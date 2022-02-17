<?php

namespace PHPMaker2021\SIMRSSQLSERVERGUDANGFARMASI;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class PoDelete extends Po
{
    use MessagesTrait;

    // Page ID
    public $PageID = "delete";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'PO';

    // Page object name
    public $PageObjName = "PoDelete";

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

        // Table object (PO)
        if (!isset($GLOBALS["PO"]) || get_class($GLOBALS["PO"]) == PROJECT_NAMESPACE . "PO") {
            $GLOBALS["PO"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'PO');
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
                $doc = new $class(Container("PO"));
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
        $this->ORG_UNIT_CODE->setVisibility();
        $this->PO->setVisibility();
        $this->PO_DATE->setVisibility();
        $this->ORDER_VALUE->setVisibility();
        $this->RECEIVED_VALUE->setVisibility();
        $this->PROCURE_METHOD->setVisibility();
        $this->COMPANY_ID->setVisibility();
        $this->FUND_ID->setVisibility();
        $this->FUND_NO->setVisibility();
        $this->DESCRIPTION->setVisibility();
        $this->MODIFIED_DATE->setVisibility();
        $this->MODIFIED_BY->setVisibility();
        $this->ORDER_BY->setVisibility();
        $this->SENT_TO->setVisibility();
        $this->ISVALID->setVisibility();
        $this->START_VALID->setVisibility();
        $this->END_VALID->setVisibility();
        $this->CONTRACT_NO->setVisibility();
        $this->ORG_ID->setVisibility();
        $this->CLINIC_ID->setVisibility();
        $this->ACCOUNT_ID->setVisibility();
        $this->PAID_VALUE->setVisibility();
        $this->PPN->setVisibility();
        $this->MATERAI->setVisibility();
        $this->PPN_VALUE->setVisibility();
        $this->DISCOUNT_VALUE->setVisibility();
        $this->ISCETAK->setVisibility();
        $this->PRINT_DATE->setVisibility();
        $this->PRINTED_BY->setVisibility();
        $this->PRINTQ->setVisibility();
        $this->TAGIHAN_VALUE->setVisibility();
        $this->ACKNOWLEDGEBY->setVisibility();
        $this->NUM->setVisibility();
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

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Load key parameters
        $this->RecKeys = $this->getRecordKeys(); // Load record keys
        $filter = $this->getFilterFromRecordKeys();
        if ($filter == "") {
            $this->terminate("PoList"); // Prevent SQL injection, return to list
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
                $this->terminate("PoList"); // Return to list
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
        $this->ORG_UNIT_CODE->setDbValue($row['ORG_UNIT_CODE']);
        $this->PO->setDbValue($row['PO']);
        $this->PO_DATE->setDbValue($row['PO_DATE']);
        $this->ORDER_VALUE->setDbValue($row['ORDER_VALUE']);
        $this->RECEIVED_VALUE->setDbValue($row['RECEIVED_VALUE']);
        $this->PROCURE_METHOD->setDbValue($row['PROCURE_METHOD']);
        $this->COMPANY_ID->setDbValue($row['COMPANY_ID']);
        $this->FUND_ID->setDbValue($row['FUND_ID']);
        $this->FUND_NO->setDbValue($row['FUND_NO']);
        $this->DESCRIPTION->setDbValue($row['DESCRIPTION']);
        $this->MODIFIED_DATE->setDbValue($row['MODIFIED_DATE']);
        $this->MODIFIED_BY->setDbValue($row['MODIFIED_BY']);
        $this->ORDER_BY->setDbValue($row['ORDER_BY']);
        $this->SENT_TO->setDbValue($row['SENT_TO']);
        $this->ISVALID->setDbValue($row['ISVALID']);
        $this->START_VALID->setDbValue($row['START_VALID']);
        $this->END_VALID->setDbValue($row['END_VALID']);
        $this->CONTRACT_NO->setDbValue($row['CONTRACT_NO']);
        $this->ORG_ID->setDbValue($row['ORG_ID']);
        $this->CLINIC_ID->setDbValue($row['CLINIC_ID']);
        $this->ACCOUNT_ID->setDbValue($row['ACCOUNT_ID']);
        $this->PAID_VALUE->setDbValue($row['PAID_VALUE']);
        $this->PPN->setDbValue($row['PPN']);
        $this->MATERAI->setDbValue($row['MATERAI']);
        $this->PPN_VALUE->setDbValue($row['PPN_VALUE']);
        $this->DISCOUNT_VALUE->setDbValue($row['DISCOUNT_VALUE']);
        $this->ISCETAK->setDbValue($row['ISCETAK']);
        $this->PRINT_DATE->setDbValue($row['PRINT_DATE']);
        $this->PRINTED_BY->setDbValue($row['PRINTED_BY']);
        $this->PRINTQ->setDbValue($row['PRINTQ']);
        $this->TAGIHAN_VALUE->setDbValue($row['TAGIHAN_VALUE']);
        $this->ACKNOWLEDGEBY->setDbValue($row['ACKNOWLEDGEBY']);
        $this->NUM->setDbValue($row['NUM']);
        $this->ID->setDbValue($row['ID']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['ORG_UNIT_CODE'] = null;
        $row['PO'] = null;
        $row['PO_DATE'] = null;
        $row['ORDER_VALUE'] = null;
        $row['RECEIVED_VALUE'] = null;
        $row['PROCURE_METHOD'] = null;
        $row['COMPANY_ID'] = null;
        $row['FUND_ID'] = null;
        $row['FUND_NO'] = null;
        $row['DESCRIPTION'] = null;
        $row['MODIFIED_DATE'] = null;
        $row['MODIFIED_BY'] = null;
        $row['ORDER_BY'] = null;
        $row['SENT_TO'] = null;
        $row['ISVALID'] = null;
        $row['START_VALID'] = null;
        $row['END_VALID'] = null;
        $row['CONTRACT_NO'] = null;
        $row['ORG_ID'] = null;
        $row['CLINIC_ID'] = null;
        $row['ACCOUNT_ID'] = null;
        $row['PAID_VALUE'] = null;
        $row['PPN'] = null;
        $row['MATERAI'] = null;
        $row['PPN_VALUE'] = null;
        $row['DISCOUNT_VALUE'] = null;
        $row['ISCETAK'] = null;
        $row['PRINT_DATE'] = null;
        $row['PRINTED_BY'] = null;
        $row['PRINTQ'] = null;
        $row['TAGIHAN_VALUE'] = null;
        $row['ACKNOWLEDGEBY'] = null;
        $row['NUM'] = null;
        $row['ID'] = null;
        return $row;
    }

    // Render row values based on field settings
    public function renderRow()
    {
        global $Security, $Language, $CurrentLanguage;

        // Initialize URLs

        // Convert decimal values if posted back
        if ($this->ORDER_VALUE->FormValue == $this->ORDER_VALUE->CurrentValue && is_numeric(ConvertToFloatString($this->ORDER_VALUE->CurrentValue))) {
            $this->ORDER_VALUE->CurrentValue = ConvertToFloatString($this->ORDER_VALUE->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->RECEIVED_VALUE->FormValue == $this->RECEIVED_VALUE->CurrentValue && is_numeric(ConvertToFloatString($this->RECEIVED_VALUE->CurrentValue))) {
            $this->RECEIVED_VALUE->CurrentValue = ConvertToFloatString($this->RECEIVED_VALUE->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->PAID_VALUE->FormValue == $this->PAID_VALUE->CurrentValue && is_numeric(ConvertToFloatString($this->PAID_VALUE->CurrentValue))) {
            $this->PAID_VALUE->CurrentValue = ConvertToFloatString($this->PAID_VALUE->CurrentValue);
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
        if ($this->PPN_VALUE->FormValue == $this->PPN_VALUE->CurrentValue && is_numeric(ConvertToFloatString($this->PPN_VALUE->CurrentValue))) {
            $this->PPN_VALUE->CurrentValue = ConvertToFloatString($this->PPN_VALUE->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->DISCOUNT_VALUE->FormValue == $this->DISCOUNT_VALUE->CurrentValue && is_numeric(ConvertToFloatString($this->DISCOUNT_VALUE->CurrentValue))) {
            $this->DISCOUNT_VALUE->CurrentValue = ConvertToFloatString($this->DISCOUNT_VALUE->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->TAGIHAN_VALUE->FormValue == $this->TAGIHAN_VALUE->CurrentValue && is_numeric(ConvertToFloatString($this->TAGIHAN_VALUE->CurrentValue))) {
            $this->TAGIHAN_VALUE->CurrentValue = ConvertToFloatString($this->TAGIHAN_VALUE->CurrentValue);
        }

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // ORG_UNIT_CODE

        // PO

        // PO_DATE

        // ORDER_VALUE

        // RECEIVED_VALUE

        // PROCURE_METHOD

        // COMPANY_ID

        // FUND_ID

        // FUND_NO

        // DESCRIPTION

        // MODIFIED_DATE

        // MODIFIED_BY

        // ORDER_BY

        // SENT_TO

        // ISVALID

        // START_VALID

        // END_VALID

        // CONTRACT_NO

        // ORG_ID

        // CLINIC_ID

        // ACCOUNT_ID

        // PAID_VALUE

        // PPN

        // MATERAI

        // PPN_VALUE

        // DISCOUNT_VALUE

        // ISCETAK

        // PRINT_DATE

        // PRINTED_BY

        // PRINTQ

        // TAGIHAN_VALUE

        // ACKNOWLEDGEBY

        // NUM

        // ID
        if ($this->RowType == ROWTYPE_VIEW) {
            // ORG_UNIT_CODE
            $this->ORG_UNIT_CODE->ViewValue = $this->ORG_UNIT_CODE->CurrentValue;
            $this->ORG_UNIT_CODE->ViewCustomAttributes = "";

            // PO
            $this->PO->ViewValue = $this->PO->CurrentValue;
            $this->PO->ViewCustomAttributes = "";

            // PO_DATE
            $this->PO_DATE->ViewValue = $this->PO_DATE->CurrentValue;
            $this->PO_DATE->ViewValue = FormatDateTime($this->PO_DATE->ViewValue, 0);
            $this->PO_DATE->ViewCustomAttributes = "";

            // ORDER_VALUE
            $this->ORDER_VALUE->ViewValue = $this->ORDER_VALUE->CurrentValue;
            $this->ORDER_VALUE->ViewValue = FormatNumber($this->ORDER_VALUE->ViewValue, 2, -2, -2, -2);
            $this->ORDER_VALUE->ViewCustomAttributes = "";

            // RECEIVED_VALUE
            $this->RECEIVED_VALUE->ViewValue = $this->RECEIVED_VALUE->CurrentValue;
            $this->RECEIVED_VALUE->ViewValue = FormatNumber($this->RECEIVED_VALUE->ViewValue, 2, -2, -2, -2);
            $this->RECEIVED_VALUE->ViewCustomAttributes = "";

            // PROCURE_METHOD
            $this->PROCURE_METHOD->ViewValue = $this->PROCURE_METHOD->CurrentValue;
            $this->PROCURE_METHOD->ViewValue = FormatNumber($this->PROCURE_METHOD->ViewValue, 0, -2, -2, -2);
            $this->PROCURE_METHOD->ViewCustomAttributes = "";

            // COMPANY_ID
            $this->COMPANY_ID->ViewValue = $this->COMPANY_ID->CurrentValue;
            $this->COMPANY_ID->ViewCustomAttributes = "";

            // FUND_ID
            $this->FUND_ID->ViewValue = $this->FUND_ID->CurrentValue;
            $this->FUND_ID->ViewValue = FormatNumber($this->FUND_ID->ViewValue, 0, -2, -2, -2);
            $this->FUND_ID->ViewCustomAttributes = "";

            // FUND_NO
            $this->FUND_NO->ViewValue = $this->FUND_NO->CurrentValue;
            $this->FUND_NO->ViewCustomAttributes = "";

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

            // ORDER_BY
            $this->ORDER_BY->ViewValue = $this->ORDER_BY->CurrentValue;
            $this->ORDER_BY->ViewCustomAttributes = "";

            // SENT_TO
            $this->SENT_TO->ViewValue = $this->SENT_TO->CurrentValue;
            $this->SENT_TO->ViewCustomAttributes = "";

            // ISVALID
            $this->ISVALID->ViewValue = $this->ISVALID->CurrentValue;
            $this->ISVALID->ViewCustomAttributes = "";

            // START_VALID
            $this->START_VALID->ViewValue = $this->START_VALID->CurrentValue;
            $this->START_VALID->ViewValue = FormatDateTime($this->START_VALID->ViewValue, 0);
            $this->START_VALID->ViewCustomAttributes = "";

            // END_VALID
            $this->END_VALID->ViewValue = $this->END_VALID->CurrentValue;
            $this->END_VALID->ViewValue = FormatDateTime($this->END_VALID->ViewValue, 0);
            $this->END_VALID->ViewCustomAttributes = "";

            // CONTRACT_NO
            $this->CONTRACT_NO->ViewValue = $this->CONTRACT_NO->CurrentValue;
            $this->CONTRACT_NO->ViewCustomAttributes = "";

            // ORG_ID
            $this->ORG_ID->ViewValue = $this->ORG_ID->CurrentValue;
            $this->ORG_ID->ViewCustomAttributes = "";

            // CLINIC_ID
            $this->CLINIC_ID->ViewValue = $this->CLINIC_ID->CurrentValue;
            $this->CLINIC_ID->ViewCustomAttributes = "";

            // ACCOUNT_ID
            $this->ACCOUNT_ID->ViewValue = $this->ACCOUNT_ID->CurrentValue;
            $this->ACCOUNT_ID->ViewCustomAttributes = "";

            // PAID_VALUE
            $this->PAID_VALUE->ViewValue = $this->PAID_VALUE->CurrentValue;
            $this->PAID_VALUE->ViewValue = FormatNumber($this->PAID_VALUE->ViewValue, 2, -2, -2, -2);
            $this->PAID_VALUE->ViewCustomAttributes = "";

            // PPN
            $this->PPN->ViewValue = $this->PPN->CurrentValue;
            $this->PPN->ViewValue = FormatNumber($this->PPN->ViewValue, 2, -2, -2, -2);
            $this->PPN->ViewCustomAttributes = "";

            // MATERAI
            $this->MATERAI->ViewValue = $this->MATERAI->CurrentValue;
            $this->MATERAI->ViewValue = FormatNumber($this->MATERAI->ViewValue, 2, -2, -2, -2);
            $this->MATERAI->ViewCustomAttributes = "";

            // PPN_VALUE
            $this->PPN_VALUE->ViewValue = $this->PPN_VALUE->CurrentValue;
            $this->PPN_VALUE->ViewValue = FormatNumber($this->PPN_VALUE->ViewValue, 2, -2, -2, -2);
            $this->PPN_VALUE->ViewCustomAttributes = "";

            // DISCOUNT_VALUE
            $this->DISCOUNT_VALUE->ViewValue = $this->DISCOUNT_VALUE->CurrentValue;
            $this->DISCOUNT_VALUE->ViewValue = FormatNumber($this->DISCOUNT_VALUE->ViewValue, 2, -2, -2, -2);
            $this->DISCOUNT_VALUE->ViewCustomAttributes = "";

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

            // TAGIHAN_VALUE
            $this->TAGIHAN_VALUE->ViewValue = $this->TAGIHAN_VALUE->CurrentValue;
            $this->TAGIHAN_VALUE->ViewValue = FormatNumber($this->TAGIHAN_VALUE->ViewValue, 2, -2, -2, -2);
            $this->TAGIHAN_VALUE->ViewCustomAttributes = "";

            // ACKNOWLEDGEBY
            $this->ACKNOWLEDGEBY->ViewValue = $this->ACKNOWLEDGEBY->CurrentValue;
            $this->ACKNOWLEDGEBY->ViewCustomAttributes = "";

            // NUM
            $this->NUM->ViewValue = $this->NUM->CurrentValue;
            $this->NUM->ViewValue = FormatNumber($this->NUM->ViewValue, 0, -2, -2, -2);
            $this->NUM->ViewCustomAttributes = "";

            // ID
            $this->ID->ViewValue = $this->ID->CurrentValue;
            $this->ID->ViewCustomAttributes = "";

            // ORG_UNIT_CODE
            $this->ORG_UNIT_CODE->LinkCustomAttributes = "";
            $this->ORG_UNIT_CODE->HrefValue = "";
            $this->ORG_UNIT_CODE->TooltipValue = "";

            // PO
            $this->PO->LinkCustomAttributes = "";
            $this->PO->HrefValue = "";
            $this->PO->TooltipValue = "";

            // PO_DATE
            $this->PO_DATE->LinkCustomAttributes = "";
            $this->PO_DATE->HrefValue = "";
            $this->PO_DATE->TooltipValue = "";

            // ORDER_VALUE
            $this->ORDER_VALUE->LinkCustomAttributes = "";
            $this->ORDER_VALUE->HrefValue = "";
            $this->ORDER_VALUE->TooltipValue = "";

            // RECEIVED_VALUE
            $this->RECEIVED_VALUE->LinkCustomAttributes = "";
            $this->RECEIVED_VALUE->HrefValue = "";
            $this->RECEIVED_VALUE->TooltipValue = "";

            // PROCURE_METHOD
            $this->PROCURE_METHOD->LinkCustomAttributes = "";
            $this->PROCURE_METHOD->HrefValue = "";
            $this->PROCURE_METHOD->TooltipValue = "";

            // COMPANY_ID
            $this->COMPANY_ID->LinkCustomAttributes = "";
            $this->COMPANY_ID->HrefValue = "";
            $this->COMPANY_ID->TooltipValue = "";

            // FUND_ID
            $this->FUND_ID->LinkCustomAttributes = "";
            $this->FUND_ID->HrefValue = "";
            $this->FUND_ID->TooltipValue = "";

            // FUND_NO
            $this->FUND_NO->LinkCustomAttributes = "";
            $this->FUND_NO->HrefValue = "";
            $this->FUND_NO->TooltipValue = "";

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

            // ORDER_BY
            $this->ORDER_BY->LinkCustomAttributes = "";
            $this->ORDER_BY->HrefValue = "";
            $this->ORDER_BY->TooltipValue = "";

            // SENT_TO
            $this->SENT_TO->LinkCustomAttributes = "";
            $this->SENT_TO->HrefValue = "";
            $this->SENT_TO->TooltipValue = "";

            // ISVALID
            $this->ISVALID->LinkCustomAttributes = "";
            $this->ISVALID->HrefValue = "";
            $this->ISVALID->TooltipValue = "";

            // START_VALID
            $this->START_VALID->LinkCustomAttributes = "";
            $this->START_VALID->HrefValue = "";
            $this->START_VALID->TooltipValue = "";

            // END_VALID
            $this->END_VALID->LinkCustomAttributes = "";
            $this->END_VALID->HrefValue = "";
            $this->END_VALID->TooltipValue = "";

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

            // ACCOUNT_ID
            $this->ACCOUNT_ID->LinkCustomAttributes = "";
            $this->ACCOUNT_ID->HrefValue = "";
            $this->ACCOUNT_ID->TooltipValue = "";

            // PAID_VALUE
            $this->PAID_VALUE->LinkCustomAttributes = "";
            $this->PAID_VALUE->HrefValue = "";
            $this->PAID_VALUE->TooltipValue = "";

            // PPN
            $this->PPN->LinkCustomAttributes = "";
            $this->PPN->HrefValue = "";
            $this->PPN->TooltipValue = "";

            // MATERAI
            $this->MATERAI->LinkCustomAttributes = "";
            $this->MATERAI->HrefValue = "";
            $this->MATERAI->TooltipValue = "";

            // PPN_VALUE
            $this->PPN_VALUE->LinkCustomAttributes = "";
            $this->PPN_VALUE->HrefValue = "";
            $this->PPN_VALUE->TooltipValue = "";

            // DISCOUNT_VALUE
            $this->DISCOUNT_VALUE->LinkCustomAttributes = "";
            $this->DISCOUNT_VALUE->HrefValue = "";
            $this->DISCOUNT_VALUE->TooltipValue = "";

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

            // TAGIHAN_VALUE
            $this->TAGIHAN_VALUE->LinkCustomAttributes = "";
            $this->TAGIHAN_VALUE->HrefValue = "";
            $this->TAGIHAN_VALUE->TooltipValue = "";

            // ACKNOWLEDGEBY
            $this->ACKNOWLEDGEBY->LinkCustomAttributes = "";
            $this->ACKNOWLEDGEBY->HrefValue = "";
            $this->ACKNOWLEDGEBY->TooltipValue = "";

            // NUM
            $this->NUM->LinkCustomAttributes = "";
            $this->NUM->HrefValue = "";
            $this->NUM->TooltipValue = "";

            // ID
            $this->ID->LinkCustomAttributes = "";
            $this->ID->HrefValue = "";
            $this->ID->TooltipValue = "";
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("PoList"), "", $this->TableVar, true);
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
