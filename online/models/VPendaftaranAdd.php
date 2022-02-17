<?php

namespace PHPMaker2021\ONLINEBARU;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class VPendaftaranAdd extends VPendaftaran
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'v_pendaftaran';

    // Page object name
    public $PageObjName = "VPendaftaranAdd";

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

        // Table object (v_pendaftaran)
        if (!isset($GLOBALS["v_pendaftaran"]) || get_class($GLOBALS["v_pendaftaran"]) == PROJECT_NAMESPACE . "v_pendaftaran") {
            $GLOBALS["v_pendaftaran"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'v_pendaftaran');
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
                $doc = new $class(Container("v_pendaftaran"));
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
                    if ($pageName == "VPendaftaranView") {
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
            $key .= @$ar['Id'];
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
            $this->Id->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->NAMA->Visible = false;
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
        $this->Id->Visible = false;
        $this->no_urut->Visible = false;
        $this->NAMA->Visible = false;
        $this->tanggal_daftar->setVisibility();
        $this->tanggal_panggil->Visible = false;
        $this->loket->Visible = false;
        $this->status_panggil->setVisibility();
        $this->user->setVisibility();
        $this->newapp->setVisibility();
        $this->kdpoli->setVisibility();
        $this->tanggal_pesan->setVisibility();
        $this->tujuan->setVisibility();
        $this->disabilitas->setVisibility();
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
        $this->setupLookupOptions($this->kdpoli);

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
            if (($keyValue = Get("Id") ?? Route("Id")) !== null) {
                $this->Id->setQueryStringValue($keyValue);
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
                    $this->terminate("VPendaftaranList"); // No matching record, return to list
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
                    if (GetPageName($returnUrl) == "VPendaftaranList") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "VPendaftaranView") {
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
        $this->Id->CurrentValue = null;
        $this->Id->OldValue = $this->Id->CurrentValue;
        $this->no_urut->CurrentValue = null;
        $this->no_urut->OldValue = $this->no_urut->CurrentValue;
        $this->NAMA->CurrentValue = null;
        $this->NAMA->OldValue = $this->NAMA->CurrentValue;
        $this->tanggal_daftar->CurrentValue = null;
        $this->tanggal_daftar->OldValue = $this->tanggal_daftar->CurrentValue;
        $this->tanggal_panggil->CurrentValue = null;
        $this->tanggal_panggil->OldValue = $this->tanggal_panggil->CurrentValue;
        $this->loket->CurrentValue = null;
        $this->loket->OldValue = $this->loket->CurrentValue;
        $this->status_panggil->CurrentValue = 0;
        $this->user->CurrentValue = null;
        $this->user->OldValue = $this->user->CurrentValue;
        $this->newapp->CurrentValue = 1;
        $this->kdpoli->CurrentValue = null;
        $this->kdpoli->OldValue = $this->kdpoli->CurrentValue;
        $this->tanggal_pesan->CurrentValue = null;
        $this->tanggal_pesan->OldValue = $this->tanggal_pesan->CurrentValue;
        $this->tujuan->CurrentValue = null;
        $this->tujuan->OldValue = $this->tujuan->CurrentValue;
        $this->disabilitas->CurrentValue = null;
        $this->disabilitas->OldValue = $this->disabilitas->CurrentValue;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;

        // Check field name 'tanggal_daftar' first before field var 'x_tanggal_daftar'
        $val = $CurrentForm->hasValue("tanggal_daftar") ? $CurrentForm->getValue("tanggal_daftar") : $CurrentForm->getValue("x_tanggal_daftar");
        if (!$this->tanggal_daftar->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tanggal_daftar->Visible = false; // Disable update for API request
            } else {
                $this->tanggal_daftar->setFormValue($val);
            }
            $this->tanggal_daftar->CurrentValue = UnFormatDateTime($this->tanggal_daftar->CurrentValue, 7);
        }

        // Check field name 'status_panggil' first before field var 'x_status_panggil'
        $val = $CurrentForm->hasValue("status_panggil") ? $CurrentForm->getValue("status_panggil") : $CurrentForm->getValue("x_status_panggil");
        if (!$this->status_panggil->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->status_panggil->Visible = false; // Disable update for API request
            } else {
                $this->status_panggil->setFormValue($val);
            }
        }

        // Check field name 'user' first before field var 'x_user'
        $val = $CurrentForm->hasValue("user") ? $CurrentForm->getValue("user") : $CurrentForm->getValue("x_user");
        if (!$this->user->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->user->Visible = false; // Disable update for API request
            } else {
                $this->user->setFormValue($val);
            }
        }

        // Check field name 'newapp' first before field var 'x_newapp'
        $val = $CurrentForm->hasValue("newapp") ? $CurrentForm->getValue("newapp") : $CurrentForm->getValue("x_newapp");
        if (!$this->newapp->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->newapp->Visible = false; // Disable update for API request
            } else {
                $this->newapp->setFormValue($val);
            }
        }

        // Check field name 'kdpoli' first before field var 'x_kdpoli'
        $val = $CurrentForm->hasValue("kdpoli") ? $CurrentForm->getValue("kdpoli") : $CurrentForm->getValue("x_kdpoli");
        if (!$this->kdpoli->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->kdpoli->Visible = false; // Disable update for API request
            } else {
                $this->kdpoli->setFormValue($val);
            }
        }

        // Check field name 'tanggal_pesan' first before field var 'x_tanggal_pesan'
        $val = $CurrentForm->hasValue("tanggal_pesan") ? $CurrentForm->getValue("tanggal_pesan") : $CurrentForm->getValue("x_tanggal_pesan");
        if (!$this->tanggal_pesan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tanggal_pesan->Visible = false; // Disable update for API request
            } else {
                $this->tanggal_pesan->setFormValue($val);
            }
            $this->tanggal_pesan->CurrentValue = UnFormatDateTime($this->tanggal_pesan->CurrentValue, 0);
        }

        // Check field name 'tujuan' first before field var 'x_tujuan'
        $val = $CurrentForm->hasValue("tujuan") ? $CurrentForm->getValue("tujuan") : $CurrentForm->getValue("x_tujuan");
        if (!$this->tujuan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tujuan->Visible = false; // Disable update for API request
            } else {
                $this->tujuan->setFormValue($val);
            }
        }

        // Check field name 'disabilitas' first before field var 'x_disabilitas'
        $val = $CurrentForm->hasValue("disabilitas") ? $CurrentForm->getValue("disabilitas") : $CurrentForm->getValue("x_disabilitas");
        if (!$this->disabilitas->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->disabilitas->Visible = false; // Disable update for API request
            } else {
                $this->disabilitas->setFormValue($val);
            }
        }

        // Check field name 'Id' first before field var 'x_Id'
        $val = $CurrentForm->hasValue("Id") ? $CurrentForm->getValue("Id") : $CurrentForm->getValue("x_Id");
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->tanggal_daftar->CurrentValue = $this->tanggal_daftar->FormValue;
        $this->tanggal_daftar->CurrentValue = UnFormatDateTime($this->tanggal_daftar->CurrentValue, 7);
        $this->status_panggil->CurrentValue = $this->status_panggil->FormValue;
        $this->user->CurrentValue = $this->user->FormValue;
        $this->newapp->CurrentValue = $this->newapp->FormValue;
        $this->kdpoli->CurrentValue = $this->kdpoli->FormValue;
        $this->tanggal_pesan->CurrentValue = $this->tanggal_pesan->FormValue;
        $this->tanggal_pesan->CurrentValue = UnFormatDateTime($this->tanggal_pesan->CurrentValue, 0);
        $this->tujuan->CurrentValue = $this->tujuan->FormValue;
        $this->disabilitas->CurrentValue = $this->disabilitas->FormValue;
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
        $this->Id->setDbValue($row['Id']);
        $this->no_urut->setDbValue($row['no_urut']);
        $this->NAMA->setDbValue($row['NAMA']);
        $this->tanggal_daftar->setDbValue($row['tanggal_daftar']);
        $this->tanggal_panggil->setDbValue($row['tanggal_panggil']);
        $this->loket->setDbValue($row['loket']);
        $this->status_panggil->setDbValue($row['status_panggil']);
        $this->user->setDbValue($row['user']);
        $this->newapp->setDbValue($row['newapp']);
        $this->kdpoli->setDbValue($row['kdpoli']);
        $this->tanggal_pesan->setDbValue($row['tanggal_pesan']);
        $this->tujuan->setDbValue($row['tujuan']);
        $this->disabilitas->setDbValue($row['disabilitas']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $this->loadDefaultValues();
        $row = [];
        $row['Id'] = $this->Id->CurrentValue;
        $row['no_urut'] = $this->no_urut->CurrentValue;
        $row['NAMA'] = $this->NAMA->CurrentValue;
        $row['tanggal_daftar'] = $this->tanggal_daftar->CurrentValue;
        $row['tanggal_panggil'] = $this->tanggal_panggil->CurrentValue;
        $row['loket'] = $this->loket->CurrentValue;
        $row['status_panggil'] = $this->status_panggil->CurrentValue;
        $row['user'] = $this->user->CurrentValue;
        $row['newapp'] = $this->newapp->CurrentValue;
        $row['kdpoli'] = $this->kdpoli->CurrentValue;
        $row['tanggal_pesan'] = $this->tanggal_pesan->CurrentValue;
        $row['tujuan'] = $this->tujuan->CurrentValue;
        $row['disabilitas'] = $this->disabilitas->CurrentValue;
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

        // Id

        // no_urut

        // NAMA

        // tanggal_daftar

        // tanggal_panggil

        // loket

        // status_panggil

        // user

        // newapp

        // kdpoli

        // tanggal_pesan

        // tujuan

        // disabilitas
        if ($this->RowType == ROWTYPE_VIEW) {
            // Id
            $this->Id->ViewValue = $this->Id->CurrentValue;
            $this->Id->ViewCustomAttributes = "";

            // no_urut
            $this->no_urut->ViewValue = $this->no_urut->CurrentValue;
            $this->no_urut->ViewValue = FormatNumber($this->no_urut->ViewValue, 0, -2, -2, -2);
            $this->no_urut->ViewCustomAttributes = "";

            // NAMA
            $this->NAMA->ViewValue = $this->NAMA->CurrentValue;
            $this->NAMA->ViewCustomAttributes = "";

            // tanggal_daftar
            $this->tanggal_daftar->ViewValue = $this->tanggal_daftar->CurrentValue;
            $this->tanggal_daftar->ViewValue = FormatDateTime($this->tanggal_daftar->ViewValue, 7);
            $this->tanggal_daftar->ViewCustomAttributes = "";

            // tanggal_panggil
            $this->tanggal_panggil->ViewValue = $this->tanggal_panggil->CurrentValue;
            $this->tanggal_panggil->ViewValue = FormatDateTime($this->tanggal_panggil->ViewValue, 0);
            $this->tanggal_panggil->ViewCustomAttributes = "";

            // loket
            $this->loket->ViewValue = $this->loket->CurrentValue;
            $this->loket->ViewCustomAttributes = "";

            // status_panggil
            $this->status_panggil->ViewValue = $this->status_panggil->CurrentValue;
            $this->status_panggil->ViewValue = FormatNumber($this->status_panggil->ViewValue, 0, -2, -2, -2);
            $this->status_panggil->ViewCustomAttributes = "";

            // user
            $this->user->ViewValue = $this->user->CurrentValue;
            $this->user->ViewValue = FormatNumber($this->user->ViewValue, 0, -2, -2, -2);
            $this->user->ViewCustomAttributes = "";

            // newapp
            $this->newapp->ViewValue = $this->newapp->CurrentValue;
            $this->newapp->ViewValue = FormatNumber($this->newapp->ViewValue, 0, -2, -2, -2);
            $this->newapp->ViewCustomAttributes = "";

            // kdpoli
            $curVal = trim(strval($this->kdpoli->CurrentValue));
            if ($curVal != "") {
                $this->kdpoli->ViewValue = $this->kdpoli->lookupCacheOption($curVal);
                if ($this->kdpoli->ViewValue === null) { // Lookup from database
                    $filterWrk = "[CLINIC_ID]" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $lookupFilter = function() {
                        return "[STYPE_ID] = 1";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    $sqlWrk = $this->kdpoli->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->kdpoli->Lookup->renderViewRow($rswrk[0]);
                        $this->kdpoli->ViewValue = $this->kdpoli->displayValue($arwrk);
                    } else {
                        $this->kdpoli->ViewValue = $this->kdpoli->CurrentValue;
                    }
                }
            } else {
                $this->kdpoli->ViewValue = null;
            }
            $this->kdpoli->ViewCustomAttributes = "";

            // tanggal_pesan
            $this->tanggal_pesan->ViewValue = $this->tanggal_pesan->CurrentValue;
            $this->tanggal_pesan->ViewValue = FormatDateTime($this->tanggal_pesan->ViewValue, 0);
            $this->tanggal_pesan->ViewCustomAttributes = "";

            // tujuan
            $this->tujuan->ViewValue = $this->tujuan->CurrentValue;
            $this->tujuan->ViewCustomAttributes = "";

            // disabilitas
            $this->disabilitas->ViewValue = $this->disabilitas->CurrentValue;
            $this->disabilitas->ViewValue = FormatNumber($this->disabilitas->ViewValue, 0, -2, -2, -2);
            $this->disabilitas->ViewCustomAttributes = "";

            // tanggal_daftar
            $this->tanggal_daftar->LinkCustomAttributes = "";
            $this->tanggal_daftar->HrefValue = "";
            $this->tanggal_daftar->TooltipValue = "";

            // status_panggil
            $this->status_panggil->LinkCustomAttributes = "";
            $this->status_panggil->HrefValue = "";
            $this->status_panggil->TooltipValue = "";

            // user
            $this->user->LinkCustomAttributes = "";
            $this->user->HrefValue = "";
            $this->user->TooltipValue = "";

            // newapp
            $this->newapp->LinkCustomAttributes = "";
            $this->newapp->HrefValue = "";
            $this->newapp->TooltipValue = "";

            // kdpoli
            $this->kdpoli->LinkCustomAttributes = "";
            $this->kdpoli->HrefValue = "";
            $this->kdpoli->TooltipValue = "";

            // tanggal_pesan
            $this->tanggal_pesan->LinkCustomAttributes = "";
            $this->tanggal_pesan->HrefValue = "";
            $this->tanggal_pesan->TooltipValue = "";

            // tujuan
            $this->tujuan->LinkCustomAttributes = "";
            $this->tujuan->HrefValue = "";
            $this->tujuan->TooltipValue = "";

            // disabilitas
            $this->disabilitas->LinkCustomAttributes = "";
            $this->disabilitas->HrefValue = "";
            $this->disabilitas->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // tanggal_daftar
            $this->tanggal_daftar->EditAttrs["class"] = "form-control";
            $this->tanggal_daftar->EditCustomAttributes = "";
            $this->tanggal_daftar->EditValue = HtmlEncode(FormatDateTime($this->tanggal_daftar->CurrentValue, 7));
            $this->tanggal_daftar->PlaceHolder = RemoveHtml($this->tanggal_daftar->caption());

            // status_panggil
            $this->status_panggil->EditAttrs["class"] = "form-control";
            $this->status_panggil->EditCustomAttributes = "";
            $this->status_panggil->CurrentValue = 0;

            // user

            // newapp
            $this->newapp->EditAttrs["class"] = "form-control";
            $this->newapp->EditCustomAttributes = "";
            $this->newapp->CurrentValue = 1;

            // kdpoli
            $this->kdpoli->EditCustomAttributes = "";
            $curVal = trim(strval($this->kdpoli->CurrentValue));
            if ($curVal != "") {
                $this->kdpoli->ViewValue = $this->kdpoli->lookupCacheOption($curVal);
            } else {
                $this->kdpoli->ViewValue = $this->kdpoli->Lookup !== null && is_array($this->kdpoli->Lookup->Options) ? $curVal : null;
            }
            if ($this->kdpoli->ViewValue !== null) { // Load from cache
                $this->kdpoli->EditValue = array_values($this->kdpoli->Lookup->Options);
                if ($this->kdpoli->ViewValue == "") {
                    $this->kdpoli->ViewValue = $Language->phrase("PleaseSelect");
                }
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "[CLINIC_ID]" . SearchString("=", $this->kdpoli->CurrentValue, DATATYPE_STRING, "");
                }
                $lookupFilter = function() {
                    return "[STYPE_ID] = 1";
                };
                $lookupFilter = $lookupFilter->bindTo($this);
                $sqlWrk = $this->kdpoli->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->kdpoli->Lookup->renderViewRow($rswrk[0]);
                    $this->kdpoli->ViewValue = $this->kdpoli->displayValue($arwrk);
                } else {
                    $this->kdpoli->ViewValue = $Language->phrase("PleaseSelect");
                }
                $arwrk = $rswrk;
                $this->kdpoli->EditValue = $arwrk;
            }
            $this->kdpoli->PlaceHolder = RemoveHtml($this->kdpoli->caption());

            // tanggal_pesan

            // tujuan
            $this->tujuan->EditAttrs["class"] = "form-control";
            $this->tujuan->EditCustomAttributes = "";
            if (!$this->tujuan->Raw) {
                $this->tujuan->CurrentValue = HtmlDecode($this->tujuan->CurrentValue);
            }
            $this->tujuan->EditValue = HtmlEncode($this->tujuan->CurrentValue);
            $this->tujuan->PlaceHolder = RemoveHtml($this->tujuan->caption());

            // disabilitas
            $this->disabilitas->EditAttrs["class"] = "form-control";
            $this->disabilitas->EditCustomAttributes = "";
            $this->disabilitas->EditValue = HtmlEncode($this->disabilitas->CurrentValue);
            $this->disabilitas->PlaceHolder = RemoveHtml($this->disabilitas->caption());

            // Add refer script

            // tanggal_daftar
            $this->tanggal_daftar->LinkCustomAttributes = "";
            $this->tanggal_daftar->HrefValue = "";

            // status_panggil
            $this->status_panggil->LinkCustomAttributes = "";
            $this->status_panggil->HrefValue = "";

            // user
            $this->user->LinkCustomAttributes = "";
            $this->user->HrefValue = "";

            // newapp
            $this->newapp->LinkCustomAttributes = "";
            $this->newapp->HrefValue = "";

            // kdpoli
            $this->kdpoli->LinkCustomAttributes = "";
            $this->kdpoli->HrefValue = "";

            // tanggal_pesan
            $this->tanggal_pesan->LinkCustomAttributes = "";
            $this->tanggal_pesan->HrefValue = "";

            // tujuan
            $this->tujuan->LinkCustomAttributes = "";
            $this->tujuan->HrefValue = "";

            // disabilitas
            $this->disabilitas->LinkCustomAttributes = "";
            $this->disabilitas->HrefValue = "";
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
        if ($this->tanggal_daftar->Required) {
            if (!$this->tanggal_daftar->IsDetailKey && EmptyValue($this->tanggal_daftar->FormValue)) {
                $this->tanggal_daftar->addErrorMessage(str_replace("%s", $this->tanggal_daftar->caption(), $this->tanggal_daftar->RequiredErrorMessage));
            }
        }
        if (!CheckEuroDate($this->tanggal_daftar->FormValue)) {
            $this->tanggal_daftar->addErrorMessage($this->tanggal_daftar->getErrorMessage(false));
        }
        if ($this->status_panggil->Required) {
            if (!$this->status_panggil->IsDetailKey && EmptyValue($this->status_panggil->FormValue)) {
                $this->status_panggil->addErrorMessage(str_replace("%s", $this->status_panggil->caption(), $this->status_panggil->RequiredErrorMessage));
            }
        }
        if ($this->user->Required) {
            if (!$this->user->IsDetailKey && EmptyValue($this->user->FormValue)) {
                $this->user->addErrorMessage(str_replace("%s", $this->user->caption(), $this->user->RequiredErrorMessage));
            }
        }
        if ($this->newapp->Required) {
            if (!$this->newapp->IsDetailKey && EmptyValue($this->newapp->FormValue)) {
                $this->newapp->addErrorMessage(str_replace("%s", $this->newapp->caption(), $this->newapp->RequiredErrorMessage));
            }
        }
        if ($this->kdpoli->Required) {
            if (!$this->kdpoli->IsDetailKey && EmptyValue($this->kdpoli->FormValue)) {
                $this->kdpoli->addErrorMessage(str_replace("%s", $this->kdpoli->caption(), $this->kdpoli->RequiredErrorMessage));
            }
        }
        if ($this->tanggal_pesan->Required) {
            if (!$this->tanggal_pesan->IsDetailKey && EmptyValue($this->tanggal_pesan->FormValue)) {
                $this->tanggal_pesan->addErrorMessage(str_replace("%s", $this->tanggal_pesan->caption(), $this->tanggal_pesan->RequiredErrorMessage));
            }
        }
        if ($this->tujuan->Required) {
            if (!$this->tujuan->IsDetailKey && EmptyValue($this->tujuan->FormValue)) {
                $this->tujuan->addErrorMessage(str_replace("%s", $this->tujuan->caption(), $this->tujuan->RequiredErrorMessage));
            }
        }
        if ($this->disabilitas->Required) {
            if (!$this->disabilitas->IsDetailKey && EmptyValue($this->disabilitas->FormValue)) {
                $this->disabilitas->addErrorMessage(str_replace("%s", $this->disabilitas->caption(), $this->disabilitas->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->disabilitas->FormValue)) {
            $this->disabilitas->addErrorMessage($this->disabilitas->getErrorMessage(false));
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

        // tanggal_daftar
        $this->tanggal_daftar->setDbValueDef($rsnew, UnFormatDateTime($this->tanggal_daftar->CurrentValue, 7), null, false);

        // status_panggil
        $this->status_panggil->setDbValueDef($rsnew, $this->status_panggil->CurrentValue, null, false);

        // user
        $this->user->CurrentValue = CurrentUserID();
        $this->user->setDbValueDef($rsnew, $this->user->CurrentValue, null);

        // newapp
        $this->newapp->setDbValueDef($rsnew, $this->newapp->CurrentValue, null, false);

        // kdpoli
        $this->kdpoli->setDbValueDef($rsnew, $this->kdpoli->CurrentValue, null, false);

        // tanggal_pesan
        $this->tanggal_pesan->CurrentValue = CurrentDate();
        $this->tanggal_pesan->setDbValueDef($rsnew, $this->tanggal_pesan->CurrentValue, null);

        // tujuan
        $this->tujuan->setDbValueDef($rsnew, $this->tujuan->CurrentValue, null, false);

        // disabilitas
        $this->disabilitas->setDbValueDef($rsnew, $this->disabilitas->CurrentValue, null, false);

        // Call Row Inserting event
        $insertRow = $this->rowInserting($rsold, $rsnew);
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
        $Breadcrumb = new Breadcrumb("AntrianPendaftaranList");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("VPendaftaranList"), "", $this->TableVar, true);
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
                case "x_kdpoli":
                    $lookupFilter = function () {
                        return "[STYPE_ID] = 1";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
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
