<?php

namespace PHPMaker2021\Online;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class Register extends AntrianLogin
{
    use MessagesTrait;

    // Page ID
    public $PageID = "register";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "Register";

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

        // Table object (ANTRIAN_LOGIN)
        if (!isset($GLOBALS["ANTRIAN_LOGIN"]) || get_class($GLOBALS["ANTRIAN_LOGIN"]) == PROJECT_NAMESPACE . "ANTRIAN_LOGIN") {
            $GLOBALS["ANTRIAN_LOGIN"] = &$this;
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
                $row = ["url" => $url];
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
    public $FormClassName = "ew-horizontal ew-form ew-register-form";
    public $IsModal = false;
    public $IsMobileOrModal = false;

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $CustomExportType, $ExportFileName, $UserProfile, $Language, $Security, $CurrentForm,
            $UserTable, $CurrentLanguage, $Breadcrumb, $SkipHeaderFooter;

        // Is modal
        $this->IsModal = Param("modal") == "1";

        // Create form object
        $CurrentForm = new HttpForm();
        $this->CurrentAction = Param("action"); // Set up current action

        // Global Page Loading event (in userfn*.php)
        Page_Loading();

        // Page Load event
        if (method_exists($this, "pageLoad")) {
            $this->pageLoad();
        }

        // Check modal
        if ($this->IsModal) {
            $SkipHeaderFooter = true;
        }
        $this->IsMobileOrModal = IsMobile() || $this->IsModal;
        $this->FormClassName = "ew-form ew-register-form ew-horizontal";

        // Set up Breadcrumb
        $Breadcrumb = new Breadcrumb("VDaftarantriList");
        $Breadcrumb->add("register", "RegisterPage", CurrentUrl(), "", "", true);
        $this->Heading = $Language->phrase("RegisterPage");
        $userExists = false;
        $this->loadRowValues(); // Load default values

        // Get action
        $action = "";
        if (IsApi()) {
            $action = "insert";
        } elseif (Post("action") != "") {
            $action = Post("action");
        }

        // Check action
        if ($action != "") {
            // Get action
            $this->CurrentAction = $action;
            $this->loadFormValues(); // Get form values

            // Validate form
            if (!$this->validateForm()) {
                if (IsApi()) {
                    $this->terminate();
                    return;
                } else {
                    $this->CurrentAction = "show"; // Form error, reset action
                }
            }
        } else {
            $this->CurrentAction = "show"; // Display blank record
        }

        // Insert record
        if ($this->isInsert()) {
            // Check for duplicate User ID
            $filter = GetUserFilter(Config("LOGIN_USERNAME_FIELD_NAME"), $this->NO_HP->CurrentValue);
            // Set up filter (WHERE Clause)
            $this->CurrentFilter = $filter;
            $userSql = $this->getCurrentSql();
            $rs = Conn($UserTable->Dbid)->executeQuery($userSql);
            if ($rs->fetch()) {
                $userExists = true;
                $this->restoreFormValues(); // Restore form values
                $this->setFailureMessage($Language->phrase("UserExists")); // Set user exist message
            }
            if (!$userExists) {
                $this->SendEmail = true; // Send email on add success
                if ($this->addRow()) { // Add record
                    if ($this->getSuccessMessage() == "") {
                        $this->setSuccessMessage($Language->phrase("RegisterSuccess")); // Register success
                    }
                    if (IsApi()) { // Return to caller
                        $this->terminate(true);
                        return;
                    } else {
                        $this->terminate("login"); // Return
                        return;
                    }
                } else {
                    $this->restoreFormValues(); // Restore form values
                }
            }
        }

        // API request, return
        if (IsApi()) {
            $this->terminate();
            return;
        }

        // Render row
        $this->RowType = ROWTYPE_ADD; // Render add
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
        $this->FOTO->Upload->Index = $CurrentForm->Index;
        $this->FOTO->Upload->uploadFile();
        $this->FOTO->CurrentValue = $this->FOTO->Upload->FileName;
    }

    // Load default values
    protected function loadDefaultValues()
    {
        $this->ID->CurrentValue = null;
        $this->ID->OldValue = $this->ID->CurrentValue;
        $this->FOTO->Upload->DbValue = null;
        $this->FOTO->OldValue = $this->FOTO->Upload->DbValue;
        $this->NOMR->CurrentValue = null;
        $this->NOMR->OldValue = $this->NOMR->CurrentValue;
        $this->NO_BPJS->CurrentValue = null;
        $this->NO_BPJS->OldValue = $this->NO_BPJS->CurrentValue;
        $this->NAMA->CurrentValue = null;
        $this->NAMA->OldValue = $this->NAMA->CurrentValue;
        $this->TEMPAT_LAHIR->CurrentValue = null;
        $this->TEMPAT_LAHIR->OldValue = $this->TEMPAT_LAHIR->CurrentValue;
        $this->TANGGAL_LAHIR->CurrentValue = null;
        $this->TANGGAL_LAHIR->OldValue = $this->TANGGAL_LAHIR->CurrentValue;
        $this->JENIS_KELAMIN->CurrentValue = null;
        $this->JENIS_KELAMIN->OldValue = $this->JENIS_KELAMIN->CurrentValue;
        $this->AGAMA->CurrentValue = null;
        $this->AGAMA->OldValue = $this->AGAMA->CurrentValue;
        $this->PEKERJAAN->CurrentValue = null;
        $this->PEKERJAAN->OldValue = $this->PEKERJAAN->CurrentValue;
        $this->ALAMAT->CurrentValue = null;
        $this->ALAMAT->OldValue = $this->ALAMAT->CurrentValue;
        $this->_EMAIL->CurrentValue = null;
        $this->_EMAIL->OldValue = $this->_EMAIL->CurrentValue;
        $this->NO_TELP->CurrentValue = null;
        $this->NO_TELP->OldValue = $this->NO_TELP->CurrentValue;
        $this->NO_HP->CurrentValue = null;
        $this->NO_HP->OldValue = $this->NO_HP->CurrentValue;
        $this->TANGGAL_REGIS->CurrentValue = null;
        $this->TANGGAL_REGIS->OldValue = $this->TANGGAL_REGIS->CurrentValue;
        $this->NAMA_IBU->CurrentValue = null;
        $this->NAMA_IBU->OldValue = $this->NAMA_IBU->CurrentValue;
        $this->NAMA_AYAH->CurrentValue = null;
        $this->NAMA_AYAH->OldValue = $this->NAMA_AYAH->CurrentValue;
        $this->NAMA_PASANGAN->CurrentValue = null;
        $this->NAMA_PASANGAN->OldValue = $this->NAMA_PASANGAN->CurrentValue;
        $this->_PASSWORD->CurrentValue = null;
        $this->_PASSWORD->OldValue = $this->_PASSWORD->CurrentValue;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;

        // Check field name 'NOMR' first before field var 'x_NOMR'
        $val = $CurrentForm->hasValue("NOMR") ? $CurrentForm->getValue("NOMR") : $CurrentForm->getValue("x_NOMR");
        if (!$this->NOMR->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->NOMR->Visible = false; // Disable update for API request
            } else {
                $this->NOMR->setFormValue($val);
            }
        }

        // Check field name 'NO_BPJS' first before field var 'x_NO_BPJS'
        $val = $CurrentForm->hasValue("NO_BPJS") ? $CurrentForm->getValue("NO_BPJS") : $CurrentForm->getValue("x_NO_BPJS");
        if (!$this->NO_BPJS->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->NO_BPJS->Visible = false; // Disable update for API request
            } else {
                $this->NO_BPJS->setFormValue($val);
            }
        }

        // Check field name 'NAMA' first before field var 'x_NAMA'
        $val = $CurrentForm->hasValue("NAMA") ? $CurrentForm->getValue("NAMA") : $CurrentForm->getValue("x_NAMA");
        if (!$this->NAMA->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->NAMA->Visible = false; // Disable update for API request
            } else {
                $this->NAMA->setFormValue($val);
            }
        }

        // Check field name 'TEMPAT_LAHIR' first before field var 'x_TEMPAT_LAHIR'
        $val = $CurrentForm->hasValue("TEMPAT_LAHIR") ? $CurrentForm->getValue("TEMPAT_LAHIR") : $CurrentForm->getValue("x_TEMPAT_LAHIR");
        if (!$this->TEMPAT_LAHIR->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->TEMPAT_LAHIR->Visible = false; // Disable update for API request
            } else {
                $this->TEMPAT_LAHIR->setFormValue($val);
            }
        }

        // Check field name 'TANGGAL_LAHIR' first before field var 'x_TANGGAL_LAHIR'
        $val = $CurrentForm->hasValue("TANGGAL_LAHIR") ? $CurrentForm->getValue("TANGGAL_LAHIR") : $CurrentForm->getValue("x_TANGGAL_LAHIR");
        if (!$this->TANGGAL_LAHIR->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->TANGGAL_LAHIR->Visible = false; // Disable update for API request
            } else {
                $this->TANGGAL_LAHIR->setFormValue($val);
            }
            $this->TANGGAL_LAHIR->CurrentValue = UnFormatDateTime($this->TANGGAL_LAHIR->CurrentValue, 0);
        }

        // Check field name 'ALAMAT' first before field var 'x_ALAMAT'
        $val = $CurrentForm->hasValue("ALAMAT") ? $CurrentForm->getValue("ALAMAT") : $CurrentForm->getValue("x_ALAMAT");
        if (!$this->ALAMAT->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ALAMAT->Visible = false; // Disable update for API request
            } else {
                $this->ALAMAT->setFormValue($val);
            }
        }

        // Check field name 'EMAIL' first before field var 'x__EMAIL'
        $val = $CurrentForm->hasValue("EMAIL") ? $CurrentForm->getValue("EMAIL") : $CurrentForm->getValue("x__EMAIL");
        if (!$this->_EMAIL->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->_EMAIL->Visible = false; // Disable update for API request
            } else {
                $this->_EMAIL->setFormValue($val);
            }
        }

        // Check field name 'NO_HP' first before field var 'x_NO_HP'
        $val = $CurrentForm->hasValue("NO_HP") ? $CurrentForm->getValue("NO_HP") : $CurrentForm->getValue("x_NO_HP");
        if (!$this->NO_HP->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->NO_HP->Visible = false; // Disable update for API request
            } else {
                $this->NO_HP->setFormValue($val);
            }
        }

        // Check field name 'PASSWORD' first before field var 'x__PASSWORD'
        $val = $CurrentForm->hasValue("PASSWORD") ? $CurrentForm->getValue("PASSWORD") : $CurrentForm->getValue("x__PASSWORD");
        if (!$this->_PASSWORD->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->_PASSWORD->Visible = false; // Disable update for API request
            } else {
                $this->_PASSWORD->setFormValue($val);
            }
        }

        // Note: ConfirmValue will be compared with FormValue
        if (Config("ENCRYPTED_PASSWORD")) { // Encrypted password, use raw value
            $this->_PASSWORD->ConfirmValue = $CurrentForm->getValue("c__PASSWORD");
        } else {
            $this->_PASSWORD->ConfirmValue = RemoveXss($CurrentForm->getValue("c__PASSWORD"));
        }

        // Check field name 'ID' first before field var 'x_ID'
        $val = $CurrentForm->hasValue("ID") ? $CurrentForm->getValue("ID") : $CurrentForm->getValue("x_ID");
        $this->getUploadFiles(); // Get upload files
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->NOMR->CurrentValue = $this->NOMR->FormValue;
        $this->NO_BPJS->CurrentValue = $this->NO_BPJS->FormValue;
        $this->NAMA->CurrentValue = $this->NAMA->FormValue;
        $this->TEMPAT_LAHIR->CurrentValue = $this->TEMPAT_LAHIR->FormValue;
        $this->TANGGAL_LAHIR->CurrentValue = $this->TANGGAL_LAHIR->FormValue;
        $this->TANGGAL_LAHIR->CurrentValue = UnFormatDateTime($this->TANGGAL_LAHIR->CurrentValue, 0);
        $this->ALAMAT->CurrentValue = $this->ALAMAT->FormValue;
        $this->_EMAIL->CurrentValue = $this->_EMAIL->FormValue;
        $this->NO_HP->CurrentValue = $this->NO_HP->FormValue;
        $this->_PASSWORD->CurrentValue = $this->_PASSWORD->FormValue;
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
        $this->ID->setDbValue($row['ID']);
        $this->FOTO->Upload->DbValue = $row['FOTO'];
        $this->FOTO->setDbValue($this->FOTO->Upload->DbValue);
        $this->NOMR->setDbValue($row['NOMR']);
        $this->NO_BPJS->setDbValue($row['NO_BPJS']);
        $this->NAMA->setDbValue($row['NAMA']);
        $this->TEMPAT_LAHIR->setDbValue($row['TEMPAT_LAHIR']);
        $this->TANGGAL_LAHIR->setDbValue($row['TANGGAL_LAHIR']);
        $this->JENIS_KELAMIN->setDbValue($row['JENIS_KELAMIN']);
        $this->AGAMA->setDbValue($row['AGAMA']);
        $this->PEKERJAAN->setDbValue($row['PEKERJAAN']);
        $this->ALAMAT->setDbValue($row['ALAMAT']);
        $this->_EMAIL->setDbValue($row['EMAIL']);
        $this->NO_TELP->setDbValue($row['NO_TELP']);
        $this->NO_HP->setDbValue($row['NO_HP']);
        $this->TANGGAL_REGIS->setDbValue($row['TANGGAL_REGIS']);
        $this->NAMA_IBU->setDbValue($row['NAMA_IBU']);
        $this->NAMA_AYAH->setDbValue($row['NAMA_AYAH']);
        $this->NAMA_PASANGAN->setDbValue($row['NAMA_PASANGAN']);
        $this->_PASSWORD->setDbValue($row['PASSWORD']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $this->loadDefaultValues();
        $row = [];
        $row['ID'] = $this->ID->CurrentValue;
        $row['FOTO'] = $this->FOTO->Upload->DbValue;
        $row['NOMR'] = $this->NOMR->CurrentValue;
        $row['NO_BPJS'] = $this->NO_BPJS->CurrentValue;
        $row['NAMA'] = $this->NAMA->CurrentValue;
        $row['TEMPAT_LAHIR'] = $this->TEMPAT_LAHIR->CurrentValue;
        $row['TANGGAL_LAHIR'] = $this->TANGGAL_LAHIR->CurrentValue;
        $row['JENIS_KELAMIN'] = $this->JENIS_KELAMIN->CurrentValue;
        $row['AGAMA'] = $this->AGAMA->CurrentValue;
        $row['PEKERJAAN'] = $this->PEKERJAAN->CurrentValue;
        $row['ALAMAT'] = $this->ALAMAT->CurrentValue;
        $row['EMAIL'] = $this->_EMAIL->CurrentValue;
        $row['NO_TELP'] = $this->NO_TELP->CurrentValue;
        $row['NO_HP'] = $this->NO_HP->CurrentValue;
        $row['TANGGAL_REGIS'] = $this->TANGGAL_REGIS->CurrentValue;
        $row['NAMA_IBU'] = $this->NAMA_IBU->CurrentValue;
        $row['NAMA_AYAH'] = $this->NAMA_AYAH->CurrentValue;
        $row['NAMA_PASANGAN'] = $this->NAMA_PASANGAN->CurrentValue;
        $row['PASSWORD'] = $this->_PASSWORD->CurrentValue;
        return $row;
    }

    // Render row values based on field settings
    public function renderRow()
    {
        global $Security, $Language, $CurrentLanguage;

        // Initialize URLs

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // ID

        // FOTO

        // NOMR

        // NO_BPJS

        // NAMA

        // TEMPAT_LAHIR

        // TANGGAL_LAHIR

        // JENIS_KELAMIN

        // AGAMA

        // PEKERJAAN

        // ALAMAT

        // EMAIL

        // NO_TELP

        // NO_HP

        // TANGGAL_REGIS

        // NAMA_IBU

        // NAMA_AYAH

        // NAMA_PASANGAN

        // PASSWORD
        if ($this->RowType == ROWTYPE_VIEW) {
            // ID
            $this->ID->ViewValue = $this->ID->CurrentValue;
            $this->ID->ViewCustomAttributes = "";

            // FOTO
            if (!EmptyValue($this->FOTO->Upload->DbValue)) {
                $this->FOTO->ImageWidth = 300;
                $this->FOTO->ImageHeight = 0;
                $this->FOTO->ImageAlt = $this->FOTO->alt();
                $this->FOTO->ViewValue = $this->FOTO->Upload->DbValue;
            } else {
                $this->FOTO->ViewValue = "";
            }
            $this->FOTO->ViewCustomAttributes = "";

            // NOMR
            $this->NOMR->ViewValue = $this->NOMR->CurrentValue;
            $this->NOMR->ViewCustomAttributes = "";

            // NO_BPJS
            $this->NO_BPJS->ViewValue = $this->NO_BPJS->CurrentValue;
            $this->NO_BPJS->ViewCustomAttributes = "";

            // NAMA
            $this->NAMA->ViewValue = $this->NAMA->CurrentValue;
            $this->NAMA->ViewCustomAttributes = "";

            // TEMPAT_LAHIR
            $this->TEMPAT_LAHIR->ViewValue = $this->TEMPAT_LAHIR->CurrentValue;
            $this->TEMPAT_LAHIR->ViewCustomAttributes = "";

            // TANGGAL_LAHIR
            $this->TANGGAL_LAHIR->ViewValue = $this->TANGGAL_LAHIR->CurrentValue;
            $this->TANGGAL_LAHIR->ViewValue = FormatDateTime($this->TANGGAL_LAHIR->ViewValue, 0);
            $this->TANGGAL_LAHIR->ViewCustomAttributes = "";

            // JENIS_KELAMIN
            $curVal = trim(strval($this->JENIS_KELAMIN->CurrentValue));
            if ($curVal != "") {
                $this->JENIS_KELAMIN->ViewValue = $this->JENIS_KELAMIN->lookupCacheOption($curVal);
                if ($this->JENIS_KELAMIN->ViewValue === null) { // Lookup from database
                    $filterWrk = "[GENDER]" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->JENIS_KELAMIN->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->JENIS_KELAMIN->Lookup->renderViewRow($rswrk[0]);
                        $this->JENIS_KELAMIN->ViewValue = $this->JENIS_KELAMIN->displayValue($arwrk);
                    } else {
                        $this->JENIS_KELAMIN->ViewValue = $this->JENIS_KELAMIN->CurrentValue;
                    }
                }
            } else {
                $this->JENIS_KELAMIN->ViewValue = null;
            }
            $this->JENIS_KELAMIN->ViewCustomAttributes = "";

            // AGAMA
            $curVal = trim(strval($this->AGAMA->CurrentValue));
            if ($curVal != "") {
                $this->AGAMA->ViewValue = $this->AGAMA->lookupCacheOption($curVal);
                if ($this->AGAMA->ViewValue === null) { // Lookup from database
                    $filterWrk = "[KODE_AGAMA]" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->AGAMA->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->AGAMA->Lookup->renderViewRow($rswrk[0]);
                        $this->AGAMA->ViewValue = $this->AGAMA->displayValue($arwrk);
                    } else {
                        $this->AGAMA->ViewValue = $this->AGAMA->CurrentValue;
                    }
                }
            } else {
                $this->AGAMA->ViewValue = null;
            }
            $this->AGAMA->ViewCustomAttributes = "";

            // PEKERJAAN
            $curVal = trim(strval($this->PEKERJAAN->CurrentValue));
            if ($curVal != "") {
                $this->PEKERJAAN->ViewValue = $this->PEKERJAAN->lookupCacheOption($curVal);
                if ($this->PEKERJAAN->ViewValue === null) { // Lookup from database
                    $filterWrk = "[JOB_ID]" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->PEKERJAAN->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->PEKERJAAN->Lookup->renderViewRow($rswrk[0]);
                        $this->PEKERJAAN->ViewValue = $this->PEKERJAAN->displayValue($arwrk);
                    } else {
                        $this->PEKERJAAN->ViewValue = $this->PEKERJAAN->CurrentValue;
                    }
                }
            } else {
                $this->PEKERJAAN->ViewValue = null;
            }
            $this->PEKERJAAN->ViewCustomAttributes = "";

            // ALAMAT
            $this->ALAMAT->ViewValue = $this->ALAMAT->CurrentValue;
            $this->ALAMAT->ViewCustomAttributes = "";

            // EMAIL
            $this->_EMAIL->ViewValue = $this->_EMAIL->CurrentValue;
            $this->_EMAIL->ViewCustomAttributes = "";

            // NO_TELP
            $this->NO_TELP->ViewValue = $this->NO_TELP->CurrentValue;
            $this->NO_TELP->ViewCustomAttributes = "";

            // NO_HP
            $this->NO_HP->ViewValue = $this->NO_HP->CurrentValue;
            $this->NO_HP->ViewCustomAttributes = "";

            // TANGGAL_REGIS
            $this->TANGGAL_REGIS->ViewValue = $this->TANGGAL_REGIS->CurrentValue;
            $this->TANGGAL_REGIS->ViewValue = FormatDateTime($this->TANGGAL_REGIS->ViewValue, 0);
            $this->TANGGAL_REGIS->ViewCustomAttributes = "";

            // NAMA_IBU
            $this->NAMA_IBU->ViewValue = $this->NAMA_IBU->CurrentValue;
            $this->NAMA_IBU->ViewCustomAttributes = "";

            // NAMA_AYAH
            $this->NAMA_AYAH->ViewValue = $this->NAMA_AYAH->CurrentValue;
            $this->NAMA_AYAH->ViewCustomAttributes = "";

            // NAMA_PASANGAN
            $this->NAMA_PASANGAN->ViewValue = $this->NAMA_PASANGAN->CurrentValue;
            $this->NAMA_PASANGAN->ViewCustomAttributes = "";

            // PASSWORD
            $this->_PASSWORD->ViewValue = $Language->phrase("PasswordMask");
            $this->_PASSWORD->ViewCustomAttributes = "";

            // FOTO
            $this->FOTO->LinkCustomAttributes = "";
            if (!EmptyValue($this->FOTO->Upload->DbValue)) {
                $this->FOTO->HrefValue = GetFileUploadUrl($this->FOTO, $this->FOTO->htmlDecode($this->FOTO->Upload->DbValue)); // Add prefix/suffix
                $this->FOTO->LinkAttrs["target"] = ""; // Add target
                if ($this->isExport()) {
                    $this->FOTO->HrefValue = FullUrl($this->FOTO->HrefValue, "href");
                }
            } else {
                $this->FOTO->HrefValue = "";
            }
            $this->FOTO->ExportHrefValue = $this->FOTO->UploadPath . $this->FOTO->Upload->DbValue;
            $this->FOTO->TooltipValue = "";
            if ($this->FOTO->UseColorbox) {
                if (EmptyValue($this->FOTO->TooltipValue)) {
                    $this->FOTO->LinkAttrs["title"] = $Language->phrase("ViewImageGallery");
                }
                $this->FOTO->LinkAttrs["data-rel"] = "ANTRIAN_LOGIN_x_FOTO";
                $this->FOTO->LinkAttrs->appendClass("ew-lightbox");
            }

            // NOMR
            $this->NOMR->LinkCustomAttributes = "";
            $this->NOMR->HrefValue = "";
            $this->NOMR->TooltipValue = "";

            // NO_BPJS
            $this->NO_BPJS->LinkCustomAttributes = "";
            $this->NO_BPJS->HrefValue = "";
            $this->NO_BPJS->TooltipValue = "";

            // NAMA
            $this->NAMA->LinkCustomAttributes = "";
            $this->NAMA->HrefValue = "";
            $this->NAMA->TooltipValue = "";

            // TEMPAT_LAHIR
            $this->TEMPAT_LAHIR->LinkCustomAttributes = "";
            $this->TEMPAT_LAHIR->HrefValue = "";
            $this->TEMPAT_LAHIR->TooltipValue = "";

            // TANGGAL_LAHIR
            $this->TANGGAL_LAHIR->LinkCustomAttributes = "";
            $this->TANGGAL_LAHIR->HrefValue = "";
            $this->TANGGAL_LAHIR->TooltipValue = "";

            // ALAMAT
            $this->ALAMAT->LinkCustomAttributes = "";
            $this->ALAMAT->HrefValue = "";
            $this->ALAMAT->TooltipValue = "";

            // EMAIL
            $this->_EMAIL->LinkCustomAttributes = "";
            $this->_EMAIL->HrefValue = "";
            $this->_EMAIL->TooltipValue = "";

            // NO_HP
            $this->NO_HP->LinkCustomAttributes = "";
            $this->NO_HP->HrefValue = "";
            $this->NO_HP->TooltipValue = "";

            // PASSWORD
            $this->_PASSWORD->LinkCustomAttributes = "";
            $this->_PASSWORD->HrefValue = "";
            $this->_PASSWORD->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // FOTO
            $this->FOTO->EditAttrs["class"] = "form-control";
            $this->FOTO->EditCustomAttributes = "";
            if (!EmptyValue($this->FOTO->Upload->DbValue)) {
                $this->FOTO->ImageWidth = 300;
                $this->FOTO->ImageHeight = 0;
                $this->FOTO->ImageAlt = $this->FOTO->alt();
                $this->FOTO->EditValue = $this->FOTO->Upload->DbValue;
            } else {
                $this->FOTO->EditValue = "";
            }
            if (!EmptyValue($this->FOTO->CurrentValue)) {
                $this->FOTO->Upload->FileName = $this->FOTO->CurrentValue;
            }
            if ($this->isShow()) {
                RenderUploadField($this->FOTO);
            }

            // NOMR
            $this->NOMR->EditAttrs["class"] = "form-control";
            $this->NOMR->EditCustomAttributes = "";
            if (!$this->NOMR->Raw) {
                $this->NOMR->CurrentValue = HtmlDecode($this->NOMR->CurrentValue);
            }
            $this->NOMR->EditValue = HtmlEncode($this->NOMR->CurrentValue);
            $this->NOMR->PlaceHolder = RemoveHtml($this->NOMR->caption());

            // NO_BPJS
            $this->NO_BPJS->EditAttrs["class"] = "form-control";
            $this->NO_BPJS->EditCustomAttributes = "";
            if (!$this->NO_BPJS->Raw) {
                $this->NO_BPJS->CurrentValue = HtmlDecode($this->NO_BPJS->CurrentValue);
            }
            $this->NO_BPJS->EditValue = HtmlEncode($this->NO_BPJS->CurrentValue);
            $this->NO_BPJS->PlaceHolder = RemoveHtml($this->NO_BPJS->caption());

            // NAMA
            $this->NAMA->EditAttrs["class"] = "form-control";
            $this->NAMA->EditCustomAttributes = "";
            if (!$this->NAMA->Raw) {
                $this->NAMA->CurrentValue = HtmlDecode($this->NAMA->CurrentValue);
            }
            $this->NAMA->EditValue = HtmlEncode($this->NAMA->CurrentValue);
            $this->NAMA->PlaceHolder = RemoveHtml($this->NAMA->caption());

            // TEMPAT_LAHIR
            $this->TEMPAT_LAHIR->EditAttrs["class"] = "form-control";
            $this->TEMPAT_LAHIR->EditCustomAttributes = "";
            if (!$this->TEMPAT_LAHIR->Raw) {
                $this->TEMPAT_LAHIR->CurrentValue = HtmlDecode($this->TEMPAT_LAHIR->CurrentValue);
            }
            $this->TEMPAT_LAHIR->EditValue = HtmlEncode($this->TEMPAT_LAHIR->CurrentValue);
            $this->TEMPAT_LAHIR->PlaceHolder = RemoveHtml($this->TEMPAT_LAHIR->caption());

            // TANGGAL_LAHIR
            $this->TANGGAL_LAHIR->EditAttrs["class"] = "form-control";
            $this->TANGGAL_LAHIR->EditCustomAttributes = "";
            $this->TANGGAL_LAHIR->EditValue = HtmlEncode(FormatDateTime($this->TANGGAL_LAHIR->CurrentValue, 8));
            $this->TANGGAL_LAHIR->PlaceHolder = RemoveHtml($this->TANGGAL_LAHIR->caption());

            // ALAMAT
            $this->ALAMAT->EditAttrs["class"] = "form-control";
            $this->ALAMAT->EditCustomAttributes = "";
            $this->ALAMAT->EditValue = HtmlEncode($this->ALAMAT->CurrentValue);
            $this->ALAMAT->PlaceHolder = RemoveHtml($this->ALAMAT->caption());

            // EMAIL
            $this->_EMAIL->EditAttrs["class"] = "form-control";
            $this->_EMAIL->EditCustomAttributes = "";
            if (!$this->_EMAIL->Raw) {
                $this->_EMAIL->CurrentValue = HtmlDecode($this->_EMAIL->CurrentValue);
            }
            $this->_EMAIL->EditValue = HtmlEncode($this->_EMAIL->CurrentValue);
            $this->_EMAIL->PlaceHolder = RemoveHtml($this->_EMAIL->caption());

            // NO_HP
            $this->NO_HP->EditAttrs["class"] = "form-control";
            $this->NO_HP->EditCustomAttributes = "";
            if (!$this->NO_HP->Raw) {
                $this->NO_HP->CurrentValue = HtmlDecode($this->NO_HP->CurrentValue);
            }
            $this->NO_HP->EditValue = HtmlEncode($this->NO_HP->CurrentValue);
            $this->NO_HP->PlaceHolder = RemoveHtml($this->NO_HP->caption());

            // PASSWORD
            $this->_PASSWORD->EditAttrs["class"] = "form-control";
            $this->_PASSWORD->EditCustomAttributes = "";
            $this->_PASSWORD->PlaceHolder = RemoveHtml($this->_PASSWORD->caption());

            // Add refer script

            // FOTO
            $this->FOTO->LinkCustomAttributes = "";
            if (!EmptyValue($this->FOTO->Upload->DbValue)) {
                $this->FOTO->HrefValue = GetFileUploadUrl($this->FOTO, $this->FOTO->htmlDecode($this->FOTO->Upload->DbValue)); // Add prefix/suffix
                $this->FOTO->LinkAttrs["target"] = ""; // Add target
                if ($this->isExport()) {
                    $this->FOTO->HrefValue = FullUrl($this->FOTO->HrefValue, "href");
                }
            } else {
                $this->FOTO->HrefValue = "";
            }
            $this->FOTO->ExportHrefValue = $this->FOTO->UploadPath . $this->FOTO->Upload->DbValue;

            // NOMR
            $this->NOMR->LinkCustomAttributes = "";
            $this->NOMR->HrefValue = "";

            // NO_BPJS
            $this->NO_BPJS->LinkCustomAttributes = "";
            $this->NO_BPJS->HrefValue = "";

            // NAMA
            $this->NAMA->LinkCustomAttributes = "";
            $this->NAMA->HrefValue = "";

            // TEMPAT_LAHIR
            $this->TEMPAT_LAHIR->LinkCustomAttributes = "";
            $this->TEMPAT_LAHIR->HrefValue = "";

            // TANGGAL_LAHIR
            $this->TANGGAL_LAHIR->LinkCustomAttributes = "";
            $this->TANGGAL_LAHIR->HrefValue = "";

            // ALAMAT
            $this->ALAMAT->LinkCustomAttributes = "";
            $this->ALAMAT->HrefValue = "";

            // EMAIL
            $this->_EMAIL->LinkCustomAttributes = "";
            $this->_EMAIL->HrefValue = "";

            // NO_HP
            $this->NO_HP->LinkCustomAttributes = "";
            $this->NO_HP->HrefValue = "";

            // PASSWORD
            $this->_PASSWORD->LinkCustomAttributes = "";
            $this->_PASSWORD->HrefValue = "";
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
        if ($this->FOTO->Required) {
            if ($this->FOTO->Upload->FileName == "" && !$this->FOTO->Upload->KeepFile) {
                $this->FOTO->addErrorMessage(str_replace("%s", $this->FOTO->caption(), $this->FOTO->RequiredErrorMessage));
            }
        }
        if ($this->NOMR->Required) {
            if (!$this->NOMR->IsDetailKey && EmptyValue($this->NOMR->FormValue)) {
                $this->NOMR->addErrorMessage(str_replace("%s", $this->NOMR->caption(), $this->NOMR->RequiredErrorMessage));
            }
        }
        if ($this->NO_BPJS->Required) {
            if (!$this->NO_BPJS->IsDetailKey && EmptyValue($this->NO_BPJS->FormValue)) {
                $this->NO_BPJS->addErrorMessage(str_replace("%s", $this->NO_BPJS->caption(), $this->NO_BPJS->RequiredErrorMessage));
            }
        }
        if ($this->NAMA->Required) {
            if (!$this->NAMA->IsDetailKey && EmptyValue($this->NAMA->FormValue)) {
                $this->NAMA->addErrorMessage(str_replace("%s", $this->NAMA->caption(), $this->NAMA->RequiredErrorMessage));
            }
        }
        if ($this->TEMPAT_LAHIR->Required) {
            if (!$this->TEMPAT_LAHIR->IsDetailKey && EmptyValue($this->TEMPAT_LAHIR->FormValue)) {
                $this->TEMPAT_LAHIR->addErrorMessage(str_replace("%s", $this->TEMPAT_LAHIR->caption(), $this->TEMPAT_LAHIR->RequiredErrorMessage));
            }
        }
        if ($this->TANGGAL_LAHIR->Required) {
            if (!$this->TANGGAL_LAHIR->IsDetailKey && EmptyValue($this->TANGGAL_LAHIR->FormValue)) {
                $this->TANGGAL_LAHIR->addErrorMessage(str_replace("%s", $this->TANGGAL_LAHIR->caption(), $this->TANGGAL_LAHIR->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->TANGGAL_LAHIR->FormValue)) {
            $this->TANGGAL_LAHIR->addErrorMessage($this->TANGGAL_LAHIR->getErrorMessage(false));
        }
        if ($this->ALAMAT->Required) {
            if (!$this->ALAMAT->IsDetailKey && EmptyValue($this->ALAMAT->FormValue)) {
                $this->ALAMAT->addErrorMessage(str_replace("%s", $this->ALAMAT->caption(), $this->ALAMAT->RequiredErrorMessage));
            }
        }
        if ($this->_EMAIL->Required) {
            if (!$this->_EMAIL->IsDetailKey && EmptyValue($this->_EMAIL->FormValue)) {
                $this->_EMAIL->addErrorMessage(str_replace("%s", $this->_EMAIL->caption(), $this->_EMAIL->RequiredErrorMessage));
            }
        }
        if ($this->NO_HP->Required) {
            if (!$this->NO_HP->IsDetailKey && EmptyValue($this->NO_HP->FormValue)) {
                $this->NO_HP->addErrorMessage($Language->phrase("EnterUserName"));
            }
        }
        if (!$this->NO_HP->Raw && Config("REMOVE_XSS") && CheckUsername($this->NO_HP->FormValue)) {
            $this->NO_HP->addErrorMessage($Language->phrase("InvalidUsernameChars"));
        }
        if ($this->_PASSWORD->Required) {
            if (!$this->_PASSWORD->IsDetailKey && EmptyValue($this->_PASSWORD->FormValue)) {
                $this->_PASSWORD->addErrorMessage($Language->phrase("EnterPassword"));
            }
        }
        if (!$this->_PASSWORD->Raw && Config("REMOVE_XSS") && CheckPassword($this->_PASSWORD->FormValue)) {
            $this->_PASSWORD->addErrorMessage($Language->phrase("InvalidPasswordChars"));
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

        // Check if valid User ID
        $validUser = false;
        if ($Security->currentUserID() != "" && !EmptyValue($this->ID->CurrentValue) && !$Security->isAdmin()) { // Non system admin
            $validUser = $Security->isValidUserID($this->ID->CurrentValue);
            if (!$validUser) {
                $userIdMsg = str_replace("%c", CurrentUserID(), $Language->phrase("UnAuthorizedUserID"));
                $userIdMsg = str_replace("%u", $this->ID->CurrentValue, $userIdMsg);
                $this->setFailureMessage($userIdMsg);
                return false;
            }
        }
        $conn = $this->getConnection();

        // Load db values from rsold
        $this->loadDbValues($rsold);
        if ($rsold) {
        }
        $rsnew = [];

        // FOTO
        if ($this->FOTO->Visible && !$this->FOTO->Upload->KeepFile) {
            $this->FOTO->Upload->DbValue = ""; // No need to delete old file
            if ($this->FOTO->Upload->FileName == "") {
                $rsnew['FOTO'] = null;
            } else {
                $rsnew['FOTO'] = $this->FOTO->Upload->FileName;
            }
        }

        // NOMR
        $this->NOMR->setDbValueDef($rsnew, $this->NOMR->CurrentValue, null, false);

        // NO_BPJS
        $this->NO_BPJS->setDbValueDef($rsnew, $this->NO_BPJS->CurrentValue, null, false);

        // NAMA
        $this->NAMA->setDbValueDef($rsnew, $this->NAMA->CurrentValue, null, false);

        // TEMPAT_LAHIR
        $this->TEMPAT_LAHIR->setDbValueDef($rsnew, $this->TEMPAT_LAHIR->CurrentValue, null, false);

        // TANGGAL_LAHIR
        $this->TANGGAL_LAHIR->setDbValueDef($rsnew, UnFormatDateTime($this->TANGGAL_LAHIR->CurrentValue, 0), null, false);

        // ALAMAT
        $this->ALAMAT->setDbValueDef($rsnew, $this->ALAMAT->CurrentValue, null, false);

        // EMAIL
        $this->_EMAIL->setDbValueDef($rsnew, $this->_EMAIL->CurrentValue, null, false);

        // NO_HP
        $this->NO_HP->setDbValueDef($rsnew, $this->NO_HP->CurrentValue, null, false);

        // PASSWORD
        if (!IsMaskedPassword($this->_PASSWORD->CurrentValue)) {
            $this->_PASSWORD->setDbValueDef($rsnew, $this->_PASSWORD->CurrentValue, null, false);
        }

        // ID
        if ($this->FOTO->Visible && !$this->FOTO->Upload->KeepFile) {
            $oldFiles = EmptyValue($this->FOTO->Upload->DbValue) ? [] : [$this->FOTO->htmlDecode($this->FOTO->Upload->DbValue)];
            if (!EmptyValue($this->FOTO->Upload->FileName)) {
                $newFiles = [$this->FOTO->Upload->FileName];
                $NewFileCount = count($newFiles);
                for ($i = 0; $i < $NewFileCount; $i++) {
                    if ($newFiles[$i] != "") {
                        $file = $newFiles[$i];
                        $tempPath = UploadTempPath($this->FOTO, $this->FOTO->Upload->Index);
                        if (file_exists($tempPath . $file)) {
                            if (Config("DELETE_UPLOADED_FILES")) {
                                $oldFileFound = false;
                                $oldFileCount = count($oldFiles);
                                for ($j = 0; $j < $oldFileCount; $j++) {
                                    $oldFile = $oldFiles[$j];
                                    if ($oldFile == $file) { // Old file found, no need to delete anymore
                                        array_splice($oldFiles, $j, 1);
                                        $oldFileFound = true;
                                        break;
                                    }
                                }
                                if ($oldFileFound) { // No need to check if file exists further
                                    continue;
                                }
                            }
                            $file1 = UniqueFilename($this->FOTO->physicalUploadPath(), $file); // Get new file name
                            if ($file1 != $file) { // Rename temp file
                                while (file_exists($tempPath . $file1) || file_exists($this->FOTO->physicalUploadPath() . $file1)) { // Make sure no file name clash
                                    $file1 = UniqueFilename([$this->FOTO->physicalUploadPath(), $tempPath], $file1, true); // Use indexed name
                                }
                                rename($tempPath . $file, $tempPath . $file1);
                                $newFiles[$i] = $file1;
                            }
                        }
                    }
                }
                $this->FOTO->Upload->DbValue = empty($oldFiles) ? "" : implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $oldFiles);
                $this->FOTO->Upload->FileName = implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $newFiles);
                $this->FOTO->setDbValueDef($rsnew, $this->FOTO->Upload->FileName, null, false);
            }
        }

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
                if ($this->FOTO->Visible && !$this->FOTO->Upload->KeepFile) {
                    $oldFiles = EmptyValue($this->FOTO->Upload->DbValue) ? [] : [$this->FOTO->htmlDecode($this->FOTO->Upload->DbValue)];
                    if (!EmptyValue($this->FOTO->Upload->FileName)) {
                        $newFiles = [$this->FOTO->Upload->FileName];
                        $newFiles2 = [$this->FOTO->htmlDecode($rsnew['FOTO'])];
                        $newFileCount = count($newFiles);
                        for ($i = 0; $i < $newFileCount; $i++) {
                            if ($newFiles[$i] != "") {
                                $file = UploadTempPath($this->FOTO, $this->FOTO->Upload->Index) . $newFiles[$i];
                                if (file_exists($file)) {
                                    if (@$newFiles2[$i] != "") { // Use correct file name
                                        $newFiles[$i] = $newFiles2[$i];
                                    }
                                    if (!$this->FOTO->Upload->SaveToFile($newFiles[$i], true, $i)) { // Just replace
                                        $this->setFailureMessage($Language->phrase("UploadErrMsg7"));
                                        return false;
                                    }
                                }
                            }
                        }
                    } else {
                        $newFiles = [];
                    }
                    if (Config("DELETE_UPLOADED_FILES")) {
                        foreach ($oldFiles as $oldFile) {
                            if ($oldFile != "" && !in_array($oldFile, $newFiles)) {
                                @unlink($this->FOTO->oldPhysicalUploadPath() . $oldFile);
                            }
                        }
                    }
                }
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

            // Call User Registered event
            $this->userRegistered($rsnew);
        }

        // Clean upload path if any
        if ($addRow) {
            // FOTO
            CleanUploadTempPath($this->FOTO, $this->FOTO->Upload->Index);
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
        $Breadcrumb = new Breadcrumb("VDaftarantriList");
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
                case "x_JENIS_KELAMIN":
                    break;
                case "x_AGAMA":
                    break;
                case "x_PEKERJAAN":
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
    // $type = ''|'success'|'failure'
    public function messageShowing(&$msg, $type)
    {
        // Example:
        //if ($type == 'success') $msg = "your success message";
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

    // Email Sending event
    public function emailSending($email, &$args)
    {
        //var_dump($email); var_dump($args); exit();
        return true;
    }

    // Form Custom Validate event
    public function formCustomValidate(&$customError)
    {
        // Return error message in CustomError
        return true;
    }

    // User Registered event
    public function userRegistered(&$rs)
    {
        //Log("User_Registered");
    }

    // User Activated event
    public function userActivated(&$rs)
    {
        //Log("User_Activated");
    }
}
