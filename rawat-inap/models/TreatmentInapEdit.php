<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class TreatmentInapEdit extends TreatmentInap
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'TREATMENT_INAP';

    // Page object name
    public $PageObjName = "TreatmentInapEdit";

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

        // Table object (TREATMENT_INAP)
        if (!isset($GLOBALS["TREATMENT_INAP"]) || get_class($GLOBALS["TREATMENT_INAP"]) == PROJECT_NAMESPACE . "TREATMENT_INAP") {
            $GLOBALS["TREATMENT_INAP"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

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

            // Handle modal response
            if ($this->IsModal) { // Show as modal
                $row = ["url" => GetUrl($url), "modal" => "1"];
                $pageName = GetPageName($url);
                if ($pageName != $this->getListUrl()) { // Not List page
                    $row["caption"] = $this->getModalCaption($pageName);
                    if ($pageName == "TreatmentInapView") {
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
        $this->BILL_ID->Visible = false;
        $this->NO_REGISTRATION->Visible = false;
        $this->VISIT_ID->setVisibility();
        $this->TARIF_ID->setVisibility();
        $this->CLASS_ID->Visible = false;
        $this->CLINIC_ID->setVisibility();
        $this->CLINIC_ID_FROM->Visible = false;
        $this->TREATMENT->setVisibility();
        $this->TREAT_DATE->Visible = false;
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
        $this->CLINIC_TYPE->Visible = false;
        $this->ID_1->setVisibility();
        $this->ORG_UNIT_CODE->Visible = false;
        $this->BILL_ID_1->Visible = false;
        $this->NO_REGISTRATION_1->Visible = false;
        $this->VISIT_ID_1->Visible = false;
        $this->TARIF_ID_1->Visible = false;
        $this->CLASS_ID_1->Visible = false;
        $this->CLINIC_ID_1->Visible = false;
        $this->CLINIC_ID_FROM_1->Visible = false;
        $this->TREATMENT_1->Visible = false;
        $this->TREAT_DATE_1->Visible = false;
        $this->QUANTITY_1->Visible = false;
        $this->MEASURE_ID->setVisibility();
        $this->MEASURE_ID_1->Visible = false;
        $this->TRANS_ID_1->Visible = false;
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
                    $this->terminate("TreatmentInapList"); // No matching record, return to list
                    return;
                }
                break;
            case "update": // Update
                $returnUrl = $this->getReturnUrl();
                if (GetPageName($returnUrl) == "TreatmentInapList") {
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

        // Check field name 'CLINIC_ID' first before field var 'x_CLINIC_ID'
        $val = $CurrentForm->hasValue("CLINIC_ID") ? $CurrentForm->getValue("CLINIC_ID") : $CurrentForm->getValue("x_CLINIC_ID");
        if (!$this->CLINIC_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->CLINIC_ID->Visible = false; // Disable update for API request
            } else {
                $this->CLINIC_ID->setFormValue($val);
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

        // Check field name 'QUANTITY' first before field var 'x_QUANTITY'
        $val = $CurrentForm->hasValue("QUANTITY") ? $CurrentForm->getValue("QUANTITY") : $CurrentForm->getValue("x_QUANTITY");
        if (!$this->QUANTITY->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->QUANTITY->Visible = false; // Disable update for API request
            } else {
                $this->QUANTITY->setFormValue($val);
            }
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

        // Check field name 'ID' first before field var 'x_ID'
        $val = $CurrentForm->hasValue("ID") ? $CurrentForm->getValue("ID") : $CurrentForm->getValue("x_ID");
        if (!$this->ID->IsDetailKey) {
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

        // Check field name 'SUBSIDI' first before field var 'x_SUBSIDI'
        $val = $CurrentForm->hasValue("SUBSIDI") ? $CurrentForm->getValue("SUBSIDI") : $CurrentForm->getValue("x_SUBSIDI");
        if (!$this->SUBSIDI->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->SUBSIDI->Visible = false; // Disable update for API request
            } else {
                $this->SUBSIDI->setFormValue($val);
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

        // Check field name 'ISCETAK' first before field var 'x_ISCETAK'
        $val = $CurrentForm->hasValue("ISCETAK") ? $CurrentForm->getValue("ISCETAK") : $CurrentForm->getValue("x_ISCETAK");
        if (!$this->ISCETAK->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ISCETAK->Visible = false; // Disable update for API request
            } else {
                $this->ISCETAK->setFormValue($val);
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

        // Check field name 'KUITANSI_ID' first before field var 'x_KUITANSI_ID'
        $val = $CurrentForm->hasValue("KUITANSI_ID") ? $CurrentForm->getValue("KUITANSI_ID") : $CurrentForm->getValue("x_KUITANSI_ID");
        if (!$this->KUITANSI_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->KUITANSI_ID->Visible = false; // Disable update for API request
            } else {
                $this->KUITANSI_ID->setFormValue($val);
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

        // Check field name 'TAGIHAN' first before field var 'x_TAGIHAN'
        $val = $CurrentForm->hasValue("TAGIHAN") ? $CurrentForm->getValue("TAGIHAN") : $CurrentForm->getValue("x_TAGIHAN");
        if (!$this->TAGIHAN->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->TAGIHAN->Visible = false; // Disable update for API request
            } else {
                $this->TAGIHAN->setFormValue($val);
            }
        }

        // Check field name 'ID_1' first before field var 'x_ID_1'
        $val = $CurrentForm->hasValue("ID_1") ? $CurrentForm->getValue("ID_1") : $CurrentForm->getValue("x_ID_1");
        if (!$this->ID_1->IsDetailKey) {
            $this->ID_1->setFormValue($val);
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
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->VISIT_ID->CurrentValue = $this->VISIT_ID->FormValue;
        $this->TARIF_ID->CurrentValue = $this->TARIF_ID->FormValue;
        $this->CLINIC_ID->CurrentValue = $this->CLINIC_ID->FormValue;
        $this->TREATMENT->CurrentValue = $this->TREATMENT->FormValue;
        $this->QUANTITY->CurrentValue = $this->QUANTITY->FormValue;
        $this->TRANS_ID->CurrentValue = $this->TRANS_ID->FormValue;
        $this->ID->CurrentValue = $this->ID->FormValue;
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
        $this->ID_1->CurrentValue = $this->ID_1->FormValue;
        $this->MEASURE_ID->CurrentValue = $this->MEASURE_ID->FormValue;
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
        $row = [];
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
        $row['KELUAR_ID'] = null;
        $row['BED_ID'] = null;
        $row['EXIT_DATE'] = null;
        $row['THENAME'] = null;
        $row['THEADDRESS'] = null;
        $row['THEID'] = null;
        $row['TRANS_ID'] = null;
        $row['ID'] = null;
        $row['AMOUNT'] = null;
        $row['POKOK_JUAL'] = null;
        $row['PPN'] = null;
        $row['SUBSIDI'] = null;
        $row['PRINT_DATE'] = null;
        $row['ISCETAK'] = null;
        $row['NOTA_NO'] = null;
        $row['KUITANSI_ID'] = null;
        $row['amount_paid'] = null;
        $row['sell_price'] = null;
        $row['diskon'] = null;
        $row['TAGIHAN'] = null;
        $row['CLINIC_TYPE'] = null;
        $row['ID_1'] = null;
        $row['ORG_UNIT_CODE'] = null;
        $row['BILL_ID_1'] = null;
        $row['NO_REGISTRATION_1'] = null;
        $row['VISIT_ID_1'] = null;
        $row['TARIF_ID_1'] = null;
        $row['CLASS_ID_1'] = null;
        $row['CLINIC_ID_1'] = null;
        $row['CLINIC_ID_FROM_1'] = null;
        $row['TREATMENT_1'] = null;
        $row['TREAT_DATE_1'] = null;
        $row['QUANTITY_1'] = null;
        $row['MEASURE_ID'] = null;
        $row['MEASURE_ID_1'] = null;
        $row['TRANS_ID_1'] = null;
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

            // ID_1
            $this->ID_1->LinkCustomAttributes = "";
            $this->ID_1->HrefValue = "";
            $this->ID_1->TooltipValue = "";

            // MEASURE_ID
            $this->MEASURE_ID->LinkCustomAttributes = "";
            $this->MEASURE_ID->HrefValue = "";
            $this->MEASURE_ID->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_EDIT) {
            // VISIT_ID
            $this->VISIT_ID->EditAttrs["class"] = "form-control";
            $this->VISIT_ID->EditCustomAttributes = "";
            if ($this->VISIT_ID->getSessionValue() != "") {
                $this->VISIT_ID->CurrentValue = GetForeignKeyValue($this->VISIT_ID->getSessionValue());
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

            // QUANTITY
            $this->QUANTITY->EditAttrs["class"] = "form-control";
            $this->QUANTITY->EditCustomAttributes = "";
            $this->QUANTITY->EditValue = HtmlEncode($this->QUANTITY->CurrentValue);
            $this->QUANTITY->PlaceHolder = RemoveHtml($this->QUANTITY->caption());
            if (strval($this->QUANTITY->EditValue) != "" && is_numeric($this->QUANTITY->EditValue)) {
                $this->QUANTITY->EditValue = FormatNumber($this->QUANTITY->EditValue, -2, -2, -2, -2);
            }

            // TRANS_ID
            $this->TRANS_ID->EditAttrs["class"] = "form-control";
            $this->TRANS_ID->EditCustomAttributes = "";
            if ($this->TRANS_ID->getSessionValue() != "") {
                $this->TRANS_ID->CurrentValue = GetForeignKeyValue($this->TRANS_ID->getSessionValue());
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
            }

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

            // SUBSIDI
            $this->SUBSIDI->EditAttrs["class"] = "form-control";
            $this->SUBSIDI->EditCustomAttributes = "";
            $this->SUBSIDI->EditValue = HtmlEncode($this->SUBSIDI->CurrentValue);
            $this->SUBSIDI->PlaceHolder = RemoveHtml($this->SUBSIDI->caption());
            if (strval($this->SUBSIDI->EditValue) != "" && is_numeric($this->SUBSIDI->EditValue)) {
                $this->SUBSIDI->EditValue = FormatNumber($this->SUBSIDI->EditValue, -2, -2, -2, -2);
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
            }

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

            // TAGIHAN
            $this->TAGIHAN->EditAttrs["class"] = "form-control";
            $this->TAGIHAN->EditCustomAttributes = "";
            $this->TAGIHAN->EditValue = HtmlEncode($this->TAGIHAN->CurrentValue);
            $this->TAGIHAN->PlaceHolder = RemoveHtml($this->TAGIHAN->caption());
            if (strval($this->TAGIHAN->EditValue) != "" && is_numeric($this->TAGIHAN->EditValue)) {
                $this->TAGIHAN->EditValue = FormatNumber($this->TAGIHAN->EditValue, -2, -2, -2, -2);
            }

            // ID_1
            $this->ID_1->EditAttrs["class"] = "form-control";
            $this->ID_1->EditCustomAttributes = "";
            $this->ID_1->EditValue = HtmlEncode($this->ID_1->CurrentValue);
            $this->ID_1->PlaceHolder = RemoveHtml($this->ID_1->caption());

            // MEASURE_ID
            $this->MEASURE_ID->EditAttrs["class"] = "form-control";
            $this->MEASURE_ID->EditCustomAttributes = "";
            $this->MEASURE_ID->EditValue = HtmlEncode($this->MEASURE_ID->CurrentValue);
            $this->MEASURE_ID->PlaceHolder = RemoveHtml($this->MEASURE_ID->caption());

            // Edit refer script

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

            // ID_1
            $this->ID_1->LinkCustomAttributes = "";
            $this->ID_1->HrefValue = "";

            // MEASURE_ID
            $this->MEASURE_ID->LinkCustomAttributes = "";
            $this->MEASURE_ID->HrefValue = "";
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
        if ($this->ID_1->Required) {
            if (!$this->ID_1->IsDetailKey && EmptyValue($this->ID_1->FormValue)) {
                $this->ID_1->addErrorMessage(str_replace("%s", $this->ID_1->caption(), $this->ID_1->RequiredErrorMessage));
            }
        }
        if ($this->MEASURE_ID->Required) {
            if (!$this->MEASURE_ID->IsDetailKey && EmptyValue($this->MEASURE_ID->FormValue)) {
                $this->MEASURE_ID->addErrorMessage(str_replace("%s", $this->MEASURE_ID->caption(), $this->MEASURE_ID->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->MEASURE_ID->FormValue)) {
            $this->MEASURE_ID->addErrorMessage($this->MEASURE_ID->getErrorMessage(false));
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

            // TARIF_ID
            $this->TARIF_ID->setDbValueDef($rsnew, $this->TARIF_ID->CurrentValue, null, $this->TARIF_ID->ReadOnly);

            // TREATMENT
            $this->TREATMENT->setDbValueDef($rsnew, $this->TREATMENT->CurrentValue, null, $this->TREATMENT->ReadOnly);

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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("TreatmentInapList"), "", $this->TableVar, true);
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
}
