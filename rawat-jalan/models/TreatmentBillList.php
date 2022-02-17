<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAJALALTER;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class TreatmentBillList extends TreatmentBill
{
    use MessagesTrait;

    // Page ID
    public $PageID = "list";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'TREATMENT_BILL';

    // Page object name
    public $PageObjName = "TreatmentBillList";

    // Rendering View
    public $RenderingView = false;

    // Grid form hidden field names
    public $FormName = "fTREATMENT_BILLlist";
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

        // Table object (TREATMENT_BILL)
        if (!isset($GLOBALS["TREATMENT_BILL"]) || get_class($GLOBALS["TREATMENT_BILL"]) == PROJECT_NAMESPACE . "TREATMENT_BILL") {
            $GLOBALS["TREATMENT_BILL"] = &$this;
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
        $this->AddUrl = "TreatmentBillAdd";
        $this->InlineAddUrl = $pageUrl . "action=add";
        $this->GridAddUrl = $pageUrl . "action=gridadd";
        $this->GridEditUrl = $pageUrl . "action=gridedit";
        $this->MultiDeleteUrl = "TreatmentBillDelete";
        $this->MultiUpdateUrl = "TreatmentBillUpdate";

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'TREATMENT_BILL');
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
        $this->FilterOptions->TagClassName = "ew-filter-option fTREATMENT_BILLlistsrch";

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
                $doc = new $class(Container("TREATMENT_BILL"));
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
            $this->MODIFIED_BY->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->MODIFIED_DATE->Visible = false;
        }
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
        $this->CurrentAction = Param("action"); // Set up current action

        // Get grid add count
        $gridaddcnt = Get(Config("TABLE_GRID_ADD_ROW_COUNT"), "");
        if (is_numeric($gridaddcnt) && $gridaddcnt > 0) {
            $this->GridAddRowCount = $gridaddcnt;
        }

        // Set up list options
        $this->setupListOptions();
        $this->ORG_UNIT_CODE->Visible = false;
        $this->BILL_ID->Visible = false;
        $this->NO_REGISTRATION->setVisibility();
        $this->VISIT_ID->setVisibility();
        $this->TARIF_ID->setVisibility();
        $this->CLASS_ID->Visible = false;
        $this->CLINIC_ID->setVisibility();
        $this->CLINIC_ID_FROM->Visible = false;
        $this->TREATMENT->setVisibility();
        $this->TREAT_DATE->setVisibility();
        $this->AMOUNT->setVisibility();
        $this->QUANTITY->setVisibility();
        $this->MEASURE_ID->Visible = false;
        $this->POKOK_JUAL->Visible = false;
        $this->PPN->Visible = false;
        $this->MARGIN->Visible = false;
        $this->SUBSIDI->Visible = false;
        $this->EMBALACE->Visible = false;
        $this->PROFESI->Visible = false;
        $this->DISCOUNT->Visible = false;
        $this->PAY_METHOD_ID->Visible = false;
        $this->PAYMENT_DATE->Visible = false;
        $this->ISLUNAS->setVisibility();
        $this->DUEDATE_ANGSURAN->Visible = false;
        $this->DESCRIPTION->Visible = false;
        $this->KUITANSI_ID->Visible = false;
        $this->NOTA_NO->setVisibility();
        $this->ISCETAK->Visible = false;
        $this->PRINT_DATE->Visible = false;
        $this->RESEP_NO->Visible = false;
        $this->RESEP_KE->Visible = false;
        $this->DOSE->Visible = false;
        $this->ORIG_DOSE->Visible = false;
        $this->DOSE_PRESC->Visible = false;
        $this->ITER->Visible = false;
        $this->ITER_KE->Visible = false;
        $this->SOLD_STATUS->Visible = false;
        $this->RACIKAN->Visible = false;
        $this->CLASS_ROOM_ID->Visible = false;
        $this->KELUAR_ID->Visible = false;
        $this->BED_ID->Visible = false;
        $this->PERDA_ID->Visible = false;
        $this->EMPLOYEE_ID->setVisibility();
        $this->DESCRIPTION2->Visible = false;
        $this->MODIFIED_BY->Visible = false;
        $this->MODIFIED_DATE->Visible = false;
        $this->MODIFIED_FROM->Visible = false;
        $this->BRAND_ID->Visible = false;
        $this->DOCTOR->setVisibility();
        $this->JML_BKS->Visible = false;
        $this->EXIT_DATE->Visible = false;
        $this->FA_V->Visible = false;
        $this->TASK_ID->Visible = false;
        $this->EMPLOYEE_ID_FROM->Visible = false;
        $this->DOCTOR_FROM->Visible = false;
        $this->status_pasien_id->Visible = false;
        $this->amount_paid->setVisibility();
        $this->THENAME->setVisibility();
        $this->THEADDRESS->setVisibility();
        $this->THEID->setVisibility();
        $this->serial_nb->Visible = false;
        $this->TREATMENT_PLAFOND->Visible = false;
        $this->AMOUNT_PLAFOND->Visible = false;
        $this->AMOUNT_PAID_PLAFOND->Visible = false;
        $this->CLASS_ID_PLAFOND->Visible = false;
        $this->PAYOR_ID->Visible = false;
        $this->PEMBULATAN->Visible = false;
        $this->ISRJ->setVisibility();
        $this->AGEYEAR->Visible = false;
        $this->AGEMONTH->Visible = false;
        $this->AGEDAY->Visible = false;
        $this->GENDER->Visible = false;
        $this->KAL_ID->Visible = false;
        $this->CORRECTION_ID->Visible = false;
        $this->CORRECTION_BY->Visible = false;
        $this->KARYAWAN->Visible = false;
        $this->ACCOUNT_ID->Visible = false;
        $this->sell_price->setVisibility();
        $this->diskon->Visible = false;
        $this->INVOICE_ID->Visible = false;
        $this->NUMER->Visible = false;
        $this->MEASURE_ID2->Visible = false;
        $this->POTONGAN->Visible = false;
        $this->BAYAR->Visible = false;
        $this->RETUR->Visible = false;
        $this->TARIF_TYPE->Visible = false;
        $this->PPNVALUE->Visible = false;
        $this->TAGIHAN->setVisibility();
        $this->KOREKSI->Visible = false;
        $this->STATUS_OBAT->Visible = false;
        $this->SUBSIDISAT->Visible = false;
        $this->PRINTQ->Visible = false;
        $this->PRINTED_BY->Visible = false;
        $this->STOCK_AVAILABLE->Visible = false;
        $this->STATUS_TARIF->Visible = false;
        $this->CLINIC_TYPE->Visible = false;
        $this->PACKAGE_ID->Visible = false;
        $this->MODULE_ID->Visible = false;
        $this->profession->Visible = false;
        $this->THEORDER->Visible = false;
        $this->CASHIER->Visible = false;
        $this->SPPFEE->Visible = false;
        $this->SPPBILL->Visible = false;
        $this->SPPRJK->Visible = false;
        $this->SPPJMN->Visible = false;
        $this->SPPKASIR->Visible = false;
        $this->PERUJUK->Visible = false;
        $this->PERUJUKFEE->Visible = false;
        $this->modified_datesys->Visible = false;
        $this->TRANS_ID->setVisibility();
        $this->SPPBILLDATE->Visible = false;
        $this->SPPBILLUSER->Visible = false;
        $this->SPPKASIRDATE->Visible = false;
        $this->SPPKASIRUSER->Visible = false;
        $this->SPPPOLI->Visible = false;
        $this->SPPPOLIUSER->Visible = false;
        $this->SPPPOLIDATE->Visible = false;
        $this->nota_temp->Visible = false;
        $this->CLINIC_ID_TEMP->Visible = false;
        $this->NOSEP->Visible = false;
        $this->ID->Visible = false;
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
        $this->setupLookupOptions($this->EMPLOYEE_ID);

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
        $filterList = Concat($filterList, $this->amount_paid->AdvancedSearch->toJson(), ","); // Field amount_paid
        $filterList = Concat($filterList, $this->THENAME->AdvancedSearch->toJson(), ","); // Field THENAME
        $filterList = Concat($filterList, $this->THEADDRESS->AdvancedSearch->toJson(), ","); // Field THEADDRESS
        $filterList = Concat($filterList, $this->THEID->AdvancedSearch->toJson(), ","); // Field THEID
        $filterList = Concat($filterList, $this->serial_nb->AdvancedSearch->toJson(), ","); // Field serial_nb
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
        $filterList = Concat($filterList, $this->SPPFEE->AdvancedSearch->toJson(), ","); // Field SPPFEE
        $filterList = Concat($filterList, $this->SPPBILL->AdvancedSearch->toJson(), ","); // Field SPPBILL
        $filterList = Concat($filterList, $this->SPPRJK->AdvancedSearch->toJson(), ","); // Field SPPRJK
        $filterList = Concat($filterList, $this->SPPJMN->AdvancedSearch->toJson(), ","); // Field SPPJMN
        $filterList = Concat($filterList, $this->SPPKASIR->AdvancedSearch->toJson(), ","); // Field SPPKASIR
        $filterList = Concat($filterList, $this->PERUJUK->AdvancedSearch->toJson(), ","); // Field PERUJUK
        $filterList = Concat($filterList, $this->PERUJUKFEE->AdvancedSearch->toJson(), ","); // Field PERUJUKFEE
        $filterList = Concat($filterList, $this->modified_datesys->AdvancedSearch->toJson(), ","); // Field modified_datesys
        $filterList = Concat($filterList, $this->TRANS_ID->AdvancedSearch->toJson(), ","); // Field TRANS_ID
        $filterList = Concat($filterList, $this->SPPBILLDATE->AdvancedSearch->toJson(), ","); // Field SPPBILLDATE
        $filterList = Concat($filterList, $this->SPPBILLUSER->AdvancedSearch->toJson(), ","); // Field SPPBILLUSER
        $filterList = Concat($filterList, $this->SPPKASIRDATE->AdvancedSearch->toJson(), ","); // Field SPPKASIRDATE
        $filterList = Concat($filterList, $this->SPPKASIRUSER->AdvancedSearch->toJson(), ","); // Field SPPKASIRUSER
        $filterList = Concat($filterList, $this->SPPPOLI->AdvancedSearch->toJson(), ","); // Field SPPPOLI
        $filterList = Concat($filterList, $this->SPPPOLIUSER->AdvancedSearch->toJson(), ","); // Field SPPPOLIUSER
        $filterList = Concat($filterList, $this->SPPPOLIDATE->AdvancedSearch->toJson(), ","); // Field SPPPOLIDATE
        $filterList = Concat($filterList, $this->nota_temp->AdvancedSearch->toJson(), ","); // Field nota_temp
        $filterList = Concat($filterList, $this->CLINIC_ID_TEMP->AdvancedSearch->toJson(), ","); // Field CLINIC_ID_TEMP
        $filterList = Concat($filterList, $this->NOSEP->AdvancedSearch->toJson(), ","); // Field NOSEP
        $filterList = Concat($filterList, $this->ID->AdvancedSearch->toJson(), ","); // Field ID
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
            $UserProfile->setSearchFilters(CurrentUserName(), "fTREATMENT_BILLlistsrch", $filters);
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

        // Field amount_paid
        $this->amount_paid->AdvancedSearch->SearchValue = @$filter["x_amount_paid"];
        $this->amount_paid->AdvancedSearch->SearchOperator = @$filter["z_amount_paid"];
        $this->amount_paid->AdvancedSearch->SearchCondition = @$filter["v_amount_paid"];
        $this->amount_paid->AdvancedSearch->SearchValue2 = @$filter["y_amount_paid"];
        $this->amount_paid->AdvancedSearch->SearchOperator2 = @$filter["w_amount_paid"];
        $this->amount_paid->AdvancedSearch->save();

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

        // Field serial_nb
        $this->serial_nb->AdvancedSearch->SearchValue = @$filter["x_serial_nb"];
        $this->serial_nb->AdvancedSearch->SearchOperator = @$filter["z_serial_nb"];
        $this->serial_nb->AdvancedSearch->SearchCondition = @$filter["v_serial_nb"];
        $this->serial_nb->AdvancedSearch->SearchValue2 = @$filter["y_serial_nb"];
        $this->serial_nb->AdvancedSearch->SearchOperator2 = @$filter["w_serial_nb"];
        $this->serial_nb->AdvancedSearch->save();

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

        // Field SPPFEE
        $this->SPPFEE->AdvancedSearch->SearchValue = @$filter["x_SPPFEE"];
        $this->SPPFEE->AdvancedSearch->SearchOperator = @$filter["z_SPPFEE"];
        $this->SPPFEE->AdvancedSearch->SearchCondition = @$filter["v_SPPFEE"];
        $this->SPPFEE->AdvancedSearch->SearchValue2 = @$filter["y_SPPFEE"];
        $this->SPPFEE->AdvancedSearch->SearchOperator2 = @$filter["w_SPPFEE"];
        $this->SPPFEE->AdvancedSearch->save();

        // Field SPPBILL
        $this->SPPBILL->AdvancedSearch->SearchValue = @$filter["x_SPPBILL"];
        $this->SPPBILL->AdvancedSearch->SearchOperator = @$filter["z_SPPBILL"];
        $this->SPPBILL->AdvancedSearch->SearchCondition = @$filter["v_SPPBILL"];
        $this->SPPBILL->AdvancedSearch->SearchValue2 = @$filter["y_SPPBILL"];
        $this->SPPBILL->AdvancedSearch->SearchOperator2 = @$filter["w_SPPBILL"];
        $this->SPPBILL->AdvancedSearch->save();

        // Field SPPRJK
        $this->SPPRJK->AdvancedSearch->SearchValue = @$filter["x_SPPRJK"];
        $this->SPPRJK->AdvancedSearch->SearchOperator = @$filter["z_SPPRJK"];
        $this->SPPRJK->AdvancedSearch->SearchCondition = @$filter["v_SPPRJK"];
        $this->SPPRJK->AdvancedSearch->SearchValue2 = @$filter["y_SPPRJK"];
        $this->SPPRJK->AdvancedSearch->SearchOperator2 = @$filter["w_SPPRJK"];
        $this->SPPRJK->AdvancedSearch->save();

        // Field SPPJMN
        $this->SPPJMN->AdvancedSearch->SearchValue = @$filter["x_SPPJMN"];
        $this->SPPJMN->AdvancedSearch->SearchOperator = @$filter["z_SPPJMN"];
        $this->SPPJMN->AdvancedSearch->SearchCondition = @$filter["v_SPPJMN"];
        $this->SPPJMN->AdvancedSearch->SearchValue2 = @$filter["y_SPPJMN"];
        $this->SPPJMN->AdvancedSearch->SearchOperator2 = @$filter["w_SPPJMN"];
        $this->SPPJMN->AdvancedSearch->save();

        // Field SPPKASIR
        $this->SPPKASIR->AdvancedSearch->SearchValue = @$filter["x_SPPKASIR"];
        $this->SPPKASIR->AdvancedSearch->SearchOperator = @$filter["z_SPPKASIR"];
        $this->SPPKASIR->AdvancedSearch->SearchCondition = @$filter["v_SPPKASIR"];
        $this->SPPKASIR->AdvancedSearch->SearchValue2 = @$filter["y_SPPKASIR"];
        $this->SPPKASIR->AdvancedSearch->SearchOperator2 = @$filter["w_SPPKASIR"];
        $this->SPPKASIR->AdvancedSearch->save();

        // Field PERUJUK
        $this->PERUJUK->AdvancedSearch->SearchValue = @$filter["x_PERUJUK"];
        $this->PERUJUK->AdvancedSearch->SearchOperator = @$filter["z_PERUJUK"];
        $this->PERUJUK->AdvancedSearch->SearchCondition = @$filter["v_PERUJUK"];
        $this->PERUJUK->AdvancedSearch->SearchValue2 = @$filter["y_PERUJUK"];
        $this->PERUJUK->AdvancedSearch->SearchOperator2 = @$filter["w_PERUJUK"];
        $this->PERUJUK->AdvancedSearch->save();

        // Field PERUJUKFEE
        $this->PERUJUKFEE->AdvancedSearch->SearchValue = @$filter["x_PERUJUKFEE"];
        $this->PERUJUKFEE->AdvancedSearch->SearchOperator = @$filter["z_PERUJUKFEE"];
        $this->PERUJUKFEE->AdvancedSearch->SearchCondition = @$filter["v_PERUJUKFEE"];
        $this->PERUJUKFEE->AdvancedSearch->SearchValue2 = @$filter["y_PERUJUKFEE"];
        $this->PERUJUKFEE->AdvancedSearch->SearchOperator2 = @$filter["w_PERUJUKFEE"];
        $this->PERUJUKFEE->AdvancedSearch->save();

        // Field modified_datesys
        $this->modified_datesys->AdvancedSearch->SearchValue = @$filter["x_modified_datesys"];
        $this->modified_datesys->AdvancedSearch->SearchOperator = @$filter["z_modified_datesys"];
        $this->modified_datesys->AdvancedSearch->SearchCondition = @$filter["v_modified_datesys"];
        $this->modified_datesys->AdvancedSearch->SearchValue2 = @$filter["y_modified_datesys"];
        $this->modified_datesys->AdvancedSearch->SearchOperator2 = @$filter["w_modified_datesys"];
        $this->modified_datesys->AdvancedSearch->save();

        // Field TRANS_ID
        $this->TRANS_ID->AdvancedSearch->SearchValue = @$filter["x_TRANS_ID"];
        $this->TRANS_ID->AdvancedSearch->SearchOperator = @$filter["z_TRANS_ID"];
        $this->TRANS_ID->AdvancedSearch->SearchCondition = @$filter["v_TRANS_ID"];
        $this->TRANS_ID->AdvancedSearch->SearchValue2 = @$filter["y_TRANS_ID"];
        $this->TRANS_ID->AdvancedSearch->SearchOperator2 = @$filter["w_TRANS_ID"];
        $this->TRANS_ID->AdvancedSearch->save();

        // Field SPPBILLDATE
        $this->SPPBILLDATE->AdvancedSearch->SearchValue = @$filter["x_SPPBILLDATE"];
        $this->SPPBILLDATE->AdvancedSearch->SearchOperator = @$filter["z_SPPBILLDATE"];
        $this->SPPBILLDATE->AdvancedSearch->SearchCondition = @$filter["v_SPPBILLDATE"];
        $this->SPPBILLDATE->AdvancedSearch->SearchValue2 = @$filter["y_SPPBILLDATE"];
        $this->SPPBILLDATE->AdvancedSearch->SearchOperator2 = @$filter["w_SPPBILLDATE"];
        $this->SPPBILLDATE->AdvancedSearch->save();

        // Field SPPBILLUSER
        $this->SPPBILLUSER->AdvancedSearch->SearchValue = @$filter["x_SPPBILLUSER"];
        $this->SPPBILLUSER->AdvancedSearch->SearchOperator = @$filter["z_SPPBILLUSER"];
        $this->SPPBILLUSER->AdvancedSearch->SearchCondition = @$filter["v_SPPBILLUSER"];
        $this->SPPBILLUSER->AdvancedSearch->SearchValue2 = @$filter["y_SPPBILLUSER"];
        $this->SPPBILLUSER->AdvancedSearch->SearchOperator2 = @$filter["w_SPPBILLUSER"];
        $this->SPPBILLUSER->AdvancedSearch->save();

        // Field SPPKASIRDATE
        $this->SPPKASIRDATE->AdvancedSearch->SearchValue = @$filter["x_SPPKASIRDATE"];
        $this->SPPKASIRDATE->AdvancedSearch->SearchOperator = @$filter["z_SPPKASIRDATE"];
        $this->SPPKASIRDATE->AdvancedSearch->SearchCondition = @$filter["v_SPPKASIRDATE"];
        $this->SPPKASIRDATE->AdvancedSearch->SearchValue2 = @$filter["y_SPPKASIRDATE"];
        $this->SPPKASIRDATE->AdvancedSearch->SearchOperator2 = @$filter["w_SPPKASIRDATE"];
        $this->SPPKASIRDATE->AdvancedSearch->save();

        // Field SPPKASIRUSER
        $this->SPPKASIRUSER->AdvancedSearch->SearchValue = @$filter["x_SPPKASIRUSER"];
        $this->SPPKASIRUSER->AdvancedSearch->SearchOperator = @$filter["z_SPPKASIRUSER"];
        $this->SPPKASIRUSER->AdvancedSearch->SearchCondition = @$filter["v_SPPKASIRUSER"];
        $this->SPPKASIRUSER->AdvancedSearch->SearchValue2 = @$filter["y_SPPKASIRUSER"];
        $this->SPPKASIRUSER->AdvancedSearch->SearchOperator2 = @$filter["w_SPPKASIRUSER"];
        $this->SPPKASIRUSER->AdvancedSearch->save();

        // Field SPPPOLI
        $this->SPPPOLI->AdvancedSearch->SearchValue = @$filter["x_SPPPOLI"];
        $this->SPPPOLI->AdvancedSearch->SearchOperator = @$filter["z_SPPPOLI"];
        $this->SPPPOLI->AdvancedSearch->SearchCondition = @$filter["v_SPPPOLI"];
        $this->SPPPOLI->AdvancedSearch->SearchValue2 = @$filter["y_SPPPOLI"];
        $this->SPPPOLI->AdvancedSearch->SearchOperator2 = @$filter["w_SPPPOLI"];
        $this->SPPPOLI->AdvancedSearch->save();

        // Field SPPPOLIUSER
        $this->SPPPOLIUSER->AdvancedSearch->SearchValue = @$filter["x_SPPPOLIUSER"];
        $this->SPPPOLIUSER->AdvancedSearch->SearchOperator = @$filter["z_SPPPOLIUSER"];
        $this->SPPPOLIUSER->AdvancedSearch->SearchCondition = @$filter["v_SPPPOLIUSER"];
        $this->SPPPOLIUSER->AdvancedSearch->SearchValue2 = @$filter["y_SPPPOLIUSER"];
        $this->SPPPOLIUSER->AdvancedSearch->SearchOperator2 = @$filter["w_SPPPOLIUSER"];
        $this->SPPPOLIUSER->AdvancedSearch->save();

        // Field SPPPOLIDATE
        $this->SPPPOLIDATE->AdvancedSearch->SearchValue = @$filter["x_SPPPOLIDATE"];
        $this->SPPPOLIDATE->AdvancedSearch->SearchOperator = @$filter["z_SPPPOLIDATE"];
        $this->SPPPOLIDATE->AdvancedSearch->SearchCondition = @$filter["v_SPPPOLIDATE"];
        $this->SPPPOLIDATE->AdvancedSearch->SearchValue2 = @$filter["y_SPPPOLIDATE"];
        $this->SPPPOLIDATE->AdvancedSearch->SearchOperator2 = @$filter["w_SPPPOLIDATE"];
        $this->SPPPOLIDATE->AdvancedSearch->save();

        // Field nota_temp
        $this->nota_temp->AdvancedSearch->SearchValue = @$filter["x_nota_temp"];
        $this->nota_temp->AdvancedSearch->SearchOperator = @$filter["z_nota_temp"];
        $this->nota_temp->AdvancedSearch->SearchCondition = @$filter["v_nota_temp"];
        $this->nota_temp->AdvancedSearch->SearchValue2 = @$filter["y_nota_temp"];
        $this->nota_temp->AdvancedSearch->SearchOperator2 = @$filter["w_nota_temp"];
        $this->nota_temp->AdvancedSearch->save();

        // Field CLINIC_ID_TEMP
        $this->CLINIC_ID_TEMP->AdvancedSearch->SearchValue = @$filter["x_CLINIC_ID_TEMP"];
        $this->CLINIC_ID_TEMP->AdvancedSearch->SearchOperator = @$filter["z_CLINIC_ID_TEMP"];
        $this->CLINIC_ID_TEMP->AdvancedSearch->SearchCondition = @$filter["v_CLINIC_ID_TEMP"];
        $this->CLINIC_ID_TEMP->AdvancedSearch->SearchValue2 = @$filter["y_CLINIC_ID_TEMP"];
        $this->CLINIC_ID_TEMP->AdvancedSearch->SearchOperator2 = @$filter["w_CLINIC_ID_TEMP"];
        $this->CLINIC_ID_TEMP->AdvancedSearch->save();

        // Field NOSEP
        $this->NOSEP->AdvancedSearch->SearchValue = @$filter["x_NOSEP"];
        $this->NOSEP->AdvancedSearch->SearchOperator = @$filter["z_NOSEP"];
        $this->NOSEP->AdvancedSearch->SearchCondition = @$filter["v_NOSEP"];
        $this->NOSEP->AdvancedSearch->SearchValue2 = @$filter["y_NOSEP"];
        $this->NOSEP->AdvancedSearch->SearchOperator2 = @$filter["w_NOSEP"];
        $this->NOSEP->AdvancedSearch->save();

        // Field ID
        $this->ID->AdvancedSearch->SearchValue = @$filter["x_ID"];
        $this->ID->AdvancedSearch->SearchOperator = @$filter["z_ID"];
        $this->ID->AdvancedSearch->SearchCondition = @$filter["v_ID"];
        $this->ID->AdvancedSearch->SearchValue2 = @$filter["y_ID"];
        $this->ID->AdvancedSearch->SearchOperator2 = @$filter["w_ID"];
        $this->ID->AdvancedSearch->save();
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
        $this->buildSearchSql($where, $this->ORG_UNIT_CODE, $default, false); // ORG_UNIT_CODE
        $this->buildSearchSql($where, $this->BILL_ID, $default, false); // BILL_ID
        $this->buildSearchSql($where, $this->NO_REGISTRATION, $default, false); // NO_REGISTRATION
        $this->buildSearchSql($where, $this->VISIT_ID, $default, false); // VISIT_ID
        $this->buildSearchSql($where, $this->TARIF_ID, $default, false); // TARIF_ID
        $this->buildSearchSql($where, $this->CLASS_ID, $default, false); // CLASS_ID
        $this->buildSearchSql($where, $this->CLINIC_ID, $default, false); // CLINIC_ID
        $this->buildSearchSql($where, $this->CLINIC_ID_FROM, $default, false); // CLINIC_ID_FROM
        $this->buildSearchSql($where, $this->TREATMENT, $default, false); // TREATMENT
        $this->buildSearchSql($where, $this->TREAT_DATE, $default, false); // TREAT_DATE
        $this->buildSearchSql($where, $this->AMOUNT, $default, false); // AMOUNT
        $this->buildSearchSql($where, $this->QUANTITY, $default, false); // QUANTITY
        $this->buildSearchSql($where, $this->MEASURE_ID, $default, false); // MEASURE_ID
        $this->buildSearchSql($where, $this->POKOK_JUAL, $default, false); // POKOK_JUAL
        $this->buildSearchSql($where, $this->PPN, $default, false); // PPN
        $this->buildSearchSql($where, $this->MARGIN, $default, false); // MARGIN
        $this->buildSearchSql($where, $this->SUBSIDI, $default, false); // SUBSIDI
        $this->buildSearchSql($where, $this->EMBALACE, $default, false); // EMBALACE
        $this->buildSearchSql($where, $this->PROFESI, $default, false); // PROFESI
        $this->buildSearchSql($where, $this->DISCOUNT, $default, false); // DISCOUNT
        $this->buildSearchSql($where, $this->PAY_METHOD_ID, $default, false); // PAY_METHOD_ID
        $this->buildSearchSql($where, $this->PAYMENT_DATE, $default, false); // PAYMENT_DATE
        $this->buildSearchSql($where, $this->ISLUNAS, $default, true); // ISLUNAS
        $this->buildSearchSql($where, $this->DUEDATE_ANGSURAN, $default, false); // DUEDATE_ANGSURAN
        $this->buildSearchSql($where, $this->DESCRIPTION, $default, false); // DESCRIPTION
        $this->buildSearchSql($where, $this->KUITANSI_ID, $default, false); // KUITANSI_ID
        $this->buildSearchSql($where, $this->NOTA_NO, $default, false); // NOTA_NO
        $this->buildSearchSql($where, $this->ISCETAK, $default, false); // ISCETAK
        $this->buildSearchSql($where, $this->PRINT_DATE, $default, false); // PRINT_DATE
        $this->buildSearchSql($where, $this->RESEP_NO, $default, false); // RESEP_NO
        $this->buildSearchSql($where, $this->RESEP_KE, $default, false); // RESEP_KE
        $this->buildSearchSql($where, $this->DOSE, $default, false); // DOSE
        $this->buildSearchSql($where, $this->ORIG_DOSE, $default, false); // ORIG_DOSE
        $this->buildSearchSql($where, $this->DOSE_PRESC, $default, false); // DOSE_PRESC
        $this->buildSearchSql($where, $this->ITER, $default, false); // ITER
        $this->buildSearchSql($where, $this->ITER_KE, $default, false); // ITER_KE
        $this->buildSearchSql($where, $this->SOLD_STATUS, $default, false); // SOLD_STATUS
        $this->buildSearchSql($where, $this->RACIKAN, $default, false); // RACIKAN
        $this->buildSearchSql($where, $this->CLASS_ROOM_ID, $default, false); // CLASS_ROOM_ID
        $this->buildSearchSql($where, $this->KELUAR_ID, $default, false); // KELUAR_ID
        $this->buildSearchSql($where, $this->BED_ID, $default, false); // BED_ID
        $this->buildSearchSql($where, $this->PERDA_ID, $default, false); // PERDA_ID
        $this->buildSearchSql($where, $this->EMPLOYEE_ID, $default, false); // EMPLOYEE_ID
        $this->buildSearchSql($where, $this->DESCRIPTION2, $default, false); // DESCRIPTION2
        $this->buildSearchSql($where, $this->MODIFIED_BY, $default, false); // MODIFIED_BY
        $this->buildSearchSql($where, $this->MODIFIED_DATE, $default, false); // MODIFIED_DATE
        $this->buildSearchSql($where, $this->MODIFIED_FROM, $default, false); // MODIFIED_FROM
        $this->buildSearchSql($where, $this->BRAND_ID, $default, false); // BRAND_ID
        $this->buildSearchSql($where, $this->DOCTOR, $default, false); // DOCTOR
        $this->buildSearchSql($where, $this->JML_BKS, $default, false); // JML_BKS
        $this->buildSearchSql($where, $this->EXIT_DATE, $default, false); // EXIT_DATE
        $this->buildSearchSql($where, $this->FA_V, $default, false); // FA_V
        $this->buildSearchSql($where, $this->TASK_ID, $default, false); // TASK_ID
        $this->buildSearchSql($where, $this->EMPLOYEE_ID_FROM, $default, false); // EMPLOYEE_ID_FROM
        $this->buildSearchSql($where, $this->DOCTOR_FROM, $default, false); // DOCTOR_FROM
        $this->buildSearchSql($where, $this->status_pasien_id, $default, false); // status_pasien_id
        $this->buildSearchSql($where, $this->amount_paid, $default, false); // amount_paid
        $this->buildSearchSql($where, $this->THENAME, $default, false); // THENAME
        $this->buildSearchSql($where, $this->THEADDRESS, $default, false); // THEADDRESS
        $this->buildSearchSql($where, $this->THEID, $default, false); // THEID
        $this->buildSearchSql($where, $this->serial_nb, $default, false); // serial_nb
        $this->buildSearchSql($where, $this->TREATMENT_PLAFOND, $default, false); // TREATMENT_PLAFOND
        $this->buildSearchSql($where, $this->AMOUNT_PLAFOND, $default, false); // AMOUNT_PLAFOND
        $this->buildSearchSql($where, $this->AMOUNT_PAID_PLAFOND, $default, false); // AMOUNT_PAID_PLAFOND
        $this->buildSearchSql($where, $this->CLASS_ID_PLAFOND, $default, false); // CLASS_ID_PLAFOND
        $this->buildSearchSql($where, $this->PAYOR_ID, $default, false); // PAYOR_ID
        $this->buildSearchSql($where, $this->PEMBULATAN, $default, false); // PEMBULATAN
        $this->buildSearchSql($where, $this->ISRJ, $default, true); // ISRJ
        $this->buildSearchSql($where, $this->AGEYEAR, $default, false); // AGEYEAR
        $this->buildSearchSql($where, $this->AGEMONTH, $default, false); // AGEMONTH
        $this->buildSearchSql($where, $this->AGEDAY, $default, false); // AGEDAY
        $this->buildSearchSql($where, $this->GENDER, $default, false); // GENDER
        $this->buildSearchSql($where, $this->KAL_ID, $default, false); // KAL_ID
        $this->buildSearchSql($where, $this->CORRECTION_ID, $default, false); // CORRECTION_ID
        $this->buildSearchSql($where, $this->CORRECTION_BY, $default, false); // CORRECTION_BY
        $this->buildSearchSql($where, $this->KARYAWAN, $default, false); // KARYAWAN
        $this->buildSearchSql($where, $this->ACCOUNT_ID, $default, false); // ACCOUNT_ID
        $this->buildSearchSql($where, $this->sell_price, $default, false); // sell_price
        $this->buildSearchSql($where, $this->diskon, $default, false); // diskon
        $this->buildSearchSql($where, $this->INVOICE_ID, $default, false); // INVOICE_ID
        $this->buildSearchSql($where, $this->NUMER, $default, false); // NUMER
        $this->buildSearchSql($where, $this->MEASURE_ID2, $default, false); // MEASURE_ID2
        $this->buildSearchSql($where, $this->POTONGAN, $default, false); // POTONGAN
        $this->buildSearchSql($where, $this->BAYAR, $default, false); // BAYAR
        $this->buildSearchSql($where, $this->RETUR, $default, false); // RETUR
        $this->buildSearchSql($where, $this->TARIF_TYPE, $default, false); // TARIF_TYPE
        $this->buildSearchSql($where, $this->PPNVALUE, $default, false); // PPNVALUE
        $this->buildSearchSql($where, $this->TAGIHAN, $default, false); // TAGIHAN
        $this->buildSearchSql($where, $this->KOREKSI, $default, false); // KOREKSI
        $this->buildSearchSql($where, $this->STATUS_OBAT, $default, false); // STATUS_OBAT
        $this->buildSearchSql($where, $this->SUBSIDISAT, $default, false); // SUBSIDISAT
        $this->buildSearchSql($where, $this->PRINTQ, $default, false); // PRINTQ
        $this->buildSearchSql($where, $this->PRINTED_BY, $default, false); // PRINTED_BY
        $this->buildSearchSql($where, $this->STOCK_AVAILABLE, $default, false); // STOCK_AVAILABLE
        $this->buildSearchSql($where, $this->STATUS_TARIF, $default, false); // STATUS_TARIF
        $this->buildSearchSql($where, $this->CLINIC_TYPE, $default, false); // CLINIC_TYPE
        $this->buildSearchSql($where, $this->PACKAGE_ID, $default, false); // PACKAGE_ID
        $this->buildSearchSql($where, $this->MODULE_ID, $default, false); // MODULE_ID
        $this->buildSearchSql($where, $this->profession, $default, false); // profession
        $this->buildSearchSql($where, $this->THEORDER, $default, false); // THEORDER
        $this->buildSearchSql($where, $this->CASHIER, $default, false); // CASHIER
        $this->buildSearchSql($where, $this->SPPFEE, $default, false); // SPPFEE
        $this->buildSearchSql($where, $this->SPPBILL, $default, false); // SPPBILL
        $this->buildSearchSql($where, $this->SPPRJK, $default, false); // SPPRJK
        $this->buildSearchSql($where, $this->SPPJMN, $default, false); // SPPJMN
        $this->buildSearchSql($where, $this->SPPKASIR, $default, false); // SPPKASIR
        $this->buildSearchSql($where, $this->PERUJUK, $default, false); // PERUJUK
        $this->buildSearchSql($where, $this->PERUJUKFEE, $default, false); // PERUJUKFEE
        $this->buildSearchSql($where, $this->modified_datesys, $default, false); // modified_datesys
        $this->buildSearchSql($where, $this->TRANS_ID, $default, false); // TRANS_ID
        $this->buildSearchSql($where, $this->SPPBILLDATE, $default, false); // SPPBILLDATE
        $this->buildSearchSql($where, $this->SPPBILLUSER, $default, false); // SPPBILLUSER
        $this->buildSearchSql($where, $this->SPPKASIRDATE, $default, false); // SPPKASIRDATE
        $this->buildSearchSql($where, $this->SPPKASIRUSER, $default, false); // SPPKASIRUSER
        $this->buildSearchSql($where, $this->SPPPOLI, $default, false); // SPPPOLI
        $this->buildSearchSql($where, $this->SPPPOLIUSER, $default, false); // SPPPOLIUSER
        $this->buildSearchSql($where, $this->SPPPOLIDATE, $default, false); // SPPPOLIDATE
        $this->buildSearchSql($where, $this->nota_temp, $default, false); // nota_temp
        $this->buildSearchSql($where, $this->CLINIC_ID_TEMP, $default, false); // CLINIC_ID_TEMP
        $this->buildSearchSql($where, $this->NOSEP, $default, false); // NOSEP
        $this->buildSearchSql($where, $this->ID, $default, false); // ID

        // Set up search parm
        if (!$default && $where != "" && in_array($this->Command, ["", "reset", "resetall"])) {
            $this->Command = "search";
        }
        if (!$default && $this->Command == "search") {
            $this->ORG_UNIT_CODE->AdvancedSearch->save(); // ORG_UNIT_CODE
            $this->BILL_ID->AdvancedSearch->save(); // BILL_ID
            $this->NO_REGISTRATION->AdvancedSearch->save(); // NO_REGISTRATION
            $this->VISIT_ID->AdvancedSearch->save(); // VISIT_ID
            $this->TARIF_ID->AdvancedSearch->save(); // TARIF_ID
            $this->CLASS_ID->AdvancedSearch->save(); // CLASS_ID
            $this->CLINIC_ID->AdvancedSearch->save(); // CLINIC_ID
            $this->CLINIC_ID_FROM->AdvancedSearch->save(); // CLINIC_ID_FROM
            $this->TREATMENT->AdvancedSearch->save(); // TREATMENT
            $this->TREAT_DATE->AdvancedSearch->save(); // TREAT_DATE
            $this->AMOUNT->AdvancedSearch->save(); // AMOUNT
            $this->QUANTITY->AdvancedSearch->save(); // QUANTITY
            $this->MEASURE_ID->AdvancedSearch->save(); // MEASURE_ID
            $this->POKOK_JUAL->AdvancedSearch->save(); // POKOK_JUAL
            $this->PPN->AdvancedSearch->save(); // PPN
            $this->MARGIN->AdvancedSearch->save(); // MARGIN
            $this->SUBSIDI->AdvancedSearch->save(); // SUBSIDI
            $this->EMBALACE->AdvancedSearch->save(); // EMBALACE
            $this->PROFESI->AdvancedSearch->save(); // PROFESI
            $this->DISCOUNT->AdvancedSearch->save(); // DISCOUNT
            $this->PAY_METHOD_ID->AdvancedSearch->save(); // PAY_METHOD_ID
            $this->PAYMENT_DATE->AdvancedSearch->save(); // PAYMENT_DATE
            $this->ISLUNAS->AdvancedSearch->save(); // ISLUNAS
            $this->DUEDATE_ANGSURAN->AdvancedSearch->save(); // DUEDATE_ANGSURAN
            $this->DESCRIPTION->AdvancedSearch->save(); // DESCRIPTION
            $this->KUITANSI_ID->AdvancedSearch->save(); // KUITANSI_ID
            $this->NOTA_NO->AdvancedSearch->save(); // NOTA_NO
            $this->ISCETAK->AdvancedSearch->save(); // ISCETAK
            $this->PRINT_DATE->AdvancedSearch->save(); // PRINT_DATE
            $this->RESEP_NO->AdvancedSearch->save(); // RESEP_NO
            $this->RESEP_KE->AdvancedSearch->save(); // RESEP_KE
            $this->DOSE->AdvancedSearch->save(); // DOSE
            $this->ORIG_DOSE->AdvancedSearch->save(); // ORIG_DOSE
            $this->DOSE_PRESC->AdvancedSearch->save(); // DOSE_PRESC
            $this->ITER->AdvancedSearch->save(); // ITER
            $this->ITER_KE->AdvancedSearch->save(); // ITER_KE
            $this->SOLD_STATUS->AdvancedSearch->save(); // SOLD_STATUS
            $this->RACIKAN->AdvancedSearch->save(); // RACIKAN
            $this->CLASS_ROOM_ID->AdvancedSearch->save(); // CLASS_ROOM_ID
            $this->KELUAR_ID->AdvancedSearch->save(); // KELUAR_ID
            $this->BED_ID->AdvancedSearch->save(); // BED_ID
            $this->PERDA_ID->AdvancedSearch->save(); // PERDA_ID
            $this->EMPLOYEE_ID->AdvancedSearch->save(); // EMPLOYEE_ID
            $this->DESCRIPTION2->AdvancedSearch->save(); // DESCRIPTION2
            $this->MODIFIED_BY->AdvancedSearch->save(); // MODIFIED_BY
            $this->MODIFIED_DATE->AdvancedSearch->save(); // MODIFIED_DATE
            $this->MODIFIED_FROM->AdvancedSearch->save(); // MODIFIED_FROM
            $this->BRAND_ID->AdvancedSearch->save(); // BRAND_ID
            $this->DOCTOR->AdvancedSearch->save(); // DOCTOR
            $this->JML_BKS->AdvancedSearch->save(); // JML_BKS
            $this->EXIT_DATE->AdvancedSearch->save(); // EXIT_DATE
            $this->FA_V->AdvancedSearch->save(); // FA_V
            $this->TASK_ID->AdvancedSearch->save(); // TASK_ID
            $this->EMPLOYEE_ID_FROM->AdvancedSearch->save(); // EMPLOYEE_ID_FROM
            $this->DOCTOR_FROM->AdvancedSearch->save(); // DOCTOR_FROM
            $this->status_pasien_id->AdvancedSearch->save(); // status_pasien_id
            $this->amount_paid->AdvancedSearch->save(); // amount_paid
            $this->THENAME->AdvancedSearch->save(); // THENAME
            $this->THEADDRESS->AdvancedSearch->save(); // THEADDRESS
            $this->THEID->AdvancedSearch->save(); // THEID
            $this->serial_nb->AdvancedSearch->save(); // serial_nb
            $this->TREATMENT_PLAFOND->AdvancedSearch->save(); // TREATMENT_PLAFOND
            $this->AMOUNT_PLAFOND->AdvancedSearch->save(); // AMOUNT_PLAFOND
            $this->AMOUNT_PAID_PLAFOND->AdvancedSearch->save(); // AMOUNT_PAID_PLAFOND
            $this->CLASS_ID_PLAFOND->AdvancedSearch->save(); // CLASS_ID_PLAFOND
            $this->PAYOR_ID->AdvancedSearch->save(); // PAYOR_ID
            $this->PEMBULATAN->AdvancedSearch->save(); // PEMBULATAN
            $this->ISRJ->AdvancedSearch->save(); // ISRJ
            $this->AGEYEAR->AdvancedSearch->save(); // AGEYEAR
            $this->AGEMONTH->AdvancedSearch->save(); // AGEMONTH
            $this->AGEDAY->AdvancedSearch->save(); // AGEDAY
            $this->GENDER->AdvancedSearch->save(); // GENDER
            $this->KAL_ID->AdvancedSearch->save(); // KAL_ID
            $this->CORRECTION_ID->AdvancedSearch->save(); // CORRECTION_ID
            $this->CORRECTION_BY->AdvancedSearch->save(); // CORRECTION_BY
            $this->KARYAWAN->AdvancedSearch->save(); // KARYAWAN
            $this->ACCOUNT_ID->AdvancedSearch->save(); // ACCOUNT_ID
            $this->sell_price->AdvancedSearch->save(); // sell_price
            $this->diskon->AdvancedSearch->save(); // diskon
            $this->INVOICE_ID->AdvancedSearch->save(); // INVOICE_ID
            $this->NUMER->AdvancedSearch->save(); // NUMER
            $this->MEASURE_ID2->AdvancedSearch->save(); // MEASURE_ID2
            $this->POTONGAN->AdvancedSearch->save(); // POTONGAN
            $this->BAYAR->AdvancedSearch->save(); // BAYAR
            $this->RETUR->AdvancedSearch->save(); // RETUR
            $this->TARIF_TYPE->AdvancedSearch->save(); // TARIF_TYPE
            $this->PPNVALUE->AdvancedSearch->save(); // PPNVALUE
            $this->TAGIHAN->AdvancedSearch->save(); // TAGIHAN
            $this->KOREKSI->AdvancedSearch->save(); // KOREKSI
            $this->STATUS_OBAT->AdvancedSearch->save(); // STATUS_OBAT
            $this->SUBSIDISAT->AdvancedSearch->save(); // SUBSIDISAT
            $this->PRINTQ->AdvancedSearch->save(); // PRINTQ
            $this->PRINTED_BY->AdvancedSearch->save(); // PRINTED_BY
            $this->STOCK_AVAILABLE->AdvancedSearch->save(); // STOCK_AVAILABLE
            $this->STATUS_TARIF->AdvancedSearch->save(); // STATUS_TARIF
            $this->CLINIC_TYPE->AdvancedSearch->save(); // CLINIC_TYPE
            $this->PACKAGE_ID->AdvancedSearch->save(); // PACKAGE_ID
            $this->MODULE_ID->AdvancedSearch->save(); // MODULE_ID
            $this->profession->AdvancedSearch->save(); // profession
            $this->THEORDER->AdvancedSearch->save(); // THEORDER
            $this->CASHIER->AdvancedSearch->save(); // CASHIER
            $this->SPPFEE->AdvancedSearch->save(); // SPPFEE
            $this->SPPBILL->AdvancedSearch->save(); // SPPBILL
            $this->SPPRJK->AdvancedSearch->save(); // SPPRJK
            $this->SPPJMN->AdvancedSearch->save(); // SPPJMN
            $this->SPPKASIR->AdvancedSearch->save(); // SPPKASIR
            $this->PERUJUK->AdvancedSearch->save(); // PERUJUK
            $this->PERUJUKFEE->AdvancedSearch->save(); // PERUJUKFEE
            $this->modified_datesys->AdvancedSearch->save(); // modified_datesys
            $this->TRANS_ID->AdvancedSearch->save(); // TRANS_ID
            $this->SPPBILLDATE->AdvancedSearch->save(); // SPPBILLDATE
            $this->SPPBILLUSER->AdvancedSearch->save(); // SPPBILLUSER
            $this->SPPKASIRDATE->AdvancedSearch->save(); // SPPKASIRDATE
            $this->SPPKASIRUSER->AdvancedSearch->save(); // SPPKASIRUSER
            $this->SPPPOLI->AdvancedSearch->save(); // SPPPOLI
            $this->SPPPOLIUSER->AdvancedSearch->save(); // SPPPOLIUSER
            $this->SPPPOLIDATE->AdvancedSearch->save(); // SPPPOLIDATE
            $this->nota_temp->AdvancedSearch->save(); // nota_temp
            $this->CLINIC_ID_TEMP->AdvancedSearch->save(); // CLINIC_ID_TEMP
            $this->NOSEP->AdvancedSearch->save(); // NOSEP
            $this->ID->AdvancedSearch->save(); // ID
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
        $this->buildBasicSearchSql($where, $this->TREATMENT, $arKeywords, $type);
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
        if ($this->ORG_UNIT_CODE->AdvancedSearch->issetSession()) {
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
        if ($this->AMOUNT->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->QUANTITY->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->MEASURE_ID->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->POKOK_JUAL->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->PPN->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->MARGIN->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->SUBSIDI->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->EMBALACE->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->PROFESI->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->DISCOUNT->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->PAY_METHOD_ID->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->PAYMENT_DATE->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->ISLUNAS->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->DUEDATE_ANGSURAN->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->DESCRIPTION->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->KUITANSI_ID->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->NOTA_NO->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->ISCETAK->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->PRINT_DATE->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->RESEP_NO->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->RESEP_KE->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->DOSE->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->ORIG_DOSE->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->DOSE_PRESC->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->ITER->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->ITER_KE->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->SOLD_STATUS->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->RACIKAN->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->CLASS_ROOM_ID->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->KELUAR_ID->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->BED_ID->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->PERDA_ID->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->EMPLOYEE_ID->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->DESCRIPTION2->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->MODIFIED_BY->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->MODIFIED_DATE->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->MODIFIED_FROM->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->BRAND_ID->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->DOCTOR->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->JML_BKS->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->EXIT_DATE->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->FA_V->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->TASK_ID->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->EMPLOYEE_ID_FROM->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->DOCTOR_FROM->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->status_pasien_id->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->amount_paid->AdvancedSearch->issetSession()) {
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
        if ($this->serial_nb->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->TREATMENT_PLAFOND->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->AMOUNT_PLAFOND->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->AMOUNT_PAID_PLAFOND->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->CLASS_ID_PLAFOND->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->PAYOR_ID->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->PEMBULATAN->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->ISRJ->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->AGEYEAR->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->AGEMONTH->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->AGEDAY->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->GENDER->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->KAL_ID->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->CORRECTION_ID->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->CORRECTION_BY->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->KARYAWAN->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->ACCOUNT_ID->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->sell_price->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->diskon->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->INVOICE_ID->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->NUMER->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->MEASURE_ID2->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->POTONGAN->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->BAYAR->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->RETUR->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->TARIF_TYPE->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->PPNVALUE->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->TAGIHAN->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->KOREKSI->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->STATUS_OBAT->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->SUBSIDISAT->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->PRINTQ->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->PRINTED_BY->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->STOCK_AVAILABLE->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->STATUS_TARIF->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->CLINIC_TYPE->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->PACKAGE_ID->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->MODULE_ID->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->profession->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->THEORDER->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->CASHIER->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->SPPFEE->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->SPPBILL->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->SPPRJK->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->SPPJMN->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->SPPKASIR->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->PERUJUK->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->PERUJUKFEE->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->modified_datesys->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->TRANS_ID->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->SPPBILLDATE->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->SPPBILLUSER->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->SPPKASIRDATE->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->SPPKASIRUSER->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->SPPPOLI->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->SPPPOLIUSER->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->SPPPOLIDATE->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->nota_temp->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->CLINIC_ID_TEMP->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->NOSEP->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->ID->AdvancedSearch->issetSession()) {
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
                $this->ORG_UNIT_CODE->AdvancedSearch->unsetSession();
                $this->BILL_ID->AdvancedSearch->unsetSession();
                $this->NO_REGISTRATION->AdvancedSearch->unsetSession();
                $this->VISIT_ID->AdvancedSearch->unsetSession();
                $this->TARIF_ID->AdvancedSearch->unsetSession();
                $this->CLASS_ID->AdvancedSearch->unsetSession();
                $this->CLINIC_ID->AdvancedSearch->unsetSession();
                $this->CLINIC_ID_FROM->AdvancedSearch->unsetSession();
                $this->TREATMENT->AdvancedSearch->unsetSession();
                $this->TREAT_DATE->AdvancedSearch->unsetSession();
                $this->AMOUNT->AdvancedSearch->unsetSession();
                $this->QUANTITY->AdvancedSearch->unsetSession();
                $this->MEASURE_ID->AdvancedSearch->unsetSession();
                $this->POKOK_JUAL->AdvancedSearch->unsetSession();
                $this->PPN->AdvancedSearch->unsetSession();
                $this->MARGIN->AdvancedSearch->unsetSession();
                $this->SUBSIDI->AdvancedSearch->unsetSession();
                $this->EMBALACE->AdvancedSearch->unsetSession();
                $this->PROFESI->AdvancedSearch->unsetSession();
                $this->DISCOUNT->AdvancedSearch->unsetSession();
                $this->PAY_METHOD_ID->AdvancedSearch->unsetSession();
                $this->PAYMENT_DATE->AdvancedSearch->unsetSession();
                $this->ISLUNAS->AdvancedSearch->unsetSession();
                $this->DUEDATE_ANGSURAN->AdvancedSearch->unsetSession();
                $this->DESCRIPTION->AdvancedSearch->unsetSession();
                $this->KUITANSI_ID->AdvancedSearch->unsetSession();
                $this->NOTA_NO->AdvancedSearch->unsetSession();
                $this->ISCETAK->AdvancedSearch->unsetSession();
                $this->PRINT_DATE->AdvancedSearch->unsetSession();
                $this->RESEP_NO->AdvancedSearch->unsetSession();
                $this->RESEP_KE->AdvancedSearch->unsetSession();
                $this->DOSE->AdvancedSearch->unsetSession();
                $this->ORIG_DOSE->AdvancedSearch->unsetSession();
                $this->DOSE_PRESC->AdvancedSearch->unsetSession();
                $this->ITER->AdvancedSearch->unsetSession();
                $this->ITER_KE->AdvancedSearch->unsetSession();
                $this->SOLD_STATUS->AdvancedSearch->unsetSession();
                $this->RACIKAN->AdvancedSearch->unsetSession();
                $this->CLASS_ROOM_ID->AdvancedSearch->unsetSession();
                $this->KELUAR_ID->AdvancedSearch->unsetSession();
                $this->BED_ID->AdvancedSearch->unsetSession();
                $this->PERDA_ID->AdvancedSearch->unsetSession();
                $this->EMPLOYEE_ID->AdvancedSearch->unsetSession();
                $this->DESCRIPTION2->AdvancedSearch->unsetSession();
                $this->MODIFIED_BY->AdvancedSearch->unsetSession();
                $this->MODIFIED_DATE->AdvancedSearch->unsetSession();
                $this->MODIFIED_FROM->AdvancedSearch->unsetSession();
                $this->BRAND_ID->AdvancedSearch->unsetSession();
                $this->DOCTOR->AdvancedSearch->unsetSession();
                $this->JML_BKS->AdvancedSearch->unsetSession();
                $this->EXIT_DATE->AdvancedSearch->unsetSession();
                $this->FA_V->AdvancedSearch->unsetSession();
                $this->TASK_ID->AdvancedSearch->unsetSession();
                $this->EMPLOYEE_ID_FROM->AdvancedSearch->unsetSession();
                $this->DOCTOR_FROM->AdvancedSearch->unsetSession();
                $this->status_pasien_id->AdvancedSearch->unsetSession();
                $this->amount_paid->AdvancedSearch->unsetSession();
                $this->THENAME->AdvancedSearch->unsetSession();
                $this->THEADDRESS->AdvancedSearch->unsetSession();
                $this->THEID->AdvancedSearch->unsetSession();
                $this->serial_nb->AdvancedSearch->unsetSession();
                $this->TREATMENT_PLAFOND->AdvancedSearch->unsetSession();
                $this->AMOUNT_PLAFOND->AdvancedSearch->unsetSession();
                $this->AMOUNT_PAID_PLAFOND->AdvancedSearch->unsetSession();
                $this->CLASS_ID_PLAFOND->AdvancedSearch->unsetSession();
                $this->PAYOR_ID->AdvancedSearch->unsetSession();
                $this->PEMBULATAN->AdvancedSearch->unsetSession();
                $this->ISRJ->AdvancedSearch->unsetSession();
                $this->AGEYEAR->AdvancedSearch->unsetSession();
                $this->AGEMONTH->AdvancedSearch->unsetSession();
                $this->AGEDAY->AdvancedSearch->unsetSession();
                $this->GENDER->AdvancedSearch->unsetSession();
                $this->KAL_ID->AdvancedSearch->unsetSession();
                $this->CORRECTION_ID->AdvancedSearch->unsetSession();
                $this->CORRECTION_BY->AdvancedSearch->unsetSession();
                $this->KARYAWAN->AdvancedSearch->unsetSession();
                $this->ACCOUNT_ID->AdvancedSearch->unsetSession();
                $this->sell_price->AdvancedSearch->unsetSession();
                $this->diskon->AdvancedSearch->unsetSession();
                $this->INVOICE_ID->AdvancedSearch->unsetSession();
                $this->NUMER->AdvancedSearch->unsetSession();
                $this->MEASURE_ID2->AdvancedSearch->unsetSession();
                $this->POTONGAN->AdvancedSearch->unsetSession();
                $this->BAYAR->AdvancedSearch->unsetSession();
                $this->RETUR->AdvancedSearch->unsetSession();
                $this->TARIF_TYPE->AdvancedSearch->unsetSession();
                $this->PPNVALUE->AdvancedSearch->unsetSession();
                $this->TAGIHAN->AdvancedSearch->unsetSession();
                $this->KOREKSI->AdvancedSearch->unsetSession();
                $this->STATUS_OBAT->AdvancedSearch->unsetSession();
                $this->SUBSIDISAT->AdvancedSearch->unsetSession();
                $this->PRINTQ->AdvancedSearch->unsetSession();
                $this->PRINTED_BY->AdvancedSearch->unsetSession();
                $this->STOCK_AVAILABLE->AdvancedSearch->unsetSession();
                $this->STATUS_TARIF->AdvancedSearch->unsetSession();
                $this->CLINIC_TYPE->AdvancedSearch->unsetSession();
                $this->PACKAGE_ID->AdvancedSearch->unsetSession();
                $this->MODULE_ID->AdvancedSearch->unsetSession();
                $this->profession->AdvancedSearch->unsetSession();
                $this->THEORDER->AdvancedSearch->unsetSession();
                $this->CASHIER->AdvancedSearch->unsetSession();
                $this->SPPFEE->AdvancedSearch->unsetSession();
                $this->SPPBILL->AdvancedSearch->unsetSession();
                $this->SPPRJK->AdvancedSearch->unsetSession();
                $this->SPPJMN->AdvancedSearch->unsetSession();
                $this->SPPKASIR->AdvancedSearch->unsetSession();
                $this->PERUJUK->AdvancedSearch->unsetSession();
                $this->PERUJUKFEE->AdvancedSearch->unsetSession();
                $this->modified_datesys->AdvancedSearch->unsetSession();
                $this->TRANS_ID->AdvancedSearch->unsetSession();
                $this->SPPBILLDATE->AdvancedSearch->unsetSession();
                $this->SPPBILLUSER->AdvancedSearch->unsetSession();
                $this->SPPKASIRDATE->AdvancedSearch->unsetSession();
                $this->SPPKASIRUSER->AdvancedSearch->unsetSession();
                $this->SPPPOLI->AdvancedSearch->unsetSession();
                $this->SPPPOLIUSER->AdvancedSearch->unsetSession();
                $this->SPPPOLIDATE->AdvancedSearch->unsetSession();
                $this->nota_temp->AdvancedSearch->unsetSession();
                $this->CLINIC_ID_TEMP->AdvancedSearch->unsetSession();
                $this->NOSEP->AdvancedSearch->unsetSession();
                $this->ID->AdvancedSearch->unsetSession();
    }

    // Restore all search parameters
    protected function restoreSearchParms()
    {
        $this->RestoreSearch = true;

        // Restore basic search values
        $this->BasicSearch->load();

        // Restore advanced search values
                $this->ORG_UNIT_CODE->AdvancedSearch->load();
                $this->BILL_ID->AdvancedSearch->load();
                $this->NO_REGISTRATION->AdvancedSearch->load();
                $this->VISIT_ID->AdvancedSearch->load();
                $this->TARIF_ID->AdvancedSearch->load();
                $this->CLASS_ID->AdvancedSearch->load();
                $this->CLINIC_ID->AdvancedSearch->load();
                $this->CLINIC_ID_FROM->AdvancedSearch->load();
                $this->TREATMENT->AdvancedSearch->load();
                $this->TREAT_DATE->AdvancedSearch->load();
                $this->AMOUNT->AdvancedSearch->load();
                $this->QUANTITY->AdvancedSearch->load();
                $this->MEASURE_ID->AdvancedSearch->load();
                $this->POKOK_JUAL->AdvancedSearch->load();
                $this->PPN->AdvancedSearch->load();
                $this->MARGIN->AdvancedSearch->load();
                $this->SUBSIDI->AdvancedSearch->load();
                $this->EMBALACE->AdvancedSearch->load();
                $this->PROFESI->AdvancedSearch->load();
                $this->DISCOUNT->AdvancedSearch->load();
                $this->PAY_METHOD_ID->AdvancedSearch->load();
                $this->PAYMENT_DATE->AdvancedSearch->load();
                $this->ISLUNAS->AdvancedSearch->load();
                $this->DUEDATE_ANGSURAN->AdvancedSearch->load();
                $this->DESCRIPTION->AdvancedSearch->load();
                $this->KUITANSI_ID->AdvancedSearch->load();
                $this->NOTA_NO->AdvancedSearch->load();
                $this->ISCETAK->AdvancedSearch->load();
                $this->PRINT_DATE->AdvancedSearch->load();
                $this->RESEP_NO->AdvancedSearch->load();
                $this->RESEP_KE->AdvancedSearch->load();
                $this->DOSE->AdvancedSearch->load();
                $this->ORIG_DOSE->AdvancedSearch->load();
                $this->DOSE_PRESC->AdvancedSearch->load();
                $this->ITER->AdvancedSearch->load();
                $this->ITER_KE->AdvancedSearch->load();
                $this->SOLD_STATUS->AdvancedSearch->load();
                $this->RACIKAN->AdvancedSearch->load();
                $this->CLASS_ROOM_ID->AdvancedSearch->load();
                $this->KELUAR_ID->AdvancedSearch->load();
                $this->BED_ID->AdvancedSearch->load();
                $this->PERDA_ID->AdvancedSearch->load();
                $this->EMPLOYEE_ID->AdvancedSearch->load();
                $this->DESCRIPTION2->AdvancedSearch->load();
                $this->MODIFIED_BY->AdvancedSearch->load();
                $this->MODIFIED_DATE->AdvancedSearch->load();
                $this->MODIFIED_FROM->AdvancedSearch->load();
                $this->BRAND_ID->AdvancedSearch->load();
                $this->DOCTOR->AdvancedSearch->load();
                $this->JML_BKS->AdvancedSearch->load();
                $this->EXIT_DATE->AdvancedSearch->load();
                $this->FA_V->AdvancedSearch->load();
                $this->TASK_ID->AdvancedSearch->load();
                $this->EMPLOYEE_ID_FROM->AdvancedSearch->load();
                $this->DOCTOR_FROM->AdvancedSearch->load();
                $this->status_pasien_id->AdvancedSearch->load();
                $this->amount_paid->AdvancedSearch->load();
                $this->THENAME->AdvancedSearch->load();
                $this->THEADDRESS->AdvancedSearch->load();
                $this->THEID->AdvancedSearch->load();
                $this->serial_nb->AdvancedSearch->load();
                $this->TREATMENT_PLAFOND->AdvancedSearch->load();
                $this->AMOUNT_PLAFOND->AdvancedSearch->load();
                $this->AMOUNT_PAID_PLAFOND->AdvancedSearch->load();
                $this->CLASS_ID_PLAFOND->AdvancedSearch->load();
                $this->PAYOR_ID->AdvancedSearch->load();
                $this->PEMBULATAN->AdvancedSearch->load();
                $this->ISRJ->AdvancedSearch->load();
                $this->AGEYEAR->AdvancedSearch->load();
                $this->AGEMONTH->AdvancedSearch->load();
                $this->AGEDAY->AdvancedSearch->load();
                $this->GENDER->AdvancedSearch->load();
                $this->KAL_ID->AdvancedSearch->load();
                $this->CORRECTION_ID->AdvancedSearch->load();
                $this->CORRECTION_BY->AdvancedSearch->load();
                $this->KARYAWAN->AdvancedSearch->load();
                $this->ACCOUNT_ID->AdvancedSearch->load();
                $this->sell_price->AdvancedSearch->load();
                $this->diskon->AdvancedSearch->load();
                $this->INVOICE_ID->AdvancedSearch->load();
                $this->NUMER->AdvancedSearch->load();
                $this->MEASURE_ID2->AdvancedSearch->load();
                $this->POTONGAN->AdvancedSearch->load();
                $this->BAYAR->AdvancedSearch->load();
                $this->RETUR->AdvancedSearch->load();
                $this->TARIF_TYPE->AdvancedSearch->load();
                $this->PPNVALUE->AdvancedSearch->load();
                $this->TAGIHAN->AdvancedSearch->load();
                $this->KOREKSI->AdvancedSearch->load();
                $this->STATUS_OBAT->AdvancedSearch->load();
                $this->SUBSIDISAT->AdvancedSearch->load();
                $this->PRINTQ->AdvancedSearch->load();
                $this->PRINTED_BY->AdvancedSearch->load();
                $this->STOCK_AVAILABLE->AdvancedSearch->load();
                $this->STATUS_TARIF->AdvancedSearch->load();
                $this->CLINIC_TYPE->AdvancedSearch->load();
                $this->PACKAGE_ID->AdvancedSearch->load();
                $this->MODULE_ID->AdvancedSearch->load();
                $this->profession->AdvancedSearch->load();
                $this->THEORDER->AdvancedSearch->load();
                $this->CASHIER->AdvancedSearch->load();
                $this->SPPFEE->AdvancedSearch->load();
                $this->SPPBILL->AdvancedSearch->load();
                $this->SPPRJK->AdvancedSearch->load();
                $this->SPPJMN->AdvancedSearch->load();
                $this->SPPKASIR->AdvancedSearch->load();
                $this->PERUJUK->AdvancedSearch->load();
                $this->PERUJUKFEE->AdvancedSearch->load();
                $this->modified_datesys->AdvancedSearch->load();
                $this->TRANS_ID->AdvancedSearch->load();
                $this->SPPBILLDATE->AdvancedSearch->load();
                $this->SPPBILLUSER->AdvancedSearch->load();
                $this->SPPKASIRDATE->AdvancedSearch->load();
                $this->SPPKASIRUSER->AdvancedSearch->load();
                $this->SPPPOLI->AdvancedSearch->load();
                $this->SPPPOLIUSER->AdvancedSearch->load();
                $this->SPPPOLIDATE->AdvancedSearch->load();
                $this->nota_temp->AdvancedSearch->load();
                $this->CLINIC_ID_TEMP->AdvancedSearch->load();
                $this->NOSEP->AdvancedSearch->load();
                $this->ID->AdvancedSearch->load();
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
            $this->updateSort($this->AMOUNT); // AMOUNT
            $this->updateSort($this->QUANTITY); // QUANTITY
            $this->updateSort($this->ISLUNAS); // ISLUNAS
            $this->updateSort($this->NOTA_NO); // NOTA_NO
            $this->updateSort($this->EMPLOYEE_ID); // EMPLOYEE_ID
            $this->updateSort($this->DOCTOR); // DOCTOR
            $this->updateSort($this->amount_paid); // amount_paid
            $this->updateSort($this->THENAME); // THENAME
            $this->updateSort($this->THEADDRESS); // THEADDRESS
            $this->updateSort($this->THEID); // THEID
            $this->updateSort($this->ISRJ); // ISRJ
            $this->updateSort($this->sell_price); // sell_price
            $this->updateSort($this->TAGIHAN); // TAGIHAN
            $this->updateSort($this->TRANS_ID); // TRANS_ID
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

            // Reset master/detail keys
            if ($this->Command == "resetall") {
                $this->setCurrentMasterTable(""); // Clear master table
                $this->DbMasterFilter = "";
                $this->DbDetailFilter = "";
                        $this->VISIT_ID->setSessionValue("");
                        $this->NO_REGISTRATION->setSessionValue("");
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
                $this->amount_paid->setSort("");
                $this->THENAME->setSort("");
                $this->THEADDRESS->setSort("");
                $this->THEID->setSort("");
                $this->serial_nb->setSort("");
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
                $this->SPPFEE->setSort("");
                $this->SPPBILL->setSort("");
                $this->SPPRJK->setSort("");
                $this->SPPJMN->setSort("");
                $this->SPPKASIR->setSort("");
                $this->PERUJUK->setSort("");
                $this->PERUJUKFEE->setSort("");
                $this->modified_datesys->setSort("");
                $this->TRANS_ID->setSort("");
                $this->SPPBILLDATE->setSort("");
                $this->SPPBILLUSER->setSort("");
                $this->SPPKASIRDATE->setSort("");
                $this->SPPKASIRUSER->setSort("");
                $this->SPPPOLI->setSort("");
                $this->SPPPOLIUSER->setSort("");
                $this->SPPPOLIDATE->setSort("");
                $this->nota_temp->setSort("");
                $this->CLINIC_ID_TEMP->setSort("");
                $this->NOSEP->setSort("");
                $this->ID->setSort("");
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
        $item->Body = "<a class=\"ew-save-filter\" data-form=\"fTREATMENT_BILLlistsrch\" href=\"#\" onclick=\"return false;\">" . $Language->phrase("SaveCurrentFilter") . "</a>";
        $item->Visible = true;
        $item = &$this->FilterOptions->add("deletefilter");
        $item->Body = "<a class=\"ew-delete-filter\" data-form=\"fTREATMENT_BILLlistsrch\" href=\"#\" onclick=\"return false;\">" . $Language->phrase("DeleteFilter") . "</a>";
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
                $item->Body = '<a class="ew-action ew-list-action" title="' . HtmlEncode($caption) . '" data-caption="' . HtmlEncode($caption) . '" href="#" onclick="return ew.submitAction(event,jQuery.extend({f:document.fTREATMENT_BILLlist},' . $listaction->toJson(true) . '));">' . $icon . '</a>';
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

    // Load search values for validation
    protected function loadSearchValues()
    {
        // Load search values
        $hasValue = false;

        // ORG_UNIT_CODE
        if (!$this->isAddOrEdit() && $this->ORG_UNIT_CODE->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->ORG_UNIT_CODE->AdvancedSearch->SearchValue != "" || $this->ORG_UNIT_CODE->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

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

        // AMOUNT
        if (!$this->isAddOrEdit() && $this->AMOUNT->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->AMOUNT->AdvancedSearch->SearchValue != "" || $this->AMOUNT->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
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

        // MEASURE_ID
        if (!$this->isAddOrEdit() && $this->MEASURE_ID->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->MEASURE_ID->AdvancedSearch->SearchValue != "" || $this->MEASURE_ID->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
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

        // MARGIN
        if (!$this->isAddOrEdit() && $this->MARGIN->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->MARGIN->AdvancedSearch->SearchValue != "" || $this->MARGIN->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
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

        // EMBALACE
        if (!$this->isAddOrEdit() && $this->EMBALACE->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->EMBALACE->AdvancedSearch->SearchValue != "" || $this->EMBALACE->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // PROFESI
        if (!$this->isAddOrEdit() && $this->PROFESI->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->PROFESI->AdvancedSearch->SearchValue != "" || $this->PROFESI->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // DISCOUNT
        if (!$this->isAddOrEdit() && $this->DISCOUNT->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->DISCOUNT->AdvancedSearch->SearchValue != "" || $this->DISCOUNT->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // PAY_METHOD_ID
        if (!$this->isAddOrEdit() && $this->PAY_METHOD_ID->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->PAY_METHOD_ID->AdvancedSearch->SearchValue != "" || $this->PAY_METHOD_ID->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // PAYMENT_DATE
        if (!$this->isAddOrEdit() && $this->PAYMENT_DATE->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->PAYMENT_DATE->AdvancedSearch->SearchValue != "" || $this->PAYMENT_DATE->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // ISLUNAS
        if (!$this->isAddOrEdit() && $this->ISLUNAS->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->ISLUNAS->AdvancedSearch->SearchValue != "" || $this->ISLUNAS->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }
        if (is_array($this->ISLUNAS->AdvancedSearch->SearchValue)) {
            $this->ISLUNAS->AdvancedSearch->SearchValue = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $this->ISLUNAS->AdvancedSearch->SearchValue);
        }
        if (is_array($this->ISLUNAS->AdvancedSearch->SearchValue2)) {
            $this->ISLUNAS->AdvancedSearch->SearchValue2 = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $this->ISLUNAS->AdvancedSearch->SearchValue2);
        }

        // DUEDATE_ANGSURAN
        if (!$this->isAddOrEdit() && $this->DUEDATE_ANGSURAN->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->DUEDATE_ANGSURAN->AdvancedSearch->SearchValue != "" || $this->DUEDATE_ANGSURAN->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // DESCRIPTION
        if (!$this->isAddOrEdit() && $this->DESCRIPTION->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->DESCRIPTION->AdvancedSearch->SearchValue != "" || $this->DESCRIPTION->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
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

        // NOTA_NO
        if (!$this->isAddOrEdit() && $this->NOTA_NO->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->NOTA_NO->AdvancedSearch->SearchValue != "" || $this->NOTA_NO->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
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

        // PRINT_DATE
        if (!$this->isAddOrEdit() && $this->PRINT_DATE->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->PRINT_DATE->AdvancedSearch->SearchValue != "" || $this->PRINT_DATE->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // RESEP_NO
        if (!$this->isAddOrEdit() && $this->RESEP_NO->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->RESEP_NO->AdvancedSearch->SearchValue != "" || $this->RESEP_NO->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // RESEP_KE
        if (!$this->isAddOrEdit() && $this->RESEP_KE->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->RESEP_KE->AdvancedSearch->SearchValue != "" || $this->RESEP_KE->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // DOSE
        if (!$this->isAddOrEdit() && $this->DOSE->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->DOSE->AdvancedSearch->SearchValue != "" || $this->DOSE->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // ORIG_DOSE
        if (!$this->isAddOrEdit() && $this->ORIG_DOSE->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->ORIG_DOSE->AdvancedSearch->SearchValue != "" || $this->ORIG_DOSE->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // DOSE_PRESC
        if (!$this->isAddOrEdit() && $this->DOSE_PRESC->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->DOSE_PRESC->AdvancedSearch->SearchValue != "" || $this->DOSE_PRESC->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // ITER
        if (!$this->isAddOrEdit() && $this->ITER->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->ITER->AdvancedSearch->SearchValue != "" || $this->ITER->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // ITER_KE
        if (!$this->isAddOrEdit() && $this->ITER_KE->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->ITER_KE->AdvancedSearch->SearchValue != "" || $this->ITER_KE->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // SOLD_STATUS
        if (!$this->isAddOrEdit() && $this->SOLD_STATUS->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->SOLD_STATUS->AdvancedSearch->SearchValue != "" || $this->SOLD_STATUS->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // RACIKAN
        if (!$this->isAddOrEdit() && $this->RACIKAN->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->RACIKAN->AdvancedSearch->SearchValue != "" || $this->RACIKAN->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // CLASS_ROOM_ID
        if (!$this->isAddOrEdit() && $this->CLASS_ROOM_ID->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->CLASS_ROOM_ID->AdvancedSearch->SearchValue != "" || $this->CLASS_ROOM_ID->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
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

        // PERDA_ID
        if (!$this->isAddOrEdit() && $this->PERDA_ID->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->PERDA_ID->AdvancedSearch->SearchValue != "" || $this->PERDA_ID->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // EMPLOYEE_ID
        if (!$this->isAddOrEdit() && $this->EMPLOYEE_ID->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->EMPLOYEE_ID->AdvancedSearch->SearchValue != "" || $this->EMPLOYEE_ID->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // DESCRIPTION2
        if (!$this->isAddOrEdit() && $this->DESCRIPTION2->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->DESCRIPTION2->AdvancedSearch->SearchValue != "" || $this->DESCRIPTION2->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // MODIFIED_BY
        if (!$this->isAddOrEdit() && $this->MODIFIED_BY->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->MODIFIED_BY->AdvancedSearch->SearchValue != "" || $this->MODIFIED_BY->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // MODIFIED_DATE
        if (!$this->isAddOrEdit() && $this->MODIFIED_DATE->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->MODIFIED_DATE->AdvancedSearch->SearchValue != "" || $this->MODIFIED_DATE->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // MODIFIED_FROM
        if (!$this->isAddOrEdit() && $this->MODIFIED_FROM->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->MODIFIED_FROM->AdvancedSearch->SearchValue != "" || $this->MODIFIED_FROM->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // BRAND_ID
        if (!$this->isAddOrEdit() && $this->BRAND_ID->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->BRAND_ID->AdvancedSearch->SearchValue != "" || $this->BRAND_ID->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // DOCTOR
        if (!$this->isAddOrEdit() && $this->DOCTOR->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->DOCTOR->AdvancedSearch->SearchValue != "" || $this->DOCTOR->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // JML_BKS
        if (!$this->isAddOrEdit() && $this->JML_BKS->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->JML_BKS->AdvancedSearch->SearchValue != "" || $this->JML_BKS->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
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

        // FA_V
        if (!$this->isAddOrEdit() && $this->FA_V->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->FA_V->AdvancedSearch->SearchValue != "" || $this->FA_V->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // TASK_ID
        if (!$this->isAddOrEdit() && $this->TASK_ID->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->TASK_ID->AdvancedSearch->SearchValue != "" || $this->TASK_ID->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // EMPLOYEE_ID_FROM
        if (!$this->isAddOrEdit() && $this->EMPLOYEE_ID_FROM->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->EMPLOYEE_ID_FROM->AdvancedSearch->SearchValue != "" || $this->EMPLOYEE_ID_FROM->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // DOCTOR_FROM
        if (!$this->isAddOrEdit() && $this->DOCTOR_FROM->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->DOCTOR_FROM->AdvancedSearch->SearchValue != "" || $this->DOCTOR_FROM->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // status_pasien_id
        if (!$this->isAddOrEdit() && $this->status_pasien_id->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->status_pasien_id->AdvancedSearch->SearchValue != "" || $this->status_pasien_id->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
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

        // serial_nb
        if (!$this->isAddOrEdit() && $this->serial_nb->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->serial_nb->AdvancedSearch->SearchValue != "" || $this->serial_nb->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // TREATMENT_PLAFOND
        if (!$this->isAddOrEdit() && $this->TREATMENT_PLAFOND->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->TREATMENT_PLAFOND->AdvancedSearch->SearchValue != "" || $this->TREATMENT_PLAFOND->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // AMOUNT_PLAFOND
        if (!$this->isAddOrEdit() && $this->AMOUNT_PLAFOND->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->AMOUNT_PLAFOND->AdvancedSearch->SearchValue != "" || $this->AMOUNT_PLAFOND->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // AMOUNT_PAID_PLAFOND
        if (!$this->isAddOrEdit() && $this->AMOUNT_PAID_PLAFOND->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->AMOUNT_PAID_PLAFOND->AdvancedSearch->SearchValue != "" || $this->AMOUNT_PAID_PLAFOND->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // CLASS_ID_PLAFOND
        if (!$this->isAddOrEdit() && $this->CLASS_ID_PLAFOND->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->CLASS_ID_PLAFOND->AdvancedSearch->SearchValue != "" || $this->CLASS_ID_PLAFOND->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // PAYOR_ID
        if (!$this->isAddOrEdit() && $this->PAYOR_ID->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->PAYOR_ID->AdvancedSearch->SearchValue != "" || $this->PAYOR_ID->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // PEMBULATAN
        if (!$this->isAddOrEdit() && $this->PEMBULATAN->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->PEMBULATAN->AdvancedSearch->SearchValue != "" || $this->PEMBULATAN->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // ISRJ
        if (!$this->isAddOrEdit() && $this->ISRJ->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->ISRJ->AdvancedSearch->SearchValue != "" || $this->ISRJ->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }
        if (is_array($this->ISRJ->AdvancedSearch->SearchValue)) {
            $this->ISRJ->AdvancedSearch->SearchValue = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $this->ISRJ->AdvancedSearch->SearchValue);
        }
        if (is_array($this->ISRJ->AdvancedSearch->SearchValue2)) {
            $this->ISRJ->AdvancedSearch->SearchValue2 = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $this->ISRJ->AdvancedSearch->SearchValue2);
        }

        // AGEYEAR
        if (!$this->isAddOrEdit() && $this->AGEYEAR->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->AGEYEAR->AdvancedSearch->SearchValue != "" || $this->AGEYEAR->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // AGEMONTH
        if (!$this->isAddOrEdit() && $this->AGEMONTH->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->AGEMONTH->AdvancedSearch->SearchValue != "" || $this->AGEMONTH->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // AGEDAY
        if (!$this->isAddOrEdit() && $this->AGEDAY->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->AGEDAY->AdvancedSearch->SearchValue != "" || $this->AGEDAY->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // GENDER
        if (!$this->isAddOrEdit() && $this->GENDER->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->GENDER->AdvancedSearch->SearchValue != "" || $this->GENDER->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // KAL_ID
        if (!$this->isAddOrEdit() && $this->KAL_ID->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->KAL_ID->AdvancedSearch->SearchValue != "" || $this->KAL_ID->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // CORRECTION_ID
        if (!$this->isAddOrEdit() && $this->CORRECTION_ID->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->CORRECTION_ID->AdvancedSearch->SearchValue != "" || $this->CORRECTION_ID->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // CORRECTION_BY
        if (!$this->isAddOrEdit() && $this->CORRECTION_BY->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->CORRECTION_BY->AdvancedSearch->SearchValue != "" || $this->CORRECTION_BY->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // KARYAWAN
        if (!$this->isAddOrEdit() && $this->KARYAWAN->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->KARYAWAN->AdvancedSearch->SearchValue != "" || $this->KARYAWAN->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // ACCOUNT_ID
        if (!$this->isAddOrEdit() && $this->ACCOUNT_ID->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->ACCOUNT_ID->AdvancedSearch->SearchValue != "" || $this->ACCOUNT_ID->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
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

        // INVOICE_ID
        if (!$this->isAddOrEdit() && $this->INVOICE_ID->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->INVOICE_ID->AdvancedSearch->SearchValue != "" || $this->INVOICE_ID->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // NUMER
        if (!$this->isAddOrEdit() && $this->NUMER->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->NUMER->AdvancedSearch->SearchValue != "" || $this->NUMER->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // MEASURE_ID2
        if (!$this->isAddOrEdit() && $this->MEASURE_ID2->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->MEASURE_ID2->AdvancedSearch->SearchValue != "" || $this->MEASURE_ID2->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // POTONGAN
        if (!$this->isAddOrEdit() && $this->POTONGAN->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->POTONGAN->AdvancedSearch->SearchValue != "" || $this->POTONGAN->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // BAYAR
        if (!$this->isAddOrEdit() && $this->BAYAR->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->BAYAR->AdvancedSearch->SearchValue != "" || $this->BAYAR->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // RETUR
        if (!$this->isAddOrEdit() && $this->RETUR->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->RETUR->AdvancedSearch->SearchValue != "" || $this->RETUR->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // TARIF_TYPE
        if (!$this->isAddOrEdit() && $this->TARIF_TYPE->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->TARIF_TYPE->AdvancedSearch->SearchValue != "" || $this->TARIF_TYPE->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // PPNVALUE
        if (!$this->isAddOrEdit() && $this->PPNVALUE->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->PPNVALUE->AdvancedSearch->SearchValue != "" || $this->PPNVALUE->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
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

        // KOREKSI
        if (!$this->isAddOrEdit() && $this->KOREKSI->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->KOREKSI->AdvancedSearch->SearchValue != "" || $this->KOREKSI->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // STATUS_OBAT
        if (!$this->isAddOrEdit() && $this->STATUS_OBAT->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->STATUS_OBAT->AdvancedSearch->SearchValue != "" || $this->STATUS_OBAT->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // SUBSIDISAT
        if (!$this->isAddOrEdit() && $this->SUBSIDISAT->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->SUBSIDISAT->AdvancedSearch->SearchValue != "" || $this->SUBSIDISAT->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // PRINTQ
        if (!$this->isAddOrEdit() && $this->PRINTQ->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->PRINTQ->AdvancedSearch->SearchValue != "" || $this->PRINTQ->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // PRINTED_BY
        if (!$this->isAddOrEdit() && $this->PRINTED_BY->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->PRINTED_BY->AdvancedSearch->SearchValue != "" || $this->PRINTED_BY->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // STOCK_AVAILABLE
        if (!$this->isAddOrEdit() && $this->STOCK_AVAILABLE->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->STOCK_AVAILABLE->AdvancedSearch->SearchValue != "" || $this->STOCK_AVAILABLE->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // STATUS_TARIF
        if (!$this->isAddOrEdit() && $this->STATUS_TARIF->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->STATUS_TARIF->AdvancedSearch->SearchValue != "" || $this->STATUS_TARIF->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
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

        // PACKAGE_ID
        if (!$this->isAddOrEdit() && $this->PACKAGE_ID->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->PACKAGE_ID->AdvancedSearch->SearchValue != "" || $this->PACKAGE_ID->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // MODULE_ID
        if (!$this->isAddOrEdit() && $this->MODULE_ID->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->MODULE_ID->AdvancedSearch->SearchValue != "" || $this->MODULE_ID->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // profession
        if (!$this->isAddOrEdit() && $this->profession->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->profession->AdvancedSearch->SearchValue != "" || $this->profession->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // THEORDER
        if (!$this->isAddOrEdit() && $this->THEORDER->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->THEORDER->AdvancedSearch->SearchValue != "" || $this->THEORDER->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // CASHIER
        if (!$this->isAddOrEdit() && $this->CASHIER->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->CASHIER->AdvancedSearch->SearchValue != "" || $this->CASHIER->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // SPPFEE
        if (!$this->isAddOrEdit() && $this->SPPFEE->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->SPPFEE->AdvancedSearch->SearchValue != "" || $this->SPPFEE->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // SPPBILL
        if (!$this->isAddOrEdit() && $this->SPPBILL->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->SPPBILL->AdvancedSearch->SearchValue != "" || $this->SPPBILL->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // SPPRJK
        if (!$this->isAddOrEdit() && $this->SPPRJK->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->SPPRJK->AdvancedSearch->SearchValue != "" || $this->SPPRJK->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // SPPJMN
        if (!$this->isAddOrEdit() && $this->SPPJMN->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->SPPJMN->AdvancedSearch->SearchValue != "" || $this->SPPJMN->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // SPPKASIR
        if (!$this->isAddOrEdit() && $this->SPPKASIR->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->SPPKASIR->AdvancedSearch->SearchValue != "" || $this->SPPKASIR->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // PERUJUK
        if (!$this->isAddOrEdit() && $this->PERUJUK->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->PERUJUK->AdvancedSearch->SearchValue != "" || $this->PERUJUK->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // PERUJUKFEE
        if (!$this->isAddOrEdit() && $this->PERUJUKFEE->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->PERUJUKFEE->AdvancedSearch->SearchValue != "" || $this->PERUJUKFEE->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // modified_datesys
        if (!$this->isAddOrEdit() && $this->modified_datesys->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->modified_datesys->AdvancedSearch->SearchValue != "" || $this->modified_datesys->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
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

        // SPPBILLDATE
        if (!$this->isAddOrEdit() && $this->SPPBILLDATE->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->SPPBILLDATE->AdvancedSearch->SearchValue != "" || $this->SPPBILLDATE->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // SPPBILLUSER
        if (!$this->isAddOrEdit() && $this->SPPBILLUSER->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->SPPBILLUSER->AdvancedSearch->SearchValue != "" || $this->SPPBILLUSER->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // SPPKASIRDATE
        if (!$this->isAddOrEdit() && $this->SPPKASIRDATE->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->SPPKASIRDATE->AdvancedSearch->SearchValue != "" || $this->SPPKASIRDATE->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // SPPKASIRUSER
        if (!$this->isAddOrEdit() && $this->SPPKASIRUSER->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->SPPKASIRUSER->AdvancedSearch->SearchValue != "" || $this->SPPKASIRUSER->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // SPPPOLI
        if (!$this->isAddOrEdit() && $this->SPPPOLI->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->SPPPOLI->AdvancedSearch->SearchValue != "" || $this->SPPPOLI->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // SPPPOLIUSER
        if (!$this->isAddOrEdit() && $this->SPPPOLIUSER->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->SPPPOLIUSER->AdvancedSearch->SearchValue != "" || $this->SPPPOLIUSER->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // SPPPOLIDATE
        if (!$this->isAddOrEdit() && $this->SPPPOLIDATE->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->SPPPOLIDATE->AdvancedSearch->SearchValue != "" || $this->SPPPOLIDATE->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // nota_temp
        if (!$this->isAddOrEdit() && $this->nota_temp->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->nota_temp->AdvancedSearch->SearchValue != "" || $this->nota_temp->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // CLINIC_ID_TEMP
        if (!$this->isAddOrEdit() && $this->CLINIC_ID_TEMP->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->CLINIC_ID_TEMP->AdvancedSearch->SearchValue != "" || $this->CLINIC_ID_TEMP->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // NOSEP
        if (!$this->isAddOrEdit() && $this->NOSEP->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->NOSEP->AdvancedSearch->SearchValue != "" || $this->NOSEP->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
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
        return $hasValue;
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
        $this->amount_paid->setDbValue($row['amount_paid']);
        $this->THENAME->setDbValue($row['THENAME']);
        $this->THEADDRESS->setDbValue($row['THEADDRESS']);
        $this->THEID->setDbValue($row['THEID']);
        $this->serial_nb->setDbValue($row['serial_nb']);
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
        $this->SPPFEE->setDbValue($row['SPPFEE']);
        $this->SPPBILL->setDbValue($row['SPPBILL']);
        $this->SPPRJK->setDbValue($row['SPPRJK']);
        $this->SPPJMN->setDbValue($row['SPPJMN']);
        $this->SPPKASIR->setDbValue($row['SPPKASIR']);
        $this->PERUJUK->setDbValue($row['PERUJUK']);
        $this->PERUJUKFEE->setDbValue($row['PERUJUKFEE']);
        $this->modified_datesys->setDbValue($row['modified_datesys']);
        $this->TRANS_ID->setDbValue($row['TRANS_ID']);
        $this->SPPBILLDATE->setDbValue($row['SPPBILLDATE']);
        $this->SPPBILLUSER->setDbValue($row['SPPBILLUSER']);
        $this->SPPKASIRDATE->setDbValue($row['SPPKASIRDATE']);
        $this->SPPKASIRUSER->setDbValue($row['SPPKASIRUSER']);
        $this->SPPPOLI->setDbValue($row['SPPPOLI']);
        $this->SPPPOLIUSER->setDbValue($row['SPPPOLIUSER']);
        $this->SPPPOLIDATE->setDbValue($row['SPPPOLIDATE']);
        $this->nota_temp->setDbValue($row['nota_temp']);
        $this->CLINIC_ID_TEMP->setDbValue($row['CLINIC_ID_TEMP']);
        $this->NOSEP->setDbValue($row['NOSEP']);
        $this->ID->setDbValue($row['ID']);
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
        $row['amount_paid'] = null;
        $row['THENAME'] = null;
        $row['THEADDRESS'] = null;
        $row['THEID'] = null;
        $row['serial_nb'] = null;
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
        $row['SPPFEE'] = null;
        $row['SPPBILL'] = null;
        $row['SPPRJK'] = null;
        $row['SPPJMN'] = null;
        $row['SPPKASIR'] = null;
        $row['PERUJUK'] = null;
        $row['PERUJUKFEE'] = null;
        $row['modified_datesys'] = null;
        $row['TRANS_ID'] = null;
        $row['SPPBILLDATE'] = null;
        $row['SPPBILLUSER'] = null;
        $row['SPPKASIRDATE'] = null;
        $row['SPPKASIRUSER'] = null;
        $row['SPPPOLI'] = null;
        $row['SPPPOLIUSER'] = null;
        $row['SPPPOLIDATE'] = null;
        $row['nota_temp'] = null;
        $row['CLINIC_ID_TEMP'] = null;
        $row['NOSEP'] = null;
        $row['ID'] = null;
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
        if ($this->amount_paid->FormValue == $this->amount_paid->CurrentValue && is_numeric(ConvertToFloatString($this->amount_paid->CurrentValue))) {
            $this->amount_paid->CurrentValue = ConvertToFloatString($this->amount_paid->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->sell_price->FormValue == $this->sell_price->CurrentValue && is_numeric(ConvertToFloatString($this->sell_price->CurrentValue))) {
            $this->sell_price->CurrentValue = ConvertToFloatString($this->sell_price->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->TAGIHAN->FormValue == $this->TAGIHAN->CurrentValue && is_numeric(ConvertToFloatString($this->TAGIHAN->CurrentValue))) {
            $this->TAGIHAN->CurrentValue = ConvertToFloatString($this->TAGIHAN->CurrentValue);
        }

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // ORG_UNIT_CODE
        $this->ORG_UNIT_CODE->CellCssStyle = "white-space: nowrap;";

        // BILL_ID
        $this->BILL_ID->CellCssStyle = "white-space: nowrap;";

        // NO_REGISTRATION
        $this->NO_REGISTRATION->CellCssStyle = "white-space: nowrap;";

        // VISIT_ID
        $this->VISIT_ID->CellCssStyle = "white-space: nowrap;";

        // TARIF_ID
        $this->TARIF_ID->CellCssStyle = "white-space: nowrap;";

        // CLASS_ID
        $this->CLASS_ID->CellCssStyle = "white-space: nowrap;";

        // CLINIC_ID
        $this->CLINIC_ID->CellCssStyle = "white-space: nowrap;";

        // CLINIC_ID_FROM
        $this->CLINIC_ID_FROM->CellCssStyle = "white-space: nowrap;";

        // TREATMENT
        $this->TREATMENT->CellCssStyle = "white-space: nowrap;";

        // TREAT_DATE
        $this->TREAT_DATE->CellCssStyle = "white-space: nowrap;";

        // AMOUNT
        $this->AMOUNT->CellCssStyle = "white-space: nowrap;";

        // QUANTITY
        $this->QUANTITY->CellCssStyle = "white-space: nowrap;";

        // MEASURE_ID
        $this->MEASURE_ID->CellCssStyle = "white-space: nowrap;";

        // POKOK_JUAL
        $this->POKOK_JUAL->CellCssStyle = "white-space: nowrap;";

        // PPN
        $this->PPN->CellCssStyle = "white-space: nowrap;";

        // MARGIN
        $this->MARGIN->CellCssStyle = "white-space: nowrap;";

        // SUBSIDI
        $this->SUBSIDI->CellCssStyle = "white-space: nowrap;";

        // EMBALACE
        $this->EMBALACE->CellCssStyle = "white-space: nowrap;";

        // PROFESI
        $this->PROFESI->CellCssStyle = "white-space: nowrap;";

        // DISCOUNT
        $this->DISCOUNT->CellCssStyle = "white-space: nowrap;";

        // PAY_METHOD_ID
        $this->PAY_METHOD_ID->CellCssStyle = "white-space: nowrap;";

        // PAYMENT_DATE
        $this->PAYMENT_DATE->CellCssStyle = "white-space: nowrap;";

        // ISLUNAS
        $this->ISLUNAS->CellCssStyle = "white-space: nowrap;";

        // DUEDATE_ANGSURAN
        $this->DUEDATE_ANGSURAN->CellCssStyle = "white-space: nowrap;";

        // DESCRIPTION
        $this->DESCRIPTION->CellCssStyle = "white-space: nowrap;";

        // KUITANSI_ID
        $this->KUITANSI_ID->CellCssStyle = "white-space: nowrap;";

        // NOTA_NO
        $this->NOTA_NO->CellCssStyle = "white-space: nowrap;";

        // ISCETAK
        $this->ISCETAK->CellCssStyle = "white-space: nowrap;";

        // PRINT_DATE
        $this->PRINT_DATE->CellCssStyle = "white-space: nowrap;";

        // RESEP_NO
        $this->RESEP_NO->CellCssStyle = "white-space: nowrap;";

        // RESEP_KE
        $this->RESEP_KE->CellCssStyle = "white-space: nowrap;";

        // DOSE
        $this->DOSE->CellCssStyle = "white-space: nowrap;";

        // ORIG_DOSE
        $this->ORIG_DOSE->CellCssStyle = "white-space: nowrap;";

        // DOSE_PRESC
        $this->DOSE_PRESC->CellCssStyle = "white-space: nowrap;";

        // ITER
        $this->ITER->CellCssStyle = "white-space: nowrap;";

        // ITER_KE
        $this->ITER_KE->CellCssStyle = "white-space: nowrap;";

        // SOLD_STATUS
        $this->SOLD_STATUS->CellCssStyle = "white-space: nowrap;";

        // RACIKAN
        $this->RACIKAN->CellCssStyle = "white-space: nowrap;";

        // CLASS_ROOM_ID
        $this->CLASS_ROOM_ID->CellCssStyle = "white-space: nowrap;";

        // KELUAR_ID
        $this->KELUAR_ID->CellCssStyle = "white-space: nowrap;";

        // BED_ID
        $this->BED_ID->CellCssStyle = "white-space: nowrap;";

        // PERDA_ID
        $this->PERDA_ID->CellCssStyle = "white-space: nowrap;";

        // EMPLOYEE_ID
        $this->EMPLOYEE_ID->CellCssStyle = "white-space: nowrap;";

        // DESCRIPTION2
        $this->DESCRIPTION2->CellCssStyle = "white-space: nowrap;";

        // MODIFIED_BY
        $this->MODIFIED_BY->CellCssStyle = "white-space: nowrap;";

        // MODIFIED_DATE
        $this->MODIFIED_DATE->CellCssStyle = "white-space: nowrap;";

        // MODIFIED_FROM
        $this->MODIFIED_FROM->CellCssStyle = "white-space: nowrap;";

        // BRAND_ID
        $this->BRAND_ID->CellCssStyle = "white-space: nowrap;";

        // DOCTOR
        $this->DOCTOR->CellCssStyle = "white-space: nowrap;";

        // JML_BKS
        $this->JML_BKS->CellCssStyle = "white-space: nowrap;";

        // EXIT_DATE
        $this->EXIT_DATE->CellCssStyle = "white-space: nowrap;";

        // FA_V
        $this->FA_V->CellCssStyle = "white-space: nowrap;";

        // TASK_ID
        $this->TASK_ID->CellCssStyle = "white-space: nowrap;";

        // EMPLOYEE_ID_FROM
        $this->EMPLOYEE_ID_FROM->CellCssStyle = "white-space: nowrap;";

        // DOCTOR_FROM
        $this->DOCTOR_FROM->CellCssStyle = "white-space: nowrap;";

        // status_pasien_id
        $this->status_pasien_id->CellCssStyle = "white-space: nowrap;";

        // amount_paid
        $this->amount_paid->CellCssStyle = "white-space: nowrap;";

        // THENAME
        $this->THENAME->CellCssStyle = "white-space: nowrap;";

        // THEADDRESS
        $this->THEADDRESS->CellCssStyle = "white-space: nowrap;";

        // THEID
        $this->THEID->CellCssStyle = "white-space: nowrap;";

        // serial_nb
        $this->serial_nb->CellCssStyle = "white-space: nowrap;";

        // TREATMENT_PLAFOND
        $this->TREATMENT_PLAFOND->CellCssStyle = "white-space: nowrap;";

        // AMOUNT_PLAFOND
        $this->AMOUNT_PLAFOND->CellCssStyle = "white-space: nowrap;";

        // AMOUNT_PAID_PLAFOND
        $this->AMOUNT_PAID_PLAFOND->CellCssStyle = "white-space: nowrap;";

        // CLASS_ID_PLAFOND
        $this->CLASS_ID_PLAFOND->CellCssStyle = "white-space: nowrap;";

        // PAYOR_ID
        $this->PAYOR_ID->CellCssStyle = "white-space: nowrap;";

        // PEMBULATAN
        $this->PEMBULATAN->CellCssStyle = "white-space: nowrap;";

        // ISRJ
        $this->ISRJ->CellCssStyle = "white-space: nowrap;";

        // AGEYEAR
        $this->AGEYEAR->CellCssStyle = "white-space: nowrap;";

        // AGEMONTH
        $this->AGEMONTH->CellCssStyle = "white-space: nowrap;";

        // AGEDAY
        $this->AGEDAY->CellCssStyle = "white-space: nowrap;";

        // GENDER
        $this->GENDER->CellCssStyle = "white-space: nowrap;";

        // KAL_ID
        $this->KAL_ID->CellCssStyle = "white-space: nowrap;";

        // CORRECTION_ID
        $this->CORRECTION_ID->CellCssStyle = "white-space: nowrap;";

        // CORRECTION_BY
        $this->CORRECTION_BY->CellCssStyle = "white-space: nowrap;";

        // KARYAWAN
        $this->KARYAWAN->CellCssStyle = "white-space: nowrap;";

        // ACCOUNT_ID
        $this->ACCOUNT_ID->CellCssStyle = "white-space: nowrap;";

        // sell_price
        $this->sell_price->CellCssStyle = "white-space: nowrap;";

        // diskon
        $this->diskon->CellCssStyle = "white-space: nowrap;";

        // INVOICE_ID
        $this->INVOICE_ID->CellCssStyle = "white-space: nowrap;";

        // NUMER
        $this->NUMER->CellCssStyle = "white-space: nowrap;";

        // MEASURE_ID2
        $this->MEASURE_ID2->CellCssStyle = "white-space: nowrap;";

        // POTONGAN
        $this->POTONGAN->CellCssStyle = "white-space: nowrap;";

        // BAYAR
        $this->BAYAR->CellCssStyle = "white-space: nowrap;";

        // RETUR
        $this->RETUR->CellCssStyle = "white-space: nowrap;";

        // TARIF_TYPE
        $this->TARIF_TYPE->CellCssStyle = "white-space: nowrap;";

        // PPNVALUE
        $this->PPNVALUE->CellCssStyle = "white-space: nowrap;";

        // TAGIHAN
        $this->TAGIHAN->CellCssStyle = "white-space: nowrap;";

        // KOREKSI
        $this->KOREKSI->CellCssStyle = "white-space: nowrap;";

        // STATUS_OBAT
        $this->STATUS_OBAT->CellCssStyle = "white-space: nowrap;";

        // SUBSIDISAT
        $this->SUBSIDISAT->CellCssStyle = "white-space: nowrap;";

        // PRINTQ
        $this->PRINTQ->CellCssStyle = "white-space: nowrap;";

        // PRINTED_BY
        $this->PRINTED_BY->CellCssStyle = "white-space: nowrap;";

        // STOCK_AVAILABLE
        $this->STOCK_AVAILABLE->CellCssStyle = "white-space: nowrap;";

        // STATUS_TARIF
        $this->STATUS_TARIF->CellCssStyle = "white-space: nowrap;";

        // CLINIC_TYPE
        $this->CLINIC_TYPE->CellCssStyle = "white-space: nowrap;";

        // PACKAGE_ID
        $this->PACKAGE_ID->CellCssStyle = "white-space: nowrap;";

        // MODULE_ID
        $this->MODULE_ID->CellCssStyle = "white-space: nowrap;";

        // profession
        $this->profession->CellCssStyle = "white-space: nowrap;";

        // THEORDER
        $this->THEORDER->CellCssStyle = "white-space: nowrap;";

        // CASHIER
        $this->CASHIER->CellCssStyle = "white-space: nowrap;";

        // SPPFEE
        $this->SPPFEE->CellCssStyle = "white-space: nowrap;";

        // SPPBILL
        $this->SPPBILL->CellCssStyle = "white-space: nowrap;";

        // SPPRJK
        $this->SPPRJK->CellCssStyle = "white-space: nowrap;";

        // SPPJMN
        $this->SPPJMN->CellCssStyle = "white-space: nowrap;";

        // SPPKASIR
        $this->SPPKASIR->CellCssStyle = "white-space: nowrap;";

        // PERUJUK
        $this->PERUJUK->CellCssStyle = "white-space: nowrap;";

        // PERUJUKFEE
        $this->PERUJUKFEE->CellCssStyle = "white-space: nowrap;";

        // modified_datesys
        $this->modified_datesys->CellCssStyle = "white-space: nowrap;";

        // TRANS_ID
        $this->TRANS_ID->CellCssStyle = "white-space: nowrap;";

        // SPPBILLDATE
        $this->SPPBILLDATE->CellCssStyle = "white-space: nowrap;";

        // SPPBILLUSER
        $this->SPPBILLUSER->CellCssStyle = "white-space: nowrap;";

        // SPPKASIRDATE
        $this->SPPKASIRDATE->CellCssStyle = "white-space: nowrap;";

        // SPPKASIRUSER
        $this->SPPKASIRUSER->CellCssStyle = "white-space: nowrap;";

        // SPPPOLI
        $this->SPPPOLI->CellCssStyle = "white-space: nowrap;";

        // SPPPOLIUSER
        $this->SPPPOLIUSER->CellCssStyle = "white-space: nowrap;";

        // SPPPOLIDATE
        $this->SPPPOLIDATE->CellCssStyle = "white-space: nowrap;";

        // nota_temp
        $this->nota_temp->CellCssStyle = "white-space: nowrap;";

        // CLINIC_ID_TEMP
        $this->CLINIC_ID_TEMP->CellCssStyle = "white-space: nowrap;";

        // NOSEP
        $this->NOSEP->CellCssStyle = "white-space: nowrap;";

        // ID
        $this->ID->CellCssStyle = "white-space: nowrap;";

        // Accumulate aggregate value
        if ($this->RowType != ROWTYPE_AGGREGATEINIT && $this->RowType != ROWTYPE_AGGREGATE) {
            if (is_numeric($this->amount_paid->CurrentValue)) {
                $this->amount_paid->Total += $this->amount_paid->CurrentValue; // Accumulate total
            }
        }
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

            // AMOUNT
            $this->AMOUNT->ViewValue = $this->AMOUNT->CurrentValue;
            $this->AMOUNT->ViewValue = FormatNumber($this->AMOUNT->ViewValue, 0, -2, -2, -2);
            $this->AMOUNT->ViewCustomAttributes = "";

            // QUANTITY
            $this->QUANTITY->ViewValue = $this->QUANTITY->CurrentValue;
            $this->QUANTITY->ViewValue = FormatNumber($this->QUANTITY->ViewValue, 0, -2, -2, -2);
            $this->QUANTITY->ViewCustomAttributes = "";

            // MEASURE_ID
            $this->MEASURE_ID->ViewValue = $this->MEASURE_ID->CurrentValue;
            $this->MEASURE_ID->ViewValue = FormatNumber($this->MEASURE_ID->ViewValue, 0, -2, -2, -2);
            $this->MEASURE_ID->ViewCustomAttributes = "";

            // POKOK_JUAL
            $this->POKOK_JUAL->ViewValue = $this->POKOK_JUAL->CurrentValue;
            $this->POKOK_JUAL->ViewValue = FormatNumber($this->POKOK_JUAL->ViewValue, 0, -2, -2, -2);
            $this->POKOK_JUAL->ViewCustomAttributes = "";

            // PPN
            $this->PPN->ViewValue = $this->PPN->CurrentValue;
            $this->PPN->ViewValue = FormatNumber($this->PPN->ViewValue, 0, -2, -2, -2);
            $this->PPN->ViewCustomAttributes = "";

            // MARGIN
            $this->MARGIN->ViewValue = $this->MARGIN->CurrentValue;
            $this->MARGIN->ViewValue = FormatNumber($this->MARGIN->ViewValue, 0, -2, -2, -2);
            $this->MARGIN->ViewCustomAttributes = "";

            // SUBSIDI
            $this->SUBSIDI->ViewValue = $this->SUBSIDI->CurrentValue;
            $this->SUBSIDI->ViewValue = FormatNumber($this->SUBSIDI->ViewValue, 0, -2, -2, -2);
            $this->SUBSIDI->ViewCustomAttributes = "";

            // EMBALACE
            $this->EMBALACE->ViewValue = $this->EMBALACE->CurrentValue;
            $this->EMBALACE->ViewValue = FormatNumber($this->EMBALACE->ViewValue, 0, -2, -2, -2);
            $this->EMBALACE->ViewCustomAttributes = "";

            // PROFESI
            $this->PROFESI->ViewValue = $this->PROFESI->CurrentValue;
            $this->PROFESI->ViewValue = FormatNumber($this->PROFESI->ViewValue, 0, -2, -2, -2);
            $this->PROFESI->ViewCustomAttributes = "";

            // DISCOUNT
            $this->DISCOUNT->ViewValue = $this->DISCOUNT->CurrentValue;
            $this->DISCOUNT->ViewValue = FormatNumber($this->DISCOUNT->ViewValue, 0, -2, -2, -2);
            $this->DISCOUNT->ViewCustomAttributes = "";

            // PAY_METHOD_ID
            $this->PAY_METHOD_ID->ViewValue = $this->PAY_METHOD_ID->CurrentValue;
            $this->PAY_METHOD_ID->ViewValue = FormatNumber($this->PAY_METHOD_ID->ViewValue, 0, -2, -2, -2);
            $this->PAY_METHOD_ID->ViewCustomAttributes = "";

            // PAYMENT_DATE
            $this->PAYMENT_DATE->ViewValue = $this->PAYMENT_DATE->CurrentValue;
            $this->PAYMENT_DATE->ViewValue = FormatDateTime($this->PAYMENT_DATE->ViewValue, 11);
            $this->PAYMENT_DATE->ViewCustomAttributes = "";

            // ISLUNAS
            if (strval($this->ISLUNAS->CurrentValue) != "") {
                $this->ISLUNAS->ViewValue = new OptionValues();
                $arwrk = explode(",", strval($this->ISLUNAS->CurrentValue));
                $cnt = count($arwrk);
                for ($ari = 0; $ari < $cnt; $ari++)
                    $this->ISLUNAS->ViewValue->add($this->ISLUNAS->optionCaption(trim($arwrk[$ari])));
            } else {
                $this->ISLUNAS->ViewValue = null;
            }
            $this->ISLUNAS->ViewCustomAttributes = "";

            // DUEDATE_ANGSURAN
            $this->DUEDATE_ANGSURAN->ViewValue = $this->DUEDATE_ANGSURAN->CurrentValue;
            $this->DUEDATE_ANGSURAN->ViewValue = FormatDateTime($this->DUEDATE_ANGSURAN->ViewValue, 11);
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
            $this->PRINT_DATE->ViewValue = FormatDateTime($this->PRINT_DATE->ViewValue, 11);
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
            $this->DOSE->ViewValue = FormatNumber($this->DOSE->ViewValue, 0, -2, -2, -2);
            $this->DOSE->ViewCustomAttributes = "";

            // ORIG_DOSE
            $this->ORIG_DOSE->ViewValue = $this->ORIG_DOSE->CurrentValue;
            $this->ORIG_DOSE->ViewValue = FormatNumber($this->ORIG_DOSE->ViewValue, 0, -2, -2, -2);
            $this->ORIG_DOSE->ViewCustomAttributes = "";

            // DOSE_PRESC
            $this->DOSE_PRESC->ViewValue = $this->DOSE_PRESC->CurrentValue;
            $this->DOSE_PRESC->ViewValue = FormatNumber($this->DOSE_PRESC->ViewValue, 0, -2, -2, -2);
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
            $curVal = trim(strval($this->EMPLOYEE_ID->CurrentValue));
            if ($curVal != "") {
                $this->EMPLOYEE_ID->ViewValue = $this->EMPLOYEE_ID->lookupCacheOption($curVal);
                if ($this->EMPLOYEE_ID->ViewValue === null) { // Lookup from database
                    $filterWrk = "[EMPLOYEE_ID]" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->EMPLOYEE_ID->Lookup->getSql(false, $filterWrk, '', $this, true, true);
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

            // DESCRIPTION2
            $this->DESCRIPTION2->ViewValue = $this->DESCRIPTION2->CurrentValue;
            $this->DESCRIPTION2->ViewCustomAttributes = "";

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
            $this->EXIT_DATE->ViewValue = FormatDateTime($this->EXIT_DATE->ViewValue, 11);
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

            // amount_paid
            $this->amount_paid->ViewValue = $this->amount_paid->CurrentValue;
            $this->amount_paid->ViewValue = FormatNumber($this->amount_paid->ViewValue, 0, -2, -2, -2);
            $this->amount_paid->ViewCustomAttributes = "";

            // THENAME
            $this->THENAME->ViewValue = $this->THENAME->CurrentValue;
            $this->THENAME->ViewCustomAttributes = "";

            // THEADDRESS
            $this->THEADDRESS->ViewValue = $this->THEADDRESS->CurrentValue;
            $this->THEADDRESS->ViewCustomAttributes = "";

            // THEID
            $this->THEID->ViewValue = $this->THEID->CurrentValue;
            $this->THEID->ViewCustomAttributes = "";

            // serial_nb
            $this->serial_nb->ViewValue = $this->serial_nb->CurrentValue;
            $this->serial_nb->ViewCustomAttributes = "";

            // TREATMENT_PLAFOND
            $this->TREATMENT_PLAFOND->ViewValue = $this->TREATMENT_PLAFOND->CurrentValue;
            $this->TREATMENT_PLAFOND->ViewCustomAttributes = "";

            // AMOUNT_PLAFOND
            $this->AMOUNT_PLAFOND->ViewValue = $this->AMOUNT_PLAFOND->CurrentValue;
            $this->AMOUNT_PLAFOND->ViewValue = FormatNumber($this->AMOUNT_PLAFOND->ViewValue, 0, -2, -2, -2);
            $this->AMOUNT_PLAFOND->ViewCustomAttributes = "";

            // AMOUNT_PAID_PLAFOND
            $this->AMOUNT_PAID_PLAFOND->ViewValue = $this->AMOUNT_PAID_PLAFOND->CurrentValue;
            $this->AMOUNT_PAID_PLAFOND->ViewValue = FormatNumber($this->AMOUNT_PAID_PLAFOND->ViewValue, 0, -2, -2, -2);
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
            $this->PEMBULATAN->ViewValue = FormatNumber($this->PEMBULATAN->ViewValue, 0, -2, -2, -2);
            $this->PEMBULATAN->ViewCustomAttributes = "";

            // ISRJ
            if (strval($this->ISRJ->CurrentValue) != "") {
                $this->ISRJ->ViewValue = new OptionValues();
                $arwrk = explode(",", strval($this->ISRJ->CurrentValue));
                $cnt = count($arwrk);
                for ($ari = 0; $ari < $cnt; $ari++)
                    $this->ISRJ->ViewValue->add($this->ISRJ->optionCaption(trim($arwrk[$ari])));
            } else {
                $this->ISRJ->ViewValue = null;
            }
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
            $this->sell_price->ViewValue = FormatNumber($this->sell_price->ViewValue, 0, -2, -2, -2);
            $this->sell_price->ViewCustomAttributes = "";

            // diskon
            $this->diskon->ViewValue = $this->diskon->CurrentValue;
            $this->diskon->ViewValue = FormatNumber($this->diskon->ViewValue, 0, -2, -2, -2);
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
            $this->POTONGAN->ViewValue = FormatNumber($this->POTONGAN->ViewValue, 0, -2, -2, -2);
            $this->POTONGAN->ViewCustomAttributes = "";

            // BAYAR
            $this->BAYAR->ViewValue = $this->BAYAR->CurrentValue;
            $this->BAYAR->ViewValue = FormatNumber($this->BAYAR->ViewValue, 0, -2, -2, -2);
            $this->BAYAR->ViewCustomAttributes = "";

            // RETUR
            $this->RETUR->ViewValue = $this->RETUR->CurrentValue;
            $this->RETUR->ViewValue = FormatNumber($this->RETUR->ViewValue, 0, -2, -2, -2);
            $this->RETUR->ViewCustomAttributes = "";

            // TARIF_TYPE
            $this->TARIF_TYPE->ViewValue = $this->TARIF_TYPE->CurrentValue;
            $this->TARIF_TYPE->ViewCustomAttributes = "";

            // PPNVALUE
            $this->PPNVALUE->ViewValue = $this->PPNVALUE->CurrentValue;
            $this->PPNVALUE->ViewValue = FormatNumber($this->PPNVALUE->ViewValue, 0, -2, -2, -2);
            $this->PPNVALUE->ViewCustomAttributes = "";

            // TAGIHAN
            $this->TAGIHAN->ViewValue = $this->TAGIHAN->CurrentValue;
            $this->TAGIHAN->ViewValue = FormatNumber($this->TAGIHAN->ViewValue, 0, -2, -2, -2);
            $this->TAGIHAN->ViewCustomAttributes = "";

            // KOREKSI
            $this->KOREKSI->ViewValue = $this->KOREKSI->CurrentValue;
            $this->KOREKSI->ViewValue = FormatNumber($this->KOREKSI->ViewValue, 0, -2, -2, -2);
            $this->KOREKSI->ViewCustomAttributes = "";

            // STATUS_OBAT
            $this->STATUS_OBAT->ViewValue = $this->STATUS_OBAT->CurrentValue;
            $this->STATUS_OBAT->ViewValue = FormatNumber($this->STATUS_OBAT->ViewValue, 0, -2, -2, -2);
            $this->STATUS_OBAT->ViewCustomAttributes = "";

            // SUBSIDISAT
            $this->SUBSIDISAT->ViewValue = $this->SUBSIDISAT->CurrentValue;
            $this->SUBSIDISAT->ViewValue = FormatNumber($this->SUBSIDISAT->ViewValue, 0, -2, -2, -2);
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
            $this->STOCK_AVAILABLE->ViewValue = FormatNumber($this->STOCK_AVAILABLE->ViewValue, 0, -2, -2, -2);
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
            $this->profession->ViewValue = FormatNumber($this->profession->ViewValue, 0, -2, -2, -2);
            $this->profession->ViewCustomAttributes = "";

            // THEORDER
            $this->THEORDER->ViewValue = $this->THEORDER->CurrentValue;
            $this->THEORDER->ViewValue = FormatNumber($this->THEORDER->ViewValue, 0, -2, -2, -2);
            $this->THEORDER->ViewCustomAttributes = "";

            // CASHIER
            $this->CASHIER->ViewValue = $this->CASHIER->CurrentValue;
            $this->CASHIER->ViewCustomAttributes = "";

            // SPPFEE
            $this->SPPFEE->ViewValue = $this->SPPFEE->CurrentValue;
            $this->SPPFEE->ViewCustomAttributes = "";

            // SPPBILL
            $this->SPPBILL->ViewValue = $this->SPPBILL->CurrentValue;
            $this->SPPBILL->ViewCustomAttributes = "";

            // SPPRJK
            $this->SPPRJK->ViewValue = $this->SPPRJK->CurrentValue;
            $this->SPPRJK->ViewCustomAttributes = "";

            // SPPJMN
            $this->SPPJMN->ViewValue = $this->SPPJMN->CurrentValue;
            $this->SPPJMN->ViewCustomAttributes = "";

            // SPPKASIR
            $this->SPPKASIR->ViewValue = $this->SPPKASIR->CurrentValue;
            $this->SPPKASIR->ViewCustomAttributes = "";

            // PERUJUK
            $this->PERUJUK->ViewValue = $this->PERUJUK->CurrentValue;
            $this->PERUJUK->ViewCustomAttributes = "";

            // PERUJUKFEE
            $this->PERUJUKFEE->ViewValue = $this->PERUJUKFEE->CurrentValue;
            $this->PERUJUKFEE->ViewValue = FormatNumber($this->PERUJUKFEE->ViewValue, 0, -2, -2, -2);
            $this->PERUJUKFEE->ViewCustomAttributes = "";

            // modified_datesys
            $this->modified_datesys->ViewValue = $this->modified_datesys->CurrentValue;
            $this->modified_datesys->ViewValue = FormatDateTime($this->modified_datesys->ViewValue, 11);
            $this->modified_datesys->ViewCustomAttributes = "";

            // TRANS_ID
            $this->TRANS_ID->ViewValue = $this->TRANS_ID->CurrentValue;
            $this->TRANS_ID->ViewCustomAttributes = "";

            // SPPBILLDATE
            $this->SPPBILLDATE->ViewValue = $this->SPPBILLDATE->CurrentValue;
            $this->SPPBILLDATE->ViewValue = FormatDateTime($this->SPPBILLDATE->ViewValue, 11);
            $this->SPPBILLDATE->ViewCustomAttributes = "";

            // SPPBILLUSER
            $this->SPPBILLUSER->ViewValue = $this->SPPBILLUSER->CurrentValue;
            $this->SPPBILLUSER->ViewCustomAttributes = "";

            // SPPKASIRDATE
            $this->SPPKASIRDATE->ViewValue = $this->SPPKASIRDATE->CurrentValue;
            $this->SPPKASIRDATE->ViewValue = FormatDateTime($this->SPPKASIRDATE->ViewValue, 11);
            $this->SPPKASIRDATE->ViewCustomAttributes = "";

            // SPPKASIRUSER
            $this->SPPKASIRUSER->ViewValue = $this->SPPKASIRUSER->CurrentValue;
            $this->SPPKASIRUSER->ViewCustomAttributes = "";

            // SPPPOLI
            $this->SPPPOLI->ViewValue = $this->SPPPOLI->CurrentValue;
            $this->SPPPOLI->ViewCustomAttributes = "";

            // SPPPOLIUSER
            $this->SPPPOLIUSER->ViewValue = $this->SPPPOLIUSER->CurrentValue;
            $this->SPPPOLIUSER->ViewCustomAttributes = "";

            // SPPPOLIDATE
            $this->SPPPOLIDATE->ViewValue = $this->SPPPOLIDATE->CurrentValue;
            $this->SPPPOLIDATE->ViewValue = FormatDateTime($this->SPPPOLIDATE->ViewValue, 11);
            $this->SPPPOLIDATE->ViewCustomAttributes = "";

            // nota_temp
            $this->nota_temp->ViewValue = $this->nota_temp->CurrentValue;
            $this->nota_temp->ViewCustomAttributes = "";

            // CLINIC_ID_TEMP
            $this->CLINIC_ID_TEMP->ViewValue = $this->CLINIC_ID_TEMP->CurrentValue;
            $this->CLINIC_ID_TEMP->ViewCustomAttributes = "";

            // NOSEP
            $this->NOSEP->ViewValue = $this->NOSEP->CurrentValue;
            $this->NOSEP->ViewCustomAttributes = "";

            // ID
            $this->ID->ViewValue = $this->ID->CurrentValue;
            $this->ID->ViewCustomAttributes = "";

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

            // AMOUNT
            $this->AMOUNT->LinkCustomAttributes = "";
            $this->AMOUNT->HrefValue = "";
            $this->AMOUNT->TooltipValue = "";

            // QUANTITY
            $this->QUANTITY->LinkCustomAttributes = "";
            $this->QUANTITY->HrefValue = "";
            $this->QUANTITY->TooltipValue = "";

            // ISLUNAS
            $this->ISLUNAS->LinkCustomAttributes = "";
            $this->ISLUNAS->HrefValue = "";
            $this->ISLUNAS->TooltipValue = "";

            // NOTA_NO
            $this->NOTA_NO->LinkCustomAttributes = "";
            $this->NOTA_NO->HrefValue = "";
            $this->NOTA_NO->TooltipValue = "";

            // EMPLOYEE_ID
            $this->EMPLOYEE_ID->LinkCustomAttributes = "";
            $this->EMPLOYEE_ID->HrefValue = "";
            $this->EMPLOYEE_ID->TooltipValue = "";

            // DOCTOR
            $this->DOCTOR->LinkCustomAttributes = "";
            $this->DOCTOR->HrefValue = "";
            $this->DOCTOR->TooltipValue = "";

            // amount_paid
            $this->amount_paid->LinkCustomAttributes = "";
            $this->amount_paid->HrefValue = "";
            $this->amount_paid->TooltipValue = "";

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

            // ISRJ
            $this->ISRJ->LinkCustomAttributes = "";
            $this->ISRJ->HrefValue = "";
            $this->ISRJ->TooltipValue = "";

            // sell_price
            $this->sell_price->LinkCustomAttributes = "";
            $this->sell_price->HrefValue = "";
            $this->sell_price->TooltipValue = "";

            // TAGIHAN
            $this->TAGIHAN->LinkCustomAttributes = "";
            $this->TAGIHAN->HrefValue = "";
            $this->TAGIHAN->TooltipValue = "";

            // TRANS_ID
            $this->TRANS_ID->LinkCustomAttributes = "";
            $this->TRANS_ID->HrefValue = "";
            $this->TRANS_ID->TooltipValue = "";
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

            // AMOUNT
            $this->AMOUNT->EditAttrs["class"] = "form-control";
            $this->AMOUNT->EditCustomAttributes = "";
            $this->AMOUNT->EditValue = HtmlEncode($this->AMOUNT->AdvancedSearch->SearchValue);
            $this->AMOUNT->PlaceHolder = RemoveHtml($this->AMOUNT->caption());

            // QUANTITY
            $this->QUANTITY->EditAttrs["class"] = "form-control";
            $this->QUANTITY->EditCustomAttributes = "";
            $this->QUANTITY->EditValue = HtmlEncode($this->QUANTITY->AdvancedSearch->SearchValue);
            $this->QUANTITY->PlaceHolder = RemoveHtml($this->QUANTITY->caption());

            // ISLUNAS
            $this->ISLUNAS->EditCustomAttributes = "";
            $this->ISLUNAS->EditValue = $this->ISLUNAS->options(false);
            $this->ISLUNAS->PlaceHolder = RemoveHtml($this->ISLUNAS->caption());

            // NOTA_NO
            $this->NOTA_NO->EditAttrs["class"] = "form-control";
            $this->NOTA_NO->EditCustomAttributes = "";
            if (!$this->NOTA_NO->Raw) {
                $this->NOTA_NO->AdvancedSearch->SearchValue = HtmlDecode($this->NOTA_NO->AdvancedSearch->SearchValue);
            }
            $this->NOTA_NO->EditValue = HtmlEncode($this->NOTA_NO->AdvancedSearch->SearchValue);
            $this->NOTA_NO->PlaceHolder = RemoveHtml($this->NOTA_NO->caption());

            // EMPLOYEE_ID
            $this->EMPLOYEE_ID->EditAttrs["class"] = "form-control";
            $this->EMPLOYEE_ID->EditCustomAttributes = "";
            $this->EMPLOYEE_ID->PlaceHolder = RemoveHtml($this->EMPLOYEE_ID->caption());

            // DOCTOR
            $this->DOCTOR->EditAttrs["class"] = "form-control";
            $this->DOCTOR->EditCustomAttributes = "";
            if (!$this->DOCTOR->Raw) {
                $this->DOCTOR->AdvancedSearch->SearchValue = HtmlDecode($this->DOCTOR->AdvancedSearch->SearchValue);
            }
            $this->DOCTOR->EditValue = HtmlEncode($this->DOCTOR->AdvancedSearch->SearchValue);
            $this->DOCTOR->PlaceHolder = RemoveHtml($this->DOCTOR->caption());

            // amount_paid
            $this->amount_paid->EditAttrs["class"] = "form-control";
            $this->amount_paid->EditCustomAttributes = "";
            $this->amount_paid->EditValue = HtmlEncode($this->amount_paid->AdvancedSearch->SearchValue);
            $this->amount_paid->PlaceHolder = RemoveHtml($this->amount_paid->caption());

            // THENAME
            $this->THENAME->EditAttrs["class"] = "form-control";
            $this->THENAME->EditCustomAttributes = "";
            if (!$this->THENAME->Raw) {
                $this->THENAME->AdvancedSearch->SearchValue = HtmlDecode($this->THENAME->AdvancedSearch->SearchValue);
            }
            $this->THENAME->EditValue = HtmlEncode($this->THENAME->AdvancedSearch->SearchValue);
            $this->THENAME->PlaceHolder = RemoveHtml($this->THENAME->caption());

            // THEADDRESS
            $this->THEADDRESS->EditAttrs["class"] = "form-control";
            $this->THEADDRESS->EditCustomAttributes = "";
            if (!$this->THEADDRESS->Raw) {
                $this->THEADDRESS->AdvancedSearch->SearchValue = HtmlDecode($this->THEADDRESS->AdvancedSearch->SearchValue);
            }
            $this->THEADDRESS->EditValue = HtmlEncode($this->THEADDRESS->AdvancedSearch->SearchValue);
            $this->THEADDRESS->PlaceHolder = RemoveHtml($this->THEADDRESS->caption());

            // THEID
            $this->THEID->EditAttrs["class"] = "form-control";
            $this->THEID->EditCustomAttributes = "";
            if (!$this->THEID->Raw) {
                $this->THEID->AdvancedSearch->SearchValue = HtmlDecode($this->THEID->AdvancedSearch->SearchValue);
            }
            $this->THEID->EditValue = HtmlEncode($this->THEID->AdvancedSearch->SearchValue);
            $this->THEID->PlaceHolder = RemoveHtml($this->THEID->caption());

            // ISRJ
            $this->ISRJ->EditCustomAttributes = "";
            $this->ISRJ->EditValue = $this->ISRJ->options(false);
            $this->ISRJ->PlaceHolder = RemoveHtml($this->ISRJ->caption());

            // sell_price
            $this->sell_price->EditAttrs["class"] = "form-control";
            $this->sell_price->EditCustomAttributes = "";
            $this->sell_price->EditValue = HtmlEncode($this->sell_price->AdvancedSearch->SearchValue);
            $this->sell_price->PlaceHolder = RemoveHtml($this->sell_price->caption());

            // TAGIHAN
            $this->TAGIHAN->EditAttrs["class"] = "form-control";
            $this->TAGIHAN->EditCustomAttributes = "";
            $this->TAGIHAN->EditValue = HtmlEncode($this->TAGIHAN->AdvancedSearch->SearchValue);
            $this->TAGIHAN->PlaceHolder = RemoveHtml($this->TAGIHAN->caption());

            // TRANS_ID
            $this->TRANS_ID->EditAttrs["class"] = "form-control";
            $this->TRANS_ID->EditCustomAttributes = "";
            if (!$this->TRANS_ID->Raw) {
                $this->TRANS_ID->AdvancedSearch->SearchValue = HtmlDecode($this->TRANS_ID->AdvancedSearch->SearchValue);
            }
            $this->TRANS_ID->EditValue = HtmlEncode($this->TRANS_ID->AdvancedSearch->SearchValue);
            $this->TRANS_ID->PlaceHolder = RemoveHtml($this->TRANS_ID->caption());
        } elseif ($this->RowType == ROWTYPE_AGGREGATEINIT) { // Initialize aggregate row
                    $this->amount_paid->Total = 0; // Initialize total
        } elseif ($this->RowType == ROWTYPE_AGGREGATE) { // Aggregate row
            $this->amount_paid->CurrentValue = $this->amount_paid->Total;
            $this->amount_paid->ViewValue = $this->amount_paid->CurrentValue;
            $this->amount_paid->ViewValue = FormatNumber($this->amount_paid->ViewValue, 0, -2, -2, -2);
            $this->amount_paid->ViewCustomAttributes = "";
            $this->amount_paid->HrefValue = ""; // Clear href value
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

    // Load advanced search
    public function loadAdvancedSearch()
    {
        $this->ORG_UNIT_CODE->AdvancedSearch->load();
        $this->BILL_ID->AdvancedSearch->load();
        $this->NO_REGISTRATION->AdvancedSearch->load();
        $this->VISIT_ID->AdvancedSearch->load();
        $this->TARIF_ID->AdvancedSearch->load();
        $this->CLASS_ID->AdvancedSearch->load();
        $this->CLINIC_ID->AdvancedSearch->load();
        $this->CLINIC_ID_FROM->AdvancedSearch->load();
        $this->TREATMENT->AdvancedSearch->load();
        $this->TREAT_DATE->AdvancedSearch->load();
        $this->AMOUNT->AdvancedSearch->load();
        $this->QUANTITY->AdvancedSearch->load();
        $this->MEASURE_ID->AdvancedSearch->load();
        $this->POKOK_JUAL->AdvancedSearch->load();
        $this->PPN->AdvancedSearch->load();
        $this->MARGIN->AdvancedSearch->load();
        $this->SUBSIDI->AdvancedSearch->load();
        $this->EMBALACE->AdvancedSearch->load();
        $this->PROFESI->AdvancedSearch->load();
        $this->DISCOUNT->AdvancedSearch->load();
        $this->PAY_METHOD_ID->AdvancedSearch->load();
        $this->PAYMENT_DATE->AdvancedSearch->load();
        $this->ISLUNAS->AdvancedSearch->load();
        $this->DUEDATE_ANGSURAN->AdvancedSearch->load();
        $this->DESCRIPTION->AdvancedSearch->load();
        $this->KUITANSI_ID->AdvancedSearch->load();
        $this->NOTA_NO->AdvancedSearch->load();
        $this->ISCETAK->AdvancedSearch->load();
        $this->PRINT_DATE->AdvancedSearch->load();
        $this->RESEP_NO->AdvancedSearch->load();
        $this->RESEP_KE->AdvancedSearch->load();
        $this->DOSE->AdvancedSearch->load();
        $this->ORIG_DOSE->AdvancedSearch->load();
        $this->DOSE_PRESC->AdvancedSearch->load();
        $this->ITER->AdvancedSearch->load();
        $this->ITER_KE->AdvancedSearch->load();
        $this->SOLD_STATUS->AdvancedSearch->load();
        $this->RACIKAN->AdvancedSearch->load();
        $this->CLASS_ROOM_ID->AdvancedSearch->load();
        $this->KELUAR_ID->AdvancedSearch->load();
        $this->BED_ID->AdvancedSearch->load();
        $this->PERDA_ID->AdvancedSearch->load();
        $this->EMPLOYEE_ID->AdvancedSearch->load();
        $this->DESCRIPTION2->AdvancedSearch->load();
        $this->MODIFIED_BY->AdvancedSearch->load();
        $this->MODIFIED_DATE->AdvancedSearch->load();
        $this->MODIFIED_FROM->AdvancedSearch->load();
        $this->BRAND_ID->AdvancedSearch->load();
        $this->DOCTOR->AdvancedSearch->load();
        $this->JML_BKS->AdvancedSearch->load();
        $this->EXIT_DATE->AdvancedSearch->load();
        $this->FA_V->AdvancedSearch->load();
        $this->TASK_ID->AdvancedSearch->load();
        $this->EMPLOYEE_ID_FROM->AdvancedSearch->load();
        $this->DOCTOR_FROM->AdvancedSearch->load();
        $this->status_pasien_id->AdvancedSearch->load();
        $this->amount_paid->AdvancedSearch->load();
        $this->THENAME->AdvancedSearch->load();
        $this->THEADDRESS->AdvancedSearch->load();
        $this->THEID->AdvancedSearch->load();
        $this->serial_nb->AdvancedSearch->load();
        $this->TREATMENT_PLAFOND->AdvancedSearch->load();
        $this->AMOUNT_PLAFOND->AdvancedSearch->load();
        $this->AMOUNT_PAID_PLAFOND->AdvancedSearch->load();
        $this->CLASS_ID_PLAFOND->AdvancedSearch->load();
        $this->PAYOR_ID->AdvancedSearch->load();
        $this->PEMBULATAN->AdvancedSearch->load();
        $this->ISRJ->AdvancedSearch->load();
        $this->AGEYEAR->AdvancedSearch->load();
        $this->AGEMONTH->AdvancedSearch->load();
        $this->AGEDAY->AdvancedSearch->load();
        $this->GENDER->AdvancedSearch->load();
        $this->KAL_ID->AdvancedSearch->load();
        $this->CORRECTION_ID->AdvancedSearch->load();
        $this->CORRECTION_BY->AdvancedSearch->load();
        $this->KARYAWAN->AdvancedSearch->load();
        $this->ACCOUNT_ID->AdvancedSearch->load();
        $this->sell_price->AdvancedSearch->load();
        $this->diskon->AdvancedSearch->load();
        $this->INVOICE_ID->AdvancedSearch->load();
        $this->NUMER->AdvancedSearch->load();
        $this->MEASURE_ID2->AdvancedSearch->load();
        $this->POTONGAN->AdvancedSearch->load();
        $this->BAYAR->AdvancedSearch->load();
        $this->RETUR->AdvancedSearch->load();
        $this->TARIF_TYPE->AdvancedSearch->load();
        $this->PPNVALUE->AdvancedSearch->load();
        $this->TAGIHAN->AdvancedSearch->load();
        $this->KOREKSI->AdvancedSearch->load();
        $this->STATUS_OBAT->AdvancedSearch->load();
        $this->SUBSIDISAT->AdvancedSearch->load();
        $this->PRINTQ->AdvancedSearch->load();
        $this->PRINTED_BY->AdvancedSearch->load();
        $this->STOCK_AVAILABLE->AdvancedSearch->load();
        $this->STATUS_TARIF->AdvancedSearch->load();
        $this->CLINIC_TYPE->AdvancedSearch->load();
        $this->PACKAGE_ID->AdvancedSearch->load();
        $this->MODULE_ID->AdvancedSearch->load();
        $this->profession->AdvancedSearch->load();
        $this->THEORDER->AdvancedSearch->load();
        $this->CASHIER->AdvancedSearch->load();
        $this->SPPFEE->AdvancedSearch->load();
        $this->SPPBILL->AdvancedSearch->load();
        $this->SPPRJK->AdvancedSearch->load();
        $this->SPPJMN->AdvancedSearch->load();
        $this->SPPKASIR->AdvancedSearch->load();
        $this->PERUJUK->AdvancedSearch->load();
        $this->PERUJUKFEE->AdvancedSearch->load();
        $this->modified_datesys->AdvancedSearch->load();
        $this->TRANS_ID->AdvancedSearch->load();
        $this->SPPBILLDATE->AdvancedSearch->load();
        $this->SPPBILLUSER->AdvancedSearch->load();
        $this->SPPKASIRDATE->AdvancedSearch->load();
        $this->SPPKASIRUSER->AdvancedSearch->load();
        $this->SPPPOLI->AdvancedSearch->load();
        $this->SPPPOLIUSER->AdvancedSearch->load();
        $this->SPPPOLIDATE->AdvancedSearch->load();
        $this->nota_temp->AdvancedSearch->load();
        $this->CLINIC_ID_TEMP->AdvancedSearch->load();
        $this->NOSEP->AdvancedSearch->load();
        $this->ID->AdvancedSearch->load();
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
        $item->Body = "<a class=\"btn btn-default ew-search-toggle" . $searchToggleClass . "\" href=\"#\" role=\"button\" title=\"" . $Language->phrase("SearchPanel") . "\" data-caption=\"" . $Language->phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fTREATMENT_BILLlistsrch\" aria-pressed=\"" . ($searchToggleClass == " active" ? "true" : "false") . "\">" . $Language->phrase("SearchLink") . "</a>";
        $item->Visible = true;

        // Show all button
        $item = &$this->SearchOptions->add("showall");
        $item->Body = "<a class=\"btn btn-default ew-show-all\" title=\"" . $Language->phrase("ShowAll") . "\" data-caption=\"" . $Language->phrase("ShowAll") . "\" href=\"" . $pageUrl . "cmd=reset\">" . $Language->phrase("ShowAllBtn") . "</a>";
        $item->Visible = ($this->SearchWhere != $this->DefaultSearchWhere && $this->SearchWhere != "0=101");

        // Advanced search button
        $item = &$this->SearchOptions->add("advancedsearch");
        $item->Body = "<a class=\"btn btn-default ew-advanced-search\" title=\"" . $Language->phrase("AdvancedSearch") . "\" data-caption=\"" . $Language->phrase("AdvancedSearch") . "\" href=\"TreatmentBillSearch\">" . $Language->phrase("AdvancedSearchBtn") . "</a>";
        $item->Visible = true;

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
                case "x_ISLUNAS":
                    break;
                case "x_EMPLOYEE_ID":
                    break;
                case "x_ISRJ":
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
