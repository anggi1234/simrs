<?php

namespace PHPMaker2021\SIMRSSQLSERVERGUDANGFARMASI;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class PoInvoiceAdd extends PoInvoice
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'PO_INVOICE';

    // Page object name
    public $PageObjName = "PoInvoiceAdd";

    // Rendering View
    public $RenderingView = false;

    // Page headings
    public $Heading = "";
    public $Subheading = "";
    public $PageHeader;
    public $PageFooter;

    // Page terminated
    private $terminated = false;

    // Page heading
    public function pageHeading()
    {
        global $Language;
        if ($this->Heading != "") {
            return $this->Heading;
        }
        if (method_exists($this, "tableCaption")) {
            return $this->tableCaption();
        }
        return "";
    }

    // Page subheading
    public function pageSubheading()
    {
        global $Language;
        if ($this->Subheading != "") {
            return $this->Subheading;
        }
        if ($this->TableName) {
            return $Language->phrase($this->PageID);
        }
        return "";
    }

    // Page name
    public function pageName()
    {
        return CurrentPageName();
    }

    // Page URL
    public function pageUrl()
    {
        $url = ScriptName() . "?";
        if ($this->UseTokenInUrl) {
            $url .= "t=" . $this->TableVar . "&"; // Add page token
        }
        return $url;
    }

    // Show Page Header
    public function showPageHeader()
    {
        $header = $this->PageHeader;
        $this->pageDataRendering($header);
        if ($header != "") { // Header exists, display
            echo '<p id="ew-page-header">' . $header . '</p>';
        }
    }

    // Show Page Footer
    public function showPageFooter()
    {
        $footer = $this->PageFooter;
        $this->pageDataRendered($footer);
        if ($footer != "") { // Footer exists, display
            echo '<p id="ew-page-footer">' . $footer . '</p>';
        }
    }

    // Validate page request
    protected function isPageRequest()
    {
        global $CurrentForm;
        if ($this->UseTokenInUrl) {
            if ($CurrentForm) {
                return ($this->TableVar == $CurrentForm->getValue("t"));
            }
            if (Get("t") !== null) {
                return ($this->TableVar == Get("t"));
            }
        }
        return true;
    }

    // Constructor
    public function __construct()
    {
        global $Language, $DashboardReport, $DebugTimer;
        global $UserTable;

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("language");

        // Parent constuctor
        parent::__construct();

        // Table object (PO_INVOICE)
        if (!isset($GLOBALS["PO_INVOICE"]) || get_class($GLOBALS["PO_INVOICE"]) == PROJECT_NAMESPACE . "PO_INVOICE") {
            $GLOBALS["PO_INVOICE"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'PO_INVOICE');
        }

        // Start timer
        $DebugTimer = Container("timer");

        // Debug message
        LoadDebugMessage();

        // Open connection
        $GLOBALS["Conn"] = $GLOBALS["Conn"] ?? $this->getConnection();

        // User table object
        $UserTable = Container("usertable");
    }

    // Get content from stream
    public function getContents($stream = null): string
    {
        global $Response;
        return is_object($Response) ? $Response->getBody() : ob_get_clean();
    }

    // Is lookup
    public function isLookup()
    {
        return SameText(Route(0), Config("API_LOOKUP_ACTION"));
    }

    // Is AutoFill
    public function isAutoFill()
    {
        return $this->isLookup() && SameText(Post("ajax"), "autofill");
    }

    // Is AutoSuggest
    public function isAutoSuggest()
    {
        return $this->isLookup() && SameText(Post("ajax"), "autosuggest");
    }

    // Is modal lookup
    public function isModalLookup()
    {
        return $this->isLookup() && SameText(Post("ajax"), "modal");
    }

    // Is terminated
    public function isTerminated()
    {
        return $this->terminated;
    }

    /**
     * Terminate page
     *
     * @param string $url URL for direction
     * @return void
     */
    public function terminate($url = "")
    {
        if ($this->terminated) {
            return;
        }
        global $ExportFileName, $TempImages, $DashboardReport, $Response;

        // Page is terminated
        $this->terminated = true;

         // Page Unload event
        if (method_exists($this, "pageUnload")) {
            $this->pageUnload();
        }

        // Global Page Unloaded event (in userfn*.php)
        Page_Unloaded();

        // Export
        if ($this->CustomExport && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, Config("EXPORT_CLASSES"))) {
            $content = $this->getContents();
            if ($ExportFileName == "") {
                $ExportFileName = $this->TableVar;
            }
            $class = PROJECT_NAMESPACE . Config("EXPORT_CLASSES." . $this->CustomExport);
            if (class_exists($class)) {
                $doc = new $class(Container("PO_INVOICE"));
                $doc->Text = @$content;
                if ($this->isExport("email")) {
                    echo $this->exportEmail($doc->Text);
                } else {
                    $doc->export();
                }
                DeleteTempImages(); // Delete temp images
                return;
            }
        }
        if (!IsApi() && method_exists($this, "pageRedirecting")) {
            $this->pageRedirecting($url);
        }

        // Close connection
        CloseConnections();

        // Return for API
        if (IsApi()) {
            $res = $url === true;
            if (!$res) { // Show error
                WriteJson(array_merge(["success" => false], $this->getMessages()));
            }
            return;
        } else { // Check if response is JSON
            if (StartsString("application/json", $Response->getHeaderLine("Content-type")) && $Response->getBody()->getSize()) { // With JSON response
                $this->clearMessages();
                return;
            }
        }

        // Go to URL if specified
        if ($url != "") {
            if (!Config("DEBUG") && ob_get_length()) {
                ob_end_clean();
            }

            // Handle modal response
            if ($this->IsModal) { // Show as modal
                $row = ["url" => GetUrl($url), "modal" => "1"];
                $pageName = GetPageName($url);
                if ($pageName != $this->getListUrl()) { // Not List page
                    $row["caption"] = $this->getModalCaption($pageName);
                    if ($pageName == "PoInvoiceView") {
                        $row["view"] = "1";
                    }
                } else { // List page should not be shown as modal => error
                    $row["error"] = $this->getFailureMessage();
                    $this->clearFailureMessage();
                }
                WriteJson($row);
            } else {
                SaveDebugMessage();
                Redirect(GetUrl($url));
            }
        }
        return; // Return to controller
    }

    // Get records from recordset
    protected function getRecordsFromRecordset($rs, $current = false)
    {
        $rows = [];
        if (is_object($rs)) { // Recordset
            while ($rs && !$rs->EOF) {
                $this->loadRowValues($rs); // Set up DbValue/CurrentValue
                $row = $this->getRecordFromArray($rs->fields);
                if ($current) {
                    return $row;
                } else {
                    $rows[] = $row;
                }
                $rs->moveNext();
            }
        } elseif (is_array($rs)) {
            foreach ($rs as $ar) {
                $row = $this->getRecordFromArray($ar);
                if ($current) {
                    return $row;
                } else {
                    $rows[] = $row;
                }
            }
        }
        return $rows;
    }

    // Get record from array
    protected function getRecordFromArray($ar)
    {
        $row = [];
        if (is_array($ar)) {
            foreach ($ar as $fldname => $val) {
                if (array_key_exists($fldname, $this->Fields) && ($this->Fields[$fldname]->Visible || $this->Fields[$fldname]->IsPrimaryKey)) { // Primary key or Visible
                    $fld = &$this->Fields[$fldname];
                    if ($fld->HtmlTag == "FILE") { // Upload field
                        if (EmptyValue($val)) {
                            $row[$fldname] = null;
                        } else {
                            if ($fld->DataType == DATATYPE_BLOB) {
                                $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                    "/" . $fld->TableVar . "/" . $fld->Param . "/" . rawurlencode($this->getRecordKeyValue($ar))));
                                $row[$fldname] = ["type" => ContentType($val), "url" => $url, "name" => $fld->Param . ContentExtension($val)];
                            } elseif (!$fld->UploadMultiple || !ContainsString($val, Config("MULTIPLE_UPLOAD_SEPARATOR"))) { // Single file
                                $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                    "/" . $fld->TableVar . "/" . Encrypt($fld->physicalUploadPath() . $val)));
                                $row[$fldname] = ["type" => MimeContentType($val), "url" => $url, "name" => $val];
                            } else { // Multiple files
                                $files = explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $val);
                                $ar = [];
                                foreach ($files as $file) {
                                    $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                        "/" . $fld->TableVar . "/" . Encrypt($fld->physicalUploadPath() . $file)));
                                    if (!EmptyValue($file)) {
                                        $ar[] = ["type" => MimeContentType($file), "url" => $url, "name" => $file];
                                    }
                                }
                                $row[$fldname] = $ar;
                            }
                        }
                    } else {
                        $row[$fldname] = $val;
                    }
                }
            }
        }
        return $row;
    }

    // Get record key value from array
    protected function getRecordKeyValue($ar)
    {
        $key = "";
        if (is_array($ar)) {
            $key .= @$ar['INVOICE_ID'];
        }
        return $key;
    }

    /**
     * Hide fields for add/edit
     *
     * @return void
     */
    protected function hideFieldsForAddEdit()
    {
    }

    // Lookup data
    public function lookup()
    {
        global $Language, $Security;

        // Get lookup object
        $fieldName = Post("field");
        $lookup = $this->Fields[$fieldName]->Lookup;

        // Get lookup parameters
        $lookupType = Post("ajax", "unknown");
        $pageSize = -1;
        $offset = -1;
        $searchValue = "";
        if (SameText($lookupType, "modal")) {
            $searchValue = Post("sv", "");
            $pageSize = Post("recperpage", 10);
            $offset = Post("start", 0);
        } elseif (SameText($lookupType, "autosuggest")) {
            $searchValue = Param("q", "");
            $pageSize = Param("n", -1);
            $pageSize = is_numeric($pageSize) ? (int)$pageSize : -1;
            if ($pageSize <= 0) {
                $pageSize = Config("AUTO_SUGGEST_MAX_ENTRIES");
            }
            $start = Param("start", -1);
            $start = is_numeric($start) ? (int)$start : -1;
            $page = Param("page", -1);
            $page = is_numeric($page) ? (int)$page : -1;
            $offset = $start >= 0 ? $start : ($page > 0 && $pageSize > 0 ? ($page - 1) * $pageSize : 0);
        }
        $userSelect = Decrypt(Post("s", ""));
        $userFilter = Decrypt(Post("f", ""));
        $userOrderBy = Decrypt(Post("o", ""));
        $keys = Post("keys");
        $lookup->LookupType = $lookupType; // Lookup type
        if ($keys !== null) { // Selected records from modal
            if (is_array($keys)) {
                $keys = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $keys);
            }
            $lookup->FilterFields = []; // Skip parent fields if any
            $lookup->FilterValues[] = $keys; // Lookup values
            $pageSize = -1; // Show all records
        } else { // Lookup values
            $lookup->FilterValues[] = Post("v0", Post("lookupValue", ""));
        }
        $cnt = is_array($lookup->FilterFields) ? count($lookup->FilterFields) : 0;
        for ($i = 1; $i <= $cnt; $i++) {
            $lookup->FilterValues[] = Post("v" . $i, "");
        }
        $lookup->SearchValue = $searchValue;
        $lookup->PageSize = $pageSize;
        $lookup->Offset = $offset;
        if ($userSelect != "") {
            $lookup->UserSelect = $userSelect;
        }
        if ($userFilter != "") {
            $lookup->UserFilter = $userFilter;
        }
        if ($userOrderBy != "") {
            $lookup->UserOrderBy = $userOrderBy;
        }
        $lookup->toJson($this); // Use settings from current page
    }
    public $FormClassName = "ew-horizontal ew-form ew-add-form";
    public $IsModal = false;
    public $IsMobileOrModal = false;
    public $DbMasterFilter = "";
    public $DbDetailFilter = "";
    public $StartRecord;
    public $Priv = 0;
    public $OldRecordset;
    public $CopyRecord;

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $CustomExportType, $ExportFileName, $UserProfile, $Language, $Security, $CurrentForm,
            $SkipHeaderFooter;

        // Is modal
        $this->IsModal = Param("modal") == "1";

        // Create form object
        $CurrentForm = new HttpForm();
        $this->CurrentAction = Param("action"); // Set up current action
        $this->ORG_UNIT_CODE->setVisibility();
        $this->INVOICE_ID->setVisibility();
        $this->INVOICE_ID2->setVisibility();
        $this->INVOICE_DATE->setVisibility();
        $this->PO->setVisibility();
        $this->COMPANY_ID->setVisibility();
        $this->RECEIVED_DATE->setVisibility();
        $this->AMOUNT->setVisibility();
        $this->PAYMENT_DUE->setVisibility();
        $this->DESCRIPTION->setVisibility();
        $this->MODIFIED_DATE->setVisibility();
        $this->MODIFIED_BY->setVisibility();
        $this->RECEIVED_BY->setVisibility();
        $this->PRIORITY->setVisibility();
        $this->CREDIT_NOTE->setVisibility();
        $this->CREDIT_AMOUNT->setVisibility();
        $this->PPN->setVisibility();
        $this->MATERAI->setVisibility();
        $this->SENT_BY->setVisibility();
        $this->ACCOUNT_ID->setVisibility();
        $this->FINANCE_ID->setVisibility();
        $this->potongan->setVisibility();
        $this->RECEIVED_VALUE->setVisibility();
        $this->NO_ORDER->setVisibility();
        $this->CONTRACT_NO->setVisibility();
        $this->ORG_ID->setVisibility();
        $this->CLINIC_ID->setVisibility();
        $this->PPN_VALUE->setVisibility();
        $this->DISCOUNT_VALUE->setVisibility();
        $this->PAID_VALUE->setVisibility();
        $this->ISCETAK->setVisibility();
        $this->PRINT_DATE->setVisibility();
        $this->PRINTED_BY->setVisibility();
        $this->PRINTQ->setVisibility();
        $this->FAKTUR_DATE->setVisibility();
        $this->DISTRIBUTION_TYPE->setVisibility();
        $this->DISCOUNTOFF_VALUE->setVisibility();
        $this->THECOUNTER->setVisibility();
        $this->FUND_ID->setVisibility();
        $this->ORDER_BY->setVisibility();
        $this->ACKNOWLEDGEBY->setVisibility();
        $this->NUM->setVisibility();
        $this->ISPO->setVisibility();
        $this->DOCS_TYPE->setVisibility();
        $this->PO_DATE->setVisibility();
        $this->PO_VALUE->setVisibility();
        $this->hideFieldsForAddEdit();

        // Do not use lookup cache
        $this->setUseLookupCache(false);

        // Global Page Loading event (in userfn*.php)
        Page_Loading();

        // Page Load event
        if (method_exists($this, "pageLoad")) {
            $this->pageLoad();
        }

        // Set up lookup cache

        // Check modal
        if ($this->IsModal) {
            $SkipHeaderFooter = true;
        }
        $this->IsMobileOrModal = IsMobile() || $this->IsModal;
        $this->FormClassName = "ew-form ew-add-form ew-horizontal";
        $postBack = false;

        // Set up current action
        if (IsApi()) {
            $this->CurrentAction = "insert"; // Add record directly
            $postBack = true;
        } elseif (Post("action") !== null) {
            $this->CurrentAction = Post("action"); // Get form action
            $this->setKey(Post($this->OldKeyName));
            $postBack = true;
        } else {
            // Load key values from QueryString
            if (($keyValue = Get("INVOICE_ID") ?? Route("INVOICE_ID")) !== null) {
                $this->INVOICE_ID->setQueryStringValue($keyValue);
            }
            $this->OldKey = $this->getKey(true); // Get from CurrentValue
            $this->CopyRecord = !EmptyValue($this->OldKey);
            if ($this->CopyRecord) {
                $this->CurrentAction = "copy"; // Copy record
            } else {
                $this->CurrentAction = "show"; // Display blank record
            }
        }

        // Load old record / default values
        $loaded = $this->loadOldRecord();

        // Load form values
        if ($postBack) {
            $this->loadFormValues(); // Load form values
        }

        // Validate form if post back
        if ($postBack) {
            if (!$this->validateForm()) {
                $this->EventCancelled = true; // Event cancelled
                $this->restoreFormValues(); // Restore form values
                if (IsApi()) {
                    $this->terminate();
                    return;
                } else {
                    $this->CurrentAction = "show"; // Form error, reset action
                }
            }
        }

        // Perform current action
        switch ($this->CurrentAction) {
            case "copy": // Copy an existing record
                if (!$loaded) { // Record not loaded
                    if ($this->getFailureMessage() == "") {
                        $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
                    }
                    $this->terminate("PoInvoiceList"); // No matching record, return to list
                    return;
                }
                break;
            case "insert": // Add new record
                $this->SendEmail = true; // Send email on add success
                if ($this->addRow($this->OldRecordset)) { // Add successful
                    if ($this->getSuccessMessage() == "" && Post("addopt") != "1") { // Skip success message for addopt (done in JavaScript)
                        $this->setSuccessMessage($Language->phrase("AddSuccess")); // Set up success message
                    }
                    $returnUrl = $this->getReturnUrl();
                    if (GetPageName($returnUrl) == "PoInvoiceList") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "PoInvoiceView") {
                        $returnUrl = $this->getViewUrl(); // View page, return to View page with keyurl directly
                    }
                    if (IsApi()) { // Return to caller
                        $this->terminate(true);
                        return;
                    } else {
                        $this->terminate($returnUrl);
                        return;
                    }
                } elseif (IsApi()) { // API request, return
                    $this->terminate();
                    return;
                } else {
                    $this->EventCancelled = true; // Event cancelled
                    $this->restoreFormValues(); // Add failed, restore form values
                }
        }

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Render row based on row type
        $this->RowType = ROWTYPE_ADD; // Render add type

        // Render row
        $this->resetAttributes();
        $this->renderRow();

        // Set LoginStatus / Page_Rendering / Page_Render
        if (!IsApi() && !$this->isTerminated()) {
            // Pass table and field properties to client side
            $this->toClientVar(["tableCaption"], ["caption", "Visible", "Required", "IsInvalid", "Raw"]);

            // Setup login status
            SetupLoginStatus();

            // Pass login status to client side
            SetClientVar("login", LoginStatus());

            // Global Page Rendering event (in userfn*.php)
            Page_Rendering();

            // Page Render event
            if (method_exists($this, "pageRender")) {
                $this->pageRender();
            }
        }
    }

    // Get upload files
    protected function getUploadFiles()
    {
        global $CurrentForm, $Language;
    }

    // Load default values
    protected function loadDefaultValues()
    {
        $this->ORG_UNIT_CODE->CurrentValue = null;
        $this->ORG_UNIT_CODE->OldValue = $this->ORG_UNIT_CODE->CurrentValue;
        $this->INVOICE_ID->CurrentValue = "(((CONVERT([varchar](4),datepart(year,getdate()),(0))+right(CONVERT([varchar](4),datepart(month,getdate())+(100),(0)),(2)))+right(CONVERT([varchar](3),datepart(day,getdate())+(100),(0)),(2)))+right(CONVERT([varchar](3),datepart(hour,getdate())+(100),(0)),(2)))+right(CONVERT([varchar](3),datepart(minute,getdate())+(100),(0)),(2)))+right(CONVERT([varchar](3),datepart(second,getdate())+(100),(0)),(2)))+left(newid(),(7";
        $this->INVOICE_ID2->CurrentValue = null;
        $this->INVOICE_ID2->OldValue = $this->INVOICE_ID2->CurrentValue;
        $this->INVOICE_DATE->CurrentValue = null;
        $this->INVOICE_DATE->OldValue = $this->INVOICE_DATE->CurrentValue;
        $this->PO->CurrentValue = null;
        $this->PO->OldValue = $this->PO->CurrentValue;
        $this->COMPANY_ID->CurrentValue = null;
        $this->COMPANY_ID->OldValue = $this->COMPANY_ID->CurrentValue;
        $this->RECEIVED_DATE->CurrentValue = null;
        $this->RECEIVED_DATE->OldValue = $this->RECEIVED_DATE->CurrentValue;
        $this->AMOUNT->CurrentValue = null;
        $this->AMOUNT->OldValue = $this->AMOUNT->CurrentValue;
        $this->PAYMENT_DUE->CurrentValue = null;
        $this->PAYMENT_DUE->OldValue = $this->PAYMENT_DUE->CurrentValue;
        $this->DESCRIPTION->CurrentValue = null;
        $this->DESCRIPTION->OldValue = $this->DESCRIPTION->CurrentValue;
        $this->MODIFIED_DATE->CurrentValue = null;
        $this->MODIFIED_DATE->OldValue = $this->MODIFIED_DATE->CurrentValue;
        $this->MODIFIED_BY->CurrentValue = null;
        $this->MODIFIED_BY->OldValue = $this->MODIFIED_BY->CurrentValue;
        $this->RECEIVED_BY->CurrentValue = null;
        $this->RECEIVED_BY->OldValue = $this->RECEIVED_BY->CurrentValue;
        $this->PRIORITY->CurrentValue = null;
        $this->PRIORITY->OldValue = $this->PRIORITY->CurrentValue;
        $this->CREDIT_NOTE->CurrentValue = null;
        $this->CREDIT_NOTE->OldValue = $this->CREDIT_NOTE->CurrentValue;
        $this->CREDIT_AMOUNT->CurrentValue = null;
        $this->CREDIT_AMOUNT->OldValue = $this->CREDIT_AMOUNT->CurrentValue;
        $this->PPN->CurrentValue = null;
        $this->PPN->OldValue = $this->PPN->CurrentValue;
        $this->MATERAI->CurrentValue = null;
        $this->MATERAI->OldValue = $this->MATERAI->CurrentValue;
        $this->SENT_BY->CurrentValue = null;
        $this->SENT_BY->OldValue = $this->SENT_BY->CurrentValue;
        $this->ACCOUNT_ID->CurrentValue = null;
        $this->ACCOUNT_ID->OldValue = $this->ACCOUNT_ID->CurrentValue;
        $this->FINANCE_ID->CurrentValue = null;
        $this->FINANCE_ID->OldValue = $this->FINANCE_ID->CurrentValue;
        $this->potongan->CurrentValue = null;
        $this->potongan->OldValue = $this->potongan->CurrentValue;
        $this->RECEIVED_VALUE->CurrentValue = null;
        $this->RECEIVED_VALUE->OldValue = $this->RECEIVED_VALUE->CurrentValue;
        $this->NO_ORDER->CurrentValue = null;
        $this->NO_ORDER->OldValue = $this->NO_ORDER->CurrentValue;
        $this->CONTRACT_NO->CurrentValue = null;
        $this->CONTRACT_NO->OldValue = $this->CONTRACT_NO->CurrentValue;
        $this->ORG_ID->CurrentValue = null;
        $this->ORG_ID->OldValue = $this->ORG_ID->CurrentValue;
        $this->CLINIC_ID->CurrentValue = null;
        $this->CLINIC_ID->OldValue = $this->CLINIC_ID->CurrentValue;
        $this->PPN_VALUE->CurrentValue = null;
        $this->PPN_VALUE->OldValue = $this->PPN_VALUE->CurrentValue;
        $this->DISCOUNT_VALUE->CurrentValue = null;
        $this->DISCOUNT_VALUE->OldValue = $this->DISCOUNT_VALUE->CurrentValue;
        $this->PAID_VALUE->CurrentValue = null;
        $this->PAID_VALUE->OldValue = $this->PAID_VALUE->CurrentValue;
        $this->ISCETAK->CurrentValue = null;
        $this->ISCETAK->OldValue = $this->ISCETAK->CurrentValue;
        $this->PRINT_DATE->CurrentValue = null;
        $this->PRINT_DATE->OldValue = $this->PRINT_DATE->CurrentValue;
        $this->PRINTED_BY->CurrentValue = null;
        $this->PRINTED_BY->OldValue = $this->PRINTED_BY->CurrentValue;
        $this->PRINTQ->CurrentValue = null;
        $this->PRINTQ->OldValue = $this->PRINTQ->CurrentValue;
        $this->FAKTUR_DATE->CurrentValue = null;
        $this->FAKTUR_DATE->OldValue = $this->FAKTUR_DATE->CurrentValue;
        $this->DISTRIBUTION_TYPE->CurrentValue = null;
        $this->DISTRIBUTION_TYPE->OldValue = $this->DISTRIBUTION_TYPE->CurrentValue;
        $this->DISCOUNTOFF_VALUE->CurrentValue = null;
        $this->DISCOUNTOFF_VALUE->OldValue = $this->DISCOUNTOFF_VALUE->CurrentValue;
        $this->THECOUNTER->CurrentValue = null;
        $this->THECOUNTER->OldValue = $this->THECOUNTER->CurrentValue;
        $this->FUND_ID->CurrentValue = null;
        $this->FUND_ID->OldValue = $this->FUND_ID->CurrentValue;
        $this->ORDER_BY->CurrentValue = null;
        $this->ORDER_BY->OldValue = $this->ORDER_BY->CurrentValue;
        $this->ACKNOWLEDGEBY->CurrentValue = null;
        $this->ACKNOWLEDGEBY->OldValue = $this->ACKNOWLEDGEBY->CurrentValue;
        $this->NUM->CurrentValue = null;
        $this->NUM->OldValue = $this->NUM->CurrentValue;
        $this->ISPO->CurrentValue = null;
        $this->ISPO->OldValue = $this->ISPO->CurrentValue;
        $this->DOCS_TYPE->CurrentValue = null;
        $this->DOCS_TYPE->OldValue = $this->DOCS_TYPE->CurrentValue;
        $this->PO_DATE->CurrentValue = null;
        $this->PO_DATE->OldValue = $this->PO_DATE->CurrentValue;
        $this->PO_VALUE->CurrentValue = 0;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;

        // Check field name 'ORG_UNIT_CODE' first before field var 'x_ORG_UNIT_CODE'
        $val = $CurrentForm->hasValue("ORG_UNIT_CODE") ? $CurrentForm->getValue("ORG_UNIT_CODE") : $CurrentForm->getValue("x_ORG_UNIT_CODE");
        if (!$this->ORG_UNIT_CODE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ORG_UNIT_CODE->Visible = false; // Disable update for API request
            } else {
                $this->ORG_UNIT_CODE->setFormValue($val);
            }
        }

        // Check field name 'INVOICE_ID' first before field var 'x_INVOICE_ID'
        $val = $CurrentForm->hasValue("INVOICE_ID") ? $CurrentForm->getValue("INVOICE_ID") : $CurrentForm->getValue("x_INVOICE_ID");
        if (!$this->INVOICE_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->INVOICE_ID->Visible = false; // Disable update for API request
            } else {
                $this->INVOICE_ID->setFormValue($val);
            }
        }

        // Check field name 'INVOICE_ID2' first before field var 'x_INVOICE_ID2'
        $val = $CurrentForm->hasValue("INVOICE_ID2") ? $CurrentForm->getValue("INVOICE_ID2") : $CurrentForm->getValue("x_INVOICE_ID2");
        if (!$this->INVOICE_ID2->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->INVOICE_ID2->Visible = false; // Disable update for API request
            } else {
                $this->INVOICE_ID2->setFormValue($val);
            }
        }

        // Check field name 'INVOICE_DATE' first before field var 'x_INVOICE_DATE'
        $val = $CurrentForm->hasValue("INVOICE_DATE") ? $CurrentForm->getValue("INVOICE_DATE") : $CurrentForm->getValue("x_INVOICE_DATE");
        if (!$this->INVOICE_DATE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->INVOICE_DATE->Visible = false; // Disable update for API request
            } else {
                $this->INVOICE_DATE->setFormValue($val);
            }
            $this->INVOICE_DATE->CurrentValue = UnFormatDateTime($this->INVOICE_DATE->CurrentValue, 0);
        }

        // Check field name 'PO' first before field var 'x_PO'
        $val = $CurrentForm->hasValue("PO") ? $CurrentForm->getValue("PO") : $CurrentForm->getValue("x_PO");
        if (!$this->PO->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->PO->Visible = false; // Disable update for API request
            } else {
                $this->PO->setFormValue($val);
            }
        }

        // Check field name 'COMPANY_ID' first before field var 'x_COMPANY_ID'
        $val = $CurrentForm->hasValue("COMPANY_ID") ? $CurrentForm->getValue("COMPANY_ID") : $CurrentForm->getValue("x_COMPANY_ID");
        if (!$this->COMPANY_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->COMPANY_ID->Visible = false; // Disable update for API request
            } else {
                $this->COMPANY_ID->setFormValue($val);
            }
        }

        // Check field name 'RECEIVED_DATE' first before field var 'x_RECEIVED_DATE'
        $val = $CurrentForm->hasValue("RECEIVED_DATE") ? $CurrentForm->getValue("RECEIVED_DATE") : $CurrentForm->getValue("x_RECEIVED_DATE");
        if (!$this->RECEIVED_DATE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->RECEIVED_DATE->Visible = false; // Disable update for API request
            } else {
                $this->RECEIVED_DATE->setFormValue($val);
            }
            $this->RECEIVED_DATE->CurrentValue = UnFormatDateTime($this->RECEIVED_DATE->CurrentValue, 0);
        }

        // Check field name 'AMOUNT' first before field var 'x_AMOUNT'
        $val = $CurrentForm->hasValue("AMOUNT") ? $CurrentForm->getValue("AMOUNT") : $CurrentForm->getValue("x_AMOUNT");
        if (!$this->AMOUNT->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->AMOUNT->Visible = false; // Disable update for API request
            } else {
                $this->AMOUNT->setFormValue($val);
            }
        }

        // Check field name 'PAYMENT_DUE' first before field var 'x_PAYMENT_DUE'
        $val = $CurrentForm->hasValue("PAYMENT_DUE") ? $CurrentForm->getValue("PAYMENT_DUE") : $CurrentForm->getValue("x_PAYMENT_DUE");
        if (!$this->PAYMENT_DUE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->PAYMENT_DUE->Visible = false; // Disable update for API request
            } else {
                $this->PAYMENT_DUE->setFormValue($val);
            }
            $this->PAYMENT_DUE->CurrentValue = UnFormatDateTime($this->PAYMENT_DUE->CurrentValue, 0);
        }

        // Check field name 'DESCRIPTION' first before field var 'x_DESCRIPTION'
        $val = $CurrentForm->hasValue("DESCRIPTION") ? $CurrentForm->getValue("DESCRIPTION") : $CurrentForm->getValue("x_DESCRIPTION");
        if (!$this->DESCRIPTION->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->DESCRIPTION->Visible = false; // Disable update for API request
            } else {
                $this->DESCRIPTION->setFormValue($val);
            }
        }

        // Check field name 'MODIFIED_DATE' first before field var 'x_MODIFIED_DATE'
        $val = $CurrentForm->hasValue("MODIFIED_DATE") ? $CurrentForm->getValue("MODIFIED_DATE") : $CurrentForm->getValue("x_MODIFIED_DATE");
        if (!$this->MODIFIED_DATE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->MODIFIED_DATE->Visible = false; // Disable update for API request
            } else {
                $this->MODIFIED_DATE->setFormValue($val);
            }
            $this->MODIFIED_DATE->CurrentValue = UnFormatDateTime($this->MODIFIED_DATE->CurrentValue, 0);
        }

        // Check field name 'MODIFIED_BY' first before field var 'x_MODIFIED_BY'
        $val = $CurrentForm->hasValue("MODIFIED_BY") ? $CurrentForm->getValue("MODIFIED_BY") : $CurrentForm->getValue("x_MODIFIED_BY");
        if (!$this->MODIFIED_BY->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->MODIFIED_BY->Visible = false; // Disable update for API request
            } else {
                $this->MODIFIED_BY->setFormValue($val);
            }
        }

        // Check field name 'RECEIVED_BY' first before field var 'x_RECEIVED_BY'
        $val = $CurrentForm->hasValue("RECEIVED_BY") ? $CurrentForm->getValue("RECEIVED_BY") : $CurrentForm->getValue("x_RECEIVED_BY");
        if (!$this->RECEIVED_BY->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->RECEIVED_BY->Visible = false; // Disable update for API request
            } else {
                $this->RECEIVED_BY->setFormValue($val);
            }
        }

        // Check field name 'PRIORITY' first before field var 'x_PRIORITY'
        $val = $CurrentForm->hasValue("PRIORITY") ? $CurrentForm->getValue("PRIORITY") : $CurrentForm->getValue("x_PRIORITY");
        if (!$this->PRIORITY->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->PRIORITY->Visible = false; // Disable update for API request
            } else {
                $this->PRIORITY->setFormValue($val);
            }
        }

        // Check field name 'CREDIT_NOTE' first before field var 'x_CREDIT_NOTE'
        $val = $CurrentForm->hasValue("CREDIT_NOTE") ? $CurrentForm->getValue("CREDIT_NOTE") : $CurrentForm->getValue("x_CREDIT_NOTE");
        if (!$this->CREDIT_NOTE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->CREDIT_NOTE->Visible = false; // Disable update for API request
            } else {
                $this->CREDIT_NOTE->setFormValue($val);
            }
        }

        // Check field name 'CREDIT_AMOUNT' first before field var 'x_CREDIT_AMOUNT'
        $val = $CurrentForm->hasValue("CREDIT_AMOUNT") ? $CurrentForm->getValue("CREDIT_AMOUNT") : $CurrentForm->getValue("x_CREDIT_AMOUNT");
        if (!$this->CREDIT_AMOUNT->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->CREDIT_AMOUNT->Visible = false; // Disable update for API request
            } else {
                $this->CREDIT_AMOUNT->setFormValue($val);
            }
        }

        // Check field name 'PPN' first before field var 'x_PPN'
        $val = $CurrentForm->hasValue("PPN") ? $CurrentForm->getValue("PPN") : $CurrentForm->getValue("x_PPN");
        if (!$this->PPN->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->PPN->Visible = false; // Disable update for API request
            } else {
                $this->PPN->setFormValue($val);
            }
        }

        // Check field name 'MATERAI' first before field var 'x_MATERAI'
        $val = $CurrentForm->hasValue("MATERAI") ? $CurrentForm->getValue("MATERAI") : $CurrentForm->getValue("x_MATERAI");
        if (!$this->MATERAI->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->MATERAI->Visible = false; // Disable update for API request
            } else {
                $this->MATERAI->setFormValue($val);
            }
        }

        // Check field name 'SENT_BY' first before field var 'x_SENT_BY'
        $val = $CurrentForm->hasValue("SENT_BY") ? $CurrentForm->getValue("SENT_BY") : $CurrentForm->getValue("x_SENT_BY");
        if (!$this->SENT_BY->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->SENT_BY->Visible = false; // Disable update for API request
            } else {
                $this->SENT_BY->setFormValue($val);
            }
        }

        // Check field name 'ACCOUNT_ID' first before field var 'x_ACCOUNT_ID'
        $val = $CurrentForm->hasValue("ACCOUNT_ID") ? $CurrentForm->getValue("ACCOUNT_ID") : $CurrentForm->getValue("x_ACCOUNT_ID");
        if (!$this->ACCOUNT_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ACCOUNT_ID->Visible = false; // Disable update for API request
            } else {
                $this->ACCOUNT_ID->setFormValue($val);
            }
        }

        // Check field name 'FINANCE_ID' first before field var 'x_FINANCE_ID'
        $val = $CurrentForm->hasValue("FINANCE_ID") ? $CurrentForm->getValue("FINANCE_ID") : $CurrentForm->getValue("x_FINANCE_ID");
        if (!$this->FINANCE_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->FINANCE_ID->Visible = false; // Disable update for API request
            } else {
                $this->FINANCE_ID->setFormValue($val);
            }
        }

        // Check field name 'potongan' first before field var 'x_potongan'
        $val = $CurrentForm->hasValue("potongan") ? $CurrentForm->getValue("potongan") : $CurrentForm->getValue("x_potongan");
        if (!$this->potongan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->potongan->Visible = false; // Disable update for API request
            } else {
                $this->potongan->setFormValue($val);
            }
        }

        // Check field name 'RECEIVED_VALUE' first before field var 'x_RECEIVED_VALUE'
        $val = $CurrentForm->hasValue("RECEIVED_VALUE") ? $CurrentForm->getValue("RECEIVED_VALUE") : $CurrentForm->getValue("x_RECEIVED_VALUE");
        if (!$this->RECEIVED_VALUE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->RECEIVED_VALUE->Visible = false; // Disable update for API request
            } else {
                $this->RECEIVED_VALUE->setFormValue($val);
            }
        }

        // Check field name 'NO_ORDER' first before field var 'x_NO_ORDER'
        $val = $CurrentForm->hasValue("NO_ORDER") ? $CurrentForm->getValue("NO_ORDER") : $CurrentForm->getValue("x_NO_ORDER");
        if (!$this->NO_ORDER->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->NO_ORDER->Visible = false; // Disable update for API request
            } else {
                $this->NO_ORDER->setFormValue($val);
            }
        }

        // Check field name 'CONTRACT_NO' first before field var 'x_CONTRACT_NO'
        $val = $CurrentForm->hasValue("CONTRACT_NO") ? $CurrentForm->getValue("CONTRACT_NO") : $CurrentForm->getValue("x_CONTRACT_NO");
        if (!$this->CONTRACT_NO->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->CONTRACT_NO->Visible = false; // Disable update for API request
            } else {
                $this->CONTRACT_NO->setFormValue($val);
            }
        }

        // Check field name 'ORG_ID' first before field var 'x_ORG_ID'
        $val = $CurrentForm->hasValue("ORG_ID") ? $CurrentForm->getValue("ORG_ID") : $CurrentForm->getValue("x_ORG_ID");
        if (!$this->ORG_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ORG_ID->Visible = false; // Disable update for API request
            } else {
                $this->ORG_ID->setFormValue($val);
            }
        }

        // Check field name 'CLINIC_ID' first before field var 'x_CLINIC_ID'
        $val = $CurrentForm->hasValue("CLINIC_ID") ? $CurrentForm->getValue("CLINIC_ID") : $CurrentForm->getValue("x_CLINIC_ID");
        if (!$this->CLINIC_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->CLINIC_ID->Visible = false; // Disable update for API request
            } else {
                $this->CLINIC_ID->setFormValue($val);
            }
        }

        // Check field name 'PPN_VALUE' first before field var 'x_PPN_VALUE'
        $val = $CurrentForm->hasValue("PPN_VALUE") ? $CurrentForm->getValue("PPN_VALUE") : $CurrentForm->getValue("x_PPN_VALUE");
        if (!$this->PPN_VALUE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->PPN_VALUE->Visible = false; // Disable update for API request
            } else {
                $this->PPN_VALUE->setFormValue($val);
            }
        }

        // Check field name 'DISCOUNT_VALUE' first before field var 'x_DISCOUNT_VALUE'
        $val = $CurrentForm->hasValue("DISCOUNT_VALUE") ? $CurrentForm->getValue("DISCOUNT_VALUE") : $CurrentForm->getValue("x_DISCOUNT_VALUE");
        if (!$this->DISCOUNT_VALUE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->DISCOUNT_VALUE->Visible = false; // Disable update for API request
            } else {
                $this->DISCOUNT_VALUE->setFormValue($val);
            }
        }

        // Check field name 'PAID_VALUE' first before field var 'x_PAID_VALUE'
        $val = $CurrentForm->hasValue("PAID_VALUE") ? $CurrentForm->getValue("PAID_VALUE") : $CurrentForm->getValue("x_PAID_VALUE");
        if (!$this->PAID_VALUE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->PAID_VALUE->Visible = false; // Disable update for API request
            } else {
                $this->PAID_VALUE->setFormValue($val);
            }
        }

        // Check field name 'ISCETAK' first before field var 'x_ISCETAK'
        $val = $CurrentForm->hasValue("ISCETAK") ? $CurrentForm->getValue("ISCETAK") : $CurrentForm->getValue("x_ISCETAK");
        if (!$this->ISCETAK->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ISCETAK->Visible = false; // Disable update for API request
            } else {
                $this->ISCETAK->setFormValue($val);
            }
        }

        // Check field name 'PRINT_DATE' first before field var 'x_PRINT_DATE'
        $val = $CurrentForm->hasValue("PRINT_DATE") ? $CurrentForm->getValue("PRINT_DATE") : $CurrentForm->getValue("x_PRINT_DATE");
        if (!$this->PRINT_DATE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->PRINT_DATE->Visible = false; // Disable update for API request
            } else {
                $this->PRINT_DATE->setFormValue($val);
            }
            $this->PRINT_DATE->CurrentValue = UnFormatDateTime($this->PRINT_DATE->CurrentValue, 0);
        }

        // Check field name 'PRINTED_BY' first before field var 'x_PRINTED_BY'
        $val = $CurrentForm->hasValue("PRINTED_BY") ? $CurrentForm->getValue("PRINTED_BY") : $CurrentForm->getValue("x_PRINTED_BY");
        if (!$this->PRINTED_BY->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->PRINTED_BY->Visible = false; // Disable update for API request
            } else {
                $this->PRINTED_BY->setFormValue($val);
            }
        }

        // Check field name 'PRINTQ' first before field var 'x_PRINTQ'
        $val = $CurrentForm->hasValue("PRINTQ") ? $CurrentForm->getValue("PRINTQ") : $CurrentForm->getValue("x_PRINTQ");
        if (!$this->PRINTQ->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->PRINTQ->Visible = false; // Disable update for API request
            } else {
                $this->PRINTQ->setFormValue($val);
            }
        }

        // Check field name 'FAKTUR_DATE' first before field var 'x_FAKTUR_DATE'
        $val = $CurrentForm->hasValue("FAKTUR_DATE") ? $CurrentForm->getValue("FAKTUR_DATE") : $CurrentForm->getValue("x_FAKTUR_DATE");
        if (!$this->FAKTUR_DATE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->FAKTUR_DATE->Visible = false; // Disable update for API request
            } else {
                $this->FAKTUR_DATE->setFormValue($val);
            }
            $this->FAKTUR_DATE->CurrentValue = UnFormatDateTime($this->FAKTUR_DATE->CurrentValue, 0);
        }

        // Check field name 'DISTRIBUTION_TYPE' first before field var 'x_DISTRIBUTION_TYPE'
        $val = $CurrentForm->hasValue("DISTRIBUTION_TYPE") ? $CurrentForm->getValue("DISTRIBUTION_TYPE") : $CurrentForm->getValue("x_DISTRIBUTION_TYPE");
        if (!$this->DISTRIBUTION_TYPE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->DISTRIBUTION_TYPE->Visible = false; // Disable update for API request
            } else {
                $this->DISTRIBUTION_TYPE->setFormValue($val);
            }
        }

        // Check field name 'DISCOUNTOFF_VALUE' first before field var 'x_DISCOUNTOFF_VALUE'
        $val = $CurrentForm->hasValue("DISCOUNTOFF_VALUE") ? $CurrentForm->getValue("DISCOUNTOFF_VALUE") : $CurrentForm->getValue("x_DISCOUNTOFF_VALUE");
        if (!$this->DISCOUNTOFF_VALUE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->DISCOUNTOFF_VALUE->Visible = false; // Disable update for API request
            } else {
                $this->DISCOUNTOFF_VALUE->setFormValue($val);
            }
        }

        // Check field name 'THECOUNTER' first before field var 'x_THECOUNTER'
        $val = $CurrentForm->hasValue("THECOUNTER") ? $CurrentForm->getValue("THECOUNTER") : $CurrentForm->getValue("x_THECOUNTER");
        if (!$this->THECOUNTER->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->THECOUNTER->Visible = false; // Disable update for API request
            } else {
                $this->THECOUNTER->setFormValue($val);
            }
        }

        // Check field name 'FUND_ID' first before field var 'x_FUND_ID'
        $val = $CurrentForm->hasValue("FUND_ID") ? $CurrentForm->getValue("FUND_ID") : $CurrentForm->getValue("x_FUND_ID");
        if (!$this->FUND_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->FUND_ID->Visible = false; // Disable update for API request
            } else {
                $this->FUND_ID->setFormValue($val);
            }
        }

        // Check field name 'ORDER_BY' first before field var 'x_ORDER_BY'
        $val = $CurrentForm->hasValue("ORDER_BY") ? $CurrentForm->getValue("ORDER_BY") : $CurrentForm->getValue("x_ORDER_BY");
        if (!$this->ORDER_BY->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ORDER_BY->Visible = false; // Disable update for API request
            } else {
                $this->ORDER_BY->setFormValue($val);
            }
        }

        // Check field name 'ACKNOWLEDGEBY' first before field var 'x_ACKNOWLEDGEBY'
        $val = $CurrentForm->hasValue("ACKNOWLEDGEBY") ? $CurrentForm->getValue("ACKNOWLEDGEBY") : $CurrentForm->getValue("x_ACKNOWLEDGEBY");
        if (!$this->ACKNOWLEDGEBY->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ACKNOWLEDGEBY->Visible = false; // Disable update for API request
            } else {
                $this->ACKNOWLEDGEBY->setFormValue($val);
            }
        }

        // Check field name 'NUM' first before field var 'x_NUM'
        $val = $CurrentForm->hasValue("NUM") ? $CurrentForm->getValue("NUM") : $CurrentForm->getValue("x_NUM");
        if (!$this->NUM->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->NUM->Visible = false; // Disable update for API request
            } else {
                $this->NUM->setFormValue($val);
            }
        }

        // Check field name 'ISPO' first before field var 'x_ISPO'
        $val = $CurrentForm->hasValue("ISPO") ? $CurrentForm->getValue("ISPO") : $CurrentForm->getValue("x_ISPO");
        if (!$this->ISPO->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ISPO->Visible = false; // Disable update for API request
            } else {
                $this->ISPO->setFormValue($val);
            }
        }

        // Check field name 'DOCS_TYPE' first before field var 'x_DOCS_TYPE'
        $val = $CurrentForm->hasValue("DOCS_TYPE") ? $CurrentForm->getValue("DOCS_TYPE") : $CurrentForm->getValue("x_DOCS_TYPE");
        if (!$this->DOCS_TYPE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->DOCS_TYPE->Visible = false; // Disable update for API request
            } else {
                $this->DOCS_TYPE->setFormValue($val);
            }
        }

        // Check field name 'PO_DATE' first before field var 'x_PO_DATE'
        $val = $CurrentForm->hasValue("PO_DATE") ? $CurrentForm->getValue("PO_DATE") : $CurrentForm->getValue("x_PO_DATE");
        if (!$this->PO_DATE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->PO_DATE->Visible = false; // Disable update for API request
            } else {
                $this->PO_DATE->setFormValue($val);
            }
            $this->PO_DATE->CurrentValue = UnFormatDateTime($this->PO_DATE->CurrentValue, 0);
        }

        // Check field name 'PO_VALUE' first before field var 'x_PO_VALUE'
        $val = $CurrentForm->hasValue("PO_VALUE") ? $CurrentForm->getValue("PO_VALUE") : $CurrentForm->getValue("x_PO_VALUE");
        if (!$this->PO_VALUE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->PO_VALUE->Visible = false; // Disable update for API request
            } else {
                $this->PO_VALUE->setFormValue($val);
            }
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->ORG_UNIT_CODE->CurrentValue = $this->ORG_UNIT_CODE->FormValue;
        $this->INVOICE_ID->CurrentValue = $this->INVOICE_ID->FormValue;
        $this->INVOICE_ID2->CurrentValue = $this->INVOICE_ID2->FormValue;
        $this->INVOICE_DATE->CurrentValue = $this->INVOICE_DATE->FormValue;
        $this->INVOICE_DATE->CurrentValue = UnFormatDateTime($this->INVOICE_DATE->CurrentValue, 0);
        $this->PO->CurrentValue = $this->PO->FormValue;
        $this->COMPANY_ID->CurrentValue = $this->COMPANY_ID->FormValue;
        $this->RECEIVED_DATE->CurrentValue = $this->RECEIVED_DATE->FormValue;
        $this->RECEIVED_DATE->CurrentValue = UnFormatDateTime($this->RECEIVED_DATE->CurrentValue, 0);
        $this->AMOUNT->CurrentValue = $this->AMOUNT->FormValue;
        $this->PAYMENT_DUE->CurrentValue = $this->PAYMENT_DUE->FormValue;
        $this->PAYMENT_DUE->CurrentValue = UnFormatDateTime($this->PAYMENT_DUE->CurrentValue, 0);
        $this->DESCRIPTION->CurrentValue = $this->DESCRIPTION->FormValue;
        $this->MODIFIED_DATE->CurrentValue = $this->MODIFIED_DATE->FormValue;
        $this->MODIFIED_DATE->CurrentValue = UnFormatDateTime($this->MODIFIED_DATE->CurrentValue, 0);
        $this->MODIFIED_BY->CurrentValue = $this->MODIFIED_BY->FormValue;
        $this->RECEIVED_BY->CurrentValue = $this->RECEIVED_BY->FormValue;
        $this->PRIORITY->CurrentValue = $this->PRIORITY->FormValue;
        $this->CREDIT_NOTE->CurrentValue = $this->CREDIT_NOTE->FormValue;
        $this->CREDIT_AMOUNT->CurrentValue = $this->CREDIT_AMOUNT->FormValue;
        $this->PPN->CurrentValue = $this->PPN->FormValue;
        $this->MATERAI->CurrentValue = $this->MATERAI->FormValue;
        $this->SENT_BY->CurrentValue = $this->SENT_BY->FormValue;
        $this->ACCOUNT_ID->CurrentValue = $this->ACCOUNT_ID->FormValue;
        $this->FINANCE_ID->CurrentValue = $this->FINANCE_ID->FormValue;
        $this->potongan->CurrentValue = $this->potongan->FormValue;
        $this->RECEIVED_VALUE->CurrentValue = $this->RECEIVED_VALUE->FormValue;
        $this->NO_ORDER->CurrentValue = $this->NO_ORDER->FormValue;
        $this->CONTRACT_NO->CurrentValue = $this->CONTRACT_NO->FormValue;
        $this->ORG_ID->CurrentValue = $this->ORG_ID->FormValue;
        $this->CLINIC_ID->CurrentValue = $this->CLINIC_ID->FormValue;
        $this->PPN_VALUE->CurrentValue = $this->PPN_VALUE->FormValue;
        $this->DISCOUNT_VALUE->CurrentValue = $this->DISCOUNT_VALUE->FormValue;
        $this->PAID_VALUE->CurrentValue = $this->PAID_VALUE->FormValue;
        $this->ISCETAK->CurrentValue = $this->ISCETAK->FormValue;
        $this->PRINT_DATE->CurrentValue = $this->PRINT_DATE->FormValue;
        $this->PRINT_DATE->CurrentValue = UnFormatDateTime($this->PRINT_DATE->CurrentValue, 0);
        $this->PRINTED_BY->CurrentValue = $this->PRINTED_BY->FormValue;
        $this->PRINTQ->CurrentValue = $this->PRINTQ->FormValue;
        $this->FAKTUR_DATE->CurrentValue = $this->FAKTUR_DATE->FormValue;
        $this->FAKTUR_DATE->CurrentValue = UnFormatDateTime($this->FAKTUR_DATE->CurrentValue, 0);
        $this->DISTRIBUTION_TYPE->CurrentValue = $this->DISTRIBUTION_TYPE->FormValue;
        $this->DISCOUNTOFF_VALUE->CurrentValue = $this->DISCOUNTOFF_VALUE->FormValue;
        $this->THECOUNTER->CurrentValue = $this->THECOUNTER->FormValue;
        $this->FUND_ID->CurrentValue = $this->FUND_ID->FormValue;
        $this->ORDER_BY->CurrentValue = $this->ORDER_BY->FormValue;
        $this->ACKNOWLEDGEBY->CurrentValue = $this->ACKNOWLEDGEBY->FormValue;
        $this->NUM->CurrentValue = $this->NUM->FormValue;
        $this->ISPO->CurrentValue = $this->ISPO->FormValue;
        $this->DOCS_TYPE->CurrentValue = $this->DOCS_TYPE->FormValue;
        $this->PO_DATE->CurrentValue = $this->PO_DATE->FormValue;
        $this->PO_DATE->CurrentValue = UnFormatDateTime($this->PO_DATE->CurrentValue, 0);
        $this->PO_VALUE->CurrentValue = $this->PO_VALUE->FormValue;
    }

    /**
     * Load row based on key values
     *
     * @return void
     */
    public function loadRow()
    {
        global $Security, $Language;
        $filter = $this->getRecordFilter();

        // Call Row Selecting event
        $this->rowSelecting($filter);

        // Load SQL based on filter
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $res = false;
        $row = $conn->fetchAssoc($sql);
        if ($row) {
            $res = true;
            $this->loadRowValues($row); // Load row values
        }
        return $res;
    }

    /**
     * Load row values from recordset or record
     *
     * @param Recordset|array $rs Record
     * @return void
     */
    public function loadRowValues($rs = null)
    {
        if (is_array($rs)) {
            $row = $rs;
        } elseif ($rs && property_exists($rs, "fields")) { // Recordset
            $row = $rs->fields;
        } else {
            $row = $this->newRow();
        }

        // Call Row Selected event
        $this->rowSelected($row);
        if (!$rs) {
            return;
        }
        $this->ORG_UNIT_CODE->setDbValue($row['ORG_UNIT_CODE']);
        $this->INVOICE_ID->setDbValue($row['INVOICE_ID']);
        $this->INVOICE_ID2->setDbValue($row['INVOICE_ID2']);
        $this->INVOICE_DATE->setDbValue($row['INVOICE_DATE']);
        $this->PO->setDbValue($row['PO']);
        $this->COMPANY_ID->setDbValue($row['COMPANY_ID']);
        $this->RECEIVED_DATE->setDbValue($row['RECEIVED_DATE']);
        $this->AMOUNT->setDbValue($row['AMOUNT']);
        $this->PAYMENT_DUE->setDbValue($row['PAYMENT_DUE']);
        $this->DESCRIPTION->setDbValue($row['DESCRIPTION']);
        $this->MODIFIED_DATE->setDbValue($row['MODIFIED_DATE']);
        $this->MODIFIED_BY->setDbValue($row['MODIFIED_BY']);
        $this->RECEIVED_BY->setDbValue($row['RECEIVED_BY']);
        $this->PRIORITY->setDbValue($row['PRIORITY']);
        $this->CREDIT_NOTE->setDbValue($row['CREDIT_NOTE']);
        $this->CREDIT_AMOUNT->setDbValue($row['CREDIT_AMOUNT']);
        $this->PPN->setDbValue($row['PPN']);
        $this->MATERAI->setDbValue($row['MATERAI']);
        $this->SENT_BY->setDbValue($row['SENT_BY']);
        $this->ACCOUNT_ID->setDbValue($row['ACCOUNT_ID']);
        $this->FINANCE_ID->setDbValue($row['FINANCE_ID']);
        $this->potongan->setDbValue($row['potongan']);
        $this->RECEIVED_VALUE->setDbValue($row['RECEIVED_VALUE']);
        $this->NO_ORDER->setDbValue($row['NO_ORDER']);
        $this->CONTRACT_NO->setDbValue($row['CONTRACT_NO']);
        $this->ORG_ID->setDbValue($row['ORG_ID']);
        $this->CLINIC_ID->setDbValue($row['CLINIC_ID']);
        $this->PPN_VALUE->setDbValue($row['PPN_VALUE']);
        $this->DISCOUNT_VALUE->setDbValue($row['DISCOUNT_VALUE']);
        $this->PAID_VALUE->setDbValue($row['PAID_VALUE']);
        $this->ISCETAK->setDbValue($row['ISCETAK']);
        $this->PRINT_DATE->setDbValue($row['PRINT_DATE']);
        $this->PRINTED_BY->setDbValue($row['PRINTED_BY']);
        $this->PRINTQ->setDbValue($row['PRINTQ']);
        $this->FAKTUR_DATE->setDbValue($row['FAKTUR_DATE']);
        $this->DISTRIBUTION_TYPE->setDbValue($row['DISTRIBUTION_TYPE']);
        $this->DISCOUNTOFF_VALUE->setDbValue($row['DISCOUNTOFF_VALUE']);
        $this->THECOUNTER->setDbValue($row['THECOUNTER']);
        $this->FUND_ID->setDbValue($row['FUND_ID']);
        $this->ORDER_BY->setDbValue($row['ORDER_BY']);
        $this->ACKNOWLEDGEBY->setDbValue($row['ACKNOWLEDGEBY']);
        $this->NUM->setDbValue($row['NUM']);
        $this->ISPO->setDbValue($row['ISPO']);
        $this->DOCS_TYPE->setDbValue($row['DOCS_TYPE']);
        $this->PO_DATE->setDbValue($row['PO_DATE']);
        $this->PO_VALUE->setDbValue($row['PO_VALUE']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $this->loadDefaultValues();
        $row = [];
        $row['ORG_UNIT_CODE'] = $this->ORG_UNIT_CODE->CurrentValue;
        $row['INVOICE_ID'] = $this->INVOICE_ID->CurrentValue;
        $row['INVOICE_ID2'] = $this->INVOICE_ID2->CurrentValue;
        $row['INVOICE_DATE'] = $this->INVOICE_DATE->CurrentValue;
        $row['PO'] = $this->PO->CurrentValue;
        $row['COMPANY_ID'] = $this->COMPANY_ID->CurrentValue;
        $row['RECEIVED_DATE'] = $this->RECEIVED_DATE->CurrentValue;
        $row['AMOUNT'] = $this->AMOUNT->CurrentValue;
        $row['PAYMENT_DUE'] = $this->PAYMENT_DUE->CurrentValue;
        $row['DESCRIPTION'] = $this->DESCRIPTION->CurrentValue;
        $row['MODIFIED_DATE'] = $this->MODIFIED_DATE->CurrentValue;
        $row['MODIFIED_BY'] = $this->MODIFIED_BY->CurrentValue;
        $row['RECEIVED_BY'] = $this->RECEIVED_BY->CurrentValue;
        $row['PRIORITY'] = $this->PRIORITY->CurrentValue;
        $row['CREDIT_NOTE'] = $this->CREDIT_NOTE->CurrentValue;
        $row['CREDIT_AMOUNT'] = $this->CREDIT_AMOUNT->CurrentValue;
        $row['PPN'] = $this->PPN->CurrentValue;
        $row['MATERAI'] = $this->MATERAI->CurrentValue;
        $row['SENT_BY'] = $this->SENT_BY->CurrentValue;
        $row['ACCOUNT_ID'] = $this->ACCOUNT_ID->CurrentValue;
        $row['FINANCE_ID'] = $this->FINANCE_ID->CurrentValue;
        $row['potongan'] = $this->potongan->CurrentValue;
        $row['RECEIVED_VALUE'] = $this->RECEIVED_VALUE->CurrentValue;
        $row['NO_ORDER'] = $this->NO_ORDER->CurrentValue;
        $row['CONTRACT_NO'] = $this->CONTRACT_NO->CurrentValue;
        $row['ORG_ID'] = $this->ORG_ID->CurrentValue;
        $row['CLINIC_ID'] = $this->CLINIC_ID->CurrentValue;
        $row['PPN_VALUE'] = $this->PPN_VALUE->CurrentValue;
        $row['DISCOUNT_VALUE'] = $this->DISCOUNT_VALUE->CurrentValue;
        $row['PAID_VALUE'] = $this->PAID_VALUE->CurrentValue;
        $row['ISCETAK'] = $this->ISCETAK->CurrentValue;
        $row['PRINT_DATE'] = $this->PRINT_DATE->CurrentValue;
        $row['PRINTED_BY'] = $this->PRINTED_BY->CurrentValue;
        $row['PRINTQ'] = $this->PRINTQ->CurrentValue;
        $row['FAKTUR_DATE'] = $this->FAKTUR_DATE->CurrentValue;
        $row['DISTRIBUTION_TYPE'] = $this->DISTRIBUTION_TYPE->CurrentValue;
        $row['DISCOUNTOFF_VALUE'] = $this->DISCOUNTOFF_VALUE->CurrentValue;
        $row['THECOUNTER'] = $this->THECOUNTER->CurrentValue;
        $row['FUND_ID'] = $this->FUND_ID->CurrentValue;
        $row['ORDER_BY'] = $this->ORDER_BY->CurrentValue;
        $row['ACKNOWLEDGEBY'] = $this->ACKNOWLEDGEBY->CurrentValue;
        $row['NUM'] = $this->NUM->CurrentValue;
        $row['ISPO'] = $this->ISPO->CurrentValue;
        $row['DOCS_TYPE'] = $this->DOCS_TYPE->CurrentValue;
        $row['PO_DATE'] = $this->PO_DATE->CurrentValue;
        $row['PO_VALUE'] = $this->PO_VALUE->CurrentValue;
        return $row;
    }

    // Load old record
    protected function loadOldRecord()
    {
        // Load old record
        $this->OldRecordset = null;
        $validKey = $this->OldKey != "";
        if ($validKey) {
            $this->CurrentFilter = $this->getRecordFilter();
            $sql = $this->getCurrentSql();
            $conn = $this->getConnection();
            $this->OldRecordset = LoadRecordset($sql, $conn);
        }
        $this->loadRowValues($this->OldRecordset); // Load row values
        return $validKey;
    }

    // Render row values based on field settings
    public function renderRow()
    {
        global $Security, $Language, $CurrentLanguage;

        // Initialize URLs

        // Convert decimal values if posted back
        if ($this->AMOUNT->FormValue == $this->AMOUNT->CurrentValue && is_numeric(ConvertToFloatString($this->AMOUNT->CurrentValue))) {
            $this->AMOUNT->CurrentValue = ConvertToFloatString($this->AMOUNT->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->CREDIT_AMOUNT->FormValue == $this->CREDIT_AMOUNT->CurrentValue && is_numeric(ConvertToFloatString($this->CREDIT_AMOUNT->CurrentValue))) {
            $this->CREDIT_AMOUNT->CurrentValue = ConvertToFloatString($this->CREDIT_AMOUNT->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->PPN->FormValue == $this->PPN->CurrentValue && is_numeric(ConvertToFloatString($this->PPN->CurrentValue))) {
            $this->PPN->CurrentValue = ConvertToFloatString($this->PPN->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->MATERAI->FormValue == $this->MATERAI->CurrentValue && is_numeric(ConvertToFloatString($this->MATERAI->CurrentValue))) {
            $this->MATERAI->CurrentValue = ConvertToFloatString($this->MATERAI->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->potongan->FormValue == $this->potongan->CurrentValue && is_numeric(ConvertToFloatString($this->potongan->CurrentValue))) {
            $this->potongan->CurrentValue = ConvertToFloatString($this->potongan->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->RECEIVED_VALUE->FormValue == $this->RECEIVED_VALUE->CurrentValue && is_numeric(ConvertToFloatString($this->RECEIVED_VALUE->CurrentValue))) {
            $this->RECEIVED_VALUE->CurrentValue = ConvertToFloatString($this->RECEIVED_VALUE->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->PPN_VALUE->FormValue == $this->PPN_VALUE->CurrentValue && is_numeric(ConvertToFloatString($this->PPN_VALUE->CurrentValue))) {
            $this->PPN_VALUE->CurrentValue = ConvertToFloatString($this->PPN_VALUE->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->DISCOUNT_VALUE->FormValue == $this->DISCOUNT_VALUE->CurrentValue && is_numeric(ConvertToFloatString($this->DISCOUNT_VALUE->CurrentValue))) {
            $this->DISCOUNT_VALUE->CurrentValue = ConvertToFloatString($this->DISCOUNT_VALUE->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->PAID_VALUE->FormValue == $this->PAID_VALUE->CurrentValue && is_numeric(ConvertToFloatString($this->PAID_VALUE->CurrentValue))) {
            $this->PAID_VALUE->CurrentValue = ConvertToFloatString($this->PAID_VALUE->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->DISCOUNTOFF_VALUE->FormValue == $this->DISCOUNTOFF_VALUE->CurrentValue && is_numeric(ConvertToFloatString($this->DISCOUNTOFF_VALUE->CurrentValue))) {
            $this->DISCOUNTOFF_VALUE->CurrentValue = ConvertToFloatString($this->DISCOUNTOFF_VALUE->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->PO_VALUE->FormValue == $this->PO_VALUE->CurrentValue && is_numeric(ConvertToFloatString($this->PO_VALUE->CurrentValue))) {
            $this->PO_VALUE->CurrentValue = ConvertToFloatString($this->PO_VALUE->CurrentValue);
        }

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // ORG_UNIT_CODE

        // INVOICE_ID

        // INVOICE_ID2

        // INVOICE_DATE

        // PO

        // COMPANY_ID

        // RECEIVED_DATE

        // AMOUNT

        // PAYMENT_DUE

        // DESCRIPTION

        // MODIFIED_DATE

        // MODIFIED_BY

        // RECEIVED_BY

        // PRIORITY

        // CREDIT_NOTE

        // CREDIT_AMOUNT

        // PPN

        // MATERAI

        // SENT_BY

        // ACCOUNT_ID

        // FINANCE_ID

        // potongan

        // RECEIVED_VALUE

        // NO_ORDER

        // CONTRACT_NO

        // ORG_ID

        // CLINIC_ID

        // PPN_VALUE

        // DISCOUNT_VALUE

        // PAID_VALUE

        // ISCETAK

        // PRINT_DATE

        // PRINTED_BY

        // PRINTQ

        // FAKTUR_DATE

        // DISTRIBUTION_TYPE

        // DISCOUNTOFF_VALUE

        // THECOUNTER

        // FUND_ID

        // ORDER_BY

        // ACKNOWLEDGEBY

        // NUM

        // ISPO

        // DOCS_TYPE

        // PO_DATE

        // PO_VALUE
        if ($this->RowType == ROWTYPE_VIEW) {
            // ORG_UNIT_CODE
            $this->ORG_UNIT_CODE->ViewValue = $this->ORG_UNIT_CODE->CurrentValue;
            $this->ORG_UNIT_CODE->ViewCustomAttributes = "";

            // INVOICE_ID
            $this->INVOICE_ID->ViewValue = $this->INVOICE_ID->CurrentValue;
            $this->INVOICE_ID->ViewCustomAttributes = "";

            // INVOICE_ID2
            $this->INVOICE_ID2->ViewValue = $this->INVOICE_ID2->CurrentValue;
            $this->INVOICE_ID2->ViewCustomAttributes = "";

            // INVOICE_DATE
            $this->INVOICE_DATE->ViewValue = $this->INVOICE_DATE->CurrentValue;
            $this->INVOICE_DATE->ViewValue = FormatDateTime($this->INVOICE_DATE->ViewValue, 0);
            $this->INVOICE_DATE->ViewCustomAttributes = "";

            // PO
            $this->PO->ViewValue = $this->PO->CurrentValue;
            $this->PO->ViewCustomAttributes = "";

            // COMPANY_ID
            $this->COMPANY_ID->ViewValue = $this->COMPANY_ID->CurrentValue;
            $this->COMPANY_ID->ViewCustomAttributes = "";

            // RECEIVED_DATE
            $this->RECEIVED_DATE->ViewValue = $this->RECEIVED_DATE->CurrentValue;
            $this->RECEIVED_DATE->ViewValue = FormatDateTime($this->RECEIVED_DATE->ViewValue, 0);
            $this->RECEIVED_DATE->ViewCustomAttributes = "";

            // AMOUNT
            $this->AMOUNT->ViewValue = $this->AMOUNT->CurrentValue;
            $this->AMOUNT->ViewValue = FormatNumber($this->AMOUNT->ViewValue, 2, -2, -2, -2);
            $this->AMOUNT->ViewCustomAttributes = "";

            // PAYMENT_DUE
            $this->PAYMENT_DUE->ViewValue = $this->PAYMENT_DUE->CurrentValue;
            $this->PAYMENT_DUE->ViewValue = FormatDateTime($this->PAYMENT_DUE->ViewValue, 0);
            $this->PAYMENT_DUE->ViewCustomAttributes = "";

            // DESCRIPTION
            $this->DESCRIPTION->ViewValue = $this->DESCRIPTION->CurrentValue;
            $this->DESCRIPTION->ViewCustomAttributes = "";

            // MODIFIED_DATE
            $this->MODIFIED_DATE->ViewValue = $this->MODIFIED_DATE->CurrentValue;
            $this->MODIFIED_DATE->ViewValue = FormatDateTime($this->MODIFIED_DATE->ViewValue, 0);
            $this->MODIFIED_DATE->ViewCustomAttributes = "";

            // MODIFIED_BY
            $this->MODIFIED_BY->ViewValue = $this->MODIFIED_BY->CurrentValue;
            $this->MODIFIED_BY->ViewCustomAttributes = "";

            // RECEIVED_BY
            $this->RECEIVED_BY->ViewValue = $this->RECEIVED_BY->CurrentValue;
            $this->RECEIVED_BY->ViewCustomAttributes = "";

            // PRIORITY
            $this->PRIORITY->ViewValue = $this->PRIORITY->CurrentValue;
            $this->PRIORITY->ViewValue = FormatNumber($this->PRIORITY->ViewValue, 0, -2, -2, -2);
            $this->PRIORITY->ViewCustomAttributes = "";

            // CREDIT_NOTE
            $this->CREDIT_NOTE->ViewValue = $this->CREDIT_NOTE->CurrentValue;
            $this->CREDIT_NOTE->ViewCustomAttributes = "";

            // CREDIT_AMOUNT
            $this->CREDIT_AMOUNT->ViewValue = $this->CREDIT_AMOUNT->CurrentValue;
            $this->CREDIT_AMOUNT->ViewValue = FormatNumber($this->CREDIT_AMOUNT->ViewValue, 2, -2, -2, -2);
            $this->CREDIT_AMOUNT->ViewCustomAttributes = "";

            // PPN
            $this->PPN->ViewValue = $this->PPN->CurrentValue;
            $this->PPN->ViewValue = FormatNumber($this->PPN->ViewValue, 2, -2, -2, -2);
            $this->PPN->ViewCustomAttributes = "";

            // MATERAI
            $this->MATERAI->ViewValue = $this->MATERAI->CurrentValue;
            $this->MATERAI->ViewValue = FormatNumber($this->MATERAI->ViewValue, 2, -2, -2, -2);
            $this->MATERAI->ViewCustomAttributes = "";

            // SENT_BY
            $this->SENT_BY->ViewValue = $this->SENT_BY->CurrentValue;
            $this->SENT_BY->ViewCustomAttributes = "";

            // ACCOUNT_ID
            $this->ACCOUNT_ID->ViewValue = $this->ACCOUNT_ID->CurrentValue;
            $this->ACCOUNT_ID->ViewValue = FormatNumber($this->ACCOUNT_ID->ViewValue, 0, -2, -2, -2);
            $this->ACCOUNT_ID->ViewCustomAttributes = "";

            // FINANCE_ID
            $this->FINANCE_ID->ViewValue = $this->FINANCE_ID->CurrentValue;
            $this->FINANCE_ID->ViewValue = FormatNumber($this->FINANCE_ID->ViewValue, 0, -2, -2, -2);
            $this->FINANCE_ID->ViewCustomAttributes = "";

            // potongan
            $this->potongan->ViewValue = $this->potongan->CurrentValue;
            $this->potongan->ViewValue = FormatNumber($this->potongan->ViewValue, 2, -2, -2, -2);
            $this->potongan->ViewCustomAttributes = "";

            // RECEIVED_VALUE
            $this->RECEIVED_VALUE->ViewValue = $this->RECEIVED_VALUE->CurrentValue;
            $this->RECEIVED_VALUE->ViewValue = FormatNumber($this->RECEIVED_VALUE->ViewValue, 2, -2, -2, -2);
            $this->RECEIVED_VALUE->ViewCustomAttributes = "";

            // NO_ORDER
            $this->NO_ORDER->ViewValue = $this->NO_ORDER->CurrentValue;
            $this->NO_ORDER->ViewCustomAttributes = "";

            // CONTRACT_NO
            $this->CONTRACT_NO->ViewValue = $this->CONTRACT_NO->CurrentValue;
            $this->CONTRACT_NO->ViewCustomAttributes = "";

            // ORG_ID
            $this->ORG_ID->ViewValue = $this->ORG_ID->CurrentValue;
            $this->ORG_ID->ViewCustomAttributes = "";

            // CLINIC_ID
            $this->CLINIC_ID->ViewValue = $this->CLINIC_ID->CurrentValue;
            $this->CLINIC_ID->ViewCustomAttributes = "";

            // PPN_VALUE
            $this->PPN_VALUE->ViewValue = $this->PPN_VALUE->CurrentValue;
            $this->PPN_VALUE->ViewValue = FormatNumber($this->PPN_VALUE->ViewValue, 2, -2, -2, -2);
            $this->PPN_VALUE->ViewCustomAttributes = "";

            // DISCOUNT_VALUE
            $this->DISCOUNT_VALUE->ViewValue = $this->DISCOUNT_VALUE->CurrentValue;
            $this->DISCOUNT_VALUE->ViewValue = FormatNumber($this->DISCOUNT_VALUE->ViewValue, 2, -2, -2, -2);
            $this->DISCOUNT_VALUE->ViewCustomAttributes = "";

            // PAID_VALUE
            $this->PAID_VALUE->ViewValue = $this->PAID_VALUE->CurrentValue;
            $this->PAID_VALUE->ViewValue = FormatNumber($this->PAID_VALUE->ViewValue, 2, -2, -2, -2);
            $this->PAID_VALUE->ViewCustomAttributes = "";

            // ISCETAK
            $this->ISCETAK->ViewValue = $this->ISCETAK->CurrentValue;
            $this->ISCETAK->ViewCustomAttributes = "";

            // PRINT_DATE
            $this->PRINT_DATE->ViewValue = $this->PRINT_DATE->CurrentValue;
            $this->PRINT_DATE->ViewValue = FormatDateTime($this->PRINT_DATE->ViewValue, 0);
            $this->PRINT_DATE->ViewCustomAttributes = "";

            // PRINTED_BY
            $this->PRINTED_BY->ViewValue = $this->PRINTED_BY->CurrentValue;
            $this->PRINTED_BY->ViewCustomAttributes = "";

            // PRINTQ
            $this->PRINTQ->ViewValue = $this->PRINTQ->CurrentValue;
            $this->PRINTQ->ViewValue = FormatNumber($this->PRINTQ->ViewValue, 0, -2, -2, -2);
            $this->PRINTQ->ViewCustomAttributes = "";

            // FAKTUR_DATE
            $this->FAKTUR_DATE->ViewValue = $this->FAKTUR_DATE->CurrentValue;
            $this->FAKTUR_DATE->ViewValue = FormatDateTime($this->FAKTUR_DATE->ViewValue, 0);
            $this->FAKTUR_DATE->ViewCustomAttributes = "";

            // DISTRIBUTION_TYPE
            $this->DISTRIBUTION_TYPE->ViewValue = $this->DISTRIBUTION_TYPE->CurrentValue;
            $this->DISTRIBUTION_TYPE->ViewValue = FormatNumber($this->DISTRIBUTION_TYPE->ViewValue, 0, -2, -2, -2);
            $this->DISTRIBUTION_TYPE->ViewCustomAttributes = "";

            // DISCOUNTOFF_VALUE
            $this->DISCOUNTOFF_VALUE->ViewValue = $this->DISCOUNTOFF_VALUE->CurrentValue;
            $this->DISCOUNTOFF_VALUE->ViewValue = FormatNumber($this->DISCOUNTOFF_VALUE->ViewValue, 2, -2, -2, -2);
            $this->DISCOUNTOFF_VALUE->ViewCustomAttributes = "";

            // THECOUNTER
            $this->THECOUNTER->ViewValue = $this->THECOUNTER->CurrentValue;
            $this->THECOUNTER->ViewValue = FormatNumber($this->THECOUNTER->ViewValue, 0, -2, -2, -2);
            $this->THECOUNTER->ViewCustomAttributes = "";

            // FUND_ID
            $this->FUND_ID->ViewValue = $this->FUND_ID->CurrentValue;
            $this->FUND_ID->ViewValue = FormatNumber($this->FUND_ID->ViewValue, 0, -2, -2, -2);
            $this->FUND_ID->ViewCustomAttributes = "";

            // ORDER_BY
            $this->ORDER_BY->ViewValue = $this->ORDER_BY->CurrentValue;
            $this->ORDER_BY->ViewCustomAttributes = "";

            // ACKNOWLEDGEBY
            $this->ACKNOWLEDGEBY->ViewValue = $this->ACKNOWLEDGEBY->CurrentValue;
            $this->ACKNOWLEDGEBY->ViewCustomAttributes = "";

            // NUM
            $this->NUM->ViewValue = $this->NUM->CurrentValue;
            $this->NUM->ViewValue = FormatNumber($this->NUM->ViewValue, 0, -2, -2, -2);
            $this->NUM->ViewCustomAttributes = "";

            // ISPO
            $this->ISPO->ViewValue = $this->ISPO->CurrentValue;
            $this->ISPO->ViewCustomAttributes = "";

            // DOCS_TYPE
            $this->DOCS_TYPE->ViewValue = $this->DOCS_TYPE->CurrentValue;
            $this->DOCS_TYPE->ViewValue = FormatNumber($this->DOCS_TYPE->ViewValue, 0, -2, -2, -2);
            $this->DOCS_TYPE->ViewCustomAttributes = "";

            // PO_DATE
            $this->PO_DATE->ViewValue = $this->PO_DATE->CurrentValue;
            $this->PO_DATE->ViewValue = FormatDateTime($this->PO_DATE->ViewValue, 0);
            $this->PO_DATE->ViewCustomAttributes = "";

            // PO_VALUE
            $this->PO_VALUE->ViewValue = $this->PO_VALUE->CurrentValue;
            $this->PO_VALUE->ViewValue = FormatNumber($this->PO_VALUE->ViewValue, 2, -2, -2, -2);
            $this->PO_VALUE->ViewCustomAttributes = "";

            // ORG_UNIT_CODE
            $this->ORG_UNIT_CODE->LinkCustomAttributes = "";
            $this->ORG_UNIT_CODE->HrefValue = "";
            $this->ORG_UNIT_CODE->TooltipValue = "";

            // INVOICE_ID
            $this->INVOICE_ID->LinkCustomAttributes = "";
            $this->INVOICE_ID->HrefValue = "";
            $this->INVOICE_ID->TooltipValue = "";

            // INVOICE_ID2
            $this->INVOICE_ID2->LinkCustomAttributes = "";
            $this->INVOICE_ID2->HrefValue = "";
            $this->INVOICE_ID2->TooltipValue = "";

            // INVOICE_DATE
            $this->INVOICE_DATE->LinkCustomAttributes = "";
            $this->INVOICE_DATE->HrefValue = "";
            $this->INVOICE_DATE->TooltipValue = "";

            // PO
            $this->PO->LinkCustomAttributes = "";
            $this->PO->HrefValue = "";
            $this->PO->TooltipValue = "";

            // COMPANY_ID
            $this->COMPANY_ID->LinkCustomAttributes = "";
            $this->COMPANY_ID->HrefValue = "";
            $this->COMPANY_ID->TooltipValue = "";

            // RECEIVED_DATE
            $this->RECEIVED_DATE->LinkCustomAttributes = "";
            $this->RECEIVED_DATE->HrefValue = "";
            $this->RECEIVED_DATE->TooltipValue = "";

            // AMOUNT
            $this->AMOUNT->LinkCustomAttributes = "";
            $this->AMOUNT->HrefValue = "";
            $this->AMOUNT->TooltipValue = "";

            // PAYMENT_DUE
            $this->PAYMENT_DUE->LinkCustomAttributes = "";
            $this->PAYMENT_DUE->HrefValue = "";
            $this->PAYMENT_DUE->TooltipValue = "";

            // DESCRIPTION
            $this->DESCRIPTION->LinkCustomAttributes = "";
            $this->DESCRIPTION->HrefValue = "";
            $this->DESCRIPTION->TooltipValue = "";

            // MODIFIED_DATE
            $this->MODIFIED_DATE->LinkCustomAttributes = "";
            $this->MODIFIED_DATE->HrefValue = "";
            $this->MODIFIED_DATE->TooltipValue = "";

            // MODIFIED_BY
            $this->MODIFIED_BY->LinkCustomAttributes = "";
            $this->MODIFIED_BY->HrefValue = "";
            $this->MODIFIED_BY->TooltipValue = "";

            // RECEIVED_BY
            $this->RECEIVED_BY->LinkCustomAttributes = "";
            $this->RECEIVED_BY->HrefValue = "";
            $this->RECEIVED_BY->TooltipValue = "";

            // PRIORITY
            $this->PRIORITY->LinkCustomAttributes = "";
            $this->PRIORITY->HrefValue = "";
            $this->PRIORITY->TooltipValue = "";

            // CREDIT_NOTE
            $this->CREDIT_NOTE->LinkCustomAttributes = "";
            $this->CREDIT_NOTE->HrefValue = "";
            $this->CREDIT_NOTE->TooltipValue = "";

            // CREDIT_AMOUNT
            $this->CREDIT_AMOUNT->LinkCustomAttributes = "";
            $this->CREDIT_AMOUNT->HrefValue = "";
            $this->CREDIT_AMOUNT->TooltipValue = "";

            // PPN
            $this->PPN->LinkCustomAttributes = "";
            $this->PPN->HrefValue = "";
            $this->PPN->TooltipValue = "";

            // MATERAI
            $this->MATERAI->LinkCustomAttributes = "";
            $this->MATERAI->HrefValue = "";
            $this->MATERAI->TooltipValue = "";

            // SENT_BY
            $this->SENT_BY->LinkCustomAttributes = "";
            $this->SENT_BY->HrefValue = "";
            $this->SENT_BY->TooltipValue = "";

            // ACCOUNT_ID
            $this->ACCOUNT_ID->LinkCustomAttributes = "";
            $this->ACCOUNT_ID->HrefValue = "";
            $this->ACCOUNT_ID->TooltipValue = "";

            // FINANCE_ID
            $this->FINANCE_ID->LinkCustomAttributes = "";
            $this->FINANCE_ID->HrefValue = "";
            $this->FINANCE_ID->TooltipValue = "";

            // potongan
            $this->potongan->LinkCustomAttributes = "";
            $this->potongan->HrefValue = "";
            $this->potongan->TooltipValue = "";

            // RECEIVED_VALUE
            $this->RECEIVED_VALUE->LinkCustomAttributes = "";
            $this->RECEIVED_VALUE->HrefValue = "";
            $this->RECEIVED_VALUE->TooltipValue = "";

            // NO_ORDER
            $this->NO_ORDER->LinkCustomAttributes = "";
            $this->NO_ORDER->HrefValue = "";
            $this->NO_ORDER->TooltipValue = "";

            // CONTRACT_NO
            $this->CONTRACT_NO->LinkCustomAttributes = "";
            $this->CONTRACT_NO->HrefValue = "";
            $this->CONTRACT_NO->TooltipValue = "";

            // ORG_ID
            $this->ORG_ID->LinkCustomAttributes = "";
            $this->ORG_ID->HrefValue = "";
            $this->ORG_ID->TooltipValue = "";

            // CLINIC_ID
            $this->CLINIC_ID->LinkCustomAttributes = "";
            $this->CLINIC_ID->HrefValue = "";
            $this->CLINIC_ID->TooltipValue = "";

            // PPN_VALUE
            $this->PPN_VALUE->LinkCustomAttributes = "";
            $this->PPN_VALUE->HrefValue = "";
            $this->PPN_VALUE->TooltipValue = "";

            // DISCOUNT_VALUE
            $this->DISCOUNT_VALUE->LinkCustomAttributes = "";
            $this->DISCOUNT_VALUE->HrefValue = "";
            $this->DISCOUNT_VALUE->TooltipValue = "";

            // PAID_VALUE
            $this->PAID_VALUE->LinkCustomAttributes = "";
            $this->PAID_VALUE->HrefValue = "";
            $this->PAID_VALUE->TooltipValue = "";

            // ISCETAK
            $this->ISCETAK->LinkCustomAttributes = "";
            $this->ISCETAK->HrefValue = "";
            $this->ISCETAK->TooltipValue = "";

            // PRINT_DATE
            $this->PRINT_DATE->LinkCustomAttributes = "";
            $this->PRINT_DATE->HrefValue = "";
            $this->PRINT_DATE->TooltipValue = "";

            // PRINTED_BY
            $this->PRINTED_BY->LinkCustomAttributes = "";
            $this->PRINTED_BY->HrefValue = "";
            $this->PRINTED_BY->TooltipValue = "";

            // PRINTQ
            $this->PRINTQ->LinkCustomAttributes = "";
            $this->PRINTQ->HrefValue = "";
            $this->PRINTQ->TooltipValue = "";

            // FAKTUR_DATE
            $this->FAKTUR_DATE->LinkCustomAttributes = "";
            $this->FAKTUR_DATE->HrefValue = "";
            $this->FAKTUR_DATE->TooltipValue = "";

            // DISTRIBUTION_TYPE
            $this->DISTRIBUTION_TYPE->LinkCustomAttributes = "";
            $this->DISTRIBUTION_TYPE->HrefValue = "";
            $this->DISTRIBUTION_TYPE->TooltipValue = "";

            // DISCOUNTOFF_VALUE
            $this->DISCOUNTOFF_VALUE->LinkCustomAttributes = "";
            $this->DISCOUNTOFF_VALUE->HrefValue = "";
            $this->DISCOUNTOFF_VALUE->TooltipValue = "";

            // THECOUNTER
            $this->THECOUNTER->LinkCustomAttributes = "";
            $this->THECOUNTER->HrefValue = "";
            $this->THECOUNTER->TooltipValue = "";

            // FUND_ID
            $this->FUND_ID->LinkCustomAttributes = "";
            $this->FUND_ID->HrefValue = "";
            $this->FUND_ID->TooltipValue = "";

            // ORDER_BY
            $this->ORDER_BY->LinkCustomAttributes = "";
            $this->ORDER_BY->HrefValue = "";
            $this->ORDER_BY->TooltipValue = "";

            // ACKNOWLEDGEBY
            $this->ACKNOWLEDGEBY->LinkCustomAttributes = "";
            $this->ACKNOWLEDGEBY->HrefValue = "";
            $this->ACKNOWLEDGEBY->TooltipValue = "";

            // NUM
            $this->NUM->LinkCustomAttributes = "";
            $this->NUM->HrefValue = "";
            $this->NUM->TooltipValue = "";

            // ISPO
            $this->ISPO->LinkCustomAttributes = "";
            $this->ISPO->HrefValue = "";
            $this->ISPO->TooltipValue = "";

            // DOCS_TYPE
            $this->DOCS_TYPE->LinkCustomAttributes = "";
            $this->DOCS_TYPE->HrefValue = "";
            $this->DOCS_TYPE->TooltipValue = "";

            // PO_DATE
            $this->PO_DATE->LinkCustomAttributes = "";
            $this->PO_DATE->HrefValue = "";
            $this->PO_DATE->TooltipValue = "";

            // PO_VALUE
            $this->PO_VALUE->LinkCustomAttributes = "";
            $this->PO_VALUE->HrefValue = "";
            $this->PO_VALUE->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // ORG_UNIT_CODE
            $this->ORG_UNIT_CODE->EditAttrs["class"] = "form-control";
            $this->ORG_UNIT_CODE->EditCustomAttributes = "";
            if (!$this->ORG_UNIT_CODE->Raw) {
                $this->ORG_UNIT_CODE->CurrentValue = HtmlDecode($this->ORG_UNIT_CODE->CurrentValue);
            }
            $this->ORG_UNIT_CODE->EditValue = HtmlEncode($this->ORG_UNIT_CODE->CurrentValue);
            $this->ORG_UNIT_CODE->PlaceHolder = RemoveHtml($this->ORG_UNIT_CODE->caption());

            // INVOICE_ID
            $this->INVOICE_ID->EditAttrs["class"] = "form-control";
            $this->INVOICE_ID->EditCustomAttributes = "";
            if (!$this->INVOICE_ID->Raw) {
                $this->INVOICE_ID->CurrentValue = HtmlDecode($this->INVOICE_ID->CurrentValue);
            }
            $this->INVOICE_ID->EditValue = HtmlEncode($this->INVOICE_ID->CurrentValue);
            $this->INVOICE_ID->PlaceHolder = RemoveHtml($this->INVOICE_ID->caption());

            // INVOICE_ID2
            $this->INVOICE_ID2->EditAttrs["class"] = "form-control";
            $this->INVOICE_ID2->EditCustomAttributes = "";
            if (!$this->INVOICE_ID2->Raw) {
                $this->INVOICE_ID2->CurrentValue = HtmlDecode($this->INVOICE_ID2->CurrentValue);
            }
            $this->INVOICE_ID2->EditValue = HtmlEncode($this->INVOICE_ID2->CurrentValue);
            $this->INVOICE_ID2->PlaceHolder = RemoveHtml($this->INVOICE_ID2->caption());

            // INVOICE_DATE
            $this->INVOICE_DATE->EditAttrs["class"] = "form-control";
            $this->INVOICE_DATE->EditCustomAttributes = "";
            $this->INVOICE_DATE->EditValue = HtmlEncode(FormatDateTime($this->INVOICE_DATE->CurrentValue, 8));
            $this->INVOICE_DATE->PlaceHolder = RemoveHtml($this->INVOICE_DATE->caption());

            // PO
            $this->PO->EditAttrs["class"] = "form-control";
            $this->PO->EditCustomAttributes = "";
            if (!$this->PO->Raw) {
                $this->PO->CurrentValue = HtmlDecode($this->PO->CurrentValue);
            }
            $this->PO->EditValue = HtmlEncode($this->PO->CurrentValue);
            $this->PO->PlaceHolder = RemoveHtml($this->PO->caption());

            // COMPANY_ID
            $this->COMPANY_ID->EditAttrs["class"] = "form-control";
            $this->COMPANY_ID->EditCustomAttributes = "";
            if (!$this->COMPANY_ID->Raw) {
                $this->COMPANY_ID->CurrentValue = HtmlDecode($this->COMPANY_ID->CurrentValue);
            }
            $this->COMPANY_ID->EditValue = HtmlEncode($this->COMPANY_ID->CurrentValue);
            $this->COMPANY_ID->PlaceHolder = RemoveHtml($this->COMPANY_ID->caption());

            // RECEIVED_DATE
            $this->RECEIVED_DATE->EditAttrs["class"] = "form-control";
            $this->RECEIVED_DATE->EditCustomAttributes = "";
            $this->RECEIVED_DATE->EditValue = HtmlEncode(FormatDateTime($this->RECEIVED_DATE->CurrentValue, 8));
            $this->RECEIVED_DATE->PlaceHolder = RemoveHtml($this->RECEIVED_DATE->caption());

            // AMOUNT
            $this->AMOUNT->EditAttrs["class"] = "form-control";
            $this->AMOUNT->EditCustomAttributes = "";
            $this->AMOUNT->EditValue = HtmlEncode($this->AMOUNT->CurrentValue);
            $this->AMOUNT->PlaceHolder = RemoveHtml($this->AMOUNT->caption());
            if (strval($this->AMOUNT->EditValue) != "" && is_numeric($this->AMOUNT->EditValue)) {
                $this->AMOUNT->EditValue = FormatNumber($this->AMOUNT->EditValue, -2, -2, -2, -2);
            }

            // PAYMENT_DUE
            $this->PAYMENT_DUE->EditAttrs["class"] = "form-control";
            $this->PAYMENT_DUE->EditCustomAttributes = "";
            $this->PAYMENT_DUE->EditValue = HtmlEncode(FormatDateTime($this->PAYMENT_DUE->CurrentValue, 8));
            $this->PAYMENT_DUE->PlaceHolder = RemoveHtml($this->PAYMENT_DUE->caption());

            // DESCRIPTION
            $this->DESCRIPTION->EditAttrs["class"] = "form-control";
            $this->DESCRIPTION->EditCustomAttributes = "";
            if (!$this->DESCRIPTION->Raw) {
                $this->DESCRIPTION->CurrentValue = HtmlDecode($this->DESCRIPTION->CurrentValue);
            }
            $this->DESCRIPTION->EditValue = HtmlEncode($this->DESCRIPTION->CurrentValue);
            $this->DESCRIPTION->PlaceHolder = RemoveHtml($this->DESCRIPTION->caption());

            // MODIFIED_DATE
            $this->MODIFIED_DATE->EditAttrs["class"] = "form-control";
            $this->MODIFIED_DATE->EditCustomAttributes = "";
            $this->MODIFIED_DATE->EditValue = HtmlEncode(FormatDateTime($this->MODIFIED_DATE->CurrentValue, 8));
            $this->MODIFIED_DATE->PlaceHolder = RemoveHtml($this->MODIFIED_DATE->caption());

            // MODIFIED_BY
            $this->MODIFIED_BY->EditAttrs["class"] = "form-control";
            $this->MODIFIED_BY->EditCustomAttributes = "";
            if (!$this->MODIFIED_BY->Raw) {
                $this->MODIFIED_BY->CurrentValue = HtmlDecode($this->MODIFIED_BY->CurrentValue);
            }
            $this->MODIFIED_BY->EditValue = HtmlEncode($this->MODIFIED_BY->CurrentValue);
            $this->MODIFIED_BY->PlaceHolder = RemoveHtml($this->MODIFIED_BY->caption());

            // RECEIVED_BY
            $this->RECEIVED_BY->EditAttrs["class"] = "form-control";
            $this->RECEIVED_BY->EditCustomAttributes = "";
            if (!$this->RECEIVED_BY->Raw) {
                $this->RECEIVED_BY->CurrentValue = HtmlDecode($this->RECEIVED_BY->CurrentValue);
            }
            $this->RECEIVED_BY->EditValue = HtmlEncode($this->RECEIVED_BY->CurrentValue);
            $this->RECEIVED_BY->PlaceHolder = RemoveHtml($this->RECEIVED_BY->caption());

            // PRIORITY
            $this->PRIORITY->EditAttrs["class"] = "form-control";
            $this->PRIORITY->EditCustomAttributes = "";
            $this->PRIORITY->EditValue = HtmlEncode($this->PRIORITY->CurrentValue);
            $this->PRIORITY->PlaceHolder = RemoveHtml($this->PRIORITY->caption());

            // CREDIT_NOTE
            $this->CREDIT_NOTE->EditAttrs["class"] = "form-control";
            $this->CREDIT_NOTE->EditCustomAttributes = "";
            if (!$this->CREDIT_NOTE->Raw) {
                $this->CREDIT_NOTE->CurrentValue = HtmlDecode($this->CREDIT_NOTE->CurrentValue);
            }
            $this->CREDIT_NOTE->EditValue = HtmlEncode($this->CREDIT_NOTE->CurrentValue);
            $this->CREDIT_NOTE->PlaceHolder = RemoveHtml($this->CREDIT_NOTE->caption());

            // CREDIT_AMOUNT
            $this->CREDIT_AMOUNT->EditAttrs["class"] = "form-control";
            $this->CREDIT_AMOUNT->EditCustomAttributes = "";
            $this->CREDIT_AMOUNT->EditValue = HtmlEncode($this->CREDIT_AMOUNT->CurrentValue);
            $this->CREDIT_AMOUNT->PlaceHolder = RemoveHtml($this->CREDIT_AMOUNT->caption());
            if (strval($this->CREDIT_AMOUNT->EditValue) != "" && is_numeric($this->CREDIT_AMOUNT->EditValue)) {
                $this->CREDIT_AMOUNT->EditValue = FormatNumber($this->CREDIT_AMOUNT->EditValue, -2, -2, -2, -2);
            }

            // PPN
            $this->PPN->EditAttrs["class"] = "form-control";
            $this->PPN->EditCustomAttributes = "";
            $this->PPN->EditValue = HtmlEncode($this->PPN->CurrentValue);
            $this->PPN->PlaceHolder = RemoveHtml($this->PPN->caption());
            if (strval($this->PPN->EditValue) != "" && is_numeric($this->PPN->EditValue)) {
                $this->PPN->EditValue = FormatNumber($this->PPN->EditValue, -2, -2, -2, -2);
            }

            // MATERAI
            $this->MATERAI->EditAttrs["class"] = "form-control";
            $this->MATERAI->EditCustomAttributes = "";
            $this->MATERAI->EditValue = HtmlEncode($this->MATERAI->CurrentValue);
            $this->MATERAI->PlaceHolder = RemoveHtml($this->MATERAI->caption());
            if (strval($this->MATERAI->EditValue) != "" && is_numeric($this->MATERAI->EditValue)) {
                $this->MATERAI->EditValue = FormatNumber($this->MATERAI->EditValue, -2, -2, -2, -2);
            }

            // SENT_BY
            $this->SENT_BY->EditAttrs["class"] = "form-control";
            $this->SENT_BY->EditCustomAttributes = "";
            if (!$this->SENT_BY->Raw) {
                $this->SENT_BY->CurrentValue = HtmlDecode($this->SENT_BY->CurrentValue);
            }
            $this->SENT_BY->EditValue = HtmlEncode($this->SENT_BY->CurrentValue);
            $this->SENT_BY->PlaceHolder = RemoveHtml($this->SENT_BY->caption());

            // ACCOUNT_ID
            $this->ACCOUNT_ID->EditAttrs["class"] = "form-control";
            $this->ACCOUNT_ID->EditCustomAttributes = "";
            $this->ACCOUNT_ID->EditValue = HtmlEncode($this->ACCOUNT_ID->CurrentValue);
            $this->ACCOUNT_ID->PlaceHolder = RemoveHtml($this->ACCOUNT_ID->caption());

            // FINANCE_ID
            $this->FINANCE_ID->EditAttrs["class"] = "form-control";
            $this->FINANCE_ID->EditCustomAttributes = "";
            $this->FINANCE_ID->EditValue = HtmlEncode($this->FINANCE_ID->CurrentValue);
            $this->FINANCE_ID->PlaceHolder = RemoveHtml($this->FINANCE_ID->caption());

            // potongan
            $this->potongan->EditAttrs["class"] = "form-control";
            $this->potongan->EditCustomAttributes = "";
            $this->potongan->EditValue = HtmlEncode($this->potongan->CurrentValue);
            $this->potongan->PlaceHolder = RemoveHtml($this->potongan->caption());
            if (strval($this->potongan->EditValue) != "" && is_numeric($this->potongan->EditValue)) {
                $this->potongan->EditValue = FormatNumber($this->potongan->EditValue, -2, -2, -2, -2);
            }

            // RECEIVED_VALUE
            $this->RECEIVED_VALUE->EditAttrs["class"] = "form-control";
            $this->RECEIVED_VALUE->EditCustomAttributes = "";
            $this->RECEIVED_VALUE->EditValue = HtmlEncode($this->RECEIVED_VALUE->CurrentValue);
            $this->RECEIVED_VALUE->PlaceHolder = RemoveHtml($this->RECEIVED_VALUE->caption());
            if (strval($this->RECEIVED_VALUE->EditValue) != "" && is_numeric($this->RECEIVED_VALUE->EditValue)) {
                $this->RECEIVED_VALUE->EditValue = FormatNumber($this->RECEIVED_VALUE->EditValue, -2, -2, -2, -2);
            }

            // NO_ORDER
            $this->NO_ORDER->EditAttrs["class"] = "form-control";
            $this->NO_ORDER->EditCustomAttributes = "";
            if (!$this->NO_ORDER->Raw) {
                $this->NO_ORDER->CurrentValue = HtmlDecode($this->NO_ORDER->CurrentValue);
            }
            $this->NO_ORDER->EditValue = HtmlEncode($this->NO_ORDER->CurrentValue);
            $this->NO_ORDER->PlaceHolder = RemoveHtml($this->NO_ORDER->caption());

            // CONTRACT_NO
            $this->CONTRACT_NO->EditAttrs["class"] = "form-control";
            $this->CONTRACT_NO->EditCustomAttributes = "";
            if (!$this->CONTRACT_NO->Raw) {
                $this->CONTRACT_NO->CurrentValue = HtmlDecode($this->CONTRACT_NO->CurrentValue);
            }
            $this->CONTRACT_NO->EditValue = HtmlEncode($this->CONTRACT_NO->CurrentValue);
            $this->CONTRACT_NO->PlaceHolder = RemoveHtml($this->CONTRACT_NO->caption());

            // ORG_ID
            $this->ORG_ID->EditAttrs["class"] = "form-control";
            $this->ORG_ID->EditCustomAttributes = "";
            if (!$this->ORG_ID->Raw) {
                $this->ORG_ID->CurrentValue = HtmlDecode($this->ORG_ID->CurrentValue);
            }
            $this->ORG_ID->EditValue = HtmlEncode($this->ORG_ID->CurrentValue);
            $this->ORG_ID->PlaceHolder = RemoveHtml($this->ORG_ID->caption());

            // CLINIC_ID
            $this->CLINIC_ID->EditAttrs["class"] = "form-control";
            $this->CLINIC_ID->EditCustomAttributes = "";
            if (!$this->CLINIC_ID->Raw) {
                $this->CLINIC_ID->CurrentValue = HtmlDecode($this->CLINIC_ID->CurrentValue);
            }
            $this->CLINIC_ID->EditValue = HtmlEncode($this->CLINIC_ID->CurrentValue);
            $this->CLINIC_ID->PlaceHolder = RemoveHtml($this->CLINIC_ID->caption());

            // PPN_VALUE
            $this->PPN_VALUE->EditAttrs["class"] = "form-control";
            $this->PPN_VALUE->EditCustomAttributes = "";
            $this->PPN_VALUE->EditValue = HtmlEncode($this->PPN_VALUE->CurrentValue);
            $this->PPN_VALUE->PlaceHolder = RemoveHtml($this->PPN_VALUE->caption());
            if (strval($this->PPN_VALUE->EditValue) != "" && is_numeric($this->PPN_VALUE->EditValue)) {
                $this->PPN_VALUE->EditValue = FormatNumber($this->PPN_VALUE->EditValue, -2, -2, -2, -2);
            }

            // DISCOUNT_VALUE
            $this->DISCOUNT_VALUE->EditAttrs["class"] = "form-control";
            $this->DISCOUNT_VALUE->EditCustomAttributes = "";
            $this->DISCOUNT_VALUE->EditValue = HtmlEncode($this->DISCOUNT_VALUE->CurrentValue);
            $this->DISCOUNT_VALUE->PlaceHolder = RemoveHtml($this->DISCOUNT_VALUE->caption());
            if (strval($this->DISCOUNT_VALUE->EditValue) != "" && is_numeric($this->DISCOUNT_VALUE->EditValue)) {
                $this->DISCOUNT_VALUE->EditValue = FormatNumber($this->DISCOUNT_VALUE->EditValue, -2, -2, -2, -2);
            }

            // PAID_VALUE
            $this->PAID_VALUE->EditAttrs["class"] = "form-control";
            $this->PAID_VALUE->EditCustomAttributes = "";
            $this->PAID_VALUE->EditValue = HtmlEncode($this->PAID_VALUE->CurrentValue);
            $this->PAID_VALUE->PlaceHolder = RemoveHtml($this->PAID_VALUE->caption());
            if (strval($this->PAID_VALUE->EditValue) != "" && is_numeric($this->PAID_VALUE->EditValue)) {
                $this->PAID_VALUE->EditValue = FormatNumber($this->PAID_VALUE->EditValue, -2, -2, -2, -2);
            }

            // ISCETAK
            $this->ISCETAK->EditAttrs["class"] = "form-control";
            $this->ISCETAK->EditCustomAttributes = "";
            if (!$this->ISCETAK->Raw) {
                $this->ISCETAK->CurrentValue = HtmlDecode($this->ISCETAK->CurrentValue);
            }
            $this->ISCETAK->EditValue = HtmlEncode($this->ISCETAK->CurrentValue);
            $this->ISCETAK->PlaceHolder = RemoveHtml($this->ISCETAK->caption());

            // PRINT_DATE
            $this->PRINT_DATE->EditAttrs["class"] = "form-control";
            $this->PRINT_DATE->EditCustomAttributes = "";
            $this->PRINT_DATE->EditValue = HtmlEncode(FormatDateTime($this->PRINT_DATE->CurrentValue, 8));
            $this->PRINT_DATE->PlaceHolder = RemoveHtml($this->PRINT_DATE->caption());

            // PRINTED_BY
            $this->PRINTED_BY->EditAttrs["class"] = "form-control";
            $this->PRINTED_BY->EditCustomAttributes = "";
            if (!$this->PRINTED_BY->Raw) {
                $this->PRINTED_BY->CurrentValue = HtmlDecode($this->PRINTED_BY->CurrentValue);
            }
            $this->PRINTED_BY->EditValue = HtmlEncode($this->PRINTED_BY->CurrentValue);
            $this->PRINTED_BY->PlaceHolder = RemoveHtml($this->PRINTED_BY->caption());

            // PRINTQ
            $this->PRINTQ->EditAttrs["class"] = "form-control";
            $this->PRINTQ->EditCustomAttributes = "";
            $this->PRINTQ->EditValue = HtmlEncode($this->PRINTQ->CurrentValue);
            $this->PRINTQ->PlaceHolder = RemoveHtml($this->PRINTQ->caption());

            // FAKTUR_DATE
            $this->FAKTUR_DATE->EditAttrs["class"] = "form-control";
            $this->FAKTUR_DATE->EditCustomAttributes = "";
            $this->FAKTUR_DATE->EditValue = HtmlEncode(FormatDateTime($this->FAKTUR_DATE->CurrentValue, 8));
            $this->FAKTUR_DATE->PlaceHolder = RemoveHtml($this->FAKTUR_DATE->caption());

            // DISTRIBUTION_TYPE
            $this->DISTRIBUTION_TYPE->EditAttrs["class"] = "form-control";
            $this->DISTRIBUTION_TYPE->EditCustomAttributes = "";
            $this->DISTRIBUTION_TYPE->EditValue = HtmlEncode($this->DISTRIBUTION_TYPE->CurrentValue);
            $this->DISTRIBUTION_TYPE->PlaceHolder = RemoveHtml($this->DISTRIBUTION_TYPE->caption());

            // DISCOUNTOFF_VALUE
            $this->DISCOUNTOFF_VALUE->EditAttrs["class"] = "form-control";
            $this->DISCOUNTOFF_VALUE->EditCustomAttributes = "";
            $this->DISCOUNTOFF_VALUE->EditValue = HtmlEncode($this->DISCOUNTOFF_VALUE->CurrentValue);
            $this->DISCOUNTOFF_VALUE->PlaceHolder = RemoveHtml($this->DISCOUNTOFF_VALUE->caption());
            if (strval($this->DISCOUNTOFF_VALUE->EditValue) != "" && is_numeric($this->DISCOUNTOFF_VALUE->EditValue)) {
                $this->DISCOUNTOFF_VALUE->EditValue = FormatNumber($this->DISCOUNTOFF_VALUE->EditValue, -2, -2, -2, -2);
            }

            // THECOUNTER
            $this->THECOUNTER->EditAttrs["class"] = "form-control";
            $this->THECOUNTER->EditCustomAttributes = "";
            $this->THECOUNTER->EditValue = HtmlEncode($this->THECOUNTER->CurrentValue);
            $this->THECOUNTER->PlaceHolder = RemoveHtml($this->THECOUNTER->caption());

            // FUND_ID
            $this->FUND_ID->EditAttrs["class"] = "form-control";
            $this->FUND_ID->EditCustomAttributes = "";
            $this->FUND_ID->EditValue = HtmlEncode($this->FUND_ID->CurrentValue);
            $this->FUND_ID->PlaceHolder = RemoveHtml($this->FUND_ID->caption());

            // ORDER_BY
            $this->ORDER_BY->EditAttrs["class"] = "form-control";
            $this->ORDER_BY->EditCustomAttributes = "";
            if (!$this->ORDER_BY->Raw) {
                $this->ORDER_BY->CurrentValue = HtmlDecode($this->ORDER_BY->CurrentValue);
            }
            $this->ORDER_BY->EditValue = HtmlEncode($this->ORDER_BY->CurrentValue);
            $this->ORDER_BY->PlaceHolder = RemoveHtml($this->ORDER_BY->caption());

            // ACKNOWLEDGEBY
            $this->ACKNOWLEDGEBY->EditAttrs["class"] = "form-control";
            $this->ACKNOWLEDGEBY->EditCustomAttributes = "";
            if (!$this->ACKNOWLEDGEBY->Raw) {
                $this->ACKNOWLEDGEBY->CurrentValue = HtmlDecode($this->ACKNOWLEDGEBY->CurrentValue);
            }
            $this->ACKNOWLEDGEBY->EditValue = HtmlEncode($this->ACKNOWLEDGEBY->CurrentValue);
            $this->ACKNOWLEDGEBY->PlaceHolder = RemoveHtml($this->ACKNOWLEDGEBY->caption());

            // NUM
            $this->NUM->EditAttrs["class"] = "form-control";
            $this->NUM->EditCustomAttributes = "";
            $this->NUM->EditValue = HtmlEncode($this->NUM->CurrentValue);
            $this->NUM->PlaceHolder = RemoveHtml($this->NUM->caption());

            // ISPO
            $this->ISPO->EditAttrs["class"] = "form-control";
            $this->ISPO->EditCustomAttributes = "";
            if (!$this->ISPO->Raw) {
                $this->ISPO->CurrentValue = HtmlDecode($this->ISPO->CurrentValue);
            }
            $this->ISPO->EditValue = HtmlEncode($this->ISPO->CurrentValue);
            $this->ISPO->PlaceHolder = RemoveHtml($this->ISPO->caption());

            // DOCS_TYPE
            $this->DOCS_TYPE->EditAttrs["class"] = "form-control";
            $this->DOCS_TYPE->EditCustomAttributes = "";
            $this->DOCS_TYPE->EditValue = HtmlEncode($this->DOCS_TYPE->CurrentValue);
            $this->DOCS_TYPE->PlaceHolder = RemoveHtml($this->DOCS_TYPE->caption());

            // PO_DATE
            $this->PO_DATE->EditAttrs["class"] = "form-control";
            $this->PO_DATE->EditCustomAttributes = "";
            $this->PO_DATE->EditValue = HtmlEncode(FormatDateTime($this->PO_DATE->CurrentValue, 8));
            $this->PO_DATE->PlaceHolder = RemoveHtml($this->PO_DATE->caption());

            // PO_VALUE
            $this->PO_VALUE->EditAttrs["class"] = "form-control";
            $this->PO_VALUE->EditCustomAttributes = "";
            $this->PO_VALUE->EditValue = HtmlEncode($this->PO_VALUE->CurrentValue);
            $this->PO_VALUE->PlaceHolder = RemoveHtml($this->PO_VALUE->caption());
            if (strval($this->PO_VALUE->EditValue) != "" && is_numeric($this->PO_VALUE->EditValue)) {
                $this->PO_VALUE->EditValue = FormatNumber($this->PO_VALUE->EditValue, -2, -2, -2, -2);
            }

            // Add refer script

            // ORG_UNIT_CODE
            $this->ORG_UNIT_CODE->LinkCustomAttributes = "";
            $this->ORG_UNIT_CODE->HrefValue = "";

            // INVOICE_ID
            $this->INVOICE_ID->LinkCustomAttributes = "";
            $this->INVOICE_ID->HrefValue = "";

            // INVOICE_ID2
            $this->INVOICE_ID2->LinkCustomAttributes = "";
            $this->INVOICE_ID2->HrefValue = "";

            // INVOICE_DATE
            $this->INVOICE_DATE->LinkCustomAttributes = "";
            $this->INVOICE_DATE->HrefValue = "";

            // PO
            $this->PO->LinkCustomAttributes = "";
            $this->PO->HrefValue = "";

            // COMPANY_ID
            $this->COMPANY_ID->LinkCustomAttributes = "";
            $this->COMPANY_ID->HrefValue = "";

            // RECEIVED_DATE
            $this->RECEIVED_DATE->LinkCustomAttributes = "";
            $this->RECEIVED_DATE->HrefValue = "";

            // AMOUNT
            $this->AMOUNT->LinkCustomAttributes = "";
            $this->AMOUNT->HrefValue = "";

            // PAYMENT_DUE
            $this->PAYMENT_DUE->LinkCustomAttributes = "";
            $this->PAYMENT_DUE->HrefValue = "";

            // DESCRIPTION
            $this->DESCRIPTION->LinkCustomAttributes = "";
            $this->DESCRIPTION->HrefValue = "";

            // MODIFIED_DATE
            $this->MODIFIED_DATE->LinkCustomAttributes = "";
            $this->MODIFIED_DATE->HrefValue = "";

            // MODIFIED_BY
            $this->MODIFIED_BY->LinkCustomAttributes = "";
            $this->MODIFIED_BY->HrefValue = "";

            // RECEIVED_BY
            $this->RECEIVED_BY->LinkCustomAttributes = "";
            $this->RECEIVED_BY->HrefValue = "";

            // PRIORITY
            $this->PRIORITY->LinkCustomAttributes = "";
            $this->PRIORITY->HrefValue = "";

            // CREDIT_NOTE
            $this->CREDIT_NOTE->LinkCustomAttributes = "";
            $this->CREDIT_NOTE->HrefValue = "";

            // CREDIT_AMOUNT
            $this->CREDIT_AMOUNT->LinkCustomAttributes = "";
            $this->CREDIT_AMOUNT->HrefValue = "";

            // PPN
            $this->PPN->LinkCustomAttributes = "";
            $this->PPN->HrefValue = "";

            // MATERAI
            $this->MATERAI->LinkCustomAttributes = "";
            $this->MATERAI->HrefValue = "";

            // SENT_BY
            $this->SENT_BY->LinkCustomAttributes = "";
            $this->SENT_BY->HrefValue = "";

            // ACCOUNT_ID
            $this->ACCOUNT_ID->LinkCustomAttributes = "";
            $this->ACCOUNT_ID->HrefValue = "";

            // FINANCE_ID
            $this->FINANCE_ID->LinkCustomAttributes = "";
            $this->FINANCE_ID->HrefValue = "";

            // potongan
            $this->potongan->LinkCustomAttributes = "";
            $this->potongan->HrefValue = "";

            // RECEIVED_VALUE
            $this->RECEIVED_VALUE->LinkCustomAttributes = "";
            $this->RECEIVED_VALUE->HrefValue = "";

            // NO_ORDER
            $this->NO_ORDER->LinkCustomAttributes = "";
            $this->NO_ORDER->HrefValue = "";

            // CONTRACT_NO
            $this->CONTRACT_NO->LinkCustomAttributes = "";
            $this->CONTRACT_NO->HrefValue = "";

            // ORG_ID
            $this->ORG_ID->LinkCustomAttributes = "";
            $this->ORG_ID->HrefValue = "";

            // CLINIC_ID
            $this->CLINIC_ID->LinkCustomAttributes = "";
            $this->CLINIC_ID->HrefValue = "";

            // PPN_VALUE
            $this->PPN_VALUE->LinkCustomAttributes = "";
            $this->PPN_VALUE->HrefValue = "";

            // DISCOUNT_VALUE
            $this->DISCOUNT_VALUE->LinkCustomAttributes = "";
            $this->DISCOUNT_VALUE->HrefValue = "";

            // PAID_VALUE
            $this->PAID_VALUE->LinkCustomAttributes = "";
            $this->PAID_VALUE->HrefValue = "";

            // ISCETAK
            $this->ISCETAK->LinkCustomAttributes = "";
            $this->ISCETAK->HrefValue = "";

            // PRINT_DATE
            $this->PRINT_DATE->LinkCustomAttributes = "";
            $this->PRINT_DATE->HrefValue = "";

            // PRINTED_BY
            $this->PRINTED_BY->LinkCustomAttributes = "";
            $this->PRINTED_BY->HrefValue = "";

            // PRINTQ
            $this->PRINTQ->LinkCustomAttributes = "";
            $this->PRINTQ->HrefValue = "";

            // FAKTUR_DATE
            $this->FAKTUR_DATE->LinkCustomAttributes = "";
            $this->FAKTUR_DATE->HrefValue = "";

            // DISTRIBUTION_TYPE
            $this->DISTRIBUTION_TYPE->LinkCustomAttributes = "";
            $this->DISTRIBUTION_TYPE->HrefValue = "";

            // DISCOUNTOFF_VALUE
            $this->DISCOUNTOFF_VALUE->LinkCustomAttributes = "";
            $this->DISCOUNTOFF_VALUE->HrefValue = "";

            // THECOUNTER
            $this->THECOUNTER->LinkCustomAttributes = "";
            $this->THECOUNTER->HrefValue = "";

            // FUND_ID
            $this->FUND_ID->LinkCustomAttributes = "";
            $this->FUND_ID->HrefValue = "";

            // ORDER_BY
            $this->ORDER_BY->LinkCustomAttributes = "";
            $this->ORDER_BY->HrefValue = "";

            // ACKNOWLEDGEBY
            $this->ACKNOWLEDGEBY->LinkCustomAttributes = "";
            $this->ACKNOWLEDGEBY->HrefValue = "";

            // NUM
            $this->NUM->LinkCustomAttributes = "";
            $this->NUM->HrefValue = "";

            // ISPO
            $this->ISPO->LinkCustomAttributes = "";
            $this->ISPO->HrefValue = "";

            // DOCS_TYPE
            $this->DOCS_TYPE->LinkCustomAttributes = "";
            $this->DOCS_TYPE->HrefValue = "";

            // PO_DATE
            $this->PO_DATE->LinkCustomAttributes = "";
            $this->PO_DATE->HrefValue = "";

            // PO_VALUE
            $this->PO_VALUE->LinkCustomAttributes = "";
            $this->PO_VALUE->HrefValue = "";
        }
        if ($this->RowType == ROWTYPE_ADD || $this->RowType == ROWTYPE_EDIT || $this->RowType == ROWTYPE_SEARCH) { // Add/Edit/Search row
            $this->setupFieldTitles();
        }

        // Call Row Rendered event
        if ($this->RowType != ROWTYPE_AGGREGATEINIT) {
            $this->rowRendered();
        }
    }

    // Validate form
    protected function validateForm()
    {
        global $Language;

        // Check if validation required
        if (!Config("SERVER_VALIDATE")) {
            return true;
        }
        if ($this->ORG_UNIT_CODE->Required) {
            if (!$this->ORG_UNIT_CODE->IsDetailKey && EmptyValue($this->ORG_UNIT_CODE->FormValue)) {
                $this->ORG_UNIT_CODE->addErrorMessage(str_replace("%s", $this->ORG_UNIT_CODE->caption(), $this->ORG_UNIT_CODE->RequiredErrorMessage));
            }
        }
        if ($this->INVOICE_ID->Required) {
            if (!$this->INVOICE_ID->IsDetailKey && EmptyValue($this->INVOICE_ID->FormValue)) {
                $this->INVOICE_ID->addErrorMessage(str_replace("%s", $this->INVOICE_ID->caption(), $this->INVOICE_ID->RequiredErrorMessage));
            }
        }
        if ($this->INVOICE_ID2->Required) {
            if (!$this->INVOICE_ID2->IsDetailKey && EmptyValue($this->INVOICE_ID2->FormValue)) {
                $this->INVOICE_ID2->addErrorMessage(str_replace("%s", $this->INVOICE_ID2->caption(), $this->INVOICE_ID2->RequiredErrorMessage));
            }
        }
        if ($this->INVOICE_DATE->Required) {
            if (!$this->INVOICE_DATE->IsDetailKey && EmptyValue($this->INVOICE_DATE->FormValue)) {
                $this->INVOICE_DATE->addErrorMessage(str_replace("%s", $this->INVOICE_DATE->caption(), $this->INVOICE_DATE->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->INVOICE_DATE->FormValue)) {
            $this->INVOICE_DATE->addErrorMessage($this->INVOICE_DATE->getErrorMessage(false));
        }
        if ($this->PO->Required) {
            if (!$this->PO->IsDetailKey && EmptyValue($this->PO->FormValue)) {
                $this->PO->addErrorMessage(str_replace("%s", $this->PO->caption(), $this->PO->RequiredErrorMessage));
            }
        }
        if ($this->COMPANY_ID->Required) {
            if (!$this->COMPANY_ID->IsDetailKey && EmptyValue($this->COMPANY_ID->FormValue)) {
                $this->COMPANY_ID->addErrorMessage(str_replace("%s", $this->COMPANY_ID->caption(), $this->COMPANY_ID->RequiredErrorMessage));
            }
        }
        if ($this->RECEIVED_DATE->Required) {
            if (!$this->RECEIVED_DATE->IsDetailKey && EmptyValue($this->RECEIVED_DATE->FormValue)) {
                $this->RECEIVED_DATE->addErrorMessage(str_replace("%s", $this->RECEIVED_DATE->caption(), $this->RECEIVED_DATE->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->RECEIVED_DATE->FormValue)) {
            $this->RECEIVED_DATE->addErrorMessage($this->RECEIVED_DATE->getErrorMessage(false));
        }
        if ($this->AMOUNT->Required) {
            if (!$this->AMOUNT->IsDetailKey && EmptyValue($this->AMOUNT->FormValue)) {
                $this->AMOUNT->addErrorMessage(str_replace("%s", $this->AMOUNT->caption(), $this->AMOUNT->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->AMOUNT->FormValue)) {
            $this->AMOUNT->addErrorMessage($this->AMOUNT->getErrorMessage(false));
        }
        if ($this->PAYMENT_DUE->Required) {
            if (!$this->PAYMENT_DUE->IsDetailKey && EmptyValue($this->PAYMENT_DUE->FormValue)) {
                $this->PAYMENT_DUE->addErrorMessage(str_replace("%s", $this->PAYMENT_DUE->caption(), $this->PAYMENT_DUE->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->PAYMENT_DUE->FormValue)) {
            $this->PAYMENT_DUE->addErrorMessage($this->PAYMENT_DUE->getErrorMessage(false));
        }
        if ($this->DESCRIPTION->Required) {
            if (!$this->DESCRIPTION->IsDetailKey && EmptyValue($this->DESCRIPTION->FormValue)) {
                $this->DESCRIPTION->addErrorMessage(str_replace("%s", $this->DESCRIPTION->caption(), $this->DESCRIPTION->RequiredErrorMessage));
            }
        }
        if ($this->MODIFIED_DATE->Required) {
            if (!$this->MODIFIED_DATE->IsDetailKey && EmptyValue($this->MODIFIED_DATE->FormValue)) {
                $this->MODIFIED_DATE->addErrorMessage(str_replace("%s", $this->MODIFIED_DATE->caption(), $this->MODIFIED_DATE->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->MODIFIED_DATE->FormValue)) {
            $this->MODIFIED_DATE->addErrorMessage($this->MODIFIED_DATE->getErrorMessage(false));
        }
        if ($this->MODIFIED_BY->Required) {
            if (!$this->MODIFIED_BY->IsDetailKey && EmptyValue($this->MODIFIED_BY->FormValue)) {
                $this->MODIFIED_BY->addErrorMessage(str_replace("%s", $this->MODIFIED_BY->caption(), $this->MODIFIED_BY->RequiredErrorMessage));
            }
        }
        if ($this->RECEIVED_BY->Required) {
            if (!$this->RECEIVED_BY->IsDetailKey && EmptyValue($this->RECEIVED_BY->FormValue)) {
                $this->RECEIVED_BY->addErrorMessage(str_replace("%s", $this->RECEIVED_BY->caption(), $this->RECEIVED_BY->RequiredErrorMessage));
            }
        }
        if ($this->PRIORITY->Required) {
            if (!$this->PRIORITY->IsDetailKey && EmptyValue($this->PRIORITY->FormValue)) {
                $this->PRIORITY->addErrorMessage(str_replace("%s", $this->PRIORITY->caption(), $this->PRIORITY->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->PRIORITY->FormValue)) {
            $this->PRIORITY->addErrorMessage($this->PRIORITY->getErrorMessage(false));
        }
        if ($this->CREDIT_NOTE->Required) {
            if (!$this->CREDIT_NOTE->IsDetailKey && EmptyValue($this->CREDIT_NOTE->FormValue)) {
                $this->CREDIT_NOTE->addErrorMessage(str_replace("%s", $this->CREDIT_NOTE->caption(), $this->CREDIT_NOTE->RequiredErrorMessage));
            }
        }
        if ($this->CREDIT_AMOUNT->Required) {
            if (!$this->CREDIT_AMOUNT->IsDetailKey && EmptyValue($this->CREDIT_AMOUNT->FormValue)) {
                $this->CREDIT_AMOUNT->addErrorMessage(str_replace("%s", $this->CREDIT_AMOUNT->caption(), $this->CREDIT_AMOUNT->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->CREDIT_AMOUNT->FormValue)) {
            $this->CREDIT_AMOUNT->addErrorMessage($this->CREDIT_AMOUNT->getErrorMessage(false));
        }
        if ($this->PPN->Required) {
            if (!$this->PPN->IsDetailKey && EmptyValue($this->PPN->FormValue)) {
                $this->PPN->addErrorMessage(str_replace("%s", $this->PPN->caption(), $this->PPN->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->PPN->FormValue)) {
            $this->PPN->addErrorMessage($this->PPN->getErrorMessage(false));
        }
        if ($this->MATERAI->Required) {
            if (!$this->MATERAI->IsDetailKey && EmptyValue($this->MATERAI->FormValue)) {
                $this->MATERAI->addErrorMessage(str_replace("%s", $this->MATERAI->caption(), $this->MATERAI->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->MATERAI->FormValue)) {
            $this->MATERAI->addErrorMessage($this->MATERAI->getErrorMessage(false));
        }
        if ($this->SENT_BY->Required) {
            if (!$this->SENT_BY->IsDetailKey && EmptyValue($this->SENT_BY->FormValue)) {
                $this->SENT_BY->addErrorMessage(str_replace("%s", $this->SENT_BY->caption(), $this->SENT_BY->RequiredErrorMessage));
            }
        }
        if ($this->ACCOUNT_ID->Required) {
            if (!$this->ACCOUNT_ID->IsDetailKey && EmptyValue($this->ACCOUNT_ID->FormValue)) {
                $this->ACCOUNT_ID->addErrorMessage(str_replace("%s", $this->ACCOUNT_ID->caption(), $this->ACCOUNT_ID->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->ACCOUNT_ID->FormValue)) {
            $this->ACCOUNT_ID->addErrorMessage($this->ACCOUNT_ID->getErrorMessage(false));
        }
        if ($this->FINANCE_ID->Required) {
            if (!$this->FINANCE_ID->IsDetailKey && EmptyValue($this->FINANCE_ID->FormValue)) {
                $this->FINANCE_ID->addErrorMessage(str_replace("%s", $this->FINANCE_ID->caption(), $this->FINANCE_ID->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->FINANCE_ID->FormValue)) {
            $this->FINANCE_ID->addErrorMessage($this->FINANCE_ID->getErrorMessage(false));
        }
        if ($this->potongan->Required) {
            if (!$this->potongan->IsDetailKey && EmptyValue($this->potongan->FormValue)) {
                $this->potongan->addErrorMessage(str_replace("%s", $this->potongan->caption(), $this->potongan->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->potongan->FormValue)) {
            $this->potongan->addErrorMessage($this->potongan->getErrorMessage(false));
        }
        if ($this->RECEIVED_VALUE->Required) {
            if (!$this->RECEIVED_VALUE->IsDetailKey && EmptyValue($this->RECEIVED_VALUE->FormValue)) {
                $this->RECEIVED_VALUE->addErrorMessage(str_replace("%s", $this->RECEIVED_VALUE->caption(), $this->RECEIVED_VALUE->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->RECEIVED_VALUE->FormValue)) {
            $this->RECEIVED_VALUE->addErrorMessage($this->RECEIVED_VALUE->getErrorMessage(false));
        }
        if ($this->NO_ORDER->Required) {
            if (!$this->NO_ORDER->IsDetailKey && EmptyValue($this->NO_ORDER->FormValue)) {
                $this->NO_ORDER->addErrorMessage(str_replace("%s", $this->NO_ORDER->caption(), $this->NO_ORDER->RequiredErrorMessage));
            }
        }
        if ($this->CONTRACT_NO->Required) {
            if (!$this->CONTRACT_NO->IsDetailKey && EmptyValue($this->CONTRACT_NO->FormValue)) {
                $this->CONTRACT_NO->addErrorMessage(str_replace("%s", $this->CONTRACT_NO->caption(), $this->CONTRACT_NO->RequiredErrorMessage));
            }
        }
        if ($this->ORG_ID->Required) {
            if (!$this->ORG_ID->IsDetailKey && EmptyValue($this->ORG_ID->FormValue)) {
                $this->ORG_ID->addErrorMessage(str_replace("%s", $this->ORG_ID->caption(), $this->ORG_ID->RequiredErrorMessage));
            }
        }
        if ($this->CLINIC_ID->Required) {
            if (!$this->CLINIC_ID->IsDetailKey && EmptyValue($this->CLINIC_ID->FormValue)) {
                $this->CLINIC_ID->addErrorMessage(str_replace("%s", $this->CLINIC_ID->caption(), $this->CLINIC_ID->RequiredErrorMessage));
            }
        }
        if ($this->PPN_VALUE->Required) {
            if (!$this->PPN_VALUE->IsDetailKey && EmptyValue($this->PPN_VALUE->FormValue)) {
                $this->PPN_VALUE->addErrorMessage(str_replace("%s", $this->PPN_VALUE->caption(), $this->PPN_VALUE->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->PPN_VALUE->FormValue)) {
            $this->PPN_VALUE->addErrorMessage($this->PPN_VALUE->getErrorMessage(false));
        }
        if ($this->DISCOUNT_VALUE->Required) {
            if (!$this->DISCOUNT_VALUE->IsDetailKey && EmptyValue($this->DISCOUNT_VALUE->FormValue)) {
                $this->DISCOUNT_VALUE->addErrorMessage(str_replace("%s", $this->DISCOUNT_VALUE->caption(), $this->DISCOUNT_VALUE->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->DISCOUNT_VALUE->FormValue)) {
            $this->DISCOUNT_VALUE->addErrorMessage($this->DISCOUNT_VALUE->getErrorMessage(false));
        }
        if ($this->PAID_VALUE->Required) {
            if (!$this->PAID_VALUE->IsDetailKey && EmptyValue($this->PAID_VALUE->FormValue)) {
                $this->PAID_VALUE->addErrorMessage(str_replace("%s", $this->PAID_VALUE->caption(), $this->PAID_VALUE->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->PAID_VALUE->FormValue)) {
            $this->PAID_VALUE->addErrorMessage($this->PAID_VALUE->getErrorMessage(false));
        }
        if ($this->ISCETAK->Required) {
            if (!$this->ISCETAK->IsDetailKey && EmptyValue($this->ISCETAK->FormValue)) {
                $this->ISCETAK->addErrorMessage(str_replace("%s", $this->ISCETAK->caption(), $this->ISCETAK->RequiredErrorMessage));
            }
        }
        if ($this->PRINT_DATE->Required) {
            if (!$this->PRINT_DATE->IsDetailKey && EmptyValue($this->PRINT_DATE->FormValue)) {
                $this->PRINT_DATE->addErrorMessage(str_replace("%s", $this->PRINT_DATE->caption(), $this->PRINT_DATE->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->PRINT_DATE->FormValue)) {
            $this->PRINT_DATE->addErrorMessage($this->PRINT_DATE->getErrorMessage(false));
        }
        if ($this->PRINTED_BY->Required) {
            if (!$this->PRINTED_BY->IsDetailKey && EmptyValue($this->PRINTED_BY->FormValue)) {
                $this->PRINTED_BY->addErrorMessage(str_replace("%s", $this->PRINTED_BY->caption(), $this->PRINTED_BY->RequiredErrorMessage));
            }
        }
        if ($this->PRINTQ->Required) {
            if (!$this->PRINTQ->IsDetailKey && EmptyValue($this->PRINTQ->FormValue)) {
                $this->PRINTQ->addErrorMessage(str_replace("%s", $this->PRINTQ->caption(), $this->PRINTQ->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->PRINTQ->FormValue)) {
            $this->PRINTQ->addErrorMessage($this->PRINTQ->getErrorMessage(false));
        }
        if ($this->FAKTUR_DATE->Required) {
            if (!$this->FAKTUR_DATE->IsDetailKey && EmptyValue($this->FAKTUR_DATE->FormValue)) {
                $this->FAKTUR_DATE->addErrorMessage(str_replace("%s", $this->FAKTUR_DATE->caption(), $this->FAKTUR_DATE->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->FAKTUR_DATE->FormValue)) {
            $this->FAKTUR_DATE->addErrorMessage($this->FAKTUR_DATE->getErrorMessage(false));
        }
        if ($this->DISTRIBUTION_TYPE->Required) {
            if (!$this->DISTRIBUTION_TYPE->IsDetailKey && EmptyValue($this->DISTRIBUTION_TYPE->FormValue)) {
                $this->DISTRIBUTION_TYPE->addErrorMessage(str_replace("%s", $this->DISTRIBUTION_TYPE->caption(), $this->DISTRIBUTION_TYPE->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->DISTRIBUTION_TYPE->FormValue)) {
            $this->DISTRIBUTION_TYPE->addErrorMessage($this->DISTRIBUTION_TYPE->getErrorMessage(false));
        }
        if ($this->DISCOUNTOFF_VALUE->Required) {
            if (!$this->DISCOUNTOFF_VALUE->IsDetailKey && EmptyValue($this->DISCOUNTOFF_VALUE->FormValue)) {
                $this->DISCOUNTOFF_VALUE->addErrorMessage(str_replace("%s", $this->DISCOUNTOFF_VALUE->caption(), $this->DISCOUNTOFF_VALUE->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->DISCOUNTOFF_VALUE->FormValue)) {
            $this->DISCOUNTOFF_VALUE->addErrorMessage($this->DISCOUNTOFF_VALUE->getErrorMessage(false));
        }
        if ($this->THECOUNTER->Required) {
            if (!$this->THECOUNTER->IsDetailKey && EmptyValue($this->THECOUNTER->FormValue)) {
                $this->THECOUNTER->addErrorMessage(str_replace("%s", $this->THECOUNTER->caption(), $this->THECOUNTER->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->THECOUNTER->FormValue)) {
            $this->THECOUNTER->addErrorMessage($this->THECOUNTER->getErrorMessage(false));
        }
        if ($this->FUND_ID->Required) {
            if (!$this->FUND_ID->IsDetailKey && EmptyValue($this->FUND_ID->FormValue)) {
                $this->FUND_ID->addErrorMessage(str_replace("%s", $this->FUND_ID->caption(), $this->FUND_ID->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->FUND_ID->FormValue)) {
            $this->FUND_ID->addErrorMessage($this->FUND_ID->getErrorMessage(false));
        }
        if ($this->ORDER_BY->Required) {
            if (!$this->ORDER_BY->IsDetailKey && EmptyValue($this->ORDER_BY->FormValue)) {
                $this->ORDER_BY->addErrorMessage(str_replace("%s", $this->ORDER_BY->caption(), $this->ORDER_BY->RequiredErrorMessage));
            }
        }
        if ($this->ACKNOWLEDGEBY->Required) {
            if (!$this->ACKNOWLEDGEBY->IsDetailKey && EmptyValue($this->ACKNOWLEDGEBY->FormValue)) {
                $this->ACKNOWLEDGEBY->addErrorMessage(str_replace("%s", $this->ACKNOWLEDGEBY->caption(), $this->ACKNOWLEDGEBY->RequiredErrorMessage));
            }
        }
        if ($this->NUM->Required) {
            if (!$this->NUM->IsDetailKey && EmptyValue($this->NUM->FormValue)) {
                $this->NUM->addErrorMessage(str_replace("%s", $this->NUM->caption(), $this->NUM->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->NUM->FormValue)) {
            $this->NUM->addErrorMessage($this->NUM->getErrorMessage(false));
        }
        if ($this->ISPO->Required) {
            if (!$this->ISPO->IsDetailKey && EmptyValue($this->ISPO->FormValue)) {
                $this->ISPO->addErrorMessage(str_replace("%s", $this->ISPO->caption(), $this->ISPO->RequiredErrorMessage));
            }
        }
        if ($this->DOCS_TYPE->Required) {
            if (!$this->DOCS_TYPE->IsDetailKey && EmptyValue($this->DOCS_TYPE->FormValue)) {
                $this->DOCS_TYPE->addErrorMessage(str_replace("%s", $this->DOCS_TYPE->caption(), $this->DOCS_TYPE->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->DOCS_TYPE->FormValue)) {
            $this->DOCS_TYPE->addErrorMessage($this->DOCS_TYPE->getErrorMessage(false));
        }
        if ($this->PO_DATE->Required) {
            if (!$this->PO_DATE->IsDetailKey && EmptyValue($this->PO_DATE->FormValue)) {
                $this->PO_DATE->addErrorMessage(str_replace("%s", $this->PO_DATE->caption(), $this->PO_DATE->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->PO_DATE->FormValue)) {
            $this->PO_DATE->addErrorMessage($this->PO_DATE->getErrorMessage(false));
        }
        if ($this->PO_VALUE->Required) {
            if (!$this->PO_VALUE->IsDetailKey && EmptyValue($this->PO_VALUE->FormValue)) {
                $this->PO_VALUE->addErrorMessage(str_replace("%s", $this->PO_VALUE->caption(), $this->PO_VALUE->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->PO_VALUE->FormValue)) {
            $this->PO_VALUE->addErrorMessage($this->PO_VALUE->getErrorMessage(false));
        }

        // Return validate result
        $validateForm = !$this->hasInvalidFields();

        // Call Form_CustomValidate event
        $formCustomError = "";
        $validateForm = $validateForm && $this->formCustomValidate($formCustomError);
        if ($formCustomError != "") {
            $this->setFailureMessage($formCustomError);
        }
        return $validateForm;
    }

    // Add record
    protected function addRow($rsold = null)
    {
        global $Language, $Security;
        if ($this->INVOICE_ID->CurrentValue != "") { // Check field with unique index
            $filter = "([INVOICE_ID] = '" . AdjustSql($this->INVOICE_ID->CurrentValue, $this->Dbid) . "')";
            $rsChk = $this->loadRs($filter)->fetch();
            if ($rsChk !== false) {
                $idxErrMsg = str_replace("%f", $this->INVOICE_ID->caption(), $Language->phrase("DupIndex"));
                $idxErrMsg = str_replace("%v", $this->INVOICE_ID->CurrentValue, $idxErrMsg);
                $this->setFailureMessage($idxErrMsg);
                return false;
            }
        }
        $conn = $this->getConnection();

        // Load db values from rsold
        $this->loadDbValues($rsold);
        if ($rsold) {
        }
        $rsnew = [];

        // ORG_UNIT_CODE
        $this->ORG_UNIT_CODE->setDbValueDef($rsnew, $this->ORG_UNIT_CODE->CurrentValue, "", false);

        // INVOICE_ID
        $this->INVOICE_ID->setDbValueDef($rsnew, $this->INVOICE_ID->CurrentValue, "", strval($this->INVOICE_ID->CurrentValue) == "");

        // INVOICE_ID2
        $this->INVOICE_ID2->setDbValueDef($rsnew, $this->INVOICE_ID2->CurrentValue, null, false);

        // INVOICE_DATE
        $this->INVOICE_DATE->setDbValueDef($rsnew, UnFormatDateTime($this->INVOICE_DATE->CurrentValue, 0), null, false);

        // PO
        $this->PO->setDbValueDef($rsnew, $this->PO->CurrentValue, null, false);

        // COMPANY_ID
        $this->COMPANY_ID->setDbValueDef($rsnew, $this->COMPANY_ID->CurrentValue, null, false);

        // RECEIVED_DATE
        $this->RECEIVED_DATE->setDbValueDef($rsnew, UnFormatDateTime($this->RECEIVED_DATE->CurrentValue, 0), null, false);

        // AMOUNT
        $this->AMOUNT->setDbValueDef($rsnew, $this->AMOUNT->CurrentValue, null, false);

        // PAYMENT_DUE
        $this->PAYMENT_DUE->setDbValueDef($rsnew, UnFormatDateTime($this->PAYMENT_DUE->CurrentValue, 0), null, false);

        // DESCRIPTION
        $this->DESCRIPTION->setDbValueDef($rsnew, $this->DESCRIPTION->CurrentValue, null, false);

        // MODIFIED_DATE
        $this->MODIFIED_DATE->setDbValueDef($rsnew, UnFormatDateTime($this->MODIFIED_DATE->CurrentValue, 0), null, false);

        // MODIFIED_BY
        $this->MODIFIED_BY->setDbValueDef($rsnew, $this->MODIFIED_BY->CurrentValue, null, false);

        // RECEIVED_BY
        $this->RECEIVED_BY->setDbValueDef($rsnew, $this->RECEIVED_BY->CurrentValue, null, false);

        // PRIORITY
        $this->PRIORITY->setDbValueDef($rsnew, $this->PRIORITY->CurrentValue, null, false);

        // CREDIT_NOTE
        $this->CREDIT_NOTE->setDbValueDef($rsnew, $this->CREDIT_NOTE->CurrentValue, null, false);

        // CREDIT_AMOUNT
        $this->CREDIT_AMOUNT->setDbValueDef($rsnew, $this->CREDIT_AMOUNT->CurrentValue, null, false);

        // PPN
        $this->PPN->setDbValueDef($rsnew, $this->PPN->CurrentValue, null, false);

        // MATERAI
        $this->MATERAI->setDbValueDef($rsnew, $this->MATERAI->CurrentValue, null, false);

        // SENT_BY
        $this->SENT_BY->setDbValueDef($rsnew, $this->SENT_BY->CurrentValue, null, false);

        // ACCOUNT_ID
        $this->ACCOUNT_ID->setDbValueDef($rsnew, $this->ACCOUNT_ID->CurrentValue, null, false);

        // FINANCE_ID
        $this->FINANCE_ID->setDbValueDef($rsnew, $this->FINANCE_ID->CurrentValue, null, false);

        // potongan
        $this->potongan->setDbValueDef($rsnew, $this->potongan->CurrentValue, null, false);

        // RECEIVED_VALUE
        $this->RECEIVED_VALUE->setDbValueDef($rsnew, $this->RECEIVED_VALUE->CurrentValue, null, false);

        // NO_ORDER
        $this->NO_ORDER->setDbValueDef($rsnew, $this->NO_ORDER->CurrentValue, null, false);

        // CONTRACT_NO
        $this->CONTRACT_NO->setDbValueDef($rsnew, $this->CONTRACT_NO->CurrentValue, null, false);

        // ORG_ID
        $this->ORG_ID->setDbValueDef($rsnew, $this->ORG_ID->CurrentValue, null, false);

        // CLINIC_ID
        $this->CLINIC_ID->setDbValueDef($rsnew, $this->CLINIC_ID->CurrentValue, null, false);

        // PPN_VALUE
        $this->PPN_VALUE->setDbValueDef($rsnew, $this->PPN_VALUE->CurrentValue, null, false);

        // DISCOUNT_VALUE
        $this->DISCOUNT_VALUE->setDbValueDef($rsnew, $this->DISCOUNT_VALUE->CurrentValue, null, false);

        // PAID_VALUE
        $this->PAID_VALUE->setDbValueDef($rsnew, $this->PAID_VALUE->CurrentValue, null, false);

        // ISCETAK
        $this->ISCETAK->setDbValueDef($rsnew, $this->ISCETAK->CurrentValue, null, false);

        // PRINT_DATE
        $this->PRINT_DATE->setDbValueDef($rsnew, UnFormatDateTime($this->PRINT_DATE->CurrentValue, 0), null, false);

        // PRINTED_BY
        $this->PRINTED_BY->setDbValueDef($rsnew, $this->PRINTED_BY->CurrentValue, null, false);

        // PRINTQ
        $this->PRINTQ->setDbValueDef($rsnew, $this->PRINTQ->CurrentValue, null, false);

        // FAKTUR_DATE
        $this->FAKTUR_DATE->setDbValueDef($rsnew, UnFormatDateTime($this->FAKTUR_DATE->CurrentValue, 0), null, false);

        // DISTRIBUTION_TYPE
        $this->DISTRIBUTION_TYPE->setDbValueDef($rsnew, $this->DISTRIBUTION_TYPE->CurrentValue, null, false);

        // DISCOUNTOFF_VALUE
        $this->DISCOUNTOFF_VALUE->setDbValueDef($rsnew, $this->DISCOUNTOFF_VALUE->CurrentValue, null, false);

        // THECOUNTER
        $this->THECOUNTER->setDbValueDef($rsnew, $this->THECOUNTER->CurrentValue, null, false);

        // FUND_ID
        $this->FUND_ID->setDbValueDef($rsnew, $this->FUND_ID->CurrentValue, null, false);

        // ORDER_BY
        $this->ORDER_BY->setDbValueDef($rsnew, $this->ORDER_BY->CurrentValue, null, false);

        // ACKNOWLEDGEBY
        $this->ACKNOWLEDGEBY->setDbValueDef($rsnew, $this->ACKNOWLEDGEBY->CurrentValue, null, false);

        // NUM
        $this->NUM->setDbValueDef($rsnew, $this->NUM->CurrentValue, null, false);

        // ISPO
        $this->ISPO->setDbValueDef($rsnew, $this->ISPO->CurrentValue, null, false);

        // DOCS_TYPE
        $this->DOCS_TYPE->setDbValueDef($rsnew, $this->DOCS_TYPE->CurrentValue, null, false);

        // PO_DATE
        $this->PO_DATE->setDbValueDef($rsnew, UnFormatDateTime($this->PO_DATE->CurrentValue, 0), null, false);

        // PO_VALUE
        $this->PO_VALUE->setDbValueDef($rsnew, $this->PO_VALUE->CurrentValue, null, strval($this->PO_VALUE->CurrentValue) == "");

        // Call Row Inserting event
        $insertRow = $this->rowInserting($rsold, $rsnew);

        // Check if key value entered
        if ($insertRow && $this->ValidateKey && strval($rsnew['INVOICE_ID']) == "") {
            $this->setFailureMessage($Language->phrase("InvalidKeyValue"));
            $insertRow = false;
        }

        // Check for duplicate key
        if ($insertRow && $this->ValidateKey) {
            $filter = $this->getRecordFilter($rsnew);
            $rsChk = $this->loadRs($filter)->fetch();
            if ($rsChk !== false) {
                $keyErrMsg = str_replace("%f", $filter, $Language->phrase("DupKey"));
                $this->setFailureMessage($keyErrMsg);
                $insertRow = false;
            }
        }
        $addRow = false;
        if ($insertRow) {
            try {
                $addRow = $this->insert($rsnew);
            } catch (\Exception $e) {
                $this->setFailureMessage($e->getMessage());
            }
            if ($addRow) {
            }
        } else {
            if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                // Use the message, do nothing
            } elseif ($this->CancelMessage != "") {
                $this->setFailureMessage($this->CancelMessage);
                $this->CancelMessage = "";
            } else {
                $this->setFailureMessage($Language->phrase("InsertCancelled"));
            }
            $addRow = false;
        }
        if ($addRow) {
            // Call Row Inserted event
            $this->rowInserted($rsold, $rsnew);
        }

        // Clean upload path if any
        if ($addRow) {
        }

        // Write JSON for API request
        if (IsApi() && $addRow) {
            $row = $this->getRecordsFromRecordset([$rsnew], true);
            WriteJson(["success" => true, $this->TableVar => $row]);
        }
        return $addRow;
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("PoInvoiceList"), "", $this->TableVar, true);
        $pageId = ($this->isCopy()) ? "Copy" : "Add";
        $Breadcrumb->add("add", $pageId, $url);
    }

    // Setup lookup options
    public function setupLookupOptions($fld)
    {
        if ($fld->Lookup !== null && $fld->Lookup->Options === null) {
            // Get default connection and filter
            $conn = $this->getConnection();
            $lookupFilter = "";

            // No need to check any more
            $fld->Lookup->Options = [];

            // Set up lookup SQL and connection
            switch ($fld->FieldVar) {
                default:
                    $lookupFilter = "";
                    break;
            }

            // Always call to Lookup->getSql so that user can setup Lookup->Options in Lookup_Selecting server event
            $sql = $fld->Lookup->getSql(false, "", $lookupFilter, $this);

            // Set up lookup cache
            if ($fld->UseLookupCache && $sql != "" && count($fld->Lookup->Options) == 0) {
                $totalCnt = $this->getRecordCount($sql, $conn);
                if ($totalCnt > $fld->LookupCacheCount) { // Total count > cache count, do not cache
                    return;
                }
                $rows = $conn->executeQuery($sql)->fetchAll(\PDO::FETCH_BOTH);
                $ar = [];
                foreach ($rows as $row) {
                    $row = $fld->Lookup->renderViewRow($row);
                    $ar[strval($row[0])] = $row;
                }
                $fld->Lookup->Options = $ar;
            }
        }
    }

    // Page Load event
    public function pageLoad()
    {
        //Log("Page Load");
    }

    // Page Unload event
    public function pageUnload()
    {
        //Log("Page Unload");
    }

    // Page Redirecting event
    public function pageRedirecting(&$url)
    {
        // Example:
        //$url = "your URL";
    }

    // Message Showing event
    // $type = ''|'success'|'failure'|'warning'
    public function messageShowing(&$msg, $type)
    {
        if ($type == 'success') {
            //$msg = "your success message";
        } elseif ($type == 'failure') {
            //$msg = "your failure message";
        } elseif ($type == 'warning') {
            //$msg = "your warning message";
        } else {
            //$msg = "your message";
        }
    }

    // Page Render event
    public function pageRender()
    {
        //Log("Page Render");
    }

    // Page Data Rendering event
    public function pageDataRendering(&$header)
    {
        // Example:
        //$header = "your header";
    }

    // Page Data Rendered event
    public function pageDataRendered(&$footer)
    {
        // Example:
        //$footer = "your footer";
    }

    // Form Custom Validate event
    public function formCustomValidate(&$customError)
    {
        // Return error message in CustomError
        return true;
    }
}
