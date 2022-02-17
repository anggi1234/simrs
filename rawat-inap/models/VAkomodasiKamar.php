<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

use Doctrine\DBAL\ParameterType;

/**
 * Table class for V_AKOMODASI_KAMAR
 */
class VAkomodasiKamar extends DbTable
{
    protected $SqlFrom = "";
    protected $SqlSelect = null;
    protected $SqlSelectList = null;
    protected $SqlWhere = "";
    protected $SqlGroupBy = "";
    protected $SqlHaving = "";
    protected $SqlOrderBy = "";
    public $UseSessionForListSql = true;

    // Column CSS classes
    public $LeftColumnClass = "col-sm-2 col-form-label ew-label";
    public $RightColumnClass = "col-sm-10";
    public $OffsetColumnClass = "col-sm-10 offset-sm-2";
    public $TableLeftColumnClass = "w-col-2";

    // Export
    public $ExportDoc;

    // Fields
    public $ID;
    public $BILL_ID;
    public $NO_REGISTRATION;
    public $VISIT_ID;
    public $TRANS_ID;
    public $TARIF_ID;
    public $CLASS_ID;
    public $CLINIC_ID;
    public $CLINIC_ID_FROM;
    public $TREATMENT;
    public $TREAT_DATE;
    public $QUANTITY;
    public $MEASURE_ID;
    public $DESCRIPTION;
    public $CLASS_ROOM_ID;
    public $KELUAR_ID;
    public $BED_ID;
    public $EMPLOYEE_ID;
    public $DOCTOR;
    public $EXIT_DATE;
    public $EMPLOYEE_ID_FROM;
    public $DOCTOR_FROM;
    public $STATUS_PASIEN_ID;
    public $THENAME;
    public $THEADDRESS;
    public $THEID;
    public $ISRJ;
    public $AGEYEAR;
    public $AGEMONTH;
    public $AGEDAY;
    public $GENDER;
    public $KARYAWAN;
    public $MODIFIED_BY;
    public $MODIFIED_DATE;
    public $MODIFIED_FROM;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'V_AKOMODASI_KAMAR';
        $this->TableName = 'V_AKOMODASI_KAMAR';
        $this->TableType = 'CUSTOMVIEW';

        // Update Table
        $this->UpdateTable = "dbo.TREATMENT_AKOMODASI";
        $this->Dbid = 'DB';
        $this->ExportAll = true;
        $this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
        $this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
        $this->ExportPageSize = "a4"; // Page size (PDF only)
        $this->ExportExcelPageOrientation = ""; // Page orientation (PhpSpreadsheet only)
        $this->ExportExcelPageSize = ""; // Page size (PhpSpreadsheet only)
        $this->ExportWordPageOrientation = "portrait"; // Page orientation (PHPWord only)
        $this->ExportWordColumnWidth = null; // Cell width (PHPWord only)
        $this->DetailAdd = false; // Allow detail add
        $this->DetailEdit = true; // Allow detail edit
        $this->DetailView = true; // Allow detail view
        $this->ShowMultipleDetails = false; // Show multiple details
        $this->GridAddRowCount = 1;
        $this->AllowAddDeleteRow = true; // Allow add/delete row
        $this->UserIDAllowSecurity = Config("DEFAULT_USER_ID_ALLOW_SECURITY"); // Default User ID allowed permissions
        $this->BasicSearch = new BasicSearch($this->TableVar);

        // ID
        $this->ID = new DbField('V_AKOMODASI_KAMAR', 'V_AKOMODASI_KAMAR', 'x_ID', 'ID', 'dbo.TREATMENT_AKOMODASI.ID', 'CAST(dbo.TREATMENT_AKOMODASI.ID AS NVARCHAR)', 3, 4, -1, false, 'dbo.TREATMENT_AKOMODASI.ID', false, false, false, 'FORMATTED TEXT', 'NO');
        $this->ID->IsAutoIncrement = true; // Autoincrement field
        $this->ID->IsPrimaryKey = true; // Primary key field
        $this->ID->Nullable = false; // NOT NULL field
        $this->ID->Sortable = true; // Allow sort
        $this->ID->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->ID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->ID->Param, "CustomMsg");
        $this->Fields['ID'] = &$this->ID;

        // BILL_ID
        $this->BILL_ID = new DbField('V_AKOMODASI_KAMAR', 'V_AKOMODASI_KAMAR', 'x_BILL_ID', 'BILL_ID', 'dbo.TREATMENT_AKOMODASI.BILL_ID', 'dbo.TREATMENT_AKOMODASI.BILL_ID', 200, 50, -1, false, 'dbo.TREATMENT_AKOMODASI.BILL_ID', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->BILL_ID->IsForeignKey = true; // Foreign key field
        $this->BILL_ID->Nullable = false; // NOT NULL field
        $this->BILL_ID->Required = true; // Required field
        $this->BILL_ID->Sortable = true; // Allow sort
        $this->BILL_ID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->BILL_ID->Param, "CustomMsg");
        $this->Fields['BILL_ID'] = &$this->BILL_ID;

        // NO_REGISTRATION
        $this->NO_REGISTRATION = new DbField('V_AKOMODASI_KAMAR', 'V_AKOMODASI_KAMAR', 'x_NO_REGISTRATION', 'NO_REGISTRATION', 'dbo.TREATMENT_AKOMODASI.NO_REGISTRATION', 'dbo.TREATMENT_AKOMODASI.NO_REGISTRATION', 200, 25, -1, false, 'dbo.TREATMENT_AKOMODASI.NO_REGISTRATION', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->NO_REGISTRATION->IsForeignKey = true; // Foreign key field
        $this->NO_REGISTRATION->Nullable = false; // NOT NULL field
        $this->NO_REGISTRATION->Required = true; // Required field
        $this->NO_REGISTRATION->Sortable = true; // Allow sort
        $this->NO_REGISTRATION->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->NO_REGISTRATION->Param, "CustomMsg");
        $this->Fields['NO_REGISTRATION'] = &$this->NO_REGISTRATION;

        // VISIT_ID
        $this->VISIT_ID = new DbField('V_AKOMODASI_KAMAR', 'V_AKOMODASI_KAMAR', 'x_VISIT_ID', 'VISIT_ID', 'dbo.TREATMENT_AKOMODASI.VISIT_ID', 'dbo.TREATMENT_AKOMODASI.VISIT_ID', 200, 50, -1, false, 'dbo.TREATMENT_AKOMODASI.VISIT_ID', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->VISIT_ID->IsForeignKey = true; // Foreign key field
        $this->VISIT_ID->Nullable = false; // NOT NULL field
        $this->VISIT_ID->Required = true; // Required field
        $this->VISIT_ID->Sortable = true; // Allow sort
        $this->VISIT_ID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->VISIT_ID->Param, "CustomMsg");
        $this->Fields['VISIT_ID'] = &$this->VISIT_ID;

        // TRANS_ID
        $this->TRANS_ID = new DbField('V_AKOMODASI_KAMAR', 'V_AKOMODASI_KAMAR', 'x_TRANS_ID', 'TRANS_ID', 'dbo.TREATMENT_AKOMODASI.TRANS_ID', 'dbo.TREATMENT_AKOMODASI.TRANS_ID', 200, 50, -1, false, 'dbo.TREATMENT_AKOMODASI.TRANS_ID', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->TRANS_ID->IsForeignKey = true; // Foreign key field
        $this->TRANS_ID->Sortable = true; // Allow sort
        $this->TRANS_ID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->TRANS_ID->Param, "CustomMsg");
        $this->Fields['TRANS_ID'] = &$this->TRANS_ID;

        // TARIF_ID
        $this->TARIF_ID = new DbField('V_AKOMODASI_KAMAR', 'V_AKOMODASI_KAMAR', 'x_TARIF_ID', 'TARIF_ID', 'dbo.TREATMENT_AKOMODASI.TARIF_ID', 'dbo.TREATMENT_AKOMODASI.TARIF_ID', 200, 25, -1, false, 'dbo.TREATMENT_AKOMODASI.TARIF_ID', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->TARIF_ID->Sortable = true; // Allow sort
        $this->TARIF_ID->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->TARIF_ID->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->TARIF_ID->Lookup = new Lookup('TARIF_ID', 'TREAT_TARIF', false, 'TARIF_ID', ["TARIF_NAME","","",""], [], [], [], [], ["TARIF_NAME"], ["x_TREATMENT"], '', '');
                break;
            default:
                $this->TARIF_ID->Lookup = new Lookup('TARIF_ID', 'TREAT_TARIF', false, 'TARIF_ID', ["TARIF_NAME","","",""], [], [], [], [], ["TARIF_NAME"], ["x_TREATMENT"], '', '');
                break;
        }
        $this->TARIF_ID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->TARIF_ID->Param, "CustomMsg");
        $this->Fields['TARIF_ID'] = &$this->TARIF_ID;

        // CLASS_ID
        $this->CLASS_ID = new DbField('V_AKOMODASI_KAMAR', 'V_AKOMODASI_KAMAR', 'x_CLASS_ID', 'CLASS_ID', 'dbo.TREATMENT_AKOMODASI.CLASS_ID', 'CAST(dbo.TREATMENT_AKOMODASI.CLASS_ID AS NVARCHAR)', 17, 1, -1, false, 'dbo.TREATMENT_AKOMODASI.CLASS_ID', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->CLASS_ID->Sortable = true; // Allow sort
        $this->CLASS_ID->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->CLASS_ID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->CLASS_ID->Param, "CustomMsg");
        $this->Fields['CLASS_ID'] = &$this->CLASS_ID;

        // CLINIC_ID
        $this->CLINIC_ID = new DbField('V_AKOMODASI_KAMAR', 'V_AKOMODASI_KAMAR', 'x_CLINIC_ID', 'CLINIC_ID', 'dbo.TREATMENT_AKOMODASI.CLINIC_ID', 'dbo.TREATMENT_AKOMODASI.CLINIC_ID', 200, 15, -1, false, 'dbo.TREATMENT_AKOMODASI.CLINIC_ID', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->CLINIC_ID->Sortable = true; // Allow sort
        $this->CLINIC_ID->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->CLINIC_ID->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->CLINIC_ID->Lookup = new Lookup('CLINIC_ID', 'CLINIC', false, 'CLINIC_ID', ["NAME_OF_CLINIC","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->CLINIC_ID->Lookup = new Lookup('CLINIC_ID', 'CLINIC', false, 'CLINIC_ID', ["NAME_OF_CLINIC","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->CLINIC_ID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->CLINIC_ID->Param, "CustomMsg");
        $this->Fields['CLINIC_ID'] = &$this->CLINIC_ID;

        // CLINIC_ID_FROM
        $this->CLINIC_ID_FROM = new DbField('V_AKOMODASI_KAMAR', 'V_AKOMODASI_KAMAR', 'x_CLINIC_ID_FROM', 'CLINIC_ID_FROM', 'dbo.TREATMENT_AKOMODASI.CLINIC_ID_FROM', 'dbo.TREATMENT_AKOMODASI.CLINIC_ID_FROM', 200, 15, -1, false, 'dbo.TREATMENT_AKOMODASI.CLINIC_ID_FROM', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->CLINIC_ID_FROM->Sortable = true; // Allow sort
        $this->CLINIC_ID_FROM->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->CLINIC_ID_FROM->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->CLINIC_ID_FROM->Lookup = new Lookup('CLINIC_ID_FROM', 'CLINIC', false, 'CLINIC_ID', ["CLINIC_TYPE","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->CLINIC_ID_FROM->Lookup = new Lookup('CLINIC_ID_FROM', 'CLINIC', false, 'CLINIC_ID', ["CLINIC_TYPE","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->CLINIC_ID_FROM->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->CLINIC_ID_FROM->Param, "CustomMsg");
        $this->Fields['CLINIC_ID_FROM'] = &$this->CLINIC_ID_FROM;

        // TREATMENT
        $this->TREATMENT = new DbField('V_AKOMODASI_KAMAR', 'V_AKOMODASI_KAMAR', 'x_TREATMENT', 'TREATMENT', 'dbo.TREATMENT_AKOMODASI.TREATMENT', 'dbo.TREATMENT_AKOMODASI.TREATMENT', 200, 200, -1, false, 'dbo.TREATMENT_AKOMODASI.TREATMENT', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->TREATMENT->Sortable = true; // Allow sort
        $this->TREATMENT->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->TREATMENT->Param, "CustomMsg");
        $this->Fields['TREATMENT'] = &$this->TREATMENT;

        // TREAT_DATE
        $this->TREAT_DATE = new DbField('V_AKOMODASI_KAMAR', 'V_AKOMODASI_KAMAR', 'x_TREAT_DATE', 'TREAT_DATE', 'dbo.TREATMENT_AKOMODASI.TREAT_DATE', CastDateFieldForLike("dbo.TREATMENT_AKOMODASI.TREAT_DATE", 11, "DB"), 135, 8, 11, false, 'dbo.TREATMENT_AKOMODASI.TREAT_DATE', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->TREAT_DATE->Sortable = true; // Allow sort
        $this->TREAT_DATE->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_SEPARATOR"], $Language->phrase("IncorrectDateDMY"));
        $this->TREAT_DATE->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->TREAT_DATE->Param, "CustomMsg");
        $this->Fields['TREAT_DATE'] = &$this->TREAT_DATE;

        // QUANTITY
        $this->QUANTITY = new DbField('V_AKOMODASI_KAMAR', 'V_AKOMODASI_KAMAR', 'x_QUANTITY', 'QUANTITY', 'dbo.TREATMENT_AKOMODASI.QUANTITY', 'CAST(dbo.TREATMENT_AKOMODASI.QUANTITY AS NVARCHAR)', 131, 8, -1, false, 'dbo.TREATMENT_AKOMODASI.QUANTITY', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->QUANTITY->Sortable = true; // Allow sort
        $this->QUANTITY->DefaultDecimalPrecision = 2; // Default decimal precision
        $this->QUANTITY->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->QUANTITY->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->QUANTITY->Param, "CustomMsg");
        $this->Fields['QUANTITY'] = &$this->QUANTITY;

        // MEASURE_ID
        $this->MEASURE_ID = new DbField('V_AKOMODASI_KAMAR', 'V_AKOMODASI_KAMAR', 'x_MEASURE_ID', 'MEASURE_ID', 'dbo.TREATMENT_AKOMODASI.MEASURE_ID', 'CAST(dbo.TREATMENT_AKOMODASI.MEASURE_ID AS NVARCHAR)', 2, 2, -1, false, 'dbo.TREATMENT_AKOMODASI.MEASURE_ID', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->MEASURE_ID->Sortable = true; // Allow sort
        $this->MEASURE_ID->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->MEASURE_ID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->MEASURE_ID->Param, "CustomMsg");
        $this->Fields['MEASURE_ID'] = &$this->MEASURE_ID;

        // DESCRIPTION
        $this->DESCRIPTION = new DbField('V_AKOMODASI_KAMAR', 'V_AKOMODASI_KAMAR', 'x_DESCRIPTION', 'DESCRIPTION', 'dbo.TREATMENT_AKOMODASI.DESCRIPTION', 'dbo.TREATMENT_AKOMODASI.DESCRIPTION', 200, 200, -1, false, 'dbo.TREATMENT_AKOMODASI.DESCRIPTION', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->DESCRIPTION->Sortable = true; // Allow sort
        $this->DESCRIPTION->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->DESCRIPTION->Param, "CustomMsg");
        $this->Fields['DESCRIPTION'] = &$this->DESCRIPTION;

        // CLASS_ROOM_ID
        $this->CLASS_ROOM_ID = new DbField('V_AKOMODASI_KAMAR', 'V_AKOMODASI_KAMAR', 'x_CLASS_ROOM_ID', 'CLASS_ROOM_ID', 'dbo.TREATMENT_AKOMODASI.CLASS_ROOM_ID', 'dbo.TREATMENT_AKOMODASI.CLASS_ROOM_ID', 200, 16, -1, false, 'dbo.TREATMENT_AKOMODASI.CLASS_ROOM_ID', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->CLASS_ROOM_ID->Sortable = true; // Allow sort
        $this->CLASS_ROOM_ID->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->CLASS_ROOM_ID->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->CLASS_ROOM_ID->Lookup = new Lookup('CLASS_ROOM_ID', 'CLASS_ROOM', false, 'CLASS_ROOM_ID', ["NAME_OF_CLASS","","",""], [], [], [], [], ["NAME_OF_CLASS"], ["x_DESCRIPTION"], '', '');
                break;
            default:
                $this->CLASS_ROOM_ID->Lookup = new Lookup('CLASS_ROOM_ID', 'CLASS_ROOM', false, 'CLASS_ROOM_ID', ["NAME_OF_CLASS","","",""], [], [], [], [], ["NAME_OF_CLASS"], ["x_DESCRIPTION"], '', '');
                break;
        }
        $this->CLASS_ROOM_ID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->CLASS_ROOM_ID->Param, "CustomMsg");
        $this->Fields['CLASS_ROOM_ID'] = &$this->CLASS_ROOM_ID;

        // KELUAR_ID
        $this->KELUAR_ID = new DbField('V_AKOMODASI_KAMAR', 'V_AKOMODASI_KAMAR', 'x_KELUAR_ID', 'KELUAR_ID', 'dbo.TREATMENT_AKOMODASI.KELUAR_ID', 'CAST(dbo.TREATMENT_AKOMODASI.KELUAR_ID AS NVARCHAR)', 17, 1, -1, false, 'dbo.TREATMENT_AKOMODASI.KELUAR_ID', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->KELUAR_ID->Sortable = true; // Allow sort
        $this->KELUAR_ID->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->KELUAR_ID->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->KELUAR_ID->Lookup = new Lookup('KELUAR_ID', 'CARA_KELUAR', false, 'KELUAR_ID', ["CARA_KELUAR","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->KELUAR_ID->Lookup = new Lookup('KELUAR_ID', 'CARA_KELUAR', false, 'KELUAR_ID', ["CARA_KELUAR","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->KELUAR_ID->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->KELUAR_ID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->KELUAR_ID->Param, "CustomMsg");
        $this->Fields['KELUAR_ID'] = &$this->KELUAR_ID;

        // BED_ID
        $this->BED_ID = new DbField('V_AKOMODASI_KAMAR', 'V_AKOMODASI_KAMAR', 'x_BED_ID', 'BED_ID', 'dbo.TREATMENT_AKOMODASI.BED_ID', 'CAST(dbo.TREATMENT_AKOMODASI.BED_ID AS NVARCHAR)', 17, 1, -1, false, 'dbo.TREATMENT_AKOMODASI.BED_ID', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->BED_ID->Sortable = true; // Allow sort
        $this->BED_ID->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->BED_ID->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->BED_ID->Lookup = new Lookup('BED_ID', 'BEDS', false, 'BED_ID', ["BED_ID","CLASS_ROOM_ID","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->BED_ID->Lookup = new Lookup('BED_ID', 'BEDS', false, 'BED_ID', ["BED_ID","CLASS_ROOM_ID","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->BED_ID->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->BED_ID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->BED_ID->Param, "CustomMsg");
        $this->Fields['BED_ID'] = &$this->BED_ID;

        // EMPLOYEE_ID
        $this->EMPLOYEE_ID = new DbField('V_AKOMODASI_KAMAR', 'V_AKOMODASI_KAMAR', 'x_EMPLOYEE_ID', 'EMPLOYEE_ID', 'dbo.TREATMENT_AKOMODASI.EMPLOYEE_ID', 'dbo.TREATMENT_AKOMODASI.EMPLOYEE_ID', 200, 15, -1, false, 'dbo.TREATMENT_AKOMODASI.EMPLOYEE_ID', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->EMPLOYEE_ID->Sortable = true; // Allow sort
        $this->EMPLOYEE_ID->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->EMPLOYEE_ID->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->EMPLOYEE_ID->Lookup = new Lookup('EMPLOYEE_ID', 'EMPLOYEE_ALL', false, 'EMPLOYEE_ID', ["FULLNAME","","",""], [], [], [], [], ["FULLNAME"], ["x_DOCTOR"], '', '');
                break;
            default:
                $this->EMPLOYEE_ID->Lookup = new Lookup('EMPLOYEE_ID', 'EMPLOYEE_ALL', false, 'EMPLOYEE_ID', ["FULLNAME","","",""], [], [], [], [], ["FULLNAME"], ["x_DOCTOR"], '', '');
                break;
        }
        $this->EMPLOYEE_ID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->EMPLOYEE_ID->Param, "CustomMsg");
        $this->Fields['EMPLOYEE_ID'] = &$this->EMPLOYEE_ID;

        // DOCTOR
        $this->DOCTOR = new DbField('V_AKOMODASI_KAMAR', 'V_AKOMODASI_KAMAR', 'x_DOCTOR', 'DOCTOR', 'dbo.TREATMENT_AKOMODASI.DOCTOR', 'dbo.TREATMENT_AKOMODASI.DOCTOR', 200, 100, -1, false, 'dbo.TREATMENT_AKOMODASI.DOCTOR', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->DOCTOR->Sortable = true; // Allow sort
        $this->DOCTOR->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->DOCTOR->Param, "CustomMsg");
        $this->Fields['DOCTOR'] = &$this->DOCTOR;

        // EXIT_DATE
        $this->EXIT_DATE = new DbField('V_AKOMODASI_KAMAR', 'V_AKOMODASI_KAMAR', 'x_EXIT_DATE', 'EXIT_DATE', 'dbo.TREATMENT_AKOMODASI.EXIT_DATE', CastDateFieldForLike("dbo.TREATMENT_AKOMODASI.EXIT_DATE", 11, "DB"), 135, 8, 11, false, 'dbo.TREATMENT_AKOMODASI.EXIT_DATE', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->EXIT_DATE->Sortable = true; // Allow sort
        $this->EXIT_DATE->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_SEPARATOR"], $Language->phrase("IncorrectDateDMY"));
        $this->EXIT_DATE->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->EXIT_DATE->Param, "CustomMsg");
        $this->Fields['EXIT_DATE'] = &$this->EXIT_DATE;

        // EMPLOYEE_ID_FROM
        $this->EMPLOYEE_ID_FROM = new DbField('V_AKOMODASI_KAMAR', 'V_AKOMODASI_KAMAR', 'x_EMPLOYEE_ID_FROM', 'EMPLOYEE_ID_FROM', 'dbo.TREATMENT_AKOMODASI.EMPLOYEE_ID_FROM', 'dbo.TREATMENT_AKOMODASI.EMPLOYEE_ID_FROM', 200, 50, -1, false, 'dbo.TREATMENT_AKOMODASI.EMPLOYEE_ID_FROM', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->EMPLOYEE_ID_FROM->Sortable = true; // Allow sort
        $this->EMPLOYEE_ID_FROM->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->EMPLOYEE_ID_FROM->Param, "CustomMsg");
        $this->Fields['EMPLOYEE_ID_FROM'] = &$this->EMPLOYEE_ID_FROM;

        // DOCTOR_FROM
        $this->DOCTOR_FROM = new DbField('V_AKOMODASI_KAMAR', 'V_AKOMODASI_KAMAR', 'x_DOCTOR_FROM', 'DOCTOR_FROM', 'dbo.TREATMENT_AKOMODASI.DOCTOR_FROM', 'dbo.TREATMENT_AKOMODASI.DOCTOR_FROM', 200, 50, -1, false, 'dbo.TREATMENT_AKOMODASI.DOCTOR_FROM', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->DOCTOR_FROM->Sortable = true; // Allow sort
        $this->DOCTOR_FROM->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->DOCTOR_FROM->Param, "CustomMsg");
        $this->Fields['DOCTOR_FROM'] = &$this->DOCTOR_FROM;

        // STATUS_PASIEN_ID
        $this->STATUS_PASIEN_ID = new DbField('V_AKOMODASI_KAMAR', 'V_AKOMODASI_KAMAR', 'x_STATUS_PASIEN_ID', 'STATUS_PASIEN_ID', 'dbo.TREATMENT_AKOMODASI.STATUS_PASIEN_ID', 'CAST(dbo.TREATMENT_AKOMODASI.STATUS_PASIEN_ID AS NVARCHAR)', 17, 1, -1, false, 'dbo.TREATMENT_AKOMODASI.STATUS_PASIEN_ID', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->STATUS_PASIEN_ID->Sortable = true; // Allow sort
        $this->STATUS_PASIEN_ID->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->STATUS_PASIEN_ID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->STATUS_PASIEN_ID->Param, "CustomMsg");
        $this->Fields['STATUS_PASIEN_ID'] = &$this->STATUS_PASIEN_ID;

        // THENAME
        $this->THENAME = new DbField('V_AKOMODASI_KAMAR', 'V_AKOMODASI_KAMAR', 'x_THENAME', 'THENAME', 'dbo.TREATMENT_AKOMODASI.THENAME', 'dbo.TREATMENT_AKOMODASI.THENAME', 200, 100, -1, false, 'dbo.TREATMENT_AKOMODASI.THENAME', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->THENAME->IsForeignKey = true; // Foreign key field
        $this->THENAME->Sortable = true; // Allow sort
        $this->THENAME->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->THENAME->Param, "CustomMsg");
        $this->Fields['THENAME'] = &$this->THENAME;

        // THEADDRESS
        $this->THEADDRESS = new DbField('V_AKOMODASI_KAMAR', 'V_AKOMODASI_KAMAR', 'x_THEADDRESS', 'THEADDRESS', 'dbo.TREATMENT_AKOMODASI.THEADDRESS', 'dbo.TREATMENT_AKOMODASI.THEADDRESS', 200, 150, -1, false, 'dbo.TREATMENT_AKOMODASI.THEADDRESS', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->THEADDRESS->Sortable = true; // Allow sort
        $this->THEADDRESS->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->THEADDRESS->Param, "CustomMsg");
        $this->Fields['THEADDRESS'] = &$this->THEADDRESS;

        // THEID
        $this->THEID = new DbField('V_AKOMODASI_KAMAR', 'V_AKOMODASI_KAMAR', 'x_THEID', 'THEID', 'dbo.TREATMENT_AKOMODASI.THEID', 'dbo.TREATMENT_AKOMODASI.THEID', 200, 25, -1, false, 'dbo.TREATMENT_AKOMODASI.THEID', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->THEID->Sortable = true; // Allow sort
        $this->THEID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->THEID->Param, "CustomMsg");
        $this->Fields['THEID'] = &$this->THEID;

        // ISRJ
        $this->ISRJ = new DbField('V_AKOMODASI_KAMAR', 'V_AKOMODASI_KAMAR', 'x_ISRJ', 'ISRJ', 'dbo.TREATMENT_AKOMODASI.ISRJ', 'dbo.TREATMENT_AKOMODASI.ISRJ', 129, 1, -1, false, 'dbo.TREATMENT_AKOMODASI.ISRJ', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->ISRJ->Sortable = true; // Allow sort
        $this->ISRJ->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->ISRJ->Param, "CustomMsg");
        $this->Fields['ISRJ'] = &$this->ISRJ;

        // AGEYEAR
        $this->AGEYEAR = new DbField('V_AKOMODASI_KAMAR', 'V_AKOMODASI_KAMAR', 'x_AGEYEAR', 'AGEYEAR', 'dbo.TREATMENT_AKOMODASI.AGEYEAR', 'CAST(dbo.TREATMENT_AKOMODASI.AGEYEAR AS NVARCHAR)', 17, 1, -1, false, 'dbo.TREATMENT_AKOMODASI.AGEYEAR', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->AGEYEAR->Sortable = true; // Allow sort
        $this->AGEYEAR->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->AGEYEAR->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->AGEYEAR->Param, "CustomMsg");
        $this->Fields['AGEYEAR'] = &$this->AGEYEAR;

        // AGEMONTH
        $this->AGEMONTH = new DbField('V_AKOMODASI_KAMAR', 'V_AKOMODASI_KAMAR', 'x_AGEMONTH', 'AGEMONTH', 'dbo.TREATMENT_AKOMODASI.AGEMONTH', 'CAST(dbo.TREATMENT_AKOMODASI.AGEMONTH AS NVARCHAR)', 17, 1, -1, false, 'dbo.TREATMENT_AKOMODASI.AGEMONTH', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->AGEMONTH->Sortable = true; // Allow sort
        $this->AGEMONTH->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->AGEMONTH->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->AGEMONTH->Param, "CustomMsg");
        $this->Fields['AGEMONTH'] = &$this->AGEMONTH;

        // AGEDAY
        $this->AGEDAY = new DbField('V_AKOMODASI_KAMAR', 'V_AKOMODASI_KAMAR', 'x_AGEDAY', 'AGEDAY', 'dbo.TREATMENT_AKOMODASI.AGEDAY', 'CAST(dbo.TREATMENT_AKOMODASI.AGEDAY AS NVARCHAR)', 17, 1, -1, false, 'dbo.TREATMENT_AKOMODASI.AGEDAY', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->AGEDAY->Sortable = true; // Allow sort
        $this->AGEDAY->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->AGEDAY->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->AGEDAY->Param, "CustomMsg");
        $this->Fields['AGEDAY'] = &$this->AGEDAY;

        // GENDER
        $this->GENDER = new DbField('V_AKOMODASI_KAMAR', 'V_AKOMODASI_KAMAR', 'x_GENDER', 'GENDER', 'dbo.TREATMENT_AKOMODASI.GENDER', 'dbo.TREATMENT_AKOMODASI.GENDER', 129, 1, -1, false, 'dbo.TREATMENT_AKOMODASI.GENDER', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->GENDER->Sortable = true; // Allow sort
        $this->GENDER->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->GENDER->Param, "CustomMsg");
        $this->Fields['GENDER'] = &$this->GENDER;

        // KARYAWAN
        $this->KARYAWAN = new DbField('V_AKOMODASI_KAMAR', 'V_AKOMODASI_KAMAR', 'x_KARYAWAN', 'KARYAWAN', 'dbo.TREATMENT_AKOMODASI.KARYAWAN', 'dbo.TREATMENT_AKOMODASI.KARYAWAN', 200, 50, -1, false, 'dbo.TREATMENT_AKOMODASI.KARYAWAN', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->KARYAWAN->Sortable = true; // Allow sort
        $this->KARYAWAN->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->KARYAWAN->Param, "CustomMsg");
        $this->Fields['KARYAWAN'] = &$this->KARYAWAN;

        // MODIFIED_BY
        $this->MODIFIED_BY = new DbField('V_AKOMODASI_KAMAR', 'V_AKOMODASI_KAMAR', 'x_MODIFIED_BY', 'MODIFIED_BY', 'dbo.TREATMENT_AKOMODASI.MODIFIED_BY', 'dbo.TREATMENT_AKOMODASI.MODIFIED_BY', 200, 200, -1, false, 'dbo.TREATMENT_AKOMODASI.MODIFIED_BY', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->MODIFIED_BY->Sortable = true; // Allow sort
        $this->MODIFIED_BY->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->MODIFIED_BY->Param, "CustomMsg");
        $this->Fields['MODIFIED_BY'] = &$this->MODIFIED_BY;

        // MODIFIED_DATE
        $this->MODIFIED_DATE = new DbField('V_AKOMODASI_KAMAR', 'V_AKOMODASI_KAMAR', 'x_MODIFIED_DATE', 'MODIFIED_DATE', 'dbo.TREATMENT_AKOMODASI.MODIFIED_DATE', CastDateFieldForLike("dbo.TREATMENT_AKOMODASI.MODIFIED_DATE", 0, "DB"), 135, 8, 0, false, 'dbo.TREATMENT_AKOMODASI.MODIFIED_DATE', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->MODIFIED_DATE->Sortable = true; // Allow sort
        $this->MODIFIED_DATE->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->MODIFIED_DATE->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->MODIFIED_DATE->Param, "CustomMsg");
        $this->Fields['MODIFIED_DATE'] = &$this->MODIFIED_DATE;

        // MODIFIED_FROM
        $this->MODIFIED_FROM = new DbField('V_AKOMODASI_KAMAR', 'V_AKOMODASI_KAMAR', 'x_MODIFIED_FROM', 'MODIFIED_FROM', 'dbo.TREATMENT_AKOMODASI.MODIFIED_FROM', 'dbo.TREATMENT_AKOMODASI.MODIFIED_FROM', 200, 50, -1, false, 'dbo.TREATMENT_AKOMODASI.MODIFIED_FROM', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->MODIFIED_FROM->Sortable = true; // Allow sort
        $this->MODIFIED_FROM->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->MODIFIED_FROM->Param, "CustomMsg");
        $this->Fields['MODIFIED_FROM'] = &$this->MODIFIED_FROM;
    }

    // Field Visibility
    public function getFieldVisibility($fldParm)
    {
        global $Security;
        return $this->$fldParm->Visible; // Returns original value
    }

    // Set left column class (must be predefined col-*-* classes of Bootstrap grid system)
    public function setLeftColumnClass($class)
    {
        if (preg_match('/^col\-(\w+)\-(\d+)$/', $class, $match)) {
            $this->LeftColumnClass = $class . " col-form-label ew-label";
            $this->RightColumnClass = "col-" . $match[1] . "-" . strval(12 - (int)$match[2]);
            $this->OffsetColumnClass = $this->RightColumnClass . " " . str_replace("col-", "offset-", $class);
            $this->TableLeftColumnClass = preg_replace('/^col-\w+-(\d+)$/', "w-col-$1", $class); // Change to w-col-*
        }
    }

    // Single column sort
    public function updateSort(&$fld)
    {
        if ($this->CurrentOrder == $fld->Name) {
            $sortField = $fld->Expression;
            $lastSort = $fld->getSort();
            if (in_array($this->CurrentOrderType, ["ASC", "DESC", "NO"])) {
                $curSort = $this->CurrentOrderType;
            } else {
                $curSort = $lastSort;
            }
            $fld->setSort($curSort);
            $orderBy = in_array($curSort, ["ASC", "DESC"]) ? $sortField . " " . $curSort : "";
            $this->setSessionOrderBy($orderBy); // Save to Session
        } else {
            $fld->setSort("");
        }
    }

    // Current master table name
    public function getCurrentMasterTable()
    {
        return Session(PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_MASTER_TABLE"));
    }

    public function setCurrentMasterTable($v)
    {
        $_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_MASTER_TABLE")] = $v;
    }

    // Session master WHERE clause
    public function getMasterFilter()
    {
        // Master filter
        $masterFilter = "";
        if ($this->getCurrentMasterTable() == "PASIEN_VISITATION") {
            if ($this->VISIT_ID->getSessionValue() != "") {
                $masterFilter .= "" . GetForeignKeySql("[VISIT_ID]", $this->VISIT_ID->getSessionValue(), DATATYPE_STRING, "DB");
            } else {
                return "";
            }
            if ($this->NO_REGISTRATION->getSessionValue() != "") {
                $masterFilter .= " AND " . GetForeignKeySql("[NO_REGISTRATION]", $this->NO_REGISTRATION->getSessionValue(), DATATYPE_STRING, "DB");
            } else {
                return "";
            }
            if ($this->TRANS_ID->getSessionValue() != "") {
                $masterFilter .= " AND " . GetForeignKeySql("[TRANS_ID]", $this->TRANS_ID->getSessionValue(), DATATYPE_STRING, "DB");
            } else {
                return "";
            }
            if ($this->THENAME->getSessionValue() != "") {
                $masterFilter .= " AND " . GetForeignKeySql("[DIANTAR_OLEH]", $this->THENAME->getSessionValue(), DATATYPE_STRING, "DB");
            } else {
                return "";
            }
        }
        if ($this->getCurrentMasterTable() == "TREATMENT_BILL") {
            if ($this->BILL_ID->getSessionValue() != "") {
                $masterFilter .= "" . GetForeignKeySql("[BILL_ID]", $this->BILL_ID->getSessionValue(), DATATYPE_STRING, "DB");
            } else {
                return "";
            }
            if ($this->VISIT_ID->getSessionValue() != "") {
                $masterFilter .= " AND " . GetForeignKeySql("[VISIT_ID]", $this->VISIT_ID->getSessionValue(), DATATYPE_STRING, "DB");
            } else {
                return "";
            }
            if ($this->NO_REGISTRATION->getSessionValue() != "") {
                $masterFilter .= " AND " . GetForeignKeySql("[NO_REGISTRATION]", $this->NO_REGISTRATION->getSessionValue(), DATATYPE_STRING, "DB");
            } else {
                return "";
            }
            if ($this->TRANS_ID->getSessionValue() != "") {
                $masterFilter .= " AND " . GetForeignKeySql("[TRANS_ID]", $this->TRANS_ID->getSessionValue(), DATATYPE_STRING, "DB");
            } else {
                return "";
            }
        }
        return $masterFilter;
    }

    // Session detail WHERE clause
    public function getDetailFilter()
    {
        // Detail filter
        $detailFilter = "";
        if ($this->getCurrentMasterTable() == "PASIEN_VISITATION") {
            if ($this->VISIT_ID->getSessionValue() != "") {
                $detailFilter .= "" . GetForeignKeySql("dbo.TREATMENT_AKOMODASI.VISIT_ID", $this->VISIT_ID->getSessionValue(), DATATYPE_STRING, "DB");
            } else {
                return "";
            }
            if ($this->NO_REGISTRATION->getSessionValue() != "") {
                $detailFilter .= " AND " . GetForeignKeySql("dbo.TREATMENT_AKOMODASI.NO_REGISTRATION", $this->NO_REGISTRATION->getSessionValue(), DATATYPE_STRING, "DB");
            } else {
                return "";
            }
            if ($this->TRANS_ID->getSessionValue() != "") {
                $detailFilter .= " AND " . GetForeignKeySql("dbo.TREATMENT_AKOMODASI.TRANS_ID", $this->TRANS_ID->getSessionValue(), DATATYPE_STRING, "DB");
            } else {
                return "";
            }
            if ($this->THENAME->getSessionValue() != "") {
                $detailFilter .= " AND " . GetForeignKeySql("dbo.TREATMENT_AKOMODASI.THENAME", $this->THENAME->getSessionValue(), DATATYPE_STRING, "DB");
            } else {
                return "";
            }
        }
        if ($this->getCurrentMasterTable() == "TREATMENT_BILL") {
            if ($this->BILL_ID->getSessionValue() != "") {
                $detailFilter .= "" . GetForeignKeySql("dbo.TREATMENT_AKOMODASI.BILL_ID", $this->BILL_ID->getSessionValue(), DATATYPE_STRING, "DB");
            } else {
                return "";
            }
            if ($this->VISIT_ID->getSessionValue() != "") {
                $detailFilter .= " AND " . GetForeignKeySql("dbo.TREATMENT_AKOMODASI.VISIT_ID", $this->VISIT_ID->getSessionValue(), DATATYPE_STRING, "DB");
            } else {
                return "";
            }
            if ($this->NO_REGISTRATION->getSessionValue() != "") {
                $detailFilter .= " AND " . GetForeignKeySql("dbo.TREATMENT_AKOMODASI.NO_REGISTRATION", $this->NO_REGISTRATION->getSessionValue(), DATATYPE_STRING, "DB");
            } else {
                return "";
            }
            if ($this->TRANS_ID->getSessionValue() != "") {
                $detailFilter .= " AND " . GetForeignKeySql("dbo.TREATMENT_AKOMODASI.TRANS_ID", $this->TRANS_ID->getSessionValue(), DATATYPE_STRING, "DB");
            } else {
                return "";
            }
        }
        return $detailFilter;
    }

    // Master filter
    public function sqlMasterFilter_PASIEN_VISITATION()
    {
        return "[VISIT_ID]='@VISIT_ID@' AND [NO_REGISTRATION]='@NO_REGISTRATION@' AND [TRANS_ID]='@TRANS_ID@' AND [DIANTAR_OLEH]='@DIANTAR_OLEH@'";
    }
    // Detail filter
    public function sqlDetailFilter_PASIEN_VISITATION()
    {
        return "dbo.TREATMENT_AKOMODASI.VISIT_ID='@VISIT_ID@' AND dbo.TREATMENT_AKOMODASI.NO_REGISTRATION='@NO_REGISTRATION@' AND dbo.TREATMENT_AKOMODASI.TRANS_ID='@TRANS_ID@' AND dbo.TREATMENT_AKOMODASI.THENAME='@THENAME@'";
    }

    // Master filter
    public function sqlMasterFilter_TREATMENT_BILL()
    {
        return "[BILL_ID]='@BILL_ID@' AND [VISIT_ID]='@VISIT_ID@' AND [NO_REGISTRATION]='@NO_REGISTRATION@' AND [TRANS_ID]='@TRANS_ID@'";
    }
    // Detail filter
    public function sqlDetailFilter_TREATMENT_BILL()
    {
        return "dbo.TREATMENT_AKOMODASI.BILL_ID='@BILL_ID@' AND dbo.TREATMENT_AKOMODASI.VISIT_ID='@VISIT_ID@' AND dbo.TREATMENT_AKOMODASI.NO_REGISTRATION='@NO_REGISTRATION@' AND dbo.TREATMENT_AKOMODASI.TRANS_ID='@TRANS_ID@'";
    }

    // Table level SQL
    public function getSqlFrom() // From
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "dbo.TREATMENT_AKOMODASI";
    }

    public function sqlFrom() // For backward compatibility
    {
        return $this->getSqlFrom();
    }

    public function setSqlFrom($v)
    {
        $this->SqlFrom = $v;
    }

    public function getSqlSelect() // Select
    {
        return $this->SqlSelect ?? $this->getQueryBuilder()->select("dbo.TREATMENT_AKOMODASI.ID, dbo.TREATMENT_AKOMODASI.BILL_ID, dbo.TREATMENT_AKOMODASI.NO_REGISTRATION, dbo.TREATMENT_AKOMODASI.VISIT_ID, dbo.TREATMENT_AKOMODASI.TRANS_ID, dbo.TREATMENT_AKOMODASI.TARIF_ID, dbo.TREATMENT_AKOMODASI.CLASS_ID, dbo.TREATMENT_AKOMODASI.CLINIC_ID, dbo.TREATMENT_AKOMODASI.CLINIC_ID_FROM, dbo.TREATMENT_AKOMODASI.TREATMENT, dbo.TREATMENT_AKOMODASI.TREAT_DATE, dbo.TREATMENT_AKOMODASI.QUANTITY, dbo.TREATMENT_AKOMODASI.MEASURE_ID, dbo.TREATMENT_AKOMODASI.DESCRIPTION, dbo.TREATMENT_AKOMODASI.CLASS_ROOM_ID, dbo.TREATMENT_AKOMODASI.KELUAR_ID, dbo.TREATMENT_AKOMODASI.BED_ID, dbo.TREATMENT_AKOMODASI.EMPLOYEE_ID, dbo.TREATMENT_AKOMODASI.DOCTOR, dbo.TREATMENT_AKOMODASI.EXIT_DATE, dbo.TREATMENT_AKOMODASI.EMPLOYEE_ID_FROM, dbo.TREATMENT_AKOMODASI.DOCTOR_FROM, dbo.TREATMENT_AKOMODASI.STATUS_PASIEN_ID, dbo.TREATMENT_AKOMODASI.THENAME, dbo.TREATMENT_AKOMODASI.THEADDRESS, dbo.TREATMENT_AKOMODASI.THEID, dbo.TREATMENT_AKOMODASI.ISRJ, dbo.TREATMENT_AKOMODASI.AGEYEAR, dbo.TREATMENT_AKOMODASI.AGEMONTH, dbo.TREATMENT_AKOMODASI.AGEDAY, dbo.TREATMENT_AKOMODASI.GENDER, dbo.TREATMENT_AKOMODASI.KARYAWAN, dbo.TREATMENT_AKOMODASI.MODIFIED_BY, dbo.TREATMENT_AKOMODASI.MODIFIED_DATE, dbo.TREATMENT_AKOMODASI.MODIFIED_FROM");
    }

    public function sqlSelect() // For backward compatibility
    {
        return $this->getSqlSelect();
    }

    public function setSqlSelect($v)
    {
        $this->SqlSelect = $v;
    }

    public function getSqlWhere() // Where
    {
        $where = ($this->SqlWhere != "") ? $this->SqlWhere : "";
        $this->DefaultFilter = "";
        AddFilter($where, $this->DefaultFilter);
        return $where;
    }

    public function sqlWhere() // For backward compatibility
    {
        return $this->getSqlWhere();
    }

    public function setSqlWhere($v)
    {
        $this->SqlWhere = $v;
    }

    public function getSqlGroupBy() // Group By
    {
        return ($this->SqlGroupBy != "") ? $this->SqlGroupBy : "";
    }

    public function sqlGroupBy() // For backward compatibility
    {
        return $this->getSqlGroupBy();
    }

    public function setSqlGroupBy($v)
    {
        $this->SqlGroupBy = $v;
    }

    public function getSqlHaving() // Having
    {
        return ($this->SqlHaving != "") ? $this->SqlHaving : "";
    }

    public function sqlHaving() // For backward compatibility
    {
        return $this->getSqlHaving();
    }

    public function setSqlHaving($v)
    {
        $this->SqlHaving = $v;
    }

    public function getSqlOrderBy() // Order By
    {
        return ($this->SqlOrderBy != "") ? $this->SqlOrderBy : $this->DefaultSort;
    }

    public function sqlOrderBy() // For backward compatibility
    {
        return $this->getSqlOrderBy();
    }

    public function setSqlOrderBy($v)
    {
        $this->SqlOrderBy = $v;
    }

    // Apply User ID filters
    public function applyUserIDFilters($filter)
    {
        return $filter;
    }

    // Check if User ID security allows view all
    public function userIDAllow($id = "")
    {
        $allow = $this->UserIDAllowSecurity;
        switch ($id) {
            case "add":
            case "copy":
            case "gridadd":
            case "register":
            case "addopt":
                return (($allow & 1) == 1);
            case "edit":
            case "gridedit":
            case "update":
            case "changepassword":
            case "resetpassword":
                return (($allow & 4) == 4);
            case "delete":
                return (($allow & 2) == 2);
            case "view":
                return (($allow & 32) == 32);
            case "search":
                return (($allow & 64) == 64);
            default:
                return (($allow & 8) == 8);
        }
    }

    /**
     * Get record count
     *
     * @param string|QueryBuilder $sql SQL or QueryBuilder
     * @param mixed $c Connection
     * @return int
     */
    public function getRecordCount($sql, $c = null)
    {
        $cnt = -1;
        $rs = null;
        if ($sql instanceof \Doctrine\DBAL\Query\QueryBuilder) { // Query builder
            $sqlwrk = clone $sql;
            $sqlwrk = $sqlwrk->resetQueryPart("orderBy")->getSQL();
        } else {
            $sqlwrk = $sql;
        }
        $pattern = '/^SELECT\s([\s\S]+)\sFROM\s/i';
        // Skip Custom View / SubQuery / SELECT DISTINCT / ORDER BY
        if (
            ($this->TableType == 'TABLE' || $this->TableType == 'VIEW' || $this->TableType == 'LINKTABLE') &&
            preg_match($pattern, $sqlwrk) && !preg_match('/\(\s*(SELECT[^)]+)\)/i', $sqlwrk) &&
            !preg_match('/^\s*select\s+distinct\s+/i', $sqlwrk) && !preg_match('/\s+order\s+by\s+/i', $sqlwrk)
        ) {
            $sqlwrk = "SELECT COUNT(*) FROM " . preg_replace($pattern, "", $sqlwrk);
        } else {
            $sqlwrk = "SELECT COUNT(*) FROM (" . $sqlwrk . ") COUNT_TABLE";
        }
        $conn = $c ?? $this->getConnection();
        $rs = $conn->executeQuery($sqlwrk);
        $cnt = $rs->fetchColumn();
        if ($cnt !== false) {
            return (int)$cnt;
        }

        // Unable to get count by SELECT COUNT(*), execute the SQL to get record count directly
        return ExecuteRecordCount($sql, $conn);
    }

    // Get SQL
    public function getSql($where, $orderBy = "")
    {
        return $this->buildSelectSql(
            $this->getSqlSelect(),
            $this->getSqlFrom(),
            $this->getSqlWhere(),
            $this->getSqlGroupBy(),
            $this->getSqlHaving(),
            $this->getSqlOrderBy(),
            $where,
            $orderBy
        )->getSQL();
    }

    // Table SQL
    public function getCurrentSql()
    {
        $filter = $this->CurrentFilter;
        $filter = $this->applyUserIDFilters($filter);
        $sort = $this->getSessionOrderBy();
        return $this->getSql($filter, $sort);
    }

    /**
     * Table SQL with List page filter
     *
     * @return QueryBuilder
     */
    public function getListSql()
    {
        $filter = $this->UseSessionForListSql ? $this->getSessionWhere() : "";
        AddFilter($filter, $this->CurrentFilter);
        $filter = $this->applyUserIDFilters($filter);
        $this->recordsetSelecting($filter);
        $select = $this->getSqlSelect();
        $from = $this->getSqlFrom();
        $sort = $this->UseSessionForListSql ? $this->getSessionOrderBy() : "";
        $this->Sort = $sort;
        return $this->buildSelectSql(
            $select,
            $from,
            $this->getSqlWhere(),
            $this->getSqlGroupBy(),
            $this->getSqlHaving(),
            $this->getSqlOrderBy(),
            $filter,
            $sort
        );
    }

    // Get ORDER BY clause
    public function getOrderBy()
    {
        $orderBy = $this->getSqlOrderBy();
        $sort = $this->getSessionOrderBy();
        if ($orderBy != "" && $sort != "") {
            $orderBy .= ", " . $sort;
        } elseif ($sort != "") {
            $orderBy = $sort;
        }
        return $orderBy;
    }

    // Get record count based on filter (for detail record count in master table pages)
    public function loadRecordCount($filter)
    {
        $origFilter = $this->CurrentFilter;
        $this->CurrentFilter = $filter;
        $this->recordsetSelecting($this->CurrentFilter);
        $select = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlSelect() : $this->getQueryBuilder()->select("*");
        $groupBy = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlGroupBy() : "";
        $having = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlHaving() : "";
        $sql = $this->buildSelectSql($select, $this->getSqlFrom(), $this->getSqlWhere(), $groupBy, $having, "", $this->CurrentFilter, "");
        $cnt = $this->getRecordCount($sql);
        $this->CurrentFilter = $origFilter;
        return $cnt;
    }

    // Get record count (for current List page)
    public function listRecordCount()
    {
        $filter = $this->getSessionWhere();
        AddFilter($filter, $this->CurrentFilter);
        $filter = $this->applyUserIDFilters($filter);
        $this->recordsetSelecting($filter);
        $select = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlSelect() : $this->getQueryBuilder()->select("*");
        $groupBy = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlGroupBy() : "";
        $having = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlHaving() : "";
        $sql = $this->buildSelectSql($select, $this->getSqlFrom(), $this->getSqlWhere(), $groupBy, $having, "", $filter, "");
        $cnt = $this->getRecordCount($sql);
        return $cnt;
    }

    /**
     * INSERT statement
     *
     * @param mixed $rs
     * @return QueryBuilder
     */
    protected function insertSql(&$rs)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->insert($this->UpdateTable);
        foreach ($rs as $name => $value) {
            if (!isset($this->Fields[$name]) || $this->Fields[$name]->IsCustom) {
                continue;
            }
            $type = GetParameterType($this->Fields[$name], $value, $this->Dbid);
            $queryBuilder->setValue($this->Fields[$name]->Expression, $queryBuilder->createPositionalParameter($value, $type));
        }
        return $queryBuilder;
    }

    // Insert
    public function insert(&$rs)
    {
        $conn = $this->getConnection();
        $success = $this->insertSql($rs)->execute();
        if ($success) {
            // Get insert id if necessary
            $this->ID->setDbValue($conn->lastInsertId());
            $rs['ID'] = $this->ID->DbValue;
        }
        return $success;
    }

    /**
     * UPDATE statement
     *
     * @param array $rs Data to be updated
     * @param string|array $where WHERE clause
     * @param string $curfilter Filter
     * @return QueryBuilder
     */
    protected function updateSql(&$rs, $where = "", $curfilter = true)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->update($this->UpdateTable);
        foreach ($rs as $name => $value) {
            if (!isset($this->Fields[$name]) || $this->Fields[$name]->IsCustom || $this->Fields[$name]->IsAutoIncrement) {
                continue;
            }
            $type = GetParameterType($this->Fields[$name], $value, $this->Dbid);
            $queryBuilder->set($this->Fields[$name]->Expression, $queryBuilder->createPositionalParameter($value, $type));
        }
        $filter = ($curfilter) ? $this->CurrentFilter : "";
        if (is_array($where)) {
            $where = $this->arrayToFilter($where);
        }
        AddFilter($filter, $where);
        if ($filter != "") {
            $queryBuilder->where($filter);
        }
        return $queryBuilder;
    }

    // Update
    public function update(&$rs, $where = "", $rsold = null, $curfilter = true)
    {
        // If no field is updated, execute may return 0. Treat as success
        $success = $this->updateSql($rs, $where, $curfilter)->execute();
        $success = ($success > 0) ? $success : true;
        return $success;
    }

    /**
     * DELETE statement
     *
     * @param array $rs Key values
     * @param string|array $where WHERE clause
     * @param string $curfilter Filter
     * @return QueryBuilder
     */
    protected function deleteSql(&$rs, $where = "", $curfilter = true)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->delete($this->UpdateTable);
        if (is_array($where)) {
            $where = $this->arrayToFilter($where);
        }
        if ($rs) {
            if (array_key_exists('ID', $rs)) {
                AddFilter($where, QuotedName('ID', $this->Dbid) . '=' . QuotedValue($rs['ID'], $this->ID->DataType, $this->Dbid));
            }
        }
        $filter = ($curfilter) ? $this->CurrentFilter : "";
        AddFilter($filter, $where);
        return $queryBuilder->where($filter != "" ? $filter : "0=1");
    }

    // Delete
    public function delete(&$rs, $where = "", $curfilter = false)
    {
        $success = true;
        if ($success) {
            $success = $this->deleteSql($rs, $where, $curfilter)->execute();
        }
        return $success;
    }

    // Load DbValue from recordset or array
    protected function loadDbValues($row)
    {
        if (!is_array($row)) {
            return;
        }
        $this->ID->DbValue = $row['ID'];
        $this->BILL_ID->DbValue = $row['BILL_ID'];
        $this->NO_REGISTRATION->DbValue = $row['NO_REGISTRATION'];
        $this->VISIT_ID->DbValue = $row['VISIT_ID'];
        $this->TRANS_ID->DbValue = $row['TRANS_ID'];
        $this->TARIF_ID->DbValue = $row['TARIF_ID'];
        $this->CLASS_ID->DbValue = $row['CLASS_ID'];
        $this->CLINIC_ID->DbValue = $row['CLINIC_ID'];
        $this->CLINIC_ID_FROM->DbValue = $row['CLINIC_ID_FROM'];
        $this->TREATMENT->DbValue = $row['TREATMENT'];
        $this->TREAT_DATE->DbValue = $row['TREAT_DATE'];
        $this->QUANTITY->DbValue = $row['QUANTITY'];
        $this->MEASURE_ID->DbValue = $row['MEASURE_ID'];
        $this->DESCRIPTION->DbValue = $row['DESCRIPTION'];
        $this->CLASS_ROOM_ID->DbValue = $row['CLASS_ROOM_ID'];
        $this->KELUAR_ID->DbValue = $row['KELUAR_ID'];
        $this->BED_ID->DbValue = $row['BED_ID'];
        $this->EMPLOYEE_ID->DbValue = $row['EMPLOYEE_ID'];
        $this->DOCTOR->DbValue = $row['DOCTOR'];
        $this->EXIT_DATE->DbValue = $row['EXIT_DATE'];
        $this->EMPLOYEE_ID_FROM->DbValue = $row['EMPLOYEE_ID_FROM'];
        $this->DOCTOR_FROM->DbValue = $row['DOCTOR_FROM'];
        $this->STATUS_PASIEN_ID->DbValue = $row['STATUS_PASIEN_ID'];
        $this->THENAME->DbValue = $row['THENAME'];
        $this->THEADDRESS->DbValue = $row['THEADDRESS'];
        $this->THEID->DbValue = $row['THEID'];
        $this->ISRJ->DbValue = $row['ISRJ'];
        $this->AGEYEAR->DbValue = $row['AGEYEAR'];
        $this->AGEMONTH->DbValue = $row['AGEMONTH'];
        $this->AGEDAY->DbValue = $row['AGEDAY'];
        $this->GENDER->DbValue = $row['GENDER'];
        $this->KARYAWAN->DbValue = $row['KARYAWAN'];
        $this->MODIFIED_BY->DbValue = $row['MODIFIED_BY'];
        $this->MODIFIED_DATE->DbValue = $row['MODIFIED_DATE'];
        $this->MODIFIED_FROM->DbValue = $row['MODIFIED_FROM'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "dbo.TREATMENT_AKOMODASI.ID = @ID@";
    }

    // Get Key
    public function getKey($current = false)
    {
        $keys = [];
        $val = $current ? $this->ID->CurrentValue : $this->ID->OldValue;
        if (EmptyValue($val)) {
            return "";
        } else {
            $keys[] = $val;
        }
        return implode(Config("COMPOSITE_KEY_SEPARATOR"), $keys);
    }

    // Set Key
    public function setKey($key, $current = false)
    {
        $this->OldKey = strval($key);
        $keys = explode(Config("COMPOSITE_KEY_SEPARATOR"), $this->OldKey);
        if (count($keys) == 1) {
            if ($current) {
                $this->ID->CurrentValue = $keys[0];
            } else {
                $this->ID->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('ID', $row) ? $row['ID'] : null;
        } else {
            $val = $this->ID->OldValue !== null ? $this->ID->OldValue : $this->ID->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@ID@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
        }
        return $keyFilter;
    }

    // Return page URL
    public function getReturnUrl()
    {
        $referUrl = ReferUrl();
        $referPageName = ReferPageName();
        $name = PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_RETURN_URL");
        // Get referer URL automatically
        if ($referUrl != "" && $referPageName != CurrentPageName() && $referPageName != "login") { // Referer not same page or login page
            $_SESSION[$name] = $referUrl; // Save to Session
        }
        return $_SESSION[$name] ?? GetUrl("VAkomodasiKamarList");
    }

    // Set return page URL
    public function setReturnUrl($v)
    {
        $_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_RETURN_URL")] = $v;
    }

    // Get modal caption
    public function getModalCaption($pageName)
    {
        global $Language;
        if ($pageName == "VAkomodasiKamarView") {
            return $Language->phrase("View");
        } elseif ($pageName == "VAkomodasiKamarEdit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "VAkomodasiKamarAdd") {
            return $Language->phrase("Add");
        } else {
            return "";
        }
    }

    // API page name
    public function getApiPageName($action)
    {
        switch (strtolower($action)) {
            case Config("API_VIEW_ACTION"):
                return "VAkomodasiKamarView";
            case Config("API_ADD_ACTION"):
                return "VAkomodasiKamarAdd";
            case Config("API_EDIT_ACTION"):
                return "VAkomodasiKamarEdit";
            case Config("API_DELETE_ACTION"):
                return "VAkomodasiKamarDelete";
            case Config("API_LIST_ACTION"):
                return "VAkomodasiKamarList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "VAkomodasiKamarList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("VAkomodasiKamarView", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("VAkomodasiKamarView", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "VAkomodasiKamarAdd?" . $this->getUrlParm($parm);
        } else {
            $url = "VAkomodasiKamarAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("VAkomodasiKamarEdit", $this->getUrlParm($parm));
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl(CurrentPageName(), $this->getUrlParm("action=edit"));
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        $url = $this->keyUrl("VAkomodasiKamarAdd", $this->getUrlParm($parm));
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl(CurrentPageName(), $this->getUrlParm("action=copy"));
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl()
    {
        return $this->keyUrl("VAkomodasiKamarDelete", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
        if ($this->getCurrentMasterTable() == "PASIEN_VISITATION" && !ContainsString($url, Config("TABLE_SHOW_MASTER") . "=")) {
            $url .= (ContainsString($url, "?") ? "&" : "?") . Config("TABLE_SHOW_MASTER") . "=" . $this->getCurrentMasterTable();
            $url .= "&" . GetForeignKeyUrl("fk_VISIT_ID", $this->VISIT_ID->CurrentValue ?? $this->VISIT_ID->getSessionValue());
            $url .= "&" . GetForeignKeyUrl("fk_NO_REGISTRATION", $this->NO_REGISTRATION->CurrentValue ?? $this->NO_REGISTRATION->getSessionValue());
            $url .= "&" . GetForeignKeyUrl("fk_TRANS_ID", $this->TRANS_ID->CurrentValue ?? $this->TRANS_ID->getSessionValue());
            $url .= "&" . GetForeignKeyUrl("fk_DIANTAR_OLEH", $this->THENAME->CurrentValue ?? $this->THENAME->getSessionValue());
        }
        if ($this->getCurrentMasterTable() == "TREATMENT_BILL" && !ContainsString($url, Config("TABLE_SHOW_MASTER") . "=")) {
            $url .= (ContainsString($url, "?") ? "&" : "?") . Config("TABLE_SHOW_MASTER") . "=" . $this->getCurrentMasterTable();
            $url .= "&" . GetForeignKeyUrl("fk_BILL_ID", $this->BILL_ID->CurrentValue ?? $this->BILL_ID->getSessionValue());
            $url .= "&" . GetForeignKeyUrl("fk_VISIT_ID", $this->VISIT_ID->CurrentValue ?? $this->VISIT_ID->getSessionValue());
            $url .= "&" . GetForeignKeyUrl("fk_NO_REGISTRATION", $this->NO_REGISTRATION->CurrentValue ?? $this->NO_REGISTRATION->getSessionValue());
            $url .= "&" . GetForeignKeyUrl("fk_TRANS_ID", $this->TRANS_ID->CurrentValue ?? $this->TRANS_ID->getSessionValue());
        }
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json .= "ID:" . JsonEncode($this->ID->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->ID->CurrentValue !== null) {
            $url .= "/" . rawurlencode($this->ID->CurrentValue);
        } else {
            return "javascript:ew.alert(ew.language.phrase('InvalidRecord'));";
        }
        if ($parm != "") {
            $url .= "?" . $parm;
        }
        return $url;
    }

    // Render sort
    public function renderSort($fld)
    {
        $classId = $fld->TableVar . "_" . $fld->Param;
        $scriptId = str_replace("%id%", $classId, "tpc_%id%");
        $scriptStart = $this->UseCustomTemplate ? "<template id=\"" . $scriptId . "\">" : "";
        $scriptEnd = $this->UseCustomTemplate ? "</template>" : "";
        $jsSort = " class=\"ew-pointer\" onclick=\"ew.sort(event, '" . $this->sortUrl($fld) . "', 1);\"";
        if ($this->sortUrl($fld) == "") {
            $html = <<<NOSORTHTML
{$scriptStart}<div class="ew-table-header-caption">{$fld->caption()}</div>{$scriptEnd}
NOSORTHTML;
        } else {
            if ($fld->getSort() == "ASC") {
                $sortIcon = '<i class="fas fa-sort-up"></i>';
            } elseif ($fld->getSort() == "DESC") {
                $sortIcon = '<i class="fas fa-sort-down"></i>';
            } else {
                $sortIcon = '';
            }
            $html = <<<SORTHTML
{$scriptStart}<div{$jsSort}><div class="ew-table-header-btn"><span class="ew-table-header-caption">{$fld->caption()}</span><span class="ew-table-header-sort">{$sortIcon}</span></div></div>{$scriptEnd}
SORTHTML;
        }
        return $html;
    }

    // Sort URL
    public function sortUrl($fld)
    {
        if (
            $this->CurrentAction || $this->isExport() ||
            in_array($fld->Type, [141, 201, 203, 128, 204, 205])
        ) { // Unsortable data type
                return "";
        } elseif ($fld->Sortable) {
            $urlParm = $this->getUrlParm("order=" . urlencode($fld->Name) . "&amp;ordertype=" . $fld->getNextSort());
            return $this->addMasterUrl(CurrentPageName() . "?" . $urlParm);
        } else {
            return "";
        }
    }

    // Get record keys from Post/Get/Session
    public function getRecordKeys()
    {
        $arKeys = [];
        $arKey = [];
        if (Param("key_m") !== null) {
            $arKeys = Param("key_m");
            $cnt = count($arKeys);
        } else {
            if (($keyValue = Param("ID") ?? Route("ID")) !== null) {
                $arKeys[] = $keyValue;
            } elseif (IsApi() && (($keyValue = Key(0) ?? Route(2)) !== null)) {
                $arKeys[] = $keyValue;
            } else {
                $arKeys = null; // Do not setup
            }

            //return $arKeys; // Do not return yet, so the values will also be checked by the following code
        }
        // Check keys
        $ar = [];
        if (is_array($arKeys)) {
            foreach ($arKeys as $key) {
                if (!is_numeric($key)) {
                    continue;
                }
                $ar[] = $key;
            }
        }
        return $ar;
    }

    // Get filter from record keys
    public function getFilterFromRecordKeys($setCurrent = true)
    {
        $arKeys = $this->getRecordKeys();
        $keyFilter = "";
        foreach ($arKeys as $key) {
            if ($keyFilter != "") {
                $keyFilter .= " OR ";
            }
            if ($setCurrent) {
                $this->ID->CurrentValue = $key;
            } else {
                $this->ID->OldValue = $key;
            }
            $keyFilter .= "(" . $this->getRecordFilter() . ")";
        }
        return $keyFilter;
    }

    // Load recordset based on filter
    public function &loadRs($filter)
    {
        $sql = $this->getSql($filter); // Set up filter (WHERE Clause)
        $conn = $this->getConnection();
        $stmt = $conn->executeQuery($sql);
        return $stmt;
    }

    // Load row values from record
    public function loadListRowValues(&$rs)
    {
        if (is_array($rs)) {
            $row = $rs;
        } elseif ($rs && property_exists($rs, "fields")) { // Recordset
            $row = $rs->fields;
        } else {
            return;
        }
        $this->ID->setDbValue($row['ID']);
        $this->BILL_ID->setDbValue($row['BILL_ID']);
        $this->NO_REGISTRATION->setDbValue($row['NO_REGISTRATION']);
        $this->VISIT_ID->setDbValue($row['VISIT_ID']);
        $this->TRANS_ID->setDbValue($row['TRANS_ID']);
        $this->TARIF_ID->setDbValue($row['TARIF_ID']);
        $this->CLASS_ID->setDbValue($row['CLASS_ID']);
        $this->CLINIC_ID->setDbValue($row['CLINIC_ID']);
        $this->CLINIC_ID_FROM->setDbValue($row['CLINIC_ID_FROM']);
        $this->TREATMENT->setDbValue($row['TREATMENT']);
        $this->TREAT_DATE->setDbValue($row['TREAT_DATE']);
        $this->QUANTITY->setDbValue($row['QUANTITY']);
        $this->MEASURE_ID->setDbValue($row['MEASURE_ID']);
        $this->DESCRIPTION->setDbValue($row['DESCRIPTION']);
        $this->CLASS_ROOM_ID->setDbValue($row['CLASS_ROOM_ID']);
        $this->KELUAR_ID->setDbValue($row['KELUAR_ID']);
        $this->BED_ID->setDbValue($row['BED_ID']);
        $this->EMPLOYEE_ID->setDbValue($row['EMPLOYEE_ID']);
        $this->DOCTOR->setDbValue($row['DOCTOR']);
        $this->EXIT_DATE->setDbValue($row['EXIT_DATE']);
        $this->EMPLOYEE_ID_FROM->setDbValue($row['EMPLOYEE_ID_FROM']);
        $this->DOCTOR_FROM->setDbValue($row['DOCTOR_FROM']);
        $this->STATUS_PASIEN_ID->setDbValue($row['STATUS_PASIEN_ID']);
        $this->THENAME->setDbValue($row['THENAME']);
        $this->THEADDRESS->setDbValue($row['THEADDRESS']);
        $this->THEID->setDbValue($row['THEID']);
        $this->ISRJ->setDbValue($row['ISRJ']);
        $this->AGEYEAR->setDbValue($row['AGEYEAR']);
        $this->AGEMONTH->setDbValue($row['AGEMONTH']);
        $this->AGEDAY->setDbValue($row['AGEDAY']);
        $this->GENDER->setDbValue($row['GENDER']);
        $this->KARYAWAN->setDbValue($row['KARYAWAN']);
        $this->MODIFIED_BY->setDbValue($row['MODIFIED_BY']);
        $this->MODIFIED_DATE->setDbValue($row['MODIFIED_DATE']);
        $this->MODIFIED_FROM->setDbValue($row['MODIFIED_FROM']);
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // ID

        // BILL_ID

        // NO_REGISTRATION

        // VISIT_ID

        // TRANS_ID

        // TARIF_ID

        // CLASS_ID

        // CLINIC_ID

        // CLINIC_ID_FROM

        // TREATMENT

        // TREAT_DATE

        // QUANTITY

        // MEASURE_ID

        // DESCRIPTION

        // CLASS_ROOM_ID

        // KELUAR_ID

        // BED_ID

        // EMPLOYEE_ID

        // DOCTOR

        // EXIT_DATE

        // EMPLOYEE_ID_FROM

        // DOCTOR_FROM

        // STATUS_PASIEN_ID

        // THENAME

        // THEADDRESS

        // THEID

        // ISRJ

        // AGEYEAR

        // AGEMONTH

        // AGEDAY

        // GENDER

        // KARYAWAN

        // MODIFIED_BY

        // MODIFIED_DATE

        // MODIFIED_FROM

        // ID
        $this->ID->ViewValue = $this->ID->CurrentValue;
        $this->ID->ViewCustomAttributes = "";

        // BILL_ID
        $this->BILL_ID->ViewValue = $this->BILL_ID->CurrentValue;
        $this->BILL_ID->ViewCustomAttributes = "";

        // NO_REGISTRATION
        $this->NO_REGISTRATION->ViewValue = $this->NO_REGISTRATION->CurrentValue;
        $this->NO_REGISTRATION->ViewCustomAttributes = "";

        // VISIT_ID
        $this->VISIT_ID->ViewValue = $this->VISIT_ID->CurrentValue;
        $this->VISIT_ID->ViewCustomAttributes = "";

        // TRANS_ID
        $this->TRANS_ID->ViewValue = $this->TRANS_ID->CurrentValue;
        $this->TRANS_ID->ViewCustomAttributes = "";

        // TARIF_ID
        $curVal = trim(strval($this->TARIF_ID->CurrentValue));
        if ($curVal != "") {
            $this->TARIF_ID->ViewValue = $this->TARIF_ID->lookupCacheOption($curVal);
            if ($this->TARIF_ID->ViewValue === null) { // Lookup from database
                $filterWrk = "[TARIF_ID]" . SearchString("=", $curVal, DATATYPE_STRING, "");
                $lookupFilter = function() {
                    return "[TREAT_ID] = 010001";
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
        $curVal = trim(strval($this->CLINIC_ID_FROM->CurrentValue));
        if ($curVal != "") {
            $this->CLINIC_ID_FROM->ViewValue = $this->CLINIC_ID_FROM->lookupCacheOption($curVal);
            if ($this->CLINIC_ID_FROM->ViewValue === null) { // Lookup from database
                $filterWrk = "[CLINIC_ID]" . SearchString("=", $curVal, DATATYPE_STRING, "");
                $lookupFilter = function() {
                    return "[STYPE_ID] = 0";
                };
                $lookupFilter = $lookupFilter->bindTo($this);
                $sqlWrk = $this->CLINIC_ID_FROM->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->CLINIC_ID_FROM->Lookup->renderViewRow($rswrk[0]);
                    $this->CLINIC_ID_FROM->ViewValue = $this->CLINIC_ID_FROM->displayValue($arwrk);
                } else {
                    $this->CLINIC_ID_FROM->ViewValue = $this->CLINIC_ID_FROM->CurrentValue;
                }
            }
        } else {
            $this->CLINIC_ID_FROM->ViewValue = null;
        }
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
        $this->QUANTITY->ViewValue = FormatNumber($this->QUANTITY->ViewValue, 2, -2, -2, -2);
        $this->QUANTITY->ViewCustomAttributes = "";

        // MEASURE_ID
        $this->MEASURE_ID->ViewValue = $this->MEASURE_ID->CurrentValue;
        $this->MEASURE_ID->ViewValue = FormatNumber($this->MEASURE_ID->ViewValue, 0, -2, -2, -2);
        $this->MEASURE_ID->ViewCustomAttributes = "";

        // DESCRIPTION
        $this->DESCRIPTION->ViewValue = $this->DESCRIPTION->CurrentValue;
        $this->DESCRIPTION->ViewCustomAttributes = "";

        // CLASS_ROOM_ID
        $curVal = trim(strval($this->CLASS_ROOM_ID->CurrentValue));
        if ($curVal != "") {
            $this->CLASS_ROOM_ID->ViewValue = $this->CLASS_ROOM_ID->lookupCacheOption($curVal);
            if ($this->CLASS_ROOM_ID->ViewValue === null) { // Lookup from database
                $filterWrk = "[CLASS_ROOM_ID]" . SearchString("=", $curVal, DATATYPE_STRING, "");
                $sqlWrk = $this->CLASS_ROOM_ID->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->CLASS_ROOM_ID->Lookup->renderViewRow($rswrk[0]);
                    $this->CLASS_ROOM_ID->ViewValue = $this->CLASS_ROOM_ID->displayValue($arwrk);
                } else {
                    $this->CLASS_ROOM_ID->ViewValue = $this->CLASS_ROOM_ID->CurrentValue;
                }
            }
        } else {
            $this->CLASS_ROOM_ID->ViewValue = null;
        }
        $this->CLASS_ROOM_ID->ViewCustomAttributes = "";

        // KELUAR_ID
        $curVal = trim(strval($this->KELUAR_ID->CurrentValue));
        if ($curVal != "") {
            $this->KELUAR_ID->ViewValue = $this->KELUAR_ID->lookupCacheOption($curVal);
            if ($this->KELUAR_ID->ViewValue === null) { // Lookup from database
                $filterWrk = "[KELUAR_ID]" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->KELUAR_ID->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->KELUAR_ID->Lookup->renderViewRow($rswrk[0]);
                    $this->KELUAR_ID->ViewValue = $this->KELUAR_ID->displayValue($arwrk);
                } else {
                    $this->KELUAR_ID->ViewValue = $this->KELUAR_ID->CurrentValue;
                }
            }
        } else {
            $this->KELUAR_ID->ViewValue = null;
        }
        $this->KELUAR_ID->ViewCustomAttributes = "";

        // BED_ID
        $curVal = trim(strval($this->BED_ID->CurrentValue));
        if ($curVal != "") {
            $this->BED_ID->ViewValue = $this->BED_ID->lookupCacheOption($curVal);
            if ($this->BED_ID->ViewValue === null) { // Lookup from database
                $filterWrk = "[BED_ID]" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->BED_ID->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->BED_ID->Lookup->renderViewRow($rswrk[0]);
                    $this->BED_ID->ViewValue = $this->BED_ID->displayValue($arwrk);
                } else {
                    $this->BED_ID->ViewValue = $this->BED_ID->CurrentValue;
                }
            }
        } else {
            $this->BED_ID->ViewValue = null;
        }
        $this->BED_ID->ViewCustomAttributes = "";

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

        // DOCTOR
        $this->DOCTOR->ViewValue = $this->DOCTOR->CurrentValue;
        $this->DOCTOR->ViewCustomAttributes = "";

        // EXIT_DATE
        $this->EXIT_DATE->ViewValue = $this->EXIT_DATE->CurrentValue;
        $this->EXIT_DATE->ViewValue = FormatDateTime($this->EXIT_DATE->ViewValue, 11);
        $this->EXIT_DATE->ViewCustomAttributes = "";

        // EMPLOYEE_ID_FROM
        $this->EMPLOYEE_ID_FROM->ViewValue = $this->EMPLOYEE_ID_FROM->CurrentValue;
        $this->EMPLOYEE_ID_FROM->ViewCustomAttributes = "";

        // DOCTOR_FROM
        $this->DOCTOR_FROM->ViewValue = $this->DOCTOR_FROM->CurrentValue;
        $this->DOCTOR_FROM->ViewCustomAttributes = "";

        // STATUS_PASIEN_ID
        $this->STATUS_PASIEN_ID->ViewValue = $this->STATUS_PASIEN_ID->CurrentValue;
        $this->STATUS_PASIEN_ID->ViewValue = FormatNumber($this->STATUS_PASIEN_ID->ViewValue, 0, -2, -2, -2);
        $this->STATUS_PASIEN_ID->ViewCustomAttributes = "";

        // THENAME
        $this->THENAME->ViewValue = $this->THENAME->CurrentValue;
        $this->THENAME->ViewCustomAttributes = "";

        // THEADDRESS
        $this->THEADDRESS->ViewValue = $this->THEADDRESS->CurrentValue;
        $this->THEADDRESS->ViewCustomAttributes = "";

        // THEID
        $this->THEID->ViewValue = $this->THEID->CurrentValue;
        $this->THEID->ViewCustomAttributes = "";

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

        // ID
        $this->ID->LinkCustomAttributes = "";
        $this->ID->HrefValue = "";
        $this->ID->TooltipValue = "";

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

        // TRANS_ID
        $this->TRANS_ID->LinkCustomAttributes = "";
        $this->TRANS_ID->HrefValue = "";
        $this->TRANS_ID->TooltipValue = "";

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

        // STATUS_PASIEN_ID
        $this->STATUS_PASIEN_ID->LinkCustomAttributes = "";
        $this->STATUS_PASIEN_ID->HrefValue = "";
        $this->STATUS_PASIEN_ID->TooltipValue = "";

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

        // Call Row Rendered event
        $this->rowRendered();

        // Save data for Custom Template
        $this->Rows[] = $this->customTemplateFieldValues();
    }

    // Render edit row values
    public function renderEditRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // ID
        $this->ID->EditAttrs["class"] = "form-control";
        $this->ID->EditCustomAttributes = "";
        $this->ID->EditValue = $this->ID->CurrentValue;
        $this->ID->ViewCustomAttributes = "";

        // BILL_ID
        $this->BILL_ID->EditAttrs["class"] = "form-control";
        $this->BILL_ID->EditCustomAttributes = "";
        if ($this->BILL_ID->getSessionValue() != "") {
            $this->BILL_ID->CurrentValue = GetForeignKeyValue($this->BILL_ID->getSessionValue());
            $this->BILL_ID->ViewValue = $this->BILL_ID->CurrentValue;
            $this->BILL_ID->ViewCustomAttributes = "";
        } else {
            if (!$this->BILL_ID->Raw) {
                $this->BILL_ID->CurrentValue = HtmlDecode($this->BILL_ID->CurrentValue);
            }
            $this->BILL_ID->EditValue = $this->BILL_ID->CurrentValue;
            $this->BILL_ID->PlaceHolder = RemoveHtml($this->BILL_ID->caption());
        }

        // NO_REGISTRATION
        $this->NO_REGISTRATION->EditAttrs["class"] = "form-control";
        $this->NO_REGISTRATION->EditCustomAttributes = "";
        if ($this->NO_REGISTRATION->getSessionValue() != "") {
            $this->NO_REGISTRATION->CurrentValue = GetForeignKeyValue($this->NO_REGISTRATION->getSessionValue());
            $this->NO_REGISTRATION->ViewValue = $this->NO_REGISTRATION->CurrentValue;
            $this->NO_REGISTRATION->ViewCustomAttributes = "";
        } else {
            if (!$this->NO_REGISTRATION->Raw) {
                $this->NO_REGISTRATION->CurrentValue = HtmlDecode($this->NO_REGISTRATION->CurrentValue);
            }
            $this->NO_REGISTRATION->EditValue = $this->NO_REGISTRATION->CurrentValue;
            $this->NO_REGISTRATION->PlaceHolder = RemoveHtml($this->NO_REGISTRATION->caption());
        }

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
            $this->VISIT_ID->EditValue = $this->VISIT_ID->CurrentValue;
            $this->VISIT_ID->PlaceHolder = RemoveHtml($this->VISIT_ID->caption());
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
            $this->TRANS_ID->EditValue = $this->TRANS_ID->CurrentValue;
            $this->TRANS_ID->PlaceHolder = RemoveHtml($this->TRANS_ID->caption());
        }

        // TARIF_ID
        $this->TARIF_ID->EditAttrs["class"] = "form-control";
        $this->TARIF_ID->EditCustomAttributes = "";
        $this->TARIF_ID->PlaceHolder = RemoveHtml($this->TARIF_ID->caption());

        // CLASS_ID
        $this->CLASS_ID->EditAttrs["class"] = "form-control";
        $this->CLASS_ID->EditCustomAttributes = "";
        $this->CLASS_ID->EditValue = $this->CLASS_ID->CurrentValue;
        $this->CLASS_ID->PlaceHolder = RemoveHtml($this->CLASS_ID->caption());

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

        // CLINIC_ID_FROM
        $this->CLINIC_ID_FROM->EditAttrs["class"] = "form-control";
        $this->CLINIC_ID_FROM->EditCustomAttributes = "";
        $this->CLINIC_ID_FROM->PlaceHolder = RemoveHtml($this->CLINIC_ID_FROM->caption());

        // TREATMENT
        $this->TREATMENT->EditAttrs["class"] = "form-control";
        $this->TREATMENT->EditCustomAttributes = "";
        $this->TREATMENT->EditValue = $this->TREATMENT->CurrentValue;
        $this->TREATMENT->ViewCustomAttributes = "";

        // TREAT_DATE
        $this->TREAT_DATE->EditAttrs["class"] = "form-control";
        $this->TREAT_DATE->EditCustomAttributes = "";
        $this->TREAT_DATE->EditValue = $this->TREAT_DATE->CurrentValue;
        $this->TREAT_DATE->EditValue = FormatDateTime($this->TREAT_DATE->EditValue, 11);
        $this->TREAT_DATE->ViewCustomAttributes = "";

        // QUANTITY
        $this->QUANTITY->EditAttrs["class"] = "form-control";
        $this->QUANTITY->EditCustomAttributes = "";
        $this->QUANTITY->EditValue = $this->QUANTITY->CurrentValue;
        $this->QUANTITY->PlaceHolder = RemoveHtml($this->QUANTITY->caption());
        if (strval($this->QUANTITY->EditValue) != "" && is_numeric($this->QUANTITY->EditValue)) {
            $this->QUANTITY->EditValue = FormatNumber($this->QUANTITY->EditValue, -2, -2, -2, -2);
        }

        // MEASURE_ID
        $this->MEASURE_ID->EditAttrs["class"] = "form-control";
        $this->MEASURE_ID->EditCustomAttributes = "";
        $this->MEASURE_ID->EditValue = $this->MEASURE_ID->CurrentValue;
        $this->MEASURE_ID->PlaceHolder = RemoveHtml($this->MEASURE_ID->caption());

        // DESCRIPTION
        $this->DESCRIPTION->EditAttrs["class"] = "form-control";
        $this->DESCRIPTION->EditCustomAttributes = "";
        if (!$this->DESCRIPTION->Raw) {
            $this->DESCRIPTION->CurrentValue = HtmlDecode($this->DESCRIPTION->CurrentValue);
        }
        $this->DESCRIPTION->EditValue = $this->DESCRIPTION->CurrentValue;
        $this->DESCRIPTION->PlaceHolder = RemoveHtml($this->DESCRIPTION->caption());

        // CLASS_ROOM_ID
        $this->CLASS_ROOM_ID->EditAttrs["class"] = "form-control";
        $this->CLASS_ROOM_ID->EditCustomAttributes = "";
        $this->CLASS_ROOM_ID->PlaceHolder = RemoveHtml($this->CLASS_ROOM_ID->caption());

        // KELUAR_ID
        $this->KELUAR_ID->EditAttrs["class"] = "form-control";
        $this->KELUAR_ID->EditCustomAttributes = "";
        $this->KELUAR_ID->PlaceHolder = RemoveHtml($this->KELUAR_ID->caption());

        // BED_ID
        $this->BED_ID->EditAttrs["class"] = "form-control";
        $this->BED_ID->EditCustomAttributes = "";
        $this->BED_ID->PlaceHolder = RemoveHtml($this->BED_ID->caption());

        // EMPLOYEE_ID
        $this->EMPLOYEE_ID->EditAttrs["class"] = "form-control";
        $this->EMPLOYEE_ID->EditCustomAttributes = "";
        $this->EMPLOYEE_ID->PlaceHolder = RemoveHtml($this->EMPLOYEE_ID->caption());

        // DOCTOR
        $this->DOCTOR->EditAttrs["class"] = "form-control";
        $this->DOCTOR->EditCustomAttributes = "";
        if (!$this->DOCTOR->Raw) {
            $this->DOCTOR->CurrentValue = HtmlDecode($this->DOCTOR->CurrentValue);
        }
        $this->DOCTOR->EditValue = $this->DOCTOR->CurrentValue;
        $this->DOCTOR->PlaceHolder = RemoveHtml($this->DOCTOR->caption());

        // EXIT_DATE
        $this->EXIT_DATE->EditAttrs["class"] = "form-control";
        $this->EXIT_DATE->EditCustomAttributes = "";
        $this->EXIT_DATE->EditValue = FormatDateTime($this->EXIT_DATE->CurrentValue, 11);
        $this->EXIT_DATE->PlaceHolder = RemoveHtml($this->EXIT_DATE->caption());

        // EMPLOYEE_ID_FROM
        $this->EMPLOYEE_ID_FROM->EditAttrs["class"] = "form-control";
        $this->EMPLOYEE_ID_FROM->EditCustomAttributes = "";
        if (!$this->EMPLOYEE_ID_FROM->Raw) {
            $this->EMPLOYEE_ID_FROM->CurrentValue = HtmlDecode($this->EMPLOYEE_ID_FROM->CurrentValue);
        }
        $this->EMPLOYEE_ID_FROM->EditValue = $this->EMPLOYEE_ID_FROM->CurrentValue;
        $this->EMPLOYEE_ID_FROM->PlaceHolder = RemoveHtml($this->EMPLOYEE_ID_FROM->caption());

        // DOCTOR_FROM
        $this->DOCTOR_FROM->EditAttrs["class"] = "form-control";
        $this->DOCTOR_FROM->EditCustomAttributes = "";
        if (!$this->DOCTOR_FROM->Raw) {
            $this->DOCTOR_FROM->CurrentValue = HtmlDecode($this->DOCTOR_FROM->CurrentValue);
        }
        $this->DOCTOR_FROM->EditValue = $this->DOCTOR_FROM->CurrentValue;
        $this->DOCTOR_FROM->PlaceHolder = RemoveHtml($this->DOCTOR_FROM->caption());

        // STATUS_PASIEN_ID
        $this->STATUS_PASIEN_ID->EditAttrs["class"] = "form-control";
        $this->STATUS_PASIEN_ID->EditCustomAttributes = "";
        $this->STATUS_PASIEN_ID->EditValue = $this->STATUS_PASIEN_ID->CurrentValue;
        $this->STATUS_PASIEN_ID->PlaceHolder = RemoveHtml($this->STATUS_PASIEN_ID->caption());

        // THENAME
        $this->THENAME->EditAttrs["class"] = "form-control";
        $this->THENAME->EditCustomAttributes = "";
        if ($this->THENAME->getSessionValue() != "") {
            $this->THENAME->CurrentValue = GetForeignKeyValue($this->THENAME->getSessionValue());
            $this->THENAME->ViewValue = $this->THENAME->CurrentValue;
            $this->THENAME->ViewCustomAttributes = "";
        } else {
            if (!$this->THENAME->Raw) {
                $this->THENAME->CurrentValue = HtmlDecode($this->THENAME->CurrentValue);
            }
            $this->THENAME->EditValue = $this->THENAME->CurrentValue;
            $this->THENAME->PlaceHolder = RemoveHtml($this->THENAME->caption());
        }

        // THEADDRESS
        $this->THEADDRESS->EditAttrs["class"] = "form-control";
        $this->THEADDRESS->EditCustomAttributes = "";
        if (!$this->THEADDRESS->Raw) {
            $this->THEADDRESS->CurrentValue = HtmlDecode($this->THEADDRESS->CurrentValue);
        }
        $this->THEADDRESS->EditValue = $this->THEADDRESS->CurrentValue;
        $this->THEADDRESS->PlaceHolder = RemoveHtml($this->THEADDRESS->caption());

        // THEID
        $this->THEID->EditAttrs["class"] = "form-control";
        $this->THEID->EditCustomAttributes = "";
        if (!$this->THEID->Raw) {
            $this->THEID->CurrentValue = HtmlDecode($this->THEID->CurrentValue);
        }
        $this->THEID->EditValue = $this->THEID->CurrentValue;
        $this->THEID->PlaceHolder = RemoveHtml($this->THEID->caption());

        // ISRJ
        $this->ISRJ->EditAttrs["class"] = "form-control";
        $this->ISRJ->EditCustomAttributes = "";
        if (!$this->ISRJ->Raw) {
            $this->ISRJ->CurrentValue = HtmlDecode($this->ISRJ->CurrentValue);
        }
        $this->ISRJ->EditValue = $this->ISRJ->CurrentValue;
        $this->ISRJ->PlaceHolder = RemoveHtml($this->ISRJ->caption());

        // AGEYEAR
        $this->AGEYEAR->EditAttrs["class"] = "form-control";
        $this->AGEYEAR->EditCustomAttributes = "";
        $this->AGEYEAR->EditValue = $this->AGEYEAR->CurrentValue;
        $this->AGEYEAR->PlaceHolder = RemoveHtml($this->AGEYEAR->caption());

        // AGEMONTH
        $this->AGEMONTH->EditAttrs["class"] = "form-control";
        $this->AGEMONTH->EditCustomAttributes = "";
        $this->AGEMONTH->EditValue = $this->AGEMONTH->CurrentValue;
        $this->AGEMONTH->PlaceHolder = RemoveHtml($this->AGEMONTH->caption());

        // AGEDAY
        $this->AGEDAY->EditAttrs["class"] = "form-control";
        $this->AGEDAY->EditCustomAttributes = "";
        $this->AGEDAY->EditValue = $this->AGEDAY->CurrentValue;
        $this->AGEDAY->PlaceHolder = RemoveHtml($this->AGEDAY->caption());

        // GENDER
        $this->GENDER->EditAttrs["class"] = "form-control";
        $this->GENDER->EditCustomAttributes = "";
        if (!$this->GENDER->Raw) {
            $this->GENDER->CurrentValue = HtmlDecode($this->GENDER->CurrentValue);
        }
        $this->GENDER->EditValue = $this->GENDER->CurrentValue;
        $this->GENDER->PlaceHolder = RemoveHtml($this->GENDER->caption());

        // KARYAWAN
        $this->KARYAWAN->EditAttrs["class"] = "form-control";
        $this->KARYAWAN->EditCustomAttributes = "";
        if (!$this->KARYAWAN->Raw) {
            $this->KARYAWAN->CurrentValue = HtmlDecode($this->KARYAWAN->CurrentValue);
        }
        $this->KARYAWAN->EditValue = $this->KARYAWAN->CurrentValue;
        $this->KARYAWAN->PlaceHolder = RemoveHtml($this->KARYAWAN->caption());

        // MODIFIED_BY
        $this->MODIFIED_BY->EditAttrs["class"] = "form-control";
        $this->MODIFIED_BY->EditCustomAttributes = "";
        if (!$this->MODIFIED_BY->Raw) {
            $this->MODIFIED_BY->CurrentValue = HtmlDecode($this->MODIFIED_BY->CurrentValue);
        }
        $this->MODIFIED_BY->EditValue = $this->MODIFIED_BY->CurrentValue;
        $this->MODIFIED_BY->PlaceHolder = RemoveHtml($this->MODIFIED_BY->caption());

        // MODIFIED_DATE
        $this->MODIFIED_DATE->EditAttrs["class"] = "form-control";
        $this->MODIFIED_DATE->EditCustomAttributes = "";
        $this->MODIFIED_DATE->EditValue = FormatDateTime($this->MODIFIED_DATE->CurrentValue, 8);
        $this->MODIFIED_DATE->PlaceHolder = RemoveHtml($this->MODIFIED_DATE->caption());

        // MODIFIED_FROM
        $this->MODIFIED_FROM->EditAttrs["class"] = "form-control";
        $this->MODIFIED_FROM->EditCustomAttributes = "";
        if (!$this->MODIFIED_FROM->Raw) {
            $this->MODIFIED_FROM->CurrentValue = HtmlDecode($this->MODIFIED_FROM->CurrentValue);
        }
        $this->MODIFIED_FROM->EditValue = $this->MODIFIED_FROM->CurrentValue;
        $this->MODIFIED_FROM->PlaceHolder = RemoveHtml($this->MODIFIED_FROM->caption());

        // Call Row Rendered event
        $this->rowRendered();
    }

    // Aggregate list row values
    public function aggregateListRowValues()
    {
    }

    // Aggregate list row (for rendering)
    public function aggregateListRow()
    {
        // Call Row Rendered event
        $this->rowRendered();
    }

    // Export data in HTML/CSV/Word/Excel/Email/PDF format
    public function exportDocument($doc, $recordset, $startRec = 1, $stopRec = 1, $exportPageType = "")
    {
        if (!$recordset || !$doc) {
            return;
        }
        if (!$doc->ExportCustom) {
            // Write header
            $doc->exportTableHeader();
            if ($doc->Horizontal) { // Horizontal format, write header
                $doc->beginExportRow();
                if ($exportPageType == "view") {
                    $doc->exportCaption($this->CLINIC_ID);
                    $doc->exportCaption($this->TREATMENT);
                    $doc->exportCaption($this->TREAT_DATE);
                    $doc->exportCaption($this->DESCRIPTION);
                    $doc->exportCaption($this->CLASS_ROOM_ID);
                    $doc->exportCaption($this->KELUAR_ID);
                    $doc->exportCaption($this->BED_ID);
                    $doc->exportCaption($this->EMPLOYEE_ID);
                } else {
                    $doc->exportCaption($this->ID);
                    $doc->exportCaption($this->BILL_ID);
                    $doc->exportCaption($this->NO_REGISTRATION);
                    $doc->exportCaption($this->VISIT_ID);
                    $doc->exportCaption($this->TRANS_ID);
                    $doc->exportCaption($this->TARIF_ID);
                    $doc->exportCaption($this->CLASS_ID);
                    $doc->exportCaption($this->CLINIC_ID);
                    $doc->exportCaption($this->CLINIC_ID_FROM);
                    $doc->exportCaption($this->TREATMENT);
                    $doc->exportCaption($this->TREAT_DATE);
                    $doc->exportCaption($this->QUANTITY);
                    $doc->exportCaption($this->MEASURE_ID);
                    $doc->exportCaption($this->DESCRIPTION);
                    $doc->exportCaption($this->CLASS_ROOM_ID);
                    $doc->exportCaption($this->KELUAR_ID);
                    $doc->exportCaption($this->BED_ID);
                    $doc->exportCaption($this->EMPLOYEE_ID);
                    $doc->exportCaption($this->DOCTOR);
                    $doc->exportCaption($this->EXIT_DATE);
                    $doc->exportCaption($this->EMPLOYEE_ID_FROM);
                    $doc->exportCaption($this->DOCTOR_FROM);
                    $doc->exportCaption($this->STATUS_PASIEN_ID);
                    $doc->exportCaption($this->THENAME);
                    $doc->exportCaption($this->THEADDRESS);
                    $doc->exportCaption($this->THEID);
                    $doc->exportCaption($this->ISRJ);
                    $doc->exportCaption($this->AGEYEAR);
                    $doc->exportCaption($this->AGEMONTH);
                    $doc->exportCaption($this->AGEDAY);
                    $doc->exportCaption($this->GENDER);
                    $doc->exportCaption($this->KARYAWAN);
                    $doc->exportCaption($this->MODIFIED_BY);
                    $doc->exportCaption($this->MODIFIED_DATE);
                    $doc->exportCaption($this->MODIFIED_FROM);
                }
                $doc->endExportRow();
            }
        }

        // Move to first record
        $recCnt = $startRec - 1;
        $stopRec = ($stopRec > 0) ? $stopRec : PHP_INT_MAX;
        while (!$recordset->EOF && $recCnt < $stopRec) {
            $row = $recordset->fields;
            $recCnt++;
            if ($recCnt >= $startRec) {
                $rowCnt = $recCnt - $startRec + 1;

                // Page break
                if ($this->ExportPageBreakCount > 0) {
                    if ($rowCnt > 1 && ($rowCnt - 1) % $this->ExportPageBreakCount == 0) {
                        $doc->exportPageBreak();
                    }
                }
                $this->loadListRowValues($row);

                // Render row
                $this->RowType = ROWTYPE_VIEW; // Render view
                $this->resetAttributes();
                $this->renderListRow();
                if (!$doc->ExportCustom) {
                    $doc->beginExportRow($rowCnt); // Allow CSS styles if enabled
                    if ($exportPageType == "view") {
                        $doc->exportField($this->CLINIC_ID);
                        $doc->exportField($this->TREATMENT);
                        $doc->exportField($this->TREAT_DATE);
                        $doc->exportField($this->DESCRIPTION);
                        $doc->exportField($this->CLASS_ROOM_ID);
                        $doc->exportField($this->KELUAR_ID);
                        $doc->exportField($this->BED_ID);
                        $doc->exportField($this->EMPLOYEE_ID);
                    } else {
                        $doc->exportField($this->ID);
                        $doc->exportField($this->BILL_ID);
                        $doc->exportField($this->NO_REGISTRATION);
                        $doc->exportField($this->VISIT_ID);
                        $doc->exportField($this->TRANS_ID);
                        $doc->exportField($this->TARIF_ID);
                        $doc->exportField($this->CLASS_ID);
                        $doc->exportField($this->CLINIC_ID);
                        $doc->exportField($this->CLINIC_ID_FROM);
                        $doc->exportField($this->TREATMENT);
                        $doc->exportField($this->TREAT_DATE);
                        $doc->exportField($this->QUANTITY);
                        $doc->exportField($this->MEASURE_ID);
                        $doc->exportField($this->DESCRIPTION);
                        $doc->exportField($this->CLASS_ROOM_ID);
                        $doc->exportField($this->KELUAR_ID);
                        $doc->exportField($this->BED_ID);
                        $doc->exportField($this->EMPLOYEE_ID);
                        $doc->exportField($this->DOCTOR);
                        $doc->exportField($this->EXIT_DATE);
                        $doc->exportField($this->EMPLOYEE_ID_FROM);
                        $doc->exportField($this->DOCTOR_FROM);
                        $doc->exportField($this->STATUS_PASIEN_ID);
                        $doc->exportField($this->THENAME);
                        $doc->exportField($this->THEADDRESS);
                        $doc->exportField($this->THEID);
                        $doc->exportField($this->ISRJ);
                        $doc->exportField($this->AGEYEAR);
                        $doc->exportField($this->AGEMONTH);
                        $doc->exportField($this->AGEDAY);
                        $doc->exportField($this->GENDER);
                        $doc->exportField($this->KARYAWAN);
                        $doc->exportField($this->MODIFIED_BY);
                        $doc->exportField($this->MODIFIED_DATE);
                        $doc->exportField($this->MODIFIED_FROM);
                    }
                    $doc->endExportRow($rowCnt);
                }
            }

            // Call Row Export server event
            if ($doc->ExportCustom) {
                $this->rowExport($row);
            }
            $recordset->moveNext();
        }
        if (!$doc->ExportCustom) {
            $doc->exportTableFooter();
        }
    }

    // Get file data
    public function getFileData($fldparm, $key, $resize, $width = 0, $height = 0, $plugins = [])
    {
        // No binary fields
        return false;
    }

    // Table level events

    // Recordset Selecting event
    public function recordsetSelecting(&$filter)
    {
        // Enter your code here
    }

    // Recordset Selected event
    public function recordsetSelected(&$rs)
    {
        //Log("Recordset Selected");
    }

    // Recordset Search Validated event
    public function recordsetSearchValidated()
    {
        // Example:
        //$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value
    }

    // Recordset Searching event
    public function recordsetSearching(&$filter)
    {
        // Enter your code here
    }

    // Row_Selecting event
    public function rowSelecting(&$filter)
    {
        // Enter your code here
    }

    // Row Selected event
    public function rowSelected(&$rs)
    {
        //Log("Row Selected");
    }

    // Row Inserting event
    public function rowInserting($rsold, &$rsnew)
    {
        // Enter your code here
        // To cancel, set return value to false
        return true;
    }

    // Row Inserted event
    public function rowInserted($rsold, &$rsnew)
    {
        //Log("Row Inserted");
    }

    // Row Updating event
    public function rowUpdating($rsold, &$rsnew)
    {
        // Enter your code here
        // To cancel, set return value to false
        return true;
    }

    // Row Updated event
    public function rowUpdated($rsold, &$rsnew)
    {
        //Log("Row Updated");
    }

    // Row Update Conflict event
    public function rowUpdateConflict($rsold, &$rsnew)
    {
        // Enter your code here
        // To ignore conflict, set return value to false
        return true;
    }

    // Grid Inserting event
    public function gridInserting()
    {
        // Enter your code here
        // To reject grid insert, set return value to false
        return true;
    }

    // Grid Inserted event
    public function gridInserted($rsnew)
    {
        //Log("Grid Inserted");
    }

    // Grid Updating event
    public function gridUpdating($rsold)
    {
        // Enter your code here
        // To reject grid update, set return value to false
        return true;
    }

    // Grid Updated event
    public function gridUpdated($rsold, $rsnew)
    {
        //Log("Grid Updated");
    }

    // Row Deleting event
    public function rowDeleting(&$rs)
    {
        // Enter your code here
        // To cancel, set return value to False
        return true;
    }

    // Row Deleted event
    public function rowDeleted(&$rs)
    {
        //Log("Row Deleted");
    }

    // Email Sending event
    public function emailSending($email, &$args)
    {
        //var_dump($email); var_dump($args); exit();
        return true;
    }

    // Lookup Selecting event
    public function lookupSelecting($fld, &$filter)
    {
        //var_dump($fld->Name, $fld->Lookup, $filter); // Uncomment to view the filter
        // Enter your code here
    }

    // Row Rendering event
    public function rowRendering()
    {
        // Enter your code here
    }

    // Row Rendered event
    public function rowRendered()
    {
        // To view properties of field class, use:
        //var_dump($this-><FieldName>);
    }

    // User ID Filtering event
    public function userIdFiltering(&$filter)
    {
        // Enter your code here
    }
}
