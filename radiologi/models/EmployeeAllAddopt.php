<?php

namespace PHPMaker2021\SIMRSSQLSERVERRADIOLOGI;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class EmployeeAllAddopt extends EmployeeAll
{
    use MessagesTrait;

    // Page ID
    public $PageID = "addopt";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'EMPLOYEE_ALL';

    // Page object name
    public $PageObjName = "EmployeeAllAddopt";

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

        // Table object (EMPLOYEE_ALL)
        if (!isset($GLOBALS["EMPLOYEE_ALL"]) || get_class($GLOBALS["EMPLOYEE_ALL"]) == PROJECT_NAMESPACE . "EMPLOYEE_ALL") {
            $GLOBALS["EMPLOYEE_ALL"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'EMPLOYEE_ALL');
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
                $doc = new $class(Container("EMPLOYEE_ALL"));
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
            $key .= @$ar['ORG_UNIT_CODE'] . Config("COMPOSITE_KEY_SEPARATOR");
            $key .= @$ar['EMPLOYEE_ID'];
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
    public $IsModal = false;

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
        $this->DESCRIPTION->Visible = false;
        $this->OBJECT_CATEGORY_ID->Visible = false;
        $this->ORG_UNIT_CODE->Visible = false;
        $this->EMPLOYEE_ID->Visible = false;
        $this->MYADDRESS->Visible = false;
        $this->POSTAL_CODE->Visible = false;
        $this->RT->Visible = false;
        $this->RW->Visible = false;
        $this->KAL_ID->Visible = false;
        $this->KEC_ID->Visible = false;
        $this->KODE_KOTA->Visible = false;
        $this->PROVINCE_CODE->Visible = false;
        $this->COUNTRY_CODE->Visible = false;
        $this->PHONE->Visible = false;
        $this->FAX->Visible = false;
        $this->_EMAIL->Visible = false;
        $this->HANDPHONE->Visible = false;
        $this->KARPEG->Visible = false;
        $this->KARIS->Visible = false;
        $this->ASKES->Visible = false;
        $this->TASPEN->Visible = false;
        $this->FULLNAME->setVisibility();
        $this->GELAR_DEPAN->Visible = false;
        $this->GELAR_BELAKANG->Visible = false;
        $this->NICKNAME->Visible = false;
        $this->PLACEOFBIRTH->Visible = false;
        $this->DATEOFBIRTH->Visible = false;
        $this->KODE_AGAMA->Visible = false;
        $this->GENDER->Visible = false;
        $this->MARITALSTATUSID->Visible = false;
        $this->BLOOD_ID->Visible = false;
        $this->ORG_ID->Visible = false;
        $this->KODE_JABATAN->Visible = false;
        $this->EMPLOYEED_DATE->Visible = false;
        $this->EMP_TYPE->Visible = false;
        $this->STATUS_ID->Visible = false;
        $this->CURRENT_GOLF_ID->Visible = false;
        $this->FUNCTIONAL->Visible = false;
        $this->TOTAL_CCP->Visible = false;
        $this->PWORKING_PERIOD_TH->Visible = false;
        $this->P_WORKING_PERIOD_BLN->Visible = false;
        $this->RWORKING_PERIOD_TH->Visible = false;
        $this->RWORKING_PERIOD_BLN->Visible = false;
        $this->CURRENT_GOL_ID->Visible = false;
        $this->GWORKING_PERIOD_TH->Visible = false;
        $this->GWORKING_PERIOD_BLN->Visible = false;
        $this->EDUCATION_TYPE_CODE->Visible = false;
        $this->NPWP->Visible = false;
        $this->NATION_ID->Visible = false;
        $this->PAID_ID->Visible = false;
        $this->NONACTIVE->Visible = false;
        $this->NONACTIVE_DATE->Visible = false;
        $this->NON_ACTIVE_TYPE->Visible = false;
        $this->PENSION_DATE->Visible = false;
        $this->MORTGAGEYEAR->Visible = false;
        $this->MODIFIED_DATE->Visible = false;
        $this->MODIFIED_BY->Visible = false;
        $this->PICTUREFILE->Visible = false;
        $this->FINGERSCANFILE->Visible = false;
        $this->ISFULLTIME->Visible = false;
        $this->SPECIALIST_TYPE_ID->Visible = false;
        $this->BANK_ID->Visible = false;
        $this->BANK_ACCOUNT->Visible = false;
        $this->NPK->Visible = false;
        $this->OTHER_ADDRESS->Visible = false;
        $this->DEATH_DATE->Visible = false;
        $this->WEBSITE->Visible = false;
        $this->NIP->Visible = false;
        $this->DPJP->Visible = false;
        $this->SK_NO->Visible = false;
        $this->SK_TMT->Visible = false;
        $this->SK_TAT->Visible = false;
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
        $this->setupLookupOptions($this->GENDER);
        $this->setupLookupOptions($this->ORG_ID);
        $this->setupLookupOptions($this->SPECIALIST_TYPE_ID);

        // Set up Breadcrumb
        //$this->setupBreadcrumb(); // Not used
        $this->loadRowValues(); // Load default values

        // Render row
        $this->RowType = ROWTYPE_ADD; // Render add type
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
        $this->DESCRIPTION->CurrentValue = null;
        $this->DESCRIPTION->OldValue = $this->DESCRIPTION->CurrentValue;
        $this->OBJECT_CATEGORY_ID->CurrentValue = null;
        $this->OBJECT_CATEGORY_ID->OldValue = $this->OBJECT_CATEGORY_ID->CurrentValue;
        $this->ORG_UNIT_CODE->CurrentValue = null;
        $this->ORG_UNIT_CODE->OldValue = $this->ORG_UNIT_CODE->CurrentValue;
        $this->EMPLOYEE_ID->CurrentValue = null;
        $this->EMPLOYEE_ID->OldValue = $this->EMPLOYEE_ID->CurrentValue;
        $this->MYADDRESS->CurrentValue = null;
        $this->MYADDRESS->OldValue = $this->MYADDRESS->CurrentValue;
        $this->POSTAL_CODE->CurrentValue = null;
        $this->POSTAL_CODE->OldValue = $this->POSTAL_CODE->CurrentValue;
        $this->RT->CurrentValue = null;
        $this->RT->OldValue = $this->RT->CurrentValue;
        $this->RW->CurrentValue = null;
        $this->RW->OldValue = $this->RW->CurrentValue;
        $this->KAL_ID->CurrentValue = null;
        $this->KAL_ID->OldValue = $this->KAL_ID->CurrentValue;
        $this->KEC_ID->CurrentValue = null;
        $this->KEC_ID->OldValue = $this->KEC_ID->CurrentValue;
        $this->KODE_KOTA->CurrentValue = null;
        $this->KODE_KOTA->OldValue = $this->KODE_KOTA->CurrentValue;
        $this->PROVINCE_CODE->CurrentValue = null;
        $this->PROVINCE_CODE->OldValue = $this->PROVINCE_CODE->CurrentValue;
        $this->COUNTRY_CODE->CurrentValue = null;
        $this->COUNTRY_CODE->OldValue = $this->COUNTRY_CODE->CurrentValue;
        $this->PHONE->CurrentValue = null;
        $this->PHONE->OldValue = $this->PHONE->CurrentValue;
        $this->FAX->CurrentValue = null;
        $this->FAX->OldValue = $this->FAX->CurrentValue;
        $this->_EMAIL->CurrentValue = null;
        $this->_EMAIL->OldValue = $this->_EMAIL->CurrentValue;
        $this->HANDPHONE->CurrentValue = null;
        $this->HANDPHONE->OldValue = $this->HANDPHONE->CurrentValue;
        $this->KARPEG->CurrentValue = null;
        $this->KARPEG->OldValue = $this->KARPEG->CurrentValue;
        $this->KARIS->CurrentValue = null;
        $this->KARIS->OldValue = $this->KARIS->CurrentValue;
        $this->ASKES->CurrentValue = null;
        $this->ASKES->OldValue = $this->ASKES->CurrentValue;
        $this->TASPEN->CurrentValue = null;
        $this->TASPEN->OldValue = $this->TASPEN->CurrentValue;
        $this->FULLNAME->CurrentValue = null;
        $this->FULLNAME->OldValue = $this->FULLNAME->CurrentValue;
        $this->GELAR_DEPAN->CurrentValue = null;
        $this->GELAR_DEPAN->OldValue = $this->GELAR_DEPAN->CurrentValue;
        $this->GELAR_BELAKANG->CurrentValue = null;
        $this->GELAR_BELAKANG->OldValue = $this->GELAR_BELAKANG->CurrentValue;
        $this->NICKNAME->CurrentValue = null;
        $this->NICKNAME->OldValue = $this->NICKNAME->CurrentValue;
        $this->PLACEOFBIRTH->CurrentValue = null;
        $this->PLACEOFBIRTH->OldValue = $this->PLACEOFBIRTH->CurrentValue;
        $this->DATEOFBIRTH->CurrentValue = null;
        $this->DATEOFBIRTH->OldValue = $this->DATEOFBIRTH->CurrentValue;
        $this->KODE_AGAMA->CurrentValue = null;
        $this->KODE_AGAMA->OldValue = $this->KODE_AGAMA->CurrentValue;
        $this->GENDER->CurrentValue = null;
        $this->GENDER->OldValue = $this->GENDER->CurrentValue;
        $this->MARITALSTATUSID->CurrentValue = null;
        $this->MARITALSTATUSID->OldValue = $this->MARITALSTATUSID->CurrentValue;
        $this->BLOOD_ID->CurrentValue = null;
        $this->BLOOD_ID->OldValue = $this->BLOOD_ID->CurrentValue;
        $this->ORG_ID->CurrentValue = null;
        $this->ORG_ID->OldValue = $this->ORG_ID->CurrentValue;
        $this->KODE_JABATAN->CurrentValue = null;
        $this->KODE_JABATAN->OldValue = $this->KODE_JABATAN->CurrentValue;
        $this->EMPLOYEED_DATE->CurrentValue = null;
        $this->EMPLOYEED_DATE->OldValue = $this->EMPLOYEED_DATE->CurrentValue;
        $this->EMP_TYPE->CurrentValue = null;
        $this->EMP_TYPE->OldValue = $this->EMP_TYPE->CurrentValue;
        $this->STATUS_ID->CurrentValue = null;
        $this->STATUS_ID->OldValue = $this->STATUS_ID->CurrentValue;
        $this->CURRENT_GOLF_ID->CurrentValue = null;
        $this->CURRENT_GOLF_ID->OldValue = $this->CURRENT_GOLF_ID->CurrentValue;
        $this->FUNCTIONAL->CurrentValue = null;
        $this->FUNCTIONAL->OldValue = $this->FUNCTIONAL->CurrentValue;
        $this->TOTAL_CCP->CurrentValue = null;
        $this->TOTAL_CCP->OldValue = $this->TOTAL_CCP->CurrentValue;
        $this->PWORKING_PERIOD_TH->CurrentValue = null;
        $this->PWORKING_PERIOD_TH->OldValue = $this->PWORKING_PERIOD_TH->CurrentValue;
        $this->P_WORKING_PERIOD_BLN->CurrentValue = null;
        $this->P_WORKING_PERIOD_BLN->OldValue = $this->P_WORKING_PERIOD_BLN->CurrentValue;
        $this->RWORKING_PERIOD_TH->CurrentValue = null;
        $this->RWORKING_PERIOD_TH->OldValue = $this->RWORKING_PERIOD_TH->CurrentValue;
        $this->RWORKING_PERIOD_BLN->CurrentValue = null;
        $this->RWORKING_PERIOD_BLN->OldValue = $this->RWORKING_PERIOD_BLN->CurrentValue;
        $this->CURRENT_GOL_ID->CurrentValue = null;
        $this->CURRENT_GOL_ID->OldValue = $this->CURRENT_GOL_ID->CurrentValue;
        $this->GWORKING_PERIOD_TH->CurrentValue = null;
        $this->GWORKING_PERIOD_TH->OldValue = $this->GWORKING_PERIOD_TH->CurrentValue;
        $this->GWORKING_PERIOD_BLN->CurrentValue = null;
        $this->GWORKING_PERIOD_BLN->OldValue = $this->GWORKING_PERIOD_BLN->CurrentValue;
        $this->EDUCATION_TYPE_CODE->CurrentValue = null;
        $this->EDUCATION_TYPE_CODE->OldValue = $this->EDUCATION_TYPE_CODE->CurrentValue;
        $this->NPWP->CurrentValue = null;
        $this->NPWP->OldValue = $this->NPWP->CurrentValue;
        $this->NATION_ID->CurrentValue = null;
        $this->NATION_ID->OldValue = $this->NATION_ID->CurrentValue;
        $this->PAID_ID->CurrentValue = null;
        $this->PAID_ID->OldValue = $this->PAID_ID->CurrentValue;
        $this->NONACTIVE->CurrentValue = null;
        $this->NONACTIVE->OldValue = $this->NONACTIVE->CurrentValue;
        $this->NONACTIVE_DATE->CurrentValue = null;
        $this->NONACTIVE_DATE->OldValue = $this->NONACTIVE_DATE->CurrentValue;
        $this->NON_ACTIVE_TYPE->CurrentValue = null;
        $this->NON_ACTIVE_TYPE->OldValue = $this->NON_ACTIVE_TYPE->CurrentValue;
        $this->PENSION_DATE->CurrentValue = null;
        $this->PENSION_DATE->OldValue = $this->PENSION_DATE->CurrentValue;
        $this->MORTGAGEYEAR->CurrentValue = null;
        $this->MORTGAGEYEAR->OldValue = $this->MORTGAGEYEAR->CurrentValue;
        $this->MODIFIED_DATE->CurrentValue = null;
        $this->MODIFIED_DATE->OldValue = $this->MODIFIED_DATE->CurrentValue;
        $this->MODIFIED_BY->CurrentValue = null;
        $this->MODIFIED_BY->OldValue = $this->MODIFIED_BY->CurrentValue;
        $this->PICTUREFILE->CurrentValue = null;
        $this->PICTUREFILE->OldValue = $this->PICTUREFILE->CurrentValue;
        $this->FINGERSCANFILE->CurrentValue = null;
        $this->FINGERSCANFILE->OldValue = $this->FINGERSCANFILE->CurrentValue;
        $this->ISFULLTIME->CurrentValue = null;
        $this->ISFULLTIME->OldValue = $this->ISFULLTIME->CurrentValue;
        $this->SPECIALIST_TYPE_ID->CurrentValue = null;
        $this->SPECIALIST_TYPE_ID->OldValue = $this->SPECIALIST_TYPE_ID->CurrentValue;
        $this->BANK_ID->CurrentValue = null;
        $this->BANK_ID->OldValue = $this->BANK_ID->CurrentValue;
        $this->BANK_ACCOUNT->CurrentValue = null;
        $this->BANK_ACCOUNT->OldValue = $this->BANK_ACCOUNT->CurrentValue;
        $this->NPK->CurrentValue = null;
        $this->NPK->OldValue = $this->NPK->CurrentValue;
        $this->OTHER_ADDRESS->CurrentValue = null;
        $this->OTHER_ADDRESS->OldValue = $this->OTHER_ADDRESS->CurrentValue;
        $this->DEATH_DATE->CurrentValue = null;
        $this->DEATH_DATE->OldValue = $this->DEATH_DATE->CurrentValue;
        $this->WEBSITE->CurrentValue = null;
        $this->WEBSITE->OldValue = $this->WEBSITE->CurrentValue;
        $this->NIP->CurrentValue = null;
        $this->NIP->OldValue = $this->NIP->CurrentValue;
        $this->DPJP->CurrentValue = null;
        $this->DPJP->OldValue = $this->DPJP->CurrentValue;
        $this->SK_NO->CurrentValue = null;
        $this->SK_NO->OldValue = $this->SK_NO->CurrentValue;
        $this->SK_TMT->CurrentValue = null;
        $this->SK_TMT->OldValue = $this->SK_TMT->CurrentValue;
        $this->SK_TAT->CurrentValue = null;
        $this->SK_TAT->OldValue = $this->SK_TAT->CurrentValue;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;

        // Check field name 'FULLNAME' first before field var 'x_FULLNAME'
        $val = $CurrentForm->hasValue("FULLNAME") ? $CurrentForm->getValue("FULLNAME") : $CurrentForm->getValue("x_FULLNAME");
        if (!$this->FULLNAME->IsDetailKey) {
            $this->FULLNAME->setFormValue(ConvertFromUtf8($val));
        }

        // Check field name 'ORG_UNIT_CODE' first before field var 'x_ORG_UNIT_CODE'
        $val = $CurrentForm->hasValue("ORG_UNIT_CODE") ? $CurrentForm->getValue("ORG_UNIT_CODE") : $CurrentForm->getValue("x_ORG_UNIT_CODE");
        if (!$this->ORG_UNIT_CODE->IsDetailKey) {
            $this->ORG_UNIT_CODE->setFormValue(ConvertFromUtf8($val));
        }

        // Check field name 'EMPLOYEE_ID' first before field var 'x_EMPLOYEE_ID'
        $val = $CurrentForm->hasValue("EMPLOYEE_ID") ? $CurrentForm->getValue("EMPLOYEE_ID") : $CurrentForm->getValue("x_EMPLOYEE_ID");
        if (!$this->EMPLOYEE_ID->IsDetailKey) {
            $this->EMPLOYEE_ID->setFormValue(ConvertFromUtf8($val));
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->ORG_UNIT_CODE->CurrentValue = ConvertToUtf8($this->ORG_UNIT_CODE->FormValue);
        $this->EMPLOYEE_ID->CurrentValue = ConvertToUtf8($this->EMPLOYEE_ID->FormValue);
        $this->FULLNAME->CurrentValue = ConvertToUtf8($this->FULLNAME->FormValue);
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
        $this->DESCRIPTION->setDbValue($row['DESCRIPTION']);
        $this->OBJECT_CATEGORY_ID->setDbValue($row['OBJECT_CATEGORY_ID']);
        $this->ORG_UNIT_CODE->setDbValue($row['ORG_UNIT_CODE']);
        $this->EMPLOYEE_ID->setDbValue($row['EMPLOYEE_ID']);
        $this->MYADDRESS->setDbValue($row['MYADDRESS']);
        $this->POSTAL_CODE->setDbValue($row['POSTAL_CODE']);
        $this->RT->setDbValue($row['RT']);
        $this->RW->setDbValue($row['RW']);
        $this->KAL_ID->setDbValue($row['KAL_ID']);
        $this->KEC_ID->setDbValue($row['KEC_ID']);
        $this->KODE_KOTA->setDbValue($row['KODE_KOTA']);
        $this->PROVINCE_CODE->setDbValue($row['PROVINCE_CODE']);
        $this->COUNTRY_CODE->setDbValue($row['COUNTRY_CODE']);
        $this->PHONE->setDbValue($row['PHONE']);
        $this->FAX->setDbValue($row['FAX']);
        $this->_EMAIL->setDbValue($row['EMAIL']);
        $this->HANDPHONE->setDbValue($row['HANDPHONE']);
        $this->KARPEG->setDbValue($row['KARPEG']);
        $this->KARIS->setDbValue($row['KARIS']);
        $this->ASKES->setDbValue($row['ASKES']);
        $this->TASPEN->setDbValue($row['TASPEN']);
        $this->FULLNAME->setDbValue($row['FULLNAME']);
        $this->GELAR_DEPAN->setDbValue($row['GELAR_DEPAN']);
        $this->GELAR_BELAKANG->setDbValue($row['GELAR_BELAKANG']);
        $this->NICKNAME->setDbValue($row['NICKNAME']);
        $this->PLACEOFBIRTH->setDbValue($row['PLACEOFBIRTH']);
        $this->DATEOFBIRTH->setDbValue($row['DATEOFBIRTH']);
        $this->KODE_AGAMA->setDbValue($row['KODE_AGAMA']);
        $this->GENDER->setDbValue($row['GENDER']);
        $this->MARITALSTATUSID->setDbValue($row['MARITALSTATUSID']);
        $this->BLOOD_ID->setDbValue($row['BLOOD_ID']);
        $this->ORG_ID->setDbValue($row['ORG_ID']);
        $this->KODE_JABATAN->setDbValue($row['KODE_JABATAN']);
        $this->EMPLOYEED_DATE->setDbValue($row['EMPLOYEED_DATE']);
        $this->EMP_TYPE->setDbValue($row['EMP_TYPE']);
        $this->STATUS_ID->setDbValue($row['STATUS_ID']);
        $this->CURRENT_GOLF_ID->setDbValue($row['CURRENT_GOLF_ID']);
        $this->FUNCTIONAL->setDbValue($row['FUNCTIONAL']);
        $this->TOTAL_CCP->setDbValue($row['TOTAL_CCP']);
        $this->PWORKING_PERIOD_TH->setDbValue($row['PWORKING_PERIOD_TH']);
        $this->P_WORKING_PERIOD_BLN->setDbValue($row['P_WORKING_PERIOD_BLN']);
        $this->RWORKING_PERIOD_TH->setDbValue($row['RWORKING_PERIOD_TH']);
        $this->RWORKING_PERIOD_BLN->setDbValue($row['RWORKING_PERIOD_BLN']);
        $this->CURRENT_GOL_ID->setDbValue($row['CURRENT_GOL_ID']);
        $this->GWORKING_PERIOD_TH->setDbValue($row['GWORKING_PERIOD_TH']);
        $this->GWORKING_PERIOD_BLN->setDbValue($row['GWORKING_PERIOD_BLN']);
        $this->EDUCATION_TYPE_CODE->setDbValue($row['EDUCATION_TYPE_CODE']);
        $this->NPWP->setDbValue($row['NPWP']);
        $this->NATION_ID->setDbValue($row['NATION_ID']);
        $this->PAID_ID->setDbValue($row['PAID_ID']);
        $this->NONACTIVE->setDbValue($row['NONACTIVE']);
        $this->NONACTIVE_DATE->setDbValue($row['NONACTIVE_DATE']);
        $this->NON_ACTIVE_TYPE->setDbValue($row['NON_ACTIVE_TYPE']);
        $this->PENSION_DATE->setDbValue($row['PENSION_DATE']);
        $this->MORTGAGEYEAR->setDbValue($row['MORTGAGEYEAR']);
        $this->MODIFIED_DATE->setDbValue($row['MODIFIED_DATE']);
        $this->MODIFIED_BY->setDbValue($row['MODIFIED_BY']);
        $this->PICTUREFILE->setDbValue($row['PICTUREFILE']);
        $this->FINGERSCANFILE->setDbValue($row['FINGERSCANFILE']);
        $this->ISFULLTIME->setDbValue($row['ISFULLTIME']);
        $this->SPECIALIST_TYPE_ID->setDbValue($row['SPECIALIST_TYPE_ID']);
        $this->BANK_ID->setDbValue($row['BANK_ID']);
        $this->BANK_ACCOUNT->setDbValue($row['BANK_ACCOUNT']);
        $this->NPK->setDbValue($row['NPK']);
        $this->OTHER_ADDRESS->setDbValue($row['OTHER_ADDRESS']);
        $this->DEATH_DATE->setDbValue($row['DEATH_DATE']);
        $this->WEBSITE->setDbValue($row['WEBSITE']);
        $this->NIP->setDbValue($row['NIP']);
        $this->DPJP->setDbValue($row['DPJP']);
        $this->SK_NO->setDbValue($row['SK_NO']);
        $this->SK_TMT->setDbValue($row['SK_TMT']);
        $this->SK_TAT->setDbValue($row['SK_TAT']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $this->loadDefaultValues();
        $row = [];
        $row['DESCRIPTION'] = $this->DESCRIPTION->CurrentValue;
        $row['OBJECT_CATEGORY_ID'] = $this->OBJECT_CATEGORY_ID->CurrentValue;
        $row['ORG_UNIT_CODE'] = $this->ORG_UNIT_CODE->CurrentValue;
        $row['EMPLOYEE_ID'] = $this->EMPLOYEE_ID->CurrentValue;
        $row['MYADDRESS'] = $this->MYADDRESS->CurrentValue;
        $row['POSTAL_CODE'] = $this->POSTAL_CODE->CurrentValue;
        $row['RT'] = $this->RT->CurrentValue;
        $row['RW'] = $this->RW->CurrentValue;
        $row['KAL_ID'] = $this->KAL_ID->CurrentValue;
        $row['KEC_ID'] = $this->KEC_ID->CurrentValue;
        $row['KODE_KOTA'] = $this->KODE_KOTA->CurrentValue;
        $row['PROVINCE_CODE'] = $this->PROVINCE_CODE->CurrentValue;
        $row['COUNTRY_CODE'] = $this->COUNTRY_CODE->CurrentValue;
        $row['PHONE'] = $this->PHONE->CurrentValue;
        $row['FAX'] = $this->FAX->CurrentValue;
        $row['EMAIL'] = $this->_EMAIL->CurrentValue;
        $row['HANDPHONE'] = $this->HANDPHONE->CurrentValue;
        $row['KARPEG'] = $this->KARPEG->CurrentValue;
        $row['KARIS'] = $this->KARIS->CurrentValue;
        $row['ASKES'] = $this->ASKES->CurrentValue;
        $row['TASPEN'] = $this->TASPEN->CurrentValue;
        $row['FULLNAME'] = $this->FULLNAME->CurrentValue;
        $row['GELAR_DEPAN'] = $this->GELAR_DEPAN->CurrentValue;
        $row['GELAR_BELAKANG'] = $this->GELAR_BELAKANG->CurrentValue;
        $row['NICKNAME'] = $this->NICKNAME->CurrentValue;
        $row['PLACEOFBIRTH'] = $this->PLACEOFBIRTH->CurrentValue;
        $row['DATEOFBIRTH'] = $this->DATEOFBIRTH->CurrentValue;
        $row['KODE_AGAMA'] = $this->KODE_AGAMA->CurrentValue;
        $row['GENDER'] = $this->GENDER->CurrentValue;
        $row['MARITALSTATUSID'] = $this->MARITALSTATUSID->CurrentValue;
        $row['BLOOD_ID'] = $this->BLOOD_ID->CurrentValue;
        $row['ORG_ID'] = $this->ORG_ID->CurrentValue;
        $row['KODE_JABATAN'] = $this->KODE_JABATAN->CurrentValue;
        $row['EMPLOYEED_DATE'] = $this->EMPLOYEED_DATE->CurrentValue;
        $row['EMP_TYPE'] = $this->EMP_TYPE->CurrentValue;
        $row['STATUS_ID'] = $this->STATUS_ID->CurrentValue;
        $row['CURRENT_GOLF_ID'] = $this->CURRENT_GOLF_ID->CurrentValue;
        $row['FUNCTIONAL'] = $this->FUNCTIONAL->CurrentValue;
        $row['TOTAL_CCP'] = $this->TOTAL_CCP->CurrentValue;
        $row['PWORKING_PERIOD_TH'] = $this->PWORKING_PERIOD_TH->CurrentValue;
        $row['P_WORKING_PERIOD_BLN'] = $this->P_WORKING_PERIOD_BLN->CurrentValue;
        $row['RWORKING_PERIOD_TH'] = $this->RWORKING_PERIOD_TH->CurrentValue;
        $row['RWORKING_PERIOD_BLN'] = $this->RWORKING_PERIOD_BLN->CurrentValue;
        $row['CURRENT_GOL_ID'] = $this->CURRENT_GOL_ID->CurrentValue;
        $row['GWORKING_PERIOD_TH'] = $this->GWORKING_PERIOD_TH->CurrentValue;
        $row['GWORKING_PERIOD_BLN'] = $this->GWORKING_PERIOD_BLN->CurrentValue;
        $row['EDUCATION_TYPE_CODE'] = $this->EDUCATION_TYPE_CODE->CurrentValue;
        $row['NPWP'] = $this->NPWP->CurrentValue;
        $row['NATION_ID'] = $this->NATION_ID->CurrentValue;
        $row['PAID_ID'] = $this->PAID_ID->CurrentValue;
        $row['NONACTIVE'] = $this->NONACTIVE->CurrentValue;
        $row['NONACTIVE_DATE'] = $this->NONACTIVE_DATE->CurrentValue;
        $row['NON_ACTIVE_TYPE'] = $this->NON_ACTIVE_TYPE->CurrentValue;
        $row['PENSION_DATE'] = $this->PENSION_DATE->CurrentValue;
        $row['MORTGAGEYEAR'] = $this->MORTGAGEYEAR->CurrentValue;
        $row['MODIFIED_DATE'] = $this->MODIFIED_DATE->CurrentValue;
        $row['MODIFIED_BY'] = $this->MODIFIED_BY->CurrentValue;
        $row['PICTUREFILE'] = $this->PICTUREFILE->CurrentValue;
        $row['FINGERSCANFILE'] = $this->FINGERSCANFILE->CurrentValue;
        $row['ISFULLTIME'] = $this->ISFULLTIME->CurrentValue;
        $row['SPECIALIST_TYPE_ID'] = $this->SPECIALIST_TYPE_ID->CurrentValue;
        $row['BANK_ID'] = $this->BANK_ID->CurrentValue;
        $row['BANK_ACCOUNT'] = $this->BANK_ACCOUNT->CurrentValue;
        $row['NPK'] = $this->NPK->CurrentValue;
        $row['OTHER_ADDRESS'] = $this->OTHER_ADDRESS->CurrentValue;
        $row['DEATH_DATE'] = $this->DEATH_DATE->CurrentValue;
        $row['WEBSITE'] = $this->WEBSITE->CurrentValue;
        $row['NIP'] = $this->NIP->CurrentValue;
        $row['DPJP'] = $this->DPJP->CurrentValue;
        $row['SK_NO'] = $this->SK_NO->CurrentValue;
        $row['SK_TMT'] = $this->SK_TMT->CurrentValue;
        $row['SK_TAT'] = $this->SK_TAT->CurrentValue;
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

        // DESCRIPTION

        // OBJECT_CATEGORY_ID

        // ORG_UNIT_CODE

        // EMPLOYEE_ID

        // MYADDRESS

        // POSTAL_CODE

        // RT

        // RW

        // KAL_ID

        // KEC_ID

        // KODE_KOTA

        // PROVINCE_CODE

        // COUNTRY_CODE

        // PHONE

        // FAX

        // EMAIL

        // HANDPHONE

        // KARPEG

        // KARIS

        // ASKES

        // TASPEN

        // FULLNAME

        // GELAR_DEPAN

        // GELAR_BELAKANG

        // NICKNAME

        // PLACEOFBIRTH

        // DATEOFBIRTH

        // KODE_AGAMA

        // GENDER

        // MARITALSTATUSID

        // BLOOD_ID

        // ORG_ID

        // KODE_JABATAN

        // EMPLOYEED_DATE

        // EMP_TYPE

        // STATUS_ID

        // CURRENT_GOLF_ID

        // FUNCTIONAL

        // TOTAL_CCP

        // PWORKING_PERIOD_TH

        // P_WORKING_PERIOD_BLN

        // RWORKING_PERIOD_TH

        // RWORKING_PERIOD_BLN

        // CURRENT_GOL_ID

        // GWORKING_PERIOD_TH

        // GWORKING_PERIOD_BLN

        // EDUCATION_TYPE_CODE

        // NPWP

        // NATION_ID

        // PAID_ID

        // NONACTIVE

        // NONACTIVE_DATE

        // NON_ACTIVE_TYPE

        // PENSION_DATE

        // MORTGAGEYEAR

        // MODIFIED_DATE

        // MODIFIED_BY

        // PICTUREFILE

        // FINGERSCANFILE

        // ISFULLTIME

        // SPECIALIST_TYPE_ID

        // BANK_ID

        // BANK_ACCOUNT

        // NPK

        // OTHER_ADDRESS

        // DEATH_DATE

        // WEBSITE

        // NIP

        // DPJP

        // SK_NO

        // SK_TMT

        // SK_TAT
        if ($this->RowType == ROWTYPE_VIEW) {
            // DESCRIPTION
            $this->DESCRIPTION->ViewValue = $this->DESCRIPTION->CurrentValue;
            $this->DESCRIPTION->ViewCustomAttributes = "";

            // OBJECT_CATEGORY_ID
            $this->OBJECT_CATEGORY_ID->ViewValue = $this->OBJECT_CATEGORY_ID->CurrentValue;
            $this->OBJECT_CATEGORY_ID->ViewValue = FormatNumber($this->OBJECT_CATEGORY_ID->ViewValue, 0, -2, -2, -2);
            $this->OBJECT_CATEGORY_ID->ViewCustomAttributes = "";

            // ORG_UNIT_CODE
            $this->ORG_UNIT_CODE->ViewValue = $this->ORG_UNIT_CODE->CurrentValue;
            $this->ORG_UNIT_CODE->ViewCustomAttributes = "";

            // EMPLOYEE_ID
            $this->EMPLOYEE_ID->ViewValue = $this->EMPLOYEE_ID->CurrentValue;
            $this->EMPLOYEE_ID->ViewCustomAttributes = "";

            // MYADDRESS
            $this->MYADDRESS->ViewValue = $this->MYADDRESS->CurrentValue;
            $this->MYADDRESS->ViewCustomAttributes = "";

            // POSTAL_CODE
            $this->POSTAL_CODE->ViewValue = $this->POSTAL_CODE->CurrentValue;
            $this->POSTAL_CODE->ViewCustomAttributes = "";

            // RT
            $this->RT->ViewValue = $this->RT->CurrentValue;
            $this->RT->ViewCustomAttributes = "";

            // RW
            $this->RW->ViewValue = $this->RW->CurrentValue;
            $this->RW->ViewCustomAttributes = "";

            // KAL_ID
            $this->KAL_ID->ViewValue = $this->KAL_ID->CurrentValue;
            $this->KAL_ID->ViewCustomAttributes = "";

            // KEC_ID
            $this->KEC_ID->ViewValue = $this->KEC_ID->CurrentValue;
            $this->KEC_ID->ViewCustomAttributes = "";

            // KODE_KOTA
            $this->KODE_KOTA->ViewValue = $this->KODE_KOTA->CurrentValue;
            $this->KODE_KOTA->ViewCustomAttributes = "";

            // PROVINCE_CODE
            $this->PROVINCE_CODE->ViewValue = $this->PROVINCE_CODE->CurrentValue;
            $this->PROVINCE_CODE->ViewCustomAttributes = "";

            // COUNTRY_CODE
            $this->COUNTRY_CODE->ViewValue = $this->COUNTRY_CODE->CurrentValue;
            $this->COUNTRY_CODE->ViewCustomAttributes = "";

            // PHONE
            $this->PHONE->ViewValue = $this->PHONE->CurrentValue;
            $this->PHONE->ViewCustomAttributes = "";

            // FAX
            $this->FAX->ViewValue = $this->FAX->CurrentValue;
            $this->FAX->ViewCustomAttributes = "";

            // EMAIL
            $this->_EMAIL->ViewValue = $this->_EMAIL->CurrentValue;
            $this->_EMAIL->ViewCustomAttributes = "";

            // HANDPHONE
            $this->HANDPHONE->ViewValue = $this->HANDPHONE->CurrentValue;
            $this->HANDPHONE->ViewCustomAttributes = "";

            // KARPEG
            $this->KARPEG->ViewValue = $this->KARPEG->CurrentValue;
            $this->KARPEG->ViewCustomAttributes = "";

            // KARIS
            $this->KARIS->ViewValue = $this->KARIS->CurrentValue;
            $this->KARIS->ViewCustomAttributes = "";

            // ASKES
            $this->ASKES->ViewValue = $this->ASKES->CurrentValue;
            $this->ASKES->ViewCustomAttributes = "";

            // TASPEN
            $this->TASPEN->ViewValue = $this->TASPEN->CurrentValue;
            $this->TASPEN->ViewCustomAttributes = "";

            // FULLNAME
            $this->FULLNAME->ViewValue = $this->FULLNAME->CurrentValue;
            $this->FULLNAME->ViewCustomAttributes = "";

            // GELAR_DEPAN
            $this->GELAR_DEPAN->ViewValue = $this->GELAR_DEPAN->CurrentValue;
            $this->GELAR_DEPAN->ViewCustomAttributes = "";

            // GELAR_BELAKANG
            $this->GELAR_BELAKANG->ViewValue = $this->GELAR_BELAKANG->CurrentValue;
            $this->GELAR_BELAKANG->ViewCustomAttributes = "";

            // NICKNAME
            $this->NICKNAME->ViewValue = $this->NICKNAME->CurrentValue;
            $this->NICKNAME->ViewCustomAttributes = "";

            // PLACEOFBIRTH
            $this->PLACEOFBIRTH->ViewValue = $this->PLACEOFBIRTH->CurrentValue;
            $this->PLACEOFBIRTH->ViewCustomAttributes = "";

            // DATEOFBIRTH
            $this->DATEOFBIRTH->ViewValue = $this->DATEOFBIRTH->CurrentValue;
            $this->DATEOFBIRTH->ViewValue = FormatDateTime($this->DATEOFBIRTH->ViewValue, 0);
            $this->DATEOFBIRTH->ViewCustomAttributes = "";

            // KODE_AGAMA
            $this->KODE_AGAMA->ViewValue = $this->KODE_AGAMA->CurrentValue;
            $this->KODE_AGAMA->ViewValue = FormatNumber($this->KODE_AGAMA->ViewValue, 0, -2, -2, -2);
            $this->KODE_AGAMA->ViewCustomAttributes = "";

            // GENDER
            $curVal = trim(strval($this->GENDER->CurrentValue));
            if ($curVal != "") {
                $this->GENDER->ViewValue = $this->GENDER->lookupCacheOption($curVal);
                if ($this->GENDER->ViewValue === null) { // Lookup from database
                    $filterWrk = "[GENDER]" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->GENDER->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->GENDER->Lookup->renderViewRow($rswrk[0]);
                        $this->GENDER->ViewValue = $this->GENDER->displayValue($arwrk);
                    } else {
                        $this->GENDER->ViewValue = $this->GENDER->CurrentValue;
                    }
                }
            } else {
                $this->GENDER->ViewValue = null;
            }
            $this->GENDER->ViewCustomAttributes = "";

            // MARITALSTATUSID
            $this->MARITALSTATUSID->ViewValue = $this->MARITALSTATUSID->CurrentValue;
            $this->MARITALSTATUSID->ViewValue = FormatNumber($this->MARITALSTATUSID->ViewValue, 0, -2, -2, -2);
            $this->MARITALSTATUSID->ViewCustomAttributes = "";

            // BLOOD_ID
            $this->BLOOD_ID->ViewValue = $this->BLOOD_ID->CurrentValue;
            $this->BLOOD_ID->ViewValue = FormatNumber($this->BLOOD_ID->ViewValue, 0, -2, -2, -2);
            $this->BLOOD_ID->ViewCustomAttributes = "";

            // ORG_ID
            $curVal = trim(strval($this->ORG_ID->CurrentValue));
            if ($curVal != "") {
                $this->ORG_ID->ViewValue = $this->ORG_ID->lookupCacheOption($curVal);
                if ($this->ORG_ID->ViewValue === null) { // Lookup from database
                    $filterWrk = "[ORG_ID]" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->ORG_ID->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->ORG_ID->Lookup->renderViewRow($rswrk[0]);
                        $this->ORG_ID->ViewValue = $this->ORG_ID->displayValue($arwrk);
                    } else {
                        $this->ORG_ID->ViewValue = $this->ORG_ID->CurrentValue;
                    }
                }
            } else {
                $this->ORG_ID->ViewValue = null;
            }
            $this->ORG_ID->ViewCustomAttributes = "";

            // KODE_JABATAN
            $this->KODE_JABATAN->ViewValue = $this->KODE_JABATAN->CurrentValue;
            $this->KODE_JABATAN->ViewCustomAttributes = "";

            // EMPLOYEED_DATE
            $this->EMPLOYEED_DATE->ViewValue = $this->EMPLOYEED_DATE->CurrentValue;
            $this->EMPLOYEED_DATE->ViewValue = FormatDateTime($this->EMPLOYEED_DATE->ViewValue, 0);
            $this->EMPLOYEED_DATE->ViewCustomAttributes = "";

            // EMP_TYPE
            $this->EMP_TYPE->ViewValue = $this->EMP_TYPE->CurrentValue;
            $this->EMP_TYPE->ViewValue = FormatNumber($this->EMP_TYPE->ViewValue, 0, -2, -2, -2);
            $this->EMP_TYPE->ViewCustomAttributes = "";

            // STATUS_ID
            $this->STATUS_ID->ViewValue = $this->STATUS_ID->CurrentValue;
            $this->STATUS_ID->ViewValue = FormatNumber($this->STATUS_ID->ViewValue, 0, -2, -2, -2);
            $this->STATUS_ID->ViewCustomAttributes = "";

            // CURRENT_GOLF_ID
            $this->CURRENT_GOLF_ID->ViewValue = $this->CURRENT_GOLF_ID->CurrentValue;
            $this->CURRENT_GOLF_ID->ViewCustomAttributes = "";

            // FUNCTIONAL
            $this->FUNCTIONAL->ViewValue = $this->FUNCTIONAL->CurrentValue;
            $this->FUNCTIONAL->ViewCustomAttributes = "";

            // TOTAL_CCP
            $this->TOTAL_CCP->ViewValue = $this->TOTAL_CCP->CurrentValue;
            $this->TOTAL_CCP->ViewValue = FormatNumber($this->TOTAL_CCP->ViewValue, 2, -2, -2, -2);
            $this->TOTAL_CCP->ViewCustomAttributes = "";

            // PWORKING_PERIOD_TH
            $this->PWORKING_PERIOD_TH->ViewValue = $this->PWORKING_PERIOD_TH->CurrentValue;
            $this->PWORKING_PERIOD_TH->ViewValue = FormatNumber($this->PWORKING_PERIOD_TH->ViewValue, 0, -2, -2, -2);
            $this->PWORKING_PERIOD_TH->ViewCustomAttributes = "";

            // P_WORKING_PERIOD_BLN
            $this->P_WORKING_PERIOD_BLN->ViewValue = $this->P_WORKING_PERIOD_BLN->CurrentValue;
            $this->P_WORKING_PERIOD_BLN->ViewValue = FormatNumber($this->P_WORKING_PERIOD_BLN->ViewValue, 0, -2, -2, -2);
            $this->P_WORKING_PERIOD_BLN->ViewCustomAttributes = "";

            // RWORKING_PERIOD_TH
            $this->RWORKING_PERIOD_TH->ViewValue = $this->RWORKING_PERIOD_TH->CurrentValue;
            $this->RWORKING_PERIOD_TH->ViewValue = FormatNumber($this->RWORKING_PERIOD_TH->ViewValue, 0, -2, -2, -2);
            $this->RWORKING_PERIOD_TH->ViewCustomAttributes = "";

            // RWORKING_PERIOD_BLN
            $this->RWORKING_PERIOD_BLN->ViewValue = $this->RWORKING_PERIOD_BLN->CurrentValue;
            $this->RWORKING_PERIOD_BLN->ViewValue = FormatNumber($this->RWORKING_PERIOD_BLN->ViewValue, 0, -2, -2, -2);
            $this->RWORKING_PERIOD_BLN->ViewCustomAttributes = "";

            // CURRENT_GOL_ID
            $this->CURRENT_GOL_ID->ViewValue = $this->CURRENT_GOL_ID->CurrentValue;
            $this->CURRENT_GOL_ID->ViewCustomAttributes = "";

            // GWORKING_PERIOD_TH
            $this->GWORKING_PERIOD_TH->ViewValue = $this->GWORKING_PERIOD_TH->CurrentValue;
            $this->GWORKING_PERIOD_TH->ViewValue = FormatNumber($this->GWORKING_PERIOD_TH->ViewValue, 0, -2, -2, -2);
            $this->GWORKING_PERIOD_TH->ViewCustomAttributes = "";

            // GWORKING_PERIOD_BLN
            $this->GWORKING_PERIOD_BLN->ViewValue = $this->GWORKING_PERIOD_BLN->CurrentValue;
            $this->GWORKING_PERIOD_BLN->ViewValue = FormatNumber($this->GWORKING_PERIOD_BLN->ViewValue, 0, -2, -2, -2);
            $this->GWORKING_PERIOD_BLN->ViewCustomAttributes = "";

            // EDUCATION_TYPE_CODE
            $this->EDUCATION_TYPE_CODE->ViewValue = $this->EDUCATION_TYPE_CODE->CurrentValue;
            $this->EDUCATION_TYPE_CODE->ViewValue = FormatNumber($this->EDUCATION_TYPE_CODE->ViewValue, 0, -2, -2, -2);
            $this->EDUCATION_TYPE_CODE->ViewCustomAttributes = "";

            // NPWP
            $this->NPWP->ViewValue = $this->NPWP->CurrentValue;
            $this->NPWP->ViewCustomAttributes = "";

            // NATION_ID
            $this->NATION_ID->ViewValue = $this->NATION_ID->CurrentValue;
            $this->NATION_ID->ViewValue = FormatNumber($this->NATION_ID->ViewValue, 0, -2, -2, -2);
            $this->NATION_ID->ViewCustomAttributes = "";

            // PAID_ID
            $this->PAID_ID->ViewValue = $this->PAID_ID->CurrentValue;
            $this->PAID_ID->ViewCustomAttributes = "";

            // NONACTIVE
            $this->NONACTIVE->ViewValue = $this->NONACTIVE->CurrentValue;
            $this->NONACTIVE->ViewCustomAttributes = "";

            // NONACTIVE_DATE
            $this->NONACTIVE_DATE->ViewValue = $this->NONACTIVE_DATE->CurrentValue;
            $this->NONACTIVE_DATE->ViewValue = FormatDateTime($this->NONACTIVE_DATE->ViewValue, 0);
            $this->NONACTIVE_DATE->ViewCustomAttributes = "";

            // NON_ACTIVE_TYPE
            $this->NON_ACTIVE_TYPE->ViewValue = $this->NON_ACTIVE_TYPE->CurrentValue;
            $this->NON_ACTIVE_TYPE->ViewValue = FormatNumber($this->NON_ACTIVE_TYPE->ViewValue, 0, -2, -2, -2);
            $this->NON_ACTIVE_TYPE->ViewCustomAttributes = "";

            // PENSION_DATE
            $this->PENSION_DATE->ViewValue = $this->PENSION_DATE->CurrentValue;
            $this->PENSION_DATE->ViewValue = FormatDateTime($this->PENSION_DATE->ViewValue, 0);
            $this->PENSION_DATE->ViewCustomAttributes = "";

            // MORTGAGEYEAR
            $this->MORTGAGEYEAR->ViewValue = $this->MORTGAGEYEAR->CurrentValue;
            $this->MORTGAGEYEAR->ViewValue = FormatNumber($this->MORTGAGEYEAR->ViewValue, 0, -2, -2, -2);
            $this->MORTGAGEYEAR->ViewCustomAttributes = "";

            // MODIFIED_DATE
            $this->MODIFIED_DATE->ViewValue = $this->MODIFIED_DATE->CurrentValue;
            $this->MODIFIED_DATE->ViewValue = FormatDateTime($this->MODIFIED_DATE->ViewValue, 0);
            $this->MODIFIED_DATE->ViewCustomAttributes = "";

            // MODIFIED_BY
            $this->MODIFIED_BY->ViewValue = $this->MODIFIED_BY->CurrentValue;
            $this->MODIFIED_BY->ViewCustomAttributes = "";

            // PICTUREFILE
            $this->PICTUREFILE->ViewValue = $this->PICTUREFILE->CurrentValue;
            $this->PICTUREFILE->ViewCustomAttributes = "";

            // FINGERSCANFILE
            $this->FINGERSCANFILE->ViewValue = $this->FINGERSCANFILE->CurrentValue;
            $this->FINGERSCANFILE->ViewCustomAttributes = "";

            // ISFULLTIME
            $this->ISFULLTIME->ViewValue = $this->ISFULLTIME->CurrentValue;
            $this->ISFULLTIME->ViewCustomAttributes = "";

            // SPECIALIST_TYPE_ID
            $curVal = trim(strval($this->SPECIALIST_TYPE_ID->CurrentValue));
            if ($curVal != "") {
                $this->SPECIALIST_TYPE_ID->ViewValue = $this->SPECIALIST_TYPE_ID->lookupCacheOption($curVal);
                if ($this->SPECIALIST_TYPE_ID->ViewValue === null) { // Lookup from database
                    $filterWrk = "[SPECIALIST_TYPE_ID]" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->SPECIALIST_TYPE_ID->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->SPECIALIST_TYPE_ID->Lookup->renderViewRow($rswrk[0]);
                        $this->SPECIALIST_TYPE_ID->ViewValue = $this->SPECIALIST_TYPE_ID->displayValue($arwrk);
                    } else {
                        $this->SPECIALIST_TYPE_ID->ViewValue = $this->SPECIALIST_TYPE_ID->CurrentValue;
                    }
                }
            } else {
                $this->SPECIALIST_TYPE_ID->ViewValue = null;
            }
            $this->SPECIALIST_TYPE_ID->ViewCustomAttributes = "";

            // BANK_ID
            $this->BANK_ID->ViewValue = $this->BANK_ID->CurrentValue;
            $this->BANK_ID->ViewCustomAttributes = "";

            // BANK_ACCOUNT
            $this->BANK_ACCOUNT->ViewValue = $this->BANK_ACCOUNT->CurrentValue;
            $this->BANK_ACCOUNT->ViewCustomAttributes = "";

            // NPK
            $this->NPK->ViewValue = $this->NPK->CurrentValue;
            $this->NPK->ViewCustomAttributes = "";

            // OTHER_ADDRESS
            $this->OTHER_ADDRESS->ViewValue = $this->OTHER_ADDRESS->CurrentValue;
            $this->OTHER_ADDRESS->ViewCustomAttributes = "";

            // DEATH_DATE
            $this->DEATH_DATE->ViewValue = $this->DEATH_DATE->CurrentValue;
            $this->DEATH_DATE->ViewValue = FormatDateTime($this->DEATH_DATE->ViewValue, 0);
            $this->DEATH_DATE->ViewCustomAttributes = "";

            // WEBSITE
            $this->WEBSITE->ViewValue = $this->WEBSITE->CurrentValue;
            $this->WEBSITE->ViewCustomAttributes = "";

            // NIP
            $this->NIP->ViewValue = $this->NIP->CurrentValue;
            $this->NIP->ViewCustomAttributes = "";

            // DPJP
            $this->DPJP->ViewValue = $this->DPJP->CurrentValue;
            $this->DPJP->ViewCustomAttributes = "";

            // SK_NO
            $this->SK_NO->ViewValue = $this->SK_NO->CurrentValue;
            $this->SK_NO->ViewCustomAttributes = "";

            // SK_TMT
            $this->SK_TMT->ViewValue = $this->SK_TMT->CurrentValue;
            $this->SK_TMT->ViewValue = FormatDateTime($this->SK_TMT->ViewValue, 0);
            $this->SK_TMT->ViewCustomAttributes = "";

            // SK_TAT
            $this->SK_TAT->ViewValue = $this->SK_TAT->CurrentValue;
            $this->SK_TAT->ViewValue = FormatDateTime($this->SK_TAT->ViewValue, 0);
            $this->SK_TAT->ViewCustomAttributes = "";

            // FULLNAME
            $this->FULLNAME->LinkCustomAttributes = "";
            $this->FULLNAME->HrefValue = "";
            $this->FULLNAME->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // FULLNAME
            $this->FULLNAME->EditAttrs["class"] = "form-control";
            $this->FULLNAME->EditCustomAttributes = "";
            if (!$this->FULLNAME->Raw) {
                $this->FULLNAME->CurrentValue = HtmlDecode($this->FULLNAME->CurrentValue);
            }
            $this->FULLNAME->EditValue = HtmlEncode($this->FULLNAME->CurrentValue);
            $this->FULLNAME->PlaceHolder = RemoveHtml($this->FULLNAME->caption());

            // Add refer script

            // FULLNAME
            $this->FULLNAME->LinkCustomAttributes = "";
            $this->FULLNAME->HrefValue = "";
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
        if ($this->FULLNAME->Required) {
            if (!$this->FULLNAME->IsDetailKey && EmptyValue($this->FULLNAME->FormValue)) {
                $this->FULLNAME->addErrorMessage(str_replace("%s", $this->FULLNAME->caption(), $this->FULLNAME->RequiredErrorMessage));
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

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("EmployeeAllList"), "", $this->TableVar, true);
        $pageId = "addopt";
        $Breadcrumb->add("addopt", $pageId, $url);
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
                case "x_GENDER":
                    break;
                case "x_ORG_ID":
                    break;
                case "x_SPECIALIST_TYPE_ID":
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
