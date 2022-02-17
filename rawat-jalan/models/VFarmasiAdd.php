<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAJALALTER;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class VFarmasiAdd extends VFarmasi
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'V_FARMASI';

    // Page object name
    public $PageObjName = "VFarmasiAdd";

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

        // Table object (V_FARMASI)
        if (!isset($GLOBALS["V_FARMASI"]) || get_class($GLOBALS["V_FARMASI"]) == PROJECT_NAMESPACE . "V_FARMASI") {
            $GLOBALS["V_FARMASI"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'V_FARMASI');
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
                $doc = new $class(Container("V_FARMASI"));
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
                    if ($pageName == "VFarmasiView") {
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
            $key .= @$ar['IDXDAFTAR'];
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
            $this->IDXDAFTAR->Visible = false;
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
        $this->NO_REGISTRATION->setVisibility();
        $this->VISIT_ID->setVisibility();
        $this->STATUS_PASIEN_ID->setVisibility();
        $this->RUJUKAN_ID->setVisibility();
        $this->ADDRESS_OF_RUJUKAN->setVisibility();
        $this->REASON_ID->setVisibility();
        $this->WAY_ID->setVisibility();
        $this->PATIENT_CATEGORY_ID->setVisibility();
        $this->BOOKED_DATE->setVisibility();
        $this->VISIT_DATE->setVisibility();
        $this->ISNEW->setVisibility();
        $this->FOLLOW_UP->setVisibility();
        $this->PLACE_TYPE->setVisibility();
        $this->CLINIC_ID->setVisibility();
        $this->CLINIC_ID_FROM->setVisibility();
        $this->CLASS_ROOM_ID->setVisibility();
        $this->BED_ID->setVisibility();
        $this->KELUAR_ID->setVisibility();
        $this->IN_DATE->setVisibility();
        $this->EXIT_DATE->setVisibility();
        $this->DIANTAR_OLEH->setVisibility();
        $this->GENDER->setVisibility();
        $this->DESCRIPTION->setVisibility();
        $this->VISITOR_ADDRESS->setVisibility();
        $this->MODIFIED_BY->setVisibility();
        $this->MODIFIED_DATE->setVisibility();
        $this->MODIFIED_FROM->setVisibility();
        $this->EMPLOYEE_ID->setVisibility();
        $this->EMPLOYEE_ID_FROM->setVisibility();
        $this->RESPONSIBLE_ID->setVisibility();
        $this->RESPONSIBLE->setVisibility();
        $this->FAMILY_STATUS_ID->setVisibility();
        $this->TICKET_NO->setVisibility();
        $this->ISATTENDED->setVisibility();
        $this->PAYOR_ID->setVisibility();
        $this->CLASS_ID->setVisibility();
        $this->ISPERTARIF->setVisibility();
        $this->KAL_ID->setVisibility();
        $this->EMPLOYEE_INAP->setVisibility();
        $this->PASIEN_ID->setVisibility();
        $this->KARYAWAN->setVisibility();
        $this->ACCOUNT_ID->setVisibility();
        $this->CLASS_ID_PLAFOND->setVisibility();
        $this->BACKCHARGE->setVisibility();
        $this->COVERAGE_ID->setVisibility();
        $this->AGEYEAR->setVisibility();
        $this->AGEMONTH->setVisibility();
        $this->AGEDAY->setVisibility();
        $this->RECOMENDATION->setVisibility();
        $this->CONCLUSION->setVisibility();
        $this->SPECIMENNO->setVisibility();
        $this->LOCKED->setVisibility();
        $this->RM_OUT_DATE->setVisibility();
        $this->RM_IN_DATE->setVisibility();
        $this->LAMA_PINJAM->setVisibility();
        $this->STANDAR_RJ->setVisibility();
        $this->LENGKAP_RJ->setVisibility();
        $this->LENGKAP_RI->setVisibility();
        $this->RESEND_RM_DATE->setVisibility();
        $this->LENGKAP_RM1->setVisibility();
        $this->LENGKAP_RESUME->setVisibility();
        $this->LENGKAP_ANAMNESIS->setVisibility();
        $this->LENGKAP_CONSENT->setVisibility();
        $this->LENGKAP_ANESTESI->setVisibility();
        $this->LENGKAP_OP->setVisibility();
        $this->BACK_RM_DATE->setVisibility();
        $this->VALID_RM_DATE->setVisibility();
        $this->NO_SKP->setVisibility();
        $this->NO_SKPINAP->setVisibility();
        $this->DIAGNOSA_ID->setVisibility();
        $this->ticket_all->setVisibility();
        $this->tanggal_rujukan->setVisibility();
        $this->ISRJ->setVisibility();
        $this->NORUJUKAN->setVisibility();
        $this->PPKRUJUKAN->setVisibility();
        $this->LOKASILAKA->setVisibility();
        $this->KDPOLI->setVisibility();
        $this->EDIT_SEP->setVisibility();
        $this->DELETE_SEP->setVisibility();
        $this->KODE_AGAMA->setVisibility();
        $this->DIAG_AWAL->setVisibility();
        $this->AKTIF->setVisibility();
        $this->BILL_INAP->setVisibility();
        $this->SEP_PRINTDATE->setVisibility();
        $this->MAPPING_SEP->setVisibility();
        $this->TRANS_ID->setVisibility();
        $this->KDPOLI_EKS->setVisibility();
        $this->COB->setVisibility();
        $this->PENJAMIN->setVisibility();
        $this->ASALRUJUKAN->setVisibility();
        $this->RESPONSEP->setVisibility();
        $this->APPROVAL_DESC->setVisibility();
        $this->APPROVAL_RESPONAJUKAN->setVisibility();
        $this->APPROVAL_RESPONAPPROV->setVisibility();
        $this->RESPONTGLPLG_DESC->setVisibility();
        $this->RESPONPOST_VKLAIM->setVisibility();
        $this->RESPONPUT_VKLAIM->setVisibility();
        $this->RESPONDEL_VKLAIM->setVisibility();
        $this->CALL_TIMES->setVisibility();
        $this->CALL_DATE->setVisibility();
        $this->CALL_DATES->setVisibility();
        $this->SERVED_DATE->setVisibility();
        $this->SERVED_INAP->setVisibility();
        $this->KDDPJP1->setVisibility();
        $this->KDDPJP->setVisibility();
        $this->IDXDAFTAR->Visible = false;
        $this->tgl_kontrol->setVisibility();
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
            if (($keyValue = Get("IDXDAFTAR") ?? Route("IDXDAFTAR")) !== null) {
                $this->IDXDAFTAR->setQueryStringValue($keyValue);
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
                    $this->terminate("VFarmasiList"); // No matching record, return to list
                    return;
                }
                break;
            case "insert": // Add new record
                $this->SendEmail = true; // Send email on add success
                if ($this->addRow($this->OldRecordset)) { // Add successful
                    if ($this->getSuccessMessage() == "" && Post("addopt") != "1") { // Skip success message for addopt (done in JavaScript)
                        $this->setSuccessMessage($Language->phrase("AddSuccess")); // Set up success message
                    }
                    $returnUrl = 'PasienVisitationEdit/'.urlencode(CurrentPage()->IDXDAFTAR->CurrentValue);
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
        $this->NO_REGISTRATION->CurrentValue = null;
        $this->NO_REGISTRATION->OldValue = $this->NO_REGISTRATION->CurrentValue;
        $this->VISIT_ID->CurrentValue = null;
        $this->VISIT_ID->OldValue = $this->VISIT_ID->CurrentValue;
        $this->STATUS_PASIEN_ID->CurrentValue = null;
        $this->STATUS_PASIEN_ID->OldValue = $this->STATUS_PASIEN_ID->CurrentValue;
        $this->RUJUKAN_ID->CurrentValue = null;
        $this->RUJUKAN_ID->OldValue = $this->RUJUKAN_ID->CurrentValue;
        $this->ADDRESS_OF_RUJUKAN->CurrentValue = null;
        $this->ADDRESS_OF_RUJUKAN->OldValue = $this->ADDRESS_OF_RUJUKAN->CurrentValue;
        $this->REASON_ID->CurrentValue = null;
        $this->REASON_ID->OldValue = $this->REASON_ID->CurrentValue;
        $this->WAY_ID->CurrentValue = null;
        $this->WAY_ID->OldValue = $this->WAY_ID->CurrentValue;
        $this->PATIENT_CATEGORY_ID->CurrentValue = null;
        $this->PATIENT_CATEGORY_ID->OldValue = $this->PATIENT_CATEGORY_ID->CurrentValue;
        $this->BOOKED_DATE->CurrentValue = null;
        $this->BOOKED_DATE->OldValue = $this->BOOKED_DATE->CurrentValue;
        $this->VISIT_DATE->CurrentValue = null;
        $this->VISIT_DATE->OldValue = $this->VISIT_DATE->CurrentValue;
        $this->ISNEW->CurrentValue = null;
        $this->ISNEW->OldValue = $this->ISNEW->CurrentValue;
        $this->FOLLOW_UP->CurrentValue = null;
        $this->FOLLOW_UP->OldValue = $this->FOLLOW_UP->CurrentValue;
        $this->PLACE_TYPE->CurrentValue = null;
        $this->PLACE_TYPE->OldValue = $this->PLACE_TYPE->CurrentValue;
        $this->CLINIC_ID->CurrentValue = null;
        $this->CLINIC_ID->OldValue = $this->CLINIC_ID->CurrentValue;
        $this->CLINIC_ID_FROM->CurrentValue = null;
        $this->CLINIC_ID_FROM->OldValue = $this->CLINIC_ID_FROM->CurrentValue;
        $this->CLASS_ROOM_ID->CurrentValue = null;
        $this->CLASS_ROOM_ID->OldValue = $this->CLASS_ROOM_ID->CurrentValue;
        $this->BED_ID->CurrentValue = null;
        $this->BED_ID->OldValue = $this->BED_ID->CurrentValue;
        $this->KELUAR_ID->CurrentValue = null;
        $this->KELUAR_ID->OldValue = $this->KELUAR_ID->CurrentValue;
        $this->IN_DATE->CurrentValue = null;
        $this->IN_DATE->OldValue = $this->IN_DATE->CurrentValue;
        $this->EXIT_DATE->CurrentValue = null;
        $this->EXIT_DATE->OldValue = $this->EXIT_DATE->CurrentValue;
        $this->DIANTAR_OLEH->CurrentValue = null;
        $this->DIANTAR_OLEH->OldValue = $this->DIANTAR_OLEH->CurrentValue;
        $this->GENDER->CurrentValue = null;
        $this->GENDER->OldValue = $this->GENDER->CurrentValue;
        $this->DESCRIPTION->CurrentValue = null;
        $this->DESCRIPTION->OldValue = $this->DESCRIPTION->CurrentValue;
        $this->VISITOR_ADDRESS->CurrentValue = null;
        $this->VISITOR_ADDRESS->OldValue = $this->VISITOR_ADDRESS->CurrentValue;
        $this->MODIFIED_BY->CurrentValue = null;
        $this->MODIFIED_BY->OldValue = $this->MODIFIED_BY->CurrentValue;
        $this->MODIFIED_DATE->CurrentValue = null;
        $this->MODIFIED_DATE->OldValue = $this->MODIFIED_DATE->CurrentValue;
        $this->MODIFIED_FROM->CurrentValue = null;
        $this->MODIFIED_FROM->OldValue = $this->MODIFIED_FROM->CurrentValue;
        $this->EMPLOYEE_ID->CurrentValue = null;
        $this->EMPLOYEE_ID->OldValue = $this->EMPLOYEE_ID->CurrentValue;
        $this->EMPLOYEE_ID_FROM->CurrentValue = null;
        $this->EMPLOYEE_ID_FROM->OldValue = $this->EMPLOYEE_ID_FROM->CurrentValue;
        $this->RESPONSIBLE_ID->CurrentValue = null;
        $this->RESPONSIBLE_ID->OldValue = $this->RESPONSIBLE_ID->CurrentValue;
        $this->RESPONSIBLE->CurrentValue = null;
        $this->RESPONSIBLE->OldValue = $this->RESPONSIBLE->CurrentValue;
        $this->FAMILY_STATUS_ID->CurrentValue = null;
        $this->FAMILY_STATUS_ID->OldValue = $this->FAMILY_STATUS_ID->CurrentValue;
        $this->TICKET_NO->CurrentValue = null;
        $this->TICKET_NO->OldValue = $this->TICKET_NO->CurrentValue;
        $this->ISATTENDED->CurrentValue = null;
        $this->ISATTENDED->OldValue = $this->ISATTENDED->CurrentValue;
        $this->PAYOR_ID->CurrentValue = null;
        $this->PAYOR_ID->OldValue = $this->PAYOR_ID->CurrentValue;
        $this->CLASS_ID->CurrentValue = null;
        $this->CLASS_ID->OldValue = $this->CLASS_ID->CurrentValue;
        $this->ISPERTARIF->CurrentValue = null;
        $this->ISPERTARIF->OldValue = $this->ISPERTARIF->CurrentValue;
        $this->KAL_ID->CurrentValue = null;
        $this->KAL_ID->OldValue = $this->KAL_ID->CurrentValue;
        $this->EMPLOYEE_INAP->CurrentValue = null;
        $this->EMPLOYEE_INAP->OldValue = $this->EMPLOYEE_INAP->CurrentValue;
        $this->PASIEN_ID->CurrentValue = null;
        $this->PASIEN_ID->OldValue = $this->PASIEN_ID->CurrentValue;
        $this->KARYAWAN->CurrentValue = null;
        $this->KARYAWAN->OldValue = $this->KARYAWAN->CurrentValue;
        $this->ACCOUNT_ID->CurrentValue = null;
        $this->ACCOUNT_ID->OldValue = $this->ACCOUNT_ID->CurrentValue;
        $this->CLASS_ID_PLAFOND->CurrentValue = null;
        $this->CLASS_ID_PLAFOND->OldValue = $this->CLASS_ID_PLAFOND->CurrentValue;
        $this->BACKCHARGE->CurrentValue = null;
        $this->BACKCHARGE->OldValue = $this->BACKCHARGE->CurrentValue;
        $this->COVERAGE_ID->CurrentValue = null;
        $this->COVERAGE_ID->OldValue = $this->COVERAGE_ID->CurrentValue;
        $this->AGEYEAR->CurrentValue = null;
        $this->AGEYEAR->OldValue = $this->AGEYEAR->CurrentValue;
        $this->AGEMONTH->CurrentValue = null;
        $this->AGEMONTH->OldValue = $this->AGEMONTH->CurrentValue;
        $this->AGEDAY->CurrentValue = null;
        $this->AGEDAY->OldValue = $this->AGEDAY->CurrentValue;
        $this->RECOMENDATION->CurrentValue = null;
        $this->RECOMENDATION->OldValue = $this->RECOMENDATION->CurrentValue;
        $this->CONCLUSION->CurrentValue = null;
        $this->CONCLUSION->OldValue = $this->CONCLUSION->CurrentValue;
        $this->SPECIMENNO->CurrentValue = null;
        $this->SPECIMENNO->OldValue = $this->SPECIMENNO->CurrentValue;
        $this->LOCKED->CurrentValue = null;
        $this->LOCKED->OldValue = $this->LOCKED->CurrentValue;
        $this->RM_OUT_DATE->CurrentValue = null;
        $this->RM_OUT_DATE->OldValue = $this->RM_OUT_DATE->CurrentValue;
        $this->RM_IN_DATE->CurrentValue = null;
        $this->RM_IN_DATE->OldValue = $this->RM_IN_DATE->CurrentValue;
        $this->LAMA_PINJAM->CurrentValue = null;
        $this->LAMA_PINJAM->OldValue = $this->LAMA_PINJAM->CurrentValue;
        $this->STANDAR_RJ->CurrentValue = null;
        $this->STANDAR_RJ->OldValue = $this->STANDAR_RJ->CurrentValue;
        $this->LENGKAP_RJ->CurrentValue = null;
        $this->LENGKAP_RJ->OldValue = $this->LENGKAP_RJ->CurrentValue;
        $this->LENGKAP_RI->CurrentValue = null;
        $this->LENGKAP_RI->OldValue = $this->LENGKAP_RI->CurrentValue;
        $this->RESEND_RM_DATE->CurrentValue = null;
        $this->RESEND_RM_DATE->OldValue = $this->RESEND_RM_DATE->CurrentValue;
        $this->LENGKAP_RM1->CurrentValue = null;
        $this->LENGKAP_RM1->OldValue = $this->LENGKAP_RM1->CurrentValue;
        $this->LENGKAP_RESUME->CurrentValue = null;
        $this->LENGKAP_RESUME->OldValue = $this->LENGKAP_RESUME->CurrentValue;
        $this->LENGKAP_ANAMNESIS->CurrentValue = null;
        $this->LENGKAP_ANAMNESIS->OldValue = $this->LENGKAP_ANAMNESIS->CurrentValue;
        $this->LENGKAP_CONSENT->CurrentValue = null;
        $this->LENGKAP_CONSENT->OldValue = $this->LENGKAP_CONSENT->CurrentValue;
        $this->LENGKAP_ANESTESI->CurrentValue = null;
        $this->LENGKAP_ANESTESI->OldValue = $this->LENGKAP_ANESTESI->CurrentValue;
        $this->LENGKAP_OP->CurrentValue = null;
        $this->LENGKAP_OP->OldValue = $this->LENGKAP_OP->CurrentValue;
        $this->BACK_RM_DATE->CurrentValue = null;
        $this->BACK_RM_DATE->OldValue = $this->BACK_RM_DATE->CurrentValue;
        $this->VALID_RM_DATE->CurrentValue = null;
        $this->VALID_RM_DATE->OldValue = $this->VALID_RM_DATE->CurrentValue;
        $this->NO_SKP->CurrentValue = null;
        $this->NO_SKP->OldValue = $this->NO_SKP->CurrentValue;
        $this->NO_SKPINAP->CurrentValue = null;
        $this->NO_SKPINAP->OldValue = $this->NO_SKPINAP->CurrentValue;
        $this->DIAGNOSA_ID->CurrentValue = null;
        $this->DIAGNOSA_ID->OldValue = $this->DIAGNOSA_ID->CurrentValue;
        $this->ticket_all->CurrentValue = null;
        $this->ticket_all->OldValue = $this->ticket_all->CurrentValue;
        $this->tanggal_rujukan->CurrentValue = null;
        $this->tanggal_rujukan->OldValue = $this->tanggal_rujukan->CurrentValue;
        $this->ISRJ->CurrentValue = null;
        $this->ISRJ->OldValue = $this->ISRJ->CurrentValue;
        $this->NORUJUKAN->CurrentValue = null;
        $this->NORUJUKAN->OldValue = $this->NORUJUKAN->CurrentValue;
        $this->PPKRUJUKAN->CurrentValue = null;
        $this->PPKRUJUKAN->OldValue = $this->PPKRUJUKAN->CurrentValue;
        $this->LOKASILAKA->CurrentValue = null;
        $this->LOKASILAKA->OldValue = $this->LOKASILAKA->CurrentValue;
        $this->KDPOLI->CurrentValue = null;
        $this->KDPOLI->OldValue = $this->KDPOLI->CurrentValue;
        $this->EDIT_SEP->CurrentValue = null;
        $this->EDIT_SEP->OldValue = $this->EDIT_SEP->CurrentValue;
        $this->DELETE_SEP->CurrentValue = null;
        $this->DELETE_SEP->OldValue = $this->DELETE_SEP->CurrentValue;
        $this->KODE_AGAMA->CurrentValue = null;
        $this->KODE_AGAMA->OldValue = $this->KODE_AGAMA->CurrentValue;
        $this->DIAG_AWAL->CurrentValue = null;
        $this->DIAG_AWAL->OldValue = $this->DIAG_AWAL->CurrentValue;
        $this->AKTIF->CurrentValue = null;
        $this->AKTIF->OldValue = $this->AKTIF->CurrentValue;
        $this->BILL_INAP->CurrentValue = null;
        $this->BILL_INAP->OldValue = $this->BILL_INAP->CurrentValue;
        $this->SEP_PRINTDATE->CurrentValue = null;
        $this->SEP_PRINTDATE->OldValue = $this->SEP_PRINTDATE->CurrentValue;
        $this->MAPPING_SEP->CurrentValue = null;
        $this->MAPPING_SEP->OldValue = $this->MAPPING_SEP->CurrentValue;
        $this->TRANS_ID->CurrentValue = null;
        $this->TRANS_ID->OldValue = $this->TRANS_ID->CurrentValue;
        $this->KDPOLI_EKS->CurrentValue = null;
        $this->KDPOLI_EKS->OldValue = $this->KDPOLI_EKS->CurrentValue;
        $this->COB->CurrentValue = null;
        $this->COB->OldValue = $this->COB->CurrentValue;
        $this->PENJAMIN->CurrentValue = null;
        $this->PENJAMIN->OldValue = $this->PENJAMIN->CurrentValue;
        $this->ASALRUJUKAN->CurrentValue = null;
        $this->ASALRUJUKAN->OldValue = $this->ASALRUJUKAN->CurrentValue;
        $this->RESPONSEP->CurrentValue = null;
        $this->RESPONSEP->OldValue = $this->RESPONSEP->CurrentValue;
        $this->APPROVAL_DESC->CurrentValue = null;
        $this->APPROVAL_DESC->OldValue = $this->APPROVAL_DESC->CurrentValue;
        $this->APPROVAL_RESPONAJUKAN->CurrentValue = null;
        $this->APPROVAL_RESPONAJUKAN->OldValue = $this->APPROVAL_RESPONAJUKAN->CurrentValue;
        $this->APPROVAL_RESPONAPPROV->CurrentValue = null;
        $this->APPROVAL_RESPONAPPROV->OldValue = $this->APPROVAL_RESPONAPPROV->CurrentValue;
        $this->RESPONTGLPLG_DESC->CurrentValue = null;
        $this->RESPONTGLPLG_DESC->OldValue = $this->RESPONTGLPLG_DESC->CurrentValue;
        $this->RESPONPOST_VKLAIM->CurrentValue = null;
        $this->RESPONPOST_VKLAIM->OldValue = $this->RESPONPOST_VKLAIM->CurrentValue;
        $this->RESPONPUT_VKLAIM->CurrentValue = null;
        $this->RESPONPUT_VKLAIM->OldValue = $this->RESPONPUT_VKLAIM->CurrentValue;
        $this->RESPONDEL_VKLAIM->CurrentValue = null;
        $this->RESPONDEL_VKLAIM->OldValue = $this->RESPONDEL_VKLAIM->CurrentValue;
        $this->CALL_TIMES->CurrentValue = null;
        $this->CALL_TIMES->OldValue = $this->CALL_TIMES->CurrentValue;
        $this->CALL_DATE->CurrentValue = null;
        $this->CALL_DATE->OldValue = $this->CALL_DATE->CurrentValue;
        $this->CALL_DATES->CurrentValue = null;
        $this->CALL_DATES->OldValue = $this->CALL_DATES->CurrentValue;
        $this->SERVED_DATE->CurrentValue = null;
        $this->SERVED_DATE->OldValue = $this->SERVED_DATE->CurrentValue;
        $this->SERVED_INAP->CurrentValue = null;
        $this->SERVED_INAP->OldValue = $this->SERVED_INAP->CurrentValue;
        $this->KDDPJP1->CurrentValue = null;
        $this->KDDPJP1->OldValue = $this->KDDPJP1->CurrentValue;
        $this->KDDPJP->CurrentValue = null;
        $this->KDDPJP->OldValue = $this->KDDPJP->CurrentValue;
        $this->IDXDAFTAR->CurrentValue = null;
        $this->IDXDAFTAR->OldValue = $this->IDXDAFTAR->CurrentValue;
        $this->tgl_kontrol->CurrentValue = null;
        $this->tgl_kontrol->OldValue = $this->tgl_kontrol->CurrentValue;
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

        // Check field name 'NO_REGISTRATION' first before field var 'x_NO_REGISTRATION'
        $val = $CurrentForm->hasValue("NO_REGISTRATION") ? $CurrentForm->getValue("NO_REGISTRATION") : $CurrentForm->getValue("x_NO_REGISTRATION");
        if (!$this->NO_REGISTRATION->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->NO_REGISTRATION->Visible = false; // Disable update for API request
            } else {
                $this->NO_REGISTRATION->setFormValue($val);
            }
        }

        // Check field name 'VISIT_ID' first before field var 'x_VISIT_ID'
        $val = $CurrentForm->hasValue("VISIT_ID") ? $CurrentForm->getValue("VISIT_ID") : $CurrentForm->getValue("x_VISIT_ID");
        if (!$this->VISIT_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->VISIT_ID->Visible = false; // Disable update for API request
            } else {
                $this->VISIT_ID->setFormValue($val);
            }
        }

        // Check field name 'STATUS_PASIEN_ID' first before field var 'x_STATUS_PASIEN_ID'
        $val = $CurrentForm->hasValue("STATUS_PASIEN_ID") ? $CurrentForm->getValue("STATUS_PASIEN_ID") : $CurrentForm->getValue("x_STATUS_PASIEN_ID");
        if (!$this->STATUS_PASIEN_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->STATUS_PASIEN_ID->Visible = false; // Disable update for API request
            } else {
                $this->STATUS_PASIEN_ID->setFormValue($val);
            }
        }

        // Check field name 'RUJUKAN_ID' first before field var 'x_RUJUKAN_ID'
        $val = $CurrentForm->hasValue("RUJUKAN_ID") ? $CurrentForm->getValue("RUJUKAN_ID") : $CurrentForm->getValue("x_RUJUKAN_ID");
        if (!$this->RUJUKAN_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->RUJUKAN_ID->Visible = false; // Disable update for API request
            } else {
                $this->RUJUKAN_ID->setFormValue($val);
            }
        }

        // Check field name 'ADDRESS_OF_RUJUKAN' first before field var 'x_ADDRESS_OF_RUJUKAN'
        $val = $CurrentForm->hasValue("ADDRESS_OF_RUJUKAN") ? $CurrentForm->getValue("ADDRESS_OF_RUJUKAN") : $CurrentForm->getValue("x_ADDRESS_OF_RUJUKAN");
        if (!$this->ADDRESS_OF_RUJUKAN->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ADDRESS_OF_RUJUKAN->Visible = false; // Disable update for API request
            } else {
                $this->ADDRESS_OF_RUJUKAN->setFormValue($val);
            }
        }

        // Check field name 'REASON_ID' first before field var 'x_REASON_ID'
        $val = $CurrentForm->hasValue("REASON_ID") ? $CurrentForm->getValue("REASON_ID") : $CurrentForm->getValue("x_REASON_ID");
        if (!$this->REASON_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->REASON_ID->Visible = false; // Disable update for API request
            } else {
                $this->REASON_ID->setFormValue($val);
            }
        }

        // Check field name 'WAY_ID' first before field var 'x_WAY_ID'
        $val = $CurrentForm->hasValue("WAY_ID") ? $CurrentForm->getValue("WAY_ID") : $CurrentForm->getValue("x_WAY_ID");
        if (!$this->WAY_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->WAY_ID->Visible = false; // Disable update for API request
            } else {
                $this->WAY_ID->setFormValue($val);
            }
        }

        // Check field name 'PATIENT_CATEGORY_ID' first before field var 'x_PATIENT_CATEGORY_ID'
        $val = $CurrentForm->hasValue("PATIENT_CATEGORY_ID") ? $CurrentForm->getValue("PATIENT_CATEGORY_ID") : $CurrentForm->getValue("x_PATIENT_CATEGORY_ID");
        if (!$this->PATIENT_CATEGORY_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->PATIENT_CATEGORY_ID->Visible = false; // Disable update for API request
            } else {
                $this->PATIENT_CATEGORY_ID->setFormValue($val);
            }
        }

        // Check field name 'BOOKED_DATE' first before field var 'x_BOOKED_DATE'
        $val = $CurrentForm->hasValue("BOOKED_DATE") ? $CurrentForm->getValue("BOOKED_DATE") : $CurrentForm->getValue("x_BOOKED_DATE");
        if (!$this->BOOKED_DATE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->BOOKED_DATE->Visible = false; // Disable update for API request
            } else {
                $this->BOOKED_DATE->setFormValue($val);
            }
            $this->BOOKED_DATE->CurrentValue = UnFormatDateTime($this->BOOKED_DATE->CurrentValue, 0);
        }

        // Check field name 'VISIT_DATE' first before field var 'x_VISIT_DATE'
        $val = $CurrentForm->hasValue("VISIT_DATE") ? $CurrentForm->getValue("VISIT_DATE") : $CurrentForm->getValue("x_VISIT_DATE");
        if (!$this->VISIT_DATE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->VISIT_DATE->Visible = false; // Disable update for API request
            } else {
                $this->VISIT_DATE->setFormValue($val);
            }
            $this->VISIT_DATE->CurrentValue = UnFormatDateTime($this->VISIT_DATE->CurrentValue, 0);
        }

        // Check field name 'ISNEW' first before field var 'x_ISNEW'
        $val = $CurrentForm->hasValue("ISNEW") ? $CurrentForm->getValue("ISNEW") : $CurrentForm->getValue("x_ISNEW");
        if (!$this->ISNEW->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ISNEW->Visible = false; // Disable update for API request
            } else {
                $this->ISNEW->setFormValue($val);
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

        // Check field name 'PLACE_TYPE' first before field var 'x_PLACE_TYPE'
        $val = $CurrentForm->hasValue("PLACE_TYPE") ? $CurrentForm->getValue("PLACE_TYPE") : $CurrentForm->getValue("x_PLACE_TYPE");
        if (!$this->PLACE_TYPE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->PLACE_TYPE->Visible = false; // Disable update for API request
            } else {
                $this->PLACE_TYPE->setFormValue($val);
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

        // Check field name 'CLINIC_ID_FROM' first before field var 'x_CLINIC_ID_FROM'
        $val = $CurrentForm->hasValue("CLINIC_ID_FROM") ? $CurrentForm->getValue("CLINIC_ID_FROM") : $CurrentForm->getValue("x_CLINIC_ID_FROM");
        if (!$this->CLINIC_ID_FROM->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->CLINIC_ID_FROM->Visible = false; // Disable update for API request
            } else {
                $this->CLINIC_ID_FROM->setFormValue($val);
            }
        }

        // Check field name 'CLASS_ROOM_ID' first before field var 'x_CLASS_ROOM_ID'
        $val = $CurrentForm->hasValue("CLASS_ROOM_ID") ? $CurrentForm->getValue("CLASS_ROOM_ID") : $CurrentForm->getValue("x_CLASS_ROOM_ID");
        if (!$this->CLASS_ROOM_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->CLASS_ROOM_ID->Visible = false; // Disable update for API request
            } else {
                $this->CLASS_ROOM_ID->setFormValue($val);
            }
        }

        // Check field name 'BED_ID' first before field var 'x_BED_ID'
        $val = $CurrentForm->hasValue("BED_ID") ? $CurrentForm->getValue("BED_ID") : $CurrentForm->getValue("x_BED_ID");
        if (!$this->BED_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->BED_ID->Visible = false; // Disable update for API request
            } else {
                $this->BED_ID->setFormValue($val);
            }
        }

        // Check field name 'KELUAR_ID' first before field var 'x_KELUAR_ID'
        $val = $CurrentForm->hasValue("KELUAR_ID") ? $CurrentForm->getValue("KELUAR_ID") : $CurrentForm->getValue("x_KELUAR_ID");
        if (!$this->KELUAR_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->KELUAR_ID->Visible = false; // Disable update for API request
            } else {
                $this->KELUAR_ID->setFormValue($val);
            }
        }

        // Check field name 'IN_DATE' first before field var 'x_IN_DATE'
        $val = $CurrentForm->hasValue("IN_DATE") ? $CurrentForm->getValue("IN_DATE") : $CurrentForm->getValue("x_IN_DATE");
        if (!$this->IN_DATE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->IN_DATE->Visible = false; // Disable update for API request
            } else {
                $this->IN_DATE->setFormValue($val);
            }
            $this->IN_DATE->CurrentValue = UnFormatDateTime($this->IN_DATE->CurrentValue, 0);
        }

        // Check field name 'EXIT_DATE' first before field var 'x_EXIT_DATE'
        $val = $CurrentForm->hasValue("EXIT_DATE") ? $CurrentForm->getValue("EXIT_DATE") : $CurrentForm->getValue("x_EXIT_DATE");
        if (!$this->EXIT_DATE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->EXIT_DATE->Visible = false; // Disable update for API request
            } else {
                $this->EXIT_DATE->setFormValue($val);
            }
            $this->EXIT_DATE->CurrentValue = UnFormatDateTime($this->EXIT_DATE->CurrentValue, 0);
        }

        // Check field name 'DIANTAR_OLEH' first before field var 'x_DIANTAR_OLEH'
        $val = $CurrentForm->hasValue("DIANTAR_OLEH") ? $CurrentForm->getValue("DIANTAR_OLEH") : $CurrentForm->getValue("x_DIANTAR_OLEH");
        if (!$this->DIANTAR_OLEH->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->DIANTAR_OLEH->Visible = false; // Disable update for API request
            } else {
                $this->DIANTAR_OLEH->setFormValue($val);
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

        // Check field name 'DESCRIPTION' first before field var 'x_DESCRIPTION'
        $val = $CurrentForm->hasValue("DESCRIPTION") ? $CurrentForm->getValue("DESCRIPTION") : $CurrentForm->getValue("x_DESCRIPTION");
        if (!$this->DESCRIPTION->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->DESCRIPTION->Visible = false; // Disable update for API request
            } else {
                $this->DESCRIPTION->setFormValue($val);
            }
        }

        // Check field name 'VISITOR_ADDRESS' first before field var 'x_VISITOR_ADDRESS'
        $val = $CurrentForm->hasValue("VISITOR_ADDRESS") ? $CurrentForm->getValue("VISITOR_ADDRESS") : $CurrentForm->getValue("x_VISITOR_ADDRESS");
        if (!$this->VISITOR_ADDRESS->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->VISITOR_ADDRESS->Visible = false; // Disable update for API request
            } else {
                $this->VISITOR_ADDRESS->setFormValue($val);
            }
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

        // Check field name 'MODIFIED_FROM' first before field var 'x_MODIFIED_FROM'
        $val = $CurrentForm->hasValue("MODIFIED_FROM") ? $CurrentForm->getValue("MODIFIED_FROM") : $CurrentForm->getValue("x_MODIFIED_FROM");
        if (!$this->MODIFIED_FROM->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->MODIFIED_FROM->Visible = false; // Disable update for API request
            } else {
                $this->MODIFIED_FROM->setFormValue($val);
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

        // Check field name 'EMPLOYEE_ID_FROM' first before field var 'x_EMPLOYEE_ID_FROM'
        $val = $CurrentForm->hasValue("EMPLOYEE_ID_FROM") ? $CurrentForm->getValue("EMPLOYEE_ID_FROM") : $CurrentForm->getValue("x_EMPLOYEE_ID_FROM");
        if (!$this->EMPLOYEE_ID_FROM->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->EMPLOYEE_ID_FROM->Visible = false; // Disable update for API request
            } else {
                $this->EMPLOYEE_ID_FROM->setFormValue($val);
            }
        }

        // Check field name 'RESPONSIBLE_ID' first before field var 'x_RESPONSIBLE_ID'
        $val = $CurrentForm->hasValue("RESPONSIBLE_ID") ? $CurrentForm->getValue("RESPONSIBLE_ID") : $CurrentForm->getValue("x_RESPONSIBLE_ID");
        if (!$this->RESPONSIBLE_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->RESPONSIBLE_ID->Visible = false; // Disable update for API request
            } else {
                $this->RESPONSIBLE_ID->setFormValue($val);
            }
        }

        // Check field name 'RESPONSIBLE' first before field var 'x_RESPONSIBLE'
        $val = $CurrentForm->hasValue("RESPONSIBLE") ? $CurrentForm->getValue("RESPONSIBLE") : $CurrentForm->getValue("x_RESPONSIBLE");
        if (!$this->RESPONSIBLE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->RESPONSIBLE->Visible = false; // Disable update for API request
            } else {
                $this->RESPONSIBLE->setFormValue($val);
            }
        }

        // Check field name 'FAMILY_STATUS_ID' first before field var 'x_FAMILY_STATUS_ID'
        $val = $CurrentForm->hasValue("FAMILY_STATUS_ID") ? $CurrentForm->getValue("FAMILY_STATUS_ID") : $CurrentForm->getValue("x_FAMILY_STATUS_ID");
        if (!$this->FAMILY_STATUS_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->FAMILY_STATUS_ID->Visible = false; // Disable update for API request
            } else {
                $this->FAMILY_STATUS_ID->setFormValue($val);
            }
        }

        // Check field name 'TICKET_NO' first before field var 'x_TICKET_NO'
        $val = $CurrentForm->hasValue("TICKET_NO") ? $CurrentForm->getValue("TICKET_NO") : $CurrentForm->getValue("x_TICKET_NO");
        if (!$this->TICKET_NO->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->TICKET_NO->Visible = false; // Disable update for API request
            } else {
                $this->TICKET_NO->setFormValue($val);
            }
        }

        // Check field name 'ISATTENDED' first before field var 'x_ISATTENDED'
        $val = $CurrentForm->hasValue("ISATTENDED") ? $CurrentForm->getValue("ISATTENDED") : $CurrentForm->getValue("x_ISATTENDED");
        if (!$this->ISATTENDED->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ISATTENDED->Visible = false; // Disable update for API request
            } else {
                $this->ISATTENDED->setFormValue($val);
            }
        }

        // Check field name 'PAYOR_ID' first before field var 'x_PAYOR_ID'
        $val = $CurrentForm->hasValue("PAYOR_ID") ? $CurrentForm->getValue("PAYOR_ID") : $CurrentForm->getValue("x_PAYOR_ID");
        if (!$this->PAYOR_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->PAYOR_ID->Visible = false; // Disable update for API request
            } else {
                $this->PAYOR_ID->setFormValue($val);
            }
        }

        // Check field name 'CLASS_ID' first before field var 'x_CLASS_ID'
        $val = $CurrentForm->hasValue("CLASS_ID") ? $CurrentForm->getValue("CLASS_ID") : $CurrentForm->getValue("x_CLASS_ID");
        if (!$this->CLASS_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->CLASS_ID->Visible = false; // Disable update for API request
            } else {
                $this->CLASS_ID->setFormValue($val);
            }
        }

        // Check field name 'ISPERTARIF' first before field var 'x_ISPERTARIF'
        $val = $CurrentForm->hasValue("ISPERTARIF") ? $CurrentForm->getValue("ISPERTARIF") : $CurrentForm->getValue("x_ISPERTARIF");
        if (!$this->ISPERTARIF->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ISPERTARIF->Visible = false; // Disable update for API request
            } else {
                $this->ISPERTARIF->setFormValue($val);
            }
        }

        // Check field name 'KAL_ID' first before field var 'x_KAL_ID'
        $val = $CurrentForm->hasValue("KAL_ID") ? $CurrentForm->getValue("KAL_ID") : $CurrentForm->getValue("x_KAL_ID");
        if (!$this->KAL_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->KAL_ID->Visible = false; // Disable update for API request
            } else {
                $this->KAL_ID->setFormValue($val);
            }
        }

        // Check field name 'EMPLOYEE_INAP' first before field var 'x_EMPLOYEE_INAP'
        $val = $CurrentForm->hasValue("EMPLOYEE_INAP") ? $CurrentForm->getValue("EMPLOYEE_INAP") : $CurrentForm->getValue("x_EMPLOYEE_INAP");
        if (!$this->EMPLOYEE_INAP->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->EMPLOYEE_INAP->Visible = false; // Disable update for API request
            } else {
                $this->EMPLOYEE_INAP->setFormValue($val);
            }
        }

        // Check field name 'PASIEN_ID' first before field var 'x_PASIEN_ID'
        $val = $CurrentForm->hasValue("PASIEN_ID") ? $CurrentForm->getValue("PASIEN_ID") : $CurrentForm->getValue("x_PASIEN_ID");
        if (!$this->PASIEN_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->PASIEN_ID->Visible = false; // Disable update for API request
            } else {
                $this->PASIEN_ID->setFormValue($val);
            }
        }

        // Check field name 'KARYAWAN' first before field var 'x_KARYAWAN'
        $val = $CurrentForm->hasValue("KARYAWAN") ? $CurrentForm->getValue("KARYAWAN") : $CurrentForm->getValue("x_KARYAWAN");
        if (!$this->KARYAWAN->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->KARYAWAN->Visible = false; // Disable update for API request
            } else {
                $this->KARYAWAN->setFormValue($val);
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

        // Check field name 'CLASS_ID_PLAFOND' first before field var 'x_CLASS_ID_PLAFOND'
        $val = $CurrentForm->hasValue("CLASS_ID_PLAFOND") ? $CurrentForm->getValue("CLASS_ID_PLAFOND") : $CurrentForm->getValue("x_CLASS_ID_PLAFOND");
        if (!$this->CLASS_ID_PLAFOND->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->CLASS_ID_PLAFOND->Visible = false; // Disable update for API request
            } else {
                $this->CLASS_ID_PLAFOND->setFormValue($val);
            }
        }

        // Check field name 'BACKCHARGE' first before field var 'x_BACKCHARGE'
        $val = $CurrentForm->hasValue("BACKCHARGE") ? $CurrentForm->getValue("BACKCHARGE") : $CurrentForm->getValue("x_BACKCHARGE");
        if (!$this->BACKCHARGE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->BACKCHARGE->Visible = false; // Disable update for API request
            } else {
                $this->BACKCHARGE->setFormValue($val);
            }
        }

        // Check field name 'COVERAGE_ID' first before field var 'x_COVERAGE_ID'
        $val = $CurrentForm->hasValue("COVERAGE_ID") ? $CurrentForm->getValue("COVERAGE_ID") : $CurrentForm->getValue("x_COVERAGE_ID");
        if (!$this->COVERAGE_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->COVERAGE_ID->Visible = false; // Disable update for API request
            } else {
                $this->COVERAGE_ID->setFormValue($val);
            }
        }

        // Check field name 'AGEYEAR' first before field var 'x_AGEYEAR'
        $val = $CurrentForm->hasValue("AGEYEAR") ? $CurrentForm->getValue("AGEYEAR") : $CurrentForm->getValue("x_AGEYEAR");
        if (!$this->AGEYEAR->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->AGEYEAR->Visible = false; // Disable update for API request
            } else {
                $this->AGEYEAR->setFormValue($val);
            }
        }

        // Check field name 'AGEMONTH' first before field var 'x_AGEMONTH'
        $val = $CurrentForm->hasValue("AGEMONTH") ? $CurrentForm->getValue("AGEMONTH") : $CurrentForm->getValue("x_AGEMONTH");
        if (!$this->AGEMONTH->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->AGEMONTH->Visible = false; // Disable update for API request
            } else {
                $this->AGEMONTH->setFormValue($val);
            }
        }

        // Check field name 'AGEDAY' first before field var 'x_AGEDAY'
        $val = $CurrentForm->hasValue("AGEDAY") ? $CurrentForm->getValue("AGEDAY") : $CurrentForm->getValue("x_AGEDAY");
        if (!$this->AGEDAY->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->AGEDAY->Visible = false; // Disable update for API request
            } else {
                $this->AGEDAY->setFormValue($val);
            }
        }

        // Check field name 'RECOMENDATION' first before field var 'x_RECOMENDATION'
        $val = $CurrentForm->hasValue("RECOMENDATION") ? $CurrentForm->getValue("RECOMENDATION") : $CurrentForm->getValue("x_RECOMENDATION");
        if (!$this->RECOMENDATION->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->RECOMENDATION->Visible = false; // Disable update for API request
            } else {
                $this->RECOMENDATION->setFormValue($val);
            }
        }

        // Check field name 'CONCLUSION' first before field var 'x_CONCLUSION'
        $val = $CurrentForm->hasValue("CONCLUSION") ? $CurrentForm->getValue("CONCLUSION") : $CurrentForm->getValue("x_CONCLUSION");
        if (!$this->CONCLUSION->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->CONCLUSION->Visible = false; // Disable update for API request
            } else {
                $this->CONCLUSION->setFormValue($val);
            }
        }

        // Check field name 'SPECIMENNO' first before field var 'x_SPECIMENNO'
        $val = $CurrentForm->hasValue("SPECIMENNO") ? $CurrentForm->getValue("SPECIMENNO") : $CurrentForm->getValue("x_SPECIMENNO");
        if (!$this->SPECIMENNO->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->SPECIMENNO->Visible = false; // Disable update for API request
            } else {
                $this->SPECIMENNO->setFormValue($val);
            }
        }

        // Check field name 'LOCKED' first before field var 'x_LOCKED'
        $val = $CurrentForm->hasValue("LOCKED") ? $CurrentForm->getValue("LOCKED") : $CurrentForm->getValue("x_LOCKED");
        if (!$this->LOCKED->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->LOCKED->Visible = false; // Disable update for API request
            } else {
                $this->LOCKED->setFormValue($val);
            }
        }

        // Check field name 'RM_OUT_DATE' first before field var 'x_RM_OUT_DATE'
        $val = $CurrentForm->hasValue("RM_OUT_DATE") ? $CurrentForm->getValue("RM_OUT_DATE") : $CurrentForm->getValue("x_RM_OUT_DATE");
        if (!$this->RM_OUT_DATE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->RM_OUT_DATE->Visible = false; // Disable update for API request
            } else {
                $this->RM_OUT_DATE->setFormValue($val);
            }
            $this->RM_OUT_DATE->CurrentValue = UnFormatDateTime($this->RM_OUT_DATE->CurrentValue, 0);
        }

        // Check field name 'RM_IN_DATE' first before field var 'x_RM_IN_DATE'
        $val = $CurrentForm->hasValue("RM_IN_DATE") ? $CurrentForm->getValue("RM_IN_DATE") : $CurrentForm->getValue("x_RM_IN_DATE");
        if (!$this->RM_IN_DATE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->RM_IN_DATE->Visible = false; // Disable update for API request
            } else {
                $this->RM_IN_DATE->setFormValue($val);
            }
            $this->RM_IN_DATE->CurrentValue = UnFormatDateTime($this->RM_IN_DATE->CurrentValue, 0);
        }

        // Check field name 'LAMA_PINJAM' first before field var 'x_LAMA_PINJAM'
        $val = $CurrentForm->hasValue("LAMA_PINJAM") ? $CurrentForm->getValue("LAMA_PINJAM") : $CurrentForm->getValue("x_LAMA_PINJAM");
        if (!$this->LAMA_PINJAM->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->LAMA_PINJAM->Visible = false; // Disable update for API request
            } else {
                $this->LAMA_PINJAM->setFormValue($val);
            }
            $this->LAMA_PINJAM->CurrentValue = UnFormatDateTime($this->LAMA_PINJAM->CurrentValue, 0);
        }

        // Check field name 'STANDAR_RJ' first before field var 'x_STANDAR_RJ'
        $val = $CurrentForm->hasValue("STANDAR_RJ") ? $CurrentForm->getValue("STANDAR_RJ") : $CurrentForm->getValue("x_STANDAR_RJ");
        if (!$this->STANDAR_RJ->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->STANDAR_RJ->Visible = false; // Disable update for API request
            } else {
                $this->STANDAR_RJ->setFormValue($val);
            }
        }

        // Check field name 'LENGKAP_RJ' first before field var 'x_LENGKAP_RJ'
        $val = $CurrentForm->hasValue("LENGKAP_RJ") ? $CurrentForm->getValue("LENGKAP_RJ") : $CurrentForm->getValue("x_LENGKAP_RJ");
        if (!$this->LENGKAP_RJ->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->LENGKAP_RJ->Visible = false; // Disable update for API request
            } else {
                $this->LENGKAP_RJ->setFormValue($val);
            }
        }

        // Check field name 'LENGKAP_RI' first before field var 'x_LENGKAP_RI'
        $val = $CurrentForm->hasValue("LENGKAP_RI") ? $CurrentForm->getValue("LENGKAP_RI") : $CurrentForm->getValue("x_LENGKAP_RI");
        if (!$this->LENGKAP_RI->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->LENGKAP_RI->Visible = false; // Disable update for API request
            } else {
                $this->LENGKAP_RI->setFormValue($val);
            }
        }

        // Check field name 'RESEND_RM_DATE' first before field var 'x_RESEND_RM_DATE'
        $val = $CurrentForm->hasValue("RESEND_RM_DATE") ? $CurrentForm->getValue("RESEND_RM_DATE") : $CurrentForm->getValue("x_RESEND_RM_DATE");
        if (!$this->RESEND_RM_DATE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->RESEND_RM_DATE->Visible = false; // Disable update for API request
            } else {
                $this->RESEND_RM_DATE->setFormValue($val);
            }
            $this->RESEND_RM_DATE->CurrentValue = UnFormatDateTime($this->RESEND_RM_DATE->CurrentValue, 0);
        }

        // Check field name 'LENGKAP_RM1' first before field var 'x_LENGKAP_RM1'
        $val = $CurrentForm->hasValue("LENGKAP_RM1") ? $CurrentForm->getValue("LENGKAP_RM1") : $CurrentForm->getValue("x_LENGKAP_RM1");
        if (!$this->LENGKAP_RM1->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->LENGKAP_RM1->Visible = false; // Disable update for API request
            } else {
                $this->LENGKAP_RM1->setFormValue($val);
            }
        }

        // Check field name 'LENGKAP_RESUME' first before field var 'x_LENGKAP_RESUME'
        $val = $CurrentForm->hasValue("LENGKAP_RESUME") ? $CurrentForm->getValue("LENGKAP_RESUME") : $CurrentForm->getValue("x_LENGKAP_RESUME");
        if (!$this->LENGKAP_RESUME->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->LENGKAP_RESUME->Visible = false; // Disable update for API request
            } else {
                $this->LENGKAP_RESUME->setFormValue($val);
            }
        }

        // Check field name 'LENGKAP_ANAMNESIS' first before field var 'x_LENGKAP_ANAMNESIS'
        $val = $CurrentForm->hasValue("LENGKAP_ANAMNESIS") ? $CurrentForm->getValue("LENGKAP_ANAMNESIS") : $CurrentForm->getValue("x_LENGKAP_ANAMNESIS");
        if (!$this->LENGKAP_ANAMNESIS->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->LENGKAP_ANAMNESIS->Visible = false; // Disable update for API request
            } else {
                $this->LENGKAP_ANAMNESIS->setFormValue($val);
            }
        }

        // Check field name 'LENGKAP_CONSENT' first before field var 'x_LENGKAP_CONSENT'
        $val = $CurrentForm->hasValue("LENGKAP_CONSENT") ? $CurrentForm->getValue("LENGKAP_CONSENT") : $CurrentForm->getValue("x_LENGKAP_CONSENT");
        if (!$this->LENGKAP_CONSENT->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->LENGKAP_CONSENT->Visible = false; // Disable update for API request
            } else {
                $this->LENGKAP_CONSENT->setFormValue($val);
            }
        }

        // Check field name 'LENGKAP_ANESTESI' first before field var 'x_LENGKAP_ANESTESI'
        $val = $CurrentForm->hasValue("LENGKAP_ANESTESI") ? $CurrentForm->getValue("LENGKAP_ANESTESI") : $CurrentForm->getValue("x_LENGKAP_ANESTESI");
        if (!$this->LENGKAP_ANESTESI->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->LENGKAP_ANESTESI->Visible = false; // Disable update for API request
            } else {
                $this->LENGKAP_ANESTESI->setFormValue($val);
            }
        }

        // Check field name 'LENGKAP_OP' first before field var 'x_LENGKAP_OP'
        $val = $CurrentForm->hasValue("LENGKAP_OP") ? $CurrentForm->getValue("LENGKAP_OP") : $CurrentForm->getValue("x_LENGKAP_OP");
        if (!$this->LENGKAP_OP->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->LENGKAP_OP->Visible = false; // Disable update for API request
            } else {
                $this->LENGKAP_OP->setFormValue($val);
            }
        }

        // Check field name 'BACK_RM_DATE' first before field var 'x_BACK_RM_DATE'
        $val = $CurrentForm->hasValue("BACK_RM_DATE") ? $CurrentForm->getValue("BACK_RM_DATE") : $CurrentForm->getValue("x_BACK_RM_DATE");
        if (!$this->BACK_RM_DATE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->BACK_RM_DATE->Visible = false; // Disable update for API request
            } else {
                $this->BACK_RM_DATE->setFormValue($val);
            }
            $this->BACK_RM_DATE->CurrentValue = UnFormatDateTime($this->BACK_RM_DATE->CurrentValue, 0);
        }

        // Check field name 'VALID_RM_DATE' first before field var 'x_VALID_RM_DATE'
        $val = $CurrentForm->hasValue("VALID_RM_DATE") ? $CurrentForm->getValue("VALID_RM_DATE") : $CurrentForm->getValue("x_VALID_RM_DATE");
        if (!$this->VALID_RM_DATE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->VALID_RM_DATE->Visible = false; // Disable update for API request
            } else {
                $this->VALID_RM_DATE->setFormValue($val);
            }
            $this->VALID_RM_DATE->CurrentValue = UnFormatDateTime($this->VALID_RM_DATE->CurrentValue, 0);
        }

        // Check field name 'NO_SKP' first before field var 'x_NO_SKP'
        $val = $CurrentForm->hasValue("NO_SKP") ? $CurrentForm->getValue("NO_SKP") : $CurrentForm->getValue("x_NO_SKP");
        if (!$this->NO_SKP->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->NO_SKP->Visible = false; // Disable update for API request
            } else {
                $this->NO_SKP->setFormValue($val);
            }
        }

        // Check field name 'NO_SKPINAP' first before field var 'x_NO_SKPINAP'
        $val = $CurrentForm->hasValue("NO_SKPINAP") ? $CurrentForm->getValue("NO_SKPINAP") : $CurrentForm->getValue("x_NO_SKPINAP");
        if (!$this->NO_SKPINAP->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->NO_SKPINAP->Visible = false; // Disable update for API request
            } else {
                $this->NO_SKPINAP->setFormValue($val);
            }
        }

        // Check field name 'DIAGNOSA_ID' first before field var 'x_DIAGNOSA_ID'
        $val = $CurrentForm->hasValue("DIAGNOSA_ID") ? $CurrentForm->getValue("DIAGNOSA_ID") : $CurrentForm->getValue("x_DIAGNOSA_ID");
        if (!$this->DIAGNOSA_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->DIAGNOSA_ID->Visible = false; // Disable update for API request
            } else {
                $this->DIAGNOSA_ID->setFormValue($val);
            }
        }

        // Check field name 'ticket_all' first before field var 'x_ticket_all'
        $val = $CurrentForm->hasValue("ticket_all") ? $CurrentForm->getValue("ticket_all") : $CurrentForm->getValue("x_ticket_all");
        if (!$this->ticket_all->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ticket_all->Visible = false; // Disable update for API request
            } else {
                $this->ticket_all->setFormValue($val);
            }
        }

        // Check field name 'tanggal_rujukan' first before field var 'x_tanggal_rujukan'
        $val = $CurrentForm->hasValue("tanggal_rujukan") ? $CurrentForm->getValue("tanggal_rujukan") : $CurrentForm->getValue("x_tanggal_rujukan");
        if (!$this->tanggal_rujukan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tanggal_rujukan->Visible = false; // Disable update for API request
            } else {
                $this->tanggal_rujukan->setFormValue($val);
            }
            $this->tanggal_rujukan->CurrentValue = UnFormatDateTime($this->tanggal_rujukan->CurrentValue, 0);
        }

        // Check field name 'ISRJ' first before field var 'x_ISRJ'
        $val = $CurrentForm->hasValue("ISRJ") ? $CurrentForm->getValue("ISRJ") : $CurrentForm->getValue("x_ISRJ");
        if (!$this->ISRJ->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ISRJ->Visible = false; // Disable update for API request
            } else {
                $this->ISRJ->setFormValue($val);
            }
        }

        // Check field name 'NORUJUKAN' first before field var 'x_NORUJUKAN'
        $val = $CurrentForm->hasValue("NORUJUKAN") ? $CurrentForm->getValue("NORUJUKAN") : $CurrentForm->getValue("x_NORUJUKAN");
        if (!$this->NORUJUKAN->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->NORUJUKAN->Visible = false; // Disable update for API request
            } else {
                $this->NORUJUKAN->setFormValue($val);
            }
        }

        // Check field name 'PPKRUJUKAN' first before field var 'x_PPKRUJUKAN'
        $val = $CurrentForm->hasValue("PPKRUJUKAN") ? $CurrentForm->getValue("PPKRUJUKAN") : $CurrentForm->getValue("x_PPKRUJUKAN");
        if (!$this->PPKRUJUKAN->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->PPKRUJUKAN->Visible = false; // Disable update for API request
            } else {
                $this->PPKRUJUKAN->setFormValue($val);
            }
        }

        // Check field name 'LOKASILAKA' first before field var 'x_LOKASILAKA'
        $val = $CurrentForm->hasValue("LOKASILAKA") ? $CurrentForm->getValue("LOKASILAKA") : $CurrentForm->getValue("x_LOKASILAKA");
        if (!$this->LOKASILAKA->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->LOKASILAKA->Visible = false; // Disable update for API request
            } else {
                $this->LOKASILAKA->setFormValue($val);
            }
        }

        // Check field name 'KDPOLI' first before field var 'x_KDPOLI'
        $val = $CurrentForm->hasValue("KDPOLI") ? $CurrentForm->getValue("KDPOLI") : $CurrentForm->getValue("x_KDPOLI");
        if (!$this->KDPOLI->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->KDPOLI->Visible = false; // Disable update for API request
            } else {
                $this->KDPOLI->setFormValue($val);
            }
        }

        // Check field name 'EDIT_SEP' first before field var 'x_EDIT_SEP'
        $val = $CurrentForm->hasValue("EDIT_SEP") ? $CurrentForm->getValue("EDIT_SEP") : $CurrentForm->getValue("x_EDIT_SEP");
        if (!$this->EDIT_SEP->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->EDIT_SEP->Visible = false; // Disable update for API request
            } else {
                $this->EDIT_SEP->setFormValue($val);
            }
        }

        // Check field name 'DELETE_SEP' first before field var 'x_DELETE_SEP'
        $val = $CurrentForm->hasValue("DELETE_SEP") ? $CurrentForm->getValue("DELETE_SEP") : $CurrentForm->getValue("x_DELETE_SEP");
        if (!$this->DELETE_SEP->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->DELETE_SEP->Visible = false; // Disable update for API request
            } else {
                $this->DELETE_SEP->setFormValue($val);
            }
        }

        // Check field name 'KODE_AGAMA' first before field var 'x_KODE_AGAMA'
        $val = $CurrentForm->hasValue("KODE_AGAMA") ? $CurrentForm->getValue("KODE_AGAMA") : $CurrentForm->getValue("x_KODE_AGAMA");
        if (!$this->KODE_AGAMA->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->KODE_AGAMA->Visible = false; // Disable update for API request
            } else {
                $this->KODE_AGAMA->setFormValue($val);
            }
        }

        // Check field name 'DIAG_AWAL' first before field var 'x_DIAG_AWAL'
        $val = $CurrentForm->hasValue("DIAG_AWAL") ? $CurrentForm->getValue("DIAG_AWAL") : $CurrentForm->getValue("x_DIAG_AWAL");
        if (!$this->DIAG_AWAL->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->DIAG_AWAL->Visible = false; // Disable update for API request
            } else {
                $this->DIAG_AWAL->setFormValue($val);
            }
        }

        // Check field name 'AKTIF' first before field var 'x_AKTIF'
        $val = $CurrentForm->hasValue("AKTIF") ? $CurrentForm->getValue("AKTIF") : $CurrentForm->getValue("x_AKTIF");
        if (!$this->AKTIF->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->AKTIF->Visible = false; // Disable update for API request
            } else {
                $this->AKTIF->setFormValue($val);
            }
        }

        // Check field name 'BILL_INAP' first before field var 'x_BILL_INAP'
        $val = $CurrentForm->hasValue("BILL_INAP") ? $CurrentForm->getValue("BILL_INAP") : $CurrentForm->getValue("x_BILL_INAP");
        if (!$this->BILL_INAP->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->BILL_INAP->Visible = false; // Disable update for API request
            } else {
                $this->BILL_INAP->setFormValue($val);
            }
        }

        // Check field name 'SEP_PRINTDATE' first before field var 'x_SEP_PRINTDATE'
        $val = $CurrentForm->hasValue("SEP_PRINTDATE") ? $CurrentForm->getValue("SEP_PRINTDATE") : $CurrentForm->getValue("x_SEP_PRINTDATE");
        if (!$this->SEP_PRINTDATE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->SEP_PRINTDATE->Visible = false; // Disable update for API request
            } else {
                $this->SEP_PRINTDATE->setFormValue($val);
            }
            $this->SEP_PRINTDATE->CurrentValue = UnFormatDateTime($this->SEP_PRINTDATE->CurrentValue, 0);
        }

        // Check field name 'MAPPING_SEP' first before field var 'x_MAPPING_SEP'
        $val = $CurrentForm->hasValue("MAPPING_SEP") ? $CurrentForm->getValue("MAPPING_SEP") : $CurrentForm->getValue("x_MAPPING_SEP");
        if (!$this->MAPPING_SEP->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->MAPPING_SEP->Visible = false; // Disable update for API request
            } else {
                $this->MAPPING_SEP->setFormValue($val);
            }
        }

        // Check field name 'TRANS_ID' first before field var 'x_TRANS_ID'
        $val = $CurrentForm->hasValue("TRANS_ID") ? $CurrentForm->getValue("TRANS_ID") : $CurrentForm->getValue("x_TRANS_ID");
        if (!$this->TRANS_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->TRANS_ID->Visible = false; // Disable update for API request
            } else {
                $this->TRANS_ID->setFormValue($val);
            }
        }

        // Check field name 'KDPOLI_EKS' first before field var 'x_KDPOLI_EKS'
        $val = $CurrentForm->hasValue("KDPOLI_EKS") ? $CurrentForm->getValue("KDPOLI_EKS") : $CurrentForm->getValue("x_KDPOLI_EKS");
        if (!$this->KDPOLI_EKS->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->KDPOLI_EKS->Visible = false; // Disable update for API request
            } else {
                $this->KDPOLI_EKS->setFormValue($val);
            }
        }

        // Check field name 'COB' first before field var 'x_COB'
        $val = $CurrentForm->hasValue("COB") ? $CurrentForm->getValue("COB") : $CurrentForm->getValue("x_COB");
        if (!$this->COB->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->COB->Visible = false; // Disable update for API request
            } else {
                $this->COB->setFormValue($val);
            }
        }

        // Check field name 'PENJAMIN' first before field var 'x_PENJAMIN'
        $val = $CurrentForm->hasValue("PENJAMIN") ? $CurrentForm->getValue("PENJAMIN") : $CurrentForm->getValue("x_PENJAMIN");
        if (!$this->PENJAMIN->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->PENJAMIN->Visible = false; // Disable update for API request
            } else {
                $this->PENJAMIN->setFormValue($val);
            }
        }

        // Check field name 'ASALRUJUKAN' first before field var 'x_ASALRUJUKAN'
        $val = $CurrentForm->hasValue("ASALRUJUKAN") ? $CurrentForm->getValue("ASALRUJUKAN") : $CurrentForm->getValue("x_ASALRUJUKAN");
        if (!$this->ASALRUJUKAN->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ASALRUJUKAN->Visible = false; // Disable update for API request
            } else {
                $this->ASALRUJUKAN->setFormValue($val);
            }
        }

        // Check field name 'RESPONSEP' first before field var 'x_RESPONSEP'
        $val = $CurrentForm->hasValue("RESPONSEP") ? $CurrentForm->getValue("RESPONSEP") : $CurrentForm->getValue("x_RESPONSEP");
        if (!$this->RESPONSEP->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->RESPONSEP->Visible = false; // Disable update for API request
            } else {
                $this->RESPONSEP->setFormValue($val);
            }
        }

        // Check field name 'APPROVAL_DESC' first before field var 'x_APPROVAL_DESC'
        $val = $CurrentForm->hasValue("APPROVAL_DESC") ? $CurrentForm->getValue("APPROVAL_DESC") : $CurrentForm->getValue("x_APPROVAL_DESC");
        if (!$this->APPROVAL_DESC->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->APPROVAL_DESC->Visible = false; // Disable update for API request
            } else {
                $this->APPROVAL_DESC->setFormValue($val);
            }
        }

        // Check field name 'APPROVAL_RESPONAJUKAN' first before field var 'x_APPROVAL_RESPONAJUKAN'
        $val = $CurrentForm->hasValue("APPROVAL_RESPONAJUKAN") ? $CurrentForm->getValue("APPROVAL_RESPONAJUKAN") : $CurrentForm->getValue("x_APPROVAL_RESPONAJUKAN");
        if (!$this->APPROVAL_RESPONAJUKAN->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->APPROVAL_RESPONAJUKAN->Visible = false; // Disable update for API request
            } else {
                $this->APPROVAL_RESPONAJUKAN->setFormValue($val);
            }
        }

        // Check field name 'APPROVAL_RESPONAPPROV' first before field var 'x_APPROVAL_RESPONAPPROV'
        $val = $CurrentForm->hasValue("APPROVAL_RESPONAPPROV") ? $CurrentForm->getValue("APPROVAL_RESPONAPPROV") : $CurrentForm->getValue("x_APPROVAL_RESPONAPPROV");
        if (!$this->APPROVAL_RESPONAPPROV->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->APPROVAL_RESPONAPPROV->Visible = false; // Disable update for API request
            } else {
                $this->APPROVAL_RESPONAPPROV->setFormValue($val);
            }
        }

        // Check field name 'RESPONTGLPLG_DESC' first before field var 'x_RESPONTGLPLG_DESC'
        $val = $CurrentForm->hasValue("RESPONTGLPLG_DESC") ? $CurrentForm->getValue("RESPONTGLPLG_DESC") : $CurrentForm->getValue("x_RESPONTGLPLG_DESC");
        if (!$this->RESPONTGLPLG_DESC->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->RESPONTGLPLG_DESC->Visible = false; // Disable update for API request
            } else {
                $this->RESPONTGLPLG_DESC->setFormValue($val);
            }
        }

        // Check field name 'RESPONPOST_VKLAIM' first before field var 'x_RESPONPOST_VKLAIM'
        $val = $CurrentForm->hasValue("RESPONPOST_VKLAIM") ? $CurrentForm->getValue("RESPONPOST_VKLAIM") : $CurrentForm->getValue("x_RESPONPOST_VKLAIM");
        if (!$this->RESPONPOST_VKLAIM->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->RESPONPOST_VKLAIM->Visible = false; // Disable update for API request
            } else {
                $this->RESPONPOST_VKLAIM->setFormValue($val);
            }
        }

        // Check field name 'RESPONPUT_VKLAIM' first before field var 'x_RESPONPUT_VKLAIM'
        $val = $CurrentForm->hasValue("RESPONPUT_VKLAIM") ? $CurrentForm->getValue("RESPONPUT_VKLAIM") : $CurrentForm->getValue("x_RESPONPUT_VKLAIM");
        if (!$this->RESPONPUT_VKLAIM->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->RESPONPUT_VKLAIM->Visible = false; // Disable update for API request
            } else {
                $this->RESPONPUT_VKLAIM->setFormValue($val);
            }
        }

        // Check field name 'RESPONDEL_VKLAIM' first before field var 'x_RESPONDEL_VKLAIM'
        $val = $CurrentForm->hasValue("RESPONDEL_VKLAIM") ? $CurrentForm->getValue("RESPONDEL_VKLAIM") : $CurrentForm->getValue("x_RESPONDEL_VKLAIM");
        if (!$this->RESPONDEL_VKLAIM->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->RESPONDEL_VKLAIM->Visible = false; // Disable update for API request
            } else {
                $this->RESPONDEL_VKLAIM->setFormValue($val);
            }
        }

        // Check field name 'CALL_TIMES' first before field var 'x_CALL_TIMES'
        $val = $CurrentForm->hasValue("CALL_TIMES") ? $CurrentForm->getValue("CALL_TIMES") : $CurrentForm->getValue("x_CALL_TIMES");
        if (!$this->CALL_TIMES->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->CALL_TIMES->Visible = false; // Disable update for API request
            } else {
                $this->CALL_TIMES->setFormValue($val);
            }
        }

        // Check field name 'CALL_DATE' first before field var 'x_CALL_DATE'
        $val = $CurrentForm->hasValue("CALL_DATE") ? $CurrentForm->getValue("CALL_DATE") : $CurrentForm->getValue("x_CALL_DATE");
        if (!$this->CALL_DATE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->CALL_DATE->Visible = false; // Disable update for API request
            } else {
                $this->CALL_DATE->setFormValue($val);
            }
            $this->CALL_DATE->CurrentValue = UnFormatDateTime($this->CALL_DATE->CurrentValue, 0);
        }

        // Check field name 'CALL_DATES' first before field var 'x_CALL_DATES'
        $val = $CurrentForm->hasValue("CALL_DATES") ? $CurrentForm->getValue("CALL_DATES") : $CurrentForm->getValue("x_CALL_DATES");
        if (!$this->CALL_DATES->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->CALL_DATES->Visible = false; // Disable update for API request
            } else {
                $this->CALL_DATES->setFormValue($val);
            }
            $this->CALL_DATES->CurrentValue = UnFormatDateTime($this->CALL_DATES->CurrentValue, 0);
        }

        // Check field name 'SERVED_DATE' first before field var 'x_SERVED_DATE'
        $val = $CurrentForm->hasValue("SERVED_DATE") ? $CurrentForm->getValue("SERVED_DATE") : $CurrentForm->getValue("x_SERVED_DATE");
        if (!$this->SERVED_DATE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->SERVED_DATE->Visible = false; // Disable update for API request
            } else {
                $this->SERVED_DATE->setFormValue($val);
            }
            $this->SERVED_DATE->CurrentValue = UnFormatDateTime($this->SERVED_DATE->CurrentValue, 0);
        }

        // Check field name 'SERVED_INAP' first before field var 'x_SERVED_INAP'
        $val = $CurrentForm->hasValue("SERVED_INAP") ? $CurrentForm->getValue("SERVED_INAP") : $CurrentForm->getValue("x_SERVED_INAP");
        if (!$this->SERVED_INAP->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->SERVED_INAP->Visible = false; // Disable update for API request
            } else {
                $this->SERVED_INAP->setFormValue($val);
            }
            $this->SERVED_INAP->CurrentValue = UnFormatDateTime($this->SERVED_INAP->CurrentValue, 0);
        }

        // Check field name 'KDDPJP1' first before field var 'x_KDDPJP1'
        $val = $CurrentForm->hasValue("KDDPJP1") ? $CurrentForm->getValue("KDDPJP1") : $CurrentForm->getValue("x_KDDPJP1");
        if (!$this->KDDPJP1->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->KDDPJP1->Visible = false; // Disable update for API request
            } else {
                $this->KDDPJP1->setFormValue($val);
            }
        }

        // Check field name 'KDDPJP' first before field var 'x_KDDPJP'
        $val = $CurrentForm->hasValue("KDDPJP") ? $CurrentForm->getValue("KDDPJP") : $CurrentForm->getValue("x_KDDPJP");
        if (!$this->KDDPJP->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->KDDPJP->Visible = false; // Disable update for API request
            } else {
                $this->KDDPJP->setFormValue($val);
            }
        }

        // Check field name 'tgl_kontrol' first before field var 'x_tgl_kontrol'
        $val = $CurrentForm->hasValue("tgl_kontrol") ? $CurrentForm->getValue("tgl_kontrol") : $CurrentForm->getValue("x_tgl_kontrol");
        if (!$this->tgl_kontrol->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tgl_kontrol->Visible = false; // Disable update for API request
            } else {
                $this->tgl_kontrol->setFormValue($val);
            }
            $this->tgl_kontrol->CurrentValue = UnFormatDateTime($this->tgl_kontrol->CurrentValue, 0);
        }

        // Check field name 'IDXDAFTAR' first before field var 'x_IDXDAFTAR'
        $val = $CurrentForm->hasValue("IDXDAFTAR") ? $CurrentForm->getValue("IDXDAFTAR") : $CurrentForm->getValue("x_IDXDAFTAR");
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->ORG_UNIT_CODE->CurrentValue = $this->ORG_UNIT_CODE->FormValue;
        $this->NO_REGISTRATION->CurrentValue = $this->NO_REGISTRATION->FormValue;
        $this->VISIT_ID->CurrentValue = $this->VISIT_ID->FormValue;
        $this->STATUS_PASIEN_ID->CurrentValue = $this->STATUS_PASIEN_ID->FormValue;
        $this->RUJUKAN_ID->CurrentValue = $this->RUJUKAN_ID->FormValue;
        $this->ADDRESS_OF_RUJUKAN->CurrentValue = $this->ADDRESS_OF_RUJUKAN->FormValue;
        $this->REASON_ID->CurrentValue = $this->REASON_ID->FormValue;
        $this->WAY_ID->CurrentValue = $this->WAY_ID->FormValue;
        $this->PATIENT_CATEGORY_ID->CurrentValue = $this->PATIENT_CATEGORY_ID->FormValue;
        $this->BOOKED_DATE->CurrentValue = $this->BOOKED_DATE->FormValue;
        $this->BOOKED_DATE->CurrentValue = UnFormatDateTime($this->BOOKED_DATE->CurrentValue, 0);
        $this->VISIT_DATE->CurrentValue = $this->VISIT_DATE->FormValue;
        $this->VISIT_DATE->CurrentValue = UnFormatDateTime($this->VISIT_DATE->CurrentValue, 0);
        $this->ISNEW->CurrentValue = $this->ISNEW->FormValue;
        $this->FOLLOW_UP->CurrentValue = $this->FOLLOW_UP->FormValue;
        $this->PLACE_TYPE->CurrentValue = $this->PLACE_TYPE->FormValue;
        $this->CLINIC_ID->CurrentValue = $this->CLINIC_ID->FormValue;
        $this->CLINIC_ID_FROM->CurrentValue = $this->CLINIC_ID_FROM->FormValue;
        $this->CLASS_ROOM_ID->CurrentValue = $this->CLASS_ROOM_ID->FormValue;
        $this->BED_ID->CurrentValue = $this->BED_ID->FormValue;
        $this->KELUAR_ID->CurrentValue = $this->KELUAR_ID->FormValue;
        $this->IN_DATE->CurrentValue = $this->IN_DATE->FormValue;
        $this->IN_DATE->CurrentValue = UnFormatDateTime($this->IN_DATE->CurrentValue, 0);
        $this->EXIT_DATE->CurrentValue = $this->EXIT_DATE->FormValue;
        $this->EXIT_DATE->CurrentValue = UnFormatDateTime($this->EXIT_DATE->CurrentValue, 0);
        $this->DIANTAR_OLEH->CurrentValue = $this->DIANTAR_OLEH->FormValue;
        $this->GENDER->CurrentValue = $this->GENDER->FormValue;
        $this->DESCRIPTION->CurrentValue = $this->DESCRIPTION->FormValue;
        $this->VISITOR_ADDRESS->CurrentValue = $this->VISITOR_ADDRESS->FormValue;
        $this->MODIFIED_BY->CurrentValue = $this->MODIFIED_BY->FormValue;
        $this->MODIFIED_DATE->CurrentValue = $this->MODIFIED_DATE->FormValue;
        $this->MODIFIED_DATE->CurrentValue = UnFormatDateTime($this->MODIFIED_DATE->CurrentValue, 0);
        $this->MODIFIED_FROM->CurrentValue = $this->MODIFIED_FROM->FormValue;
        $this->EMPLOYEE_ID->CurrentValue = $this->EMPLOYEE_ID->FormValue;
        $this->EMPLOYEE_ID_FROM->CurrentValue = $this->EMPLOYEE_ID_FROM->FormValue;
        $this->RESPONSIBLE_ID->CurrentValue = $this->RESPONSIBLE_ID->FormValue;
        $this->RESPONSIBLE->CurrentValue = $this->RESPONSIBLE->FormValue;
        $this->FAMILY_STATUS_ID->CurrentValue = $this->FAMILY_STATUS_ID->FormValue;
        $this->TICKET_NO->CurrentValue = $this->TICKET_NO->FormValue;
        $this->ISATTENDED->CurrentValue = $this->ISATTENDED->FormValue;
        $this->PAYOR_ID->CurrentValue = $this->PAYOR_ID->FormValue;
        $this->CLASS_ID->CurrentValue = $this->CLASS_ID->FormValue;
        $this->ISPERTARIF->CurrentValue = $this->ISPERTARIF->FormValue;
        $this->KAL_ID->CurrentValue = $this->KAL_ID->FormValue;
        $this->EMPLOYEE_INAP->CurrentValue = $this->EMPLOYEE_INAP->FormValue;
        $this->PASIEN_ID->CurrentValue = $this->PASIEN_ID->FormValue;
        $this->KARYAWAN->CurrentValue = $this->KARYAWAN->FormValue;
        $this->ACCOUNT_ID->CurrentValue = $this->ACCOUNT_ID->FormValue;
        $this->CLASS_ID_PLAFOND->CurrentValue = $this->CLASS_ID_PLAFOND->FormValue;
        $this->BACKCHARGE->CurrentValue = $this->BACKCHARGE->FormValue;
        $this->COVERAGE_ID->CurrentValue = $this->COVERAGE_ID->FormValue;
        $this->AGEYEAR->CurrentValue = $this->AGEYEAR->FormValue;
        $this->AGEMONTH->CurrentValue = $this->AGEMONTH->FormValue;
        $this->AGEDAY->CurrentValue = $this->AGEDAY->FormValue;
        $this->RECOMENDATION->CurrentValue = $this->RECOMENDATION->FormValue;
        $this->CONCLUSION->CurrentValue = $this->CONCLUSION->FormValue;
        $this->SPECIMENNO->CurrentValue = $this->SPECIMENNO->FormValue;
        $this->LOCKED->CurrentValue = $this->LOCKED->FormValue;
        $this->RM_OUT_DATE->CurrentValue = $this->RM_OUT_DATE->FormValue;
        $this->RM_OUT_DATE->CurrentValue = UnFormatDateTime($this->RM_OUT_DATE->CurrentValue, 0);
        $this->RM_IN_DATE->CurrentValue = $this->RM_IN_DATE->FormValue;
        $this->RM_IN_DATE->CurrentValue = UnFormatDateTime($this->RM_IN_DATE->CurrentValue, 0);
        $this->LAMA_PINJAM->CurrentValue = $this->LAMA_PINJAM->FormValue;
        $this->LAMA_PINJAM->CurrentValue = UnFormatDateTime($this->LAMA_PINJAM->CurrentValue, 0);
        $this->STANDAR_RJ->CurrentValue = $this->STANDAR_RJ->FormValue;
        $this->LENGKAP_RJ->CurrentValue = $this->LENGKAP_RJ->FormValue;
        $this->LENGKAP_RI->CurrentValue = $this->LENGKAP_RI->FormValue;
        $this->RESEND_RM_DATE->CurrentValue = $this->RESEND_RM_DATE->FormValue;
        $this->RESEND_RM_DATE->CurrentValue = UnFormatDateTime($this->RESEND_RM_DATE->CurrentValue, 0);
        $this->LENGKAP_RM1->CurrentValue = $this->LENGKAP_RM1->FormValue;
        $this->LENGKAP_RESUME->CurrentValue = $this->LENGKAP_RESUME->FormValue;
        $this->LENGKAP_ANAMNESIS->CurrentValue = $this->LENGKAP_ANAMNESIS->FormValue;
        $this->LENGKAP_CONSENT->CurrentValue = $this->LENGKAP_CONSENT->FormValue;
        $this->LENGKAP_ANESTESI->CurrentValue = $this->LENGKAP_ANESTESI->FormValue;
        $this->LENGKAP_OP->CurrentValue = $this->LENGKAP_OP->FormValue;
        $this->BACK_RM_DATE->CurrentValue = $this->BACK_RM_DATE->FormValue;
        $this->BACK_RM_DATE->CurrentValue = UnFormatDateTime($this->BACK_RM_DATE->CurrentValue, 0);
        $this->VALID_RM_DATE->CurrentValue = $this->VALID_RM_DATE->FormValue;
        $this->VALID_RM_DATE->CurrentValue = UnFormatDateTime($this->VALID_RM_DATE->CurrentValue, 0);
        $this->NO_SKP->CurrentValue = $this->NO_SKP->FormValue;
        $this->NO_SKPINAP->CurrentValue = $this->NO_SKPINAP->FormValue;
        $this->DIAGNOSA_ID->CurrentValue = $this->DIAGNOSA_ID->FormValue;
        $this->ticket_all->CurrentValue = $this->ticket_all->FormValue;
        $this->tanggal_rujukan->CurrentValue = $this->tanggal_rujukan->FormValue;
        $this->tanggal_rujukan->CurrentValue = UnFormatDateTime($this->tanggal_rujukan->CurrentValue, 0);
        $this->ISRJ->CurrentValue = $this->ISRJ->FormValue;
        $this->NORUJUKAN->CurrentValue = $this->NORUJUKAN->FormValue;
        $this->PPKRUJUKAN->CurrentValue = $this->PPKRUJUKAN->FormValue;
        $this->LOKASILAKA->CurrentValue = $this->LOKASILAKA->FormValue;
        $this->KDPOLI->CurrentValue = $this->KDPOLI->FormValue;
        $this->EDIT_SEP->CurrentValue = $this->EDIT_SEP->FormValue;
        $this->DELETE_SEP->CurrentValue = $this->DELETE_SEP->FormValue;
        $this->KODE_AGAMA->CurrentValue = $this->KODE_AGAMA->FormValue;
        $this->DIAG_AWAL->CurrentValue = $this->DIAG_AWAL->FormValue;
        $this->AKTIF->CurrentValue = $this->AKTIF->FormValue;
        $this->BILL_INAP->CurrentValue = $this->BILL_INAP->FormValue;
        $this->SEP_PRINTDATE->CurrentValue = $this->SEP_PRINTDATE->FormValue;
        $this->SEP_PRINTDATE->CurrentValue = UnFormatDateTime($this->SEP_PRINTDATE->CurrentValue, 0);
        $this->MAPPING_SEP->CurrentValue = $this->MAPPING_SEP->FormValue;
        $this->TRANS_ID->CurrentValue = $this->TRANS_ID->FormValue;
        $this->KDPOLI_EKS->CurrentValue = $this->KDPOLI_EKS->FormValue;
        $this->COB->CurrentValue = $this->COB->FormValue;
        $this->PENJAMIN->CurrentValue = $this->PENJAMIN->FormValue;
        $this->ASALRUJUKAN->CurrentValue = $this->ASALRUJUKAN->FormValue;
        $this->RESPONSEP->CurrentValue = $this->RESPONSEP->FormValue;
        $this->APPROVAL_DESC->CurrentValue = $this->APPROVAL_DESC->FormValue;
        $this->APPROVAL_RESPONAJUKAN->CurrentValue = $this->APPROVAL_RESPONAJUKAN->FormValue;
        $this->APPROVAL_RESPONAPPROV->CurrentValue = $this->APPROVAL_RESPONAPPROV->FormValue;
        $this->RESPONTGLPLG_DESC->CurrentValue = $this->RESPONTGLPLG_DESC->FormValue;
        $this->RESPONPOST_VKLAIM->CurrentValue = $this->RESPONPOST_VKLAIM->FormValue;
        $this->RESPONPUT_VKLAIM->CurrentValue = $this->RESPONPUT_VKLAIM->FormValue;
        $this->RESPONDEL_VKLAIM->CurrentValue = $this->RESPONDEL_VKLAIM->FormValue;
        $this->CALL_TIMES->CurrentValue = $this->CALL_TIMES->FormValue;
        $this->CALL_DATE->CurrentValue = $this->CALL_DATE->FormValue;
        $this->CALL_DATE->CurrentValue = UnFormatDateTime($this->CALL_DATE->CurrentValue, 0);
        $this->CALL_DATES->CurrentValue = $this->CALL_DATES->FormValue;
        $this->CALL_DATES->CurrentValue = UnFormatDateTime($this->CALL_DATES->CurrentValue, 0);
        $this->SERVED_DATE->CurrentValue = $this->SERVED_DATE->FormValue;
        $this->SERVED_DATE->CurrentValue = UnFormatDateTime($this->SERVED_DATE->CurrentValue, 0);
        $this->SERVED_INAP->CurrentValue = $this->SERVED_INAP->FormValue;
        $this->SERVED_INAP->CurrentValue = UnFormatDateTime($this->SERVED_INAP->CurrentValue, 0);
        $this->KDDPJP1->CurrentValue = $this->KDDPJP1->FormValue;
        $this->KDDPJP->CurrentValue = $this->KDDPJP->FormValue;
        $this->tgl_kontrol->CurrentValue = $this->tgl_kontrol->FormValue;
        $this->tgl_kontrol->CurrentValue = UnFormatDateTime($this->tgl_kontrol->CurrentValue, 0);
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
        $this->NO_REGISTRATION->setDbValue($row['NO_REGISTRATION']);
        $this->VISIT_ID->setDbValue($row['VISIT_ID']);
        $this->STATUS_PASIEN_ID->setDbValue($row['STATUS_PASIEN_ID']);
        $this->RUJUKAN_ID->setDbValue($row['RUJUKAN_ID']);
        $this->ADDRESS_OF_RUJUKAN->setDbValue($row['ADDRESS_OF_RUJUKAN']);
        $this->REASON_ID->setDbValue($row['REASON_ID']);
        $this->WAY_ID->setDbValue($row['WAY_ID']);
        $this->PATIENT_CATEGORY_ID->setDbValue($row['PATIENT_CATEGORY_ID']);
        $this->BOOKED_DATE->setDbValue($row['BOOKED_DATE']);
        $this->VISIT_DATE->setDbValue($row['VISIT_DATE']);
        $this->ISNEW->setDbValue($row['ISNEW']);
        $this->FOLLOW_UP->setDbValue($row['FOLLOW_UP']);
        $this->PLACE_TYPE->setDbValue($row['PLACE_TYPE']);
        $this->CLINIC_ID->setDbValue($row['CLINIC_ID']);
        $this->CLINIC_ID_FROM->setDbValue($row['CLINIC_ID_FROM']);
        $this->CLASS_ROOM_ID->setDbValue($row['CLASS_ROOM_ID']);
        $this->BED_ID->setDbValue($row['BED_ID']);
        $this->KELUAR_ID->setDbValue($row['KELUAR_ID']);
        $this->IN_DATE->setDbValue($row['IN_DATE']);
        $this->EXIT_DATE->setDbValue($row['EXIT_DATE']);
        $this->DIANTAR_OLEH->setDbValue($row['DIANTAR_OLEH']);
        $this->GENDER->setDbValue($row['GENDER']);
        $this->DESCRIPTION->setDbValue($row['DESCRIPTION']);
        $this->VISITOR_ADDRESS->setDbValue($row['VISITOR_ADDRESS']);
        $this->MODIFIED_BY->setDbValue($row['MODIFIED_BY']);
        $this->MODIFIED_DATE->setDbValue($row['MODIFIED_DATE']);
        $this->MODIFIED_FROM->setDbValue($row['MODIFIED_FROM']);
        $this->EMPLOYEE_ID->setDbValue($row['EMPLOYEE_ID']);
        $this->EMPLOYEE_ID_FROM->setDbValue($row['EMPLOYEE_ID_FROM']);
        $this->RESPONSIBLE_ID->setDbValue($row['RESPONSIBLE_ID']);
        $this->RESPONSIBLE->setDbValue($row['RESPONSIBLE']);
        $this->FAMILY_STATUS_ID->setDbValue($row['FAMILY_STATUS_ID']);
        $this->TICKET_NO->setDbValue($row['TICKET_NO']);
        $this->ISATTENDED->setDbValue($row['ISATTENDED']);
        $this->PAYOR_ID->setDbValue($row['PAYOR_ID']);
        $this->CLASS_ID->setDbValue($row['CLASS_ID']);
        $this->ISPERTARIF->setDbValue($row['ISPERTARIF']);
        $this->KAL_ID->setDbValue($row['KAL_ID']);
        $this->EMPLOYEE_INAP->setDbValue($row['EMPLOYEE_INAP']);
        $this->PASIEN_ID->setDbValue($row['PASIEN_ID']);
        $this->KARYAWAN->setDbValue($row['KARYAWAN']);
        $this->ACCOUNT_ID->setDbValue($row['ACCOUNT_ID']);
        $this->CLASS_ID_PLAFOND->setDbValue($row['CLASS_ID_PLAFOND']);
        $this->BACKCHARGE->setDbValue($row['BACKCHARGE']);
        $this->COVERAGE_ID->setDbValue($row['COVERAGE_ID']);
        $this->AGEYEAR->setDbValue($row['AGEYEAR']);
        $this->AGEMONTH->setDbValue($row['AGEMONTH']);
        $this->AGEDAY->setDbValue($row['AGEDAY']);
        $this->RECOMENDATION->setDbValue($row['RECOMENDATION']);
        $this->CONCLUSION->setDbValue($row['CONCLUSION']);
        $this->SPECIMENNO->setDbValue($row['SPECIMENNO']);
        $this->LOCKED->setDbValue($row['LOCKED']);
        $this->RM_OUT_DATE->setDbValue($row['RM_OUT_DATE']);
        $this->RM_IN_DATE->setDbValue($row['RM_IN_DATE']);
        $this->LAMA_PINJAM->setDbValue($row['LAMA_PINJAM']);
        $this->STANDAR_RJ->setDbValue($row['STANDAR_RJ']);
        $this->LENGKAP_RJ->setDbValue($row['LENGKAP_RJ']);
        $this->LENGKAP_RI->setDbValue($row['LENGKAP_RI']);
        $this->RESEND_RM_DATE->setDbValue($row['RESEND_RM_DATE']);
        $this->LENGKAP_RM1->setDbValue($row['LENGKAP_RM1']);
        $this->LENGKAP_RESUME->setDbValue($row['LENGKAP_RESUME']);
        $this->LENGKAP_ANAMNESIS->setDbValue($row['LENGKAP_ANAMNESIS']);
        $this->LENGKAP_CONSENT->setDbValue($row['LENGKAP_CONSENT']);
        $this->LENGKAP_ANESTESI->setDbValue($row['LENGKAP_ANESTESI']);
        $this->LENGKAP_OP->setDbValue($row['LENGKAP_OP']);
        $this->BACK_RM_DATE->setDbValue($row['BACK_RM_DATE']);
        $this->VALID_RM_DATE->setDbValue($row['VALID_RM_DATE']);
        $this->NO_SKP->setDbValue($row['NO_SKP']);
        $this->NO_SKPINAP->setDbValue($row['NO_SKPINAP']);
        $this->DIAGNOSA_ID->setDbValue($row['DIAGNOSA_ID']);
        $this->ticket_all->setDbValue($row['ticket_all']);
        $this->tanggal_rujukan->setDbValue($row['tanggal_rujukan']);
        $this->ISRJ->setDbValue($row['ISRJ']);
        $this->NORUJUKAN->setDbValue($row['NORUJUKAN']);
        $this->PPKRUJUKAN->setDbValue($row['PPKRUJUKAN']);
        $this->LOKASILAKA->setDbValue($row['LOKASILAKA']);
        $this->KDPOLI->setDbValue($row['KDPOLI']);
        $this->EDIT_SEP->setDbValue($row['EDIT_SEP']);
        $this->DELETE_SEP->setDbValue($row['DELETE_SEP']);
        $this->KODE_AGAMA->setDbValue($row['KODE_AGAMA']);
        $this->DIAG_AWAL->setDbValue($row['DIAG_AWAL']);
        $this->AKTIF->setDbValue($row['AKTIF']);
        $this->BILL_INAP->setDbValue($row['BILL_INAP']);
        $this->SEP_PRINTDATE->setDbValue($row['SEP_PRINTDATE']);
        $this->MAPPING_SEP->setDbValue($row['MAPPING_SEP']);
        $this->TRANS_ID->setDbValue($row['TRANS_ID']);
        $this->KDPOLI_EKS->setDbValue($row['KDPOLI_EKS']);
        $this->COB->setDbValue($row['COB']);
        $this->PENJAMIN->setDbValue($row['PENJAMIN']);
        $this->ASALRUJUKAN->setDbValue($row['ASALRUJUKAN']);
        $this->RESPONSEP->setDbValue($row['RESPONSEP']);
        $this->APPROVAL_DESC->setDbValue($row['APPROVAL_DESC']);
        $this->APPROVAL_RESPONAJUKAN->setDbValue($row['APPROVAL_RESPONAJUKAN']);
        $this->APPROVAL_RESPONAPPROV->setDbValue($row['APPROVAL_RESPONAPPROV']);
        $this->RESPONTGLPLG_DESC->setDbValue($row['RESPONTGLPLG_DESC']);
        $this->RESPONPOST_VKLAIM->setDbValue($row['RESPONPOST_VKLAIM']);
        $this->RESPONPUT_VKLAIM->setDbValue($row['RESPONPUT_VKLAIM']);
        $this->RESPONDEL_VKLAIM->setDbValue($row['RESPONDEL_VKLAIM']);
        $this->CALL_TIMES->setDbValue($row['CALL_TIMES']);
        $this->CALL_DATE->setDbValue($row['CALL_DATE']);
        $this->CALL_DATES->setDbValue($row['CALL_DATES']);
        $this->SERVED_DATE->setDbValue($row['SERVED_DATE']);
        $this->SERVED_INAP->setDbValue($row['SERVED_INAP']);
        $this->KDDPJP1->setDbValue($row['KDDPJP1']);
        $this->KDDPJP->setDbValue($row['KDDPJP']);
        $this->IDXDAFTAR->setDbValue($row['IDXDAFTAR']);
        $this->tgl_kontrol->setDbValue($row['tgl_kontrol']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $this->loadDefaultValues();
        $row = [];
        $row['ORG_UNIT_CODE'] = $this->ORG_UNIT_CODE->CurrentValue;
        $row['NO_REGISTRATION'] = $this->NO_REGISTRATION->CurrentValue;
        $row['VISIT_ID'] = $this->VISIT_ID->CurrentValue;
        $row['STATUS_PASIEN_ID'] = $this->STATUS_PASIEN_ID->CurrentValue;
        $row['RUJUKAN_ID'] = $this->RUJUKAN_ID->CurrentValue;
        $row['ADDRESS_OF_RUJUKAN'] = $this->ADDRESS_OF_RUJUKAN->CurrentValue;
        $row['REASON_ID'] = $this->REASON_ID->CurrentValue;
        $row['WAY_ID'] = $this->WAY_ID->CurrentValue;
        $row['PATIENT_CATEGORY_ID'] = $this->PATIENT_CATEGORY_ID->CurrentValue;
        $row['BOOKED_DATE'] = $this->BOOKED_DATE->CurrentValue;
        $row['VISIT_DATE'] = $this->VISIT_DATE->CurrentValue;
        $row['ISNEW'] = $this->ISNEW->CurrentValue;
        $row['FOLLOW_UP'] = $this->FOLLOW_UP->CurrentValue;
        $row['PLACE_TYPE'] = $this->PLACE_TYPE->CurrentValue;
        $row['CLINIC_ID'] = $this->CLINIC_ID->CurrentValue;
        $row['CLINIC_ID_FROM'] = $this->CLINIC_ID_FROM->CurrentValue;
        $row['CLASS_ROOM_ID'] = $this->CLASS_ROOM_ID->CurrentValue;
        $row['BED_ID'] = $this->BED_ID->CurrentValue;
        $row['KELUAR_ID'] = $this->KELUAR_ID->CurrentValue;
        $row['IN_DATE'] = $this->IN_DATE->CurrentValue;
        $row['EXIT_DATE'] = $this->EXIT_DATE->CurrentValue;
        $row['DIANTAR_OLEH'] = $this->DIANTAR_OLEH->CurrentValue;
        $row['GENDER'] = $this->GENDER->CurrentValue;
        $row['DESCRIPTION'] = $this->DESCRIPTION->CurrentValue;
        $row['VISITOR_ADDRESS'] = $this->VISITOR_ADDRESS->CurrentValue;
        $row['MODIFIED_BY'] = $this->MODIFIED_BY->CurrentValue;
        $row['MODIFIED_DATE'] = $this->MODIFIED_DATE->CurrentValue;
        $row['MODIFIED_FROM'] = $this->MODIFIED_FROM->CurrentValue;
        $row['EMPLOYEE_ID'] = $this->EMPLOYEE_ID->CurrentValue;
        $row['EMPLOYEE_ID_FROM'] = $this->EMPLOYEE_ID_FROM->CurrentValue;
        $row['RESPONSIBLE_ID'] = $this->RESPONSIBLE_ID->CurrentValue;
        $row['RESPONSIBLE'] = $this->RESPONSIBLE->CurrentValue;
        $row['FAMILY_STATUS_ID'] = $this->FAMILY_STATUS_ID->CurrentValue;
        $row['TICKET_NO'] = $this->TICKET_NO->CurrentValue;
        $row['ISATTENDED'] = $this->ISATTENDED->CurrentValue;
        $row['PAYOR_ID'] = $this->PAYOR_ID->CurrentValue;
        $row['CLASS_ID'] = $this->CLASS_ID->CurrentValue;
        $row['ISPERTARIF'] = $this->ISPERTARIF->CurrentValue;
        $row['KAL_ID'] = $this->KAL_ID->CurrentValue;
        $row['EMPLOYEE_INAP'] = $this->EMPLOYEE_INAP->CurrentValue;
        $row['PASIEN_ID'] = $this->PASIEN_ID->CurrentValue;
        $row['KARYAWAN'] = $this->KARYAWAN->CurrentValue;
        $row['ACCOUNT_ID'] = $this->ACCOUNT_ID->CurrentValue;
        $row['CLASS_ID_PLAFOND'] = $this->CLASS_ID_PLAFOND->CurrentValue;
        $row['BACKCHARGE'] = $this->BACKCHARGE->CurrentValue;
        $row['COVERAGE_ID'] = $this->COVERAGE_ID->CurrentValue;
        $row['AGEYEAR'] = $this->AGEYEAR->CurrentValue;
        $row['AGEMONTH'] = $this->AGEMONTH->CurrentValue;
        $row['AGEDAY'] = $this->AGEDAY->CurrentValue;
        $row['RECOMENDATION'] = $this->RECOMENDATION->CurrentValue;
        $row['CONCLUSION'] = $this->CONCLUSION->CurrentValue;
        $row['SPECIMENNO'] = $this->SPECIMENNO->CurrentValue;
        $row['LOCKED'] = $this->LOCKED->CurrentValue;
        $row['RM_OUT_DATE'] = $this->RM_OUT_DATE->CurrentValue;
        $row['RM_IN_DATE'] = $this->RM_IN_DATE->CurrentValue;
        $row['LAMA_PINJAM'] = $this->LAMA_PINJAM->CurrentValue;
        $row['STANDAR_RJ'] = $this->STANDAR_RJ->CurrentValue;
        $row['LENGKAP_RJ'] = $this->LENGKAP_RJ->CurrentValue;
        $row['LENGKAP_RI'] = $this->LENGKAP_RI->CurrentValue;
        $row['RESEND_RM_DATE'] = $this->RESEND_RM_DATE->CurrentValue;
        $row['LENGKAP_RM1'] = $this->LENGKAP_RM1->CurrentValue;
        $row['LENGKAP_RESUME'] = $this->LENGKAP_RESUME->CurrentValue;
        $row['LENGKAP_ANAMNESIS'] = $this->LENGKAP_ANAMNESIS->CurrentValue;
        $row['LENGKAP_CONSENT'] = $this->LENGKAP_CONSENT->CurrentValue;
        $row['LENGKAP_ANESTESI'] = $this->LENGKAP_ANESTESI->CurrentValue;
        $row['LENGKAP_OP'] = $this->LENGKAP_OP->CurrentValue;
        $row['BACK_RM_DATE'] = $this->BACK_RM_DATE->CurrentValue;
        $row['VALID_RM_DATE'] = $this->VALID_RM_DATE->CurrentValue;
        $row['NO_SKP'] = $this->NO_SKP->CurrentValue;
        $row['NO_SKPINAP'] = $this->NO_SKPINAP->CurrentValue;
        $row['DIAGNOSA_ID'] = $this->DIAGNOSA_ID->CurrentValue;
        $row['ticket_all'] = $this->ticket_all->CurrentValue;
        $row['tanggal_rujukan'] = $this->tanggal_rujukan->CurrentValue;
        $row['ISRJ'] = $this->ISRJ->CurrentValue;
        $row['NORUJUKAN'] = $this->NORUJUKAN->CurrentValue;
        $row['PPKRUJUKAN'] = $this->PPKRUJUKAN->CurrentValue;
        $row['LOKASILAKA'] = $this->LOKASILAKA->CurrentValue;
        $row['KDPOLI'] = $this->KDPOLI->CurrentValue;
        $row['EDIT_SEP'] = $this->EDIT_SEP->CurrentValue;
        $row['DELETE_SEP'] = $this->DELETE_SEP->CurrentValue;
        $row['KODE_AGAMA'] = $this->KODE_AGAMA->CurrentValue;
        $row['DIAG_AWAL'] = $this->DIAG_AWAL->CurrentValue;
        $row['AKTIF'] = $this->AKTIF->CurrentValue;
        $row['BILL_INAP'] = $this->BILL_INAP->CurrentValue;
        $row['SEP_PRINTDATE'] = $this->SEP_PRINTDATE->CurrentValue;
        $row['MAPPING_SEP'] = $this->MAPPING_SEP->CurrentValue;
        $row['TRANS_ID'] = $this->TRANS_ID->CurrentValue;
        $row['KDPOLI_EKS'] = $this->KDPOLI_EKS->CurrentValue;
        $row['COB'] = $this->COB->CurrentValue;
        $row['PENJAMIN'] = $this->PENJAMIN->CurrentValue;
        $row['ASALRUJUKAN'] = $this->ASALRUJUKAN->CurrentValue;
        $row['RESPONSEP'] = $this->RESPONSEP->CurrentValue;
        $row['APPROVAL_DESC'] = $this->APPROVAL_DESC->CurrentValue;
        $row['APPROVAL_RESPONAJUKAN'] = $this->APPROVAL_RESPONAJUKAN->CurrentValue;
        $row['APPROVAL_RESPONAPPROV'] = $this->APPROVAL_RESPONAPPROV->CurrentValue;
        $row['RESPONTGLPLG_DESC'] = $this->RESPONTGLPLG_DESC->CurrentValue;
        $row['RESPONPOST_VKLAIM'] = $this->RESPONPOST_VKLAIM->CurrentValue;
        $row['RESPONPUT_VKLAIM'] = $this->RESPONPUT_VKLAIM->CurrentValue;
        $row['RESPONDEL_VKLAIM'] = $this->RESPONDEL_VKLAIM->CurrentValue;
        $row['CALL_TIMES'] = $this->CALL_TIMES->CurrentValue;
        $row['CALL_DATE'] = $this->CALL_DATE->CurrentValue;
        $row['CALL_DATES'] = $this->CALL_DATES->CurrentValue;
        $row['SERVED_DATE'] = $this->SERVED_DATE->CurrentValue;
        $row['SERVED_INAP'] = $this->SERVED_INAP->CurrentValue;
        $row['KDDPJP1'] = $this->KDDPJP1->CurrentValue;
        $row['KDDPJP'] = $this->KDDPJP->CurrentValue;
        $row['IDXDAFTAR'] = $this->IDXDAFTAR->CurrentValue;
        $row['tgl_kontrol'] = $this->tgl_kontrol->CurrentValue;
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

        // NO_REGISTRATION

        // VISIT_ID

        // STATUS_PASIEN_ID

        // RUJUKAN_ID

        // ADDRESS_OF_RUJUKAN

        // REASON_ID

        // WAY_ID

        // PATIENT_CATEGORY_ID

        // BOOKED_DATE

        // VISIT_DATE

        // ISNEW

        // FOLLOW_UP

        // PLACE_TYPE

        // CLINIC_ID

        // CLINIC_ID_FROM

        // CLASS_ROOM_ID

        // BED_ID

        // KELUAR_ID

        // IN_DATE

        // EXIT_DATE

        // DIANTAR_OLEH

        // GENDER

        // DESCRIPTION

        // VISITOR_ADDRESS

        // MODIFIED_BY

        // MODIFIED_DATE

        // MODIFIED_FROM

        // EMPLOYEE_ID

        // EMPLOYEE_ID_FROM

        // RESPONSIBLE_ID

        // RESPONSIBLE

        // FAMILY_STATUS_ID

        // TICKET_NO

        // ISATTENDED

        // PAYOR_ID

        // CLASS_ID

        // ISPERTARIF

        // KAL_ID

        // EMPLOYEE_INAP

        // PASIEN_ID

        // KARYAWAN

        // ACCOUNT_ID

        // CLASS_ID_PLAFOND

        // BACKCHARGE

        // COVERAGE_ID

        // AGEYEAR

        // AGEMONTH

        // AGEDAY

        // RECOMENDATION

        // CONCLUSION

        // SPECIMENNO

        // LOCKED

        // RM_OUT_DATE

        // RM_IN_DATE

        // LAMA_PINJAM

        // STANDAR_RJ

        // LENGKAP_RJ

        // LENGKAP_RI

        // RESEND_RM_DATE

        // LENGKAP_RM1

        // LENGKAP_RESUME

        // LENGKAP_ANAMNESIS

        // LENGKAP_CONSENT

        // LENGKAP_ANESTESI

        // LENGKAP_OP

        // BACK_RM_DATE

        // VALID_RM_DATE

        // NO_SKP

        // NO_SKPINAP

        // DIAGNOSA_ID

        // ticket_all

        // tanggal_rujukan

        // ISRJ

        // NORUJUKAN

        // PPKRUJUKAN

        // LOKASILAKA

        // KDPOLI

        // EDIT_SEP

        // DELETE_SEP

        // KODE_AGAMA

        // DIAG_AWAL

        // AKTIF

        // BILL_INAP

        // SEP_PRINTDATE

        // MAPPING_SEP

        // TRANS_ID

        // KDPOLI_EKS

        // COB

        // PENJAMIN

        // ASALRUJUKAN

        // RESPONSEP

        // APPROVAL_DESC

        // APPROVAL_RESPONAJUKAN

        // APPROVAL_RESPONAPPROV

        // RESPONTGLPLG_DESC

        // RESPONPOST_VKLAIM

        // RESPONPUT_VKLAIM

        // RESPONDEL_VKLAIM

        // CALL_TIMES

        // CALL_DATE

        // CALL_DATES

        // SERVED_DATE

        // SERVED_INAP

        // KDDPJP1

        // KDDPJP

        // IDXDAFTAR

        // tgl_kontrol
        if ($this->RowType == ROWTYPE_VIEW) {
            // ORG_UNIT_CODE
            $this->ORG_UNIT_CODE->ViewValue = $this->ORG_UNIT_CODE->CurrentValue;
            $this->ORG_UNIT_CODE->ViewCustomAttributes = "";

            // NO_REGISTRATION
            $this->NO_REGISTRATION->ViewValue = $this->NO_REGISTRATION->CurrentValue;
            $this->NO_REGISTRATION->ViewCustomAttributes = "";

            // VISIT_ID
            $this->VISIT_ID->ViewValue = $this->VISIT_ID->CurrentValue;
            $this->VISIT_ID->ViewCustomAttributes = "";

            // STATUS_PASIEN_ID
            $this->STATUS_PASIEN_ID->ViewValue = $this->STATUS_PASIEN_ID->CurrentValue;
            $this->STATUS_PASIEN_ID->ViewValue = FormatNumber($this->STATUS_PASIEN_ID->ViewValue, 0, -2, -2, -2);
            $this->STATUS_PASIEN_ID->ViewCustomAttributes = "";

            // RUJUKAN_ID
            $this->RUJUKAN_ID->ViewValue = $this->RUJUKAN_ID->CurrentValue;
            $this->RUJUKAN_ID->ViewValue = FormatNumber($this->RUJUKAN_ID->ViewValue, 0, -2, -2, -2);
            $this->RUJUKAN_ID->ViewCustomAttributes = "";

            // ADDRESS_OF_RUJUKAN
            $this->ADDRESS_OF_RUJUKAN->ViewValue = $this->ADDRESS_OF_RUJUKAN->CurrentValue;
            $this->ADDRESS_OF_RUJUKAN->ViewCustomAttributes = "";

            // REASON_ID
            $this->REASON_ID->ViewValue = $this->REASON_ID->CurrentValue;
            $this->REASON_ID->ViewValue = FormatNumber($this->REASON_ID->ViewValue, 0, -2, -2, -2);
            $this->REASON_ID->ViewCustomAttributes = "";

            // WAY_ID
            $this->WAY_ID->ViewValue = $this->WAY_ID->CurrentValue;
            $this->WAY_ID->ViewValue = FormatNumber($this->WAY_ID->ViewValue, 0, -2, -2, -2);
            $this->WAY_ID->ViewCustomAttributes = "";

            // PATIENT_CATEGORY_ID
            $this->PATIENT_CATEGORY_ID->ViewValue = $this->PATIENT_CATEGORY_ID->CurrentValue;
            $this->PATIENT_CATEGORY_ID->ViewValue = FormatNumber($this->PATIENT_CATEGORY_ID->ViewValue, 0, -2, -2, -2);
            $this->PATIENT_CATEGORY_ID->ViewCustomAttributes = "";

            // BOOKED_DATE
            $this->BOOKED_DATE->ViewValue = $this->BOOKED_DATE->CurrentValue;
            $this->BOOKED_DATE->ViewValue = FormatDateTime($this->BOOKED_DATE->ViewValue, 0);
            $this->BOOKED_DATE->ViewCustomAttributes = "";

            // VISIT_DATE
            $this->VISIT_DATE->ViewValue = $this->VISIT_DATE->CurrentValue;
            $this->VISIT_DATE->ViewValue = FormatDateTime($this->VISIT_DATE->ViewValue, 0);
            $this->VISIT_DATE->ViewCustomAttributes = "";

            // ISNEW
            $this->ISNEW->ViewValue = $this->ISNEW->CurrentValue;
            $this->ISNEW->ViewCustomAttributes = "";

            // FOLLOW_UP
            $this->FOLLOW_UP->ViewValue = $this->FOLLOW_UP->CurrentValue;
            $this->FOLLOW_UP->ViewValue = FormatNumber($this->FOLLOW_UP->ViewValue, 0, -2, -2, -2);
            $this->FOLLOW_UP->ViewCustomAttributes = "";

            // PLACE_TYPE
            $this->PLACE_TYPE->ViewValue = $this->PLACE_TYPE->CurrentValue;
            $this->PLACE_TYPE->ViewValue = FormatNumber($this->PLACE_TYPE->ViewValue, 0, -2, -2, -2);
            $this->PLACE_TYPE->ViewCustomAttributes = "";

            // CLINIC_ID
            $this->CLINIC_ID->ViewValue = $this->CLINIC_ID->CurrentValue;
            $this->CLINIC_ID->ViewCustomAttributes = "";

            // CLINIC_ID_FROM
            $this->CLINIC_ID_FROM->ViewValue = $this->CLINIC_ID_FROM->CurrentValue;
            $this->CLINIC_ID_FROM->ViewCustomAttributes = "";

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

            // IN_DATE
            $this->IN_DATE->ViewValue = $this->IN_DATE->CurrentValue;
            $this->IN_DATE->ViewValue = FormatDateTime($this->IN_DATE->ViewValue, 0);
            $this->IN_DATE->ViewCustomAttributes = "";

            // EXIT_DATE
            $this->EXIT_DATE->ViewValue = $this->EXIT_DATE->CurrentValue;
            $this->EXIT_DATE->ViewValue = FormatDateTime($this->EXIT_DATE->ViewValue, 0);
            $this->EXIT_DATE->ViewCustomAttributes = "";

            // DIANTAR_OLEH
            $this->DIANTAR_OLEH->ViewValue = $this->DIANTAR_OLEH->CurrentValue;
            $this->DIANTAR_OLEH->ViewCustomAttributes = "";

            // GENDER
            $this->GENDER->ViewValue = $this->GENDER->CurrentValue;
            $this->GENDER->ViewCustomAttributes = "";

            // DESCRIPTION
            $this->DESCRIPTION->ViewValue = $this->DESCRIPTION->CurrentValue;
            $this->DESCRIPTION->ViewCustomAttributes = "";

            // VISITOR_ADDRESS
            $this->VISITOR_ADDRESS->ViewValue = $this->VISITOR_ADDRESS->CurrentValue;
            $this->VISITOR_ADDRESS->ViewCustomAttributes = "";

            // MODIFIED_BY
            $this->MODIFIED_BY->ViewValue = $this->MODIFIED_BY->CurrentValue;
            $this->MODIFIED_BY->ViewCustomAttributes = "";

            // MODIFIED_DATE
            $this->MODIFIED_DATE->ViewValue = $this->MODIFIED_DATE->CurrentValue;
            $this->MODIFIED_DATE->ViewValue = FormatDateTime($this->MODIFIED_DATE->ViewValue, 0);
            $this->MODIFIED_DATE->ViewCustomAttributes = "";

            // MODIFIED_FROM
            $this->MODIFIED_FROM->ViewValue = $this->MODIFIED_FROM->CurrentValue;
            $this->MODIFIED_FROM->ViewCustomAttributes = "";

            // EMPLOYEE_ID
            $this->EMPLOYEE_ID->ViewValue = $this->EMPLOYEE_ID->CurrentValue;
            $this->EMPLOYEE_ID->ViewCustomAttributes = "";

            // EMPLOYEE_ID_FROM
            $this->EMPLOYEE_ID_FROM->ViewValue = $this->EMPLOYEE_ID_FROM->CurrentValue;
            $this->EMPLOYEE_ID_FROM->ViewCustomAttributes = "";

            // RESPONSIBLE_ID
            $this->RESPONSIBLE_ID->ViewValue = $this->RESPONSIBLE_ID->CurrentValue;
            $this->RESPONSIBLE_ID->ViewValue = FormatNumber($this->RESPONSIBLE_ID->ViewValue, 0, -2, -2, -2);
            $this->RESPONSIBLE_ID->ViewCustomAttributes = "";

            // RESPONSIBLE
            $this->RESPONSIBLE->ViewValue = $this->RESPONSIBLE->CurrentValue;
            $this->RESPONSIBLE->ViewCustomAttributes = "";

            // FAMILY_STATUS_ID
            $this->FAMILY_STATUS_ID->ViewValue = $this->FAMILY_STATUS_ID->CurrentValue;
            $this->FAMILY_STATUS_ID->ViewValue = FormatNumber($this->FAMILY_STATUS_ID->ViewValue, 0, -2, -2, -2);
            $this->FAMILY_STATUS_ID->ViewCustomAttributes = "";

            // TICKET_NO
            $this->TICKET_NO->ViewValue = $this->TICKET_NO->CurrentValue;
            $this->TICKET_NO->ViewValue = FormatNumber($this->TICKET_NO->ViewValue, 0, -2, -2, -2);
            $this->TICKET_NO->ViewCustomAttributes = "";

            // ISATTENDED
            $this->ISATTENDED->ViewValue = $this->ISATTENDED->CurrentValue;
            $this->ISATTENDED->ViewCustomAttributes = "";

            // PAYOR_ID
            $this->PAYOR_ID->ViewValue = $this->PAYOR_ID->CurrentValue;
            $this->PAYOR_ID->ViewCustomAttributes = "";

            // CLASS_ID
            $this->CLASS_ID->ViewValue = $this->CLASS_ID->CurrentValue;
            $this->CLASS_ID->ViewValue = FormatNumber($this->CLASS_ID->ViewValue, 0, -2, -2, -2);
            $this->CLASS_ID->ViewCustomAttributes = "";

            // ISPERTARIF
            $this->ISPERTARIF->ViewValue = $this->ISPERTARIF->CurrentValue;
            $this->ISPERTARIF->ViewCustomAttributes = "";

            // KAL_ID
            $this->KAL_ID->ViewValue = $this->KAL_ID->CurrentValue;
            $this->KAL_ID->ViewCustomAttributes = "";

            // EMPLOYEE_INAP
            $this->EMPLOYEE_INAP->ViewValue = $this->EMPLOYEE_INAP->CurrentValue;
            $this->EMPLOYEE_INAP->ViewCustomAttributes = "";

            // PASIEN_ID
            $this->PASIEN_ID->ViewValue = $this->PASIEN_ID->CurrentValue;
            $this->PASIEN_ID->ViewCustomAttributes = "";

            // KARYAWAN
            $this->KARYAWAN->ViewValue = $this->KARYAWAN->CurrentValue;
            $this->KARYAWAN->ViewCustomAttributes = "";

            // ACCOUNT_ID
            $this->ACCOUNT_ID->ViewValue = $this->ACCOUNT_ID->CurrentValue;
            $this->ACCOUNT_ID->ViewCustomAttributes = "";

            // CLASS_ID_PLAFOND
            $this->CLASS_ID_PLAFOND->ViewValue = $this->CLASS_ID_PLAFOND->CurrentValue;
            $this->CLASS_ID_PLAFOND->ViewValue = FormatNumber($this->CLASS_ID_PLAFOND->ViewValue, 0, -2, -2, -2);
            $this->CLASS_ID_PLAFOND->ViewCustomAttributes = "";

            // BACKCHARGE
            $this->BACKCHARGE->ViewValue = $this->BACKCHARGE->CurrentValue;
            $this->BACKCHARGE->ViewCustomAttributes = "";

            // COVERAGE_ID
            $this->COVERAGE_ID->ViewValue = $this->COVERAGE_ID->CurrentValue;
            $this->COVERAGE_ID->ViewValue = FormatNumber($this->COVERAGE_ID->ViewValue, 0, -2, -2, -2);
            $this->COVERAGE_ID->ViewCustomAttributes = "";

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

            // RECOMENDATION
            $this->RECOMENDATION->ViewValue = $this->RECOMENDATION->CurrentValue;
            $this->RECOMENDATION->ViewCustomAttributes = "";

            // CONCLUSION
            $this->CONCLUSION->ViewValue = $this->CONCLUSION->CurrentValue;
            $this->CONCLUSION->ViewCustomAttributes = "";

            // SPECIMENNO
            $this->SPECIMENNO->ViewValue = $this->SPECIMENNO->CurrentValue;
            $this->SPECIMENNO->ViewCustomAttributes = "";

            // LOCKED
            $this->LOCKED->ViewValue = $this->LOCKED->CurrentValue;
            $this->LOCKED->ViewCustomAttributes = "";

            // RM_OUT_DATE
            $this->RM_OUT_DATE->ViewValue = $this->RM_OUT_DATE->CurrentValue;
            $this->RM_OUT_DATE->ViewValue = FormatDateTime($this->RM_OUT_DATE->ViewValue, 0);
            $this->RM_OUT_DATE->ViewCustomAttributes = "";

            // RM_IN_DATE
            $this->RM_IN_DATE->ViewValue = $this->RM_IN_DATE->CurrentValue;
            $this->RM_IN_DATE->ViewValue = FormatDateTime($this->RM_IN_DATE->ViewValue, 0);
            $this->RM_IN_DATE->ViewCustomAttributes = "";

            // LAMA_PINJAM
            $this->LAMA_PINJAM->ViewValue = $this->LAMA_PINJAM->CurrentValue;
            $this->LAMA_PINJAM->ViewValue = FormatDateTime($this->LAMA_PINJAM->ViewValue, 0);
            $this->LAMA_PINJAM->ViewCustomAttributes = "";

            // STANDAR_RJ
            $this->STANDAR_RJ->ViewValue = $this->STANDAR_RJ->CurrentValue;
            $this->STANDAR_RJ->ViewCustomAttributes = "";

            // LENGKAP_RJ
            $this->LENGKAP_RJ->ViewValue = $this->LENGKAP_RJ->CurrentValue;
            $this->LENGKAP_RJ->ViewCustomAttributes = "";

            // LENGKAP_RI
            $this->LENGKAP_RI->ViewValue = $this->LENGKAP_RI->CurrentValue;
            $this->LENGKAP_RI->ViewCustomAttributes = "";

            // RESEND_RM_DATE
            $this->RESEND_RM_DATE->ViewValue = $this->RESEND_RM_DATE->CurrentValue;
            $this->RESEND_RM_DATE->ViewValue = FormatDateTime($this->RESEND_RM_DATE->ViewValue, 0);
            $this->RESEND_RM_DATE->ViewCustomAttributes = "";

            // LENGKAP_RM1
            $this->LENGKAP_RM1->ViewValue = $this->LENGKAP_RM1->CurrentValue;
            $this->LENGKAP_RM1->ViewCustomAttributes = "";

            // LENGKAP_RESUME
            $this->LENGKAP_RESUME->ViewValue = $this->LENGKAP_RESUME->CurrentValue;
            $this->LENGKAP_RESUME->ViewCustomAttributes = "";

            // LENGKAP_ANAMNESIS
            $this->LENGKAP_ANAMNESIS->ViewValue = $this->LENGKAP_ANAMNESIS->CurrentValue;
            $this->LENGKAP_ANAMNESIS->ViewCustomAttributes = "";

            // LENGKAP_CONSENT
            $this->LENGKAP_CONSENT->ViewValue = $this->LENGKAP_CONSENT->CurrentValue;
            $this->LENGKAP_CONSENT->ViewCustomAttributes = "";

            // LENGKAP_ANESTESI
            $this->LENGKAP_ANESTESI->ViewValue = $this->LENGKAP_ANESTESI->CurrentValue;
            $this->LENGKAP_ANESTESI->ViewCustomAttributes = "";

            // LENGKAP_OP
            $this->LENGKAP_OP->ViewValue = $this->LENGKAP_OP->CurrentValue;
            $this->LENGKAP_OP->ViewCustomAttributes = "";

            // BACK_RM_DATE
            $this->BACK_RM_DATE->ViewValue = $this->BACK_RM_DATE->CurrentValue;
            $this->BACK_RM_DATE->ViewValue = FormatDateTime($this->BACK_RM_DATE->ViewValue, 0);
            $this->BACK_RM_DATE->ViewCustomAttributes = "";

            // VALID_RM_DATE
            $this->VALID_RM_DATE->ViewValue = $this->VALID_RM_DATE->CurrentValue;
            $this->VALID_RM_DATE->ViewValue = FormatDateTime($this->VALID_RM_DATE->ViewValue, 0);
            $this->VALID_RM_DATE->ViewCustomAttributes = "";

            // NO_SKP
            $this->NO_SKP->ViewValue = $this->NO_SKP->CurrentValue;
            $this->NO_SKP->ViewCustomAttributes = "";

            // NO_SKPINAP
            $this->NO_SKPINAP->ViewValue = $this->NO_SKPINAP->CurrentValue;
            $this->NO_SKPINAP->ViewCustomAttributes = "";

            // DIAGNOSA_ID
            $this->DIAGNOSA_ID->ViewValue = $this->DIAGNOSA_ID->CurrentValue;
            $this->DIAGNOSA_ID->ViewCustomAttributes = "";

            // ticket_all
            $this->ticket_all->ViewValue = $this->ticket_all->CurrentValue;
            $this->ticket_all->ViewValue = FormatNumber($this->ticket_all->ViewValue, 0, -2, -2, -2);
            $this->ticket_all->ViewCustomAttributes = "";

            // tanggal_rujukan
            $this->tanggal_rujukan->ViewValue = $this->tanggal_rujukan->CurrentValue;
            $this->tanggal_rujukan->ViewValue = FormatDateTime($this->tanggal_rujukan->ViewValue, 0);
            $this->tanggal_rujukan->ViewCustomAttributes = "";

            // ISRJ
            $this->ISRJ->ViewValue = $this->ISRJ->CurrentValue;
            $this->ISRJ->ViewCustomAttributes = "";

            // NORUJUKAN
            $this->NORUJUKAN->ViewValue = $this->NORUJUKAN->CurrentValue;
            $this->NORUJUKAN->ViewCustomAttributes = "";

            // PPKRUJUKAN
            $this->PPKRUJUKAN->ViewValue = $this->PPKRUJUKAN->CurrentValue;
            $this->PPKRUJUKAN->ViewCustomAttributes = "";

            // LOKASILAKA
            $this->LOKASILAKA->ViewValue = $this->LOKASILAKA->CurrentValue;
            $this->LOKASILAKA->ViewCustomAttributes = "";

            // KDPOLI
            $this->KDPOLI->ViewValue = $this->KDPOLI->CurrentValue;
            $this->KDPOLI->ViewCustomAttributes = "";

            // EDIT_SEP
            $this->EDIT_SEP->ViewValue = $this->EDIT_SEP->CurrentValue;
            $this->EDIT_SEP->ViewCustomAttributes = "";

            // DELETE_SEP
            $this->DELETE_SEP->ViewValue = $this->DELETE_SEP->CurrentValue;
            $this->DELETE_SEP->ViewCustomAttributes = "";

            // KODE_AGAMA
            $this->KODE_AGAMA->ViewValue = $this->KODE_AGAMA->CurrentValue;
            $this->KODE_AGAMA->ViewValue = FormatNumber($this->KODE_AGAMA->ViewValue, 0, -2, -2, -2);
            $this->KODE_AGAMA->ViewCustomAttributes = "";

            // DIAG_AWAL
            $this->DIAG_AWAL->ViewValue = $this->DIAG_AWAL->CurrentValue;
            $this->DIAG_AWAL->ViewCustomAttributes = "";

            // AKTIF
            $this->AKTIF->ViewValue = $this->AKTIF->CurrentValue;
            $this->AKTIF->ViewCustomAttributes = "";

            // BILL_INAP
            $this->BILL_INAP->ViewValue = $this->BILL_INAP->CurrentValue;
            $this->BILL_INAP->ViewCustomAttributes = "";

            // SEP_PRINTDATE
            $this->SEP_PRINTDATE->ViewValue = $this->SEP_PRINTDATE->CurrentValue;
            $this->SEP_PRINTDATE->ViewValue = FormatDateTime($this->SEP_PRINTDATE->ViewValue, 0);
            $this->SEP_PRINTDATE->ViewCustomAttributes = "";

            // MAPPING_SEP
            $this->MAPPING_SEP->ViewValue = $this->MAPPING_SEP->CurrentValue;
            $this->MAPPING_SEP->ViewCustomAttributes = "";

            // TRANS_ID
            $this->TRANS_ID->ViewValue = $this->TRANS_ID->CurrentValue;
            $this->TRANS_ID->ViewCustomAttributes = "";

            // KDPOLI_EKS
            $this->KDPOLI_EKS->ViewValue = $this->KDPOLI_EKS->CurrentValue;
            $this->KDPOLI_EKS->ViewCustomAttributes = "";

            // COB
            $this->COB->ViewValue = $this->COB->CurrentValue;
            $this->COB->ViewCustomAttributes = "";

            // PENJAMIN
            $this->PENJAMIN->ViewValue = $this->PENJAMIN->CurrentValue;
            $this->PENJAMIN->ViewCustomAttributes = "";

            // ASALRUJUKAN
            $this->ASALRUJUKAN->ViewValue = $this->ASALRUJUKAN->CurrentValue;
            $this->ASALRUJUKAN->ViewCustomAttributes = "";

            // RESPONSEP
            $this->RESPONSEP->ViewValue = $this->RESPONSEP->CurrentValue;
            $this->RESPONSEP->ViewCustomAttributes = "";

            // APPROVAL_DESC
            $this->APPROVAL_DESC->ViewValue = $this->APPROVAL_DESC->CurrentValue;
            $this->APPROVAL_DESC->ViewCustomAttributes = "";

            // APPROVAL_RESPONAJUKAN
            $this->APPROVAL_RESPONAJUKAN->ViewValue = $this->APPROVAL_RESPONAJUKAN->CurrentValue;
            $this->APPROVAL_RESPONAJUKAN->ViewCustomAttributes = "";

            // APPROVAL_RESPONAPPROV
            $this->APPROVAL_RESPONAPPROV->ViewValue = $this->APPROVAL_RESPONAPPROV->CurrentValue;
            $this->APPROVAL_RESPONAPPROV->ViewCustomAttributes = "";

            // RESPONTGLPLG_DESC
            $this->RESPONTGLPLG_DESC->ViewValue = $this->RESPONTGLPLG_DESC->CurrentValue;
            $this->RESPONTGLPLG_DESC->ViewCustomAttributes = "";

            // RESPONPOST_VKLAIM
            $this->RESPONPOST_VKLAIM->ViewValue = $this->RESPONPOST_VKLAIM->CurrentValue;
            $this->RESPONPOST_VKLAIM->ViewCustomAttributes = "";

            // RESPONPUT_VKLAIM
            $this->RESPONPUT_VKLAIM->ViewValue = $this->RESPONPUT_VKLAIM->CurrentValue;
            $this->RESPONPUT_VKLAIM->ViewCustomAttributes = "";

            // RESPONDEL_VKLAIM
            $this->RESPONDEL_VKLAIM->ViewValue = $this->RESPONDEL_VKLAIM->CurrentValue;
            $this->RESPONDEL_VKLAIM->ViewCustomAttributes = "";

            // CALL_TIMES
            $this->CALL_TIMES->ViewValue = $this->CALL_TIMES->CurrentValue;
            $this->CALL_TIMES->ViewValue = FormatNumber($this->CALL_TIMES->ViewValue, 0, -2, -2, -2);
            $this->CALL_TIMES->ViewCustomAttributes = "";

            // CALL_DATE
            $this->CALL_DATE->ViewValue = $this->CALL_DATE->CurrentValue;
            $this->CALL_DATE->ViewValue = FormatDateTime($this->CALL_DATE->ViewValue, 0);
            $this->CALL_DATE->ViewCustomAttributes = "";

            // CALL_DATES
            $this->CALL_DATES->ViewValue = $this->CALL_DATES->CurrentValue;
            $this->CALL_DATES->ViewValue = FormatDateTime($this->CALL_DATES->ViewValue, 0);
            $this->CALL_DATES->ViewCustomAttributes = "";

            // SERVED_DATE
            $this->SERVED_DATE->ViewValue = $this->SERVED_DATE->CurrentValue;
            $this->SERVED_DATE->ViewValue = FormatDateTime($this->SERVED_DATE->ViewValue, 0);
            $this->SERVED_DATE->ViewCustomAttributes = "";

            // SERVED_INAP
            $this->SERVED_INAP->ViewValue = $this->SERVED_INAP->CurrentValue;
            $this->SERVED_INAP->ViewValue = FormatDateTime($this->SERVED_INAP->ViewValue, 0);
            $this->SERVED_INAP->ViewCustomAttributes = "";

            // KDDPJP1
            $this->KDDPJP1->ViewValue = $this->KDDPJP1->CurrentValue;
            $this->KDDPJP1->ViewCustomAttributes = "";

            // KDDPJP
            $this->KDDPJP->ViewValue = $this->KDDPJP->CurrentValue;
            $this->KDDPJP->ViewCustomAttributes = "";

            // IDXDAFTAR
            $this->IDXDAFTAR->ViewValue = $this->IDXDAFTAR->CurrentValue;
            $this->IDXDAFTAR->ViewCustomAttributes = "";

            // tgl_kontrol
            $this->tgl_kontrol->ViewValue = $this->tgl_kontrol->CurrentValue;
            $this->tgl_kontrol->ViewValue = FormatDateTime($this->tgl_kontrol->ViewValue, 0);
            $this->tgl_kontrol->ViewCustomAttributes = "";

            // ORG_UNIT_CODE
            $this->ORG_UNIT_CODE->LinkCustomAttributes = "";
            $this->ORG_UNIT_CODE->HrefValue = "";
            $this->ORG_UNIT_CODE->TooltipValue = "";

            // NO_REGISTRATION
            $this->NO_REGISTRATION->LinkCustomAttributes = "";
            $this->NO_REGISTRATION->HrefValue = "";
            $this->NO_REGISTRATION->TooltipValue = "";

            // VISIT_ID
            $this->VISIT_ID->LinkCustomAttributes = "";
            $this->VISIT_ID->HrefValue = "";
            $this->VISIT_ID->TooltipValue = "";

            // STATUS_PASIEN_ID
            $this->STATUS_PASIEN_ID->LinkCustomAttributes = "";
            $this->STATUS_PASIEN_ID->HrefValue = "";
            $this->STATUS_PASIEN_ID->TooltipValue = "";

            // RUJUKAN_ID
            $this->RUJUKAN_ID->LinkCustomAttributes = "";
            $this->RUJUKAN_ID->HrefValue = "";
            $this->RUJUKAN_ID->TooltipValue = "";

            // ADDRESS_OF_RUJUKAN
            $this->ADDRESS_OF_RUJUKAN->LinkCustomAttributes = "";
            $this->ADDRESS_OF_RUJUKAN->HrefValue = "";
            $this->ADDRESS_OF_RUJUKAN->TooltipValue = "";

            // REASON_ID
            $this->REASON_ID->LinkCustomAttributes = "";
            $this->REASON_ID->HrefValue = "";
            $this->REASON_ID->TooltipValue = "";

            // WAY_ID
            $this->WAY_ID->LinkCustomAttributes = "";
            $this->WAY_ID->HrefValue = "";
            $this->WAY_ID->TooltipValue = "";

            // PATIENT_CATEGORY_ID
            $this->PATIENT_CATEGORY_ID->LinkCustomAttributes = "";
            $this->PATIENT_CATEGORY_ID->HrefValue = "";
            $this->PATIENT_CATEGORY_ID->TooltipValue = "";

            // BOOKED_DATE
            $this->BOOKED_DATE->LinkCustomAttributes = "";
            $this->BOOKED_DATE->HrefValue = "";
            $this->BOOKED_DATE->TooltipValue = "";

            // VISIT_DATE
            $this->VISIT_DATE->LinkCustomAttributes = "";
            $this->VISIT_DATE->HrefValue = "";
            $this->VISIT_DATE->TooltipValue = "";

            // ISNEW
            $this->ISNEW->LinkCustomAttributes = "";
            $this->ISNEW->HrefValue = "";
            $this->ISNEW->TooltipValue = "";

            // FOLLOW_UP
            $this->FOLLOW_UP->LinkCustomAttributes = "";
            $this->FOLLOW_UP->HrefValue = "";
            $this->FOLLOW_UP->TooltipValue = "";

            // PLACE_TYPE
            $this->PLACE_TYPE->LinkCustomAttributes = "";
            $this->PLACE_TYPE->HrefValue = "";
            $this->PLACE_TYPE->TooltipValue = "";

            // CLINIC_ID
            $this->CLINIC_ID->LinkCustomAttributes = "";
            $this->CLINIC_ID->HrefValue = "";
            $this->CLINIC_ID->TooltipValue = "";

            // CLINIC_ID_FROM
            $this->CLINIC_ID_FROM->LinkCustomAttributes = "";
            $this->CLINIC_ID_FROM->HrefValue = "";
            $this->CLINIC_ID_FROM->TooltipValue = "";

            // CLASS_ROOM_ID
            $this->CLASS_ROOM_ID->LinkCustomAttributes = "";
            $this->CLASS_ROOM_ID->HrefValue = "";
            $this->CLASS_ROOM_ID->TooltipValue = "";

            // BED_ID
            $this->BED_ID->LinkCustomAttributes = "";
            $this->BED_ID->HrefValue = "";
            $this->BED_ID->TooltipValue = "";

            // KELUAR_ID
            $this->KELUAR_ID->LinkCustomAttributes = "";
            $this->KELUAR_ID->HrefValue = "";
            $this->KELUAR_ID->TooltipValue = "";

            // IN_DATE
            $this->IN_DATE->LinkCustomAttributes = "";
            $this->IN_DATE->HrefValue = "";
            $this->IN_DATE->TooltipValue = "";

            // EXIT_DATE
            $this->EXIT_DATE->LinkCustomAttributes = "";
            $this->EXIT_DATE->HrefValue = "";
            $this->EXIT_DATE->TooltipValue = "";

            // DIANTAR_OLEH
            $this->DIANTAR_OLEH->LinkCustomAttributes = "";
            $this->DIANTAR_OLEH->HrefValue = "";
            $this->DIANTAR_OLEH->TooltipValue = "";

            // GENDER
            $this->GENDER->LinkCustomAttributes = "";
            $this->GENDER->HrefValue = "";
            $this->GENDER->TooltipValue = "";

            // DESCRIPTION
            $this->DESCRIPTION->LinkCustomAttributes = "";
            $this->DESCRIPTION->HrefValue = "";
            $this->DESCRIPTION->TooltipValue = "";

            // VISITOR_ADDRESS
            $this->VISITOR_ADDRESS->LinkCustomAttributes = "";
            $this->VISITOR_ADDRESS->HrefValue = "";
            $this->VISITOR_ADDRESS->TooltipValue = "";

            // MODIFIED_BY
            $this->MODIFIED_BY->LinkCustomAttributes = "";
            $this->MODIFIED_BY->HrefValue = "";
            $this->MODIFIED_BY->TooltipValue = "";

            // MODIFIED_DATE
            $this->MODIFIED_DATE->LinkCustomAttributes = "";
            $this->MODIFIED_DATE->HrefValue = "";
            $this->MODIFIED_DATE->TooltipValue = "";

            // MODIFIED_FROM
            $this->MODIFIED_FROM->LinkCustomAttributes = "";
            $this->MODIFIED_FROM->HrefValue = "";
            $this->MODIFIED_FROM->TooltipValue = "";

            // EMPLOYEE_ID
            $this->EMPLOYEE_ID->LinkCustomAttributes = "";
            $this->EMPLOYEE_ID->HrefValue = "";
            $this->EMPLOYEE_ID->TooltipValue = "";

            // EMPLOYEE_ID_FROM
            $this->EMPLOYEE_ID_FROM->LinkCustomAttributes = "";
            $this->EMPLOYEE_ID_FROM->HrefValue = "";
            $this->EMPLOYEE_ID_FROM->TooltipValue = "";

            // RESPONSIBLE_ID
            $this->RESPONSIBLE_ID->LinkCustomAttributes = "";
            $this->RESPONSIBLE_ID->HrefValue = "";
            $this->RESPONSIBLE_ID->TooltipValue = "";

            // RESPONSIBLE
            $this->RESPONSIBLE->LinkCustomAttributes = "";
            $this->RESPONSIBLE->HrefValue = "";
            $this->RESPONSIBLE->TooltipValue = "";

            // FAMILY_STATUS_ID
            $this->FAMILY_STATUS_ID->LinkCustomAttributes = "";
            $this->FAMILY_STATUS_ID->HrefValue = "";
            $this->FAMILY_STATUS_ID->TooltipValue = "";

            // TICKET_NO
            $this->TICKET_NO->LinkCustomAttributes = "";
            $this->TICKET_NO->HrefValue = "";
            $this->TICKET_NO->TooltipValue = "";

            // ISATTENDED
            $this->ISATTENDED->LinkCustomAttributes = "";
            $this->ISATTENDED->HrefValue = "";
            $this->ISATTENDED->TooltipValue = "";

            // PAYOR_ID
            $this->PAYOR_ID->LinkCustomAttributes = "";
            $this->PAYOR_ID->HrefValue = "";
            $this->PAYOR_ID->TooltipValue = "";

            // CLASS_ID
            $this->CLASS_ID->LinkCustomAttributes = "";
            $this->CLASS_ID->HrefValue = "";
            $this->CLASS_ID->TooltipValue = "";

            // ISPERTARIF
            $this->ISPERTARIF->LinkCustomAttributes = "";
            $this->ISPERTARIF->HrefValue = "";
            $this->ISPERTARIF->TooltipValue = "";

            // KAL_ID
            $this->KAL_ID->LinkCustomAttributes = "";
            $this->KAL_ID->HrefValue = "";
            $this->KAL_ID->TooltipValue = "";

            // EMPLOYEE_INAP
            $this->EMPLOYEE_INAP->LinkCustomAttributes = "";
            $this->EMPLOYEE_INAP->HrefValue = "";
            $this->EMPLOYEE_INAP->TooltipValue = "";

            // PASIEN_ID
            $this->PASIEN_ID->LinkCustomAttributes = "";
            $this->PASIEN_ID->HrefValue = "";
            $this->PASIEN_ID->TooltipValue = "";

            // KARYAWAN
            $this->KARYAWAN->LinkCustomAttributes = "";
            $this->KARYAWAN->HrefValue = "";
            $this->KARYAWAN->TooltipValue = "";

            // ACCOUNT_ID
            $this->ACCOUNT_ID->LinkCustomAttributes = "";
            $this->ACCOUNT_ID->HrefValue = "";
            $this->ACCOUNT_ID->TooltipValue = "";

            // CLASS_ID_PLAFOND
            $this->CLASS_ID_PLAFOND->LinkCustomAttributes = "";
            $this->CLASS_ID_PLAFOND->HrefValue = "";
            $this->CLASS_ID_PLAFOND->TooltipValue = "";

            // BACKCHARGE
            $this->BACKCHARGE->LinkCustomAttributes = "";
            $this->BACKCHARGE->HrefValue = "";
            $this->BACKCHARGE->TooltipValue = "";

            // COVERAGE_ID
            $this->COVERAGE_ID->LinkCustomAttributes = "";
            $this->COVERAGE_ID->HrefValue = "";
            $this->COVERAGE_ID->TooltipValue = "";

            // AGEYEAR
            $this->AGEYEAR->LinkCustomAttributes = "";
            $this->AGEYEAR->HrefValue = "";
            $this->AGEYEAR->TooltipValue = "";

            // AGEMONTH
            $this->AGEMONTH->LinkCustomAttributes = "";
            $this->AGEMONTH->HrefValue = "";
            $this->AGEMONTH->TooltipValue = "";

            // AGEDAY
            $this->AGEDAY->LinkCustomAttributes = "";
            $this->AGEDAY->HrefValue = "";
            $this->AGEDAY->TooltipValue = "";

            // RECOMENDATION
            $this->RECOMENDATION->LinkCustomAttributes = "";
            $this->RECOMENDATION->HrefValue = "";
            $this->RECOMENDATION->TooltipValue = "";

            // CONCLUSION
            $this->CONCLUSION->LinkCustomAttributes = "";
            $this->CONCLUSION->HrefValue = "";
            $this->CONCLUSION->TooltipValue = "";

            // SPECIMENNO
            $this->SPECIMENNO->LinkCustomAttributes = "";
            $this->SPECIMENNO->HrefValue = "";
            $this->SPECIMENNO->TooltipValue = "";

            // LOCKED
            $this->LOCKED->LinkCustomAttributes = "";
            $this->LOCKED->HrefValue = "";
            $this->LOCKED->TooltipValue = "";

            // RM_OUT_DATE
            $this->RM_OUT_DATE->LinkCustomAttributes = "";
            $this->RM_OUT_DATE->HrefValue = "";
            $this->RM_OUT_DATE->TooltipValue = "";

            // RM_IN_DATE
            $this->RM_IN_DATE->LinkCustomAttributes = "";
            $this->RM_IN_DATE->HrefValue = "";
            $this->RM_IN_DATE->TooltipValue = "";

            // LAMA_PINJAM
            $this->LAMA_PINJAM->LinkCustomAttributes = "";
            $this->LAMA_PINJAM->HrefValue = "";
            $this->LAMA_PINJAM->TooltipValue = "";

            // STANDAR_RJ
            $this->STANDAR_RJ->LinkCustomAttributes = "";
            $this->STANDAR_RJ->HrefValue = "";
            $this->STANDAR_RJ->TooltipValue = "";

            // LENGKAP_RJ
            $this->LENGKAP_RJ->LinkCustomAttributes = "";
            $this->LENGKAP_RJ->HrefValue = "";
            $this->LENGKAP_RJ->TooltipValue = "";

            // LENGKAP_RI
            $this->LENGKAP_RI->LinkCustomAttributes = "";
            $this->LENGKAP_RI->HrefValue = "";
            $this->LENGKAP_RI->TooltipValue = "";

            // RESEND_RM_DATE
            $this->RESEND_RM_DATE->LinkCustomAttributes = "";
            $this->RESEND_RM_DATE->HrefValue = "";
            $this->RESEND_RM_DATE->TooltipValue = "";

            // LENGKAP_RM1
            $this->LENGKAP_RM1->LinkCustomAttributes = "";
            $this->LENGKAP_RM1->HrefValue = "";
            $this->LENGKAP_RM1->TooltipValue = "";

            // LENGKAP_RESUME
            $this->LENGKAP_RESUME->LinkCustomAttributes = "";
            $this->LENGKAP_RESUME->HrefValue = "";
            $this->LENGKAP_RESUME->TooltipValue = "";

            // LENGKAP_ANAMNESIS
            $this->LENGKAP_ANAMNESIS->LinkCustomAttributes = "";
            $this->LENGKAP_ANAMNESIS->HrefValue = "";
            $this->LENGKAP_ANAMNESIS->TooltipValue = "";

            // LENGKAP_CONSENT
            $this->LENGKAP_CONSENT->LinkCustomAttributes = "";
            $this->LENGKAP_CONSENT->HrefValue = "";
            $this->LENGKAP_CONSENT->TooltipValue = "";

            // LENGKAP_ANESTESI
            $this->LENGKAP_ANESTESI->LinkCustomAttributes = "";
            $this->LENGKAP_ANESTESI->HrefValue = "";
            $this->LENGKAP_ANESTESI->TooltipValue = "";

            // LENGKAP_OP
            $this->LENGKAP_OP->LinkCustomAttributes = "";
            $this->LENGKAP_OP->HrefValue = "";
            $this->LENGKAP_OP->TooltipValue = "";

            // BACK_RM_DATE
            $this->BACK_RM_DATE->LinkCustomAttributes = "";
            $this->BACK_RM_DATE->HrefValue = "";
            $this->BACK_RM_DATE->TooltipValue = "";

            // VALID_RM_DATE
            $this->VALID_RM_DATE->LinkCustomAttributes = "";
            $this->VALID_RM_DATE->HrefValue = "";
            $this->VALID_RM_DATE->TooltipValue = "";

            // NO_SKP
            $this->NO_SKP->LinkCustomAttributes = "";
            $this->NO_SKP->HrefValue = "";
            $this->NO_SKP->TooltipValue = "";

            // NO_SKPINAP
            $this->NO_SKPINAP->LinkCustomAttributes = "";
            $this->NO_SKPINAP->HrefValue = "";
            $this->NO_SKPINAP->TooltipValue = "";

            // DIAGNOSA_ID
            $this->DIAGNOSA_ID->LinkCustomAttributes = "";
            $this->DIAGNOSA_ID->HrefValue = "";
            $this->DIAGNOSA_ID->TooltipValue = "";

            // ticket_all
            $this->ticket_all->LinkCustomAttributes = "";
            $this->ticket_all->HrefValue = "";
            $this->ticket_all->TooltipValue = "";

            // tanggal_rujukan
            $this->tanggal_rujukan->LinkCustomAttributes = "";
            $this->tanggal_rujukan->HrefValue = "";
            $this->tanggal_rujukan->TooltipValue = "";

            // ISRJ
            $this->ISRJ->LinkCustomAttributes = "";
            $this->ISRJ->HrefValue = "";
            $this->ISRJ->TooltipValue = "";

            // NORUJUKAN
            $this->NORUJUKAN->LinkCustomAttributes = "";
            $this->NORUJUKAN->HrefValue = "";
            $this->NORUJUKAN->TooltipValue = "";

            // PPKRUJUKAN
            $this->PPKRUJUKAN->LinkCustomAttributes = "";
            $this->PPKRUJUKAN->HrefValue = "";
            $this->PPKRUJUKAN->TooltipValue = "";

            // LOKASILAKA
            $this->LOKASILAKA->LinkCustomAttributes = "";
            $this->LOKASILAKA->HrefValue = "";
            $this->LOKASILAKA->TooltipValue = "";

            // KDPOLI
            $this->KDPOLI->LinkCustomAttributes = "";
            $this->KDPOLI->HrefValue = "";
            $this->KDPOLI->TooltipValue = "";

            // EDIT_SEP
            $this->EDIT_SEP->LinkCustomAttributes = "";
            $this->EDIT_SEP->HrefValue = "";
            $this->EDIT_SEP->TooltipValue = "";

            // DELETE_SEP
            $this->DELETE_SEP->LinkCustomAttributes = "";
            $this->DELETE_SEP->HrefValue = "";
            $this->DELETE_SEP->TooltipValue = "";

            // KODE_AGAMA
            $this->KODE_AGAMA->LinkCustomAttributes = "";
            $this->KODE_AGAMA->HrefValue = "";
            $this->KODE_AGAMA->TooltipValue = "";

            // DIAG_AWAL
            $this->DIAG_AWAL->LinkCustomAttributes = "";
            $this->DIAG_AWAL->HrefValue = "";
            $this->DIAG_AWAL->TooltipValue = "";

            // AKTIF
            $this->AKTIF->LinkCustomAttributes = "";
            $this->AKTIF->HrefValue = "";
            $this->AKTIF->TooltipValue = "";

            // BILL_INAP
            $this->BILL_INAP->LinkCustomAttributes = "";
            $this->BILL_INAP->HrefValue = "";
            $this->BILL_INAP->TooltipValue = "";

            // SEP_PRINTDATE
            $this->SEP_PRINTDATE->LinkCustomAttributes = "";
            $this->SEP_PRINTDATE->HrefValue = "";
            $this->SEP_PRINTDATE->TooltipValue = "";

            // MAPPING_SEP
            $this->MAPPING_SEP->LinkCustomAttributes = "";
            $this->MAPPING_SEP->HrefValue = "";
            $this->MAPPING_SEP->TooltipValue = "";

            // TRANS_ID
            $this->TRANS_ID->LinkCustomAttributes = "";
            $this->TRANS_ID->HrefValue = "";
            $this->TRANS_ID->TooltipValue = "";

            // KDPOLI_EKS
            $this->KDPOLI_EKS->LinkCustomAttributes = "";
            $this->KDPOLI_EKS->HrefValue = "";
            $this->KDPOLI_EKS->TooltipValue = "";

            // COB
            $this->COB->LinkCustomAttributes = "";
            $this->COB->HrefValue = "";
            $this->COB->TooltipValue = "";

            // PENJAMIN
            $this->PENJAMIN->LinkCustomAttributes = "";
            $this->PENJAMIN->HrefValue = "";
            $this->PENJAMIN->TooltipValue = "";

            // ASALRUJUKAN
            $this->ASALRUJUKAN->LinkCustomAttributes = "";
            $this->ASALRUJUKAN->HrefValue = "";
            $this->ASALRUJUKAN->TooltipValue = "";

            // RESPONSEP
            $this->RESPONSEP->LinkCustomAttributes = "";
            $this->RESPONSEP->HrefValue = "";
            $this->RESPONSEP->TooltipValue = "";

            // APPROVAL_DESC
            $this->APPROVAL_DESC->LinkCustomAttributes = "";
            $this->APPROVAL_DESC->HrefValue = "";
            $this->APPROVAL_DESC->TooltipValue = "";

            // APPROVAL_RESPONAJUKAN
            $this->APPROVAL_RESPONAJUKAN->LinkCustomAttributes = "";
            $this->APPROVAL_RESPONAJUKAN->HrefValue = "";
            $this->APPROVAL_RESPONAJUKAN->TooltipValue = "";

            // APPROVAL_RESPONAPPROV
            $this->APPROVAL_RESPONAPPROV->LinkCustomAttributes = "";
            $this->APPROVAL_RESPONAPPROV->HrefValue = "";
            $this->APPROVAL_RESPONAPPROV->TooltipValue = "";

            // RESPONTGLPLG_DESC
            $this->RESPONTGLPLG_DESC->LinkCustomAttributes = "";
            $this->RESPONTGLPLG_DESC->HrefValue = "";
            $this->RESPONTGLPLG_DESC->TooltipValue = "";

            // RESPONPOST_VKLAIM
            $this->RESPONPOST_VKLAIM->LinkCustomAttributes = "";
            $this->RESPONPOST_VKLAIM->HrefValue = "";
            $this->RESPONPOST_VKLAIM->TooltipValue = "";

            // RESPONPUT_VKLAIM
            $this->RESPONPUT_VKLAIM->LinkCustomAttributes = "";
            $this->RESPONPUT_VKLAIM->HrefValue = "";
            $this->RESPONPUT_VKLAIM->TooltipValue = "";

            // RESPONDEL_VKLAIM
            $this->RESPONDEL_VKLAIM->LinkCustomAttributes = "";
            $this->RESPONDEL_VKLAIM->HrefValue = "";
            $this->RESPONDEL_VKLAIM->TooltipValue = "";

            // CALL_TIMES
            $this->CALL_TIMES->LinkCustomAttributes = "";
            $this->CALL_TIMES->HrefValue = "";
            $this->CALL_TIMES->TooltipValue = "";

            // CALL_DATE
            $this->CALL_DATE->LinkCustomAttributes = "";
            $this->CALL_DATE->HrefValue = "";
            $this->CALL_DATE->TooltipValue = "";

            // CALL_DATES
            $this->CALL_DATES->LinkCustomAttributes = "";
            $this->CALL_DATES->HrefValue = "";
            $this->CALL_DATES->TooltipValue = "";

            // SERVED_DATE
            $this->SERVED_DATE->LinkCustomAttributes = "";
            $this->SERVED_DATE->HrefValue = "";
            $this->SERVED_DATE->TooltipValue = "";

            // SERVED_INAP
            $this->SERVED_INAP->LinkCustomAttributes = "";
            $this->SERVED_INAP->HrefValue = "";
            $this->SERVED_INAP->TooltipValue = "";

            // KDDPJP1
            $this->KDDPJP1->LinkCustomAttributes = "";
            $this->KDDPJP1->HrefValue = "";
            $this->KDDPJP1->TooltipValue = "";

            // KDDPJP
            $this->KDDPJP->LinkCustomAttributes = "";
            $this->KDDPJP->HrefValue = "";
            $this->KDDPJP->TooltipValue = "";

            // tgl_kontrol
            $this->tgl_kontrol->LinkCustomAttributes = "";
            $this->tgl_kontrol->HrefValue = "";
            $this->tgl_kontrol->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // ORG_UNIT_CODE
            $this->ORG_UNIT_CODE->EditAttrs["class"] = "form-control";
            $this->ORG_UNIT_CODE->EditCustomAttributes = "";
            if (!$this->ORG_UNIT_CODE->Raw) {
                $this->ORG_UNIT_CODE->CurrentValue = HtmlDecode($this->ORG_UNIT_CODE->CurrentValue);
            }
            $this->ORG_UNIT_CODE->EditValue = HtmlEncode($this->ORG_UNIT_CODE->CurrentValue);
            $this->ORG_UNIT_CODE->PlaceHolder = RemoveHtml($this->ORG_UNIT_CODE->caption());

            // NO_REGISTRATION
            $this->NO_REGISTRATION->EditAttrs["class"] = "form-control";
            $this->NO_REGISTRATION->EditCustomAttributes = "";
            if (!$this->NO_REGISTRATION->Raw) {
                $this->NO_REGISTRATION->CurrentValue = HtmlDecode($this->NO_REGISTRATION->CurrentValue);
            }
            $this->NO_REGISTRATION->EditValue = HtmlEncode($this->NO_REGISTRATION->CurrentValue);
            $this->NO_REGISTRATION->PlaceHolder = RemoveHtml($this->NO_REGISTRATION->caption());

            // VISIT_ID
            $this->VISIT_ID->EditAttrs["class"] = "form-control";
            $this->VISIT_ID->EditCustomAttributes = "";
            if (!$this->VISIT_ID->Raw) {
                $this->VISIT_ID->CurrentValue = HtmlDecode($this->VISIT_ID->CurrentValue);
            }
            $this->VISIT_ID->EditValue = HtmlEncode($this->VISIT_ID->CurrentValue);
            $this->VISIT_ID->PlaceHolder = RemoveHtml($this->VISIT_ID->caption());

            // STATUS_PASIEN_ID
            $this->STATUS_PASIEN_ID->EditAttrs["class"] = "form-control";
            $this->STATUS_PASIEN_ID->EditCustomAttributes = "";
            $this->STATUS_PASIEN_ID->EditValue = HtmlEncode($this->STATUS_PASIEN_ID->CurrentValue);
            $this->STATUS_PASIEN_ID->PlaceHolder = RemoveHtml($this->STATUS_PASIEN_ID->caption());

            // RUJUKAN_ID
            $this->RUJUKAN_ID->EditAttrs["class"] = "form-control";
            $this->RUJUKAN_ID->EditCustomAttributes = "";
            $this->RUJUKAN_ID->EditValue = HtmlEncode($this->RUJUKAN_ID->CurrentValue);
            $this->RUJUKAN_ID->PlaceHolder = RemoveHtml($this->RUJUKAN_ID->caption());

            // ADDRESS_OF_RUJUKAN
            $this->ADDRESS_OF_RUJUKAN->EditAttrs["class"] = "form-control";
            $this->ADDRESS_OF_RUJUKAN->EditCustomAttributes = "";
            if (!$this->ADDRESS_OF_RUJUKAN->Raw) {
                $this->ADDRESS_OF_RUJUKAN->CurrentValue = HtmlDecode($this->ADDRESS_OF_RUJUKAN->CurrentValue);
            }
            $this->ADDRESS_OF_RUJUKAN->EditValue = HtmlEncode($this->ADDRESS_OF_RUJUKAN->CurrentValue);
            $this->ADDRESS_OF_RUJUKAN->PlaceHolder = RemoveHtml($this->ADDRESS_OF_RUJUKAN->caption());

            // REASON_ID
            $this->REASON_ID->EditAttrs["class"] = "form-control";
            $this->REASON_ID->EditCustomAttributes = "";
            $this->REASON_ID->EditValue = HtmlEncode($this->REASON_ID->CurrentValue);
            $this->REASON_ID->PlaceHolder = RemoveHtml($this->REASON_ID->caption());

            // WAY_ID
            $this->WAY_ID->EditAttrs["class"] = "form-control";
            $this->WAY_ID->EditCustomAttributes = "";
            $this->WAY_ID->EditValue = HtmlEncode($this->WAY_ID->CurrentValue);
            $this->WAY_ID->PlaceHolder = RemoveHtml($this->WAY_ID->caption());

            // PATIENT_CATEGORY_ID
            $this->PATIENT_CATEGORY_ID->EditAttrs["class"] = "form-control";
            $this->PATIENT_CATEGORY_ID->EditCustomAttributes = "";
            $this->PATIENT_CATEGORY_ID->EditValue = HtmlEncode($this->PATIENT_CATEGORY_ID->CurrentValue);
            $this->PATIENT_CATEGORY_ID->PlaceHolder = RemoveHtml($this->PATIENT_CATEGORY_ID->caption());

            // BOOKED_DATE
            $this->BOOKED_DATE->EditAttrs["class"] = "form-control";
            $this->BOOKED_DATE->EditCustomAttributes = "";
            $this->BOOKED_DATE->EditValue = HtmlEncode(FormatDateTime($this->BOOKED_DATE->CurrentValue, 8));
            $this->BOOKED_DATE->PlaceHolder = RemoveHtml($this->BOOKED_DATE->caption());

            // VISIT_DATE
            $this->VISIT_DATE->EditAttrs["class"] = "form-control";
            $this->VISIT_DATE->EditCustomAttributes = "";
            $this->VISIT_DATE->EditValue = HtmlEncode(FormatDateTime($this->VISIT_DATE->CurrentValue, 8));
            $this->VISIT_DATE->PlaceHolder = RemoveHtml($this->VISIT_DATE->caption());

            // ISNEW
            $this->ISNEW->EditAttrs["class"] = "form-control";
            $this->ISNEW->EditCustomAttributes = "";
            if (!$this->ISNEW->Raw) {
                $this->ISNEW->CurrentValue = HtmlDecode($this->ISNEW->CurrentValue);
            }
            $this->ISNEW->EditValue = HtmlEncode($this->ISNEW->CurrentValue);
            $this->ISNEW->PlaceHolder = RemoveHtml($this->ISNEW->caption());

            // FOLLOW_UP
            $this->FOLLOW_UP->EditAttrs["class"] = "form-control";
            $this->FOLLOW_UP->EditCustomAttributes = "";
            $this->FOLLOW_UP->EditValue = HtmlEncode($this->FOLLOW_UP->CurrentValue);
            $this->FOLLOW_UP->PlaceHolder = RemoveHtml($this->FOLLOW_UP->caption());

            // PLACE_TYPE
            $this->PLACE_TYPE->EditAttrs["class"] = "form-control";
            $this->PLACE_TYPE->EditCustomAttributes = "";
            $this->PLACE_TYPE->EditValue = HtmlEncode($this->PLACE_TYPE->CurrentValue);
            $this->PLACE_TYPE->PlaceHolder = RemoveHtml($this->PLACE_TYPE->caption());

            // CLINIC_ID
            $this->CLINIC_ID->EditAttrs["class"] = "form-control";
            $this->CLINIC_ID->EditCustomAttributes = "";
            if (!$this->CLINIC_ID->Raw) {
                $this->CLINIC_ID->CurrentValue = HtmlDecode($this->CLINIC_ID->CurrentValue);
            }
            $this->CLINIC_ID->EditValue = HtmlEncode($this->CLINIC_ID->CurrentValue);
            $this->CLINIC_ID->PlaceHolder = RemoveHtml($this->CLINIC_ID->caption());

            // CLINIC_ID_FROM
            $this->CLINIC_ID_FROM->EditAttrs["class"] = "form-control";
            $this->CLINIC_ID_FROM->EditCustomAttributes = "";
            if (!$this->CLINIC_ID_FROM->Raw) {
                $this->CLINIC_ID_FROM->CurrentValue = HtmlDecode($this->CLINIC_ID_FROM->CurrentValue);
            }
            $this->CLINIC_ID_FROM->EditValue = HtmlEncode($this->CLINIC_ID_FROM->CurrentValue);
            $this->CLINIC_ID_FROM->PlaceHolder = RemoveHtml($this->CLINIC_ID_FROM->caption());

            // CLASS_ROOM_ID
            $this->CLASS_ROOM_ID->EditAttrs["class"] = "form-control";
            $this->CLASS_ROOM_ID->EditCustomAttributes = "";
            if (!$this->CLASS_ROOM_ID->Raw) {
                $this->CLASS_ROOM_ID->CurrentValue = HtmlDecode($this->CLASS_ROOM_ID->CurrentValue);
            }
            $this->CLASS_ROOM_ID->EditValue = HtmlEncode($this->CLASS_ROOM_ID->CurrentValue);
            $this->CLASS_ROOM_ID->PlaceHolder = RemoveHtml($this->CLASS_ROOM_ID->caption());

            // BED_ID
            $this->BED_ID->EditAttrs["class"] = "form-control";
            $this->BED_ID->EditCustomAttributes = "";
            $this->BED_ID->EditValue = HtmlEncode($this->BED_ID->CurrentValue);
            $this->BED_ID->PlaceHolder = RemoveHtml($this->BED_ID->caption());

            // KELUAR_ID
            $this->KELUAR_ID->EditAttrs["class"] = "form-control";
            $this->KELUAR_ID->EditCustomAttributes = "";
            $this->KELUAR_ID->EditValue = HtmlEncode($this->KELUAR_ID->CurrentValue);
            $this->KELUAR_ID->PlaceHolder = RemoveHtml($this->KELUAR_ID->caption());

            // IN_DATE
            $this->IN_DATE->EditAttrs["class"] = "form-control";
            $this->IN_DATE->EditCustomAttributes = "";
            $this->IN_DATE->EditValue = HtmlEncode(FormatDateTime($this->IN_DATE->CurrentValue, 8));
            $this->IN_DATE->PlaceHolder = RemoveHtml($this->IN_DATE->caption());

            // EXIT_DATE
            $this->EXIT_DATE->EditAttrs["class"] = "form-control";
            $this->EXIT_DATE->EditCustomAttributes = "";
            $this->EXIT_DATE->EditValue = HtmlEncode(FormatDateTime($this->EXIT_DATE->CurrentValue, 8));
            $this->EXIT_DATE->PlaceHolder = RemoveHtml($this->EXIT_DATE->caption());

            // DIANTAR_OLEH
            $this->DIANTAR_OLEH->EditAttrs["class"] = "form-control";
            $this->DIANTAR_OLEH->EditCustomAttributes = "";
            if (!$this->DIANTAR_OLEH->Raw) {
                $this->DIANTAR_OLEH->CurrentValue = HtmlDecode($this->DIANTAR_OLEH->CurrentValue);
            }
            $this->DIANTAR_OLEH->EditValue = HtmlEncode($this->DIANTAR_OLEH->CurrentValue);
            $this->DIANTAR_OLEH->PlaceHolder = RemoveHtml($this->DIANTAR_OLEH->caption());

            // GENDER
            $this->GENDER->EditAttrs["class"] = "form-control";
            $this->GENDER->EditCustomAttributes = "";
            if (!$this->GENDER->Raw) {
                $this->GENDER->CurrentValue = HtmlDecode($this->GENDER->CurrentValue);
            }
            $this->GENDER->EditValue = HtmlEncode($this->GENDER->CurrentValue);
            $this->GENDER->PlaceHolder = RemoveHtml($this->GENDER->caption());

            // DESCRIPTION
            $this->DESCRIPTION->EditAttrs["class"] = "form-control";
            $this->DESCRIPTION->EditCustomAttributes = "";
            if (!$this->DESCRIPTION->Raw) {
                $this->DESCRIPTION->CurrentValue = HtmlDecode($this->DESCRIPTION->CurrentValue);
            }
            $this->DESCRIPTION->EditValue = HtmlEncode($this->DESCRIPTION->CurrentValue);
            $this->DESCRIPTION->PlaceHolder = RemoveHtml($this->DESCRIPTION->caption());

            // VISITOR_ADDRESS
            $this->VISITOR_ADDRESS->EditAttrs["class"] = "form-control";
            $this->VISITOR_ADDRESS->EditCustomAttributes = "";
            if (!$this->VISITOR_ADDRESS->Raw) {
                $this->VISITOR_ADDRESS->CurrentValue = HtmlDecode($this->VISITOR_ADDRESS->CurrentValue);
            }
            $this->VISITOR_ADDRESS->EditValue = HtmlEncode($this->VISITOR_ADDRESS->CurrentValue);
            $this->VISITOR_ADDRESS->PlaceHolder = RemoveHtml($this->VISITOR_ADDRESS->caption());

            // MODIFIED_BY
            $this->MODIFIED_BY->EditAttrs["class"] = "form-control";
            $this->MODIFIED_BY->EditCustomAttributes = "";
            if (!$this->MODIFIED_BY->Raw) {
                $this->MODIFIED_BY->CurrentValue = HtmlDecode($this->MODIFIED_BY->CurrentValue);
            }
            $this->MODIFIED_BY->EditValue = HtmlEncode($this->MODIFIED_BY->CurrentValue);
            $this->MODIFIED_BY->PlaceHolder = RemoveHtml($this->MODIFIED_BY->caption());

            // MODIFIED_DATE
            $this->MODIFIED_DATE->EditAttrs["class"] = "form-control";
            $this->MODIFIED_DATE->EditCustomAttributes = "";
            $this->MODIFIED_DATE->EditValue = HtmlEncode(FormatDateTime($this->MODIFIED_DATE->CurrentValue, 8));
            $this->MODIFIED_DATE->PlaceHolder = RemoveHtml($this->MODIFIED_DATE->caption());

            // MODIFIED_FROM
            $this->MODIFIED_FROM->EditAttrs["class"] = "form-control";
            $this->MODIFIED_FROM->EditCustomAttributes = "";
            if (!$this->MODIFIED_FROM->Raw) {
                $this->MODIFIED_FROM->CurrentValue = HtmlDecode($this->MODIFIED_FROM->CurrentValue);
            }
            $this->MODIFIED_FROM->EditValue = HtmlEncode($this->MODIFIED_FROM->CurrentValue);
            $this->MODIFIED_FROM->PlaceHolder = RemoveHtml($this->MODIFIED_FROM->caption());

            // EMPLOYEE_ID
            $this->EMPLOYEE_ID->EditAttrs["class"] = "form-control";
            $this->EMPLOYEE_ID->EditCustomAttributes = "";
            if (!$this->EMPLOYEE_ID->Raw) {
                $this->EMPLOYEE_ID->CurrentValue = HtmlDecode($this->EMPLOYEE_ID->CurrentValue);
            }
            $this->EMPLOYEE_ID->EditValue = HtmlEncode($this->EMPLOYEE_ID->CurrentValue);
            $this->EMPLOYEE_ID->PlaceHolder = RemoveHtml($this->EMPLOYEE_ID->caption());

            // EMPLOYEE_ID_FROM
            $this->EMPLOYEE_ID_FROM->EditAttrs["class"] = "form-control";
            $this->EMPLOYEE_ID_FROM->EditCustomAttributes = "";
            if (!$this->EMPLOYEE_ID_FROM->Raw) {
                $this->EMPLOYEE_ID_FROM->CurrentValue = HtmlDecode($this->EMPLOYEE_ID_FROM->CurrentValue);
            }
            $this->EMPLOYEE_ID_FROM->EditValue = HtmlEncode($this->EMPLOYEE_ID_FROM->CurrentValue);
            $this->EMPLOYEE_ID_FROM->PlaceHolder = RemoveHtml($this->EMPLOYEE_ID_FROM->caption());

            // RESPONSIBLE_ID
            $this->RESPONSIBLE_ID->EditAttrs["class"] = "form-control";
            $this->RESPONSIBLE_ID->EditCustomAttributes = "";
            $this->RESPONSIBLE_ID->EditValue = HtmlEncode($this->RESPONSIBLE_ID->CurrentValue);
            $this->RESPONSIBLE_ID->PlaceHolder = RemoveHtml($this->RESPONSIBLE_ID->caption());

            // RESPONSIBLE
            $this->RESPONSIBLE->EditAttrs["class"] = "form-control";
            $this->RESPONSIBLE->EditCustomAttributes = "";
            if (!$this->RESPONSIBLE->Raw) {
                $this->RESPONSIBLE->CurrentValue = HtmlDecode($this->RESPONSIBLE->CurrentValue);
            }
            $this->RESPONSIBLE->EditValue = HtmlEncode($this->RESPONSIBLE->CurrentValue);
            $this->RESPONSIBLE->PlaceHolder = RemoveHtml($this->RESPONSIBLE->caption());

            // FAMILY_STATUS_ID
            $this->FAMILY_STATUS_ID->EditAttrs["class"] = "form-control";
            $this->FAMILY_STATUS_ID->EditCustomAttributes = "";
            $this->FAMILY_STATUS_ID->EditValue = HtmlEncode($this->FAMILY_STATUS_ID->CurrentValue);
            $this->FAMILY_STATUS_ID->PlaceHolder = RemoveHtml($this->FAMILY_STATUS_ID->caption());

            // TICKET_NO
            $this->TICKET_NO->EditAttrs["class"] = "form-control";
            $this->TICKET_NO->EditCustomAttributes = "";
            $this->TICKET_NO->EditValue = HtmlEncode($this->TICKET_NO->CurrentValue);
            $this->TICKET_NO->PlaceHolder = RemoveHtml($this->TICKET_NO->caption());

            // ISATTENDED
            $this->ISATTENDED->EditAttrs["class"] = "form-control";
            $this->ISATTENDED->EditCustomAttributes = "";
            if (!$this->ISATTENDED->Raw) {
                $this->ISATTENDED->CurrentValue = HtmlDecode($this->ISATTENDED->CurrentValue);
            }
            $this->ISATTENDED->EditValue = HtmlEncode($this->ISATTENDED->CurrentValue);
            $this->ISATTENDED->PlaceHolder = RemoveHtml($this->ISATTENDED->caption());

            // PAYOR_ID
            $this->PAYOR_ID->EditAttrs["class"] = "form-control";
            $this->PAYOR_ID->EditCustomAttributes = "";
            if (!$this->PAYOR_ID->Raw) {
                $this->PAYOR_ID->CurrentValue = HtmlDecode($this->PAYOR_ID->CurrentValue);
            }
            $this->PAYOR_ID->EditValue = HtmlEncode($this->PAYOR_ID->CurrentValue);
            $this->PAYOR_ID->PlaceHolder = RemoveHtml($this->PAYOR_ID->caption());

            // CLASS_ID
            $this->CLASS_ID->EditAttrs["class"] = "form-control";
            $this->CLASS_ID->EditCustomAttributes = "";
            $this->CLASS_ID->EditValue = HtmlEncode($this->CLASS_ID->CurrentValue);
            $this->CLASS_ID->PlaceHolder = RemoveHtml($this->CLASS_ID->caption());

            // ISPERTARIF
            $this->ISPERTARIF->EditAttrs["class"] = "form-control";
            $this->ISPERTARIF->EditCustomAttributes = "";
            if (!$this->ISPERTARIF->Raw) {
                $this->ISPERTARIF->CurrentValue = HtmlDecode($this->ISPERTARIF->CurrentValue);
            }
            $this->ISPERTARIF->EditValue = HtmlEncode($this->ISPERTARIF->CurrentValue);
            $this->ISPERTARIF->PlaceHolder = RemoveHtml($this->ISPERTARIF->caption());

            // KAL_ID
            $this->KAL_ID->EditAttrs["class"] = "form-control";
            $this->KAL_ID->EditCustomAttributes = "";
            if (!$this->KAL_ID->Raw) {
                $this->KAL_ID->CurrentValue = HtmlDecode($this->KAL_ID->CurrentValue);
            }
            $this->KAL_ID->EditValue = HtmlEncode($this->KAL_ID->CurrentValue);
            $this->KAL_ID->PlaceHolder = RemoveHtml($this->KAL_ID->caption());

            // EMPLOYEE_INAP
            $this->EMPLOYEE_INAP->EditAttrs["class"] = "form-control";
            $this->EMPLOYEE_INAP->EditCustomAttributes = "";
            if (!$this->EMPLOYEE_INAP->Raw) {
                $this->EMPLOYEE_INAP->CurrentValue = HtmlDecode($this->EMPLOYEE_INAP->CurrentValue);
            }
            $this->EMPLOYEE_INAP->EditValue = HtmlEncode($this->EMPLOYEE_INAP->CurrentValue);
            $this->EMPLOYEE_INAP->PlaceHolder = RemoveHtml($this->EMPLOYEE_INAP->caption());

            // PASIEN_ID
            $this->PASIEN_ID->EditAttrs["class"] = "form-control";
            $this->PASIEN_ID->EditCustomAttributes = "";
            if (!$this->PASIEN_ID->Raw) {
                $this->PASIEN_ID->CurrentValue = HtmlDecode($this->PASIEN_ID->CurrentValue);
            }
            $this->PASIEN_ID->EditValue = HtmlEncode($this->PASIEN_ID->CurrentValue);
            $this->PASIEN_ID->PlaceHolder = RemoveHtml($this->PASIEN_ID->caption());

            // KARYAWAN
            $this->KARYAWAN->EditAttrs["class"] = "form-control";
            $this->KARYAWAN->EditCustomAttributes = "";
            if (!$this->KARYAWAN->Raw) {
                $this->KARYAWAN->CurrentValue = HtmlDecode($this->KARYAWAN->CurrentValue);
            }
            $this->KARYAWAN->EditValue = HtmlEncode($this->KARYAWAN->CurrentValue);
            $this->KARYAWAN->PlaceHolder = RemoveHtml($this->KARYAWAN->caption());

            // ACCOUNT_ID
            $this->ACCOUNT_ID->EditAttrs["class"] = "form-control";
            $this->ACCOUNT_ID->EditCustomAttributes = "";
            if (!$this->ACCOUNT_ID->Raw) {
                $this->ACCOUNT_ID->CurrentValue = HtmlDecode($this->ACCOUNT_ID->CurrentValue);
            }
            $this->ACCOUNT_ID->EditValue = HtmlEncode($this->ACCOUNT_ID->CurrentValue);
            $this->ACCOUNT_ID->PlaceHolder = RemoveHtml($this->ACCOUNT_ID->caption());

            // CLASS_ID_PLAFOND
            $this->CLASS_ID_PLAFOND->EditAttrs["class"] = "form-control";
            $this->CLASS_ID_PLAFOND->EditCustomAttributes = "";
            $this->CLASS_ID_PLAFOND->EditValue = HtmlEncode($this->CLASS_ID_PLAFOND->CurrentValue);
            $this->CLASS_ID_PLAFOND->PlaceHolder = RemoveHtml($this->CLASS_ID_PLAFOND->caption());

            // BACKCHARGE
            $this->BACKCHARGE->EditAttrs["class"] = "form-control";
            $this->BACKCHARGE->EditCustomAttributes = "";
            if (!$this->BACKCHARGE->Raw) {
                $this->BACKCHARGE->CurrentValue = HtmlDecode($this->BACKCHARGE->CurrentValue);
            }
            $this->BACKCHARGE->EditValue = HtmlEncode($this->BACKCHARGE->CurrentValue);
            $this->BACKCHARGE->PlaceHolder = RemoveHtml($this->BACKCHARGE->caption());

            // COVERAGE_ID
            $this->COVERAGE_ID->EditAttrs["class"] = "form-control";
            $this->COVERAGE_ID->EditCustomAttributes = "";
            $this->COVERAGE_ID->EditValue = HtmlEncode($this->COVERAGE_ID->CurrentValue);
            $this->COVERAGE_ID->PlaceHolder = RemoveHtml($this->COVERAGE_ID->caption());

            // AGEYEAR
            $this->AGEYEAR->EditAttrs["class"] = "form-control";
            $this->AGEYEAR->EditCustomAttributes = "";
            $this->AGEYEAR->EditValue = HtmlEncode($this->AGEYEAR->CurrentValue);
            $this->AGEYEAR->PlaceHolder = RemoveHtml($this->AGEYEAR->caption());

            // AGEMONTH
            $this->AGEMONTH->EditAttrs["class"] = "form-control";
            $this->AGEMONTH->EditCustomAttributes = "";
            $this->AGEMONTH->EditValue = HtmlEncode($this->AGEMONTH->CurrentValue);
            $this->AGEMONTH->PlaceHolder = RemoveHtml($this->AGEMONTH->caption());

            // AGEDAY
            $this->AGEDAY->EditAttrs["class"] = "form-control";
            $this->AGEDAY->EditCustomAttributes = "";
            $this->AGEDAY->EditValue = HtmlEncode($this->AGEDAY->CurrentValue);
            $this->AGEDAY->PlaceHolder = RemoveHtml($this->AGEDAY->caption());

            // RECOMENDATION
            $this->RECOMENDATION->EditAttrs["class"] = "form-control";
            $this->RECOMENDATION->EditCustomAttributes = "";
            if (!$this->RECOMENDATION->Raw) {
                $this->RECOMENDATION->CurrentValue = HtmlDecode($this->RECOMENDATION->CurrentValue);
            }
            $this->RECOMENDATION->EditValue = HtmlEncode($this->RECOMENDATION->CurrentValue);
            $this->RECOMENDATION->PlaceHolder = RemoveHtml($this->RECOMENDATION->caption());

            // CONCLUSION
            $this->CONCLUSION->EditAttrs["class"] = "form-control";
            $this->CONCLUSION->EditCustomAttributes = "";
            if (!$this->CONCLUSION->Raw) {
                $this->CONCLUSION->CurrentValue = HtmlDecode($this->CONCLUSION->CurrentValue);
            }
            $this->CONCLUSION->EditValue = HtmlEncode($this->CONCLUSION->CurrentValue);
            $this->CONCLUSION->PlaceHolder = RemoveHtml($this->CONCLUSION->caption());

            // SPECIMENNO
            $this->SPECIMENNO->EditAttrs["class"] = "form-control";
            $this->SPECIMENNO->EditCustomAttributes = "";
            if (!$this->SPECIMENNO->Raw) {
                $this->SPECIMENNO->CurrentValue = HtmlDecode($this->SPECIMENNO->CurrentValue);
            }
            $this->SPECIMENNO->EditValue = HtmlEncode($this->SPECIMENNO->CurrentValue);
            $this->SPECIMENNO->PlaceHolder = RemoveHtml($this->SPECIMENNO->caption());

            // LOCKED
            $this->LOCKED->EditAttrs["class"] = "form-control";
            $this->LOCKED->EditCustomAttributes = "";
            if (!$this->LOCKED->Raw) {
                $this->LOCKED->CurrentValue = HtmlDecode($this->LOCKED->CurrentValue);
            }
            $this->LOCKED->EditValue = HtmlEncode($this->LOCKED->CurrentValue);
            $this->LOCKED->PlaceHolder = RemoveHtml($this->LOCKED->caption());

            // RM_OUT_DATE
            $this->RM_OUT_DATE->EditAttrs["class"] = "form-control";
            $this->RM_OUT_DATE->EditCustomAttributes = "";
            $this->RM_OUT_DATE->EditValue = HtmlEncode(FormatDateTime($this->RM_OUT_DATE->CurrentValue, 8));
            $this->RM_OUT_DATE->PlaceHolder = RemoveHtml($this->RM_OUT_DATE->caption());

            // RM_IN_DATE
            $this->RM_IN_DATE->EditAttrs["class"] = "form-control";
            $this->RM_IN_DATE->EditCustomAttributes = "";
            $this->RM_IN_DATE->EditValue = HtmlEncode(FormatDateTime($this->RM_IN_DATE->CurrentValue, 8));
            $this->RM_IN_DATE->PlaceHolder = RemoveHtml($this->RM_IN_DATE->caption());

            // LAMA_PINJAM
            $this->LAMA_PINJAM->EditAttrs["class"] = "form-control";
            $this->LAMA_PINJAM->EditCustomAttributes = "";
            $this->LAMA_PINJAM->EditValue = HtmlEncode(FormatDateTime($this->LAMA_PINJAM->CurrentValue, 8));
            $this->LAMA_PINJAM->PlaceHolder = RemoveHtml($this->LAMA_PINJAM->caption());

            // STANDAR_RJ
            $this->STANDAR_RJ->EditAttrs["class"] = "form-control";
            $this->STANDAR_RJ->EditCustomAttributes = "";
            if (!$this->STANDAR_RJ->Raw) {
                $this->STANDAR_RJ->CurrentValue = HtmlDecode($this->STANDAR_RJ->CurrentValue);
            }
            $this->STANDAR_RJ->EditValue = HtmlEncode($this->STANDAR_RJ->CurrentValue);
            $this->STANDAR_RJ->PlaceHolder = RemoveHtml($this->STANDAR_RJ->caption());

            // LENGKAP_RJ
            $this->LENGKAP_RJ->EditAttrs["class"] = "form-control";
            $this->LENGKAP_RJ->EditCustomAttributes = "";
            if (!$this->LENGKAP_RJ->Raw) {
                $this->LENGKAP_RJ->CurrentValue = HtmlDecode($this->LENGKAP_RJ->CurrentValue);
            }
            $this->LENGKAP_RJ->EditValue = HtmlEncode($this->LENGKAP_RJ->CurrentValue);
            $this->LENGKAP_RJ->PlaceHolder = RemoveHtml($this->LENGKAP_RJ->caption());

            // LENGKAP_RI
            $this->LENGKAP_RI->EditAttrs["class"] = "form-control";
            $this->LENGKAP_RI->EditCustomAttributes = "";
            if (!$this->LENGKAP_RI->Raw) {
                $this->LENGKAP_RI->CurrentValue = HtmlDecode($this->LENGKAP_RI->CurrentValue);
            }
            $this->LENGKAP_RI->EditValue = HtmlEncode($this->LENGKAP_RI->CurrentValue);
            $this->LENGKAP_RI->PlaceHolder = RemoveHtml($this->LENGKAP_RI->caption());

            // RESEND_RM_DATE
            $this->RESEND_RM_DATE->EditAttrs["class"] = "form-control";
            $this->RESEND_RM_DATE->EditCustomAttributes = "";
            $this->RESEND_RM_DATE->EditValue = HtmlEncode(FormatDateTime($this->RESEND_RM_DATE->CurrentValue, 8));
            $this->RESEND_RM_DATE->PlaceHolder = RemoveHtml($this->RESEND_RM_DATE->caption());

            // LENGKAP_RM1
            $this->LENGKAP_RM1->EditAttrs["class"] = "form-control";
            $this->LENGKAP_RM1->EditCustomAttributes = "";
            if (!$this->LENGKAP_RM1->Raw) {
                $this->LENGKAP_RM1->CurrentValue = HtmlDecode($this->LENGKAP_RM1->CurrentValue);
            }
            $this->LENGKAP_RM1->EditValue = HtmlEncode($this->LENGKAP_RM1->CurrentValue);
            $this->LENGKAP_RM1->PlaceHolder = RemoveHtml($this->LENGKAP_RM1->caption());

            // LENGKAP_RESUME
            $this->LENGKAP_RESUME->EditAttrs["class"] = "form-control";
            $this->LENGKAP_RESUME->EditCustomAttributes = "";
            if (!$this->LENGKAP_RESUME->Raw) {
                $this->LENGKAP_RESUME->CurrentValue = HtmlDecode($this->LENGKAP_RESUME->CurrentValue);
            }
            $this->LENGKAP_RESUME->EditValue = HtmlEncode($this->LENGKAP_RESUME->CurrentValue);
            $this->LENGKAP_RESUME->PlaceHolder = RemoveHtml($this->LENGKAP_RESUME->caption());

            // LENGKAP_ANAMNESIS
            $this->LENGKAP_ANAMNESIS->EditAttrs["class"] = "form-control";
            $this->LENGKAP_ANAMNESIS->EditCustomAttributes = "";
            if (!$this->LENGKAP_ANAMNESIS->Raw) {
                $this->LENGKAP_ANAMNESIS->CurrentValue = HtmlDecode($this->LENGKAP_ANAMNESIS->CurrentValue);
            }
            $this->LENGKAP_ANAMNESIS->EditValue = HtmlEncode($this->LENGKAP_ANAMNESIS->CurrentValue);
            $this->LENGKAP_ANAMNESIS->PlaceHolder = RemoveHtml($this->LENGKAP_ANAMNESIS->caption());

            // LENGKAP_CONSENT
            $this->LENGKAP_CONSENT->EditAttrs["class"] = "form-control";
            $this->LENGKAP_CONSENT->EditCustomAttributes = "";
            if (!$this->LENGKAP_CONSENT->Raw) {
                $this->LENGKAP_CONSENT->CurrentValue = HtmlDecode($this->LENGKAP_CONSENT->CurrentValue);
            }
            $this->LENGKAP_CONSENT->EditValue = HtmlEncode($this->LENGKAP_CONSENT->CurrentValue);
            $this->LENGKAP_CONSENT->PlaceHolder = RemoveHtml($this->LENGKAP_CONSENT->caption());

            // LENGKAP_ANESTESI
            $this->LENGKAP_ANESTESI->EditAttrs["class"] = "form-control";
            $this->LENGKAP_ANESTESI->EditCustomAttributes = "";
            if (!$this->LENGKAP_ANESTESI->Raw) {
                $this->LENGKAP_ANESTESI->CurrentValue = HtmlDecode($this->LENGKAP_ANESTESI->CurrentValue);
            }
            $this->LENGKAP_ANESTESI->EditValue = HtmlEncode($this->LENGKAP_ANESTESI->CurrentValue);
            $this->LENGKAP_ANESTESI->PlaceHolder = RemoveHtml($this->LENGKAP_ANESTESI->caption());

            // LENGKAP_OP
            $this->LENGKAP_OP->EditAttrs["class"] = "form-control";
            $this->LENGKAP_OP->EditCustomAttributes = "";
            if (!$this->LENGKAP_OP->Raw) {
                $this->LENGKAP_OP->CurrentValue = HtmlDecode($this->LENGKAP_OP->CurrentValue);
            }
            $this->LENGKAP_OP->EditValue = HtmlEncode($this->LENGKAP_OP->CurrentValue);
            $this->LENGKAP_OP->PlaceHolder = RemoveHtml($this->LENGKAP_OP->caption());

            // BACK_RM_DATE
            $this->BACK_RM_DATE->EditAttrs["class"] = "form-control";
            $this->BACK_RM_DATE->EditCustomAttributes = "";
            $this->BACK_RM_DATE->EditValue = HtmlEncode(FormatDateTime($this->BACK_RM_DATE->CurrentValue, 8));
            $this->BACK_RM_DATE->PlaceHolder = RemoveHtml($this->BACK_RM_DATE->caption());

            // VALID_RM_DATE
            $this->VALID_RM_DATE->EditAttrs["class"] = "form-control";
            $this->VALID_RM_DATE->EditCustomAttributes = "";
            $this->VALID_RM_DATE->EditValue = HtmlEncode(FormatDateTime($this->VALID_RM_DATE->CurrentValue, 8));
            $this->VALID_RM_DATE->PlaceHolder = RemoveHtml($this->VALID_RM_DATE->caption());

            // NO_SKP
            $this->NO_SKP->EditAttrs["class"] = "form-control";
            $this->NO_SKP->EditCustomAttributes = "";
            if (!$this->NO_SKP->Raw) {
                $this->NO_SKP->CurrentValue = HtmlDecode($this->NO_SKP->CurrentValue);
            }
            $this->NO_SKP->EditValue = HtmlEncode($this->NO_SKP->CurrentValue);
            $this->NO_SKP->PlaceHolder = RemoveHtml($this->NO_SKP->caption());

            // NO_SKPINAP
            $this->NO_SKPINAP->EditAttrs["class"] = "form-control";
            $this->NO_SKPINAP->EditCustomAttributes = "";
            if (!$this->NO_SKPINAP->Raw) {
                $this->NO_SKPINAP->CurrentValue = HtmlDecode($this->NO_SKPINAP->CurrentValue);
            }
            $this->NO_SKPINAP->EditValue = HtmlEncode($this->NO_SKPINAP->CurrentValue);
            $this->NO_SKPINAP->PlaceHolder = RemoveHtml($this->NO_SKPINAP->caption());

            // DIAGNOSA_ID
            $this->DIAGNOSA_ID->EditAttrs["class"] = "form-control";
            $this->DIAGNOSA_ID->EditCustomAttributes = "";
            if (!$this->DIAGNOSA_ID->Raw) {
                $this->DIAGNOSA_ID->CurrentValue = HtmlDecode($this->DIAGNOSA_ID->CurrentValue);
            }
            $this->DIAGNOSA_ID->EditValue = HtmlEncode($this->DIAGNOSA_ID->CurrentValue);
            $this->DIAGNOSA_ID->PlaceHolder = RemoveHtml($this->DIAGNOSA_ID->caption());

            // ticket_all
            $this->ticket_all->EditAttrs["class"] = "form-control";
            $this->ticket_all->EditCustomAttributes = "";
            $this->ticket_all->EditValue = HtmlEncode($this->ticket_all->CurrentValue);
            $this->ticket_all->PlaceHolder = RemoveHtml($this->ticket_all->caption());

            // tanggal_rujukan
            $this->tanggal_rujukan->EditAttrs["class"] = "form-control";
            $this->tanggal_rujukan->EditCustomAttributes = "";
            $this->tanggal_rujukan->EditValue = HtmlEncode(FormatDateTime($this->tanggal_rujukan->CurrentValue, 8));
            $this->tanggal_rujukan->PlaceHolder = RemoveHtml($this->tanggal_rujukan->caption());

            // ISRJ
            $this->ISRJ->EditAttrs["class"] = "form-control";
            $this->ISRJ->EditCustomAttributes = "";
            if (!$this->ISRJ->Raw) {
                $this->ISRJ->CurrentValue = HtmlDecode($this->ISRJ->CurrentValue);
            }
            $this->ISRJ->EditValue = HtmlEncode($this->ISRJ->CurrentValue);
            $this->ISRJ->PlaceHolder = RemoveHtml($this->ISRJ->caption());

            // NORUJUKAN
            $this->NORUJUKAN->EditAttrs["class"] = "form-control";
            $this->NORUJUKAN->EditCustomAttributes = "";
            if (!$this->NORUJUKAN->Raw) {
                $this->NORUJUKAN->CurrentValue = HtmlDecode($this->NORUJUKAN->CurrentValue);
            }
            $this->NORUJUKAN->EditValue = HtmlEncode($this->NORUJUKAN->CurrentValue);
            $this->NORUJUKAN->PlaceHolder = RemoveHtml($this->NORUJUKAN->caption());

            // PPKRUJUKAN
            $this->PPKRUJUKAN->EditAttrs["class"] = "form-control";
            $this->PPKRUJUKAN->EditCustomAttributes = "";
            if (!$this->PPKRUJUKAN->Raw) {
                $this->PPKRUJUKAN->CurrentValue = HtmlDecode($this->PPKRUJUKAN->CurrentValue);
            }
            $this->PPKRUJUKAN->EditValue = HtmlEncode($this->PPKRUJUKAN->CurrentValue);
            $this->PPKRUJUKAN->PlaceHolder = RemoveHtml($this->PPKRUJUKAN->caption());

            // LOKASILAKA
            $this->LOKASILAKA->EditAttrs["class"] = "form-control";
            $this->LOKASILAKA->EditCustomAttributes = "";
            if (!$this->LOKASILAKA->Raw) {
                $this->LOKASILAKA->CurrentValue = HtmlDecode($this->LOKASILAKA->CurrentValue);
            }
            $this->LOKASILAKA->EditValue = HtmlEncode($this->LOKASILAKA->CurrentValue);
            $this->LOKASILAKA->PlaceHolder = RemoveHtml($this->LOKASILAKA->caption());

            // KDPOLI
            $this->KDPOLI->EditAttrs["class"] = "form-control";
            $this->KDPOLI->EditCustomAttributes = "";
            if (!$this->KDPOLI->Raw) {
                $this->KDPOLI->CurrentValue = HtmlDecode($this->KDPOLI->CurrentValue);
            }
            $this->KDPOLI->EditValue = HtmlEncode($this->KDPOLI->CurrentValue);
            $this->KDPOLI->PlaceHolder = RemoveHtml($this->KDPOLI->caption());

            // EDIT_SEP
            $this->EDIT_SEP->EditAttrs["class"] = "form-control";
            $this->EDIT_SEP->EditCustomAttributes = "";
            if (!$this->EDIT_SEP->Raw) {
                $this->EDIT_SEP->CurrentValue = HtmlDecode($this->EDIT_SEP->CurrentValue);
            }
            $this->EDIT_SEP->EditValue = HtmlEncode($this->EDIT_SEP->CurrentValue);
            $this->EDIT_SEP->PlaceHolder = RemoveHtml($this->EDIT_SEP->caption());

            // DELETE_SEP
            $this->DELETE_SEP->EditAttrs["class"] = "form-control";
            $this->DELETE_SEP->EditCustomAttributes = "";
            if (!$this->DELETE_SEP->Raw) {
                $this->DELETE_SEP->CurrentValue = HtmlDecode($this->DELETE_SEP->CurrentValue);
            }
            $this->DELETE_SEP->EditValue = HtmlEncode($this->DELETE_SEP->CurrentValue);
            $this->DELETE_SEP->PlaceHolder = RemoveHtml($this->DELETE_SEP->caption());

            // KODE_AGAMA
            $this->KODE_AGAMA->EditAttrs["class"] = "form-control";
            $this->KODE_AGAMA->EditCustomAttributes = "";
            $this->KODE_AGAMA->EditValue = HtmlEncode($this->KODE_AGAMA->CurrentValue);
            $this->KODE_AGAMA->PlaceHolder = RemoveHtml($this->KODE_AGAMA->caption());

            // DIAG_AWAL
            $this->DIAG_AWAL->EditAttrs["class"] = "form-control";
            $this->DIAG_AWAL->EditCustomAttributes = "";
            if (!$this->DIAG_AWAL->Raw) {
                $this->DIAG_AWAL->CurrentValue = HtmlDecode($this->DIAG_AWAL->CurrentValue);
            }
            $this->DIAG_AWAL->EditValue = HtmlEncode($this->DIAG_AWAL->CurrentValue);
            $this->DIAG_AWAL->PlaceHolder = RemoveHtml($this->DIAG_AWAL->caption());

            // AKTIF
            $this->AKTIF->EditAttrs["class"] = "form-control";
            $this->AKTIF->EditCustomAttributes = "";
            if (!$this->AKTIF->Raw) {
                $this->AKTIF->CurrentValue = HtmlDecode($this->AKTIF->CurrentValue);
            }
            $this->AKTIF->EditValue = HtmlEncode($this->AKTIF->CurrentValue);
            $this->AKTIF->PlaceHolder = RemoveHtml($this->AKTIF->caption());

            // BILL_INAP
            $this->BILL_INAP->EditAttrs["class"] = "form-control";
            $this->BILL_INAP->EditCustomAttributes = "";
            if (!$this->BILL_INAP->Raw) {
                $this->BILL_INAP->CurrentValue = HtmlDecode($this->BILL_INAP->CurrentValue);
            }
            $this->BILL_INAP->EditValue = HtmlEncode($this->BILL_INAP->CurrentValue);
            $this->BILL_INAP->PlaceHolder = RemoveHtml($this->BILL_INAP->caption());

            // SEP_PRINTDATE
            $this->SEP_PRINTDATE->EditAttrs["class"] = "form-control";
            $this->SEP_PRINTDATE->EditCustomAttributes = "";
            $this->SEP_PRINTDATE->EditValue = HtmlEncode(FormatDateTime($this->SEP_PRINTDATE->CurrentValue, 8));
            $this->SEP_PRINTDATE->PlaceHolder = RemoveHtml($this->SEP_PRINTDATE->caption());

            // MAPPING_SEP
            $this->MAPPING_SEP->EditAttrs["class"] = "form-control";
            $this->MAPPING_SEP->EditCustomAttributes = "";
            if (!$this->MAPPING_SEP->Raw) {
                $this->MAPPING_SEP->CurrentValue = HtmlDecode($this->MAPPING_SEP->CurrentValue);
            }
            $this->MAPPING_SEP->EditValue = HtmlEncode($this->MAPPING_SEP->CurrentValue);
            $this->MAPPING_SEP->PlaceHolder = RemoveHtml($this->MAPPING_SEP->caption());

            // TRANS_ID
            $this->TRANS_ID->EditAttrs["class"] = "form-control";
            $this->TRANS_ID->EditCustomAttributes = "";
            if (!$this->TRANS_ID->Raw) {
                $this->TRANS_ID->CurrentValue = HtmlDecode($this->TRANS_ID->CurrentValue);
            }
            $this->TRANS_ID->EditValue = HtmlEncode($this->TRANS_ID->CurrentValue);
            $this->TRANS_ID->PlaceHolder = RemoveHtml($this->TRANS_ID->caption());

            // KDPOLI_EKS
            $this->KDPOLI_EKS->EditAttrs["class"] = "form-control";
            $this->KDPOLI_EKS->EditCustomAttributes = "";
            if (!$this->KDPOLI_EKS->Raw) {
                $this->KDPOLI_EKS->CurrentValue = HtmlDecode($this->KDPOLI_EKS->CurrentValue);
            }
            $this->KDPOLI_EKS->EditValue = HtmlEncode($this->KDPOLI_EKS->CurrentValue);
            $this->KDPOLI_EKS->PlaceHolder = RemoveHtml($this->KDPOLI_EKS->caption());

            // COB
            $this->COB->EditAttrs["class"] = "form-control";
            $this->COB->EditCustomAttributes = "";
            if (!$this->COB->Raw) {
                $this->COB->CurrentValue = HtmlDecode($this->COB->CurrentValue);
            }
            $this->COB->EditValue = HtmlEncode($this->COB->CurrentValue);
            $this->COB->PlaceHolder = RemoveHtml($this->COB->caption());

            // PENJAMIN
            $this->PENJAMIN->EditAttrs["class"] = "form-control";
            $this->PENJAMIN->EditCustomAttributes = "";
            if (!$this->PENJAMIN->Raw) {
                $this->PENJAMIN->CurrentValue = HtmlDecode($this->PENJAMIN->CurrentValue);
            }
            $this->PENJAMIN->EditValue = HtmlEncode($this->PENJAMIN->CurrentValue);
            $this->PENJAMIN->PlaceHolder = RemoveHtml($this->PENJAMIN->caption());

            // ASALRUJUKAN
            $this->ASALRUJUKAN->EditAttrs["class"] = "form-control";
            $this->ASALRUJUKAN->EditCustomAttributes = "";
            if (!$this->ASALRUJUKAN->Raw) {
                $this->ASALRUJUKAN->CurrentValue = HtmlDecode($this->ASALRUJUKAN->CurrentValue);
            }
            $this->ASALRUJUKAN->EditValue = HtmlEncode($this->ASALRUJUKAN->CurrentValue);
            $this->ASALRUJUKAN->PlaceHolder = RemoveHtml($this->ASALRUJUKAN->caption());

            // RESPONSEP
            $this->RESPONSEP->EditAttrs["class"] = "form-control";
            $this->RESPONSEP->EditCustomAttributes = "";
            if (!$this->RESPONSEP->Raw) {
                $this->RESPONSEP->CurrentValue = HtmlDecode($this->RESPONSEP->CurrentValue);
            }
            $this->RESPONSEP->EditValue = HtmlEncode($this->RESPONSEP->CurrentValue);
            $this->RESPONSEP->PlaceHolder = RemoveHtml($this->RESPONSEP->caption());

            // APPROVAL_DESC
            $this->APPROVAL_DESC->EditAttrs["class"] = "form-control";
            $this->APPROVAL_DESC->EditCustomAttributes = "";
            if (!$this->APPROVAL_DESC->Raw) {
                $this->APPROVAL_DESC->CurrentValue = HtmlDecode($this->APPROVAL_DESC->CurrentValue);
            }
            $this->APPROVAL_DESC->EditValue = HtmlEncode($this->APPROVAL_DESC->CurrentValue);
            $this->APPROVAL_DESC->PlaceHolder = RemoveHtml($this->APPROVAL_DESC->caption());

            // APPROVAL_RESPONAJUKAN
            $this->APPROVAL_RESPONAJUKAN->EditAttrs["class"] = "form-control";
            $this->APPROVAL_RESPONAJUKAN->EditCustomAttributes = "";
            if (!$this->APPROVAL_RESPONAJUKAN->Raw) {
                $this->APPROVAL_RESPONAJUKAN->CurrentValue = HtmlDecode($this->APPROVAL_RESPONAJUKAN->CurrentValue);
            }
            $this->APPROVAL_RESPONAJUKAN->EditValue = HtmlEncode($this->APPROVAL_RESPONAJUKAN->CurrentValue);
            $this->APPROVAL_RESPONAJUKAN->PlaceHolder = RemoveHtml($this->APPROVAL_RESPONAJUKAN->caption());

            // APPROVAL_RESPONAPPROV
            $this->APPROVAL_RESPONAPPROV->EditAttrs["class"] = "form-control";
            $this->APPROVAL_RESPONAPPROV->EditCustomAttributes = "";
            if (!$this->APPROVAL_RESPONAPPROV->Raw) {
                $this->APPROVAL_RESPONAPPROV->CurrentValue = HtmlDecode($this->APPROVAL_RESPONAPPROV->CurrentValue);
            }
            $this->APPROVAL_RESPONAPPROV->EditValue = HtmlEncode($this->APPROVAL_RESPONAPPROV->CurrentValue);
            $this->APPROVAL_RESPONAPPROV->PlaceHolder = RemoveHtml($this->APPROVAL_RESPONAPPROV->caption());

            // RESPONTGLPLG_DESC
            $this->RESPONTGLPLG_DESC->EditAttrs["class"] = "form-control";
            $this->RESPONTGLPLG_DESC->EditCustomAttributes = "";
            if (!$this->RESPONTGLPLG_DESC->Raw) {
                $this->RESPONTGLPLG_DESC->CurrentValue = HtmlDecode($this->RESPONTGLPLG_DESC->CurrentValue);
            }
            $this->RESPONTGLPLG_DESC->EditValue = HtmlEncode($this->RESPONTGLPLG_DESC->CurrentValue);
            $this->RESPONTGLPLG_DESC->PlaceHolder = RemoveHtml($this->RESPONTGLPLG_DESC->caption());

            // RESPONPOST_VKLAIM
            $this->RESPONPOST_VKLAIM->EditAttrs["class"] = "form-control";
            $this->RESPONPOST_VKLAIM->EditCustomAttributes = "";
            if (!$this->RESPONPOST_VKLAIM->Raw) {
                $this->RESPONPOST_VKLAIM->CurrentValue = HtmlDecode($this->RESPONPOST_VKLAIM->CurrentValue);
            }
            $this->RESPONPOST_VKLAIM->EditValue = HtmlEncode($this->RESPONPOST_VKLAIM->CurrentValue);
            $this->RESPONPOST_VKLAIM->PlaceHolder = RemoveHtml($this->RESPONPOST_VKLAIM->caption());

            // RESPONPUT_VKLAIM
            $this->RESPONPUT_VKLAIM->EditAttrs["class"] = "form-control";
            $this->RESPONPUT_VKLAIM->EditCustomAttributes = "";
            if (!$this->RESPONPUT_VKLAIM->Raw) {
                $this->RESPONPUT_VKLAIM->CurrentValue = HtmlDecode($this->RESPONPUT_VKLAIM->CurrentValue);
            }
            $this->RESPONPUT_VKLAIM->EditValue = HtmlEncode($this->RESPONPUT_VKLAIM->CurrentValue);
            $this->RESPONPUT_VKLAIM->PlaceHolder = RemoveHtml($this->RESPONPUT_VKLAIM->caption());

            // RESPONDEL_VKLAIM
            $this->RESPONDEL_VKLAIM->EditAttrs["class"] = "form-control";
            $this->RESPONDEL_VKLAIM->EditCustomAttributes = "";
            if (!$this->RESPONDEL_VKLAIM->Raw) {
                $this->RESPONDEL_VKLAIM->CurrentValue = HtmlDecode($this->RESPONDEL_VKLAIM->CurrentValue);
            }
            $this->RESPONDEL_VKLAIM->EditValue = HtmlEncode($this->RESPONDEL_VKLAIM->CurrentValue);
            $this->RESPONDEL_VKLAIM->PlaceHolder = RemoveHtml($this->RESPONDEL_VKLAIM->caption());

            // CALL_TIMES
            $this->CALL_TIMES->EditAttrs["class"] = "form-control";
            $this->CALL_TIMES->EditCustomAttributes = "";
            $this->CALL_TIMES->EditValue = HtmlEncode($this->CALL_TIMES->CurrentValue);
            $this->CALL_TIMES->PlaceHolder = RemoveHtml($this->CALL_TIMES->caption());

            // CALL_DATE
            $this->CALL_DATE->EditAttrs["class"] = "form-control";
            $this->CALL_DATE->EditCustomAttributes = "";
            $this->CALL_DATE->EditValue = HtmlEncode(FormatDateTime($this->CALL_DATE->CurrentValue, 8));
            $this->CALL_DATE->PlaceHolder = RemoveHtml($this->CALL_DATE->caption());

            // CALL_DATES
            $this->CALL_DATES->EditAttrs["class"] = "form-control";
            $this->CALL_DATES->EditCustomAttributes = "";
            $this->CALL_DATES->EditValue = HtmlEncode(FormatDateTime($this->CALL_DATES->CurrentValue, 8));
            $this->CALL_DATES->PlaceHolder = RemoveHtml($this->CALL_DATES->caption());

            // SERVED_DATE
            $this->SERVED_DATE->EditAttrs["class"] = "form-control";
            $this->SERVED_DATE->EditCustomAttributes = "";
            $this->SERVED_DATE->EditValue = HtmlEncode(FormatDateTime($this->SERVED_DATE->CurrentValue, 8));
            $this->SERVED_DATE->PlaceHolder = RemoveHtml($this->SERVED_DATE->caption());

            // SERVED_INAP
            $this->SERVED_INAP->EditAttrs["class"] = "form-control";
            $this->SERVED_INAP->EditCustomAttributes = "";
            $this->SERVED_INAP->EditValue = HtmlEncode(FormatDateTime($this->SERVED_INAP->CurrentValue, 8));
            $this->SERVED_INAP->PlaceHolder = RemoveHtml($this->SERVED_INAP->caption());

            // KDDPJP1
            $this->KDDPJP1->EditAttrs["class"] = "form-control";
            $this->KDDPJP1->EditCustomAttributes = "";
            if (!$this->KDDPJP1->Raw) {
                $this->KDDPJP1->CurrentValue = HtmlDecode($this->KDDPJP1->CurrentValue);
            }
            $this->KDDPJP1->EditValue = HtmlEncode($this->KDDPJP1->CurrentValue);
            $this->KDDPJP1->PlaceHolder = RemoveHtml($this->KDDPJP1->caption());

            // KDDPJP
            $this->KDDPJP->EditAttrs["class"] = "form-control";
            $this->KDDPJP->EditCustomAttributes = "";
            if (!$this->KDDPJP->Raw) {
                $this->KDDPJP->CurrentValue = HtmlDecode($this->KDDPJP->CurrentValue);
            }
            $this->KDDPJP->EditValue = HtmlEncode($this->KDDPJP->CurrentValue);
            $this->KDDPJP->PlaceHolder = RemoveHtml($this->KDDPJP->caption());

            // tgl_kontrol
            $this->tgl_kontrol->EditAttrs["class"] = "form-control";
            $this->tgl_kontrol->EditCustomAttributes = "";
            $this->tgl_kontrol->EditValue = HtmlEncode(FormatDateTime($this->tgl_kontrol->CurrentValue, 8));
            $this->tgl_kontrol->PlaceHolder = RemoveHtml($this->tgl_kontrol->caption());

            // Add refer script

            // ORG_UNIT_CODE
            $this->ORG_UNIT_CODE->LinkCustomAttributes = "";
            $this->ORG_UNIT_CODE->HrefValue = "";

            // NO_REGISTRATION
            $this->NO_REGISTRATION->LinkCustomAttributes = "";
            $this->NO_REGISTRATION->HrefValue = "";

            // VISIT_ID
            $this->VISIT_ID->LinkCustomAttributes = "";
            $this->VISIT_ID->HrefValue = "";

            // STATUS_PASIEN_ID
            $this->STATUS_PASIEN_ID->LinkCustomAttributes = "";
            $this->STATUS_PASIEN_ID->HrefValue = "";

            // RUJUKAN_ID
            $this->RUJUKAN_ID->LinkCustomAttributes = "";
            $this->RUJUKAN_ID->HrefValue = "";

            // ADDRESS_OF_RUJUKAN
            $this->ADDRESS_OF_RUJUKAN->LinkCustomAttributes = "";
            $this->ADDRESS_OF_RUJUKAN->HrefValue = "";

            // REASON_ID
            $this->REASON_ID->LinkCustomAttributes = "";
            $this->REASON_ID->HrefValue = "";

            // WAY_ID
            $this->WAY_ID->LinkCustomAttributes = "";
            $this->WAY_ID->HrefValue = "";

            // PATIENT_CATEGORY_ID
            $this->PATIENT_CATEGORY_ID->LinkCustomAttributes = "";
            $this->PATIENT_CATEGORY_ID->HrefValue = "";

            // BOOKED_DATE
            $this->BOOKED_DATE->LinkCustomAttributes = "";
            $this->BOOKED_DATE->HrefValue = "";

            // VISIT_DATE
            $this->VISIT_DATE->LinkCustomAttributes = "";
            $this->VISIT_DATE->HrefValue = "";

            // ISNEW
            $this->ISNEW->LinkCustomAttributes = "";
            $this->ISNEW->HrefValue = "";

            // FOLLOW_UP
            $this->FOLLOW_UP->LinkCustomAttributes = "";
            $this->FOLLOW_UP->HrefValue = "";

            // PLACE_TYPE
            $this->PLACE_TYPE->LinkCustomAttributes = "";
            $this->PLACE_TYPE->HrefValue = "";

            // CLINIC_ID
            $this->CLINIC_ID->LinkCustomAttributes = "";
            $this->CLINIC_ID->HrefValue = "";

            // CLINIC_ID_FROM
            $this->CLINIC_ID_FROM->LinkCustomAttributes = "";
            $this->CLINIC_ID_FROM->HrefValue = "";

            // CLASS_ROOM_ID
            $this->CLASS_ROOM_ID->LinkCustomAttributes = "";
            $this->CLASS_ROOM_ID->HrefValue = "";

            // BED_ID
            $this->BED_ID->LinkCustomAttributes = "";
            $this->BED_ID->HrefValue = "";

            // KELUAR_ID
            $this->KELUAR_ID->LinkCustomAttributes = "";
            $this->KELUAR_ID->HrefValue = "";

            // IN_DATE
            $this->IN_DATE->LinkCustomAttributes = "";
            $this->IN_DATE->HrefValue = "";

            // EXIT_DATE
            $this->EXIT_DATE->LinkCustomAttributes = "";
            $this->EXIT_DATE->HrefValue = "";

            // DIANTAR_OLEH
            $this->DIANTAR_OLEH->LinkCustomAttributes = "";
            $this->DIANTAR_OLEH->HrefValue = "";

            // GENDER
            $this->GENDER->LinkCustomAttributes = "";
            $this->GENDER->HrefValue = "";

            // DESCRIPTION
            $this->DESCRIPTION->LinkCustomAttributes = "";
            $this->DESCRIPTION->HrefValue = "";

            // VISITOR_ADDRESS
            $this->VISITOR_ADDRESS->LinkCustomAttributes = "";
            $this->VISITOR_ADDRESS->HrefValue = "";

            // MODIFIED_BY
            $this->MODIFIED_BY->LinkCustomAttributes = "";
            $this->MODIFIED_BY->HrefValue = "";

            // MODIFIED_DATE
            $this->MODIFIED_DATE->LinkCustomAttributes = "";
            $this->MODIFIED_DATE->HrefValue = "";

            // MODIFIED_FROM
            $this->MODIFIED_FROM->LinkCustomAttributes = "";
            $this->MODIFIED_FROM->HrefValue = "";

            // EMPLOYEE_ID
            $this->EMPLOYEE_ID->LinkCustomAttributes = "";
            $this->EMPLOYEE_ID->HrefValue = "";

            // EMPLOYEE_ID_FROM
            $this->EMPLOYEE_ID_FROM->LinkCustomAttributes = "";
            $this->EMPLOYEE_ID_FROM->HrefValue = "";

            // RESPONSIBLE_ID
            $this->RESPONSIBLE_ID->LinkCustomAttributes = "";
            $this->RESPONSIBLE_ID->HrefValue = "";

            // RESPONSIBLE
            $this->RESPONSIBLE->LinkCustomAttributes = "";
            $this->RESPONSIBLE->HrefValue = "";

            // FAMILY_STATUS_ID
            $this->FAMILY_STATUS_ID->LinkCustomAttributes = "";
            $this->FAMILY_STATUS_ID->HrefValue = "";

            // TICKET_NO
            $this->TICKET_NO->LinkCustomAttributes = "";
            $this->TICKET_NO->HrefValue = "";

            // ISATTENDED
            $this->ISATTENDED->LinkCustomAttributes = "";
            $this->ISATTENDED->HrefValue = "";

            // PAYOR_ID
            $this->PAYOR_ID->LinkCustomAttributes = "";
            $this->PAYOR_ID->HrefValue = "";

            // CLASS_ID
            $this->CLASS_ID->LinkCustomAttributes = "";
            $this->CLASS_ID->HrefValue = "";

            // ISPERTARIF
            $this->ISPERTARIF->LinkCustomAttributes = "";
            $this->ISPERTARIF->HrefValue = "";

            // KAL_ID
            $this->KAL_ID->LinkCustomAttributes = "";
            $this->KAL_ID->HrefValue = "";

            // EMPLOYEE_INAP
            $this->EMPLOYEE_INAP->LinkCustomAttributes = "";
            $this->EMPLOYEE_INAP->HrefValue = "";

            // PASIEN_ID
            $this->PASIEN_ID->LinkCustomAttributes = "";
            $this->PASIEN_ID->HrefValue = "";

            // KARYAWAN
            $this->KARYAWAN->LinkCustomAttributes = "";
            $this->KARYAWAN->HrefValue = "";

            // ACCOUNT_ID
            $this->ACCOUNT_ID->LinkCustomAttributes = "";
            $this->ACCOUNT_ID->HrefValue = "";

            // CLASS_ID_PLAFOND
            $this->CLASS_ID_PLAFOND->LinkCustomAttributes = "";
            $this->CLASS_ID_PLAFOND->HrefValue = "";

            // BACKCHARGE
            $this->BACKCHARGE->LinkCustomAttributes = "";
            $this->BACKCHARGE->HrefValue = "";

            // COVERAGE_ID
            $this->COVERAGE_ID->LinkCustomAttributes = "";
            $this->COVERAGE_ID->HrefValue = "";

            // AGEYEAR
            $this->AGEYEAR->LinkCustomAttributes = "";
            $this->AGEYEAR->HrefValue = "";

            // AGEMONTH
            $this->AGEMONTH->LinkCustomAttributes = "";
            $this->AGEMONTH->HrefValue = "";

            // AGEDAY
            $this->AGEDAY->LinkCustomAttributes = "";
            $this->AGEDAY->HrefValue = "";

            // RECOMENDATION
            $this->RECOMENDATION->LinkCustomAttributes = "";
            $this->RECOMENDATION->HrefValue = "";

            // CONCLUSION
            $this->CONCLUSION->LinkCustomAttributes = "";
            $this->CONCLUSION->HrefValue = "";

            // SPECIMENNO
            $this->SPECIMENNO->LinkCustomAttributes = "";
            $this->SPECIMENNO->HrefValue = "";

            // LOCKED
            $this->LOCKED->LinkCustomAttributes = "";
            $this->LOCKED->HrefValue = "";

            // RM_OUT_DATE
            $this->RM_OUT_DATE->LinkCustomAttributes = "";
            $this->RM_OUT_DATE->HrefValue = "";

            // RM_IN_DATE
            $this->RM_IN_DATE->LinkCustomAttributes = "";
            $this->RM_IN_DATE->HrefValue = "";

            // LAMA_PINJAM
            $this->LAMA_PINJAM->LinkCustomAttributes = "";
            $this->LAMA_PINJAM->HrefValue = "";

            // STANDAR_RJ
            $this->STANDAR_RJ->LinkCustomAttributes = "";
            $this->STANDAR_RJ->HrefValue = "";

            // LENGKAP_RJ
            $this->LENGKAP_RJ->LinkCustomAttributes = "";
            $this->LENGKAP_RJ->HrefValue = "";

            // LENGKAP_RI
            $this->LENGKAP_RI->LinkCustomAttributes = "";
            $this->LENGKAP_RI->HrefValue = "";

            // RESEND_RM_DATE
            $this->RESEND_RM_DATE->LinkCustomAttributes = "";
            $this->RESEND_RM_DATE->HrefValue = "";

            // LENGKAP_RM1
            $this->LENGKAP_RM1->LinkCustomAttributes = "";
            $this->LENGKAP_RM1->HrefValue = "";

            // LENGKAP_RESUME
            $this->LENGKAP_RESUME->LinkCustomAttributes = "";
            $this->LENGKAP_RESUME->HrefValue = "";

            // LENGKAP_ANAMNESIS
            $this->LENGKAP_ANAMNESIS->LinkCustomAttributes = "";
            $this->LENGKAP_ANAMNESIS->HrefValue = "";

            // LENGKAP_CONSENT
            $this->LENGKAP_CONSENT->LinkCustomAttributes = "";
            $this->LENGKAP_CONSENT->HrefValue = "";

            // LENGKAP_ANESTESI
            $this->LENGKAP_ANESTESI->LinkCustomAttributes = "";
            $this->LENGKAP_ANESTESI->HrefValue = "";

            // LENGKAP_OP
            $this->LENGKAP_OP->LinkCustomAttributes = "";
            $this->LENGKAP_OP->HrefValue = "";

            // BACK_RM_DATE
            $this->BACK_RM_DATE->LinkCustomAttributes = "";
            $this->BACK_RM_DATE->HrefValue = "";

            // VALID_RM_DATE
            $this->VALID_RM_DATE->LinkCustomAttributes = "";
            $this->VALID_RM_DATE->HrefValue = "";

            // NO_SKP
            $this->NO_SKP->LinkCustomAttributes = "";
            $this->NO_SKP->HrefValue = "";

            // NO_SKPINAP
            $this->NO_SKPINAP->LinkCustomAttributes = "";
            $this->NO_SKPINAP->HrefValue = "";

            // DIAGNOSA_ID
            $this->DIAGNOSA_ID->LinkCustomAttributes = "";
            $this->DIAGNOSA_ID->HrefValue = "";

            // ticket_all
            $this->ticket_all->LinkCustomAttributes = "";
            $this->ticket_all->HrefValue = "";

            // tanggal_rujukan
            $this->tanggal_rujukan->LinkCustomAttributes = "";
            $this->tanggal_rujukan->HrefValue = "";

            // ISRJ
            $this->ISRJ->LinkCustomAttributes = "";
            $this->ISRJ->HrefValue = "";

            // NORUJUKAN
            $this->NORUJUKAN->LinkCustomAttributes = "";
            $this->NORUJUKAN->HrefValue = "";

            // PPKRUJUKAN
            $this->PPKRUJUKAN->LinkCustomAttributes = "";
            $this->PPKRUJUKAN->HrefValue = "";

            // LOKASILAKA
            $this->LOKASILAKA->LinkCustomAttributes = "";
            $this->LOKASILAKA->HrefValue = "";

            // KDPOLI
            $this->KDPOLI->LinkCustomAttributes = "";
            $this->KDPOLI->HrefValue = "";

            // EDIT_SEP
            $this->EDIT_SEP->LinkCustomAttributes = "";
            $this->EDIT_SEP->HrefValue = "";

            // DELETE_SEP
            $this->DELETE_SEP->LinkCustomAttributes = "";
            $this->DELETE_SEP->HrefValue = "";

            // KODE_AGAMA
            $this->KODE_AGAMA->LinkCustomAttributes = "";
            $this->KODE_AGAMA->HrefValue = "";

            // DIAG_AWAL
            $this->DIAG_AWAL->LinkCustomAttributes = "";
            $this->DIAG_AWAL->HrefValue = "";

            // AKTIF
            $this->AKTIF->LinkCustomAttributes = "";
            $this->AKTIF->HrefValue = "";

            // BILL_INAP
            $this->BILL_INAP->LinkCustomAttributes = "";
            $this->BILL_INAP->HrefValue = "";

            // SEP_PRINTDATE
            $this->SEP_PRINTDATE->LinkCustomAttributes = "";
            $this->SEP_PRINTDATE->HrefValue = "";

            // MAPPING_SEP
            $this->MAPPING_SEP->LinkCustomAttributes = "";
            $this->MAPPING_SEP->HrefValue = "";

            // TRANS_ID
            $this->TRANS_ID->LinkCustomAttributes = "";
            $this->TRANS_ID->HrefValue = "";

            // KDPOLI_EKS
            $this->KDPOLI_EKS->LinkCustomAttributes = "";
            $this->KDPOLI_EKS->HrefValue = "";

            // COB
            $this->COB->LinkCustomAttributes = "";
            $this->COB->HrefValue = "";

            // PENJAMIN
            $this->PENJAMIN->LinkCustomAttributes = "";
            $this->PENJAMIN->HrefValue = "";

            // ASALRUJUKAN
            $this->ASALRUJUKAN->LinkCustomAttributes = "";
            $this->ASALRUJUKAN->HrefValue = "";

            // RESPONSEP
            $this->RESPONSEP->LinkCustomAttributes = "";
            $this->RESPONSEP->HrefValue = "";

            // APPROVAL_DESC
            $this->APPROVAL_DESC->LinkCustomAttributes = "";
            $this->APPROVAL_DESC->HrefValue = "";

            // APPROVAL_RESPONAJUKAN
            $this->APPROVAL_RESPONAJUKAN->LinkCustomAttributes = "";
            $this->APPROVAL_RESPONAJUKAN->HrefValue = "";

            // APPROVAL_RESPONAPPROV
            $this->APPROVAL_RESPONAPPROV->LinkCustomAttributes = "";
            $this->APPROVAL_RESPONAPPROV->HrefValue = "";

            // RESPONTGLPLG_DESC
            $this->RESPONTGLPLG_DESC->LinkCustomAttributes = "";
            $this->RESPONTGLPLG_DESC->HrefValue = "";

            // RESPONPOST_VKLAIM
            $this->RESPONPOST_VKLAIM->LinkCustomAttributes = "";
            $this->RESPONPOST_VKLAIM->HrefValue = "";

            // RESPONPUT_VKLAIM
            $this->RESPONPUT_VKLAIM->LinkCustomAttributes = "";
            $this->RESPONPUT_VKLAIM->HrefValue = "";

            // RESPONDEL_VKLAIM
            $this->RESPONDEL_VKLAIM->LinkCustomAttributes = "";
            $this->RESPONDEL_VKLAIM->HrefValue = "";

            // CALL_TIMES
            $this->CALL_TIMES->LinkCustomAttributes = "";
            $this->CALL_TIMES->HrefValue = "";

            // CALL_DATE
            $this->CALL_DATE->LinkCustomAttributes = "";
            $this->CALL_DATE->HrefValue = "";

            // CALL_DATES
            $this->CALL_DATES->LinkCustomAttributes = "";
            $this->CALL_DATES->HrefValue = "";

            // SERVED_DATE
            $this->SERVED_DATE->LinkCustomAttributes = "";
            $this->SERVED_DATE->HrefValue = "";

            // SERVED_INAP
            $this->SERVED_INAP->LinkCustomAttributes = "";
            $this->SERVED_INAP->HrefValue = "";

            // KDDPJP1
            $this->KDDPJP1->LinkCustomAttributes = "";
            $this->KDDPJP1->HrefValue = "";

            // KDDPJP
            $this->KDDPJP->LinkCustomAttributes = "";
            $this->KDDPJP->HrefValue = "";

            // tgl_kontrol
            $this->tgl_kontrol->LinkCustomAttributes = "";
            $this->tgl_kontrol->HrefValue = "";
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
        if ($this->NO_REGISTRATION->Required) {
            if (!$this->NO_REGISTRATION->IsDetailKey && EmptyValue($this->NO_REGISTRATION->FormValue)) {
                $this->NO_REGISTRATION->addErrorMessage(str_replace("%s", $this->NO_REGISTRATION->caption(), $this->NO_REGISTRATION->RequiredErrorMessage));
            }
        }
        if ($this->VISIT_ID->Required) {
            if (!$this->VISIT_ID->IsDetailKey && EmptyValue($this->VISIT_ID->FormValue)) {
                $this->VISIT_ID->addErrorMessage(str_replace("%s", $this->VISIT_ID->caption(), $this->VISIT_ID->RequiredErrorMessage));
            }
        }
        if ($this->STATUS_PASIEN_ID->Required) {
            if (!$this->STATUS_PASIEN_ID->IsDetailKey && EmptyValue($this->STATUS_PASIEN_ID->FormValue)) {
                $this->STATUS_PASIEN_ID->addErrorMessage(str_replace("%s", $this->STATUS_PASIEN_ID->caption(), $this->STATUS_PASIEN_ID->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->STATUS_PASIEN_ID->FormValue)) {
            $this->STATUS_PASIEN_ID->addErrorMessage($this->STATUS_PASIEN_ID->getErrorMessage(false));
        }
        if ($this->RUJUKAN_ID->Required) {
            if (!$this->RUJUKAN_ID->IsDetailKey && EmptyValue($this->RUJUKAN_ID->FormValue)) {
                $this->RUJUKAN_ID->addErrorMessage(str_replace("%s", $this->RUJUKAN_ID->caption(), $this->RUJUKAN_ID->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->RUJUKAN_ID->FormValue)) {
            $this->RUJUKAN_ID->addErrorMessage($this->RUJUKAN_ID->getErrorMessage(false));
        }
        if ($this->ADDRESS_OF_RUJUKAN->Required) {
            if (!$this->ADDRESS_OF_RUJUKAN->IsDetailKey && EmptyValue($this->ADDRESS_OF_RUJUKAN->FormValue)) {
                $this->ADDRESS_OF_RUJUKAN->addErrorMessage(str_replace("%s", $this->ADDRESS_OF_RUJUKAN->caption(), $this->ADDRESS_OF_RUJUKAN->RequiredErrorMessage));
            }
        }
        if ($this->REASON_ID->Required) {
            if (!$this->REASON_ID->IsDetailKey && EmptyValue($this->REASON_ID->FormValue)) {
                $this->REASON_ID->addErrorMessage(str_replace("%s", $this->REASON_ID->caption(), $this->REASON_ID->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->REASON_ID->FormValue)) {
            $this->REASON_ID->addErrorMessage($this->REASON_ID->getErrorMessage(false));
        }
        if ($this->WAY_ID->Required) {
            if (!$this->WAY_ID->IsDetailKey && EmptyValue($this->WAY_ID->FormValue)) {
                $this->WAY_ID->addErrorMessage(str_replace("%s", $this->WAY_ID->caption(), $this->WAY_ID->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->WAY_ID->FormValue)) {
            $this->WAY_ID->addErrorMessage($this->WAY_ID->getErrorMessage(false));
        }
        if ($this->PATIENT_CATEGORY_ID->Required) {
            if (!$this->PATIENT_CATEGORY_ID->IsDetailKey && EmptyValue($this->PATIENT_CATEGORY_ID->FormValue)) {
                $this->PATIENT_CATEGORY_ID->addErrorMessage(str_replace("%s", $this->PATIENT_CATEGORY_ID->caption(), $this->PATIENT_CATEGORY_ID->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->PATIENT_CATEGORY_ID->FormValue)) {
            $this->PATIENT_CATEGORY_ID->addErrorMessage($this->PATIENT_CATEGORY_ID->getErrorMessage(false));
        }
        if ($this->BOOKED_DATE->Required) {
            if (!$this->BOOKED_DATE->IsDetailKey && EmptyValue($this->BOOKED_DATE->FormValue)) {
                $this->BOOKED_DATE->addErrorMessage(str_replace("%s", $this->BOOKED_DATE->caption(), $this->BOOKED_DATE->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->BOOKED_DATE->FormValue)) {
            $this->BOOKED_DATE->addErrorMessage($this->BOOKED_DATE->getErrorMessage(false));
        }
        if ($this->VISIT_DATE->Required) {
            if (!$this->VISIT_DATE->IsDetailKey && EmptyValue($this->VISIT_DATE->FormValue)) {
                $this->VISIT_DATE->addErrorMessage(str_replace("%s", $this->VISIT_DATE->caption(), $this->VISIT_DATE->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->VISIT_DATE->FormValue)) {
            $this->VISIT_DATE->addErrorMessage($this->VISIT_DATE->getErrorMessage(false));
        }
        if ($this->ISNEW->Required) {
            if (!$this->ISNEW->IsDetailKey && EmptyValue($this->ISNEW->FormValue)) {
                $this->ISNEW->addErrorMessage(str_replace("%s", $this->ISNEW->caption(), $this->ISNEW->RequiredErrorMessage));
            }
        }
        if ($this->FOLLOW_UP->Required) {
            if (!$this->FOLLOW_UP->IsDetailKey && EmptyValue($this->FOLLOW_UP->FormValue)) {
                $this->FOLLOW_UP->addErrorMessage(str_replace("%s", $this->FOLLOW_UP->caption(), $this->FOLLOW_UP->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->FOLLOW_UP->FormValue)) {
            $this->FOLLOW_UP->addErrorMessage($this->FOLLOW_UP->getErrorMessage(false));
        }
        if ($this->PLACE_TYPE->Required) {
            if (!$this->PLACE_TYPE->IsDetailKey && EmptyValue($this->PLACE_TYPE->FormValue)) {
                $this->PLACE_TYPE->addErrorMessage(str_replace("%s", $this->PLACE_TYPE->caption(), $this->PLACE_TYPE->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->PLACE_TYPE->FormValue)) {
            $this->PLACE_TYPE->addErrorMessage($this->PLACE_TYPE->getErrorMessage(false));
        }
        if ($this->CLINIC_ID->Required) {
            if (!$this->CLINIC_ID->IsDetailKey && EmptyValue($this->CLINIC_ID->FormValue)) {
                $this->CLINIC_ID->addErrorMessage(str_replace("%s", $this->CLINIC_ID->caption(), $this->CLINIC_ID->RequiredErrorMessage));
            }
        }
        if ($this->CLINIC_ID_FROM->Required) {
            if (!$this->CLINIC_ID_FROM->IsDetailKey && EmptyValue($this->CLINIC_ID_FROM->FormValue)) {
                $this->CLINIC_ID_FROM->addErrorMessage(str_replace("%s", $this->CLINIC_ID_FROM->caption(), $this->CLINIC_ID_FROM->RequiredErrorMessage));
            }
        }
        if ($this->CLASS_ROOM_ID->Required) {
            if (!$this->CLASS_ROOM_ID->IsDetailKey && EmptyValue($this->CLASS_ROOM_ID->FormValue)) {
                $this->CLASS_ROOM_ID->addErrorMessage(str_replace("%s", $this->CLASS_ROOM_ID->caption(), $this->CLASS_ROOM_ID->RequiredErrorMessage));
            }
        }
        if ($this->BED_ID->Required) {
            if (!$this->BED_ID->IsDetailKey && EmptyValue($this->BED_ID->FormValue)) {
                $this->BED_ID->addErrorMessage(str_replace("%s", $this->BED_ID->caption(), $this->BED_ID->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->BED_ID->FormValue)) {
            $this->BED_ID->addErrorMessage($this->BED_ID->getErrorMessage(false));
        }
        if ($this->KELUAR_ID->Required) {
            if (!$this->KELUAR_ID->IsDetailKey && EmptyValue($this->KELUAR_ID->FormValue)) {
                $this->KELUAR_ID->addErrorMessage(str_replace("%s", $this->KELUAR_ID->caption(), $this->KELUAR_ID->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->KELUAR_ID->FormValue)) {
            $this->KELUAR_ID->addErrorMessage($this->KELUAR_ID->getErrorMessage(false));
        }
        if ($this->IN_DATE->Required) {
            if (!$this->IN_DATE->IsDetailKey && EmptyValue($this->IN_DATE->FormValue)) {
                $this->IN_DATE->addErrorMessage(str_replace("%s", $this->IN_DATE->caption(), $this->IN_DATE->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->IN_DATE->FormValue)) {
            $this->IN_DATE->addErrorMessage($this->IN_DATE->getErrorMessage(false));
        }
        if ($this->EXIT_DATE->Required) {
            if (!$this->EXIT_DATE->IsDetailKey && EmptyValue($this->EXIT_DATE->FormValue)) {
                $this->EXIT_DATE->addErrorMessage(str_replace("%s", $this->EXIT_DATE->caption(), $this->EXIT_DATE->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->EXIT_DATE->FormValue)) {
            $this->EXIT_DATE->addErrorMessage($this->EXIT_DATE->getErrorMessage(false));
        }
        if ($this->DIANTAR_OLEH->Required) {
            if (!$this->DIANTAR_OLEH->IsDetailKey && EmptyValue($this->DIANTAR_OLEH->FormValue)) {
                $this->DIANTAR_OLEH->addErrorMessage(str_replace("%s", $this->DIANTAR_OLEH->caption(), $this->DIANTAR_OLEH->RequiredErrorMessage));
            }
        }
        if ($this->GENDER->Required) {
            if (!$this->GENDER->IsDetailKey && EmptyValue($this->GENDER->FormValue)) {
                $this->GENDER->addErrorMessage(str_replace("%s", $this->GENDER->caption(), $this->GENDER->RequiredErrorMessage));
            }
        }
        if ($this->DESCRIPTION->Required) {
            if (!$this->DESCRIPTION->IsDetailKey && EmptyValue($this->DESCRIPTION->FormValue)) {
                $this->DESCRIPTION->addErrorMessage(str_replace("%s", $this->DESCRIPTION->caption(), $this->DESCRIPTION->RequiredErrorMessage));
            }
        }
        if ($this->VISITOR_ADDRESS->Required) {
            if (!$this->VISITOR_ADDRESS->IsDetailKey && EmptyValue($this->VISITOR_ADDRESS->FormValue)) {
                $this->VISITOR_ADDRESS->addErrorMessage(str_replace("%s", $this->VISITOR_ADDRESS->caption(), $this->VISITOR_ADDRESS->RequiredErrorMessage));
            }
        }
        if ($this->MODIFIED_BY->Required) {
            if (!$this->MODIFIED_BY->IsDetailKey && EmptyValue($this->MODIFIED_BY->FormValue)) {
                $this->MODIFIED_BY->addErrorMessage(str_replace("%s", $this->MODIFIED_BY->caption(), $this->MODIFIED_BY->RequiredErrorMessage));
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
        if ($this->MODIFIED_FROM->Required) {
            if (!$this->MODIFIED_FROM->IsDetailKey && EmptyValue($this->MODIFIED_FROM->FormValue)) {
                $this->MODIFIED_FROM->addErrorMessage(str_replace("%s", $this->MODIFIED_FROM->caption(), $this->MODIFIED_FROM->RequiredErrorMessage));
            }
        }
        if ($this->EMPLOYEE_ID->Required) {
            if (!$this->EMPLOYEE_ID->IsDetailKey && EmptyValue($this->EMPLOYEE_ID->FormValue)) {
                $this->EMPLOYEE_ID->addErrorMessage(str_replace("%s", $this->EMPLOYEE_ID->caption(), $this->EMPLOYEE_ID->RequiredErrorMessage));
            }
        }
        if ($this->EMPLOYEE_ID_FROM->Required) {
            if (!$this->EMPLOYEE_ID_FROM->IsDetailKey && EmptyValue($this->EMPLOYEE_ID_FROM->FormValue)) {
                $this->EMPLOYEE_ID_FROM->addErrorMessage(str_replace("%s", $this->EMPLOYEE_ID_FROM->caption(), $this->EMPLOYEE_ID_FROM->RequiredErrorMessage));
            }
        }
        if ($this->RESPONSIBLE_ID->Required) {
            if (!$this->RESPONSIBLE_ID->IsDetailKey && EmptyValue($this->RESPONSIBLE_ID->FormValue)) {
                $this->RESPONSIBLE_ID->addErrorMessage(str_replace("%s", $this->RESPONSIBLE_ID->caption(), $this->RESPONSIBLE_ID->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->RESPONSIBLE_ID->FormValue)) {
            $this->RESPONSIBLE_ID->addErrorMessage($this->RESPONSIBLE_ID->getErrorMessage(false));
        }
        if ($this->RESPONSIBLE->Required) {
            if (!$this->RESPONSIBLE->IsDetailKey && EmptyValue($this->RESPONSIBLE->FormValue)) {
                $this->RESPONSIBLE->addErrorMessage(str_replace("%s", $this->RESPONSIBLE->caption(), $this->RESPONSIBLE->RequiredErrorMessage));
            }
        }
        if ($this->FAMILY_STATUS_ID->Required) {
            if (!$this->FAMILY_STATUS_ID->IsDetailKey && EmptyValue($this->FAMILY_STATUS_ID->FormValue)) {
                $this->FAMILY_STATUS_ID->addErrorMessage(str_replace("%s", $this->FAMILY_STATUS_ID->caption(), $this->FAMILY_STATUS_ID->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->FAMILY_STATUS_ID->FormValue)) {
            $this->FAMILY_STATUS_ID->addErrorMessage($this->FAMILY_STATUS_ID->getErrorMessage(false));
        }
        if ($this->TICKET_NO->Required) {
            if (!$this->TICKET_NO->IsDetailKey && EmptyValue($this->TICKET_NO->FormValue)) {
                $this->TICKET_NO->addErrorMessage(str_replace("%s", $this->TICKET_NO->caption(), $this->TICKET_NO->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->TICKET_NO->FormValue)) {
            $this->TICKET_NO->addErrorMessage($this->TICKET_NO->getErrorMessage(false));
        }
        if ($this->ISATTENDED->Required) {
            if (!$this->ISATTENDED->IsDetailKey && EmptyValue($this->ISATTENDED->FormValue)) {
                $this->ISATTENDED->addErrorMessage(str_replace("%s", $this->ISATTENDED->caption(), $this->ISATTENDED->RequiredErrorMessage));
            }
        }
        if ($this->PAYOR_ID->Required) {
            if (!$this->PAYOR_ID->IsDetailKey && EmptyValue($this->PAYOR_ID->FormValue)) {
                $this->PAYOR_ID->addErrorMessage(str_replace("%s", $this->PAYOR_ID->caption(), $this->PAYOR_ID->RequiredErrorMessage));
            }
        }
        if ($this->CLASS_ID->Required) {
            if (!$this->CLASS_ID->IsDetailKey && EmptyValue($this->CLASS_ID->FormValue)) {
                $this->CLASS_ID->addErrorMessage(str_replace("%s", $this->CLASS_ID->caption(), $this->CLASS_ID->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->CLASS_ID->FormValue)) {
            $this->CLASS_ID->addErrorMessage($this->CLASS_ID->getErrorMessage(false));
        }
        if ($this->ISPERTARIF->Required) {
            if (!$this->ISPERTARIF->IsDetailKey && EmptyValue($this->ISPERTARIF->FormValue)) {
                $this->ISPERTARIF->addErrorMessage(str_replace("%s", $this->ISPERTARIF->caption(), $this->ISPERTARIF->RequiredErrorMessage));
            }
        }
        if ($this->KAL_ID->Required) {
            if (!$this->KAL_ID->IsDetailKey && EmptyValue($this->KAL_ID->FormValue)) {
                $this->KAL_ID->addErrorMessage(str_replace("%s", $this->KAL_ID->caption(), $this->KAL_ID->RequiredErrorMessage));
            }
        }
        if ($this->EMPLOYEE_INAP->Required) {
            if (!$this->EMPLOYEE_INAP->IsDetailKey && EmptyValue($this->EMPLOYEE_INAP->FormValue)) {
                $this->EMPLOYEE_INAP->addErrorMessage(str_replace("%s", $this->EMPLOYEE_INAP->caption(), $this->EMPLOYEE_INAP->RequiredErrorMessage));
            }
        }
        if ($this->PASIEN_ID->Required) {
            if (!$this->PASIEN_ID->IsDetailKey && EmptyValue($this->PASIEN_ID->FormValue)) {
                $this->PASIEN_ID->addErrorMessage(str_replace("%s", $this->PASIEN_ID->caption(), $this->PASIEN_ID->RequiredErrorMessage));
            }
        }
        if ($this->KARYAWAN->Required) {
            if (!$this->KARYAWAN->IsDetailKey && EmptyValue($this->KARYAWAN->FormValue)) {
                $this->KARYAWAN->addErrorMessage(str_replace("%s", $this->KARYAWAN->caption(), $this->KARYAWAN->RequiredErrorMessage));
            }
        }
        if ($this->ACCOUNT_ID->Required) {
            if (!$this->ACCOUNT_ID->IsDetailKey && EmptyValue($this->ACCOUNT_ID->FormValue)) {
                $this->ACCOUNT_ID->addErrorMessage(str_replace("%s", $this->ACCOUNT_ID->caption(), $this->ACCOUNT_ID->RequiredErrorMessage));
            }
        }
        if ($this->CLASS_ID_PLAFOND->Required) {
            if (!$this->CLASS_ID_PLAFOND->IsDetailKey && EmptyValue($this->CLASS_ID_PLAFOND->FormValue)) {
                $this->CLASS_ID_PLAFOND->addErrorMessage(str_replace("%s", $this->CLASS_ID_PLAFOND->caption(), $this->CLASS_ID_PLAFOND->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->CLASS_ID_PLAFOND->FormValue)) {
            $this->CLASS_ID_PLAFOND->addErrorMessage($this->CLASS_ID_PLAFOND->getErrorMessage(false));
        }
        if ($this->BACKCHARGE->Required) {
            if (!$this->BACKCHARGE->IsDetailKey && EmptyValue($this->BACKCHARGE->FormValue)) {
                $this->BACKCHARGE->addErrorMessage(str_replace("%s", $this->BACKCHARGE->caption(), $this->BACKCHARGE->RequiredErrorMessage));
            }
        }
        if ($this->COVERAGE_ID->Required) {
            if (!$this->COVERAGE_ID->IsDetailKey && EmptyValue($this->COVERAGE_ID->FormValue)) {
                $this->COVERAGE_ID->addErrorMessage(str_replace("%s", $this->COVERAGE_ID->caption(), $this->COVERAGE_ID->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->COVERAGE_ID->FormValue)) {
            $this->COVERAGE_ID->addErrorMessage($this->COVERAGE_ID->getErrorMessage(false));
        }
        if ($this->AGEYEAR->Required) {
            if (!$this->AGEYEAR->IsDetailKey && EmptyValue($this->AGEYEAR->FormValue)) {
                $this->AGEYEAR->addErrorMessage(str_replace("%s", $this->AGEYEAR->caption(), $this->AGEYEAR->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->AGEYEAR->FormValue)) {
            $this->AGEYEAR->addErrorMessage($this->AGEYEAR->getErrorMessage(false));
        }
        if ($this->AGEMONTH->Required) {
            if (!$this->AGEMONTH->IsDetailKey && EmptyValue($this->AGEMONTH->FormValue)) {
                $this->AGEMONTH->addErrorMessage(str_replace("%s", $this->AGEMONTH->caption(), $this->AGEMONTH->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->AGEMONTH->FormValue)) {
            $this->AGEMONTH->addErrorMessage($this->AGEMONTH->getErrorMessage(false));
        }
        if ($this->AGEDAY->Required) {
            if (!$this->AGEDAY->IsDetailKey && EmptyValue($this->AGEDAY->FormValue)) {
                $this->AGEDAY->addErrorMessage(str_replace("%s", $this->AGEDAY->caption(), $this->AGEDAY->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->AGEDAY->FormValue)) {
            $this->AGEDAY->addErrorMessage($this->AGEDAY->getErrorMessage(false));
        }
        if ($this->RECOMENDATION->Required) {
            if (!$this->RECOMENDATION->IsDetailKey && EmptyValue($this->RECOMENDATION->FormValue)) {
                $this->RECOMENDATION->addErrorMessage(str_replace("%s", $this->RECOMENDATION->caption(), $this->RECOMENDATION->RequiredErrorMessage));
            }
        }
        if ($this->CONCLUSION->Required) {
            if (!$this->CONCLUSION->IsDetailKey && EmptyValue($this->CONCLUSION->FormValue)) {
                $this->CONCLUSION->addErrorMessage(str_replace("%s", $this->CONCLUSION->caption(), $this->CONCLUSION->RequiredErrorMessage));
            }
        }
        if ($this->SPECIMENNO->Required) {
            if (!$this->SPECIMENNO->IsDetailKey && EmptyValue($this->SPECIMENNO->FormValue)) {
                $this->SPECIMENNO->addErrorMessage(str_replace("%s", $this->SPECIMENNO->caption(), $this->SPECIMENNO->RequiredErrorMessage));
            }
        }
        if ($this->LOCKED->Required) {
            if (!$this->LOCKED->IsDetailKey && EmptyValue($this->LOCKED->FormValue)) {
                $this->LOCKED->addErrorMessage(str_replace("%s", $this->LOCKED->caption(), $this->LOCKED->RequiredErrorMessage));
            }
        }
        if ($this->RM_OUT_DATE->Required) {
            if (!$this->RM_OUT_DATE->IsDetailKey && EmptyValue($this->RM_OUT_DATE->FormValue)) {
                $this->RM_OUT_DATE->addErrorMessage(str_replace("%s", $this->RM_OUT_DATE->caption(), $this->RM_OUT_DATE->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->RM_OUT_DATE->FormValue)) {
            $this->RM_OUT_DATE->addErrorMessage($this->RM_OUT_DATE->getErrorMessage(false));
        }
        if ($this->RM_IN_DATE->Required) {
            if (!$this->RM_IN_DATE->IsDetailKey && EmptyValue($this->RM_IN_DATE->FormValue)) {
                $this->RM_IN_DATE->addErrorMessage(str_replace("%s", $this->RM_IN_DATE->caption(), $this->RM_IN_DATE->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->RM_IN_DATE->FormValue)) {
            $this->RM_IN_DATE->addErrorMessage($this->RM_IN_DATE->getErrorMessage(false));
        }
        if ($this->LAMA_PINJAM->Required) {
            if (!$this->LAMA_PINJAM->IsDetailKey && EmptyValue($this->LAMA_PINJAM->FormValue)) {
                $this->LAMA_PINJAM->addErrorMessage(str_replace("%s", $this->LAMA_PINJAM->caption(), $this->LAMA_PINJAM->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->LAMA_PINJAM->FormValue)) {
            $this->LAMA_PINJAM->addErrorMessage($this->LAMA_PINJAM->getErrorMessage(false));
        }
        if ($this->STANDAR_RJ->Required) {
            if (!$this->STANDAR_RJ->IsDetailKey && EmptyValue($this->STANDAR_RJ->FormValue)) {
                $this->STANDAR_RJ->addErrorMessage(str_replace("%s", $this->STANDAR_RJ->caption(), $this->STANDAR_RJ->RequiredErrorMessage));
            }
        }
        if ($this->LENGKAP_RJ->Required) {
            if (!$this->LENGKAP_RJ->IsDetailKey && EmptyValue($this->LENGKAP_RJ->FormValue)) {
                $this->LENGKAP_RJ->addErrorMessage(str_replace("%s", $this->LENGKAP_RJ->caption(), $this->LENGKAP_RJ->RequiredErrorMessage));
            }
        }
        if ($this->LENGKAP_RI->Required) {
            if (!$this->LENGKAP_RI->IsDetailKey && EmptyValue($this->LENGKAP_RI->FormValue)) {
                $this->LENGKAP_RI->addErrorMessage(str_replace("%s", $this->LENGKAP_RI->caption(), $this->LENGKAP_RI->RequiredErrorMessage));
            }
        }
        if ($this->RESEND_RM_DATE->Required) {
            if (!$this->RESEND_RM_DATE->IsDetailKey && EmptyValue($this->RESEND_RM_DATE->FormValue)) {
                $this->RESEND_RM_DATE->addErrorMessage(str_replace("%s", $this->RESEND_RM_DATE->caption(), $this->RESEND_RM_DATE->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->RESEND_RM_DATE->FormValue)) {
            $this->RESEND_RM_DATE->addErrorMessage($this->RESEND_RM_DATE->getErrorMessage(false));
        }
        if ($this->LENGKAP_RM1->Required) {
            if (!$this->LENGKAP_RM1->IsDetailKey && EmptyValue($this->LENGKAP_RM1->FormValue)) {
                $this->LENGKAP_RM1->addErrorMessage(str_replace("%s", $this->LENGKAP_RM1->caption(), $this->LENGKAP_RM1->RequiredErrorMessage));
            }
        }
        if ($this->LENGKAP_RESUME->Required) {
            if (!$this->LENGKAP_RESUME->IsDetailKey && EmptyValue($this->LENGKAP_RESUME->FormValue)) {
                $this->LENGKAP_RESUME->addErrorMessage(str_replace("%s", $this->LENGKAP_RESUME->caption(), $this->LENGKAP_RESUME->RequiredErrorMessage));
            }
        }
        if ($this->LENGKAP_ANAMNESIS->Required) {
            if (!$this->LENGKAP_ANAMNESIS->IsDetailKey && EmptyValue($this->LENGKAP_ANAMNESIS->FormValue)) {
                $this->LENGKAP_ANAMNESIS->addErrorMessage(str_replace("%s", $this->LENGKAP_ANAMNESIS->caption(), $this->LENGKAP_ANAMNESIS->RequiredErrorMessage));
            }
        }
        if ($this->LENGKAP_CONSENT->Required) {
            if (!$this->LENGKAP_CONSENT->IsDetailKey && EmptyValue($this->LENGKAP_CONSENT->FormValue)) {
                $this->LENGKAP_CONSENT->addErrorMessage(str_replace("%s", $this->LENGKAP_CONSENT->caption(), $this->LENGKAP_CONSENT->RequiredErrorMessage));
            }
        }
        if ($this->LENGKAP_ANESTESI->Required) {
            if (!$this->LENGKAP_ANESTESI->IsDetailKey && EmptyValue($this->LENGKAP_ANESTESI->FormValue)) {
                $this->LENGKAP_ANESTESI->addErrorMessage(str_replace("%s", $this->LENGKAP_ANESTESI->caption(), $this->LENGKAP_ANESTESI->RequiredErrorMessage));
            }
        }
        if ($this->LENGKAP_OP->Required) {
            if (!$this->LENGKAP_OP->IsDetailKey && EmptyValue($this->LENGKAP_OP->FormValue)) {
                $this->LENGKAP_OP->addErrorMessage(str_replace("%s", $this->LENGKAP_OP->caption(), $this->LENGKAP_OP->RequiredErrorMessage));
            }
        }
        if ($this->BACK_RM_DATE->Required) {
            if (!$this->BACK_RM_DATE->IsDetailKey && EmptyValue($this->BACK_RM_DATE->FormValue)) {
                $this->BACK_RM_DATE->addErrorMessage(str_replace("%s", $this->BACK_RM_DATE->caption(), $this->BACK_RM_DATE->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->BACK_RM_DATE->FormValue)) {
            $this->BACK_RM_DATE->addErrorMessage($this->BACK_RM_DATE->getErrorMessage(false));
        }
        if ($this->VALID_RM_DATE->Required) {
            if (!$this->VALID_RM_DATE->IsDetailKey && EmptyValue($this->VALID_RM_DATE->FormValue)) {
                $this->VALID_RM_DATE->addErrorMessage(str_replace("%s", $this->VALID_RM_DATE->caption(), $this->VALID_RM_DATE->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->VALID_RM_DATE->FormValue)) {
            $this->VALID_RM_DATE->addErrorMessage($this->VALID_RM_DATE->getErrorMessage(false));
        }
        if ($this->NO_SKP->Required) {
            if (!$this->NO_SKP->IsDetailKey && EmptyValue($this->NO_SKP->FormValue)) {
                $this->NO_SKP->addErrorMessage(str_replace("%s", $this->NO_SKP->caption(), $this->NO_SKP->RequiredErrorMessage));
            }
        }
        if ($this->NO_SKPINAP->Required) {
            if (!$this->NO_SKPINAP->IsDetailKey && EmptyValue($this->NO_SKPINAP->FormValue)) {
                $this->NO_SKPINAP->addErrorMessage(str_replace("%s", $this->NO_SKPINAP->caption(), $this->NO_SKPINAP->RequiredErrorMessage));
            }
        }
        if ($this->DIAGNOSA_ID->Required) {
            if (!$this->DIAGNOSA_ID->IsDetailKey && EmptyValue($this->DIAGNOSA_ID->FormValue)) {
                $this->DIAGNOSA_ID->addErrorMessage(str_replace("%s", $this->DIAGNOSA_ID->caption(), $this->DIAGNOSA_ID->RequiredErrorMessage));
            }
        }
        if ($this->ticket_all->Required) {
            if (!$this->ticket_all->IsDetailKey && EmptyValue($this->ticket_all->FormValue)) {
                $this->ticket_all->addErrorMessage(str_replace("%s", $this->ticket_all->caption(), $this->ticket_all->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->ticket_all->FormValue)) {
            $this->ticket_all->addErrorMessage($this->ticket_all->getErrorMessage(false));
        }
        if ($this->tanggal_rujukan->Required) {
            if (!$this->tanggal_rujukan->IsDetailKey && EmptyValue($this->tanggal_rujukan->FormValue)) {
                $this->tanggal_rujukan->addErrorMessage(str_replace("%s", $this->tanggal_rujukan->caption(), $this->tanggal_rujukan->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->tanggal_rujukan->FormValue)) {
            $this->tanggal_rujukan->addErrorMessage($this->tanggal_rujukan->getErrorMessage(false));
        }
        if ($this->ISRJ->Required) {
            if (!$this->ISRJ->IsDetailKey && EmptyValue($this->ISRJ->FormValue)) {
                $this->ISRJ->addErrorMessage(str_replace("%s", $this->ISRJ->caption(), $this->ISRJ->RequiredErrorMessage));
            }
        }
        if ($this->NORUJUKAN->Required) {
            if (!$this->NORUJUKAN->IsDetailKey && EmptyValue($this->NORUJUKAN->FormValue)) {
                $this->NORUJUKAN->addErrorMessage(str_replace("%s", $this->NORUJUKAN->caption(), $this->NORUJUKAN->RequiredErrorMessage));
            }
        }
        if ($this->PPKRUJUKAN->Required) {
            if (!$this->PPKRUJUKAN->IsDetailKey && EmptyValue($this->PPKRUJUKAN->FormValue)) {
                $this->PPKRUJUKAN->addErrorMessage(str_replace("%s", $this->PPKRUJUKAN->caption(), $this->PPKRUJUKAN->RequiredErrorMessage));
            }
        }
        if ($this->LOKASILAKA->Required) {
            if (!$this->LOKASILAKA->IsDetailKey && EmptyValue($this->LOKASILAKA->FormValue)) {
                $this->LOKASILAKA->addErrorMessage(str_replace("%s", $this->LOKASILAKA->caption(), $this->LOKASILAKA->RequiredErrorMessage));
            }
        }
        if ($this->KDPOLI->Required) {
            if (!$this->KDPOLI->IsDetailKey && EmptyValue($this->KDPOLI->FormValue)) {
                $this->KDPOLI->addErrorMessage(str_replace("%s", $this->KDPOLI->caption(), $this->KDPOLI->RequiredErrorMessage));
            }
        }
        if ($this->EDIT_SEP->Required) {
            if (!$this->EDIT_SEP->IsDetailKey && EmptyValue($this->EDIT_SEP->FormValue)) {
                $this->EDIT_SEP->addErrorMessage(str_replace("%s", $this->EDIT_SEP->caption(), $this->EDIT_SEP->RequiredErrorMessage));
            }
        }
        if ($this->DELETE_SEP->Required) {
            if (!$this->DELETE_SEP->IsDetailKey && EmptyValue($this->DELETE_SEP->FormValue)) {
                $this->DELETE_SEP->addErrorMessage(str_replace("%s", $this->DELETE_SEP->caption(), $this->DELETE_SEP->RequiredErrorMessage));
            }
        }
        if ($this->KODE_AGAMA->Required) {
            if (!$this->KODE_AGAMA->IsDetailKey && EmptyValue($this->KODE_AGAMA->FormValue)) {
                $this->KODE_AGAMA->addErrorMessage(str_replace("%s", $this->KODE_AGAMA->caption(), $this->KODE_AGAMA->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->KODE_AGAMA->FormValue)) {
            $this->KODE_AGAMA->addErrorMessage($this->KODE_AGAMA->getErrorMessage(false));
        }
        if ($this->DIAG_AWAL->Required) {
            if (!$this->DIAG_AWAL->IsDetailKey && EmptyValue($this->DIAG_AWAL->FormValue)) {
                $this->DIAG_AWAL->addErrorMessage(str_replace("%s", $this->DIAG_AWAL->caption(), $this->DIAG_AWAL->RequiredErrorMessage));
            }
        }
        if ($this->AKTIF->Required) {
            if (!$this->AKTIF->IsDetailKey && EmptyValue($this->AKTIF->FormValue)) {
                $this->AKTIF->addErrorMessage(str_replace("%s", $this->AKTIF->caption(), $this->AKTIF->RequiredErrorMessage));
            }
        }
        if ($this->BILL_INAP->Required) {
            if (!$this->BILL_INAP->IsDetailKey && EmptyValue($this->BILL_INAP->FormValue)) {
                $this->BILL_INAP->addErrorMessage(str_replace("%s", $this->BILL_INAP->caption(), $this->BILL_INAP->RequiredErrorMessage));
            }
        }
        if ($this->SEP_PRINTDATE->Required) {
            if (!$this->SEP_PRINTDATE->IsDetailKey && EmptyValue($this->SEP_PRINTDATE->FormValue)) {
                $this->SEP_PRINTDATE->addErrorMessage(str_replace("%s", $this->SEP_PRINTDATE->caption(), $this->SEP_PRINTDATE->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->SEP_PRINTDATE->FormValue)) {
            $this->SEP_PRINTDATE->addErrorMessage($this->SEP_PRINTDATE->getErrorMessage(false));
        }
        if ($this->MAPPING_SEP->Required) {
            if (!$this->MAPPING_SEP->IsDetailKey && EmptyValue($this->MAPPING_SEP->FormValue)) {
                $this->MAPPING_SEP->addErrorMessage(str_replace("%s", $this->MAPPING_SEP->caption(), $this->MAPPING_SEP->RequiredErrorMessage));
            }
        }
        if ($this->TRANS_ID->Required) {
            if (!$this->TRANS_ID->IsDetailKey && EmptyValue($this->TRANS_ID->FormValue)) {
                $this->TRANS_ID->addErrorMessage(str_replace("%s", $this->TRANS_ID->caption(), $this->TRANS_ID->RequiredErrorMessage));
            }
        }
        if ($this->KDPOLI_EKS->Required) {
            if (!$this->KDPOLI_EKS->IsDetailKey && EmptyValue($this->KDPOLI_EKS->FormValue)) {
                $this->KDPOLI_EKS->addErrorMessage(str_replace("%s", $this->KDPOLI_EKS->caption(), $this->KDPOLI_EKS->RequiredErrorMessage));
            }
        }
        if ($this->COB->Required) {
            if (!$this->COB->IsDetailKey && EmptyValue($this->COB->FormValue)) {
                $this->COB->addErrorMessage(str_replace("%s", $this->COB->caption(), $this->COB->RequiredErrorMessage));
            }
        }
        if ($this->PENJAMIN->Required) {
            if (!$this->PENJAMIN->IsDetailKey && EmptyValue($this->PENJAMIN->FormValue)) {
                $this->PENJAMIN->addErrorMessage(str_replace("%s", $this->PENJAMIN->caption(), $this->PENJAMIN->RequiredErrorMessage));
            }
        }
        if ($this->ASALRUJUKAN->Required) {
            if (!$this->ASALRUJUKAN->IsDetailKey && EmptyValue($this->ASALRUJUKAN->FormValue)) {
                $this->ASALRUJUKAN->addErrorMessage(str_replace("%s", $this->ASALRUJUKAN->caption(), $this->ASALRUJUKAN->RequiredErrorMessage));
            }
        }
        if ($this->RESPONSEP->Required) {
            if (!$this->RESPONSEP->IsDetailKey && EmptyValue($this->RESPONSEP->FormValue)) {
                $this->RESPONSEP->addErrorMessage(str_replace("%s", $this->RESPONSEP->caption(), $this->RESPONSEP->RequiredErrorMessage));
            }
        }
        if ($this->APPROVAL_DESC->Required) {
            if (!$this->APPROVAL_DESC->IsDetailKey && EmptyValue($this->APPROVAL_DESC->FormValue)) {
                $this->APPROVAL_DESC->addErrorMessage(str_replace("%s", $this->APPROVAL_DESC->caption(), $this->APPROVAL_DESC->RequiredErrorMessage));
            }
        }
        if ($this->APPROVAL_RESPONAJUKAN->Required) {
            if (!$this->APPROVAL_RESPONAJUKAN->IsDetailKey && EmptyValue($this->APPROVAL_RESPONAJUKAN->FormValue)) {
                $this->APPROVAL_RESPONAJUKAN->addErrorMessage(str_replace("%s", $this->APPROVAL_RESPONAJUKAN->caption(), $this->APPROVAL_RESPONAJUKAN->RequiredErrorMessage));
            }
        }
        if ($this->APPROVAL_RESPONAPPROV->Required) {
            if (!$this->APPROVAL_RESPONAPPROV->IsDetailKey && EmptyValue($this->APPROVAL_RESPONAPPROV->FormValue)) {
                $this->APPROVAL_RESPONAPPROV->addErrorMessage(str_replace("%s", $this->APPROVAL_RESPONAPPROV->caption(), $this->APPROVAL_RESPONAPPROV->RequiredErrorMessage));
            }
        }
        if ($this->RESPONTGLPLG_DESC->Required) {
            if (!$this->RESPONTGLPLG_DESC->IsDetailKey && EmptyValue($this->RESPONTGLPLG_DESC->FormValue)) {
                $this->RESPONTGLPLG_DESC->addErrorMessage(str_replace("%s", $this->RESPONTGLPLG_DESC->caption(), $this->RESPONTGLPLG_DESC->RequiredErrorMessage));
            }
        }
        if ($this->RESPONPOST_VKLAIM->Required) {
            if (!$this->RESPONPOST_VKLAIM->IsDetailKey && EmptyValue($this->RESPONPOST_VKLAIM->FormValue)) {
                $this->RESPONPOST_VKLAIM->addErrorMessage(str_replace("%s", $this->RESPONPOST_VKLAIM->caption(), $this->RESPONPOST_VKLAIM->RequiredErrorMessage));
            }
        }
        if ($this->RESPONPUT_VKLAIM->Required) {
            if (!$this->RESPONPUT_VKLAIM->IsDetailKey && EmptyValue($this->RESPONPUT_VKLAIM->FormValue)) {
                $this->RESPONPUT_VKLAIM->addErrorMessage(str_replace("%s", $this->RESPONPUT_VKLAIM->caption(), $this->RESPONPUT_VKLAIM->RequiredErrorMessage));
            }
        }
        if ($this->RESPONDEL_VKLAIM->Required) {
            if (!$this->RESPONDEL_VKLAIM->IsDetailKey && EmptyValue($this->RESPONDEL_VKLAIM->FormValue)) {
                $this->RESPONDEL_VKLAIM->addErrorMessage(str_replace("%s", $this->RESPONDEL_VKLAIM->caption(), $this->RESPONDEL_VKLAIM->RequiredErrorMessage));
            }
        }
        if ($this->CALL_TIMES->Required) {
            if (!$this->CALL_TIMES->IsDetailKey && EmptyValue($this->CALL_TIMES->FormValue)) {
                $this->CALL_TIMES->addErrorMessage(str_replace("%s", $this->CALL_TIMES->caption(), $this->CALL_TIMES->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->CALL_TIMES->FormValue)) {
            $this->CALL_TIMES->addErrorMessage($this->CALL_TIMES->getErrorMessage(false));
        }
        if ($this->CALL_DATE->Required) {
            if (!$this->CALL_DATE->IsDetailKey && EmptyValue($this->CALL_DATE->FormValue)) {
                $this->CALL_DATE->addErrorMessage(str_replace("%s", $this->CALL_DATE->caption(), $this->CALL_DATE->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->CALL_DATE->FormValue)) {
            $this->CALL_DATE->addErrorMessage($this->CALL_DATE->getErrorMessage(false));
        }
        if ($this->CALL_DATES->Required) {
            if (!$this->CALL_DATES->IsDetailKey && EmptyValue($this->CALL_DATES->FormValue)) {
                $this->CALL_DATES->addErrorMessage(str_replace("%s", $this->CALL_DATES->caption(), $this->CALL_DATES->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->CALL_DATES->FormValue)) {
            $this->CALL_DATES->addErrorMessage($this->CALL_DATES->getErrorMessage(false));
        }
        if ($this->SERVED_DATE->Required) {
            if (!$this->SERVED_DATE->IsDetailKey && EmptyValue($this->SERVED_DATE->FormValue)) {
                $this->SERVED_DATE->addErrorMessage(str_replace("%s", $this->SERVED_DATE->caption(), $this->SERVED_DATE->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->SERVED_DATE->FormValue)) {
            $this->SERVED_DATE->addErrorMessage($this->SERVED_DATE->getErrorMessage(false));
        }
        if ($this->SERVED_INAP->Required) {
            if (!$this->SERVED_INAP->IsDetailKey && EmptyValue($this->SERVED_INAP->FormValue)) {
                $this->SERVED_INAP->addErrorMessage(str_replace("%s", $this->SERVED_INAP->caption(), $this->SERVED_INAP->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->SERVED_INAP->FormValue)) {
            $this->SERVED_INAP->addErrorMessage($this->SERVED_INAP->getErrorMessage(false));
        }
        if ($this->KDDPJP1->Required) {
            if (!$this->KDDPJP1->IsDetailKey && EmptyValue($this->KDDPJP1->FormValue)) {
                $this->KDDPJP1->addErrorMessage(str_replace("%s", $this->KDDPJP1->caption(), $this->KDDPJP1->RequiredErrorMessage));
            }
        }
        if ($this->KDDPJP->Required) {
            if (!$this->KDDPJP->IsDetailKey && EmptyValue($this->KDDPJP->FormValue)) {
                $this->KDDPJP->addErrorMessage(str_replace("%s", $this->KDDPJP->caption(), $this->KDDPJP->RequiredErrorMessage));
            }
        }
        if ($this->tgl_kontrol->Required) {
            if (!$this->tgl_kontrol->IsDetailKey && EmptyValue($this->tgl_kontrol->FormValue)) {
                $this->tgl_kontrol->addErrorMessage(str_replace("%s", $this->tgl_kontrol->caption(), $this->tgl_kontrol->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->tgl_kontrol->FormValue)) {
            $this->tgl_kontrol->addErrorMessage($this->tgl_kontrol->getErrorMessage(false));
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
        $this->ORG_UNIT_CODE->setDbValueDef($rsnew, $this->ORG_UNIT_CODE->CurrentValue, null, false);

        // NO_REGISTRATION
        $this->NO_REGISTRATION->setDbValueDef($rsnew, $this->NO_REGISTRATION->CurrentValue, "", false);

        // VISIT_ID
        $this->VISIT_ID->setDbValueDef($rsnew, $this->VISIT_ID->CurrentValue, null, false);

        // STATUS_PASIEN_ID
        $this->STATUS_PASIEN_ID->setDbValueDef($rsnew, $this->STATUS_PASIEN_ID->CurrentValue, null, false);

        // RUJUKAN_ID
        $this->RUJUKAN_ID->setDbValueDef($rsnew, $this->RUJUKAN_ID->CurrentValue, null, false);

        // ADDRESS_OF_RUJUKAN
        $this->ADDRESS_OF_RUJUKAN->setDbValueDef($rsnew, $this->ADDRESS_OF_RUJUKAN->CurrentValue, null, false);

        // REASON_ID
        $this->REASON_ID->setDbValueDef($rsnew, $this->REASON_ID->CurrentValue, null, false);

        // WAY_ID
        $this->WAY_ID->setDbValueDef($rsnew, $this->WAY_ID->CurrentValue, null, false);

        // PATIENT_CATEGORY_ID
        $this->PATIENT_CATEGORY_ID->setDbValueDef($rsnew, $this->PATIENT_CATEGORY_ID->CurrentValue, null, false);

        // BOOKED_DATE
        $this->BOOKED_DATE->setDbValueDef($rsnew, UnFormatDateTime($this->BOOKED_DATE->CurrentValue, 0), null, false);

        // VISIT_DATE
        $this->VISIT_DATE->setDbValueDef($rsnew, UnFormatDateTime($this->VISIT_DATE->CurrentValue, 0), null, false);

        // ISNEW
        $this->ISNEW->setDbValueDef($rsnew, $this->ISNEW->CurrentValue, null, false);

        // FOLLOW_UP
        $this->FOLLOW_UP->setDbValueDef($rsnew, $this->FOLLOW_UP->CurrentValue, null, false);

        // PLACE_TYPE
        $this->PLACE_TYPE->setDbValueDef($rsnew, $this->PLACE_TYPE->CurrentValue, null, false);

        // CLINIC_ID
        $this->CLINIC_ID->setDbValueDef($rsnew, $this->CLINIC_ID->CurrentValue, null, false);

        // CLINIC_ID_FROM
        $this->CLINIC_ID_FROM->setDbValueDef($rsnew, $this->CLINIC_ID_FROM->CurrentValue, null, false);

        // CLASS_ROOM_ID
        $this->CLASS_ROOM_ID->setDbValueDef($rsnew, $this->CLASS_ROOM_ID->CurrentValue, null, false);

        // BED_ID
        $this->BED_ID->setDbValueDef($rsnew, $this->BED_ID->CurrentValue, null, false);

        // KELUAR_ID
        $this->KELUAR_ID->setDbValueDef($rsnew, $this->KELUAR_ID->CurrentValue, null, false);

        // IN_DATE
        $this->IN_DATE->setDbValueDef($rsnew, UnFormatDateTime($this->IN_DATE->CurrentValue, 0), null, false);

        // EXIT_DATE
        $this->EXIT_DATE->setDbValueDef($rsnew, UnFormatDateTime($this->EXIT_DATE->CurrentValue, 0), null, false);

        // DIANTAR_OLEH
        $this->DIANTAR_OLEH->setDbValueDef($rsnew, $this->DIANTAR_OLEH->CurrentValue, null, false);

        // GENDER
        $this->GENDER->setDbValueDef($rsnew, $this->GENDER->CurrentValue, null, false);

        // DESCRIPTION
        $this->DESCRIPTION->setDbValueDef($rsnew, $this->DESCRIPTION->CurrentValue, null, false);

        // VISITOR_ADDRESS
        $this->VISITOR_ADDRESS->setDbValueDef($rsnew, $this->VISITOR_ADDRESS->CurrentValue, null, false);

        // MODIFIED_BY
        $this->MODIFIED_BY->setDbValueDef($rsnew, $this->MODIFIED_BY->CurrentValue, null, false);

        // MODIFIED_DATE
        $this->MODIFIED_DATE->setDbValueDef($rsnew, UnFormatDateTime($this->MODIFIED_DATE->CurrentValue, 0), null, false);

        // MODIFIED_FROM
        $this->MODIFIED_FROM->setDbValueDef($rsnew, $this->MODIFIED_FROM->CurrentValue, null, false);

        // EMPLOYEE_ID
        $this->EMPLOYEE_ID->setDbValueDef($rsnew, $this->EMPLOYEE_ID->CurrentValue, null, false);

        // EMPLOYEE_ID_FROM
        $this->EMPLOYEE_ID_FROM->setDbValueDef($rsnew, $this->EMPLOYEE_ID_FROM->CurrentValue, null, false);

        // RESPONSIBLE_ID
        $this->RESPONSIBLE_ID->setDbValueDef($rsnew, $this->RESPONSIBLE_ID->CurrentValue, null, false);

        // RESPONSIBLE
        $this->RESPONSIBLE->setDbValueDef($rsnew, $this->RESPONSIBLE->CurrentValue, null, false);

        // FAMILY_STATUS_ID
        $this->FAMILY_STATUS_ID->setDbValueDef($rsnew, $this->FAMILY_STATUS_ID->CurrentValue, null, false);

        // TICKET_NO
        $this->TICKET_NO->setDbValueDef($rsnew, $this->TICKET_NO->CurrentValue, null, false);

        // ISATTENDED
        $this->ISATTENDED->setDbValueDef($rsnew, $this->ISATTENDED->CurrentValue, null, false);

        // PAYOR_ID
        $this->PAYOR_ID->setDbValueDef($rsnew, $this->PAYOR_ID->CurrentValue, null, false);

        // CLASS_ID
        $this->CLASS_ID->setDbValueDef($rsnew, $this->CLASS_ID->CurrentValue, null, false);

        // ISPERTARIF
        $this->ISPERTARIF->setDbValueDef($rsnew, $this->ISPERTARIF->CurrentValue, null, false);

        // KAL_ID
        $this->KAL_ID->setDbValueDef($rsnew, $this->KAL_ID->CurrentValue, null, false);

        // EMPLOYEE_INAP
        $this->EMPLOYEE_INAP->setDbValueDef($rsnew, $this->EMPLOYEE_INAP->CurrentValue, null, false);

        // PASIEN_ID
        $this->PASIEN_ID->setDbValueDef($rsnew, $this->PASIEN_ID->CurrentValue, null, false);

        // KARYAWAN
        $this->KARYAWAN->setDbValueDef($rsnew, $this->KARYAWAN->CurrentValue, null, false);

        // ACCOUNT_ID
        $this->ACCOUNT_ID->setDbValueDef($rsnew, $this->ACCOUNT_ID->CurrentValue, null, false);

        // CLASS_ID_PLAFOND
        $this->CLASS_ID_PLAFOND->setDbValueDef($rsnew, $this->CLASS_ID_PLAFOND->CurrentValue, null, false);

        // BACKCHARGE
        $this->BACKCHARGE->setDbValueDef($rsnew, $this->BACKCHARGE->CurrentValue, null, false);

        // COVERAGE_ID
        $this->COVERAGE_ID->setDbValueDef($rsnew, $this->COVERAGE_ID->CurrentValue, null, false);

        // AGEYEAR
        $this->AGEYEAR->setDbValueDef($rsnew, $this->AGEYEAR->CurrentValue, null, false);

        // AGEMONTH
        $this->AGEMONTH->setDbValueDef($rsnew, $this->AGEMONTH->CurrentValue, null, false);

        // AGEDAY
        $this->AGEDAY->setDbValueDef($rsnew, $this->AGEDAY->CurrentValue, null, false);

        // RECOMENDATION
        $this->RECOMENDATION->setDbValueDef($rsnew, $this->RECOMENDATION->CurrentValue, null, false);

        // CONCLUSION
        $this->CONCLUSION->setDbValueDef($rsnew, $this->CONCLUSION->CurrentValue, null, false);

        // SPECIMENNO
        $this->SPECIMENNO->setDbValueDef($rsnew, $this->SPECIMENNO->CurrentValue, null, false);

        // LOCKED
        $this->LOCKED->setDbValueDef($rsnew, $this->LOCKED->CurrentValue, null, false);

        // RM_OUT_DATE
        $this->RM_OUT_DATE->setDbValueDef($rsnew, UnFormatDateTime($this->RM_OUT_DATE->CurrentValue, 0), null, false);

        // RM_IN_DATE
        $this->RM_IN_DATE->setDbValueDef($rsnew, UnFormatDateTime($this->RM_IN_DATE->CurrentValue, 0), null, false);

        // LAMA_PINJAM
        $this->LAMA_PINJAM->setDbValueDef($rsnew, UnFormatDateTime($this->LAMA_PINJAM->CurrentValue, 0), null, false);

        // STANDAR_RJ
        $this->STANDAR_RJ->setDbValueDef($rsnew, $this->STANDAR_RJ->CurrentValue, null, false);

        // LENGKAP_RJ
        $this->LENGKAP_RJ->setDbValueDef($rsnew, $this->LENGKAP_RJ->CurrentValue, null, false);

        // LENGKAP_RI
        $this->LENGKAP_RI->setDbValueDef($rsnew, $this->LENGKAP_RI->CurrentValue, null, false);

        // RESEND_RM_DATE
        $this->RESEND_RM_DATE->setDbValueDef($rsnew, UnFormatDateTime($this->RESEND_RM_DATE->CurrentValue, 0), null, false);

        // LENGKAP_RM1
        $this->LENGKAP_RM1->setDbValueDef($rsnew, $this->LENGKAP_RM1->CurrentValue, null, false);

        // LENGKAP_RESUME
        $this->LENGKAP_RESUME->setDbValueDef($rsnew, $this->LENGKAP_RESUME->CurrentValue, null, false);

        // LENGKAP_ANAMNESIS
        $this->LENGKAP_ANAMNESIS->setDbValueDef($rsnew, $this->LENGKAP_ANAMNESIS->CurrentValue, null, false);

        // LENGKAP_CONSENT
        $this->LENGKAP_CONSENT->setDbValueDef($rsnew, $this->LENGKAP_CONSENT->CurrentValue, null, false);

        // LENGKAP_ANESTESI
        $this->LENGKAP_ANESTESI->setDbValueDef($rsnew, $this->LENGKAP_ANESTESI->CurrentValue, null, false);

        // LENGKAP_OP
        $this->LENGKAP_OP->setDbValueDef($rsnew, $this->LENGKAP_OP->CurrentValue, null, false);

        // BACK_RM_DATE
        $this->BACK_RM_DATE->setDbValueDef($rsnew, UnFormatDateTime($this->BACK_RM_DATE->CurrentValue, 0), null, false);

        // VALID_RM_DATE
        $this->VALID_RM_DATE->setDbValueDef($rsnew, UnFormatDateTime($this->VALID_RM_DATE->CurrentValue, 0), null, false);

        // NO_SKP
        $this->NO_SKP->setDbValueDef($rsnew, $this->NO_SKP->CurrentValue, null, false);

        // NO_SKPINAP
        $this->NO_SKPINAP->setDbValueDef($rsnew, $this->NO_SKPINAP->CurrentValue, null, false);

        // DIAGNOSA_ID
        $this->DIAGNOSA_ID->setDbValueDef($rsnew, $this->DIAGNOSA_ID->CurrentValue, null, false);

        // ticket_all
        $this->ticket_all->setDbValueDef($rsnew, $this->ticket_all->CurrentValue, null, false);

        // tanggal_rujukan
        $this->tanggal_rujukan->setDbValueDef($rsnew, UnFormatDateTime($this->tanggal_rujukan->CurrentValue, 0), null, false);

        // ISRJ
        $this->ISRJ->setDbValueDef($rsnew, $this->ISRJ->CurrentValue, null, false);

        // NORUJUKAN
        $this->NORUJUKAN->setDbValueDef($rsnew, $this->NORUJUKAN->CurrentValue, null, false);

        // PPKRUJUKAN
        $this->PPKRUJUKAN->setDbValueDef($rsnew, $this->PPKRUJUKAN->CurrentValue, null, false);

        // LOKASILAKA
        $this->LOKASILAKA->setDbValueDef($rsnew, $this->LOKASILAKA->CurrentValue, null, false);

        // KDPOLI
        $this->KDPOLI->setDbValueDef($rsnew, $this->KDPOLI->CurrentValue, null, false);

        // EDIT_SEP
        $this->EDIT_SEP->setDbValueDef($rsnew, $this->EDIT_SEP->CurrentValue, null, false);

        // DELETE_SEP
        $this->DELETE_SEP->setDbValueDef($rsnew, $this->DELETE_SEP->CurrentValue, null, false);

        // KODE_AGAMA
        $this->KODE_AGAMA->setDbValueDef($rsnew, $this->KODE_AGAMA->CurrentValue, null, false);

        // DIAG_AWAL
        $this->DIAG_AWAL->setDbValueDef($rsnew, $this->DIAG_AWAL->CurrentValue, null, false);

        // AKTIF
        $this->AKTIF->setDbValueDef($rsnew, $this->AKTIF->CurrentValue, null, false);

        // BILL_INAP
        $this->BILL_INAP->setDbValueDef($rsnew, $this->BILL_INAP->CurrentValue, null, false);

        // SEP_PRINTDATE
        $this->SEP_PRINTDATE->setDbValueDef($rsnew, UnFormatDateTime($this->SEP_PRINTDATE->CurrentValue, 0), null, false);

        // MAPPING_SEP
        $this->MAPPING_SEP->setDbValueDef($rsnew, $this->MAPPING_SEP->CurrentValue, null, false);

        // TRANS_ID
        $this->TRANS_ID->setDbValueDef($rsnew, $this->TRANS_ID->CurrentValue, null, false);

        // KDPOLI_EKS
        $this->KDPOLI_EKS->setDbValueDef($rsnew, $this->KDPOLI_EKS->CurrentValue, null, false);

        // COB
        $this->COB->setDbValueDef($rsnew, $this->COB->CurrentValue, null, false);

        // PENJAMIN
        $this->PENJAMIN->setDbValueDef($rsnew, $this->PENJAMIN->CurrentValue, null, false);

        // ASALRUJUKAN
        $this->ASALRUJUKAN->setDbValueDef($rsnew, $this->ASALRUJUKAN->CurrentValue, null, false);

        // RESPONSEP
        $this->RESPONSEP->setDbValueDef($rsnew, $this->RESPONSEP->CurrentValue, null, false);

        // APPROVAL_DESC
        $this->APPROVAL_DESC->setDbValueDef($rsnew, $this->APPROVAL_DESC->CurrentValue, null, false);

        // APPROVAL_RESPONAJUKAN
        $this->APPROVAL_RESPONAJUKAN->setDbValueDef($rsnew, $this->APPROVAL_RESPONAJUKAN->CurrentValue, null, false);

        // APPROVAL_RESPONAPPROV
        $this->APPROVAL_RESPONAPPROV->setDbValueDef($rsnew, $this->APPROVAL_RESPONAPPROV->CurrentValue, null, false);

        // RESPONTGLPLG_DESC
        $this->RESPONTGLPLG_DESC->setDbValueDef($rsnew, $this->RESPONTGLPLG_DESC->CurrentValue, null, false);

        // RESPONPOST_VKLAIM
        $this->RESPONPOST_VKLAIM->setDbValueDef($rsnew, $this->RESPONPOST_VKLAIM->CurrentValue, null, false);

        // RESPONPUT_VKLAIM
        $this->RESPONPUT_VKLAIM->setDbValueDef($rsnew, $this->RESPONPUT_VKLAIM->CurrentValue, null, false);

        // RESPONDEL_VKLAIM
        $this->RESPONDEL_VKLAIM->setDbValueDef($rsnew, $this->RESPONDEL_VKLAIM->CurrentValue, null, false);

        // CALL_TIMES
        $this->CALL_TIMES->setDbValueDef($rsnew, $this->CALL_TIMES->CurrentValue, null, false);

        // CALL_DATE
        $this->CALL_DATE->setDbValueDef($rsnew, UnFormatDateTime($this->CALL_DATE->CurrentValue, 0), null, false);

        // CALL_DATES
        $this->CALL_DATES->setDbValueDef($rsnew, UnFormatDateTime($this->CALL_DATES->CurrentValue, 0), null, false);

        // SERVED_DATE
        $this->SERVED_DATE->setDbValueDef($rsnew, UnFormatDateTime($this->SERVED_DATE->CurrentValue, 0), null, false);

        // SERVED_INAP
        $this->SERVED_INAP->setDbValueDef($rsnew, UnFormatDateTime($this->SERVED_INAP->CurrentValue, 0), null, false);

        // KDDPJP1
        $this->KDDPJP1->setDbValueDef($rsnew, $this->KDDPJP1->CurrentValue, null, false);

        // KDDPJP
        $this->KDDPJP->setDbValueDef($rsnew, $this->KDDPJP->CurrentValue, null, false);

        // tgl_kontrol
        $this->tgl_kontrol->setDbValueDef($rsnew, UnFormatDateTime($this->tgl_kontrol->CurrentValue, 0), null, false);

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
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("VFarmasiList"), "", $this->TableVar, true);
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
