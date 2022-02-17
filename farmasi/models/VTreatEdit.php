<?php

namespace PHPMaker2021\SIMRS;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class VTreatEdit extends VTreat
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'V_TREAT';

    // Page object name
    public $PageObjName = "VTreatEdit";

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

        // Table object (V_TREAT)
        if (!isset($GLOBALS["V_TREAT"]) || get_class($GLOBALS["V_TREAT"]) == PROJECT_NAMESPACE . "V_TREAT") {
            $GLOBALS["V_TREAT"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'V_TREAT');
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
                $doc = new $class(Container("V_TREAT"));
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
                    if ($pageName == "VTreatView") {
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
    public $FormClassName = "ew-horizontal ew-form ew-edit-form";
    public $IsModal = false;
    public $IsMobileOrModal = false;
    public $DbMasterFilter;
    public $DbDetailFilter;
    public $HashValue; // Hash Value
    public $DisplayRecords = 1;
    public $StartRecord;
    public $StopRecord;
    public $TotalRecords = 0;
    public $RecordRange = 10;
    public $RecordCount;

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
        $this->QUANTITY->setVisibility();
        $this->MEASURE_ID->setVisibility();
        $this->DESCRIPTION->setVisibility();
        $this->RESEP_NO->setVisibility();
        $this->DOSE_PRESC->setVisibility();
        $this->SOLD_STATUS->setVisibility();
        $this->RACIKAN->setVisibility();
        $this->CLASS_ROOM_ID->setVisibility();
        $this->KELUAR_ID->setVisibility();
        $this->BED_ID->setVisibility();
        $this->EMPLOYEE_ID->setVisibility();
        $this->DESCRIPTION2->setVisibility();
        $this->BRAND_ID->setVisibility();
        $this->DOCTOR->setVisibility();
        $this->EXIT_DATE->setVisibility();
        $this->EMPLOYEE_ID_FROM->setVisibility();
        $this->DOCTOR_FROM->setVisibility();
        $this->status_pasien_id->setVisibility();
        $this->THENAME->setVisibility();
        $this->THEADDRESS->setVisibility();
        $this->THEID->setVisibility();
        $this->SERIAL_NB->setVisibility();
        $this->ISRJ->setVisibility();
        $this->AGEYEAR->setVisibility();
        $this->AGEMONTH->setVisibility();
        $this->AGEDAY->setVisibility();
        $this->GENDER->setVisibility();
        $this->KARYAWAN->setVisibility();
        $this->MODIFIED_BY->setVisibility();
        $this->MODIFIED_DATE->setVisibility();
        $this->MODIFIED_FROM->setVisibility();
        $this->NUMER->setVisibility();
        $this->NOTA_NO->setVisibility();
        $this->MEASURE_ID2->setVisibility();
        $this->POTONGAN->setVisibility();
        $this->BAYAR->setVisibility();
        $this->RETUR->setVisibility();
        $this->TARIF_TYPE->setVisibility();
        $this->PPNVALUE->setVisibility();
        $this->TAGIHAN->setVisibility();
        $this->KOREKSI->setVisibility();
        $this->AMOUNT_PAID->setVisibility();
        $this->DISKON->setVisibility();
        $this->SELL_PRICE->setVisibility();
        $this->ACCOUNT_ID->setVisibility();
        $this->subsidi->setVisibility();
        $this->PROFESI->setVisibility();
        $this->EMBALACE->setVisibility();
        $this->DISCOUNT->setVisibility();
        $this->AMOUNT->setVisibility();
        $this->PPN->setVisibility();
        $this->ITER->setVisibility();
        $this->PAYOR_ID->setVisibility();
        $this->STATUS_OBAT->setVisibility();
        $this->SUBSIDISAT->setVisibility();
        $this->MARGIN->setVisibility();
        $this->POKOK_JUAL->setVisibility();
        $this->PRINTQ->setVisibility();
        $this->PRINTED_BY->setVisibility();
        $this->STOCK_AVAILABLE->setVisibility();
        $this->STATUS_TARIF->setVisibility();
        $this->PACKAGE_ID->setVisibility();
        $this->MODULE_ID->setVisibility();
        $this->profession->setVisibility();
        $this->THEORDER->setVisibility();
        $this->CORRECTION_ID->setVisibility();
        $this->CORRECTION_BY->setVisibility();
        $this->CASHIER->setVisibility();
        $this->islunas->setVisibility();
        $this->PAY_METHOD_ID->setVisibility();
        $this->PAYMENT_DATE->setVisibility();
        $this->ISCETAK->setVisibility();
        $this->print_date->setVisibility();
        $this->DOSE->setVisibility();
        $this->JML_BKS->setVisibility();
        $this->ORIG_DOSE->setVisibility();
        $this->RESEP_KE->setVisibility();
        $this->ITER_KE->setVisibility();
        $this->KUITANSI_ID->setVisibility();
        $this->PEMBULATAN->setVisibility();
        $this->KAL_ID->setVisibility();
        $this->INVOICE_ID->setVisibility();
        $this->SERVICE_TIME->setVisibility();
        $this->TAKEN_TIME->setVisibility();
        $this->modified_datesys->setVisibility();
        $this->TRANS_ID->setVisibility();
        $this->SPPBILL->setVisibility();
        $this->SPPBILLDATE->setVisibility();
        $this->SPPBILLUSER->setVisibility();
        $this->SPPKASIR->setVisibility();
        $this->SPPKASIRDATE->setVisibility();
        $this->SPPKASIRUSER->setVisibility();
        $this->SPPPOLI->setVisibility();
        $this->SPPPOLIUSER->setVisibility();
        $this->SPPPOLIDATE->setVisibility();
        $this->NOSEP->setVisibility();
        $this->ID->setVisibility();
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
        $this->FormClassName = "ew-form ew-edit-form ew-horizontal";
        $loaded = false;
        $postBack = false;

        // Set up current action and primary key
        if (IsApi()) {
            // Load key values
            $loaded = true;
            if (($keyValue = Get("ID") ?? Key(0) ?? Route(2)) !== null) {
                $this->ID->setQueryStringValue($keyValue);
                $this->ID->setOldValue($this->ID->QueryStringValue);
            } elseif (Post("ID") !== null) {
                $this->ID->setFormValue(Post("ID"));
                $this->ID->setOldValue($this->ID->FormValue);
            } else {
                $loaded = false; // Unable to load key
            }

            // Load record
            if ($loaded) {
                $loaded = $this->loadRow();
            }
            if (!$loaded) {
                $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
                $this->terminate();
                return;
            }
            $this->CurrentAction = "update"; // Update record directly
            $this->OldKey = $this->getKey(true); // Get from CurrentValue
            $postBack = true;
        } else {
            if (Post("action") !== null) {
                $this->CurrentAction = Post("action"); // Get action code
                if (!$this->isShow()) { // Not reload record, handle as postback
                    $postBack = true;
                }

                // Get key from Form
                $this->setKey(Post($this->OldKeyName), $this->isShow());
            } else {
                $this->CurrentAction = "show"; // Default action is display

                // Load key from QueryString
                $loadByQuery = false;
                if (($keyValue = Get("ID") ?? Route("ID")) !== null) {
                    $this->ID->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->ID->CurrentValue = null;
                }
            }

            // Set up master detail parameters
            $this->setupMasterParms();

            // Load recordset
            if ($this->isShow()) {
                // Load current record
                $loaded = $this->loadRow();
                $this->OldKey = $loaded ? $this->getKey(true) : ""; // Get from CurrentValue
            }
        }

        // Process form if post back
        if ($postBack) {
            $this->loadFormValues(); // Get form values
        }

        // Validate form if post back
        if ($postBack) {
            if (!$this->validateForm()) {
                $this->EventCancelled = true; // Event cancelled
                $this->restoreFormValues();
                if (IsApi()) {
                    $this->terminate();
                    return;
                } else {
                    $this->CurrentAction = ""; // Form error, reset action
                }
            }
        }

        // Perform current action
        switch ($this->CurrentAction) {
            case "show": // Get a record to display
                if (!$loaded) { // Load record based on key
                    if ($this->getFailureMessage() == "") {
                        $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
                    }
                    $this->terminate("VTreatList"); // No matching record, return to list
                    return;
                }
                break;
            case "update": // Update
                $returnUrl = $this->getReturnUrl();
                if (GetPageName($returnUrl) == "VTreatList") {
                    $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                }
                $this->SendEmail = true; // Send email on update success
                if ($this->editRow()) { // Update record based on key
                    if ($this->getSuccessMessage() == "") {
                        $this->setSuccessMessage($Language->phrase("UpdateSuccess")); // Update success
                    }
                    if (IsApi()) {
                        $this->terminate(true);
                        return;
                    } else {
                        $this->terminate($returnUrl); // Return to caller
                        return;
                    }
                } elseif (IsApi()) { // API request, return
                    $this->terminate();
                    return;
                } elseif ($this->getFailureMessage() == $Language->phrase("NoRecord")) {
                    $this->terminate($returnUrl); // Return to caller
                    return;
                } else {
                    $this->EventCancelled = true; // Event cancelled
                    $this->restoreFormValues(); // Restore form values if update failed
                }
        }

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Render the record
        $this->RowType = ROWTYPE_EDIT; // Render as Edit
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

        // Check field name 'DESCRIPTION' first before field var 'x_DESCRIPTION'
        $val = $CurrentForm->hasValue("DESCRIPTION") ? $CurrentForm->getValue("DESCRIPTION") : $CurrentForm->getValue("x_DESCRIPTION");
        if (!$this->DESCRIPTION->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->DESCRIPTION->Visible = false; // Disable update for API request
            } else {
                $this->DESCRIPTION->setFormValue($val);
            }
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

        // Check field name 'DOSE_PRESC' first before field var 'x_DOSE_PRESC'
        $val = $CurrentForm->hasValue("DOSE_PRESC") ? $CurrentForm->getValue("DOSE_PRESC") : $CurrentForm->getValue("x_DOSE_PRESC");
        if (!$this->DOSE_PRESC->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->DOSE_PRESC->Visible = false; // Disable update for API request
            } else {
                $this->DOSE_PRESC->setFormValue($val);
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

        // Check field name 'SERIAL_NB' first before field var 'x_SERIAL_NB'
        $val = $CurrentForm->hasValue("SERIAL_NB") ? $CurrentForm->getValue("SERIAL_NB") : $CurrentForm->getValue("x_SERIAL_NB");
        if (!$this->SERIAL_NB->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->SERIAL_NB->Visible = false; // Disable update for API request
            } else {
                $this->SERIAL_NB->setFormValue($val);
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

        // Check field name 'KARYAWAN' first before field var 'x_KARYAWAN'
        $val = $CurrentForm->hasValue("KARYAWAN") ? $CurrentForm->getValue("KARYAWAN") : $CurrentForm->getValue("x_KARYAWAN");
        if (!$this->KARYAWAN->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->KARYAWAN->Visible = false; // Disable update for API request
            } else {
                $this->KARYAWAN->setFormValue($val);
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

        // Check field name 'NUMER' first before field var 'x_NUMER'
        $val = $CurrentForm->hasValue("NUMER") ? $CurrentForm->getValue("NUMER") : $CurrentForm->getValue("x_NUMER");
        if (!$this->NUMER->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->NUMER->Visible = false; // Disable update for API request
            } else {
                $this->NUMER->setFormValue($val);
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

        // Check field name 'AMOUNT_PAID' first before field var 'x_AMOUNT_PAID'
        $val = $CurrentForm->hasValue("AMOUNT_PAID") ? $CurrentForm->getValue("AMOUNT_PAID") : $CurrentForm->getValue("x_AMOUNT_PAID");
        if (!$this->AMOUNT_PAID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->AMOUNT_PAID->Visible = false; // Disable update for API request
            } else {
                $this->AMOUNT_PAID->setFormValue($val);
            }
        }

        // Check field name 'DISKON' first before field var 'x_DISKON'
        $val = $CurrentForm->hasValue("DISKON") ? $CurrentForm->getValue("DISKON") : $CurrentForm->getValue("x_DISKON");
        if (!$this->DISKON->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->DISKON->Visible = false; // Disable update for API request
            } else {
                $this->DISKON->setFormValue($val);
            }
        }

        // Check field name 'SELL_PRICE' first before field var 'x_SELL_PRICE'
        $val = $CurrentForm->hasValue("SELL_PRICE") ? $CurrentForm->getValue("SELL_PRICE") : $CurrentForm->getValue("x_SELL_PRICE");
        if (!$this->SELL_PRICE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->SELL_PRICE->Visible = false; // Disable update for API request
            } else {
                $this->SELL_PRICE->setFormValue($val);
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

        // Check field name 'subsidi' first before field var 'x_subsidi'
        $val = $CurrentForm->hasValue("subsidi") ? $CurrentForm->getValue("subsidi") : $CurrentForm->getValue("x_subsidi");
        if (!$this->subsidi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->subsidi->Visible = false; // Disable update for API request
            } else {
                $this->subsidi->setFormValue($val);
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

        // Check field name 'EMBALACE' first before field var 'x_EMBALACE'
        $val = $CurrentForm->hasValue("EMBALACE") ? $CurrentForm->getValue("EMBALACE") : $CurrentForm->getValue("x_EMBALACE");
        if (!$this->EMBALACE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->EMBALACE->Visible = false; // Disable update for API request
            } else {
                $this->EMBALACE->setFormValue($val);
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

        // Check field name 'AMOUNT' first before field var 'x_AMOUNT'
        $val = $CurrentForm->hasValue("AMOUNT") ? $CurrentForm->getValue("AMOUNT") : $CurrentForm->getValue("x_AMOUNT");
        if (!$this->AMOUNT->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->AMOUNT->Visible = false; // Disable update for API request
            } else {
                $this->AMOUNT->setFormValue($val);
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

        // Check field name 'ITER' first before field var 'x_ITER'
        $val = $CurrentForm->hasValue("ITER") ? $CurrentForm->getValue("ITER") : $CurrentForm->getValue("x_ITER");
        if (!$this->ITER->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ITER->Visible = false; // Disable update for API request
            } else {
                $this->ITER->setFormValue($val);
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

        // Check field name 'MARGIN' first before field var 'x_MARGIN'
        $val = $CurrentForm->hasValue("MARGIN") ? $CurrentForm->getValue("MARGIN") : $CurrentForm->getValue("x_MARGIN");
        if (!$this->MARGIN->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->MARGIN->Visible = false; // Disable update for API request
            } else {
                $this->MARGIN->setFormValue($val);
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

        // Check field name 'CASHIER' first before field var 'x_CASHIER'
        $val = $CurrentForm->hasValue("CASHIER") ? $CurrentForm->getValue("CASHIER") : $CurrentForm->getValue("x_CASHIER");
        if (!$this->CASHIER->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->CASHIER->Visible = false; // Disable update for API request
            } else {
                $this->CASHIER->setFormValue($val);
            }
        }

        // Check field name 'islunas' first before field var 'x_islunas'
        $val = $CurrentForm->hasValue("islunas") ? $CurrentForm->getValue("islunas") : $CurrentForm->getValue("x_islunas");
        if (!$this->islunas->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->islunas->Visible = false; // Disable update for API request
            } else {
                $this->islunas->setFormValue($val);
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

        // Check field name 'ISCETAK' first before field var 'x_ISCETAK'
        $val = $CurrentForm->hasValue("ISCETAK") ? $CurrentForm->getValue("ISCETAK") : $CurrentForm->getValue("x_ISCETAK");
        if (!$this->ISCETAK->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ISCETAK->Visible = false; // Disable update for API request
            } else {
                $this->ISCETAK->setFormValue($val);
            }
        }

        // Check field name 'print_date' first before field var 'x_print_date'
        $val = $CurrentForm->hasValue("print_date") ? $CurrentForm->getValue("print_date") : $CurrentForm->getValue("x_print_date");
        if (!$this->print_date->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->print_date->Visible = false; // Disable update for API request
            } else {
                $this->print_date->setFormValue($val);
            }
            $this->print_date->CurrentValue = UnFormatDateTime($this->print_date->CurrentValue, 0);
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

        // Check field name 'JML_BKS' first before field var 'x_JML_BKS'
        $val = $CurrentForm->hasValue("JML_BKS") ? $CurrentForm->getValue("JML_BKS") : $CurrentForm->getValue("x_JML_BKS");
        if (!$this->JML_BKS->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->JML_BKS->Visible = false; // Disable update for API request
            } else {
                $this->JML_BKS->setFormValue($val);
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

        // Check field name 'RESEP_KE' first before field var 'x_RESEP_KE'
        $val = $CurrentForm->hasValue("RESEP_KE") ? $CurrentForm->getValue("RESEP_KE") : $CurrentForm->getValue("x_RESEP_KE");
        if (!$this->RESEP_KE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->RESEP_KE->Visible = false; // Disable update for API request
            } else {
                $this->RESEP_KE->setFormValue($val);
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

        // Check field name 'KUITANSI_ID' first before field var 'x_KUITANSI_ID'
        $val = $CurrentForm->hasValue("KUITANSI_ID") ? $CurrentForm->getValue("KUITANSI_ID") : $CurrentForm->getValue("x_KUITANSI_ID");
        if (!$this->KUITANSI_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->KUITANSI_ID->Visible = false; // Disable update for API request
            } else {
                $this->KUITANSI_ID->setFormValue($val);
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

        // Check field name 'KAL_ID' first before field var 'x_KAL_ID'
        $val = $CurrentForm->hasValue("KAL_ID") ? $CurrentForm->getValue("KAL_ID") : $CurrentForm->getValue("x_KAL_ID");
        if (!$this->KAL_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->KAL_ID->Visible = false; // Disable update for API request
            } else {
                $this->KAL_ID->setFormValue($val);
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

        // Check field name 'SERVICE_TIME' first before field var 'x_SERVICE_TIME'
        $val = $CurrentForm->hasValue("SERVICE_TIME") ? $CurrentForm->getValue("SERVICE_TIME") : $CurrentForm->getValue("x_SERVICE_TIME");
        if (!$this->SERVICE_TIME->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->SERVICE_TIME->Visible = false; // Disable update for API request
            } else {
                $this->SERVICE_TIME->setFormValue($val);
            }
            $this->SERVICE_TIME->CurrentValue = UnFormatDateTime($this->SERVICE_TIME->CurrentValue, 0);
        }

        // Check field name 'TAKEN_TIME' first before field var 'x_TAKEN_TIME'
        $val = $CurrentForm->hasValue("TAKEN_TIME") ? $CurrentForm->getValue("TAKEN_TIME") : $CurrentForm->getValue("x_TAKEN_TIME");
        if (!$this->TAKEN_TIME->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->TAKEN_TIME->Visible = false; // Disable update for API request
            } else {
                $this->TAKEN_TIME->setFormValue($val);
            }
            $this->TAKEN_TIME->CurrentValue = UnFormatDateTime($this->TAKEN_TIME->CurrentValue, 0);
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

        // Check field name 'SPPBILL' first before field var 'x_SPPBILL'
        $val = $CurrentForm->hasValue("SPPBILL") ? $CurrentForm->getValue("SPPBILL") : $CurrentForm->getValue("x_SPPBILL");
        if (!$this->SPPBILL->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->SPPBILL->Visible = false; // Disable update for API request
            } else {
                $this->SPPBILL->setFormValue($val);
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

        // Check field name 'SPPKASIR' first before field var 'x_SPPKASIR'
        $val = $CurrentForm->hasValue("SPPKASIR") ? $CurrentForm->getValue("SPPKASIR") : $CurrentForm->getValue("x_SPPKASIR");
        if (!$this->SPPKASIR->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->SPPKASIR->Visible = false; // Disable update for API request
            } else {
                $this->SPPKASIR->setFormValue($val);
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

        // Check field name 'NOSEP' first before field var 'x_NOSEP'
        $val = $CurrentForm->hasValue("NOSEP") ? $CurrentForm->getValue("NOSEP") : $CurrentForm->getValue("x_NOSEP");
        if (!$this->NOSEP->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->NOSEP->Visible = false; // Disable update for API request
            } else {
                $this->NOSEP->setFormValue($val);
            }
        }

        // Check field name 'ID' first before field var 'x_ID'
        $val = $CurrentForm->hasValue("ID") ? $CurrentForm->getValue("ID") : $CurrentForm->getValue("x_ID");
        if (!$this->ID->IsDetailKey) {
            $this->ID->setFormValue($val);
        }
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
        $this->QUANTITY->CurrentValue = $this->QUANTITY->FormValue;
        $this->MEASURE_ID->CurrentValue = $this->MEASURE_ID->FormValue;
        $this->DESCRIPTION->CurrentValue = $this->DESCRIPTION->FormValue;
        $this->RESEP_NO->CurrentValue = $this->RESEP_NO->FormValue;
        $this->DOSE_PRESC->CurrentValue = $this->DOSE_PRESC->FormValue;
        $this->SOLD_STATUS->CurrentValue = $this->SOLD_STATUS->FormValue;
        $this->RACIKAN->CurrentValue = $this->RACIKAN->FormValue;
        $this->CLASS_ROOM_ID->CurrentValue = $this->CLASS_ROOM_ID->FormValue;
        $this->KELUAR_ID->CurrentValue = $this->KELUAR_ID->FormValue;
        $this->BED_ID->CurrentValue = $this->BED_ID->FormValue;
        $this->EMPLOYEE_ID->CurrentValue = $this->EMPLOYEE_ID->FormValue;
        $this->DESCRIPTION2->CurrentValue = $this->DESCRIPTION2->FormValue;
        $this->BRAND_ID->CurrentValue = $this->BRAND_ID->FormValue;
        $this->DOCTOR->CurrentValue = $this->DOCTOR->FormValue;
        $this->EXIT_DATE->CurrentValue = $this->EXIT_DATE->FormValue;
        $this->EXIT_DATE->CurrentValue = UnFormatDateTime($this->EXIT_DATE->CurrentValue, 0);
        $this->EMPLOYEE_ID_FROM->CurrentValue = $this->EMPLOYEE_ID_FROM->FormValue;
        $this->DOCTOR_FROM->CurrentValue = $this->DOCTOR_FROM->FormValue;
        $this->status_pasien_id->CurrentValue = $this->status_pasien_id->FormValue;
        $this->THENAME->CurrentValue = $this->THENAME->FormValue;
        $this->THEADDRESS->CurrentValue = $this->THEADDRESS->FormValue;
        $this->THEID->CurrentValue = $this->THEID->FormValue;
        $this->SERIAL_NB->CurrentValue = $this->SERIAL_NB->FormValue;
        $this->ISRJ->CurrentValue = $this->ISRJ->FormValue;
        $this->AGEYEAR->CurrentValue = $this->AGEYEAR->FormValue;
        $this->AGEMONTH->CurrentValue = $this->AGEMONTH->FormValue;
        $this->AGEDAY->CurrentValue = $this->AGEDAY->FormValue;
        $this->GENDER->CurrentValue = $this->GENDER->FormValue;
        $this->KARYAWAN->CurrentValue = $this->KARYAWAN->FormValue;
        $this->MODIFIED_BY->CurrentValue = $this->MODIFIED_BY->FormValue;
        $this->MODIFIED_DATE->CurrentValue = $this->MODIFIED_DATE->FormValue;
        $this->MODIFIED_DATE->CurrentValue = UnFormatDateTime($this->MODIFIED_DATE->CurrentValue, 0);
        $this->MODIFIED_FROM->CurrentValue = $this->MODIFIED_FROM->FormValue;
        $this->NUMER->CurrentValue = $this->NUMER->FormValue;
        $this->NOTA_NO->CurrentValue = $this->NOTA_NO->FormValue;
        $this->MEASURE_ID2->CurrentValue = $this->MEASURE_ID2->FormValue;
        $this->POTONGAN->CurrentValue = $this->POTONGAN->FormValue;
        $this->BAYAR->CurrentValue = $this->BAYAR->FormValue;
        $this->RETUR->CurrentValue = $this->RETUR->FormValue;
        $this->TARIF_TYPE->CurrentValue = $this->TARIF_TYPE->FormValue;
        $this->PPNVALUE->CurrentValue = $this->PPNVALUE->FormValue;
        $this->TAGIHAN->CurrentValue = $this->TAGIHAN->FormValue;
        $this->KOREKSI->CurrentValue = $this->KOREKSI->FormValue;
        $this->AMOUNT_PAID->CurrentValue = $this->AMOUNT_PAID->FormValue;
        $this->DISKON->CurrentValue = $this->DISKON->FormValue;
        $this->SELL_PRICE->CurrentValue = $this->SELL_PRICE->FormValue;
        $this->ACCOUNT_ID->CurrentValue = $this->ACCOUNT_ID->FormValue;
        $this->subsidi->CurrentValue = $this->subsidi->FormValue;
        $this->PROFESI->CurrentValue = $this->PROFESI->FormValue;
        $this->EMBALACE->CurrentValue = $this->EMBALACE->FormValue;
        $this->DISCOUNT->CurrentValue = $this->DISCOUNT->FormValue;
        $this->AMOUNT->CurrentValue = $this->AMOUNT->FormValue;
        $this->PPN->CurrentValue = $this->PPN->FormValue;
        $this->ITER->CurrentValue = $this->ITER->FormValue;
        $this->PAYOR_ID->CurrentValue = $this->PAYOR_ID->FormValue;
        $this->STATUS_OBAT->CurrentValue = $this->STATUS_OBAT->FormValue;
        $this->SUBSIDISAT->CurrentValue = $this->SUBSIDISAT->FormValue;
        $this->MARGIN->CurrentValue = $this->MARGIN->FormValue;
        $this->POKOK_JUAL->CurrentValue = $this->POKOK_JUAL->FormValue;
        $this->PRINTQ->CurrentValue = $this->PRINTQ->FormValue;
        $this->PRINTED_BY->CurrentValue = $this->PRINTED_BY->FormValue;
        $this->STOCK_AVAILABLE->CurrentValue = $this->STOCK_AVAILABLE->FormValue;
        $this->STATUS_TARIF->CurrentValue = $this->STATUS_TARIF->FormValue;
        $this->PACKAGE_ID->CurrentValue = $this->PACKAGE_ID->FormValue;
        $this->MODULE_ID->CurrentValue = $this->MODULE_ID->FormValue;
        $this->profession->CurrentValue = $this->profession->FormValue;
        $this->THEORDER->CurrentValue = $this->THEORDER->FormValue;
        $this->CORRECTION_ID->CurrentValue = $this->CORRECTION_ID->FormValue;
        $this->CORRECTION_BY->CurrentValue = $this->CORRECTION_BY->FormValue;
        $this->CASHIER->CurrentValue = $this->CASHIER->FormValue;
        $this->islunas->CurrentValue = $this->islunas->FormValue;
        $this->PAY_METHOD_ID->CurrentValue = $this->PAY_METHOD_ID->FormValue;
        $this->PAYMENT_DATE->CurrentValue = $this->PAYMENT_DATE->FormValue;
        $this->PAYMENT_DATE->CurrentValue = UnFormatDateTime($this->PAYMENT_DATE->CurrentValue, 0);
        $this->ISCETAK->CurrentValue = $this->ISCETAK->FormValue;
        $this->print_date->CurrentValue = $this->print_date->FormValue;
        $this->print_date->CurrentValue = UnFormatDateTime($this->print_date->CurrentValue, 0);
        $this->DOSE->CurrentValue = $this->DOSE->FormValue;
        $this->JML_BKS->CurrentValue = $this->JML_BKS->FormValue;
        $this->ORIG_DOSE->CurrentValue = $this->ORIG_DOSE->FormValue;
        $this->RESEP_KE->CurrentValue = $this->RESEP_KE->FormValue;
        $this->ITER_KE->CurrentValue = $this->ITER_KE->FormValue;
        $this->KUITANSI_ID->CurrentValue = $this->KUITANSI_ID->FormValue;
        $this->PEMBULATAN->CurrentValue = $this->PEMBULATAN->FormValue;
        $this->KAL_ID->CurrentValue = $this->KAL_ID->FormValue;
        $this->INVOICE_ID->CurrentValue = $this->INVOICE_ID->FormValue;
        $this->SERVICE_TIME->CurrentValue = $this->SERVICE_TIME->FormValue;
        $this->SERVICE_TIME->CurrentValue = UnFormatDateTime($this->SERVICE_TIME->CurrentValue, 0);
        $this->TAKEN_TIME->CurrentValue = $this->TAKEN_TIME->FormValue;
        $this->TAKEN_TIME->CurrentValue = UnFormatDateTime($this->TAKEN_TIME->CurrentValue, 0);
        $this->modified_datesys->CurrentValue = $this->modified_datesys->FormValue;
        $this->modified_datesys->CurrentValue = UnFormatDateTime($this->modified_datesys->CurrentValue, 0);
        $this->TRANS_ID->CurrentValue = $this->TRANS_ID->FormValue;
        $this->SPPBILL->CurrentValue = $this->SPPBILL->FormValue;
        $this->SPPBILLDATE->CurrentValue = $this->SPPBILLDATE->FormValue;
        $this->SPPBILLDATE->CurrentValue = UnFormatDateTime($this->SPPBILLDATE->CurrentValue, 0);
        $this->SPPBILLUSER->CurrentValue = $this->SPPBILLUSER->FormValue;
        $this->SPPKASIR->CurrentValue = $this->SPPKASIR->FormValue;
        $this->SPPKASIRDATE->CurrentValue = $this->SPPKASIRDATE->FormValue;
        $this->SPPKASIRDATE->CurrentValue = UnFormatDateTime($this->SPPKASIRDATE->CurrentValue, 0);
        $this->SPPKASIRUSER->CurrentValue = $this->SPPKASIRUSER->FormValue;
        $this->SPPPOLI->CurrentValue = $this->SPPPOLI->FormValue;
        $this->SPPPOLIUSER->CurrentValue = $this->SPPPOLIUSER->FormValue;
        $this->SPPPOLIDATE->CurrentValue = $this->SPPPOLIDATE->FormValue;
        $this->SPPPOLIDATE->CurrentValue = UnFormatDateTime($this->SPPPOLIDATE->CurrentValue, 0);
        $this->NOSEP->CurrentValue = $this->NOSEP->FormValue;
        $this->ID->CurrentValue = $this->ID->FormValue;
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
        $this->QUANTITY->setDbValue($row['QUANTITY']);
        $this->MEASURE_ID->setDbValue($row['MEASURE_ID']);
        $this->DESCRIPTION->setDbValue($row['DESCRIPTION']);
        $this->RESEP_NO->setDbValue($row['RESEP_NO']);
        $this->DOSE_PRESC->setDbValue($row['DOSE_PRESC']);
        $this->SOLD_STATUS->setDbValue($row['SOLD_STATUS']);
        $this->RACIKAN->setDbValue($row['RACIKAN']);
        $this->CLASS_ROOM_ID->setDbValue($row['CLASS_ROOM_ID']);
        $this->KELUAR_ID->setDbValue($row['KELUAR_ID']);
        $this->BED_ID->setDbValue($row['BED_ID']);
        $this->EMPLOYEE_ID->setDbValue($row['EMPLOYEE_ID']);
        $this->DESCRIPTION2->setDbValue($row['DESCRIPTION2']);
        $this->BRAND_ID->setDbValue($row['BRAND_ID']);
        $this->DOCTOR->setDbValue($row['DOCTOR']);
        $this->EXIT_DATE->setDbValue($row['EXIT_DATE']);
        $this->EMPLOYEE_ID_FROM->setDbValue($row['EMPLOYEE_ID_FROM']);
        $this->DOCTOR_FROM->setDbValue($row['DOCTOR_FROM']);
        $this->status_pasien_id->setDbValue($row['status_pasien_id']);
        $this->THENAME->setDbValue($row['THENAME']);
        $this->THEADDRESS->setDbValue($row['THEADDRESS']);
        $this->THEID->setDbValue($row['THEID']);
        $this->SERIAL_NB->setDbValue($row['SERIAL_NB']);
        $this->ISRJ->setDbValue($row['ISRJ']);
        $this->AGEYEAR->setDbValue($row['AGEYEAR']);
        $this->AGEMONTH->setDbValue($row['AGEMONTH']);
        $this->AGEDAY->setDbValue($row['AGEDAY']);
        $this->GENDER->setDbValue($row['GENDER']);
        $this->KARYAWAN->setDbValue($row['KARYAWAN']);
        $this->MODIFIED_BY->setDbValue($row['MODIFIED_BY']);
        $this->MODIFIED_DATE->setDbValue($row['MODIFIED_DATE']);
        $this->MODIFIED_FROM->setDbValue($row['MODIFIED_FROM']);
        $this->NUMER->setDbValue($row['NUMER']);
        $this->NOTA_NO->setDbValue($row['NOTA_NO']);
        $this->MEASURE_ID2->setDbValue($row['MEASURE_ID2']);
        $this->POTONGAN->setDbValue($row['POTONGAN']);
        $this->BAYAR->setDbValue($row['BAYAR']);
        $this->RETUR->setDbValue($row['RETUR']);
        $this->TARIF_TYPE->setDbValue($row['TARIF_TYPE']);
        $this->PPNVALUE->setDbValue($row['PPNVALUE']);
        $this->TAGIHAN->setDbValue($row['TAGIHAN']);
        $this->KOREKSI->setDbValue($row['KOREKSI']);
        $this->AMOUNT_PAID->setDbValue($row['AMOUNT_PAID']);
        $this->DISKON->setDbValue($row['DISKON']);
        $this->SELL_PRICE->setDbValue($row['SELL_PRICE']);
        $this->ACCOUNT_ID->setDbValue($row['ACCOUNT_ID']);
        $this->subsidi->setDbValue($row['subsidi']);
        $this->PROFESI->setDbValue($row['PROFESI']);
        $this->EMBALACE->setDbValue($row['EMBALACE']);
        $this->DISCOUNT->setDbValue($row['DISCOUNT']);
        $this->AMOUNT->setDbValue($row['AMOUNT']);
        $this->PPN->setDbValue($row['PPN']);
        $this->ITER->setDbValue($row['ITER']);
        $this->PAYOR_ID->setDbValue($row['PAYOR_ID']);
        $this->STATUS_OBAT->setDbValue($row['STATUS_OBAT']);
        $this->SUBSIDISAT->setDbValue($row['SUBSIDISAT']);
        $this->MARGIN->setDbValue($row['MARGIN']);
        $this->POKOK_JUAL->setDbValue($row['POKOK_JUAL']);
        $this->PRINTQ->setDbValue($row['PRINTQ']);
        $this->PRINTED_BY->setDbValue($row['PRINTED_BY']);
        $this->STOCK_AVAILABLE->setDbValue($row['STOCK_AVAILABLE']);
        $this->STATUS_TARIF->setDbValue($row['STATUS_TARIF']);
        $this->PACKAGE_ID->setDbValue($row['PACKAGE_ID']);
        $this->MODULE_ID->setDbValue($row['MODULE_ID']);
        $this->profession->setDbValue($row['profession']);
        $this->THEORDER->setDbValue($row['THEORDER']);
        $this->CORRECTION_ID->setDbValue($row['CORRECTION_ID']);
        $this->CORRECTION_BY->setDbValue($row['CORRECTION_BY']);
        $this->CASHIER->setDbValue($row['CASHIER']);
        $this->islunas->setDbValue($row['islunas']);
        $this->PAY_METHOD_ID->setDbValue($row['PAY_METHOD_ID']);
        $this->PAYMENT_DATE->setDbValue($row['PAYMENT_DATE']);
        $this->ISCETAK->setDbValue($row['ISCETAK']);
        $this->print_date->setDbValue($row['print_date']);
        $this->DOSE->setDbValue($row['DOSE']);
        $this->JML_BKS->setDbValue($row['JML_BKS']);
        $this->ORIG_DOSE->setDbValue($row['ORIG_DOSE']);
        $this->RESEP_KE->setDbValue($row['RESEP_KE']);
        $this->ITER_KE->setDbValue($row['ITER_KE']);
        $this->KUITANSI_ID->setDbValue($row['KUITANSI_ID']);
        $this->PEMBULATAN->setDbValue($row['PEMBULATAN']);
        $this->KAL_ID->setDbValue($row['KAL_ID']);
        $this->INVOICE_ID->setDbValue($row['INVOICE_ID']);
        $this->SERVICE_TIME->setDbValue($row['SERVICE_TIME']);
        $this->TAKEN_TIME->setDbValue($row['TAKEN_TIME']);
        $this->modified_datesys->setDbValue($row['modified_datesys']);
        $this->TRANS_ID->setDbValue($row['TRANS_ID']);
        $this->SPPBILL->setDbValue($row['SPPBILL']);
        $this->SPPBILLDATE->setDbValue($row['SPPBILLDATE']);
        $this->SPPBILLUSER->setDbValue($row['SPPBILLUSER']);
        $this->SPPKASIR->setDbValue($row['SPPKASIR']);
        $this->SPPKASIRDATE->setDbValue($row['SPPKASIRDATE']);
        $this->SPPKASIRUSER->setDbValue($row['SPPKASIRUSER']);
        $this->SPPPOLI->setDbValue($row['SPPPOLI']);
        $this->SPPPOLIUSER->setDbValue($row['SPPPOLIUSER']);
        $this->SPPPOLIDATE->setDbValue($row['SPPPOLIDATE']);
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
        $row['QUANTITY'] = null;
        $row['MEASURE_ID'] = null;
        $row['DESCRIPTION'] = null;
        $row['RESEP_NO'] = null;
        $row['DOSE_PRESC'] = null;
        $row['SOLD_STATUS'] = null;
        $row['RACIKAN'] = null;
        $row['CLASS_ROOM_ID'] = null;
        $row['KELUAR_ID'] = null;
        $row['BED_ID'] = null;
        $row['EMPLOYEE_ID'] = null;
        $row['DESCRIPTION2'] = null;
        $row['BRAND_ID'] = null;
        $row['DOCTOR'] = null;
        $row['EXIT_DATE'] = null;
        $row['EMPLOYEE_ID_FROM'] = null;
        $row['DOCTOR_FROM'] = null;
        $row['status_pasien_id'] = null;
        $row['THENAME'] = null;
        $row['THEADDRESS'] = null;
        $row['THEID'] = null;
        $row['SERIAL_NB'] = null;
        $row['ISRJ'] = null;
        $row['AGEYEAR'] = null;
        $row['AGEMONTH'] = null;
        $row['AGEDAY'] = null;
        $row['GENDER'] = null;
        $row['KARYAWAN'] = null;
        $row['MODIFIED_BY'] = null;
        $row['MODIFIED_DATE'] = null;
        $row['MODIFIED_FROM'] = null;
        $row['NUMER'] = null;
        $row['NOTA_NO'] = null;
        $row['MEASURE_ID2'] = null;
        $row['POTONGAN'] = null;
        $row['BAYAR'] = null;
        $row['RETUR'] = null;
        $row['TARIF_TYPE'] = null;
        $row['PPNVALUE'] = null;
        $row['TAGIHAN'] = null;
        $row['KOREKSI'] = null;
        $row['AMOUNT_PAID'] = null;
        $row['DISKON'] = null;
        $row['SELL_PRICE'] = null;
        $row['ACCOUNT_ID'] = null;
        $row['subsidi'] = null;
        $row['PROFESI'] = null;
        $row['EMBALACE'] = null;
        $row['DISCOUNT'] = null;
        $row['AMOUNT'] = null;
        $row['PPN'] = null;
        $row['ITER'] = null;
        $row['PAYOR_ID'] = null;
        $row['STATUS_OBAT'] = null;
        $row['SUBSIDISAT'] = null;
        $row['MARGIN'] = null;
        $row['POKOK_JUAL'] = null;
        $row['PRINTQ'] = null;
        $row['PRINTED_BY'] = null;
        $row['STOCK_AVAILABLE'] = null;
        $row['STATUS_TARIF'] = null;
        $row['PACKAGE_ID'] = null;
        $row['MODULE_ID'] = null;
        $row['profession'] = null;
        $row['THEORDER'] = null;
        $row['CORRECTION_ID'] = null;
        $row['CORRECTION_BY'] = null;
        $row['CASHIER'] = null;
        $row['islunas'] = null;
        $row['PAY_METHOD_ID'] = null;
        $row['PAYMENT_DATE'] = null;
        $row['ISCETAK'] = null;
        $row['print_date'] = null;
        $row['DOSE'] = null;
        $row['JML_BKS'] = null;
        $row['ORIG_DOSE'] = null;
        $row['RESEP_KE'] = null;
        $row['ITER_KE'] = null;
        $row['KUITANSI_ID'] = null;
        $row['PEMBULATAN'] = null;
        $row['KAL_ID'] = null;
        $row['INVOICE_ID'] = null;
        $row['SERVICE_TIME'] = null;
        $row['TAKEN_TIME'] = null;
        $row['modified_datesys'] = null;
        $row['TRANS_ID'] = null;
        $row['SPPBILL'] = null;
        $row['SPPBILLDATE'] = null;
        $row['SPPBILLUSER'] = null;
        $row['SPPKASIR'] = null;
        $row['SPPKASIRDATE'] = null;
        $row['SPPKASIRUSER'] = null;
        $row['SPPPOLI'] = null;
        $row['SPPPOLIUSER'] = null;
        $row['SPPPOLIDATE'] = null;
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

        // Convert decimal values if posted back
        if ($this->QUANTITY->FormValue == $this->QUANTITY->CurrentValue && is_numeric(ConvertToFloatString($this->QUANTITY->CurrentValue))) {
            $this->QUANTITY->CurrentValue = ConvertToFloatString($this->QUANTITY->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->DOSE_PRESC->FormValue == $this->DOSE_PRESC->CurrentValue && is_numeric(ConvertToFloatString($this->DOSE_PRESC->CurrentValue))) {
            $this->DOSE_PRESC->CurrentValue = ConvertToFloatString($this->DOSE_PRESC->CurrentValue);
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
        if ($this->AMOUNT_PAID->FormValue == $this->AMOUNT_PAID->CurrentValue && is_numeric(ConvertToFloatString($this->AMOUNT_PAID->CurrentValue))) {
            $this->AMOUNT_PAID->CurrentValue = ConvertToFloatString($this->AMOUNT_PAID->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->DISKON->FormValue == $this->DISKON->CurrentValue && is_numeric(ConvertToFloatString($this->DISKON->CurrentValue))) {
            $this->DISKON->CurrentValue = ConvertToFloatString($this->DISKON->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->SELL_PRICE->FormValue == $this->SELL_PRICE->CurrentValue && is_numeric(ConvertToFloatString($this->SELL_PRICE->CurrentValue))) {
            $this->SELL_PRICE->CurrentValue = ConvertToFloatString($this->SELL_PRICE->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->subsidi->FormValue == $this->subsidi->CurrentValue && is_numeric(ConvertToFloatString($this->subsidi->CurrentValue))) {
            $this->subsidi->CurrentValue = ConvertToFloatString($this->subsidi->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->PROFESI->FormValue == $this->PROFESI->CurrentValue && is_numeric(ConvertToFloatString($this->PROFESI->CurrentValue))) {
            $this->PROFESI->CurrentValue = ConvertToFloatString($this->PROFESI->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->EMBALACE->FormValue == $this->EMBALACE->CurrentValue && is_numeric(ConvertToFloatString($this->EMBALACE->CurrentValue))) {
            $this->EMBALACE->CurrentValue = ConvertToFloatString($this->EMBALACE->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->DISCOUNT->FormValue == $this->DISCOUNT->CurrentValue && is_numeric(ConvertToFloatString($this->DISCOUNT->CurrentValue))) {
            $this->DISCOUNT->CurrentValue = ConvertToFloatString($this->DISCOUNT->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->AMOUNT->FormValue == $this->AMOUNT->CurrentValue && is_numeric(ConvertToFloatString($this->AMOUNT->CurrentValue))) {
            $this->AMOUNT->CurrentValue = ConvertToFloatString($this->AMOUNT->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->PPN->FormValue == $this->PPN->CurrentValue && is_numeric(ConvertToFloatString($this->PPN->CurrentValue))) {
            $this->PPN->CurrentValue = ConvertToFloatString($this->PPN->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->SUBSIDISAT->FormValue == $this->SUBSIDISAT->CurrentValue && is_numeric(ConvertToFloatString($this->SUBSIDISAT->CurrentValue))) {
            $this->SUBSIDISAT->CurrentValue = ConvertToFloatString($this->SUBSIDISAT->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->MARGIN->FormValue == $this->MARGIN->CurrentValue && is_numeric(ConvertToFloatString($this->MARGIN->CurrentValue))) {
            $this->MARGIN->CurrentValue = ConvertToFloatString($this->MARGIN->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->POKOK_JUAL->FormValue == $this->POKOK_JUAL->CurrentValue && is_numeric(ConvertToFloatString($this->POKOK_JUAL->CurrentValue))) {
            $this->POKOK_JUAL->CurrentValue = ConvertToFloatString($this->POKOK_JUAL->CurrentValue);
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
        if ($this->DOSE->FormValue == $this->DOSE->CurrentValue && is_numeric(ConvertToFloatString($this->DOSE->CurrentValue))) {
            $this->DOSE->CurrentValue = ConvertToFloatString($this->DOSE->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->ORIG_DOSE->FormValue == $this->ORIG_DOSE->CurrentValue && is_numeric(ConvertToFloatString($this->ORIG_DOSE->CurrentValue))) {
            $this->ORIG_DOSE->CurrentValue = ConvertToFloatString($this->ORIG_DOSE->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->PEMBULATAN->FormValue == $this->PEMBULATAN->CurrentValue && is_numeric(ConvertToFloatString($this->PEMBULATAN->CurrentValue))) {
            $this->PEMBULATAN->CurrentValue = ConvertToFloatString($this->PEMBULATAN->CurrentValue);
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

        // QUANTITY

        // MEASURE_ID

        // DESCRIPTION

        // RESEP_NO

        // DOSE_PRESC

        // SOLD_STATUS

        // RACIKAN

        // CLASS_ROOM_ID

        // KELUAR_ID

        // BED_ID

        // EMPLOYEE_ID

        // DESCRIPTION2

        // BRAND_ID

        // DOCTOR

        // EXIT_DATE

        // EMPLOYEE_ID_FROM

        // DOCTOR_FROM

        // status_pasien_id

        // THENAME

        // THEADDRESS

        // THEID

        // SERIAL_NB

        // ISRJ

        // AGEYEAR

        // AGEMONTH

        // AGEDAY

        // GENDER

        // KARYAWAN

        // MODIFIED_BY

        // MODIFIED_DATE

        // MODIFIED_FROM

        // NUMER

        // NOTA_NO

        // MEASURE_ID2

        // POTONGAN

        // BAYAR

        // RETUR

        // TARIF_TYPE

        // PPNVALUE

        // TAGIHAN

        // KOREKSI

        // AMOUNT_PAID

        // DISKON

        // SELL_PRICE

        // ACCOUNT_ID

        // subsidi

        // PROFESI

        // EMBALACE

        // DISCOUNT

        // AMOUNT

        // PPN

        // ITER

        // PAYOR_ID

        // STATUS_OBAT

        // SUBSIDISAT

        // MARGIN

        // POKOK_JUAL

        // PRINTQ

        // PRINTED_BY

        // STOCK_AVAILABLE

        // STATUS_TARIF

        // PACKAGE_ID

        // MODULE_ID

        // profession

        // THEORDER

        // CORRECTION_ID

        // CORRECTION_BY

        // CASHIER

        // islunas

        // PAY_METHOD_ID

        // PAYMENT_DATE

        // ISCETAK

        // print_date

        // DOSE

        // JML_BKS

        // ORIG_DOSE

        // RESEP_KE

        // ITER_KE

        // KUITANSI_ID

        // PEMBULATAN

        // KAL_ID

        // INVOICE_ID

        // SERVICE_TIME

        // TAKEN_TIME

        // modified_datesys

        // TRANS_ID

        // SPPBILL

        // SPPBILLDATE

        // SPPBILLUSER

        // SPPKASIR

        // SPPKASIRDATE

        // SPPKASIRUSER

        // SPPPOLI

        // SPPPOLIUSER

        // SPPPOLIDATE

        // NOSEP

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

            // QUANTITY
            $this->QUANTITY->ViewValue = $this->QUANTITY->CurrentValue;
            $this->QUANTITY->ViewValue = FormatNumber($this->QUANTITY->ViewValue, 2, -2, -2, -2);
            $this->QUANTITY->ViewCustomAttributes = "";

            // MEASURE_ID
            $this->MEASURE_ID->ViewValue = $this->MEASURE_ID->CurrentValue;
            $this->MEASURE_ID->ViewValue = FormatNumber($this->MEASURE_ID->ViewValue, 0, -2, -2, -2);
            $this->MEASURE_ID->ViewCustomAttributes = "";

            // DESCRIPTION
            $this->DESCRIPTION->ViewValue = $this->DESCRIPTION->CurrentValue;
            $this->DESCRIPTION->ViewCustomAttributes = "";

            // RESEP_NO
            $this->RESEP_NO->ViewValue = $this->RESEP_NO->CurrentValue;
            $this->RESEP_NO->ViewCustomAttributes = "";

            // DOSE_PRESC
            $this->DOSE_PRESC->ViewValue = $this->DOSE_PRESC->CurrentValue;
            $this->DOSE_PRESC->ViewValue = FormatNumber($this->DOSE_PRESC->ViewValue, 2, -2, -2, -2);
            $this->DOSE_PRESC->ViewCustomAttributes = "";

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

            // EMPLOYEE_ID
            $this->EMPLOYEE_ID->ViewValue = $this->EMPLOYEE_ID->CurrentValue;
            $this->EMPLOYEE_ID->ViewCustomAttributes = "";

            // DESCRIPTION2
            $this->DESCRIPTION2->ViewValue = $this->DESCRIPTION2->CurrentValue;
            $this->DESCRIPTION2->ViewCustomAttributes = "";

            // BRAND_ID
            $this->BRAND_ID->ViewValue = $this->BRAND_ID->CurrentValue;
            $this->BRAND_ID->ViewCustomAttributes = "";

            // DOCTOR
            $this->DOCTOR->ViewValue = $this->DOCTOR->CurrentValue;
            $this->DOCTOR->ViewCustomAttributes = "";

            // EXIT_DATE
            $this->EXIT_DATE->ViewValue = $this->EXIT_DATE->CurrentValue;
            $this->EXIT_DATE->ViewValue = FormatDateTime($this->EXIT_DATE->ViewValue, 0);
            $this->EXIT_DATE->ViewCustomAttributes = "";

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

            // KARYAWAN
            $this->KARYAWAN->ViewValue = $this->KARYAWAN->CurrentValue;
            $this->KARYAWAN->ViewCustomAttributes = "";

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

            // NUMER
            $this->NUMER->ViewValue = $this->NUMER->CurrentValue;
            $this->NUMER->ViewCustomAttributes = "";

            // NOTA_NO
            $this->NOTA_NO->ViewValue = $this->NOTA_NO->CurrentValue;
            $this->NOTA_NO->ViewCustomAttributes = "";

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

            // AMOUNT_PAID
            $this->AMOUNT_PAID->ViewValue = $this->AMOUNT_PAID->CurrentValue;
            $this->AMOUNT_PAID->ViewValue = FormatNumber($this->AMOUNT_PAID->ViewValue, 2, -2, -2, -2);
            $this->AMOUNT_PAID->ViewCustomAttributes = "";

            // DISKON
            $this->DISKON->ViewValue = $this->DISKON->CurrentValue;
            $this->DISKON->ViewValue = FormatNumber($this->DISKON->ViewValue, 2, -2, -2, -2);
            $this->DISKON->ViewCustomAttributes = "";

            // SELL_PRICE
            $this->SELL_PRICE->ViewValue = $this->SELL_PRICE->CurrentValue;
            $this->SELL_PRICE->ViewValue = FormatNumber($this->SELL_PRICE->ViewValue, 2, -2, -2, -2);
            $this->SELL_PRICE->ViewCustomAttributes = "";

            // ACCOUNT_ID
            $this->ACCOUNT_ID->ViewValue = $this->ACCOUNT_ID->CurrentValue;
            $this->ACCOUNT_ID->ViewCustomAttributes = "";

            // subsidi
            $this->subsidi->ViewValue = $this->subsidi->CurrentValue;
            $this->subsidi->ViewValue = FormatNumber($this->subsidi->ViewValue, 2, -2, -2, -2);
            $this->subsidi->ViewCustomAttributes = "";

            // PROFESI
            $this->PROFESI->ViewValue = $this->PROFESI->CurrentValue;
            $this->PROFESI->ViewValue = FormatNumber($this->PROFESI->ViewValue, 2, -2, -2, -2);
            $this->PROFESI->ViewCustomAttributes = "";

            // EMBALACE
            $this->EMBALACE->ViewValue = $this->EMBALACE->CurrentValue;
            $this->EMBALACE->ViewValue = FormatNumber($this->EMBALACE->ViewValue, 2, -2, -2, -2);
            $this->EMBALACE->ViewCustomAttributes = "";

            // DISCOUNT
            $this->DISCOUNT->ViewValue = $this->DISCOUNT->CurrentValue;
            $this->DISCOUNT->ViewValue = FormatNumber($this->DISCOUNT->ViewValue, 2, -2, -2, -2);
            $this->DISCOUNT->ViewCustomAttributes = "";

            // AMOUNT
            $this->AMOUNT->ViewValue = $this->AMOUNT->CurrentValue;
            $this->AMOUNT->ViewValue = FormatNumber($this->AMOUNT->ViewValue, 2, -2, -2, -2);
            $this->AMOUNT->ViewCustomAttributes = "";

            // PPN
            $this->PPN->ViewValue = $this->PPN->CurrentValue;
            $this->PPN->ViewValue = FormatNumber($this->PPN->ViewValue, 2, -2, -2, -2);
            $this->PPN->ViewCustomAttributes = "";

            // ITER
            $this->ITER->ViewValue = $this->ITER->CurrentValue;
            $this->ITER->ViewValue = FormatNumber($this->ITER->ViewValue, 0, -2, -2, -2);
            $this->ITER->ViewCustomAttributes = "";

            // PAYOR_ID
            $this->PAYOR_ID->ViewValue = $this->PAYOR_ID->CurrentValue;
            $this->PAYOR_ID->ViewCustomAttributes = "";

            // STATUS_OBAT
            $this->STATUS_OBAT->ViewValue = $this->STATUS_OBAT->CurrentValue;
            $this->STATUS_OBAT->ViewValue = FormatNumber($this->STATUS_OBAT->ViewValue, 0, -2, -2, -2);
            $this->STATUS_OBAT->ViewCustomAttributes = "";

            // SUBSIDISAT
            $this->SUBSIDISAT->ViewValue = $this->SUBSIDISAT->CurrentValue;
            $this->SUBSIDISAT->ViewValue = FormatNumber($this->SUBSIDISAT->ViewValue, 2, -2, -2, -2);
            $this->SUBSIDISAT->ViewCustomAttributes = "";

            // MARGIN
            $this->MARGIN->ViewValue = $this->MARGIN->CurrentValue;
            $this->MARGIN->ViewValue = FormatNumber($this->MARGIN->ViewValue, 2, -2, -2, -2);
            $this->MARGIN->ViewCustomAttributes = "";

            // POKOK_JUAL
            $this->POKOK_JUAL->ViewValue = $this->POKOK_JUAL->CurrentValue;
            $this->POKOK_JUAL->ViewValue = FormatNumber($this->POKOK_JUAL->ViewValue, 2, -2, -2, -2);
            $this->POKOK_JUAL->ViewCustomAttributes = "";

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

            // CORRECTION_ID
            $this->CORRECTION_ID->ViewValue = $this->CORRECTION_ID->CurrentValue;
            $this->CORRECTION_ID->ViewCustomAttributes = "";

            // CORRECTION_BY
            $this->CORRECTION_BY->ViewValue = $this->CORRECTION_BY->CurrentValue;
            $this->CORRECTION_BY->ViewCustomAttributes = "";

            // CASHIER
            $this->CASHIER->ViewValue = $this->CASHIER->CurrentValue;
            $this->CASHIER->ViewCustomAttributes = "";

            // islunas
            $this->islunas->ViewValue = $this->islunas->CurrentValue;
            $this->islunas->ViewCustomAttributes = "";

            // PAY_METHOD_ID
            $this->PAY_METHOD_ID->ViewValue = $this->PAY_METHOD_ID->CurrentValue;
            $this->PAY_METHOD_ID->ViewValue = FormatNumber($this->PAY_METHOD_ID->ViewValue, 0, -2, -2, -2);
            $this->PAY_METHOD_ID->ViewCustomAttributes = "";

            // PAYMENT_DATE
            $this->PAYMENT_DATE->ViewValue = $this->PAYMENT_DATE->CurrentValue;
            $this->PAYMENT_DATE->ViewValue = FormatDateTime($this->PAYMENT_DATE->ViewValue, 0);
            $this->PAYMENT_DATE->ViewCustomAttributes = "";

            // ISCETAK
            $this->ISCETAK->ViewValue = $this->ISCETAK->CurrentValue;
            $this->ISCETAK->ViewCustomAttributes = "";

            // print_date
            $this->print_date->ViewValue = $this->print_date->CurrentValue;
            $this->print_date->ViewValue = FormatDateTime($this->print_date->ViewValue, 0);
            $this->print_date->ViewCustomAttributes = "";

            // DOSE
            $this->DOSE->ViewValue = $this->DOSE->CurrentValue;
            $this->DOSE->ViewValue = FormatNumber($this->DOSE->ViewValue, 2, -2, -2, -2);
            $this->DOSE->ViewCustomAttributes = "";

            // JML_BKS
            $this->JML_BKS->ViewValue = $this->JML_BKS->CurrentValue;
            $this->JML_BKS->ViewValue = FormatNumber($this->JML_BKS->ViewValue, 0, -2, -2, -2);
            $this->JML_BKS->ViewCustomAttributes = "";

            // ORIG_DOSE
            $this->ORIG_DOSE->ViewValue = $this->ORIG_DOSE->CurrentValue;
            $this->ORIG_DOSE->ViewValue = FormatNumber($this->ORIG_DOSE->ViewValue, 2, -2, -2, -2);
            $this->ORIG_DOSE->ViewCustomAttributes = "";

            // RESEP_KE
            $this->RESEP_KE->ViewValue = $this->RESEP_KE->CurrentValue;
            $this->RESEP_KE->ViewValue = FormatNumber($this->RESEP_KE->ViewValue, 0, -2, -2, -2);
            $this->RESEP_KE->ViewCustomAttributes = "";

            // ITER_KE
            $this->ITER_KE->ViewValue = $this->ITER_KE->CurrentValue;
            $this->ITER_KE->ViewValue = FormatNumber($this->ITER_KE->ViewValue, 0, -2, -2, -2);
            $this->ITER_KE->ViewCustomAttributes = "";

            // KUITANSI_ID
            $this->KUITANSI_ID->ViewValue = $this->KUITANSI_ID->CurrentValue;
            $this->KUITANSI_ID->ViewCustomAttributes = "";

            // PEMBULATAN
            $this->PEMBULATAN->ViewValue = $this->PEMBULATAN->CurrentValue;
            $this->PEMBULATAN->ViewValue = FormatNumber($this->PEMBULATAN->ViewValue, 2, -2, -2, -2);
            $this->PEMBULATAN->ViewCustomAttributes = "";

            // KAL_ID
            $this->KAL_ID->ViewValue = $this->KAL_ID->CurrentValue;
            $this->KAL_ID->ViewCustomAttributes = "";

            // INVOICE_ID
            $this->INVOICE_ID->ViewValue = $this->INVOICE_ID->CurrentValue;
            $this->INVOICE_ID->ViewCustomAttributes = "";

            // SERVICE_TIME
            $this->SERVICE_TIME->ViewValue = $this->SERVICE_TIME->CurrentValue;
            $this->SERVICE_TIME->ViewValue = FormatDateTime($this->SERVICE_TIME->ViewValue, 0);
            $this->SERVICE_TIME->ViewCustomAttributes = "";

            // TAKEN_TIME
            $this->TAKEN_TIME->ViewValue = $this->TAKEN_TIME->CurrentValue;
            $this->TAKEN_TIME->ViewValue = FormatDateTime($this->TAKEN_TIME->ViewValue, 0);
            $this->TAKEN_TIME->ViewCustomAttributes = "";

            // modified_datesys
            $this->modified_datesys->ViewValue = $this->modified_datesys->CurrentValue;
            $this->modified_datesys->ViewValue = FormatDateTime($this->modified_datesys->ViewValue, 0);
            $this->modified_datesys->ViewCustomAttributes = "";

            // TRANS_ID
            $this->TRANS_ID->ViewValue = $this->TRANS_ID->CurrentValue;
            $this->TRANS_ID->ViewCustomAttributes = "";

            // SPPBILL
            $this->SPPBILL->ViewValue = $this->SPPBILL->CurrentValue;
            $this->SPPBILL->ViewCustomAttributes = "";

            // SPPBILLDATE
            $this->SPPBILLDATE->ViewValue = $this->SPPBILLDATE->CurrentValue;
            $this->SPPBILLDATE->ViewValue = FormatDateTime($this->SPPBILLDATE->ViewValue, 0);
            $this->SPPBILLDATE->ViewCustomAttributes = "";

            // SPPBILLUSER
            $this->SPPBILLUSER->ViewValue = $this->SPPBILLUSER->CurrentValue;
            $this->SPPBILLUSER->ViewCustomAttributes = "";

            // SPPKASIR
            $this->SPPKASIR->ViewValue = $this->SPPKASIR->CurrentValue;
            $this->SPPKASIR->ViewCustomAttributes = "";

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

            // NOSEP
            $this->NOSEP->ViewValue = $this->NOSEP->CurrentValue;
            $this->NOSEP->ViewCustomAttributes = "";

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

            // QUANTITY
            $this->QUANTITY->LinkCustomAttributes = "";
            $this->QUANTITY->HrefValue = "";
            $this->QUANTITY->TooltipValue = "";

            // MEASURE_ID
            $this->MEASURE_ID->LinkCustomAttributes = "";
            $this->MEASURE_ID->HrefValue = "";
            $this->MEASURE_ID->TooltipValue = "";

            // DESCRIPTION
            $this->DESCRIPTION->LinkCustomAttributes = "";
            $this->DESCRIPTION->HrefValue = "";
            $this->DESCRIPTION->TooltipValue = "";

            // RESEP_NO
            $this->RESEP_NO->LinkCustomAttributes = "";
            $this->RESEP_NO->HrefValue = "";
            $this->RESEP_NO->TooltipValue = "";

            // DOSE_PRESC
            $this->DOSE_PRESC->LinkCustomAttributes = "";
            $this->DOSE_PRESC->HrefValue = "";
            $this->DOSE_PRESC->TooltipValue = "";

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

            // EMPLOYEE_ID
            $this->EMPLOYEE_ID->LinkCustomAttributes = "";
            $this->EMPLOYEE_ID->HrefValue = "";
            $this->EMPLOYEE_ID->TooltipValue = "";

            // DESCRIPTION2
            $this->DESCRIPTION2->LinkCustomAttributes = "";
            $this->DESCRIPTION2->HrefValue = "";
            $this->DESCRIPTION2->TooltipValue = "";

            // BRAND_ID
            $this->BRAND_ID->LinkCustomAttributes = "";
            $this->BRAND_ID->HrefValue = "";
            $this->BRAND_ID->TooltipValue = "";

            // DOCTOR
            $this->DOCTOR->LinkCustomAttributes = "";
            $this->DOCTOR->HrefValue = "";
            $this->DOCTOR->TooltipValue = "";

            // EXIT_DATE
            $this->EXIT_DATE->LinkCustomAttributes = "";
            $this->EXIT_DATE->HrefValue = "";
            $this->EXIT_DATE->TooltipValue = "";

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

            // KARYAWAN
            $this->KARYAWAN->LinkCustomAttributes = "";
            $this->KARYAWAN->HrefValue = "";
            $this->KARYAWAN->TooltipValue = "";

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

            // NUMER
            $this->NUMER->LinkCustomAttributes = "";
            $this->NUMER->HrefValue = "";
            $this->NUMER->TooltipValue = "";

            // NOTA_NO
            $this->NOTA_NO->LinkCustomAttributes = "";
            $this->NOTA_NO->HrefValue = "";
            $this->NOTA_NO->TooltipValue = "";

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

            // AMOUNT_PAID
            $this->AMOUNT_PAID->LinkCustomAttributes = "";
            $this->AMOUNT_PAID->HrefValue = "";
            $this->AMOUNT_PAID->TooltipValue = "";

            // DISKON
            $this->DISKON->LinkCustomAttributes = "";
            $this->DISKON->HrefValue = "";
            $this->DISKON->TooltipValue = "";

            // SELL_PRICE
            $this->SELL_PRICE->LinkCustomAttributes = "";
            $this->SELL_PRICE->HrefValue = "";
            $this->SELL_PRICE->TooltipValue = "";

            // ACCOUNT_ID
            $this->ACCOUNT_ID->LinkCustomAttributes = "";
            $this->ACCOUNT_ID->HrefValue = "";
            $this->ACCOUNT_ID->TooltipValue = "";

            // subsidi
            $this->subsidi->LinkCustomAttributes = "";
            $this->subsidi->HrefValue = "";
            $this->subsidi->TooltipValue = "";

            // PROFESI
            $this->PROFESI->LinkCustomAttributes = "";
            $this->PROFESI->HrefValue = "";
            $this->PROFESI->TooltipValue = "";

            // EMBALACE
            $this->EMBALACE->LinkCustomAttributes = "";
            $this->EMBALACE->HrefValue = "";
            $this->EMBALACE->TooltipValue = "";

            // DISCOUNT
            $this->DISCOUNT->LinkCustomAttributes = "";
            $this->DISCOUNT->HrefValue = "";
            $this->DISCOUNT->TooltipValue = "";

            // AMOUNT
            $this->AMOUNT->LinkCustomAttributes = "";
            $this->AMOUNT->HrefValue = "";
            $this->AMOUNT->TooltipValue = "";

            // PPN
            $this->PPN->LinkCustomAttributes = "";
            $this->PPN->HrefValue = "";
            $this->PPN->TooltipValue = "";

            // ITER
            $this->ITER->LinkCustomAttributes = "";
            $this->ITER->HrefValue = "";
            $this->ITER->TooltipValue = "";

            // PAYOR_ID
            $this->PAYOR_ID->LinkCustomAttributes = "";
            $this->PAYOR_ID->HrefValue = "";
            $this->PAYOR_ID->TooltipValue = "";

            // STATUS_OBAT
            $this->STATUS_OBAT->LinkCustomAttributes = "";
            $this->STATUS_OBAT->HrefValue = "";
            $this->STATUS_OBAT->TooltipValue = "";

            // SUBSIDISAT
            $this->SUBSIDISAT->LinkCustomAttributes = "";
            $this->SUBSIDISAT->HrefValue = "";
            $this->SUBSIDISAT->TooltipValue = "";

            // MARGIN
            $this->MARGIN->LinkCustomAttributes = "";
            $this->MARGIN->HrefValue = "";
            $this->MARGIN->TooltipValue = "";

            // POKOK_JUAL
            $this->POKOK_JUAL->LinkCustomAttributes = "";
            $this->POKOK_JUAL->HrefValue = "";
            $this->POKOK_JUAL->TooltipValue = "";

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

            // CORRECTION_ID
            $this->CORRECTION_ID->LinkCustomAttributes = "";
            $this->CORRECTION_ID->HrefValue = "";
            $this->CORRECTION_ID->TooltipValue = "";

            // CORRECTION_BY
            $this->CORRECTION_BY->LinkCustomAttributes = "";
            $this->CORRECTION_BY->HrefValue = "";
            $this->CORRECTION_BY->TooltipValue = "";

            // CASHIER
            $this->CASHIER->LinkCustomAttributes = "";
            $this->CASHIER->HrefValue = "";
            $this->CASHIER->TooltipValue = "";

            // islunas
            $this->islunas->LinkCustomAttributes = "";
            $this->islunas->HrefValue = "";
            $this->islunas->TooltipValue = "";

            // PAY_METHOD_ID
            $this->PAY_METHOD_ID->LinkCustomAttributes = "";
            $this->PAY_METHOD_ID->HrefValue = "";
            $this->PAY_METHOD_ID->TooltipValue = "";

            // PAYMENT_DATE
            $this->PAYMENT_DATE->LinkCustomAttributes = "";
            $this->PAYMENT_DATE->HrefValue = "";
            $this->PAYMENT_DATE->TooltipValue = "";

            // ISCETAK
            $this->ISCETAK->LinkCustomAttributes = "";
            $this->ISCETAK->HrefValue = "";
            $this->ISCETAK->TooltipValue = "";

            // print_date
            $this->print_date->LinkCustomAttributes = "";
            $this->print_date->HrefValue = "";
            $this->print_date->TooltipValue = "";

            // DOSE
            $this->DOSE->LinkCustomAttributes = "";
            $this->DOSE->HrefValue = "";
            $this->DOSE->TooltipValue = "";

            // JML_BKS
            $this->JML_BKS->LinkCustomAttributes = "";
            $this->JML_BKS->HrefValue = "";
            $this->JML_BKS->TooltipValue = "";

            // ORIG_DOSE
            $this->ORIG_DOSE->LinkCustomAttributes = "";
            $this->ORIG_DOSE->HrefValue = "";
            $this->ORIG_DOSE->TooltipValue = "";

            // RESEP_KE
            $this->RESEP_KE->LinkCustomAttributes = "";
            $this->RESEP_KE->HrefValue = "";
            $this->RESEP_KE->TooltipValue = "";

            // ITER_KE
            $this->ITER_KE->LinkCustomAttributes = "";
            $this->ITER_KE->HrefValue = "";
            $this->ITER_KE->TooltipValue = "";

            // KUITANSI_ID
            $this->KUITANSI_ID->LinkCustomAttributes = "";
            $this->KUITANSI_ID->HrefValue = "";
            $this->KUITANSI_ID->TooltipValue = "";

            // PEMBULATAN
            $this->PEMBULATAN->LinkCustomAttributes = "";
            $this->PEMBULATAN->HrefValue = "";
            $this->PEMBULATAN->TooltipValue = "";

            // KAL_ID
            $this->KAL_ID->LinkCustomAttributes = "";
            $this->KAL_ID->HrefValue = "";
            $this->KAL_ID->TooltipValue = "";

            // INVOICE_ID
            $this->INVOICE_ID->LinkCustomAttributes = "";
            $this->INVOICE_ID->HrefValue = "";
            $this->INVOICE_ID->TooltipValue = "";

            // SERVICE_TIME
            $this->SERVICE_TIME->LinkCustomAttributes = "";
            $this->SERVICE_TIME->HrefValue = "";
            $this->SERVICE_TIME->TooltipValue = "";

            // TAKEN_TIME
            $this->TAKEN_TIME->LinkCustomAttributes = "";
            $this->TAKEN_TIME->HrefValue = "";
            $this->TAKEN_TIME->TooltipValue = "";

            // modified_datesys
            $this->modified_datesys->LinkCustomAttributes = "";
            $this->modified_datesys->HrefValue = "";
            $this->modified_datesys->TooltipValue = "";

            // TRANS_ID
            $this->TRANS_ID->LinkCustomAttributes = "";
            $this->TRANS_ID->HrefValue = "";
            $this->TRANS_ID->TooltipValue = "";

            // SPPBILL
            $this->SPPBILL->LinkCustomAttributes = "";
            $this->SPPBILL->HrefValue = "";
            $this->SPPBILL->TooltipValue = "";

            // SPPBILLDATE
            $this->SPPBILLDATE->LinkCustomAttributes = "";
            $this->SPPBILLDATE->HrefValue = "";
            $this->SPPBILLDATE->TooltipValue = "";

            // SPPBILLUSER
            $this->SPPBILLUSER->LinkCustomAttributes = "";
            $this->SPPBILLUSER->HrefValue = "";
            $this->SPPBILLUSER->TooltipValue = "";

            // SPPKASIR
            $this->SPPKASIR->LinkCustomAttributes = "";
            $this->SPPKASIR->HrefValue = "";
            $this->SPPKASIR->TooltipValue = "";

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

            // NOSEP
            $this->NOSEP->LinkCustomAttributes = "";
            $this->NOSEP->HrefValue = "";
            $this->NOSEP->TooltipValue = "";

            // ID
            $this->ID->LinkCustomAttributes = "";
            $this->ID->HrefValue = "";
            $this->ID->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_EDIT) {
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
            if ($this->VISIT_ID->getSessionValue() != "") {
                $this->VISIT_ID->CurrentValue = GetForeignKeyValue($this->VISIT_ID->getSessionValue());
                $this->VISIT_ID->ViewValue = $this->VISIT_ID->CurrentValue;
                $this->VISIT_ID->ViewCustomAttributes = "";
            } else {
                if (!$this->VISIT_ID->Raw) {
                    $this->VISIT_ID->CurrentValue = HtmlDecode($this->VISIT_ID->CurrentValue);
                }
                $this->VISIT_ID->EditValue = HtmlEncode($this->VISIT_ID->CurrentValue);
                $this->VISIT_ID->PlaceHolder = RemoveHtml($this->VISIT_ID->caption());
            }

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

            // DESCRIPTION
            $this->DESCRIPTION->EditAttrs["class"] = "form-control";
            $this->DESCRIPTION->EditCustomAttributes = "";
            if (!$this->DESCRIPTION->Raw) {
                $this->DESCRIPTION->CurrentValue = HtmlDecode($this->DESCRIPTION->CurrentValue);
            }
            $this->DESCRIPTION->EditValue = HtmlEncode($this->DESCRIPTION->CurrentValue);
            $this->DESCRIPTION->PlaceHolder = RemoveHtml($this->DESCRIPTION->caption());

            // RESEP_NO
            $this->RESEP_NO->EditAttrs["class"] = "form-control";
            $this->RESEP_NO->EditCustomAttributes = "";
            if (!$this->RESEP_NO->Raw) {
                $this->RESEP_NO->CurrentValue = HtmlDecode($this->RESEP_NO->CurrentValue);
            }
            $this->RESEP_NO->EditValue = HtmlEncode($this->RESEP_NO->CurrentValue);
            $this->RESEP_NO->PlaceHolder = RemoveHtml($this->RESEP_NO->caption());

            // DOSE_PRESC
            $this->DOSE_PRESC->EditAttrs["class"] = "form-control";
            $this->DOSE_PRESC->EditCustomAttributes = "";
            $this->DOSE_PRESC->EditValue = HtmlEncode($this->DOSE_PRESC->CurrentValue);
            $this->DOSE_PRESC->PlaceHolder = RemoveHtml($this->DOSE_PRESC->caption());
            if (strval($this->DOSE_PRESC->EditValue) != "" && is_numeric($this->DOSE_PRESC->EditValue)) {
                $this->DOSE_PRESC->EditValue = FormatNumber($this->DOSE_PRESC->EditValue, -2, -2, -2, -2);
            }

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

            // EXIT_DATE
            $this->EXIT_DATE->EditAttrs["class"] = "form-control";
            $this->EXIT_DATE->EditCustomAttributes = "";
            $this->EXIT_DATE->EditValue = HtmlEncode(FormatDateTime($this->EXIT_DATE->CurrentValue, 8));
            $this->EXIT_DATE->PlaceHolder = RemoveHtml($this->EXIT_DATE->caption());

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

            // SERIAL_NB
            $this->SERIAL_NB->EditAttrs["class"] = "form-control";
            $this->SERIAL_NB->EditCustomAttributes = "";
            if (!$this->SERIAL_NB->Raw) {
                $this->SERIAL_NB->CurrentValue = HtmlDecode($this->SERIAL_NB->CurrentValue);
            }
            $this->SERIAL_NB->EditValue = HtmlEncode($this->SERIAL_NB->CurrentValue);
            $this->SERIAL_NB->PlaceHolder = RemoveHtml($this->SERIAL_NB->caption());

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

            // KARYAWAN
            $this->KARYAWAN->EditAttrs["class"] = "form-control";
            $this->KARYAWAN->EditCustomAttributes = "";
            if (!$this->KARYAWAN->Raw) {
                $this->KARYAWAN->CurrentValue = HtmlDecode($this->KARYAWAN->CurrentValue);
            }
            $this->KARYAWAN->EditValue = HtmlEncode($this->KARYAWAN->CurrentValue);
            $this->KARYAWAN->PlaceHolder = RemoveHtml($this->KARYAWAN->caption());

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

            // NUMER
            $this->NUMER->EditAttrs["class"] = "form-control";
            $this->NUMER->EditCustomAttributes = "";
            if (!$this->NUMER->Raw) {
                $this->NUMER->CurrentValue = HtmlDecode($this->NUMER->CurrentValue);
            }
            $this->NUMER->EditValue = HtmlEncode($this->NUMER->CurrentValue);
            $this->NUMER->PlaceHolder = RemoveHtml($this->NUMER->caption());

            // NOTA_NO
            $this->NOTA_NO->EditAttrs["class"] = "form-control";
            $this->NOTA_NO->EditCustomAttributes = "";
            if (!$this->NOTA_NO->Raw) {
                $this->NOTA_NO->CurrentValue = HtmlDecode($this->NOTA_NO->CurrentValue);
            }
            $this->NOTA_NO->EditValue = HtmlEncode($this->NOTA_NO->CurrentValue);
            $this->NOTA_NO->PlaceHolder = RemoveHtml($this->NOTA_NO->caption());

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

            // AMOUNT_PAID
            $this->AMOUNT_PAID->EditAttrs["class"] = "form-control";
            $this->AMOUNT_PAID->EditCustomAttributes = "";
            $this->AMOUNT_PAID->EditValue = HtmlEncode($this->AMOUNT_PAID->CurrentValue);
            $this->AMOUNT_PAID->PlaceHolder = RemoveHtml($this->AMOUNT_PAID->caption());
            if (strval($this->AMOUNT_PAID->EditValue) != "" && is_numeric($this->AMOUNT_PAID->EditValue)) {
                $this->AMOUNT_PAID->EditValue = FormatNumber($this->AMOUNT_PAID->EditValue, -2, -2, -2, -2);
            }

            // DISKON
            $this->DISKON->EditAttrs["class"] = "form-control";
            $this->DISKON->EditCustomAttributes = "";
            $this->DISKON->EditValue = HtmlEncode($this->DISKON->CurrentValue);
            $this->DISKON->PlaceHolder = RemoveHtml($this->DISKON->caption());
            if (strval($this->DISKON->EditValue) != "" && is_numeric($this->DISKON->EditValue)) {
                $this->DISKON->EditValue = FormatNumber($this->DISKON->EditValue, -2, -2, -2, -2);
            }

            // SELL_PRICE
            $this->SELL_PRICE->EditAttrs["class"] = "form-control";
            $this->SELL_PRICE->EditCustomAttributes = "";
            $this->SELL_PRICE->EditValue = HtmlEncode($this->SELL_PRICE->CurrentValue);
            $this->SELL_PRICE->PlaceHolder = RemoveHtml($this->SELL_PRICE->caption());
            if (strval($this->SELL_PRICE->EditValue) != "" && is_numeric($this->SELL_PRICE->EditValue)) {
                $this->SELL_PRICE->EditValue = FormatNumber($this->SELL_PRICE->EditValue, -2, -2, -2, -2);
            }

            // ACCOUNT_ID
            $this->ACCOUNT_ID->EditAttrs["class"] = "form-control";
            $this->ACCOUNT_ID->EditCustomAttributes = "";
            if (!$this->ACCOUNT_ID->Raw) {
                $this->ACCOUNT_ID->CurrentValue = HtmlDecode($this->ACCOUNT_ID->CurrentValue);
            }
            $this->ACCOUNT_ID->EditValue = HtmlEncode($this->ACCOUNT_ID->CurrentValue);
            $this->ACCOUNT_ID->PlaceHolder = RemoveHtml($this->ACCOUNT_ID->caption());

            // subsidi
            $this->subsidi->EditAttrs["class"] = "form-control";
            $this->subsidi->EditCustomAttributes = "";
            $this->subsidi->EditValue = HtmlEncode($this->subsidi->CurrentValue);
            $this->subsidi->PlaceHolder = RemoveHtml($this->subsidi->caption());
            if (strval($this->subsidi->EditValue) != "" && is_numeric($this->subsidi->EditValue)) {
                $this->subsidi->EditValue = FormatNumber($this->subsidi->EditValue, -2, -2, -2, -2);
            }

            // PROFESI
            $this->PROFESI->EditAttrs["class"] = "form-control";
            $this->PROFESI->EditCustomAttributes = "";
            $this->PROFESI->EditValue = HtmlEncode($this->PROFESI->CurrentValue);
            $this->PROFESI->PlaceHolder = RemoveHtml($this->PROFESI->caption());
            if (strval($this->PROFESI->EditValue) != "" && is_numeric($this->PROFESI->EditValue)) {
                $this->PROFESI->EditValue = FormatNumber($this->PROFESI->EditValue, -2, -2, -2, -2);
            }

            // EMBALACE
            $this->EMBALACE->EditAttrs["class"] = "form-control";
            $this->EMBALACE->EditCustomAttributes = "";
            $this->EMBALACE->EditValue = HtmlEncode($this->EMBALACE->CurrentValue);
            $this->EMBALACE->PlaceHolder = RemoveHtml($this->EMBALACE->caption());
            if (strval($this->EMBALACE->EditValue) != "" && is_numeric($this->EMBALACE->EditValue)) {
                $this->EMBALACE->EditValue = FormatNumber($this->EMBALACE->EditValue, -2, -2, -2, -2);
            }

            // DISCOUNT
            $this->DISCOUNT->EditAttrs["class"] = "form-control";
            $this->DISCOUNT->EditCustomAttributes = "";
            $this->DISCOUNT->EditValue = HtmlEncode($this->DISCOUNT->CurrentValue);
            $this->DISCOUNT->PlaceHolder = RemoveHtml($this->DISCOUNT->caption());
            if (strval($this->DISCOUNT->EditValue) != "" && is_numeric($this->DISCOUNT->EditValue)) {
                $this->DISCOUNT->EditValue = FormatNumber($this->DISCOUNT->EditValue, -2, -2, -2, -2);
            }

            // AMOUNT
            $this->AMOUNT->EditAttrs["class"] = "form-control";
            $this->AMOUNT->EditCustomAttributes = "";
            $this->AMOUNT->EditValue = HtmlEncode($this->AMOUNT->CurrentValue);
            $this->AMOUNT->PlaceHolder = RemoveHtml($this->AMOUNT->caption());
            if (strval($this->AMOUNT->EditValue) != "" && is_numeric($this->AMOUNT->EditValue)) {
                $this->AMOUNT->EditValue = FormatNumber($this->AMOUNT->EditValue, -2, -2, -2, -2);
            }

            // PPN
            $this->PPN->EditAttrs["class"] = "form-control";
            $this->PPN->EditCustomAttributes = "";
            $this->PPN->EditValue = HtmlEncode($this->PPN->CurrentValue);
            $this->PPN->PlaceHolder = RemoveHtml($this->PPN->caption());
            if (strval($this->PPN->EditValue) != "" && is_numeric($this->PPN->EditValue)) {
                $this->PPN->EditValue = FormatNumber($this->PPN->EditValue, -2, -2, -2, -2);
            }

            // ITER
            $this->ITER->EditAttrs["class"] = "form-control";
            $this->ITER->EditCustomAttributes = "";
            $this->ITER->EditValue = HtmlEncode($this->ITER->CurrentValue);
            $this->ITER->PlaceHolder = RemoveHtml($this->ITER->caption());

            // PAYOR_ID
            $this->PAYOR_ID->EditAttrs["class"] = "form-control";
            $this->PAYOR_ID->EditCustomAttributes = "";
            if (!$this->PAYOR_ID->Raw) {
                $this->PAYOR_ID->CurrentValue = HtmlDecode($this->PAYOR_ID->CurrentValue);
            }
            $this->PAYOR_ID->EditValue = HtmlEncode($this->PAYOR_ID->CurrentValue);
            $this->PAYOR_ID->PlaceHolder = RemoveHtml($this->PAYOR_ID->caption());

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

            // MARGIN
            $this->MARGIN->EditAttrs["class"] = "form-control";
            $this->MARGIN->EditCustomAttributes = "";
            $this->MARGIN->EditValue = HtmlEncode($this->MARGIN->CurrentValue);
            $this->MARGIN->PlaceHolder = RemoveHtml($this->MARGIN->caption());
            if (strval($this->MARGIN->EditValue) != "" && is_numeric($this->MARGIN->EditValue)) {
                $this->MARGIN->EditValue = FormatNumber($this->MARGIN->EditValue, -2, -2, -2, -2);
            }

            // POKOK_JUAL
            $this->POKOK_JUAL->EditAttrs["class"] = "form-control";
            $this->POKOK_JUAL->EditCustomAttributes = "";
            $this->POKOK_JUAL->EditValue = HtmlEncode($this->POKOK_JUAL->CurrentValue);
            $this->POKOK_JUAL->PlaceHolder = RemoveHtml($this->POKOK_JUAL->caption());
            if (strval($this->POKOK_JUAL->EditValue) != "" && is_numeric($this->POKOK_JUAL->EditValue)) {
                $this->POKOK_JUAL->EditValue = FormatNumber($this->POKOK_JUAL->EditValue, -2, -2, -2, -2);
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

            // CASHIER
            $this->CASHIER->EditAttrs["class"] = "form-control";
            $this->CASHIER->EditCustomAttributes = "";
            if (!$this->CASHIER->Raw) {
                $this->CASHIER->CurrentValue = HtmlDecode($this->CASHIER->CurrentValue);
            }
            $this->CASHIER->EditValue = HtmlEncode($this->CASHIER->CurrentValue);
            $this->CASHIER->PlaceHolder = RemoveHtml($this->CASHIER->caption());

            // islunas
            $this->islunas->EditAttrs["class"] = "form-control";
            $this->islunas->EditCustomAttributes = "";
            if (!$this->islunas->Raw) {
                $this->islunas->CurrentValue = HtmlDecode($this->islunas->CurrentValue);
            }
            $this->islunas->EditValue = HtmlEncode($this->islunas->CurrentValue);
            $this->islunas->PlaceHolder = RemoveHtml($this->islunas->caption());

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

            // ISCETAK
            $this->ISCETAK->EditAttrs["class"] = "form-control";
            $this->ISCETAK->EditCustomAttributes = "";
            if (!$this->ISCETAK->Raw) {
                $this->ISCETAK->CurrentValue = HtmlDecode($this->ISCETAK->CurrentValue);
            }
            $this->ISCETAK->EditValue = HtmlEncode($this->ISCETAK->CurrentValue);
            $this->ISCETAK->PlaceHolder = RemoveHtml($this->ISCETAK->caption());

            // print_date
            $this->print_date->EditAttrs["class"] = "form-control";
            $this->print_date->EditCustomAttributes = "";
            $this->print_date->EditValue = HtmlEncode(FormatDateTime($this->print_date->CurrentValue, 8));
            $this->print_date->PlaceHolder = RemoveHtml($this->print_date->caption());

            // DOSE
            $this->DOSE->EditAttrs["class"] = "form-control";
            $this->DOSE->EditCustomAttributes = "";
            $this->DOSE->EditValue = HtmlEncode($this->DOSE->CurrentValue);
            $this->DOSE->PlaceHolder = RemoveHtml($this->DOSE->caption());
            if (strval($this->DOSE->EditValue) != "" && is_numeric($this->DOSE->EditValue)) {
                $this->DOSE->EditValue = FormatNumber($this->DOSE->EditValue, -2, -2, -2, -2);
            }

            // JML_BKS
            $this->JML_BKS->EditAttrs["class"] = "form-control";
            $this->JML_BKS->EditCustomAttributes = "";
            $this->JML_BKS->EditValue = HtmlEncode($this->JML_BKS->CurrentValue);
            $this->JML_BKS->PlaceHolder = RemoveHtml($this->JML_BKS->caption());

            // ORIG_DOSE
            $this->ORIG_DOSE->EditAttrs["class"] = "form-control";
            $this->ORIG_DOSE->EditCustomAttributes = "";
            $this->ORIG_DOSE->EditValue = HtmlEncode($this->ORIG_DOSE->CurrentValue);
            $this->ORIG_DOSE->PlaceHolder = RemoveHtml($this->ORIG_DOSE->caption());
            if (strval($this->ORIG_DOSE->EditValue) != "" && is_numeric($this->ORIG_DOSE->EditValue)) {
                $this->ORIG_DOSE->EditValue = FormatNumber($this->ORIG_DOSE->EditValue, -2, -2, -2, -2);
            }

            // RESEP_KE
            $this->RESEP_KE->EditAttrs["class"] = "form-control";
            $this->RESEP_KE->EditCustomAttributes = "";
            $this->RESEP_KE->EditValue = HtmlEncode($this->RESEP_KE->CurrentValue);
            $this->RESEP_KE->PlaceHolder = RemoveHtml($this->RESEP_KE->caption());

            // ITER_KE
            $this->ITER_KE->EditAttrs["class"] = "form-control";
            $this->ITER_KE->EditCustomAttributes = "";
            $this->ITER_KE->EditValue = HtmlEncode($this->ITER_KE->CurrentValue);
            $this->ITER_KE->PlaceHolder = RemoveHtml($this->ITER_KE->caption());

            // KUITANSI_ID
            $this->KUITANSI_ID->EditAttrs["class"] = "form-control";
            $this->KUITANSI_ID->EditCustomAttributes = "";
            if (!$this->KUITANSI_ID->Raw) {
                $this->KUITANSI_ID->CurrentValue = HtmlDecode($this->KUITANSI_ID->CurrentValue);
            }
            $this->KUITANSI_ID->EditValue = HtmlEncode($this->KUITANSI_ID->CurrentValue);
            $this->KUITANSI_ID->PlaceHolder = RemoveHtml($this->KUITANSI_ID->caption());

            // PEMBULATAN
            $this->PEMBULATAN->EditAttrs["class"] = "form-control";
            $this->PEMBULATAN->EditCustomAttributes = "";
            $this->PEMBULATAN->EditValue = HtmlEncode($this->PEMBULATAN->CurrentValue);
            $this->PEMBULATAN->PlaceHolder = RemoveHtml($this->PEMBULATAN->caption());
            if (strval($this->PEMBULATAN->EditValue) != "" && is_numeric($this->PEMBULATAN->EditValue)) {
                $this->PEMBULATAN->EditValue = FormatNumber($this->PEMBULATAN->EditValue, -2, -2, -2, -2);
            }

            // KAL_ID
            $this->KAL_ID->EditAttrs["class"] = "form-control";
            $this->KAL_ID->EditCustomAttributes = "";
            if (!$this->KAL_ID->Raw) {
                $this->KAL_ID->CurrentValue = HtmlDecode($this->KAL_ID->CurrentValue);
            }
            $this->KAL_ID->EditValue = HtmlEncode($this->KAL_ID->CurrentValue);
            $this->KAL_ID->PlaceHolder = RemoveHtml($this->KAL_ID->caption());

            // INVOICE_ID
            $this->INVOICE_ID->EditAttrs["class"] = "form-control";
            $this->INVOICE_ID->EditCustomAttributes = "";
            if (!$this->INVOICE_ID->Raw) {
                $this->INVOICE_ID->CurrentValue = HtmlDecode($this->INVOICE_ID->CurrentValue);
            }
            $this->INVOICE_ID->EditValue = HtmlEncode($this->INVOICE_ID->CurrentValue);
            $this->INVOICE_ID->PlaceHolder = RemoveHtml($this->INVOICE_ID->caption());

            // SERVICE_TIME
            $this->SERVICE_TIME->EditAttrs["class"] = "form-control";
            $this->SERVICE_TIME->EditCustomAttributes = "";
            $this->SERVICE_TIME->EditValue = HtmlEncode(FormatDateTime($this->SERVICE_TIME->CurrentValue, 8));
            $this->SERVICE_TIME->PlaceHolder = RemoveHtml($this->SERVICE_TIME->caption());

            // TAKEN_TIME
            $this->TAKEN_TIME->EditAttrs["class"] = "form-control";
            $this->TAKEN_TIME->EditCustomAttributes = "";
            $this->TAKEN_TIME->EditValue = HtmlEncode(FormatDateTime($this->TAKEN_TIME->CurrentValue, 8));
            $this->TAKEN_TIME->PlaceHolder = RemoveHtml($this->TAKEN_TIME->caption());

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

            // SPPBILL
            $this->SPPBILL->EditAttrs["class"] = "form-control";
            $this->SPPBILL->EditCustomAttributes = "";
            if (!$this->SPPBILL->Raw) {
                $this->SPPBILL->CurrentValue = HtmlDecode($this->SPPBILL->CurrentValue);
            }
            $this->SPPBILL->EditValue = HtmlEncode($this->SPPBILL->CurrentValue);
            $this->SPPBILL->PlaceHolder = RemoveHtml($this->SPPBILL->caption());

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

            // SPPKASIR
            $this->SPPKASIR->EditAttrs["class"] = "form-control";
            $this->SPPKASIR->EditCustomAttributes = "";
            if (!$this->SPPKASIR->Raw) {
                $this->SPPKASIR->CurrentValue = HtmlDecode($this->SPPKASIR->CurrentValue);
            }
            $this->SPPKASIR->EditValue = HtmlEncode($this->SPPKASIR->CurrentValue);
            $this->SPPKASIR->PlaceHolder = RemoveHtml($this->SPPKASIR->caption());

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

            // NOSEP
            $this->NOSEP->EditAttrs["class"] = "form-control";
            $this->NOSEP->EditCustomAttributes = "";
            if (!$this->NOSEP->Raw) {
                $this->NOSEP->CurrentValue = HtmlDecode($this->NOSEP->CurrentValue);
            }
            $this->NOSEP->EditValue = HtmlEncode($this->NOSEP->CurrentValue);
            $this->NOSEP->PlaceHolder = RemoveHtml($this->NOSEP->caption());

            // ID
            $this->ID->EditAttrs["class"] = "form-control";
            $this->ID->EditCustomAttributes = "";
            $this->ID->EditValue = $this->ID->CurrentValue;
            $this->ID->ViewCustomAttributes = "";

            // Edit refer script

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

            // QUANTITY
            $this->QUANTITY->LinkCustomAttributes = "";
            $this->QUANTITY->HrefValue = "";

            // MEASURE_ID
            $this->MEASURE_ID->LinkCustomAttributes = "";
            $this->MEASURE_ID->HrefValue = "";

            // DESCRIPTION
            $this->DESCRIPTION->LinkCustomAttributes = "";
            $this->DESCRIPTION->HrefValue = "";

            // RESEP_NO
            $this->RESEP_NO->LinkCustomAttributes = "";
            $this->RESEP_NO->HrefValue = "";

            // DOSE_PRESC
            $this->DOSE_PRESC->LinkCustomAttributes = "";
            $this->DOSE_PRESC->HrefValue = "";

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

            // EMPLOYEE_ID
            $this->EMPLOYEE_ID->LinkCustomAttributes = "";
            $this->EMPLOYEE_ID->HrefValue = "";

            // DESCRIPTION2
            $this->DESCRIPTION2->LinkCustomAttributes = "";
            $this->DESCRIPTION2->HrefValue = "";

            // BRAND_ID
            $this->BRAND_ID->LinkCustomAttributes = "";
            $this->BRAND_ID->HrefValue = "";

            // DOCTOR
            $this->DOCTOR->LinkCustomAttributes = "";
            $this->DOCTOR->HrefValue = "";

            // EXIT_DATE
            $this->EXIT_DATE->LinkCustomAttributes = "";
            $this->EXIT_DATE->HrefValue = "";

            // EMPLOYEE_ID_FROM
            $this->EMPLOYEE_ID_FROM->LinkCustomAttributes = "";
            $this->EMPLOYEE_ID_FROM->HrefValue = "";

            // DOCTOR_FROM
            $this->DOCTOR_FROM->LinkCustomAttributes = "";
            $this->DOCTOR_FROM->HrefValue = "";

            // status_pasien_id
            $this->status_pasien_id->LinkCustomAttributes = "";
            $this->status_pasien_id->HrefValue = "";

            // THENAME
            $this->THENAME->LinkCustomAttributes = "";
            $this->THENAME->HrefValue = "";

            // THEADDRESS
            $this->THEADDRESS->LinkCustomAttributes = "";
            $this->THEADDRESS->HrefValue = "";

            // THEID
            $this->THEID->LinkCustomAttributes = "";
            $this->THEID->HrefValue = "";

            // SERIAL_NB
            $this->SERIAL_NB->LinkCustomAttributes = "";
            $this->SERIAL_NB->HrefValue = "";

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

            // KARYAWAN
            $this->KARYAWAN->LinkCustomAttributes = "";
            $this->KARYAWAN->HrefValue = "";

            // MODIFIED_BY
            $this->MODIFIED_BY->LinkCustomAttributes = "";
            $this->MODIFIED_BY->HrefValue = "";

            // MODIFIED_DATE
            $this->MODIFIED_DATE->LinkCustomAttributes = "";
            $this->MODIFIED_DATE->HrefValue = "";

            // MODIFIED_FROM
            $this->MODIFIED_FROM->LinkCustomAttributes = "";
            $this->MODIFIED_FROM->HrefValue = "";

            // NUMER
            $this->NUMER->LinkCustomAttributes = "";
            $this->NUMER->HrefValue = "";

            // NOTA_NO
            $this->NOTA_NO->LinkCustomAttributes = "";
            $this->NOTA_NO->HrefValue = "";

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

            // AMOUNT_PAID
            $this->AMOUNT_PAID->LinkCustomAttributes = "";
            $this->AMOUNT_PAID->HrefValue = "";

            // DISKON
            $this->DISKON->LinkCustomAttributes = "";
            $this->DISKON->HrefValue = "";

            // SELL_PRICE
            $this->SELL_PRICE->LinkCustomAttributes = "";
            $this->SELL_PRICE->HrefValue = "";

            // ACCOUNT_ID
            $this->ACCOUNT_ID->LinkCustomAttributes = "";
            $this->ACCOUNT_ID->HrefValue = "";

            // subsidi
            $this->subsidi->LinkCustomAttributes = "";
            $this->subsidi->HrefValue = "";

            // PROFESI
            $this->PROFESI->LinkCustomAttributes = "";
            $this->PROFESI->HrefValue = "";

            // EMBALACE
            $this->EMBALACE->LinkCustomAttributes = "";
            $this->EMBALACE->HrefValue = "";

            // DISCOUNT
            $this->DISCOUNT->LinkCustomAttributes = "";
            $this->DISCOUNT->HrefValue = "";

            // AMOUNT
            $this->AMOUNT->LinkCustomAttributes = "";
            $this->AMOUNT->HrefValue = "";

            // PPN
            $this->PPN->LinkCustomAttributes = "";
            $this->PPN->HrefValue = "";

            // ITER
            $this->ITER->LinkCustomAttributes = "";
            $this->ITER->HrefValue = "";

            // PAYOR_ID
            $this->PAYOR_ID->LinkCustomAttributes = "";
            $this->PAYOR_ID->HrefValue = "";

            // STATUS_OBAT
            $this->STATUS_OBAT->LinkCustomAttributes = "";
            $this->STATUS_OBAT->HrefValue = "";

            // SUBSIDISAT
            $this->SUBSIDISAT->LinkCustomAttributes = "";
            $this->SUBSIDISAT->HrefValue = "";

            // MARGIN
            $this->MARGIN->LinkCustomAttributes = "";
            $this->MARGIN->HrefValue = "";

            // POKOK_JUAL
            $this->POKOK_JUAL->LinkCustomAttributes = "";
            $this->POKOK_JUAL->HrefValue = "";

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

            // CORRECTION_ID
            $this->CORRECTION_ID->LinkCustomAttributes = "";
            $this->CORRECTION_ID->HrefValue = "";

            // CORRECTION_BY
            $this->CORRECTION_BY->LinkCustomAttributes = "";
            $this->CORRECTION_BY->HrefValue = "";

            // CASHIER
            $this->CASHIER->LinkCustomAttributes = "";
            $this->CASHIER->HrefValue = "";

            // islunas
            $this->islunas->LinkCustomAttributes = "";
            $this->islunas->HrefValue = "";

            // PAY_METHOD_ID
            $this->PAY_METHOD_ID->LinkCustomAttributes = "";
            $this->PAY_METHOD_ID->HrefValue = "";

            // PAYMENT_DATE
            $this->PAYMENT_DATE->LinkCustomAttributes = "";
            $this->PAYMENT_DATE->HrefValue = "";

            // ISCETAK
            $this->ISCETAK->LinkCustomAttributes = "";
            $this->ISCETAK->HrefValue = "";

            // print_date
            $this->print_date->LinkCustomAttributes = "";
            $this->print_date->HrefValue = "";

            // DOSE
            $this->DOSE->LinkCustomAttributes = "";
            $this->DOSE->HrefValue = "";

            // JML_BKS
            $this->JML_BKS->LinkCustomAttributes = "";
            $this->JML_BKS->HrefValue = "";

            // ORIG_DOSE
            $this->ORIG_DOSE->LinkCustomAttributes = "";
            $this->ORIG_DOSE->HrefValue = "";

            // RESEP_KE
            $this->RESEP_KE->LinkCustomAttributes = "";
            $this->RESEP_KE->HrefValue = "";

            // ITER_KE
            $this->ITER_KE->LinkCustomAttributes = "";
            $this->ITER_KE->HrefValue = "";

            // KUITANSI_ID
            $this->KUITANSI_ID->LinkCustomAttributes = "";
            $this->KUITANSI_ID->HrefValue = "";

            // PEMBULATAN
            $this->PEMBULATAN->LinkCustomAttributes = "";
            $this->PEMBULATAN->HrefValue = "";

            // KAL_ID
            $this->KAL_ID->LinkCustomAttributes = "";
            $this->KAL_ID->HrefValue = "";

            // INVOICE_ID
            $this->INVOICE_ID->LinkCustomAttributes = "";
            $this->INVOICE_ID->HrefValue = "";

            // SERVICE_TIME
            $this->SERVICE_TIME->LinkCustomAttributes = "";
            $this->SERVICE_TIME->HrefValue = "";

            // TAKEN_TIME
            $this->TAKEN_TIME->LinkCustomAttributes = "";
            $this->TAKEN_TIME->HrefValue = "";

            // modified_datesys
            $this->modified_datesys->LinkCustomAttributes = "";
            $this->modified_datesys->HrefValue = "";

            // TRANS_ID
            $this->TRANS_ID->LinkCustomAttributes = "";
            $this->TRANS_ID->HrefValue = "";

            // SPPBILL
            $this->SPPBILL->LinkCustomAttributes = "";
            $this->SPPBILL->HrefValue = "";

            // SPPBILLDATE
            $this->SPPBILLDATE->LinkCustomAttributes = "";
            $this->SPPBILLDATE->HrefValue = "";

            // SPPBILLUSER
            $this->SPPBILLUSER->LinkCustomAttributes = "";
            $this->SPPBILLUSER->HrefValue = "";

            // SPPKASIR
            $this->SPPKASIR->LinkCustomAttributes = "";
            $this->SPPKASIR->HrefValue = "";

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

            // NOSEP
            $this->NOSEP->LinkCustomAttributes = "";
            $this->NOSEP->HrefValue = "";

            // ID
            $this->ID->LinkCustomAttributes = "";
            $this->ID->HrefValue = "";
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
        if ($this->DESCRIPTION->Required) {
            if (!$this->DESCRIPTION->IsDetailKey && EmptyValue($this->DESCRIPTION->FormValue)) {
                $this->DESCRIPTION->addErrorMessage(str_replace("%s", $this->DESCRIPTION->caption(), $this->DESCRIPTION->RequiredErrorMessage));
            }
        }
        if ($this->RESEP_NO->Required) {
            if (!$this->RESEP_NO->IsDetailKey && EmptyValue($this->RESEP_NO->FormValue)) {
                $this->RESEP_NO->addErrorMessage(str_replace("%s", $this->RESEP_NO->caption(), $this->RESEP_NO->RequiredErrorMessage));
            }
        }
        if ($this->DOSE_PRESC->Required) {
            if (!$this->DOSE_PRESC->IsDetailKey && EmptyValue($this->DOSE_PRESC->FormValue)) {
                $this->DOSE_PRESC->addErrorMessage(str_replace("%s", $this->DOSE_PRESC->caption(), $this->DOSE_PRESC->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->DOSE_PRESC->FormValue)) {
            $this->DOSE_PRESC->addErrorMessage($this->DOSE_PRESC->getErrorMessage(false));
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
        if ($this->EXIT_DATE->Required) {
            if (!$this->EXIT_DATE->IsDetailKey && EmptyValue($this->EXIT_DATE->FormValue)) {
                $this->EXIT_DATE->addErrorMessage(str_replace("%s", $this->EXIT_DATE->caption(), $this->EXIT_DATE->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->EXIT_DATE->FormValue)) {
            $this->EXIT_DATE->addErrorMessage($this->EXIT_DATE->getErrorMessage(false));
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
        if ($this->SERIAL_NB->Required) {
            if (!$this->SERIAL_NB->IsDetailKey && EmptyValue($this->SERIAL_NB->FormValue)) {
                $this->SERIAL_NB->addErrorMessage(str_replace("%s", $this->SERIAL_NB->caption(), $this->SERIAL_NB->RequiredErrorMessage));
            }
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
        if ($this->KARYAWAN->Required) {
            if (!$this->KARYAWAN->IsDetailKey && EmptyValue($this->KARYAWAN->FormValue)) {
                $this->KARYAWAN->addErrorMessage(str_replace("%s", $this->KARYAWAN->caption(), $this->KARYAWAN->RequiredErrorMessage));
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
        if ($this->NUMER->Required) {
            if (!$this->NUMER->IsDetailKey && EmptyValue($this->NUMER->FormValue)) {
                $this->NUMER->addErrorMessage(str_replace("%s", $this->NUMER->caption(), $this->NUMER->RequiredErrorMessage));
            }
        }
        if ($this->NOTA_NO->Required) {
            if (!$this->NOTA_NO->IsDetailKey && EmptyValue($this->NOTA_NO->FormValue)) {
                $this->NOTA_NO->addErrorMessage(str_replace("%s", $this->NOTA_NO->caption(), $this->NOTA_NO->RequiredErrorMessage));
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
        if ($this->AMOUNT_PAID->Required) {
            if (!$this->AMOUNT_PAID->IsDetailKey && EmptyValue($this->AMOUNT_PAID->FormValue)) {
                $this->AMOUNT_PAID->addErrorMessage(str_replace("%s", $this->AMOUNT_PAID->caption(), $this->AMOUNT_PAID->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->AMOUNT_PAID->FormValue)) {
            $this->AMOUNT_PAID->addErrorMessage($this->AMOUNT_PAID->getErrorMessage(false));
        }
        if ($this->DISKON->Required) {
            if (!$this->DISKON->IsDetailKey && EmptyValue($this->DISKON->FormValue)) {
                $this->DISKON->addErrorMessage(str_replace("%s", $this->DISKON->caption(), $this->DISKON->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->DISKON->FormValue)) {
            $this->DISKON->addErrorMessage($this->DISKON->getErrorMessage(false));
        }
        if ($this->SELL_PRICE->Required) {
            if (!$this->SELL_PRICE->IsDetailKey && EmptyValue($this->SELL_PRICE->FormValue)) {
                $this->SELL_PRICE->addErrorMessage(str_replace("%s", $this->SELL_PRICE->caption(), $this->SELL_PRICE->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->SELL_PRICE->FormValue)) {
            $this->SELL_PRICE->addErrorMessage($this->SELL_PRICE->getErrorMessage(false));
        }
        if ($this->ACCOUNT_ID->Required) {
            if (!$this->ACCOUNT_ID->IsDetailKey && EmptyValue($this->ACCOUNT_ID->FormValue)) {
                $this->ACCOUNT_ID->addErrorMessage(str_replace("%s", $this->ACCOUNT_ID->caption(), $this->ACCOUNT_ID->RequiredErrorMessage));
            }
        }
        if ($this->subsidi->Required) {
            if (!$this->subsidi->IsDetailKey && EmptyValue($this->subsidi->FormValue)) {
                $this->subsidi->addErrorMessage(str_replace("%s", $this->subsidi->caption(), $this->subsidi->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->subsidi->FormValue)) {
            $this->subsidi->addErrorMessage($this->subsidi->getErrorMessage(false));
        }
        if ($this->PROFESI->Required) {
            if (!$this->PROFESI->IsDetailKey && EmptyValue($this->PROFESI->FormValue)) {
                $this->PROFESI->addErrorMessage(str_replace("%s", $this->PROFESI->caption(), $this->PROFESI->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->PROFESI->FormValue)) {
            $this->PROFESI->addErrorMessage($this->PROFESI->getErrorMessage(false));
        }
        if ($this->EMBALACE->Required) {
            if (!$this->EMBALACE->IsDetailKey && EmptyValue($this->EMBALACE->FormValue)) {
                $this->EMBALACE->addErrorMessage(str_replace("%s", $this->EMBALACE->caption(), $this->EMBALACE->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->EMBALACE->FormValue)) {
            $this->EMBALACE->addErrorMessage($this->EMBALACE->getErrorMessage(false));
        }
        if ($this->DISCOUNT->Required) {
            if (!$this->DISCOUNT->IsDetailKey && EmptyValue($this->DISCOUNT->FormValue)) {
                $this->DISCOUNT->addErrorMessage(str_replace("%s", $this->DISCOUNT->caption(), $this->DISCOUNT->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->DISCOUNT->FormValue)) {
            $this->DISCOUNT->addErrorMessage($this->DISCOUNT->getErrorMessage(false));
        }
        if ($this->AMOUNT->Required) {
            if (!$this->AMOUNT->IsDetailKey && EmptyValue($this->AMOUNT->FormValue)) {
                $this->AMOUNT->addErrorMessage(str_replace("%s", $this->AMOUNT->caption(), $this->AMOUNT->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->AMOUNT->FormValue)) {
            $this->AMOUNT->addErrorMessage($this->AMOUNT->getErrorMessage(false));
        }
        if ($this->PPN->Required) {
            if (!$this->PPN->IsDetailKey && EmptyValue($this->PPN->FormValue)) {
                $this->PPN->addErrorMessage(str_replace("%s", $this->PPN->caption(), $this->PPN->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->PPN->FormValue)) {
            $this->PPN->addErrorMessage($this->PPN->getErrorMessage(false));
        }
        if ($this->ITER->Required) {
            if (!$this->ITER->IsDetailKey && EmptyValue($this->ITER->FormValue)) {
                $this->ITER->addErrorMessage(str_replace("%s", $this->ITER->caption(), $this->ITER->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->ITER->FormValue)) {
            $this->ITER->addErrorMessage($this->ITER->getErrorMessage(false));
        }
        if ($this->PAYOR_ID->Required) {
            if (!$this->PAYOR_ID->IsDetailKey && EmptyValue($this->PAYOR_ID->FormValue)) {
                $this->PAYOR_ID->addErrorMessage(str_replace("%s", $this->PAYOR_ID->caption(), $this->PAYOR_ID->RequiredErrorMessage));
            }
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
        if ($this->MARGIN->Required) {
            if (!$this->MARGIN->IsDetailKey && EmptyValue($this->MARGIN->FormValue)) {
                $this->MARGIN->addErrorMessage(str_replace("%s", $this->MARGIN->caption(), $this->MARGIN->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->MARGIN->FormValue)) {
            $this->MARGIN->addErrorMessage($this->MARGIN->getErrorMessage(false));
        }
        if ($this->POKOK_JUAL->Required) {
            if (!$this->POKOK_JUAL->IsDetailKey && EmptyValue($this->POKOK_JUAL->FormValue)) {
                $this->POKOK_JUAL->addErrorMessage(str_replace("%s", $this->POKOK_JUAL->caption(), $this->POKOK_JUAL->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->POKOK_JUAL->FormValue)) {
            $this->POKOK_JUAL->addErrorMessage($this->POKOK_JUAL->getErrorMessage(false));
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
        if ($this->CASHIER->Required) {
            if (!$this->CASHIER->IsDetailKey && EmptyValue($this->CASHIER->FormValue)) {
                $this->CASHIER->addErrorMessage(str_replace("%s", $this->CASHIER->caption(), $this->CASHIER->RequiredErrorMessage));
            }
        }
        if ($this->islunas->Required) {
            if (!$this->islunas->IsDetailKey && EmptyValue($this->islunas->FormValue)) {
                $this->islunas->addErrorMessage(str_replace("%s", $this->islunas->caption(), $this->islunas->RequiredErrorMessage));
            }
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
        if ($this->ISCETAK->Required) {
            if (!$this->ISCETAK->IsDetailKey && EmptyValue($this->ISCETAK->FormValue)) {
                $this->ISCETAK->addErrorMessage(str_replace("%s", $this->ISCETAK->caption(), $this->ISCETAK->RequiredErrorMessage));
            }
        }
        if ($this->print_date->Required) {
            if (!$this->print_date->IsDetailKey && EmptyValue($this->print_date->FormValue)) {
                $this->print_date->addErrorMessage(str_replace("%s", $this->print_date->caption(), $this->print_date->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->print_date->FormValue)) {
            $this->print_date->addErrorMessage($this->print_date->getErrorMessage(false));
        }
        if ($this->DOSE->Required) {
            if (!$this->DOSE->IsDetailKey && EmptyValue($this->DOSE->FormValue)) {
                $this->DOSE->addErrorMessage(str_replace("%s", $this->DOSE->caption(), $this->DOSE->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->DOSE->FormValue)) {
            $this->DOSE->addErrorMessage($this->DOSE->getErrorMessage(false));
        }
        if ($this->JML_BKS->Required) {
            if (!$this->JML_BKS->IsDetailKey && EmptyValue($this->JML_BKS->FormValue)) {
                $this->JML_BKS->addErrorMessage(str_replace("%s", $this->JML_BKS->caption(), $this->JML_BKS->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->JML_BKS->FormValue)) {
            $this->JML_BKS->addErrorMessage($this->JML_BKS->getErrorMessage(false));
        }
        if ($this->ORIG_DOSE->Required) {
            if (!$this->ORIG_DOSE->IsDetailKey && EmptyValue($this->ORIG_DOSE->FormValue)) {
                $this->ORIG_DOSE->addErrorMessage(str_replace("%s", $this->ORIG_DOSE->caption(), $this->ORIG_DOSE->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->ORIG_DOSE->FormValue)) {
            $this->ORIG_DOSE->addErrorMessage($this->ORIG_DOSE->getErrorMessage(false));
        }
        if ($this->RESEP_KE->Required) {
            if (!$this->RESEP_KE->IsDetailKey && EmptyValue($this->RESEP_KE->FormValue)) {
                $this->RESEP_KE->addErrorMessage(str_replace("%s", $this->RESEP_KE->caption(), $this->RESEP_KE->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->RESEP_KE->FormValue)) {
            $this->RESEP_KE->addErrorMessage($this->RESEP_KE->getErrorMessage(false));
        }
        if ($this->ITER_KE->Required) {
            if (!$this->ITER_KE->IsDetailKey && EmptyValue($this->ITER_KE->FormValue)) {
                $this->ITER_KE->addErrorMessage(str_replace("%s", $this->ITER_KE->caption(), $this->ITER_KE->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->ITER_KE->FormValue)) {
            $this->ITER_KE->addErrorMessage($this->ITER_KE->getErrorMessage(false));
        }
        if ($this->KUITANSI_ID->Required) {
            if (!$this->KUITANSI_ID->IsDetailKey && EmptyValue($this->KUITANSI_ID->FormValue)) {
                $this->KUITANSI_ID->addErrorMessage(str_replace("%s", $this->KUITANSI_ID->caption(), $this->KUITANSI_ID->RequiredErrorMessage));
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
        if ($this->KAL_ID->Required) {
            if (!$this->KAL_ID->IsDetailKey && EmptyValue($this->KAL_ID->FormValue)) {
                $this->KAL_ID->addErrorMessage(str_replace("%s", $this->KAL_ID->caption(), $this->KAL_ID->RequiredErrorMessage));
            }
        }
        if ($this->INVOICE_ID->Required) {
            if (!$this->INVOICE_ID->IsDetailKey && EmptyValue($this->INVOICE_ID->FormValue)) {
                $this->INVOICE_ID->addErrorMessage(str_replace("%s", $this->INVOICE_ID->caption(), $this->INVOICE_ID->RequiredErrorMessage));
            }
        }
        if ($this->SERVICE_TIME->Required) {
            if (!$this->SERVICE_TIME->IsDetailKey && EmptyValue($this->SERVICE_TIME->FormValue)) {
                $this->SERVICE_TIME->addErrorMessage(str_replace("%s", $this->SERVICE_TIME->caption(), $this->SERVICE_TIME->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->SERVICE_TIME->FormValue)) {
            $this->SERVICE_TIME->addErrorMessage($this->SERVICE_TIME->getErrorMessage(false));
        }
        if ($this->TAKEN_TIME->Required) {
            if (!$this->TAKEN_TIME->IsDetailKey && EmptyValue($this->TAKEN_TIME->FormValue)) {
                $this->TAKEN_TIME->addErrorMessage(str_replace("%s", $this->TAKEN_TIME->caption(), $this->TAKEN_TIME->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->TAKEN_TIME->FormValue)) {
            $this->TAKEN_TIME->addErrorMessage($this->TAKEN_TIME->getErrorMessage(false));
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
        if ($this->SPPBILL->Required) {
            if (!$this->SPPBILL->IsDetailKey && EmptyValue($this->SPPBILL->FormValue)) {
                $this->SPPBILL->addErrorMessage(str_replace("%s", $this->SPPBILL->caption(), $this->SPPBILL->RequiredErrorMessage));
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
        if ($this->SPPKASIR->Required) {
            if (!$this->SPPKASIR->IsDetailKey && EmptyValue($this->SPPKASIR->FormValue)) {
                $this->SPPKASIR->addErrorMessage(str_replace("%s", $this->SPPKASIR->caption(), $this->SPPKASIR->RequiredErrorMessage));
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
        if ($this->NOSEP->Required) {
            if (!$this->NOSEP->IsDetailKey && EmptyValue($this->NOSEP->FormValue)) {
                $this->NOSEP->addErrorMessage(str_replace("%s", $this->NOSEP->caption(), $this->NOSEP->RequiredErrorMessage));
            }
        }
        if ($this->ID->Required) {
            if (!$this->ID->IsDetailKey && EmptyValue($this->ID->FormValue)) {
                $this->ID->addErrorMessage(str_replace("%s", $this->ID->caption(), $this->ID->RequiredErrorMessage));
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

            // ORG_UNIT_CODE
            $this->ORG_UNIT_CODE->setDbValueDef($rsnew, $this->ORG_UNIT_CODE->CurrentValue, "", $this->ORG_UNIT_CODE->ReadOnly);

            // BILL_ID
            $this->BILL_ID->setDbValueDef($rsnew, $this->BILL_ID->CurrentValue, "", $this->BILL_ID->ReadOnly);

            // NO_REGISTRATION
            $this->NO_REGISTRATION->setDbValueDef($rsnew, $this->NO_REGISTRATION->CurrentValue, "", $this->NO_REGISTRATION->ReadOnly);

            // VISIT_ID
            if ($this->VISIT_ID->getSessionValue() != "") {
                $this->VISIT_ID->ReadOnly = true;
            }
            $this->VISIT_ID->setDbValueDef($rsnew, $this->VISIT_ID->CurrentValue, "", $this->VISIT_ID->ReadOnly);

            // TARIF_ID
            $this->TARIF_ID->setDbValueDef($rsnew, $this->TARIF_ID->CurrentValue, null, $this->TARIF_ID->ReadOnly);

            // CLASS_ID
            $this->CLASS_ID->setDbValueDef($rsnew, $this->CLASS_ID->CurrentValue, null, $this->CLASS_ID->ReadOnly);

            // CLINIC_ID
            $this->CLINIC_ID->setDbValueDef($rsnew, $this->CLINIC_ID->CurrentValue, null, $this->CLINIC_ID->ReadOnly);

            // CLINIC_ID_FROM
            $this->CLINIC_ID_FROM->setDbValueDef($rsnew, $this->CLINIC_ID_FROM->CurrentValue, null, $this->CLINIC_ID_FROM->ReadOnly);

            // TREATMENT
            $this->TREATMENT->setDbValueDef($rsnew, $this->TREATMENT->CurrentValue, null, $this->TREATMENT->ReadOnly);

            // TREAT_DATE
            $this->TREAT_DATE->setDbValueDef($rsnew, UnFormatDateTime($this->TREAT_DATE->CurrentValue, 0), null, $this->TREAT_DATE->ReadOnly);

            // QUANTITY
            $this->QUANTITY->setDbValueDef($rsnew, $this->QUANTITY->CurrentValue, null, $this->QUANTITY->ReadOnly);

            // MEASURE_ID
            $this->MEASURE_ID->setDbValueDef($rsnew, $this->MEASURE_ID->CurrentValue, null, $this->MEASURE_ID->ReadOnly);

            // DESCRIPTION
            $this->DESCRIPTION->setDbValueDef($rsnew, $this->DESCRIPTION->CurrentValue, null, $this->DESCRIPTION->ReadOnly);

            // RESEP_NO
            $this->RESEP_NO->setDbValueDef($rsnew, $this->RESEP_NO->CurrentValue, null, $this->RESEP_NO->ReadOnly);

            // DOSE_PRESC
            $this->DOSE_PRESC->setDbValueDef($rsnew, $this->DOSE_PRESC->CurrentValue, null, $this->DOSE_PRESC->ReadOnly);

            // SOLD_STATUS
            $this->SOLD_STATUS->setDbValueDef($rsnew, $this->SOLD_STATUS->CurrentValue, null, $this->SOLD_STATUS->ReadOnly);

            // RACIKAN
            $this->RACIKAN->setDbValueDef($rsnew, $this->RACIKAN->CurrentValue, null, $this->RACIKAN->ReadOnly);

            // CLASS_ROOM_ID
            $this->CLASS_ROOM_ID->setDbValueDef($rsnew, $this->CLASS_ROOM_ID->CurrentValue, null, $this->CLASS_ROOM_ID->ReadOnly);

            // KELUAR_ID
            $this->KELUAR_ID->setDbValueDef($rsnew, $this->KELUAR_ID->CurrentValue, null, $this->KELUAR_ID->ReadOnly);

            // BED_ID
            $this->BED_ID->setDbValueDef($rsnew, $this->BED_ID->CurrentValue, null, $this->BED_ID->ReadOnly);

            // EMPLOYEE_ID
            $this->EMPLOYEE_ID->setDbValueDef($rsnew, $this->EMPLOYEE_ID->CurrentValue, null, $this->EMPLOYEE_ID->ReadOnly);

            // DESCRIPTION2
            $this->DESCRIPTION2->setDbValueDef($rsnew, $this->DESCRIPTION2->CurrentValue, null, $this->DESCRIPTION2->ReadOnly);

            // BRAND_ID
            $this->BRAND_ID->setDbValueDef($rsnew, $this->BRAND_ID->CurrentValue, null, $this->BRAND_ID->ReadOnly);

            // DOCTOR
            $this->DOCTOR->setDbValueDef($rsnew, $this->DOCTOR->CurrentValue, null, $this->DOCTOR->ReadOnly);

            // EXIT_DATE
            $this->EXIT_DATE->setDbValueDef($rsnew, UnFormatDateTime($this->EXIT_DATE->CurrentValue, 0), null, $this->EXIT_DATE->ReadOnly);

            // EMPLOYEE_ID_FROM
            $this->EMPLOYEE_ID_FROM->setDbValueDef($rsnew, $this->EMPLOYEE_ID_FROM->CurrentValue, null, $this->EMPLOYEE_ID_FROM->ReadOnly);

            // DOCTOR_FROM
            $this->DOCTOR_FROM->setDbValueDef($rsnew, $this->DOCTOR_FROM->CurrentValue, null, $this->DOCTOR_FROM->ReadOnly);

            // status_pasien_id
            $this->status_pasien_id->setDbValueDef($rsnew, $this->status_pasien_id->CurrentValue, null, $this->status_pasien_id->ReadOnly);

            // THENAME
            $this->THENAME->setDbValueDef($rsnew, $this->THENAME->CurrentValue, null, $this->THENAME->ReadOnly);

            // THEADDRESS
            $this->THEADDRESS->setDbValueDef($rsnew, $this->THEADDRESS->CurrentValue, null, $this->THEADDRESS->ReadOnly);

            // THEID
            $this->THEID->setDbValueDef($rsnew, $this->THEID->CurrentValue, null, $this->THEID->ReadOnly);

            // SERIAL_NB
            $this->SERIAL_NB->setDbValueDef($rsnew, $this->SERIAL_NB->CurrentValue, null, $this->SERIAL_NB->ReadOnly);

            // ISRJ
            $this->ISRJ->setDbValueDef($rsnew, $this->ISRJ->CurrentValue, null, $this->ISRJ->ReadOnly);

            // AGEYEAR
            $this->AGEYEAR->setDbValueDef($rsnew, $this->AGEYEAR->CurrentValue, null, $this->AGEYEAR->ReadOnly);

            // AGEMONTH
            $this->AGEMONTH->setDbValueDef($rsnew, $this->AGEMONTH->CurrentValue, null, $this->AGEMONTH->ReadOnly);

            // AGEDAY
            $this->AGEDAY->setDbValueDef($rsnew, $this->AGEDAY->CurrentValue, null, $this->AGEDAY->ReadOnly);

            // GENDER
            $this->GENDER->setDbValueDef($rsnew, $this->GENDER->CurrentValue, null, $this->GENDER->ReadOnly);

            // KARYAWAN
            $this->KARYAWAN->setDbValueDef($rsnew, $this->KARYAWAN->CurrentValue, null, $this->KARYAWAN->ReadOnly);

            // MODIFIED_BY
            $this->MODIFIED_BY->setDbValueDef($rsnew, $this->MODIFIED_BY->CurrentValue, null, $this->MODIFIED_BY->ReadOnly);

            // MODIFIED_DATE
            $this->MODIFIED_DATE->setDbValueDef($rsnew, UnFormatDateTime($this->MODIFIED_DATE->CurrentValue, 0), null, $this->MODIFIED_DATE->ReadOnly);

            // MODIFIED_FROM
            $this->MODIFIED_FROM->setDbValueDef($rsnew, $this->MODIFIED_FROM->CurrentValue, null, $this->MODIFIED_FROM->ReadOnly);

            // NUMER
            $this->NUMER->setDbValueDef($rsnew, $this->NUMER->CurrentValue, null, $this->NUMER->ReadOnly);

            // NOTA_NO
            $this->NOTA_NO->setDbValueDef($rsnew, $this->NOTA_NO->CurrentValue, null, $this->NOTA_NO->ReadOnly);

            // MEASURE_ID2
            $this->MEASURE_ID2->setDbValueDef($rsnew, $this->MEASURE_ID2->CurrentValue, null, $this->MEASURE_ID2->ReadOnly);

            // POTONGAN
            $this->POTONGAN->setDbValueDef($rsnew, $this->POTONGAN->CurrentValue, null, $this->POTONGAN->ReadOnly);

            // BAYAR
            $this->BAYAR->setDbValueDef($rsnew, $this->BAYAR->CurrentValue, null, $this->BAYAR->ReadOnly);

            // RETUR
            $this->RETUR->setDbValueDef($rsnew, $this->RETUR->CurrentValue, null, $this->RETUR->ReadOnly);

            // TARIF_TYPE
            $this->TARIF_TYPE->setDbValueDef($rsnew, $this->TARIF_TYPE->CurrentValue, null, $this->TARIF_TYPE->ReadOnly);

            // PPNVALUE
            $this->PPNVALUE->setDbValueDef($rsnew, $this->PPNVALUE->CurrentValue, null, $this->PPNVALUE->ReadOnly);

            // TAGIHAN
            $this->TAGIHAN->setDbValueDef($rsnew, $this->TAGIHAN->CurrentValue, null, $this->TAGIHAN->ReadOnly);

            // KOREKSI
            $this->KOREKSI->setDbValueDef($rsnew, $this->KOREKSI->CurrentValue, null, $this->KOREKSI->ReadOnly);

            // AMOUNT_PAID
            $this->AMOUNT_PAID->setDbValueDef($rsnew, $this->AMOUNT_PAID->CurrentValue, null, $this->AMOUNT_PAID->ReadOnly);

            // DISKON
            $this->DISKON->setDbValueDef($rsnew, $this->DISKON->CurrentValue, null, $this->DISKON->ReadOnly);

            // SELL_PRICE
            $this->SELL_PRICE->setDbValueDef($rsnew, $this->SELL_PRICE->CurrentValue, null, $this->SELL_PRICE->ReadOnly);

            // ACCOUNT_ID
            $this->ACCOUNT_ID->setDbValueDef($rsnew, $this->ACCOUNT_ID->CurrentValue, null, $this->ACCOUNT_ID->ReadOnly);

            // subsidi
            $this->subsidi->setDbValueDef($rsnew, $this->subsidi->CurrentValue, null, $this->subsidi->ReadOnly);

            // PROFESI
            $this->PROFESI->setDbValueDef($rsnew, $this->PROFESI->CurrentValue, null, $this->PROFESI->ReadOnly);

            // EMBALACE
            $this->EMBALACE->setDbValueDef($rsnew, $this->EMBALACE->CurrentValue, null, $this->EMBALACE->ReadOnly);

            // DISCOUNT
            $this->DISCOUNT->setDbValueDef($rsnew, $this->DISCOUNT->CurrentValue, null, $this->DISCOUNT->ReadOnly);

            // AMOUNT
            $this->AMOUNT->setDbValueDef($rsnew, $this->AMOUNT->CurrentValue, null, $this->AMOUNT->ReadOnly);

            // PPN
            $this->PPN->setDbValueDef($rsnew, $this->PPN->CurrentValue, null, $this->PPN->ReadOnly);

            // ITER
            $this->ITER->setDbValueDef($rsnew, $this->ITER->CurrentValue, null, $this->ITER->ReadOnly);

            // PAYOR_ID
            $this->PAYOR_ID->setDbValueDef($rsnew, $this->PAYOR_ID->CurrentValue, null, $this->PAYOR_ID->ReadOnly);

            // STATUS_OBAT
            $this->STATUS_OBAT->setDbValueDef($rsnew, $this->STATUS_OBAT->CurrentValue, null, $this->STATUS_OBAT->ReadOnly);

            // SUBSIDISAT
            $this->SUBSIDISAT->setDbValueDef($rsnew, $this->SUBSIDISAT->CurrentValue, null, $this->SUBSIDISAT->ReadOnly);

            // MARGIN
            $this->MARGIN->setDbValueDef($rsnew, $this->MARGIN->CurrentValue, null, $this->MARGIN->ReadOnly);

            // POKOK_JUAL
            $this->POKOK_JUAL->setDbValueDef($rsnew, $this->POKOK_JUAL->CurrentValue, null, $this->POKOK_JUAL->ReadOnly);

            // PRINTQ
            $this->PRINTQ->setDbValueDef($rsnew, $this->PRINTQ->CurrentValue, null, $this->PRINTQ->ReadOnly);

            // PRINTED_BY
            $this->PRINTED_BY->setDbValueDef($rsnew, $this->PRINTED_BY->CurrentValue, null, $this->PRINTED_BY->ReadOnly);

            // STOCK_AVAILABLE
            $this->STOCK_AVAILABLE->setDbValueDef($rsnew, $this->STOCK_AVAILABLE->CurrentValue, null, $this->STOCK_AVAILABLE->ReadOnly);

            // STATUS_TARIF
            $this->STATUS_TARIF->setDbValueDef($rsnew, $this->STATUS_TARIF->CurrentValue, null, $this->STATUS_TARIF->ReadOnly);

            // PACKAGE_ID
            $this->PACKAGE_ID->setDbValueDef($rsnew, $this->PACKAGE_ID->CurrentValue, null, $this->PACKAGE_ID->ReadOnly);

            // MODULE_ID
            $this->MODULE_ID->setDbValueDef($rsnew, $this->MODULE_ID->CurrentValue, null, $this->MODULE_ID->ReadOnly);

            // profession
            $this->profession->setDbValueDef($rsnew, $this->profession->CurrentValue, null, $this->profession->ReadOnly);

            // THEORDER
            $this->THEORDER->setDbValueDef($rsnew, $this->THEORDER->CurrentValue, null, $this->THEORDER->ReadOnly);

            // CORRECTION_ID
            $this->CORRECTION_ID->setDbValueDef($rsnew, $this->CORRECTION_ID->CurrentValue, null, $this->CORRECTION_ID->ReadOnly);

            // CORRECTION_BY
            $this->CORRECTION_BY->setDbValueDef($rsnew, $this->CORRECTION_BY->CurrentValue, null, $this->CORRECTION_BY->ReadOnly);

            // CASHIER
            $this->CASHIER->setDbValueDef($rsnew, $this->CASHIER->CurrentValue, null, $this->CASHIER->ReadOnly);

            // islunas
            $this->islunas->setDbValueDef($rsnew, $this->islunas->CurrentValue, null, $this->islunas->ReadOnly);

            // PAY_METHOD_ID
            $this->PAY_METHOD_ID->setDbValueDef($rsnew, $this->PAY_METHOD_ID->CurrentValue, null, $this->PAY_METHOD_ID->ReadOnly);

            // PAYMENT_DATE
            $this->PAYMENT_DATE->setDbValueDef($rsnew, UnFormatDateTime($this->PAYMENT_DATE->CurrentValue, 0), null, $this->PAYMENT_DATE->ReadOnly);

            // ISCETAK
            $this->ISCETAK->setDbValueDef($rsnew, $this->ISCETAK->CurrentValue, null, $this->ISCETAK->ReadOnly);

            // print_date
            $this->print_date->setDbValueDef($rsnew, UnFormatDateTime($this->print_date->CurrentValue, 0), null, $this->print_date->ReadOnly);

            // DOSE
            $this->DOSE->setDbValueDef($rsnew, $this->DOSE->CurrentValue, null, $this->DOSE->ReadOnly);

            // JML_BKS
            $this->JML_BKS->setDbValueDef($rsnew, $this->JML_BKS->CurrentValue, null, $this->JML_BKS->ReadOnly);

            // ORIG_DOSE
            $this->ORIG_DOSE->setDbValueDef($rsnew, $this->ORIG_DOSE->CurrentValue, null, $this->ORIG_DOSE->ReadOnly);

            // RESEP_KE
            $this->RESEP_KE->setDbValueDef($rsnew, $this->RESEP_KE->CurrentValue, null, $this->RESEP_KE->ReadOnly);

            // ITER_KE
            $this->ITER_KE->setDbValueDef($rsnew, $this->ITER_KE->CurrentValue, null, $this->ITER_KE->ReadOnly);

            // KUITANSI_ID
            $this->KUITANSI_ID->setDbValueDef($rsnew, $this->KUITANSI_ID->CurrentValue, null, $this->KUITANSI_ID->ReadOnly);

            // PEMBULATAN
            $this->PEMBULATAN->setDbValueDef($rsnew, $this->PEMBULATAN->CurrentValue, null, $this->PEMBULATAN->ReadOnly);

            // KAL_ID
            $this->KAL_ID->setDbValueDef($rsnew, $this->KAL_ID->CurrentValue, null, $this->KAL_ID->ReadOnly);

            // INVOICE_ID
            $this->INVOICE_ID->setDbValueDef($rsnew, $this->INVOICE_ID->CurrentValue, null, $this->INVOICE_ID->ReadOnly);

            // SERVICE_TIME
            $this->SERVICE_TIME->setDbValueDef($rsnew, UnFormatDateTime($this->SERVICE_TIME->CurrentValue, 0), null, $this->SERVICE_TIME->ReadOnly);

            // TAKEN_TIME
            $this->TAKEN_TIME->setDbValueDef($rsnew, UnFormatDateTime($this->TAKEN_TIME->CurrentValue, 0), null, $this->TAKEN_TIME->ReadOnly);

            // modified_datesys
            $this->modified_datesys->setDbValueDef($rsnew, UnFormatDateTime($this->modified_datesys->CurrentValue, 0), null, $this->modified_datesys->ReadOnly);

            // TRANS_ID
            $this->TRANS_ID->setDbValueDef($rsnew, $this->TRANS_ID->CurrentValue, null, $this->TRANS_ID->ReadOnly);

            // SPPBILL
            $this->SPPBILL->setDbValueDef($rsnew, $this->SPPBILL->CurrentValue, null, $this->SPPBILL->ReadOnly);

            // SPPBILLDATE
            $this->SPPBILLDATE->setDbValueDef($rsnew, UnFormatDateTime($this->SPPBILLDATE->CurrentValue, 0), null, $this->SPPBILLDATE->ReadOnly);

            // SPPBILLUSER
            $this->SPPBILLUSER->setDbValueDef($rsnew, $this->SPPBILLUSER->CurrentValue, null, $this->SPPBILLUSER->ReadOnly);

            // SPPKASIR
            $this->SPPKASIR->setDbValueDef($rsnew, $this->SPPKASIR->CurrentValue, null, $this->SPPKASIR->ReadOnly);

            // SPPKASIRDATE
            $this->SPPKASIRDATE->setDbValueDef($rsnew, UnFormatDateTime($this->SPPKASIRDATE->CurrentValue, 0), null, $this->SPPKASIRDATE->ReadOnly);

            // SPPKASIRUSER
            $this->SPPKASIRUSER->setDbValueDef($rsnew, $this->SPPKASIRUSER->CurrentValue, null, $this->SPPKASIRUSER->ReadOnly);

            // SPPPOLI
            $this->SPPPOLI->setDbValueDef($rsnew, $this->SPPPOLI->CurrentValue, null, $this->SPPPOLI->ReadOnly);

            // SPPPOLIUSER
            $this->SPPPOLIUSER->setDbValueDef($rsnew, $this->SPPPOLIUSER->CurrentValue, null, $this->SPPPOLIUSER->ReadOnly);

            // SPPPOLIDATE
            $this->SPPPOLIDATE->setDbValueDef($rsnew, UnFormatDateTime($this->SPPPOLIDATE->CurrentValue, 0), null, $this->SPPPOLIDATE->ReadOnly);

            // NOSEP
            $this->NOSEP->setDbValueDef($rsnew, $this->NOSEP->CurrentValue, null, $this->NOSEP->ReadOnly);

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
            }
        }
        if ($validMaster) {
            // Save current master table
            $this->setCurrentMasterTable($masterTblVar);
            $this->setSessionWhere($this->getDetailFilter());

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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("VTreatList"), "", $this->TableVar, true);
        $pageId = "edit";
        $Breadcrumb->add("edit", $pageId, $url);
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
}
