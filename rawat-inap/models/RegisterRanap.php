<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

use Doctrine\DBAL\ParameterType;

/**
 * Table class for register_ranap
 */
class RegisterRanap extends ReportTable
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
    public $ShowGroupHeaderAsRow = false;
    public $ShowCompactSummaryFooter = true;

    // Export
    public $ExportDoc;

    // Fields
    public $NO_REGISTRATION;
    public $GENDER;
    public $CLASS_ROOM_ID;
    public $BED_ID;
    public $SERVED_INAP;
    public $STATUS_PASIEN_ID;
    public $ISRJ;
    public $VISIT_ID;
    public $IDXDAFTAR;
    public $DIANTAR_OLEH;
    public $EXIT_DATE;
    public $KELUAR_ID;
    public $AGEYEAR;
    public $ORG_UNIT_CODE;
    public $RUJUKAN_ID;
    public $ADDRESS_OF_RUJUKAN;
    public $REASON_ID;
    public $WAY_ID;
    public $PATIENT_CATEGORY_ID;
    public $BOOKED_DATE;
    public $VISIT_DATE;
    public $ISNEW;
    public $FOLLOW_UP;
    public $PLACE_TYPE;
    public $CLINIC_ID;
    public $CLINIC_ID_FROM;
    public $IN_DATE;
    public $DESCRIPTION;
    public $VISITOR_ADDRESS;
    public $MODIFIED_BY;
    public $MODIFIED_DATE;
    public $MODIFIED_FROM;
    public $EMPLOYEE_ID;
    public $EMPLOYEE_ID_FROM;
    public $RESPONSIBLE_ID;
    public $RESPONSIBLE;
    public $FAMILY_STATUS_ID;
    public $TICKET_NO;
    public $ISATTENDED;
    public $PAYOR_ID;
    public $CLASS_ID;
    public $ISPERTARIF;
    public $KAL_ID;
    public $EMPLOYEE_INAP;
    public $PASIEN_ID;
    public $KARYAWAN;
    public $ACCOUNT_ID;
    public $CLASS_ID_PLAFOND;
    public $BACKCHARGE;
    public $COVERAGE_ID;
    public $AGEMONTH;
    public $AGEDAY;
    public $RECOMENDATION;
    public $CONCLUSION;
    public $SPECIMENNO;
    public $LOCKED;
    public $RM_OUT_DATE;
    public $RM_IN_DATE;
    public $LAMA_PINJAM;
    public $STANDAR_RJ;
    public $LENGKAP_RJ;
    public $LENGKAP_RI;
    public $RESEND_RM_DATE;
    public $LENGKAP_RM1;
    public $LENGKAP_RESUME;
    public $LENGKAP_ANAMNESIS;
    public $LENGKAP_CONSENT;
    public $LENGKAP_ANESTESI;
    public $LENGKAP_OP;
    public $BACK_RM_DATE;
    public $VALID_RM_DATE;
    public $NO_SKP;
    public $NO_SKPINAP;
    public $DIAGNOSA_ID;
    public $ticket_all;
    public $tanggal_rujukan;
    public $NORUJUKAN;
    public $PPKRUJUKAN;
    public $LOKASILAKA;
    public $KDPOLI;
    public $EDIT_SEP;
    public $DELETE_SEP;
    public $KODE_AGAMA;
    public $DIAG_AWAL;
    public $AKTIF;
    public $BILL_INAP;
    public $SEP_PRINTDATE;
    public $MAPPING_SEP;
    public $TRANS_ID;
    public $KDPOLI_EKS;
    public $COB;
    public $PENJAMIN;
    public $ASALRUJUKAN;
    public $RESPONSEP;
    public $APPROVAL_DESC;
    public $APPROVAL_RESPONAJUKAN;
    public $APPROVAL_RESPONAPPROV;
    public $RESPONTGLPLG_DESC;
    public $RESPONPOST_VKLAIM;
    public $RESPONPUT_VKLAIM;
    public $RESPONDEL_VKLAIM;
    public $CALL_TIMES;
    public $CALL_DATE;
    public $CALL_DATES;
    public $SERVED_DATE;
    public $KDDPJP1;
    public $KDDPJP;
    public $tgl_kontrol;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'register_ranap';
        $this->TableName = 'register_ranap';
        $this->TableType = 'REPORT';

        // Update Table
        $this->UpdateTable = "dbo.PASIEN_VISITATION";
        $this->ReportSourceTable = 'V_KUNJUNGAN_PASIEN'; // Report source table
        $this->Dbid = 'DB';
        $this->ExportAll = true;
        $this->ExportPageBreakCount = 0; // Page break per every n record (report only)
        $this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
        $this->ExportPageSize = "a4"; // Page size (PDF only)
        $this->ExportExcelPageOrientation = ""; // Page orientation (PhpSpreadsheet only)
        $this->ExportExcelPageSize = ""; // Page size (PhpSpreadsheet only)
        $this->ExportWordPageOrientation = "portrait"; // Page orientation (PHPWord only)
        $this->ExportWordColumnWidth = null; // Cell width (PHPWord only)
        $this->UserIDAllowSecurity = Config("DEFAULT_USER_ID_ALLOW_SECURITY"); // Default User ID allowed permissions

        // NO_REGISTRATION
        $this->NO_REGISTRATION = new ReportField('register_ranap', 'register_ranap', 'x_NO_REGISTRATION', 'NO_REGISTRATION', '[NO_REGISTRATION]', '[NO_REGISTRATION]', 200, 50, -1, false, '[NO_REGISTRATION]', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->NO_REGISTRATION->Nullable = false; // NOT NULL field
        $this->NO_REGISTRATION->Required = true; // Required field
        $this->NO_REGISTRATION->Sortable = true; // Allow sort
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
        $this->NO_REGISTRATION->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['NO_REGISTRATION'] = &$this->NO_REGISTRATION;

        // GENDER
        $this->GENDER = new ReportField('register_ranap', 'register_ranap', 'x_GENDER', 'GENDER', '[GENDER]', '[GENDER]', 129, 1, -1, false, '[GENDER]', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->GENDER->Sortable = true; // Allow sort
        $this->GENDER->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->GENDER->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->GENDER->Lookup = new Lookup('GENDER', 'SEX', false, 'GENDER', ["NAME_OF_GENDER","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->GENDER->Lookup = new Lookup('GENDER', 'SEX', false, 'GENDER', ["NAME_OF_GENDER","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->GENDER->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->GENDER->Param, "CustomMsg");
        $this->GENDER->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['GENDER'] = &$this->GENDER;

        // CLASS_ROOM_ID
        $this->CLASS_ROOM_ID = new ReportField('register_ranap', 'register_ranap', 'x_CLASS_ROOM_ID', 'CLASS_ROOM_ID', '[CLASS_ROOM_ID]', '[CLASS_ROOM_ID]', 200, 16, -1, false, '[CLASS_ROOM_ID]', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->CLASS_ROOM_ID->Sortable = true; // Allow sort
        $this->CLASS_ROOM_ID->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->CLASS_ROOM_ID->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->CLASS_ROOM_ID->Lookup = new Lookup('CLASS_ROOM_ID', 'CLASS_ROOM', false, 'CLASS_ROOM_ID', ["NAME_OF_CLASS","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->CLASS_ROOM_ID->Lookup = new Lookup('CLASS_ROOM_ID', 'CLASS_ROOM', false, 'CLASS_ROOM_ID', ["NAME_OF_CLASS","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->CLASS_ROOM_ID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->CLASS_ROOM_ID->Param, "CustomMsg");
        $this->CLASS_ROOM_ID->AdvancedSearch->SearchValueDefault = INIT_VALUE;
        $this->CLASS_ROOM_ID->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['CLASS_ROOM_ID'] = &$this->CLASS_ROOM_ID;

        // BED_ID
        $this->BED_ID = new ReportField('register_ranap', 'register_ranap', 'x_BED_ID', 'BED_ID', '[BED_ID]', 'CAST([BED_ID] AS NVARCHAR)', 17, 1, -1, false, '[BED_ID]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->BED_ID->Sortable = true; // Allow sort
        $this->BED_ID->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->BED_ID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->BED_ID->Param, "CustomMsg");
        $this->BED_ID->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['BED_ID'] = &$this->BED_ID;

        // SERVED_INAP
        $this->SERVED_INAP = new ReportField('register_ranap', 'register_ranap', 'x_SERVED_INAP', 'SERVED_INAP', '[SERVED_INAP]', CastDateFieldForLike("[SERVED_INAP]", 7, "DB"), 135, 8, 7, false, '[SERVED_INAP]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->SERVED_INAP->Sortable = true; // Allow sort
        $this->SERVED_INAP->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_SEPARATOR"], $Language->phrase("IncorrectDateDMY"));
        $this->SERVED_INAP->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->SERVED_INAP->Param, "CustomMsg");
        $this->SERVED_INAP->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['SERVED_INAP'] = &$this->SERVED_INAP;

        // STATUS_PASIEN_ID
        $this->STATUS_PASIEN_ID = new ReportField('register_ranap', 'register_ranap', 'x_STATUS_PASIEN_ID', 'STATUS_PASIEN_ID', '[STATUS_PASIEN_ID]', 'CAST([STATUS_PASIEN_ID] AS NVARCHAR)', 17, 1, -1, false, '[STATUS_PASIEN_ID]', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->STATUS_PASIEN_ID->Sortable = true; // Allow sort
        $this->STATUS_PASIEN_ID->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->STATUS_PASIEN_ID->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->STATUS_PASIEN_ID->Lookup = new Lookup('STATUS_PASIEN_ID', 'STATUS_PASIEN', false, 'STATUS_PASIEN_ID', ["NAME_OF_STATUS_PASIEN","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->STATUS_PASIEN_ID->Lookup = new Lookup('STATUS_PASIEN_ID', 'STATUS_PASIEN', false, 'STATUS_PASIEN_ID', ["NAME_OF_STATUS_PASIEN","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->STATUS_PASIEN_ID->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->STATUS_PASIEN_ID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->STATUS_PASIEN_ID->Param, "CustomMsg");
        $this->STATUS_PASIEN_ID->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['STATUS_PASIEN_ID'] = &$this->STATUS_PASIEN_ID;

        // ISRJ
        $this->ISRJ = new ReportField('register_ranap', 'register_ranap', 'x_ISRJ', 'ISRJ', '[ISRJ]', '[ISRJ]', 129, 1, -1, false, '[ISRJ]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->ISRJ->Sortable = true; // Allow sort
        $this->ISRJ->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->ISRJ->Param, "CustomMsg");
        $this->ISRJ->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['ISRJ'] = &$this->ISRJ;

        // VISIT_ID
        $this->VISIT_ID = new ReportField('register_ranap', 'register_ranap', 'x_VISIT_ID', 'VISIT_ID', '[VISIT_ID]', '[VISIT_ID]', 200, 50, -1, false, '[VISIT_ID]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->VISIT_ID->Required = true; // Required field
        $this->VISIT_ID->Sortable = true; // Allow sort
        $this->VISIT_ID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->VISIT_ID->Param, "CustomMsg");
        $this->VISIT_ID->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['VISIT_ID'] = &$this->VISIT_ID;

        // IDXDAFTAR
        $this->IDXDAFTAR = new ReportField('register_ranap', 'register_ranap', 'x_IDXDAFTAR', 'IDXDAFTAR', '[IDXDAFTAR]', 'CAST([IDXDAFTAR] AS NVARCHAR)', 3, 4, -1, false, '[IDXDAFTAR]', false, false, false, 'FORMATTED TEXT', 'NO');
        $this->IDXDAFTAR->IsAutoIncrement = true; // Autoincrement field
        $this->IDXDAFTAR->IsPrimaryKey = true; // Primary key field
        $this->IDXDAFTAR->Nullable = false; // NOT NULL field
        $this->IDXDAFTAR->Sortable = true; // Allow sort
        $this->IDXDAFTAR->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->IDXDAFTAR->Param, "CustomMsg");
        $this->IDXDAFTAR->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['IDXDAFTAR'] = &$this->IDXDAFTAR;

        // DIANTAR_OLEH
        $this->DIANTAR_OLEH = new ReportField('register_ranap', 'register_ranap', 'x_DIANTAR_OLEH', 'DIANTAR_OLEH', '[DIANTAR_OLEH]', '[DIANTAR_OLEH]', 200, 255, -1, false, '[DIANTAR_OLEH]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->DIANTAR_OLEH->Sortable = true; // Allow sort
        $this->DIANTAR_OLEH->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->DIANTAR_OLEH->Param, "CustomMsg");
        $this->DIANTAR_OLEH->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['DIANTAR_OLEH'] = &$this->DIANTAR_OLEH;

        // EXIT_DATE
        $this->EXIT_DATE = new ReportField('register_ranap', 'register_ranap', 'x_EXIT_DATE', 'EXIT_DATE', '[EXIT_DATE]', CastDateFieldForLike("[EXIT_DATE]", 0, "DB"), 135, 8, 0, false, '[EXIT_DATE]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->EXIT_DATE->Sortable = true; // Allow sort
        $this->EXIT_DATE->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->EXIT_DATE->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->EXIT_DATE->Param, "CustomMsg");
        $this->EXIT_DATE->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['EXIT_DATE'] = &$this->EXIT_DATE;

        // KELUAR_ID
        $this->KELUAR_ID = new ReportField('register_ranap', 'register_ranap', 'x_KELUAR_ID', 'KELUAR_ID', '[KELUAR_ID]', 'CAST([KELUAR_ID] AS NVARCHAR)', 17, 1, -1, false, '[KELUAR_ID]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->KELUAR_ID->Sortable = true; // Allow sort
        $this->KELUAR_ID->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->KELUAR_ID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->KELUAR_ID->Param, "CustomMsg");
        $this->KELUAR_ID->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['KELUAR_ID'] = &$this->KELUAR_ID;

        // AGEYEAR
        $this->AGEYEAR = new ReportField('register_ranap', 'register_ranap', 'x_AGEYEAR', 'AGEYEAR', '[AGEYEAR]', 'CAST([AGEYEAR] AS NVARCHAR)', 2, 2, -1, false, '[AGEYEAR]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->AGEYEAR->Sortable = true; // Allow sort
        $this->AGEYEAR->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->AGEYEAR->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->AGEYEAR->Param, "CustomMsg");
        $this->AGEYEAR->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['AGEYEAR'] = &$this->AGEYEAR;

        // ORG_UNIT_CODE
        $this->ORG_UNIT_CODE = new ReportField('register_ranap', 'register_ranap', 'x_ORG_UNIT_CODE', 'ORG_UNIT_CODE', '[ORG_UNIT_CODE]', '[ORG_UNIT_CODE]', 200, 50, -1, false, '[ORG_UNIT_CODE]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->ORG_UNIT_CODE->Sortable = true; // Allow sort
        $this->ORG_UNIT_CODE->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->ORG_UNIT_CODE->Param, "CustomMsg");
        $this->ORG_UNIT_CODE->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['ORG_UNIT_CODE'] = &$this->ORG_UNIT_CODE;

        // RUJUKAN_ID
        $this->RUJUKAN_ID = new ReportField('register_ranap', 'register_ranap', 'x_RUJUKAN_ID', 'RUJUKAN_ID', '[RUJUKAN_ID]', 'CAST([RUJUKAN_ID] AS NVARCHAR)', 20, 8, -1, false, '[RUJUKAN_ID]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->RUJUKAN_ID->Sortable = true; // Allow sort
        $this->RUJUKAN_ID->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->RUJUKAN_ID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->RUJUKAN_ID->Param, "CustomMsg");
        $this->RUJUKAN_ID->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['RUJUKAN_ID'] = &$this->RUJUKAN_ID;

        // ADDRESS_OF_RUJUKAN
        $this->ADDRESS_OF_RUJUKAN = new ReportField('register_ranap', 'register_ranap', 'x_ADDRESS_OF_RUJUKAN', 'ADDRESS_OF_RUJUKAN', '[ADDRESS_OF_RUJUKAN]', '[ADDRESS_OF_RUJUKAN]', 200, 100, -1, false, '[ADDRESS_OF_RUJUKAN]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->ADDRESS_OF_RUJUKAN->Sortable = true; // Allow sort
        $this->ADDRESS_OF_RUJUKAN->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->ADDRESS_OF_RUJUKAN->Param, "CustomMsg");
        $this->ADDRESS_OF_RUJUKAN->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['ADDRESS_OF_RUJUKAN'] = &$this->ADDRESS_OF_RUJUKAN;

        // REASON_ID
        $this->REASON_ID = new ReportField('register_ranap', 'register_ranap', 'x_REASON_ID', 'REASON_ID', '[REASON_ID]', 'CAST([REASON_ID] AS NVARCHAR)', 17, 1, -1, false, '[REASON_ID]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->REASON_ID->Sortable = true; // Allow sort
        $this->REASON_ID->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->REASON_ID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->REASON_ID->Param, "CustomMsg");
        $this->REASON_ID->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['REASON_ID'] = &$this->REASON_ID;

        // WAY_ID
        $this->WAY_ID = new ReportField('register_ranap', 'register_ranap', 'x_WAY_ID', 'WAY_ID', '[WAY_ID]', 'CAST([WAY_ID] AS NVARCHAR)', 17, 1, -1, false, '[WAY_ID]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->WAY_ID->Sortable = true; // Allow sort
        $this->WAY_ID->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->WAY_ID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->WAY_ID->Param, "CustomMsg");
        $this->WAY_ID->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['WAY_ID'] = &$this->WAY_ID;

        // PATIENT_CATEGORY_ID
        $this->PATIENT_CATEGORY_ID = new ReportField('register_ranap', 'register_ranap', 'x_PATIENT_CATEGORY_ID', 'PATIENT_CATEGORY_ID', '[PATIENT_CATEGORY_ID]', 'CAST([PATIENT_CATEGORY_ID] AS NVARCHAR)', 17, 1, -1, false, '[PATIENT_CATEGORY_ID]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->PATIENT_CATEGORY_ID->Sortable = true; // Allow sort
        $this->PATIENT_CATEGORY_ID->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->PATIENT_CATEGORY_ID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->PATIENT_CATEGORY_ID->Param, "CustomMsg");
        $this->PATIENT_CATEGORY_ID->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['PATIENT_CATEGORY_ID'] = &$this->PATIENT_CATEGORY_ID;

        // BOOKED_DATE
        $this->BOOKED_DATE = new ReportField('register_ranap', 'register_ranap', 'x_BOOKED_DATE', 'BOOKED_DATE', '[BOOKED_DATE]', CastDateFieldForLike("[BOOKED_DATE]", 0, "DB"), 135, 8, 0, false, '[BOOKED_DATE]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->BOOKED_DATE->Sortable = true; // Allow sort
        $this->BOOKED_DATE->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->BOOKED_DATE->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->BOOKED_DATE->Param, "CustomMsg");
        $this->BOOKED_DATE->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['BOOKED_DATE'] = &$this->BOOKED_DATE;

        // VISIT_DATE
        $this->VISIT_DATE = new ReportField('register_ranap', 'register_ranap', 'x_VISIT_DATE', 'VISIT_DATE', 'dbo.PASIEN_VISITATION.VISIT_DATE', CastDateFieldForLike("dbo.PASIEN_VISITATION.VISIT_DATE", 0, "DB"), 135, 8, 0, false, 'dbo.PASIEN_VISITATION.VISIT_DATE', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->VISIT_DATE->Sortable = true; // Allow sort
        $this->VISIT_DATE->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->VISIT_DATE->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->VISIT_DATE->Param, "CustomMsg");
        $this->VISIT_DATE->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['VISIT_DATE'] = &$this->VISIT_DATE;

        // ISNEW
        $this->ISNEW = new ReportField('register_ranap', 'register_ranap', 'x_ISNEW', 'ISNEW', '[ISNEW]', '[ISNEW]', 129, 1, -1, false, '[ISNEW]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->ISNEW->Sortable = true; // Allow sort
        $this->ISNEW->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->ISNEW->Param, "CustomMsg");
        $this->ISNEW->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['ISNEW'] = &$this->ISNEW;

        // FOLLOW_UP
        $this->FOLLOW_UP = new ReportField('register_ranap', 'register_ranap', 'x_FOLLOW_UP', 'FOLLOW_UP', '[FOLLOW_UP]', 'CAST([FOLLOW_UP] AS NVARCHAR)', 17, 1, -1, false, '[FOLLOW_UP]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->FOLLOW_UP->Sortable = true; // Allow sort
        $this->FOLLOW_UP->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->FOLLOW_UP->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->FOLLOW_UP->Param, "CustomMsg");
        $this->FOLLOW_UP->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['FOLLOW_UP'] = &$this->FOLLOW_UP;

        // PLACE_TYPE
        $this->PLACE_TYPE = new ReportField('register_ranap', 'register_ranap', 'x_PLACE_TYPE', 'PLACE_TYPE', '[PLACE_TYPE]', 'CAST([PLACE_TYPE] AS NVARCHAR)', 17, 1, -1, false, '[PLACE_TYPE]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->PLACE_TYPE->Sortable = true; // Allow sort
        $this->PLACE_TYPE->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->PLACE_TYPE->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->PLACE_TYPE->Param, "CustomMsg");
        $this->PLACE_TYPE->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['PLACE_TYPE'] = &$this->PLACE_TYPE;

        // CLINIC_ID
        $this->CLINIC_ID = new ReportField('register_ranap', 'register_ranap', 'x_CLINIC_ID', 'CLINIC_ID', '[CLINIC_ID]', '[CLINIC_ID]', 200, 8, -1, false, '[CLINIC_ID]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->CLINIC_ID->Sortable = true; // Allow sort
        $this->CLINIC_ID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->CLINIC_ID->Param, "CustomMsg");
        $this->CLINIC_ID->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['CLINIC_ID'] = &$this->CLINIC_ID;

        // CLINIC_ID_FROM
        $this->CLINIC_ID_FROM = new ReportField('register_ranap', 'register_ranap', 'x_CLINIC_ID_FROM', 'CLINIC_ID_FROM', '[CLINIC_ID_FROM]', '[CLINIC_ID_FROM]', 200, 8, -1, false, '[CLINIC_ID_FROM]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->CLINIC_ID_FROM->Sortable = true; // Allow sort
        $this->CLINIC_ID_FROM->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->CLINIC_ID_FROM->Param, "CustomMsg");
        $this->CLINIC_ID_FROM->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['CLINIC_ID_FROM'] = &$this->CLINIC_ID_FROM;

        // IN_DATE
        $this->IN_DATE = new ReportField('register_ranap', 'register_ranap', 'x_IN_DATE', 'IN_DATE', '[IN_DATE]', CastDateFieldForLike("[IN_DATE]", 0, "DB"), 135, 8, 0, false, '[IN_DATE]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->IN_DATE->Sortable = true; // Allow sort
        $this->IN_DATE->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->IN_DATE->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->IN_DATE->Param, "CustomMsg");
        $this->IN_DATE->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['IN_DATE'] = &$this->IN_DATE;

        // DESCRIPTION
        $this->DESCRIPTION = new ReportField('register_ranap', 'register_ranap', 'x_DESCRIPTION', 'DESCRIPTION', '[DESCRIPTION]', '[DESCRIPTION]', 200, 200, -1, false, '[DESCRIPTION]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->DESCRIPTION->Sortable = true; // Allow sort
        $this->DESCRIPTION->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->DESCRIPTION->Param, "CustomMsg");
        $this->DESCRIPTION->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['DESCRIPTION'] = &$this->DESCRIPTION;

        // VISITOR_ADDRESS
        $this->VISITOR_ADDRESS = new ReportField('register_ranap', 'register_ranap', 'x_VISITOR_ADDRESS', 'VISITOR_ADDRESS', '[VISITOR_ADDRESS]', '[VISITOR_ADDRESS]', 200, 150, -1, false, '[VISITOR_ADDRESS]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->VISITOR_ADDRESS->Sortable = true; // Allow sort
        $this->VISITOR_ADDRESS->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->VISITOR_ADDRESS->Param, "CustomMsg");
        $this->VISITOR_ADDRESS->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['VISITOR_ADDRESS'] = &$this->VISITOR_ADDRESS;

        // MODIFIED_BY
        $this->MODIFIED_BY = new ReportField('register_ranap', 'register_ranap', 'x_MODIFIED_BY', 'MODIFIED_BY', '[MODIFIED_BY]', '[MODIFIED_BY]', 200, 100, -1, false, '[MODIFIED_BY]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->MODIFIED_BY->Sortable = true; // Allow sort
        $this->MODIFIED_BY->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->MODIFIED_BY->Param, "CustomMsg");
        $this->MODIFIED_BY->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['MODIFIED_BY'] = &$this->MODIFIED_BY;

        // MODIFIED_DATE
        $this->MODIFIED_DATE = new ReportField('register_ranap', 'register_ranap', 'x_MODIFIED_DATE', 'MODIFIED_DATE', '[MODIFIED_DATE]', CastDateFieldForLike("[MODIFIED_DATE]", 0, "DB"), 135, 8, 0, false, '[MODIFIED_DATE]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->MODIFIED_DATE->Sortable = true; // Allow sort
        $this->MODIFIED_DATE->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->MODIFIED_DATE->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->MODIFIED_DATE->Param, "CustomMsg");
        $this->MODIFIED_DATE->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['MODIFIED_DATE'] = &$this->MODIFIED_DATE;

        // MODIFIED_FROM
        $this->MODIFIED_FROM = new ReportField('register_ranap', 'register_ranap', 'x_MODIFIED_FROM', 'MODIFIED_FROM', '[MODIFIED_FROM]', '[MODIFIED_FROM]', 200, 50, -1, false, '[MODIFIED_FROM]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->MODIFIED_FROM->Sortable = true; // Allow sort
        $this->MODIFIED_FROM->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->MODIFIED_FROM->Param, "CustomMsg");
        $this->MODIFIED_FROM->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['MODIFIED_FROM'] = &$this->MODIFIED_FROM;

        // EMPLOYEE_ID
        $this->EMPLOYEE_ID = new ReportField('register_ranap', 'register_ranap', 'x_EMPLOYEE_ID', 'EMPLOYEE_ID', '[EMPLOYEE_ID]', '[EMPLOYEE_ID]', 200, 15, -1, false, '[EMPLOYEE_ID]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->EMPLOYEE_ID->Sortable = true; // Allow sort
        $this->EMPLOYEE_ID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->EMPLOYEE_ID->Param, "CustomMsg");
        $this->EMPLOYEE_ID->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['EMPLOYEE_ID'] = &$this->EMPLOYEE_ID;

        // EMPLOYEE_ID_FROM
        $this->EMPLOYEE_ID_FROM = new ReportField('register_ranap', 'register_ranap', 'x_EMPLOYEE_ID_FROM', 'EMPLOYEE_ID_FROM', '[EMPLOYEE_ID_FROM]', '[EMPLOYEE_ID_FROM]', 200, 50, -1, false, '[EMPLOYEE_ID_FROM]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->EMPLOYEE_ID_FROM->Sortable = true; // Allow sort
        $this->EMPLOYEE_ID_FROM->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->EMPLOYEE_ID_FROM->Param, "CustomMsg");
        $this->EMPLOYEE_ID_FROM->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['EMPLOYEE_ID_FROM'] = &$this->EMPLOYEE_ID_FROM;

        // RESPONSIBLE_ID
        $this->RESPONSIBLE_ID = new ReportField('register_ranap', 'register_ranap', 'x_RESPONSIBLE_ID', 'RESPONSIBLE_ID', '[RESPONSIBLE_ID]', 'CAST([RESPONSIBLE_ID] AS NVARCHAR)', 17, 1, -1, false, '[RESPONSIBLE_ID]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->RESPONSIBLE_ID->Sortable = true; // Allow sort
        $this->RESPONSIBLE_ID->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->RESPONSIBLE_ID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->RESPONSIBLE_ID->Param, "CustomMsg");
        $this->RESPONSIBLE_ID->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['RESPONSIBLE_ID'] = &$this->RESPONSIBLE_ID;

        // RESPONSIBLE
        $this->RESPONSIBLE = new ReportField('register_ranap', 'register_ranap', 'x_RESPONSIBLE', 'RESPONSIBLE', '[RESPONSIBLE]', '[RESPONSIBLE]', 200, 150, -1, false, '[RESPONSIBLE]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->RESPONSIBLE->Sortable = true; // Allow sort
        $this->RESPONSIBLE->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->RESPONSIBLE->Param, "CustomMsg");
        $this->RESPONSIBLE->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['RESPONSIBLE'] = &$this->RESPONSIBLE;

        // FAMILY_STATUS_ID
        $this->FAMILY_STATUS_ID = new ReportField('register_ranap', 'register_ranap', 'x_FAMILY_STATUS_ID', 'FAMILY_STATUS_ID', '[FAMILY_STATUS_ID]', 'CAST([FAMILY_STATUS_ID] AS NVARCHAR)', 17, 1, -1, false, '[FAMILY_STATUS_ID]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->FAMILY_STATUS_ID->Sortable = true; // Allow sort
        $this->FAMILY_STATUS_ID->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->FAMILY_STATUS_ID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->FAMILY_STATUS_ID->Param, "CustomMsg");
        $this->FAMILY_STATUS_ID->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['FAMILY_STATUS_ID'] = &$this->FAMILY_STATUS_ID;

        // TICKET_NO
        $this->TICKET_NO = new ReportField('register_ranap', 'register_ranap', 'x_TICKET_NO', 'TICKET_NO', '[TICKET_NO]', 'CAST([TICKET_NO] AS NVARCHAR)', 2, 2, -1, false, '[TICKET_NO]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->TICKET_NO->Sortable = true; // Allow sort
        $this->TICKET_NO->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->TICKET_NO->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->TICKET_NO->Param, "CustomMsg");
        $this->TICKET_NO->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['TICKET_NO'] = &$this->TICKET_NO;

        // ISATTENDED
        $this->ISATTENDED = new ReportField('register_ranap', 'register_ranap', 'x_ISATTENDED', 'ISATTENDED', '[ISATTENDED]', '[ISATTENDED]', 129, 1, -1, false, '[ISATTENDED]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->ISATTENDED->Sortable = true; // Allow sort
        $this->ISATTENDED->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->ISATTENDED->Param, "CustomMsg");
        $this->ISATTENDED->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['ISATTENDED'] = &$this->ISATTENDED;

        // PAYOR_ID
        $this->PAYOR_ID = new ReportField('register_ranap', 'register_ranap', 'x_PAYOR_ID', 'PAYOR_ID', '[PAYOR_ID]', '[PAYOR_ID]', 200, 50, -1, false, '[PAYOR_ID]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->PAYOR_ID->Sortable = true; // Allow sort
        $this->PAYOR_ID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->PAYOR_ID->Param, "CustomMsg");
        $this->PAYOR_ID->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['PAYOR_ID'] = &$this->PAYOR_ID;

        // CLASS_ID
        $this->CLASS_ID = new ReportField('register_ranap', 'register_ranap', 'x_CLASS_ID', 'CLASS_ID', '[CLASS_ID]', 'CAST([CLASS_ID] AS NVARCHAR)', 17, 1, -1, false, '[CLASS_ID]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->CLASS_ID->Sortable = true; // Allow sort
        $this->CLASS_ID->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->CLASS_ID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->CLASS_ID->Param, "CustomMsg");
        $this->CLASS_ID->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['CLASS_ID'] = &$this->CLASS_ID;

        // ISPERTARIF
        $this->ISPERTARIF = new ReportField('register_ranap', 'register_ranap', 'x_ISPERTARIF', 'ISPERTARIF', '[ISPERTARIF]', '[ISPERTARIF]', 129, 1, -1, false, '[ISPERTARIF]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->ISPERTARIF->Sortable = true; // Allow sort
        $this->ISPERTARIF->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->ISPERTARIF->Param, "CustomMsg");
        $this->ISPERTARIF->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['ISPERTARIF'] = &$this->ISPERTARIF;

        // KAL_ID
        $this->KAL_ID = new ReportField('register_ranap', 'register_ranap', 'x_KAL_ID', 'KAL_ID', '[KAL_ID]', '[KAL_ID]', 200, 50, -1, false, '[KAL_ID]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->KAL_ID->Sortable = true; // Allow sort
        $this->KAL_ID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->KAL_ID->Param, "CustomMsg");
        $this->KAL_ID->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['KAL_ID'] = &$this->KAL_ID;

        // EMPLOYEE_INAP
        $this->EMPLOYEE_INAP = new ReportField('register_ranap', 'register_ranap', 'x_EMPLOYEE_INAP', 'EMPLOYEE_INAP', '[EMPLOYEE_INAP]', '[EMPLOYEE_INAP]', 200, 50, -1, false, '[EMPLOYEE_INAP]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->EMPLOYEE_INAP->Sortable = true; // Allow sort
        $this->EMPLOYEE_INAP->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->EMPLOYEE_INAP->Param, "CustomMsg");
        $this->EMPLOYEE_INAP->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['EMPLOYEE_INAP'] = &$this->EMPLOYEE_INAP;

        // PASIEN_ID
        $this->PASIEN_ID = new ReportField('register_ranap', 'register_ranap', 'x_PASIEN_ID', 'PASIEN_ID', '[PASIEN_ID]', '[PASIEN_ID]', 200, 30, -1, false, '[PASIEN_ID]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->PASIEN_ID->Sortable = true; // Allow sort
        $this->PASIEN_ID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->PASIEN_ID->Param, "CustomMsg");
        $this->PASIEN_ID->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['PASIEN_ID'] = &$this->PASIEN_ID;

        // KARYAWAN
        $this->KARYAWAN = new ReportField('register_ranap', 'register_ranap', 'x_KARYAWAN', 'KARYAWAN', '[KARYAWAN]', '[KARYAWAN]', 200, 50, -1, false, '[KARYAWAN]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->KARYAWAN->Sortable = true; // Allow sort
        $this->KARYAWAN->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->KARYAWAN->Param, "CustomMsg");
        $this->KARYAWAN->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['KARYAWAN'] = &$this->KARYAWAN;

        // ACCOUNT_ID
        $this->ACCOUNT_ID = new ReportField('register_ranap', 'register_ranap', 'x_ACCOUNT_ID', 'ACCOUNT_ID', '[ACCOUNT_ID]', '[ACCOUNT_ID]', 200, 50, -1, false, '[ACCOUNT_ID]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->ACCOUNT_ID->Sortable = true; // Allow sort
        $this->ACCOUNT_ID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->ACCOUNT_ID->Param, "CustomMsg");
        $this->ACCOUNT_ID->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['ACCOUNT_ID'] = &$this->ACCOUNT_ID;

        // CLASS_ID_PLAFOND
        $this->CLASS_ID_PLAFOND = new ReportField('register_ranap', 'register_ranap', 'x_CLASS_ID_PLAFOND', 'CLASS_ID_PLAFOND', '[CLASS_ID_PLAFOND]', 'CAST([CLASS_ID_PLAFOND] AS NVARCHAR)', 17, 1, -1, false, '[CLASS_ID_PLAFOND]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->CLASS_ID_PLAFOND->Sortable = true; // Allow sort
        $this->CLASS_ID_PLAFOND->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->CLASS_ID_PLAFOND->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->CLASS_ID_PLAFOND->Param, "CustomMsg");
        $this->CLASS_ID_PLAFOND->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['CLASS_ID_PLAFOND'] = &$this->CLASS_ID_PLAFOND;

        // BACKCHARGE
        $this->BACKCHARGE = new ReportField('register_ranap', 'register_ranap', 'x_BACKCHARGE', 'BACKCHARGE', '[BACKCHARGE]', '[BACKCHARGE]', 129, 1, -1, false, '[BACKCHARGE]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->BACKCHARGE->Sortable = true; // Allow sort
        $this->BACKCHARGE->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->BACKCHARGE->Param, "CustomMsg");
        $this->BACKCHARGE->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['BACKCHARGE'] = &$this->BACKCHARGE;

        // COVERAGE_ID
        $this->COVERAGE_ID = new ReportField('register_ranap', 'register_ranap', 'x_COVERAGE_ID', 'COVERAGE_ID', '[COVERAGE_ID]', 'CAST([COVERAGE_ID] AS NVARCHAR)', 17, 1, -1, false, '[COVERAGE_ID]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->COVERAGE_ID->Sortable = true; // Allow sort
        $this->COVERAGE_ID->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->COVERAGE_ID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->COVERAGE_ID->Param, "CustomMsg");
        $this->COVERAGE_ID->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['COVERAGE_ID'] = &$this->COVERAGE_ID;

        // AGEMONTH
        $this->AGEMONTH = new ReportField('register_ranap', 'register_ranap', 'x_AGEMONTH', 'AGEMONTH', '[AGEMONTH]', 'CAST([AGEMONTH] AS NVARCHAR)', 2, 2, -1, false, '[AGEMONTH]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->AGEMONTH->Sortable = true; // Allow sort
        $this->AGEMONTH->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->AGEMONTH->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->AGEMONTH->Param, "CustomMsg");
        $this->AGEMONTH->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['AGEMONTH'] = &$this->AGEMONTH;

        // AGEDAY
        $this->AGEDAY = new ReportField('register_ranap', 'register_ranap', 'x_AGEDAY', 'AGEDAY', '[AGEDAY]', 'CAST([AGEDAY] AS NVARCHAR)', 2, 2, -1, false, '[AGEDAY]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->AGEDAY->Sortable = true; // Allow sort
        $this->AGEDAY->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->AGEDAY->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->AGEDAY->Param, "CustomMsg");
        $this->AGEDAY->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['AGEDAY'] = &$this->AGEDAY;

        // RECOMENDATION
        $this->RECOMENDATION = new ReportField('register_ranap', 'register_ranap', 'x_RECOMENDATION', 'RECOMENDATION', '[RECOMENDATION]', '[RECOMENDATION]', 200, 8000, -1, false, '[RECOMENDATION]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->RECOMENDATION->Sortable = true; // Allow sort
        $this->RECOMENDATION->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->RECOMENDATION->Param, "CustomMsg");
        $this->RECOMENDATION->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['RECOMENDATION'] = &$this->RECOMENDATION;

        // CONCLUSION
        $this->CONCLUSION = new ReportField('register_ranap', 'register_ranap', 'x_CONCLUSION', 'CONCLUSION', '[CONCLUSION]', '[CONCLUSION]', 200, 8000, -1, false, '[CONCLUSION]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->CONCLUSION->Sortable = true; // Allow sort
        $this->CONCLUSION->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->CONCLUSION->Param, "CustomMsg");
        $this->CONCLUSION->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['CONCLUSION'] = &$this->CONCLUSION;

        // SPECIMENNO
        $this->SPECIMENNO = new ReportField('register_ranap', 'register_ranap', 'x_SPECIMENNO', 'SPECIMENNO', '[SPECIMENNO]', '[SPECIMENNO]', 200, 50, -1, false, '[SPECIMENNO]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->SPECIMENNO->Sortable = true; // Allow sort
        $this->SPECIMENNO->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->SPECIMENNO->Param, "CustomMsg");
        $this->SPECIMENNO->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['SPECIMENNO'] = &$this->SPECIMENNO;

        // LOCKED
        $this->LOCKED = new ReportField('register_ranap', 'register_ranap', 'x_LOCKED', 'LOCKED', '[LOCKED]', '[LOCKED]', 200, 1, -1, false, '[LOCKED]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->LOCKED->Sortable = true; // Allow sort
        $this->LOCKED->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->LOCKED->Param, "CustomMsg");
        $this->LOCKED->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['LOCKED'] = &$this->LOCKED;

        // RM_OUT_DATE
        $this->RM_OUT_DATE = new ReportField('register_ranap', 'register_ranap', 'x_RM_OUT_DATE', 'RM_OUT_DATE', '[RM_OUT_DATE]', CastDateFieldForLike("[RM_OUT_DATE]", 0, "DB"), 135, 8, 0, false, '[RM_OUT_DATE]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->RM_OUT_DATE->Sortable = true; // Allow sort
        $this->RM_OUT_DATE->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->RM_OUT_DATE->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->RM_OUT_DATE->Param, "CustomMsg");
        $this->RM_OUT_DATE->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['RM_OUT_DATE'] = &$this->RM_OUT_DATE;

        // RM_IN_DATE
        $this->RM_IN_DATE = new ReportField('register_ranap', 'register_ranap', 'x_RM_IN_DATE', 'RM_IN_DATE', '[RM_IN_DATE]', CastDateFieldForLike("[RM_IN_DATE]", 0, "DB"), 135, 8, 0, false, '[RM_IN_DATE]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->RM_IN_DATE->Sortable = true; // Allow sort
        $this->RM_IN_DATE->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->RM_IN_DATE->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->RM_IN_DATE->Param, "CustomMsg");
        $this->RM_IN_DATE->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['RM_IN_DATE'] = &$this->RM_IN_DATE;

        // LAMA_PINJAM
        $this->LAMA_PINJAM = new ReportField('register_ranap', 'register_ranap', 'x_LAMA_PINJAM', 'LAMA_PINJAM', '[LAMA_PINJAM]', CastDateFieldForLike("[LAMA_PINJAM]", 0, "DB"), 135, 8, 0, false, '[LAMA_PINJAM]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->LAMA_PINJAM->Sortable = true; // Allow sort
        $this->LAMA_PINJAM->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->LAMA_PINJAM->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->LAMA_PINJAM->Param, "CustomMsg");
        $this->LAMA_PINJAM->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['LAMA_PINJAM'] = &$this->LAMA_PINJAM;

        // STANDAR_RJ
        $this->STANDAR_RJ = new ReportField('register_ranap', 'register_ranap', 'x_STANDAR_RJ', 'STANDAR_RJ', '[STANDAR_RJ]', '[STANDAR_RJ]', 129, 1, -1, false, '[STANDAR_RJ]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->STANDAR_RJ->Sortable = true; // Allow sort
        $this->STANDAR_RJ->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->STANDAR_RJ->Param, "CustomMsg");
        $this->STANDAR_RJ->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['STANDAR_RJ'] = &$this->STANDAR_RJ;

        // LENGKAP_RJ
        $this->LENGKAP_RJ = new ReportField('register_ranap', 'register_ranap', 'x_LENGKAP_RJ', 'LENGKAP_RJ', '[LENGKAP_RJ]', '[LENGKAP_RJ]', 129, 1, -1, false, '[LENGKAP_RJ]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->LENGKAP_RJ->Sortable = true; // Allow sort
        $this->LENGKAP_RJ->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->LENGKAP_RJ->Param, "CustomMsg");
        $this->LENGKAP_RJ->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['LENGKAP_RJ'] = &$this->LENGKAP_RJ;

        // LENGKAP_RI
        $this->LENGKAP_RI = new ReportField('register_ranap', 'register_ranap', 'x_LENGKAP_RI', 'LENGKAP_RI', '[LENGKAP_RI]', '[LENGKAP_RI]', 129, 1, -1, false, '[LENGKAP_RI]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->LENGKAP_RI->Sortable = true; // Allow sort
        $this->LENGKAP_RI->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->LENGKAP_RI->Param, "CustomMsg");
        $this->LENGKAP_RI->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['LENGKAP_RI'] = &$this->LENGKAP_RI;

        // RESEND_RM_DATE
        $this->RESEND_RM_DATE = new ReportField('register_ranap', 'register_ranap', 'x_RESEND_RM_DATE', 'RESEND_RM_DATE', '[RESEND_RM_DATE]', CastDateFieldForLike("[RESEND_RM_DATE]", 0, "DB"), 135, 8, 0, false, '[RESEND_RM_DATE]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->RESEND_RM_DATE->Sortable = true; // Allow sort
        $this->RESEND_RM_DATE->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->RESEND_RM_DATE->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->RESEND_RM_DATE->Param, "CustomMsg");
        $this->RESEND_RM_DATE->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['RESEND_RM_DATE'] = &$this->RESEND_RM_DATE;

        // LENGKAP_RM1
        $this->LENGKAP_RM1 = new ReportField('register_ranap', 'register_ranap', 'x_LENGKAP_RM1', 'LENGKAP_RM1', '[LENGKAP_RM1]', '[LENGKAP_RM1]', 129, 1, -1, false, '[LENGKAP_RM1]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->LENGKAP_RM1->Sortable = true; // Allow sort
        $this->LENGKAP_RM1->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->LENGKAP_RM1->Param, "CustomMsg");
        $this->LENGKAP_RM1->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['LENGKAP_RM1'] = &$this->LENGKAP_RM1;

        // LENGKAP_RESUME
        $this->LENGKAP_RESUME = new ReportField('register_ranap', 'register_ranap', 'x_LENGKAP_RESUME', 'LENGKAP_RESUME', '[LENGKAP_RESUME]', '[LENGKAP_RESUME]', 129, 1, -1, false, '[LENGKAP_RESUME]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->LENGKAP_RESUME->Sortable = true; // Allow sort
        $this->LENGKAP_RESUME->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->LENGKAP_RESUME->Param, "CustomMsg");
        $this->LENGKAP_RESUME->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['LENGKAP_RESUME'] = &$this->LENGKAP_RESUME;

        // LENGKAP_ANAMNESIS
        $this->LENGKAP_ANAMNESIS = new ReportField('register_ranap', 'register_ranap', 'x_LENGKAP_ANAMNESIS', 'LENGKAP_ANAMNESIS', '[LENGKAP_ANAMNESIS]', '[LENGKAP_ANAMNESIS]', 129, 1, -1, false, '[LENGKAP_ANAMNESIS]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->LENGKAP_ANAMNESIS->Sortable = true; // Allow sort
        $this->LENGKAP_ANAMNESIS->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->LENGKAP_ANAMNESIS->Param, "CustomMsg");
        $this->LENGKAP_ANAMNESIS->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['LENGKAP_ANAMNESIS'] = &$this->LENGKAP_ANAMNESIS;

        // LENGKAP_CONSENT
        $this->LENGKAP_CONSENT = new ReportField('register_ranap', 'register_ranap', 'x_LENGKAP_CONSENT', 'LENGKAP_CONSENT', '[LENGKAP_CONSENT]', '[LENGKAP_CONSENT]', 129, 1, -1, false, '[LENGKAP_CONSENT]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->LENGKAP_CONSENT->Sortable = true; // Allow sort
        $this->LENGKAP_CONSENT->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->LENGKAP_CONSENT->Param, "CustomMsg");
        $this->LENGKAP_CONSENT->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['LENGKAP_CONSENT'] = &$this->LENGKAP_CONSENT;

        // LENGKAP_ANESTESI
        $this->LENGKAP_ANESTESI = new ReportField('register_ranap', 'register_ranap', 'x_LENGKAP_ANESTESI', 'LENGKAP_ANESTESI', '[LENGKAP_ANESTESI]', '[LENGKAP_ANESTESI]', 129, 1, -1, false, '[LENGKAP_ANESTESI]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->LENGKAP_ANESTESI->Sortable = true; // Allow sort
        $this->LENGKAP_ANESTESI->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->LENGKAP_ANESTESI->Param, "CustomMsg");
        $this->LENGKAP_ANESTESI->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['LENGKAP_ANESTESI'] = &$this->LENGKAP_ANESTESI;

        // LENGKAP_OP
        $this->LENGKAP_OP = new ReportField('register_ranap', 'register_ranap', 'x_LENGKAP_OP', 'LENGKAP_OP', '[LENGKAP_OP]', '[LENGKAP_OP]', 129, 1, -1, false, '[LENGKAP_OP]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->LENGKAP_OP->Sortable = true; // Allow sort
        $this->LENGKAP_OP->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->LENGKAP_OP->Param, "CustomMsg");
        $this->LENGKAP_OP->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['LENGKAP_OP'] = &$this->LENGKAP_OP;

        // BACK_RM_DATE
        $this->BACK_RM_DATE = new ReportField('register_ranap', 'register_ranap', 'x_BACK_RM_DATE', 'BACK_RM_DATE', '[BACK_RM_DATE]', CastDateFieldForLike("[BACK_RM_DATE]", 0, "DB"), 135, 8, 0, false, '[BACK_RM_DATE]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->BACK_RM_DATE->Sortable = true; // Allow sort
        $this->BACK_RM_DATE->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->BACK_RM_DATE->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->BACK_RM_DATE->Param, "CustomMsg");
        $this->BACK_RM_DATE->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['BACK_RM_DATE'] = &$this->BACK_RM_DATE;

        // VALID_RM_DATE
        $this->VALID_RM_DATE = new ReportField('register_ranap', 'register_ranap', 'x_VALID_RM_DATE', 'VALID_RM_DATE', '[VALID_RM_DATE]', CastDateFieldForLike("[VALID_RM_DATE]", 0, "DB"), 135, 8, 0, false, '[VALID_RM_DATE]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->VALID_RM_DATE->Sortable = true; // Allow sort
        $this->VALID_RM_DATE->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->VALID_RM_DATE->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->VALID_RM_DATE->Param, "CustomMsg");
        $this->VALID_RM_DATE->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['VALID_RM_DATE'] = &$this->VALID_RM_DATE;

        // NO_SKP
        $this->NO_SKP = new ReportField('register_ranap', 'register_ranap', 'x_NO_SKP', 'NO_SKP', '[NO_SKP]', '[NO_SKP]', 200, 50, -1, false, '[NO_SKP]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->NO_SKP->Sortable = true; // Allow sort
        $this->NO_SKP->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->NO_SKP->Param, "CustomMsg");
        $this->NO_SKP->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['NO_SKP'] = &$this->NO_SKP;

        // NO_SKPINAP
        $this->NO_SKPINAP = new ReportField('register_ranap', 'register_ranap', 'x_NO_SKPINAP', 'NO_SKPINAP', '[NO_SKPINAP]', '[NO_SKPINAP]', 200, 50, -1, false, '[NO_SKPINAP]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->NO_SKPINAP->Sortable = true; // Allow sort
        $this->NO_SKPINAP->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->NO_SKPINAP->Param, "CustomMsg");
        $this->NO_SKPINAP->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['NO_SKPINAP'] = &$this->NO_SKPINAP;

        // DIAGNOSA_ID
        $this->DIAGNOSA_ID = new ReportField('register_ranap', 'register_ranap', 'x_DIAGNOSA_ID', 'DIAGNOSA_ID', '[DIAGNOSA_ID]', '[DIAGNOSA_ID]', 200, 10, -1, false, '[DIAGNOSA_ID]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->DIAGNOSA_ID->Sortable = true; // Allow sort
        $this->DIAGNOSA_ID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->DIAGNOSA_ID->Param, "CustomMsg");
        $this->DIAGNOSA_ID->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['DIAGNOSA_ID'] = &$this->DIAGNOSA_ID;

        // ticket_all
        $this->ticket_all = new ReportField('register_ranap', 'register_ranap', 'x_ticket_all', 'ticket_all', '[ticket_all]', 'CAST([ticket_all] AS NVARCHAR)', 20, 8, -1, false, '[ticket_all]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->ticket_all->Sortable = true; // Allow sort
        $this->ticket_all->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->ticket_all->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->ticket_all->Param, "CustomMsg");
        $this->ticket_all->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['ticket_all'] = &$this->ticket_all;

        // tanggal_rujukan
        $this->tanggal_rujukan = new ReportField('register_ranap', 'register_ranap', 'x_tanggal_rujukan', 'tanggal_rujukan', '[tanggal_rujukan]', CastDateFieldForLike("[tanggal_rujukan]", 0, "DB"), 135, 8, 0, false, '[tanggal_rujukan]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->tanggal_rujukan->Sortable = true; // Allow sort
        $this->tanggal_rujukan->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->tanggal_rujukan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->tanggal_rujukan->Param, "CustomMsg");
        $this->tanggal_rujukan->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['tanggal_rujukan'] = &$this->tanggal_rujukan;

        // NORUJUKAN
        $this->NORUJUKAN = new ReportField('register_ranap', 'register_ranap', 'x_NORUJUKAN', 'NORUJUKAN', '[NORUJUKAN]', '[NORUJUKAN]', 200, 50, -1, false, '[NORUJUKAN]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->NORUJUKAN->Sortable = true; // Allow sort
        $this->NORUJUKAN->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->NORUJUKAN->Param, "CustomMsg");
        $this->NORUJUKAN->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['NORUJUKAN'] = &$this->NORUJUKAN;

        // PPKRUJUKAN
        $this->PPKRUJUKAN = new ReportField('register_ranap', 'register_ranap', 'x_PPKRUJUKAN', 'PPKRUJUKAN', '[PPKRUJUKAN]', '[PPKRUJUKAN]', 200, 50, -1, false, '[PPKRUJUKAN]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->PPKRUJUKAN->Sortable = true; // Allow sort
        $this->PPKRUJUKAN->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->PPKRUJUKAN->Param, "CustomMsg");
        $this->PPKRUJUKAN->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['PPKRUJUKAN'] = &$this->PPKRUJUKAN;

        // LOKASILAKA
        $this->LOKASILAKA = new ReportField('register_ranap', 'register_ranap', 'x_LOKASILAKA', 'LOKASILAKA', '[LOKASILAKA]', '[LOKASILAKA]', 200, 50, -1, false, '[LOKASILAKA]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->LOKASILAKA->Sortable = true; // Allow sort
        $this->LOKASILAKA->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->LOKASILAKA->Param, "CustomMsg");
        $this->LOKASILAKA->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['LOKASILAKA'] = &$this->LOKASILAKA;

        // KDPOLI
        $this->KDPOLI = new ReportField('register_ranap', 'register_ranap', 'x_KDPOLI', 'KDPOLI', '[KDPOLI]', '[KDPOLI]', 200, 3, -1, false, '[KDPOLI]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->KDPOLI->Sortable = true; // Allow sort
        $this->KDPOLI->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->KDPOLI->Param, "CustomMsg");
        $this->KDPOLI->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['KDPOLI'] = &$this->KDPOLI;

        // EDIT_SEP
        $this->EDIT_SEP = new ReportField('register_ranap', 'register_ranap', 'x_EDIT_SEP', 'EDIT_SEP', '[EDIT_SEP]', '[EDIT_SEP]', 200, 250, -1, false, '[EDIT_SEP]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->EDIT_SEP->Sortable = true; // Allow sort
        $this->EDIT_SEP->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->EDIT_SEP->Param, "CustomMsg");
        $this->EDIT_SEP->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['EDIT_SEP'] = &$this->EDIT_SEP;

        // DELETE_SEP
        $this->DELETE_SEP = new ReportField('register_ranap', 'register_ranap', 'x_DELETE_SEP', 'DELETE_SEP', '[DELETE_SEP]', '[DELETE_SEP]', 200, 250, -1, false, '[DELETE_SEP]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->DELETE_SEP->Sortable = true; // Allow sort
        $this->DELETE_SEP->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->DELETE_SEP->Param, "CustomMsg");
        $this->DELETE_SEP->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['DELETE_SEP'] = &$this->DELETE_SEP;

        // KODE_AGAMA
        $this->KODE_AGAMA = new ReportField('register_ranap', 'register_ranap', 'x_KODE_AGAMA', 'KODE_AGAMA', '[KODE_AGAMA]', 'CAST([KODE_AGAMA] AS NVARCHAR)', 17, 1, -1, false, '[KODE_AGAMA]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->KODE_AGAMA->Sortable = true; // Allow sort
        $this->KODE_AGAMA->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->KODE_AGAMA->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->KODE_AGAMA->Param, "CustomMsg");
        $this->KODE_AGAMA->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['KODE_AGAMA'] = &$this->KODE_AGAMA;

        // DIAG_AWAL
        $this->DIAG_AWAL = new ReportField('register_ranap', 'register_ranap', 'x_DIAG_AWAL', 'DIAG_AWAL', '[DIAG_AWAL]', '[DIAG_AWAL]', 200, 10, -1, false, '[DIAG_AWAL]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->DIAG_AWAL->Sortable = true; // Allow sort
        $this->DIAG_AWAL->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->DIAG_AWAL->Param, "CustomMsg");
        $this->DIAG_AWAL->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['DIAG_AWAL'] = &$this->DIAG_AWAL;

        // AKTIF
        $this->AKTIF = new ReportField('register_ranap', 'register_ranap', 'x_AKTIF', 'AKTIF', '[AKTIF]', '[AKTIF]', 200, 2, -1, false, '[AKTIF]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->AKTIF->Sortable = true; // Allow sort
        $this->AKTIF->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->AKTIF->Param, "CustomMsg");
        $this->AKTIF->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['AKTIF'] = &$this->AKTIF;

        // BILL_INAP
        $this->BILL_INAP = new ReportField('register_ranap', 'register_ranap', 'x_BILL_INAP', 'BILL_INAP', '[BILL_INAP]', '[BILL_INAP]', 200, 50, -1, false, '[BILL_INAP]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->BILL_INAP->Sortable = true; // Allow sort
        $this->BILL_INAP->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->BILL_INAP->Param, "CustomMsg");
        $this->BILL_INAP->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['BILL_INAP'] = &$this->BILL_INAP;

        // SEP_PRINTDATE
        $this->SEP_PRINTDATE = new ReportField('register_ranap', 'register_ranap', 'x_SEP_PRINTDATE', 'SEP_PRINTDATE', '[SEP_PRINTDATE]', CastDateFieldForLike("[SEP_PRINTDATE]", 0, "DB"), 135, 8, 0, false, '[SEP_PRINTDATE]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->SEP_PRINTDATE->Sortable = true; // Allow sort
        $this->SEP_PRINTDATE->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->SEP_PRINTDATE->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->SEP_PRINTDATE->Param, "CustomMsg");
        $this->SEP_PRINTDATE->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['SEP_PRINTDATE'] = &$this->SEP_PRINTDATE;

        // MAPPING_SEP
        $this->MAPPING_SEP = new ReportField('register_ranap', 'register_ranap', 'x_MAPPING_SEP', 'MAPPING_SEP', '[MAPPING_SEP]', '[MAPPING_SEP]', 200, 250, -1, false, '[MAPPING_SEP]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->MAPPING_SEP->Sortable = true; // Allow sort
        $this->MAPPING_SEP->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->MAPPING_SEP->Param, "CustomMsg");
        $this->MAPPING_SEP->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['MAPPING_SEP'] = &$this->MAPPING_SEP;

        // TRANS_ID
        $this->TRANS_ID = new ReportField('register_ranap', 'register_ranap', 'x_TRANS_ID', 'TRANS_ID', '[TRANS_ID]', '[TRANS_ID]', 200, 50, -1, false, '[TRANS_ID]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->TRANS_ID->Sortable = true; // Allow sort
        $this->TRANS_ID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->TRANS_ID->Param, "CustomMsg");
        $this->TRANS_ID->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['TRANS_ID'] = &$this->TRANS_ID;

        // KDPOLI_EKS
        $this->KDPOLI_EKS = new ReportField('register_ranap', 'register_ranap', 'x_KDPOLI_EKS', 'KDPOLI_EKS', '[KDPOLI_EKS]', '[KDPOLI_EKS]', 129, 1, -1, false, '[KDPOLI_EKS]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->KDPOLI_EKS->Sortable = true; // Allow sort
        $this->KDPOLI_EKS->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->KDPOLI_EKS->Param, "CustomMsg");
        $this->KDPOLI_EKS->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['KDPOLI_EKS'] = &$this->KDPOLI_EKS;

        // COB
        $this->COB = new ReportField('register_ranap', 'register_ranap', 'x_COB', 'COB', '[COB]', '[COB]', 129, 1, -1, false, '[COB]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->COB->Sortable = true; // Allow sort
        $this->COB->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->COB->Param, "CustomMsg");
        $this->COB->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['COB'] = &$this->COB;

        // PENJAMIN
        $this->PENJAMIN = new ReportField('register_ranap', 'register_ranap', 'x_PENJAMIN', 'PENJAMIN', '[PENJAMIN]', '[PENJAMIN]', 200, 25, -1, false, '[PENJAMIN]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->PENJAMIN->Sortable = true; // Allow sort
        $this->PENJAMIN->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->PENJAMIN->Param, "CustomMsg");
        $this->PENJAMIN->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['PENJAMIN'] = &$this->PENJAMIN;

        // ASALRUJUKAN
        $this->ASALRUJUKAN = new ReportField('register_ranap', 'register_ranap', 'x_ASALRUJUKAN', 'ASALRUJUKAN', '[ASALRUJUKAN]', '[ASALRUJUKAN]', 129, 1, -1, false, '[ASALRUJUKAN]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->ASALRUJUKAN->Sortable = true; // Allow sort
        $this->ASALRUJUKAN->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->ASALRUJUKAN->Param, "CustomMsg");
        $this->ASALRUJUKAN->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['ASALRUJUKAN'] = &$this->ASALRUJUKAN;

        // RESPONSEP
        $this->RESPONSEP = new ReportField('register_ranap', 'register_ranap', 'x_RESPONSEP', 'RESPONSEP', '[RESPONSEP]', '[RESPONSEP]', 200, 0, -1, false, '[RESPONSEP]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->RESPONSEP->Sortable = true; // Allow sort
        $this->RESPONSEP->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->RESPONSEP->Param, "CustomMsg");
        $this->RESPONSEP->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['RESPONSEP'] = &$this->RESPONSEP;

        // APPROVAL_DESC
        $this->APPROVAL_DESC = new ReportField('register_ranap', 'register_ranap', 'x_APPROVAL_DESC', 'APPROVAL_DESC', '[APPROVAL_DESC]', '[APPROVAL_DESC]', 200, 250, -1, false, '[APPROVAL_DESC]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->APPROVAL_DESC->Sortable = true; // Allow sort
        $this->APPROVAL_DESC->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->APPROVAL_DESC->Param, "CustomMsg");
        $this->APPROVAL_DESC->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['APPROVAL_DESC'] = &$this->APPROVAL_DESC;

        // APPROVAL_RESPONAJUKAN
        $this->APPROVAL_RESPONAJUKAN = new ReportField('register_ranap', 'register_ranap', 'x_APPROVAL_RESPONAJUKAN', 'APPROVAL_RESPONAJUKAN', '[APPROVAL_RESPONAJUKAN]', '[APPROVAL_RESPONAJUKAN]', 200, 250, -1, false, '[APPROVAL_RESPONAJUKAN]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->APPROVAL_RESPONAJUKAN->Sortable = true; // Allow sort
        $this->APPROVAL_RESPONAJUKAN->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->APPROVAL_RESPONAJUKAN->Param, "CustomMsg");
        $this->APPROVAL_RESPONAJUKAN->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['APPROVAL_RESPONAJUKAN'] = &$this->APPROVAL_RESPONAJUKAN;

        // APPROVAL_RESPONAPPROV
        $this->APPROVAL_RESPONAPPROV = new ReportField('register_ranap', 'register_ranap', 'x_APPROVAL_RESPONAPPROV', 'APPROVAL_RESPONAPPROV', '[APPROVAL_RESPONAPPROV]', '[APPROVAL_RESPONAPPROV]', 200, 250, -1, false, '[APPROVAL_RESPONAPPROV]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->APPROVAL_RESPONAPPROV->Sortable = true; // Allow sort
        $this->APPROVAL_RESPONAPPROV->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->APPROVAL_RESPONAPPROV->Param, "CustomMsg");
        $this->APPROVAL_RESPONAPPROV->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['APPROVAL_RESPONAPPROV'] = &$this->APPROVAL_RESPONAPPROV;

        // RESPONTGLPLG_DESC
        $this->RESPONTGLPLG_DESC = new ReportField('register_ranap', 'register_ranap', 'x_RESPONTGLPLG_DESC', 'RESPONTGLPLG_DESC', '[RESPONTGLPLG_DESC]', '[RESPONTGLPLG_DESC]', 200, 250, -1, false, '[RESPONTGLPLG_DESC]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->RESPONTGLPLG_DESC->Sortable = true; // Allow sort
        $this->RESPONTGLPLG_DESC->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->RESPONTGLPLG_DESC->Param, "CustomMsg");
        $this->RESPONTGLPLG_DESC->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['RESPONTGLPLG_DESC'] = &$this->RESPONTGLPLG_DESC;

        // RESPONPOST_VKLAIM
        $this->RESPONPOST_VKLAIM = new ReportField('register_ranap', 'register_ranap', 'x_RESPONPOST_VKLAIM', 'RESPONPOST_VKLAIM', '[RESPONPOST_VKLAIM]', '[RESPONPOST_VKLAIM]', 200, 0, -1, false, '[RESPONPOST_VKLAIM]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->RESPONPOST_VKLAIM->Sortable = true; // Allow sort
        $this->RESPONPOST_VKLAIM->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->RESPONPOST_VKLAIM->Param, "CustomMsg");
        $this->RESPONPOST_VKLAIM->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['RESPONPOST_VKLAIM'] = &$this->RESPONPOST_VKLAIM;

        // RESPONPUT_VKLAIM
        $this->RESPONPUT_VKLAIM = new ReportField('register_ranap', 'register_ranap', 'x_RESPONPUT_VKLAIM', 'RESPONPUT_VKLAIM', '[RESPONPUT_VKLAIM]', '[RESPONPUT_VKLAIM]', 200, 0, -1, false, '[RESPONPUT_VKLAIM]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->RESPONPUT_VKLAIM->Sortable = true; // Allow sort
        $this->RESPONPUT_VKLAIM->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->RESPONPUT_VKLAIM->Param, "CustomMsg");
        $this->RESPONPUT_VKLAIM->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['RESPONPUT_VKLAIM'] = &$this->RESPONPUT_VKLAIM;

        // RESPONDEL_VKLAIM
        $this->RESPONDEL_VKLAIM = new ReportField('register_ranap', 'register_ranap', 'x_RESPONDEL_VKLAIM', 'RESPONDEL_VKLAIM', '[RESPONDEL_VKLAIM]', '[RESPONDEL_VKLAIM]', 200, 0, -1, false, '[RESPONDEL_VKLAIM]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->RESPONDEL_VKLAIM->Sortable = true; // Allow sort
        $this->RESPONDEL_VKLAIM->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->RESPONDEL_VKLAIM->Param, "CustomMsg");
        $this->RESPONDEL_VKLAIM->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['RESPONDEL_VKLAIM'] = &$this->RESPONDEL_VKLAIM;

        // CALL_TIMES
        $this->CALL_TIMES = new ReportField('register_ranap', 'register_ranap', 'x_CALL_TIMES', 'CALL_TIMES', '[CALL_TIMES]', 'CAST([CALL_TIMES] AS NVARCHAR)', 3, 4, -1, false, '[CALL_TIMES]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->CALL_TIMES->Sortable = true; // Allow sort
        $this->CALL_TIMES->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->CALL_TIMES->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->CALL_TIMES->Param, "CustomMsg");
        $this->CALL_TIMES->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['CALL_TIMES'] = &$this->CALL_TIMES;

        // CALL_DATE
        $this->CALL_DATE = new ReportField('register_ranap', 'register_ranap', 'x_CALL_DATE', 'CALL_DATE', '[CALL_DATE]', CastDateFieldForLike("[CALL_DATE]", 0, "DB"), 135, 8, 0, false, '[CALL_DATE]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->CALL_DATE->Sortable = true; // Allow sort
        $this->CALL_DATE->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->CALL_DATE->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->CALL_DATE->Param, "CustomMsg");
        $this->CALL_DATE->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['CALL_DATE'] = &$this->CALL_DATE;

        // CALL_DATES
        $this->CALL_DATES = new ReportField('register_ranap', 'register_ranap', 'x_CALL_DATES', 'CALL_DATES', '[CALL_DATES]', CastDateFieldForLike("[CALL_DATES]", 0, "DB"), 135, 8, 0, false, '[CALL_DATES]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->CALL_DATES->Sortable = true; // Allow sort
        $this->CALL_DATES->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->CALL_DATES->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->CALL_DATES->Param, "CustomMsg");
        $this->CALL_DATES->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['CALL_DATES'] = &$this->CALL_DATES;

        // SERVED_DATE
        $this->SERVED_DATE = new ReportField('register_ranap', 'register_ranap', 'x_SERVED_DATE', 'SERVED_DATE', '[SERVED_DATE]', CastDateFieldForLike("[SERVED_DATE]", 0, "DB"), 135, 8, 0, false, '[SERVED_DATE]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->SERVED_DATE->Sortable = true; // Allow sort
        $this->SERVED_DATE->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->SERVED_DATE->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->SERVED_DATE->Param, "CustomMsg");
        $this->SERVED_DATE->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['SERVED_DATE'] = &$this->SERVED_DATE;

        // KDDPJP1
        $this->KDDPJP1 = new ReportField('register_ranap', 'register_ranap', 'x_KDDPJP1', 'KDDPJP1', '[KDDPJP1]', '[KDDPJP1]', 200, 25, -1, false, '[KDDPJP1]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->KDDPJP1->Sortable = true; // Allow sort
        $this->KDDPJP1->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->KDDPJP1->Param, "CustomMsg");
        $this->KDDPJP1->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['KDDPJP1'] = &$this->KDDPJP1;

        // KDDPJP
        $this->KDDPJP = new ReportField('register_ranap', 'register_ranap', 'x_KDDPJP', 'KDDPJP', '[KDDPJP]', '[KDDPJP]', 200, 25, -1, false, '[KDDPJP]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->KDDPJP->Sortable = true; // Allow sort
        $this->KDDPJP->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->KDDPJP->Param, "CustomMsg");
        $this->KDDPJP->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['KDDPJP'] = &$this->KDDPJP;

        // tgl_kontrol
        $this->tgl_kontrol = new ReportField('register_ranap', 'register_ranap', 'x_tgl_kontrol', 'tgl_kontrol', '[tgl_kontrol]', CastDateFieldForLike("[tgl_kontrol]", 0, "DB"), 135, 8, 0, false, '[tgl_kontrol]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->tgl_kontrol->Sortable = true; // Allow sort
        $this->tgl_kontrol->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->tgl_kontrol->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->tgl_kontrol->Param, "CustomMsg");
        $this->tgl_kontrol->SourceTableVar = 'V_KUNJUNGAN_PASIEN';
        $this->Fields['tgl_kontrol'] = &$this->tgl_kontrol;
    }

    // Field Visibility
    public function getFieldVisibility($fldParm)
    {
        global $Security;
        return $this->$fldParm->Visible; // Returns original value
    }

    // Single column sort
    protected function updateSort(&$fld)
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
            $lastOrderBy = in_array($lastSort, ["ASC", "DESC"]) ? $sortField . " " . $lastSort : "";
            $curOrderBy = in_array($curSort, ["ASC", "DESC"]) ? $sortField . " " . $curSort : "";
            if ($fld->GroupingFieldId == 0) {
                $this->setDetailOrderBy($curOrderBy); // Save to Session
            }
        } else {
            if ($fld->GroupingFieldId == 0) {
                $fld->setSort("");
            }
        }
    }

    // Get Sort SQL
    protected function sortSql()
    {
        $dtlSortSql = $this->getDetailOrderBy(); // Get ORDER BY for detail fields from session
        $argrps = [];
        foreach ($this->Fields as $fld) {
            if (in_array($fld->getSort(), ["ASC", "DESC"])) {
                $fldsql = $fld->Expression;
                if ($fld->GroupingFieldId > 0) {
                    if ($fld->GroupSql != "") {
                        $argrps[$fld->GroupingFieldId] = str_replace("%s", $fldsql, $fld->GroupSql) . " " . $fld->getSort();
                    } else {
                        $argrps[$fld->GroupingFieldId] = $fldsql . " " . $fld->getSort();
                    }
                }
            }
        }
        $sortSql = "";
        foreach ($argrps as $grp) {
            if ($sortSql != "") {
                $sortSql .= ", ";
            }
            $sortSql .= $grp;
        }
        if ($dtlSortSql != "") {
            if ($sortSql != "") {
                $sortSql .= ", ";
            }
            $sortSql .= $dtlSortSql;
        }
        return $sortSql;
    }

    // Summary properties
    private $sqlSelectAggregate = null;
    private $sqlAggregatePrefix = "";
    private $sqlAggregateSuffix = "";
    private $sqlSelectCount = null;

    // Select Aggregate
    public function getSqlSelectAggregate()
    {
        return $this->sqlSelectAggregate ?? $this->getQueryBuilder()->select("COUNT(*) AS [cnt_idxdaftar]");
    }

    public function setSqlSelectAggregate($v)
    {
        $this->sqlSelectAggregate = $v;
    }

    // Aggregate Prefix
    public function getSqlAggregatePrefix()
    {
        return ($this->sqlAggregatePrefix != "") ? $this->sqlAggregatePrefix : "";
    }

    public function setSqlAggregatePrefix($v)
    {
        $this->sqlAggregatePrefix = $v;
    }

    // Aggregate Suffix
    public function getSqlAggregateSuffix()
    {
        return ($this->sqlAggregateSuffix != "") ? $this->sqlAggregateSuffix : "";
    }

    public function setSqlAggregateSuffix($v)
    {
        $this->sqlAggregateSuffix = $v;
    }

    // Select Count
    public function getSqlSelectCount()
    {
        return $this->sqlSelectCount ?? $this->getQueryBuilder()->select("COUNT(*)");
    }

    public function setSqlSelectCount($v)
    {
        $this->sqlSelectCount = $v;
    }

    // Render for lookup
    public function renderLookup()
    {
        $this->CLASS_ROOM_ID->ViewValue = GetDropDownDisplayValue($this->CLASS_ROOM_ID->CurrentValue, "", 0);
        $this->SERVED_INAP->ViewValue = FormatDateTime($this->SERVED_INAP->CurrentValue, 7);
    }

    // Table level SQL
    public function getSqlFrom() // From
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "dbo.PASIEN_VISITATION";
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
        if ($this->SqlSelect) {
            return $this->SqlSelect;
        }
        $select = $this->getQueryBuilder()->select("dbo.PASIEN_VISITATION.*");
        return $select;
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

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "[IDXDAFTAR] = @IDXDAFTAR@";
    }

    // Get Key
    public function getKey($current = false)
    {
        $keys = [];
        $val = $current ? $this->IDXDAFTAR->CurrentValue : $this->IDXDAFTAR->OldValue;
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
                $this->IDXDAFTAR->CurrentValue = $keys[0];
            } else {
                $this->IDXDAFTAR->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('IDXDAFTAR', $row) ? $row['IDXDAFTAR'] : null;
        } else {
            $val = $this->IDXDAFTAR->OldValue !== null ? $this->IDXDAFTAR->OldValue : $this->IDXDAFTAR->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@IDXDAFTAR@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return $_SESSION[$name] ?? GetUrl("");
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
        if ($pageName == "") {
            return $Language->phrase("View");
        } elseif ($pageName == "") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "") {
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
                return "";
            case Config("API_ADD_ACTION"):
                return "";
            case Config("API_EDIT_ACTION"):
                return "";
            case Config("API_DELETE_ACTION"):
                return "";
            case Config("API_LIST_ACTION"):
                return "";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "?" . $this->getUrlParm($parm);
        } else {
            $url = "";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("", $this->getUrlParm($parm));
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
        $url = $this->keyUrl("", $this->getUrlParm($parm));
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
        return $this->keyUrl("", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json .= "IDXDAFTAR:" . JsonEncode($this->IDXDAFTAR->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->IDXDAFTAR->CurrentValue !== null) {
            $url .= "/" . rawurlencode($this->IDXDAFTAR->CurrentValue);
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
        global $DashboardReport;
        if (
            $this->CurrentAction || $this->isExport() ||
            $this->DrillDown || $DashboardReport ||
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
            if (($keyValue = Param("IDXDAFTAR") ?? Route("IDXDAFTAR")) !== null) {
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
                $this->IDXDAFTAR->CurrentValue = $key;
            } else {
                $this->IDXDAFTAR->OldValue = $key;
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

    // Get file data
    public function getFileData($fldparm, $key, $resize, $width = 0, $height = 0, $plugins = [])
    {
        // No binary fields
        return false;
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
