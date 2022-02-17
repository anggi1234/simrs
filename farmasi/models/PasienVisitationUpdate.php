<?php

namespace PHPMaker2021\SIMRS;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class PasienVisitationUpdate extends PasienVisitation
{
    use MessagesTrait;

    // Page ID
    public $PageID = "update";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'PASIEN_VISITATION';

    // Page object name
    public $PageObjName = "PasienVisitationUpdate";

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

        // Table object (PASIEN_VISITATION)
        if (!isset($GLOBALS["PASIEN_VISITATION"]) || get_class($GLOBALS["PASIEN_VISITATION"]) == PROJECT_NAMESPACE . "PASIEN_VISITATION") {
            $GLOBALS["PASIEN_VISITATION"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'PASIEN_VISITATION');
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
                $doc = new $class(Container("PASIEN_VISITATION"));
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
                    if ($pageName == "PasienVisitationView") {
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
    public $FormClassName = "ew-horizontal ew-form ew-update-form";
    public $IsModal = false;
    public $IsMobileOrModal = false;
    public $RecKeys;
    public $Disabled;
    public $UpdateCount = 0;

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
        $this->VISIT_ID->setVisibility();
        $this->NO_REGISTRATION->setVisibility();
        $this->DIANTAR_OLEH->setVisibility();
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
        $this->GENDER->setVisibility();
        $this->KODE_AGAMA->setVisibility();
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
        $this->SEP->setVisibility();
        $this->hideFieldsForAddEdit();
        $this->VISIT_ID->Required = false;
        $this->NO_REGISTRATION->Required = false;

        // Do not use lookup cache
        $this->setUseLookupCache(false);

        // Global Page Loading event (in userfn*.php)
        Page_Loading();

        // Page Load event
        if (method_exists($this, "pageLoad")) {
            $this->pageLoad();
        }

        // Set up lookup cache
        $this->setupLookupOptions($this->NO_REGISTRATION);
        $this->setupLookupOptions($this->STATUS_PASIEN_ID);
        $this->setupLookupOptions($this->RUJUKAN_ID);
        $this->setupLookupOptions($this->REASON_ID);
        $this->setupLookupOptions($this->WAY_ID);
        $this->setupLookupOptions($this->PATIENT_CATEGORY_ID);
        $this->setupLookupOptions($this->CLINIC_ID);
        $this->setupLookupOptions($this->CLINIC_ID_FROM);
        $this->setupLookupOptions($this->KELUAR_ID);
        $this->setupLookupOptions($this->GENDER);
        $this->setupLookupOptions($this->KODE_AGAMA);
        $this->setupLookupOptions($this->EMPLOYEE_ID);
        $this->setupLookupOptions($this->RESPONSIBLE_ID);
        $this->setupLookupOptions($this->PAYOR_ID);
        $this->setupLookupOptions($this->CLASS_ID);
        $this->setupLookupOptions($this->KAL_ID);
        $this->setupLookupOptions($this->COVERAGE_ID);
        $this->setupLookupOptions($this->DIAGNOSA_ID);
        $this->setupLookupOptions($this->ISRJ);
        $this->setupLookupOptions($this->PPKRUJUKAN);

        // Check modal
        if ($this->IsModal) {
            $SkipHeaderFooter = true;
        }
        $this->IsMobileOrModal = IsMobile() || $this->IsModal;
        $this->FormClassName = "ew-form ew-update-form ew-horizontal";

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Try to load keys from list form
        $this->RecKeys = $this->getRecordKeys(); // Load record keys
        if (Post("action") !== null && Post("action") !== "") {
            // Get action
            $this->CurrentAction = Post("action");
            $this->loadFormValues(); // Get form values

            // Validate form
            if (!$this->validateForm()) {
                $this->CurrentAction = "show"; // Form error, reset action
                if (!$this->hasInvalidFields()) { // No fields selected
                    $this->setFailureMessage($Language->phrase("NoFieldSelected"));
                }
            }
        } else {
            $this->loadMultiUpdateValues(); // Load initial values to form
        }
        if (count($this->RecKeys) <= 0) {
            $this->terminate("PasienVisitationList"); // No records selected, return to list
            return;
        }
        if ($this->isUpdate()) {
                if ($this->updateRows()) { // Update Records based on key
                    if ($this->getSuccessMessage() == "") {
                        $this->setSuccessMessage($Language->phrase("UpdateSuccess")); // Set up update success message
                    }
                    $this->terminate($this->getReturnUrl()); // Return to caller
                    return;
                } else {
                    $this->restoreFormValues(); // Restore form values
                }
        }

        // Render row
        $this->RowType = ROWTYPE_EDIT; // Render edit
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

    // Load initial values to form if field values are identical in all selected records
    protected function loadMultiUpdateValues()
    {
        $this->CurrentFilter = $this->getFilterFromRecordKeys();

        // Load recordset
        if ($rs = $this->loadRecordset()) {
            $i = 1;
            while (!$rs->EOF) {
                if ($i == 1) {
                    $this->ORG_UNIT_CODE->setDbValue($rs->fields['ORG_UNIT_CODE']);
                    $this->VISIT_ID->setDbValue($rs->fields['VISIT_ID']);
                    $this->NO_REGISTRATION->setDbValue($rs->fields['NO_REGISTRATION']);
                    $this->DIANTAR_OLEH->setDbValue($rs->fields['DIANTAR_OLEH']);
                    $this->STATUS_PASIEN_ID->setDbValue($rs->fields['STATUS_PASIEN_ID']);
                    $this->RUJUKAN_ID->setDbValue($rs->fields['RUJUKAN_ID']);
                    $this->ADDRESS_OF_RUJUKAN->setDbValue($rs->fields['ADDRESS_OF_RUJUKAN']);
                    $this->REASON_ID->setDbValue($rs->fields['REASON_ID']);
                    $this->WAY_ID->setDbValue($rs->fields['WAY_ID']);
                    $this->PATIENT_CATEGORY_ID->setDbValue($rs->fields['PATIENT_CATEGORY_ID']);
                    $this->BOOKED_DATE->setDbValue($rs->fields['BOOKED_DATE']);
                    $this->VISIT_DATE->setDbValue($rs->fields['VISIT_DATE']);
                    $this->ISNEW->setDbValue($rs->fields['ISNEW']);
                    $this->FOLLOW_UP->setDbValue($rs->fields['FOLLOW_UP']);
                    $this->PLACE_TYPE->setDbValue($rs->fields['PLACE_TYPE']);
                    $this->CLINIC_ID->setDbValue($rs->fields['CLINIC_ID']);
                    $this->CLINIC_ID_FROM->setDbValue($rs->fields['CLINIC_ID_FROM']);
                    $this->CLASS_ROOM_ID->setDbValue($rs->fields['CLASS_ROOM_ID']);
                    $this->BED_ID->setDbValue($rs->fields['BED_ID']);
                    $this->KELUAR_ID->setDbValue($rs->fields['KELUAR_ID']);
                    $this->IN_DATE->setDbValue($rs->fields['IN_DATE']);
                    $this->EXIT_DATE->setDbValue($rs->fields['EXIT_DATE']);
                    $this->GENDER->setDbValue($rs->fields['GENDER']);
                    $this->KODE_AGAMA->setDbValue($rs->fields['KODE_AGAMA']);
                    $this->DESCRIPTION->setDbValue($rs->fields['DESCRIPTION']);
                    $this->VISITOR_ADDRESS->setDbValue($rs->fields['VISITOR_ADDRESS']);
                    $this->MODIFIED_BY->setDbValue($rs->fields['MODIFIED_BY']);
                    $this->MODIFIED_DATE->setDbValue($rs->fields['MODIFIED_DATE']);
                    $this->MODIFIED_FROM->setDbValue($rs->fields['MODIFIED_FROM']);
                    $this->EMPLOYEE_ID->setDbValue($rs->fields['EMPLOYEE_ID']);
                    $this->EMPLOYEE_ID_FROM->setDbValue($rs->fields['EMPLOYEE_ID_FROM']);
                    $this->RESPONSIBLE_ID->setDbValue($rs->fields['RESPONSIBLE_ID']);
                    $this->RESPONSIBLE->setDbValue($rs->fields['RESPONSIBLE']);
                    $this->FAMILY_STATUS_ID->setDbValue($rs->fields['FAMILY_STATUS_ID']);
                    $this->TICKET_NO->setDbValue($rs->fields['TICKET_NO']);
                    $this->ISATTENDED->setDbValue($rs->fields['ISATTENDED']);
                    $this->PAYOR_ID->setDbValue($rs->fields['PAYOR_ID']);
                    $this->CLASS_ID->setDbValue($rs->fields['CLASS_ID']);
                    $this->ISPERTARIF->setDbValue($rs->fields['ISPERTARIF']);
                    $this->KAL_ID->setDbValue($rs->fields['KAL_ID']);
                    $this->EMPLOYEE_INAP->setDbValue($rs->fields['EMPLOYEE_INAP']);
                    $this->PASIEN_ID->setDbValue($rs->fields['PASIEN_ID']);
                    $this->KARYAWAN->setDbValue($rs->fields['KARYAWAN']);
                    $this->ACCOUNT_ID->setDbValue($rs->fields['ACCOUNT_ID']);
                    $this->CLASS_ID_PLAFOND->setDbValue($rs->fields['CLASS_ID_PLAFOND']);
                    $this->BACKCHARGE->setDbValue($rs->fields['BACKCHARGE']);
                    $this->COVERAGE_ID->setDbValue($rs->fields['COVERAGE_ID']);
                    $this->AGEYEAR->setDbValue($rs->fields['AGEYEAR']);
                    $this->AGEMONTH->setDbValue($rs->fields['AGEMONTH']);
                    $this->AGEDAY->setDbValue($rs->fields['AGEDAY']);
                    $this->RECOMENDATION->setDbValue($rs->fields['RECOMENDATION']);
                    $this->CONCLUSION->setDbValue($rs->fields['CONCLUSION']);
                    $this->SPECIMENNO->setDbValue($rs->fields['SPECIMENNO']);
                    $this->LOCKED->setDbValue($rs->fields['LOCKED']);
                    $this->RM_OUT_DATE->setDbValue($rs->fields['RM_OUT_DATE']);
                    $this->RM_IN_DATE->setDbValue($rs->fields['RM_IN_DATE']);
                    $this->LAMA_PINJAM->setDbValue($rs->fields['LAMA_PINJAM']);
                    $this->STANDAR_RJ->setDbValue($rs->fields['STANDAR_RJ']);
                    $this->LENGKAP_RJ->setDbValue($rs->fields['LENGKAP_RJ']);
                    $this->LENGKAP_RI->setDbValue($rs->fields['LENGKAP_RI']);
                    $this->RESEND_RM_DATE->setDbValue($rs->fields['RESEND_RM_DATE']);
                    $this->LENGKAP_RM1->setDbValue($rs->fields['LENGKAP_RM1']);
                    $this->LENGKAP_RESUME->setDbValue($rs->fields['LENGKAP_RESUME']);
                    $this->LENGKAP_ANAMNESIS->setDbValue($rs->fields['LENGKAP_ANAMNESIS']);
                    $this->LENGKAP_CONSENT->setDbValue($rs->fields['LENGKAP_CONSENT']);
                    $this->LENGKAP_ANESTESI->setDbValue($rs->fields['LENGKAP_ANESTESI']);
                    $this->LENGKAP_OP->setDbValue($rs->fields['LENGKAP_OP']);
                    $this->BACK_RM_DATE->setDbValue($rs->fields['BACK_RM_DATE']);
                    $this->VALID_RM_DATE->setDbValue($rs->fields['VALID_RM_DATE']);
                    $this->NO_SKP->setDbValue($rs->fields['NO_SKP']);
                    $this->NO_SKPINAP->setDbValue($rs->fields['NO_SKPINAP']);
                    $this->DIAGNOSA_ID->setDbValue($rs->fields['DIAGNOSA_ID']);
                    $this->ticket_all->setDbValue($rs->fields['ticket_all']);
                    $this->tanggal_rujukan->setDbValue($rs->fields['tanggal_rujukan']);
                    $this->ISRJ->setDbValue($rs->fields['ISRJ']);
                    $this->NORUJUKAN->setDbValue($rs->fields['NORUJUKAN']);
                    $this->PPKRUJUKAN->setDbValue($rs->fields['PPKRUJUKAN']);
                    $this->LOKASILAKA->setDbValue($rs->fields['LOKASILAKA']);
                    $this->KDPOLI->setDbValue($rs->fields['KDPOLI']);
                    $this->EDIT_SEP->setDbValue($rs->fields['EDIT_SEP']);
                    $this->DELETE_SEP->setDbValue($rs->fields['DELETE_SEP']);
                    $this->DIAG_AWAL->setDbValue($rs->fields['DIAG_AWAL']);
                    $this->AKTIF->setDbValue($rs->fields['AKTIF']);
                    $this->BILL_INAP->setDbValue($rs->fields['BILL_INAP']);
                    $this->SEP_PRINTDATE->setDbValue($rs->fields['SEP_PRINTDATE']);
                    $this->MAPPING_SEP->setDbValue($rs->fields['MAPPING_SEP']);
                    $this->TRANS_ID->setDbValue($rs->fields['TRANS_ID']);
                    $this->KDPOLI_EKS->setDbValue($rs->fields['KDPOLI_EKS']);
                    $this->COB->setDbValue($rs->fields['COB']);
                    $this->PENJAMIN->setDbValue($rs->fields['PENJAMIN']);
                    $this->ASALRUJUKAN->setDbValue($rs->fields['ASALRUJUKAN']);
                    $this->RESPONSEP->setDbValue($rs->fields['RESPONSEP']);
                    $this->APPROVAL_DESC->setDbValue($rs->fields['APPROVAL_DESC']);
                    $this->APPROVAL_RESPONAJUKAN->setDbValue($rs->fields['APPROVAL_RESPONAJUKAN']);
                    $this->APPROVAL_RESPONAPPROV->setDbValue($rs->fields['APPROVAL_RESPONAPPROV']);
                    $this->RESPONTGLPLG_DESC->setDbValue($rs->fields['RESPONTGLPLG_DESC']);
                    $this->RESPONPOST_VKLAIM->setDbValue($rs->fields['RESPONPOST_VKLAIM']);
                    $this->RESPONPUT_VKLAIM->setDbValue($rs->fields['RESPONPUT_VKLAIM']);
                    $this->RESPONDEL_VKLAIM->setDbValue($rs->fields['RESPONDEL_VKLAIM']);
                    $this->CALL_TIMES->setDbValue($rs->fields['CALL_TIMES']);
                    $this->CALL_DATE->setDbValue($rs->fields['CALL_DATE']);
                    $this->CALL_DATES->setDbValue($rs->fields['CALL_DATES']);
                    $this->SERVED_DATE->setDbValue($rs->fields['SERVED_DATE']);
                    $this->SERVED_INAP->setDbValue($rs->fields['SERVED_INAP']);
                    $this->KDDPJP1->setDbValue($rs->fields['KDDPJP1']);
                    $this->KDDPJP->setDbValue($rs->fields['KDDPJP']);
                    $this->SEP->setDbValue($rs->fields['SEP']);
                } else {
                    if (!CompareValue($this->ORG_UNIT_CODE->DbValue, $rs->fields['ORG_UNIT_CODE'])) {
                        $this->ORG_UNIT_CODE->CurrentValue = null;
                    }
                    if (!CompareValue($this->VISIT_ID->DbValue, $rs->fields['VISIT_ID'])) {
                        $this->VISIT_ID->CurrentValue = null;
                    }
                    if (!CompareValue($this->NO_REGISTRATION->DbValue, $rs->fields['NO_REGISTRATION'])) {
                        $this->NO_REGISTRATION->CurrentValue = null;
                    }
                    if (!CompareValue($this->DIANTAR_OLEH->DbValue, $rs->fields['DIANTAR_OLEH'])) {
                        $this->DIANTAR_OLEH->CurrentValue = null;
                    }
                    if (!CompareValue($this->STATUS_PASIEN_ID->DbValue, $rs->fields['STATUS_PASIEN_ID'])) {
                        $this->STATUS_PASIEN_ID->CurrentValue = null;
                    }
                    if (!CompareValue($this->RUJUKAN_ID->DbValue, $rs->fields['RUJUKAN_ID'])) {
                        $this->RUJUKAN_ID->CurrentValue = null;
                    }
                    if (!CompareValue($this->ADDRESS_OF_RUJUKAN->DbValue, $rs->fields['ADDRESS_OF_RUJUKAN'])) {
                        $this->ADDRESS_OF_RUJUKAN->CurrentValue = null;
                    }
                    if (!CompareValue($this->REASON_ID->DbValue, $rs->fields['REASON_ID'])) {
                        $this->REASON_ID->CurrentValue = null;
                    }
                    if (!CompareValue($this->WAY_ID->DbValue, $rs->fields['WAY_ID'])) {
                        $this->WAY_ID->CurrentValue = null;
                    }
                    if (!CompareValue($this->PATIENT_CATEGORY_ID->DbValue, $rs->fields['PATIENT_CATEGORY_ID'])) {
                        $this->PATIENT_CATEGORY_ID->CurrentValue = null;
                    }
                    if (!CompareValue($this->BOOKED_DATE->DbValue, $rs->fields['BOOKED_DATE'])) {
                        $this->BOOKED_DATE->CurrentValue = null;
                    }
                    if (!CompareValue($this->VISIT_DATE->DbValue, $rs->fields['VISIT_DATE'])) {
                        $this->VISIT_DATE->CurrentValue = null;
                    }
                    if (!CompareValue($this->ISNEW->DbValue, $rs->fields['ISNEW'])) {
                        $this->ISNEW->CurrentValue = null;
                    }
                    if (!CompareValue($this->FOLLOW_UP->DbValue, $rs->fields['FOLLOW_UP'])) {
                        $this->FOLLOW_UP->CurrentValue = null;
                    }
                    if (!CompareValue($this->PLACE_TYPE->DbValue, $rs->fields['PLACE_TYPE'])) {
                        $this->PLACE_TYPE->CurrentValue = null;
                    }
                    if (!CompareValue($this->CLINIC_ID->DbValue, $rs->fields['CLINIC_ID'])) {
                        $this->CLINIC_ID->CurrentValue = null;
                    }
                    if (!CompareValue($this->CLINIC_ID_FROM->DbValue, $rs->fields['CLINIC_ID_FROM'])) {
                        $this->CLINIC_ID_FROM->CurrentValue = null;
                    }
                    if (!CompareValue($this->CLASS_ROOM_ID->DbValue, $rs->fields['CLASS_ROOM_ID'])) {
                        $this->CLASS_ROOM_ID->CurrentValue = null;
                    }
                    if (!CompareValue($this->BED_ID->DbValue, $rs->fields['BED_ID'])) {
                        $this->BED_ID->CurrentValue = null;
                    }
                    if (!CompareValue($this->KELUAR_ID->DbValue, $rs->fields['KELUAR_ID'])) {
                        $this->KELUAR_ID->CurrentValue = null;
                    }
                    if (!CompareValue($this->IN_DATE->DbValue, $rs->fields['IN_DATE'])) {
                        $this->IN_DATE->CurrentValue = null;
                    }
                    if (!CompareValue($this->EXIT_DATE->DbValue, $rs->fields['EXIT_DATE'])) {
                        $this->EXIT_DATE->CurrentValue = null;
                    }
                    if (!CompareValue($this->GENDER->DbValue, $rs->fields['GENDER'])) {
                        $this->GENDER->CurrentValue = null;
                    }
                    if (!CompareValue($this->KODE_AGAMA->DbValue, $rs->fields['KODE_AGAMA'])) {
                        $this->KODE_AGAMA->CurrentValue = null;
                    }
                    if (!CompareValue($this->DESCRIPTION->DbValue, $rs->fields['DESCRIPTION'])) {
                        $this->DESCRIPTION->CurrentValue = null;
                    }
                    if (!CompareValue($this->VISITOR_ADDRESS->DbValue, $rs->fields['VISITOR_ADDRESS'])) {
                        $this->VISITOR_ADDRESS->CurrentValue = null;
                    }
                    if (!CompareValue($this->MODIFIED_BY->DbValue, $rs->fields['MODIFIED_BY'])) {
                        $this->MODIFIED_BY->CurrentValue = null;
                    }
                    if (!CompareValue($this->MODIFIED_DATE->DbValue, $rs->fields['MODIFIED_DATE'])) {
                        $this->MODIFIED_DATE->CurrentValue = null;
                    }
                    if (!CompareValue($this->MODIFIED_FROM->DbValue, $rs->fields['MODIFIED_FROM'])) {
                        $this->MODIFIED_FROM->CurrentValue = null;
                    }
                    if (!CompareValue($this->EMPLOYEE_ID->DbValue, $rs->fields['EMPLOYEE_ID'])) {
                        $this->EMPLOYEE_ID->CurrentValue = null;
                    }
                    if (!CompareValue($this->EMPLOYEE_ID_FROM->DbValue, $rs->fields['EMPLOYEE_ID_FROM'])) {
                        $this->EMPLOYEE_ID_FROM->CurrentValue = null;
                    }
                    if (!CompareValue($this->RESPONSIBLE_ID->DbValue, $rs->fields['RESPONSIBLE_ID'])) {
                        $this->RESPONSIBLE_ID->CurrentValue = null;
                    }
                    if (!CompareValue($this->RESPONSIBLE->DbValue, $rs->fields['RESPONSIBLE'])) {
                        $this->RESPONSIBLE->CurrentValue = null;
                    }
                    if (!CompareValue($this->FAMILY_STATUS_ID->DbValue, $rs->fields['FAMILY_STATUS_ID'])) {
                        $this->FAMILY_STATUS_ID->CurrentValue = null;
                    }
                    if (!CompareValue($this->TICKET_NO->DbValue, $rs->fields['TICKET_NO'])) {
                        $this->TICKET_NO->CurrentValue = null;
                    }
                    if (!CompareValue($this->ISATTENDED->DbValue, $rs->fields['ISATTENDED'])) {
                        $this->ISATTENDED->CurrentValue = null;
                    }
                    if (!CompareValue($this->PAYOR_ID->DbValue, $rs->fields['PAYOR_ID'])) {
                        $this->PAYOR_ID->CurrentValue = null;
                    }
                    if (!CompareValue($this->CLASS_ID->DbValue, $rs->fields['CLASS_ID'])) {
                        $this->CLASS_ID->CurrentValue = null;
                    }
                    if (!CompareValue($this->ISPERTARIF->DbValue, $rs->fields['ISPERTARIF'])) {
                        $this->ISPERTARIF->CurrentValue = null;
                    }
                    if (!CompareValue($this->KAL_ID->DbValue, $rs->fields['KAL_ID'])) {
                        $this->KAL_ID->CurrentValue = null;
                    }
                    if (!CompareValue($this->EMPLOYEE_INAP->DbValue, $rs->fields['EMPLOYEE_INAP'])) {
                        $this->EMPLOYEE_INAP->CurrentValue = null;
                    }
                    if (!CompareValue($this->PASIEN_ID->DbValue, $rs->fields['PASIEN_ID'])) {
                        $this->PASIEN_ID->CurrentValue = null;
                    }
                    if (!CompareValue($this->KARYAWAN->DbValue, $rs->fields['KARYAWAN'])) {
                        $this->KARYAWAN->CurrentValue = null;
                    }
                    if (!CompareValue($this->ACCOUNT_ID->DbValue, $rs->fields['ACCOUNT_ID'])) {
                        $this->ACCOUNT_ID->CurrentValue = null;
                    }
                    if (!CompareValue($this->CLASS_ID_PLAFOND->DbValue, $rs->fields['CLASS_ID_PLAFOND'])) {
                        $this->CLASS_ID_PLAFOND->CurrentValue = null;
                    }
                    if (!CompareValue($this->BACKCHARGE->DbValue, $rs->fields['BACKCHARGE'])) {
                        $this->BACKCHARGE->CurrentValue = null;
                    }
                    if (!CompareValue($this->COVERAGE_ID->DbValue, $rs->fields['COVERAGE_ID'])) {
                        $this->COVERAGE_ID->CurrentValue = null;
                    }
                    if (!CompareValue($this->AGEYEAR->DbValue, $rs->fields['AGEYEAR'])) {
                        $this->AGEYEAR->CurrentValue = null;
                    }
                    if (!CompareValue($this->AGEMONTH->DbValue, $rs->fields['AGEMONTH'])) {
                        $this->AGEMONTH->CurrentValue = null;
                    }
                    if (!CompareValue($this->AGEDAY->DbValue, $rs->fields['AGEDAY'])) {
                        $this->AGEDAY->CurrentValue = null;
                    }
                    if (!CompareValue($this->RECOMENDATION->DbValue, $rs->fields['RECOMENDATION'])) {
                        $this->RECOMENDATION->CurrentValue = null;
                    }
                    if (!CompareValue($this->CONCLUSION->DbValue, $rs->fields['CONCLUSION'])) {
                        $this->CONCLUSION->CurrentValue = null;
                    }
                    if (!CompareValue($this->SPECIMENNO->DbValue, $rs->fields['SPECIMENNO'])) {
                        $this->SPECIMENNO->CurrentValue = null;
                    }
                    if (!CompareValue($this->LOCKED->DbValue, $rs->fields['LOCKED'])) {
                        $this->LOCKED->CurrentValue = null;
                    }
                    if (!CompareValue($this->RM_OUT_DATE->DbValue, $rs->fields['RM_OUT_DATE'])) {
                        $this->RM_OUT_DATE->CurrentValue = null;
                    }
                    if (!CompareValue($this->RM_IN_DATE->DbValue, $rs->fields['RM_IN_DATE'])) {
                        $this->RM_IN_DATE->CurrentValue = null;
                    }
                    if (!CompareValue($this->LAMA_PINJAM->DbValue, $rs->fields['LAMA_PINJAM'])) {
                        $this->LAMA_PINJAM->CurrentValue = null;
                    }
                    if (!CompareValue($this->STANDAR_RJ->DbValue, $rs->fields['STANDAR_RJ'])) {
                        $this->STANDAR_RJ->CurrentValue = null;
                    }
                    if (!CompareValue($this->LENGKAP_RJ->DbValue, $rs->fields['LENGKAP_RJ'])) {
                        $this->LENGKAP_RJ->CurrentValue = null;
                    }
                    if (!CompareValue($this->LENGKAP_RI->DbValue, $rs->fields['LENGKAP_RI'])) {
                        $this->LENGKAP_RI->CurrentValue = null;
                    }
                    if (!CompareValue($this->RESEND_RM_DATE->DbValue, $rs->fields['RESEND_RM_DATE'])) {
                        $this->RESEND_RM_DATE->CurrentValue = null;
                    }
                    if (!CompareValue($this->LENGKAP_RM1->DbValue, $rs->fields['LENGKAP_RM1'])) {
                        $this->LENGKAP_RM1->CurrentValue = null;
                    }
                    if (!CompareValue($this->LENGKAP_RESUME->DbValue, $rs->fields['LENGKAP_RESUME'])) {
                        $this->LENGKAP_RESUME->CurrentValue = null;
                    }
                    if (!CompareValue($this->LENGKAP_ANAMNESIS->DbValue, $rs->fields['LENGKAP_ANAMNESIS'])) {
                        $this->LENGKAP_ANAMNESIS->CurrentValue = null;
                    }
                    if (!CompareValue($this->LENGKAP_CONSENT->DbValue, $rs->fields['LENGKAP_CONSENT'])) {
                        $this->LENGKAP_CONSENT->CurrentValue = null;
                    }
                    if (!CompareValue($this->LENGKAP_ANESTESI->DbValue, $rs->fields['LENGKAP_ANESTESI'])) {
                        $this->LENGKAP_ANESTESI->CurrentValue = null;
                    }
                    if (!CompareValue($this->LENGKAP_OP->DbValue, $rs->fields['LENGKAP_OP'])) {
                        $this->LENGKAP_OP->CurrentValue = null;
                    }
                    if (!CompareValue($this->BACK_RM_DATE->DbValue, $rs->fields['BACK_RM_DATE'])) {
                        $this->BACK_RM_DATE->CurrentValue = null;
                    }
                    if (!CompareValue($this->VALID_RM_DATE->DbValue, $rs->fields['VALID_RM_DATE'])) {
                        $this->VALID_RM_DATE->CurrentValue = null;
                    }
                    if (!CompareValue($this->NO_SKP->DbValue, $rs->fields['NO_SKP'])) {
                        $this->NO_SKP->CurrentValue = null;
                    }
                    if (!CompareValue($this->NO_SKPINAP->DbValue, $rs->fields['NO_SKPINAP'])) {
                        $this->NO_SKPINAP->CurrentValue = null;
                    }
                    if (!CompareValue($this->DIAGNOSA_ID->DbValue, $rs->fields['DIAGNOSA_ID'])) {
                        $this->DIAGNOSA_ID->CurrentValue = null;
                    }
                    if (!CompareValue($this->ticket_all->DbValue, $rs->fields['ticket_all'])) {
                        $this->ticket_all->CurrentValue = null;
                    }
                    if (!CompareValue($this->tanggal_rujukan->DbValue, $rs->fields['tanggal_rujukan'])) {
                        $this->tanggal_rujukan->CurrentValue = null;
                    }
                    if (!CompareValue($this->ISRJ->DbValue, $rs->fields['ISRJ'])) {
                        $this->ISRJ->CurrentValue = null;
                    }
                    if (!CompareValue($this->NORUJUKAN->DbValue, $rs->fields['NORUJUKAN'])) {
                        $this->NORUJUKAN->CurrentValue = null;
                    }
                    if (!CompareValue($this->PPKRUJUKAN->DbValue, $rs->fields['PPKRUJUKAN'])) {
                        $this->PPKRUJUKAN->CurrentValue = null;
                    }
                    if (!CompareValue($this->LOKASILAKA->DbValue, $rs->fields['LOKASILAKA'])) {
                        $this->LOKASILAKA->CurrentValue = null;
                    }
                    if (!CompareValue($this->KDPOLI->DbValue, $rs->fields['KDPOLI'])) {
                        $this->KDPOLI->CurrentValue = null;
                    }
                    if (!CompareValue($this->EDIT_SEP->DbValue, $rs->fields['EDIT_SEP'])) {
                        $this->EDIT_SEP->CurrentValue = null;
                    }
                    if (!CompareValue($this->DELETE_SEP->DbValue, $rs->fields['DELETE_SEP'])) {
                        $this->DELETE_SEP->CurrentValue = null;
                    }
                    if (!CompareValue($this->DIAG_AWAL->DbValue, $rs->fields['DIAG_AWAL'])) {
                        $this->DIAG_AWAL->CurrentValue = null;
                    }
                    if (!CompareValue($this->AKTIF->DbValue, $rs->fields['AKTIF'])) {
                        $this->AKTIF->CurrentValue = null;
                    }
                    if (!CompareValue($this->BILL_INAP->DbValue, $rs->fields['BILL_INAP'])) {
                        $this->BILL_INAP->CurrentValue = null;
                    }
                    if (!CompareValue($this->SEP_PRINTDATE->DbValue, $rs->fields['SEP_PRINTDATE'])) {
                        $this->SEP_PRINTDATE->CurrentValue = null;
                    }
                    if (!CompareValue($this->MAPPING_SEP->DbValue, $rs->fields['MAPPING_SEP'])) {
                        $this->MAPPING_SEP->CurrentValue = null;
                    }
                    if (!CompareValue($this->TRANS_ID->DbValue, $rs->fields['TRANS_ID'])) {
                        $this->TRANS_ID->CurrentValue = null;
                    }
                    if (!CompareValue($this->KDPOLI_EKS->DbValue, $rs->fields['KDPOLI_EKS'])) {
                        $this->KDPOLI_EKS->CurrentValue = null;
                    }
                    if (!CompareValue($this->COB->DbValue, $rs->fields['COB'])) {
                        $this->COB->CurrentValue = null;
                    }
                    if (!CompareValue($this->PENJAMIN->DbValue, $rs->fields['PENJAMIN'])) {
                        $this->PENJAMIN->CurrentValue = null;
                    }
                    if (!CompareValue($this->ASALRUJUKAN->DbValue, $rs->fields['ASALRUJUKAN'])) {
                        $this->ASALRUJUKAN->CurrentValue = null;
                    }
                    if (!CompareValue($this->RESPONSEP->DbValue, $rs->fields['RESPONSEP'])) {
                        $this->RESPONSEP->CurrentValue = null;
                    }
                    if (!CompareValue($this->APPROVAL_DESC->DbValue, $rs->fields['APPROVAL_DESC'])) {
                        $this->APPROVAL_DESC->CurrentValue = null;
                    }
                    if (!CompareValue($this->APPROVAL_RESPONAJUKAN->DbValue, $rs->fields['APPROVAL_RESPONAJUKAN'])) {
                        $this->APPROVAL_RESPONAJUKAN->CurrentValue = null;
                    }
                    if (!CompareValue($this->APPROVAL_RESPONAPPROV->DbValue, $rs->fields['APPROVAL_RESPONAPPROV'])) {
                        $this->APPROVAL_RESPONAPPROV->CurrentValue = null;
                    }
                    if (!CompareValue($this->RESPONTGLPLG_DESC->DbValue, $rs->fields['RESPONTGLPLG_DESC'])) {
                        $this->RESPONTGLPLG_DESC->CurrentValue = null;
                    }
                    if (!CompareValue($this->RESPONPOST_VKLAIM->DbValue, $rs->fields['RESPONPOST_VKLAIM'])) {
                        $this->RESPONPOST_VKLAIM->CurrentValue = null;
                    }
                    if (!CompareValue($this->RESPONPUT_VKLAIM->DbValue, $rs->fields['RESPONPUT_VKLAIM'])) {
                        $this->RESPONPUT_VKLAIM->CurrentValue = null;
                    }
                    if (!CompareValue($this->RESPONDEL_VKLAIM->DbValue, $rs->fields['RESPONDEL_VKLAIM'])) {
                        $this->RESPONDEL_VKLAIM->CurrentValue = null;
                    }
                    if (!CompareValue($this->CALL_TIMES->DbValue, $rs->fields['CALL_TIMES'])) {
                        $this->CALL_TIMES->CurrentValue = null;
                    }
                    if (!CompareValue($this->CALL_DATE->DbValue, $rs->fields['CALL_DATE'])) {
                        $this->CALL_DATE->CurrentValue = null;
                    }
                    if (!CompareValue($this->CALL_DATES->DbValue, $rs->fields['CALL_DATES'])) {
                        $this->CALL_DATES->CurrentValue = null;
                    }
                    if (!CompareValue($this->SERVED_DATE->DbValue, $rs->fields['SERVED_DATE'])) {
                        $this->SERVED_DATE->CurrentValue = null;
                    }
                    if (!CompareValue($this->SERVED_INAP->DbValue, $rs->fields['SERVED_INAP'])) {
                        $this->SERVED_INAP->CurrentValue = null;
                    }
                    if (!CompareValue($this->KDDPJP1->DbValue, $rs->fields['KDDPJP1'])) {
                        $this->KDDPJP1->CurrentValue = null;
                    }
                    if (!CompareValue($this->KDDPJP->DbValue, $rs->fields['KDDPJP'])) {
                        $this->KDDPJP->CurrentValue = null;
                    }
                    if (!CompareValue($this->SEP->DbValue, $rs->fields['SEP'])) {
                        $this->SEP->CurrentValue = null;
                    }
                }
                $i++;
                $rs->moveNext();
            }
            $rs->close();
        }
    }

    // Set up key value
    protected function setupKeyValues($key)
    {
        $keyFld = $key;
        if (!is_numeric($keyFld)) {
            return false;
        }
        $this->IDXDAFTAR->OldValue = $keyFld;
        return true;
    }

    // Update all selected rows
    protected function updateRows()
    {
        global $Language;
        $conn = $this->getConnection();
        $conn->beginTransaction();

        // Get old records
        $this->CurrentFilter = $this->getFilterFromRecordKeys(false);
        $sql = $this->getCurrentSql();
        $rsold = $conn->fetchAll($sql);

        // Update all rows
        $key = "";
        foreach ($this->RecKeys as $reckey) {
            if ($this->setupKeyValues($reckey)) {
                $thisKey = $reckey;
                $this->SendEmail = false; // Do not send email on update success
                $this->UpdateCount += 1; // Update record count for records being updated
                $updateRows = $this->editRow(); // Update this row
            } else {
                $updateRows = false;
            }
            if (!$updateRows) {
                break; // Update failed
            }
            if ($key != "") {
                $key .= ", ";
            }
            $key .= $thisKey;
        }

        // Check if all rows updated
        if ($updateRows) {
            $conn->commit(); // Commit transaction

            // Get new records
            $rsnew = $conn->fetchAll($sql);
        } else {
            $conn->rollback(); // Rollback transaction
        }
        return $updateRows;
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
        $this->ORG_UNIT_CODE->MultiUpdate = $CurrentForm->getValue("u_ORG_UNIT_CODE");

        // Check field name 'VISIT_ID' first before field var 'x_VISIT_ID'
        $val = $CurrentForm->hasValue("VISIT_ID") ? $CurrentForm->getValue("VISIT_ID") : $CurrentForm->getValue("x_VISIT_ID");
        if (!$this->VISIT_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->VISIT_ID->Visible = false; // Disable update for API request
            } else {
                $this->VISIT_ID->setFormValue($val);
            }
        }
        $this->VISIT_ID->MultiUpdate = $CurrentForm->getValue("u_VISIT_ID");

        // Check field name 'NO_REGISTRATION' first before field var 'x_NO_REGISTRATION'
        $val = $CurrentForm->hasValue("NO_REGISTRATION") ? $CurrentForm->getValue("NO_REGISTRATION") : $CurrentForm->getValue("x_NO_REGISTRATION");
        if (!$this->NO_REGISTRATION->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->NO_REGISTRATION->Visible = false; // Disable update for API request
            } else {
                $this->NO_REGISTRATION->setFormValue($val);
            }
        }
        $this->NO_REGISTRATION->MultiUpdate = $CurrentForm->getValue("u_NO_REGISTRATION");

        // Check field name 'DIANTAR_OLEH' first before field var 'x_DIANTAR_OLEH'
        $val = $CurrentForm->hasValue("DIANTAR_OLEH") ? $CurrentForm->getValue("DIANTAR_OLEH") : $CurrentForm->getValue("x_DIANTAR_OLEH");
        if (!$this->DIANTAR_OLEH->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->DIANTAR_OLEH->Visible = false; // Disable update for API request
            } else {
                $this->DIANTAR_OLEH->setFormValue($val);
            }
        }
        $this->DIANTAR_OLEH->MultiUpdate = $CurrentForm->getValue("u_DIANTAR_OLEH");

        // Check field name 'STATUS_PASIEN_ID' first before field var 'x_STATUS_PASIEN_ID'
        $val = $CurrentForm->hasValue("STATUS_PASIEN_ID") ? $CurrentForm->getValue("STATUS_PASIEN_ID") : $CurrentForm->getValue("x_STATUS_PASIEN_ID");
        if (!$this->STATUS_PASIEN_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->STATUS_PASIEN_ID->Visible = false; // Disable update for API request
            } else {
                $this->STATUS_PASIEN_ID->setFormValue($val);
            }
        }
        $this->STATUS_PASIEN_ID->MultiUpdate = $CurrentForm->getValue("u_STATUS_PASIEN_ID");

        // Check field name 'RUJUKAN_ID' first before field var 'x_RUJUKAN_ID'
        $val = $CurrentForm->hasValue("RUJUKAN_ID") ? $CurrentForm->getValue("RUJUKAN_ID") : $CurrentForm->getValue("x_RUJUKAN_ID");
        if (!$this->RUJUKAN_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->RUJUKAN_ID->Visible = false; // Disable update for API request
            } else {
                $this->RUJUKAN_ID->setFormValue($val);
            }
        }
        $this->RUJUKAN_ID->MultiUpdate = $CurrentForm->getValue("u_RUJUKAN_ID");

        // Check field name 'ADDRESS_OF_RUJUKAN' first before field var 'x_ADDRESS_OF_RUJUKAN'
        $val = $CurrentForm->hasValue("ADDRESS_OF_RUJUKAN") ? $CurrentForm->getValue("ADDRESS_OF_RUJUKAN") : $CurrentForm->getValue("x_ADDRESS_OF_RUJUKAN");
        if (!$this->ADDRESS_OF_RUJUKAN->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ADDRESS_OF_RUJUKAN->Visible = false; // Disable update for API request
            } else {
                $this->ADDRESS_OF_RUJUKAN->setFormValue($val);
            }
        }
        $this->ADDRESS_OF_RUJUKAN->MultiUpdate = $CurrentForm->getValue("u_ADDRESS_OF_RUJUKAN");

        // Check field name 'REASON_ID' first before field var 'x_REASON_ID'
        $val = $CurrentForm->hasValue("REASON_ID") ? $CurrentForm->getValue("REASON_ID") : $CurrentForm->getValue("x_REASON_ID");
        if (!$this->REASON_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->REASON_ID->Visible = false; // Disable update for API request
            } else {
                $this->REASON_ID->setFormValue($val);
            }
        }
        $this->REASON_ID->MultiUpdate = $CurrentForm->getValue("u_REASON_ID");

        // Check field name 'WAY_ID' first before field var 'x_WAY_ID'
        $val = $CurrentForm->hasValue("WAY_ID") ? $CurrentForm->getValue("WAY_ID") : $CurrentForm->getValue("x_WAY_ID");
        if (!$this->WAY_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->WAY_ID->Visible = false; // Disable update for API request
            } else {
                $this->WAY_ID->setFormValue($val);
            }
        }
        $this->WAY_ID->MultiUpdate = $CurrentForm->getValue("u_WAY_ID");

        // Check field name 'PATIENT_CATEGORY_ID' first before field var 'x_PATIENT_CATEGORY_ID'
        $val = $CurrentForm->hasValue("PATIENT_CATEGORY_ID") ? $CurrentForm->getValue("PATIENT_CATEGORY_ID") : $CurrentForm->getValue("x_PATIENT_CATEGORY_ID");
        if (!$this->PATIENT_CATEGORY_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->PATIENT_CATEGORY_ID->Visible = false; // Disable update for API request
            } else {
                $this->PATIENT_CATEGORY_ID->setFormValue($val);
            }
        }
        $this->PATIENT_CATEGORY_ID->MultiUpdate = $CurrentForm->getValue("u_PATIENT_CATEGORY_ID");

        // Check field name 'BOOKED_DATE' first before field var 'x_BOOKED_DATE'
        $val = $CurrentForm->hasValue("BOOKED_DATE") ? $CurrentForm->getValue("BOOKED_DATE") : $CurrentForm->getValue("x_BOOKED_DATE");
        if (!$this->BOOKED_DATE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->BOOKED_DATE->Visible = false; // Disable update for API request
            } else {
                $this->BOOKED_DATE->setFormValue($val);
            }
            $this->BOOKED_DATE->CurrentValue = UnFormatDateTime($this->BOOKED_DATE->CurrentValue, 11);
        }
        $this->BOOKED_DATE->MultiUpdate = $CurrentForm->getValue("u_BOOKED_DATE");

        // Check field name 'VISIT_DATE' first before field var 'x_VISIT_DATE'
        $val = $CurrentForm->hasValue("VISIT_DATE") ? $CurrentForm->getValue("VISIT_DATE") : $CurrentForm->getValue("x_VISIT_DATE");
        if (!$this->VISIT_DATE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->VISIT_DATE->Visible = false; // Disable update for API request
            } else {
                $this->VISIT_DATE->setFormValue($val);
            }
            $this->VISIT_DATE->CurrentValue = UnFormatDateTime($this->VISIT_DATE->CurrentValue, 11);
        }
        $this->VISIT_DATE->MultiUpdate = $CurrentForm->getValue("u_VISIT_DATE");

        // Check field name 'ISNEW' first before field var 'x_ISNEW'
        $val = $CurrentForm->hasValue("ISNEW") ? $CurrentForm->getValue("ISNEW") : $CurrentForm->getValue("x_ISNEW");
        if (!$this->ISNEW->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ISNEW->Visible = false; // Disable update for API request
            } else {
                $this->ISNEW->setFormValue($val);
            }
        }
        $this->ISNEW->MultiUpdate = $CurrentForm->getValue("u_ISNEW");

        // Check field name 'FOLLOW_UP' first before field var 'x_FOLLOW_UP'
        $val = $CurrentForm->hasValue("FOLLOW_UP") ? $CurrentForm->getValue("FOLLOW_UP") : $CurrentForm->getValue("x_FOLLOW_UP");
        if (!$this->FOLLOW_UP->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->FOLLOW_UP->Visible = false; // Disable update for API request
            } else {
                $this->FOLLOW_UP->setFormValue($val);
            }
        }
        $this->FOLLOW_UP->MultiUpdate = $CurrentForm->getValue("u_FOLLOW_UP");

        // Check field name 'PLACE_TYPE' first before field var 'x_PLACE_TYPE'
        $val = $CurrentForm->hasValue("PLACE_TYPE") ? $CurrentForm->getValue("PLACE_TYPE") : $CurrentForm->getValue("x_PLACE_TYPE");
        if (!$this->PLACE_TYPE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->PLACE_TYPE->Visible = false; // Disable update for API request
            } else {
                $this->PLACE_TYPE->setFormValue($val);
            }
        }
        $this->PLACE_TYPE->MultiUpdate = $CurrentForm->getValue("u_PLACE_TYPE");

        // Check field name 'CLINIC_ID' first before field var 'x_CLINIC_ID'
        $val = $CurrentForm->hasValue("CLINIC_ID") ? $CurrentForm->getValue("CLINIC_ID") : $CurrentForm->getValue("x_CLINIC_ID");
        if (!$this->CLINIC_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->CLINIC_ID->Visible = false; // Disable update for API request
            } else {
                $this->CLINIC_ID->setFormValue($val);
            }
        }
        $this->CLINIC_ID->MultiUpdate = $CurrentForm->getValue("u_CLINIC_ID");

        // Check field name 'CLINIC_ID_FROM' first before field var 'x_CLINIC_ID_FROM'
        $val = $CurrentForm->hasValue("CLINIC_ID_FROM") ? $CurrentForm->getValue("CLINIC_ID_FROM") : $CurrentForm->getValue("x_CLINIC_ID_FROM");
        if (!$this->CLINIC_ID_FROM->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->CLINIC_ID_FROM->Visible = false; // Disable update for API request
            } else {
                $this->CLINIC_ID_FROM->setFormValue($val);
            }
        }
        $this->CLINIC_ID_FROM->MultiUpdate = $CurrentForm->getValue("u_CLINIC_ID_FROM");

        // Check field name 'CLASS_ROOM_ID' first before field var 'x_CLASS_ROOM_ID'
        $val = $CurrentForm->hasValue("CLASS_ROOM_ID") ? $CurrentForm->getValue("CLASS_ROOM_ID") : $CurrentForm->getValue("x_CLASS_ROOM_ID");
        if (!$this->CLASS_ROOM_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->CLASS_ROOM_ID->Visible = false; // Disable update for API request
            } else {
                $this->CLASS_ROOM_ID->setFormValue($val);
            }
        }
        $this->CLASS_ROOM_ID->MultiUpdate = $CurrentForm->getValue("u_CLASS_ROOM_ID");

        // Check field name 'BED_ID' first before field var 'x_BED_ID'
        $val = $CurrentForm->hasValue("BED_ID") ? $CurrentForm->getValue("BED_ID") : $CurrentForm->getValue("x_BED_ID");
        if (!$this->BED_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->BED_ID->Visible = false; // Disable update for API request
            } else {
                $this->BED_ID->setFormValue($val);
            }
        }
        $this->BED_ID->MultiUpdate = $CurrentForm->getValue("u_BED_ID");

        // Check field name 'KELUAR_ID' first before field var 'x_KELUAR_ID'
        $val = $CurrentForm->hasValue("KELUAR_ID") ? $CurrentForm->getValue("KELUAR_ID") : $CurrentForm->getValue("x_KELUAR_ID");
        if (!$this->KELUAR_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->KELUAR_ID->Visible = false; // Disable update for API request
            } else {
                $this->KELUAR_ID->setFormValue($val);
            }
        }
        $this->KELUAR_ID->MultiUpdate = $CurrentForm->getValue("u_KELUAR_ID");

        // Check field name 'IN_DATE' first before field var 'x_IN_DATE'
        $val = $CurrentForm->hasValue("IN_DATE") ? $CurrentForm->getValue("IN_DATE") : $CurrentForm->getValue("x_IN_DATE");
        if (!$this->IN_DATE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->IN_DATE->Visible = false; // Disable update for API request
            } else {
                $this->IN_DATE->setFormValue($val);
            }
            $this->IN_DATE->CurrentValue = UnFormatDateTime($this->IN_DATE->CurrentValue, 11);
        }
        $this->IN_DATE->MultiUpdate = $CurrentForm->getValue("u_IN_DATE");

        // Check field name 'EXIT_DATE' first before field var 'x_EXIT_DATE'
        $val = $CurrentForm->hasValue("EXIT_DATE") ? $CurrentForm->getValue("EXIT_DATE") : $CurrentForm->getValue("x_EXIT_DATE");
        if (!$this->EXIT_DATE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->EXIT_DATE->Visible = false; // Disable update for API request
            } else {
                $this->EXIT_DATE->setFormValue($val);
            }
            $this->EXIT_DATE->CurrentValue = UnFormatDateTime($this->EXIT_DATE->CurrentValue, 11);
        }
        $this->EXIT_DATE->MultiUpdate = $CurrentForm->getValue("u_EXIT_DATE");

        // Check field name 'GENDER' first before field var 'x_GENDER'
        $val = $CurrentForm->hasValue("GENDER") ? $CurrentForm->getValue("GENDER") : $CurrentForm->getValue("x_GENDER");
        if (!$this->GENDER->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->GENDER->Visible = false; // Disable update for API request
            } else {
                $this->GENDER->setFormValue($val);
            }
        }
        $this->GENDER->MultiUpdate = $CurrentForm->getValue("u_GENDER");

        // Check field name 'KODE_AGAMA' first before field var 'x_KODE_AGAMA'
        $val = $CurrentForm->hasValue("KODE_AGAMA") ? $CurrentForm->getValue("KODE_AGAMA") : $CurrentForm->getValue("x_KODE_AGAMA");
        if (!$this->KODE_AGAMA->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->KODE_AGAMA->Visible = false; // Disable update for API request
            } else {
                $this->KODE_AGAMA->setFormValue($val);
            }
        }
        $this->KODE_AGAMA->MultiUpdate = $CurrentForm->getValue("u_KODE_AGAMA");

        // Check field name 'DESCRIPTION' first before field var 'x_DESCRIPTION'
        $val = $CurrentForm->hasValue("DESCRIPTION") ? $CurrentForm->getValue("DESCRIPTION") : $CurrentForm->getValue("x_DESCRIPTION");
        if (!$this->DESCRIPTION->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->DESCRIPTION->Visible = false; // Disable update for API request
            } else {
                $this->DESCRIPTION->setFormValue($val);
            }
        }
        $this->DESCRIPTION->MultiUpdate = $CurrentForm->getValue("u_DESCRIPTION");

        // Check field name 'VISITOR_ADDRESS' first before field var 'x_VISITOR_ADDRESS'
        $val = $CurrentForm->hasValue("VISITOR_ADDRESS") ? $CurrentForm->getValue("VISITOR_ADDRESS") : $CurrentForm->getValue("x_VISITOR_ADDRESS");
        if (!$this->VISITOR_ADDRESS->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->VISITOR_ADDRESS->Visible = false; // Disable update for API request
            } else {
                $this->VISITOR_ADDRESS->setFormValue($val);
            }
        }
        $this->VISITOR_ADDRESS->MultiUpdate = $CurrentForm->getValue("u_VISITOR_ADDRESS");

        // Check field name 'MODIFIED_BY' first before field var 'x_MODIFIED_BY'
        $val = $CurrentForm->hasValue("MODIFIED_BY") ? $CurrentForm->getValue("MODIFIED_BY") : $CurrentForm->getValue("x_MODIFIED_BY");
        if (!$this->MODIFIED_BY->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->MODIFIED_BY->Visible = false; // Disable update for API request
            } else {
                $this->MODIFIED_BY->setFormValue($val);
            }
        }
        $this->MODIFIED_BY->MultiUpdate = $CurrentForm->getValue("u_MODIFIED_BY");

        // Check field name 'MODIFIED_DATE' first before field var 'x_MODIFIED_DATE'
        $val = $CurrentForm->hasValue("MODIFIED_DATE") ? $CurrentForm->getValue("MODIFIED_DATE") : $CurrentForm->getValue("x_MODIFIED_DATE");
        if (!$this->MODIFIED_DATE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->MODIFIED_DATE->Visible = false; // Disable update for API request
            } else {
                $this->MODIFIED_DATE->setFormValue($val);
            }
            $this->MODIFIED_DATE->CurrentValue = UnFormatDateTime($this->MODIFIED_DATE->CurrentValue, 11);
        }
        $this->MODIFIED_DATE->MultiUpdate = $CurrentForm->getValue("u_MODIFIED_DATE");

        // Check field name 'MODIFIED_FROM' first before field var 'x_MODIFIED_FROM'
        $val = $CurrentForm->hasValue("MODIFIED_FROM") ? $CurrentForm->getValue("MODIFIED_FROM") : $CurrentForm->getValue("x_MODIFIED_FROM");
        if (!$this->MODIFIED_FROM->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->MODIFIED_FROM->Visible = false; // Disable update for API request
            } else {
                $this->MODIFIED_FROM->setFormValue($val);
            }
        }
        $this->MODIFIED_FROM->MultiUpdate = $CurrentForm->getValue("u_MODIFIED_FROM");

        // Check field name 'EMPLOYEE_ID' first before field var 'x_EMPLOYEE_ID'
        $val = $CurrentForm->hasValue("EMPLOYEE_ID") ? $CurrentForm->getValue("EMPLOYEE_ID") : $CurrentForm->getValue("x_EMPLOYEE_ID");
        if (!$this->EMPLOYEE_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->EMPLOYEE_ID->Visible = false; // Disable update for API request
            } else {
                $this->EMPLOYEE_ID->setFormValue($val);
            }
        }
        $this->EMPLOYEE_ID->MultiUpdate = $CurrentForm->getValue("u_EMPLOYEE_ID");

        // Check field name 'EMPLOYEE_ID_FROM' first before field var 'x_EMPLOYEE_ID_FROM'
        $val = $CurrentForm->hasValue("EMPLOYEE_ID_FROM") ? $CurrentForm->getValue("EMPLOYEE_ID_FROM") : $CurrentForm->getValue("x_EMPLOYEE_ID_FROM");
        if (!$this->EMPLOYEE_ID_FROM->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->EMPLOYEE_ID_FROM->Visible = false; // Disable update for API request
            } else {
                $this->EMPLOYEE_ID_FROM->setFormValue($val);
            }
        }
        $this->EMPLOYEE_ID_FROM->MultiUpdate = $CurrentForm->getValue("u_EMPLOYEE_ID_FROM");

        // Check field name 'RESPONSIBLE_ID' first before field var 'x_RESPONSIBLE_ID'
        $val = $CurrentForm->hasValue("RESPONSIBLE_ID") ? $CurrentForm->getValue("RESPONSIBLE_ID") : $CurrentForm->getValue("x_RESPONSIBLE_ID");
        if (!$this->RESPONSIBLE_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->RESPONSIBLE_ID->Visible = false; // Disable update for API request
            } else {
                $this->RESPONSIBLE_ID->setFormValue($val);
            }
        }
        $this->RESPONSIBLE_ID->MultiUpdate = $CurrentForm->getValue("u_RESPONSIBLE_ID");

        // Check field name 'RESPONSIBLE' first before field var 'x_RESPONSIBLE'
        $val = $CurrentForm->hasValue("RESPONSIBLE") ? $CurrentForm->getValue("RESPONSIBLE") : $CurrentForm->getValue("x_RESPONSIBLE");
        if (!$this->RESPONSIBLE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->RESPONSIBLE->Visible = false; // Disable update for API request
            } else {
                $this->RESPONSIBLE->setFormValue($val);
            }
        }
        $this->RESPONSIBLE->MultiUpdate = $CurrentForm->getValue("u_RESPONSIBLE");

        // Check field name 'FAMILY_STATUS_ID' first before field var 'x_FAMILY_STATUS_ID'
        $val = $CurrentForm->hasValue("FAMILY_STATUS_ID") ? $CurrentForm->getValue("FAMILY_STATUS_ID") : $CurrentForm->getValue("x_FAMILY_STATUS_ID");
        if (!$this->FAMILY_STATUS_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->FAMILY_STATUS_ID->Visible = false; // Disable update for API request
            } else {
                $this->FAMILY_STATUS_ID->setFormValue($val);
            }
        }
        $this->FAMILY_STATUS_ID->MultiUpdate = $CurrentForm->getValue("u_FAMILY_STATUS_ID");

        // Check field name 'TICKET_NO' first before field var 'x_TICKET_NO'
        $val = $CurrentForm->hasValue("TICKET_NO") ? $CurrentForm->getValue("TICKET_NO") : $CurrentForm->getValue("x_TICKET_NO");
        if (!$this->TICKET_NO->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->TICKET_NO->Visible = false; // Disable update for API request
            } else {
                $this->TICKET_NO->setFormValue($val);
            }
        }
        $this->TICKET_NO->MultiUpdate = $CurrentForm->getValue("u_TICKET_NO");

        // Check field name 'ISATTENDED' first before field var 'x_ISATTENDED'
        $val = $CurrentForm->hasValue("ISATTENDED") ? $CurrentForm->getValue("ISATTENDED") : $CurrentForm->getValue("x_ISATTENDED");
        if (!$this->ISATTENDED->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ISATTENDED->Visible = false; // Disable update for API request
            } else {
                $this->ISATTENDED->setFormValue($val);
            }
        }
        $this->ISATTENDED->MultiUpdate = $CurrentForm->getValue("u_ISATTENDED");

        // Check field name 'PAYOR_ID' first before field var 'x_PAYOR_ID'
        $val = $CurrentForm->hasValue("PAYOR_ID") ? $CurrentForm->getValue("PAYOR_ID") : $CurrentForm->getValue("x_PAYOR_ID");
        if (!$this->PAYOR_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->PAYOR_ID->Visible = false; // Disable update for API request
            } else {
                $this->PAYOR_ID->setFormValue($val);
            }
        }
        $this->PAYOR_ID->MultiUpdate = $CurrentForm->getValue("u_PAYOR_ID");

        // Check field name 'CLASS_ID' first before field var 'x_CLASS_ID'
        $val = $CurrentForm->hasValue("CLASS_ID") ? $CurrentForm->getValue("CLASS_ID") : $CurrentForm->getValue("x_CLASS_ID");
        if (!$this->CLASS_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->CLASS_ID->Visible = false; // Disable update for API request
            } else {
                $this->CLASS_ID->setFormValue($val);
            }
        }
        $this->CLASS_ID->MultiUpdate = $CurrentForm->getValue("u_CLASS_ID");

        // Check field name 'ISPERTARIF' first before field var 'x_ISPERTARIF'
        $val = $CurrentForm->hasValue("ISPERTARIF") ? $CurrentForm->getValue("ISPERTARIF") : $CurrentForm->getValue("x_ISPERTARIF");
        if (!$this->ISPERTARIF->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ISPERTARIF->Visible = false; // Disable update for API request
            } else {
                $this->ISPERTARIF->setFormValue($val);
            }
        }
        $this->ISPERTARIF->MultiUpdate = $CurrentForm->getValue("u_ISPERTARIF");

        // Check field name 'KAL_ID' first before field var 'x_KAL_ID'
        $val = $CurrentForm->hasValue("KAL_ID") ? $CurrentForm->getValue("KAL_ID") : $CurrentForm->getValue("x_KAL_ID");
        if (!$this->KAL_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->KAL_ID->Visible = false; // Disable update for API request
            } else {
                $this->KAL_ID->setFormValue($val);
            }
        }
        $this->KAL_ID->MultiUpdate = $CurrentForm->getValue("u_KAL_ID");

        // Check field name 'EMPLOYEE_INAP' first before field var 'x_EMPLOYEE_INAP'
        $val = $CurrentForm->hasValue("EMPLOYEE_INAP") ? $CurrentForm->getValue("EMPLOYEE_INAP") : $CurrentForm->getValue("x_EMPLOYEE_INAP");
        if (!$this->EMPLOYEE_INAP->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->EMPLOYEE_INAP->Visible = false; // Disable update for API request
            } else {
                $this->EMPLOYEE_INAP->setFormValue($val);
            }
        }
        $this->EMPLOYEE_INAP->MultiUpdate = $CurrentForm->getValue("u_EMPLOYEE_INAP");

        // Check field name 'PASIEN_ID' first before field var 'x_PASIEN_ID'
        $val = $CurrentForm->hasValue("PASIEN_ID") ? $CurrentForm->getValue("PASIEN_ID") : $CurrentForm->getValue("x_PASIEN_ID");
        if (!$this->PASIEN_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->PASIEN_ID->Visible = false; // Disable update for API request
            } else {
                $this->PASIEN_ID->setFormValue($val);
            }
        }
        $this->PASIEN_ID->MultiUpdate = $CurrentForm->getValue("u_PASIEN_ID");

        // Check field name 'KARYAWAN' first before field var 'x_KARYAWAN'
        $val = $CurrentForm->hasValue("KARYAWAN") ? $CurrentForm->getValue("KARYAWAN") : $CurrentForm->getValue("x_KARYAWAN");
        if (!$this->KARYAWAN->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->KARYAWAN->Visible = false; // Disable update for API request
            } else {
                $this->KARYAWAN->setFormValue($val);
            }
        }
        $this->KARYAWAN->MultiUpdate = $CurrentForm->getValue("u_KARYAWAN");

        // Check field name 'ACCOUNT_ID' first before field var 'x_ACCOUNT_ID'
        $val = $CurrentForm->hasValue("ACCOUNT_ID") ? $CurrentForm->getValue("ACCOUNT_ID") : $CurrentForm->getValue("x_ACCOUNT_ID");
        if (!$this->ACCOUNT_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ACCOUNT_ID->Visible = false; // Disable update for API request
            } else {
                $this->ACCOUNT_ID->setFormValue($val);
            }
        }
        $this->ACCOUNT_ID->MultiUpdate = $CurrentForm->getValue("u_ACCOUNT_ID");

        // Check field name 'CLASS_ID_PLAFOND' first before field var 'x_CLASS_ID_PLAFOND'
        $val = $CurrentForm->hasValue("CLASS_ID_PLAFOND") ? $CurrentForm->getValue("CLASS_ID_PLAFOND") : $CurrentForm->getValue("x_CLASS_ID_PLAFOND");
        if (!$this->CLASS_ID_PLAFOND->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->CLASS_ID_PLAFOND->Visible = false; // Disable update for API request
            } else {
                $this->CLASS_ID_PLAFOND->setFormValue($val);
            }
        }
        $this->CLASS_ID_PLAFOND->MultiUpdate = $CurrentForm->getValue("u_CLASS_ID_PLAFOND");

        // Check field name 'BACKCHARGE' first before field var 'x_BACKCHARGE'
        $val = $CurrentForm->hasValue("BACKCHARGE") ? $CurrentForm->getValue("BACKCHARGE") : $CurrentForm->getValue("x_BACKCHARGE");
        if (!$this->BACKCHARGE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->BACKCHARGE->Visible = false; // Disable update for API request
            } else {
                $this->BACKCHARGE->setFormValue($val);
            }
        }
        $this->BACKCHARGE->MultiUpdate = $CurrentForm->getValue("u_BACKCHARGE");

        // Check field name 'COVERAGE_ID' first before field var 'x_COVERAGE_ID'
        $val = $CurrentForm->hasValue("COVERAGE_ID") ? $CurrentForm->getValue("COVERAGE_ID") : $CurrentForm->getValue("x_COVERAGE_ID");
        if (!$this->COVERAGE_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->COVERAGE_ID->Visible = false; // Disable update for API request
            } else {
                $this->COVERAGE_ID->setFormValue($val);
            }
        }
        $this->COVERAGE_ID->MultiUpdate = $CurrentForm->getValue("u_COVERAGE_ID");

        // Check field name 'AGEYEAR' first before field var 'x_AGEYEAR'
        $val = $CurrentForm->hasValue("AGEYEAR") ? $CurrentForm->getValue("AGEYEAR") : $CurrentForm->getValue("x_AGEYEAR");
        if (!$this->AGEYEAR->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->AGEYEAR->Visible = false; // Disable update for API request
            } else {
                $this->AGEYEAR->setFormValue($val);
            }
        }
        $this->AGEYEAR->MultiUpdate = $CurrentForm->getValue("u_AGEYEAR");

        // Check field name 'AGEMONTH' first before field var 'x_AGEMONTH'
        $val = $CurrentForm->hasValue("AGEMONTH") ? $CurrentForm->getValue("AGEMONTH") : $CurrentForm->getValue("x_AGEMONTH");
        if (!$this->AGEMONTH->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->AGEMONTH->Visible = false; // Disable update for API request
            } else {
                $this->AGEMONTH->setFormValue($val);
            }
        }
        $this->AGEMONTH->MultiUpdate = $CurrentForm->getValue("u_AGEMONTH");

        // Check field name 'AGEDAY' first before field var 'x_AGEDAY'
        $val = $CurrentForm->hasValue("AGEDAY") ? $CurrentForm->getValue("AGEDAY") : $CurrentForm->getValue("x_AGEDAY");
        if (!$this->AGEDAY->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->AGEDAY->Visible = false; // Disable update for API request
            } else {
                $this->AGEDAY->setFormValue($val);
            }
        }
        $this->AGEDAY->MultiUpdate = $CurrentForm->getValue("u_AGEDAY");

        // Check field name 'RECOMENDATION' first before field var 'x_RECOMENDATION'
        $val = $CurrentForm->hasValue("RECOMENDATION") ? $CurrentForm->getValue("RECOMENDATION") : $CurrentForm->getValue("x_RECOMENDATION");
        if (!$this->RECOMENDATION->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->RECOMENDATION->Visible = false; // Disable update for API request
            } else {
                $this->RECOMENDATION->setFormValue($val);
            }
        }
        $this->RECOMENDATION->MultiUpdate = $CurrentForm->getValue("u_RECOMENDATION");

        // Check field name 'CONCLUSION' first before field var 'x_CONCLUSION'
        $val = $CurrentForm->hasValue("CONCLUSION") ? $CurrentForm->getValue("CONCLUSION") : $CurrentForm->getValue("x_CONCLUSION");
        if (!$this->CONCLUSION->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->CONCLUSION->Visible = false; // Disable update for API request
            } else {
                $this->CONCLUSION->setFormValue($val);
            }
        }
        $this->CONCLUSION->MultiUpdate = $CurrentForm->getValue("u_CONCLUSION");

        // Check field name 'SPECIMENNO' first before field var 'x_SPECIMENNO'
        $val = $CurrentForm->hasValue("SPECIMENNO") ? $CurrentForm->getValue("SPECIMENNO") : $CurrentForm->getValue("x_SPECIMENNO");
        if (!$this->SPECIMENNO->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->SPECIMENNO->Visible = false; // Disable update for API request
            } else {
                $this->SPECIMENNO->setFormValue($val);
            }
        }
        $this->SPECIMENNO->MultiUpdate = $CurrentForm->getValue("u_SPECIMENNO");

        // Check field name 'LOCKED' first before field var 'x_LOCKED'
        $val = $CurrentForm->hasValue("LOCKED") ? $CurrentForm->getValue("LOCKED") : $CurrentForm->getValue("x_LOCKED");
        if (!$this->LOCKED->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->LOCKED->Visible = false; // Disable update for API request
            } else {
                $this->LOCKED->setFormValue($val);
            }
        }
        $this->LOCKED->MultiUpdate = $CurrentForm->getValue("u_LOCKED");

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
        $this->RM_OUT_DATE->MultiUpdate = $CurrentForm->getValue("u_RM_OUT_DATE");

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
        $this->RM_IN_DATE->MultiUpdate = $CurrentForm->getValue("u_RM_IN_DATE");

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
        $this->LAMA_PINJAM->MultiUpdate = $CurrentForm->getValue("u_LAMA_PINJAM");

        // Check field name 'STANDAR_RJ' first before field var 'x_STANDAR_RJ'
        $val = $CurrentForm->hasValue("STANDAR_RJ") ? $CurrentForm->getValue("STANDAR_RJ") : $CurrentForm->getValue("x_STANDAR_RJ");
        if (!$this->STANDAR_RJ->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->STANDAR_RJ->Visible = false; // Disable update for API request
            } else {
                $this->STANDAR_RJ->setFormValue($val);
            }
        }
        $this->STANDAR_RJ->MultiUpdate = $CurrentForm->getValue("u_STANDAR_RJ");

        // Check field name 'LENGKAP_RJ' first before field var 'x_LENGKAP_RJ'
        $val = $CurrentForm->hasValue("LENGKAP_RJ") ? $CurrentForm->getValue("LENGKAP_RJ") : $CurrentForm->getValue("x_LENGKAP_RJ");
        if (!$this->LENGKAP_RJ->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->LENGKAP_RJ->Visible = false; // Disable update for API request
            } else {
                $this->LENGKAP_RJ->setFormValue($val);
            }
        }
        $this->LENGKAP_RJ->MultiUpdate = $CurrentForm->getValue("u_LENGKAP_RJ");

        // Check field name 'LENGKAP_RI' first before field var 'x_LENGKAP_RI'
        $val = $CurrentForm->hasValue("LENGKAP_RI") ? $CurrentForm->getValue("LENGKAP_RI") : $CurrentForm->getValue("x_LENGKAP_RI");
        if (!$this->LENGKAP_RI->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->LENGKAP_RI->Visible = false; // Disable update for API request
            } else {
                $this->LENGKAP_RI->setFormValue($val);
            }
        }
        $this->LENGKAP_RI->MultiUpdate = $CurrentForm->getValue("u_LENGKAP_RI");

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
        $this->RESEND_RM_DATE->MultiUpdate = $CurrentForm->getValue("u_RESEND_RM_DATE");

        // Check field name 'LENGKAP_RM1' first before field var 'x_LENGKAP_RM1'
        $val = $CurrentForm->hasValue("LENGKAP_RM1") ? $CurrentForm->getValue("LENGKAP_RM1") : $CurrentForm->getValue("x_LENGKAP_RM1");
        if (!$this->LENGKAP_RM1->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->LENGKAP_RM1->Visible = false; // Disable update for API request
            } else {
                $this->LENGKAP_RM1->setFormValue($val);
            }
        }
        $this->LENGKAP_RM1->MultiUpdate = $CurrentForm->getValue("u_LENGKAP_RM1");

        // Check field name 'LENGKAP_RESUME' first before field var 'x_LENGKAP_RESUME'
        $val = $CurrentForm->hasValue("LENGKAP_RESUME") ? $CurrentForm->getValue("LENGKAP_RESUME") : $CurrentForm->getValue("x_LENGKAP_RESUME");
        if (!$this->LENGKAP_RESUME->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->LENGKAP_RESUME->Visible = false; // Disable update for API request
            } else {
                $this->LENGKAP_RESUME->setFormValue($val);
            }
        }
        $this->LENGKAP_RESUME->MultiUpdate = $CurrentForm->getValue("u_LENGKAP_RESUME");

        // Check field name 'LENGKAP_ANAMNESIS' first before field var 'x_LENGKAP_ANAMNESIS'
        $val = $CurrentForm->hasValue("LENGKAP_ANAMNESIS") ? $CurrentForm->getValue("LENGKAP_ANAMNESIS") : $CurrentForm->getValue("x_LENGKAP_ANAMNESIS");
        if (!$this->LENGKAP_ANAMNESIS->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->LENGKAP_ANAMNESIS->Visible = false; // Disable update for API request
            } else {
                $this->LENGKAP_ANAMNESIS->setFormValue($val);
            }
        }
        $this->LENGKAP_ANAMNESIS->MultiUpdate = $CurrentForm->getValue("u_LENGKAP_ANAMNESIS");

        // Check field name 'LENGKAP_CONSENT' first before field var 'x_LENGKAP_CONSENT'
        $val = $CurrentForm->hasValue("LENGKAP_CONSENT") ? $CurrentForm->getValue("LENGKAP_CONSENT") : $CurrentForm->getValue("x_LENGKAP_CONSENT");
        if (!$this->LENGKAP_CONSENT->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->LENGKAP_CONSENT->Visible = false; // Disable update for API request
            } else {
                $this->LENGKAP_CONSENT->setFormValue($val);
            }
        }
        $this->LENGKAP_CONSENT->MultiUpdate = $CurrentForm->getValue("u_LENGKAP_CONSENT");

        // Check field name 'LENGKAP_ANESTESI' first before field var 'x_LENGKAP_ANESTESI'
        $val = $CurrentForm->hasValue("LENGKAP_ANESTESI") ? $CurrentForm->getValue("LENGKAP_ANESTESI") : $CurrentForm->getValue("x_LENGKAP_ANESTESI");
        if (!$this->LENGKAP_ANESTESI->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->LENGKAP_ANESTESI->Visible = false; // Disable update for API request
            } else {
                $this->LENGKAP_ANESTESI->setFormValue($val);
            }
        }
        $this->LENGKAP_ANESTESI->MultiUpdate = $CurrentForm->getValue("u_LENGKAP_ANESTESI");

        // Check field name 'LENGKAP_OP' first before field var 'x_LENGKAP_OP'
        $val = $CurrentForm->hasValue("LENGKAP_OP") ? $CurrentForm->getValue("LENGKAP_OP") : $CurrentForm->getValue("x_LENGKAP_OP");
        if (!$this->LENGKAP_OP->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->LENGKAP_OP->Visible = false; // Disable update for API request
            } else {
                $this->LENGKAP_OP->setFormValue($val);
            }
        }
        $this->LENGKAP_OP->MultiUpdate = $CurrentForm->getValue("u_LENGKAP_OP");

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
        $this->BACK_RM_DATE->MultiUpdate = $CurrentForm->getValue("u_BACK_RM_DATE");

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
        $this->VALID_RM_DATE->MultiUpdate = $CurrentForm->getValue("u_VALID_RM_DATE");

        // Check field name 'NO_SKP' first before field var 'x_NO_SKP'
        $val = $CurrentForm->hasValue("NO_SKP") ? $CurrentForm->getValue("NO_SKP") : $CurrentForm->getValue("x_NO_SKP");
        if (!$this->NO_SKP->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->NO_SKP->Visible = false; // Disable update for API request
            } else {
                $this->NO_SKP->setFormValue($val);
            }
        }
        $this->NO_SKP->MultiUpdate = $CurrentForm->getValue("u_NO_SKP");

        // Check field name 'NO_SKPINAP' first before field var 'x_NO_SKPINAP'
        $val = $CurrentForm->hasValue("NO_SKPINAP") ? $CurrentForm->getValue("NO_SKPINAP") : $CurrentForm->getValue("x_NO_SKPINAP");
        if (!$this->NO_SKPINAP->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->NO_SKPINAP->Visible = false; // Disable update for API request
            } else {
                $this->NO_SKPINAP->setFormValue($val);
            }
        }
        $this->NO_SKPINAP->MultiUpdate = $CurrentForm->getValue("u_NO_SKPINAP");

        // Check field name 'DIAGNOSA_ID' first before field var 'x_DIAGNOSA_ID'
        $val = $CurrentForm->hasValue("DIAGNOSA_ID") ? $CurrentForm->getValue("DIAGNOSA_ID") : $CurrentForm->getValue("x_DIAGNOSA_ID");
        if (!$this->DIAGNOSA_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->DIAGNOSA_ID->Visible = false; // Disable update for API request
            } else {
                $this->DIAGNOSA_ID->setFormValue($val);
            }
        }
        $this->DIAGNOSA_ID->MultiUpdate = $CurrentForm->getValue("u_DIAGNOSA_ID");

        // Check field name 'ticket_all' first before field var 'x_ticket_all'
        $val = $CurrentForm->hasValue("ticket_all") ? $CurrentForm->getValue("ticket_all") : $CurrentForm->getValue("x_ticket_all");
        if (!$this->ticket_all->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ticket_all->Visible = false; // Disable update for API request
            } else {
                $this->ticket_all->setFormValue($val);
            }
        }
        $this->ticket_all->MultiUpdate = $CurrentForm->getValue("u_ticket_all");

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
        $this->tanggal_rujukan->MultiUpdate = $CurrentForm->getValue("u_tanggal_rujukan");

        // Check field name 'ISRJ' first before field var 'x_ISRJ'
        $val = $CurrentForm->hasValue("ISRJ") ? $CurrentForm->getValue("ISRJ") : $CurrentForm->getValue("x_ISRJ");
        if (!$this->ISRJ->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ISRJ->Visible = false; // Disable update for API request
            } else {
                $this->ISRJ->setFormValue($val);
            }
        }
        $this->ISRJ->MultiUpdate = $CurrentForm->getValue("u_ISRJ");

        // Check field name 'NORUJUKAN' first before field var 'x_NORUJUKAN'
        $val = $CurrentForm->hasValue("NORUJUKAN") ? $CurrentForm->getValue("NORUJUKAN") : $CurrentForm->getValue("x_NORUJUKAN");
        if (!$this->NORUJUKAN->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->NORUJUKAN->Visible = false; // Disable update for API request
            } else {
                $this->NORUJUKAN->setFormValue($val);
            }
        }
        $this->NORUJUKAN->MultiUpdate = $CurrentForm->getValue("u_NORUJUKAN");

        // Check field name 'PPKRUJUKAN' first before field var 'x_PPKRUJUKAN'
        $val = $CurrentForm->hasValue("PPKRUJUKAN") ? $CurrentForm->getValue("PPKRUJUKAN") : $CurrentForm->getValue("x_PPKRUJUKAN");
        if (!$this->PPKRUJUKAN->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->PPKRUJUKAN->Visible = false; // Disable update for API request
            } else {
                $this->PPKRUJUKAN->setFormValue($val);
            }
        }
        $this->PPKRUJUKAN->MultiUpdate = $CurrentForm->getValue("u_PPKRUJUKAN");

        // Check field name 'LOKASILAKA' first before field var 'x_LOKASILAKA'
        $val = $CurrentForm->hasValue("LOKASILAKA") ? $CurrentForm->getValue("LOKASILAKA") : $CurrentForm->getValue("x_LOKASILAKA");
        if (!$this->LOKASILAKA->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->LOKASILAKA->Visible = false; // Disable update for API request
            } else {
                $this->LOKASILAKA->setFormValue($val);
            }
        }
        $this->LOKASILAKA->MultiUpdate = $CurrentForm->getValue("u_LOKASILAKA");

        // Check field name 'KDPOLI' first before field var 'x_KDPOLI'
        $val = $CurrentForm->hasValue("KDPOLI") ? $CurrentForm->getValue("KDPOLI") : $CurrentForm->getValue("x_KDPOLI");
        if (!$this->KDPOLI->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->KDPOLI->Visible = false; // Disable update for API request
            } else {
                $this->KDPOLI->setFormValue($val);
            }
        }
        $this->KDPOLI->MultiUpdate = $CurrentForm->getValue("u_KDPOLI");

        // Check field name 'EDIT_SEP' first before field var 'x_EDIT_SEP'
        $val = $CurrentForm->hasValue("EDIT_SEP") ? $CurrentForm->getValue("EDIT_SEP") : $CurrentForm->getValue("x_EDIT_SEP");
        if (!$this->EDIT_SEP->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->EDIT_SEP->Visible = false; // Disable update for API request
            } else {
                $this->EDIT_SEP->setFormValue($val);
            }
        }
        $this->EDIT_SEP->MultiUpdate = $CurrentForm->getValue("u_EDIT_SEP");

        // Check field name 'DELETE_SEP' first before field var 'x_DELETE_SEP'
        $val = $CurrentForm->hasValue("DELETE_SEP") ? $CurrentForm->getValue("DELETE_SEP") : $CurrentForm->getValue("x_DELETE_SEP");
        if (!$this->DELETE_SEP->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->DELETE_SEP->Visible = false; // Disable update for API request
            } else {
                $this->DELETE_SEP->setFormValue($val);
            }
        }
        $this->DELETE_SEP->MultiUpdate = $CurrentForm->getValue("u_DELETE_SEP");

        // Check field name 'DIAG_AWAL' first before field var 'x_DIAG_AWAL'
        $val = $CurrentForm->hasValue("DIAG_AWAL") ? $CurrentForm->getValue("DIAG_AWAL") : $CurrentForm->getValue("x_DIAG_AWAL");
        if (!$this->DIAG_AWAL->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->DIAG_AWAL->Visible = false; // Disable update for API request
            } else {
                $this->DIAG_AWAL->setFormValue($val);
            }
        }
        $this->DIAG_AWAL->MultiUpdate = $CurrentForm->getValue("u_DIAG_AWAL");

        // Check field name 'AKTIF' first before field var 'x_AKTIF'
        $val = $CurrentForm->hasValue("AKTIF") ? $CurrentForm->getValue("AKTIF") : $CurrentForm->getValue("x_AKTIF");
        if (!$this->AKTIF->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->AKTIF->Visible = false; // Disable update for API request
            } else {
                $this->AKTIF->setFormValue($val);
            }
        }
        $this->AKTIF->MultiUpdate = $CurrentForm->getValue("u_AKTIF");

        // Check field name 'BILL_INAP' first before field var 'x_BILL_INAP'
        $val = $CurrentForm->hasValue("BILL_INAP") ? $CurrentForm->getValue("BILL_INAP") : $CurrentForm->getValue("x_BILL_INAP");
        if (!$this->BILL_INAP->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->BILL_INAP->Visible = false; // Disable update for API request
            } else {
                $this->BILL_INAP->setFormValue($val);
            }
        }
        $this->BILL_INAP->MultiUpdate = $CurrentForm->getValue("u_BILL_INAP");

        // Check field name 'SEP_PRINTDATE' first before field var 'x_SEP_PRINTDATE'
        $val = $CurrentForm->hasValue("SEP_PRINTDATE") ? $CurrentForm->getValue("SEP_PRINTDATE") : $CurrentForm->getValue("x_SEP_PRINTDATE");
        if (!$this->SEP_PRINTDATE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->SEP_PRINTDATE->Visible = false; // Disable update for API request
            } else {
                $this->SEP_PRINTDATE->setFormValue($val);
            }
            $this->SEP_PRINTDATE->CurrentValue = UnFormatDateTime($this->SEP_PRINTDATE->CurrentValue, 11);
        }
        $this->SEP_PRINTDATE->MultiUpdate = $CurrentForm->getValue("u_SEP_PRINTDATE");

        // Check field name 'MAPPING_SEP' first before field var 'x_MAPPING_SEP'
        $val = $CurrentForm->hasValue("MAPPING_SEP") ? $CurrentForm->getValue("MAPPING_SEP") : $CurrentForm->getValue("x_MAPPING_SEP");
        if (!$this->MAPPING_SEP->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->MAPPING_SEP->Visible = false; // Disable update for API request
            } else {
                $this->MAPPING_SEP->setFormValue($val);
            }
        }
        $this->MAPPING_SEP->MultiUpdate = $CurrentForm->getValue("u_MAPPING_SEP");

        // Check field name 'TRANS_ID' first before field var 'x_TRANS_ID'
        $val = $CurrentForm->hasValue("TRANS_ID") ? $CurrentForm->getValue("TRANS_ID") : $CurrentForm->getValue("x_TRANS_ID");
        if (!$this->TRANS_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->TRANS_ID->Visible = false; // Disable update for API request
            } else {
                $this->TRANS_ID->setFormValue($val);
            }
        }
        $this->TRANS_ID->MultiUpdate = $CurrentForm->getValue("u_TRANS_ID");

        // Check field name 'KDPOLI_EKS' first before field var 'x_KDPOLI_EKS'
        $val = $CurrentForm->hasValue("KDPOLI_EKS") ? $CurrentForm->getValue("KDPOLI_EKS") : $CurrentForm->getValue("x_KDPOLI_EKS");
        if (!$this->KDPOLI_EKS->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->KDPOLI_EKS->Visible = false; // Disable update for API request
            } else {
                $this->KDPOLI_EKS->setFormValue($val);
            }
        }
        $this->KDPOLI_EKS->MultiUpdate = $CurrentForm->getValue("u_KDPOLI_EKS");

        // Check field name 'COB' first before field var 'x_COB'
        $val = $CurrentForm->hasValue("COB") ? $CurrentForm->getValue("COB") : $CurrentForm->getValue("x_COB");
        if (!$this->COB->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->COB->Visible = false; // Disable update for API request
            } else {
                $this->COB->setFormValue($val);
            }
        }
        $this->COB->MultiUpdate = $CurrentForm->getValue("u_COB");

        // Check field name 'PENJAMIN' first before field var 'x_PENJAMIN'
        $val = $CurrentForm->hasValue("PENJAMIN") ? $CurrentForm->getValue("PENJAMIN") : $CurrentForm->getValue("x_PENJAMIN");
        if (!$this->PENJAMIN->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->PENJAMIN->Visible = false; // Disable update for API request
            } else {
                $this->PENJAMIN->setFormValue($val);
            }
        }
        $this->PENJAMIN->MultiUpdate = $CurrentForm->getValue("u_PENJAMIN");

        // Check field name 'ASALRUJUKAN' first before field var 'x_ASALRUJUKAN'
        $val = $CurrentForm->hasValue("ASALRUJUKAN") ? $CurrentForm->getValue("ASALRUJUKAN") : $CurrentForm->getValue("x_ASALRUJUKAN");
        if (!$this->ASALRUJUKAN->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ASALRUJUKAN->Visible = false; // Disable update for API request
            } else {
                $this->ASALRUJUKAN->setFormValue($val);
            }
        }
        $this->ASALRUJUKAN->MultiUpdate = $CurrentForm->getValue("u_ASALRUJUKAN");

        // Check field name 'RESPONSEP' first before field var 'x_RESPONSEP'
        $val = $CurrentForm->hasValue("RESPONSEP") ? $CurrentForm->getValue("RESPONSEP") : $CurrentForm->getValue("x_RESPONSEP");
        if (!$this->RESPONSEP->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->RESPONSEP->Visible = false; // Disable update for API request
            } else {
                $this->RESPONSEP->setFormValue($val);
            }
        }
        $this->RESPONSEP->MultiUpdate = $CurrentForm->getValue("u_RESPONSEP");

        // Check field name 'APPROVAL_DESC' first before field var 'x_APPROVAL_DESC'
        $val = $CurrentForm->hasValue("APPROVAL_DESC") ? $CurrentForm->getValue("APPROVAL_DESC") : $CurrentForm->getValue("x_APPROVAL_DESC");
        if (!$this->APPROVAL_DESC->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->APPROVAL_DESC->Visible = false; // Disable update for API request
            } else {
                $this->APPROVAL_DESC->setFormValue($val);
            }
        }
        $this->APPROVAL_DESC->MultiUpdate = $CurrentForm->getValue("u_APPROVAL_DESC");

        // Check field name 'APPROVAL_RESPONAJUKAN' first before field var 'x_APPROVAL_RESPONAJUKAN'
        $val = $CurrentForm->hasValue("APPROVAL_RESPONAJUKAN") ? $CurrentForm->getValue("APPROVAL_RESPONAJUKAN") : $CurrentForm->getValue("x_APPROVAL_RESPONAJUKAN");
        if (!$this->APPROVAL_RESPONAJUKAN->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->APPROVAL_RESPONAJUKAN->Visible = false; // Disable update for API request
            } else {
                $this->APPROVAL_RESPONAJUKAN->setFormValue($val);
            }
        }
        $this->APPROVAL_RESPONAJUKAN->MultiUpdate = $CurrentForm->getValue("u_APPROVAL_RESPONAJUKAN");

        // Check field name 'APPROVAL_RESPONAPPROV' first before field var 'x_APPROVAL_RESPONAPPROV'
        $val = $CurrentForm->hasValue("APPROVAL_RESPONAPPROV") ? $CurrentForm->getValue("APPROVAL_RESPONAPPROV") : $CurrentForm->getValue("x_APPROVAL_RESPONAPPROV");
        if (!$this->APPROVAL_RESPONAPPROV->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->APPROVAL_RESPONAPPROV->Visible = false; // Disable update for API request
            } else {
                $this->APPROVAL_RESPONAPPROV->setFormValue($val);
            }
        }
        $this->APPROVAL_RESPONAPPROV->MultiUpdate = $CurrentForm->getValue("u_APPROVAL_RESPONAPPROV");

        // Check field name 'RESPONTGLPLG_DESC' first before field var 'x_RESPONTGLPLG_DESC'
        $val = $CurrentForm->hasValue("RESPONTGLPLG_DESC") ? $CurrentForm->getValue("RESPONTGLPLG_DESC") : $CurrentForm->getValue("x_RESPONTGLPLG_DESC");
        if (!$this->RESPONTGLPLG_DESC->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->RESPONTGLPLG_DESC->Visible = false; // Disable update for API request
            } else {
                $this->RESPONTGLPLG_DESC->setFormValue($val);
            }
        }
        $this->RESPONTGLPLG_DESC->MultiUpdate = $CurrentForm->getValue("u_RESPONTGLPLG_DESC");

        // Check field name 'RESPONPOST_VKLAIM' first before field var 'x_RESPONPOST_VKLAIM'
        $val = $CurrentForm->hasValue("RESPONPOST_VKLAIM") ? $CurrentForm->getValue("RESPONPOST_VKLAIM") : $CurrentForm->getValue("x_RESPONPOST_VKLAIM");
        if (!$this->RESPONPOST_VKLAIM->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->RESPONPOST_VKLAIM->Visible = false; // Disable update for API request
            } else {
                $this->RESPONPOST_VKLAIM->setFormValue($val);
            }
        }
        $this->RESPONPOST_VKLAIM->MultiUpdate = $CurrentForm->getValue("u_RESPONPOST_VKLAIM");

        // Check field name 'RESPONPUT_VKLAIM' first before field var 'x_RESPONPUT_VKLAIM'
        $val = $CurrentForm->hasValue("RESPONPUT_VKLAIM") ? $CurrentForm->getValue("RESPONPUT_VKLAIM") : $CurrentForm->getValue("x_RESPONPUT_VKLAIM");
        if (!$this->RESPONPUT_VKLAIM->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->RESPONPUT_VKLAIM->Visible = false; // Disable update for API request
            } else {
                $this->RESPONPUT_VKLAIM->setFormValue($val);
            }
        }
        $this->RESPONPUT_VKLAIM->MultiUpdate = $CurrentForm->getValue("u_RESPONPUT_VKLAIM");

        // Check field name 'RESPONDEL_VKLAIM' first before field var 'x_RESPONDEL_VKLAIM'
        $val = $CurrentForm->hasValue("RESPONDEL_VKLAIM") ? $CurrentForm->getValue("RESPONDEL_VKLAIM") : $CurrentForm->getValue("x_RESPONDEL_VKLAIM");
        if (!$this->RESPONDEL_VKLAIM->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->RESPONDEL_VKLAIM->Visible = false; // Disable update for API request
            } else {
                $this->RESPONDEL_VKLAIM->setFormValue($val);
            }
        }
        $this->RESPONDEL_VKLAIM->MultiUpdate = $CurrentForm->getValue("u_RESPONDEL_VKLAIM");

        // Check field name 'CALL_TIMES' first before field var 'x_CALL_TIMES'
        $val = $CurrentForm->hasValue("CALL_TIMES") ? $CurrentForm->getValue("CALL_TIMES") : $CurrentForm->getValue("x_CALL_TIMES");
        if (!$this->CALL_TIMES->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->CALL_TIMES->Visible = false; // Disable update for API request
            } else {
                $this->CALL_TIMES->setFormValue($val);
            }
        }
        $this->CALL_TIMES->MultiUpdate = $CurrentForm->getValue("u_CALL_TIMES");

        // Check field name 'CALL_DATE' first before field var 'x_CALL_DATE'
        $val = $CurrentForm->hasValue("CALL_DATE") ? $CurrentForm->getValue("CALL_DATE") : $CurrentForm->getValue("x_CALL_DATE");
        if (!$this->CALL_DATE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->CALL_DATE->Visible = false; // Disable update for API request
            } else {
                $this->CALL_DATE->setFormValue($val);
            }
            $this->CALL_DATE->CurrentValue = UnFormatDateTime($this->CALL_DATE->CurrentValue, 11);
        }
        $this->CALL_DATE->MultiUpdate = $CurrentForm->getValue("u_CALL_DATE");

        // Check field name 'CALL_DATES' first before field var 'x_CALL_DATES'
        $val = $CurrentForm->hasValue("CALL_DATES") ? $CurrentForm->getValue("CALL_DATES") : $CurrentForm->getValue("x_CALL_DATES");
        if (!$this->CALL_DATES->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->CALL_DATES->Visible = false; // Disable update for API request
            } else {
                $this->CALL_DATES->setFormValue($val);
            }
            $this->CALL_DATES->CurrentValue = UnFormatDateTime($this->CALL_DATES->CurrentValue, 11);
        }
        $this->CALL_DATES->MultiUpdate = $CurrentForm->getValue("u_CALL_DATES");

        // Check field name 'SERVED_DATE' first before field var 'x_SERVED_DATE'
        $val = $CurrentForm->hasValue("SERVED_DATE") ? $CurrentForm->getValue("SERVED_DATE") : $CurrentForm->getValue("x_SERVED_DATE");
        if (!$this->SERVED_DATE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->SERVED_DATE->Visible = false; // Disable update for API request
            } else {
                $this->SERVED_DATE->setFormValue($val);
            }
            $this->SERVED_DATE->CurrentValue = UnFormatDateTime($this->SERVED_DATE->CurrentValue, 11);
        }
        $this->SERVED_DATE->MultiUpdate = $CurrentForm->getValue("u_SERVED_DATE");

        // Check field name 'SERVED_INAP' first before field var 'x_SERVED_INAP'
        $val = $CurrentForm->hasValue("SERVED_INAP") ? $CurrentForm->getValue("SERVED_INAP") : $CurrentForm->getValue("x_SERVED_INAP");
        if (!$this->SERVED_INAP->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->SERVED_INAP->Visible = false; // Disable update for API request
            } else {
                $this->SERVED_INAP->setFormValue($val);
            }
            $this->SERVED_INAP->CurrentValue = UnFormatDateTime($this->SERVED_INAP->CurrentValue, 11);
        }
        $this->SERVED_INAP->MultiUpdate = $CurrentForm->getValue("u_SERVED_INAP");

        // Check field name 'KDDPJP1' first before field var 'x_KDDPJP1'
        $val = $CurrentForm->hasValue("KDDPJP1") ? $CurrentForm->getValue("KDDPJP1") : $CurrentForm->getValue("x_KDDPJP1");
        if (!$this->KDDPJP1->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->KDDPJP1->Visible = false; // Disable update for API request
            } else {
                $this->KDDPJP1->setFormValue($val);
            }
        }
        $this->KDDPJP1->MultiUpdate = $CurrentForm->getValue("u_KDDPJP1");

        // Check field name 'KDDPJP' first before field var 'x_KDDPJP'
        $val = $CurrentForm->hasValue("KDDPJP") ? $CurrentForm->getValue("KDDPJP") : $CurrentForm->getValue("x_KDDPJP");
        if (!$this->KDDPJP->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->KDDPJP->Visible = false; // Disable update for API request
            } else {
                $this->KDDPJP->setFormValue($val);
            }
        }
        $this->KDDPJP->MultiUpdate = $CurrentForm->getValue("u_KDDPJP");

        // Check field name 'SEP' first before field var 'x_SEP'
        $val = $CurrentForm->hasValue("SEP") ? $CurrentForm->getValue("SEP") : $CurrentForm->getValue("x_SEP");
        if (!$this->SEP->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->SEP->Visible = false; // Disable update for API request
            } else {
                $this->SEP->setFormValue($val);
            }
        }
        $this->SEP->MultiUpdate = $CurrentForm->getValue("u_SEP");

        // Check field name 'IDXDAFTAR' first before field var 'x_IDXDAFTAR'
        $val = $CurrentForm->hasValue("IDXDAFTAR") ? $CurrentForm->getValue("IDXDAFTAR") : $CurrentForm->getValue("x_IDXDAFTAR");
        if (!$this->IDXDAFTAR->IsDetailKey) {
            $this->IDXDAFTAR->setFormValue($val);
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->IDXDAFTAR->CurrentValue = $this->IDXDAFTAR->FormValue;
        $this->ORG_UNIT_CODE->CurrentValue = $this->ORG_UNIT_CODE->FormValue;
        $this->VISIT_ID->CurrentValue = $this->VISIT_ID->FormValue;
        $this->NO_REGISTRATION->CurrentValue = $this->NO_REGISTRATION->FormValue;
        $this->DIANTAR_OLEH->CurrentValue = $this->DIANTAR_OLEH->FormValue;
        $this->STATUS_PASIEN_ID->CurrentValue = $this->STATUS_PASIEN_ID->FormValue;
        $this->RUJUKAN_ID->CurrentValue = $this->RUJUKAN_ID->FormValue;
        $this->ADDRESS_OF_RUJUKAN->CurrentValue = $this->ADDRESS_OF_RUJUKAN->FormValue;
        $this->REASON_ID->CurrentValue = $this->REASON_ID->FormValue;
        $this->WAY_ID->CurrentValue = $this->WAY_ID->FormValue;
        $this->PATIENT_CATEGORY_ID->CurrentValue = $this->PATIENT_CATEGORY_ID->FormValue;
        $this->BOOKED_DATE->CurrentValue = $this->BOOKED_DATE->FormValue;
        $this->BOOKED_DATE->CurrentValue = UnFormatDateTime($this->BOOKED_DATE->CurrentValue, 11);
        $this->VISIT_DATE->CurrentValue = $this->VISIT_DATE->FormValue;
        $this->VISIT_DATE->CurrentValue = UnFormatDateTime($this->VISIT_DATE->CurrentValue, 11);
        $this->ISNEW->CurrentValue = $this->ISNEW->FormValue;
        $this->FOLLOW_UP->CurrentValue = $this->FOLLOW_UP->FormValue;
        $this->PLACE_TYPE->CurrentValue = $this->PLACE_TYPE->FormValue;
        $this->CLINIC_ID->CurrentValue = $this->CLINIC_ID->FormValue;
        $this->CLINIC_ID_FROM->CurrentValue = $this->CLINIC_ID_FROM->FormValue;
        $this->CLASS_ROOM_ID->CurrentValue = $this->CLASS_ROOM_ID->FormValue;
        $this->BED_ID->CurrentValue = $this->BED_ID->FormValue;
        $this->KELUAR_ID->CurrentValue = $this->KELUAR_ID->FormValue;
        $this->IN_DATE->CurrentValue = $this->IN_DATE->FormValue;
        $this->IN_DATE->CurrentValue = UnFormatDateTime($this->IN_DATE->CurrentValue, 11);
        $this->EXIT_DATE->CurrentValue = $this->EXIT_DATE->FormValue;
        $this->EXIT_DATE->CurrentValue = UnFormatDateTime($this->EXIT_DATE->CurrentValue, 11);
        $this->GENDER->CurrentValue = $this->GENDER->FormValue;
        $this->KODE_AGAMA->CurrentValue = $this->KODE_AGAMA->FormValue;
        $this->DESCRIPTION->CurrentValue = $this->DESCRIPTION->FormValue;
        $this->VISITOR_ADDRESS->CurrentValue = $this->VISITOR_ADDRESS->FormValue;
        $this->MODIFIED_BY->CurrentValue = $this->MODIFIED_BY->FormValue;
        $this->MODIFIED_DATE->CurrentValue = $this->MODIFIED_DATE->FormValue;
        $this->MODIFIED_DATE->CurrentValue = UnFormatDateTime($this->MODIFIED_DATE->CurrentValue, 11);
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
        $this->DIAG_AWAL->CurrentValue = $this->DIAG_AWAL->FormValue;
        $this->AKTIF->CurrentValue = $this->AKTIF->FormValue;
        $this->BILL_INAP->CurrentValue = $this->BILL_INAP->FormValue;
        $this->SEP_PRINTDATE->CurrentValue = $this->SEP_PRINTDATE->FormValue;
        $this->SEP_PRINTDATE->CurrentValue = UnFormatDateTime($this->SEP_PRINTDATE->CurrentValue, 11);
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
        $this->CALL_DATE->CurrentValue = UnFormatDateTime($this->CALL_DATE->CurrentValue, 11);
        $this->CALL_DATES->CurrentValue = $this->CALL_DATES->FormValue;
        $this->CALL_DATES->CurrentValue = UnFormatDateTime($this->CALL_DATES->CurrentValue, 11);
        $this->SERVED_DATE->CurrentValue = $this->SERVED_DATE->FormValue;
        $this->SERVED_DATE->CurrentValue = UnFormatDateTime($this->SERVED_DATE->CurrentValue, 11);
        $this->SERVED_INAP->CurrentValue = $this->SERVED_INAP->FormValue;
        $this->SERVED_INAP->CurrentValue = UnFormatDateTime($this->SERVED_INAP->CurrentValue, 11);
        $this->KDDPJP1->CurrentValue = $this->KDDPJP1->FormValue;
        $this->KDDPJP->CurrentValue = $this->KDDPJP->FormValue;
        $this->SEP->CurrentValue = $this->SEP->FormValue;
    }

    // Load recordset
    public function loadRecordset($offset = -1, $rowcnt = -1)
    {
        // Load List page SQL (QueryBuilder)
        $sql = $this->getListSql();

        // Load recordset
        if ($offset > -1) {
            $sql->setFirstResult($offset);
        }
        if ($rowcnt > 0) {
            $sql->setMaxResults($rowcnt);
        }
        $stmt = $sql->execute();
        $rs = new Recordset($stmt, $sql);

        // Call Recordset Selected event
        $this->recordsetSelected($rs);
        return $rs;
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
        $this->VISIT_ID->setDbValue($row['VISIT_ID']);
        $this->NO_REGISTRATION->setDbValue($row['NO_REGISTRATION']);
        $this->DIANTAR_OLEH->setDbValue($row['DIANTAR_OLEH']);
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
        $this->GENDER->setDbValue($row['GENDER']);
        $this->KODE_AGAMA->setDbValue($row['KODE_AGAMA']);
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
        $this->SEP->setDbValue($row['SEP']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['ORG_UNIT_CODE'] = null;
        $row['VISIT_ID'] = null;
        $row['NO_REGISTRATION'] = null;
        $row['DIANTAR_OLEH'] = null;
        $row['STATUS_PASIEN_ID'] = null;
        $row['RUJUKAN_ID'] = null;
        $row['ADDRESS_OF_RUJUKAN'] = null;
        $row['REASON_ID'] = null;
        $row['WAY_ID'] = null;
        $row['PATIENT_CATEGORY_ID'] = null;
        $row['BOOKED_DATE'] = null;
        $row['VISIT_DATE'] = null;
        $row['ISNEW'] = null;
        $row['FOLLOW_UP'] = null;
        $row['PLACE_TYPE'] = null;
        $row['CLINIC_ID'] = null;
        $row['CLINIC_ID_FROM'] = null;
        $row['CLASS_ROOM_ID'] = null;
        $row['BED_ID'] = null;
        $row['KELUAR_ID'] = null;
        $row['IN_DATE'] = null;
        $row['EXIT_DATE'] = null;
        $row['GENDER'] = null;
        $row['KODE_AGAMA'] = null;
        $row['DESCRIPTION'] = null;
        $row['VISITOR_ADDRESS'] = null;
        $row['MODIFIED_BY'] = null;
        $row['MODIFIED_DATE'] = null;
        $row['MODIFIED_FROM'] = null;
        $row['EMPLOYEE_ID'] = null;
        $row['EMPLOYEE_ID_FROM'] = null;
        $row['RESPONSIBLE_ID'] = null;
        $row['RESPONSIBLE'] = null;
        $row['FAMILY_STATUS_ID'] = null;
        $row['TICKET_NO'] = null;
        $row['ISATTENDED'] = null;
        $row['PAYOR_ID'] = null;
        $row['CLASS_ID'] = null;
        $row['ISPERTARIF'] = null;
        $row['KAL_ID'] = null;
        $row['EMPLOYEE_INAP'] = null;
        $row['PASIEN_ID'] = null;
        $row['KARYAWAN'] = null;
        $row['ACCOUNT_ID'] = null;
        $row['CLASS_ID_PLAFOND'] = null;
        $row['BACKCHARGE'] = null;
        $row['COVERAGE_ID'] = null;
        $row['AGEYEAR'] = null;
        $row['AGEMONTH'] = null;
        $row['AGEDAY'] = null;
        $row['RECOMENDATION'] = null;
        $row['CONCLUSION'] = null;
        $row['SPECIMENNO'] = null;
        $row['LOCKED'] = null;
        $row['RM_OUT_DATE'] = null;
        $row['RM_IN_DATE'] = null;
        $row['LAMA_PINJAM'] = null;
        $row['STANDAR_RJ'] = null;
        $row['LENGKAP_RJ'] = null;
        $row['LENGKAP_RI'] = null;
        $row['RESEND_RM_DATE'] = null;
        $row['LENGKAP_RM1'] = null;
        $row['LENGKAP_RESUME'] = null;
        $row['LENGKAP_ANAMNESIS'] = null;
        $row['LENGKAP_CONSENT'] = null;
        $row['LENGKAP_ANESTESI'] = null;
        $row['LENGKAP_OP'] = null;
        $row['BACK_RM_DATE'] = null;
        $row['VALID_RM_DATE'] = null;
        $row['NO_SKP'] = null;
        $row['NO_SKPINAP'] = null;
        $row['DIAGNOSA_ID'] = null;
        $row['ticket_all'] = null;
        $row['tanggal_rujukan'] = null;
        $row['ISRJ'] = null;
        $row['NORUJUKAN'] = null;
        $row['PPKRUJUKAN'] = null;
        $row['LOKASILAKA'] = null;
        $row['KDPOLI'] = null;
        $row['EDIT_SEP'] = null;
        $row['DELETE_SEP'] = null;
        $row['DIAG_AWAL'] = null;
        $row['AKTIF'] = null;
        $row['BILL_INAP'] = null;
        $row['SEP_PRINTDATE'] = null;
        $row['MAPPING_SEP'] = null;
        $row['TRANS_ID'] = null;
        $row['KDPOLI_EKS'] = null;
        $row['COB'] = null;
        $row['PENJAMIN'] = null;
        $row['ASALRUJUKAN'] = null;
        $row['RESPONSEP'] = null;
        $row['APPROVAL_DESC'] = null;
        $row['APPROVAL_RESPONAJUKAN'] = null;
        $row['APPROVAL_RESPONAPPROV'] = null;
        $row['RESPONTGLPLG_DESC'] = null;
        $row['RESPONPOST_VKLAIM'] = null;
        $row['RESPONPUT_VKLAIM'] = null;
        $row['RESPONDEL_VKLAIM'] = null;
        $row['CALL_TIMES'] = null;
        $row['CALL_DATE'] = null;
        $row['CALL_DATES'] = null;
        $row['SERVED_DATE'] = null;
        $row['SERVED_INAP'] = null;
        $row['KDDPJP1'] = null;
        $row['KDDPJP'] = null;
        $row['IDXDAFTAR'] = null;
        $row['SEP'] = null;
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

        // ORG_UNIT_CODE

        // VISIT_ID

        // NO_REGISTRATION

        // DIANTAR_OLEH

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

        // GENDER

        // KODE_AGAMA

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

        // SEP
        if ($this->RowType == ROWTYPE_VIEW) {
            // ORG_UNIT_CODE
            $this->ORG_UNIT_CODE->ViewValue = $this->ORG_UNIT_CODE->CurrentValue;
            $this->ORG_UNIT_CODE->ViewCustomAttributes = "";

            // VISIT_ID
            $this->VISIT_ID->ViewValue = $this->VISIT_ID->CurrentValue;
            $this->VISIT_ID->ViewCustomAttributes = "";

            // NO_REGISTRATION
            $curVal = trim(strval($this->NO_REGISTRATION->CurrentValue));
            if ($curVal != "") {
                $this->NO_REGISTRATION->ViewValue = $this->NO_REGISTRATION->lookupCacheOption($curVal);
                if ($this->NO_REGISTRATION->ViewValue === null) { // Lookup from database
                    $filterWrk = "[NO_REGISTRATION]" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->NO_REGISTRATION->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->NO_REGISTRATION->Lookup->renderViewRow($rswrk[0]);
                        $this->NO_REGISTRATION->ViewValue = $this->NO_REGISTRATION->displayValue($arwrk);
                    } else {
                        $this->NO_REGISTRATION->ViewValue = $this->NO_REGISTRATION->CurrentValue;
                    }
                }
            } else {
                $this->NO_REGISTRATION->ViewValue = null;
            }
            $this->NO_REGISTRATION->ViewCustomAttributes = "";

            // DIANTAR_OLEH
            $this->DIANTAR_OLEH->ViewValue = $this->DIANTAR_OLEH->CurrentValue;
            $this->DIANTAR_OLEH->ViewCustomAttributes = "";

            // STATUS_PASIEN_ID
            $curVal = trim(strval($this->STATUS_PASIEN_ID->CurrentValue));
            if ($curVal != "") {
                $this->STATUS_PASIEN_ID->ViewValue = $this->STATUS_PASIEN_ID->lookupCacheOption($curVal);
                if ($this->STATUS_PASIEN_ID->ViewValue === null) { // Lookup from database
                    $filterWrk = "[STATUS_PASIEN_ID]" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $lookupFilter = function() {
                        return "[ISACTIVE] = 1";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    $sqlWrk = $this->STATUS_PASIEN_ID->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->STATUS_PASIEN_ID->Lookup->renderViewRow($rswrk[0]);
                        $this->STATUS_PASIEN_ID->ViewValue = $this->STATUS_PASIEN_ID->displayValue($arwrk);
                    } else {
                        $this->STATUS_PASIEN_ID->ViewValue = $this->STATUS_PASIEN_ID->CurrentValue;
                    }
                }
            } else {
                $this->STATUS_PASIEN_ID->ViewValue = null;
            }
            $this->STATUS_PASIEN_ID->ViewCustomAttributes = "";

            // RUJUKAN_ID
            $curVal = trim(strval($this->RUJUKAN_ID->CurrentValue));
            if ($curVal != "") {
                $this->RUJUKAN_ID->ViewValue = $this->RUJUKAN_ID->lookupCacheOption($curVal);
                if ($this->RUJUKAN_ID->ViewValue === null) { // Lookup from database
                    $filterWrk = "[RUJUKAN_ID]" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->RUJUKAN_ID->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->RUJUKAN_ID->Lookup->renderViewRow($rswrk[0]);
                        $this->RUJUKAN_ID->ViewValue = $this->RUJUKAN_ID->displayValue($arwrk);
                    } else {
                        $this->RUJUKAN_ID->ViewValue = $this->RUJUKAN_ID->CurrentValue;
                    }
                }
            } else {
                $this->RUJUKAN_ID->ViewValue = null;
            }
            $this->RUJUKAN_ID->ViewCustomAttributes = "";

            // ADDRESS_OF_RUJUKAN
            if (strval($this->ADDRESS_OF_RUJUKAN->CurrentValue) != "") {
                $this->ADDRESS_OF_RUJUKAN->ViewValue = new OptionValues();
                $arwrk = explode(",", strval($this->ADDRESS_OF_RUJUKAN->CurrentValue));
                $cnt = count($arwrk);
                for ($ari = 0; $ari < $cnt; $ari++)
                    $this->ADDRESS_OF_RUJUKAN->ViewValue->add($this->ADDRESS_OF_RUJUKAN->optionCaption(trim($arwrk[$ari])));
            } else {
                $this->ADDRESS_OF_RUJUKAN->ViewValue = null;
            }
            $this->ADDRESS_OF_RUJUKAN->ViewCustomAttributes = "";

            // REASON_ID
            $curVal = trim(strval($this->REASON_ID->CurrentValue));
            if ($curVal != "") {
                $this->REASON_ID->ViewValue = $this->REASON_ID->lookupCacheOption($curVal);
                if ($this->REASON_ID->ViewValue === null) { // Lookup from database
                    $filterWrk = "[REASON_ID]" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->REASON_ID->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->REASON_ID->Lookup->renderViewRow($rswrk[0]);
                        $this->REASON_ID->ViewValue = $this->REASON_ID->displayValue($arwrk);
                    } else {
                        $this->REASON_ID->ViewValue = $this->REASON_ID->CurrentValue;
                    }
                }
            } else {
                $this->REASON_ID->ViewValue = null;
            }
            $this->REASON_ID->ViewCustomAttributes = "";

            // WAY_ID
            $curVal = trim(strval($this->WAY_ID->CurrentValue));
            if ($curVal != "") {
                $this->WAY_ID->ViewValue = $this->WAY_ID->lookupCacheOption($curVal);
                if ($this->WAY_ID->ViewValue === null) { // Lookup from database
                    $filterWrk = "[WAY_ID]" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->WAY_ID->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->WAY_ID->Lookup->renderViewRow($rswrk[0]);
                        $this->WAY_ID->ViewValue = $this->WAY_ID->displayValue($arwrk);
                    } else {
                        $this->WAY_ID->ViewValue = $this->WAY_ID->CurrentValue;
                    }
                }
            } else {
                $this->WAY_ID->ViewValue = null;
            }
            $this->WAY_ID->ViewCustomAttributes = "";

            // PATIENT_CATEGORY_ID
            $curVal = trim(strval($this->PATIENT_CATEGORY_ID->CurrentValue));
            if ($curVal != "") {
                $this->PATIENT_CATEGORY_ID->ViewValue = $this->PATIENT_CATEGORY_ID->lookupCacheOption($curVal);
                if ($this->PATIENT_CATEGORY_ID->ViewValue === null) { // Lookup from database
                    $filterWrk = "[PATIENT_CATEGORY_ID]" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->PATIENT_CATEGORY_ID->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->PATIENT_CATEGORY_ID->Lookup->renderViewRow($rswrk[0]);
                        $this->PATIENT_CATEGORY_ID->ViewValue = $this->PATIENT_CATEGORY_ID->displayValue($arwrk);
                    } else {
                        $this->PATIENT_CATEGORY_ID->ViewValue = $this->PATIENT_CATEGORY_ID->CurrentValue;
                    }
                }
            } else {
                $this->PATIENT_CATEGORY_ID->ViewValue = null;
            }
            $this->PATIENT_CATEGORY_ID->ViewCustomAttributes = "";

            // BOOKED_DATE
            $this->BOOKED_DATE->ViewValue = $this->BOOKED_DATE->CurrentValue;
            $this->BOOKED_DATE->ViewValue = FormatDateTime($this->BOOKED_DATE->ViewValue, 11);
            $this->BOOKED_DATE->ViewCustomAttributes = "";

            // VISIT_DATE
            $this->VISIT_DATE->ViewValue = $this->VISIT_DATE->CurrentValue;
            $this->VISIT_DATE->ViewValue = FormatDateTime($this->VISIT_DATE->ViewValue, 11);
            $this->VISIT_DATE->ViewCustomAttributes = "";

            // ISNEW
            if (strval($this->ISNEW->CurrentValue) != "") {
                $this->ISNEW->ViewValue = $this->ISNEW->optionCaption($this->ISNEW->CurrentValue);
            } else {
                $this->ISNEW->ViewValue = null;
            }
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
            $curVal = trim(strval($this->CLINIC_ID->CurrentValue));
            if ($curVal != "") {
                $this->CLINIC_ID->ViewValue = $this->CLINIC_ID->lookupCacheOption($curVal);
                if ($this->CLINIC_ID->ViewValue === null) { // Lookup from database
                    $filterWrk = "[CLINIC_ID]" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $lookupFilter = function() {
                        return "[STYPE_ID] = 1 OR [STYPE_ID] = 2 OR [STYPE_ID] = 3 OR [STYPE_ID] = 5";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    $sqlWrk = $this->CLINIC_ID->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
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

            // CLINIC_ID_FROM
            $curVal = trim(strval($this->CLINIC_ID_FROM->CurrentValue));
            if ($curVal != "") {
                $this->CLINIC_ID_FROM->ViewValue = $this->CLINIC_ID_FROM->lookupCacheOption($curVal);
                if ($this->CLINIC_ID_FROM->ViewValue === null) { // Lookup from database
                    $filterWrk = "[CLINIC_ID]" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->CLINIC_ID_FROM->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->CLINIC_ID_FROM->Lookup->renderViewRow($rswrk[0]);
                        $this->CLINIC_ID_FROM->ViewValue = $this->CLINIC_ID_FROM->displayValue($arwrk);
                    } else {
                        $this->CLINIC_ID_FROM->ViewValue = $this->CLINIC_ID_FROM->CurrentValue;
                    }
                }
            } else {
                $this->CLINIC_ID_FROM->ViewValue = null;
            }
            $this->CLINIC_ID_FROM->ViewCustomAttributes = "";

            // CLASS_ROOM_ID
            $this->CLASS_ROOM_ID->ViewValue = $this->CLASS_ROOM_ID->CurrentValue;
            $this->CLASS_ROOM_ID->ViewCustomAttributes = "";

            // BED_ID
            $this->BED_ID->ViewValue = $this->BED_ID->CurrentValue;
            $this->BED_ID->ViewValue = FormatNumber($this->BED_ID->ViewValue, 0, -2, -2, -2);
            $this->BED_ID->ViewCustomAttributes = "";

            // KELUAR_ID
            $curVal = trim(strval($this->KELUAR_ID->CurrentValue));
            if ($curVal != "") {
                $this->KELUAR_ID->ViewValue = $this->KELUAR_ID->lookupCacheOption($curVal);
                if ($this->KELUAR_ID->ViewValue === null) { // Lookup from database
                    $filterWrk = "[KELUAR_ID]" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->KELUAR_ID->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->KELUAR_ID->Lookup->renderViewRow($rswrk[0]);
                        $this->KELUAR_ID->ViewValue = $this->KELUAR_ID->displayValue($arwrk);
                    } else {
                        $this->KELUAR_ID->ViewValue = $this->KELUAR_ID->CurrentValue;
                    }
                }
            } else {
                $this->KELUAR_ID->ViewValue = null;
            }
            $this->KELUAR_ID->ViewCustomAttributes = "";

            // IN_DATE
            $this->IN_DATE->ViewValue = $this->IN_DATE->CurrentValue;
            $this->IN_DATE->ViewValue = FormatDateTime($this->IN_DATE->ViewValue, 11);
            $this->IN_DATE->ViewCustomAttributes = "";

            // EXIT_DATE
            $this->EXIT_DATE->ViewValue = $this->EXIT_DATE->CurrentValue;
            $this->EXIT_DATE->ViewValue = FormatDateTime($this->EXIT_DATE->ViewValue, 11);
            $this->EXIT_DATE->ViewCustomAttributes = "";

            // GENDER
            $curVal = trim(strval($this->GENDER->CurrentValue));
            if ($curVal != "") {
                $this->GENDER->ViewValue = $this->GENDER->lookupCacheOption($curVal);
                if ($this->GENDER->ViewValue === null) { // Lookup from database
                    $filterWrk = "[GENDER]" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $lookupFilter = function() {
                        return "[GENDER] = 1 OR [GENDER] = 2";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    $sqlWrk = $this->GENDER->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
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

            // KODE_AGAMA
            $curVal = trim(strval($this->KODE_AGAMA->CurrentValue));
            if ($curVal != "") {
                $this->KODE_AGAMA->ViewValue = $this->KODE_AGAMA->lookupCacheOption($curVal);
                if ($this->KODE_AGAMA->ViewValue === null) { // Lookup from database
                    $filterWrk = "[KODE_AGAMA]" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->KODE_AGAMA->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->KODE_AGAMA->Lookup->renderViewRow($rswrk[0]);
                        $this->KODE_AGAMA->ViewValue = $this->KODE_AGAMA->displayValue($arwrk);
                    } else {
                        $this->KODE_AGAMA->ViewValue = $this->KODE_AGAMA->CurrentValue;
                    }
                }
            } else {
                $this->KODE_AGAMA->ViewValue = null;
            }
            $this->KODE_AGAMA->ViewCustomAttributes = "";

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
            $this->MODIFIED_DATE->ViewValue = FormatDateTime($this->MODIFIED_DATE->ViewValue, 11);
            $this->MODIFIED_DATE->ViewCustomAttributes = "";

            // MODIFIED_FROM
            $this->MODIFIED_FROM->ViewValue = $this->MODIFIED_FROM->CurrentValue;
            $this->MODIFIED_FROM->ViewCustomAttributes = "";

            // EMPLOYEE_ID
            $curVal = trim(strval($this->EMPLOYEE_ID->CurrentValue));
            if ($curVal != "") {
                $this->EMPLOYEE_ID->ViewValue = $this->EMPLOYEE_ID->lookupCacheOption($curVal);
                if ($this->EMPLOYEE_ID->ViewValue === null) { // Lookup from database
                    $filterWrk = "[EMPLOYEE_ID]" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $lookupFilter = function() {
                        return "[OBJECT_CATEGORY_ID]= 20";
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

            // EMPLOYEE_ID_FROM
            $this->EMPLOYEE_ID_FROM->ViewValue = $this->EMPLOYEE_ID_FROM->CurrentValue;
            $this->EMPLOYEE_ID_FROM->ViewCustomAttributes = "";

            // RESPONSIBLE_ID
            $curVal = trim(strval($this->RESPONSIBLE_ID->CurrentValue));
            if ($curVal != "") {
                $this->RESPONSIBLE_ID->ViewValue = $this->RESPONSIBLE_ID->lookupCacheOption($curVal);
                if ($this->RESPONSIBLE_ID->ViewValue === null) { // Lookup from database
                    $filterWrk = "[RESPONSIBLE_ID]" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->RESPONSIBLE_ID->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->RESPONSIBLE_ID->Lookup->renderViewRow($rswrk[0]);
                        $this->RESPONSIBLE_ID->ViewValue = $this->RESPONSIBLE_ID->displayValue($arwrk);
                    } else {
                        $this->RESPONSIBLE_ID->ViewValue = $this->RESPONSIBLE_ID->CurrentValue;
                    }
                }
            } else {
                $this->RESPONSIBLE_ID->ViewValue = null;
            }
            $this->RESPONSIBLE_ID->ViewCustomAttributes = "";

            // RESPONSIBLE
            $this->RESPONSIBLE->ViewValue = $this->RESPONSIBLE->CurrentValue;
            $this->RESPONSIBLE->ViewCustomAttributes = "";

            // FAMILY_STATUS_ID
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
            $curVal = trim(strval($this->PAYOR_ID->CurrentValue));
            if ($curVal != "") {
                $this->PAYOR_ID->ViewValue = $this->PAYOR_ID->lookupCacheOption($curVal);
                if ($this->PAYOR_ID->ViewValue === null) { // Lookup from database
                    $filterWrk = "[PAYOR_ID]" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->PAYOR_ID->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->PAYOR_ID->Lookup->renderViewRow($rswrk[0]);
                        $this->PAYOR_ID->ViewValue = $this->PAYOR_ID->displayValue($arwrk);
                    } else {
                        $this->PAYOR_ID->ViewValue = $this->PAYOR_ID->CurrentValue;
                    }
                }
            } else {
                $this->PAYOR_ID->ViewValue = null;
            }
            $this->PAYOR_ID->ViewCustomAttributes = "";

            // CLASS_ID
            $curVal = trim(strval($this->CLASS_ID->CurrentValue));
            if ($curVal != "") {
                $this->CLASS_ID->ViewValue = $this->CLASS_ID->lookupCacheOption($curVal);
                if ($this->CLASS_ID->ViewValue === null) { // Lookup from database
                    $filterWrk = "[CLASS_ID]" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->CLASS_ID->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->CLASS_ID->Lookup->renderViewRow($rswrk[0]);
                        $this->CLASS_ID->ViewValue = $this->CLASS_ID->displayValue($arwrk);
                    } else {
                        $this->CLASS_ID->ViewValue = $this->CLASS_ID->CurrentValue;
                    }
                }
            } else {
                $this->CLASS_ID->ViewValue = null;
            }
            $this->CLASS_ID->ViewCustomAttributes = "";

            // ISPERTARIF
            $this->ISPERTARIF->ViewValue = $this->ISPERTARIF->CurrentValue;
            $this->ISPERTARIF->ViewCustomAttributes = "";

            // KAL_ID
            $curVal = trim(strval($this->KAL_ID->CurrentValue));
            if ($curVal != "") {
                $this->KAL_ID->ViewValue = $this->KAL_ID->lookupCacheOption($curVal);
                if ($this->KAL_ID->ViewValue === null) { // Lookup from database
                    $filterWrk = "[KAL_ID]" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->KAL_ID->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->KAL_ID->Lookup->renderViewRow($rswrk[0]);
                        $this->KAL_ID->ViewValue = $this->KAL_ID->displayValue($arwrk);
                    } else {
                        $this->KAL_ID->ViewValue = $this->KAL_ID->CurrentValue;
                    }
                }
            } else {
                $this->KAL_ID->ViewValue = null;
            }
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
            $curVal = trim(strval($this->COVERAGE_ID->CurrentValue));
            if ($curVal != "") {
                $this->COVERAGE_ID->ViewValue = $this->COVERAGE_ID->lookupCacheOption($curVal);
                if ($this->COVERAGE_ID->ViewValue === null) { // Lookup from database
                    $filterWrk = "[COVERAGE_ID]" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->COVERAGE_ID->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->COVERAGE_ID->Lookup->renderViewRow($rswrk[0]);
                        $this->COVERAGE_ID->ViewValue = $this->COVERAGE_ID->displayValue($arwrk);
                    } else {
                        $this->COVERAGE_ID->ViewValue = $this->COVERAGE_ID->CurrentValue;
                    }
                }
            } else {
                $this->COVERAGE_ID->ViewValue = null;
            }
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
            $curVal = trim(strval($this->DIAGNOSA_ID->CurrentValue));
            if ($curVal != "") {
                $this->DIAGNOSA_ID->ViewValue = $this->DIAGNOSA_ID->lookupCacheOption($curVal);
                if ($this->DIAGNOSA_ID->ViewValue === null) { // Lookup from database
                    $filterWrk = "[DIAGNOSA_ID]" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->DIAGNOSA_ID->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->DIAGNOSA_ID->Lookup->renderViewRow($rswrk[0]);
                        $this->DIAGNOSA_ID->ViewValue = $this->DIAGNOSA_ID->displayValue($arwrk);
                    } else {
                        $this->DIAGNOSA_ID->ViewValue = $this->DIAGNOSA_ID->CurrentValue;
                    }
                }
            } else {
                $this->DIAGNOSA_ID->ViewValue = null;
            }
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
            $curVal = trim(strval($this->ISRJ->CurrentValue));
            if ($curVal != "") {
                $this->ISRJ->ViewValue = $this->ISRJ->lookupCacheOption($curVal);
                if ($this->ISRJ->ViewValue === null) { // Lookup from database
                    $filterWrk = "[KELUAR_ID]" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->ISRJ->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->ISRJ->Lookup->renderViewRow($rswrk[0]);
                        $this->ISRJ->ViewValue = $this->ISRJ->displayValue($arwrk);
                    } else {
                        $this->ISRJ->ViewValue = $this->ISRJ->CurrentValue;
                    }
                }
            } else {
                $this->ISRJ->ViewValue = null;
            }
            $this->ISRJ->ViewCustomAttributes = "";

            // NORUJUKAN
            $this->NORUJUKAN->ViewValue = $this->NORUJUKAN->CurrentValue;
            $this->NORUJUKAN->ViewCustomAttributes = "";

            // PPKRUJUKAN
            $curVal = trim(strval($this->PPKRUJUKAN->CurrentValue));
            if ($curVal != "") {
                $this->PPKRUJUKAN->ViewValue = $this->PPKRUJUKAN->lookupCacheOption($curVal);
                if ($this->PPKRUJUKAN->ViewValue === null) { // Lookup from database
                    $filterWrk = "[KDPROVIDER]" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->PPKRUJUKAN->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->PPKRUJUKAN->Lookup->renderViewRow($rswrk[0]);
                        $this->PPKRUJUKAN->ViewValue = $this->PPKRUJUKAN->displayValue($arwrk);
                    } else {
                        $this->PPKRUJUKAN->ViewValue = $this->PPKRUJUKAN->CurrentValue;
                    }
                }
            } else {
                $this->PPKRUJUKAN->ViewValue = null;
            }
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
            $this->SEP_PRINTDATE->ViewValue = FormatDateTime($this->SEP_PRINTDATE->ViewValue, 11);
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
            if (strval($this->COB->CurrentValue) != "") {
                $this->COB->ViewValue = new OptionValues();
                $arwrk = explode(",", strval($this->COB->CurrentValue));
                $cnt = count($arwrk);
                for ($ari = 0; $ari < $cnt; $ari++)
                    $this->COB->ViewValue->add($this->COB->optionCaption(trim($arwrk[$ari])));
            } else {
                $this->COB->ViewValue = null;
            }
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
            $this->CALL_DATE->ViewValue = FormatDateTime($this->CALL_DATE->ViewValue, 11);
            $this->CALL_DATE->ViewCustomAttributes = "";

            // CALL_DATES
            $this->CALL_DATES->ViewValue = $this->CALL_DATES->CurrentValue;
            $this->CALL_DATES->ViewValue = FormatDateTime($this->CALL_DATES->ViewValue, 11);
            $this->CALL_DATES->ViewCustomAttributes = "";

            // SERVED_DATE
            $this->SERVED_DATE->ViewValue = $this->SERVED_DATE->CurrentValue;
            $this->SERVED_DATE->ViewValue = FormatDateTime($this->SERVED_DATE->ViewValue, 11);
            $this->SERVED_DATE->ViewCustomAttributes = "";

            // SERVED_INAP
            $this->SERVED_INAP->ViewValue = $this->SERVED_INAP->CurrentValue;
            $this->SERVED_INAP->ViewValue = FormatDateTime($this->SERVED_INAP->ViewValue, 11);
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

            // SEP
            $this->SEP->ViewValue = $this->SEP->CurrentValue;
            $this->SEP->ViewCustomAttributes = "";

            // ORG_UNIT_CODE
            $this->ORG_UNIT_CODE->LinkCustomAttributes = "";
            $this->ORG_UNIT_CODE->HrefValue = "";
            $this->ORG_UNIT_CODE->TooltipValue = "";

            // VISIT_ID
            $this->VISIT_ID->LinkCustomAttributes = "";
            $this->VISIT_ID->HrefValue = "";
            $this->VISIT_ID->TooltipValue = "";

            // NO_REGISTRATION
            $this->NO_REGISTRATION->LinkCustomAttributes = "";
            $this->NO_REGISTRATION->HrefValue = "";
            $this->NO_REGISTRATION->TooltipValue = "";

            // DIANTAR_OLEH
            $this->DIANTAR_OLEH->LinkCustomAttributes = "";
            $this->DIANTAR_OLEH->HrefValue = "";
            $this->DIANTAR_OLEH->TooltipValue = "";

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

            // GENDER
            $this->GENDER->LinkCustomAttributes = "";
            $this->GENDER->HrefValue = "";
            $this->GENDER->TooltipValue = "";

            // KODE_AGAMA
            $this->KODE_AGAMA->LinkCustomAttributes = "";
            $this->KODE_AGAMA->HrefValue = "";
            $this->KODE_AGAMA->TooltipValue = "";

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

            // SEP
            $this->SEP->LinkCustomAttributes = "";
            $this->SEP->HrefValue = "";
            $this->SEP->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_EDIT) {
            // ORG_UNIT_CODE

            // VISIT_ID
            $this->VISIT_ID->EditAttrs["class"] = "form-control";
            $this->VISIT_ID->EditCustomAttributes = "";
            $this->VISIT_ID->EditValue = $this->VISIT_ID->CurrentValue;
            $this->VISIT_ID->ViewCustomAttributes = "";

            // NO_REGISTRATION
            $this->NO_REGISTRATION->EditAttrs["class"] = "form-control";
            $this->NO_REGISTRATION->EditCustomAttributes = "";
            $curVal = trim(strval($this->NO_REGISTRATION->CurrentValue));
            if ($curVal != "") {
                $this->NO_REGISTRATION->EditValue = $this->NO_REGISTRATION->lookupCacheOption($curVal);
                if ($this->NO_REGISTRATION->EditValue === null) { // Lookup from database
                    $filterWrk = "[NO_REGISTRATION]" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->NO_REGISTRATION->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->NO_REGISTRATION->Lookup->renderViewRow($rswrk[0]);
                        $this->NO_REGISTRATION->EditValue = $this->NO_REGISTRATION->displayValue($arwrk);
                    } else {
                        $this->NO_REGISTRATION->EditValue = $this->NO_REGISTRATION->CurrentValue;
                    }
                }
            } else {
                $this->NO_REGISTRATION->EditValue = null;
            }
            $this->NO_REGISTRATION->ViewCustomAttributes = "";

            // DIANTAR_OLEH
            $this->DIANTAR_OLEH->EditAttrs["class"] = "form-control";
            $this->DIANTAR_OLEH->EditCustomAttributes = "";
            $this->DIANTAR_OLEH->EditValue = $this->DIANTAR_OLEH->CurrentValue;
            $this->DIANTAR_OLEH->ViewCustomAttributes = "";

            // STATUS_PASIEN_ID
            $this->STATUS_PASIEN_ID->EditAttrs["class"] = "form-control";
            $this->STATUS_PASIEN_ID->EditCustomAttributes = "";
            $curVal = trim(strval($this->STATUS_PASIEN_ID->CurrentValue));
            if ($curVal != "") {
                $this->STATUS_PASIEN_ID->EditValue = $this->STATUS_PASIEN_ID->lookupCacheOption($curVal);
                if ($this->STATUS_PASIEN_ID->EditValue === null) { // Lookup from database
                    $filterWrk = "[STATUS_PASIEN_ID]" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $lookupFilter = function() {
                        return "[ISACTIVE] = 1";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    $sqlWrk = $this->STATUS_PASIEN_ID->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->STATUS_PASIEN_ID->Lookup->renderViewRow($rswrk[0]);
                        $this->STATUS_PASIEN_ID->EditValue = $this->STATUS_PASIEN_ID->displayValue($arwrk);
                    } else {
                        $this->STATUS_PASIEN_ID->EditValue = $this->STATUS_PASIEN_ID->CurrentValue;
                    }
                }
            } else {
                $this->STATUS_PASIEN_ID->EditValue = null;
            }
            $this->STATUS_PASIEN_ID->ViewCustomAttributes = "";

            // RUJUKAN_ID
            $this->RUJUKAN_ID->EditAttrs["class"] = "form-control";
            $this->RUJUKAN_ID->EditCustomAttributes = "";
            $curVal = trim(strval($this->RUJUKAN_ID->CurrentValue));
            if ($curVal != "") {
                $this->RUJUKAN_ID->EditValue = $this->RUJUKAN_ID->lookupCacheOption($curVal);
                if ($this->RUJUKAN_ID->EditValue === null) { // Lookup from database
                    $filterWrk = "[RUJUKAN_ID]" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->RUJUKAN_ID->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->RUJUKAN_ID->Lookup->renderViewRow($rswrk[0]);
                        $this->RUJUKAN_ID->EditValue = $this->RUJUKAN_ID->displayValue($arwrk);
                    } else {
                        $this->RUJUKAN_ID->EditValue = $this->RUJUKAN_ID->CurrentValue;
                    }
                }
            } else {
                $this->RUJUKAN_ID->EditValue = null;
            }
            $this->RUJUKAN_ID->ViewCustomAttributes = "";

            // ADDRESS_OF_RUJUKAN
            $this->ADDRESS_OF_RUJUKAN->EditAttrs["class"] = "form-control";
            $this->ADDRESS_OF_RUJUKAN->EditCustomAttributes = "";
            if (strval($this->ADDRESS_OF_RUJUKAN->CurrentValue) != "") {
                $this->ADDRESS_OF_RUJUKAN->EditValue = new OptionValues();
                $arwrk = explode(",", strval($this->ADDRESS_OF_RUJUKAN->CurrentValue));
                $cnt = count($arwrk);
                for ($ari = 0; $ari < $cnt; $ari++)
                    $this->ADDRESS_OF_RUJUKAN->EditValue->add($this->ADDRESS_OF_RUJUKAN->optionCaption(trim($arwrk[$ari])));
            } else {
                $this->ADDRESS_OF_RUJUKAN->EditValue = null;
            }
            $this->ADDRESS_OF_RUJUKAN->ViewCustomAttributes = "";

            // REASON_ID
            $this->REASON_ID->EditAttrs["class"] = "form-control";
            $this->REASON_ID->EditCustomAttributes = "";
            $curVal = trim(strval($this->REASON_ID->CurrentValue));
            if ($curVal != "") {
                $this->REASON_ID->EditValue = $this->REASON_ID->lookupCacheOption($curVal);
                if ($this->REASON_ID->EditValue === null) { // Lookup from database
                    $filterWrk = "[REASON_ID]" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->REASON_ID->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->REASON_ID->Lookup->renderViewRow($rswrk[0]);
                        $this->REASON_ID->EditValue = $this->REASON_ID->displayValue($arwrk);
                    } else {
                        $this->REASON_ID->EditValue = $this->REASON_ID->CurrentValue;
                    }
                }
            } else {
                $this->REASON_ID->EditValue = null;
            }
            $this->REASON_ID->ViewCustomAttributes = "";

            // WAY_ID
            $this->WAY_ID->EditAttrs["class"] = "form-control";
            $this->WAY_ID->EditCustomAttributes = "";
            $curVal = trim(strval($this->WAY_ID->CurrentValue));
            if ($curVal != "") {
                $this->WAY_ID->EditValue = $this->WAY_ID->lookupCacheOption($curVal);
                if ($this->WAY_ID->EditValue === null) { // Lookup from database
                    $filterWrk = "[WAY_ID]" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->WAY_ID->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->WAY_ID->Lookup->renderViewRow($rswrk[0]);
                        $this->WAY_ID->EditValue = $this->WAY_ID->displayValue($arwrk);
                    } else {
                        $this->WAY_ID->EditValue = $this->WAY_ID->CurrentValue;
                    }
                }
            } else {
                $this->WAY_ID->EditValue = null;
            }
            $this->WAY_ID->ViewCustomAttributes = "";

            // PATIENT_CATEGORY_ID
            $this->PATIENT_CATEGORY_ID->EditAttrs["class"] = "form-control";
            $this->PATIENT_CATEGORY_ID->EditCustomAttributes = "";
            $curVal = trim(strval($this->PATIENT_CATEGORY_ID->CurrentValue));
            if ($curVal != "") {
                $this->PATIENT_CATEGORY_ID->EditValue = $this->PATIENT_CATEGORY_ID->lookupCacheOption($curVal);
                if ($this->PATIENT_CATEGORY_ID->EditValue === null) { // Lookup from database
                    $filterWrk = "[PATIENT_CATEGORY_ID]" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->PATIENT_CATEGORY_ID->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->PATIENT_CATEGORY_ID->Lookup->renderViewRow($rswrk[0]);
                        $this->PATIENT_CATEGORY_ID->EditValue = $this->PATIENT_CATEGORY_ID->displayValue($arwrk);
                    } else {
                        $this->PATIENT_CATEGORY_ID->EditValue = $this->PATIENT_CATEGORY_ID->CurrentValue;
                    }
                }
            } else {
                $this->PATIENT_CATEGORY_ID->EditValue = null;
            }
            $this->PATIENT_CATEGORY_ID->ViewCustomAttributes = "";

            // BOOKED_DATE

            // VISIT_DATE
            $this->VISIT_DATE->EditAttrs["class"] = "form-control";
            $this->VISIT_DATE->EditCustomAttributes = "";
            $this->VISIT_DATE->EditValue = $this->VISIT_DATE->CurrentValue;
            $this->VISIT_DATE->EditValue = FormatDateTime($this->VISIT_DATE->EditValue, 11);
            $this->VISIT_DATE->ViewCustomAttributes = "";

            // ISNEW
            $this->ISNEW->EditAttrs["class"] = "form-control";
            $this->ISNEW->EditCustomAttributes = "";
            if (strval($this->ISNEW->CurrentValue) != "") {
                $this->ISNEW->EditValue = $this->ISNEW->optionCaption($this->ISNEW->CurrentValue);
            } else {
                $this->ISNEW->EditValue = null;
            }
            $this->ISNEW->ViewCustomAttributes = "";

            // FOLLOW_UP
            $this->FOLLOW_UP->EditAttrs["class"] = "form-control";
            $this->FOLLOW_UP->EditCustomAttributes = "";
            $this->FOLLOW_UP->EditValue = $this->FOLLOW_UP->CurrentValue;
            $this->FOLLOW_UP->EditValue = FormatNumber($this->FOLLOW_UP->EditValue, 0, -2, -2, -2);
            $this->FOLLOW_UP->ViewCustomAttributes = "";

            // PLACE_TYPE
            $this->PLACE_TYPE->EditAttrs["class"] = "form-control";
            $this->PLACE_TYPE->EditCustomAttributes = "";
            $this->PLACE_TYPE->EditValue = $this->PLACE_TYPE->CurrentValue;
            $this->PLACE_TYPE->EditValue = FormatNumber($this->PLACE_TYPE->EditValue, 0, -2, -2, -2);
            $this->PLACE_TYPE->ViewCustomAttributes = "";

            // CLINIC_ID
            $this->CLINIC_ID->EditAttrs["class"] = "form-control";
            $this->CLINIC_ID->EditCustomAttributes = "";
            $curVal = trim(strval($this->CLINIC_ID->CurrentValue));
            if ($curVal != "") {
                $this->CLINIC_ID->EditValue = $this->CLINIC_ID->lookupCacheOption($curVal);
                if ($this->CLINIC_ID->EditValue === null) { // Lookup from database
                    $filterWrk = "[CLINIC_ID]" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $lookupFilter = function() {
                        return "[STYPE_ID] = 1 OR [STYPE_ID] = 2 OR [STYPE_ID] = 3 OR [STYPE_ID] = 5";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    $sqlWrk = $this->CLINIC_ID->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
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

            // CLINIC_ID_FROM
            $this->CLINIC_ID_FROM->EditAttrs["class"] = "form-control";
            $this->CLINIC_ID_FROM->EditCustomAttributes = "";
            $curVal = trim(strval($this->CLINIC_ID_FROM->CurrentValue));
            if ($curVal != "") {
                $this->CLINIC_ID_FROM->EditValue = $this->CLINIC_ID_FROM->lookupCacheOption($curVal);
                if ($this->CLINIC_ID_FROM->EditValue === null) { // Lookup from database
                    $filterWrk = "[CLINIC_ID]" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->CLINIC_ID_FROM->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->CLINIC_ID_FROM->Lookup->renderViewRow($rswrk[0]);
                        $this->CLINIC_ID_FROM->EditValue = $this->CLINIC_ID_FROM->displayValue($arwrk);
                    } else {
                        $this->CLINIC_ID_FROM->EditValue = $this->CLINIC_ID_FROM->CurrentValue;
                    }
                }
            } else {
                $this->CLINIC_ID_FROM->EditValue = null;
            }
            $this->CLINIC_ID_FROM->ViewCustomAttributes = "";

            // CLASS_ROOM_ID
            $this->CLASS_ROOM_ID->EditAttrs["class"] = "form-control";
            $this->CLASS_ROOM_ID->EditCustomAttributes = "";
            $this->CLASS_ROOM_ID->EditValue = $this->CLASS_ROOM_ID->CurrentValue;
            $this->CLASS_ROOM_ID->ViewCustomAttributes = "";

            // BED_ID
            $this->BED_ID->EditAttrs["class"] = "form-control";
            $this->BED_ID->EditCustomAttributes = "";
            $this->BED_ID->EditValue = $this->BED_ID->CurrentValue;
            $this->BED_ID->EditValue = FormatNumber($this->BED_ID->EditValue, 0, -2, -2, -2);
            $this->BED_ID->ViewCustomAttributes = "";

            // KELUAR_ID
            $this->KELUAR_ID->EditAttrs["class"] = "form-control";
            $this->KELUAR_ID->EditCustomAttributes = "";
            $curVal = trim(strval($this->KELUAR_ID->CurrentValue));
            if ($curVal != "") {
                $this->KELUAR_ID->EditValue = $this->KELUAR_ID->lookupCacheOption($curVal);
                if ($this->KELUAR_ID->EditValue === null) { // Lookup from database
                    $filterWrk = "[KELUAR_ID]" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->KELUAR_ID->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->KELUAR_ID->Lookup->renderViewRow($rswrk[0]);
                        $this->KELUAR_ID->EditValue = $this->KELUAR_ID->displayValue($arwrk);
                    } else {
                        $this->KELUAR_ID->EditValue = $this->KELUAR_ID->CurrentValue;
                    }
                }
            } else {
                $this->KELUAR_ID->EditValue = null;
            }
            $this->KELUAR_ID->ViewCustomAttributes = "";

            // IN_DATE
            $this->IN_DATE->EditAttrs["class"] = "form-control";
            $this->IN_DATE->EditCustomAttributes = "";
            $this->IN_DATE->CurrentValue = FormatDateTime($this->IN_DATE->CurrentValue, 11);

            // EXIT_DATE
            $this->EXIT_DATE->EditAttrs["class"] = "form-control";
            $this->EXIT_DATE->EditCustomAttributes = "";
            $this->EXIT_DATE->EditValue = $this->EXIT_DATE->CurrentValue;
            $this->EXIT_DATE->EditValue = FormatDateTime($this->EXIT_DATE->EditValue, 11);
            $this->EXIT_DATE->ViewCustomAttributes = "";

            // GENDER
            $this->GENDER->EditAttrs["class"] = "form-control";
            $this->GENDER->EditCustomAttributes = "";
            $curVal = trim(strval($this->GENDER->CurrentValue));
            if ($curVal != "") {
                $this->GENDER->EditValue = $this->GENDER->lookupCacheOption($curVal);
                if ($this->GENDER->EditValue === null) { // Lookup from database
                    $filterWrk = "[GENDER]" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $lookupFilter = function() {
                        return "[GENDER] = 1 OR [GENDER] = 2";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    $sqlWrk = $this->GENDER->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
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

            // KODE_AGAMA
            $this->KODE_AGAMA->EditAttrs["class"] = "form-control";
            $this->KODE_AGAMA->EditCustomAttributes = "";
            $curVal = trim(strval($this->KODE_AGAMA->CurrentValue));
            if ($curVal != "") {
                $this->KODE_AGAMA->EditValue = $this->KODE_AGAMA->lookupCacheOption($curVal);
                if ($this->KODE_AGAMA->EditValue === null) { // Lookup from database
                    $filterWrk = "[KODE_AGAMA]" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->KODE_AGAMA->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->KODE_AGAMA->Lookup->renderViewRow($rswrk[0]);
                        $this->KODE_AGAMA->EditValue = $this->KODE_AGAMA->displayValue($arwrk);
                    } else {
                        $this->KODE_AGAMA->EditValue = $this->KODE_AGAMA->CurrentValue;
                    }
                }
            } else {
                $this->KODE_AGAMA->EditValue = null;
            }
            $this->KODE_AGAMA->ViewCustomAttributes = "";

            // DESCRIPTION
            $this->DESCRIPTION->EditAttrs["class"] = "form-control";
            $this->DESCRIPTION->EditCustomAttributes = "";
            $this->DESCRIPTION->EditValue = $this->DESCRIPTION->CurrentValue;
            $this->DESCRIPTION->ViewCustomAttributes = "";

            // VISITOR_ADDRESS
            $this->VISITOR_ADDRESS->EditAttrs["class"] = "form-control";
            $this->VISITOR_ADDRESS->EditCustomAttributes = "";
            $this->VISITOR_ADDRESS->EditValue = $this->VISITOR_ADDRESS->CurrentValue;
            $this->VISITOR_ADDRESS->ViewCustomAttributes = "";

            // MODIFIED_BY

            // MODIFIED_DATE

            // MODIFIED_FROM

            // EMPLOYEE_ID
            $this->EMPLOYEE_ID->EditAttrs["class"] = "form-control";
            $this->EMPLOYEE_ID->EditCustomAttributes = "";
            $curVal = trim(strval($this->EMPLOYEE_ID->CurrentValue));
            if ($curVal != "") {
                $this->EMPLOYEE_ID->EditValue = $this->EMPLOYEE_ID->lookupCacheOption($curVal);
                if ($this->EMPLOYEE_ID->EditValue === null) { // Lookup from database
                    $filterWrk = "[EMPLOYEE_ID]" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $lookupFilter = function() {
                        return "[OBJECT_CATEGORY_ID]= 20";
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

            // EMPLOYEE_ID_FROM
            $this->EMPLOYEE_ID_FROM->EditAttrs["class"] = "form-control";
            $this->EMPLOYEE_ID_FROM->EditCustomAttributes = "";
            $this->EMPLOYEE_ID_FROM->EditValue = $this->EMPLOYEE_ID_FROM->CurrentValue;
            $this->EMPLOYEE_ID_FROM->ViewCustomAttributes = "";

            // RESPONSIBLE_ID
            $this->RESPONSIBLE_ID->EditAttrs["class"] = "form-control";
            $this->RESPONSIBLE_ID->EditCustomAttributes = "";
            $curVal = trim(strval($this->RESPONSIBLE_ID->CurrentValue));
            if ($curVal != "") {
                $this->RESPONSIBLE_ID->EditValue = $this->RESPONSIBLE_ID->lookupCacheOption($curVal);
                if ($this->RESPONSIBLE_ID->EditValue === null) { // Lookup from database
                    $filterWrk = "[RESPONSIBLE_ID]" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->RESPONSIBLE_ID->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->RESPONSIBLE_ID->Lookup->renderViewRow($rswrk[0]);
                        $this->RESPONSIBLE_ID->EditValue = $this->RESPONSIBLE_ID->displayValue($arwrk);
                    } else {
                        $this->RESPONSIBLE_ID->EditValue = $this->RESPONSIBLE_ID->CurrentValue;
                    }
                }
            } else {
                $this->RESPONSIBLE_ID->EditValue = null;
            }
            $this->RESPONSIBLE_ID->ViewCustomAttributes = "";

            // RESPONSIBLE
            $this->RESPONSIBLE->EditAttrs["class"] = "form-control";
            $this->RESPONSIBLE->EditCustomAttributes = "";
            $this->RESPONSIBLE->EditValue = $this->RESPONSIBLE->CurrentValue;
            $this->RESPONSIBLE->ViewCustomAttributes = "";

            // FAMILY_STATUS_ID
            $this->FAMILY_STATUS_ID->EditAttrs["class"] = "form-control";
            $this->FAMILY_STATUS_ID->EditCustomAttributes = "";
            $this->FAMILY_STATUS_ID->EditValue = FormatNumber($this->FAMILY_STATUS_ID->EditValue, 0, -2, -2, -2);
            $this->FAMILY_STATUS_ID->ViewCustomAttributes = "";

            // TICKET_NO
            $this->TICKET_NO->EditAttrs["class"] = "form-control";
            $this->TICKET_NO->EditCustomAttributes = "";
            $this->TICKET_NO->EditValue = $this->TICKET_NO->CurrentValue;
            $this->TICKET_NO->EditValue = FormatNumber($this->TICKET_NO->EditValue, 0, -2, -2, -2);
            $this->TICKET_NO->ViewCustomAttributes = "";

            // ISATTENDED
            $this->ISATTENDED->EditAttrs["class"] = "form-control";
            $this->ISATTENDED->EditCustomAttributes = "";
            $this->ISATTENDED->EditValue = $this->ISATTENDED->CurrentValue;
            $this->ISATTENDED->ViewCustomAttributes = "";

            // PAYOR_ID
            $this->PAYOR_ID->EditAttrs["class"] = "form-control";
            $this->PAYOR_ID->EditCustomAttributes = "";
            $curVal = trim(strval($this->PAYOR_ID->CurrentValue));
            if ($curVal != "") {
                $this->PAYOR_ID->EditValue = $this->PAYOR_ID->lookupCacheOption($curVal);
                if ($this->PAYOR_ID->EditValue === null) { // Lookup from database
                    $filterWrk = "[PAYOR_ID]" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->PAYOR_ID->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->PAYOR_ID->Lookup->renderViewRow($rswrk[0]);
                        $this->PAYOR_ID->EditValue = $this->PAYOR_ID->displayValue($arwrk);
                    } else {
                        $this->PAYOR_ID->EditValue = $this->PAYOR_ID->CurrentValue;
                    }
                }
            } else {
                $this->PAYOR_ID->EditValue = null;
            }
            $this->PAYOR_ID->ViewCustomAttributes = "";

            // CLASS_ID
            $this->CLASS_ID->EditAttrs["class"] = "form-control";
            $this->CLASS_ID->EditCustomAttributes = "";
            $curVal = trim(strval($this->CLASS_ID->CurrentValue));
            if ($curVal != "") {
                $this->CLASS_ID->EditValue = $this->CLASS_ID->lookupCacheOption($curVal);
                if ($this->CLASS_ID->EditValue === null) { // Lookup from database
                    $filterWrk = "[CLASS_ID]" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->CLASS_ID->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->CLASS_ID->Lookup->renderViewRow($rswrk[0]);
                        $this->CLASS_ID->EditValue = $this->CLASS_ID->displayValue($arwrk);
                    } else {
                        $this->CLASS_ID->EditValue = $this->CLASS_ID->CurrentValue;
                    }
                }
            } else {
                $this->CLASS_ID->EditValue = null;
            }
            $this->CLASS_ID->ViewCustomAttributes = "";

            // ISPERTARIF
            $this->ISPERTARIF->EditAttrs["class"] = "form-control";
            $this->ISPERTARIF->EditCustomAttributes = "";
            $this->ISPERTARIF->EditValue = $this->ISPERTARIF->CurrentValue;
            $this->ISPERTARIF->ViewCustomAttributes = "";

            // KAL_ID
            $this->KAL_ID->EditAttrs["class"] = "form-control";
            $this->KAL_ID->EditCustomAttributes = "";
            $curVal = trim(strval($this->KAL_ID->CurrentValue));
            if ($curVal != "") {
                $this->KAL_ID->EditValue = $this->KAL_ID->lookupCacheOption($curVal);
                if ($this->KAL_ID->EditValue === null) { // Lookup from database
                    $filterWrk = "[KAL_ID]" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->KAL_ID->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->KAL_ID->Lookup->renderViewRow($rswrk[0]);
                        $this->KAL_ID->EditValue = $this->KAL_ID->displayValue($arwrk);
                    } else {
                        $this->KAL_ID->EditValue = $this->KAL_ID->CurrentValue;
                    }
                }
            } else {
                $this->KAL_ID->EditValue = null;
            }
            $this->KAL_ID->ViewCustomAttributes = "";

            // EMPLOYEE_INAP
            $this->EMPLOYEE_INAP->EditAttrs["class"] = "form-control";
            $this->EMPLOYEE_INAP->EditCustomAttributes = "";
            $this->EMPLOYEE_INAP->EditValue = $this->EMPLOYEE_INAP->CurrentValue;
            $this->EMPLOYEE_INAP->ViewCustomAttributes = "";

            // PASIEN_ID
            $this->PASIEN_ID->EditAttrs["class"] = "form-control";
            $this->PASIEN_ID->EditCustomAttributes = "";
            $this->PASIEN_ID->EditValue = $this->PASIEN_ID->CurrentValue;
            $this->PASIEN_ID->ViewCustomAttributes = "";

            // KARYAWAN
            $this->KARYAWAN->EditAttrs["class"] = "form-control";
            $this->KARYAWAN->EditCustomAttributes = "";
            $this->KARYAWAN->EditValue = $this->KARYAWAN->CurrentValue;
            $this->KARYAWAN->ViewCustomAttributes = "";

            // ACCOUNT_ID
            $this->ACCOUNT_ID->EditAttrs["class"] = "form-control";
            $this->ACCOUNT_ID->EditCustomAttributes = "";
            $this->ACCOUNT_ID->EditValue = $this->ACCOUNT_ID->CurrentValue;
            $this->ACCOUNT_ID->ViewCustomAttributes = "";

            // CLASS_ID_PLAFOND
            $this->CLASS_ID_PLAFOND->EditAttrs["class"] = "form-control";
            $this->CLASS_ID_PLAFOND->EditCustomAttributes = "";
            $this->CLASS_ID_PLAFOND->EditValue = $this->CLASS_ID_PLAFOND->CurrentValue;
            $this->CLASS_ID_PLAFOND->EditValue = FormatNumber($this->CLASS_ID_PLAFOND->EditValue, 0, -2, -2, -2);
            $this->CLASS_ID_PLAFOND->ViewCustomAttributes = "";

            // BACKCHARGE
            $this->BACKCHARGE->EditAttrs["class"] = "form-control";
            $this->BACKCHARGE->EditCustomAttributes = "";
            $this->BACKCHARGE->EditValue = $this->BACKCHARGE->CurrentValue;
            $this->BACKCHARGE->ViewCustomAttributes = "";

            // COVERAGE_ID
            $this->COVERAGE_ID->EditAttrs["class"] = "form-control";
            $this->COVERAGE_ID->EditCustomAttributes = "";
            $curVal = trim(strval($this->COVERAGE_ID->CurrentValue));
            if ($curVal != "") {
                $this->COVERAGE_ID->EditValue = $this->COVERAGE_ID->lookupCacheOption($curVal);
                if ($this->COVERAGE_ID->EditValue === null) { // Lookup from database
                    $filterWrk = "[COVERAGE_ID]" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->COVERAGE_ID->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->COVERAGE_ID->Lookup->renderViewRow($rswrk[0]);
                        $this->COVERAGE_ID->EditValue = $this->COVERAGE_ID->displayValue($arwrk);
                    } else {
                        $this->COVERAGE_ID->EditValue = $this->COVERAGE_ID->CurrentValue;
                    }
                }
            } else {
                $this->COVERAGE_ID->EditValue = null;
            }
            $this->COVERAGE_ID->ViewCustomAttributes = "";

            // AGEYEAR
            $this->AGEYEAR->EditAttrs["class"] = "form-control";
            $this->AGEYEAR->EditCustomAttributes = "";
            $this->AGEYEAR->EditValue = $this->AGEYEAR->CurrentValue;
            $this->AGEYEAR->EditValue = FormatNumber($this->AGEYEAR->EditValue, 0, -2, -2, -2);
            $this->AGEYEAR->ViewCustomAttributes = "";

            // AGEMONTH
            $this->AGEMONTH->EditAttrs["class"] = "form-control";
            $this->AGEMONTH->EditCustomAttributes = "";
            $this->AGEMONTH->EditValue = $this->AGEMONTH->CurrentValue;
            $this->AGEMONTH->EditValue = FormatNumber($this->AGEMONTH->EditValue, 0, -2, -2, -2);
            $this->AGEMONTH->ViewCustomAttributes = "";

            // AGEDAY
            $this->AGEDAY->EditAttrs["class"] = "form-control";
            $this->AGEDAY->EditCustomAttributes = "";
            $this->AGEDAY->EditValue = $this->AGEDAY->CurrentValue;
            $this->AGEDAY->EditValue = FormatNumber($this->AGEDAY->EditValue, 0, -2, -2, -2);
            $this->AGEDAY->ViewCustomAttributes = "";

            // RECOMENDATION
            $this->RECOMENDATION->EditAttrs["class"] = "form-control";
            $this->RECOMENDATION->EditCustomAttributes = "";
            $this->RECOMENDATION->EditValue = $this->RECOMENDATION->CurrentValue;
            $this->RECOMENDATION->ViewCustomAttributes = "";

            // CONCLUSION
            $this->CONCLUSION->EditAttrs["class"] = "form-control";
            $this->CONCLUSION->EditCustomAttributes = "";
            $this->CONCLUSION->EditValue = $this->CONCLUSION->CurrentValue;
            $this->CONCLUSION->ViewCustomAttributes = "";

            // SPECIMENNO
            $this->SPECIMENNO->EditAttrs["class"] = "form-control";
            $this->SPECIMENNO->EditCustomAttributes = "";
            $this->SPECIMENNO->EditValue = $this->SPECIMENNO->CurrentValue;
            $this->SPECIMENNO->ViewCustomAttributes = "";

            // LOCKED
            $this->LOCKED->EditAttrs["class"] = "form-control";
            $this->LOCKED->EditCustomAttributes = "";
            $this->LOCKED->EditValue = $this->LOCKED->CurrentValue;
            $this->LOCKED->ViewCustomAttributes = "";

            // RM_OUT_DATE
            $this->RM_OUT_DATE->EditAttrs["class"] = "form-control";
            $this->RM_OUT_DATE->EditCustomAttributes = "";
            $this->RM_OUT_DATE->EditValue = $this->RM_OUT_DATE->CurrentValue;
            $this->RM_OUT_DATE->EditValue = FormatDateTime($this->RM_OUT_DATE->EditValue, 0);
            $this->RM_OUT_DATE->ViewCustomAttributes = "";

            // RM_IN_DATE
            $this->RM_IN_DATE->EditAttrs["class"] = "form-control";
            $this->RM_IN_DATE->EditCustomAttributes = "";
            $this->RM_IN_DATE->EditValue = $this->RM_IN_DATE->CurrentValue;
            $this->RM_IN_DATE->EditValue = FormatDateTime($this->RM_IN_DATE->EditValue, 0);
            $this->RM_IN_DATE->ViewCustomAttributes = "";

            // LAMA_PINJAM
            $this->LAMA_PINJAM->EditAttrs["class"] = "form-control";
            $this->LAMA_PINJAM->EditCustomAttributes = "";
            $this->LAMA_PINJAM->EditValue = $this->LAMA_PINJAM->CurrentValue;
            $this->LAMA_PINJAM->EditValue = FormatDateTime($this->LAMA_PINJAM->EditValue, 0);
            $this->LAMA_PINJAM->ViewCustomAttributes = "";

            // STANDAR_RJ
            $this->STANDAR_RJ->EditAttrs["class"] = "form-control";
            $this->STANDAR_RJ->EditCustomAttributes = "";
            $this->STANDAR_RJ->EditValue = $this->STANDAR_RJ->CurrentValue;
            $this->STANDAR_RJ->ViewCustomAttributes = "";

            // LENGKAP_RJ
            $this->LENGKAP_RJ->EditAttrs["class"] = "form-control";
            $this->LENGKAP_RJ->EditCustomAttributes = "";
            $this->LENGKAP_RJ->EditValue = $this->LENGKAP_RJ->CurrentValue;
            $this->LENGKAP_RJ->ViewCustomAttributes = "";

            // LENGKAP_RI
            $this->LENGKAP_RI->EditAttrs["class"] = "form-control";
            $this->LENGKAP_RI->EditCustomAttributes = "";
            $this->LENGKAP_RI->EditValue = $this->LENGKAP_RI->CurrentValue;
            $this->LENGKAP_RI->ViewCustomAttributes = "";

            // RESEND_RM_DATE
            $this->RESEND_RM_DATE->EditAttrs["class"] = "form-control";
            $this->RESEND_RM_DATE->EditCustomAttributes = "";
            $this->RESEND_RM_DATE->EditValue = $this->RESEND_RM_DATE->CurrentValue;
            $this->RESEND_RM_DATE->EditValue = FormatDateTime($this->RESEND_RM_DATE->EditValue, 0);
            $this->RESEND_RM_DATE->ViewCustomAttributes = "";

            // LENGKAP_RM1
            $this->LENGKAP_RM1->EditAttrs["class"] = "form-control";
            $this->LENGKAP_RM1->EditCustomAttributes = "";
            $this->LENGKAP_RM1->EditValue = $this->LENGKAP_RM1->CurrentValue;
            $this->LENGKAP_RM1->ViewCustomAttributes = "";

            // LENGKAP_RESUME
            $this->LENGKAP_RESUME->EditAttrs["class"] = "form-control";
            $this->LENGKAP_RESUME->EditCustomAttributes = "";
            $this->LENGKAP_RESUME->EditValue = $this->LENGKAP_RESUME->CurrentValue;
            $this->LENGKAP_RESUME->ViewCustomAttributes = "";

            // LENGKAP_ANAMNESIS
            $this->LENGKAP_ANAMNESIS->EditAttrs["class"] = "form-control";
            $this->LENGKAP_ANAMNESIS->EditCustomAttributes = "";
            $this->LENGKAP_ANAMNESIS->EditValue = $this->LENGKAP_ANAMNESIS->CurrentValue;
            $this->LENGKAP_ANAMNESIS->ViewCustomAttributes = "";

            // LENGKAP_CONSENT
            $this->LENGKAP_CONSENT->EditAttrs["class"] = "form-control";
            $this->LENGKAP_CONSENT->EditCustomAttributes = "";
            $this->LENGKAP_CONSENT->EditValue = $this->LENGKAP_CONSENT->CurrentValue;
            $this->LENGKAP_CONSENT->ViewCustomAttributes = "";

            // LENGKAP_ANESTESI
            $this->LENGKAP_ANESTESI->EditAttrs["class"] = "form-control";
            $this->LENGKAP_ANESTESI->EditCustomAttributes = "";
            $this->LENGKAP_ANESTESI->EditValue = $this->LENGKAP_ANESTESI->CurrentValue;
            $this->LENGKAP_ANESTESI->ViewCustomAttributes = "";

            // LENGKAP_OP
            $this->LENGKAP_OP->EditAttrs["class"] = "form-control";
            $this->LENGKAP_OP->EditCustomAttributes = "";
            $this->LENGKAP_OP->EditValue = $this->LENGKAP_OP->CurrentValue;
            $this->LENGKAP_OP->ViewCustomAttributes = "";

            // BACK_RM_DATE
            $this->BACK_RM_DATE->EditAttrs["class"] = "form-control";
            $this->BACK_RM_DATE->EditCustomAttributes = "";
            $this->BACK_RM_DATE->EditValue = $this->BACK_RM_DATE->CurrentValue;
            $this->BACK_RM_DATE->EditValue = FormatDateTime($this->BACK_RM_DATE->EditValue, 0);
            $this->BACK_RM_DATE->ViewCustomAttributes = "";

            // VALID_RM_DATE
            $this->VALID_RM_DATE->EditAttrs["class"] = "form-control";
            $this->VALID_RM_DATE->EditCustomAttributes = "";
            $this->VALID_RM_DATE->EditValue = $this->VALID_RM_DATE->CurrentValue;
            $this->VALID_RM_DATE->EditValue = FormatDateTime($this->VALID_RM_DATE->EditValue, 0);
            $this->VALID_RM_DATE->ViewCustomAttributes = "";

            // NO_SKP
            $this->NO_SKP->EditAttrs["class"] = "form-control";
            $this->NO_SKP->EditCustomAttributes = "";
            $this->NO_SKP->EditValue = $this->NO_SKP->CurrentValue;
            $this->NO_SKP->ViewCustomAttributes = "";

            // NO_SKPINAP
            $this->NO_SKPINAP->EditAttrs["class"] = "form-control";
            $this->NO_SKPINAP->EditCustomAttributes = "";
            $this->NO_SKPINAP->EditValue = $this->NO_SKPINAP->CurrentValue;
            $this->NO_SKPINAP->ViewCustomAttributes = "";

            // DIAGNOSA_ID
            $this->DIAGNOSA_ID->EditAttrs["class"] = "form-control";
            $this->DIAGNOSA_ID->EditCustomAttributes = "";
            $curVal = trim(strval($this->DIAGNOSA_ID->CurrentValue));
            if ($curVal != "") {
                $this->DIAGNOSA_ID->EditValue = $this->DIAGNOSA_ID->lookupCacheOption($curVal);
                if ($this->DIAGNOSA_ID->EditValue === null) { // Lookup from database
                    $filterWrk = "[DIAGNOSA_ID]" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->DIAGNOSA_ID->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->DIAGNOSA_ID->Lookup->renderViewRow($rswrk[0]);
                        $this->DIAGNOSA_ID->EditValue = $this->DIAGNOSA_ID->displayValue($arwrk);
                    } else {
                        $this->DIAGNOSA_ID->EditValue = $this->DIAGNOSA_ID->CurrentValue;
                    }
                }
            } else {
                $this->DIAGNOSA_ID->EditValue = null;
            }
            $this->DIAGNOSA_ID->ViewCustomAttributes = "";

            // ticket_all
            $this->ticket_all->EditAttrs["class"] = "form-control";
            $this->ticket_all->EditCustomAttributes = "";
            $this->ticket_all->EditValue = $this->ticket_all->CurrentValue;
            $this->ticket_all->EditValue = FormatNumber($this->ticket_all->EditValue, 0, -2, -2, -2);
            $this->ticket_all->ViewCustomAttributes = "";

            // tanggal_rujukan
            $this->tanggal_rujukan->EditAttrs["class"] = "form-control";
            $this->tanggal_rujukan->EditCustomAttributes = "";
            $this->tanggal_rujukan->EditValue = $this->tanggal_rujukan->CurrentValue;
            $this->tanggal_rujukan->EditValue = FormatDateTime($this->tanggal_rujukan->EditValue, 0);
            $this->tanggal_rujukan->ViewCustomAttributes = "";

            // ISRJ
            $this->ISRJ->EditAttrs["class"] = "form-control";
            $this->ISRJ->EditCustomAttributes = "";
            $curVal = trim(strval($this->ISRJ->CurrentValue));
            if ($curVal != "") {
                $this->ISRJ->EditValue = $this->ISRJ->lookupCacheOption($curVal);
                if ($this->ISRJ->EditValue === null) { // Lookup from database
                    $filterWrk = "[KELUAR_ID]" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->ISRJ->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->ISRJ->Lookup->renderViewRow($rswrk[0]);
                        $this->ISRJ->EditValue = $this->ISRJ->displayValue($arwrk);
                    } else {
                        $this->ISRJ->EditValue = $this->ISRJ->CurrentValue;
                    }
                }
            } else {
                $this->ISRJ->EditValue = null;
            }
            $this->ISRJ->ViewCustomAttributes = "";

            // NORUJUKAN
            $this->NORUJUKAN->EditAttrs["class"] = "form-control";
            $this->NORUJUKAN->EditCustomAttributes = "";
            $this->NORUJUKAN->EditValue = $this->NORUJUKAN->CurrentValue;
            $this->NORUJUKAN->ViewCustomAttributes = "";

            // PPKRUJUKAN
            $this->PPKRUJUKAN->EditAttrs["class"] = "form-control";
            $this->PPKRUJUKAN->EditCustomAttributes = "";
            $curVal = trim(strval($this->PPKRUJUKAN->CurrentValue));
            if ($curVal != "") {
                $this->PPKRUJUKAN->EditValue = $this->PPKRUJUKAN->lookupCacheOption($curVal);
                if ($this->PPKRUJUKAN->EditValue === null) { // Lookup from database
                    $filterWrk = "[KDPROVIDER]" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->PPKRUJUKAN->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->PPKRUJUKAN->Lookup->renderViewRow($rswrk[0]);
                        $this->PPKRUJUKAN->EditValue = $this->PPKRUJUKAN->displayValue($arwrk);
                    } else {
                        $this->PPKRUJUKAN->EditValue = $this->PPKRUJUKAN->CurrentValue;
                    }
                }
            } else {
                $this->PPKRUJUKAN->EditValue = null;
            }
            $this->PPKRUJUKAN->ViewCustomAttributes = "";

            // LOKASILAKA
            $this->LOKASILAKA->EditAttrs["class"] = "form-control";
            $this->LOKASILAKA->EditCustomAttributes = "";
            $this->LOKASILAKA->EditValue = $this->LOKASILAKA->CurrentValue;
            $this->LOKASILAKA->ViewCustomAttributes = "";

            // KDPOLI
            $this->KDPOLI->EditAttrs["class"] = "form-control";
            $this->KDPOLI->EditCustomAttributes = "";
            $this->KDPOLI->EditValue = $this->KDPOLI->CurrentValue;
            $this->KDPOLI->ViewCustomAttributes = "";

            // EDIT_SEP
            $this->EDIT_SEP->EditAttrs["class"] = "form-control";
            $this->EDIT_SEP->EditCustomAttributes = "";
            $this->EDIT_SEP->EditValue = $this->EDIT_SEP->CurrentValue;
            $this->EDIT_SEP->ViewCustomAttributes = "";

            // DELETE_SEP
            $this->DELETE_SEP->EditAttrs["class"] = "form-control";
            $this->DELETE_SEP->EditCustomAttributes = "";
            $this->DELETE_SEP->EditValue = $this->DELETE_SEP->CurrentValue;
            $this->DELETE_SEP->ViewCustomAttributes = "";

            // DIAG_AWAL
            $this->DIAG_AWAL->EditAttrs["class"] = "form-control";
            $this->DIAG_AWAL->EditCustomAttributes = "";
            $this->DIAG_AWAL->EditValue = $this->DIAG_AWAL->CurrentValue;
            $this->DIAG_AWAL->ViewCustomAttributes = "";

            // AKTIF
            $this->AKTIF->EditAttrs["class"] = "form-control";
            $this->AKTIF->EditCustomAttributes = "";
            $this->AKTIF->EditValue = $this->AKTIF->CurrentValue;
            $this->AKTIF->ViewCustomAttributes = "";

            // BILL_INAP
            $this->BILL_INAP->EditAttrs["class"] = "form-control";
            $this->BILL_INAP->EditCustomAttributes = "";
            $this->BILL_INAP->EditValue = $this->BILL_INAP->CurrentValue;
            $this->BILL_INAP->ViewCustomAttributes = "";

            // SEP_PRINTDATE
            $this->SEP_PRINTDATE->EditAttrs["class"] = "form-control";
            $this->SEP_PRINTDATE->EditCustomAttributes = "";
            $this->SEP_PRINTDATE->EditValue = $this->SEP_PRINTDATE->CurrentValue;
            $this->SEP_PRINTDATE->EditValue = FormatDateTime($this->SEP_PRINTDATE->EditValue, 11);
            $this->SEP_PRINTDATE->ViewCustomAttributes = "";

            // MAPPING_SEP
            $this->MAPPING_SEP->EditAttrs["class"] = "form-control";
            $this->MAPPING_SEP->EditCustomAttributes = "";
            $this->MAPPING_SEP->EditValue = $this->MAPPING_SEP->CurrentValue;
            $this->MAPPING_SEP->ViewCustomAttributes = "";

            // TRANS_ID
            $this->TRANS_ID->EditAttrs["class"] = "form-control";
            $this->TRANS_ID->EditCustomAttributes = "";
            $this->TRANS_ID->EditValue = $this->TRANS_ID->CurrentValue;
            $this->TRANS_ID->ViewCustomAttributes = "";

            // KDPOLI_EKS
            $this->KDPOLI_EKS->EditAttrs["class"] = "form-control";
            $this->KDPOLI_EKS->EditCustomAttributes = "";
            $this->KDPOLI_EKS->EditValue = $this->KDPOLI_EKS->CurrentValue;
            $this->KDPOLI_EKS->ViewCustomAttributes = "";

            // COB
            $this->COB->EditAttrs["class"] = "form-control";
            $this->COB->EditCustomAttributes = "";
            if (strval($this->COB->CurrentValue) != "") {
                $this->COB->EditValue = new OptionValues();
                $arwrk = explode(",", strval($this->COB->CurrentValue));
                $cnt = count($arwrk);
                for ($ari = 0; $ari < $cnt; $ari++)
                    $this->COB->EditValue->add($this->COB->optionCaption(trim($arwrk[$ari])));
            } else {
                $this->COB->EditValue = null;
            }
            $this->COB->ViewCustomAttributes = "";

            // PENJAMIN
            $this->PENJAMIN->EditAttrs["class"] = "form-control";
            $this->PENJAMIN->EditCustomAttributes = "";
            $this->PENJAMIN->EditValue = $this->PENJAMIN->CurrentValue;
            $this->PENJAMIN->ViewCustomAttributes = "";

            // ASALRUJUKAN
            $this->ASALRUJUKAN->EditAttrs["class"] = "form-control";
            $this->ASALRUJUKAN->EditCustomAttributes = "";
            $this->ASALRUJUKAN->EditValue = $this->ASALRUJUKAN->CurrentValue;
            $this->ASALRUJUKAN->ViewCustomAttributes = "";

            // RESPONSEP
            $this->RESPONSEP->EditAttrs["class"] = "form-control";
            $this->RESPONSEP->EditCustomAttributes = "";
            $this->RESPONSEP->EditValue = $this->RESPONSEP->CurrentValue;
            $this->RESPONSEP->ViewCustomAttributes = "";

            // APPROVAL_DESC
            $this->APPROVAL_DESC->EditAttrs["class"] = "form-control";
            $this->APPROVAL_DESC->EditCustomAttributes = "";
            $this->APPROVAL_DESC->EditValue = $this->APPROVAL_DESC->CurrentValue;
            $this->APPROVAL_DESC->ViewCustomAttributes = "";

            // APPROVAL_RESPONAJUKAN
            $this->APPROVAL_RESPONAJUKAN->EditAttrs["class"] = "form-control";
            $this->APPROVAL_RESPONAJUKAN->EditCustomAttributes = "";
            $this->APPROVAL_RESPONAJUKAN->EditValue = $this->APPROVAL_RESPONAJUKAN->CurrentValue;
            $this->APPROVAL_RESPONAJUKAN->ViewCustomAttributes = "";

            // APPROVAL_RESPONAPPROV
            $this->APPROVAL_RESPONAPPROV->EditAttrs["class"] = "form-control";
            $this->APPROVAL_RESPONAPPROV->EditCustomAttributes = "";
            $this->APPROVAL_RESPONAPPROV->EditValue = $this->APPROVAL_RESPONAPPROV->CurrentValue;
            $this->APPROVAL_RESPONAPPROV->ViewCustomAttributes = "";

            // RESPONTGLPLG_DESC
            $this->RESPONTGLPLG_DESC->EditAttrs["class"] = "form-control";
            $this->RESPONTGLPLG_DESC->EditCustomAttributes = "";
            $this->RESPONTGLPLG_DESC->EditValue = $this->RESPONTGLPLG_DESC->CurrentValue;
            $this->RESPONTGLPLG_DESC->ViewCustomAttributes = "";

            // RESPONPOST_VKLAIM
            $this->RESPONPOST_VKLAIM->EditAttrs["class"] = "form-control";
            $this->RESPONPOST_VKLAIM->EditCustomAttributes = "";
            $this->RESPONPOST_VKLAIM->EditValue = $this->RESPONPOST_VKLAIM->CurrentValue;
            $this->RESPONPOST_VKLAIM->ViewCustomAttributes = "";

            // RESPONPUT_VKLAIM
            $this->RESPONPUT_VKLAIM->EditAttrs["class"] = "form-control";
            $this->RESPONPUT_VKLAIM->EditCustomAttributes = "";
            $this->RESPONPUT_VKLAIM->EditValue = $this->RESPONPUT_VKLAIM->CurrentValue;
            $this->RESPONPUT_VKLAIM->ViewCustomAttributes = "";

            // RESPONDEL_VKLAIM
            $this->RESPONDEL_VKLAIM->EditAttrs["class"] = "form-control";
            $this->RESPONDEL_VKLAIM->EditCustomAttributes = "";
            $this->RESPONDEL_VKLAIM->EditValue = $this->RESPONDEL_VKLAIM->CurrentValue;
            $this->RESPONDEL_VKLAIM->ViewCustomAttributes = "";

            // CALL_TIMES
            $this->CALL_TIMES->EditAttrs["class"] = "form-control";
            $this->CALL_TIMES->EditCustomAttributes = "";
            $this->CALL_TIMES->EditValue = $this->CALL_TIMES->CurrentValue;
            $this->CALL_TIMES->EditValue = FormatNumber($this->CALL_TIMES->EditValue, 0, -2, -2, -2);
            $this->CALL_TIMES->ViewCustomAttributes = "";

            // CALL_DATE
            $this->CALL_DATE->EditAttrs["class"] = "form-control";
            $this->CALL_DATE->EditCustomAttributes = "";
            $this->CALL_DATE->EditValue = $this->CALL_DATE->CurrentValue;
            $this->CALL_DATE->EditValue = FormatDateTime($this->CALL_DATE->EditValue, 11);
            $this->CALL_DATE->ViewCustomAttributes = "";

            // CALL_DATES
            $this->CALL_DATES->EditAttrs["class"] = "form-control";
            $this->CALL_DATES->EditCustomAttributes = "";
            $this->CALL_DATES->EditValue = $this->CALL_DATES->CurrentValue;
            $this->CALL_DATES->EditValue = FormatDateTime($this->CALL_DATES->EditValue, 11);
            $this->CALL_DATES->ViewCustomAttributes = "";

            // SERVED_DATE
            $this->SERVED_DATE->EditAttrs["class"] = "form-control";
            $this->SERVED_DATE->EditCustomAttributes = "";
            $this->SERVED_DATE->EditValue = $this->SERVED_DATE->CurrentValue;
            $this->SERVED_DATE->EditValue = FormatDateTime($this->SERVED_DATE->EditValue, 11);
            $this->SERVED_DATE->ViewCustomAttributes = "";

            // SERVED_INAP
            $this->SERVED_INAP->EditAttrs["class"] = "form-control";
            $this->SERVED_INAP->EditCustomAttributes = "";
            $this->SERVED_INAP->EditValue = $this->SERVED_INAP->CurrentValue;
            $this->SERVED_INAP->EditValue = FormatDateTime($this->SERVED_INAP->EditValue, 11);
            $this->SERVED_INAP->ViewCustomAttributes = "";

            // KDDPJP1
            $this->KDDPJP1->EditAttrs["class"] = "form-control";
            $this->KDDPJP1->EditCustomAttributes = "";
            $this->KDDPJP1->EditValue = $this->KDDPJP1->CurrentValue;
            $this->KDDPJP1->ViewCustomAttributes = "";

            // KDDPJP
            $this->KDDPJP->EditAttrs["class"] = "form-control";
            $this->KDDPJP->EditCustomAttributes = "";
            $this->KDDPJP->EditValue = $this->KDDPJP->CurrentValue;
            $this->KDDPJP->ViewCustomAttributes = "";

            // SEP
            $this->SEP->EditAttrs["class"] = "form-control";
            $this->SEP->EditCustomAttributes = "";
            if (!$this->SEP->Raw) {
                $this->SEP->CurrentValue = HtmlDecode($this->SEP->CurrentValue);
            }
            $this->SEP->EditValue = HtmlEncode($this->SEP->CurrentValue);
            $this->SEP->PlaceHolder = RemoveHtml($this->SEP->caption());

            // Edit refer script

            // ORG_UNIT_CODE
            $this->ORG_UNIT_CODE->LinkCustomAttributes = "";
            $this->ORG_UNIT_CODE->HrefValue = "";
            $this->ORG_UNIT_CODE->TooltipValue = "";

            // VISIT_ID
            $this->VISIT_ID->LinkCustomAttributes = "";
            $this->VISIT_ID->HrefValue = "";
            $this->VISIT_ID->TooltipValue = "";

            // NO_REGISTRATION
            $this->NO_REGISTRATION->LinkCustomAttributes = "";
            $this->NO_REGISTRATION->HrefValue = "";
            $this->NO_REGISTRATION->TooltipValue = "";

            // DIANTAR_OLEH
            $this->DIANTAR_OLEH->LinkCustomAttributes = "";
            $this->DIANTAR_OLEH->HrefValue = "";
            $this->DIANTAR_OLEH->TooltipValue = "";

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

            // GENDER
            $this->GENDER->LinkCustomAttributes = "";
            $this->GENDER->HrefValue = "";
            $this->GENDER->TooltipValue = "";

            // KODE_AGAMA
            $this->KODE_AGAMA->LinkCustomAttributes = "";
            $this->KODE_AGAMA->HrefValue = "";
            $this->KODE_AGAMA->TooltipValue = "";

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

            // SEP
            $this->SEP->LinkCustomAttributes = "";
            $this->SEP->HrefValue = "";
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
        $updateCnt = 0;
        if ($this->ORG_UNIT_CODE->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->VISIT_ID->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->NO_REGISTRATION->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->DIANTAR_OLEH->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->STATUS_PASIEN_ID->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->RUJUKAN_ID->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->ADDRESS_OF_RUJUKAN->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->REASON_ID->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->WAY_ID->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->PATIENT_CATEGORY_ID->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->BOOKED_DATE->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->VISIT_DATE->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->ISNEW->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->FOLLOW_UP->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->PLACE_TYPE->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->CLINIC_ID->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->CLINIC_ID_FROM->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->CLASS_ROOM_ID->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->BED_ID->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->KELUAR_ID->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->IN_DATE->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->EXIT_DATE->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->GENDER->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->KODE_AGAMA->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->DESCRIPTION->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->VISITOR_ADDRESS->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->MODIFIED_BY->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->MODIFIED_DATE->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->MODIFIED_FROM->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->EMPLOYEE_ID->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->EMPLOYEE_ID_FROM->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->RESPONSIBLE_ID->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->RESPONSIBLE->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->FAMILY_STATUS_ID->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->TICKET_NO->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->ISATTENDED->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->PAYOR_ID->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->CLASS_ID->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->ISPERTARIF->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->KAL_ID->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->EMPLOYEE_INAP->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->PASIEN_ID->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->KARYAWAN->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->ACCOUNT_ID->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->CLASS_ID_PLAFOND->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->BACKCHARGE->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->COVERAGE_ID->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->AGEYEAR->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->AGEMONTH->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->AGEDAY->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->RECOMENDATION->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->CONCLUSION->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->SPECIMENNO->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->LOCKED->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->RM_OUT_DATE->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->RM_IN_DATE->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->LAMA_PINJAM->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->STANDAR_RJ->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->LENGKAP_RJ->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->LENGKAP_RI->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->RESEND_RM_DATE->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->LENGKAP_RM1->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->LENGKAP_RESUME->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->LENGKAP_ANAMNESIS->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->LENGKAP_CONSENT->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->LENGKAP_ANESTESI->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->LENGKAP_OP->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->BACK_RM_DATE->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->VALID_RM_DATE->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->NO_SKP->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->NO_SKPINAP->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->DIAGNOSA_ID->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->ticket_all->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->tanggal_rujukan->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->ISRJ->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->NORUJUKAN->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->PPKRUJUKAN->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->LOKASILAKA->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->KDPOLI->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->EDIT_SEP->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->DELETE_SEP->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->DIAG_AWAL->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->AKTIF->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->BILL_INAP->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->SEP_PRINTDATE->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->MAPPING_SEP->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->TRANS_ID->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->KDPOLI_EKS->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->COB->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->PENJAMIN->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->ASALRUJUKAN->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->RESPONSEP->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->APPROVAL_DESC->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->APPROVAL_RESPONAJUKAN->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->APPROVAL_RESPONAPPROV->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->RESPONTGLPLG_DESC->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->RESPONPOST_VKLAIM->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->RESPONPUT_VKLAIM->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->RESPONDEL_VKLAIM->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->CALL_TIMES->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->CALL_DATE->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->CALL_DATES->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->SERVED_DATE->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->SERVED_INAP->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->KDDPJP1->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->KDDPJP->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($this->SEP->multiUpdateSelected()) {
            $updateCnt++;
        }
        if ($updateCnt == 0) {
            return false;
        }

        // Check if validation required
        if (!Config("SERVER_VALIDATE")) {
            return true;
        }
        if ($this->ORG_UNIT_CODE->Required) {
            if ($this->ORG_UNIT_CODE->MultiUpdate != "" && !$this->ORG_UNIT_CODE->IsDetailKey && EmptyValue($this->ORG_UNIT_CODE->FormValue)) {
                $this->ORG_UNIT_CODE->addErrorMessage(str_replace("%s", $this->ORG_UNIT_CODE->caption(), $this->ORG_UNIT_CODE->RequiredErrorMessage));
            }
        }
        if ($this->VISIT_ID->Required) {
            if ($this->VISIT_ID->MultiUpdate != "" && !$this->VISIT_ID->IsDetailKey && EmptyValue($this->VISIT_ID->FormValue)) {
                $this->VISIT_ID->addErrorMessage(str_replace("%s", $this->VISIT_ID->caption(), $this->VISIT_ID->RequiredErrorMessage));
            }
        }
        if ($this->NO_REGISTRATION->Required) {
            if ($this->NO_REGISTRATION->MultiUpdate != "" && !$this->NO_REGISTRATION->IsDetailKey && EmptyValue($this->NO_REGISTRATION->FormValue)) {
                $this->NO_REGISTRATION->addErrorMessage(str_replace("%s", $this->NO_REGISTRATION->caption(), $this->NO_REGISTRATION->RequiredErrorMessage));
            }
        }
        if ($this->DIANTAR_OLEH->Required) {
            if ($this->DIANTAR_OLEH->MultiUpdate != "" && !$this->DIANTAR_OLEH->IsDetailKey && EmptyValue($this->DIANTAR_OLEH->FormValue)) {
                $this->DIANTAR_OLEH->addErrorMessage(str_replace("%s", $this->DIANTAR_OLEH->caption(), $this->DIANTAR_OLEH->RequiredErrorMessage));
            }
        }
        if ($this->STATUS_PASIEN_ID->Required) {
            if ($this->STATUS_PASIEN_ID->MultiUpdate != "" && !$this->STATUS_PASIEN_ID->IsDetailKey && EmptyValue($this->STATUS_PASIEN_ID->FormValue)) {
                $this->STATUS_PASIEN_ID->addErrorMessage(str_replace("%s", $this->STATUS_PASIEN_ID->caption(), $this->STATUS_PASIEN_ID->RequiredErrorMessage));
            }
        }
        if ($this->RUJUKAN_ID->Required) {
            if ($this->RUJUKAN_ID->MultiUpdate != "" && !$this->RUJUKAN_ID->IsDetailKey && EmptyValue($this->RUJUKAN_ID->FormValue)) {
                $this->RUJUKAN_ID->addErrorMessage(str_replace("%s", $this->RUJUKAN_ID->caption(), $this->RUJUKAN_ID->RequiredErrorMessage));
            }
        }
        if ($this->ADDRESS_OF_RUJUKAN->Required) {
            if ($this->ADDRESS_OF_RUJUKAN->MultiUpdate != "" && $this->ADDRESS_OF_RUJUKAN->FormValue == "") {
                $this->ADDRESS_OF_RUJUKAN->addErrorMessage(str_replace("%s", $this->ADDRESS_OF_RUJUKAN->caption(), $this->ADDRESS_OF_RUJUKAN->RequiredErrorMessage));
            }
        }
        if ($this->REASON_ID->Required) {
            if ($this->REASON_ID->MultiUpdate != "" && !$this->REASON_ID->IsDetailKey && EmptyValue($this->REASON_ID->FormValue)) {
                $this->REASON_ID->addErrorMessage(str_replace("%s", $this->REASON_ID->caption(), $this->REASON_ID->RequiredErrorMessage));
            }
        }
        if ($this->WAY_ID->Required) {
            if ($this->WAY_ID->MultiUpdate != "" && !$this->WAY_ID->IsDetailKey && EmptyValue($this->WAY_ID->FormValue)) {
                $this->WAY_ID->addErrorMessage(str_replace("%s", $this->WAY_ID->caption(), $this->WAY_ID->RequiredErrorMessage));
            }
        }
        if ($this->PATIENT_CATEGORY_ID->Required) {
            if ($this->PATIENT_CATEGORY_ID->MultiUpdate != "" && !$this->PATIENT_CATEGORY_ID->IsDetailKey && EmptyValue($this->PATIENT_CATEGORY_ID->FormValue)) {
                $this->PATIENT_CATEGORY_ID->addErrorMessage(str_replace("%s", $this->PATIENT_CATEGORY_ID->caption(), $this->PATIENT_CATEGORY_ID->RequiredErrorMessage));
            }
        }
        if ($this->BOOKED_DATE->Required) {
            if ($this->BOOKED_DATE->MultiUpdate != "" && !$this->BOOKED_DATE->IsDetailKey && EmptyValue($this->BOOKED_DATE->FormValue)) {
                $this->BOOKED_DATE->addErrorMessage(str_replace("%s", $this->BOOKED_DATE->caption(), $this->BOOKED_DATE->RequiredErrorMessage));
            }
        }
        if ($this->VISIT_DATE->Required) {
            if ($this->VISIT_DATE->MultiUpdate != "" && !$this->VISIT_DATE->IsDetailKey && EmptyValue($this->VISIT_DATE->FormValue)) {
                $this->VISIT_DATE->addErrorMessage(str_replace("%s", $this->VISIT_DATE->caption(), $this->VISIT_DATE->RequiredErrorMessage));
            }
        }
        if ($this->ISNEW->Required) {
            if ($this->ISNEW->MultiUpdate != "" && $this->ISNEW->FormValue == "") {
                $this->ISNEW->addErrorMessage(str_replace("%s", $this->ISNEW->caption(), $this->ISNEW->RequiredErrorMessage));
            }
        }
        if ($this->FOLLOW_UP->Required) {
            if ($this->FOLLOW_UP->MultiUpdate != "" && !$this->FOLLOW_UP->IsDetailKey && EmptyValue($this->FOLLOW_UP->FormValue)) {
                $this->FOLLOW_UP->addErrorMessage(str_replace("%s", $this->FOLLOW_UP->caption(), $this->FOLLOW_UP->RequiredErrorMessage));
            }
        }
        if ($this->PLACE_TYPE->Required) {
            if ($this->PLACE_TYPE->MultiUpdate != "" && !$this->PLACE_TYPE->IsDetailKey && EmptyValue($this->PLACE_TYPE->FormValue)) {
                $this->PLACE_TYPE->addErrorMessage(str_replace("%s", $this->PLACE_TYPE->caption(), $this->PLACE_TYPE->RequiredErrorMessage));
            }
        }
        if ($this->CLINIC_ID->Required) {
            if ($this->CLINIC_ID->MultiUpdate != "" && !$this->CLINIC_ID->IsDetailKey && EmptyValue($this->CLINIC_ID->FormValue)) {
                $this->CLINIC_ID->addErrorMessage(str_replace("%s", $this->CLINIC_ID->caption(), $this->CLINIC_ID->RequiredErrorMessage));
            }
        }
        if ($this->CLINIC_ID_FROM->Required) {
            if ($this->CLINIC_ID_FROM->MultiUpdate != "" && !$this->CLINIC_ID_FROM->IsDetailKey && EmptyValue($this->CLINIC_ID_FROM->FormValue)) {
                $this->CLINIC_ID_FROM->addErrorMessage(str_replace("%s", $this->CLINIC_ID_FROM->caption(), $this->CLINIC_ID_FROM->RequiredErrorMessage));
            }
        }
        if ($this->CLASS_ROOM_ID->Required) {
            if ($this->CLASS_ROOM_ID->MultiUpdate != "" && !$this->CLASS_ROOM_ID->IsDetailKey && EmptyValue($this->CLASS_ROOM_ID->FormValue)) {
                $this->CLASS_ROOM_ID->addErrorMessage(str_replace("%s", $this->CLASS_ROOM_ID->caption(), $this->CLASS_ROOM_ID->RequiredErrorMessage));
            }
        }
        if ($this->BED_ID->Required) {
            if ($this->BED_ID->MultiUpdate != "" && !$this->BED_ID->IsDetailKey && EmptyValue($this->BED_ID->FormValue)) {
                $this->BED_ID->addErrorMessage(str_replace("%s", $this->BED_ID->caption(), $this->BED_ID->RequiredErrorMessage));
            }
        }
        if ($this->KELUAR_ID->Required) {
            if ($this->KELUAR_ID->MultiUpdate != "" && !$this->KELUAR_ID->IsDetailKey && EmptyValue($this->KELUAR_ID->FormValue)) {
                $this->KELUAR_ID->addErrorMessage(str_replace("%s", $this->KELUAR_ID->caption(), $this->KELUAR_ID->RequiredErrorMessage));
            }
        }
        if ($this->IN_DATE->Required) {
            if ($this->IN_DATE->MultiUpdate != "" && !$this->IN_DATE->IsDetailKey && EmptyValue($this->IN_DATE->FormValue)) {
                $this->IN_DATE->addErrorMessage(str_replace("%s", $this->IN_DATE->caption(), $this->IN_DATE->RequiredErrorMessage));
            }
        }
        if ($this->EXIT_DATE->Required) {
            if ($this->EXIT_DATE->MultiUpdate != "" && !$this->EXIT_DATE->IsDetailKey && EmptyValue($this->EXIT_DATE->FormValue)) {
                $this->EXIT_DATE->addErrorMessage(str_replace("%s", $this->EXIT_DATE->caption(), $this->EXIT_DATE->RequiredErrorMessage));
            }
        }
        if ($this->GENDER->Required) {
            if ($this->GENDER->MultiUpdate != "" && $this->GENDER->FormValue == "") {
                $this->GENDER->addErrorMessage(str_replace("%s", $this->GENDER->caption(), $this->GENDER->RequiredErrorMessage));
            }
        }
        if ($this->KODE_AGAMA->Required) {
            if ($this->KODE_AGAMA->MultiUpdate != "" && $this->KODE_AGAMA->FormValue == "") {
                $this->KODE_AGAMA->addErrorMessage(str_replace("%s", $this->KODE_AGAMA->caption(), $this->KODE_AGAMA->RequiredErrorMessage));
            }
        }
        if ($this->DESCRIPTION->Required) {
            if ($this->DESCRIPTION->MultiUpdate != "" && !$this->DESCRIPTION->IsDetailKey && EmptyValue($this->DESCRIPTION->FormValue)) {
                $this->DESCRIPTION->addErrorMessage(str_replace("%s", $this->DESCRIPTION->caption(), $this->DESCRIPTION->RequiredErrorMessage));
            }
        }
        if ($this->VISITOR_ADDRESS->Required) {
            if ($this->VISITOR_ADDRESS->MultiUpdate != "" && !$this->VISITOR_ADDRESS->IsDetailKey && EmptyValue($this->VISITOR_ADDRESS->FormValue)) {
                $this->VISITOR_ADDRESS->addErrorMessage(str_replace("%s", $this->VISITOR_ADDRESS->caption(), $this->VISITOR_ADDRESS->RequiredErrorMessage));
            }
        }
        if ($this->MODIFIED_BY->Required) {
            if ($this->MODIFIED_BY->MultiUpdate != "" && !$this->MODIFIED_BY->IsDetailKey && EmptyValue($this->MODIFIED_BY->FormValue)) {
                $this->MODIFIED_BY->addErrorMessage(str_replace("%s", $this->MODIFIED_BY->caption(), $this->MODIFIED_BY->RequiredErrorMessage));
            }
        }
        if ($this->MODIFIED_DATE->Required) {
            if ($this->MODIFIED_DATE->MultiUpdate != "" && !$this->MODIFIED_DATE->IsDetailKey && EmptyValue($this->MODIFIED_DATE->FormValue)) {
                $this->MODIFIED_DATE->addErrorMessage(str_replace("%s", $this->MODIFIED_DATE->caption(), $this->MODIFIED_DATE->RequiredErrorMessage));
            }
        }
        if ($this->MODIFIED_FROM->Required) {
            if ($this->MODIFIED_FROM->MultiUpdate != "" && !$this->MODIFIED_FROM->IsDetailKey && EmptyValue($this->MODIFIED_FROM->FormValue)) {
                $this->MODIFIED_FROM->addErrorMessage(str_replace("%s", $this->MODIFIED_FROM->caption(), $this->MODIFIED_FROM->RequiredErrorMessage));
            }
        }
        if ($this->EMPLOYEE_ID->Required) {
            if ($this->EMPLOYEE_ID->MultiUpdate != "" && !$this->EMPLOYEE_ID->IsDetailKey && EmptyValue($this->EMPLOYEE_ID->FormValue)) {
                $this->EMPLOYEE_ID->addErrorMessage(str_replace("%s", $this->EMPLOYEE_ID->caption(), $this->EMPLOYEE_ID->RequiredErrorMessage));
            }
        }
        if ($this->EMPLOYEE_ID_FROM->Required) {
            if ($this->EMPLOYEE_ID_FROM->MultiUpdate != "" && !$this->EMPLOYEE_ID_FROM->IsDetailKey && EmptyValue($this->EMPLOYEE_ID_FROM->FormValue)) {
                $this->EMPLOYEE_ID_FROM->addErrorMessage(str_replace("%s", $this->EMPLOYEE_ID_FROM->caption(), $this->EMPLOYEE_ID_FROM->RequiredErrorMessage));
            }
        }
        if ($this->RESPONSIBLE_ID->Required) {
            if ($this->RESPONSIBLE_ID->MultiUpdate != "" && !$this->RESPONSIBLE_ID->IsDetailKey && EmptyValue($this->RESPONSIBLE_ID->FormValue)) {
                $this->RESPONSIBLE_ID->addErrorMessage(str_replace("%s", $this->RESPONSIBLE_ID->caption(), $this->RESPONSIBLE_ID->RequiredErrorMessage));
            }
        }
        if ($this->RESPONSIBLE->Required) {
            if ($this->RESPONSIBLE->MultiUpdate != "" && !$this->RESPONSIBLE->IsDetailKey && EmptyValue($this->RESPONSIBLE->FormValue)) {
                $this->RESPONSIBLE->addErrorMessage(str_replace("%s", $this->RESPONSIBLE->caption(), $this->RESPONSIBLE->RequiredErrorMessage));
            }
        }
        if ($this->FAMILY_STATUS_ID->Required) {
            if ($this->FAMILY_STATUS_ID->MultiUpdate != "" && !$this->FAMILY_STATUS_ID->IsDetailKey && EmptyValue($this->FAMILY_STATUS_ID->FormValue)) {
                $this->FAMILY_STATUS_ID->addErrorMessage(str_replace("%s", $this->FAMILY_STATUS_ID->caption(), $this->FAMILY_STATUS_ID->RequiredErrorMessage));
            }
        }
        if ($this->TICKET_NO->Required) {
            if ($this->TICKET_NO->MultiUpdate != "" && !$this->TICKET_NO->IsDetailKey && EmptyValue($this->TICKET_NO->FormValue)) {
                $this->TICKET_NO->addErrorMessage(str_replace("%s", $this->TICKET_NO->caption(), $this->TICKET_NO->RequiredErrorMessage));
            }
        }
        if ($this->ISATTENDED->Required) {
            if ($this->ISATTENDED->MultiUpdate != "" && !$this->ISATTENDED->IsDetailKey && EmptyValue($this->ISATTENDED->FormValue)) {
                $this->ISATTENDED->addErrorMessage(str_replace("%s", $this->ISATTENDED->caption(), $this->ISATTENDED->RequiredErrorMessage));
            }
        }
        if ($this->PAYOR_ID->Required) {
            if ($this->PAYOR_ID->MultiUpdate != "" && !$this->PAYOR_ID->IsDetailKey && EmptyValue($this->PAYOR_ID->FormValue)) {
                $this->PAYOR_ID->addErrorMessage(str_replace("%s", $this->PAYOR_ID->caption(), $this->PAYOR_ID->RequiredErrorMessage));
            }
        }
        if ($this->CLASS_ID->Required) {
            if ($this->CLASS_ID->MultiUpdate != "" && !$this->CLASS_ID->IsDetailKey && EmptyValue($this->CLASS_ID->FormValue)) {
                $this->CLASS_ID->addErrorMessage(str_replace("%s", $this->CLASS_ID->caption(), $this->CLASS_ID->RequiredErrorMessage));
            }
        }
        if ($this->ISPERTARIF->Required) {
            if ($this->ISPERTARIF->MultiUpdate != "" && !$this->ISPERTARIF->IsDetailKey && EmptyValue($this->ISPERTARIF->FormValue)) {
                $this->ISPERTARIF->addErrorMessage(str_replace("%s", $this->ISPERTARIF->caption(), $this->ISPERTARIF->RequiredErrorMessage));
            }
        }
        if ($this->KAL_ID->Required) {
            if ($this->KAL_ID->MultiUpdate != "" && !$this->KAL_ID->IsDetailKey && EmptyValue($this->KAL_ID->FormValue)) {
                $this->KAL_ID->addErrorMessage(str_replace("%s", $this->KAL_ID->caption(), $this->KAL_ID->RequiredErrorMessage));
            }
        }
        if ($this->EMPLOYEE_INAP->Required) {
            if ($this->EMPLOYEE_INAP->MultiUpdate != "" && !$this->EMPLOYEE_INAP->IsDetailKey && EmptyValue($this->EMPLOYEE_INAP->FormValue)) {
                $this->EMPLOYEE_INAP->addErrorMessage(str_replace("%s", $this->EMPLOYEE_INAP->caption(), $this->EMPLOYEE_INAP->RequiredErrorMessage));
            }
        }
        if ($this->PASIEN_ID->Required) {
            if ($this->PASIEN_ID->MultiUpdate != "" && !$this->PASIEN_ID->IsDetailKey && EmptyValue($this->PASIEN_ID->FormValue)) {
                $this->PASIEN_ID->addErrorMessage(str_replace("%s", $this->PASIEN_ID->caption(), $this->PASIEN_ID->RequiredErrorMessage));
            }
        }
        if ($this->KARYAWAN->Required) {
            if ($this->KARYAWAN->MultiUpdate != "" && !$this->KARYAWAN->IsDetailKey && EmptyValue($this->KARYAWAN->FormValue)) {
                $this->KARYAWAN->addErrorMessage(str_replace("%s", $this->KARYAWAN->caption(), $this->KARYAWAN->RequiredErrorMessage));
            }
        }
        if ($this->ACCOUNT_ID->Required) {
            if ($this->ACCOUNT_ID->MultiUpdate != "" && !$this->ACCOUNT_ID->IsDetailKey && EmptyValue($this->ACCOUNT_ID->FormValue)) {
                $this->ACCOUNT_ID->addErrorMessage(str_replace("%s", $this->ACCOUNT_ID->caption(), $this->ACCOUNT_ID->RequiredErrorMessage));
            }
        }
        if ($this->CLASS_ID_PLAFOND->Required) {
            if ($this->CLASS_ID_PLAFOND->MultiUpdate != "" && !$this->CLASS_ID_PLAFOND->IsDetailKey && EmptyValue($this->CLASS_ID_PLAFOND->FormValue)) {
                $this->CLASS_ID_PLAFOND->addErrorMessage(str_replace("%s", $this->CLASS_ID_PLAFOND->caption(), $this->CLASS_ID_PLAFOND->RequiredErrorMessage));
            }
        }
        if ($this->BACKCHARGE->Required) {
            if ($this->BACKCHARGE->MultiUpdate != "" && !$this->BACKCHARGE->IsDetailKey && EmptyValue($this->BACKCHARGE->FormValue)) {
                $this->BACKCHARGE->addErrorMessage(str_replace("%s", $this->BACKCHARGE->caption(), $this->BACKCHARGE->RequiredErrorMessage));
            }
        }
        if ($this->COVERAGE_ID->Required) {
            if ($this->COVERAGE_ID->MultiUpdate != "" && $this->COVERAGE_ID->FormValue == "") {
                $this->COVERAGE_ID->addErrorMessage(str_replace("%s", $this->COVERAGE_ID->caption(), $this->COVERAGE_ID->RequiredErrorMessage));
            }
        }
        if ($this->AGEYEAR->Required) {
            if ($this->AGEYEAR->MultiUpdate != "" && !$this->AGEYEAR->IsDetailKey && EmptyValue($this->AGEYEAR->FormValue)) {
                $this->AGEYEAR->addErrorMessage(str_replace("%s", $this->AGEYEAR->caption(), $this->AGEYEAR->RequiredErrorMessage));
            }
        }
        if ($this->AGEMONTH->Required) {
            if ($this->AGEMONTH->MultiUpdate != "" && !$this->AGEMONTH->IsDetailKey && EmptyValue($this->AGEMONTH->FormValue)) {
                $this->AGEMONTH->addErrorMessage(str_replace("%s", $this->AGEMONTH->caption(), $this->AGEMONTH->RequiredErrorMessage));
            }
        }
        if ($this->AGEDAY->Required) {
            if ($this->AGEDAY->MultiUpdate != "" && !$this->AGEDAY->IsDetailKey && EmptyValue($this->AGEDAY->FormValue)) {
                $this->AGEDAY->addErrorMessage(str_replace("%s", $this->AGEDAY->caption(), $this->AGEDAY->RequiredErrorMessage));
            }
        }
        if ($this->RECOMENDATION->Required) {
            if ($this->RECOMENDATION->MultiUpdate != "" && !$this->RECOMENDATION->IsDetailKey && EmptyValue($this->RECOMENDATION->FormValue)) {
                $this->RECOMENDATION->addErrorMessage(str_replace("%s", $this->RECOMENDATION->caption(), $this->RECOMENDATION->RequiredErrorMessage));
            }
        }
        if ($this->CONCLUSION->Required) {
            if ($this->CONCLUSION->MultiUpdate != "" && !$this->CONCLUSION->IsDetailKey && EmptyValue($this->CONCLUSION->FormValue)) {
                $this->CONCLUSION->addErrorMessage(str_replace("%s", $this->CONCLUSION->caption(), $this->CONCLUSION->RequiredErrorMessage));
            }
        }
        if ($this->SPECIMENNO->Required) {
            if ($this->SPECIMENNO->MultiUpdate != "" && !$this->SPECIMENNO->IsDetailKey && EmptyValue($this->SPECIMENNO->FormValue)) {
                $this->SPECIMENNO->addErrorMessage(str_replace("%s", $this->SPECIMENNO->caption(), $this->SPECIMENNO->RequiredErrorMessage));
            }
        }
        if ($this->LOCKED->Required) {
            if ($this->LOCKED->MultiUpdate != "" && !$this->LOCKED->IsDetailKey && EmptyValue($this->LOCKED->FormValue)) {
                $this->LOCKED->addErrorMessage(str_replace("%s", $this->LOCKED->caption(), $this->LOCKED->RequiredErrorMessage));
            }
        }
        if ($this->RM_OUT_DATE->Required) {
            if ($this->RM_OUT_DATE->MultiUpdate != "" && !$this->RM_OUT_DATE->IsDetailKey && EmptyValue($this->RM_OUT_DATE->FormValue)) {
                $this->RM_OUT_DATE->addErrorMessage(str_replace("%s", $this->RM_OUT_DATE->caption(), $this->RM_OUT_DATE->RequiredErrorMessage));
            }
        }
        if ($this->RM_IN_DATE->Required) {
            if ($this->RM_IN_DATE->MultiUpdate != "" && !$this->RM_IN_DATE->IsDetailKey && EmptyValue($this->RM_IN_DATE->FormValue)) {
                $this->RM_IN_DATE->addErrorMessage(str_replace("%s", $this->RM_IN_DATE->caption(), $this->RM_IN_DATE->RequiredErrorMessage));
            }
        }
        if ($this->LAMA_PINJAM->Required) {
            if ($this->LAMA_PINJAM->MultiUpdate != "" && !$this->LAMA_PINJAM->IsDetailKey && EmptyValue($this->LAMA_PINJAM->FormValue)) {
                $this->LAMA_PINJAM->addErrorMessage(str_replace("%s", $this->LAMA_PINJAM->caption(), $this->LAMA_PINJAM->RequiredErrorMessage));
            }
        }
        if ($this->STANDAR_RJ->Required) {
            if ($this->STANDAR_RJ->MultiUpdate != "" && !$this->STANDAR_RJ->IsDetailKey && EmptyValue($this->STANDAR_RJ->FormValue)) {
                $this->STANDAR_RJ->addErrorMessage(str_replace("%s", $this->STANDAR_RJ->caption(), $this->STANDAR_RJ->RequiredErrorMessage));
            }
        }
        if ($this->LENGKAP_RJ->Required) {
            if ($this->LENGKAP_RJ->MultiUpdate != "" && !$this->LENGKAP_RJ->IsDetailKey && EmptyValue($this->LENGKAP_RJ->FormValue)) {
                $this->LENGKAP_RJ->addErrorMessage(str_replace("%s", $this->LENGKAP_RJ->caption(), $this->LENGKAP_RJ->RequiredErrorMessage));
            }
        }
        if ($this->LENGKAP_RI->Required) {
            if ($this->LENGKAP_RI->MultiUpdate != "" && !$this->LENGKAP_RI->IsDetailKey && EmptyValue($this->LENGKAP_RI->FormValue)) {
                $this->LENGKAP_RI->addErrorMessage(str_replace("%s", $this->LENGKAP_RI->caption(), $this->LENGKAP_RI->RequiredErrorMessage));
            }
        }
        if ($this->RESEND_RM_DATE->Required) {
            if ($this->RESEND_RM_DATE->MultiUpdate != "" && !$this->RESEND_RM_DATE->IsDetailKey && EmptyValue($this->RESEND_RM_DATE->FormValue)) {
                $this->RESEND_RM_DATE->addErrorMessage(str_replace("%s", $this->RESEND_RM_DATE->caption(), $this->RESEND_RM_DATE->RequiredErrorMessage));
            }
        }
        if ($this->LENGKAP_RM1->Required) {
            if ($this->LENGKAP_RM1->MultiUpdate != "" && !$this->LENGKAP_RM1->IsDetailKey && EmptyValue($this->LENGKAP_RM1->FormValue)) {
                $this->LENGKAP_RM1->addErrorMessage(str_replace("%s", $this->LENGKAP_RM1->caption(), $this->LENGKAP_RM1->RequiredErrorMessage));
            }
        }
        if ($this->LENGKAP_RESUME->Required) {
            if ($this->LENGKAP_RESUME->MultiUpdate != "" && !$this->LENGKAP_RESUME->IsDetailKey && EmptyValue($this->LENGKAP_RESUME->FormValue)) {
                $this->LENGKAP_RESUME->addErrorMessage(str_replace("%s", $this->LENGKAP_RESUME->caption(), $this->LENGKAP_RESUME->RequiredErrorMessage));
            }
        }
        if ($this->LENGKAP_ANAMNESIS->Required) {
            if ($this->LENGKAP_ANAMNESIS->MultiUpdate != "" && !$this->LENGKAP_ANAMNESIS->IsDetailKey && EmptyValue($this->LENGKAP_ANAMNESIS->FormValue)) {
                $this->LENGKAP_ANAMNESIS->addErrorMessage(str_replace("%s", $this->LENGKAP_ANAMNESIS->caption(), $this->LENGKAP_ANAMNESIS->RequiredErrorMessage));
            }
        }
        if ($this->LENGKAP_CONSENT->Required) {
            if ($this->LENGKAP_CONSENT->MultiUpdate != "" && !$this->LENGKAP_CONSENT->IsDetailKey && EmptyValue($this->LENGKAP_CONSENT->FormValue)) {
                $this->LENGKAP_CONSENT->addErrorMessage(str_replace("%s", $this->LENGKAP_CONSENT->caption(), $this->LENGKAP_CONSENT->RequiredErrorMessage));
            }
        }
        if ($this->LENGKAP_ANESTESI->Required) {
            if ($this->LENGKAP_ANESTESI->MultiUpdate != "" && !$this->LENGKAP_ANESTESI->IsDetailKey && EmptyValue($this->LENGKAP_ANESTESI->FormValue)) {
                $this->LENGKAP_ANESTESI->addErrorMessage(str_replace("%s", $this->LENGKAP_ANESTESI->caption(), $this->LENGKAP_ANESTESI->RequiredErrorMessage));
            }
        }
        if ($this->LENGKAP_OP->Required) {
            if ($this->LENGKAP_OP->MultiUpdate != "" && !$this->LENGKAP_OP->IsDetailKey && EmptyValue($this->LENGKAP_OP->FormValue)) {
                $this->LENGKAP_OP->addErrorMessage(str_replace("%s", $this->LENGKAP_OP->caption(), $this->LENGKAP_OP->RequiredErrorMessage));
            }
        }
        if ($this->BACK_RM_DATE->Required) {
            if ($this->BACK_RM_DATE->MultiUpdate != "" && !$this->BACK_RM_DATE->IsDetailKey && EmptyValue($this->BACK_RM_DATE->FormValue)) {
                $this->BACK_RM_DATE->addErrorMessage(str_replace("%s", $this->BACK_RM_DATE->caption(), $this->BACK_RM_DATE->RequiredErrorMessage));
            }
        }
        if ($this->VALID_RM_DATE->Required) {
            if ($this->VALID_RM_DATE->MultiUpdate != "" && !$this->VALID_RM_DATE->IsDetailKey && EmptyValue($this->VALID_RM_DATE->FormValue)) {
                $this->VALID_RM_DATE->addErrorMessage(str_replace("%s", $this->VALID_RM_DATE->caption(), $this->VALID_RM_DATE->RequiredErrorMessage));
            }
        }
        if ($this->NO_SKP->Required) {
            if ($this->NO_SKP->MultiUpdate != "" && !$this->NO_SKP->IsDetailKey && EmptyValue($this->NO_SKP->FormValue)) {
                $this->NO_SKP->addErrorMessage(str_replace("%s", $this->NO_SKP->caption(), $this->NO_SKP->RequiredErrorMessage));
            }
        }
        if ($this->NO_SKPINAP->Required) {
            if ($this->NO_SKPINAP->MultiUpdate != "" && !$this->NO_SKPINAP->IsDetailKey && EmptyValue($this->NO_SKPINAP->FormValue)) {
                $this->NO_SKPINAP->addErrorMessage(str_replace("%s", $this->NO_SKPINAP->caption(), $this->NO_SKPINAP->RequiredErrorMessage));
            }
        }
        if ($this->DIAGNOSA_ID->Required) {
            if ($this->DIAGNOSA_ID->MultiUpdate != "" && !$this->DIAGNOSA_ID->IsDetailKey && EmptyValue($this->DIAGNOSA_ID->FormValue)) {
                $this->DIAGNOSA_ID->addErrorMessage(str_replace("%s", $this->DIAGNOSA_ID->caption(), $this->DIAGNOSA_ID->RequiredErrorMessage));
            }
        }
        if ($this->ticket_all->Required) {
            if ($this->ticket_all->MultiUpdate != "" && !$this->ticket_all->IsDetailKey && EmptyValue($this->ticket_all->FormValue)) {
                $this->ticket_all->addErrorMessage(str_replace("%s", $this->ticket_all->caption(), $this->ticket_all->RequiredErrorMessage));
            }
        }
        if ($this->tanggal_rujukan->Required) {
            if ($this->tanggal_rujukan->MultiUpdate != "" && !$this->tanggal_rujukan->IsDetailKey && EmptyValue($this->tanggal_rujukan->FormValue)) {
                $this->tanggal_rujukan->addErrorMessage(str_replace("%s", $this->tanggal_rujukan->caption(), $this->tanggal_rujukan->RequiredErrorMessage));
            }
        }
        if ($this->ISRJ->Required) {
            if ($this->ISRJ->MultiUpdate != "" && !$this->ISRJ->IsDetailKey && EmptyValue($this->ISRJ->FormValue)) {
                $this->ISRJ->addErrorMessage(str_replace("%s", $this->ISRJ->caption(), $this->ISRJ->RequiredErrorMessage));
            }
        }
        if ($this->NORUJUKAN->Required) {
            if ($this->NORUJUKAN->MultiUpdate != "" && !$this->NORUJUKAN->IsDetailKey && EmptyValue($this->NORUJUKAN->FormValue)) {
                $this->NORUJUKAN->addErrorMessage(str_replace("%s", $this->NORUJUKAN->caption(), $this->NORUJUKAN->RequiredErrorMessage));
            }
        }
        if ($this->PPKRUJUKAN->Required) {
            if ($this->PPKRUJUKAN->MultiUpdate != "" && !$this->PPKRUJUKAN->IsDetailKey && EmptyValue($this->PPKRUJUKAN->FormValue)) {
                $this->PPKRUJUKAN->addErrorMessage(str_replace("%s", $this->PPKRUJUKAN->caption(), $this->PPKRUJUKAN->RequiredErrorMessage));
            }
        }
        if ($this->LOKASILAKA->Required) {
            if ($this->LOKASILAKA->MultiUpdate != "" && !$this->LOKASILAKA->IsDetailKey && EmptyValue($this->LOKASILAKA->FormValue)) {
                $this->LOKASILAKA->addErrorMessage(str_replace("%s", $this->LOKASILAKA->caption(), $this->LOKASILAKA->RequiredErrorMessage));
            }
        }
        if ($this->KDPOLI->Required) {
            if ($this->KDPOLI->MultiUpdate != "" && !$this->KDPOLI->IsDetailKey && EmptyValue($this->KDPOLI->FormValue)) {
                $this->KDPOLI->addErrorMessage(str_replace("%s", $this->KDPOLI->caption(), $this->KDPOLI->RequiredErrorMessage));
            }
        }
        if ($this->EDIT_SEP->Required) {
            if ($this->EDIT_SEP->MultiUpdate != "" && !$this->EDIT_SEP->IsDetailKey && EmptyValue($this->EDIT_SEP->FormValue)) {
                $this->EDIT_SEP->addErrorMessage(str_replace("%s", $this->EDIT_SEP->caption(), $this->EDIT_SEP->RequiredErrorMessage));
            }
        }
        if ($this->DELETE_SEP->Required) {
            if ($this->DELETE_SEP->MultiUpdate != "" && !$this->DELETE_SEP->IsDetailKey && EmptyValue($this->DELETE_SEP->FormValue)) {
                $this->DELETE_SEP->addErrorMessage(str_replace("%s", $this->DELETE_SEP->caption(), $this->DELETE_SEP->RequiredErrorMessage));
            }
        }
        if ($this->DIAG_AWAL->Required) {
            if ($this->DIAG_AWAL->MultiUpdate != "" && !$this->DIAG_AWAL->IsDetailKey && EmptyValue($this->DIAG_AWAL->FormValue)) {
                $this->DIAG_AWAL->addErrorMessage(str_replace("%s", $this->DIAG_AWAL->caption(), $this->DIAG_AWAL->RequiredErrorMessage));
            }
        }
        if ($this->AKTIF->Required) {
            if ($this->AKTIF->MultiUpdate != "" && !$this->AKTIF->IsDetailKey && EmptyValue($this->AKTIF->FormValue)) {
                $this->AKTIF->addErrorMessage(str_replace("%s", $this->AKTIF->caption(), $this->AKTIF->RequiredErrorMessage));
            }
        }
        if ($this->BILL_INAP->Required) {
            if ($this->BILL_INAP->MultiUpdate != "" && !$this->BILL_INAP->IsDetailKey && EmptyValue($this->BILL_INAP->FormValue)) {
                $this->BILL_INAP->addErrorMessage(str_replace("%s", $this->BILL_INAP->caption(), $this->BILL_INAP->RequiredErrorMessage));
            }
        }
        if ($this->SEP_PRINTDATE->Required) {
            if ($this->SEP_PRINTDATE->MultiUpdate != "" && !$this->SEP_PRINTDATE->IsDetailKey && EmptyValue($this->SEP_PRINTDATE->FormValue)) {
                $this->SEP_PRINTDATE->addErrorMessage(str_replace("%s", $this->SEP_PRINTDATE->caption(), $this->SEP_PRINTDATE->RequiredErrorMessage));
            }
        }
        if ($this->MAPPING_SEP->Required) {
            if ($this->MAPPING_SEP->MultiUpdate != "" && !$this->MAPPING_SEP->IsDetailKey && EmptyValue($this->MAPPING_SEP->FormValue)) {
                $this->MAPPING_SEP->addErrorMessage(str_replace("%s", $this->MAPPING_SEP->caption(), $this->MAPPING_SEP->RequiredErrorMessage));
            }
        }
        if ($this->TRANS_ID->Required) {
            if ($this->TRANS_ID->MultiUpdate != "" && !$this->TRANS_ID->IsDetailKey && EmptyValue($this->TRANS_ID->FormValue)) {
                $this->TRANS_ID->addErrorMessage(str_replace("%s", $this->TRANS_ID->caption(), $this->TRANS_ID->RequiredErrorMessage));
            }
        }
        if ($this->KDPOLI_EKS->Required) {
            if ($this->KDPOLI_EKS->MultiUpdate != "" && !$this->KDPOLI_EKS->IsDetailKey && EmptyValue($this->KDPOLI_EKS->FormValue)) {
                $this->KDPOLI_EKS->addErrorMessage(str_replace("%s", $this->KDPOLI_EKS->caption(), $this->KDPOLI_EKS->RequiredErrorMessage));
            }
        }
        if ($this->COB->Required) {
            if ($this->COB->MultiUpdate != "" && $this->COB->FormValue == "") {
                $this->COB->addErrorMessage(str_replace("%s", $this->COB->caption(), $this->COB->RequiredErrorMessage));
            }
        }
        if ($this->PENJAMIN->Required) {
            if ($this->PENJAMIN->MultiUpdate != "" && !$this->PENJAMIN->IsDetailKey && EmptyValue($this->PENJAMIN->FormValue)) {
                $this->PENJAMIN->addErrorMessage(str_replace("%s", $this->PENJAMIN->caption(), $this->PENJAMIN->RequiredErrorMessage));
            }
        }
        if ($this->ASALRUJUKAN->Required) {
            if ($this->ASALRUJUKAN->MultiUpdate != "" && !$this->ASALRUJUKAN->IsDetailKey && EmptyValue($this->ASALRUJUKAN->FormValue)) {
                $this->ASALRUJUKAN->addErrorMessage(str_replace("%s", $this->ASALRUJUKAN->caption(), $this->ASALRUJUKAN->RequiredErrorMessage));
            }
        }
        if ($this->RESPONSEP->Required) {
            if ($this->RESPONSEP->MultiUpdate != "" && !$this->RESPONSEP->IsDetailKey && EmptyValue($this->RESPONSEP->FormValue)) {
                $this->RESPONSEP->addErrorMessage(str_replace("%s", $this->RESPONSEP->caption(), $this->RESPONSEP->RequiredErrorMessage));
            }
        }
        if ($this->APPROVAL_DESC->Required) {
            if ($this->APPROVAL_DESC->MultiUpdate != "" && !$this->APPROVAL_DESC->IsDetailKey && EmptyValue($this->APPROVAL_DESC->FormValue)) {
                $this->APPROVAL_DESC->addErrorMessage(str_replace("%s", $this->APPROVAL_DESC->caption(), $this->APPROVAL_DESC->RequiredErrorMessage));
            }
        }
        if ($this->APPROVAL_RESPONAJUKAN->Required) {
            if ($this->APPROVAL_RESPONAJUKAN->MultiUpdate != "" && !$this->APPROVAL_RESPONAJUKAN->IsDetailKey && EmptyValue($this->APPROVAL_RESPONAJUKAN->FormValue)) {
                $this->APPROVAL_RESPONAJUKAN->addErrorMessage(str_replace("%s", $this->APPROVAL_RESPONAJUKAN->caption(), $this->APPROVAL_RESPONAJUKAN->RequiredErrorMessage));
            }
        }
        if ($this->APPROVAL_RESPONAPPROV->Required) {
            if ($this->APPROVAL_RESPONAPPROV->MultiUpdate != "" && !$this->APPROVAL_RESPONAPPROV->IsDetailKey && EmptyValue($this->APPROVAL_RESPONAPPROV->FormValue)) {
                $this->APPROVAL_RESPONAPPROV->addErrorMessage(str_replace("%s", $this->APPROVAL_RESPONAPPROV->caption(), $this->APPROVAL_RESPONAPPROV->RequiredErrorMessage));
            }
        }
        if ($this->RESPONTGLPLG_DESC->Required) {
            if ($this->RESPONTGLPLG_DESC->MultiUpdate != "" && !$this->RESPONTGLPLG_DESC->IsDetailKey && EmptyValue($this->RESPONTGLPLG_DESC->FormValue)) {
                $this->RESPONTGLPLG_DESC->addErrorMessage(str_replace("%s", $this->RESPONTGLPLG_DESC->caption(), $this->RESPONTGLPLG_DESC->RequiredErrorMessage));
            }
        }
        if ($this->RESPONPOST_VKLAIM->Required) {
            if ($this->RESPONPOST_VKLAIM->MultiUpdate != "" && !$this->RESPONPOST_VKLAIM->IsDetailKey && EmptyValue($this->RESPONPOST_VKLAIM->FormValue)) {
                $this->RESPONPOST_VKLAIM->addErrorMessage(str_replace("%s", $this->RESPONPOST_VKLAIM->caption(), $this->RESPONPOST_VKLAIM->RequiredErrorMessage));
            }
        }
        if ($this->RESPONPUT_VKLAIM->Required) {
            if ($this->RESPONPUT_VKLAIM->MultiUpdate != "" && !$this->RESPONPUT_VKLAIM->IsDetailKey && EmptyValue($this->RESPONPUT_VKLAIM->FormValue)) {
                $this->RESPONPUT_VKLAIM->addErrorMessage(str_replace("%s", $this->RESPONPUT_VKLAIM->caption(), $this->RESPONPUT_VKLAIM->RequiredErrorMessage));
            }
        }
        if ($this->RESPONDEL_VKLAIM->Required) {
            if ($this->RESPONDEL_VKLAIM->MultiUpdate != "" && !$this->RESPONDEL_VKLAIM->IsDetailKey && EmptyValue($this->RESPONDEL_VKLAIM->FormValue)) {
                $this->RESPONDEL_VKLAIM->addErrorMessage(str_replace("%s", $this->RESPONDEL_VKLAIM->caption(), $this->RESPONDEL_VKLAIM->RequiredErrorMessage));
            }
        }
        if ($this->CALL_TIMES->Required) {
            if ($this->CALL_TIMES->MultiUpdate != "" && !$this->CALL_TIMES->IsDetailKey && EmptyValue($this->CALL_TIMES->FormValue)) {
                $this->CALL_TIMES->addErrorMessage(str_replace("%s", $this->CALL_TIMES->caption(), $this->CALL_TIMES->RequiredErrorMessage));
            }
        }
        if ($this->CALL_DATE->Required) {
            if ($this->CALL_DATE->MultiUpdate != "" && !$this->CALL_DATE->IsDetailKey && EmptyValue($this->CALL_DATE->FormValue)) {
                $this->CALL_DATE->addErrorMessage(str_replace("%s", $this->CALL_DATE->caption(), $this->CALL_DATE->RequiredErrorMessage));
            }
        }
        if ($this->CALL_DATES->Required) {
            if ($this->CALL_DATES->MultiUpdate != "" && !$this->CALL_DATES->IsDetailKey && EmptyValue($this->CALL_DATES->FormValue)) {
                $this->CALL_DATES->addErrorMessage(str_replace("%s", $this->CALL_DATES->caption(), $this->CALL_DATES->RequiredErrorMessage));
            }
        }
        if ($this->SERVED_DATE->Required) {
            if ($this->SERVED_DATE->MultiUpdate != "" && !$this->SERVED_DATE->IsDetailKey && EmptyValue($this->SERVED_DATE->FormValue)) {
                $this->SERVED_DATE->addErrorMessage(str_replace("%s", $this->SERVED_DATE->caption(), $this->SERVED_DATE->RequiredErrorMessage));
            }
        }
        if ($this->SERVED_INAP->Required) {
            if ($this->SERVED_INAP->MultiUpdate != "" && !$this->SERVED_INAP->IsDetailKey && EmptyValue($this->SERVED_INAP->FormValue)) {
                $this->SERVED_INAP->addErrorMessage(str_replace("%s", $this->SERVED_INAP->caption(), $this->SERVED_INAP->RequiredErrorMessage));
            }
        }
        if ($this->KDDPJP1->Required) {
            if ($this->KDDPJP1->MultiUpdate != "" && !$this->KDDPJP1->IsDetailKey && EmptyValue($this->KDDPJP1->FormValue)) {
                $this->KDDPJP1->addErrorMessage(str_replace("%s", $this->KDDPJP1->caption(), $this->KDDPJP1->RequiredErrorMessage));
            }
        }
        if ($this->KDDPJP->Required) {
            if ($this->KDDPJP->MultiUpdate != "" && !$this->KDDPJP->IsDetailKey && EmptyValue($this->KDDPJP->FormValue)) {
                $this->KDDPJP->addErrorMessage(str_replace("%s", $this->KDDPJP->caption(), $this->KDDPJP->RequiredErrorMessage));
            }
        }
        if ($this->SEP->Required) {
            if ($this->SEP->MultiUpdate != "" && !$this->SEP->IsDetailKey && EmptyValue($this->SEP->FormValue)) {
                $this->SEP->addErrorMessage(str_replace("%s", $this->SEP->caption(), $this->SEP->RequiredErrorMessage));
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

            // SEP
            $this->SEP->setDbValueDef($rsnew, $this->SEP->CurrentValue, "", $this->SEP->ReadOnly || $this->SEP->MultiUpdate != "1");

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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("PasienVisitationList"), "", $this->TableVar, true);
        $pageId = "update";
        $Breadcrumb->add("update", $pageId, $url);
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
                case "x_NO_REGISTRATION":
                    break;
                case "x_STATUS_PASIEN_ID":
                    $lookupFilter = function () {
                        return "[ISACTIVE] = 1";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    break;
                case "x_RUJUKAN_ID":
                    break;
                case "x_ADDRESS_OF_RUJUKAN":
                    break;
                case "x_REASON_ID":
                    break;
                case "x_WAY_ID":
                    break;
                case "x_PATIENT_CATEGORY_ID":
                    break;
                case "x_ISNEW":
                    break;
                case "x_CLINIC_ID":
                    $lookupFilter = function () {
                        return "[STYPE_ID] = 1 OR [STYPE_ID] = 2 OR [STYPE_ID] = 3 OR [STYPE_ID] = 5";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    break;
                case "x_CLINIC_ID_FROM":
                    break;
                case "x_KELUAR_ID":
                    break;
                case "x_GENDER":
                    $lookupFilter = function () {
                        return "[GENDER] = 1 OR [GENDER] = 2";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    break;
                case "x_KODE_AGAMA":
                    break;
                case "x_EMPLOYEE_ID":
                    $lookupFilter = function () {
                        return "[OBJECT_CATEGORY_ID]= 20";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    break;
                case "x_RESPONSIBLE_ID":
                    break;
                case "x_PAYOR_ID":
                    break;
                case "x_CLASS_ID":
                    break;
                case "x_KAL_ID":
                    break;
                case "x_COVERAGE_ID":
                    break;
                case "x_DIAGNOSA_ID":
                    break;
                case "x_ISRJ":
                    break;
                case "x_PPKRUJUKAN":
                    break;
                case "x_COB":
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
