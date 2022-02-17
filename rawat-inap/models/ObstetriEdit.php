<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class ObstetriEdit extends Obstetri
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'OBSTETRI';

    // Page object name
    public $PageObjName = "ObstetriEdit";

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

        // Table object (OBSTETRI)
        if (!isset($GLOBALS["OBSTETRI"]) || get_class($GLOBALS["OBSTETRI"]) == PROJECT_NAMESPACE . "OBSTETRI") {
            $GLOBALS["OBSTETRI"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'OBSTETRI');
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
                $doc = new $class(Container("OBSTETRI"));
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
                    if ($pageName == "ObstetriView") {
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
    public $MultiPages; // Multi pages object

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
        $this->ORG_UNIT_CODE->Visible = false;
        $this->OBSTETRI_ID->Visible = false;
        $this->NO_REGISTRATION->setVisibility();
        $this->THENAME->setVisibility();
        $this->THEADDRESS->setVisibility();
        $this->GENDER->setVisibility();
        $this->CLINIC_ID->setVisibility();
        $this->EMPLOYEE_ID->setVisibility();
        $this->HPHT->Visible = false;
        $this->HTP->Visible = false;
        $this->PASIEN_DIAGNOSA_ID->Visible = false;
        $this->DIAGNOSA_ID->Visible = false;
        $this->KOHORT_NB->Visible = false;
        $this->BIRTH_NB->setVisibility();
        $this->BIRTH_DURATION->setVisibility();
        $this->BIRTH_PLACE->setVisibility();
        $this->ANTE_NATAL->setVisibility();
        $this->BIRTH_WAY->setVisibility();
        $this->BIRTH_BY->setVisibility();
        $this->BIRTH_DATE->setVisibility();
        $this->GESTASI->setVisibility();
        $this->PARITY->setVisibility();
        $this->NB_BABY->setVisibility();
        $this->BABY_DIE->setVisibility();
        $this->ABORTUS_KE->setVisibility();
        $this->ABORTUS_ID->setVisibility();
        $this->ABORTION_DATE->setVisibility();
        $this->BIRTH_CAT->setVisibility();
        $this->BIRTH_CON->setVisibility();
        $this->BIRTH_RISK->setVisibility();
        $this->RISK_TYPE->setVisibility();
        $this->FOLLOW_UP->setVisibility();
        $this->DIRUJUK_OLEH->setVisibility();
        $this->INSPECTION_DATE->setVisibility();
        $this->PORSIO->setVisibility();
        $this->PEMBUKAAN->setVisibility();
        $this->KETUBAN->setVisibility();
        $this->PRESENTASI->setVisibility();
        $this->POSISI->setVisibility();
        $this->PENURUNAN->setVisibility();
        $this->HEART_ID->Visible = false;
        $this->JANIN_ID->Visible = false;
        $this->FREK_DJJ->Visible = false;
        $this->PLACENTA->setVisibility();
        $this->LOCHIA->Visible = false;
        $this->BAB_TYPE->Visible = false;
        $this->BAB_BAB_TYPE->Visible = false;
        $this->RAHIM_ID->setVisibility();
        $this->BIR_RAHIM_ID->Visible = false;
        $this->VISIT_ID->Visible = false;
        $this->BLOODING->setVisibility();
        $this->DESCRIPTION->setVisibility();
        $this->MODIFIED_DATE->Visible = false;
        $this->MODIFIED_BY->Visible = false;
        $this->MODIFIED_FROM->Visible = false;
        $this->RAHIM_SALIN->Visible = false;
        $this->RAHIM_NIFAS->Visible = false;
        $this->BAK_TYPE->Visible = false;
        $this->THEID->Visible = false;
        $this->STATUS_PASIEN_ID->Visible = false;
        $this->ISRJ->Visible = false;
        $this->AGEYEAR->Visible = false;
        $this->AGEMONTH->Visible = false;
        $this->AGEDAY->Visible = false;
        $this->CLASS_ROOM_ID->Visible = false;
        $this->BED_ID->Visible = false;
        $this->KELUAR_ID->Visible = false;
        $this->DOCTOR->Visible = false;
        $this->NB_OBSTETRI->Visible = false;
        $this->OBSTETRI_DIE->Visible = false;
        $this->KAL_ID->Visible = false;
        $this->DIAGNOSA_ID2->Visible = false;
        $this->APGAR_ID->Visible = false;
        $this->BIRTH_LAST_ID->Visible = false;
        $this->ID->setVisibility();
        $this->hideFieldsForAddEdit();

        // Do not use lookup cache
        $this->setUseLookupCache(false);

        // Set up multi page object
        $this->setupMultiPages();

        // Global Page Loading event (in userfn*.php)
        Page_Loading();

        // Page Load event
        if (method_exists($this, "pageLoad")) {
            $this->pageLoad();
        }

        // Set up lookup cache
        $this->setupLookupOptions($this->GENDER);
        $this->setupLookupOptions($this->CLINIC_ID);
        $this->setupLookupOptions($this->EMPLOYEE_ID);
        $this->setupLookupOptions($this->BIRTH_NB);
        $this->setupLookupOptions($this->BIRTH_PLACE);
        $this->setupLookupOptions($this->ANTE_NATAL);
        $this->setupLookupOptions($this->BIRTH_WAY);
        $this->setupLookupOptions($this->BIRTH_BY);
        $this->setupLookupOptions($this->ABORTUS_ID);
        $this->setupLookupOptions($this->BIRTH_CON);
        $this->setupLookupOptions($this->FOLLOW_UP);
        $this->setupLookupOptions($this->RAHIM_ID);

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

            // Set up master detail parameters
            $this->setupMasterParms();

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
                    $this->terminate("ObstetriList"); // No matching record, return to list
                    return;
                }
                break;
            case "update": // Update
                $returnUrl = $this->GetViewUrl();
                if (GetPageName($returnUrl) == "ObstetriList") {
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

        // Check field name 'NO_REGISTRATION' first before field var 'x_NO_REGISTRATION'
        $val = $CurrentForm->hasValue("NO_REGISTRATION") ? $CurrentForm->getValue("NO_REGISTRATION") : $CurrentForm->getValue("x_NO_REGISTRATION");
        if (!$this->NO_REGISTRATION->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->NO_REGISTRATION->Visible = false; // Disable update for API request
            } else {
                $this->NO_REGISTRATION->setFormValue($val);
            }
        }

        // Check field name 'THENAME' first before field var 'x_THENAME'
        $val = $CurrentForm->hasValue("THENAME") ? $CurrentForm->getValue("THENAME") : $CurrentForm->getValue("x_THENAME");
        if (!$this->THENAME->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->THENAME->Visible = false; // Disable update for API request
            } else {
                $this->THENAME->setFormValue($val);
            }
        }

        // Check field name 'THEADDRESS' first before field var 'x_THEADDRESS'
        $val = $CurrentForm->hasValue("THEADDRESS") ? $CurrentForm->getValue("THEADDRESS") : $CurrentForm->getValue("x_THEADDRESS");
        if (!$this->THEADDRESS->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->THEADDRESS->Visible = false; // Disable update for API request
            } else {
                $this->THEADDRESS->setFormValue($val);
            }
        }

        // Check field name 'GENDER' first before field var 'x_GENDER'
        $val = $CurrentForm->hasValue("GENDER") ? $CurrentForm->getValue("GENDER") : $CurrentForm->getValue("x_GENDER");
        if (!$this->GENDER->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->GENDER->Visible = false; // Disable update for API request
            } else {
                $this->GENDER->setFormValue($val);
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

        // Check field name 'EMPLOYEE_ID' first before field var 'x_EMPLOYEE_ID'
        $val = $CurrentForm->hasValue("EMPLOYEE_ID") ? $CurrentForm->getValue("EMPLOYEE_ID") : $CurrentForm->getValue("x_EMPLOYEE_ID");
        if (!$this->EMPLOYEE_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->EMPLOYEE_ID->Visible = false; // Disable update for API request
            } else {
                $this->EMPLOYEE_ID->setFormValue($val);
            }
        }

        // Check field name 'BIRTH_NB' first before field var 'x_BIRTH_NB'
        $val = $CurrentForm->hasValue("BIRTH_NB") ? $CurrentForm->getValue("BIRTH_NB") : $CurrentForm->getValue("x_BIRTH_NB");
        if (!$this->BIRTH_NB->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->BIRTH_NB->Visible = false; // Disable update for API request
            } else {
                $this->BIRTH_NB->setFormValue($val);
            }
        }

        // Check field name 'BIRTH_DURATION' first before field var 'x_BIRTH_DURATION'
        $val = $CurrentForm->hasValue("BIRTH_DURATION") ? $CurrentForm->getValue("BIRTH_DURATION") : $CurrentForm->getValue("x_BIRTH_DURATION");
        if (!$this->BIRTH_DURATION->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->BIRTH_DURATION->Visible = false; // Disable update for API request
            } else {
                $this->BIRTH_DURATION->setFormValue($val);
            }
        }

        // Check field name 'BIRTH_PLACE' first before field var 'x_BIRTH_PLACE'
        $val = $CurrentForm->hasValue("BIRTH_PLACE") ? $CurrentForm->getValue("BIRTH_PLACE") : $CurrentForm->getValue("x_BIRTH_PLACE");
        if (!$this->BIRTH_PLACE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->BIRTH_PLACE->Visible = false; // Disable update for API request
            } else {
                $this->BIRTH_PLACE->setFormValue($val);
            }
        }

        // Check field name 'ANTE_NATAL' first before field var 'x_ANTE_NATAL'
        $val = $CurrentForm->hasValue("ANTE_NATAL") ? $CurrentForm->getValue("ANTE_NATAL") : $CurrentForm->getValue("x_ANTE_NATAL");
        if (!$this->ANTE_NATAL->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ANTE_NATAL->Visible = false; // Disable update for API request
            } else {
                $this->ANTE_NATAL->setFormValue($val);
            }
        }

        // Check field name 'BIRTH_WAY' first before field var 'x_BIRTH_WAY'
        $val = $CurrentForm->hasValue("BIRTH_WAY") ? $CurrentForm->getValue("BIRTH_WAY") : $CurrentForm->getValue("x_BIRTH_WAY");
        if (!$this->BIRTH_WAY->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->BIRTH_WAY->Visible = false; // Disable update for API request
            } else {
                $this->BIRTH_WAY->setFormValue($val);
            }
        }

        // Check field name 'BIRTH_BY' first before field var 'x_BIRTH_BY'
        $val = $CurrentForm->hasValue("BIRTH_BY") ? $CurrentForm->getValue("BIRTH_BY") : $CurrentForm->getValue("x_BIRTH_BY");
        if (!$this->BIRTH_BY->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->BIRTH_BY->Visible = false; // Disable update for API request
            } else {
                $this->BIRTH_BY->setFormValue($val);
            }
        }

        // Check field name 'BIRTH_DATE' first before field var 'x_BIRTH_DATE'
        $val = $CurrentForm->hasValue("BIRTH_DATE") ? $CurrentForm->getValue("BIRTH_DATE") : $CurrentForm->getValue("x_BIRTH_DATE");
        if (!$this->BIRTH_DATE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->BIRTH_DATE->Visible = false; // Disable update for API request
            } else {
                $this->BIRTH_DATE->setFormValue($val);
            }
            $this->BIRTH_DATE->CurrentValue = UnFormatDateTime($this->BIRTH_DATE->CurrentValue, 7);
        }

        // Check field name 'GESTASI' first before field var 'x_GESTASI'
        $val = $CurrentForm->hasValue("GESTASI") ? $CurrentForm->getValue("GESTASI") : $CurrentForm->getValue("x_GESTASI");
        if (!$this->GESTASI->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->GESTASI->Visible = false; // Disable update for API request
            } else {
                $this->GESTASI->setFormValue($val);
            }
        }

        // Check field name 'PARITY' first before field var 'x_PARITY'
        $val = $CurrentForm->hasValue("PARITY") ? $CurrentForm->getValue("PARITY") : $CurrentForm->getValue("x_PARITY");
        if (!$this->PARITY->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->PARITY->Visible = false; // Disable update for API request
            } else {
                $this->PARITY->setFormValue($val);
            }
        }

        // Check field name 'NB_BABY' first before field var 'x_NB_BABY'
        $val = $CurrentForm->hasValue("NB_BABY") ? $CurrentForm->getValue("NB_BABY") : $CurrentForm->getValue("x_NB_BABY");
        if (!$this->NB_BABY->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->NB_BABY->Visible = false; // Disable update for API request
            } else {
                $this->NB_BABY->setFormValue($val);
            }
        }

        // Check field name 'BABY_DIE' first before field var 'x_BABY_DIE'
        $val = $CurrentForm->hasValue("BABY_DIE") ? $CurrentForm->getValue("BABY_DIE") : $CurrentForm->getValue("x_BABY_DIE");
        if (!$this->BABY_DIE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->BABY_DIE->Visible = false; // Disable update for API request
            } else {
                $this->BABY_DIE->setFormValue($val);
            }
        }

        // Check field name 'ABORTUS_KE' first before field var 'x_ABORTUS_KE'
        $val = $CurrentForm->hasValue("ABORTUS_KE") ? $CurrentForm->getValue("ABORTUS_KE") : $CurrentForm->getValue("x_ABORTUS_KE");
        if (!$this->ABORTUS_KE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ABORTUS_KE->Visible = false; // Disable update for API request
            } else {
                $this->ABORTUS_KE->setFormValue($val);
            }
        }

        // Check field name 'ABORTUS_ID' first before field var 'x_ABORTUS_ID'
        $val = $CurrentForm->hasValue("ABORTUS_ID") ? $CurrentForm->getValue("ABORTUS_ID") : $CurrentForm->getValue("x_ABORTUS_ID");
        if (!$this->ABORTUS_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ABORTUS_ID->Visible = false; // Disable update for API request
            } else {
                $this->ABORTUS_ID->setFormValue($val);
            }
        }

        // Check field name 'ABORTION_DATE' first before field var 'x_ABORTION_DATE'
        $val = $CurrentForm->hasValue("ABORTION_DATE") ? $CurrentForm->getValue("ABORTION_DATE") : $CurrentForm->getValue("x_ABORTION_DATE");
        if (!$this->ABORTION_DATE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ABORTION_DATE->Visible = false; // Disable update for API request
            } else {
                $this->ABORTION_DATE->setFormValue($val);
            }
            $this->ABORTION_DATE->CurrentValue = UnFormatDateTime($this->ABORTION_DATE->CurrentValue, 0);
        }

        // Check field name 'BIRTH_CAT' first before field var 'x_BIRTH_CAT'
        $val = $CurrentForm->hasValue("BIRTH_CAT") ? $CurrentForm->getValue("BIRTH_CAT") : $CurrentForm->getValue("x_BIRTH_CAT");
        if (!$this->BIRTH_CAT->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->BIRTH_CAT->Visible = false; // Disable update for API request
            } else {
                $this->BIRTH_CAT->setFormValue($val);
            }
        }

        // Check field name 'BIRTH_CON' first before field var 'x_BIRTH_CON'
        $val = $CurrentForm->hasValue("BIRTH_CON") ? $CurrentForm->getValue("BIRTH_CON") : $CurrentForm->getValue("x_BIRTH_CON");
        if (!$this->BIRTH_CON->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->BIRTH_CON->Visible = false; // Disable update for API request
            } else {
                $this->BIRTH_CON->setFormValue($val);
            }
        }

        // Check field name 'BIRTH_RISK' first before field var 'x_BIRTH_RISK'
        $val = $CurrentForm->hasValue("BIRTH_RISK") ? $CurrentForm->getValue("BIRTH_RISK") : $CurrentForm->getValue("x_BIRTH_RISK");
        if (!$this->BIRTH_RISK->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->BIRTH_RISK->Visible = false; // Disable update for API request
            } else {
                $this->BIRTH_RISK->setFormValue($val);
            }
        }

        // Check field name 'RISK_TYPE' first before field var 'x_RISK_TYPE'
        $val = $CurrentForm->hasValue("RISK_TYPE") ? $CurrentForm->getValue("RISK_TYPE") : $CurrentForm->getValue("x_RISK_TYPE");
        if (!$this->RISK_TYPE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->RISK_TYPE->Visible = false; // Disable update for API request
            } else {
                $this->RISK_TYPE->setFormValue($val);
            }
        }

        // Check field name 'FOLLOW_UP' first before field var 'x_FOLLOW_UP'
        $val = $CurrentForm->hasValue("FOLLOW_UP") ? $CurrentForm->getValue("FOLLOW_UP") : $CurrentForm->getValue("x_FOLLOW_UP");
        if (!$this->FOLLOW_UP->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->FOLLOW_UP->Visible = false; // Disable update for API request
            } else {
                $this->FOLLOW_UP->setFormValue($val);
            }
        }

        // Check field name 'DIRUJUK_OLEH' first before field var 'x_DIRUJUK_OLEH'
        $val = $CurrentForm->hasValue("DIRUJUK_OLEH") ? $CurrentForm->getValue("DIRUJUK_OLEH") : $CurrentForm->getValue("x_DIRUJUK_OLEH");
        if (!$this->DIRUJUK_OLEH->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->DIRUJUK_OLEH->Visible = false; // Disable update for API request
            } else {
                $this->DIRUJUK_OLEH->setFormValue($val);
            }
        }

        // Check field name 'INSPECTION_DATE' first before field var 'x_INSPECTION_DATE'
        $val = $CurrentForm->hasValue("INSPECTION_DATE") ? $CurrentForm->getValue("INSPECTION_DATE") : $CurrentForm->getValue("x_INSPECTION_DATE");
        if (!$this->INSPECTION_DATE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->INSPECTION_DATE->Visible = false; // Disable update for API request
            } else {
                $this->INSPECTION_DATE->setFormValue($val);
            }
            $this->INSPECTION_DATE->CurrentValue = UnFormatDateTime($this->INSPECTION_DATE->CurrentValue, 11);
        }

        // Check field name 'PORSIO' first before field var 'x_PORSIO'
        $val = $CurrentForm->hasValue("PORSIO") ? $CurrentForm->getValue("PORSIO") : $CurrentForm->getValue("x_PORSIO");
        if (!$this->PORSIO->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->PORSIO->Visible = false; // Disable update for API request
            } else {
                $this->PORSIO->setFormValue($val);
            }
        }

        // Check field name 'PEMBUKAAN' first before field var 'x_PEMBUKAAN'
        $val = $CurrentForm->hasValue("PEMBUKAAN") ? $CurrentForm->getValue("PEMBUKAAN") : $CurrentForm->getValue("x_PEMBUKAAN");
        if (!$this->PEMBUKAAN->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->PEMBUKAAN->Visible = false; // Disable update for API request
            } else {
                $this->PEMBUKAAN->setFormValue($val);
            }
        }

        // Check field name 'KETUBAN' first before field var 'x_KETUBAN'
        $val = $CurrentForm->hasValue("KETUBAN") ? $CurrentForm->getValue("KETUBAN") : $CurrentForm->getValue("x_KETUBAN");
        if (!$this->KETUBAN->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->KETUBAN->Visible = false; // Disable update for API request
            } else {
                $this->KETUBAN->setFormValue($val);
            }
        }

        // Check field name 'PRESENTASI' first before field var 'x_PRESENTASI'
        $val = $CurrentForm->hasValue("PRESENTASI") ? $CurrentForm->getValue("PRESENTASI") : $CurrentForm->getValue("x_PRESENTASI");
        if (!$this->PRESENTASI->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->PRESENTASI->Visible = false; // Disable update for API request
            } else {
                $this->PRESENTASI->setFormValue($val);
            }
        }

        // Check field name 'POSISI' first before field var 'x_POSISI'
        $val = $CurrentForm->hasValue("POSISI") ? $CurrentForm->getValue("POSISI") : $CurrentForm->getValue("x_POSISI");
        if (!$this->POSISI->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->POSISI->Visible = false; // Disable update for API request
            } else {
                $this->POSISI->setFormValue($val);
            }
        }

        // Check field name 'PENURUNAN' first before field var 'x_PENURUNAN'
        $val = $CurrentForm->hasValue("PENURUNAN") ? $CurrentForm->getValue("PENURUNAN") : $CurrentForm->getValue("x_PENURUNAN");
        if (!$this->PENURUNAN->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->PENURUNAN->Visible = false; // Disable update for API request
            } else {
                $this->PENURUNAN->setFormValue($val);
            }
        }

        // Check field name 'PLACENTA' first before field var 'x_PLACENTA'
        $val = $CurrentForm->hasValue("PLACENTA") ? $CurrentForm->getValue("PLACENTA") : $CurrentForm->getValue("x_PLACENTA");
        if (!$this->PLACENTA->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->PLACENTA->Visible = false; // Disable update for API request
            } else {
                $this->PLACENTA->setFormValue($val);
            }
        }

        // Check field name 'RAHIM_ID' first before field var 'x_RAHIM_ID'
        $val = $CurrentForm->hasValue("RAHIM_ID") ? $CurrentForm->getValue("RAHIM_ID") : $CurrentForm->getValue("x_RAHIM_ID");
        if (!$this->RAHIM_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->RAHIM_ID->Visible = false; // Disable update for API request
            } else {
                $this->RAHIM_ID->setFormValue($val);
            }
        }

        // Check field name 'BLOODING' first before field var 'x_BLOODING'
        $val = $CurrentForm->hasValue("BLOODING") ? $CurrentForm->getValue("BLOODING") : $CurrentForm->getValue("x_BLOODING");
        if (!$this->BLOODING->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->BLOODING->Visible = false; // Disable update for API request
            } else {
                $this->BLOODING->setFormValue($val);
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
        $this->NO_REGISTRATION->CurrentValue = $this->NO_REGISTRATION->FormValue;
        $this->THENAME->CurrentValue = $this->THENAME->FormValue;
        $this->THEADDRESS->CurrentValue = $this->THEADDRESS->FormValue;
        $this->GENDER->CurrentValue = $this->GENDER->FormValue;
        $this->CLINIC_ID->CurrentValue = $this->CLINIC_ID->FormValue;
        $this->EMPLOYEE_ID->CurrentValue = $this->EMPLOYEE_ID->FormValue;
        $this->BIRTH_NB->CurrentValue = $this->BIRTH_NB->FormValue;
        $this->BIRTH_DURATION->CurrentValue = $this->BIRTH_DURATION->FormValue;
        $this->BIRTH_PLACE->CurrentValue = $this->BIRTH_PLACE->FormValue;
        $this->ANTE_NATAL->CurrentValue = $this->ANTE_NATAL->FormValue;
        $this->BIRTH_WAY->CurrentValue = $this->BIRTH_WAY->FormValue;
        $this->BIRTH_BY->CurrentValue = $this->BIRTH_BY->FormValue;
        $this->BIRTH_DATE->CurrentValue = $this->BIRTH_DATE->FormValue;
        $this->BIRTH_DATE->CurrentValue = UnFormatDateTime($this->BIRTH_DATE->CurrentValue, 7);
        $this->GESTASI->CurrentValue = $this->GESTASI->FormValue;
        $this->PARITY->CurrentValue = $this->PARITY->FormValue;
        $this->NB_BABY->CurrentValue = $this->NB_BABY->FormValue;
        $this->BABY_DIE->CurrentValue = $this->BABY_DIE->FormValue;
        $this->ABORTUS_KE->CurrentValue = $this->ABORTUS_KE->FormValue;
        $this->ABORTUS_ID->CurrentValue = $this->ABORTUS_ID->FormValue;
        $this->ABORTION_DATE->CurrentValue = $this->ABORTION_DATE->FormValue;
        $this->ABORTION_DATE->CurrentValue = UnFormatDateTime($this->ABORTION_DATE->CurrentValue, 0);
        $this->BIRTH_CAT->CurrentValue = $this->BIRTH_CAT->FormValue;
        $this->BIRTH_CON->CurrentValue = $this->BIRTH_CON->FormValue;
        $this->BIRTH_RISK->CurrentValue = $this->BIRTH_RISK->FormValue;
        $this->RISK_TYPE->CurrentValue = $this->RISK_TYPE->FormValue;
        $this->FOLLOW_UP->CurrentValue = $this->FOLLOW_UP->FormValue;
        $this->DIRUJUK_OLEH->CurrentValue = $this->DIRUJUK_OLEH->FormValue;
        $this->INSPECTION_DATE->CurrentValue = $this->INSPECTION_DATE->FormValue;
        $this->INSPECTION_DATE->CurrentValue = UnFormatDateTime($this->INSPECTION_DATE->CurrentValue, 11);
        $this->PORSIO->CurrentValue = $this->PORSIO->FormValue;
        $this->PEMBUKAAN->CurrentValue = $this->PEMBUKAAN->FormValue;
        $this->KETUBAN->CurrentValue = $this->KETUBAN->FormValue;
        $this->PRESENTASI->CurrentValue = $this->PRESENTASI->FormValue;
        $this->POSISI->CurrentValue = $this->POSISI->FormValue;
        $this->PENURUNAN->CurrentValue = $this->PENURUNAN->FormValue;
        $this->PLACENTA->CurrentValue = $this->PLACENTA->FormValue;
        $this->RAHIM_ID->CurrentValue = $this->RAHIM_ID->FormValue;
        $this->BLOODING->CurrentValue = $this->BLOODING->FormValue;
        $this->DESCRIPTION->CurrentValue = $this->DESCRIPTION->FormValue;
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
        $this->OBSTETRI_ID->setDbValue($row['OBSTETRI_ID']);
        $this->NO_REGISTRATION->setDbValue($row['NO_REGISTRATION']);
        $this->THENAME->setDbValue($row['THENAME']);
        $this->THEADDRESS->setDbValue($row['THEADDRESS']);
        $this->GENDER->setDbValue($row['GENDER']);
        $this->CLINIC_ID->setDbValue($row['CLINIC_ID']);
        $this->EMPLOYEE_ID->setDbValue($row['EMPLOYEE_ID']);
        $this->HPHT->setDbValue($row['HPHT']);
        $this->HTP->setDbValue($row['HTP']);
        $this->PASIEN_DIAGNOSA_ID->setDbValue($row['PASIEN_DIAGNOSA_ID']);
        $this->DIAGNOSA_ID->setDbValue($row['DIAGNOSA_ID']);
        $this->KOHORT_NB->setDbValue($row['KOHORT_NB']);
        $this->BIRTH_NB->setDbValue($row['BIRTH_NB']);
        $this->BIRTH_DURATION->setDbValue($row['BIRTH_DURATION']);
        $this->BIRTH_PLACE->setDbValue($row['BIRTH_PLACE']);
        $this->ANTE_NATAL->setDbValue($row['ANTE_NATAL']);
        $this->BIRTH_WAY->setDbValue($row['BIRTH_WAY']);
        $this->BIRTH_BY->setDbValue($row['BIRTH_BY']);
        $this->BIRTH_DATE->setDbValue($row['BIRTH_DATE']);
        $this->GESTASI->setDbValue($row['GESTASI']);
        $this->PARITY->setDbValue($row['PARITY']);
        $this->NB_BABY->setDbValue($row['NB_BABY']);
        $this->BABY_DIE->setDbValue($row['BABY_DIE']);
        $this->ABORTUS_KE->setDbValue($row['ABORTUS_KE']);
        $this->ABORTUS_ID->setDbValue($row['ABORTUS_ID']);
        $this->ABORTION_DATE->setDbValue($row['ABORTION_DATE']);
        $this->BIRTH_CAT->setDbValue($row['BIRTH_CAT']);
        $this->BIRTH_CON->setDbValue($row['BIRTH_CON']);
        $this->BIRTH_RISK->setDbValue($row['BIRTH_RISK']);
        $this->RISK_TYPE->setDbValue($row['RISK_TYPE']);
        $this->FOLLOW_UP->setDbValue($row['FOLLOW_UP']);
        $this->DIRUJUK_OLEH->setDbValue($row['DIRUJUK_OLEH']);
        $this->INSPECTION_DATE->setDbValue($row['INSPECTION_DATE']);
        $this->PORSIO->setDbValue($row['PORSIO']);
        $this->PEMBUKAAN->setDbValue($row['PEMBUKAAN']);
        $this->KETUBAN->setDbValue($row['KETUBAN']);
        $this->PRESENTASI->setDbValue($row['PRESENTASI']);
        $this->POSISI->setDbValue($row['POSISI']);
        $this->PENURUNAN->setDbValue($row['PENURUNAN']);
        $this->HEART_ID->setDbValue($row['HEART_ID']);
        $this->JANIN_ID->setDbValue($row['JANIN_ID']);
        $this->FREK_DJJ->setDbValue($row['FREK_DJJ']);
        $this->PLACENTA->setDbValue($row['PLACENTA']);
        $this->LOCHIA->setDbValue($row['LOCHIA']);
        $this->BAB_TYPE->setDbValue($row['BAB_TYPE']);
        $this->BAB_BAB_TYPE->setDbValue($row['BAB_BAB_TYPE']);
        $this->RAHIM_ID->setDbValue($row['RAHIM_ID']);
        $this->BIR_RAHIM_ID->setDbValue($row['BIR_RAHIM_ID']);
        $this->VISIT_ID->setDbValue($row['VISIT_ID']);
        $this->BLOODING->setDbValue($row['BLOODING']);
        $this->DESCRIPTION->setDbValue($row['DESCRIPTION']);
        $this->MODIFIED_DATE->setDbValue($row['MODIFIED_DATE']);
        $this->MODIFIED_BY->setDbValue($row['MODIFIED_BY']);
        $this->MODIFIED_FROM->setDbValue($row['MODIFIED_FROM']);
        $this->RAHIM_SALIN->setDbValue($row['RAHIM_SALIN']);
        $this->RAHIM_NIFAS->setDbValue($row['RAHIM_NIFAS']);
        $this->BAK_TYPE->setDbValue($row['BAK_TYPE']);
        $this->THEID->setDbValue($row['THEID']);
        $this->STATUS_PASIEN_ID->setDbValue($row['STATUS_PASIEN_ID']);
        $this->ISRJ->setDbValue($row['ISRJ']);
        $this->AGEYEAR->setDbValue($row['AGEYEAR']);
        $this->AGEMONTH->setDbValue($row['AGEMONTH']);
        $this->AGEDAY->setDbValue($row['AGEDAY']);
        $this->CLASS_ROOM_ID->setDbValue($row['CLASS_ROOM_ID']);
        $this->BED_ID->setDbValue($row['BED_ID']);
        $this->KELUAR_ID->setDbValue($row['KELUAR_ID']);
        $this->DOCTOR->setDbValue($row['DOCTOR']);
        $this->NB_OBSTETRI->setDbValue($row['NB_OBSTETRI']);
        $this->OBSTETRI_DIE->setDbValue($row['OBSTETRI_DIE']);
        $this->KAL_ID->setDbValue($row['KAL_ID']);
        $this->DIAGNOSA_ID2->setDbValue($row['DIAGNOSA_ID2']);
        $this->APGAR_ID->setDbValue($row['APGAR_ID']);
        $this->BIRTH_LAST_ID->setDbValue($row['BIRTH_LAST_ID']);
        $this->ID->setDbValue($row['ID']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['ORG_UNIT_CODE'] = null;
        $row['OBSTETRI_ID'] = null;
        $row['NO_REGISTRATION'] = null;
        $row['THENAME'] = null;
        $row['THEADDRESS'] = null;
        $row['GENDER'] = null;
        $row['CLINIC_ID'] = null;
        $row['EMPLOYEE_ID'] = null;
        $row['HPHT'] = null;
        $row['HTP'] = null;
        $row['PASIEN_DIAGNOSA_ID'] = null;
        $row['DIAGNOSA_ID'] = null;
        $row['KOHORT_NB'] = null;
        $row['BIRTH_NB'] = null;
        $row['BIRTH_DURATION'] = null;
        $row['BIRTH_PLACE'] = null;
        $row['ANTE_NATAL'] = null;
        $row['BIRTH_WAY'] = null;
        $row['BIRTH_BY'] = null;
        $row['BIRTH_DATE'] = null;
        $row['GESTASI'] = null;
        $row['PARITY'] = null;
        $row['NB_BABY'] = null;
        $row['BABY_DIE'] = null;
        $row['ABORTUS_KE'] = null;
        $row['ABORTUS_ID'] = null;
        $row['ABORTION_DATE'] = null;
        $row['BIRTH_CAT'] = null;
        $row['BIRTH_CON'] = null;
        $row['BIRTH_RISK'] = null;
        $row['RISK_TYPE'] = null;
        $row['FOLLOW_UP'] = null;
        $row['DIRUJUK_OLEH'] = null;
        $row['INSPECTION_DATE'] = null;
        $row['PORSIO'] = null;
        $row['PEMBUKAAN'] = null;
        $row['KETUBAN'] = null;
        $row['PRESENTASI'] = null;
        $row['POSISI'] = null;
        $row['PENURUNAN'] = null;
        $row['HEART_ID'] = null;
        $row['JANIN_ID'] = null;
        $row['FREK_DJJ'] = null;
        $row['PLACENTA'] = null;
        $row['LOCHIA'] = null;
        $row['BAB_TYPE'] = null;
        $row['BAB_BAB_TYPE'] = null;
        $row['RAHIM_ID'] = null;
        $row['BIR_RAHIM_ID'] = null;
        $row['VISIT_ID'] = null;
        $row['BLOODING'] = null;
        $row['DESCRIPTION'] = null;
        $row['MODIFIED_DATE'] = null;
        $row['MODIFIED_BY'] = null;
        $row['MODIFIED_FROM'] = null;
        $row['RAHIM_SALIN'] = null;
        $row['RAHIM_NIFAS'] = null;
        $row['BAK_TYPE'] = null;
        $row['THEID'] = null;
        $row['STATUS_PASIEN_ID'] = null;
        $row['ISRJ'] = null;
        $row['AGEYEAR'] = null;
        $row['AGEMONTH'] = null;
        $row['AGEDAY'] = null;
        $row['CLASS_ROOM_ID'] = null;
        $row['BED_ID'] = null;
        $row['KELUAR_ID'] = null;
        $row['DOCTOR'] = null;
        $row['NB_OBSTETRI'] = null;
        $row['OBSTETRI_DIE'] = null;
        $row['KAL_ID'] = null;
        $row['DIAGNOSA_ID2'] = null;
        $row['APGAR_ID'] = null;
        $row['BIRTH_LAST_ID'] = null;
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

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // ORG_UNIT_CODE

        // OBSTETRI_ID

        // NO_REGISTRATION

        // THENAME

        // THEADDRESS

        // GENDER

        // CLINIC_ID

        // EMPLOYEE_ID

        // HPHT

        // HTP

        // PASIEN_DIAGNOSA_ID

        // DIAGNOSA_ID

        // KOHORT_NB

        // BIRTH_NB

        // BIRTH_DURATION

        // BIRTH_PLACE

        // ANTE_NATAL

        // BIRTH_WAY

        // BIRTH_BY

        // BIRTH_DATE

        // GESTASI

        // PARITY

        // NB_BABY

        // BABY_DIE

        // ABORTUS_KE

        // ABORTUS_ID

        // ABORTION_DATE

        // BIRTH_CAT

        // BIRTH_CON

        // BIRTH_RISK

        // RISK_TYPE

        // FOLLOW_UP

        // DIRUJUK_OLEH

        // INSPECTION_DATE

        // PORSIO

        // PEMBUKAAN

        // KETUBAN

        // PRESENTASI

        // POSISI

        // PENURUNAN

        // HEART_ID

        // JANIN_ID

        // FREK_DJJ

        // PLACENTA

        // LOCHIA

        // BAB_TYPE

        // BAB_BAB_TYPE

        // RAHIM_ID

        // BIR_RAHIM_ID

        // VISIT_ID

        // BLOODING

        // DESCRIPTION

        // MODIFIED_DATE

        // MODIFIED_BY

        // MODIFIED_FROM

        // RAHIM_SALIN

        // RAHIM_NIFAS

        // BAK_TYPE

        // THEID

        // STATUS_PASIEN_ID

        // ISRJ

        // AGEYEAR

        // AGEMONTH

        // AGEDAY

        // CLASS_ROOM_ID

        // BED_ID

        // KELUAR_ID

        // DOCTOR

        // NB_OBSTETRI

        // OBSTETRI_DIE

        // KAL_ID

        // DIAGNOSA_ID2

        // APGAR_ID

        // BIRTH_LAST_ID

        // ID
        if ($this->RowType == ROWTYPE_VIEW) {
            // NO_REGISTRATION
            $this->NO_REGISTRATION->ViewValue = $this->NO_REGISTRATION->CurrentValue;
            $this->NO_REGISTRATION->ViewCustomAttributes = "";

            // THENAME
            $this->THENAME->ViewValue = $this->THENAME->CurrentValue;
            $this->THENAME->ViewCustomAttributes = "";

            // THEADDRESS
            $this->THEADDRESS->ViewValue = $this->THEADDRESS->CurrentValue;
            $this->THEADDRESS->ViewCustomAttributes = "";

            // GENDER
            $curVal = trim(strval($this->GENDER->CurrentValue));
            if ($curVal != "") {
                $this->GENDER->ViewValue = $this->GENDER->lookupCacheOption($curVal);
                if ($this->GENDER->ViewValue === null) { // Lookup from database
                    $filterWrk = "[GENDER]" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->GENDER->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->GENDER->Lookup->renderViewRow($rswrk[0]);
                        $this->GENDER->ViewValue = $this->GENDER->displayValue($arwrk);
                    } else {
                        $this->GENDER->ViewValue = $this->GENDER->CurrentValue;
                    }
                }
            } else {
                $this->GENDER->ViewValue = null;
            }
            $this->GENDER->ViewCustomAttributes = "";

            // CLINIC_ID
            $curVal = trim(strval($this->CLINIC_ID->CurrentValue));
            if ($curVal != "") {
                $this->CLINIC_ID->ViewValue = $this->CLINIC_ID->lookupCacheOption($curVal);
                if ($this->CLINIC_ID->ViewValue === null) { // Lookup from database
                    $filterWrk = "[CLINIC_ID]" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->CLINIC_ID->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->CLINIC_ID->Lookup->renderViewRow($rswrk[0]);
                        $this->CLINIC_ID->ViewValue = $this->CLINIC_ID->displayValue($arwrk);
                    } else {
                        $this->CLINIC_ID->ViewValue = $this->CLINIC_ID->CurrentValue;
                    }
                }
            } else {
                $this->CLINIC_ID->ViewValue = null;
            }
            $this->CLINIC_ID->ViewCustomAttributes = "";

            // EMPLOYEE_ID
            $curVal = trim(strval($this->EMPLOYEE_ID->CurrentValue));
            if ($curVal != "") {
                $this->EMPLOYEE_ID->ViewValue = $this->EMPLOYEE_ID->lookupCacheOption($curVal);
                if ($this->EMPLOYEE_ID->ViewValue === null) { // Lookup from database
                    $filterWrk = "[EMPLOYEE_ID]" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $lookupFilter = function() {
                        return "[OBJECT_CATEGORY_ID]=20 AND [NONACTIVE]=0";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    $sqlWrk = $this->EMPLOYEE_ID->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->EMPLOYEE_ID->Lookup->renderViewRow($rswrk[0]);
                        $this->EMPLOYEE_ID->ViewValue = $this->EMPLOYEE_ID->displayValue($arwrk);
                    } else {
                        $this->EMPLOYEE_ID->ViewValue = $this->EMPLOYEE_ID->CurrentValue;
                    }
                }
            } else {
                $this->EMPLOYEE_ID->ViewValue = null;
            }
            $this->EMPLOYEE_ID->ViewCustomAttributes = "";

            // HPHT
            $this->HPHT->ViewValue = $this->HPHT->CurrentValue;
            $this->HPHT->ViewValue = FormatDateTime($this->HPHT->ViewValue, 0);
            $this->HPHT->ViewCustomAttributes = "";

            // HTP
            $this->HTP->ViewValue = $this->HTP->CurrentValue;
            $this->HTP->ViewValue = FormatDateTime($this->HTP->ViewValue, 0);
            $this->HTP->ViewCustomAttributes = "";

            // PASIEN_DIAGNOSA_ID
            $this->PASIEN_DIAGNOSA_ID->ViewValue = $this->PASIEN_DIAGNOSA_ID->CurrentValue;
            $this->PASIEN_DIAGNOSA_ID->ViewCustomAttributes = "";

            // DIAGNOSA_ID
            $this->DIAGNOSA_ID->ViewValue = $this->DIAGNOSA_ID->CurrentValue;
            $this->DIAGNOSA_ID->ViewCustomAttributes = "";

            // KOHORT_NB
            $this->KOHORT_NB->ViewValue = $this->KOHORT_NB->CurrentValue;
            $this->KOHORT_NB->ViewCustomAttributes = "";

            // BIRTH_NB
            $curVal = trim(strval($this->BIRTH_NB->CurrentValue));
            if ($curVal != "") {
                $this->BIRTH_NB->ViewValue = $this->BIRTH_NB->lookupCacheOption($curVal);
                if ($this->BIRTH_NB->ViewValue === null) { // Lookup from database
                    $filterWrk = "[BIRTH_NB]" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->BIRTH_NB->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->BIRTH_NB->Lookup->renderViewRow($rswrk[0]);
                        $this->BIRTH_NB->ViewValue = $this->BIRTH_NB->displayValue($arwrk);
                    } else {
                        $this->BIRTH_NB->ViewValue = $this->BIRTH_NB->CurrentValue;
                    }
                }
            } else {
                $this->BIRTH_NB->ViewValue = null;
            }
            $this->BIRTH_NB->ViewCustomAttributes = "";

            // BIRTH_DURATION
            $this->BIRTH_DURATION->ViewValue = $this->BIRTH_DURATION->CurrentValue;
            $this->BIRTH_DURATION->ViewValue = FormatNumber($this->BIRTH_DURATION->ViewValue, 0, -2, -2, -2);
            $this->BIRTH_DURATION->ViewCustomAttributes = "";

            // BIRTH_PLACE
            $curVal = trim(strval($this->BIRTH_PLACE->CurrentValue));
            if ($curVal != "") {
                $this->BIRTH_PLACE->ViewValue = $this->BIRTH_PLACE->lookupCacheOption($curVal);
                if ($this->BIRTH_PLACE->ViewValue === null) { // Lookup from database
                    $filterWrk = "[BIRTH_PLACE]" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->BIRTH_PLACE->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->BIRTH_PLACE->Lookup->renderViewRow($rswrk[0]);
                        $this->BIRTH_PLACE->ViewValue = $this->BIRTH_PLACE->displayValue($arwrk);
                    } else {
                        $this->BIRTH_PLACE->ViewValue = $this->BIRTH_PLACE->CurrentValue;
                    }
                }
            } else {
                $this->BIRTH_PLACE->ViewValue = null;
            }
            $this->BIRTH_PLACE->ViewCustomAttributes = "";

            // ANTE_NATAL
            $curVal = trim(strval($this->ANTE_NATAL->CurrentValue));
            if ($curVal != "") {
                $this->ANTE_NATAL->ViewValue = $this->ANTE_NATAL->lookupCacheOption($curVal);
                if ($this->ANTE_NATAL->ViewValue === null) { // Lookup from database
                    $filterWrk = "[ANTE_NATAL]" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->ANTE_NATAL->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->ANTE_NATAL->Lookup->renderViewRow($rswrk[0]);
                        $this->ANTE_NATAL->ViewValue = $this->ANTE_NATAL->displayValue($arwrk);
                    } else {
                        $this->ANTE_NATAL->ViewValue = $this->ANTE_NATAL->CurrentValue;
                    }
                }
            } else {
                $this->ANTE_NATAL->ViewValue = null;
            }
            $this->ANTE_NATAL->ViewCustomAttributes = "";

            // BIRTH_WAY
            $curVal = trim(strval($this->BIRTH_WAY->CurrentValue));
            if ($curVal != "") {
                $this->BIRTH_WAY->ViewValue = $this->BIRTH_WAY->lookupCacheOption($curVal);
                if ($this->BIRTH_WAY->ViewValue === null) { // Lookup from database
                    $filterWrk = "[BIRTHWAY]" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->BIRTH_WAY->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->BIRTH_WAY->Lookup->renderViewRow($rswrk[0]);
                        $this->BIRTH_WAY->ViewValue = $this->BIRTH_WAY->displayValue($arwrk);
                    } else {
                        $this->BIRTH_WAY->ViewValue = $this->BIRTH_WAY->CurrentValue;
                    }
                }
            } else {
                $this->BIRTH_WAY->ViewValue = null;
            }
            $this->BIRTH_WAY->ViewCustomAttributes = "";

            // BIRTH_BY
            $curVal = trim(strval($this->BIRTH_BY->CurrentValue));
            if ($curVal != "") {
                $this->BIRTH_BY->ViewValue = $this->BIRTH_BY->lookupCacheOption($curVal);
                if ($this->BIRTH_BY->ViewValue === null) { // Lookup from database
                    $filterWrk = "[BIRTH_BY]" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->BIRTH_BY->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->BIRTH_BY->Lookup->renderViewRow($rswrk[0]);
                        $this->BIRTH_BY->ViewValue = $this->BIRTH_BY->displayValue($arwrk);
                    } else {
                        $this->BIRTH_BY->ViewValue = $this->BIRTH_BY->CurrentValue;
                    }
                }
            } else {
                $this->BIRTH_BY->ViewValue = null;
            }
            $this->BIRTH_BY->ViewCustomAttributes = "";

            // BIRTH_DATE
            $this->BIRTH_DATE->ViewValue = $this->BIRTH_DATE->CurrentValue;
            $this->BIRTH_DATE->ViewValue = FormatDateTime($this->BIRTH_DATE->ViewValue, 7);
            $this->BIRTH_DATE->ViewCustomAttributes = "";

            // GESTASI
            $this->GESTASI->ViewValue = $this->GESTASI->CurrentValue;
            $this->GESTASI->ViewValue = FormatNumber($this->GESTASI->ViewValue, 0, -2, -2, -2);
            $this->GESTASI->ViewCustomAttributes = "";

            // PARITY
            $this->PARITY->ViewValue = $this->PARITY->CurrentValue;
            $this->PARITY->ViewValue = FormatNumber($this->PARITY->ViewValue, 0, -2, -2, -2);
            $this->PARITY->ViewCustomAttributes = "";

            // NB_BABY
            $this->NB_BABY->ViewValue = $this->NB_BABY->CurrentValue;
            $this->NB_BABY->ViewValue = FormatNumber($this->NB_BABY->ViewValue, 0, -2, -2, -2);
            $this->NB_BABY->ViewCustomAttributes = "";

            // BABY_DIE
            $this->BABY_DIE->ViewValue = $this->BABY_DIE->CurrentValue;
            $this->BABY_DIE->ViewValue = FormatNumber($this->BABY_DIE->ViewValue, 0, -2, -2, -2);
            $this->BABY_DIE->ViewCustomAttributes = "";

            // ABORTUS_KE
            $this->ABORTUS_KE->ViewValue = $this->ABORTUS_KE->CurrentValue;
            $this->ABORTUS_KE->ViewValue = FormatNumber($this->ABORTUS_KE->ViewValue, 0, -2, -2, -2);
            $this->ABORTUS_KE->ViewCustomAttributes = "";

            // ABORTUS_ID
            $curVal = trim(strval($this->ABORTUS_ID->CurrentValue));
            if ($curVal != "") {
                $this->ABORTUS_ID->ViewValue = $this->ABORTUS_ID->lookupCacheOption($curVal);
                if ($this->ABORTUS_ID->ViewValue === null) { // Lookup from database
                    $filterWrk = "[ABORTUS_ID]" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->ABORTUS_ID->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->ABORTUS_ID->Lookup->renderViewRow($rswrk[0]);
                        $this->ABORTUS_ID->ViewValue = $this->ABORTUS_ID->displayValue($arwrk);
                    } else {
                        $this->ABORTUS_ID->ViewValue = $this->ABORTUS_ID->CurrentValue;
                    }
                }
            } else {
                $this->ABORTUS_ID->ViewValue = null;
            }
            $this->ABORTUS_ID->ViewCustomAttributes = "";

            // ABORTION_DATE
            $this->ABORTION_DATE->ViewValue = $this->ABORTION_DATE->CurrentValue;
            $this->ABORTION_DATE->ViewValue = FormatDateTime($this->ABORTION_DATE->ViewValue, 0);
            $this->ABORTION_DATE->ViewCustomAttributes = "";

            // BIRTH_CAT
            $this->BIRTH_CAT->ViewValue = $this->BIRTH_CAT->CurrentValue;
            $this->BIRTH_CAT->ViewCustomAttributes = "";

            // BIRTH_CON
            $curVal = trim(strval($this->BIRTH_CON->CurrentValue));
            if ($curVal != "") {
                $this->BIRTH_CON->ViewValue = $this->BIRTH_CON->lookupCacheOption($curVal);
                if ($this->BIRTH_CON->ViewValue === null) { // Lookup from database
                    $filterWrk = "[BIRTH_CON]" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->BIRTH_CON->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->BIRTH_CON->Lookup->renderViewRow($rswrk[0]);
                        $this->BIRTH_CON->ViewValue = $this->BIRTH_CON->displayValue($arwrk);
                    } else {
                        $this->BIRTH_CON->ViewValue = $this->BIRTH_CON->CurrentValue;
                    }
                }
            } else {
                $this->BIRTH_CON->ViewValue = null;
            }
            $this->BIRTH_CON->ViewCustomAttributes = "";

            // BIRTH_RISK
            $this->BIRTH_RISK->ViewValue = $this->BIRTH_RISK->CurrentValue;
            $this->BIRTH_RISK->ViewValue = FormatNumber($this->BIRTH_RISK->ViewValue, 0, -2, -2, -2);
            $this->BIRTH_RISK->ViewCustomAttributes = "";

            // RISK_TYPE
            $this->RISK_TYPE->ViewValue = $this->RISK_TYPE->CurrentValue;
            $this->RISK_TYPE->ViewValue = FormatNumber($this->RISK_TYPE->ViewValue, 0, -2, -2, -2);
            $this->RISK_TYPE->ViewCustomAttributes = "";

            // FOLLOW_UP
            $curVal = trim(strval($this->FOLLOW_UP->CurrentValue));
            if ($curVal != "") {
                $this->FOLLOW_UP->ViewValue = $this->FOLLOW_UP->lookupCacheOption($curVal);
                if ($this->FOLLOW_UP->ViewValue === null) { // Lookup from database
                    $filterWrk = "[FOLLOW_UP]" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->FOLLOW_UP->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->FOLLOW_UP->Lookup->renderViewRow($rswrk[0]);
                        $this->FOLLOW_UP->ViewValue = $this->FOLLOW_UP->displayValue($arwrk);
                    } else {
                        $this->FOLLOW_UP->ViewValue = $this->FOLLOW_UP->CurrentValue;
                    }
                }
            } else {
                $this->FOLLOW_UP->ViewValue = null;
            }
            $this->FOLLOW_UP->ViewCustomAttributes = "";

            // DIRUJUK_OLEH
            if (strval($this->DIRUJUK_OLEH->CurrentValue) != "") {
                $this->DIRUJUK_OLEH->ViewValue = $this->DIRUJUK_OLEH->optionCaption($this->DIRUJUK_OLEH->CurrentValue);
            } else {
                $this->DIRUJUK_OLEH->ViewValue = null;
            }
            $this->DIRUJUK_OLEH->ViewCustomAttributes = "";

            // INSPECTION_DATE
            $this->INSPECTION_DATE->ViewValue = $this->INSPECTION_DATE->CurrentValue;
            $this->INSPECTION_DATE->ViewValue = FormatDateTime($this->INSPECTION_DATE->ViewValue, 11);
            $this->INSPECTION_DATE->ViewCustomAttributes = "";

            // PORSIO
            $this->PORSIO->ViewValue = $this->PORSIO->CurrentValue;
            $this->PORSIO->ViewCustomAttributes = "";

            // PEMBUKAAN
            $this->PEMBUKAAN->ViewValue = $this->PEMBUKAAN->CurrentValue;
            $this->PEMBUKAAN->ViewCustomAttributes = "";

            // KETUBAN
            $this->KETUBAN->ViewValue = $this->KETUBAN->CurrentValue;
            $this->KETUBAN->ViewCustomAttributes = "";

            // PRESENTASI
            $this->PRESENTASI->ViewValue = $this->PRESENTASI->CurrentValue;
            $this->PRESENTASI->ViewCustomAttributes = "";

            // POSISI
            $this->POSISI->ViewValue = $this->POSISI->CurrentValue;
            $this->POSISI->ViewCustomAttributes = "";

            // PENURUNAN
            $this->PENURUNAN->ViewValue = $this->PENURUNAN->CurrentValue;
            $this->PENURUNAN->ViewCustomAttributes = "";

            // HEART_ID
            $this->HEART_ID->ViewValue = $this->HEART_ID->CurrentValue;
            $this->HEART_ID->ViewValue = FormatNumber($this->HEART_ID->ViewValue, 0, -2, -2, -2);
            $this->HEART_ID->ViewCustomAttributes = "";

            // JANIN_ID
            $this->JANIN_ID->ViewValue = $this->JANIN_ID->CurrentValue;
            $this->JANIN_ID->ViewValue = FormatNumber($this->JANIN_ID->ViewValue, 0, -2, -2, -2);
            $this->JANIN_ID->ViewCustomAttributes = "";

            // FREK_DJJ
            $this->FREK_DJJ->ViewValue = $this->FREK_DJJ->CurrentValue;
            $this->FREK_DJJ->ViewValue = FormatNumber($this->FREK_DJJ->ViewValue, 2, -2, -2, -2);
            $this->FREK_DJJ->ViewCustomAttributes = "";

            // PLACENTA
            $this->PLACENTA->ViewValue = $this->PLACENTA->CurrentValue;
            $this->PLACENTA->ViewCustomAttributes = "";

            // LOCHIA
            $this->LOCHIA->ViewValue = $this->LOCHIA->CurrentValue;
            $this->LOCHIA->ViewCustomAttributes = "";

            // BAB_TYPE
            $this->BAB_TYPE->ViewValue = $this->BAB_TYPE->CurrentValue;
            $this->BAB_TYPE->ViewValue = FormatNumber($this->BAB_TYPE->ViewValue, 0, -2, -2, -2);
            $this->BAB_TYPE->ViewCustomAttributes = "";

            // BAB_BAB_TYPE
            $this->BAB_BAB_TYPE->ViewValue = $this->BAB_BAB_TYPE->CurrentValue;
            $this->BAB_BAB_TYPE->ViewValue = FormatNumber($this->BAB_BAB_TYPE->ViewValue, 0, -2, -2, -2);
            $this->BAB_BAB_TYPE->ViewCustomAttributes = "";

            // RAHIM_ID
            $curVal = trim(strval($this->RAHIM_ID->CurrentValue));
            if ($curVal != "") {
                $this->RAHIM_ID->ViewValue = $this->RAHIM_ID->lookupCacheOption($curVal);
                if ($this->RAHIM_ID->ViewValue === null) { // Lookup from database
                    $filterWrk = "[RAHIM_ID]" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->RAHIM_ID->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->RAHIM_ID->Lookup->renderViewRow($rswrk[0]);
                        $this->RAHIM_ID->ViewValue = $this->RAHIM_ID->displayValue($arwrk);
                    } else {
                        $this->RAHIM_ID->ViewValue = $this->RAHIM_ID->CurrentValue;
                    }
                }
            } else {
                $this->RAHIM_ID->ViewValue = null;
            }
            $this->RAHIM_ID->ViewCustomAttributes = "";

            // BIR_RAHIM_ID
            $this->BIR_RAHIM_ID->ViewValue = $this->BIR_RAHIM_ID->CurrentValue;
            $this->BIR_RAHIM_ID->ViewCustomAttributes = "";

            // VISIT_ID
            $this->VISIT_ID->ViewValue = $this->VISIT_ID->CurrentValue;
            $this->VISIT_ID->ViewCustomAttributes = "";

            // BLOODING
            if (strval($this->BLOODING->CurrentValue) != "") {
                $this->BLOODING->ViewValue = $this->BLOODING->optionCaption($this->BLOODING->CurrentValue);
            } else {
                $this->BLOODING->ViewValue = null;
            }
            $this->BLOODING->ViewCustomAttributes = "";

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

            // MODIFIED_FROM
            $this->MODIFIED_FROM->ViewValue = $this->MODIFIED_FROM->CurrentValue;
            $this->MODIFIED_FROM->ViewCustomAttributes = "";

            // RAHIM_SALIN
            $this->RAHIM_SALIN->ViewValue = $this->RAHIM_SALIN->CurrentValue;
            $this->RAHIM_SALIN->ViewCustomAttributes = "";

            // RAHIM_NIFAS
            $this->RAHIM_NIFAS->ViewValue = $this->RAHIM_NIFAS->CurrentValue;
            $this->RAHIM_NIFAS->ViewCustomAttributes = "";

            // BAK_TYPE
            $this->BAK_TYPE->ViewValue = $this->BAK_TYPE->CurrentValue;
            $this->BAK_TYPE->ViewValue = FormatNumber($this->BAK_TYPE->ViewValue, 0, -2, -2, -2);
            $this->BAK_TYPE->ViewCustomAttributes = "";

            // THEID
            $this->THEID->ViewValue = $this->THEID->CurrentValue;
            $this->THEID->ViewCustomAttributes = "";

            // STATUS_PASIEN_ID
            $this->STATUS_PASIEN_ID->ViewValue = $this->STATUS_PASIEN_ID->CurrentValue;
            $this->STATUS_PASIEN_ID->ViewValue = FormatNumber($this->STATUS_PASIEN_ID->ViewValue, 0, -2, -2, -2);
            $this->STATUS_PASIEN_ID->ViewCustomAttributes = "";

            // ISRJ
            $this->ISRJ->ViewValue = $this->ISRJ->CurrentValue;
            $this->ISRJ->ViewCustomAttributes = "";

            // AGEYEAR
            $this->AGEYEAR->ViewValue = $this->AGEYEAR->CurrentValue;
            $this->AGEYEAR->ViewValue = FormatNumber($this->AGEYEAR->ViewValue, 0, -2, -2, -2);
            $this->AGEYEAR->ViewCustomAttributes = "";

            // AGEMONTH
            $this->AGEMONTH->ViewValue = $this->AGEMONTH->CurrentValue;
            $this->AGEMONTH->ViewValue = FormatNumber($this->AGEMONTH->ViewValue, 0, -2, -2, -2);
            $this->AGEMONTH->ViewCustomAttributes = "";

            // AGEDAY
            $this->AGEDAY->ViewValue = $this->AGEDAY->CurrentValue;
            $this->AGEDAY->ViewValue = FormatNumber($this->AGEDAY->ViewValue, 0, -2, -2, -2);
            $this->AGEDAY->ViewCustomAttributes = "";

            // CLASS_ROOM_ID
            $this->CLASS_ROOM_ID->ViewValue = $this->CLASS_ROOM_ID->CurrentValue;
            $this->CLASS_ROOM_ID->ViewCustomAttributes = "";

            // BED_ID
            $this->BED_ID->ViewValue = $this->BED_ID->CurrentValue;
            $this->BED_ID->ViewValue = FormatNumber($this->BED_ID->ViewValue, 0, -2, -2, -2);
            $this->BED_ID->ViewCustomAttributes = "";

            // KELUAR_ID
            $this->KELUAR_ID->ViewValue = $this->KELUAR_ID->CurrentValue;
            $this->KELUAR_ID->ViewValue = FormatNumber($this->KELUAR_ID->ViewValue, 0, -2, -2, -2);
            $this->KELUAR_ID->ViewCustomAttributes = "";

            // DOCTOR
            $this->DOCTOR->ViewValue = $this->DOCTOR->CurrentValue;
            $this->DOCTOR->ViewCustomAttributes = "";

            // NB_OBSTETRI
            $this->NB_OBSTETRI->ViewValue = $this->NB_OBSTETRI->CurrentValue;
            $this->NB_OBSTETRI->ViewValue = FormatNumber($this->NB_OBSTETRI->ViewValue, 0, -2, -2, -2);
            $this->NB_OBSTETRI->ViewCustomAttributes = "";

            // OBSTETRI_DIE
            $this->OBSTETRI_DIE->ViewValue = $this->OBSTETRI_DIE->CurrentValue;
            $this->OBSTETRI_DIE->ViewValue = FormatNumber($this->OBSTETRI_DIE->ViewValue, 0, -2, -2, -2);
            $this->OBSTETRI_DIE->ViewCustomAttributes = "";

            // KAL_ID
            $this->KAL_ID->ViewValue = $this->KAL_ID->CurrentValue;
            $this->KAL_ID->ViewCustomAttributes = "";

            // DIAGNOSA_ID2
            $this->DIAGNOSA_ID2->ViewValue = $this->DIAGNOSA_ID2->CurrentValue;
            $this->DIAGNOSA_ID2->ViewCustomAttributes = "";

            // APGAR_ID
            $this->APGAR_ID->ViewValue = $this->APGAR_ID->CurrentValue;
            $this->APGAR_ID->ViewCustomAttributes = "";

            // BIRTH_LAST_ID
            $this->BIRTH_LAST_ID->ViewValue = $this->BIRTH_LAST_ID->CurrentValue;
            $this->BIRTH_LAST_ID->ViewCustomAttributes = "";

            // ID
            $this->ID->ViewValue = $this->ID->CurrentValue;
            $this->ID->ViewCustomAttributes = "";

            // NO_REGISTRATION
            $this->NO_REGISTRATION->LinkCustomAttributes = "";
            $this->NO_REGISTRATION->HrefValue = "";
            $this->NO_REGISTRATION->TooltipValue = "";

            // THENAME
            $this->THENAME->LinkCustomAttributes = "";
            $this->THENAME->HrefValue = "";
            $this->THENAME->TooltipValue = "";

            // THEADDRESS
            $this->THEADDRESS->LinkCustomAttributes = "";
            $this->THEADDRESS->HrefValue = "";
            $this->THEADDRESS->TooltipValue = "";

            // GENDER
            $this->GENDER->LinkCustomAttributes = "";
            $this->GENDER->HrefValue = "";
            $this->GENDER->TooltipValue = "";

            // CLINIC_ID
            $this->CLINIC_ID->LinkCustomAttributes = "";
            $this->CLINIC_ID->HrefValue = "";
            $this->CLINIC_ID->TooltipValue = "";

            // EMPLOYEE_ID
            $this->EMPLOYEE_ID->LinkCustomAttributes = "";
            $this->EMPLOYEE_ID->HrefValue = "";
            $this->EMPLOYEE_ID->TooltipValue = "";

            // BIRTH_NB
            $this->BIRTH_NB->LinkCustomAttributes = "";
            $this->BIRTH_NB->HrefValue = "";
            $this->BIRTH_NB->TooltipValue = "";

            // BIRTH_DURATION
            $this->BIRTH_DURATION->LinkCustomAttributes = "";
            $this->BIRTH_DURATION->HrefValue = "";
            $this->BIRTH_DURATION->TooltipValue = "";

            // BIRTH_PLACE
            $this->BIRTH_PLACE->LinkCustomAttributes = "";
            $this->BIRTH_PLACE->HrefValue = "";
            $this->BIRTH_PLACE->TooltipValue = "";

            // ANTE_NATAL
            $this->ANTE_NATAL->LinkCustomAttributes = "";
            $this->ANTE_NATAL->HrefValue = "";
            $this->ANTE_NATAL->TooltipValue = "";

            // BIRTH_WAY
            $this->BIRTH_WAY->LinkCustomAttributes = "";
            $this->BIRTH_WAY->HrefValue = "";
            $this->BIRTH_WAY->TooltipValue = "";

            // BIRTH_BY
            $this->BIRTH_BY->LinkCustomAttributes = "";
            $this->BIRTH_BY->HrefValue = "";
            $this->BIRTH_BY->TooltipValue = "";

            // BIRTH_DATE
            $this->BIRTH_DATE->LinkCustomAttributes = "";
            $this->BIRTH_DATE->HrefValue = "";
            $this->BIRTH_DATE->TooltipValue = "";

            // GESTASI
            $this->GESTASI->LinkCustomAttributes = "";
            $this->GESTASI->HrefValue = "";
            $this->GESTASI->TooltipValue = "";

            // PARITY
            $this->PARITY->LinkCustomAttributes = "";
            $this->PARITY->HrefValue = "";
            $this->PARITY->TooltipValue = "";

            // NB_BABY
            $this->NB_BABY->LinkCustomAttributes = "";
            $this->NB_BABY->HrefValue = "";
            $this->NB_BABY->TooltipValue = "";

            // BABY_DIE
            $this->BABY_DIE->LinkCustomAttributes = "";
            $this->BABY_DIE->HrefValue = "";
            $this->BABY_DIE->TooltipValue = "";

            // ABORTUS_KE
            $this->ABORTUS_KE->LinkCustomAttributes = "";
            $this->ABORTUS_KE->HrefValue = "";
            $this->ABORTUS_KE->TooltipValue = "";

            // ABORTUS_ID
            $this->ABORTUS_ID->LinkCustomAttributes = "";
            $this->ABORTUS_ID->HrefValue = "";
            $this->ABORTUS_ID->TooltipValue = "";

            // ABORTION_DATE
            $this->ABORTION_DATE->LinkCustomAttributes = "";
            $this->ABORTION_DATE->HrefValue = "";
            $this->ABORTION_DATE->TooltipValue = "";

            // BIRTH_CAT
            $this->BIRTH_CAT->LinkCustomAttributes = "";
            $this->BIRTH_CAT->HrefValue = "";
            $this->BIRTH_CAT->TooltipValue = "";

            // BIRTH_CON
            $this->BIRTH_CON->LinkCustomAttributes = "";
            $this->BIRTH_CON->HrefValue = "";
            $this->BIRTH_CON->TooltipValue = "";

            // BIRTH_RISK
            $this->BIRTH_RISK->LinkCustomAttributes = "";
            $this->BIRTH_RISK->HrefValue = "";
            $this->BIRTH_RISK->TooltipValue = "";

            // RISK_TYPE
            $this->RISK_TYPE->LinkCustomAttributes = "";
            $this->RISK_TYPE->HrefValue = "";
            $this->RISK_TYPE->TooltipValue = "";

            // FOLLOW_UP
            $this->FOLLOW_UP->LinkCustomAttributes = "";
            $this->FOLLOW_UP->HrefValue = "";
            $this->FOLLOW_UP->TooltipValue = "";

            // DIRUJUK_OLEH
            $this->DIRUJUK_OLEH->LinkCustomAttributes = "";
            $this->DIRUJUK_OLEH->HrefValue = "";
            $this->DIRUJUK_OLEH->TooltipValue = "";

            // INSPECTION_DATE
            $this->INSPECTION_DATE->LinkCustomAttributes = "";
            $this->INSPECTION_DATE->HrefValue = "";
            $this->INSPECTION_DATE->TooltipValue = "";

            // PORSIO
            $this->PORSIO->LinkCustomAttributes = "";
            $this->PORSIO->HrefValue = "";
            $this->PORSIO->TooltipValue = "";

            // PEMBUKAAN
            $this->PEMBUKAAN->LinkCustomAttributes = "";
            $this->PEMBUKAAN->HrefValue = "";
            $this->PEMBUKAAN->TooltipValue = "";

            // KETUBAN
            $this->KETUBAN->LinkCustomAttributes = "";
            $this->KETUBAN->HrefValue = "";
            $this->KETUBAN->TooltipValue = "";

            // PRESENTASI
            $this->PRESENTASI->LinkCustomAttributes = "";
            $this->PRESENTASI->HrefValue = "";
            $this->PRESENTASI->TooltipValue = "";

            // POSISI
            $this->POSISI->LinkCustomAttributes = "";
            $this->POSISI->HrefValue = "";
            $this->POSISI->TooltipValue = "";

            // PENURUNAN
            $this->PENURUNAN->LinkCustomAttributes = "";
            $this->PENURUNAN->HrefValue = "";
            $this->PENURUNAN->TooltipValue = "";

            // PLACENTA
            $this->PLACENTA->LinkCustomAttributes = "";
            $this->PLACENTA->HrefValue = "";
            $this->PLACENTA->TooltipValue = "";

            // RAHIM_ID
            $this->RAHIM_ID->LinkCustomAttributes = "";
            $this->RAHIM_ID->HrefValue = "";
            $this->RAHIM_ID->TooltipValue = "";

            // BLOODING
            $this->BLOODING->LinkCustomAttributes = "";
            $this->BLOODING->HrefValue = "";
            $this->BLOODING->TooltipValue = "";

            // DESCRIPTION
            $this->DESCRIPTION->LinkCustomAttributes = "";
            $this->DESCRIPTION->HrefValue = "";
            $this->DESCRIPTION->TooltipValue = "";

            // ID
            $this->ID->LinkCustomAttributes = "";
            $this->ID->HrefValue = "";
            $this->ID->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_EDIT) {
            // NO_REGISTRATION
            $this->NO_REGISTRATION->EditAttrs["class"] = "form-control";
            $this->NO_REGISTRATION->EditCustomAttributes = "";
            $this->NO_REGISTRATION->EditValue = $this->NO_REGISTRATION->CurrentValue;
            $this->NO_REGISTRATION->ViewCustomAttributes = "";

            // THENAME
            $this->THENAME->EditAttrs["class"] = "form-control";
            $this->THENAME->EditCustomAttributes = "";
            $this->THENAME->EditValue = $this->THENAME->CurrentValue;
            $this->THENAME->ViewCustomAttributes = "";

            // THEADDRESS
            $this->THEADDRESS->EditAttrs["class"] = "form-control";
            $this->THEADDRESS->EditCustomAttributes = "";
            $this->THEADDRESS->EditValue = $this->THEADDRESS->CurrentValue;
            $this->THEADDRESS->ViewCustomAttributes = "";

            // GENDER
            $this->GENDER->EditAttrs["class"] = "form-control";
            $this->GENDER->EditCustomAttributes = "";
            $curVal = trim(strval($this->GENDER->CurrentValue));
            if ($curVal != "") {
                $this->GENDER->EditValue = $this->GENDER->lookupCacheOption($curVal);
                if ($this->GENDER->EditValue === null) { // Lookup from database
                    $filterWrk = "[GENDER]" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->GENDER->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->GENDER->Lookup->renderViewRow($rswrk[0]);
                        $this->GENDER->EditValue = $this->GENDER->displayValue($arwrk);
                    } else {
                        $this->GENDER->EditValue = $this->GENDER->CurrentValue;
                    }
                }
            } else {
                $this->GENDER->EditValue = null;
            }
            $this->GENDER->ViewCustomAttributes = "";

            // CLINIC_ID
            $this->CLINIC_ID->EditAttrs["class"] = "form-control";
            $this->CLINIC_ID->EditCustomAttributes = "";
            $curVal = trim(strval($this->CLINIC_ID->CurrentValue));
            if ($curVal != "") {
                $this->CLINIC_ID->EditValue = $this->CLINIC_ID->lookupCacheOption($curVal);
                if ($this->CLINIC_ID->EditValue === null) { // Lookup from database
                    $filterWrk = "[CLINIC_ID]" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->CLINIC_ID->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->CLINIC_ID->Lookup->renderViewRow($rswrk[0]);
                        $this->CLINIC_ID->EditValue = $this->CLINIC_ID->displayValue($arwrk);
                    } else {
                        $this->CLINIC_ID->EditValue = $this->CLINIC_ID->CurrentValue;
                    }
                }
            } else {
                $this->CLINIC_ID->EditValue = null;
            }
            $this->CLINIC_ID->ViewCustomAttributes = "";

            // EMPLOYEE_ID
            $this->EMPLOYEE_ID->EditAttrs["class"] = "form-control";
            $this->EMPLOYEE_ID->EditCustomAttributes = "";
            $curVal = trim(strval($this->EMPLOYEE_ID->CurrentValue));
            if ($curVal != "") {
                $this->EMPLOYEE_ID->EditValue = $this->EMPLOYEE_ID->lookupCacheOption($curVal);
                if ($this->EMPLOYEE_ID->EditValue === null) { // Lookup from database
                    $filterWrk = "[EMPLOYEE_ID]" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $lookupFilter = function() {
                        return "[OBJECT_CATEGORY_ID]=20 AND [NONACTIVE]=0";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    $sqlWrk = $this->EMPLOYEE_ID->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->EMPLOYEE_ID->Lookup->renderViewRow($rswrk[0]);
                        $this->EMPLOYEE_ID->EditValue = $this->EMPLOYEE_ID->displayValue($arwrk);
                    } else {
                        $this->EMPLOYEE_ID->EditValue = $this->EMPLOYEE_ID->CurrentValue;
                    }
                }
            } else {
                $this->EMPLOYEE_ID->EditValue = null;
            }
            $this->EMPLOYEE_ID->ViewCustomAttributes = "";

            // BIRTH_NB
            $this->BIRTH_NB->EditAttrs["class"] = "form-control";
            $this->BIRTH_NB->EditCustomAttributes = "";
            $curVal = trim(strval($this->BIRTH_NB->CurrentValue));
            if ($curVal != "") {
                $this->BIRTH_NB->ViewValue = $this->BIRTH_NB->lookupCacheOption($curVal);
            } else {
                $this->BIRTH_NB->ViewValue = $this->BIRTH_NB->Lookup !== null && is_array($this->BIRTH_NB->Lookup->Options) ? $curVal : null;
            }
            if ($this->BIRTH_NB->ViewValue !== null) { // Load from cache
                $this->BIRTH_NB->EditValue = array_values($this->BIRTH_NB->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "[BIRTH_NB]" . SearchString("=", $this->BIRTH_NB->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->BIRTH_NB->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->BIRTH_NB->EditValue = $arwrk;
            }
            $this->BIRTH_NB->PlaceHolder = RemoveHtml($this->BIRTH_NB->caption());

            // BIRTH_DURATION
            $this->BIRTH_DURATION->EditAttrs["class"] = "form-control";
            $this->BIRTH_DURATION->EditCustomAttributes = "";
            $this->BIRTH_DURATION->EditValue = HtmlEncode($this->BIRTH_DURATION->CurrentValue);
            $this->BIRTH_DURATION->PlaceHolder = RemoveHtml($this->BIRTH_DURATION->caption());

            // BIRTH_PLACE
            $this->BIRTH_PLACE->EditAttrs["class"] = "form-control";
            $this->BIRTH_PLACE->EditCustomAttributes = "";
            $curVal = trim(strval($this->BIRTH_PLACE->CurrentValue));
            if ($curVal != "") {
                $this->BIRTH_PLACE->ViewValue = $this->BIRTH_PLACE->lookupCacheOption($curVal);
            } else {
                $this->BIRTH_PLACE->ViewValue = $this->BIRTH_PLACE->Lookup !== null && is_array($this->BIRTH_PLACE->Lookup->Options) ? $curVal : null;
            }
            if ($this->BIRTH_PLACE->ViewValue !== null) { // Load from cache
                $this->BIRTH_PLACE->EditValue = array_values($this->BIRTH_PLACE->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "[BIRTH_PLACE]" . SearchString("=", $this->BIRTH_PLACE->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->BIRTH_PLACE->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->BIRTH_PLACE->EditValue = $arwrk;
            }
            $this->BIRTH_PLACE->PlaceHolder = RemoveHtml($this->BIRTH_PLACE->caption());

            // ANTE_NATAL
            $this->ANTE_NATAL->EditAttrs["class"] = "form-control";
            $this->ANTE_NATAL->EditCustomAttributes = "";
            $curVal = trim(strval($this->ANTE_NATAL->CurrentValue));
            if ($curVal != "") {
                $this->ANTE_NATAL->ViewValue = $this->ANTE_NATAL->lookupCacheOption($curVal);
            } else {
                $this->ANTE_NATAL->ViewValue = $this->ANTE_NATAL->Lookup !== null && is_array($this->ANTE_NATAL->Lookup->Options) ? $curVal : null;
            }
            if ($this->ANTE_NATAL->ViewValue !== null) { // Load from cache
                $this->ANTE_NATAL->EditValue = array_values($this->ANTE_NATAL->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "[ANTE_NATAL]" . SearchString("=", $this->ANTE_NATAL->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->ANTE_NATAL->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->ANTE_NATAL->EditValue = $arwrk;
            }
            $this->ANTE_NATAL->PlaceHolder = RemoveHtml($this->ANTE_NATAL->caption());

            // BIRTH_WAY
            $this->BIRTH_WAY->EditAttrs["class"] = "form-control";
            $this->BIRTH_WAY->EditCustomAttributes = "";
            $curVal = trim(strval($this->BIRTH_WAY->CurrentValue));
            if ($curVal != "") {
                $this->BIRTH_WAY->ViewValue = $this->BIRTH_WAY->lookupCacheOption($curVal);
            } else {
                $this->BIRTH_WAY->ViewValue = $this->BIRTH_WAY->Lookup !== null && is_array($this->BIRTH_WAY->Lookup->Options) ? $curVal : null;
            }
            if ($this->BIRTH_WAY->ViewValue !== null) { // Load from cache
                $this->BIRTH_WAY->EditValue = array_values($this->BIRTH_WAY->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "[BIRTHWAY]" . SearchString("=", $this->BIRTH_WAY->CurrentValue, DATATYPE_STRING, "");
                }
                $sqlWrk = $this->BIRTH_WAY->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->BIRTH_WAY->EditValue = $arwrk;
            }
            $this->BIRTH_WAY->PlaceHolder = RemoveHtml($this->BIRTH_WAY->caption());

            // BIRTH_BY
            $this->BIRTH_BY->EditAttrs["class"] = "form-control";
            $this->BIRTH_BY->EditCustomAttributes = "";
            $curVal = trim(strval($this->BIRTH_BY->CurrentValue));
            if ($curVal != "") {
                $this->BIRTH_BY->ViewValue = $this->BIRTH_BY->lookupCacheOption($curVal);
            } else {
                $this->BIRTH_BY->ViewValue = $this->BIRTH_BY->Lookup !== null && is_array($this->BIRTH_BY->Lookup->Options) ? $curVal : null;
            }
            if ($this->BIRTH_BY->ViewValue !== null) { // Load from cache
                $this->BIRTH_BY->EditValue = array_values($this->BIRTH_BY->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "[BIRTH_BY]" . SearchString("=", $this->BIRTH_BY->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->BIRTH_BY->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->BIRTH_BY->EditValue = $arwrk;
            }
            $this->BIRTH_BY->PlaceHolder = RemoveHtml($this->BIRTH_BY->caption());

            // BIRTH_DATE
            $this->BIRTH_DATE->EditAttrs["class"] = "form-control";
            $this->BIRTH_DATE->EditCustomAttributes = "";
            $this->BIRTH_DATE->EditValue = HtmlEncode(FormatDateTime($this->BIRTH_DATE->CurrentValue, 7));
            $this->BIRTH_DATE->PlaceHolder = RemoveHtml($this->BIRTH_DATE->caption());

            // GESTASI
            $this->GESTASI->EditAttrs["class"] = "form-control";
            $this->GESTASI->EditCustomAttributes = "";
            $this->GESTASI->EditValue = HtmlEncode($this->GESTASI->CurrentValue);
            $this->GESTASI->PlaceHolder = RemoveHtml($this->GESTASI->caption());

            // PARITY
            $this->PARITY->EditAttrs["class"] = "form-control";
            $this->PARITY->EditCustomAttributes = "";
            $this->PARITY->EditValue = HtmlEncode($this->PARITY->CurrentValue);
            $this->PARITY->PlaceHolder = RemoveHtml($this->PARITY->caption());

            // NB_BABY
            $this->NB_BABY->EditAttrs["class"] = "form-control";
            $this->NB_BABY->EditCustomAttributes = "";
            $this->NB_BABY->EditValue = HtmlEncode($this->NB_BABY->CurrentValue);
            $this->NB_BABY->PlaceHolder = RemoveHtml($this->NB_BABY->caption());

            // BABY_DIE
            $this->BABY_DIE->EditAttrs["class"] = "form-control";
            $this->BABY_DIE->EditCustomAttributes = "";
            $this->BABY_DIE->EditValue = HtmlEncode($this->BABY_DIE->CurrentValue);
            $this->BABY_DIE->PlaceHolder = RemoveHtml($this->BABY_DIE->caption());

            // ABORTUS_KE
            $this->ABORTUS_KE->EditAttrs["class"] = "form-control";
            $this->ABORTUS_KE->EditCustomAttributes = "";
            $this->ABORTUS_KE->EditValue = HtmlEncode($this->ABORTUS_KE->CurrentValue);
            $this->ABORTUS_KE->PlaceHolder = RemoveHtml($this->ABORTUS_KE->caption());

            // ABORTUS_ID
            $this->ABORTUS_ID->EditAttrs["class"] = "form-control";
            $this->ABORTUS_ID->EditCustomAttributes = "";
            $curVal = trim(strval($this->ABORTUS_ID->CurrentValue));
            if ($curVal != "") {
                $this->ABORTUS_ID->ViewValue = $this->ABORTUS_ID->lookupCacheOption($curVal);
            } else {
                $this->ABORTUS_ID->ViewValue = $this->ABORTUS_ID->Lookup !== null && is_array($this->ABORTUS_ID->Lookup->Options) ? $curVal : null;
            }
            if ($this->ABORTUS_ID->ViewValue !== null) { // Load from cache
                $this->ABORTUS_ID->EditValue = array_values($this->ABORTUS_ID->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "[ABORTUS_ID]" . SearchString("=", $this->ABORTUS_ID->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->ABORTUS_ID->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                foreach ($arwrk as &$row)
                    $row = $this->ABORTUS_ID->Lookup->renderViewRow($row);
                $this->ABORTUS_ID->EditValue = $arwrk;
            }
            $this->ABORTUS_ID->PlaceHolder = RemoveHtml($this->ABORTUS_ID->caption());

            // ABORTION_DATE
            $this->ABORTION_DATE->EditAttrs["class"] = "form-control";
            $this->ABORTION_DATE->EditCustomAttributes = "";
            $this->ABORTION_DATE->EditValue = HtmlEncode(FormatDateTime($this->ABORTION_DATE->CurrentValue, 8));
            $this->ABORTION_DATE->PlaceHolder = RemoveHtml($this->ABORTION_DATE->caption());

            // BIRTH_CAT
            $this->BIRTH_CAT->EditAttrs["class"] = "form-control";
            $this->BIRTH_CAT->EditCustomAttributes = "";
            if (!$this->BIRTH_CAT->Raw) {
                $this->BIRTH_CAT->CurrentValue = HtmlDecode($this->BIRTH_CAT->CurrentValue);
            }
            $this->BIRTH_CAT->EditValue = HtmlEncode($this->BIRTH_CAT->CurrentValue);
            $this->BIRTH_CAT->PlaceHolder = RemoveHtml($this->BIRTH_CAT->caption());

            // BIRTH_CON
            $this->BIRTH_CON->EditAttrs["class"] = "form-control";
            $this->BIRTH_CON->EditCustomAttributes = "";
            $curVal = trim(strval($this->BIRTH_CON->CurrentValue));
            if ($curVal != "") {
                $this->BIRTH_CON->ViewValue = $this->BIRTH_CON->lookupCacheOption($curVal);
            } else {
                $this->BIRTH_CON->ViewValue = $this->BIRTH_CON->Lookup !== null && is_array($this->BIRTH_CON->Lookup->Options) ? $curVal : null;
            }
            if ($this->BIRTH_CON->ViewValue !== null) { // Load from cache
                $this->BIRTH_CON->EditValue = array_values($this->BIRTH_CON->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "[BIRTH_CON]" . SearchString("=", $this->BIRTH_CON->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->BIRTH_CON->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->BIRTH_CON->EditValue = $arwrk;
            }
            $this->BIRTH_CON->PlaceHolder = RemoveHtml($this->BIRTH_CON->caption());

            // BIRTH_RISK
            $this->BIRTH_RISK->EditAttrs["class"] = "form-control";
            $this->BIRTH_RISK->EditCustomAttributes = "";
            $this->BIRTH_RISK->EditValue = HtmlEncode($this->BIRTH_RISK->CurrentValue);
            $this->BIRTH_RISK->PlaceHolder = RemoveHtml($this->BIRTH_RISK->caption());

            // RISK_TYPE
            $this->RISK_TYPE->EditAttrs["class"] = "form-control";
            $this->RISK_TYPE->EditCustomAttributes = "";
            $this->RISK_TYPE->EditValue = HtmlEncode($this->RISK_TYPE->CurrentValue);
            $this->RISK_TYPE->PlaceHolder = RemoveHtml($this->RISK_TYPE->caption());

            // FOLLOW_UP
            $this->FOLLOW_UP->EditAttrs["class"] = "form-control";
            $this->FOLLOW_UP->EditCustomAttributes = "";
            $curVal = trim(strval($this->FOLLOW_UP->CurrentValue));
            if ($curVal != "") {
                $this->FOLLOW_UP->ViewValue = $this->FOLLOW_UP->lookupCacheOption($curVal);
            } else {
                $this->FOLLOW_UP->ViewValue = $this->FOLLOW_UP->Lookup !== null && is_array($this->FOLLOW_UP->Lookup->Options) ? $curVal : null;
            }
            if ($this->FOLLOW_UP->ViewValue !== null) { // Load from cache
                $this->FOLLOW_UP->EditValue = array_values($this->FOLLOW_UP->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "[FOLLOW_UP]" . SearchString("=", $this->FOLLOW_UP->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->FOLLOW_UP->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->FOLLOW_UP->EditValue = $arwrk;
            }
            $this->FOLLOW_UP->PlaceHolder = RemoveHtml($this->FOLLOW_UP->caption());

            // DIRUJUK_OLEH
            $this->DIRUJUK_OLEH->EditAttrs["class"] = "form-control";
            $this->DIRUJUK_OLEH->EditCustomAttributes = "";
            $this->DIRUJUK_OLEH->EditValue = $this->DIRUJUK_OLEH->options(true);
            $this->DIRUJUK_OLEH->PlaceHolder = RemoveHtml($this->DIRUJUK_OLEH->caption());

            // INSPECTION_DATE
            $this->INSPECTION_DATE->EditAttrs["class"] = "form-control";
            $this->INSPECTION_DATE->EditCustomAttributes = "";
            $this->INSPECTION_DATE->EditValue = HtmlEncode(FormatDateTime($this->INSPECTION_DATE->CurrentValue, 11));
            $this->INSPECTION_DATE->PlaceHolder = RemoveHtml($this->INSPECTION_DATE->caption());

            // PORSIO
            $this->PORSIO->EditAttrs["class"] = "form-control";
            $this->PORSIO->EditCustomAttributes = "";
            if (!$this->PORSIO->Raw) {
                $this->PORSIO->CurrentValue = HtmlDecode($this->PORSIO->CurrentValue);
            }
            $this->PORSIO->EditValue = HtmlEncode($this->PORSIO->CurrentValue);
            $this->PORSIO->PlaceHolder = RemoveHtml($this->PORSIO->caption());

            // PEMBUKAAN
            $this->PEMBUKAAN->EditAttrs["class"] = "form-control";
            $this->PEMBUKAAN->EditCustomAttributes = "";
            if (!$this->PEMBUKAAN->Raw) {
                $this->PEMBUKAAN->CurrentValue = HtmlDecode($this->PEMBUKAAN->CurrentValue);
            }
            $this->PEMBUKAAN->EditValue = HtmlEncode($this->PEMBUKAAN->CurrentValue);
            $this->PEMBUKAAN->PlaceHolder = RemoveHtml($this->PEMBUKAAN->caption());

            // KETUBAN
            $this->KETUBAN->EditAttrs["class"] = "form-control";
            $this->KETUBAN->EditCustomAttributes = "";
            if (!$this->KETUBAN->Raw) {
                $this->KETUBAN->CurrentValue = HtmlDecode($this->KETUBAN->CurrentValue);
            }
            $this->KETUBAN->EditValue = HtmlEncode($this->KETUBAN->CurrentValue);
            $this->KETUBAN->PlaceHolder = RemoveHtml($this->KETUBAN->caption());

            // PRESENTASI
            $this->PRESENTASI->EditAttrs["class"] = "form-control";
            $this->PRESENTASI->EditCustomAttributes = "";
            if (!$this->PRESENTASI->Raw) {
                $this->PRESENTASI->CurrentValue = HtmlDecode($this->PRESENTASI->CurrentValue);
            }
            $this->PRESENTASI->EditValue = HtmlEncode($this->PRESENTASI->CurrentValue);
            $this->PRESENTASI->PlaceHolder = RemoveHtml($this->PRESENTASI->caption());

            // POSISI
            $this->POSISI->EditAttrs["class"] = "form-control";
            $this->POSISI->EditCustomAttributes = "";
            if (!$this->POSISI->Raw) {
                $this->POSISI->CurrentValue = HtmlDecode($this->POSISI->CurrentValue);
            }
            $this->POSISI->EditValue = HtmlEncode($this->POSISI->CurrentValue);
            $this->POSISI->PlaceHolder = RemoveHtml($this->POSISI->caption());

            // PENURUNAN
            $this->PENURUNAN->EditAttrs["class"] = "form-control";
            $this->PENURUNAN->EditCustomAttributes = "";
            if (!$this->PENURUNAN->Raw) {
                $this->PENURUNAN->CurrentValue = HtmlDecode($this->PENURUNAN->CurrentValue);
            }
            $this->PENURUNAN->EditValue = HtmlEncode($this->PENURUNAN->CurrentValue);
            $this->PENURUNAN->PlaceHolder = RemoveHtml($this->PENURUNAN->caption());

            // PLACENTA
            $this->PLACENTA->EditAttrs["class"] = "form-control";
            $this->PLACENTA->EditCustomAttributes = "";
            if (!$this->PLACENTA->Raw) {
                $this->PLACENTA->CurrentValue = HtmlDecode($this->PLACENTA->CurrentValue);
            }
            $this->PLACENTA->EditValue = HtmlEncode($this->PLACENTA->CurrentValue);
            $this->PLACENTA->PlaceHolder = RemoveHtml($this->PLACENTA->caption());

            // RAHIM_ID
            $this->RAHIM_ID->EditAttrs["class"] = "form-control";
            $this->RAHIM_ID->EditCustomAttributes = "";
            $curVal = trim(strval($this->RAHIM_ID->CurrentValue));
            if ($curVal != "") {
                $this->RAHIM_ID->ViewValue = $this->RAHIM_ID->lookupCacheOption($curVal);
            } else {
                $this->RAHIM_ID->ViewValue = $this->RAHIM_ID->Lookup !== null && is_array($this->RAHIM_ID->Lookup->Options) ? $curVal : null;
            }
            if ($this->RAHIM_ID->ViewValue !== null) { // Load from cache
                $this->RAHIM_ID->EditValue = array_values($this->RAHIM_ID->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "[RAHIM_ID]" . SearchString("=", $this->RAHIM_ID->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->RAHIM_ID->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->RAHIM_ID->EditValue = $arwrk;
            }
            $this->RAHIM_ID->PlaceHolder = RemoveHtml($this->RAHIM_ID->caption());

            // BLOODING
            $this->BLOODING->EditCustomAttributes = "";
            $this->BLOODING->EditValue = $this->BLOODING->options(false);
            $this->BLOODING->PlaceHolder = RemoveHtml($this->BLOODING->caption());

            // DESCRIPTION
            $this->DESCRIPTION->EditAttrs["class"] = "form-control";
            $this->DESCRIPTION->EditCustomAttributes = "";
            if (!$this->DESCRIPTION->Raw) {
                $this->DESCRIPTION->CurrentValue = HtmlDecode($this->DESCRIPTION->CurrentValue);
            }
            $this->DESCRIPTION->EditValue = HtmlEncode($this->DESCRIPTION->CurrentValue);
            $this->DESCRIPTION->PlaceHolder = RemoveHtml($this->DESCRIPTION->caption());

            // ID
            $this->ID->EditAttrs["class"] = "form-control";
            $this->ID->EditCustomAttributes = "";
            $this->ID->EditValue = $this->ID->CurrentValue;
            $this->ID->ViewCustomAttributes = "";

            // Edit refer script

            // NO_REGISTRATION
            $this->NO_REGISTRATION->LinkCustomAttributes = "";
            $this->NO_REGISTRATION->HrefValue = "";
            $this->NO_REGISTRATION->TooltipValue = "";

            // THENAME
            $this->THENAME->LinkCustomAttributes = "";
            $this->THENAME->HrefValue = "";
            $this->THENAME->TooltipValue = "";

            // THEADDRESS
            $this->THEADDRESS->LinkCustomAttributes = "";
            $this->THEADDRESS->HrefValue = "";
            $this->THEADDRESS->TooltipValue = "";

            // GENDER
            $this->GENDER->LinkCustomAttributes = "";
            $this->GENDER->HrefValue = "";
            $this->GENDER->TooltipValue = "";

            // CLINIC_ID
            $this->CLINIC_ID->LinkCustomAttributes = "";
            $this->CLINIC_ID->HrefValue = "";
            $this->CLINIC_ID->TooltipValue = "";

            // EMPLOYEE_ID
            $this->EMPLOYEE_ID->LinkCustomAttributes = "";
            $this->EMPLOYEE_ID->HrefValue = "";
            $this->EMPLOYEE_ID->TooltipValue = "";

            // BIRTH_NB
            $this->BIRTH_NB->LinkCustomAttributes = "";
            $this->BIRTH_NB->HrefValue = "";

            // BIRTH_DURATION
            $this->BIRTH_DURATION->LinkCustomAttributes = "";
            $this->BIRTH_DURATION->HrefValue = "";

            // BIRTH_PLACE
            $this->BIRTH_PLACE->LinkCustomAttributes = "";
            $this->BIRTH_PLACE->HrefValue = "";

            // ANTE_NATAL
            $this->ANTE_NATAL->LinkCustomAttributes = "";
            $this->ANTE_NATAL->HrefValue = "";

            // BIRTH_WAY
            $this->BIRTH_WAY->LinkCustomAttributes = "";
            $this->BIRTH_WAY->HrefValue = "";

            // BIRTH_BY
            $this->BIRTH_BY->LinkCustomAttributes = "";
            $this->BIRTH_BY->HrefValue = "";

            // BIRTH_DATE
            $this->BIRTH_DATE->LinkCustomAttributes = "";
            $this->BIRTH_DATE->HrefValue = "";

            // GESTASI
            $this->GESTASI->LinkCustomAttributes = "";
            $this->GESTASI->HrefValue = "";

            // PARITY
            $this->PARITY->LinkCustomAttributes = "";
            $this->PARITY->HrefValue = "";

            // NB_BABY
            $this->NB_BABY->LinkCustomAttributes = "";
            $this->NB_BABY->HrefValue = "";

            // BABY_DIE
            $this->BABY_DIE->LinkCustomAttributes = "";
            $this->BABY_DIE->HrefValue = "";

            // ABORTUS_KE
            $this->ABORTUS_KE->LinkCustomAttributes = "";
            $this->ABORTUS_KE->HrefValue = "";

            // ABORTUS_ID
            $this->ABORTUS_ID->LinkCustomAttributes = "";
            $this->ABORTUS_ID->HrefValue = "";

            // ABORTION_DATE
            $this->ABORTION_DATE->LinkCustomAttributes = "";
            $this->ABORTION_DATE->HrefValue = "";

            // BIRTH_CAT
            $this->BIRTH_CAT->LinkCustomAttributes = "";
            $this->BIRTH_CAT->HrefValue = "";

            // BIRTH_CON
            $this->BIRTH_CON->LinkCustomAttributes = "";
            $this->BIRTH_CON->HrefValue = "";

            // BIRTH_RISK
            $this->BIRTH_RISK->LinkCustomAttributes = "";
            $this->BIRTH_RISK->HrefValue = "";

            // RISK_TYPE
            $this->RISK_TYPE->LinkCustomAttributes = "";
            $this->RISK_TYPE->HrefValue = "";

            // FOLLOW_UP
            $this->FOLLOW_UP->LinkCustomAttributes = "";
            $this->FOLLOW_UP->HrefValue = "";

            // DIRUJUK_OLEH
            $this->DIRUJUK_OLEH->LinkCustomAttributes = "";
            $this->DIRUJUK_OLEH->HrefValue = "";

            // INSPECTION_DATE
            $this->INSPECTION_DATE->LinkCustomAttributes = "";
            $this->INSPECTION_DATE->HrefValue = "";

            // PORSIO
            $this->PORSIO->LinkCustomAttributes = "";
            $this->PORSIO->HrefValue = "";

            // PEMBUKAAN
            $this->PEMBUKAAN->LinkCustomAttributes = "";
            $this->PEMBUKAAN->HrefValue = "";

            // KETUBAN
            $this->KETUBAN->LinkCustomAttributes = "";
            $this->KETUBAN->HrefValue = "";

            // PRESENTASI
            $this->PRESENTASI->LinkCustomAttributes = "";
            $this->PRESENTASI->HrefValue = "";

            // POSISI
            $this->POSISI->LinkCustomAttributes = "";
            $this->POSISI->HrefValue = "";

            // PENURUNAN
            $this->PENURUNAN->LinkCustomAttributes = "";
            $this->PENURUNAN->HrefValue = "";

            // PLACENTA
            $this->PLACENTA->LinkCustomAttributes = "";
            $this->PLACENTA->HrefValue = "";

            // RAHIM_ID
            $this->RAHIM_ID->LinkCustomAttributes = "";
            $this->RAHIM_ID->HrefValue = "";

            // BLOODING
            $this->BLOODING->LinkCustomAttributes = "";
            $this->BLOODING->HrefValue = "";

            // DESCRIPTION
            $this->DESCRIPTION->LinkCustomAttributes = "";
            $this->DESCRIPTION->HrefValue = "";

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
        if ($this->NO_REGISTRATION->Required) {
            if (!$this->NO_REGISTRATION->IsDetailKey && EmptyValue($this->NO_REGISTRATION->FormValue)) {
                $this->NO_REGISTRATION->addErrorMessage(str_replace("%s", $this->NO_REGISTRATION->caption(), $this->NO_REGISTRATION->RequiredErrorMessage));
            }
        }
        if ($this->THENAME->Required) {
            if (!$this->THENAME->IsDetailKey && EmptyValue($this->THENAME->FormValue)) {
                $this->THENAME->addErrorMessage(str_replace("%s", $this->THENAME->caption(), $this->THENAME->RequiredErrorMessage));
            }
        }
        if ($this->THEADDRESS->Required) {
            if (!$this->THEADDRESS->IsDetailKey && EmptyValue($this->THEADDRESS->FormValue)) {
                $this->THEADDRESS->addErrorMessage(str_replace("%s", $this->THEADDRESS->caption(), $this->THEADDRESS->RequiredErrorMessage));
            }
        }
        if ($this->GENDER->Required) {
            if (!$this->GENDER->IsDetailKey && EmptyValue($this->GENDER->FormValue)) {
                $this->GENDER->addErrorMessage(str_replace("%s", $this->GENDER->caption(), $this->GENDER->RequiredErrorMessage));
            }
        }
        if ($this->CLINIC_ID->Required) {
            if (!$this->CLINIC_ID->IsDetailKey && EmptyValue($this->CLINIC_ID->FormValue)) {
                $this->CLINIC_ID->addErrorMessage(str_replace("%s", $this->CLINIC_ID->caption(), $this->CLINIC_ID->RequiredErrorMessage));
            }
        }
        if ($this->EMPLOYEE_ID->Required) {
            if (!$this->EMPLOYEE_ID->IsDetailKey && EmptyValue($this->EMPLOYEE_ID->FormValue)) {
                $this->EMPLOYEE_ID->addErrorMessage(str_replace("%s", $this->EMPLOYEE_ID->caption(), $this->EMPLOYEE_ID->RequiredErrorMessage));
            }
        }
        if ($this->BIRTH_NB->Required) {
            if (!$this->BIRTH_NB->IsDetailKey && EmptyValue($this->BIRTH_NB->FormValue)) {
                $this->BIRTH_NB->addErrorMessage(str_replace("%s", $this->BIRTH_NB->caption(), $this->BIRTH_NB->RequiredErrorMessage));
            }
        }
        if ($this->BIRTH_DURATION->Required) {
            if (!$this->BIRTH_DURATION->IsDetailKey && EmptyValue($this->BIRTH_DURATION->FormValue)) {
                $this->BIRTH_DURATION->addErrorMessage(str_replace("%s", $this->BIRTH_DURATION->caption(), $this->BIRTH_DURATION->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->BIRTH_DURATION->FormValue)) {
            $this->BIRTH_DURATION->addErrorMessage($this->BIRTH_DURATION->getErrorMessage(false));
        }
        if ($this->BIRTH_PLACE->Required) {
            if (!$this->BIRTH_PLACE->IsDetailKey && EmptyValue($this->BIRTH_PLACE->FormValue)) {
                $this->BIRTH_PLACE->addErrorMessage(str_replace("%s", $this->BIRTH_PLACE->caption(), $this->BIRTH_PLACE->RequiredErrorMessage));
            }
        }
        if ($this->ANTE_NATAL->Required) {
            if (!$this->ANTE_NATAL->IsDetailKey && EmptyValue($this->ANTE_NATAL->FormValue)) {
                $this->ANTE_NATAL->addErrorMessage(str_replace("%s", $this->ANTE_NATAL->caption(), $this->ANTE_NATAL->RequiredErrorMessage));
            }
        }
        if ($this->BIRTH_WAY->Required) {
            if (!$this->BIRTH_WAY->IsDetailKey && EmptyValue($this->BIRTH_WAY->FormValue)) {
                $this->BIRTH_WAY->addErrorMessage(str_replace("%s", $this->BIRTH_WAY->caption(), $this->BIRTH_WAY->RequiredErrorMessage));
            }
        }
        if ($this->BIRTH_BY->Required) {
            if (!$this->BIRTH_BY->IsDetailKey && EmptyValue($this->BIRTH_BY->FormValue)) {
                $this->BIRTH_BY->addErrorMessage(str_replace("%s", $this->BIRTH_BY->caption(), $this->BIRTH_BY->RequiredErrorMessage));
            }
        }
        if ($this->BIRTH_DATE->Required) {
            if (!$this->BIRTH_DATE->IsDetailKey && EmptyValue($this->BIRTH_DATE->FormValue)) {
                $this->BIRTH_DATE->addErrorMessage(str_replace("%s", $this->BIRTH_DATE->caption(), $this->BIRTH_DATE->RequiredErrorMessage));
            }
        }
        if (!CheckEuroDate($this->BIRTH_DATE->FormValue)) {
            $this->BIRTH_DATE->addErrorMessage($this->BIRTH_DATE->getErrorMessage(false));
        }
        if ($this->GESTASI->Required) {
            if (!$this->GESTASI->IsDetailKey && EmptyValue($this->GESTASI->FormValue)) {
                $this->GESTASI->addErrorMessage(str_replace("%s", $this->GESTASI->caption(), $this->GESTASI->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->GESTASI->FormValue)) {
            $this->GESTASI->addErrorMessage($this->GESTASI->getErrorMessage(false));
        }
        if ($this->PARITY->Required) {
            if (!$this->PARITY->IsDetailKey && EmptyValue($this->PARITY->FormValue)) {
                $this->PARITY->addErrorMessage(str_replace("%s", $this->PARITY->caption(), $this->PARITY->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->PARITY->FormValue)) {
            $this->PARITY->addErrorMessage($this->PARITY->getErrorMessage(false));
        }
        if ($this->NB_BABY->Required) {
            if (!$this->NB_BABY->IsDetailKey && EmptyValue($this->NB_BABY->FormValue)) {
                $this->NB_BABY->addErrorMessage(str_replace("%s", $this->NB_BABY->caption(), $this->NB_BABY->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->NB_BABY->FormValue)) {
            $this->NB_BABY->addErrorMessage($this->NB_BABY->getErrorMessage(false));
        }
        if ($this->BABY_DIE->Required) {
            if (!$this->BABY_DIE->IsDetailKey && EmptyValue($this->BABY_DIE->FormValue)) {
                $this->BABY_DIE->addErrorMessage(str_replace("%s", $this->BABY_DIE->caption(), $this->BABY_DIE->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->BABY_DIE->FormValue)) {
            $this->BABY_DIE->addErrorMessage($this->BABY_DIE->getErrorMessage(false));
        }
        if ($this->ABORTUS_KE->Required) {
            if (!$this->ABORTUS_KE->IsDetailKey && EmptyValue($this->ABORTUS_KE->FormValue)) {
                $this->ABORTUS_KE->addErrorMessage(str_replace("%s", $this->ABORTUS_KE->caption(), $this->ABORTUS_KE->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->ABORTUS_KE->FormValue)) {
            $this->ABORTUS_KE->addErrorMessage($this->ABORTUS_KE->getErrorMessage(false));
        }
        if ($this->ABORTUS_ID->Required) {
            if (!$this->ABORTUS_ID->IsDetailKey && EmptyValue($this->ABORTUS_ID->FormValue)) {
                $this->ABORTUS_ID->addErrorMessage(str_replace("%s", $this->ABORTUS_ID->caption(), $this->ABORTUS_ID->RequiredErrorMessage));
            }
        }
        if ($this->ABORTION_DATE->Required) {
            if (!$this->ABORTION_DATE->IsDetailKey && EmptyValue($this->ABORTION_DATE->FormValue)) {
                $this->ABORTION_DATE->addErrorMessage(str_replace("%s", $this->ABORTION_DATE->caption(), $this->ABORTION_DATE->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->ABORTION_DATE->FormValue)) {
            $this->ABORTION_DATE->addErrorMessage($this->ABORTION_DATE->getErrorMessage(false));
        }
        if ($this->BIRTH_CAT->Required) {
            if (!$this->BIRTH_CAT->IsDetailKey && EmptyValue($this->BIRTH_CAT->FormValue)) {
                $this->BIRTH_CAT->addErrorMessage(str_replace("%s", $this->BIRTH_CAT->caption(), $this->BIRTH_CAT->RequiredErrorMessage));
            }
        }
        if ($this->BIRTH_CON->Required) {
            if (!$this->BIRTH_CON->IsDetailKey && EmptyValue($this->BIRTH_CON->FormValue)) {
                $this->BIRTH_CON->addErrorMessage(str_replace("%s", $this->BIRTH_CON->caption(), $this->BIRTH_CON->RequiredErrorMessage));
            }
        }
        if ($this->BIRTH_RISK->Required) {
            if (!$this->BIRTH_RISK->IsDetailKey && EmptyValue($this->BIRTH_RISK->FormValue)) {
                $this->BIRTH_RISK->addErrorMessage(str_replace("%s", $this->BIRTH_RISK->caption(), $this->BIRTH_RISK->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->BIRTH_RISK->FormValue)) {
            $this->BIRTH_RISK->addErrorMessage($this->BIRTH_RISK->getErrorMessage(false));
        }
        if ($this->RISK_TYPE->Required) {
            if (!$this->RISK_TYPE->IsDetailKey && EmptyValue($this->RISK_TYPE->FormValue)) {
                $this->RISK_TYPE->addErrorMessage(str_replace("%s", $this->RISK_TYPE->caption(), $this->RISK_TYPE->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->RISK_TYPE->FormValue)) {
            $this->RISK_TYPE->addErrorMessage($this->RISK_TYPE->getErrorMessage(false));
        }
        if ($this->FOLLOW_UP->Required) {
            if (!$this->FOLLOW_UP->IsDetailKey && EmptyValue($this->FOLLOW_UP->FormValue)) {
                $this->FOLLOW_UP->addErrorMessage(str_replace("%s", $this->FOLLOW_UP->caption(), $this->FOLLOW_UP->RequiredErrorMessage));
            }
        }
        if ($this->DIRUJUK_OLEH->Required) {
            if (!$this->DIRUJUK_OLEH->IsDetailKey && EmptyValue($this->DIRUJUK_OLEH->FormValue)) {
                $this->DIRUJUK_OLEH->addErrorMessage(str_replace("%s", $this->DIRUJUK_OLEH->caption(), $this->DIRUJUK_OLEH->RequiredErrorMessage));
            }
        }
        if ($this->INSPECTION_DATE->Required) {
            if (!$this->INSPECTION_DATE->IsDetailKey && EmptyValue($this->INSPECTION_DATE->FormValue)) {
                $this->INSPECTION_DATE->addErrorMessage(str_replace("%s", $this->INSPECTION_DATE->caption(), $this->INSPECTION_DATE->RequiredErrorMessage));
            }
        }
        if (!CheckEuroDate($this->INSPECTION_DATE->FormValue)) {
            $this->INSPECTION_DATE->addErrorMessage($this->INSPECTION_DATE->getErrorMessage(false));
        }
        if ($this->PORSIO->Required) {
            if (!$this->PORSIO->IsDetailKey && EmptyValue($this->PORSIO->FormValue)) {
                $this->PORSIO->addErrorMessage(str_replace("%s", $this->PORSIO->caption(), $this->PORSIO->RequiredErrorMessage));
            }
        }
        if ($this->PEMBUKAAN->Required) {
            if (!$this->PEMBUKAAN->IsDetailKey && EmptyValue($this->PEMBUKAAN->FormValue)) {
                $this->PEMBUKAAN->addErrorMessage(str_replace("%s", $this->PEMBUKAAN->caption(), $this->PEMBUKAAN->RequiredErrorMessage));
            }
        }
        if ($this->KETUBAN->Required) {
            if (!$this->KETUBAN->IsDetailKey && EmptyValue($this->KETUBAN->FormValue)) {
                $this->KETUBAN->addErrorMessage(str_replace("%s", $this->KETUBAN->caption(), $this->KETUBAN->RequiredErrorMessage));
            }
        }
        if ($this->PRESENTASI->Required) {
            if (!$this->PRESENTASI->IsDetailKey && EmptyValue($this->PRESENTASI->FormValue)) {
                $this->PRESENTASI->addErrorMessage(str_replace("%s", $this->PRESENTASI->caption(), $this->PRESENTASI->RequiredErrorMessage));
            }
        }
        if ($this->POSISI->Required) {
            if (!$this->POSISI->IsDetailKey && EmptyValue($this->POSISI->FormValue)) {
                $this->POSISI->addErrorMessage(str_replace("%s", $this->POSISI->caption(), $this->POSISI->RequiredErrorMessage));
            }
        }
        if ($this->PENURUNAN->Required) {
            if (!$this->PENURUNAN->IsDetailKey && EmptyValue($this->PENURUNAN->FormValue)) {
                $this->PENURUNAN->addErrorMessage(str_replace("%s", $this->PENURUNAN->caption(), $this->PENURUNAN->RequiredErrorMessage));
            }
        }
        if ($this->PLACENTA->Required) {
            if (!$this->PLACENTA->IsDetailKey && EmptyValue($this->PLACENTA->FormValue)) {
                $this->PLACENTA->addErrorMessage(str_replace("%s", $this->PLACENTA->caption(), $this->PLACENTA->RequiredErrorMessage));
            }
        }
        if ($this->RAHIM_ID->Required) {
            if (!$this->RAHIM_ID->IsDetailKey && EmptyValue($this->RAHIM_ID->FormValue)) {
                $this->RAHIM_ID->addErrorMessage(str_replace("%s", $this->RAHIM_ID->caption(), $this->RAHIM_ID->RequiredErrorMessage));
            }
        }
        if ($this->BLOODING->Required) {
            if ($this->BLOODING->FormValue == "") {
                $this->BLOODING->addErrorMessage(str_replace("%s", $this->BLOODING->caption(), $this->BLOODING->RequiredErrorMessage));
            }
        }
        if ($this->DESCRIPTION->Required) {
            if (!$this->DESCRIPTION->IsDetailKey && EmptyValue($this->DESCRIPTION->FormValue)) {
                $this->DESCRIPTION->addErrorMessage(str_replace("%s", $this->DESCRIPTION->caption(), $this->DESCRIPTION->RequiredErrorMessage));
            }
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

            // BIRTH_NB
            $this->BIRTH_NB->setDbValueDef($rsnew, $this->BIRTH_NB->CurrentValue, null, $this->BIRTH_NB->ReadOnly);

            // BIRTH_DURATION
            $this->BIRTH_DURATION->setDbValueDef($rsnew, $this->BIRTH_DURATION->CurrentValue, null, $this->BIRTH_DURATION->ReadOnly);

            // BIRTH_PLACE
            $this->BIRTH_PLACE->setDbValueDef($rsnew, $this->BIRTH_PLACE->CurrentValue, null, $this->BIRTH_PLACE->ReadOnly);

            // ANTE_NATAL
            $this->ANTE_NATAL->setDbValueDef($rsnew, $this->ANTE_NATAL->CurrentValue, null, $this->ANTE_NATAL->ReadOnly);

            // BIRTH_WAY
            $this->BIRTH_WAY->setDbValueDef($rsnew, $this->BIRTH_WAY->CurrentValue, null, $this->BIRTH_WAY->ReadOnly);

            // BIRTH_BY
            $this->BIRTH_BY->setDbValueDef($rsnew, $this->BIRTH_BY->CurrentValue, null, $this->BIRTH_BY->ReadOnly);

            // BIRTH_DATE
            $this->BIRTH_DATE->setDbValueDef($rsnew, UnFormatDateTime($this->BIRTH_DATE->CurrentValue, 7), null, $this->BIRTH_DATE->ReadOnly);

            // GESTASI
            $this->GESTASI->setDbValueDef($rsnew, $this->GESTASI->CurrentValue, null, $this->GESTASI->ReadOnly);

            // PARITY
            $this->PARITY->setDbValueDef($rsnew, $this->PARITY->CurrentValue, null, $this->PARITY->ReadOnly);

            // NB_BABY
            $this->NB_BABY->setDbValueDef($rsnew, $this->NB_BABY->CurrentValue, null, $this->NB_BABY->ReadOnly);

            // BABY_DIE
            $this->BABY_DIE->setDbValueDef($rsnew, $this->BABY_DIE->CurrentValue, null, $this->BABY_DIE->ReadOnly);

            // ABORTUS_KE
            $this->ABORTUS_KE->setDbValueDef($rsnew, $this->ABORTUS_KE->CurrentValue, null, $this->ABORTUS_KE->ReadOnly);

            // ABORTUS_ID
            $this->ABORTUS_ID->setDbValueDef($rsnew, $this->ABORTUS_ID->CurrentValue, null, $this->ABORTUS_ID->ReadOnly);

            // ABORTION_DATE
            $this->ABORTION_DATE->setDbValueDef($rsnew, UnFormatDateTime($this->ABORTION_DATE->CurrentValue, 0), null, $this->ABORTION_DATE->ReadOnly);

            // BIRTH_CAT
            $this->BIRTH_CAT->setDbValueDef($rsnew, $this->BIRTH_CAT->CurrentValue, null, $this->BIRTH_CAT->ReadOnly);

            // BIRTH_CON
            $this->BIRTH_CON->setDbValueDef($rsnew, $this->BIRTH_CON->CurrentValue, null, $this->BIRTH_CON->ReadOnly);

            // BIRTH_RISK
            $this->BIRTH_RISK->setDbValueDef($rsnew, $this->BIRTH_RISK->CurrentValue, null, $this->BIRTH_RISK->ReadOnly);

            // RISK_TYPE
            $this->RISK_TYPE->setDbValueDef($rsnew, $this->RISK_TYPE->CurrentValue, null, $this->RISK_TYPE->ReadOnly);

            // FOLLOW_UP
            $this->FOLLOW_UP->setDbValueDef($rsnew, $this->FOLLOW_UP->CurrentValue, null, $this->FOLLOW_UP->ReadOnly);

            // DIRUJUK_OLEH
            $this->DIRUJUK_OLEH->setDbValueDef($rsnew, $this->DIRUJUK_OLEH->CurrentValue, null, $this->DIRUJUK_OLEH->ReadOnly);

            // INSPECTION_DATE
            $this->INSPECTION_DATE->setDbValueDef($rsnew, UnFormatDateTime($this->INSPECTION_DATE->CurrentValue, 11), null, $this->INSPECTION_DATE->ReadOnly);

            // PORSIO
            $this->PORSIO->setDbValueDef($rsnew, $this->PORSIO->CurrentValue, null, $this->PORSIO->ReadOnly);

            // PEMBUKAAN
            $this->PEMBUKAAN->setDbValueDef($rsnew, $this->PEMBUKAAN->CurrentValue, null, $this->PEMBUKAAN->ReadOnly);

            // KETUBAN
            $this->KETUBAN->setDbValueDef($rsnew, $this->KETUBAN->CurrentValue, null, $this->KETUBAN->ReadOnly);

            // PRESENTASI
            $this->PRESENTASI->setDbValueDef($rsnew, $this->PRESENTASI->CurrentValue, null, $this->PRESENTASI->ReadOnly);

            // POSISI
            $this->POSISI->setDbValueDef($rsnew, $this->POSISI->CurrentValue, null, $this->POSISI->ReadOnly);

            // PENURUNAN
            $this->PENURUNAN->setDbValueDef($rsnew, $this->PENURUNAN->CurrentValue, null, $this->PENURUNAN->ReadOnly);

            // PLACENTA
            $this->PLACENTA->setDbValueDef($rsnew, $this->PLACENTA->CurrentValue, null, $this->PLACENTA->ReadOnly);

            // RAHIM_ID
            $this->RAHIM_ID->setDbValueDef($rsnew, $this->RAHIM_ID->CurrentValue, null, $this->RAHIM_ID->ReadOnly);

            // BLOODING
            $this->BLOODING->setDbValueDef($rsnew, $this->BLOODING->CurrentValue, null, $this->BLOODING->ReadOnly);

            // DESCRIPTION
            $this->DESCRIPTION->setDbValueDef($rsnew, $this->DESCRIPTION->CurrentValue, null, $this->DESCRIPTION->ReadOnly);

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

    // Set up master/detail based on QueryString
    protected function setupMasterParms()
    {
        $validMaster = false;
        // Get the keys for master table
        if (($master = Get(Config("TABLE_SHOW_MASTER"), Get(Config("TABLE_MASTER")))) !== null) {
            $masterTblVar = $master;
            if ($masterTblVar == "") {
                $validMaster = true;
                $this->DbMasterFilter = "";
                $this->DbDetailFilter = "";
            }
            if ($masterTblVar == "V_RAWAT_INAP") {
                $validMaster = true;
                $masterTbl = Container("V_RAWAT_INAP");
                if (($parm = Get("fk_VISIT_ID", Get("VISIT_ID"))) !== null) {
                    $masterTbl->VISIT_ID->setQueryStringValue($parm);
                    $this->VISIT_ID->setQueryStringValue($masterTbl->VISIT_ID->QueryStringValue);
                    $this->VISIT_ID->setSessionValue($this->VISIT_ID->QueryStringValue);
                } else {
                    $validMaster = false;
                }
                if (($parm = Get("fk_NO_REGISTRATION", Get("NO_REGISTRATION"))) !== null) {
                    $masterTbl->NO_REGISTRATION->setQueryStringValue($parm);
                    $this->NO_REGISTRATION->setQueryStringValue($masterTbl->NO_REGISTRATION->QueryStringValue);
                    $this->NO_REGISTRATION->setSessionValue($this->NO_REGISTRATION->QueryStringValue);
                } else {
                    $validMaster = false;
                }
                if (($parm = Get("fk_THENAME", Get("THENAME"))) !== null) {
                    $masterTbl->THENAME->setQueryStringValue($parm);
                    $this->THENAME->setQueryStringValue($masterTbl->THENAME->QueryStringValue);
                    $this->THENAME->setSessionValue($this->THENAME->QueryStringValue);
                } else {
                    $validMaster = false;
                }
                if (($parm = Get("fk_THEADDRESS", Get("THEADDRESS"))) !== null) {
                    $masterTbl->THEADDRESS->setQueryStringValue($parm);
                    $this->THEADDRESS->setQueryStringValue($masterTbl->THEADDRESS->QueryStringValue);
                    $this->THEADDRESS->setSessionValue($this->THEADDRESS->QueryStringValue);
                } else {
                    $validMaster = false;
                }
                if (($parm = Get("fk_GENDER", Get("GENDER"))) !== null) {
                    $masterTbl->GENDER->setQueryStringValue($parm);
                    $this->GENDER->setQueryStringValue($masterTbl->GENDER->QueryStringValue);
                    $this->GENDER->setSessionValue($this->GENDER->QueryStringValue);
                } else {
                    $validMaster = false;
                }
                if (($parm = Get("fk_ORG_UNIT_CODE", Get("ORG_UNIT_CODE"))) !== null) {
                    $masterTbl->ORG_UNIT_CODE->setQueryStringValue($parm);
                    $this->ORG_UNIT_CODE->setQueryStringValue($masterTbl->ORG_UNIT_CODE->QueryStringValue);
                    $this->ORG_UNIT_CODE->setSessionValue($this->ORG_UNIT_CODE->QueryStringValue);
                } else {
                    $validMaster = false;
                }
            }
        } elseif (($master = Post(Config("TABLE_SHOW_MASTER"), Post(Config("TABLE_MASTER")))) !== null) {
            $masterTblVar = $master;
            if ($masterTblVar == "") {
                    $validMaster = true;
                    $this->DbMasterFilter = "";
                    $this->DbDetailFilter = "";
            }
            if ($masterTblVar == "V_RAWAT_INAP") {
                $validMaster = true;
                $masterTbl = Container("V_RAWAT_INAP");
                if (($parm = Post("fk_VISIT_ID", Post("VISIT_ID"))) !== null) {
                    $masterTbl->VISIT_ID->setFormValue($parm);
                    $this->VISIT_ID->setFormValue($masterTbl->VISIT_ID->FormValue);
                    $this->VISIT_ID->setSessionValue($this->VISIT_ID->FormValue);
                } else {
                    $validMaster = false;
                }
                if (($parm = Post("fk_NO_REGISTRATION", Post("NO_REGISTRATION"))) !== null) {
                    $masterTbl->NO_REGISTRATION->setFormValue($parm);
                    $this->NO_REGISTRATION->setFormValue($masterTbl->NO_REGISTRATION->FormValue);
                    $this->NO_REGISTRATION->setSessionValue($this->NO_REGISTRATION->FormValue);
                } else {
                    $validMaster = false;
                }
                if (($parm = Post("fk_THENAME", Post("THENAME"))) !== null) {
                    $masterTbl->THENAME->setFormValue($parm);
                    $this->THENAME->setFormValue($masterTbl->THENAME->FormValue);
                    $this->THENAME->setSessionValue($this->THENAME->FormValue);
                } else {
                    $validMaster = false;
                }
                if (($parm = Post("fk_THEADDRESS", Post("THEADDRESS"))) !== null) {
                    $masterTbl->THEADDRESS->setFormValue($parm);
                    $this->THEADDRESS->setFormValue($masterTbl->THEADDRESS->FormValue);
                    $this->THEADDRESS->setSessionValue($this->THEADDRESS->FormValue);
                } else {
                    $validMaster = false;
                }
                if (($parm = Post("fk_GENDER", Post("GENDER"))) !== null) {
                    $masterTbl->GENDER->setFormValue($parm);
                    $this->GENDER->setFormValue($masterTbl->GENDER->FormValue);
                    $this->GENDER->setSessionValue($this->GENDER->FormValue);
                } else {
                    $validMaster = false;
                }
                if (($parm = Post("fk_ORG_UNIT_CODE", Post("ORG_UNIT_CODE"))) !== null) {
                    $masterTbl->ORG_UNIT_CODE->setFormValue($parm);
                    $this->ORG_UNIT_CODE->setFormValue($masterTbl->ORG_UNIT_CODE->FormValue);
                    $this->ORG_UNIT_CODE->setSessionValue($this->ORG_UNIT_CODE->FormValue);
                } else {
                    $validMaster = false;
                }
            }
        }
        if ($validMaster) {
            // Save current master table
            $this->setCurrentMasterTable($masterTblVar);
            $this->setSessionWhere($this->getDetailFilter());

            // Reset start record counter (new master key)
            if (!$this->isAddOrEdit()) {
                $this->StartRecord = 1;
                $this->setStartRecordNumber($this->StartRecord);
            }

            // Clear previous master key from Session
            if ($masterTblVar != "V_RAWAT_INAP") {
                if ($this->VISIT_ID->CurrentValue == "") {
                    $this->VISIT_ID->setSessionValue("");
                }
                if ($this->NO_REGISTRATION->CurrentValue == "") {
                    $this->NO_REGISTRATION->setSessionValue("");
                }
                if ($this->THENAME->CurrentValue == "") {
                    $this->THENAME->setSessionValue("");
                }
                if ($this->THEADDRESS->CurrentValue == "") {
                    $this->THEADDRESS->setSessionValue("");
                }
                if ($this->GENDER->CurrentValue == "") {
                    $this->GENDER->setSessionValue("");
                }
                if ($this->ORG_UNIT_CODE->CurrentValue == "") {
                    $this->ORG_UNIT_CODE->setSessionValue("");
                }
            }
        }
        $this->DbMasterFilter = $this->getMasterFilter(); // Get master filter
        $this->DbDetailFilter = $this->getDetailFilter(); // Get detail filter
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("ObstetriList"), "", $this->TableVar, true);
        $pageId = "edit";
        $Breadcrumb->add("edit", $pageId, $url);
    }

    // Set up multi pages
    protected function setupMultiPages()
    {
        $pages = new SubPages();
        $pages->Style = "tabs";
        $pages->add(0);
        $pages->add(1);
        $pages->add(2);
        $pages->add(3);
        $this->MultiPages = $pages;
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
                case "x_GENDER":
                    break;
                case "x_CLINIC_ID":
                    break;
                case "x_EMPLOYEE_ID":
                    $lookupFilter = function () {
                        return "[OBJECT_CATEGORY_ID]=20 AND [NONACTIVE]=0";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    break;
                case "x_BIRTH_NB":
                    break;
                case "x_BIRTH_PLACE":
                    break;
                case "x_ANTE_NATAL":
                    break;
                case "x_BIRTH_WAY":
                    break;
                case "x_BIRTH_BY":
                    break;
                case "x_ABORTUS_ID":
                    break;
                case "x_BIRTH_CON":
                    break;
                case "x_FOLLOW_UP":
                    break;
                case "x_DIRUJUK_OLEH":
                    break;
                case "x_RAHIM_ID":
                    break;
                case "x_BLOODING":
                    break;
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
