<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class TreatmentBilltrans1List extends TreatmentBilltrans1
{
    use MessagesTrait;

    // Page ID
    public $PageID = "list";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'TREATMENT_BILLTRANS1';

    // Page object name
    public $PageObjName = "TreatmentBilltrans1List";

    // Rendering View
    public $RenderingView = false;

    // Grid form hidden field names
    public $FormName = "fTREATMENT_BILLTRANS1list";
    public $FormActionName = "k_action";
    public $FormBlankRowName = "k_blankrow";
    public $FormKeyCountName = "key_count";

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

        // Table object (TREATMENT_BILLTRANS1)
        if (!isset($GLOBALS["TREATMENT_BILLTRANS1"]) || get_class($GLOBALS["TREATMENT_BILLTRANS1"]) == PROJECT_NAMESPACE . "TREATMENT_BILLTRANS1") {
            $GLOBALS["TREATMENT_BILLTRANS1"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Initialize URLs
        $this->ExportPrintUrl = $pageUrl . "export=print";
        $this->ExportExcelUrl = $pageUrl . "export=excel";
        $this->ExportWordUrl = $pageUrl . "export=word";
        $this->ExportPdfUrl = $pageUrl . "export=pdf";
        $this->ExportHtmlUrl = $pageUrl . "export=html";
        $this->ExportXmlUrl = $pageUrl . "export=xml";
        $this->ExportCsvUrl = $pageUrl . "export=csv";
        $this->AddUrl = "TreatmentBilltrans1Add";
        $this->InlineAddUrl = $pageUrl . "action=add";
        $this->GridAddUrl = $pageUrl . "action=gridadd";
        $this->GridEditUrl = $pageUrl . "action=gridedit";
        $this->MultiDeleteUrl = "TreatmentBilltrans1Delete";
        $this->MultiUpdateUrl = "TreatmentBilltrans1Update";

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'TREATMENT_BILLTRANS1');
        }

        // Start timer
        $DebugTimer = Container("timer");

        // Debug message
        LoadDebugMessage();

        // Open connection
        $GLOBALS["Conn"] = $GLOBALS["Conn"] ?? $this->getConnection();

        // List options
        $this->ListOptions = new ListOptions();
        $this->ListOptions->TableVar = $this->TableVar;

        // Export options
        $this->ExportOptions = new ListOptions("div");
        $this->ExportOptions->TagClassName = "ew-export-option";

        // Import options
        $this->ImportOptions = new ListOptions("div");
        $this->ImportOptions->TagClassName = "ew-import-option";

        // Other options
        if (!$this->OtherOptions) {
            $this->OtherOptions = new ListOptionsArray();
        }
        $this->OtherOptions["addedit"] = new ListOptions("div");
        $this->OtherOptions["addedit"]->TagClassName = "ew-add-edit-option";
        $this->OtherOptions["detail"] = new ListOptions("div");
        $this->OtherOptions["detail"]->TagClassName = "ew-detail-option";
        $this->OtherOptions["action"] = new ListOptions("div");
        $this->OtherOptions["action"]->TagClassName = "ew-action-option";

        // Filter options
        $this->FilterOptions = new ListOptions("div");
        $this->FilterOptions->TagClassName = "ew-filter-option fTREATMENT_BILLTRANS1listsrch";

        // List actions
        $this->ListActions = new ListActions();
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
                $doc = new $class(Container("TREATMENT_BILLTRANS1"));
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
            SaveDebugMessage();
            Redirect(GetUrl($url));
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
                        if ($fld->DataType == DATATYPE_MEMO && $fld->MemoMaxLength > 0) {
                            $val = TruncateMemo($val, $fld->MemoMaxLength, $fld->TruncateMemoRemoveHtml);
                        }
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
            $key .= @$ar['BILL_ID'];
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

    // Class variables
    public $ListOptions; // List options
    public $ExportOptions; // Export options
    public $SearchOptions; // Search options
    public $OtherOptions; // Other options
    public $FilterOptions; // Filter options
    public $ImportOptions; // Import options
    public $ListActions; // List actions
    public $SelectedCount = 0;
    public $SelectedIndex = 0;
    public $DisplayRecords = 10;
    public $StartRecord;
    public $StopRecord;
    public $TotalRecords = 0;
    public $RecordRange = 10;
    public $PageSizes = "10,20,50,-1"; // Page sizes (comma separated)
    public $DefaultSearchWhere = ""; // Default search WHERE clause
    public $SearchWhere = ""; // Search WHERE clause
    public $SearchPanelClass = "ew-search-panel collapse show"; // Search Panel class
    public $SearchRowCount = 0; // For extended search
    public $SearchColumnCount = 0; // For extended search
    public $SearchFieldsPerRow = 1; // For extended search
    public $RecordCount = 0; // Record count
    public $EditRowCount;
    public $StartRowCount = 1;
    public $RowCount = 0;
    public $Attrs = []; // Row attributes and cell attributes
    public $RowIndex = 0; // Row index
    public $KeyCount = 0; // Key count
    public $RowAction = ""; // Row action
    public $MultiColumnClass = "col-sm";
    public $MultiColumnEditClass = "w-100";
    public $DbMasterFilter = ""; // Master filter
    public $DbDetailFilter = ""; // Detail filter
    public $MasterRecordExists;
    public $MultiSelectKey;
    public $Command;
    public $RestoreSearch = false;
    public $HashValue; // Hash value
    public $DetailPages;
    public $OldRecordset;

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $CustomExportType, $ExportFileName, $UserProfile, $Language, $Security, $CurrentForm;
        $this->CurrentAction = Param("action"); // Set up current action

        // Get grid add count
        $gridaddcnt = Get(Config("TABLE_GRID_ADD_ROW_COUNT"), "");
        if (is_numeric($gridaddcnt) && $gridaddcnt > 0) {
            $this->GridAddRowCount = $gridaddcnt;
        }

        // Set up list options
        $this->setupListOptions();
        $this->ORG_UNIT_CODE->setVisibility();
        $this->BILL_ID->setVisibility();
        $this->NO_REGISTRATION->setVisibility();
        $this->VISIT_ID->setVisibility();
        $this->TARIF_ID->setVisibility();
        $this->CLASS_ID->setVisibility();
        $this->CLINIC_ID->setVisibility();
        $this->CLINIC_ID_FROM->setVisibility();
        $this->TREATMENT->setVisibility();
        $this->TREAT_DATE->setVisibility();
        $this->AMOUNT->setVisibility();
        $this->QUANTITY->setVisibility();
        $this->MEASURE_ID->setVisibility();
        $this->POKOK_JUAL->setVisibility();
        $this->PPN->setVisibility();
        $this->MARGIN->setVisibility();
        $this->SUBSIDI->setVisibility();
        $this->EMBALACE->setVisibility();
        $this->PROFESI->setVisibility();
        $this->DISCOUNT->setVisibility();
        $this->PAY_METHOD_ID->setVisibility();
        $this->PAYMENT_DATE->setVisibility();
        $this->ISLUNAS->setVisibility();
        $this->DUEDATE_ANGSURAN->setVisibility();
        $this->DESCRIPTION->setVisibility();
        $this->KUITANSI_ID->setVisibility();
        $this->NOTA_NO->setVisibility();
        $this->ISCETAK->setVisibility();
        $this->PRINT_DATE->setVisibility();
        $this->RESEP_NO->setVisibility();
        $this->RESEP_KE->setVisibility();
        $this->DOSE->setVisibility();
        $this->ORIG_DOSE->setVisibility();
        $this->DOSE_PRESC->setVisibility();
        $this->ITER->setVisibility();
        $this->ITER_KE->setVisibility();
        $this->SOLD_STATUS->setVisibility();
        $this->RACIKAN->setVisibility();
        $this->CLASS_ROOM_ID->setVisibility();
        $this->KELUAR_ID->setVisibility();
        $this->BED_ID->setVisibility();
        $this->PERDA_ID->setVisibility();
        $this->EMPLOYEE_ID->setVisibility();
        $this->DESCRIPTION2->setVisibility();
        $this->MODIFIED_BY->setVisibility();
        $this->MODIFIED_DATE->setVisibility();
        $this->MODIFIED_FROM->setVisibility();
        $this->BRAND_ID->setVisibility();
        $this->DOCTOR->setVisibility();
        $this->JML_BKS->setVisibility();
        $this->EXIT_DATE->setVisibility();
        $this->FA_V->setVisibility();
        $this->TASK_ID->setVisibility();
        $this->EMPLOYEE_ID_FROM->setVisibility();
        $this->DOCTOR_FROM->setVisibility();
        $this->status_pasien_id->setVisibility();
        $this->AMOUNT_PAID->setVisibility();
        $this->THENAME->setVisibility();
        $this->THEADDRESS->setVisibility();
        $this->THEID->setVisibility();
        $this->SERIAL_NB->setVisibility();
        $this->TREATMENT_PLAFOND->setVisibility();
        $this->AMOUNT_PLAFOND->setVisibility();
        $this->AMOUNT_PAID_PLAFOND->setVisibility();
        $this->CLASS_ID_PLAFOND->setVisibility();
        $this->PAYOR_ID->setVisibility();
        $this->PEMBULATAN->setVisibility();
        $this->ISRJ->setVisibility();
        $this->AGEYEAR->setVisibility();
        $this->AGEMONTH->setVisibility();
        $this->AGEDAY->setVisibility();
        $this->GENDER->setVisibility();
        $this->KAL_ID->setVisibility();
        $this->CORRECTION_ID->setVisibility();
        $this->CORRECTION_BY->setVisibility();
        $this->KARYAWAN->setVisibility();
        $this->ACCOUNT_ID->setVisibility();
        $this->sell_price->setVisibility();
        $this->diskon->setVisibility();
        $this->INVOICE_ID->setVisibility();
        $this->NUMER->setVisibility();
        $this->MEASURE_ID2->setVisibility();
        $this->POTONGAN->setVisibility();
        $this->BAYAR->setVisibility();
        $this->RETUR->setVisibility();
        $this->TARIF_TYPE->setVisibility();
        $this->PPNVALUE->setVisibility();
        $this->TAGIHAN->setVisibility();
        $this->KOREKSI->setVisibility();
        $this->STATUS_OBAT->setVisibility();
        $this->SUBSIDISAT->setVisibility();
        $this->PRINTQ->setVisibility();
        $this->PRINTED_BY->setVisibility();
        $this->STOCK_AVAILABLE->setVisibility();
        $this->STATUS_TARIF->setVisibility();
        $this->CLINIC_TYPE->setVisibility();
        $this->PACKAGE_ID->setVisibility();
        $this->MODULE_ID->setVisibility();
        $this->profession->setVisibility();
        $this->THEORDER->setVisibility();
        $this->CASHIER->setVisibility();
        $this->hideFieldsForAddEdit();

        // Global Page Loading event (in userfn*.php)
        Page_Loading();

        // Page Load event
        if (method_exists($this, "pageLoad")) {
            $this->pageLoad();
        }

        // Setup other options
        $this->setupOtherOptions();

        // Set up custom action (compatible with old version)
        foreach ($this->CustomActions as $name => $action) {
            $this->ListActions->add($name, $action);
        }

        // Show checkbox column if multiple action
        foreach ($this->ListActions->Items as $listaction) {
            if ($listaction->Select == ACTION_MULTIPLE && $listaction->Allow) {
                $this->ListOptions["checkbox"]->Visible = true;
                break;
            }
        }

        // Set up lookup cache

        // Search filters
        $srchAdvanced = ""; // Advanced search filter
        $srchBasic = ""; // Basic search filter
        $filter = "";

        // Get command
        $this->Command = strtolower(Get("cmd"));
        if ($this->isPageRequest()) {
            // Process list action first
            if ($this->processListAction()) { // Ajax request
                $this->terminate();
                return;
            }

            // Set up records per page
            $this->setupDisplayRecords();

            // Handle reset command
            $this->resetCmd();

            // Set up Breadcrumb
            if (!$this->isExport()) {
                $this->setupBreadcrumb();
            }

            // Hide list options
            if ($this->isExport()) {
                $this->ListOptions->hideAllOptions(["sequence"]);
                $this->ListOptions->UseDropDownButton = false; // Disable drop down button
                $this->ListOptions->UseButtonGroup = false; // Disable button group
            } elseif ($this->isGridAdd() || $this->isGridEdit()) {
                $this->ListOptions->hideAllOptions();
                $this->ListOptions->UseDropDownButton = false; // Disable drop down button
                $this->ListOptions->UseButtonGroup = false; // Disable button group
            }

            // Hide options
            if ($this->isExport() || $this->CurrentAction) {
                $this->ExportOptions->hideAllOptions();
                $this->FilterOptions->hideAllOptions();
                $this->ImportOptions->hideAllOptions();
            }

            // Hide other options
            if ($this->isExport()) {
                $this->OtherOptions->hideAllOptions();
            }

            // Get default search criteria
            AddFilter($this->DefaultSearchWhere, $this->basicSearchWhere(true));

            // Get basic search values
            $this->loadBasicSearchValues();

            // Process filter list
            if ($this->processFilterList()) {
                $this->terminate();
                return;
            }

            // Restore search parms from Session if not searching / reset / export
            if (($this->isExport() || $this->Command != "search" && $this->Command != "reset" && $this->Command != "resetall") && $this->Command != "json" && $this->checkSearchParms()) {
                $this->restoreSearchParms();
            }

            // Call Recordset SearchValidated event
            $this->recordsetSearchValidated();

            // Set up sorting order
            $this->setupSortOrder();

            // Get basic search criteria
            if (!$this->hasInvalidFields()) {
                $srchBasic = $this->basicSearchWhere();
            }
        }

        // Restore display records
        if ($this->Command != "json" && $this->getRecordsPerPage() != "") {
            $this->DisplayRecords = $this->getRecordsPerPage(); // Restore from Session
        } else {
            $this->DisplayRecords = 10; // Load default
            $this->setRecordsPerPage($this->DisplayRecords); // Save default to Session
        }

        // Load Sorting Order
        if ($this->Command != "json") {
            $this->loadSortOrder();
        }

        // Load search default if no existing search criteria
        if (!$this->checkSearchParms()) {
            // Load basic search from default
            $this->BasicSearch->loadDefault();
            if ($this->BasicSearch->Keyword != "") {
                $srchBasic = $this->basicSearchWhere();
            }
        }

        // Build search criteria
        AddFilter($this->SearchWhere, $srchAdvanced);
        AddFilter($this->SearchWhere, $srchBasic);

        // Call Recordset_Searching event
        $this->recordsetSearching($this->SearchWhere);

        // Save search criteria
        if ($this->Command == "search" && !$this->RestoreSearch) {
            $this->setSearchWhere($this->SearchWhere); // Save to Session
            $this->StartRecord = 1; // Reset start record counter
            $this->setStartRecordNumber($this->StartRecord);
        } elseif ($this->Command != "json") {
            $this->SearchWhere = $this->getSearchWhere();
        }

        // Build filter
        $filter = "";
        AddFilter($filter, $this->DbDetailFilter);
        AddFilter($filter, $this->SearchWhere);

        // Set up filter
        if ($this->Command == "json") {
            $this->UseSessionForListSql = false; // Do not use session for ListSQL
            $this->CurrentFilter = $filter;
        } else {
            $this->setSessionWhere($filter);
            $this->CurrentFilter = "";
        }
        if ($this->isGridAdd()) {
            $this->CurrentFilter = "0=1";
            $this->StartRecord = 1;
            $this->DisplayRecords = $this->GridAddRowCount;
            $this->TotalRecords = $this->DisplayRecords;
            $this->StopRecord = $this->DisplayRecords;
        } else {
            $this->TotalRecords = $this->listRecordCount();
            $this->StartRecord = 1;
            if ($this->DisplayRecords <= 0 || ($this->isExport() && $this->ExportAll)) { // Display all records
                $this->DisplayRecords = $this->TotalRecords;
            }
            if (!($this->isExport() && $this->ExportAll)) { // Set up start record position
                $this->setupStartRecord();
            }
            $this->Recordset = $this->loadRecordset($this->StartRecord - 1, $this->DisplayRecords);

            // Set no record found message
            if (!$this->CurrentAction && $this->TotalRecords == 0) {
                if ($this->SearchWhere == "0=101") {
                    $this->setWarningMessage($Language->phrase("EnterSearchCriteria"));
                } else {
                    $this->setWarningMessage($Language->phrase("NoRecord"));
                }
            }
        }

        // Search options
        $this->setupSearchOptions();

        // Set up search panel class
        if ($this->SearchWhere != "") {
            AppendClass($this->SearchPanelClass, "show");
        }

        // Normal return
        if (IsApi()) {
            $rows = $this->getRecordsFromRecordset($this->Recordset);
            $this->Recordset->close();
            WriteJson(["success" => true, $this->TableVar => $rows, "totalRecordCount" => $this->TotalRecords]);
            $this->terminate(true);
            return;
        }

        // Set up pager
        $this->Pager = new PrevNextPager($this->StartRecord, $this->getRecordsPerPage(), $this->TotalRecords, $this->PageSizes, $this->RecordRange, $this->AutoHidePager, $this->AutoHidePageSizeSelector);

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

    // Set up number of records displayed per page
    protected function setupDisplayRecords()
    {
        $wrk = Get(Config("TABLE_REC_PER_PAGE"), "");
        if ($wrk != "") {
            if (is_numeric($wrk)) {
                $this->DisplayRecords = (int)$wrk;
            } else {
                if (SameText($wrk, "all")) { // Display all records
                    $this->DisplayRecords = -1;
                } else {
                    $this->DisplayRecords = 10; // Non-numeric, load default
                }
            }
            $this->setRecordsPerPage($this->DisplayRecords); // Save to Session
            // Reset start position
            $this->StartRecord = 1;
            $this->setStartRecordNumber($this->StartRecord);
        }
    }

    // Build filter for all keys
    protected function buildKeyFilter()
    {
        global $CurrentForm;
        $wrkFilter = "";

        // Update row index and get row key
        $rowindex = 1;
        $CurrentForm->Index = $rowindex;
        $thisKey = strval($CurrentForm->getValue($this->OldKeyName));
        while ($thisKey != "") {
            $this->setKey($thisKey);
            if ($this->OldKey != "") {
                $filter = $this->getRecordFilter();
                if ($wrkFilter != "") {
                    $wrkFilter .= " OR ";
                }
                $wrkFilter .= $filter;
            } else {
                $wrkFilter = "0=1";
                break;
            }

            // Update row index and get row key
            $rowindex++; // Next row
            $CurrentForm->Index = $rowindex;
            $thisKey = strval($CurrentForm->getValue($this->OldKeyName));
        }
        return $wrkFilter;
    }

    // Get list of filters
    public function getFilterList()
    {
        global $UserProfile;

        // Initialize
        $filterList = "";
        $savedFilterList = "";
        $filterList = Concat($filterList, $this->ORG_UNIT_CODE->AdvancedSearch->toJson(), ","); // Field ORG_UNIT_CODE
        $filterList = Concat($filterList, $this->BILL_ID->AdvancedSearch->toJson(), ","); // Field BILL_ID
        $filterList = Concat($filterList, $this->NO_REGISTRATION->AdvancedSearch->toJson(), ","); // Field NO_REGISTRATION
        $filterList = Concat($filterList, $this->VISIT_ID->AdvancedSearch->toJson(), ","); // Field VISIT_ID
        $filterList = Concat($filterList, $this->TARIF_ID->AdvancedSearch->toJson(), ","); // Field TARIF_ID
        $filterList = Concat($filterList, $this->CLASS_ID->AdvancedSearch->toJson(), ","); // Field CLASS_ID
        $filterList = Concat($filterList, $this->CLINIC_ID->AdvancedSearch->toJson(), ","); // Field CLINIC_ID
        $filterList = Concat($filterList, $this->CLINIC_ID_FROM->AdvancedSearch->toJson(), ","); // Field CLINIC_ID_FROM
        $filterList = Concat($filterList, $this->TREATMENT->AdvancedSearch->toJson(), ","); // Field TREATMENT
        $filterList = Concat($filterList, $this->TREAT_DATE->AdvancedSearch->toJson(), ","); // Field TREAT_DATE
        $filterList = Concat($filterList, $this->AMOUNT->AdvancedSearch->toJson(), ","); // Field AMOUNT
        $filterList = Concat($filterList, $this->QUANTITY->AdvancedSearch->toJson(), ","); // Field QUANTITY
        $filterList = Concat($filterList, $this->MEASURE_ID->AdvancedSearch->toJson(), ","); // Field MEASURE_ID
        $filterList = Concat($filterList, $this->POKOK_JUAL->AdvancedSearch->toJson(), ","); // Field POKOK_JUAL
        $filterList = Concat($filterList, $this->PPN->AdvancedSearch->toJson(), ","); // Field PPN
        $filterList = Concat($filterList, $this->MARGIN->AdvancedSearch->toJson(), ","); // Field MARGIN
        $filterList = Concat($filterList, $this->SUBSIDI->AdvancedSearch->toJson(), ","); // Field SUBSIDI
        $filterList = Concat($filterList, $this->EMBALACE->AdvancedSearch->toJson(), ","); // Field EMBALACE
        $filterList = Concat($filterList, $this->PROFESI->AdvancedSearch->toJson(), ","); // Field PROFESI
        $filterList = Concat($filterList, $this->DISCOUNT->AdvancedSearch->toJson(), ","); // Field DISCOUNT
        $filterList = Concat($filterList, $this->PAY_METHOD_ID->AdvancedSearch->toJson(), ","); // Field PAY_METHOD_ID
        $filterList = Concat($filterList, $this->PAYMENT_DATE->AdvancedSearch->toJson(), ","); // Field PAYMENT_DATE
        $filterList = Concat($filterList, $this->ISLUNAS->AdvancedSearch->toJson(), ","); // Field ISLUNAS
        $filterList = Concat($filterList, $this->DUEDATE_ANGSURAN->AdvancedSearch->toJson(), ","); // Field DUEDATE_ANGSURAN
        $filterList = Concat($filterList, $this->DESCRIPTION->AdvancedSearch->toJson(), ","); // Field DESCRIPTION
        $filterList = Concat($filterList, $this->KUITANSI_ID->AdvancedSearch->toJson(), ","); // Field KUITANSI_ID
        $filterList = Concat($filterList, $this->NOTA_NO->AdvancedSearch->toJson(), ","); // Field NOTA_NO
        $filterList = Concat($filterList, $this->ISCETAK->AdvancedSearch->toJson(), ","); // Field ISCETAK
        $filterList = Concat($filterList, $this->PRINT_DATE->AdvancedSearch->toJson(), ","); // Field PRINT_DATE
        $filterList = Concat($filterList, $this->RESEP_NO->AdvancedSearch->toJson(), ","); // Field RESEP_NO
        $filterList = Concat($filterList, $this->RESEP_KE->AdvancedSearch->toJson(), ","); // Field RESEP_KE
        $filterList = Concat($filterList, $this->DOSE->AdvancedSearch->toJson(), ","); // Field DOSE
        $filterList = Concat($filterList, $this->ORIG_DOSE->AdvancedSearch->toJson(), ","); // Field ORIG_DOSE
        $filterList = Concat($filterList, $this->DOSE_PRESC->AdvancedSearch->toJson(), ","); // Field DOSE_PRESC
        $filterList = Concat($filterList, $this->ITER->AdvancedSearch->toJson(), ","); // Field ITER
        $filterList = Concat($filterList, $this->ITER_KE->AdvancedSearch->toJson(), ","); // Field ITER_KE
        $filterList = Concat($filterList, $this->SOLD_STATUS->AdvancedSearch->toJson(), ","); // Field SOLD_STATUS
        $filterList = Concat($filterList, $this->RACIKAN->AdvancedSearch->toJson(), ","); // Field RACIKAN
        $filterList = Concat($filterList, $this->CLASS_ROOM_ID->AdvancedSearch->toJson(), ","); // Field CLASS_ROOM_ID
        $filterList = Concat($filterList, $this->KELUAR_ID->AdvancedSearch->toJson(), ","); // Field KELUAR_ID
        $filterList = Concat($filterList, $this->BED_ID->AdvancedSearch->toJson(), ","); // Field BED_ID
        $filterList = Concat($filterList, $this->PERDA_ID->AdvancedSearch->toJson(), ","); // Field PERDA_ID
        $filterList = Concat($filterList, $this->EMPLOYEE_ID->AdvancedSearch->toJson(), ","); // Field EMPLOYEE_ID
        $filterList = Concat($filterList, $this->DESCRIPTION2->AdvancedSearch->toJson(), ","); // Field DESCRIPTION2
        $filterList = Concat($filterList, $this->MODIFIED_BY->AdvancedSearch->toJson(), ","); // Field MODIFIED_BY
        $filterList = Concat($filterList, $this->MODIFIED_DATE->AdvancedSearch->toJson(), ","); // Field MODIFIED_DATE
        $filterList = Concat($filterList, $this->MODIFIED_FROM->AdvancedSearch->toJson(), ","); // Field MODIFIED_FROM
        $filterList = Concat($filterList, $this->BRAND_ID->AdvancedSearch->toJson(), ","); // Field BRAND_ID
        $filterList = Concat($filterList, $this->DOCTOR->AdvancedSearch->toJson(), ","); // Field DOCTOR
        $filterList = Concat($filterList, $this->JML_BKS->AdvancedSearch->toJson(), ","); // Field JML_BKS
        $filterList = Concat($filterList, $this->EXIT_DATE->AdvancedSearch->toJson(), ","); // Field EXIT_DATE
        $filterList = Concat($filterList, $this->FA_V->AdvancedSearch->toJson(), ","); // Field FA_V
        $filterList = Concat($filterList, $this->TASK_ID->AdvancedSearch->toJson(), ","); // Field TASK_ID
        $filterList = Concat($filterList, $this->EMPLOYEE_ID_FROM->AdvancedSearch->toJson(), ","); // Field EMPLOYEE_ID_FROM
        $filterList = Concat($filterList, $this->DOCTOR_FROM->AdvancedSearch->toJson(), ","); // Field DOCTOR_FROM
        $filterList = Concat($filterList, $this->status_pasien_id->AdvancedSearch->toJson(), ","); // Field status_pasien_id
        $filterList = Concat($filterList, $this->AMOUNT_PAID->AdvancedSearch->toJson(), ","); // Field AMOUNT_PAID
        $filterList = Concat($filterList, $this->THENAME->AdvancedSearch->toJson(), ","); // Field THENAME
        $filterList = Concat($filterList, $this->THEADDRESS->AdvancedSearch->toJson(), ","); // Field THEADDRESS
        $filterList = Concat($filterList, $this->THEID->AdvancedSearch->toJson(), ","); // Field THEID
        $filterList = Concat($filterList, $this->SERIAL_NB->AdvancedSearch->toJson(), ","); // Field SERIAL_NB
        $filterList = Concat($filterList, $this->TREATMENT_PLAFOND->AdvancedSearch->toJson(), ","); // Field TREATMENT_PLAFOND
        $filterList = Concat($filterList, $this->AMOUNT_PLAFOND->AdvancedSearch->toJson(), ","); // Field AMOUNT_PLAFOND
        $filterList = Concat($filterList, $this->AMOUNT_PAID_PLAFOND->AdvancedSearch->toJson(), ","); // Field AMOUNT_PAID_PLAFOND
        $filterList = Concat($filterList, $this->CLASS_ID_PLAFOND->AdvancedSearch->toJson(), ","); // Field CLASS_ID_PLAFOND
        $filterList = Concat($filterList, $this->PAYOR_ID->AdvancedSearch->toJson(), ","); // Field PAYOR_ID
        $filterList = Concat($filterList, $this->PEMBULATAN->AdvancedSearch->toJson(), ","); // Field PEMBULATAN
        $filterList = Concat($filterList, $this->ISRJ->AdvancedSearch->toJson(), ","); // Field ISRJ
        $filterList = Concat($filterList, $this->AGEYEAR->AdvancedSearch->toJson(), ","); // Field AGEYEAR
        $filterList = Concat($filterList, $this->AGEMONTH->AdvancedSearch->toJson(), ","); // Field AGEMONTH
        $filterList = Concat($filterList, $this->AGEDAY->AdvancedSearch->toJson(), ","); // Field AGEDAY
        $filterList = Concat($filterList, $this->GENDER->AdvancedSearch->toJson(), ","); // Field GENDER
        $filterList = Concat($filterList, $this->KAL_ID->AdvancedSearch->toJson(), ","); // Field KAL_ID
        $filterList = Concat($filterList, $this->CORRECTION_ID->AdvancedSearch->toJson(), ","); // Field CORRECTION_ID
        $filterList = Concat($filterList, $this->CORRECTION_BY->AdvancedSearch->toJson(), ","); // Field CORRECTION_BY
        $filterList = Concat($filterList, $this->KARYAWAN->AdvancedSearch->toJson(), ","); // Field KARYAWAN
        $filterList = Concat($filterList, $this->ACCOUNT_ID->AdvancedSearch->toJson(), ","); // Field ACCOUNT_ID
        $filterList = Concat($filterList, $this->sell_price->AdvancedSearch->toJson(), ","); // Field sell_price
        $filterList = Concat($filterList, $this->diskon->AdvancedSearch->toJson(), ","); // Field diskon
        $filterList = Concat($filterList, $this->INVOICE_ID->AdvancedSearch->toJson(), ","); // Field INVOICE_ID
        $filterList = Concat($filterList, $this->NUMER->AdvancedSearch->toJson(), ","); // Field NUMER
        $filterList = Concat($filterList, $this->MEASURE_ID2->AdvancedSearch->toJson(), ","); // Field MEASURE_ID2
        $filterList = Concat($filterList, $this->POTONGAN->AdvancedSearch->toJson(), ","); // Field POTONGAN
        $filterList = Concat($filterList, $this->BAYAR->AdvancedSearch->toJson(), ","); // Field BAYAR
        $filterList = Concat($filterList, $this->RETUR->AdvancedSearch->toJson(), ","); // Field RETUR
        $filterList = Concat($filterList, $this->TARIF_TYPE->AdvancedSearch->toJson(), ","); // Field TARIF_TYPE
        $filterList = Concat($filterList, $this->PPNVALUE->AdvancedSearch->toJson(), ","); // Field PPNVALUE
        $filterList = Concat($filterList, $this->TAGIHAN->AdvancedSearch->toJson(), ","); // Field TAGIHAN
        $filterList = Concat($filterList, $this->KOREKSI->AdvancedSearch->toJson(), ","); // Field KOREKSI
        $filterList = Concat($filterList, $this->STATUS_OBAT->AdvancedSearch->toJson(), ","); // Field STATUS_OBAT
        $filterList = Concat($filterList, $this->SUBSIDISAT->AdvancedSearch->toJson(), ","); // Field SUBSIDISAT
        $filterList = Concat($filterList, $this->PRINTQ->AdvancedSearch->toJson(), ","); // Field PRINTQ
        $filterList = Concat($filterList, $this->PRINTED_BY->AdvancedSearch->toJson(), ","); // Field PRINTED_BY
        $filterList = Concat($filterList, $this->STOCK_AVAILABLE->AdvancedSearch->toJson(), ","); // Field STOCK_AVAILABLE
        $filterList = Concat($filterList, $this->STATUS_TARIF->AdvancedSearch->toJson(), ","); // Field STATUS_TARIF
        $filterList = Concat($filterList, $this->CLINIC_TYPE->AdvancedSearch->toJson(), ","); // Field CLINIC_TYPE
        $filterList = Concat($filterList, $this->PACKAGE_ID->AdvancedSearch->toJson(), ","); // Field PACKAGE_ID
        $filterList = Concat($filterList, $this->MODULE_ID->AdvancedSearch->toJson(), ","); // Field MODULE_ID
        $filterList = Concat($filterList, $this->profession->AdvancedSearch->toJson(), ","); // Field profession
        $filterList = Concat($filterList, $this->THEORDER->AdvancedSearch->toJson(), ","); // Field THEORDER
        $filterList = Concat($filterList, $this->CASHIER->AdvancedSearch->toJson(), ","); // Field CASHIER
        if ($this->BasicSearch->Keyword != "") {
            $wrk = "\"" . Config("TABLE_BASIC_SEARCH") . "\":\"" . JsEncode($this->BasicSearch->Keyword) . "\",\"" . Config("TABLE_BASIC_SEARCH_TYPE") . "\":\"" . JsEncode($this->BasicSearch->Type) . "\"";
            $filterList = Concat($filterList, $wrk, ",");
        }

        // Return filter list in JSON
        if ($filterList != "") {
            $filterList = "\"data\":{" . $filterList . "}";
        }
        if ($savedFilterList != "") {
            $filterList = Concat($filterList, "\"filters\":" . $savedFilterList, ",");
        }
        return ($filterList != "") ? "{" . $filterList . "}" : "null";
    }

    // Process filter list
    protected function processFilterList()
    {
        global $UserProfile;
        if (Post("ajax") == "savefilters") { // Save filter request (Ajax)
            $filters = Post("filters");
            $UserProfile->setSearchFilters(CurrentUserName(), "fTREATMENT_BILLTRANS1listsrch", $filters);
            WriteJson([["success" => true]]); // Success
            return true;
        } elseif (Post("cmd") == "resetfilter") {
            $this->restoreFilterList();
        }
        return false;
    }

    // Restore list of filters
    protected function restoreFilterList()
    {
        // Return if not reset filter
        if (Post("cmd") !== "resetfilter") {
            return false;
        }
        $filter = json_decode(Post("filter"), true);
        $this->Command = "search";

        // Field ORG_UNIT_CODE
        $this->ORG_UNIT_CODE->AdvancedSearch->SearchValue = @$filter["x_ORG_UNIT_CODE"];
        $this->ORG_UNIT_CODE->AdvancedSearch->SearchOperator = @$filter["z_ORG_UNIT_CODE"];
        $this->ORG_UNIT_CODE->AdvancedSearch->SearchCondition = @$filter["v_ORG_UNIT_CODE"];
        $this->ORG_UNIT_CODE->AdvancedSearch->SearchValue2 = @$filter["y_ORG_UNIT_CODE"];
        $this->ORG_UNIT_CODE->AdvancedSearch->SearchOperator2 = @$filter["w_ORG_UNIT_CODE"];
        $this->ORG_UNIT_CODE->AdvancedSearch->save();

        // Field BILL_ID
        $this->BILL_ID->AdvancedSearch->SearchValue = @$filter["x_BILL_ID"];
        $this->BILL_ID->AdvancedSearch->SearchOperator = @$filter["z_BILL_ID"];
        $this->BILL_ID->AdvancedSearch->SearchCondition = @$filter["v_BILL_ID"];
        $this->BILL_ID->AdvancedSearch->SearchValue2 = @$filter["y_BILL_ID"];
        $this->BILL_ID->AdvancedSearch->SearchOperator2 = @$filter["w_BILL_ID"];
        $this->BILL_ID->AdvancedSearch->save();

        // Field NO_REGISTRATION
        $this->NO_REGISTRATION->AdvancedSearch->SearchValue = @$filter["x_NO_REGISTRATION"];
        $this->NO_REGISTRATION->AdvancedSearch->SearchOperator = @$filter["z_NO_REGISTRATION"];
        $this->NO_REGISTRATION->AdvancedSearch->SearchCondition = @$filter["v_NO_REGISTRATION"];
        $this->NO_REGISTRATION->AdvancedSearch->SearchValue2 = @$filter["y_NO_REGISTRATION"];
        $this->NO_REGISTRATION->AdvancedSearch->SearchOperator2 = @$filter["w_NO_REGISTRATION"];
        $this->NO_REGISTRATION->AdvancedSearch->save();

        // Field VISIT_ID
        $this->VISIT_ID->AdvancedSearch->SearchValue = @$filter["x_VISIT_ID"];
        $this->VISIT_ID->AdvancedSearch->SearchOperator = @$filter["z_VISIT_ID"];
        $this->VISIT_ID->AdvancedSearch->SearchCondition = @$filter["v_VISIT_ID"];
        $this->VISIT_ID->AdvancedSearch->SearchValue2 = @$filter["y_VISIT_ID"];
        $this->VISIT_ID->AdvancedSearch->SearchOperator2 = @$filter["w_VISIT_ID"];
        $this->VISIT_ID->AdvancedSearch->save();

        // Field TARIF_ID
        $this->TARIF_ID->AdvancedSearch->SearchValue = @$filter["x_TARIF_ID"];
        $this->TARIF_ID->AdvancedSearch->SearchOperator = @$filter["z_TARIF_ID"];
        $this->TARIF_ID->AdvancedSearch->SearchCondition = @$filter["v_TARIF_ID"];
        $this->TARIF_ID->AdvancedSearch->SearchValue2 = @$filter["y_TARIF_ID"];
        $this->TARIF_ID->AdvancedSearch->SearchOperator2 = @$filter["w_TARIF_ID"];
        $this->TARIF_ID->AdvancedSearch->save();

        // Field CLASS_ID
        $this->CLASS_ID->AdvancedSearch->SearchValue = @$filter["x_CLASS_ID"];
        $this->CLASS_ID->AdvancedSearch->SearchOperator = @$filter["z_CLASS_ID"];
        $this->CLASS_ID->AdvancedSearch->SearchCondition = @$filter["v_CLASS_ID"];
        $this->CLASS_ID->AdvancedSearch->SearchValue2 = @$filter["y_CLASS_ID"];
        $this->CLASS_ID->AdvancedSearch->SearchOperator2 = @$filter["w_CLASS_ID"];
        $this->CLASS_ID->AdvancedSearch->save();

        // Field CLINIC_ID
        $this->CLINIC_ID->AdvancedSearch->SearchValue = @$filter["x_CLINIC_ID"];
        $this->CLINIC_ID->AdvancedSearch->SearchOperator = @$filter["z_CLINIC_ID"];
        $this->CLINIC_ID->AdvancedSearch->SearchCondition = @$filter["v_CLINIC_ID"];
        $this->CLINIC_ID->AdvancedSearch->SearchValue2 = @$filter["y_CLINIC_ID"];
        $this->CLINIC_ID->AdvancedSearch->SearchOperator2 = @$filter["w_CLINIC_ID"];
        $this->CLINIC_ID->AdvancedSearch->save();

        // Field CLINIC_ID_FROM
        $this->CLINIC_ID_FROM->AdvancedSearch->SearchValue = @$filter["x_CLINIC_ID_FROM"];
        $this->CLINIC_ID_FROM->AdvancedSearch->SearchOperator = @$filter["z_CLINIC_ID_FROM"];
        $this->CLINIC_ID_FROM->AdvancedSearch->SearchCondition = @$filter["v_CLINIC_ID_FROM"];
        $this->CLINIC_ID_FROM->AdvancedSearch->SearchValue2 = @$filter["y_CLINIC_ID_FROM"];
        $this->CLINIC_ID_FROM->AdvancedSearch->SearchOperator2 = @$filter["w_CLINIC_ID_FROM"];
        $this->CLINIC_ID_FROM->AdvancedSearch->save();

        // Field TREATMENT
        $this->TREATMENT->AdvancedSearch->SearchValue = @$filter["x_TREATMENT"];
        $this->TREATMENT->AdvancedSearch->SearchOperator = @$filter["z_TREATMENT"];
        $this->TREATMENT->AdvancedSearch->SearchCondition = @$filter["v_TREATMENT"];
        $this->TREATMENT->AdvancedSearch->SearchValue2 = @$filter["y_TREATMENT"];
        $this->TREATMENT->AdvancedSearch->SearchOperator2 = @$filter["w_TREATMENT"];
        $this->TREATMENT->AdvancedSearch->save();

        // Field TREAT_DATE
        $this->TREAT_DATE->AdvancedSearch->SearchValue = @$filter["x_TREAT_DATE"];
        $this->TREAT_DATE->AdvancedSearch->SearchOperator = @$filter["z_TREAT_DATE"];
        $this->TREAT_DATE->AdvancedSearch->SearchCondition = @$filter["v_TREAT_DATE"];
        $this->TREAT_DATE->AdvancedSearch->SearchValue2 = @$filter["y_TREAT_DATE"];
        $this->TREAT_DATE->AdvancedSearch->SearchOperator2 = @$filter["w_TREAT_DATE"];
        $this->TREAT_DATE->AdvancedSearch->save();

        // Field AMOUNT
        $this->AMOUNT->AdvancedSearch->SearchValue = @$filter["x_AMOUNT"];
        $this->AMOUNT->AdvancedSearch->SearchOperator = @$filter["z_AMOUNT"];
        $this->AMOUNT->AdvancedSearch->SearchCondition = @$filter["v_AMOUNT"];
        $this->AMOUNT->AdvancedSearch->SearchValue2 = @$filter["y_AMOUNT"];
        $this->AMOUNT->AdvancedSearch->SearchOperator2 = @$filter["w_AMOUNT"];
        $this->AMOUNT->AdvancedSearch->save();

        // Field QUANTITY
        $this->QUANTITY->AdvancedSearch->SearchValue = @$filter["x_QUANTITY"];
        $this->QUANTITY->AdvancedSearch->SearchOperator = @$filter["z_QUANTITY"];
        $this->QUANTITY->AdvancedSearch->SearchCondition = @$filter["v_QUANTITY"];
        $this->QUANTITY->AdvancedSearch->SearchValue2 = @$filter["y_QUANTITY"];
        $this->QUANTITY->AdvancedSearch->SearchOperator2 = @$filter["w_QUANTITY"];
        $this->QUANTITY->AdvancedSearch->save();

        // Field MEASURE_ID
        $this->MEASURE_ID->AdvancedSearch->SearchValue = @$filter["x_MEASURE_ID"];
        $this->MEASURE_ID->AdvancedSearch->SearchOperator = @$filter["z_MEASURE_ID"];
        $this->MEASURE_ID->AdvancedSearch->SearchCondition = @$filter["v_MEASURE_ID"];
        $this->MEASURE_ID->AdvancedSearch->SearchValue2 = @$filter["y_MEASURE_ID"];
        $this->MEASURE_ID->AdvancedSearch->SearchOperator2 = @$filter["w_MEASURE_ID"];
        $this->MEASURE_ID->AdvancedSearch->save();

        // Field POKOK_JUAL
        $this->POKOK_JUAL->AdvancedSearch->SearchValue = @$filter["x_POKOK_JUAL"];
        $this->POKOK_JUAL->AdvancedSearch->SearchOperator = @$filter["z_POKOK_JUAL"];
        $this->POKOK_JUAL->AdvancedSearch->SearchCondition = @$filter["v_POKOK_JUAL"];
        $this->POKOK_JUAL->AdvancedSearch->SearchValue2 = @$filter["y_POKOK_JUAL"];
        $this->POKOK_JUAL->AdvancedSearch->SearchOperator2 = @$filter["w_POKOK_JUAL"];
        $this->POKOK_JUAL->AdvancedSearch->save();

        // Field PPN
        $this->PPN->AdvancedSearch->SearchValue = @$filter["x_PPN"];
        $this->PPN->AdvancedSearch->SearchOperator = @$filter["z_PPN"];
        $this->PPN->AdvancedSearch->SearchCondition = @$filter["v_PPN"];
        $this->PPN->AdvancedSearch->SearchValue2 = @$filter["y_PPN"];
        $this->PPN->AdvancedSearch->SearchOperator2 = @$filter["w_PPN"];
        $this->PPN->AdvancedSearch->save();

        // Field MARGIN
        $this->MARGIN->AdvancedSearch->SearchValue = @$filter["x_MARGIN"];
        $this->MARGIN->AdvancedSearch->SearchOperator = @$filter["z_MARGIN"];
        $this->MARGIN->AdvancedSearch->SearchCondition = @$filter["v_MARGIN"];
        $this->MARGIN->AdvancedSearch->SearchValue2 = @$filter["y_MARGIN"];
        $this->MARGIN->AdvancedSearch->SearchOperator2 = @$filter["w_MARGIN"];
        $this->MARGIN->AdvancedSearch->save();

        // Field SUBSIDI
        $this->SUBSIDI->AdvancedSearch->SearchValue = @$filter["x_SUBSIDI"];
        $this->SUBSIDI->AdvancedSearch->SearchOperator = @$filter["z_SUBSIDI"];
        $this->SUBSIDI->AdvancedSearch->SearchCondition = @$filter["v_SUBSIDI"];
        $this->SUBSIDI->AdvancedSearch->SearchValue2 = @$filter["y_SUBSIDI"];
        $this->SUBSIDI->AdvancedSearch->SearchOperator2 = @$filter["w_SUBSIDI"];
        $this->SUBSIDI->AdvancedSearch->save();

        // Field EMBALACE
        $this->EMBALACE->AdvancedSearch->SearchValue = @$filter["x_EMBALACE"];
        $this->EMBALACE->AdvancedSearch->SearchOperator = @$filter["z_EMBALACE"];
        $this->EMBALACE->AdvancedSearch->SearchCondition = @$filter["v_EMBALACE"];
        $this->EMBALACE->AdvancedSearch->SearchValue2 = @$filter["y_EMBALACE"];
        $this->EMBALACE->AdvancedSearch->SearchOperator2 = @$filter["w_EMBALACE"];
        $this->EMBALACE->AdvancedSearch->save();

        // Field PROFESI
        $this->PROFESI->AdvancedSearch->SearchValue = @$filter["x_PROFESI"];
        $this->PROFESI->AdvancedSearch->SearchOperator = @$filter["z_PROFESI"];
        $this->PROFESI->AdvancedSearch->SearchCondition = @$filter["v_PROFESI"];
        $this->PROFESI->AdvancedSearch->SearchValue2 = @$filter["y_PROFESI"];
        $this->PROFESI->AdvancedSearch->SearchOperator2 = @$filter["w_PROFESI"];
        $this->PROFESI->AdvancedSearch->save();

        // Field DISCOUNT
        $this->DISCOUNT->AdvancedSearch->SearchValue = @$filter["x_DISCOUNT"];
        $this->DISCOUNT->AdvancedSearch->SearchOperator = @$filter["z_DISCOUNT"];
        $this->DISCOUNT->AdvancedSearch->SearchCondition = @$filter["v_DISCOUNT"];
        $this->DISCOUNT->AdvancedSearch->SearchValue2 = @$filter["y_DISCOUNT"];
        $this->DISCOUNT->AdvancedSearch->SearchOperator2 = @$filter["w_DISCOUNT"];
        $this->DISCOUNT->AdvancedSearch->save();

        // Field PAY_METHOD_ID
        $this->PAY_METHOD_ID->AdvancedSearch->SearchValue = @$filter["x_PAY_METHOD_ID"];
        $this->PAY_METHOD_ID->AdvancedSearch->SearchOperator = @$filter["z_PAY_METHOD_ID"];
        $this->PAY_METHOD_ID->AdvancedSearch->SearchCondition = @$filter["v_PAY_METHOD_ID"];
        $this->PAY_METHOD_ID->AdvancedSearch->SearchValue2 = @$filter["y_PAY_METHOD_ID"];
        $this->PAY_METHOD_ID->AdvancedSearch->SearchOperator2 = @$filter["w_PAY_METHOD_ID"];
        $this->PAY_METHOD_ID->AdvancedSearch->save();

        // Field PAYMENT_DATE
        $this->PAYMENT_DATE->AdvancedSearch->SearchValue = @$filter["x_PAYMENT_DATE"];
        $this->PAYMENT_DATE->AdvancedSearch->SearchOperator = @$filter["z_PAYMENT_DATE"];
        $this->PAYMENT_DATE->AdvancedSearch->SearchCondition = @$filter["v_PAYMENT_DATE"];
        $this->PAYMENT_DATE->AdvancedSearch->SearchValue2 = @$filter["y_PAYMENT_DATE"];
        $this->PAYMENT_DATE->AdvancedSearch->SearchOperator2 = @$filter["w_PAYMENT_DATE"];
        $this->PAYMENT_DATE->AdvancedSearch->save();

        // Field ISLUNAS
        $this->ISLUNAS->AdvancedSearch->SearchValue = @$filter["x_ISLUNAS"];
        $this->ISLUNAS->AdvancedSearch->SearchOperator = @$filter["z_ISLUNAS"];
        $this->ISLUNAS->AdvancedSearch->SearchCondition = @$filter["v_ISLUNAS"];
        $this->ISLUNAS->AdvancedSearch->SearchValue2 = @$filter["y_ISLUNAS"];
        $this->ISLUNAS->AdvancedSearch->SearchOperator2 = @$filter["w_ISLUNAS"];
        $this->ISLUNAS->AdvancedSearch->save();

        // Field DUEDATE_ANGSURAN
        $this->DUEDATE_ANGSURAN->AdvancedSearch->SearchValue = @$filter["x_DUEDATE_ANGSURAN"];
        $this->DUEDATE_ANGSURAN->AdvancedSearch->SearchOperator = @$filter["z_DUEDATE_ANGSURAN"];
        $this->DUEDATE_ANGSURAN->AdvancedSearch->SearchCondition = @$filter["v_DUEDATE_ANGSURAN"];
        $this->DUEDATE_ANGSURAN->AdvancedSearch->SearchValue2 = @$filter["y_DUEDATE_ANGSURAN"];
        $this->DUEDATE_ANGSURAN->AdvancedSearch->SearchOperator2 = @$filter["w_DUEDATE_ANGSURAN"];
        $this->DUEDATE_ANGSURAN->AdvancedSearch->save();

        // Field DESCRIPTION
        $this->DESCRIPTION->AdvancedSearch->SearchValue = @$filter["x_DESCRIPTION"];
        $this->DESCRIPTION->AdvancedSearch->SearchOperator = @$filter["z_DESCRIPTION"];
        $this->DESCRIPTION->AdvancedSearch->SearchCondition = @$filter["v_DESCRIPTION"];
        $this->DESCRIPTION->AdvancedSearch->SearchValue2 = @$filter["y_DESCRIPTION"];
        $this->DESCRIPTION->AdvancedSearch->SearchOperator2 = @$filter["w_DESCRIPTION"];
        $this->DESCRIPTION->AdvancedSearch->save();

        // Field KUITANSI_ID
        $this->KUITANSI_ID->AdvancedSearch->SearchValue = @$filter["x_KUITANSI_ID"];
        $this->KUITANSI_ID->AdvancedSearch->SearchOperator = @$filter["z_KUITANSI_ID"];
        $this->KUITANSI_ID->AdvancedSearch->SearchCondition = @$filter["v_KUITANSI_ID"];
        $this->KUITANSI_ID->AdvancedSearch->SearchValue2 = @$filter["y_KUITANSI_ID"];
        $this->KUITANSI_ID->AdvancedSearch->SearchOperator2 = @$filter["w_KUITANSI_ID"];
        $this->KUITANSI_ID->AdvancedSearch->save();

        // Field NOTA_NO
        $this->NOTA_NO->AdvancedSearch->SearchValue = @$filter["x_NOTA_NO"];
        $this->NOTA_NO->AdvancedSearch->SearchOperator = @$filter["z_NOTA_NO"];
        $this->NOTA_NO->AdvancedSearch->SearchCondition = @$filter["v_NOTA_NO"];
        $this->NOTA_NO->AdvancedSearch->SearchValue2 = @$filter["y_NOTA_NO"];
        $this->NOTA_NO->AdvancedSearch->SearchOperator2 = @$filter["w_NOTA_NO"];
        $this->NOTA_NO->AdvancedSearch->save();

        // Field ISCETAK
        $this->ISCETAK->AdvancedSearch->SearchValue = @$filter["x_ISCETAK"];
        $this->ISCETAK->AdvancedSearch->SearchOperator = @$filter["z_ISCETAK"];
        $this->ISCETAK->AdvancedSearch->SearchCondition = @$filter["v_ISCETAK"];
        $this->ISCETAK->AdvancedSearch->SearchValue2 = @$filter["y_ISCETAK"];
        $this->ISCETAK->AdvancedSearch->SearchOperator2 = @$filter["w_ISCETAK"];
        $this->ISCETAK->AdvancedSearch->save();

        // Field PRINT_DATE
        $this->PRINT_DATE->AdvancedSearch->SearchValue = @$filter["x_PRINT_DATE"];
        $this->PRINT_DATE->AdvancedSearch->SearchOperator = @$filter["z_PRINT_DATE"];
        $this->PRINT_DATE->AdvancedSearch->SearchCondition = @$filter["v_PRINT_DATE"];
        $this->PRINT_DATE->AdvancedSearch->SearchValue2 = @$filter["y_PRINT_DATE"];
        $this->PRINT_DATE->AdvancedSearch->SearchOperator2 = @$filter["w_PRINT_DATE"];
        $this->PRINT_DATE->AdvancedSearch->save();

        // Field RESEP_NO
        $this->RESEP_NO->AdvancedSearch->SearchValue = @$filter["x_RESEP_NO"];
        $this->RESEP_NO->AdvancedSearch->SearchOperator = @$filter["z_RESEP_NO"];
        $this->RESEP_NO->AdvancedSearch->SearchCondition = @$filter["v_RESEP_NO"];
        $this->RESEP_NO->AdvancedSearch->SearchValue2 = @$filter["y_RESEP_NO"];
        $this->RESEP_NO->AdvancedSearch->SearchOperator2 = @$filter["w_RESEP_NO"];
        $this->RESEP_NO->AdvancedSearch->save();

        // Field RESEP_KE
        $this->RESEP_KE->AdvancedSearch->SearchValue = @$filter["x_RESEP_KE"];
        $this->RESEP_KE->AdvancedSearch->SearchOperator = @$filter["z_RESEP_KE"];
        $this->RESEP_KE->AdvancedSearch->SearchCondition = @$filter["v_RESEP_KE"];
        $this->RESEP_KE->AdvancedSearch->SearchValue2 = @$filter["y_RESEP_KE"];
        $this->RESEP_KE->AdvancedSearch->SearchOperator2 = @$filter["w_RESEP_KE"];
        $this->RESEP_KE->AdvancedSearch->save();

        // Field DOSE
        $this->DOSE->AdvancedSearch->SearchValue = @$filter["x_DOSE"];
        $this->DOSE->AdvancedSearch->SearchOperator = @$filter["z_DOSE"];
        $this->DOSE->AdvancedSearch->SearchCondition = @$filter["v_DOSE"];
        $this->DOSE->AdvancedSearch->SearchValue2 = @$filter["y_DOSE"];
        $this->DOSE->AdvancedSearch->SearchOperator2 = @$filter["w_DOSE"];
        $this->DOSE->AdvancedSearch->save();

        // Field ORIG_DOSE
        $this->ORIG_DOSE->AdvancedSearch->SearchValue = @$filter["x_ORIG_DOSE"];
        $this->ORIG_DOSE->AdvancedSearch->SearchOperator = @$filter["z_ORIG_DOSE"];
        $this->ORIG_DOSE->AdvancedSearch->SearchCondition = @$filter["v_ORIG_DOSE"];
        $this->ORIG_DOSE->AdvancedSearch->SearchValue2 = @$filter["y_ORIG_DOSE"];
        $this->ORIG_DOSE->AdvancedSearch->SearchOperator2 = @$filter["w_ORIG_DOSE"];
        $this->ORIG_DOSE->AdvancedSearch->save();

        // Field DOSE_PRESC
        $this->DOSE_PRESC->AdvancedSearch->SearchValue = @$filter["x_DOSE_PRESC"];
        $this->DOSE_PRESC->AdvancedSearch->SearchOperator = @$filter["z_DOSE_PRESC"];
        $this->DOSE_PRESC->AdvancedSearch->SearchCondition = @$filter["v_DOSE_PRESC"];
        $this->DOSE_PRESC->AdvancedSearch->SearchValue2 = @$filter["y_DOSE_PRESC"];
        $this->DOSE_PRESC->AdvancedSearch->SearchOperator2 = @$filter["w_DOSE_PRESC"];
        $this->DOSE_PRESC->AdvancedSearch->save();

        // Field ITER
        $this->ITER->AdvancedSearch->SearchValue = @$filter["x_ITER"];
        $this->ITER->AdvancedSearch->SearchOperator = @$filter["z_ITER"];
        $this->ITER->AdvancedSearch->SearchCondition = @$filter["v_ITER"];
        $this->ITER->AdvancedSearch->SearchValue2 = @$filter["y_ITER"];
        $this->ITER->AdvancedSearch->SearchOperator2 = @$filter["w_ITER"];
        $this->ITER->AdvancedSearch->save();

        // Field ITER_KE
        $this->ITER_KE->AdvancedSearch->SearchValue = @$filter["x_ITER_KE"];
        $this->ITER_KE->AdvancedSearch->SearchOperator = @$filter["z_ITER_KE"];
        $this->ITER_KE->AdvancedSearch->SearchCondition = @$filter["v_ITER_KE"];
        $this->ITER_KE->AdvancedSearch->SearchValue2 = @$filter["y_ITER_KE"];
        $this->ITER_KE->AdvancedSearch->SearchOperator2 = @$filter["w_ITER_KE"];
        $this->ITER_KE->AdvancedSearch->save();

        // Field SOLD_STATUS
        $this->SOLD_STATUS->AdvancedSearch->SearchValue = @$filter["x_SOLD_STATUS"];
        $this->SOLD_STATUS->AdvancedSearch->SearchOperator = @$filter["z_SOLD_STATUS"];
        $this->SOLD_STATUS->AdvancedSearch->SearchCondition = @$filter["v_SOLD_STATUS"];
        $this->SOLD_STATUS->AdvancedSearch->SearchValue2 = @$filter["y_SOLD_STATUS"];
        $this->SOLD_STATUS->AdvancedSearch->SearchOperator2 = @$filter["w_SOLD_STATUS"];
        $this->SOLD_STATUS->AdvancedSearch->save();

        // Field RACIKAN
        $this->RACIKAN->AdvancedSearch->SearchValue = @$filter["x_RACIKAN"];
        $this->RACIKAN->AdvancedSearch->SearchOperator = @$filter["z_RACIKAN"];
        $this->RACIKAN->AdvancedSearch->SearchCondition = @$filter["v_RACIKAN"];
        $this->RACIKAN->AdvancedSearch->SearchValue2 = @$filter["y_RACIKAN"];
        $this->RACIKAN->AdvancedSearch->SearchOperator2 = @$filter["w_RACIKAN"];
        $this->RACIKAN->AdvancedSearch->save();

        // Field CLASS_ROOM_ID
        $this->CLASS_ROOM_ID->AdvancedSearch->SearchValue = @$filter["x_CLASS_ROOM_ID"];
        $this->CLASS_ROOM_ID->AdvancedSearch->SearchOperator = @$filter["z_CLASS_ROOM_ID"];
        $this->CLASS_ROOM_ID->AdvancedSearch->SearchCondition = @$filter["v_CLASS_ROOM_ID"];
        $this->CLASS_ROOM_ID->AdvancedSearch->SearchValue2 = @$filter["y_CLASS_ROOM_ID"];
        $this->CLASS_ROOM_ID->AdvancedSearch->SearchOperator2 = @$filter["w_CLASS_ROOM_ID"];
        $this->CLASS_ROOM_ID->AdvancedSearch->save();

        // Field KELUAR_ID
        $this->KELUAR_ID->AdvancedSearch->SearchValue = @$filter["x_KELUAR_ID"];
        $this->KELUAR_ID->AdvancedSearch->SearchOperator = @$filter["z_KELUAR_ID"];
        $this->KELUAR_ID->AdvancedSearch->SearchCondition = @$filter["v_KELUAR_ID"];
        $this->KELUAR_ID->AdvancedSearch->SearchValue2 = @$filter["y_KELUAR_ID"];
        $this->KELUAR_ID->AdvancedSearch->SearchOperator2 = @$filter["w_KELUAR_ID"];
        $this->KELUAR_ID->AdvancedSearch->save();

        // Field BED_ID
        $this->BED_ID->AdvancedSearch->SearchValue = @$filter["x_BED_ID"];
        $this->BED_ID->AdvancedSearch->SearchOperator = @$filter["z_BED_ID"];
        $this->BED_ID->AdvancedSearch->SearchCondition = @$filter["v_BED_ID"];
        $this->BED_ID->AdvancedSearch->SearchValue2 = @$filter["y_BED_ID"];
        $this->BED_ID->AdvancedSearch->SearchOperator2 = @$filter["w_BED_ID"];
        $this->BED_ID->AdvancedSearch->save();

        // Field PERDA_ID
        $this->PERDA_ID->AdvancedSearch->SearchValue = @$filter["x_PERDA_ID"];
        $this->PERDA_ID->AdvancedSearch->SearchOperator = @$filter["z_PERDA_ID"];
        $this->PERDA_ID->AdvancedSearch->SearchCondition = @$filter["v_PERDA_ID"];
        $this->PERDA_ID->AdvancedSearch->SearchValue2 = @$filter["y_PERDA_ID"];
        $this->PERDA_ID->AdvancedSearch->SearchOperator2 = @$filter["w_PERDA_ID"];
        $this->PERDA_ID->AdvancedSearch->save();

        // Field EMPLOYEE_ID
        $this->EMPLOYEE_ID->AdvancedSearch->SearchValue = @$filter["x_EMPLOYEE_ID"];
        $this->EMPLOYEE_ID->AdvancedSearch->SearchOperator = @$filter["z_EMPLOYEE_ID"];
        $this->EMPLOYEE_ID->AdvancedSearch->SearchCondition = @$filter["v_EMPLOYEE_ID"];
        $this->EMPLOYEE_ID->AdvancedSearch->SearchValue2 = @$filter["y_EMPLOYEE_ID"];
        $this->EMPLOYEE_ID->AdvancedSearch->SearchOperator2 = @$filter["w_EMPLOYEE_ID"];
        $this->EMPLOYEE_ID->AdvancedSearch->save();

        // Field DESCRIPTION2
        $this->DESCRIPTION2->AdvancedSearch->SearchValue = @$filter["x_DESCRIPTION2"];
        $this->DESCRIPTION2->AdvancedSearch->SearchOperator = @$filter["z_DESCRIPTION2"];
        $this->DESCRIPTION2->AdvancedSearch->SearchCondition = @$filter["v_DESCRIPTION2"];
        $this->DESCRIPTION2->AdvancedSearch->SearchValue2 = @$filter["y_DESCRIPTION2"];
        $this->DESCRIPTION2->AdvancedSearch->SearchOperator2 = @$filter["w_DESCRIPTION2"];
        $this->DESCRIPTION2->AdvancedSearch->save();

        // Field MODIFIED_BY
        $this->MODIFIED_BY->AdvancedSearch->SearchValue = @$filter["x_MODIFIED_BY"];
        $this->MODIFIED_BY->AdvancedSearch->SearchOperator = @$filter["z_MODIFIED_BY"];
        $this->MODIFIED_BY->AdvancedSearch->SearchCondition = @$filter["v_MODIFIED_BY"];
        $this->MODIFIED_BY->AdvancedSearch->SearchValue2 = @$filter["y_MODIFIED_BY"];
        $this->MODIFIED_BY->AdvancedSearch->SearchOperator2 = @$filter["w_MODIFIED_BY"];
        $this->MODIFIED_BY->AdvancedSearch->save();

        // Field MODIFIED_DATE
        $this->MODIFIED_DATE->AdvancedSearch->SearchValue = @$filter["x_MODIFIED_DATE"];
        $this->MODIFIED_DATE->AdvancedSearch->SearchOperator = @$filter["z_MODIFIED_DATE"];
        $this->MODIFIED_DATE->AdvancedSearch->SearchCondition = @$filter["v_MODIFIED_DATE"];
        $this->MODIFIED_DATE->AdvancedSearch->SearchValue2 = @$filter["y_MODIFIED_DATE"];
        $this->MODIFIED_DATE->AdvancedSearch->SearchOperator2 = @$filter["w_MODIFIED_DATE"];
        $this->MODIFIED_DATE->AdvancedSearch->save();

        // Field MODIFIED_FROM
        $this->MODIFIED_FROM->AdvancedSearch->SearchValue = @$filter["x_MODIFIED_FROM"];
        $this->MODIFIED_FROM->AdvancedSearch->SearchOperator = @$filter["z_MODIFIED_FROM"];
        $this->MODIFIED_FROM->AdvancedSearch->SearchCondition = @$filter["v_MODIFIED_FROM"];
        $this->MODIFIED_FROM->AdvancedSearch->SearchValue2 = @$filter["y_MODIFIED_FROM"];
        $this->MODIFIED_FROM->AdvancedSearch->SearchOperator2 = @$filter["w_MODIFIED_FROM"];
        $this->MODIFIED_FROM->AdvancedSearch->save();

        // Field BRAND_ID
        $this->BRAND_ID->AdvancedSearch->SearchValue = @$filter["x_BRAND_ID"];
        $this->BRAND_ID->AdvancedSearch->SearchOperator = @$filter["z_BRAND_ID"];
        $this->BRAND_ID->AdvancedSearch->SearchCondition = @$filter["v_BRAND_ID"];
        $this->BRAND_ID->AdvancedSearch->SearchValue2 = @$filter["y_BRAND_ID"];
        $this->BRAND_ID->AdvancedSearch->SearchOperator2 = @$filter["w_BRAND_ID"];
        $this->BRAND_ID->AdvancedSearch->save();

        // Field DOCTOR
        $this->DOCTOR->AdvancedSearch->SearchValue = @$filter["x_DOCTOR"];
        $this->DOCTOR->AdvancedSearch->SearchOperator = @$filter["z_DOCTOR"];
        $this->DOCTOR->AdvancedSearch->SearchCondition = @$filter["v_DOCTOR"];
        $this->DOCTOR->AdvancedSearch->SearchValue2 = @$filter["y_DOCTOR"];
        $this->DOCTOR->AdvancedSearch->SearchOperator2 = @$filter["w_DOCTOR"];
        $this->DOCTOR->AdvancedSearch->save();

        // Field JML_BKS
        $this->JML_BKS->AdvancedSearch->SearchValue = @$filter["x_JML_BKS"];
        $this->JML_BKS->AdvancedSearch->SearchOperator = @$filter["z_JML_BKS"];
        $this->JML_BKS->AdvancedSearch->SearchCondition = @$filter["v_JML_BKS"];
        $this->JML_BKS->AdvancedSearch->SearchValue2 = @$filter["y_JML_BKS"];
        $this->JML_BKS->AdvancedSearch->SearchOperator2 = @$filter["w_JML_BKS"];
        $this->JML_BKS->AdvancedSearch->save();

        // Field EXIT_DATE
        $this->EXIT_DATE->AdvancedSearch->SearchValue = @$filter["x_EXIT_DATE"];
        $this->EXIT_DATE->AdvancedSearch->SearchOperator = @$filter["z_EXIT_DATE"];
        $this->EXIT_DATE->AdvancedSearch->SearchCondition = @$filter["v_EXIT_DATE"];
        $this->EXIT_DATE->AdvancedSearch->SearchValue2 = @$filter["y_EXIT_DATE"];
        $this->EXIT_DATE->AdvancedSearch->SearchOperator2 = @$filter["w_EXIT_DATE"];
        $this->EXIT_DATE->AdvancedSearch->save();

        // Field FA_V
        $this->FA_V->AdvancedSearch->SearchValue = @$filter["x_FA_V"];
        $this->FA_V->AdvancedSearch->SearchOperator = @$filter["z_FA_V"];
        $this->FA_V->AdvancedSearch->SearchCondition = @$filter["v_FA_V"];
        $this->FA_V->AdvancedSearch->SearchValue2 = @$filter["y_FA_V"];
        $this->FA_V->AdvancedSearch->SearchOperator2 = @$filter["w_FA_V"];
        $this->FA_V->AdvancedSearch->save();

        // Field TASK_ID
        $this->TASK_ID->AdvancedSearch->SearchValue = @$filter["x_TASK_ID"];
        $this->TASK_ID->AdvancedSearch->SearchOperator = @$filter["z_TASK_ID"];
        $this->TASK_ID->AdvancedSearch->SearchCondition = @$filter["v_TASK_ID"];
        $this->TASK_ID->AdvancedSearch->SearchValue2 = @$filter["y_TASK_ID"];
        $this->TASK_ID->AdvancedSearch->SearchOperator2 = @$filter["w_TASK_ID"];
        $this->TASK_ID->AdvancedSearch->save();

        // Field EMPLOYEE_ID_FROM
        $this->EMPLOYEE_ID_FROM->AdvancedSearch->SearchValue = @$filter["x_EMPLOYEE_ID_FROM"];
        $this->EMPLOYEE_ID_FROM->AdvancedSearch->SearchOperator = @$filter["z_EMPLOYEE_ID_FROM"];
        $this->EMPLOYEE_ID_FROM->AdvancedSearch->SearchCondition = @$filter["v_EMPLOYEE_ID_FROM"];
        $this->EMPLOYEE_ID_FROM->AdvancedSearch->SearchValue2 = @$filter["y_EMPLOYEE_ID_FROM"];
        $this->EMPLOYEE_ID_FROM->AdvancedSearch->SearchOperator2 = @$filter["w_EMPLOYEE_ID_FROM"];
        $this->EMPLOYEE_ID_FROM->AdvancedSearch->save();

        // Field DOCTOR_FROM
        $this->DOCTOR_FROM->AdvancedSearch->SearchValue = @$filter["x_DOCTOR_FROM"];
        $this->DOCTOR_FROM->AdvancedSearch->SearchOperator = @$filter["z_DOCTOR_FROM"];
        $this->DOCTOR_FROM->AdvancedSearch->SearchCondition = @$filter["v_DOCTOR_FROM"];
        $this->DOCTOR_FROM->AdvancedSearch->SearchValue2 = @$filter["y_DOCTOR_FROM"];
        $this->DOCTOR_FROM->AdvancedSearch->SearchOperator2 = @$filter["w_DOCTOR_FROM"];
        $this->DOCTOR_FROM->AdvancedSearch->save();

        // Field status_pasien_id
        $this->status_pasien_id->AdvancedSearch->SearchValue = @$filter["x_status_pasien_id"];
        $this->status_pasien_id->AdvancedSearch->SearchOperator = @$filter["z_status_pasien_id"];
        $this->status_pasien_id->AdvancedSearch->SearchCondition = @$filter["v_status_pasien_id"];
        $this->status_pasien_id->AdvancedSearch->SearchValue2 = @$filter["y_status_pasien_id"];
        $this->status_pasien_id->AdvancedSearch->SearchOperator2 = @$filter["w_status_pasien_id"];
        $this->status_pasien_id->AdvancedSearch->save();

        // Field AMOUNT_PAID
        $this->AMOUNT_PAID->AdvancedSearch->SearchValue = @$filter["x_AMOUNT_PAID"];
        $this->AMOUNT_PAID->AdvancedSearch->SearchOperator = @$filter["z_AMOUNT_PAID"];
        $this->AMOUNT_PAID->AdvancedSearch->SearchCondition = @$filter["v_AMOUNT_PAID"];
        $this->AMOUNT_PAID->AdvancedSearch->SearchValue2 = @$filter["y_AMOUNT_PAID"];
        $this->AMOUNT_PAID->AdvancedSearch->SearchOperator2 = @$filter["w_AMOUNT_PAID"];
        $this->AMOUNT_PAID->AdvancedSearch->save();

        // Field THENAME
        $this->THENAME->AdvancedSearch->SearchValue = @$filter["x_THENAME"];
        $this->THENAME->AdvancedSearch->SearchOperator = @$filter["z_THENAME"];
        $this->THENAME->AdvancedSearch->SearchCondition = @$filter["v_THENAME"];
        $this->THENAME->AdvancedSearch->SearchValue2 = @$filter["y_THENAME"];
        $this->THENAME->AdvancedSearch->SearchOperator2 = @$filter["w_THENAME"];
        $this->THENAME->AdvancedSearch->save();

        // Field THEADDRESS
        $this->THEADDRESS->AdvancedSearch->SearchValue = @$filter["x_THEADDRESS"];
        $this->THEADDRESS->AdvancedSearch->SearchOperator = @$filter["z_THEADDRESS"];
        $this->THEADDRESS->AdvancedSearch->SearchCondition = @$filter["v_THEADDRESS"];
        $this->THEADDRESS->AdvancedSearch->SearchValue2 = @$filter["y_THEADDRESS"];
        $this->THEADDRESS->AdvancedSearch->SearchOperator2 = @$filter["w_THEADDRESS"];
        $this->THEADDRESS->AdvancedSearch->save();

        // Field THEID
        $this->THEID->AdvancedSearch->SearchValue = @$filter["x_THEID"];
        $this->THEID->AdvancedSearch->SearchOperator = @$filter["z_THEID"];
        $this->THEID->AdvancedSearch->SearchCondition = @$filter["v_THEID"];
        $this->THEID->AdvancedSearch->SearchValue2 = @$filter["y_THEID"];
        $this->THEID->AdvancedSearch->SearchOperator2 = @$filter["w_THEID"];
        $this->THEID->AdvancedSearch->save();

        // Field SERIAL_NB
        $this->SERIAL_NB->AdvancedSearch->SearchValue = @$filter["x_SERIAL_NB"];
        $this->SERIAL_NB->AdvancedSearch->SearchOperator = @$filter["z_SERIAL_NB"];
        $this->SERIAL_NB->AdvancedSearch->SearchCondition = @$filter["v_SERIAL_NB"];
        $this->SERIAL_NB->AdvancedSearch->SearchValue2 = @$filter["y_SERIAL_NB"];
        $this->SERIAL_NB->AdvancedSearch->SearchOperator2 = @$filter["w_SERIAL_NB"];
        $this->SERIAL_NB->AdvancedSearch->save();

        // Field TREATMENT_PLAFOND
        $this->TREATMENT_PLAFOND->AdvancedSearch->SearchValue = @$filter["x_TREATMENT_PLAFOND"];
        $this->TREATMENT_PLAFOND->AdvancedSearch->SearchOperator = @$filter["z_TREATMENT_PLAFOND"];
        $this->TREATMENT_PLAFOND->AdvancedSearch->SearchCondition = @$filter["v_TREATMENT_PLAFOND"];
        $this->TREATMENT_PLAFOND->AdvancedSearch->SearchValue2 = @$filter["y_TREATMENT_PLAFOND"];
        $this->TREATMENT_PLAFOND->AdvancedSearch->SearchOperator2 = @$filter["w_TREATMENT_PLAFOND"];
        $this->TREATMENT_PLAFOND->AdvancedSearch->save();

        // Field AMOUNT_PLAFOND
        $this->AMOUNT_PLAFOND->AdvancedSearch->SearchValue = @$filter["x_AMOUNT_PLAFOND"];
        $this->AMOUNT_PLAFOND->AdvancedSearch->SearchOperator = @$filter["z_AMOUNT_PLAFOND"];
        $this->AMOUNT_PLAFOND->AdvancedSearch->SearchCondition = @$filter["v_AMOUNT_PLAFOND"];
        $this->AMOUNT_PLAFOND->AdvancedSearch->SearchValue2 = @$filter["y_AMOUNT_PLAFOND"];
        $this->AMOUNT_PLAFOND->AdvancedSearch->SearchOperator2 = @$filter["w_AMOUNT_PLAFOND"];
        $this->AMOUNT_PLAFOND->AdvancedSearch->save();

        // Field AMOUNT_PAID_PLAFOND
        $this->AMOUNT_PAID_PLAFOND->AdvancedSearch->SearchValue = @$filter["x_AMOUNT_PAID_PLAFOND"];
        $this->AMOUNT_PAID_PLAFOND->AdvancedSearch->SearchOperator = @$filter["z_AMOUNT_PAID_PLAFOND"];
        $this->AMOUNT_PAID_PLAFOND->AdvancedSearch->SearchCondition = @$filter["v_AMOUNT_PAID_PLAFOND"];
        $this->AMOUNT_PAID_PLAFOND->AdvancedSearch->SearchValue2 = @$filter["y_AMOUNT_PAID_PLAFOND"];
        $this->AMOUNT_PAID_PLAFOND->AdvancedSearch->SearchOperator2 = @$filter["w_AMOUNT_PAID_PLAFOND"];
        $this->AMOUNT_PAID_PLAFOND->AdvancedSearch->save();

        // Field CLASS_ID_PLAFOND
        $this->CLASS_ID_PLAFOND->AdvancedSearch->SearchValue = @$filter["x_CLASS_ID_PLAFOND"];
        $this->CLASS_ID_PLAFOND->AdvancedSearch->SearchOperator = @$filter["z_CLASS_ID_PLAFOND"];
        $this->CLASS_ID_PLAFOND->AdvancedSearch->SearchCondition = @$filter["v_CLASS_ID_PLAFOND"];
        $this->CLASS_ID_PLAFOND->AdvancedSearch->SearchValue2 = @$filter["y_CLASS_ID_PLAFOND"];
        $this->CLASS_ID_PLAFOND->AdvancedSearch->SearchOperator2 = @$filter["w_CLASS_ID_PLAFOND"];
        $this->CLASS_ID_PLAFOND->AdvancedSearch->save();

        // Field PAYOR_ID
        $this->PAYOR_ID->AdvancedSearch->SearchValue = @$filter["x_PAYOR_ID"];
        $this->PAYOR_ID->AdvancedSearch->SearchOperator = @$filter["z_PAYOR_ID"];
        $this->PAYOR_ID->AdvancedSearch->SearchCondition = @$filter["v_PAYOR_ID"];
        $this->PAYOR_ID->AdvancedSearch->SearchValue2 = @$filter["y_PAYOR_ID"];
        $this->PAYOR_ID->AdvancedSearch->SearchOperator2 = @$filter["w_PAYOR_ID"];
        $this->PAYOR_ID->AdvancedSearch->save();

        // Field PEMBULATAN
        $this->PEMBULATAN->AdvancedSearch->SearchValue = @$filter["x_PEMBULATAN"];
        $this->PEMBULATAN->AdvancedSearch->SearchOperator = @$filter["z_PEMBULATAN"];
        $this->PEMBULATAN->AdvancedSearch->SearchCondition = @$filter["v_PEMBULATAN"];
        $this->PEMBULATAN->AdvancedSearch->SearchValue2 = @$filter["y_PEMBULATAN"];
        $this->PEMBULATAN->AdvancedSearch->SearchOperator2 = @$filter["w_PEMBULATAN"];
        $this->PEMBULATAN->AdvancedSearch->save();

        // Field ISRJ
        $this->ISRJ->AdvancedSearch->SearchValue = @$filter["x_ISRJ"];
        $this->ISRJ->AdvancedSearch->SearchOperator = @$filter["z_ISRJ"];
        $this->ISRJ->AdvancedSearch->SearchCondition = @$filter["v_ISRJ"];
        $this->ISRJ->AdvancedSearch->SearchValue2 = @$filter["y_ISRJ"];
        $this->ISRJ->AdvancedSearch->SearchOperator2 = @$filter["w_ISRJ"];
        $this->ISRJ->AdvancedSearch->save();

        // Field AGEYEAR
        $this->AGEYEAR->AdvancedSearch->SearchValue = @$filter["x_AGEYEAR"];
        $this->AGEYEAR->AdvancedSearch->SearchOperator = @$filter["z_AGEYEAR"];
        $this->AGEYEAR->AdvancedSearch->SearchCondition = @$filter["v_AGEYEAR"];
        $this->AGEYEAR->AdvancedSearch->SearchValue2 = @$filter["y_AGEYEAR"];
        $this->AGEYEAR->AdvancedSearch->SearchOperator2 = @$filter["w_AGEYEAR"];
        $this->AGEYEAR->AdvancedSearch->save();

        // Field AGEMONTH
        $this->AGEMONTH->AdvancedSearch->SearchValue = @$filter["x_AGEMONTH"];
        $this->AGEMONTH->AdvancedSearch->SearchOperator = @$filter["z_AGEMONTH"];
        $this->AGEMONTH->AdvancedSearch->SearchCondition = @$filter["v_AGEMONTH"];
        $this->AGEMONTH->AdvancedSearch->SearchValue2 = @$filter["y_AGEMONTH"];
        $this->AGEMONTH->AdvancedSearch->SearchOperator2 = @$filter["w_AGEMONTH"];
        $this->AGEMONTH->AdvancedSearch->save();

        // Field AGEDAY
        $this->AGEDAY->AdvancedSearch->SearchValue = @$filter["x_AGEDAY"];
        $this->AGEDAY->AdvancedSearch->SearchOperator = @$filter["z_AGEDAY"];
        $this->AGEDAY->AdvancedSearch->SearchCondition = @$filter["v_AGEDAY"];
        $this->AGEDAY->AdvancedSearch->SearchValue2 = @$filter["y_AGEDAY"];
        $this->AGEDAY->AdvancedSearch->SearchOperator2 = @$filter["w_AGEDAY"];
        $this->AGEDAY->AdvancedSearch->save();

        // Field GENDER
        $this->GENDER->AdvancedSearch->SearchValue = @$filter["x_GENDER"];
        $this->GENDER->AdvancedSearch->SearchOperator = @$filter["z_GENDER"];
        $this->GENDER->AdvancedSearch->SearchCondition = @$filter["v_GENDER"];
        $this->GENDER->AdvancedSearch->SearchValue2 = @$filter["y_GENDER"];
        $this->GENDER->AdvancedSearch->SearchOperator2 = @$filter["w_GENDER"];
        $this->GENDER->AdvancedSearch->save();

        // Field KAL_ID
        $this->KAL_ID->AdvancedSearch->SearchValue = @$filter["x_KAL_ID"];
        $this->KAL_ID->AdvancedSearch->SearchOperator = @$filter["z_KAL_ID"];
        $this->KAL_ID->AdvancedSearch->SearchCondition = @$filter["v_KAL_ID"];
        $this->KAL_ID->AdvancedSearch->SearchValue2 = @$filter["y_KAL_ID"];
        $this->KAL_ID->AdvancedSearch->SearchOperator2 = @$filter["w_KAL_ID"];
        $this->KAL_ID->AdvancedSearch->save();

        // Field CORRECTION_ID
        $this->CORRECTION_ID->AdvancedSearch->SearchValue = @$filter["x_CORRECTION_ID"];
        $this->CORRECTION_ID->AdvancedSearch->SearchOperator = @$filter["z_CORRECTION_ID"];
        $this->CORRECTION_ID->AdvancedSearch->SearchCondition = @$filter["v_CORRECTION_ID"];
        $this->CORRECTION_ID->AdvancedSearch->SearchValue2 = @$filter["y_CORRECTION_ID"];
        $this->CORRECTION_ID->AdvancedSearch->SearchOperator2 = @$filter["w_CORRECTION_ID"];
        $this->CORRECTION_ID->AdvancedSearch->save();

        // Field CORRECTION_BY
        $this->CORRECTION_BY->AdvancedSearch->SearchValue = @$filter["x_CORRECTION_BY"];
        $this->CORRECTION_BY->AdvancedSearch->SearchOperator = @$filter["z_CORRECTION_BY"];
        $this->CORRECTION_BY->AdvancedSearch->SearchCondition = @$filter["v_CORRECTION_BY"];
        $this->CORRECTION_BY->AdvancedSearch->SearchValue2 = @$filter["y_CORRECTION_BY"];
        $this->CORRECTION_BY->AdvancedSearch->SearchOperator2 = @$filter["w_CORRECTION_BY"];
        $this->CORRECTION_BY->AdvancedSearch->save();

        // Field KARYAWAN
        $this->KARYAWAN->AdvancedSearch->SearchValue = @$filter["x_KARYAWAN"];
        $this->KARYAWAN->AdvancedSearch->SearchOperator = @$filter["z_KARYAWAN"];
        $this->KARYAWAN->AdvancedSearch->SearchCondition = @$filter["v_KARYAWAN"];
        $this->KARYAWAN->AdvancedSearch->SearchValue2 = @$filter["y_KARYAWAN"];
        $this->KARYAWAN->AdvancedSearch->SearchOperator2 = @$filter["w_KARYAWAN"];
        $this->KARYAWAN->AdvancedSearch->save();

        // Field ACCOUNT_ID
        $this->ACCOUNT_ID->AdvancedSearch->SearchValue = @$filter["x_ACCOUNT_ID"];
        $this->ACCOUNT_ID->AdvancedSearch->SearchOperator = @$filter["z_ACCOUNT_ID"];
        $this->ACCOUNT_ID->AdvancedSearch->SearchCondition = @$filter["v_ACCOUNT_ID"];
        $this->ACCOUNT_ID->AdvancedSearch->SearchValue2 = @$filter["y_ACCOUNT_ID"];
        $this->ACCOUNT_ID->AdvancedSearch->SearchOperator2 = @$filter["w_ACCOUNT_ID"];
        $this->ACCOUNT_ID->AdvancedSearch->save();

        // Field sell_price
        $this->sell_price->AdvancedSearch->SearchValue = @$filter["x_sell_price"];
        $this->sell_price->AdvancedSearch->SearchOperator = @$filter["z_sell_price"];
        $this->sell_price->AdvancedSearch->SearchCondition = @$filter["v_sell_price"];
        $this->sell_price->AdvancedSearch->SearchValue2 = @$filter["y_sell_price"];
        $this->sell_price->AdvancedSearch->SearchOperator2 = @$filter["w_sell_price"];
        $this->sell_price->AdvancedSearch->save();

        // Field diskon
        $this->diskon->AdvancedSearch->SearchValue = @$filter["x_diskon"];
        $this->diskon->AdvancedSearch->SearchOperator = @$filter["z_diskon"];
        $this->diskon->AdvancedSearch->SearchCondition = @$filter["v_diskon"];
        $this->diskon->AdvancedSearch->SearchValue2 = @$filter["y_diskon"];
        $this->diskon->AdvancedSearch->SearchOperator2 = @$filter["w_diskon"];
        $this->diskon->AdvancedSearch->save();

        // Field INVOICE_ID
        $this->INVOICE_ID->AdvancedSearch->SearchValue = @$filter["x_INVOICE_ID"];
        $this->INVOICE_ID->AdvancedSearch->SearchOperator = @$filter["z_INVOICE_ID"];
        $this->INVOICE_ID->AdvancedSearch->SearchCondition = @$filter["v_INVOICE_ID"];
        $this->INVOICE_ID->AdvancedSearch->SearchValue2 = @$filter["y_INVOICE_ID"];
        $this->INVOICE_ID->AdvancedSearch->SearchOperator2 = @$filter["w_INVOICE_ID"];
        $this->INVOICE_ID->AdvancedSearch->save();

        // Field NUMER
        $this->NUMER->AdvancedSearch->SearchValue = @$filter["x_NUMER"];
        $this->NUMER->AdvancedSearch->SearchOperator = @$filter["z_NUMER"];
        $this->NUMER->AdvancedSearch->SearchCondition = @$filter["v_NUMER"];
        $this->NUMER->AdvancedSearch->SearchValue2 = @$filter["y_NUMER"];
        $this->NUMER->AdvancedSearch->SearchOperator2 = @$filter["w_NUMER"];
        $this->NUMER->AdvancedSearch->save();

        // Field MEASURE_ID2
        $this->MEASURE_ID2->AdvancedSearch->SearchValue = @$filter["x_MEASURE_ID2"];
        $this->MEASURE_ID2->AdvancedSearch->SearchOperator = @$filter["z_MEASURE_ID2"];
        $this->MEASURE_ID2->AdvancedSearch->SearchCondition = @$filter["v_MEASURE_ID2"];
        $this->MEASURE_ID2->AdvancedSearch->SearchValue2 = @$filter["y_MEASURE_ID2"];
        $this->MEASURE_ID2->AdvancedSearch->SearchOperator2 = @$filter["w_MEASURE_ID2"];
        $this->MEASURE_ID2->AdvancedSearch->save();

        // Field POTONGAN
        $this->POTONGAN->AdvancedSearch->SearchValue = @$filter["x_POTONGAN"];
        $this->POTONGAN->AdvancedSearch->SearchOperator = @$filter["z_POTONGAN"];
        $this->POTONGAN->AdvancedSearch->SearchCondition = @$filter["v_POTONGAN"];
        $this->POTONGAN->AdvancedSearch->SearchValue2 = @$filter["y_POTONGAN"];
        $this->POTONGAN->AdvancedSearch->SearchOperator2 = @$filter["w_POTONGAN"];
        $this->POTONGAN->AdvancedSearch->save();

        // Field BAYAR
        $this->BAYAR->AdvancedSearch->SearchValue = @$filter["x_BAYAR"];
        $this->BAYAR->AdvancedSearch->SearchOperator = @$filter["z_BAYAR"];
        $this->BAYAR->AdvancedSearch->SearchCondition = @$filter["v_BAYAR"];
        $this->BAYAR->AdvancedSearch->SearchValue2 = @$filter["y_BAYAR"];
        $this->BAYAR->AdvancedSearch->SearchOperator2 = @$filter["w_BAYAR"];
        $this->BAYAR->AdvancedSearch->save();

        // Field RETUR
        $this->RETUR->AdvancedSearch->SearchValue = @$filter["x_RETUR"];
        $this->RETUR->AdvancedSearch->SearchOperator = @$filter["z_RETUR"];
        $this->RETUR->AdvancedSearch->SearchCondition = @$filter["v_RETUR"];
        $this->RETUR->AdvancedSearch->SearchValue2 = @$filter["y_RETUR"];
        $this->RETUR->AdvancedSearch->SearchOperator2 = @$filter["w_RETUR"];
        $this->RETUR->AdvancedSearch->save();

        // Field TARIF_TYPE
        $this->TARIF_TYPE->AdvancedSearch->SearchValue = @$filter["x_TARIF_TYPE"];
        $this->TARIF_TYPE->AdvancedSearch->SearchOperator = @$filter["z_TARIF_TYPE"];
        $this->TARIF_TYPE->AdvancedSearch->SearchCondition = @$filter["v_TARIF_TYPE"];
        $this->TARIF_TYPE->AdvancedSearch->SearchValue2 = @$filter["y_TARIF_TYPE"];
        $this->TARIF_TYPE->AdvancedSearch->SearchOperator2 = @$filter["w_TARIF_TYPE"];
        $this->TARIF_TYPE->AdvancedSearch->save();

        // Field PPNVALUE
        $this->PPNVALUE->AdvancedSearch->SearchValue = @$filter["x_PPNVALUE"];
        $this->PPNVALUE->AdvancedSearch->SearchOperator = @$filter["z_PPNVALUE"];
        $this->PPNVALUE->AdvancedSearch->SearchCondition = @$filter["v_PPNVALUE"];
        $this->PPNVALUE->AdvancedSearch->SearchValue2 = @$filter["y_PPNVALUE"];
        $this->PPNVALUE->AdvancedSearch->SearchOperator2 = @$filter["w_PPNVALUE"];
        $this->PPNVALUE->AdvancedSearch->save();

        // Field TAGIHAN
        $this->TAGIHAN->AdvancedSearch->SearchValue = @$filter["x_TAGIHAN"];
        $this->TAGIHAN->AdvancedSearch->SearchOperator = @$filter["z_TAGIHAN"];
        $this->TAGIHAN->AdvancedSearch->SearchCondition = @$filter["v_TAGIHAN"];
        $this->TAGIHAN->AdvancedSearch->SearchValue2 = @$filter["y_TAGIHAN"];
        $this->TAGIHAN->AdvancedSearch->SearchOperator2 = @$filter["w_TAGIHAN"];
        $this->TAGIHAN->AdvancedSearch->save();

        // Field KOREKSI
        $this->KOREKSI->AdvancedSearch->SearchValue = @$filter["x_KOREKSI"];
        $this->KOREKSI->AdvancedSearch->SearchOperator = @$filter["z_KOREKSI"];
        $this->KOREKSI->AdvancedSearch->SearchCondition = @$filter["v_KOREKSI"];
        $this->KOREKSI->AdvancedSearch->SearchValue2 = @$filter["y_KOREKSI"];
        $this->KOREKSI->AdvancedSearch->SearchOperator2 = @$filter["w_KOREKSI"];
        $this->KOREKSI->AdvancedSearch->save();

        // Field STATUS_OBAT
        $this->STATUS_OBAT->AdvancedSearch->SearchValue = @$filter["x_STATUS_OBAT"];
        $this->STATUS_OBAT->AdvancedSearch->SearchOperator = @$filter["z_STATUS_OBAT"];
        $this->STATUS_OBAT->AdvancedSearch->SearchCondition = @$filter["v_STATUS_OBAT"];
        $this->STATUS_OBAT->AdvancedSearch->SearchValue2 = @$filter["y_STATUS_OBAT"];
        $this->STATUS_OBAT->AdvancedSearch->SearchOperator2 = @$filter["w_STATUS_OBAT"];
        $this->STATUS_OBAT->AdvancedSearch->save();

        // Field SUBSIDISAT
        $this->SUBSIDISAT->AdvancedSearch->SearchValue = @$filter["x_SUBSIDISAT"];
        $this->SUBSIDISAT->AdvancedSearch->SearchOperator = @$filter["z_SUBSIDISAT"];
        $this->SUBSIDISAT->AdvancedSearch->SearchCondition = @$filter["v_SUBSIDISAT"];
        $this->SUBSIDISAT->AdvancedSearch->SearchValue2 = @$filter["y_SUBSIDISAT"];
        $this->SUBSIDISAT->AdvancedSearch->SearchOperator2 = @$filter["w_SUBSIDISAT"];
        $this->SUBSIDISAT->AdvancedSearch->save();

        // Field PRINTQ
        $this->PRINTQ->AdvancedSearch->SearchValue = @$filter["x_PRINTQ"];
        $this->PRINTQ->AdvancedSearch->SearchOperator = @$filter["z_PRINTQ"];
        $this->PRINTQ->AdvancedSearch->SearchCondition = @$filter["v_PRINTQ"];
        $this->PRINTQ->AdvancedSearch->SearchValue2 = @$filter["y_PRINTQ"];
        $this->PRINTQ->AdvancedSearch->SearchOperator2 = @$filter["w_PRINTQ"];
        $this->PRINTQ->AdvancedSearch->save();

        // Field PRINTED_BY
        $this->PRINTED_BY->AdvancedSearch->SearchValue = @$filter["x_PRINTED_BY"];
        $this->PRINTED_BY->AdvancedSearch->SearchOperator = @$filter["z_PRINTED_BY"];
        $this->PRINTED_BY->AdvancedSearch->SearchCondition = @$filter["v_PRINTED_BY"];
        $this->PRINTED_BY->AdvancedSearch->SearchValue2 = @$filter["y_PRINTED_BY"];
        $this->PRINTED_BY->AdvancedSearch->SearchOperator2 = @$filter["w_PRINTED_BY"];
        $this->PRINTED_BY->AdvancedSearch->save();

        // Field STOCK_AVAILABLE
        $this->STOCK_AVAILABLE->AdvancedSearch->SearchValue = @$filter["x_STOCK_AVAILABLE"];
        $this->STOCK_AVAILABLE->AdvancedSearch->SearchOperator = @$filter["z_STOCK_AVAILABLE"];
        $this->STOCK_AVAILABLE->AdvancedSearch->SearchCondition = @$filter["v_STOCK_AVAILABLE"];
        $this->STOCK_AVAILABLE->AdvancedSearch->SearchValue2 = @$filter["y_STOCK_AVAILABLE"];
        $this->STOCK_AVAILABLE->AdvancedSearch->SearchOperator2 = @$filter["w_STOCK_AVAILABLE"];
        $this->STOCK_AVAILABLE->AdvancedSearch->save();

        // Field STATUS_TARIF
        $this->STATUS_TARIF->AdvancedSearch->SearchValue = @$filter["x_STATUS_TARIF"];
        $this->STATUS_TARIF->AdvancedSearch->SearchOperator = @$filter["z_STATUS_TARIF"];
        $this->STATUS_TARIF->AdvancedSearch->SearchCondition = @$filter["v_STATUS_TARIF"];
        $this->STATUS_TARIF->AdvancedSearch->SearchValue2 = @$filter["y_STATUS_TARIF"];
        $this->STATUS_TARIF->AdvancedSearch->SearchOperator2 = @$filter["w_STATUS_TARIF"];
        $this->STATUS_TARIF->AdvancedSearch->save();

        // Field CLINIC_TYPE
        $this->CLINIC_TYPE->AdvancedSearch->SearchValue = @$filter["x_CLINIC_TYPE"];
        $this->CLINIC_TYPE->AdvancedSearch->SearchOperator = @$filter["z_CLINIC_TYPE"];
        $this->CLINIC_TYPE->AdvancedSearch->SearchCondition = @$filter["v_CLINIC_TYPE"];
        $this->CLINIC_TYPE->AdvancedSearch->SearchValue2 = @$filter["y_CLINIC_TYPE"];
        $this->CLINIC_TYPE->AdvancedSearch->SearchOperator2 = @$filter["w_CLINIC_TYPE"];
        $this->CLINIC_TYPE->AdvancedSearch->save();

        // Field PACKAGE_ID
        $this->PACKAGE_ID->AdvancedSearch->SearchValue = @$filter["x_PACKAGE_ID"];
        $this->PACKAGE_ID->AdvancedSearch->SearchOperator = @$filter["z_PACKAGE_ID"];
        $this->PACKAGE_ID->AdvancedSearch->SearchCondition = @$filter["v_PACKAGE_ID"];
        $this->PACKAGE_ID->AdvancedSearch->SearchValue2 = @$filter["y_PACKAGE_ID"];
        $this->PACKAGE_ID->AdvancedSearch->SearchOperator2 = @$filter["w_PACKAGE_ID"];
        $this->PACKAGE_ID->AdvancedSearch->save();

        // Field MODULE_ID
        $this->MODULE_ID->AdvancedSearch->SearchValue = @$filter["x_MODULE_ID"];
        $this->MODULE_ID->AdvancedSearch->SearchOperator = @$filter["z_MODULE_ID"];
        $this->MODULE_ID->AdvancedSearch->SearchCondition = @$filter["v_MODULE_ID"];
        $this->MODULE_ID->AdvancedSearch->SearchValue2 = @$filter["y_MODULE_ID"];
        $this->MODULE_ID->AdvancedSearch->SearchOperator2 = @$filter["w_MODULE_ID"];
        $this->MODULE_ID->AdvancedSearch->save();

        // Field profession
        $this->profession->AdvancedSearch->SearchValue = @$filter["x_profession"];
        $this->profession->AdvancedSearch->SearchOperator = @$filter["z_profession"];
        $this->profession->AdvancedSearch->SearchCondition = @$filter["v_profession"];
        $this->profession->AdvancedSearch->SearchValue2 = @$filter["y_profession"];
        $this->profession->AdvancedSearch->SearchOperator2 = @$filter["w_profession"];
        $this->profession->AdvancedSearch->save();

        // Field THEORDER
        $this->THEORDER->AdvancedSearch->SearchValue = @$filter["x_THEORDER"];
        $this->THEORDER->AdvancedSearch->SearchOperator = @$filter["z_THEORDER"];
        $this->THEORDER->AdvancedSearch->SearchCondition = @$filter["v_THEORDER"];
        $this->THEORDER->AdvancedSearch->SearchValue2 = @$filter["y_THEORDER"];
        $this->THEORDER->AdvancedSearch->SearchOperator2 = @$filter["w_THEORDER"];
        $this->THEORDER->AdvancedSearch->save();

        // Field CASHIER
        $this->CASHIER->AdvancedSearch->SearchValue = @$filter["x_CASHIER"];
        $this->CASHIER->AdvancedSearch->SearchOperator = @$filter["z_CASHIER"];
        $this->CASHIER->AdvancedSearch->SearchCondition = @$filter["v_CASHIER"];
        $this->CASHIER->AdvancedSearch->SearchValue2 = @$filter["y_CASHIER"];
        $this->CASHIER->AdvancedSearch->SearchOperator2 = @$filter["w_CASHIER"];
        $this->CASHIER->AdvancedSearch->save();
        $this->BasicSearch->setKeyword(@$filter[Config("TABLE_BASIC_SEARCH")]);
        $this->BasicSearch->setType(@$filter[Config("TABLE_BASIC_SEARCH_TYPE")]);
    }

    // Return basic search SQL
    protected function basicSearchSql($arKeywords, $type)
    {
        $where = "";
        $this->buildBasicSearchSql($where, $this->ORG_UNIT_CODE, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->BILL_ID, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->NO_REGISTRATION, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->VISIT_ID, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->TARIF_ID, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->CLINIC_ID, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->CLINIC_ID_FROM, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->TREATMENT, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->ISLUNAS, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->DESCRIPTION, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->KUITANSI_ID, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->NOTA_NO, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->ISCETAK, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->RESEP_NO, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->CLASS_ROOM_ID, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->EMPLOYEE_ID, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->DESCRIPTION2, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->MODIFIED_BY, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->MODIFIED_FROM, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->BRAND_ID, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->DOCTOR, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->EMPLOYEE_ID_FROM, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->DOCTOR_FROM, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->THENAME, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->THEADDRESS, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->THEID, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->SERIAL_NB, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->TREATMENT_PLAFOND, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->PAYOR_ID, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->ISRJ, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->GENDER, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->KAL_ID, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->CORRECTION_ID, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->CORRECTION_BY, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->KARYAWAN, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->ACCOUNT_ID, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->INVOICE_ID, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->NUMER, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->TARIF_TYPE, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->PRINTED_BY, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->PACKAGE_ID, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->MODULE_ID, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->CASHIER, $arKeywords, $type);
        return $where;
    }

    // Build basic search SQL
    protected function buildBasicSearchSql(&$where, &$fld, $arKeywords, $type)
    {
        $defCond = ($type == "OR") ? "OR" : "AND";
        $arSql = []; // Array for SQL parts
        $arCond = []; // Array for search conditions
        $cnt = count($arKeywords);
        $j = 0; // Number of SQL parts
        for ($i = 0; $i < $cnt; $i++) {
            $keyword = $arKeywords[$i];
            $keyword = trim($keyword);
            if (Config("BASIC_SEARCH_IGNORE_PATTERN") != "") {
                $keyword = preg_replace(Config("BASIC_SEARCH_IGNORE_PATTERN"), "\\", $keyword);
                $ar = explode("\\", $keyword);
            } else {
                $ar = [$keyword];
            }
            foreach ($ar as $keyword) {
                if ($keyword != "") {
                    $wrk = "";
                    if ($keyword == "OR" && $type == "") {
                        if ($j > 0) {
                            $arCond[$j - 1] = "OR";
                        }
                    } elseif ($keyword == Config("NULL_VALUE")) {
                        $wrk = $fld->Expression . " IS NULL";
                    } elseif ($keyword == Config("NOT_NULL_VALUE")) {
                        $wrk = $fld->Expression . " IS NOT NULL";
                    } elseif ($fld->IsVirtual && $fld->Visible) {
                        $wrk = $fld->VirtualExpression . Like(QuotedValue("%" . $keyword . "%", DATATYPE_STRING, $this->Dbid), $this->Dbid);
                    } elseif ($fld->DataType != DATATYPE_NUMBER || is_numeric($keyword)) {
                        $wrk = $fld->BasicSearchExpression . Like(QuotedValue("%" . $keyword . "%", DATATYPE_STRING, $this->Dbid), $this->Dbid);
                    }
                    if ($wrk != "") {
                        $arSql[$j] = $wrk;
                        $arCond[$j] = $defCond;
                        $j += 1;
                    }
                }
            }
        }
        $cnt = count($arSql);
        $quoted = false;
        $sql = "";
        if ($cnt > 0) {
            for ($i = 0; $i < $cnt - 1; $i++) {
                if ($arCond[$i] == "OR") {
                    if (!$quoted) {
                        $sql .= "(";
                    }
                    $quoted = true;
                }
                $sql .= $arSql[$i];
                if ($quoted && $arCond[$i] != "OR") {
                    $sql .= ")";
                    $quoted = false;
                }
                $sql .= " " . $arCond[$i] . " ";
            }
            $sql .= $arSql[$cnt - 1];
            if ($quoted) {
                $sql .= ")";
            }
        }
        if ($sql != "") {
            if ($where != "") {
                $where .= " OR ";
            }
            $where .= "(" . $sql . ")";
        }
    }

    // Return basic search WHERE clause based on search keyword and type
    protected function basicSearchWhere($default = false)
    {
        global $Security;
        $searchStr = "";
        $searchKeyword = ($default) ? $this->BasicSearch->KeywordDefault : $this->BasicSearch->Keyword;
        $searchType = ($default) ? $this->BasicSearch->TypeDefault : $this->BasicSearch->Type;

        // Get search SQL
        if ($searchKeyword != "") {
            $ar = $this->BasicSearch->keywordList($default);
            // Search keyword in any fields
            if (($searchType == "OR" || $searchType == "AND") && $this->BasicSearch->BasicSearchAnyFields) {
                foreach ($ar as $keyword) {
                    if ($keyword != "") {
                        if ($searchStr != "") {
                            $searchStr .= " " . $searchType . " ";
                        }
                        $searchStr .= "(" . $this->basicSearchSql([$keyword], $searchType) . ")";
                    }
                }
            } else {
                $searchStr = $this->basicSearchSql($ar, $searchType);
            }
            if (!$default && in_array($this->Command, ["", "reset", "resetall"])) {
                $this->Command = "search";
            }
        }
        if (!$default && $this->Command == "search") {
            $this->BasicSearch->setKeyword($searchKeyword);
            $this->BasicSearch->setType($searchType);
        }
        return $searchStr;
    }

    // Check if search parm exists
    protected function checkSearchParms()
    {
        // Check basic search
        if ($this->BasicSearch->issetSession()) {
            return true;
        }
        return false;
    }

    // Clear all search parameters
    protected function resetSearchParms()
    {
        // Clear search WHERE clause
        $this->SearchWhere = "";
        $this->setSearchWhere($this->SearchWhere);

        // Clear basic search parameters
        $this->resetBasicSearchParms();
    }

    // Load advanced search default values
    protected function loadAdvancedSearchDefault()
    {
        return false;
    }

    // Clear all basic search parameters
    protected function resetBasicSearchParms()
    {
        $this->BasicSearch->unsetSession();
    }

    // Restore all search parameters
    protected function restoreSearchParms()
    {
        $this->RestoreSearch = true;

        // Restore basic search values
        $this->BasicSearch->load();
    }

    // Set up sort parameters
    protected function setupSortOrder()
    {
        // Check for "order" parameter
        if (Get("order") !== null) {
            $this->CurrentOrder = Get("order");
            $this->CurrentOrderType = Get("ordertype", "");
            $this->updateSort($this->ORG_UNIT_CODE); // ORG_UNIT_CODE
            $this->updateSort($this->BILL_ID); // BILL_ID
            $this->updateSort($this->NO_REGISTRATION); // NO_REGISTRATION
            $this->updateSort($this->VISIT_ID); // VISIT_ID
            $this->updateSort($this->TARIF_ID); // TARIF_ID
            $this->updateSort($this->CLASS_ID); // CLASS_ID
            $this->updateSort($this->CLINIC_ID); // CLINIC_ID
            $this->updateSort($this->CLINIC_ID_FROM); // CLINIC_ID_FROM
            $this->updateSort($this->TREATMENT); // TREATMENT
            $this->updateSort($this->TREAT_DATE); // TREAT_DATE
            $this->updateSort($this->AMOUNT); // AMOUNT
            $this->updateSort($this->QUANTITY); // QUANTITY
            $this->updateSort($this->MEASURE_ID); // MEASURE_ID
            $this->updateSort($this->POKOK_JUAL); // POKOK_JUAL
            $this->updateSort($this->PPN); // PPN
            $this->updateSort($this->MARGIN); // MARGIN
            $this->updateSort($this->SUBSIDI); // SUBSIDI
            $this->updateSort($this->EMBALACE); // EMBALACE
            $this->updateSort($this->PROFESI); // PROFESI
            $this->updateSort($this->DISCOUNT); // DISCOUNT
            $this->updateSort($this->PAY_METHOD_ID); // PAY_METHOD_ID
            $this->updateSort($this->PAYMENT_DATE); // PAYMENT_DATE
            $this->updateSort($this->ISLUNAS); // ISLUNAS
            $this->updateSort($this->DUEDATE_ANGSURAN); // DUEDATE_ANGSURAN
            $this->updateSort($this->DESCRIPTION); // DESCRIPTION
            $this->updateSort($this->KUITANSI_ID); // KUITANSI_ID
            $this->updateSort($this->NOTA_NO); // NOTA_NO
            $this->updateSort($this->ISCETAK); // ISCETAK
            $this->updateSort($this->PRINT_DATE); // PRINT_DATE
            $this->updateSort($this->RESEP_NO); // RESEP_NO
            $this->updateSort($this->RESEP_KE); // RESEP_KE
            $this->updateSort($this->DOSE); // DOSE
            $this->updateSort($this->ORIG_DOSE); // ORIG_DOSE
            $this->updateSort($this->DOSE_PRESC); // DOSE_PRESC
            $this->updateSort($this->ITER); // ITER
            $this->updateSort($this->ITER_KE); // ITER_KE
            $this->updateSort($this->SOLD_STATUS); // SOLD_STATUS
            $this->updateSort($this->RACIKAN); // RACIKAN
            $this->updateSort($this->CLASS_ROOM_ID); // CLASS_ROOM_ID
            $this->updateSort($this->KELUAR_ID); // KELUAR_ID
            $this->updateSort($this->BED_ID); // BED_ID
            $this->updateSort($this->PERDA_ID); // PERDA_ID
            $this->updateSort($this->EMPLOYEE_ID); // EMPLOYEE_ID
            $this->updateSort($this->DESCRIPTION2); // DESCRIPTION2
            $this->updateSort($this->MODIFIED_BY); // MODIFIED_BY
            $this->updateSort($this->MODIFIED_DATE); // MODIFIED_DATE
            $this->updateSort($this->MODIFIED_FROM); // MODIFIED_FROM
            $this->updateSort($this->BRAND_ID); // BRAND_ID
            $this->updateSort($this->DOCTOR); // DOCTOR
            $this->updateSort($this->JML_BKS); // JML_BKS
            $this->updateSort($this->EXIT_DATE); // EXIT_DATE
            $this->updateSort($this->FA_V); // FA_V
            $this->updateSort($this->TASK_ID); // TASK_ID
            $this->updateSort($this->EMPLOYEE_ID_FROM); // EMPLOYEE_ID_FROM
            $this->updateSort($this->DOCTOR_FROM); // DOCTOR_FROM
            $this->updateSort($this->status_pasien_id); // status_pasien_id
            $this->updateSort($this->AMOUNT_PAID); // AMOUNT_PAID
            $this->updateSort($this->THENAME); // THENAME
            $this->updateSort($this->THEADDRESS); // THEADDRESS
            $this->updateSort($this->THEID); // THEID
            $this->updateSort($this->SERIAL_NB); // SERIAL_NB
            $this->updateSort($this->TREATMENT_PLAFOND); // TREATMENT_PLAFOND
            $this->updateSort($this->AMOUNT_PLAFOND); // AMOUNT_PLAFOND
            $this->updateSort($this->AMOUNT_PAID_PLAFOND); // AMOUNT_PAID_PLAFOND
            $this->updateSort($this->CLASS_ID_PLAFOND); // CLASS_ID_PLAFOND
            $this->updateSort($this->PAYOR_ID); // PAYOR_ID
            $this->updateSort($this->PEMBULATAN); // PEMBULATAN
            $this->updateSort($this->ISRJ); // ISRJ
            $this->updateSort($this->AGEYEAR); // AGEYEAR
            $this->updateSort($this->AGEMONTH); // AGEMONTH
            $this->updateSort($this->AGEDAY); // AGEDAY
            $this->updateSort($this->GENDER); // GENDER
            $this->updateSort($this->KAL_ID); // KAL_ID
            $this->updateSort($this->CORRECTION_ID); // CORRECTION_ID
            $this->updateSort($this->CORRECTION_BY); // CORRECTION_BY
            $this->updateSort($this->KARYAWAN); // KARYAWAN
            $this->updateSort($this->ACCOUNT_ID); // ACCOUNT_ID
            $this->updateSort($this->sell_price); // sell_price
            $this->updateSort($this->diskon); // diskon
            $this->updateSort($this->INVOICE_ID); // INVOICE_ID
            $this->updateSort($this->NUMER); // NUMER
            $this->updateSort($this->MEASURE_ID2); // MEASURE_ID2
            $this->updateSort($this->POTONGAN); // POTONGAN
            $this->updateSort($this->BAYAR); // BAYAR
            $this->updateSort($this->RETUR); // RETUR
            $this->updateSort($this->TARIF_TYPE); // TARIF_TYPE
            $this->updateSort($this->PPNVALUE); // PPNVALUE
            $this->updateSort($this->TAGIHAN); // TAGIHAN
            $this->updateSort($this->KOREKSI); // KOREKSI
            $this->updateSort($this->STATUS_OBAT); // STATUS_OBAT
            $this->updateSort($this->SUBSIDISAT); // SUBSIDISAT
            $this->updateSort($this->PRINTQ); // PRINTQ
            $this->updateSort($this->PRINTED_BY); // PRINTED_BY
            $this->updateSort($this->STOCK_AVAILABLE); // STOCK_AVAILABLE
            $this->updateSort($this->STATUS_TARIF); // STATUS_TARIF
            $this->updateSort($this->CLINIC_TYPE); // CLINIC_TYPE
            $this->updateSort($this->PACKAGE_ID); // PACKAGE_ID
            $this->updateSort($this->MODULE_ID); // MODULE_ID
            $this->updateSort($this->profession); // profession
            $this->updateSort($this->THEORDER); // THEORDER
            $this->updateSort($this->CASHIER); // CASHIER
            $this->setStartRecordNumber(1); // Reset start position
        }
    }

    // Load sort order parameters
    protected function loadSortOrder()
    {
        $orderBy = $this->getSessionOrderBy(); // Get ORDER BY from Session
        if ($orderBy == "") {
            $this->DefaultSort = "";
            if ($this->getSqlOrderBy() != "") {
                $useDefaultSort = true;
                if ($useDefaultSort) {
                    $orderBy = $this->getSqlOrderBy();
                    $this->setSessionOrderBy($orderBy);
                } else {
                    $this->setSessionOrderBy("");
                }
            }
        }
    }

    // Reset command
    // - cmd=reset (Reset search parameters)
    // - cmd=resetall (Reset search and master/detail parameters)
    // - cmd=resetsort (Reset sort parameters)
    protected function resetCmd()
    {
        // Check if reset command
        if (StartsString("reset", $this->Command)) {
            // Reset search criteria
            if ($this->Command == "reset" || $this->Command == "resetall") {
                $this->resetSearchParms();
            }

            // Reset (clear) sorting order
            if ($this->Command == "resetsort") {
                $orderBy = "";
                $this->setSessionOrderBy($orderBy);
                $this->ORG_UNIT_CODE->setSort("");
                $this->BILL_ID->setSort("");
                $this->NO_REGISTRATION->setSort("");
                $this->VISIT_ID->setSort("");
                $this->TARIF_ID->setSort("");
                $this->CLASS_ID->setSort("");
                $this->CLINIC_ID->setSort("");
                $this->CLINIC_ID_FROM->setSort("");
                $this->TREATMENT->setSort("");
                $this->TREAT_DATE->setSort("");
                $this->AMOUNT->setSort("");
                $this->QUANTITY->setSort("");
                $this->MEASURE_ID->setSort("");
                $this->POKOK_JUAL->setSort("");
                $this->PPN->setSort("");
                $this->MARGIN->setSort("");
                $this->SUBSIDI->setSort("");
                $this->EMBALACE->setSort("");
                $this->PROFESI->setSort("");
                $this->DISCOUNT->setSort("");
                $this->PAY_METHOD_ID->setSort("");
                $this->PAYMENT_DATE->setSort("");
                $this->ISLUNAS->setSort("");
                $this->DUEDATE_ANGSURAN->setSort("");
                $this->DESCRIPTION->setSort("");
                $this->KUITANSI_ID->setSort("");
                $this->NOTA_NO->setSort("");
                $this->ISCETAK->setSort("");
                $this->PRINT_DATE->setSort("");
                $this->RESEP_NO->setSort("");
                $this->RESEP_KE->setSort("");
                $this->DOSE->setSort("");
                $this->ORIG_DOSE->setSort("");
                $this->DOSE_PRESC->setSort("");
                $this->ITER->setSort("");
                $this->ITER_KE->setSort("");
                $this->SOLD_STATUS->setSort("");
                $this->RACIKAN->setSort("");
                $this->CLASS_ROOM_ID->setSort("");
                $this->KELUAR_ID->setSort("");
                $this->BED_ID->setSort("");
                $this->PERDA_ID->setSort("");
                $this->EMPLOYEE_ID->setSort("");
                $this->DESCRIPTION2->setSort("");
                $this->MODIFIED_BY->setSort("");
                $this->MODIFIED_DATE->setSort("");
                $this->MODIFIED_FROM->setSort("");
                $this->BRAND_ID->setSort("");
                $this->DOCTOR->setSort("");
                $this->JML_BKS->setSort("");
                $this->EXIT_DATE->setSort("");
                $this->FA_V->setSort("");
                $this->TASK_ID->setSort("");
                $this->EMPLOYEE_ID_FROM->setSort("");
                $this->DOCTOR_FROM->setSort("");
                $this->status_pasien_id->setSort("");
                $this->AMOUNT_PAID->setSort("");
                $this->THENAME->setSort("");
                $this->THEADDRESS->setSort("");
                $this->THEID->setSort("");
                $this->SERIAL_NB->setSort("");
                $this->TREATMENT_PLAFOND->setSort("");
                $this->AMOUNT_PLAFOND->setSort("");
                $this->AMOUNT_PAID_PLAFOND->setSort("");
                $this->CLASS_ID_PLAFOND->setSort("");
                $this->PAYOR_ID->setSort("");
                $this->PEMBULATAN->setSort("");
                $this->ISRJ->setSort("");
                $this->AGEYEAR->setSort("");
                $this->AGEMONTH->setSort("");
                $this->AGEDAY->setSort("");
                $this->GENDER->setSort("");
                $this->KAL_ID->setSort("");
                $this->CORRECTION_ID->setSort("");
                $this->CORRECTION_BY->setSort("");
                $this->KARYAWAN->setSort("");
                $this->ACCOUNT_ID->setSort("");
                $this->sell_price->setSort("");
                $this->diskon->setSort("");
                $this->INVOICE_ID->setSort("");
                $this->NUMER->setSort("");
                $this->MEASURE_ID2->setSort("");
                $this->POTONGAN->setSort("");
                $this->BAYAR->setSort("");
                $this->RETUR->setSort("");
                $this->TARIF_TYPE->setSort("");
                $this->PPNVALUE->setSort("");
                $this->TAGIHAN->setSort("");
                $this->KOREKSI->setSort("");
                $this->STATUS_OBAT->setSort("");
                $this->SUBSIDISAT->setSort("");
                $this->PRINTQ->setSort("");
                $this->PRINTED_BY->setSort("");
                $this->STOCK_AVAILABLE->setSort("");
                $this->STATUS_TARIF->setSort("");
                $this->CLINIC_TYPE->setSort("");
                $this->PACKAGE_ID->setSort("");
                $this->MODULE_ID->setSort("");
                $this->profession->setSort("");
                $this->THEORDER->setSort("");
                $this->CASHIER->setSort("");
            }

            // Reset start position
            $this->StartRecord = 1;
            $this->setStartRecordNumber($this->StartRecord);
        }
    }

    // Set up list options
    protected function setupListOptions()
    {
        global $Security, $Language;

        // Add group option item
        $item = &$this->ListOptions->add($this->ListOptions->GroupOptionName);
        $item->Body = "";
        $item->OnLeft = true;
        $item->Visible = false;

        // "view"
        $item = &$this->ListOptions->add("view");
        $item->CssClass = "text-nowrap";
        $item->Visible = true;
        $item->OnLeft = true;

        // "edit"
        $item = &$this->ListOptions->add("edit");
        $item->CssClass = "text-nowrap";
        $item->Visible = true;
        $item->OnLeft = true;

        // "copy"
        $item = &$this->ListOptions->add("copy");
        $item->CssClass = "text-nowrap";
        $item->Visible = true;
        $item->OnLeft = true;

        // "delete"
        $item = &$this->ListOptions->add("delete");
        $item->CssClass = "text-nowrap";
        $item->Visible = true;
        $item->OnLeft = true;

        // List actions
        $item = &$this->ListOptions->add("listactions");
        $item->CssClass = "text-nowrap";
        $item->OnLeft = true;
        $item->Visible = false;
        $item->ShowInButtonGroup = false;
        $item->ShowInDropDown = false;

        // "checkbox"
        $item = &$this->ListOptions->add("checkbox");
        $item->Visible = false;
        $item->OnLeft = true;
        $item->Header = "<div class=\"custom-control custom-checkbox d-inline-block\"><input type=\"checkbox\" name=\"key\" id=\"key\" class=\"custom-control-input\" onclick=\"ew.selectAllKey(this);\"><label class=\"custom-control-label\" for=\"key\"></label></div>";
        $item->moveTo(0);
        $item->ShowInDropDown = false;
        $item->ShowInButtonGroup = false;

        // Drop down button for ListOptions
        $this->ListOptions->UseDropDownButton = false;
        $this->ListOptions->DropDownButtonPhrase = $Language->phrase("ButtonListOptions");
        $this->ListOptions->UseButtonGroup = true;
        if ($this->ListOptions->UseButtonGroup && IsMobile()) {
            $this->ListOptions->UseDropDownButton = true;
        }

        //$this->ListOptions->ButtonClass = ""; // Class for button group

        // Call ListOptions_Load event
        $this->listOptionsLoad();
        $this->setupListOptionsExt();
        $item = $this->ListOptions[$this->ListOptions->GroupOptionName];
        $item->Visible = $this->ListOptions->groupOptionVisible();
    }

    // Render list options
    public function renderListOptions()
    {
        global $Security, $Language, $CurrentForm;
        $this->ListOptions->loadDefault();

        // Call ListOptions_Rendering event
        $this->listOptionsRendering();
        $pageUrl = $this->pageUrl();
        if ($this->CurrentMode == "view") {
            // "view"
            $opt = $this->ListOptions["view"];
            $viewcaption = HtmlTitle($Language->phrase("ViewLink"));
            if (true) {
                $opt->Body = "<a class=\"ew-row-link ew-view\" title=\"" . $viewcaption . "\" data-caption=\"" . $viewcaption . "\" href=\"" . HtmlEncode(GetUrl($this->ViewUrl)) . "\">" . $Language->phrase("ViewLink") . "</a>";
            } else {
                $opt->Body = "";
            }

            // "edit"
            $opt = $this->ListOptions["edit"];
            $editcaption = HtmlTitle($Language->phrase("EditLink"));
            if (true) {
                $opt->Body = "<a class=\"ew-row-link ew-edit\" title=\"" . HtmlTitle($Language->phrase("EditLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("EditLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->EditUrl)) . "\">" . $Language->phrase("EditLink") . "</a>";
            } else {
                $opt->Body = "";
            }

            // "copy"
            $opt = $this->ListOptions["copy"];
            $copycaption = HtmlTitle($Language->phrase("CopyLink"));
            if (true) {
                $opt->Body = "<a class=\"ew-row-link ew-copy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"" . HtmlEncode(GetUrl($this->CopyUrl)) . "\">" . $Language->phrase("CopyLink") . "</a>";
            } else {
                $opt->Body = "";
            }

            // "delete"
            $opt = $this->ListOptions["delete"];
            if (true) {
            $opt->Body = "<a class=\"ew-row-link ew-delete\"" . "" . " title=\"" . HtmlTitle($Language->phrase("DeleteLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("DeleteLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->DeleteUrl)) . "\">" . $Language->phrase("DeleteLink") . "</a>";
            } else {
                $opt->Body = "";
            }
        } // End View mode

        // Set up list action buttons
        $opt = $this->ListOptions["listactions"];
        if ($opt && !$this->isExport() && !$this->CurrentAction) {
            $body = "";
            $links = [];
            foreach ($this->ListActions->Items as $listaction) {
                if ($listaction->Select == ACTION_SINGLE && $listaction->Allow) {
                    $action = $listaction->Action;
                    $caption = $listaction->Caption;
                    $icon = ($listaction->Icon != "") ? "<i class=\"" . HtmlEncode(str_replace(" ew-icon", "", $listaction->Icon)) . "\" data-caption=\"" . HtmlTitle($caption) . "\"></i> " : "";
                    $links[] = "<li><a class=\"dropdown-item ew-action ew-list-action\" data-action=\"" . HtmlEncode($action) . "\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"#\" onclick=\"return ew.submitAction(event,jQuery.extend({key:" . $this->keyToJson(true) . "}," . $listaction->toJson(true) . "));\">" . $icon . $listaction->Caption . "</a></li>";
                    if (count($links) == 1) { // Single button
                        $body = "<a class=\"ew-action ew-list-action\" data-action=\"" . HtmlEncode($action) . "\" title=\"" . HtmlTitle($caption) . "\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"#\" onclick=\"return ew.submitAction(event,jQuery.extend({key:" . $this->keyToJson(true) . "}," . $listaction->toJson(true) . "));\">" . $icon . $listaction->Caption . "</a>";
                    }
                }
            }
            if (count($links) > 1) { // More than one buttons, use dropdown
                $body = "<button class=\"dropdown-toggle btn btn-default ew-actions\" title=\"" . HtmlTitle($Language->phrase("ListActionButton")) . "\" data-toggle=\"dropdown\">" . $Language->phrase("ListActionButton") . "</button>";
                $content = "";
                foreach ($links as $link) {
                    $content .= "<li>" . $link . "</li>";
                }
                $body .= "<ul class=\"dropdown-menu" . ($opt->OnLeft ? "" : " dropdown-menu-right") . "\">" . $content . "</ul>";
                $body = "<div class=\"btn-group btn-group-sm\">" . $body . "</div>";
            }
            if (count($links) > 0) {
                $opt->Body = $body;
                $opt->Visible = true;
            }
        }

        // "checkbox"
        $opt = $this->ListOptions["checkbox"];
        $opt->Body = "<div class=\"custom-control custom-checkbox d-inline-block\"><input type=\"checkbox\" id=\"key_m_" . $this->RowCount . "\" name=\"key_m[]\" class=\"custom-control-input ew-multi-select\" value=\"" . HtmlEncode($this->ORG_UNIT_CODE->CurrentValue . Config("COMPOSITE_KEY_SEPARATOR") . $this->BILL_ID->CurrentValue) . "\" onclick=\"ew.clickMultiCheckbox(event);\"><label class=\"custom-control-label\" for=\"key_m_" . $this->RowCount . "\"></label></div>";
        $this->renderListOptionsExt();

        // Call ListOptions_Rendered event
        $this->listOptionsRendered();
    }

    // Set up other options
    protected function setupOtherOptions()
    {
        global $Language, $Security;
        $options = &$this->OtherOptions;
        $option = $options["addedit"];

        // Add
        $item = &$option->add("add");
        $addcaption = HtmlTitle($Language->phrase("AddLink"));
        $item->Body = "<a class=\"ew-add-edit ew-add\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . HtmlEncode(GetUrl($this->AddUrl)) . "\">" . $Language->phrase("AddLink") . "</a>";
        $item->Visible = $this->AddUrl != "";
        $option = $options["action"];

        // Set up options default
        foreach ($options as $option) {
            $option->UseDropDownButton = false;
            $option->UseButtonGroup = true;
            //$option->ButtonClass = ""; // Class for button group
            $item = &$option->add($option->GroupOptionName);
            $item->Body = "";
            $item->Visible = false;
        }
        $options["addedit"]->DropDownButtonPhrase = $Language->phrase("ButtonAddEdit");
        $options["detail"]->DropDownButtonPhrase = $Language->phrase("ButtonDetails");
        $options["action"]->DropDownButtonPhrase = $Language->phrase("ButtonActions");

        // Filter button
        $item = &$this->FilterOptions->add("savecurrentfilter");
        $item->Body = "<a class=\"ew-save-filter\" data-form=\"fTREATMENT_BILLTRANS1listsrch\" href=\"#\" onclick=\"return false;\">" . $Language->phrase("SaveCurrentFilter") . "</a>";
        $item->Visible = true;
        $item = &$this->FilterOptions->add("deletefilter");
        $item->Body = "<a class=\"ew-delete-filter\" data-form=\"fTREATMENT_BILLTRANS1listsrch\" href=\"#\" onclick=\"return false;\">" . $Language->phrase("DeleteFilter") . "</a>";
        $item->Visible = true;
        $this->FilterOptions->UseDropDownButton = true;
        $this->FilterOptions->UseButtonGroup = !$this->FilterOptions->UseDropDownButton;
        $this->FilterOptions->DropDownButtonPhrase = $Language->phrase("Filters");

        // Add group option item
        $item = &$this->FilterOptions->add($this->FilterOptions->GroupOptionName);
        $item->Body = "";
        $item->Visible = false;
    }

    // Render other options
    public function renderOtherOptions()
    {
        global $Language, $Security;
        $options = &$this->OtherOptions;
        $option = $options["action"];
        // Set up list action buttons
        foreach ($this->ListActions->Items as $listaction) {
            if ($listaction->Select == ACTION_MULTIPLE) {
                $item = &$option->add("custom_" . $listaction->Action);
                $caption = $listaction->Caption;
                $icon = ($listaction->Icon != "") ? '<i class="' . HtmlEncode($listaction->Icon) . '" data-caption="' . HtmlEncode($caption) . '"></i>' . $caption : $caption;
                $item->Body = '<a class="ew-action ew-list-action" title="' . HtmlEncode($caption) . '" data-caption="' . HtmlEncode($caption) . '" href="#" onclick="return ew.submitAction(event,jQuery.extend({f:document.fTREATMENT_BILLTRANS1list},' . $listaction->toJson(true) . '));">' . $icon . '</a>';
                $item->Visible = $listaction->Allow;
            }
        }

        // Hide grid edit and other options
        if ($this->TotalRecords <= 0) {
            $option = $options["addedit"];
            $item = $option["gridedit"];
            if ($item) {
                $item->Visible = false;
            }
            $option = $options["action"];
            $option->hideAllOptions();
        }
    }

    // Process list action
    protected function processListAction()
    {
        global $Language, $Security;
        $userlist = "";
        $user = "";
        $filter = $this->getFilterFromRecordKeys();
        $userAction = Post("useraction", "");
        if ($filter != "" && $userAction != "") {
            // Check permission first
            $actionCaption = $userAction;
            if (array_key_exists($userAction, $this->ListActions->Items)) {
                $actionCaption = $this->ListActions[$userAction]->Caption;
                if (!$this->ListActions[$userAction]->Allow) {
                    $errmsg = str_replace('%s', $actionCaption, $Language->phrase("CustomActionNotAllowed"));
                    if (Post("ajax") == $userAction) { // Ajax
                        echo "<p class=\"text-danger\">" . $errmsg . "</p>";
                        return true;
                    } else {
                        $this->setFailureMessage($errmsg);
                        return false;
                    }
                }
            }
            $this->CurrentFilter = $filter;
            $sql = $this->getCurrentSql();
            $conn = $this->getConnection();
            $rs = LoadRecordset($sql, $conn, \PDO::FETCH_ASSOC);
            $this->CurrentAction = $userAction;

            // Call row action event
            if ($rs) {
                $conn->beginTransaction();
                $this->SelectedCount = $rs->recordCount();
                $this->SelectedIndex = 0;
                while (!$rs->EOF) {
                    $this->SelectedIndex++;
                    $row = $rs->fields;
                    $processed = $this->rowCustomAction($userAction, $row);
                    if (!$processed) {
                        break;
                    }
                    $rs->moveNext();
                }
                if ($processed) {
                    $conn->commit(); // Commit the changes
                    if ($this->getSuccessMessage() == "" && !ob_get_length()) { // No output
                        $this->setSuccessMessage(str_replace('%s', $actionCaption, $Language->phrase("CustomActionCompleted"))); // Set up success message
                    }
                } else {
                    $conn->rollback(); // Rollback changes

                    // Set up error message
                    if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                        // Use the message, do nothing
                    } elseif ($this->CancelMessage != "") {
                        $this->setFailureMessage($this->CancelMessage);
                        $this->CancelMessage = "";
                    } else {
                        $this->setFailureMessage(str_replace('%s', $actionCaption, $Language->phrase("CustomActionFailed")));
                    }
                }
            }
            if ($rs) {
                $rs->close();
            }
            $this->CurrentAction = ""; // Clear action
            if (Post("ajax") == $userAction) { // Ajax
                if ($this->getSuccessMessage() != "") {
                    echo "<p class=\"text-success\">" . $this->getSuccessMessage() . "</p>";
                    $this->clearSuccessMessage(); // Clear message
                }
                if ($this->getFailureMessage() != "") {
                    echo "<p class=\"text-danger\">" . $this->getFailureMessage() . "</p>";
                    $this->clearFailureMessage(); // Clear message
                }
                return true;
            }
        }
        return false; // Not ajax request
    }

    // Set up list options (extended codes)
    protected function setupListOptionsExt()
    {
    }

    // Render list options (extended codes)
    protected function renderListOptionsExt()
    {
    }

    // Load basic search values
    protected function loadBasicSearchValues()
    {
        $this->BasicSearch->setKeyword(Get(Config("TABLE_BASIC_SEARCH"), ""), false);
        if ($this->BasicSearch->Keyword != "" && $this->Command == "") {
            $this->Command = "search";
        }
        $this->BasicSearch->setType(Get(Config("TABLE_BASIC_SEARCH_TYPE"), ""), false);
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
        $this->BILL_ID->setDbValue($row['BILL_ID']);
        $this->NO_REGISTRATION->setDbValue($row['NO_REGISTRATION']);
        $this->VISIT_ID->setDbValue($row['VISIT_ID']);
        $this->TARIF_ID->setDbValue($row['TARIF_ID']);
        $this->CLASS_ID->setDbValue($row['CLASS_ID']);
        $this->CLINIC_ID->setDbValue($row['CLINIC_ID']);
        $this->CLINIC_ID_FROM->setDbValue($row['CLINIC_ID_FROM']);
        $this->TREATMENT->setDbValue($row['TREATMENT']);
        $this->TREAT_DATE->setDbValue($row['TREAT_DATE']);
        $this->AMOUNT->setDbValue($row['AMOUNT']);
        $this->QUANTITY->setDbValue($row['QUANTITY']);
        $this->MEASURE_ID->setDbValue($row['MEASURE_ID']);
        $this->POKOK_JUAL->setDbValue($row['POKOK_JUAL']);
        $this->PPN->setDbValue($row['PPN']);
        $this->MARGIN->setDbValue($row['MARGIN']);
        $this->SUBSIDI->setDbValue($row['SUBSIDI']);
        $this->EMBALACE->setDbValue($row['EMBALACE']);
        $this->PROFESI->setDbValue($row['PROFESI']);
        $this->DISCOUNT->setDbValue($row['DISCOUNT']);
        $this->PAY_METHOD_ID->setDbValue($row['PAY_METHOD_ID']);
        $this->PAYMENT_DATE->setDbValue($row['PAYMENT_DATE']);
        $this->ISLUNAS->setDbValue($row['ISLUNAS']);
        $this->DUEDATE_ANGSURAN->setDbValue($row['DUEDATE_ANGSURAN']);
        $this->DESCRIPTION->setDbValue($row['DESCRIPTION']);
        $this->KUITANSI_ID->setDbValue($row['KUITANSI_ID']);
        $this->NOTA_NO->setDbValue($row['NOTA_NO']);
        $this->ISCETAK->setDbValue($row['ISCETAK']);
        $this->PRINT_DATE->setDbValue($row['PRINT_DATE']);
        $this->RESEP_NO->setDbValue($row['RESEP_NO']);
        $this->RESEP_KE->setDbValue($row['RESEP_KE']);
        $this->DOSE->setDbValue($row['DOSE']);
        $this->ORIG_DOSE->setDbValue($row['ORIG_DOSE']);
        $this->DOSE_PRESC->setDbValue($row['DOSE_PRESC']);
        $this->ITER->setDbValue($row['ITER']);
        $this->ITER_KE->setDbValue($row['ITER_KE']);
        $this->SOLD_STATUS->setDbValue($row['SOLD_STATUS']);
        $this->RACIKAN->setDbValue($row['RACIKAN']);
        $this->CLASS_ROOM_ID->setDbValue($row['CLASS_ROOM_ID']);
        $this->KELUAR_ID->setDbValue($row['KELUAR_ID']);
        $this->BED_ID->setDbValue($row['BED_ID']);
        $this->PERDA_ID->setDbValue($row['PERDA_ID']);
        $this->EMPLOYEE_ID->setDbValue($row['EMPLOYEE_ID']);
        $this->DESCRIPTION2->setDbValue($row['DESCRIPTION2']);
        $this->MODIFIED_BY->setDbValue($row['MODIFIED_BY']);
        $this->MODIFIED_DATE->setDbValue($row['MODIFIED_DATE']);
        $this->MODIFIED_FROM->setDbValue($row['MODIFIED_FROM']);
        $this->BRAND_ID->setDbValue($row['BRAND_ID']);
        $this->DOCTOR->setDbValue($row['DOCTOR']);
        $this->JML_BKS->setDbValue($row['JML_BKS']);
        $this->EXIT_DATE->setDbValue($row['EXIT_DATE']);
        $this->FA_V->setDbValue($row['FA_V']);
        $this->TASK_ID->setDbValue($row['TASK_ID']);
        $this->EMPLOYEE_ID_FROM->setDbValue($row['EMPLOYEE_ID_FROM']);
        $this->DOCTOR_FROM->setDbValue($row['DOCTOR_FROM']);
        $this->status_pasien_id->setDbValue($row['status_pasien_id']);
        $this->AMOUNT_PAID->setDbValue($row['AMOUNT_PAID']);
        $this->THENAME->setDbValue($row['THENAME']);
        $this->THEADDRESS->setDbValue($row['THEADDRESS']);
        $this->THEID->setDbValue($row['THEID']);
        $this->SERIAL_NB->setDbValue($row['SERIAL_NB']);
        $this->TREATMENT_PLAFOND->setDbValue($row['TREATMENT_PLAFOND']);
        $this->AMOUNT_PLAFOND->setDbValue($row['AMOUNT_PLAFOND']);
        $this->AMOUNT_PAID_PLAFOND->setDbValue($row['AMOUNT_PAID_PLAFOND']);
        $this->CLASS_ID_PLAFOND->setDbValue($row['CLASS_ID_PLAFOND']);
        $this->PAYOR_ID->setDbValue($row['PAYOR_ID']);
        $this->PEMBULATAN->setDbValue($row['PEMBULATAN']);
        $this->ISRJ->setDbValue($row['ISRJ']);
        $this->AGEYEAR->setDbValue($row['AGEYEAR']);
        $this->AGEMONTH->setDbValue($row['AGEMONTH']);
        $this->AGEDAY->setDbValue($row['AGEDAY']);
        $this->GENDER->setDbValue($row['GENDER']);
        $this->KAL_ID->setDbValue($row['KAL_ID']);
        $this->CORRECTION_ID->setDbValue($row['CORRECTION_ID']);
        $this->CORRECTION_BY->setDbValue($row['CORRECTION_BY']);
        $this->KARYAWAN->setDbValue($row['KARYAWAN']);
        $this->ACCOUNT_ID->setDbValue($row['ACCOUNT_ID']);
        $this->sell_price->setDbValue($row['sell_price']);
        $this->diskon->setDbValue($row['diskon']);
        $this->INVOICE_ID->setDbValue($row['INVOICE_ID']);
        $this->NUMER->setDbValue($row['NUMER']);
        $this->MEASURE_ID2->setDbValue($row['MEASURE_ID2']);
        $this->POTONGAN->setDbValue($row['POTONGAN']);
        $this->BAYAR->setDbValue($row['BAYAR']);
        $this->RETUR->setDbValue($row['RETUR']);
        $this->TARIF_TYPE->setDbValue($row['TARIF_TYPE']);
        $this->PPNVALUE->setDbValue($row['PPNVALUE']);
        $this->TAGIHAN->setDbValue($row['TAGIHAN']);
        $this->KOREKSI->setDbValue($row['KOREKSI']);
        $this->STATUS_OBAT->setDbValue($row['STATUS_OBAT']);
        $this->SUBSIDISAT->setDbValue($row['SUBSIDISAT']);
        $this->PRINTQ->setDbValue($row['PRINTQ']);
        $this->PRINTED_BY->setDbValue($row['PRINTED_BY']);
        $this->STOCK_AVAILABLE->setDbValue($row['STOCK_AVAILABLE']);
        $this->STATUS_TARIF->setDbValue($row['STATUS_TARIF']);
        $this->CLINIC_TYPE->setDbValue($row['CLINIC_TYPE']);
        $this->PACKAGE_ID->setDbValue($row['PACKAGE_ID']);
        $this->MODULE_ID->setDbValue($row['MODULE_ID']);
        $this->profession->setDbValue($row['profession']);
        $this->THEORDER->setDbValue($row['THEORDER']);
        $this->CASHIER->setDbValue($row['CASHIER']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['ORG_UNIT_CODE'] = null;
        $row['BILL_ID'] = null;
        $row['NO_REGISTRATION'] = null;
        $row['VISIT_ID'] = null;
        $row['TARIF_ID'] = null;
        $row['CLASS_ID'] = null;
        $row['CLINIC_ID'] = null;
        $row['CLINIC_ID_FROM'] = null;
        $row['TREATMENT'] = null;
        $row['TREAT_DATE'] = null;
        $row['AMOUNT'] = null;
        $row['QUANTITY'] = null;
        $row['MEASURE_ID'] = null;
        $row['POKOK_JUAL'] = null;
        $row['PPN'] = null;
        $row['MARGIN'] = null;
        $row['SUBSIDI'] = null;
        $row['EMBALACE'] = null;
        $row['PROFESI'] = null;
        $row['DISCOUNT'] = null;
        $row['PAY_METHOD_ID'] = null;
        $row['PAYMENT_DATE'] = null;
        $row['ISLUNAS'] = null;
        $row['DUEDATE_ANGSURAN'] = null;
        $row['DESCRIPTION'] = null;
        $row['KUITANSI_ID'] = null;
        $row['NOTA_NO'] = null;
        $row['ISCETAK'] = null;
        $row['PRINT_DATE'] = null;
        $row['RESEP_NO'] = null;
        $row['RESEP_KE'] = null;
        $row['DOSE'] = null;
        $row['ORIG_DOSE'] = null;
        $row['DOSE_PRESC'] = null;
        $row['ITER'] = null;
        $row['ITER_KE'] = null;
        $row['SOLD_STATUS'] = null;
        $row['RACIKAN'] = null;
        $row['CLASS_ROOM_ID'] = null;
        $row['KELUAR_ID'] = null;
        $row['BED_ID'] = null;
        $row['PERDA_ID'] = null;
        $row['EMPLOYEE_ID'] = null;
        $row['DESCRIPTION2'] = null;
        $row['MODIFIED_BY'] = null;
        $row['MODIFIED_DATE'] = null;
        $row['MODIFIED_FROM'] = null;
        $row['BRAND_ID'] = null;
        $row['DOCTOR'] = null;
        $row['JML_BKS'] = null;
        $row['EXIT_DATE'] = null;
        $row['FA_V'] = null;
        $row['TASK_ID'] = null;
        $row['EMPLOYEE_ID_FROM'] = null;
        $row['DOCTOR_FROM'] = null;
        $row['status_pasien_id'] = null;
        $row['AMOUNT_PAID'] = null;
        $row['THENAME'] = null;
        $row['THEADDRESS'] = null;
        $row['THEID'] = null;
        $row['SERIAL_NB'] = null;
        $row['TREATMENT_PLAFOND'] = null;
        $row['AMOUNT_PLAFOND'] = null;
        $row['AMOUNT_PAID_PLAFOND'] = null;
        $row['CLASS_ID_PLAFOND'] = null;
        $row['PAYOR_ID'] = null;
        $row['PEMBULATAN'] = null;
        $row['ISRJ'] = null;
        $row['AGEYEAR'] = null;
        $row['AGEMONTH'] = null;
        $row['AGEDAY'] = null;
        $row['GENDER'] = null;
        $row['KAL_ID'] = null;
        $row['CORRECTION_ID'] = null;
        $row['CORRECTION_BY'] = null;
        $row['KARYAWAN'] = null;
        $row['ACCOUNT_ID'] = null;
        $row['sell_price'] = null;
        $row['diskon'] = null;
        $row['INVOICE_ID'] = null;
        $row['NUMER'] = null;
        $row['MEASURE_ID2'] = null;
        $row['POTONGAN'] = null;
        $row['BAYAR'] = null;
        $row['RETUR'] = null;
        $row['TARIF_TYPE'] = null;
        $row['PPNVALUE'] = null;
        $row['TAGIHAN'] = null;
        $row['KOREKSI'] = null;
        $row['STATUS_OBAT'] = null;
        $row['SUBSIDISAT'] = null;
        $row['PRINTQ'] = null;
        $row['PRINTED_BY'] = null;
        $row['STOCK_AVAILABLE'] = null;
        $row['STATUS_TARIF'] = null;
        $row['CLINIC_TYPE'] = null;
        $row['PACKAGE_ID'] = null;
        $row['MODULE_ID'] = null;
        $row['profession'] = null;
        $row['THEORDER'] = null;
        $row['CASHIER'] = null;
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
        $this->ViewUrl = $this->getViewUrl();
        $this->EditUrl = $this->getEditUrl();
        $this->InlineEditUrl = $this->getInlineEditUrl();
        $this->CopyUrl = $this->getCopyUrl();
        $this->InlineCopyUrl = $this->getInlineCopyUrl();
        $this->DeleteUrl = $this->getDeleteUrl();

        // Convert decimal values if posted back
        if ($this->AMOUNT->FormValue == $this->AMOUNT->CurrentValue && is_numeric(ConvertToFloatString($this->AMOUNT->CurrentValue))) {
            $this->AMOUNT->CurrentValue = ConvertToFloatString($this->AMOUNT->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->QUANTITY->FormValue == $this->QUANTITY->CurrentValue && is_numeric(ConvertToFloatString($this->QUANTITY->CurrentValue))) {
            $this->QUANTITY->CurrentValue = ConvertToFloatString($this->QUANTITY->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->POKOK_JUAL->FormValue == $this->POKOK_JUAL->CurrentValue && is_numeric(ConvertToFloatString($this->POKOK_JUAL->CurrentValue))) {
            $this->POKOK_JUAL->CurrentValue = ConvertToFloatString($this->POKOK_JUAL->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->PPN->FormValue == $this->PPN->CurrentValue && is_numeric(ConvertToFloatString($this->PPN->CurrentValue))) {
            $this->PPN->CurrentValue = ConvertToFloatString($this->PPN->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->MARGIN->FormValue == $this->MARGIN->CurrentValue && is_numeric(ConvertToFloatString($this->MARGIN->CurrentValue))) {
            $this->MARGIN->CurrentValue = ConvertToFloatString($this->MARGIN->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->SUBSIDI->FormValue == $this->SUBSIDI->CurrentValue && is_numeric(ConvertToFloatString($this->SUBSIDI->CurrentValue))) {
            $this->SUBSIDI->CurrentValue = ConvertToFloatString($this->SUBSIDI->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->EMBALACE->FormValue == $this->EMBALACE->CurrentValue && is_numeric(ConvertToFloatString($this->EMBALACE->CurrentValue))) {
            $this->EMBALACE->CurrentValue = ConvertToFloatString($this->EMBALACE->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->PROFESI->FormValue == $this->PROFESI->CurrentValue && is_numeric(ConvertToFloatString($this->PROFESI->CurrentValue))) {
            $this->PROFESI->CurrentValue = ConvertToFloatString($this->PROFESI->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->DISCOUNT->FormValue == $this->DISCOUNT->CurrentValue && is_numeric(ConvertToFloatString($this->DISCOUNT->CurrentValue))) {
            $this->DISCOUNT->CurrentValue = ConvertToFloatString($this->DISCOUNT->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->DOSE->FormValue == $this->DOSE->CurrentValue && is_numeric(ConvertToFloatString($this->DOSE->CurrentValue))) {
            $this->DOSE->CurrentValue = ConvertToFloatString($this->DOSE->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->ORIG_DOSE->FormValue == $this->ORIG_DOSE->CurrentValue && is_numeric(ConvertToFloatString($this->ORIG_DOSE->CurrentValue))) {
            $this->ORIG_DOSE->CurrentValue = ConvertToFloatString($this->ORIG_DOSE->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->DOSE_PRESC->FormValue == $this->DOSE_PRESC->CurrentValue && is_numeric(ConvertToFloatString($this->DOSE_PRESC->CurrentValue))) {
            $this->DOSE_PRESC->CurrentValue = ConvertToFloatString($this->DOSE_PRESC->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->AMOUNT_PAID->FormValue == $this->AMOUNT_PAID->CurrentValue && is_numeric(ConvertToFloatString($this->AMOUNT_PAID->CurrentValue))) {
            $this->AMOUNT_PAID->CurrentValue = ConvertToFloatString($this->AMOUNT_PAID->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->AMOUNT_PLAFOND->FormValue == $this->AMOUNT_PLAFOND->CurrentValue && is_numeric(ConvertToFloatString($this->AMOUNT_PLAFOND->CurrentValue))) {
            $this->AMOUNT_PLAFOND->CurrentValue = ConvertToFloatString($this->AMOUNT_PLAFOND->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->AMOUNT_PAID_PLAFOND->FormValue == $this->AMOUNT_PAID_PLAFOND->CurrentValue && is_numeric(ConvertToFloatString($this->AMOUNT_PAID_PLAFOND->CurrentValue))) {
            $this->AMOUNT_PAID_PLAFOND->CurrentValue = ConvertToFloatString($this->AMOUNT_PAID_PLAFOND->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->PEMBULATAN->FormValue == $this->PEMBULATAN->CurrentValue && is_numeric(ConvertToFloatString($this->PEMBULATAN->CurrentValue))) {
            $this->PEMBULATAN->CurrentValue = ConvertToFloatString($this->PEMBULATAN->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->sell_price->FormValue == $this->sell_price->CurrentValue && is_numeric(ConvertToFloatString($this->sell_price->CurrentValue))) {
            $this->sell_price->CurrentValue = ConvertToFloatString($this->sell_price->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->diskon->FormValue == $this->diskon->CurrentValue && is_numeric(ConvertToFloatString($this->diskon->CurrentValue))) {
            $this->diskon->CurrentValue = ConvertToFloatString($this->diskon->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->POTONGAN->FormValue == $this->POTONGAN->CurrentValue && is_numeric(ConvertToFloatString($this->POTONGAN->CurrentValue))) {
            $this->POTONGAN->CurrentValue = ConvertToFloatString($this->POTONGAN->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->BAYAR->FormValue == $this->BAYAR->CurrentValue && is_numeric(ConvertToFloatString($this->BAYAR->CurrentValue))) {
            $this->BAYAR->CurrentValue = ConvertToFloatString($this->BAYAR->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->RETUR->FormValue == $this->RETUR->CurrentValue && is_numeric(ConvertToFloatString($this->RETUR->CurrentValue))) {
            $this->RETUR->CurrentValue = ConvertToFloatString($this->RETUR->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->PPNVALUE->FormValue == $this->PPNVALUE->CurrentValue && is_numeric(ConvertToFloatString($this->PPNVALUE->CurrentValue))) {
            $this->PPNVALUE->CurrentValue = ConvertToFloatString($this->PPNVALUE->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->TAGIHAN->FormValue == $this->TAGIHAN->CurrentValue && is_numeric(ConvertToFloatString($this->TAGIHAN->CurrentValue))) {
            $this->TAGIHAN->CurrentValue = ConvertToFloatString($this->TAGIHAN->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->KOREKSI->FormValue == $this->KOREKSI->CurrentValue && is_numeric(ConvertToFloatString($this->KOREKSI->CurrentValue))) {
            $this->KOREKSI->CurrentValue = ConvertToFloatString($this->KOREKSI->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->SUBSIDISAT->FormValue == $this->SUBSIDISAT->CurrentValue && is_numeric(ConvertToFloatString($this->SUBSIDISAT->CurrentValue))) {
            $this->SUBSIDISAT->CurrentValue = ConvertToFloatString($this->SUBSIDISAT->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->STOCK_AVAILABLE->FormValue == $this->STOCK_AVAILABLE->CurrentValue && is_numeric(ConvertToFloatString($this->STOCK_AVAILABLE->CurrentValue))) {
            $this->STOCK_AVAILABLE->CurrentValue = ConvertToFloatString($this->STOCK_AVAILABLE->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->profession->FormValue == $this->profession->CurrentValue && is_numeric(ConvertToFloatString($this->profession->CurrentValue))) {
            $this->profession->CurrentValue = ConvertToFloatString($this->profession->CurrentValue);
        }

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // ORG_UNIT_CODE

        // BILL_ID

        // NO_REGISTRATION

        // VISIT_ID

        // TARIF_ID

        // CLASS_ID

        // CLINIC_ID

        // CLINIC_ID_FROM

        // TREATMENT

        // TREAT_DATE

        // AMOUNT

        // QUANTITY

        // MEASURE_ID

        // POKOK_JUAL

        // PPN

        // MARGIN

        // SUBSIDI

        // EMBALACE

        // PROFESI

        // DISCOUNT

        // PAY_METHOD_ID

        // PAYMENT_DATE

        // ISLUNAS

        // DUEDATE_ANGSURAN

        // DESCRIPTION

        // KUITANSI_ID

        // NOTA_NO

        // ISCETAK

        // PRINT_DATE

        // RESEP_NO

        // RESEP_KE

        // DOSE

        // ORIG_DOSE

        // DOSE_PRESC

        // ITER

        // ITER_KE

        // SOLD_STATUS

        // RACIKAN

        // CLASS_ROOM_ID

        // KELUAR_ID

        // BED_ID

        // PERDA_ID

        // EMPLOYEE_ID

        // DESCRIPTION2

        // MODIFIED_BY

        // MODIFIED_DATE

        // MODIFIED_FROM

        // BRAND_ID

        // DOCTOR

        // JML_BKS

        // EXIT_DATE

        // FA_V

        // TASK_ID

        // EMPLOYEE_ID_FROM

        // DOCTOR_FROM

        // status_pasien_id

        // AMOUNT_PAID

        // THENAME

        // THEADDRESS

        // THEID

        // SERIAL_NB

        // TREATMENT_PLAFOND

        // AMOUNT_PLAFOND

        // AMOUNT_PAID_PLAFOND

        // CLASS_ID_PLAFOND

        // PAYOR_ID

        // PEMBULATAN

        // ISRJ

        // AGEYEAR

        // AGEMONTH

        // AGEDAY

        // GENDER

        // KAL_ID

        // CORRECTION_ID

        // CORRECTION_BY

        // KARYAWAN

        // ACCOUNT_ID

        // sell_price

        // diskon

        // INVOICE_ID

        // NUMER

        // MEASURE_ID2

        // POTONGAN

        // BAYAR

        // RETUR

        // TARIF_TYPE

        // PPNVALUE

        // TAGIHAN

        // KOREKSI

        // STATUS_OBAT

        // SUBSIDISAT

        // PRINTQ

        // PRINTED_BY

        // STOCK_AVAILABLE

        // STATUS_TARIF

        // CLINIC_TYPE

        // PACKAGE_ID

        // MODULE_ID

        // profession

        // THEORDER

        // CASHIER
        if ($this->RowType == ROWTYPE_VIEW) {
            // ORG_UNIT_CODE
            $this->ORG_UNIT_CODE->ViewValue = $this->ORG_UNIT_CODE->CurrentValue;
            $this->ORG_UNIT_CODE->ViewCustomAttributes = "";

            // BILL_ID
            $this->BILL_ID->ViewValue = $this->BILL_ID->CurrentValue;
            $this->BILL_ID->ViewCustomAttributes = "";

            // NO_REGISTRATION
            $this->NO_REGISTRATION->ViewValue = $this->NO_REGISTRATION->CurrentValue;
            $this->NO_REGISTRATION->ViewCustomAttributes = "";

            // VISIT_ID
            $this->VISIT_ID->ViewValue = $this->VISIT_ID->CurrentValue;
            $this->VISIT_ID->ViewCustomAttributes = "";

            // TARIF_ID
            $this->TARIF_ID->ViewValue = $this->TARIF_ID->CurrentValue;
            $this->TARIF_ID->ViewCustomAttributes = "";

            // CLASS_ID
            $this->CLASS_ID->ViewValue = $this->CLASS_ID->CurrentValue;
            $this->CLASS_ID->ViewValue = FormatNumber($this->CLASS_ID->ViewValue, 0, -2, -2, -2);
            $this->CLASS_ID->ViewCustomAttributes = "";

            // CLINIC_ID
            $this->CLINIC_ID->ViewValue = $this->CLINIC_ID->CurrentValue;
            $this->CLINIC_ID->ViewCustomAttributes = "";

            // CLINIC_ID_FROM
            $this->CLINIC_ID_FROM->ViewValue = $this->CLINIC_ID_FROM->CurrentValue;
            $this->CLINIC_ID_FROM->ViewCustomAttributes = "";

            // TREATMENT
            $this->TREATMENT->ViewValue = $this->TREATMENT->CurrentValue;
            $this->TREATMENT->ViewCustomAttributes = "";

            // TREAT_DATE
            $this->TREAT_DATE->ViewValue = $this->TREAT_DATE->CurrentValue;
            $this->TREAT_DATE->ViewValue = FormatDateTime($this->TREAT_DATE->ViewValue, 0);
            $this->TREAT_DATE->ViewCustomAttributes = "";

            // AMOUNT
            $this->AMOUNT->ViewValue = $this->AMOUNT->CurrentValue;
            $this->AMOUNT->ViewValue = FormatNumber($this->AMOUNT->ViewValue, 2, -2, -2, -2);
            $this->AMOUNT->ViewCustomAttributes = "";

            // QUANTITY
            $this->QUANTITY->ViewValue = $this->QUANTITY->CurrentValue;
            $this->QUANTITY->ViewValue = FormatNumber($this->QUANTITY->ViewValue, 2, -2, -2, -2);
            $this->QUANTITY->ViewCustomAttributes = "";

            // MEASURE_ID
            $this->MEASURE_ID->ViewValue = $this->MEASURE_ID->CurrentValue;
            $this->MEASURE_ID->ViewValue = FormatNumber($this->MEASURE_ID->ViewValue, 0, -2, -2, -2);
            $this->MEASURE_ID->ViewCustomAttributes = "";

            // POKOK_JUAL
            $this->POKOK_JUAL->ViewValue = $this->POKOK_JUAL->CurrentValue;
            $this->POKOK_JUAL->ViewValue = FormatNumber($this->POKOK_JUAL->ViewValue, 2, -2, -2, -2);
            $this->POKOK_JUAL->ViewCustomAttributes = "";

            // PPN
            $this->PPN->ViewValue = $this->PPN->CurrentValue;
            $this->PPN->ViewValue = FormatNumber($this->PPN->ViewValue, 2, -2, -2, -2);
            $this->PPN->ViewCustomAttributes = "";

            // MARGIN
            $this->MARGIN->ViewValue = $this->MARGIN->CurrentValue;
            $this->MARGIN->ViewValue = FormatNumber($this->MARGIN->ViewValue, 2, -2, -2, -2);
            $this->MARGIN->ViewCustomAttributes = "";

            // SUBSIDI
            $this->SUBSIDI->ViewValue = $this->SUBSIDI->CurrentValue;
            $this->SUBSIDI->ViewValue = FormatNumber($this->SUBSIDI->ViewValue, 2, -2, -2, -2);
            $this->SUBSIDI->ViewCustomAttributes = "";

            // EMBALACE
            $this->EMBALACE->ViewValue = $this->EMBALACE->CurrentValue;
            $this->EMBALACE->ViewValue = FormatNumber($this->EMBALACE->ViewValue, 2, -2, -2, -2);
            $this->EMBALACE->ViewCustomAttributes = "";

            // PROFESI
            $this->PROFESI->ViewValue = $this->PROFESI->CurrentValue;
            $this->PROFESI->ViewValue = FormatNumber($this->PROFESI->ViewValue, 2, -2, -2, -2);
            $this->PROFESI->ViewCustomAttributes = "";

            // DISCOUNT
            $this->DISCOUNT->ViewValue = $this->DISCOUNT->CurrentValue;
            $this->DISCOUNT->ViewValue = FormatNumber($this->DISCOUNT->ViewValue, 2, -2, -2, -2);
            $this->DISCOUNT->ViewCustomAttributes = "";

            // PAY_METHOD_ID
            $this->PAY_METHOD_ID->ViewValue = $this->PAY_METHOD_ID->CurrentValue;
            $this->PAY_METHOD_ID->ViewValue = FormatNumber($this->PAY_METHOD_ID->ViewValue, 0, -2, -2, -2);
            $this->PAY_METHOD_ID->ViewCustomAttributes = "";

            // PAYMENT_DATE
            $this->PAYMENT_DATE->ViewValue = $this->PAYMENT_DATE->CurrentValue;
            $this->PAYMENT_DATE->ViewValue = FormatDateTime($this->PAYMENT_DATE->ViewValue, 0);
            $this->PAYMENT_DATE->ViewCustomAttributes = "";

            // ISLUNAS
            $this->ISLUNAS->ViewValue = $this->ISLUNAS->CurrentValue;
            $this->ISLUNAS->ViewCustomAttributes = "";

            // DUEDATE_ANGSURAN
            $this->DUEDATE_ANGSURAN->ViewValue = $this->DUEDATE_ANGSURAN->CurrentValue;
            $this->DUEDATE_ANGSURAN->ViewValue = FormatDateTime($this->DUEDATE_ANGSURAN->ViewValue, 0);
            $this->DUEDATE_ANGSURAN->ViewCustomAttributes = "";

            // DESCRIPTION
            $this->DESCRIPTION->ViewValue = $this->DESCRIPTION->CurrentValue;
            $this->DESCRIPTION->ViewCustomAttributes = "";

            // KUITANSI_ID
            $this->KUITANSI_ID->ViewValue = $this->KUITANSI_ID->CurrentValue;
            $this->KUITANSI_ID->ViewCustomAttributes = "";

            // NOTA_NO
            $this->NOTA_NO->ViewValue = $this->NOTA_NO->CurrentValue;
            $this->NOTA_NO->ViewCustomAttributes = "";

            // ISCETAK
            $this->ISCETAK->ViewValue = $this->ISCETAK->CurrentValue;
            $this->ISCETAK->ViewCustomAttributes = "";

            // PRINT_DATE
            $this->PRINT_DATE->ViewValue = $this->PRINT_DATE->CurrentValue;
            $this->PRINT_DATE->ViewValue = FormatDateTime($this->PRINT_DATE->ViewValue, 0);
            $this->PRINT_DATE->ViewCustomAttributes = "";

            // RESEP_NO
            $this->RESEP_NO->ViewValue = $this->RESEP_NO->CurrentValue;
            $this->RESEP_NO->ViewCustomAttributes = "";

            // RESEP_KE
            $this->RESEP_KE->ViewValue = $this->RESEP_KE->CurrentValue;
            $this->RESEP_KE->ViewValue = FormatNumber($this->RESEP_KE->ViewValue, 0, -2, -2, -2);
            $this->RESEP_KE->ViewCustomAttributes = "";

            // DOSE
            $this->DOSE->ViewValue = $this->DOSE->CurrentValue;
            $this->DOSE->ViewValue = FormatNumber($this->DOSE->ViewValue, 2, -2, -2, -2);
            $this->DOSE->ViewCustomAttributes = "";

            // ORIG_DOSE
            $this->ORIG_DOSE->ViewValue = $this->ORIG_DOSE->CurrentValue;
            $this->ORIG_DOSE->ViewValue = FormatNumber($this->ORIG_DOSE->ViewValue, 2, -2, -2, -2);
            $this->ORIG_DOSE->ViewCustomAttributes = "";

            // DOSE_PRESC
            $this->DOSE_PRESC->ViewValue = $this->DOSE_PRESC->CurrentValue;
            $this->DOSE_PRESC->ViewValue = FormatNumber($this->DOSE_PRESC->ViewValue, 2, -2, -2, -2);
            $this->DOSE_PRESC->ViewCustomAttributes = "";

            // ITER
            $this->ITER->ViewValue = $this->ITER->CurrentValue;
            $this->ITER->ViewValue = FormatNumber($this->ITER->ViewValue, 0, -2, -2, -2);
            $this->ITER->ViewCustomAttributes = "";

            // ITER_KE
            $this->ITER_KE->ViewValue = $this->ITER_KE->CurrentValue;
            $this->ITER_KE->ViewValue = FormatNumber($this->ITER_KE->ViewValue, 0, -2, -2, -2);
            $this->ITER_KE->ViewCustomAttributes = "";

            // SOLD_STATUS
            $this->SOLD_STATUS->ViewValue = $this->SOLD_STATUS->CurrentValue;
            $this->SOLD_STATUS->ViewValue = FormatNumber($this->SOLD_STATUS->ViewValue, 0, -2, -2, -2);
            $this->SOLD_STATUS->ViewCustomAttributes = "";

            // RACIKAN
            $this->RACIKAN->ViewValue = $this->RACIKAN->CurrentValue;
            $this->RACIKAN->ViewValue = FormatNumber($this->RACIKAN->ViewValue, 0, -2, -2, -2);
            $this->RACIKAN->ViewCustomAttributes = "";

            // CLASS_ROOM_ID
            $this->CLASS_ROOM_ID->ViewValue = $this->CLASS_ROOM_ID->CurrentValue;
            $this->CLASS_ROOM_ID->ViewCustomAttributes = "";

            // KELUAR_ID
            $this->KELUAR_ID->ViewValue = $this->KELUAR_ID->CurrentValue;
            $this->KELUAR_ID->ViewValue = FormatNumber($this->KELUAR_ID->ViewValue, 0, -2, -2, -2);
            $this->KELUAR_ID->ViewCustomAttributes = "";

            // BED_ID
            $this->BED_ID->ViewValue = $this->BED_ID->CurrentValue;
            $this->BED_ID->ViewValue = FormatNumber($this->BED_ID->ViewValue, 0, -2, -2, -2);
            $this->BED_ID->ViewCustomAttributes = "";

            // PERDA_ID
            $this->PERDA_ID->ViewValue = $this->PERDA_ID->CurrentValue;
            $this->PERDA_ID->ViewValue = FormatNumber($this->PERDA_ID->ViewValue, 0, -2, -2, -2);
            $this->PERDA_ID->ViewCustomAttributes = "";

            // EMPLOYEE_ID
            $this->EMPLOYEE_ID->ViewValue = $this->EMPLOYEE_ID->CurrentValue;
            $this->EMPLOYEE_ID->ViewCustomAttributes = "";

            // DESCRIPTION2
            $this->DESCRIPTION2->ViewValue = $this->DESCRIPTION2->CurrentValue;
            $this->DESCRIPTION2->ViewCustomAttributes = "";

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

            // BRAND_ID
            $this->BRAND_ID->ViewValue = $this->BRAND_ID->CurrentValue;
            $this->BRAND_ID->ViewCustomAttributes = "";

            // DOCTOR
            $this->DOCTOR->ViewValue = $this->DOCTOR->CurrentValue;
            $this->DOCTOR->ViewCustomAttributes = "";

            // JML_BKS
            $this->JML_BKS->ViewValue = $this->JML_BKS->CurrentValue;
            $this->JML_BKS->ViewValue = FormatNumber($this->JML_BKS->ViewValue, 0, -2, -2, -2);
            $this->JML_BKS->ViewCustomAttributes = "";

            // EXIT_DATE
            $this->EXIT_DATE->ViewValue = $this->EXIT_DATE->CurrentValue;
            $this->EXIT_DATE->ViewValue = FormatDateTime($this->EXIT_DATE->ViewValue, 0);
            $this->EXIT_DATE->ViewCustomAttributes = "";

            // FA_V
            $this->FA_V->ViewValue = $this->FA_V->CurrentValue;
            $this->FA_V->ViewValue = FormatNumber($this->FA_V->ViewValue, 0, -2, -2, -2);
            $this->FA_V->ViewCustomAttributes = "";

            // TASK_ID
            $this->TASK_ID->ViewValue = $this->TASK_ID->CurrentValue;
            $this->TASK_ID->ViewValue = FormatNumber($this->TASK_ID->ViewValue, 0, -2, -2, -2);
            $this->TASK_ID->ViewCustomAttributes = "";

            // EMPLOYEE_ID_FROM
            $this->EMPLOYEE_ID_FROM->ViewValue = $this->EMPLOYEE_ID_FROM->CurrentValue;
            $this->EMPLOYEE_ID_FROM->ViewCustomAttributes = "";

            // DOCTOR_FROM
            $this->DOCTOR_FROM->ViewValue = $this->DOCTOR_FROM->CurrentValue;
            $this->DOCTOR_FROM->ViewCustomAttributes = "";

            // status_pasien_id
            $this->status_pasien_id->ViewValue = $this->status_pasien_id->CurrentValue;
            $this->status_pasien_id->ViewValue = FormatNumber($this->status_pasien_id->ViewValue, 0, -2, -2, -2);
            $this->status_pasien_id->ViewCustomAttributes = "";

            // AMOUNT_PAID
            $this->AMOUNT_PAID->ViewValue = $this->AMOUNT_PAID->CurrentValue;
            $this->AMOUNT_PAID->ViewValue = FormatNumber($this->AMOUNT_PAID->ViewValue, 2, -2, -2, -2);
            $this->AMOUNT_PAID->ViewCustomAttributes = "";

            // THENAME
            $this->THENAME->ViewValue = $this->THENAME->CurrentValue;
            $this->THENAME->ViewCustomAttributes = "";

            // THEADDRESS
            $this->THEADDRESS->ViewValue = $this->THEADDRESS->CurrentValue;
            $this->THEADDRESS->ViewCustomAttributes = "";

            // THEID
            $this->THEID->ViewValue = $this->THEID->CurrentValue;
            $this->THEID->ViewCustomAttributes = "";

            // SERIAL_NB
            $this->SERIAL_NB->ViewValue = $this->SERIAL_NB->CurrentValue;
            $this->SERIAL_NB->ViewCustomAttributes = "";

            // TREATMENT_PLAFOND
            $this->TREATMENT_PLAFOND->ViewValue = $this->TREATMENT_PLAFOND->CurrentValue;
            $this->TREATMENT_PLAFOND->ViewCustomAttributes = "";

            // AMOUNT_PLAFOND
            $this->AMOUNT_PLAFOND->ViewValue = $this->AMOUNT_PLAFOND->CurrentValue;
            $this->AMOUNT_PLAFOND->ViewValue = FormatNumber($this->AMOUNT_PLAFOND->ViewValue, 2, -2, -2, -2);
            $this->AMOUNT_PLAFOND->ViewCustomAttributes = "";

            // AMOUNT_PAID_PLAFOND
            $this->AMOUNT_PAID_PLAFOND->ViewValue = $this->AMOUNT_PAID_PLAFOND->CurrentValue;
            $this->AMOUNT_PAID_PLAFOND->ViewValue = FormatNumber($this->AMOUNT_PAID_PLAFOND->ViewValue, 2, -2, -2, -2);
            $this->AMOUNT_PAID_PLAFOND->ViewCustomAttributes = "";

            // CLASS_ID_PLAFOND
            $this->CLASS_ID_PLAFOND->ViewValue = $this->CLASS_ID_PLAFOND->CurrentValue;
            $this->CLASS_ID_PLAFOND->ViewValue = FormatNumber($this->CLASS_ID_PLAFOND->ViewValue, 0, -2, -2, -2);
            $this->CLASS_ID_PLAFOND->ViewCustomAttributes = "";

            // PAYOR_ID
            $this->PAYOR_ID->ViewValue = $this->PAYOR_ID->CurrentValue;
            $this->PAYOR_ID->ViewCustomAttributes = "";

            // PEMBULATAN
            $this->PEMBULATAN->ViewValue = $this->PEMBULATAN->CurrentValue;
            $this->PEMBULATAN->ViewValue = FormatNumber($this->PEMBULATAN->ViewValue, 2, -2, -2, -2);
            $this->PEMBULATAN->ViewCustomAttributes = "";

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

            // GENDER
            $this->GENDER->ViewValue = $this->GENDER->CurrentValue;
            $this->GENDER->ViewCustomAttributes = "";

            // KAL_ID
            $this->KAL_ID->ViewValue = $this->KAL_ID->CurrentValue;
            $this->KAL_ID->ViewCustomAttributes = "";

            // CORRECTION_ID
            $this->CORRECTION_ID->ViewValue = $this->CORRECTION_ID->CurrentValue;
            $this->CORRECTION_ID->ViewCustomAttributes = "";

            // CORRECTION_BY
            $this->CORRECTION_BY->ViewValue = $this->CORRECTION_BY->CurrentValue;
            $this->CORRECTION_BY->ViewCustomAttributes = "";

            // KARYAWAN
            $this->KARYAWAN->ViewValue = $this->KARYAWAN->CurrentValue;
            $this->KARYAWAN->ViewCustomAttributes = "";

            // ACCOUNT_ID
            $this->ACCOUNT_ID->ViewValue = $this->ACCOUNT_ID->CurrentValue;
            $this->ACCOUNT_ID->ViewCustomAttributes = "";

            // sell_price
            $this->sell_price->ViewValue = $this->sell_price->CurrentValue;
            $this->sell_price->ViewValue = FormatNumber($this->sell_price->ViewValue, 2, -2, -2, -2);
            $this->sell_price->ViewCustomAttributes = "";

            // diskon
            $this->diskon->ViewValue = $this->diskon->CurrentValue;
            $this->diskon->ViewValue = FormatNumber($this->diskon->ViewValue, 2, -2, -2, -2);
            $this->diskon->ViewCustomAttributes = "";

            // INVOICE_ID
            $this->INVOICE_ID->ViewValue = $this->INVOICE_ID->CurrentValue;
            $this->INVOICE_ID->ViewCustomAttributes = "";

            // NUMER
            $this->NUMER->ViewValue = $this->NUMER->CurrentValue;
            $this->NUMER->ViewCustomAttributes = "";

            // MEASURE_ID2
            $this->MEASURE_ID2->ViewValue = $this->MEASURE_ID2->CurrentValue;
            $this->MEASURE_ID2->ViewValue = FormatNumber($this->MEASURE_ID2->ViewValue, 0, -2, -2, -2);
            $this->MEASURE_ID2->ViewCustomAttributes = "";

            // POTONGAN
            $this->POTONGAN->ViewValue = $this->POTONGAN->CurrentValue;
            $this->POTONGAN->ViewValue = FormatNumber($this->POTONGAN->ViewValue, 2, -2, -2, -2);
            $this->POTONGAN->ViewCustomAttributes = "";

            // BAYAR
            $this->BAYAR->ViewValue = $this->BAYAR->CurrentValue;
            $this->BAYAR->ViewValue = FormatNumber($this->BAYAR->ViewValue, 2, -2, -2, -2);
            $this->BAYAR->ViewCustomAttributes = "";

            // RETUR
            $this->RETUR->ViewValue = $this->RETUR->CurrentValue;
            $this->RETUR->ViewValue = FormatNumber($this->RETUR->ViewValue, 2, -2, -2, -2);
            $this->RETUR->ViewCustomAttributes = "";

            // TARIF_TYPE
            $this->TARIF_TYPE->ViewValue = $this->TARIF_TYPE->CurrentValue;
            $this->TARIF_TYPE->ViewCustomAttributes = "";

            // PPNVALUE
            $this->PPNVALUE->ViewValue = $this->PPNVALUE->CurrentValue;
            $this->PPNVALUE->ViewValue = FormatNumber($this->PPNVALUE->ViewValue, 2, -2, -2, -2);
            $this->PPNVALUE->ViewCustomAttributes = "";

            // TAGIHAN
            $this->TAGIHAN->ViewValue = $this->TAGIHAN->CurrentValue;
            $this->TAGIHAN->ViewValue = FormatNumber($this->TAGIHAN->ViewValue, 2, -2, -2, -2);
            $this->TAGIHAN->ViewCustomAttributes = "";

            // KOREKSI
            $this->KOREKSI->ViewValue = $this->KOREKSI->CurrentValue;
            $this->KOREKSI->ViewValue = FormatNumber($this->KOREKSI->ViewValue, 2, -2, -2, -2);
            $this->KOREKSI->ViewCustomAttributes = "";

            // STATUS_OBAT
            $this->STATUS_OBAT->ViewValue = $this->STATUS_OBAT->CurrentValue;
            $this->STATUS_OBAT->ViewValue = FormatNumber($this->STATUS_OBAT->ViewValue, 0, -2, -2, -2);
            $this->STATUS_OBAT->ViewCustomAttributes = "";

            // SUBSIDISAT
            $this->SUBSIDISAT->ViewValue = $this->SUBSIDISAT->CurrentValue;
            $this->SUBSIDISAT->ViewValue = FormatNumber($this->SUBSIDISAT->ViewValue, 2, -2, -2, -2);
            $this->SUBSIDISAT->ViewCustomAttributes = "";

            // PRINTQ
            $this->PRINTQ->ViewValue = $this->PRINTQ->CurrentValue;
            $this->PRINTQ->ViewValue = FormatNumber($this->PRINTQ->ViewValue, 0, -2, -2, -2);
            $this->PRINTQ->ViewCustomAttributes = "";

            // PRINTED_BY
            $this->PRINTED_BY->ViewValue = $this->PRINTED_BY->CurrentValue;
            $this->PRINTED_BY->ViewCustomAttributes = "";

            // STOCK_AVAILABLE
            $this->STOCK_AVAILABLE->ViewValue = $this->STOCK_AVAILABLE->CurrentValue;
            $this->STOCK_AVAILABLE->ViewValue = FormatNumber($this->STOCK_AVAILABLE->ViewValue, 2, -2, -2, -2);
            $this->STOCK_AVAILABLE->ViewCustomAttributes = "";

            // STATUS_TARIF
            $this->STATUS_TARIF->ViewValue = $this->STATUS_TARIF->CurrentValue;
            $this->STATUS_TARIF->ViewValue = FormatNumber($this->STATUS_TARIF->ViewValue, 0, -2, -2, -2);
            $this->STATUS_TARIF->ViewCustomAttributes = "";

            // CLINIC_TYPE
            $this->CLINIC_TYPE->ViewValue = $this->CLINIC_TYPE->CurrentValue;
            $this->CLINIC_TYPE->ViewValue = FormatNumber($this->CLINIC_TYPE->ViewValue, 0, -2, -2, -2);
            $this->CLINIC_TYPE->ViewCustomAttributes = "";

            // PACKAGE_ID
            $this->PACKAGE_ID->ViewValue = $this->PACKAGE_ID->CurrentValue;
            $this->PACKAGE_ID->ViewCustomAttributes = "";

            // MODULE_ID
            $this->MODULE_ID->ViewValue = $this->MODULE_ID->CurrentValue;
            $this->MODULE_ID->ViewCustomAttributes = "";

            // profession
            $this->profession->ViewValue = $this->profession->CurrentValue;
            $this->profession->ViewValue = FormatNumber($this->profession->ViewValue, 2, -2, -2, -2);
            $this->profession->ViewCustomAttributes = "";

            // THEORDER
            $this->THEORDER->ViewValue = $this->THEORDER->CurrentValue;
            $this->THEORDER->ViewValue = FormatNumber($this->THEORDER->ViewValue, 0, -2, -2, -2);
            $this->THEORDER->ViewCustomAttributes = "";

            // CASHIER
            $this->CASHIER->ViewValue = $this->CASHIER->CurrentValue;
            $this->CASHIER->ViewCustomAttributes = "";

            // ORG_UNIT_CODE
            $this->ORG_UNIT_CODE->LinkCustomAttributes = "";
            $this->ORG_UNIT_CODE->HrefValue = "";
            $this->ORG_UNIT_CODE->TooltipValue = "";

            // BILL_ID
            $this->BILL_ID->LinkCustomAttributes = "";
            $this->BILL_ID->HrefValue = "";
            $this->BILL_ID->TooltipValue = "";

            // NO_REGISTRATION
            $this->NO_REGISTRATION->LinkCustomAttributes = "";
            $this->NO_REGISTRATION->HrefValue = "";
            $this->NO_REGISTRATION->TooltipValue = "";

            // VISIT_ID
            $this->VISIT_ID->LinkCustomAttributes = "";
            $this->VISIT_ID->HrefValue = "";
            $this->VISIT_ID->TooltipValue = "";

            // TARIF_ID
            $this->TARIF_ID->LinkCustomAttributes = "";
            $this->TARIF_ID->HrefValue = "";
            $this->TARIF_ID->TooltipValue = "";

            // CLASS_ID
            $this->CLASS_ID->LinkCustomAttributes = "";
            $this->CLASS_ID->HrefValue = "";
            $this->CLASS_ID->TooltipValue = "";

            // CLINIC_ID
            $this->CLINIC_ID->LinkCustomAttributes = "";
            $this->CLINIC_ID->HrefValue = "";
            $this->CLINIC_ID->TooltipValue = "";

            // CLINIC_ID_FROM
            $this->CLINIC_ID_FROM->LinkCustomAttributes = "";
            $this->CLINIC_ID_FROM->HrefValue = "";
            $this->CLINIC_ID_FROM->TooltipValue = "";

            // TREATMENT
            $this->TREATMENT->LinkCustomAttributes = "";
            $this->TREATMENT->HrefValue = "";
            $this->TREATMENT->TooltipValue = "";

            // TREAT_DATE
            $this->TREAT_DATE->LinkCustomAttributes = "";
            $this->TREAT_DATE->HrefValue = "";
            $this->TREAT_DATE->TooltipValue = "";

            // AMOUNT
            $this->AMOUNT->LinkCustomAttributes = "";
            $this->AMOUNT->HrefValue = "";
            $this->AMOUNT->TooltipValue = "";

            // QUANTITY
            $this->QUANTITY->LinkCustomAttributes = "";
            $this->QUANTITY->HrefValue = "";
            $this->QUANTITY->TooltipValue = "";

            // MEASURE_ID
            $this->MEASURE_ID->LinkCustomAttributes = "";
            $this->MEASURE_ID->HrefValue = "";
            $this->MEASURE_ID->TooltipValue = "";

            // POKOK_JUAL
            $this->POKOK_JUAL->LinkCustomAttributes = "";
            $this->POKOK_JUAL->HrefValue = "";
            $this->POKOK_JUAL->TooltipValue = "";

            // PPN
            $this->PPN->LinkCustomAttributes = "";
            $this->PPN->HrefValue = "";
            $this->PPN->TooltipValue = "";

            // MARGIN
            $this->MARGIN->LinkCustomAttributes = "";
            $this->MARGIN->HrefValue = "";
            $this->MARGIN->TooltipValue = "";

            // SUBSIDI
            $this->SUBSIDI->LinkCustomAttributes = "";
            $this->SUBSIDI->HrefValue = "";
            $this->SUBSIDI->TooltipValue = "";

            // EMBALACE
            $this->EMBALACE->LinkCustomAttributes = "";
            $this->EMBALACE->HrefValue = "";
            $this->EMBALACE->TooltipValue = "";

            // PROFESI
            $this->PROFESI->LinkCustomAttributes = "";
            $this->PROFESI->HrefValue = "";
            $this->PROFESI->TooltipValue = "";

            // DISCOUNT
            $this->DISCOUNT->LinkCustomAttributes = "";
            $this->DISCOUNT->HrefValue = "";
            $this->DISCOUNT->TooltipValue = "";

            // PAY_METHOD_ID
            $this->PAY_METHOD_ID->LinkCustomAttributes = "";
            $this->PAY_METHOD_ID->HrefValue = "";
            $this->PAY_METHOD_ID->TooltipValue = "";

            // PAYMENT_DATE
            $this->PAYMENT_DATE->LinkCustomAttributes = "";
            $this->PAYMENT_DATE->HrefValue = "";
            $this->PAYMENT_DATE->TooltipValue = "";

            // ISLUNAS
            $this->ISLUNAS->LinkCustomAttributes = "";
            $this->ISLUNAS->HrefValue = "";
            $this->ISLUNAS->TooltipValue = "";

            // DUEDATE_ANGSURAN
            $this->DUEDATE_ANGSURAN->LinkCustomAttributes = "";
            $this->DUEDATE_ANGSURAN->HrefValue = "";
            $this->DUEDATE_ANGSURAN->TooltipValue = "";

            // DESCRIPTION
            $this->DESCRIPTION->LinkCustomAttributes = "";
            $this->DESCRIPTION->HrefValue = "";
            $this->DESCRIPTION->TooltipValue = "";

            // KUITANSI_ID
            $this->KUITANSI_ID->LinkCustomAttributes = "";
            $this->KUITANSI_ID->HrefValue = "";
            $this->KUITANSI_ID->TooltipValue = "";

            // NOTA_NO
            $this->NOTA_NO->LinkCustomAttributes = "";
            $this->NOTA_NO->HrefValue = "";
            $this->NOTA_NO->TooltipValue = "";

            // ISCETAK
            $this->ISCETAK->LinkCustomAttributes = "";
            $this->ISCETAK->HrefValue = "";
            $this->ISCETAK->TooltipValue = "";

            // PRINT_DATE
            $this->PRINT_DATE->LinkCustomAttributes = "";
            $this->PRINT_DATE->HrefValue = "";
            $this->PRINT_DATE->TooltipValue = "";

            // RESEP_NO
            $this->RESEP_NO->LinkCustomAttributes = "";
            $this->RESEP_NO->HrefValue = "";
            $this->RESEP_NO->TooltipValue = "";

            // RESEP_KE
            $this->RESEP_KE->LinkCustomAttributes = "";
            $this->RESEP_KE->HrefValue = "";
            $this->RESEP_KE->TooltipValue = "";

            // DOSE
            $this->DOSE->LinkCustomAttributes = "";
            $this->DOSE->HrefValue = "";
            $this->DOSE->TooltipValue = "";

            // ORIG_DOSE
            $this->ORIG_DOSE->LinkCustomAttributes = "";
            $this->ORIG_DOSE->HrefValue = "";
            $this->ORIG_DOSE->TooltipValue = "";

            // DOSE_PRESC
            $this->DOSE_PRESC->LinkCustomAttributes = "";
            $this->DOSE_PRESC->HrefValue = "";
            $this->DOSE_PRESC->TooltipValue = "";

            // ITER
            $this->ITER->LinkCustomAttributes = "";
            $this->ITER->HrefValue = "";
            $this->ITER->TooltipValue = "";

            // ITER_KE
            $this->ITER_KE->LinkCustomAttributes = "";
            $this->ITER_KE->HrefValue = "";
            $this->ITER_KE->TooltipValue = "";

            // SOLD_STATUS
            $this->SOLD_STATUS->LinkCustomAttributes = "";
            $this->SOLD_STATUS->HrefValue = "";
            $this->SOLD_STATUS->TooltipValue = "";

            // RACIKAN
            $this->RACIKAN->LinkCustomAttributes = "";
            $this->RACIKAN->HrefValue = "";
            $this->RACIKAN->TooltipValue = "";

            // CLASS_ROOM_ID
            $this->CLASS_ROOM_ID->LinkCustomAttributes = "";
            $this->CLASS_ROOM_ID->HrefValue = "";
            $this->CLASS_ROOM_ID->TooltipValue = "";

            // KELUAR_ID
            $this->KELUAR_ID->LinkCustomAttributes = "";
            $this->KELUAR_ID->HrefValue = "";
            $this->KELUAR_ID->TooltipValue = "";

            // BED_ID
            $this->BED_ID->LinkCustomAttributes = "";
            $this->BED_ID->HrefValue = "";
            $this->BED_ID->TooltipValue = "";

            // PERDA_ID
            $this->PERDA_ID->LinkCustomAttributes = "";
            $this->PERDA_ID->HrefValue = "";
            $this->PERDA_ID->TooltipValue = "";

            // EMPLOYEE_ID
            $this->EMPLOYEE_ID->LinkCustomAttributes = "";
            $this->EMPLOYEE_ID->HrefValue = "";
            $this->EMPLOYEE_ID->TooltipValue = "";

            // DESCRIPTION2
            $this->DESCRIPTION2->LinkCustomAttributes = "";
            $this->DESCRIPTION2->HrefValue = "";
            $this->DESCRIPTION2->TooltipValue = "";

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

            // BRAND_ID
            $this->BRAND_ID->LinkCustomAttributes = "";
            $this->BRAND_ID->HrefValue = "";
            $this->BRAND_ID->TooltipValue = "";

            // DOCTOR
            $this->DOCTOR->LinkCustomAttributes = "";
            $this->DOCTOR->HrefValue = "";
            $this->DOCTOR->TooltipValue = "";

            // JML_BKS
            $this->JML_BKS->LinkCustomAttributes = "";
            $this->JML_BKS->HrefValue = "";
            $this->JML_BKS->TooltipValue = "";

            // EXIT_DATE
            $this->EXIT_DATE->LinkCustomAttributes = "";
            $this->EXIT_DATE->HrefValue = "";
            $this->EXIT_DATE->TooltipValue = "";

            // FA_V
            $this->FA_V->LinkCustomAttributes = "";
            $this->FA_V->HrefValue = "";
            $this->FA_V->TooltipValue = "";

            // TASK_ID
            $this->TASK_ID->LinkCustomAttributes = "";
            $this->TASK_ID->HrefValue = "";
            $this->TASK_ID->TooltipValue = "";

            // EMPLOYEE_ID_FROM
            $this->EMPLOYEE_ID_FROM->LinkCustomAttributes = "";
            $this->EMPLOYEE_ID_FROM->HrefValue = "";
            $this->EMPLOYEE_ID_FROM->TooltipValue = "";

            // DOCTOR_FROM
            $this->DOCTOR_FROM->LinkCustomAttributes = "";
            $this->DOCTOR_FROM->HrefValue = "";
            $this->DOCTOR_FROM->TooltipValue = "";

            // status_pasien_id
            $this->status_pasien_id->LinkCustomAttributes = "";
            $this->status_pasien_id->HrefValue = "";
            $this->status_pasien_id->TooltipValue = "";

            // AMOUNT_PAID
            $this->AMOUNT_PAID->LinkCustomAttributes = "";
            $this->AMOUNT_PAID->HrefValue = "";
            $this->AMOUNT_PAID->TooltipValue = "";

            // THENAME
            $this->THENAME->LinkCustomAttributes = "";
            $this->THENAME->HrefValue = "";
            $this->THENAME->TooltipValue = "";

            // THEADDRESS
            $this->THEADDRESS->LinkCustomAttributes = "";
            $this->THEADDRESS->HrefValue = "";
            $this->THEADDRESS->TooltipValue = "";

            // THEID
            $this->THEID->LinkCustomAttributes = "";
            $this->THEID->HrefValue = "";
            $this->THEID->TooltipValue = "";

            // SERIAL_NB
            $this->SERIAL_NB->LinkCustomAttributes = "";
            $this->SERIAL_NB->HrefValue = "";
            $this->SERIAL_NB->TooltipValue = "";

            // TREATMENT_PLAFOND
            $this->TREATMENT_PLAFOND->LinkCustomAttributes = "";
            $this->TREATMENT_PLAFOND->HrefValue = "";
            $this->TREATMENT_PLAFOND->TooltipValue = "";

            // AMOUNT_PLAFOND
            $this->AMOUNT_PLAFOND->LinkCustomAttributes = "";
            $this->AMOUNT_PLAFOND->HrefValue = "";
            $this->AMOUNT_PLAFOND->TooltipValue = "";

            // AMOUNT_PAID_PLAFOND
            $this->AMOUNT_PAID_PLAFOND->LinkCustomAttributes = "";
            $this->AMOUNT_PAID_PLAFOND->HrefValue = "";
            $this->AMOUNT_PAID_PLAFOND->TooltipValue = "";

            // CLASS_ID_PLAFOND
            $this->CLASS_ID_PLAFOND->LinkCustomAttributes = "";
            $this->CLASS_ID_PLAFOND->HrefValue = "";
            $this->CLASS_ID_PLAFOND->TooltipValue = "";

            // PAYOR_ID
            $this->PAYOR_ID->LinkCustomAttributes = "";
            $this->PAYOR_ID->HrefValue = "";
            $this->PAYOR_ID->TooltipValue = "";

            // PEMBULATAN
            $this->PEMBULATAN->LinkCustomAttributes = "";
            $this->PEMBULATAN->HrefValue = "";
            $this->PEMBULATAN->TooltipValue = "";

            // ISRJ
            $this->ISRJ->LinkCustomAttributes = "";
            $this->ISRJ->HrefValue = "";
            $this->ISRJ->TooltipValue = "";

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

            // GENDER
            $this->GENDER->LinkCustomAttributes = "";
            $this->GENDER->HrefValue = "";
            $this->GENDER->TooltipValue = "";

            // KAL_ID
            $this->KAL_ID->LinkCustomAttributes = "";
            $this->KAL_ID->HrefValue = "";
            $this->KAL_ID->TooltipValue = "";

            // CORRECTION_ID
            $this->CORRECTION_ID->LinkCustomAttributes = "";
            $this->CORRECTION_ID->HrefValue = "";
            $this->CORRECTION_ID->TooltipValue = "";

            // CORRECTION_BY
            $this->CORRECTION_BY->LinkCustomAttributes = "";
            $this->CORRECTION_BY->HrefValue = "";
            $this->CORRECTION_BY->TooltipValue = "";

            // KARYAWAN
            $this->KARYAWAN->LinkCustomAttributes = "";
            $this->KARYAWAN->HrefValue = "";
            $this->KARYAWAN->TooltipValue = "";

            // ACCOUNT_ID
            $this->ACCOUNT_ID->LinkCustomAttributes = "";
            $this->ACCOUNT_ID->HrefValue = "";
            $this->ACCOUNT_ID->TooltipValue = "";

            // sell_price
            $this->sell_price->LinkCustomAttributes = "";
            $this->sell_price->HrefValue = "";
            $this->sell_price->TooltipValue = "";

            // diskon
            $this->diskon->LinkCustomAttributes = "";
            $this->diskon->HrefValue = "";
            $this->diskon->TooltipValue = "";

            // INVOICE_ID
            $this->INVOICE_ID->LinkCustomAttributes = "";
            $this->INVOICE_ID->HrefValue = "";
            $this->INVOICE_ID->TooltipValue = "";

            // NUMER
            $this->NUMER->LinkCustomAttributes = "";
            $this->NUMER->HrefValue = "";
            $this->NUMER->TooltipValue = "";

            // MEASURE_ID2
            $this->MEASURE_ID2->LinkCustomAttributes = "";
            $this->MEASURE_ID2->HrefValue = "";
            $this->MEASURE_ID2->TooltipValue = "";

            // POTONGAN
            $this->POTONGAN->LinkCustomAttributes = "";
            $this->POTONGAN->HrefValue = "";
            $this->POTONGAN->TooltipValue = "";

            // BAYAR
            $this->BAYAR->LinkCustomAttributes = "";
            $this->BAYAR->HrefValue = "";
            $this->BAYAR->TooltipValue = "";

            // RETUR
            $this->RETUR->LinkCustomAttributes = "";
            $this->RETUR->HrefValue = "";
            $this->RETUR->TooltipValue = "";

            // TARIF_TYPE
            $this->TARIF_TYPE->LinkCustomAttributes = "";
            $this->TARIF_TYPE->HrefValue = "";
            $this->TARIF_TYPE->TooltipValue = "";

            // PPNVALUE
            $this->PPNVALUE->LinkCustomAttributes = "";
            $this->PPNVALUE->HrefValue = "";
            $this->PPNVALUE->TooltipValue = "";

            // TAGIHAN
            $this->TAGIHAN->LinkCustomAttributes = "";
            $this->TAGIHAN->HrefValue = "";
            $this->TAGIHAN->TooltipValue = "";

            // KOREKSI
            $this->KOREKSI->LinkCustomAttributes = "";
            $this->KOREKSI->HrefValue = "";
            $this->KOREKSI->TooltipValue = "";

            // STATUS_OBAT
            $this->STATUS_OBAT->LinkCustomAttributes = "";
            $this->STATUS_OBAT->HrefValue = "";
            $this->STATUS_OBAT->TooltipValue = "";

            // SUBSIDISAT
            $this->SUBSIDISAT->LinkCustomAttributes = "";
            $this->SUBSIDISAT->HrefValue = "";
            $this->SUBSIDISAT->TooltipValue = "";

            // PRINTQ
            $this->PRINTQ->LinkCustomAttributes = "";
            $this->PRINTQ->HrefValue = "";
            $this->PRINTQ->TooltipValue = "";

            // PRINTED_BY
            $this->PRINTED_BY->LinkCustomAttributes = "";
            $this->PRINTED_BY->HrefValue = "";
            $this->PRINTED_BY->TooltipValue = "";

            // STOCK_AVAILABLE
            $this->STOCK_AVAILABLE->LinkCustomAttributes = "";
            $this->STOCK_AVAILABLE->HrefValue = "";
            $this->STOCK_AVAILABLE->TooltipValue = "";

            // STATUS_TARIF
            $this->STATUS_TARIF->LinkCustomAttributes = "";
            $this->STATUS_TARIF->HrefValue = "";
            $this->STATUS_TARIF->TooltipValue = "";

            // CLINIC_TYPE
            $this->CLINIC_TYPE->LinkCustomAttributes = "";
            $this->CLINIC_TYPE->HrefValue = "";
            $this->CLINIC_TYPE->TooltipValue = "";

            // PACKAGE_ID
            $this->PACKAGE_ID->LinkCustomAttributes = "";
            $this->PACKAGE_ID->HrefValue = "";
            $this->PACKAGE_ID->TooltipValue = "";

            // MODULE_ID
            $this->MODULE_ID->LinkCustomAttributes = "";
            $this->MODULE_ID->HrefValue = "";
            $this->MODULE_ID->TooltipValue = "";

            // profession
            $this->profession->LinkCustomAttributes = "";
            $this->profession->HrefValue = "";
            $this->profession->TooltipValue = "";

            // THEORDER
            $this->THEORDER->LinkCustomAttributes = "";
            $this->THEORDER->HrefValue = "";
            $this->THEORDER->TooltipValue = "";

            // CASHIER
            $this->CASHIER->LinkCustomAttributes = "";
            $this->CASHIER->HrefValue = "";
            $this->CASHIER->TooltipValue = "";
        }

        // Call Row Rendered event
        if ($this->RowType != ROWTYPE_AGGREGATEINIT) {
            $this->rowRendered();
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
        $item->Body = "<a class=\"btn btn-default ew-search-toggle" . $searchToggleClass . "\" href=\"#\" role=\"button\" title=\"" . $Language->phrase("SearchPanel") . "\" data-caption=\"" . $Language->phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fTREATMENT_BILLTRANS1listsrch\" aria-pressed=\"" . ($searchToggleClass == " active" ? "true" : "false") . "\">" . $Language->phrase("SearchLink") . "</a>";
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
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset / cmd=resetall
        $Breadcrumb->add("list", $this->TableVar, $url, "", $this->TableVar, true);
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

    // ListOptions Load event
    public function listOptionsLoad()
    {
        // Example:
        //$opt = &$this->ListOptions->Add("new");
        //$opt->Header = "xxx";
        //$opt->OnLeft = true; // Link on left
        //$opt->MoveTo(0); // Move to first column
    }

    // ListOptions Rendering event
    public function listOptionsRendering()
    {
        //Container("DetailTableGrid")->DetailAdd = (...condition...); // Set to true or false conditionally
        //Container("DetailTableGrid")->DetailEdit = (...condition...); // Set to true or false conditionally
        //Container("DetailTableGrid")->DetailView = (...condition...); // Set to true or false conditionally
    }

    // ListOptions Rendered event
    public function listOptionsRendered()
    {
        // Example:
        //$this->ListOptions["new"]->Body = "xxx";
    }

    // Row Custom Action event
    public function rowCustomAction($action, $row)
    {
        // Return false to abort
        return true;
    }

    // Page Exporting event
    // $this->ExportDoc = export document object
    public function pageExporting()
    {
        //$this->ExportDoc->Text = "my header"; // Export header
        //return false; // Return false to skip default export and use Row_Export event
        return true; // Return true to use default export and skip Row_Export event
    }

    // Row Export event
    // $this->ExportDoc = export document object
    public function rowExport($rs)
    {
        //$this->ExportDoc->Text .= "my content"; // Build HTML with field value: $rs["MyField"] or $this->MyField->ViewValue
    }

    // Page Exported event
    // $this->ExportDoc = export document object
    public function pageExported()
    {
        //$this->ExportDoc->Text .= "my footer"; // Export footer
        //Log($this->ExportDoc->Text);
    }

    // Page Importing event
    public function pageImporting($reader, &$options)
    {
        //var_dump($reader); // Import data reader
        //var_dump($options); // Show all options for importing
        //return false; // Return false to skip import
        return true;
    }

    // Row Import event
    public function rowImport(&$row, $cnt)
    {
        //Log($cnt); // Import record count
        //var_dump($row); // Import row
        //return false; // Return false to skip import
        return true;
    }

    // Page Imported event
    public function pageImported($reader, $results)
    {
        //var_dump($reader); // Import data reader
        //var_dump($results); // Import results
    }
}
