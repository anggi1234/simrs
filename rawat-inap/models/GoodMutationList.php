<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class GoodMutationList extends GoodMutation
{
    use MessagesTrait;

    // Page ID
    public $PageID = "list";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'GOOD_MUTATION';

    // Page object name
    public $PageObjName = "GoodMutationList";

    // Rendering View
    public $RenderingView = false;

    // Grid form hidden field names
    public $FormName = "fGOOD_MUTATIONlist";
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
        global $UserTable;

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("language");

        // Parent constuctor
        parent::__construct();

        // Table object (GOOD_MUTATION)
        if (!isset($GLOBALS["GOOD_MUTATION"]) || get_class($GLOBALS["GOOD_MUTATION"]) == PROJECT_NAMESPACE . "GOOD_MUTATION") {
            $GLOBALS["GOOD_MUTATION"] = &$this;
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
        $this->AddUrl = "GoodMutationAdd";
        $this->InlineAddUrl = $pageUrl . "action=add";
        $this->GridAddUrl = $pageUrl . "action=gridadd";
        $this->GridEditUrl = $pageUrl . "action=gridedit";
        $this->MultiDeleteUrl = "GoodMutationDelete";
        $this->MultiUpdateUrl = "GoodMutationUpdate";

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'GOOD_MUTATION');
        }

        // Start timer
        $DebugTimer = Container("timer");

        // Debug message
        LoadDebugMessage();

        // Open connection
        $GLOBALS["Conn"] = $GLOBALS["Conn"] ?? $this->getConnection();

        // User table object
        $UserTable = Container("usertable");

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
        $this->FilterOptions->TagClassName = "ew-filter-option fGOOD_MUTATIONlistsrch";

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
                $doc = new $class(Container("GOOD_MUTATION"));
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
            $key .= @$ar['ITEM_ID'];
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
        $this->ITEM_ID->setVisibility();
        $this->ORG_ID->setVisibility();
        $this->RETUR_ID->setVisibility();
        $this->ORDER_ID->setVisibility();
        $this->BATCH_NO->setVisibility();
        $this->BRAND_ID->setVisibility();
        $this->ROOMS_ID->setVisibility();
        $this->SHELF_NO->setVisibility();
        $this->EXPIRY_DATE->setVisibility();
        $this->SERIAL_NB->setVisibility();
        $this->FROM_ROOMS_ID->setVisibility();
        $this->ISOUTLET->setVisibility();
        $this->QUANTITY->setVisibility();
        $this->MEASURE_ID->setVisibility();
        $this->DISTRIBUTION_TYPE->setVisibility();
        $this->CONDITION->setVisibility();
        $this->ALLOCATED_DATE->setVisibility();
        $this->STOCKOPNAME_DATE->setVisibility();
        $this->INVOICE_ID->setVisibility();
        $this->ALLOCATED_FROM->setVisibility();
        $this->PRICE->setVisibility();
        $this->ITEM_ID_FROM->setVisibility();
        $this->MODIFIED_DATE->setVisibility();
        $this->MODIFIED_BY->setVisibility();
        $this->STOCK_OPNAME->setVisibility();
        $this->STOK_AWAL->setVisibility();
        $this->STOCK_LALU->setVisibility();
        $this->STOCK_KOREKSI->setVisibility();
        $this->DITERIMA->setVisibility();
        $this->DISTRIBUSI->setVisibility();
        $this->DIJUAL->setVisibility();
        $this->DIHAPUS->setVisibility();
        $this->DIMINTA->setVisibility();
        $this->DIRETUR->setVisibility();
        $this->PO->setVisibility();
        $this->COMPANY_ID->setVisibility();
        $this->FUND_ID->setVisibility();
        $this->INVOICE_ID2->setVisibility();
        $this->MEASURE_ID3->setVisibility();
        $this->SIZE_KEMASAN->setVisibility();
        $this->BRAND_NAME->setVisibility();
        $this->MEASURE_ID2->setVisibility();
        $this->SIZE_GOODS->setVisibility();
        $this->MEASURE_DOSIS->setVisibility();
        $this->DOC_NO->setVisibility();
        $this->ORDER_PRICE->setVisibility();
        $this->ISCETAK->setVisibility();
        $this->PRINT_DATE->setVisibility();
        $this->PRINTED_BY->setVisibility();
        $this->PRINTQ->setVisibility();
        $this->STOCK_AVAILABLE->setVisibility();
        $this->STATUS_PASIEN_ID->setVisibility();
        $this->MONTH_ID->setVisibility();
        $this->YEAR_ID->setVisibility();
        $this->CORRECTION_DOC->setVisibility();
        $this->CORRECTIONS->setVisibility();
        $this->CORRECTION_DATE->setVisibility();
        $this->DISCOUNT->setVisibility();
        $this->DISCOUNT2->setVisibility();
        $this->ORG_UNIT_FROM->setVisibility();
        $this->DISCOUNTOFF->setVisibility();
        $this->avgprice->setVisibility();
        $this->idx->setVisibility();
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
        if (!$Security->canList()) {
            $filter = "(0=1)"; // Filter all records
        }
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
                if (!$Security->canList()) {
                    $this->setWarningMessage(DeniedMessage());
                }
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
        $filterList = Concat($filterList, $this->ITEM_ID->AdvancedSearch->toJson(), ","); // Field ITEM_ID
        $filterList = Concat($filterList, $this->ORG_ID->AdvancedSearch->toJson(), ","); // Field ORG_ID
        $filterList = Concat($filterList, $this->RETUR_ID->AdvancedSearch->toJson(), ","); // Field RETUR_ID
        $filterList = Concat($filterList, $this->ORDER_ID->AdvancedSearch->toJson(), ","); // Field ORDER_ID
        $filterList = Concat($filterList, $this->BATCH_NO->AdvancedSearch->toJson(), ","); // Field BATCH_NO
        $filterList = Concat($filterList, $this->BRAND_ID->AdvancedSearch->toJson(), ","); // Field BRAND_ID
        $filterList = Concat($filterList, $this->ROOMS_ID->AdvancedSearch->toJson(), ","); // Field ROOMS_ID
        $filterList = Concat($filterList, $this->SHELF_NO->AdvancedSearch->toJson(), ","); // Field SHELF_NO
        $filterList = Concat($filterList, $this->EXPIRY_DATE->AdvancedSearch->toJson(), ","); // Field EXPIRY_DATE
        $filterList = Concat($filterList, $this->SERIAL_NB->AdvancedSearch->toJson(), ","); // Field SERIAL_NB
        $filterList = Concat($filterList, $this->FROM_ROOMS_ID->AdvancedSearch->toJson(), ","); // Field FROM_ROOMS_ID
        $filterList = Concat($filterList, $this->ISOUTLET->AdvancedSearch->toJson(), ","); // Field ISOUTLET
        $filterList = Concat($filterList, $this->QUANTITY->AdvancedSearch->toJson(), ","); // Field QUANTITY
        $filterList = Concat($filterList, $this->MEASURE_ID->AdvancedSearch->toJson(), ","); // Field MEASURE_ID
        $filterList = Concat($filterList, $this->DISTRIBUTION_TYPE->AdvancedSearch->toJson(), ","); // Field DISTRIBUTION_TYPE
        $filterList = Concat($filterList, $this->CONDITION->AdvancedSearch->toJson(), ","); // Field CONDITION
        $filterList = Concat($filterList, $this->ALLOCATED_DATE->AdvancedSearch->toJson(), ","); // Field ALLOCATED_DATE
        $filterList = Concat($filterList, $this->STOCKOPNAME_DATE->AdvancedSearch->toJson(), ","); // Field STOCKOPNAME_DATE
        $filterList = Concat($filterList, $this->INVOICE_ID->AdvancedSearch->toJson(), ","); // Field INVOICE_ID
        $filterList = Concat($filterList, $this->ALLOCATED_FROM->AdvancedSearch->toJson(), ","); // Field ALLOCATED_FROM
        $filterList = Concat($filterList, $this->PRICE->AdvancedSearch->toJson(), ","); // Field PRICE
        $filterList = Concat($filterList, $this->ITEM_ID_FROM->AdvancedSearch->toJson(), ","); // Field ITEM_ID_FROM
        $filterList = Concat($filterList, $this->MODIFIED_DATE->AdvancedSearch->toJson(), ","); // Field MODIFIED_DATE
        $filterList = Concat($filterList, $this->MODIFIED_BY->AdvancedSearch->toJson(), ","); // Field MODIFIED_BY
        $filterList = Concat($filterList, $this->STOCK_OPNAME->AdvancedSearch->toJson(), ","); // Field STOCK_OPNAME
        $filterList = Concat($filterList, $this->STOK_AWAL->AdvancedSearch->toJson(), ","); // Field STOK_AWAL
        $filterList = Concat($filterList, $this->STOCK_LALU->AdvancedSearch->toJson(), ","); // Field STOCK_LALU
        $filterList = Concat($filterList, $this->STOCK_KOREKSI->AdvancedSearch->toJson(), ","); // Field STOCK_KOREKSI
        $filterList = Concat($filterList, $this->DITERIMA->AdvancedSearch->toJson(), ","); // Field DITERIMA
        $filterList = Concat($filterList, $this->DISTRIBUSI->AdvancedSearch->toJson(), ","); // Field DISTRIBUSI
        $filterList = Concat($filterList, $this->DIJUAL->AdvancedSearch->toJson(), ","); // Field DIJUAL
        $filterList = Concat($filterList, $this->DIHAPUS->AdvancedSearch->toJson(), ","); // Field DIHAPUS
        $filterList = Concat($filterList, $this->DIMINTA->AdvancedSearch->toJson(), ","); // Field DIMINTA
        $filterList = Concat($filterList, $this->DIRETUR->AdvancedSearch->toJson(), ","); // Field DIRETUR
        $filterList = Concat($filterList, $this->PO->AdvancedSearch->toJson(), ","); // Field PO
        $filterList = Concat($filterList, $this->COMPANY_ID->AdvancedSearch->toJson(), ","); // Field COMPANY_ID
        $filterList = Concat($filterList, $this->FUND_ID->AdvancedSearch->toJson(), ","); // Field FUND_ID
        $filterList = Concat($filterList, $this->INVOICE_ID2->AdvancedSearch->toJson(), ","); // Field INVOICE_ID2
        $filterList = Concat($filterList, $this->MEASURE_ID3->AdvancedSearch->toJson(), ","); // Field MEASURE_ID3
        $filterList = Concat($filterList, $this->SIZE_KEMASAN->AdvancedSearch->toJson(), ","); // Field SIZE_KEMASAN
        $filterList = Concat($filterList, $this->BRAND_NAME->AdvancedSearch->toJson(), ","); // Field BRAND_NAME
        $filterList = Concat($filterList, $this->MEASURE_ID2->AdvancedSearch->toJson(), ","); // Field MEASURE_ID2
        $filterList = Concat($filterList, $this->SIZE_GOODS->AdvancedSearch->toJson(), ","); // Field SIZE_GOODS
        $filterList = Concat($filterList, $this->MEASURE_DOSIS->AdvancedSearch->toJson(), ","); // Field MEASURE_DOSIS
        $filterList = Concat($filterList, $this->DOC_NO->AdvancedSearch->toJson(), ","); // Field DOC_NO
        $filterList = Concat($filterList, $this->ORDER_PRICE->AdvancedSearch->toJson(), ","); // Field ORDER_PRICE
        $filterList = Concat($filterList, $this->ISCETAK->AdvancedSearch->toJson(), ","); // Field ISCETAK
        $filterList = Concat($filterList, $this->PRINT_DATE->AdvancedSearch->toJson(), ","); // Field PRINT_DATE
        $filterList = Concat($filterList, $this->PRINTED_BY->AdvancedSearch->toJson(), ","); // Field PRINTED_BY
        $filterList = Concat($filterList, $this->PRINTQ->AdvancedSearch->toJson(), ","); // Field PRINTQ
        $filterList = Concat($filterList, $this->STOCK_AVAILABLE->AdvancedSearch->toJson(), ","); // Field STOCK_AVAILABLE
        $filterList = Concat($filterList, $this->STATUS_PASIEN_ID->AdvancedSearch->toJson(), ","); // Field STATUS_PASIEN_ID
        $filterList = Concat($filterList, $this->MONTH_ID->AdvancedSearch->toJson(), ","); // Field MONTH_ID
        $filterList = Concat($filterList, $this->YEAR_ID->AdvancedSearch->toJson(), ","); // Field YEAR_ID
        $filterList = Concat($filterList, $this->CORRECTION_DOC->AdvancedSearch->toJson(), ","); // Field CORRECTION_DOC
        $filterList = Concat($filterList, $this->CORRECTIONS->AdvancedSearch->toJson(), ","); // Field CORRECTIONS
        $filterList = Concat($filterList, $this->CORRECTION_DATE->AdvancedSearch->toJson(), ","); // Field CORRECTION_DATE
        $filterList = Concat($filterList, $this->DISCOUNT->AdvancedSearch->toJson(), ","); // Field DISCOUNT
        $filterList = Concat($filterList, $this->DISCOUNT2->AdvancedSearch->toJson(), ","); // Field DISCOUNT2
        $filterList = Concat($filterList, $this->ORG_UNIT_FROM->AdvancedSearch->toJson(), ","); // Field ORG_UNIT_FROM
        $filterList = Concat($filterList, $this->DISCOUNTOFF->AdvancedSearch->toJson(), ","); // Field DISCOUNTOFF
        $filterList = Concat($filterList, $this->avgprice->AdvancedSearch->toJson(), ","); // Field avgprice
        $filterList = Concat($filterList, $this->idx->AdvancedSearch->toJson(), ","); // Field idx
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
            $UserProfile->setSearchFilters(CurrentUserName(), "fGOOD_MUTATIONlistsrch", $filters);
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

        // Field ITEM_ID
        $this->ITEM_ID->AdvancedSearch->SearchValue = @$filter["x_ITEM_ID"];
        $this->ITEM_ID->AdvancedSearch->SearchOperator = @$filter["z_ITEM_ID"];
        $this->ITEM_ID->AdvancedSearch->SearchCondition = @$filter["v_ITEM_ID"];
        $this->ITEM_ID->AdvancedSearch->SearchValue2 = @$filter["y_ITEM_ID"];
        $this->ITEM_ID->AdvancedSearch->SearchOperator2 = @$filter["w_ITEM_ID"];
        $this->ITEM_ID->AdvancedSearch->save();

        // Field ORG_ID
        $this->ORG_ID->AdvancedSearch->SearchValue = @$filter["x_ORG_ID"];
        $this->ORG_ID->AdvancedSearch->SearchOperator = @$filter["z_ORG_ID"];
        $this->ORG_ID->AdvancedSearch->SearchCondition = @$filter["v_ORG_ID"];
        $this->ORG_ID->AdvancedSearch->SearchValue2 = @$filter["y_ORG_ID"];
        $this->ORG_ID->AdvancedSearch->SearchOperator2 = @$filter["w_ORG_ID"];
        $this->ORG_ID->AdvancedSearch->save();

        // Field RETUR_ID
        $this->RETUR_ID->AdvancedSearch->SearchValue = @$filter["x_RETUR_ID"];
        $this->RETUR_ID->AdvancedSearch->SearchOperator = @$filter["z_RETUR_ID"];
        $this->RETUR_ID->AdvancedSearch->SearchCondition = @$filter["v_RETUR_ID"];
        $this->RETUR_ID->AdvancedSearch->SearchValue2 = @$filter["y_RETUR_ID"];
        $this->RETUR_ID->AdvancedSearch->SearchOperator2 = @$filter["w_RETUR_ID"];
        $this->RETUR_ID->AdvancedSearch->save();

        // Field ORDER_ID
        $this->ORDER_ID->AdvancedSearch->SearchValue = @$filter["x_ORDER_ID"];
        $this->ORDER_ID->AdvancedSearch->SearchOperator = @$filter["z_ORDER_ID"];
        $this->ORDER_ID->AdvancedSearch->SearchCondition = @$filter["v_ORDER_ID"];
        $this->ORDER_ID->AdvancedSearch->SearchValue2 = @$filter["y_ORDER_ID"];
        $this->ORDER_ID->AdvancedSearch->SearchOperator2 = @$filter["w_ORDER_ID"];
        $this->ORDER_ID->AdvancedSearch->save();

        // Field BATCH_NO
        $this->BATCH_NO->AdvancedSearch->SearchValue = @$filter["x_BATCH_NO"];
        $this->BATCH_NO->AdvancedSearch->SearchOperator = @$filter["z_BATCH_NO"];
        $this->BATCH_NO->AdvancedSearch->SearchCondition = @$filter["v_BATCH_NO"];
        $this->BATCH_NO->AdvancedSearch->SearchValue2 = @$filter["y_BATCH_NO"];
        $this->BATCH_NO->AdvancedSearch->SearchOperator2 = @$filter["w_BATCH_NO"];
        $this->BATCH_NO->AdvancedSearch->save();

        // Field BRAND_ID
        $this->BRAND_ID->AdvancedSearch->SearchValue = @$filter["x_BRAND_ID"];
        $this->BRAND_ID->AdvancedSearch->SearchOperator = @$filter["z_BRAND_ID"];
        $this->BRAND_ID->AdvancedSearch->SearchCondition = @$filter["v_BRAND_ID"];
        $this->BRAND_ID->AdvancedSearch->SearchValue2 = @$filter["y_BRAND_ID"];
        $this->BRAND_ID->AdvancedSearch->SearchOperator2 = @$filter["w_BRAND_ID"];
        $this->BRAND_ID->AdvancedSearch->save();

        // Field ROOMS_ID
        $this->ROOMS_ID->AdvancedSearch->SearchValue = @$filter["x_ROOMS_ID"];
        $this->ROOMS_ID->AdvancedSearch->SearchOperator = @$filter["z_ROOMS_ID"];
        $this->ROOMS_ID->AdvancedSearch->SearchCondition = @$filter["v_ROOMS_ID"];
        $this->ROOMS_ID->AdvancedSearch->SearchValue2 = @$filter["y_ROOMS_ID"];
        $this->ROOMS_ID->AdvancedSearch->SearchOperator2 = @$filter["w_ROOMS_ID"];
        $this->ROOMS_ID->AdvancedSearch->save();

        // Field SHELF_NO
        $this->SHELF_NO->AdvancedSearch->SearchValue = @$filter["x_SHELF_NO"];
        $this->SHELF_NO->AdvancedSearch->SearchOperator = @$filter["z_SHELF_NO"];
        $this->SHELF_NO->AdvancedSearch->SearchCondition = @$filter["v_SHELF_NO"];
        $this->SHELF_NO->AdvancedSearch->SearchValue2 = @$filter["y_SHELF_NO"];
        $this->SHELF_NO->AdvancedSearch->SearchOperator2 = @$filter["w_SHELF_NO"];
        $this->SHELF_NO->AdvancedSearch->save();

        // Field EXPIRY_DATE
        $this->EXPIRY_DATE->AdvancedSearch->SearchValue = @$filter["x_EXPIRY_DATE"];
        $this->EXPIRY_DATE->AdvancedSearch->SearchOperator = @$filter["z_EXPIRY_DATE"];
        $this->EXPIRY_DATE->AdvancedSearch->SearchCondition = @$filter["v_EXPIRY_DATE"];
        $this->EXPIRY_DATE->AdvancedSearch->SearchValue2 = @$filter["y_EXPIRY_DATE"];
        $this->EXPIRY_DATE->AdvancedSearch->SearchOperator2 = @$filter["w_EXPIRY_DATE"];
        $this->EXPIRY_DATE->AdvancedSearch->save();

        // Field SERIAL_NB
        $this->SERIAL_NB->AdvancedSearch->SearchValue = @$filter["x_SERIAL_NB"];
        $this->SERIAL_NB->AdvancedSearch->SearchOperator = @$filter["z_SERIAL_NB"];
        $this->SERIAL_NB->AdvancedSearch->SearchCondition = @$filter["v_SERIAL_NB"];
        $this->SERIAL_NB->AdvancedSearch->SearchValue2 = @$filter["y_SERIAL_NB"];
        $this->SERIAL_NB->AdvancedSearch->SearchOperator2 = @$filter["w_SERIAL_NB"];
        $this->SERIAL_NB->AdvancedSearch->save();

        // Field FROM_ROOMS_ID
        $this->FROM_ROOMS_ID->AdvancedSearch->SearchValue = @$filter["x_FROM_ROOMS_ID"];
        $this->FROM_ROOMS_ID->AdvancedSearch->SearchOperator = @$filter["z_FROM_ROOMS_ID"];
        $this->FROM_ROOMS_ID->AdvancedSearch->SearchCondition = @$filter["v_FROM_ROOMS_ID"];
        $this->FROM_ROOMS_ID->AdvancedSearch->SearchValue2 = @$filter["y_FROM_ROOMS_ID"];
        $this->FROM_ROOMS_ID->AdvancedSearch->SearchOperator2 = @$filter["w_FROM_ROOMS_ID"];
        $this->FROM_ROOMS_ID->AdvancedSearch->save();

        // Field ISOUTLET
        $this->ISOUTLET->AdvancedSearch->SearchValue = @$filter["x_ISOUTLET"];
        $this->ISOUTLET->AdvancedSearch->SearchOperator = @$filter["z_ISOUTLET"];
        $this->ISOUTLET->AdvancedSearch->SearchCondition = @$filter["v_ISOUTLET"];
        $this->ISOUTLET->AdvancedSearch->SearchValue2 = @$filter["y_ISOUTLET"];
        $this->ISOUTLET->AdvancedSearch->SearchOperator2 = @$filter["w_ISOUTLET"];
        $this->ISOUTLET->AdvancedSearch->save();

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

        // Field DISTRIBUTION_TYPE
        $this->DISTRIBUTION_TYPE->AdvancedSearch->SearchValue = @$filter["x_DISTRIBUTION_TYPE"];
        $this->DISTRIBUTION_TYPE->AdvancedSearch->SearchOperator = @$filter["z_DISTRIBUTION_TYPE"];
        $this->DISTRIBUTION_TYPE->AdvancedSearch->SearchCondition = @$filter["v_DISTRIBUTION_TYPE"];
        $this->DISTRIBUTION_TYPE->AdvancedSearch->SearchValue2 = @$filter["y_DISTRIBUTION_TYPE"];
        $this->DISTRIBUTION_TYPE->AdvancedSearch->SearchOperator2 = @$filter["w_DISTRIBUTION_TYPE"];
        $this->DISTRIBUTION_TYPE->AdvancedSearch->save();

        // Field CONDITION
        $this->CONDITION->AdvancedSearch->SearchValue = @$filter["x_CONDITION"];
        $this->CONDITION->AdvancedSearch->SearchOperator = @$filter["z_CONDITION"];
        $this->CONDITION->AdvancedSearch->SearchCondition = @$filter["v_CONDITION"];
        $this->CONDITION->AdvancedSearch->SearchValue2 = @$filter["y_CONDITION"];
        $this->CONDITION->AdvancedSearch->SearchOperator2 = @$filter["w_CONDITION"];
        $this->CONDITION->AdvancedSearch->save();

        // Field ALLOCATED_DATE
        $this->ALLOCATED_DATE->AdvancedSearch->SearchValue = @$filter["x_ALLOCATED_DATE"];
        $this->ALLOCATED_DATE->AdvancedSearch->SearchOperator = @$filter["z_ALLOCATED_DATE"];
        $this->ALLOCATED_DATE->AdvancedSearch->SearchCondition = @$filter["v_ALLOCATED_DATE"];
        $this->ALLOCATED_DATE->AdvancedSearch->SearchValue2 = @$filter["y_ALLOCATED_DATE"];
        $this->ALLOCATED_DATE->AdvancedSearch->SearchOperator2 = @$filter["w_ALLOCATED_DATE"];
        $this->ALLOCATED_DATE->AdvancedSearch->save();

        // Field STOCKOPNAME_DATE
        $this->STOCKOPNAME_DATE->AdvancedSearch->SearchValue = @$filter["x_STOCKOPNAME_DATE"];
        $this->STOCKOPNAME_DATE->AdvancedSearch->SearchOperator = @$filter["z_STOCKOPNAME_DATE"];
        $this->STOCKOPNAME_DATE->AdvancedSearch->SearchCondition = @$filter["v_STOCKOPNAME_DATE"];
        $this->STOCKOPNAME_DATE->AdvancedSearch->SearchValue2 = @$filter["y_STOCKOPNAME_DATE"];
        $this->STOCKOPNAME_DATE->AdvancedSearch->SearchOperator2 = @$filter["w_STOCKOPNAME_DATE"];
        $this->STOCKOPNAME_DATE->AdvancedSearch->save();

        // Field INVOICE_ID
        $this->INVOICE_ID->AdvancedSearch->SearchValue = @$filter["x_INVOICE_ID"];
        $this->INVOICE_ID->AdvancedSearch->SearchOperator = @$filter["z_INVOICE_ID"];
        $this->INVOICE_ID->AdvancedSearch->SearchCondition = @$filter["v_INVOICE_ID"];
        $this->INVOICE_ID->AdvancedSearch->SearchValue2 = @$filter["y_INVOICE_ID"];
        $this->INVOICE_ID->AdvancedSearch->SearchOperator2 = @$filter["w_INVOICE_ID"];
        $this->INVOICE_ID->AdvancedSearch->save();

        // Field ALLOCATED_FROM
        $this->ALLOCATED_FROM->AdvancedSearch->SearchValue = @$filter["x_ALLOCATED_FROM"];
        $this->ALLOCATED_FROM->AdvancedSearch->SearchOperator = @$filter["z_ALLOCATED_FROM"];
        $this->ALLOCATED_FROM->AdvancedSearch->SearchCondition = @$filter["v_ALLOCATED_FROM"];
        $this->ALLOCATED_FROM->AdvancedSearch->SearchValue2 = @$filter["y_ALLOCATED_FROM"];
        $this->ALLOCATED_FROM->AdvancedSearch->SearchOperator2 = @$filter["w_ALLOCATED_FROM"];
        $this->ALLOCATED_FROM->AdvancedSearch->save();

        // Field PRICE
        $this->PRICE->AdvancedSearch->SearchValue = @$filter["x_PRICE"];
        $this->PRICE->AdvancedSearch->SearchOperator = @$filter["z_PRICE"];
        $this->PRICE->AdvancedSearch->SearchCondition = @$filter["v_PRICE"];
        $this->PRICE->AdvancedSearch->SearchValue2 = @$filter["y_PRICE"];
        $this->PRICE->AdvancedSearch->SearchOperator2 = @$filter["w_PRICE"];
        $this->PRICE->AdvancedSearch->save();

        // Field ITEM_ID_FROM
        $this->ITEM_ID_FROM->AdvancedSearch->SearchValue = @$filter["x_ITEM_ID_FROM"];
        $this->ITEM_ID_FROM->AdvancedSearch->SearchOperator = @$filter["z_ITEM_ID_FROM"];
        $this->ITEM_ID_FROM->AdvancedSearch->SearchCondition = @$filter["v_ITEM_ID_FROM"];
        $this->ITEM_ID_FROM->AdvancedSearch->SearchValue2 = @$filter["y_ITEM_ID_FROM"];
        $this->ITEM_ID_FROM->AdvancedSearch->SearchOperator2 = @$filter["w_ITEM_ID_FROM"];
        $this->ITEM_ID_FROM->AdvancedSearch->save();

        // Field MODIFIED_DATE
        $this->MODIFIED_DATE->AdvancedSearch->SearchValue = @$filter["x_MODIFIED_DATE"];
        $this->MODIFIED_DATE->AdvancedSearch->SearchOperator = @$filter["z_MODIFIED_DATE"];
        $this->MODIFIED_DATE->AdvancedSearch->SearchCondition = @$filter["v_MODIFIED_DATE"];
        $this->MODIFIED_DATE->AdvancedSearch->SearchValue2 = @$filter["y_MODIFIED_DATE"];
        $this->MODIFIED_DATE->AdvancedSearch->SearchOperator2 = @$filter["w_MODIFIED_DATE"];
        $this->MODIFIED_DATE->AdvancedSearch->save();

        // Field MODIFIED_BY
        $this->MODIFIED_BY->AdvancedSearch->SearchValue = @$filter["x_MODIFIED_BY"];
        $this->MODIFIED_BY->AdvancedSearch->SearchOperator = @$filter["z_MODIFIED_BY"];
        $this->MODIFIED_BY->AdvancedSearch->SearchCondition = @$filter["v_MODIFIED_BY"];
        $this->MODIFIED_BY->AdvancedSearch->SearchValue2 = @$filter["y_MODIFIED_BY"];
        $this->MODIFIED_BY->AdvancedSearch->SearchOperator2 = @$filter["w_MODIFIED_BY"];
        $this->MODIFIED_BY->AdvancedSearch->save();

        // Field STOCK_OPNAME
        $this->STOCK_OPNAME->AdvancedSearch->SearchValue = @$filter["x_STOCK_OPNAME"];
        $this->STOCK_OPNAME->AdvancedSearch->SearchOperator = @$filter["z_STOCK_OPNAME"];
        $this->STOCK_OPNAME->AdvancedSearch->SearchCondition = @$filter["v_STOCK_OPNAME"];
        $this->STOCK_OPNAME->AdvancedSearch->SearchValue2 = @$filter["y_STOCK_OPNAME"];
        $this->STOCK_OPNAME->AdvancedSearch->SearchOperator2 = @$filter["w_STOCK_OPNAME"];
        $this->STOCK_OPNAME->AdvancedSearch->save();

        // Field STOK_AWAL
        $this->STOK_AWAL->AdvancedSearch->SearchValue = @$filter["x_STOK_AWAL"];
        $this->STOK_AWAL->AdvancedSearch->SearchOperator = @$filter["z_STOK_AWAL"];
        $this->STOK_AWAL->AdvancedSearch->SearchCondition = @$filter["v_STOK_AWAL"];
        $this->STOK_AWAL->AdvancedSearch->SearchValue2 = @$filter["y_STOK_AWAL"];
        $this->STOK_AWAL->AdvancedSearch->SearchOperator2 = @$filter["w_STOK_AWAL"];
        $this->STOK_AWAL->AdvancedSearch->save();

        // Field STOCK_LALU
        $this->STOCK_LALU->AdvancedSearch->SearchValue = @$filter["x_STOCK_LALU"];
        $this->STOCK_LALU->AdvancedSearch->SearchOperator = @$filter["z_STOCK_LALU"];
        $this->STOCK_LALU->AdvancedSearch->SearchCondition = @$filter["v_STOCK_LALU"];
        $this->STOCK_LALU->AdvancedSearch->SearchValue2 = @$filter["y_STOCK_LALU"];
        $this->STOCK_LALU->AdvancedSearch->SearchOperator2 = @$filter["w_STOCK_LALU"];
        $this->STOCK_LALU->AdvancedSearch->save();

        // Field STOCK_KOREKSI
        $this->STOCK_KOREKSI->AdvancedSearch->SearchValue = @$filter["x_STOCK_KOREKSI"];
        $this->STOCK_KOREKSI->AdvancedSearch->SearchOperator = @$filter["z_STOCK_KOREKSI"];
        $this->STOCK_KOREKSI->AdvancedSearch->SearchCondition = @$filter["v_STOCK_KOREKSI"];
        $this->STOCK_KOREKSI->AdvancedSearch->SearchValue2 = @$filter["y_STOCK_KOREKSI"];
        $this->STOCK_KOREKSI->AdvancedSearch->SearchOperator2 = @$filter["w_STOCK_KOREKSI"];
        $this->STOCK_KOREKSI->AdvancedSearch->save();

        // Field DITERIMA
        $this->DITERIMA->AdvancedSearch->SearchValue = @$filter["x_DITERIMA"];
        $this->DITERIMA->AdvancedSearch->SearchOperator = @$filter["z_DITERIMA"];
        $this->DITERIMA->AdvancedSearch->SearchCondition = @$filter["v_DITERIMA"];
        $this->DITERIMA->AdvancedSearch->SearchValue2 = @$filter["y_DITERIMA"];
        $this->DITERIMA->AdvancedSearch->SearchOperator2 = @$filter["w_DITERIMA"];
        $this->DITERIMA->AdvancedSearch->save();

        // Field DISTRIBUSI
        $this->DISTRIBUSI->AdvancedSearch->SearchValue = @$filter["x_DISTRIBUSI"];
        $this->DISTRIBUSI->AdvancedSearch->SearchOperator = @$filter["z_DISTRIBUSI"];
        $this->DISTRIBUSI->AdvancedSearch->SearchCondition = @$filter["v_DISTRIBUSI"];
        $this->DISTRIBUSI->AdvancedSearch->SearchValue2 = @$filter["y_DISTRIBUSI"];
        $this->DISTRIBUSI->AdvancedSearch->SearchOperator2 = @$filter["w_DISTRIBUSI"];
        $this->DISTRIBUSI->AdvancedSearch->save();

        // Field DIJUAL
        $this->DIJUAL->AdvancedSearch->SearchValue = @$filter["x_DIJUAL"];
        $this->DIJUAL->AdvancedSearch->SearchOperator = @$filter["z_DIJUAL"];
        $this->DIJUAL->AdvancedSearch->SearchCondition = @$filter["v_DIJUAL"];
        $this->DIJUAL->AdvancedSearch->SearchValue2 = @$filter["y_DIJUAL"];
        $this->DIJUAL->AdvancedSearch->SearchOperator2 = @$filter["w_DIJUAL"];
        $this->DIJUAL->AdvancedSearch->save();

        // Field DIHAPUS
        $this->DIHAPUS->AdvancedSearch->SearchValue = @$filter["x_DIHAPUS"];
        $this->DIHAPUS->AdvancedSearch->SearchOperator = @$filter["z_DIHAPUS"];
        $this->DIHAPUS->AdvancedSearch->SearchCondition = @$filter["v_DIHAPUS"];
        $this->DIHAPUS->AdvancedSearch->SearchValue2 = @$filter["y_DIHAPUS"];
        $this->DIHAPUS->AdvancedSearch->SearchOperator2 = @$filter["w_DIHAPUS"];
        $this->DIHAPUS->AdvancedSearch->save();

        // Field DIMINTA
        $this->DIMINTA->AdvancedSearch->SearchValue = @$filter["x_DIMINTA"];
        $this->DIMINTA->AdvancedSearch->SearchOperator = @$filter["z_DIMINTA"];
        $this->DIMINTA->AdvancedSearch->SearchCondition = @$filter["v_DIMINTA"];
        $this->DIMINTA->AdvancedSearch->SearchValue2 = @$filter["y_DIMINTA"];
        $this->DIMINTA->AdvancedSearch->SearchOperator2 = @$filter["w_DIMINTA"];
        $this->DIMINTA->AdvancedSearch->save();

        // Field DIRETUR
        $this->DIRETUR->AdvancedSearch->SearchValue = @$filter["x_DIRETUR"];
        $this->DIRETUR->AdvancedSearch->SearchOperator = @$filter["z_DIRETUR"];
        $this->DIRETUR->AdvancedSearch->SearchCondition = @$filter["v_DIRETUR"];
        $this->DIRETUR->AdvancedSearch->SearchValue2 = @$filter["y_DIRETUR"];
        $this->DIRETUR->AdvancedSearch->SearchOperator2 = @$filter["w_DIRETUR"];
        $this->DIRETUR->AdvancedSearch->save();

        // Field PO
        $this->PO->AdvancedSearch->SearchValue = @$filter["x_PO"];
        $this->PO->AdvancedSearch->SearchOperator = @$filter["z_PO"];
        $this->PO->AdvancedSearch->SearchCondition = @$filter["v_PO"];
        $this->PO->AdvancedSearch->SearchValue2 = @$filter["y_PO"];
        $this->PO->AdvancedSearch->SearchOperator2 = @$filter["w_PO"];
        $this->PO->AdvancedSearch->save();

        // Field COMPANY_ID
        $this->COMPANY_ID->AdvancedSearch->SearchValue = @$filter["x_COMPANY_ID"];
        $this->COMPANY_ID->AdvancedSearch->SearchOperator = @$filter["z_COMPANY_ID"];
        $this->COMPANY_ID->AdvancedSearch->SearchCondition = @$filter["v_COMPANY_ID"];
        $this->COMPANY_ID->AdvancedSearch->SearchValue2 = @$filter["y_COMPANY_ID"];
        $this->COMPANY_ID->AdvancedSearch->SearchOperator2 = @$filter["w_COMPANY_ID"];
        $this->COMPANY_ID->AdvancedSearch->save();

        // Field FUND_ID
        $this->FUND_ID->AdvancedSearch->SearchValue = @$filter["x_FUND_ID"];
        $this->FUND_ID->AdvancedSearch->SearchOperator = @$filter["z_FUND_ID"];
        $this->FUND_ID->AdvancedSearch->SearchCondition = @$filter["v_FUND_ID"];
        $this->FUND_ID->AdvancedSearch->SearchValue2 = @$filter["y_FUND_ID"];
        $this->FUND_ID->AdvancedSearch->SearchOperator2 = @$filter["w_FUND_ID"];
        $this->FUND_ID->AdvancedSearch->save();

        // Field INVOICE_ID2
        $this->INVOICE_ID2->AdvancedSearch->SearchValue = @$filter["x_INVOICE_ID2"];
        $this->INVOICE_ID2->AdvancedSearch->SearchOperator = @$filter["z_INVOICE_ID2"];
        $this->INVOICE_ID2->AdvancedSearch->SearchCondition = @$filter["v_INVOICE_ID2"];
        $this->INVOICE_ID2->AdvancedSearch->SearchValue2 = @$filter["y_INVOICE_ID2"];
        $this->INVOICE_ID2->AdvancedSearch->SearchOperator2 = @$filter["w_INVOICE_ID2"];
        $this->INVOICE_ID2->AdvancedSearch->save();

        // Field MEASURE_ID3
        $this->MEASURE_ID3->AdvancedSearch->SearchValue = @$filter["x_MEASURE_ID3"];
        $this->MEASURE_ID3->AdvancedSearch->SearchOperator = @$filter["z_MEASURE_ID3"];
        $this->MEASURE_ID3->AdvancedSearch->SearchCondition = @$filter["v_MEASURE_ID3"];
        $this->MEASURE_ID3->AdvancedSearch->SearchValue2 = @$filter["y_MEASURE_ID3"];
        $this->MEASURE_ID3->AdvancedSearch->SearchOperator2 = @$filter["w_MEASURE_ID3"];
        $this->MEASURE_ID3->AdvancedSearch->save();

        // Field SIZE_KEMASAN
        $this->SIZE_KEMASAN->AdvancedSearch->SearchValue = @$filter["x_SIZE_KEMASAN"];
        $this->SIZE_KEMASAN->AdvancedSearch->SearchOperator = @$filter["z_SIZE_KEMASAN"];
        $this->SIZE_KEMASAN->AdvancedSearch->SearchCondition = @$filter["v_SIZE_KEMASAN"];
        $this->SIZE_KEMASAN->AdvancedSearch->SearchValue2 = @$filter["y_SIZE_KEMASAN"];
        $this->SIZE_KEMASAN->AdvancedSearch->SearchOperator2 = @$filter["w_SIZE_KEMASAN"];
        $this->SIZE_KEMASAN->AdvancedSearch->save();

        // Field BRAND_NAME
        $this->BRAND_NAME->AdvancedSearch->SearchValue = @$filter["x_BRAND_NAME"];
        $this->BRAND_NAME->AdvancedSearch->SearchOperator = @$filter["z_BRAND_NAME"];
        $this->BRAND_NAME->AdvancedSearch->SearchCondition = @$filter["v_BRAND_NAME"];
        $this->BRAND_NAME->AdvancedSearch->SearchValue2 = @$filter["y_BRAND_NAME"];
        $this->BRAND_NAME->AdvancedSearch->SearchOperator2 = @$filter["w_BRAND_NAME"];
        $this->BRAND_NAME->AdvancedSearch->save();

        // Field MEASURE_ID2
        $this->MEASURE_ID2->AdvancedSearch->SearchValue = @$filter["x_MEASURE_ID2"];
        $this->MEASURE_ID2->AdvancedSearch->SearchOperator = @$filter["z_MEASURE_ID2"];
        $this->MEASURE_ID2->AdvancedSearch->SearchCondition = @$filter["v_MEASURE_ID2"];
        $this->MEASURE_ID2->AdvancedSearch->SearchValue2 = @$filter["y_MEASURE_ID2"];
        $this->MEASURE_ID2->AdvancedSearch->SearchOperator2 = @$filter["w_MEASURE_ID2"];
        $this->MEASURE_ID2->AdvancedSearch->save();

        // Field SIZE_GOODS
        $this->SIZE_GOODS->AdvancedSearch->SearchValue = @$filter["x_SIZE_GOODS"];
        $this->SIZE_GOODS->AdvancedSearch->SearchOperator = @$filter["z_SIZE_GOODS"];
        $this->SIZE_GOODS->AdvancedSearch->SearchCondition = @$filter["v_SIZE_GOODS"];
        $this->SIZE_GOODS->AdvancedSearch->SearchValue2 = @$filter["y_SIZE_GOODS"];
        $this->SIZE_GOODS->AdvancedSearch->SearchOperator2 = @$filter["w_SIZE_GOODS"];
        $this->SIZE_GOODS->AdvancedSearch->save();

        // Field MEASURE_DOSIS
        $this->MEASURE_DOSIS->AdvancedSearch->SearchValue = @$filter["x_MEASURE_DOSIS"];
        $this->MEASURE_DOSIS->AdvancedSearch->SearchOperator = @$filter["z_MEASURE_DOSIS"];
        $this->MEASURE_DOSIS->AdvancedSearch->SearchCondition = @$filter["v_MEASURE_DOSIS"];
        $this->MEASURE_DOSIS->AdvancedSearch->SearchValue2 = @$filter["y_MEASURE_DOSIS"];
        $this->MEASURE_DOSIS->AdvancedSearch->SearchOperator2 = @$filter["w_MEASURE_DOSIS"];
        $this->MEASURE_DOSIS->AdvancedSearch->save();

        // Field DOC_NO
        $this->DOC_NO->AdvancedSearch->SearchValue = @$filter["x_DOC_NO"];
        $this->DOC_NO->AdvancedSearch->SearchOperator = @$filter["z_DOC_NO"];
        $this->DOC_NO->AdvancedSearch->SearchCondition = @$filter["v_DOC_NO"];
        $this->DOC_NO->AdvancedSearch->SearchValue2 = @$filter["y_DOC_NO"];
        $this->DOC_NO->AdvancedSearch->SearchOperator2 = @$filter["w_DOC_NO"];
        $this->DOC_NO->AdvancedSearch->save();

        // Field ORDER_PRICE
        $this->ORDER_PRICE->AdvancedSearch->SearchValue = @$filter["x_ORDER_PRICE"];
        $this->ORDER_PRICE->AdvancedSearch->SearchOperator = @$filter["z_ORDER_PRICE"];
        $this->ORDER_PRICE->AdvancedSearch->SearchCondition = @$filter["v_ORDER_PRICE"];
        $this->ORDER_PRICE->AdvancedSearch->SearchValue2 = @$filter["y_ORDER_PRICE"];
        $this->ORDER_PRICE->AdvancedSearch->SearchOperator2 = @$filter["w_ORDER_PRICE"];
        $this->ORDER_PRICE->AdvancedSearch->save();

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

        // Field PRINTED_BY
        $this->PRINTED_BY->AdvancedSearch->SearchValue = @$filter["x_PRINTED_BY"];
        $this->PRINTED_BY->AdvancedSearch->SearchOperator = @$filter["z_PRINTED_BY"];
        $this->PRINTED_BY->AdvancedSearch->SearchCondition = @$filter["v_PRINTED_BY"];
        $this->PRINTED_BY->AdvancedSearch->SearchValue2 = @$filter["y_PRINTED_BY"];
        $this->PRINTED_BY->AdvancedSearch->SearchOperator2 = @$filter["w_PRINTED_BY"];
        $this->PRINTED_BY->AdvancedSearch->save();

        // Field PRINTQ
        $this->PRINTQ->AdvancedSearch->SearchValue = @$filter["x_PRINTQ"];
        $this->PRINTQ->AdvancedSearch->SearchOperator = @$filter["z_PRINTQ"];
        $this->PRINTQ->AdvancedSearch->SearchCondition = @$filter["v_PRINTQ"];
        $this->PRINTQ->AdvancedSearch->SearchValue2 = @$filter["y_PRINTQ"];
        $this->PRINTQ->AdvancedSearch->SearchOperator2 = @$filter["w_PRINTQ"];
        $this->PRINTQ->AdvancedSearch->save();

        // Field STOCK_AVAILABLE
        $this->STOCK_AVAILABLE->AdvancedSearch->SearchValue = @$filter["x_STOCK_AVAILABLE"];
        $this->STOCK_AVAILABLE->AdvancedSearch->SearchOperator = @$filter["z_STOCK_AVAILABLE"];
        $this->STOCK_AVAILABLE->AdvancedSearch->SearchCondition = @$filter["v_STOCK_AVAILABLE"];
        $this->STOCK_AVAILABLE->AdvancedSearch->SearchValue2 = @$filter["y_STOCK_AVAILABLE"];
        $this->STOCK_AVAILABLE->AdvancedSearch->SearchOperator2 = @$filter["w_STOCK_AVAILABLE"];
        $this->STOCK_AVAILABLE->AdvancedSearch->save();

        // Field STATUS_PASIEN_ID
        $this->STATUS_PASIEN_ID->AdvancedSearch->SearchValue = @$filter["x_STATUS_PASIEN_ID"];
        $this->STATUS_PASIEN_ID->AdvancedSearch->SearchOperator = @$filter["z_STATUS_PASIEN_ID"];
        $this->STATUS_PASIEN_ID->AdvancedSearch->SearchCondition = @$filter["v_STATUS_PASIEN_ID"];
        $this->STATUS_PASIEN_ID->AdvancedSearch->SearchValue2 = @$filter["y_STATUS_PASIEN_ID"];
        $this->STATUS_PASIEN_ID->AdvancedSearch->SearchOperator2 = @$filter["w_STATUS_PASIEN_ID"];
        $this->STATUS_PASIEN_ID->AdvancedSearch->save();

        // Field MONTH_ID
        $this->MONTH_ID->AdvancedSearch->SearchValue = @$filter["x_MONTH_ID"];
        $this->MONTH_ID->AdvancedSearch->SearchOperator = @$filter["z_MONTH_ID"];
        $this->MONTH_ID->AdvancedSearch->SearchCondition = @$filter["v_MONTH_ID"];
        $this->MONTH_ID->AdvancedSearch->SearchValue2 = @$filter["y_MONTH_ID"];
        $this->MONTH_ID->AdvancedSearch->SearchOperator2 = @$filter["w_MONTH_ID"];
        $this->MONTH_ID->AdvancedSearch->save();

        // Field YEAR_ID
        $this->YEAR_ID->AdvancedSearch->SearchValue = @$filter["x_YEAR_ID"];
        $this->YEAR_ID->AdvancedSearch->SearchOperator = @$filter["z_YEAR_ID"];
        $this->YEAR_ID->AdvancedSearch->SearchCondition = @$filter["v_YEAR_ID"];
        $this->YEAR_ID->AdvancedSearch->SearchValue2 = @$filter["y_YEAR_ID"];
        $this->YEAR_ID->AdvancedSearch->SearchOperator2 = @$filter["w_YEAR_ID"];
        $this->YEAR_ID->AdvancedSearch->save();

        // Field CORRECTION_DOC
        $this->CORRECTION_DOC->AdvancedSearch->SearchValue = @$filter["x_CORRECTION_DOC"];
        $this->CORRECTION_DOC->AdvancedSearch->SearchOperator = @$filter["z_CORRECTION_DOC"];
        $this->CORRECTION_DOC->AdvancedSearch->SearchCondition = @$filter["v_CORRECTION_DOC"];
        $this->CORRECTION_DOC->AdvancedSearch->SearchValue2 = @$filter["y_CORRECTION_DOC"];
        $this->CORRECTION_DOC->AdvancedSearch->SearchOperator2 = @$filter["w_CORRECTION_DOC"];
        $this->CORRECTION_DOC->AdvancedSearch->save();

        // Field CORRECTIONS
        $this->CORRECTIONS->AdvancedSearch->SearchValue = @$filter["x_CORRECTIONS"];
        $this->CORRECTIONS->AdvancedSearch->SearchOperator = @$filter["z_CORRECTIONS"];
        $this->CORRECTIONS->AdvancedSearch->SearchCondition = @$filter["v_CORRECTIONS"];
        $this->CORRECTIONS->AdvancedSearch->SearchValue2 = @$filter["y_CORRECTIONS"];
        $this->CORRECTIONS->AdvancedSearch->SearchOperator2 = @$filter["w_CORRECTIONS"];
        $this->CORRECTIONS->AdvancedSearch->save();

        // Field CORRECTION_DATE
        $this->CORRECTION_DATE->AdvancedSearch->SearchValue = @$filter["x_CORRECTION_DATE"];
        $this->CORRECTION_DATE->AdvancedSearch->SearchOperator = @$filter["z_CORRECTION_DATE"];
        $this->CORRECTION_DATE->AdvancedSearch->SearchCondition = @$filter["v_CORRECTION_DATE"];
        $this->CORRECTION_DATE->AdvancedSearch->SearchValue2 = @$filter["y_CORRECTION_DATE"];
        $this->CORRECTION_DATE->AdvancedSearch->SearchOperator2 = @$filter["w_CORRECTION_DATE"];
        $this->CORRECTION_DATE->AdvancedSearch->save();

        // Field DISCOUNT
        $this->DISCOUNT->AdvancedSearch->SearchValue = @$filter["x_DISCOUNT"];
        $this->DISCOUNT->AdvancedSearch->SearchOperator = @$filter["z_DISCOUNT"];
        $this->DISCOUNT->AdvancedSearch->SearchCondition = @$filter["v_DISCOUNT"];
        $this->DISCOUNT->AdvancedSearch->SearchValue2 = @$filter["y_DISCOUNT"];
        $this->DISCOUNT->AdvancedSearch->SearchOperator2 = @$filter["w_DISCOUNT"];
        $this->DISCOUNT->AdvancedSearch->save();

        // Field DISCOUNT2
        $this->DISCOUNT2->AdvancedSearch->SearchValue = @$filter["x_DISCOUNT2"];
        $this->DISCOUNT2->AdvancedSearch->SearchOperator = @$filter["z_DISCOUNT2"];
        $this->DISCOUNT2->AdvancedSearch->SearchCondition = @$filter["v_DISCOUNT2"];
        $this->DISCOUNT2->AdvancedSearch->SearchValue2 = @$filter["y_DISCOUNT2"];
        $this->DISCOUNT2->AdvancedSearch->SearchOperator2 = @$filter["w_DISCOUNT2"];
        $this->DISCOUNT2->AdvancedSearch->save();

        // Field ORG_UNIT_FROM
        $this->ORG_UNIT_FROM->AdvancedSearch->SearchValue = @$filter["x_ORG_UNIT_FROM"];
        $this->ORG_UNIT_FROM->AdvancedSearch->SearchOperator = @$filter["z_ORG_UNIT_FROM"];
        $this->ORG_UNIT_FROM->AdvancedSearch->SearchCondition = @$filter["v_ORG_UNIT_FROM"];
        $this->ORG_UNIT_FROM->AdvancedSearch->SearchValue2 = @$filter["y_ORG_UNIT_FROM"];
        $this->ORG_UNIT_FROM->AdvancedSearch->SearchOperator2 = @$filter["w_ORG_UNIT_FROM"];
        $this->ORG_UNIT_FROM->AdvancedSearch->save();

        // Field DISCOUNTOFF
        $this->DISCOUNTOFF->AdvancedSearch->SearchValue = @$filter["x_DISCOUNTOFF"];
        $this->DISCOUNTOFF->AdvancedSearch->SearchOperator = @$filter["z_DISCOUNTOFF"];
        $this->DISCOUNTOFF->AdvancedSearch->SearchCondition = @$filter["v_DISCOUNTOFF"];
        $this->DISCOUNTOFF->AdvancedSearch->SearchValue2 = @$filter["y_DISCOUNTOFF"];
        $this->DISCOUNTOFF->AdvancedSearch->SearchOperator2 = @$filter["w_DISCOUNTOFF"];
        $this->DISCOUNTOFF->AdvancedSearch->save();

        // Field avgprice
        $this->avgprice->AdvancedSearch->SearchValue = @$filter["x_avgprice"];
        $this->avgprice->AdvancedSearch->SearchOperator = @$filter["z_avgprice"];
        $this->avgprice->AdvancedSearch->SearchCondition = @$filter["v_avgprice"];
        $this->avgprice->AdvancedSearch->SearchValue2 = @$filter["y_avgprice"];
        $this->avgprice->AdvancedSearch->SearchOperator2 = @$filter["w_avgprice"];
        $this->avgprice->AdvancedSearch->save();

        // Field idx
        $this->idx->AdvancedSearch->SearchValue = @$filter["x_idx"];
        $this->idx->AdvancedSearch->SearchOperator = @$filter["z_idx"];
        $this->idx->AdvancedSearch->SearchCondition = @$filter["v_idx"];
        $this->idx->AdvancedSearch->SearchValue2 = @$filter["y_idx"];
        $this->idx->AdvancedSearch->SearchOperator2 = @$filter["w_idx"];
        $this->idx->AdvancedSearch->save();
        $this->BasicSearch->setKeyword(@$filter[Config("TABLE_BASIC_SEARCH")]);
        $this->BasicSearch->setType(@$filter[Config("TABLE_BASIC_SEARCH_TYPE")]);
    }

    // Return basic search SQL
    protected function basicSearchSql($arKeywords, $type)
    {
        $where = "";
        $this->buildBasicSearchSql($where, $this->ORG_UNIT_CODE, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->ITEM_ID, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->ORG_ID, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->RETUR_ID, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->ORDER_ID, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->BATCH_NO, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->BRAND_ID, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->ROOMS_ID, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->SERIAL_NB, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->FROM_ROOMS_ID, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->ISOUTLET, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->INVOICE_ID, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->ALLOCATED_FROM, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->ITEM_ID_FROM, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->MODIFIED_BY, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->PO, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->COMPANY_ID, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->INVOICE_ID2, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->BRAND_NAME, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->DOC_NO, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->ISCETAK, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->PRINTED_BY, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->CORRECTION_DOC, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->CORRECTIONS, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->ORG_UNIT_FROM, $arKeywords, $type);
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
        if (!$Security->canSearch()) {
            return "";
        }
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
            $this->updateSort($this->ITEM_ID); // ITEM_ID
            $this->updateSort($this->ORG_ID); // ORG_ID
            $this->updateSort($this->RETUR_ID); // RETUR_ID
            $this->updateSort($this->ORDER_ID); // ORDER_ID
            $this->updateSort($this->BATCH_NO); // BATCH_NO
            $this->updateSort($this->BRAND_ID); // BRAND_ID
            $this->updateSort($this->ROOMS_ID); // ROOMS_ID
            $this->updateSort($this->SHELF_NO); // SHELF_NO
            $this->updateSort($this->EXPIRY_DATE); // EXPIRY_DATE
            $this->updateSort($this->SERIAL_NB); // SERIAL_NB
            $this->updateSort($this->FROM_ROOMS_ID); // FROM_ROOMS_ID
            $this->updateSort($this->ISOUTLET); // ISOUTLET
            $this->updateSort($this->QUANTITY); // QUANTITY
            $this->updateSort($this->MEASURE_ID); // MEASURE_ID
            $this->updateSort($this->DISTRIBUTION_TYPE); // DISTRIBUTION_TYPE
            $this->updateSort($this->CONDITION); // CONDITION
            $this->updateSort($this->ALLOCATED_DATE); // ALLOCATED_DATE
            $this->updateSort($this->STOCKOPNAME_DATE); // STOCKOPNAME_DATE
            $this->updateSort($this->INVOICE_ID); // INVOICE_ID
            $this->updateSort($this->ALLOCATED_FROM); // ALLOCATED_FROM
            $this->updateSort($this->PRICE); // PRICE
            $this->updateSort($this->ITEM_ID_FROM); // ITEM_ID_FROM
            $this->updateSort($this->MODIFIED_DATE); // MODIFIED_DATE
            $this->updateSort($this->MODIFIED_BY); // MODIFIED_BY
            $this->updateSort($this->STOCK_OPNAME); // STOCK_OPNAME
            $this->updateSort($this->STOK_AWAL); // STOK_AWAL
            $this->updateSort($this->STOCK_LALU); // STOCK_LALU
            $this->updateSort($this->STOCK_KOREKSI); // STOCK_KOREKSI
            $this->updateSort($this->DITERIMA); // DITERIMA
            $this->updateSort($this->DISTRIBUSI); // DISTRIBUSI
            $this->updateSort($this->DIJUAL); // DIJUAL
            $this->updateSort($this->DIHAPUS); // DIHAPUS
            $this->updateSort($this->DIMINTA); // DIMINTA
            $this->updateSort($this->DIRETUR); // DIRETUR
            $this->updateSort($this->PO); // PO
            $this->updateSort($this->COMPANY_ID); // COMPANY_ID
            $this->updateSort($this->FUND_ID); // FUND_ID
            $this->updateSort($this->INVOICE_ID2); // INVOICE_ID2
            $this->updateSort($this->MEASURE_ID3); // MEASURE_ID3
            $this->updateSort($this->SIZE_KEMASAN); // SIZE_KEMASAN
            $this->updateSort($this->BRAND_NAME); // BRAND_NAME
            $this->updateSort($this->MEASURE_ID2); // MEASURE_ID2
            $this->updateSort($this->SIZE_GOODS); // SIZE_GOODS
            $this->updateSort($this->MEASURE_DOSIS); // MEASURE_DOSIS
            $this->updateSort($this->DOC_NO); // DOC_NO
            $this->updateSort($this->ORDER_PRICE); // ORDER_PRICE
            $this->updateSort($this->ISCETAK); // ISCETAK
            $this->updateSort($this->PRINT_DATE); // PRINT_DATE
            $this->updateSort($this->PRINTED_BY); // PRINTED_BY
            $this->updateSort($this->PRINTQ); // PRINTQ
            $this->updateSort($this->STOCK_AVAILABLE); // STOCK_AVAILABLE
            $this->updateSort($this->STATUS_PASIEN_ID); // STATUS_PASIEN_ID
            $this->updateSort($this->MONTH_ID); // MONTH_ID
            $this->updateSort($this->YEAR_ID); // YEAR_ID
            $this->updateSort($this->CORRECTION_DOC); // CORRECTION_DOC
            $this->updateSort($this->CORRECTIONS); // CORRECTIONS
            $this->updateSort($this->CORRECTION_DATE); // CORRECTION_DATE
            $this->updateSort($this->DISCOUNT); // DISCOUNT
            $this->updateSort($this->DISCOUNT2); // DISCOUNT2
            $this->updateSort($this->ORG_UNIT_FROM); // ORG_UNIT_FROM
            $this->updateSort($this->DISCOUNTOFF); // DISCOUNTOFF
            $this->updateSort($this->avgprice); // avgprice
            $this->updateSort($this->idx); // idx
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
                $this->ITEM_ID->setSort("");
                $this->ORG_ID->setSort("");
                $this->RETUR_ID->setSort("");
                $this->ORDER_ID->setSort("");
                $this->BATCH_NO->setSort("");
                $this->BRAND_ID->setSort("");
                $this->ROOMS_ID->setSort("");
                $this->SHELF_NO->setSort("");
                $this->EXPIRY_DATE->setSort("");
                $this->SERIAL_NB->setSort("");
                $this->FROM_ROOMS_ID->setSort("");
                $this->ISOUTLET->setSort("");
                $this->QUANTITY->setSort("");
                $this->MEASURE_ID->setSort("");
                $this->DISTRIBUTION_TYPE->setSort("");
                $this->CONDITION->setSort("");
                $this->ALLOCATED_DATE->setSort("");
                $this->STOCKOPNAME_DATE->setSort("");
                $this->INVOICE_ID->setSort("");
                $this->ALLOCATED_FROM->setSort("");
                $this->PRICE->setSort("");
                $this->ITEM_ID_FROM->setSort("");
                $this->MODIFIED_DATE->setSort("");
                $this->MODIFIED_BY->setSort("");
                $this->STOCK_OPNAME->setSort("");
                $this->STOK_AWAL->setSort("");
                $this->STOCK_LALU->setSort("");
                $this->STOCK_KOREKSI->setSort("");
                $this->DITERIMA->setSort("");
                $this->DISTRIBUSI->setSort("");
                $this->DIJUAL->setSort("");
                $this->DIHAPUS->setSort("");
                $this->DIMINTA->setSort("");
                $this->DIRETUR->setSort("");
                $this->PO->setSort("");
                $this->COMPANY_ID->setSort("");
                $this->FUND_ID->setSort("");
                $this->INVOICE_ID2->setSort("");
                $this->MEASURE_ID3->setSort("");
                $this->SIZE_KEMASAN->setSort("");
                $this->BRAND_NAME->setSort("");
                $this->MEASURE_ID2->setSort("");
                $this->SIZE_GOODS->setSort("");
                $this->MEASURE_DOSIS->setSort("");
                $this->DOC_NO->setSort("");
                $this->ORDER_PRICE->setSort("");
                $this->ISCETAK->setSort("");
                $this->PRINT_DATE->setSort("");
                $this->PRINTED_BY->setSort("");
                $this->PRINTQ->setSort("");
                $this->STOCK_AVAILABLE->setSort("");
                $this->STATUS_PASIEN_ID->setSort("");
                $this->MONTH_ID->setSort("");
                $this->YEAR_ID->setSort("");
                $this->CORRECTION_DOC->setSort("");
                $this->CORRECTIONS->setSort("");
                $this->CORRECTION_DATE->setSort("");
                $this->DISCOUNT->setSort("");
                $this->DISCOUNT2->setSort("");
                $this->ORG_UNIT_FROM->setSort("");
                $this->DISCOUNTOFF->setSort("");
                $this->avgprice->setSort("");
                $this->idx->setSort("");
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
        $item->Visible = $Security->canView();
        $item->OnLeft = true;

        // "edit"
        $item = &$this->ListOptions->add("edit");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->canEdit();
        $item->OnLeft = true;

        // "copy"
        $item = &$this->ListOptions->add("copy");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->canAdd();
        $item->OnLeft = true;

        // "delete"
        $item = &$this->ListOptions->add("delete");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->canDelete();
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
            if ($Security->canView()) {
                $opt->Body = "<a class=\"ew-row-link ew-view\" title=\"" . $viewcaption . "\" data-caption=\"" . $viewcaption . "\" href=\"" . HtmlEncode(GetUrl($this->ViewUrl)) . "\">" . $Language->phrase("ViewLink") . "</a>";
            } else {
                $opt->Body = "";
            }

            // "edit"
            $opt = $this->ListOptions["edit"];
            $editcaption = HtmlTitle($Language->phrase("EditLink"));
            if ($Security->canEdit()) {
                $opt->Body = "<a class=\"ew-row-link ew-edit\" title=\"" . HtmlTitle($Language->phrase("EditLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("EditLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->EditUrl)) . "\">" . $Language->phrase("EditLink") . "</a>";
            } else {
                $opt->Body = "";
            }

            // "copy"
            $opt = $this->ListOptions["copy"];
            $copycaption = HtmlTitle($Language->phrase("CopyLink"));
            if ($Security->canAdd()) {
                $opt->Body = "<a class=\"ew-row-link ew-copy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"" . HtmlEncode(GetUrl($this->CopyUrl)) . "\">" . $Language->phrase("CopyLink") . "</a>";
            } else {
                $opt->Body = "";
            }

            // "delete"
            $opt = $this->ListOptions["delete"];
            if ($Security->canDelete()) {
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
        $opt->Body = "<div class=\"custom-control custom-checkbox d-inline-block\"><input type=\"checkbox\" id=\"key_m_" . $this->RowCount . "\" name=\"key_m[]\" class=\"custom-control-input ew-multi-select\" value=\"" . HtmlEncode($this->ORG_UNIT_CODE->CurrentValue . Config("COMPOSITE_KEY_SEPARATOR") . $this->ITEM_ID->CurrentValue) . "\" onclick=\"ew.clickMultiCheckbox(event);\"><label class=\"custom-control-label\" for=\"key_m_" . $this->RowCount . "\"></label></div>";
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
        $item->Visible = $this->AddUrl != "" && $Security->canAdd();
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
        $item->Body = "<a class=\"ew-save-filter\" data-form=\"fGOOD_MUTATIONlistsrch\" href=\"#\" onclick=\"return false;\">" . $Language->phrase("SaveCurrentFilter") . "</a>";
        $item->Visible = true;
        $item = &$this->FilterOptions->add("deletefilter");
        $item->Body = "<a class=\"ew-delete-filter\" data-form=\"fGOOD_MUTATIONlistsrch\" href=\"#\" onclick=\"return false;\">" . $Language->phrase("DeleteFilter") . "</a>";
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
                $item->Body = '<a class="ew-action ew-list-action" title="' . HtmlEncode($caption) . '" data-caption="' . HtmlEncode($caption) . '" href="#" onclick="return ew.submitAction(event,jQuery.extend({f:document.fGOOD_MUTATIONlist},' . $listaction->toJson(true) . '));">' . $icon . '</a>';
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
        $this->ITEM_ID->setDbValue($row['ITEM_ID']);
        $this->ORG_ID->setDbValue($row['ORG_ID']);
        $this->RETUR_ID->setDbValue($row['RETUR_ID']);
        $this->ORDER_ID->setDbValue($row['ORDER_ID']);
        $this->BATCH_NO->setDbValue($row['BATCH_NO']);
        $this->BRAND_ID->setDbValue($row['BRAND_ID']);
        $this->ROOMS_ID->setDbValue($row['ROOMS_ID']);
        $this->SHELF_NO->setDbValue($row['SHELF_NO']);
        $this->EXPIRY_DATE->setDbValue($row['EXPIRY_DATE']);
        $this->SERIAL_NB->setDbValue($row['SERIAL_NB']);
        $this->FROM_ROOMS_ID->setDbValue($row['FROM_ROOMS_ID']);
        $this->ISOUTLET->setDbValue($row['ISOUTLET']);
        $this->QUANTITY->setDbValue($row['QUANTITY']);
        $this->MEASURE_ID->setDbValue($row['MEASURE_ID']);
        $this->DISTRIBUTION_TYPE->setDbValue($row['DISTRIBUTION_TYPE']);
        $this->CONDITION->setDbValue($row['CONDITION']);
        $this->ALLOCATED_DATE->setDbValue($row['ALLOCATED_DATE']);
        $this->STOCKOPNAME_DATE->setDbValue($row['STOCKOPNAME_DATE']);
        $this->INVOICE_ID->setDbValue($row['INVOICE_ID']);
        $this->ALLOCATED_FROM->setDbValue($row['ALLOCATED_FROM']);
        $this->PRICE->setDbValue($row['PRICE']);
        $this->ITEM_ID_FROM->setDbValue($row['ITEM_ID_FROM']);
        $this->MODIFIED_DATE->setDbValue($row['MODIFIED_DATE']);
        $this->MODIFIED_BY->setDbValue($row['MODIFIED_BY']);
        $this->STOCK_OPNAME->setDbValue($row['STOCK_OPNAME']);
        $this->STOK_AWAL->setDbValue($row['STOK_AWAL']);
        $this->STOCK_LALU->setDbValue($row['STOCK_LALU']);
        $this->STOCK_KOREKSI->setDbValue($row['STOCK_KOREKSI']);
        $this->DITERIMA->setDbValue($row['DITERIMA']);
        $this->DISTRIBUSI->setDbValue($row['DISTRIBUSI']);
        $this->DIJUAL->setDbValue($row['DIJUAL']);
        $this->DIHAPUS->setDbValue($row['DIHAPUS']);
        $this->DIMINTA->setDbValue($row['DIMINTA']);
        $this->DIRETUR->setDbValue($row['DIRETUR']);
        $this->PO->setDbValue($row['PO']);
        $this->COMPANY_ID->setDbValue($row['COMPANY_ID']);
        $this->FUND_ID->setDbValue($row['FUND_ID']);
        $this->INVOICE_ID2->setDbValue($row['INVOICE_ID2']);
        $this->MEASURE_ID3->setDbValue($row['MEASURE_ID3']);
        $this->SIZE_KEMASAN->setDbValue($row['SIZE_KEMASAN']);
        $this->BRAND_NAME->setDbValue($row['BRAND_NAME']);
        $this->MEASURE_ID2->setDbValue($row['MEASURE_ID2']);
        $this->SIZE_GOODS->setDbValue($row['SIZE_GOODS']);
        $this->MEASURE_DOSIS->setDbValue($row['MEASURE_DOSIS']);
        $this->DOC_NO->setDbValue($row['DOC_NO']);
        $this->ORDER_PRICE->setDbValue($row['ORDER_PRICE']);
        $this->ISCETAK->setDbValue($row['ISCETAK']);
        $this->PRINT_DATE->setDbValue($row['PRINT_DATE']);
        $this->PRINTED_BY->setDbValue($row['PRINTED_BY']);
        $this->PRINTQ->setDbValue($row['PRINTQ']);
        $this->STOCK_AVAILABLE->setDbValue($row['STOCK_AVAILABLE']);
        $this->STATUS_PASIEN_ID->setDbValue($row['STATUS_PASIEN_ID']);
        $this->MONTH_ID->setDbValue($row['MONTH_ID']);
        $this->YEAR_ID->setDbValue($row['YEAR_ID']);
        $this->CORRECTION_DOC->setDbValue($row['CORRECTION_DOC']);
        $this->CORRECTIONS->setDbValue($row['CORRECTIONS']);
        $this->CORRECTION_DATE->setDbValue($row['CORRECTION_DATE']);
        $this->DISCOUNT->setDbValue($row['DISCOUNT']);
        $this->DISCOUNT2->setDbValue($row['DISCOUNT2']);
        $this->ORG_UNIT_FROM->setDbValue($row['ORG_UNIT_FROM']);
        $this->DISCOUNTOFF->setDbValue($row['DISCOUNTOFF']);
        $this->avgprice->setDbValue($row['avgprice']);
        $this->idx->setDbValue($row['idx']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['ORG_UNIT_CODE'] = null;
        $row['ITEM_ID'] = null;
        $row['ORG_ID'] = null;
        $row['RETUR_ID'] = null;
        $row['ORDER_ID'] = null;
        $row['BATCH_NO'] = null;
        $row['BRAND_ID'] = null;
        $row['ROOMS_ID'] = null;
        $row['SHELF_NO'] = null;
        $row['EXPIRY_DATE'] = null;
        $row['SERIAL_NB'] = null;
        $row['FROM_ROOMS_ID'] = null;
        $row['ISOUTLET'] = null;
        $row['QUANTITY'] = null;
        $row['MEASURE_ID'] = null;
        $row['DISTRIBUTION_TYPE'] = null;
        $row['CONDITION'] = null;
        $row['ALLOCATED_DATE'] = null;
        $row['STOCKOPNAME_DATE'] = null;
        $row['INVOICE_ID'] = null;
        $row['ALLOCATED_FROM'] = null;
        $row['PRICE'] = null;
        $row['ITEM_ID_FROM'] = null;
        $row['MODIFIED_DATE'] = null;
        $row['MODIFIED_BY'] = null;
        $row['STOCK_OPNAME'] = null;
        $row['STOK_AWAL'] = null;
        $row['STOCK_LALU'] = null;
        $row['STOCK_KOREKSI'] = null;
        $row['DITERIMA'] = null;
        $row['DISTRIBUSI'] = null;
        $row['DIJUAL'] = null;
        $row['DIHAPUS'] = null;
        $row['DIMINTA'] = null;
        $row['DIRETUR'] = null;
        $row['PO'] = null;
        $row['COMPANY_ID'] = null;
        $row['FUND_ID'] = null;
        $row['INVOICE_ID2'] = null;
        $row['MEASURE_ID3'] = null;
        $row['SIZE_KEMASAN'] = null;
        $row['BRAND_NAME'] = null;
        $row['MEASURE_ID2'] = null;
        $row['SIZE_GOODS'] = null;
        $row['MEASURE_DOSIS'] = null;
        $row['DOC_NO'] = null;
        $row['ORDER_PRICE'] = null;
        $row['ISCETAK'] = null;
        $row['PRINT_DATE'] = null;
        $row['PRINTED_BY'] = null;
        $row['PRINTQ'] = null;
        $row['STOCK_AVAILABLE'] = null;
        $row['STATUS_PASIEN_ID'] = null;
        $row['MONTH_ID'] = null;
        $row['YEAR_ID'] = null;
        $row['CORRECTION_DOC'] = null;
        $row['CORRECTIONS'] = null;
        $row['CORRECTION_DATE'] = null;
        $row['DISCOUNT'] = null;
        $row['DISCOUNT2'] = null;
        $row['ORG_UNIT_FROM'] = null;
        $row['DISCOUNTOFF'] = null;
        $row['avgprice'] = null;
        $row['idx'] = null;
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
        if ($this->QUANTITY->FormValue == $this->QUANTITY->CurrentValue && is_numeric(ConvertToFloatString($this->QUANTITY->CurrentValue))) {
            $this->QUANTITY->CurrentValue = ConvertToFloatString($this->QUANTITY->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->PRICE->FormValue == $this->PRICE->CurrentValue && is_numeric(ConvertToFloatString($this->PRICE->CurrentValue))) {
            $this->PRICE->CurrentValue = ConvertToFloatString($this->PRICE->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->STOCK_OPNAME->FormValue == $this->STOCK_OPNAME->CurrentValue && is_numeric(ConvertToFloatString($this->STOCK_OPNAME->CurrentValue))) {
            $this->STOCK_OPNAME->CurrentValue = ConvertToFloatString($this->STOCK_OPNAME->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->STOK_AWAL->FormValue == $this->STOK_AWAL->CurrentValue && is_numeric(ConvertToFloatString($this->STOK_AWAL->CurrentValue))) {
            $this->STOK_AWAL->CurrentValue = ConvertToFloatString($this->STOK_AWAL->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->STOCK_LALU->FormValue == $this->STOCK_LALU->CurrentValue && is_numeric(ConvertToFloatString($this->STOCK_LALU->CurrentValue))) {
            $this->STOCK_LALU->CurrentValue = ConvertToFloatString($this->STOCK_LALU->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->STOCK_KOREKSI->FormValue == $this->STOCK_KOREKSI->CurrentValue && is_numeric(ConvertToFloatString($this->STOCK_KOREKSI->CurrentValue))) {
            $this->STOCK_KOREKSI->CurrentValue = ConvertToFloatString($this->STOCK_KOREKSI->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->DITERIMA->FormValue == $this->DITERIMA->CurrentValue && is_numeric(ConvertToFloatString($this->DITERIMA->CurrentValue))) {
            $this->DITERIMA->CurrentValue = ConvertToFloatString($this->DITERIMA->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->DISTRIBUSI->FormValue == $this->DISTRIBUSI->CurrentValue && is_numeric(ConvertToFloatString($this->DISTRIBUSI->CurrentValue))) {
            $this->DISTRIBUSI->CurrentValue = ConvertToFloatString($this->DISTRIBUSI->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->DIJUAL->FormValue == $this->DIJUAL->CurrentValue && is_numeric(ConvertToFloatString($this->DIJUAL->CurrentValue))) {
            $this->DIJUAL->CurrentValue = ConvertToFloatString($this->DIJUAL->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->DIHAPUS->FormValue == $this->DIHAPUS->CurrentValue && is_numeric(ConvertToFloatString($this->DIHAPUS->CurrentValue))) {
            $this->DIHAPUS->CurrentValue = ConvertToFloatString($this->DIHAPUS->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->DIMINTA->FormValue == $this->DIMINTA->CurrentValue && is_numeric(ConvertToFloatString($this->DIMINTA->CurrentValue))) {
            $this->DIMINTA->CurrentValue = ConvertToFloatString($this->DIMINTA->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->DIRETUR->FormValue == $this->DIRETUR->CurrentValue && is_numeric(ConvertToFloatString($this->DIRETUR->CurrentValue))) {
            $this->DIRETUR->CurrentValue = ConvertToFloatString($this->DIRETUR->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->SIZE_KEMASAN->FormValue == $this->SIZE_KEMASAN->CurrentValue && is_numeric(ConvertToFloatString($this->SIZE_KEMASAN->CurrentValue))) {
            $this->SIZE_KEMASAN->CurrentValue = ConvertToFloatString($this->SIZE_KEMASAN->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->SIZE_GOODS->FormValue == $this->SIZE_GOODS->CurrentValue && is_numeric(ConvertToFloatString($this->SIZE_GOODS->CurrentValue))) {
            $this->SIZE_GOODS->CurrentValue = ConvertToFloatString($this->SIZE_GOODS->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->ORDER_PRICE->FormValue == $this->ORDER_PRICE->CurrentValue && is_numeric(ConvertToFloatString($this->ORDER_PRICE->CurrentValue))) {
            $this->ORDER_PRICE->CurrentValue = ConvertToFloatString($this->ORDER_PRICE->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->STOCK_AVAILABLE->FormValue == $this->STOCK_AVAILABLE->CurrentValue && is_numeric(ConvertToFloatString($this->STOCK_AVAILABLE->CurrentValue))) {
            $this->STOCK_AVAILABLE->CurrentValue = ConvertToFloatString($this->STOCK_AVAILABLE->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->DISCOUNT->FormValue == $this->DISCOUNT->CurrentValue && is_numeric(ConvertToFloatString($this->DISCOUNT->CurrentValue))) {
            $this->DISCOUNT->CurrentValue = ConvertToFloatString($this->DISCOUNT->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->DISCOUNT2->FormValue == $this->DISCOUNT2->CurrentValue && is_numeric(ConvertToFloatString($this->DISCOUNT2->CurrentValue))) {
            $this->DISCOUNT2->CurrentValue = ConvertToFloatString($this->DISCOUNT2->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->DISCOUNTOFF->FormValue == $this->DISCOUNTOFF->CurrentValue && is_numeric(ConvertToFloatString($this->DISCOUNTOFF->CurrentValue))) {
            $this->DISCOUNTOFF->CurrentValue = ConvertToFloatString($this->DISCOUNTOFF->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->avgprice->FormValue == $this->avgprice->CurrentValue && is_numeric(ConvertToFloatString($this->avgprice->CurrentValue))) {
            $this->avgprice->CurrentValue = ConvertToFloatString($this->avgprice->CurrentValue);
        }

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // ORG_UNIT_CODE

        // ITEM_ID

        // ORG_ID

        // RETUR_ID

        // ORDER_ID

        // BATCH_NO

        // BRAND_ID

        // ROOMS_ID

        // SHELF_NO

        // EXPIRY_DATE

        // SERIAL_NB

        // FROM_ROOMS_ID

        // ISOUTLET

        // QUANTITY

        // MEASURE_ID

        // DISTRIBUTION_TYPE

        // CONDITION

        // ALLOCATED_DATE

        // STOCKOPNAME_DATE

        // INVOICE_ID

        // ALLOCATED_FROM

        // PRICE

        // ITEM_ID_FROM

        // MODIFIED_DATE

        // MODIFIED_BY

        // STOCK_OPNAME

        // STOK_AWAL

        // STOCK_LALU

        // STOCK_KOREKSI

        // DITERIMA

        // DISTRIBUSI

        // DIJUAL

        // DIHAPUS

        // DIMINTA

        // DIRETUR

        // PO

        // COMPANY_ID

        // FUND_ID

        // INVOICE_ID2

        // MEASURE_ID3

        // SIZE_KEMASAN

        // BRAND_NAME

        // MEASURE_ID2

        // SIZE_GOODS

        // MEASURE_DOSIS

        // DOC_NO

        // ORDER_PRICE

        // ISCETAK

        // PRINT_DATE

        // PRINTED_BY

        // PRINTQ

        // STOCK_AVAILABLE

        // STATUS_PASIEN_ID

        // MONTH_ID

        // YEAR_ID

        // CORRECTION_DOC

        // CORRECTIONS

        // CORRECTION_DATE

        // DISCOUNT

        // DISCOUNT2

        // ORG_UNIT_FROM

        // DISCOUNTOFF

        // avgprice

        // idx
        if ($this->RowType == ROWTYPE_VIEW) {
            // ORG_UNIT_CODE
            $this->ORG_UNIT_CODE->ViewValue = $this->ORG_UNIT_CODE->CurrentValue;
            $this->ORG_UNIT_CODE->ViewCustomAttributes = "";

            // ITEM_ID
            $this->ITEM_ID->ViewValue = $this->ITEM_ID->CurrentValue;
            $this->ITEM_ID->ViewCustomAttributes = "";

            // ORG_ID
            $this->ORG_ID->ViewValue = $this->ORG_ID->CurrentValue;
            $this->ORG_ID->ViewCustomAttributes = "";

            // RETUR_ID
            $this->RETUR_ID->ViewValue = $this->RETUR_ID->CurrentValue;
            $this->RETUR_ID->ViewCustomAttributes = "";

            // ORDER_ID
            $this->ORDER_ID->ViewValue = $this->ORDER_ID->CurrentValue;
            $this->ORDER_ID->ViewCustomAttributes = "";

            // BATCH_NO
            $this->BATCH_NO->ViewValue = $this->BATCH_NO->CurrentValue;
            $this->BATCH_NO->ViewCustomAttributes = "";

            // BRAND_ID
            $this->BRAND_ID->ViewValue = $this->BRAND_ID->CurrentValue;
            $this->BRAND_ID->ViewCustomAttributes = "";

            // ROOMS_ID
            $this->ROOMS_ID->ViewValue = $this->ROOMS_ID->CurrentValue;
            $this->ROOMS_ID->ViewCustomAttributes = "";

            // SHELF_NO
            $this->SHELF_NO->ViewValue = $this->SHELF_NO->CurrentValue;
            $this->SHELF_NO->ViewValue = FormatNumber($this->SHELF_NO->ViewValue, 0, -2, -2, -2);
            $this->SHELF_NO->ViewCustomAttributes = "";

            // EXPIRY_DATE
            $this->EXPIRY_DATE->ViewValue = $this->EXPIRY_DATE->CurrentValue;
            $this->EXPIRY_DATE->ViewValue = FormatDateTime($this->EXPIRY_DATE->ViewValue, 0);
            $this->EXPIRY_DATE->ViewCustomAttributes = "";

            // SERIAL_NB
            $this->SERIAL_NB->ViewValue = $this->SERIAL_NB->CurrentValue;
            $this->SERIAL_NB->ViewCustomAttributes = "";

            // FROM_ROOMS_ID
            $this->FROM_ROOMS_ID->ViewValue = $this->FROM_ROOMS_ID->CurrentValue;
            $this->FROM_ROOMS_ID->ViewCustomAttributes = "";

            // ISOUTLET
            $this->ISOUTLET->ViewValue = $this->ISOUTLET->CurrentValue;
            $this->ISOUTLET->ViewCustomAttributes = "";

            // QUANTITY
            $this->QUANTITY->ViewValue = $this->QUANTITY->CurrentValue;
            $this->QUANTITY->ViewValue = FormatNumber($this->QUANTITY->ViewValue, 2, -2, -2, -2);
            $this->QUANTITY->ViewCustomAttributes = "";

            // MEASURE_ID
            $this->MEASURE_ID->ViewValue = $this->MEASURE_ID->CurrentValue;
            $this->MEASURE_ID->ViewValue = FormatNumber($this->MEASURE_ID->ViewValue, 0, -2, -2, -2);
            $this->MEASURE_ID->ViewCustomAttributes = "";

            // DISTRIBUTION_TYPE
            $this->DISTRIBUTION_TYPE->ViewValue = $this->DISTRIBUTION_TYPE->CurrentValue;
            $this->DISTRIBUTION_TYPE->ViewValue = FormatNumber($this->DISTRIBUTION_TYPE->ViewValue, 0, -2, -2, -2);
            $this->DISTRIBUTION_TYPE->ViewCustomAttributes = "";

            // CONDITION
            $this->CONDITION->ViewValue = $this->CONDITION->CurrentValue;
            $this->CONDITION->ViewValue = FormatNumber($this->CONDITION->ViewValue, 0, -2, -2, -2);
            $this->CONDITION->ViewCustomAttributes = "";

            // ALLOCATED_DATE
            $this->ALLOCATED_DATE->ViewValue = $this->ALLOCATED_DATE->CurrentValue;
            $this->ALLOCATED_DATE->ViewValue = FormatDateTime($this->ALLOCATED_DATE->ViewValue, 0);
            $this->ALLOCATED_DATE->ViewCustomAttributes = "";

            // STOCKOPNAME_DATE
            $this->STOCKOPNAME_DATE->ViewValue = $this->STOCKOPNAME_DATE->CurrentValue;
            $this->STOCKOPNAME_DATE->ViewValue = FormatDateTime($this->STOCKOPNAME_DATE->ViewValue, 0);
            $this->STOCKOPNAME_DATE->ViewCustomAttributes = "";

            // INVOICE_ID
            $this->INVOICE_ID->ViewValue = $this->INVOICE_ID->CurrentValue;
            $this->INVOICE_ID->ViewCustomAttributes = "";

            // ALLOCATED_FROM
            $this->ALLOCATED_FROM->ViewValue = $this->ALLOCATED_FROM->CurrentValue;
            $this->ALLOCATED_FROM->ViewCustomAttributes = "";

            // PRICE
            $this->PRICE->ViewValue = $this->PRICE->CurrentValue;
            $this->PRICE->ViewValue = FormatNumber($this->PRICE->ViewValue, 2, -2, -2, -2);
            $this->PRICE->ViewCustomAttributes = "";

            // ITEM_ID_FROM
            $this->ITEM_ID_FROM->ViewValue = $this->ITEM_ID_FROM->CurrentValue;
            $this->ITEM_ID_FROM->ViewCustomAttributes = "";

            // MODIFIED_DATE
            $this->MODIFIED_DATE->ViewValue = $this->MODIFIED_DATE->CurrentValue;
            $this->MODIFIED_DATE->ViewValue = FormatDateTime($this->MODIFIED_DATE->ViewValue, 0);
            $this->MODIFIED_DATE->ViewCustomAttributes = "";

            // MODIFIED_BY
            $this->MODIFIED_BY->ViewValue = $this->MODIFIED_BY->CurrentValue;
            $this->MODIFIED_BY->ViewCustomAttributes = "";

            // STOCK_OPNAME
            $this->STOCK_OPNAME->ViewValue = $this->STOCK_OPNAME->CurrentValue;
            $this->STOCK_OPNAME->ViewValue = FormatNumber($this->STOCK_OPNAME->ViewValue, 2, -2, -2, -2);
            $this->STOCK_OPNAME->ViewCustomAttributes = "";

            // STOK_AWAL
            $this->STOK_AWAL->ViewValue = $this->STOK_AWAL->CurrentValue;
            $this->STOK_AWAL->ViewValue = FormatNumber($this->STOK_AWAL->ViewValue, 2, -2, -2, -2);
            $this->STOK_AWAL->ViewCustomAttributes = "";

            // STOCK_LALU
            $this->STOCK_LALU->ViewValue = $this->STOCK_LALU->CurrentValue;
            $this->STOCK_LALU->ViewValue = FormatNumber($this->STOCK_LALU->ViewValue, 2, -2, -2, -2);
            $this->STOCK_LALU->ViewCustomAttributes = "";

            // STOCK_KOREKSI
            $this->STOCK_KOREKSI->ViewValue = $this->STOCK_KOREKSI->CurrentValue;
            $this->STOCK_KOREKSI->ViewValue = FormatNumber($this->STOCK_KOREKSI->ViewValue, 2, -2, -2, -2);
            $this->STOCK_KOREKSI->ViewCustomAttributes = "";

            // DITERIMA
            $this->DITERIMA->ViewValue = $this->DITERIMA->CurrentValue;
            $this->DITERIMA->ViewValue = FormatNumber($this->DITERIMA->ViewValue, 2, -2, -2, -2);
            $this->DITERIMA->ViewCustomAttributes = "";

            // DISTRIBUSI
            $this->DISTRIBUSI->ViewValue = $this->DISTRIBUSI->CurrentValue;
            $this->DISTRIBUSI->ViewValue = FormatNumber($this->DISTRIBUSI->ViewValue, 2, -2, -2, -2);
            $this->DISTRIBUSI->ViewCustomAttributes = "";

            // DIJUAL
            $this->DIJUAL->ViewValue = $this->DIJUAL->CurrentValue;
            $this->DIJUAL->ViewValue = FormatNumber($this->DIJUAL->ViewValue, 2, -2, -2, -2);
            $this->DIJUAL->ViewCustomAttributes = "";

            // DIHAPUS
            $this->DIHAPUS->ViewValue = $this->DIHAPUS->CurrentValue;
            $this->DIHAPUS->ViewValue = FormatNumber($this->DIHAPUS->ViewValue, 2, -2, -2, -2);
            $this->DIHAPUS->ViewCustomAttributes = "";

            // DIMINTA
            $this->DIMINTA->ViewValue = $this->DIMINTA->CurrentValue;
            $this->DIMINTA->ViewValue = FormatNumber($this->DIMINTA->ViewValue, 2, -2, -2, -2);
            $this->DIMINTA->ViewCustomAttributes = "";

            // DIRETUR
            $this->DIRETUR->ViewValue = $this->DIRETUR->CurrentValue;
            $this->DIRETUR->ViewValue = FormatNumber($this->DIRETUR->ViewValue, 2, -2, -2, -2);
            $this->DIRETUR->ViewCustomAttributes = "";

            // PO
            $this->PO->ViewValue = $this->PO->CurrentValue;
            $this->PO->ViewCustomAttributes = "";

            // COMPANY_ID
            $this->COMPANY_ID->ViewValue = $this->COMPANY_ID->CurrentValue;
            $this->COMPANY_ID->ViewCustomAttributes = "";

            // FUND_ID
            $this->FUND_ID->ViewValue = $this->FUND_ID->CurrentValue;
            $this->FUND_ID->ViewValue = FormatNumber($this->FUND_ID->ViewValue, 0, -2, -2, -2);
            $this->FUND_ID->ViewCustomAttributes = "";

            // INVOICE_ID2
            $this->INVOICE_ID2->ViewValue = $this->INVOICE_ID2->CurrentValue;
            $this->INVOICE_ID2->ViewCustomAttributes = "";

            // MEASURE_ID3
            $this->MEASURE_ID3->ViewValue = $this->MEASURE_ID3->CurrentValue;
            $this->MEASURE_ID3->ViewValue = FormatNumber($this->MEASURE_ID3->ViewValue, 0, -2, -2, -2);
            $this->MEASURE_ID3->ViewCustomAttributes = "";

            // SIZE_KEMASAN
            $this->SIZE_KEMASAN->ViewValue = $this->SIZE_KEMASAN->CurrentValue;
            $this->SIZE_KEMASAN->ViewValue = FormatNumber($this->SIZE_KEMASAN->ViewValue, 2, -2, -2, -2);
            $this->SIZE_KEMASAN->ViewCustomAttributes = "";

            // BRAND_NAME
            $this->BRAND_NAME->ViewValue = $this->BRAND_NAME->CurrentValue;
            $this->BRAND_NAME->ViewCustomAttributes = "";

            // MEASURE_ID2
            $this->MEASURE_ID2->ViewValue = $this->MEASURE_ID2->CurrentValue;
            $this->MEASURE_ID2->ViewValue = FormatNumber($this->MEASURE_ID2->ViewValue, 0, -2, -2, -2);
            $this->MEASURE_ID2->ViewCustomAttributes = "";

            // SIZE_GOODS
            $this->SIZE_GOODS->ViewValue = $this->SIZE_GOODS->CurrentValue;
            $this->SIZE_GOODS->ViewValue = FormatNumber($this->SIZE_GOODS->ViewValue, 2, -2, -2, -2);
            $this->SIZE_GOODS->ViewCustomAttributes = "";

            // MEASURE_DOSIS
            $this->MEASURE_DOSIS->ViewValue = $this->MEASURE_DOSIS->CurrentValue;
            $this->MEASURE_DOSIS->ViewValue = FormatNumber($this->MEASURE_DOSIS->ViewValue, 0, -2, -2, -2);
            $this->MEASURE_DOSIS->ViewCustomAttributes = "";

            // DOC_NO
            $this->DOC_NO->ViewValue = $this->DOC_NO->CurrentValue;
            $this->DOC_NO->ViewCustomAttributes = "";

            // ORDER_PRICE
            $this->ORDER_PRICE->ViewValue = $this->ORDER_PRICE->CurrentValue;
            $this->ORDER_PRICE->ViewValue = FormatNumber($this->ORDER_PRICE->ViewValue, 2, -2, -2, -2);
            $this->ORDER_PRICE->ViewCustomAttributes = "";

            // ISCETAK
            $this->ISCETAK->ViewValue = $this->ISCETAK->CurrentValue;
            $this->ISCETAK->ViewCustomAttributes = "";

            // PRINT_DATE
            $this->PRINT_DATE->ViewValue = $this->PRINT_DATE->CurrentValue;
            $this->PRINT_DATE->ViewValue = FormatDateTime($this->PRINT_DATE->ViewValue, 0);
            $this->PRINT_DATE->ViewCustomAttributes = "";

            // PRINTED_BY
            $this->PRINTED_BY->ViewValue = $this->PRINTED_BY->CurrentValue;
            $this->PRINTED_BY->ViewCustomAttributes = "";

            // PRINTQ
            $this->PRINTQ->ViewValue = $this->PRINTQ->CurrentValue;
            $this->PRINTQ->ViewValue = FormatNumber($this->PRINTQ->ViewValue, 0, -2, -2, -2);
            $this->PRINTQ->ViewCustomAttributes = "";

            // STOCK_AVAILABLE
            $this->STOCK_AVAILABLE->ViewValue = $this->STOCK_AVAILABLE->CurrentValue;
            $this->STOCK_AVAILABLE->ViewValue = FormatNumber($this->STOCK_AVAILABLE->ViewValue, 2, -2, -2, -2);
            $this->STOCK_AVAILABLE->ViewCustomAttributes = "";

            // STATUS_PASIEN_ID
            $this->STATUS_PASIEN_ID->ViewValue = $this->STATUS_PASIEN_ID->CurrentValue;
            $this->STATUS_PASIEN_ID->ViewValue = FormatNumber($this->STATUS_PASIEN_ID->ViewValue, 0, -2, -2, -2);
            $this->STATUS_PASIEN_ID->ViewCustomAttributes = "";

            // MONTH_ID
            $this->MONTH_ID->ViewValue = $this->MONTH_ID->CurrentValue;
            $this->MONTH_ID->ViewValue = FormatNumber($this->MONTH_ID->ViewValue, 0, -2, -2, -2);
            $this->MONTH_ID->ViewCustomAttributes = "";

            // YEAR_ID
            $this->YEAR_ID->ViewValue = $this->YEAR_ID->CurrentValue;
            $this->YEAR_ID->ViewValue = FormatNumber($this->YEAR_ID->ViewValue, 0, -2, -2, -2);
            $this->YEAR_ID->ViewCustomAttributes = "";

            // CORRECTION_DOC
            $this->CORRECTION_DOC->ViewValue = $this->CORRECTION_DOC->CurrentValue;
            $this->CORRECTION_DOC->ViewCustomAttributes = "";

            // CORRECTIONS
            $this->CORRECTIONS->ViewValue = $this->CORRECTIONS->CurrentValue;
            $this->CORRECTIONS->ViewCustomAttributes = "";

            // CORRECTION_DATE
            $this->CORRECTION_DATE->ViewValue = $this->CORRECTION_DATE->CurrentValue;
            $this->CORRECTION_DATE->ViewValue = FormatDateTime($this->CORRECTION_DATE->ViewValue, 0);
            $this->CORRECTION_DATE->ViewCustomAttributes = "";

            // DISCOUNT
            $this->DISCOUNT->ViewValue = $this->DISCOUNT->CurrentValue;
            $this->DISCOUNT->ViewValue = FormatNumber($this->DISCOUNT->ViewValue, 2, -2, -2, -2);
            $this->DISCOUNT->ViewCustomAttributes = "";

            // DISCOUNT2
            $this->DISCOUNT2->ViewValue = $this->DISCOUNT2->CurrentValue;
            $this->DISCOUNT2->ViewValue = FormatNumber($this->DISCOUNT2->ViewValue, 2, -2, -2, -2);
            $this->DISCOUNT2->ViewCustomAttributes = "";

            // ORG_UNIT_FROM
            $this->ORG_UNIT_FROM->ViewValue = $this->ORG_UNIT_FROM->CurrentValue;
            $this->ORG_UNIT_FROM->ViewCustomAttributes = "";

            // DISCOUNTOFF
            $this->DISCOUNTOFF->ViewValue = $this->DISCOUNTOFF->CurrentValue;
            $this->DISCOUNTOFF->ViewValue = FormatNumber($this->DISCOUNTOFF->ViewValue, 2, -2, -2, -2);
            $this->DISCOUNTOFF->ViewCustomAttributes = "";

            // avgprice
            $this->avgprice->ViewValue = $this->avgprice->CurrentValue;
            $this->avgprice->ViewValue = FormatNumber($this->avgprice->ViewValue, 2, -2, -2, -2);
            $this->avgprice->ViewCustomAttributes = "";

            // idx
            $this->idx->ViewValue = $this->idx->CurrentValue;
            $this->idx->ViewValue = FormatNumber($this->idx->ViewValue, 0, -2, -2, -2);
            $this->idx->ViewCustomAttributes = "";

            // ORG_UNIT_CODE
            $this->ORG_UNIT_CODE->LinkCustomAttributes = "";
            $this->ORG_UNIT_CODE->HrefValue = "";
            $this->ORG_UNIT_CODE->TooltipValue = "";

            // ITEM_ID
            $this->ITEM_ID->LinkCustomAttributes = "";
            $this->ITEM_ID->HrefValue = "";
            $this->ITEM_ID->TooltipValue = "";

            // ORG_ID
            $this->ORG_ID->LinkCustomAttributes = "";
            $this->ORG_ID->HrefValue = "";
            $this->ORG_ID->TooltipValue = "";

            // RETUR_ID
            $this->RETUR_ID->LinkCustomAttributes = "";
            $this->RETUR_ID->HrefValue = "";
            $this->RETUR_ID->TooltipValue = "";

            // ORDER_ID
            $this->ORDER_ID->LinkCustomAttributes = "";
            $this->ORDER_ID->HrefValue = "";
            $this->ORDER_ID->TooltipValue = "";

            // BATCH_NO
            $this->BATCH_NO->LinkCustomAttributes = "";
            $this->BATCH_NO->HrefValue = "";
            $this->BATCH_NO->TooltipValue = "";

            // BRAND_ID
            $this->BRAND_ID->LinkCustomAttributes = "";
            $this->BRAND_ID->HrefValue = "";
            $this->BRAND_ID->TooltipValue = "";

            // ROOMS_ID
            $this->ROOMS_ID->LinkCustomAttributes = "";
            $this->ROOMS_ID->HrefValue = "";
            $this->ROOMS_ID->TooltipValue = "";

            // SHELF_NO
            $this->SHELF_NO->LinkCustomAttributes = "";
            $this->SHELF_NO->HrefValue = "";
            $this->SHELF_NO->TooltipValue = "";

            // EXPIRY_DATE
            $this->EXPIRY_DATE->LinkCustomAttributes = "";
            $this->EXPIRY_DATE->HrefValue = "";
            $this->EXPIRY_DATE->TooltipValue = "";

            // SERIAL_NB
            $this->SERIAL_NB->LinkCustomAttributes = "";
            $this->SERIAL_NB->HrefValue = "";
            $this->SERIAL_NB->TooltipValue = "";

            // FROM_ROOMS_ID
            $this->FROM_ROOMS_ID->LinkCustomAttributes = "";
            $this->FROM_ROOMS_ID->HrefValue = "";
            $this->FROM_ROOMS_ID->TooltipValue = "";

            // ISOUTLET
            $this->ISOUTLET->LinkCustomAttributes = "";
            $this->ISOUTLET->HrefValue = "";
            $this->ISOUTLET->TooltipValue = "";

            // QUANTITY
            $this->QUANTITY->LinkCustomAttributes = "";
            $this->QUANTITY->HrefValue = "";
            $this->QUANTITY->TooltipValue = "";

            // MEASURE_ID
            $this->MEASURE_ID->LinkCustomAttributes = "";
            $this->MEASURE_ID->HrefValue = "";
            $this->MEASURE_ID->TooltipValue = "";

            // DISTRIBUTION_TYPE
            $this->DISTRIBUTION_TYPE->LinkCustomAttributes = "";
            $this->DISTRIBUTION_TYPE->HrefValue = "";
            $this->DISTRIBUTION_TYPE->TooltipValue = "";

            // CONDITION
            $this->CONDITION->LinkCustomAttributes = "";
            $this->CONDITION->HrefValue = "";
            $this->CONDITION->TooltipValue = "";

            // ALLOCATED_DATE
            $this->ALLOCATED_DATE->LinkCustomAttributes = "";
            $this->ALLOCATED_DATE->HrefValue = "";
            $this->ALLOCATED_DATE->TooltipValue = "";

            // STOCKOPNAME_DATE
            $this->STOCKOPNAME_DATE->LinkCustomAttributes = "";
            $this->STOCKOPNAME_DATE->HrefValue = "";
            $this->STOCKOPNAME_DATE->TooltipValue = "";

            // INVOICE_ID
            $this->INVOICE_ID->LinkCustomAttributes = "";
            $this->INVOICE_ID->HrefValue = "";
            $this->INVOICE_ID->TooltipValue = "";

            // ALLOCATED_FROM
            $this->ALLOCATED_FROM->LinkCustomAttributes = "";
            $this->ALLOCATED_FROM->HrefValue = "";
            $this->ALLOCATED_FROM->TooltipValue = "";

            // PRICE
            $this->PRICE->LinkCustomAttributes = "";
            $this->PRICE->HrefValue = "";
            $this->PRICE->TooltipValue = "";

            // ITEM_ID_FROM
            $this->ITEM_ID_FROM->LinkCustomAttributes = "";
            $this->ITEM_ID_FROM->HrefValue = "";
            $this->ITEM_ID_FROM->TooltipValue = "";

            // MODIFIED_DATE
            $this->MODIFIED_DATE->LinkCustomAttributes = "";
            $this->MODIFIED_DATE->HrefValue = "";
            $this->MODIFIED_DATE->TooltipValue = "";

            // MODIFIED_BY
            $this->MODIFIED_BY->LinkCustomAttributes = "";
            $this->MODIFIED_BY->HrefValue = "";
            $this->MODIFIED_BY->TooltipValue = "";

            // STOCK_OPNAME
            $this->STOCK_OPNAME->LinkCustomAttributes = "";
            $this->STOCK_OPNAME->HrefValue = "";
            $this->STOCK_OPNAME->TooltipValue = "";

            // STOK_AWAL
            $this->STOK_AWAL->LinkCustomAttributes = "";
            $this->STOK_AWAL->HrefValue = "";
            $this->STOK_AWAL->TooltipValue = "";

            // STOCK_LALU
            $this->STOCK_LALU->LinkCustomAttributes = "";
            $this->STOCK_LALU->HrefValue = "";
            $this->STOCK_LALU->TooltipValue = "";

            // STOCK_KOREKSI
            $this->STOCK_KOREKSI->LinkCustomAttributes = "";
            $this->STOCK_KOREKSI->HrefValue = "";
            $this->STOCK_KOREKSI->TooltipValue = "";

            // DITERIMA
            $this->DITERIMA->LinkCustomAttributes = "";
            $this->DITERIMA->HrefValue = "";
            $this->DITERIMA->TooltipValue = "";

            // DISTRIBUSI
            $this->DISTRIBUSI->LinkCustomAttributes = "";
            $this->DISTRIBUSI->HrefValue = "";
            $this->DISTRIBUSI->TooltipValue = "";

            // DIJUAL
            $this->DIJUAL->LinkCustomAttributes = "";
            $this->DIJUAL->HrefValue = "";
            $this->DIJUAL->TooltipValue = "";

            // DIHAPUS
            $this->DIHAPUS->LinkCustomAttributes = "";
            $this->DIHAPUS->HrefValue = "";
            $this->DIHAPUS->TooltipValue = "";

            // DIMINTA
            $this->DIMINTA->LinkCustomAttributes = "";
            $this->DIMINTA->HrefValue = "";
            $this->DIMINTA->TooltipValue = "";

            // DIRETUR
            $this->DIRETUR->LinkCustomAttributes = "";
            $this->DIRETUR->HrefValue = "";
            $this->DIRETUR->TooltipValue = "";

            // PO
            $this->PO->LinkCustomAttributes = "";
            $this->PO->HrefValue = "";
            $this->PO->TooltipValue = "";

            // COMPANY_ID
            $this->COMPANY_ID->LinkCustomAttributes = "";
            $this->COMPANY_ID->HrefValue = "";
            $this->COMPANY_ID->TooltipValue = "";

            // FUND_ID
            $this->FUND_ID->LinkCustomAttributes = "";
            $this->FUND_ID->HrefValue = "";
            $this->FUND_ID->TooltipValue = "";

            // INVOICE_ID2
            $this->INVOICE_ID2->LinkCustomAttributes = "";
            $this->INVOICE_ID2->HrefValue = "";
            $this->INVOICE_ID2->TooltipValue = "";

            // MEASURE_ID3
            $this->MEASURE_ID3->LinkCustomAttributes = "";
            $this->MEASURE_ID3->HrefValue = "";
            $this->MEASURE_ID3->TooltipValue = "";

            // SIZE_KEMASAN
            $this->SIZE_KEMASAN->LinkCustomAttributes = "";
            $this->SIZE_KEMASAN->HrefValue = "";
            $this->SIZE_KEMASAN->TooltipValue = "";

            // BRAND_NAME
            $this->BRAND_NAME->LinkCustomAttributes = "";
            $this->BRAND_NAME->HrefValue = "";
            $this->BRAND_NAME->TooltipValue = "";

            // MEASURE_ID2
            $this->MEASURE_ID2->LinkCustomAttributes = "";
            $this->MEASURE_ID2->HrefValue = "";
            $this->MEASURE_ID2->TooltipValue = "";

            // SIZE_GOODS
            $this->SIZE_GOODS->LinkCustomAttributes = "";
            $this->SIZE_GOODS->HrefValue = "";
            $this->SIZE_GOODS->TooltipValue = "";

            // MEASURE_DOSIS
            $this->MEASURE_DOSIS->LinkCustomAttributes = "";
            $this->MEASURE_DOSIS->HrefValue = "";
            $this->MEASURE_DOSIS->TooltipValue = "";

            // DOC_NO
            $this->DOC_NO->LinkCustomAttributes = "";
            $this->DOC_NO->HrefValue = "";
            $this->DOC_NO->TooltipValue = "";

            // ORDER_PRICE
            $this->ORDER_PRICE->LinkCustomAttributes = "";
            $this->ORDER_PRICE->HrefValue = "";
            $this->ORDER_PRICE->TooltipValue = "";

            // ISCETAK
            $this->ISCETAK->LinkCustomAttributes = "";
            $this->ISCETAK->HrefValue = "";
            $this->ISCETAK->TooltipValue = "";

            // PRINT_DATE
            $this->PRINT_DATE->LinkCustomAttributes = "";
            $this->PRINT_DATE->HrefValue = "";
            $this->PRINT_DATE->TooltipValue = "";

            // PRINTED_BY
            $this->PRINTED_BY->LinkCustomAttributes = "";
            $this->PRINTED_BY->HrefValue = "";
            $this->PRINTED_BY->TooltipValue = "";

            // PRINTQ
            $this->PRINTQ->LinkCustomAttributes = "";
            $this->PRINTQ->HrefValue = "";
            $this->PRINTQ->TooltipValue = "";

            // STOCK_AVAILABLE
            $this->STOCK_AVAILABLE->LinkCustomAttributes = "";
            $this->STOCK_AVAILABLE->HrefValue = "";
            $this->STOCK_AVAILABLE->TooltipValue = "";

            // STATUS_PASIEN_ID
            $this->STATUS_PASIEN_ID->LinkCustomAttributes = "";
            $this->STATUS_PASIEN_ID->HrefValue = "";
            $this->STATUS_PASIEN_ID->TooltipValue = "";

            // MONTH_ID
            $this->MONTH_ID->LinkCustomAttributes = "";
            $this->MONTH_ID->HrefValue = "";
            $this->MONTH_ID->TooltipValue = "";

            // YEAR_ID
            $this->YEAR_ID->LinkCustomAttributes = "";
            $this->YEAR_ID->HrefValue = "";
            $this->YEAR_ID->TooltipValue = "";

            // CORRECTION_DOC
            $this->CORRECTION_DOC->LinkCustomAttributes = "";
            $this->CORRECTION_DOC->HrefValue = "";
            $this->CORRECTION_DOC->TooltipValue = "";

            // CORRECTIONS
            $this->CORRECTIONS->LinkCustomAttributes = "";
            $this->CORRECTIONS->HrefValue = "";
            $this->CORRECTIONS->TooltipValue = "";

            // CORRECTION_DATE
            $this->CORRECTION_DATE->LinkCustomAttributes = "";
            $this->CORRECTION_DATE->HrefValue = "";
            $this->CORRECTION_DATE->TooltipValue = "";

            // DISCOUNT
            $this->DISCOUNT->LinkCustomAttributes = "";
            $this->DISCOUNT->HrefValue = "";
            $this->DISCOUNT->TooltipValue = "";

            // DISCOUNT2
            $this->DISCOUNT2->LinkCustomAttributes = "";
            $this->DISCOUNT2->HrefValue = "";
            $this->DISCOUNT2->TooltipValue = "";

            // ORG_UNIT_FROM
            $this->ORG_UNIT_FROM->LinkCustomAttributes = "";
            $this->ORG_UNIT_FROM->HrefValue = "";
            $this->ORG_UNIT_FROM->TooltipValue = "";

            // DISCOUNTOFF
            $this->DISCOUNTOFF->LinkCustomAttributes = "";
            $this->DISCOUNTOFF->HrefValue = "";
            $this->DISCOUNTOFF->TooltipValue = "";

            // avgprice
            $this->avgprice->LinkCustomAttributes = "";
            $this->avgprice->HrefValue = "";
            $this->avgprice->TooltipValue = "";

            // idx
            $this->idx->LinkCustomAttributes = "";
            $this->idx->HrefValue = "";
            $this->idx->TooltipValue = "";
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
        $item->Body = "<a class=\"btn btn-default ew-search-toggle" . $searchToggleClass . "\" href=\"#\" role=\"button\" title=\"" . $Language->phrase("SearchPanel") . "\" data-caption=\"" . $Language->phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fGOOD_MUTATIONlistsrch\" aria-pressed=\"" . ($searchToggleClass == " active" ? "true" : "false") . "\">" . $Language->phrase("SearchLink") . "</a>";
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
