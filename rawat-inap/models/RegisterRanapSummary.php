<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class RegisterRanapSummary extends RegisterRanap
{
    use MessagesTrait;

    // Page ID
    public $PageID = "summary";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'register_ranap';

    // Page object name
    public $PageObjName = "RegisterRanapSummary";

    // Rendering View
    public $RenderingView = false;

    // CSS
    public $ReportTableClass = "";
    public $ReportTableStyle = "";

    // Page URLs
    public $AddUrl;
    public $EditUrl;
    public $CopyUrl;
    public $DeleteUrl;
    public $ViewUrl;
    public $ListUrl;

    // Export URLs
    public $ExportPrintUrl;
    public $ExportHtmlUrl;
    public $ExportExcelUrl;
    public $ExportWordUrl;
    public $ExportXmlUrl;
    public $ExportCsvUrl;
    public $ExportPdfUrl;

    // Custom export
    public $ExportExcelCustom = false;
    public $ExportWordCustom = false;
    public $ExportPdfCustom = false;
    public $ExportEmailCustom = false;

    // Update URLs
    public $InlineAddUrl;
    public $InlineCopyUrl;
    public $InlineEditUrl;
    public $GridAddUrl;
    public $GridEditUrl;
    public $MultiDeleteUrl;
    public $MultiUpdateUrl;

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

        // Table object (register_ranap)
        if (!isset($GLOBALS["register_ranap"]) || get_class($GLOBALS["register_ranap"]) == PROJECT_NAMESPACE . "register_ranap") {
            $GLOBALS["register_ranap"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Initialize URLs
        $this->ExportPrintUrl = $pageUrl . "export=print";
        $this->ExportExcelUrl = $pageUrl . "export=excel";
        $this->ExportWordUrl = $pageUrl . "export=word";
        $this->ExportPdfUrl = $pageUrl . "export=pdf";

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'register_ranap');
        }

        // Start timer
        $DebugTimer = Container("timer");

        // Debug message
        LoadDebugMessage();

        // Open connection
        $GLOBALS["Conn"] = $GLOBALS["Conn"] ?? $this->getConnection();

        // User table object
        $UserTable = Container("usertable");

        // Export options
        $this->ExportOptions = new ListOptions("div");
        $this->ExportOptions->TagClassName = "ew-export-option";

        // Filter options
        $this->FilterOptions = new ListOptions("div");
        $this->FilterOptions->TagClassName = "ew-filter-option fsummary";
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
        if ($this->isExport() && !$this->isExport("print")) {
            $class = PROJECT_NAMESPACE . Config("REPORT_EXPORT_CLASSES." . $this->Export);
            if (class_exists($class)) {
                $content = $this->getContents();
                $doc = new $class();
                $doc($this, $content);
            }
        }
        if (!IsApi() && method_exists($this, "pageRedirecting")) {
            $this->pageRedirecting($url);
        }

        // Close connection if not in dashboard
        if (!$DashboardReport) {
            CloseConnections();
        }

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
            SaveDebugMessage();
            Redirect(GetUrl($url));
        }
        return; // Return to controller
    }

    // Lookup data
    public function lookup()
    {
        global $Language, $Security;

        // Get lookup object
        $fieldName = Post("field");
        $lookup = $this->Fields[$fieldName]->Lookup;
        if (in_array($lookup->LinkTable, [$this->ReportSourceTable, $this->TableVar])) {
            $lookup->RenderViewFunc = "renderLookup"; // Set up view renderer
        }
        $lookup->RenderEditFunc = ""; // Set up edit renderer

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

    // Options
    public $HideOptions = false;
    public $ExportOptions; // Export options
    public $SearchOptions; // Search options
    public $FilterOptions; // Filter options

    // Records
    public $GroupRecords = [];
    public $DetailRecords = [];
    public $DetailRecordCount = 0;

    // Paging variables
    public $RecordIndex = 0; // Record index
    public $RecordCount = 0; // Record count (start from 1 for each group)
    public $StartGroup = 0; // Start group
    public $StopGroup = 0; // Stop group
    public $TotalGroups = 0; // Total groups
    public $GroupCount = 0; // Group count
    public $GroupCounter = []; // Group counter
    public $DisplayGroups = 5; // Groups per page
    public $GroupRange = 10;
    public $PageSizes = "1,2,3,5,-1"; // Page sizes (comma separated)
    public $PageFirstGroupFilter = "";
    public $UserIDFilter = "";
    public $DefaultSearchWhere = ""; // Default search WHERE clause
    public $SearchWhere = "";
    public $SearchPanelClass = "ew-search-panel collapse show"; // Search Panel class
    public $SearchRowCount = 0; // For extended search
    public $SearchColumnCount = 0; // For extended search
    public $SearchFieldsPerRow = 2; // For extended search
    public $DrillDownList = "";
    public $DbMasterFilter = ""; // Master filter
    public $DbDetailFilter = ""; // Detail filter
    public $SearchCommand = false;
    public $ShowHeader;
    public $GroupColumnCount = 0;
    public $SubGroupColumnCount = 0;
    public $DetailColumnCount = 0;
    public $TotalCount;
    public $PageTotalCount;
    public $TopContentClass = "col-sm-12 ew-top";
    public $LeftContentClass = "ew-left";
    public $CenterContentClass = "col-sm-12 ew-center";
    public $RightContentClass = "ew-right";
    public $BottomContentClass = "col-sm-12 ew-bottom";

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $ExportFileName, $Language, $Security, $UserProfile,
            $Security, $DrillDownInPanel, $Breadcrumb,
            $DashboardReport, $CustomExportType, $ReportExportType;
        $this->CurrentAction = Param("action"); // Set up current action

        // Global Page Loading event (in userfn*.php)
        Page_Loading();

        // Page Load event
        if (method_exists($this, "pageLoad")) {
            $this->pageLoad();
        }

        // Setup other options
        $this->setupOtherOptions();

        // Set up table class
        if ($this->isExport("word") || $this->isExport("excel") || $this->isExport("pdf")) {
            $this->ReportTableClass = "ew-table";
        } else {
            $this->ReportTableClass = "table ew-table";
        }

        // Set field visibility for detail fields
        $this->NO_REGISTRATION->setVisibility();
        $this->GENDER->setVisibility();
        $this->CLASS_ROOM_ID->setVisibility();
        $this->BED_ID->setVisibility();
        $this->SERVED_INAP->setVisibility();
        $this->STATUS_PASIEN_ID->setVisibility();
        $this->ISRJ->setVisibility();
        $this->VISIT_ID->setVisibility();
        $this->IDXDAFTAR->setVisibility();
        $this->DIANTAR_OLEH->setVisibility();
        $this->EXIT_DATE->setVisibility();
        $this->KELUAR_ID->setVisibility();
        $this->AGEYEAR->setVisibility();
        $this->ORG_UNIT_CODE->setVisibility();
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
        $this->IN_DATE->setVisibility();
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
        $this->KDDPJP1->setVisibility();
        $this->KDDPJP->setVisibility();
        $this->tgl_kontrol->setVisibility();

        // Set up groups per page dynamically
        $this->setupDisplayGroups();

        // Set up Breadcrumb
        if (!$this->isExport() && !$DashboardReport) {
            $this->setupBreadcrumb();
        }

        // Check if search command
        $this->SearchCommand = (Get("cmd", "") == "search");

        // Load custom filters
        $this->pageFilterLoad();

        // Extended filter
        $extendedFilter = "";

        // Restore filter list
        $this->restoreFilterList();

        // Build extended filter
        $extendedFilter = $this->getExtendedFilter();
        AddFilter($this->SearchWhere, $extendedFilter);

        // Call Page Selecting event
        $this->pageSelecting($this->SearchWhere);

        // Set up search panel class
        if ($this->SearchWhere != "") {
            AppendClass($this->SearchPanelClass, "show");
        }

        // Get sort
        $this->Sort = $this->getSort();

        // Search options
        $this->setupSearchOptions();

        // Update filter
        AddFilter($this->Filter, $this->SearchWhere);

        // Get total count
        $sql = $this->buildReportSql($this->getSqlSelect(), $this->getSqlFrom(), $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), "", $this->Filter, "");
        $this->TotalGroups = $this->getRecordCount($sql);
        if ($this->DisplayGroups <= 0 || $this->DrillDown || $DashboardReport) { // Display all groups
            $this->DisplayGroups = $this->TotalGroups;
        }
        $this->StartGroup = 1;

        // Show header
        $this->ShowHeader = ($this->TotalGroups > 0);

        // Set up start position if not export all
        if ($this->ExportAll && $this->isExport()) {
            $this->DisplayGroups = $this->TotalGroups;
        } else {
            $this->setupStartGroup();
        }

        // Set no record found message
        if ($this->TotalGroups == 0) {
            if ($Security->canList()) {
                if ($this->SearchWhere == "0=101") {
                    $this->setWarningMessage($Language->phrase("EnterSearchCriteria"));
                } else {
                    $this->setWarningMessage($Language->phrase("NoRecord"));
                }
            } else {
                $this->setWarningMessage(DeniedMessage());
            }
        }

        // Hide export options if export/dashboard report/hide options
        if ($this->isExport() || $DashboardReport || $this->HideOptions) {
            $this->ExportOptions->hideAllOptions();
        }

        // Hide search/filter options if export/drilldown/dashboard report/hide options
        if ($this->isExport() || $this->DrillDown || $DashboardReport || $this->HideOptions) {
            $this->SearchOptions->hideAllOptions();
            $this->FilterOptions->hideAllOptions();
        }

        // Get current page records
        if ($this->TotalGroups > 0) {
            $sql = $this->buildReportSql($this->getSqlSelect(), $this->getSqlFrom(), $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), "", $this->Filter, $this->Sort);
            $rs = $sql->setFirstResult($this->StartGroup - 1)->setMaxResults($this->DisplayGroups)->execute();
            $this->DetailRecords = $rs->fetchAll(); // Get records
            $this->GroupCount = 1;
        }
        $this->setupFieldCount();

        // Set the last group to display if not export all
        if ($this->ExportAll && $this->isExport()) {
            $this->StopGroup = $this->TotalGroups;
        } else {
            $this->StopGroup = $this->StartGroup + $this->DisplayGroups - 1;
        }

        // Stop group <= total number of groups
        if (intval($this->StopGroup) > intval($this->TotalGroups)) {
            $this->StopGroup = $this->TotalGroups;
        }
        $this->RecordCount = 0;
        $this->RecordIndex = 0;
        $this->setGroupCount($this->StopGroup - $this->StartGroup + 1, 1);

        // Set up pager
        $this->Pager = new PrevNextPager($this->StartGroup, $this->getGroupPerPage(), $this->TotalGroups, $this->PageSizes, $this->GroupRange, $this->AutoHidePager, $this->AutoHidePageSizeSelector);

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

    // Load row values
    public function loadRowValues($record)
    {
        $data = [];
        $data["NO_REGISTRATION"] = $record['NO_REGISTRATION'];
        $data["GENDER"] = $record['GENDER'];
        $data["CLASS_ROOM_ID"] = $record['CLASS_ROOM_ID'];
        $data["BED_ID"] = $record['BED_ID'];
        $data["SERVED_INAP"] = $record['SERVED_INAP'];
        $data["STATUS_PASIEN_ID"] = $record['STATUS_PASIEN_ID'];
        $data["ISRJ"] = $record['ISRJ'];
        $data["VISIT_ID"] = $record['VISIT_ID'];
        $data["IDXDAFTAR"] = $record['IDXDAFTAR'];
        $data["DIANTAR_OLEH"] = $record['DIANTAR_OLEH'];
        $data["EXIT_DATE"] = $record['EXIT_DATE'];
        $data["KELUAR_ID"] = $record['KELUAR_ID'];
        $data["AGEYEAR"] = $record['AGEYEAR'];
        $data["ORG_UNIT_CODE"] = $record['ORG_UNIT_CODE'];
        $data["RUJUKAN_ID"] = $record['RUJUKAN_ID'];
        $data["ADDRESS_OF_RUJUKAN"] = $record['ADDRESS_OF_RUJUKAN'];
        $data["REASON_ID"] = $record['REASON_ID'];
        $data["WAY_ID"] = $record['WAY_ID'];
        $data["PATIENT_CATEGORY_ID"] = $record['PATIENT_CATEGORY_ID'];
        $data["BOOKED_DATE"] = $record['BOOKED_DATE'];
        $data["VISIT_DATE"] = $record['VISIT_DATE'];
        $data["ISNEW"] = $record['ISNEW'];
        $data["FOLLOW_UP"] = $record['FOLLOW_UP'];
        $data["PLACE_TYPE"] = $record['PLACE_TYPE'];
        $data["CLINIC_ID"] = $record['CLINIC_ID'];
        $data["CLINIC_ID_FROM"] = $record['CLINIC_ID_FROM'];
        $data["IN_DATE"] = $record['IN_DATE'];
        $data["DESCRIPTION"] = $record['DESCRIPTION'];
        $data["VISITOR_ADDRESS"] = $record['VISITOR_ADDRESS'];
        $data["MODIFIED_BY"] = $record['MODIFIED_BY'];
        $data["MODIFIED_DATE"] = $record['MODIFIED_DATE'];
        $data["MODIFIED_FROM"] = $record['MODIFIED_FROM'];
        $data["EMPLOYEE_ID"] = $record['EMPLOYEE_ID'];
        $data["EMPLOYEE_ID_FROM"] = $record['EMPLOYEE_ID_FROM'];
        $data["RESPONSIBLE_ID"] = $record['RESPONSIBLE_ID'];
        $data["RESPONSIBLE"] = $record['RESPONSIBLE'];
        $data["FAMILY_STATUS_ID"] = $record['FAMILY_STATUS_ID'];
        $data["TICKET_NO"] = $record['TICKET_NO'];
        $data["ISATTENDED"] = $record['ISATTENDED'];
        $data["PAYOR_ID"] = $record['PAYOR_ID'];
        $data["CLASS_ID"] = $record['CLASS_ID'];
        $data["ISPERTARIF"] = $record['ISPERTARIF'];
        $data["KAL_ID"] = $record['KAL_ID'];
        $data["EMPLOYEE_INAP"] = $record['EMPLOYEE_INAP'];
        $data["PASIEN_ID"] = $record['PASIEN_ID'];
        $data["KARYAWAN"] = $record['KARYAWAN'];
        $data["ACCOUNT_ID"] = $record['ACCOUNT_ID'];
        $data["CLASS_ID_PLAFOND"] = $record['CLASS_ID_PLAFOND'];
        $data["BACKCHARGE"] = $record['BACKCHARGE'];
        $data["COVERAGE_ID"] = $record['COVERAGE_ID'];
        $data["AGEMONTH"] = $record['AGEMONTH'];
        $data["AGEDAY"] = $record['AGEDAY'];
        $data["RECOMENDATION"] = $record['RECOMENDATION'];
        $data["CONCLUSION"] = $record['CONCLUSION'];
        $data["SPECIMENNO"] = $record['SPECIMENNO'];
        $data["LOCKED"] = $record['LOCKED'];
        $data["RM_OUT_DATE"] = $record['RM_OUT_DATE'];
        $data["RM_IN_DATE"] = $record['RM_IN_DATE'];
        $data["LAMA_PINJAM"] = $record['LAMA_PINJAM'];
        $data["STANDAR_RJ"] = $record['STANDAR_RJ'];
        $data["LENGKAP_RJ"] = $record['LENGKAP_RJ'];
        $data["LENGKAP_RI"] = $record['LENGKAP_RI'];
        $data["RESEND_RM_DATE"] = $record['RESEND_RM_DATE'];
        $data["LENGKAP_RM1"] = $record['LENGKAP_RM1'];
        $data["LENGKAP_RESUME"] = $record['LENGKAP_RESUME'];
        $data["LENGKAP_ANAMNESIS"] = $record['LENGKAP_ANAMNESIS'];
        $data["LENGKAP_CONSENT"] = $record['LENGKAP_CONSENT'];
        $data["LENGKAP_ANESTESI"] = $record['LENGKAP_ANESTESI'];
        $data["LENGKAP_OP"] = $record['LENGKAP_OP'];
        $data["BACK_RM_DATE"] = $record['BACK_RM_DATE'];
        $data["VALID_RM_DATE"] = $record['VALID_RM_DATE'];
        $data["NO_SKP"] = $record['NO_SKP'];
        $data["NO_SKPINAP"] = $record['NO_SKPINAP'];
        $data["DIAGNOSA_ID"] = $record['DIAGNOSA_ID'];
        $data["ticket_all"] = $record['ticket_all'];
        $data["tanggal_rujukan"] = $record['tanggal_rujukan'];
        $data["NORUJUKAN"] = $record['NORUJUKAN'];
        $data["PPKRUJUKAN"] = $record['PPKRUJUKAN'];
        $data["LOKASILAKA"] = $record['LOKASILAKA'];
        $data["KDPOLI"] = $record['KDPOLI'];
        $data["EDIT_SEP"] = $record['EDIT_SEP'];
        $data["DELETE_SEP"] = $record['DELETE_SEP'];
        $data["KODE_AGAMA"] = $record['KODE_AGAMA'];
        $data["DIAG_AWAL"] = $record['DIAG_AWAL'];
        $data["AKTIF"] = $record['AKTIF'];
        $data["BILL_INAP"] = $record['BILL_INAP'];
        $data["SEP_PRINTDATE"] = $record['SEP_PRINTDATE'];
        $data["MAPPING_SEP"] = $record['MAPPING_SEP'];
        $data["TRANS_ID"] = $record['TRANS_ID'];
        $data["KDPOLI_EKS"] = $record['KDPOLI_EKS'];
        $data["COB"] = $record['COB'];
        $data["PENJAMIN"] = $record['PENJAMIN'];
        $data["ASALRUJUKAN"] = $record['ASALRUJUKAN'];
        $data["RESPONSEP"] = $record['RESPONSEP'];
        $data["APPROVAL_DESC"] = $record['APPROVAL_DESC'];
        $data["APPROVAL_RESPONAJUKAN"] = $record['APPROVAL_RESPONAJUKAN'];
        $data["APPROVAL_RESPONAPPROV"] = $record['APPROVAL_RESPONAPPROV'];
        $data["RESPONTGLPLG_DESC"] = $record['RESPONTGLPLG_DESC'];
        $data["RESPONPOST_VKLAIM"] = $record['RESPONPOST_VKLAIM'];
        $data["RESPONPUT_VKLAIM"] = $record['RESPONPUT_VKLAIM'];
        $data["RESPONDEL_VKLAIM"] = $record['RESPONDEL_VKLAIM'];
        $data["CALL_TIMES"] = $record['CALL_TIMES'];
        $data["CALL_DATE"] = $record['CALL_DATE'];
        $data["CALL_DATES"] = $record['CALL_DATES'];
        $data["SERVED_DATE"] = $record['SERVED_DATE'];
        $data["KDDPJP1"] = $record['KDDPJP1'];
        $data["KDDPJP"] = $record['KDDPJP'];
        $data["tgl_kontrol"] = $record['tgl_kontrol'];
        $this->Rows[] = $data;
        $this->NO_REGISTRATION->setDbValue($record['NO_REGISTRATION']);
        $this->GENDER->setDbValue($record['GENDER']);
        $this->CLASS_ROOM_ID->setDbValue($record['CLASS_ROOM_ID']);
        $this->BED_ID->setDbValue($record['BED_ID']);
        $this->SERVED_INAP->setDbValue($record['SERVED_INAP']);
        $this->STATUS_PASIEN_ID->setDbValue($record['STATUS_PASIEN_ID']);
        $this->ISRJ->setDbValue($record['ISRJ']);
        $this->VISIT_ID->setDbValue($record['VISIT_ID']);
        $this->IDXDAFTAR->setDbValue($record['IDXDAFTAR']);
        $this->DIANTAR_OLEH->setDbValue($record['DIANTAR_OLEH']);
        $this->EXIT_DATE->setDbValue($record['EXIT_DATE']);
        $this->KELUAR_ID->setDbValue($record['KELUAR_ID']);
        $this->AGEYEAR->setDbValue($record['AGEYEAR']);
        $this->ORG_UNIT_CODE->setDbValue($record['ORG_UNIT_CODE']);
        $this->RUJUKAN_ID->setDbValue($record['RUJUKAN_ID']);
        $this->ADDRESS_OF_RUJUKAN->setDbValue($record['ADDRESS_OF_RUJUKAN']);
        $this->REASON_ID->setDbValue($record['REASON_ID']);
        $this->WAY_ID->setDbValue($record['WAY_ID']);
        $this->PATIENT_CATEGORY_ID->setDbValue($record['PATIENT_CATEGORY_ID']);
        $this->BOOKED_DATE->setDbValue($record['BOOKED_DATE']);
        $this->VISIT_DATE->setDbValue($record['VISIT_DATE']);
        $this->ISNEW->setDbValue($record['ISNEW']);
        $this->FOLLOW_UP->setDbValue($record['FOLLOW_UP']);
        $this->PLACE_TYPE->setDbValue($record['PLACE_TYPE']);
        $this->CLINIC_ID->setDbValue($record['CLINIC_ID']);
        $this->CLINIC_ID_FROM->setDbValue($record['CLINIC_ID_FROM']);
        $this->IN_DATE->setDbValue($record['IN_DATE']);
        $this->DESCRIPTION->setDbValue($record['DESCRIPTION']);
        $this->VISITOR_ADDRESS->setDbValue($record['VISITOR_ADDRESS']);
        $this->MODIFIED_BY->setDbValue($record['MODIFIED_BY']);
        $this->MODIFIED_DATE->setDbValue($record['MODIFIED_DATE']);
        $this->MODIFIED_FROM->setDbValue($record['MODIFIED_FROM']);
        $this->EMPLOYEE_ID->setDbValue($record['EMPLOYEE_ID']);
        $this->EMPLOYEE_ID_FROM->setDbValue($record['EMPLOYEE_ID_FROM']);
        $this->RESPONSIBLE_ID->setDbValue($record['RESPONSIBLE_ID']);
        $this->RESPONSIBLE->setDbValue($record['RESPONSIBLE']);
        $this->FAMILY_STATUS_ID->setDbValue($record['FAMILY_STATUS_ID']);
        $this->TICKET_NO->setDbValue($record['TICKET_NO']);
        $this->ISATTENDED->setDbValue($record['ISATTENDED']);
        $this->PAYOR_ID->setDbValue($record['PAYOR_ID']);
        $this->CLASS_ID->setDbValue($record['CLASS_ID']);
        $this->ISPERTARIF->setDbValue($record['ISPERTARIF']);
        $this->KAL_ID->setDbValue($record['KAL_ID']);
        $this->EMPLOYEE_INAP->setDbValue($record['EMPLOYEE_INAP']);
        $this->PASIEN_ID->setDbValue($record['PASIEN_ID']);
        $this->KARYAWAN->setDbValue($record['KARYAWAN']);
        $this->ACCOUNT_ID->setDbValue($record['ACCOUNT_ID']);
        $this->CLASS_ID_PLAFOND->setDbValue($record['CLASS_ID_PLAFOND']);
        $this->BACKCHARGE->setDbValue($record['BACKCHARGE']);
        $this->COVERAGE_ID->setDbValue($record['COVERAGE_ID']);
        $this->AGEMONTH->setDbValue($record['AGEMONTH']);
        $this->AGEDAY->setDbValue($record['AGEDAY']);
        $this->RECOMENDATION->setDbValue($record['RECOMENDATION']);
        $this->CONCLUSION->setDbValue($record['CONCLUSION']);
        $this->SPECIMENNO->setDbValue($record['SPECIMENNO']);
        $this->LOCKED->setDbValue($record['LOCKED']);
        $this->RM_OUT_DATE->setDbValue($record['RM_OUT_DATE']);
        $this->RM_IN_DATE->setDbValue($record['RM_IN_DATE']);
        $this->LAMA_PINJAM->setDbValue($record['LAMA_PINJAM']);
        $this->STANDAR_RJ->setDbValue($record['STANDAR_RJ']);
        $this->LENGKAP_RJ->setDbValue($record['LENGKAP_RJ']);
        $this->LENGKAP_RI->setDbValue($record['LENGKAP_RI']);
        $this->RESEND_RM_DATE->setDbValue($record['RESEND_RM_DATE']);
        $this->LENGKAP_RM1->setDbValue($record['LENGKAP_RM1']);
        $this->LENGKAP_RESUME->setDbValue($record['LENGKAP_RESUME']);
        $this->LENGKAP_ANAMNESIS->setDbValue($record['LENGKAP_ANAMNESIS']);
        $this->LENGKAP_CONSENT->setDbValue($record['LENGKAP_CONSENT']);
        $this->LENGKAP_ANESTESI->setDbValue($record['LENGKAP_ANESTESI']);
        $this->LENGKAP_OP->setDbValue($record['LENGKAP_OP']);
        $this->BACK_RM_DATE->setDbValue($record['BACK_RM_DATE']);
        $this->VALID_RM_DATE->setDbValue($record['VALID_RM_DATE']);
        $this->NO_SKP->setDbValue($record['NO_SKP']);
        $this->NO_SKPINAP->setDbValue($record['NO_SKPINAP']);
        $this->DIAGNOSA_ID->setDbValue($record['DIAGNOSA_ID']);
        $this->ticket_all->setDbValue($record['ticket_all']);
        $this->tanggal_rujukan->setDbValue($record['tanggal_rujukan']);
        $this->NORUJUKAN->setDbValue($record['NORUJUKAN']);
        $this->PPKRUJUKAN->setDbValue($record['PPKRUJUKAN']);
        $this->LOKASILAKA->setDbValue($record['LOKASILAKA']);
        $this->KDPOLI->setDbValue($record['KDPOLI']);
        $this->EDIT_SEP->setDbValue($record['EDIT_SEP']);
        $this->DELETE_SEP->setDbValue($record['DELETE_SEP']);
        $this->KODE_AGAMA->setDbValue($record['KODE_AGAMA']);
        $this->DIAG_AWAL->setDbValue($record['DIAG_AWAL']);
        $this->AKTIF->setDbValue($record['AKTIF']);
        $this->BILL_INAP->setDbValue($record['BILL_INAP']);
        $this->SEP_PRINTDATE->setDbValue($record['SEP_PRINTDATE']);
        $this->MAPPING_SEP->setDbValue($record['MAPPING_SEP']);
        $this->TRANS_ID->setDbValue($record['TRANS_ID']);
        $this->KDPOLI_EKS->setDbValue($record['KDPOLI_EKS']);
        $this->COB->setDbValue($record['COB']);
        $this->PENJAMIN->setDbValue($record['PENJAMIN']);
        $this->ASALRUJUKAN->setDbValue($record['ASALRUJUKAN']);
        $this->RESPONSEP->setDbValue($record['RESPONSEP']);
        $this->APPROVAL_DESC->setDbValue($record['APPROVAL_DESC']);
        $this->APPROVAL_RESPONAJUKAN->setDbValue($record['APPROVAL_RESPONAJUKAN']);
        $this->APPROVAL_RESPONAPPROV->setDbValue($record['APPROVAL_RESPONAPPROV']);
        $this->RESPONTGLPLG_DESC->setDbValue($record['RESPONTGLPLG_DESC']);
        $this->RESPONPOST_VKLAIM->setDbValue($record['RESPONPOST_VKLAIM']);
        $this->RESPONPUT_VKLAIM->setDbValue($record['RESPONPUT_VKLAIM']);
        $this->RESPONDEL_VKLAIM->setDbValue($record['RESPONDEL_VKLAIM']);
        $this->CALL_TIMES->setDbValue($record['CALL_TIMES']);
        $this->CALL_DATE->setDbValue($record['CALL_DATE']);
        $this->CALL_DATES->setDbValue($record['CALL_DATES']);
        $this->SERVED_DATE->setDbValue($record['SERVED_DATE']);
        $this->KDDPJP1->setDbValue($record['KDDPJP1']);
        $this->KDDPJP->setDbValue($record['KDDPJP']);
        $this->tgl_kontrol->setDbValue($record['tgl_kontrol']);
    }

    // Render row
    public function renderRow()
    {
        global $Security, $Language, $Language;
        $conn = $this->getConnection();
        if ($this->RowType == ROWTYPE_TOTAL && $this->RowTotalSubType == ROWTOTAL_FOOTER && $this->RowTotalType == ROWTOTAL_PAGE) { // Get Page total
            $records = &$this->DetailRecords;
            $this->IDXDAFTAR->getCnt($records);
            $this->PageTotalCount = count($records);
        } elseif ($this->RowType == ROWTYPE_TOTAL && $this->RowTotalSubType == ROWTOTAL_FOOTER && $this->RowTotalType == ROWTOTAL_GRAND) { // Get Grand total
            $hasCount = false;
            $hasSummary = false;

            // Get total count from SQL directly
            $sql = $this->buildReportSql($this->getSqlSelectCount(), $this->getSqlFrom(), $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), "", $this->Filter, "");
            $rstot = $conn->executeQuery($sql);
            if ($rstot && $cnt = $rstot->fetchColumn()) {
                $rstot->closeCursor();
                $hasCount = true;
            } else {
                $cnt = 0;
            }
            $this->TotalCount = $cnt;

            // Get total from SQL directly
            $sql = $this->buildReportSql($this->getSqlSelectAggregate(), $this->getSqlFrom(), $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), "", $this->Filter, "");
            $sql = $this->getSqlAggregatePrefix() . $sql . $this->getSqlAggregateSuffix();
            $rsagg = $conn->fetchAssoc($sql);
            if ($rsagg) {
                $this->NO_REGISTRATION->Count = $this->TotalCount;
                $this->GENDER->Count = $this->TotalCount;
                $this->CLASS_ROOM_ID->Count = $this->TotalCount;
                $this->BED_ID->Count = $this->TotalCount;
                $this->SERVED_INAP->Count = $this->TotalCount;
                $this->STATUS_PASIEN_ID->Count = $this->TotalCount;
                $this->ISRJ->Count = $this->TotalCount;
                $this->VISIT_ID->Count = $this->TotalCount;
                $this->IDXDAFTAR->Count = $this->TotalCount;
                $this->IDXDAFTAR->CntValue = $rsagg["cnt_idxdaftar"];
                $this->DIANTAR_OLEH->Count = $this->TotalCount;
                $this->EXIT_DATE->Count = $this->TotalCount;
                $this->KELUAR_ID->Count = $this->TotalCount;
                $this->AGEYEAR->Count = $this->TotalCount;
                $this->ORG_UNIT_CODE->Count = $this->TotalCount;
                $this->RUJUKAN_ID->Count = $this->TotalCount;
                $this->ADDRESS_OF_RUJUKAN->Count = $this->TotalCount;
                $this->REASON_ID->Count = $this->TotalCount;
                $this->WAY_ID->Count = $this->TotalCount;
                $this->PATIENT_CATEGORY_ID->Count = $this->TotalCount;
                $this->BOOKED_DATE->Count = $this->TotalCount;
                $this->VISIT_DATE->Count = $this->TotalCount;
                $this->ISNEW->Count = $this->TotalCount;
                $this->FOLLOW_UP->Count = $this->TotalCount;
                $this->PLACE_TYPE->Count = $this->TotalCount;
                $this->CLINIC_ID->Count = $this->TotalCount;
                $this->CLINIC_ID_FROM->Count = $this->TotalCount;
                $this->IN_DATE->Count = $this->TotalCount;
                $this->DESCRIPTION->Count = $this->TotalCount;
                $this->VISITOR_ADDRESS->Count = $this->TotalCount;
                $this->MODIFIED_BY->Count = $this->TotalCount;
                $this->MODIFIED_DATE->Count = $this->TotalCount;
                $this->MODIFIED_FROM->Count = $this->TotalCount;
                $this->EMPLOYEE_ID->Count = $this->TotalCount;
                $this->EMPLOYEE_ID_FROM->Count = $this->TotalCount;
                $this->RESPONSIBLE_ID->Count = $this->TotalCount;
                $this->RESPONSIBLE->Count = $this->TotalCount;
                $this->FAMILY_STATUS_ID->Count = $this->TotalCount;
                $this->TICKET_NO->Count = $this->TotalCount;
                $this->ISATTENDED->Count = $this->TotalCount;
                $this->PAYOR_ID->Count = $this->TotalCount;
                $this->CLASS_ID->Count = $this->TotalCount;
                $this->ISPERTARIF->Count = $this->TotalCount;
                $this->KAL_ID->Count = $this->TotalCount;
                $this->EMPLOYEE_INAP->Count = $this->TotalCount;
                $this->PASIEN_ID->Count = $this->TotalCount;
                $this->KARYAWAN->Count = $this->TotalCount;
                $this->ACCOUNT_ID->Count = $this->TotalCount;
                $this->CLASS_ID_PLAFOND->Count = $this->TotalCount;
                $this->BACKCHARGE->Count = $this->TotalCount;
                $this->COVERAGE_ID->Count = $this->TotalCount;
                $this->AGEMONTH->Count = $this->TotalCount;
                $this->AGEDAY->Count = $this->TotalCount;
                $this->RECOMENDATION->Count = $this->TotalCount;
                $this->CONCLUSION->Count = $this->TotalCount;
                $this->SPECIMENNO->Count = $this->TotalCount;
                $this->LOCKED->Count = $this->TotalCount;
                $this->RM_OUT_DATE->Count = $this->TotalCount;
                $this->RM_IN_DATE->Count = $this->TotalCount;
                $this->LAMA_PINJAM->Count = $this->TotalCount;
                $this->STANDAR_RJ->Count = $this->TotalCount;
                $this->LENGKAP_RJ->Count = $this->TotalCount;
                $this->LENGKAP_RI->Count = $this->TotalCount;
                $this->RESEND_RM_DATE->Count = $this->TotalCount;
                $this->LENGKAP_RM1->Count = $this->TotalCount;
                $this->LENGKAP_RESUME->Count = $this->TotalCount;
                $this->LENGKAP_ANAMNESIS->Count = $this->TotalCount;
                $this->LENGKAP_CONSENT->Count = $this->TotalCount;
                $this->LENGKAP_ANESTESI->Count = $this->TotalCount;
                $this->LENGKAP_OP->Count = $this->TotalCount;
                $this->BACK_RM_DATE->Count = $this->TotalCount;
                $this->VALID_RM_DATE->Count = $this->TotalCount;
                $this->NO_SKP->Count = $this->TotalCount;
                $this->NO_SKPINAP->Count = $this->TotalCount;
                $this->DIAGNOSA_ID->Count = $this->TotalCount;
                $this->ticket_all->Count = $this->TotalCount;
                $this->tanggal_rujukan->Count = $this->TotalCount;
                $this->NORUJUKAN->Count = $this->TotalCount;
                $this->PPKRUJUKAN->Count = $this->TotalCount;
                $this->LOKASILAKA->Count = $this->TotalCount;
                $this->KDPOLI->Count = $this->TotalCount;
                $this->EDIT_SEP->Count = $this->TotalCount;
                $this->DELETE_SEP->Count = $this->TotalCount;
                $this->KODE_AGAMA->Count = $this->TotalCount;
                $this->DIAG_AWAL->Count = $this->TotalCount;
                $this->AKTIF->Count = $this->TotalCount;
                $this->BILL_INAP->Count = $this->TotalCount;
                $this->SEP_PRINTDATE->Count = $this->TotalCount;
                $this->MAPPING_SEP->Count = $this->TotalCount;
                $this->TRANS_ID->Count = $this->TotalCount;
                $this->KDPOLI_EKS->Count = $this->TotalCount;
                $this->COB->Count = $this->TotalCount;
                $this->PENJAMIN->Count = $this->TotalCount;
                $this->ASALRUJUKAN->Count = $this->TotalCount;
                $this->RESPONSEP->Count = $this->TotalCount;
                $this->APPROVAL_DESC->Count = $this->TotalCount;
                $this->APPROVAL_RESPONAJUKAN->Count = $this->TotalCount;
                $this->APPROVAL_RESPONAPPROV->Count = $this->TotalCount;
                $this->RESPONTGLPLG_DESC->Count = $this->TotalCount;
                $this->RESPONPOST_VKLAIM->Count = $this->TotalCount;
                $this->RESPONPUT_VKLAIM->Count = $this->TotalCount;
                $this->RESPONDEL_VKLAIM->Count = $this->TotalCount;
                $this->CALL_TIMES->Count = $this->TotalCount;
                $this->CALL_DATE->Count = $this->TotalCount;
                $this->CALL_DATES->Count = $this->TotalCount;
                $this->SERVED_DATE->Count = $this->TotalCount;
                $this->KDDPJP1->Count = $this->TotalCount;
                $this->KDDPJP->Count = $this->TotalCount;
                $this->tgl_kontrol->Count = $this->TotalCount;
                $hasSummary = true;
            }

            // Accumulate grand summary from detail records
            if (!$hasCount || !$hasSummary) {
                $sql = $this->buildReportSql($this->getSqlSelect(), $this->getSqlFrom(), $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), "", $this->Filter, "");
                $rs = $sql->execute();
                $this->DetailRecords = $rs ? $rs->fetchAll() : [];
                $this->IDXDAFTAR->getCnt($this->DetailRecords);
            }
        }

        // Call Row_Rendering event
        $this->rowRendering();

        // NO_REGISTRATION
        $this->NO_REGISTRATION->CellCssStyle = "white-space: nowrap;";

        // GENDER
        $this->GENDER->CellCssStyle = "white-space: nowrap;";

        // CLASS_ROOM_ID
        $this->CLASS_ROOM_ID->CellCssStyle = "white-space: nowrap;";

        // BED_ID

        // SERVED_INAP

        // STATUS_PASIEN_ID

        // ISRJ
        $this->ISRJ->CellCssStyle = "white-space: nowrap;";

        // VISIT_ID
        $this->VISIT_ID->CellCssStyle = "white-space: nowrap;";

        // IDXDAFTAR
        $this->IDXDAFTAR->CellCssStyle = "white-space: nowrap;";

        // DIANTAR_OLEH
        $this->DIANTAR_OLEH->CellCssStyle = "white-space: nowrap;";

        // EXIT_DATE

        // KELUAR_ID

        // AGEYEAR

        // ORG_UNIT_CODE

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

        // IN_DATE

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

        // KDDPJP1

        // KDDPJP

        // tgl_kontrol
        if ($this->RowType == ROWTYPE_SEARCH) {
            // CLASS_ROOM_ID
            $this->CLASS_ROOM_ID->EditAttrs["class"] = "form-control";
            $this->CLASS_ROOM_ID->EditCustomAttributes = "";
            $curVal = $this->CLASS_ROOM_ID->AdvancedSearch->SearchValue == INIT_VALUE ? "" : trim(strval($this->CLASS_ROOM_ID->AdvancedSearch->SearchValue));
            if ($curVal != "") {
                $this->CLASS_ROOM_ID->AdvancedSearch->ViewValue = $this->CLASS_ROOM_ID->lookupCacheOption($curVal);
            } else {
                $this->CLASS_ROOM_ID->AdvancedSearch->ViewValue = $this->CLASS_ROOM_ID->Lookup !== null && is_array($this->CLASS_ROOM_ID->Lookup->Options) ? $curVal : null;
            }
            if ($this->CLASS_ROOM_ID->AdvancedSearch->ViewValue !== null) { // Load from cache
                $this->CLASS_ROOM_ID->EditValue = array_values($this->CLASS_ROOM_ID->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "[CLASS_ROOM_ID]" . SearchString("=", $this->CLASS_ROOM_ID->AdvancedSearch->SearchValue, DATATYPE_STRING, "");
                }
                $sqlWrk = $this->CLASS_ROOM_ID->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->CLASS_ROOM_ID->EditValue = $arwrk;
            }
            $this->CLASS_ROOM_ID->PlaceHolder = RemoveHtml($this->CLASS_ROOM_ID->caption());

            // SERVED_INAP
            $this->SERVED_INAP->EditAttrs["class"] = "form-control";
            $this->SERVED_INAP->EditCustomAttributes = "";
            $this->SERVED_INAP->EditValue = HtmlEncode(FormatDateTime(UnFormatDateTime($this->SERVED_INAP->AdvancedSearch->SearchValue, 7), 7));
            $this->SERVED_INAP->PlaceHolder = RemoveHtml($this->SERVED_INAP->caption());
        } elseif ($this->RowType == ROWTYPE_TOTAL && !($this->RowTotalType == ROWTOTAL_GROUP && $this->RowTotalSubType == ROWTOTAL_HEADER)) { // Summary row
            $this->RowAttrs->prependClass(($this->RowTotalType == ROWTOTAL_PAGE || $this->RowTotalType == ROWTOTAL_GRAND) ? "ew-rpt-grp-aggregate" : ""); // Set up row class

            // IDXDAFTAR
            $this->IDXDAFTAR->CntViewValue = $this->IDXDAFTAR->CntValue;
            $this->IDXDAFTAR->CntViewValue = FormatNumber($this->IDXDAFTAR->CntViewValue, 0, -2, -2, -2);
            $this->IDXDAFTAR->ViewCustomAttributes = "";
            $this->IDXDAFTAR->CellAttrs["class"] = ($this->RowTotalType == ROWTOTAL_PAGE || $this->RowTotalType == ROWTOTAL_GRAND) ? "ew-rpt-grp-aggregate" : "ew-rpt-grp-summary-" . $this->RowGroupLevel;

            // NO_REGISTRATION
            $this->NO_REGISTRATION->HrefValue = "";

            // GENDER
            $this->GENDER->HrefValue = "";

            // CLASS_ROOM_ID
            $this->CLASS_ROOM_ID->HrefValue = "";

            // BED_ID
            $this->BED_ID->HrefValue = "";

            // SERVED_INAP
            $this->SERVED_INAP->HrefValue = "";

            // STATUS_PASIEN_ID
            $this->STATUS_PASIEN_ID->HrefValue = "";

            // ISRJ
            $this->ISRJ->HrefValue = "";

            // VISIT_ID
            $this->VISIT_ID->HrefValue = "";

            // IDXDAFTAR
            $this->IDXDAFTAR->HrefValue = "";

            // DIANTAR_OLEH
            $this->DIANTAR_OLEH->HrefValue = "";

            // EXIT_DATE
            $this->EXIT_DATE->HrefValue = "";

            // KELUAR_ID
            $this->KELUAR_ID->HrefValue = "";

            // AGEYEAR
            $this->AGEYEAR->HrefValue = "";

            // ORG_UNIT_CODE
            $this->ORG_UNIT_CODE->HrefValue = "";

            // RUJUKAN_ID
            $this->RUJUKAN_ID->HrefValue = "";

            // ADDRESS_OF_RUJUKAN
            $this->ADDRESS_OF_RUJUKAN->HrefValue = "";

            // REASON_ID
            $this->REASON_ID->HrefValue = "";

            // WAY_ID
            $this->WAY_ID->HrefValue = "";

            // PATIENT_CATEGORY_ID
            $this->PATIENT_CATEGORY_ID->HrefValue = "";

            // BOOKED_DATE
            $this->BOOKED_DATE->HrefValue = "";

            // VISIT_DATE
            $this->VISIT_DATE->HrefValue = "";

            // ISNEW
            $this->ISNEW->HrefValue = "";

            // FOLLOW_UP
            $this->FOLLOW_UP->HrefValue = "";

            // PLACE_TYPE
            $this->PLACE_TYPE->HrefValue = "";

            // CLINIC_ID
            $this->CLINIC_ID->HrefValue = "";

            // CLINIC_ID_FROM
            $this->CLINIC_ID_FROM->HrefValue = "";

            // IN_DATE
            $this->IN_DATE->HrefValue = "";

            // DESCRIPTION
            $this->DESCRIPTION->HrefValue = "";

            // VISITOR_ADDRESS
            $this->VISITOR_ADDRESS->HrefValue = "";

            // MODIFIED_BY
            $this->MODIFIED_BY->HrefValue = "";

            // MODIFIED_DATE
            $this->MODIFIED_DATE->HrefValue = "";

            // MODIFIED_FROM
            $this->MODIFIED_FROM->HrefValue = "";

            // EMPLOYEE_ID
            $this->EMPLOYEE_ID->HrefValue = "";

            // EMPLOYEE_ID_FROM
            $this->EMPLOYEE_ID_FROM->HrefValue = "";

            // RESPONSIBLE_ID
            $this->RESPONSIBLE_ID->HrefValue = "";

            // RESPONSIBLE
            $this->RESPONSIBLE->HrefValue = "";

            // FAMILY_STATUS_ID
            $this->FAMILY_STATUS_ID->HrefValue = "";

            // TICKET_NO
            $this->TICKET_NO->HrefValue = "";

            // ISATTENDED
            $this->ISATTENDED->HrefValue = "";

            // PAYOR_ID
            $this->PAYOR_ID->HrefValue = "";

            // CLASS_ID
            $this->CLASS_ID->HrefValue = "";

            // ISPERTARIF
            $this->ISPERTARIF->HrefValue = "";

            // KAL_ID
            $this->KAL_ID->HrefValue = "";

            // EMPLOYEE_INAP
            $this->EMPLOYEE_INAP->HrefValue = "";

            // PASIEN_ID
            $this->PASIEN_ID->HrefValue = "";

            // KARYAWAN
            $this->KARYAWAN->HrefValue = "";

            // ACCOUNT_ID
            $this->ACCOUNT_ID->HrefValue = "";

            // CLASS_ID_PLAFOND
            $this->CLASS_ID_PLAFOND->HrefValue = "";

            // BACKCHARGE
            $this->BACKCHARGE->HrefValue = "";

            // COVERAGE_ID
            $this->COVERAGE_ID->HrefValue = "";

            // AGEMONTH
            $this->AGEMONTH->HrefValue = "";

            // AGEDAY
            $this->AGEDAY->HrefValue = "";

            // RECOMENDATION
            $this->RECOMENDATION->HrefValue = "";

            // CONCLUSION
            $this->CONCLUSION->HrefValue = "";

            // SPECIMENNO
            $this->SPECIMENNO->HrefValue = "";

            // LOCKED
            $this->LOCKED->HrefValue = "";

            // RM_OUT_DATE
            $this->RM_OUT_DATE->HrefValue = "";

            // RM_IN_DATE
            $this->RM_IN_DATE->HrefValue = "";

            // LAMA_PINJAM
            $this->LAMA_PINJAM->HrefValue = "";

            // STANDAR_RJ
            $this->STANDAR_RJ->HrefValue = "";

            // LENGKAP_RJ
            $this->LENGKAP_RJ->HrefValue = "";

            // LENGKAP_RI
            $this->LENGKAP_RI->HrefValue = "";

            // RESEND_RM_DATE
            $this->RESEND_RM_DATE->HrefValue = "";

            // LENGKAP_RM1
            $this->LENGKAP_RM1->HrefValue = "";

            // LENGKAP_RESUME
            $this->LENGKAP_RESUME->HrefValue = "";

            // LENGKAP_ANAMNESIS
            $this->LENGKAP_ANAMNESIS->HrefValue = "";

            // LENGKAP_CONSENT
            $this->LENGKAP_CONSENT->HrefValue = "";

            // LENGKAP_ANESTESI
            $this->LENGKAP_ANESTESI->HrefValue = "";

            // LENGKAP_OP
            $this->LENGKAP_OP->HrefValue = "";

            // BACK_RM_DATE
            $this->BACK_RM_DATE->HrefValue = "";

            // VALID_RM_DATE
            $this->VALID_RM_DATE->HrefValue = "";

            // NO_SKP
            $this->NO_SKP->HrefValue = "";

            // NO_SKPINAP
            $this->NO_SKPINAP->HrefValue = "";

            // DIAGNOSA_ID
            $this->DIAGNOSA_ID->HrefValue = "";

            // ticket_all
            $this->ticket_all->HrefValue = "";

            // tanggal_rujukan
            $this->tanggal_rujukan->HrefValue = "";

            // NORUJUKAN
            $this->NORUJUKAN->HrefValue = "";

            // PPKRUJUKAN
            $this->PPKRUJUKAN->HrefValue = "";

            // LOKASILAKA
            $this->LOKASILAKA->HrefValue = "";

            // KDPOLI
            $this->KDPOLI->HrefValue = "";

            // EDIT_SEP
            $this->EDIT_SEP->HrefValue = "";

            // DELETE_SEP
            $this->DELETE_SEP->HrefValue = "";

            // KODE_AGAMA
            $this->KODE_AGAMA->HrefValue = "";

            // DIAG_AWAL
            $this->DIAG_AWAL->HrefValue = "";

            // AKTIF
            $this->AKTIF->HrefValue = "";

            // BILL_INAP
            $this->BILL_INAP->HrefValue = "";

            // SEP_PRINTDATE
            $this->SEP_PRINTDATE->HrefValue = "";

            // MAPPING_SEP
            $this->MAPPING_SEP->HrefValue = "";

            // TRANS_ID
            $this->TRANS_ID->HrefValue = "";

            // KDPOLI_EKS
            $this->KDPOLI_EKS->HrefValue = "";

            // COB
            $this->COB->HrefValue = "";

            // PENJAMIN
            $this->PENJAMIN->HrefValue = "";

            // ASALRUJUKAN
            $this->ASALRUJUKAN->HrefValue = "";

            // RESPONSEP
            $this->RESPONSEP->HrefValue = "";

            // APPROVAL_DESC
            $this->APPROVAL_DESC->HrefValue = "";

            // APPROVAL_RESPONAJUKAN
            $this->APPROVAL_RESPONAJUKAN->HrefValue = "";

            // APPROVAL_RESPONAPPROV
            $this->APPROVAL_RESPONAPPROV->HrefValue = "";

            // RESPONTGLPLG_DESC
            $this->RESPONTGLPLG_DESC->HrefValue = "";

            // RESPONPOST_VKLAIM
            $this->RESPONPOST_VKLAIM->HrefValue = "";

            // RESPONPUT_VKLAIM
            $this->RESPONPUT_VKLAIM->HrefValue = "";

            // RESPONDEL_VKLAIM
            $this->RESPONDEL_VKLAIM->HrefValue = "";

            // CALL_TIMES
            $this->CALL_TIMES->HrefValue = "";

            // CALL_DATE
            $this->CALL_DATE->HrefValue = "";

            // CALL_DATES
            $this->CALL_DATES->HrefValue = "";

            // SERVED_DATE
            $this->SERVED_DATE->HrefValue = "";

            // KDDPJP1
            $this->KDDPJP1->HrefValue = "";

            // KDDPJP
            $this->KDDPJP->HrefValue = "";

            // tgl_kontrol
            $this->tgl_kontrol->HrefValue = "";
        } else {
            if ($this->RowTotalType == ROWTOTAL_GROUP && $this->RowTotalSubType == ROWTOTAL_HEADER) {
            } else {
            }

            // NO_REGISTRATION
            $this->NO_REGISTRATION->ViewValue = $this->NO_REGISTRATION->CurrentValue;
            $curVal = $this->NO_REGISTRATION->CurrentValue == INIT_VALUE ? "" : trim(strval($this->NO_REGISTRATION->CurrentValue));
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
            $this->NO_REGISTRATION->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->NO_REGISTRATION->ViewCustomAttributes = "";

            // GENDER
            $this->GENDER->ViewValue = $this->GENDER->CurrentValue;
            $curVal = $this->GENDER->CurrentValue == INIT_VALUE ? "" : trim(strval($this->GENDER->CurrentValue));
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
            $this->GENDER->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->GENDER->ViewCustomAttributes = "";

            // CLASS_ROOM_ID
            $this->CLASS_ROOM_ID->ViewValue = $this->CLASS_ROOM_ID->CurrentValue;
            $curVal = $this->CLASS_ROOM_ID->CurrentValue == INIT_VALUE ? "" : trim(strval($this->CLASS_ROOM_ID->CurrentValue));
            if ($curVal != "") {
                $this->CLASS_ROOM_ID->ViewValue = $this->CLASS_ROOM_ID->lookupCacheOption($curVal);
                if ($this->CLASS_ROOM_ID->ViewValue === null) { // Lookup from database
                    $filterWrk = "[CLASS_ROOM_ID]" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->CLASS_ROOM_ID->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->CLASS_ROOM_ID->Lookup->renderViewRow($rswrk[0]);
                        $this->CLASS_ROOM_ID->ViewValue = $this->CLASS_ROOM_ID->displayValue($arwrk);
                    } else {
                        $this->CLASS_ROOM_ID->ViewValue = $this->CLASS_ROOM_ID->CurrentValue;
                    }
                }
            } else {
                $this->CLASS_ROOM_ID->ViewValue = null;
            }
            $this->CLASS_ROOM_ID->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->CLASS_ROOM_ID->ViewCustomAttributes = "";

            // BED_ID
            $this->BED_ID->ViewValue = $this->BED_ID->CurrentValue;
            $this->BED_ID->ViewValue = FormatNumber($this->BED_ID->ViewValue, 0, -2, -2, -2);
            $this->BED_ID->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->BED_ID->ViewCustomAttributes = "";

            // SERVED_INAP
            $this->SERVED_INAP->ViewValue = $this->SERVED_INAP->CurrentValue;
            $this->SERVED_INAP->ViewValue = FormatDateTime($this->SERVED_INAP->ViewValue, 7);
            $this->SERVED_INAP->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->SERVED_INAP->ViewCustomAttributes = "";

            // STATUS_PASIEN_ID
            $this->STATUS_PASIEN_ID->ViewValue = $this->STATUS_PASIEN_ID->CurrentValue;
            $curVal = $this->STATUS_PASIEN_ID->CurrentValue == INIT_VALUE ? "" : trim(strval($this->STATUS_PASIEN_ID->CurrentValue));
            if ($curVal != "") {
                $this->STATUS_PASIEN_ID->ViewValue = $this->STATUS_PASIEN_ID->lookupCacheOption($curVal);
                if ($this->STATUS_PASIEN_ID->ViewValue === null) { // Lookup from database
                    $filterWrk = "[STATUS_PASIEN_ID]" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->STATUS_PASIEN_ID->Lookup->getSql(false, $filterWrk, '', $this, true, true);
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
            $this->STATUS_PASIEN_ID->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->STATUS_PASIEN_ID->ViewCustomAttributes = "";

            // ISRJ
            $this->ISRJ->ViewValue = $this->ISRJ->CurrentValue;
            $this->ISRJ->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->ISRJ->ViewCustomAttributes = "";

            // VISIT_ID
            $this->VISIT_ID->ViewValue = $this->VISIT_ID->CurrentValue;
            $this->VISIT_ID->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->VISIT_ID->ViewCustomAttributes = "";

            // IDXDAFTAR
            $this->IDXDAFTAR->ViewValue = $this->IDXDAFTAR->CurrentValue;
            $this->IDXDAFTAR->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->IDXDAFTAR->ViewCustomAttributes = "";

            // DIANTAR_OLEH
            $this->DIANTAR_OLEH->ViewValue = $this->DIANTAR_OLEH->CurrentValue;
            $this->DIANTAR_OLEH->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->DIANTAR_OLEH->ViewCustomAttributes = "";

            // EXIT_DATE
            $this->EXIT_DATE->ViewValue = $this->EXIT_DATE->CurrentValue;
            $this->EXIT_DATE->ViewValue = FormatDateTime($this->EXIT_DATE->ViewValue, 0);
            $this->EXIT_DATE->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->EXIT_DATE->ViewCustomAttributes = "";

            // KELUAR_ID
            $this->KELUAR_ID->ViewValue = $this->KELUAR_ID->CurrentValue;
            $this->KELUAR_ID->ViewValue = FormatNumber($this->KELUAR_ID->ViewValue, 0, -2, -2, -2);
            $this->KELUAR_ID->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->KELUAR_ID->ViewCustomAttributes = "";

            // AGEYEAR
            $this->AGEYEAR->ViewValue = $this->AGEYEAR->CurrentValue;
            $this->AGEYEAR->ViewValue = FormatNumber($this->AGEYEAR->ViewValue, 0, -2, -2, -2);
            $this->AGEYEAR->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->AGEYEAR->ViewCustomAttributes = "";

            // ORG_UNIT_CODE
            $this->ORG_UNIT_CODE->ViewValue = $this->ORG_UNIT_CODE->CurrentValue;
            $this->ORG_UNIT_CODE->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->ORG_UNIT_CODE->ViewCustomAttributes = "";

            // RUJUKAN_ID
            $this->RUJUKAN_ID->ViewValue = $this->RUJUKAN_ID->CurrentValue;
            $this->RUJUKAN_ID->ViewValue = FormatNumber($this->RUJUKAN_ID->ViewValue, 0, -2, -2, -2);
            $this->RUJUKAN_ID->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->RUJUKAN_ID->ViewCustomAttributes = "";

            // ADDRESS_OF_RUJUKAN
            $this->ADDRESS_OF_RUJUKAN->ViewValue = $this->ADDRESS_OF_RUJUKAN->CurrentValue;
            $this->ADDRESS_OF_RUJUKAN->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->ADDRESS_OF_RUJUKAN->ViewCustomAttributes = "";

            // REASON_ID
            $this->REASON_ID->ViewValue = $this->REASON_ID->CurrentValue;
            $this->REASON_ID->ViewValue = FormatNumber($this->REASON_ID->ViewValue, 0, -2, -2, -2);
            $this->REASON_ID->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->REASON_ID->ViewCustomAttributes = "";

            // WAY_ID
            $this->WAY_ID->ViewValue = $this->WAY_ID->CurrentValue;
            $this->WAY_ID->ViewValue = FormatNumber($this->WAY_ID->ViewValue, 0, -2, -2, -2);
            $this->WAY_ID->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->WAY_ID->ViewCustomAttributes = "";

            // PATIENT_CATEGORY_ID
            $this->PATIENT_CATEGORY_ID->ViewValue = $this->PATIENT_CATEGORY_ID->CurrentValue;
            $this->PATIENT_CATEGORY_ID->ViewValue = FormatNumber($this->PATIENT_CATEGORY_ID->ViewValue, 0, -2, -2, -2);
            $this->PATIENT_CATEGORY_ID->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->PATIENT_CATEGORY_ID->ViewCustomAttributes = "";

            // BOOKED_DATE
            $this->BOOKED_DATE->ViewValue = $this->BOOKED_DATE->CurrentValue;
            $this->BOOKED_DATE->ViewValue = FormatDateTime($this->BOOKED_DATE->ViewValue, 0);
            $this->BOOKED_DATE->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->BOOKED_DATE->ViewCustomAttributes = "";

            // VISIT_DATE
            $this->VISIT_DATE->ViewValue = $this->VISIT_DATE->CurrentValue;
            $this->VISIT_DATE->ViewValue = FormatDateTime($this->VISIT_DATE->ViewValue, 0);
            $this->VISIT_DATE->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->VISIT_DATE->ViewCustomAttributes = "";

            // ISNEW
            $this->ISNEW->ViewValue = $this->ISNEW->CurrentValue;
            $this->ISNEW->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->ISNEW->ViewCustomAttributes = "";

            // FOLLOW_UP
            $this->FOLLOW_UP->ViewValue = $this->FOLLOW_UP->CurrentValue;
            $this->FOLLOW_UP->ViewValue = FormatNumber($this->FOLLOW_UP->ViewValue, 0, -2, -2, -2);
            $this->FOLLOW_UP->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->FOLLOW_UP->ViewCustomAttributes = "";

            // PLACE_TYPE
            $this->PLACE_TYPE->ViewValue = $this->PLACE_TYPE->CurrentValue;
            $this->PLACE_TYPE->ViewValue = FormatNumber($this->PLACE_TYPE->ViewValue, 0, -2, -2, -2);
            $this->PLACE_TYPE->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->PLACE_TYPE->ViewCustomAttributes = "";

            // CLINIC_ID
            $this->CLINIC_ID->ViewValue = $this->CLINIC_ID->CurrentValue;
            $this->CLINIC_ID->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->CLINIC_ID->ViewCustomAttributes = "";

            // CLINIC_ID_FROM
            $this->CLINIC_ID_FROM->ViewValue = $this->CLINIC_ID_FROM->CurrentValue;
            $this->CLINIC_ID_FROM->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->CLINIC_ID_FROM->ViewCustomAttributes = "";

            // IN_DATE
            $this->IN_DATE->ViewValue = $this->IN_DATE->CurrentValue;
            $this->IN_DATE->ViewValue = FormatDateTime($this->IN_DATE->ViewValue, 0);
            $this->IN_DATE->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->IN_DATE->ViewCustomAttributes = "";

            // DESCRIPTION
            $this->DESCRIPTION->ViewValue = $this->DESCRIPTION->CurrentValue;
            $this->DESCRIPTION->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->DESCRIPTION->ViewCustomAttributes = "";

            // VISITOR_ADDRESS
            $this->VISITOR_ADDRESS->ViewValue = $this->VISITOR_ADDRESS->CurrentValue;
            $this->VISITOR_ADDRESS->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->VISITOR_ADDRESS->ViewCustomAttributes = "";

            // MODIFIED_BY
            $this->MODIFIED_BY->ViewValue = $this->MODIFIED_BY->CurrentValue;
            $this->MODIFIED_BY->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->MODIFIED_BY->ViewCustomAttributes = "";

            // MODIFIED_DATE
            $this->MODIFIED_DATE->ViewValue = $this->MODIFIED_DATE->CurrentValue;
            $this->MODIFIED_DATE->ViewValue = FormatDateTime($this->MODIFIED_DATE->ViewValue, 0);
            $this->MODIFIED_DATE->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->MODIFIED_DATE->ViewCustomAttributes = "";

            // MODIFIED_FROM
            $this->MODIFIED_FROM->ViewValue = $this->MODIFIED_FROM->CurrentValue;
            $this->MODIFIED_FROM->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->MODIFIED_FROM->ViewCustomAttributes = "";

            // EMPLOYEE_ID
            $this->EMPLOYEE_ID->ViewValue = $this->EMPLOYEE_ID->CurrentValue;
            $this->EMPLOYEE_ID->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->EMPLOYEE_ID->ViewCustomAttributes = "";

            // EMPLOYEE_ID_FROM
            $this->EMPLOYEE_ID_FROM->ViewValue = $this->EMPLOYEE_ID_FROM->CurrentValue;
            $this->EMPLOYEE_ID_FROM->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->EMPLOYEE_ID_FROM->ViewCustomAttributes = "";

            // RESPONSIBLE_ID
            $this->RESPONSIBLE_ID->ViewValue = $this->RESPONSIBLE_ID->CurrentValue;
            $this->RESPONSIBLE_ID->ViewValue = FormatNumber($this->RESPONSIBLE_ID->ViewValue, 0, -2, -2, -2);
            $this->RESPONSIBLE_ID->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->RESPONSIBLE_ID->ViewCustomAttributes = "";

            // RESPONSIBLE
            $this->RESPONSIBLE->ViewValue = $this->RESPONSIBLE->CurrentValue;
            $this->RESPONSIBLE->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->RESPONSIBLE->ViewCustomAttributes = "";

            // FAMILY_STATUS_ID
            $this->FAMILY_STATUS_ID->ViewValue = $this->FAMILY_STATUS_ID->CurrentValue;
            $this->FAMILY_STATUS_ID->ViewValue = FormatNumber($this->FAMILY_STATUS_ID->ViewValue, 0, -2, -2, -2);
            $this->FAMILY_STATUS_ID->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->FAMILY_STATUS_ID->ViewCustomAttributes = "";

            // TICKET_NO
            $this->TICKET_NO->ViewValue = $this->TICKET_NO->CurrentValue;
            $this->TICKET_NO->ViewValue = FormatNumber($this->TICKET_NO->ViewValue, 0, -2, -2, -2);
            $this->TICKET_NO->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->TICKET_NO->ViewCustomAttributes = "";

            // ISATTENDED
            $this->ISATTENDED->ViewValue = $this->ISATTENDED->CurrentValue;
            $this->ISATTENDED->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->ISATTENDED->ViewCustomAttributes = "";

            // PAYOR_ID
            $this->PAYOR_ID->ViewValue = $this->PAYOR_ID->CurrentValue;
            $this->PAYOR_ID->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->PAYOR_ID->ViewCustomAttributes = "";

            // CLASS_ID
            $this->CLASS_ID->ViewValue = $this->CLASS_ID->CurrentValue;
            $this->CLASS_ID->ViewValue = FormatNumber($this->CLASS_ID->ViewValue, 0, -2, -2, -2);
            $this->CLASS_ID->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->CLASS_ID->ViewCustomAttributes = "";

            // ISPERTARIF
            $this->ISPERTARIF->ViewValue = $this->ISPERTARIF->CurrentValue;
            $this->ISPERTARIF->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->ISPERTARIF->ViewCustomAttributes = "";

            // KAL_ID
            $this->KAL_ID->ViewValue = $this->KAL_ID->CurrentValue;
            $this->KAL_ID->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->KAL_ID->ViewCustomAttributes = "";

            // EMPLOYEE_INAP
            $this->EMPLOYEE_INAP->ViewValue = $this->EMPLOYEE_INAP->CurrentValue;
            $this->EMPLOYEE_INAP->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->EMPLOYEE_INAP->ViewCustomAttributes = "";

            // PASIEN_ID
            $this->PASIEN_ID->ViewValue = $this->PASIEN_ID->CurrentValue;
            $this->PASIEN_ID->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->PASIEN_ID->ViewCustomAttributes = "";

            // KARYAWAN
            $this->KARYAWAN->ViewValue = $this->KARYAWAN->CurrentValue;
            $this->KARYAWAN->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->KARYAWAN->ViewCustomAttributes = "";

            // ACCOUNT_ID
            $this->ACCOUNT_ID->ViewValue = $this->ACCOUNT_ID->CurrentValue;
            $this->ACCOUNT_ID->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->ACCOUNT_ID->ViewCustomAttributes = "";

            // CLASS_ID_PLAFOND
            $this->CLASS_ID_PLAFOND->ViewValue = $this->CLASS_ID_PLAFOND->CurrentValue;
            $this->CLASS_ID_PLAFOND->ViewValue = FormatNumber($this->CLASS_ID_PLAFOND->ViewValue, 0, -2, -2, -2);
            $this->CLASS_ID_PLAFOND->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->CLASS_ID_PLAFOND->ViewCustomAttributes = "";

            // BACKCHARGE
            $this->BACKCHARGE->ViewValue = $this->BACKCHARGE->CurrentValue;
            $this->BACKCHARGE->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->BACKCHARGE->ViewCustomAttributes = "";

            // COVERAGE_ID
            $this->COVERAGE_ID->ViewValue = $this->COVERAGE_ID->CurrentValue;
            $this->COVERAGE_ID->ViewValue = FormatNumber($this->COVERAGE_ID->ViewValue, 0, -2, -2, -2);
            $this->COVERAGE_ID->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->COVERAGE_ID->ViewCustomAttributes = "";

            // AGEMONTH
            $this->AGEMONTH->ViewValue = $this->AGEMONTH->CurrentValue;
            $this->AGEMONTH->ViewValue = FormatNumber($this->AGEMONTH->ViewValue, 0, -2, -2, -2);
            $this->AGEMONTH->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->AGEMONTH->ViewCustomAttributes = "";

            // AGEDAY
            $this->AGEDAY->ViewValue = $this->AGEDAY->CurrentValue;
            $this->AGEDAY->ViewValue = FormatNumber($this->AGEDAY->ViewValue, 0, -2, -2, -2);
            $this->AGEDAY->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->AGEDAY->ViewCustomAttributes = "";

            // RECOMENDATION
            $this->RECOMENDATION->ViewValue = $this->RECOMENDATION->CurrentValue;
            $this->RECOMENDATION->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->RECOMENDATION->ViewCustomAttributes = "";

            // CONCLUSION
            $this->CONCLUSION->ViewValue = $this->CONCLUSION->CurrentValue;
            $this->CONCLUSION->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->CONCLUSION->ViewCustomAttributes = "";

            // SPECIMENNO
            $this->SPECIMENNO->ViewValue = $this->SPECIMENNO->CurrentValue;
            $this->SPECIMENNO->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->SPECIMENNO->ViewCustomAttributes = "";

            // LOCKED
            $this->LOCKED->ViewValue = $this->LOCKED->CurrentValue;
            $this->LOCKED->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->LOCKED->ViewCustomAttributes = "";

            // RM_OUT_DATE
            $this->RM_OUT_DATE->ViewValue = $this->RM_OUT_DATE->CurrentValue;
            $this->RM_OUT_DATE->ViewValue = FormatDateTime($this->RM_OUT_DATE->ViewValue, 0);
            $this->RM_OUT_DATE->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->RM_OUT_DATE->ViewCustomAttributes = "";

            // RM_IN_DATE
            $this->RM_IN_DATE->ViewValue = $this->RM_IN_DATE->CurrentValue;
            $this->RM_IN_DATE->ViewValue = FormatDateTime($this->RM_IN_DATE->ViewValue, 0);
            $this->RM_IN_DATE->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->RM_IN_DATE->ViewCustomAttributes = "";

            // LAMA_PINJAM
            $this->LAMA_PINJAM->ViewValue = $this->LAMA_PINJAM->CurrentValue;
            $this->LAMA_PINJAM->ViewValue = FormatDateTime($this->LAMA_PINJAM->ViewValue, 0);
            $this->LAMA_PINJAM->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->LAMA_PINJAM->ViewCustomAttributes = "";

            // STANDAR_RJ
            $this->STANDAR_RJ->ViewValue = $this->STANDAR_RJ->CurrentValue;
            $this->STANDAR_RJ->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->STANDAR_RJ->ViewCustomAttributes = "";

            // LENGKAP_RJ
            $this->LENGKAP_RJ->ViewValue = $this->LENGKAP_RJ->CurrentValue;
            $this->LENGKAP_RJ->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->LENGKAP_RJ->ViewCustomAttributes = "";

            // LENGKAP_RI
            $this->LENGKAP_RI->ViewValue = $this->LENGKAP_RI->CurrentValue;
            $this->LENGKAP_RI->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->LENGKAP_RI->ViewCustomAttributes = "";

            // RESEND_RM_DATE
            $this->RESEND_RM_DATE->ViewValue = $this->RESEND_RM_DATE->CurrentValue;
            $this->RESEND_RM_DATE->ViewValue = FormatDateTime($this->RESEND_RM_DATE->ViewValue, 0);
            $this->RESEND_RM_DATE->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->RESEND_RM_DATE->ViewCustomAttributes = "";

            // LENGKAP_RM1
            $this->LENGKAP_RM1->ViewValue = $this->LENGKAP_RM1->CurrentValue;
            $this->LENGKAP_RM1->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->LENGKAP_RM1->ViewCustomAttributes = "";

            // LENGKAP_RESUME
            $this->LENGKAP_RESUME->ViewValue = $this->LENGKAP_RESUME->CurrentValue;
            $this->LENGKAP_RESUME->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->LENGKAP_RESUME->ViewCustomAttributes = "";

            // LENGKAP_ANAMNESIS
            $this->LENGKAP_ANAMNESIS->ViewValue = $this->LENGKAP_ANAMNESIS->CurrentValue;
            $this->LENGKAP_ANAMNESIS->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->LENGKAP_ANAMNESIS->ViewCustomAttributes = "";

            // LENGKAP_CONSENT
            $this->LENGKAP_CONSENT->ViewValue = $this->LENGKAP_CONSENT->CurrentValue;
            $this->LENGKAP_CONSENT->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->LENGKAP_CONSENT->ViewCustomAttributes = "";

            // LENGKAP_ANESTESI
            $this->LENGKAP_ANESTESI->ViewValue = $this->LENGKAP_ANESTESI->CurrentValue;
            $this->LENGKAP_ANESTESI->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->LENGKAP_ANESTESI->ViewCustomAttributes = "";

            // LENGKAP_OP
            $this->LENGKAP_OP->ViewValue = $this->LENGKAP_OP->CurrentValue;
            $this->LENGKAP_OP->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->LENGKAP_OP->ViewCustomAttributes = "";

            // BACK_RM_DATE
            $this->BACK_RM_DATE->ViewValue = $this->BACK_RM_DATE->CurrentValue;
            $this->BACK_RM_DATE->ViewValue = FormatDateTime($this->BACK_RM_DATE->ViewValue, 0);
            $this->BACK_RM_DATE->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->BACK_RM_DATE->ViewCustomAttributes = "";

            // VALID_RM_DATE
            $this->VALID_RM_DATE->ViewValue = $this->VALID_RM_DATE->CurrentValue;
            $this->VALID_RM_DATE->ViewValue = FormatDateTime($this->VALID_RM_DATE->ViewValue, 0);
            $this->VALID_RM_DATE->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->VALID_RM_DATE->ViewCustomAttributes = "";

            // NO_SKP
            $this->NO_SKP->ViewValue = $this->NO_SKP->CurrentValue;
            $this->NO_SKP->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->NO_SKP->ViewCustomAttributes = "";

            // NO_SKPINAP
            $this->NO_SKPINAP->ViewValue = $this->NO_SKPINAP->CurrentValue;
            $this->NO_SKPINAP->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->NO_SKPINAP->ViewCustomAttributes = "";

            // DIAGNOSA_ID
            $this->DIAGNOSA_ID->ViewValue = $this->DIAGNOSA_ID->CurrentValue;
            $this->DIAGNOSA_ID->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->DIAGNOSA_ID->ViewCustomAttributes = "";

            // ticket_all
            $this->ticket_all->ViewValue = $this->ticket_all->CurrentValue;
            $this->ticket_all->ViewValue = FormatNumber($this->ticket_all->ViewValue, 0, -2, -2, -2);
            $this->ticket_all->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->ticket_all->ViewCustomAttributes = "";

            // tanggal_rujukan
            $this->tanggal_rujukan->ViewValue = $this->tanggal_rujukan->CurrentValue;
            $this->tanggal_rujukan->ViewValue = FormatDateTime($this->tanggal_rujukan->ViewValue, 0);
            $this->tanggal_rujukan->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->tanggal_rujukan->ViewCustomAttributes = "";

            // NORUJUKAN
            $this->NORUJUKAN->ViewValue = $this->NORUJUKAN->CurrentValue;
            $this->NORUJUKAN->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->NORUJUKAN->ViewCustomAttributes = "";

            // PPKRUJUKAN
            $this->PPKRUJUKAN->ViewValue = $this->PPKRUJUKAN->CurrentValue;
            $this->PPKRUJUKAN->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->PPKRUJUKAN->ViewCustomAttributes = "";

            // LOKASILAKA
            $this->LOKASILAKA->ViewValue = $this->LOKASILAKA->CurrentValue;
            $this->LOKASILAKA->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->LOKASILAKA->ViewCustomAttributes = "";

            // KDPOLI
            $this->KDPOLI->ViewValue = $this->KDPOLI->CurrentValue;
            $this->KDPOLI->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->KDPOLI->ViewCustomAttributes = "";

            // EDIT_SEP
            $this->EDIT_SEP->ViewValue = $this->EDIT_SEP->CurrentValue;
            $this->EDIT_SEP->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->EDIT_SEP->ViewCustomAttributes = "";

            // DELETE_SEP
            $this->DELETE_SEP->ViewValue = $this->DELETE_SEP->CurrentValue;
            $this->DELETE_SEP->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->DELETE_SEP->ViewCustomAttributes = "";

            // KODE_AGAMA
            $this->KODE_AGAMA->ViewValue = $this->KODE_AGAMA->CurrentValue;
            $this->KODE_AGAMA->ViewValue = FormatNumber($this->KODE_AGAMA->ViewValue, 0, -2, -2, -2);
            $this->KODE_AGAMA->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->KODE_AGAMA->ViewCustomAttributes = "";

            // DIAG_AWAL
            $this->DIAG_AWAL->ViewValue = $this->DIAG_AWAL->CurrentValue;
            $this->DIAG_AWAL->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->DIAG_AWAL->ViewCustomAttributes = "";

            // AKTIF
            $this->AKTIF->ViewValue = $this->AKTIF->CurrentValue;
            $this->AKTIF->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->AKTIF->ViewCustomAttributes = "";

            // BILL_INAP
            $this->BILL_INAP->ViewValue = $this->BILL_INAP->CurrentValue;
            $this->BILL_INAP->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->BILL_INAP->ViewCustomAttributes = "";

            // SEP_PRINTDATE
            $this->SEP_PRINTDATE->ViewValue = $this->SEP_PRINTDATE->CurrentValue;
            $this->SEP_PRINTDATE->ViewValue = FormatDateTime($this->SEP_PRINTDATE->ViewValue, 0);
            $this->SEP_PRINTDATE->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->SEP_PRINTDATE->ViewCustomAttributes = "";

            // MAPPING_SEP
            $this->MAPPING_SEP->ViewValue = $this->MAPPING_SEP->CurrentValue;
            $this->MAPPING_SEP->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->MAPPING_SEP->ViewCustomAttributes = "";

            // TRANS_ID
            $this->TRANS_ID->ViewValue = $this->TRANS_ID->CurrentValue;
            $this->TRANS_ID->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->TRANS_ID->ViewCustomAttributes = "";

            // KDPOLI_EKS
            $this->KDPOLI_EKS->ViewValue = $this->KDPOLI_EKS->CurrentValue;
            $this->KDPOLI_EKS->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->KDPOLI_EKS->ViewCustomAttributes = "";

            // COB
            $this->COB->ViewValue = $this->COB->CurrentValue;
            $this->COB->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->COB->ViewCustomAttributes = "";

            // PENJAMIN
            $this->PENJAMIN->ViewValue = $this->PENJAMIN->CurrentValue;
            $this->PENJAMIN->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->PENJAMIN->ViewCustomAttributes = "";

            // ASALRUJUKAN
            $this->ASALRUJUKAN->ViewValue = $this->ASALRUJUKAN->CurrentValue;
            $this->ASALRUJUKAN->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->ASALRUJUKAN->ViewCustomAttributes = "";

            // RESPONSEP
            $this->RESPONSEP->ViewValue = $this->RESPONSEP->CurrentValue;
            $this->RESPONSEP->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->RESPONSEP->ViewCustomAttributes = "";

            // APPROVAL_DESC
            $this->APPROVAL_DESC->ViewValue = $this->APPROVAL_DESC->CurrentValue;
            $this->APPROVAL_DESC->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->APPROVAL_DESC->ViewCustomAttributes = "";

            // APPROVAL_RESPONAJUKAN
            $this->APPROVAL_RESPONAJUKAN->ViewValue = $this->APPROVAL_RESPONAJUKAN->CurrentValue;
            $this->APPROVAL_RESPONAJUKAN->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->APPROVAL_RESPONAJUKAN->ViewCustomAttributes = "";

            // APPROVAL_RESPONAPPROV
            $this->APPROVAL_RESPONAPPROV->ViewValue = $this->APPROVAL_RESPONAPPROV->CurrentValue;
            $this->APPROVAL_RESPONAPPROV->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->APPROVAL_RESPONAPPROV->ViewCustomAttributes = "";

            // RESPONTGLPLG_DESC
            $this->RESPONTGLPLG_DESC->ViewValue = $this->RESPONTGLPLG_DESC->CurrentValue;
            $this->RESPONTGLPLG_DESC->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->RESPONTGLPLG_DESC->ViewCustomAttributes = "";

            // RESPONPOST_VKLAIM
            $this->RESPONPOST_VKLAIM->ViewValue = $this->RESPONPOST_VKLAIM->CurrentValue;
            $this->RESPONPOST_VKLAIM->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->RESPONPOST_VKLAIM->ViewCustomAttributes = "";

            // RESPONPUT_VKLAIM
            $this->RESPONPUT_VKLAIM->ViewValue = $this->RESPONPUT_VKLAIM->CurrentValue;
            $this->RESPONPUT_VKLAIM->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->RESPONPUT_VKLAIM->ViewCustomAttributes = "";

            // RESPONDEL_VKLAIM
            $this->RESPONDEL_VKLAIM->ViewValue = $this->RESPONDEL_VKLAIM->CurrentValue;
            $this->RESPONDEL_VKLAIM->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->RESPONDEL_VKLAIM->ViewCustomAttributes = "";

            // CALL_TIMES
            $this->CALL_TIMES->ViewValue = $this->CALL_TIMES->CurrentValue;
            $this->CALL_TIMES->ViewValue = FormatNumber($this->CALL_TIMES->ViewValue, 0, -2, -2, -2);
            $this->CALL_TIMES->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->CALL_TIMES->ViewCustomAttributes = "";

            // CALL_DATE
            $this->CALL_DATE->ViewValue = $this->CALL_DATE->CurrentValue;
            $this->CALL_DATE->ViewValue = FormatDateTime($this->CALL_DATE->ViewValue, 0);
            $this->CALL_DATE->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->CALL_DATE->ViewCustomAttributes = "";

            // CALL_DATES
            $this->CALL_DATES->ViewValue = $this->CALL_DATES->CurrentValue;
            $this->CALL_DATES->ViewValue = FormatDateTime($this->CALL_DATES->ViewValue, 0);
            $this->CALL_DATES->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->CALL_DATES->ViewCustomAttributes = "";

            // SERVED_DATE
            $this->SERVED_DATE->ViewValue = $this->SERVED_DATE->CurrentValue;
            $this->SERVED_DATE->ViewValue = FormatDateTime($this->SERVED_DATE->ViewValue, 0);
            $this->SERVED_DATE->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->SERVED_DATE->ViewCustomAttributes = "";

            // KDDPJP1
            $this->KDDPJP1->ViewValue = $this->KDDPJP1->CurrentValue;
            $this->KDDPJP1->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->KDDPJP1->ViewCustomAttributes = "";

            // KDDPJP
            $this->KDDPJP->ViewValue = $this->KDDPJP->CurrentValue;
            $this->KDDPJP->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->KDDPJP->ViewCustomAttributes = "";

            // tgl_kontrol
            $this->tgl_kontrol->ViewValue = $this->tgl_kontrol->CurrentValue;
            $this->tgl_kontrol->ViewValue = FormatDateTime($this->tgl_kontrol->ViewValue, 0);
            $this->tgl_kontrol->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->tgl_kontrol->ViewCustomAttributes = "";

            // NO_REGISTRATION
            $this->NO_REGISTRATION->LinkCustomAttributes = "";
            $this->NO_REGISTRATION->HrefValue = "";
            $this->NO_REGISTRATION->TooltipValue = "";

            // GENDER
            $this->GENDER->LinkCustomAttributes = "";
            $this->GENDER->HrefValue = "";
            $this->GENDER->TooltipValue = "";

            // CLASS_ROOM_ID
            $this->CLASS_ROOM_ID->LinkCustomAttributes = "";
            $this->CLASS_ROOM_ID->HrefValue = "";
            $this->CLASS_ROOM_ID->TooltipValue = "";

            // BED_ID
            $this->BED_ID->LinkCustomAttributes = "";
            $this->BED_ID->HrefValue = "";
            $this->BED_ID->TooltipValue = "";

            // SERVED_INAP
            $this->SERVED_INAP->LinkCustomAttributes = "";
            $this->SERVED_INAP->HrefValue = "";
            $this->SERVED_INAP->TooltipValue = "";

            // STATUS_PASIEN_ID
            $this->STATUS_PASIEN_ID->LinkCustomAttributes = "";
            $this->STATUS_PASIEN_ID->HrefValue = "";
            $this->STATUS_PASIEN_ID->TooltipValue = "";

            // ISRJ
            $this->ISRJ->LinkCustomAttributes = "";
            $this->ISRJ->HrefValue = "";
            $this->ISRJ->TooltipValue = "";

            // VISIT_ID
            $this->VISIT_ID->LinkCustomAttributes = "";
            $this->VISIT_ID->HrefValue = "";
            $this->VISIT_ID->TooltipValue = "";

            // IDXDAFTAR
            $this->IDXDAFTAR->LinkCustomAttributes = "";
            $this->IDXDAFTAR->HrefValue = "";
            $this->IDXDAFTAR->TooltipValue = "";

            // DIANTAR_OLEH
            $this->DIANTAR_OLEH->LinkCustomAttributes = "";
            $this->DIANTAR_OLEH->HrefValue = "";
            $this->DIANTAR_OLEH->TooltipValue = "";

            // EXIT_DATE
            $this->EXIT_DATE->LinkCustomAttributes = "";
            $this->EXIT_DATE->HrefValue = "";
            $this->EXIT_DATE->TooltipValue = "";

            // KELUAR_ID
            $this->KELUAR_ID->LinkCustomAttributes = "";
            $this->KELUAR_ID->HrefValue = "";
            $this->KELUAR_ID->TooltipValue = "";

            // AGEYEAR
            $this->AGEYEAR->LinkCustomAttributes = "";
            $this->AGEYEAR->HrefValue = "";
            $this->AGEYEAR->TooltipValue = "";

            // ORG_UNIT_CODE
            $this->ORG_UNIT_CODE->LinkCustomAttributes = "";
            $this->ORG_UNIT_CODE->HrefValue = "";
            $this->ORG_UNIT_CODE->TooltipValue = "";

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

            // IN_DATE
            $this->IN_DATE->LinkCustomAttributes = "";
            $this->IN_DATE->HrefValue = "";
            $this->IN_DATE->TooltipValue = "";

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
        }

        // Call Cell_Rendered event
        if ($this->RowType == ROWTYPE_TOTAL) {
            // IDXDAFTAR
            $currentValue = $this->IDXDAFTAR->CntValue;
            $viewValue = &$this->IDXDAFTAR->CntViewValue;
            $viewAttrs = &$this->IDXDAFTAR->ViewAttrs;
            $cellAttrs = &$this->IDXDAFTAR->CellAttrs;
            $hrefValue = &$this->IDXDAFTAR->HrefValue;
            $linkAttrs = &$this->IDXDAFTAR->LinkAttrs;
            $this->cellRendered($this->IDXDAFTAR, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);
        } else {
            // NO_REGISTRATION
            $currentValue = $this->NO_REGISTRATION->CurrentValue;
            $viewValue = &$this->NO_REGISTRATION->ViewValue;
            $viewAttrs = &$this->NO_REGISTRATION->ViewAttrs;
            $cellAttrs = &$this->NO_REGISTRATION->CellAttrs;
            $hrefValue = &$this->NO_REGISTRATION->HrefValue;
            $linkAttrs = &$this->NO_REGISTRATION->LinkAttrs;
            $this->cellRendered($this->NO_REGISTRATION, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // GENDER
            $currentValue = $this->GENDER->CurrentValue;
            $viewValue = &$this->GENDER->ViewValue;
            $viewAttrs = &$this->GENDER->ViewAttrs;
            $cellAttrs = &$this->GENDER->CellAttrs;
            $hrefValue = &$this->GENDER->HrefValue;
            $linkAttrs = &$this->GENDER->LinkAttrs;
            $this->cellRendered($this->GENDER, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // CLASS_ROOM_ID
            $currentValue = $this->CLASS_ROOM_ID->CurrentValue;
            $viewValue = &$this->CLASS_ROOM_ID->ViewValue;
            $viewAttrs = &$this->CLASS_ROOM_ID->ViewAttrs;
            $cellAttrs = &$this->CLASS_ROOM_ID->CellAttrs;
            $hrefValue = &$this->CLASS_ROOM_ID->HrefValue;
            $linkAttrs = &$this->CLASS_ROOM_ID->LinkAttrs;
            $this->cellRendered($this->CLASS_ROOM_ID, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // BED_ID
            $currentValue = $this->BED_ID->CurrentValue;
            $viewValue = &$this->BED_ID->ViewValue;
            $viewAttrs = &$this->BED_ID->ViewAttrs;
            $cellAttrs = &$this->BED_ID->CellAttrs;
            $hrefValue = &$this->BED_ID->HrefValue;
            $linkAttrs = &$this->BED_ID->LinkAttrs;
            $this->cellRendered($this->BED_ID, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // SERVED_INAP
            $currentValue = $this->SERVED_INAP->CurrentValue;
            $viewValue = &$this->SERVED_INAP->ViewValue;
            $viewAttrs = &$this->SERVED_INAP->ViewAttrs;
            $cellAttrs = &$this->SERVED_INAP->CellAttrs;
            $hrefValue = &$this->SERVED_INAP->HrefValue;
            $linkAttrs = &$this->SERVED_INAP->LinkAttrs;
            $this->cellRendered($this->SERVED_INAP, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // STATUS_PASIEN_ID
            $currentValue = $this->STATUS_PASIEN_ID->CurrentValue;
            $viewValue = &$this->STATUS_PASIEN_ID->ViewValue;
            $viewAttrs = &$this->STATUS_PASIEN_ID->ViewAttrs;
            $cellAttrs = &$this->STATUS_PASIEN_ID->CellAttrs;
            $hrefValue = &$this->STATUS_PASIEN_ID->HrefValue;
            $linkAttrs = &$this->STATUS_PASIEN_ID->LinkAttrs;
            $this->cellRendered($this->STATUS_PASIEN_ID, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // ISRJ
            $currentValue = $this->ISRJ->CurrentValue;
            $viewValue = &$this->ISRJ->ViewValue;
            $viewAttrs = &$this->ISRJ->ViewAttrs;
            $cellAttrs = &$this->ISRJ->CellAttrs;
            $hrefValue = &$this->ISRJ->HrefValue;
            $linkAttrs = &$this->ISRJ->LinkAttrs;
            $this->cellRendered($this->ISRJ, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // VISIT_ID
            $currentValue = $this->VISIT_ID->CurrentValue;
            $viewValue = &$this->VISIT_ID->ViewValue;
            $viewAttrs = &$this->VISIT_ID->ViewAttrs;
            $cellAttrs = &$this->VISIT_ID->CellAttrs;
            $hrefValue = &$this->VISIT_ID->HrefValue;
            $linkAttrs = &$this->VISIT_ID->LinkAttrs;
            $this->cellRendered($this->VISIT_ID, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // IDXDAFTAR
            $currentValue = $this->IDXDAFTAR->CurrentValue;
            $viewValue = &$this->IDXDAFTAR->ViewValue;
            $viewAttrs = &$this->IDXDAFTAR->ViewAttrs;
            $cellAttrs = &$this->IDXDAFTAR->CellAttrs;
            $hrefValue = &$this->IDXDAFTAR->HrefValue;
            $linkAttrs = &$this->IDXDAFTAR->LinkAttrs;
            $this->cellRendered($this->IDXDAFTAR, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // DIANTAR_OLEH
            $currentValue = $this->DIANTAR_OLEH->CurrentValue;
            $viewValue = &$this->DIANTAR_OLEH->ViewValue;
            $viewAttrs = &$this->DIANTAR_OLEH->ViewAttrs;
            $cellAttrs = &$this->DIANTAR_OLEH->CellAttrs;
            $hrefValue = &$this->DIANTAR_OLEH->HrefValue;
            $linkAttrs = &$this->DIANTAR_OLEH->LinkAttrs;
            $this->cellRendered($this->DIANTAR_OLEH, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // EXIT_DATE
            $currentValue = $this->EXIT_DATE->CurrentValue;
            $viewValue = &$this->EXIT_DATE->ViewValue;
            $viewAttrs = &$this->EXIT_DATE->ViewAttrs;
            $cellAttrs = &$this->EXIT_DATE->CellAttrs;
            $hrefValue = &$this->EXIT_DATE->HrefValue;
            $linkAttrs = &$this->EXIT_DATE->LinkAttrs;
            $this->cellRendered($this->EXIT_DATE, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // KELUAR_ID
            $currentValue = $this->KELUAR_ID->CurrentValue;
            $viewValue = &$this->KELUAR_ID->ViewValue;
            $viewAttrs = &$this->KELUAR_ID->ViewAttrs;
            $cellAttrs = &$this->KELUAR_ID->CellAttrs;
            $hrefValue = &$this->KELUAR_ID->HrefValue;
            $linkAttrs = &$this->KELUAR_ID->LinkAttrs;
            $this->cellRendered($this->KELUAR_ID, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // AGEYEAR
            $currentValue = $this->AGEYEAR->CurrentValue;
            $viewValue = &$this->AGEYEAR->ViewValue;
            $viewAttrs = &$this->AGEYEAR->ViewAttrs;
            $cellAttrs = &$this->AGEYEAR->CellAttrs;
            $hrefValue = &$this->AGEYEAR->HrefValue;
            $linkAttrs = &$this->AGEYEAR->LinkAttrs;
            $this->cellRendered($this->AGEYEAR, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // ORG_UNIT_CODE
            $currentValue = $this->ORG_UNIT_CODE->CurrentValue;
            $viewValue = &$this->ORG_UNIT_CODE->ViewValue;
            $viewAttrs = &$this->ORG_UNIT_CODE->ViewAttrs;
            $cellAttrs = &$this->ORG_UNIT_CODE->CellAttrs;
            $hrefValue = &$this->ORG_UNIT_CODE->HrefValue;
            $linkAttrs = &$this->ORG_UNIT_CODE->LinkAttrs;
            $this->cellRendered($this->ORG_UNIT_CODE, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // RUJUKAN_ID
            $currentValue = $this->RUJUKAN_ID->CurrentValue;
            $viewValue = &$this->RUJUKAN_ID->ViewValue;
            $viewAttrs = &$this->RUJUKAN_ID->ViewAttrs;
            $cellAttrs = &$this->RUJUKAN_ID->CellAttrs;
            $hrefValue = &$this->RUJUKAN_ID->HrefValue;
            $linkAttrs = &$this->RUJUKAN_ID->LinkAttrs;
            $this->cellRendered($this->RUJUKAN_ID, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // ADDRESS_OF_RUJUKAN
            $currentValue = $this->ADDRESS_OF_RUJUKAN->CurrentValue;
            $viewValue = &$this->ADDRESS_OF_RUJUKAN->ViewValue;
            $viewAttrs = &$this->ADDRESS_OF_RUJUKAN->ViewAttrs;
            $cellAttrs = &$this->ADDRESS_OF_RUJUKAN->CellAttrs;
            $hrefValue = &$this->ADDRESS_OF_RUJUKAN->HrefValue;
            $linkAttrs = &$this->ADDRESS_OF_RUJUKAN->LinkAttrs;
            $this->cellRendered($this->ADDRESS_OF_RUJUKAN, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // REASON_ID
            $currentValue = $this->REASON_ID->CurrentValue;
            $viewValue = &$this->REASON_ID->ViewValue;
            $viewAttrs = &$this->REASON_ID->ViewAttrs;
            $cellAttrs = &$this->REASON_ID->CellAttrs;
            $hrefValue = &$this->REASON_ID->HrefValue;
            $linkAttrs = &$this->REASON_ID->LinkAttrs;
            $this->cellRendered($this->REASON_ID, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // WAY_ID
            $currentValue = $this->WAY_ID->CurrentValue;
            $viewValue = &$this->WAY_ID->ViewValue;
            $viewAttrs = &$this->WAY_ID->ViewAttrs;
            $cellAttrs = &$this->WAY_ID->CellAttrs;
            $hrefValue = &$this->WAY_ID->HrefValue;
            $linkAttrs = &$this->WAY_ID->LinkAttrs;
            $this->cellRendered($this->WAY_ID, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // PATIENT_CATEGORY_ID
            $currentValue = $this->PATIENT_CATEGORY_ID->CurrentValue;
            $viewValue = &$this->PATIENT_CATEGORY_ID->ViewValue;
            $viewAttrs = &$this->PATIENT_CATEGORY_ID->ViewAttrs;
            $cellAttrs = &$this->PATIENT_CATEGORY_ID->CellAttrs;
            $hrefValue = &$this->PATIENT_CATEGORY_ID->HrefValue;
            $linkAttrs = &$this->PATIENT_CATEGORY_ID->LinkAttrs;
            $this->cellRendered($this->PATIENT_CATEGORY_ID, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // BOOKED_DATE
            $currentValue = $this->BOOKED_DATE->CurrentValue;
            $viewValue = &$this->BOOKED_DATE->ViewValue;
            $viewAttrs = &$this->BOOKED_DATE->ViewAttrs;
            $cellAttrs = &$this->BOOKED_DATE->CellAttrs;
            $hrefValue = &$this->BOOKED_DATE->HrefValue;
            $linkAttrs = &$this->BOOKED_DATE->LinkAttrs;
            $this->cellRendered($this->BOOKED_DATE, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // VISIT_DATE
            $currentValue = $this->VISIT_DATE->CurrentValue;
            $viewValue = &$this->VISIT_DATE->ViewValue;
            $viewAttrs = &$this->VISIT_DATE->ViewAttrs;
            $cellAttrs = &$this->VISIT_DATE->CellAttrs;
            $hrefValue = &$this->VISIT_DATE->HrefValue;
            $linkAttrs = &$this->VISIT_DATE->LinkAttrs;
            $this->cellRendered($this->VISIT_DATE, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // ISNEW
            $currentValue = $this->ISNEW->CurrentValue;
            $viewValue = &$this->ISNEW->ViewValue;
            $viewAttrs = &$this->ISNEW->ViewAttrs;
            $cellAttrs = &$this->ISNEW->CellAttrs;
            $hrefValue = &$this->ISNEW->HrefValue;
            $linkAttrs = &$this->ISNEW->LinkAttrs;
            $this->cellRendered($this->ISNEW, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // FOLLOW_UP
            $currentValue = $this->FOLLOW_UP->CurrentValue;
            $viewValue = &$this->FOLLOW_UP->ViewValue;
            $viewAttrs = &$this->FOLLOW_UP->ViewAttrs;
            $cellAttrs = &$this->FOLLOW_UP->CellAttrs;
            $hrefValue = &$this->FOLLOW_UP->HrefValue;
            $linkAttrs = &$this->FOLLOW_UP->LinkAttrs;
            $this->cellRendered($this->FOLLOW_UP, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // PLACE_TYPE
            $currentValue = $this->PLACE_TYPE->CurrentValue;
            $viewValue = &$this->PLACE_TYPE->ViewValue;
            $viewAttrs = &$this->PLACE_TYPE->ViewAttrs;
            $cellAttrs = &$this->PLACE_TYPE->CellAttrs;
            $hrefValue = &$this->PLACE_TYPE->HrefValue;
            $linkAttrs = &$this->PLACE_TYPE->LinkAttrs;
            $this->cellRendered($this->PLACE_TYPE, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // CLINIC_ID
            $currentValue = $this->CLINIC_ID->CurrentValue;
            $viewValue = &$this->CLINIC_ID->ViewValue;
            $viewAttrs = &$this->CLINIC_ID->ViewAttrs;
            $cellAttrs = &$this->CLINIC_ID->CellAttrs;
            $hrefValue = &$this->CLINIC_ID->HrefValue;
            $linkAttrs = &$this->CLINIC_ID->LinkAttrs;
            $this->cellRendered($this->CLINIC_ID, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // CLINIC_ID_FROM
            $currentValue = $this->CLINIC_ID_FROM->CurrentValue;
            $viewValue = &$this->CLINIC_ID_FROM->ViewValue;
            $viewAttrs = &$this->CLINIC_ID_FROM->ViewAttrs;
            $cellAttrs = &$this->CLINIC_ID_FROM->CellAttrs;
            $hrefValue = &$this->CLINIC_ID_FROM->HrefValue;
            $linkAttrs = &$this->CLINIC_ID_FROM->LinkAttrs;
            $this->cellRendered($this->CLINIC_ID_FROM, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // IN_DATE
            $currentValue = $this->IN_DATE->CurrentValue;
            $viewValue = &$this->IN_DATE->ViewValue;
            $viewAttrs = &$this->IN_DATE->ViewAttrs;
            $cellAttrs = &$this->IN_DATE->CellAttrs;
            $hrefValue = &$this->IN_DATE->HrefValue;
            $linkAttrs = &$this->IN_DATE->LinkAttrs;
            $this->cellRendered($this->IN_DATE, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // DESCRIPTION
            $currentValue = $this->DESCRIPTION->CurrentValue;
            $viewValue = &$this->DESCRIPTION->ViewValue;
            $viewAttrs = &$this->DESCRIPTION->ViewAttrs;
            $cellAttrs = &$this->DESCRIPTION->CellAttrs;
            $hrefValue = &$this->DESCRIPTION->HrefValue;
            $linkAttrs = &$this->DESCRIPTION->LinkAttrs;
            $this->cellRendered($this->DESCRIPTION, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // VISITOR_ADDRESS
            $currentValue = $this->VISITOR_ADDRESS->CurrentValue;
            $viewValue = &$this->VISITOR_ADDRESS->ViewValue;
            $viewAttrs = &$this->VISITOR_ADDRESS->ViewAttrs;
            $cellAttrs = &$this->VISITOR_ADDRESS->CellAttrs;
            $hrefValue = &$this->VISITOR_ADDRESS->HrefValue;
            $linkAttrs = &$this->VISITOR_ADDRESS->LinkAttrs;
            $this->cellRendered($this->VISITOR_ADDRESS, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // MODIFIED_BY
            $currentValue = $this->MODIFIED_BY->CurrentValue;
            $viewValue = &$this->MODIFIED_BY->ViewValue;
            $viewAttrs = &$this->MODIFIED_BY->ViewAttrs;
            $cellAttrs = &$this->MODIFIED_BY->CellAttrs;
            $hrefValue = &$this->MODIFIED_BY->HrefValue;
            $linkAttrs = &$this->MODIFIED_BY->LinkAttrs;
            $this->cellRendered($this->MODIFIED_BY, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // MODIFIED_DATE
            $currentValue = $this->MODIFIED_DATE->CurrentValue;
            $viewValue = &$this->MODIFIED_DATE->ViewValue;
            $viewAttrs = &$this->MODIFIED_DATE->ViewAttrs;
            $cellAttrs = &$this->MODIFIED_DATE->CellAttrs;
            $hrefValue = &$this->MODIFIED_DATE->HrefValue;
            $linkAttrs = &$this->MODIFIED_DATE->LinkAttrs;
            $this->cellRendered($this->MODIFIED_DATE, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // MODIFIED_FROM
            $currentValue = $this->MODIFIED_FROM->CurrentValue;
            $viewValue = &$this->MODIFIED_FROM->ViewValue;
            $viewAttrs = &$this->MODIFIED_FROM->ViewAttrs;
            $cellAttrs = &$this->MODIFIED_FROM->CellAttrs;
            $hrefValue = &$this->MODIFIED_FROM->HrefValue;
            $linkAttrs = &$this->MODIFIED_FROM->LinkAttrs;
            $this->cellRendered($this->MODIFIED_FROM, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // EMPLOYEE_ID
            $currentValue = $this->EMPLOYEE_ID->CurrentValue;
            $viewValue = &$this->EMPLOYEE_ID->ViewValue;
            $viewAttrs = &$this->EMPLOYEE_ID->ViewAttrs;
            $cellAttrs = &$this->EMPLOYEE_ID->CellAttrs;
            $hrefValue = &$this->EMPLOYEE_ID->HrefValue;
            $linkAttrs = &$this->EMPLOYEE_ID->LinkAttrs;
            $this->cellRendered($this->EMPLOYEE_ID, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // EMPLOYEE_ID_FROM
            $currentValue = $this->EMPLOYEE_ID_FROM->CurrentValue;
            $viewValue = &$this->EMPLOYEE_ID_FROM->ViewValue;
            $viewAttrs = &$this->EMPLOYEE_ID_FROM->ViewAttrs;
            $cellAttrs = &$this->EMPLOYEE_ID_FROM->CellAttrs;
            $hrefValue = &$this->EMPLOYEE_ID_FROM->HrefValue;
            $linkAttrs = &$this->EMPLOYEE_ID_FROM->LinkAttrs;
            $this->cellRendered($this->EMPLOYEE_ID_FROM, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // RESPONSIBLE_ID
            $currentValue = $this->RESPONSIBLE_ID->CurrentValue;
            $viewValue = &$this->RESPONSIBLE_ID->ViewValue;
            $viewAttrs = &$this->RESPONSIBLE_ID->ViewAttrs;
            $cellAttrs = &$this->RESPONSIBLE_ID->CellAttrs;
            $hrefValue = &$this->RESPONSIBLE_ID->HrefValue;
            $linkAttrs = &$this->RESPONSIBLE_ID->LinkAttrs;
            $this->cellRendered($this->RESPONSIBLE_ID, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // RESPONSIBLE
            $currentValue = $this->RESPONSIBLE->CurrentValue;
            $viewValue = &$this->RESPONSIBLE->ViewValue;
            $viewAttrs = &$this->RESPONSIBLE->ViewAttrs;
            $cellAttrs = &$this->RESPONSIBLE->CellAttrs;
            $hrefValue = &$this->RESPONSIBLE->HrefValue;
            $linkAttrs = &$this->RESPONSIBLE->LinkAttrs;
            $this->cellRendered($this->RESPONSIBLE, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // FAMILY_STATUS_ID
            $currentValue = $this->FAMILY_STATUS_ID->CurrentValue;
            $viewValue = &$this->FAMILY_STATUS_ID->ViewValue;
            $viewAttrs = &$this->FAMILY_STATUS_ID->ViewAttrs;
            $cellAttrs = &$this->FAMILY_STATUS_ID->CellAttrs;
            $hrefValue = &$this->FAMILY_STATUS_ID->HrefValue;
            $linkAttrs = &$this->FAMILY_STATUS_ID->LinkAttrs;
            $this->cellRendered($this->FAMILY_STATUS_ID, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // TICKET_NO
            $currentValue = $this->TICKET_NO->CurrentValue;
            $viewValue = &$this->TICKET_NO->ViewValue;
            $viewAttrs = &$this->TICKET_NO->ViewAttrs;
            $cellAttrs = &$this->TICKET_NO->CellAttrs;
            $hrefValue = &$this->TICKET_NO->HrefValue;
            $linkAttrs = &$this->TICKET_NO->LinkAttrs;
            $this->cellRendered($this->TICKET_NO, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // ISATTENDED
            $currentValue = $this->ISATTENDED->CurrentValue;
            $viewValue = &$this->ISATTENDED->ViewValue;
            $viewAttrs = &$this->ISATTENDED->ViewAttrs;
            $cellAttrs = &$this->ISATTENDED->CellAttrs;
            $hrefValue = &$this->ISATTENDED->HrefValue;
            $linkAttrs = &$this->ISATTENDED->LinkAttrs;
            $this->cellRendered($this->ISATTENDED, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // PAYOR_ID
            $currentValue = $this->PAYOR_ID->CurrentValue;
            $viewValue = &$this->PAYOR_ID->ViewValue;
            $viewAttrs = &$this->PAYOR_ID->ViewAttrs;
            $cellAttrs = &$this->PAYOR_ID->CellAttrs;
            $hrefValue = &$this->PAYOR_ID->HrefValue;
            $linkAttrs = &$this->PAYOR_ID->LinkAttrs;
            $this->cellRendered($this->PAYOR_ID, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // CLASS_ID
            $currentValue = $this->CLASS_ID->CurrentValue;
            $viewValue = &$this->CLASS_ID->ViewValue;
            $viewAttrs = &$this->CLASS_ID->ViewAttrs;
            $cellAttrs = &$this->CLASS_ID->CellAttrs;
            $hrefValue = &$this->CLASS_ID->HrefValue;
            $linkAttrs = &$this->CLASS_ID->LinkAttrs;
            $this->cellRendered($this->CLASS_ID, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // ISPERTARIF
            $currentValue = $this->ISPERTARIF->CurrentValue;
            $viewValue = &$this->ISPERTARIF->ViewValue;
            $viewAttrs = &$this->ISPERTARIF->ViewAttrs;
            $cellAttrs = &$this->ISPERTARIF->CellAttrs;
            $hrefValue = &$this->ISPERTARIF->HrefValue;
            $linkAttrs = &$this->ISPERTARIF->LinkAttrs;
            $this->cellRendered($this->ISPERTARIF, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // KAL_ID
            $currentValue = $this->KAL_ID->CurrentValue;
            $viewValue = &$this->KAL_ID->ViewValue;
            $viewAttrs = &$this->KAL_ID->ViewAttrs;
            $cellAttrs = &$this->KAL_ID->CellAttrs;
            $hrefValue = &$this->KAL_ID->HrefValue;
            $linkAttrs = &$this->KAL_ID->LinkAttrs;
            $this->cellRendered($this->KAL_ID, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // EMPLOYEE_INAP
            $currentValue = $this->EMPLOYEE_INAP->CurrentValue;
            $viewValue = &$this->EMPLOYEE_INAP->ViewValue;
            $viewAttrs = &$this->EMPLOYEE_INAP->ViewAttrs;
            $cellAttrs = &$this->EMPLOYEE_INAP->CellAttrs;
            $hrefValue = &$this->EMPLOYEE_INAP->HrefValue;
            $linkAttrs = &$this->EMPLOYEE_INAP->LinkAttrs;
            $this->cellRendered($this->EMPLOYEE_INAP, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // PASIEN_ID
            $currentValue = $this->PASIEN_ID->CurrentValue;
            $viewValue = &$this->PASIEN_ID->ViewValue;
            $viewAttrs = &$this->PASIEN_ID->ViewAttrs;
            $cellAttrs = &$this->PASIEN_ID->CellAttrs;
            $hrefValue = &$this->PASIEN_ID->HrefValue;
            $linkAttrs = &$this->PASIEN_ID->LinkAttrs;
            $this->cellRendered($this->PASIEN_ID, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // KARYAWAN
            $currentValue = $this->KARYAWAN->CurrentValue;
            $viewValue = &$this->KARYAWAN->ViewValue;
            $viewAttrs = &$this->KARYAWAN->ViewAttrs;
            $cellAttrs = &$this->KARYAWAN->CellAttrs;
            $hrefValue = &$this->KARYAWAN->HrefValue;
            $linkAttrs = &$this->KARYAWAN->LinkAttrs;
            $this->cellRendered($this->KARYAWAN, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // ACCOUNT_ID
            $currentValue = $this->ACCOUNT_ID->CurrentValue;
            $viewValue = &$this->ACCOUNT_ID->ViewValue;
            $viewAttrs = &$this->ACCOUNT_ID->ViewAttrs;
            $cellAttrs = &$this->ACCOUNT_ID->CellAttrs;
            $hrefValue = &$this->ACCOUNT_ID->HrefValue;
            $linkAttrs = &$this->ACCOUNT_ID->LinkAttrs;
            $this->cellRendered($this->ACCOUNT_ID, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // CLASS_ID_PLAFOND
            $currentValue = $this->CLASS_ID_PLAFOND->CurrentValue;
            $viewValue = &$this->CLASS_ID_PLAFOND->ViewValue;
            $viewAttrs = &$this->CLASS_ID_PLAFOND->ViewAttrs;
            $cellAttrs = &$this->CLASS_ID_PLAFOND->CellAttrs;
            $hrefValue = &$this->CLASS_ID_PLAFOND->HrefValue;
            $linkAttrs = &$this->CLASS_ID_PLAFOND->LinkAttrs;
            $this->cellRendered($this->CLASS_ID_PLAFOND, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // BACKCHARGE
            $currentValue = $this->BACKCHARGE->CurrentValue;
            $viewValue = &$this->BACKCHARGE->ViewValue;
            $viewAttrs = &$this->BACKCHARGE->ViewAttrs;
            $cellAttrs = &$this->BACKCHARGE->CellAttrs;
            $hrefValue = &$this->BACKCHARGE->HrefValue;
            $linkAttrs = &$this->BACKCHARGE->LinkAttrs;
            $this->cellRendered($this->BACKCHARGE, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // COVERAGE_ID
            $currentValue = $this->COVERAGE_ID->CurrentValue;
            $viewValue = &$this->COVERAGE_ID->ViewValue;
            $viewAttrs = &$this->COVERAGE_ID->ViewAttrs;
            $cellAttrs = &$this->COVERAGE_ID->CellAttrs;
            $hrefValue = &$this->COVERAGE_ID->HrefValue;
            $linkAttrs = &$this->COVERAGE_ID->LinkAttrs;
            $this->cellRendered($this->COVERAGE_ID, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // AGEMONTH
            $currentValue = $this->AGEMONTH->CurrentValue;
            $viewValue = &$this->AGEMONTH->ViewValue;
            $viewAttrs = &$this->AGEMONTH->ViewAttrs;
            $cellAttrs = &$this->AGEMONTH->CellAttrs;
            $hrefValue = &$this->AGEMONTH->HrefValue;
            $linkAttrs = &$this->AGEMONTH->LinkAttrs;
            $this->cellRendered($this->AGEMONTH, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // AGEDAY
            $currentValue = $this->AGEDAY->CurrentValue;
            $viewValue = &$this->AGEDAY->ViewValue;
            $viewAttrs = &$this->AGEDAY->ViewAttrs;
            $cellAttrs = &$this->AGEDAY->CellAttrs;
            $hrefValue = &$this->AGEDAY->HrefValue;
            $linkAttrs = &$this->AGEDAY->LinkAttrs;
            $this->cellRendered($this->AGEDAY, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // RECOMENDATION
            $currentValue = $this->RECOMENDATION->CurrentValue;
            $viewValue = &$this->RECOMENDATION->ViewValue;
            $viewAttrs = &$this->RECOMENDATION->ViewAttrs;
            $cellAttrs = &$this->RECOMENDATION->CellAttrs;
            $hrefValue = &$this->RECOMENDATION->HrefValue;
            $linkAttrs = &$this->RECOMENDATION->LinkAttrs;
            $this->cellRendered($this->RECOMENDATION, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // CONCLUSION
            $currentValue = $this->CONCLUSION->CurrentValue;
            $viewValue = &$this->CONCLUSION->ViewValue;
            $viewAttrs = &$this->CONCLUSION->ViewAttrs;
            $cellAttrs = &$this->CONCLUSION->CellAttrs;
            $hrefValue = &$this->CONCLUSION->HrefValue;
            $linkAttrs = &$this->CONCLUSION->LinkAttrs;
            $this->cellRendered($this->CONCLUSION, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // SPECIMENNO
            $currentValue = $this->SPECIMENNO->CurrentValue;
            $viewValue = &$this->SPECIMENNO->ViewValue;
            $viewAttrs = &$this->SPECIMENNO->ViewAttrs;
            $cellAttrs = &$this->SPECIMENNO->CellAttrs;
            $hrefValue = &$this->SPECIMENNO->HrefValue;
            $linkAttrs = &$this->SPECIMENNO->LinkAttrs;
            $this->cellRendered($this->SPECIMENNO, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // LOCKED
            $currentValue = $this->LOCKED->CurrentValue;
            $viewValue = &$this->LOCKED->ViewValue;
            $viewAttrs = &$this->LOCKED->ViewAttrs;
            $cellAttrs = &$this->LOCKED->CellAttrs;
            $hrefValue = &$this->LOCKED->HrefValue;
            $linkAttrs = &$this->LOCKED->LinkAttrs;
            $this->cellRendered($this->LOCKED, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // RM_OUT_DATE
            $currentValue = $this->RM_OUT_DATE->CurrentValue;
            $viewValue = &$this->RM_OUT_DATE->ViewValue;
            $viewAttrs = &$this->RM_OUT_DATE->ViewAttrs;
            $cellAttrs = &$this->RM_OUT_DATE->CellAttrs;
            $hrefValue = &$this->RM_OUT_DATE->HrefValue;
            $linkAttrs = &$this->RM_OUT_DATE->LinkAttrs;
            $this->cellRendered($this->RM_OUT_DATE, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // RM_IN_DATE
            $currentValue = $this->RM_IN_DATE->CurrentValue;
            $viewValue = &$this->RM_IN_DATE->ViewValue;
            $viewAttrs = &$this->RM_IN_DATE->ViewAttrs;
            $cellAttrs = &$this->RM_IN_DATE->CellAttrs;
            $hrefValue = &$this->RM_IN_DATE->HrefValue;
            $linkAttrs = &$this->RM_IN_DATE->LinkAttrs;
            $this->cellRendered($this->RM_IN_DATE, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // LAMA_PINJAM
            $currentValue = $this->LAMA_PINJAM->CurrentValue;
            $viewValue = &$this->LAMA_PINJAM->ViewValue;
            $viewAttrs = &$this->LAMA_PINJAM->ViewAttrs;
            $cellAttrs = &$this->LAMA_PINJAM->CellAttrs;
            $hrefValue = &$this->LAMA_PINJAM->HrefValue;
            $linkAttrs = &$this->LAMA_PINJAM->LinkAttrs;
            $this->cellRendered($this->LAMA_PINJAM, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // STANDAR_RJ
            $currentValue = $this->STANDAR_RJ->CurrentValue;
            $viewValue = &$this->STANDAR_RJ->ViewValue;
            $viewAttrs = &$this->STANDAR_RJ->ViewAttrs;
            $cellAttrs = &$this->STANDAR_RJ->CellAttrs;
            $hrefValue = &$this->STANDAR_RJ->HrefValue;
            $linkAttrs = &$this->STANDAR_RJ->LinkAttrs;
            $this->cellRendered($this->STANDAR_RJ, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // LENGKAP_RJ
            $currentValue = $this->LENGKAP_RJ->CurrentValue;
            $viewValue = &$this->LENGKAP_RJ->ViewValue;
            $viewAttrs = &$this->LENGKAP_RJ->ViewAttrs;
            $cellAttrs = &$this->LENGKAP_RJ->CellAttrs;
            $hrefValue = &$this->LENGKAP_RJ->HrefValue;
            $linkAttrs = &$this->LENGKAP_RJ->LinkAttrs;
            $this->cellRendered($this->LENGKAP_RJ, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // LENGKAP_RI
            $currentValue = $this->LENGKAP_RI->CurrentValue;
            $viewValue = &$this->LENGKAP_RI->ViewValue;
            $viewAttrs = &$this->LENGKAP_RI->ViewAttrs;
            $cellAttrs = &$this->LENGKAP_RI->CellAttrs;
            $hrefValue = &$this->LENGKAP_RI->HrefValue;
            $linkAttrs = &$this->LENGKAP_RI->LinkAttrs;
            $this->cellRendered($this->LENGKAP_RI, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // RESEND_RM_DATE
            $currentValue = $this->RESEND_RM_DATE->CurrentValue;
            $viewValue = &$this->RESEND_RM_DATE->ViewValue;
            $viewAttrs = &$this->RESEND_RM_DATE->ViewAttrs;
            $cellAttrs = &$this->RESEND_RM_DATE->CellAttrs;
            $hrefValue = &$this->RESEND_RM_DATE->HrefValue;
            $linkAttrs = &$this->RESEND_RM_DATE->LinkAttrs;
            $this->cellRendered($this->RESEND_RM_DATE, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // LENGKAP_RM1
            $currentValue = $this->LENGKAP_RM1->CurrentValue;
            $viewValue = &$this->LENGKAP_RM1->ViewValue;
            $viewAttrs = &$this->LENGKAP_RM1->ViewAttrs;
            $cellAttrs = &$this->LENGKAP_RM1->CellAttrs;
            $hrefValue = &$this->LENGKAP_RM1->HrefValue;
            $linkAttrs = &$this->LENGKAP_RM1->LinkAttrs;
            $this->cellRendered($this->LENGKAP_RM1, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // LENGKAP_RESUME
            $currentValue = $this->LENGKAP_RESUME->CurrentValue;
            $viewValue = &$this->LENGKAP_RESUME->ViewValue;
            $viewAttrs = &$this->LENGKAP_RESUME->ViewAttrs;
            $cellAttrs = &$this->LENGKAP_RESUME->CellAttrs;
            $hrefValue = &$this->LENGKAP_RESUME->HrefValue;
            $linkAttrs = &$this->LENGKAP_RESUME->LinkAttrs;
            $this->cellRendered($this->LENGKAP_RESUME, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // LENGKAP_ANAMNESIS
            $currentValue = $this->LENGKAP_ANAMNESIS->CurrentValue;
            $viewValue = &$this->LENGKAP_ANAMNESIS->ViewValue;
            $viewAttrs = &$this->LENGKAP_ANAMNESIS->ViewAttrs;
            $cellAttrs = &$this->LENGKAP_ANAMNESIS->CellAttrs;
            $hrefValue = &$this->LENGKAP_ANAMNESIS->HrefValue;
            $linkAttrs = &$this->LENGKAP_ANAMNESIS->LinkAttrs;
            $this->cellRendered($this->LENGKAP_ANAMNESIS, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // LENGKAP_CONSENT
            $currentValue = $this->LENGKAP_CONSENT->CurrentValue;
            $viewValue = &$this->LENGKAP_CONSENT->ViewValue;
            $viewAttrs = &$this->LENGKAP_CONSENT->ViewAttrs;
            $cellAttrs = &$this->LENGKAP_CONSENT->CellAttrs;
            $hrefValue = &$this->LENGKAP_CONSENT->HrefValue;
            $linkAttrs = &$this->LENGKAP_CONSENT->LinkAttrs;
            $this->cellRendered($this->LENGKAP_CONSENT, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // LENGKAP_ANESTESI
            $currentValue = $this->LENGKAP_ANESTESI->CurrentValue;
            $viewValue = &$this->LENGKAP_ANESTESI->ViewValue;
            $viewAttrs = &$this->LENGKAP_ANESTESI->ViewAttrs;
            $cellAttrs = &$this->LENGKAP_ANESTESI->CellAttrs;
            $hrefValue = &$this->LENGKAP_ANESTESI->HrefValue;
            $linkAttrs = &$this->LENGKAP_ANESTESI->LinkAttrs;
            $this->cellRendered($this->LENGKAP_ANESTESI, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // LENGKAP_OP
            $currentValue = $this->LENGKAP_OP->CurrentValue;
            $viewValue = &$this->LENGKAP_OP->ViewValue;
            $viewAttrs = &$this->LENGKAP_OP->ViewAttrs;
            $cellAttrs = &$this->LENGKAP_OP->CellAttrs;
            $hrefValue = &$this->LENGKAP_OP->HrefValue;
            $linkAttrs = &$this->LENGKAP_OP->LinkAttrs;
            $this->cellRendered($this->LENGKAP_OP, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // BACK_RM_DATE
            $currentValue = $this->BACK_RM_DATE->CurrentValue;
            $viewValue = &$this->BACK_RM_DATE->ViewValue;
            $viewAttrs = &$this->BACK_RM_DATE->ViewAttrs;
            $cellAttrs = &$this->BACK_RM_DATE->CellAttrs;
            $hrefValue = &$this->BACK_RM_DATE->HrefValue;
            $linkAttrs = &$this->BACK_RM_DATE->LinkAttrs;
            $this->cellRendered($this->BACK_RM_DATE, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // VALID_RM_DATE
            $currentValue = $this->VALID_RM_DATE->CurrentValue;
            $viewValue = &$this->VALID_RM_DATE->ViewValue;
            $viewAttrs = &$this->VALID_RM_DATE->ViewAttrs;
            $cellAttrs = &$this->VALID_RM_DATE->CellAttrs;
            $hrefValue = &$this->VALID_RM_DATE->HrefValue;
            $linkAttrs = &$this->VALID_RM_DATE->LinkAttrs;
            $this->cellRendered($this->VALID_RM_DATE, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // NO_SKP
            $currentValue = $this->NO_SKP->CurrentValue;
            $viewValue = &$this->NO_SKP->ViewValue;
            $viewAttrs = &$this->NO_SKP->ViewAttrs;
            $cellAttrs = &$this->NO_SKP->CellAttrs;
            $hrefValue = &$this->NO_SKP->HrefValue;
            $linkAttrs = &$this->NO_SKP->LinkAttrs;
            $this->cellRendered($this->NO_SKP, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // NO_SKPINAP
            $currentValue = $this->NO_SKPINAP->CurrentValue;
            $viewValue = &$this->NO_SKPINAP->ViewValue;
            $viewAttrs = &$this->NO_SKPINAP->ViewAttrs;
            $cellAttrs = &$this->NO_SKPINAP->CellAttrs;
            $hrefValue = &$this->NO_SKPINAP->HrefValue;
            $linkAttrs = &$this->NO_SKPINAP->LinkAttrs;
            $this->cellRendered($this->NO_SKPINAP, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // DIAGNOSA_ID
            $currentValue = $this->DIAGNOSA_ID->CurrentValue;
            $viewValue = &$this->DIAGNOSA_ID->ViewValue;
            $viewAttrs = &$this->DIAGNOSA_ID->ViewAttrs;
            $cellAttrs = &$this->DIAGNOSA_ID->CellAttrs;
            $hrefValue = &$this->DIAGNOSA_ID->HrefValue;
            $linkAttrs = &$this->DIAGNOSA_ID->LinkAttrs;
            $this->cellRendered($this->DIAGNOSA_ID, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // ticket_all
            $currentValue = $this->ticket_all->CurrentValue;
            $viewValue = &$this->ticket_all->ViewValue;
            $viewAttrs = &$this->ticket_all->ViewAttrs;
            $cellAttrs = &$this->ticket_all->CellAttrs;
            $hrefValue = &$this->ticket_all->HrefValue;
            $linkAttrs = &$this->ticket_all->LinkAttrs;
            $this->cellRendered($this->ticket_all, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // tanggal_rujukan
            $currentValue = $this->tanggal_rujukan->CurrentValue;
            $viewValue = &$this->tanggal_rujukan->ViewValue;
            $viewAttrs = &$this->tanggal_rujukan->ViewAttrs;
            $cellAttrs = &$this->tanggal_rujukan->CellAttrs;
            $hrefValue = &$this->tanggal_rujukan->HrefValue;
            $linkAttrs = &$this->tanggal_rujukan->LinkAttrs;
            $this->cellRendered($this->tanggal_rujukan, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // NORUJUKAN
            $currentValue = $this->NORUJUKAN->CurrentValue;
            $viewValue = &$this->NORUJUKAN->ViewValue;
            $viewAttrs = &$this->NORUJUKAN->ViewAttrs;
            $cellAttrs = &$this->NORUJUKAN->CellAttrs;
            $hrefValue = &$this->NORUJUKAN->HrefValue;
            $linkAttrs = &$this->NORUJUKAN->LinkAttrs;
            $this->cellRendered($this->NORUJUKAN, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // PPKRUJUKAN
            $currentValue = $this->PPKRUJUKAN->CurrentValue;
            $viewValue = &$this->PPKRUJUKAN->ViewValue;
            $viewAttrs = &$this->PPKRUJUKAN->ViewAttrs;
            $cellAttrs = &$this->PPKRUJUKAN->CellAttrs;
            $hrefValue = &$this->PPKRUJUKAN->HrefValue;
            $linkAttrs = &$this->PPKRUJUKAN->LinkAttrs;
            $this->cellRendered($this->PPKRUJUKAN, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // LOKASILAKA
            $currentValue = $this->LOKASILAKA->CurrentValue;
            $viewValue = &$this->LOKASILAKA->ViewValue;
            $viewAttrs = &$this->LOKASILAKA->ViewAttrs;
            $cellAttrs = &$this->LOKASILAKA->CellAttrs;
            $hrefValue = &$this->LOKASILAKA->HrefValue;
            $linkAttrs = &$this->LOKASILAKA->LinkAttrs;
            $this->cellRendered($this->LOKASILAKA, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // KDPOLI
            $currentValue = $this->KDPOLI->CurrentValue;
            $viewValue = &$this->KDPOLI->ViewValue;
            $viewAttrs = &$this->KDPOLI->ViewAttrs;
            $cellAttrs = &$this->KDPOLI->CellAttrs;
            $hrefValue = &$this->KDPOLI->HrefValue;
            $linkAttrs = &$this->KDPOLI->LinkAttrs;
            $this->cellRendered($this->KDPOLI, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // EDIT_SEP
            $currentValue = $this->EDIT_SEP->CurrentValue;
            $viewValue = &$this->EDIT_SEP->ViewValue;
            $viewAttrs = &$this->EDIT_SEP->ViewAttrs;
            $cellAttrs = &$this->EDIT_SEP->CellAttrs;
            $hrefValue = &$this->EDIT_SEP->HrefValue;
            $linkAttrs = &$this->EDIT_SEP->LinkAttrs;
            $this->cellRendered($this->EDIT_SEP, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // DELETE_SEP
            $currentValue = $this->DELETE_SEP->CurrentValue;
            $viewValue = &$this->DELETE_SEP->ViewValue;
            $viewAttrs = &$this->DELETE_SEP->ViewAttrs;
            $cellAttrs = &$this->DELETE_SEP->CellAttrs;
            $hrefValue = &$this->DELETE_SEP->HrefValue;
            $linkAttrs = &$this->DELETE_SEP->LinkAttrs;
            $this->cellRendered($this->DELETE_SEP, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // KODE_AGAMA
            $currentValue = $this->KODE_AGAMA->CurrentValue;
            $viewValue = &$this->KODE_AGAMA->ViewValue;
            $viewAttrs = &$this->KODE_AGAMA->ViewAttrs;
            $cellAttrs = &$this->KODE_AGAMA->CellAttrs;
            $hrefValue = &$this->KODE_AGAMA->HrefValue;
            $linkAttrs = &$this->KODE_AGAMA->LinkAttrs;
            $this->cellRendered($this->KODE_AGAMA, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // DIAG_AWAL
            $currentValue = $this->DIAG_AWAL->CurrentValue;
            $viewValue = &$this->DIAG_AWAL->ViewValue;
            $viewAttrs = &$this->DIAG_AWAL->ViewAttrs;
            $cellAttrs = &$this->DIAG_AWAL->CellAttrs;
            $hrefValue = &$this->DIAG_AWAL->HrefValue;
            $linkAttrs = &$this->DIAG_AWAL->LinkAttrs;
            $this->cellRendered($this->DIAG_AWAL, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // AKTIF
            $currentValue = $this->AKTIF->CurrentValue;
            $viewValue = &$this->AKTIF->ViewValue;
            $viewAttrs = &$this->AKTIF->ViewAttrs;
            $cellAttrs = &$this->AKTIF->CellAttrs;
            $hrefValue = &$this->AKTIF->HrefValue;
            $linkAttrs = &$this->AKTIF->LinkAttrs;
            $this->cellRendered($this->AKTIF, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // BILL_INAP
            $currentValue = $this->BILL_INAP->CurrentValue;
            $viewValue = &$this->BILL_INAP->ViewValue;
            $viewAttrs = &$this->BILL_INAP->ViewAttrs;
            $cellAttrs = &$this->BILL_INAP->CellAttrs;
            $hrefValue = &$this->BILL_INAP->HrefValue;
            $linkAttrs = &$this->BILL_INAP->LinkAttrs;
            $this->cellRendered($this->BILL_INAP, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // SEP_PRINTDATE
            $currentValue = $this->SEP_PRINTDATE->CurrentValue;
            $viewValue = &$this->SEP_PRINTDATE->ViewValue;
            $viewAttrs = &$this->SEP_PRINTDATE->ViewAttrs;
            $cellAttrs = &$this->SEP_PRINTDATE->CellAttrs;
            $hrefValue = &$this->SEP_PRINTDATE->HrefValue;
            $linkAttrs = &$this->SEP_PRINTDATE->LinkAttrs;
            $this->cellRendered($this->SEP_PRINTDATE, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // MAPPING_SEP
            $currentValue = $this->MAPPING_SEP->CurrentValue;
            $viewValue = &$this->MAPPING_SEP->ViewValue;
            $viewAttrs = &$this->MAPPING_SEP->ViewAttrs;
            $cellAttrs = &$this->MAPPING_SEP->CellAttrs;
            $hrefValue = &$this->MAPPING_SEP->HrefValue;
            $linkAttrs = &$this->MAPPING_SEP->LinkAttrs;
            $this->cellRendered($this->MAPPING_SEP, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // TRANS_ID
            $currentValue = $this->TRANS_ID->CurrentValue;
            $viewValue = &$this->TRANS_ID->ViewValue;
            $viewAttrs = &$this->TRANS_ID->ViewAttrs;
            $cellAttrs = &$this->TRANS_ID->CellAttrs;
            $hrefValue = &$this->TRANS_ID->HrefValue;
            $linkAttrs = &$this->TRANS_ID->LinkAttrs;
            $this->cellRendered($this->TRANS_ID, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // KDPOLI_EKS
            $currentValue = $this->KDPOLI_EKS->CurrentValue;
            $viewValue = &$this->KDPOLI_EKS->ViewValue;
            $viewAttrs = &$this->KDPOLI_EKS->ViewAttrs;
            $cellAttrs = &$this->KDPOLI_EKS->CellAttrs;
            $hrefValue = &$this->KDPOLI_EKS->HrefValue;
            $linkAttrs = &$this->KDPOLI_EKS->LinkAttrs;
            $this->cellRendered($this->KDPOLI_EKS, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // COB
            $currentValue = $this->COB->CurrentValue;
            $viewValue = &$this->COB->ViewValue;
            $viewAttrs = &$this->COB->ViewAttrs;
            $cellAttrs = &$this->COB->CellAttrs;
            $hrefValue = &$this->COB->HrefValue;
            $linkAttrs = &$this->COB->LinkAttrs;
            $this->cellRendered($this->COB, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // PENJAMIN
            $currentValue = $this->PENJAMIN->CurrentValue;
            $viewValue = &$this->PENJAMIN->ViewValue;
            $viewAttrs = &$this->PENJAMIN->ViewAttrs;
            $cellAttrs = &$this->PENJAMIN->CellAttrs;
            $hrefValue = &$this->PENJAMIN->HrefValue;
            $linkAttrs = &$this->PENJAMIN->LinkAttrs;
            $this->cellRendered($this->PENJAMIN, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // ASALRUJUKAN
            $currentValue = $this->ASALRUJUKAN->CurrentValue;
            $viewValue = &$this->ASALRUJUKAN->ViewValue;
            $viewAttrs = &$this->ASALRUJUKAN->ViewAttrs;
            $cellAttrs = &$this->ASALRUJUKAN->CellAttrs;
            $hrefValue = &$this->ASALRUJUKAN->HrefValue;
            $linkAttrs = &$this->ASALRUJUKAN->LinkAttrs;
            $this->cellRendered($this->ASALRUJUKAN, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // RESPONSEP
            $currentValue = $this->RESPONSEP->CurrentValue;
            $viewValue = &$this->RESPONSEP->ViewValue;
            $viewAttrs = &$this->RESPONSEP->ViewAttrs;
            $cellAttrs = &$this->RESPONSEP->CellAttrs;
            $hrefValue = &$this->RESPONSEP->HrefValue;
            $linkAttrs = &$this->RESPONSEP->LinkAttrs;
            $this->cellRendered($this->RESPONSEP, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // APPROVAL_DESC
            $currentValue = $this->APPROVAL_DESC->CurrentValue;
            $viewValue = &$this->APPROVAL_DESC->ViewValue;
            $viewAttrs = &$this->APPROVAL_DESC->ViewAttrs;
            $cellAttrs = &$this->APPROVAL_DESC->CellAttrs;
            $hrefValue = &$this->APPROVAL_DESC->HrefValue;
            $linkAttrs = &$this->APPROVAL_DESC->LinkAttrs;
            $this->cellRendered($this->APPROVAL_DESC, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // APPROVAL_RESPONAJUKAN
            $currentValue = $this->APPROVAL_RESPONAJUKAN->CurrentValue;
            $viewValue = &$this->APPROVAL_RESPONAJUKAN->ViewValue;
            $viewAttrs = &$this->APPROVAL_RESPONAJUKAN->ViewAttrs;
            $cellAttrs = &$this->APPROVAL_RESPONAJUKAN->CellAttrs;
            $hrefValue = &$this->APPROVAL_RESPONAJUKAN->HrefValue;
            $linkAttrs = &$this->APPROVAL_RESPONAJUKAN->LinkAttrs;
            $this->cellRendered($this->APPROVAL_RESPONAJUKAN, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // APPROVAL_RESPONAPPROV
            $currentValue = $this->APPROVAL_RESPONAPPROV->CurrentValue;
            $viewValue = &$this->APPROVAL_RESPONAPPROV->ViewValue;
            $viewAttrs = &$this->APPROVAL_RESPONAPPROV->ViewAttrs;
            $cellAttrs = &$this->APPROVAL_RESPONAPPROV->CellAttrs;
            $hrefValue = &$this->APPROVAL_RESPONAPPROV->HrefValue;
            $linkAttrs = &$this->APPROVAL_RESPONAPPROV->LinkAttrs;
            $this->cellRendered($this->APPROVAL_RESPONAPPROV, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // RESPONTGLPLG_DESC
            $currentValue = $this->RESPONTGLPLG_DESC->CurrentValue;
            $viewValue = &$this->RESPONTGLPLG_DESC->ViewValue;
            $viewAttrs = &$this->RESPONTGLPLG_DESC->ViewAttrs;
            $cellAttrs = &$this->RESPONTGLPLG_DESC->CellAttrs;
            $hrefValue = &$this->RESPONTGLPLG_DESC->HrefValue;
            $linkAttrs = &$this->RESPONTGLPLG_DESC->LinkAttrs;
            $this->cellRendered($this->RESPONTGLPLG_DESC, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // RESPONPOST_VKLAIM
            $currentValue = $this->RESPONPOST_VKLAIM->CurrentValue;
            $viewValue = &$this->RESPONPOST_VKLAIM->ViewValue;
            $viewAttrs = &$this->RESPONPOST_VKLAIM->ViewAttrs;
            $cellAttrs = &$this->RESPONPOST_VKLAIM->CellAttrs;
            $hrefValue = &$this->RESPONPOST_VKLAIM->HrefValue;
            $linkAttrs = &$this->RESPONPOST_VKLAIM->LinkAttrs;
            $this->cellRendered($this->RESPONPOST_VKLAIM, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // RESPONPUT_VKLAIM
            $currentValue = $this->RESPONPUT_VKLAIM->CurrentValue;
            $viewValue = &$this->RESPONPUT_VKLAIM->ViewValue;
            $viewAttrs = &$this->RESPONPUT_VKLAIM->ViewAttrs;
            $cellAttrs = &$this->RESPONPUT_VKLAIM->CellAttrs;
            $hrefValue = &$this->RESPONPUT_VKLAIM->HrefValue;
            $linkAttrs = &$this->RESPONPUT_VKLAIM->LinkAttrs;
            $this->cellRendered($this->RESPONPUT_VKLAIM, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // RESPONDEL_VKLAIM
            $currentValue = $this->RESPONDEL_VKLAIM->CurrentValue;
            $viewValue = &$this->RESPONDEL_VKLAIM->ViewValue;
            $viewAttrs = &$this->RESPONDEL_VKLAIM->ViewAttrs;
            $cellAttrs = &$this->RESPONDEL_VKLAIM->CellAttrs;
            $hrefValue = &$this->RESPONDEL_VKLAIM->HrefValue;
            $linkAttrs = &$this->RESPONDEL_VKLAIM->LinkAttrs;
            $this->cellRendered($this->RESPONDEL_VKLAIM, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // CALL_TIMES
            $currentValue = $this->CALL_TIMES->CurrentValue;
            $viewValue = &$this->CALL_TIMES->ViewValue;
            $viewAttrs = &$this->CALL_TIMES->ViewAttrs;
            $cellAttrs = &$this->CALL_TIMES->CellAttrs;
            $hrefValue = &$this->CALL_TIMES->HrefValue;
            $linkAttrs = &$this->CALL_TIMES->LinkAttrs;
            $this->cellRendered($this->CALL_TIMES, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // CALL_DATE
            $currentValue = $this->CALL_DATE->CurrentValue;
            $viewValue = &$this->CALL_DATE->ViewValue;
            $viewAttrs = &$this->CALL_DATE->ViewAttrs;
            $cellAttrs = &$this->CALL_DATE->CellAttrs;
            $hrefValue = &$this->CALL_DATE->HrefValue;
            $linkAttrs = &$this->CALL_DATE->LinkAttrs;
            $this->cellRendered($this->CALL_DATE, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // CALL_DATES
            $currentValue = $this->CALL_DATES->CurrentValue;
            $viewValue = &$this->CALL_DATES->ViewValue;
            $viewAttrs = &$this->CALL_DATES->ViewAttrs;
            $cellAttrs = &$this->CALL_DATES->CellAttrs;
            $hrefValue = &$this->CALL_DATES->HrefValue;
            $linkAttrs = &$this->CALL_DATES->LinkAttrs;
            $this->cellRendered($this->CALL_DATES, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // SERVED_DATE
            $currentValue = $this->SERVED_DATE->CurrentValue;
            $viewValue = &$this->SERVED_DATE->ViewValue;
            $viewAttrs = &$this->SERVED_DATE->ViewAttrs;
            $cellAttrs = &$this->SERVED_DATE->CellAttrs;
            $hrefValue = &$this->SERVED_DATE->HrefValue;
            $linkAttrs = &$this->SERVED_DATE->LinkAttrs;
            $this->cellRendered($this->SERVED_DATE, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // KDDPJP1
            $currentValue = $this->KDDPJP1->CurrentValue;
            $viewValue = &$this->KDDPJP1->ViewValue;
            $viewAttrs = &$this->KDDPJP1->ViewAttrs;
            $cellAttrs = &$this->KDDPJP1->CellAttrs;
            $hrefValue = &$this->KDDPJP1->HrefValue;
            $linkAttrs = &$this->KDDPJP1->LinkAttrs;
            $this->cellRendered($this->KDDPJP1, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // KDDPJP
            $currentValue = $this->KDDPJP->CurrentValue;
            $viewValue = &$this->KDDPJP->ViewValue;
            $viewAttrs = &$this->KDDPJP->ViewAttrs;
            $cellAttrs = &$this->KDDPJP->CellAttrs;
            $hrefValue = &$this->KDDPJP->HrefValue;
            $linkAttrs = &$this->KDDPJP->LinkAttrs;
            $this->cellRendered($this->KDDPJP, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // tgl_kontrol
            $currentValue = $this->tgl_kontrol->CurrentValue;
            $viewValue = &$this->tgl_kontrol->ViewValue;
            $viewAttrs = &$this->tgl_kontrol->ViewAttrs;
            $cellAttrs = &$this->tgl_kontrol->CellAttrs;
            $hrefValue = &$this->tgl_kontrol->HrefValue;
            $linkAttrs = &$this->tgl_kontrol->LinkAttrs;
            $this->cellRendered($this->tgl_kontrol, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);
        }

        // Call Row_Rendered event
        $this->rowRendered();
        $this->setupFieldCount();
    }
    private $groupCounts = [];

    // Get group count
    public function getGroupCount(...$args)
    {
        $key = "";
        foreach ($args as $arg) {
            if ($key != "") {
                $key .= "_";
            }
            $key .= strval($arg);
        }
        if ($key == "") {
            return -1;
        } elseif ($key == "0") { // Number of first level groups
            $i = 1;
            while (isset($this->groupCounts[strval($i)])) {
                $i++;
            }
            return $i - 1;
        }
        return isset($this->groupCounts[$key]) ? $this->groupCounts[$key] : -1;
    }

    // Set group count
    public function setGroupCount($value, ...$args)
    {
        $key = "";
        foreach ($args as $arg) {
            if ($key != "") {
                $key .= "_";
            }
            $key .= strval($arg);
        }
        if ($key == "") {
            return;
        }
        $this->groupCounts[$key] = $value;
    }

    // Setup field count
    protected function setupFieldCount()
    {
        $this->GroupColumnCount = 0;
        $this->SubGroupColumnCount = 0;
        $this->DetailColumnCount = 0;
        if ($this->NO_REGISTRATION->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->GENDER->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->CLASS_ROOM_ID->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->BED_ID->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->SERVED_INAP->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->STATUS_PASIEN_ID->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->ISRJ->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->VISIT_ID->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->IDXDAFTAR->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->DIANTAR_OLEH->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->EXIT_DATE->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->KELUAR_ID->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->AGEYEAR->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->ORG_UNIT_CODE->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->RUJUKAN_ID->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->ADDRESS_OF_RUJUKAN->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->REASON_ID->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->WAY_ID->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->PATIENT_CATEGORY_ID->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->BOOKED_DATE->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->VISIT_DATE->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->ISNEW->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->FOLLOW_UP->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->PLACE_TYPE->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->CLINIC_ID->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->CLINIC_ID_FROM->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->IN_DATE->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->DESCRIPTION->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->VISITOR_ADDRESS->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->MODIFIED_BY->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->MODIFIED_DATE->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->MODIFIED_FROM->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->EMPLOYEE_ID->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->EMPLOYEE_ID_FROM->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->RESPONSIBLE_ID->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->RESPONSIBLE->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->FAMILY_STATUS_ID->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->TICKET_NO->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->ISATTENDED->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->PAYOR_ID->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->CLASS_ID->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->ISPERTARIF->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->KAL_ID->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->EMPLOYEE_INAP->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->PASIEN_ID->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->KARYAWAN->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->ACCOUNT_ID->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->CLASS_ID_PLAFOND->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->BACKCHARGE->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->COVERAGE_ID->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->AGEMONTH->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->AGEDAY->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->RECOMENDATION->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->CONCLUSION->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->SPECIMENNO->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->LOCKED->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->RM_OUT_DATE->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->RM_IN_DATE->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->LAMA_PINJAM->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->STANDAR_RJ->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->LENGKAP_RJ->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->LENGKAP_RI->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->RESEND_RM_DATE->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->LENGKAP_RM1->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->LENGKAP_RESUME->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->LENGKAP_ANAMNESIS->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->LENGKAP_CONSENT->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->LENGKAP_ANESTESI->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->LENGKAP_OP->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->BACK_RM_DATE->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->VALID_RM_DATE->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->NO_SKP->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->NO_SKPINAP->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->DIAGNOSA_ID->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->ticket_all->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->tanggal_rujukan->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->NORUJUKAN->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->PPKRUJUKAN->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->LOKASILAKA->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->KDPOLI->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->EDIT_SEP->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->DELETE_SEP->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->KODE_AGAMA->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->DIAG_AWAL->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->AKTIF->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->BILL_INAP->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->SEP_PRINTDATE->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->MAPPING_SEP->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->TRANS_ID->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->KDPOLI_EKS->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->COB->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->PENJAMIN->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->ASALRUJUKAN->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->RESPONSEP->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->APPROVAL_DESC->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->APPROVAL_RESPONAJUKAN->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->APPROVAL_RESPONAPPROV->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->RESPONTGLPLG_DESC->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->RESPONPOST_VKLAIM->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->RESPONPUT_VKLAIM->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->RESPONDEL_VKLAIM->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->CALL_TIMES->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->CALL_DATE->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->CALL_DATES->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->SERVED_DATE->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->KDDPJP1->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->KDDPJP->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->tgl_kontrol->Visible) {
            $this->DetailColumnCount += 1;
        }
    }

    // Get export HTML tag
    protected function getExportTag($type, $custom = false)
    {
        global $Language;
        $pageUrl = $this->pageUrl();
        if (SameText($type, "excel")) {
            return '<a class="ew-export-link ew-excel" title="' . HtmlEncode($Language->phrase("ExportToExcel", true)) . '" data-caption="' . HtmlEncode($Language->phrase("ExportToExcel", true)) . '" href="#" onclick="return ew.exportWithCharts(event, \'' . $this->ExportExcelUrl . '\', \'' . session_id() . '\');">' . $Language->phrase("ExportToExcel") . '</a>';
        } elseif (SameText($type, "word")) {
            return '<a class="ew-export-link ew-word" title="' . HtmlEncode($Language->phrase("ExportToWord", true)) . '" data-caption="' . HtmlEncode($Language->phrase("ExportToWord", true)) . '" href="#" onclick="return ew.exportWithCharts(event, \'' . $this->ExportWordUrl . '\', \'' . session_id() . '\');">' . $Language->phrase("ExportToWord") . '</a>';
        } elseif (SameText($type, "pdf")) {
            return '<a class="ew-export-link ew-pdf" title="' . HtmlEncode($Language->phrase("ExportToPDF", true)) . '" data-caption="' . HtmlEncode($Language->phrase("ExportToPDF", true)) . '" href="#" onclick="return ew.exportWithCharts(event, \'' . $this->ExportPdfUrl . '\', \'' . session_id() . '\');">' . $Language->phrase("ExportToPDF") . '</a>';
        } elseif (SameText($type, "email")) {
            $url = $pageUrl . "export=email" . ($custom ? "&amp;custom=1" : "");
            return '<a class="ew-export-link ew-email" title="' . HtmlEncode($Language->phrase("ExportToEmail", true)) . '" data-caption="' . HtmlEncode($Language->phrase("ExportToEmail", true)) . '" id="emf_register_ranap" href="#" onclick="return ew.emailDialogShow({ lnk: \'emf_register_ranap\', hdr: ew.language.phrase(\'ExportToEmailText\'), url: \'' . $url . '\', exportid: \'' . session_id() . '\', el: this });">' . $Language->phrase("ExportToEmail") . '</a>';
        } elseif (SameText($type, "print")) {
            return "<a href=\"" . $this->ExportPrintUrl . "\" class=\"ew-export-link ew-print\" title=\"" . HtmlEncode($Language->phrase("PrinterFriendlyText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("PrinterFriendlyText")) . "\">" . $Language->phrase("PrinterFriendly") . "</a>";
        }
    }

    // Set up export options
    protected function setupExportOptions()
    {
        global $Language;

        // Printer friendly
        $item = &$this->ExportOptions->add("print");
        $item->Body = $this->getExportTag("print");
        $item->Visible = false;

        // Export to Excel
        $item = &$this->ExportOptions->add("excel");
        $item->Body = $this->getExportTag("excel");
        $item->Visible = false;

        // Export to Word
        $item = &$this->ExportOptions->add("word");
        $item->Body = $this->getExportTag("word");
        $item->Visible = false;

        // Export to Pdf
        $item = &$this->ExportOptions->add("pdf");
        $item->Body = $this->getExportTag("pdf");
        $item->Visible = false;

        // Export to Email
        $item = &$this->ExportOptions->add("email");
        $item->Body = $this->getExportTag("email");
        $item->Visible = false;

        // Drop down button for export
        $this->ExportOptions->UseButtonGroup = true;
        $this->ExportOptions->UseDropDownButton = false;
        if ($this->ExportOptions->UseButtonGroup && IsMobile()) {
            $this->ExportOptions->UseDropDownButton = true;
        }
        $this->ExportOptions->DropDownButtonPhrase = $Language->phrase("ButtonExport");

        // Add group option item
        $item = &$this->ExportOptions->add($this->ExportOptions->GroupOptionName);
        $item->Body = "";
        $item->Visible = false;

        // Hide options for export
        if ($this->isExport()) {
            $this->ExportOptions->hideAllOptions();
        }
    }

    // Set up search options
    protected function setupSearchOptions()
    {
        global $Language, $Security;
        $pageUrl = $this->pageUrl();
        $this->SearchOptions = new ListOptions("div");
        $this->SearchOptions->TagClassName = "ew-search-option";

        // Search button
        $item = &$this->SearchOptions->add("searchtoggle");
        $searchToggleClass = ($this->SearchWhere != "") ? " active" : " active";
        $item->Body = "<a class=\"btn btn-default ew-search-toggle" . $searchToggleClass . "\" href=\"#\" role=\"button\" title=\"" . $Language->phrase("SearchPanel") . "\" data-caption=\"" . $Language->phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fsummary\" aria-pressed=\"" . ($searchToggleClass == " active" ? "true" : "false") . "\">" . $Language->phrase("SearchLink") . "</a>";
        $item->Visible = true;

        // Show all button
        $item = &$this->SearchOptions->add("showall");
        $item->Body = "<a class=\"btn btn-default ew-show-all\" title=\"" . $Language->phrase("ShowAll") . "\" data-caption=\"" . $Language->phrase("ShowAll") . "\" href=\"" . $pageUrl . "cmd=reset\">" . $Language->phrase("ShowAllBtn") . "</a>";
        $item->Visible = ($this->SearchWhere != $this->DefaultSearchWhere && $this->SearchWhere != "0=101");

        // Button group for search
        $this->SearchOptions->UseDropDownButton = false;
        $this->SearchOptions->UseButtonGroup = true;
        $this->SearchOptions->DropDownButtonPhrase = $Language->phrase("ButtonSearch");

        // Add group option item
        $item = &$this->SearchOptions->add($this->SearchOptions->GroupOptionName);
        $item->Body = "";
        $item->Visible = false;

        // Hide search options
        if ($this->isExport() || $this->CurrentAction) {
            $this->SearchOptions->hideAllOptions();
        }
        if (!$Security->canSearch()) {
            $this->SearchOptions->hideAllOptions();
            $this->FilterOptions->hideAllOptions();
        }
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset / cmd=resetall
        $Breadcrumb->add("summary", $this->TableVar, $url, "", $this->TableVar, true);
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
                case "x_GENDER":
                    break;
                case "x_CLASS_ROOM_ID":
                    break;
                case "x_STATUS_PASIEN_ID":
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

    // Set up other options
    protected function setupOtherOptions()
    {
        global $Language, $Security;

        // Filter button
        $item = &$this->FilterOptions->add("savecurrentfilter");
        $item->Body = "<a class=\"ew-save-filter\" data-form=\"fsummary\" href=\"#\" onclick=\"return false;\">" . $Language->phrase("SaveCurrentFilter") . "</a>";
        $item->Visible = true;
        $item = &$this->FilterOptions->add("deletefilter");
        $item->Body = "<a class=\"ew-delete-filter\" data-form=\"fsummary\" href=\"#\" onclick=\"return false;\">" . $Language->phrase("DeleteFilter") . "</a>";
        $item->Visible = true;
        $this->FilterOptions->UseDropDownButton = true;
        $this->FilterOptions->UseButtonGroup = !$this->FilterOptions->UseDropDownButton;
        $this->FilterOptions->DropDownButtonPhrase = $Language->phrase("Filters");

        // Add group option item
        $item = &$this->FilterOptions->add($this->FilterOptions->GroupOptionName);
        $item->Body = "";
        $item->Visible = false;
    }

    // Set up starting group
    protected function setupStartGroup()
    {
        // Exit if no groups
        if ($this->DisplayGroups == 0) {
            return;
        }
        $startGrp = Param(Config("TABLE_START_GROUP"), "");
        $pageNo = Param("pageno", "");

        // Check for a 'start' parameter
        if ($startGrp != "") {
            $this->StartGroup = $startGrp;
            $this->setStartGroup($this->StartGroup);
        } elseif ($pageNo != "") {
            if (is_numeric($pageNo)) {
                $this->StartGroup = ($pageNo - 1) * $this->DisplayGroups + 1;
                if ($this->StartGroup <= 0) {
                    $this->StartGroup = 1;
                } elseif ($this->StartGroup >= intval(($this->TotalGroups - 1) / $this->DisplayGroups) * $this->DisplayGroups + 1) {
                    $this->StartGroup = intval(($this->TotalGroups - 1) / $this->DisplayGroups) * $this->DisplayGroups + 1;
                }
                $this->setStartGroup($this->StartGroup);
            } else {
                $this->StartGroup = $this->getStartGroup();
            }
        } else {
            $this->StartGroup = $this->getStartGroup();
        }

        // Check if correct start group counter
        if (!is_numeric($this->StartGroup) || $this->StartGroup == "") { // Avoid invalid start group counter
            $this->StartGroup = 1; // Reset start group counter
            $this->setStartGroup($this->StartGroup);
        } elseif (intval($this->StartGroup) > intval($this->TotalGroups)) { // Avoid starting group > total groups
            $this->StartGroup = intval(($this->TotalGroups - 1) / $this->DisplayGroups) * $this->DisplayGroups + 1; // Point to last page first group
            $this->setStartGroup($this->StartGroup);
        } elseif (($this->StartGroup - 1) % $this->DisplayGroups != 0) {
            $this->StartGroup = intval(($this->StartGroup - 1) / $this->DisplayGroups) * $this->DisplayGroups + 1; // Point to page boundary
            $this->setStartGroup($this->StartGroup);
        }
    }

    // Reset pager
    protected function resetPager()
    {
        // Reset start position (reset command)
        $this->StartGroup = 1;
        $this->setStartGroup($this->StartGroup);
    }

    // Set up number of groups displayed per page
    protected function setupDisplayGroups()
    {
        $this->DisplayGroups = 5; // Load default
        if (Param(Config("TABLE_GROUP_PER_PAGE")) !== null) {
            $wrk = Param(Config("TABLE_GROUP_PER_PAGE"));
            if (is_numeric($wrk)) {
                $this->DisplayGroups = intval($wrk);
            } elseif (strtoupper($wrk) == "ALL") { // Display all groups
                $this->DisplayGroups = -1;
            }

            // Reset start position (reset command)
            $this->StartGroup = 1;
            $this->setStartGroup($this->StartGroup);
        } elseif ($this->getGroupPerPage() != "") {
            $this->DisplayGroups = $this->getGroupPerPage(); // Restore from session
        }
        $this->setGroupPerPage($this->DisplayGroups); // Save to session
    }

    // Get sort parameters based on sort links clicked
    protected function getSort()
    {
        if ($this->DrillDown) {
            return "dbo.PASIEN_VISITATION.VISIT_DATE DESC";
        }
        $resetSort = Param("cmd") === "resetsort";
        $orderBy = Param("order", "");
        $orderType = Param("ordertype", "");

        // Check for a resetsort command
        if ($resetSort) {
            $this->setOrderBy("");
            $this->setStartGroup(1);
            $this->NO_REGISTRATION->setSort("");
            $this->GENDER->setSort("");
            $this->CLASS_ROOM_ID->setSort("");
            $this->BED_ID->setSort("");
            $this->SERVED_INAP->setSort("");
            $this->STATUS_PASIEN_ID->setSort("");
            $this->ISRJ->setSort("");
            $this->VISIT_ID->setSort("");
            $this->IDXDAFTAR->setSort("");
            $this->DIANTAR_OLEH->setSort("");
            $this->EXIT_DATE->setSort("");
            $this->KELUAR_ID->setSort("");
            $this->AGEYEAR->setSort("");
            $this->ORG_UNIT_CODE->setSort("");
            $this->RUJUKAN_ID->setSort("");
            $this->ADDRESS_OF_RUJUKAN->setSort("");
            $this->REASON_ID->setSort("");
            $this->WAY_ID->setSort("");
            $this->PATIENT_CATEGORY_ID->setSort("");
            $this->BOOKED_DATE->setSort("");
            $this->VISIT_DATE->setSort("");
            $this->ISNEW->setSort("");
            $this->FOLLOW_UP->setSort("");
            $this->PLACE_TYPE->setSort("");
            $this->CLINIC_ID->setSort("");
            $this->CLINIC_ID_FROM->setSort("");
            $this->IN_DATE->setSort("");
            $this->DESCRIPTION->setSort("");
            $this->VISITOR_ADDRESS->setSort("");
            $this->MODIFIED_BY->setSort("");
            $this->MODIFIED_DATE->setSort("");
            $this->MODIFIED_FROM->setSort("");
            $this->EMPLOYEE_ID->setSort("");
            $this->EMPLOYEE_ID_FROM->setSort("");
            $this->RESPONSIBLE_ID->setSort("");
            $this->RESPONSIBLE->setSort("");
            $this->FAMILY_STATUS_ID->setSort("");
            $this->TICKET_NO->setSort("");
            $this->ISATTENDED->setSort("");
            $this->PAYOR_ID->setSort("");
            $this->CLASS_ID->setSort("");
            $this->ISPERTARIF->setSort("");
            $this->KAL_ID->setSort("");
            $this->EMPLOYEE_INAP->setSort("");
            $this->PASIEN_ID->setSort("");
            $this->KARYAWAN->setSort("");
            $this->ACCOUNT_ID->setSort("");
            $this->CLASS_ID_PLAFOND->setSort("");
            $this->BACKCHARGE->setSort("");
            $this->COVERAGE_ID->setSort("");
            $this->AGEMONTH->setSort("");
            $this->AGEDAY->setSort("");
            $this->RECOMENDATION->setSort("");
            $this->CONCLUSION->setSort("");
            $this->SPECIMENNO->setSort("");
            $this->LOCKED->setSort("");
            $this->RM_OUT_DATE->setSort("");
            $this->RM_IN_DATE->setSort("");
            $this->LAMA_PINJAM->setSort("");
            $this->STANDAR_RJ->setSort("");
            $this->LENGKAP_RJ->setSort("");
            $this->LENGKAP_RI->setSort("");
            $this->RESEND_RM_DATE->setSort("");
            $this->LENGKAP_RM1->setSort("");
            $this->LENGKAP_RESUME->setSort("");
            $this->LENGKAP_ANAMNESIS->setSort("");
            $this->LENGKAP_CONSENT->setSort("");
            $this->LENGKAP_ANESTESI->setSort("");
            $this->LENGKAP_OP->setSort("");
            $this->BACK_RM_DATE->setSort("");
            $this->VALID_RM_DATE->setSort("");
            $this->NO_SKP->setSort("");
            $this->NO_SKPINAP->setSort("");
            $this->DIAGNOSA_ID->setSort("");
            $this->ticket_all->setSort("");
            $this->tanggal_rujukan->setSort("");
            $this->NORUJUKAN->setSort("");
            $this->PPKRUJUKAN->setSort("");
            $this->LOKASILAKA->setSort("");
            $this->KDPOLI->setSort("");
            $this->EDIT_SEP->setSort("");
            $this->DELETE_SEP->setSort("");
            $this->KODE_AGAMA->setSort("");
            $this->DIAG_AWAL->setSort("");
            $this->AKTIF->setSort("");
            $this->BILL_INAP->setSort("");
            $this->SEP_PRINTDATE->setSort("");
            $this->MAPPING_SEP->setSort("");
            $this->TRANS_ID->setSort("");
            $this->KDPOLI_EKS->setSort("");
            $this->COB->setSort("");
            $this->PENJAMIN->setSort("");
            $this->ASALRUJUKAN->setSort("");
            $this->RESPONSEP->setSort("");
            $this->APPROVAL_DESC->setSort("");
            $this->APPROVAL_RESPONAJUKAN->setSort("");
            $this->APPROVAL_RESPONAPPROV->setSort("");
            $this->RESPONTGLPLG_DESC->setSort("");
            $this->RESPONPOST_VKLAIM->setSort("");
            $this->RESPONPUT_VKLAIM->setSort("");
            $this->RESPONDEL_VKLAIM->setSort("");
            $this->CALL_TIMES->setSort("");
            $this->CALL_DATE->setSort("");
            $this->CALL_DATES->setSort("");
            $this->SERVED_DATE->setSort("");
            $this->KDDPJP1->setSort("");
            $this->KDDPJP->setSort("");
            $this->tgl_kontrol->setSort("");

        // Check for an Order parameter
        } elseif ($orderBy != "") {
            $this->CurrentOrder = $orderBy;
            $this->CurrentOrderType = $orderType;
            $this->updateSort($this->NO_REGISTRATION); // NO_REGISTRATION
            $this->updateSort($this->GENDER); // GENDER
            $this->updateSort($this->CLASS_ROOM_ID); // CLASS_ROOM_ID
            $this->updateSort($this->BED_ID); // BED_ID
            $this->updateSort($this->SERVED_INAP); // SERVED_INAP
            $this->updateSort($this->STATUS_PASIEN_ID); // STATUS_PASIEN_ID
            $this->updateSort($this->ISRJ); // ISRJ
            $this->updateSort($this->VISIT_ID); // VISIT_ID
            $this->updateSort($this->IDXDAFTAR); // IDXDAFTAR
            $this->updateSort($this->DIANTAR_OLEH); // DIANTAR_OLEH
            $this->updateSort($this->EXIT_DATE); // EXIT_DATE
            $this->updateSort($this->KELUAR_ID); // KELUAR_ID
            $this->updateSort($this->AGEYEAR); // AGEYEAR
            $this->updateSort($this->ORG_UNIT_CODE); // ORG_UNIT_CODE
            $this->updateSort($this->RUJUKAN_ID); // RUJUKAN_ID
            $this->updateSort($this->ADDRESS_OF_RUJUKAN); // ADDRESS_OF_RUJUKAN
            $this->updateSort($this->REASON_ID); // REASON_ID
            $this->updateSort($this->WAY_ID); // WAY_ID
            $this->updateSort($this->PATIENT_CATEGORY_ID); // PATIENT_CATEGORY_ID
            $this->updateSort($this->BOOKED_DATE); // BOOKED_DATE
            $this->updateSort($this->VISIT_DATE); // VISIT_DATE
            $this->updateSort($this->ISNEW); // ISNEW
            $this->updateSort($this->FOLLOW_UP); // FOLLOW_UP
            $this->updateSort($this->PLACE_TYPE); // PLACE_TYPE
            $this->updateSort($this->CLINIC_ID); // CLINIC_ID
            $this->updateSort($this->CLINIC_ID_FROM); // CLINIC_ID_FROM
            $this->updateSort($this->IN_DATE); // IN_DATE
            $this->updateSort($this->DESCRIPTION); // DESCRIPTION
            $this->updateSort($this->VISITOR_ADDRESS); // VISITOR_ADDRESS
            $this->updateSort($this->MODIFIED_BY); // MODIFIED_BY
            $this->updateSort($this->MODIFIED_DATE); // MODIFIED_DATE
            $this->updateSort($this->MODIFIED_FROM); // MODIFIED_FROM
            $this->updateSort($this->EMPLOYEE_ID); // EMPLOYEE_ID
            $this->updateSort($this->EMPLOYEE_ID_FROM); // EMPLOYEE_ID_FROM
            $this->updateSort($this->RESPONSIBLE_ID); // RESPONSIBLE_ID
            $this->updateSort($this->RESPONSIBLE); // RESPONSIBLE
            $this->updateSort($this->FAMILY_STATUS_ID); // FAMILY_STATUS_ID
            $this->updateSort($this->TICKET_NO); // TICKET_NO
            $this->updateSort($this->ISATTENDED); // ISATTENDED
            $this->updateSort($this->PAYOR_ID); // PAYOR_ID
            $this->updateSort($this->CLASS_ID); // CLASS_ID
            $this->updateSort($this->ISPERTARIF); // ISPERTARIF
            $this->updateSort($this->KAL_ID); // KAL_ID
            $this->updateSort($this->EMPLOYEE_INAP); // EMPLOYEE_INAP
            $this->updateSort($this->PASIEN_ID); // PASIEN_ID
            $this->updateSort($this->KARYAWAN); // KARYAWAN
            $this->updateSort($this->ACCOUNT_ID); // ACCOUNT_ID
            $this->updateSort($this->CLASS_ID_PLAFOND); // CLASS_ID_PLAFOND
            $this->updateSort($this->BACKCHARGE); // BACKCHARGE
            $this->updateSort($this->COVERAGE_ID); // COVERAGE_ID
            $this->updateSort($this->AGEMONTH); // AGEMONTH
            $this->updateSort($this->AGEDAY); // AGEDAY
            $this->updateSort($this->RECOMENDATION); // RECOMENDATION
            $this->updateSort($this->CONCLUSION); // CONCLUSION
            $this->updateSort($this->SPECIMENNO); // SPECIMENNO
            $this->updateSort($this->LOCKED); // LOCKED
            $this->updateSort($this->RM_OUT_DATE); // RM_OUT_DATE
            $this->updateSort($this->RM_IN_DATE); // RM_IN_DATE
            $this->updateSort($this->LAMA_PINJAM); // LAMA_PINJAM
            $this->updateSort($this->STANDAR_RJ); // STANDAR_RJ
            $this->updateSort($this->LENGKAP_RJ); // LENGKAP_RJ
            $this->updateSort($this->LENGKAP_RI); // LENGKAP_RI
            $this->updateSort($this->RESEND_RM_DATE); // RESEND_RM_DATE
            $this->updateSort($this->LENGKAP_RM1); // LENGKAP_RM1
            $this->updateSort($this->LENGKAP_RESUME); // LENGKAP_RESUME
            $this->updateSort($this->LENGKAP_ANAMNESIS); // LENGKAP_ANAMNESIS
            $this->updateSort($this->LENGKAP_CONSENT); // LENGKAP_CONSENT
            $this->updateSort($this->LENGKAP_ANESTESI); // LENGKAP_ANESTESI
            $this->updateSort($this->LENGKAP_OP); // LENGKAP_OP
            $this->updateSort($this->BACK_RM_DATE); // BACK_RM_DATE
            $this->updateSort($this->VALID_RM_DATE); // VALID_RM_DATE
            $this->updateSort($this->NO_SKP); // NO_SKP
            $this->updateSort($this->NO_SKPINAP); // NO_SKPINAP
            $this->updateSort($this->DIAGNOSA_ID); // DIAGNOSA_ID
            $this->updateSort($this->ticket_all); // ticket_all
            $this->updateSort($this->tanggal_rujukan); // tanggal_rujukan
            $this->updateSort($this->NORUJUKAN); // NORUJUKAN
            $this->updateSort($this->PPKRUJUKAN); // PPKRUJUKAN
            $this->updateSort($this->LOKASILAKA); // LOKASILAKA
            $this->updateSort($this->KDPOLI); // KDPOLI
            $this->updateSort($this->EDIT_SEP); // EDIT_SEP
            $this->updateSort($this->DELETE_SEP); // DELETE_SEP
            $this->updateSort($this->KODE_AGAMA); // KODE_AGAMA
            $this->updateSort($this->DIAG_AWAL); // DIAG_AWAL
            $this->updateSort($this->AKTIF); // AKTIF
            $this->updateSort($this->BILL_INAP); // BILL_INAP
            $this->updateSort($this->SEP_PRINTDATE); // SEP_PRINTDATE
            $this->updateSort($this->MAPPING_SEP); // MAPPING_SEP
            $this->updateSort($this->TRANS_ID); // TRANS_ID
            $this->updateSort($this->KDPOLI_EKS); // KDPOLI_EKS
            $this->updateSort($this->COB); // COB
            $this->updateSort($this->PENJAMIN); // PENJAMIN
            $this->updateSort($this->ASALRUJUKAN); // ASALRUJUKAN
            $this->updateSort($this->RESPONSEP); // RESPONSEP
            $this->updateSort($this->APPROVAL_DESC); // APPROVAL_DESC
            $this->updateSort($this->APPROVAL_RESPONAJUKAN); // APPROVAL_RESPONAJUKAN
            $this->updateSort($this->APPROVAL_RESPONAPPROV); // APPROVAL_RESPONAPPROV
            $this->updateSort($this->RESPONTGLPLG_DESC); // RESPONTGLPLG_DESC
            $this->updateSort($this->RESPONPOST_VKLAIM); // RESPONPOST_VKLAIM
            $this->updateSort($this->RESPONPUT_VKLAIM); // RESPONPUT_VKLAIM
            $this->updateSort($this->RESPONDEL_VKLAIM); // RESPONDEL_VKLAIM
            $this->updateSort($this->CALL_TIMES); // CALL_TIMES
            $this->updateSort($this->CALL_DATE); // CALL_DATE
            $this->updateSort($this->CALL_DATES); // CALL_DATES
            $this->updateSort($this->SERVED_DATE); // SERVED_DATE
            $this->updateSort($this->KDDPJP1); // KDDPJP1
            $this->updateSort($this->KDDPJP); // KDDPJP
            $this->updateSort($this->tgl_kontrol); // tgl_kontrol
            $sortSql = $this->sortSql();
            $this->setOrderBy($sortSql);
            $this->setStartGroup(1);
        }

        // Set up default sort
        if ($this->getOrderBy() == "") {
            $useDefaultSort = true;
            if ($this->VISIT_DATE->getSort() != "") {
                $useDefaultSort = false;
            }
            if ($useDefaultSort) {
                $this->VISIT_DATE->setSort("DESC");
                $this->setOrderBy("dbo.PASIEN_VISITATION.VISIT_DATE DESC");
            }
        }
        return $this->getOrderBy();
    }

    // Return extended filter
    protected function getExtendedFilter()
    {
        $filter = "";
        if ($this->DrillDown) {
            return "";
        }
        $restoreSession = false;
        $restoreDefault = false;
        // Reset search command
        if (Get("cmd", "") == "reset") {
            // Set default values
            $this->CLASS_ROOM_ID->AdvancedSearch->unsetSession();
            $this->SERVED_INAP->AdvancedSearch->unsetSession();
            $restoreDefault = true;
        } else {
            $restoreSession = !$this->SearchCommand;

            // Field CLASS_ROOM_ID
            $this->getDropDownValue($this->CLASS_ROOM_ID);

            // Field SERVED_INAP
            if ($this->SERVED_INAP->AdvancedSearch->get()) {
            }
            if (!$this->validateForm()) {
                return $filter;
            }
        }

        // Restore session
        if ($restoreSession) {
            $restoreDefault = true;
            if ($this->CLASS_ROOM_ID->AdvancedSearch->issetSession()) { // Field CLASS_ROOM_ID
                $this->CLASS_ROOM_ID->AdvancedSearch->load();
                $restoreDefault = false;
            }
            if ($this->SERVED_INAP->AdvancedSearch->issetSession()) { // Field SERVED_INAP
                $this->SERVED_INAP->AdvancedSearch->load();
                $restoreDefault = false;
            }
        }

        // Restore default
        if ($restoreDefault) {
            $this->loadDefaultFilters();
        }

        // Call page filter validated event
        $this->pageFilterValidated();

        // Build SQL and save to session
        $this->buildDropDownFilter($this->CLASS_ROOM_ID, $filter, $this->CLASS_ROOM_ID->AdvancedSearch->SearchOperator, false, true); // Field CLASS_ROOM_ID
        $this->CLASS_ROOM_ID->AdvancedSearch->save();
        $this->buildExtendedFilter($this->SERVED_INAP, $filter, false, true); // Field SERVED_INAP
        $this->SERVED_INAP->AdvancedSearch->save();

        // Field CLASS_ROOM_ID
        LoadDropDownList($this->CLASS_ROOM_ID->EditValue, $this->CLASS_ROOM_ID->AdvancedSearch->SearchValue);
        return $filter;
    }

    // Build dropdown filter
    protected function buildDropDownFilter(&$fld, &$filterClause, $fldOpr, $default = false, $saveFilter = false)
    {
        $fldVal = $default ? $fld->AdvancedSearch->SearchValueDefault : $fld->AdvancedSearch->SearchValue;
        $sql = "";
        if (is_array($fldVal)) {
            foreach ($fldVal as $val) {
                $wrk = $this->getDropDownFilter($fld, $val, $fldOpr);
                if ($wrk != "") {
                    if ($sql != "") {
                        $sql .= " OR " . $wrk;
                    } else {
                        $sql = $wrk;
                    }
                }
            }
        } else {
            $fldVal2 = $default ? $fld->AdvancedSearch->SearchValue2Default : $fld->AdvancedSearch->SearchValue2;
            $sql = $this->getDropDownFilter($fld, $fldVal, $fldOpr, $fldVal2);
        }
        if ($sql != "") {
            AddFilter($filterClause, $sql);
            if ($saveFilter) {
                $fld->CurrentFilter = $sql;
            }
        }
    }

    // Get dropdown filter
    protected function getDropDownFilter(&$fld, $fldVal, $fldOpr, $fldVal2 = "")
    {
        $fldName = $fld->Name;
        $fldExpression = $fld->Expression;
        $fldDataType = $fld->DataType;
        $isMultiple = $fld->HtmlTag == "CHECKBOX" || $fld->HtmlTag == "SELECT" && $fld->SelectMultiple;
        $fldVal = strval($fldVal);
        if ($fldOpr == "") {
            $fldOpr = "=";
        }
        $wrk = "";
        if (SameString($fldVal, Config("NULL_VALUE"))) {
            $wrk = $fldExpression . " IS NULL";
        } elseif (SameString($fldVal, Config("NOT_NULL_VALUE"))) {
            $wrk = $fldExpression . " IS NOT NULL";
        } elseif (SameString($fldVal, EMPTY_VALUE)) {
            $wrk = $fldExpression . " = ''";
        } elseif (SameString($fldVal, ALL_VALUE)) {
            $wrk = "1 = 1";
        } else {
            if ($fld->GroupSql != "") { // Use grouping SQL for search if exists
                $fldExpression = str_replace("%s", $fldExpression, $fld->GroupSql);
            }
            if (StartsString("@@", $fldVal)) {
                $wrk = $this->getCustomFilter($fld, $fldVal, $this->Dbid);
            } elseif ($isMultiple && IsMultiSearchOperator($fldOpr) && trim($fldVal) != "" && $fldVal != INIT_VALUE && ($fldDataType == DATATYPE_NUMBER || $fldDataType == DATATYPE_STRING || $fldDataType == DATATYPE_MEMO)) {
                $wrk = GetMultiSearchSql($fld, $fldOpr, trim($fldVal), $this->Dbid);
            } elseif ($fldOpr == "BETWEEN" && $fldVal != "" && $fldVal != INIT_VALUE && $fldVal2 != "" && $fldVal2 != INIT_VALUE) {
                $wrk = $fldExpression ." " . $fldOpr . " " . QuotedValue($fldVal, $fldDataType, $this->Dbid) . " AND " . QuotedValue($fldVal2, $fldDataType, $this->Dbid);
            } else {
                if ($fldVal != "" && $fldVal != INIT_VALUE) {
                    if ($fldDataType == DATATYPE_DATE && $fld->GroupSql == "" && $fldOpr != "") {
                        $wrk = GetDateFilterSql($fldExpression, $fldOpr, $fldVal, $fldDataType, $this->Dbid);
                    } else {
                        $wrk = GetFilterSql($fldOpr, $fldVal, $fldDataType, $this->Dbid);
                        if ($wrk != "") {
                            $wrk = $fldExpression . $wrk;
                        }
                    }
                }
            }
        }

        // Call Page Filtering event
        if (!StartsString("@@", $fldVal)) {
            $this->pageFiltering($fld, $wrk, "dropdown", $fldOpr, $fldVal);
        }
        return $wrk;
    }

    // Get custom filter
    protected function getCustomFilter(&$fld, $fldVal, $dbid = 0)
    {
        $wrk = "";
        if (is_array($fld->AdvancedFilters)) {
            foreach ($fld->AdvancedFilters as $filter) {
                if ($filter->ID == $fldVal && $filter->Enabled) {
                    $fldExpr = $fld->Expression;
                    $fn = $filter->FunctionName;
                    $wrkid = StartsString("@@", $filter->ID) ? substr($filter->ID, 2) : $filter->ID;
                    $fn = $fn != "" && !function_exists($fn) ? PROJECT_NAMESPACE . $fn : $fn;
                    if (function_exists($fn)) {
                        $wrk = $fn($fldExpr, $dbid);
                    } else {
                        $wrk = "";
                    }
                    $this->pageFiltering($fld, $wrk, "custom", $wrkid);
                    break;
                }
            }
        }
        return $wrk;
    }

    // Build extended filter
    protected function buildExtendedFilter(&$fld, &$filterClause, $default = false, $saveFilter = false)
    {
        $wrk = GetExtendedFilter($fld, $default, $this->Dbid);
        if (!$default) {
            $this->pageFiltering($fld, $wrk, "extended", $fld->AdvancedSearch->SearchOperator, $fld->AdvancedSearch->SearchValue, $fld->AdvancedSearch->SearchCondition, $fld->AdvancedSearch->SearchOperator2, $fld->AdvancedSearch->SearchValue2);
        }
        if ($wrk != "") {
            AddFilter($filterClause, $wrk);
            if ($saveFilter) {
                $fld->CurrentFilter = $wrk;
            }
        }
    }

    // Get drop down value from querystring
    protected function getDropDownValue(&$fld)
    {
        $ret = false;
        $parm = $fld->Param;
        if (IsPost()) {
            return false; // Skip post back
        }
        $opr = Get("z_$parm");
        if ($opr !== null) {
            $fld->AdvancedSearch->SearchOperator = $opr;
        }
        $val = Get("x_$parm");
        if ($val !== null) {
            if (is_array($val)) {
                $val = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $val);
            }
            $fld->AdvancedSearch->setSearchValue($val);
            $ret = true;
        }
        $val = Get("y_$parm");
        if ($val !== null) {
            if (is_array($val)) {
                $val = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $val);
            }
            $fld->AdvancedSearch->setSearchValue2($val);
            $ret = true;
        }
        return $ret;
    }

    // Dropdown filter exist
    protected function dropDownFilterExist(&$fld, $fldOpr)
    {
        $wrk = "";
        $this->buildDropDownFilter($fld, $wrk, $fldOpr);
        return ($wrk != "");
    }

    // Extended filter exist
    protected function extendedFilterExist(&$fld)
    {
        $extWrk = "";
        $this->buildExtendedFilter($fld, $extWrk);
        return ($extWrk != "");
    }

    // Validate form
    protected function validateForm()
    {
        global $Language;

        // Check if validation required
        if (!Config("SERVER_VALIDATE")) {
            return true;
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

    // Load default value for filters
    protected function loadDefaultFilters()
    {
        // Field CLASS_ROOM_ID
        $this->CLASS_ROOM_ID->AdvancedSearch->loadDefault();

        // Field SERVED_INAP
        $this->SERVED_INAP->AdvancedSearch->loadDefault();
    }

    // Show list of filters
    public function showFilterList()
    {
        global $Language;

        // Initialize
        $filterList = "";
        $captionClass = $this->isExport("email") ? "ew-filter-caption-email" : "ew-filter-caption";
        $captionSuffix = $this->isExport("email") ? ": " : "";

        // Field CLASS_ROOM_ID
        $extWrk = "";
        $this->buildDropDownFilter($this->CLASS_ROOM_ID, $extWrk, $this->CLASS_ROOM_ID->AdvancedSearch->SearchOperator);
        $filter = "";
        if ($extWrk != "") {
            $filter .= "<span class=\"ew-filter-value\">$extWrk</span>";
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->CLASS_ROOM_ID->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field SERVED_INAP
        $extWrk = "";
        $this->buildExtendedFilter($this->SERVED_INAP, $extWrk);
        $filter = "";
        if ($extWrk != "") {
            $filter .= "<span class=\"ew-filter-value\">$extWrk</span>";
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->SERVED_INAP->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Show Filters
        if ($filterList != "") {
            $message = "<div id=\"ew-filter-list\" class=\"alert alert-info d-table\"><div id=\"ew-current-filters\">" .
                $Language->phrase("CurrentFilters") . "</div>" . $filterList . "</div>";
            $this->messageShowing($message, "");
            Write($message);
        }
    }

    // Get list of filters
    public function getFilterList()
    {
        global $UserProfile;

        // Initialize
        $filterList = "";
        $savedFilterList = "";

        // Field CLASS_ROOM_ID
        $wrk = "";
        $wrk = ($this->CLASS_ROOM_ID->AdvancedSearch->SearchValue != INIT_VALUE) ? $this->CLASS_ROOM_ID->AdvancedSearch->SearchValue : "";
        if (is_array($wrk)) {
            $wrk = implode("||", $wrk);
        }
        if ($wrk != "") {
            $wrk = "\"x_CLASS_ROOM_ID\":\"" . JsEncode($wrk) . "\"";
        }
        if ($wrk != "") {
            if ($filterList != "") {
                $filterList .= ",";
            }
            $filterList .= $wrk;
        }

        // Field SERVED_INAP
        $wrk = "";
        if ($this->SERVED_INAP->AdvancedSearch->SearchValue != "" || $this->SERVED_INAP->AdvancedSearch->SearchValue2 != "") {
            $wrk = "\"x_SERVED_INAP\":\"" . JsEncode($this->SERVED_INAP->AdvancedSearch->SearchValue) . "\"," .
                "\"z_SERVED_INAP\":\"" . JsEncode($this->SERVED_INAP->AdvancedSearch->SearchOperator) . "\"," .
                "\"v_SERVED_INAP\":\"" . JsEncode($this->SERVED_INAP->AdvancedSearch->SearchCondition) . "\"," .
                "\"y_SERVED_INAP\":\"" . JsEncode($this->SERVED_INAP->AdvancedSearch->SearchValue2) . "\"," .
                "\"w_SERVED_INAP\":\"" . JsEncode($this->SERVED_INAP->AdvancedSearch->SearchOperator2) . "\"";
        }
        if ($wrk != "") {
            if ($filterList != "") {
                $filterList .= ",";
            }
            $filterList .= $wrk;
        }

        // Return filter list in json
        if ($filterList != "") {
            $filterList = "\"data\":{" . $filterList . "}";
        }
        if ($savedFilterList != "") {
            $filterList = Concat($filterList, "\"filters\":" . $savedFilterList, ",");
        }
        return ($filterList != "") ? "{" . $filterList . "}" : "null";
    }

    // Restore list of filters
    protected function restoreFilterList()
    {
        // Return if not reset filter
        if (Post("cmd", "") != "resetfilter") {
            return false;
        }
        $filter = json_decode(Post("filter", ""), true);
        return $this->setupFilterList($filter);
    }

    // Setup list of filters
    protected function setupFilterList($filter)
    {
        if (!is_array($filter)) {
            return false;
        }

        // Field CLASS_ROOM_ID
        if (!$this->CLASS_ROOM_ID->AdvancedSearch->getFromArray($filter)) {
            $this->CLASS_ROOM_ID->AdvancedSearch->loadDefault(); // Clear filter
        }
        $this->CLASS_ROOM_ID->AdvancedSearch->save();

        // Field SERVED_INAP
        if (!$this->SERVED_INAP->AdvancedSearch->getFromArray($filter)) {
            $this->SERVED_INAP->AdvancedSearch->loadDefault(); // Clear filter
        }
        $this->SERVED_INAP->AdvancedSearch->save();
        return true;
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

    // Page Breaking event
    public function pageBreaking(&$break, &$content)
    {
        // Example:
        //$break = false; // Skip page break, or
        //$content = "<div style=\"page-break-after:always;\">&nbsp;</div>"; // Modify page break content
    }

    // Load Filters event
    public function pageFilterLoad()
    {
        // Enter your code here
        // Example: Register/Unregister Custom Extended Filter
        //RegisterFilter($this-><Field>, 'StartsWithA', 'Starts With A', 'GetStartsWithAFilter'); // With function, or
        //RegisterFilter($this-><Field>, 'StartsWithA', 'Starts With A'); // No function, use Page_Filtering event
        //UnregisterFilter($this-><Field>, 'StartsWithA');
    }

    // Page Selecting event
    public function pageSelecting(&$filter)
    {
        // Enter your code here
    }

    // Page Filter Validated event
    public function pageFilterValidated()
    {
        // Example:
        //$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value
    }

    // Page Filtering event
    public function pageFiltering(&$fld, &$filter, $typ, $opr = "", $val = "", $cond = "", $opr2 = "", $val2 = "")
    {
        // Note: ALWAYS CHECK THE FILTER TYPE ($typ)! Example:
        //if ($typ == "dropdown" && $fld->Name == "MyField") // Dropdown filter
        //    $filter = "..."; // Modify the filter
        //if ($typ == "extended" && $fld->Name == "MyField") // Extended filter
        //    $filter = "..."; // Modify the filter
        //if ($typ == "custom" && $opr == "..." && $fld->Name == "MyField") // Custom filter, $opr is the custom filter ID
        //    $filter = "..."; // Modify the filter
    }

    // Cell Rendered event
    public function cellRendered(&$Field, $CurrentValue, &$ViewValue, &$ViewAttrs, &$CellAttrs, &$HrefValue, &$LinkAttrs)
    {
        //$ViewValue = "xxx";
        //$ViewAttrs["class"] = "xxx";
    }

    // Form Custom Validate event
    public function formCustomValidate(&$customError)
    {
        // Return error message in CustomError
        return true;
    }
}
