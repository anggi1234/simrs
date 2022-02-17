<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class UsersMenuAdd extends UsersMenu
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'USERS_MENU';

    // Page object name
    public $PageObjName = "UsersMenuAdd";

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

        // Table object (USERS_MENU)
        if (!isset($GLOBALS["USERS_MENU"]) || get_class($GLOBALS["USERS_MENU"]) == PROJECT_NAMESPACE . "USERS_MENU") {
            $GLOBALS["USERS_MENU"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'USERS_MENU');
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
                $doc = new $class(Container("USERS_MENU"));
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
                    if ($pageName == "UsersMenuView") {
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
            $key .= @$ar['USERNAME'] . Config("COMPOSITE_KEY_SEPARATOR");
            $key .= @$ar['MENU_ID'] . Config("COMPOSITE_KEY_SEPARATOR");
            $key .= @$ar['STYPE_ID'];
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
        $this->_USERNAME->setVisibility();
        $this->MENU_ID->setVisibility();
        $this->STYPE_ID->setVisibility();
        $this->GROUP_ID->setVisibility();
        $this->C->setVisibility();
        $this->R->setVisibility();
        $this->U->setVisibility();
        $this->D->setVisibility();
        $this->P->setVisibility();
        $this->E->setVisibility();
        $this->C_TIME->setVisibility();
        $this->U_TIME->setVisibility();
        $this->D_TIME->setVisibility();
        $this->MODIFIED_DATE->setVisibility();
        $this->MODIFIED_BY->setVisibility();
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
            if (($keyValue = Get("_USERNAME") ?? Route("_USERNAME")) !== null) {
                $this->_USERNAME->setQueryStringValue($keyValue);
            }
            if (($keyValue = Get("MENU_ID") ?? Route("MENU_ID")) !== null) {
                $this->MENU_ID->setQueryStringValue($keyValue);
            }
            if (($keyValue = Get("STYPE_ID") ?? Route("STYPE_ID")) !== null) {
                $this->STYPE_ID->setQueryStringValue($keyValue);
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
                    $this->terminate("UsersMenuList"); // No matching record, return to list
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
                    if (GetPageName($returnUrl) == "UsersMenuList") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "UsersMenuView") {
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
        $this->ORG_UNIT_CODE->CurrentValue = null;
        $this->ORG_UNIT_CODE->OldValue = $this->ORG_UNIT_CODE->CurrentValue;
        $this->_USERNAME->CurrentValue = null;
        $this->_USERNAME->OldValue = $this->_USERNAME->CurrentValue;
        $this->MENU_ID->CurrentValue = null;
        $this->MENU_ID->OldValue = $this->MENU_ID->CurrentValue;
        $this->STYPE_ID->CurrentValue = null;
        $this->STYPE_ID->OldValue = $this->STYPE_ID->CurrentValue;
        $this->GROUP_ID->CurrentValue = null;
        $this->GROUP_ID->OldValue = $this->GROUP_ID->CurrentValue;
        $this->C->CurrentValue = "0";
        $this->R->CurrentValue = "1";
        $this->U->CurrentValue = "0";
        $this->D->CurrentValue = "0";
        $this->P->CurrentValue = "1";
        $this->E->CurrentValue = "1";
        $this->C_TIME->CurrentValue = 7;
        $this->U_TIME->CurrentValue = 7;
        $this->D_TIME->CurrentValue = 7;
        $this->MODIFIED_DATE->CurrentValue = null;
        $this->MODIFIED_DATE->OldValue = $this->MODIFIED_DATE->CurrentValue;
        $this->MODIFIED_BY->CurrentValue = null;
        $this->MODIFIED_BY->OldValue = $this->MODIFIED_BY->CurrentValue;
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

        // Check field name 'USERNAME' first before field var 'x__USERNAME'
        $val = $CurrentForm->hasValue("USERNAME") ? $CurrentForm->getValue("USERNAME") : $CurrentForm->getValue("x__USERNAME");
        if (!$this->_USERNAME->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->_USERNAME->Visible = false; // Disable update for API request
            } else {
                $this->_USERNAME->setFormValue($val);
            }
        }

        // Check field name 'MENU_ID' first before field var 'x_MENU_ID'
        $val = $CurrentForm->hasValue("MENU_ID") ? $CurrentForm->getValue("MENU_ID") : $CurrentForm->getValue("x_MENU_ID");
        if (!$this->MENU_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->MENU_ID->Visible = false; // Disable update for API request
            } else {
                $this->MENU_ID->setFormValue($val);
            }
        }

        // Check field name 'STYPE_ID' first before field var 'x_STYPE_ID'
        $val = $CurrentForm->hasValue("STYPE_ID") ? $CurrentForm->getValue("STYPE_ID") : $CurrentForm->getValue("x_STYPE_ID");
        if (!$this->STYPE_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->STYPE_ID->Visible = false; // Disable update for API request
            } else {
                $this->STYPE_ID->setFormValue($val);
            }
        }

        // Check field name 'GROUP_ID' first before field var 'x_GROUP_ID'
        $val = $CurrentForm->hasValue("GROUP_ID") ? $CurrentForm->getValue("GROUP_ID") : $CurrentForm->getValue("x_GROUP_ID");
        if (!$this->GROUP_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->GROUP_ID->Visible = false; // Disable update for API request
            } else {
                $this->GROUP_ID->setFormValue($val);
            }
        }

        // Check field name 'C' first before field var 'x_C'
        $val = $CurrentForm->hasValue("C") ? $CurrentForm->getValue("C") : $CurrentForm->getValue("x_C");
        if (!$this->C->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->C->Visible = false; // Disable update for API request
            } else {
                $this->C->setFormValue($val);
            }
        }

        // Check field name 'R' first before field var 'x_R'
        $val = $CurrentForm->hasValue("R") ? $CurrentForm->getValue("R") : $CurrentForm->getValue("x_R");
        if (!$this->R->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->R->Visible = false; // Disable update for API request
            } else {
                $this->R->setFormValue($val);
            }
        }

        // Check field name 'U' first before field var 'x_U'
        $val = $CurrentForm->hasValue("U") ? $CurrentForm->getValue("U") : $CurrentForm->getValue("x_U");
        if (!$this->U->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->U->Visible = false; // Disable update for API request
            } else {
                $this->U->setFormValue($val);
            }
        }

        // Check field name 'D' first before field var 'x_D'
        $val = $CurrentForm->hasValue("D") ? $CurrentForm->getValue("D") : $CurrentForm->getValue("x_D");
        if (!$this->D->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->D->Visible = false; // Disable update for API request
            } else {
                $this->D->setFormValue($val);
            }
        }

        // Check field name 'P' first before field var 'x_P'
        $val = $CurrentForm->hasValue("P") ? $CurrentForm->getValue("P") : $CurrentForm->getValue("x_P");
        if (!$this->P->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->P->Visible = false; // Disable update for API request
            } else {
                $this->P->setFormValue($val);
            }
        }

        // Check field name 'E' first before field var 'x_E'
        $val = $CurrentForm->hasValue("E") ? $CurrentForm->getValue("E") : $CurrentForm->getValue("x_E");
        if (!$this->E->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->E->Visible = false; // Disable update for API request
            } else {
                $this->E->setFormValue($val);
            }
        }

        // Check field name 'C_TIME' first before field var 'x_C_TIME'
        $val = $CurrentForm->hasValue("C_TIME") ? $CurrentForm->getValue("C_TIME") : $CurrentForm->getValue("x_C_TIME");
        if (!$this->C_TIME->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->C_TIME->Visible = false; // Disable update for API request
            } else {
                $this->C_TIME->setFormValue($val);
            }
        }

        // Check field name 'U_TIME' first before field var 'x_U_TIME'
        $val = $CurrentForm->hasValue("U_TIME") ? $CurrentForm->getValue("U_TIME") : $CurrentForm->getValue("x_U_TIME");
        if (!$this->U_TIME->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->U_TIME->Visible = false; // Disable update for API request
            } else {
                $this->U_TIME->setFormValue($val);
            }
        }

        // Check field name 'D_TIME' first before field var 'x_D_TIME'
        $val = $CurrentForm->hasValue("D_TIME") ? $CurrentForm->getValue("D_TIME") : $CurrentForm->getValue("x_D_TIME");
        if (!$this->D_TIME->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->D_TIME->Visible = false; // Disable update for API request
            } else {
                $this->D_TIME->setFormValue($val);
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
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->ORG_UNIT_CODE->CurrentValue = $this->ORG_UNIT_CODE->FormValue;
        $this->_USERNAME->CurrentValue = $this->_USERNAME->FormValue;
        $this->MENU_ID->CurrentValue = $this->MENU_ID->FormValue;
        $this->STYPE_ID->CurrentValue = $this->STYPE_ID->FormValue;
        $this->GROUP_ID->CurrentValue = $this->GROUP_ID->FormValue;
        $this->C->CurrentValue = $this->C->FormValue;
        $this->R->CurrentValue = $this->R->FormValue;
        $this->U->CurrentValue = $this->U->FormValue;
        $this->D->CurrentValue = $this->D->FormValue;
        $this->P->CurrentValue = $this->P->FormValue;
        $this->E->CurrentValue = $this->E->FormValue;
        $this->C_TIME->CurrentValue = $this->C_TIME->FormValue;
        $this->U_TIME->CurrentValue = $this->U_TIME->FormValue;
        $this->D_TIME->CurrentValue = $this->D_TIME->FormValue;
        $this->MODIFIED_DATE->CurrentValue = $this->MODIFIED_DATE->FormValue;
        $this->MODIFIED_DATE->CurrentValue = UnFormatDateTime($this->MODIFIED_DATE->CurrentValue, 0);
        $this->MODIFIED_BY->CurrentValue = $this->MODIFIED_BY->FormValue;
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
        $this->_USERNAME->setDbValue($row['USERNAME']);
        $this->MENU_ID->setDbValue($row['MENU_ID']);
        $this->STYPE_ID->setDbValue($row['STYPE_ID']);
        $this->GROUP_ID->setDbValue($row['GROUP_ID']);
        $this->C->setDbValue($row['C']);
        $this->R->setDbValue($row['R']);
        $this->U->setDbValue($row['U']);
        $this->D->setDbValue($row['D']);
        $this->P->setDbValue($row['P']);
        $this->E->setDbValue($row['E']);
        $this->C_TIME->setDbValue($row['C_TIME']);
        $this->U_TIME->setDbValue($row['U_TIME']);
        $this->D_TIME->setDbValue($row['D_TIME']);
        $this->MODIFIED_DATE->setDbValue($row['MODIFIED_DATE']);
        $this->MODIFIED_BY->setDbValue($row['MODIFIED_BY']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $this->loadDefaultValues();
        $row = [];
        $row['ORG_UNIT_CODE'] = $this->ORG_UNIT_CODE->CurrentValue;
        $row['USERNAME'] = $this->_USERNAME->CurrentValue;
        $row['MENU_ID'] = $this->MENU_ID->CurrentValue;
        $row['STYPE_ID'] = $this->STYPE_ID->CurrentValue;
        $row['GROUP_ID'] = $this->GROUP_ID->CurrentValue;
        $row['C'] = $this->C->CurrentValue;
        $row['R'] = $this->R->CurrentValue;
        $row['U'] = $this->U->CurrentValue;
        $row['D'] = $this->D->CurrentValue;
        $row['P'] = $this->P->CurrentValue;
        $row['E'] = $this->E->CurrentValue;
        $row['C_TIME'] = $this->C_TIME->CurrentValue;
        $row['U_TIME'] = $this->U_TIME->CurrentValue;
        $row['D_TIME'] = $this->D_TIME->CurrentValue;
        $row['MODIFIED_DATE'] = $this->MODIFIED_DATE->CurrentValue;
        $row['MODIFIED_BY'] = $this->MODIFIED_BY->CurrentValue;
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

        // ORG_UNIT_CODE

        // USERNAME

        // MENU_ID

        // STYPE_ID

        // GROUP_ID

        // C

        // R

        // U

        // D

        // P

        // E

        // C_TIME

        // U_TIME

        // D_TIME

        // MODIFIED_DATE

        // MODIFIED_BY
        if ($this->RowType == ROWTYPE_VIEW) {
            // ORG_UNIT_CODE
            $this->ORG_UNIT_CODE->ViewValue = $this->ORG_UNIT_CODE->CurrentValue;
            $this->ORG_UNIT_CODE->ViewCustomAttributes = "";

            // USERNAME
            $this->_USERNAME->ViewValue = $this->_USERNAME->CurrentValue;
            $this->_USERNAME->ViewCustomAttributes = "";

            // MENU_ID
            $this->MENU_ID->ViewValue = $this->MENU_ID->CurrentValue;
            $this->MENU_ID->ViewCustomAttributes = "";

            // STYPE_ID
            $this->STYPE_ID->ViewValue = $this->STYPE_ID->CurrentValue;
            $this->STYPE_ID->ViewValue = FormatNumber($this->STYPE_ID->ViewValue, 0, -2, -2, -2);
            $this->STYPE_ID->ViewCustomAttributes = "";

            // GROUP_ID
            $this->GROUP_ID->ViewValue = $this->GROUP_ID->CurrentValue;
            $this->GROUP_ID->ViewValue = FormatNumber($this->GROUP_ID->ViewValue, 0, -2, -2, -2);
            $this->GROUP_ID->ViewCustomAttributes = "";

            // C
            $this->C->ViewValue = $this->C->CurrentValue;
            $this->C->ViewCustomAttributes = "";

            // R
            $this->R->ViewValue = $this->R->CurrentValue;
            $this->R->ViewCustomAttributes = "";

            // U
            $this->U->ViewValue = $this->U->CurrentValue;
            $this->U->ViewCustomAttributes = "";

            // D
            $this->D->ViewValue = $this->D->CurrentValue;
            $this->D->ViewCustomAttributes = "";

            // P
            $this->P->ViewValue = $this->P->CurrentValue;
            $this->P->ViewCustomAttributes = "";

            // E
            $this->E->ViewValue = $this->E->CurrentValue;
            $this->E->ViewCustomAttributes = "";

            // C_TIME
            $this->C_TIME->ViewValue = $this->C_TIME->CurrentValue;
            $this->C_TIME->ViewValue = FormatNumber($this->C_TIME->ViewValue, 0, -2, -2, -2);
            $this->C_TIME->ViewCustomAttributes = "";

            // U_TIME
            $this->U_TIME->ViewValue = $this->U_TIME->CurrentValue;
            $this->U_TIME->ViewValue = FormatNumber($this->U_TIME->ViewValue, 0, -2, -2, -2);
            $this->U_TIME->ViewCustomAttributes = "";

            // D_TIME
            $this->D_TIME->ViewValue = $this->D_TIME->CurrentValue;
            $this->D_TIME->ViewValue = FormatNumber($this->D_TIME->ViewValue, 0, -2, -2, -2);
            $this->D_TIME->ViewCustomAttributes = "";

            // MODIFIED_DATE
            $this->MODIFIED_DATE->ViewValue = $this->MODIFIED_DATE->CurrentValue;
            $this->MODIFIED_DATE->ViewValue = FormatDateTime($this->MODIFIED_DATE->ViewValue, 0);
            $this->MODIFIED_DATE->ViewCustomAttributes = "";

            // MODIFIED_BY
            $this->MODIFIED_BY->ViewValue = $this->MODIFIED_BY->CurrentValue;
            $this->MODIFIED_BY->ViewCustomAttributes = "";

            // ORG_UNIT_CODE
            $this->ORG_UNIT_CODE->LinkCustomAttributes = "";
            $this->ORG_UNIT_CODE->HrefValue = "";
            $this->ORG_UNIT_CODE->TooltipValue = "";

            // USERNAME
            $this->_USERNAME->LinkCustomAttributes = "";
            $this->_USERNAME->HrefValue = "";
            $this->_USERNAME->TooltipValue = "";

            // MENU_ID
            $this->MENU_ID->LinkCustomAttributes = "";
            $this->MENU_ID->HrefValue = "";
            $this->MENU_ID->TooltipValue = "";

            // STYPE_ID
            $this->STYPE_ID->LinkCustomAttributes = "";
            $this->STYPE_ID->HrefValue = "";
            $this->STYPE_ID->TooltipValue = "";

            // GROUP_ID
            $this->GROUP_ID->LinkCustomAttributes = "";
            $this->GROUP_ID->HrefValue = "";
            $this->GROUP_ID->TooltipValue = "";

            // C
            $this->C->LinkCustomAttributes = "";
            $this->C->HrefValue = "";
            $this->C->TooltipValue = "";

            // R
            $this->R->LinkCustomAttributes = "";
            $this->R->HrefValue = "";
            $this->R->TooltipValue = "";

            // U
            $this->U->LinkCustomAttributes = "";
            $this->U->HrefValue = "";
            $this->U->TooltipValue = "";

            // D
            $this->D->LinkCustomAttributes = "";
            $this->D->HrefValue = "";
            $this->D->TooltipValue = "";

            // P
            $this->P->LinkCustomAttributes = "";
            $this->P->HrefValue = "";
            $this->P->TooltipValue = "";

            // E
            $this->E->LinkCustomAttributes = "";
            $this->E->HrefValue = "";
            $this->E->TooltipValue = "";

            // C_TIME
            $this->C_TIME->LinkCustomAttributes = "";
            $this->C_TIME->HrefValue = "";
            $this->C_TIME->TooltipValue = "";

            // U_TIME
            $this->U_TIME->LinkCustomAttributes = "";
            $this->U_TIME->HrefValue = "";
            $this->U_TIME->TooltipValue = "";

            // D_TIME
            $this->D_TIME->LinkCustomAttributes = "";
            $this->D_TIME->HrefValue = "";
            $this->D_TIME->TooltipValue = "";

            // MODIFIED_DATE
            $this->MODIFIED_DATE->LinkCustomAttributes = "";
            $this->MODIFIED_DATE->HrefValue = "";
            $this->MODIFIED_DATE->TooltipValue = "";

            // MODIFIED_BY
            $this->MODIFIED_BY->LinkCustomAttributes = "";
            $this->MODIFIED_BY->HrefValue = "";
            $this->MODIFIED_BY->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // ORG_UNIT_CODE
            $this->ORG_UNIT_CODE->EditAttrs["class"] = "form-control";
            $this->ORG_UNIT_CODE->EditCustomAttributes = "";
            if (!$this->ORG_UNIT_CODE->Raw) {
                $this->ORG_UNIT_CODE->CurrentValue = HtmlDecode($this->ORG_UNIT_CODE->CurrentValue);
            }
            $this->ORG_UNIT_CODE->EditValue = HtmlEncode($this->ORG_UNIT_CODE->CurrentValue);
            $this->ORG_UNIT_CODE->PlaceHolder = RemoveHtml($this->ORG_UNIT_CODE->caption());

            // USERNAME
            $this->_USERNAME->EditAttrs["class"] = "form-control";
            $this->_USERNAME->EditCustomAttributes = "";
            if (!$this->_USERNAME->Raw) {
                $this->_USERNAME->CurrentValue = HtmlDecode($this->_USERNAME->CurrentValue);
            }
            $this->_USERNAME->EditValue = HtmlEncode($this->_USERNAME->CurrentValue);
            $this->_USERNAME->PlaceHolder = RemoveHtml($this->_USERNAME->caption());

            // MENU_ID
            $this->MENU_ID->EditAttrs["class"] = "form-control";
            $this->MENU_ID->EditCustomAttributes = "";
            if (!$this->MENU_ID->Raw) {
                $this->MENU_ID->CurrentValue = HtmlDecode($this->MENU_ID->CurrentValue);
            }
            $this->MENU_ID->EditValue = HtmlEncode($this->MENU_ID->CurrentValue);
            $this->MENU_ID->PlaceHolder = RemoveHtml($this->MENU_ID->caption());

            // STYPE_ID
            $this->STYPE_ID->EditAttrs["class"] = "form-control";
            $this->STYPE_ID->EditCustomAttributes = "";
            $this->STYPE_ID->EditValue = HtmlEncode($this->STYPE_ID->CurrentValue);
            $this->STYPE_ID->PlaceHolder = RemoveHtml($this->STYPE_ID->caption());

            // GROUP_ID
            $this->GROUP_ID->EditAttrs["class"] = "form-control";
            $this->GROUP_ID->EditCustomAttributes = "";
            $this->GROUP_ID->EditValue = HtmlEncode($this->GROUP_ID->CurrentValue);
            $this->GROUP_ID->PlaceHolder = RemoveHtml($this->GROUP_ID->caption());

            // C
            $this->C->EditAttrs["class"] = "form-control";
            $this->C->EditCustomAttributes = "";
            if (!$this->C->Raw) {
                $this->C->CurrentValue = HtmlDecode($this->C->CurrentValue);
            }
            $this->C->EditValue = HtmlEncode($this->C->CurrentValue);
            $this->C->PlaceHolder = RemoveHtml($this->C->caption());

            // R
            $this->R->EditAttrs["class"] = "form-control";
            $this->R->EditCustomAttributes = "";
            if (!$this->R->Raw) {
                $this->R->CurrentValue = HtmlDecode($this->R->CurrentValue);
            }
            $this->R->EditValue = HtmlEncode($this->R->CurrentValue);
            $this->R->PlaceHolder = RemoveHtml($this->R->caption());

            // U
            $this->U->EditAttrs["class"] = "form-control";
            $this->U->EditCustomAttributes = "";
            if (!$this->U->Raw) {
                $this->U->CurrentValue = HtmlDecode($this->U->CurrentValue);
            }
            $this->U->EditValue = HtmlEncode($this->U->CurrentValue);
            $this->U->PlaceHolder = RemoveHtml($this->U->caption());

            // D
            $this->D->EditAttrs["class"] = "form-control";
            $this->D->EditCustomAttributes = "";
            if (!$this->D->Raw) {
                $this->D->CurrentValue = HtmlDecode($this->D->CurrentValue);
            }
            $this->D->EditValue = HtmlEncode($this->D->CurrentValue);
            $this->D->PlaceHolder = RemoveHtml($this->D->caption());

            // P
            $this->P->EditAttrs["class"] = "form-control";
            $this->P->EditCustomAttributes = "";
            if (!$this->P->Raw) {
                $this->P->CurrentValue = HtmlDecode($this->P->CurrentValue);
            }
            $this->P->EditValue = HtmlEncode($this->P->CurrentValue);
            $this->P->PlaceHolder = RemoveHtml($this->P->caption());

            // E
            $this->E->EditAttrs["class"] = "form-control";
            $this->E->EditCustomAttributes = "";
            if (!$this->E->Raw) {
                $this->E->CurrentValue = HtmlDecode($this->E->CurrentValue);
            }
            $this->E->EditValue = HtmlEncode($this->E->CurrentValue);
            $this->E->PlaceHolder = RemoveHtml($this->E->caption());

            // C_TIME
            $this->C_TIME->EditAttrs["class"] = "form-control";
            $this->C_TIME->EditCustomAttributes = "";
            $this->C_TIME->EditValue = HtmlEncode($this->C_TIME->CurrentValue);
            $this->C_TIME->PlaceHolder = RemoveHtml($this->C_TIME->caption());

            // U_TIME
            $this->U_TIME->EditAttrs["class"] = "form-control";
            $this->U_TIME->EditCustomAttributes = "";
            $this->U_TIME->EditValue = HtmlEncode($this->U_TIME->CurrentValue);
            $this->U_TIME->PlaceHolder = RemoveHtml($this->U_TIME->caption());

            // D_TIME
            $this->D_TIME->EditAttrs["class"] = "form-control";
            $this->D_TIME->EditCustomAttributes = "";
            $this->D_TIME->EditValue = HtmlEncode($this->D_TIME->CurrentValue);
            $this->D_TIME->PlaceHolder = RemoveHtml($this->D_TIME->caption());

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

            // Add refer script

            // ORG_UNIT_CODE
            $this->ORG_UNIT_CODE->LinkCustomAttributes = "";
            $this->ORG_UNIT_CODE->HrefValue = "";

            // USERNAME
            $this->_USERNAME->LinkCustomAttributes = "";
            $this->_USERNAME->HrefValue = "";

            // MENU_ID
            $this->MENU_ID->LinkCustomAttributes = "";
            $this->MENU_ID->HrefValue = "";

            // STYPE_ID
            $this->STYPE_ID->LinkCustomAttributes = "";
            $this->STYPE_ID->HrefValue = "";

            // GROUP_ID
            $this->GROUP_ID->LinkCustomAttributes = "";
            $this->GROUP_ID->HrefValue = "";

            // C
            $this->C->LinkCustomAttributes = "";
            $this->C->HrefValue = "";

            // R
            $this->R->LinkCustomAttributes = "";
            $this->R->HrefValue = "";

            // U
            $this->U->LinkCustomAttributes = "";
            $this->U->HrefValue = "";

            // D
            $this->D->LinkCustomAttributes = "";
            $this->D->HrefValue = "";

            // P
            $this->P->LinkCustomAttributes = "";
            $this->P->HrefValue = "";

            // E
            $this->E->LinkCustomAttributes = "";
            $this->E->HrefValue = "";

            // C_TIME
            $this->C_TIME->LinkCustomAttributes = "";
            $this->C_TIME->HrefValue = "";

            // U_TIME
            $this->U_TIME->LinkCustomAttributes = "";
            $this->U_TIME->HrefValue = "";

            // D_TIME
            $this->D_TIME->LinkCustomAttributes = "";
            $this->D_TIME->HrefValue = "";

            // MODIFIED_DATE
            $this->MODIFIED_DATE->LinkCustomAttributes = "";
            $this->MODIFIED_DATE->HrefValue = "";

            // MODIFIED_BY
            $this->MODIFIED_BY->LinkCustomAttributes = "";
            $this->MODIFIED_BY->HrefValue = "";
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
        if ($this->_USERNAME->Required) {
            if (!$this->_USERNAME->IsDetailKey && EmptyValue($this->_USERNAME->FormValue)) {
                $this->_USERNAME->addErrorMessage(str_replace("%s", $this->_USERNAME->caption(), $this->_USERNAME->RequiredErrorMessage));
            }
        }
        if ($this->MENU_ID->Required) {
            if (!$this->MENU_ID->IsDetailKey && EmptyValue($this->MENU_ID->FormValue)) {
                $this->MENU_ID->addErrorMessage(str_replace("%s", $this->MENU_ID->caption(), $this->MENU_ID->RequiredErrorMessage));
            }
        }
        if ($this->STYPE_ID->Required) {
            if (!$this->STYPE_ID->IsDetailKey && EmptyValue($this->STYPE_ID->FormValue)) {
                $this->STYPE_ID->addErrorMessage(str_replace("%s", $this->STYPE_ID->caption(), $this->STYPE_ID->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->STYPE_ID->FormValue)) {
            $this->STYPE_ID->addErrorMessage($this->STYPE_ID->getErrorMessage(false));
        }
        if ($this->GROUP_ID->Required) {
            if (!$this->GROUP_ID->IsDetailKey && EmptyValue($this->GROUP_ID->FormValue)) {
                $this->GROUP_ID->addErrorMessage(str_replace("%s", $this->GROUP_ID->caption(), $this->GROUP_ID->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->GROUP_ID->FormValue)) {
            $this->GROUP_ID->addErrorMessage($this->GROUP_ID->getErrorMessage(false));
        }
        if ($this->C->Required) {
            if (!$this->C->IsDetailKey && EmptyValue($this->C->FormValue)) {
                $this->C->addErrorMessage(str_replace("%s", $this->C->caption(), $this->C->RequiredErrorMessage));
            }
        }
        if ($this->R->Required) {
            if (!$this->R->IsDetailKey && EmptyValue($this->R->FormValue)) {
                $this->R->addErrorMessage(str_replace("%s", $this->R->caption(), $this->R->RequiredErrorMessage));
            }
        }
        if ($this->U->Required) {
            if (!$this->U->IsDetailKey && EmptyValue($this->U->FormValue)) {
                $this->U->addErrorMessage(str_replace("%s", $this->U->caption(), $this->U->RequiredErrorMessage));
            }
        }
        if ($this->D->Required) {
            if (!$this->D->IsDetailKey && EmptyValue($this->D->FormValue)) {
                $this->D->addErrorMessage(str_replace("%s", $this->D->caption(), $this->D->RequiredErrorMessage));
            }
        }
        if ($this->P->Required) {
            if (!$this->P->IsDetailKey && EmptyValue($this->P->FormValue)) {
                $this->P->addErrorMessage(str_replace("%s", $this->P->caption(), $this->P->RequiredErrorMessage));
            }
        }
        if ($this->E->Required) {
            if (!$this->E->IsDetailKey && EmptyValue($this->E->FormValue)) {
                $this->E->addErrorMessage(str_replace("%s", $this->E->caption(), $this->E->RequiredErrorMessage));
            }
        }
        if ($this->C_TIME->Required) {
            if (!$this->C_TIME->IsDetailKey && EmptyValue($this->C_TIME->FormValue)) {
                $this->C_TIME->addErrorMessage(str_replace("%s", $this->C_TIME->caption(), $this->C_TIME->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->C_TIME->FormValue)) {
            $this->C_TIME->addErrorMessage($this->C_TIME->getErrorMessage(false));
        }
        if ($this->U_TIME->Required) {
            if (!$this->U_TIME->IsDetailKey && EmptyValue($this->U_TIME->FormValue)) {
                $this->U_TIME->addErrorMessage(str_replace("%s", $this->U_TIME->caption(), $this->U_TIME->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->U_TIME->FormValue)) {
            $this->U_TIME->addErrorMessage($this->U_TIME->getErrorMessage(false));
        }
        if ($this->D_TIME->Required) {
            if (!$this->D_TIME->IsDetailKey && EmptyValue($this->D_TIME->FormValue)) {
                $this->D_TIME->addErrorMessage(str_replace("%s", $this->D_TIME->caption(), $this->D_TIME->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->D_TIME->FormValue)) {
            $this->D_TIME->addErrorMessage($this->D_TIME->getErrorMessage(false));
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

        // USERNAME
        $this->_USERNAME->setDbValueDef($rsnew, $this->_USERNAME->CurrentValue, "", false);

        // MENU_ID
        $this->MENU_ID->setDbValueDef($rsnew, $this->MENU_ID->CurrentValue, "", false);

        // STYPE_ID
        $this->STYPE_ID->setDbValueDef($rsnew, $this->STYPE_ID->CurrentValue, 0, false);

        // GROUP_ID
        $this->GROUP_ID->setDbValueDef($rsnew, $this->GROUP_ID->CurrentValue, 0, false);

        // C
        $this->C->setDbValueDef($rsnew, $this->C->CurrentValue, null, strval($this->C->CurrentValue) == "");

        // R
        $this->R->setDbValueDef($rsnew, $this->R->CurrentValue, null, strval($this->R->CurrentValue) == "");

        // U
        $this->U->setDbValueDef($rsnew, $this->U->CurrentValue, null, strval($this->U->CurrentValue) == "");

        // D
        $this->D->setDbValueDef($rsnew, $this->D->CurrentValue, null, strval($this->D->CurrentValue) == "");

        // P
        $this->P->setDbValueDef($rsnew, $this->P->CurrentValue, null, strval($this->P->CurrentValue) == "");

        // E
        $this->E->setDbValueDef($rsnew, $this->E->CurrentValue, null, strval($this->E->CurrentValue) == "");

        // C_TIME
        $this->C_TIME->setDbValueDef($rsnew, $this->C_TIME->CurrentValue, null, strval($this->C_TIME->CurrentValue) == "");

        // U_TIME
        $this->U_TIME->setDbValueDef($rsnew, $this->U_TIME->CurrentValue, null, strval($this->U_TIME->CurrentValue) == "");

        // D_TIME
        $this->D_TIME->setDbValueDef($rsnew, $this->D_TIME->CurrentValue, null, strval($this->D_TIME->CurrentValue) == "");

        // MODIFIED_DATE
        $this->MODIFIED_DATE->setDbValueDef($rsnew, UnFormatDateTime($this->MODIFIED_DATE->CurrentValue, 0), null, false);

        // MODIFIED_BY
        $this->MODIFIED_BY->setDbValueDef($rsnew, $this->MODIFIED_BY->CurrentValue, null, false);

        // Call Row Inserting event
        $insertRow = $this->rowInserting($rsold, $rsnew);

        // Check if key value entered
        if ($insertRow && $this->ValidateKey && strval($rsnew['ORG_UNIT_CODE']) == "") {
            $this->setFailureMessage($Language->phrase("InvalidKeyValue"));
            $insertRow = false;
        }

        // Check if key value entered
        if ($insertRow && $this->ValidateKey && strval($rsnew['USERNAME']) == "") {
            $this->setFailureMessage($Language->phrase("InvalidKeyValue"));
            $insertRow = false;
        }

        // Check if key value entered
        if ($insertRow && $this->ValidateKey && strval($rsnew['MENU_ID']) == "") {
            $this->setFailureMessage($Language->phrase("InvalidKeyValue"));
            $insertRow = false;
        }

        // Check if key value entered
        if ($insertRow && $this->ValidateKey && strval($rsnew['STYPE_ID']) == "") {
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("UsersMenuList"), "", $this->TableVar, true);
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
