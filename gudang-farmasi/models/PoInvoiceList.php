<?php

namespace PHPMaker2021\SIMRSSQLSERVERGUDANGFARMASI;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class PoInvoiceList extends PoInvoice
{
    use MessagesTrait;

    // Page ID
    public $PageID = "list";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'PO_INVOICE';

    // Page object name
    public $PageObjName = "PoInvoiceList";

    // Rendering View
    public $RenderingView = false;

    // Grid form hidden field names
    public $FormName = "fPO_INVOICElist";
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

        // Table object (PO_INVOICE)
        if (!isset($GLOBALS["PO_INVOICE"]) || get_class($GLOBALS["PO_INVOICE"]) == PROJECT_NAMESPACE . "PO_INVOICE") {
            $GLOBALS["PO_INVOICE"] = &$this;
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
        $this->AddUrl = "PoInvoiceAdd";
        $this->InlineAddUrl = $pageUrl . "action=add";
        $this->GridAddUrl = $pageUrl . "action=gridadd";
        $this->GridEditUrl = $pageUrl . "action=gridedit";
        $this->MultiDeleteUrl = "PoInvoiceDelete";
        $this->MultiUpdateUrl = "PoInvoiceUpdate";

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'PO_INVOICE');
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
        $this->FilterOptions->TagClassName = "ew-filter-option fPO_INVOICElistsrch";

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
                $doc = new $class(Container("PO_INVOICE"));
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
            $key .= @$ar['INVOICE_ID'];
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
        $this->INVOICE_ID->setVisibility();
        $this->INVOICE_ID2->setVisibility();
        $this->INVOICE_DATE->setVisibility();
        $this->PO->setVisibility();
        $this->COMPANY_ID->setVisibility();
        $this->RECEIVED_DATE->setVisibility();
        $this->AMOUNT->setVisibility();
        $this->PAYMENT_DUE->setVisibility();
        $this->DESCRIPTION->setVisibility();
        $this->MODIFIED_DATE->setVisibility();
        $this->MODIFIED_BY->setVisibility();
        $this->RECEIVED_BY->setVisibility();
        $this->PRIORITY->setVisibility();
        $this->CREDIT_NOTE->setVisibility();
        $this->CREDIT_AMOUNT->setVisibility();
        $this->PPN->setVisibility();
        $this->MATERAI->setVisibility();
        $this->SENT_BY->setVisibility();
        $this->ACCOUNT_ID->setVisibility();
        $this->FINANCE_ID->setVisibility();
        $this->potongan->setVisibility();
        $this->RECEIVED_VALUE->setVisibility();
        $this->NO_ORDER->setVisibility();
        $this->CONTRACT_NO->setVisibility();
        $this->ORG_ID->setVisibility();
        $this->CLINIC_ID->setVisibility();
        $this->PPN_VALUE->setVisibility();
        $this->DISCOUNT_VALUE->setVisibility();
        $this->PAID_VALUE->setVisibility();
        $this->ISCETAK->setVisibility();
        $this->PRINT_DATE->setVisibility();
        $this->PRINTED_BY->setVisibility();
        $this->PRINTQ->setVisibility();
        $this->FAKTUR_DATE->setVisibility();
        $this->DISTRIBUTION_TYPE->setVisibility();
        $this->DISCOUNTOFF_VALUE->setVisibility();
        $this->THECOUNTER->setVisibility();
        $this->FUND_ID->setVisibility();
        $this->ORDER_BY->setVisibility();
        $this->ACKNOWLEDGEBY->setVisibility();
        $this->NUM->setVisibility();
        $this->ISPO->setVisibility();
        $this->DOCS_TYPE->setVisibility();
        $this->PO_DATE->setVisibility();
        $this->PO_VALUE->setVisibility();
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
        $filterList = Concat($filterList, $this->INVOICE_ID->AdvancedSearch->toJson(), ","); // Field INVOICE_ID
        $filterList = Concat($filterList, $this->INVOICE_ID2->AdvancedSearch->toJson(), ","); // Field INVOICE_ID2
        $filterList = Concat($filterList, $this->INVOICE_DATE->AdvancedSearch->toJson(), ","); // Field INVOICE_DATE
        $filterList = Concat($filterList, $this->PO->AdvancedSearch->toJson(), ","); // Field PO
        $filterList = Concat($filterList, $this->COMPANY_ID->AdvancedSearch->toJson(), ","); // Field COMPANY_ID
        $filterList = Concat($filterList, $this->RECEIVED_DATE->AdvancedSearch->toJson(), ","); // Field RECEIVED_DATE
        $filterList = Concat($filterList, $this->AMOUNT->AdvancedSearch->toJson(), ","); // Field AMOUNT
        $filterList = Concat($filterList, $this->PAYMENT_DUE->AdvancedSearch->toJson(), ","); // Field PAYMENT_DUE
        $filterList = Concat($filterList, $this->DESCRIPTION->AdvancedSearch->toJson(), ","); // Field DESCRIPTION
        $filterList = Concat($filterList, $this->MODIFIED_DATE->AdvancedSearch->toJson(), ","); // Field MODIFIED_DATE
        $filterList = Concat($filterList, $this->MODIFIED_BY->AdvancedSearch->toJson(), ","); // Field MODIFIED_BY
        $filterList = Concat($filterList, $this->RECEIVED_BY->AdvancedSearch->toJson(), ","); // Field RECEIVED_BY
        $filterList = Concat($filterList, $this->PRIORITY->AdvancedSearch->toJson(), ","); // Field PRIORITY
        $filterList = Concat($filterList, $this->CREDIT_NOTE->AdvancedSearch->toJson(), ","); // Field CREDIT_NOTE
        $filterList = Concat($filterList, $this->CREDIT_AMOUNT->AdvancedSearch->toJson(), ","); // Field CREDIT_AMOUNT
        $filterList = Concat($filterList, $this->PPN->AdvancedSearch->toJson(), ","); // Field PPN
        $filterList = Concat($filterList, $this->MATERAI->AdvancedSearch->toJson(), ","); // Field MATERAI
        $filterList = Concat($filterList, $this->SENT_BY->AdvancedSearch->toJson(), ","); // Field SENT_BY
        $filterList = Concat($filterList, $this->ACCOUNT_ID->AdvancedSearch->toJson(), ","); // Field ACCOUNT_ID
        $filterList = Concat($filterList, $this->FINANCE_ID->AdvancedSearch->toJson(), ","); // Field FINANCE_ID
        $filterList = Concat($filterList, $this->potongan->AdvancedSearch->toJson(), ","); // Field potongan
        $filterList = Concat($filterList, $this->RECEIVED_VALUE->AdvancedSearch->toJson(), ","); // Field RECEIVED_VALUE
        $filterList = Concat($filterList, $this->NO_ORDER->AdvancedSearch->toJson(), ","); // Field NO_ORDER
        $filterList = Concat($filterList, $this->CONTRACT_NO->AdvancedSearch->toJson(), ","); // Field CONTRACT_NO
        $filterList = Concat($filterList, $this->ORG_ID->AdvancedSearch->toJson(), ","); // Field ORG_ID
        $filterList = Concat($filterList, $this->CLINIC_ID->AdvancedSearch->toJson(), ","); // Field CLINIC_ID
        $filterList = Concat($filterList, $this->PPN_VALUE->AdvancedSearch->toJson(), ","); // Field PPN_VALUE
        $filterList = Concat($filterList, $this->DISCOUNT_VALUE->AdvancedSearch->toJson(), ","); // Field DISCOUNT_VALUE
        $filterList = Concat($filterList, $this->PAID_VALUE->AdvancedSearch->toJson(), ","); // Field PAID_VALUE
        $filterList = Concat($filterList, $this->ISCETAK->AdvancedSearch->toJson(), ","); // Field ISCETAK
        $filterList = Concat($filterList, $this->PRINT_DATE->AdvancedSearch->toJson(), ","); // Field PRINT_DATE
        $filterList = Concat($filterList, $this->PRINTED_BY->AdvancedSearch->toJson(), ","); // Field PRINTED_BY
        $filterList = Concat($filterList, $this->PRINTQ->AdvancedSearch->toJson(), ","); // Field PRINTQ
        $filterList = Concat($filterList, $this->FAKTUR_DATE->AdvancedSearch->toJson(), ","); // Field FAKTUR_DATE
        $filterList = Concat($filterList, $this->DISTRIBUTION_TYPE->AdvancedSearch->toJson(), ","); // Field DISTRIBUTION_TYPE
        $filterList = Concat($filterList, $this->DISCOUNTOFF_VALUE->AdvancedSearch->toJson(), ","); // Field DISCOUNTOFF_VALUE
        $filterList = Concat($filterList, $this->THECOUNTER->AdvancedSearch->toJson(), ","); // Field THECOUNTER
        $filterList = Concat($filterList, $this->FUND_ID->AdvancedSearch->toJson(), ","); // Field FUND_ID
        $filterList = Concat($filterList, $this->ORDER_BY->AdvancedSearch->toJson(), ","); // Field ORDER_BY
        $filterList = Concat($filterList, $this->ACKNOWLEDGEBY->AdvancedSearch->toJson(), ","); // Field ACKNOWLEDGEBY
        $filterList = Concat($filterList, $this->NUM->AdvancedSearch->toJson(), ","); // Field NUM
        $filterList = Concat($filterList, $this->ISPO->AdvancedSearch->toJson(), ","); // Field ISPO
        $filterList = Concat($filterList, $this->DOCS_TYPE->AdvancedSearch->toJson(), ","); // Field DOCS_TYPE
        $filterList = Concat($filterList, $this->PO_DATE->AdvancedSearch->toJson(), ","); // Field PO_DATE
        $filterList = Concat($filterList, $this->PO_VALUE->AdvancedSearch->toJson(), ","); // Field PO_VALUE
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
            $UserProfile->setSearchFilters(CurrentUserName(), "fPO_INVOICElistsrch", $filters);
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

        // Field INVOICE_ID
        $this->INVOICE_ID->AdvancedSearch->SearchValue = @$filter["x_INVOICE_ID"];
        $this->INVOICE_ID->AdvancedSearch->SearchOperator = @$filter["z_INVOICE_ID"];
        $this->INVOICE_ID->AdvancedSearch->SearchCondition = @$filter["v_INVOICE_ID"];
        $this->INVOICE_ID->AdvancedSearch->SearchValue2 = @$filter["y_INVOICE_ID"];
        $this->INVOICE_ID->AdvancedSearch->SearchOperator2 = @$filter["w_INVOICE_ID"];
        $this->INVOICE_ID->AdvancedSearch->save();

        // Field INVOICE_ID2
        $this->INVOICE_ID2->AdvancedSearch->SearchValue = @$filter["x_INVOICE_ID2"];
        $this->INVOICE_ID2->AdvancedSearch->SearchOperator = @$filter["z_INVOICE_ID2"];
        $this->INVOICE_ID2->AdvancedSearch->SearchCondition = @$filter["v_INVOICE_ID2"];
        $this->INVOICE_ID2->AdvancedSearch->SearchValue2 = @$filter["y_INVOICE_ID2"];
        $this->INVOICE_ID2->AdvancedSearch->SearchOperator2 = @$filter["w_INVOICE_ID2"];
        $this->INVOICE_ID2->AdvancedSearch->save();

        // Field INVOICE_DATE
        $this->INVOICE_DATE->AdvancedSearch->SearchValue = @$filter["x_INVOICE_DATE"];
        $this->INVOICE_DATE->AdvancedSearch->SearchOperator = @$filter["z_INVOICE_DATE"];
        $this->INVOICE_DATE->AdvancedSearch->SearchCondition = @$filter["v_INVOICE_DATE"];
        $this->INVOICE_DATE->AdvancedSearch->SearchValue2 = @$filter["y_INVOICE_DATE"];
        $this->INVOICE_DATE->AdvancedSearch->SearchOperator2 = @$filter["w_INVOICE_DATE"];
        $this->INVOICE_DATE->AdvancedSearch->save();

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

        // Field RECEIVED_DATE
        $this->RECEIVED_DATE->AdvancedSearch->SearchValue = @$filter["x_RECEIVED_DATE"];
        $this->RECEIVED_DATE->AdvancedSearch->SearchOperator = @$filter["z_RECEIVED_DATE"];
        $this->RECEIVED_DATE->AdvancedSearch->SearchCondition = @$filter["v_RECEIVED_DATE"];
        $this->RECEIVED_DATE->AdvancedSearch->SearchValue2 = @$filter["y_RECEIVED_DATE"];
        $this->RECEIVED_DATE->AdvancedSearch->SearchOperator2 = @$filter["w_RECEIVED_DATE"];
        $this->RECEIVED_DATE->AdvancedSearch->save();

        // Field AMOUNT
        $this->AMOUNT->AdvancedSearch->SearchValue = @$filter["x_AMOUNT"];
        $this->AMOUNT->AdvancedSearch->SearchOperator = @$filter["z_AMOUNT"];
        $this->AMOUNT->AdvancedSearch->SearchCondition = @$filter["v_AMOUNT"];
        $this->AMOUNT->AdvancedSearch->SearchValue2 = @$filter["y_AMOUNT"];
        $this->AMOUNT->AdvancedSearch->SearchOperator2 = @$filter["w_AMOUNT"];
        $this->AMOUNT->AdvancedSearch->save();

        // Field PAYMENT_DUE
        $this->PAYMENT_DUE->AdvancedSearch->SearchValue = @$filter["x_PAYMENT_DUE"];
        $this->PAYMENT_DUE->AdvancedSearch->SearchOperator = @$filter["z_PAYMENT_DUE"];
        $this->PAYMENT_DUE->AdvancedSearch->SearchCondition = @$filter["v_PAYMENT_DUE"];
        $this->PAYMENT_DUE->AdvancedSearch->SearchValue2 = @$filter["y_PAYMENT_DUE"];
        $this->PAYMENT_DUE->AdvancedSearch->SearchOperator2 = @$filter["w_PAYMENT_DUE"];
        $this->PAYMENT_DUE->AdvancedSearch->save();

        // Field DESCRIPTION
        $this->DESCRIPTION->AdvancedSearch->SearchValue = @$filter["x_DESCRIPTION"];
        $this->DESCRIPTION->AdvancedSearch->SearchOperator = @$filter["z_DESCRIPTION"];
        $this->DESCRIPTION->AdvancedSearch->SearchCondition = @$filter["v_DESCRIPTION"];
        $this->DESCRIPTION->AdvancedSearch->SearchValue2 = @$filter["y_DESCRIPTION"];
        $this->DESCRIPTION->AdvancedSearch->SearchOperator2 = @$filter["w_DESCRIPTION"];
        $this->DESCRIPTION->AdvancedSearch->save();

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

        // Field RECEIVED_BY
        $this->RECEIVED_BY->AdvancedSearch->SearchValue = @$filter["x_RECEIVED_BY"];
        $this->RECEIVED_BY->AdvancedSearch->SearchOperator = @$filter["z_RECEIVED_BY"];
        $this->RECEIVED_BY->AdvancedSearch->SearchCondition = @$filter["v_RECEIVED_BY"];
        $this->RECEIVED_BY->AdvancedSearch->SearchValue2 = @$filter["y_RECEIVED_BY"];
        $this->RECEIVED_BY->AdvancedSearch->SearchOperator2 = @$filter["w_RECEIVED_BY"];
        $this->RECEIVED_BY->AdvancedSearch->save();

        // Field PRIORITY
        $this->PRIORITY->AdvancedSearch->SearchValue = @$filter["x_PRIORITY"];
        $this->PRIORITY->AdvancedSearch->SearchOperator = @$filter["z_PRIORITY"];
        $this->PRIORITY->AdvancedSearch->SearchCondition = @$filter["v_PRIORITY"];
        $this->PRIORITY->AdvancedSearch->SearchValue2 = @$filter["y_PRIORITY"];
        $this->PRIORITY->AdvancedSearch->SearchOperator2 = @$filter["w_PRIORITY"];
        $this->PRIORITY->AdvancedSearch->save();

        // Field CREDIT_NOTE
        $this->CREDIT_NOTE->AdvancedSearch->SearchValue = @$filter["x_CREDIT_NOTE"];
        $this->CREDIT_NOTE->AdvancedSearch->SearchOperator = @$filter["z_CREDIT_NOTE"];
        $this->CREDIT_NOTE->AdvancedSearch->SearchCondition = @$filter["v_CREDIT_NOTE"];
        $this->CREDIT_NOTE->AdvancedSearch->SearchValue2 = @$filter["y_CREDIT_NOTE"];
        $this->CREDIT_NOTE->AdvancedSearch->SearchOperator2 = @$filter["w_CREDIT_NOTE"];
        $this->CREDIT_NOTE->AdvancedSearch->save();

        // Field CREDIT_AMOUNT
        $this->CREDIT_AMOUNT->AdvancedSearch->SearchValue = @$filter["x_CREDIT_AMOUNT"];
        $this->CREDIT_AMOUNT->AdvancedSearch->SearchOperator = @$filter["z_CREDIT_AMOUNT"];
        $this->CREDIT_AMOUNT->AdvancedSearch->SearchCondition = @$filter["v_CREDIT_AMOUNT"];
        $this->CREDIT_AMOUNT->AdvancedSearch->SearchValue2 = @$filter["y_CREDIT_AMOUNT"];
        $this->CREDIT_AMOUNT->AdvancedSearch->SearchOperator2 = @$filter["w_CREDIT_AMOUNT"];
        $this->CREDIT_AMOUNT->AdvancedSearch->save();

        // Field PPN
        $this->PPN->AdvancedSearch->SearchValue = @$filter["x_PPN"];
        $this->PPN->AdvancedSearch->SearchOperator = @$filter["z_PPN"];
        $this->PPN->AdvancedSearch->SearchCondition = @$filter["v_PPN"];
        $this->PPN->AdvancedSearch->SearchValue2 = @$filter["y_PPN"];
        $this->PPN->AdvancedSearch->SearchOperator2 = @$filter["w_PPN"];
        $this->PPN->AdvancedSearch->save();

        // Field MATERAI
        $this->MATERAI->AdvancedSearch->SearchValue = @$filter["x_MATERAI"];
        $this->MATERAI->AdvancedSearch->SearchOperator = @$filter["z_MATERAI"];
        $this->MATERAI->AdvancedSearch->SearchCondition = @$filter["v_MATERAI"];
        $this->MATERAI->AdvancedSearch->SearchValue2 = @$filter["y_MATERAI"];
        $this->MATERAI->AdvancedSearch->SearchOperator2 = @$filter["w_MATERAI"];
        $this->MATERAI->AdvancedSearch->save();

        // Field SENT_BY
        $this->SENT_BY->AdvancedSearch->SearchValue = @$filter["x_SENT_BY"];
        $this->SENT_BY->AdvancedSearch->SearchOperator = @$filter["z_SENT_BY"];
        $this->SENT_BY->AdvancedSearch->SearchCondition = @$filter["v_SENT_BY"];
        $this->SENT_BY->AdvancedSearch->SearchValue2 = @$filter["y_SENT_BY"];
        $this->SENT_BY->AdvancedSearch->SearchOperator2 = @$filter["w_SENT_BY"];
        $this->SENT_BY->AdvancedSearch->save();

        // Field ACCOUNT_ID
        $this->ACCOUNT_ID->AdvancedSearch->SearchValue = @$filter["x_ACCOUNT_ID"];
        $this->ACCOUNT_ID->AdvancedSearch->SearchOperator = @$filter["z_ACCOUNT_ID"];
        $this->ACCOUNT_ID->AdvancedSearch->SearchCondition = @$filter["v_ACCOUNT_ID"];
        $this->ACCOUNT_ID->AdvancedSearch->SearchValue2 = @$filter["y_ACCOUNT_ID"];
        $this->ACCOUNT_ID->AdvancedSearch->SearchOperator2 = @$filter["w_ACCOUNT_ID"];
        $this->ACCOUNT_ID->AdvancedSearch->save();

        // Field FINANCE_ID
        $this->FINANCE_ID->AdvancedSearch->SearchValue = @$filter["x_FINANCE_ID"];
        $this->FINANCE_ID->AdvancedSearch->SearchOperator = @$filter["z_FINANCE_ID"];
        $this->FINANCE_ID->AdvancedSearch->SearchCondition = @$filter["v_FINANCE_ID"];
        $this->FINANCE_ID->AdvancedSearch->SearchValue2 = @$filter["y_FINANCE_ID"];
        $this->FINANCE_ID->AdvancedSearch->SearchOperator2 = @$filter["w_FINANCE_ID"];
        $this->FINANCE_ID->AdvancedSearch->save();

        // Field potongan
        $this->potongan->AdvancedSearch->SearchValue = @$filter["x_potongan"];
        $this->potongan->AdvancedSearch->SearchOperator = @$filter["z_potongan"];
        $this->potongan->AdvancedSearch->SearchCondition = @$filter["v_potongan"];
        $this->potongan->AdvancedSearch->SearchValue2 = @$filter["y_potongan"];
        $this->potongan->AdvancedSearch->SearchOperator2 = @$filter["w_potongan"];
        $this->potongan->AdvancedSearch->save();

        // Field RECEIVED_VALUE
        $this->RECEIVED_VALUE->AdvancedSearch->SearchValue = @$filter["x_RECEIVED_VALUE"];
        $this->RECEIVED_VALUE->AdvancedSearch->SearchOperator = @$filter["z_RECEIVED_VALUE"];
        $this->RECEIVED_VALUE->AdvancedSearch->SearchCondition = @$filter["v_RECEIVED_VALUE"];
        $this->RECEIVED_VALUE->AdvancedSearch->SearchValue2 = @$filter["y_RECEIVED_VALUE"];
        $this->RECEIVED_VALUE->AdvancedSearch->SearchOperator2 = @$filter["w_RECEIVED_VALUE"];
        $this->RECEIVED_VALUE->AdvancedSearch->save();

        // Field NO_ORDER
        $this->NO_ORDER->AdvancedSearch->SearchValue = @$filter["x_NO_ORDER"];
        $this->NO_ORDER->AdvancedSearch->SearchOperator = @$filter["z_NO_ORDER"];
        $this->NO_ORDER->AdvancedSearch->SearchCondition = @$filter["v_NO_ORDER"];
        $this->NO_ORDER->AdvancedSearch->SearchValue2 = @$filter["y_NO_ORDER"];
        $this->NO_ORDER->AdvancedSearch->SearchOperator2 = @$filter["w_NO_ORDER"];
        $this->NO_ORDER->AdvancedSearch->save();

        // Field CONTRACT_NO
        $this->CONTRACT_NO->AdvancedSearch->SearchValue = @$filter["x_CONTRACT_NO"];
        $this->CONTRACT_NO->AdvancedSearch->SearchOperator = @$filter["z_CONTRACT_NO"];
        $this->CONTRACT_NO->AdvancedSearch->SearchCondition = @$filter["v_CONTRACT_NO"];
        $this->CONTRACT_NO->AdvancedSearch->SearchValue2 = @$filter["y_CONTRACT_NO"];
        $this->CONTRACT_NO->AdvancedSearch->SearchOperator2 = @$filter["w_CONTRACT_NO"];
        $this->CONTRACT_NO->AdvancedSearch->save();

        // Field ORG_ID
        $this->ORG_ID->AdvancedSearch->SearchValue = @$filter["x_ORG_ID"];
        $this->ORG_ID->AdvancedSearch->SearchOperator = @$filter["z_ORG_ID"];
        $this->ORG_ID->AdvancedSearch->SearchCondition = @$filter["v_ORG_ID"];
        $this->ORG_ID->AdvancedSearch->SearchValue2 = @$filter["y_ORG_ID"];
        $this->ORG_ID->AdvancedSearch->SearchOperator2 = @$filter["w_ORG_ID"];
        $this->ORG_ID->AdvancedSearch->save();

        // Field CLINIC_ID
        $this->CLINIC_ID->AdvancedSearch->SearchValue = @$filter["x_CLINIC_ID"];
        $this->CLINIC_ID->AdvancedSearch->SearchOperator = @$filter["z_CLINIC_ID"];
        $this->CLINIC_ID->AdvancedSearch->SearchCondition = @$filter["v_CLINIC_ID"];
        $this->CLINIC_ID->AdvancedSearch->SearchValue2 = @$filter["y_CLINIC_ID"];
        $this->CLINIC_ID->AdvancedSearch->SearchOperator2 = @$filter["w_CLINIC_ID"];
        $this->CLINIC_ID->AdvancedSearch->save();

        // Field PPN_VALUE
        $this->PPN_VALUE->AdvancedSearch->SearchValue = @$filter["x_PPN_VALUE"];
        $this->PPN_VALUE->AdvancedSearch->SearchOperator = @$filter["z_PPN_VALUE"];
        $this->PPN_VALUE->AdvancedSearch->SearchCondition = @$filter["v_PPN_VALUE"];
        $this->PPN_VALUE->AdvancedSearch->SearchValue2 = @$filter["y_PPN_VALUE"];
        $this->PPN_VALUE->AdvancedSearch->SearchOperator2 = @$filter["w_PPN_VALUE"];
        $this->PPN_VALUE->AdvancedSearch->save();

        // Field DISCOUNT_VALUE
        $this->DISCOUNT_VALUE->AdvancedSearch->SearchValue = @$filter["x_DISCOUNT_VALUE"];
        $this->DISCOUNT_VALUE->AdvancedSearch->SearchOperator = @$filter["z_DISCOUNT_VALUE"];
        $this->DISCOUNT_VALUE->AdvancedSearch->SearchCondition = @$filter["v_DISCOUNT_VALUE"];
        $this->DISCOUNT_VALUE->AdvancedSearch->SearchValue2 = @$filter["y_DISCOUNT_VALUE"];
        $this->DISCOUNT_VALUE->AdvancedSearch->SearchOperator2 = @$filter["w_DISCOUNT_VALUE"];
        $this->DISCOUNT_VALUE->AdvancedSearch->save();

        // Field PAID_VALUE
        $this->PAID_VALUE->AdvancedSearch->SearchValue = @$filter["x_PAID_VALUE"];
        $this->PAID_VALUE->AdvancedSearch->SearchOperator = @$filter["z_PAID_VALUE"];
        $this->PAID_VALUE->AdvancedSearch->SearchCondition = @$filter["v_PAID_VALUE"];
        $this->PAID_VALUE->AdvancedSearch->SearchValue2 = @$filter["y_PAID_VALUE"];
        $this->PAID_VALUE->AdvancedSearch->SearchOperator2 = @$filter["w_PAID_VALUE"];
        $this->PAID_VALUE->AdvancedSearch->save();

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

        // Field FAKTUR_DATE
        $this->FAKTUR_DATE->AdvancedSearch->SearchValue = @$filter["x_FAKTUR_DATE"];
        $this->FAKTUR_DATE->AdvancedSearch->SearchOperator = @$filter["z_FAKTUR_DATE"];
        $this->FAKTUR_DATE->AdvancedSearch->SearchCondition = @$filter["v_FAKTUR_DATE"];
        $this->FAKTUR_DATE->AdvancedSearch->SearchValue2 = @$filter["y_FAKTUR_DATE"];
        $this->FAKTUR_DATE->AdvancedSearch->SearchOperator2 = @$filter["w_FAKTUR_DATE"];
        $this->FAKTUR_DATE->AdvancedSearch->save();

        // Field DISTRIBUTION_TYPE
        $this->DISTRIBUTION_TYPE->AdvancedSearch->SearchValue = @$filter["x_DISTRIBUTION_TYPE"];
        $this->DISTRIBUTION_TYPE->AdvancedSearch->SearchOperator = @$filter["z_DISTRIBUTION_TYPE"];
        $this->DISTRIBUTION_TYPE->AdvancedSearch->SearchCondition = @$filter["v_DISTRIBUTION_TYPE"];
        $this->DISTRIBUTION_TYPE->AdvancedSearch->SearchValue2 = @$filter["y_DISTRIBUTION_TYPE"];
        $this->DISTRIBUTION_TYPE->AdvancedSearch->SearchOperator2 = @$filter["w_DISTRIBUTION_TYPE"];
        $this->DISTRIBUTION_TYPE->AdvancedSearch->save();

        // Field DISCOUNTOFF_VALUE
        $this->DISCOUNTOFF_VALUE->AdvancedSearch->SearchValue = @$filter["x_DISCOUNTOFF_VALUE"];
        $this->DISCOUNTOFF_VALUE->AdvancedSearch->SearchOperator = @$filter["z_DISCOUNTOFF_VALUE"];
        $this->DISCOUNTOFF_VALUE->AdvancedSearch->SearchCondition = @$filter["v_DISCOUNTOFF_VALUE"];
        $this->DISCOUNTOFF_VALUE->AdvancedSearch->SearchValue2 = @$filter["y_DISCOUNTOFF_VALUE"];
        $this->DISCOUNTOFF_VALUE->AdvancedSearch->SearchOperator2 = @$filter["w_DISCOUNTOFF_VALUE"];
        $this->DISCOUNTOFF_VALUE->AdvancedSearch->save();

        // Field THECOUNTER
        $this->THECOUNTER->AdvancedSearch->SearchValue = @$filter["x_THECOUNTER"];
        $this->THECOUNTER->AdvancedSearch->SearchOperator = @$filter["z_THECOUNTER"];
        $this->THECOUNTER->AdvancedSearch->SearchCondition = @$filter["v_THECOUNTER"];
        $this->THECOUNTER->AdvancedSearch->SearchValue2 = @$filter["y_THECOUNTER"];
        $this->THECOUNTER->AdvancedSearch->SearchOperator2 = @$filter["w_THECOUNTER"];
        $this->THECOUNTER->AdvancedSearch->save();

        // Field FUND_ID
        $this->FUND_ID->AdvancedSearch->SearchValue = @$filter["x_FUND_ID"];
        $this->FUND_ID->AdvancedSearch->SearchOperator = @$filter["z_FUND_ID"];
        $this->FUND_ID->AdvancedSearch->SearchCondition = @$filter["v_FUND_ID"];
        $this->FUND_ID->AdvancedSearch->SearchValue2 = @$filter["y_FUND_ID"];
        $this->FUND_ID->AdvancedSearch->SearchOperator2 = @$filter["w_FUND_ID"];
        $this->FUND_ID->AdvancedSearch->save();

        // Field ORDER_BY
        $this->ORDER_BY->AdvancedSearch->SearchValue = @$filter["x_ORDER_BY"];
        $this->ORDER_BY->AdvancedSearch->SearchOperator = @$filter["z_ORDER_BY"];
        $this->ORDER_BY->AdvancedSearch->SearchCondition = @$filter["v_ORDER_BY"];
        $this->ORDER_BY->AdvancedSearch->SearchValue2 = @$filter["y_ORDER_BY"];
        $this->ORDER_BY->AdvancedSearch->SearchOperator2 = @$filter["w_ORDER_BY"];
        $this->ORDER_BY->AdvancedSearch->save();

        // Field ACKNOWLEDGEBY
        $this->ACKNOWLEDGEBY->AdvancedSearch->SearchValue = @$filter["x_ACKNOWLEDGEBY"];
        $this->ACKNOWLEDGEBY->AdvancedSearch->SearchOperator = @$filter["z_ACKNOWLEDGEBY"];
        $this->ACKNOWLEDGEBY->AdvancedSearch->SearchCondition = @$filter["v_ACKNOWLEDGEBY"];
        $this->ACKNOWLEDGEBY->AdvancedSearch->SearchValue2 = @$filter["y_ACKNOWLEDGEBY"];
        $this->ACKNOWLEDGEBY->AdvancedSearch->SearchOperator2 = @$filter["w_ACKNOWLEDGEBY"];
        $this->ACKNOWLEDGEBY->AdvancedSearch->save();

        // Field NUM
        $this->NUM->AdvancedSearch->SearchValue = @$filter["x_NUM"];
        $this->NUM->AdvancedSearch->SearchOperator = @$filter["z_NUM"];
        $this->NUM->AdvancedSearch->SearchCondition = @$filter["v_NUM"];
        $this->NUM->AdvancedSearch->SearchValue2 = @$filter["y_NUM"];
        $this->NUM->AdvancedSearch->SearchOperator2 = @$filter["w_NUM"];
        $this->NUM->AdvancedSearch->save();

        // Field ISPO
        $this->ISPO->AdvancedSearch->SearchValue = @$filter["x_ISPO"];
        $this->ISPO->AdvancedSearch->SearchOperator = @$filter["z_ISPO"];
        $this->ISPO->AdvancedSearch->SearchCondition = @$filter["v_ISPO"];
        $this->ISPO->AdvancedSearch->SearchValue2 = @$filter["y_ISPO"];
        $this->ISPO->AdvancedSearch->SearchOperator2 = @$filter["w_ISPO"];
        $this->ISPO->AdvancedSearch->save();

        // Field DOCS_TYPE
        $this->DOCS_TYPE->AdvancedSearch->SearchValue = @$filter["x_DOCS_TYPE"];
        $this->DOCS_TYPE->AdvancedSearch->SearchOperator = @$filter["z_DOCS_TYPE"];
        $this->DOCS_TYPE->AdvancedSearch->SearchCondition = @$filter["v_DOCS_TYPE"];
        $this->DOCS_TYPE->AdvancedSearch->SearchValue2 = @$filter["y_DOCS_TYPE"];
        $this->DOCS_TYPE->AdvancedSearch->SearchOperator2 = @$filter["w_DOCS_TYPE"];
        $this->DOCS_TYPE->AdvancedSearch->save();

        // Field PO_DATE
        $this->PO_DATE->AdvancedSearch->SearchValue = @$filter["x_PO_DATE"];
        $this->PO_DATE->AdvancedSearch->SearchOperator = @$filter["z_PO_DATE"];
        $this->PO_DATE->AdvancedSearch->SearchCondition = @$filter["v_PO_DATE"];
        $this->PO_DATE->AdvancedSearch->SearchValue2 = @$filter["y_PO_DATE"];
        $this->PO_DATE->AdvancedSearch->SearchOperator2 = @$filter["w_PO_DATE"];
        $this->PO_DATE->AdvancedSearch->save();

        // Field PO_VALUE
        $this->PO_VALUE->AdvancedSearch->SearchValue = @$filter["x_PO_VALUE"];
        $this->PO_VALUE->AdvancedSearch->SearchOperator = @$filter["z_PO_VALUE"];
        $this->PO_VALUE->AdvancedSearch->SearchCondition = @$filter["v_PO_VALUE"];
        $this->PO_VALUE->AdvancedSearch->SearchValue2 = @$filter["y_PO_VALUE"];
        $this->PO_VALUE->AdvancedSearch->SearchOperator2 = @$filter["w_PO_VALUE"];
        $this->PO_VALUE->AdvancedSearch->save();
        $this->BasicSearch->setKeyword(@$filter[Config("TABLE_BASIC_SEARCH")]);
        $this->BasicSearch->setType(@$filter[Config("TABLE_BASIC_SEARCH_TYPE")]);
    }

    // Return basic search SQL
    protected function basicSearchSql($arKeywords, $type)
    {
        $where = "";
        $this->buildBasicSearchSql($where, $this->ORG_UNIT_CODE, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->INVOICE_ID, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->INVOICE_ID2, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->PO, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->COMPANY_ID, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->DESCRIPTION, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->MODIFIED_BY, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->RECEIVED_BY, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->CREDIT_NOTE, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->SENT_BY, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->NO_ORDER, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->CONTRACT_NO, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->ORG_ID, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->CLINIC_ID, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->ISCETAK, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->PRINTED_BY, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->ORDER_BY, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->ACKNOWLEDGEBY, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->ISPO, $arKeywords, $type);
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
            $this->updateSort($this->INVOICE_ID); // INVOICE_ID
            $this->updateSort($this->INVOICE_ID2); // INVOICE_ID2
            $this->updateSort($this->INVOICE_DATE); // INVOICE_DATE
            $this->updateSort($this->PO); // PO
            $this->updateSort($this->COMPANY_ID); // COMPANY_ID
            $this->updateSort($this->RECEIVED_DATE); // RECEIVED_DATE
            $this->updateSort($this->AMOUNT); // AMOUNT
            $this->updateSort($this->PAYMENT_DUE); // PAYMENT_DUE
            $this->updateSort($this->DESCRIPTION); // DESCRIPTION
            $this->updateSort($this->MODIFIED_DATE); // MODIFIED_DATE
            $this->updateSort($this->MODIFIED_BY); // MODIFIED_BY
            $this->updateSort($this->RECEIVED_BY); // RECEIVED_BY
            $this->updateSort($this->PRIORITY); // PRIORITY
            $this->updateSort($this->CREDIT_NOTE); // CREDIT_NOTE
            $this->updateSort($this->CREDIT_AMOUNT); // CREDIT_AMOUNT
            $this->updateSort($this->PPN); // PPN
            $this->updateSort($this->MATERAI); // MATERAI
            $this->updateSort($this->SENT_BY); // SENT_BY
            $this->updateSort($this->ACCOUNT_ID); // ACCOUNT_ID
            $this->updateSort($this->FINANCE_ID); // FINANCE_ID
            $this->updateSort($this->potongan); // potongan
            $this->updateSort($this->RECEIVED_VALUE); // RECEIVED_VALUE
            $this->updateSort($this->NO_ORDER); // NO_ORDER
            $this->updateSort($this->CONTRACT_NO); // CONTRACT_NO
            $this->updateSort($this->ORG_ID); // ORG_ID
            $this->updateSort($this->CLINIC_ID); // CLINIC_ID
            $this->updateSort($this->PPN_VALUE); // PPN_VALUE
            $this->updateSort($this->DISCOUNT_VALUE); // DISCOUNT_VALUE
            $this->updateSort($this->PAID_VALUE); // PAID_VALUE
            $this->updateSort($this->ISCETAK); // ISCETAK
            $this->updateSort($this->PRINT_DATE); // PRINT_DATE
            $this->updateSort($this->PRINTED_BY); // PRINTED_BY
            $this->updateSort($this->PRINTQ); // PRINTQ
            $this->updateSort($this->FAKTUR_DATE); // FAKTUR_DATE
            $this->updateSort($this->DISTRIBUTION_TYPE); // DISTRIBUTION_TYPE
            $this->updateSort($this->DISCOUNTOFF_VALUE); // DISCOUNTOFF_VALUE
            $this->updateSort($this->THECOUNTER); // THECOUNTER
            $this->updateSort($this->FUND_ID); // FUND_ID
            $this->updateSort($this->ORDER_BY); // ORDER_BY
            $this->updateSort($this->ACKNOWLEDGEBY); // ACKNOWLEDGEBY
            $this->updateSort($this->NUM); // NUM
            $this->updateSort($this->ISPO); // ISPO
            $this->updateSort($this->DOCS_TYPE); // DOCS_TYPE
            $this->updateSort($this->PO_DATE); // PO_DATE
            $this->updateSort($this->PO_VALUE); // PO_VALUE
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
                $this->INVOICE_ID->setSort("");
                $this->INVOICE_ID2->setSort("");
                $this->INVOICE_DATE->setSort("");
                $this->PO->setSort("");
                $this->COMPANY_ID->setSort("");
                $this->RECEIVED_DATE->setSort("");
                $this->AMOUNT->setSort("");
                $this->PAYMENT_DUE->setSort("");
                $this->DESCRIPTION->setSort("");
                $this->MODIFIED_DATE->setSort("");
                $this->MODIFIED_BY->setSort("");
                $this->RECEIVED_BY->setSort("");
                $this->PRIORITY->setSort("");
                $this->CREDIT_NOTE->setSort("");
                $this->CREDIT_AMOUNT->setSort("");
                $this->PPN->setSort("");
                $this->MATERAI->setSort("");
                $this->SENT_BY->setSort("");
                $this->ACCOUNT_ID->setSort("");
                $this->FINANCE_ID->setSort("");
                $this->potongan->setSort("");
                $this->RECEIVED_VALUE->setSort("");
                $this->NO_ORDER->setSort("");
                $this->CONTRACT_NO->setSort("");
                $this->ORG_ID->setSort("");
                $this->CLINIC_ID->setSort("");
                $this->PPN_VALUE->setSort("");
                $this->DISCOUNT_VALUE->setSort("");
                $this->PAID_VALUE->setSort("");
                $this->ISCETAK->setSort("");
                $this->PRINT_DATE->setSort("");
                $this->PRINTED_BY->setSort("");
                $this->PRINTQ->setSort("");
                $this->FAKTUR_DATE->setSort("");
                $this->DISTRIBUTION_TYPE->setSort("");
                $this->DISCOUNTOFF_VALUE->setSort("");
                $this->THECOUNTER->setSort("");
                $this->FUND_ID->setSort("");
                $this->ORDER_BY->setSort("");
                $this->ACKNOWLEDGEBY->setSort("");
                $this->NUM->setSort("");
                $this->ISPO->setSort("");
                $this->DOCS_TYPE->setSort("");
                $this->PO_DATE->setSort("");
                $this->PO_VALUE->setSort("");
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
        $opt->Body = "<div class=\"custom-control custom-checkbox d-inline-block\"><input type=\"checkbox\" id=\"key_m_" . $this->RowCount . "\" name=\"key_m[]\" class=\"custom-control-input ew-multi-select\" value=\"" . HtmlEncode($this->INVOICE_ID->CurrentValue) . "\" onclick=\"ew.clickMultiCheckbox(event);\"><label class=\"custom-control-label\" for=\"key_m_" . $this->RowCount . "\"></label></div>";
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
        $item->Body = "<a class=\"ew-save-filter\" data-form=\"fPO_INVOICElistsrch\" href=\"#\" onclick=\"return false;\">" . $Language->phrase("SaveCurrentFilter") . "</a>";
        $item->Visible = true;
        $item = &$this->FilterOptions->add("deletefilter");
        $item->Body = "<a class=\"ew-delete-filter\" data-form=\"fPO_INVOICElistsrch\" href=\"#\" onclick=\"return false;\">" . $Language->phrase("DeleteFilter") . "</a>";
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
                $item->Body = '<a class="ew-action ew-list-action" title="' . HtmlEncode($caption) . '" data-caption="' . HtmlEncode($caption) . '" href="#" onclick="return ew.submitAction(event,jQuery.extend({f:document.fPO_INVOICElist},' . $listaction->toJson(true) . '));">' . $icon . '</a>';
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
        $this->INVOICE_ID->setDbValue($row['INVOICE_ID']);
        $this->INVOICE_ID2->setDbValue($row['INVOICE_ID2']);
        $this->INVOICE_DATE->setDbValue($row['INVOICE_DATE']);
        $this->PO->setDbValue($row['PO']);
        $this->COMPANY_ID->setDbValue($row['COMPANY_ID']);
        $this->RECEIVED_DATE->setDbValue($row['RECEIVED_DATE']);
        $this->AMOUNT->setDbValue($row['AMOUNT']);
        $this->PAYMENT_DUE->setDbValue($row['PAYMENT_DUE']);
        $this->DESCRIPTION->setDbValue($row['DESCRIPTION']);
        $this->MODIFIED_DATE->setDbValue($row['MODIFIED_DATE']);
        $this->MODIFIED_BY->setDbValue($row['MODIFIED_BY']);
        $this->RECEIVED_BY->setDbValue($row['RECEIVED_BY']);
        $this->PRIORITY->setDbValue($row['PRIORITY']);
        $this->CREDIT_NOTE->setDbValue($row['CREDIT_NOTE']);
        $this->CREDIT_AMOUNT->setDbValue($row['CREDIT_AMOUNT']);
        $this->PPN->setDbValue($row['PPN']);
        $this->MATERAI->setDbValue($row['MATERAI']);
        $this->SENT_BY->setDbValue($row['SENT_BY']);
        $this->ACCOUNT_ID->setDbValue($row['ACCOUNT_ID']);
        $this->FINANCE_ID->setDbValue($row['FINANCE_ID']);
        $this->potongan->setDbValue($row['potongan']);
        $this->RECEIVED_VALUE->setDbValue($row['RECEIVED_VALUE']);
        $this->NO_ORDER->setDbValue($row['NO_ORDER']);
        $this->CONTRACT_NO->setDbValue($row['CONTRACT_NO']);
        $this->ORG_ID->setDbValue($row['ORG_ID']);
        $this->CLINIC_ID->setDbValue($row['CLINIC_ID']);
        $this->PPN_VALUE->setDbValue($row['PPN_VALUE']);
        $this->DISCOUNT_VALUE->setDbValue($row['DISCOUNT_VALUE']);
        $this->PAID_VALUE->setDbValue($row['PAID_VALUE']);
        $this->ISCETAK->setDbValue($row['ISCETAK']);
        $this->PRINT_DATE->setDbValue($row['PRINT_DATE']);
        $this->PRINTED_BY->setDbValue($row['PRINTED_BY']);
        $this->PRINTQ->setDbValue($row['PRINTQ']);
        $this->FAKTUR_DATE->setDbValue($row['FAKTUR_DATE']);
        $this->DISTRIBUTION_TYPE->setDbValue($row['DISTRIBUTION_TYPE']);
        $this->DISCOUNTOFF_VALUE->setDbValue($row['DISCOUNTOFF_VALUE']);
        $this->THECOUNTER->setDbValue($row['THECOUNTER']);
        $this->FUND_ID->setDbValue($row['FUND_ID']);
        $this->ORDER_BY->setDbValue($row['ORDER_BY']);
        $this->ACKNOWLEDGEBY->setDbValue($row['ACKNOWLEDGEBY']);
        $this->NUM->setDbValue($row['NUM']);
        $this->ISPO->setDbValue($row['ISPO']);
        $this->DOCS_TYPE->setDbValue($row['DOCS_TYPE']);
        $this->PO_DATE->setDbValue($row['PO_DATE']);
        $this->PO_VALUE->setDbValue($row['PO_VALUE']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['ORG_UNIT_CODE'] = null;
        $row['INVOICE_ID'] = null;
        $row['INVOICE_ID2'] = null;
        $row['INVOICE_DATE'] = null;
        $row['PO'] = null;
        $row['COMPANY_ID'] = null;
        $row['RECEIVED_DATE'] = null;
        $row['AMOUNT'] = null;
        $row['PAYMENT_DUE'] = null;
        $row['DESCRIPTION'] = null;
        $row['MODIFIED_DATE'] = null;
        $row['MODIFIED_BY'] = null;
        $row['RECEIVED_BY'] = null;
        $row['PRIORITY'] = null;
        $row['CREDIT_NOTE'] = null;
        $row['CREDIT_AMOUNT'] = null;
        $row['PPN'] = null;
        $row['MATERAI'] = null;
        $row['SENT_BY'] = null;
        $row['ACCOUNT_ID'] = null;
        $row['FINANCE_ID'] = null;
        $row['potongan'] = null;
        $row['RECEIVED_VALUE'] = null;
        $row['NO_ORDER'] = null;
        $row['CONTRACT_NO'] = null;
        $row['ORG_ID'] = null;
        $row['CLINIC_ID'] = null;
        $row['PPN_VALUE'] = null;
        $row['DISCOUNT_VALUE'] = null;
        $row['PAID_VALUE'] = null;
        $row['ISCETAK'] = null;
        $row['PRINT_DATE'] = null;
        $row['PRINTED_BY'] = null;
        $row['PRINTQ'] = null;
        $row['FAKTUR_DATE'] = null;
        $row['DISTRIBUTION_TYPE'] = null;
        $row['DISCOUNTOFF_VALUE'] = null;
        $row['THECOUNTER'] = null;
        $row['FUND_ID'] = null;
        $row['ORDER_BY'] = null;
        $row['ACKNOWLEDGEBY'] = null;
        $row['NUM'] = null;
        $row['ISPO'] = null;
        $row['DOCS_TYPE'] = null;
        $row['PO_DATE'] = null;
        $row['PO_VALUE'] = null;
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
        if ($this->CREDIT_AMOUNT->FormValue == $this->CREDIT_AMOUNT->CurrentValue && is_numeric(ConvertToFloatString($this->CREDIT_AMOUNT->CurrentValue))) {
            $this->CREDIT_AMOUNT->CurrentValue = ConvertToFloatString($this->CREDIT_AMOUNT->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->PPN->FormValue == $this->PPN->CurrentValue && is_numeric(ConvertToFloatString($this->PPN->CurrentValue))) {
            $this->PPN->CurrentValue = ConvertToFloatString($this->PPN->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->MATERAI->FormValue == $this->MATERAI->CurrentValue && is_numeric(ConvertToFloatString($this->MATERAI->CurrentValue))) {
            $this->MATERAI->CurrentValue = ConvertToFloatString($this->MATERAI->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->potongan->FormValue == $this->potongan->CurrentValue && is_numeric(ConvertToFloatString($this->potongan->CurrentValue))) {
            $this->potongan->CurrentValue = ConvertToFloatString($this->potongan->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->RECEIVED_VALUE->FormValue == $this->RECEIVED_VALUE->CurrentValue && is_numeric(ConvertToFloatString($this->RECEIVED_VALUE->CurrentValue))) {
            $this->RECEIVED_VALUE->CurrentValue = ConvertToFloatString($this->RECEIVED_VALUE->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->PPN_VALUE->FormValue == $this->PPN_VALUE->CurrentValue && is_numeric(ConvertToFloatString($this->PPN_VALUE->CurrentValue))) {
            $this->PPN_VALUE->CurrentValue = ConvertToFloatString($this->PPN_VALUE->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->DISCOUNT_VALUE->FormValue == $this->DISCOUNT_VALUE->CurrentValue && is_numeric(ConvertToFloatString($this->DISCOUNT_VALUE->CurrentValue))) {
            $this->DISCOUNT_VALUE->CurrentValue = ConvertToFloatString($this->DISCOUNT_VALUE->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->PAID_VALUE->FormValue == $this->PAID_VALUE->CurrentValue && is_numeric(ConvertToFloatString($this->PAID_VALUE->CurrentValue))) {
            $this->PAID_VALUE->CurrentValue = ConvertToFloatString($this->PAID_VALUE->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->DISCOUNTOFF_VALUE->FormValue == $this->DISCOUNTOFF_VALUE->CurrentValue && is_numeric(ConvertToFloatString($this->DISCOUNTOFF_VALUE->CurrentValue))) {
            $this->DISCOUNTOFF_VALUE->CurrentValue = ConvertToFloatString($this->DISCOUNTOFF_VALUE->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->PO_VALUE->FormValue == $this->PO_VALUE->CurrentValue && is_numeric(ConvertToFloatString($this->PO_VALUE->CurrentValue))) {
            $this->PO_VALUE->CurrentValue = ConvertToFloatString($this->PO_VALUE->CurrentValue);
        }

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // ORG_UNIT_CODE

        // INVOICE_ID

        // INVOICE_ID2

        // INVOICE_DATE

        // PO

        // COMPANY_ID

        // RECEIVED_DATE

        // AMOUNT

        // PAYMENT_DUE

        // DESCRIPTION

        // MODIFIED_DATE

        // MODIFIED_BY

        // RECEIVED_BY

        // PRIORITY

        // CREDIT_NOTE

        // CREDIT_AMOUNT

        // PPN

        // MATERAI

        // SENT_BY

        // ACCOUNT_ID

        // FINANCE_ID

        // potongan

        // RECEIVED_VALUE

        // NO_ORDER

        // CONTRACT_NO

        // ORG_ID

        // CLINIC_ID

        // PPN_VALUE

        // DISCOUNT_VALUE

        // PAID_VALUE

        // ISCETAK

        // PRINT_DATE

        // PRINTED_BY

        // PRINTQ

        // FAKTUR_DATE

        // DISTRIBUTION_TYPE

        // DISCOUNTOFF_VALUE

        // THECOUNTER

        // FUND_ID

        // ORDER_BY

        // ACKNOWLEDGEBY

        // NUM

        // ISPO

        // DOCS_TYPE

        // PO_DATE

        // PO_VALUE
        if ($this->RowType == ROWTYPE_VIEW) {
            // ORG_UNIT_CODE
            $this->ORG_UNIT_CODE->ViewValue = $this->ORG_UNIT_CODE->CurrentValue;
            $this->ORG_UNIT_CODE->ViewCustomAttributes = "";

            // INVOICE_ID
            $this->INVOICE_ID->ViewValue = $this->INVOICE_ID->CurrentValue;
            $this->INVOICE_ID->ViewCustomAttributes = "";

            // INVOICE_ID2
            $this->INVOICE_ID2->ViewValue = $this->INVOICE_ID2->CurrentValue;
            $this->INVOICE_ID2->ViewCustomAttributes = "";

            // INVOICE_DATE
            $this->INVOICE_DATE->ViewValue = $this->INVOICE_DATE->CurrentValue;
            $this->INVOICE_DATE->ViewValue = FormatDateTime($this->INVOICE_DATE->ViewValue, 0);
            $this->INVOICE_DATE->ViewCustomAttributes = "";

            // PO
            $this->PO->ViewValue = $this->PO->CurrentValue;
            $this->PO->ViewCustomAttributes = "";

            // COMPANY_ID
            $this->COMPANY_ID->ViewValue = $this->COMPANY_ID->CurrentValue;
            $this->COMPANY_ID->ViewCustomAttributes = "";

            // RECEIVED_DATE
            $this->RECEIVED_DATE->ViewValue = $this->RECEIVED_DATE->CurrentValue;
            $this->RECEIVED_DATE->ViewValue = FormatDateTime($this->RECEIVED_DATE->ViewValue, 0);
            $this->RECEIVED_DATE->ViewCustomAttributes = "";

            // AMOUNT
            $this->AMOUNT->ViewValue = $this->AMOUNT->CurrentValue;
            $this->AMOUNT->ViewValue = FormatNumber($this->AMOUNT->ViewValue, 2, -2, -2, -2);
            $this->AMOUNT->ViewCustomAttributes = "";

            // PAYMENT_DUE
            $this->PAYMENT_DUE->ViewValue = $this->PAYMENT_DUE->CurrentValue;
            $this->PAYMENT_DUE->ViewValue = FormatDateTime($this->PAYMENT_DUE->ViewValue, 0);
            $this->PAYMENT_DUE->ViewCustomAttributes = "";

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

            // RECEIVED_BY
            $this->RECEIVED_BY->ViewValue = $this->RECEIVED_BY->CurrentValue;
            $this->RECEIVED_BY->ViewCustomAttributes = "";

            // PRIORITY
            $this->PRIORITY->ViewValue = $this->PRIORITY->CurrentValue;
            $this->PRIORITY->ViewValue = FormatNumber($this->PRIORITY->ViewValue, 0, -2, -2, -2);
            $this->PRIORITY->ViewCustomAttributes = "";

            // CREDIT_NOTE
            $this->CREDIT_NOTE->ViewValue = $this->CREDIT_NOTE->CurrentValue;
            $this->CREDIT_NOTE->ViewCustomAttributes = "";

            // CREDIT_AMOUNT
            $this->CREDIT_AMOUNT->ViewValue = $this->CREDIT_AMOUNT->CurrentValue;
            $this->CREDIT_AMOUNT->ViewValue = FormatNumber($this->CREDIT_AMOUNT->ViewValue, 2, -2, -2, -2);
            $this->CREDIT_AMOUNT->ViewCustomAttributes = "";

            // PPN
            $this->PPN->ViewValue = $this->PPN->CurrentValue;
            $this->PPN->ViewValue = FormatNumber($this->PPN->ViewValue, 2, -2, -2, -2);
            $this->PPN->ViewCustomAttributes = "";

            // MATERAI
            $this->MATERAI->ViewValue = $this->MATERAI->CurrentValue;
            $this->MATERAI->ViewValue = FormatNumber($this->MATERAI->ViewValue, 2, -2, -2, -2);
            $this->MATERAI->ViewCustomAttributes = "";

            // SENT_BY
            $this->SENT_BY->ViewValue = $this->SENT_BY->CurrentValue;
            $this->SENT_BY->ViewCustomAttributes = "";

            // ACCOUNT_ID
            $this->ACCOUNT_ID->ViewValue = $this->ACCOUNT_ID->CurrentValue;
            $this->ACCOUNT_ID->ViewValue = FormatNumber($this->ACCOUNT_ID->ViewValue, 0, -2, -2, -2);
            $this->ACCOUNT_ID->ViewCustomAttributes = "";

            // FINANCE_ID
            $this->FINANCE_ID->ViewValue = $this->FINANCE_ID->CurrentValue;
            $this->FINANCE_ID->ViewValue = FormatNumber($this->FINANCE_ID->ViewValue, 0, -2, -2, -2);
            $this->FINANCE_ID->ViewCustomAttributes = "";

            // potongan
            $this->potongan->ViewValue = $this->potongan->CurrentValue;
            $this->potongan->ViewValue = FormatNumber($this->potongan->ViewValue, 2, -2, -2, -2);
            $this->potongan->ViewCustomAttributes = "";

            // RECEIVED_VALUE
            $this->RECEIVED_VALUE->ViewValue = $this->RECEIVED_VALUE->CurrentValue;
            $this->RECEIVED_VALUE->ViewValue = FormatNumber($this->RECEIVED_VALUE->ViewValue, 2, -2, -2, -2);
            $this->RECEIVED_VALUE->ViewCustomAttributes = "";

            // NO_ORDER
            $this->NO_ORDER->ViewValue = $this->NO_ORDER->CurrentValue;
            $this->NO_ORDER->ViewCustomAttributes = "";

            // CONTRACT_NO
            $this->CONTRACT_NO->ViewValue = $this->CONTRACT_NO->CurrentValue;
            $this->CONTRACT_NO->ViewCustomAttributes = "";

            // ORG_ID
            $this->ORG_ID->ViewValue = $this->ORG_ID->CurrentValue;
            $this->ORG_ID->ViewCustomAttributes = "";

            // CLINIC_ID
            $this->CLINIC_ID->ViewValue = $this->CLINIC_ID->CurrentValue;
            $this->CLINIC_ID->ViewCustomAttributes = "";

            // PPN_VALUE
            $this->PPN_VALUE->ViewValue = $this->PPN_VALUE->CurrentValue;
            $this->PPN_VALUE->ViewValue = FormatNumber($this->PPN_VALUE->ViewValue, 2, -2, -2, -2);
            $this->PPN_VALUE->ViewCustomAttributes = "";

            // DISCOUNT_VALUE
            $this->DISCOUNT_VALUE->ViewValue = $this->DISCOUNT_VALUE->CurrentValue;
            $this->DISCOUNT_VALUE->ViewValue = FormatNumber($this->DISCOUNT_VALUE->ViewValue, 2, -2, -2, -2);
            $this->DISCOUNT_VALUE->ViewCustomAttributes = "";

            // PAID_VALUE
            $this->PAID_VALUE->ViewValue = $this->PAID_VALUE->CurrentValue;
            $this->PAID_VALUE->ViewValue = FormatNumber($this->PAID_VALUE->ViewValue, 2, -2, -2, -2);
            $this->PAID_VALUE->ViewCustomAttributes = "";

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

            // FAKTUR_DATE
            $this->FAKTUR_DATE->ViewValue = $this->FAKTUR_DATE->CurrentValue;
            $this->FAKTUR_DATE->ViewValue = FormatDateTime($this->FAKTUR_DATE->ViewValue, 0);
            $this->FAKTUR_DATE->ViewCustomAttributes = "";

            // DISTRIBUTION_TYPE
            $this->DISTRIBUTION_TYPE->ViewValue = $this->DISTRIBUTION_TYPE->CurrentValue;
            $this->DISTRIBUTION_TYPE->ViewValue = FormatNumber($this->DISTRIBUTION_TYPE->ViewValue, 0, -2, -2, -2);
            $this->DISTRIBUTION_TYPE->ViewCustomAttributes = "";

            // DISCOUNTOFF_VALUE
            $this->DISCOUNTOFF_VALUE->ViewValue = $this->DISCOUNTOFF_VALUE->CurrentValue;
            $this->DISCOUNTOFF_VALUE->ViewValue = FormatNumber($this->DISCOUNTOFF_VALUE->ViewValue, 2, -2, -2, -2);
            $this->DISCOUNTOFF_VALUE->ViewCustomAttributes = "";

            // THECOUNTER
            $this->THECOUNTER->ViewValue = $this->THECOUNTER->CurrentValue;
            $this->THECOUNTER->ViewValue = FormatNumber($this->THECOUNTER->ViewValue, 0, -2, -2, -2);
            $this->THECOUNTER->ViewCustomAttributes = "";

            // FUND_ID
            $this->FUND_ID->ViewValue = $this->FUND_ID->CurrentValue;
            $this->FUND_ID->ViewValue = FormatNumber($this->FUND_ID->ViewValue, 0, -2, -2, -2);
            $this->FUND_ID->ViewCustomAttributes = "";

            // ORDER_BY
            $this->ORDER_BY->ViewValue = $this->ORDER_BY->CurrentValue;
            $this->ORDER_BY->ViewCustomAttributes = "";

            // ACKNOWLEDGEBY
            $this->ACKNOWLEDGEBY->ViewValue = $this->ACKNOWLEDGEBY->CurrentValue;
            $this->ACKNOWLEDGEBY->ViewCustomAttributes = "";

            // NUM
            $this->NUM->ViewValue = $this->NUM->CurrentValue;
            $this->NUM->ViewValue = FormatNumber($this->NUM->ViewValue, 0, -2, -2, -2);
            $this->NUM->ViewCustomAttributes = "";

            // ISPO
            $this->ISPO->ViewValue = $this->ISPO->CurrentValue;
            $this->ISPO->ViewCustomAttributes = "";

            // DOCS_TYPE
            $this->DOCS_TYPE->ViewValue = $this->DOCS_TYPE->CurrentValue;
            $this->DOCS_TYPE->ViewValue = FormatNumber($this->DOCS_TYPE->ViewValue, 0, -2, -2, -2);
            $this->DOCS_TYPE->ViewCustomAttributes = "";

            // PO_DATE
            $this->PO_DATE->ViewValue = $this->PO_DATE->CurrentValue;
            $this->PO_DATE->ViewValue = FormatDateTime($this->PO_DATE->ViewValue, 0);
            $this->PO_DATE->ViewCustomAttributes = "";

            // PO_VALUE
            $this->PO_VALUE->ViewValue = $this->PO_VALUE->CurrentValue;
            $this->PO_VALUE->ViewValue = FormatNumber($this->PO_VALUE->ViewValue, 2, -2, -2, -2);
            $this->PO_VALUE->ViewCustomAttributes = "";

            // ORG_UNIT_CODE
            $this->ORG_UNIT_CODE->LinkCustomAttributes = "";
            $this->ORG_UNIT_CODE->HrefValue = "";
            $this->ORG_UNIT_CODE->TooltipValue = "";

            // INVOICE_ID
            $this->INVOICE_ID->LinkCustomAttributes = "";
            $this->INVOICE_ID->HrefValue = "";
            $this->INVOICE_ID->TooltipValue = "";

            // INVOICE_ID2
            $this->INVOICE_ID2->LinkCustomAttributes = "";
            $this->INVOICE_ID2->HrefValue = "";
            $this->INVOICE_ID2->TooltipValue = "";

            // INVOICE_DATE
            $this->INVOICE_DATE->LinkCustomAttributes = "";
            $this->INVOICE_DATE->HrefValue = "";
            $this->INVOICE_DATE->TooltipValue = "";

            // PO
            $this->PO->LinkCustomAttributes = "";
            $this->PO->HrefValue = "";
            $this->PO->TooltipValue = "";

            // COMPANY_ID
            $this->COMPANY_ID->LinkCustomAttributes = "";
            $this->COMPANY_ID->HrefValue = "";
            $this->COMPANY_ID->TooltipValue = "";

            // RECEIVED_DATE
            $this->RECEIVED_DATE->LinkCustomAttributes = "";
            $this->RECEIVED_DATE->HrefValue = "";
            $this->RECEIVED_DATE->TooltipValue = "";

            // AMOUNT
            $this->AMOUNT->LinkCustomAttributes = "";
            $this->AMOUNT->HrefValue = "";
            $this->AMOUNT->TooltipValue = "";

            // PAYMENT_DUE
            $this->PAYMENT_DUE->LinkCustomAttributes = "";
            $this->PAYMENT_DUE->HrefValue = "";
            $this->PAYMENT_DUE->TooltipValue = "";

            // DESCRIPTION
            $this->DESCRIPTION->LinkCustomAttributes = "";
            $this->DESCRIPTION->HrefValue = "";
            $this->DESCRIPTION->TooltipValue = "";

            // MODIFIED_DATE
            $this->MODIFIED_DATE->LinkCustomAttributes = "";
            $this->MODIFIED_DATE->HrefValue = "";
            $this->MODIFIED_DATE->TooltipValue = "";

            // MODIFIED_BY
            $this->MODIFIED_BY->LinkCustomAttributes = "";
            $this->MODIFIED_BY->HrefValue = "";
            $this->MODIFIED_BY->TooltipValue = "";

            // RECEIVED_BY
            $this->RECEIVED_BY->LinkCustomAttributes = "";
            $this->RECEIVED_BY->HrefValue = "";
            $this->RECEIVED_BY->TooltipValue = "";

            // PRIORITY
            $this->PRIORITY->LinkCustomAttributes = "";
            $this->PRIORITY->HrefValue = "";
            $this->PRIORITY->TooltipValue = "";

            // CREDIT_NOTE
            $this->CREDIT_NOTE->LinkCustomAttributes = "";
            $this->CREDIT_NOTE->HrefValue = "";
            $this->CREDIT_NOTE->TooltipValue = "";

            // CREDIT_AMOUNT
            $this->CREDIT_AMOUNT->LinkCustomAttributes = "";
            $this->CREDIT_AMOUNT->HrefValue = "";
            $this->CREDIT_AMOUNT->TooltipValue = "";

            // PPN
            $this->PPN->LinkCustomAttributes = "";
            $this->PPN->HrefValue = "";
            $this->PPN->TooltipValue = "";

            // MATERAI
            $this->MATERAI->LinkCustomAttributes = "";
            $this->MATERAI->HrefValue = "";
            $this->MATERAI->TooltipValue = "";

            // SENT_BY
            $this->SENT_BY->LinkCustomAttributes = "";
            $this->SENT_BY->HrefValue = "";
            $this->SENT_BY->TooltipValue = "";

            // ACCOUNT_ID
            $this->ACCOUNT_ID->LinkCustomAttributes = "";
            $this->ACCOUNT_ID->HrefValue = "";
            $this->ACCOUNT_ID->TooltipValue = "";

            // FINANCE_ID
            $this->FINANCE_ID->LinkCustomAttributes = "";
            $this->FINANCE_ID->HrefValue = "";
            $this->FINANCE_ID->TooltipValue = "";

            // potongan
            $this->potongan->LinkCustomAttributes = "";
            $this->potongan->HrefValue = "";
            $this->potongan->TooltipValue = "";

            // RECEIVED_VALUE
            $this->RECEIVED_VALUE->LinkCustomAttributes = "";
            $this->RECEIVED_VALUE->HrefValue = "";
            $this->RECEIVED_VALUE->TooltipValue = "";

            // NO_ORDER
            $this->NO_ORDER->LinkCustomAttributes = "";
            $this->NO_ORDER->HrefValue = "";
            $this->NO_ORDER->TooltipValue = "";

            // CONTRACT_NO
            $this->CONTRACT_NO->LinkCustomAttributes = "";
            $this->CONTRACT_NO->HrefValue = "";
            $this->CONTRACT_NO->TooltipValue = "";

            // ORG_ID
            $this->ORG_ID->LinkCustomAttributes = "";
            $this->ORG_ID->HrefValue = "";
            $this->ORG_ID->TooltipValue = "";

            // CLINIC_ID
            $this->CLINIC_ID->LinkCustomAttributes = "";
            $this->CLINIC_ID->HrefValue = "";
            $this->CLINIC_ID->TooltipValue = "";

            // PPN_VALUE
            $this->PPN_VALUE->LinkCustomAttributes = "";
            $this->PPN_VALUE->HrefValue = "";
            $this->PPN_VALUE->TooltipValue = "";

            // DISCOUNT_VALUE
            $this->DISCOUNT_VALUE->LinkCustomAttributes = "";
            $this->DISCOUNT_VALUE->HrefValue = "";
            $this->DISCOUNT_VALUE->TooltipValue = "";

            // PAID_VALUE
            $this->PAID_VALUE->LinkCustomAttributes = "";
            $this->PAID_VALUE->HrefValue = "";
            $this->PAID_VALUE->TooltipValue = "";

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

            // FAKTUR_DATE
            $this->FAKTUR_DATE->LinkCustomAttributes = "";
            $this->FAKTUR_DATE->HrefValue = "";
            $this->FAKTUR_DATE->TooltipValue = "";

            // DISTRIBUTION_TYPE
            $this->DISTRIBUTION_TYPE->LinkCustomAttributes = "";
            $this->DISTRIBUTION_TYPE->HrefValue = "";
            $this->DISTRIBUTION_TYPE->TooltipValue = "";

            // DISCOUNTOFF_VALUE
            $this->DISCOUNTOFF_VALUE->LinkCustomAttributes = "";
            $this->DISCOUNTOFF_VALUE->HrefValue = "";
            $this->DISCOUNTOFF_VALUE->TooltipValue = "";

            // THECOUNTER
            $this->THECOUNTER->LinkCustomAttributes = "";
            $this->THECOUNTER->HrefValue = "";
            $this->THECOUNTER->TooltipValue = "";

            // FUND_ID
            $this->FUND_ID->LinkCustomAttributes = "";
            $this->FUND_ID->HrefValue = "";
            $this->FUND_ID->TooltipValue = "";

            // ORDER_BY
            $this->ORDER_BY->LinkCustomAttributes = "";
            $this->ORDER_BY->HrefValue = "";
            $this->ORDER_BY->TooltipValue = "";

            // ACKNOWLEDGEBY
            $this->ACKNOWLEDGEBY->LinkCustomAttributes = "";
            $this->ACKNOWLEDGEBY->HrefValue = "";
            $this->ACKNOWLEDGEBY->TooltipValue = "";

            // NUM
            $this->NUM->LinkCustomAttributes = "";
            $this->NUM->HrefValue = "";
            $this->NUM->TooltipValue = "";

            // ISPO
            $this->ISPO->LinkCustomAttributes = "";
            $this->ISPO->HrefValue = "";
            $this->ISPO->TooltipValue = "";

            // DOCS_TYPE
            $this->DOCS_TYPE->LinkCustomAttributes = "";
            $this->DOCS_TYPE->HrefValue = "";
            $this->DOCS_TYPE->TooltipValue = "";

            // PO_DATE
            $this->PO_DATE->LinkCustomAttributes = "";
            $this->PO_DATE->HrefValue = "";
            $this->PO_DATE->TooltipValue = "";

            // PO_VALUE
            $this->PO_VALUE->LinkCustomAttributes = "";
            $this->PO_VALUE->HrefValue = "";
            $this->PO_VALUE->TooltipValue = "";
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
        $item->Body = "<a class=\"btn btn-default ew-search-toggle" . $searchToggleClass . "\" href=\"#\" role=\"button\" title=\"" . $Language->phrase("SearchPanel") . "\" data-caption=\"" . $Language->phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fPO_INVOICElistsrch\" aria-pressed=\"" . ($searchToggleClass == " active" ? "true" : "false") . "\">" . $Language->phrase("SearchLink") . "</a>";
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
