<?php

namespace PHPMaker2021\SIMRSFARMASI;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class TreatmentBillSearch extends TreatmentBill
{
    use MessagesTrait;

    // Page ID
    public $PageID = "search";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'TREATMENT_BILL';

    // Page object name
    public $PageObjName = "TreatmentBillSearch";

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

        // Table object (TREATMENT_BILL)
        if (!isset($GLOBALS["TREATMENT_BILL"]) || get_class($GLOBALS["TREATMENT_BILL"]) == PROJECT_NAMESPACE . "TREATMENT_BILL") {
            $GLOBALS["TREATMENT_BILL"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

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

            // Handle modal response
            if ($this->IsModal) { // Show as modal
                $row = ["url" => GetUrl($url), "modal" => "1"];
                $pageName = GetPageName($url);
                if ($pageName != $this->getListUrl()) { // Not List page
                    $row["caption"] = $this->getModalCaption($pageName);
                    if ($pageName == "TreatmentBillView") {
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
    public $FormClassName = "ew-horizontal ew-form ew-search-form";
    public $IsModal = false;
    public $IsMobileOrModal = false;

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
        $this->nota_temp->setVisibility();
        $this->CLINIC_ID_TEMP->setVisibility();
        $this->NOSEP->setVisibility();
        $this->ID->setVisibility();
        $this->IDXDAFTAR->setVisibility();
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
        $this->setupLookupOptions($this->NO_REGISTRATION);
        $this->setupLookupOptions($this->TARIF_ID);
        $this->setupLookupOptions($this->CLINIC_ID);
        $this->setupLookupOptions($this->EMPLOYEE_ID);

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Check modal
        if ($this->IsModal) {
            $SkipHeaderFooter = true;
        }
        $this->IsMobileOrModal = IsMobile() || $this->IsModal;
        if ($this->isPageRequest()) {
            // Get action
            $this->CurrentAction = Post("action");
            if ($this->isSearch()) {
                // Build search string for advanced search, remove blank field
                $this->loadSearchValues(); // Get search values
                if ($this->validateSearch()) {
                    $srchStr = $this->buildAdvancedSearch();
                } else {
                    $srchStr = "";
                }
                if ($srchStr != "") {
                    $srchStr = $this->getUrlParm($srchStr);
                    $srchStr = "TreatmentBillList" . "?" . $srchStr;
                    $this->terminate($srchStr); // Go to list page
                    return;
                }
            }
        }

        // Restore search settings from Session
        if (!$this->hasInvalidFields()) {
            $this->loadAdvancedSearch();
        }

        // Render row for search
        $this->RowType = ROWTYPE_SEARCH;
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

    // Build advanced search
    protected function buildAdvancedSearch()
    {
        $srchUrl = "";
        $this->buildSearchUrl($srchUrl, $this->ORG_UNIT_CODE); // ORG_UNIT_CODE
        $this->buildSearchUrl($srchUrl, $this->BILL_ID); // BILL_ID
        $this->buildSearchUrl($srchUrl, $this->NO_REGISTRATION); // NO_REGISTRATION
        $this->buildSearchUrl($srchUrl, $this->VISIT_ID); // VISIT_ID
        $this->buildSearchUrl($srchUrl, $this->TARIF_ID); // TARIF_ID
        $this->buildSearchUrl($srchUrl, $this->CLASS_ID); // CLASS_ID
        $this->buildSearchUrl($srchUrl, $this->CLINIC_ID); // CLINIC_ID
        $this->buildSearchUrl($srchUrl, $this->CLINIC_ID_FROM); // CLINIC_ID_FROM
        $this->buildSearchUrl($srchUrl, $this->TREATMENT); // TREATMENT
        $this->buildSearchUrl($srchUrl, $this->TREAT_DATE); // TREAT_DATE
        $this->buildSearchUrl($srchUrl, $this->AMOUNT); // AMOUNT
        $this->buildSearchUrl($srchUrl, $this->QUANTITY); // QUANTITY
        $this->buildSearchUrl($srchUrl, $this->MEASURE_ID); // MEASURE_ID
        $this->buildSearchUrl($srchUrl, $this->POKOK_JUAL); // POKOK_JUAL
        $this->buildSearchUrl($srchUrl, $this->PPN); // PPN
        $this->buildSearchUrl($srchUrl, $this->MARGIN); // MARGIN
        $this->buildSearchUrl($srchUrl, $this->SUBSIDI); // SUBSIDI
        $this->buildSearchUrl($srchUrl, $this->EMBALACE); // EMBALACE
        $this->buildSearchUrl($srchUrl, $this->PROFESI); // PROFESI
        $this->buildSearchUrl($srchUrl, $this->DISCOUNT); // DISCOUNT
        $this->buildSearchUrl($srchUrl, $this->PAY_METHOD_ID); // PAY_METHOD_ID
        $this->buildSearchUrl($srchUrl, $this->PAYMENT_DATE); // PAYMENT_DATE
        $this->buildSearchUrl($srchUrl, $this->ISLUNAS); // ISLUNAS
        $this->buildSearchUrl($srchUrl, $this->DUEDATE_ANGSURAN); // DUEDATE_ANGSURAN
        $this->buildSearchUrl($srchUrl, $this->DESCRIPTION); // DESCRIPTION
        $this->buildSearchUrl($srchUrl, $this->KUITANSI_ID); // KUITANSI_ID
        $this->buildSearchUrl($srchUrl, $this->NOTA_NO); // NOTA_NO
        $this->buildSearchUrl($srchUrl, $this->ISCETAK); // ISCETAK
        $this->buildSearchUrl($srchUrl, $this->PRINT_DATE); // PRINT_DATE
        $this->buildSearchUrl($srchUrl, $this->RESEP_NO); // RESEP_NO
        $this->buildSearchUrl($srchUrl, $this->RESEP_KE); // RESEP_KE
        $this->buildSearchUrl($srchUrl, $this->DOSE); // DOSE
        $this->buildSearchUrl($srchUrl, $this->ORIG_DOSE); // ORIG_DOSE
        $this->buildSearchUrl($srchUrl, $this->DOSE_PRESC); // DOSE_PRESC
        $this->buildSearchUrl($srchUrl, $this->ITER); // ITER
        $this->buildSearchUrl($srchUrl, $this->ITER_KE); // ITER_KE
        $this->buildSearchUrl($srchUrl, $this->SOLD_STATUS); // SOLD_STATUS
        $this->buildSearchUrl($srchUrl, $this->RACIKAN); // RACIKAN
        $this->buildSearchUrl($srchUrl, $this->CLASS_ROOM_ID); // CLASS_ROOM_ID
        $this->buildSearchUrl($srchUrl, $this->KELUAR_ID); // KELUAR_ID
        $this->buildSearchUrl($srchUrl, $this->BED_ID); // BED_ID
        $this->buildSearchUrl($srchUrl, $this->PERDA_ID); // PERDA_ID
        $this->buildSearchUrl($srchUrl, $this->EMPLOYEE_ID); // EMPLOYEE_ID
        $this->buildSearchUrl($srchUrl, $this->DESCRIPTION2); // DESCRIPTION2
        $this->buildSearchUrl($srchUrl, $this->MODIFIED_BY); // MODIFIED_BY
        $this->buildSearchUrl($srchUrl, $this->MODIFIED_DATE); // MODIFIED_DATE
        $this->buildSearchUrl($srchUrl, $this->MODIFIED_FROM); // MODIFIED_FROM
        $this->buildSearchUrl($srchUrl, $this->BRAND_ID); // BRAND_ID
        $this->buildSearchUrl($srchUrl, $this->DOCTOR); // DOCTOR
        $this->buildSearchUrl($srchUrl, $this->JML_BKS); // JML_BKS
        $this->buildSearchUrl($srchUrl, $this->EXIT_DATE); // EXIT_DATE
        $this->buildSearchUrl($srchUrl, $this->FA_V); // FA_V
        $this->buildSearchUrl($srchUrl, $this->TASK_ID); // TASK_ID
        $this->buildSearchUrl($srchUrl, $this->EMPLOYEE_ID_FROM); // EMPLOYEE_ID_FROM
        $this->buildSearchUrl($srchUrl, $this->DOCTOR_FROM); // DOCTOR_FROM
        $this->buildSearchUrl($srchUrl, $this->status_pasien_id); // status_pasien_id
        $this->buildSearchUrl($srchUrl, $this->amount_paid); // amount_paid
        $this->buildSearchUrl($srchUrl, $this->THENAME); // THENAME
        $this->buildSearchUrl($srchUrl, $this->THEADDRESS); // THEADDRESS
        $this->buildSearchUrl($srchUrl, $this->THEID); // THEID
        $this->buildSearchUrl($srchUrl, $this->serial_nb); // serial_nb
        $this->buildSearchUrl($srchUrl, $this->TREATMENT_PLAFOND); // TREATMENT_PLAFOND
        $this->buildSearchUrl($srchUrl, $this->AMOUNT_PLAFOND); // AMOUNT_PLAFOND
        $this->buildSearchUrl($srchUrl, $this->AMOUNT_PAID_PLAFOND); // AMOUNT_PAID_PLAFOND
        $this->buildSearchUrl($srchUrl, $this->CLASS_ID_PLAFOND); // CLASS_ID_PLAFOND
        $this->buildSearchUrl($srchUrl, $this->PAYOR_ID); // PAYOR_ID
        $this->buildSearchUrl($srchUrl, $this->PEMBULATAN); // PEMBULATAN
        $this->buildSearchUrl($srchUrl, $this->ISRJ); // ISRJ
        $this->buildSearchUrl($srchUrl, $this->AGEYEAR); // AGEYEAR
        $this->buildSearchUrl($srchUrl, $this->AGEMONTH); // AGEMONTH
        $this->buildSearchUrl($srchUrl, $this->AGEDAY); // AGEDAY
        $this->buildSearchUrl($srchUrl, $this->GENDER); // GENDER
        $this->buildSearchUrl($srchUrl, $this->KAL_ID); // KAL_ID
        $this->buildSearchUrl($srchUrl, $this->CORRECTION_ID); // CORRECTION_ID
        $this->buildSearchUrl($srchUrl, $this->CORRECTION_BY); // CORRECTION_BY
        $this->buildSearchUrl($srchUrl, $this->KARYAWAN); // KARYAWAN
        $this->buildSearchUrl($srchUrl, $this->ACCOUNT_ID); // ACCOUNT_ID
        $this->buildSearchUrl($srchUrl, $this->sell_price); // sell_price
        $this->buildSearchUrl($srchUrl, $this->diskon); // diskon
        $this->buildSearchUrl($srchUrl, $this->INVOICE_ID); // INVOICE_ID
        $this->buildSearchUrl($srchUrl, $this->NUMER); // NUMER
        $this->buildSearchUrl($srchUrl, $this->MEASURE_ID2); // MEASURE_ID2
        $this->buildSearchUrl($srchUrl, $this->POTONGAN); // POTONGAN
        $this->buildSearchUrl($srchUrl, $this->BAYAR); // BAYAR
        $this->buildSearchUrl($srchUrl, $this->RETUR); // RETUR
        $this->buildSearchUrl($srchUrl, $this->TARIF_TYPE); // TARIF_TYPE
        $this->buildSearchUrl($srchUrl, $this->PPNVALUE); // PPNVALUE
        $this->buildSearchUrl($srchUrl, $this->TAGIHAN); // TAGIHAN
        $this->buildSearchUrl($srchUrl, $this->KOREKSI); // KOREKSI
        $this->buildSearchUrl($srchUrl, $this->STATUS_OBAT); // STATUS_OBAT
        $this->buildSearchUrl($srchUrl, $this->SUBSIDISAT); // SUBSIDISAT
        $this->buildSearchUrl($srchUrl, $this->PRINTQ); // PRINTQ
        $this->buildSearchUrl($srchUrl, $this->PRINTED_BY); // PRINTED_BY
        $this->buildSearchUrl($srchUrl, $this->STOCK_AVAILABLE); // STOCK_AVAILABLE
        $this->buildSearchUrl($srchUrl, $this->STATUS_TARIF); // STATUS_TARIF
        $this->buildSearchUrl($srchUrl, $this->CLINIC_TYPE); // CLINIC_TYPE
        $this->buildSearchUrl($srchUrl, $this->PACKAGE_ID); // PACKAGE_ID
        $this->buildSearchUrl($srchUrl, $this->MODULE_ID); // MODULE_ID
        $this->buildSearchUrl($srchUrl, $this->profession); // profession
        $this->buildSearchUrl($srchUrl, $this->THEORDER); // THEORDER
        $this->buildSearchUrl($srchUrl, $this->CASHIER); // CASHIER
        $this->buildSearchUrl($srchUrl, $this->SPPFEE); // SPPFEE
        $this->buildSearchUrl($srchUrl, $this->SPPBILL); // SPPBILL
        $this->buildSearchUrl($srchUrl, $this->SPPRJK); // SPPRJK
        $this->buildSearchUrl($srchUrl, $this->SPPJMN); // SPPJMN
        $this->buildSearchUrl($srchUrl, $this->SPPKASIR); // SPPKASIR
        $this->buildSearchUrl($srchUrl, $this->PERUJUK); // PERUJUK
        $this->buildSearchUrl($srchUrl, $this->PERUJUKFEE); // PERUJUKFEE
        $this->buildSearchUrl($srchUrl, $this->modified_datesys); // modified_datesys
        $this->buildSearchUrl($srchUrl, $this->TRANS_ID); // TRANS_ID
        $this->buildSearchUrl($srchUrl, $this->SPPBILLDATE); // SPPBILLDATE
        $this->buildSearchUrl($srchUrl, $this->SPPBILLUSER); // SPPBILLUSER
        $this->buildSearchUrl($srchUrl, $this->SPPKASIRDATE); // SPPKASIRDATE
        $this->buildSearchUrl($srchUrl, $this->SPPKASIRUSER); // SPPKASIRUSER
        $this->buildSearchUrl($srchUrl, $this->SPPPOLI); // SPPPOLI
        $this->buildSearchUrl($srchUrl, $this->SPPPOLIUSER); // SPPPOLIUSER
        $this->buildSearchUrl($srchUrl, $this->SPPPOLIDATE); // SPPPOLIDATE
        $this->buildSearchUrl($srchUrl, $this->nota_temp); // nota_temp
        $this->buildSearchUrl($srchUrl, $this->CLINIC_ID_TEMP); // CLINIC_ID_TEMP
        $this->buildSearchUrl($srchUrl, $this->NOSEP); // NOSEP
        $this->buildSearchUrl($srchUrl, $this->ID); // ID
        $this->buildSearchUrl($srchUrl, $this->IDXDAFTAR); // IDXDAFTAR
        if ($srchUrl != "") {
            $srchUrl .= "&";
        }
        $srchUrl .= "cmd=search";
        return $srchUrl;
    }

    // Build search URL
    protected function buildSearchUrl(&$url, &$fld, $oprOnly = false)
    {
        global $CurrentForm;
        $wrk = "";
        $fldParm = $fld->Param;
        $fldVal = $CurrentForm->getValue("x_$fldParm");
        $fldOpr = $CurrentForm->getValue("z_$fldParm");
        $fldCond = $CurrentForm->getValue("v_$fldParm");
        $fldVal2 = $CurrentForm->getValue("y_$fldParm");
        $fldOpr2 = $CurrentForm->getValue("w_$fldParm");
        if (is_array($fldVal)) {
            $fldVal = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $fldVal);
        }
        if (is_array($fldVal2)) {
            $fldVal2 = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $fldVal2);
        }
        $fldOpr = strtoupper(trim($fldOpr));
        $fldDataType = ($fld->IsVirtual) ? DATATYPE_STRING : $fld->DataType;
        if ($fldOpr == "BETWEEN") {
            $isValidValue = ($fldDataType != DATATYPE_NUMBER) ||
                ($fldDataType == DATATYPE_NUMBER && $this->searchValueIsNumeric($fld, $fldVal) && $this->searchValueIsNumeric($fld, $fldVal2));
            if ($fldVal != "" && $fldVal2 != "" && $isValidValue) {
                $wrk = "x_" . $fldParm . "=" . urlencode($fldVal) .
                    "&y_" . $fldParm . "=" . urlencode($fldVal2) .
                    "&z_" . $fldParm . "=" . urlencode($fldOpr);
            }
        } else {
            $isValidValue = ($fldDataType != DATATYPE_NUMBER) ||
                ($fldDataType == DATATYPE_NUMBER && $this->searchValueIsNumeric($fld, $fldVal));
            if ($fldVal != "" && $isValidValue && IsValidOperator($fldOpr, $fldDataType)) {
                $wrk = "x_" . $fldParm . "=" . urlencode($fldVal) .
                    "&z_" . $fldParm . "=" . urlencode($fldOpr);
            } elseif ($fldOpr == "IS NULL" || $fldOpr == "IS NOT NULL" || ($fldOpr != "" && $oprOnly && IsValidOperator($fldOpr, $fldDataType))) {
                $wrk = "z_" . $fldParm . "=" . urlencode($fldOpr);
            }
            $isValidValue = ($fldDataType != DATATYPE_NUMBER) ||
                ($fldDataType == DATATYPE_NUMBER && $this->searchValueIsNumeric($fld, $fldVal2));
            if ($fldVal2 != "" && $isValidValue && IsValidOperator($fldOpr2, $fldDataType)) {
                if ($wrk != "") {
                    $wrk .= "&v_" . $fldParm . "=" . urlencode($fldCond) . "&";
                }
                $wrk .= "y_" . $fldParm . "=" . urlencode($fldVal2) .
                    "&w_" . $fldParm . "=" . urlencode($fldOpr2);
            } elseif ($fldOpr2 == "IS NULL" || $fldOpr2 == "IS NOT NULL" || ($fldOpr2 != "" && $oprOnly && IsValidOperator($fldOpr2, $fldDataType))) {
                if ($wrk != "") {
                    $wrk .= "&v_" . $fldParm . "=" . urlencode($fldCond) . "&";
                }
                $wrk .= "w_" . $fldParm . "=" . urlencode($fldOpr2);
            }
        }
        if ($wrk != "") {
            if ($url != "") {
                $url .= "&";
            }
            $url .= $wrk;
        }
    }

    // Check if search value is numeric
    protected function searchValueIsNumeric($fld, $value)
    {
        if (IsFloatFormat($fld->Type)) {
            $value = ConvertToFloatString($value);
        }
        return is_numeric($value);
    }

    // Load search values for validation
    protected function loadSearchValues()
    {
        // Load search values
        $hasValue = false;
        if ($this->ORG_UNIT_CODE->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->BILL_ID->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->NO_REGISTRATION->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->VISIT_ID->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->TARIF_ID->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->CLASS_ID->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->CLINIC_ID->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->CLINIC_ID_FROM->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->TREATMENT->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->TREAT_DATE->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->AMOUNT->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->QUANTITY->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->MEASURE_ID->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->POKOK_JUAL->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->PPN->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->MARGIN->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->SUBSIDI->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->EMBALACE->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->PROFESI->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->DISCOUNT->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->PAY_METHOD_ID->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->PAYMENT_DATE->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->ISLUNAS->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->DUEDATE_ANGSURAN->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->DESCRIPTION->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->KUITANSI_ID->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->NOTA_NO->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->ISCETAK->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->PRINT_DATE->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->RESEP_NO->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->RESEP_KE->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->DOSE->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->ORIG_DOSE->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->DOSE_PRESC->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->ITER->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->ITER_KE->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->SOLD_STATUS->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->RACIKAN->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->CLASS_ROOM_ID->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->KELUAR_ID->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->BED_ID->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->PERDA_ID->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->EMPLOYEE_ID->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->DESCRIPTION2->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->MODIFIED_BY->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->MODIFIED_DATE->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->MODIFIED_FROM->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->BRAND_ID->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->DOCTOR->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->JML_BKS->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->EXIT_DATE->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->FA_V->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->TASK_ID->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->EMPLOYEE_ID_FROM->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->DOCTOR_FROM->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->status_pasien_id->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->amount_paid->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->THENAME->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->THEADDRESS->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->THEID->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->serial_nb->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->TREATMENT_PLAFOND->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->AMOUNT_PLAFOND->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->AMOUNT_PAID_PLAFOND->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->CLASS_ID_PLAFOND->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->PAYOR_ID->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->PEMBULATAN->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->ISRJ->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->AGEYEAR->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->AGEMONTH->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->AGEDAY->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->GENDER->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->KAL_ID->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->CORRECTION_ID->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->CORRECTION_BY->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->KARYAWAN->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->ACCOUNT_ID->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->sell_price->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->diskon->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->INVOICE_ID->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->NUMER->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->MEASURE_ID2->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->POTONGAN->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->BAYAR->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->RETUR->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->TARIF_TYPE->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->PPNVALUE->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->TAGIHAN->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->KOREKSI->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->STATUS_OBAT->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->SUBSIDISAT->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->PRINTQ->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->PRINTED_BY->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->STOCK_AVAILABLE->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->STATUS_TARIF->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->CLINIC_TYPE->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->PACKAGE_ID->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->MODULE_ID->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->profession->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->THEORDER->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->CASHIER->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->SPPFEE->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->SPPBILL->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->SPPRJK->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->SPPJMN->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->SPPKASIR->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->PERUJUK->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->PERUJUKFEE->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->modified_datesys->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->TRANS_ID->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->SPPBILLDATE->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->SPPBILLUSER->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->SPPKASIRDATE->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->SPPKASIRUSER->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->SPPPOLI->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->SPPPOLIUSER->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->SPPPOLIDATE->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->nota_temp->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->CLINIC_ID_TEMP->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->NOSEP->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->ID->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->IDXDAFTAR->AdvancedSearch->post()) {
            $hasValue = true;
        }
        return $hasValue;
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

        // nota_temp

        // CLINIC_ID_TEMP

        // NOSEP

        // ID

        // IDXDAFTAR
        if ($this->RowType == ROWTYPE_VIEW) {
            // ORG_UNIT_CODE
            $this->ORG_UNIT_CODE->ViewValue = $this->ORG_UNIT_CODE->CurrentValue;
            $this->ORG_UNIT_CODE->ViewCustomAttributes = 'hidden';

            // BILL_ID
            $this->BILL_ID->ViewValue = $this->BILL_ID->CurrentValue;
            $this->BILL_ID->ViewCustomAttributes = "";

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
            $this->PAYMENT_DATE->ViewValue = FormatDateTime($this->PAYMENT_DATE->ViewValue, 11);
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
            $this->BAYAR->ViewValue = FormatNumber($this->BAYAR->ViewValue, 0, -2, -2, -2);
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

            // IDXDAFTAR
            $this->IDXDAFTAR->ViewValue = $this->IDXDAFTAR->CurrentValue;
            $this->IDXDAFTAR->ViewValue = FormatNumber($this->IDXDAFTAR->ViewValue, 0, -2, -2, -2);
            $this->IDXDAFTAR->ViewCustomAttributes = "";

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

            // nota_temp
            $this->nota_temp->LinkCustomAttributes = "";
            $this->nota_temp->HrefValue = "";
            $this->nota_temp->TooltipValue = "";

            // CLINIC_ID_TEMP
            $this->CLINIC_ID_TEMP->LinkCustomAttributes = "";
            $this->CLINIC_ID_TEMP->HrefValue = "";
            $this->CLINIC_ID_TEMP->TooltipValue = "";

            // NOSEP
            $this->NOSEP->LinkCustomAttributes = "";
            $this->NOSEP->HrefValue = "";
            $this->NOSEP->TooltipValue = "";

            // ID
            $this->ID->LinkCustomAttributes = "";
            $this->ID->HrefValue = "";
            $this->ID->TooltipValue = "";

            // IDXDAFTAR
            $this->IDXDAFTAR->LinkCustomAttributes = "";
            $this->IDXDAFTAR->HrefValue = "";
            $this->IDXDAFTAR->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_SEARCH) {
            // ORG_UNIT_CODE
            $this->ORG_UNIT_CODE->EditAttrs["class"] = "form-control";
            $this->ORG_UNIT_CODE->EditCustomAttributes = 'readonly';
            if (!$this->ORG_UNIT_CODE->Raw) {
                $this->ORG_UNIT_CODE->AdvancedSearch->SearchValue = HtmlDecode($this->ORG_UNIT_CODE->AdvancedSearch->SearchValue);
            }
            $this->ORG_UNIT_CODE->EditValue = HtmlEncode($this->ORG_UNIT_CODE->AdvancedSearch->SearchValue);
            $this->ORG_UNIT_CODE->PlaceHolder = RemoveHtml($this->ORG_UNIT_CODE->caption());

            // BILL_ID
            $this->BILL_ID->EditAttrs["class"] = "form-control";
            $this->BILL_ID->EditCustomAttributes = 'readonly';
            if (!$this->BILL_ID->Raw) {
                $this->BILL_ID->AdvancedSearch->SearchValue = HtmlDecode($this->BILL_ID->AdvancedSearch->SearchValue);
            }
            $this->BILL_ID->EditValue = HtmlEncode($this->BILL_ID->AdvancedSearch->SearchValue);
            $this->BILL_ID->PlaceHolder = RemoveHtml($this->BILL_ID->caption());

            // NO_REGISTRATION
            $this->NO_REGISTRATION->EditCustomAttributes = "";
            $curVal = trim(strval($this->NO_REGISTRATION->AdvancedSearch->SearchValue));
            if ($curVal != "") {
                $this->NO_REGISTRATION->AdvancedSearch->ViewValue = $this->NO_REGISTRATION->lookupCacheOption($curVal);
            } else {
                $this->NO_REGISTRATION->AdvancedSearch->ViewValue = $this->NO_REGISTRATION->Lookup !== null && is_array($this->NO_REGISTRATION->Lookup->Options) ? $curVal : null;
            }
            if ($this->NO_REGISTRATION->AdvancedSearch->ViewValue !== null) { // Load from cache
                $this->NO_REGISTRATION->EditValue = array_values($this->NO_REGISTRATION->Lookup->Options);
                if ($this->NO_REGISTRATION->AdvancedSearch->ViewValue == "") {
                    $this->NO_REGISTRATION->AdvancedSearch->ViewValue = $Language->phrase("PleaseSelect");
                }
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "[NO_REGISTRATION]" . SearchString("=", $this->NO_REGISTRATION->AdvancedSearch->SearchValue, DATATYPE_STRING, "");
                }
                $sqlWrk = $this->NO_REGISTRATION->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->NO_REGISTRATION->Lookup->renderViewRow($rswrk[0]);
                    $this->NO_REGISTRATION->AdvancedSearch->ViewValue = $this->NO_REGISTRATION->displayValue($arwrk);
                } else {
                    $this->NO_REGISTRATION->AdvancedSearch->ViewValue = $Language->phrase("PleaseSelect");
                }
                $arwrk = $rswrk;
                $this->NO_REGISTRATION->EditValue = $arwrk;
            }
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
            $this->TARIF_ID->EditCustomAttributes = "";
            $curVal = trim(strval($this->TARIF_ID->AdvancedSearch->SearchValue));
            if ($curVal != "") {
                $this->TARIF_ID->AdvancedSearch->ViewValue = $this->TARIF_ID->lookupCacheOption($curVal);
            } else {
                $this->TARIF_ID->AdvancedSearch->ViewValue = $this->TARIF_ID->Lookup !== null && is_array($this->TARIF_ID->Lookup->Options) ? $curVal : null;
            }
            if ($this->TARIF_ID->AdvancedSearch->ViewValue !== null) { // Load from cache
                $this->TARIF_ID->EditValue = array_values($this->TARIF_ID->Lookup->Options);
                if ($this->TARIF_ID->AdvancedSearch->ViewValue == "") {
                    $this->TARIF_ID->AdvancedSearch->ViewValue = $Language->phrase("PleaseSelect");
                }
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "[TARIF_ID]" . SearchString("=", $this->TARIF_ID->AdvancedSearch->SearchValue, DATATYPE_STRING, "");
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
                    $this->TARIF_ID->AdvancedSearch->ViewValue = $this->TARIF_ID->displayValue($arwrk);
                } else {
                    $this->TARIF_ID->AdvancedSearch->ViewValue = $Language->phrase("PleaseSelect");
                }
                $arwrk = $rswrk;
                foreach ($arwrk as &$row)
                    $row = $this->TARIF_ID->Lookup->renderViewRow($row);
                $this->TARIF_ID->EditValue = $arwrk;
            }
            $this->TARIF_ID->PlaceHolder = RemoveHtml($this->TARIF_ID->caption());

            // CLASS_ID
            $this->CLASS_ID->EditAttrs["class"] = "form-control";
            $this->CLASS_ID->EditCustomAttributes = "";
            $this->CLASS_ID->EditValue = HtmlEncode($this->CLASS_ID->AdvancedSearch->SearchValue);
            $this->CLASS_ID->PlaceHolder = RemoveHtml($this->CLASS_ID->caption());

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

            // CLINIC_ID_FROM
            $this->CLINIC_ID_FROM->EditAttrs["class"] = "form-control";
            $this->CLINIC_ID_FROM->EditCustomAttributes = "";
            if (!$this->CLINIC_ID_FROM->Raw) {
                $this->CLINIC_ID_FROM->AdvancedSearch->SearchValue = HtmlDecode($this->CLINIC_ID_FROM->AdvancedSearch->SearchValue);
            }
            $this->CLINIC_ID_FROM->EditValue = HtmlEncode($this->CLINIC_ID_FROM->AdvancedSearch->SearchValue);
            $this->CLINIC_ID_FROM->PlaceHolder = RemoveHtml($this->CLINIC_ID_FROM->caption());

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

            // MEASURE_ID
            $this->MEASURE_ID->EditAttrs["class"] = "form-control";
            $this->MEASURE_ID->EditCustomAttributes = "";
            $this->MEASURE_ID->EditValue = HtmlEncode($this->MEASURE_ID->AdvancedSearch->SearchValue);
            $this->MEASURE_ID->PlaceHolder = RemoveHtml($this->MEASURE_ID->caption());

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

            // MARGIN
            $this->MARGIN->EditAttrs["class"] = "form-control";
            $this->MARGIN->EditCustomAttributes = "";
            $this->MARGIN->EditValue = HtmlEncode($this->MARGIN->AdvancedSearch->SearchValue);
            $this->MARGIN->PlaceHolder = RemoveHtml($this->MARGIN->caption());

            // SUBSIDI
            $this->SUBSIDI->EditAttrs["class"] = "form-control";
            $this->SUBSIDI->EditCustomAttributes = "";
            $this->SUBSIDI->EditValue = HtmlEncode($this->SUBSIDI->AdvancedSearch->SearchValue);
            $this->SUBSIDI->PlaceHolder = RemoveHtml($this->SUBSIDI->caption());

            // EMBALACE
            $this->EMBALACE->EditAttrs["class"] = "form-control";
            $this->EMBALACE->EditCustomAttributes = "";
            $this->EMBALACE->EditValue = HtmlEncode($this->EMBALACE->AdvancedSearch->SearchValue);
            $this->EMBALACE->PlaceHolder = RemoveHtml($this->EMBALACE->caption());

            // PROFESI
            $this->PROFESI->EditAttrs["class"] = "form-control";
            $this->PROFESI->EditCustomAttributes = "";
            $this->PROFESI->EditValue = HtmlEncode($this->PROFESI->AdvancedSearch->SearchValue);
            $this->PROFESI->PlaceHolder = RemoveHtml($this->PROFESI->caption());

            // DISCOUNT
            $this->DISCOUNT->EditAttrs["class"] = "form-control";
            $this->DISCOUNT->EditCustomAttributes = "";
            $this->DISCOUNT->EditValue = HtmlEncode($this->DISCOUNT->AdvancedSearch->SearchValue);
            $this->DISCOUNT->PlaceHolder = RemoveHtml($this->DISCOUNT->caption());

            // PAY_METHOD_ID
            $this->PAY_METHOD_ID->EditAttrs["class"] = "form-control";
            $this->PAY_METHOD_ID->EditCustomAttributes = "";
            $this->PAY_METHOD_ID->EditValue = HtmlEncode($this->PAY_METHOD_ID->AdvancedSearch->SearchValue);
            $this->PAY_METHOD_ID->PlaceHolder = RemoveHtml($this->PAY_METHOD_ID->caption());

            // PAYMENT_DATE
            $this->PAYMENT_DATE->EditAttrs["class"] = "form-control";
            $this->PAYMENT_DATE->EditCustomAttributes = "";
            $this->PAYMENT_DATE->EditValue = HtmlEncode(FormatDateTime(UnFormatDateTime($this->PAYMENT_DATE->AdvancedSearch->SearchValue, 11), 11));
            $this->PAYMENT_DATE->PlaceHolder = RemoveHtml($this->PAYMENT_DATE->caption());

            // ISLUNAS
            $this->ISLUNAS->EditAttrs["class"] = "form-control";
            $this->ISLUNAS->EditCustomAttributes = "";
            if (!$this->ISLUNAS->Raw) {
                $this->ISLUNAS->AdvancedSearch->SearchValue = HtmlDecode($this->ISLUNAS->AdvancedSearch->SearchValue);
            }
            $this->ISLUNAS->EditValue = HtmlEncode($this->ISLUNAS->AdvancedSearch->SearchValue);
            $this->ISLUNAS->PlaceHolder = RemoveHtml($this->ISLUNAS->caption());

            // DUEDATE_ANGSURAN
            $this->DUEDATE_ANGSURAN->EditAttrs["class"] = "form-control";
            $this->DUEDATE_ANGSURAN->EditCustomAttributes = "";
            $this->DUEDATE_ANGSURAN->EditValue = HtmlEncode(FormatDateTime(UnFormatDateTime($this->DUEDATE_ANGSURAN->AdvancedSearch->SearchValue, 0), 8));
            $this->DUEDATE_ANGSURAN->PlaceHolder = RemoveHtml($this->DUEDATE_ANGSURAN->caption());

            // DESCRIPTION
            $this->DESCRIPTION->EditAttrs["class"] = "form-control";
            $this->DESCRIPTION->EditCustomAttributes = "";
            if (!$this->DESCRIPTION->Raw) {
                $this->DESCRIPTION->AdvancedSearch->SearchValue = HtmlDecode($this->DESCRIPTION->AdvancedSearch->SearchValue);
            }
            $this->DESCRIPTION->EditValue = HtmlEncode($this->DESCRIPTION->AdvancedSearch->SearchValue);
            $this->DESCRIPTION->PlaceHolder = RemoveHtml($this->DESCRIPTION->caption());

            // KUITANSI_ID
            $this->KUITANSI_ID->EditAttrs["class"] = "form-control";
            $this->KUITANSI_ID->EditCustomAttributes = "";
            if (!$this->KUITANSI_ID->Raw) {
                $this->KUITANSI_ID->AdvancedSearch->SearchValue = HtmlDecode($this->KUITANSI_ID->AdvancedSearch->SearchValue);
            }
            $this->KUITANSI_ID->EditValue = HtmlEncode($this->KUITANSI_ID->AdvancedSearch->SearchValue);
            $this->KUITANSI_ID->PlaceHolder = RemoveHtml($this->KUITANSI_ID->caption());

            // NOTA_NO
            $this->NOTA_NO->EditAttrs["class"] = "form-control";
            $this->NOTA_NO->EditCustomAttributes = "";
            if (!$this->NOTA_NO->Raw) {
                $this->NOTA_NO->AdvancedSearch->SearchValue = HtmlDecode($this->NOTA_NO->AdvancedSearch->SearchValue);
            }
            $this->NOTA_NO->EditValue = HtmlEncode($this->NOTA_NO->AdvancedSearch->SearchValue);
            $this->NOTA_NO->PlaceHolder = RemoveHtml($this->NOTA_NO->caption());

            // ISCETAK
            $this->ISCETAK->EditAttrs["class"] = "form-control";
            $this->ISCETAK->EditCustomAttributes = "";
            if (!$this->ISCETAK->Raw) {
                $this->ISCETAK->AdvancedSearch->SearchValue = HtmlDecode($this->ISCETAK->AdvancedSearch->SearchValue);
            }
            $this->ISCETAK->EditValue = HtmlEncode($this->ISCETAK->AdvancedSearch->SearchValue);
            $this->ISCETAK->PlaceHolder = RemoveHtml($this->ISCETAK->caption());

            // PRINT_DATE
            $this->PRINT_DATE->EditAttrs["class"] = "form-control";
            $this->PRINT_DATE->EditCustomAttributes = "";
            $this->PRINT_DATE->EditValue = HtmlEncode(FormatDateTime(UnFormatDateTime($this->PRINT_DATE->AdvancedSearch->SearchValue, 0), 8));
            $this->PRINT_DATE->PlaceHolder = RemoveHtml($this->PRINT_DATE->caption());

            // RESEP_NO
            $this->RESEP_NO->EditAttrs["class"] = "form-control";
            $this->RESEP_NO->EditCustomAttributes = "";
            if (!$this->RESEP_NO->Raw) {
                $this->RESEP_NO->AdvancedSearch->SearchValue = HtmlDecode($this->RESEP_NO->AdvancedSearch->SearchValue);
            }
            $this->RESEP_NO->EditValue = HtmlEncode($this->RESEP_NO->AdvancedSearch->SearchValue);
            $this->RESEP_NO->PlaceHolder = RemoveHtml($this->RESEP_NO->caption());

            // RESEP_KE
            $this->RESEP_KE->EditAttrs["class"] = "form-control";
            $this->RESEP_KE->EditCustomAttributes = "";
            $this->RESEP_KE->EditValue = HtmlEncode($this->RESEP_KE->AdvancedSearch->SearchValue);
            $this->RESEP_KE->PlaceHolder = RemoveHtml($this->RESEP_KE->caption());

            // DOSE
            $this->DOSE->EditAttrs["class"] = "form-control";
            $this->DOSE->EditCustomAttributes = "";
            $this->DOSE->EditValue = HtmlEncode($this->DOSE->AdvancedSearch->SearchValue);
            $this->DOSE->PlaceHolder = RemoveHtml($this->DOSE->caption());

            // ORIG_DOSE
            $this->ORIG_DOSE->EditAttrs["class"] = "form-control";
            $this->ORIG_DOSE->EditCustomAttributes = "";
            $this->ORIG_DOSE->EditValue = HtmlEncode($this->ORIG_DOSE->AdvancedSearch->SearchValue);
            $this->ORIG_DOSE->PlaceHolder = RemoveHtml($this->ORIG_DOSE->caption());

            // DOSE_PRESC
            $this->DOSE_PRESC->EditAttrs["class"] = "form-control";
            $this->DOSE_PRESC->EditCustomAttributes = "";
            $this->DOSE_PRESC->EditValue = HtmlEncode($this->DOSE_PRESC->AdvancedSearch->SearchValue);
            $this->DOSE_PRESC->PlaceHolder = RemoveHtml($this->DOSE_PRESC->caption());

            // ITER
            $this->ITER->EditAttrs["class"] = "form-control";
            $this->ITER->EditCustomAttributes = "";
            $this->ITER->EditValue = HtmlEncode($this->ITER->AdvancedSearch->SearchValue);
            $this->ITER->PlaceHolder = RemoveHtml($this->ITER->caption());

            // ITER_KE
            $this->ITER_KE->EditAttrs["class"] = "form-control";
            $this->ITER_KE->EditCustomAttributes = "";
            $this->ITER_KE->EditValue = HtmlEncode($this->ITER_KE->AdvancedSearch->SearchValue);
            $this->ITER_KE->PlaceHolder = RemoveHtml($this->ITER_KE->caption());

            // SOLD_STATUS
            $this->SOLD_STATUS->EditAttrs["class"] = "form-control";
            $this->SOLD_STATUS->EditCustomAttributes = "";
            $this->SOLD_STATUS->EditValue = HtmlEncode($this->SOLD_STATUS->AdvancedSearch->SearchValue);
            $this->SOLD_STATUS->PlaceHolder = RemoveHtml($this->SOLD_STATUS->caption());

            // RACIKAN
            $this->RACIKAN->EditAttrs["class"] = "form-control";
            $this->RACIKAN->EditCustomAttributes = "";
            $this->RACIKAN->EditValue = HtmlEncode($this->RACIKAN->AdvancedSearch->SearchValue);
            $this->RACIKAN->PlaceHolder = RemoveHtml($this->RACIKAN->caption());

            // CLASS_ROOM_ID
            $this->CLASS_ROOM_ID->EditAttrs["class"] = "form-control";
            $this->CLASS_ROOM_ID->EditCustomAttributes = "";
            if (!$this->CLASS_ROOM_ID->Raw) {
                $this->CLASS_ROOM_ID->AdvancedSearch->SearchValue = HtmlDecode($this->CLASS_ROOM_ID->AdvancedSearch->SearchValue);
            }
            $this->CLASS_ROOM_ID->EditValue = HtmlEncode($this->CLASS_ROOM_ID->AdvancedSearch->SearchValue);
            $this->CLASS_ROOM_ID->PlaceHolder = RemoveHtml($this->CLASS_ROOM_ID->caption());

            // KELUAR_ID
            $this->KELUAR_ID->EditAttrs["class"] = "form-control";
            $this->KELUAR_ID->EditCustomAttributes = "";
            $this->KELUAR_ID->EditValue = HtmlEncode($this->KELUAR_ID->AdvancedSearch->SearchValue);
            $this->KELUAR_ID->PlaceHolder = RemoveHtml($this->KELUAR_ID->caption());

            // BED_ID
            $this->BED_ID->EditAttrs["class"] = "form-control";
            $this->BED_ID->EditCustomAttributes = "";
            $this->BED_ID->EditValue = HtmlEncode($this->BED_ID->AdvancedSearch->SearchValue);
            $this->BED_ID->PlaceHolder = RemoveHtml($this->BED_ID->caption());

            // PERDA_ID
            $this->PERDA_ID->EditAttrs["class"] = "form-control";
            $this->PERDA_ID->EditCustomAttributes = "";
            $this->PERDA_ID->EditValue = HtmlEncode($this->PERDA_ID->AdvancedSearch->SearchValue);
            $this->PERDA_ID->PlaceHolder = RemoveHtml($this->PERDA_ID->caption());

            // EMPLOYEE_ID
            $this->EMPLOYEE_ID->EditAttrs["class"] = "form-control";
            $this->EMPLOYEE_ID->EditCustomAttributes = "";
            $curVal = trim(strval($this->EMPLOYEE_ID->AdvancedSearch->SearchValue));
            if ($curVal != "") {
                $this->EMPLOYEE_ID->AdvancedSearch->ViewValue = $this->EMPLOYEE_ID->lookupCacheOption($curVal);
            } else {
                $this->EMPLOYEE_ID->AdvancedSearch->ViewValue = $this->EMPLOYEE_ID->Lookup !== null && is_array($this->EMPLOYEE_ID->Lookup->Options) ? $curVal : null;
            }
            if ($this->EMPLOYEE_ID->AdvancedSearch->ViewValue !== null) { // Load from cache
                $this->EMPLOYEE_ID->EditValue = array_values($this->EMPLOYEE_ID->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "[EMPLOYEE_ID]" . SearchString("=", $this->EMPLOYEE_ID->AdvancedSearch->SearchValue, DATATYPE_STRING, "");
                }
                $sqlWrk = $this->EMPLOYEE_ID->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->EMPLOYEE_ID->EditValue = $arwrk;
            }
            $this->EMPLOYEE_ID->PlaceHolder = RemoveHtml($this->EMPLOYEE_ID->caption());

            // DESCRIPTION2
            $this->DESCRIPTION2->EditAttrs["class"] = "form-control";
            $this->DESCRIPTION2->EditCustomAttributes = "";
            if (!$this->DESCRIPTION2->Raw) {
                $this->DESCRIPTION2->AdvancedSearch->SearchValue = HtmlDecode($this->DESCRIPTION2->AdvancedSearch->SearchValue);
            }
            $this->DESCRIPTION2->EditValue = HtmlEncode($this->DESCRIPTION2->AdvancedSearch->SearchValue);
            $this->DESCRIPTION2->PlaceHolder = RemoveHtml($this->DESCRIPTION2->caption());

            // MODIFIED_BY
            $this->MODIFIED_BY->EditAttrs["class"] = "form-control";
            $this->MODIFIED_BY->EditCustomAttributes = "";
            if (!$this->MODIFIED_BY->Raw) {
                $this->MODIFIED_BY->AdvancedSearch->SearchValue = HtmlDecode($this->MODIFIED_BY->AdvancedSearch->SearchValue);
            }
            $this->MODIFIED_BY->EditValue = HtmlEncode($this->MODIFIED_BY->AdvancedSearch->SearchValue);
            $this->MODIFIED_BY->PlaceHolder = RemoveHtml($this->MODIFIED_BY->caption());

            // MODIFIED_DATE
            $this->MODIFIED_DATE->EditAttrs["class"] = "form-control";
            $this->MODIFIED_DATE->EditCustomAttributes = "";
            $this->MODIFIED_DATE->EditValue = HtmlEncode(FormatDateTime(UnFormatDateTime($this->MODIFIED_DATE->AdvancedSearch->SearchValue, 0), 8));
            $this->MODIFIED_DATE->PlaceHolder = RemoveHtml($this->MODIFIED_DATE->caption());

            // MODIFIED_FROM
            $this->MODIFIED_FROM->EditAttrs["class"] = "form-control";
            $this->MODIFIED_FROM->EditCustomAttributes = "";
            if (!$this->MODIFIED_FROM->Raw) {
                $this->MODIFIED_FROM->AdvancedSearch->SearchValue = HtmlDecode($this->MODIFIED_FROM->AdvancedSearch->SearchValue);
            }
            $this->MODIFIED_FROM->EditValue = HtmlEncode($this->MODIFIED_FROM->AdvancedSearch->SearchValue);
            $this->MODIFIED_FROM->PlaceHolder = RemoveHtml($this->MODIFIED_FROM->caption());

            // BRAND_ID
            $this->BRAND_ID->EditAttrs["class"] = "form-control";
            $this->BRAND_ID->EditCustomAttributes = "";
            if (!$this->BRAND_ID->Raw) {
                $this->BRAND_ID->AdvancedSearch->SearchValue = HtmlDecode($this->BRAND_ID->AdvancedSearch->SearchValue);
            }
            $this->BRAND_ID->EditValue = HtmlEncode($this->BRAND_ID->AdvancedSearch->SearchValue);
            $this->BRAND_ID->PlaceHolder = RemoveHtml($this->BRAND_ID->caption());

            // DOCTOR
            $this->DOCTOR->EditAttrs["class"] = "form-control";
            $this->DOCTOR->EditCustomAttributes = "";
            if (!$this->DOCTOR->Raw) {
                $this->DOCTOR->AdvancedSearch->SearchValue = HtmlDecode($this->DOCTOR->AdvancedSearch->SearchValue);
            }
            $this->DOCTOR->EditValue = HtmlEncode($this->DOCTOR->AdvancedSearch->SearchValue);
            $this->DOCTOR->PlaceHolder = RemoveHtml($this->DOCTOR->caption());

            // JML_BKS
            $this->JML_BKS->EditAttrs["class"] = "form-control";
            $this->JML_BKS->EditCustomAttributes = "";
            $this->JML_BKS->EditValue = HtmlEncode($this->JML_BKS->AdvancedSearch->SearchValue);
            $this->JML_BKS->PlaceHolder = RemoveHtml($this->JML_BKS->caption());

            // EXIT_DATE
            $this->EXIT_DATE->EditAttrs["class"] = "form-control";
            $this->EXIT_DATE->EditCustomAttributes = "";
            $this->EXIT_DATE->EditValue = HtmlEncode(FormatDateTime(UnFormatDateTime($this->EXIT_DATE->AdvancedSearch->SearchValue, 0), 8));
            $this->EXIT_DATE->PlaceHolder = RemoveHtml($this->EXIT_DATE->caption());

            // FA_V
            $this->FA_V->EditAttrs["class"] = "form-control";
            $this->FA_V->EditCustomAttributes = "";
            $this->FA_V->EditValue = HtmlEncode($this->FA_V->AdvancedSearch->SearchValue);
            $this->FA_V->PlaceHolder = RemoveHtml($this->FA_V->caption());

            // TASK_ID
            $this->TASK_ID->EditAttrs["class"] = "form-control";
            $this->TASK_ID->EditCustomAttributes = "";
            $this->TASK_ID->EditValue = HtmlEncode($this->TASK_ID->AdvancedSearch->SearchValue);
            $this->TASK_ID->PlaceHolder = RemoveHtml($this->TASK_ID->caption());

            // EMPLOYEE_ID_FROM
            $this->EMPLOYEE_ID_FROM->EditAttrs["class"] = "form-control";
            $this->EMPLOYEE_ID_FROM->EditCustomAttributes = "";
            if (!$this->EMPLOYEE_ID_FROM->Raw) {
                $this->EMPLOYEE_ID_FROM->AdvancedSearch->SearchValue = HtmlDecode($this->EMPLOYEE_ID_FROM->AdvancedSearch->SearchValue);
            }
            $this->EMPLOYEE_ID_FROM->EditValue = HtmlEncode($this->EMPLOYEE_ID_FROM->AdvancedSearch->SearchValue);
            $this->EMPLOYEE_ID_FROM->PlaceHolder = RemoveHtml($this->EMPLOYEE_ID_FROM->caption());

            // DOCTOR_FROM
            $this->DOCTOR_FROM->EditAttrs["class"] = "form-control";
            $this->DOCTOR_FROM->EditCustomAttributes = "";
            if (!$this->DOCTOR_FROM->Raw) {
                $this->DOCTOR_FROM->AdvancedSearch->SearchValue = HtmlDecode($this->DOCTOR_FROM->AdvancedSearch->SearchValue);
            }
            $this->DOCTOR_FROM->EditValue = HtmlEncode($this->DOCTOR_FROM->AdvancedSearch->SearchValue);
            $this->DOCTOR_FROM->PlaceHolder = RemoveHtml($this->DOCTOR_FROM->caption());

            // status_pasien_id
            $this->status_pasien_id->EditAttrs["class"] = "form-control";
            $this->status_pasien_id->EditCustomAttributes = "";
            $this->status_pasien_id->EditValue = HtmlEncode($this->status_pasien_id->AdvancedSearch->SearchValue);
            $this->status_pasien_id->PlaceHolder = RemoveHtml($this->status_pasien_id->caption());

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

            // serial_nb
            $this->serial_nb->EditAttrs["class"] = "form-control";
            $this->serial_nb->EditCustomAttributes = "";
            if (!$this->serial_nb->Raw) {
                $this->serial_nb->AdvancedSearch->SearchValue = HtmlDecode($this->serial_nb->AdvancedSearch->SearchValue);
            }
            $this->serial_nb->EditValue = HtmlEncode($this->serial_nb->AdvancedSearch->SearchValue);
            $this->serial_nb->PlaceHolder = RemoveHtml($this->serial_nb->caption());

            // TREATMENT_PLAFOND
            $this->TREATMENT_PLAFOND->EditAttrs["class"] = "form-control";
            $this->TREATMENT_PLAFOND->EditCustomAttributes = "";
            if (!$this->TREATMENT_PLAFOND->Raw) {
                $this->TREATMENT_PLAFOND->AdvancedSearch->SearchValue = HtmlDecode($this->TREATMENT_PLAFOND->AdvancedSearch->SearchValue);
            }
            $this->TREATMENT_PLAFOND->EditValue = HtmlEncode($this->TREATMENT_PLAFOND->AdvancedSearch->SearchValue);
            $this->TREATMENT_PLAFOND->PlaceHolder = RemoveHtml($this->TREATMENT_PLAFOND->caption());

            // AMOUNT_PLAFOND
            $this->AMOUNT_PLAFOND->EditAttrs["class"] = "form-control";
            $this->AMOUNT_PLAFOND->EditCustomAttributes = "";
            $this->AMOUNT_PLAFOND->EditValue = HtmlEncode($this->AMOUNT_PLAFOND->AdvancedSearch->SearchValue);
            $this->AMOUNT_PLAFOND->PlaceHolder = RemoveHtml($this->AMOUNT_PLAFOND->caption());

            // AMOUNT_PAID_PLAFOND
            $this->AMOUNT_PAID_PLAFOND->EditAttrs["class"] = "form-control";
            $this->AMOUNT_PAID_PLAFOND->EditCustomAttributes = "";
            $this->AMOUNT_PAID_PLAFOND->EditValue = HtmlEncode($this->AMOUNT_PAID_PLAFOND->AdvancedSearch->SearchValue);
            $this->AMOUNT_PAID_PLAFOND->PlaceHolder = RemoveHtml($this->AMOUNT_PAID_PLAFOND->caption());

            // CLASS_ID_PLAFOND
            $this->CLASS_ID_PLAFOND->EditAttrs["class"] = "form-control";
            $this->CLASS_ID_PLAFOND->EditCustomAttributes = "";
            $this->CLASS_ID_PLAFOND->EditValue = HtmlEncode($this->CLASS_ID_PLAFOND->AdvancedSearch->SearchValue);
            $this->CLASS_ID_PLAFOND->PlaceHolder = RemoveHtml($this->CLASS_ID_PLAFOND->caption());

            // PAYOR_ID
            $this->PAYOR_ID->EditAttrs["class"] = "form-control";
            $this->PAYOR_ID->EditCustomAttributes = "";
            if (!$this->PAYOR_ID->Raw) {
                $this->PAYOR_ID->AdvancedSearch->SearchValue = HtmlDecode($this->PAYOR_ID->AdvancedSearch->SearchValue);
            }
            $this->PAYOR_ID->EditValue = HtmlEncode($this->PAYOR_ID->AdvancedSearch->SearchValue);
            $this->PAYOR_ID->PlaceHolder = RemoveHtml($this->PAYOR_ID->caption());

            // PEMBULATAN
            $this->PEMBULATAN->EditAttrs["class"] = "form-control";
            $this->PEMBULATAN->EditCustomAttributes = "";
            $this->PEMBULATAN->EditValue = HtmlEncode($this->PEMBULATAN->AdvancedSearch->SearchValue);
            $this->PEMBULATAN->PlaceHolder = RemoveHtml($this->PEMBULATAN->caption());

            // ISRJ
            $this->ISRJ->EditAttrs["class"] = "form-control";
            $this->ISRJ->EditCustomAttributes = "";
            if (!$this->ISRJ->Raw) {
                $this->ISRJ->AdvancedSearch->SearchValue = HtmlDecode($this->ISRJ->AdvancedSearch->SearchValue);
            }
            $this->ISRJ->EditValue = HtmlEncode($this->ISRJ->AdvancedSearch->SearchValue);
            $this->ISRJ->PlaceHolder = RemoveHtml($this->ISRJ->caption());

            // AGEYEAR
            $this->AGEYEAR->EditAttrs["class"] = "form-control";
            $this->AGEYEAR->EditCustomAttributes = "";
            $this->AGEYEAR->EditValue = HtmlEncode($this->AGEYEAR->AdvancedSearch->SearchValue);
            $this->AGEYEAR->PlaceHolder = RemoveHtml($this->AGEYEAR->caption());

            // AGEMONTH
            $this->AGEMONTH->EditAttrs["class"] = "form-control";
            $this->AGEMONTH->EditCustomAttributes = "";
            $this->AGEMONTH->EditValue = HtmlEncode($this->AGEMONTH->AdvancedSearch->SearchValue);
            $this->AGEMONTH->PlaceHolder = RemoveHtml($this->AGEMONTH->caption());

            // AGEDAY
            $this->AGEDAY->EditAttrs["class"] = "form-control";
            $this->AGEDAY->EditCustomAttributes = "";
            $this->AGEDAY->EditValue = HtmlEncode($this->AGEDAY->AdvancedSearch->SearchValue);
            $this->AGEDAY->PlaceHolder = RemoveHtml($this->AGEDAY->caption());

            // GENDER
            $this->GENDER->EditAttrs["class"] = "form-control";
            $this->GENDER->EditCustomAttributes = "";
            if (!$this->GENDER->Raw) {
                $this->GENDER->AdvancedSearch->SearchValue = HtmlDecode($this->GENDER->AdvancedSearch->SearchValue);
            }
            $this->GENDER->EditValue = HtmlEncode($this->GENDER->AdvancedSearch->SearchValue);
            $this->GENDER->PlaceHolder = RemoveHtml($this->GENDER->caption());

            // KAL_ID
            $this->KAL_ID->EditAttrs["class"] = "form-control";
            $this->KAL_ID->EditCustomAttributes = "";
            if (!$this->KAL_ID->Raw) {
                $this->KAL_ID->AdvancedSearch->SearchValue = HtmlDecode($this->KAL_ID->AdvancedSearch->SearchValue);
            }
            $this->KAL_ID->EditValue = HtmlEncode($this->KAL_ID->AdvancedSearch->SearchValue);
            $this->KAL_ID->PlaceHolder = RemoveHtml($this->KAL_ID->caption());

            // CORRECTION_ID
            $this->CORRECTION_ID->EditAttrs["class"] = "form-control";
            $this->CORRECTION_ID->EditCustomAttributes = "";
            if (!$this->CORRECTION_ID->Raw) {
                $this->CORRECTION_ID->AdvancedSearch->SearchValue = HtmlDecode($this->CORRECTION_ID->AdvancedSearch->SearchValue);
            }
            $this->CORRECTION_ID->EditValue = HtmlEncode($this->CORRECTION_ID->AdvancedSearch->SearchValue);
            $this->CORRECTION_ID->PlaceHolder = RemoveHtml($this->CORRECTION_ID->caption());

            // CORRECTION_BY
            $this->CORRECTION_BY->EditAttrs["class"] = "form-control";
            $this->CORRECTION_BY->EditCustomAttributes = "";
            if (!$this->CORRECTION_BY->Raw) {
                $this->CORRECTION_BY->AdvancedSearch->SearchValue = HtmlDecode($this->CORRECTION_BY->AdvancedSearch->SearchValue);
            }
            $this->CORRECTION_BY->EditValue = HtmlEncode($this->CORRECTION_BY->AdvancedSearch->SearchValue);
            $this->CORRECTION_BY->PlaceHolder = RemoveHtml($this->CORRECTION_BY->caption());

            // KARYAWAN
            $this->KARYAWAN->EditAttrs["class"] = "form-control";
            $this->KARYAWAN->EditCustomAttributes = "";
            if (!$this->KARYAWAN->Raw) {
                $this->KARYAWAN->AdvancedSearch->SearchValue = HtmlDecode($this->KARYAWAN->AdvancedSearch->SearchValue);
            }
            $this->KARYAWAN->EditValue = HtmlEncode($this->KARYAWAN->AdvancedSearch->SearchValue);
            $this->KARYAWAN->PlaceHolder = RemoveHtml($this->KARYAWAN->caption());

            // ACCOUNT_ID
            $this->ACCOUNT_ID->EditAttrs["class"] = "form-control";
            $this->ACCOUNT_ID->EditCustomAttributes = "";
            if (!$this->ACCOUNT_ID->Raw) {
                $this->ACCOUNT_ID->AdvancedSearch->SearchValue = HtmlDecode($this->ACCOUNT_ID->AdvancedSearch->SearchValue);
            }
            $this->ACCOUNT_ID->EditValue = HtmlEncode($this->ACCOUNT_ID->AdvancedSearch->SearchValue);
            $this->ACCOUNT_ID->PlaceHolder = RemoveHtml($this->ACCOUNT_ID->caption());

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

            // INVOICE_ID
            $this->INVOICE_ID->EditAttrs["class"] = "form-control";
            $this->INVOICE_ID->EditCustomAttributes = "";
            if (!$this->INVOICE_ID->Raw) {
                $this->INVOICE_ID->AdvancedSearch->SearchValue = HtmlDecode($this->INVOICE_ID->AdvancedSearch->SearchValue);
            }
            $this->INVOICE_ID->EditValue = HtmlEncode($this->INVOICE_ID->AdvancedSearch->SearchValue);
            $this->INVOICE_ID->PlaceHolder = RemoveHtml($this->INVOICE_ID->caption());

            // NUMER
            $this->NUMER->EditAttrs["class"] = "form-control";
            $this->NUMER->EditCustomAttributes = "";
            if (!$this->NUMER->Raw) {
                $this->NUMER->AdvancedSearch->SearchValue = HtmlDecode($this->NUMER->AdvancedSearch->SearchValue);
            }
            $this->NUMER->EditValue = HtmlEncode($this->NUMER->AdvancedSearch->SearchValue);
            $this->NUMER->PlaceHolder = RemoveHtml($this->NUMER->caption());

            // MEASURE_ID2
            $this->MEASURE_ID2->EditAttrs["class"] = "form-control";
            $this->MEASURE_ID2->EditCustomAttributes = "";
            $this->MEASURE_ID2->EditValue = HtmlEncode($this->MEASURE_ID2->AdvancedSearch->SearchValue);
            $this->MEASURE_ID2->PlaceHolder = RemoveHtml($this->MEASURE_ID2->caption());

            // POTONGAN
            $this->POTONGAN->EditAttrs["class"] = "form-control";
            $this->POTONGAN->EditCustomAttributes = "";
            $this->POTONGAN->EditValue = HtmlEncode($this->POTONGAN->AdvancedSearch->SearchValue);
            $this->POTONGAN->PlaceHolder = RemoveHtml($this->POTONGAN->caption());

            // BAYAR
            $this->BAYAR->EditAttrs["class"] = "form-control";
            $this->BAYAR->EditCustomAttributes = "";
            $this->BAYAR->EditValue = HtmlEncode($this->BAYAR->AdvancedSearch->SearchValue);
            $this->BAYAR->PlaceHolder = RemoveHtml($this->BAYAR->caption());

            // RETUR
            $this->RETUR->EditAttrs["class"] = "form-control";
            $this->RETUR->EditCustomAttributes = "";
            $this->RETUR->EditValue = HtmlEncode($this->RETUR->AdvancedSearch->SearchValue);
            $this->RETUR->PlaceHolder = RemoveHtml($this->RETUR->caption());

            // TARIF_TYPE
            $this->TARIF_TYPE->EditAttrs["class"] = "form-control";
            $this->TARIF_TYPE->EditCustomAttributes = "";
            if (!$this->TARIF_TYPE->Raw) {
                $this->TARIF_TYPE->AdvancedSearch->SearchValue = HtmlDecode($this->TARIF_TYPE->AdvancedSearch->SearchValue);
            }
            $this->TARIF_TYPE->EditValue = HtmlEncode($this->TARIF_TYPE->AdvancedSearch->SearchValue);
            $this->TARIF_TYPE->PlaceHolder = RemoveHtml($this->TARIF_TYPE->caption());

            // PPNVALUE
            $this->PPNVALUE->EditAttrs["class"] = "form-control";
            $this->PPNVALUE->EditCustomAttributes = "";
            $this->PPNVALUE->EditValue = HtmlEncode($this->PPNVALUE->AdvancedSearch->SearchValue);
            $this->PPNVALUE->PlaceHolder = RemoveHtml($this->PPNVALUE->caption());

            // TAGIHAN
            $this->TAGIHAN->EditAttrs["class"] = "form-control";
            $this->TAGIHAN->EditCustomAttributes = "";
            $this->TAGIHAN->EditValue = HtmlEncode($this->TAGIHAN->AdvancedSearch->SearchValue);
            $this->TAGIHAN->PlaceHolder = RemoveHtml($this->TAGIHAN->caption());

            // KOREKSI
            $this->KOREKSI->EditAttrs["class"] = "form-control";
            $this->KOREKSI->EditCustomAttributes = "";
            $this->KOREKSI->EditValue = HtmlEncode($this->KOREKSI->AdvancedSearch->SearchValue);
            $this->KOREKSI->PlaceHolder = RemoveHtml($this->KOREKSI->caption());

            // STATUS_OBAT
            $this->STATUS_OBAT->EditAttrs["class"] = "form-control";
            $this->STATUS_OBAT->EditCustomAttributes = "";
            $this->STATUS_OBAT->EditValue = HtmlEncode($this->STATUS_OBAT->AdvancedSearch->SearchValue);
            $this->STATUS_OBAT->PlaceHolder = RemoveHtml($this->STATUS_OBAT->caption());

            // SUBSIDISAT
            $this->SUBSIDISAT->EditAttrs["class"] = "form-control";
            $this->SUBSIDISAT->EditCustomAttributes = "";
            $this->SUBSIDISAT->EditValue = HtmlEncode($this->SUBSIDISAT->AdvancedSearch->SearchValue);
            $this->SUBSIDISAT->PlaceHolder = RemoveHtml($this->SUBSIDISAT->caption());

            // PRINTQ
            $this->PRINTQ->EditAttrs["class"] = "form-control";
            $this->PRINTQ->EditCustomAttributes = "";
            $this->PRINTQ->EditValue = HtmlEncode($this->PRINTQ->AdvancedSearch->SearchValue);
            $this->PRINTQ->PlaceHolder = RemoveHtml($this->PRINTQ->caption());

            // PRINTED_BY
            $this->PRINTED_BY->EditAttrs["class"] = "form-control";
            $this->PRINTED_BY->EditCustomAttributes = "";
            if (!$this->PRINTED_BY->Raw) {
                $this->PRINTED_BY->AdvancedSearch->SearchValue = HtmlDecode($this->PRINTED_BY->AdvancedSearch->SearchValue);
            }
            $this->PRINTED_BY->EditValue = HtmlEncode($this->PRINTED_BY->AdvancedSearch->SearchValue);
            $this->PRINTED_BY->PlaceHolder = RemoveHtml($this->PRINTED_BY->caption());

            // STOCK_AVAILABLE
            $this->STOCK_AVAILABLE->EditAttrs["class"] = "form-control";
            $this->STOCK_AVAILABLE->EditCustomAttributes = "";
            $this->STOCK_AVAILABLE->EditValue = HtmlEncode($this->STOCK_AVAILABLE->AdvancedSearch->SearchValue);
            $this->STOCK_AVAILABLE->PlaceHolder = RemoveHtml($this->STOCK_AVAILABLE->caption());

            // STATUS_TARIF
            $this->STATUS_TARIF->EditAttrs["class"] = "form-control";
            $this->STATUS_TARIF->EditCustomAttributes = "";
            $this->STATUS_TARIF->EditValue = HtmlEncode($this->STATUS_TARIF->AdvancedSearch->SearchValue);
            $this->STATUS_TARIF->PlaceHolder = RemoveHtml($this->STATUS_TARIF->caption());

            // CLINIC_TYPE
            $this->CLINIC_TYPE->EditAttrs["class"] = "form-control";
            $this->CLINIC_TYPE->EditCustomAttributes = "";
            $this->CLINIC_TYPE->EditValue = HtmlEncode($this->CLINIC_TYPE->AdvancedSearch->SearchValue);
            $this->CLINIC_TYPE->PlaceHolder = RemoveHtml($this->CLINIC_TYPE->caption());

            // PACKAGE_ID
            $this->PACKAGE_ID->EditAttrs["class"] = "form-control";
            $this->PACKAGE_ID->EditCustomAttributes = "";
            if (!$this->PACKAGE_ID->Raw) {
                $this->PACKAGE_ID->AdvancedSearch->SearchValue = HtmlDecode($this->PACKAGE_ID->AdvancedSearch->SearchValue);
            }
            $this->PACKAGE_ID->EditValue = HtmlEncode($this->PACKAGE_ID->AdvancedSearch->SearchValue);
            $this->PACKAGE_ID->PlaceHolder = RemoveHtml($this->PACKAGE_ID->caption());

            // MODULE_ID
            $this->MODULE_ID->EditAttrs["class"] = "form-control";
            $this->MODULE_ID->EditCustomAttributes = "";
            if (!$this->MODULE_ID->Raw) {
                $this->MODULE_ID->AdvancedSearch->SearchValue = HtmlDecode($this->MODULE_ID->AdvancedSearch->SearchValue);
            }
            $this->MODULE_ID->EditValue = HtmlEncode($this->MODULE_ID->AdvancedSearch->SearchValue);
            $this->MODULE_ID->PlaceHolder = RemoveHtml($this->MODULE_ID->caption());

            // profession
            $this->profession->EditAttrs["class"] = "form-control";
            $this->profession->EditCustomAttributes = "";
            $this->profession->EditValue = HtmlEncode($this->profession->AdvancedSearch->SearchValue);
            $this->profession->PlaceHolder = RemoveHtml($this->profession->caption());

            // THEORDER
            $this->THEORDER->EditAttrs["class"] = "form-control";
            $this->THEORDER->EditCustomAttributes = "";
            $this->THEORDER->EditValue = HtmlEncode($this->THEORDER->AdvancedSearch->SearchValue);
            $this->THEORDER->PlaceHolder = RemoveHtml($this->THEORDER->caption());

            // CASHIER
            $this->CASHIER->EditAttrs["class"] = "form-control";
            $this->CASHIER->EditCustomAttributes = "";
            if (!$this->CASHIER->Raw) {
                $this->CASHIER->AdvancedSearch->SearchValue = HtmlDecode($this->CASHIER->AdvancedSearch->SearchValue);
            }
            $this->CASHIER->EditValue = HtmlEncode($this->CASHIER->AdvancedSearch->SearchValue);
            $this->CASHIER->PlaceHolder = RemoveHtml($this->CASHIER->caption());

            // SPPFEE
            $this->SPPFEE->EditAttrs["class"] = "form-control";
            $this->SPPFEE->EditCustomAttributes = "";
            if (!$this->SPPFEE->Raw) {
                $this->SPPFEE->AdvancedSearch->SearchValue = HtmlDecode($this->SPPFEE->AdvancedSearch->SearchValue);
            }
            $this->SPPFEE->EditValue = HtmlEncode($this->SPPFEE->AdvancedSearch->SearchValue);
            $this->SPPFEE->PlaceHolder = RemoveHtml($this->SPPFEE->caption());

            // SPPBILL
            $this->SPPBILL->EditAttrs["class"] = "form-control";
            $this->SPPBILL->EditCustomAttributes = "";
            if (!$this->SPPBILL->Raw) {
                $this->SPPBILL->AdvancedSearch->SearchValue = HtmlDecode($this->SPPBILL->AdvancedSearch->SearchValue);
            }
            $this->SPPBILL->EditValue = HtmlEncode($this->SPPBILL->AdvancedSearch->SearchValue);
            $this->SPPBILL->PlaceHolder = RemoveHtml($this->SPPBILL->caption());

            // SPPRJK
            $this->SPPRJK->EditAttrs["class"] = "form-control";
            $this->SPPRJK->EditCustomAttributes = "";
            if (!$this->SPPRJK->Raw) {
                $this->SPPRJK->AdvancedSearch->SearchValue = HtmlDecode($this->SPPRJK->AdvancedSearch->SearchValue);
            }
            $this->SPPRJK->EditValue = HtmlEncode($this->SPPRJK->AdvancedSearch->SearchValue);
            $this->SPPRJK->PlaceHolder = RemoveHtml($this->SPPRJK->caption());

            // SPPJMN
            $this->SPPJMN->EditAttrs["class"] = "form-control";
            $this->SPPJMN->EditCustomAttributes = "";
            if (!$this->SPPJMN->Raw) {
                $this->SPPJMN->AdvancedSearch->SearchValue = HtmlDecode($this->SPPJMN->AdvancedSearch->SearchValue);
            }
            $this->SPPJMN->EditValue = HtmlEncode($this->SPPJMN->AdvancedSearch->SearchValue);
            $this->SPPJMN->PlaceHolder = RemoveHtml($this->SPPJMN->caption());

            // SPPKASIR
            $this->SPPKASIR->EditAttrs["class"] = "form-control";
            $this->SPPKASIR->EditCustomAttributes = "";
            if (!$this->SPPKASIR->Raw) {
                $this->SPPKASIR->AdvancedSearch->SearchValue = HtmlDecode($this->SPPKASIR->AdvancedSearch->SearchValue);
            }
            $this->SPPKASIR->EditValue = HtmlEncode($this->SPPKASIR->AdvancedSearch->SearchValue);
            $this->SPPKASIR->PlaceHolder = RemoveHtml($this->SPPKASIR->caption());

            // PERUJUK
            $this->PERUJUK->EditAttrs["class"] = "form-control";
            $this->PERUJUK->EditCustomAttributes = "";
            if (!$this->PERUJUK->Raw) {
                $this->PERUJUK->AdvancedSearch->SearchValue = HtmlDecode($this->PERUJUK->AdvancedSearch->SearchValue);
            }
            $this->PERUJUK->EditValue = HtmlEncode($this->PERUJUK->AdvancedSearch->SearchValue);
            $this->PERUJUK->PlaceHolder = RemoveHtml($this->PERUJUK->caption());

            // PERUJUKFEE
            $this->PERUJUKFEE->EditAttrs["class"] = "form-control";
            $this->PERUJUKFEE->EditCustomAttributes = "";
            $this->PERUJUKFEE->EditValue = HtmlEncode($this->PERUJUKFEE->AdvancedSearch->SearchValue);
            $this->PERUJUKFEE->PlaceHolder = RemoveHtml($this->PERUJUKFEE->caption());

            // modified_datesys
            $this->modified_datesys->EditAttrs["class"] = "form-control";
            $this->modified_datesys->EditCustomAttributes = "";
            $this->modified_datesys->EditValue = HtmlEncode(FormatDateTime(UnFormatDateTime($this->modified_datesys->AdvancedSearch->SearchValue, 0), 8));
            $this->modified_datesys->PlaceHolder = RemoveHtml($this->modified_datesys->caption());

            // TRANS_ID
            $this->TRANS_ID->EditAttrs["class"] = "form-control";
            $this->TRANS_ID->EditCustomAttributes = "";
            if (!$this->TRANS_ID->Raw) {
                $this->TRANS_ID->AdvancedSearch->SearchValue = HtmlDecode($this->TRANS_ID->AdvancedSearch->SearchValue);
            }
            $this->TRANS_ID->EditValue = HtmlEncode($this->TRANS_ID->AdvancedSearch->SearchValue);
            $this->TRANS_ID->PlaceHolder = RemoveHtml($this->TRANS_ID->caption());

            // SPPBILLDATE
            $this->SPPBILLDATE->EditAttrs["class"] = "form-control";
            $this->SPPBILLDATE->EditCustomAttributes = "";
            $this->SPPBILLDATE->EditValue = HtmlEncode(FormatDateTime(UnFormatDateTime($this->SPPBILLDATE->AdvancedSearch->SearchValue, 0), 8));
            $this->SPPBILLDATE->PlaceHolder = RemoveHtml($this->SPPBILLDATE->caption());

            // SPPBILLUSER
            $this->SPPBILLUSER->EditAttrs["class"] = "form-control";
            $this->SPPBILLUSER->EditCustomAttributes = "";
            if (!$this->SPPBILLUSER->Raw) {
                $this->SPPBILLUSER->AdvancedSearch->SearchValue = HtmlDecode($this->SPPBILLUSER->AdvancedSearch->SearchValue);
            }
            $this->SPPBILLUSER->EditValue = HtmlEncode($this->SPPBILLUSER->AdvancedSearch->SearchValue);
            $this->SPPBILLUSER->PlaceHolder = RemoveHtml($this->SPPBILLUSER->caption());

            // SPPKASIRDATE
            $this->SPPKASIRDATE->EditAttrs["class"] = "form-control";
            $this->SPPKASIRDATE->EditCustomAttributes = "";
            $this->SPPKASIRDATE->EditValue = HtmlEncode(FormatDateTime(UnFormatDateTime($this->SPPKASIRDATE->AdvancedSearch->SearchValue, 0), 8));
            $this->SPPKASIRDATE->PlaceHolder = RemoveHtml($this->SPPKASIRDATE->caption());

            // SPPKASIRUSER
            $this->SPPKASIRUSER->EditAttrs["class"] = "form-control";
            $this->SPPKASIRUSER->EditCustomAttributes = "";
            if (!$this->SPPKASIRUSER->Raw) {
                $this->SPPKASIRUSER->AdvancedSearch->SearchValue = HtmlDecode($this->SPPKASIRUSER->AdvancedSearch->SearchValue);
            }
            $this->SPPKASIRUSER->EditValue = HtmlEncode($this->SPPKASIRUSER->AdvancedSearch->SearchValue);
            $this->SPPKASIRUSER->PlaceHolder = RemoveHtml($this->SPPKASIRUSER->caption());

            // SPPPOLI
            $this->SPPPOLI->EditAttrs["class"] = "form-control";
            $this->SPPPOLI->EditCustomAttributes = "";
            if (!$this->SPPPOLI->Raw) {
                $this->SPPPOLI->AdvancedSearch->SearchValue = HtmlDecode($this->SPPPOLI->AdvancedSearch->SearchValue);
            }
            $this->SPPPOLI->EditValue = HtmlEncode($this->SPPPOLI->AdvancedSearch->SearchValue);
            $this->SPPPOLI->PlaceHolder = RemoveHtml($this->SPPPOLI->caption());

            // SPPPOLIUSER
            $this->SPPPOLIUSER->EditAttrs["class"] = "form-control";
            $this->SPPPOLIUSER->EditCustomAttributes = "";
            if (!$this->SPPPOLIUSER->Raw) {
                $this->SPPPOLIUSER->AdvancedSearch->SearchValue = HtmlDecode($this->SPPPOLIUSER->AdvancedSearch->SearchValue);
            }
            $this->SPPPOLIUSER->EditValue = HtmlEncode($this->SPPPOLIUSER->AdvancedSearch->SearchValue);
            $this->SPPPOLIUSER->PlaceHolder = RemoveHtml($this->SPPPOLIUSER->caption());

            // SPPPOLIDATE
            $this->SPPPOLIDATE->EditAttrs["class"] = "form-control";
            $this->SPPPOLIDATE->EditCustomAttributes = "";
            $this->SPPPOLIDATE->EditValue = HtmlEncode(FormatDateTime(UnFormatDateTime($this->SPPPOLIDATE->AdvancedSearch->SearchValue, 0), 8));
            $this->SPPPOLIDATE->PlaceHolder = RemoveHtml($this->SPPPOLIDATE->caption());

            // nota_temp
            $this->nota_temp->EditAttrs["class"] = "form-control";
            $this->nota_temp->EditCustomAttributes = "";
            if (!$this->nota_temp->Raw) {
                $this->nota_temp->AdvancedSearch->SearchValue = HtmlDecode($this->nota_temp->AdvancedSearch->SearchValue);
            }
            $this->nota_temp->EditValue = HtmlEncode($this->nota_temp->AdvancedSearch->SearchValue);
            $this->nota_temp->PlaceHolder = RemoveHtml($this->nota_temp->caption());

            // CLINIC_ID_TEMP
            $this->CLINIC_ID_TEMP->EditAttrs["class"] = "form-control";
            $this->CLINIC_ID_TEMP->EditCustomAttributes = "";
            if (!$this->CLINIC_ID_TEMP->Raw) {
                $this->CLINIC_ID_TEMP->AdvancedSearch->SearchValue = HtmlDecode($this->CLINIC_ID_TEMP->AdvancedSearch->SearchValue);
            }
            $this->CLINIC_ID_TEMP->EditValue = HtmlEncode($this->CLINIC_ID_TEMP->AdvancedSearch->SearchValue);
            $this->CLINIC_ID_TEMP->PlaceHolder = RemoveHtml($this->CLINIC_ID_TEMP->caption());

            // NOSEP
            $this->NOSEP->EditAttrs["class"] = "form-control";
            $this->NOSEP->EditCustomAttributes = "";
            if (!$this->NOSEP->Raw) {
                $this->NOSEP->AdvancedSearch->SearchValue = HtmlDecode($this->NOSEP->AdvancedSearch->SearchValue);
            }
            $this->NOSEP->EditValue = HtmlEncode($this->NOSEP->AdvancedSearch->SearchValue);
            $this->NOSEP->PlaceHolder = RemoveHtml($this->NOSEP->caption());

            // ID
            $this->ID->EditAttrs["class"] = "form-control";
            $this->ID->EditCustomAttributes = "";
            $this->ID->EditValue = HtmlEncode($this->ID->AdvancedSearch->SearchValue);
            $this->ID->PlaceHolder = RemoveHtml($this->ID->caption());

            // IDXDAFTAR
            $this->IDXDAFTAR->EditAttrs["class"] = "form-control";
            $this->IDXDAFTAR->EditCustomAttributes = "";
            $this->IDXDAFTAR->EditValue = HtmlEncode($this->IDXDAFTAR->AdvancedSearch->SearchValue);
            $this->IDXDAFTAR->PlaceHolder = RemoveHtml($this->IDXDAFTAR->caption());
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
        if (!CheckInteger($this->CLASS_ID->AdvancedSearch->SearchValue)) {
            $this->CLASS_ID->addErrorMessage($this->CLASS_ID->getErrorMessage(false));
        }
        if (!CheckEuroDate($this->TREAT_DATE->AdvancedSearch->SearchValue)) {
            $this->TREAT_DATE->addErrorMessage($this->TREAT_DATE->getErrorMessage(false));
        }
        if (!CheckNumber($this->AMOUNT->AdvancedSearch->SearchValue)) {
            $this->AMOUNT->addErrorMessage($this->AMOUNT->getErrorMessage(false));
        }
        if (!CheckNumber($this->QUANTITY->AdvancedSearch->SearchValue)) {
            $this->QUANTITY->addErrorMessage($this->QUANTITY->getErrorMessage(false));
        }
        if (!CheckInteger($this->MEASURE_ID->AdvancedSearch->SearchValue)) {
            $this->MEASURE_ID->addErrorMessage($this->MEASURE_ID->getErrorMessage(false));
        }
        if (!CheckNumber($this->POKOK_JUAL->AdvancedSearch->SearchValue)) {
            $this->POKOK_JUAL->addErrorMessage($this->POKOK_JUAL->getErrorMessage(false));
        }
        if (!CheckNumber($this->PPN->AdvancedSearch->SearchValue)) {
            $this->PPN->addErrorMessage($this->PPN->getErrorMessage(false));
        }
        if (!CheckNumber($this->MARGIN->AdvancedSearch->SearchValue)) {
            $this->MARGIN->addErrorMessage($this->MARGIN->getErrorMessage(false));
        }
        if (!CheckNumber($this->SUBSIDI->AdvancedSearch->SearchValue)) {
            $this->SUBSIDI->addErrorMessage($this->SUBSIDI->getErrorMessage(false));
        }
        if (!CheckNumber($this->EMBALACE->AdvancedSearch->SearchValue)) {
            $this->EMBALACE->addErrorMessage($this->EMBALACE->getErrorMessage(false));
        }
        if (!CheckNumber($this->PROFESI->AdvancedSearch->SearchValue)) {
            $this->PROFESI->addErrorMessage($this->PROFESI->getErrorMessage(false));
        }
        if (!CheckNumber($this->DISCOUNT->AdvancedSearch->SearchValue)) {
            $this->DISCOUNT->addErrorMessage($this->DISCOUNT->getErrorMessage(false));
        }
        if (!CheckInteger($this->PAY_METHOD_ID->AdvancedSearch->SearchValue)) {
            $this->PAY_METHOD_ID->addErrorMessage($this->PAY_METHOD_ID->getErrorMessage(false));
        }
        if (!CheckEuroDate($this->PAYMENT_DATE->AdvancedSearch->SearchValue)) {
            $this->PAYMENT_DATE->addErrorMessage($this->PAYMENT_DATE->getErrorMessage(false));
        }
        if (!CheckDate($this->DUEDATE_ANGSURAN->AdvancedSearch->SearchValue)) {
            $this->DUEDATE_ANGSURAN->addErrorMessage($this->DUEDATE_ANGSURAN->getErrorMessage(false));
        }
        if (!CheckDate($this->PRINT_DATE->AdvancedSearch->SearchValue)) {
            $this->PRINT_DATE->addErrorMessage($this->PRINT_DATE->getErrorMessage(false));
        }
        if (!CheckInteger($this->RESEP_KE->AdvancedSearch->SearchValue)) {
            $this->RESEP_KE->addErrorMessage($this->RESEP_KE->getErrorMessage(false));
        }
        if (!CheckNumber($this->DOSE->AdvancedSearch->SearchValue)) {
            $this->DOSE->addErrorMessage($this->DOSE->getErrorMessage(false));
        }
        if (!CheckNumber($this->ORIG_DOSE->AdvancedSearch->SearchValue)) {
            $this->ORIG_DOSE->addErrorMessage($this->ORIG_DOSE->getErrorMessage(false));
        }
        if (!CheckNumber($this->DOSE_PRESC->AdvancedSearch->SearchValue)) {
            $this->DOSE_PRESC->addErrorMessage($this->DOSE_PRESC->getErrorMessage(false));
        }
        if (!CheckInteger($this->ITER->AdvancedSearch->SearchValue)) {
            $this->ITER->addErrorMessage($this->ITER->getErrorMessage(false));
        }
        if (!CheckInteger($this->ITER_KE->AdvancedSearch->SearchValue)) {
            $this->ITER_KE->addErrorMessage($this->ITER_KE->getErrorMessage(false));
        }
        if (!CheckInteger($this->SOLD_STATUS->AdvancedSearch->SearchValue)) {
            $this->SOLD_STATUS->addErrorMessage($this->SOLD_STATUS->getErrorMessage(false));
        }
        if (!CheckInteger($this->RACIKAN->AdvancedSearch->SearchValue)) {
            $this->RACIKAN->addErrorMessage($this->RACIKAN->getErrorMessage(false));
        }
        if (!CheckInteger($this->KELUAR_ID->AdvancedSearch->SearchValue)) {
            $this->KELUAR_ID->addErrorMessage($this->KELUAR_ID->getErrorMessage(false));
        }
        if (!CheckInteger($this->BED_ID->AdvancedSearch->SearchValue)) {
            $this->BED_ID->addErrorMessage($this->BED_ID->getErrorMessage(false));
        }
        if (!CheckInteger($this->PERDA_ID->AdvancedSearch->SearchValue)) {
            $this->PERDA_ID->addErrorMessage($this->PERDA_ID->getErrorMessage(false));
        }
        if (!CheckDate($this->MODIFIED_DATE->AdvancedSearch->SearchValue)) {
            $this->MODIFIED_DATE->addErrorMessage($this->MODIFIED_DATE->getErrorMessage(false));
        }
        if (!CheckInteger($this->JML_BKS->AdvancedSearch->SearchValue)) {
            $this->JML_BKS->addErrorMessage($this->JML_BKS->getErrorMessage(false));
        }
        if (!CheckDate($this->EXIT_DATE->AdvancedSearch->SearchValue)) {
            $this->EXIT_DATE->addErrorMessage($this->EXIT_DATE->getErrorMessage(false));
        }
        if (!CheckInteger($this->FA_V->AdvancedSearch->SearchValue)) {
            $this->FA_V->addErrorMessage($this->FA_V->getErrorMessage(false));
        }
        if (!CheckInteger($this->TASK_ID->AdvancedSearch->SearchValue)) {
            $this->TASK_ID->addErrorMessage($this->TASK_ID->getErrorMessage(false));
        }
        if (!CheckInteger($this->status_pasien_id->AdvancedSearch->SearchValue)) {
            $this->status_pasien_id->addErrorMessage($this->status_pasien_id->getErrorMessage(false));
        }
        if (!CheckNumber($this->amount_paid->AdvancedSearch->SearchValue)) {
            $this->amount_paid->addErrorMessage($this->amount_paid->getErrorMessage(false));
        }
        if (!CheckNumber($this->AMOUNT_PLAFOND->AdvancedSearch->SearchValue)) {
            $this->AMOUNT_PLAFOND->addErrorMessage($this->AMOUNT_PLAFOND->getErrorMessage(false));
        }
        if (!CheckNumber($this->AMOUNT_PAID_PLAFOND->AdvancedSearch->SearchValue)) {
            $this->AMOUNT_PAID_PLAFOND->addErrorMessage($this->AMOUNT_PAID_PLAFOND->getErrorMessage(false));
        }
        if (!CheckInteger($this->CLASS_ID_PLAFOND->AdvancedSearch->SearchValue)) {
            $this->CLASS_ID_PLAFOND->addErrorMessage($this->CLASS_ID_PLAFOND->getErrorMessage(false));
        }
        if (!CheckNumber($this->PEMBULATAN->AdvancedSearch->SearchValue)) {
            $this->PEMBULATAN->addErrorMessage($this->PEMBULATAN->getErrorMessage(false));
        }
        if (!CheckInteger($this->AGEYEAR->AdvancedSearch->SearchValue)) {
            $this->AGEYEAR->addErrorMessage($this->AGEYEAR->getErrorMessage(false));
        }
        if (!CheckInteger($this->AGEMONTH->AdvancedSearch->SearchValue)) {
            $this->AGEMONTH->addErrorMessage($this->AGEMONTH->getErrorMessage(false));
        }
        if (!CheckInteger($this->AGEDAY->AdvancedSearch->SearchValue)) {
            $this->AGEDAY->addErrorMessage($this->AGEDAY->getErrorMessage(false));
        }
        if (!CheckNumber($this->sell_price->AdvancedSearch->SearchValue)) {
            $this->sell_price->addErrorMessage($this->sell_price->getErrorMessage(false));
        }
        if (!CheckNumber($this->diskon->AdvancedSearch->SearchValue)) {
            $this->diskon->addErrorMessage($this->diskon->getErrorMessage(false));
        }
        if (!CheckInteger($this->MEASURE_ID2->AdvancedSearch->SearchValue)) {
            $this->MEASURE_ID2->addErrorMessage($this->MEASURE_ID2->getErrorMessage(false));
        }
        if (!CheckNumber($this->POTONGAN->AdvancedSearch->SearchValue)) {
            $this->POTONGAN->addErrorMessage($this->POTONGAN->getErrorMessage(false));
        }
        if (!CheckNumber($this->BAYAR->AdvancedSearch->SearchValue)) {
            $this->BAYAR->addErrorMessage($this->BAYAR->getErrorMessage(false));
        }
        if (!CheckNumber($this->RETUR->AdvancedSearch->SearchValue)) {
            $this->RETUR->addErrorMessage($this->RETUR->getErrorMessage(false));
        }
        if (!CheckNumber($this->PPNVALUE->AdvancedSearch->SearchValue)) {
            $this->PPNVALUE->addErrorMessage($this->PPNVALUE->getErrorMessage(false));
        }
        if (!CheckNumber($this->TAGIHAN->AdvancedSearch->SearchValue)) {
            $this->TAGIHAN->addErrorMessage($this->TAGIHAN->getErrorMessage(false));
        }
        if (!CheckNumber($this->KOREKSI->AdvancedSearch->SearchValue)) {
            $this->KOREKSI->addErrorMessage($this->KOREKSI->getErrorMessage(false));
        }
        if (!CheckInteger($this->STATUS_OBAT->AdvancedSearch->SearchValue)) {
            $this->STATUS_OBAT->addErrorMessage($this->STATUS_OBAT->getErrorMessage(false));
        }
        if (!CheckNumber($this->SUBSIDISAT->AdvancedSearch->SearchValue)) {
            $this->SUBSIDISAT->addErrorMessage($this->SUBSIDISAT->getErrorMessage(false));
        }
        if (!CheckInteger($this->PRINTQ->AdvancedSearch->SearchValue)) {
            $this->PRINTQ->addErrorMessage($this->PRINTQ->getErrorMessage(false));
        }
        if (!CheckNumber($this->STOCK_AVAILABLE->AdvancedSearch->SearchValue)) {
            $this->STOCK_AVAILABLE->addErrorMessage($this->STOCK_AVAILABLE->getErrorMessage(false));
        }
        if (!CheckInteger($this->STATUS_TARIF->AdvancedSearch->SearchValue)) {
            $this->STATUS_TARIF->addErrorMessage($this->STATUS_TARIF->getErrorMessage(false));
        }
        if (!CheckInteger($this->CLINIC_TYPE->AdvancedSearch->SearchValue)) {
            $this->CLINIC_TYPE->addErrorMessage($this->CLINIC_TYPE->getErrorMessage(false));
        }
        if (!CheckNumber($this->profession->AdvancedSearch->SearchValue)) {
            $this->profession->addErrorMessage($this->profession->getErrorMessage(false));
        }
        if (!CheckInteger($this->THEORDER->AdvancedSearch->SearchValue)) {
            $this->THEORDER->addErrorMessage($this->THEORDER->getErrorMessage(false));
        }
        if (!CheckNumber($this->PERUJUKFEE->AdvancedSearch->SearchValue)) {
            $this->PERUJUKFEE->addErrorMessage($this->PERUJUKFEE->getErrorMessage(false));
        }
        if (!CheckDate($this->modified_datesys->AdvancedSearch->SearchValue)) {
            $this->modified_datesys->addErrorMessage($this->modified_datesys->getErrorMessage(false));
        }
        if (!CheckDate($this->SPPBILLDATE->AdvancedSearch->SearchValue)) {
            $this->SPPBILLDATE->addErrorMessage($this->SPPBILLDATE->getErrorMessage(false));
        }
        if (!CheckDate($this->SPPKASIRDATE->AdvancedSearch->SearchValue)) {
            $this->SPPKASIRDATE->addErrorMessage($this->SPPKASIRDATE->getErrorMessage(false));
        }
        if (!CheckDate($this->SPPPOLIDATE->AdvancedSearch->SearchValue)) {
            $this->SPPPOLIDATE->addErrorMessage($this->SPPPOLIDATE->getErrorMessage(false));
        }
        if (!CheckInteger($this->ID->AdvancedSearch->SearchValue)) {
            $this->ID->addErrorMessage($this->ID->getErrorMessage(false));
        }
        if (!CheckInteger($this->IDXDAFTAR->AdvancedSearch->SearchValue)) {
            $this->IDXDAFTAR->addErrorMessage($this->IDXDAFTAR->getErrorMessage(false));
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
        $this->IDXDAFTAR->AdvancedSearch->load();
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("TreatmentBillList"), "", $this->TableVar, true);
        $pageId = "search";
        $Breadcrumb->add("search", $pageId, $url);
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
                case "x_EMPLOYEE_ID":
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
