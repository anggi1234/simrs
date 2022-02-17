<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class UserMenuEdit extends UserMenu
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'USER_MENU';

    // Page object name
    public $PageObjName = "UserMenuEdit";

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

        // Table object (USER_MENU)
        if (!isset($GLOBALS["USER_MENU"]) || get_class($GLOBALS["USER_MENU"]) == PROJECT_NAMESPACE . "USER_MENU") {
            $GLOBALS["USER_MENU"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'USER_MENU');
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
                $doc = new $class(Container("USER_MENU"));
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
                    if ($pageName == "UserMenuView") {
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
            $key .= @$ar['GROUP_ID'] . Config("COMPOSITE_KEY_SEPARATOR");
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
        $this->GROUP_ID->setVisibility();
        $this->MENU_ID->setVisibility();
        $this->STYPE_ID->setVisibility();
        $this->C->setVisibility();
        $this->R->setVisibility();
        $this->U->setVisibility();
        $this->D->setVisibility();
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
        $this->FormClassName = "ew-form ew-edit-form ew-horizontal";
        $loaded = false;
        $postBack = false;

        // Set up current action and primary key
        if (IsApi()) {
            // Load key values
            $loaded = true;
            if (($keyValue = Get("ORG_UNIT_CODE") ?? Key(0) ?? Route(2)) !== null) {
                $this->ORG_UNIT_CODE->setQueryStringValue($keyValue);
                $this->ORG_UNIT_CODE->setOldValue($this->ORG_UNIT_CODE->QueryStringValue);
            } elseif (Post("ORG_UNIT_CODE") !== null) {
                $this->ORG_UNIT_CODE->setFormValue(Post("ORG_UNIT_CODE"));
                $this->ORG_UNIT_CODE->setOldValue($this->ORG_UNIT_CODE->FormValue);
            } else {
                $loaded = false; // Unable to load key
            }
            if (($keyValue = Get("GROUP_ID") ?? Key(1) ?? Route(3)) !== null) {
                $this->GROUP_ID->setQueryStringValue($keyValue);
                $this->GROUP_ID->setOldValue($this->GROUP_ID->QueryStringValue);
            } elseif (Post("GROUP_ID") !== null) {
                $this->GROUP_ID->setFormValue(Post("GROUP_ID"));
                $this->GROUP_ID->setOldValue($this->GROUP_ID->FormValue);
            } else {
                $loaded = false; // Unable to load key
            }
            if (($keyValue = Get("MENU_ID") ?? Key(2) ?? Route(4)) !== null) {
                $this->MENU_ID->setQueryStringValue($keyValue);
                $this->MENU_ID->setOldValue($this->MENU_ID->QueryStringValue);
            } elseif (Post("MENU_ID") !== null) {
                $this->MENU_ID->setFormValue(Post("MENU_ID"));
                $this->MENU_ID->setOldValue($this->MENU_ID->FormValue);
            } else {
                $loaded = false; // Unable to load key
            }
            if (($keyValue = Get("STYPE_ID") ?? Key(3) ?? Route(5)) !== null) {
                $this->STYPE_ID->setQueryStringValue($keyValue);
                $this->STYPE_ID->setOldValue($this->STYPE_ID->QueryStringValue);
            } elseif (Post("STYPE_ID") !== null) {
                $this->STYPE_ID->setFormValue(Post("STYPE_ID"));
                $this->STYPE_ID->setOldValue($this->STYPE_ID->FormValue);
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
                if (($keyValue = Get("ORG_UNIT_CODE") ?? Route("ORG_UNIT_CODE")) !== null) {
                    $this->ORG_UNIT_CODE->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->ORG_UNIT_CODE->CurrentValue = null;
                }
                if (($keyValue = Get("GROUP_ID") ?? Route("GROUP_ID")) !== null) {
                    $this->GROUP_ID->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->GROUP_ID->CurrentValue = null;
                }
                if (($keyValue = Get("MENU_ID") ?? Route("MENU_ID")) !== null) {
                    $this->MENU_ID->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->MENU_ID->CurrentValue = null;
                }
                if (($keyValue = Get("STYPE_ID") ?? Route("STYPE_ID")) !== null) {
                    $this->STYPE_ID->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->STYPE_ID->CurrentValue = null;
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
                    $this->terminate("UserMenuList"); // No matching record, return to list
                    return;
                }
                break;
            case "update": // Update
                $returnUrl = $this->getReturnUrl();
                if (GetPageName($returnUrl) == "UserMenuList") {
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
        if ($CurrentForm->hasValue("o_ORG_UNIT_CODE")) {
            $this->ORG_UNIT_CODE->setOldValue($CurrentForm->getValue("o_ORG_UNIT_CODE"));
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
        if ($CurrentForm->hasValue("o_GROUP_ID")) {
            $this->GROUP_ID->setOldValue($CurrentForm->getValue("o_GROUP_ID"));
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
        if ($CurrentForm->hasValue("o_MENU_ID")) {
            $this->MENU_ID->setOldValue($CurrentForm->getValue("o_MENU_ID"));
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
        if ($CurrentForm->hasValue("o_STYPE_ID")) {
            $this->STYPE_ID->setOldValue($CurrentForm->getValue("o_STYPE_ID"));
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
        $this->GROUP_ID->CurrentValue = $this->GROUP_ID->FormValue;
        $this->MENU_ID->CurrentValue = $this->MENU_ID->FormValue;
        $this->STYPE_ID->CurrentValue = $this->STYPE_ID->FormValue;
        $this->C->CurrentValue = $this->C->FormValue;
        $this->R->CurrentValue = $this->R->FormValue;
        $this->U->CurrentValue = $this->U->FormValue;
        $this->D->CurrentValue = $this->D->FormValue;
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
        $this->GROUP_ID->setDbValue($row['GROUP_ID']);
        $this->MENU_ID->setDbValue($row['MENU_ID']);
        $this->STYPE_ID->setDbValue($row['STYPE_ID']);
        $this->C->setDbValue($row['C']);
        $this->R->setDbValue($row['R']);
        $this->U->setDbValue($row['U']);
        $this->D->setDbValue($row['D']);
        $this->MODIFIED_DATE->setDbValue($row['MODIFIED_DATE']);
        $this->MODIFIED_BY->setDbValue($row['MODIFIED_BY']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['ORG_UNIT_CODE'] = null;
        $row['GROUP_ID'] = null;
        $row['MENU_ID'] = null;
        $row['STYPE_ID'] = null;
        $row['C'] = null;
        $row['R'] = null;
        $row['U'] = null;
        $row['D'] = null;
        $row['MODIFIED_DATE'] = null;
        $row['MODIFIED_BY'] = null;
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

        // GROUP_ID

        // MENU_ID

        // STYPE_ID

        // C

        // R

        // U

        // D

        // MODIFIED_DATE

        // MODIFIED_BY
        if ($this->RowType == ROWTYPE_VIEW) {
            // ORG_UNIT_CODE
            $this->ORG_UNIT_CODE->ViewValue = $this->ORG_UNIT_CODE->CurrentValue;
            $this->ORG_UNIT_CODE->ViewCustomAttributes = "";

            // GROUP_ID
            $this->GROUP_ID->ViewValue = $this->GROUP_ID->CurrentValue;
            $this->GROUP_ID->ViewValue = FormatNumber($this->GROUP_ID->ViewValue, 0, -2, -2, -2);
            $this->GROUP_ID->ViewCustomAttributes = "";

            // MENU_ID
            $this->MENU_ID->ViewValue = $this->MENU_ID->CurrentValue;
            $this->MENU_ID->ViewCustomAttributes = "";

            // STYPE_ID
            $this->STYPE_ID->ViewValue = $this->STYPE_ID->CurrentValue;
            $this->STYPE_ID->ViewValue = FormatNumber($this->STYPE_ID->ViewValue, 0, -2, -2, -2);
            $this->STYPE_ID->ViewCustomAttributes = "";

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

            // GROUP_ID
            $this->GROUP_ID->LinkCustomAttributes = "";
            $this->GROUP_ID->HrefValue = "";
            $this->GROUP_ID->TooltipValue = "";

            // MENU_ID
            $this->MENU_ID->LinkCustomAttributes = "";
            $this->MENU_ID->HrefValue = "";
            $this->MENU_ID->TooltipValue = "";

            // STYPE_ID
            $this->STYPE_ID->LinkCustomAttributes = "";
            $this->STYPE_ID->HrefValue = "";
            $this->STYPE_ID->TooltipValue = "";

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

            // MODIFIED_DATE
            $this->MODIFIED_DATE->LinkCustomAttributes = "";
            $this->MODIFIED_DATE->HrefValue = "";
            $this->MODIFIED_DATE->TooltipValue = "";

            // MODIFIED_BY
            $this->MODIFIED_BY->LinkCustomAttributes = "";
            $this->MODIFIED_BY->HrefValue = "";
            $this->MODIFIED_BY->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_EDIT) {
            // ORG_UNIT_CODE
            $this->ORG_UNIT_CODE->EditAttrs["class"] = "form-control";
            $this->ORG_UNIT_CODE->EditCustomAttributes = "";
            if (!$this->ORG_UNIT_CODE->Raw) {
                $this->ORG_UNIT_CODE->CurrentValue = HtmlDecode($this->ORG_UNIT_CODE->CurrentValue);
            }
            $this->ORG_UNIT_CODE->EditValue = HtmlEncode($this->ORG_UNIT_CODE->CurrentValue);
            $this->ORG_UNIT_CODE->PlaceHolder = RemoveHtml($this->ORG_UNIT_CODE->caption());

            // GROUP_ID
            $this->GROUP_ID->EditAttrs["class"] = "form-control";
            $this->GROUP_ID->EditCustomAttributes = "";
            $this->GROUP_ID->EditValue = HtmlEncode($this->GROUP_ID->CurrentValue);
            $this->GROUP_ID->PlaceHolder = RemoveHtml($this->GROUP_ID->caption());

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

            // Edit refer script

            // ORG_UNIT_CODE
            $this->ORG_UNIT_CODE->LinkCustomAttributes = "";
            $this->ORG_UNIT_CODE->HrefValue = "";

            // GROUP_ID
            $this->GROUP_ID->LinkCustomAttributes = "";
            $this->GROUP_ID->HrefValue = "";

            // MENU_ID
            $this->MENU_ID->LinkCustomAttributes = "";
            $this->MENU_ID->HrefValue = "";

            // STYPE_ID
            $this->STYPE_ID->LinkCustomAttributes = "";
            $this->STYPE_ID->HrefValue = "";

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
        if ($this->GROUP_ID->Required) {
            if (!$this->GROUP_ID->IsDetailKey && EmptyValue($this->GROUP_ID->FormValue)) {
                $this->GROUP_ID->addErrorMessage(str_replace("%s", $this->GROUP_ID->caption(), $this->GROUP_ID->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->GROUP_ID->FormValue)) {
            $this->GROUP_ID->addErrorMessage($this->GROUP_ID->getErrorMessage(false));
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

            // GROUP_ID
            $this->GROUP_ID->setDbValueDef($rsnew, $this->GROUP_ID->CurrentValue, 0, $this->GROUP_ID->ReadOnly);

            // MENU_ID
            $this->MENU_ID->setDbValueDef($rsnew, $this->MENU_ID->CurrentValue, "", $this->MENU_ID->ReadOnly);

            // STYPE_ID
            $this->STYPE_ID->setDbValueDef($rsnew, $this->STYPE_ID->CurrentValue, 0, $this->STYPE_ID->ReadOnly);

            // C
            $this->C->setDbValueDef($rsnew, $this->C->CurrentValue, null, $this->C->ReadOnly);

            // R
            $this->R->setDbValueDef($rsnew, $this->R->CurrentValue, null, $this->R->ReadOnly);

            // U
            $this->U->setDbValueDef($rsnew, $this->U->CurrentValue, null, $this->U->ReadOnly);

            // D
            $this->D->setDbValueDef($rsnew, $this->D->CurrentValue, null, $this->D->ReadOnly);

            // MODIFIED_DATE
            $this->MODIFIED_DATE->setDbValueDef($rsnew, UnFormatDateTime($this->MODIFIED_DATE->CurrentValue, 0), null, $this->MODIFIED_DATE->ReadOnly);

            // MODIFIED_BY
            $this->MODIFIED_BY->setDbValueDef($rsnew, $this->MODIFIED_BY->CurrentValue, null, $this->MODIFIED_BY->ReadOnly);

            // Call Row Updating event
            $updateRow = $this->rowUpdating($rsold, $rsnew);

            // Check for duplicate key when key changed
            if ($updateRow) {
                $newKeyFilter = $this->getRecordFilter($rsnew);
                if ($newKeyFilter != $oldKeyFilter) {
                    $rsChk = $this->loadRs($newKeyFilter)->fetch();
                    if ($rsChk !== false) {
                        $keyErrMsg = str_replace("%f", $newKeyFilter, $Language->phrase("DupKey"));
                        $this->setFailureMessage($keyErrMsg);
                        $updateRow = false;
                    }
                }
            }
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("UserMenuList"), "", $this->TableVar, true);
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
