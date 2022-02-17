<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

use Doctrine\DBAL\ParameterType;

/**
 * Table class for TREATMENT_INAP
 */
class TreatmentInap extends DbTable
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
    public $BILL_ID;
    public $NO_REGISTRATION;
    public $VISIT_ID;
    public $TARIF_ID;
    public $CLASS_ID;
    public $CLINIC_ID;
    public $CLINIC_ID_FROM;
    public $TREATMENT;
    public $TREAT_DATE;
    public $QUANTITY;
    public $KELUAR_ID;
    public $BED_ID;
    public $EXIT_DATE;
    public $THENAME;
    public $THEADDRESS;
    public $THEID;
    public $TRANS_ID;
    public $ID;
    public $AMOUNT;
    public $POKOK_JUAL;
    public $PPN;
    public $SUBSIDI;
    public $PRINT_DATE;
    public $ISCETAK;
    public $NOTA_NO;
    public $KUITANSI_ID;
    public $amount_paid;
    public $sell_price;
    public $diskon;
    public $TAGIHAN;
    public $CLINIC_TYPE;
    public $ID_1;
    public $ORG_UNIT_CODE;
    public $BILL_ID_1;
    public $NO_REGISTRATION_1;
    public $VISIT_ID_1;
    public $TARIF_ID_1;
    public $CLASS_ID_1;
    public $CLINIC_ID_1;
    public $CLINIC_ID_FROM_1;
    public $TREATMENT_1;
    public $TREAT_DATE_1;
    public $QUANTITY_1;
    public $MEASURE_ID;
    public $MEASURE_ID_1;
    public $TRANS_ID_1;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'TREATMENT_INAP';
        $this->TableName = 'TREATMENT_INAP';
        $this->TableType = 'CUSTOMVIEW';

        // Update Table
        $this->UpdateTable = "dbo.TREATMENT_BILL INNER JOIN dbo.TREATMENT_AKOMODASI ON dbo.TREATMENT_BILL.VISIT_ID = dbo.TREATMENT_AKOMODASI.VISIT_ID AND dbo.TREATMENT_BILL.NO_REGISTRATION = dbo.TREATMENT_AKOMODASI.NO_REGISTRATION AND dbo.TREATMENT_BILL.TRANS_ID = dbo.TREATMENT_AKOMODASI.TRANS_ID AND dbo.TREATMENT_BILL.THENAME = dbo.TREATMENT_AKOMODASI.THENAME AND dbo.TREATMENT_BILL.BILL_ID = dbo.TREATMENT_AKOMODASI.BILL_ID";
        $this->Dbid = 'DB';
        $this->ExportAll = true;
        $this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
        $this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
        $this->ExportPageSize = "a4"; // Page size (PDF only)
        $this->ExportExcelPageOrientation = ""; // Page orientation (PhpSpreadsheet only)
        $this->ExportExcelPageSize = ""; // Page size (PhpSpreadsheet only)
        $this->ExportWordPageOrientation = "portrait"; // Page orientation (PHPWord only)
        $this->ExportWordColumnWidth = null; // Cell width (PHPWord only)
        $this->DetailAdd = true; // Allow detail add
        $this->DetailEdit = true; // Allow detail edit
        $this->DetailView = true; // Allow detail view
        $this->ShowMultipleDetails = false; // Show multiple details
        $this->GridAddRowCount = 1;
        $this->AllowAddDeleteRow = true; // Allow add/delete row
        $this->UserIDAllowSecurity = Config("DEFAULT_USER_ID_ALLOW_SECURITY"); // Default User ID allowed permissions
        $this->BasicSearch = new BasicSearch($this->TableVar);

        // BILL_ID
        $this->BILL_ID = new DbField('TREATMENT_INAP', 'TREATMENT_INAP', 'x_BILL_ID', 'BILL_ID', 'dbo.TREATMENT_BILL.BILL_ID', 'dbo.TREATMENT_BILL.BILL_ID', 200, 50, -1, false, 'dbo.TREATMENT_BILL.BILL_ID', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->BILL_ID->Nullable = false; // NOT NULL field
        $this->BILL_ID->Required = true; // Required field
        $this->BILL_ID->Sortable = false; // Allow sort
        $this->BILL_ID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->BILL_ID->Param, "CustomMsg");
        $this->Fields['BILL_ID'] = &$this->BILL_ID;

        // NO_REGISTRATION
        $this->NO_REGISTRATION = new DbField('TREATMENT_INAP', 'TREATMENT_INAP', 'x_NO_REGISTRATION', 'NO_REGISTRATION', 'dbo.TREATMENT_BILL.NO_REGISTRATION', 'dbo.TREATMENT_BILL.NO_REGISTRATION', 200, 50, -1, false, 'dbo.TREATMENT_BILL.NO_REGISTRATION', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->NO_REGISTRATION->IsForeignKey = true; // Foreign key field
        $this->NO_REGISTRATION->Nullable = false; // NOT NULL field
        $this->NO_REGISTRATION->Required = true; // Required field
        $this->NO_REGISTRATION->Sortable = false; // Allow sort
        $this->NO_REGISTRATION->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->NO_REGISTRATION->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->NO_REGISTRATION->Lookup = new Lookup('NO_REGISTRATION', 'PASIEN', false, 'NO_REGISTRATION', ["NO_REGISTRATION","NAME_OF_PASIEN","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->NO_REGISTRATION->Lookup = new Lookup('NO_REGISTRATION', 'PASIEN', false, 'NO_REGISTRATION', ["NO_REGISTRATION","NAME_OF_PASIEN","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->NO_REGISTRATION->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->NO_REGISTRATION->Param, "CustomMsg");
        $this->Fields['NO_REGISTRATION'] = &$this->NO_REGISTRATION;

        // VISIT_ID
        $this->VISIT_ID = new DbField('TREATMENT_INAP', 'TREATMENT_INAP', 'x_VISIT_ID', 'VISIT_ID', 'dbo.TREATMENT_BILL.VISIT_ID', 'dbo.TREATMENT_BILL.VISIT_ID', 200, 50, -1, false, 'dbo.TREATMENT_BILL.VISIT_ID', false, false, false, 'FORMATTED TEXT', 'HIDDEN');
        $this->VISIT_ID->IsForeignKey = true; // Foreign key field
        $this->VISIT_ID->Nullable = false; // NOT NULL field
        $this->VISIT_ID->Sortable = false; // Allow sort
        $this->VISIT_ID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->VISIT_ID->Param, "CustomMsg");
        $this->Fields['VISIT_ID'] = &$this->VISIT_ID;

        // TARIF_ID
        $this->TARIF_ID = new DbField('TREATMENT_INAP', 'TREATMENT_INAP', 'x_TARIF_ID', 'TARIF_ID', 'dbo.TREATMENT_BILL.TARIF_ID', 'dbo.TREATMENT_BILL.TARIF_ID', 200, 25, -1, false, 'dbo.TREATMENT_BILL.TARIF_ID', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->TARIF_ID->Sortable = false; // Allow sort
        $this->TARIF_ID->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->TARIF_ID->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->TARIF_ID->Lookup = new Lookup('TARIF_ID', 'TREAT_TARIF', false, 'TARIF_ID', ["TARIF_NAME","AMOUNT_PAID","",""], [], [], [], [], ["TARIF_NAME"], ["x_TREATMENT"], '[TARIF_NAME] ASC', '');
                break;
            default:
                $this->TARIF_ID->Lookup = new Lookup('TARIF_ID', 'TREAT_TARIF', false, 'TARIF_ID', ["TARIF_NAME","AMOUNT_PAID","",""], [], [], [], [], ["TARIF_NAME"], ["x_TREATMENT"], '[TARIF_NAME] ASC', '');
                break;
        }
        $this->TARIF_ID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->TARIF_ID->Param, "CustomMsg");
        $this->Fields['TARIF_ID'] = &$this->TARIF_ID;

        // CLASS_ID
        $this->CLASS_ID = new DbField('TREATMENT_INAP', 'TREATMENT_INAP', 'x_CLASS_ID', 'CLASS_ID', 'dbo.TREATMENT_BILL.CLASS_ID', 'CAST(dbo.TREATMENT_BILL.CLASS_ID AS NVARCHAR)', 17, 1, -1, false, 'dbo.TREATMENT_BILL.CLASS_ID', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->CLASS_ID->Sortable = false; // Allow sort
        $this->CLASS_ID->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->CLASS_ID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->CLASS_ID->Param, "CustomMsg");
        $this->Fields['CLASS_ID'] = &$this->CLASS_ID;

        // CLINIC_ID
        $this->CLINIC_ID = new DbField('TREATMENT_INAP', 'TREATMENT_INAP', 'x_CLINIC_ID', 'CLINIC_ID', 'dbo.TREATMENT_BILL.CLINIC_ID', 'dbo.TREATMENT_BILL.CLINIC_ID', 200, 15, -1, false, 'dbo.TREATMENT_BILL.CLINIC_ID', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->CLINIC_ID->Sortable = false; // Allow sort
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
        $this->CLINIC_ID_FROM = new DbField('TREATMENT_INAP', 'TREATMENT_INAP', 'x_CLINIC_ID_FROM', 'CLINIC_ID_FROM', 'dbo.TREATMENT_BILL.CLINIC_ID_FROM', 'dbo.TREATMENT_BILL.CLINIC_ID_FROM', 200, 15, -1, false, 'dbo.TREATMENT_BILL.CLINIC_ID_FROM', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->CLINIC_ID_FROM->Sortable = false; // Allow sort
        $this->CLINIC_ID_FROM->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->CLINIC_ID_FROM->Param, "CustomMsg");
        $this->Fields['CLINIC_ID_FROM'] = &$this->CLINIC_ID_FROM;

        // TREATMENT
        $this->TREATMENT = new DbField('TREATMENT_INAP', 'TREATMENT_INAP', 'x_TREATMENT', 'TREATMENT', 'dbo.TREATMENT_BILL.TREATMENT', 'dbo.TREATMENT_BILL.TREATMENT', 200, 200, -1, false, 'dbo.TREATMENT_BILL.TREATMENT', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->TREATMENT->Sortable = false; // Allow sort
        $this->TREATMENT->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->TREATMENT->Param, "CustomMsg");
        $this->Fields['TREATMENT'] = &$this->TREATMENT;

        // TREAT_DATE
        $this->TREAT_DATE = new DbField('TREATMENT_INAP', 'TREATMENT_INAP', 'x_TREAT_DATE', 'TREAT_DATE', 'dbo.TREATMENT_BILL.TREAT_DATE', CastDateFieldForLike("dbo.TREATMENT_BILL.TREAT_DATE", 11, "DB"), 135, 8, 11, false, 'dbo.TREATMENT_BILL.TREAT_DATE', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->TREAT_DATE->Sortable = true; // Allow sort
        $this->TREAT_DATE->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_SEPARATOR"], $Language->phrase("IncorrectDateDMY"));
        $this->TREAT_DATE->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->TREAT_DATE->Param, "CustomMsg");
        $this->Fields['TREAT_DATE'] = &$this->TREAT_DATE;

        // QUANTITY
        $this->QUANTITY = new DbField('TREATMENT_INAP', 'TREATMENT_INAP', 'x_QUANTITY', 'QUANTITY', 'dbo.TREATMENT_BILL.QUANTITY', 'CAST(dbo.TREATMENT_BILL.QUANTITY AS NVARCHAR)', 131, 8, -1, false, 'dbo.TREATMENT_BILL.QUANTITY', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->QUANTITY->Sortable = false; // Allow sort
        $this->QUANTITY->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->QUANTITY->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->QUANTITY->Param, "CustomMsg");
        $this->Fields['QUANTITY'] = &$this->QUANTITY;

        // KELUAR_ID
        $this->KELUAR_ID = new DbField('TREATMENT_INAP', 'TREATMENT_INAP', 'x_KELUAR_ID', 'KELUAR_ID', 'dbo.TREATMENT_AKOMODASI.KELUAR_ID', 'CAST(dbo.TREATMENT_AKOMODASI.KELUAR_ID AS NVARCHAR)', 17, 1, -1, false, 'dbo.TREATMENT_AKOMODASI.KELUAR_ID', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->KELUAR_ID->Sortable = false; // Allow sort
        $this->KELUAR_ID->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->KELUAR_ID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->KELUAR_ID->Param, "CustomMsg");
        $this->Fields['KELUAR_ID'] = &$this->KELUAR_ID;

        // BED_ID
        $this->BED_ID = new DbField('TREATMENT_INAP', 'TREATMENT_INAP', 'x_BED_ID', 'BED_ID', 'dbo.TREATMENT_AKOMODASI.BED_ID', 'CAST(dbo.TREATMENT_AKOMODASI.BED_ID AS NVARCHAR)', 17, 1, -1, false, 'dbo.TREATMENT_AKOMODASI.BED_ID', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->BED_ID->Sortable = false; // Allow sort
        $this->BED_ID->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->BED_ID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->BED_ID->Param, "CustomMsg");
        $this->Fields['BED_ID'] = &$this->BED_ID;

        // EXIT_DATE
        $this->EXIT_DATE = new DbField('TREATMENT_INAP', 'TREATMENT_INAP', 'x_EXIT_DATE', 'EXIT_DATE', 'dbo.TREATMENT_AKOMODASI.EXIT_DATE', CastDateFieldForLike("dbo.TREATMENT_AKOMODASI.EXIT_DATE", 0, "DB"), 135, 8, 0, false, 'dbo.TREATMENT_AKOMODASI.EXIT_DATE', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->EXIT_DATE->Sortable = false; // Allow sort
        $this->EXIT_DATE->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->EXIT_DATE->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->EXIT_DATE->Param, "CustomMsg");
        $this->Fields['EXIT_DATE'] = &$this->EXIT_DATE;

        // THENAME
        $this->THENAME = new DbField('TREATMENT_INAP', 'TREATMENT_INAP', 'x_THENAME', 'THENAME', 'dbo.TREATMENT_BILL.THENAME', 'dbo.TREATMENT_BILL.THENAME', 200, 100, -1, false, 'dbo.TREATMENT_BILL.THENAME', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->THENAME->IsForeignKey = true; // Foreign key field
        $this->THENAME->Sortable = false; // Allow sort
        $this->THENAME->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->THENAME->Param, "CustomMsg");
        $this->Fields['THENAME'] = &$this->THENAME;

        // THEADDRESS
        $this->THEADDRESS = new DbField('TREATMENT_INAP', 'TREATMENT_INAP', 'x_THEADDRESS', 'THEADDRESS', 'dbo.TREATMENT_BILL.THEADDRESS', 'dbo.TREATMENT_BILL.THEADDRESS', 200, 150, -1, false, 'dbo.TREATMENT_BILL.THEADDRESS', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->THEADDRESS->IsForeignKey = true; // Foreign key field
        $this->THEADDRESS->Sortable = false; // Allow sort
        $this->THEADDRESS->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->THEADDRESS->Param, "CustomMsg");
        $this->Fields['THEADDRESS'] = &$this->THEADDRESS;

        // THEID
        $this->THEID = new DbField('TREATMENT_INAP', 'TREATMENT_INAP', 'x_THEID', 'THEID', 'dbo.TREATMENT_BILL.THEID', 'dbo.TREATMENT_BILL.THEID', 200, 25, -1, false, 'dbo.TREATMENT_BILL.THEID', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->THEID->Sortable = false; // Allow sort
        $this->THEID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->THEID->Param, "CustomMsg");
        $this->Fields['THEID'] = &$this->THEID;

        // TRANS_ID
        $this->TRANS_ID = new DbField('TREATMENT_INAP', 'TREATMENT_INAP', 'x_TRANS_ID', 'TRANS_ID', 'dbo.TREATMENT_BILL.TRANS_ID', 'dbo.TREATMENT_BILL.TRANS_ID', 200, 50, -1, false, 'dbo.TREATMENT_BILL.TRANS_ID', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->TRANS_ID->IsForeignKey = true; // Foreign key field
        $this->TRANS_ID->Sortable = true; // Allow sort
        $this->TRANS_ID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->TRANS_ID->Param, "CustomMsg");
        $this->Fields['TRANS_ID'] = &$this->TRANS_ID;

        // ID
        $this->ID = new DbField('TREATMENT_INAP', 'TREATMENT_INAP', 'x_ID', 'ID', 'dbo.TREATMENT_BILL.ID', 'CAST(dbo.TREATMENT_BILL.ID AS NVARCHAR)', 3, 4, -1, false, 'dbo.TREATMENT_BILL.ID', false, false, false, 'FORMATTED TEXT', 'NO');
        $this->ID->IsAutoIncrement = true; // Autoincrement field
        $this->ID->IsPrimaryKey = true; // Primary key field
        $this->ID->Nullable = false; // NOT NULL field
        $this->ID->Sortable = true; // Allow sort
        $this->ID->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->ID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->ID->Param, "CustomMsg");
        $this->Fields['ID'] = &$this->ID;

        // AMOUNT
        $this->AMOUNT = new DbField('TREATMENT_INAP', 'TREATMENT_INAP', 'x_AMOUNT', 'AMOUNT', 'dbo.TREATMENT_BILL.AMOUNT', 'CAST(dbo.TREATMENT_BILL.AMOUNT AS NVARCHAR)', 6, 8, -1, false, 'dbo.TREATMENT_BILL.AMOUNT', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->AMOUNT->Sortable = true; // Allow sort
        $this->AMOUNT->DefaultDecimalPrecision = 2; // Default decimal precision
        $this->AMOUNT->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->AMOUNT->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->AMOUNT->Param, "CustomMsg");
        $this->Fields['AMOUNT'] = &$this->AMOUNT;

        // POKOK_JUAL
        $this->POKOK_JUAL = new DbField('TREATMENT_INAP', 'TREATMENT_INAP', 'x_POKOK_JUAL', 'POKOK_JUAL', 'dbo.TREATMENT_BILL.POKOK_JUAL', 'CAST(dbo.TREATMENT_BILL.POKOK_JUAL AS NVARCHAR)', 131, 8, -1, false, 'dbo.TREATMENT_BILL.POKOK_JUAL', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->POKOK_JUAL->Sortable = true; // Allow sort
        $this->POKOK_JUAL->DefaultDecimalPrecision = 2; // Default decimal precision
        $this->POKOK_JUAL->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->POKOK_JUAL->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->POKOK_JUAL->Param, "CustomMsg");
        $this->Fields['POKOK_JUAL'] = &$this->POKOK_JUAL;

        // PPN
        $this->PPN = new DbField('TREATMENT_INAP', 'TREATMENT_INAP', 'x_PPN', 'PPN', 'dbo.TREATMENT_BILL.PPN', 'CAST(dbo.TREATMENT_BILL.PPN AS NVARCHAR)', 131, 8, -1, false, 'dbo.TREATMENT_BILL.PPN', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->PPN->Sortable = true; // Allow sort
        $this->PPN->DefaultDecimalPrecision = 2; // Default decimal precision
        $this->PPN->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->PPN->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->PPN->Param, "CustomMsg");
        $this->Fields['PPN'] = &$this->PPN;

        // SUBSIDI
        $this->SUBSIDI = new DbField('TREATMENT_INAP', 'TREATMENT_INAP', 'x_SUBSIDI', 'SUBSIDI', 'dbo.TREATMENT_BILL.SUBSIDI', 'CAST(dbo.TREATMENT_BILL.SUBSIDI AS NVARCHAR)', 6, 8, -1, false, 'dbo.TREATMENT_BILL.SUBSIDI', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->SUBSIDI->Sortable = true; // Allow sort
        $this->SUBSIDI->DefaultDecimalPrecision = 2; // Default decimal precision
        $this->SUBSIDI->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->SUBSIDI->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->SUBSIDI->Param, "CustomMsg");
        $this->Fields['SUBSIDI'] = &$this->SUBSIDI;

        // PRINT_DATE
        $this->PRINT_DATE = new DbField('TREATMENT_INAP', 'TREATMENT_INAP', 'x_PRINT_DATE', 'PRINT_DATE', 'dbo.TREATMENT_BILL.PRINT_DATE', CastDateFieldForLike("dbo.TREATMENT_BILL.PRINT_DATE", 0, "DB"), 135, 8, 0, false, 'dbo.TREATMENT_BILL.PRINT_DATE', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->PRINT_DATE->Sortable = true; // Allow sort
        $this->PRINT_DATE->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->PRINT_DATE->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->PRINT_DATE->Param, "CustomMsg");
        $this->Fields['PRINT_DATE'] = &$this->PRINT_DATE;

        // ISCETAK
        $this->ISCETAK = new DbField('TREATMENT_INAP', 'TREATMENT_INAP', 'x_ISCETAK', 'ISCETAK', 'dbo.TREATMENT_BILL.ISCETAK', 'dbo.TREATMENT_BILL.ISCETAK', 129, 1, -1, false, 'dbo.TREATMENT_BILL.ISCETAK', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->ISCETAK->Sortable = true; // Allow sort
        $this->ISCETAK->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->ISCETAK->Param, "CustomMsg");
        $this->Fields['ISCETAK'] = &$this->ISCETAK;

        // NOTA_NO
        $this->NOTA_NO = new DbField('TREATMENT_INAP', 'TREATMENT_INAP', 'x_NOTA_NO', 'NOTA_NO', 'dbo.TREATMENT_BILL.NOTA_NO', 'dbo.TREATMENT_BILL.NOTA_NO', 200, 50, -1, false, 'dbo.TREATMENT_BILL.NOTA_NO', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->NOTA_NO->Sortable = true; // Allow sort
        $this->NOTA_NO->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->NOTA_NO->Param, "CustomMsg");
        $this->Fields['NOTA_NO'] = &$this->NOTA_NO;

        // KUITANSI_ID
        $this->KUITANSI_ID = new DbField('TREATMENT_INAP', 'TREATMENT_INAP', 'x_KUITANSI_ID', 'KUITANSI_ID', 'dbo.TREATMENT_BILL.KUITANSI_ID', 'dbo.TREATMENT_BILL.KUITANSI_ID', 200, 100, -1, false, 'dbo.TREATMENT_BILL.KUITANSI_ID', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->KUITANSI_ID->Sortable = true; // Allow sort
        $this->KUITANSI_ID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->KUITANSI_ID->Param, "CustomMsg");
        $this->Fields['KUITANSI_ID'] = &$this->KUITANSI_ID;

        // amount_paid
        $this->amount_paid = new DbField('TREATMENT_INAP', 'TREATMENT_INAP', 'x_amount_paid', 'amount_paid', 'dbo.TREATMENT_BILL.amount_paid', 'CAST(dbo.TREATMENT_BILL.amount_paid AS NVARCHAR)', 6, 8, -1, false, 'dbo.TREATMENT_BILL.amount_paid', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->amount_paid->Sortable = true; // Allow sort
        $this->amount_paid->DefaultDecimalPrecision = 2; // Default decimal precision
        $this->amount_paid->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->amount_paid->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->amount_paid->Param, "CustomMsg");
        $this->Fields['amount_paid'] = &$this->amount_paid;

        // sell_price
        $this->sell_price = new DbField('TREATMENT_INAP', 'TREATMENT_INAP', 'x_sell_price', 'sell_price', 'dbo.TREATMENT_BILL.sell_price', 'CAST(dbo.TREATMENT_BILL.sell_price AS NVARCHAR)', 6, 8, -1, false, 'dbo.TREATMENT_BILL.sell_price', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->sell_price->Sortable = true; // Allow sort
        $this->sell_price->DefaultDecimalPrecision = 2; // Default decimal precision
        $this->sell_price->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->sell_price->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->sell_price->Param, "CustomMsg");
        $this->Fields['sell_price'] = &$this->sell_price;

        // diskon
        $this->diskon = new DbField('TREATMENT_INAP', 'TREATMENT_INAP', 'x_diskon', 'diskon', 'dbo.TREATMENT_BILL.diskon', 'CAST(dbo.TREATMENT_BILL.diskon AS NVARCHAR)', 6, 8, -1, false, 'dbo.TREATMENT_BILL.diskon', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->diskon->Sortable = true; // Allow sort
        $this->diskon->DefaultDecimalPrecision = 2; // Default decimal precision
        $this->diskon->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->diskon->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->diskon->Param, "CustomMsg");
        $this->Fields['diskon'] = &$this->diskon;

        // TAGIHAN
        $this->TAGIHAN = new DbField('TREATMENT_INAP', 'TREATMENT_INAP', 'x_TAGIHAN', 'TAGIHAN', 'dbo.TREATMENT_BILL.TAGIHAN', 'CAST(dbo.TREATMENT_BILL.TAGIHAN AS NVARCHAR)', 6, 8, -1, false, 'dbo.TREATMENT_BILL.TAGIHAN', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->TAGIHAN->Sortable = true; // Allow sort
        $this->TAGIHAN->DefaultDecimalPrecision = 2; // Default decimal precision
        $this->TAGIHAN->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->TAGIHAN->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->TAGIHAN->Param, "CustomMsg");
        $this->Fields['TAGIHAN'] = &$this->TAGIHAN;

        // CLINIC_TYPE
        $this->CLINIC_TYPE = new DbField('TREATMENT_INAP', 'TREATMENT_INAP', 'x_CLINIC_TYPE', 'CLINIC_TYPE', 'dbo.TREATMENT_AKOMODASI.CLINIC_TYPE', 'CAST(dbo.TREATMENT_AKOMODASI.CLINIC_TYPE AS NVARCHAR)', 17, 1, -1, false, 'dbo.TREATMENT_AKOMODASI.CLINIC_TYPE', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->CLINIC_TYPE->Sortable = true; // Allow sort
        $this->CLINIC_TYPE->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->CLINIC_TYPE->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->CLINIC_TYPE->Param, "CustomMsg");
        $this->Fields['CLINIC_TYPE'] = &$this->CLINIC_TYPE;

        // ID_1
        $this->ID_1 = new DbField('TREATMENT_INAP', 'TREATMENT_INAP', 'x_ID_1', 'ID_1', '[ID_1]', 'CAST([ID_1] AS NVARCHAR)', 3, 4, -1, false, '[ID_1]', false, false, false, 'FORMATTED TEXT', 'NO');
        $this->ID_1->IsAutoIncrement = true; // Autoincrement field
        $this->ID_1->Nullable = false; // NOT NULL field
        $this->ID_1->Sortable = true; // Allow sort
        $this->ID_1->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->ID_1->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->ID_1->Param, "CustomMsg");
        $this->Fields['ID_1'] = &$this->ID_1;

        // ORG_UNIT_CODE
        $this->ORG_UNIT_CODE = new DbField('TREATMENT_INAP', 'TREATMENT_INAP', 'x_ORG_UNIT_CODE', 'ORG_UNIT_CODE', 'dbo.TREATMENT_AKOMODASI.ORG_UNIT_CODE', 'dbo.TREATMENT_AKOMODASI.ORG_UNIT_CODE', 200, 50, -1, false, 'dbo.TREATMENT_AKOMODASI.ORG_UNIT_CODE', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->ORG_UNIT_CODE->Sortable = true; // Allow sort
        $this->ORG_UNIT_CODE->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->ORG_UNIT_CODE->Param, "CustomMsg");
        $this->Fields['ORG_UNIT_CODE'] = &$this->ORG_UNIT_CODE;

        // BILL_ID_1
        $this->BILL_ID_1 = new DbField('TREATMENT_INAP', 'TREATMENT_INAP', 'x_BILL_ID_1', 'BILL_ID_1', '[BILL_ID_1]', '[BILL_ID_1]', 200, 50, -1, false, '[BILL_ID_1]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->BILL_ID_1->Nullable = false; // NOT NULL field
        $this->BILL_ID_1->Required = true; // Required field
        $this->BILL_ID_1->Sortable = true; // Allow sort
        $this->BILL_ID_1->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->BILL_ID_1->Param, "CustomMsg");
        $this->Fields['BILL_ID_1'] = &$this->BILL_ID_1;

        // NO_REGISTRATION_1
        $this->NO_REGISTRATION_1 = new DbField('TREATMENT_INAP', 'TREATMENT_INAP', 'x_NO_REGISTRATION_1', 'NO_REGISTRATION_1', '[NO_REGISTRATION_1]', '[NO_REGISTRATION_1]', 200, 25, -1, false, '[NO_REGISTRATION_1]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->NO_REGISTRATION_1->Nullable = false; // NOT NULL field
        $this->NO_REGISTRATION_1->Required = true; // Required field
        $this->NO_REGISTRATION_1->Sortable = true; // Allow sort
        $this->NO_REGISTRATION_1->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->NO_REGISTRATION_1->Param, "CustomMsg");
        $this->Fields['NO_REGISTRATION_1'] = &$this->NO_REGISTRATION_1;

        // VISIT_ID_1
        $this->VISIT_ID_1 = new DbField('TREATMENT_INAP', 'TREATMENT_INAP', 'x_VISIT_ID_1', 'VISIT_ID_1', '[VISIT_ID_1]', '[VISIT_ID_1]', 200, 50, -1, false, '[VISIT_ID_1]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->VISIT_ID_1->Nullable = false; // NOT NULL field
        $this->VISIT_ID_1->Required = true; // Required field
        $this->VISIT_ID_1->Sortable = true; // Allow sort
        $this->VISIT_ID_1->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->VISIT_ID_1->Param, "CustomMsg");
        $this->Fields['VISIT_ID_1'] = &$this->VISIT_ID_1;

        // TARIF_ID_1
        $this->TARIF_ID_1 = new DbField('TREATMENT_INAP', 'TREATMENT_INAP', 'x_TARIF_ID_1', 'TARIF_ID_1', '[TARIF_ID_1]', '[TARIF_ID_1]', 200, 25, -1, false, '[TARIF_ID_1]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->TARIF_ID_1->Sortable = true; // Allow sort
        $this->TARIF_ID_1->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->TARIF_ID_1->Param, "CustomMsg");
        $this->Fields['TARIF_ID_1'] = &$this->TARIF_ID_1;

        // CLASS_ID_1
        $this->CLASS_ID_1 = new DbField('TREATMENT_INAP', 'TREATMENT_INAP', 'x_CLASS_ID_1', 'CLASS_ID_1', '[CLASS_ID_1]', 'CAST([CLASS_ID_1] AS NVARCHAR)', 17, 1, -1, false, '[CLASS_ID_1]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->CLASS_ID_1->Sortable = true; // Allow sort
        $this->CLASS_ID_1->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->CLASS_ID_1->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->CLASS_ID_1->Param, "CustomMsg");
        $this->Fields['CLASS_ID_1'] = &$this->CLASS_ID_1;

        // CLINIC_ID_1
        $this->CLINIC_ID_1 = new DbField('TREATMENT_INAP', 'TREATMENT_INAP', 'x_CLINIC_ID_1', 'CLINIC_ID_1', '[CLINIC_ID_1]', '[CLINIC_ID_1]', 200, 15, -1, false, '[CLINIC_ID_1]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->CLINIC_ID_1->Sortable = true; // Allow sort
        $this->CLINIC_ID_1->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->CLINIC_ID_1->Param, "CustomMsg");
        $this->Fields['CLINIC_ID_1'] = &$this->CLINIC_ID_1;

        // CLINIC_ID_FROM_1
        $this->CLINIC_ID_FROM_1 = new DbField('TREATMENT_INAP', 'TREATMENT_INAP', 'x_CLINIC_ID_FROM_1', 'CLINIC_ID_FROM_1', '[CLINIC_ID_FROM_1]', '[CLINIC_ID_FROM_1]', 200, 15, -1, false, '[CLINIC_ID_FROM_1]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->CLINIC_ID_FROM_1->Sortable = true; // Allow sort
        $this->CLINIC_ID_FROM_1->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->CLINIC_ID_FROM_1->Param, "CustomMsg");
        $this->Fields['CLINIC_ID_FROM_1'] = &$this->CLINIC_ID_FROM_1;

        // TREATMENT_1
        $this->TREATMENT_1 = new DbField('TREATMENT_INAP', 'TREATMENT_INAP', 'x_TREATMENT_1', 'TREATMENT_1', '[TREATMENT_1]', '[TREATMENT_1]', 200, 200, -1, false, '[TREATMENT_1]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->TREATMENT_1->Sortable = true; // Allow sort
        $this->TREATMENT_1->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->TREATMENT_1->Param, "CustomMsg");
        $this->Fields['TREATMENT_1'] = &$this->TREATMENT_1;

        // TREAT_DATE_1
        $this->TREAT_DATE_1 = new DbField('TREATMENT_INAP', 'TREATMENT_INAP', 'x_TREAT_DATE_1', 'TREAT_DATE_1', '[TREAT_DATE_1]', CastDateFieldForLike("[TREAT_DATE_1]", 0, "DB"), 135, 8, 0, false, '[TREAT_DATE_1]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->TREAT_DATE_1->Sortable = true; // Allow sort
        $this->TREAT_DATE_1->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->TREAT_DATE_1->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->TREAT_DATE_1->Param, "CustomMsg");
        $this->Fields['TREAT_DATE_1'] = &$this->TREAT_DATE_1;

        // QUANTITY_1
        $this->QUANTITY_1 = new DbField('TREATMENT_INAP', 'TREATMENT_INAP', 'x_QUANTITY_1', 'QUANTITY_1', '[QUANTITY_1]', 'CAST([QUANTITY_1] AS NVARCHAR)', 131, 8, -1, false, '[QUANTITY_1]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->QUANTITY_1->Sortable = true; // Allow sort
        $this->QUANTITY_1->DefaultDecimalPrecision = 2; // Default decimal precision
        $this->QUANTITY_1->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->QUANTITY_1->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->QUANTITY_1->Param, "CustomMsg");
        $this->Fields['QUANTITY_1'] = &$this->QUANTITY_1;

        // MEASURE_ID
        $this->MEASURE_ID = new DbField('TREATMENT_INAP', 'TREATMENT_INAP', 'x_MEASURE_ID', 'MEASURE_ID', 'dbo.TREATMENT_BILL.MEASURE_ID', 'CAST(dbo.TREATMENT_BILL.MEASURE_ID AS NVARCHAR)', 2, 2, -1, false, 'dbo.TREATMENT_BILL.MEASURE_ID', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->MEASURE_ID->Sortable = true; // Allow sort
        $this->MEASURE_ID->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->MEASURE_ID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->MEASURE_ID->Param, "CustomMsg");
        $this->Fields['MEASURE_ID'] = &$this->MEASURE_ID;

        // MEASURE_ID_1
        $this->MEASURE_ID_1 = new DbField('TREATMENT_INAP', 'TREATMENT_INAP', 'x_MEASURE_ID_1', 'MEASURE_ID_1', '[MEASURE_ID_1]', 'CAST([MEASURE_ID_1] AS NVARCHAR)', 2, 2, -1, false, '[MEASURE_ID_1]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->MEASURE_ID_1->Sortable = true; // Allow sort
        $this->MEASURE_ID_1->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->MEASURE_ID_1->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->MEASURE_ID_1->Param, "CustomMsg");
        $this->Fields['MEASURE_ID_1'] = &$this->MEASURE_ID_1;

        // TRANS_ID_1
        $this->TRANS_ID_1 = new DbField('TREATMENT_INAP', 'TREATMENT_INAP', 'x_TRANS_ID_1', 'TRANS_ID_1', '[TRANS_ID_1]', '[TRANS_ID_1]', 200, 50, -1, false, '[TRANS_ID_1]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->TRANS_ID_1->Sortable = true; // Allow sort
        $this->TRANS_ID_1->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->TRANS_ID_1->Param, "CustomMsg");
        $this->Fields['TRANS_ID_1'] = &$this->TRANS_ID_1;
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
            if ($this->THEADDRESS->getSessionValue() != "") {
                $masterFilter .= " AND " . GetForeignKeySql("[VISITOR_ADDRESS]", $this->THEADDRESS->getSessionValue(), DATATYPE_STRING, "DB");
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
                $detailFilter .= "" . GetForeignKeySql("dbo.TREATMENT_BILL.VISIT_ID", $this->VISIT_ID->getSessionValue(), DATATYPE_STRING, "DB");
            } else {
                return "";
            }
            if ($this->NO_REGISTRATION->getSessionValue() != "") {
                $detailFilter .= " AND " . GetForeignKeySql("dbo.TREATMENT_BILL.NO_REGISTRATION", $this->NO_REGISTRATION->getSessionValue(), DATATYPE_STRING, "DB");
            } else {
                return "";
            }
            if ($this->TRANS_ID->getSessionValue() != "") {
                $detailFilter .= " AND " . GetForeignKeySql("dbo.TREATMENT_BILL.TRANS_ID", $this->TRANS_ID->getSessionValue(), DATATYPE_STRING, "DB");
            } else {
                return "";
            }
            if ($this->THENAME->getSessionValue() != "") {
                $detailFilter .= " AND " . GetForeignKeySql("dbo.TREATMENT_BILL.THENAME", $this->THENAME->getSessionValue(), DATATYPE_STRING, "DB");
            } else {
                return "";
            }
            if ($this->THEADDRESS->getSessionValue() != "") {
                $detailFilter .= " AND " . GetForeignKeySql("dbo.TREATMENT_BILL.THEADDRESS", $this->THEADDRESS->getSessionValue(), DATATYPE_STRING, "DB");
            } else {
                return "";
            }
        }
        return $detailFilter;
    }

    // Master filter
    public function sqlMasterFilter_PASIEN_VISITATION()
    {
        return "[VISIT_ID]='@VISIT_ID@' AND [NO_REGISTRATION]='@NO_REGISTRATION@' AND [TRANS_ID]='@TRANS_ID@' AND [DIANTAR_OLEH]='@DIANTAR_OLEH@' AND [VISITOR_ADDRESS]='@VISITOR_ADDRESS@'";
    }
    // Detail filter
    public function sqlDetailFilter_PASIEN_VISITATION()
    {
        return "dbo.TREATMENT_BILL.VISIT_ID='@VISIT_ID@' AND dbo.TREATMENT_BILL.NO_REGISTRATION='@NO_REGISTRATION@' AND dbo.TREATMENT_BILL.TRANS_ID='@TRANS_ID@' AND dbo.TREATMENT_BILL.THENAME='@THENAME@' AND dbo.TREATMENT_BILL.THEADDRESS='@THEADDRESS@'";
    }

    // Table level SQL
    public function getSqlFrom() // From
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "dbo.TREATMENT_BILL INNER JOIN dbo.TREATMENT_AKOMODASI ON dbo.TREATMENT_BILL.VISIT_ID = dbo.TREATMENT_AKOMODASI.VISIT_ID AND dbo.TREATMENT_BILL.NO_REGISTRATION = dbo.TREATMENT_AKOMODASI.NO_REGISTRATION AND dbo.TREATMENT_BILL.TRANS_ID = dbo.TREATMENT_AKOMODASI.TRANS_ID AND dbo.TREATMENT_BILL.THENAME = dbo.TREATMENT_AKOMODASI.THENAME AND dbo.TREATMENT_BILL.BILL_ID = dbo.TREATMENT_AKOMODASI.BILL_ID";
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
        return $this->SqlSelect ?? $this->getQueryBuilder()->select("dbo.TREATMENT_BILL.ID, dbo.TREATMENT_BILL.BILL_ID, dbo.TREATMENT_BILL.NO_REGISTRATION, dbo.TREATMENT_BILL.VISIT_ID, dbo.TREATMENT_BILL.TARIF_ID, dbo.TREATMENT_BILL.CLASS_ID, dbo.TREATMENT_BILL.CLINIC_ID, dbo.TREATMENT_BILL.CLINIC_ID_FROM, dbo.TREATMENT_BILL.TREATMENT, dbo.TREATMENT_BILL.TREAT_DATE, dbo.TREATMENT_BILL.AMOUNT, dbo.TREATMENT_BILL.QUANTITY, dbo.TREATMENT_BILL.POKOK_JUAL, dbo.TREATMENT_BILL.PPN, dbo.TREATMENT_BILL.SUBSIDI, dbo.TREATMENT_BILL.PRINT_DATE, dbo.TREATMENT_BILL.ISCETAK, dbo.TREATMENT_BILL.NOTA_NO, dbo.TREATMENT_BILL.KUITANSI_ID, dbo.TREATMENT_BILL.THENAME, dbo.TREATMENT_BILL.THEADDRESS, dbo.TREATMENT_BILL.THEID, dbo.TREATMENT_BILL.amount_paid, dbo.TREATMENT_BILL.sell_price, dbo.TREATMENT_BILL.diskon, dbo.TREATMENT_BILL.TAGIHAN, dbo.TREATMENT_BILL.TRANS_ID, dbo.TREATMENT_AKOMODASI.CLINIC_TYPE, dbo.TREATMENT_AKOMODASI.EXIT_DATE, dbo.TREATMENT_AKOMODASI.BED_ID, dbo.TREATMENT_AKOMODASI.KELUAR_ID, dbo.TREATMENT_AKOMODASI.ID, dbo.TREATMENT_AKOMODASI.ORG_UNIT_CODE, dbo.TREATMENT_AKOMODASI.BILL_ID, dbo.TREATMENT_AKOMODASI.NO_REGISTRATION, dbo.TREATMENT_AKOMODASI.VISIT_ID, dbo.TREATMENT_AKOMODASI.TARIF_ID, dbo.TREATMENT_AKOMODASI.CLASS_ID, dbo.TREATMENT_AKOMODASI.CLINIC_ID, dbo.TREATMENT_AKOMODASI.CLINIC_ID_FROM, dbo.TREATMENT_AKOMODASI.TREATMENT, dbo.TREATMENT_AKOMODASI.TREAT_DATE, dbo.TREATMENT_AKOMODASI.QUANTITY, dbo.TREATMENT_BILL.MEASURE_ID, dbo.TREATMENT_AKOMODASI.MEASURE_ID, dbo.TREATMENT_AKOMODASI.TRANS_ID");
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

            // Get insert id if necessary
            $this->ID_1->setDbValue($conn->lastInsertId());
            $rs['ID_1'] = $this->ID_1->DbValue;
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
        $this->BILL_ID->DbValue = $row['BILL_ID'];
        $this->NO_REGISTRATION->DbValue = $row['NO_REGISTRATION'];
        $this->VISIT_ID->DbValue = $row['VISIT_ID'];
        $this->TARIF_ID->DbValue = $row['TARIF_ID'];
        $this->CLASS_ID->DbValue = $row['CLASS_ID'];
        $this->CLINIC_ID->DbValue = $row['CLINIC_ID'];
        $this->CLINIC_ID_FROM->DbValue = $row['CLINIC_ID_FROM'];
        $this->TREATMENT->DbValue = $row['TREATMENT'];
        $this->TREAT_DATE->DbValue = $row['TREAT_DATE'];
        $this->QUANTITY->DbValue = $row['QUANTITY'];
        $this->KELUAR_ID->DbValue = $row['KELUAR_ID'];
        $this->BED_ID->DbValue = $row['BED_ID'];
        $this->EXIT_DATE->DbValue = $row['EXIT_DATE'];
        $this->THENAME->DbValue = $row['THENAME'];
        $this->THEADDRESS->DbValue = $row['THEADDRESS'];
        $this->THEID->DbValue = $row['THEID'];
        $this->TRANS_ID->DbValue = $row['TRANS_ID'];
        $this->ID->DbValue = $row['ID'];
        $this->AMOUNT->DbValue = $row['AMOUNT'];
        $this->POKOK_JUAL->DbValue = $row['POKOK_JUAL'];
        $this->PPN->DbValue = $row['PPN'];
        $this->SUBSIDI->DbValue = $row['SUBSIDI'];
        $this->PRINT_DATE->DbValue = $row['PRINT_DATE'];
        $this->ISCETAK->DbValue = $row['ISCETAK'];
        $this->NOTA_NO->DbValue = $row['NOTA_NO'];
        $this->KUITANSI_ID->DbValue = $row['KUITANSI_ID'];
        $this->amount_paid->DbValue = $row['amount_paid'];
        $this->sell_price->DbValue = $row['sell_price'];
        $this->diskon->DbValue = $row['diskon'];
        $this->TAGIHAN->DbValue = $row['TAGIHAN'];
        $this->CLINIC_TYPE->DbValue = $row['CLINIC_TYPE'];
        $this->ID_1->DbValue = $row['ID_1'];
        $this->ORG_UNIT_CODE->DbValue = $row['ORG_UNIT_CODE'];
        $this->BILL_ID_1->DbValue = $row['BILL_ID_1'];
        $this->NO_REGISTRATION_1->DbValue = $row['NO_REGISTRATION_1'];
        $this->VISIT_ID_1->DbValue = $row['VISIT_ID_1'];
        $this->TARIF_ID_1->DbValue = $row['TARIF_ID_1'];
        $this->CLASS_ID_1->DbValue = $row['CLASS_ID_1'];
        $this->CLINIC_ID_1->DbValue = $row['CLINIC_ID_1'];
        $this->CLINIC_ID_FROM_1->DbValue = $row['CLINIC_ID_FROM_1'];
        $this->TREATMENT_1->DbValue = $row['TREATMENT_1'];
        $this->TREAT_DATE_1->DbValue = $row['TREAT_DATE_1'];
        $this->QUANTITY_1->DbValue = $row['QUANTITY_1'];
        $this->MEASURE_ID->DbValue = $row['MEASURE_ID'];
        $this->MEASURE_ID_1->DbValue = $row['MEASURE_ID_1'];
        $this->TRANS_ID_1->DbValue = $row['TRANS_ID_1'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "dbo.TREATMENT_BILL.ID = @ID@";
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
        return $_SESSION[$name] ?? GetUrl("TreatmentInapList");
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
        if ($pageName == "TreatmentInapView") {
            return $Language->phrase("View");
        } elseif ($pageName == "TreatmentInapEdit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "TreatmentInapAdd") {
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
                return "TreatmentInapView";
            case Config("API_ADD_ACTION"):
                return "TreatmentInapAdd";
            case Config("API_EDIT_ACTION"):
                return "TreatmentInapEdit";
            case Config("API_DELETE_ACTION"):
                return "TreatmentInapDelete";
            case Config("API_LIST_ACTION"):
                return "TreatmentInapList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "TreatmentInapList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("TreatmentInapView", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("TreatmentInapView", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "TreatmentInapAdd?" . $this->getUrlParm($parm);
        } else {
            $url = "TreatmentInapAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("TreatmentInapEdit", $this->getUrlParm($parm));
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
        $url = $this->keyUrl("TreatmentInapAdd", $this->getUrlParm($parm));
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
        return $this->keyUrl("TreatmentInapDelete", $this->getUrlParm());
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
            $url .= "&" . GetForeignKeyUrl("fk_VISITOR_ADDRESS", $this->THEADDRESS->CurrentValue ?? $this->THEADDRESS->getSessionValue());
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

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

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

        // KELUAR_ID
        $this->KELUAR_ID->LinkCustomAttributes = "";
        $this->KELUAR_ID->HrefValue = "";
        $this->KELUAR_ID->TooltipValue = "";

        // BED_ID
        $this->BED_ID->LinkCustomAttributes = "";
        $this->BED_ID->HrefValue = "";
        $this->BED_ID->TooltipValue = "";

        // EXIT_DATE
        $this->EXIT_DATE->LinkCustomAttributes = "";
        $this->EXIT_DATE->HrefValue = "";
        $this->EXIT_DATE->TooltipValue = "";

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

        // CLINIC_TYPE
        $this->CLINIC_TYPE->LinkCustomAttributes = "";
        $this->CLINIC_TYPE->HrefValue = "";
        $this->CLINIC_TYPE->TooltipValue = "";

        // ID_1
        $this->ID_1->LinkCustomAttributes = "";
        $this->ID_1->HrefValue = "";
        $this->ID_1->TooltipValue = "";

        // ORG_UNIT_CODE
        $this->ORG_UNIT_CODE->LinkCustomAttributes = "";
        $this->ORG_UNIT_CODE->HrefValue = "";
        $this->ORG_UNIT_CODE->TooltipValue = "";

        // BILL_ID_1
        $this->BILL_ID_1->LinkCustomAttributes = "";
        $this->BILL_ID_1->HrefValue = "";
        $this->BILL_ID_1->TooltipValue = "";

        // NO_REGISTRATION_1
        $this->NO_REGISTRATION_1->LinkCustomAttributes = "";
        $this->NO_REGISTRATION_1->HrefValue = "";
        $this->NO_REGISTRATION_1->TooltipValue = "";

        // VISIT_ID_1
        $this->VISIT_ID_1->LinkCustomAttributes = "";
        $this->VISIT_ID_1->HrefValue = "";
        $this->VISIT_ID_1->TooltipValue = "";

        // TARIF_ID_1
        $this->TARIF_ID_1->LinkCustomAttributes = "";
        $this->TARIF_ID_1->HrefValue = "";
        $this->TARIF_ID_1->TooltipValue = "";

        // CLASS_ID_1
        $this->CLASS_ID_1->LinkCustomAttributes = "";
        $this->CLASS_ID_1->HrefValue = "";
        $this->CLASS_ID_1->TooltipValue = "";

        // CLINIC_ID_1
        $this->CLINIC_ID_1->LinkCustomAttributes = "";
        $this->CLINIC_ID_1->HrefValue = "";
        $this->CLINIC_ID_1->TooltipValue = "";

        // CLINIC_ID_FROM_1
        $this->CLINIC_ID_FROM_1->LinkCustomAttributes = "";
        $this->CLINIC_ID_FROM_1->HrefValue = "";
        $this->CLINIC_ID_FROM_1->TooltipValue = "";

        // TREATMENT_1
        $this->TREATMENT_1->LinkCustomAttributes = "";
        $this->TREATMENT_1->HrefValue = "";
        $this->TREATMENT_1->TooltipValue = "";

        // TREAT_DATE_1
        $this->TREAT_DATE_1->LinkCustomAttributes = "";
        $this->TREAT_DATE_1->HrefValue = "";
        $this->TREAT_DATE_1->TooltipValue = "";

        // QUANTITY_1
        $this->QUANTITY_1->LinkCustomAttributes = "";
        $this->QUANTITY_1->HrefValue = "";
        $this->QUANTITY_1->TooltipValue = "";

        // MEASURE_ID
        $this->MEASURE_ID->LinkCustomAttributes = "";
        $this->MEASURE_ID->HrefValue = "";
        $this->MEASURE_ID->TooltipValue = "";

        // MEASURE_ID_1
        $this->MEASURE_ID_1->LinkCustomAttributes = "";
        $this->MEASURE_ID_1->HrefValue = "";
        $this->MEASURE_ID_1->TooltipValue = "";

        // TRANS_ID_1
        $this->TRANS_ID_1->LinkCustomAttributes = "";
        $this->TRANS_ID_1->HrefValue = "";
        $this->TRANS_ID_1->TooltipValue = "";

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

        // BILL_ID
        $this->BILL_ID->EditAttrs["class"] = "form-control";
        $this->BILL_ID->EditCustomAttributes = 'readonly';
        if (!$this->BILL_ID->Raw) {
            $this->BILL_ID->CurrentValue = HtmlDecode($this->BILL_ID->CurrentValue);
        }
        $this->BILL_ID->EditValue = $this->BILL_ID->CurrentValue;
        $this->BILL_ID->PlaceHolder = RemoveHtml($this->BILL_ID->caption());

        // NO_REGISTRATION
        $this->NO_REGISTRATION->EditAttrs["class"] = "form-control";
        $this->NO_REGISTRATION->EditCustomAttributes = "";
        if ($this->NO_REGISTRATION->getSessionValue() != "") {
            $this->NO_REGISTRATION->CurrentValue = GetForeignKeyValue($this->NO_REGISTRATION->getSessionValue());
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
        } else {
            $this->NO_REGISTRATION->PlaceHolder = RemoveHtml($this->NO_REGISTRATION->caption());
        }

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
        if (!$this->CLINIC_ID_FROM->Raw) {
            $this->CLINIC_ID_FROM->CurrentValue = HtmlDecode($this->CLINIC_ID_FROM->CurrentValue);
        }
        $this->CLINIC_ID_FROM->EditValue = $this->CLINIC_ID_FROM->CurrentValue;
        $this->CLINIC_ID_FROM->PlaceHolder = RemoveHtml($this->CLINIC_ID_FROM->caption());

        // TREATMENT
        $this->TREATMENT->EditAttrs["class"] = "form-control";
        $this->TREATMENT->EditCustomAttributes = "";
        if (!$this->TREATMENT->Raw) {
            $this->TREATMENT->CurrentValue = HtmlDecode($this->TREATMENT->CurrentValue);
        }
        $this->TREATMENT->EditValue = $this->TREATMENT->CurrentValue;
        $this->TREATMENT->PlaceHolder = RemoveHtml($this->TREATMENT->caption());

        // TREAT_DATE
        $this->TREAT_DATE->EditAttrs["class"] = "form-control";
        $this->TREAT_DATE->EditCustomAttributes = "";
        $this->TREAT_DATE->EditValue = FormatDateTime($this->TREAT_DATE->CurrentValue, 11);
        $this->TREAT_DATE->PlaceHolder = RemoveHtml($this->TREAT_DATE->caption());

        // QUANTITY
        $this->QUANTITY->EditAttrs["class"] = "form-control";
        $this->QUANTITY->EditCustomAttributes = "";
        $this->QUANTITY->EditValue = $this->QUANTITY->CurrentValue;
        $this->QUANTITY->PlaceHolder = RemoveHtml($this->QUANTITY->caption());
        if (strval($this->QUANTITY->EditValue) != "" && is_numeric($this->QUANTITY->EditValue)) {
            $this->QUANTITY->EditValue = FormatNumber($this->QUANTITY->EditValue, -2, -2, -2, -2);
        }

        // KELUAR_ID
        $this->KELUAR_ID->EditAttrs["class"] = "form-control";
        $this->KELUAR_ID->EditCustomAttributes = "";
        $this->KELUAR_ID->EditValue = $this->KELUAR_ID->CurrentValue;
        $this->KELUAR_ID->PlaceHolder = RemoveHtml($this->KELUAR_ID->caption());

        // BED_ID
        $this->BED_ID->EditAttrs["class"] = "form-control";
        $this->BED_ID->EditCustomAttributes = "";
        $this->BED_ID->EditValue = $this->BED_ID->CurrentValue;
        $this->BED_ID->PlaceHolder = RemoveHtml($this->BED_ID->caption());

        // EXIT_DATE
        $this->EXIT_DATE->EditAttrs["class"] = "form-control";
        $this->EXIT_DATE->EditCustomAttributes = "";
        $this->EXIT_DATE->EditValue = FormatDateTime($this->EXIT_DATE->CurrentValue, 8);
        $this->EXIT_DATE->PlaceHolder = RemoveHtml($this->EXIT_DATE->caption());

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
        if ($this->THEADDRESS->getSessionValue() != "") {
            $this->THEADDRESS->CurrentValue = GetForeignKeyValue($this->THEADDRESS->getSessionValue());
            $this->THEADDRESS->ViewValue = $this->THEADDRESS->CurrentValue;
            $this->THEADDRESS->ViewCustomAttributes = "";
        } else {
            if (!$this->THEADDRESS->Raw) {
                $this->THEADDRESS->CurrentValue = HtmlDecode($this->THEADDRESS->CurrentValue);
            }
            $this->THEADDRESS->EditValue = $this->THEADDRESS->CurrentValue;
            $this->THEADDRESS->PlaceHolder = RemoveHtml($this->THEADDRESS->caption());
        }

        // THEID
        $this->THEID->EditAttrs["class"] = "form-control";
        $this->THEID->EditCustomAttributes = "";
        if (!$this->THEID->Raw) {
            $this->THEID->CurrentValue = HtmlDecode($this->THEID->CurrentValue);
        }
        $this->THEID->EditValue = $this->THEID->CurrentValue;
        $this->THEID->PlaceHolder = RemoveHtml($this->THEID->caption());

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

        // ID
        $this->ID->EditAttrs["class"] = "form-control";
        $this->ID->EditCustomAttributes = "";
        $this->ID->EditValue = $this->ID->CurrentValue;
        $this->ID->ViewCustomAttributes = "";

        // AMOUNT
        $this->AMOUNT->EditAttrs["class"] = "form-control";
        $this->AMOUNT->EditCustomAttributes = "";
        $this->AMOUNT->EditValue = $this->AMOUNT->CurrentValue;
        $this->AMOUNT->PlaceHolder = RemoveHtml($this->AMOUNT->caption());
        if (strval($this->AMOUNT->EditValue) != "" && is_numeric($this->AMOUNT->EditValue)) {
            $this->AMOUNT->EditValue = FormatNumber($this->AMOUNT->EditValue, -2, -2, -2, -2);
        }

        // POKOK_JUAL
        $this->POKOK_JUAL->EditAttrs["class"] = "form-control";
        $this->POKOK_JUAL->EditCustomAttributes = "";
        $this->POKOK_JUAL->EditValue = $this->POKOK_JUAL->CurrentValue;
        $this->POKOK_JUAL->PlaceHolder = RemoveHtml($this->POKOK_JUAL->caption());
        if (strval($this->POKOK_JUAL->EditValue) != "" && is_numeric($this->POKOK_JUAL->EditValue)) {
            $this->POKOK_JUAL->EditValue = FormatNumber($this->POKOK_JUAL->EditValue, -2, -2, -2, -2);
        }

        // PPN
        $this->PPN->EditAttrs["class"] = "form-control";
        $this->PPN->EditCustomAttributes = "";
        $this->PPN->EditValue = $this->PPN->CurrentValue;
        $this->PPN->PlaceHolder = RemoveHtml($this->PPN->caption());
        if (strval($this->PPN->EditValue) != "" && is_numeric($this->PPN->EditValue)) {
            $this->PPN->EditValue = FormatNumber($this->PPN->EditValue, -2, -2, -2, -2);
        }

        // SUBSIDI
        $this->SUBSIDI->EditAttrs["class"] = "form-control";
        $this->SUBSIDI->EditCustomAttributes = "";
        $this->SUBSIDI->EditValue = $this->SUBSIDI->CurrentValue;
        $this->SUBSIDI->PlaceHolder = RemoveHtml($this->SUBSIDI->caption());
        if (strval($this->SUBSIDI->EditValue) != "" && is_numeric($this->SUBSIDI->EditValue)) {
            $this->SUBSIDI->EditValue = FormatNumber($this->SUBSIDI->EditValue, -2, -2, -2, -2);
        }

        // PRINT_DATE
        $this->PRINT_DATE->EditAttrs["class"] = "form-control";
        $this->PRINT_DATE->EditCustomAttributes = "";
        $this->PRINT_DATE->EditValue = FormatDateTime($this->PRINT_DATE->CurrentValue, 8);
        $this->PRINT_DATE->PlaceHolder = RemoveHtml($this->PRINT_DATE->caption());

        // ISCETAK
        $this->ISCETAK->EditAttrs["class"] = "form-control";
        $this->ISCETAK->EditCustomAttributes = "";
        if (!$this->ISCETAK->Raw) {
            $this->ISCETAK->CurrentValue = HtmlDecode($this->ISCETAK->CurrentValue);
        }
        $this->ISCETAK->EditValue = $this->ISCETAK->CurrentValue;
        $this->ISCETAK->PlaceHolder = RemoveHtml($this->ISCETAK->caption());

        // NOTA_NO
        $this->NOTA_NO->EditAttrs["class"] = "form-control";
        $this->NOTA_NO->EditCustomAttributes = "";
        if (!$this->NOTA_NO->Raw) {
            $this->NOTA_NO->CurrentValue = HtmlDecode($this->NOTA_NO->CurrentValue);
        }
        $this->NOTA_NO->EditValue = $this->NOTA_NO->CurrentValue;
        $this->NOTA_NO->PlaceHolder = RemoveHtml($this->NOTA_NO->caption());

        // KUITANSI_ID
        $this->KUITANSI_ID->EditAttrs["class"] = "form-control";
        $this->KUITANSI_ID->EditCustomAttributes = "";
        if (!$this->KUITANSI_ID->Raw) {
            $this->KUITANSI_ID->CurrentValue = HtmlDecode($this->KUITANSI_ID->CurrentValue);
        }
        $this->KUITANSI_ID->EditValue = $this->KUITANSI_ID->CurrentValue;
        $this->KUITANSI_ID->PlaceHolder = RemoveHtml($this->KUITANSI_ID->caption());

        // amount_paid
        $this->amount_paid->EditAttrs["class"] = "form-control";
        $this->amount_paid->EditCustomAttributes = "";
        $this->amount_paid->EditValue = $this->amount_paid->CurrentValue;
        $this->amount_paid->PlaceHolder = RemoveHtml($this->amount_paid->caption());
        if (strval($this->amount_paid->EditValue) != "" && is_numeric($this->amount_paid->EditValue)) {
            $this->amount_paid->EditValue = FormatNumber($this->amount_paid->EditValue, -2, -2, -2, -2);
        }

        // sell_price
        $this->sell_price->EditAttrs["class"] = "form-control";
        $this->sell_price->EditCustomAttributes = "";
        $this->sell_price->EditValue = $this->sell_price->CurrentValue;
        $this->sell_price->PlaceHolder = RemoveHtml($this->sell_price->caption());
        if (strval($this->sell_price->EditValue) != "" && is_numeric($this->sell_price->EditValue)) {
            $this->sell_price->EditValue = FormatNumber($this->sell_price->EditValue, -2, -2, -2, -2);
        }

        // diskon
        $this->diskon->EditAttrs["class"] = "form-control";
        $this->diskon->EditCustomAttributes = "";
        $this->diskon->EditValue = $this->diskon->CurrentValue;
        $this->diskon->PlaceHolder = RemoveHtml($this->diskon->caption());
        if (strval($this->diskon->EditValue) != "" && is_numeric($this->diskon->EditValue)) {
            $this->diskon->EditValue = FormatNumber($this->diskon->EditValue, -2, -2, -2, -2);
        }

        // TAGIHAN
        $this->TAGIHAN->EditAttrs["class"] = "form-control";
        $this->TAGIHAN->EditCustomAttributes = "";
        $this->TAGIHAN->EditValue = $this->TAGIHAN->CurrentValue;
        $this->TAGIHAN->PlaceHolder = RemoveHtml($this->TAGIHAN->caption());
        if (strval($this->TAGIHAN->EditValue) != "" && is_numeric($this->TAGIHAN->EditValue)) {
            $this->TAGIHAN->EditValue = FormatNumber($this->TAGIHAN->EditValue, -2, -2, -2, -2);
        }

        // CLINIC_TYPE
        $this->CLINIC_TYPE->EditAttrs["class"] = "form-control";
        $this->CLINIC_TYPE->EditCustomAttributes = "";
        $this->CLINIC_TYPE->EditValue = $this->CLINIC_TYPE->CurrentValue;
        $this->CLINIC_TYPE->PlaceHolder = RemoveHtml($this->CLINIC_TYPE->caption());

        // ID_1
        $this->ID_1->EditAttrs["class"] = "form-control";
        $this->ID_1->EditCustomAttributes = "";
        $this->ID_1->EditValue = $this->ID_1->CurrentValue;
        $this->ID_1->PlaceHolder = RemoveHtml($this->ID_1->caption());

        // ORG_UNIT_CODE
        $this->ORG_UNIT_CODE->EditAttrs["class"] = "form-control";
        $this->ORG_UNIT_CODE->EditCustomAttributes = "";
        if (!$this->ORG_UNIT_CODE->Raw) {
            $this->ORG_UNIT_CODE->CurrentValue = HtmlDecode($this->ORG_UNIT_CODE->CurrentValue);
        }
        $this->ORG_UNIT_CODE->EditValue = $this->ORG_UNIT_CODE->CurrentValue;
        $this->ORG_UNIT_CODE->PlaceHolder = RemoveHtml($this->ORG_UNIT_CODE->caption());

        // BILL_ID_1
        $this->BILL_ID_1->EditAttrs["class"] = "form-control";
        $this->BILL_ID_1->EditCustomAttributes = "";
        if (!$this->BILL_ID_1->Raw) {
            $this->BILL_ID_1->CurrentValue = HtmlDecode($this->BILL_ID_1->CurrentValue);
        }
        $this->BILL_ID_1->EditValue = $this->BILL_ID_1->CurrentValue;
        $this->BILL_ID_1->PlaceHolder = RemoveHtml($this->BILL_ID_1->caption());

        // NO_REGISTRATION_1
        $this->NO_REGISTRATION_1->EditAttrs["class"] = "form-control";
        $this->NO_REGISTRATION_1->EditCustomAttributes = "";
        if (!$this->NO_REGISTRATION_1->Raw) {
            $this->NO_REGISTRATION_1->CurrentValue = HtmlDecode($this->NO_REGISTRATION_1->CurrentValue);
        }
        $this->NO_REGISTRATION_1->EditValue = $this->NO_REGISTRATION_1->CurrentValue;
        $this->NO_REGISTRATION_1->PlaceHolder = RemoveHtml($this->NO_REGISTRATION_1->caption());

        // VISIT_ID_1
        $this->VISIT_ID_1->EditAttrs["class"] = "form-control";
        $this->VISIT_ID_1->EditCustomAttributes = "";
        if (!$this->VISIT_ID_1->Raw) {
            $this->VISIT_ID_1->CurrentValue = HtmlDecode($this->VISIT_ID_1->CurrentValue);
        }
        $this->VISIT_ID_1->EditValue = $this->VISIT_ID_1->CurrentValue;
        $this->VISIT_ID_1->PlaceHolder = RemoveHtml($this->VISIT_ID_1->caption());

        // TARIF_ID_1
        $this->TARIF_ID_1->EditAttrs["class"] = "form-control";
        $this->TARIF_ID_1->EditCustomAttributes = "";
        if (!$this->TARIF_ID_1->Raw) {
            $this->TARIF_ID_1->CurrentValue = HtmlDecode($this->TARIF_ID_1->CurrentValue);
        }
        $this->TARIF_ID_1->EditValue = $this->TARIF_ID_1->CurrentValue;
        $this->TARIF_ID_1->PlaceHolder = RemoveHtml($this->TARIF_ID_1->caption());

        // CLASS_ID_1
        $this->CLASS_ID_1->EditAttrs["class"] = "form-control";
        $this->CLASS_ID_1->EditCustomAttributes = "";
        $this->CLASS_ID_1->EditValue = $this->CLASS_ID_1->CurrentValue;
        $this->CLASS_ID_1->PlaceHolder = RemoveHtml($this->CLASS_ID_1->caption());

        // CLINIC_ID_1
        $this->CLINIC_ID_1->EditAttrs["class"] = "form-control";
        $this->CLINIC_ID_1->EditCustomAttributes = "";
        if (!$this->CLINIC_ID_1->Raw) {
            $this->CLINIC_ID_1->CurrentValue = HtmlDecode($this->CLINIC_ID_1->CurrentValue);
        }
        $this->CLINIC_ID_1->EditValue = $this->CLINIC_ID_1->CurrentValue;
        $this->CLINIC_ID_1->PlaceHolder = RemoveHtml($this->CLINIC_ID_1->caption());

        // CLINIC_ID_FROM_1
        $this->CLINIC_ID_FROM_1->EditAttrs["class"] = "form-control";
        $this->CLINIC_ID_FROM_1->EditCustomAttributes = "";
        if (!$this->CLINIC_ID_FROM_1->Raw) {
            $this->CLINIC_ID_FROM_1->CurrentValue = HtmlDecode($this->CLINIC_ID_FROM_1->CurrentValue);
        }
        $this->CLINIC_ID_FROM_1->EditValue = $this->CLINIC_ID_FROM_1->CurrentValue;
        $this->CLINIC_ID_FROM_1->PlaceHolder = RemoveHtml($this->CLINIC_ID_FROM_1->caption());

        // TREATMENT_1
        $this->TREATMENT_1->EditAttrs["class"] = "form-control";
        $this->TREATMENT_1->EditCustomAttributes = "";
        if (!$this->TREATMENT_1->Raw) {
            $this->TREATMENT_1->CurrentValue = HtmlDecode($this->TREATMENT_1->CurrentValue);
        }
        $this->TREATMENT_1->EditValue = $this->TREATMENT_1->CurrentValue;
        $this->TREATMENT_1->PlaceHolder = RemoveHtml($this->TREATMENT_1->caption());

        // TREAT_DATE_1
        $this->TREAT_DATE_1->EditAttrs["class"] = "form-control";
        $this->TREAT_DATE_1->EditCustomAttributes = "";
        $this->TREAT_DATE_1->EditValue = FormatDateTime($this->TREAT_DATE_1->CurrentValue, 8);
        $this->TREAT_DATE_1->PlaceHolder = RemoveHtml($this->TREAT_DATE_1->caption());

        // QUANTITY_1
        $this->QUANTITY_1->EditAttrs["class"] = "form-control";
        $this->QUANTITY_1->EditCustomAttributes = "";
        $this->QUANTITY_1->EditValue = $this->QUANTITY_1->CurrentValue;
        $this->QUANTITY_1->PlaceHolder = RemoveHtml($this->QUANTITY_1->caption());
        if (strval($this->QUANTITY_1->EditValue) != "" && is_numeric($this->QUANTITY_1->EditValue)) {
            $this->QUANTITY_1->EditValue = FormatNumber($this->QUANTITY_1->EditValue, -2, -2, -2, -2);
        }

        // MEASURE_ID
        $this->MEASURE_ID->EditAttrs["class"] = "form-control";
        $this->MEASURE_ID->EditCustomAttributes = "";
        $this->MEASURE_ID->EditValue = $this->MEASURE_ID->CurrentValue;
        $this->MEASURE_ID->PlaceHolder = RemoveHtml($this->MEASURE_ID->caption());

        // MEASURE_ID_1
        $this->MEASURE_ID_1->EditAttrs["class"] = "form-control";
        $this->MEASURE_ID_1->EditCustomAttributes = "";
        $this->MEASURE_ID_1->EditValue = $this->MEASURE_ID_1->CurrentValue;
        $this->MEASURE_ID_1->PlaceHolder = RemoveHtml($this->MEASURE_ID_1->caption());

        // TRANS_ID_1
        $this->TRANS_ID_1->EditAttrs["class"] = "form-control";
        $this->TRANS_ID_1->EditCustomAttributes = "";
        if (!$this->TRANS_ID_1->Raw) {
            $this->TRANS_ID_1->CurrentValue = HtmlDecode($this->TRANS_ID_1->CurrentValue);
        }
        $this->TRANS_ID_1->EditValue = $this->TRANS_ID_1->CurrentValue;
        $this->TRANS_ID_1->PlaceHolder = RemoveHtml($this->TRANS_ID_1->caption());

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
                    $doc->exportCaption($this->TARIF_ID);
                    $doc->exportCaption($this->CLINIC_ID);
                    $doc->exportCaption($this->TREATMENT);
                    $doc->exportCaption($this->QUANTITY);
                    $doc->exportCaption($this->TRANS_ID);
                    $doc->exportCaption($this->ID);
                    $doc->exportCaption($this->AMOUNT);
                    $doc->exportCaption($this->POKOK_JUAL);
                    $doc->exportCaption($this->PPN);
                    $doc->exportCaption($this->SUBSIDI);
                    $doc->exportCaption($this->PRINT_DATE);
                    $doc->exportCaption($this->ISCETAK);
                    $doc->exportCaption($this->NOTA_NO);
                    $doc->exportCaption($this->KUITANSI_ID);
                    $doc->exportCaption($this->amount_paid);
                    $doc->exportCaption($this->sell_price);
                    $doc->exportCaption($this->diskon);
                    $doc->exportCaption($this->TAGIHAN);
                    $doc->exportCaption($this->CLINIC_TYPE);
                    $doc->exportCaption($this->ID_1);
                    $doc->exportCaption($this->ORG_UNIT_CODE);
                    $doc->exportCaption($this->BILL_ID_1);
                    $doc->exportCaption($this->NO_REGISTRATION_1);
                    $doc->exportCaption($this->VISIT_ID_1);
                    $doc->exportCaption($this->TARIF_ID_1);
                    $doc->exportCaption($this->CLASS_ID_1);
                    $doc->exportCaption($this->CLINIC_ID_1);
                    $doc->exportCaption($this->CLINIC_ID_FROM_1);
                    $doc->exportCaption($this->TREATMENT_1);
                    $doc->exportCaption($this->TREAT_DATE_1);
                    $doc->exportCaption($this->QUANTITY_1);
                    $doc->exportCaption($this->MEASURE_ID);
                    $doc->exportCaption($this->MEASURE_ID_1);
                    $doc->exportCaption($this->TRANS_ID_1);
                } else {
                    $doc->exportCaption($this->NO_REGISTRATION);
                    $doc->exportCaption($this->VISIT_ID);
                    $doc->exportCaption($this->TARIF_ID);
                    $doc->exportCaption($this->CLASS_ID);
                    $doc->exportCaption($this->CLINIC_ID);
                    $doc->exportCaption($this->CLINIC_ID_FROM);
                    $doc->exportCaption($this->TREATMENT);
                    $doc->exportCaption($this->TREAT_DATE);
                    $doc->exportCaption($this->QUANTITY);
                    $doc->exportCaption($this->KELUAR_ID);
                    $doc->exportCaption($this->BED_ID);
                    $doc->exportCaption($this->EXIT_DATE);
                    $doc->exportCaption($this->THENAME);
                    $doc->exportCaption($this->THEADDRESS);
                    $doc->exportCaption($this->THEID);
                    $doc->exportCaption($this->TRANS_ID);
                    $doc->exportCaption($this->ID);
                    $doc->exportCaption($this->AMOUNT);
                    $doc->exportCaption($this->POKOK_JUAL);
                    $doc->exportCaption($this->PPN);
                    $doc->exportCaption($this->SUBSIDI);
                    $doc->exportCaption($this->PRINT_DATE);
                    $doc->exportCaption($this->ISCETAK);
                    $doc->exportCaption($this->NOTA_NO);
                    $doc->exportCaption($this->KUITANSI_ID);
                    $doc->exportCaption($this->amount_paid);
                    $doc->exportCaption($this->sell_price);
                    $doc->exportCaption($this->diskon);
                    $doc->exportCaption($this->TAGIHAN);
                    $doc->exportCaption($this->CLINIC_TYPE);
                    $doc->exportCaption($this->ID_1);
                    $doc->exportCaption($this->ORG_UNIT_CODE);
                    $doc->exportCaption($this->BILL_ID_1);
                    $doc->exportCaption($this->NO_REGISTRATION_1);
                    $doc->exportCaption($this->VISIT_ID_1);
                    $doc->exportCaption($this->TARIF_ID_1);
                    $doc->exportCaption($this->CLASS_ID_1);
                    $doc->exportCaption($this->CLINIC_ID_1);
                    $doc->exportCaption($this->CLINIC_ID_FROM_1);
                    $doc->exportCaption($this->TREATMENT_1);
                    $doc->exportCaption($this->TREAT_DATE_1);
                    $doc->exportCaption($this->QUANTITY_1);
                    $doc->exportCaption($this->MEASURE_ID);
                    $doc->exportCaption($this->MEASURE_ID_1);
                    $doc->exportCaption($this->TRANS_ID_1);
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
                        $doc->exportField($this->TARIF_ID);
                        $doc->exportField($this->CLINIC_ID);
                        $doc->exportField($this->TREATMENT);
                        $doc->exportField($this->QUANTITY);
                        $doc->exportField($this->TRANS_ID);
                        $doc->exportField($this->ID);
                        $doc->exportField($this->AMOUNT);
                        $doc->exportField($this->POKOK_JUAL);
                        $doc->exportField($this->PPN);
                        $doc->exportField($this->SUBSIDI);
                        $doc->exportField($this->PRINT_DATE);
                        $doc->exportField($this->ISCETAK);
                        $doc->exportField($this->NOTA_NO);
                        $doc->exportField($this->KUITANSI_ID);
                        $doc->exportField($this->amount_paid);
                        $doc->exportField($this->sell_price);
                        $doc->exportField($this->diskon);
                        $doc->exportField($this->TAGIHAN);
                        $doc->exportField($this->CLINIC_TYPE);
                        $doc->exportField($this->ID_1);
                        $doc->exportField($this->ORG_UNIT_CODE);
                        $doc->exportField($this->BILL_ID_1);
                        $doc->exportField($this->NO_REGISTRATION_1);
                        $doc->exportField($this->VISIT_ID_1);
                        $doc->exportField($this->TARIF_ID_1);
                        $doc->exportField($this->CLASS_ID_1);
                        $doc->exportField($this->CLINIC_ID_1);
                        $doc->exportField($this->CLINIC_ID_FROM_1);
                        $doc->exportField($this->TREATMENT_1);
                        $doc->exportField($this->TREAT_DATE_1);
                        $doc->exportField($this->QUANTITY_1);
                        $doc->exportField($this->MEASURE_ID);
                        $doc->exportField($this->MEASURE_ID_1);
                        $doc->exportField($this->TRANS_ID_1);
                    } else {
                        $doc->exportField($this->NO_REGISTRATION);
                        $doc->exportField($this->VISIT_ID);
                        $doc->exportField($this->TARIF_ID);
                        $doc->exportField($this->CLASS_ID);
                        $doc->exportField($this->CLINIC_ID);
                        $doc->exportField($this->CLINIC_ID_FROM);
                        $doc->exportField($this->TREATMENT);
                        $doc->exportField($this->TREAT_DATE);
                        $doc->exportField($this->QUANTITY);
                        $doc->exportField($this->KELUAR_ID);
                        $doc->exportField($this->BED_ID);
                        $doc->exportField($this->EXIT_DATE);
                        $doc->exportField($this->THENAME);
                        $doc->exportField($this->THEADDRESS);
                        $doc->exportField($this->THEID);
                        $doc->exportField($this->TRANS_ID);
                        $doc->exportField($this->ID);
                        $doc->exportField($this->AMOUNT);
                        $doc->exportField($this->POKOK_JUAL);
                        $doc->exportField($this->PPN);
                        $doc->exportField($this->SUBSIDI);
                        $doc->exportField($this->PRINT_DATE);
                        $doc->exportField($this->ISCETAK);
                        $doc->exportField($this->NOTA_NO);
                        $doc->exportField($this->KUITANSI_ID);
                        $doc->exportField($this->amount_paid);
                        $doc->exportField($this->sell_price);
                        $doc->exportField($this->diskon);
                        $doc->exportField($this->TAGIHAN);
                        $doc->exportField($this->CLINIC_TYPE);
                        $doc->exportField($this->ID_1);
                        $doc->exportField($this->ORG_UNIT_CODE);
                        $doc->exportField($this->BILL_ID_1);
                        $doc->exportField($this->NO_REGISTRATION_1);
                        $doc->exportField($this->VISIT_ID_1);
                        $doc->exportField($this->TARIF_ID_1);
                        $doc->exportField($this->CLASS_ID_1);
                        $doc->exportField($this->CLINIC_ID_1);
                        $doc->exportField($this->CLINIC_ID_FROM_1);
                        $doc->exportField($this->TREATMENT_1);
                        $doc->exportField($this->TREAT_DATE_1);
                        $doc->exportField($this->QUANTITY_1);
                        $doc->exportField($this->MEASURE_ID);
                        $doc->exportField($this->MEASURE_ID_1);
                        $doc->exportField($this->TRANS_ID_1);
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
