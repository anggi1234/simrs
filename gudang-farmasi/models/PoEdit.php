<?php

namespace PHPMaker2021\SIMRSSQLSERVERGUDANGFARMASI;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class PoEdit extends Po
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'PO';

    // Page object name
    public $PageObjName = "PoEdit";

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

        // Table object (PO)
        if (!isset($GLOBALS["PO"]) || get_class($GLOBALS["PO"]) == PROJECT_NAMESPACE . "PO") {
            $GLOBALS["PO"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'PO');
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
                $doc = new $class(Container("PO"));
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
                    if ($pageName == "PoView") {
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
            $key .= @$ar['ID'];
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
        if ($this->isAdd() || $this->isCopy() || $this->isGridAdd()) {
            $this->ID->Visible = false;
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
    public $FormClassName = "ew-horizontal ew-form ew-edit-form";
    public $IsModal = false;
    public $IsMobileOrModal = false;
    public $DbMasterFilter;
    public $DbDetailFilter;
    public $HashValue; // Hash Value
    public $DisplayRecords = 1;
    public $StartRecord;
    public $StopRecord;
    public $TotalRecords = 0;
    public $RecordRange = 10;
    public $RecordCount;

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
        $this->PO_DATE->setVisibility();
        $this->ORDER_VALUE->setVisibility();
        $this->RECEIVED_VALUE->setVisibility();
        $this->PROCURE_METHOD->setVisibility();
        $this->COMPANY_ID->setVisibility();
        $this->FUND_ID->setVisibility();
        $this->FUND_NO->setVisibility();
        $this->DESCRIPTION->setVisibility();
        $this->MODIFIED_DATE->setVisibility();
        $this->MODIFIED_BY->setVisibility();
        $this->ORDER_BY->setVisibility();
        $this->SENT_TO->setVisibility();
        $this->ISVALID->setVisibility();
        $this->START_VALID->setVisibility();
        $this->END_VALID->setVisibility();
        $this->CONTRACT_NO->setVisibility();
        $this->ORG_ID->setVisibility();
        $this->CLINIC_ID->setVisibility();
        $this->ACCOUNT_ID->setVisibility();
        $this->PAID_VALUE->setVisibility();
        $this->PPN->setVisibility();
        $this->MATERAI->setVisibility();
        $this->PPN_VALUE->setVisibility();
        $this->DISCOUNT_VALUE->setVisibility();
        $this->ISCETAK->setVisibility();
        $this->PRINT_DATE->setVisibility();
        $this->PRINTED_BY->setVisibility();
        $this->PRINTQ->setVisibility();
        $this->TAGIHAN_VALUE->setVisibility();
        $this->ACKNOWLEDGEBY->setVisibility();
        $this->NUM->setVisibility();
        $this->ID->setVisibility();
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
        $this->FormClassName = "ew-form ew-edit-form ew-horizontal";
        $loaded = false;
        $postBack = false;

        // Set up current action and primary key
        if (IsApi()) {
            // Load key values
            $loaded = true;
            if (($keyValue = Get("ID") ?? Key(0) ?? Route(2)) !== null) {
                $this->ID->setQueryStringValue($keyValue);
                $this->ID->setOldValue($this->ID->QueryStringValue);
            } elseif (Post("ID") !== null) {
                $this->ID->setFormValue(Post("ID"));
                $this->ID->setOldValue($this->ID->FormValue);
            } else {
                $loaded = false; // Unable to load key
            }

            // Load record
            if ($loaded) {
                $loaded = $this->loadRow();
            }
            if (!$loaded) {
                $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
                $this->terminate();
                return;
            }
            $this->CurrentAction = "update"; // Update record directly
            $this->OldKey = $this->getKey(true); // Get from CurrentValue
            $postBack = true;
        } else {
            if (Post("action") !== null) {
                $this->CurrentAction = Post("action"); // Get action code
                if (!$this->isShow()) { // Not reload record, handle as postback
                    $postBack = true;
                }

                // Get key from Form
                $this->setKey(Post($this->OldKeyName), $this->isShow());
            } else {
                $this->CurrentAction = "show"; // Default action is display

                // Load key from QueryString
                $loadByQuery = false;
                if (($keyValue = Get("ID") ?? Route("ID")) !== null) {
                    $this->ID->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->ID->CurrentValue = null;
                }
            }

            // Load recordset
            if ($this->isShow()) {
                // Load current record
                $loaded = $this->loadRow();
                $this->OldKey = $loaded ? $this->getKey(true) : ""; // Get from CurrentValue
            }
        }

        // Process form if post back
        if ($postBack) {
            $this->loadFormValues(); // Get form values
        }

        // Validate form if post back
        if ($postBack) {
            if (!$this->validateForm()) {
                $this->EventCancelled = true; // Event cancelled
                $this->restoreFormValues();
                if (IsApi()) {
                    $this->terminate();
                    return;
                } else {
                    $this->CurrentAction = ""; // Form error, reset action
                }
            }
        }

        // Perform current action
        switch ($this->CurrentAction) {
            case "show": // Get a record to display
                if (!$loaded) { // Load record based on key
                    if ($this->getFailureMessage() == "") {
                        $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
                    }
                    $this->terminate("PoList"); // No matching record, return to list
                    return;
                }
                break;
            case "update": // Update
                $returnUrl = $this->getReturnUrl();
                if (GetPageName($returnUrl) == "PoList") {
                    $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                }
                $this->SendEmail = true; // Send email on update success
                if ($this->editRow()) { // Update record based on key
                    if ($this->getSuccessMessage() == "") {
                        $this->setSuccessMessage($Language->phrase("UpdateSuccess")); // Update success
                    }
                    if (IsApi()) {
                        $this->terminate(true);
                        return;
                    } else {
                        $this->terminate($returnUrl); // Return to caller
                        return;
                    }
                } elseif (IsApi()) { // API request, return
                    $this->terminate();
                    return;
                } elseif ($this->getFailureMessage() == $Language->phrase("NoRecord")) {
                    $this->terminate($returnUrl); // Return to caller
                    return;
                } else {
                    $this->EventCancelled = true; // Event cancelled
                    $this->restoreFormValues(); // Restore form values if update failed
                }
        }

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Render the record
        $this->RowType = ROWTYPE_EDIT; // Render as Edit
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

        // Check field name 'ORDER_VALUE' first before field var 'x_ORDER_VALUE'
        $val = $CurrentForm->hasValue("ORDER_VALUE") ? $CurrentForm->getValue("ORDER_VALUE") : $CurrentForm->getValue("x_ORDER_VALUE");
        if (!$this->ORDER_VALUE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ORDER_VALUE->Visible = false; // Disable update for API request
            } else {
                $this->ORDER_VALUE->setFormValue($val);
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

        // Check field name 'PROCURE_METHOD' first before field var 'x_PROCURE_METHOD'
        $val = $CurrentForm->hasValue("PROCURE_METHOD") ? $CurrentForm->getValue("PROCURE_METHOD") : $CurrentForm->getValue("x_PROCURE_METHOD");
        if (!$this->PROCURE_METHOD->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->PROCURE_METHOD->Visible = false; // Disable update for API request
            } else {
                $this->PROCURE_METHOD->setFormValue($val);
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

        // Check field name 'FUND_ID' first before field var 'x_FUND_ID'
        $val = $CurrentForm->hasValue("FUND_ID") ? $CurrentForm->getValue("FUND_ID") : $CurrentForm->getValue("x_FUND_ID");
        if (!$this->FUND_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->FUND_ID->Visible = false; // Disable update for API request
            } else {
                $this->FUND_ID->setFormValue($val);
            }
        }

        // Check field name 'FUND_NO' first before field var 'x_FUND_NO'
        $val = $CurrentForm->hasValue("FUND_NO") ? $CurrentForm->getValue("FUND_NO") : $CurrentForm->getValue("x_FUND_NO");
        if (!$this->FUND_NO->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->FUND_NO->Visible = false; // Disable update for API request
            } else {
                $this->FUND_NO->setFormValue($val);
            }
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

        // Check field name 'ORDER_BY' first before field var 'x_ORDER_BY'
        $val = $CurrentForm->hasValue("ORDER_BY") ? $CurrentForm->getValue("ORDER_BY") : $CurrentForm->getValue("x_ORDER_BY");
        if (!$this->ORDER_BY->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ORDER_BY->Visible = false; // Disable update for API request
            } else {
                $this->ORDER_BY->setFormValue($val);
            }
        }

        // Check field name 'SENT_TO' first before field var 'x_SENT_TO'
        $val = $CurrentForm->hasValue("SENT_TO") ? $CurrentForm->getValue("SENT_TO") : $CurrentForm->getValue("x_SENT_TO");
        if (!$this->SENT_TO->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->SENT_TO->Visible = false; // Disable update for API request
            } else {
                $this->SENT_TO->setFormValue($val);
            }
        }

        // Check field name 'ISVALID' first before field var 'x_ISVALID'
        $val = $CurrentForm->hasValue("ISVALID") ? $CurrentForm->getValue("ISVALID") : $CurrentForm->getValue("x_ISVALID");
        if (!$this->ISVALID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ISVALID->Visible = false; // Disable update for API request
            } else {
                $this->ISVALID->setFormValue($val);
            }
        }

        // Check field name 'START_VALID' first before field var 'x_START_VALID'
        $val = $CurrentForm->hasValue("START_VALID") ? $CurrentForm->getValue("START_VALID") : $CurrentForm->getValue("x_START_VALID");
        if (!$this->START_VALID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->START_VALID->Visible = false; // Disable update for API request
            } else {
                $this->START_VALID->setFormValue($val);
            }
            $this->START_VALID->CurrentValue = UnFormatDateTime($this->START_VALID->CurrentValue, 0);
        }

        // Check field name 'END_VALID' first before field var 'x_END_VALID'
        $val = $CurrentForm->hasValue("END_VALID") ? $CurrentForm->getValue("END_VALID") : $CurrentForm->getValue("x_END_VALID");
        if (!$this->END_VALID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->END_VALID->Visible = false; // Disable update for API request
            } else {
                $this->END_VALID->setFormValue($val);
            }
            $this->END_VALID->CurrentValue = UnFormatDateTime($this->END_VALID->CurrentValue, 0);
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

        // Check field name 'ACCOUNT_ID' first before field var 'x_ACCOUNT_ID'
        $val = $CurrentForm->hasValue("ACCOUNT_ID") ? $CurrentForm->getValue("ACCOUNT_ID") : $CurrentForm->getValue("x_ACCOUNT_ID");
        if (!$this->ACCOUNT_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ACCOUNT_ID->Visible = false; // Disable update for API request
            } else {
                $this->ACCOUNT_ID->setFormValue($val);
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

        // Check field name 'TAGIHAN_VALUE' first before field var 'x_TAGIHAN_VALUE'
        $val = $CurrentForm->hasValue("TAGIHAN_VALUE") ? $CurrentForm->getValue("TAGIHAN_VALUE") : $CurrentForm->getValue("x_TAGIHAN_VALUE");
        if (!$this->TAGIHAN_VALUE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->TAGIHAN_VALUE->Visible = false; // Disable update for API request
            } else {
                $this->TAGIHAN_VALUE->setFormValue($val);
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

        // Check field name 'ID' first before field var 'x_ID'
        $val = $CurrentForm->hasValue("ID") ? $CurrentForm->getValue("ID") : $CurrentForm->getValue("x_ID");
        if (!$this->ID->IsDetailKey) {
            $this->ID->setFormValue($val);
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->ORG_UNIT_CODE->CurrentValue = $this->ORG_UNIT_CODE->FormValue;
        $this->PO->CurrentValue = $this->PO->FormValue;
        $this->PO_DATE->CurrentValue = $this->PO_DATE->FormValue;
        $this->PO_DATE->CurrentValue = UnFormatDateTime($this->PO_DATE->CurrentValue, 0);
        $this->ORDER_VALUE->CurrentValue = $this->ORDER_VALUE->FormValue;
        $this->RECEIVED_VALUE->CurrentValue = $this->RECEIVED_VALUE->FormValue;
        $this->PROCURE_METHOD->CurrentValue = $this->PROCURE_METHOD->FormValue;
        $this->COMPANY_ID->CurrentValue = $this->COMPANY_ID->FormValue;
        $this->FUND_ID->CurrentValue = $this->FUND_ID->FormValue;
        $this->FUND_NO->CurrentValue = $this->FUND_NO->FormValue;
        $this->DESCRIPTION->CurrentValue = $this->DESCRIPTION->FormValue;
        $this->MODIFIED_DATE->CurrentValue = $this->MODIFIED_DATE->FormValue;
        $this->MODIFIED_DATE->CurrentValue = UnFormatDateTime($this->MODIFIED_DATE->CurrentValue, 0);
        $this->MODIFIED_BY->CurrentValue = $this->MODIFIED_BY->FormValue;
        $this->ORDER_BY->CurrentValue = $this->ORDER_BY->FormValue;
        $this->SENT_TO->CurrentValue = $this->SENT_TO->FormValue;
        $this->ISVALID->CurrentValue = $this->ISVALID->FormValue;
        $this->START_VALID->CurrentValue = $this->START_VALID->FormValue;
        $this->START_VALID->CurrentValue = UnFormatDateTime($this->START_VALID->CurrentValue, 0);
        $this->END_VALID->CurrentValue = $this->END_VALID->FormValue;
        $this->END_VALID->CurrentValue = UnFormatDateTime($this->END_VALID->CurrentValue, 0);
        $this->CONTRACT_NO->CurrentValue = $this->CONTRACT_NO->FormValue;
        $this->ORG_ID->CurrentValue = $this->ORG_ID->FormValue;
        $this->CLINIC_ID->CurrentValue = $this->CLINIC_ID->FormValue;
        $this->ACCOUNT_ID->CurrentValue = $this->ACCOUNT_ID->FormValue;
        $this->PAID_VALUE->CurrentValue = $this->PAID_VALUE->FormValue;
        $this->PPN->CurrentValue = $this->PPN->FormValue;
        $this->MATERAI->CurrentValue = $this->MATERAI->FormValue;
        $this->PPN_VALUE->CurrentValue = $this->PPN_VALUE->FormValue;
        $this->DISCOUNT_VALUE->CurrentValue = $this->DISCOUNT_VALUE->FormValue;
        $this->ISCETAK->CurrentValue = $this->ISCETAK->FormValue;
        $this->PRINT_DATE->CurrentValue = $this->PRINT_DATE->FormValue;
        $this->PRINT_DATE->CurrentValue = UnFormatDateTime($this->PRINT_DATE->CurrentValue, 0);
        $this->PRINTED_BY->CurrentValue = $this->PRINTED_BY->FormValue;
        $this->PRINTQ->CurrentValue = $this->PRINTQ->FormValue;
        $this->TAGIHAN_VALUE->CurrentValue = $this->TAGIHAN_VALUE->FormValue;
        $this->ACKNOWLEDGEBY->CurrentValue = $this->ACKNOWLEDGEBY->FormValue;
        $this->NUM->CurrentValue = $this->NUM->FormValue;
        $this->ID->CurrentValue = $this->ID->FormValue;
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
        $this->PO_DATE->setDbValue($row['PO_DATE']);
        $this->ORDER_VALUE->setDbValue($row['ORDER_VALUE']);
        $this->RECEIVED_VALUE->setDbValue($row['RECEIVED_VALUE']);
        $this->PROCURE_METHOD->setDbValue($row['PROCURE_METHOD']);
        $this->COMPANY_ID->setDbValue($row['COMPANY_ID']);
        $this->FUND_ID->setDbValue($row['FUND_ID']);
        $this->FUND_NO->setDbValue($row['FUND_NO']);
        $this->DESCRIPTION->setDbValue($row['DESCRIPTION']);
        $this->MODIFIED_DATE->setDbValue($row['MODIFIED_DATE']);
        $this->MODIFIED_BY->setDbValue($row['MODIFIED_BY']);
        $this->ORDER_BY->setDbValue($row['ORDER_BY']);
        $this->SENT_TO->setDbValue($row['SENT_TO']);
        $this->ISVALID->setDbValue($row['ISVALID']);
        $this->START_VALID->setDbValue($row['START_VALID']);
        $this->END_VALID->setDbValue($row['END_VALID']);
        $this->CONTRACT_NO->setDbValue($row['CONTRACT_NO']);
        $this->ORG_ID->setDbValue($row['ORG_ID']);
        $this->CLINIC_ID->setDbValue($row['CLINIC_ID']);
        $this->ACCOUNT_ID->setDbValue($row['ACCOUNT_ID']);
        $this->PAID_VALUE->setDbValue($row['PAID_VALUE']);
        $this->PPN->setDbValue($row['PPN']);
        $this->MATERAI->setDbValue($row['MATERAI']);
        $this->PPN_VALUE->setDbValue($row['PPN_VALUE']);
        $this->DISCOUNT_VALUE->setDbValue($row['DISCOUNT_VALUE']);
        $this->ISCETAK->setDbValue($row['ISCETAK']);
        $this->PRINT_DATE->setDbValue($row['PRINT_DATE']);
        $this->PRINTED_BY->setDbValue($row['PRINTED_BY']);
        $this->PRINTQ->setDbValue($row['PRINTQ']);
        $this->TAGIHAN_VALUE->setDbValue($row['TAGIHAN_VALUE']);
        $this->ACKNOWLEDGEBY->setDbValue($row['ACKNOWLEDGEBY']);
        $this->NUM->setDbValue($row['NUM']);
        $this->ID->setDbValue($row['ID']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['ORG_UNIT_CODE'] = null;
        $row['PO'] = null;
        $row['PO_DATE'] = null;
        $row['ORDER_VALUE'] = null;
        $row['RECEIVED_VALUE'] = null;
        $row['PROCURE_METHOD'] = null;
        $row['COMPANY_ID'] = null;
        $row['FUND_ID'] = null;
        $row['FUND_NO'] = null;
        $row['DESCRIPTION'] = null;
        $row['MODIFIED_DATE'] = null;
        $row['MODIFIED_BY'] = null;
        $row['ORDER_BY'] = null;
        $row['SENT_TO'] = null;
        $row['ISVALID'] = null;
        $row['START_VALID'] = null;
        $row['END_VALID'] = null;
        $row['CONTRACT_NO'] = null;
        $row['ORG_ID'] = null;
        $row['CLINIC_ID'] = null;
        $row['ACCOUNT_ID'] = null;
        $row['PAID_VALUE'] = null;
        $row['PPN'] = null;
        $row['MATERAI'] = null;
        $row['PPN_VALUE'] = null;
        $row['DISCOUNT_VALUE'] = null;
        $row['ISCETAK'] = null;
        $row['PRINT_DATE'] = null;
        $row['PRINTED_BY'] = null;
        $row['PRINTQ'] = null;
        $row['TAGIHAN_VALUE'] = null;
        $row['ACKNOWLEDGEBY'] = null;
        $row['NUM'] = null;
        $row['ID'] = null;
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
        if ($this->ORDER_VALUE->FormValue == $this->ORDER_VALUE->CurrentValue && is_numeric(ConvertToFloatString($this->ORDER_VALUE->CurrentValue))) {
            $this->ORDER_VALUE->CurrentValue = ConvertToFloatString($this->ORDER_VALUE->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->RECEIVED_VALUE->FormValue == $this->RECEIVED_VALUE->CurrentValue && is_numeric(ConvertToFloatString($this->RECEIVED_VALUE->CurrentValue))) {
            $this->RECEIVED_VALUE->CurrentValue = ConvertToFloatString($this->RECEIVED_VALUE->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->PAID_VALUE->FormValue == $this->PAID_VALUE->CurrentValue && is_numeric(ConvertToFloatString($this->PAID_VALUE->CurrentValue))) {
            $this->PAID_VALUE->CurrentValue = ConvertToFloatString($this->PAID_VALUE->CurrentValue);
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
        if ($this->PPN_VALUE->FormValue == $this->PPN_VALUE->CurrentValue && is_numeric(ConvertToFloatString($this->PPN_VALUE->CurrentValue))) {
            $this->PPN_VALUE->CurrentValue = ConvertToFloatString($this->PPN_VALUE->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->DISCOUNT_VALUE->FormValue == $this->DISCOUNT_VALUE->CurrentValue && is_numeric(ConvertToFloatString($this->DISCOUNT_VALUE->CurrentValue))) {
            $this->DISCOUNT_VALUE->CurrentValue = ConvertToFloatString($this->DISCOUNT_VALUE->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->TAGIHAN_VALUE->FormValue == $this->TAGIHAN_VALUE->CurrentValue && is_numeric(ConvertToFloatString($this->TAGIHAN_VALUE->CurrentValue))) {
            $this->TAGIHAN_VALUE->CurrentValue = ConvertToFloatString($this->TAGIHAN_VALUE->CurrentValue);
        }

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // ORG_UNIT_CODE

        // PO

        // PO_DATE

        // ORDER_VALUE

        // RECEIVED_VALUE

        // PROCURE_METHOD

        // COMPANY_ID

        // FUND_ID

        // FUND_NO

        // DESCRIPTION

        // MODIFIED_DATE

        // MODIFIED_BY

        // ORDER_BY

        // SENT_TO

        // ISVALID

        // START_VALID

        // END_VALID

        // CONTRACT_NO

        // ORG_ID

        // CLINIC_ID

        // ACCOUNT_ID

        // PAID_VALUE

        // PPN

        // MATERAI

        // PPN_VALUE

        // DISCOUNT_VALUE

        // ISCETAK

        // PRINT_DATE

        // PRINTED_BY

        // PRINTQ

        // TAGIHAN_VALUE

        // ACKNOWLEDGEBY

        // NUM

        // ID
        if ($this->RowType == ROWTYPE_VIEW) {
            // ORG_UNIT_CODE
            $this->ORG_UNIT_CODE->ViewValue = $this->ORG_UNIT_CODE->CurrentValue;
            $this->ORG_UNIT_CODE->ViewCustomAttributes = "";

            // PO
            $this->PO->ViewValue = $this->PO->CurrentValue;
            $this->PO->ViewCustomAttributes = "";

            // PO_DATE
            $this->PO_DATE->ViewValue = $this->PO_DATE->CurrentValue;
            $this->PO_DATE->ViewValue = FormatDateTime($this->PO_DATE->ViewValue, 0);
            $this->PO_DATE->ViewCustomAttributes = "";

            // ORDER_VALUE
            $this->ORDER_VALUE->ViewValue = $this->ORDER_VALUE->CurrentValue;
            $this->ORDER_VALUE->ViewValue = FormatNumber($this->ORDER_VALUE->ViewValue, 2, -2, -2, -2);
            $this->ORDER_VALUE->ViewCustomAttributes = "";

            // RECEIVED_VALUE
            $this->RECEIVED_VALUE->ViewValue = $this->RECEIVED_VALUE->CurrentValue;
            $this->RECEIVED_VALUE->ViewValue = FormatNumber($this->RECEIVED_VALUE->ViewValue, 2, -2, -2, -2);
            $this->RECEIVED_VALUE->ViewCustomAttributes = "";

            // PROCURE_METHOD
            $this->PROCURE_METHOD->ViewValue = $this->PROCURE_METHOD->CurrentValue;
            $this->PROCURE_METHOD->ViewValue = FormatNumber($this->PROCURE_METHOD->ViewValue, 0, -2, -2, -2);
            $this->PROCURE_METHOD->ViewCustomAttributes = "";

            // COMPANY_ID
            $this->COMPANY_ID->ViewValue = $this->COMPANY_ID->CurrentValue;
            $this->COMPANY_ID->ViewCustomAttributes = "";

            // FUND_ID
            $this->FUND_ID->ViewValue = $this->FUND_ID->CurrentValue;
            $this->FUND_ID->ViewValue = FormatNumber($this->FUND_ID->ViewValue, 0, -2, -2, -2);
            $this->FUND_ID->ViewCustomAttributes = "";

            // FUND_NO
            $this->FUND_NO->ViewValue = $this->FUND_NO->CurrentValue;
            $this->FUND_NO->ViewCustomAttributes = "";

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

            // ORDER_BY
            $this->ORDER_BY->ViewValue = $this->ORDER_BY->CurrentValue;
            $this->ORDER_BY->ViewCustomAttributes = "";

            // SENT_TO
            $this->SENT_TO->ViewValue = $this->SENT_TO->CurrentValue;
            $this->SENT_TO->ViewCustomAttributes = "";

            // ISVALID
            $this->ISVALID->ViewValue = $this->ISVALID->CurrentValue;
            $this->ISVALID->ViewCustomAttributes = "";

            // START_VALID
            $this->START_VALID->ViewValue = $this->START_VALID->CurrentValue;
            $this->START_VALID->ViewValue = FormatDateTime($this->START_VALID->ViewValue, 0);
            $this->START_VALID->ViewCustomAttributes = "";

            // END_VALID
            $this->END_VALID->ViewValue = $this->END_VALID->CurrentValue;
            $this->END_VALID->ViewValue = FormatDateTime($this->END_VALID->ViewValue, 0);
            $this->END_VALID->ViewCustomAttributes = "";

            // CONTRACT_NO
            $this->CONTRACT_NO->ViewValue = $this->CONTRACT_NO->CurrentValue;
            $this->CONTRACT_NO->ViewCustomAttributes = "";

            // ORG_ID
            $this->ORG_ID->ViewValue = $this->ORG_ID->CurrentValue;
            $this->ORG_ID->ViewCustomAttributes = "";

            // CLINIC_ID
            $this->CLINIC_ID->ViewValue = $this->CLINIC_ID->CurrentValue;
            $this->CLINIC_ID->ViewCustomAttributes = "";

            // ACCOUNT_ID
            $this->ACCOUNT_ID->ViewValue = $this->ACCOUNT_ID->CurrentValue;
            $this->ACCOUNT_ID->ViewCustomAttributes = "";

            // PAID_VALUE
            $this->PAID_VALUE->ViewValue = $this->PAID_VALUE->CurrentValue;
            $this->PAID_VALUE->ViewValue = FormatNumber($this->PAID_VALUE->ViewValue, 2, -2, -2, -2);
            $this->PAID_VALUE->ViewCustomAttributes = "";

            // PPN
            $this->PPN->ViewValue = $this->PPN->CurrentValue;
            $this->PPN->ViewValue = FormatNumber($this->PPN->ViewValue, 2, -2, -2, -2);
            $this->PPN->ViewCustomAttributes = "";

            // MATERAI
            $this->MATERAI->ViewValue = $this->MATERAI->CurrentValue;
            $this->MATERAI->ViewValue = FormatNumber($this->MATERAI->ViewValue, 2, -2, -2, -2);
            $this->MATERAI->ViewCustomAttributes = "";

            // PPN_VALUE
            $this->PPN_VALUE->ViewValue = $this->PPN_VALUE->CurrentValue;
            $this->PPN_VALUE->ViewValue = FormatNumber($this->PPN_VALUE->ViewValue, 2, -2, -2, -2);
            $this->PPN_VALUE->ViewCustomAttributes = "";

            // DISCOUNT_VALUE
            $this->DISCOUNT_VALUE->ViewValue = $this->DISCOUNT_VALUE->CurrentValue;
            $this->DISCOUNT_VALUE->ViewValue = FormatNumber($this->DISCOUNT_VALUE->ViewValue, 2, -2, -2, -2);
            $this->DISCOUNT_VALUE->ViewCustomAttributes = "";

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

            // TAGIHAN_VALUE
            $this->TAGIHAN_VALUE->ViewValue = $this->TAGIHAN_VALUE->CurrentValue;
            $this->TAGIHAN_VALUE->ViewValue = FormatNumber($this->TAGIHAN_VALUE->ViewValue, 2, -2, -2, -2);
            $this->TAGIHAN_VALUE->ViewCustomAttributes = "";

            // ACKNOWLEDGEBY
            $this->ACKNOWLEDGEBY->ViewValue = $this->ACKNOWLEDGEBY->CurrentValue;
            $this->ACKNOWLEDGEBY->ViewCustomAttributes = "";

            // NUM
            $this->NUM->ViewValue = $this->NUM->CurrentValue;
            $this->NUM->ViewValue = FormatNumber($this->NUM->ViewValue, 0, -2, -2, -2);
            $this->NUM->ViewCustomAttributes = "";

            // ID
            $this->ID->ViewValue = $this->ID->CurrentValue;
            $this->ID->ViewCustomAttributes = "";

            // ORG_UNIT_CODE
            $this->ORG_UNIT_CODE->LinkCustomAttributes = "";
            $this->ORG_UNIT_CODE->HrefValue = "";
            $this->ORG_UNIT_CODE->TooltipValue = "";

            // PO
            $this->PO->LinkCustomAttributes = "";
            $this->PO->HrefValue = "";
            $this->PO->TooltipValue = "";

            // PO_DATE
            $this->PO_DATE->LinkCustomAttributes = "";
            $this->PO_DATE->HrefValue = "";
            $this->PO_DATE->TooltipValue = "";

            // ORDER_VALUE
            $this->ORDER_VALUE->LinkCustomAttributes = "";
            $this->ORDER_VALUE->HrefValue = "";
            $this->ORDER_VALUE->TooltipValue = "";

            // RECEIVED_VALUE
            $this->RECEIVED_VALUE->LinkCustomAttributes = "";
            $this->RECEIVED_VALUE->HrefValue = "";
            $this->RECEIVED_VALUE->TooltipValue = "";

            // PROCURE_METHOD
            $this->PROCURE_METHOD->LinkCustomAttributes = "";
            $this->PROCURE_METHOD->HrefValue = "";
            $this->PROCURE_METHOD->TooltipValue = "";

            // COMPANY_ID
            $this->COMPANY_ID->LinkCustomAttributes = "";
            $this->COMPANY_ID->HrefValue = "";
            $this->COMPANY_ID->TooltipValue = "";

            // FUND_ID
            $this->FUND_ID->LinkCustomAttributes = "";
            $this->FUND_ID->HrefValue = "";
            $this->FUND_ID->TooltipValue = "";

            // FUND_NO
            $this->FUND_NO->LinkCustomAttributes = "";
            $this->FUND_NO->HrefValue = "";
            $this->FUND_NO->TooltipValue = "";

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

            // ORDER_BY
            $this->ORDER_BY->LinkCustomAttributes = "";
            $this->ORDER_BY->HrefValue = "";
            $this->ORDER_BY->TooltipValue = "";

            // SENT_TO
            $this->SENT_TO->LinkCustomAttributes = "";
            $this->SENT_TO->HrefValue = "";
            $this->SENT_TO->TooltipValue = "";

            // ISVALID
            $this->ISVALID->LinkCustomAttributes = "";
            $this->ISVALID->HrefValue = "";
            $this->ISVALID->TooltipValue = "";

            // START_VALID
            $this->START_VALID->LinkCustomAttributes = "";
            $this->START_VALID->HrefValue = "";
            $this->START_VALID->TooltipValue = "";

            // END_VALID
            $this->END_VALID->LinkCustomAttributes = "";
            $this->END_VALID->HrefValue = "";
            $this->END_VALID->TooltipValue = "";

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

            // ACCOUNT_ID
            $this->ACCOUNT_ID->LinkCustomAttributes = "";
            $this->ACCOUNT_ID->HrefValue = "";
            $this->ACCOUNT_ID->TooltipValue = "";

            // PAID_VALUE
            $this->PAID_VALUE->LinkCustomAttributes = "";
            $this->PAID_VALUE->HrefValue = "";
            $this->PAID_VALUE->TooltipValue = "";

            // PPN
            $this->PPN->LinkCustomAttributes = "";
            $this->PPN->HrefValue = "";
            $this->PPN->TooltipValue = "";

            // MATERAI
            $this->MATERAI->LinkCustomAttributes = "";
            $this->MATERAI->HrefValue = "";
            $this->MATERAI->TooltipValue = "";

            // PPN_VALUE
            $this->PPN_VALUE->LinkCustomAttributes = "";
            $this->PPN_VALUE->HrefValue = "";
            $this->PPN_VALUE->TooltipValue = "";

            // DISCOUNT_VALUE
            $this->DISCOUNT_VALUE->LinkCustomAttributes = "";
            $this->DISCOUNT_VALUE->HrefValue = "";
            $this->DISCOUNT_VALUE->TooltipValue = "";

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

            // TAGIHAN_VALUE
            $this->TAGIHAN_VALUE->LinkCustomAttributes = "";
            $this->TAGIHAN_VALUE->HrefValue = "";
            $this->TAGIHAN_VALUE->TooltipValue = "";

            // ACKNOWLEDGEBY
            $this->ACKNOWLEDGEBY->LinkCustomAttributes = "";
            $this->ACKNOWLEDGEBY->HrefValue = "";
            $this->ACKNOWLEDGEBY->TooltipValue = "";

            // NUM
            $this->NUM->LinkCustomAttributes = "";
            $this->NUM->HrefValue = "";
            $this->NUM->TooltipValue = "";

            // ID
            $this->ID->LinkCustomAttributes = "";
            $this->ID->HrefValue = "";
            $this->ID->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_EDIT) {
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

            // PO_DATE
            $this->PO_DATE->EditAttrs["class"] = "form-control";
            $this->PO_DATE->EditCustomAttributes = "";
            $this->PO_DATE->EditValue = HtmlEncode(FormatDateTime($this->PO_DATE->CurrentValue, 8));
            $this->PO_DATE->PlaceHolder = RemoveHtml($this->PO_DATE->caption());

            // ORDER_VALUE
            $this->ORDER_VALUE->EditAttrs["class"] = "form-control";
            $this->ORDER_VALUE->EditCustomAttributes = "";
            $this->ORDER_VALUE->EditValue = HtmlEncode($this->ORDER_VALUE->CurrentValue);
            $this->ORDER_VALUE->PlaceHolder = RemoveHtml($this->ORDER_VALUE->caption());
            if (strval($this->ORDER_VALUE->EditValue) != "" && is_numeric($this->ORDER_VALUE->EditValue)) {
                $this->ORDER_VALUE->EditValue = FormatNumber($this->ORDER_VALUE->EditValue, -2, -2, -2, -2);
            }

            // RECEIVED_VALUE
            $this->RECEIVED_VALUE->EditAttrs["class"] = "form-control";
            $this->RECEIVED_VALUE->EditCustomAttributes = "";
            $this->RECEIVED_VALUE->EditValue = HtmlEncode($this->RECEIVED_VALUE->CurrentValue);
            $this->RECEIVED_VALUE->PlaceHolder = RemoveHtml($this->RECEIVED_VALUE->caption());
            if (strval($this->RECEIVED_VALUE->EditValue) != "" && is_numeric($this->RECEIVED_VALUE->EditValue)) {
                $this->RECEIVED_VALUE->EditValue = FormatNumber($this->RECEIVED_VALUE->EditValue, -2, -2, -2, -2);
            }

            // PROCURE_METHOD
            $this->PROCURE_METHOD->EditAttrs["class"] = "form-control";
            $this->PROCURE_METHOD->EditCustomAttributes = "";
            $this->PROCURE_METHOD->EditValue = HtmlEncode($this->PROCURE_METHOD->CurrentValue);
            $this->PROCURE_METHOD->PlaceHolder = RemoveHtml($this->PROCURE_METHOD->caption());

            // COMPANY_ID
            $this->COMPANY_ID->EditAttrs["class"] = "form-control";
            $this->COMPANY_ID->EditCustomAttributes = "";
            if (!$this->COMPANY_ID->Raw) {
                $this->COMPANY_ID->CurrentValue = HtmlDecode($this->COMPANY_ID->CurrentValue);
            }
            $this->COMPANY_ID->EditValue = HtmlEncode($this->COMPANY_ID->CurrentValue);
            $this->COMPANY_ID->PlaceHolder = RemoveHtml($this->COMPANY_ID->caption());

            // FUND_ID
            $this->FUND_ID->EditAttrs["class"] = "form-control";
            $this->FUND_ID->EditCustomAttributes = "";
            $this->FUND_ID->EditValue = HtmlEncode($this->FUND_ID->CurrentValue);
            $this->FUND_ID->PlaceHolder = RemoveHtml($this->FUND_ID->caption());

            // FUND_NO
            $this->FUND_NO->EditAttrs["class"] = "form-control";
            $this->FUND_NO->EditCustomAttributes = "";
            if (!$this->FUND_NO->Raw) {
                $this->FUND_NO->CurrentValue = HtmlDecode($this->FUND_NO->CurrentValue);
            }
            $this->FUND_NO->EditValue = HtmlEncode($this->FUND_NO->CurrentValue);
            $this->FUND_NO->PlaceHolder = RemoveHtml($this->FUND_NO->caption());

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

            // ORDER_BY
            $this->ORDER_BY->EditAttrs["class"] = "form-control";
            $this->ORDER_BY->EditCustomAttributes = "";
            if (!$this->ORDER_BY->Raw) {
                $this->ORDER_BY->CurrentValue = HtmlDecode($this->ORDER_BY->CurrentValue);
            }
            $this->ORDER_BY->EditValue = HtmlEncode($this->ORDER_BY->CurrentValue);
            $this->ORDER_BY->PlaceHolder = RemoveHtml($this->ORDER_BY->caption());

            // SENT_TO
            $this->SENT_TO->EditAttrs["class"] = "form-control";
            $this->SENT_TO->EditCustomAttributes = "";
            if (!$this->SENT_TO->Raw) {
                $this->SENT_TO->CurrentValue = HtmlDecode($this->SENT_TO->CurrentValue);
            }
            $this->SENT_TO->EditValue = HtmlEncode($this->SENT_TO->CurrentValue);
            $this->SENT_TO->PlaceHolder = RemoveHtml($this->SENT_TO->caption());

            // ISVALID
            $this->ISVALID->EditAttrs["class"] = "form-control";
            $this->ISVALID->EditCustomAttributes = "";
            if (!$this->ISVALID->Raw) {
                $this->ISVALID->CurrentValue = HtmlDecode($this->ISVALID->CurrentValue);
            }
            $this->ISVALID->EditValue = HtmlEncode($this->ISVALID->CurrentValue);
            $this->ISVALID->PlaceHolder = RemoveHtml($this->ISVALID->caption());

            // START_VALID
            $this->START_VALID->EditAttrs["class"] = "form-control";
            $this->START_VALID->EditCustomAttributes = "";
            $this->START_VALID->EditValue = HtmlEncode(FormatDateTime($this->START_VALID->CurrentValue, 8));
            $this->START_VALID->PlaceHolder = RemoveHtml($this->START_VALID->caption());

            // END_VALID
            $this->END_VALID->EditAttrs["class"] = "form-control";
            $this->END_VALID->EditCustomAttributes = "";
            $this->END_VALID->EditValue = HtmlEncode(FormatDateTime($this->END_VALID->CurrentValue, 8));
            $this->END_VALID->PlaceHolder = RemoveHtml($this->END_VALID->caption());

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

            // ACCOUNT_ID
            $this->ACCOUNT_ID->EditAttrs["class"] = "form-control";
            $this->ACCOUNT_ID->EditCustomAttributes = "";
            if (!$this->ACCOUNT_ID->Raw) {
                $this->ACCOUNT_ID->CurrentValue = HtmlDecode($this->ACCOUNT_ID->CurrentValue);
            }
            $this->ACCOUNT_ID->EditValue = HtmlEncode($this->ACCOUNT_ID->CurrentValue);
            $this->ACCOUNT_ID->PlaceHolder = RemoveHtml($this->ACCOUNT_ID->caption());

            // PAID_VALUE
            $this->PAID_VALUE->EditAttrs["class"] = "form-control";
            $this->PAID_VALUE->EditCustomAttributes = "";
            $this->PAID_VALUE->EditValue = HtmlEncode($this->PAID_VALUE->CurrentValue);
            $this->PAID_VALUE->PlaceHolder = RemoveHtml($this->PAID_VALUE->caption());
            if (strval($this->PAID_VALUE->EditValue) != "" && is_numeric($this->PAID_VALUE->EditValue)) {
                $this->PAID_VALUE->EditValue = FormatNumber($this->PAID_VALUE->EditValue, -2, -2, -2, -2);
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

            // TAGIHAN_VALUE
            $this->TAGIHAN_VALUE->EditAttrs["class"] = "form-control";
            $this->TAGIHAN_VALUE->EditCustomAttributes = "";
            $this->TAGIHAN_VALUE->EditValue = HtmlEncode($this->TAGIHAN_VALUE->CurrentValue);
            $this->TAGIHAN_VALUE->PlaceHolder = RemoveHtml($this->TAGIHAN_VALUE->caption());
            if (strval($this->TAGIHAN_VALUE->EditValue) != "" && is_numeric($this->TAGIHAN_VALUE->EditValue)) {
                $this->TAGIHAN_VALUE->EditValue = FormatNumber($this->TAGIHAN_VALUE->EditValue, -2, -2, -2, -2);
            }

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

            // ID
            $this->ID->EditAttrs["class"] = "form-control";
            $this->ID->EditCustomAttributes = "";
            $this->ID->EditValue = $this->ID->CurrentValue;
            $this->ID->ViewCustomAttributes = "";

            // Edit refer script

            // ORG_UNIT_CODE
            $this->ORG_UNIT_CODE->LinkCustomAttributes = "";
            $this->ORG_UNIT_CODE->HrefValue = "";

            // PO
            $this->PO->LinkCustomAttributes = "";
            $this->PO->HrefValue = "";

            // PO_DATE
            $this->PO_DATE->LinkCustomAttributes = "";
            $this->PO_DATE->HrefValue = "";

            // ORDER_VALUE
            $this->ORDER_VALUE->LinkCustomAttributes = "";
            $this->ORDER_VALUE->HrefValue = "";

            // RECEIVED_VALUE
            $this->RECEIVED_VALUE->LinkCustomAttributes = "";
            $this->RECEIVED_VALUE->HrefValue = "";

            // PROCURE_METHOD
            $this->PROCURE_METHOD->LinkCustomAttributes = "";
            $this->PROCURE_METHOD->HrefValue = "";

            // COMPANY_ID
            $this->COMPANY_ID->LinkCustomAttributes = "";
            $this->COMPANY_ID->HrefValue = "";

            // FUND_ID
            $this->FUND_ID->LinkCustomAttributes = "";
            $this->FUND_ID->HrefValue = "";

            // FUND_NO
            $this->FUND_NO->LinkCustomAttributes = "";
            $this->FUND_NO->HrefValue = "";

            // DESCRIPTION
            $this->DESCRIPTION->LinkCustomAttributes = "";
            $this->DESCRIPTION->HrefValue = "";

            // MODIFIED_DATE
            $this->MODIFIED_DATE->LinkCustomAttributes = "";
            $this->MODIFIED_DATE->HrefValue = "";

            // MODIFIED_BY
            $this->MODIFIED_BY->LinkCustomAttributes = "";
            $this->MODIFIED_BY->HrefValue = "";

            // ORDER_BY
            $this->ORDER_BY->LinkCustomAttributes = "";
            $this->ORDER_BY->HrefValue = "";

            // SENT_TO
            $this->SENT_TO->LinkCustomAttributes = "";
            $this->SENT_TO->HrefValue = "";

            // ISVALID
            $this->ISVALID->LinkCustomAttributes = "";
            $this->ISVALID->HrefValue = "";

            // START_VALID
            $this->START_VALID->LinkCustomAttributes = "";
            $this->START_VALID->HrefValue = "";

            // END_VALID
            $this->END_VALID->LinkCustomAttributes = "";
            $this->END_VALID->HrefValue = "";

            // CONTRACT_NO
            $this->CONTRACT_NO->LinkCustomAttributes = "";
            $this->CONTRACT_NO->HrefValue = "";

            // ORG_ID
            $this->ORG_ID->LinkCustomAttributes = "";
            $this->ORG_ID->HrefValue = "";

            // CLINIC_ID
            $this->CLINIC_ID->LinkCustomAttributes = "";
            $this->CLINIC_ID->HrefValue = "";

            // ACCOUNT_ID
            $this->ACCOUNT_ID->LinkCustomAttributes = "";
            $this->ACCOUNT_ID->HrefValue = "";

            // PAID_VALUE
            $this->PAID_VALUE->LinkCustomAttributes = "";
            $this->PAID_VALUE->HrefValue = "";

            // PPN
            $this->PPN->LinkCustomAttributes = "";
            $this->PPN->HrefValue = "";

            // MATERAI
            $this->MATERAI->LinkCustomAttributes = "";
            $this->MATERAI->HrefValue = "";

            // PPN_VALUE
            $this->PPN_VALUE->LinkCustomAttributes = "";
            $this->PPN_VALUE->HrefValue = "";

            // DISCOUNT_VALUE
            $this->DISCOUNT_VALUE->LinkCustomAttributes = "";
            $this->DISCOUNT_VALUE->HrefValue = "";

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

            // TAGIHAN_VALUE
            $this->TAGIHAN_VALUE->LinkCustomAttributes = "";
            $this->TAGIHAN_VALUE->HrefValue = "";

            // ACKNOWLEDGEBY
            $this->ACKNOWLEDGEBY->LinkCustomAttributes = "";
            $this->ACKNOWLEDGEBY->HrefValue = "";

            // NUM
            $this->NUM->LinkCustomAttributes = "";
            $this->NUM->HrefValue = "";

            // ID
            $this->ID->LinkCustomAttributes = "";
            $this->ID->HrefValue = "";
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
        if ($this->PO_DATE->Required) {
            if (!$this->PO_DATE->IsDetailKey && EmptyValue($this->PO_DATE->FormValue)) {
                $this->PO_DATE->addErrorMessage(str_replace("%s", $this->PO_DATE->caption(), $this->PO_DATE->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->PO_DATE->FormValue)) {
            $this->PO_DATE->addErrorMessage($this->PO_DATE->getErrorMessage(false));
        }
        if ($this->ORDER_VALUE->Required) {
            if (!$this->ORDER_VALUE->IsDetailKey && EmptyValue($this->ORDER_VALUE->FormValue)) {
                $this->ORDER_VALUE->addErrorMessage(str_replace("%s", $this->ORDER_VALUE->caption(), $this->ORDER_VALUE->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->ORDER_VALUE->FormValue)) {
            $this->ORDER_VALUE->addErrorMessage($this->ORDER_VALUE->getErrorMessage(false));
        }
        if ($this->RECEIVED_VALUE->Required) {
            if (!$this->RECEIVED_VALUE->IsDetailKey && EmptyValue($this->RECEIVED_VALUE->FormValue)) {
                $this->RECEIVED_VALUE->addErrorMessage(str_replace("%s", $this->RECEIVED_VALUE->caption(), $this->RECEIVED_VALUE->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->RECEIVED_VALUE->FormValue)) {
            $this->RECEIVED_VALUE->addErrorMessage($this->RECEIVED_VALUE->getErrorMessage(false));
        }
        if ($this->PROCURE_METHOD->Required) {
            if (!$this->PROCURE_METHOD->IsDetailKey && EmptyValue($this->PROCURE_METHOD->FormValue)) {
                $this->PROCURE_METHOD->addErrorMessage(str_replace("%s", $this->PROCURE_METHOD->caption(), $this->PROCURE_METHOD->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->PROCURE_METHOD->FormValue)) {
            $this->PROCURE_METHOD->addErrorMessage($this->PROCURE_METHOD->getErrorMessage(false));
        }
        if ($this->COMPANY_ID->Required) {
            if (!$this->COMPANY_ID->IsDetailKey && EmptyValue($this->COMPANY_ID->FormValue)) {
                $this->COMPANY_ID->addErrorMessage(str_replace("%s", $this->COMPANY_ID->caption(), $this->COMPANY_ID->RequiredErrorMessage));
            }
        }
        if ($this->FUND_ID->Required) {
            if (!$this->FUND_ID->IsDetailKey && EmptyValue($this->FUND_ID->FormValue)) {
                $this->FUND_ID->addErrorMessage(str_replace("%s", $this->FUND_ID->caption(), $this->FUND_ID->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->FUND_ID->FormValue)) {
            $this->FUND_ID->addErrorMessage($this->FUND_ID->getErrorMessage(false));
        }
        if ($this->FUND_NO->Required) {
            if (!$this->FUND_NO->IsDetailKey && EmptyValue($this->FUND_NO->FormValue)) {
                $this->FUND_NO->addErrorMessage(str_replace("%s", $this->FUND_NO->caption(), $this->FUND_NO->RequiredErrorMessage));
            }
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
        if ($this->ORDER_BY->Required) {
            if (!$this->ORDER_BY->IsDetailKey && EmptyValue($this->ORDER_BY->FormValue)) {
                $this->ORDER_BY->addErrorMessage(str_replace("%s", $this->ORDER_BY->caption(), $this->ORDER_BY->RequiredErrorMessage));
            }
        }
        if ($this->SENT_TO->Required) {
            if (!$this->SENT_TO->IsDetailKey && EmptyValue($this->SENT_TO->FormValue)) {
                $this->SENT_TO->addErrorMessage(str_replace("%s", $this->SENT_TO->caption(), $this->SENT_TO->RequiredErrorMessage));
            }
        }
        if ($this->ISVALID->Required) {
            if (!$this->ISVALID->IsDetailKey && EmptyValue($this->ISVALID->FormValue)) {
                $this->ISVALID->addErrorMessage(str_replace("%s", $this->ISVALID->caption(), $this->ISVALID->RequiredErrorMessage));
            }
        }
        if ($this->START_VALID->Required) {
            if (!$this->START_VALID->IsDetailKey && EmptyValue($this->START_VALID->FormValue)) {
                $this->START_VALID->addErrorMessage(str_replace("%s", $this->START_VALID->caption(), $this->START_VALID->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->START_VALID->FormValue)) {
            $this->START_VALID->addErrorMessage($this->START_VALID->getErrorMessage(false));
        }
        if ($this->END_VALID->Required) {
            if (!$this->END_VALID->IsDetailKey && EmptyValue($this->END_VALID->FormValue)) {
                $this->END_VALID->addErrorMessage(str_replace("%s", $this->END_VALID->caption(), $this->END_VALID->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->END_VALID->FormValue)) {
            $this->END_VALID->addErrorMessage($this->END_VALID->getErrorMessage(false));
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
        if ($this->ACCOUNT_ID->Required) {
            if (!$this->ACCOUNT_ID->IsDetailKey && EmptyValue($this->ACCOUNT_ID->FormValue)) {
                $this->ACCOUNT_ID->addErrorMessage(str_replace("%s", $this->ACCOUNT_ID->caption(), $this->ACCOUNT_ID->RequiredErrorMessage));
            }
        }
        if ($this->PAID_VALUE->Required) {
            if (!$this->PAID_VALUE->IsDetailKey && EmptyValue($this->PAID_VALUE->FormValue)) {
                $this->PAID_VALUE->addErrorMessage(str_replace("%s", $this->PAID_VALUE->caption(), $this->PAID_VALUE->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->PAID_VALUE->FormValue)) {
            $this->PAID_VALUE->addErrorMessage($this->PAID_VALUE->getErrorMessage(false));
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
        if ($this->TAGIHAN_VALUE->Required) {
            if (!$this->TAGIHAN_VALUE->IsDetailKey && EmptyValue($this->TAGIHAN_VALUE->FormValue)) {
                $this->TAGIHAN_VALUE->addErrorMessage(str_replace("%s", $this->TAGIHAN_VALUE->caption(), $this->TAGIHAN_VALUE->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->TAGIHAN_VALUE->FormValue)) {
            $this->TAGIHAN_VALUE->addErrorMessage($this->TAGIHAN_VALUE->getErrorMessage(false));
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
        if ($this->ID->Required) {
            if (!$this->ID->IsDetailKey && EmptyValue($this->ID->FormValue)) {
                $this->ID->addErrorMessage(str_replace("%s", $this->ID->caption(), $this->ID->RequiredErrorMessage));
            }
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

    // Update record based on key values
    protected function editRow()
    {
        global $Security, $Language;
        $oldKeyFilter = $this->getRecordFilter();
        $filter = $this->applyUserIDFilters($oldKeyFilter);
        $conn = $this->getConnection();
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $rsold = $conn->fetchAssoc($sql);
        $editRow = false;
        if (!$rsold) {
            $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
            $editRow = false; // Update Failed
        } else {
            // Save old values
            $this->loadDbValues($rsold);
            $rsnew = [];

            // ORG_UNIT_CODE
            $this->ORG_UNIT_CODE->setDbValueDef($rsnew, $this->ORG_UNIT_CODE->CurrentValue, "", $this->ORG_UNIT_CODE->ReadOnly);

            // PO
            $this->PO->setDbValueDef($rsnew, $this->PO->CurrentValue, "", $this->PO->ReadOnly);

            // PO_DATE
            $this->PO_DATE->setDbValueDef($rsnew, UnFormatDateTime($this->PO_DATE->CurrentValue, 0), null, $this->PO_DATE->ReadOnly);

            // ORDER_VALUE
            $this->ORDER_VALUE->setDbValueDef($rsnew, $this->ORDER_VALUE->CurrentValue, null, $this->ORDER_VALUE->ReadOnly);

            // RECEIVED_VALUE
            $this->RECEIVED_VALUE->setDbValueDef($rsnew, $this->RECEIVED_VALUE->CurrentValue, null, $this->RECEIVED_VALUE->ReadOnly);

            // PROCURE_METHOD
            $this->PROCURE_METHOD->setDbValueDef($rsnew, $this->PROCURE_METHOD->CurrentValue, null, $this->PROCURE_METHOD->ReadOnly);

            // COMPANY_ID
            $this->COMPANY_ID->setDbValueDef($rsnew, $this->COMPANY_ID->CurrentValue, null, $this->COMPANY_ID->ReadOnly);

            // FUND_ID
            $this->FUND_ID->setDbValueDef($rsnew, $this->FUND_ID->CurrentValue, null, $this->FUND_ID->ReadOnly);

            // FUND_NO
            $this->FUND_NO->setDbValueDef($rsnew, $this->FUND_NO->CurrentValue, null, $this->FUND_NO->ReadOnly);

            // DESCRIPTION
            $this->DESCRIPTION->setDbValueDef($rsnew, $this->DESCRIPTION->CurrentValue, null, $this->DESCRIPTION->ReadOnly);

            // MODIFIED_DATE
            $this->MODIFIED_DATE->setDbValueDef($rsnew, UnFormatDateTime($this->MODIFIED_DATE->CurrentValue, 0), null, $this->MODIFIED_DATE->ReadOnly);

            // MODIFIED_BY
            $this->MODIFIED_BY->setDbValueDef($rsnew, $this->MODIFIED_BY->CurrentValue, null, $this->MODIFIED_BY->ReadOnly);

            // ORDER_BY
            $this->ORDER_BY->setDbValueDef($rsnew, $this->ORDER_BY->CurrentValue, null, $this->ORDER_BY->ReadOnly);

            // SENT_TO
            $this->SENT_TO->setDbValueDef($rsnew, $this->SENT_TO->CurrentValue, null, $this->SENT_TO->ReadOnly);

            // ISVALID
            $this->ISVALID->setDbValueDef($rsnew, $this->ISVALID->CurrentValue, null, $this->ISVALID->ReadOnly);

            // START_VALID
            $this->START_VALID->setDbValueDef($rsnew, UnFormatDateTime($this->START_VALID->CurrentValue, 0), null, $this->START_VALID->ReadOnly);

            // END_VALID
            $this->END_VALID->setDbValueDef($rsnew, UnFormatDateTime($this->END_VALID->CurrentValue, 0), null, $this->END_VALID->ReadOnly);

            // CONTRACT_NO
            $this->CONTRACT_NO->setDbValueDef($rsnew, $this->CONTRACT_NO->CurrentValue, null, $this->CONTRACT_NO->ReadOnly);

            // ORG_ID
            $this->ORG_ID->setDbValueDef($rsnew, $this->ORG_ID->CurrentValue, null, $this->ORG_ID->ReadOnly);

            // CLINIC_ID
            $this->CLINIC_ID->setDbValueDef($rsnew, $this->CLINIC_ID->CurrentValue, null, $this->CLINIC_ID->ReadOnly);

            // ACCOUNT_ID
            $this->ACCOUNT_ID->setDbValueDef($rsnew, $this->ACCOUNT_ID->CurrentValue, null, $this->ACCOUNT_ID->ReadOnly);

            // PAID_VALUE
            $this->PAID_VALUE->setDbValueDef($rsnew, $this->PAID_VALUE->CurrentValue, null, $this->PAID_VALUE->ReadOnly);

            // PPN
            $this->PPN->setDbValueDef($rsnew, $this->PPN->CurrentValue, null, $this->PPN->ReadOnly);

            // MATERAI
            $this->MATERAI->setDbValueDef($rsnew, $this->MATERAI->CurrentValue, null, $this->MATERAI->ReadOnly);

            // PPN_VALUE
            $this->PPN_VALUE->setDbValueDef($rsnew, $this->PPN_VALUE->CurrentValue, null, $this->PPN_VALUE->ReadOnly);

            // DISCOUNT_VALUE
            $this->DISCOUNT_VALUE->setDbValueDef($rsnew, $this->DISCOUNT_VALUE->CurrentValue, null, $this->DISCOUNT_VALUE->ReadOnly);

            // ISCETAK
            $this->ISCETAK->setDbValueDef($rsnew, $this->ISCETAK->CurrentValue, null, $this->ISCETAK->ReadOnly);

            // PRINT_DATE
            $this->PRINT_DATE->setDbValueDef($rsnew, UnFormatDateTime($this->PRINT_DATE->CurrentValue, 0), null, $this->PRINT_DATE->ReadOnly);

            // PRINTED_BY
            $this->PRINTED_BY->setDbValueDef($rsnew, $this->PRINTED_BY->CurrentValue, null, $this->PRINTED_BY->ReadOnly);

            // PRINTQ
            $this->PRINTQ->setDbValueDef($rsnew, $this->PRINTQ->CurrentValue, null, $this->PRINTQ->ReadOnly);

            // TAGIHAN_VALUE
            $this->TAGIHAN_VALUE->setDbValueDef($rsnew, $this->TAGIHAN_VALUE->CurrentValue, null, $this->TAGIHAN_VALUE->ReadOnly);

            // ACKNOWLEDGEBY
            $this->ACKNOWLEDGEBY->setDbValueDef($rsnew, $this->ACKNOWLEDGEBY->CurrentValue, null, $this->ACKNOWLEDGEBY->ReadOnly);

            // NUM
            $this->NUM->setDbValueDef($rsnew, $this->NUM->CurrentValue, null, $this->NUM->ReadOnly);

            // Call Row Updating event
            $updateRow = $this->rowUpdating($rsold, $rsnew);
            if ($updateRow) {
                if (count($rsnew) > 0) {
                    try {
                        $editRow = $this->update($rsnew, "", $rsold);
                    } catch (\Exception $e) {
                        $this->setFailureMessage($e->getMessage());
                    }
                } else {
                    $editRow = true; // No field to update
                }
                if ($editRow) {
                }
            } else {
                if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                    // Use the message, do nothing
                } elseif ($this->CancelMessage != "") {
                    $this->setFailureMessage($this->CancelMessage);
                    $this->CancelMessage = "";
                } else {
                    $this->setFailureMessage($Language->phrase("UpdateCancelled"));
                }
                $editRow = false;
            }
        }

        // Call Row_Updated event
        if ($editRow) {
            $this->rowUpdated($rsold, $rsnew);
        }

        // Clean upload path if any
        if ($editRow) {
        }

        // Write JSON for API request
        if (IsApi() && $editRow) {
            $row = $this->getRecordsFromRecordset([$rsnew], true);
            WriteJson(["success" => true, $this->TableVar => $row]);
        }
        return $editRow;
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("PoList"), "", $this->TableVar, true);
        $pageId = "edit";
        $Breadcrumb->add("edit", $pageId, $url);
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

    // Set up starting record parameters
    public function setupStartRecord()
    {
        if ($this->DisplayRecords == 0) {
            return;
        }
        if ($this->isPageRequest()) { // Validate request
            $startRec = Get(Config("TABLE_START_REC"));
            $pageNo = Get(Config("TABLE_PAGE_NO"));
            if ($pageNo !== null) { // Check for "pageno" parameter first
                if (is_numeric($pageNo)) {
                    $this->StartRecord = ($pageNo - 1) * $this->DisplayRecords + 1;
                    if ($this->StartRecord <= 0) {
                        $this->StartRecord = 1;
                    } elseif ($this->StartRecord >= (int)(($this->TotalRecords - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1) {
                        $this->StartRecord = (int)(($this->TotalRecords - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1;
                    }
                    $this->setStartRecordNumber($this->StartRecord);
                }
            } elseif ($startRec !== null) { // Check for "start" parameter
                $this->StartRecord = $startRec;
                $this->setStartRecordNumber($this->StartRecord);
            }
        }
        $this->StartRecord = $this->getStartRecordNumber();

        // Check if correct start record counter
        if (!is_numeric($this->StartRecord) || $this->StartRecord == "") { // Avoid invalid start record counter
            $this->StartRecord = 1; // Reset start record counter
            $this->setStartRecordNumber($this->StartRecord);
        } elseif ($this->StartRecord > $this->TotalRecords) { // Avoid starting record > total records
            $this->StartRecord = (int)(($this->TotalRecords - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1; // Point to last page first record
            $this->setStartRecordNumber($this->StartRecord);
        } elseif (($this->StartRecord - 1) % $this->DisplayRecords != 0) {
            $this->StartRecord = (int)(($this->StartRecord - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1; // Point to page boundary
            $this->setStartRecordNumber($this->StartRecord);
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
