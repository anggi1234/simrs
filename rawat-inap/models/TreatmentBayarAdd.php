<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class TreatmentBayarAdd extends TreatmentBayar
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'TREATMENT_BAYAR';

    // Page object name
    public $PageObjName = "TreatmentBayarAdd";

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

        // Table object (TREATMENT_BAYAR)
        if (!isset($GLOBALS["TREATMENT_BAYAR"]) || get_class($GLOBALS["TREATMENT_BAYAR"]) == PROJECT_NAMESPACE . "TREATMENT_BAYAR") {
            $GLOBALS["TREATMENT_BAYAR"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'TREATMENT_BAYAR');
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
                $doc = new $class(Container("TREATMENT_BAYAR"));
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
                    if ($pageName == "TreatmentBayarView") {
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
        $this->amount_paid->setVisibility();
        $this->THENAME->setVisibility();
        $this->THEADDRESS->setVisibility();
        $this->THEID->setVisibility();
        $this->serial_nb->setVisibility();
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
        $this->SPPFEE->setVisibility();
        $this->SPPBILL->setVisibility();
        $this->SPPRJK->setVisibility();
        $this->SPPJMN->setVisibility();
        $this->SPPKASIR->setVisibility();
        $this->PERUJUK->setVisibility();
        $this->PERUJUKFEE->setVisibility();
        $this->modified_datesys->setVisibility();
        $this->TRANS_ID->setVisibility();
        $this->SPPBILLDATE->setVisibility();
        $this->SPPBILLUSER->setVisibility();
        $this->SPPKASIRDATE->setVisibility();
        $this->SPPKASIRUSER->setVisibility();
        $this->SPPPOLI->setVisibility();
        $this->SPPPOLIUSER->setVisibility();
        $this->SPPPOLIDATE->setVisibility();
        $this->ID->Visible = false;
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
            if (($keyValue = Get("ID") ?? Route("ID")) !== null) {
                $this->ID->setQueryStringValue($keyValue);
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
                    $this->terminate("TreatmentBayarList"); // No matching record, return to list
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
                    if (GetPageName($returnUrl) == "TreatmentBayarList") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "TreatmentBayarView") {
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
        $this->BILL_ID->CurrentValue = "(((CONVERT([varchar](4),datepart(year,getdate()),(0))+right(CONVERT([varchar](4),datepart(month,getdate())+(100),(0)),(2)))+right(CONVERT([varchar](3),datepart(day,getdate())+(100),(0)),(2)))+right(CONVERT([varchar](3),datepart(hour,getdate())+(100),(0)),(2)))+right(CONVERT([varchar](3),datepart(minute,getdate())+(100),(0)),(2)))+right(CONVERT([varchar](3),datepart(second,getdate())+(100),(0)),(2)))+left(newid(),(7";
        $this->NO_REGISTRATION->CurrentValue = null;
        $this->NO_REGISTRATION->OldValue = $this->NO_REGISTRATION->CurrentValue;
        $this->VISIT_ID->CurrentValue = null;
        $this->VISIT_ID->OldValue = $this->VISIT_ID->CurrentValue;
        $this->TARIF_ID->CurrentValue = null;
        $this->TARIF_ID->OldValue = $this->TARIF_ID->CurrentValue;
        $this->CLASS_ID->CurrentValue = 0;
        $this->CLINIC_ID->CurrentValue = null;
        $this->CLINIC_ID->OldValue = $this->CLINIC_ID->CurrentValue;
        $this->CLINIC_ID_FROM->CurrentValue = null;
        $this->CLINIC_ID_FROM->OldValue = $this->CLINIC_ID_FROM->CurrentValue;
        $this->TREATMENT->CurrentValue = null;
        $this->TREATMENT->OldValue = $this->TREATMENT->CurrentValue;
        $this->TREAT_DATE->CurrentValue = null;
        $this->TREAT_DATE->OldValue = $this->TREAT_DATE->CurrentValue;
        $this->AMOUNT->CurrentValue = null;
        $this->AMOUNT->OldValue = $this->AMOUNT->CurrentValue;
        $this->QUANTITY->CurrentValue = 1;
        $this->MEASURE_ID->CurrentValue = null;
        $this->MEASURE_ID->OldValue = $this->MEASURE_ID->CurrentValue;
        $this->POKOK_JUAL->CurrentValue = 0;
        $this->PPN->CurrentValue = 0;
        $this->MARGIN->CurrentValue = 0;
        $this->SUBSIDI->CurrentValue = 0;
        $this->EMBALACE->CurrentValue = 0;
        $this->PROFESI->CurrentValue = null;
        $this->PROFESI->OldValue = $this->PROFESI->CurrentValue;
        $this->DISCOUNT->CurrentValue = 0;
        $this->PAY_METHOD_ID->CurrentValue = 0;
        $this->PAYMENT_DATE->CurrentValue = null;
        $this->PAYMENT_DATE->OldValue = $this->PAYMENT_DATE->CurrentValue;
        $this->ISLUNAS->CurrentValue = "0";
        $this->DUEDATE_ANGSURAN->CurrentValue = null;
        $this->DUEDATE_ANGSURAN->OldValue = $this->DUEDATE_ANGSURAN->CurrentValue;
        $this->DESCRIPTION->CurrentValue = null;
        $this->DESCRIPTION->OldValue = $this->DESCRIPTION->CurrentValue;
        $this->KUITANSI_ID->CurrentValue = null;
        $this->KUITANSI_ID->OldValue = $this->KUITANSI_ID->CurrentValue;
        $this->NOTA_NO->CurrentValue = null;
        $this->NOTA_NO->OldValue = $this->NOTA_NO->CurrentValue;
        $this->ISCETAK->CurrentValue = "1";
        $this->PRINT_DATE->CurrentValue = null;
        $this->PRINT_DATE->OldValue = $this->PRINT_DATE->CurrentValue;
        $this->RESEP_NO->CurrentValue = null;
        $this->RESEP_NO->OldValue = $this->RESEP_NO->CurrentValue;
        $this->RESEP_KE->CurrentValue = null;
        $this->RESEP_KE->OldValue = $this->RESEP_KE->CurrentValue;
        $this->DOSE->CurrentValue = null;
        $this->DOSE->OldValue = $this->DOSE->CurrentValue;
        $this->ORIG_DOSE->CurrentValue = null;
        $this->ORIG_DOSE->OldValue = $this->ORIG_DOSE->CurrentValue;
        $this->DOSE_PRESC->CurrentValue = null;
        $this->DOSE_PRESC->OldValue = $this->DOSE_PRESC->CurrentValue;
        $this->ITER->CurrentValue = 6;
        $this->ITER_KE->CurrentValue = 1;
        $this->SOLD_STATUS->CurrentValue = 0;
        $this->RACIKAN->CurrentValue = 102;
        $this->CLASS_ROOM_ID->CurrentValue = null;
        $this->CLASS_ROOM_ID->OldValue = $this->CLASS_ROOM_ID->CurrentValue;
        $this->KELUAR_ID->CurrentValue = null;
        $this->KELUAR_ID->OldValue = $this->KELUAR_ID->CurrentValue;
        $this->BED_ID->CurrentValue = null;
        $this->BED_ID->OldValue = $this->BED_ID->CurrentValue;
        $this->PERDA_ID->CurrentValue = null;
        $this->PERDA_ID->OldValue = $this->PERDA_ID->CurrentValue;
        $this->EMPLOYEE_ID->CurrentValue = null;
        $this->EMPLOYEE_ID->OldValue = $this->EMPLOYEE_ID->CurrentValue;
        $this->DESCRIPTION2->CurrentValue = null;
        $this->DESCRIPTION2->OldValue = $this->DESCRIPTION2->CurrentValue;
        $this->MODIFIED_BY->CurrentValue = null;
        $this->MODIFIED_BY->OldValue = $this->MODIFIED_BY->CurrentValue;
        $this->MODIFIED_DATE->CurrentValue = "getdate()";
        $this->MODIFIED_FROM->CurrentValue = null;
        $this->MODIFIED_FROM->OldValue = $this->MODIFIED_FROM->CurrentValue;
        $this->BRAND_ID->CurrentValue = null;
        $this->BRAND_ID->OldValue = $this->BRAND_ID->CurrentValue;
        $this->DOCTOR->CurrentValue = null;
        $this->DOCTOR->OldValue = $this->DOCTOR->CurrentValue;
        $this->JML_BKS->CurrentValue = 1;
        $this->EXIT_DATE->CurrentValue = null;
        $this->EXIT_DATE->OldValue = $this->EXIT_DATE->CurrentValue;
        $this->FA_V->CurrentValue = null;
        $this->FA_V->OldValue = $this->FA_V->CurrentValue;
        $this->TASK_ID->CurrentValue = 51;
        $this->EMPLOYEE_ID_FROM->CurrentValue = null;
        $this->EMPLOYEE_ID_FROM->OldValue = $this->EMPLOYEE_ID_FROM->CurrentValue;
        $this->DOCTOR_FROM->CurrentValue = null;
        $this->DOCTOR_FROM->OldValue = $this->DOCTOR_FROM->CurrentValue;
        $this->status_pasien_id->CurrentValue = 1;
        $this->amount_paid->CurrentValue = 0;
        $this->THENAME->CurrentValue = null;
        $this->THENAME->OldValue = $this->THENAME->CurrentValue;
        $this->THEADDRESS->CurrentValue = null;
        $this->THEADDRESS->OldValue = $this->THEADDRESS->CurrentValue;
        $this->THEID->CurrentValue = null;
        $this->THEID->OldValue = $this->THEID->CurrentValue;
        $this->serial_nb->CurrentValue = null;
        $this->serial_nb->OldValue = $this->serial_nb->CurrentValue;
        $this->TREATMENT_PLAFOND->CurrentValue = null;
        $this->TREATMENT_PLAFOND->OldValue = $this->TREATMENT_PLAFOND->CurrentValue;
        $this->AMOUNT_PLAFOND->CurrentValue = 0;
        $this->AMOUNT_PAID_PLAFOND->CurrentValue = 0;
        $this->CLASS_ID_PLAFOND->CurrentValue = 0;
        $this->PAYOR_ID->CurrentValue = "0";
        $this->PEMBULATAN->CurrentValue = 0;
        $this->ISRJ->CurrentValue = "1";
        $this->AGEYEAR->CurrentValue = null;
        $this->AGEYEAR->OldValue = $this->AGEYEAR->CurrentValue;
        $this->AGEMONTH->CurrentValue = null;
        $this->AGEMONTH->OldValue = $this->AGEMONTH->CurrentValue;
        $this->AGEDAY->CurrentValue = null;
        $this->AGEDAY->OldValue = $this->AGEDAY->CurrentValue;
        $this->GENDER->CurrentValue = null;
        $this->GENDER->OldValue = $this->GENDER->CurrentValue;
        $this->KAL_ID->CurrentValue = null;
        $this->KAL_ID->OldValue = $this->KAL_ID->CurrentValue;
        $this->CORRECTION_ID->CurrentValue = null;
        $this->CORRECTION_ID->OldValue = $this->CORRECTION_ID->CurrentValue;
        $this->CORRECTION_BY->CurrentValue = null;
        $this->CORRECTION_BY->OldValue = $this->CORRECTION_BY->CurrentValue;
        $this->KARYAWAN->CurrentValue = null;
        $this->KARYAWAN->OldValue = $this->KARYAWAN->CurrentValue;
        $this->ACCOUNT_ID->CurrentValue = null;
        $this->ACCOUNT_ID->OldValue = $this->ACCOUNT_ID->CurrentValue;
        $this->sell_price->CurrentValue = null;
        $this->sell_price->OldValue = $this->sell_price->CurrentValue;
        $this->diskon->CurrentValue = null;
        $this->diskon->OldValue = $this->diskon->CurrentValue;
        $this->INVOICE_ID->CurrentValue = null;
        $this->INVOICE_ID->OldValue = $this->INVOICE_ID->CurrentValue;
        $this->NUMER->CurrentValue = null;
        $this->NUMER->OldValue = $this->NUMER->CurrentValue;
        $this->MEASURE_ID2->CurrentValue = null;
        $this->MEASURE_ID2->OldValue = $this->MEASURE_ID2->CurrentValue;
        $this->POTONGAN->CurrentValue = null;
        $this->POTONGAN->OldValue = $this->POTONGAN->CurrentValue;
        $this->BAYAR->CurrentValue = null;
        $this->BAYAR->OldValue = $this->BAYAR->CurrentValue;
        $this->RETUR->CurrentValue = null;
        $this->RETUR->OldValue = $this->RETUR->CurrentValue;
        $this->TARIF_TYPE->CurrentValue = null;
        $this->TARIF_TYPE->OldValue = $this->TARIF_TYPE->CurrentValue;
        $this->PPNVALUE->CurrentValue = null;
        $this->PPNVALUE->OldValue = $this->PPNVALUE->CurrentValue;
        $this->TAGIHAN->CurrentValue = null;
        $this->TAGIHAN->OldValue = $this->TAGIHAN->CurrentValue;
        $this->KOREKSI->CurrentValue = null;
        $this->KOREKSI->OldValue = $this->KOREKSI->CurrentValue;
        $this->STATUS_OBAT->CurrentValue = null;
        $this->STATUS_OBAT->OldValue = $this->STATUS_OBAT->CurrentValue;
        $this->SUBSIDISAT->CurrentValue = null;
        $this->SUBSIDISAT->OldValue = $this->SUBSIDISAT->CurrentValue;
        $this->PRINTQ->CurrentValue = null;
        $this->PRINTQ->OldValue = $this->PRINTQ->CurrentValue;
        $this->PRINTED_BY->CurrentValue = null;
        $this->PRINTED_BY->OldValue = $this->PRINTED_BY->CurrentValue;
        $this->STOCK_AVAILABLE->CurrentValue = null;
        $this->STOCK_AVAILABLE->OldValue = $this->STOCK_AVAILABLE->CurrentValue;
        $this->STATUS_TARIF->CurrentValue = null;
        $this->STATUS_TARIF->OldValue = $this->STATUS_TARIF->CurrentValue;
        $this->CLINIC_TYPE->CurrentValue = null;
        $this->CLINIC_TYPE->OldValue = $this->CLINIC_TYPE->CurrentValue;
        $this->PACKAGE_ID->CurrentValue = null;
        $this->PACKAGE_ID->OldValue = $this->PACKAGE_ID->CurrentValue;
        $this->MODULE_ID->CurrentValue = null;
        $this->MODULE_ID->OldValue = $this->MODULE_ID->CurrentValue;
        $this->profession->CurrentValue = null;
        $this->profession->OldValue = $this->profession->CurrentValue;
        $this->THEORDER->CurrentValue = null;
        $this->THEORDER->OldValue = $this->THEORDER->CurrentValue;
        $this->CASHIER->CurrentValue = null;
        $this->CASHIER->OldValue = $this->CASHIER->CurrentValue;
        $this->SPPFEE->CurrentValue = null;
        $this->SPPFEE->OldValue = $this->SPPFEE->CurrentValue;
        $this->SPPBILL->CurrentValue = null;
        $this->SPPBILL->OldValue = $this->SPPBILL->CurrentValue;
        $this->SPPRJK->CurrentValue = null;
        $this->SPPRJK->OldValue = $this->SPPRJK->CurrentValue;
        $this->SPPJMN->CurrentValue = null;
        $this->SPPJMN->OldValue = $this->SPPJMN->CurrentValue;
        $this->SPPKASIR->CurrentValue = null;
        $this->SPPKASIR->OldValue = $this->SPPKASIR->CurrentValue;
        $this->PERUJUK->CurrentValue = null;
        $this->PERUJUK->OldValue = $this->PERUJUK->CurrentValue;
        $this->PERUJUKFEE->CurrentValue = null;
        $this->PERUJUKFEE->OldValue = $this->PERUJUKFEE->CurrentValue;
        $this->modified_datesys->CurrentValue = "getdate()";
        $this->TRANS_ID->CurrentValue = null;
        $this->TRANS_ID->OldValue = $this->TRANS_ID->CurrentValue;
        $this->SPPBILLDATE->CurrentValue = null;
        $this->SPPBILLDATE->OldValue = $this->SPPBILLDATE->CurrentValue;
        $this->SPPBILLUSER->CurrentValue = null;
        $this->SPPBILLUSER->OldValue = $this->SPPBILLUSER->CurrentValue;
        $this->SPPKASIRDATE->CurrentValue = null;
        $this->SPPKASIRDATE->OldValue = $this->SPPKASIRDATE->CurrentValue;
        $this->SPPKASIRUSER->CurrentValue = null;
        $this->SPPKASIRUSER->OldValue = $this->SPPKASIRUSER->CurrentValue;
        $this->SPPPOLI->CurrentValue = null;
        $this->SPPPOLI->OldValue = $this->SPPPOLI->CurrentValue;
        $this->SPPPOLIUSER->CurrentValue = null;
        $this->SPPPOLIUSER->OldValue = $this->SPPPOLIUSER->CurrentValue;
        $this->SPPPOLIDATE->CurrentValue = null;
        $this->SPPPOLIDATE->OldValue = $this->SPPPOLIDATE->CurrentValue;
        $this->ID->CurrentValue = null;
        $this->ID->OldValue = $this->ID->CurrentValue;
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

        // Check field name 'BILL_ID' first before field var 'x_BILL_ID'
        $val = $CurrentForm->hasValue("BILL_ID") ? $CurrentForm->getValue("BILL_ID") : $CurrentForm->getValue("x_BILL_ID");
        if (!$this->BILL_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->BILL_ID->Visible = false; // Disable update for API request
            } else {
                $this->BILL_ID->setFormValue($val);
            }
        }

        // Check field name 'NO_REGISTRATION' first before field var 'x_NO_REGISTRATION'
        $val = $CurrentForm->hasValue("NO_REGISTRATION") ? $CurrentForm->getValue("NO_REGISTRATION") : $CurrentForm->getValue("x_NO_REGISTRATION");
        if (!$this->NO_REGISTRATION->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->NO_REGISTRATION->Visible = false; // Disable update for API request
            } else {
                $this->NO_REGISTRATION->setFormValue($val);
            }
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

        // Check field name 'TARIF_ID' first before field var 'x_TARIF_ID'
        $val = $CurrentForm->hasValue("TARIF_ID") ? $CurrentForm->getValue("TARIF_ID") : $CurrentForm->getValue("x_TARIF_ID");
        if (!$this->TARIF_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->TARIF_ID->Visible = false; // Disable update for API request
            } else {
                $this->TARIF_ID->setFormValue($val);
            }
        }

        // Check field name 'CLASS_ID' first before field var 'x_CLASS_ID'
        $val = $CurrentForm->hasValue("CLASS_ID") ? $CurrentForm->getValue("CLASS_ID") : $CurrentForm->getValue("x_CLASS_ID");
        if (!$this->CLASS_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->CLASS_ID->Visible = false; // Disable update for API request
            } else {
                $this->CLASS_ID->setFormValue($val);
            }
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

        // Check field name 'CLINIC_ID_FROM' first before field var 'x_CLINIC_ID_FROM'
        $val = $CurrentForm->hasValue("CLINIC_ID_FROM") ? $CurrentForm->getValue("CLINIC_ID_FROM") : $CurrentForm->getValue("x_CLINIC_ID_FROM");
        if (!$this->CLINIC_ID_FROM->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->CLINIC_ID_FROM->Visible = false; // Disable update for API request
            } else {
                $this->CLINIC_ID_FROM->setFormValue($val);
            }
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

        // Check field name 'TREAT_DATE' first before field var 'x_TREAT_DATE'
        $val = $CurrentForm->hasValue("TREAT_DATE") ? $CurrentForm->getValue("TREAT_DATE") : $CurrentForm->getValue("x_TREAT_DATE");
        if (!$this->TREAT_DATE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->TREAT_DATE->Visible = false; // Disable update for API request
            } else {
                $this->TREAT_DATE->setFormValue($val);
            }
            $this->TREAT_DATE->CurrentValue = UnFormatDateTime($this->TREAT_DATE->CurrentValue, 0);
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

        // Check field name 'QUANTITY' first before field var 'x_QUANTITY'
        $val = $CurrentForm->hasValue("QUANTITY") ? $CurrentForm->getValue("QUANTITY") : $CurrentForm->getValue("x_QUANTITY");
        if (!$this->QUANTITY->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->QUANTITY->Visible = false; // Disable update for API request
            } else {
                $this->QUANTITY->setFormValue($val);
            }
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

        // Check field name 'POKOK_JUAL' first before field var 'x_POKOK_JUAL'
        $val = $CurrentForm->hasValue("POKOK_JUAL") ? $CurrentForm->getValue("POKOK_JUAL") : $CurrentForm->getValue("x_POKOK_JUAL");
        if (!$this->POKOK_JUAL->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->POKOK_JUAL->Visible = false; // Disable update for API request
            } else {
                $this->POKOK_JUAL->setFormValue($val);
            }
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

        // Check field name 'MARGIN' first before field var 'x_MARGIN'
        $val = $CurrentForm->hasValue("MARGIN") ? $CurrentForm->getValue("MARGIN") : $CurrentForm->getValue("x_MARGIN");
        if (!$this->MARGIN->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->MARGIN->Visible = false; // Disable update for API request
            } else {
                $this->MARGIN->setFormValue($val);
            }
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

        // Check field name 'EMBALACE' first before field var 'x_EMBALACE'
        $val = $CurrentForm->hasValue("EMBALACE") ? $CurrentForm->getValue("EMBALACE") : $CurrentForm->getValue("x_EMBALACE");
        if (!$this->EMBALACE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->EMBALACE->Visible = false; // Disable update for API request
            } else {
                $this->EMBALACE->setFormValue($val);
            }
        }

        // Check field name 'PROFESI' first before field var 'x_PROFESI'
        $val = $CurrentForm->hasValue("PROFESI") ? $CurrentForm->getValue("PROFESI") : $CurrentForm->getValue("x_PROFESI");
        if (!$this->PROFESI->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->PROFESI->Visible = false; // Disable update for API request
            } else {
                $this->PROFESI->setFormValue($val);
            }
        }

        // Check field name 'DISCOUNT' first before field var 'x_DISCOUNT'
        $val = $CurrentForm->hasValue("DISCOUNT") ? $CurrentForm->getValue("DISCOUNT") : $CurrentForm->getValue("x_DISCOUNT");
        if (!$this->DISCOUNT->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->DISCOUNT->Visible = false; // Disable update for API request
            } else {
                $this->DISCOUNT->setFormValue($val);
            }
        }

        // Check field name 'PAY_METHOD_ID' first before field var 'x_PAY_METHOD_ID'
        $val = $CurrentForm->hasValue("PAY_METHOD_ID") ? $CurrentForm->getValue("PAY_METHOD_ID") : $CurrentForm->getValue("x_PAY_METHOD_ID");
        if (!$this->PAY_METHOD_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->PAY_METHOD_ID->Visible = false; // Disable update for API request
            } else {
                $this->PAY_METHOD_ID->setFormValue($val);
            }
        }

        // Check field name 'PAYMENT_DATE' first before field var 'x_PAYMENT_DATE'
        $val = $CurrentForm->hasValue("PAYMENT_DATE") ? $CurrentForm->getValue("PAYMENT_DATE") : $CurrentForm->getValue("x_PAYMENT_DATE");
        if (!$this->PAYMENT_DATE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->PAYMENT_DATE->Visible = false; // Disable update for API request
            } else {
                $this->PAYMENT_DATE->setFormValue($val);
            }
            $this->PAYMENT_DATE->CurrentValue = UnFormatDateTime($this->PAYMENT_DATE->CurrentValue, 0);
        }

        // Check field name 'ISLUNAS' first before field var 'x_ISLUNAS'
        $val = $CurrentForm->hasValue("ISLUNAS") ? $CurrentForm->getValue("ISLUNAS") : $CurrentForm->getValue("x_ISLUNAS");
        if (!$this->ISLUNAS->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ISLUNAS->Visible = false; // Disable update for API request
            } else {
                $this->ISLUNAS->setFormValue($val);
            }
        }

        // Check field name 'DUEDATE_ANGSURAN' first before field var 'x_DUEDATE_ANGSURAN'
        $val = $CurrentForm->hasValue("DUEDATE_ANGSURAN") ? $CurrentForm->getValue("DUEDATE_ANGSURAN") : $CurrentForm->getValue("x_DUEDATE_ANGSURAN");
        if (!$this->DUEDATE_ANGSURAN->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->DUEDATE_ANGSURAN->Visible = false; // Disable update for API request
            } else {
                $this->DUEDATE_ANGSURAN->setFormValue($val);
            }
            $this->DUEDATE_ANGSURAN->CurrentValue = UnFormatDateTime($this->DUEDATE_ANGSURAN->CurrentValue, 0);
        }

        // Check field name 'DESCRIPTION' first before field var 'x_DESCRIPTION'
        $val = $CurrentForm->hasValue("DESCRIPTION") ? $CurrentForm->getValue("DESCRIPTION") : $CurrentForm->getValue("x_DESCRIPTION");
        if (!$this->DESCRIPTION->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->DESCRIPTION->Visible = false; // Disable update for API request
            } else {
                $this->DESCRIPTION->setFormValue($val);
            }
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

        // Check field name 'NOTA_NO' first before field var 'x_NOTA_NO'
        $val = $CurrentForm->hasValue("NOTA_NO") ? $CurrentForm->getValue("NOTA_NO") : $CurrentForm->getValue("x_NOTA_NO");
        if (!$this->NOTA_NO->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->NOTA_NO->Visible = false; // Disable update for API request
            } else {
                $this->NOTA_NO->setFormValue($val);
            }
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

        // Check field name 'RESEP_NO' first before field var 'x_RESEP_NO'
        $val = $CurrentForm->hasValue("RESEP_NO") ? $CurrentForm->getValue("RESEP_NO") : $CurrentForm->getValue("x_RESEP_NO");
        if (!$this->RESEP_NO->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->RESEP_NO->Visible = false; // Disable update for API request
            } else {
                $this->RESEP_NO->setFormValue($val);
            }
        }

        // Check field name 'RESEP_KE' first before field var 'x_RESEP_KE'
        $val = $CurrentForm->hasValue("RESEP_KE") ? $CurrentForm->getValue("RESEP_KE") : $CurrentForm->getValue("x_RESEP_KE");
        if (!$this->RESEP_KE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->RESEP_KE->Visible = false; // Disable update for API request
            } else {
                $this->RESEP_KE->setFormValue($val);
            }
        }

        // Check field name 'DOSE' first before field var 'x_DOSE'
        $val = $CurrentForm->hasValue("DOSE") ? $CurrentForm->getValue("DOSE") : $CurrentForm->getValue("x_DOSE");
        if (!$this->DOSE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->DOSE->Visible = false; // Disable update for API request
            } else {
                $this->DOSE->setFormValue($val);
            }
        }

        // Check field name 'ORIG_DOSE' first before field var 'x_ORIG_DOSE'
        $val = $CurrentForm->hasValue("ORIG_DOSE") ? $CurrentForm->getValue("ORIG_DOSE") : $CurrentForm->getValue("x_ORIG_DOSE");
        if (!$this->ORIG_DOSE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ORIG_DOSE->Visible = false; // Disable update for API request
            } else {
                $this->ORIG_DOSE->setFormValue($val);
            }
        }

        // Check field name 'DOSE_PRESC' first before field var 'x_DOSE_PRESC'
        $val = $CurrentForm->hasValue("DOSE_PRESC") ? $CurrentForm->getValue("DOSE_PRESC") : $CurrentForm->getValue("x_DOSE_PRESC");
        if (!$this->DOSE_PRESC->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->DOSE_PRESC->Visible = false; // Disable update for API request
            } else {
                $this->DOSE_PRESC->setFormValue($val);
            }
        }

        // Check field name 'ITER' first before field var 'x_ITER'
        $val = $CurrentForm->hasValue("ITER") ? $CurrentForm->getValue("ITER") : $CurrentForm->getValue("x_ITER");
        if (!$this->ITER->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ITER->Visible = false; // Disable update for API request
            } else {
                $this->ITER->setFormValue($val);
            }
        }

        // Check field name 'ITER_KE' first before field var 'x_ITER_KE'
        $val = $CurrentForm->hasValue("ITER_KE") ? $CurrentForm->getValue("ITER_KE") : $CurrentForm->getValue("x_ITER_KE");
        if (!$this->ITER_KE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ITER_KE->Visible = false; // Disable update for API request
            } else {
                $this->ITER_KE->setFormValue($val);
            }
        }

        // Check field name 'SOLD_STATUS' first before field var 'x_SOLD_STATUS'
        $val = $CurrentForm->hasValue("SOLD_STATUS") ? $CurrentForm->getValue("SOLD_STATUS") : $CurrentForm->getValue("x_SOLD_STATUS");
        if (!$this->SOLD_STATUS->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->SOLD_STATUS->Visible = false; // Disable update for API request
            } else {
                $this->SOLD_STATUS->setFormValue($val);
            }
        }

        // Check field name 'RACIKAN' first before field var 'x_RACIKAN'
        $val = $CurrentForm->hasValue("RACIKAN") ? $CurrentForm->getValue("RACIKAN") : $CurrentForm->getValue("x_RACIKAN");
        if (!$this->RACIKAN->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->RACIKAN->Visible = false; // Disable update for API request
            } else {
                $this->RACIKAN->setFormValue($val);
            }
        }

        // Check field name 'CLASS_ROOM_ID' first before field var 'x_CLASS_ROOM_ID'
        $val = $CurrentForm->hasValue("CLASS_ROOM_ID") ? $CurrentForm->getValue("CLASS_ROOM_ID") : $CurrentForm->getValue("x_CLASS_ROOM_ID");
        if (!$this->CLASS_ROOM_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->CLASS_ROOM_ID->Visible = false; // Disable update for API request
            } else {
                $this->CLASS_ROOM_ID->setFormValue($val);
            }
        }

        // Check field name 'KELUAR_ID' first before field var 'x_KELUAR_ID'
        $val = $CurrentForm->hasValue("KELUAR_ID") ? $CurrentForm->getValue("KELUAR_ID") : $CurrentForm->getValue("x_KELUAR_ID");
        if (!$this->KELUAR_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->KELUAR_ID->Visible = false; // Disable update for API request
            } else {
                $this->KELUAR_ID->setFormValue($val);
            }
        }

        // Check field name 'BED_ID' first before field var 'x_BED_ID'
        $val = $CurrentForm->hasValue("BED_ID") ? $CurrentForm->getValue("BED_ID") : $CurrentForm->getValue("x_BED_ID");
        if (!$this->BED_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->BED_ID->Visible = false; // Disable update for API request
            } else {
                $this->BED_ID->setFormValue($val);
            }
        }

        // Check field name 'PERDA_ID' first before field var 'x_PERDA_ID'
        $val = $CurrentForm->hasValue("PERDA_ID") ? $CurrentForm->getValue("PERDA_ID") : $CurrentForm->getValue("x_PERDA_ID");
        if (!$this->PERDA_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->PERDA_ID->Visible = false; // Disable update for API request
            } else {
                $this->PERDA_ID->setFormValue($val);
            }
        }

        // Check field name 'EMPLOYEE_ID' first before field var 'x_EMPLOYEE_ID'
        $val = $CurrentForm->hasValue("EMPLOYEE_ID") ? $CurrentForm->getValue("EMPLOYEE_ID") : $CurrentForm->getValue("x_EMPLOYEE_ID");
        if (!$this->EMPLOYEE_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->EMPLOYEE_ID->Visible = false; // Disable update for API request
            } else {
                $this->EMPLOYEE_ID->setFormValue($val);
            }
        }

        // Check field name 'DESCRIPTION2' first before field var 'x_DESCRIPTION2'
        $val = $CurrentForm->hasValue("DESCRIPTION2") ? $CurrentForm->getValue("DESCRIPTION2") : $CurrentForm->getValue("x_DESCRIPTION2");
        if (!$this->DESCRIPTION2->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->DESCRIPTION2->Visible = false; // Disable update for API request
            } else {
                $this->DESCRIPTION2->setFormValue($val);
            }
        }

        // Check field name 'MODIFIED_BY' first before field var 'x_MODIFIED_BY'
        $val = $CurrentForm->hasValue("MODIFIED_BY") ? $CurrentForm->getValue("MODIFIED_BY") : $CurrentForm->getValue("x_MODIFIED_BY");
        if (!$this->MODIFIED_BY->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->MODIFIED_BY->Visible = false; // Disable update for API request
            } else {
                $this->MODIFIED_BY->setFormValue($val);
            }
        }

        // Check field name 'MODIFIED_DATE' first before field var 'x_MODIFIED_DATE'
        $val = $CurrentForm->hasValue("MODIFIED_DATE") ? $CurrentForm->getValue("MODIFIED_DATE") : $CurrentForm->getValue("x_MODIFIED_DATE");
        if (!$this->MODIFIED_DATE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->MODIFIED_DATE->Visible = false; // Disable update for API request
            } else {
                $this->MODIFIED_DATE->setFormValue($val);
            }
            $this->MODIFIED_DATE->CurrentValue = UnFormatDateTime($this->MODIFIED_DATE->CurrentValue, 0);
        }

        // Check field name 'MODIFIED_FROM' first before field var 'x_MODIFIED_FROM'
        $val = $CurrentForm->hasValue("MODIFIED_FROM") ? $CurrentForm->getValue("MODIFIED_FROM") : $CurrentForm->getValue("x_MODIFIED_FROM");
        if (!$this->MODIFIED_FROM->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->MODIFIED_FROM->Visible = false; // Disable update for API request
            } else {
                $this->MODIFIED_FROM->setFormValue($val);
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

        // Check field name 'DOCTOR' first before field var 'x_DOCTOR'
        $val = $CurrentForm->hasValue("DOCTOR") ? $CurrentForm->getValue("DOCTOR") : $CurrentForm->getValue("x_DOCTOR");
        if (!$this->DOCTOR->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->DOCTOR->Visible = false; // Disable update for API request
            } else {
                $this->DOCTOR->setFormValue($val);
            }
        }

        // Check field name 'JML_BKS' first before field var 'x_JML_BKS'
        $val = $CurrentForm->hasValue("JML_BKS") ? $CurrentForm->getValue("JML_BKS") : $CurrentForm->getValue("x_JML_BKS");
        if (!$this->JML_BKS->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->JML_BKS->Visible = false; // Disable update for API request
            } else {
                $this->JML_BKS->setFormValue($val);
            }
        }

        // Check field name 'EXIT_DATE' first before field var 'x_EXIT_DATE'
        $val = $CurrentForm->hasValue("EXIT_DATE") ? $CurrentForm->getValue("EXIT_DATE") : $CurrentForm->getValue("x_EXIT_DATE");
        if (!$this->EXIT_DATE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->EXIT_DATE->Visible = false; // Disable update for API request
            } else {
                $this->EXIT_DATE->setFormValue($val);
            }
            $this->EXIT_DATE->CurrentValue = UnFormatDateTime($this->EXIT_DATE->CurrentValue, 0);
        }

        // Check field name 'FA_V' first before field var 'x_FA_V'
        $val = $CurrentForm->hasValue("FA_V") ? $CurrentForm->getValue("FA_V") : $CurrentForm->getValue("x_FA_V");
        if (!$this->FA_V->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->FA_V->Visible = false; // Disable update for API request
            } else {
                $this->FA_V->setFormValue($val);
            }
        }

        // Check field name 'TASK_ID' first before field var 'x_TASK_ID'
        $val = $CurrentForm->hasValue("TASK_ID") ? $CurrentForm->getValue("TASK_ID") : $CurrentForm->getValue("x_TASK_ID");
        if (!$this->TASK_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->TASK_ID->Visible = false; // Disable update for API request
            } else {
                $this->TASK_ID->setFormValue($val);
            }
        }

        // Check field name 'EMPLOYEE_ID_FROM' first before field var 'x_EMPLOYEE_ID_FROM'
        $val = $CurrentForm->hasValue("EMPLOYEE_ID_FROM") ? $CurrentForm->getValue("EMPLOYEE_ID_FROM") : $CurrentForm->getValue("x_EMPLOYEE_ID_FROM");
        if (!$this->EMPLOYEE_ID_FROM->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->EMPLOYEE_ID_FROM->Visible = false; // Disable update for API request
            } else {
                $this->EMPLOYEE_ID_FROM->setFormValue($val);
            }
        }

        // Check field name 'DOCTOR_FROM' first before field var 'x_DOCTOR_FROM'
        $val = $CurrentForm->hasValue("DOCTOR_FROM") ? $CurrentForm->getValue("DOCTOR_FROM") : $CurrentForm->getValue("x_DOCTOR_FROM");
        if (!$this->DOCTOR_FROM->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->DOCTOR_FROM->Visible = false; // Disable update for API request
            } else {
                $this->DOCTOR_FROM->setFormValue($val);
            }
        }

        // Check field name 'status_pasien_id' first before field var 'x_status_pasien_id'
        $val = $CurrentForm->hasValue("status_pasien_id") ? $CurrentForm->getValue("status_pasien_id") : $CurrentForm->getValue("x_status_pasien_id");
        if (!$this->status_pasien_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->status_pasien_id->Visible = false; // Disable update for API request
            } else {
                $this->status_pasien_id->setFormValue($val);
            }
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

        // Check field name 'THENAME' first before field var 'x_THENAME'
        $val = $CurrentForm->hasValue("THENAME") ? $CurrentForm->getValue("THENAME") : $CurrentForm->getValue("x_THENAME");
        if (!$this->THENAME->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->THENAME->Visible = false; // Disable update for API request
            } else {
                $this->THENAME->setFormValue($val);
            }
        }

        // Check field name 'THEADDRESS' first before field var 'x_THEADDRESS'
        $val = $CurrentForm->hasValue("THEADDRESS") ? $CurrentForm->getValue("THEADDRESS") : $CurrentForm->getValue("x_THEADDRESS");
        if (!$this->THEADDRESS->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->THEADDRESS->Visible = false; // Disable update for API request
            } else {
                $this->THEADDRESS->setFormValue($val);
            }
        }

        // Check field name 'THEID' first before field var 'x_THEID'
        $val = $CurrentForm->hasValue("THEID") ? $CurrentForm->getValue("THEID") : $CurrentForm->getValue("x_THEID");
        if (!$this->THEID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->THEID->Visible = false; // Disable update for API request
            } else {
                $this->THEID->setFormValue($val);
            }
        }

        // Check field name 'serial_nb' first before field var 'x_serial_nb'
        $val = $CurrentForm->hasValue("serial_nb") ? $CurrentForm->getValue("serial_nb") : $CurrentForm->getValue("x_serial_nb");
        if (!$this->serial_nb->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->serial_nb->Visible = false; // Disable update for API request
            } else {
                $this->serial_nb->setFormValue($val);
            }
        }

        // Check field name 'TREATMENT_PLAFOND' first before field var 'x_TREATMENT_PLAFOND'
        $val = $CurrentForm->hasValue("TREATMENT_PLAFOND") ? $CurrentForm->getValue("TREATMENT_PLAFOND") : $CurrentForm->getValue("x_TREATMENT_PLAFOND");
        if (!$this->TREATMENT_PLAFOND->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->TREATMENT_PLAFOND->Visible = false; // Disable update for API request
            } else {
                $this->TREATMENT_PLAFOND->setFormValue($val);
            }
        }

        // Check field name 'AMOUNT_PLAFOND' first before field var 'x_AMOUNT_PLAFOND'
        $val = $CurrentForm->hasValue("AMOUNT_PLAFOND") ? $CurrentForm->getValue("AMOUNT_PLAFOND") : $CurrentForm->getValue("x_AMOUNT_PLAFOND");
        if (!$this->AMOUNT_PLAFOND->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->AMOUNT_PLAFOND->Visible = false; // Disable update for API request
            } else {
                $this->AMOUNT_PLAFOND->setFormValue($val);
            }
        }

        // Check field name 'AMOUNT_PAID_PLAFOND' first before field var 'x_AMOUNT_PAID_PLAFOND'
        $val = $CurrentForm->hasValue("AMOUNT_PAID_PLAFOND") ? $CurrentForm->getValue("AMOUNT_PAID_PLAFOND") : $CurrentForm->getValue("x_AMOUNT_PAID_PLAFOND");
        if (!$this->AMOUNT_PAID_PLAFOND->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->AMOUNT_PAID_PLAFOND->Visible = false; // Disable update for API request
            } else {
                $this->AMOUNT_PAID_PLAFOND->setFormValue($val);
            }
        }

        // Check field name 'CLASS_ID_PLAFOND' first before field var 'x_CLASS_ID_PLAFOND'
        $val = $CurrentForm->hasValue("CLASS_ID_PLAFOND") ? $CurrentForm->getValue("CLASS_ID_PLAFOND") : $CurrentForm->getValue("x_CLASS_ID_PLAFOND");
        if (!$this->CLASS_ID_PLAFOND->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->CLASS_ID_PLAFOND->Visible = false; // Disable update for API request
            } else {
                $this->CLASS_ID_PLAFOND->setFormValue($val);
            }
        }

        // Check field name 'PAYOR_ID' first before field var 'x_PAYOR_ID'
        $val = $CurrentForm->hasValue("PAYOR_ID") ? $CurrentForm->getValue("PAYOR_ID") : $CurrentForm->getValue("x_PAYOR_ID");
        if (!$this->PAYOR_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->PAYOR_ID->Visible = false; // Disable update for API request
            } else {
                $this->PAYOR_ID->setFormValue($val);
            }
        }

        // Check field name 'PEMBULATAN' first before field var 'x_PEMBULATAN'
        $val = $CurrentForm->hasValue("PEMBULATAN") ? $CurrentForm->getValue("PEMBULATAN") : $CurrentForm->getValue("x_PEMBULATAN");
        if (!$this->PEMBULATAN->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->PEMBULATAN->Visible = false; // Disable update for API request
            } else {
                $this->PEMBULATAN->setFormValue($val);
            }
        }

        // Check field name 'ISRJ' first before field var 'x_ISRJ'
        $val = $CurrentForm->hasValue("ISRJ") ? $CurrentForm->getValue("ISRJ") : $CurrentForm->getValue("x_ISRJ");
        if (!$this->ISRJ->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ISRJ->Visible = false; // Disable update for API request
            } else {
                $this->ISRJ->setFormValue($val);
            }
        }

        // Check field name 'AGEYEAR' first before field var 'x_AGEYEAR'
        $val = $CurrentForm->hasValue("AGEYEAR") ? $CurrentForm->getValue("AGEYEAR") : $CurrentForm->getValue("x_AGEYEAR");
        if (!$this->AGEYEAR->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->AGEYEAR->Visible = false; // Disable update for API request
            } else {
                $this->AGEYEAR->setFormValue($val);
            }
        }

        // Check field name 'AGEMONTH' first before field var 'x_AGEMONTH'
        $val = $CurrentForm->hasValue("AGEMONTH") ? $CurrentForm->getValue("AGEMONTH") : $CurrentForm->getValue("x_AGEMONTH");
        if (!$this->AGEMONTH->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->AGEMONTH->Visible = false; // Disable update for API request
            } else {
                $this->AGEMONTH->setFormValue($val);
            }
        }

        // Check field name 'AGEDAY' first before field var 'x_AGEDAY'
        $val = $CurrentForm->hasValue("AGEDAY") ? $CurrentForm->getValue("AGEDAY") : $CurrentForm->getValue("x_AGEDAY");
        if (!$this->AGEDAY->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->AGEDAY->Visible = false; // Disable update for API request
            } else {
                $this->AGEDAY->setFormValue($val);
            }
        }

        // Check field name 'GENDER' first before field var 'x_GENDER'
        $val = $CurrentForm->hasValue("GENDER") ? $CurrentForm->getValue("GENDER") : $CurrentForm->getValue("x_GENDER");
        if (!$this->GENDER->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->GENDER->Visible = false; // Disable update for API request
            } else {
                $this->GENDER->setFormValue($val);
            }
        }

        // Check field name 'KAL_ID' first before field var 'x_KAL_ID'
        $val = $CurrentForm->hasValue("KAL_ID") ? $CurrentForm->getValue("KAL_ID") : $CurrentForm->getValue("x_KAL_ID");
        if (!$this->KAL_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->KAL_ID->Visible = false; // Disable update for API request
            } else {
                $this->KAL_ID->setFormValue($val);
            }
        }

        // Check field name 'CORRECTION_ID' first before field var 'x_CORRECTION_ID'
        $val = $CurrentForm->hasValue("CORRECTION_ID") ? $CurrentForm->getValue("CORRECTION_ID") : $CurrentForm->getValue("x_CORRECTION_ID");
        if (!$this->CORRECTION_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->CORRECTION_ID->Visible = false; // Disable update for API request
            } else {
                $this->CORRECTION_ID->setFormValue($val);
            }
        }

        // Check field name 'CORRECTION_BY' first before field var 'x_CORRECTION_BY'
        $val = $CurrentForm->hasValue("CORRECTION_BY") ? $CurrentForm->getValue("CORRECTION_BY") : $CurrentForm->getValue("x_CORRECTION_BY");
        if (!$this->CORRECTION_BY->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->CORRECTION_BY->Visible = false; // Disable update for API request
            } else {
                $this->CORRECTION_BY->setFormValue($val);
            }
        }

        // Check field name 'KARYAWAN' first before field var 'x_KARYAWAN'
        $val = $CurrentForm->hasValue("KARYAWAN") ? $CurrentForm->getValue("KARYAWAN") : $CurrentForm->getValue("x_KARYAWAN");
        if (!$this->KARYAWAN->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->KARYAWAN->Visible = false; // Disable update for API request
            } else {
                $this->KARYAWAN->setFormValue($val);
            }
        }

        // Check field name 'ACCOUNT_ID' first before field var 'x_ACCOUNT_ID'
        $val = $CurrentForm->hasValue("ACCOUNT_ID") ? $CurrentForm->getValue("ACCOUNT_ID") : $CurrentForm->getValue("x_ACCOUNT_ID");
        if (!$this->ACCOUNT_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ACCOUNT_ID->Visible = false; // Disable update for API request
            } else {
                $this->ACCOUNT_ID->setFormValue($val);
            }
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

        // Check field name 'diskon' first before field var 'x_diskon'
        $val = $CurrentForm->hasValue("diskon") ? $CurrentForm->getValue("diskon") : $CurrentForm->getValue("x_diskon");
        if (!$this->diskon->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->diskon->Visible = false; // Disable update for API request
            } else {
                $this->diskon->setFormValue($val);
            }
        }

        // Check field name 'INVOICE_ID' first before field var 'x_INVOICE_ID'
        $val = $CurrentForm->hasValue("INVOICE_ID") ? $CurrentForm->getValue("INVOICE_ID") : $CurrentForm->getValue("x_INVOICE_ID");
        if (!$this->INVOICE_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->INVOICE_ID->Visible = false; // Disable update for API request
            } else {
                $this->INVOICE_ID->setFormValue($val);
            }
        }

        // Check field name 'NUMER' first before field var 'x_NUMER'
        $val = $CurrentForm->hasValue("NUMER") ? $CurrentForm->getValue("NUMER") : $CurrentForm->getValue("x_NUMER");
        if (!$this->NUMER->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->NUMER->Visible = false; // Disable update for API request
            } else {
                $this->NUMER->setFormValue($val);
            }
        }

        // Check field name 'MEASURE_ID2' first before field var 'x_MEASURE_ID2'
        $val = $CurrentForm->hasValue("MEASURE_ID2") ? $CurrentForm->getValue("MEASURE_ID2") : $CurrentForm->getValue("x_MEASURE_ID2");
        if (!$this->MEASURE_ID2->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->MEASURE_ID2->Visible = false; // Disable update for API request
            } else {
                $this->MEASURE_ID2->setFormValue($val);
            }
        }

        // Check field name 'POTONGAN' first before field var 'x_POTONGAN'
        $val = $CurrentForm->hasValue("POTONGAN") ? $CurrentForm->getValue("POTONGAN") : $CurrentForm->getValue("x_POTONGAN");
        if (!$this->POTONGAN->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->POTONGAN->Visible = false; // Disable update for API request
            } else {
                $this->POTONGAN->setFormValue($val);
            }
        }

        // Check field name 'BAYAR' first before field var 'x_BAYAR'
        $val = $CurrentForm->hasValue("BAYAR") ? $CurrentForm->getValue("BAYAR") : $CurrentForm->getValue("x_BAYAR");
        if (!$this->BAYAR->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->BAYAR->Visible = false; // Disable update for API request
            } else {
                $this->BAYAR->setFormValue($val);
            }
        }

        // Check field name 'RETUR' first before field var 'x_RETUR'
        $val = $CurrentForm->hasValue("RETUR") ? $CurrentForm->getValue("RETUR") : $CurrentForm->getValue("x_RETUR");
        if (!$this->RETUR->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->RETUR->Visible = false; // Disable update for API request
            } else {
                $this->RETUR->setFormValue($val);
            }
        }

        // Check field name 'TARIF_TYPE' first before field var 'x_TARIF_TYPE'
        $val = $CurrentForm->hasValue("TARIF_TYPE") ? $CurrentForm->getValue("TARIF_TYPE") : $CurrentForm->getValue("x_TARIF_TYPE");
        if (!$this->TARIF_TYPE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->TARIF_TYPE->Visible = false; // Disable update for API request
            } else {
                $this->TARIF_TYPE->setFormValue($val);
            }
        }

        // Check field name 'PPNVALUE' first before field var 'x_PPNVALUE'
        $val = $CurrentForm->hasValue("PPNVALUE") ? $CurrentForm->getValue("PPNVALUE") : $CurrentForm->getValue("x_PPNVALUE");
        if (!$this->PPNVALUE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->PPNVALUE->Visible = false; // Disable update for API request
            } else {
                $this->PPNVALUE->setFormValue($val);
            }
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

        // Check field name 'KOREKSI' first before field var 'x_KOREKSI'
        $val = $CurrentForm->hasValue("KOREKSI") ? $CurrentForm->getValue("KOREKSI") : $CurrentForm->getValue("x_KOREKSI");
        if (!$this->KOREKSI->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->KOREKSI->Visible = false; // Disable update for API request
            } else {
                $this->KOREKSI->setFormValue($val);
            }
        }

        // Check field name 'STATUS_OBAT' first before field var 'x_STATUS_OBAT'
        $val = $CurrentForm->hasValue("STATUS_OBAT") ? $CurrentForm->getValue("STATUS_OBAT") : $CurrentForm->getValue("x_STATUS_OBAT");
        if (!$this->STATUS_OBAT->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->STATUS_OBAT->Visible = false; // Disable update for API request
            } else {
                $this->STATUS_OBAT->setFormValue($val);
            }
        }

        // Check field name 'SUBSIDISAT' first before field var 'x_SUBSIDISAT'
        $val = $CurrentForm->hasValue("SUBSIDISAT") ? $CurrentForm->getValue("SUBSIDISAT") : $CurrentForm->getValue("x_SUBSIDISAT");
        if (!$this->SUBSIDISAT->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->SUBSIDISAT->Visible = false; // Disable update for API request
            } else {
                $this->SUBSIDISAT->setFormValue($val);
            }
        }

        // Check field name 'PRINTQ' first before field var 'x_PRINTQ'
        $val = $CurrentForm->hasValue("PRINTQ") ? $CurrentForm->getValue("PRINTQ") : $CurrentForm->getValue("x_PRINTQ");
        if (!$this->PRINTQ->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->PRINTQ->Visible = false; // Disable update for API request
            } else {
                $this->PRINTQ->setFormValue($val);
            }
        }

        // Check field name 'PRINTED_BY' first before field var 'x_PRINTED_BY'
        $val = $CurrentForm->hasValue("PRINTED_BY") ? $CurrentForm->getValue("PRINTED_BY") : $CurrentForm->getValue("x_PRINTED_BY");
        if (!$this->PRINTED_BY->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->PRINTED_BY->Visible = false; // Disable update for API request
            } else {
                $this->PRINTED_BY->setFormValue($val);
            }
        }

        // Check field name 'STOCK_AVAILABLE' first before field var 'x_STOCK_AVAILABLE'
        $val = $CurrentForm->hasValue("STOCK_AVAILABLE") ? $CurrentForm->getValue("STOCK_AVAILABLE") : $CurrentForm->getValue("x_STOCK_AVAILABLE");
        if (!$this->STOCK_AVAILABLE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->STOCK_AVAILABLE->Visible = false; // Disable update for API request
            } else {
                $this->STOCK_AVAILABLE->setFormValue($val);
            }
        }

        // Check field name 'STATUS_TARIF' first before field var 'x_STATUS_TARIF'
        $val = $CurrentForm->hasValue("STATUS_TARIF") ? $CurrentForm->getValue("STATUS_TARIF") : $CurrentForm->getValue("x_STATUS_TARIF");
        if (!$this->STATUS_TARIF->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->STATUS_TARIF->Visible = false; // Disable update for API request
            } else {
                $this->STATUS_TARIF->setFormValue($val);
            }
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

        // Check field name 'PACKAGE_ID' first before field var 'x_PACKAGE_ID'
        $val = $CurrentForm->hasValue("PACKAGE_ID") ? $CurrentForm->getValue("PACKAGE_ID") : $CurrentForm->getValue("x_PACKAGE_ID");
        if (!$this->PACKAGE_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->PACKAGE_ID->Visible = false; // Disable update for API request
            } else {
                $this->PACKAGE_ID->setFormValue($val);
            }
        }

        // Check field name 'MODULE_ID' first before field var 'x_MODULE_ID'
        $val = $CurrentForm->hasValue("MODULE_ID") ? $CurrentForm->getValue("MODULE_ID") : $CurrentForm->getValue("x_MODULE_ID");
        if (!$this->MODULE_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->MODULE_ID->Visible = false; // Disable update for API request
            } else {
                $this->MODULE_ID->setFormValue($val);
            }
        }

        // Check field name 'profession' first before field var 'x_profession'
        $val = $CurrentForm->hasValue("profession") ? $CurrentForm->getValue("profession") : $CurrentForm->getValue("x_profession");
        if (!$this->profession->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->profession->Visible = false; // Disable update for API request
            } else {
                $this->profession->setFormValue($val);
            }
        }

        // Check field name 'THEORDER' first before field var 'x_THEORDER'
        $val = $CurrentForm->hasValue("THEORDER") ? $CurrentForm->getValue("THEORDER") : $CurrentForm->getValue("x_THEORDER");
        if (!$this->THEORDER->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->THEORDER->Visible = false; // Disable update for API request
            } else {
                $this->THEORDER->setFormValue($val);
            }
        }

        // Check field name 'CASHIER' first before field var 'x_CASHIER'
        $val = $CurrentForm->hasValue("CASHIER") ? $CurrentForm->getValue("CASHIER") : $CurrentForm->getValue("x_CASHIER");
        if (!$this->CASHIER->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->CASHIER->Visible = false; // Disable update for API request
            } else {
                $this->CASHIER->setFormValue($val);
            }
        }

        // Check field name 'SPPFEE' first before field var 'x_SPPFEE'
        $val = $CurrentForm->hasValue("SPPFEE") ? $CurrentForm->getValue("SPPFEE") : $CurrentForm->getValue("x_SPPFEE");
        if (!$this->SPPFEE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->SPPFEE->Visible = false; // Disable update for API request
            } else {
                $this->SPPFEE->setFormValue($val);
            }
        }

        // Check field name 'SPPBILL' first before field var 'x_SPPBILL'
        $val = $CurrentForm->hasValue("SPPBILL") ? $CurrentForm->getValue("SPPBILL") : $CurrentForm->getValue("x_SPPBILL");
        if (!$this->SPPBILL->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->SPPBILL->Visible = false; // Disable update for API request
            } else {
                $this->SPPBILL->setFormValue($val);
            }
        }

        // Check field name 'SPPRJK' first before field var 'x_SPPRJK'
        $val = $CurrentForm->hasValue("SPPRJK") ? $CurrentForm->getValue("SPPRJK") : $CurrentForm->getValue("x_SPPRJK");
        if (!$this->SPPRJK->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->SPPRJK->Visible = false; // Disable update for API request
            } else {
                $this->SPPRJK->setFormValue($val);
            }
        }

        // Check field name 'SPPJMN' first before field var 'x_SPPJMN'
        $val = $CurrentForm->hasValue("SPPJMN") ? $CurrentForm->getValue("SPPJMN") : $CurrentForm->getValue("x_SPPJMN");
        if (!$this->SPPJMN->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->SPPJMN->Visible = false; // Disable update for API request
            } else {
                $this->SPPJMN->setFormValue($val);
            }
        }

        // Check field name 'SPPKASIR' first before field var 'x_SPPKASIR'
        $val = $CurrentForm->hasValue("SPPKASIR") ? $CurrentForm->getValue("SPPKASIR") : $CurrentForm->getValue("x_SPPKASIR");
        if (!$this->SPPKASIR->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->SPPKASIR->Visible = false; // Disable update for API request
            } else {
                $this->SPPKASIR->setFormValue($val);
            }
        }

        // Check field name 'PERUJUK' first before field var 'x_PERUJUK'
        $val = $CurrentForm->hasValue("PERUJUK") ? $CurrentForm->getValue("PERUJUK") : $CurrentForm->getValue("x_PERUJUK");
        if (!$this->PERUJUK->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->PERUJUK->Visible = false; // Disable update for API request
            } else {
                $this->PERUJUK->setFormValue($val);
            }
        }

        // Check field name 'PERUJUKFEE' first before field var 'x_PERUJUKFEE'
        $val = $CurrentForm->hasValue("PERUJUKFEE") ? $CurrentForm->getValue("PERUJUKFEE") : $CurrentForm->getValue("x_PERUJUKFEE");
        if (!$this->PERUJUKFEE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->PERUJUKFEE->Visible = false; // Disable update for API request
            } else {
                $this->PERUJUKFEE->setFormValue($val);
            }
        }

        // Check field name 'modified_datesys' first before field var 'x_modified_datesys'
        $val = $CurrentForm->hasValue("modified_datesys") ? $CurrentForm->getValue("modified_datesys") : $CurrentForm->getValue("x_modified_datesys");
        if (!$this->modified_datesys->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->modified_datesys->Visible = false; // Disable update for API request
            } else {
                $this->modified_datesys->setFormValue($val);
            }
            $this->modified_datesys->CurrentValue = UnFormatDateTime($this->modified_datesys->CurrentValue, 0);
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

        // Check field name 'SPPBILLDATE' first before field var 'x_SPPBILLDATE'
        $val = $CurrentForm->hasValue("SPPBILLDATE") ? $CurrentForm->getValue("SPPBILLDATE") : $CurrentForm->getValue("x_SPPBILLDATE");
        if (!$this->SPPBILLDATE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->SPPBILLDATE->Visible = false; // Disable update for API request
            } else {
                $this->SPPBILLDATE->setFormValue($val);
            }
            $this->SPPBILLDATE->CurrentValue = UnFormatDateTime($this->SPPBILLDATE->CurrentValue, 0);
        }

        // Check field name 'SPPBILLUSER' first before field var 'x_SPPBILLUSER'
        $val = $CurrentForm->hasValue("SPPBILLUSER") ? $CurrentForm->getValue("SPPBILLUSER") : $CurrentForm->getValue("x_SPPBILLUSER");
        if (!$this->SPPBILLUSER->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->SPPBILLUSER->Visible = false; // Disable update for API request
            } else {
                $this->SPPBILLUSER->setFormValue($val);
            }
        }

        // Check field name 'SPPKASIRDATE' first before field var 'x_SPPKASIRDATE'
        $val = $CurrentForm->hasValue("SPPKASIRDATE") ? $CurrentForm->getValue("SPPKASIRDATE") : $CurrentForm->getValue("x_SPPKASIRDATE");
        if (!$this->SPPKASIRDATE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->SPPKASIRDATE->Visible = false; // Disable update for API request
            } else {
                $this->SPPKASIRDATE->setFormValue($val);
            }
            $this->SPPKASIRDATE->CurrentValue = UnFormatDateTime($this->SPPKASIRDATE->CurrentValue, 0);
        }

        // Check field name 'SPPKASIRUSER' first before field var 'x_SPPKASIRUSER'
        $val = $CurrentForm->hasValue("SPPKASIRUSER") ? $CurrentForm->getValue("SPPKASIRUSER") : $CurrentForm->getValue("x_SPPKASIRUSER");
        if (!$this->SPPKASIRUSER->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->SPPKASIRUSER->Visible = false; // Disable update for API request
            } else {
                $this->SPPKASIRUSER->setFormValue($val);
            }
        }

        // Check field name 'SPPPOLI' first before field var 'x_SPPPOLI'
        $val = $CurrentForm->hasValue("SPPPOLI") ? $CurrentForm->getValue("SPPPOLI") : $CurrentForm->getValue("x_SPPPOLI");
        if (!$this->SPPPOLI->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->SPPPOLI->Visible = false; // Disable update for API request
            } else {
                $this->SPPPOLI->setFormValue($val);
            }
        }

        // Check field name 'SPPPOLIUSER' first before field var 'x_SPPPOLIUSER'
        $val = $CurrentForm->hasValue("SPPPOLIUSER") ? $CurrentForm->getValue("SPPPOLIUSER") : $CurrentForm->getValue("x_SPPPOLIUSER");
        if (!$this->SPPPOLIUSER->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->SPPPOLIUSER->Visible = false; // Disable update for API request
            } else {
                $this->SPPPOLIUSER->setFormValue($val);
            }
        }

        // Check field name 'SPPPOLIDATE' first before field var 'x_SPPPOLIDATE'
        $val = $CurrentForm->hasValue("SPPPOLIDATE") ? $CurrentForm->getValue("SPPPOLIDATE") : $CurrentForm->getValue("x_SPPPOLIDATE");
        if (!$this->SPPPOLIDATE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->SPPPOLIDATE->Visible = false; // Disable update for API request
            } else {
                $this->SPPPOLIDATE->setFormValue($val);
            }
            $this->SPPPOLIDATE->CurrentValue = UnFormatDateTime($this->SPPPOLIDATE->CurrentValue, 0);
        }

        // Check field name 'ID' first before field var 'x_ID'
        $val = $CurrentForm->hasValue("ID") ? $CurrentForm->getValue("ID") : $CurrentForm->getValue("x_ID");
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->ORG_UNIT_CODE->CurrentValue = $this->ORG_UNIT_CODE->FormValue;
        $this->BILL_ID->CurrentValue = $this->BILL_ID->FormValue;
        $this->NO_REGISTRATION->CurrentValue = $this->NO_REGISTRATION->FormValue;
        $this->VISIT_ID->CurrentValue = $this->VISIT_ID->FormValue;
        $this->TARIF_ID->CurrentValue = $this->TARIF_ID->FormValue;
        $this->CLASS_ID->CurrentValue = $this->CLASS_ID->FormValue;
        $this->CLINIC_ID->CurrentValue = $this->CLINIC_ID->FormValue;
        $this->CLINIC_ID_FROM->CurrentValue = $this->CLINIC_ID_FROM->FormValue;
        $this->TREATMENT->CurrentValue = $this->TREATMENT->FormValue;
        $this->TREAT_DATE->CurrentValue = $this->TREAT_DATE->FormValue;
        $this->TREAT_DATE->CurrentValue = UnFormatDateTime($this->TREAT_DATE->CurrentValue, 0);
        $this->AMOUNT->CurrentValue = $this->AMOUNT->FormValue;
        $this->QUANTITY->CurrentValue = $this->QUANTITY->FormValue;
        $this->MEASURE_ID->CurrentValue = $this->MEASURE_ID->FormValue;
        $this->POKOK_JUAL->CurrentValue = $this->POKOK_JUAL->FormValue;
        $this->PPN->CurrentValue = $this->PPN->FormValue;
        $this->MARGIN->CurrentValue = $this->MARGIN->FormValue;
        $this->SUBSIDI->CurrentValue = $this->SUBSIDI->FormValue;
        $this->EMBALACE->CurrentValue = $this->EMBALACE->FormValue;
        $this->PROFESI->CurrentValue = $this->PROFESI->FormValue;
        $this->DISCOUNT->CurrentValue = $this->DISCOUNT->FormValue;
        $this->PAY_METHOD_ID->CurrentValue = $this->PAY_METHOD_ID->FormValue;
        $this->PAYMENT_DATE->CurrentValue = $this->PAYMENT_DATE->FormValue;
        $this->PAYMENT_DATE->CurrentValue = UnFormatDateTime($this->PAYMENT_DATE->CurrentValue, 0);
        $this->ISLUNAS->CurrentValue = $this->ISLUNAS->FormValue;
        $this->DUEDATE_ANGSURAN->CurrentValue = $this->DUEDATE_ANGSURAN->FormValue;
        $this->DUEDATE_ANGSURAN->CurrentValue = UnFormatDateTime($this->DUEDATE_ANGSURAN->CurrentValue, 0);
        $this->DESCRIPTION->CurrentValue = $this->DESCRIPTION->FormValue;
        $this->KUITANSI_ID->CurrentValue = $this->KUITANSI_ID->FormValue;
        $this->NOTA_NO->CurrentValue = $this->NOTA_NO->FormValue;
        $this->ISCETAK->CurrentValue = $this->ISCETAK->FormValue;
        $this->PRINT_DATE->CurrentValue = $this->PRINT_DATE->FormValue;
        $this->PRINT_DATE->CurrentValue = UnFormatDateTime($this->PRINT_DATE->CurrentValue, 0);
        $this->RESEP_NO->CurrentValue = $this->RESEP_NO->FormValue;
        $this->RESEP_KE->CurrentValue = $this->RESEP_KE->FormValue;
        $this->DOSE->CurrentValue = $this->DOSE->FormValue;
        $this->ORIG_DOSE->CurrentValue = $this->ORIG_DOSE->FormValue;
        $this->DOSE_PRESC->CurrentValue = $this->DOSE_PRESC->FormValue;
        $this->ITER->CurrentValue = $this->ITER->FormValue;
        $this->ITER_KE->CurrentValue = $this->ITER_KE->FormValue;
        $this->SOLD_STATUS->CurrentValue = $this->SOLD_STATUS->FormValue;
        $this->RACIKAN->CurrentValue = $this->RACIKAN->FormValue;
        $this->CLASS_ROOM_ID->CurrentValue = $this->CLASS_ROOM_ID->FormValue;
        $this->KELUAR_ID->CurrentValue = $this->KELUAR_ID->FormValue;
        $this->BED_ID->CurrentValue = $this->BED_ID->FormValue;
        $this->PERDA_ID->CurrentValue = $this->PERDA_ID->FormValue;
        $this->EMPLOYEE_ID->CurrentValue = $this->EMPLOYEE_ID->FormValue;
        $this->DESCRIPTION2->CurrentValue = $this->DESCRIPTION2->FormValue;
        $this->MODIFIED_BY->CurrentValue = $this->MODIFIED_BY->FormValue;
        $this->MODIFIED_DATE->CurrentValue = $this->MODIFIED_DATE->FormValue;
        $this->MODIFIED_DATE->CurrentValue = UnFormatDateTime($this->MODIFIED_DATE->CurrentValue, 0);
        $this->MODIFIED_FROM->CurrentValue = $this->MODIFIED_FROM->FormValue;
        $this->BRAND_ID->CurrentValue = $this->BRAND_ID->FormValue;
        $this->DOCTOR->CurrentValue = $this->DOCTOR->FormValue;
        $this->JML_BKS->CurrentValue = $this->JML_BKS->FormValue;
        $this->EXIT_DATE->CurrentValue = $this->EXIT_DATE->FormValue;
        $this->EXIT_DATE->CurrentValue = UnFormatDateTime($this->EXIT_DATE->CurrentValue, 0);
        $this->FA_V->CurrentValue = $this->FA_V->FormValue;
        $this->TASK_ID->CurrentValue = $this->TASK_ID->FormValue;
        $this->EMPLOYEE_ID_FROM->CurrentValue = $this->EMPLOYEE_ID_FROM->FormValue;
        $this->DOCTOR_FROM->CurrentValue = $this->DOCTOR_FROM->FormValue;
        $this->status_pasien_id->CurrentValue = $this->status_pasien_id->FormValue;
        $this->amount_paid->CurrentValue = $this->amount_paid->FormValue;
        $this->THENAME->CurrentValue = $this->THENAME->FormValue;
        $this->THEADDRESS->CurrentValue = $this->THEADDRESS->FormValue;
        $this->THEID->CurrentValue = $this->THEID->FormValue;
        $this->serial_nb->CurrentValue = $this->serial_nb->FormValue;
        $this->TREATMENT_PLAFOND->CurrentValue = $this->TREATMENT_PLAFOND->FormValue;
        $this->AMOUNT_PLAFOND->CurrentValue = $this->AMOUNT_PLAFOND->FormValue;
        $this->AMOUNT_PAID_PLAFOND->CurrentValue = $this->AMOUNT_PAID_PLAFOND->FormValue;
        $this->CLASS_ID_PLAFOND->CurrentValue = $this->CLASS_ID_PLAFOND->FormValue;
        $this->PAYOR_ID->CurrentValue = $this->PAYOR_ID->FormValue;
        $this->PEMBULATAN->CurrentValue = $this->PEMBULATAN->FormValue;
        $this->ISRJ->CurrentValue = $this->ISRJ->FormValue;
        $this->AGEYEAR->CurrentValue = $this->AGEYEAR->FormValue;
        $this->AGEMONTH->CurrentValue = $this->AGEMONTH->FormValue;
        $this->AGEDAY->CurrentValue = $this->AGEDAY->FormValue;
        $this->GENDER->CurrentValue = $this->GENDER->FormValue;
        $this->KAL_ID->CurrentValue = $this->KAL_ID->FormValue;
        $this->CORRECTION_ID->CurrentValue = $this->CORRECTION_ID->FormValue;
        $this->CORRECTION_BY->CurrentValue = $this->CORRECTION_BY->FormValue;
        $this->KARYAWAN->CurrentValue = $this->KARYAWAN->FormValue;
        $this->ACCOUNT_ID->CurrentValue = $this->ACCOUNT_ID->FormValue;
        $this->sell_price->CurrentValue = $this->sell_price->FormValue;
        $this->diskon->CurrentValue = $this->diskon->FormValue;
        $this->INVOICE_ID->CurrentValue = $this->INVOICE_ID->FormValue;
        $this->NUMER->CurrentValue = $this->NUMER->FormValue;
        $this->MEASURE_ID2->CurrentValue = $this->MEASURE_ID2->FormValue;
        $this->POTONGAN->CurrentValue = $this->POTONGAN->FormValue;
        $this->BAYAR->CurrentValue = $this->BAYAR->FormValue;
        $this->RETUR->CurrentValue = $this->RETUR->FormValue;
        $this->TARIF_TYPE->CurrentValue = $this->TARIF_TYPE->FormValue;
        $this->PPNVALUE->CurrentValue = $this->PPNVALUE->FormValue;
        $this->TAGIHAN->CurrentValue = $this->TAGIHAN->FormValue;
        $this->KOREKSI->CurrentValue = $this->KOREKSI->FormValue;
        $this->STATUS_OBAT->CurrentValue = $this->STATUS_OBAT->FormValue;
        $this->SUBSIDISAT->CurrentValue = $this->SUBSIDISAT->FormValue;
        $this->PRINTQ->CurrentValue = $this->PRINTQ->FormValue;
        $this->PRINTED_BY->CurrentValue = $this->PRINTED_BY->FormValue;
        $this->STOCK_AVAILABLE->CurrentValue = $this->STOCK_AVAILABLE->FormValue;
        $this->STATUS_TARIF->CurrentValue = $this->STATUS_TARIF->FormValue;
        $this->CLINIC_TYPE->CurrentValue = $this->CLINIC_TYPE->FormValue;
        $this->PACKAGE_ID->CurrentValue = $this->PACKAGE_ID->FormValue;
        $this->MODULE_ID->CurrentValue = $this->MODULE_ID->FormValue;
        $this->profession->CurrentValue = $this->profession->FormValue;
        $this->THEORDER->CurrentValue = $this->THEORDER->FormValue;
        $this->CASHIER->CurrentValue = $this->CASHIER->FormValue;
        $this->SPPFEE->CurrentValue = $this->SPPFEE->FormValue;
        $this->SPPBILL->CurrentValue = $this->SPPBILL->FormValue;
        $this->SPPRJK->CurrentValue = $this->SPPRJK->FormValue;
        $this->SPPJMN->CurrentValue = $this->SPPJMN->FormValue;
        $this->SPPKASIR->CurrentValue = $this->SPPKASIR->FormValue;
        $this->PERUJUK->CurrentValue = $this->PERUJUK->FormValue;
        $this->PERUJUKFEE->CurrentValue = $this->PERUJUKFEE->FormValue;
        $this->modified_datesys->CurrentValue = $this->modified_datesys->FormValue;
        $this->modified_datesys->CurrentValue = UnFormatDateTime($this->modified_datesys->CurrentValue, 0);
        $this->TRANS_ID->CurrentValue = $this->TRANS_ID->FormValue;
        $this->SPPBILLDATE->CurrentValue = $this->SPPBILLDATE->FormValue;
        $this->SPPBILLDATE->CurrentValue = UnFormatDateTime($this->SPPBILLDATE->CurrentValue, 0);
        $this->SPPBILLUSER->CurrentValue = $this->SPPBILLUSER->FormValue;
        $this->SPPKASIRDATE->CurrentValue = $this->SPPKASIRDATE->FormValue;
        $this->SPPKASIRDATE->CurrentValue = UnFormatDateTime($this->SPPKASIRDATE->CurrentValue, 0);
        $this->SPPKASIRUSER->CurrentValue = $this->SPPKASIRUSER->FormValue;
        $this->SPPPOLI->CurrentValue = $this->SPPPOLI->FormValue;
        $this->SPPPOLIUSER->CurrentValue = $this->SPPPOLIUSER->FormValue;
        $this->SPPPOLIDATE->CurrentValue = $this->SPPPOLIDATE->FormValue;
        $this->SPPPOLIDATE->CurrentValue = UnFormatDateTime($this->SPPPOLIDATE->CurrentValue, 0);
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
        $this->ID->setDbValue($row['ID']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $this->loadDefaultValues();
        $row = [];
        $row['ORG_UNIT_CODE'] = $this->ORG_UNIT_CODE->CurrentValue;
        $row['BILL_ID'] = $this->BILL_ID->CurrentValue;
        $row['NO_REGISTRATION'] = $this->NO_REGISTRATION->CurrentValue;
        $row['VISIT_ID'] = $this->VISIT_ID->CurrentValue;
        $row['TARIF_ID'] = $this->TARIF_ID->CurrentValue;
        $row['CLASS_ID'] = $this->CLASS_ID->CurrentValue;
        $row['CLINIC_ID'] = $this->CLINIC_ID->CurrentValue;
        $row['CLINIC_ID_FROM'] = $this->CLINIC_ID_FROM->CurrentValue;
        $row['TREATMENT'] = $this->TREATMENT->CurrentValue;
        $row['TREAT_DATE'] = $this->TREAT_DATE->CurrentValue;
        $row['AMOUNT'] = $this->AMOUNT->CurrentValue;
        $row['QUANTITY'] = $this->QUANTITY->CurrentValue;
        $row['MEASURE_ID'] = $this->MEASURE_ID->CurrentValue;
        $row['POKOK_JUAL'] = $this->POKOK_JUAL->CurrentValue;
        $row['PPN'] = $this->PPN->CurrentValue;
        $row['MARGIN'] = $this->MARGIN->CurrentValue;
        $row['SUBSIDI'] = $this->SUBSIDI->CurrentValue;
        $row['EMBALACE'] = $this->EMBALACE->CurrentValue;
        $row['PROFESI'] = $this->PROFESI->CurrentValue;
        $row['DISCOUNT'] = $this->DISCOUNT->CurrentValue;
        $row['PAY_METHOD_ID'] = $this->PAY_METHOD_ID->CurrentValue;
        $row['PAYMENT_DATE'] = $this->PAYMENT_DATE->CurrentValue;
        $row['ISLUNAS'] = $this->ISLUNAS->CurrentValue;
        $row['DUEDATE_ANGSURAN'] = $this->DUEDATE_ANGSURAN->CurrentValue;
        $row['DESCRIPTION'] = $this->DESCRIPTION->CurrentValue;
        $row['KUITANSI_ID'] = $this->KUITANSI_ID->CurrentValue;
        $row['NOTA_NO'] = $this->NOTA_NO->CurrentValue;
        $row['ISCETAK'] = $this->ISCETAK->CurrentValue;
        $row['PRINT_DATE'] = $this->PRINT_DATE->CurrentValue;
        $row['RESEP_NO'] = $this->RESEP_NO->CurrentValue;
        $row['RESEP_KE'] = $this->RESEP_KE->CurrentValue;
        $row['DOSE'] = $this->DOSE->CurrentValue;
        $row['ORIG_DOSE'] = $this->ORIG_DOSE->CurrentValue;
        $row['DOSE_PRESC'] = $this->DOSE_PRESC->CurrentValue;
        $row['ITER'] = $this->ITER->CurrentValue;
        $row['ITER_KE'] = $this->ITER_KE->CurrentValue;
        $row['SOLD_STATUS'] = $this->SOLD_STATUS->CurrentValue;
        $row['RACIKAN'] = $this->RACIKAN->CurrentValue;
        $row['CLASS_ROOM_ID'] = $this->CLASS_ROOM_ID->CurrentValue;
        $row['KELUAR_ID'] = $this->KELUAR_ID->CurrentValue;
        $row['BED_ID'] = $this->BED_ID->CurrentValue;
        $row['PERDA_ID'] = $this->PERDA_ID->CurrentValue;
        $row['EMPLOYEE_ID'] = $this->EMPLOYEE_ID->CurrentValue;
        $row['DESCRIPTION2'] = $this->DESCRIPTION2->CurrentValue;
        $row['MODIFIED_BY'] = $this->MODIFIED_BY->CurrentValue;
        $row['MODIFIED_DATE'] = $this->MODIFIED_DATE->CurrentValue;
        $row['MODIFIED_FROM'] = $this->MODIFIED_FROM->CurrentValue;
        $row['BRAND_ID'] = $this->BRAND_ID->CurrentValue;
        $row['DOCTOR'] = $this->DOCTOR->CurrentValue;
        $row['JML_BKS'] = $this->JML_BKS->CurrentValue;
        $row['EXIT_DATE'] = $this->EXIT_DATE->CurrentValue;
        $row['FA_V'] = $this->FA_V->CurrentValue;
        $row['TASK_ID'] = $this->TASK_ID->CurrentValue;
        $row['EMPLOYEE_ID_FROM'] = $this->EMPLOYEE_ID_FROM->CurrentValue;
        $row['DOCTOR_FROM'] = $this->DOCTOR_FROM->CurrentValue;
        $row['status_pasien_id'] = $this->status_pasien_id->CurrentValue;
        $row['amount_paid'] = $this->amount_paid->CurrentValue;
        $row['THENAME'] = $this->THENAME->CurrentValue;
        $row['THEADDRESS'] = $this->THEADDRESS->CurrentValue;
        $row['THEID'] = $this->THEID->CurrentValue;
        $row['serial_nb'] = $this->serial_nb->CurrentValue;
        $row['TREATMENT_PLAFOND'] = $this->TREATMENT_PLAFOND->CurrentValue;
        $row['AMOUNT_PLAFOND'] = $this->AMOUNT_PLAFOND->CurrentValue;
        $row['AMOUNT_PAID_PLAFOND'] = $this->AMOUNT_PAID_PLAFOND->CurrentValue;
        $row['CLASS_ID_PLAFOND'] = $this->CLASS_ID_PLAFOND->CurrentValue;
        $row['PAYOR_ID'] = $this->PAYOR_ID->CurrentValue;
        $row['PEMBULATAN'] = $this->PEMBULATAN->CurrentValue;
        $row['ISRJ'] = $this->ISRJ->CurrentValue;
        $row['AGEYEAR'] = $this->AGEYEAR->CurrentValue;
        $row['AGEMONTH'] = $this->AGEMONTH->CurrentValue;
        $row['AGEDAY'] = $this->AGEDAY->CurrentValue;
        $row['GENDER'] = $this->GENDER->CurrentValue;
        $row['KAL_ID'] = $this->KAL_ID->CurrentValue;
        $row['CORRECTION_ID'] = $this->CORRECTION_ID->CurrentValue;
        $row['CORRECTION_BY'] = $this->CORRECTION_BY->CurrentValue;
        $row['KARYAWAN'] = $this->KARYAWAN->CurrentValue;
        $row['ACCOUNT_ID'] = $this->ACCOUNT_ID->CurrentValue;
        $row['sell_price'] = $this->sell_price->CurrentValue;
        $row['diskon'] = $this->diskon->CurrentValue;
        $row['INVOICE_ID'] = $this->INVOICE_ID->CurrentValue;
        $row['NUMER'] = $this->NUMER->CurrentValue;
        $row['MEASURE_ID2'] = $this->MEASURE_ID2->CurrentValue;
        $row['POTONGAN'] = $this->POTONGAN->CurrentValue;
        $row['BAYAR'] = $this->BAYAR->CurrentValue;
        $row['RETUR'] = $this->RETUR->CurrentValue;
        $row['TARIF_TYPE'] = $this->TARIF_TYPE->CurrentValue;
        $row['PPNVALUE'] = $this->PPNVALUE->CurrentValue;
        $row['TAGIHAN'] = $this->TAGIHAN->CurrentValue;
        $row['KOREKSI'] = $this->KOREKSI->CurrentValue;
        $row['STATUS_OBAT'] = $this->STATUS_OBAT->CurrentValue;
        $row['SUBSIDISAT'] = $this->SUBSIDISAT->CurrentValue;
        $row['PRINTQ'] = $this->PRINTQ->CurrentValue;
        $row['PRINTED_BY'] = $this->PRINTED_BY->CurrentValue;
        $row['STOCK_AVAILABLE'] = $this->STOCK_AVAILABLE->CurrentValue;
        $row['STATUS_TARIF'] = $this->STATUS_TARIF->CurrentValue;
        $row['CLINIC_TYPE'] = $this->CLINIC_TYPE->CurrentValue;
        $row['PACKAGE_ID'] = $this->PACKAGE_ID->CurrentValue;
        $row['MODULE_ID'] = $this->MODULE_ID->CurrentValue;
        $row['profession'] = $this->profession->CurrentValue;
        $row['THEORDER'] = $this->THEORDER->CurrentValue;
        $row['CASHIER'] = $this->CASHIER->CurrentValue;
        $row['SPPFEE'] = $this->SPPFEE->CurrentValue;
        $row['SPPBILL'] = $this->SPPBILL->CurrentValue;
        $row['SPPRJK'] = $this->SPPRJK->CurrentValue;
        $row['SPPJMN'] = $this->SPPJMN->CurrentValue;
        $row['SPPKASIR'] = $this->SPPKASIR->CurrentValue;
        $row['PERUJUK'] = $this->PERUJUK->CurrentValue;
        $row['PERUJUKFEE'] = $this->PERUJUKFEE->CurrentValue;
        $row['modified_datesys'] = $this->modified_datesys->CurrentValue;
        $row['TRANS_ID'] = $this->TRANS_ID->CurrentValue;
        $row['SPPBILLDATE'] = $this->SPPBILLDATE->CurrentValue;
        $row['SPPBILLUSER'] = $this->SPPBILLUSER->CurrentValue;
        $row['SPPKASIRDATE'] = $this->SPPKASIRDATE->CurrentValue;
        $row['SPPKASIRUSER'] = $this->SPPKASIRUSER->CurrentValue;
        $row['SPPPOLI'] = $this->SPPPOLI->CurrentValue;
        $row['SPPPOLIUSER'] = $this->SPPPOLIUSER->CurrentValue;
        $row['SPPPOLIDATE'] = $this->SPPPOLIDATE->CurrentValue;
        $row['ID'] = $this->ID->CurrentValue;
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
        if ($this->amount_paid->FormValue == $this->amount_paid->CurrentValue && is_numeric(ConvertToFloatString($this->amount_paid->CurrentValue))) {
            $this->amount_paid->CurrentValue = ConvertToFloatString($this->amount_paid->CurrentValue);
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

        // Convert decimal values if posted back
        if ($this->PERUJUKFEE->FormValue == $this->PERUJUKFEE->CurrentValue && is_numeric(ConvertToFloatString($this->PERUJUKFEE->CurrentValue))) {
            $this->PERUJUKFEE->CurrentValue = ConvertToFloatString($this->PERUJUKFEE->CurrentValue);
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

        // amount_paid

        // THENAME

        // THEADDRESS

        // THEID

        // serial_nb

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

        // SPPFEE

        // SPPBILL

        // SPPRJK

        // SPPJMN

        // SPPKASIR

        // PERUJUK

        // PERUJUKFEE

        // modified_datesys

        // TRANS_ID

        // SPPBILLDATE

        // SPPBILLUSER

        // SPPKASIRDATE

        // SPPKASIRUSER

        // SPPPOLI

        // SPPPOLIUSER

        // SPPPOLIDATE

        // ID
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

            // amount_paid
            $this->amount_paid->ViewValue = $this->amount_paid->CurrentValue;
            $this->amount_paid->ViewValue = FormatNumber($this->amount_paid->ViewValue, 2, -2, -2, -2);
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
            $this->PERUJUKFEE->ViewValue = FormatNumber($this->PERUJUKFEE->ViewValue, 2, -2, -2, -2);
            $this->PERUJUKFEE->ViewCustomAttributes = "";

            // modified_datesys
            $this->modified_datesys->ViewValue = $this->modified_datesys->CurrentValue;
            $this->modified_datesys->ViewValue = FormatDateTime($this->modified_datesys->ViewValue, 0);
            $this->modified_datesys->ViewCustomAttributes = "";

            // TRANS_ID
            $this->TRANS_ID->ViewValue = $this->TRANS_ID->CurrentValue;
            $this->TRANS_ID->ViewCustomAttributes = "";

            // SPPBILLDATE
            $this->SPPBILLDATE->ViewValue = $this->SPPBILLDATE->CurrentValue;
            $this->SPPBILLDATE->ViewValue = FormatDateTime($this->SPPBILLDATE->ViewValue, 0);
            $this->SPPBILLDATE->ViewCustomAttributes = "";

            // SPPBILLUSER
            $this->SPPBILLUSER->ViewValue = $this->SPPBILLUSER->CurrentValue;
            $this->SPPBILLUSER->ViewCustomAttributes = "";

            // SPPKASIRDATE
            $this->SPPKASIRDATE->ViewValue = $this->SPPKASIRDATE->CurrentValue;
            $this->SPPKASIRDATE->ViewValue = FormatDateTime($this->SPPKASIRDATE->ViewValue, 0);
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
            $this->SPPPOLIDATE->ViewValue = FormatDateTime($this->SPPPOLIDATE->ViewValue, 0);
            $this->SPPPOLIDATE->ViewCustomAttributes = "";

            // ID
            $this->ID->ViewValue = $this->ID->CurrentValue;
            $this->ID->ViewCustomAttributes = "";

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

            // serial_nb
            $this->serial_nb->LinkCustomAttributes = "";
            $this->serial_nb->HrefValue = "";
            $this->serial_nb->TooltipValue = "";

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

            // SPPFEE
            $this->SPPFEE->LinkCustomAttributes = "";
            $this->SPPFEE->HrefValue = "";
            $this->SPPFEE->TooltipValue = "";

            // SPPBILL
            $this->SPPBILL->LinkCustomAttributes = "";
            $this->SPPBILL->HrefValue = "";
            $this->SPPBILL->TooltipValue = "";

            // SPPRJK
            $this->SPPRJK->LinkCustomAttributes = "";
            $this->SPPRJK->HrefValue = "";
            $this->SPPRJK->TooltipValue = "";

            // SPPJMN
            $this->SPPJMN->LinkCustomAttributes = "";
            $this->SPPJMN->HrefValue = "";
            $this->SPPJMN->TooltipValue = "";

            // SPPKASIR
            $this->SPPKASIR->LinkCustomAttributes = "";
            $this->SPPKASIR->HrefValue = "";
            $this->SPPKASIR->TooltipValue = "";

            // PERUJUK
            $this->PERUJUK->LinkCustomAttributes = "";
            $this->PERUJUK->HrefValue = "";
            $this->PERUJUK->TooltipValue = "";

            // PERUJUKFEE
            $this->PERUJUKFEE->LinkCustomAttributes = "";
            $this->PERUJUKFEE->HrefValue = "";
            $this->PERUJUKFEE->TooltipValue = "";

            // modified_datesys
            $this->modified_datesys->LinkCustomAttributes = "";
            $this->modified_datesys->HrefValue = "";
            $this->modified_datesys->TooltipValue = "";

            // TRANS_ID
            $this->TRANS_ID->LinkCustomAttributes = "";
            $this->TRANS_ID->HrefValue = "";
            $this->TRANS_ID->TooltipValue = "";

            // SPPBILLDATE
            $this->SPPBILLDATE->LinkCustomAttributes = "";
            $this->SPPBILLDATE->HrefValue = "";
            $this->SPPBILLDATE->TooltipValue = "";

            // SPPBILLUSER
            $this->SPPBILLUSER->LinkCustomAttributes = "";
            $this->SPPBILLUSER->HrefValue = "";
            $this->SPPBILLUSER->TooltipValue = "";

            // SPPKASIRDATE
            $this->SPPKASIRDATE->LinkCustomAttributes = "";
            $this->SPPKASIRDATE->HrefValue = "";
            $this->SPPKASIRDATE->TooltipValue = "";

            // SPPKASIRUSER
            $this->SPPKASIRUSER->LinkCustomAttributes = "";
            $this->SPPKASIRUSER->HrefValue = "";
            $this->SPPKASIRUSER->TooltipValue = "";

            // SPPPOLI
            $this->SPPPOLI->LinkCustomAttributes = "";
            $this->SPPPOLI->HrefValue = "";
            $this->SPPPOLI->TooltipValue = "";

            // SPPPOLIUSER
            $this->SPPPOLIUSER->LinkCustomAttributes = "";
            $this->SPPPOLIUSER->HrefValue = "";
            $this->SPPPOLIUSER->TooltipValue = "";

            // SPPPOLIDATE
            $this->SPPPOLIDATE->LinkCustomAttributes = "";
            $this->SPPPOLIDATE->HrefValue = "";
            $this->SPPPOLIDATE->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // ORG_UNIT_CODE
            $this->ORG_UNIT_CODE->EditAttrs["class"] = "form-control";
            $this->ORG_UNIT_CODE->EditCustomAttributes = "";
            if (!$this->ORG_UNIT_CODE->Raw) {
                $this->ORG_UNIT_CODE->CurrentValue = HtmlDecode($this->ORG_UNIT_CODE->CurrentValue);
            }
            $this->ORG_UNIT_CODE->EditValue = HtmlEncode($this->ORG_UNIT_CODE->CurrentValue);
            $this->ORG_UNIT_CODE->PlaceHolder = RemoveHtml($this->ORG_UNIT_CODE->caption());

            // BILL_ID
            $this->BILL_ID->EditAttrs["class"] = "form-control";
            $this->BILL_ID->EditCustomAttributes = "";
            if (!$this->BILL_ID->Raw) {
                $this->BILL_ID->CurrentValue = HtmlDecode($this->BILL_ID->CurrentValue);
            }
            $this->BILL_ID->EditValue = HtmlEncode($this->BILL_ID->CurrentValue);
            $this->BILL_ID->PlaceHolder = RemoveHtml($this->BILL_ID->caption());

            // NO_REGISTRATION
            $this->NO_REGISTRATION->EditAttrs["class"] = "form-control";
            $this->NO_REGISTRATION->EditCustomAttributes = "";
            if (!$this->NO_REGISTRATION->Raw) {
                $this->NO_REGISTRATION->CurrentValue = HtmlDecode($this->NO_REGISTRATION->CurrentValue);
            }
            $this->NO_REGISTRATION->EditValue = HtmlEncode($this->NO_REGISTRATION->CurrentValue);
            $this->NO_REGISTRATION->PlaceHolder = RemoveHtml($this->NO_REGISTRATION->caption());

            // VISIT_ID
            $this->VISIT_ID->EditAttrs["class"] = "form-control";
            $this->VISIT_ID->EditCustomAttributes = "";
            if (!$this->VISIT_ID->Raw) {
                $this->VISIT_ID->CurrentValue = HtmlDecode($this->VISIT_ID->CurrentValue);
            }
            $this->VISIT_ID->EditValue = HtmlEncode($this->VISIT_ID->CurrentValue);
            $this->VISIT_ID->PlaceHolder = RemoveHtml($this->VISIT_ID->caption());

            // TARIF_ID
            $this->TARIF_ID->EditAttrs["class"] = "form-control";
            $this->TARIF_ID->EditCustomAttributes = "";
            if (!$this->TARIF_ID->Raw) {
                $this->TARIF_ID->CurrentValue = HtmlDecode($this->TARIF_ID->CurrentValue);
            }
            $this->TARIF_ID->EditValue = HtmlEncode($this->TARIF_ID->CurrentValue);
            $this->TARIF_ID->PlaceHolder = RemoveHtml($this->TARIF_ID->caption());

            // CLASS_ID
            $this->CLASS_ID->EditAttrs["class"] = "form-control";
            $this->CLASS_ID->EditCustomAttributes = "";
            $this->CLASS_ID->EditValue = HtmlEncode($this->CLASS_ID->CurrentValue);
            $this->CLASS_ID->PlaceHolder = RemoveHtml($this->CLASS_ID->caption());

            // CLINIC_ID
            $this->CLINIC_ID->EditAttrs["class"] = "form-control";
            $this->CLINIC_ID->EditCustomAttributes = "";
            if (!$this->CLINIC_ID->Raw) {
                $this->CLINIC_ID->CurrentValue = HtmlDecode($this->CLINIC_ID->CurrentValue);
            }
            $this->CLINIC_ID->EditValue = HtmlEncode($this->CLINIC_ID->CurrentValue);
            $this->CLINIC_ID->PlaceHolder = RemoveHtml($this->CLINIC_ID->caption());

            // CLINIC_ID_FROM
            $this->CLINIC_ID_FROM->EditAttrs["class"] = "form-control";
            $this->CLINIC_ID_FROM->EditCustomAttributes = "";
            if (!$this->CLINIC_ID_FROM->Raw) {
                $this->CLINIC_ID_FROM->CurrentValue = HtmlDecode($this->CLINIC_ID_FROM->CurrentValue);
            }
            $this->CLINIC_ID_FROM->EditValue = HtmlEncode($this->CLINIC_ID_FROM->CurrentValue);
            $this->CLINIC_ID_FROM->PlaceHolder = RemoveHtml($this->CLINIC_ID_FROM->caption());

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
            $this->TREAT_DATE->EditValue = HtmlEncode(FormatDateTime($this->TREAT_DATE->CurrentValue, 8));
            $this->TREAT_DATE->PlaceHolder = RemoveHtml($this->TREAT_DATE->caption());

            // AMOUNT
            $this->AMOUNT->EditAttrs["class"] = "form-control";
            $this->AMOUNT->EditCustomAttributes = "";
            $this->AMOUNT->EditValue = HtmlEncode($this->AMOUNT->CurrentValue);
            $this->AMOUNT->PlaceHolder = RemoveHtml($this->AMOUNT->caption());
            if (strval($this->AMOUNT->EditValue) != "" && is_numeric($this->AMOUNT->EditValue)) {
                $this->AMOUNT->EditValue = FormatNumber($this->AMOUNT->EditValue, -2, -2, -2, -2);
            }

            // QUANTITY
            $this->QUANTITY->EditAttrs["class"] = "form-control";
            $this->QUANTITY->EditCustomAttributes = "";
            $this->QUANTITY->EditValue = HtmlEncode($this->QUANTITY->CurrentValue);
            $this->QUANTITY->PlaceHolder = RemoveHtml($this->QUANTITY->caption());
            if (strval($this->QUANTITY->EditValue) != "" && is_numeric($this->QUANTITY->EditValue)) {
                $this->QUANTITY->EditValue = FormatNumber($this->QUANTITY->EditValue, -2, -2, -2, -2);
            }

            // MEASURE_ID
            $this->MEASURE_ID->EditAttrs["class"] = "form-control";
            $this->MEASURE_ID->EditCustomAttributes = "";
            $this->MEASURE_ID->EditValue = HtmlEncode($this->MEASURE_ID->CurrentValue);
            $this->MEASURE_ID->PlaceHolder = RemoveHtml($this->MEASURE_ID->caption());

            // POKOK_JUAL
            $this->POKOK_JUAL->EditAttrs["class"] = "form-control";
            $this->POKOK_JUAL->EditCustomAttributes = "";
            $this->POKOK_JUAL->EditValue = HtmlEncode($this->POKOK_JUAL->CurrentValue);
            $this->POKOK_JUAL->PlaceHolder = RemoveHtml($this->POKOK_JUAL->caption());
            if (strval($this->POKOK_JUAL->EditValue) != "" && is_numeric($this->POKOK_JUAL->EditValue)) {
                $this->POKOK_JUAL->EditValue = FormatNumber($this->POKOK_JUAL->EditValue, -2, -2, -2, -2);
            }

            // PPN
            $this->PPN->EditAttrs["class"] = "form-control";
            $this->PPN->EditCustomAttributes = "";
            $this->PPN->EditValue = HtmlEncode($this->PPN->CurrentValue);
            $this->PPN->PlaceHolder = RemoveHtml($this->PPN->caption());
            if (strval($this->PPN->EditValue) != "" && is_numeric($this->PPN->EditValue)) {
                $this->PPN->EditValue = FormatNumber($this->PPN->EditValue, -2, -2, -2, -2);
            }

            // MARGIN
            $this->MARGIN->EditAttrs["class"] = "form-control";
            $this->MARGIN->EditCustomAttributes = "";
            $this->MARGIN->EditValue = HtmlEncode($this->MARGIN->CurrentValue);
            $this->MARGIN->PlaceHolder = RemoveHtml($this->MARGIN->caption());
            if (strval($this->MARGIN->EditValue) != "" && is_numeric($this->MARGIN->EditValue)) {
                $this->MARGIN->EditValue = FormatNumber($this->MARGIN->EditValue, -2, -2, -2, -2);
            }

            // SUBSIDI
            $this->SUBSIDI->EditAttrs["class"] = "form-control";
            $this->SUBSIDI->EditCustomAttributes = "";
            $this->SUBSIDI->EditValue = HtmlEncode($this->SUBSIDI->CurrentValue);
            $this->SUBSIDI->PlaceHolder = RemoveHtml($this->SUBSIDI->caption());
            if (strval($this->SUBSIDI->EditValue) != "" && is_numeric($this->SUBSIDI->EditValue)) {
                $this->SUBSIDI->EditValue = FormatNumber($this->SUBSIDI->EditValue, -2, -2, -2, -2);
            }

            // EMBALACE
            $this->EMBALACE->EditAttrs["class"] = "form-control";
            $this->EMBALACE->EditCustomAttributes = "";
            $this->EMBALACE->EditValue = HtmlEncode($this->EMBALACE->CurrentValue);
            $this->EMBALACE->PlaceHolder = RemoveHtml($this->EMBALACE->caption());
            if (strval($this->EMBALACE->EditValue) != "" && is_numeric($this->EMBALACE->EditValue)) {
                $this->EMBALACE->EditValue = FormatNumber($this->EMBALACE->EditValue, -2, -2, -2, -2);
            }

            // PROFESI
            $this->PROFESI->EditAttrs["class"] = "form-control";
            $this->PROFESI->EditCustomAttributes = "";
            $this->PROFESI->EditValue = HtmlEncode($this->PROFESI->CurrentValue);
            $this->PROFESI->PlaceHolder = RemoveHtml($this->PROFESI->caption());
            if (strval($this->PROFESI->EditValue) != "" && is_numeric($this->PROFESI->EditValue)) {
                $this->PROFESI->EditValue = FormatNumber($this->PROFESI->EditValue, -2, -2, -2, -2);
            }

            // DISCOUNT
            $this->DISCOUNT->EditAttrs["class"] = "form-control";
            $this->DISCOUNT->EditCustomAttributes = "";
            $this->DISCOUNT->EditValue = HtmlEncode($this->DISCOUNT->CurrentValue);
            $this->DISCOUNT->PlaceHolder = RemoveHtml($this->DISCOUNT->caption());
            if (strval($this->DISCOUNT->EditValue) != "" && is_numeric($this->DISCOUNT->EditValue)) {
                $this->DISCOUNT->EditValue = FormatNumber($this->DISCOUNT->EditValue, -2, -2, -2, -2);
            }

            // PAY_METHOD_ID
            $this->PAY_METHOD_ID->EditAttrs["class"] = "form-control";
            $this->PAY_METHOD_ID->EditCustomAttributes = "";
            $this->PAY_METHOD_ID->EditValue = HtmlEncode($this->PAY_METHOD_ID->CurrentValue);
            $this->PAY_METHOD_ID->PlaceHolder = RemoveHtml($this->PAY_METHOD_ID->caption());

            // PAYMENT_DATE
            $this->PAYMENT_DATE->EditAttrs["class"] = "form-control";
            $this->PAYMENT_DATE->EditCustomAttributes = "";
            $this->PAYMENT_DATE->EditValue = HtmlEncode(FormatDateTime($this->PAYMENT_DATE->CurrentValue, 8));
            $this->PAYMENT_DATE->PlaceHolder = RemoveHtml($this->PAYMENT_DATE->caption());

            // ISLUNAS
            $this->ISLUNAS->EditAttrs["class"] = "form-control";
            $this->ISLUNAS->EditCustomAttributes = "";
            if (!$this->ISLUNAS->Raw) {
                $this->ISLUNAS->CurrentValue = HtmlDecode($this->ISLUNAS->CurrentValue);
            }
            $this->ISLUNAS->EditValue = HtmlEncode($this->ISLUNAS->CurrentValue);
            $this->ISLUNAS->PlaceHolder = RemoveHtml($this->ISLUNAS->caption());

            // DUEDATE_ANGSURAN
            $this->DUEDATE_ANGSURAN->EditAttrs["class"] = "form-control";
            $this->DUEDATE_ANGSURAN->EditCustomAttributes = "";
            $this->DUEDATE_ANGSURAN->EditValue = HtmlEncode(FormatDateTime($this->DUEDATE_ANGSURAN->CurrentValue, 8));
            $this->DUEDATE_ANGSURAN->PlaceHolder = RemoveHtml($this->DUEDATE_ANGSURAN->caption());

            // DESCRIPTION
            $this->DESCRIPTION->EditAttrs["class"] = "form-control";
            $this->DESCRIPTION->EditCustomAttributes = "";
            if (!$this->DESCRIPTION->Raw) {
                $this->DESCRIPTION->CurrentValue = HtmlDecode($this->DESCRIPTION->CurrentValue);
            }
            $this->DESCRIPTION->EditValue = HtmlEncode($this->DESCRIPTION->CurrentValue);
            $this->DESCRIPTION->PlaceHolder = RemoveHtml($this->DESCRIPTION->caption());

            // KUITANSI_ID
            $this->KUITANSI_ID->EditAttrs["class"] = "form-control";
            $this->KUITANSI_ID->EditCustomAttributes = "";
            if (!$this->KUITANSI_ID->Raw) {
                $this->KUITANSI_ID->CurrentValue = HtmlDecode($this->KUITANSI_ID->CurrentValue);
            }
            $this->KUITANSI_ID->EditValue = HtmlEncode($this->KUITANSI_ID->CurrentValue);
            $this->KUITANSI_ID->PlaceHolder = RemoveHtml($this->KUITANSI_ID->caption());

            // NOTA_NO
            $this->NOTA_NO->EditAttrs["class"] = "form-control";
            $this->NOTA_NO->EditCustomAttributes = "";
            if (!$this->NOTA_NO->Raw) {
                $this->NOTA_NO->CurrentValue = HtmlDecode($this->NOTA_NO->CurrentValue);
            }
            $this->NOTA_NO->EditValue = HtmlEncode($this->NOTA_NO->CurrentValue);
            $this->NOTA_NO->PlaceHolder = RemoveHtml($this->NOTA_NO->caption());

            // ISCETAK
            $this->ISCETAK->EditAttrs["class"] = "form-control";
            $this->ISCETAK->EditCustomAttributes = "";
            if (!$this->ISCETAK->Raw) {
                $this->ISCETAK->CurrentValue = HtmlDecode($this->ISCETAK->CurrentValue);
            }
            $this->ISCETAK->EditValue = HtmlEncode($this->ISCETAK->CurrentValue);
            $this->ISCETAK->PlaceHolder = RemoveHtml($this->ISCETAK->caption());

            // PRINT_DATE
            $this->PRINT_DATE->EditAttrs["class"] = "form-control";
            $this->PRINT_DATE->EditCustomAttributes = "";
            $this->PRINT_DATE->EditValue = HtmlEncode(FormatDateTime($this->PRINT_DATE->CurrentValue, 8));
            $this->PRINT_DATE->PlaceHolder = RemoveHtml($this->PRINT_DATE->caption());

            // RESEP_NO
            $this->RESEP_NO->EditAttrs["class"] = "form-control";
            $this->RESEP_NO->EditCustomAttributes = "";
            if (!$this->RESEP_NO->Raw) {
                $this->RESEP_NO->CurrentValue = HtmlDecode($this->RESEP_NO->CurrentValue);
            }
            $this->RESEP_NO->EditValue = HtmlEncode($this->RESEP_NO->CurrentValue);
            $this->RESEP_NO->PlaceHolder = RemoveHtml($this->RESEP_NO->caption());

            // RESEP_KE
            $this->RESEP_KE->EditAttrs["class"] = "form-control";
            $this->RESEP_KE->EditCustomAttributes = "";
            $this->RESEP_KE->EditValue = HtmlEncode($this->RESEP_KE->CurrentValue);
            $this->RESEP_KE->PlaceHolder = RemoveHtml($this->RESEP_KE->caption());

            // DOSE
            $this->DOSE->EditAttrs["class"] = "form-control";
            $this->DOSE->EditCustomAttributes = "";
            $this->DOSE->EditValue = HtmlEncode($this->DOSE->CurrentValue);
            $this->DOSE->PlaceHolder = RemoveHtml($this->DOSE->caption());
            if (strval($this->DOSE->EditValue) != "" && is_numeric($this->DOSE->EditValue)) {
                $this->DOSE->EditValue = FormatNumber($this->DOSE->EditValue, -2, -2, -2, -2);
            }

            // ORIG_DOSE
            $this->ORIG_DOSE->EditAttrs["class"] = "form-control";
            $this->ORIG_DOSE->EditCustomAttributes = "";
            $this->ORIG_DOSE->EditValue = HtmlEncode($this->ORIG_DOSE->CurrentValue);
            $this->ORIG_DOSE->PlaceHolder = RemoveHtml($this->ORIG_DOSE->caption());
            if (strval($this->ORIG_DOSE->EditValue) != "" && is_numeric($this->ORIG_DOSE->EditValue)) {
                $this->ORIG_DOSE->EditValue = FormatNumber($this->ORIG_DOSE->EditValue, -2, -2, -2, -2);
            }

            // DOSE_PRESC
            $this->DOSE_PRESC->EditAttrs["class"] = "form-control";
            $this->DOSE_PRESC->EditCustomAttributes = "";
            $this->DOSE_PRESC->EditValue = HtmlEncode($this->DOSE_PRESC->CurrentValue);
            $this->DOSE_PRESC->PlaceHolder = RemoveHtml($this->DOSE_PRESC->caption());
            if (strval($this->DOSE_PRESC->EditValue) != "" && is_numeric($this->DOSE_PRESC->EditValue)) {
                $this->DOSE_PRESC->EditValue = FormatNumber($this->DOSE_PRESC->EditValue, -2, -2, -2, -2);
            }

            // ITER
            $this->ITER->EditAttrs["class"] = "form-control";
            $this->ITER->EditCustomAttributes = "";
            $this->ITER->EditValue = HtmlEncode($this->ITER->CurrentValue);
            $this->ITER->PlaceHolder = RemoveHtml($this->ITER->caption());

            // ITER_KE
            $this->ITER_KE->EditAttrs["class"] = "form-control";
            $this->ITER_KE->EditCustomAttributes = "";
            $this->ITER_KE->EditValue = HtmlEncode($this->ITER_KE->CurrentValue);
            $this->ITER_KE->PlaceHolder = RemoveHtml($this->ITER_KE->caption());

            // SOLD_STATUS
            $this->SOLD_STATUS->EditAttrs["class"] = "form-control";
            $this->SOLD_STATUS->EditCustomAttributes = "";
            $this->SOLD_STATUS->EditValue = HtmlEncode($this->SOLD_STATUS->CurrentValue);
            $this->SOLD_STATUS->PlaceHolder = RemoveHtml($this->SOLD_STATUS->caption());

            // RACIKAN
            $this->RACIKAN->EditAttrs["class"] = "form-control";
            $this->RACIKAN->EditCustomAttributes = "";
            $this->RACIKAN->EditValue = HtmlEncode($this->RACIKAN->CurrentValue);
            $this->RACIKAN->PlaceHolder = RemoveHtml($this->RACIKAN->caption());

            // CLASS_ROOM_ID
            $this->CLASS_ROOM_ID->EditAttrs["class"] = "form-control";
            $this->CLASS_ROOM_ID->EditCustomAttributes = "";
            if (!$this->CLASS_ROOM_ID->Raw) {
                $this->CLASS_ROOM_ID->CurrentValue = HtmlDecode($this->CLASS_ROOM_ID->CurrentValue);
            }
            $this->CLASS_ROOM_ID->EditValue = HtmlEncode($this->CLASS_ROOM_ID->CurrentValue);
            $this->CLASS_ROOM_ID->PlaceHolder = RemoveHtml($this->CLASS_ROOM_ID->caption());

            // KELUAR_ID
            $this->KELUAR_ID->EditAttrs["class"] = "form-control";
            $this->KELUAR_ID->EditCustomAttributes = "";
            $this->KELUAR_ID->EditValue = HtmlEncode($this->KELUAR_ID->CurrentValue);
            $this->KELUAR_ID->PlaceHolder = RemoveHtml($this->KELUAR_ID->caption());

            // BED_ID
            $this->BED_ID->EditAttrs["class"] = "form-control";
            $this->BED_ID->EditCustomAttributes = "";
            $this->BED_ID->EditValue = HtmlEncode($this->BED_ID->CurrentValue);
            $this->BED_ID->PlaceHolder = RemoveHtml($this->BED_ID->caption());

            // PERDA_ID
            $this->PERDA_ID->EditAttrs["class"] = "form-control";
            $this->PERDA_ID->EditCustomAttributes = "";
            $this->PERDA_ID->EditValue = HtmlEncode($this->PERDA_ID->CurrentValue);
            $this->PERDA_ID->PlaceHolder = RemoveHtml($this->PERDA_ID->caption());

            // EMPLOYEE_ID
            $this->EMPLOYEE_ID->EditAttrs["class"] = "form-control";
            $this->EMPLOYEE_ID->EditCustomAttributes = "";
            if (!$this->EMPLOYEE_ID->Raw) {
                $this->EMPLOYEE_ID->CurrentValue = HtmlDecode($this->EMPLOYEE_ID->CurrentValue);
            }
            $this->EMPLOYEE_ID->EditValue = HtmlEncode($this->EMPLOYEE_ID->CurrentValue);
            $this->EMPLOYEE_ID->PlaceHolder = RemoveHtml($this->EMPLOYEE_ID->caption());

            // DESCRIPTION2
            $this->DESCRIPTION2->EditAttrs["class"] = "form-control";
            $this->DESCRIPTION2->EditCustomAttributes = "";
            if (!$this->DESCRIPTION2->Raw) {
                $this->DESCRIPTION2->CurrentValue = HtmlDecode($this->DESCRIPTION2->CurrentValue);
            }
            $this->DESCRIPTION2->EditValue = HtmlEncode($this->DESCRIPTION2->CurrentValue);
            $this->DESCRIPTION2->PlaceHolder = RemoveHtml($this->DESCRIPTION2->caption());

            // MODIFIED_BY
            $this->MODIFIED_BY->EditAttrs["class"] = "form-control";
            $this->MODIFIED_BY->EditCustomAttributes = "";
            if (!$this->MODIFIED_BY->Raw) {
                $this->MODIFIED_BY->CurrentValue = HtmlDecode($this->MODIFIED_BY->CurrentValue);
            }
            $this->MODIFIED_BY->EditValue = HtmlEncode($this->MODIFIED_BY->CurrentValue);
            $this->MODIFIED_BY->PlaceHolder = RemoveHtml($this->MODIFIED_BY->caption());

            // MODIFIED_DATE
            $this->MODIFIED_DATE->EditAttrs["class"] = "form-control";
            $this->MODIFIED_DATE->EditCustomAttributes = "";
            $this->MODIFIED_DATE->EditValue = HtmlEncode(FormatDateTime($this->MODIFIED_DATE->CurrentValue, 8));
            $this->MODIFIED_DATE->PlaceHolder = RemoveHtml($this->MODIFIED_DATE->caption());

            // MODIFIED_FROM
            $this->MODIFIED_FROM->EditAttrs["class"] = "form-control";
            $this->MODIFIED_FROM->EditCustomAttributes = "";
            if (!$this->MODIFIED_FROM->Raw) {
                $this->MODIFIED_FROM->CurrentValue = HtmlDecode($this->MODIFIED_FROM->CurrentValue);
            }
            $this->MODIFIED_FROM->EditValue = HtmlEncode($this->MODIFIED_FROM->CurrentValue);
            $this->MODIFIED_FROM->PlaceHolder = RemoveHtml($this->MODIFIED_FROM->caption());

            // BRAND_ID
            $this->BRAND_ID->EditAttrs["class"] = "form-control";
            $this->BRAND_ID->EditCustomAttributes = "";
            if (!$this->BRAND_ID->Raw) {
                $this->BRAND_ID->CurrentValue = HtmlDecode($this->BRAND_ID->CurrentValue);
            }
            $this->BRAND_ID->EditValue = HtmlEncode($this->BRAND_ID->CurrentValue);
            $this->BRAND_ID->PlaceHolder = RemoveHtml($this->BRAND_ID->caption());

            // DOCTOR
            $this->DOCTOR->EditAttrs["class"] = "form-control";
            $this->DOCTOR->EditCustomAttributes = "";
            if (!$this->DOCTOR->Raw) {
                $this->DOCTOR->CurrentValue = HtmlDecode($this->DOCTOR->CurrentValue);
            }
            $this->DOCTOR->EditValue = HtmlEncode($this->DOCTOR->CurrentValue);
            $this->DOCTOR->PlaceHolder = RemoveHtml($this->DOCTOR->caption());

            // JML_BKS
            $this->JML_BKS->EditAttrs["class"] = "form-control";
            $this->JML_BKS->EditCustomAttributes = "";
            $this->JML_BKS->EditValue = HtmlEncode($this->JML_BKS->CurrentValue);
            $this->JML_BKS->PlaceHolder = RemoveHtml($this->JML_BKS->caption());

            // EXIT_DATE
            $this->EXIT_DATE->EditAttrs["class"] = "form-control";
            $this->EXIT_DATE->EditCustomAttributes = "";
            $this->EXIT_DATE->EditValue = HtmlEncode(FormatDateTime($this->EXIT_DATE->CurrentValue, 8));
            $this->EXIT_DATE->PlaceHolder = RemoveHtml($this->EXIT_DATE->caption());

            // FA_V
            $this->FA_V->EditAttrs["class"] = "form-control";
            $this->FA_V->EditCustomAttributes = "";
            $this->FA_V->EditValue = HtmlEncode($this->FA_V->CurrentValue);
            $this->FA_V->PlaceHolder = RemoveHtml($this->FA_V->caption());

            // TASK_ID
            $this->TASK_ID->EditAttrs["class"] = "form-control";
            $this->TASK_ID->EditCustomAttributes = "";
            $this->TASK_ID->EditValue = HtmlEncode($this->TASK_ID->CurrentValue);
            $this->TASK_ID->PlaceHolder = RemoveHtml($this->TASK_ID->caption());

            // EMPLOYEE_ID_FROM
            $this->EMPLOYEE_ID_FROM->EditAttrs["class"] = "form-control";
            $this->EMPLOYEE_ID_FROM->EditCustomAttributes = "";
            if (!$this->EMPLOYEE_ID_FROM->Raw) {
                $this->EMPLOYEE_ID_FROM->CurrentValue = HtmlDecode($this->EMPLOYEE_ID_FROM->CurrentValue);
            }
            $this->EMPLOYEE_ID_FROM->EditValue = HtmlEncode($this->EMPLOYEE_ID_FROM->CurrentValue);
            $this->EMPLOYEE_ID_FROM->PlaceHolder = RemoveHtml($this->EMPLOYEE_ID_FROM->caption());

            // DOCTOR_FROM
            $this->DOCTOR_FROM->EditAttrs["class"] = "form-control";
            $this->DOCTOR_FROM->EditCustomAttributes = "";
            if (!$this->DOCTOR_FROM->Raw) {
                $this->DOCTOR_FROM->CurrentValue = HtmlDecode($this->DOCTOR_FROM->CurrentValue);
            }
            $this->DOCTOR_FROM->EditValue = HtmlEncode($this->DOCTOR_FROM->CurrentValue);
            $this->DOCTOR_FROM->PlaceHolder = RemoveHtml($this->DOCTOR_FROM->caption());

            // status_pasien_id
            $this->status_pasien_id->EditAttrs["class"] = "form-control";
            $this->status_pasien_id->EditCustomAttributes = "";
            $this->status_pasien_id->EditValue = HtmlEncode($this->status_pasien_id->CurrentValue);
            $this->status_pasien_id->PlaceHolder = RemoveHtml($this->status_pasien_id->caption());

            // amount_paid
            $this->amount_paid->EditAttrs["class"] = "form-control";
            $this->amount_paid->EditCustomAttributes = "";
            $this->amount_paid->EditValue = HtmlEncode($this->amount_paid->CurrentValue);
            $this->amount_paid->PlaceHolder = RemoveHtml($this->amount_paid->caption());
            if (strval($this->amount_paid->EditValue) != "" && is_numeric($this->amount_paid->EditValue)) {
                $this->amount_paid->EditValue = FormatNumber($this->amount_paid->EditValue, -2, -2, -2, -2);
            }

            // THENAME
            $this->THENAME->EditAttrs["class"] = "form-control";
            $this->THENAME->EditCustomAttributes = "";
            if (!$this->THENAME->Raw) {
                $this->THENAME->CurrentValue = HtmlDecode($this->THENAME->CurrentValue);
            }
            $this->THENAME->EditValue = HtmlEncode($this->THENAME->CurrentValue);
            $this->THENAME->PlaceHolder = RemoveHtml($this->THENAME->caption());

            // THEADDRESS
            $this->THEADDRESS->EditAttrs["class"] = "form-control";
            $this->THEADDRESS->EditCustomAttributes = "";
            if (!$this->THEADDRESS->Raw) {
                $this->THEADDRESS->CurrentValue = HtmlDecode($this->THEADDRESS->CurrentValue);
            }
            $this->THEADDRESS->EditValue = HtmlEncode($this->THEADDRESS->CurrentValue);
            $this->THEADDRESS->PlaceHolder = RemoveHtml($this->THEADDRESS->caption());

            // THEID
            $this->THEID->EditAttrs["class"] = "form-control";
            $this->THEID->EditCustomAttributes = "";
            if (!$this->THEID->Raw) {
                $this->THEID->CurrentValue = HtmlDecode($this->THEID->CurrentValue);
            }
            $this->THEID->EditValue = HtmlEncode($this->THEID->CurrentValue);
            $this->THEID->PlaceHolder = RemoveHtml($this->THEID->caption());

            // serial_nb
            $this->serial_nb->EditAttrs["class"] = "form-control";
            $this->serial_nb->EditCustomAttributes = "";
            if (!$this->serial_nb->Raw) {
                $this->serial_nb->CurrentValue = HtmlDecode($this->serial_nb->CurrentValue);
            }
            $this->serial_nb->EditValue = HtmlEncode($this->serial_nb->CurrentValue);
            $this->serial_nb->PlaceHolder = RemoveHtml($this->serial_nb->caption());

            // TREATMENT_PLAFOND
            $this->TREATMENT_PLAFOND->EditAttrs["class"] = "form-control";
            $this->TREATMENT_PLAFOND->EditCustomAttributes = "";
            if (!$this->TREATMENT_PLAFOND->Raw) {
                $this->TREATMENT_PLAFOND->CurrentValue = HtmlDecode($this->TREATMENT_PLAFOND->CurrentValue);
            }
            $this->TREATMENT_PLAFOND->EditValue = HtmlEncode($this->TREATMENT_PLAFOND->CurrentValue);
            $this->TREATMENT_PLAFOND->PlaceHolder = RemoveHtml($this->TREATMENT_PLAFOND->caption());

            // AMOUNT_PLAFOND
            $this->AMOUNT_PLAFOND->EditAttrs["class"] = "form-control";
            $this->AMOUNT_PLAFOND->EditCustomAttributes = "";
            $this->AMOUNT_PLAFOND->EditValue = HtmlEncode($this->AMOUNT_PLAFOND->CurrentValue);
            $this->AMOUNT_PLAFOND->PlaceHolder = RemoveHtml($this->AMOUNT_PLAFOND->caption());
            if (strval($this->AMOUNT_PLAFOND->EditValue) != "" && is_numeric($this->AMOUNT_PLAFOND->EditValue)) {
                $this->AMOUNT_PLAFOND->EditValue = FormatNumber($this->AMOUNT_PLAFOND->EditValue, -2, -2, -2, -2);
            }

            // AMOUNT_PAID_PLAFOND
            $this->AMOUNT_PAID_PLAFOND->EditAttrs["class"] = "form-control";
            $this->AMOUNT_PAID_PLAFOND->EditCustomAttributes = "";
            $this->AMOUNT_PAID_PLAFOND->EditValue = HtmlEncode($this->AMOUNT_PAID_PLAFOND->CurrentValue);
            $this->AMOUNT_PAID_PLAFOND->PlaceHolder = RemoveHtml($this->AMOUNT_PAID_PLAFOND->caption());
            if (strval($this->AMOUNT_PAID_PLAFOND->EditValue) != "" && is_numeric($this->AMOUNT_PAID_PLAFOND->EditValue)) {
                $this->AMOUNT_PAID_PLAFOND->EditValue = FormatNumber($this->AMOUNT_PAID_PLAFOND->EditValue, -2, -2, -2, -2);
            }

            // CLASS_ID_PLAFOND
            $this->CLASS_ID_PLAFOND->EditAttrs["class"] = "form-control";
            $this->CLASS_ID_PLAFOND->EditCustomAttributes = "";
            $this->CLASS_ID_PLAFOND->EditValue = HtmlEncode($this->CLASS_ID_PLAFOND->CurrentValue);
            $this->CLASS_ID_PLAFOND->PlaceHolder = RemoveHtml($this->CLASS_ID_PLAFOND->caption());

            // PAYOR_ID
            $this->PAYOR_ID->EditAttrs["class"] = "form-control";
            $this->PAYOR_ID->EditCustomAttributes = "";
            if (!$this->PAYOR_ID->Raw) {
                $this->PAYOR_ID->CurrentValue = HtmlDecode($this->PAYOR_ID->CurrentValue);
            }
            $this->PAYOR_ID->EditValue = HtmlEncode($this->PAYOR_ID->CurrentValue);
            $this->PAYOR_ID->PlaceHolder = RemoveHtml($this->PAYOR_ID->caption());

            // PEMBULATAN
            $this->PEMBULATAN->EditAttrs["class"] = "form-control";
            $this->PEMBULATAN->EditCustomAttributes = "";
            $this->PEMBULATAN->EditValue = HtmlEncode($this->PEMBULATAN->CurrentValue);
            $this->PEMBULATAN->PlaceHolder = RemoveHtml($this->PEMBULATAN->caption());
            if (strval($this->PEMBULATAN->EditValue) != "" && is_numeric($this->PEMBULATAN->EditValue)) {
                $this->PEMBULATAN->EditValue = FormatNumber($this->PEMBULATAN->EditValue, -2, -2, -2, -2);
            }

            // ISRJ
            $this->ISRJ->EditAttrs["class"] = "form-control";
            $this->ISRJ->EditCustomAttributes = "";
            if (!$this->ISRJ->Raw) {
                $this->ISRJ->CurrentValue = HtmlDecode($this->ISRJ->CurrentValue);
            }
            $this->ISRJ->EditValue = HtmlEncode($this->ISRJ->CurrentValue);
            $this->ISRJ->PlaceHolder = RemoveHtml($this->ISRJ->caption());

            // AGEYEAR
            $this->AGEYEAR->EditAttrs["class"] = "form-control";
            $this->AGEYEAR->EditCustomAttributes = "";
            $this->AGEYEAR->EditValue = HtmlEncode($this->AGEYEAR->CurrentValue);
            $this->AGEYEAR->PlaceHolder = RemoveHtml($this->AGEYEAR->caption());

            // AGEMONTH
            $this->AGEMONTH->EditAttrs["class"] = "form-control";
            $this->AGEMONTH->EditCustomAttributes = "";
            $this->AGEMONTH->EditValue = HtmlEncode($this->AGEMONTH->CurrentValue);
            $this->AGEMONTH->PlaceHolder = RemoveHtml($this->AGEMONTH->caption());

            // AGEDAY
            $this->AGEDAY->EditAttrs["class"] = "form-control";
            $this->AGEDAY->EditCustomAttributes = "";
            $this->AGEDAY->EditValue = HtmlEncode($this->AGEDAY->CurrentValue);
            $this->AGEDAY->PlaceHolder = RemoveHtml($this->AGEDAY->caption());

            // GENDER
            $this->GENDER->EditAttrs["class"] = "form-control";
            $this->GENDER->EditCustomAttributes = "";
            if (!$this->GENDER->Raw) {
                $this->GENDER->CurrentValue = HtmlDecode($this->GENDER->CurrentValue);
            }
            $this->GENDER->EditValue = HtmlEncode($this->GENDER->CurrentValue);
            $this->GENDER->PlaceHolder = RemoveHtml($this->GENDER->caption());

            // KAL_ID
            $this->KAL_ID->EditAttrs["class"] = "form-control";
            $this->KAL_ID->EditCustomAttributes = "";
            if (!$this->KAL_ID->Raw) {
                $this->KAL_ID->CurrentValue = HtmlDecode($this->KAL_ID->CurrentValue);
            }
            $this->KAL_ID->EditValue = HtmlEncode($this->KAL_ID->CurrentValue);
            $this->KAL_ID->PlaceHolder = RemoveHtml($this->KAL_ID->caption());

            // CORRECTION_ID
            $this->CORRECTION_ID->EditAttrs["class"] = "form-control";
            $this->CORRECTION_ID->EditCustomAttributes = "";
            if (!$this->CORRECTION_ID->Raw) {
                $this->CORRECTION_ID->CurrentValue = HtmlDecode($this->CORRECTION_ID->CurrentValue);
            }
            $this->CORRECTION_ID->EditValue = HtmlEncode($this->CORRECTION_ID->CurrentValue);
            $this->CORRECTION_ID->PlaceHolder = RemoveHtml($this->CORRECTION_ID->caption());

            // CORRECTION_BY
            $this->CORRECTION_BY->EditAttrs["class"] = "form-control";
            $this->CORRECTION_BY->EditCustomAttributes = "";
            if (!$this->CORRECTION_BY->Raw) {
                $this->CORRECTION_BY->CurrentValue = HtmlDecode($this->CORRECTION_BY->CurrentValue);
            }
            $this->CORRECTION_BY->EditValue = HtmlEncode($this->CORRECTION_BY->CurrentValue);
            $this->CORRECTION_BY->PlaceHolder = RemoveHtml($this->CORRECTION_BY->caption());

            // KARYAWAN
            $this->KARYAWAN->EditAttrs["class"] = "form-control";
            $this->KARYAWAN->EditCustomAttributes = "";
            if (!$this->KARYAWAN->Raw) {
                $this->KARYAWAN->CurrentValue = HtmlDecode($this->KARYAWAN->CurrentValue);
            }
            $this->KARYAWAN->EditValue = HtmlEncode($this->KARYAWAN->CurrentValue);
            $this->KARYAWAN->PlaceHolder = RemoveHtml($this->KARYAWAN->caption());

            // ACCOUNT_ID
            $this->ACCOUNT_ID->EditAttrs["class"] = "form-control";
            $this->ACCOUNT_ID->EditCustomAttributes = "";
            if (!$this->ACCOUNT_ID->Raw) {
                $this->ACCOUNT_ID->CurrentValue = HtmlDecode($this->ACCOUNT_ID->CurrentValue);
            }
            $this->ACCOUNT_ID->EditValue = HtmlEncode($this->ACCOUNT_ID->CurrentValue);
            $this->ACCOUNT_ID->PlaceHolder = RemoveHtml($this->ACCOUNT_ID->caption());

            // sell_price
            $this->sell_price->EditAttrs["class"] = "form-control";
            $this->sell_price->EditCustomAttributes = "";
            $this->sell_price->EditValue = HtmlEncode($this->sell_price->CurrentValue);
            $this->sell_price->PlaceHolder = RemoveHtml($this->sell_price->caption());
            if (strval($this->sell_price->EditValue) != "" && is_numeric($this->sell_price->EditValue)) {
                $this->sell_price->EditValue = FormatNumber($this->sell_price->EditValue, -2, -2, -2, -2);
            }

            // diskon
            $this->diskon->EditAttrs["class"] = "form-control";
            $this->diskon->EditCustomAttributes = "";
            $this->diskon->EditValue = HtmlEncode($this->diskon->CurrentValue);
            $this->diskon->PlaceHolder = RemoveHtml($this->diskon->caption());
            if (strval($this->diskon->EditValue) != "" && is_numeric($this->diskon->EditValue)) {
                $this->diskon->EditValue = FormatNumber($this->diskon->EditValue, -2, -2, -2, -2);
            }

            // INVOICE_ID
            $this->INVOICE_ID->EditAttrs["class"] = "form-control";
            $this->INVOICE_ID->EditCustomAttributes = "";
            if (!$this->INVOICE_ID->Raw) {
                $this->INVOICE_ID->CurrentValue = HtmlDecode($this->INVOICE_ID->CurrentValue);
            }
            $this->INVOICE_ID->EditValue = HtmlEncode($this->INVOICE_ID->CurrentValue);
            $this->INVOICE_ID->PlaceHolder = RemoveHtml($this->INVOICE_ID->caption());

            // NUMER
            $this->NUMER->EditAttrs["class"] = "form-control";
            $this->NUMER->EditCustomAttributes = "";
            if (!$this->NUMER->Raw) {
                $this->NUMER->CurrentValue = HtmlDecode($this->NUMER->CurrentValue);
            }
            $this->NUMER->EditValue = HtmlEncode($this->NUMER->CurrentValue);
            $this->NUMER->PlaceHolder = RemoveHtml($this->NUMER->caption());

            // MEASURE_ID2
            $this->MEASURE_ID2->EditAttrs["class"] = "form-control";
            $this->MEASURE_ID2->EditCustomAttributes = "";
            $this->MEASURE_ID2->EditValue = HtmlEncode($this->MEASURE_ID2->CurrentValue);
            $this->MEASURE_ID2->PlaceHolder = RemoveHtml($this->MEASURE_ID2->caption());

            // POTONGAN
            $this->POTONGAN->EditAttrs["class"] = "form-control";
            $this->POTONGAN->EditCustomAttributes = "";
            $this->POTONGAN->EditValue = HtmlEncode($this->POTONGAN->CurrentValue);
            $this->POTONGAN->PlaceHolder = RemoveHtml($this->POTONGAN->caption());
            if (strval($this->POTONGAN->EditValue) != "" && is_numeric($this->POTONGAN->EditValue)) {
                $this->POTONGAN->EditValue = FormatNumber($this->POTONGAN->EditValue, -2, -2, -2, -2);
            }

            // BAYAR
            $this->BAYAR->EditAttrs["class"] = "form-control";
            $this->BAYAR->EditCustomAttributes = "";
            $this->BAYAR->EditValue = HtmlEncode($this->BAYAR->CurrentValue);
            $this->BAYAR->PlaceHolder = RemoveHtml($this->BAYAR->caption());
            if (strval($this->BAYAR->EditValue) != "" && is_numeric($this->BAYAR->EditValue)) {
                $this->BAYAR->EditValue = FormatNumber($this->BAYAR->EditValue, -2, -2, -2, -2);
            }

            // RETUR
            $this->RETUR->EditAttrs["class"] = "form-control";
            $this->RETUR->EditCustomAttributes = "";
            $this->RETUR->EditValue = HtmlEncode($this->RETUR->CurrentValue);
            $this->RETUR->PlaceHolder = RemoveHtml($this->RETUR->caption());
            if (strval($this->RETUR->EditValue) != "" && is_numeric($this->RETUR->EditValue)) {
                $this->RETUR->EditValue = FormatNumber($this->RETUR->EditValue, -2, -2, -2, -2);
            }

            // TARIF_TYPE
            $this->TARIF_TYPE->EditAttrs["class"] = "form-control";
            $this->TARIF_TYPE->EditCustomAttributes = "";
            if (!$this->TARIF_TYPE->Raw) {
                $this->TARIF_TYPE->CurrentValue = HtmlDecode($this->TARIF_TYPE->CurrentValue);
            }
            $this->TARIF_TYPE->EditValue = HtmlEncode($this->TARIF_TYPE->CurrentValue);
            $this->TARIF_TYPE->PlaceHolder = RemoveHtml($this->TARIF_TYPE->caption());

            // PPNVALUE
            $this->PPNVALUE->EditAttrs["class"] = "form-control";
            $this->PPNVALUE->EditCustomAttributes = "";
            $this->PPNVALUE->EditValue = HtmlEncode($this->PPNVALUE->CurrentValue);
            $this->PPNVALUE->PlaceHolder = RemoveHtml($this->PPNVALUE->caption());
            if (strval($this->PPNVALUE->EditValue) != "" && is_numeric($this->PPNVALUE->EditValue)) {
                $this->PPNVALUE->EditValue = FormatNumber($this->PPNVALUE->EditValue, -2, -2, -2, -2);
            }

            // TAGIHAN
            $this->TAGIHAN->EditAttrs["class"] = "form-control";
            $this->TAGIHAN->EditCustomAttributes = "";
            $this->TAGIHAN->EditValue = HtmlEncode($this->TAGIHAN->CurrentValue);
            $this->TAGIHAN->PlaceHolder = RemoveHtml($this->TAGIHAN->caption());
            if (strval($this->TAGIHAN->EditValue) != "" && is_numeric($this->TAGIHAN->EditValue)) {
                $this->TAGIHAN->EditValue = FormatNumber($this->TAGIHAN->EditValue, -2, -2, -2, -2);
            }

            // KOREKSI
            $this->KOREKSI->EditAttrs["class"] = "form-control";
            $this->KOREKSI->EditCustomAttributes = "";
            $this->KOREKSI->EditValue = HtmlEncode($this->KOREKSI->CurrentValue);
            $this->KOREKSI->PlaceHolder = RemoveHtml($this->KOREKSI->caption());
            if (strval($this->KOREKSI->EditValue) != "" && is_numeric($this->KOREKSI->EditValue)) {
                $this->KOREKSI->EditValue = FormatNumber($this->KOREKSI->EditValue, -2, -2, -2, -2);
            }

            // STATUS_OBAT
            $this->STATUS_OBAT->EditAttrs["class"] = "form-control";
            $this->STATUS_OBAT->EditCustomAttributes = "";
            $this->STATUS_OBAT->EditValue = HtmlEncode($this->STATUS_OBAT->CurrentValue);
            $this->STATUS_OBAT->PlaceHolder = RemoveHtml($this->STATUS_OBAT->caption());

            // SUBSIDISAT
            $this->SUBSIDISAT->EditAttrs["class"] = "form-control";
            $this->SUBSIDISAT->EditCustomAttributes = "";
            $this->SUBSIDISAT->EditValue = HtmlEncode($this->SUBSIDISAT->CurrentValue);
            $this->SUBSIDISAT->PlaceHolder = RemoveHtml($this->SUBSIDISAT->caption());
            if (strval($this->SUBSIDISAT->EditValue) != "" && is_numeric($this->SUBSIDISAT->EditValue)) {
                $this->SUBSIDISAT->EditValue = FormatNumber($this->SUBSIDISAT->EditValue, -2, -2, -2, -2);
            }

            // PRINTQ
            $this->PRINTQ->EditAttrs["class"] = "form-control";
            $this->PRINTQ->EditCustomAttributes = "";
            $this->PRINTQ->EditValue = HtmlEncode($this->PRINTQ->CurrentValue);
            $this->PRINTQ->PlaceHolder = RemoveHtml($this->PRINTQ->caption());

            // PRINTED_BY
            $this->PRINTED_BY->EditAttrs["class"] = "form-control";
            $this->PRINTED_BY->EditCustomAttributes = "";
            if (!$this->PRINTED_BY->Raw) {
                $this->PRINTED_BY->CurrentValue = HtmlDecode($this->PRINTED_BY->CurrentValue);
            }
            $this->PRINTED_BY->EditValue = HtmlEncode($this->PRINTED_BY->CurrentValue);
            $this->PRINTED_BY->PlaceHolder = RemoveHtml($this->PRINTED_BY->caption());

            // STOCK_AVAILABLE
            $this->STOCK_AVAILABLE->EditAttrs["class"] = "form-control";
            $this->STOCK_AVAILABLE->EditCustomAttributes = "";
            $this->STOCK_AVAILABLE->EditValue = HtmlEncode($this->STOCK_AVAILABLE->CurrentValue);
            $this->STOCK_AVAILABLE->PlaceHolder = RemoveHtml($this->STOCK_AVAILABLE->caption());
            if (strval($this->STOCK_AVAILABLE->EditValue) != "" && is_numeric($this->STOCK_AVAILABLE->EditValue)) {
                $this->STOCK_AVAILABLE->EditValue = FormatNumber($this->STOCK_AVAILABLE->EditValue, -2, -2, -2, -2);
            }

            // STATUS_TARIF
            $this->STATUS_TARIF->EditAttrs["class"] = "form-control";
            $this->STATUS_TARIF->EditCustomAttributes = "";
            $this->STATUS_TARIF->EditValue = HtmlEncode($this->STATUS_TARIF->CurrentValue);
            $this->STATUS_TARIF->PlaceHolder = RemoveHtml($this->STATUS_TARIF->caption());

            // CLINIC_TYPE
            $this->CLINIC_TYPE->EditAttrs["class"] = "form-control";
            $this->CLINIC_TYPE->EditCustomAttributes = "";
            $this->CLINIC_TYPE->EditValue = HtmlEncode($this->CLINIC_TYPE->CurrentValue);
            $this->CLINIC_TYPE->PlaceHolder = RemoveHtml($this->CLINIC_TYPE->caption());

            // PACKAGE_ID
            $this->PACKAGE_ID->EditAttrs["class"] = "form-control";
            $this->PACKAGE_ID->EditCustomAttributes = "";
            if (!$this->PACKAGE_ID->Raw) {
                $this->PACKAGE_ID->CurrentValue = HtmlDecode($this->PACKAGE_ID->CurrentValue);
            }
            $this->PACKAGE_ID->EditValue = HtmlEncode($this->PACKAGE_ID->CurrentValue);
            $this->PACKAGE_ID->PlaceHolder = RemoveHtml($this->PACKAGE_ID->caption());

            // MODULE_ID
            $this->MODULE_ID->EditAttrs["class"] = "form-control";
            $this->MODULE_ID->EditCustomAttributes = "";
            if (!$this->MODULE_ID->Raw) {
                $this->MODULE_ID->CurrentValue = HtmlDecode($this->MODULE_ID->CurrentValue);
            }
            $this->MODULE_ID->EditValue = HtmlEncode($this->MODULE_ID->CurrentValue);
            $this->MODULE_ID->PlaceHolder = RemoveHtml($this->MODULE_ID->caption());

            // profession
            $this->profession->EditAttrs["class"] = "form-control";
            $this->profession->EditCustomAttributes = "";
            $this->profession->EditValue = HtmlEncode($this->profession->CurrentValue);
            $this->profession->PlaceHolder = RemoveHtml($this->profession->caption());
            if (strval($this->profession->EditValue) != "" && is_numeric($this->profession->EditValue)) {
                $this->profession->EditValue = FormatNumber($this->profession->EditValue, -2, -2, -2, -2);
            }

            // THEORDER
            $this->THEORDER->EditAttrs["class"] = "form-control";
            $this->THEORDER->EditCustomAttributes = "";
            $this->THEORDER->EditValue = HtmlEncode($this->THEORDER->CurrentValue);
            $this->THEORDER->PlaceHolder = RemoveHtml($this->THEORDER->caption());

            // CASHIER
            $this->CASHIER->EditAttrs["class"] = "form-control";
            $this->CASHIER->EditCustomAttributes = "";
            if (!$this->CASHIER->Raw) {
                $this->CASHIER->CurrentValue = HtmlDecode($this->CASHIER->CurrentValue);
            }
            $this->CASHIER->EditValue = HtmlEncode($this->CASHIER->CurrentValue);
            $this->CASHIER->PlaceHolder = RemoveHtml($this->CASHIER->caption());

            // SPPFEE
            $this->SPPFEE->EditAttrs["class"] = "form-control";
            $this->SPPFEE->EditCustomAttributes = "";
            if (!$this->SPPFEE->Raw) {
                $this->SPPFEE->CurrentValue = HtmlDecode($this->SPPFEE->CurrentValue);
            }
            $this->SPPFEE->EditValue = HtmlEncode($this->SPPFEE->CurrentValue);
            $this->SPPFEE->PlaceHolder = RemoveHtml($this->SPPFEE->caption());

            // SPPBILL
            $this->SPPBILL->EditAttrs["class"] = "form-control";
            $this->SPPBILL->EditCustomAttributes = "";
            if (!$this->SPPBILL->Raw) {
                $this->SPPBILL->CurrentValue = HtmlDecode($this->SPPBILL->CurrentValue);
            }
            $this->SPPBILL->EditValue = HtmlEncode($this->SPPBILL->CurrentValue);
            $this->SPPBILL->PlaceHolder = RemoveHtml($this->SPPBILL->caption());

            // SPPRJK
            $this->SPPRJK->EditAttrs["class"] = "form-control";
            $this->SPPRJK->EditCustomAttributes = "";
            if (!$this->SPPRJK->Raw) {
                $this->SPPRJK->CurrentValue = HtmlDecode($this->SPPRJK->CurrentValue);
            }
            $this->SPPRJK->EditValue = HtmlEncode($this->SPPRJK->CurrentValue);
            $this->SPPRJK->PlaceHolder = RemoveHtml($this->SPPRJK->caption());

            // SPPJMN
            $this->SPPJMN->EditAttrs["class"] = "form-control";
            $this->SPPJMN->EditCustomAttributes = "";
            if (!$this->SPPJMN->Raw) {
                $this->SPPJMN->CurrentValue = HtmlDecode($this->SPPJMN->CurrentValue);
            }
            $this->SPPJMN->EditValue = HtmlEncode($this->SPPJMN->CurrentValue);
            $this->SPPJMN->PlaceHolder = RemoveHtml($this->SPPJMN->caption());

            // SPPKASIR
            $this->SPPKASIR->EditAttrs["class"] = "form-control";
            $this->SPPKASIR->EditCustomAttributes = "";
            if (!$this->SPPKASIR->Raw) {
                $this->SPPKASIR->CurrentValue = HtmlDecode($this->SPPKASIR->CurrentValue);
            }
            $this->SPPKASIR->EditValue = HtmlEncode($this->SPPKASIR->CurrentValue);
            $this->SPPKASIR->PlaceHolder = RemoveHtml($this->SPPKASIR->caption());

            // PERUJUK
            $this->PERUJUK->EditAttrs["class"] = "form-control";
            $this->PERUJUK->EditCustomAttributes = "";
            if (!$this->PERUJUK->Raw) {
                $this->PERUJUK->CurrentValue = HtmlDecode($this->PERUJUK->CurrentValue);
            }
            $this->PERUJUK->EditValue = HtmlEncode($this->PERUJUK->CurrentValue);
            $this->PERUJUK->PlaceHolder = RemoveHtml($this->PERUJUK->caption());

            // PERUJUKFEE
            $this->PERUJUKFEE->EditAttrs["class"] = "form-control";
            $this->PERUJUKFEE->EditCustomAttributes = "";
            $this->PERUJUKFEE->EditValue = HtmlEncode($this->PERUJUKFEE->CurrentValue);
            $this->PERUJUKFEE->PlaceHolder = RemoveHtml($this->PERUJUKFEE->caption());
            if (strval($this->PERUJUKFEE->EditValue) != "" && is_numeric($this->PERUJUKFEE->EditValue)) {
                $this->PERUJUKFEE->EditValue = FormatNumber($this->PERUJUKFEE->EditValue, -2, -2, -2, -2);
            }

            // modified_datesys
            $this->modified_datesys->EditAttrs["class"] = "form-control";
            $this->modified_datesys->EditCustomAttributes = "";
            $this->modified_datesys->EditValue = HtmlEncode(FormatDateTime($this->modified_datesys->CurrentValue, 8));
            $this->modified_datesys->PlaceHolder = RemoveHtml($this->modified_datesys->caption());

            // TRANS_ID
            $this->TRANS_ID->EditAttrs["class"] = "form-control";
            $this->TRANS_ID->EditCustomAttributes = "";
            if (!$this->TRANS_ID->Raw) {
                $this->TRANS_ID->CurrentValue = HtmlDecode($this->TRANS_ID->CurrentValue);
            }
            $this->TRANS_ID->EditValue = HtmlEncode($this->TRANS_ID->CurrentValue);
            $this->TRANS_ID->PlaceHolder = RemoveHtml($this->TRANS_ID->caption());

            // SPPBILLDATE
            $this->SPPBILLDATE->EditAttrs["class"] = "form-control";
            $this->SPPBILLDATE->EditCustomAttributes = "";
            $this->SPPBILLDATE->EditValue = HtmlEncode(FormatDateTime($this->SPPBILLDATE->CurrentValue, 8));
            $this->SPPBILLDATE->PlaceHolder = RemoveHtml($this->SPPBILLDATE->caption());

            // SPPBILLUSER
            $this->SPPBILLUSER->EditAttrs["class"] = "form-control";
            $this->SPPBILLUSER->EditCustomAttributes = "";
            if (!$this->SPPBILLUSER->Raw) {
                $this->SPPBILLUSER->CurrentValue = HtmlDecode($this->SPPBILLUSER->CurrentValue);
            }
            $this->SPPBILLUSER->EditValue = HtmlEncode($this->SPPBILLUSER->CurrentValue);
            $this->SPPBILLUSER->PlaceHolder = RemoveHtml($this->SPPBILLUSER->caption());

            // SPPKASIRDATE
            $this->SPPKASIRDATE->EditAttrs["class"] = "form-control";
            $this->SPPKASIRDATE->EditCustomAttributes = "";
            $this->SPPKASIRDATE->EditValue = HtmlEncode(FormatDateTime($this->SPPKASIRDATE->CurrentValue, 8));
            $this->SPPKASIRDATE->PlaceHolder = RemoveHtml($this->SPPKASIRDATE->caption());

            // SPPKASIRUSER
            $this->SPPKASIRUSER->EditAttrs["class"] = "form-control";
            $this->SPPKASIRUSER->EditCustomAttributes = "";
            if (!$this->SPPKASIRUSER->Raw) {
                $this->SPPKASIRUSER->CurrentValue = HtmlDecode($this->SPPKASIRUSER->CurrentValue);
            }
            $this->SPPKASIRUSER->EditValue = HtmlEncode($this->SPPKASIRUSER->CurrentValue);
            $this->SPPKASIRUSER->PlaceHolder = RemoveHtml($this->SPPKASIRUSER->caption());

            // SPPPOLI
            $this->SPPPOLI->EditAttrs["class"] = "form-control";
            $this->SPPPOLI->EditCustomAttributes = "";
            if (!$this->SPPPOLI->Raw) {
                $this->SPPPOLI->CurrentValue = HtmlDecode($this->SPPPOLI->CurrentValue);
            }
            $this->SPPPOLI->EditValue = HtmlEncode($this->SPPPOLI->CurrentValue);
            $this->SPPPOLI->PlaceHolder = RemoveHtml($this->SPPPOLI->caption());

            // SPPPOLIUSER
            $this->SPPPOLIUSER->EditAttrs["class"] = "form-control";
            $this->SPPPOLIUSER->EditCustomAttributes = "";
            if (!$this->SPPPOLIUSER->Raw) {
                $this->SPPPOLIUSER->CurrentValue = HtmlDecode($this->SPPPOLIUSER->CurrentValue);
            }
            $this->SPPPOLIUSER->EditValue = HtmlEncode($this->SPPPOLIUSER->CurrentValue);
            $this->SPPPOLIUSER->PlaceHolder = RemoveHtml($this->SPPPOLIUSER->caption());

            // SPPPOLIDATE
            $this->SPPPOLIDATE->EditAttrs["class"] = "form-control";
            $this->SPPPOLIDATE->EditCustomAttributes = "";
            $this->SPPPOLIDATE->EditValue = HtmlEncode(FormatDateTime($this->SPPPOLIDATE->CurrentValue, 8));
            $this->SPPPOLIDATE->PlaceHolder = RemoveHtml($this->SPPPOLIDATE->caption());

            // Add refer script

            // ORG_UNIT_CODE
            $this->ORG_UNIT_CODE->LinkCustomAttributes = "";
            $this->ORG_UNIT_CODE->HrefValue = "";

            // BILL_ID
            $this->BILL_ID->LinkCustomAttributes = "";
            $this->BILL_ID->HrefValue = "";

            // NO_REGISTRATION
            $this->NO_REGISTRATION->LinkCustomAttributes = "";
            $this->NO_REGISTRATION->HrefValue = "";

            // VISIT_ID
            $this->VISIT_ID->LinkCustomAttributes = "";
            $this->VISIT_ID->HrefValue = "";

            // TARIF_ID
            $this->TARIF_ID->LinkCustomAttributes = "";
            $this->TARIF_ID->HrefValue = "";

            // CLASS_ID
            $this->CLASS_ID->LinkCustomAttributes = "";
            $this->CLASS_ID->HrefValue = "";

            // CLINIC_ID
            $this->CLINIC_ID->LinkCustomAttributes = "";
            $this->CLINIC_ID->HrefValue = "";

            // CLINIC_ID_FROM
            $this->CLINIC_ID_FROM->LinkCustomAttributes = "";
            $this->CLINIC_ID_FROM->HrefValue = "";

            // TREATMENT
            $this->TREATMENT->LinkCustomAttributes = "";
            $this->TREATMENT->HrefValue = "";

            // TREAT_DATE
            $this->TREAT_DATE->LinkCustomAttributes = "";
            $this->TREAT_DATE->HrefValue = "";

            // AMOUNT
            $this->AMOUNT->LinkCustomAttributes = "";
            $this->AMOUNT->HrefValue = "";

            // QUANTITY
            $this->QUANTITY->LinkCustomAttributes = "";
            $this->QUANTITY->HrefValue = "";

            // MEASURE_ID
            $this->MEASURE_ID->LinkCustomAttributes = "";
            $this->MEASURE_ID->HrefValue = "";

            // POKOK_JUAL
            $this->POKOK_JUAL->LinkCustomAttributes = "";
            $this->POKOK_JUAL->HrefValue = "";

            // PPN
            $this->PPN->LinkCustomAttributes = "";
            $this->PPN->HrefValue = "";

            // MARGIN
            $this->MARGIN->LinkCustomAttributes = "";
            $this->MARGIN->HrefValue = "";

            // SUBSIDI
            $this->SUBSIDI->LinkCustomAttributes = "";
            $this->SUBSIDI->HrefValue = "";

            // EMBALACE
            $this->EMBALACE->LinkCustomAttributes = "";
            $this->EMBALACE->HrefValue = "";

            // PROFESI
            $this->PROFESI->LinkCustomAttributes = "";
            $this->PROFESI->HrefValue = "";

            // DISCOUNT
            $this->DISCOUNT->LinkCustomAttributes = "";
            $this->DISCOUNT->HrefValue = "";

            // PAY_METHOD_ID
            $this->PAY_METHOD_ID->LinkCustomAttributes = "";
            $this->PAY_METHOD_ID->HrefValue = "";

            // PAYMENT_DATE
            $this->PAYMENT_DATE->LinkCustomAttributes = "";
            $this->PAYMENT_DATE->HrefValue = "";

            // ISLUNAS
            $this->ISLUNAS->LinkCustomAttributes = "";
            $this->ISLUNAS->HrefValue = "";

            // DUEDATE_ANGSURAN
            $this->DUEDATE_ANGSURAN->LinkCustomAttributes = "";
            $this->DUEDATE_ANGSURAN->HrefValue = "";

            // DESCRIPTION
            $this->DESCRIPTION->LinkCustomAttributes = "";
            $this->DESCRIPTION->HrefValue = "";

            // KUITANSI_ID
            $this->KUITANSI_ID->LinkCustomAttributes = "";
            $this->KUITANSI_ID->HrefValue = "";

            // NOTA_NO
            $this->NOTA_NO->LinkCustomAttributes = "";
            $this->NOTA_NO->HrefValue = "";

            // ISCETAK
            $this->ISCETAK->LinkCustomAttributes = "";
            $this->ISCETAK->HrefValue = "";

            // PRINT_DATE
            $this->PRINT_DATE->LinkCustomAttributes = "";
            $this->PRINT_DATE->HrefValue = "";

            // RESEP_NO
            $this->RESEP_NO->LinkCustomAttributes = "";
            $this->RESEP_NO->HrefValue = "";

            // RESEP_KE
            $this->RESEP_KE->LinkCustomAttributes = "";
            $this->RESEP_KE->HrefValue = "";

            // DOSE
            $this->DOSE->LinkCustomAttributes = "";
            $this->DOSE->HrefValue = "";

            // ORIG_DOSE
            $this->ORIG_DOSE->LinkCustomAttributes = "";
            $this->ORIG_DOSE->HrefValue = "";

            // DOSE_PRESC
            $this->DOSE_PRESC->LinkCustomAttributes = "";
            $this->DOSE_PRESC->HrefValue = "";

            // ITER
            $this->ITER->LinkCustomAttributes = "";
            $this->ITER->HrefValue = "";

            // ITER_KE
            $this->ITER_KE->LinkCustomAttributes = "";
            $this->ITER_KE->HrefValue = "";

            // SOLD_STATUS
            $this->SOLD_STATUS->LinkCustomAttributes = "";
            $this->SOLD_STATUS->HrefValue = "";

            // RACIKAN
            $this->RACIKAN->LinkCustomAttributes = "";
            $this->RACIKAN->HrefValue = "";

            // CLASS_ROOM_ID
            $this->CLASS_ROOM_ID->LinkCustomAttributes = "";
            $this->CLASS_ROOM_ID->HrefValue = "";

            // KELUAR_ID
            $this->KELUAR_ID->LinkCustomAttributes = "";
            $this->KELUAR_ID->HrefValue = "";

            // BED_ID
            $this->BED_ID->LinkCustomAttributes = "";
            $this->BED_ID->HrefValue = "";

            // PERDA_ID
            $this->PERDA_ID->LinkCustomAttributes = "";
            $this->PERDA_ID->HrefValue = "";

            // EMPLOYEE_ID
            $this->EMPLOYEE_ID->LinkCustomAttributes = "";
            $this->EMPLOYEE_ID->HrefValue = "";

            // DESCRIPTION2
            $this->DESCRIPTION2->LinkCustomAttributes = "";
            $this->DESCRIPTION2->HrefValue = "";

            // MODIFIED_BY
            $this->MODIFIED_BY->LinkCustomAttributes = "";
            $this->MODIFIED_BY->HrefValue = "";

            // MODIFIED_DATE
            $this->MODIFIED_DATE->LinkCustomAttributes = "";
            $this->MODIFIED_DATE->HrefValue = "";

            // MODIFIED_FROM
            $this->MODIFIED_FROM->LinkCustomAttributes = "";
            $this->MODIFIED_FROM->HrefValue = "";

            // BRAND_ID
            $this->BRAND_ID->LinkCustomAttributes = "";
            $this->BRAND_ID->HrefValue = "";

            // DOCTOR
            $this->DOCTOR->LinkCustomAttributes = "";
            $this->DOCTOR->HrefValue = "";

            // JML_BKS
            $this->JML_BKS->LinkCustomAttributes = "";
            $this->JML_BKS->HrefValue = "";

            // EXIT_DATE
            $this->EXIT_DATE->LinkCustomAttributes = "";
            $this->EXIT_DATE->HrefValue = "";

            // FA_V
            $this->FA_V->LinkCustomAttributes = "";
            $this->FA_V->HrefValue = "";

            // TASK_ID
            $this->TASK_ID->LinkCustomAttributes = "";
            $this->TASK_ID->HrefValue = "";

            // EMPLOYEE_ID_FROM
            $this->EMPLOYEE_ID_FROM->LinkCustomAttributes = "";
            $this->EMPLOYEE_ID_FROM->HrefValue = "";

            // DOCTOR_FROM
            $this->DOCTOR_FROM->LinkCustomAttributes = "";
            $this->DOCTOR_FROM->HrefValue = "";

            // status_pasien_id
            $this->status_pasien_id->LinkCustomAttributes = "";
            $this->status_pasien_id->HrefValue = "";

            // amount_paid
            $this->amount_paid->LinkCustomAttributes = "";
            $this->amount_paid->HrefValue = "";

            // THENAME
            $this->THENAME->LinkCustomAttributes = "";
            $this->THENAME->HrefValue = "";

            // THEADDRESS
            $this->THEADDRESS->LinkCustomAttributes = "";
            $this->THEADDRESS->HrefValue = "";

            // THEID
            $this->THEID->LinkCustomAttributes = "";
            $this->THEID->HrefValue = "";

            // serial_nb
            $this->serial_nb->LinkCustomAttributes = "";
            $this->serial_nb->HrefValue = "";

            // TREATMENT_PLAFOND
            $this->TREATMENT_PLAFOND->LinkCustomAttributes = "";
            $this->TREATMENT_PLAFOND->HrefValue = "";

            // AMOUNT_PLAFOND
            $this->AMOUNT_PLAFOND->LinkCustomAttributes = "";
            $this->AMOUNT_PLAFOND->HrefValue = "";

            // AMOUNT_PAID_PLAFOND
            $this->AMOUNT_PAID_PLAFOND->LinkCustomAttributes = "";
            $this->AMOUNT_PAID_PLAFOND->HrefValue = "";

            // CLASS_ID_PLAFOND
            $this->CLASS_ID_PLAFOND->LinkCustomAttributes = "";
            $this->CLASS_ID_PLAFOND->HrefValue = "";

            // PAYOR_ID
            $this->PAYOR_ID->LinkCustomAttributes = "";
            $this->PAYOR_ID->HrefValue = "";

            // PEMBULATAN
            $this->PEMBULATAN->LinkCustomAttributes = "";
            $this->PEMBULATAN->HrefValue = "";

            // ISRJ
            $this->ISRJ->LinkCustomAttributes = "";
            $this->ISRJ->HrefValue = "";

            // AGEYEAR
            $this->AGEYEAR->LinkCustomAttributes = "";
            $this->AGEYEAR->HrefValue = "";

            // AGEMONTH
            $this->AGEMONTH->LinkCustomAttributes = "";
            $this->AGEMONTH->HrefValue = "";

            // AGEDAY
            $this->AGEDAY->LinkCustomAttributes = "";
            $this->AGEDAY->HrefValue = "";

            // GENDER
            $this->GENDER->LinkCustomAttributes = "";
            $this->GENDER->HrefValue = "";

            // KAL_ID
            $this->KAL_ID->LinkCustomAttributes = "";
            $this->KAL_ID->HrefValue = "";

            // CORRECTION_ID
            $this->CORRECTION_ID->LinkCustomAttributes = "";
            $this->CORRECTION_ID->HrefValue = "";

            // CORRECTION_BY
            $this->CORRECTION_BY->LinkCustomAttributes = "";
            $this->CORRECTION_BY->HrefValue = "";

            // KARYAWAN
            $this->KARYAWAN->LinkCustomAttributes = "";
            $this->KARYAWAN->HrefValue = "";

            // ACCOUNT_ID
            $this->ACCOUNT_ID->LinkCustomAttributes = "";
            $this->ACCOUNT_ID->HrefValue = "";

            // sell_price
            $this->sell_price->LinkCustomAttributes = "";
            $this->sell_price->HrefValue = "";

            // diskon
            $this->diskon->LinkCustomAttributes = "";
            $this->diskon->HrefValue = "";

            // INVOICE_ID
            $this->INVOICE_ID->LinkCustomAttributes = "";
            $this->INVOICE_ID->HrefValue = "";

            // NUMER
            $this->NUMER->LinkCustomAttributes = "";
            $this->NUMER->HrefValue = "";

            // MEASURE_ID2
            $this->MEASURE_ID2->LinkCustomAttributes = "";
            $this->MEASURE_ID2->HrefValue = "";

            // POTONGAN
            $this->POTONGAN->LinkCustomAttributes = "";
            $this->POTONGAN->HrefValue = "";

            // BAYAR
            $this->BAYAR->LinkCustomAttributes = "";
            $this->BAYAR->HrefValue = "";

            // RETUR
            $this->RETUR->LinkCustomAttributes = "";
            $this->RETUR->HrefValue = "";

            // TARIF_TYPE
            $this->TARIF_TYPE->LinkCustomAttributes = "";
            $this->TARIF_TYPE->HrefValue = "";

            // PPNVALUE
            $this->PPNVALUE->LinkCustomAttributes = "";
            $this->PPNVALUE->HrefValue = "";

            // TAGIHAN
            $this->TAGIHAN->LinkCustomAttributes = "";
            $this->TAGIHAN->HrefValue = "";

            // KOREKSI
            $this->KOREKSI->LinkCustomAttributes = "";
            $this->KOREKSI->HrefValue = "";

            // STATUS_OBAT
            $this->STATUS_OBAT->LinkCustomAttributes = "";
            $this->STATUS_OBAT->HrefValue = "";

            // SUBSIDISAT
            $this->SUBSIDISAT->LinkCustomAttributes = "";
            $this->SUBSIDISAT->HrefValue = "";

            // PRINTQ
            $this->PRINTQ->LinkCustomAttributes = "";
            $this->PRINTQ->HrefValue = "";

            // PRINTED_BY
            $this->PRINTED_BY->LinkCustomAttributes = "";
            $this->PRINTED_BY->HrefValue = "";

            // STOCK_AVAILABLE
            $this->STOCK_AVAILABLE->LinkCustomAttributes = "";
            $this->STOCK_AVAILABLE->HrefValue = "";

            // STATUS_TARIF
            $this->STATUS_TARIF->LinkCustomAttributes = "";
            $this->STATUS_TARIF->HrefValue = "";

            // CLINIC_TYPE
            $this->CLINIC_TYPE->LinkCustomAttributes = "";
            $this->CLINIC_TYPE->HrefValue = "";

            // PACKAGE_ID
            $this->PACKAGE_ID->LinkCustomAttributes = "";
            $this->PACKAGE_ID->HrefValue = "";

            // MODULE_ID
            $this->MODULE_ID->LinkCustomAttributes = "";
            $this->MODULE_ID->HrefValue = "";

            // profession
            $this->profession->LinkCustomAttributes = "";
            $this->profession->HrefValue = "";

            // THEORDER
            $this->THEORDER->LinkCustomAttributes = "";
            $this->THEORDER->HrefValue = "";

            // CASHIER
            $this->CASHIER->LinkCustomAttributes = "";
            $this->CASHIER->HrefValue = "";

            // SPPFEE
            $this->SPPFEE->LinkCustomAttributes = "";
            $this->SPPFEE->HrefValue = "";

            // SPPBILL
            $this->SPPBILL->LinkCustomAttributes = "";
            $this->SPPBILL->HrefValue = "";

            // SPPRJK
            $this->SPPRJK->LinkCustomAttributes = "";
            $this->SPPRJK->HrefValue = "";

            // SPPJMN
            $this->SPPJMN->LinkCustomAttributes = "";
            $this->SPPJMN->HrefValue = "";

            // SPPKASIR
            $this->SPPKASIR->LinkCustomAttributes = "";
            $this->SPPKASIR->HrefValue = "";

            // PERUJUK
            $this->PERUJUK->LinkCustomAttributes = "";
            $this->PERUJUK->HrefValue = "";

            // PERUJUKFEE
            $this->PERUJUKFEE->LinkCustomAttributes = "";
            $this->PERUJUKFEE->HrefValue = "";

            // modified_datesys
            $this->modified_datesys->LinkCustomAttributes = "";
            $this->modified_datesys->HrefValue = "";

            // TRANS_ID
            $this->TRANS_ID->LinkCustomAttributes = "";
            $this->TRANS_ID->HrefValue = "";

            // SPPBILLDATE
            $this->SPPBILLDATE->LinkCustomAttributes = "";
            $this->SPPBILLDATE->HrefValue = "";

            // SPPBILLUSER
            $this->SPPBILLUSER->LinkCustomAttributes = "";
            $this->SPPBILLUSER->HrefValue = "";

            // SPPKASIRDATE
            $this->SPPKASIRDATE->LinkCustomAttributes = "";
            $this->SPPKASIRDATE->HrefValue = "";

            // SPPKASIRUSER
            $this->SPPKASIRUSER->LinkCustomAttributes = "";
            $this->SPPKASIRUSER->HrefValue = "";

            // SPPPOLI
            $this->SPPPOLI->LinkCustomAttributes = "";
            $this->SPPPOLI->HrefValue = "";

            // SPPPOLIUSER
            $this->SPPPOLIUSER->LinkCustomAttributes = "";
            $this->SPPPOLIUSER->HrefValue = "";

            // SPPPOLIDATE
            $this->SPPPOLIDATE->LinkCustomAttributes = "";
            $this->SPPPOLIDATE->HrefValue = "";
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
        if ($this->ORG_UNIT_CODE->Required) {
            if (!$this->ORG_UNIT_CODE->IsDetailKey && EmptyValue($this->ORG_UNIT_CODE->FormValue)) {
                $this->ORG_UNIT_CODE->addErrorMessage(str_replace("%s", $this->ORG_UNIT_CODE->caption(), $this->ORG_UNIT_CODE->RequiredErrorMessage));
            }
        }
        if ($this->BILL_ID->Required) {
            if (!$this->BILL_ID->IsDetailKey && EmptyValue($this->BILL_ID->FormValue)) {
                $this->BILL_ID->addErrorMessage(str_replace("%s", $this->BILL_ID->caption(), $this->BILL_ID->RequiredErrorMessage));
            }
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
        if ($this->CLASS_ID->Required) {
            if (!$this->CLASS_ID->IsDetailKey && EmptyValue($this->CLASS_ID->FormValue)) {
                $this->CLASS_ID->addErrorMessage(str_replace("%s", $this->CLASS_ID->caption(), $this->CLASS_ID->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->CLASS_ID->FormValue)) {
            $this->CLASS_ID->addErrorMessage($this->CLASS_ID->getErrorMessage(false));
        }
        if ($this->CLINIC_ID->Required) {
            if (!$this->CLINIC_ID->IsDetailKey && EmptyValue($this->CLINIC_ID->FormValue)) {
                $this->CLINIC_ID->addErrorMessage(str_replace("%s", $this->CLINIC_ID->caption(), $this->CLINIC_ID->RequiredErrorMessage));
            }
        }
        if ($this->CLINIC_ID_FROM->Required) {
            if (!$this->CLINIC_ID_FROM->IsDetailKey && EmptyValue($this->CLINIC_ID_FROM->FormValue)) {
                $this->CLINIC_ID_FROM->addErrorMessage(str_replace("%s", $this->CLINIC_ID_FROM->caption(), $this->CLINIC_ID_FROM->RequiredErrorMessage));
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
        if (!CheckDate($this->TREAT_DATE->FormValue)) {
            $this->TREAT_DATE->addErrorMessage($this->TREAT_DATE->getErrorMessage(false));
        }
        if ($this->AMOUNT->Required) {
            if (!$this->AMOUNT->IsDetailKey && EmptyValue($this->AMOUNT->FormValue)) {
                $this->AMOUNT->addErrorMessage(str_replace("%s", $this->AMOUNT->caption(), $this->AMOUNT->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->AMOUNT->FormValue)) {
            $this->AMOUNT->addErrorMessage($this->AMOUNT->getErrorMessage(false));
        }
        if ($this->QUANTITY->Required) {
            if (!$this->QUANTITY->IsDetailKey && EmptyValue($this->QUANTITY->FormValue)) {
                $this->QUANTITY->addErrorMessage(str_replace("%s", $this->QUANTITY->caption(), $this->QUANTITY->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->QUANTITY->FormValue)) {
            $this->QUANTITY->addErrorMessage($this->QUANTITY->getErrorMessage(false));
        }
        if ($this->MEASURE_ID->Required) {
            if (!$this->MEASURE_ID->IsDetailKey && EmptyValue($this->MEASURE_ID->FormValue)) {
                $this->MEASURE_ID->addErrorMessage(str_replace("%s", $this->MEASURE_ID->caption(), $this->MEASURE_ID->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->MEASURE_ID->FormValue)) {
            $this->MEASURE_ID->addErrorMessage($this->MEASURE_ID->getErrorMessage(false));
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
        if ($this->MARGIN->Required) {
            if (!$this->MARGIN->IsDetailKey && EmptyValue($this->MARGIN->FormValue)) {
                $this->MARGIN->addErrorMessage(str_replace("%s", $this->MARGIN->caption(), $this->MARGIN->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->MARGIN->FormValue)) {
            $this->MARGIN->addErrorMessage($this->MARGIN->getErrorMessage(false));
        }
        if ($this->SUBSIDI->Required) {
            if (!$this->SUBSIDI->IsDetailKey && EmptyValue($this->SUBSIDI->FormValue)) {
                $this->SUBSIDI->addErrorMessage(str_replace("%s", $this->SUBSIDI->caption(), $this->SUBSIDI->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->SUBSIDI->FormValue)) {
            $this->SUBSIDI->addErrorMessage($this->SUBSIDI->getErrorMessage(false));
        }
        if ($this->EMBALACE->Required) {
            if (!$this->EMBALACE->IsDetailKey && EmptyValue($this->EMBALACE->FormValue)) {
                $this->EMBALACE->addErrorMessage(str_replace("%s", $this->EMBALACE->caption(), $this->EMBALACE->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->EMBALACE->FormValue)) {
            $this->EMBALACE->addErrorMessage($this->EMBALACE->getErrorMessage(false));
        }
        if ($this->PROFESI->Required) {
            if (!$this->PROFESI->IsDetailKey && EmptyValue($this->PROFESI->FormValue)) {
                $this->PROFESI->addErrorMessage(str_replace("%s", $this->PROFESI->caption(), $this->PROFESI->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->PROFESI->FormValue)) {
            $this->PROFESI->addErrorMessage($this->PROFESI->getErrorMessage(false));
        }
        if ($this->DISCOUNT->Required) {
            if (!$this->DISCOUNT->IsDetailKey && EmptyValue($this->DISCOUNT->FormValue)) {
                $this->DISCOUNT->addErrorMessage(str_replace("%s", $this->DISCOUNT->caption(), $this->DISCOUNT->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->DISCOUNT->FormValue)) {
            $this->DISCOUNT->addErrorMessage($this->DISCOUNT->getErrorMessage(false));
        }
        if ($this->PAY_METHOD_ID->Required) {
            if (!$this->PAY_METHOD_ID->IsDetailKey && EmptyValue($this->PAY_METHOD_ID->FormValue)) {
                $this->PAY_METHOD_ID->addErrorMessage(str_replace("%s", $this->PAY_METHOD_ID->caption(), $this->PAY_METHOD_ID->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->PAY_METHOD_ID->FormValue)) {
            $this->PAY_METHOD_ID->addErrorMessage($this->PAY_METHOD_ID->getErrorMessage(false));
        }
        if ($this->PAYMENT_DATE->Required) {
            if (!$this->PAYMENT_DATE->IsDetailKey && EmptyValue($this->PAYMENT_DATE->FormValue)) {
                $this->PAYMENT_DATE->addErrorMessage(str_replace("%s", $this->PAYMENT_DATE->caption(), $this->PAYMENT_DATE->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->PAYMENT_DATE->FormValue)) {
            $this->PAYMENT_DATE->addErrorMessage($this->PAYMENT_DATE->getErrorMessage(false));
        }
        if ($this->ISLUNAS->Required) {
            if (!$this->ISLUNAS->IsDetailKey && EmptyValue($this->ISLUNAS->FormValue)) {
                $this->ISLUNAS->addErrorMessage(str_replace("%s", $this->ISLUNAS->caption(), $this->ISLUNAS->RequiredErrorMessage));
            }
        }
        if ($this->DUEDATE_ANGSURAN->Required) {
            if (!$this->DUEDATE_ANGSURAN->IsDetailKey && EmptyValue($this->DUEDATE_ANGSURAN->FormValue)) {
                $this->DUEDATE_ANGSURAN->addErrorMessage(str_replace("%s", $this->DUEDATE_ANGSURAN->caption(), $this->DUEDATE_ANGSURAN->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->DUEDATE_ANGSURAN->FormValue)) {
            $this->DUEDATE_ANGSURAN->addErrorMessage($this->DUEDATE_ANGSURAN->getErrorMessage(false));
        }
        if ($this->DESCRIPTION->Required) {
            if (!$this->DESCRIPTION->IsDetailKey && EmptyValue($this->DESCRIPTION->FormValue)) {
                $this->DESCRIPTION->addErrorMessage(str_replace("%s", $this->DESCRIPTION->caption(), $this->DESCRIPTION->RequiredErrorMessage));
            }
        }
        if ($this->KUITANSI_ID->Required) {
            if (!$this->KUITANSI_ID->IsDetailKey && EmptyValue($this->KUITANSI_ID->FormValue)) {
                $this->KUITANSI_ID->addErrorMessage(str_replace("%s", $this->KUITANSI_ID->caption(), $this->KUITANSI_ID->RequiredErrorMessage));
            }
        }
        if ($this->NOTA_NO->Required) {
            if (!$this->NOTA_NO->IsDetailKey && EmptyValue($this->NOTA_NO->FormValue)) {
                $this->NOTA_NO->addErrorMessage(str_replace("%s", $this->NOTA_NO->caption(), $this->NOTA_NO->RequiredErrorMessage));
            }
        }
        if ($this->ISCETAK->Required) {
            if (!$this->ISCETAK->IsDetailKey && EmptyValue($this->ISCETAK->FormValue)) {
                $this->ISCETAK->addErrorMessage(str_replace("%s", $this->ISCETAK->caption(), $this->ISCETAK->RequiredErrorMessage));
            }
        }
        if ($this->PRINT_DATE->Required) {
            if (!$this->PRINT_DATE->IsDetailKey && EmptyValue($this->PRINT_DATE->FormValue)) {
                $this->PRINT_DATE->addErrorMessage(str_replace("%s", $this->PRINT_DATE->caption(), $this->PRINT_DATE->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->PRINT_DATE->FormValue)) {
            $this->PRINT_DATE->addErrorMessage($this->PRINT_DATE->getErrorMessage(false));
        }
        if ($this->RESEP_NO->Required) {
            if (!$this->RESEP_NO->IsDetailKey && EmptyValue($this->RESEP_NO->FormValue)) {
                $this->RESEP_NO->addErrorMessage(str_replace("%s", $this->RESEP_NO->caption(), $this->RESEP_NO->RequiredErrorMessage));
            }
        }
        if ($this->RESEP_KE->Required) {
            if (!$this->RESEP_KE->IsDetailKey && EmptyValue($this->RESEP_KE->FormValue)) {
                $this->RESEP_KE->addErrorMessage(str_replace("%s", $this->RESEP_KE->caption(), $this->RESEP_KE->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->RESEP_KE->FormValue)) {
            $this->RESEP_KE->addErrorMessage($this->RESEP_KE->getErrorMessage(false));
        }
        if ($this->DOSE->Required) {
            if (!$this->DOSE->IsDetailKey && EmptyValue($this->DOSE->FormValue)) {
                $this->DOSE->addErrorMessage(str_replace("%s", $this->DOSE->caption(), $this->DOSE->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->DOSE->FormValue)) {
            $this->DOSE->addErrorMessage($this->DOSE->getErrorMessage(false));
        }
        if ($this->ORIG_DOSE->Required) {
            if (!$this->ORIG_DOSE->IsDetailKey && EmptyValue($this->ORIG_DOSE->FormValue)) {
                $this->ORIG_DOSE->addErrorMessage(str_replace("%s", $this->ORIG_DOSE->caption(), $this->ORIG_DOSE->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->ORIG_DOSE->FormValue)) {
            $this->ORIG_DOSE->addErrorMessage($this->ORIG_DOSE->getErrorMessage(false));
        }
        if ($this->DOSE_PRESC->Required) {
            if (!$this->DOSE_PRESC->IsDetailKey && EmptyValue($this->DOSE_PRESC->FormValue)) {
                $this->DOSE_PRESC->addErrorMessage(str_replace("%s", $this->DOSE_PRESC->caption(), $this->DOSE_PRESC->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->DOSE_PRESC->FormValue)) {
            $this->DOSE_PRESC->addErrorMessage($this->DOSE_PRESC->getErrorMessage(false));
        }
        if ($this->ITER->Required) {
            if (!$this->ITER->IsDetailKey && EmptyValue($this->ITER->FormValue)) {
                $this->ITER->addErrorMessage(str_replace("%s", $this->ITER->caption(), $this->ITER->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->ITER->FormValue)) {
            $this->ITER->addErrorMessage($this->ITER->getErrorMessage(false));
        }
        if ($this->ITER_KE->Required) {
            if (!$this->ITER_KE->IsDetailKey && EmptyValue($this->ITER_KE->FormValue)) {
                $this->ITER_KE->addErrorMessage(str_replace("%s", $this->ITER_KE->caption(), $this->ITER_KE->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->ITER_KE->FormValue)) {
            $this->ITER_KE->addErrorMessage($this->ITER_KE->getErrorMessage(false));
        }
        if ($this->SOLD_STATUS->Required) {
            if (!$this->SOLD_STATUS->IsDetailKey && EmptyValue($this->SOLD_STATUS->FormValue)) {
                $this->SOLD_STATUS->addErrorMessage(str_replace("%s", $this->SOLD_STATUS->caption(), $this->SOLD_STATUS->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->SOLD_STATUS->FormValue)) {
            $this->SOLD_STATUS->addErrorMessage($this->SOLD_STATUS->getErrorMessage(false));
        }
        if ($this->RACIKAN->Required) {
            if (!$this->RACIKAN->IsDetailKey && EmptyValue($this->RACIKAN->FormValue)) {
                $this->RACIKAN->addErrorMessage(str_replace("%s", $this->RACIKAN->caption(), $this->RACIKAN->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->RACIKAN->FormValue)) {
            $this->RACIKAN->addErrorMessage($this->RACIKAN->getErrorMessage(false));
        }
        if ($this->CLASS_ROOM_ID->Required) {
            if (!$this->CLASS_ROOM_ID->IsDetailKey && EmptyValue($this->CLASS_ROOM_ID->FormValue)) {
                $this->CLASS_ROOM_ID->addErrorMessage(str_replace("%s", $this->CLASS_ROOM_ID->caption(), $this->CLASS_ROOM_ID->RequiredErrorMessage));
            }
        }
        if ($this->KELUAR_ID->Required) {
            if (!$this->KELUAR_ID->IsDetailKey && EmptyValue($this->KELUAR_ID->FormValue)) {
                $this->KELUAR_ID->addErrorMessage(str_replace("%s", $this->KELUAR_ID->caption(), $this->KELUAR_ID->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->KELUAR_ID->FormValue)) {
            $this->KELUAR_ID->addErrorMessage($this->KELUAR_ID->getErrorMessage(false));
        }
        if ($this->BED_ID->Required) {
            if (!$this->BED_ID->IsDetailKey && EmptyValue($this->BED_ID->FormValue)) {
                $this->BED_ID->addErrorMessage(str_replace("%s", $this->BED_ID->caption(), $this->BED_ID->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->BED_ID->FormValue)) {
            $this->BED_ID->addErrorMessage($this->BED_ID->getErrorMessage(false));
        }
        if ($this->PERDA_ID->Required) {
            if (!$this->PERDA_ID->IsDetailKey && EmptyValue($this->PERDA_ID->FormValue)) {
                $this->PERDA_ID->addErrorMessage(str_replace("%s", $this->PERDA_ID->caption(), $this->PERDA_ID->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->PERDA_ID->FormValue)) {
            $this->PERDA_ID->addErrorMessage($this->PERDA_ID->getErrorMessage(false));
        }
        if ($this->EMPLOYEE_ID->Required) {
            if (!$this->EMPLOYEE_ID->IsDetailKey && EmptyValue($this->EMPLOYEE_ID->FormValue)) {
                $this->EMPLOYEE_ID->addErrorMessage(str_replace("%s", $this->EMPLOYEE_ID->caption(), $this->EMPLOYEE_ID->RequiredErrorMessage));
            }
        }
        if ($this->DESCRIPTION2->Required) {
            if (!$this->DESCRIPTION2->IsDetailKey && EmptyValue($this->DESCRIPTION2->FormValue)) {
                $this->DESCRIPTION2->addErrorMessage(str_replace("%s", $this->DESCRIPTION2->caption(), $this->DESCRIPTION2->RequiredErrorMessage));
            }
        }
        if ($this->MODIFIED_BY->Required) {
            if (!$this->MODIFIED_BY->IsDetailKey && EmptyValue($this->MODIFIED_BY->FormValue)) {
                $this->MODIFIED_BY->addErrorMessage(str_replace("%s", $this->MODIFIED_BY->caption(), $this->MODIFIED_BY->RequiredErrorMessage));
            }
        }
        if ($this->MODIFIED_DATE->Required) {
            if (!$this->MODIFIED_DATE->IsDetailKey && EmptyValue($this->MODIFIED_DATE->FormValue)) {
                $this->MODIFIED_DATE->addErrorMessage(str_replace("%s", $this->MODIFIED_DATE->caption(), $this->MODIFIED_DATE->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->MODIFIED_DATE->FormValue)) {
            $this->MODIFIED_DATE->addErrorMessage($this->MODIFIED_DATE->getErrorMessage(false));
        }
        if ($this->MODIFIED_FROM->Required) {
            if (!$this->MODIFIED_FROM->IsDetailKey && EmptyValue($this->MODIFIED_FROM->FormValue)) {
                $this->MODIFIED_FROM->addErrorMessage(str_replace("%s", $this->MODIFIED_FROM->caption(), $this->MODIFIED_FROM->RequiredErrorMessage));
            }
        }
        if ($this->BRAND_ID->Required) {
            if (!$this->BRAND_ID->IsDetailKey && EmptyValue($this->BRAND_ID->FormValue)) {
                $this->BRAND_ID->addErrorMessage(str_replace("%s", $this->BRAND_ID->caption(), $this->BRAND_ID->RequiredErrorMessage));
            }
        }
        if ($this->DOCTOR->Required) {
            if (!$this->DOCTOR->IsDetailKey && EmptyValue($this->DOCTOR->FormValue)) {
                $this->DOCTOR->addErrorMessage(str_replace("%s", $this->DOCTOR->caption(), $this->DOCTOR->RequiredErrorMessage));
            }
        }
        if ($this->JML_BKS->Required) {
            if (!$this->JML_BKS->IsDetailKey && EmptyValue($this->JML_BKS->FormValue)) {
                $this->JML_BKS->addErrorMessage(str_replace("%s", $this->JML_BKS->caption(), $this->JML_BKS->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->JML_BKS->FormValue)) {
            $this->JML_BKS->addErrorMessage($this->JML_BKS->getErrorMessage(false));
        }
        if ($this->EXIT_DATE->Required) {
            if (!$this->EXIT_DATE->IsDetailKey && EmptyValue($this->EXIT_DATE->FormValue)) {
                $this->EXIT_DATE->addErrorMessage(str_replace("%s", $this->EXIT_DATE->caption(), $this->EXIT_DATE->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->EXIT_DATE->FormValue)) {
            $this->EXIT_DATE->addErrorMessage($this->EXIT_DATE->getErrorMessage(false));
        }
        if ($this->FA_V->Required) {
            if (!$this->FA_V->IsDetailKey && EmptyValue($this->FA_V->FormValue)) {
                $this->FA_V->addErrorMessage(str_replace("%s", $this->FA_V->caption(), $this->FA_V->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->FA_V->FormValue)) {
            $this->FA_V->addErrorMessage($this->FA_V->getErrorMessage(false));
        }
        if ($this->TASK_ID->Required) {
            if (!$this->TASK_ID->IsDetailKey && EmptyValue($this->TASK_ID->FormValue)) {
                $this->TASK_ID->addErrorMessage(str_replace("%s", $this->TASK_ID->caption(), $this->TASK_ID->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->TASK_ID->FormValue)) {
            $this->TASK_ID->addErrorMessage($this->TASK_ID->getErrorMessage(false));
        }
        if ($this->EMPLOYEE_ID_FROM->Required) {
            if (!$this->EMPLOYEE_ID_FROM->IsDetailKey && EmptyValue($this->EMPLOYEE_ID_FROM->FormValue)) {
                $this->EMPLOYEE_ID_FROM->addErrorMessage(str_replace("%s", $this->EMPLOYEE_ID_FROM->caption(), $this->EMPLOYEE_ID_FROM->RequiredErrorMessage));
            }
        }
        if ($this->DOCTOR_FROM->Required) {
            if (!$this->DOCTOR_FROM->IsDetailKey && EmptyValue($this->DOCTOR_FROM->FormValue)) {
                $this->DOCTOR_FROM->addErrorMessage(str_replace("%s", $this->DOCTOR_FROM->caption(), $this->DOCTOR_FROM->RequiredErrorMessage));
            }
        }
        if ($this->status_pasien_id->Required) {
            if (!$this->status_pasien_id->IsDetailKey && EmptyValue($this->status_pasien_id->FormValue)) {
                $this->status_pasien_id->addErrorMessage(str_replace("%s", $this->status_pasien_id->caption(), $this->status_pasien_id->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->status_pasien_id->FormValue)) {
            $this->status_pasien_id->addErrorMessage($this->status_pasien_id->getErrorMessage(false));
        }
        if ($this->amount_paid->Required) {
            if (!$this->amount_paid->IsDetailKey && EmptyValue($this->amount_paid->FormValue)) {
                $this->amount_paid->addErrorMessage(str_replace("%s", $this->amount_paid->caption(), $this->amount_paid->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->amount_paid->FormValue)) {
            $this->amount_paid->addErrorMessage($this->amount_paid->getErrorMessage(false));
        }
        if ($this->THENAME->Required) {
            if (!$this->THENAME->IsDetailKey && EmptyValue($this->THENAME->FormValue)) {
                $this->THENAME->addErrorMessage(str_replace("%s", $this->THENAME->caption(), $this->THENAME->RequiredErrorMessage));
            }
        }
        if ($this->THEADDRESS->Required) {
            if (!$this->THEADDRESS->IsDetailKey && EmptyValue($this->THEADDRESS->FormValue)) {
                $this->THEADDRESS->addErrorMessage(str_replace("%s", $this->THEADDRESS->caption(), $this->THEADDRESS->RequiredErrorMessage));
            }
        }
        if ($this->THEID->Required) {
            if (!$this->THEID->IsDetailKey && EmptyValue($this->THEID->FormValue)) {
                $this->THEID->addErrorMessage(str_replace("%s", $this->THEID->caption(), $this->THEID->RequiredErrorMessage));
            }
        }
        if ($this->serial_nb->Required) {
            if (!$this->serial_nb->IsDetailKey && EmptyValue($this->serial_nb->FormValue)) {
                $this->serial_nb->addErrorMessage(str_replace("%s", $this->serial_nb->caption(), $this->serial_nb->RequiredErrorMessage));
            }
        }
        if ($this->TREATMENT_PLAFOND->Required) {
            if (!$this->TREATMENT_PLAFOND->IsDetailKey && EmptyValue($this->TREATMENT_PLAFOND->FormValue)) {
                $this->TREATMENT_PLAFOND->addErrorMessage(str_replace("%s", $this->TREATMENT_PLAFOND->caption(), $this->TREATMENT_PLAFOND->RequiredErrorMessage));
            }
        }
        if ($this->AMOUNT_PLAFOND->Required) {
            if (!$this->AMOUNT_PLAFOND->IsDetailKey && EmptyValue($this->AMOUNT_PLAFOND->FormValue)) {
                $this->AMOUNT_PLAFOND->addErrorMessage(str_replace("%s", $this->AMOUNT_PLAFOND->caption(), $this->AMOUNT_PLAFOND->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->AMOUNT_PLAFOND->FormValue)) {
            $this->AMOUNT_PLAFOND->addErrorMessage($this->AMOUNT_PLAFOND->getErrorMessage(false));
        }
        if ($this->AMOUNT_PAID_PLAFOND->Required) {
            if (!$this->AMOUNT_PAID_PLAFOND->IsDetailKey && EmptyValue($this->AMOUNT_PAID_PLAFOND->FormValue)) {
                $this->AMOUNT_PAID_PLAFOND->addErrorMessage(str_replace("%s", $this->AMOUNT_PAID_PLAFOND->caption(), $this->AMOUNT_PAID_PLAFOND->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->AMOUNT_PAID_PLAFOND->FormValue)) {
            $this->AMOUNT_PAID_PLAFOND->addErrorMessage($this->AMOUNT_PAID_PLAFOND->getErrorMessage(false));
        }
        if ($this->CLASS_ID_PLAFOND->Required) {
            if (!$this->CLASS_ID_PLAFOND->IsDetailKey && EmptyValue($this->CLASS_ID_PLAFOND->FormValue)) {
                $this->CLASS_ID_PLAFOND->addErrorMessage(str_replace("%s", $this->CLASS_ID_PLAFOND->caption(), $this->CLASS_ID_PLAFOND->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->CLASS_ID_PLAFOND->FormValue)) {
            $this->CLASS_ID_PLAFOND->addErrorMessage($this->CLASS_ID_PLAFOND->getErrorMessage(false));
        }
        if ($this->PAYOR_ID->Required) {
            if (!$this->PAYOR_ID->IsDetailKey && EmptyValue($this->PAYOR_ID->FormValue)) {
                $this->PAYOR_ID->addErrorMessage(str_replace("%s", $this->PAYOR_ID->caption(), $this->PAYOR_ID->RequiredErrorMessage));
            }
        }
        if ($this->PEMBULATAN->Required) {
            if (!$this->PEMBULATAN->IsDetailKey && EmptyValue($this->PEMBULATAN->FormValue)) {
                $this->PEMBULATAN->addErrorMessage(str_replace("%s", $this->PEMBULATAN->caption(), $this->PEMBULATAN->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->PEMBULATAN->FormValue)) {
            $this->PEMBULATAN->addErrorMessage($this->PEMBULATAN->getErrorMessage(false));
        }
        if ($this->ISRJ->Required) {
            if (!$this->ISRJ->IsDetailKey && EmptyValue($this->ISRJ->FormValue)) {
                $this->ISRJ->addErrorMessage(str_replace("%s", $this->ISRJ->caption(), $this->ISRJ->RequiredErrorMessage));
            }
        }
        if ($this->AGEYEAR->Required) {
            if (!$this->AGEYEAR->IsDetailKey && EmptyValue($this->AGEYEAR->FormValue)) {
                $this->AGEYEAR->addErrorMessage(str_replace("%s", $this->AGEYEAR->caption(), $this->AGEYEAR->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->AGEYEAR->FormValue)) {
            $this->AGEYEAR->addErrorMessage($this->AGEYEAR->getErrorMessage(false));
        }
        if ($this->AGEMONTH->Required) {
            if (!$this->AGEMONTH->IsDetailKey && EmptyValue($this->AGEMONTH->FormValue)) {
                $this->AGEMONTH->addErrorMessage(str_replace("%s", $this->AGEMONTH->caption(), $this->AGEMONTH->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->AGEMONTH->FormValue)) {
            $this->AGEMONTH->addErrorMessage($this->AGEMONTH->getErrorMessage(false));
        }
        if ($this->AGEDAY->Required) {
            if (!$this->AGEDAY->IsDetailKey && EmptyValue($this->AGEDAY->FormValue)) {
                $this->AGEDAY->addErrorMessage(str_replace("%s", $this->AGEDAY->caption(), $this->AGEDAY->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->AGEDAY->FormValue)) {
            $this->AGEDAY->addErrorMessage($this->AGEDAY->getErrorMessage(false));
        }
        if ($this->GENDER->Required) {
            if (!$this->GENDER->IsDetailKey && EmptyValue($this->GENDER->FormValue)) {
                $this->GENDER->addErrorMessage(str_replace("%s", $this->GENDER->caption(), $this->GENDER->RequiredErrorMessage));
            }
        }
        if ($this->KAL_ID->Required) {
            if (!$this->KAL_ID->IsDetailKey && EmptyValue($this->KAL_ID->FormValue)) {
                $this->KAL_ID->addErrorMessage(str_replace("%s", $this->KAL_ID->caption(), $this->KAL_ID->RequiredErrorMessage));
            }
        }
        if ($this->CORRECTION_ID->Required) {
            if (!$this->CORRECTION_ID->IsDetailKey && EmptyValue($this->CORRECTION_ID->FormValue)) {
                $this->CORRECTION_ID->addErrorMessage(str_replace("%s", $this->CORRECTION_ID->caption(), $this->CORRECTION_ID->RequiredErrorMessage));
            }
        }
        if ($this->CORRECTION_BY->Required) {
            if (!$this->CORRECTION_BY->IsDetailKey && EmptyValue($this->CORRECTION_BY->FormValue)) {
                $this->CORRECTION_BY->addErrorMessage(str_replace("%s", $this->CORRECTION_BY->caption(), $this->CORRECTION_BY->RequiredErrorMessage));
            }
        }
        if ($this->KARYAWAN->Required) {
            if (!$this->KARYAWAN->IsDetailKey && EmptyValue($this->KARYAWAN->FormValue)) {
                $this->KARYAWAN->addErrorMessage(str_replace("%s", $this->KARYAWAN->caption(), $this->KARYAWAN->RequiredErrorMessage));
            }
        }
        if ($this->ACCOUNT_ID->Required) {
            if (!$this->ACCOUNT_ID->IsDetailKey && EmptyValue($this->ACCOUNT_ID->FormValue)) {
                $this->ACCOUNT_ID->addErrorMessage(str_replace("%s", $this->ACCOUNT_ID->caption(), $this->ACCOUNT_ID->RequiredErrorMessage));
            }
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
        if ($this->INVOICE_ID->Required) {
            if (!$this->INVOICE_ID->IsDetailKey && EmptyValue($this->INVOICE_ID->FormValue)) {
                $this->INVOICE_ID->addErrorMessage(str_replace("%s", $this->INVOICE_ID->caption(), $this->INVOICE_ID->RequiredErrorMessage));
            }
        }
        if ($this->NUMER->Required) {
            if (!$this->NUMER->IsDetailKey && EmptyValue($this->NUMER->FormValue)) {
                $this->NUMER->addErrorMessage(str_replace("%s", $this->NUMER->caption(), $this->NUMER->RequiredErrorMessage));
            }
        }
        if ($this->MEASURE_ID2->Required) {
            if (!$this->MEASURE_ID2->IsDetailKey && EmptyValue($this->MEASURE_ID2->FormValue)) {
                $this->MEASURE_ID2->addErrorMessage(str_replace("%s", $this->MEASURE_ID2->caption(), $this->MEASURE_ID2->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->MEASURE_ID2->FormValue)) {
            $this->MEASURE_ID2->addErrorMessage($this->MEASURE_ID2->getErrorMessage(false));
        }
        if ($this->POTONGAN->Required) {
            if (!$this->POTONGAN->IsDetailKey && EmptyValue($this->POTONGAN->FormValue)) {
                $this->POTONGAN->addErrorMessage(str_replace("%s", $this->POTONGAN->caption(), $this->POTONGAN->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->POTONGAN->FormValue)) {
            $this->POTONGAN->addErrorMessage($this->POTONGAN->getErrorMessage(false));
        }
        if ($this->BAYAR->Required) {
            if (!$this->BAYAR->IsDetailKey && EmptyValue($this->BAYAR->FormValue)) {
                $this->BAYAR->addErrorMessage(str_replace("%s", $this->BAYAR->caption(), $this->BAYAR->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->BAYAR->FormValue)) {
            $this->BAYAR->addErrorMessage($this->BAYAR->getErrorMessage(false));
        }
        if ($this->RETUR->Required) {
            if (!$this->RETUR->IsDetailKey && EmptyValue($this->RETUR->FormValue)) {
                $this->RETUR->addErrorMessage(str_replace("%s", $this->RETUR->caption(), $this->RETUR->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->RETUR->FormValue)) {
            $this->RETUR->addErrorMessage($this->RETUR->getErrorMessage(false));
        }
        if ($this->TARIF_TYPE->Required) {
            if (!$this->TARIF_TYPE->IsDetailKey && EmptyValue($this->TARIF_TYPE->FormValue)) {
                $this->TARIF_TYPE->addErrorMessage(str_replace("%s", $this->TARIF_TYPE->caption(), $this->TARIF_TYPE->RequiredErrorMessage));
            }
        }
        if ($this->PPNVALUE->Required) {
            if (!$this->PPNVALUE->IsDetailKey && EmptyValue($this->PPNVALUE->FormValue)) {
                $this->PPNVALUE->addErrorMessage(str_replace("%s", $this->PPNVALUE->caption(), $this->PPNVALUE->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->PPNVALUE->FormValue)) {
            $this->PPNVALUE->addErrorMessage($this->PPNVALUE->getErrorMessage(false));
        }
        if ($this->TAGIHAN->Required) {
            if (!$this->TAGIHAN->IsDetailKey && EmptyValue($this->TAGIHAN->FormValue)) {
                $this->TAGIHAN->addErrorMessage(str_replace("%s", $this->TAGIHAN->caption(), $this->TAGIHAN->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->TAGIHAN->FormValue)) {
            $this->TAGIHAN->addErrorMessage($this->TAGIHAN->getErrorMessage(false));
        }
        if ($this->KOREKSI->Required) {
            if (!$this->KOREKSI->IsDetailKey && EmptyValue($this->KOREKSI->FormValue)) {
                $this->KOREKSI->addErrorMessage(str_replace("%s", $this->KOREKSI->caption(), $this->KOREKSI->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->KOREKSI->FormValue)) {
            $this->KOREKSI->addErrorMessage($this->KOREKSI->getErrorMessage(false));
        }
        if ($this->STATUS_OBAT->Required) {
            if (!$this->STATUS_OBAT->IsDetailKey && EmptyValue($this->STATUS_OBAT->FormValue)) {
                $this->STATUS_OBAT->addErrorMessage(str_replace("%s", $this->STATUS_OBAT->caption(), $this->STATUS_OBAT->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->STATUS_OBAT->FormValue)) {
            $this->STATUS_OBAT->addErrorMessage($this->STATUS_OBAT->getErrorMessage(false));
        }
        if ($this->SUBSIDISAT->Required) {
            if (!$this->SUBSIDISAT->IsDetailKey && EmptyValue($this->SUBSIDISAT->FormValue)) {
                $this->SUBSIDISAT->addErrorMessage(str_replace("%s", $this->SUBSIDISAT->caption(), $this->SUBSIDISAT->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->SUBSIDISAT->FormValue)) {
            $this->SUBSIDISAT->addErrorMessage($this->SUBSIDISAT->getErrorMessage(false));
        }
        if ($this->PRINTQ->Required) {
            if (!$this->PRINTQ->IsDetailKey && EmptyValue($this->PRINTQ->FormValue)) {
                $this->PRINTQ->addErrorMessage(str_replace("%s", $this->PRINTQ->caption(), $this->PRINTQ->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->PRINTQ->FormValue)) {
            $this->PRINTQ->addErrorMessage($this->PRINTQ->getErrorMessage(false));
        }
        if ($this->PRINTED_BY->Required) {
            if (!$this->PRINTED_BY->IsDetailKey && EmptyValue($this->PRINTED_BY->FormValue)) {
                $this->PRINTED_BY->addErrorMessage(str_replace("%s", $this->PRINTED_BY->caption(), $this->PRINTED_BY->RequiredErrorMessage));
            }
        }
        if ($this->STOCK_AVAILABLE->Required) {
            if (!$this->STOCK_AVAILABLE->IsDetailKey && EmptyValue($this->STOCK_AVAILABLE->FormValue)) {
                $this->STOCK_AVAILABLE->addErrorMessage(str_replace("%s", $this->STOCK_AVAILABLE->caption(), $this->STOCK_AVAILABLE->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->STOCK_AVAILABLE->FormValue)) {
            $this->STOCK_AVAILABLE->addErrorMessage($this->STOCK_AVAILABLE->getErrorMessage(false));
        }
        if ($this->STATUS_TARIF->Required) {
            if (!$this->STATUS_TARIF->IsDetailKey && EmptyValue($this->STATUS_TARIF->FormValue)) {
                $this->STATUS_TARIF->addErrorMessage(str_replace("%s", $this->STATUS_TARIF->caption(), $this->STATUS_TARIF->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->STATUS_TARIF->FormValue)) {
            $this->STATUS_TARIF->addErrorMessage($this->STATUS_TARIF->getErrorMessage(false));
        }
        if ($this->CLINIC_TYPE->Required) {
            if (!$this->CLINIC_TYPE->IsDetailKey && EmptyValue($this->CLINIC_TYPE->FormValue)) {
                $this->CLINIC_TYPE->addErrorMessage(str_replace("%s", $this->CLINIC_TYPE->caption(), $this->CLINIC_TYPE->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->CLINIC_TYPE->FormValue)) {
            $this->CLINIC_TYPE->addErrorMessage($this->CLINIC_TYPE->getErrorMessage(false));
        }
        if ($this->PACKAGE_ID->Required) {
            if (!$this->PACKAGE_ID->IsDetailKey && EmptyValue($this->PACKAGE_ID->FormValue)) {
                $this->PACKAGE_ID->addErrorMessage(str_replace("%s", $this->PACKAGE_ID->caption(), $this->PACKAGE_ID->RequiredErrorMessage));
            }
        }
        if ($this->MODULE_ID->Required) {
            if (!$this->MODULE_ID->IsDetailKey && EmptyValue($this->MODULE_ID->FormValue)) {
                $this->MODULE_ID->addErrorMessage(str_replace("%s", $this->MODULE_ID->caption(), $this->MODULE_ID->RequiredErrorMessage));
            }
        }
        if ($this->profession->Required) {
            if (!$this->profession->IsDetailKey && EmptyValue($this->profession->FormValue)) {
                $this->profession->addErrorMessage(str_replace("%s", $this->profession->caption(), $this->profession->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->profession->FormValue)) {
            $this->profession->addErrorMessage($this->profession->getErrorMessage(false));
        }
        if ($this->THEORDER->Required) {
            if (!$this->THEORDER->IsDetailKey && EmptyValue($this->THEORDER->FormValue)) {
                $this->THEORDER->addErrorMessage(str_replace("%s", $this->THEORDER->caption(), $this->THEORDER->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->THEORDER->FormValue)) {
            $this->THEORDER->addErrorMessage($this->THEORDER->getErrorMessage(false));
        }
        if ($this->CASHIER->Required) {
            if (!$this->CASHIER->IsDetailKey && EmptyValue($this->CASHIER->FormValue)) {
                $this->CASHIER->addErrorMessage(str_replace("%s", $this->CASHIER->caption(), $this->CASHIER->RequiredErrorMessage));
            }
        }
        if ($this->SPPFEE->Required) {
            if (!$this->SPPFEE->IsDetailKey && EmptyValue($this->SPPFEE->FormValue)) {
                $this->SPPFEE->addErrorMessage(str_replace("%s", $this->SPPFEE->caption(), $this->SPPFEE->RequiredErrorMessage));
            }
        }
        if ($this->SPPBILL->Required) {
            if (!$this->SPPBILL->IsDetailKey && EmptyValue($this->SPPBILL->FormValue)) {
                $this->SPPBILL->addErrorMessage(str_replace("%s", $this->SPPBILL->caption(), $this->SPPBILL->RequiredErrorMessage));
            }
        }
        if ($this->SPPRJK->Required) {
            if (!$this->SPPRJK->IsDetailKey && EmptyValue($this->SPPRJK->FormValue)) {
                $this->SPPRJK->addErrorMessage(str_replace("%s", $this->SPPRJK->caption(), $this->SPPRJK->RequiredErrorMessage));
            }
        }
        if ($this->SPPJMN->Required) {
            if (!$this->SPPJMN->IsDetailKey && EmptyValue($this->SPPJMN->FormValue)) {
                $this->SPPJMN->addErrorMessage(str_replace("%s", $this->SPPJMN->caption(), $this->SPPJMN->RequiredErrorMessage));
            }
        }
        if ($this->SPPKASIR->Required) {
            if (!$this->SPPKASIR->IsDetailKey && EmptyValue($this->SPPKASIR->FormValue)) {
                $this->SPPKASIR->addErrorMessage(str_replace("%s", $this->SPPKASIR->caption(), $this->SPPKASIR->RequiredErrorMessage));
            }
        }
        if ($this->PERUJUK->Required) {
            if (!$this->PERUJUK->IsDetailKey && EmptyValue($this->PERUJUK->FormValue)) {
                $this->PERUJUK->addErrorMessage(str_replace("%s", $this->PERUJUK->caption(), $this->PERUJUK->RequiredErrorMessage));
            }
        }
        if ($this->PERUJUKFEE->Required) {
            if (!$this->PERUJUKFEE->IsDetailKey && EmptyValue($this->PERUJUKFEE->FormValue)) {
                $this->PERUJUKFEE->addErrorMessage(str_replace("%s", $this->PERUJUKFEE->caption(), $this->PERUJUKFEE->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->PERUJUKFEE->FormValue)) {
            $this->PERUJUKFEE->addErrorMessage($this->PERUJUKFEE->getErrorMessage(false));
        }
        if ($this->modified_datesys->Required) {
            if (!$this->modified_datesys->IsDetailKey && EmptyValue($this->modified_datesys->FormValue)) {
                $this->modified_datesys->addErrorMessage(str_replace("%s", $this->modified_datesys->caption(), $this->modified_datesys->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->modified_datesys->FormValue)) {
            $this->modified_datesys->addErrorMessage($this->modified_datesys->getErrorMessage(false));
        }
        if ($this->TRANS_ID->Required) {
            if (!$this->TRANS_ID->IsDetailKey && EmptyValue($this->TRANS_ID->FormValue)) {
                $this->TRANS_ID->addErrorMessage(str_replace("%s", $this->TRANS_ID->caption(), $this->TRANS_ID->RequiredErrorMessage));
            }
        }
        if ($this->SPPBILLDATE->Required) {
            if (!$this->SPPBILLDATE->IsDetailKey && EmptyValue($this->SPPBILLDATE->FormValue)) {
                $this->SPPBILLDATE->addErrorMessage(str_replace("%s", $this->SPPBILLDATE->caption(), $this->SPPBILLDATE->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->SPPBILLDATE->FormValue)) {
            $this->SPPBILLDATE->addErrorMessage($this->SPPBILLDATE->getErrorMessage(false));
        }
        if ($this->SPPBILLUSER->Required) {
            if (!$this->SPPBILLUSER->IsDetailKey && EmptyValue($this->SPPBILLUSER->FormValue)) {
                $this->SPPBILLUSER->addErrorMessage(str_replace("%s", $this->SPPBILLUSER->caption(), $this->SPPBILLUSER->RequiredErrorMessage));
            }
        }
        if ($this->SPPKASIRDATE->Required) {
            if (!$this->SPPKASIRDATE->IsDetailKey && EmptyValue($this->SPPKASIRDATE->FormValue)) {
                $this->SPPKASIRDATE->addErrorMessage(str_replace("%s", $this->SPPKASIRDATE->caption(), $this->SPPKASIRDATE->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->SPPKASIRDATE->FormValue)) {
            $this->SPPKASIRDATE->addErrorMessage($this->SPPKASIRDATE->getErrorMessage(false));
        }
        if ($this->SPPKASIRUSER->Required) {
            if (!$this->SPPKASIRUSER->IsDetailKey && EmptyValue($this->SPPKASIRUSER->FormValue)) {
                $this->SPPKASIRUSER->addErrorMessage(str_replace("%s", $this->SPPKASIRUSER->caption(), $this->SPPKASIRUSER->RequiredErrorMessage));
            }
        }
        if ($this->SPPPOLI->Required) {
            if (!$this->SPPPOLI->IsDetailKey && EmptyValue($this->SPPPOLI->FormValue)) {
                $this->SPPPOLI->addErrorMessage(str_replace("%s", $this->SPPPOLI->caption(), $this->SPPPOLI->RequiredErrorMessage));
            }
        }
        if ($this->SPPPOLIUSER->Required) {
            if (!$this->SPPPOLIUSER->IsDetailKey && EmptyValue($this->SPPPOLIUSER->FormValue)) {
                $this->SPPPOLIUSER->addErrorMessage(str_replace("%s", $this->SPPPOLIUSER->caption(), $this->SPPPOLIUSER->RequiredErrorMessage));
            }
        }
        if ($this->SPPPOLIDATE->Required) {
            if (!$this->SPPPOLIDATE->IsDetailKey && EmptyValue($this->SPPPOLIDATE->FormValue)) {
                $this->SPPPOLIDATE->addErrorMessage(str_replace("%s", $this->SPPPOLIDATE->caption(), $this->SPPPOLIDATE->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->SPPPOLIDATE->FormValue)) {
            $this->SPPPOLIDATE->addErrorMessage($this->SPPPOLIDATE->getErrorMessage(false));
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

        // ORG_UNIT_CODE
        $this->ORG_UNIT_CODE->setDbValueDef($rsnew, $this->ORG_UNIT_CODE->CurrentValue, null, strval($this->ORG_UNIT_CODE->CurrentValue) == "");

        // BILL_ID
        $this->BILL_ID->setDbValueDef($rsnew, $this->BILL_ID->CurrentValue, "", strval($this->BILL_ID->CurrentValue) == "");

        // NO_REGISTRATION
        $this->NO_REGISTRATION->setDbValueDef($rsnew, $this->NO_REGISTRATION->CurrentValue, "", false);

        // VISIT_ID
        $this->VISIT_ID->setDbValueDef($rsnew, $this->VISIT_ID->CurrentValue, "", false);

        // TARIF_ID
        $this->TARIF_ID->setDbValueDef($rsnew, $this->TARIF_ID->CurrentValue, null, false);

        // CLASS_ID
        $this->CLASS_ID->setDbValueDef($rsnew, $this->CLASS_ID->CurrentValue, null, strval($this->CLASS_ID->CurrentValue) == "");

        // CLINIC_ID
        $this->CLINIC_ID->setDbValueDef($rsnew, $this->CLINIC_ID->CurrentValue, null, false);

        // CLINIC_ID_FROM
        $this->CLINIC_ID_FROM->setDbValueDef($rsnew, $this->CLINIC_ID_FROM->CurrentValue, null, false);

        // TREATMENT
        $this->TREATMENT->setDbValueDef($rsnew, $this->TREATMENT->CurrentValue, null, false);

        // TREAT_DATE
        $this->TREAT_DATE->setDbValueDef($rsnew, UnFormatDateTime($this->TREAT_DATE->CurrentValue, 0), null, false);

        // AMOUNT
        $this->AMOUNT->setDbValueDef($rsnew, $this->AMOUNT->CurrentValue, null, false);

        // QUANTITY
        $this->QUANTITY->setDbValueDef($rsnew, $this->QUANTITY->CurrentValue, null, strval($this->QUANTITY->CurrentValue) == "");

        // MEASURE_ID
        $this->MEASURE_ID->setDbValueDef($rsnew, $this->MEASURE_ID->CurrentValue, null, false);

        // POKOK_JUAL
        $this->POKOK_JUAL->setDbValueDef($rsnew, $this->POKOK_JUAL->CurrentValue, null, strval($this->POKOK_JUAL->CurrentValue) == "");

        // PPN
        $this->PPN->setDbValueDef($rsnew, $this->PPN->CurrentValue, null, strval($this->PPN->CurrentValue) == "");

        // MARGIN
        $this->MARGIN->setDbValueDef($rsnew, $this->MARGIN->CurrentValue, null, strval($this->MARGIN->CurrentValue) == "");

        // SUBSIDI
        $this->SUBSIDI->setDbValueDef($rsnew, $this->SUBSIDI->CurrentValue, null, strval($this->SUBSIDI->CurrentValue) == "");

        // EMBALACE
        $this->EMBALACE->setDbValueDef($rsnew, $this->EMBALACE->CurrentValue, null, strval($this->EMBALACE->CurrentValue) == "");

        // PROFESI
        $this->PROFESI->setDbValueDef($rsnew, $this->PROFESI->CurrentValue, null, false);

        // DISCOUNT
        $this->DISCOUNT->setDbValueDef($rsnew, $this->DISCOUNT->CurrentValue, null, strval($this->DISCOUNT->CurrentValue) == "");

        // PAY_METHOD_ID
        $this->PAY_METHOD_ID->setDbValueDef($rsnew, $this->PAY_METHOD_ID->CurrentValue, null, strval($this->PAY_METHOD_ID->CurrentValue) == "");

        // PAYMENT_DATE
        $this->PAYMENT_DATE->setDbValueDef($rsnew, UnFormatDateTime($this->PAYMENT_DATE->CurrentValue, 0), null, false);

        // ISLUNAS
        $this->ISLUNAS->setDbValueDef($rsnew, $this->ISLUNAS->CurrentValue, null, strval($this->ISLUNAS->CurrentValue) == "");

        // DUEDATE_ANGSURAN
        $this->DUEDATE_ANGSURAN->setDbValueDef($rsnew, UnFormatDateTime($this->DUEDATE_ANGSURAN->CurrentValue, 0), null, false);

        // DESCRIPTION
        $this->DESCRIPTION->setDbValueDef($rsnew, $this->DESCRIPTION->CurrentValue, null, false);

        // KUITANSI_ID
        $this->KUITANSI_ID->setDbValueDef($rsnew, $this->KUITANSI_ID->CurrentValue, null, false);

        // NOTA_NO
        $this->NOTA_NO->setDbValueDef($rsnew, $this->NOTA_NO->CurrentValue, null, false);

        // ISCETAK
        $this->ISCETAK->setDbValueDef($rsnew, $this->ISCETAK->CurrentValue, null, strval($this->ISCETAK->CurrentValue) == "");

        // PRINT_DATE
        $this->PRINT_DATE->setDbValueDef($rsnew, UnFormatDateTime($this->PRINT_DATE->CurrentValue, 0), null, false);

        // RESEP_NO
        $this->RESEP_NO->setDbValueDef($rsnew, $this->RESEP_NO->CurrentValue, null, false);

        // RESEP_KE
        $this->RESEP_KE->setDbValueDef($rsnew, $this->RESEP_KE->CurrentValue, null, false);

        // DOSE
        $this->DOSE->setDbValueDef($rsnew, $this->DOSE->CurrentValue, null, false);

        // ORIG_DOSE
        $this->ORIG_DOSE->setDbValueDef($rsnew, $this->ORIG_DOSE->CurrentValue, null, false);

        // DOSE_PRESC
        $this->DOSE_PRESC->setDbValueDef($rsnew, $this->DOSE_PRESC->CurrentValue, null, false);

        // ITER
        $this->ITER->setDbValueDef($rsnew, $this->ITER->CurrentValue, null, strval($this->ITER->CurrentValue) == "");

        // ITER_KE
        $this->ITER_KE->setDbValueDef($rsnew, $this->ITER_KE->CurrentValue, null, strval($this->ITER_KE->CurrentValue) == "");

        // SOLD_STATUS
        $this->SOLD_STATUS->setDbValueDef($rsnew, $this->SOLD_STATUS->CurrentValue, null, strval($this->SOLD_STATUS->CurrentValue) == "");

        // RACIKAN
        $this->RACIKAN->setDbValueDef($rsnew, $this->RACIKAN->CurrentValue, null, strval($this->RACIKAN->CurrentValue) == "");

        // CLASS_ROOM_ID
        $this->CLASS_ROOM_ID->setDbValueDef($rsnew, $this->CLASS_ROOM_ID->CurrentValue, null, false);

        // KELUAR_ID
        $this->KELUAR_ID->setDbValueDef($rsnew, $this->KELUAR_ID->CurrentValue, null, false);

        // BED_ID
        $this->BED_ID->setDbValueDef($rsnew, $this->BED_ID->CurrentValue, null, false);

        // PERDA_ID
        $this->PERDA_ID->setDbValueDef($rsnew, $this->PERDA_ID->CurrentValue, null, false);

        // EMPLOYEE_ID
        $this->EMPLOYEE_ID->setDbValueDef($rsnew, $this->EMPLOYEE_ID->CurrentValue, null, false);

        // DESCRIPTION2
        $this->DESCRIPTION2->setDbValueDef($rsnew, $this->DESCRIPTION2->CurrentValue, null, false);

        // MODIFIED_BY
        $this->MODIFIED_BY->setDbValueDef($rsnew, $this->MODIFIED_BY->CurrentValue, null, false);

        // MODIFIED_DATE
        $this->MODIFIED_DATE->setDbValueDef($rsnew, UnFormatDateTime($this->MODIFIED_DATE->CurrentValue, 0), null, strval($this->MODIFIED_DATE->CurrentValue) == "");

        // MODIFIED_FROM
        $this->MODIFIED_FROM->setDbValueDef($rsnew, $this->MODIFIED_FROM->CurrentValue, null, false);

        // BRAND_ID
        $this->BRAND_ID->setDbValueDef($rsnew, $this->BRAND_ID->CurrentValue, null, false);

        // DOCTOR
        $this->DOCTOR->setDbValueDef($rsnew, $this->DOCTOR->CurrentValue, null, false);

        // JML_BKS
        $this->JML_BKS->setDbValueDef($rsnew, $this->JML_BKS->CurrentValue, null, strval($this->JML_BKS->CurrentValue) == "");

        // EXIT_DATE
        $this->EXIT_DATE->setDbValueDef($rsnew, UnFormatDateTime($this->EXIT_DATE->CurrentValue, 0), null, false);

        // FA_V
        $this->FA_V->setDbValueDef($rsnew, $this->FA_V->CurrentValue, null, false);

        // TASK_ID
        $this->TASK_ID->setDbValueDef($rsnew, $this->TASK_ID->CurrentValue, null, strval($this->TASK_ID->CurrentValue) == "");

        // EMPLOYEE_ID_FROM
        $this->EMPLOYEE_ID_FROM->setDbValueDef($rsnew, $this->EMPLOYEE_ID_FROM->CurrentValue, null, false);

        // DOCTOR_FROM
        $this->DOCTOR_FROM->setDbValueDef($rsnew, $this->DOCTOR_FROM->CurrentValue, null, false);

        // status_pasien_id
        $this->status_pasien_id->setDbValueDef($rsnew, $this->status_pasien_id->CurrentValue, null, strval($this->status_pasien_id->CurrentValue) == "");

        // amount_paid
        $this->amount_paid->setDbValueDef($rsnew, $this->amount_paid->CurrentValue, null, strval($this->amount_paid->CurrentValue) == "");

        // THENAME
        $this->THENAME->setDbValueDef($rsnew, $this->THENAME->CurrentValue, null, false);

        // THEADDRESS
        $this->THEADDRESS->setDbValueDef($rsnew, $this->THEADDRESS->CurrentValue, null, false);

        // THEID
        $this->THEID->setDbValueDef($rsnew, $this->THEID->CurrentValue, null, false);

        // serial_nb
        $this->serial_nb->setDbValueDef($rsnew, $this->serial_nb->CurrentValue, null, false);

        // TREATMENT_PLAFOND
        $this->TREATMENT_PLAFOND->setDbValueDef($rsnew, $this->TREATMENT_PLAFOND->CurrentValue, null, false);

        // AMOUNT_PLAFOND
        $this->AMOUNT_PLAFOND->setDbValueDef($rsnew, $this->AMOUNT_PLAFOND->CurrentValue, null, strval($this->AMOUNT_PLAFOND->CurrentValue) == "");

        // AMOUNT_PAID_PLAFOND
        $this->AMOUNT_PAID_PLAFOND->setDbValueDef($rsnew, $this->AMOUNT_PAID_PLAFOND->CurrentValue, null, strval($this->AMOUNT_PAID_PLAFOND->CurrentValue) == "");

        // CLASS_ID_PLAFOND
        $this->CLASS_ID_PLAFOND->setDbValueDef($rsnew, $this->CLASS_ID_PLAFOND->CurrentValue, null, strval($this->CLASS_ID_PLAFOND->CurrentValue) == "");

        // PAYOR_ID
        $this->PAYOR_ID->setDbValueDef($rsnew, $this->PAYOR_ID->CurrentValue, null, strval($this->PAYOR_ID->CurrentValue) == "");

        // PEMBULATAN
        $this->PEMBULATAN->setDbValueDef($rsnew, $this->PEMBULATAN->CurrentValue, null, strval($this->PEMBULATAN->CurrentValue) == "");

        // ISRJ
        $this->ISRJ->setDbValueDef($rsnew, $this->ISRJ->CurrentValue, null, strval($this->ISRJ->CurrentValue) == "");

        // AGEYEAR
        $this->AGEYEAR->setDbValueDef($rsnew, $this->AGEYEAR->CurrentValue, null, false);

        // AGEMONTH
        $this->AGEMONTH->setDbValueDef($rsnew, $this->AGEMONTH->CurrentValue, null, false);

        // AGEDAY
        $this->AGEDAY->setDbValueDef($rsnew, $this->AGEDAY->CurrentValue, null, false);

        // GENDER
        $this->GENDER->setDbValueDef($rsnew, $this->GENDER->CurrentValue, null, false);

        // KAL_ID
        $this->KAL_ID->setDbValueDef($rsnew, $this->KAL_ID->CurrentValue, null, false);

        // CORRECTION_ID
        $this->CORRECTION_ID->setDbValueDef($rsnew, $this->CORRECTION_ID->CurrentValue, null, false);

        // CORRECTION_BY
        $this->CORRECTION_BY->setDbValueDef($rsnew, $this->CORRECTION_BY->CurrentValue, null, false);

        // KARYAWAN
        $this->KARYAWAN->setDbValueDef($rsnew, $this->KARYAWAN->CurrentValue, null, false);

        // ACCOUNT_ID
        $this->ACCOUNT_ID->setDbValueDef($rsnew, $this->ACCOUNT_ID->CurrentValue, null, false);

        // sell_price
        $this->sell_price->setDbValueDef($rsnew, $this->sell_price->CurrentValue, null, false);

        // diskon
        $this->diskon->setDbValueDef($rsnew, $this->diskon->CurrentValue, null, false);

        // INVOICE_ID
        $this->INVOICE_ID->setDbValueDef($rsnew, $this->INVOICE_ID->CurrentValue, null, false);

        // NUMER
        $this->NUMER->setDbValueDef($rsnew, $this->NUMER->CurrentValue, null, false);

        // MEASURE_ID2
        $this->MEASURE_ID2->setDbValueDef($rsnew, $this->MEASURE_ID2->CurrentValue, null, false);

        // POTONGAN
        $this->POTONGAN->setDbValueDef($rsnew, $this->POTONGAN->CurrentValue, null, false);

        // BAYAR
        $this->BAYAR->setDbValueDef($rsnew, $this->BAYAR->CurrentValue, null, false);

        // RETUR
        $this->RETUR->setDbValueDef($rsnew, $this->RETUR->CurrentValue, null, false);

        // TARIF_TYPE
        $this->TARIF_TYPE->setDbValueDef($rsnew, $this->TARIF_TYPE->CurrentValue, null, false);

        // PPNVALUE
        $this->PPNVALUE->setDbValueDef($rsnew, $this->PPNVALUE->CurrentValue, null, false);

        // TAGIHAN
        $this->TAGIHAN->setDbValueDef($rsnew, $this->TAGIHAN->CurrentValue, null, false);

        // KOREKSI
        $this->KOREKSI->setDbValueDef($rsnew, $this->KOREKSI->CurrentValue, null, false);

        // STATUS_OBAT
        $this->STATUS_OBAT->setDbValueDef($rsnew, $this->STATUS_OBAT->CurrentValue, null, false);

        // SUBSIDISAT
        $this->SUBSIDISAT->setDbValueDef($rsnew, $this->SUBSIDISAT->CurrentValue, null, false);

        // PRINTQ
        $this->PRINTQ->setDbValueDef($rsnew, $this->PRINTQ->CurrentValue, null, false);

        // PRINTED_BY
        $this->PRINTED_BY->setDbValueDef($rsnew, $this->PRINTED_BY->CurrentValue, null, false);

        // STOCK_AVAILABLE
        $this->STOCK_AVAILABLE->setDbValueDef($rsnew, $this->STOCK_AVAILABLE->CurrentValue, null, false);

        // STATUS_TARIF
        $this->STATUS_TARIF->setDbValueDef($rsnew, $this->STATUS_TARIF->CurrentValue, null, false);

        // CLINIC_TYPE
        $this->CLINIC_TYPE->setDbValueDef($rsnew, $this->CLINIC_TYPE->CurrentValue, null, false);

        // PACKAGE_ID
        $this->PACKAGE_ID->setDbValueDef($rsnew, $this->PACKAGE_ID->CurrentValue, null, false);

        // MODULE_ID
        $this->MODULE_ID->setDbValueDef($rsnew, $this->MODULE_ID->CurrentValue, null, false);

        // profession
        $this->profession->setDbValueDef($rsnew, $this->profession->CurrentValue, null, false);

        // THEORDER
        $this->THEORDER->setDbValueDef($rsnew, $this->THEORDER->CurrentValue, null, false);

        // CASHIER
        $this->CASHIER->setDbValueDef($rsnew, $this->CASHIER->CurrentValue, null, false);

        // SPPFEE
        $this->SPPFEE->setDbValueDef($rsnew, $this->SPPFEE->CurrentValue, null, false);

        // SPPBILL
        $this->SPPBILL->setDbValueDef($rsnew, $this->SPPBILL->CurrentValue, null, false);

        // SPPRJK
        $this->SPPRJK->setDbValueDef($rsnew, $this->SPPRJK->CurrentValue, null, false);

        // SPPJMN
        $this->SPPJMN->setDbValueDef($rsnew, $this->SPPJMN->CurrentValue, null, false);

        // SPPKASIR
        $this->SPPKASIR->setDbValueDef($rsnew, $this->SPPKASIR->CurrentValue, null, false);

        // PERUJUK
        $this->PERUJUK->setDbValueDef($rsnew, $this->PERUJUK->CurrentValue, null, false);

        // PERUJUKFEE
        $this->PERUJUKFEE->setDbValueDef($rsnew, $this->PERUJUKFEE->CurrentValue, null, false);

        // modified_datesys
        $this->modified_datesys->setDbValueDef($rsnew, UnFormatDateTime($this->modified_datesys->CurrentValue, 0), null, strval($this->modified_datesys->CurrentValue) == "");

        // TRANS_ID
        $this->TRANS_ID->setDbValueDef($rsnew, $this->TRANS_ID->CurrentValue, null, false);

        // SPPBILLDATE
        $this->SPPBILLDATE->setDbValueDef($rsnew, UnFormatDateTime($this->SPPBILLDATE->CurrentValue, 0), null, false);

        // SPPBILLUSER
        $this->SPPBILLUSER->setDbValueDef($rsnew, $this->SPPBILLUSER->CurrentValue, null, false);

        // SPPKASIRDATE
        $this->SPPKASIRDATE->setDbValueDef($rsnew, UnFormatDateTime($this->SPPKASIRDATE->CurrentValue, 0), null, false);

        // SPPKASIRUSER
        $this->SPPKASIRUSER->setDbValueDef($rsnew, $this->SPPKASIRUSER->CurrentValue, null, false);

        // SPPPOLI
        $this->SPPPOLI->setDbValueDef($rsnew, $this->SPPPOLI->CurrentValue, null, false);

        // SPPPOLIUSER
        $this->SPPPOLIUSER->setDbValueDef($rsnew, $this->SPPPOLIUSER->CurrentValue, null, false);

        // SPPPOLIDATE
        $this->SPPPOLIDATE->setDbValueDef($rsnew, UnFormatDateTime($this->SPPPOLIDATE->CurrentValue, 0), null, false);

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

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("TreatmentBayarList"), "", $this->TableVar, true);
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
