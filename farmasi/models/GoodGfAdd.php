<?php

namespace PHPMaker2021\SIMRSFARMASI;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class GoodGfAdd extends GoodGf
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'GOOD_GF';

    // Page object name
    public $PageObjName = "GoodGfAdd";

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

        // Table object (GOOD_GF)
        if (!isset($GLOBALS["GOOD_GF"]) || get_class($GLOBALS["GOOD_GF"]) == PROJECT_NAMESPACE . "GOOD_GF") {
            $GLOBALS["GOOD_GF"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'GOOD_GF');
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
                $doc = new $class(Container("GOOD_GF"));
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
                    if ($pageName == "GoodGfView") {
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
        $this->ORG_UNIT_CODE->Visible = false;
        $this->ITEM_ID->Visible = false;
        $this->ORG_ID->Visible = false;
        $this->BATCH_NO->setVisibility();
        $this->BRAND_ID->setVisibility();
        $this->ROOMS_ID->setVisibility();
        $this->SHELF_NO->Visible = false;
        $this->EXPIRY_DATE->setVisibility();
        $this->SERIAL_NB->Visible = false;
        $this->FROM_ROOMS_ID->Visible = false;
        $this->ISOUTLET->setVisibility();
        $this->QUANTITY->setVisibility();
        $this->MEASURE_ID->Visible = false;
        $this->DISTRIBUTION_TYPE->Visible = false;
        $this->CONDITION->Visible = false;
        $this->ALLOCATED_DATE->Visible = false;
        $this->STOCKOPNAME_DATE->Visible = false;
        $this->INVOICE_ID->Visible = false;
        $this->ALLOCATED_FROM->setVisibility();
        $this->PRICE->Visible = false;
        $this->DISCOUNT->Visible = false;
        $this->DISCOUNT2->Visible = false;
        $this->DISCOUNTOFF->Visible = false;
        $this->ORG_UNIT_FROM->Visible = false;
        $this->ITEM_ID_FROM->Visible = false;
        $this->MODIFIED_DATE->Visible = false;
        $this->MODIFIED_BY->Visible = false;
        $this->STOCK_OPNAME->Visible = false;
        $this->STOK_AWAL->Visible = false;
        $this->STOCK_LALU->Visible = false;
        $this->STOCK_KOREKSI->Visible = false;
        $this->DITERIMA->Visible = false;
        $this->DISTRIBUSI->Visible = false;
        $this->DIJUAL->setVisibility();
        $this->DIHAPUS->Visible = false;
        $this->DIMINTA->Visible = false;
        $this->DIRETUR->Visible = false;
        $this->PO->Visible = false;
        $this->COMPANY_ID->Visible = false;
        $this->FUND_ID->Visible = false;
        $this->INVOICE_ID2->Visible = false;
        $this->MEASURE_ID3->Visible = false;
        $this->SIZE_KEMASAN->Visible = false;
        $this->BRAND_NAME->Visible = false;
        $this->MEASURE_ID2->Visible = false;
        $this->RETUR_ID->Visible = false;
        $this->SIZE_GOODS->Visible = false;
        $this->MEASURE_DOSIS->Visible = false;
        $this->ORDER_PRICE->Visible = false;
        $this->STOCK_AVAILABLE->Visible = false;
        $this->STATUS_PASIEN_ID->Visible = false;
        $this->MONTH_ID->Visible = false;
        $this->YEAR_ID->Visible = false;
        $this->CORRECTION_DOC->Visible = false;
        $this->CORRECTIONS->Visible = false;
        $this->CORRECTION_DATE->Visible = false;
        $this->DOC_NO->Visible = false;
        $this->ORDER_ID->Visible = false;
        $this->ISCETAK->Visible = false;
        $this->PRINT_DATE->Visible = false;
        $this->PRINTED_BY->Visible = false;
        $this->PRINTQ->Visible = false;
        $this->avgprice->Visible = false;
        $this->idx->Visible = false;
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
            if (($keyValue = Get("ORG_UNIT_CODE") ?? Route("ORG_UNIT_CODE")) !== null) {
                $this->ORG_UNIT_CODE->setQueryStringValue($keyValue);
            }
            if (($keyValue = Get("ITEM_ID") ?? Route("ITEM_ID")) !== null) {
                $this->ITEM_ID->setQueryStringValue($keyValue);
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

        // Set up master/detail parameters
        // NOTE: must be after loadOldRecord to prevent master key values overwritten
        $this->setupMasterParms();

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
                    $this->terminate("GoodGfList"); // No matching record, return to list
                    return;
                }
                break;
            case "insert": // Add new record
                $this->SendEmail = true; // Send email on add success
                if ($this->addRow($this->OldRecordset)) { // Add successful
                    if ($this->getSuccessMessage() == "" && Post("addopt") != "1") { // Skip success message for addopt (done in JavaScript)
                        $this->setSuccessMessage($Language->phrase("AddSuccess")); // Set up success message
                    }
                    $returnUrl = $this->getReturnUrl();
                    if (GetPageName($returnUrl) == "GoodGfList") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "GoodGfView") {
                        $returnUrl = $this->getViewUrl(); // View page, return to View page with keyurl directly
                    }
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
        $this->ITEM_ID->CurrentValue = null;
        $this->ITEM_ID->OldValue = $this->ITEM_ID->CurrentValue;
        $this->ORG_ID->CurrentValue = null;
        $this->ORG_ID->OldValue = $this->ORG_ID->CurrentValue;
        $this->BATCH_NO->CurrentValue = null;
        $this->BATCH_NO->OldValue = $this->BATCH_NO->CurrentValue;
        $this->BRAND_ID->CurrentValue = null;
        $this->BRAND_ID->OldValue = $this->BRAND_ID->CurrentValue;
        $this->ROOMS_ID->CurrentValue = null;
        $this->ROOMS_ID->OldValue = $this->ROOMS_ID->CurrentValue;
        $this->SHELF_NO->CurrentValue = null;
        $this->SHELF_NO->OldValue = $this->SHELF_NO->CurrentValue;
        $this->EXPIRY_DATE->CurrentValue = null;
        $this->EXPIRY_DATE->OldValue = $this->EXPIRY_DATE->CurrentValue;
        $this->SERIAL_NB->CurrentValue = null;
        $this->SERIAL_NB->OldValue = $this->SERIAL_NB->CurrentValue;
        $this->FROM_ROOMS_ID->CurrentValue = null;
        $this->FROM_ROOMS_ID->OldValue = $this->FROM_ROOMS_ID->CurrentValue;
        $this->ISOUTLET->CurrentValue = null;
        $this->ISOUTLET->OldValue = $this->ISOUTLET->CurrentValue;
        $this->QUANTITY->CurrentValue = null;
        $this->QUANTITY->OldValue = $this->QUANTITY->CurrentValue;
        $this->MEASURE_ID->CurrentValue = null;
        $this->MEASURE_ID->OldValue = $this->MEASURE_ID->CurrentValue;
        $this->DISTRIBUTION_TYPE->CurrentValue = null;
        $this->DISTRIBUTION_TYPE->OldValue = $this->DISTRIBUTION_TYPE->CurrentValue;
        $this->CONDITION->CurrentValue = null;
        $this->CONDITION->OldValue = $this->CONDITION->CurrentValue;
        $this->ALLOCATED_DATE->CurrentValue = null;
        $this->ALLOCATED_DATE->OldValue = $this->ALLOCATED_DATE->CurrentValue;
        $this->STOCKOPNAME_DATE->CurrentValue = null;
        $this->STOCKOPNAME_DATE->OldValue = $this->STOCKOPNAME_DATE->CurrentValue;
        $this->INVOICE_ID->CurrentValue = null;
        $this->INVOICE_ID->OldValue = $this->INVOICE_ID->CurrentValue;
        $this->ALLOCATED_FROM->CurrentValue = null;
        $this->ALLOCATED_FROM->OldValue = $this->ALLOCATED_FROM->CurrentValue;
        $this->PRICE->CurrentValue = null;
        $this->PRICE->OldValue = $this->PRICE->CurrentValue;
        $this->DISCOUNT->CurrentValue = null;
        $this->DISCOUNT->OldValue = $this->DISCOUNT->CurrentValue;
        $this->DISCOUNT2->CurrentValue = null;
        $this->DISCOUNT2->OldValue = $this->DISCOUNT2->CurrentValue;
        $this->DISCOUNTOFF->CurrentValue = null;
        $this->DISCOUNTOFF->OldValue = $this->DISCOUNTOFF->CurrentValue;
        $this->ORG_UNIT_FROM->CurrentValue = null;
        $this->ORG_UNIT_FROM->OldValue = $this->ORG_UNIT_FROM->CurrentValue;
        $this->ITEM_ID_FROM->CurrentValue = null;
        $this->ITEM_ID_FROM->OldValue = $this->ITEM_ID_FROM->CurrentValue;
        $this->MODIFIED_DATE->CurrentValue = null;
        $this->MODIFIED_DATE->OldValue = $this->MODIFIED_DATE->CurrentValue;
        $this->MODIFIED_BY->CurrentValue = null;
        $this->MODIFIED_BY->OldValue = $this->MODIFIED_BY->CurrentValue;
        $this->STOCK_OPNAME->CurrentValue = null;
        $this->STOCK_OPNAME->OldValue = $this->STOCK_OPNAME->CurrentValue;
        $this->STOK_AWAL->CurrentValue = null;
        $this->STOK_AWAL->OldValue = $this->STOK_AWAL->CurrentValue;
        $this->STOCK_LALU->CurrentValue = null;
        $this->STOCK_LALU->OldValue = $this->STOCK_LALU->CurrentValue;
        $this->STOCK_KOREKSI->CurrentValue = null;
        $this->STOCK_KOREKSI->OldValue = $this->STOCK_KOREKSI->CurrentValue;
        $this->DITERIMA->CurrentValue = null;
        $this->DITERIMA->OldValue = $this->DITERIMA->CurrentValue;
        $this->DISTRIBUSI->CurrentValue = null;
        $this->DISTRIBUSI->OldValue = $this->DISTRIBUSI->CurrentValue;
        $this->DIJUAL->CurrentValue = null;
        $this->DIJUAL->OldValue = $this->DIJUAL->CurrentValue;
        $this->DIHAPUS->CurrentValue = null;
        $this->DIHAPUS->OldValue = $this->DIHAPUS->CurrentValue;
        $this->DIMINTA->CurrentValue = null;
        $this->DIMINTA->OldValue = $this->DIMINTA->CurrentValue;
        $this->DIRETUR->CurrentValue = null;
        $this->DIRETUR->OldValue = $this->DIRETUR->CurrentValue;
        $this->PO->CurrentValue = null;
        $this->PO->OldValue = $this->PO->CurrentValue;
        $this->COMPANY_ID->CurrentValue = null;
        $this->COMPANY_ID->OldValue = $this->COMPANY_ID->CurrentValue;
        $this->FUND_ID->CurrentValue = null;
        $this->FUND_ID->OldValue = $this->FUND_ID->CurrentValue;
        $this->INVOICE_ID2->CurrentValue = null;
        $this->INVOICE_ID2->OldValue = $this->INVOICE_ID2->CurrentValue;
        $this->MEASURE_ID3->CurrentValue = null;
        $this->MEASURE_ID3->OldValue = $this->MEASURE_ID3->CurrentValue;
        $this->SIZE_KEMASAN->CurrentValue = null;
        $this->SIZE_KEMASAN->OldValue = $this->SIZE_KEMASAN->CurrentValue;
        $this->BRAND_NAME->CurrentValue = null;
        $this->BRAND_NAME->OldValue = $this->BRAND_NAME->CurrentValue;
        $this->MEASURE_ID2->CurrentValue = null;
        $this->MEASURE_ID2->OldValue = $this->MEASURE_ID2->CurrentValue;
        $this->RETUR_ID->CurrentValue = null;
        $this->RETUR_ID->OldValue = $this->RETUR_ID->CurrentValue;
        $this->SIZE_GOODS->CurrentValue = null;
        $this->SIZE_GOODS->OldValue = $this->SIZE_GOODS->CurrentValue;
        $this->MEASURE_DOSIS->CurrentValue = null;
        $this->MEASURE_DOSIS->OldValue = $this->MEASURE_DOSIS->CurrentValue;
        $this->ORDER_PRICE->CurrentValue = null;
        $this->ORDER_PRICE->OldValue = $this->ORDER_PRICE->CurrentValue;
        $this->STOCK_AVAILABLE->CurrentValue = null;
        $this->STOCK_AVAILABLE->OldValue = $this->STOCK_AVAILABLE->CurrentValue;
        $this->STATUS_PASIEN_ID->CurrentValue = null;
        $this->STATUS_PASIEN_ID->OldValue = $this->STATUS_PASIEN_ID->CurrentValue;
        $this->MONTH_ID->CurrentValue = null;
        $this->MONTH_ID->OldValue = $this->MONTH_ID->CurrentValue;
        $this->YEAR_ID->CurrentValue = null;
        $this->YEAR_ID->OldValue = $this->YEAR_ID->CurrentValue;
        $this->CORRECTION_DOC->CurrentValue = null;
        $this->CORRECTION_DOC->OldValue = $this->CORRECTION_DOC->CurrentValue;
        $this->CORRECTIONS->CurrentValue = null;
        $this->CORRECTIONS->OldValue = $this->CORRECTIONS->CurrentValue;
        $this->CORRECTION_DATE->CurrentValue = null;
        $this->CORRECTION_DATE->OldValue = $this->CORRECTION_DATE->CurrentValue;
        $this->DOC_NO->CurrentValue = null;
        $this->DOC_NO->OldValue = $this->DOC_NO->CurrentValue;
        $this->ORDER_ID->CurrentValue = null;
        $this->ORDER_ID->OldValue = $this->ORDER_ID->CurrentValue;
        $this->ISCETAK->CurrentValue = null;
        $this->ISCETAK->OldValue = $this->ISCETAK->CurrentValue;
        $this->PRINT_DATE->CurrentValue = null;
        $this->PRINT_DATE->OldValue = $this->PRINT_DATE->CurrentValue;
        $this->PRINTED_BY->CurrentValue = null;
        $this->PRINTED_BY->OldValue = $this->PRINTED_BY->CurrentValue;
        $this->PRINTQ->CurrentValue = null;
        $this->PRINTQ->OldValue = $this->PRINTQ->CurrentValue;
        $this->avgprice->CurrentValue = null;
        $this->avgprice->OldValue = $this->avgprice->CurrentValue;
        $this->idx->CurrentValue = null;
        $this->idx->OldValue = $this->idx->CurrentValue;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;

        // Check field name 'BATCH_NO' first before field var 'x_BATCH_NO'
        $val = $CurrentForm->hasValue("BATCH_NO") ? $CurrentForm->getValue("BATCH_NO") : $CurrentForm->getValue("x_BATCH_NO");
        if (!$this->BATCH_NO->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->BATCH_NO->Visible = false; // Disable update for API request
            } else {
                $this->BATCH_NO->setFormValue($val);
            }
        }

        // Check field name 'BRAND_ID' first before field var 'x_BRAND_ID'
        $val = $CurrentForm->hasValue("BRAND_ID") ? $CurrentForm->getValue("BRAND_ID") : $CurrentForm->getValue("x_BRAND_ID");
        if (!$this->BRAND_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->BRAND_ID->Visible = false; // Disable update for API request
            } else {
                $this->BRAND_ID->setFormValue($val);
            }
        }

        // Check field name 'ROOMS_ID' first before field var 'x_ROOMS_ID'
        $val = $CurrentForm->hasValue("ROOMS_ID") ? $CurrentForm->getValue("ROOMS_ID") : $CurrentForm->getValue("x_ROOMS_ID");
        if (!$this->ROOMS_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ROOMS_ID->Visible = false; // Disable update for API request
            } else {
                $this->ROOMS_ID->setFormValue($val);
            }
        }

        // Check field name 'EXPIRY_DATE' first before field var 'x_EXPIRY_DATE'
        $val = $CurrentForm->hasValue("EXPIRY_DATE") ? $CurrentForm->getValue("EXPIRY_DATE") : $CurrentForm->getValue("x_EXPIRY_DATE");
        if (!$this->EXPIRY_DATE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->EXPIRY_DATE->Visible = false; // Disable update for API request
            } else {
                $this->EXPIRY_DATE->setFormValue($val);
            }
            $this->EXPIRY_DATE->CurrentValue = UnFormatDateTime($this->EXPIRY_DATE->CurrentValue, 0);
        }

        // Check field name 'ISOUTLET' first before field var 'x_ISOUTLET'
        $val = $CurrentForm->hasValue("ISOUTLET") ? $CurrentForm->getValue("ISOUTLET") : $CurrentForm->getValue("x_ISOUTLET");
        if (!$this->ISOUTLET->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ISOUTLET->Visible = false; // Disable update for API request
            } else {
                $this->ISOUTLET->setFormValue($val);
            }
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

        // Check field name 'ALLOCATED_FROM' first before field var 'x_ALLOCATED_FROM'
        $val = $CurrentForm->hasValue("ALLOCATED_FROM") ? $CurrentForm->getValue("ALLOCATED_FROM") : $CurrentForm->getValue("x_ALLOCATED_FROM");
        if (!$this->ALLOCATED_FROM->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ALLOCATED_FROM->Visible = false; // Disable update for API request
            } else {
                $this->ALLOCATED_FROM->setFormValue($val);
            }
        }

        // Check field name 'DIJUAL' first before field var 'x_DIJUAL'
        $val = $CurrentForm->hasValue("DIJUAL") ? $CurrentForm->getValue("DIJUAL") : $CurrentForm->getValue("x_DIJUAL");
        if (!$this->DIJUAL->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->DIJUAL->Visible = false; // Disable update for API request
            } else {
                $this->DIJUAL->setFormValue($val);
            }
        }

        // Check field name 'ORG_UNIT_CODE' first before field var 'x_ORG_UNIT_CODE'
        $val = $CurrentForm->hasValue("ORG_UNIT_CODE") ? $CurrentForm->getValue("ORG_UNIT_CODE") : $CurrentForm->getValue("x_ORG_UNIT_CODE");
        if (!$this->ORG_UNIT_CODE->IsDetailKey) {
            $this->ORG_UNIT_CODE->setFormValue($val);
        }

        // Check field name 'ITEM_ID' first before field var 'x_ITEM_ID'
        $val = $CurrentForm->hasValue("ITEM_ID") ? $CurrentForm->getValue("ITEM_ID") : $CurrentForm->getValue("x_ITEM_ID");
        if (!$this->ITEM_ID->IsDetailKey) {
            $this->ITEM_ID->setFormValue($val);
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
                        $this->ORG_UNIT_CODE->CurrentValue = $this->ORG_UNIT_CODE->FormValue;
                        $this->ITEM_ID->CurrentValue = $this->ITEM_ID->FormValue;
        $this->BATCH_NO->CurrentValue = $this->BATCH_NO->FormValue;
        $this->BRAND_ID->CurrentValue = $this->BRAND_ID->FormValue;
        $this->ROOMS_ID->CurrentValue = $this->ROOMS_ID->FormValue;
        $this->EXPIRY_DATE->CurrentValue = $this->EXPIRY_DATE->FormValue;
        $this->EXPIRY_DATE->CurrentValue = UnFormatDateTime($this->EXPIRY_DATE->CurrentValue, 0);
        $this->ISOUTLET->CurrentValue = $this->ISOUTLET->FormValue;
        $this->QUANTITY->CurrentValue = $this->QUANTITY->FormValue;
        $this->ALLOCATED_FROM->CurrentValue = $this->ALLOCATED_FROM->FormValue;
        $this->DIJUAL->CurrentValue = $this->DIJUAL->FormValue;
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
        $this->DISCOUNT->setDbValue($row['DISCOUNT']);
        $this->DISCOUNT2->setDbValue($row['DISCOUNT2']);
        $this->DISCOUNTOFF->setDbValue($row['DISCOUNTOFF']);
        $this->ORG_UNIT_FROM->setDbValue($row['ORG_UNIT_FROM']);
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
        $this->RETUR_ID->setDbValue($row['RETUR_ID']);
        $this->SIZE_GOODS->setDbValue($row['SIZE_GOODS']);
        $this->MEASURE_DOSIS->setDbValue($row['MEASURE_DOSIS']);
        $this->ORDER_PRICE->setDbValue($row['ORDER_PRICE']);
        $this->STOCK_AVAILABLE->setDbValue($row['STOCK_AVAILABLE']);
        $this->STATUS_PASIEN_ID->setDbValue($row['STATUS_PASIEN_ID']);
        $this->MONTH_ID->setDbValue($row['MONTH_ID']);
        $this->YEAR_ID->setDbValue($row['YEAR_ID']);
        $this->CORRECTION_DOC->setDbValue($row['CORRECTION_DOC']);
        $this->CORRECTIONS->setDbValue($row['CORRECTIONS']);
        $this->CORRECTION_DATE->setDbValue($row['CORRECTION_DATE']);
        $this->DOC_NO->setDbValue($row['DOC_NO']);
        $this->ORDER_ID->setDbValue($row['ORDER_ID']);
        $this->ISCETAK->setDbValue($row['ISCETAK']);
        $this->PRINT_DATE->setDbValue($row['PRINT_DATE']);
        $this->PRINTED_BY->setDbValue($row['PRINTED_BY']);
        $this->PRINTQ->setDbValue($row['PRINTQ']);
        $this->avgprice->setDbValue($row['avgprice']);
        $this->idx->setDbValue($row['idx']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $this->loadDefaultValues();
        $row = [];
        $row['ORG_UNIT_CODE'] = $this->ORG_UNIT_CODE->CurrentValue;
        $row['ITEM_ID'] = $this->ITEM_ID->CurrentValue;
        $row['ORG_ID'] = $this->ORG_ID->CurrentValue;
        $row['BATCH_NO'] = $this->BATCH_NO->CurrentValue;
        $row['BRAND_ID'] = $this->BRAND_ID->CurrentValue;
        $row['ROOMS_ID'] = $this->ROOMS_ID->CurrentValue;
        $row['SHELF_NO'] = $this->SHELF_NO->CurrentValue;
        $row['EXPIRY_DATE'] = $this->EXPIRY_DATE->CurrentValue;
        $row['SERIAL_NB'] = $this->SERIAL_NB->CurrentValue;
        $row['FROM_ROOMS_ID'] = $this->FROM_ROOMS_ID->CurrentValue;
        $row['ISOUTLET'] = $this->ISOUTLET->CurrentValue;
        $row['QUANTITY'] = $this->QUANTITY->CurrentValue;
        $row['MEASURE_ID'] = $this->MEASURE_ID->CurrentValue;
        $row['DISTRIBUTION_TYPE'] = $this->DISTRIBUTION_TYPE->CurrentValue;
        $row['CONDITION'] = $this->CONDITION->CurrentValue;
        $row['ALLOCATED_DATE'] = $this->ALLOCATED_DATE->CurrentValue;
        $row['STOCKOPNAME_DATE'] = $this->STOCKOPNAME_DATE->CurrentValue;
        $row['INVOICE_ID'] = $this->INVOICE_ID->CurrentValue;
        $row['ALLOCATED_FROM'] = $this->ALLOCATED_FROM->CurrentValue;
        $row['PRICE'] = $this->PRICE->CurrentValue;
        $row['DISCOUNT'] = $this->DISCOUNT->CurrentValue;
        $row['DISCOUNT2'] = $this->DISCOUNT2->CurrentValue;
        $row['DISCOUNTOFF'] = $this->DISCOUNTOFF->CurrentValue;
        $row['ORG_UNIT_FROM'] = $this->ORG_UNIT_FROM->CurrentValue;
        $row['ITEM_ID_FROM'] = $this->ITEM_ID_FROM->CurrentValue;
        $row['MODIFIED_DATE'] = $this->MODIFIED_DATE->CurrentValue;
        $row['MODIFIED_BY'] = $this->MODIFIED_BY->CurrentValue;
        $row['STOCK_OPNAME'] = $this->STOCK_OPNAME->CurrentValue;
        $row['STOK_AWAL'] = $this->STOK_AWAL->CurrentValue;
        $row['STOCK_LALU'] = $this->STOCK_LALU->CurrentValue;
        $row['STOCK_KOREKSI'] = $this->STOCK_KOREKSI->CurrentValue;
        $row['DITERIMA'] = $this->DITERIMA->CurrentValue;
        $row['DISTRIBUSI'] = $this->DISTRIBUSI->CurrentValue;
        $row['DIJUAL'] = $this->DIJUAL->CurrentValue;
        $row['DIHAPUS'] = $this->DIHAPUS->CurrentValue;
        $row['DIMINTA'] = $this->DIMINTA->CurrentValue;
        $row['DIRETUR'] = $this->DIRETUR->CurrentValue;
        $row['PO'] = $this->PO->CurrentValue;
        $row['COMPANY_ID'] = $this->COMPANY_ID->CurrentValue;
        $row['FUND_ID'] = $this->FUND_ID->CurrentValue;
        $row['INVOICE_ID2'] = $this->INVOICE_ID2->CurrentValue;
        $row['MEASURE_ID3'] = $this->MEASURE_ID3->CurrentValue;
        $row['SIZE_KEMASAN'] = $this->SIZE_KEMASAN->CurrentValue;
        $row['BRAND_NAME'] = $this->BRAND_NAME->CurrentValue;
        $row['MEASURE_ID2'] = $this->MEASURE_ID2->CurrentValue;
        $row['RETUR_ID'] = $this->RETUR_ID->CurrentValue;
        $row['SIZE_GOODS'] = $this->SIZE_GOODS->CurrentValue;
        $row['MEASURE_DOSIS'] = $this->MEASURE_DOSIS->CurrentValue;
        $row['ORDER_PRICE'] = $this->ORDER_PRICE->CurrentValue;
        $row['STOCK_AVAILABLE'] = $this->STOCK_AVAILABLE->CurrentValue;
        $row['STATUS_PASIEN_ID'] = $this->STATUS_PASIEN_ID->CurrentValue;
        $row['MONTH_ID'] = $this->MONTH_ID->CurrentValue;
        $row['YEAR_ID'] = $this->YEAR_ID->CurrentValue;
        $row['CORRECTION_DOC'] = $this->CORRECTION_DOC->CurrentValue;
        $row['CORRECTIONS'] = $this->CORRECTIONS->CurrentValue;
        $row['CORRECTION_DATE'] = $this->CORRECTION_DATE->CurrentValue;
        $row['DOC_NO'] = $this->DOC_NO->CurrentValue;
        $row['ORDER_ID'] = $this->ORDER_ID->CurrentValue;
        $row['ISCETAK'] = $this->ISCETAK->CurrentValue;
        $row['PRINT_DATE'] = $this->PRINT_DATE->CurrentValue;
        $row['PRINTED_BY'] = $this->PRINTED_BY->CurrentValue;
        $row['PRINTQ'] = $this->PRINTQ->CurrentValue;
        $row['avgprice'] = $this->avgprice->CurrentValue;
        $row['idx'] = $this->idx->CurrentValue;
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

        // Convert decimal values if posted back
        if ($this->QUANTITY->FormValue == $this->QUANTITY->CurrentValue && is_numeric(ConvertToFloatString($this->QUANTITY->CurrentValue))) {
            $this->QUANTITY->CurrentValue = ConvertToFloatString($this->QUANTITY->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->DIJUAL->FormValue == $this->DIJUAL->CurrentValue && is_numeric(ConvertToFloatString($this->DIJUAL->CurrentValue))) {
            $this->DIJUAL->CurrentValue = ConvertToFloatString($this->DIJUAL->CurrentValue);
        }

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // ORG_UNIT_CODE

        // ITEM_ID

        // ORG_ID

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

        // DISCOUNT

        // DISCOUNT2

        // DISCOUNTOFF

        // ORG_UNIT_FROM

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

        // RETUR_ID

        // SIZE_GOODS

        // MEASURE_DOSIS

        // ORDER_PRICE

        // STOCK_AVAILABLE

        // STATUS_PASIEN_ID

        // MONTH_ID

        // YEAR_ID

        // CORRECTION_DOC

        // CORRECTIONS

        // CORRECTION_DATE

        // DOC_NO

        // ORDER_ID

        // ISCETAK

        // PRINT_DATE

        // PRINTED_BY

        // PRINTQ

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

            // DISCOUNT
            $this->DISCOUNT->ViewValue = $this->DISCOUNT->CurrentValue;
            $this->DISCOUNT->ViewValue = FormatNumber($this->DISCOUNT->ViewValue, 2, -2, -2, -2);
            $this->DISCOUNT->ViewCustomAttributes = "";

            // DISCOUNT2
            $this->DISCOUNT2->ViewValue = $this->DISCOUNT2->CurrentValue;
            $this->DISCOUNT2->ViewValue = FormatNumber($this->DISCOUNT2->ViewValue, 2, -2, -2, -2);
            $this->DISCOUNT2->ViewCustomAttributes = "";

            // DISCOUNTOFF
            $this->DISCOUNTOFF->ViewValue = $this->DISCOUNTOFF->CurrentValue;
            $this->DISCOUNTOFF->ViewValue = FormatNumber($this->DISCOUNTOFF->ViewValue, 2, -2, -2, -2);
            $this->DISCOUNTOFF->ViewCustomAttributes = "";

            // ORG_UNIT_FROM
            $this->ORG_UNIT_FROM->ViewValue = $this->ORG_UNIT_FROM->CurrentValue;
            $this->ORG_UNIT_FROM->ViewCustomAttributes = "";

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

            // RETUR_ID
            $this->RETUR_ID->ViewValue = $this->RETUR_ID->CurrentValue;
            $this->RETUR_ID->ViewCustomAttributes = "";

            // SIZE_GOODS
            $this->SIZE_GOODS->ViewValue = $this->SIZE_GOODS->CurrentValue;
            $this->SIZE_GOODS->ViewValue = FormatNumber($this->SIZE_GOODS->ViewValue, 2, -2, -2, -2);
            $this->SIZE_GOODS->ViewCustomAttributes = "";

            // MEASURE_DOSIS
            $this->MEASURE_DOSIS->ViewValue = $this->MEASURE_DOSIS->CurrentValue;
            $this->MEASURE_DOSIS->ViewValue = FormatNumber($this->MEASURE_DOSIS->ViewValue, 0, -2, -2, -2);
            $this->MEASURE_DOSIS->ViewCustomAttributes = "";

            // ORDER_PRICE
            $this->ORDER_PRICE->ViewValue = $this->ORDER_PRICE->CurrentValue;
            $this->ORDER_PRICE->ViewValue = FormatNumber($this->ORDER_PRICE->ViewValue, 2, -2, -2, -2);
            $this->ORDER_PRICE->ViewCustomAttributes = "";

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

            // DOC_NO
            $this->DOC_NO->ViewValue = $this->DOC_NO->CurrentValue;
            $this->DOC_NO->ViewCustomAttributes = "";

            // ORDER_ID
            $this->ORDER_ID->ViewValue = $this->ORDER_ID->CurrentValue;
            $this->ORDER_ID->ViewCustomAttributes = "";

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

            // avgprice
            $this->avgprice->ViewValue = $this->avgprice->CurrentValue;
            $this->avgprice->ViewValue = FormatNumber($this->avgprice->ViewValue, 2, -2, -2, -2);
            $this->avgprice->ViewCustomAttributes = "";

            // idx
            $this->idx->ViewValue = $this->idx->CurrentValue;
            $this->idx->ViewValue = FormatNumber($this->idx->ViewValue, 0, -2, -2, -2);
            $this->idx->ViewCustomAttributes = "";

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

            // EXPIRY_DATE
            $this->EXPIRY_DATE->LinkCustomAttributes = "";
            $this->EXPIRY_DATE->HrefValue = "";
            $this->EXPIRY_DATE->TooltipValue = "";

            // ISOUTLET
            $this->ISOUTLET->LinkCustomAttributes = "";
            $this->ISOUTLET->HrefValue = "";
            $this->ISOUTLET->TooltipValue = "";

            // QUANTITY
            $this->QUANTITY->LinkCustomAttributes = "";
            $this->QUANTITY->HrefValue = "";
            $this->QUANTITY->TooltipValue = "";

            // ALLOCATED_FROM
            $this->ALLOCATED_FROM->LinkCustomAttributes = "";
            $this->ALLOCATED_FROM->HrefValue = "";
            $this->ALLOCATED_FROM->TooltipValue = "";

            // DIJUAL
            $this->DIJUAL->LinkCustomAttributes = "";
            $this->DIJUAL->HrefValue = "";
            $this->DIJUAL->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // BATCH_NO
            $this->BATCH_NO->EditAttrs["class"] = "form-control";
            $this->BATCH_NO->EditCustomAttributes = "";
            if (!$this->BATCH_NO->Raw) {
                $this->BATCH_NO->CurrentValue = HtmlDecode($this->BATCH_NO->CurrentValue);
            }
            $this->BATCH_NO->EditValue = HtmlEncode($this->BATCH_NO->CurrentValue);
            $this->BATCH_NO->PlaceHolder = RemoveHtml($this->BATCH_NO->caption());

            // BRAND_ID
            $this->BRAND_ID->EditAttrs["class"] = "form-control";
            $this->BRAND_ID->EditCustomAttributes = "";
            if (!$this->BRAND_ID->Raw) {
                $this->BRAND_ID->CurrentValue = HtmlDecode($this->BRAND_ID->CurrentValue);
            }
            $this->BRAND_ID->EditValue = HtmlEncode($this->BRAND_ID->CurrentValue);
            $this->BRAND_ID->PlaceHolder = RemoveHtml($this->BRAND_ID->caption());

            // ROOMS_ID
            $this->ROOMS_ID->EditAttrs["class"] = "form-control";
            $this->ROOMS_ID->EditCustomAttributes = "";
            if (!$this->ROOMS_ID->Raw) {
                $this->ROOMS_ID->CurrentValue = HtmlDecode($this->ROOMS_ID->CurrentValue);
            }
            $this->ROOMS_ID->EditValue = HtmlEncode($this->ROOMS_ID->CurrentValue);
            $this->ROOMS_ID->PlaceHolder = RemoveHtml($this->ROOMS_ID->caption());

            // EXPIRY_DATE
            $this->EXPIRY_DATE->EditAttrs["class"] = "form-control";
            $this->EXPIRY_DATE->EditCustomAttributes = "";
            $this->EXPIRY_DATE->EditValue = HtmlEncode(FormatDateTime($this->EXPIRY_DATE->CurrentValue, 8));
            $this->EXPIRY_DATE->PlaceHolder = RemoveHtml($this->EXPIRY_DATE->caption());

            // ISOUTLET
            $this->ISOUTLET->EditAttrs["class"] = "form-control";
            $this->ISOUTLET->EditCustomAttributes = "";
            if (!$this->ISOUTLET->Raw) {
                $this->ISOUTLET->CurrentValue = HtmlDecode($this->ISOUTLET->CurrentValue);
            }
            $this->ISOUTLET->EditValue = HtmlEncode($this->ISOUTLET->CurrentValue);
            $this->ISOUTLET->PlaceHolder = RemoveHtml($this->ISOUTLET->caption());

            // QUANTITY
            $this->QUANTITY->EditAttrs["class"] = "form-control";
            $this->QUANTITY->EditCustomAttributes = "";
            $this->QUANTITY->EditValue = HtmlEncode($this->QUANTITY->CurrentValue);
            $this->QUANTITY->PlaceHolder = RemoveHtml($this->QUANTITY->caption());
            if (strval($this->QUANTITY->EditValue) != "" && is_numeric($this->QUANTITY->EditValue)) {
                $this->QUANTITY->EditValue = FormatNumber($this->QUANTITY->EditValue, -2, -2, -2, -2);
            }

            // ALLOCATED_FROM
            $this->ALLOCATED_FROM->EditAttrs["class"] = "form-control";
            $this->ALLOCATED_FROM->EditCustomAttributes = "";
            if (!$this->ALLOCATED_FROM->Raw) {
                $this->ALLOCATED_FROM->CurrentValue = HtmlDecode($this->ALLOCATED_FROM->CurrentValue);
            }
            $this->ALLOCATED_FROM->EditValue = HtmlEncode($this->ALLOCATED_FROM->CurrentValue);
            $this->ALLOCATED_FROM->PlaceHolder = RemoveHtml($this->ALLOCATED_FROM->caption());

            // DIJUAL
            $this->DIJUAL->EditAttrs["class"] = "form-control";
            $this->DIJUAL->EditCustomAttributes = "";
            $this->DIJUAL->EditValue = HtmlEncode($this->DIJUAL->CurrentValue);
            $this->DIJUAL->PlaceHolder = RemoveHtml($this->DIJUAL->caption());
            if (strval($this->DIJUAL->EditValue) != "" && is_numeric($this->DIJUAL->EditValue)) {
                $this->DIJUAL->EditValue = FormatNumber($this->DIJUAL->EditValue, -2, -2, -2, -2);
            }

            // Add refer script

            // BATCH_NO
            $this->BATCH_NO->LinkCustomAttributes = "";
            $this->BATCH_NO->HrefValue = "";

            // BRAND_ID
            $this->BRAND_ID->LinkCustomAttributes = "";
            $this->BRAND_ID->HrefValue = "";

            // ROOMS_ID
            $this->ROOMS_ID->LinkCustomAttributes = "";
            $this->ROOMS_ID->HrefValue = "";

            // EXPIRY_DATE
            $this->EXPIRY_DATE->LinkCustomAttributes = "";
            $this->EXPIRY_DATE->HrefValue = "";

            // ISOUTLET
            $this->ISOUTLET->LinkCustomAttributes = "";
            $this->ISOUTLET->HrefValue = "";

            // QUANTITY
            $this->QUANTITY->LinkCustomAttributes = "";
            $this->QUANTITY->HrefValue = "";

            // ALLOCATED_FROM
            $this->ALLOCATED_FROM->LinkCustomAttributes = "";
            $this->ALLOCATED_FROM->HrefValue = "";

            // DIJUAL
            $this->DIJUAL->LinkCustomAttributes = "";
            $this->DIJUAL->HrefValue = "";
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
        if ($this->BATCH_NO->Required) {
            if (!$this->BATCH_NO->IsDetailKey && EmptyValue($this->BATCH_NO->FormValue)) {
                $this->BATCH_NO->addErrorMessage(str_replace("%s", $this->BATCH_NO->caption(), $this->BATCH_NO->RequiredErrorMessage));
            }
        }
        if ($this->BRAND_ID->Required) {
            if (!$this->BRAND_ID->IsDetailKey && EmptyValue($this->BRAND_ID->FormValue)) {
                $this->BRAND_ID->addErrorMessage(str_replace("%s", $this->BRAND_ID->caption(), $this->BRAND_ID->RequiredErrorMessage));
            }
        }
        if ($this->ROOMS_ID->Required) {
            if (!$this->ROOMS_ID->IsDetailKey && EmptyValue($this->ROOMS_ID->FormValue)) {
                $this->ROOMS_ID->addErrorMessage(str_replace("%s", $this->ROOMS_ID->caption(), $this->ROOMS_ID->RequiredErrorMessage));
            }
        }
        if ($this->EXPIRY_DATE->Required) {
            if (!$this->EXPIRY_DATE->IsDetailKey && EmptyValue($this->EXPIRY_DATE->FormValue)) {
                $this->EXPIRY_DATE->addErrorMessage(str_replace("%s", $this->EXPIRY_DATE->caption(), $this->EXPIRY_DATE->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->EXPIRY_DATE->FormValue)) {
            $this->EXPIRY_DATE->addErrorMessage($this->EXPIRY_DATE->getErrorMessage(false));
        }
        if ($this->ISOUTLET->Required) {
            if (!$this->ISOUTLET->IsDetailKey && EmptyValue($this->ISOUTLET->FormValue)) {
                $this->ISOUTLET->addErrorMessage(str_replace("%s", $this->ISOUTLET->caption(), $this->ISOUTLET->RequiredErrorMessage));
            }
        }
        if ($this->QUANTITY->Required) {
            if (!$this->QUANTITY->IsDetailKey && EmptyValue($this->QUANTITY->FormValue)) {
                $this->QUANTITY->addErrorMessage(str_replace("%s", $this->QUANTITY->caption(), $this->QUANTITY->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->QUANTITY->FormValue)) {
            $this->QUANTITY->addErrorMessage($this->QUANTITY->getErrorMessage(false));
        }
        if ($this->ALLOCATED_FROM->Required) {
            if (!$this->ALLOCATED_FROM->IsDetailKey && EmptyValue($this->ALLOCATED_FROM->FormValue)) {
                $this->ALLOCATED_FROM->addErrorMessage(str_replace("%s", $this->ALLOCATED_FROM->caption(), $this->ALLOCATED_FROM->RequiredErrorMessage));
            }
        }
        if ($this->DIJUAL->Required) {
            if (!$this->DIJUAL->IsDetailKey && EmptyValue($this->DIJUAL->FormValue)) {
                $this->DIJUAL->addErrorMessage(str_replace("%s", $this->DIJUAL->caption(), $this->DIJUAL->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->DIJUAL->FormValue)) {
            $this->DIJUAL->addErrorMessage($this->DIJUAL->getErrorMessage(false));
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

        // BATCH_NO
        $this->BATCH_NO->setDbValueDef($rsnew, $this->BATCH_NO->CurrentValue, null, false);

        // BRAND_ID
        $this->BRAND_ID->setDbValueDef($rsnew, $this->BRAND_ID->CurrentValue, "", false);

        // ROOMS_ID
        $this->ROOMS_ID->setDbValueDef($rsnew, $this->ROOMS_ID->CurrentValue, "", false);

        // EXPIRY_DATE
        $this->EXPIRY_DATE->setDbValueDef($rsnew, UnFormatDateTime($this->EXPIRY_DATE->CurrentValue, 0), null, false);

        // ISOUTLET
        $this->ISOUTLET->setDbValueDef($rsnew, $this->ISOUTLET->CurrentValue, null, false);

        // QUANTITY
        $this->QUANTITY->setDbValueDef($rsnew, $this->QUANTITY->CurrentValue, null, false);

        // ALLOCATED_FROM
        $this->ALLOCATED_FROM->setDbValueDef($rsnew, $this->ALLOCATED_FROM->CurrentValue, null, false);

        // DIJUAL
        $this->DIJUAL->setDbValueDef($rsnew, $this->DIJUAL->CurrentValue, null, false);

        // DOC_NO
        if ($this->DOC_NO->getSessionValue() != "") {
            $rsnew['DOC_NO'] = $this->DOC_NO->getSessionValue();
        }

        // ORDER_ID
        if ($this->ORDER_ID->getSessionValue() != "") {
            $rsnew['ORDER_ID'] = $this->ORDER_ID->getSessionValue();
        }

        // Call Row Inserting event
        $insertRow = $this->rowInserting($rsold, $rsnew);

        // Check if key value entered
        if ($insertRow && $this->ValidateKey && strval($rsnew['ORG_UNIT_CODE']) == "") {
            $this->setFailureMessage($Language->phrase("InvalidKeyValue"));
            $insertRow = false;
        }

        // Check if key value entered
        if ($insertRow && $this->ValidateKey && strval($rsnew['ITEM_ID']) == "") {
            $this->setFailureMessage($Language->phrase("InvalidKeyValue"));
            $insertRow = false;
        }

        // Check for duplicate key
        if ($insertRow && $this->ValidateKey) {
            $filter = $this->getRecordFilter($rsnew);
            $rsChk = $this->loadRs($filter)->fetch();
            if ($rsChk !== false) {
                $keyErrMsg = str_replace("%f", $filter, $Language->phrase("DupKey"));
                $this->setFailureMessage($keyErrMsg);
                $insertRow = false;
            }
        }
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
            if ($masterTblVar == "MUTATION_DOCS") {
                $validMaster = true;
                $masterTbl = Container("MUTATION_DOCS");
                if (($parm = Get("fk_ORDER_ID", Get("ORDER_ID"))) !== null) {
                    $masterTbl->ORDER_ID->setQueryStringValue($parm);
                    $this->ORDER_ID->setQueryStringValue($masterTbl->ORDER_ID->QueryStringValue);
                    $this->ORDER_ID->setSessionValue($this->ORDER_ID->QueryStringValue);
                } else {
                    $validMaster = false;
                }
                if (($parm = Get("fk_DOC_NO", Get("DOC_NO"))) !== null) {
                    $masterTbl->DOC_NO->setQueryStringValue($parm);
                    $this->DOC_NO->setQueryStringValue($masterTbl->DOC_NO->QueryStringValue);
                    $this->DOC_NO->setSessionValue($this->DOC_NO->QueryStringValue);
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
            if ($masterTblVar == "MUTATION_DOCS") {
                $validMaster = true;
                $masterTbl = Container("MUTATION_DOCS");
                if (($parm = Post("fk_ORDER_ID", Post("ORDER_ID"))) !== null) {
                    $masterTbl->ORDER_ID->setFormValue($parm);
                    $this->ORDER_ID->setFormValue($masterTbl->ORDER_ID->FormValue);
                    $this->ORDER_ID->setSessionValue($this->ORDER_ID->FormValue);
                } else {
                    $validMaster = false;
                }
                if (($parm = Post("fk_DOC_NO", Post("DOC_NO"))) !== null) {
                    $masterTbl->DOC_NO->setFormValue($parm);
                    $this->DOC_NO->setFormValue($masterTbl->DOC_NO->FormValue);
                    $this->DOC_NO->setSessionValue($this->DOC_NO->FormValue);
                } else {
                    $validMaster = false;
                }
            }
        }
        if ($validMaster) {
            // Save current master table
            $this->setCurrentMasterTable($masterTblVar);

            // Reset start record counter (new master key)
            if (!$this->isAddOrEdit()) {
                $this->StartRecord = 1;
                $this->setStartRecordNumber($this->StartRecord);
            }

            // Clear previous master key from Session
            if ($masterTblVar != "MUTATION_DOCS") {
                if ($this->ORDER_ID->CurrentValue == "") {
                    $this->ORDER_ID->setSessionValue("");
                }
                if ($this->DOC_NO->CurrentValue == "") {
                    $this->DOC_NO->setSessionValue("");
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("GoodGfList"), "", $this->TableVar, true);
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
