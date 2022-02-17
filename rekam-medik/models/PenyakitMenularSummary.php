<?php

namespace PHPMaker2021\SIMRSSQLSERVERREKAMMEDIK;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class PenyakitMenularSummary extends PenyakitMenular
{
    use MessagesTrait;

    // Page ID
    public $PageID = "summary";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'penyakit_menular';

    // Page object name
    public $PageObjName = "PenyakitMenularSummary";

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

        // Table object (penyakit_menular)
        if (!isset($GLOBALS["penyakit_menular"]) || get_class($GLOBALS["penyakit_menular"]) == PROJECT_NAMESPACE . "penyakit_menular") {
            $GLOBALS["penyakit_menular"] = &$this;
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
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'penyakit_menular');
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
    public $SearchFieldsPerRow = 1; // For extended search
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
        $this->THENAME->setVisibility();
        $this->KELUAR_ID->setVisibility();
        $this->DATE_OF_DIAGNOSA->setVisibility();
        $this->DIAGNOSA_ID->setVisibility();
        $this->SUFFER_TYPE->setVisibility();
        $this->AGEYEAR->setVisibility();
        $this->THEADDRESS->setVisibility();
        $this->GENDER->setVisibility();
        $this->ID->setVisibility();

        // Set up groups per page dynamically
        $this->setupDisplayGroups();

        // Set up Breadcrumb
        if (!$this->isExport() && !$DashboardReport) {
            $this->setupBreadcrumb();
        }

        // Load custom filters
        $this->pageFilterLoad();

        // Extended filter
        $extendedFilter = "";

        // No filter
        $this->FilterOptions["savecurrentfilter"]->Visible = false;
        $this->FilterOptions["deletefilter"]->Visible = false;

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
        $data["ORG_UNIT_CODE"] = $record['ORG_UNIT_CODE'];
        $data["PASIEN_DIAGNOSA_ID"] = $record['PASIEN_DIAGNOSA_ID'];
        $data["NO_REGISTRATION"] = $record['NO_REGISTRATION'];
        $data["THENAME"] = $record['THENAME'];
        $data["VISIT_ID"] = $record['VISIT_ID'];
        $data["CLINIC_ID"] = $record['CLINIC_ID'];
        $data["BILL_ID"] = $record['BILL_ID'];
        $data["CLASS_ROOM_ID"] = $record['CLASS_ROOM_ID'];
        $data["IN_DATE"] = $record['IN_DATE'];
        $data["EXIT_DATE"] = $record['EXIT_DATE'];
        $data["BED_ID"] = $record['BED_ID'];
        $data["KELUAR_ID"] = $record['KELUAR_ID'];
        $data["DATE_OF_DIAGNOSA"] = $record['DATE_OF_DIAGNOSA'];
        $data["REPORT_DATE"] = $record['REPORT_DATE'];
        $data["DIAGNOSA_ID"] = $record['DIAGNOSA_ID'];
        $data["DIAGNOSA_DESC"] = $record['DIAGNOSA_DESC'];
        $data["ANAMNASE"] = $record['ANAMNASE'];
        $data["PEMERIKSAAN"] = $record['PEMERIKSAAN'];
        $data["TERAPHY_DESC"] = $record['TERAPHY_DESC'];
        $data["INSTRUCTION"] = $record['INSTRUCTION'];
        $data["SUFFER_TYPE"] = $record['SUFFER_TYPE'];
        $data["INFECTED_BODY"] = $record['INFECTED_BODY'];
        $data["EMPLOYEE_ID"] = $record['EMPLOYEE_ID'];
        $data["RISK_LEVEL"] = $record['RISK_LEVEL'];
        $data["MORFOLOGI_NEOPLASMA"] = $record['MORFOLOGI_NEOPLASMA'];
        $data["HURT"] = $record['HURT'];
        $data["HURT_TYPE"] = $record['HURT_TYPE'];
        $data["DIAG_CAT"] = $record['DIAG_CAT'];
        $data["ADDICTION_MATERIAL"] = $record['ADDICTION_MATERIAL'];
        $data["INFECTED_QUANTITY"] = $record['INFECTED_QUANTITY'];
        $data["CONTAGIOUS_TYPE"] = $record['CONTAGIOUS_TYPE'];
        $data["CURATIF_ID"] = $record['CURATIF_ID'];
        $data["RESULT_ID"] = $record['RESULT_ID'];
        $data["INFECTION_TYPE"] = $record['INFECTION_TYPE'];
        $data["INVESTIGATION_ID"] = $record['INVESTIGATION_ID'];
        $data["DISABILITY"] = $record['DISABILITY'];
        $data["DESCRIPTION"] = $record['DESCRIPTION'];
        $data["KOMPLIKASI"] = $record['KOMPLIKASI'];
        $data["MODIFIED_DATE"] = $record['MODIFIED_DATE'];
        $data["MODIFIED_BY"] = $record['MODIFIED_BY'];
        $data["MODIFIED_FROM"] = $record['MODIFIED_FROM'];
        $data["STATUS_PASIEN_ID"] = $record['STATUS_PASIEN_ID'];
        $data["AGEYEAR"] = $record['AGEYEAR'];
        $data["AGEMONTH"] = $record['AGEMONTH'];
        $data["AGEDAY"] = $record['AGEDAY'];
        $data["THEADDRESS"] = $record['THEADDRESS'];
        $data["THEID"] = $record['THEID'];
        $data["ISRJ"] = $record['ISRJ'];
        $data["GENDER"] = $record['GENDER'];
        $data["DOCTOR"] = $record['DOCTOR'];
        $data["KAL_ID"] = $record['KAL_ID'];
        $data["ACCOUNT_ID"] = $record['ACCOUNT_ID'];
        $data["DIAGNOSA_ID_02"] = $record['DIAGNOSA_ID_02'];
        $data["DIAGNOSA_ID_03"] = $record['DIAGNOSA_ID_03'];
        $data["DIAGNOSA_ID_04"] = $record['DIAGNOSA_ID_04'];
        $data["DIAGNOSA_ID_05"] = $record['DIAGNOSA_ID_05'];
        $data["DIAGNOSA_ID_06"] = $record['DIAGNOSA_ID_06'];
        $data["DIAGNOSA_ID_07"] = $record['DIAGNOSA_ID_07'];
        $data["DIAGNOSA_ID_08"] = $record['DIAGNOSA_ID_08'];
        $data["DIAGNOSA_ID_09"] = $record['DIAGNOSA_ID_09'];
        $data["DIAGNOSA_ID_10"] = $record['DIAGNOSA_ID_10'];
        $data["PROCEDURE_01"] = $record['PROCEDURE_01'];
        $data["PROCEDURE_02"] = $record['PROCEDURE_02'];
        $data["PROCEDURE_03"] = $record['PROCEDURE_03'];
        $data["PROCEDURE_04"] = $record['PROCEDURE_04'];
        $data["PROCEDURE_05"] = $record['PROCEDURE_05'];
        $data["PROCEDURE_06"] = $record['PROCEDURE_06'];
        $data["PROCEDURE_07"] = $record['PROCEDURE_07'];
        $data["PROCEDURE_08"] = $record['PROCEDURE_08'];
        $data["PROCEDURE_09"] = $record['PROCEDURE_09'];
        $data["PROCEDURE_10"] = $record['PROCEDURE_10'];
        $data["DIAGNOSA_ID2"] = $record['DIAGNOSA_ID2'];
        $data["WEIGHT"] = $record['WEIGHT'];
        $data["NOKARTU"] = $record['NOKARTU'];
        $data["NOSEP"] = $record['NOSEP'];
        $data["TGLSEP"] = $record['TGLSEP'];
        $data["RENCANATL"] = $record['RENCANATL'];
        $data["DIRUJUKKE"] = $record['DIRUJUKKE'];
        $data["TGLKONTROL"] = $record['TGLKONTROL'];
        $data["KDPOLI_KONTROL"] = $record['KDPOLI_KONTROL'];
        $data["JAMINAN"] = $record['JAMINAN'];
        $data["SPESIALISTIK"] = $record['SPESIALISTIK'];
        $data["PEMERIKSAAN_02"] = $record['PEMERIKSAAN_02'];
        $data["DIAGNOSA_DESC_02"] = $record['DIAGNOSA_DESC_02'];
        $data["DIAGNOSA_DESC_03"] = $record['DIAGNOSA_DESC_03'];
        $data["DIAGNOSA_DESC_04"] = $record['DIAGNOSA_DESC_04'];
        $data["DIAGNOSA_DESC_05"] = $record['DIAGNOSA_DESC_05'];
        $data["DIAGNOSA_DESC_06"] = $record['DIAGNOSA_DESC_06'];
        $data["PROCEDURE_DESC_01"] = $record['PROCEDURE_DESC_01'];
        $data["PROCEDURE_DESC_02"] = $record['PROCEDURE_DESC_02'];
        $data["PROCEDURE_DESC_03"] = $record['PROCEDURE_DESC_03'];
        $data["PROCEDURE_DESC_04"] = $record['PROCEDURE_DESC_04'];
        $data["PROCEDURE_DESC_05"] = $record['PROCEDURE_DESC_05'];
        $data["height"] = $record['height'];
        $data["TEMPERATURE"] = $record['TEMPERATURE'];
        $data["TENSION_UPPER"] = $record['TENSION_UPPER'];
        $data["TENSION_BELOW"] = $record['TENSION_BELOW'];
        $data["NADI"] = $record['NADI'];
        $data["NAFAS"] = $record['NAFAS'];
        $data["spec_procedures"] = $record['spec_procedures'];
        $data["spec_drug"] = $record['spec_drug'];
        $data["spec_prothesis"] = $record['spec_prothesis'];
        $data["spec_investigation"] = $record['spec_investigation'];
        $data["procedure_11"] = $record['procedure_11'];
        $data["procedure_12"] = $record['procedure_12'];
        $data["procedure_13"] = $record['procedure_13'];
        $data["procedure_14"] = $record['procedure_14'];
        $data["procedure_15"] = $record['procedure_15'];
        $data["isanestesi"] = $record['isanestesi'];
        $data["isreposisi"] = $record['isreposisi'];
        $data["islab"] = $record['islab'];
        $data["isro"] = $record['isro'];
        $data["isekg"] = $record['isekg'];
        $data["ishecting"] = $record['ishecting'];
        $data["isgips"] = $record['isgips'];
        $data["islengkap"] = $record['islengkap'];
        $data["ID"] = $record['ID'];
        $this->Rows[] = $data;
        $this->ORG_UNIT_CODE->setDbValue($record['ORG_UNIT_CODE']);
        $this->PASIEN_DIAGNOSA_ID->setDbValue($record['PASIEN_DIAGNOSA_ID']);
        $this->NO_REGISTRATION->setDbValue($record['NO_REGISTRATION']);
        $this->THENAME->setDbValue($record['THENAME']);
        $this->VISIT_ID->setDbValue($record['VISIT_ID']);
        $this->CLINIC_ID->setDbValue($record['CLINIC_ID']);
        $this->BILL_ID->setDbValue($record['BILL_ID']);
        $this->CLASS_ROOM_ID->setDbValue($record['CLASS_ROOM_ID']);
        $this->IN_DATE->setDbValue($record['IN_DATE']);
        $this->EXIT_DATE->setDbValue($record['EXIT_DATE']);
        $this->BED_ID->setDbValue($record['BED_ID']);
        $this->KELUAR_ID->setDbValue($record['KELUAR_ID']);
        $this->DATE_OF_DIAGNOSA->setDbValue($record['DATE_OF_DIAGNOSA']);
        $this->REPORT_DATE->setDbValue($record['REPORT_DATE']);
        $this->DIAGNOSA_ID->setDbValue($record['DIAGNOSA_ID']);
        $this->DIAGNOSA_DESC->setDbValue($record['DIAGNOSA_DESC']);
        $this->ANAMNASE->setDbValue($record['ANAMNASE']);
        $this->PEMERIKSAAN->setDbValue($record['PEMERIKSAAN']);
        $this->TERAPHY_DESC->setDbValue($record['TERAPHY_DESC']);
        $this->INSTRUCTION->setDbValue($record['INSTRUCTION']);
        $this->SUFFER_TYPE->setDbValue($record['SUFFER_TYPE']);
        $this->INFECTED_BODY->setDbValue($record['INFECTED_BODY']);
        $this->EMPLOYEE_ID->setDbValue($record['EMPLOYEE_ID']);
        $this->RISK_LEVEL->setDbValue($record['RISK_LEVEL']);
        $this->MORFOLOGI_NEOPLASMA->setDbValue($record['MORFOLOGI_NEOPLASMA']);
        $this->HURT->setDbValue($record['HURT']);
        $this->HURT_TYPE->setDbValue($record['HURT_TYPE']);
        $this->DIAG_CAT->setDbValue($record['DIAG_CAT']);
        $this->ADDICTION_MATERIAL->setDbValue($record['ADDICTION_MATERIAL']);
        $this->INFECTED_QUANTITY->setDbValue($record['INFECTED_QUANTITY']);
        $this->CONTAGIOUS_TYPE->setDbValue($record['CONTAGIOUS_TYPE']);
        $this->CURATIF_ID->setDbValue($record['CURATIF_ID']);
        $this->RESULT_ID->setDbValue($record['RESULT_ID']);
        $this->INFECTION_TYPE->setDbValue($record['INFECTION_TYPE']);
        $this->INVESTIGATION_ID->setDbValue($record['INVESTIGATION_ID']);
        $this->DISABILITY->setDbValue($record['DISABILITY']);
        $this->DESCRIPTION->setDbValue($record['DESCRIPTION']);
        $this->KOMPLIKASI->setDbValue($record['KOMPLIKASI']);
        $this->MODIFIED_DATE->setDbValue($record['MODIFIED_DATE']);
        $this->MODIFIED_BY->setDbValue($record['MODIFIED_BY']);
        $this->MODIFIED_FROM->setDbValue($record['MODIFIED_FROM']);
        $this->STATUS_PASIEN_ID->setDbValue($record['STATUS_PASIEN_ID']);
        $this->AGEYEAR->setDbValue($record['AGEYEAR']);
        $this->AGEMONTH->setDbValue($record['AGEMONTH']);
        $this->AGEDAY->setDbValue($record['AGEDAY']);
        $this->THEADDRESS->setDbValue($record['THEADDRESS']);
        $this->THEID->setDbValue($record['THEID']);
        $this->ISRJ->setDbValue($record['ISRJ']);
        $this->GENDER->setDbValue($record['GENDER']);
        $this->DOCTOR->setDbValue($record['DOCTOR']);
        $this->KAL_ID->setDbValue($record['KAL_ID']);
        $this->ACCOUNT_ID->setDbValue($record['ACCOUNT_ID']);
        $this->DIAGNOSA_ID_02->setDbValue($record['DIAGNOSA_ID_02']);
        $this->DIAGNOSA_ID_03->setDbValue($record['DIAGNOSA_ID_03']);
        $this->DIAGNOSA_ID_04->setDbValue($record['DIAGNOSA_ID_04']);
        $this->DIAGNOSA_ID_05->setDbValue($record['DIAGNOSA_ID_05']);
        $this->DIAGNOSA_ID_06->setDbValue($record['DIAGNOSA_ID_06']);
        $this->DIAGNOSA_ID_07->setDbValue($record['DIAGNOSA_ID_07']);
        $this->DIAGNOSA_ID_08->setDbValue($record['DIAGNOSA_ID_08']);
        $this->DIAGNOSA_ID_09->setDbValue($record['DIAGNOSA_ID_09']);
        $this->DIAGNOSA_ID_10->setDbValue($record['DIAGNOSA_ID_10']);
        $this->PROCEDURE_01->setDbValue($record['PROCEDURE_01']);
        $this->PROCEDURE_02->setDbValue($record['PROCEDURE_02']);
        $this->PROCEDURE_03->setDbValue($record['PROCEDURE_03']);
        $this->PROCEDURE_04->setDbValue($record['PROCEDURE_04']);
        $this->PROCEDURE_05->setDbValue($record['PROCEDURE_05']);
        $this->PROCEDURE_06->setDbValue($record['PROCEDURE_06']);
        $this->PROCEDURE_07->setDbValue($record['PROCEDURE_07']);
        $this->PROCEDURE_08->setDbValue($record['PROCEDURE_08']);
        $this->PROCEDURE_09->setDbValue($record['PROCEDURE_09']);
        $this->PROCEDURE_10->setDbValue($record['PROCEDURE_10']);
        $this->DIAGNOSA_ID2->setDbValue($record['DIAGNOSA_ID2']);
        $this->WEIGHT->setDbValue($record['WEIGHT']);
        $this->NOKARTU->setDbValue($record['NOKARTU']);
        $this->NOSEP->setDbValue($record['NOSEP']);
        $this->TGLSEP->setDbValue($record['TGLSEP']);
        $this->RENCANATL->setDbValue($record['RENCANATL']);
        $this->DIRUJUKKE->setDbValue($record['DIRUJUKKE']);
        $this->TGLKONTROL->setDbValue($record['TGLKONTROL']);
        $this->KDPOLI_KONTROL->setDbValue($record['KDPOLI_KONTROL']);
        $this->JAMINAN->setDbValue($record['JAMINAN']);
        $this->SPESIALISTIK->setDbValue($record['SPESIALISTIK']);
        $this->PEMERIKSAAN_02->setDbValue($record['PEMERIKSAAN_02']);
        $this->DIAGNOSA_DESC_02->setDbValue($record['DIAGNOSA_DESC_02']);
        $this->DIAGNOSA_DESC_03->setDbValue($record['DIAGNOSA_DESC_03']);
        $this->DIAGNOSA_DESC_04->setDbValue($record['DIAGNOSA_DESC_04']);
        $this->DIAGNOSA_DESC_05->setDbValue($record['DIAGNOSA_DESC_05']);
        $this->DIAGNOSA_DESC_06->setDbValue($record['DIAGNOSA_DESC_06']);
        $this->PROCEDURE_DESC_01->setDbValue($record['PROCEDURE_DESC_01']);
        $this->PROCEDURE_DESC_02->setDbValue($record['PROCEDURE_DESC_02']);
        $this->PROCEDURE_DESC_03->setDbValue($record['PROCEDURE_DESC_03']);
        $this->PROCEDURE_DESC_04->setDbValue($record['PROCEDURE_DESC_04']);
        $this->PROCEDURE_DESC_05->setDbValue($record['PROCEDURE_DESC_05']);
        $this->RESPONPOST->setDbValue($record['RESPONPOST']);
        $this->RESPONPUT->setDbValue($record['RESPONPUT']);
        $this->RESPONDEL->setDbValue($record['RESPONDEL']);
        $this->JSONPOST->setDbValue($record['JSONPOST']);
        $this->JSONPUT->setDbValue($record['JSONPUT']);
        $this->JSONDEL->setDbValue($record['JSONDEL']);
        $this->height->setDbValue($record['height']);
        $this->TEMPERATURE->setDbValue($record['TEMPERATURE']);
        $this->TENSION_UPPER->setDbValue($record['TENSION_UPPER']);
        $this->TENSION_BELOW->setDbValue($record['TENSION_BELOW']);
        $this->NADI->setDbValue($record['NADI']);
        $this->NAFAS->setDbValue($record['NAFAS']);
        $this->spec_procedures->setDbValue($record['spec_procedures']);
        $this->spec_drug->setDbValue($record['spec_drug']);
        $this->spec_prothesis->setDbValue($record['spec_prothesis']);
        $this->spec_investigation->setDbValue($record['spec_investigation']);
        $this->procedure_11->setDbValue($record['procedure_11']);
        $this->procedure_12->setDbValue($record['procedure_12']);
        $this->procedure_13->setDbValue($record['procedure_13']);
        $this->procedure_14->setDbValue($record['procedure_14']);
        $this->procedure_15->setDbValue($record['procedure_15']);
        $this->isanestesi->setDbValue($record['isanestesi']);
        $this->isreposisi->setDbValue($record['isreposisi']);
        $this->islab->setDbValue($record['islab']);
        $this->isro->setDbValue($record['isro']);
        $this->isekg->setDbValue($record['isekg']);
        $this->ishecting->setDbValue($record['ishecting']);
        $this->isgips->setDbValue($record['isgips']);
        $this->islengkap->setDbValue($record['islengkap']);
        $this->ID->setDbValue($record['ID']);
    }

    // Render row
    public function renderRow()
    {
        global $Security, $Language, $Language;
        $conn = $this->getConnection();
        if ($this->RowType == ROWTYPE_TOTAL && $this->RowTotalSubType == ROWTOTAL_FOOTER && $this->RowTotalType == ROWTOTAL_PAGE) { // Get Page total
            $records = &$this->DetailRecords;
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
            $hasSummary = true;

            // Accumulate grand summary from detail records
            if (!$hasCount || !$hasSummary) {
                $sql = $this->buildReportSql($this->getSqlSelect(), $this->getSqlFrom(), $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), "", $this->Filter, "");
                $rs = $sql->execute();
                $this->DetailRecords = $rs ? $rs->fetchAll() : [];
            }
        }

        // Call Row_Rendering event
        $this->rowRendering();

        // NO_REGISTRATION
        $this->NO_REGISTRATION->CellCssStyle = "white-space: nowrap;";

        // THENAME
        $this->THENAME->CellCssStyle = "white-space: nowrap;";

        // KELUAR_ID
        $this->KELUAR_ID->CellCssStyle = "white-space: nowrap;";

        // DATE_OF_DIAGNOSA
        $this->DATE_OF_DIAGNOSA->CellCssStyle = "white-space: nowrap;";

        // DIAGNOSA_ID
        $this->DIAGNOSA_ID->CellCssStyle = "white-space: nowrap;";

        // SUFFER_TYPE
        $this->SUFFER_TYPE->CellCssStyle = "white-space: nowrap;";

        // AGEYEAR
        $this->AGEYEAR->CellCssStyle = "white-space: nowrap;";

        // THEADDRESS
        $this->THEADDRESS->CellCssStyle = "white-space: nowrap;";

        // GENDER
        $this->GENDER->CellCssStyle = "white-space: nowrap;";

        // ID
        if ($this->RowType == ROWTYPE_SEARCH) { // Search row
        } elseif ($this->RowType == ROWTYPE_TOTAL && !($this->RowTotalType == ROWTOTAL_GROUP && $this->RowTotalSubType == ROWTOTAL_HEADER)) { // Summary row
            $this->RowAttrs->prependClass(($this->RowTotalType == ROWTOTAL_PAGE || $this->RowTotalType == ROWTOTAL_GRAND) ? "ew-rpt-grp-aggregate" : ""); // Set up row class

            // NO_REGISTRATION
            $this->NO_REGISTRATION->HrefValue = "";

            // THENAME
            $this->THENAME->HrefValue = "";

            // KELUAR_ID
            $this->KELUAR_ID->HrefValue = "";

            // DATE_OF_DIAGNOSA
            $this->DATE_OF_DIAGNOSA->HrefValue = "";

            // DIAGNOSA_ID
            $this->DIAGNOSA_ID->HrefValue = "";

            // SUFFER_TYPE
            $this->SUFFER_TYPE->HrefValue = "";

            // AGEYEAR
            $this->AGEYEAR->HrefValue = "";

            // THEADDRESS
            $this->THEADDRESS->HrefValue = "";

            // GENDER
            $this->GENDER->HrefValue = "";

            // ID
            $this->ID->HrefValue = "";
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

            // THENAME
            $this->THENAME->ViewValue = $this->THENAME->CurrentValue;
            $this->THENAME->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->THENAME->ViewCustomAttributes = "";

            // KELUAR_ID
            $this->KELUAR_ID->ViewValue = $this->KELUAR_ID->CurrentValue;
            $curVal = $this->KELUAR_ID->CurrentValue == INIT_VALUE ? "" : trim(strval($this->KELUAR_ID->CurrentValue));
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
            $this->KELUAR_ID->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->KELUAR_ID->ViewCustomAttributes = "";

            // DATE_OF_DIAGNOSA
            $this->DATE_OF_DIAGNOSA->ViewValue = $this->DATE_OF_DIAGNOSA->CurrentValue;
            $this->DATE_OF_DIAGNOSA->ViewValue = FormatDateTime($this->DATE_OF_DIAGNOSA->ViewValue, 0);
            $this->DATE_OF_DIAGNOSA->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->DATE_OF_DIAGNOSA->ViewCustomAttributes = "";

            // DIAGNOSA_ID
            $this->DIAGNOSA_ID->ViewValue = $this->DIAGNOSA_ID->CurrentValue;
            $curVal = $this->DIAGNOSA_ID->CurrentValue == INIT_VALUE ? "" : trim(strval($this->DIAGNOSA_ID->CurrentValue));
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
            $this->DIAGNOSA_ID->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->DIAGNOSA_ID->ViewCustomAttributes = "";

            // SUFFER_TYPE
            $this->SUFFER_TYPE->ViewValue = $this->SUFFER_TYPE->CurrentValue;
            $curVal = $this->SUFFER_TYPE->CurrentValue == INIT_VALUE ? "" : trim(strval($this->SUFFER_TYPE->CurrentValue));
            if ($curVal != "") {
                $this->SUFFER_TYPE->ViewValue = $this->SUFFER_TYPE->lookupCacheOption($curVal);
                if ($this->SUFFER_TYPE->ViewValue === null) { // Lookup from database
                    $filterWrk = "[SUFFER_TYPE]" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->SUFFER_TYPE->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->SUFFER_TYPE->Lookup->renderViewRow($rswrk[0]);
                        $this->SUFFER_TYPE->ViewValue = $this->SUFFER_TYPE->displayValue($arwrk);
                    } else {
                        $this->SUFFER_TYPE->ViewValue = $this->SUFFER_TYPE->CurrentValue;
                    }
                }
            } else {
                $this->SUFFER_TYPE->ViewValue = null;
            }
            $this->SUFFER_TYPE->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->SUFFER_TYPE->ViewCustomAttributes = "";

            // AGEYEAR
            $this->AGEYEAR->ViewValue = $this->AGEYEAR->CurrentValue;
            $this->AGEYEAR->ViewValue = FormatNumber($this->AGEYEAR->ViewValue, 0, -2, -2, -2);
            $this->AGEYEAR->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->AGEYEAR->ViewCustomAttributes = "";

            // THEADDRESS
            $this->THEADDRESS->ViewValue = $this->THEADDRESS->CurrentValue;
            $this->THEADDRESS->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->THEADDRESS->ViewCustomAttributes = "";

            // GENDER
            $this->GENDER->ViewValue = $this->GENDER->CurrentValue;
            $this->GENDER->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->GENDER->ViewCustomAttributes = "";

            // ID
            $this->ID->ViewValue = $this->ID->CurrentValue;
            $this->ID->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
            $this->ID->ViewCustomAttributes = "";

            // NO_REGISTRATION
            $this->NO_REGISTRATION->LinkCustomAttributes = "";
            $this->NO_REGISTRATION->HrefValue = "";
            $this->NO_REGISTRATION->TooltipValue = "";

            // THENAME
            $this->THENAME->LinkCustomAttributes = "";
            $this->THENAME->HrefValue = "";
            $this->THENAME->TooltipValue = "";

            // KELUAR_ID
            $this->KELUAR_ID->LinkCustomAttributes = "";
            $this->KELUAR_ID->HrefValue = "";
            $this->KELUAR_ID->TooltipValue = "";

            // DATE_OF_DIAGNOSA
            $this->DATE_OF_DIAGNOSA->LinkCustomAttributes = "";
            $this->DATE_OF_DIAGNOSA->HrefValue = "";
            $this->DATE_OF_DIAGNOSA->TooltipValue = "";

            // DIAGNOSA_ID
            $this->DIAGNOSA_ID->LinkCustomAttributes = "";
            $this->DIAGNOSA_ID->HrefValue = "";
            $this->DIAGNOSA_ID->TooltipValue = "";

            // SUFFER_TYPE
            $this->SUFFER_TYPE->LinkCustomAttributes = "";
            $this->SUFFER_TYPE->HrefValue = "";
            $this->SUFFER_TYPE->TooltipValue = "";

            // AGEYEAR
            $this->AGEYEAR->LinkCustomAttributes = "";
            $this->AGEYEAR->HrefValue = "";
            $this->AGEYEAR->TooltipValue = "";

            // THEADDRESS
            $this->THEADDRESS->LinkCustomAttributes = "";
            $this->THEADDRESS->HrefValue = "";
            $this->THEADDRESS->TooltipValue = "";

            // GENDER
            $this->GENDER->LinkCustomAttributes = "";
            $this->GENDER->HrefValue = "";
            $this->GENDER->TooltipValue = "";

            // ID
            $this->ID->LinkCustomAttributes = "";
            $this->ID->HrefValue = "";
            $this->ID->TooltipValue = "";
        }

        // Call Cell_Rendered event
        if ($this->RowType == ROWTYPE_TOTAL) { // Summary row
        } else {
            // NO_REGISTRATION
            $currentValue = $this->NO_REGISTRATION->CurrentValue;
            $viewValue = &$this->NO_REGISTRATION->ViewValue;
            $viewAttrs = &$this->NO_REGISTRATION->ViewAttrs;
            $cellAttrs = &$this->NO_REGISTRATION->CellAttrs;
            $hrefValue = &$this->NO_REGISTRATION->HrefValue;
            $linkAttrs = &$this->NO_REGISTRATION->LinkAttrs;
            $this->cellRendered($this->NO_REGISTRATION, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // THENAME
            $currentValue = $this->THENAME->CurrentValue;
            $viewValue = &$this->THENAME->ViewValue;
            $viewAttrs = &$this->THENAME->ViewAttrs;
            $cellAttrs = &$this->THENAME->CellAttrs;
            $hrefValue = &$this->THENAME->HrefValue;
            $linkAttrs = &$this->THENAME->LinkAttrs;
            $this->cellRendered($this->THENAME, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // KELUAR_ID
            $currentValue = $this->KELUAR_ID->CurrentValue;
            $viewValue = &$this->KELUAR_ID->ViewValue;
            $viewAttrs = &$this->KELUAR_ID->ViewAttrs;
            $cellAttrs = &$this->KELUAR_ID->CellAttrs;
            $hrefValue = &$this->KELUAR_ID->HrefValue;
            $linkAttrs = &$this->KELUAR_ID->LinkAttrs;
            $this->cellRendered($this->KELUAR_ID, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // DATE_OF_DIAGNOSA
            $currentValue = $this->DATE_OF_DIAGNOSA->CurrentValue;
            $viewValue = &$this->DATE_OF_DIAGNOSA->ViewValue;
            $viewAttrs = &$this->DATE_OF_DIAGNOSA->ViewAttrs;
            $cellAttrs = &$this->DATE_OF_DIAGNOSA->CellAttrs;
            $hrefValue = &$this->DATE_OF_DIAGNOSA->HrefValue;
            $linkAttrs = &$this->DATE_OF_DIAGNOSA->LinkAttrs;
            $this->cellRendered($this->DATE_OF_DIAGNOSA, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // DIAGNOSA_ID
            $currentValue = $this->DIAGNOSA_ID->CurrentValue;
            $viewValue = &$this->DIAGNOSA_ID->ViewValue;
            $viewAttrs = &$this->DIAGNOSA_ID->ViewAttrs;
            $cellAttrs = &$this->DIAGNOSA_ID->CellAttrs;
            $hrefValue = &$this->DIAGNOSA_ID->HrefValue;
            $linkAttrs = &$this->DIAGNOSA_ID->LinkAttrs;
            $this->cellRendered($this->DIAGNOSA_ID, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // SUFFER_TYPE
            $currentValue = $this->SUFFER_TYPE->CurrentValue;
            $viewValue = &$this->SUFFER_TYPE->ViewValue;
            $viewAttrs = &$this->SUFFER_TYPE->ViewAttrs;
            $cellAttrs = &$this->SUFFER_TYPE->CellAttrs;
            $hrefValue = &$this->SUFFER_TYPE->HrefValue;
            $linkAttrs = &$this->SUFFER_TYPE->LinkAttrs;
            $this->cellRendered($this->SUFFER_TYPE, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // AGEYEAR
            $currentValue = $this->AGEYEAR->CurrentValue;
            $viewValue = &$this->AGEYEAR->ViewValue;
            $viewAttrs = &$this->AGEYEAR->ViewAttrs;
            $cellAttrs = &$this->AGEYEAR->CellAttrs;
            $hrefValue = &$this->AGEYEAR->HrefValue;
            $linkAttrs = &$this->AGEYEAR->LinkAttrs;
            $this->cellRendered($this->AGEYEAR, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // THEADDRESS
            $currentValue = $this->THEADDRESS->CurrentValue;
            $viewValue = &$this->THEADDRESS->ViewValue;
            $viewAttrs = &$this->THEADDRESS->ViewAttrs;
            $cellAttrs = &$this->THEADDRESS->CellAttrs;
            $hrefValue = &$this->THEADDRESS->HrefValue;
            $linkAttrs = &$this->THEADDRESS->LinkAttrs;
            $this->cellRendered($this->THEADDRESS, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // GENDER
            $currentValue = $this->GENDER->CurrentValue;
            $viewValue = &$this->GENDER->ViewValue;
            $viewAttrs = &$this->GENDER->ViewAttrs;
            $cellAttrs = &$this->GENDER->CellAttrs;
            $hrefValue = &$this->GENDER->HrefValue;
            $linkAttrs = &$this->GENDER->LinkAttrs;
            $this->cellRendered($this->GENDER, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // ID
            $currentValue = $this->ID->CurrentValue;
            $viewValue = &$this->ID->ViewValue;
            $viewAttrs = &$this->ID->ViewAttrs;
            $cellAttrs = &$this->ID->CellAttrs;
            $hrefValue = &$this->ID->HrefValue;
            $linkAttrs = &$this->ID->LinkAttrs;
            $this->cellRendered($this->ID, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);
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
        if ($this->THENAME->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->KELUAR_ID->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->DATE_OF_DIAGNOSA->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->DIAGNOSA_ID->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->SUFFER_TYPE->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->AGEYEAR->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->THEADDRESS->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->GENDER->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->ID->Visible) {
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
            return '<a class="ew-export-link ew-email" title="' . HtmlEncode($Language->phrase("ExportToEmail", true)) . '" data-caption="' . HtmlEncode($Language->phrase("ExportToEmail", true)) . '" id="emf_penyakit_menular" href="#" onclick="return ew.emailDialogShow({ lnk: \'emf_penyakit_menular\', hdr: ew.language.phrase(\'ExportToEmailText\'), url: \'' . $url . '\', exportid: \'' . session_id() . '\', el: this });">' . $Language->phrase("ExportToEmail") . '</a>';
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
                case "x_CLINIC_ID":
                    break;
                case "x_KELUAR_ID":
                    break;
                case "x_DIAGNOSA_ID":
                    break;
                case "x_SUFFER_TYPE":
                    break;
                case "x_EMPLOYEE_ID":
                    $lookupFilter = function () {
                        return "[OBJECT_CATEGORY_ID]= 20";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    break;
                case "x_DIAG_CAT":
                    break;
                case "x_INVESTIGATION_ID":
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
        $item->Visible = false;
        $item = &$this->FilterOptions->add("deletefilter");
        $item->Body = "<a class=\"ew-delete-filter\" data-form=\"fsummary\" href=\"#\" onclick=\"return false;\">" . $Language->phrase("DeleteFilter") . "</a>";
        $item->Visible = false;
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
            return "";
        }
        $resetSort = Param("cmd") === "resetsort";
        $orderBy = Param("order", "");
        $orderType = Param("ordertype", "");

        // Check for a resetsort command
        if ($resetSort) {
            $this->setOrderBy("");
            $this->setStartGroup(1);
            $this->NO_REGISTRATION->setSort("");
            $this->THENAME->setSort("");
            $this->KELUAR_ID->setSort("");
            $this->DATE_OF_DIAGNOSA->setSort("");
            $this->DIAGNOSA_ID->setSort("");
            $this->SUFFER_TYPE->setSort("");
            $this->AGEYEAR->setSort("");
            $this->THEADDRESS->setSort("");
            $this->GENDER->setSort("");
            $this->ID->setSort("");

        // Check for an Order parameter
        } elseif ($orderBy != "") {
            $this->CurrentOrder = $orderBy;
            $this->CurrentOrderType = $orderType;
            $this->updateSort($this->NO_REGISTRATION); // NO_REGISTRATION
            $this->updateSort($this->THENAME); // THENAME
            $this->updateSort($this->KELUAR_ID); // KELUAR_ID
            $this->updateSort($this->DATE_OF_DIAGNOSA); // DATE_OF_DIAGNOSA
            $this->updateSort($this->DIAGNOSA_ID); // DIAGNOSA_ID
            $this->updateSort($this->SUFFER_TYPE); // SUFFER_TYPE
            $this->updateSort($this->AGEYEAR); // AGEYEAR
            $this->updateSort($this->THEADDRESS); // THEADDRESS
            $this->updateSort($this->GENDER); // GENDER
            $this->updateSort($this->ID); // ID
            $sortSql = $this->sortSql();
            $this->setOrderBy($sortSql);
            $this->setStartGroup(1);
        }
        return $this->getOrderBy();
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
