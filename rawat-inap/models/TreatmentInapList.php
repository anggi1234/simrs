<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class TreatmentInapList extends TreatmentInap
{
    use MessagesTrait;

    // Page ID
    public $PageID = "list";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'TREATMENT_INAP';

    // Page object name
    public $PageObjName = "TreatmentInapList";

    // Rendering View
    public $RenderingView = false;

    // Grid form hidden field names
    public $FormName = "fTREATMENT_INAPlist";
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

        // Table object (TREATMENT_INAP)
        if (!isset($GLOBALS["TREATMENT_INAP"]) || get_class($GLOBALS["TREATMENT_INAP"]) == PROJECT_NAMESPACE . "TREATMENT_INAP") {
            $GLOBALS["TREATMENT_INAP"] = &$this;
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
        $this->AddUrl = "TreatmentInapAdd";
        $this->InlineAddUrl = $pageUrl . "action=add";
        $this->GridAddUrl = $pageUrl . "action=gridadd";
        $this->GridEditUrl = $pageUrl . "action=gridedit";
        $this->MultiDeleteUrl = "TreatmentInapDelete";
        $this->MultiUpdateUrl = "TreatmentInapUpdate";

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'TREATMENT_INAP');
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
        $this->FilterOptions->TagClassName = "ew-filter-option fTREATMENT_INAPlistsrch";

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
                $doc = new $class(Container("TREATMENT_INAP"));
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
        if ($this->isAddOrEdit()) {
            $this->KELUAR_ID->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->BED_ID->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->EXIT_DATE->Visible = false;
        }
        if ($this->isAdd() || $this->isCopy() || $this->isGridAdd()) {
            $this->ID->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->CLINIC_TYPE->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->ID_1->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->ORG_UNIT_CODE->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->BILL_ID_1->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->NO_REGISTRATION_1->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->VISIT_ID_1->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->TARIF_ID_1->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->CLASS_ID_1->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->CLINIC_ID_1->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->CLINIC_ID_FROM_1->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->TREATMENT_1->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->TREAT_DATE_1->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->QUANTITY_1->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->MEASURE_ID_1->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->TRANS_ID_1->Visible = false;
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
    public $SearchFieldsPerRow = 5; // For extended search
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

        // Create form object
        $CurrentForm = new HttpForm();
        $this->CurrentAction = Param("action"); // Set up current action

        // Get grid add count
        $gridaddcnt = Get(Config("TABLE_GRID_ADD_ROW_COUNT"), "");
        if (is_numeric($gridaddcnt) && $gridaddcnt > 0) {
            $this->GridAddRowCount = $gridaddcnt;
        }

        // Set up list options
        $this->setupListOptions();
        $this->BILL_ID->Visible = false;
        $this->NO_REGISTRATION->setVisibility();
        $this->VISIT_ID->setVisibility();
        $this->TARIF_ID->setVisibility();
        $this->CLASS_ID->Visible = false;
        $this->CLINIC_ID->setVisibility();
        $this->CLINIC_ID_FROM->Visible = false;
        $this->TREATMENT->setVisibility();
        $this->TREAT_DATE->setVisibility();
        $this->QUANTITY->setVisibility();
        $this->KELUAR_ID->Visible = false;
        $this->BED_ID->Visible = false;
        $this->EXIT_DATE->Visible = false;
        $this->THENAME->Visible = false;
        $this->THEADDRESS->Visible = false;
        $this->THEID->Visible = false;
        $this->TRANS_ID->setVisibility();
        $this->ID->setVisibility();
        $this->AMOUNT->setVisibility();
        $this->POKOK_JUAL->setVisibility();
        $this->PPN->setVisibility();
        $this->SUBSIDI->setVisibility();
        $this->PRINT_DATE->setVisibility();
        $this->ISCETAK->setVisibility();
        $this->NOTA_NO->setVisibility();
        $this->KUITANSI_ID->setVisibility();
        $this->amount_paid->setVisibility();
        $this->sell_price->setVisibility();
        $this->diskon->setVisibility();
        $this->TAGIHAN->setVisibility();
        $this->CLINIC_TYPE->setVisibility();
        $this->ID_1->setVisibility();
        $this->ORG_UNIT_CODE->setVisibility();
        $this->BILL_ID_1->setVisibility();
        $this->NO_REGISTRATION_1->setVisibility();
        $this->VISIT_ID_1->setVisibility();
        $this->TARIF_ID_1->setVisibility();
        $this->CLASS_ID_1->setVisibility();
        $this->CLINIC_ID_1->setVisibility();
        $this->CLINIC_ID_FROM_1->setVisibility();
        $this->TREATMENT_1->setVisibility();
        $this->TREAT_DATE_1->setVisibility();
        $this->QUANTITY_1->setVisibility();
        $this->MEASURE_ID->setVisibility();
        $this->MEASURE_ID_1->setVisibility();
        $this->TRANS_ID_1->setVisibility();
        $this->hideFieldsForAddEdit();

        // Global Page Loading event (in userfn*.php)
        Page_Loading();

        // Page Load event
        if (method_exists($this, "pageLoad")) {
            $this->pageLoad();
        }

        // Set up master detail parameters
        $this->setupMasterParms();

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
        $this->setupLookupOptions($this->NO_REGISTRATION);
        $this->setupLookupOptions($this->TARIF_ID);
        $this->setupLookupOptions($this->CLINIC_ID);

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

            // Check QueryString parameters
            if (Get("action") !== null) {
                $this->CurrentAction = Get("action");

                // Clear inline mode
                if ($this->isCancel()) {
                    $this->clearInlineMode();
                }

                // Switch to grid edit mode
                if ($this->isGridEdit()) {
                    $this->gridEditMode();
                }

                // Switch to grid add mode
                if ($this->isGridAdd()) {
                    $this->gridAddMode();
                }
            } else {
                if (Post("action") !== null) {
                    $this->CurrentAction = Post("action"); // Get action

                    // Grid Update
                    if (($this->isGridUpdate() || $this->isGridOverwrite()) && Session(SESSION_INLINE_MODE) == "gridedit") {
                        if ($this->validateGridForm()) {
                            $gridUpdate = $this->gridUpdate();
                        } else {
                            $gridUpdate = false;
                        }
                        if ($gridUpdate) {
                        } else {
                            $this->EventCancelled = true;
                            $this->gridEditMode(); // Stay in Grid edit mode
                        }
                    }

                    // Grid Insert
                    if ($this->isGridInsert() && Session(SESSION_INLINE_MODE) == "gridadd") {
                        if ($this->validateGridForm()) {
                            $gridInsert = $this->gridInsert();
                        } else {
                            $gridInsert = false;
                        }
                        if ($gridInsert) {
                        } else {
                            $this->EventCancelled = true;
                            $this->gridAddMode(); // Stay in Grid add mode
                        }
                    }
                } elseif (Session(SESSION_INLINE_MODE) == "gridedit") { // Previously in grid edit mode
                    if (Get(Config("TABLE_START_REC")) !== null || Get(Config("TABLE_PAGE_NO")) !== null) { // Stay in grid edit mode if paging
                        $this->gridEditMode();
                    } else { // Reset grid edit
                        $this->clearInlineMode();
                    }
                }
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

            // Show grid delete link for grid add / grid edit
            if ($this->AllowAddDeleteRow) {
                if ($this->isGridAdd() || $this->isGridEdit()) {
                    $item = $this->ListOptions["griddelete"];
                    if ($item) {
                        $item->Visible = true;
                    }
                }
            }

            // Get default search criteria
            AddFilter($this->DefaultSearchWhere, $this->basicSearchWhere(true));
            AddFilter($this->DefaultSearchWhere, $this->advancedSearchWhere(true));

            // Get basic search values
            $this->loadBasicSearchValues();

            // Get and validate search values for advanced search
            $this->loadSearchValues(); // Get search values

            // Process filter list
            if ($this->processFilterList()) {
                $this->terminate();
                return;
            }
            if (!$this->validateSearch()) {
                // Nothing to do
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

            // Get search criteria for advanced search
            if (!$this->hasInvalidFields()) {
                $srchAdvanced = $this->advancedSearchWhere();
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

            // Load advanced search from default
            if ($this->loadAdvancedSearchDefault()) {
                $srchAdvanced = $this->advancedSearchWhere();
            }
        }

        // Restore search settings from Session
        if (!$this->hasInvalidFields()) {
            $this->loadAdvancedSearch();
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

        // Restore master/detail filter
        $this->DbMasterFilter = $this->getMasterFilter(); // Restore master filter
        $this->DbDetailFilter = $this->getDetailFilter(); // Restore detail filter
        AddFilter($filter, $this->DbDetailFilter);
        AddFilter($filter, $this->SearchWhere);

        // Load master record
        if ($this->CurrentMode != "add" && $this->getMasterFilter() != "" && $this->getCurrentMasterTable() == "PASIEN_VISITATION") {
            $masterTbl = Container("PASIEN_VISITATION");
            $rsmaster = $masterTbl->loadRs($this->DbMasterFilter)->fetch(\PDO::FETCH_ASSOC);
            $this->MasterRecordExists = $rsmaster !== false;
            if (!$this->MasterRecordExists) {
                $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record found
                $this->terminate("PasienVisitationList"); // Return to master page
                return;
            } else {
                $masterTbl->loadListRowValues($rsmaster);
                $masterTbl->RowType = ROWTYPE_MASTER; // Master row
                $masterTbl->renderListRow();
            }
        }

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

    // Exit inline mode
    protected function clearInlineMode()
    {
        $this->QUANTITY->FormValue = ""; // Clear form value
        $this->AMOUNT->FormValue = ""; // Clear form value
        $this->POKOK_JUAL->FormValue = ""; // Clear form value
        $this->PPN->FormValue = ""; // Clear form value
        $this->SUBSIDI->FormValue = ""; // Clear form value
        $this->amount_paid->FormValue = ""; // Clear form value
        $this->sell_price->FormValue = ""; // Clear form value
        $this->diskon->FormValue = ""; // Clear form value
        $this->TAGIHAN->FormValue = ""; // Clear form value
        $this->QUANTITY_1->FormValue = ""; // Clear form value
        $this->LastAction = $this->CurrentAction; // Save last action
        $this->CurrentAction = ""; // Clear action
        $_SESSION[SESSION_INLINE_MODE] = ""; // Clear inline mode
    }

    // Switch to Grid Add mode
    protected function gridAddMode()
    {
        $this->CurrentAction = "gridadd";
        $_SESSION[SESSION_INLINE_MODE] = "gridadd";
        $this->hideFieldsForAddEdit();
    }

    // Switch to Grid Edit mode
    protected function gridEditMode()
    {
        $this->CurrentAction = "gridedit";
        $_SESSION[SESSION_INLINE_MODE] = "gridedit";
        $this->hideFieldsForAddEdit();
    }

    // Perform update to grid
    public function gridUpdate()
    {
        global $Language, $CurrentForm;
        $gridUpdate = true;

        // Get old recordset
        $this->CurrentFilter = $this->buildKeyFilter();
        if ($this->CurrentFilter == "") {
            $this->CurrentFilter = "0=1";
        }
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        if ($rs = $conn->executeQuery($sql)) {
            $rsold = $rs->fetchAll();
            $rs->closeCursor();
        }

        // Call Grid Updating event
        if (!$this->gridUpdating($rsold)) {
            if ($this->getFailureMessage() == "") {
                $this->setFailureMessage($Language->phrase("GridEditCancelled")); // Set grid edit cancelled message
            }
            return false;
        }

        // Begin transaction
        $conn->beginTransaction();
        $key = "";

        // Update row index and get row key
        $CurrentForm->Index = -1;
        $rowcnt = strval($CurrentForm->getValue($this->FormKeyCountName));
        if ($rowcnt == "" || !is_numeric($rowcnt)) {
            $rowcnt = 0;
        }

        // Update all rows based on key
        for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
            $CurrentForm->Index = $rowindex;
            $this->setKey($CurrentForm->getValue($this->OldKeyName));
            $rowaction = strval($CurrentForm->getValue($this->FormActionName));

            // Load all values and keys
            if ($rowaction != "insertdelete") { // Skip insert then deleted rows
                $this->loadFormValues(); // Get form values
                if ($rowaction == "" || $rowaction == "edit" || $rowaction == "delete") {
                    $gridUpdate = $this->OldKey != ""; // Key must not be empty
                } else {
                    $gridUpdate = true;
                }

                // Skip empty row
                if ($rowaction == "insert" && $this->emptyRow()) {
                // Validate form and insert/update/delete record
                } elseif ($gridUpdate) {
                    if ($rowaction == "delete") {
                        $this->CurrentFilter = $this->getRecordFilter();
                        $gridUpdate = $this->deleteRows(); // Delete this row
                    //} elseif (!$this->validateForm()) { // Already done in validateGridForm
                    //    $gridUpdate = false; // Form error, reset action
                    } else {
                        if ($rowaction == "insert") {
                            $gridUpdate = $this->addRow(); // Insert this row
                        } else {
                            if ($this->OldKey != "") {
                                $this->SendEmail = false; // Do not send email on update success
                                $gridUpdate = $this->editRow(); // Update this row
                            }
                        } // End update
                    }
                }
                if ($gridUpdate) {
                    if ($key != "") {
                        $key .= ", ";
                    }
                    $key .= $this->OldKey;
                } else {
                    break;
                }
            }
        }
        if ($gridUpdate) {
            $conn->commit(); // Commit transaction

            // Get new records
            $rsnew = $conn->fetchAll($sql);

            // Call Grid_Updated event
            $this->gridUpdated($rsold, $rsnew);
            if ($this->getSuccessMessage() == "") {
                $this->setSuccessMessage($Language->phrase("UpdateSuccess")); // Set up update success message
            }
            $this->clearInlineMode(); // Clear inline edit mode
        } else {
            $conn->rollback(); // Rollback transaction
            if ($this->getFailureMessage() == "") {
                $this->setFailureMessage($Language->phrase("UpdateFailed")); // Set update failed message
            }
        }
        return $gridUpdate;
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

    // Perform Grid Add
    public function gridInsert()
    {
        global $Language, $CurrentForm;
        $rowindex = 1;
        $gridInsert = false;
        $conn = $this->getConnection();

        // Call Grid Inserting event
        if (!$this->gridInserting()) {
            if ($this->getFailureMessage() == "") {
                $this->setFailureMessage($Language->phrase("GridAddCancelled")); // Set grid add cancelled message
            }
            return false;
        }

        // Begin transaction
        $conn->beginTransaction();

        // Init key filter
        $wrkfilter = "";
        $addcnt = 0;
        $key = "";

        // Get row count
        $CurrentForm->Index = -1;
        $rowcnt = strval($CurrentForm->getValue($this->FormKeyCountName));
        if ($rowcnt == "" || !is_numeric($rowcnt)) {
            $rowcnt = 0;
        }

        // Insert all rows
        for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
            // Load current row values
            $CurrentForm->Index = $rowindex;
            $rowaction = strval($CurrentForm->getValue($this->FormActionName));
            if ($rowaction != "" && $rowaction != "insert") {
                continue; // Skip
            }
            if ($rowaction == "insert") {
                $this->OldKey = strval($CurrentForm->getValue($this->OldKeyName));
                $this->loadOldRecord(); // Load old record
            }
            $this->loadFormValues(); // Get form values
            if (!$this->emptyRow()) {
                $addcnt++;
                $this->SendEmail = false; // Do not send email on insert success

                // Validate form // Already done in validateGridForm
                //if (!$this->validateForm()) {
                //    $gridInsert = false; // Form error, reset action
                //} else {
                    $gridInsert = $this->addRow($this->OldRecordset); // Insert this row
                //}
                if ($gridInsert) {
                    if ($key != "") {
                        $key .= Config("COMPOSITE_KEY_SEPARATOR");
                    }
                    $key .= $this->ID->CurrentValue;

                    // Add filter for this record
                    $filter = $this->getRecordFilter();
                    if ($wrkfilter != "") {
                        $wrkfilter .= " OR ";
                    }
                    $wrkfilter .= $filter;
                } else {
                    break;
                }
            }
        }
        if ($addcnt == 0) { // No record inserted
            $this->setFailureMessage($Language->phrase("NoAddRecord"));
            $gridInsert = false;
        }
        if ($gridInsert) {
            $conn->commit(); // Commit transaction

            // Get new records
            $this->CurrentFilter = $wrkfilter;
            $sql = $this->getCurrentSql();
            $rsnew = $conn->fetchAll($sql);

            // Call Grid_Inserted event
            $this->gridInserted($rsnew);
            if ($this->getSuccessMessage() == "") {
                $this->setSuccessMessage($Language->phrase("InsertSuccess")); // Set up insert success message
            }
            $this->clearInlineMode(); // Clear grid add mode
        } else {
            $conn->rollback(); // Rollback transaction
            if ($this->getFailureMessage() == "") {
                $this->setFailureMessage($Language->phrase("InsertFailed")); // Set insert failed message
            }
        }
        return $gridInsert;
    }

    // Check if empty row
    public function emptyRow()
    {
        global $CurrentForm;
        if ($CurrentForm->hasValue("x_NO_REGISTRATION") && $CurrentForm->hasValue("o_NO_REGISTRATION") && $this->NO_REGISTRATION->CurrentValue != $this->NO_REGISTRATION->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_VISIT_ID") && $CurrentForm->hasValue("o_VISIT_ID") && $this->VISIT_ID->CurrentValue != $this->VISIT_ID->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_TARIF_ID") && $CurrentForm->hasValue("o_TARIF_ID") && $this->TARIF_ID->CurrentValue != $this->TARIF_ID->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_CLINIC_ID") && $CurrentForm->hasValue("o_CLINIC_ID") && $this->CLINIC_ID->CurrentValue != $this->CLINIC_ID->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_TREATMENT") && $CurrentForm->hasValue("o_TREATMENT") && $this->TREATMENT->CurrentValue != $this->TREATMENT->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_TREAT_DATE") && $CurrentForm->hasValue("o_TREAT_DATE") && $this->TREAT_DATE->CurrentValue != $this->TREAT_DATE->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_QUANTITY") && $CurrentForm->hasValue("o_QUANTITY") && $this->QUANTITY->CurrentValue != $this->QUANTITY->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_TRANS_ID") && $CurrentForm->hasValue("o_TRANS_ID") && $this->TRANS_ID->CurrentValue != $this->TRANS_ID->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_AMOUNT") && $CurrentForm->hasValue("o_AMOUNT") && $this->AMOUNT->CurrentValue != $this->AMOUNT->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_POKOK_JUAL") && $CurrentForm->hasValue("o_POKOK_JUAL") && $this->POKOK_JUAL->CurrentValue != $this->POKOK_JUAL->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_PPN") && $CurrentForm->hasValue("o_PPN") && $this->PPN->CurrentValue != $this->PPN->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_SUBSIDI") && $CurrentForm->hasValue("o_SUBSIDI") && $this->SUBSIDI->CurrentValue != $this->SUBSIDI->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_PRINT_DATE") && $CurrentForm->hasValue("o_PRINT_DATE") && $this->PRINT_DATE->CurrentValue != $this->PRINT_DATE->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_ISCETAK") && $CurrentForm->hasValue("o_ISCETAK") && $this->ISCETAK->CurrentValue != $this->ISCETAK->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_NOTA_NO") && $CurrentForm->hasValue("o_NOTA_NO") && $this->NOTA_NO->CurrentValue != $this->NOTA_NO->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_KUITANSI_ID") && $CurrentForm->hasValue("o_KUITANSI_ID") && $this->KUITANSI_ID->CurrentValue != $this->KUITANSI_ID->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_amount_paid") && $CurrentForm->hasValue("o_amount_paid") && $this->amount_paid->CurrentValue != $this->amount_paid->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_sell_price") && $CurrentForm->hasValue("o_sell_price") && $this->sell_price->CurrentValue != $this->sell_price->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_diskon") && $CurrentForm->hasValue("o_diskon") && $this->diskon->CurrentValue != $this->diskon->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_TAGIHAN") && $CurrentForm->hasValue("o_TAGIHAN") && $this->TAGIHAN->CurrentValue != $this->TAGIHAN->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_CLINIC_TYPE") && $CurrentForm->hasValue("o_CLINIC_TYPE") && $this->CLINIC_TYPE->CurrentValue != $this->CLINIC_TYPE->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_ORG_UNIT_CODE") && $CurrentForm->hasValue("o_ORG_UNIT_CODE") && $this->ORG_UNIT_CODE->CurrentValue != $this->ORG_UNIT_CODE->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_BILL_ID_1") && $CurrentForm->hasValue("o_BILL_ID_1") && $this->BILL_ID_1->CurrentValue != $this->BILL_ID_1->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_NO_REGISTRATION_1") && $CurrentForm->hasValue("o_NO_REGISTRATION_1") && $this->NO_REGISTRATION_1->CurrentValue != $this->NO_REGISTRATION_1->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_VISIT_ID_1") && $CurrentForm->hasValue("o_VISIT_ID_1") && $this->VISIT_ID_1->CurrentValue != $this->VISIT_ID_1->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_TARIF_ID_1") && $CurrentForm->hasValue("o_TARIF_ID_1") && $this->TARIF_ID_1->CurrentValue != $this->TARIF_ID_1->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_CLASS_ID_1") && $CurrentForm->hasValue("o_CLASS_ID_1") && $this->CLASS_ID_1->CurrentValue != $this->CLASS_ID_1->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_CLINIC_ID_1") && $CurrentForm->hasValue("o_CLINIC_ID_1") && $this->CLINIC_ID_1->CurrentValue != $this->CLINIC_ID_1->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_CLINIC_ID_FROM_1") && $CurrentForm->hasValue("o_CLINIC_ID_FROM_1") && $this->CLINIC_ID_FROM_1->CurrentValue != $this->CLINIC_ID_FROM_1->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_TREATMENT_1") && $CurrentForm->hasValue("o_TREATMENT_1") && $this->TREATMENT_1->CurrentValue != $this->TREATMENT_1->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_TREAT_DATE_1") && $CurrentForm->hasValue("o_TREAT_DATE_1") && $this->TREAT_DATE_1->CurrentValue != $this->TREAT_DATE_1->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_QUANTITY_1") && $CurrentForm->hasValue("o_QUANTITY_1") && $this->QUANTITY_1->CurrentValue != $this->QUANTITY_1->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_MEASURE_ID") && $CurrentForm->hasValue("o_MEASURE_ID") && $this->MEASURE_ID->CurrentValue != $this->MEASURE_ID->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_MEASURE_ID_1") && $CurrentForm->hasValue("o_MEASURE_ID_1") && $this->MEASURE_ID_1->CurrentValue != $this->MEASURE_ID_1->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_TRANS_ID_1") && $CurrentForm->hasValue("o_TRANS_ID_1") && $this->TRANS_ID_1->CurrentValue != $this->TRANS_ID_1->OldValue) {
            return false;
        }
        return true;
    }

    // Validate grid form
    public function validateGridForm()
    {
        global $CurrentForm;
        // Get row count
        $CurrentForm->Index = -1;
        $rowcnt = strval($CurrentForm->getValue($this->FormKeyCountName));
        if ($rowcnt == "" || !is_numeric($rowcnt)) {
            $rowcnt = 0;
        }

        // Validate all records
        for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
            // Load current row values
            $CurrentForm->Index = $rowindex;
            $rowaction = strval($CurrentForm->getValue($this->FormActionName));
            if ($rowaction != "delete" && $rowaction != "insertdelete") {
                $this->loadFormValues(); // Get form values
                if ($rowaction == "insert" && $this->emptyRow()) {
                    // Ignore
                } elseif (!$this->validateForm()) {
                    return false;
                }
            }
        }
        return true;
    }

    // Get all form values of the grid
    public function getGridFormValues()
    {
        global $CurrentForm;
        // Get row count
        $CurrentForm->Index = -1;
        $rowcnt = strval($CurrentForm->getValue($this->FormKeyCountName));
        if ($rowcnt == "" || !is_numeric($rowcnt)) {
            $rowcnt = 0;
        }
        $rows = [];

        // Loop through all records
        for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
            // Load current row values
            $CurrentForm->Index = $rowindex;
            $rowaction = strval($CurrentForm->getValue($this->FormActionName));
            if ($rowaction != "delete" && $rowaction != "insertdelete") {
                $this->loadFormValues(); // Get form values
                if ($rowaction == "insert" && $this->emptyRow()) {
                    // Ignore
                } else {
                    $rows[] = $this->getFieldValues("FormValue"); // Return row as array
                }
            }
        }
        return $rows; // Return as array of array
    }

    // Restore form values for current row
    public function restoreCurrentRowFormValues($idx)
    {
        global $CurrentForm;

        // Get row based on current index
        $CurrentForm->Index = $idx;
        $rowaction = strval($CurrentForm->getValue($this->FormActionName));
        $this->loadFormValues(); // Load form values
        // Set up invalid status correctly
        $this->resetFormError();
        if ($rowaction == "insert" && $this->emptyRow()) {
            // Ignore
        } else {
            $this->validateForm();
        }
    }

    // Reset form status
    public function resetFormError()
    {
        $this->NO_REGISTRATION->clearErrorMessage();
        $this->VISIT_ID->clearErrorMessage();
        $this->TARIF_ID->clearErrorMessage();
        $this->CLINIC_ID->clearErrorMessage();
        $this->TREATMENT->clearErrorMessage();
        $this->TREAT_DATE->clearErrorMessage();
        $this->QUANTITY->clearErrorMessage();
        $this->TRANS_ID->clearErrorMessage();
        $this->ID->clearErrorMessage();
        $this->AMOUNT->clearErrorMessage();
        $this->POKOK_JUAL->clearErrorMessage();
        $this->PPN->clearErrorMessage();
        $this->SUBSIDI->clearErrorMessage();
        $this->PRINT_DATE->clearErrorMessage();
        $this->ISCETAK->clearErrorMessage();
        $this->NOTA_NO->clearErrorMessage();
        $this->KUITANSI_ID->clearErrorMessage();
        $this->amount_paid->clearErrorMessage();
        $this->sell_price->clearErrorMessage();
        $this->diskon->clearErrorMessage();
        $this->TAGIHAN->clearErrorMessage();
        $this->CLINIC_TYPE->clearErrorMessage();
        $this->ID_1->clearErrorMessage();
        $this->ORG_UNIT_CODE->clearErrorMessage();
        $this->BILL_ID_1->clearErrorMessage();
        $this->NO_REGISTRATION_1->clearErrorMessage();
        $this->VISIT_ID_1->clearErrorMessage();
        $this->TARIF_ID_1->clearErrorMessage();
        $this->CLASS_ID_1->clearErrorMessage();
        $this->CLINIC_ID_1->clearErrorMessage();
        $this->CLINIC_ID_FROM_1->clearErrorMessage();
        $this->TREATMENT_1->clearErrorMessage();
        $this->TREAT_DATE_1->clearErrorMessage();
        $this->QUANTITY_1->clearErrorMessage();
        $this->MEASURE_ID->clearErrorMessage();
        $this->MEASURE_ID_1->clearErrorMessage();
        $this->TRANS_ID_1->clearErrorMessage();
    }

    // Get list of filters
    public function getFilterList()
    {
        global $UserProfile;

        // Initialize
        $filterList = "";
        $savedFilterList = "";
        $filterList = Concat($filterList, $this->BILL_ID->AdvancedSearch->toJson(), ","); // Field BILL_ID
        $filterList = Concat($filterList, $this->NO_REGISTRATION->AdvancedSearch->toJson(), ","); // Field NO_REGISTRATION
        $filterList = Concat($filterList, $this->VISIT_ID->AdvancedSearch->toJson(), ","); // Field VISIT_ID
        $filterList = Concat($filterList, $this->TARIF_ID->AdvancedSearch->toJson(), ","); // Field TARIF_ID
        $filterList = Concat($filterList, $this->CLASS_ID->AdvancedSearch->toJson(), ","); // Field CLASS_ID
        $filterList = Concat($filterList, $this->CLINIC_ID->AdvancedSearch->toJson(), ","); // Field CLINIC_ID
        $filterList = Concat($filterList, $this->CLINIC_ID_FROM->AdvancedSearch->toJson(), ","); // Field CLINIC_ID_FROM
        $filterList = Concat($filterList, $this->TREATMENT->AdvancedSearch->toJson(), ","); // Field TREATMENT
        $filterList = Concat($filterList, $this->TREAT_DATE->AdvancedSearch->toJson(), ","); // Field TREAT_DATE
        $filterList = Concat($filterList, $this->QUANTITY->AdvancedSearch->toJson(), ","); // Field QUANTITY
        $filterList = Concat($filterList, $this->KELUAR_ID->AdvancedSearch->toJson(), ","); // Field KELUAR_ID
        $filterList = Concat($filterList, $this->BED_ID->AdvancedSearch->toJson(), ","); // Field BED_ID
        $filterList = Concat($filterList, $this->EXIT_DATE->AdvancedSearch->toJson(), ","); // Field EXIT_DATE
        $filterList = Concat($filterList, $this->THENAME->AdvancedSearch->toJson(), ","); // Field THENAME
        $filterList = Concat($filterList, $this->THEADDRESS->AdvancedSearch->toJson(), ","); // Field THEADDRESS
        $filterList = Concat($filterList, $this->THEID->AdvancedSearch->toJson(), ","); // Field THEID
        $filterList = Concat($filterList, $this->TRANS_ID->AdvancedSearch->toJson(), ","); // Field TRANS_ID
        $filterList = Concat($filterList, $this->ID->AdvancedSearch->toJson(), ","); // Field ID
        $filterList = Concat($filterList, $this->AMOUNT->AdvancedSearch->toJson(), ","); // Field AMOUNT
        $filterList = Concat($filterList, $this->POKOK_JUAL->AdvancedSearch->toJson(), ","); // Field POKOK_JUAL
        $filterList = Concat($filterList, $this->PPN->AdvancedSearch->toJson(), ","); // Field PPN
        $filterList = Concat($filterList, $this->SUBSIDI->AdvancedSearch->toJson(), ","); // Field SUBSIDI
        $filterList = Concat($filterList, $this->PRINT_DATE->AdvancedSearch->toJson(), ","); // Field PRINT_DATE
        $filterList = Concat($filterList, $this->ISCETAK->AdvancedSearch->toJson(), ","); // Field ISCETAK
        $filterList = Concat($filterList, $this->NOTA_NO->AdvancedSearch->toJson(), ","); // Field NOTA_NO
        $filterList = Concat($filterList, $this->KUITANSI_ID->AdvancedSearch->toJson(), ","); // Field KUITANSI_ID
        $filterList = Concat($filterList, $this->amount_paid->AdvancedSearch->toJson(), ","); // Field amount_paid
        $filterList = Concat($filterList, $this->sell_price->AdvancedSearch->toJson(), ","); // Field sell_price
        $filterList = Concat($filterList, $this->diskon->AdvancedSearch->toJson(), ","); // Field diskon
        $filterList = Concat($filterList, $this->TAGIHAN->AdvancedSearch->toJson(), ","); // Field TAGIHAN
        $filterList = Concat($filterList, $this->CLINIC_TYPE->AdvancedSearch->toJson(), ","); // Field CLINIC_TYPE
        $filterList = Concat($filterList, $this->ID_1->AdvancedSearch->toJson(), ","); // Field ID_1
        $filterList = Concat($filterList, $this->ORG_UNIT_CODE->AdvancedSearch->toJson(), ","); // Field ORG_UNIT_CODE
        $filterList = Concat($filterList, $this->BILL_ID_1->AdvancedSearch->toJson(), ","); // Field BILL_ID_1
        $filterList = Concat($filterList, $this->NO_REGISTRATION_1->AdvancedSearch->toJson(), ","); // Field NO_REGISTRATION_1
        $filterList = Concat($filterList, $this->VISIT_ID_1->AdvancedSearch->toJson(), ","); // Field VISIT_ID_1
        $filterList = Concat($filterList, $this->TARIF_ID_1->AdvancedSearch->toJson(), ","); // Field TARIF_ID_1
        $filterList = Concat($filterList, $this->CLASS_ID_1->AdvancedSearch->toJson(), ","); // Field CLASS_ID_1
        $filterList = Concat($filterList, $this->CLINIC_ID_1->AdvancedSearch->toJson(), ","); // Field CLINIC_ID_1
        $filterList = Concat($filterList, $this->CLINIC_ID_FROM_1->AdvancedSearch->toJson(), ","); // Field CLINIC_ID_FROM_1
        $filterList = Concat($filterList, $this->TREATMENT_1->AdvancedSearch->toJson(), ","); // Field TREATMENT_1
        $filterList = Concat($filterList, $this->TREAT_DATE_1->AdvancedSearch->toJson(), ","); // Field TREAT_DATE_1
        $filterList = Concat($filterList, $this->QUANTITY_1->AdvancedSearch->toJson(), ","); // Field QUANTITY_1
        $filterList = Concat($filterList, $this->MEASURE_ID->AdvancedSearch->toJson(), ","); // Field MEASURE_ID
        $filterList = Concat($filterList, $this->MEASURE_ID_1->AdvancedSearch->toJson(), ","); // Field MEASURE_ID_1
        $filterList = Concat($filterList, $this->TRANS_ID_1->AdvancedSearch->toJson(), ","); // Field TRANS_ID_1
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
            $UserProfile->setSearchFilters(CurrentUserName(), "fTREATMENT_INAPlistsrch", $filters);
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

        // Field QUANTITY
        $this->QUANTITY->AdvancedSearch->SearchValue = @$filter["x_QUANTITY"];
        $this->QUANTITY->AdvancedSearch->SearchOperator = @$filter["z_QUANTITY"];
        $this->QUANTITY->AdvancedSearch->SearchCondition = @$filter["v_QUANTITY"];
        $this->QUANTITY->AdvancedSearch->SearchValue2 = @$filter["y_QUANTITY"];
        $this->QUANTITY->AdvancedSearch->SearchOperator2 = @$filter["w_QUANTITY"];
        $this->QUANTITY->AdvancedSearch->save();

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

        // Field EXIT_DATE
        $this->EXIT_DATE->AdvancedSearch->SearchValue = @$filter["x_EXIT_DATE"];
        $this->EXIT_DATE->AdvancedSearch->SearchOperator = @$filter["z_EXIT_DATE"];
        $this->EXIT_DATE->AdvancedSearch->SearchCondition = @$filter["v_EXIT_DATE"];
        $this->EXIT_DATE->AdvancedSearch->SearchValue2 = @$filter["y_EXIT_DATE"];
        $this->EXIT_DATE->AdvancedSearch->SearchOperator2 = @$filter["w_EXIT_DATE"];
        $this->EXIT_DATE->AdvancedSearch->save();

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

        // Field TRANS_ID
        $this->TRANS_ID->AdvancedSearch->SearchValue = @$filter["x_TRANS_ID"];
        $this->TRANS_ID->AdvancedSearch->SearchOperator = @$filter["z_TRANS_ID"];
        $this->TRANS_ID->AdvancedSearch->SearchCondition = @$filter["v_TRANS_ID"];
        $this->TRANS_ID->AdvancedSearch->SearchValue2 = @$filter["y_TRANS_ID"];
        $this->TRANS_ID->AdvancedSearch->SearchOperator2 = @$filter["w_TRANS_ID"];
        $this->TRANS_ID->AdvancedSearch->save();

        // Field ID
        $this->ID->AdvancedSearch->SearchValue = @$filter["x_ID"];
        $this->ID->AdvancedSearch->SearchOperator = @$filter["z_ID"];
        $this->ID->AdvancedSearch->SearchCondition = @$filter["v_ID"];
        $this->ID->AdvancedSearch->SearchValue2 = @$filter["y_ID"];
        $this->ID->AdvancedSearch->SearchOperator2 = @$filter["w_ID"];
        $this->ID->AdvancedSearch->save();

        // Field AMOUNT
        $this->AMOUNT->AdvancedSearch->SearchValue = @$filter["x_AMOUNT"];
        $this->AMOUNT->AdvancedSearch->SearchOperator = @$filter["z_AMOUNT"];
        $this->AMOUNT->AdvancedSearch->SearchCondition = @$filter["v_AMOUNT"];
        $this->AMOUNT->AdvancedSearch->SearchValue2 = @$filter["y_AMOUNT"];
        $this->AMOUNT->AdvancedSearch->SearchOperator2 = @$filter["w_AMOUNT"];
        $this->AMOUNT->AdvancedSearch->save();

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

        // Field SUBSIDI
        $this->SUBSIDI->AdvancedSearch->SearchValue = @$filter["x_SUBSIDI"];
        $this->SUBSIDI->AdvancedSearch->SearchOperator = @$filter["z_SUBSIDI"];
        $this->SUBSIDI->AdvancedSearch->SearchCondition = @$filter["v_SUBSIDI"];
        $this->SUBSIDI->AdvancedSearch->SearchValue2 = @$filter["y_SUBSIDI"];
        $this->SUBSIDI->AdvancedSearch->SearchOperator2 = @$filter["w_SUBSIDI"];
        $this->SUBSIDI->AdvancedSearch->save();

        // Field PRINT_DATE
        $this->PRINT_DATE->AdvancedSearch->SearchValue = @$filter["x_PRINT_DATE"];
        $this->PRINT_DATE->AdvancedSearch->SearchOperator = @$filter["z_PRINT_DATE"];
        $this->PRINT_DATE->AdvancedSearch->SearchCondition = @$filter["v_PRINT_DATE"];
        $this->PRINT_DATE->AdvancedSearch->SearchValue2 = @$filter["y_PRINT_DATE"];
        $this->PRINT_DATE->AdvancedSearch->SearchOperator2 = @$filter["w_PRINT_DATE"];
        $this->PRINT_DATE->AdvancedSearch->save();

        // Field ISCETAK
        $this->ISCETAK->AdvancedSearch->SearchValue = @$filter["x_ISCETAK"];
        $this->ISCETAK->AdvancedSearch->SearchOperator = @$filter["z_ISCETAK"];
        $this->ISCETAK->AdvancedSearch->SearchCondition = @$filter["v_ISCETAK"];
        $this->ISCETAK->AdvancedSearch->SearchValue2 = @$filter["y_ISCETAK"];
        $this->ISCETAK->AdvancedSearch->SearchOperator2 = @$filter["w_ISCETAK"];
        $this->ISCETAK->AdvancedSearch->save();

        // Field NOTA_NO
        $this->NOTA_NO->AdvancedSearch->SearchValue = @$filter["x_NOTA_NO"];
        $this->NOTA_NO->AdvancedSearch->SearchOperator = @$filter["z_NOTA_NO"];
        $this->NOTA_NO->AdvancedSearch->SearchCondition = @$filter["v_NOTA_NO"];
        $this->NOTA_NO->AdvancedSearch->SearchValue2 = @$filter["y_NOTA_NO"];
        $this->NOTA_NO->AdvancedSearch->SearchOperator2 = @$filter["w_NOTA_NO"];
        $this->NOTA_NO->AdvancedSearch->save();

        // Field KUITANSI_ID
        $this->KUITANSI_ID->AdvancedSearch->SearchValue = @$filter["x_KUITANSI_ID"];
        $this->KUITANSI_ID->AdvancedSearch->SearchOperator = @$filter["z_KUITANSI_ID"];
        $this->KUITANSI_ID->AdvancedSearch->SearchCondition = @$filter["v_KUITANSI_ID"];
        $this->KUITANSI_ID->AdvancedSearch->SearchValue2 = @$filter["y_KUITANSI_ID"];
        $this->KUITANSI_ID->AdvancedSearch->SearchOperator2 = @$filter["w_KUITANSI_ID"];
        $this->KUITANSI_ID->AdvancedSearch->save();

        // Field amount_paid
        $this->amount_paid->AdvancedSearch->SearchValue = @$filter["x_amount_paid"];
        $this->amount_paid->AdvancedSearch->SearchOperator = @$filter["z_amount_paid"];
        $this->amount_paid->AdvancedSearch->SearchCondition = @$filter["v_amount_paid"];
        $this->amount_paid->AdvancedSearch->SearchValue2 = @$filter["y_amount_paid"];
        $this->amount_paid->AdvancedSearch->SearchOperator2 = @$filter["w_amount_paid"];
        $this->amount_paid->AdvancedSearch->save();

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

        // Field TAGIHAN
        $this->TAGIHAN->AdvancedSearch->SearchValue = @$filter["x_TAGIHAN"];
        $this->TAGIHAN->AdvancedSearch->SearchOperator = @$filter["z_TAGIHAN"];
        $this->TAGIHAN->AdvancedSearch->SearchCondition = @$filter["v_TAGIHAN"];
        $this->TAGIHAN->AdvancedSearch->SearchValue2 = @$filter["y_TAGIHAN"];
        $this->TAGIHAN->AdvancedSearch->SearchOperator2 = @$filter["w_TAGIHAN"];
        $this->TAGIHAN->AdvancedSearch->save();

        // Field CLINIC_TYPE
        $this->CLINIC_TYPE->AdvancedSearch->SearchValue = @$filter["x_CLINIC_TYPE"];
        $this->CLINIC_TYPE->AdvancedSearch->SearchOperator = @$filter["z_CLINIC_TYPE"];
        $this->CLINIC_TYPE->AdvancedSearch->SearchCondition = @$filter["v_CLINIC_TYPE"];
        $this->CLINIC_TYPE->AdvancedSearch->SearchValue2 = @$filter["y_CLINIC_TYPE"];
        $this->CLINIC_TYPE->AdvancedSearch->SearchOperator2 = @$filter["w_CLINIC_TYPE"];
        $this->CLINIC_TYPE->AdvancedSearch->save();

        // Field ID_1
        $this->ID_1->AdvancedSearch->SearchValue = @$filter["x_ID_1"];
        $this->ID_1->AdvancedSearch->SearchOperator = @$filter["z_ID_1"];
        $this->ID_1->AdvancedSearch->SearchCondition = @$filter["v_ID_1"];
        $this->ID_1->AdvancedSearch->SearchValue2 = @$filter["y_ID_1"];
        $this->ID_1->AdvancedSearch->SearchOperator2 = @$filter["w_ID_1"];
        $this->ID_1->AdvancedSearch->save();

        // Field ORG_UNIT_CODE
        $this->ORG_UNIT_CODE->AdvancedSearch->SearchValue = @$filter["x_ORG_UNIT_CODE"];
        $this->ORG_UNIT_CODE->AdvancedSearch->SearchOperator = @$filter["z_ORG_UNIT_CODE"];
        $this->ORG_UNIT_CODE->AdvancedSearch->SearchCondition = @$filter["v_ORG_UNIT_CODE"];
        $this->ORG_UNIT_CODE->AdvancedSearch->SearchValue2 = @$filter["y_ORG_UNIT_CODE"];
        $this->ORG_UNIT_CODE->AdvancedSearch->SearchOperator2 = @$filter["w_ORG_UNIT_CODE"];
        $this->ORG_UNIT_CODE->AdvancedSearch->save();

        // Field BILL_ID_1
        $this->BILL_ID_1->AdvancedSearch->SearchValue = @$filter["x_BILL_ID_1"];
        $this->BILL_ID_1->AdvancedSearch->SearchOperator = @$filter["z_BILL_ID_1"];
        $this->BILL_ID_1->AdvancedSearch->SearchCondition = @$filter["v_BILL_ID_1"];
        $this->BILL_ID_1->AdvancedSearch->SearchValue2 = @$filter["y_BILL_ID_1"];
        $this->BILL_ID_1->AdvancedSearch->SearchOperator2 = @$filter["w_BILL_ID_1"];
        $this->BILL_ID_1->AdvancedSearch->save();

        // Field NO_REGISTRATION_1
        $this->NO_REGISTRATION_1->AdvancedSearch->SearchValue = @$filter["x_NO_REGISTRATION_1"];
        $this->NO_REGISTRATION_1->AdvancedSearch->SearchOperator = @$filter["z_NO_REGISTRATION_1"];
        $this->NO_REGISTRATION_1->AdvancedSearch->SearchCondition = @$filter["v_NO_REGISTRATION_1"];
        $this->NO_REGISTRATION_1->AdvancedSearch->SearchValue2 = @$filter["y_NO_REGISTRATION_1"];
        $this->NO_REGISTRATION_1->AdvancedSearch->SearchOperator2 = @$filter["w_NO_REGISTRATION_1"];
        $this->NO_REGISTRATION_1->AdvancedSearch->save();

        // Field VISIT_ID_1
        $this->VISIT_ID_1->AdvancedSearch->SearchValue = @$filter["x_VISIT_ID_1"];
        $this->VISIT_ID_1->AdvancedSearch->SearchOperator = @$filter["z_VISIT_ID_1"];
        $this->VISIT_ID_1->AdvancedSearch->SearchCondition = @$filter["v_VISIT_ID_1"];
        $this->VISIT_ID_1->AdvancedSearch->SearchValue2 = @$filter["y_VISIT_ID_1"];
        $this->VISIT_ID_1->AdvancedSearch->SearchOperator2 = @$filter["w_VISIT_ID_1"];
        $this->VISIT_ID_1->AdvancedSearch->save();

        // Field TARIF_ID_1
        $this->TARIF_ID_1->AdvancedSearch->SearchValue = @$filter["x_TARIF_ID_1"];
        $this->TARIF_ID_1->AdvancedSearch->SearchOperator = @$filter["z_TARIF_ID_1"];
        $this->TARIF_ID_1->AdvancedSearch->SearchCondition = @$filter["v_TARIF_ID_1"];
        $this->TARIF_ID_1->AdvancedSearch->SearchValue2 = @$filter["y_TARIF_ID_1"];
        $this->TARIF_ID_1->AdvancedSearch->SearchOperator2 = @$filter["w_TARIF_ID_1"];
        $this->TARIF_ID_1->AdvancedSearch->save();

        // Field CLASS_ID_1
        $this->CLASS_ID_1->AdvancedSearch->SearchValue = @$filter["x_CLASS_ID_1"];
        $this->CLASS_ID_1->AdvancedSearch->SearchOperator = @$filter["z_CLASS_ID_1"];
        $this->CLASS_ID_1->AdvancedSearch->SearchCondition = @$filter["v_CLASS_ID_1"];
        $this->CLASS_ID_1->AdvancedSearch->SearchValue2 = @$filter["y_CLASS_ID_1"];
        $this->CLASS_ID_1->AdvancedSearch->SearchOperator2 = @$filter["w_CLASS_ID_1"];
        $this->CLASS_ID_1->AdvancedSearch->save();

        // Field CLINIC_ID_1
        $this->CLINIC_ID_1->AdvancedSearch->SearchValue = @$filter["x_CLINIC_ID_1"];
        $this->CLINIC_ID_1->AdvancedSearch->SearchOperator = @$filter["z_CLINIC_ID_1"];
        $this->CLINIC_ID_1->AdvancedSearch->SearchCondition = @$filter["v_CLINIC_ID_1"];
        $this->CLINIC_ID_1->AdvancedSearch->SearchValue2 = @$filter["y_CLINIC_ID_1"];
        $this->CLINIC_ID_1->AdvancedSearch->SearchOperator2 = @$filter["w_CLINIC_ID_1"];
        $this->CLINIC_ID_1->AdvancedSearch->save();

        // Field CLINIC_ID_FROM_1
        $this->CLINIC_ID_FROM_1->AdvancedSearch->SearchValue = @$filter["x_CLINIC_ID_FROM_1"];
        $this->CLINIC_ID_FROM_1->AdvancedSearch->SearchOperator = @$filter["z_CLINIC_ID_FROM_1"];
        $this->CLINIC_ID_FROM_1->AdvancedSearch->SearchCondition = @$filter["v_CLINIC_ID_FROM_1"];
        $this->CLINIC_ID_FROM_1->AdvancedSearch->SearchValue2 = @$filter["y_CLINIC_ID_FROM_1"];
        $this->CLINIC_ID_FROM_1->AdvancedSearch->SearchOperator2 = @$filter["w_CLINIC_ID_FROM_1"];
        $this->CLINIC_ID_FROM_1->AdvancedSearch->save();

        // Field TREATMENT_1
        $this->TREATMENT_1->AdvancedSearch->SearchValue = @$filter["x_TREATMENT_1"];
        $this->TREATMENT_1->AdvancedSearch->SearchOperator = @$filter["z_TREATMENT_1"];
        $this->TREATMENT_1->AdvancedSearch->SearchCondition = @$filter["v_TREATMENT_1"];
        $this->TREATMENT_1->AdvancedSearch->SearchValue2 = @$filter["y_TREATMENT_1"];
        $this->TREATMENT_1->AdvancedSearch->SearchOperator2 = @$filter["w_TREATMENT_1"];
        $this->TREATMENT_1->AdvancedSearch->save();

        // Field TREAT_DATE_1
        $this->TREAT_DATE_1->AdvancedSearch->SearchValue = @$filter["x_TREAT_DATE_1"];
        $this->TREAT_DATE_1->AdvancedSearch->SearchOperator = @$filter["z_TREAT_DATE_1"];
        $this->TREAT_DATE_1->AdvancedSearch->SearchCondition = @$filter["v_TREAT_DATE_1"];
        $this->TREAT_DATE_1->AdvancedSearch->SearchValue2 = @$filter["y_TREAT_DATE_1"];
        $this->TREAT_DATE_1->AdvancedSearch->SearchOperator2 = @$filter["w_TREAT_DATE_1"];
        $this->TREAT_DATE_1->AdvancedSearch->save();

        // Field QUANTITY_1
        $this->QUANTITY_1->AdvancedSearch->SearchValue = @$filter["x_QUANTITY_1"];
        $this->QUANTITY_1->AdvancedSearch->SearchOperator = @$filter["z_QUANTITY_1"];
        $this->QUANTITY_1->AdvancedSearch->SearchCondition = @$filter["v_QUANTITY_1"];
        $this->QUANTITY_1->AdvancedSearch->SearchValue2 = @$filter["y_QUANTITY_1"];
        $this->QUANTITY_1->AdvancedSearch->SearchOperator2 = @$filter["w_QUANTITY_1"];
        $this->QUANTITY_1->AdvancedSearch->save();

        // Field MEASURE_ID
        $this->MEASURE_ID->AdvancedSearch->SearchValue = @$filter["x_MEASURE_ID"];
        $this->MEASURE_ID->AdvancedSearch->SearchOperator = @$filter["z_MEASURE_ID"];
        $this->MEASURE_ID->AdvancedSearch->SearchCondition = @$filter["v_MEASURE_ID"];
        $this->MEASURE_ID->AdvancedSearch->SearchValue2 = @$filter["y_MEASURE_ID"];
        $this->MEASURE_ID->AdvancedSearch->SearchOperator2 = @$filter["w_MEASURE_ID"];
        $this->MEASURE_ID->AdvancedSearch->save();

        // Field MEASURE_ID_1
        $this->MEASURE_ID_1->AdvancedSearch->SearchValue = @$filter["x_MEASURE_ID_1"];
        $this->MEASURE_ID_1->AdvancedSearch->SearchOperator = @$filter["z_MEASURE_ID_1"];
        $this->MEASURE_ID_1->AdvancedSearch->SearchCondition = @$filter["v_MEASURE_ID_1"];
        $this->MEASURE_ID_1->AdvancedSearch->SearchValue2 = @$filter["y_MEASURE_ID_1"];
        $this->MEASURE_ID_1->AdvancedSearch->SearchOperator2 = @$filter["w_MEASURE_ID_1"];
        $this->MEASURE_ID_1->AdvancedSearch->save();

        // Field TRANS_ID_1
        $this->TRANS_ID_1->AdvancedSearch->SearchValue = @$filter["x_TRANS_ID_1"];
        $this->TRANS_ID_1->AdvancedSearch->SearchOperator = @$filter["z_TRANS_ID_1"];
        $this->TRANS_ID_1->AdvancedSearch->SearchCondition = @$filter["v_TRANS_ID_1"];
        $this->TRANS_ID_1->AdvancedSearch->SearchValue2 = @$filter["y_TRANS_ID_1"];
        $this->TRANS_ID_1->AdvancedSearch->SearchOperator2 = @$filter["w_TRANS_ID_1"];
        $this->TRANS_ID_1->AdvancedSearch->save();
        $this->BasicSearch->setKeyword(@$filter[Config("TABLE_BASIC_SEARCH")]);
        $this->BasicSearch->setType(@$filter[Config("TABLE_BASIC_SEARCH_TYPE")]);
    }

    // Advanced search WHERE clause based on QueryString
    protected function advancedSearchWhere($default = false)
    {
        global $Security;
        $where = "";
        if (!$Security->canSearch()) {
            return "";
        }
        $this->buildSearchSql($where, $this->BILL_ID, $default, false); // BILL_ID
        $this->buildSearchSql($where, $this->NO_REGISTRATION, $default, false); // NO_REGISTRATION
        $this->buildSearchSql($where, $this->VISIT_ID, $default, false); // VISIT_ID
        $this->buildSearchSql($where, $this->TARIF_ID, $default, false); // TARIF_ID
        $this->buildSearchSql($where, $this->CLASS_ID, $default, false); // CLASS_ID
        $this->buildSearchSql($where, $this->CLINIC_ID, $default, false); // CLINIC_ID
        $this->buildSearchSql($where, $this->CLINIC_ID_FROM, $default, false); // CLINIC_ID_FROM
        $this->buildSearchSql($where, $this->TREATMENT, $default, false); // TREATMENT
        $this->buildSearchSql($where, $this->TREAT_DATE, $default, false); // TREAT_DATE
        $this->buildSearchSql($where, $this->QUANTITY, $default, false); // QUANTITY
        $this->buildSearchSql($where, $this->KELUAR_ID, $default, false); // KELUAR_ID
        $this->buildSearchSql($where, $this->BED_ID, $default, false); // BED_ID
        $this->buildSearchSql($where, $this->EXIT_DATE, $default, false); // EXIT_DATE
        $this->buildSearchSql($where, $this->THENAME, $default, false); // THENAME
        $this->buildSearchSql($where, $this->THEADDRESS, $default, false); // THEADDRESS
        $this->buildSearchSql($where, $this->THEID, $default, false); // THEID
        $this->buildSearchSql($where, $this->TRANS_ID, $default, false); // TRANS_ID
        $this->buildSearchSql($where, $this->ID, $default, false); // ID
        $this->buildSearchSql($where, $this->AMOUNT, $default, false); // AMOUNT
        $this->buildSearchSql($where, $this->POKOK_JUAL, $default, false); // POKOK_JUAL
        $this->buildSearchSql($where, $this->PPN, $default, false); // PPN
        $this->buildSearchSql($where, $this->SUBSIDI, $default, false); // SUBSIDI
        $this->buildSearchSql($where, $this->PRINT_DATE, $default, false); // PRINT_DATE
        $this->buildSearchSql($where, $this->ISCETAK, $default, false); // ISCETAK
        $this->buildSearchSql($where, $this->NOTA_NO, $default, false); // NOTA_NO
        $this->buildSearchSql($where, $this->KUITANSI_ID, $default, false); // KUITANSI_ID
        $this->buildSearchSql($where, $this->amount_paid, $default, false); // amount_paid
        $this->buildSearchSql($where, $this->sell_price, $default, false); // sell_price
        $this->buildSearchSql($where, $this->diskon, $default, false); // diskon
        $this->buildSearchSql($where, $this->TAGIHAN, $default, false); // TAGIHAN
        $this->buildSearchSql($where, $this->CLINIC_TYPE, $default, false); // CLINIC_TYPE
        $this->buildSearchSql($where, $this->ID_1, $default, false); // ID_1
        $this->buildSearchSql($where, $this->ORG_UNIT_CODE, $default, false); // ORG_UNIT_CODE
        $this->buildSearchSql($where, $this->BILL_ID_1, $default, false); // BILL_ID_1
        $this->buildSearchSql($where, $this->NO_REGISTRATION_1, $default, false); // NO_REGISTRATION_1
        $this->buildSearchSql($where, $this->VISIT_ID_1, $default, false); // VISIT_ID_1
        $this->buildSearchSql($where, $this->TARIF_ID_1, $default, false); // TARIF_ID_1
        $this->buildSearchSql($where, $this->CLASS_ID_1, $default, false); // CLASS_ID_1
        $this->buildSearchSql($where, $this->CLINIC_ID_1, $default, false); // CLINIC_ID_1
        $this->buildSearchSql($where, $this->CLINIC_ID_FROM_1, $default, false); // CLINIC_ID_FROM_1
        $this->buildSearchSql($where, $this->TREATMENT_1, $default, false); // TREATMENT_1
        $this->buildSearchSql($where, $this->TREAT_DATE_1, $default, false); // TREAT_DATE_1
        $this->buildSearchSql($where, $this->QUANTITY_1, $default, false); // QUANTITY_1
        $this->buildSearchSql($where, $this->MEASURE_ID, $default, false); // MEASURE_ID
        $this->buildSearchSql($where, $this->MEASURE_ID_1, $default, false); // MEASURE_ID_1
        $this->buildSearchSql($where, $this->TRANS_ID_1, $default, false); // TRANS_ID_1

        // Set up search parm
        if (!$default && $where != "" && in_array($this->Command, ["", "reset", "resetall"])) {
            $this->Command = "search";
        }
        if (!$default && $this->Command == "search") {
            $this->BILL_ID->AdvancedSearch->save(); // BILL_ID
            $this->NO_REGISTRATION->AdvancedSearch->save(); // NO_REGISTRATION
            $this->VISIT_ID->AdvancedSearch->save(); // VISIT_ID
            $this->TARIF_ID->AdvancedSearch->save(); // TARIF_ID
            $this->CLASS_ID->AdvancedSearch->save(); // CLASS_ID
            $this->CLINIC_ID->AdvancedSearch->save(); // CLINIC_ID
            $this->CLINIC_ID_FROM->AdvancedSearch->save(); // CLINIC_ID_FROM
            $this->TREATMENT->AdvancedSearch->save(); // TREATMENT
            $this->TREAT_DATE->AdvancedSearch->save(); // TREAT_DATE
            $this->QUANTITY->AdvancedSearch->save(); // QUANTITY
            $this->KELUAR_ID->AdvancedSearch->save(); // KELUAR_ID
            $this->BED_ID->AdvancedSearch->save(); // BED_ID
            $this->EXIT_DATE->AdvancedSearch->save(); // EXIT_DATE
            $this->THENAME->AdvancedSearch->save(); // THENAME
            $this->THEADDRESS->AdvancedSearch->save(); // THEADDRESS
            $this->THEID->AdvancedSearch->save(); // THEID
            $this->TRANS_ID->AdvancedSearch->save(); // TRANS_ID
            $this->ID->AdvancedSearch->save(); // ID
            $this->AMOUNT->AdvancedSearch->save(); // AMOUNT
            $this->POKOK_JUAL->AdvancedSearch->save(); // POKOK_JUAL
            $this->PPN->AdvancedSearch->save(); // PPN
            $this->SUBSIDI->AdvancedSearch->save(); // SUBSIDI
            $this->PRINT_DATE->AdvancedSearch->save(); // PRINT_DATE
            $this->ISCETAK->AdvancedSearch->save(); // ISCETAK
            $this->NOTA_NO->AdvancedSearch->save(); // NOTA_NO
            $this->KUITANSI_ID->AdvancedSearch->save(); // KUITANSI_ID
            $this->amount_paid->AdvancedSearch->save(); // amount_paid
            $this->sell_price->AdvancedSearch->save(); // sell_price
            $this->diskon->AdvancedSearch->save(); // diskon
            $this->TAGIHAN->AdvancedSearch->save(); // TAGIHAN
            $this->CLINIC_TYPE->AdvancedSearch->save(); // CLINIC_TYPE
            $this->ID_1->AdvancedSearch->save(); // ID_1
            $this->ORG_UNIT_CODE->AdvancedSearch->save(); // ORG_UNIT_CODE
            $this->BILL_ID_1->AdvancedSearch->save(); // BILL_ID_1
            $this->NO_REGISTRATION_1->AdvancedSearch->save(); // NO_REGISTRATION_1
            $this->VISIT_ID_1->AdvancedSearch->save(); // VISIT_ID_1
            $this->TARIF_ID_1->AdvancedSearch->save(); // TARIF_ID_1
            $this->CLASS_ID_1->AdvancedSearch->save(); // CLASS_ID_1
            $this->CLINIC_ID_1->AdvancedSearch->save(); // CLINIC_ID_1
            $this->CLINIC_ID_FROM_1->AdvancedSearch->save(); // CLINIC_ID_FROM_1
            $this->TREATMENT_1->AdvancedSearch->save(); // TREATMENT_1
            $this->TREAT_DATE_1->AdvancedSearch->save(); // TREAT_DATE_1
            $this->QUANTITY_1->AdvancedSearch->save(); // QUANTITY_1
            $this->MEASURE_ID->AdvancedSearch->save(); // MEASURE_ID
            $this->MEASURE_ID_1->AdvancedSearch->save(); // MEASURE_ID_1
            $this->TRANS_ID_1->AdvancedSearch->save(); // TRANS_ID_1
        }
        return $where;
    }

    // Build search SQL
    protected function buildSearchSql(&$where, &$fld, $default, $multiValue)
    {
        $fldParm = $fld->Param;
        $fldVal = ($default) ? $fld->AdvancedSearch->SearchValueDefault : $fld->AdvancedSearch->SearchValue;
        $fldOpr = ($default) ? $fld->AdvancedSearch->SearchOperatorDefault : $fld->AdvancedSearch->SearchOperator;
        $fldCond = ($default) ? $fld->AdvancedSearch->SearchConditionDefault : $fld->AdvancedSearch->SearchCondition;
        $fldVal2 = ($default) ? $fld->AdvancedSearch->SearchValue2Default : $fld->AdvancedSearch->SearchValue2;
        $fldOpr2 = ($default) ? $fld->AdvancedSearch->SearchOperator2Default : $fld->AdvancedSearch->SearchOperator2;
        $wrk = "";
        if (is_array($fldVal)) {
            $fldVal = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $fldVal);
        }
        if (is_array($fldVal2)) {
            $fldVal2 = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $fldVal2);
        }
        $fldOpr = strtoupper(trim($fldOpr));
        if ($fldOpr == "") {
            $fldOpr = "=";
        }
        $fldOpr2 = strtoupper(trim($fldOpr2));
        if ($fldOpr2 == "") {
            $fldOpr2 = "=";
        }
        if (Config("SEARCH_MULTI_VALUE_OPTION") == 1 || !IsMultiSearchOperator($fldOpr)) {
            $multiValue = false;
        }
        if ($multiValue) {
            $wrk1 = ($fldVal != "") ? GetMultiSearchSql($fld, $fldOpr, $fldVal, $this->Dbid) : ""; // Field value 1
            $wrk2 = ($fldVal2 != "") ? GetMultiSearchSql($fld, $fldOpr2, $fldVal2, $this->Dbid) : ""; // Field value 2
            $wrk = $wrk1; // Build final SQL
            if ($wrk2 != "") {
                $wrk = ($wrk != "") ? "($wrk) $fldCond ($wrk2)" : $wrk2;
            }
        } else {
            $fldVal = $this->convertSearchValue($fld, $fldVal);
            $fldVal2 = $this->convertSearchValue($fld, $fldVal2);
            $wrk = GetSearchSql($fld, $fldVal, $fldOpr, $fldCond, $fldVal2, $fldOpr2, $this->Dbid);
        }
        AddFilter($where, $wrk);
    }

    // Convert search value
    protected function convertSearchValue(&$fld, $fldVal)
    {
        if ($fldVal == Config("NULL_VALUE") || $fldVal == Config("NOT_NULL_VALUE")) {
            return $fldVal;
        }
        $value = $fldVal;
        if ($fld->isBoolean()) {
            if ($fldVal != "") {
                $value = (SameText($fldVal, "1") || SameText($fldVal, "y") || SameText($fldVal, "t")) ? $fld->TrueValue : $fld->FalseValue;
            }
        } elseif ($fld->DataType == DATATYPE_DATE || $fld->DataType == DATATYPE_TIME) {
            if ($fldVal != "") {
                $value = UnFormatDateTime($fldVal, $fld->DateTimeFormat);
            }
        }
        return $value;
    }

    // Return basic search SQL
    protected function basicSearchSql($arKeywords, $type)
    {
        $where = "";
        $this->buildBasicSearchSql($where, $this->CLINIC_ID, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->TREATMENT, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->TRANS_ID, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->ISCETAK, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->NOTA_NO, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->KUITANSI_ID, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->ORG_UNIT_CODE, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->BILL_ID_1, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->NO_REGISTRATION_1, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->VISIT_ID_1, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->TARIF_ID_1, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->CLINIC_ID_1, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->CLINIC_ID_FROM_1, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->TREATMENT_1, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->TRANS_ID_1, $arKeywords, $type);
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
        if ($this->BILL_ID->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->NO_REGISTRATION->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->VISIT_ID->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->TARIF_ID->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->CLASS_ID->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->CLINIC_ID->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->CLINIC_ID_FROM->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->TREATMENT->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->TREAT_DATE->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->QUANTITY->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->KELUAR_ID->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->BED_ID->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->EXIT_DATE->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->THENAME->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->THEADDRESS->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->THEID->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->TRANS_ID->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->ID->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->AMOUNT->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->POKOK_JUAL->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->PPN->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->SUBSIDI->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->PRINT_DATE->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->ISCETAK->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->NOTA_NO->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->KUITANSI_ID->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->amount_paid->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->sell_price->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->diskon->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->TAGIHAN->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->CLINIC_TYPE->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->ID_1->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->ORG_UNIT_CODE->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->BILL_ID_1->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->NO_REGISTRATION_1->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->VISIT_ID_1->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->TARIF_ID_1->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->CLASS_ID_1->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->CLINIC_ID_1->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->CLINIC_ID_FROM_1->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->TREATMENT_1->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->TREAT_DATE_1->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->QUANTITY_1->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->MEASURE_ID->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->MEASURE_ID_1->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->TRANS_ID_1->AdvancedSearch->issetSession()) {
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

        // Clear advanced search parameters
        $this->resetAdvancedSearchParms();
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

    // Clear all advanced search parameters
    protected function resetAdvancedSearchParms()
    {
                $this->BILL_ID->AdvancedSearch->unsetSession();
                $this->NO_REGISTRATION->AdvancedSearch->unsetSession();
                $this->VISIT_ID->AdvancedSearch->unsetSession();
                $this->TARIF_ID->AdvancedSearch->unsetSession();
                $this->CLASS_ID->AdvancedSearch->unsetSession();
                $this->CLINIC_ID->AdvancedSearch->unsetSession();
                $this->CLINIC_ID_FROM->AdvancedSearch->unsetSession();
                $this->TREATMENT->AdvancedSearch->unsetSession();
                $this->TREAT_DATE->AdvancedSearch->unsetSession();
                $this->QUANTITY->AdvancedSearch->unsetSession();
                $this->KELUAR_ID->AdvancedSearch->unsetSession();
                $this->BED_ID->AdvancedSearch->unsetSession();
                $this->EXIT_DATE->AdvancedSearch->unsetSession();
                $this->THENAME->AdvancedSearch->unsetSession();
                $this->THEADDRESS->AdvancedSearch->unsetSession();
                $this->THEID->AdvancedSearch->unsetSession();
                $this->TRANS_ID->AdvancedSearch->unsetSession();
                $this->ID->AdvancedSearch->unsetSession();
                $this->AMOUNT->AdvancedSearch->unsetSession();
                $this->POKOK_JUAL->AdvancedSearch->unsetSession();
                $this->PPN->AdvancedSearch->unsetSession();
                $this->SUBSIDI->AdvancedSearch->unsetSession();
                $this->PRINT_DATE->AdvancedSearch->unsetSession();
                $this->ISCETAK->AdvancedSearch->unsetSession();
                $this->NOTA_NO->AdvancedSearch->unsetSession();
                $this->KUITANSI_ID->AdvancedSearch->unsetSession();
                $this->amount_paid->AdvancedSearch->unsetSession();
                $this->sell_price->AdvancedSearch->unsetSession();
                $this->diskon->AdvancedSearch->unsetSession();
                $this->TAGIHAN->AdvancedSearch->unsetSession();
                $this->CLINIC_TYPE->AdvancedSearch->unsetSession();
                $this->ID_1->AdvancedSearch->unsetSession();
                $this->ORG_UNIT_CODE->AdvancedSearch->unsetSession();
                $this->BILL_ID_1->AdvancedSearch->unsetSession();
                $this->NO_REGISTRATION_1->AdvancedSearch->unsetSession();
                $this->VISIT_ID_1->AdvancedSearch->unsetSession();
                $this->TARIF_ID_1->AdvancedSearch->unsetSession();
                $this->CLASS_ID_1->AdvancedSearch->unsetSession();
                $this->CLINIC_ID_1->AdvancedSearch->unsetSession();
                $this->CLINIC_ID_FROM_1->AdvancedSearch->unsetSession();
                $this->TREATMENT_1->AdvancedSearch->unsetSession();
                $this->TREAT_DATE_1->AdvancedSearch->unsetSession();
                $this->QUANTITY_1->AdvancedSearch->unsetSession();
                $this->MEASURE_ID->AdvancedSearch->unsetSession();
                $this->MEASURE_ID_1->AdvancedSearch->unsetSession();
                $this->TRANS_ID_1->AdvancedSearch->unsetSession();
    }

    // Restore all search parameters
    protected function restoreSearchParms()
    {
        $this->RestoreSearch = true;

        // Restore basic search values
        $this->BasicSearch->load();

        // Restore advanced search values
                $this->BILL_ID->AdvancedSearch->load();
                $this->NO_REGISTRATION->AdvancedSearch->load();
                $this->VISIT_ID->AdvancedSearch->load();
                $this->TARIF_ID->AdvancedSearch->load();
                $this->CLASS_ID->AdvancedSearch->load();
                $this->CLINIC_ID->AdvancedSearch->load();
                $this->CLINIC_ID_FROM->AdvancedSearch->load();
                $this->TREATMENT->AdvancedSearch->load();
                $this->TREAT_DATE->AdvancedSearch->load();
                $this->QUANTITY->AdvancedSearch->load();
                $this->KELUAR_ID->AdvancedSearch->load();
                $this->BED_ID->AdvancedSearch->load();
                $this->EXIT_DATE->AdvancedSearch->load();
                $this->THENAME->AdvancedSearch->load();
                $this->THEADDRESS->AdvancedSearch->load();
                $this->THEID->AdvancedSearch->load();
                $this->TRANS_ID->AdvancedSearch->load();
                $this->ID->AdvancedSearch->load();
                $this->AMOUNT->AdvancedSearch->load();
                $this->POKOK_JUAL->AdvancedSearch->load();
                $this->PPN->AdvancedSearch->load();
                $this->SUBSIDI->AdvancedSearch->load();
                $this->PRINT_DATE->AdvancedSearch->load();
                $this->ISCETAK->AdvancedSearch->load();
                $this->NOTA_NO->AdvancedSearch->load();
                $this->KUITANSI_ID->AdvancedSearch->load();
                $this->amount_paid->AdvancedSearch->load();
                $this->sell_price->AdvancedSearch->load();
                $this->diskon->AdvancedSearch->load();
                $this->TAGIHAN->AdvancedSearch->load();
                $this->CLINIC_TYPE->AdvancedSearch->load();
                $this->ID_1->AdvancedSearch->load();
                $this->ORG_UNIT_CODE->AdvancedSearch->load();
                $this->BILL_ID_1->AdvancedSearch->load();
                $this->NO_REGISTRATION_1->AdvancedSearch->load();
                $this->VISIT_ID_1->AdvancedSearch->load();
                $this->TARIF_ID_1->AdvancedSearch->load();
                $this->CLASS_ID_1->AdvancedSearch->load();
                $this->CLINIC_ID_1->AdvancedSearch->load();
                $this->CLINIC_ID_FROM_1->AdvancedSearch->load();
                $this->TREATMENT_1->AdvancedSearch->load();
                $this->TREAT_DATE_1->AdvancedSearch->load();
                $this->QUANTITY_1->AdvancedSearch->load();
                $this->MEASURE_ID->AdvancedSearch->load();
                $this->MEASURE_ID_1->AdvancedSearch->load();
                $this->TRANS_ID_1->AdvancedSearch->load();
    }

    // Set up sort parameters
    protected function setupSortOrder()
    {
        // Check for "order" parameter
        if (Get("order") !== null) {
            $this->CurrentOrder = Get("order");
            $this->CurrentOrderType = Get("ordertype", "");
            $this->updateSort($this->NO_REGISTRATION); // NO_REGISTRATION
            $this->updateSort($this->VISIT_ID); // VISIT_ID
            $this->updateSort($this->TARIF_ID); // TARIF_ID
            $this->updateSort($this->CLINIC_ID); // CLINIC_ID
            $this->updateSort($this->TREATMENT); // TREATMENT
            $this->updateSort($this->TREAT_DATE); // TREAT_DATE
            $this->updateSort($this->QUANTITY); // QUANTITY
            $this->updateSort($this->TRANS_ID); // TRANS_ID
            $this->updateSort($this->ID); // ID
            $this->updateSort($this->AMOUNT); // AMOUNT
            $this->updateSort($this->POKOK_JUAL); // POKOK_JUAL
            $this->updateSort($this->PPN); // PPN
            $this->updateSort($this->SUBSIDI); // SUBSIDI
            $this->updateSort($this->PRINT_DATE); // PRINT_DATE
            $this->updateSort($this->ISCETAK); // ISCETAK
            $this->updateSort($this->NOTA_NO); // NOTA_NO
            $this->updateSort($this->KUITANSI_ID); // KUITANSI_ID
            $this->updateSort($this->amount_paid); // amount_paid
            $this->updateSort($this->sell_price); // sell_price
            $this->updateSort($this->diskon); // diskon
            $this->updateSort($this->TAGIHAN); // TAGIHAN
            $this->updateSort($this->CLINIC_TYPE); // CLINIC_TYPE
            $this->updateSort($this->ID_1); // ID_1
            $this->updateSort($this->ORG_UNIT_CODE); // ORG_UNIT_CODE
            $this->updateSort($this->BILL_ID_1); // BILL_ID_1
            $this->updateSort($this->NO_REGISTRATION_1); // NO_REGISTRATION_1
            $this->updateSort($this->VISIT_ID_1); // VISIT_ID_1
            $this->updateSort($this->TARIF_ID_1); // TARIF_ID_1
            $this->updateSort($this->CLASS_ID_1); // CLASS_ID_1
            $this->updateSort($this->CLINIC_ID_1); // CLINIC_ID_1
            $this->updateSort($this->CLINIC_ID_FROM_1); // CLINIC_ID_FROM_1
            $this->updateSort($this->TREATMENT_1); // TREATMENT_1
            $this->updateSort($this->TREAT_DATE_1); // TREAT_DATE_1
            $this->updateSort($this->QUANTITY_1); // QUANTITY_1
            $this->updateSort($this->MEASURE_ID); // MEASURE_ID
            $this->updateSort($this->MEASURE_ID_1); // MEASURE_ID_1
            $this->updateSort($this->TRANS_ID_1); // TRANS_ID_1
            $this->setStartRecordNumber(1); // Reset start position
        }
    }

    // Load sort order parameters
    protected function loadSortOrder()
    {
        $orderBy = $this->getSessionOrderBy(); // Get ORDER BY from Session
        if ($orderBy == "") {
            $this->DefaultSort = "dbo.TREATMENT_BILL.TREAT_DATE DESC";
            if ($this->getSqlOrderBy() != "") {
                $useDefaultSort = true;
                if ($this->TREAT_DATE->getSort() != "") {
                    $useDefaultSort = false;
                }
                if ($useDefaultSort) {
                    $this->TREAT_DATE->setSort("DESC");
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

            // Reset master/detail keys
            if ($this->Command == "resetall") {
                $this->setCurrentMasterTable(""); // Clear master table
                $this->DbMasterFilter = "";
                $this->DbDetailFilter = "";
                        $this->VISIT_ID->setSessionValue("");
                        $this->NO_REGISTRATION->setSessionValue("");
                        $this->TRANS_ID->setSessionValue("");
                        $this->THENAME->setSessionValue("");
                        $this->THEADDRESS->setSessionValue("");
            }

            // Reset (clear) sorting order
            if ($this->Command == "resetsort") {
                $orderBy = "";
                $this->setSessionOrderBy($orderBy);
                $this->BILL_ID->setSort("");
                $this->NO_REGISTRATION->setSort("");
                $this->VISIT_ID->setSort("");
                $this->TARIF_ID->setSort("");
                $this->CLASS_ID->setSort("");
                $this->CLINIC_ID->setSort("");
                $this->CLINIC_ID_FROM->setSort("");
                $this->TREATMENT->setSort("");
                $this->TREAT_DATE->setSort("");
                $this->QUANTITY->setSort("");
                $this->KELUAR_ID->setSort("");
                $this->BED_ID->setSort("");
                $this->EXIT_DATE->setSort("");
                $this->THENAME->setSort("");
                $this->THEADDRESS->setSort("");
                $this->THEID->setSort("");
                $this->TRANS_ID->setSort("");
                $this->ID->setSort("");
                $this->AMOUNT->setSort("");
                $this->POKOK_JUAL->setSort("");
                $this->PPN->setSort("");
                $this->SUBSIDI->setSort("");
                $this->PRINT_DATE->setSort("");
                $this->ISCETAK->setSort("");
                $this->NOTA_NO->setSort("");
                $this->KUITANSI_ID->setSort("");
                $this->amount_paid->setSort("");
                $this->sell_price->setSort("");
                $this->diskon->setSort("");
                $this->TAGIHAN->setSort("");
                $this->CLINIC_TYPE->setSort("");
                $this->ID_1->setSort("");
                $this->ORG_UNIT_CODE->setSort("");
                $this->BILL_ID_1->setSort("");
                $this->NO_REGISTRATION_1->setSort("");
                $this->VISIT_ID_1->setSort("");
                $this->TARIF_ID_1->setSort("");
                $this->CLASS_ID_1->setSort("");
                $this->CLINIC_ID_1->setSort("");
                $this->CLINIC_ID_FROM_1->setSort("");
                $this->TREATMENT_1->setSort("");
                $this->TREAT_DATE_1->setSort("");
                $this->QUANTITY_1->setSort("");
                $this->MEASURE_ID->setSort("");
                $this->MEASURE_ID_1->setSort("");
                $this->TRANS_ID_1->setSort("");
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

        // "griddelete"
        if ($this->AllowAddDeleteRow) {
            $item = &$this->ListOptions->add("griddelete");
            $item->CssClass = "text-nowrap";
            $item->OnLeft = true;
            $item->Visible = false; // Default hidden
        }

        // Add group option item
        $item = &$this->ListOptions->add($this->ListOptions->GroupOptionName);
        $item->Body = "";
        $item->OnLeft = true;
        $item->Visible = false;

        // "edit"
        $item = &$this->ListOptions->add("edit");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->canEdit();
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

        // Set up row action and key
        if ($CurrentForm && is_numeric($this->RowIndex) && $this->RowType != "view") {
            $CurrentForm->Index = $this->RowIndex;
            $actionName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormActionName);
            $oldKeyName = str_replace("k_", "k" . $this->RowIndex . "_", $this->OldKeyName);
            $blankRowName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormBlankRowName);
            if ($this->RowAction != "") {
                $this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $actionName . "\" id=\"" . $actionName . "\" value=\"" . $this->RowAction . "\">";
            }
            $oldKey = $this->getKey(false); // Get from OldValue
            if ($oldKeyName != "" && $oldKey != "") {
                $this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $oldKeyName . "\" id=\"" . $oldKeyName . "\" value=\"" . HtmlEncode($oldKey) . "\">";
            }
            if ($this->RowAction == "insert" && $this->isConfirm() && $this->emptyRow()) {
                $this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $blankRowName . "\" id=\"" . $blankRowName . "\" value=\"1\">";
            }
        }

        // "delete"
        if ($this->AllowAddDeleteRow) {
            if ($this->isGridAdd() || $this->isGridEdit()) {
                $options = &$this->ListOptions;
                $options->UseButtonGroup = true; // Use button group for grid delete button
                $opt = $options["griddelete"];
                if (!$Security->canDelete() && is_numeric($this->RowIndex) && ($this->RowAction == "" || $this->RowAction == "edit")) { // Do not allow delete existing record
                    $opt->Body = "&nbsp;";
                } else {
                    $opt->Body = "<a class=\"ew-grid-link ew-grid-delete\" title=\"" . HtmlTitle($Language->phrase("DeleteLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("DeleteLink")) . "\" onclick=\"return ew.deleteGridRow(this, " . $this->RowIndex . ");\">" . $Language->phrase("DeleteLink") . "</a>";
                }
            }
        }
        $pageUrl = $this->pageUrl();
        if ($this->CurrentMode == "view") {
            // "edit"
            $opt = $this->ListOptions["edit"];
            $editcaption = HtmlTitle($Language->phrase("EditLink"));
            if ($Security->canEdit()) {
                $opt->Body = "<a class=\"ew-row-link ew-edit\" title=\"" . HtmlTitle($Language->phrase("EditLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("EditLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->EditUrl)) . "\">" . $Language->phrase("EditLink") . "</a>";
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
        $opt->Body = "<div class=\"custom-control custom-checkbox d-inline-block\"><input type=\"checkbox\" id=\"key_m_" . $this->RowCount . "\" name=\"key_m[]\" class=\"custom-control-input ew-multi-select\" value=\"" . HtmlEncode($this->ID->CurrentValue) . "\" onclick=\"ew.clickMultiCheckbox(event);\"><label class=\"custom-control-label\" for=\"key_m_" . $this->RowCount . "\"></label></div>";
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
        $item = &$option->add("gridadd");
        $item->Body = "<a class=\"ew-add-edit ew-grid-add\" title=\"" . HtmlTitle($Language->phrase("GridAddLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("GridAddLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->GridAddUrl)) . "\">" . $Language->phrase("GridAddLink") . "</a>";
        $item->Visible = $this->GridAddUrl != "" && $Security->canAdd();

        // Add grid edit
        $option = $options["addedit"];
        $item = &$option->add("gridedit");
        $item->Body = "<a class=\"ew-add-edit ew-grid-edit\" title=\"" . HtmlTitle($Language->phrase("GridEditLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("GridEditLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->GridEditUrl)) . "\">" . $Language->phrase("GridEditLink") . "</a>";
        $item->Visible = $this->GridEditUrl != "" && $Security->canEdit();
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
        $item->Body = "<a class=\"ew-save-filter\" data-form=\"fTREATMENT_INAPlistsrch\" href=\"#\" onclick=\"return false;\">" . $Language->phrase("SaveCurrentFilter") . "</a>";
        $item->Visible = true;
        $item = &$this->FilterOptions->add("deletefilter");
        $item->Body = "<a class=\"ew-delete-filter\" data-form=\"fTREATMENT_INAPlistsrch\" href=\"#\" onclick=\"return false;\">" . $Language->phrase("DeleteFilter") . "</a>";
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
        if (!$this->isGridAdd() && !$this->isGridEdit()) { // Not grid add/edit mode
            $option = $options["action"];
            // Set up list action buttons
            foreach ($this->ListActions->Items as $listaction) {
                if ($listaction->Select == ACTION_MULTIPLE) {
                    $item = &$option->add("custom_" . $listaction->Action);
                    $caption = $listaction->Caption;
                    $icon = ($listaction->Icon != "") ? '<i class="' . HtmlEncode($listaction->Icon) . '" data-caption="' . HtmlEncode($caption) . '"></i>' . $caption : $caption;
                    $item->Body = '<a class="ew-action ew-list-action" title="' . HtmlEncode($caption) . '" data-caption="' . HtmlEncode($caption) . '" href="#" onclick="return ew.submitAction(event,jQuery.extend({f:document.fTREATMENT_INAPlist},' . $listaction->toJson(true) . '));">' . $icon . '</a>';
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
        } else { // Grid add/edit mode
            // Hide all options first
            foreach ($options as $option) {
                $option->hideAllOptions();
            }
            $pageUrl = $this->pageUrl();

            // Grid-Add
            if ($this->isGridAdd()) {
                if ($this->AllowAddDeleteRow) {
                    // Add add blank row
                    $option = $options["addedit"];
                    $option->UseDropDownButton = false;
                    $item = &$option->add("addblankrow");
                    $item->Body = "<a class=\"ew-add-edit ew-add-blank-row\" title=\"" . HtmlTitle($Language->phrase("AddBlankRow")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("AddBlankRow")) . "\" href=\"#\" onclick=\"return ew.addGridRow(this);\">" . $Language->phrase("AddBlankRow") . "</a>";
                    $item->Visible = $Security->canAdd();
                }
                $option = $options["action"];
                $option->UseDropDownButton = false;
                // Add grid insert
                $item = &$option->add("gridinsert");
                $item->Body = "<a class=\"ew-action ew-grid-insert\" title=\"" . HtmlTitle($Language->phrase("GridInsertLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("GridInsertLink")) . "\" href=\"#\" onclick=\"ew.forms.get(this).submit(event, '" . $this->pageName() . "'); return false;\">" . $Language->phrase("GridInsertLink") . "</a>";
                // Add grid cancel
                $item = &$option->add("gridcancel");
                $cancelurl = $this->addMasterUrl($pageUrl . "action=cancel");
                $item->Body = "<a class=\"ew-action ew-grid-cancel\" title=\"" . HtmlTitle($Language->phrase("GridCancelLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("GridCancelLink")) . "\" href=\"" . $cancelurl . "\">" . $Language->phrase("GridCancelLink") . "</a>";
            }

            // Grid-Edit
            if ($this->isGridEdit()) {
                if ($this->AllowAddDeleteRow) {
                    // Add add blank row
                    $option = $options["addedit"];
                    $option->UseDropDownButton = false;
                    $item = &$option->add("addblankrow");
                    $item->Body = "<a class=\"ew-add-edit ew-add-blank-row\" title=\"" . HtmlTitle($Language->phrase("AddBlankRow")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("AddBlankRow")) . "\" href=\"#\" onclick=\"return ew.addGridRow(this);\">" . $Language->phrase("AddBlankRow") . "</a>";
                    $item->Visible = $Security->canAdd();
                }
                $option = $options["action"];
                $option->UseDropDownButton = false;
                    $item = &$option->add("gridsave");
                    $item->Body = "<a class=\"ew-action ew-grid-save\" title=\"" . HtmlTitle($Language->phrase("GridSaveLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("GridSaveLink")) . "\" href=\"#\" onclick=\"ew.forms.get(this).submit(event, '" . $this->pageName() . "'); return false;\">" . $Language->phrase("GridSaveLink") . "</a>";
                    $item = &$option->add("gridcancel");
                    $cancelurl = $this->addMasterUrl($pageUrl . "action=cancel");
                    $item->Body = "<a class=\"ew-action ew-grid-cancel\" title=\"" . HtmlTitle($Language->phrase("GridCancelLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("GridCancelLink")) . "\" href=\"" . $cancelurl . "\">" . $Language->phrase("GridCancelLink") . "</a>";
            }
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

    // Load default values
    protected function loadDefaultValues()
    {
        $this->BILL_ID->CurrentValue = null;
        $this->BILL_ID->OldValue = $this->BILL_ID->CurrentValue;
        $this->NO_REGISTRATION->CurrentValue = null;
        $this->NO_REGISTRATION->OldValue = $this->NO_REGISTRATION->CurrentValue;
        $this->VISIT_ID->CurrentValue = null;
        $this->VISIT_ID->OldValue = $this->VISIT_ID->CurrentValue;
        $this->TARIF_ID->CurrentValue = null;
        $this->TARIF_ID->OldValue = $this->TARIF_ID->CurrentValue;
        $this->CLASS_ID->CurrentValue = 0;
        $this->CLASS_ID->OldValue = $this->CLASS_ID->CurrentValue;
        $this->CLINIC_ID->CurrentValue = null;
        $this->CLINIC_ID->OldValue = $this->CLINIC_ID->CurrentValue;
        $this->CLINIC_ID_FROM->CurrentValue = null;
        $this->CLINIC_ID_FROM->OldValue = $this->CLINIC_ID_FROM->CurrentValue;
        $this->TREATMENT->CurrentValue = null;
        $this->TREATMENT->OldValue = $this->TREATMENT->CurrentValue;
        $this->TREAT_DATE->CurrentValue = CurrentDateTime();
        $this->TREAT_DATE->OldValue = $this->TREAT_DATE->CurrentValue;
        $this->QUANTITY->CurrentValue = 1;
        $this->QUANTITY->OldValue = $this->QUANTITY->CurrentValue;
        $this->KELUAR_ID->CurrentValue = null;
        $this->KELUAR_ID->OldValue = $this->KELUAR_ID->CurrentValue;
        $this->BED_ID->CurrentValue = null;
        $this->BED_ID->OldValue = $this->BED_ID->CurrentValue;
        $this->EXIT_DATE->CurrentValue = null;
        $this->EXIT_DATE->OldValue = $this->EXIT_DATE->CurrentValue;
        $this->THENAME->CurrentValue = null;
        $this->THENAME->OldValue = $this->THENAME->CurrentValue;
        $this->THEADDRESS->CurrentValue = null;
        $this->THEADDRESS->OldValue = $this->THEADDRESS->CurrentValue;
        $this->THEID->CurrentValue = null;
        $this->THEID->OldValue = $this->THEID->CurrentValue;
        $this->TRANS_ID->CurrentValue = null;
        $this->TRANS_ID->OldValue = $this->TRANS_ID->CurrentValue;
        $this->ID->CurrentValue = null;
        $this->ID->OldValue = $this->ID->CurrentValue;
        $this->AMOUNT->CurrentValue = null;
        $this->AMOUNT->OldValue = $this->AMOUNT->CurrentValue;
        $this->POKOK_JUAL->CurrentValue = null;
        $this->POKOK_JUAL->OldValue = $this->POKOK_JUAL->CurrentValue;
        $this->PPN->CurrentValue = null;
        $this->PPN->OldValue = $this->PPN->CurrentValue;
        $this->SUBSIDI->CurrentValue = null;
        $this->SUBSIDI->OldValue = $this->SUBSIDI->CurrentValue;
        $this->PRINT_DATE->CurrentValue = null;
        $this->PRINT_DATE->OldValue = $this->PRINT_DATE->CurrentValue;
        $this->ISCETAK->CurrentValue = null;
        $this->ISCETAK->OldValue = $this->ISCETAK->CurrentValue;
        $this->NOTA_NO->CurrentValue = null;
        $this->NOTA_NO->OldValue = $this->NOTA_NO->CurrentValue;
        $this->KUITANSI_ID->CurrentValue = null;
        $this->KUITANSI_ID->OldValue = $this->KUITANSI_ID->CurrentValue;
        $this->amount_paid->CurrentValue = null;
        $this->amount_paid->OldValue = $this->amount_paid->CurrentValue;
        $this->sell_price->CurrentValue = null;
        $this->sell_price->OldValue = $this->sell_price->CurrentValue;
        $this->diskon->CurrentValue = null;
        $this->diskon->OldValue = $this->diskon->CurrentValue;
        $this->TAGIHAN->CurrentValue = null;
        $this->TAGIHAN->OldValue = $this->TAGIHAN->CurrentValue;
        $this->CLINIC_TYPE->CurrentValue = null;
        $this->CLINIC_TYPE->OldValue = $this->CLINIC_TYPE->CurrentValue;
        $this->ID_1->CurrentValue = null;
        $this->ID_1->OldValue = $this->ID_1->CurrentValue;
        $this->ORG_UNIT_CODE->CurrentValue = null;
        $this->ORG_UNIT_CODE->OldValue = $this->ORG_UNIT_CODE->CurrentValue;
        $this->BILL_ID_1->CurrentValue = null;
        $this->BILL_ID_1->OldValue = $this->BILL_ID_1->CurrentValue;
        $this->NO_REGISTRATION_1->CurrentValue = null;
        $this->NO_REGISTRATION_1->OldValue = $this->NO_REGISTRATION_1->CurrentValue;
        $this->VISIT_ID_1->CurrentValue = null;
        $this->VISIT_ID_1->OldValue = $this->VISIT_ID_1->CurrentValue;
        $this->TARIF_ID_1->CurrentValue = null;
        $this->TARIF_ID_1->OldValue = $this->TARIF_ID_1->CurrentValue;
        $this->CLASS_ID_1->CurrentValue = null;
        $this->CLASS_ID_1->OldValue = $this->CLASS_ID_1->CurrentValue;
        $this->CLINIC_ID_1->CurrentValue = null;
        $this->CLINIC_ID_1->OldValue = $this->CLINIC_ID_1->CurrentValue;
        $this->CLINIC_ID_FROM_1->CurrentValue = null;
        $this->CLINIC_ID_FROM_1->OldValue = $this->CLINIC_ID_FROM_1->CurrentValue;
        $this->TREATMENT_1->CurrentValue = null;
        $this->TREATMENT_1->OldValue = $this->TREATMENT_1->CurrentValue;
        $this->TREAT_DATE_1->CurrentValue = null;
        $this->TREAT_DATE_1->OldValue = $this->TREAT_DATE_1->CurrentValue;
        $this->QUANTITY_1->CurrentValue = null;
        $this->QUANTITY_1->OldValue = $this->QUANTITY_1->CurrentValue;
        $this->MEASURE_ID->CurrentValue = null;
        $this->MEASURE_ID->OldValue = $this->MEASURE_ID->CurrentValue;
        $this->MEASURE_ID_1->CurrentValue = null;
        $this->MEASURE_ID_1->OldValue = $this->MEASURE_ID_1->CurrentValue;
        $this->TRANS_ID_1->CurrentValue = null;
        $this->TRANS_ID_1->OldValue = $this->TRANS_ID_1->CurrentValue;
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

    // Load search values for validation
    protected function loadSearchValues()
    {
        // Load search values
        $hasValue = false;

        // BILL_ID
        if (!$this->isAddOrEdit() && $this->BILL_ID->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->BILL_ID->AdvancedSearch->SearchValue != "" || $this->BILL_ID->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // NO_REGISTRATION
        if (!$this->isAddOrEdit() && $this->NO_REGISTRATION->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->NO_REGISTRATION->AdvancedSearch->SearchValue != "" || $this->NO_REGISTRATION->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // VISIT_ID
        if (!$this->isAddOrEdit() && $this->VISIT_ID->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->VISIT_ID->AdvancedSearch->SearchValue != "" || $this->VISIT_ID->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // TARIF_ID
        if (!$this->isAddOrEdit() && $this->TARIF_ID->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->TARIF_ID->AdvancedSearch->SearchValue != "" || $this->TARIF_ID->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // CLASS_ID
        if (!$this->isAddOrEdit() && $this->CLASS_ID->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->CLASS_ID->AdvancedSearch->SearchValue != "" || $this->CLASS_ID->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // CLINIC_ID
        if (!$this->isAddOrEdit() && $this->CLINIC_ID->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->CLINIC_ID->AdvancedSearch->SearchValue != "" || $this->CLINIC_ID->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // CLINIC_ID_FROM
        if (!$this->isAddOrEdit() && $this->CLINIC_ID_FROM->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->CLINIC_ID_FROM->AdvancedSearch->SearchValue != "" || $this->CLINIC_ID_FROM->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // TREATMENT
        if (!$this->isAddOrEdit() && $this->TREATMENT->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->TREATMENT->AdvancedSearch->SearchValue != "" || $this->TREATMENT->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // TREAT_DATE
        if (!$this->isAddOrEdit() && $this->TREAT_DATE->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->TREAT_DATE->AdvancedSearch->SearchValue != "" || $this->TREAT_DATE->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // QUANTITY
        if (!$this->isAddOrEdit() && $this->QUANTITY->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->QUANTITY->AdvancedSearch->SearchValue != "" || $this->QUANTITY->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // KELUAR_ID
        if (!$this->isAddOrEdit() && $this->KELUAR_ID->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->KELUAR_ID->AdvancedSearch->SearchValue != "" || $this->KELUAR_ID->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // BED_ID
        if (!$this->isAddOrEdit() && $this->BED_ID->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->BED_ID->AdvancedSearch->SearchValue != "" || $this->BED_ID->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // EXIT_DATE
        if (!$this->isAddOrEdit() && $this->EXIT_DATE->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->EXIT_DATE->AdvancedSearch->SearchValue != "" || $this->EXIT_DATE->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // THENAME
        if (!$this->isAddOrEdit() && $this->THENAME->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->THENAME->AdvancedSearch->SearchValue != "" || $this->THENAME->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // THEADDRESS
        if (!$this->isAddOrEdit() && $this->THEADDRESS->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->THEADDRESS->AdvancedSearch->SearchValue != "" || $this->THEADDRESS->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // THEID
        if (!$this->isAddOrEdit() && $this->THEID->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->THEID->AdvancedSearch->SearchValue != "" || $this->THEID->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // TRANS_ID
        if (!$this->isAddOrEdit() && $this->TRANS_ID->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->TRANS_ID->AdvancedSearch->SearchValue != "" || $this->TRANS_ID->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // ID
        if (!$this->isAddOrEdit() && $this->ID->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->ID->AdvancedSearch->SearchValue != "" || $this->ID->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // AMOUNT
        if (!$this->isAddOrEdit() && $this->AMOUNT->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->AMOUNT->AdvancedSearch->SearchValue != "" || $this->AMOUNT->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // POKOK_JUAL
        if (!$this->isAddOrEdit() && $this->POKOK_JUAL->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->POKOK_JUAL->AdvancedSearch->SearchValue != "" || $this->POKOK_JUAL->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // PPN
        if (!$this->isAddOrEdit() && $this->PPN->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->PPN->AdvancedSearch->SearchValue != "" || $this->PPN->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // SUBSIDI
        if (!$this->isAddOrEdit() && $this->SUBSIDI->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->SUBSIDI->AdvancedSearch->SearchValue != "" || $this->SUBSIDI->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // PRINT_DATE
        if (!$this->isAddOrEdit() && $this->PRINT_DATE->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->PRINT_DATE->AdvancedSearch->SearchValue != "" || $this->PRINT_DATE->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // ISCETAK
        if (!$this->isAddOrEdit() && $this->ISCETAK->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->ISCETAK->AdvancedSearch->SearchValue != "" || $this->ISCETAK->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // NOTA_NO
        if (!$this->isAddOrEdit() && $this->NOTA_NO->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->NOTA_NO->AdvancedSearch->SearchValue != "" || $this->NOTA_NO->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // KUITANSI_ID
        if (!$this->isAddOrEdit() && $this->KUITANSI_ID->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->KUITANSI_ID->AdvancedSearch->SearchValue != "" || $this->KUITANSI_ID->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // amount_paid
        if (!$this->isAddOrEdit() && $this->amount_paid->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->amount_paid->AdvancedSearch->SearchValue != "" || $this->amount_paid->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // sell_price
        if (!$this->isAddOrEdit() && $this->sell_price->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->sell_price->AdvancedSearch->SearchValue != "" || $this->sell_price->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // diskon
        if (!$this->isAddOrEdit() && $this->diskon->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->diskon->AdvancedSearch->SearchValue != "" || $this->diskon->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // TAGIHAN
        if (!$this->isAddOrEdit() && $this->TAGIHAN->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->TAGIHAN->AdvancedSearch->SearchValue != "" || $this->TAGIHAN->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // CLINIC_TYPE
        if (!$this->isAddOrEdit() && $this->CLINIC_TYPE->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->CLINIC_TYPE->AdvancedSearch->SearchValue != "" || $this->CLINIC_TYPE->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // ID_1
        if (!$this->isAddOrEdit() && $this->ID_1->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->ID_1->AdvancedSearch->SearchValue != "" || $this->ID_1->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // ORG_UNIT_CODE
        if (!$this->isAddOrEdit() && $this->ORG_UNIT_CODE->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->ORG_UNIT_CODE->AdvancedSearch->SearchValue != "" || $this->ORG_UNIT_CODE->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // BILL_ID_1
        if (!$this->isAddOrEdit() && $this->BILL_ID_1->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->BILL_ID_1->AdvancedSearch->SearchValue != "" || $this->BILL_ID_1->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // NO_REGISTRATION_1
        if (!$this->isAddOrEdit() && $this->NO_REGISTRATION_1->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->NO_REGISTRATION_1->AdvancedSearch->SearchValue != "" || $this->NO_REGISTRATION_1->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // VISIT_ID_1
        if (!$this->isAddOrEdit() && $this->VISIT_ID_1->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->VISIT_ID_1->AdvancedSearch->SearchValue != "" || $this->VISIT_ID_1->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // TARIF_ID_1
        if (!$this->isAddOrEdit() && $this->TARIF_ID_1->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->TARIF_ID_1->AdvancedSearch->SearchValue != "" || $this->TARIF_ID_1->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // CLASS_ID_1
        if (!$this->isAddOrEdit() && $this->CLASS_ID_1->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->CLASS_ID_1->AdvancedSearch->SearchValue != "" || $this->CLASS_ID_1->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // CLINIC_ID_1
        if (!$this->isAddOrEdit() && $this->CLINIC_ID_1->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->CLINIC_ID_1->AdvancedSearch->SearchValue != "" || $this->CLINIC_ID_1->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // CLINIC_ID_FROM_1
        if (!$this->isAddOrEdit() && $this->CLINIC_ID_FROM_1->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->CLINIC_ID_FROM_1->AdvancedSearch->SearchValue != "" || $this->CLINIC_ID_FROM_1->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // TREATMENT_1
        if (!$this->isAddOrEdit() && $this->TREATMENT_1->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->TREATMENT_1->AdvancedSearch->SearchValue != "" || $this->TREATMENT_1->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // TREAT_DATE_1
        if (!$this->isAddOrEdit() && $this->TREAT_DATE_1->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->TREAT_DATE_1->AdvancedSearch->SearchValue != "" || $this->TREAT_DATE_1->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // QUANTITY_1
        if (!$this->isAddOrEdit() && $this->QUANTITY_1->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->QUANTITY_1->AdvancedSearch->SearchValue != "" || $this->QUANTITY_1->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // MEASURE_ID
        if (!$this->isAddOrEdit() && $this->MEASURE_ID->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->MEASURE_ID->AdvancedSearch->SearchValue != "" || $this->MEASURE_ID->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // MEASURE_ID_1
        if (!$this->isAddOrEdit() && $this->MEASURE_ID_1->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->MEASURE_ID_1->AdvancedSearch->SearchValue != "" || $this->MEASURE_ID_1->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // TRANS_ID_1
        if (!$this->isAddOrEdit() && $this->TRANS_ID_1->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->TRANS_ID_1->AdvancedSearch->SearchValue != "" || $this->TRANS_ID_1->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }
        return $hasValue;
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
        if ($CurrentForm->hasValue("o_NO_REGISTRATION")) {
            $this->NO_REGISTRATION->setOldValue($CurrentForm->getValue("o_NO_REGISTRATION"));
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
        if ($CurrentForm->hasValue("o_VISIT_ID")) {
            $this->VISIT_ID->setOldValue($CurrentForm->getValue("o_VISIT_ID"));
        }

        // Check field name 'TARIF_ID' first before field var 'x_TARIF_ID'
        $val = $CurrentForm->hasValue("TARIF_ID") ? $CurrentForm->getValue("TARIF_ID") : $CurrentForm->getValue("x_TARIF_ID");
        if (!$this->TARIF_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->TARIF_ID->Visible = false; // Disable update for API request
            } else {
                $this->TARIF_ID->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_TARIF_ID")) {
            $this->TARIF_ID->setOldValue($CurrentForm->getValue("o_TARIF_ID"));
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
        if ($CurrentForm->hasValue("o_CLINIC_ID")) {
            $this->CLINIC_ID->setOldValue($CurrentForm->getValue("o_CLINIC_ID"));
        }

        // Check field name 'TREATMENT' first before field var 'x_TREATMENT'
        $val = $CurrentForm->hasValue("TREATMENT") ? $CurrentForm->getValue("TREATMENT") : $CurrentForm->getValue("x_TREATMENT");
        if (!$this->TREATMENT->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->TREATMENT->Visible = false; // Disable update for API request
            } else {
                $this->TREATMENT->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_TREATMENT")) {
            $this->TREATMENT->setOldValue($CurrentForm->getValue("o_TREATMENT"));
        }

        // Check field name 'TREAT_DATE' first before field var 'x_TREAT_DATE'
        $val = $CurrentForm->hasValue("TREAT_DATE") ? $CurrentForm->getValue("TREAT_DATE") : $CurrentForm->getValue("x_TREAT_DATE");
        if (!$this->TREAT_DATE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->TREAT_DATE->Visible = false; // Disable update for API request
            } else {
                $this->TREAT_DATE->setFormValue($val);
            }
            $this->TREAT_DATE->CurrentValue = UnFormatDateTime($this->TREAT_DATE->CurrentValue, 11);
        }
        if ($CurrentForm->hasValue("o_TREAT_DATE")) {
            $this->TREAT_DATE->setOldValue($CurrentForm->getValue("o_TREAT_DATE"));
        }

        // Check field name 'QUANTITY' first before field var 'x_QUANTITY'
        $val = $CurrentForm->hasValue("QUANTITY") ? $CurrentForm->getValue("QUANTITY") : $CurrentForm->getValue("x_QUANTITY");
        if (!$this->QUANTITY->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->QUANTITY->Visible = false; // Disable update for API request
            } else {
                $this->QUANTITY->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_QUANTITY")) {
            $this->QUANTITY->setOldValue($CurrentForm->getValue("o_QUANTITY"));
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
        if ($CurrentForm->hasValue("o_TRANS_ID")) {
            $this->TRANS_ID->setOldValue($CurrentForm->getValue("o_TRANS_ID"));
        }

        // Check field name 'ID' first before field var 'x_ID'
        $val = $CurrentForm->hasValue("ID") ? $CurrentForm->getValue("ID") : $CurrentForm->getValue("x_ID");
        if (!$this->ID->IsDetailKey && !$this->isGridAdd() && !$this->isAdd()) {
            $this->ID->setFormValue($val);
        }

        // Check field name 'AMOUNT' first before field var 'x_AMOUNT'
        $val = $CurrentForm->hasValue("AMOUNT") ? $CurrentForm->getValue("AMOUNT") : $CurrentForm->getValue("x_AMOUNT");
        if (!$this->AMOUNT->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->AMOUNT->Visible = false; // Disable update for API request
            } else {
                $this->AMOUNT->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_AMOUNT")) {
            $this->AMOUNT->setOldValue($CurrentForm->getValue("o_AMOUNT"));
        }

        // Check field name 'POKOK_JUAL' first before field var 'x_POKOK_JUAL'
        $val = $CurrentForm->hasValue("POKOK_JUAL") ? $CurrentForm->getValue("POKOK_JUAL") : $CurrentForm->getValue("x_POKOK_JUAL");
        if (!$this->POKOK_JUAL->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->POKOK_JUAL->Visible = false; // Disable update for API request
            } else {
                $this->POKOK_JUAL->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_POKOK_JUAL")) {
            $this->POKOK_JUAL->setOldValue($CurrentForm->getValue("o_POKOK_JUAL"));
        }

        // Check field name 'PPN' first before field var 'x_PPN'
        $val = $CurrentForm->hasValue("PPN") ? $CurrentForm->getValue("PPN") : $CurrentForm->getValue("x_PPN");
        if (!$this->PPN->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->PPN->Visible = false; // Disable update for API request
            } else {
                $this->PPN->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_PPN")) {
            $this->PPN->setOldValue($CurrentForm->getValue("o_PPN"));
        }

        // Check field name 'SUBSIDI' first before field var 'x_SUBSIDI'
        $val = $CurrentForm->hasValue("SUBSIDI") ? $CurrentForm->getValue("SUBSIDI") : $CurrentForm->getValue("x_SUBSIDI");
        if (!$this->SUBSIDI->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->SUBSIDI->Visible = false; // Disable update for API request
            } else {
                $this->SUBSIDI->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_SUBSIDI")) {
            $this->SUBSIDI->setOldValue($CurrentForm->getValue("o_SUBSIDI"));
        }

        // Check field name 'PRINT_DATE' first before field var 'x_PRINT_DATE'
        $val = $CurrentForm->hasValue("PRINT_DATE") ? $CurrentForm->getValue("PRINT_DATE") : $CurrentForm->getValue("x_PRINT_DATE");
        if (!$this->PRINT_DATE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->PRINT_DATE->Visible = false; // Disable update for API request
            } else {
                $this->PRINT_DATE->setFormValue($val);
            }
            $this->PRINT_DATE->CurrentValue = UnFormatDateTime($this->PRINT_DATE->CurrentValue, 0);
        }
        if ($CurrentForm->hasValue("o_PRINT_DATE")) {
            $this->PRINT_DATE->setOldValue($CurrentForm->getValue("o_PRINT_DATE"));
        }

        // Check field name 'ISCETAK' first before field var 'x_ISCETAK'
        $val = $CurrentForm->hasValue("ISCETAK") ? $CurrentForm->getValue("ISCETAK") : $CurrentForm->getValue("x_ISCETAK");
        if (!$this->ISCETAK->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ISCETAK->Visible = false; // Disable update for API request
            } else {
                $this->ISCETAK->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_ISCETAK")) {
            $this->ISCETAK->setOldValue($CurrentForm->getValue("o_ISCETAK"));
        }

        // Check field name 'NOTA_NO' first before field var 'x_NOTA_NO'
        $val = $CurrentForm->hasValue("NOTA_NO") ? $CurrentForm->getValue("NOTA_NO") : $CurrentForm->getValue("x_NOTA_NO");
        if (!$this->NOTA_NO->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->NOTA_NO->Visible = false; // Disable update for API request
            } else {
                $this->NOTA_NO->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_NOTA_NO")) {
            $this->NOTA_NO->setOldValue($CurrentForm->getValue("o_NOTA_NO"));
        }

        // Check field name 'KUITANSI_ID' first before field var 'x_KUITANSI_ID'
        $val = $CurrentForm->hasValue("KUITANSI_ID") ? $CurrentForm->getValue("KUITANSI_ID") : $CurrentForm->getValue("x_KUITANSI_ID");
        if (!$this->KUITANSI_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->KUITANSI_ID->Visible = false; // Disable update for API request
            } else {
                $this->KUITANSI_ID->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_KUITANSI_ID")) {
            $this->KUITANSI_ID->setOldValue($CurrentForm->getValue("o_KUITANSI_ID"));
        }

        // Check field name 'amount_paid' first before field var 'x_amount_paid'
        $val = $CurrentForm->hasValue("amount_paid") ? $CurrentForm->getValue("amount_paid") : $CurrentForm->getValue("x_amount_paid");
        if (!$this->amount_paid->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->amount_paid->Visible = false; // Disable update for API request
            } else {
                $this->amount_paid->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_amount_paid")) {
            $this->amount_paid->setOldValue($CurrentForm->getValue("o_amount_paid"));
        }

        // Check field name 'sell_price' first before field var 'x_sell_price'
        $val = $CurrentForm->hasValue("sell_price") ? $CurrentForm->getValue("sell_price") : $CurrentForm->getValue("x_sell_price");
        if (!$this->sell_price->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->sell_price->Visible = false; // Disable update for API request
            } else {
                $this->sell_price->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_sell_price")) {
            $this->sell_price->setOldValue($CurrentForm->getValue("o_sell_price"));
        }

        // Check field name 'diskon' first before field var 'x_diskon'
        $val = $CurrentForm->hasValue("diskon") ? $CurrentForm->getValue("diskon") : $CurrentForm->getValue("x_diskon");
        if (!$this->diskon->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->diskon->Visible = false; // Disable update for API request
            } else {
                $this->diskon->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_diskon")) {
            $this->diskon->setOldValue($CurrentForm->getValue("o_diskon"));
        }

        // Check field name 'TAGIHAN' first before field var 'x_TAGIHAN'
        $val = $CurrentForm->hasValue("TAGIHAN") ? $CurrentForm->getValue("TAGIHAN") : $CurrentForm->getValue("x_TAGIHAN");
        if (!$this->TAGIHAN->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->TAGIHAN->Visible = false; // Disable update for API request
            } else {
                $this->TAGIHAN->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_TAGIHAN")) {
            $this->TAGIHAN->setOldValue($CurrentForm->getValue("o_TAGIHAN"));
        }

        // Check field name 'CLINIC_TYPE' first before field var 'x_CLINIC_TYPE'
        $val = $CurrentForm->hasValue("CLINIC_TYPE") ? $CurrentForm->getValue("CLINIC_TYPE") : $CurrentForm->getValue("x_CLINIC_TYPE");
        if (!$this->CLINIC_TYPE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->CLINIC_TYPE->Visible = false; // Disable update for API request
            } else {
                $this->CLINIC_TYPE->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_CLINIC_TYPE")) {
            $this->CLINIC_TYPE->setOldValue($CurrentForm->getValue("o_CLINIC_TYPE"));
        }

        // Check field name 'ID_1' first before field var 'x_ID_1'
        $val = $CurrentForm->hasValue("ID_1") ? $CurrentForm->getValue("ID_1") : $CurrentForm->getValue("x_ID_1");
        if (!$this->ID_1->IsDetailKey && !$this->isGridAdd() && !$this->isAdd()) {
            $this->ID_1->setFormValue($val);
        }

        // Check field name 'ORG_UNIT_CODE' first before field var 'x_ORG_UNIT_CODE'
        $val = $CurrentForm->hasValue("ORG_UNIT_CODE") ? $CurrentForm->getValue("ORG_UNIT_CODE") : $CurrentForm->getValue("x_ORG_UNIT_CODE");
        if (!$this->ORG_UNIT_CODE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ORG_UNIT_CODE->Visible = false; // Disable update for API request
            } else {
                $this->ORG_UNIT_CODE->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_ORG_UNIT_CODE")) {
            $this->ORG_UNIT_CODE->setOldValue($CurrentForm->getValue("o_ORG_UNIT_CODE"));
        }

        // Check field name 'BILL_ID_1' first before field var 'x_BILL_ID_1'
        $val = $CurrentForm->hasValue("BILL_ID_1") ? $CurrentForm->getValue("BILL_ID_1") : $CurrentForm->getValue("x_BILL_ID_1");
        if (!$this->BILL_ID_1->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->BILL_ID_1->Visible = false; // Disable update for API request
            } else {
                $this->BILL_ID_1->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_BILL_ID_1")) {
            $this->BILL_ID_1->setOldValue($CurrentForm->getValue("o_BILL_ID_1"));
        }

        // Check field name 'NO_REGISTRATION_1' first before field var 'x_NO_REGISTRATION_1'
        $val = $CurrentForm->hasValue("NO_REGISTRATION_1") ? $CurrentForm->getValue("NO_REGISTRATION_1") : $CurrentForm->getValue("x_NO_REGISTRATION_1");
        if (!$this->NO_REGISTRATION_1->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->NO_REGISTRATION_1->Visible = false; // Disable update for API request
            } else {
                $this->NO_REGISTRATION_1->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_NO_REGISTRATION_1")) {
            $this->NO_REGISTRATION_1->setOldValue($CurrentForm->getValue("o_NO_REGISTRATION_1"));
        }

        // Check field name 'VISIT_ID_1' first before field var 'x_VISIT_ID_1'
        $val = $CurrentForm->hasValue("VISIT_ID_1") ? $CurrentForm->getValue("VISIT_ID_1") : $CurrentForm->getValue("x_VISIT_ID_1");
        if (!$this->VISIT_ID_1->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->VISIT_ID_1->Visible = false; // Disable update for API request
            } else {
                $this->VISIT_ID_1->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_VISIT_ID_1")) {
            $this->VISIT_ID_1->setOldValue($CurrentForm->getValue("o_VISIT_ID_1"));
        }

        // Check field name 'TARIF_ID_1' first before field var 'x_TARIF_ID_1'
        $val = $CurrentForm->hasValue("TARIF_ID_1") ? $CurrentForm->getValue("TARIF_ID_1") : $CurrentForm->getValue("x_TARIF_ID_1");
        if (!$this->TARIF_ID_1->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->TARIF_ID_1->Visible = false; // Disable update for API request
            } else {
                $this->TARIF_ID_1->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_TARIF_ID_1")) {
            $this->TARIF_ID_1->setOldValue($CurrentForm->getValue("o_TARIF_ID_1"));
        }

        // Check field name 'CLASS_ID_1' first before field var 'x_CLASS_ID_1'
        $val = $CurrentForm->hasValue("CLASS_ID_1") ? $CurrentForm->getValue("CLASS_ID_1") : $CurrentForm->getValue("x_CLASS_ID_1");
        if (!$this->CLASS_ID_1->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->CLASS_ID_1->Visible = false; // Disable update for API request
            } else {
                $this->CLASS_ID_1->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_CLASS_ID_1")) {
            $this->CLASS_ID_1->setOldValue($CurrentForm->getValue("o_CLASS_ID_1"));
        }

        // Check field name 'CLINIC_ID_1' first before field var 'x_CLINIC_ID_1'
        $val = $CurrentForm->hasValue("CLINIC_ID_1") ? $CurrentForm->getValue("CLINIC_ID_1") : $CurrentForm->getValue("x_CLINIC_ID_1");
        if (!$this->CLINIC_ID_1->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->CLINIC_ID_1->Visible = false; // Disable update for API request
            } else {
                $this->CLINIC_ID_1->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_CLINIC_ID_1")) {
            $this->CLINIC_ID_1->setOldValue($CurrentForm->getValue("o_CLINIC_ID_1"));
        }

        // Check field name 'CLINIC_ID_FROM_1' first before field var 'x_CLINIC_ID_FROM_1'
        $val = $CurrentForm->hasValue("CLINIC_ID_FROM_1") ? $CurrentForm->getValue("CLINIC_ID_FROM_1") : $CurrentForm->getValue("x_CLINIC_ID_FROM_1");
        if (!$this->CLINIC_ID_FROM_1->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->CLINIC_ID_FROM_1->Visible = false; // Disable update for API request
            } else {
                $this->CLINIC_ID_FROM_1->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_CLINIC_ID_FROM_1")) {
            $this->CLINIC_ID_FROM_1->setOldValue($CurrentForm->getValue("o_CLINIC_ID_FROM_1"));
        }

        // Check field name 'TREATMENT_1' first before field var 'x_TREATMENT_1'
        $val = $CurrentForm->hasValue("TREATMENT_1") ? $CurrentForm->getValue("TREATMENT_1") : $CurrentForm->getValue("x_TREATMENT_1");
        if (!$this->TREATMENT_1->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->TREATMENT_1->Visible = false; // Disable update for API request
            } else {
                $this->TREATMENT_1->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_TREATMENT_1")) {
            $this->TREATMENT_1->setOldValue($CurrentForm->getValue("o_TREATMENT_1"));
        }

        // Check field name 'TREAT_DATE_1' first before field var 'x_TREAT_DATE_1'
        $val = $CurrentForm->hasValue("TREAT_DATE_1") ? $CurrentForm->getValue("TREAT_DATE_1") : $CurrentForm->getValue("x_TREAT_DATE_1");
        if (!$this->TREAT_DATE_1->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->TREAT_DATE_1->Visible = false; // Disable update for API request
            } else {
                $this->TREAT_DATE_1->setFormValue($val);
            }
            $this->TREAT_DATE_1->CurrentValue = UnFormatDateTime($this->TREAT_DATE_1->CurrentValue, 0);
        }
        if ($CurrentForm->hasValue("o_TREAT_DATE_1")) {
            $this->TREAT_DATE_1->setOldValue($CurrentForm->getValue("o_TREAT_DATE_1"));
        }

        // Check field name 'QUANTITY_1' first before field var 'x_QUANTITY_1'
        $val = $CurrentForm->hasValue("QUANTITY_1") ? $CurrentForm->getValue("QUANTITY_1") : $CurrentForm->getValue("x_QUANTITY_1");
        if (!$this->QUANTITY_1->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->QUANTITY_1->Visible = false; // Disable update for API request
            } else {
                $this->QUANTITY_1->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_QUANTITY_1")) {
            $this->QUANTITY_1->setOldValue($CurrentForm->getValue("o_QUANTITY_1"));
        }

        // Check field name 'MEASURE_ID' first before field var 'x_MEASURE_ID'
        $val = $CurrentForm->hasValue("MEASURE_ID") ? $CurrentForm->getValue("MEASURE_ID") : $CurrentForm->getValue("x_MEASURE_ID");
        if (!$this->MEASURE_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->MEASURE_ID->Visible = false; // Disable update for API request
            } else {
                $this->MEASURE_ID->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_MEASURE_ID")) {
            $this->MEASURE_ID->setOldValue($CurrentForm->getValue("o_MEASURE_ID"));
        }

        // Check field name 'MEASURE_ID_1' first before field var 'x_MEASURE_ID_1'
        $val = $CurrentForm->hasValue("MEASURE_ID_1") ? $CurrentForm->getValue("MEASURE_ID_1") : $CurrentForm->getValue("x_MEASURE_ID_1");
        if (!$this->MEASURE_ID_1->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->MEASURE_ID_1->Visible = false; // Disable update for API request
            } else {
                $this->MEASURE_ID_1->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_MEASURE_ID_1")) {
            $this->MEASURE_ID_1->setOldValue($CurrentForm->getValue("o_MEASURE_ID_1"));
        }

        // Check field name 'TRANS_ID_1' first before field var 'x_TRANS_ID_1'
        $val = $CurrentForm->hasValue("TRANS_ID_1") ? $CurrentForm->getValue("TRANS_ID_1") : $CurrentForm->getValue("x_TRANS_ID_1");
        if (!$this->TRANS_ID_1->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->TRANS_ID_1->Visible = false; // Disable update for API request
            } else {
                $this->TRANS_ID_1->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_TRANS_ID_1")) {
            $this->TRANS_ID_1->setOldValue($CurrentForm->getValue("o_TRANS_ID_1"));
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->NO_REGISTRATION->CurrentValue = $this->NO_REGISTRATION->FormValue;
        $this->VISIT_ID->CurrentValue = $this->VISIT_ID->FormValue;
        $this->TARIF_ID->CurrentValue = $this->TARIF_ID->FormValue;
        $this->CLINIC_ID->CurrentValue = $this->CLINIC_ID->FormValue;
        $this->TREATMENT->CurrentValue = $this->TREATMENT->FormValue;
        $this->TREAT_DATE->CurrentValue = $this->TREAT_DATE->FormValue;
        $this->TREAT_DATE->CurrentValue = UnFormatDateTime($this->TREAT_DATE->CurrentValue, 11);
        $this->QUANTITY->CurrentValue = $this->QUANTITY->FormValue;
        $this->TRANS_ID->CurrentValue = $this->TRANS_ID->FormValue;
        if (!$this->isGridAdd() && !$this->isAdd()) {
            $this->ID->CurrentValue = $this->ID->FormValue;
        }
        $this->AMOUNT->CurrentValue = $this->AMOUNT->FormValue;
        $this->POKOK_JUAL->CurrentValue = $this->POKOK_JUAL->FormValue;
        $this->PPN->CurrentValue = $this->PPN->FormValue;
        $this->SUBSIDI->CurrentValue = $this->SUBSIDI->FormValue;
        $this->PRINT_DATE->CurrentValue = $this->PRINT_DATE->FormValue;
        $this->PRINT_DATE->CurrentValue = UnFormatDateTime($this->PRINT_DATE->CurrentValue, 0);
        $this->ISCETAK->CurrentValue = $this->ISCETAK->FormValue;
        $this->NOTA_NO->CurrentValue = $this->NOTA_NO->FormValue;
        $this->KUITANSI_ID->CurrentValue = $this->KUITANSI_ID->FormValue;
        $this->amount_paid->CurrentValue = $this->amount_paid->FormValue;
        $this->sell_price->CurrentValue = $this->sell_price->FormValue;
        $this->diskon->CurrentValue = $this->diskon->FormValue;
        $this->TAGIHAN->CurrentValue = $this->TAGIHAN->FormValue;
        $this->CLINIC_TYPE->CurrentValue = $this->CLINIC_TYPE->FormValue;
        if (!$this->isGridAdd() && !$this->isAdd()) {
            $this->ID_1->CurrentValue = $this->ID_1->FormValue;
        }
        $this->ORG_UNIT_CODE->CurrentValue = $this->ORG_UNIT_CODE->FormValue;
        $this->BILL_ID_1->CurrentValue = $this->BILL_ID_1->FormValue;
        $this->NO_REGISTRATION_1->CurrentValue = $this->NO_REGISTRATION_1->FormValue;
        $this->VISIT_ID_1->CurrentValue = $this->VISIT_ID_1->FormValue;
        $this->TARIF_ID_1->CurrentValue = $this->TARIF_ID_1->FormValue;
        $this->CLASS_ID_1->CurrentValue = $this->CLASS_ID_1->FormValue;
        $this->CLINIC_ID_1->CurrentValue = $this->CLINIC_ID_1->FormValue;
        $this->CLINIC_ID_FROM_1->CurrentValue = $this->CLINIC_ID_FROM_1->FormValue;
        $this->TREATMENT_1->CurrentValue = $this->TREATMENT_1->FormValue;
        $this->TREAT_DATE_1->CurrentValue = $this->TREAT_DATE_1->FormValue;
        $this->TREAT_DATE_1->CurrentValue = UnFormatDateTime($this->TREAT_DATE_1->CurrentValue, 0);
        $this->QUANTITY_1->CurrentValue = $this->QUANTITY_1->FormValue;
        $this->MEASURE_ID->CurrentValue = $this->MEASURE_ID->FormValue;
        $this->MEASURE_ID_1->CurrentValue = $this->MEASURE_ID_1->FormValue;
        $this->TRANS_ID_1->CurrentValue = $this->TRANS_ID_1->FormValue;
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
            if (!$this->EventCancelled) {
                $this->HashValue = $this->getRowHash($row); // Get hash value for record
            }
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
        $this->BILL_ID->setDbValue($row['BILL_ID']);
        $this->NO_REGISTRATION->setDbValue($row['NO_REGISTRATION']);
        $this->VISIT_ID->setDbValue($row['VISIT_ID']);
        $this->TARIF_ID->setDbValue($row['TARIF_ID']);
        $this->CLASS_ID->setDbValue($row['CLASS_ID']);
        $this->CLINIC_ID->setDbValue($row['CLINIC_ID']);
        $this->CLINIC_ID_FROM->setDbValue($row['CLINIC_ID_FROM']);
        $this->TREATMENT->setDbValue($row['TREATMENT']);
        $this->TREAT_DATE->setDbValue($row['TREAT_DATE']);
        $this->QUANTITY->setDbValue($row['QUANTITY']);
        $this->KELUAR_ID->setDbValue($row['KELUAR_ID']);
        $this->BED_ID->setDbValue($row['BED_ID']);
        $this->EXIT_DATE->setDbValue($row['EXIT_DATE']);
        $this->THENAME->setDbValue($row['THENAME']);
        $this->THEADDRESS->setDbValue($row['THEADDRESS']);
        $this->THEID->setDbValue($row['THEID']);
        $this->TRANS_ID->setDbValue($row['TRANS_ID']);
        $this->ID->setDbValue($row['ID']);
        $this->AMOUNT->setDbValue($row['AMOUNT']);
        $this->POKOK_JUAL->setDbValue($row['POKOK_JUAL']);
        $this->PPN->setDbValue($row['PPN']);
        $this->SUBSIDI->setDbValue($row['SUBSIDI']);
        $this->PRINT_DATE->setDbValue($row['PRINT_DATE']);
        $this->ISCETAK->setDbValue($row['ISCETAK']);
        $this->NOTA_NO->setDbValue($row['NOTA_NO']);
        $this->KUITANSI_ID->setDbValue($row['KUITANSI_ID']);
        $this->amount_paid->setDbValue($row['amount_paid']);
        $this->sell_price->setDbValue($row['sell_price']);
        $this->diskon->setDbValue($row['diskon']);
        $this->TAGIHAN->setDbValue($row['TAGIHAN']);
        $this->CLINIC_TYPE->setDbValue($row['CLINIC_TYPE']);
        $this->ID_1->setDbValue($row['ID_1']);
        $this->ORG_UNIT_CODE->setDbValue($row['ORG_UNIT_CODE']);
        $this->BILL_ID_1->setDbValue($row['BILL_ID_1']);
        $this->NO_REGISTRATION_1->setDbValue($row['NO_REGISTRATION_1']);
        $this->VISIT_ID_1->setDbValue($row['VISIT_ID_1']);
        $this->TARIF_ID_1->setDbValue($row['TARIF_ID_1']);
        $this->CLASS_ID_1->setDbValue($row['CLASS_ID_1']);
        $this->CLINIC_ID_1->setDbValue($row['CLINIC_ID_1']);
        $this->CLINIC_ID_FROM_1->setDbValue($row['CLINIC_ID_FROM_1']);
        $this->TREATMENT_1->setDbValue($row['TREATMENT_1']);
        $this->TREAT_DATE_1->setDbValue($row['TREAT_DATE_1']);
        $this->QUANTITY_1->setDbValue($row['QUANTITY_1']);
        $this->MEASURE_ID->setDbValue($row['MEASURE_ID']);
        $this->MEASURE_ID_1->setDbValue($row['MEASURE_ID_1']);
        $this->TRANS_ID_1->setDbValue($row['TRANS_ID_1']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $this->loadDefaultValues();
        $row = [];
        $row['BILL_ID'] = $this->BILL_ID->CurrentValue;
        $row['NO_REGISTRATION'] = $this->NO_REGISTRATION->CurrentValue;
        $row['VISIT_ID'] = $this->VISIT_ID->CurrentValue;
        $row['TARIF_ID'] = $this->TARIF_ID->CurrentValue;
        $row['CLASS_ID'] = $this->CLASS_ID->CurrentValue;
        $row['CLINIC_ID'] = $this->CLINIC_ID->CurrentValue;
        $row['CLINIC_ID_FROM'] = $this->CLINIC_ID_FROM->CurrentValue;
        $row['TREATMENT'] = $this->TREATMENT->CurrentValue;
        $row['TREAT_DATE'] = $this->TREAT_DATE->CurrentValue;
        $row['QUANTITY'] = $this->QUANTITY->CurrentValue;
        $row['KELUAR_ID'] = $this->KELUAR_ID->CurrentValue;
        $row['BED_ID'] = $this->BED_ID->CurrentValue;
        $row['EXIT_DATE'] = $this->EXIT_DATE->CurrentValue;
        $row['THENAME'] = $this->THENAME->CurrentValue;
        $row['THEADDRESS'] = $this->THEADDRESS->CurrentValue;
        $row['THEID'] = $this->THEID->CurrentValue;
        $row['TRANS_ID'] = $this->TRANS_ID->CurrentValue;
        $row['ID'] = $this->ID->CurrentValue;
        $row['AMOUNT'] = $this->AMOUNT->CurrentValue;
        $row['POKOK_JUAL'] = $this->POKOK_JUAL->CurrentValue;
        $row['PPN'] = $this->PPN->CurrentValue;
        $row['SUBSIDI'] = $this->SUBSIDI->CurrentValue;
        $row['PRINT_DATE'] = $this->PRINT_DATE->CurrentValue;
        $row['ISCETAK'] = $this->ISCETAK->CurrentValue;
        $row['NOTA_NO'] = $this->NOTA_NO->CurrentValue;
        $row['KUITANSI_ID'] = $this->KUITANSI_ID->CurrentValue;
        $row['amount_paid'] = $this->amount_paid->CurrentValue;
        $row['sell_price'] = $this->sell_price->CurrentValue;
        $row['diskon'] = $this->diskon->CurrentValue;
        $row['TAGIHAN'] = $this->TAGIHAN->CurrentValue;
        $row['CLINIC_TYPE'] = $this->CLINIC_TYPE->CurrentValue;
        $row['ID_1'] = $this->ID_1->CurrentValue;
        $row['ORG_UNIT_CODE'] = $this->ORG_UNIT_CODE->CurrentValue;
        $row['BILL_ID_1'] = $this->BILL_ID_1->CurrentValue;
        $row['NO_REGISTRATION_1'] = $this->NO_REGISTRATION_1->CurrentValue;
        $row['VISIT_ID_1'] = $this->VISIT_ID_1->CurrentValue;
        $row['TARIF_ID_1'] = $this->TARIF_ID_1->CurrentValue;
        $row['CLASS_ID_1'] = $this->CLASS_ID_1->CurrentValue;
        $row['CLINIC_ID_1'] = $this->CLINIC_ID_1->CurrentValue;
        $row['CLINIC_ID_FROM_1'] = $this->CLINIC_ID_FROM_1->CurrentValue;
        $row['TREATMENT_1'] = $this->TREATMENT_1->CurrentValue;
        $row['TREAT_DATE_1'] = $this->TREAT_DATE_1->CurrentValue;
        $row['QUANTITY_1'] = $this->QUANTITY_1->CurrentValue;
        $row['MEASURE_ID'] = $this->MEASURE_ID->CurrentValue;
        $row['MEASURE_ID_1'] = $this->MEASURE_ID_1->CurrentValue;
        $row['TRANS_ID_1'] = $this->TRANS_ID_1->CurrentValue;
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
        if ($this->AMOUNT->FormValue == $this->AMOUNT->CurrentValue && is_numeric(ConvertToFloatString($this->AMOUNT->CurrentValue))) {
            $this->AMOUNT->CurrentValue = ConvertToFloatString($this->AMOUNT->CurrentValue);
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
        if ($this->SUBSIDI->FormValue == $this->SUBSIDI->CurrentValue && is_numeric(ConvertToFloatString($this->SUBSIDI->CurrentValue))) {
            $this->SUBSIDI->CurrentValue = ConvertToFloatString($this->SUBSIDI->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->amount_paid->FormValue == $this->amount_paid->CurrentValue && is_numeric(ConvertToFloatString($this->amount_paid->CurrentValue))) {
            $this->amount_paid->CurrentValue = ConvertToFloatString($this->amount_paid->CurrentValue);
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
        if ($this->TAGIHAN->FormValue == $this->TAGIHAN->CurrentValue && is_numeric(ConvertToFloatString($this->TAGIHAN->CurrentValue))) {
            $this->TAGIHAN->CurrentValue = ConvertToFloatString($this->TAGIHAN->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->QUANTITY_1->FormValue == $this->QUANTITY_1->CurrentValue && is_numeric(ConvertToFloatString($this->QUANTITY_1->CurrentValue))) {
            $this->QUANTITY_1->CurrentValue = ConvertToFloatString($this->QUANTITY_1->CurrentValue);
        }

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // BILL_ID

        // NO_REGISTRATION

        // VISIT_ID

        // TARIF_ID

        // CLASS_ID

        // CLINIC_ID

        // CLINIC_ID_FROM

        // TREATMENT

        // TREAT_DATE

        // QUANTITY

        // KELUAR_ID

        // BED_ID

        // EXIT_DATE

        // THENAME

        // THEADDRESS

        // THEID

        // TRANS_ID

        // ID

        // AMOUNT

        // POKOK_JUAL

        // PPN

        // SUBSIDI

        // PRINT_DATE

        // ISCETAK

        // NOTA_NO

        // KUITANSI_ID

        // amount_paid

        // sell_price

        // diskon

        // TAGIHAN

        // CLINIC_TYPE

        // ID_1

        // ORG_UNIT_CODE

        // BILL_ID_1

        // NO_REGISTRATION_1

        // VISIT_ID_1

        // TARIF_ID_1

        // CLASS_ID_1

        // CLINIC_ID_1

        // CLINIC_ID_FROM_1

        // TREATMENT_1

        // TREAT_DATE_1

        // QUANTITY_1

        // MEASURE_ID

        // MEASURE_ID_1

        // TRANS_ID_1
        if ($this->RowType == ROWTYPE_VIEW) {
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

            // VISIT_ID
            $this->VISIT_ID->ViewValue = $this->VISIT_ID->CurrentValue;
            $this->VISIT_ID->ViewCustomAttributes = 'hidden';

            // TARIF_ID
            $curVal = trim(strval($this->TARIF_ID->CurrentValue));
            if ($curVal != "") {
                $this->TARIF_ID->ViewValue = $this->TARIF_ID->lookupCacheOption($curVal);
                if ($this->TARIF_ID->ViewValue === null) { // Lookup from database
                    $filterWrk = "[TARIF_ID]" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $lookupFilter = function() {
                        return "[IMPLEMENTED] = 1";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    $sqlWrk = $this->TARIF_ID->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->TARIF_ID->Lookup->renderViewRow($rswrk[0]);
                        $this->TARIF_ID->ViewValue = $this->TARIF_ID->displayValue($arwrk);
                    } else {
                        $this->TARIF_ID->ViewValue = $this->TARIF_ID->CurrentValue;
                    }
                }
            } else {
                $this->TARIF_ID->ViewValue = null;
            }
            $this->TARIF_ID->ViewCustomAttributes = "";

            // CLASS_ID
            $this->CLASS_ID->ViewValue = $this->CLASS_ID->CurrentValue;
            $this->CLASS_ID->ViewValue = FormatNumber($this->CLASS_ID->ViewValue, 0, -2, -2, -2);
            $this->CLASS_ID->ViewCustomAttributes = "";

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

            // CLINIC_ID_FROM
            $this->CLINIC_ID_FROM->ViewValue = $this->CLINIC_ID_FROM->CurrentValue;
            $this->CLINIC_ID_FROM->ViewCustomAttributes = "";

            // TREATMENT
            $this->TREATMENT->ViewValue = $this->TREATMENT->CurrentValue;
            $this->TREATMENT->ViewCustomAttributes = "";

            // TREAT_DATE
            $this->TREAT_DATE->ViewValue = $this->TREAT_DATE->CurrentValue;
            $this->TREAT_DATE->ViewValue = FormatDateTime($this->TREAT_DATE->ViewValue, 11);
            $this->TREAT_DATE->ViewCustomAttributes = "";

            // QUANTITY
            $this->QUANTITY->ViewValue = $this->QUANTITY->CurrentValue;
            $this->QUANTITY->ViewValue = FormatNumber($this->QUANTITY->ViewValue, 0, -2, -2, -2);
            $this->QUANTITY->ViewCustomAttributes = "";

            // KELUAR_ID
            $this->KELUAR_ID->ViewValue = $this->KELUAR_ID->CurrentValue;
            $this->KELUAR_ID->ViewValue = FormatNumber($this->KELUAR_ID->ViewValue, 0, -2, -2, -2);
            $this->KELUAR_ID->ViewCustomAttributes = "";

            // BED_ID
            $this->BED_ID->ViewValue = $this->BED_ID->CurrentValue;
            $this->BED_ID->ViewValue = FormatNumber($this->BED_ID->ViewValue, 0, -2, -2, -2);
            $this->BED_ID->ViewCustomAttributes = "";

            // EXIT_DATE
            $this->EXIT_DATE->ViewValue = $this->EXIT_DATE->CurrentValue;
            $this->EXIT_DATE->ViewValue = FormatDateTime($this->EXIT_DATE->ViewValue, 0);
            $this->EXIT_DATE->ViewCustomAttributes = "";

            // THENAME
            $this->THENAME->ViewValue = $this->THENAME->CurrentValue;
            $this->THENAME->ViewCustomAttributes = "";

            // THEADDRESS
            $this->THEADDRESS->ViewValue = $this->THEADDRESS->CurrentValue;
            $this->THEADDRESS->ViewCustomAttributes = "";

            // THEID
            $this->THEID->ViewValue = $this->THEID->CurrentValue;
            $this->THEID->ViewCustomAttributes = "";

            // TRANS_ID
            $this->TRANS_ID->ViewValue = $this->TRANS_ID->CurrentValue;
            $this->TRANS_ID->ViewCustomAttributes = "";

            // ID
            $this->ID->ViewValue = $this->ID->CurrentValue;
            $this->ID->ViewCustomAttributes = "";

            // AMOUNT
            $this->AMOUNT->ViewValue = $this->AMOUNT->CurrentValue;
            $this->AMOUNT->ViewValue = FormatNumber($this->AMOUNT->ViewValue, 2, -2, -2, -2);
            $this->AMOUNT->ViewCustomAttributes = "";

            // POKOK_JUAL
            $this->POKOK_JUAL->ViewValue = $this->POKOK_JUAL->CurrentValue;
            $this->POKOK_JUAL->ViewValue = FormatNumber($this->POKOK_JUAL->ViewValue, 2, -2, -2, -2);
            $this->POKOK_JUAL->ViewCustomAttributes = "";

            // PPN
            $this->PPN->ViewValue = $this->PPN->CurrentValue;
            $this->PPN->ViewValue = FormatNumber($this->PPN->ViewValue, 2, -2, -2, -2);
            $this->PPN->ViewCustomAttributes = "";

            // SUBSIDI
            $this->SUBSIDI->ViewValue = $this->SUBSIDI->CurrentValue;
            $this->SUBSIDI->ViewValue = FormatNumber($this->SUBSIDI->ViewValue, 2, -2, -2, -2);
            $this->SUBSIDI->ViewCustomAttributes = "";

            // PRINT_DATE
            $this->PRINT_DATE->ViewValue = $this->PRINT_DATE->CurrentValue;
            $this->PRINT_DATE->ViewValue = FormatDateTime($this->PRINT_DATE->ViewValue, 0);
            $this->PRINT_DATE->ViewCustomAttributes = "";

            // ISCETAK
            $this->ISCETAK->ViewValue = $this->ISCETAK->CurrentValue;
            $this->ISCETAK->ViewCustomAttributes = "";

            // NOTA_NO
            $this->NOTA_NO->ViewValue = $this->NOTA_NO->CurrentValue;
            $this->NOTA_NO->ViewCustomAttributes = "";

            // KUITANSI_ID
            $this->KUITANSI_ID->ViewValue = $this->KUITANSI_ID->CurrentValue;
            $this->KUITANSI_ID->ViewCustomAttributes = "";

            // amount_paid
            $this->amount_paid->ViewValue = $this->amount_paid->CurrentValue;
            $this->amount_paid->ViewValue = FormatNumber($this->amount_paid->ViewValue, 2, -2, -2, -2);
            $this->amount_paid->ViewCustomAttributes = "";

            // sell_price
            $this->sell_price->ViewValue = $this->sell_price->CurrentValue;
            $this->sell_price->ViewValue = FormatNumber($this->sell_price->ViewValue, 2, -2, -2, -2);
            $this->sell_price->ViewCustomAttributes = "";

            // diskon
            $this->diskon->ViewValue = $this->diskon->CurrentValue;
            $this->diskon->ViewValue = FormatNumber($this->diskon->ViewValue, 2, -2, -2, -2);
            $this->diskon->ViewCustomAttributes = "";

            // TAGIHAN
            $this->TAGIHAN->ViewValue = $this->TAGIHAN->CurrentValue;
            $this->TAGIHAN->ViewValue = FormatNumber($this->TAGIHAN->ViewValue, 2, -2, -2, -2);
            $this->TAGIHAN->ViewCustomAttributes = "";

            // CLINIC_TYPE
            $this->CLINIC_TYPE->ViewValue = $this->CLINIC_TYPE->CurrentValue;
            $this->CLINIC_TYPE->ViewValue = FormatNumber($this->CLINIC_TYPE->ViewValue, 0, -2, -2, -2);
            $this->CLINIC_TYPE->ViewCustomAttributes = "";

            // ID_1
            $this->ID_1->ViewValue = $this->ID_1->CurrentValue;
            $this->ID_1->ViewCustomAttributes = "";

            // ORG_UNIT_CODE
            $this->ORG_UNIT_CODE->ViewValue = $this->ORG_UNIT_CODE->CurrentValue;
            $this->ORG_UNIT_CODE->ViewCustomAttributes = "";

            // BILL_ID_1
            $this->BILL_ID_1->ViewValue = $this->BILL_ID_1->CurrentValue;
            $this->BILL_ID_1->ViewCustomAttributes = "";

            // NO_REGISTRATION_1
            $this->NO_REGISTRATION_1->ViewValue = $this->NO_REGISTRATION_1->CurrentValue;
            $this->NO_REGISTRATION_1->ViewCustomAttributes = "";

            // VISIT_ID_1
            $this->VISIT_ID_1->ViewValue = $this->VISIT_ID_1->CurrentValue;
            $this->VISIT_ID_1->ViewCustomAttributes = "";

            // TARIF_ID_1
            $this->TARIF_ID_1->ViewValue = $this->TARIF_ID_1->CurrentValue;
            $this->TARIF_ID_1->ViewCustomAttributes = "";

            // CLASS_ID_1
            $this->CLASS_ID_1->ViewValue = $this->CLASS_ID_1->CurrentValue;
            $this->CLASS_ID_1->ViewValue = FormatNumber($this->CLASS_ID_1->ViewValue, 0, -2, -2, -2);
            $this->CLASS_ID_1->ViewCustomAttributes = "";

            // CLINIC_ID_1
            $this->CLINIC_ID_1->ViewValue = $this->CLINIC_ID_1->CurrentValue;
            $this->CLINIC_ID_1->ViewCustomAttributes = "";

            // CLINIC_ID_FROM_1
            $this->CLINIC_ID_FROM_1->ViewValue = $this->CLINIC_ID_FROM_1->CurrentValue;
            $this->CLINIC_ID_FROM_1->ViewCustomAttributes = "";

            // TREATMENT_1
            $this->TREATMENT_1->ViewValue = $this->TREATMENT_1->CurrentValue;
            $this->TREATMENT_1->ViewCustomAttributes = "";

            // TREAT_DATE_1
            $this->TREAT_DATE_1->ViewValue = $this->TREAT_DATE_1->CurrentValue;
            $this->TREAT_DATE_1->ViewValue = FormatDateTime($this->TREAT_DATE_1->ViewValue, 0);
            $this->TREAT_DATE_1->ViewCustomAttributes = "";

            // QUANTITY_1
            $this->QUANTITY_1->ViewValue = $this->QUANTITY_1->CurrentValue;
            $this->QUANTITY_1->ViewValue = FormatNumber($this->QUANTITY_1->ViewValue, 2, -2, -2, -2);
            $this->QUANTITY_1->ViewCustomAttributes = "";

            // MEASURE_ID
            $this->MEASURE_ID->ViewValue = $this->MEASURE_ID->CurrentValue;
            $this->MEASURE_ID->ViewValue = FormatNumber($this->MEASURE_ID->ViewValue, 0, -2, -2, -2);
            $this->MEASURE_ID->ViewCustomAttributes = "";

            // MEASURE_ID_1
            $this->MEASURE_ID_1->ViewValue = $this->MEASURE_ID_1->CurrentValue;
            $this->MEASURE_ID_1->ViewValue = FormatNumber($this->MEASURE_ID_1->ViewValue, 0, -2, -2, -2);
            $this->MEASURE_ID_1->ViewCustomAttributes = "";

            // TRANS_ID_1
            $this->TRANS_ID_1->ViewValue = $this->TRANS_ID_1->CurrentValue;
            $this->TRANS_ID_1->ViewCustomAttributes = "";

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

            // CLINIC_ID
            $this->CLINIC_ID->LinkCustomAttributes = "";
            $this->CLINIC_ID->HrefValue = "";
            $this->CLINIC_ID->TooltipValue = "";

            // TREATMENT
            $this->TREATMENT->LinkCustomAttributes = "";
            $this->TREATMENT->HrefValue = "";
            $this->TREATMENT->TooltipValue = "";

            // TREAT_DATE
            $this->TREAT_DATE->LinkCustomAttributes = "";
            $this->TREAT_DATE->HrefValue = "";
            $this->TREAT_DATE->TooltipValue = "";

            // QUANTITY
            $this->QUANTITY->LinkCustomAttributes = "";
            $this->QUANTITY->HrefValue = "";
            $this->QUANTITY->TooltipValue = "";

            // TRANS_ID
            $this->TRANS_ID->LinkCustomAttributes = "";
            $this->TRANS_ID->HrefValue = "";
            $this->TRANS_ID->TooltipValue = "";

            // ID
            $this->ID->LinkCustomAttributes = "";
            $this->ID->HrefValue = "";
            $this->ID->TooltipValue = "";

            // AMOUNT
            $this->AMOUNT->LinkCustomAttributes = "";
            $this->AMOUNT->HrefValue = "";
            $this->AMOUNT->TooltipValue = "";

            // POKOK_JUAL
            $this->POKOK_JUAL->LinkCustomAttributes = "";
            $this->POKOK_JUAL->HrefValue = "";
            $this->POKOK_JUAL->TooltipValue = "";

            // PPN
            $this->PPN->LinkCustomAttributes = "";
            $this->PPN->HrefValue = "";
            $this->PPN->TooltipValue = "";

            // SUBSIDI
            $this->SUBSIDI->LinkCustomAttributes = "";
            $this->SUBSIDI->HrefValue = "";
            $this->SUBSIDI->TooltipValue = "";

            // PRINT_DATE
            $this->PRINT_DATE->LinkCustomAttributes = "";
            $this->PRINT_DATE->HrefValue = "";
            $this->PRINT_DATE->TooltipValue = "";

            // ISCETAK
            $this->ISCETAK->LinkCustomAttributes = "";
            $this->ISCETAK->HrefValue = "";
            $this->ISCETAK->TooltipValue = "";

            // NOTA_NO
            $this->NOTA_NO->LinkCustomAttributes = "";
            $this->NOTA_NO->HrefValue = "";
            $this->NOTA_NO->TooltipValue = "";

            // KUITANSI_ID
            $this->KUITANSI_ID->LinkCustomAttributes = "";
            $this->KUITANSI_ID->HrefValue = "";
            $this->KUITANSI_ID->TooltipValue = "";

            // amount_paid
            $this->amount_paid->LinkCustomAttributes = "";
            $this->amount_paid->HrefValue = "";
            $this->amount_paid->TooltipValue = "";

            // sell_price
            $this->sell_price->LinkCustomAttributes = "";
            $this->sell_price->HrefValue = "";
            $this->sell_price->TooltipValue = "";

            // diskon
            $this->diskon->LinkCustomAttributes = "";
            $this->diskon->HrefValue = "";
            $this->diskon->TooltipValue = "";

            // TAGIHAN
            $this->TAGIHAN->LinkCustomAttributes = "";
            $this->TAGIHAN->HrefValue = "";
            $this->TAGIHAN->TooltipValue = "";

            // CLINIC_TYPE
            $this->CLINIC_TYPE->LinkCustomAttributes = "";
            $this->CLINIC_TYPE->HrefValue = "";
            $this->CLINIC_TYPE->TooltipValue = "";

            // ID_1
            $this->ID_1->LinkCustomAttributes = "";
            $this->ID_1->HrefValue = "";
            $this->ID_1->TooltipValue = "";

            // ORG_UNIT_CODE
            $this->ORG_UNIT_CODE->LinkCustomAttributes = "";
            $this->ORG_UNIT_CODE->HrefValue = "";
            $this->ORG_UNIT_CODE->TooltipValue = "";

            // BILL_ID_1
            $this->BILL_ID_1->LinkCustomAttributes = "";
            $this->BILL_ID_1->HrefValue = "";
            $this->BILL_ID_1->TooltipValue = "";

            // NO_REGISTRATION_1
            $this->NO_REGISTRATION_1->LinkCustomAttributes = "";
            $this->NO_REGISTRATION_1->HrefValue = "";
            $this->NO_REGISTRATION_1->TooltipValue = "";

            // VISIT_ID_1
            $this->VISIT_ID_1->LinkCustomAttributes = "";
            $this->VISIT_ID_1->HrefValue = "";
            $this->VISIT_ID_1->TooltipValue = "";

            // TARIF_ID_1
            $this->TARIF_ID_1->LinkCustomAttributes = "";
            $this->TARIF_ID_1->HrefValue = "";
            $this->TARIF_ID_1->TooltipValue = "";

            // CLASS_ID_1
            $this->CLASS_ID_1->LinkCustomAttributes = "";
            $this->CLASS_ID_1->HrefValue = "";
            $this->CLASS_ID_1->TooltipValue = "";

            // CLINIC_ID_1
            $this->CLINIC_ID_1->LinkCustomAttributes = "";
            $this->CLINIC_ID_1->HrefValue = "";
            $this->CLINIC_ID_1->TooltipValue = "";

            // CLINIC_ID_FROM_1
            $this->CLINIC_ID_FROM_1->LinkCustomAttributes = "";
            $this->CLINIC_ID_FROM_1->HrefValue = "";
            $this->CLINIC_ID_FROM_1->TooltipValue = "";

            // TREATMENT_1
            $this->TREATMENT_1->LinkCustomAttributes = "";
            $this->TREATMENT_1->HrefValue = "";
            $this->TREATMENT_1->TooltipValue = "";

            // TREAT_DATE_1
            $this->TREAT_DATE_1->LinkCustomAttributes = "";
            $this->TREAT_DATE_1->HrefValue = "";
            $this->TREAT_DATE_1->TooltipValue = "";

            // QUANTITY_1
            $this->QUANTITY_1->LinkCustomAttributes = "";
            $this->QUANTITY_1->HrefValue = "";
            $this->QUANTITY_1->TooltipValue = "";

            // MEASURE_ID
            $this->MEASURE_ID->LinkCustomAttributes = "";
            $this->MEASURE_ID->HrefValue = "";
            $this->MEASURE_ID->TooltipValue = "";

            // MEASURE_ID_1
            $this->MEASURE_ID_1->LinkCustomAttributes = "";
            $this->MEASURE_ID_1->HrefValue = "";
            $this->MEASURE_ID_1->TooltipValue = "";

            // TRANS_ID_1
            $this->TRANS_ID_1->LinkCustomAttributes = "";
            $this->TRANS_ID_1->HrefValue = "";
            $this->TRANS_ID_1->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // NO_REGISTRATION
            $this->NO_REGISTRATION->EditCustomAttributes = "";
            if ($this->NO_REGISTRATION->getSessionValue() != "") {
                $this->NO_REGISTRATION->CurrentValue = GetForeignKeyValue($this->NO_REGISTRATION->getSessionValue());
                $this->NO_REGISTRATION->OldValue = $this->NO_REGISTRATION->CurrentValue;
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
            } else {
                $curVal = trim(strval($this->NO_REGISTRATION->CurrentValue));
                if ($curVal != "") {
                    $this->NO_REGISTRATION->ViewValue = $this->NO_REGISTRATION->lookupCacheOption($curVal);
                } else {
                    $this->NO_REGISTRATION->ViewValue = $this->NO_REGISTRATION->Lookup !== null && is_array($this->NO_REGISTRATION->Lookup->Options) ? $curVal : null;
                }
                if ($this->NO_REGISTRATION->ViewValue !== null) { // Load from cache
                    $this->NO_REGISTRATION->EditValue = array_values($this->NO_REGISTRATION->Lookup->Options);
                    if ($this->NO_REGISTRATION->ViewValue == "") {
                        $this->NO_REGISTRATION->ViewValue = $Language->phrase("PleaseSelect");
                    }
                } else { // Lookup from database
                    if ($curVal == "") {
                        $filterWrk = "0=1";
                    } else {
                        $filterWrk = "[NO_REGISTRATION]" . SearchString("=", $this->NO_REGISTRATION->CurrentValue, DATATYPE_STRING, "");
                    }
                    $sqlWrk = $this->NO_REGISTRATION->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->NO_REGISTRATION->Lookup->renderViewRow($rswrk[0]);
                        $this->NO_REGISTRATION->ViewValue = $this->NO_REGISTRATION->displayValue($arwrk);
                    } else {
                        $this->NO_REGISTRATION->ViewValue = $Language->phrase("PleaseSelect");
                    }
                    $arwrk = $rswrk;
                    $this->NO_REGISTRATION->EditValue = $arwrk;
                }
                $this->NO_REGISTRATION->PlaceHolder = RemoveHtml($this->NO_REGISTRATION->caption());
            }

            // VISIT_ID
            $this->VISIT_ID->EditAttrs["class"] = "form-control";
            $this->VISIT_ID->EditCustomAttributes = "";
            if ($this->VISIT_ID->getSessionValue() != "") {
                $this->VISIT_ID->CurrentValue = GetForeignKeyValue($this->VISIT_ID->getSessionValue());
                $this->VISIT_ID->OldValue = $this->VISIT_ID->CurrentValue;
                $this->VISIT_ID->ViewValue = $this->VISIT_ID->CurrentValue;
                $this->VISIT_ID->ViewCustomAttributes = 'hidden';
            } else {
                if (!$this->VISIT_ID->Raw) {
                    $this->VISIT_ID->CurrentValue = HtmlDecode($this->VISIT_ID->CurrentValue);
                }
                $this->VISIT_ID->EditValue = HtmlEncode($this->VISIT_ID->CurrentValue);
                $this->VISIT_ID->PlaceHolder = RemoveHtml($this->VISIT_ID->caption());
            }

            // TARIF_ID
            $this->TARIF_ID->EditCustomAttributes = "";
            $curVal = trim(strval($this->TARIF_ID->CurrentValue));
            if ($curVal != "") {
                $this->TARIF_ID->ViewValue = $this->TARIF_ID->lookupCacheOption($curVal);
            } else {
                $this->TARIF_ID->ViewValue = $this->TARIF_ID->Lookup !== null && is_array($this->TARIF_ID->Lookup->Options) ? $curVal : null;
            }
            if ($this->TARIF_ID->ViewValue !== null) { // Load from cache
                $this->TARIF_ID->EditValue = array_values($this->TARIF_ID->Lookup->Options);
                if ($this->TARIF_ID->ViewValue == "") {
                    $this->TARIF_ID->ViewValue = $Language->phrase("PleaseSelect");
                }
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "[TARIF_ID]" . SearchString("=", $this->TARIF_ID->CurrentValue, DATATYPE_STRING, "");
                }
                $lookupFilter = function() {
                    return "[IMPLEMENTED] = 1";
                };
                $lookupFilter = $lookupFilter->bindTo($this);
                $sqlWrk = $this->TARIF_ID->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->TARIF_ID->Lookup->renderViewRow($rswrk[0]);
                    $this->TARIF_ID->ViewValue = $this->TARIF_ID->displayValue($arwrk);
                } else {
                    $this->TARIF_ID->ViewValue = $Language->phrase("PleaseSelect");
                }
                $arwrk = $rswrk;
                foreach ($arwrk as &$row)
                    $row = $this->TARIF_ID->Lookup->renderViewRow($row);
                $this->TARIF_ID->EditValue = $arwrk;
            }
            $this->TARIF_ID->PlaceHolder = RemoveHtml($this->TARIF_ID->caption());

            // CLINIC_ID
            $this->CLINIC_ID->EditAttrs["class"] = "form-control";
            $this->CLINIC_ID->EditCustomAttributes = "";
            $curVal = trim(strval($this->CLINIC_ID->CurrentValue));
            if ($curVal != "") {
                $this->CLINIC_ID->ViewValue = $this->CLINIC_ID->lookupCacheOption($curVal);
            } else {
                $this->CLINIC_ID->ViewValue = $this->CLINIC_ID->Lookup !== null && is_array($this->CLINIC_ID->Lookup->Options) ? $curVal : null;
            }
            if ($this->CLINIC_ID->ViewValue !== null) { // Load from cache
                $this->CLINIC_ID->EditValue = array_values($this->CLINIC_ID->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "[CLINIC_ID]" . SearchString("=", $this->CLINIC_ID->CurrentValue, DATATYPE_STRING, "");
                }
                $sqlWrk = $this->CLINIC_ID->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->CLINIC_ID->EditValue = $arwrk;
            }
            $this->CLINIC_ID->PlaceHolder = RemoveHtml($this->CLINIC_ID->caption());

            // TREATMENT
            $this->TREATMENT->EditAttrs["class"] = "form-control";
            $this->TREATMENT->EditCustomAttributes = "";
            if (!$this->TREATMENT->Raw) {
                $this->TREATMENT->CurrentValue = HtmlDecode($this->TREATMENT->CurrentValue);
            }
            $this->TREATMENT->EditValue = HtmlEncode($this->TREATMENT->CurrentValue);
            $this->TREATMENT->PlaceHolder = RemoveHtml($this->TREATMENT->caption());

            // TREAT_DATE
            $this->TREAT_DATE->EditAttrs["class"] = "form-control";
            $this->TREAT_DATE->EditCustomAttributes = "";
            $this->TREAT_DATE->EditValue = HtmlEncode(FormatDateTime($this->TREAT_DATE->CurrentValue, 11));
            $this->TREAT_DATE->PlaceHolder = RemoveHtml($this->TREAT_DATE->caption());

            // QUANTITY
            $this->QUANTITY->EditAttrs["class"] = "form-control";
            $this->QUANTITY->EditCustomAttributes = "";
            $this->QUANTITY->EditValue = HtmlEncode($this->QUANTITY->CurrentValue);
            $this->QUANTITY->PlaceHolder = RemoveHtml($this->QUANTITY->caption());
            if (strval($this->QUANTITY->EditValue) != "" && is_numeric($this->QUANTITY->EditValue)) {
                $this->QUANTITY->EditValue = FormatNumber($this->QUANTITY->EditValue, -2, -2, -2, -2);
                $this->QUANTITY->OldValue = $this->QUANTITY->EditValue;
            }

            // TRANS_ID
            $this->TRANS_ID->EditAttrs["class"] = "form-control";
            $this->TRANS_ID->EditCustomAttributes = "";
            if ($this->TRANS_ID->getSessionValue() != "") {
                $this->TRANS_ID->CurrentValue = GetForeignKeyValue($this->TRANS_ID->getSessionValue());
                $this->TRANS_ID->OldValue = $this->TRANS_ID->CurrentValue;
                $this->TRANS_ID->ViewValue = $this->TRANS_ID->CurrentValue;
                $this->TRANS_ID->ViewCustomAttributes = "";
            } else {
                if (!$this->TRANS_ID->Raw) {
                    $this->TRANS_ID->CurrentValue = HtmlDecode($this->TRANS_ID->CurrentValue);
                }
                $this->TRANS_ID->EditValue = HtmlEncode($this->TRANS_ID->CurrentValue);
                $this->TRANS_ID->PlaceHolder = RemoveHtml($this->TRANS_ID->caption());
            }

            // ID

            // AMOUNT
            $this->AMOUNT->EditAttrs["class"] = "form-control";
            $this->AMOUNT->EditCustomAttributes = "";
            $this->AMOUNT->EditValue = HtmlEncode($this->AMOUNT->CurrentValue);
            $this->AMOUNT->PlaceHolder = RemoveHtml($this->AMOUNT->caption());
            if (strval($this->AMOUNT->EditValue) != "" && is_numeric($this->AMOUNT->EditValue)) {
                $this->AMOUNT->EditValue = FormatNumber($this->AMOUNT->EditValue, -2, -2, -2, -2);
                $this->AMOUNT->OldValue = $this->AMOUNT->EditValue;
            }

            // POKOK_JUAL
            $this->POKOK_JUAL->EditAttrs["class"] = "form-control";
            $this->POKOK_JUAL->EditCustomAttributes = "";
            $this->POKOK_JUAL->EditValue = HtmlEncode($this->POKOK_JUAL->CurrentValue);
            $this->POKOK_JUAL->PlaceHolder = RemoveHtml($this->POKOK_JUAL->caption());
            if (strval($this->POKOK_JUAL->EditValue) != "" && is_numeric($this->POKOK_JUAL->EditValue)) {
                $this->POKOK_JUAL->EditValue = FormatNumber($this->POKOK_JUAL->EditValue, -2, -2, -2, -2);
                $this->POKOK_JUAL->OldValue = $this->POKOK_JUAL->EditValue;
            }

            // PPN
            $this->PPN->EditAttrs["class"] = "form-control";
            $this->PPN->EditCustomAttributes = "";
            $this->PPN->EditValue = HtmlEncode($this->PPN->CurrentValue);
            $this->PPN->PlaceHolder = RemoveHtml($this->PPN->caption());
            if (strval($this->PPN->EditValue) != "" && is_numeric($this->PPN->EditValue)) {
                $this->PPN->EditValue = FormatNumber($this->PPN->EditValue, -2, -2, -2, -2);
                $this->PPN->OldValue = $this->PPN->EditValue;
            }

            // SUBSIDI
            $this->SUBSIDI->EditAttrs["class"] = "form-control";
            $this->SUBSIDI->EditCustomAttributes = "";
            $this->SUBSIDI->EditValue = HtmlEncode($this->SUBSIDI->CurrentValue);
            $this->SUBSIDI->PlaceHolder = RemoveHtml($this->SUBSIDI->caption());
            if (strval($this->SUBSIDI->EditValue) != "" && is_numeric($this->SUBSIDI->EditValue)) {
                $this->SUBSIDI->EditValue = FormatNumber($this->SUBSIDI->EditValue, -2, -2, -2, -2);
                $this->SUBSIDI->OldValue = $this->SUBSIDI->EditValue;
            }

            // PRINT_DATE
            $this->PRINT_DATE->EditAttrs["class"] = "form-control";
            $this->PRINT_DATE->EditCustomAttributes = "";
            $this->PRINT_DATE->EditValue = HtmlEncode(FormatDateTime($this->PRINT_DATE->CurrentValue, 8));
            $this->PRINT_DATE->PlaceHolder = RemoveHtml($this->PRINT_DATE->caption());

            // ISCETAK
            $this->ISCETAK->EditAttrs["class"] = "form-control";
            $this->ISCETAK->EditCustomAttributes = "";
            if (!$this->ISCETAK->Raw) {
                $this->ISCETAK->CurrentValue = HtmlDecode($this->ISCETAK->CurrentValue);
            }
            $this->ISCETAK->EditValue = HtmlEncode($this->ISCETAK->CurrentValue);
            $this->ISCETAK->PlaceHolder = RemoveHtml($this->ISCETAK->caption());

            // NOTA_NO
            $this->NOTA_NO->EditAttrs["class"] = "form-control";
            $this->NOTA_NO->EditCustomAttributes = "";
            if (!$this->NOTA_NO->Raw) {
                $this->NOTA_NO->CurrentValue = HtmlDecode($this->NOTA_NO->CurrentValue);
            }
            $this->NOTA_NO->EditValue = HtmlEncode($this->NOTA_NO->CurrentValue);
            $this->NOTA_NO->PlaceHolder = RemoveHtml($this->NOTA_NO->caption());

            // KUITANSI_ID
            $this->KUITANSI_ID->EditAttrs["class"] = "form-control";
            $this->KUITANSI_ID->EditCustomAttributes = "";
            if (!$this->KUITANSI_ID->Raw) {
                $this->KUITANSI_ID->CurrentValue = HtmlDecode($this->KUITANSI_ID->CurrentValue);
            }
            $this->KUITANSI_ID->EditValue = HtmlEncode($this->KUITANSI_ID->CurrentValue);
            $this->KUITANSI_ID->PlaceHolder = RemoveHtml($this->KUITANSI_ID->caption());

            // amount_paid
            $this->amount_paid->EditAttrs["class"] = "form-control";
            $this->amount_paid->EditCustomAttributes = "";
            $this->amount_paid->EditValue = HtmlEncode($this->amount_paid->CurrentValue);
            $this->amount_paid->PlaceHolder = RemoveHtml($this->amount_paid->caption());
            if (strval($this->amount_paid->EditValue) != "" && is_numeric($this->amount_paid->EditValue)) {
                $this->amount_paid->EditValue = FormatNumber($this->amount_paid->EditValue, -2, -2, -2, -2);
                $this->amount_paid->OldValue = $this->amount_paid->EditValue;
            }

            // sell_price
            $this->sell_price->EditAttrs["class"] = "form-control";
            $this->sell_price->EditCustomAttributes = "";
            $this->sell_price->EditValue = HtmlEncode($this->sell_price->CurrentValue);
            $this->sell_price->PlaceHolder = RemoveHtml($this->sell_price->caption());
            if (strval($this->sell_price->EditValue) != "" && is_numeric($this->sell_price->EditValue)) {
                $this->sell_price->EditValue = FormatNumber($this->sell_price->EditValue, -2, -2, -2, -2);
                $this->sell_price->OldValue = $this->sell_price->EditValue;
            }

            // diskon
            $this->diskon->EditAttrs["class"] = "form-control";
            $this->diskon->EditCustomAttributes = "";
            $this->diskon->EditValue = HtmlEncode($this->diskon->CurrentValue);
            $this->diskon->PlaceHolder = RemoveHtml($this->diskon->caption());
            if (strval($this->diskon->EditValue) != "" && is_numeric($this->diskon->EditValue)) {
                $this->diskon->EditValue = FormatNumber($this->diskon->EditValue, -2, -2, -2, -2);
                $this->diskon->OldValue = $this->diskon->EditValue;
            }

            // TAGIHAN
            $this->TAGIHAN->EditAttrs["class"] = "form-control";
            $this->TAGIHAN->EditCustomAttributes = "";
            $this->TAGIHAN->EditValue = HtmlEncode($this->TAGIHAN->CurrentValue);
            $this->TAGIHAN->PlaceHolder = RemoveHtml($this->TAGIHAN->caption());
            if (strval($this->TAGIHAN->EditValue) != "" && is_numeric($this->TAGIHAN->EditValue)) {
                $this->TAGIHAN->EditValue = FormatNumber($this->TAGIHAN->EditValue, -2, -2, -2, -2);
                $this->TAGIHAN->OldValue = $this->TAGIHAN->EditValue;
            }

            // CLINIC_TYPE
            $this->CLINIC_TYPE->EditAttrs["class"] = "form-control";
            $this->CLINIC_TYPE->EditCustomAttributes = "";
            $this->CLINIC_TYPE->EditValue = HtmlEncode($this->CLINIC_TYPE->CurrentValue);
            $this->CLINIC_TYPE->PlaceHolder = RemoveHtml($this->CLINIC_TYPE->caption());

            // ID_1

            // ORG_UNIT_CODE
            $this->ORG_UNIT_CODE->EditAttrs["class"] = "form-control";
            $this->ORG_UNIT_CODE->EditCustomAttributes = "";
            if (!$this->ORG_UNIT_CODE->Raw) {
                $this->ORG_UNIT_CODE->CurrentValue = HtmlDecode($this->ORG_UNIT_CODE->CurrentValue);
            }
            $this->ORG_UNIT_CODE->EditValue = HtmlEncode($this->ORG_UNIT_CODE->CurrentValue);
            $this->ORG_UNIT_CODE->PlaceHolder = RemoveHtml($this->ORG_UNIT_CODE->caption());

            // BILL_ID_1
            $this->BILL_ID_1->EditAttrs["class"] = "form-control";
            $this->BILL_ID_1->EditCustomAttributes = "";
            if (!$this->BILL_ID_1->Raw) {
                $this->BILL_ID_1->CurrentValue = HtmlDecode($this->BILL_ID_1->CurrentValue);
            }
            $this->BILL_ID_1->EditValue = HtmlEncode($this->BILL_ID_1->CurrentValue);
            $this->BILL_ID_1->PlaceHolder = RemoveHtml($this->BILL_ID_1->caption());

            // NO_REGISTRATION_1
            $this->NO_REGISTRATION_1->EditAttrs["class"] = "form-control";
            $this->NO_REGISTRATION_1->EditCustomAttributes = "";
            if (!$this->NO_REGISTRATION_1->Raw) {
                $this->NO_REGISTRATION_1->CurrentValue = HtmlDecode($this->NO_REGISTRATION_1->CurrentValue);
            }
            $this->NO_REGISTRATION_1->EditValue = HtmlEncode($this->NO_REGISTRATION_1->CurrentValue);
            $this->NO_REGISTRATION_1->PlaceHolder = RemoveHtml($this->NO_REGISTRATION_1->caption());

            // VISIT_ID_1
            $this->VISIT_ID_1->EditAttrs["class"] = "form-control";
            $this->VISIT_ID_1->EditCustomAttributes = "";
            if (!$this->VISIT_ID_1->Raw) {
                $this->VISIT_ID_1->CurrentValue = HtmlDecode($this->VISIT_ID_1->CurrentValue);
            }
            $this->VISIT_ID_1->EditValue = HtmlEncode($this->VISIT_ID_1->CurrentValue);
            $this->VISIT_ID_1->PlaceHolder = RemoveHtml($this->VISIT_ID_1->caption());

            // TARIF_ID_1
            $this->TARIF_ID_1->EditAttrs["class"] = "form-control";
            $this->TARIF_ID_1->EditCustomAttributes = "";
            if (!$this->TARIF_ID_1->Raw) {
                $this->TARIF_ID_1->CurrentValue = HtmlDecode($this->TARIF_ID_1->CurrentValue);
            }
            $this->TARIF_ID_1->EditValue = HtmlEncode($this->TARIF_ID_1->CurrentValue);
            $this->TARIF_ID_1->PlaceHolder = RemoveHtml($this->TARIF_ID_1->caption());

            // CLASS_ID_1
            $this->CLASS_ID_1->EditAttrs["class"] = "form-control";
            $this->CLASS_ID_1->EditCustomAttributes = "";
            $this->CLASS_ID_1->EditValue = HtmlEncode($this->CLASS_ID_1->CurrentValue);
            $this->CLASS_ID_1->PlaceHolder = RemoveHtml($this->CLASS_ID_1->caption());

            // CLINIC_ID_1
            $this->CLINIC_ID_1->EditAttrs["class"] = "form-control";
            $this->CLINIC_ID_1->EditCustomAttributes = "";
            if (!$this->CLINIC_ID_1->Raw) {
                $this->CLINIC_ID_1->CurrentValue = HtmlDecode($this->CLINIC_ID_1->CurrentValue);
            }
            $this->CLINIC_ID_1->EditValue = HtmlEncode($this->CLINIC_ID_1->CurrentValue);
            $this->CLINIC_ID_1->PlaceHolder = RemoveHtml($this->CLINIC_ID_1->caption());

            // CLINIC_ID_FROM_1
            $this->CLINIC_ID_FROM_1->EditAttrs["class"] = "form-control";
            $this->CLINIC_ID_FROM_1->EditCustomAttributes = "";
            if (!$this->CLINIC_ID_FROM_1->Raw) {
                $this->CLINIC_ID_FROM_1->CurrentValue = HtmlDecode($this->CLINIC_ID_FROM_1->CurrentValue);
            }
            $this->CLINIC_ID_FROM_1->EditValue = HtmlEncode($this->CLINIC_ID_FROM_1->CurrentValue);
            $this->CLINIC_ID_FROM_1->PlaceHolder = RemoveHtml($this->CLINIC_ID_FROM_1->caption());

            // TREATMENT_1
            $this->TREATMENT_1->EditAttrs["class"] = "form-control";
            $this->TREATMENT_1->EditCustomAttributes = "";
            if (!$this->TREATMENT_1->Raw) {
                $this->TREATMENT_1->CurrentValue = HtmlDecode($this->TREATMENT_1->CurrentValue);
            }
            $this->TREATMENT_1->EditValue = HtmlEncode($this->TREATMENT_1->CurrentValue);
            $this->TREATMENT_1->PlaceHolder = RemoveHtml($this->TREATMENT_1->caption());

            // TREAT_DATE_1
            $this->TREAT_DATE_1->EditAttrs["class"] = "form-control";
            $this->TREAT_DATE_1->EditCustomAttributes = "";
            $this->TREAT_DATE_1->EditValue = HtmlEncode(FormatDateTime($this->TREAT_DATE_1->CurrentValue, 8));
            $this->TREAT_DATE_1->PlaceHolder = RemoveHtml($this->TREAT_DATE_1->caption());

            // QUANTITY_1
            $this->QUANTITY_1->EditAttrs["class"] = "form-control";
            $this->QUANTITY_1->EditCustomAttributes = "";
            $this->QUANTITY_1->EditValue = HtmlEncode($this->QUANTITY_1->CurrentValue);
            $this->QUANTITY_1->PlaceHolder = RemoveHtml($this->QUANTITY_1->caption());
            if (strval($this->QUANTITY_1->EditValue) != "" && is_numeric($this->QUANTITY_1->EditValue)) {
                $this->QUANTITY_1->EditValue = FormatNumber($this->QUANTITY_1->EditValue, -2, -2, -2, -2);
                $this->QUANTITY_1->OldValue = $this->QUANTITY_1->EditValue;
            }

            // MEASURE_ID
            $this->MEASURE_ID->EditAttrs["class"] = "form-control";
            $this->MEASURE_ID->EditCustomAttributes = "";
            $this->MEASURE_ID->EditValue = HtmlEncode($this->MEASURE_ID->CurrentValue);
            $this->MEASURE_ID->PlaceHolder = RemoveHtml($this->MEASURE_ID->caption());

            // MEASURE_ID_1
            $this->MEASURE_ID_1->EditAttrs["class"] = "form-control";
            $this->MEASURE_ID_1->EditCustomAttributes = "";
            $this->MEASURE_ID_1->EditValue = HtmlEncode($this->MEASURE_ID_1->CurrentValue);
            $this->MEASURE_ID_1->PlaceHolder = RemoveHtml($this->MEASURE_ID_1->caption());

            // TRANS_ID_1
            $this->TRANS_ID_1->EditAttrs["class"] = "form-control";
            $this->TRANS_ID_1->EditCustomAttributes = "";
            if (!$this->TRANS_ID_1->Raw) {
                $this->TRANS_ID_1->CurrentValue = HtmlDecode($this->TRANS_ID_1->CurrentValue);
            }
            $this->TRANS_ID_1->EditValue = HtmlEncode($this->TRANS_ID_1->CurrentValue);
            $this->TRANS_ID_1->PlaceHolder = RemoveHtml($this->TRANS_ID_1->caption());

            // Add refer script

            // NO_REGISTRATION
            $this->NO_REGISTRATION->LinkCustomAttributes = "";
            $this->NO_REGISTRATION->HrefValue = "";

            // VISIT_ID
            $this->VISIT_ID->LinkCustomAttributes = "";
            $this->VISIT_ID->HrefValue = "";

            // TARIF_ID
            $this->TARIF_ID->LinkCustomAttributes = "";
            $this->TARIF_ID->HrefValue = "";

            // CLINIC_ID
            $this->CLINIC_ID->LinkCustomAttributes = "";
            $this->CLINIC_ID->HrefValue = "";

            // TREATMENT
            $this->TREATMENT->LinkCustomAttributes = "";
            $this->TREATMENT->HrefValue = "";

            // TREAT_DATE
            $this->TREAT_DATE->LinkCustomAttributes = "";
            $this->TREAT_DATE->HrefValue = "";

            // QUANTITY
            $this->QUANTITY->LinkCustomAttributes = "";
            $this->QUANTITY->HrefValue = "";

            // TRANS_ID
            $this->TRANS_ID->LinkCustomAttributes = "";
            $this->TRANS_ID->HrefValue = "";

            // ID
            $this->ID->LinkCustomAttributes = "";
            $this->ID->HrefValue = "";

            // AMOUNT
            $this->AMOUNT->LinkCustomAttributes = "";
            $this->AMOUNT->HrefValue = "";

            // POKOK_JUAL
            $this->POKOK_JUAL->LinkCustomAttributes = "";
            $this->POKOK_JUAL->HrefValue = "";

            // PPN
            $this->PPN->LinkCustomAttributes = "";
            $this->PPN->HrefValue = "";

            // SUBSIDI
            $this->SUBSIDI->LinkCustomAttributes = "";
            $this->SUBSIDI->HrefValue = "";

            // PRINT_DATE
            $this->PRINT_DATE->LinkCustomAttributes = "";
            $this->PRINT_DATE->HrefValue = "";

            // ISCETAK
            $this->ISCETAK->LinkCustomAttributes = "";
            $this->ISCETAK->HrefValue = "";

            // NOTA_NO
            $this->NOTA_NO->LinkCustomAttributes = "";
            $this->NOTA_NO->HrefValue = "";

            // KUITANSI_ID
            $this->KUITANSI_ID->LinkCustomAttributes = "";
            $this->KUITANSI_ID->HrefValue = "";

            // amount_paid
            $this->amount_paid->LinkCustomAttributes = "";
            $this->amount_paid->HrefValue = "";

            // sell_price
            $this->sell_price->LinkCustomAttributes = "";
            $this->sell_price->HrefValue = "";

            // diskon
            $this->diskon->LinkCustomAttributes = "";
            $this->diskon->HrefValue = "";

            // TAGIHAN
            $this->TAGIHAN->LinkCustomAttributes = "";
            $this->TAGIHAN->HrefValue = "";

            // CLINIC_TYPE
            $this->CLINIC_TYPE->LinkCustomAttributes = "";
            $this->CLINIC_TYPE->HrefValue = "";

            // ID_1
            $this->ID_1->LinkCustomAttributes = "";
            $this->ID_1->HrefValue = "";

            // ORG_UNIT_CODE
            $this->ORG_UNIT_CODE->LinkCustomAttributes = "";
            $this->ORG_UNIT_CODE->HrefValue = "";

            // BILL_ID_1
            $this->BILL_ID_1->LinkCustomAttributes = "";
            $this->BILL_ID_1->HrefValue = "";

            // NO_REGISTRATION_1
            $this->NO_REGISTRATION_1->LinkCustomAttributes = "";
            $this->NO_REGISTRATION_1->HrefValue = "";

            // VISIT_ID_1
            $this->VISIT_ID_1->LinkCustomAttributes = "";
            $this->VISIT_ID_1->HrefValue = "";

            // TARIF_ID_1
            $this->TARIF_ID_1->LinkCustomAttributes = "";
            $this->TARIF_ID_1->HrefValue = "";

            // CLASS_ID_1
            $this->CLASS_ID_1->LinkCustomAttributes = "";
            $this->CLASS_ID_1->HrefValue = "";

            // CLINIC_ID_1
            $this->CLINIC_ID_1->LinkCustomAttributes = "";
            $this->CLINIC_ID_1->HrefValue = "";

            // CLINIC_ID_FROM_1
            $this->CLINIC_ID_FROM_1->LinkCustomAttributes = "";
            $this->CLINIC_ID_FROM_1->HrefValue = "";

            // TREATMENT_1
            $this->TREATMENT_1->LinkCustomAttributes = "";
            $this->TREATMENT_1->HrefValue = "";

            // TREAT_DATE_1
            $this->TREAT_DATE_1->LinkCustomAttributes = "";
            $this->TREAT_DATE_1->HrefValue = "";

            // QUANTITY_1
            $this->QUANTITY_1->LinkCustomAttributes = "";
            $this->QUANTITY_1->HrefValue = "";

            // MEASURE_ID
            $this->MEASURE_ID->LinkCustomAttributes = "";
            $this->MEASURE_ID->HrefValue = "";

            // MEASURE_ID_1
            $this->MEASURE_ID_1->LinkCustomAttributes = "";
            $this->MEASURE_ID_1->HrefValue = "";

            // TRANS_ID_1
            $this->TRANS_ID_1->LinkCustomAttributes = "";
            $this->TRANS_ID_1->HrefValue = "";
        } elseif ($this->RowType == ROWTYPE_EDIT) {
            // NO_REGISTRATION
            $this->NO_REGISTRATION->EditCustomAttributes = "";
            if ($this->NO_REGISTRATION->getSessionValue() != "") {
                $this->NO_REGISTRATION->CurrentValue = GetForeignKeyValue($this->NO_REGISTRATION->getSessionValue());
                $this->NO_REGISTRATION->OldValue = $this->NO_REGISTRATION->CurrentValue;
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
            } else {
                $curVal = trim(strval($this->NO_REGISTRATION->CurrentValue));
                if ($curVal != "") {
                    $this->NO_REGISTRATION->ViewValue = $this->NO_REGISTRATION->lookupCacheOption($curVal);
                } else {
                    $this->NO_REGISTRATION->ViewValue = $this->NO_REGISTRATION->Lookup !== null && is_array($this->NO_REGISTRATION->Lookup->Options) ? $curVal : null;
                }
                if ($this->NO_REGISTRATION->ViewValue !== null) { // Load from cache
                    $this->NO_REGISTRATION->EditValue = array_values($this->NO_REGISTRATION->Lookup->Options);
                    if ($this->NO_REGISTRATION->ViewValue == "") {
                        $this->NO_REGISTRATION->ViewValue = $Language->phrase("PleaseSelect");
                    }
                } else { // Lookup from database
                    if ($curVal == "") {
                        $filterWrk = "0=1";
                    } else {
                        $filterWrk = "[NO_REGISTRATION]" . SearchString("=", $this->NO_REGISTRATION->CurrentValue, DATATYPE_STRING, "");
                    }
                    $sqlWrk = $this->NO_REGISTRATION->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->NO_REGISTRATION->Lookup->renderViewRow($rswrk[0]);
                        $this->NO_REGISTRATION->ViewValue = $this->NO_REGISTRATION->displayValue($arwrk);
                    } else {
                        $this->NO_REGISTRATION->ViewValue = $Language->phrase("PleaseSelect");
                    }
                    $arwrk = $rswrk;
                    $this->NO_REGISTRATION->EditValue = $arwrk;
                }
                $this->NO_REGISTRATION->PlaceHolder = RemoveHtml($this->NO_REGISTRATION->caption());
            }

            // VISIT_ID
            $this->VISIT_ID->EditAttrs["class"] = "form-control";
            $this->VISIT_ID->EditCustomAttributes = "";
            if ($this->VISIT_ID->getSessionValue() != "") {
                $this->VISIT_ID->CurrentValue = GetForeignKeyValue($this->VISIT_ID->getSessionValue());
                $this->VISIT_ID->OldValue = $this->VISIT_ID->CurrentValue;
                $this->VISIT_ID->ViewValue = $this->VISIT_ID->CurrentValue;
                $this->VISIT_ID->ViewCustomAttributes = 'hidden';
            } else {
            }

            // TARIF_ID
            $this->TARIF_ID->EditCustomAttributes = "";
            $curVal = trim(strval($this->TARIF_ID->CurrentValue));
            if ($curVal != "") {
                $this->TARIF_ID->ViewValue = $this->TARIF_ID->lookupCacheOption($curVal);
            } else {
                $this->TARIF_ID->ViewValue = $this->TARIF_ID->Lookup !== null && is_array($this->TARIF_ID->Lookup->Options) ? $curVal : null;
            }
            if ($this->TARIF_ID->ViewValue !== null) { // Load from cache
                $this->TARIF_ID->EditValue = array_values($this->TARIF_ID->Lookup->Options);
                if ($this->TARIF_ID->ViewValue == "") {
                    $this->TARIF_ID->ViewValue = $Language->phrase("PleaseSelect");
                }
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "[TARIF_ID]" . SearchString("=", $this->TARIF_ID->CurrentValue, DATATYPE_STRING, "");
                }
                $lookupFilter = function() {
                    return "[IMPLEMENTED] = 1";
                };
                $lookupFilter = $lookupFilter->bindTo($this);
                $sqlWrk = $this->TARIF_ID->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->TARIF_ID->Lookup->renderViewRow($rswrk[0]);
                    $this->TARIF_ID->ViewValue = $this->TARIF_ID->displayValue($arwrk);
                } else {
                    $this->TARIF_ID->ViewValue = $Language->phrase("PleaseSelect");
                }
                $arwrk = $rswrk;
                foreach ($arwrk as &$row)
                    $row = $this->TARIF_ID->Lookup->renderViewRow($row);
                $this->TARIF_ID->EditValue = $arwrk;
            }
            $this->TARIF_ID->PlaceHolder = RemoveHtml($this->TARIF_ID->caption());

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

            // TREATMENT
            $this->TREATMENT->EditAttrs["class"] = "form-control";
            $this->TREATMENT->EditCustomAttributes = "";
            if (!$this->TREATMENT->Raw) {
                $this->TREATMENT->CurrentValue = HtmlDecode($this->TREATMENT->CurrentValue);
            }
            $this->TREATMENT->EditValue = HtmlEncode($this->TREATMENT->CurrentValue);
            $this->TREATMENT->PlaceHolder = RemoveHtml($this->TREATMENT->caption());

            // TREAT_DATE
            $this->TREAT_DATE->EditAttrs["class"] = "form-control";
            $this->TREAT_DATE->EditCustomAttributes = "";
            $this->TREAT_DATE->EditValue = HtmlEncode(FormatDateTime($this->TREAT_DATE->CurrentValue, 11));
            $this->TREAT_DATE->PlaceHolder = RemoveHtml($this->TREAT_DATE->caption());

            // QUANTITY
            $this->QUANTITY->EditAttrs["class"] = "form-control";
            $this->QUANTITY->EditCustomAttributes = "";
            $this->QUANTITY->EditValue = HtmlEncode($this->QUANTITY->CurrentValue);
            $this->QUANTITY->PlaceHolder = RemoveHtml($this->QUANTITY->caption());
            if (strval($this->QUANTITY->EditValue) != "" && is_numeric($this->QUANTITY->EditValue)) {
                $this->QUANTITY->EditValue = FormatNumber($this->QUANTITY->EditValue, -2, -2, -2, -2);
                $this->QUANTITY->OldValue = $this->QUANTITY->EditValue;
            }

            // TRANS_ID
            $this->TRANS_ID->EditAttrs["class"] = "form-control";
            $this->TRANS_ID->EditCustomAttributes = "";
            if ($this->TRANS_ID->getSessionValue() != "") {
                $this->TRANS_ID->CurrentValue = GetForeignKeyValue($this->TRANS_ID->getSessionValue());
                $this->TRANS_ID->OldValue = $this->TRANS_ID->CurrentValue;
                $this->TRANS_ID->ViewValue = $this->TRANS_ID->CurrentValue;
                $this->TRANS_ID->ViewCustomAttributes = "";
            } else {
                if (!$this->TRANS_ID->Raw) {
                    $this->TRANS_ID->CurrentValue = HtmlDecode($this->TRANS_ID->CurrentValue);
                }
                $this->TRANS_ID->EditValue = HtmlEncode($this->TRANS_ID->CurrentValue);
                $this->TRANS_ID->PlaceHolder = RemoveHtml($this->TRANS_ID->caption());
            }

            // ID
            $this->ID->EditAttrs["class"] = "form-control";
            $this->ID->EditCustomAttributes = "";
            $this->ID->EditValue = $this->ID->CurrentValue;
            $this->ID->ViewCustomAttributes = "";

            // AMOUNT
            $this->AMOUNT->EditAttrs["class"] = "form-control";
            $this->AMOUNT->EditCustomAttributes = "";
            $this->AMOUNT->EditValue = HtmlEncode($this->AMOUNT->CurrentValue);
            $this->AMOUNT->PlaceHolder = RemoveHtml($this->AMOUNT->caption());
            if (strval($this->AMOUNT->EditValue) != "" && is_numeric($this->AMOUNT->EditValue)) {
                $this->AMOUNT->EditValue = FormatNumber($this->AMOUNT->EditValue, -2, -2, -2, -2);
                $this->AMOUNT->OldValue = $this->AMOUNT->EditValue;
            }

            // POKOK_JUAL
            $this->POKOK_JUAL->EditAttrs["class"] = "form-control";
            $this->POKOK_JUAL->EditCustomAttributes = "";
            $this->POKOK_JUAL->EditValue = HtmlEncode($this->POKOK_JUAL->CurrentValue);
            $this->POKOK_JUAL->PlaceHolder = RemoveHtml($this->POKOK_JUAL->caption());
            if (strval($this->POKOK_JUAL->EditValue) != "" && is_numeric($this->POKOK_JUAL->EditValue)) {
                $this->POKOK_JUAL->EditValue = FormatNumber($this->POKOK_JUAL->EditValue, -2, -2, -2, -2);
                $this->POKOK_JUAL->OldValue = $this->POKOK_JUAL->EditValue;
            }

            // PPN
            $this->PPN->EditAttrs["class"] = "form-control";
            $this->PPN->EditCustomAttributes = "";
            $this->PPN->EditValue = HtmlEncode($this->PPN->CurrentValue);
            $this->PPN->PlaceHolder = RemoveHtml($this->PPN->caption());
            if (strval($this->PPN->EditValue) != "" && is_numeric($this->PPN->EditValue)) {
                $this->PPN->EditValue = FormatNumber($this->PPN->EditValue, -2, -2, -2, -2);
                $this->PPN->OldValue = $this->PPN->EditValue;
            }

            // SUBSIDI
            $this->SUBSIDI->EditAttrs["class"] = "form-control";
            $this->SUBSIDI->EditCustomAttributes = "";
            $this->SUBSIDI->EditValue = HtmlEncode($this->SUBSIDI->CurrentValue);
            $this->SUBSIDI->PlaceHolder = RemoveHtml($this->SUBSIDI->caption());
            if (strval($this->SUBSIDI->EditValue) != "" && is_numeric($this->SUBSIDI->EditValue)) {
                $this->SUBSIDI->EditValue = FormatNumber($this->SUBSIDI->EditValue, -2, -2, -2, -2);
                $this->SUBSIDI->OldValue = $this->SUBSIDI->EditValue;
            }

            // PRINT_DATE
            $this->PRINT_DATE->EditAttrs["class"] = "form-control";
            $this->PRINT_DATE->EditCustomAttributes = "";
            $this->PRINT_DATE->EditValue = HtmlEncode(FormatDateTime($this->PRINT_DATE->CurrentValue, 8));
            $this->PRINT_DATE->PlaceHolder = RemoveHtml($this->PRINT_DATE->caption());

            // ISCETAK
            $this->ISCETAK->EditAttrs["class"] = "form-control";
            $this->ISCETAK->EditCustomAttributes = "";
            if (!$this->ISCETAK->Raw) {
                $this->ISCETAK->CurrentValue = HtmlDecode($this->ISCETAK->CurrentValue);
            }
            $this->ISCETAK->EditValue = HtmlEncode($this->ISCETAK->CurrentValue);
            $this->ISCETAK->PlaceHolder = RemoveHtml($this->ISCETAK->caption());

            // NOTA_NO
            $this->NOTA_NO->EditAttrs["class"] = "form-control";
            $this->NOTA_NO->EditCustomAttributes = "";
            if (!$this->NOTA_NO->Raw) {
                $this->NOTA_NO->CurrentValue = HtmlDecode($this->NOTA_NO->CurrentValue);
            }
            $this->NOTA_NO->EditValue = HtmlEncode($this->NOTA_NO->CurrentValue);
            $this->NOTA_NO->PlaceHolder = RemoveHtml($this->NOTA_NO->caption());

            // KUITANSI_ID
            $this->KUITANSI_ID->EditAttrs["class"] = "form-control";
            $this->KUITANSI_ID->EditCustomAttributes = "";
            if (!$this->KUITANSI_ID->Raw) {
                $this->KUITANSI_ID->CurrentValue = HtmlDecode($this->KUITANSI_ID->CurrentValue);
            }
            $this->KUITANSI_ID->EditValue = HtmlEncode($this->KUITANSI_ID->CurrentValue);
            $this->KUITANSI_ID->PlaceHolder = RemoveHtml($this->KUITANSI_ID->caption());

            // amount_paid
            $this->amount_paid->EditAttrs["class"] = "form-control";
            $this->amount_paid->EditCustomAttributes = "";
            $this->amount_paid->EditValue = HtmlEncode($this->amount_paid->CurrentValue);
            $this->amount_paid->PlaceHolder = RemoveHtml($this->amount_paid->caption());
            if (strval($this->amount_paid->EditValue) != "" && is_numeric($this->amount_paid->EditValue)) {
                $this->amount_paid->EditValue = FormatNumber($this->amount_paid->EditValue, -2, -2, -2, -2);
                $this->amount_paid->OldValue = $this->amount_paid->EditValue;
            }

            // sell_price
            $this->sell_price->EditAttrs["class"] = "form-control";
            $this->sell_price->EditCustomAttributes = "";
            $this->sell_price->EditValue = HtmlEncode($this->sell_price->CurrentValue);
            $this->sell_price->PlaceHolder = RemoveHtml($this->sell_price->caption());
            if (strval($this->sell_price->EditValue) != "" && is_numeric($this->sell_price->EditValue)) {
                $this->sell_price->EditValue = FormatNumber($this->sell_price->EditValue, -2, -2, -2, -2);
                $this->sell_price->OldValue = $this->sell_price->EditValue;
            }

            // diskon
            $this->diskon->EditAttrs["class"] = "form-control";
            $this->diskon->EditCustomAttributes = "";
            $this->diskon->EditValue = HtmlEncode($this->diskon->CurrentValue);
            $this->diskon->PlaceHolder = RemoveHtml($this->diskon->caption());
            if (strval($this->diskon->EditValue) != "" && is_numeric($this->diskon->EditValue)) {
                $this->diskon->EditValue = FormatNumber($this->diskon->EditValue, -2, -2, -2, -2);
                $this->diskon->OldValue = $this->diskon->EditValue;
            }

            // TAGIHAN
            $this->TAGIHAN->EditAttrs["class"] = "form-control";
            $this->TAGIHAN->EditCustomAttributes = "";
            $this->TAGIHAN->EditValue = HtmlEncode($this->TAGIHAN->CurrentValue);
            $this->TAGIHAN->PlaceHolder = RemoveHtml($this->TAGIHAN->caption());
            if (strval($this->TAGIHAN->EditValue) != "" && is_numeric($this->TAGIHAN->EditValue)) {
                $this->TAGIHAN->EditValue = FormatNumber($this->TAGIHAN->EditValue, -2, -2, -2, -2);
                $this->TAGIHAN->OldValue = $this->TAGIHAN->EditValue;
            }

            // CLINIC_TYPE
            $this->CLINIC_TYPE->EditAttrs["class"] = "form-control";
            $this->CLINIC_TYPE->EditCustomAttributes = "";
            $this->CLINIC_TYPE->EditValue = HtmlEncode($this->CLINIC_TYPE->CurrentValue);
            $this->CLINIC_TYPE->PlaceHolder = RemoveHtml($this->CLINIC_TYPE->caption());

            // ID_1
            $this->ID_1->EditAttrs["class"] = "form-control";
            $this->ID_1->EditCustomAttributes = "";
            $this->ID_1->EditValue = HtmlEncode($this->ID_1->CurrentValue);
            $this->ID_1->PlaceHolder = RemoveHtml($this->ID_1->caption());

            // ORG_UNIT_CODE
            $this->ORG_UNIT_CODE->EditAttrs["class"] = "form-control";
            $this->ORG_UNIT_CODE->EditCustomAttributes = "";
            if (!$this->ORG_UNIT_CODE->Raw) {
                $this->ORG_UNIT_CODE->CurrentValue = HtmlDecode($this->ORG_UNIT_CODE->CurrentValue);
            }
            $this->ORG_UNIT_CODE->EditValue = HtmlEncode($this->ORG_UNIT_CODE->CurrentValue);
            $this->ORG_UNIT_CODE->PlaceHolder = RemoveHtml($this->ORG_UNIT_CODE->caption());

            // BILL_ID_1
            $this->BILL_ID_1->EditAttrs["class"] = "form-control";
            $this->BILL_ID_1->EditCustomAttributes = "";
            if (!$this->BILL_ID_1->Raw) {
                $this->BILL_ID_1->CurrentValue = HtmlDecode($this->BILL_ID_1->CurrentValue);
            }
            $this->BILL_ID_1->EditValue = HtmlEncode($this->BILL_ID_1->CurrentValue);
            $this->BILL_ID_1->PlaceHolder = RemoveHtml($this->BILL_ID_1->caption());

            // NO_REGISTRATION_1
            $this->NO_REGISTRATION_1->EditAttrs["class"] = "form-control";
            $this->NO_REGISTRATION_1->EditCustomAttributes = "";
            if (!$this->NO_REGISTRATION_1->Raw) {
                $this->NO_REGISTRATION_1->CurrentValue = HtmlDecode($this->NO_REGISTRATION_1->CurrentValue);
            }
            $this->NO_REGISTRATION_1->EditValue = HtmlEncode($this->NO_REGISTRATION_1->CurrentValue);
            $this->NO_REGISTRATION_1->PlaceHolder = RemoveHtml($this->NO_REGISTRATION_1->caption());

            // VISIT_ID_1
            $this->VISIT_ID_1->EditAttrs["class"] = "form-control";
            $this->VISIT_ID_1->EditCustomAttributes = "";
            if (!$this->VISIT_ID_1->Raw) {
                $this->VISIT_ID_1->CurrentValue = HtmlDecode($this->VISIT_ID_1->CurrentValue);
            }
            $this->VISIT_ID_1->EditValue = HtmlEncode($this->VISIT_ID_1->CurrentValue);
            $this->VISIT_ID_1->PlaceHolder = RemoveHtml($this->VISIT_ID_1->caption());

            // TARIF_ID_1
            $this->TARIF_ID_1->EditAttrs["class"] = "form-control";
            $this->TARIF_ID_1->EditCustomAttributes = "";
            if (!$this->TARIF_ID_1->Raw) {
                $this->TARIF_ID_1->CurrentValue = HtmlDecode($this->TARIF_ID_1->CurrentValue);
            }
            $this->TARIF_ID_1->EditValue = HtmlEncode($this->TARIF_ID_1->CurrentValue);
            $this->TARIF_ID_1->PlaceHolder = RemoveHtml($this->TARIF_ID_1->caption());

            // CLASS_ID_1
            $this->CLASS_ID_1->EditAttrs["class"] = "form-control";
            $this->CLASS_ID_1->EditCustomAttributes = "";
            $this->CLASS_ID_1->EditValue = HtmlEncode($this->CLASS_ID_1->CurrentValue);
            $this->CLASS_ID_1->PlaceHolder = RemoveHtml($this->CLASS_ID_1->caption());

            // CLINIC_ID_1
            $this->CLINIC_ID_1->EditAttrs["class"] = "form-control";
            $this->CLINIC_ID_1->EditCustomAttributes = "";
            if (!$this->CLINIC_ID_1->Raw) {
                $this->CLINIC_ID_1->CurrentValue = HtmlDecode($this->CLINIC_ID_1->CurrentValue);
            }
            $this->CLINIC_ID_1->EditValue = HtmlEncode($this->CLINIC_ID_1->CurrentValue);
            $this->CLINIC_ID_1->PlaceHolder = RemoveHtml($this->CLINIC_ID_1->caption());

            // CLINIC_ID_FROM_1
            $this->CLINIC_ID_FROM_1->EditAttrs["class"] = "form-control";
            $this->CLINIC_ID_FROM_1->EditCustomAttributes = "";
            if (!$this->CLINIC_ID_FROM_1->Raw) {
                $this->CLINIC_ID_FROM_1->CurrentValue = HtmlDecode($this->CLINIC_ID_FROM_1->CurrentValue);
            }
            $this->CLINIC_ID_FROM_1->EditValue = HtmlEncode($this->CLINIC_ID_FROM_1->CurrentValue);
            $this->CLINIC_ID_FROM_1->PlaceHolder = RemoveHtml($this->CLINIC_ID_FROM_1->caption());

            // TREATMENT_1
            $this->TREATMENT_1->EditAttrs["class"] = "form-control";
            $this->TREATMENT_1->EditCustomAttributes = "";
            if (!$this->TREATMENT_1->Raw) {
                $this->TREATMENT_1->CurrentValue = HtmlDecode($this->TREATMENT_1->CurrentValue);
            }
            $this->TREATMENT_1->EditValue = HtmlEncode($this->TREATMENT_1->CurrentValue);
            $this->TREATMENT_1->PlaceHolder = RemoveHtml($this->TREATMENT_1->caption());

            // TREAT_DATE_1
            $this->TREAT_DATE_1->EditAttrs["class"] = "form-control";
            $this->TREAT_DATE_1->EditCustomAttributes = "";
            $this->TREAT_DATE_1->EditValue = HtmlEncode(FormatDateTime($this->TREAT_DATE_1->CurrentValue, 8));
            $this->TREAT_DATE_1->PlaceHolder = RemoveHtml($this->TREAT_DATE_1->caption());

            // QUANTITY_1
            $this->QUANTITY_1->EditAttrs["class"] = "form-control";
            $this->QUANTITY_1->EditCustomAttributes = "";
            $this->QUANTITY_1->EditValue = HtmlEncode($this->QUANTITY_1->CurrentValue);
            $this->QUANTITY_1->PlaceHolder = RemoveHtml($this->QUANTITY_1->caption());
            if (strval($this->QUANTITY_1->EditValue) != "" && is_numeric($this->QUANTITY_1->EditValue)) {
                $this->QUANTITY_1->EditValue = FormatNumber($this->QUANTITY_1->EditValue, -2, -2, -2, -2);
                $this->QUANTITY_1->OldValue = $this->QUANTITY_1->EditValue;
            }

            // MEASURE_ID
            $this->MEASURE_ID->EditAttrs["class"] = "form-control";
            $this->MEASURE_ID->EditCustomAttributes = "";
            $this->MEASURE_ID->EditValue = HtmlEncode($this->MEASURE_ID->CurrentValue);
            $this->MEASURE_ID->PlaceHolder = RemoveHtml($this->MEASURE_ID->caption());

            // MEASURE_ID_1
            $this->MEASURE_ID_1->EditAttrs["class"] = "form-control";
            $this->MEASURE_ID_1->EditCustomAttributes = "";
            $this->MEASURE_ID_1->EditValue = HtmlEncode($this->MEASURE_ID_1->CurrentValue);
            $this->MEASURE_ID_1->PlaceHolder = RemoveHtml($this->MEASURE_ID_1->caption());

            // TRANS_ID_1
            $this->TRANS_ID_1->EditAttrs["class"] = "form-control";
            $this->TRANS_ID_1->EditCustomAttributes = "";
            if (!$this->TRANS_ID_1->Raw) {
                $this->TRANS_ID_1->CurrentValue = HtmlDecode($this->TRANS_ID_1->CurrentValue);
            }
            $this->TRANS_ID_1->EditValue = HtmlEncode($this->TRANS_ID_1->CurrentValue);
            $this->TRANS_ID_1->PlaceHolder = RemoveHtml($this->TRANS_ID_1->caption());

            // Edit refer script

            // NO_REGISTRATION
            $this->NO_REGISTRATION->LinkCustomAttributes = "";
            $this->NO_REGISTRATION->HrefValue = "";

            // VISIT_ID
            $this->VISIT_ID->LinkCustomAttributes = "";
            $this->VISIT_ID->HrefValue = "";
            $this->VISIT_ID->TooltipValue = "";

            // TARIF_ID
            $this->TARIF_ID->LinkCustomAttributes = "";
            $this->TARIF_ID->HrefValue = "";

            // CLINIC_ID
            $this->CLINIC_ID->LinkCustomAttributes = "";
            $this->CLINIC_ID->HrefValue = "";
            $this->CLINIC_ID->TooltipValue = "";

            // TREATMENT
            $this->TREATMENT->LinkCustomAttributes = "";
            $this->TREATMENT->HrefValue = "";

            // TREAT_DATE
            $this->TREAT_DATE->LinkCustomAttributes = "";
            $this->TREAT_DATE->HrefValue = "";

            // QUANTITY
            $this->QUANTITY->LinkCustomAttributes = "";
            $this->QUANTITY->HrefValue = "";

            // TRANS_ID
            $this->TRANS_ID->LinkCustomAttributes = "";
            $this->TRANS_ID->HrefValue = "";

            // ID
            $this->ID->LinkCustomAttributes = "";
            $this->ID->HrefValue = "";

            // AMOUNT
            $this->AMOUNT->LinkCustomAttributes = "";
            $this->AMOUNT->HrefValue = "";

            // POKOK_JUAL
            $this->POKOK_JUAL->LinkCustomAttributes = "";
            $this->POKOK_JUAL->HrefValue = "";

            // PPN
            $this->PPN->LinkCustomAttributes = "";
            $this->PPN->HrefValue = "";

            // SUBSIDI
            $this->SUBSIDI->LinkCustomAttributes = "";
            $this->SUBSIDI->HrefValue = "";

            // PRINT_DATE
            $this->PRINT_DATE->LinkCustomAttributes = "";
            $this->PRINT_DATE->HrefValue = "";

            // ISCETAK
            $this->ISCETAK->LinkCustomAttributes = "";
            $this->ISCETAK->HrefValue = "";

            // NOTA_NO
            $this->NOTA_NO->LinkCustomAttributes = "";
            $this->NOTA_NO->HrefValue = "";

            // KUITANSI_ID
            $this->KUITANSI_ID->LinkCustomAttributes = "";
            $this->KUITANSI_ID->HrefValue = "";

            // amount_paid
            $this->amount_paid->LinkCustomAttributes = "";
            $this->amount_paid->HrefValue = "";

            // sell_price
            $this->sell_price->LinkCustomAttributes = "";
            $this->sell_price->HrefValue = "";

            // diskon
            $this->diskon->LinkCustomAttributes = "";
            $this->diskon->HrefValue = "";

            // TAGIHAN
            $this->TAGIHAN->LinkCustomAttributes = "";
            $this->TAGIHAN->HrefValue = "";

            // CLINIC_TYPE
            $this->CLINIC_TYPE->LinkCustomAttributes = "";
            $this->CLINIC_TYPE->HrefValue = "";

            // ID_1
            $this->ID_1->LinkCustomAttributes = "";
            $this->ID_1->HrefValue = "";

            // ORG_UNIT_CODE
            $this->ORG_UNIT_CODE->LinkCustomAttributes = "";
            $this->ORG_UNIT_CODE->HrefValue = "";

            // BILL_ID_1
            $this->BILL_ID_1->LinkCustomAttributes = "";
            $this->BILL_ID_1->HrefValue = "";

            // NO_REGISTRATION_1
            $this->NO_REGISTRATION_1->LinkCustomAttributes = "";
            $this->NO_REGISTRATION_1->HrefValue = "";

            // VISIT_ID_1
            $this->VISIT_ID_1->LinkCustomAttributes = "";
            $this->VISIT_ID_1->HrefValue = "";

            // TARIF_ID_1
            $this->TARIF_ID_1->LinkCustomAttributes = "";
            $this->TARIF_ID_1->HrefValue = "";

            // CLASS_ID_1
            $this->CLASS_ID_1->LinkCustomAttributes = "";
            $this->CLASS_ID_1->HrefValue = "";

            // CLINIC_ID_1
            $this->CLINIC_ID_1->LinkCustomAttributes = "";
            $this->CLINIC_ID_1->HrefValue = "";

            // CLINIC_ID_FROM_1
            $this->CLINIC_ID_FROM_1->LinkCustomAttributes = "";
            $this->CLINIC_ID_FROM_1->HrefValue = "";

            // TREATMENT_1
            $this->TREATMENT_1->LinkCustomAttributes = "";
            $this->TREATMENT_1->HrefValue = "";

            // TREAT_DATE_1
            $this->TREAT_DATE_1->LinkCustomAttributes = "";
            $this->TREAT_DATE_1->HrefValue = "";

            // QUANTITY_1
            $this->QUANTITY_1->LinkCustomAttributes = "";
            $this->QUANTITY_1->HrefValue = "";

            // MEASURE_ID
            $this->MEASURE_ID->LinkCustomAttributes = "";
            $this->MEASURE_ID->HrefValue = "";

            // MEASURE_ID_1
            $this->MEASURE_ID_1->LinkCustomAttributes = "";
            $this->MEASURE_ID_1->HrefValue = "";

            // TRANS_ID_1
            $this->TRANS_ID_1->LinkCustomAttributes = "";
            $this->TRANS_ID_1->HrefValue = "";
        } elseif ($this->RowType == ROWTYPE_SEARCH) {
            // NO_REGISTRATION
            $this->NO_REGISTRATION->EditAttrs["class"] = "form-control";
            $this->NO_REGISTRATION->EditCustomAttributes = "";
            $this->NO_REGISTRATION->PlaceHolder = RemoveHtml($this->NO_REGISTRATION->caption());

            // VISIT_ID
            $this->VISIT_ID->EditAttrs["class"] = "form-control";
            $this->VISIT_ID->EditCustomAttributes = "";
            if (!$this->VISIT_ID->Raw) {
                $this->VISIT_ID->AdvancedSearch->SearchValue = HtmlDecode($this->VISIT_ID->AdvancedSearch->SearchValue);
            }
            $this->VISIT_ID->EditValue = HtmlEncode($this->VISIT_ID->AdvancedSearch->SearchValue);
            $this->VISIT_ID->PlaceHolder = RemoveHtml($this->VISIT_ID->caption());

            // TARIF_ID
            $this->TARIF_ID->EditAttrs["class"] = "form-control";
            $this->TARIF_ID->EditCustomAttributes = "";
            $this->TARIF_ID->PlaceHolder = RemoveHtml($this->TARIF_ID->caption());

            // CLINIC_ID
            $this->CLINIC_ID->EditAttrs["class"] = "form-control";
            $this->CLINIC_ID->EditCustomAttributes = "";
            $curVal = trim(strval($this->CLINIC_ID->AdvancedSearch->SearchValue));
            if ($curVal != "") {
                $this->CLINIC_ID->AdvancedSearch->ViewValue = $this->CLINIC_ID->lookupCacheOption($curVal);
            } else {
                $this->CLINIC_ID->AdvancedSearch->ViewValue = $this->CLINIC_ID->Lookup !== null && is_array($this->CLINIC_ID->Lookup->Options) ? $curVal : null;
            }
            if ($this->CLINIC_ID->AdvancedSearch->ViewValue !== null) { // Load from cache
                $this->CLINIC_ID->EditValue = array_values($this->CLINIC_ID->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "[CLINIC_ID]" . SearchString("=", $this->CLINIC_ID->AdvancedSearch->SearchValue, DATATYPE_STRING, "");
                }
                $sqlWrk = $this->CLINIC_ID->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->CLINIC_ID->EditValue = $arwrk;
            }
            $this->CLINIC_ID->PlaceHolder = RemoveHtml($this->CLINIC_ID->caption());

            // TREATMENT
            $this->TREATMENT->EditAttrs["class"] = "form-control";
            $this->TREATMENT->EditCustomAttributes = "";
            if (!$this->TREATMENT->Raw) {
                $this->TREATMENT->AdvancedSearch->SearchValue = HtmlDecode($this->TREATMENT->AdvancedSearch->SearchValue);
            }
            $this->TREATMENT->EditValue = HtmlEncode($this->TREATMENT->AdvancedSearch->SearchValue);
            $this->TREATMENT->PlaceHolder = RemoveHtml($this->TREATMENT->caption());

            // TREAT_DATE
            $this->TREAT_DATE->EditAttrs["class"] = "form-control";
            $this->TREAT_DATE->EditCustomAttributes = "";
            $this->TREAT_DATE->EditValue = HtmlEncode(FormatDateTime(UnFormatDateTime($this->TREAT_DATE->AdvancedSearch->SearchValue, 11), 11));
            $this->TREAT_DATE->PlaceHolder = RemoveHtml($this->TREAT_DATE->caption());

            // QUANTITY
            $this->QUANTITY->EditAttrs["class"] = "form-control";
            $this->QUANTITY->EditCustomAttributes = "";
            $this->QUANTITY->EditValue = HtmlEncode($this->QUANTITY->AdvancedSearch->SearchValue);
            $this->QUANTITY->PlaceHolder = RemoveHtml($this->QUANTITY->caption());

            // TRANS_ID
            $this->TRANS_ID->EditAttrs["class"] = "form-control";
            $this->TRANS_ID->EditCustomAttributes = "";
            if (!$this->TRANS_ID->Raw) {
                $this->TRANS_ID->AdvancedSearch->SearchValue = HtmlDecode($this->TRANS_ID->AdvancedSearch->SearchValue);
            }
            $this->TRANS_ID->EditValue = HtmlEncode($this->TRANS_ID->AdvancedSearch->SearchValue);
            $this->TRANS_ID->PlaceHolder = RemoveHtml($this->TRANS_ID->caption());

            // ID
            $this->ID->EditAttrs["class"] = "form-control";
            $this->ID->EditCustomAttributes = "";
            $this->ID->EditValue = HtmlEncode($this->ID->AdvancedSearch->SearchValue);
            $this->ID->PlaceHolder = RemoveHtml($this->ID->caption());

            // AMOUNT
            $this->AMOUNT->EditAttrs["class"] = "form-control";
            $this->AMOUNT->EditCustomAttributes = "";
            $this->AMOUNT->EditValue = HtmlEncode($this->AMOUNT->AdvancedSearch->SearchValue);
            $this->AMOUNT->PlaceHolder = RemoveHtml($this->AMOUNT->caption());

            // POKOK_JUAL
            $this->POKOK_JUAL->EditAttrs["class"] = "form-control";
            $this->POKOK_JUAL->EditCustomAttributes = "";
            $this->POKOK_JUAL->EditValue = HtmlEncode($this->POKOK_JUAL->AdvancedSearch->SearchValue);
            $this->POKOK_JUAL->PlaceHolder = RemoveHtml($this->POKOK_JUAL->caption());

            // PPN
            $this->PPN->EditAttrs["class"] = "form-control";
            $this->PPN->EditCustomAttributes = "";
            $this->PPN->EditValue = HtmlEncode($this->PPN->AdvancedSearch->SearchValue);
            $this->PPN->PlaceHolder = RemoveHtml($this->PPN->caption());

            // SUBSIDI
            $this->SUBSIDI->EditAttrs["class"] = "form-control";
            $this->SUBSIDI->EditCustomAttributes = "";
            $this->SUBSIDI->EditValue = HtmlEncode($this->SUBSIDI->AdvancedSearch->SearchValue);
            $this->SUBSIDI->PlaceHolder = RemoveHtml($this->SUBSIDI->caption());

            // PRINT_DATE
            $this->PRINT_DATE->EditAttrs["class"] = "form-control";
            $this->PRINT_DATE->EditCustomAttributes = "";
            $this->PRINT_DATE->EditValue = HtmlEncode(FormatDateTime(UnFormatDateTime($this->PRINT_DATE->AdvancedSearch->SearchValue, 0), 8));
            $this->PRINT_DATE->PlaceHolder = RemoveHtml($this->PRINT_DATE->caption());

            // ISCETAK
            $this->ISCETAK->EditAttrs["class"] = "form-control";
            $this->ISCETAK->EditCustomAttributes = "";
            if (!$this->ISCETAK->Raw) {
                $this->ISCETAK->AdvancedSearch->SearchValue = HtmlDecode($this->ISCETAK->AdvancedSearch->SearchValue);
            }
            $this->ISCETAK->EditValue = HtmlEncode($this->ISCETAK->AdvancedSearch->SearchValue);
            $this->ISCETAK->PlaceHolder = RemoveHtml($this->ISCETAK->caption());

            // NOTA_NO
            $this->NOTA_NO->EditAttrs["class"] = "form-control";
            $this->NOTA_NO->EditCustomAttributes = "";
            if (!$this->NOTA_NO->Raw) {
                $this->NOTA_NO->AdvancedSearch->SearchValue = HtmlDecode($this->NOTA_NO->AdvancedSearch->SearchValue);
            }
            $this->NOTA_NO->EditValue = HtmlEncode($this->NOTA_NO->AdvancedSearch->SearchValue);
            $this->NOTA_NO->PlaceHolder = RemoveHtml($this->NOTA_NO->caption());

            // KUITANSI_ID
            $this->KUITANSI_ID->EditAttrs["class"] = "form-control";
            $this->KUITANSI_ID->EditCustomAttributes = "";
            if (!$this->KUITANSI_ID->Raw) {
                $this->KUITANSI_ID->AdvancedSearch->SearchValue = HtmlDecode($this->KUITANSI_ID->AdvancedSearch->SearchValue);
            }
            $this->KUITANSI_ID->EditValue = HtmlEncode($this->KUITANSI_ID->AdvancedSearch->SearchValue);
            $this->KUITANSI_ID->PlaceHolder = RemoveHtml($this->KUITANSI_ID->caption());

            // amount_paid
            $this->amount_paid->EditAttrs["class"] = "form-control";
            $this->amount_paid->EditCustomAttributes = "";
            $this->amount_paid->EditValue = HtmlEncode($this->amount_paid->AdvancedSearch->SearchValue);
            $this->amount_paid->PlaceHolder = RemoveHtml($this->amount_paid->caption());

            // sell_price
            $this->sell_price->EditAttrs["class"] = "form-control";
            $this->sell_price->EditCustomAttributes = "";
            $this->sell_price->EditValue = HtmlEncode($this->sell_price->AdvancedSearch->SearchValue);
            $this->sell_price->PlaceHolder = RemoveHtml($this->sell_price->caption());

            // diskon
            $this->diskon->EditAttrs["class"] = "form-control";
            $this->diskon->EditCustomAttributes = "";
            $this->diskon->EditValue = HtmlEncode($this->diskon->AdvancedSearch->SearchValue);
            $this->diskon->PlaceHolder = RemoveHtml($this->diskon->caption());

            // TAGIHAN
            $this->TAGIHAN->EditAttrs["class"] = "form-control";
            $this->TAGIHAN->EditCustomAttributes = "";
            $this->TAGIHAN->EditValue = HtmlEncode($this->TAGIHAN->AdvancedSearch->SearchValue);
            $this->TAGIHAN->PlaceHolder = RemoveHtml($this->TAGIHAN->caption());

            // CLINIC_TYPE
            $this->CLINIC_TYPE->EditAttrs["class"] = "form-control";
            $this->CLINIC_TYPE->EditCustomAttributes = "";
            $this->CLINIC_TYPE->EditValue = HtmlEncode($this->CLINIC_TYPE->AdvancedSearch->SearchValue);
            $this->CLINIC_TYPE->PlaceHolder = RemoveHtml($this->CLINIC_TYPE->caption());

            // ID_1
            $this->ID_1->EditAttrs["class"] = "form-control";
            $this->ID_1->EditCustomAttributes = "";
            $this->ID_1->EditValue = HtmlEncode($this->ID_1->AdvancedSearch->SearchValue);
            $this->ID_1->PlaceHolder = RemoveHtml($this->ID_1->caption());

            // ORG_UNIT_CODE
            $this->ORG_UNIT_CODE->EditAttrs["class"] = "form-control";
            $this->ORG_UNIT_CODE->EditCustomAttributes = "";
            if (!$this->ORG_UNIT_CODE->Raw) {
                $this->ORG_UNIT_CODE->AdvancedSearch->SearchValue = HtmlDecode($this->ORG_UNIT_CODE->AdvancedSearch->SearchValue);
            }
            $this->ORG_UNIT_CODE->EditValue = HtmlEncode($this->ORG_UNIT_CODE->AdvancedSearch->SearchValue);
            $this->ORG_UNIT_CODE->PlaceHolder = RemoveHtml($this->ORG_UNIT_CODE->caption());

            // BILL_ID_1
            $this->BILL_ID_1->EditAttrs["class"] = "form-control";
            $this->BILL_ID_1->EditCustomAttributes = "";
            if (!$this->BILL_ID_1->Raw) {
                $this->BILL_ID_1->AdvancedSearch->SearchValue = HtmlDecode($this->BILL_ID_1->AdvancedSearch->SearchValue);
            }
            $this->BILL_ID_1->EditValue = HtmlEncode($this->BILL_ID_1->AdvancedSearch->SearchValue);
            $this->BILL_ID_1->PlaceHolder = RemoveHtml($this->BILL_ID_1->caption());

            // NO_REGISTRATION_1
            $this->NO_REGISTRATION_1->EditAttrs["class"] = "form-control";
            $this->NO_REGISTRATION_1->EditCustomAttributes = "";
            if (!$this->NO_REGISTRATION_1->Raw) {
                $this->NO_REGISTRATION_1->AdvancedSearch->SearchValue = HtmlDecode($this->NO_REGISTRATION_1->AdvancedSearch->SearchValue);
            }
            $this->NO_REGISTRATION_1->EditValue = HtmlEncode($this->NO_REGISTRATION_1->AdvancedSearch->SearchValue);
            $this->NO_REGISTRATION_1->PlaceHolder = RemoveHtml($this->NO_REGISTRATION_1->caption());

            // VISIT_ID_1
            $this->VISIT_ID_1->EditAttrs["class"] = "form-control";
            $this->VISIT_ID_1->EditCustomAttributes = "";
            if (!$this->VISIT_ID_1->Raw) {
                $this->VISIT_ID_1->AdvancedSearch->SearchValue = HtmlDecode($this->VISIT_ID_1->AdvancedSearch->SearchValue);
            }
            $this->VISIT_ID_1->EditValue = HtmlEncode($this->VISIT_ID_1->AdvancedSearch->SearchValue);
            $this->VISIT_ID_1->PlaceHolder = RemoveHtml($this->VISIT_ID_1->caption());

            // TARIF_ID_1
            $this->TARIF_ID_1->EditAttrs["class"] = "form-control";
            $this->TARIF_ID_1->EditCustomAttributes = "";
            if (!$this->TARIF_ID_1->Raw) {
                $this->TARIF_ID_1->AdvancedSearch->SearchValue = HtmlDecode($this->TARIF_ID_1->AdvancedSearch->SearchValue);
            }
            $this->TARIF_ID_1->EditValue = HtmlEncode($this->TARIF_ID_1->AdvancedSearch->SearchValue);
            $this->TARIF_ID_1->PlaceHolder = RemoveHtml($this->TARIF_ID_1->caption());

            // CLASS_ID_1
            $this->CLASS_ID_1->EditAttrs["class"] = "form-control";
            $this->CLASS_ID_1->EditCustomAttributes = "";
            $this->CLASS_ID_1->EditValue = HtmlEncode($this->CLASS_ID_1->AdvancedSearch->SearchValue);
            $this->CLASS_ID_1->PlaceHolder = RemoveHtml($this->CLASS_ID_1->caption());

            // CLINIC_ID_1
            $this->CLINIC_ID_1->EditAttrs["class"] = "form-control";
            $this->CLINIC_ID_1->EditCustomAttributes = "";
            if (!$this->CLINIC_ID_1->Raw) {
                $this->CLINIC_ID_1->AdvancedSearch->SearchValue = HtmlDecode($this->CLINIC_ID_1->AdvancedSearch->SearchValue);
            }
            $this->CLINIC_ID_1->EditValue = HtmlEncode($this->CLINIC_ID_1->AdvancedSearch->SearchValue);
            $this->CLINIC_ID_1->PlaceHolder = RemoveHtml($this->CLINIC_ID_1->caption());

            // CLINIC_ID_FROM_1
            $this->CLINIC_ID_FROM_1->EditAttrs["class"] = "form-control";
            $this->CLINIC_ID_FROM_1->EditCustomAttributes = "";
            if (!$this->CLINIC_ID_FROM_1->Raw) {
                $this->CLINIC_ID_FROM_1->AdvancedSearch->SearchValue = HtmlDecode($this->CLINIC_ID_FROM_1->AdvancedSearch->SearchValue);
            }
            $this->CLINIC_ID_FROM_1->EditValue = HtmlEncode($this->CLINIC_ID_FROM_1->AdvancedSearch->SearchValue);
            $this->CLINIC_ID_FROM_1->PlaceHolder = RemoveHtml($this->CLINIC_ID_FROM_1->caption());

            // TREATMENT_1
            $this->TREATMENT_1->EditAttrs["class"] = "form-control";
            $this->TREATMENT_1->EditCustomAttributes = "";
            if (!$this->TREATMENT_1->Raw) {
                $this->TREATMENT_1->AdvancedSearch->SearchValue = HtmlDecode($this->TREATMENT_1->AdvancedSearch->SearchValue);
            }
            $this->TREATMENT_1->EditValue = HtmlEncode($this->TREATMENT_1->AdvancedSearch->SearchValue);
            $this->TREATMENT_1->PlaceHolder = RemoveHtml($this->TREATMENT_1->caption());

            // TREAT_DATE_1
            $this->TREAT_DATE_1->EditAttrs["class"] = "form-control";
            $this->TREAT_DATE_1->EditCustomAttributes = "";
            $this->TREAT_DATE_1->EditValue = HtmlEncode(FormatDateTime(UnFormatDateTime($this->TREAT_DATE_1->AdvancedSearch->SearchValue, 0), 8));
            $this->TREAT_DATE_1->PlaceHolder = RemoveHtml($this->TREAT_DATE_1->caption());

            // QUANTITY_1
            $this->QUANTITY_1->EditAttrs["class"] = "form-control";
            $this->QUANTITY_1->EditCustomAttributes = "";
            $this->QUANTITY_1->EditValue = HtmlEncode($this->QUANTITY_1->AdvancedSearch->SearchValue);
            $this->QUANTITY_1->PlaceHolder = RemoveHtml($this->QUANTITY_1->caption());

            // MEASURE_ID
            $this->MEASURE_ID->EditAttrs["class"] = "form-control";
            $this->MEASURE_ID->EditCustomAttributes = "";
            $this->MEASURE_ID->EditValue = HtmlEncode($this->MEASURE_ID->AdvancedSearch->SearchValue);
            $this->MEASURE_ID->PlaceHolder = RemoveHtml($this->MEASURE_ID->caption());

            // MEASURE_ID_1
            $this->MEASURE_ID_1->EditAttrs["class"] = "form-control";
            $this->MEASURE_ID_1->EditCustomAttributes = "";
            $this->MEASURE_ID_1->EditValue = HtmlEncode($this->MEASURE_ID_1->AdvancedSearch->SearchValue);
            $this->MEASURE_ID_1->PlaceHolder = RemoveHtml($this->MEASURE_ID_1->caption());

            // TRANS_ID_1
            $this->TRANS_ID_1->EditAttrs["class"] = "form-control";
            $this->TRANS_ID_1->EditCustomAttributes = "";
            if (!$this->TRANS_ID_1->Raw) {
                $this->TRANS_ID_1->AdvancedSearch->SearchValue = HtmlDecode($this->TRANS_ID_1->AdvancedSearch->SearchValue);
            }
            $this->TRANS_ID_1->EditValue = HtmlEncode($this->TRANS_ID_1->AdvancedSearch->SearchValue);
            $this->TRANS_ID_1->PlaceHolder = RemoveHtml($this->TRANS_ID_1->caption());
        }
        if ($this->RowType == ROWTYPE_ADD || $this->RowType == ROWTYPE_EDIT || $this->RowType == ROWTYPE_SEARCH) { // Add/Edit/Search row
            $this->setupFieldTitles();
        }

        // Call Row Rendered event
        if ($this->RowType != ROWTYPE_AGGREGATEINIT) {
            $this->rowRendered();
        }
    }

    // Validate search
    protected function validateSearch()
    {
        // Check if validation required
        if (!Config("SERVER_VALIDATE")) {
            return true;
        }
        if (!CheckEuroDate($this->TREAT_DATE->AdvancedSearch->SearchValue)) {
            $this->TREAT_DATE->addErrorMessage($this->TREAT_DATE->getErrorMessage(false));
        }

        // Return validate result
        $validateSearch = !$this->hasInvalidFields();

        // Call Form_CustomValidate event
        $formCustomError = "";
        $validateSearch = $validateSearch && $this->formCustomValidate($formCustomError);
        if ($formCustomError != "") {
            $this->setFailureMessage($formCustomError);
        }
        return $validateSearch;
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
        if ($this->VISIT_ID->Required) {
            if (!$this->VISIT_ID->IsDetailKey && EmptyValue($this->VISIT_ID->FormValue)) {
                $this->VISIT_ID->addErrorMessage(str_replace("%s", $this->VISIT_ID->caption(), $this->VISIT_ID->RequiredErrorMessage));
            }
        }
        if ($this->TARIF_ID->Required) {
            if (!$this->TARIF_ID->IsDetailKey && EmptyValue($this->TARIF_ID->FormValue)) {
                $this->TARIF_ID->addErrorMessage(str_replace("%s", $this->TARIF_ID->caption(), $this->TARIF_ID->RequiredErrorMessage));
            }
        }
        if ($this->CLINIC_ID->Required) {
            if (!$this->CLINIC_ID->IsDetailKey && EmptyValue($this->CLINIC_ID->FormValue)) {
                $this->CLINIC_ID->addErrorMessage(str_replace("%s", $this->CLINIC_ID->caption(), $this->CLINIC_ID->RequiredErrorMessage));
            }
        }
        if ($this->TREATMENT->Required) {
            if (!$this->TREATMENT->IsDetailKey && EmptyValue($this->TREATMENT->FormValue)) {
                $this->TREATMENT->addErrorMessage(str_replace("%s", $this->TREATMENT->caption(), $this->TREATMENT->RequiredErrorMessage));
            }
        }
        if ($this->TREAT_DATE->Required) {
            if (!$this->TREAT_DATE->IsDetailKey && EmptyValue($this->TREAT_DATE->FormValue)) {
                $this->TREAT_DATE->addErrorMessage(str_replace("%s", $this->TREAT_DATE->caption(), $this->TREAT_DATE->RequiredErrorMessage));
            }
        }
        if (!CheckEuroDate($this->TREAT_DATE->FormValue)) {
            $this->TREAT_DATE->addErrorMessage($this->TREAT_DATE->getErrorMessage(false));
        }
        if ($this->QUANTITY->Required) {
            if (!$this->QUANTITY->IsDetailKey && EmptyValue($this->QUANTITY->FormValue)) {
                $this->QUANTITY->addErrorMessage(str_replace("%s", $this->QUANTITY->caption(), $this->QUANTITY->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->QUANTITY->FormValue)) {
            $this->QUANTITY->addErrorMessage($this->QUANTITY->getErrorMessage(false));
        }
        if ($this->TRANS_ID->Required) {
            if (!$this->TRANS_ID->IsDetailKey && EmptyValue($this->TRANS_ID->FormValue)) {
                $this->TRANS_ID->addErrorMessage(str_replace("%s", $this->TRANS_ID->caption(), $this->TRANS_ID->RequiredErrorMessage));
            }
        }
        if ($this->ID->Required) {
            if (!$this->ID->IsDetailKey && EmptyValue($this->ID->FormValue)) {
                $this->ID->addErrorMessage(str_replace("%s", $this->ID->caption(), $this->ID->RequiredErrorMessage));
            }
        }
        if ($this->AMOUNT->Required) {
            if (!$this->AMOUNT->IsDetailKey && EmptyValue($this->AMOUNT->FormValue)) {
                $this->AMOUNT->addErrorMessage(str_replace("%s", $this->AMOUNT->caption(), $this->AMOUNT->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->AMOUNT->FormValue)) {
            $this->AMOUNT->addErrorMessage($this->AMOUNT->getErrorMessage(false));
        }
        if ($this->POKOK_JUAL->Required) {
            if (!$this->POKOK_JUAL->IsDetailKey && EmptyValue($this->POKOK_JUAL->FormValue)) {
                $this->POKOK_JUAL->addErrorMessage(str_replace("%s", $this->POKOK_JUAL->caption(), $this->POKOK_JUAL->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->POKOK_JUAL->FormValue)) {
            $this->POKOK_JUAL->addErrorMessage($this->POKOK_JUAL->getErrorMessage(false));
        }
        if ($this->PPN->Required) {
            if (!$this->PPN->IsDetailKey && EmptyValue($this->PPN->FormValue)) {
                $this->PPN->addErrorMessage(str_replace("%s", $this->PPN->caption(), $this->PPN->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->PPN->FormValue)) {
            $this->PPN->addErrorMessage($this->PPN->getErrorMessage(false));
        }
        if ($this->SUBSIDI->Required) {
            if (!$this->SUBSIDI->IsDetailKey && EmptyValue($this->SUBSIDI->FormValue)) {
                $this->SUBSIDI->addErrorMessage(str_replace("%s", $this->SUBSIDI->caption(), $this->SUBSIDI->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->SUBSIDI->FormValue)) {
            $this->SUBSIDI->addErrorMessage($this->SUBSIDI->getErrorMessage(false));
        }
        if ($this->PRINT_DATE->Required) {
            if (!$this->PRINT_DATE->IsDetailKey && EmptyValue($this->PRINT_DATE->FormValue)) {
                $this->PRINT_DATE->addErrorMessage(str_replace("%s", $this->PRINT_DATE->caption(), $this->PRINT_DATE->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->PRINT_DATE->FormValue)) {
            $this->PRINT_DATE->addErrorMessage($this->PRINT_DATE->getErrorMessage(false));
        }
        if ($this->ISCETAK->Required) {
            if (!$this->ISCETAK->IsDetailKey && EmptyValue($this->ISCETAK->FormValue)) {
                $this->ISCETAK->addErrorMessage(str_replace("%s", $this->ISCETAK->caption(), $this->ISCETAK->RequiredErrorMessage));
            }
        }
        if ($this->NOTA_NO->Required) {
            if (!$this->NOTA_NO->IsDetailKey && EmptyValue($this->NOTA_NO->FormValue)) {
                $this->NOTA_NO->addErrorMessage(str_replace("%s", $this->NOTA_NO->caption(), $this->NOTA_NO->RequiredErrorMessage));
            }
        }
        if ($this->KUITANSI_ID->Required) {
            if (!$this->KUITANSI_ID->IsDetailKey && EmptyValue($this->KUITANSI_ID->FormValue)) {
                $this->KUITANSI_ID->addErrorMessage(str_replace("%s", $this->KUITANSI_ID->caption(), $this->KUITANSI_ID->RequiredErrorMessage));
            }
        }
        if ($this->amount_paid->Required) {
            if (!$this->amount_paid->IsDetailKey && EmptyValue($this->amount_paid->FormValue)) {
                $this->amount_paid->addErrorMessage(str_replace("%s", $this->amount_paid->caption(), $this->amount_paid->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->amount_paid->FormValue)) {
            $this->amount_paid->addErrorMessage($this->amount_paid->getErrorMessage(false));
        }
        if ($this->sell_price->Required) {
            if (!$this->sell_price->IsDetailKey && EmptyValue($this->sell_price->FormValue)) {
                $this->sell_price->addErrorMessage(str_replace("%s", $this->sell_price->caption(), $this->sell_price->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->sell_price->FormValue)) {
            $this->sell_price->addErrorMessage($this->sell_price->getErrorMessage(false));
        }
        if ($this->diskon->Required) {
            if (!$this->diskon->IsDetailKey && EmptyValue($this->diskon->FormValue)) {
                $this->diskon->addErrorMessage(str_replace("%s", $this->diskon->caption(), $this->diskon->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->diskon->FormValue)) {
            $this->diskon->addErrorMessage($this->diskon->getErrorMessage(false));
        }
        if ($this->TAGIHAN->Required) {
            if (!$this->TAGIHAN->IsDetailKey && EmptyValue($this->TAGIHAN->FormValue)) {
                $this->TAGIHAN->addErrorMessage(str_replace("%s", $this->TAGIHAN->caption(), $this->TAGIHAN->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->TAGIHAN->FormValue)) {
            $this->TAGIHAN->addErrorMessage($this->TAGIHAN->getErrorMessage(false));
        }
        if ($this->CLINIC_TYPE->Required) {
            if (!$this->CLINIC_TYPE->IsDetailKey && EmptyValue($this->CLINIC_TYPE->FormValue)) {
                $this->CLINIC_TYPE->addErrorMessage(str_replace("%s", $this->CLINIC_TYPE->caption(), $this->CLINIC_TYPE->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->CLINIC_TYPE->FormValue)) {
            $this->CLINIC_TYPE->addErrorMessage($this->CLINIC_TYPE->getErrorMessage(false));
        }
        if ($this->ID_1->Required) {
            if (!$this->ID_1->IsDetailKey && EmptyValue($this->ID_1->FormValue)) {
                $this->ID_1->addErrorMessage(str_replace("%s", $this->ID_1->caption(), $this->ID_1->RequiredErrorMessage));
            }
        }
        if ($this->ORG_UNIT_CODE->Required) {
            if (!$this->ORG_UNIT_CODE->IsDetailKey && EmptyValue($this->ORG_UNIT_CODE->FormValue)) {
                $this->ORG_UNIT_CODE->addErrorMessage(str_replace("%s", $this->ORG_UNIT_CODE->caption(), $this->ORG_UNIT_CODE->RequiredErrorMessage));
            }
        }
        if ($this->BILL_ID_1->Required) {
            if (!$this->BILL_ID_1->IsDetailKey && EmptyValue($this->BILL_ID_1->FormValue)) {
                $this->BILL_ID_1->addErrorMessage(str_replace("%s", $this->BILL_ID_1->caption(), $this->BILL_ID_1->RequiredErrorMessage));
            }
        }
        if ($this->NO_REGISTRATION_1->Required) {
            if (!$this->NO_REGISTRATION_1->IsDetailKey && EmptyValue($this->NO_REGISTRATION_1->FormValue)) {
                $this->NO_REGISTRATION_1->addErrorMessage(str_replace("%s", $this->NO_REGISTRATION_1->caption(), $this->NO_REGISTRATION_1->RequiredErrorMessage));
            }
        }
        if ($this->VISIT_ID_1->Required) {
            if (!$this->VISIT_ID_1->IsDetailKey && EmptyValue($this->VISIT_ID_1->FormValue)) {
                $this->VISIT_ID_1->addErrorMessage(str_replace("%s", $this->VISIT_ID_1->caption(), $this->VISIT_ID_1->RequiredErrorMessage));
            }
        }
        if ($this->TARIF_ID_1->Required) {
            if (!$this->TARIF_ID_1->IsDetailKey && EmptyValue($this->TARIF_ID_1->FormValue)) {
                $this->TARIF_ID_1->addErrorMessage(str_replace("%s", $this->TARIF_ID_1->caption(), $this->TARIF_ID_1->RequiredErrorMessage));
            }
        }
        if ($this->CLASS_ID_1->Required) {
            if (!$this->CLASS_ID_1->IsDetailKey && EmptyValue($this->CLASS_ID_1->FormValue)) {
                $this->CLASS_ID_1->addErrorMessage(str_replace("%s", $this->CLASS_ID_1->caption(), $this->CLASS_ID_1->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->CLASS_ID_1->FormValue)) {
            $this->CLASS_ID_1->addErrorMessage($this->CLASS_ID_1->getErrorMessage(false));
        }
        if ($this->CLINIC_ID_1->Required) {
            if (!$this->CLINIC_ID_1->IsDetailKey && EmptyValue($this->CLINIC_ID_1->FormValue)) {
                $this->CLINIC_ID_1->addErrorMessage(str_replace("%s", $this->CLINIC_ID_1->caption(), $this->CLINIC_ID_1->RequiredErrorMessage));
            }
        }
        if ($this->CLINIC_ID_FROM_1->Required) {
            if (!$this->CLINIC_ID_FROM_1->IsDetailKey && EmptyValue($this->CLINIC_ID_FROM_1->FormValue)) {
                $this->CLINIC_ID_FROM_1->addErrorMessage(str_replace("%s", $this->CLINIC_ID_FROM_1->caption(), $this->CLINIC_ID_FROM_1->RequiredErrorMessage));
            }
        }
        if ($this->TREATMENT_1->Required) {
            if (!$this->TREATMENT_1->IsDetailKey && EmptyValue($this->TREATMENT_1->FormValue)) {
                $this->TREATMENT_1->addErrorMessage(str_replace("%s", $this->TREATMENT_1->caption(), $this->TREATMENT_1->RequiredErrorMessage));
            }
        }
        if ($this->TREAT_DATE_1->Required) {
            if (!$this->TREAT_DATE_1->IsDetailKey && EmptyValue($this->TREAT_DATE_1->FormValue)) {
                $this->TREAT_DATE_1->addErrorMessage(str_replace("%s", $this->TREAT_DATE_1->caption(), $this->TREAT_DATE_1->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->TREAT_DATE_1->FormValue)) {
            $this->TREAT_DATE_1->addErrorMessage($this->TREAT_DATE_1->getErrorMessage(false));
        }
        if ($this->QUANTITY_1->Required) {
            if (!$this->QUANTITY_1->IsDetailKey && EmptyValue($this->QUANTITY_1->FormValue)) {
                $this->QUANTITY_1->addErrorMessage(str_replace("%s", $this->QUANTITY_1->caption(), $this->QUANTITY_1->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->QUANTITY_1->FormValue)) {
            $this->QUANTITY_1->addErrorMessage($this->QUANTITY_1->getErrorMessage(false));
        }
        if ($this->MEASURE_ID->Required) {
            if (!$this->MEASURE_ID->IsDetailKey && EmptyValue($this->MEASURE_ID->FormValue)) {
                $this->MEASURE_ID->addErrorMessage(str_replace("%s", $this->MEASURE_ID->caption(), $this->MEASURE_ID->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->MEASURE_ID->FormValue)) {
            $this->MEASURE_ID->addErrorMessage($this->MEASURE_ID->getErrorMessage(false));
        }
        if ($this->MEASURE_ID_1->Required) {
            if (!$this->MEASURE_ID_1->IsDetailKey && EmptyValue($this->MEASURE_ID_1->FormValue)) {
                $this->MEASURE_ID_1->addErrorMessage(str_replace("%s", $this->MEASURE_ID_1->caption(), $this->MEASURE_ID_1->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->MEASURE_ID_1->FormValue)) {
            $this->MEASURE_ID_1->addErrorMessage($this->MEASURE_ID_1->getErrorMessage(false));
        }
        if ($this->TRANS_ID_1->Required) {
            if (!$this->TRANS_ID_1->IsDetailKey && EmptyValue($this->TRANS_ID_1->FormValue)) {
                $this->TRANS_ID_1->addErrorMessage(str_replace("%s", $this->TRANS_ID_1->caption(), $this->TRANS_ID_1->RequiredErrorMessage));
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

    // Delete records based on current filter
    protected function deleteRows()
    {
        global $Language, $Security;
        if (!$Security->canDelete()) {
            $this->setFailureMessage($Language->phrase("NoDeletePermission")); // No delete permission
            return false;
        }
        $deleteRows = true;
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $rows = $conn->fetchAll($sql);
        if (count($rows) == 0) {
            $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
            return false;
        }

        // Clone old rows
        $rsold = $rows;

        // Call row deleting event
        if ($deleteRows) {
            foreach ($rsold as $row) {
                $deleteRows = $this->rowDeleting($row);
                if (!$deleteRows) {
                    break;
                }
            }
        }
        if ($deleteRows) {
            $key = "";
            foreach ($rsold as $row) {
                $thisKey = "";
                if ($thisKey != "") {
                    $thisKey .= Config("COMPOSITE_KEY_SEPARATOR");
                }
                $thisKey .= $row['ID'];
                if (Config("DELETE_UPLOADED_FILES")) { // Delete old files
                    $this->deleteUploadedFiles($row);
                }
                $deleteRows = $this->delete($row); // Delete
                if ($deleteRows === false) {
                    break;
                }
                if ($key != "") {
                    $key .= ", ";
                }
                $key .= $thisKey;
            }
        }
        if (!$deleteRows) {
            // Set up error message
            if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                // Use the message, do nothing
            } elseif ($this->CancelMessage != "") {
                $this->setFailureMessage($this->CancelMessage);
                $this->CancelMessage = "";
            } else {
                $this->setFailureMessage($Language->phrase("DeleteCancelled"));
            }
        }

        // Call Row Deleted event
        if ($deleteRows) {
            foreach ($rsold as $row) {
                $this->rowDeleted($row);
            }
        }

        // Write JSON for API request
        if (IsApi() && $deleteRows) {
            $row = $this->getRecordsFromRecordset($rsold);
            WriteJson(["success" => true, $this->TableVar => $row]);
        }
        return $deleteRows;
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

            // NO_REGISTRATION
            if ($this->NO_REGISTRATION->getSessionValue() != "") {
                $this->NO_REGISTRATION->ReadOnly = true;
            }
            $this->NO_REGISTRATION->setDbValueDef($rsnew, $this->NO_REGISTRATION->CurrentValue, "", $this->NO_REGISTRATION->ReadOnly);

            // TARIF_ID
            $this->TARIF_ID->setDbValueDef($rsnew, $this->TARIF_ID->CurrentValue, null, $this->TARIF_ID->ReadOnly);

            // TREATMENT
            $this->TREATMENT->setDbValueDef($rsnew, $this->TREATMENT->CurrentValue, null, $this->TREATMENT->ReadOnly);

            // TREAT_DATE
            $this->TREAT_DATE->setDbValueDef($rsnew, UnFormatDateTime($this->TREAT_DATE->CurrentValue, 11), null, $this->TREAT_DATE->ReadOnly);

            // QUANTITY
            $this->QUANTITY->setDbValueDef($rsnew, $this->QUANTITY->CurrentValue, null, $this->QUANTITY->ReadOnly);

            // TRANS_ID
            if ($this->TRANS_ID->getSessionValue() != "") {
                $this->TRANS_ID->ReadOnly = true;
            }
            $this->TRANS_ID->setDbValueDef($rsnew, $this->TRANS_ID->CurrentValue, null, $this->TRANS_ID->ReadOnly);

            // AMOUNT
            $this->AMOUNT->setDbValueDef($rsnew, $this->AMOUNT->CurrentValue, null, $this->AMOUNT->ReadOnly);

            // POKOK_JUAL
            $this->POKOK_JUAL->setDbValueDef($rsnew, $this->POKOK_JUAL->CurrentValue, null, $this->POKOK_JUAL->ReadOnly);

            // PPN
            $this->PPN->setDbValueDef($rsnew, $this->PPN->CurrentValue, null, $this->PPN->ReadOnly);

            // SUBSIDI
            $this->SUBSIDI->setDbValueDef($rsnew, $this->SUBSIDI->CurrentValue, null, $this->SUBSIDI->ReadOnly);

            // PRINT_DATE
            $this->PRINT_DATE->setDbValueDef($rsnew, UnFormatDateTime($this->PRINT_DATE->CurrentValue, 0), null, $this->PRINT_DATE->ReadOnly);

            // ISCETAK
            $this->ISCETAK->setDbValueDef($rsnew, $this->ISCETAK->CurrentValue, null, $this->ISCETAK->ReadOnly);

            // NOTA_NO
            $this->NOTA_NO->setDbValueDef($rsnew, $this->NOTA_NO->CurrentValue, null, $this->NOTA_NO->ReadOnly);

            // KUITANSI_ID
            $this->KUITANSI_ID->setDbValueDef($rsnew, $this->KUITANSI_ID->CurrentValue, null, $this->KUITANSI_ID->ReadOnly);

            // amount_paid
            $this->amount_paid->setDbValueDef($rsnew, $this->amount_paid->CurrentValue, null, $this->amount_paid->ReadOnly);

            // sell_price
            $this->sell_price->setDbValueDef($rsnew, $this->sell_price->CurrentValue, null, $this->sell_price->ReadOnly);

            // diskon
            $this->diskon->setDbValueDef($rsnew, $this->diskon->CurrentValue, null, $this->diskon->ReadOnly);

            // TAGIHAN
            $this->TAGIHAN->setDbValueDef($rsnew, $this->TAGIHAN->CurrentValue, null, $this->TAGIHAN->ReadOnly);

            // MEASURE_ID
            $this->MEASURE_ID->setDbValueDef($rsnew, $this->MEASURE_ID->CurrentValue, null, $this->MEASURE_ID->ReadOnly);

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

    // Load row hash
    protected function loadRowHash()
    {
        $filter = $this->getRecordFilter();

        // Load SQL based on filter
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $row = $conn->fetchAssoc($sql);
        $this->HashValue = $row ? $this->getRowHash($row) : ""; // Get hash value for record
    }

    // Get Row Hash
    public function getRowHash(&$rs)
    {
        if (!$rs) {
            return "";
        }
        $row = ($rs instanceof Recordset) ? $rs->fields : $rs;
        $hash = "";
        $hash .= GetFieldHash($row['NO_REGISTRATION']); // NO_REGISTRATION
        $hash .= GetFieldHash($row['TARIF_ID']); // TARIF_ID
        $hash .= GetFieldHash($row['TREATMENT']); // TREATMENT
        $hash .= GetFieldHash($row['TREAT_DATE']); // TREAT_DATE
        $hash .= GetFieldHash($row['QUANTITY']); // QUANTITY
        $hash .= GetFieldHash($row['TRANS_ID']); // TRANS_ID
        $hash .= GetFieldHash($row['AMOUNT']); // AMOUNT
        $hash .= GetFieldHash($row['POKOK_JUAL']); // POKOK_JUAL
        $hash .= GetFieldHash($row['PPN']); // PPN
        $hash .= GetFieldHash($row['SUBSIDI']); // SUBSIDI
        $hash .= GetFieldHash($row['PRINT_DATE']); // PRINT_DATE
        $hash .= GetFieldHash($row['ISCETAK']); // ISCETAK
        $hash .= GetFieldHash($row['NOTA_NO']); // NOTA_NO
        $hash .= GetFieldHash($row['KUITANSI_ID']); // KUITANSI_ID
        $hash .= GetFieldHash($row['amount_paid']); // amount_paid
        $hash .= GetFieldHash($row['sell_price']); // sell_price
        $hash .= GetFieldHash($row['diskon']); // diskon
        $hash .= GetFieldHash($row['TAGIHAN']); // TAGIHAN
        $hash .= GetFieldHash($row['MEASURE_ID']); // MEASURE_ID
        return md5($hash);
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

        // NO_REGISTRATION
        $this->NO_REGISTRATION->setDbValueDef($rsnew, $this->NO_REGISTRATION->CurrentValue, "", false);

        // VISIT_ID
        $this->VISIT_ID->setDbValueDef($rsnew, $this->VISIT_ID->CurrentValue, "", false);

        // TARIF_ID
        $this->TARIF_ID->setDbValueDef($rsnew, $this->TARIF_ID->CurrentValue, null, false);

        // CLINIC_ID
        $this->CLINIC_ID->setDbValueDef($rsnew, $this->CLINIC_ID->CurrentValue, null, false);

        // TREATMENT
        $this->TREATMENT->setDbValueDef($rsnew, $this->TREATMENT->CurrentValue, null, false);

        // TREAT_DATE
        $this->TREAT_DATE->setDbValueDef($rsnew, UnFormatDateTime($this->TREAT_DATE->CurrentValue, 11), null, false);

        // QUANTITY
        $this->QUANTITY->setDbValueDef($rsnew, $this->QUANTITY->CurrentValue, null, false);

        // TRANS_ID
        $this->TRANS_ID->setDbValueDef($rsnew, $this->TRANS_ID->CurrentValue, null, false);

        // AMOUNT
        $this->AMOUNT->setDbValueDef($rsnew, $this->AMOUNT->CurrentValue, null, false);

        // POKOK_JUAL
        $this->POKOK_JUAL->setDbValueDef($rsnew, $this->POKOK_JUAL->CurrentValue, null, false);

        // PPN
        $this->PPN->setDbValueDef($rsnew, $this->PPN->CurrentValue, null, false);

        // SUBSIDI
        $this->SUBSIDI->setDbValueDef($rsnew, $this->SUBSIDI->CurrentValue, null, false);

        // PRINT_DATE
        $this->PRINT_DATE->setDbValueDef($rsnew, UnFormatDateTime($this->PRINT_DATE->CurrentValue, 0), null, false);

        // ISCETAK
        $this->ISCETAK->setDbValueDef($rsnew, $this->ISCETAK->CurrentValue, null, false);

        // NOTA_NO
        $this->NOTA_NO->setDbValueDef($rsnew, $this->NOTA_NO->CurrentValue, null, false);

        // KUITANSI_ID
        $this->KUITANSI_ID->setDbValueDef($rsnew, $this->KUITANSI_ID->CurrentValue, null, false);

        // amount_paid
        $this->amount_paid->setDbValueDef($rsnew, $this->amount_paid->CurrentValue, null, false);

        // sell_price
        $this->sell_price->setDbValueDef($rsnew, $this->sell_price->CurrentValue, null, false);

        // diskon
        $this->diskon->setDbValueDef($rsnew, $this->diskon->CurrentValue, null, false);

        // TAGIHAN
        $this->TAGIHAN->setDbValueDef($rsnew, $this->TAGIHAN->CurrentValue, null, false);

        // MEASURE_ID
        $this->MEASURE_ID->setDbValueDef($rsnew, $this->MEASURE_ID->CurrentValue, null, false);

        // THENAME
        if ($this->THENAME->getSessionValue() != "") {
            $rsnew['THENAME'] = $this->THENAME->getSessionValue();
        }

        // THEADDRESS
        if ($this->THEADDRESS->getSessionValue() != "") {
            $rsnew['THEADDRESS'] = $this->THEADDRESS->getSessionValue();
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

    // Load advanced search
    public function loadAdvancedSearch()
    {
        $this->BILL_ID->AdvancedSearch->load();
        $this->NO_REGISTRATION->AdvancedSearch->load();
        $this->VISIT_ID->AdvancedSearch->load();
        $this->TARIF_ID->AdvancedSearch->load();
        $this->CLASS_ID->AdvancedSearch->load();
        $this->CLINIC_ID->AdvancedSearch->load();
        $this->CLINIC_ID_FROM->AdvancedSearch->load();
        $this->TREATMENT->AdvancedSearch->load();
        $this->TREAT_DATE->AdvancedSearch->load();
        $this->QUANTITY->AdvancedSearch->load();
        $this->KELUAR_ID->AdvancedSearch->load();
        $this->BED_ID->AdvancedSearch->load();
        $this->EXIT_DATE->AdvancedSearch->load();
        $this->THENAME->AdvancedSearch->load();
        $this->THEADDRESS->AdvancedSearch->load();
        $this->THEID->AdvancedSearch->load();
        $this->TRANS_ID->AdvancedSearch->load();
        $this->ID->AdvancedSearch->load();
        $this->AMOUNT->AdvancedSearch->load();
        $this->POKOK_JUAL->AdvancedSearch->load();
        $this->PPN->AdvancedSearch->load();
        $this->SUBSIDI->AdvancedSearch->load();
        $this->PRINT_DATE->AdvancedSearch->load();
        $this->ISCETAK->AdvancedSearch->load();
        $this->NOTA_NO->AdvancedSearch->load();
        $this->KUITANSI_ID->AdvancedSearch->load();
        $this->amount_paid->AdvancedSearch->load();
        $this->sell_price->AdvancedSearch->load();
        $this->diskon->AdvancedSearch->load();
        $this->TAGIHAN->AdvancedSearch->load();
        $this->CLINIC_TYPE->AdvancedSearch->load();
        $this->ID_1->AdvancedSearch->load();
        $this->ORG_UNIT_CODE->AdvancedSearch->load();
        $this->BILL_ID_1->AdvancedSearch->load();
        $this->NO_REGISTRATION_1->AdvancedSearch->load();
        $this->VISIT_ID_1->AdvancedSearch->load();
        $this->TARIF_ID_1->AdvancedSearch->load();
        $this->CLASS_ID_1->AdvancedSearch->load();
        $this->CLINIC_ID_1->AdvancedSearch->load();
        $this->CLINIC_ID_FROM_1->AdvancedSearch->load();
        $this->TREATMENT_1->AdvancedSearch->load();
        $this->TREAT_DATE_1->AdvancedSearch->load();
        $this->QUANTITY_1->AdvancedSearch->load();
        $this->MEASURE_ID->AdvancedSearch->load();
        $this->MEASURE_ID_1->AdvancedSearch->load();
        $this->TRANS_ID_1->AdvancedSearch->load();
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
        $item->Body = "<a class=\"btn btn-default ew-search-toggle" . $searchToggleClass . "\" href=\"#\" role=\"button\" title=\"" . $Language->phrase("SearchPanel") . "\" data-caption=\"" . $Language->phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fTREATMENT_INAPlistsrch\" aria-pressed=\"" . ($searchToggleClass == " active" ? "true" : "false") . "\">" . $Language->phrase("SearchLink") . "</a>";
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
            if ($masterTblVar == "PASIEN_VISITATION") {
                $validMaster = true;
                $masterTbl = Container("PASIEN_VISITATION");
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
                if (($parm = Get("fk_TRANS_ID", Get("TRANS_ID"))) !== null) {
                    $masterTbl->TRANS_ID->setQueryStringValue($parm);
                    $this->TRANS_ID->setQueryStringValue($masterTbl->TRANS_ID->QueryStringValue);
                    $this->TRANS_ID->setSessionValue($this->TRANS_ID->QueryStringValue);
                } else {
                    $validMaster = false;
                }
                if (($parm = Get("fk_DIANTAR_OLEH", Get("THENAME"))) !== null) {
                    $masterTbl->DIANTAR_OLEH->setQueryStringValue($parm);
                    $this->THENAME->setQueryStringValue($masterTbl->DIANTAR_OLEH->QueryStringValue);
                    $this->THENAME->setSessionValue($this->THENAME->QueryStringValue);
                } else {
                    $validMaster = false;
                }
                if (($parm = Get("fk_VISITOR_ADDRESS", Get("THEADDRESS"))) !== null) {
                    $masterTbl->VISITOR_ADDRESS->setQueryStringValue($parm);
                    $this->THEADDRESS->setQueryStringValue($masterTbl->VISITOR_ADDRESS->QueryStringValue);
                    $this->THEADDRESS->setSessionValue($this->THEADDRESS->QueryStringValue);
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
            if ($masterTblVar == "PASIEN_VISITATION") {
                $validMaster = true;
                $masterTbl = Container("PASIEN_VISITATION");
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
                if (($parm = Post("fk_TRANS_ID", Post("TRANS_ID"))) !== null) {
                    $masterTbl->TRANS_ID->setFormValue($parm);
                    $this->TRANS_ID->setFormValue($masterTbl->TRANS_ID->FormValue);
                    $this->TRANS_ID->setSessionValue($this->TRANS_ID->FormValue);
                } else {
                    $validMaster = false;
                }
                if (($parm = Post("fk_DIANTAR_OLEH", Post("THENAME"))) !== null) {
                    $masterTbl->DIANTAR_OLEH->setFormValue($parm);
                    $this->THENAME->setFormValue($masterTbl->DIANTAR_OLEH->FormValue);
                    $this->THENAME->setSessionValue($this->THENAME->FormValue);
                } else {
                    $validMaster = false;
                }
                if (($parm = Post("fk_VISITOR_ADDRESS", Post("THEADDRESS"))) !== null) {
                    $masterTbl->VISITOR_ADDRESS->setFormValue($parm);
                    $this->THEADDRESS->setFormValue($masterTbl->VISITOR_ADDRESS->FormValue);
                    $this->THEADDRESS->setSessionValue($this->THEADDRESS->FormValue);
                } else {
                    $validMaster = false;
                }
            }
        }
        if ($validMaster) {
            // Save current master table
            $this->setCurrentMasterTable($masterTblVar);

            // Update URL
            $this->AddUrl = $this->addMasterUrl($this->AddUrl);
            $this->InlineAddUrl = $this->addMasterUrl($this->InlineAddUrl);
            $this->GridAddUrl = $this->addMasterUrl($this->GridAddUrl);
            $this->GridEditUrl = $this->addMasterUrl($this->GridEditUrl);

            // Reset start record counter (new master key)
            if (!$this->isAddOrEdit()) {
                $this->StartRecord = 1;
                $this->setStartRecordNumber($this->StartRecord);
            }

            // Clear previous master key from Session
            if ($masterTblVar != "PASIEN_VISITATION") {
                if ($this->VISIT_ID->CurrentValue == "") {
                    $this->VISIT_ID->setSessionValue("");
                }
                if ($this->NO_REGISTRATION->CurrentValue == "") {
                    $this->NO_REGISTRATION->setSessionValue("");
                }
                if ($this->TRANS_ID->CurrentValue == "") {
                    $this->TRANS_ID->setSessionValue("");
                }
                if ($this->THENAME->CurrentValue == "") {
                    $this->THENAME->setSessionValue("");
                }
                if ($this->THEADDRESS->CurrentValue == "") {
                    $this->THEADDRESS->setSessionValue("");
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
                case "x_NO_REGISTRATION":
                    break;
                case "x_TARIF_ID":
                    $lookupFilter = function () {
                        return "[IMPLEMENTED] = 1";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    break;
                case "x_CLINIC_ID":
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
