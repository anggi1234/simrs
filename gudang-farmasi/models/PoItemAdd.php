<?php

namespace PHPMaker2021\SIMRSSQLSERVERGUDANGFARMASI;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class PoItemAdd extends PoItem
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'PO_ITEM';

    // Page object name
    public $PageObjName = "PoItemAdd";

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

        // Table object (PO_ITEM)
        if (!isset($GLOBALS["PO_ITEM"]) || get_class($GLOBALS["PO_ITEM"]) == PROJECT_NAMESPACE . "PO_ITEM") {
            $GLOBALS["PO_ITEM"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'PO_ITEM');
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
                $doc = new $class(Container("PO_ITEM"));
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
                    if ($pageName == "PoItemView") {
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
            $key .= @$ar['ORG_UNIT_CODE'] . Config("COMPOSITE_KEY_SEPARATOR");
            $key .= @$ar['PO'] . Config("COMPOSITE_KEY_SEPARATOR");
            $key .= @$ar['BRAND_ID'];
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
        if ($this->isAddOrEdit()) {
            $this->IDX->Visible = false;
        }
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
        $this->PO->setVisibility();
        $this->BRAND_ID->setVisibility();
        $this->ORDER_DATE->setVisibility();
        $this->PO_NO->setVisibility();
        $this->PURCHASE_PRICE->setVisibility();
        $this->ORDER_QUANTITY->setVisibility();
        $this->RECEIVED_QUANTITY->setVisibility();
        $this->MEASURE_ID->setVisibility();
        $this->DISCOUNT->setVisibility();
        $this->AMOUNT_PAID->setVisibility();
        $this->ATP_DATE->setVisibility();
        $this->DELIVERY_DATE->setVisibility();
        $this->DESCRIPTION->setVisibility();
        $this->MODIFIED_DATE->setVisibility();
        $this->MODIFIED_BY->setVisibility();
        $this->company_id->setVisibility();
        $this->SIZE_KEMASAN->setVisibility();
        $this->MEASURE_ID2->setVisibility();
        $this->SIZE_GOODS->setVisibility();
        $this->MEASURE_DOSIS->setVisibility();
        $this->QUANTITY->setVisibility();
        $this->MEASURE_ID3->setVisibility();
        $this->ORDER_PRICE->setVisibility();
        $this->BRAND_NAME->setVisibility();
        $this->ISCETAK->setVisibility();
        $this->PRINT_DATE->setVisibility();
        $this->PRINTED_BY->setVisibility();
        $this->PRINTQ->setVisibility();
        $this->DISCOUNTOFF->setVisibility();
        $this->IDX->Visible = false;
        $this->QUANTITY0->setVisibility();
        $this->PROPOSEDQ->setVisibility();
        $this->STOCKQ->setVisibility();
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
            if (($keyValue = Get("ORG_UNIT_CODE") ?? Route("ORG_UNIT_CODE")) !== null) {
                $this->ORG_UNIT_CODE->setQueryStringValue($keyValue);
            }
            if (($keyValue = Get("PO") ?? Route("PO")) !== null) {
                $this->PO->setQueryStringValue($keyValue);
            }
            if (($keyValue = Get("BRAND_ID") ?? Route("BRAND_ID")) !== null) {
                $this->BRAND_ID->setQueryStringValue($keyValue);
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
                    $this->terminate("PoItemList"); // No matching record, return to list
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
                    if (GetPageName($returnUrl) == "PoItemList") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "PoItemView") {
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
        $this->PO->CurrentValue = "(((CONVERT([varchar](4),datepart(year,getdate()),(0))+right(CONVERT([varchar](4),datepart(month,getdate())+(100),(0)),(2)))+right(CONVERT([varchar](3),datepart(day,getdate())+(100),(0)),(2)))+right(CONVERT([varchar](3),datepart(hour,getdate())+(100),(0)),(2)))+right(CONVERT([varchar](3),datepart(minute,getdate())+(100),(0)),(2)))+right(CONVERT([varchar](3),datepart(second,getdate())+(100),(0)),(2)))+left(newid(),(7";
        $this->BRAND_ID->CurrentValue = null;
        $this->BRAND_ID->OldValue = $this->BRAND_ID->CurrentValue;
        $this->ORDER_DATE->CurrentValue = null;
        $this->ORDER_DATE->OldValue = $this->ORDER_DATE->CurrentValue;
        $this->PO_NO->CurrentValue = null;
        $this->PO_NO->OldValue = $this->PO_NO->CurrentValue;
        $this->PURCHASE_PRICE->CurrentValue = null;
        $this->PURCHASE_PRICE->OldValue = $this->PURCHASE_PRICE->CurrentValue;
        $this->ORDER_QUANTITY->CurrentValue = 1;
        $this->RECEIVED_QUANTITY->CurrentValue = null;
        $this->RECEIVED_QUANTITY->OldValue = $this->RECEIVED_QUANTITY->CurrentValue;
        $this->MEASURE_ID->CurrentValue = 3;
        $this->DISCOUNT->CurrentValue = 0;
        $this->AMOUNT_PAID->CurrentValue = null;
        $this->AMOUNT_PAID->OldValue = $this->AMOUNT_PAID->CurrentValue;
        $this->ATP_DATE->CurrentValue = null;
        $this->ATP_DATE->OldValue = $this->ATP_DATE->CurrentValue;
        $this->DELIVERY_DATE->CurrentValue = null;
        $this->DELIVERY_DATE->OldValue = $this->DELIVERY_DATE->CurrentValue;
        $this->DESCRIPTION->CurrentValue = null;
        $this->DESCRIPTION->OldValue = $this->DESCRIPTION->CurrentValue;
        $this->MODIFIED_DATE->CurrentValue = "getdate()";
        $this->MODIFIED_BY->CurrentValue = null;
        $this->MODIFIED_BY->OldValue = $this->MODIFIED_BY->CurrentValue;
        $this->company_id->CurrentValue = null;
        $this->company_id->OldValue = $this->company_id->CurrentValue;
        $this->SIZE_KEMASAN->CurrentValue = 1;
        $this->MEASURE_ID2->CurrentValue = 3;
        $this->SIZE_GOODS->CurrentValue = 50;
        $this->MEASURE_DOSIS->CurrentValue = 15;
        $this->QUANTITY->CurrentValue = 1;
        $this->MEASURE_ID3->CurrentValue = 21;
        $this->ORDER_PRICE->CurrentValue = null;
        $this->ORDER_PRICE->OldValue = $this->ORDER_PRICE->CurrentValue;
        $this->BRAND_NAME->CurrentValue = null;
        $this->BRAND_NAME->OldValue = $this->BRAND_NAME->CurrentValue;
        $this->ISCETAK->CurrentValue = null;
        $this->ISCETAK->OldValue = $this->ISCETAK->CurrentValue;
        $this->PRINT_DATE->CurrentValue = null;
        $this->PRINT_DATE->OldValue = $this->PRINT_DATE->CurrentValue;
        $this->PRINTED_BY->CurrentValue = null;
        $this->PRINTED_BY->OldValue = $this->PRINTED_BY->CurrentValue;
        $this->PRINTQ->CurrentValue = null;
        $this->PRINTQ->OldValue = $this->PRINTQ->CurrentValue;
        $this->DISCOUNTOFF->CurrentValue = null;
        $this->DISCOUNTOFF->OldValue = $this->DISCOUNTOFF->CurrentValue;
        $this->IDX->CurrentValue = null;
        $this->IDX->OldValue = $this->IDX->CurrentValue;
        $this->QUANTITY0->CurrentValue = null;
        $this->QUANTITY0->OldValue = $this->QUANTITY0->CurrentValue;
        $this->PROPOSEDQ->CurrentValue = null;
        $this->PROPOSEDQ->OldValue = $this->PROPOSEDQ->CurrentValue;
        $this->STOCKQ->CurrentValue = null;
        $this->STOCKQ->OldValue = $this->STOCKQ->CurrentValue;
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

        // Check field name 'PO' first before field var 'x_PO'
        $val = $CurrentForm->hasValue("PO") ? $CurrentForm->getValue("PO") : $CurrentForm->getValue("x_PO");
        if (!$this->PO->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->PO->Visible = false; // Disable update for API request
            } else {
                $this->PO->setFormValue($val);
            }
        }

        // Check field name 'BRAND_ID' first before field var 'x_BRAND_ID'
        $val = $CurrentForm->hasValue("BRAND_ID") ? $CurrentForm->getValue("BRAND_ID") : $CurrentForm->getValue("x_BRAND_ID");
        if (!$this->BRAND_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->BRAND_ID->Visible = false; // Disable update for API request
            } else {
                $this->BRAND_ID->setFormValue($val);
            }
        }

        // Check field name 'ORDER_DATE' first before field var 'x_ORDER_DATE'
        $val = $CurrentForm->hasValue("ORDER_DATE") ? $CurrentForm->getValue("ORDER_DATE") : $CurrentForm->getValue("x_ORDER_DATE");
        if (!$this->ORDER_DATE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ORDER_DATE->Visible = false; // Disable update for API request
            } else {
                $this->ORDER_DATE->setFormValue($val);
            }
            $this->ORDER_DATE->CurrentValue = UnFormatDateTime($this->ORDER_DATE->CurrentValue, 0);
        }

        // Check field name 'PO_NO' first before field var 'x_PO_NO'
        $val = $CurrentForm->hasValue("PO_NO") ? $CurrentForm->getValue("PO_NO") : $CurrentForm->getValue("x_PO_NO");
        if (!$this->PO_NO->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->PO_NO->Visible = false; // Disable update for API request
            } else {
                $this->PO_NO->setFormValue($val);
            }
        }

        // Check field name 'PURCHASE_PRICE' first before field var 'x_PURCHASE_PRICE'
        $val = $CurrentForm->hasValue("PURCHASE_PRICE") ? $CurrentForm->getValue("PURCHASE_PRICE") : $CurrentForm->getValue("x_PURCHASE_PRICE");
        if (!$this->PURCHASE_PRICE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->PURCHASE_PRICE->Visible = false; // Disable update for API request
            } else {
                $this->PURCHASE_PRICE->setFormValue($val);
            }
        }

        // Check field name 'ORDER_QUANTITY' first before field var 'x_ORDER_QUANTITY'
        $val = $CurrentForm->hasValue("ORDER_QUANTITY") ? $CurrentForm->getValue("ORDER_QUANTITY") : $CurrentForm->getValue("x_ORDER_QUANTITY");
        if (!$this->ORDER_QUANTITY->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ORDER_QUANTITY->Visible = false; // Disable update for API request
            } else {
                $this->ORDER_QUANTITY->setFormValue($val);
            }
        }

        // Check field name 'RECEIVED_QUANTITY' first before field var 'x_RECEIVED_QUANTITY'
        $val = $CurrentForm->hasValue("RECEIVED_QUANTITY") ? $CurrentForm->getValue("RECEIVED_QUANTITY") : $CurrentForm->getValue("x_RECEIVED_QUANTITY");
        if (!$this->RECEIVED_QUANTITY->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->RECEIVED_QUANTITY->Visible = false; // Disable update for API request
            } else {
                $this->RECEIVED_QUANTITY->setFormValue($val);
            }
        }

        // Check field name 'MEASURE_ID' first before field var 'x_MEASURE_ID'
        $val = $CurrentForm->hasValue("MEASURE_ID") ? $CurrentForm->getValue("MEASURE_ID") : $CurrentForm->getValue("x_MEASURE_ID");
        if (!$this->MEASURE_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->MEASURE_ID->Visible = false; // Disable update for API request
            } else {
                $this->MEASURE_ID->setFormValue($val);
            }
        }

        // Check field name 'DISCOUNT' first before field var 'x_DISCOUNT'
        $val = $CurrentForm->hasValue("DISCOUNT") ? $CurrentForm->getValue("DISCOUNT") : $CurrentForm->getValue("x_DISCOUNT");
        if (!$this->DISCOUNT->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->DISCOUNT->Visible = false; // Disable update for API request
            } else {
                $this->DISCOUNT->setFormValue($val);
            }
        }

        // Check field name 'AMOUNT_PAID' first before field var 'x_AMOUNT_PAID'
        $val = $CurrentForm->hasValue("AMOUNT_PAID") ? $CurrentForm->getValue("AMOUNT_PAID") : $CurrentForm->getValue("x_AMOUNT_PAID");
        if (!$this->AMOUNT_PAID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->AMOUNT_PAID->Visible = false; // Disable update for API request
            } else {
                $this->AMOUNT_PAID->setFormValue($val);
            }
        }

        // Check field name 'ATP_DATE' first before field var 'x_ATP_DATE'
        $val = $CurrentForm->hasValue("ATP_DATE") ? $CurrentForm->getValue("ATP_DATE") : $CurrentForm->getValue("x_ATP_DATE");
        if (!$this->ATP_DATE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ATP_DATE->Visible = false; // Disable update for API request
            } else {
                $this->ATP_DATE->setFormValue($val);
            }
            $this->ATP_DATE->CurrentValue = UnFormatDateTime($this->ATP_DATE->CurrentValue, 0);
        }

        // Check field name 'DELIVERY_DATE' first before field var 'x_DELIVERY_DATE'
        $val = $CurrentForm->hasValue("DELIVERY_DATE") ? $CurrentForm->getValue("DELIVERY_DATE") : $CurrentForm->getValue("x_DELIVERY_DATE");
        if (!$this->DELIVERY_DATE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->DELIVERY_DATE->Visible = false; // Disable update for API request
            } else {
                $this->DELIVERY_DATE->setFormValue($val);
            }
            $this->DELIVERY_DATE->CurrentValue = UnFormatDateTime($this->DELIVERY_DATE->CurrentValue, 0);
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

        // Check field name 'company_id' first before field var 'x_company_id'
        $val = $CurrentForm->hasValue("company_id") ? $CurrentForm->getValue("company_id") : $CurrentForm->getValue("x_company_id");
        if (!$this->company_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->company_id->Visible = false; // Disable update for API request
            } else {
                $this->company_id->setFormValue($val);
            }
        }

        // Check field name 'SIZE_KEMASAN' first before field var 'x_SIZE_KEMASAN'
        $val = $CurrentForm->hasValue("SIZE_KEMASAN") ? $CurrentForm->getValue("SIZE_KEMASAN") : $CurrentForm->getValue("x_SIZE_KEMASAN");
        if (!$this->SIZE_KEMASAN->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->SIZE_KEMASAN->Visible = false; // Disable update for API request
            } else {
                $this->SIZE_KEMASAN->setFormValue($val);
            }
        }

        // Check field name 'MEASURE_ID2' first before field var 'x_MEASURE_ID2'
        $val = $CurrentForm->hasValue("MEASURE_ID2") ? $CurrentForm->getValue("MEASURE_ID2") : $CurrentForm->getValue("x_MEASURE_ID2");
        if (!$this->MEASURE_ID2->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->MEASURE_ID2->Visible = false; // Disable update for API request
            } else {
                $this->MEASURE_ID2->setFormValue($val);
            }
        }

        // Check field name 'SIZE_GOODS' first before field var 'x_SIZE_GOODS'
        $val = $CurrentForm->hasValue("SIZE_GOODS") ? $CurrentForm->getValue("SIZE_GOODS") : $CurrentForm->getValue("x_SIZE_GOODS");
        if (!$this->SIZE_GOODS->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->SIZE_GOODS->Visible = false; // Disable update for API request
            } else {
                $this->SIZE_GOODS->setFormValue($val);
            }
        }

        // Check field name 'MEASURE_DOSIS' first before field var 'x_MEASURE_DOSIS'
        $val = $CurrentForm->hasValue("MEASURE_DOSIS") ? $CurrentForm->getValue("MEASURE_DOSIS") : $CurrentForm->getValue("x_MEASURE_DOSIS");
        if (!$this->MEASURE_DOSIS->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->MEASURE_DOSIS->Visible = false; // Disable update for API request
            } else {
                $this->MEASURE_DOSIS->setFormValue($val);
            }
        }

        // Check field name 'QUANTITY' first before field var 'x_QUANTITY'
        $val = $CurrentForm->hasValue("QUANTITY") ? $CurrentForm->getValue("QUANTITY") : $CurrentForm->getValue("x_QUANTITY");
        if (!$this->QUANTITY->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->QUANTITY->Visible = false; // Disable update for API request
            } else {
                $this->QUANTITY->setFormValue($val);
            }
        }

        // Check field name 'MEASURE_ID3' first before field var 'x_MEASURE_ID3'
        $val = $CurrentForm->hasValue("MEASURE_ID3") ? $CurrentForm->getValue("MEASURE_ID3") : $CurrentForm->getValue("x_MEASURE_ID3");
        if (!$this->MEASURE_ID3->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->MEASURE_ID3->Visible = false; // Disable update for API request
            } else {
                $this->MEASURE_ID3->setFormValue($val);
            }
        }

        // Check field name 'ORDER_PRICE' first before field var 'x_ORDER_PRICE'
        $val = $CurrentForm->hasValue("ORDER_PRICE") ? $CurrentForm->getValue("ORDER_PRICE") : $CurrentForm->getValue("x_ORDER_PRICE");
        if (!$this->ORDER_PRICE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ORDER_PRICE->Visible = false; // Disable update for API request
            } else {
                $this->ORDER_PRICE->setFormValue($val);
            }
        }

        // Check field name 'BRAND_NAME' first before field var 'x_BRAND_NAME'
        $val = $CurrentForm->hasValue("BRAND_NAME") ? $CurrentForm->getValue("BRAND_NAME") : $CurrentForm->getValue("x_BRAND_NAME");
        if (!$this->BRAND_NAME->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->BRAND_NAME->Visible = false; // Disable update for API request
            } else {
                $this->BRAND_NAME->setFormValue($val);
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

        // Check field name 'DISCOUNTOFF' first before field var 'x_DISCOUNTOFF'
        $val = $CurrentForm->hasValue("DISCOUNTOFF") ? $CurrentForm->getValue("DISCOUNTOFF") : $CurrentForm->getValue("x_DISCOUNTOFF");
        if (!$this->DISCOUNTOFF->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->DISCOUNTOFF->Visible = false; // Disable update for API request
            } else {
                $this->DISCOUNTOFF->setFormValue($val);
            }
        }

        // Check field name 'QUANTITY0' first before field var 'x_QUANTITY0'
        $val = $CurrentForm->hasValue("QUANTITY0") ? $CurrentForm->getValue("QUANTITY0") : $CurrentForm->getValue("x_QUANTITY0");
        if (!$this->QUANTITY0->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->QUANTITY0->Visible = false; // Disable update for API request
            } else {
                $this->QUANTITY0->setFormValue($val);
            }
        }

        // Check field name 'PROPOSEDQ' first before field var 'x_PROPOSEDQ'
        $val = $CurrentForm->hasValue("PROPOSEDQ") ? $CurrentForm->getValue("PROPOSEDQ") : $CurrentForm->getValue("x_PROPOSEDQ");
        if (!$this->PROPOSEDQ->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->PROPOSEDQ->Visible = false; // Disable update for API request
            } else {
                $this->PROPOSEDQ->setFormValue($val);
            }
        }

        // Check field name 'STOCKQ' first before field var 'x_STOCKQ'
        $val = $CurrentForm->hasValue("STOCKQ") ? $CurrentForm->getValue("STOCKQ") : $CurrentForm->getValue("x_STOCKQ");
        if (!$this->STOCKQ->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->STOCKQ->Visible = false; // Disable update for API request
            } else {
                $this->STOCKQ->setFormValue($val);
            }
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->ORG_UNIT_CODE->CurrentValue = $this->ORG_UNIT_CODE->FormValue;
        $this->PO->CurrentValue = $this->PO->FormValue;
        $this->BRAND_ID->CurrentValue = $this->BRAND_ID->FormValue;
        $this->ORDER_DATE->CurrentValue = $this->ORDER_DATE->FormValue;
        $this->ORDER_DATE->CurrentValue = UnFormatDateTime($this->ORDER_DATE->CurrentValue, 0);
        $this->PO_NO->CurrentValue = $this->PO_NO->FormValue;
        $this->PURCHASE_PRICE->CurrentValue = $this->PURCHASE_PRICE->FormValue;
        $this->ORDER_QUANTITY->CurrentValue = $this->ORDER_QUANTITY->FormValue;
        $this->RECEIVED_QUANTITY->CurrentValue = $this->RECEIVED_QUANTITY->FormValue;
        $this->MEASURE_ID->CurrentValue = $this->MEASURE_ID->FormValue;
        $this->DISCOUNT->CurrentValue = $this->DISCOUNT->FormValue;
        $this->AMOUNT_PAID->CurrentValue = $this->AMOUNT_PAID->FormValue;
        $this->ATP_DATE->CurrentValue = $this->ATP_DATE->FormValue;
        $this->ATP_DATE->CurrentValue = UnFormatDateTime($this->ATP_DATE->CurrentValue, 0);
        $this->DELIVERY_DATE->CurrentValue = $this->DELIVERY_DATE->FormValue;
        $this->DELIVERY_DATE->CurrentValue = UnFormatDateTime($this->DELIVERY_DATE->CurrentValue, 0);
        $this->DESCRIPTION->CurrentValue = $this->DESCRIPTION->FormValue;
        $this->MODIFIED_DATE->CurrentValue = $this->MODIFIED_DATE->FormValue;
        $this->MODIFIED_DATE->CurrentValue = UnFormatDateTime($this->MODIFIED_DATE->CurrentValue, 0);
        $this->MODIFIED_BY->CurrentValue = $this->MODIFIED_BY->FormValue;
        $this->company_id->CurrentValue = $this->company_id->FormValue;
        $this->SIZE_KEMASAN->CurrentValue = $this->SIZE_KEMASAN->FormValue;
        $this->MEASURE_ID2->CurrentValue = $this->MEASURE_ID2->FormValue;
        $this->SIZE_GOODS->CurrentValue = $this->SIZE_GOODS->FormValue;
        $this->MEASURE_DOSIS->CurrentValue = $this->MEASURE_DOSIS->FormValue;
        $this->QUANTITY->CurrentValue = $this->QUANTITY->FormValue;
        $this->MEASURE_ID3->CurrentValue = $this->MEASURE_ID3->FormValue;
        $this->ORDER_PRICE->CurrentValue = $this->ORDER_PRICE->FormValue;
        $this->BRAND_NAME->CurrentValue = $this->BRAND_NAME->FormValue;
        $this->ISCETAK->CurrentValue = $this->ISCETAK->FormValue;
        $this->PRINT_DATE->CurrentValue = $this->PRINT_DATE->FormValue;
        $this->PRINT_DATE->CurrentValue = UnFormatDateTime($this->PRINT_DATE->CurrentValue, 0);
        $this->PRINTED_BY->CurrentValue = $this->PRINTED_BY->FormValue;
        $this->PRINTQ->CurrentValue = $this->PRINTQ->FormValue;
        $this->DISCOUNTOFF->CurrentValue = $this->DISCOUNTOFF->FormValue;
        $this->QUANTITY0->CurrentValue = $this->QUANTITY0->FormValue;
        $this->PROPOSEDQ->CurrentValue = $this->PROPOSEDQ->FormValue;
        $this->STOCKQ->CurrentValue = $this->STOCKQ->FormValue;
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
        $this->PO->setDbValue($row['PO']);
        $this->BRAND_ID->setDbValue($row['BRAND_ID']);
        $this->ORDER_DATE->setDbValue($row['ORDER_DATE']);
        $this->PO_NO->setDbValue($row['PO_NO']);
        $this->PURCHASE_PRICE->setDbValue($row['PURCHASE_PRICE']);
        $this->ORDER_QUANTITY->setDbValue($row['ORDER_QUANTITY']);
        $this->RECEIVED_QUANTITY->setDbValue($row['RECEIVED_QUANTITY']);
        $this->MEASURE_ID->setDbValue($row['MEASURE_ID']);
        $this->DISCOUNT->setDbValue($row['DISCOUNT']);
        $this->AMOUNT_PAID->setDbValue($row['AMOUNT_PAID']);
        $this->ATP_DATE->setDbValue($row['ATP_DATE']);
        $this->DELIVERY_DATE->setDbValue($row['DELIVERY_DATE']);
        $this->DESCRIPTION->setDbValue($row['DESCRIPTION']);
        $this->MODIFIED_DATE->setDbValue($row['MODIFIED_DATE']);
        $this->MODIFIED_BY->setDbValue($row['MODIFIED_BY']);
        $this->company_id->setDbValue($row['company_id']);
        $this->SIZE_KEMASAN->setDbValue($row['SIZE_KEMASAN']);
        $this->MEASURE_ID2->setDbValue($row['MEASURE_ID2']);
        $this->SIZE_GOODS->setDbValue($row['SIZE_GOODS']);
        $this->MEASURE_DOSIS->setDbValue($row['MEASURE_DOSIS']);
        $this->QUANTITY->setDbValue($row['QUANTITY']);
        $this->MEASURE_ID3->setDbValue($row['MEASURE_ID3']);
        $this->ORDER_PRICE->setDbValue($row['ORDER_PRICE']);
        $this->BRAND_NAME->setDbValue($row['BRAND_NAME']);
        $this->ISCETAK->setDbValue($row['ISCETAK']);
        $this->PRINT_DATE->setDbValue($row['PRINT_DATE']);
        $this->PRINTED_BY->setDbValue($row['PRINTED_BY']);
        $this->PRINTQ->setDbValue($row['PRINTQ']);
        $this->DISCOUNTOFF->setDbValue($row['DISCOUNTOFF']);
        $this->IDX->setDbValue($row['IDX']);
        $this->QUANTITY0->setDbValue($row['QUANTITY0']);
        $this->PROPOSEDQ->setDbValue($row['PROPOSEDQ']);
        $this->STOCKQ->setDbValue($row['STOCKQ']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $this->loadDefaultValues();
        $row = [];
        $row['ORG_UNIT_CODE'] = $this->ORG_UNIT_CODE->CurrentValue;
        $row['PO'] = $this->PO->CurrentValue;
        $row['BRAND_ID'] = $this->BRAND_ID->CurrentValue;
        $row['ORDER_DATE'] = $this->ORDER_DATE->CurrentValue;
        $row['PO_NO'] = $this->PO_NO->CurrentValue;
        $row['PURCHASE_PRICE'] = $this->PURCHASE_PRICE->CurrentValue;
        $row['ORDER_QUANTITY'] = $this->ORDER_QUANTITY->CurrentValue;
        $row['RECEIVED_QUANTITY'] = $this->RECEIVED_QUANTITY->CurrentValue;
        $row['MEASURE_ID'] = $this->MEASURE_ID->CurrentValue;
        $row['DISCOUNT'] = $this->DISCOUNT->CurrentValue;
        $row['AMOUNT_PAID'] = $this->AMOUNT_PAID->CurrentValue;
        $row['ATP_DATE'] = $this->ATP_DATE->CurrentValue;
        $row['DELIVERY_DATE'] = $this->DELIVERY_DATE->CurrentValue;
        $row['DESCRIPTION'] = $this->DESCRIPTION->CurrentValue;
        $row['MODIFIED_DATE'] = $this->MODIFIED_DATE->CurrentValue;
        $row['MODIFIED_BY'] = $this->MODIFIED_BY->CurrentValue;
        $row['company_id'] = $this->company_id->CurrentValue;
        $row['SIZE_KEMASAN'] = $this->SIZE_KEMASAN->CurrentValue;
        $row['MEASURE_ID2'] = $this->MEASURE_ID2->CurrentValue;
        $row['SIZE_GOODS'] = $this->SIZE_GOODS->CurrentValue;
        $row['MEASURE_DOSIS'] = $this->MEASURE_DOSIS->CurrentValue;
        $row['QUANTITY'] = $this->QUANTITY->CurrentValue;
        $row['MEASURE_ID3'] = $this->MEASURE_ID3->CurrentValue;
        $row['ORDER_PRICE'] = $this->ORDER_PRICE->CurrentValue;
        $row['BRAND_NAME'] = $this->BRAND_NAME->CurrentValue;
        $row['ISCETAK'] = $this->ISCETAK->CurrentValue;
        $row['PRINT_DATE'] = $this->PRINT_DATE->CurrentValue;
        $row['PRINTED_BY'] = $this->PRINTED_BY->CurrentValue;
        $row['PRINTQ'] = $this->PRINTQ->CurrentValue;
        $row['DISCOUNTOFF'] = $this->DISCOUNTOFF->CurrentValue;
        $row['IDX'] = $this->IDX->CurrentValue;
        $row['QUANTITY0'] = $this->QUANTITY0->CurrentValue;
        $row['PROPOSEDQ'] = $this->PROPOSEDQ->CurrentValue;
        $row['STOCKQ'] = $this->STOCKQ->CurrentValue;
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
        if ($this->PURCHASE_PRICE->FormValue == $this->PURCHASE_PRICE->CurrentValue && is_numeric(ConvertToFloatString($this->PURCHASE_PRICE->CurrentValue))) {
            $this->PURCHASE_PRICE->CurrentValue = ConvertToFloatString($this->PURCHASE_PRICE->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->ORDER_QUANTITY->FormValue == $this->ORDER_QUANTITY->CurrentValue && is_numeric(ConvertToFloatString($this->ORDER_QUANTITY->CurrentValue))) {
            $this->ORDER_QUANTITY->CurrentValue = ConvertToFloatString($this->ORDER_QUANTITY->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->RECEIVED_QUANTITY->FormValue == $this->RECEIVED_QUANTITY->CurrentValue && is_numeric(ConvertToFloatString($this->RECEIVED_QUANTITY->CurrentValue))) {
            $this->RECEIVED_QUANTITY->CurrentValue = ConvertToFloatString($this->RECEIVED_QUANTITY->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->DISCOUNT->FormValue == $this->DISCOUNT->CurrentValue && is_numeric(ConvertToFloatString($this->DISCOUNT->CurrentValue))) {
            $this->DISCOUNT->CurrentValue = ConvertToFloatString($this->DISCOUNT->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->AMOUNT_PAID->FormValue == $this->AMOUNT_PAID->CurrentValue && is_numeric(ConvertToFloatString($this->AMOUNT_PAID->CurrentValue))) {
            $this->AMOUNT_PAID->CurrentValue = ConvertToFloatString($this->AMOUNT_PAID->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->SIZE_KEMASAN->FormValue == $this->SIZE_KEMASAN->CurrentValue && is_numeric(ConvertToFloatString($this->SIZE_KEMASAN->CurrentValue))) {
            $this->SIZE_KEMASAN->CurrentValue = ConvertToFloatString($this->SIZE_KEMASAN->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->SIZE_GOODS->FormValue == $this->SIZE_GOODS->CurrentValue && is_numeric(ConvertToFloatString($this->SIZE_GOODS->CurrentValue))) {
            $this->SIZE_GOODS->CurrentValue = ConvertToFloatString($this->SIZE_GOODS->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->QUANTITY->FormValue == $this->QUANTITY->CurrentValue && is_numeric(ConvertToFloatString($this->QUANTITY->CurrentValue))) {
            $this->QUANTITY->CurrentValue = ConvertToFloatString($this->QUANTITY->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->ORDER_PRICE->FormValue == $this->ORDER_PRICE->CurrentValue && is_numeric(ConvertToFloatString($this->ORDER_PRICE->CurrentValue))) {
            $this->ORDER_PRICE->CurrentValue = ConvertToFloatString($this->ORDER_PRICE->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->DISCOUNTOFF->FormValue == $this->DISCOUNTOFF->CurrentValue && is_numeric(ConvertToFloatString($this->DISCOUNTOFF->CurrentValue))) {
            $this->DISCOUNTOFF->CurrentValue = ConvertToFloatString($this->DISCOUNTOFF->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->QUANTITY0->FormValue == $this->QUANTITY0->CurrentValue && is_numeric(ConvertToFloatString($this->QUANTITY0->CurrentValue))) {
            $this->QUANTITY0->CurrentValue = ConvertToFloatString($this->QUANTITY0->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->PROPOSEDQ->FormValue == $this->PROPOSEDQ->CurrentValue && is_numeric(ConvertToFloatString($this->PROPOSEDQ->CurrentValue))) {
            $this->PROPOSEDQ->CurrentValue = ConvertToFloatString($this->PROPOSEDQ->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->STOCKQ->FormValue == $this->STOCKQ->CurrentValue && is_numeric(ConvertToFloatString($this->STOCKQ->CurrentValue))) {
            $this->STOCKQ->CurrentValue = ConvertToFloatString($this->STOCKQ->CurrentValue);
        }

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // ORG_UNIT_CODE

        // PO

        // BRAND_ID

        // ORDER_DATE

        // PO_NO

        // PURCHASE_PRICE

        // ORDER_QUANTITY

        // RECEIVED_QUANTITY

        // MEASURE_ID

        // DISCOUNT

        // AMOUNT_PAID

        // ATP_DATE

        // DELIVERY_DATE

        // DESCRIPTION

        // MODIFIED_DATE

        // MODIFIED_BY

        // company_id

        // SIZE_KEMASAN

        // MEASURE_ID2

        // SIZE_GOODS

        // MEASURE_DOSIS

        // QUANTITY

        // MEASURE_ID3

        // ORDER_PRICE

        // BRAND_NAME

        // ISCETAK

        // PRINT_DATE

        // PRINTED_BY

        // PRINTQ

        // DISCOUNTOFF

        // IDX

        // QUANTITY0

        // PROPOSEDQ

        // STOCKQ
        if ($this->RowType == ROWTYPE_VIEW) {
            // ORG_UNIT_CODE
            $this->ORG_UNIT_CODE->ViewValue = $this->ORG_UNIT_CODE->CurrentValue;
            $this->ORG_UNIT_CODE->ViewCustomAttributes = "";

            // PO
            $this->PO->ViewValue = $this->PO->CurrentValue;
            $this->PO->ViewCustomAttributes = "";

            // BRAND_ID
            $this->BRAND_ID->ViewValue = $this->BRAND_ID->CurrentValue;
            $this->BRAND_ID->ViewCustomAttributes = "";

            // ORDER_DATE
            $this->ORDER_DATE->ViewValue = $this->ORDER_DATE->CurrentValue;
            $this->ORDER_DATE->ViewValue = FormatDateTime($this->ORDER_DATE->ViewValue, 0);
            $this->ORDER_DATE->ViewCustomAttributes = "";

            // PO_NO
            $this->PO_NO->ViewValue = $this->PO_NO->CurrentValue;
            $this->PO_NO->ViewCustomAttributes = "";

            // PURCHASE_PRICE
            $this->PURCHASE_PRICE->ViewValue = $this->PURCHASE_PRICE->CurrentValue;
            $this->PURCHASE_PRICE->ViewValue = FormatNumber($this->PURCHASE_PRICE->ViewValue, 2, -2, -2, -2);
            $this->PURCHASE_PRICE->ViewCustomAttributes = "";

            // ORDER_QUANTITY
            $this->ORDER_QUANTITY->ViewValue = $this->ORDER_QUANTITY->CurrentValue;
            $this->ORDER_QUANTITY->ViewValue = FormatNumber($this->ORDER_QUANTITY->ViewValue, 2, -2, -2, -2);
            $this->ORDER_QUANTITY->ViewCustomAttributes = "";

            // RECEIVED_QUANTITY
            $this->RECEIVED_QUANTITY->ViewValue = $this->RECEIVED_QUANTITY->CurrentValue;
            $this->RECEIVED_QUANTITY->ViewValue = FormatNumber($this->RECEIVED_QUANTITY->ViewValue, 2, -2, -2, -2);
            $this->RECEIVED_QUANTITY->ViewCustomAttributes = "";

            // MEASURE_ID
            $this->MEASURE_ID->ViewValue = $this->MEASURE_ID->CurrentValue;
            $this->MEASURE_ID->ViewValue = FormatNumber($this->MEASURE_ID->ViewValue, 0, -2, -2, -2);
            $this->MEASURE_ID->ViewCustomAttributes = "";

            // DISCOUNT
            $this->DISCOUNT->ViewValue = $this->DISCOUNT->CurrentValue;
            $this->DISCOUNT->ViewValue = FormatNumber($this->DISCOUNT->ViewValue, 2, -2, -2, -2);
            $this->DISCOUNT->ViewCustomAttributes = "";

            // AMOUNT_PAID
            $this->AMOUNT_PAID->ViewValue = $this->AMOUNT_PAID->CurrentValue;
            $this->AMOUNT_PAID->ViewValue = FormatNumber($this->AMOUNT_PAID->ViewValue, 2, -2, -2, -2);
            $this->AMOUNT_PAID->ViewCustomAttributes = "";

            // ATP_DATE
            $this->ATP_DATE->ViewValue = $this->ATP_DATE->CurrentValue;
            $this->ATP_DATE->ViewValue = FormatDateTime($this->ATP_DATE->ViewValue, 0);
            $this->ATP_DATE->ViewCustomAttributes = "";

            // DELIVERY_DATE
            $this->DELIVERY_DATE->ViewValue = $this->DELIVERY_DATE->CurrentValue;
            $this->DELIVERY_DATE->ViewValue = FormatDateTime($this->DELIVERY_DATE->ViewValue, 0);
            $this->DELIVERY_DATE->ViewCustomAttributes = "";

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

            // company_id
            $this->company_id->ViewValue = $this->company_id->CurrentValue;
            $this->company_id->ViewCustomAttributes = "";

            // SIZE_KEMASAN
            $this->SIZE_KEMASAN->ViewValue = $this->SIZE_KEMASAN->CurrentValue;
            $this->SIZE_KEMASAN->ViewValue = FormatNumber($this->SIZE_KEMASAN->ViewValue, 2, -2, -2, -2);
            $this->SIZE_KEMASAN->ViewCustomAttributes = "";

            // MEASURE_ID2
            $this->MEASURE_ID2->ViewValue = $this->MEASURE_ID2->CurrentValue;
            $this->MEASURE_ID2->ViewValue = FormatNumber($this->MEASURE_ID2->ViewValue, 0, -2, -2, -2);
            $this->MEASURE_ID2->ViewCustomAttributes = "";

            // SIZE_GOODS
            $this->SIZE_GOODS->ViewValue = $this->SIZE_GOODS->CurrentValue;
            $this->SIZE_GOODS->ViewValue = FormatNumber($this->SIZE_GOODS->ViewValue, 2, -2, -2, -2);
            $this->SIZE_GOODS->ViewCustomAttributes = "";

            // MEASURE_DOSIS
            $this->MEASURE_DOSIS->ViewValue = $this->MEASURE_DOSIS->CurrentValue;
            $this->MEASURE_DOSIS->ViewValue = FormatNumber($this->MEASURE_DOSIS->ViewValue, 0, -2, -2, -2);
            $this->MEASURE_DOSIS->ViewCustomAttributes = "";

            // QUANTITY
            $this->QUANTITY->ViewValue = $this->QUANTITY->CurrentValue;
            $this->QUANTITY->ViewValue = FormatNumber($this->QUANTITY->ViewValue, 2, -2, -2, -2);
            $this->QUANTITY->ViewCustomAttributes = "";

            // MEASURE_ID3
            $this->MEASURE_ID3->ViewValue = $this->MEASURE_ID3->CurrentValue;
            $this->MEASURE_ID3->ViewValue = FormatNumber($this->MEASURE_ID3->ViewValue, 0, -2, -2, -2);
            $this->MEASURE_ID3->ViewCustomAttributes = "";

            // ORDER_PRICE
            $this->ORDER_PRICE->ViewValue = $this->ORDER_PRICE->CurrentValue;
            $this->ORDER_PRICE->ViewValue = FormatNumber($this->ORDER_PRICE->ViewValue, 2, -2, -2, -2);
            $this->ORDER_PRICE->ViewCustomAttributes = "";

            // BRAND_NAME
            $this->BRAND_NAME->ViewValue = $this->BRAND_NAME->CurrentValue;
            $this->BRAND_NAME->ViewCustomAttributes = "";

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

            // DISCOUNTOFF
            $this->DISCOUNTOFF->ViewValue = $this->DISCOUNTOFF->CurrentValue;
            $this->DISCOUNTOFF->ViewValue = FormatNumber($this->DISCOUNTOFF->ViewValue, 2, -2, -2, -2);
            $this->DISCOUNTOFF->ViewCustomAttributes = "";

            // IDX
            $this->IDX->ViewValue = $this->IDX->CurrentValue;
            $this->IDX->ViewCustomAttributes = "";

            // QUANTITY0
            $this->QUANTITY0->ViewValue = $this->QUANTITY0->CurrentValue;
            $this->QUANTITY0->ViewValue = FormatNumber($this->QUANTITY0->ViewValue, 2, -2, -2, -2);
            $this->QUANTITY0->ViewCustomAttributes = "";

            // PROPOSEDQ
            $this->PROPOSEDQ->ViewValue = $this->PROPOSEDQ->CurrentValue;
            $this->PROPOSEDQ->ViewValue = FormatNumber($this->PROPOSEDQ->ViewValue, 2, -2, -2, -2);
            $this->PROPOSEDQ->ViewCustomAttributes = "";

            // STOCKQ
            $this->STOCKQ->ViewValue = $this->STOCKQ->CurrentValue;
            $this->STOCKQ->ViewValue = FormatNumber($this->STOCKQ->ViewValue, 2, -2, -2, -2);
            $this->STOCKQ->ViewCustomAttributes = "";

            // ORG_UNIT_CODE
            $this->ORG_UNIT_CODE->LinkCustomAttributes = "";
            $this->ORG_UNIT_CODE->HrefValue = "";
            $this->ORG_UNIT_CODE->TooltipValue = "";

            // PO
            $this->PO->LinkCustomAttributes = "";
            $this->PO->HrefValue = "";
            $this->PO->TooltipValue = "";

            // BRAND_ID
            $this->BRAND_ID->LinkCustomAttributes = "";
            $this->BRAND_ID->HrefValue = "";
            $this->BRAND_ID->TooltipValue = "";

            // ORDER_DATE
            $this->ORDER_DATE->LinkCustomAttributes = "";
            $this->ORDER_DATE->HrefValue = "";
            $this->ORDER_DATE->TooltipValue = "";

            // PO_NO
            $this->PO_NO->LinkCustomAttributes = "";
            $this->PO_NO->HrefValue = "";
            $this->PO_NO->TooltipValue = "";

            // PURCHASE_PRICE
            $this->PURCHASE_PRICE->LinkCustomAttributes = "";
            $this->PURCHASE_PRICE->HrefValue = "";
            $this->PURCHASE_PRICE->TooltipValue = "";

            // ORDER_QUANTITY
            $this->ORDER_QUANTITY->LinkCustomAttributes = "";
            $this->ORDER_QUANTITY->HrefValue = "";
            $this->ORDER_QUANTITY->TooltipValue = "";

            // RECEIVED_QUANTITY
            $this->RECEIVED_QUANTITY->LinkCustomAttributes = "";
            $this->RECEIVED_QUANTITY->HrefValue = "";
            $this->RECEIVED_QUANTITY->TooltipValue = "";

            // MEASURE_ID
            $this->MEASURE_ID->LinkCustomAttributes = "";
            $this->MEASURE_ID->HrefValue = "";
            $this->MEASURE_ID->TooltipValue = "";

            // DISCOUNT
            $this->DISCOUNT->LinkCustomAttributes = "";
            $this->DISCOUNT->HrefValue = "";
            $this->DISCOUNT->TooltipValue = "";

            // AMOUNT_PAID
            $this->AMOUNT_PAID->LinkCustomAttributes = "";
            $this->AMOUNT_PAID->HrefValue = "";
            $this->AMOUNT_PAID->TooltipValue = "";

            // ATP_DATE
            $this->ATP_DATE->LinkCustomAttributes = "";
            $this->ATP_DATE->HrefValue = "";
            $this->ATP_DATE->TooltipValue = "";

            // DELIVERY_DATE
            $this->DELIVERY_DATE->LinkCustomAttributes = "";
            $this->DELIVERY_DATE->HrefValue = "";
            $this->DELIVERY_DATE->TooltipValue = "";

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

            // company_id
            $this->company_id->LinkCustomAttributes = "";
            $this->company_id->HrefValue = "";
            $this->company_id->TooltipValue = "";

            // SIZE_KEMASAN
            $this->SIZE_KEMASAN->LinkCustomAttributes = "";
            $this->SIZE_KEMASAN->HrefValue = "";
            $this->SIZE_KEMASAN->TooltipValue = "";

            // MEASURE_ID2
            $this->MEASURE_ID2->LinkCustomAttributes = "";
            $this->MEASURE_ID2->HrefValue = "";
            $this->MEASURE_ID2->TooltipValue = "";

            // SIZE_GOODS
            $this->SIZE_GOODS->LinkCustomAttributes = "";
            $this->SIZE_GOODS->HrefValue = "";
            $this->SIZE_GOODS->TooltipValue = "";

            // MEASURE_DOSIS
            $this->MEASURE_DOSIS->LinkCustomAttributes = "";
            $this->MEASURE_DOSIS->HrefValue = "";
            $this->MEASURE_DOSIS->TooltipValue = "";

            // QUANTITY
            $this->QUANTITY->LinkCustomAttributes = "";
            $this->QUANTITY->HrefValue = "";
            $this->QUANTITY->TooltipValue = "";

            // MEASURE_ID3
            $this->MEASURE_ID3->LinkCustomAttributes = "";
            $this->MEASURE_ID3->HrefValue = "";
            $this->MEASURE_ID3->TooltipValue = "";

            // ORDER_PRICE
            $this->ORDER_PRICE->LinkCustomAttributes = "";
            $this->ORDER_PRICE->HrefValue = "";
            $this->ORDER_PRICE->TooltipValue = "";

            // BRAND_NAME
            $this->BRAND_NAME->LinkCustomAttributes = "";
            $this->BRAND_NAME->HrefValue = "";
            $this->BRAND_NAME->TooltipValue = "";

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

            // DISCOUNTOFF
            $this->DISCOUNTOFF->LinkCustomAttributes = "";
            $this->DISCOUNTOFF->HrefValue = "";
            $this->DISCOUNTOFF->TooltipValue = "";

            // QUANTITY0
            $this->QUANTITY0->LinkCustomAttributes = "";
            $this->QUANTITY0->HrefValue = "";
            $this->QUANTITY0->TooltipValue = "";

            // PROPOSEDQ
            $this->PROPOSEDQ->LinkCustomAttributes = "";
            $this->PROPOSEDQ->HrefValue = "";
            $this->PROPOSEDQ->TooltipValue = "";

            // STOCKQ
            $this->STOCKQ->LinkCustomAttributes = "";
            $this->STOCKQ->HrefValue = "";
            $this->STOCKQ->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // ORG_UNIT_CODE
            $this->ORG_UNIT_CODE->EditAttrs["class"] = "form-control";
            $this->ORG_UNIT_CODE->EditCustomAttributes = "";
            if (!$this->ORG_UNIT_CODE->Raw) {
                $this->ORG_UNIT_CODE->CurrentValue = HtmlDecode($this->ORG_UNIT_CODE->CurrentValue);
            }
            $this->ORG_UNIT_CODE->EditValue = HtmlEncode($this->ORG_UNIT_CODE->CurrentValue);
            $this->ORG_UNIT_CODE->PlaceHolder = RemoveHtml($this->ORG_UNIT_CODE->caption());

            // PO
            $this->PO->EditAttrs["class"] = "form-control";
            $this->PO->EditCustomAttributes = "";
            if (!$this->PO->Raw) {
                $this->PO->CurrentValue = HtmlDecode($this->PO->CurrentValue);
            }
            $this->PO->EditValue = HtmlEncode($this->PO->CurrentValue);
            $this->PO->PlaceHolder = RemoveHtml($this->PO->caption());

            // BRAND_ID
            $this->BRAND_ID->EditAttrs["class"] = "form-control";
            $this->BRAND_ID->EditCustomAttributes = "";
            if (!$this->BRAND_ID->Raw) {
                $this->BRAND_ID->CurrentValue = HtmlDecode($this->BRAND_ID->CurrentValue);
            }
            $this->BRAND_ID->EditValue = HtmlEncode($this->BRAND_ID->CurrentValue);
            $this->BRAND_ID->PlaceHolder = RemoveHtml($this->BRAND_ID->caption());

            // ORDER_DATE
            $this->ORDER_DATE->EditAttrs["class"] = "form-control";
            $this->ORDER_DATE->EditCustomAttributes = "";
            $this->ORDER_DATE->EditValue = HtmlEncode(FormatDateTime($this->ORDER_DATE->CurrentValue, 8));
            $this->ORDER_DATE->PlaceHolder = RemoveHtml($this->ORDER_DATE->caption());

            // PO_NO
            $this->PO_NO->EditAttrs["class"] = "form-control";
            $this->PO_NO->EditCustomAttributes = "";
            if (!$this->PO_NO->Raw) {
                $this->PO_NO->CurrentValue = HtmlDecode($this->PO_NO->CurrentValue);
            }
            $this->PO_NO->EditValue = HtmlEncode($this->PO_NO->CurrentValue);
            $this->PO_NO->PlaceHolder = RemoveHtml($this->PO_NO->caption());

            // PURCHASE_PRICE
            $this->PURCHASE_PRICE->EditAttrs["class"] = "form-control";
            $this->PURCHASE_PRICE->EditCustomAttributes = "";
            $this->PURCHASE_PRICE->EditValue = HtmlEncode($this->PURCHASE_PRICE->CurrentValue);
            $this->PURCHASE_PRICE->PlaceHolder = RemoveHtml($this->PURCHASE_PRICE->caption());
            if (strval($this->PURCHASE_PRICE->EditValue) != "" && is_numeric($this->PURCHASE_PRICE->EditValue)) {
                $this->PURCHASE_PRICE->EditValue = FormatNumber($this->PURCHASE_PRICE->EditValue, -2, -2, -2, -2);
            }

            // ORDER_QUANTITY
            $this->ORDER_QUANTITY->EditAttrs["class"] = "form-control";
            $this->ORDER_QUANTITY->EditCustomAttributes = "";
            $this->ORDER_QUANTITY->EditValue = HtmlEncode($this->ORDER_QUANTITY->CurrentValue);
            $this->ORDER_QUANTITY->PlaceHolder = RemoveHtml($this->ORDER_QUANTITY->caption());
            if (strval($this->ORDER_QUANTITY->EditValue) != "" && is_numeric($this->ORDER_QUANTITY->EditValue)) {
                $this->ORDER_QUANTITY->EditValue = FormatNumber($this->ORDER_QUANTITY->EditValue, -2, -2, -2, -2);
            }

            // RECEIVED_QUANTITY
            $this->RECEIVED_QUANTITY->EditAttrs["class"] = "form-control";
            $this->RECEIVED_QUANTITY->EditCustomAttributes = "";
            $this->RECEIVED_QUANTITY->EditValue = HtmlEncode($this->RECEIVED_QUANTITY->CurrentValue);
            $this->RECEIVED_QUANTITY->PlaceHolder = RemoveHtml($this->RECEIVED_QUANTITY->caption());
            if (strval($this->RECEIVED_QUANTITY->EditValue) != "" && is_numeric($this->RECEIVED_QUANTITY->EditValue)) {
                $this->RECEIVED_QUANTITY->EditValue = FormatNumber($this->RECEIVED_QUANTITY->EditValue, -2, -2, -2, -2);
            }

            // MEASURE_ID
            $this->MEASURE_ID->EditAttrs["class"] = "form-control";
            $this->MEASURE_ID->EditCustomAttributes = "";
            $this->MEASURE_ID->EditValue = HtmlEncode($this->MEASURE_ID->CurrentValue);
            $this->MEASURE_ID->PlaceHolder = RemoveHtml($this->MEASURE_ID->caption());

            // DISCOUNT
            $this->DISCOUNT->EditAttrs["class"] = "form-control";
            $this->DISCOUNT->EditCustomAttributes = "";
            $this->DISCOUNT->EditValue = HtmlEncode($this->DISCOUNT->CurrentValue);
            $this->DISCOUNT->PlaceHolder = RemoveHtml($this->DISCOUNT->caption());
            if (strval($this->DISCOUNT->EditValue) != "" && is_numeric($this->DISCOUNT->EditValue)) {
                $this->DISCOUNT->EditValue = FormatNumber($this->DISCOUNT->EditValue, -2, -2, -2, -2);
            }

            // AMOUNT_PAID
            $this->AMOUNT_PAID->EditAttrs["class"] = "form-control";
            $this->AMOUNT_PAID->EditCustomAttributes = "";
            $this->AMOUNT_PAID->EditValue = HtmlEncode($this->AMOUNT_PAID->CurrentValue);
            $this->AMOUNT_PAID->PlaceHolder = RemoveHtml($this->AMOUNT_PAID->caption());
            if (strval($this->AMOUNT_PAID->EditValue) != "" && is_numeric($this->AMOUNT_PAID->EditValue)) {
                $this->AMOUNT_PAID->EditValue = FormatNumber($this->AMOUNT_PAID->EditValue, -2, -2, -2, -2);
            }

            // ATP_DATE
            $this->ATP_DATE->EditAttrs["class"] = "form-control";
            $this->ATP_DATE->EditCustomAttributes = "";
            $this->ATP_DATE->EditValue = HtmlEncode(FormatDateTime($this->ATP_DATE->CurrentValue, 8));
            $this->ATP_DATE->PlaceHolder = RemoveHtml($this->ATP_DATE->caption());

            // DELIVERY_DATE
            $this->DELIVERY_DATE->EditAttrs["class"] = "form-control";
            $this->DELIVERY_DATE->EditCustomAttributes = "";
            $this->DELIVERY_DATE->EditValue = HtmlEncode(FormatDateTime($this->DELIVERY_DATE->CurrentValue, 8));
            $this->DELIVERY_DATE->PlaceHolder = RemoveHtml($this->DELIVERY_DATE->caption());

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

            // company_id
            $this->company_id->EditAttrs["class"] = "form-control";
            $this->company_id->EditCustomAttributes = "";
            if (!$this->company_id->Raw) {
                $this->company_id->CurrentValue = HtmlDecode($this->company_id->CurrentValue);
            }
            $this->company_id->EditValue = HtmlEncode($this->company_id->CurrentValue);
            $this->company_id->PlaceHolder = RemoveHtml($this->company_id->caption());

            // SIZE_KEMASAN
            $this->SIZE_KEMASAN->EditAttrs["class"] = "form-control";
            $this->SIZE_KEMASAN->EditCustomAttributes = "";
            $this->SIZE_KEMASAN->EditValue = HtmlEncode($this->SIZE_KEMASAN->CurrentValue);
            $this->SIZE_KEMASAN->PlaceHolder = RemoveHtml($this->SIZE_KEMASAN->caption());
            if (strval($this->SIZE_KEMASAN->EditValue) != "" && is_numeric($this->SIZE_KEMASAN->EditValue)) {
                $this->SIZE_KEMASAN->EditValue = FormatNumber($this->SIZE_KEMASAN->EditValue, -2, -2, -2, -2);
            }

            // MEASURE_ID2
            $this->MEASURE_ID2->EditAttrs["class"] = "form-control";
            $this->MEASURE_ID2->EditCustomAttributes = "";
            $this->MEASURE_ID2->EditValue = HtmlEncode($this->MEASURE_ID2->CurrentValue);
            $this->MEASURE_ID2->PlaceHolder = RemoveHtml($this->MEASURE_ID2->caption());

            // SIZE_GOODS
            $this->SIZE_GOODS->EditAttrs["class"] = "form-control";
            $this->SIZE_GOODS->EditCustomAttributes = "";
            $this->SIZE_GOODS->EditValue = HtmlEncode($this->SIZE_GOODS->CurrentValue);
            $this->SIZE_GOODS->PlaceHolder = RemoveHtml($this->SIZE_GOODS->caption());
            if (strval($this->SIZE_GOODS->EditValue) != "" && is_numeric($this->SIZE_GOODS->EditValue)) {
                $this->SIZE_GOODS->EditValue = FormatNumber($this->SIZE_GOODS->EditValue, -2, -2, -2, -2);
            }

            // MEASURE_DOSIS
            $this->MEASURE_DOSIS->EditAttrs["class"] = "form-control";
            $this->MEASURE_DOSIS->EditCustomAttributes = "";
            $this->MEASURE_DOSIS->EditValue = HtmlEncode($this->MEASURE_DOSIS->CurrentValue);
            $this->MEASURE_DOSIS->PlaceHolder = RemoveHtml($this->MEASURE_DOSIS->caption());

            // QUANTITY
            $this->QUANTITY->EditAttrs["class"] = "form-control";
            $this->QUANTITY->EditCustomAttributes = "";
            $this->QUANTITY->EditValue = HtmlEncode($this->QUANTITY->CurrentValue);
            $this->QUANTITY->PlaceHolder = RemoveHtml($this->QUANTITY->caption());
            if (strval($this->QUANTITY->EditValue) != "" && is_numeric($this->QUANTITY->EditValue)) {
                $this->QUANTITY->EditValue = FormatNumber($this->QUANTITY->EditValue, -2, -2, -2, -2);
            }

            // MEASURE_ID3
            $this->MEASURE_ID3->EditAttrs["class"] = "form-control";
            $this->MEASURE_ID3->EditCustomAttributes = "";
            $this->MEASURE_ID3->EditValue = HtmlEncode($this->MEASURE_ID3->CurrentValue);
            $this->MEASURE_ID3->PlaceHolder = RemoveHtml($this->MEASURE_ID3->caption());

            // ORDER_PRICE
            $this->ORDER_PRICE->EditAttrs["class"] = "form-control";
            $this->ORDER_PRICE->EditCustomAttributes = "";
            $this->ORDER_PRICE->EditValue = HtmlEncode($this->ORDER_PRICE->CurrentValue);
            $this->ORDER_PRICE->PlaceHolder = RemoveHtml($this->ORDER_PRICE->caption());
            if (strval($this->ORDER_PRICE->EditValue) != "" && is_numeric($this->ORDER_PRICE->EditValue)) {
                $this->ORDER_PRICE->EditValue = FormatNumber($this->ORDER_PRICE->EditValue, -2, -2, -2, -2);
            }

            // BRAND_NAME
            $this->BRAND_NAME->EditAttrs["class"] = "form-control";
            $this->BRAND_NAME->EditCustomAttributes = "";
            if (!$this->BRAND_NAME->Raw) {
                $this->BRAND_NAME->CurrentValue = HtmlDecode($this->BRAND_NAME->CurrentValue);
            }
            $this->BRAND_NAME->EditValue = HtmlEncode($this->BRAND_NAME->CurrentValue);
            $this->BRAND_NAME->PlaceHolder = RemoveHtml($this->BRAND_NAME->caption());

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

            // DISCOUNTOFF
            $this->DISCOUNTOFF->EditAttrs["class"] = "form-control";
            $this->DISCOUNTOFF->EditCustomAttributes = "";
            $this->DISCOUNTOFF->EditValue = HtmlEncode($this->DISCOUNTOFF->CurrentValue);
            $this->DISCOUNTOFF->PlaceHolder = RemoveHtml($this->DISCOUNTOFF->caption());
            if (strval($this->DISCOUNTOFF->EditValue) != "" && is_numeric($this->DISCOUNTOFF->EditValue)) {
                $this->DISCOUNTOFF->EditValue = FormatNumber($this->DISCOUNTOFF->EditValue, -2, -2, -2, -2);
            }

            // QUANTITY0
            $this->QUANTITY0->EditAttrs["class"] = "form-control";
            $this->QUANTITY0->EditCustomAttributes = "";
            $this->QUANTITY0->EditValue = HtmlEncode($this->QUANTITY0->CurrentValue);
            $this->QUANTITY0->PlaceHolder = RemoveHtml($this->QUANTITY0->caption());
            if (strval($this->QUANTITY0->EditValue) != "" && is_numeric($this->QUANTITY0->EditValue)) {
                $this->QUANTITY0->EditValue = FormatNumber($this->QUANTITY0->EditValue, -2, -2, -2, -2);
            }

            // PROPOSEDQ
            $this->PROPOSEDQ->EditAttrs["class"] = "form-control";
            $this->PROPOSEDQ->EditCustomAttributes = "";
            $this->PROPOSEDQ->EditValue = HtmlEncode($this->PROPOSEDQ->CurrentValue);
            $this->PROPOSEDQ->PlaceHolder = RemoveHtml($this->PROPOSEDQ->caption());
            if (strval($this->PROPOSEDQ->EditValue) != "" && is_numeric($this->PROPOSEDQ->EditValue)) {
                $this->PROPOSEDQ->EditValue = FormatNumber($this->PROPOSEDQ->EditValue, -2, -2, -2, -2);
            }

            // STOCKQ
            $this->STOCKQ->EditAttrs["class"] = "form-control";
            $this->STOCKQ->EditCustomAttributes = "";
            $this->STOCKQ->EditValue = HtmlEncode($this->STOCKQ->CurrentValue);
            $this->STOCKQ->PlaceHolder = RemoveHtml($this->STOCKQ->caption());
            if (strval($this->STOCKQ->EditValue) != "" && is_numeric($this->STOCKQ->EditValue)) {
                $this->STOCKQ->EditValue = FormatNumber($this->STOCKQ->EditValue, -2, -2, -2, -2);
            }

            // Add refer script

            // ORG_UNIT_CODE
            $this->ORG_UNIT_CODE->LinkCustomAttributes = "";
            $this->ORG_UNIT_CODE->HrefValue = "";

            // PO
            $this->PO->LinkCustomAttributes = "";
            $this->PO->HrefValue = "";

            // BRAND_ID
            $this->BRAND_ID->LinkCustomAttributes = "";
            $this->BRAND_ID->HrefValue = "";

            // ORDER_DATE
            $this->ORDER_DATE->LinkCustomAttributes = "";
            $this->ORDER_DATE->HrefValue = "";

            // PO_NO
            $this->PO_NO->LinkCustomAttributes = "";
            $this->PO_NO->HrefValue = "";

            // PURCHASE_PRICE
            $this->PURCHASE_PRICE->LinkCustomAttributes = "";
            $this->PURCHASE_PRICE->HrefValue = "";

            // ORDER_QUANTITY
            $this->ORDER_QUANTITY->LinkCustomAttributes = "";
            $this->ORDER_QUANTITY->HrefValue = "";

            // RECEIVED_QUANTITY
            $this->RECEIVED_QUANTITY->LinkCustomAttributes = "";
            $this->RECEIVED_QUANTITY->HrefValue = "";

            // MEASURE_ID
            $this->MEASURE_ID->LinkCustomAttributes = "";
            $this->MEASURE_ID->HrefValue = "";

            // DISCOUNT
            $this->DISCOUNT->LinkCustomAttributes = "";
            $this->DISCOUNT->HrefValue = "";

            // AMOUNT_PAID
            $this->AMOUNT_PAID->LinkCustomAttributes = "";
            $this->AMOUNT_PAID->HrefValue = "";

            // ATP_DATE
            $this->ATP_DATE->LinkCustomAttributes = "";
            $this->ATP_DATE->HrefValue = "";

            // DELIVERY_DATE
            $this->DELIVERY_DATE->LinkCustomAttributes = "";
            $this->DELIVERY_DATE->HrefValue = "";

            // DESCRIPTION
            $this->DESCRIPTION->LinkCustomAttributes = "";
            $this->DESCRIPTION->HrefValue = "";

            // MODIFIED_DATE
            $this->MODIFIED_DATE->LinkCustomAttributes = "";
            $this->MODIFIED_DATE->HrefValue = "";

            // MODIFIED_BY
            $this->MODIFIED_BY->LinkCustomAttributes = "";
            $this->MODIFIED_BY->HrefValue = "";

            // company_id
            $this->company_id->LinkCustomAttributes = "";
            $this->company_id->HrefValue = "";

            // SIZE_KEMASAN
            $this->SIZE_KEMASAN->LinkCustomAttributes = "";
            $this->SIZE_KEMASAN->HrefValue = "";

            // MEASURE_ID2
            $this->MEASURE_ID2->LinkCustomAttributes = "";
            $this->MEASURE_ID2->HrefValue = "";

            // SIZE_GOODS
            $this->SIZE_GOODS->LinkCustomAttributes = "";
            $this->SIZE_GOODS->HrefValue = "";

            // MEASURE_DOSIS
            $this->MEASURE_DOSIS->LinkCustomAttributes = "";
            $this->MEASURE_DOSIS->HrefValue = "";

            // QUANTITY
            $this->QUANTITY->LinkCustomAttributes = "";
            $this->QUANTITY->HrefValue = "";

            // MEASURE_ID3
            $this->MEASURE_ID3->LinkCustomAttributes = "";
            $this->MEASURE_ID3->HrefValue = "";

            // ORDER_PRICE
            $this->ORDER_PRICE->LinkCustomAttributes = "";
            $this->ORDER_PRICE->HrefValue = "";

            // BRAND_NAME
            $this->BRAND_NAME->LinkCustomAttributes = "";
            $this->BRAND_NAME->HrefValue = "";

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

            // DISCOUNTOFF
            $this->DISCOUNTOFF->LinkCustomAttributes = "";
            $this->DISCOUNTOFF->HrefValue = "";

            // QUANTITY0
            $this->QUANTITY0->LinkCustomAttributes = "";
            $this->QUANTITY0->HrefValue = "";

            // PROPOSEDQ
            $this->PROPOSEDQ->LinkCustomAttributes = "";
            $this->PROPOSEDQ->HrefValue = "";

            // STOCKQ
            $this->STOCKQ->LinkCustomAttributes = "";
            $this->STOCKQ->HrefValue = "";
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
        if ($this->PO->Required) {
            if (!$this->PO->IsDetailKey && EmptyValue($this->PO->FormValue)) {
                $this->PO->addErrorMessage(str_replace("%s", $this->PO->caption(), $this->PO->RequiredErrorMessage));
            }
        }
        if ($this->BRAND_ID->Required) {
            if (!$this->BRAND_ID->IsDetailKey && EmptyValue($this->BRAND_ID->FormValue)) {
                $this->BRAND_ID->addErrorMessage(str_replace("%s", $this->BRAND_ID->caption(), $this->BRAND_ID->RequiredErrorMessage));
            }
        }
        if ($this->ORDER_DATE->Required) {
            if (!$this->ORDER_DATE->IsDetailKey && EmptyValue($this->ORDER_DATE->FormValue)) {
                $this->ORDER_DATE->addErrorMessage(str_replace("%s", $this->ORDER_DATE->caption(), $this->ORDER_DATE->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->ORDER_DATE->FormValue)) {
            $this->ORDER_DATE->addErrorMessage($this->ORDER_DATE->getErrorMessage(false));
        }
        if ($this->PO_NO->Required) {
            if (!$this->PO_NO->IsDetailKey && EmptyValue($this->PO_NO->FormValue)) {
                $this->PO_NO->addErrorMessage(str_replace("%s", $this->PO_NO->caption(), $this->PO_NO->RequiredErrorMessage));
            }
        }
        if ($this->PURCHASE_PRICE->Required) {
            if (!$this->PURCHASE_PRICE->IsDetailKey && EmptyValue($this->PURCHASE_PRICE->FormValue)) {
                $this->PURCHASE_PRICE->addErrorMessage(str_replace("%s", $this->PURCHASE_PRICE->caption(), $this->PURCHASE_PRICE->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->PURCHASE_PRICE->FormValue)) {
            $this->PURCHASE_PRICE->addErrorMessage($this->PURCHASE_PRICE->getErrorMessage(false));
        }
        if ($this->ORDER_QUANTITY->Required) {
            if (!$this->ORDER_QUANTITY->IsDetailKey && EmptyValue($this->ORDER_QUANTITY->FormValue)) {
                $this->ORDER_QUANTITY->addErrorMessage(str_replace("%s", $this->ORDER_QUANTITY->caption(), $this->ORDER_QUANTITY->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->ORDER_QUANTITY->FormValue)) {
            $this->ORDER_QUANTITY->addErrorMessage($this->ORDER_QUANTITY->getErrorMessage(false));
        }
        if ($this->RECEIVED_QUANTITY->Required) {
            if (!$this->RECEIVED_QUANTITY->IsDetailKey && EmptyValue($this->RECEIVED_QUANTITY->FormValue)) {
                $this->RECEIVED_QUANTITY->addErrorMessage(str_replace("%s", $this->RECEIVED_QUANTITY->caption(), $this->RECEIVED_QUANTITY->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->RECEIVED_QUANTITY->FormValue)) {
            $this->RECEIVED_QUANTITY->addErrorMessage($this->RECEIVED_QUANTITY->getErrorMessage(false));
        }
        if ($this->MEASURE_ID->Required) {
            if (!$this->MEASURE_ID->IsDetailKey && EmptyValue($this->MEASURE_ID->FormValue)) {
                $this->MEASURE_ID->addErrorMessage(str_replace("%s", $this->MEASURE_ID->caption(), $this->MEASURE_ID->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->MEASURE_ID->FormValue)) {
            $this->MEASURE_ID->addErrorMessage($this->MEASURE_ID->getErrorMessage(false));
        }
        if ($this->DISCOUNT->Required) {
            if (!$this->DISCOUNT->IsDetailKey && EmptyValue($this->DISCOUNT->FormValue)) {
                $this->DISCOUNT->addErrorMessage(str_replace("%s", $this->DISCOUNT->caption(), $this->DISCOUNT->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->DISCOUNT->FormValue)) {
            $this->DISCOUNT->addErrorMessage($this->DISCOUNT->getErrorMessage(false));
        }
        if ($this->AMOUNT_PAID->Required) {
            if (!$this->AMOUNT_PAID->IsDetailKey && EmptyValue($this->AMOUNT_PAID->FormValue)) {
                $this->AMOUNT_PAID->addErrorMessage(str_replace("%s", $this->AMOUNT_PAID->caption(), $this->AMOUNT_PAID->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->AMOUNT_PAID->FormValue)) {
            $this->AMOUNT_PAID->addErrorMessage($this->AMOUNT_PAID->getErrorMessage(false));
        }
        if ($this->ATP_DATE->Required) {
            if (!$this->ATP_DATE->IsDetailKey && EmptyValue($this->ATP_DATE->FormValue)) {
                $this->ATP_DATE->addErrorMessage(str_replace("%s", $this->ATP_DATE->caption(), $this->ATP_DATE->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->ATP_DATE->FormValue)) {
            $this->ATP_DATE->addErrorMessage($this->ATP_DATE->getErrorMessage(false));
        }
        if ($this->DELIVERY_DATE->Required) {
            if (!$this->DELIVERY_DATE->IsDetailKey && EmptyValue($this->DELIVERY_DATE->FormValue)) {
                $this->DELIVERY_DATE->addErrorMessage(str_replace("%s", $this->DELIVERY_DATE->caption(), $this->DELIVERY_DATE->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->DELIVERY_DATE->FormValue)) {
            $this->DELIVERY_DATE->addErrorMessage($this->DELIVERY_DATE->getErrorMessage(false));
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
        if ($this->company_id->Required) {
            if (!$this->company_id->IsDetailKey && EmptyValue($this->company_id->FormValue)) {
                $this->company_id->addErrorMessage(str_replace("%s", $this->company_id->caption(), $this->company_id->RequiredErrorMessage));
            }
        }
        if ($this->SIZE_KEMASAN->Required) {
            if (!$this->SIZE_KEMASAN->IsDetailKey && EmptyValue($this->SIZE_KEMASAN->FormValue)) {
                $this->SIZE_KEMASAN->addErrorMessage(str_replace("%s", $this->SIZE_KEMASAN->caption(), $this->SIZE_KEMASAN->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->SIZE_KEMASAN->FormValue)) {
            $this->SIZE_KEMASAN->addErrorMessage($this->SIZE_KEMASAN->getErrorMessage(false));
        }
        if ($this->MEASURE_ID2->Required) {
            if (!$this->MEASURE_ID2->IsDetailKey && EmptyValue($this->MEASURE_ID2->FormValue)) {
                $this->MEASURE_ID2->addErrorMessage(str_replace("%s", $this->MEASURE_ID2->caption(), $this->MEASURE_ID2->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->MEASURE_ID2->FormValue)) {
            $this->MEASURE_ID2->addErrorMessage($this->MEASURE_ID2->getErrorMessage(false));
        }
        if ($this->SIZE_GOODS->Required) {
            if (!$this->SIZE_GOODS->IsDetailKey && EmptyValue($this->SIZE_GOODS->FormValue)) {
                $this->SIZE_GOODS->addErrorMessage(str_replace("%s", $this->SIZE_GOODS->caption(), $this->SIZE_GOODS->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->SIZE_GOODS->FormValue)) {
            $this->SIZE_GOODS->addErrorMessage($this->SIZE_GOODS->getErrorMessage(false));
        }
        if ($this->MEASURE_DOSIS->Required) {
            if (!$this->MEASURE_DOSIS->IsDetailKey && EmptyValue($this->MEASURE_DOSIS->FormValue)) {
                $this->MEASURE_DOSIS->addErrorMessage(str_replace("%s", $this->MEASURE_DOSIS->caption(), $this->MEASURE_DOSIS->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->MEASURE_DOSIS->FormValue)) {
            $this->MEASURE_DOSIS->addErrorMessage($this->MEASURE_DOSIS->getErrorMessage(false));
        }
        if ($this->QUANTITY->Required) {
            if (!$this->QUANTITY->IsDetailKey && EmptyValue($this->QUANTITY->FormValue)) {
                $this->QUANTITY->addErrorMessage(str_replace("%s", $this->QUANTITY->caption(), $this->QUANTITY->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->QUANTITY->FormValue)) {
            $this->QUANTITY->addErrorMessage($this->QUANTITY->getErrorMessage(false));
        }
        if ($this->MEASURE_ID3->Required) {
            if (!$this->MEASURE_ID3->IsDetailKey && EmptyValue($this->MEASURE_ID3->FormValue)) {
                $this->MEASURE_ID3->addErrorMessage(str_replace("%s", $this->MEASURE_ID3->caption(), $this->MEASURE_ID3->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->MEASURE_ID3->FormValue)) {
            $this->MEASURE_ID3->addErrorMessage($this->MEASURE_ID3->getErrorMessage(false));
        }
        if ($this->ORDER_PRICE->Required) {
            if (!$this->ORDER_PRICE->IsDetailKey && EmptyValue($this->ORDER_PRICE->FormValue)) {
                $this->ORDER_PRICE->addErrorMessage(str_replace("%s", $this->ORDER_PRICE->caption(), $this->ORDER_PRICE->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->ORDER_PRICE->FormValue)) {
            $this->ORDER_PRICE->addErrorMessage($this->ORDER_PRICE->getErrorMessage(false));
        }
        if ($this->BRAND_NAME->Required) {
            if (!$this->BRAND_NAME->IsDetailKey && EmptyValue($this->BRAND_NAME->FormValue)) {
                $this->BRAND_NAME->addErrorMessage(str_replace("%s", $this->BRAND_NAME->caption(), $this->BRAND_NAME->RequiredErrorMessage));
            }
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
        if ($this->DISCOUNTOFF->Required) {
            if (!$this->DISCOUNTOFF->IsDetailKey && EmptyValue($this->DISCOUNTOFF->FormValue)) {
                $this->DISCOUNTOFF->addErrorMessage(str_replace("%s", $this->DISCOUNTOFF->caption(), $this->DISCOUNTOFF->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->DISCOUNTOFF->FormValue)) {
            $this->DISCOUNTOFF->addErrorMessage($this->DISCOUNTOFF->getErrorMessage(false));
        }
        if ($this->QUANTITY0->Required) {
            if (!$this->QUANTITY0->IsDetailKey && EmptyValue($this->QUANTITY0->FormValue)) {
                $this->QUANTITY0->addErrorMessage(str_replace("%s", $this->QUANTITY0->caption(), $this->QUANTITY0->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->QUANTITY0->FormValue)) {
            $this->QUANTITY0->addErrorMessage($this->QUANTITY0->getErrorMessage(false));
        }
        if ($this->PROPOSEDQ->Required) {
            if (!$this->PROPOSEDQ->IsDetailKey && EmptyValue($this->PROPOSEDQ->FormValue)) {
                $this->PROPOSEDQ->addErrorMessage(str_replace("%s", $this->PROPOSEDQ->caption(), $this->PROPOSEDQ->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->PROPOSEDQ->FormValue)) {
            $this->PROPOSEDQ->addErrorMessage($this->PROPOSEDQ->getErrorMessage(false));
        }
        if ($this->STOCKQ->Required) {
            if (!$this->STOCKQ->IsDetailKey && EmptyValue($this->STOCKQ->FormValue)) {
                $this->STOCKQ->addErrorMessage(str_replace("%s", $this->STOCKQ->caption(), $this->STOCKQ->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->STOCKQ->FormValue)) {
            $this->STOCKQ->addErrorMessage($this->STOCKQ->getErrorMessage(false));
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
        $conn = $this->getConnection();

        // Load db values from rsold
        $this->loadDbValues($rsold);
        if ($rsold) {
        }
        $rsnew = [];

        // ORG_UNIT_CODE
        $this->ORG_UNIT_CODE->setDbValueDef($rsnew, $this->ORG_UNIT_CODE->CurrentValue, "", false);

        // PO
        $this->PO->setDbValueDef($rsnew, $this->PO->CurrentValue, "", strval($this->PO->CurrentValue) == "");

        // BRAND_ID
        $this->BRAND_ID->setDbValueDef($rsnew, $this->BRAND_ID->CurrentValue, "", false);

        // ORDER_DATE
        $this->ORDER_DATE->setDbValueDef($rsnew, UnFormatDateTime($this->ORDER_DATE->CurrentValue, 0), null, false);

        // PO_NO
        $this->PO_NO->setDbValueDef($rsnew, $this->PO_NO->CurrentValue, null, false);

        // PURCHASE_PRICE
        $this->PURCHASE_PRICE->setDbValueDef($rsnew, $this->PURCHASE_PRICE->CurrentValue, null, false);

        // ORDER_QUANTITY
        $this->ORDER_QUANTITY->setDbValueDef($rsnew, $this->ORDER_QUANTITY->CurrentValue, null, strval($this->ORDER_QUANTITY->CurrentValue) == "");

        // RECEIVED_QUANTITY
        $this->RECEIVED_QUANTITY->setDbValueDef($rsnew, $this->RECEIVED_QUANTITY->CurrentValue, null, false);

        // MEASURE_ID
        $this->MEASURE_ID->setDbValueDef($rsnew, $this->MEASURE_ID->CurrentValue, null, strval($this->MEASURE_ID->CurrentValue) == "");

        // DISCOUNT
        $this->DISCOUNT->setDbValueDef($rsnew, $this->DISCOUNT->CurrentValue, null, strval($this->DISCOUNT->CurrentValue) == "");

        // AMOUNT_PAID
        $this->AMOUNT_PAID->setDbValueDef($rsnew, $this->AMOUNT_PAID->CurrentValue, null, false);

        // ATP_DATE
        $this->ATP_DATE->setDbValueDef($rsnew, UnFormatDateTime($this->ATP_DATE->CurrentValue, 0), null, false);

        // DELIVERY_DATE
        $this->DELIVERY_DATE->setDbValueDef($rsnew, UnFormatDateTime($this->DELIVERY_DATE->CurrentValue, 0), null, false);

        // DESCRIPTION
        $this->DESCRIPTION->setDbValueDef($rsnew, $this->DESCRIPTION->CurrentValue, null, false);

        // MODIFIED_DATE
        $this->MODIFIED_DATE->setDbValueDef($rsnew, UnFormatDateTime($this->MODIFIED_DATE->CurrentValue, 0), null, strval($this->MODIFIED_DATE->CurrentValue) == "");

        // MODIFIED_BY
        $this->MODIFIED_BY->setDbValueDef($rsnew, $this->MODIFIED_BY->CurrentValue, null, false);

        // company_id
        $this->company_id->setDbValueDef($rsnew, $this->company_id->CurrentValue, null, false);

        // SIZE_KEMASAN
        $this->SIZE_KEMASAN->setDbValueDef($rsnew, $this->SIZE_KEMASAN->CurrentValue, null, strval($this->SIZE_KEMASAN->CurrentValue) == "");

        // MEASURE_ID2
        $this->MEASURE_ID2->setDbValueDef($rsnew, $this->MEASURE_ID2->CurrentValue, null, strval($this->MEASURE_ID2->CurrentValue) == "");

        // SIZE_GOODS
        $this->SIZE_GOODS->setDbValueDef($rsnew, $this->SIZE_GOODS->CurrentValue, null, strval($this->SIZE_GOODS->CurrentValue) == "");

        // MEASURE_DOSIS
        $this->MEASURE_DOSIS->setDbValueDef($rsnew, $this->MEASURE_DOSIS->CurrentValue, null, strval($this->MEASURE_DOSIS->CurrentValue) == "");

        // QUANTITY
        $this->QUANTITY->setDbValueDef($rsnew, $this->QUANTITY->CurrentValue, null, strval($this->QUANTITY->CurrentValue) == "");

        // MEASURE_ID3
        $this->MEASURE_ID3->setDbValueDef($rsnew, $this->MEASURE_ID3->CurrentValue, null, strval($this->MEASURE_ID3->CurrentValue) == "");

        // ORDER_PRICE
        $this->ORDER_PRICE->setDbValueDef($rsnew, $this->ORDER_PRICE->CurrentValue, null, false);

        // BRAND_NAME
        $this->BRAND_NAME->setDbValueDef($rsnew, $this->BRAND_NAME->CurrentValue, null, false);

        // ISCETAK
        $this->ISCETAK->setDbValueDef($rsnew, $this->ISCETAK->CurrentValue, null, false);

        // PRINT_DATE
        $this->PRINT_DATE->setDbValueDef($rsnew, UnFormatDateTime($this->PRINT_DATE->CurrentValue, 0), null, false);

        // PRINTED_BY
        $this->PRINTED_BY->setDbValueDef($rsnew, $this->PRINTED_BY->CurrentValue, null, false);

        // PRINTQ
        $this->PRINTQ->setDbValueDef($rsnew, $this->PRINTQ->CurrentValue, null, false);

        // DISCOUNTOFF
        $this->DISCOUNTOFF->setDbValueDef($rsnew, $this->DISCOUNTOFF->CurrentValue, null, false);

        // QUANTITY0
        $this->QUANTITY0->setDbValueDef($rsnew, $this->QUANTITY0->CurrentValue, null, false);

        // PROPOSEDQ
        $this->PROPOSEDQ->setDbValueDef($rsnew, $this->PROPOSEDQ->CurrentValue, null, false);

        // STOCKQ
        $this->STOCKQ->setDbValueDef($rsnew, $this->STOCKQ->CurrentValue, null, false);

        // Call Row Inserting event
        $insertRow = $this->rowInserting($rsold, $rsnew);

        // Check if key value entered
        if ($insertRow && $this->ValidateKey && strval($rsnew['ORG_UNIT_CODE']) == "") {
            $this->setFailureMessage($Language->phrase("InvalidKeyValue"));
            $insertRow = false;
        }

        // Check if key value entered
        if ($insertRow && $this->ValidateKey && strval($rsnew['PO']) == "") {
            $this->setFailureMessage($Language->phrase("InvalidKeyValue"));
            $insertRow = false;
        }

        // Check if key value entered
        if ($insertRow && $this->ValidateKey && strval($rsnew['BRAND_ID']) == "") {
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("PoItemList"), "", $this->TableVar, true);
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
