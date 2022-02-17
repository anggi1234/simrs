<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class WebsiteMenuAdd extends WebsiteMenu
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'WEBSITE_MENU';

    // Page object name
    public $PageObjName = "WebsiteMenuAdd";

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

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("language");

        // Parent constuctor
        parent::__construct();

        // Table object (WEBSITE_MENU)
        if (!isset($GLOBALS["WEBSITE_MENU"]) || get_class($GLOBALS["WEBSITE_MENU"]) == PROJECT_NAMESPACE . "WEBSITE_MENU") {
            $GLOBALS["WEBSITE_MENU"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'WEBSITE_MENU');
        }

        // Start timer
        $DebugTimer = Container("timer");

        // Debug message
        LoadDebugMessage();

        // Open connection
        $GLOBALS["Conn"] = $GLOBALS["Conn"] ?? $this->getConnection();
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
                $doc = new $class(Container("WEBSITE_MENU"));
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
                    if ($pageName == "WebsiteMenuView") {
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
            $key .= @$ar['MENU_ID'];
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
        $this->MENU_ID->setVisibility();
        $this->javascript_id->setVisibility();
        $this->file_name->setVisibility();
        $this->menu_name->setVisibility();
        $this->isactive->setVisibility();
        $this->menu_type->setVisibility();
        $this->header_name->setVisibility();
        $this->isslide->setVisibility();
        $this->timeslide->setVisibility();
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
            if (($keyValue = Get("MENU_ID") ?? Route("MENU_ID")) !== null) {
                $this->MENU_ID->setQueryStringValue($keyValue);
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
                    $this->terminate("WebsiteMenuList"); // No matching record, return to list
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
                    if (GetPageName($returnUrl) == "WebsiteMenuList") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "WebsiteMenuView") {
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
        $this->MENU_ID->CurrentValue = null;
        $this->MENU_ID->OldValue = $this->MENU_ID->CurrentValue;
        $this->javascript_id->CurrentValue = null;
        $this->javascript_id->OldValue = $this->javascript_id->CurrentValue;
        $this->file_name->CurrentValue = null;
        $this->file_name->OldValue = $this->file_name->CurrentValue;
        $this->menu_name->CurrentValue = null;
        $this->menu_name->OldValue = $this->menu_name->CurrentValue;
        $this->isactive->CurrentValue = null;
        $this->isactive->OldValue = $this->isactive->CurrentValue;
        $this->menu_type->CurrentValue = null;
        $this->menu_type->OldValue = $this->menu_type->CurrentValue;
        $this->header_name->CurrentValue = null;
        $this->header_name->OldValue = $this->header_name->CurrentValue;
        $this->isslide->CurrentValue = null;
        $this->isslide->OldValue = $this->isslide->CurrentValue;
        $this->timeslide->CurrentValue = null;
        $this->timeslide->OldValue = $this->timeslide->CurrentValue;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;

        // Check field name 'MENU_ID' first before field var 'x_MENU_ID'
        $val = $CurrentForm->hasValue("MENU_ID") ? $CurrentForm->getValue("MENU_ID") : $CurrentForm->getValue("x_MENU_ID");
        if (!$this->MENU_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->MENU_ID->Visible = false; // Disable update for API request
            } else {
                $this->MENU_ID->setFormValue($val);
            }
        }

        // Check field name 'javascript_id' first before field var 'x_javascript_id'
        $val = $CurrentForm->hasValue("javascript_id") ? $CurrentForm->getValue("javascript_id") : $CurrentForm->getValue("x_javascript_id");
        if (!$this->javascript_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->javascript_id->Visible = false; // Disable update for API request
            } else {
                $this->javascript_id->setFormValue($val);
            }
        }

        // Check field name 'file_name' first before field var 'x_file_name'
        $val = $CurrentForm->hasValue("file_name") ? $CurrentForm->getValue("file_name") : $CurrentForm->getValue("x_file_name");
        if (!$this->file_name->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->file_name->Visible = false; // Disable update for API request
            } else {
                $this->file_name->setFormValue($val);
            }
        }

        // Check field name 'menu_name' first before field var 'x_menu_name'
        $val = $CurrentForm->hasValue("menu_name") ? $CurrentForm->getValue("menu_name") : $CurrentForm->getValue("x_menu_name");
        if (!$this->menu_name->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->menu_name->Visible = false; // Disable update for API request
            } else {
                $this->menu_name->setFormValue($val);
            }
        }

        // Check field name 'isactive' first before field var 'x_isactive'
        $val = $CurrentForm->hasValue("isactive") ? $CurrentForm->getValue("isactive") : $CurrentForm->getValue("x_isactive");
        if (!$this->isactive->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->isactive->Visible = false; // Disable update for API request
            } else {
                $this->isactive->setFormValue($val);
            }
        }

        // Check field name 'menu_type' first before field var 'x_menu_type'
        $val = $CurrentForm->hasValue("menu_type") ? $CurrentForm->getValue("menu_type") : $CurrentForm->getValue("x_menu_type");
        if (!$this->menu_type->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->menu_type->Visible = false; // Disable update for API request
            } else {
                $this->menu_type->setFormValue($val);
            }
        }

        // Check field name 'header_name' first before field var 'x_header_name'
        $val = $CurrentForm->hasValue("header_name") ? $CurrentForm->getValue("header_name") : $CurrentForm->getValue("x_header_name");
        if (!$this->header_name->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->header_name->Visible = false; // Disable update for API request
            } else {
                $this->header_name->setFormValue($val);
            }
        }

        // Check field name 'isslide' first before field var 'x_isslide'
        $val = $CurrentForm->hasValue("isslide") ? $CurrentForm->getValue("isslide") : $CurrentForm->getValue("x_isslide");
        if (!$this->isslide->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->isslide->Visible = false; // Disable update for API request
            } else {
                $this->isslide->setFormValue($val);
            }
        }

        // Check field name 'timeslide' first before field var 'x_timeslide'
        $val = $CurrentForm->hasValue("timeslide") ? $CurrentForm->getValue("timeslide") : $CurrentForm->getValue("x_timeslide");
        if (!$this->timeslide->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->timeslide->Visible = false; // Disable update for API request
            } else {
                $this->timeslide->setFormValue($val);
            }
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->MENU_ID->CurrentValue = $this->MENU_ID->FormValue;
        $this->javascript_id->CurrentValue = $this->javascript_id->FormValue;
        $this->file_name->CurrentValue = $this->file_name->FormValue;
        $this->menu_name->CurrentValue = $this->menu_name->FormValue;
        $this->isactive->CurrentValue = $this->isactive->FormValue;
        $this->menu_type->CurrentValue = $this->menu_type->FormValue;
        $this->header_name->CurrentValue = $this->header_name->FormValue;
        $this->isslide->CurrentValue = $this->isslide->FormValue;
        $this->timeslide->CurrentValue = $this->timeslide->FormValue;
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
        $this->MENU_ID->setDbValue($row['MENU_ID']);
        $this->javascript_id->setDbValue($row['javascript_id']);
        $this->file_name->setDbValue($row['file_name']);
        $this->menu_name->setDbValue($row['menu_name']);
        $this->isactive->setDbValue($row['isactive']);
        $this->menu_type->setDbValue($row['menu_type']);
        $this->header_name->setDbValue($row['header_name']);
        $this->isslide->setDbValue($row['isslide']);
        $this->timeslide->setDbValue($row['timeslide']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $this->loadDefaultValues();
        $row = [];
        $row['MENU_ID'] = $this->MENU_ID->CurrentValue;
        $row['javascript_id'] = $this->javascript_id->CurrentValue;
        $row['file_name'] = $this->file_name->CurrentValue;
        $row['menu_name'] = $this->menu_name->CurrentValue;
        $row['isactive'] = $this->isactive->CurrentValue;
        $row['menu_type'] = $this->menu_type->CurrentValue;
        $row['header_name'] = $this->header_name->CurrentValue;
        $row['isslide'] = $this->isslide->CurrentValue;
        $row['timeslide'] = $this->timeslide->CurrentValue;
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

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // MENU_ID

        // javascript_id

        // file_name

        // menu_name

        // isactive

        // menu_type

        // header_name

        // isslide

        // timeslide
        if ($this->RowType == ROWTYPE_VIEW) {
            // MENU_ID
            $this->MENU_ID->ViewValue = $this->MENU_ID->CurrentValue;
            $this->MENU_ID->ViewValue = FormatNumber($this->MENU_ID->ViewValue, 0, -2, -2, -2);
            $this->MENU_ID->ViewCustomAttributes = "";

            // javascript_id
            $this->javascript_id->ViewValue = $this->javascript_id->CurrentValue;
            $this->javascript_id->ViewCustomAttributes = "";

            // file_name
            $this->file_name->ViewValue = $this->file_name->CurrentValue;
            $this->file_name->ViewCustomAttributes = "";

            // menu_name
            $this->menu_name->ViewValue = $this->menu_name->CurrentValue;
            $this->menu_name->ViewCustomAttributes = "";

            // isactive
            $this->isactive->ViewValue = $this->isactive->CurrentValue;
            $this->isactive->ViewCustomAttributes = "";

            // menu_type
            $this->menu_type->ViewValue = $this->menu_type->CurrentValue;
            $this->menu_type->ViewValue = FormatNumber($this->menu_type->ViewValue, 0, -2, -2, -2);
            $this->menu_type->ViewCustomAttributes = "";

            // header_name
            $this->header_name->ViewValue = $this->header_name->CurrentValue;
            $this->header_name->ViewCustomAttributes = "";

            // isslide
            $this->isslide->ViewValue = $this->isslide->CurrentValue;
            $this->isslide->ViewCustomAttributes = "";

            // timeslide
            $this->timeslide->ViewValue = $this->timeslide->CurrentValue;
            $this->timeslide->ViewValue = FormatNumber($this->timeslide->ViewValue, 0, -2, -2, -2);
            $this->timeslide->ViewCustomAttributes = "";

            // MENU_ID
            $this->MENU_ID->LinkCustomAttributes = "";
            $this->MENU_ID->HrefValue = "";
            $this->MENU_ID->TooltipValue = "";

            // javascript_id
            $this->javascript_id->LinkCustomAttributes = "";
            $this->javascript_id->HrefValue = "";
            $this->javascript_id->TooltipValue = "";

            // file_name
            $this->file_name->LinkCustomAttributes = "";
            $this->file_name->HrefValue = "";
            $this->file_name->TooltipValue = "";

            // menu_name
            $this->menu_name->LinkCustomAttributes = "";
            $this->menu_name->HrefValue = "";
            $this->menu_name->TooltipValue = "";

            // isactive
            $this->isactive->LinkCustomAttributes = "";
            $this->isactive->HrefValue = "";
            $this->isactive->TooltipValue = "";

            // menu_type
            $this->menu_type->LinkCustomAttributes = "";
            $this->menu_type->HrefValue = "";
            $this->menu_type->TooltipValue = "";

            // header_name
            $this->header_name->LinkCustomAttributes = "";
            $this->header_name->HrefValue = "";
            $this->header_name->TooltipValue = "";

            // isslide
            $this->isslide->LinkCustomAttributes = "";
            $this->isslide->HrefValue = "";
            $this->isslide->TooltipValue = "";

            // timeslide
            $this->timeslide->LinkCustomAttributes = "";
            $this->timeslide->HrefValue = "";
            $this->timeslide->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // MENU_ID
            $this->MENU_ID->EditAttrs["class"] = "form-control";
            $this->MENU_ID->EditCustomAttributes = "";
            $this->MENU_ID->EditValue = HtmlEncode($this->MENU_ID->CurrentValue);
            $this->MENU_ID->PlaceHolder = RemoveHtml($this->MENU_ID->caption());

            // javascript_id
            $this->javascript_id->EditAttrs["class"] = "form-control";
            $this->javascript_id->EditCustomAttributes = "";
            if (!$this->javascript_id->Raw) {
                $this->javascript_id->CurrentValue = HtmlDecode($this->javascript_id->CurrentValue);
            }
            $this->javascript_id->EditValue = HtmlEncode($this->javascript_id->CurrentValue);
            $this->javascript_id->PlaceHolder = RemoveHtml($this->javascript_id->caption());

            // file_name
            $this->file_name->EditAttrs["class"] = "form-control";
            $this->file_name->EditCustomAttributes = "";
            if (!$this->file_name->Raw) {
                $this->file_name->CurrentValue = HtmlDecode($this->file_name->CurrentValue);
            }
            $this->file_name->EditValue = HtmlEncode($this->file_name->CurrentValue);
            $this->file_name->PlaceHolder = RemoveHtml($this->file_name->caption());

            // menu_name
            $this->menu_name->EditAttrs["class"] = "form-control";
            $this->menu_name->EditCustomAttributes = "";
            if (!$this->menu_name->Raw) {
                $this->menu_name->CurrentValue = HtmlDecode($this->menu_name->CurrentValue);
            }
            $this->menu_name->EditValue = HtmlEncode($this->menu_name->CurrentValue);
            $this->menu_name->PlaceHolder = RemoveHtml($this->menu_name->caption());

            // isactive
            $this->isactive->EditAttrs["class"] = "form-control";
            $this->isactive->EditCustomAttributes = "";
            if (!$this->isactive->Raw) {
                $this->isactive->CurrentValue = HtmlDecode($this->isactive->CurrentValue);
            }
            $this->isactive->EditValue = HtmlEncode($this->isactive->CurrentValue);
            $this->isactive->PlaceHolder = RemoveHtml($this->isactive->caption());

            // menu_type
            $this->menu_type->EditAttrs["class"] = "form-control";
            $this->menu_type->EditCustomAttributes = "";
            $this->menu_type->EditValue = HtmlEncode($this->menu_type->CurrentValue);
            $this->menu_type->PlaceHolder = RemoveHtml($this->menu_type->caption());

            // header_name
            $this->header_name->EditAttrs["class"] = "form-control";
            $this->header_name->EditCustomAttributes = "";
            if (!$this->header_name->Raw) {
                $this->header_name->CurrentValue = HtmlDecode($this->header_name->CurrentValue);
            }
            $this->header_name->EditValue = HtmlEncode($this->header_name->CurrentValue);
            $this->header_name->PlaceHolder = RemoveHtml($this->header_name->caption());

            // isslide
            $this->isslide->EditAttrs["class"] = "form-control";
            $this->isslide->EditCustomAttributes = "";
            if (!$this->isslide->Raw) {
                $this->isslide->CurrentValue = HtmlDecode($this->isslide->CurrentValue);
            }
            $this->isslide->EditValue = HtmlEncode($this->isslide->CurrentValue);
            $this->isslide->PlaceHolder = RemoveHtml($this->isslide->caption());

            // timeslide
            $this->timeslide->EditAttrs["class"] = "form-control";
            $this->timeslide->EditCustomAttributes = "";
            $this->timeslide->EditValue = HtmlEncode($this->timeslide->CurrentValue);
            $this->timeslide->PlaceHolder = RemoveHtml($this->timeslide->caption());

            // Add refer script

            // MENU_ID
            $this->MENU_ID->LinkCustomAttributes = "";
            $this->MENU_ID->HrefValue = "";

            // javascript_id
            $this->javascript_id->LinkCustomAttributes = "";
            $this->javascript_id->HrefValue = "";

            // file_name
            $this->file_name->LinkCustomAttributes = "";
            $this->file_name->HrefValue = "";

            // menu_name
            $this->menu_name->LinkCustomAttributes = "";
            $this->menu_name->HrefValue = "";

            // isactive
            $this->isactive->LinkCustomAttributes = "";
            $this->isactive->HrefValue = "";

            // menu_type
            $this->menu_type->LinkCustomAttributes = "";
            $this->menu_type->HrefValue = "";

            // header_name
            $this->header_name->LinkCustomAttributes = "";
            $this->header_name->HrefValue = "";

            // isslide
            $this->isslide->LinkCustomAttributes = "";
            $this->isslide->HrefValue = "";

            // timeslide
            $this->timeslide->LinkCustomAttributes = "";
            $this->timeslide->HrefValue = "";
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
        if ($this->MENU_ID->Required) {
            if (!$this->MENU_ID->IsDetailKey && EmptyValue($this->MENU_ID->FormValue)) {
                $this->MENU_ID->addErrorMessage(str_replace("%s", $this->MENU_ID->caption(), $this->MENU_ID->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->MENU_ID->FormValue)) {
            $this->MENU_ID->addErrorMessage($this->MENU_ID->getErrorMessage(false));
        }
        if ($this->javascript_id->Required) {
            if (!$this->javascript_id->IsDetailKey && EmptyValue($this->javascript_id->FormValue)) {
                $this->javascript_id->addErrorMessage(str_replace("%s", $this->javascript_id->caption(), $this->javascript_id->RequiredErrorMessage));
            }
        }
        if ($this->file_name->Required) {
            if (!$this->file_name->IsDetailKey && EmptyValue($this->file_name->FormValue)) {
                $this->file_name->addErrorMessage(str_replace("%s", $this->file_name->caption(), $this->file_name->RequiredErrorMessage));
            }
        }
        if ($this->menu_name->Required) {
            if (!$this->menu_name->IsDetailKey && EmptyValue($this->menu_name->FormValue)) {
                $this->menu_name->addErrorMessage(str_replace("%s", $this->menu_name->caption(), $this->menu_name->RequiredErrorMessage));
            }
        }
        if ($this->isactive->Required) {
            if (!$this->isactive->IsDetailKey && EmptyValue($this->isactive->FormValue)) {
                $this->isactive->addErrorMessage(str_replace("%s", $this->isactive->caption(), $this->isactive->RequiredErrorMessage));
            }
        }
        if ($this->menu_type->Required) {
            if (!$this->menu_type->IsDetailKey && EmptyValue($this->menu_type->FormValue)) {
                $this->menu_type->addErrorMessage(str_replace("%s", $this->menu_type->caption(), $this->menu_type->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->menu_type->FormValue)) {
            $this->menu_type->addErrorMessage($this->menu_type->getErrorMessage(false));
        }
        if ($this->header_name->Required) {
            if (!$this->header_name->IsDetailKey && EmptyValue($this->header_name->FormValue)) {
                $this->header_name->addErrorMessage(str_replace("%s", $this->header_name->caption(), $this->header_name->RequiredErrorMessage));
            }
        }
        if ($this->isslide->Required) {
            if (!$this->isslide->IsDetailKey && EmptyValue($this->isslide->FormValue)) {
                $this->isslide->addErrorMessage(str_replace("%s", $this->isslide->caption(), $this->isslide->RequiredErrorMessage));
            }
        }
        if ($this->timeslide->Required) {
            if (!$this->timeslide->IsDetailKey && EmptyValue($this->timeslide->FormValue)) {
                $this->timeslide->addErrorMessage(str_replace("%s", $this->timeslide->caption(), $this->timeslide->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->timeslide->FormValue)) {
            $this->timeslide->addErrorMessage($this->timeslide->getErrorMessage(false));
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
        if ($this->MENU_ID->CurrentValue != "") { // Check field with unique index
            $filter = "([MENU_ID] = " . AdjustSql($this->MENU_ID->CurrentValue, $this->Dbid) . ")";
            $rsChk = $this->loadRs($filter)->fetch();
            if ($rsChk !== false) {
                $idxErrMsg = str_replace("%f", $this->MENU_ID->caption(), $Language->phrase("DupIndex"));
                $idxErrMsg = str_replace("%v", $this->MENU_ID->CurrentValue, $idxErrMsg);
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

        // MENU_ID
        $this->MENU_ID->setDbValueDef($rsnew, $this->MENU_ID->CurrentValue, 0, false);

        // javascript_id
        $this->javascript_id->setDbValueDef($rsnew, $this->javascript_id->CurrentValue, null, false);

        // file_name
        $this->file_name->setDbValueDef($rsnew, $this->file_name->CurrentValue, null, false);

        // menu_name
        $this->menu_name->setDbValueDef($rsnew, $this->menu_name->CurrentValue, null, false);

        // isactive
        $this->isactive->setDbValueDef($rsnew, $this->isactive->CurrentValue, null, false);

        // menu_type
        $this->menu_type->setDbValueDef($rsnew, $this->menu_type->CurrentValue, null, false);

        // header_name
        $this->header_name->setDbValueDef($rsnew, $this->header_name->CurrentValue, null, false);

        // isslide
        $this->isslide->setDbValueDef($rsnew, $this->isslide->CurrentValue, null, false);

        // timeslide
        $this->timeslide->setDbValueDef($rsnew, $this->timeslide->CurrentValue, null, false);

        // Call Row Inserting event
        $insertRow = $this->rowInserting($rsold, $rsnew);

        // Check if key value entered
        if ($insertRow && $this->ValidateKey && strval($rsnew['MENU_ID']) == "") {
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("WebsiteMenuList"), "", $this->TableVar, true);
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
