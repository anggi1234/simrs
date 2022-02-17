<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class VTreatmentbillDelete extends VTreatmentbill
{
    use MessagesTrait;

    // Page ID
    public $PageID = "delete";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'V_TREATMENTBILL';

    // Page object name
    public $PageObjName = "VTreatmentbillDelete";

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

        // Table object (V_TREATMENTBILL)
        if (!isset($GLOBALS["V_TREATMENTBILL"]) || get_class($GLOBALS["V_TREATMENTBILL"]) == PROJECT_NAMESPACE . "V_TREATMENTBILL") {
            $GLOBALS["V_TREATMENTBILL"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'V_TREATMENTBILL');
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
                $doc = new $class(Container("V_TREATMENTBILL"));
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
            $key .= @$ar['visit_id'];
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
            $this->KALURAHAN->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->name_of_clinic->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->booked_Date->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->visit_date->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->visit_id->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->isattended->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->diantar_oleh->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->visitor_address->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->address_of_rujukan->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->rujukan_id->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->patient_category_id->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->payor_id->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->reason_id->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->DESCRIPTION->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->way_id->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->follow_up->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->isnew->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->family_status_id->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->class_room_id->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->STATUS_PASIEN_ID->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->fullname->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->employee_id->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->employee_id_from->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->clinic_id->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->clinic_id_FROM->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->doctor->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->bed_id->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->keluar_id->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->treat_date->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->exit_date->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->name_of_class->Visible = false;
        }
    }
    public $DbMasterFilter = "";
    public $DbDetailFilter = "";
    public $StartRecord;
    public $TotalRecords = 0;
    public $RecordCount;
    public $RecKeys = [];
    public $StartRowCount = 1;
    public $RowCount = 0;

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $CustomExportType, $ExportFileName, $UserProfile, $Language, $Security, $CurrentForm;
        $this->CurrentAction = Param("action"); // Set up current action
        $this->NAME_OF_PASIEN->setVisibility();
        $this->NO_REGISTRATION->Visible = false;
        $this->ORG_UNIT_CODE->Visible = false;
        $this->date_of_birth->setVisibility();
        $this->CONTACT_ADDRESS->setVisibility();
        $this->PHONE_NUMBER->setVisibility();
        $this->MOBILE->setVisibility();
        $this->KAL_ID->Visible = false;
        $this->PLACE_OF_BIRTH->setVisibility();
        $this->KALURAHAN->setVisibility();
        $this->name_of_clinic->setVisibility();
        $this->booked_Date->setVisibility();
        $this->visit_date->setVisibility();
        $this->visit_id->setVisibility();
        $this->isattended->setVisibility();
        $this->diantar_oleh->setVisibility();
        $this->visitor_address->setVisibility();
        $this->address_of_rujukan->setVisibility();
        $this->rujukan_id->setVisibility();
        $this->patient_category_id->setVisibility();
        $this->payor_id->setVisibility();
        $this->reason_id->setVisibility();
        $this->DESCRIPTION->Visible = false;
        $this->way_id->setVisibility();
        $this->follow_up->setVisibility();
        $this->isnew->setVisibility();
        $this->family_status_id->setVisibility();
        $this->class_room_id->setVisibility();
        $this->STATUS_PASIEN_ID->setVisibility();
        $this->fullname->setVisibility();
        $this->employee_id->setVisibility();
        $this->employee_id_from->setVisibility();
        $this->clinic_id->setVisibility();
        $this->clinic_id_FROM->setVisibility();
        $this->doctor->setVisibility();
        $this->bed_id->setVisibility();
        $this->keluar_id->setVisibility();
        $this->treat_date->setVisibility();
        $this->exit_date->setVisibility();
        $this->name_of_class->setVisibility();
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

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Load key parameters
        $this->RecKeys = $this->getRecordKeys(); // Load record keys
        $filter = $this->getFilterFromRecordKeys();
        if ($filter == "") {
            $this->terminate("VTreatmentbillList"); // Prevent SQL injection, return to list
            return;
        }

        // Set up filter (WHERE Clause)
        $this->CurrentFilter = $filter;

        // Get action
        if (IsApi()) {
            $this->CurrentAction = "delete"; // Delete record directly
        } elseif (Post("action") !== null) {
            $this->CurrentAction = Post("action");
        } elseif (Get("action") == "1") {
            $this->CurrentAction = "delete"; // Delete record directly
        } else {
            $this->CurrentAction = "show"; // Display record
        }
        if ($this->isDelete()) {
            $this->SendEmail = true; // Send email on delete success
            if ($this->deleteRows()) { // Delete rows
                if ($this->getSuccessMessage() == "") {
                    $this->setSuccessMessage($Language->phrase("DeleteSuccess")); // Set up success message
                }
                if (IsApi()) {
                    $this->terminate(true);
                    return;
                } else {
                    $this->terminate($this->getReturnUrl()); // Return to caller
                    return;
                }
            } else { // Delete failed
                if (IsApi()) {
                    $this->terminate();
                    return;
                }
                $this->CurrentAction = "show"; // Display record
            }
        }
        if ($this->isShow()) { // Load records for display
            if ($this->Recordset = $this->loadRecordset()) {
                $this->TotalRecords = $this->Recordset->recordCount(); // Get record count
            }
            if ($this->TotalRecords <= 0) { // No record found, exit
                if ($this->Recordset) {
                    $this->Recordset->close();
                }
                $this->terminate("VTreatmentbillList"); // Return to list
                return;
            }
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
        $this->NAME_OF_PASIEN->setDbValue($row['NAME_OF_PASIEN']);
        $this->NO_REGISTRATION->setDbValue($row['NO_REGISTRATION']);
        $this->ORG_UNIT_CODE->setDbValue($row['ORG_UNIT_CODE']);
        $this->date_of_birth->setDbValue($row['date_of_birth']);
        $this->CONTACT_ADDRESS->setDbValue($row['CONTACT_ADDRESS']);
        $this->PHONE_NUMBER->setDbValue($row['PHONE_NUMBER']);
        $this->MOBILE->setDbValue($row['MOBILE']);
        $this->KAL_ID->setDbValue($row['KAL_ID']);
        $this->PLACE_OF_BIRTH->setDbValue($row['PLACE_OF_BIRTH']);
        $this->KALURAHAN->setDbValue($row['KALURAHAN']);
        $this->name_of_clinic->setDbValue($row['name_of_clinic']);
        $this->booked_Date->setDbValue($row['booked_Date']);
        $this->visit_date->setDbValue($row['visit_date']);
        $this->visit_id->setDbValue($row['visit_id']);
        $this->isattended->setDbValue($row['isattended']);
        $this->diantar_oleh->setDbValue($row['diantar_oleh']);
        $this->visitor_address->setDbValue($row['visitor_address']);
        $this->address_of_rujukan->setDbValue($row['address_of_rujukan']);
        $this->rujukan_id->setDbValue($row['rujukan_id']);
        $this->patient_category_id->setDbValue($row['patient_category_id']);
        $this->payor_id->setDbValue($row['payor_id']);
        $this->reason_id->setDbValue($row['reason_id']);
        $this->DESCRIPTION->setDbValue($row['DESCRIPTION']);
        $this->way_id->setDbValue($row['way_id']);
        $this->follow_up->setDbValue($row['follow_up']);
        $this->isnew->setDbValue($row['isnew']);
        $this->family_status_id->setDbValue($row['family_status_id']);
        $this->class_room_id->setDbValue($row['class_room_id']);
        $this->STATUS_PASIEN_ID->setDbValue($row['STATUS_PASIEN_ID']);
        $this->fullname->setDbValue($row['fullname']);
        $this->employee_id->setDbValue($row['employee_id']);
        $this->employee_id_from->setDbValue($row['employee_id_from']);
        $this->clinic_id->setDbValue($row['clinic_id']);
        $this->clinic_id_FROM->setDbValue($row['clinic_id_FROM']);
        $this->doctor->setDbValue($row['doctor']);
        $this->bed_id->setDbValue($row['bed_id']);
        $this->keluar_id->setDbValue($row['keluar_id']);
        $this->treat_date->setDbValue($row['treat_date']);
        $this->exit_date->setDbValue($row['exit_date']);
        $this->name_of_class->setDbValue($row['name_of_class']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['NAME_OF_PASIEN'] = null;
        $row['NO_REGISTRATION'] = null;
        $row['ORG_UNIT_CODE'] = null;
        $row['date_of_birth'] = null;
        $row['CONTACT_ADDRESS'] = null;
        $row['PHONE_NUMBER'] = null;
        $row['MOBILE'] = null;
        $row['KAL_ID'] = null;
        $row['PLACE_OF_BIRTH'] = null;
        $row['KALURAHAN'] = null;
        $row['name_of_clinic'] = null;
        $row['booked_Date'] = null;
        $row['visit_date'] = null;
        $row['visit_id'] = null;
        $row['isattended'] = null;
        $row['diantar_oleh'] = null;
        $row['visitor_address'] = null;
        $row['address_of_rujukan'] = null;
        $row['rujukan_id'] = null;
        $row['patient_category_id'] = null;
        $row['payor_id'] = null;
        $row['reason_id'] = null;
        $row['DESCRIPTION'] = null;
        $row['way_id'] = null;
        $row['follow_up'] = null;
        $row['isnew'] = null;
        $row['family_status_id'] = null;
        $row['class_room_id'] = null;
        $row['STATUS_PASIEN_ID'] = null;
        $row['fullname'] = null;
        $row['employee_id'] = null;
        $row['employee_id_from'] = null;
        $row['clinic_id'] = null;
        $row['clinic_id_FROM'] = null;
        $row['doctor'] = null;
        $row['bed_id'] = null;
        $row['keluar_id'] = null;
        $row['treat_date'] = null;
        $row['exit_date'] = null;
        $row['name_of_class'] = null;
        return $row;
    }

    // Render row values based on field settings
    public function renderRow()
    {
        global $Security, $Language, $CurrentLanguage;

        // Initialize URLs

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // NAME_OF_PASIEN

        // NO_REGISTRATION

        // ORG_UNIT_CODE

        // date_of_birth

        // CONTACT_ADDRESS

        // PHONE_NUMBER

        // MOBILE

        // KAL_ID

        // PLACE_OF_BIRTH

        // KALURAHAN

        // name_of_clinic

        // booked_Date

        // visit_date

        // visit_id

        // isattended

        // diantar_oleh

        // visitor_address

        // address_of_rujukan

        // rujukan_id

        // patient_category_id

        // payor_id

        // reason_id

        // DESCRIPTION

        // way_id

        // follow_up

        // isnew

        // family_status_id

        // class_room_id

        // STATUS_PASIEN_ID

        // fullname

        // employee_id

        // employee_id_from

        // clinic_id

        // clinic_id_FROM

        // doctor

        // bed_id

        // keluar_id

        // treat_date

        // exit_date

        // name_of_class
        if ($this->RowType == ROWTYPE_VIEW) {
            // NAME_OF_PASIEN
            $this->NAME_OF_PASIEN->ViewValue = $this->NAME_OF_PASIEN->CurrentValue;
            $this->NAME_OF_PASIEN->ViewCustomAttributes = "";

            // date_of_birth
            $this->date_of_birth->ViewValue = $this->date_of_birth->CurrentValue;
            $this->date_of_birth->ViewValue = FormatDateTime($this->date_of_birth->ViewValue, 0);
            $this->date_of_birth->ViewCustomAttributes = "";

            // CONTACT_ADDRESS
            $this->CONTACT_ADDRESS->ViewValue = $this->CONTACT_ADDRESS->CurrentValue;
            $this->CONTACT_ADDRESS->ViewCustomAttributes = "";

            // PHONE_NUMBER
            $this->PHONE_NUMBER->ViewValue = $this->PHONE_NUMBER->CurrentValue;
            $this->PHONE_NUMBER->ViewCustomAttributes = "";

            // MOBILE
            $this->MOBILE->ViewValue = $this->MOBILE->CurrentValue;
            $this->MOBILE->ViewCustomAttributes = "";

            // KAL_ID
            $this->KAL_ID->ViewValue = $this->KAL_ID->CurrentValue;
            $this->KAL_ID->ViewCustomAttributes = "";

            // PLACE_OF_BIRTH
            $this->PLACE_OF_BIRTH->ViewValue = $this->PLACE_OF_BIRTH->CurrentValue;
            $this->PLACE_OF_BIRTH->ViewCustomAttributes = "";

            // KALURAHAN
            $this->KALURAHAN->ViewValue = $this->KALURAHAN->CurrentValue;
            $this->KALURAHAN->ViewCustomAttributes = "";

            // name_of_clinic
            $this->name_of_clinic->ViewValue = $this->name_of_clinic->CurrentValue;
            $this->name_of_clinic->ViewCustomAttributes = "";

            // booked_Date
            $this->booked_Date->ViewValue = $this->booked_Date->CurrentValue;
            $this->booked_Date->ViewValue = FormatDateTime($this->booked_Date->ViewValue, 0);
            $this->booked_Date->ViewCustomAttributes = "";

            // visit_date
            $this->visit_date->ViewValue = $this->visit_date->CurrentValue;
            $this->visit_date->ViewValue = FormatDateTime($this->visit_date->ViewValue, 0);
            $this->visit_date->ViewCustomAttributes = "";

            // visit_id
            $this->visit_id->ViewValue = $this->visit_id->CurrentValue;
            $this->visit_id->ViewCustomAttributes = "";

            // isattended
            $this->isattended->ViewValue = $this->isattended->CurrentValue;
            $this->isattended->ViewCustomAttributes = "";

            // diantar_oleh
            $this->diantar_oleh->ViewValue = $this->diantar_oleh->CurrentValue;
            $this->diantar_oleh->ViewCustomAttributes = "";

            // visitor_address
            $this->visitor_address->ViewValue = $this->visitor_address->CurrentValue;
            $this->visitor_address->ViewCustomAttributes = "";

            // address_of_rujukan
            $this->address_of_rujukan->ViewValue = $this->address_of_rujukan->CurrentValue;
            $this->address_of_rujukan->ViewCustomAttributes = "";

            // rujukan_id
            $this->rujukan_id->ViewValue = $this->rujukan_id->CurrentValue;
            $this->rujukan_id->ViewValue = FormatNumber($this->rujukan_id->ViewValue, 0, -2, -2, -2);
            $this->rujukan_id->ViewCustomAttributes = "";

            // patient_category_id
            $this->patient_category_id->ViewValue = $this->patient_category_id->CurrentValue;
            $this->patient_category_id->ViewValue = FormatNumber($this->patient_category_id->ViewValue, 0, -2, -2, -2);
            $this->patient_category_id->ViewCustomAttributes = "";

            // payor_id
            $this->payor_id->ViewValue = $this->payor_id->CurrentValue;
            $this->payor_id->ViewCustomAttributes = "";

            // reason_id
            $this->reason_id->ViewValue = $this->reason_id->CurrentValue;
            $this->reason_id->ViewValue = FormatNumber($this->reason_id->ViewValue, 0, -2, -2, -2);
            $this->reason_id->ViewCustomAttributes = "";

            // DESCRIPTION
            $this->DESCRIPTION->ViewValue = $this->DESCRIPTION->CurrentValue;
            $this->DESCRIPTION->ViewCustomAttributes = "";

            // way_id
            $this->way_id->ViewValue = $this->way_id->CurrentValue;
            $this->way_id->ViewValue = FormatNumber($this->way_id->ViewValue, 0, -2, -2, -2);
            $this->way_id->ViewCustomAttributes = "";

            // follow_up
            $this->follow_up->ViewValue = $this->follow_up->CurrentValue;
            $this->follow_up->ViewValue = FormatNumber($this->follow_up->ViewValue, 0, -2, -2, -2);
            $this->follow_up->ViewCustomAttributes = "";

            // isnew
            $this->isnew->ViewValue = $this->isnew->CurrentValue;
            $this->isnew->ViewCustomAttributes = "";

            // family_status_id
            $this->family_status_id->ViewValue = $this->family_status_id->CurrentValue;
            $this->family_status_id->ViewValue = FormatNumber($this->family_status_id->ViewValue, 0, -2, -2, -2);
            $this->family_status_id->ViewCustomAttributes = "";

            // class_room_id
            $this->class_room_id->ViewValue = $this->class_room_id->CurrentValue;
            $this->class_room_id->ViewCustomAttributes = "";

            // STATUS_PASIEN_ID
            $this->STATUS_PASIEN_ID->ViewValue = $this->STATUS_PASIEN_ID->CurrentValue;
            $this->STATUS_PASIEN_ID->ViewValue = FormatNumber($this->STATUS_PASIEN_ID->ViewValue, 0, -2, -2, -2);
            $this->STATUS_PASIEN_ID->ViewCustomAttributes = "";

            // fullname
            $this->fullname->ViewValue = $this->fullname->CurrentValue;
            $this->fullname->ViewCustomAttributes = "";

            // employee_id
            $this->employee_id->ViewValue = $this->employee_id->CurrentValue;
            $this->employee_id->ViewCustomAttributes = "";

            // employee_id_from
            $this->employee_id_from->ViewValue = $this->employee_id_from->CurrentValue;
            $this->employee_id_from->ViewCustomAttributes = "";

            // clinic_id
            $this->clinic_id->ViewValue = $this->clinic_id->CurrentValue;
            $this->clinic_id->ViewCustomAttributes = "";

            // clinic_id_FROM
            $this->clinic_id_FROM->ViewValue = $this->clinic_id_FROM->CurrentValue;
            $this->clinic_id_FROM->ViewCustomAttributes = "";

            // doctor
            $this->doctor->ViewValue = $this->doctor->CurrentValue;
            $this->doctor->ViewCustomAttributes = "";

            // bed_id
            $this->bed_id->ViewValue = $this->bed_id->CurrentValue;
            $this->bed_id->ViewValue = FormatNumber($this->bed_id->ViewValue, 0, -2, -2, -2);
            $this->bed_id->ViewCustomAttributes = "";

            // keluar_id
            $this->keluar_id->ViewValue = $this->keluar_id->CurrentValue;
            $this->keluar_id->ViewValue = FormatNumber($this->keluar_id->ViewValue, 0, -2, -2, -2);
            $this->keluar_id->ViewCustomAttributes = "";

            // treat_date
            $this->treat_date->ViewValue = $this->treat_date->CurrentValue;
            $this->treat_date->ViewValue = FormatDateTime($this->treat_date->ViewValue, 0);
            $this->treat_date->ViewCustomAttributes = "";

            // exit_date
            $this->exit_date->ViewValue = $this->exit_date->CurrentValue;
            $this->exit_date->ViewValue = FormatDateTime($this->exit_date->ViewValue, 0);
            $this->exit_date->ViewCustomAttributes = "";

            // name_of_class
            $this->name_of_class->ViewValue = $this->name_of_class->CurrentValue;
            $this->name_of_class->ViewCustomAttributes = "";

            // NAME_OF_PASIEN
            $this->NAME_OF_PASIEN->LinkCustomAttributes = "";
            $this->NAME_OF_PASIEN->HrefValue = "";
            $this->NAME_OF_PASIEN->TooltipValue = "";

            // date_of_birth
            $this->date_of_birth->LinkCustomAttributes = "";
            $this->date_of_birth->HrefValue = "";
            $this->date_of_birth->TooltipValue = "";

            // CONTACT_ADDRESS
            $this->CONTACT_ADDRESS->LinkCustomAttributes = "";
            $this->CONTACT_ADDRESS->HrefValue = "";
            $this->CONTACT_ADDRESS->TooltipValue = "";

            // PHONE_NUMBER
            $this->PHONE_NUMBER->LinkCustomAttributes = "";
            $this->PHONE_NUMBER->HrefValue = "";
            $this->PHONE_NUMBER->TooltipValue = "";

            // MOBILE
            $this->MOBILE->LinkCustomAttributes = "";
            $this->MOBILE->HrefValue = "";
            $this->MOBILE->TooltipValue = "";

            // PLACE_OF_BIRTH
            $this->PLACE_OF_BIRTH->LinkCustomAttributes = "";
            $this->PLACE_OF_BIRTH->HrefValue = "";
            $this->PLACE_OF_BIRTH->TooltipValue = "";

            // KALURAHAN
            $this->KALURAHAN->LinkCustomAttributes = "";
            $this->KALURAHAN->HrefValue = "";
            $this->KALURAHAN->TooltipValue = "";

            // name_of_clinic
            $this->name_of_clinic->LinkCustomAttributes = "";
            $this->name_of_clinic->HrefValue = "";
            $this->name_of_clinic->TooltipValue = "";

            // booked_Date
            $this->booked_Date->LinkCustomAttributes = "";
            $this->booked_Date->HrefValue = "";
            $this->booked_Date->TooltipValue = "";

            // visit_date
            $this->visit_date->LinkCustomAttributes = "";
            $this->visit_date->HrefValue = "";
            $this->visit_date->TooltipValue = "";

            // visit_id
            $this->visit_id->LinkCustomAttributes = "";
            $this->visit_id->HrefValue = "";
            $this->visit_id->TooltipValue = "";

            // isattended
            $this->isattended->LinkCustomAttributes = "";
            $this->isattended->HrefValue = "";
            $this->isattended->TooltipValue = "";

            // diantar_oleh
            $this->diantar_oleh->LinkCustomAttributes = "";
            $this->diantar_oleh->HrefValue = "";
            $this->diantar_oleh->TooltipValue = "";

            // visitor_address
            $this->visitor_address->LinkCustomAttributes = "";
            $this->visitor_address->HrefValue = "";
            $this->visitor_address->TooltipValue = "";

            // address_of_rujukan
            $this->address_of_rujukan->LinkCustomAttributes = "";
            $this->address_of_rujukan->HrefValue = "";
            $this->address_of_rujukan->TooltipValue = "";

            // rujukan_id
            $this->rujukan_id->LinkCustomAttributes = "";
            $this->rujukan_id->HrefValue = "";
            $this->rujukan_id->TooltipValue = "";

            // patient_category_id
            $this->patient_category_id->LinkCustomAttributes = "";
            $this->patient_category_id->HrefValue = "";
            $this->patient_category_id->TooltipValue = "";

            // payor_id
            $this->payor_id->LinkCustomAttributes = "";
            $this->payor_id->HrefValue = "";
            $this->payor_id->TooltipValue = "";

            // reason_id
            $this->reason_id->LinkCustomAttributes = "";
            $this->reason_id->HrefValue = "";
            $this->reason_id->TooltipValue = "";

            // way_id
            $this->way_id->LinkCustomAttributes = "";
            $this->way_id->HrefValue = "";
            $this->way_id->TooltipValue = "";

            // follow_up
            $this->follow_up->LinkCustomAttributes = "";
            $this->follow_up->HrefValue = "";
            $this->follow_up->TooltipValue = "";

            // isnew
            $this->isnew->LinkCustomAttributes = "";
            $this->isnew->HrefValue = "";
            $this->isnew->TooltipValue = "";

            // family_status_id
            $this->family_status_id->LinkCustomAttributes = "";
            $this->family_status_id->HrefValue = "";
            $this->family_status_id->TooltipValue = "";

            // class_room_id
            $this->class_room_id->LinkCustomAttributes = "";
            $this->class_room_id->HrefValue = "";
            $this->class_room_id->TooltipValue = "";

            // STATUS_PASIEN_ID
            $this->STATUS_PASIEN_ID->LinkCustomAttributes = "";
            $this->STATUS_PASIEN_ID->HrefValue = "";
            $this->STATUS_PASIEN_ID->TooltipValue = "";

            // fullname
            $this->fullname->LinkCustomAttributes = "";
            $this->fullname->HrefValue = "";
            $this->fullname->TooltipValue = "";

            // employee_id
            $this->employee_id->LinkCustomAttributes = "";
            $this->employee_id->HrefValue = "";
            $this->employee_id->TooltipValue = "";

            // employee_id_from
            $this->employee_id_from->LinkCustomAttributes = "";
            $this->employee_id_from->HrefValue = "";
            $this->employee_id_from->TooltipValue = "";

            // clinic_id
            $this->clinic_id->LinkCustomAttributes = "";
            $this->clinic_id->HrefValue = "";
            $this->clinic_id->TooltipValue = "";

            // clinic_id_FROM
            $this->clinic_id_FROM->LinkCustomAttributes = "";
            $this->clinic_id_FROM->HrefValue = "";
            $this->clinic_id_FROM->TooltipValue = "";

            // doctor
            $this->doctor->LinkCustomAttributes = "";
            $this->doctor->HrefValue = "";
            $this->doctor->TooltipValue = "";

            // bed_id
            $this->bed_id->LinkCustomAttributes = "";
            $this->bed_id->HrefValue = "";
            $this->bed_id->TooltipValue = "";

            // keluar_id
            $this->keluar_id->LinkCustomAttributes = "";
            $this->keluar_id->HrefValue = "";
            $this->keluar_id->TooltipValue = "";

            // treat_date
            $this->treat_date->LinkCustomAttributes = "";
            $this->treat_date->HrefValue = "";
            $this->treat_date->TooltipValue = "";

            // exit_date
            $this->exit_date->LinkCustomAttributes = "";
            $this->exit_date->HrefValue = "";
            $this->exit_date->TooltipValue = "";

            // name_of_class
            $this->name_of_class->LinkCustomAttributes = "";
            $this->name_of_class->HrefValue = "";
            $this->name_of_class->TooltipValue = "";
        }

        // Call Row Rendered event
        if ($this->RowType != ROWTYPE_AGGREGATEINIT) {
            $this->rowRendered();
        }
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
        $conn->beginTransaction();

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
                $thisKey .= $row['visit_id'];
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
        if ($deleteRows) {
            $conn->commit(); // Commit the changes
        } else {
            $conn->rollback(); // Rollback changes
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

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("VTreatmentbillList"), "", $this->TableVar, true);
        $pageId = "delete";
        $Breadcrumb->add("delete", $pageId, $url);
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
}
