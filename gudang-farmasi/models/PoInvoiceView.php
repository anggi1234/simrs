<?php

namespace PHPMaker2021\SIMRSSQLSERVERGUDANGFARMASI;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class PoInvoiceView extends PoInvoice
{
    use MessagesTrait;

    // Page ID
    public $PageID = "view";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'PO_INVOICE';

    // Page object name
    public $PageObjName = "PoInvoiceView";

    // Rendering View
    public $RenderingView = false;

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
        if (($keyValue = Get("INVOICE_ID") ?? Route("INVOICE_ID")) !== null) {
            $this->RecKey["INVOICE_ID"] = $keyValue;
        }
        $this->ExportPrintUrl = $pageUrl . "export=print";
        $this->ExportHtmlUrl = $pageUrl . "export=html";
        $this->ExportExcelUrl = $pageUrl . "export=excel";
        $this->ExportWordUrl = $pageUrl . "export=word";
        $this->ExportXmlUrl = $pageUrl . "export=xml";
        $this->ExportCsvUrl = $pageUrl . "export=csv";
        $this->ExportPdfUrl = $pageUrl . "export=pdf";

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

        // Export options
        $this->ExportOptions = new ListOptions("div");
        $this->ExportOptions->TagClassName = "ew-export-option";

        // Other options
        if (!$this->OtherOptions) {
            $this->OtherOptions = new ListOptionsArray();
        }
        $this->OtherOptions["action"] = new ListOptions("div");
        $this->OtherOptions["action"]->TagClassName = "ew-action-option";
        $this->OtherOptions["detail"] = new ListOptions("div");
        $this->OtherOptions["detail"]->TagClassName = "ew-detail-option";
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

            // Handle modal response
            if ($this->IsModal) { // Show as modal
                $row = ["url" => GetUrl($url), "modal" => "1"];
                $pageName = GetPageName($url);
                if ($pageName != $this->getListUrl()) { // Not List page
                    $row["caption"] = $this->getModalCaption($pageName);
                    if ($pageName == "PoInvoiceView") {
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
    public $ExportOptions; // Export options
    public $OtherOptions; // Other options
    public $DisplayRecords = 1;
    public $DbMasterFilter;
    public $DbDetailFilter;
    public $StartRecord;
    public $StopRecord;
    public $TotalRecords = 0;
    public $RecordRange = 10;
    public $RecKey = [];
    public $IsModal = false;

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
        $this->CurrentAction = Param("action"); // Set up current action
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

        // Load current record
        $loadCurrentRecord = false;
        $returnUrl = "";
        $matchRecord = false;
        if ($this->isPageRequest()) { // Validate request
            if (($keyValue = Get("INVOICE_ID") ?? Route("INVOICE_ID")) !== null) {
                $this->INVOICE_ID->setQueryStringValue($keyValue);
                $this->RecKey["INVOICE_ID"] = $this->INVOICE_ID->QueryStringValue;
            } elseif (Post("INVOICE_ID") !== null) {
                $this->INVOICE_ID->setFormValue(Post("INVOICE_ID"));
                $this->RecKey["INVOICE_ID"] = $this->INVOICE_ID->FormValue;
            } elseif (IsApi() && ($keyValue = Key(0) ?? Route(2)) !== null) {
                $this->INVOICE_ID->setQueryStringValue($keyValue);
                $this->RecKey["INVOICE_ID"] = $this->INVOICE_ID->QueryStringValue;
            } else {
                $returnUrl = "PoInvoiceList"; // Return to list
            }

            // Get action
            $this->CurrentAction = "show"; // Display
            switch ($this->CurrentAction) {
                case "show": // Get a record to display

                    // Load record based on key
                    if (IsApi()) {
                        $filter = $this->getRecordFilter();
                        $this->CurrentFilter = $filter;
                        $sql = $this->getCurrentSql();
                        $conn = $this->getConnection();
                        $this->Recordset = LoadRecordset($sql, $conn);
                        $res = $this->Recordset && !$this->Recordset->EOF;
                    } else {
                        $res = $this->loadRow();
                    }
                    if (!$res) { // Load record based on key
                        if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "") {
                            $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
                        }
                        $returnUrl = "PoInvoiceList"; // No matching record, return to list
                    }
                    break;
            }
        } else {
            $returnUrl = "PoInvoiceList"; // Not page request, return to list
        }
        if ($returnUrl != "") {
            $this->terminate($returnUrl);
            return;
        }

        // Set up Breadcrumb
        if (!$this->isExport()) {
            $this->setupBreadcrumb();
        }

        // Render row
        $this->RowType = ROWTYPE_VIEW;
        $this->resetAttributes();
        $this->renderRow();

        // Normal return
        if (IsApi()) {
            $rows = $this->getRecordsFromRecordset($this->Recordset, true); // Get current record only
            $this->Recordset->close();
            WriteJson(["success" => true, $this->TableVar => $rows]);
            $this->terminate(true);
            return;
        }

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

    // Set up other options
    protected function setupOtherOptions()
    {
        global $Language, $Security;
        $options = &$this->OtherOptions;
        $option = $options["action"];

        // Add
        $item = &$option->add("add");
        $addcaption = HtmlTitle($Language->phrase("ViewPageAddLink"));
        if ($this->IsModal) {
            $item->Body = "<a class=\"ew-action ew-add\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"#\" onclick=\"return ew.modalDialogShow({lnk:this,url:'" . HtmlEncode(GetUrl($this->AddUrl)) . "'});\">" . $Language->phrase("ViewPageAddLink") . "</a>";
        } else {
            $item->Body = "<a class=\"ew-action ew-add\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . HtmlEncode(GetUrl($this->AddUrl)) . "\">" . $Language->phrase("ViewPageAddLink") . "</a>";
        }
        $item->Visible = ($this->AddUrl != "" && $Security->canAdd());

        // Edit
        $item = &$option->add("edit");
        $editcaption = HtmlTitle($Language->phrase("ViewPageEditLink"));
        if ($this->IsModal) {
            $item->Body = "<a class=\"ew-action ew-edit\" title=\"" . $editcaption . "\" data-caption=\"" . $editcaption . "\" href=\"#\" onclick=\"return ew.modalDialogShow({lnk:this,url:'" . HtmlEncode(GetUrl($this->EditUrl)) . "'});\">" . $Language->phrase("ViewPageEditLink") . "</a>";
        } else {
            $item->Body = "<a class=\"ew-action ew-edit\" title=\"" . $editcaption . "\" data-caption=\"" . $editcaption . "\" href=\"" . HtmlEncode(GetUrl($this->EditUrl)) . "\">" . $Language->phrase("ViewPageEditLink") . "</a>";
        }
        $item->Visible = ($this->EditUrl != "" && $Security->canEdit());

        // Copy
        $item = &$option->add("copy");
        $copycaption = HtmlTitle($Language->phrase("ViewPageCopyLink"));
        if ($this->IsModal) {
            $item->Body = "<a class=\"ew-action ew-copy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"#\" onclick=\"return ew.modalDialogShow({lnk:this,btn:'AddBtn',url:'" . HtmlEncode(GetUrl($this->CopyUrl)) . "'});\">" . $Language->phrase("ViewPageCopyLink") . "</a>";
        } else {
            $item->Body = "<a class=\"ew-action ew-copy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"" . HtmlEncode(GetUrl($this->CopyUrl)) . "\">" . $Language->phrase("ViewPageCopyLink") . "</a>";
        }
        $item->Visible = ($this->CopyUrl != "" && $Security->canAdd());

        // Delete
        $item = &$option->add("delete");
        if ($this->IsModal) { // Handle as inline delete
            $item->Body = "<a onclick=\"return ew.confirmDelete(this);\" class=\"ew-action ew-delete\" title=\"" . HtmlTitle($Language->phrase("ViewPageDeleteLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("ViewPageDeleteLink")) . "\" href=\"" . HtmlEncode(UrlAddQuery(GetUrl($this->DeleteUrl), "action=1")) . "\">" . $Language->phrase("ViewPageDeleteLink") . "</a>";
        } else {
            $item->Body = "<a class=\"ew-action ew-delete\" title=\"" . HtmlTitle($Language->phrase("ViewPageDeleteLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("ViewPageDeleteLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->DeleteUrl)) . "\">" . $Language->phrase("ViewPageDeleteLink") . "</a>";
        }
        $item->Visible = ($this->DeleteUrl != "" && $Security->canDelete());

        // Set up action default
        $option = $options["action"];
        $option->DropDownButtonPhrase = $Language->phrase("ButtonActions");
        $option->UseDropDownButton = false;
        $option->UseButtonGroup = true;
        $item = &$option->add($option->GroupOptionName);
        $item->Body = "";
        $item->Visible = false;
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

    // Render row values based on field settings
    public function renderRow()
    {
        global $Security, $Language, $CurrentLanguage;

        // Initialize URLs
        $this->AddUrl = $this->getAddUrl();
        $this->EditUrl = $this->getEditUrl();
        $this->CopyUrl = $this->getCopyUrl();
        $this->DeleteUrl = $this->getDeleteUrl();
        $this->ListUrl = $this->getListUrl();
        $this->setupOtherOptions();

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

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("PoInvoiceList"), "", $this->TableVar, true);
        $pageId = "view";
        $Breadcrumb->add("view", $pageId, $url);
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
}
