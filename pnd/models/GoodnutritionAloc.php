<?php

namespace PHPMaker2021\SIMRSSQLSERVERPENDAFTARAN;

use Doctrine\DBAL\ParameterType;

/**
 * Table class for GOODNUTRITION_ALOC
 */
class GoodnutritionAloc extends DbTable
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
    public $ORG_UNIT_CODE;
    public $ITEM_ID;
    public $ORG_ID;
    public $DOC_NO;
    public $BATCH_NO;
    public $BRAND_ID;
    public $ROOMS_ID;
    public $SHELF_NO;
    public $EXPIRY_DATE;
    public $FROM_ROOMS_ID;
    public $DISTRIBUTION_TYPE;
    public $CONDITION;
    public $ALLOCATED_DATE;
    public $STOCKOPNAME_DATE;
    public $INVOICE_ID;
    public $ALLOCATED_FROM;
    public $PRICE;
    public $ORDER_PRICE;
    public $ITEM_ID_FROM;
    public $MODIFIED_DATE;
    public $MODIFIED_BY;
    public $STOCK_AVAILABLE;
    public $STOCK_OPNAME;
    public $STOK_AWAL;
    public $STOCK_LALU;
    public $STOCK_KOREKSI;
    public $DITERIMA;
    public $DISTRIBUSI;
    public $DIJUAL;
    public $DIHAPUS;
    public $DIMINTA;
    public $DIRETUR;
    public $PO;
    public $FUND_ID;
    public $INVOICE_ID2;
    public $MEASURE_ID3;
    public $SIZE_KEMASAN;
    public $BRAND_NAME;
    public $MEASURE_ID2;
    public $MONTH_ID;
    public $YEAR_ID;
    public $DISCOUNT;
    public $QUANTITY;
    public $MEASURE_ID;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'GOODNUTRITION_ALOC';
        $this->TableName = 'GOODNUTRITION_ALOC';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "[dbo].[GOODNUTRITION_ALOC]";
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
        $this->DetailEdit = false; // Allow detail edit
        $this->DetailView = false; // Allow detail view
        $this->ShowMultipleDetails = false; // Show multiple details
        $this->GridAddRowCount = 5;
        $this->AllowAddDeleteRow = true; // Allow add/delete row
        $this->UserIDAllowSecurity = Config("DEFAULT_USER_ID_ALLOW_SECURITY"); // Default User ID allowed permissions
        $this->BasicSearch = new BasicSearch($this->TableVar);

        // ORG_UNIT_CODE
        $this->ORG_UNIT_CODE = new DbField('GOODNUTRITION_ALOC', 'GOODNUTRITION_ALOC', 'x_ORG_UNIT_CODE', 'ORG_UNIT_CODE', '[ORG_UNIT_CODE]', '[ORG_UNIT_CODE]', 200, 50, -1, false, '[ORG_UNIT_CODE]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->ORG_UNIT_CODE->IsPrimaryKey = true; // Primary key field
        $this->ORG_UNIT_CODE->Nullable = false; // NOT NULL field
        $this->ORG_UNIT_CODE->Required = true; // Required field
        $this->ORG_UNIT_CODE->Sortable = true; // Allow sort
        $this->ORG_UNIT_CODE->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->ORG_UNIT_CODE->Param, "CustomMsg");
        $this->Fields['ORG_UNIT_CODE'] = &$this->ORG_UNIT_CODE;

        // ITEM_ID
        $this->ITEM_ID = new DbField('GOODNUTRITION_ALOC', 'GOODNUTRITION_ALOC', 'x_ITEM_ID', 'ITEM_ID', '[ITEM_ID]', '[ITEM_ID]', 200, 50, -1, false, '[ITEM_ID]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->ITEM_ID->IsPrimaryKey = true; // Primary key field
        $this->ITEM_ID->Nullable = false; // NOT NULL field
        $this->ITEM_ID->Required = true; // Required field
        $this->ITEM_ID->Sortable = true; // Allow sort
        $this->ITEM_ID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->ITEM_ID->Param, "CustomMsg");
        $this->Fields['ITEM_ID'] = &$this->ITEM_ID;

        // ORG_ID
        $this->ORG_ID = new DbField('GOODNUTRITION_ALOC', 'GOODNUTRITION_ALOC', 'x_ORG_ID', 'ORG_ID', '[ORG_ID]', '[ORG_ID]', 200, 50, -1, false, '[ORG_ID]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->ORG_ID->Sortable = true; // Allow sort
        $this->ORG_ID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->ORG_ID->Param, "CustomMsg");
        $this->Fields['ORG_ID'] = &$this->ORG_ID;

        // DOC_NO
        $this->DOC_NO = new DbField('GOODNUTRITION_ALOC', 'GOODNUTRITION_ALOC', 'x_DOC_NO', 'DOC_NO', '[DOC_NO]', '[DOC_NO]', 200, 50, -1, false, '[DOC_NO]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->DOC_NO->Sortable = true; // Allow sort
        $this->DOC_NO->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->DOC_NO->Param, "CustomMsg");
        $this->Fields['DOC_NO'] = &$this->DOC_NO;

        // BATCH_NO
        $this->BATCH_NO = new DbField('GOODNUTRITION_ALOC', 'GOODNUTRITION_ALOC', 'x_BATCH_NO', 'BATCH_NO', '[BATCH_NO]', '[BATCH_NO]', 200, 75, -1, false, '[BATCH_NO]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->BATCH_NO->Sortable = true; // Allow sort
        $this->BATCH_NO->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->BATCH_NO->Param, "CustomMsg");
        $this->Fields['BATCH_NO'] = &$this->BATCH_NO;

        // BRAND_ID
        $this->BRAND_ID = new DbField('GOODNUTRITION_ALOC', 'GOODNUTRITION_ALOC', 'x_BRAND_ID', 'BRAND_ID', '[BRAND_ID]', '[BRAND_ID]', 200, 50, -1, false, '[BRAND_ID]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->BRAND_ID->Nullable = false; // NOT NULL field
        $this->BRAND_ID->Required = true; // Required field
        $this->BRAND_ID->Sortable = true; // Allow sort
        $this->BRAND_ID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->BRAND_ID->Param, "CustomMsg");
        $this->Fields['BRAND_ID'] = &$this->BRAND_ID;

        // ROOMS_ID
        $this->ROOMS_ID = new DbField('GOODNUTRITION_ALOC', 'GOODNUTRITION_ALOC', 'x_ROOMS_ID', 'ROOMS_ID', '[ROOMS_ID]', '[ROOMS_ID]', 200, 10, -1, false, '[ROOMS_ID]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->ROOMS_ID->Nullable = false; // NOT NULL field
        $this->ROOMS_ID->Required = true; // Required field
        $this->ROOMS_ID->Sortable = true; // Allow sort
        $this->ROOMS_ID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->ROOMS_ID->Param, "CustomMsg");
        $this->Fields['ROOMS_ID'] = &$this->ROOMS_ID;

        // SHELF_NO
        $this->SHELF_NO = new DbField('GOODNUTRITION_ALOC', 'GOODNUTRITION_ALOC', 'x_SHELF_NO', 'SHELF_NO', '[SHELF_NO]', 'CAST([SHELF_NO] AS NVARCHAR)', 2, 2, -1, false, '[SHELF_NO]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->SHELF_NO->Sortable = true; // Allow sort
        $this->SHELF_NO->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->SHELF_NO->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->SHELF_NO->Param, "CustomMsg");
        $this->Fields['SHELF_NO'] = &$this->SHELF_NO;

        // EXPIRY_DATE
        $this->EXPIRY_DATE = new DbField('GOODNUTRITION_ALOC', 'GOODNUTRITION_ALOC', 'x_EXPIRY_DATE', 'EXPIRY_DATE', '[EXPIRY_DATE]', CastDateFieldForLike("[EXPIRY_DATE]", 0, "DB"), 135, 8, 0, false, '[EXPIRY_DATE]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->EXPIRY_DATE->Sortable = true; // Allow sort
        $this->EXPIRY_DATE->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->EXPIRY_DATE->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->EXPIRY_DATE->Param, "CustomMsg");
        $this->Fields['EXPIRY_DATE'] = &$this->EXPIRY_DATE;

        // FROM_ROOMS_ID
        $this->FROM_ROOMS_ID = new DbField('GOODNUTRITION_ALOC', 'GOODNUTRITION_ALOC', 'x_FROM_ROOMS_ID', 'FROM_ROOMS_ID', '[FROM_ROOMS_ID]', '[FROM_ROOMS_ID]', 200, 10, -1, false, '[FROM_ROOMS_ID]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->FROM_ROOMS_ID->Sortable = true; // Allow sort
        $this->FROM_ROOMS_ID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->FROM_ROOMS_ID->Param, "CustomMsg");
        $this->Fields['FROM_ROOMS_ID'] = &$this->FROM_ROOMS_ID;

        // DISTRIBUTION_TYPE
        $this->DISTRIBUTION_TYPE = new DbField('GOODNUTRITION_ALOC', 'GOODNUTRITION_ALOC', 'x_DISTRIBUTION_TYPE', 'DISTRIBUTION_TYPE', '[DISTRIBUTION_TYPE]', 'CAST([DISTRIBUTION_TYPE] AS NVARCHAR)', 17, 1, -1, false, '[DISTRIBUTION_TYPE]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->DISTRIBUTION_TYPE->Sortable = true; // Allow sort
        $this->DISTRIBUTION_TYPE->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->DISTRIBUTION_TYPE->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->DISTRIBUTION_TYPE->Param, "CustomMsg");
        $this->Fields['DISTRIBUTION_TYPE'] = &$this->DISTRIBUTION_TYPE;

        // CONDITION
        $this->CONDITION = new DbField('GOODNUTRITION_ALOC', 'GOODNUTRITION_ALOC', 'x_CONDITION', 'CONDITION', '[CONDITION]', 'CAST([CONDITION] AS NVARCHAR)', 17, 1, -1, false, '[CONDITION]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->CONDITION->Sortable = true; // Allow sort
        $this->CONDITION->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->CONDITION->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->CONDITION->Param, "CustomMsg");
        $this->Fields['CONDITION'] = &$this->CONDITION;

        // ALLOCATED_DATE
        $this->ALLOCATED_DATE = new DbField('GOODNUTRITION_ALOC', 'GOODNUTRITION_ALOC', 'x_ALLOCATED_DATE', 'ALLOCATED_DATE', '[ALLOCATED_DATE]', CastDateFieldForLike("[ALLOCATED_DATE]", 0, "DB"), 135, 8, 0, false, '[ALLOCATED_DATE]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->ALLOCATED_DATE->Sortable = true; // Allow sort
        $this->ALLOCATED_DATE->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->ALLOCATED_DATE->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->ALLOCATED_DATE->Param, "CustomMsg");
        $this->Fields['ALLOCATED_DATE'] = &$this->ALLOCATED_DATE;

        // STOCKOPNAME_DATE
        $this->STOCKOPNAME_DATE = new DbField('GOODNUTRITION_ALOC', 'GOODNUTRITION_ALOC', 'x_STOCKOPNAME_DATE', 'STOCKOPNAME_DATE', '[STOCKOPNAME_DATE]', CastDateFieldForLike("[STOCKOPNAME_DATE]", 0, "DB"), 135, 8, 0, false, '[STOCKOPNAME_DATE]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->STOCKOPNAME_DATE->Sortable = true; // Allow sort
        $this->STOCKOPNAME_DATE->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->STOCKOPNAME_DATE->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->STOCKOPNAME_DATE->Param, "CustomMsg");
        $this->Fields['STOCKOPNAME_DATE'] = &$this->STOCKOPNAME_DATE;

        // INVOICE_ID
        $this->INVOICE_ID = new DbField('GOODNUTRITION_ALOC', 'GOODNUTRITION_ALOC', 'x_INVOICE_ID', 'INVOICE_ID', '[INVOICE_ID]', '[INVOICE_ID]', 200, 50, -1, false, '[INVOICE_ID]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->INVOICE_ID->Sortable = true; // Allow sort
        $this->INVOICE_ID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->INVOICE_ID->Param, "CustomMsg");
        $this->Fields['INVOICE_ID'] = &$this->INVOICE_ID;

        // ALLOCATED_FROM
        $this->ALLOCATED_FROM = new DbField('GOODNUTRITION_ALOC', 'GOODNUTRITION_ALOC', 'x_ALLOCATED_FROM', 'ALLOCATED_FROM', '[ALLOCATED_FROM]', '[ALLOCATED_FROM]', 200, 255, -1, false, '[ALLOCATED_FROM]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->ALLOCATED_FROM->Sortable = true; // Allow sort
        $this->ALLOCATED_FROM->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->ALLOCATED_FROM->Param, "CustomMsg");
        $this->Fields['ALLOCATED_FROM'] = &$this->ALLOCATED_FROM;

        // PRICE
        $this->PRICE = new DbField('GOODNUTRITION_ALOC', 'GOODNUTRITION_ALOC', 'x_PRICE', 'PRICE', '[PRICE]', 'CAST([PRICE] AS NVARCHAR)', 6, 8, -1, false, '[PRICE]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->PRICE->Sortable = true; // Allow sort
        $this->PRICE->DefaultDecimalPrecision = 2; // Default decimal precision
        $this->PRICE->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->PRICE->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->PRICE->Param, "CustomMsg");
        $this->Fields['PRICE'] = &$this->PRICE;

        // ORDER_PRICE
        $this->ORDER_PRICE = new DbField('GOODNUTRITION_ALOC', 'GOODNUTRITION_ALOC', 'x_ORDER_PRICE', 'ORDER_PRICE', '[ORDER_PRICE]', 'CAST([ORDER_PRICE] AS NVARCHAR)', 6, 8, -1, false, '[ORDER_PRICE]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->ORDER_PRICE->Sortable = true; // Allow sort
        $this->ORDER_PRICE->DefaultDecimalPrecision = 2; // Default decimal precision
        $this->ORDER_PRICE->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->ORDER_PRICE->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->ORDER_PRICE->Param, "CustomMsg");
        $this->Fields['ORDER_PRICE'] = &$this->ORDER_PRICE;

        // ITEM_ID_FROM
        $this->ITEM_ID_FROM = new DbField('GOODNUTRITION_ALOC', 'GOODNUTRITION_ALOC', 'x_ITEM_ID_FROM', 'ITEM_ID_FROM', '[ITEM_ID_FROM]', '[ITEM_ID_FROM]', 200, 50, -1, false, '[ITEM_ID_FROM]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->ITEM_ID_FROM->Sortable = true; // Allow sort
        $this->ITEM_ID_FROM->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->ITEM_ID_FROM->Param, "CustomMsg");
        $this->Fields['ITEM_ID_FROM'] = &$this->ITEM_ID_FROM;

        // MODIFIED_DATE
        $this->MODIFIED_DATE = new DbField('GOODNUTRITION_ALOC', 'GOODNUTRITION_ALOC', 'x_MODIFIED_DATE', 'MODIFIED_DATE', '[MODIFIED_DATE]', CastDateFieldForLike("[MODIFIED_DATE]", 0, "DB"), 135, 8, 0, false, '[MODIFIED_DATE]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->MODIFIED_DATE->Sortable = true; // Allow sort
        $this->MODIFIED_DATE->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->MODIFIED_DATE->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->MODIFIED_DATE->Param, "CustomMsg");
        $this->Fields['MODIFIED_DATE'] = &$this->MODIFIED_DATE;

        // MODIFIED_BY
        $this->MODIFIED_BY = new DbField('GOODNUTRITION_ALOC', 'GOODNUTRITION_ALOC', 'x_MODIFIED_BY', 'MODIFIED_BY', '[MODIFIED_BY]', '[MODIFIED_BY]', 200, 50, -1, false, '[MODIFIED_BY]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->MODIFIED_BY->Sortable = true; // Allow sort
        $this->MODIFIED_BY->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->MODIFIED_BY->Param, "CustomMsg");
        $this->Fields['MODIFIED_BY'] = &$this->MODIFIED_BY;

        // STOCK_AVAILABLE
        $this->STOCK_AVAILABLE = new DbField('GOODNUTRITION_ALOC', 'GOODNUTRITION_ALOC', 'x_STOCK_AVAILABLE', 'STOCK_AVAILABLE', '[STOCK_AVAILABLE]', 'CAST([STOCK_AVAILABLE] AS NVARCHAR)', 131, 8, -1, false, '[STOCK_AVAILABLE]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->STOCK_AVAILABLE->Sortable = true; // Allow sort
        $this->STOCK_AVAILABLE->DefaultDecimalPrecision = 2; // Default decimal precision
        $this->STOCK_AVAILABLE->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->STOCK_AVAILABLE->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->STOCK_AVAILABLE->Param, "CustomMsg");
        $this->Fields['STOCK_AVAILABLE'] = &$this->STOCK_AVAILABLE;

        // STOCK_OPNAME
        $this->STOCK_OPNAME = new DbField('GOODNUTRITION_ALOC', 'GOODNUTRITION_ALOC', 'x_STOCK_OPNAME', 'STOCK_OPNAME', '[STOCK_OPNAME]', 'CAST([STOCK_OPNAME] AS NVARCHAR)', 131, 8, -1, false, '[STOCK_OPNAME]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->STOCK_OPNAME->Sortable = true; // Allow sort
        $this->STOCK_OPNAME->DefaultDecimalPrecision = 2; // Default decimal precision
        $this->STOCK_OPNAME->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->STOCK_OPNAME->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->STOCK_OPNAME->Param, "CustomMsg");
        $this->Fields['STOCK_OPNAME'] = &$this->STOCK_OPNAME;

        // STOK_AWAL
        $this->STOK_AWAL = new DbField('GOODNUTRITION_ALOC', 'GOODNUTRITION_ALOC', 'x_STOK_AWAL', 'STOK_AWAL', '[STOK_AWAL]', 'CAST([STOK_AWAL] AS NVARCHAR)', 131, 8, -1, false, '[STOK_AWAL]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->STOK_AWAL->Sortable = true; // Allow sort
        $this->STOK_AWAL->DefaultDecimalPrecision = 2; // Default decimal precision
        $this->STOK_AWAL->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->STOK_AWAL->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->STOK_AWAL->Param, "CustomMsg");
        $this->Fields['STOK_AWAL'] = &$this->STOK_AWAL;

        // STOCK_LALU
        $this->STOCK_LALU = new DbField('GOODNUTRITION_ALOC', 'GOODNUTRITION_ALOC', 'x_STOCK_LALU', 'STOCK_LALU', '[STOCK_LALU]', 'CAST([STOCK_LALU] AS NVARCHAR)', 131, 8, -1, false, '[STOCK_LALU]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->STOCK_LALU->Sortable = true; // Allow sort
        $this->STOCK_LALU->DefaultDecimalPrecision = 2; // Default decimal precision
        $this->STOCK_LALU->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->STOCK_LALU->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->STOCK_LALU->Param, "CustomMsg");
        $this->Fields['STOCK_LALU'] = &$this->STOCK_LALU;

        // STOCK_KOREKSI
        $this->STOCK_KOREKSI = new DbField('GOODNUTRITION_ALOC', 'GOODNUTRITION_ALOC', 'x_STOCK_KOREKSI', 'STOCK_KOREKSI', '[STOCK_KOREKSI]', 'CAST([STOCK_KOREKSI] AS NVARCHAR)', 131, 8, -1, false, '[STOCK_KOREKSI]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->STOCK_KOREKSI->Sortable = true; // Allow sort
        $this->STOCK_KOREKSI->DefaultDecimalPrecision = 2; // Default decimal precision
        $this->STOCK_KOREKSI->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->STOCK_KOREKSI->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->STOCK_KOREKSI->Param, "CustomMsg");
        $this->Fields['STOCK_KOREKSI'] = &$this->STOCK_KOREKSI;

        // DITERIMA
        $this->DITERIMA = new DbField('GOODNUTRITION_ALOC', 'GOODNUTRITION_ALOC', 'x_DITERIMA', 'DITERIMA', '[DITERIMA]', 'CAST([DITERIMA] AS NVARCHAR)', 131, 8, -1, false, '[DITERIMA]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->DITERIMA->Sortable = true; // Allow sort
        $this->DITERIMA->DefaultDecimalPrecision = 2; // Default decimal precision
        $this->DITERIMA->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->DITERIMA->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->DITERIMA->Param, "CustomMsg");
        $this->Fields['DITERIMA'] = &$this->DITERIMA;

        // DISTRIBUSI
        $this->DISTRIBUSI = new DbField('GOODNUTRITION_ALOC', 'GOODNUTRITION_ALOC', 'x_DISTRIBUSI', 'DISTRIBUSI', '[DISTRIBUSI]', 'CAST([DISTRIBUSI] AS NVARCHAR)', 131, 8, -1, false, '[DISTRIBUSI]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->DISTRIBUSI->Sortable = true; // Allow sort
        $this->DISTRIBUSI->DefaultDecimalPrecision = 2; // Default decimal precision
        $this->DISTRIBUSI->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->DISTRIBUSI->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->DISTRIBUSI->Param, "CustomMsg");
        $this->Fields['DISTRIBUSI'] = &$this->DISTRIBUSI;

        // DIJUAL
        $this->DIJUAL = new DbField('GOODNUTRITION_ALOC', 'GOODNUTRITION_ALOC', 'x_DIJUAL', 'DIJUAL', '[DIJUAL]', 'CAST([DIJUAL] AS NVARCHAR)', 131, 8, -1, false, '[DIJUAL]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->DIJUAL->Sortable = true; // Allow sort
        $this->DIJUAL->DefaultDecimalPrecision = 2; // Default decimal precision
        $this->DIJUAL->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->DIJUAL->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->DIJUAL->Param, "CustomMsg");
        $this->Fields['DIJUAL'] = &$this->DIJUAL;

        // DIHAPUS
        $this->DIHAPUS = new DbField('GOODNUTRITION_ALOC', 'GOODNUTRITION_ALOC', 'x_DIHAPUS', 'DIHAPUS', '[DIHAPUS]', 'CAST([DIHAPUS] AS NVARCHAR)', 131, 8, -1, false, '[DIHAPUS]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->DIHAPUS->Sortable = true; // Allow sort
        $this->DIHAPUS->DefaultDecimalPrecision = 2; // Default decimal precision
        $this->DIHAPUS->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->DIHAPUS->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->DIHAPUS->Param, "CustomMsg");
        $this->Fields['DIHAPUS'] = &$this->DIHAPUS;

        // DIMINTA
        $this->DIMINTA = new DbField('GOODNUTRITION_ALOC', 'GOODNUTRITION_ALOC', 'x_DIMINTA', 'DIMINTA', '[DIMINTA]', 'CAST([DIMINTA] AS NVARCHAR)', 131, 8, -1, false, '[DIMINTA]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->DIMINTA->Sortable = true; // Allow sort
        $this->DIMINTA->DefaultDecimalPrecision = 2; // Default decimal precision
        $this->DIMINTA->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->DIMINTA->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->DIMINTA->Param, "CustomMsg");
        $this->Fields['DIMINTA'] = &$this->DIMINTA;

        // DIRETUR
        $this->DIRETUR = new DbField('GOODNUTRITION_ALOC', 'GOODNUTRITION_ALOC', 'x_DIRETUR', 'DIRETUR', '[DIRETUR]', 'CAST([DIRETUR] AS NVARCHAR)', 131, 8, -1, false, '[DIRETUR]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->DIRETUR->Sortable = true; // Allow sort
        $this->DIRETUR->DefaultDecimalPrecision = 2; // Default decimal precision
        $this->DIRETUR->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->DIRETUR->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->DIRETUR->Param, "CustomMsg");
        $this->Fields['DIRETUR'] = &$this->DIRETUR;

        // PO
        $this->PO = new DbField('GOODNUTRITION_ALOC', 'GOODNUTRITION_ALOC', 'x_PO', 'PO', '[PO]', '[PO]', 200, 50, -1, false, '[PO]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->PO->Sortable = true; // Allow sort
        $this->PO->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->PO->Param, "CustomMsg");
        $this->Fields['PO'] = &$this->PO;

        // FUND_ID
        $this->FUND_ID = new DbField('GOODNUTRITION_ALOC', 'GOODNUTRITION_ALOC', 'x_FUND_ID', 'FUND_ID', '[FUND_ID]', 'CAST([FUND_ID] AS NVARCHAR)', 17, 1, -1, false, '[FUND_ID]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->FUND_ID->Sortable = true; // Allow sort
        $this->FUND_ID->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->FUND_ID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->FUND_ID->Param, "CustomMsg");
        $this->Fields['FUND_ID'] = &$this->FUND_ID;

        // INVOICE_ID2
        $this->INVOICE_ID2 = new DbField('GOODNUTRITION_ALOC', 'GOODNUTRITION_ALOC', 'x_INVOICE_ID2', 'INVOICE_ID2', '[INVOICE_ID2]', '[INVOICE_ID2]', 200, 25, -1, false, '[INVOICE_ID2]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->INVOICE_ID2->Sortable = true; // Allow sort
        $this->INVOICE_ID2->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->INVOICE_ID2->Param, "CustomMsg");
        $this->Fields['INVOICE_ID2'] = &$this->INVOICE_ID2;

        // MEASURE_ID3
        $this->MEASURE_ID3 = new DbField('GOODNUTRITION_ALOC', 'GOODNUTRITION_ALOC', 'x_MEASURE_ID3', 'MEASURE_ID3', '[MEASURE_ID3]', 'CAST([MEASURE_ID3] AS NVARCHAR)', 2, 2, -1, false, '[MEASURE_ID3]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->MEASURE_ID3->Sortable = true; // Allow sort
        $this->MEASURE_ID3->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->MEASURE_ID3->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->MEASURE_ID3->Param, "CustomMsg");
        $this->Fields['MEASURE_ID3'] = &$this->MEASURE_ID3;

        // SIZE_KEMASAN
        $this->SIZE_KEMASAN = new DbField('GOODNUTRITION_ALOC', 'GOODNUTRITION_ALOC', 'x_SIZE_KEMASAN', 'SIZE_KEMASAN', '[SIZE_KEMASAN]', 'CAST([SIZE_KEMASAN] AS NVARCHAR)', 131, 8, -1, false, '[SIZE_KEMASAN]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->SIZE_KEMASAN->Sortable = true; // Allow sort
        $this->SIZE_KEMASAN->DefaultDecimalPrecision = 2; // Default decimal precision
        $this->SIZE_KEMASAN->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->SIZE_KEMASAN->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->SIZE_KEMASAN->Param, "CustomMsg");
        $this->Fields['SIZE_KEMASAN'] = &$this->SIZE_KEMASAN;

        // BRAND_NAME
        $this->BRAND_NAME = new DbField('GOODNUTRITION_ALOC', 'GOODNUTRITION_ALOC', 'x_BRAND_NAME', 'BRAND_NAME', '[BRAND_NAME]', '[BRAND_NAME]', 200, 150, -1, false, '[BRAND_NAME]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->BRAND_NAME->Sortable = true; // Allow sort
        $this->BRAND_NAME->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->BRAND_NAME->Param, "CustomMsg");
        $this->Fields['BRAND_NAME'] = &$this->BRAND_NAME;

        // MEASURE_ID2
        $this->MEASURE_ID2 = new DbField('GOODNUTRITION_ALOC', 'GOODNUTRITION_ALOC', 'x_MEASURE_ID2', 'MEASURE_ID2', '[MEASURE_ID2]', 'CAST([MEASURE_ID2] AS NVARCHAR)', 2, 2, -1, false, '[MEASURE_ID2]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->MEASURE_ID2->Sortable = true; // Allow sort
        $this->MEASURE_ID2->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->MEASURE_ID2->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->MEASURE_ID2->Param, "CustomMsg");
        $this->Fields['MEASURE_ID2'] = &$this->MEASURE_ID2;

        // MONTH_ID
        $this->MONTH_ID = new DbField('GOODNUTRITION_ALOC', 'GOODNUTRITION_ALOC', 'x_MONTH_ID', 'MONTH_ID', '[MONTH_ID]', 'CAST([MONTH_ID] AS NVARCHAR)', 17, 1, -1, false, '[MONTH_ID]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->MONTH_ID->Sortable = true; // Allow sort
        $this->MONTH_ID->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->MONTH_ID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->MONTH_ID->Param, "CustomMsg");
        $this->Fields['MONTH_ID'] = &$this->MONTH_ID;

        // YEAR_ID
        $this->YEAR_ID = new DbField('GOODNUTRITION_ALOC', 'GOODNUTRITION_ALOC', 'x_YEAR_ID', 'YEAR_ID', '[YEAR_ID]', 'CAST([YEAR_ID] AS NVARCHAR)', 2, 2, -1, false, '[YEAR_ID]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->YEAR_ID->Sortable = true; // Allow sort
        $this->YEAR_ID->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->YEAR_ID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->YEAR_ID->Param, "CustomMsg");
        $this->Fields['YEAR_ID'] = &$this->YEAR_ID;

        // DISCOUNT
        $this->DISCOUNT = new DbField('GOODNUTRITION_ALOC', 'GOODNUTRITION_ALOC', 'x_DISCOUNT', 'DISCOUNT', '[DISCOUNT]', 'CAST([DISCOUNT] AS NVARCHAR)', 131, 8, -1, false, '[DISCOUNT]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->DISCOUNT->Sortable = true; // Allow sort
        $this->DISCOUNT->DefaultDecimalPrecision = 2; // Default decimal precision
        $this->DISCOUNT->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->DISCOUNT->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->DISCOUNT->Param, "CustomMsg");
        $this->Fields['DISCOUNT'] = &$this->DISCOUNT;

        // QUANTITY
        $this->QUANTITY = new DbField('GOODNUTRITION_ALOC', 'GOODNUTRITION_ALOC', 'x_QUANTITY', 'QUANTITY', '[QUANTITY]', 'CAST([QUANTITY] AS NVARCHAR)', 131, 8, -1, false, '[QUANTITY]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->QUANTITY->Sortable = true; // Allow sort
        $this->QUANTITY->DefaultDecimalPrecision = 2; // Default decimal precision
        $this->QUANTITY->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->QUANTITY->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->QUANTITY->Param, "CustomMsg");
        $this->Fields['QUANTITY'] = &$this->QUANTITY;

        // MEASURE_ID
        $this->MEASURE_ID = new DbField('GOODNUTRITION_ALOC', 'GOODNUTRITION_ALOC', 'x_MEASURE_ID', 'MEASURE_ID', '[MEASURE_ID]', 'CAST([MEASURE_ID] AS NVARCHAR)', 2, 2, -1, false, '[MEASURE_ID]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->MEASURE_ID->Sortable = true; // Allow sort
        $this->MEASURE_ID->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->MEASURE_ID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->MEASURE_ID->Param, "CustomMsg");
        $this->Fields['MEASURE_ID'] = &$this->MEASURE_ID;
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

    // Table level SQL
    public function getSqlFrom() // From
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "[dbo].[GOODNUTRITION_ALOC]";
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
        return $this->SqlSelect ?? $this->getQueryBuilder()->select("*");
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
            if (array_key_exists('ORG_UNIT_CODE', $rs)) {
                AddFilter($where, QuotedName('ORG_UNIT_CODE', $this->Dbid) . '=' . QuotedValue($rs['ORG_UNIT_CODE'], $this->ORG_UNIT_CODE->DataType, $this->Dbid));
            }
            if (array_key_exists('ITEM_ID', $rs)) {
                AddFilter($where, QuotedName('ITEM_ID', $this->Dbid) . '=' . QuotedValue($rs['ITEM_ID'], $this->ITEM_ID->DataType, $this->Dbid));
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
        $this->ORG_UNIT_CODE->DbValue = $row['ORG_UNIT_CODE'];
        $this->ITEM_ID->DbValue = $row['ITEM_ID'];
        $this->ORG_ID->DbValue = $row['ORG_ID'];
        $this->DOC_NO->DbValue = $row['DOC_NO'];
        $this->BATCH_NO->DbValue = $row['BATCH_NO'];
        $this->BRAND_ID->DbValue = $row['BRAND_ID'];
        $this->ROOMS_ID->DbValue = $row['ROOMS_ID'];
        $this->SHELF_NO->DbValue = $row['SHELF_NO'];
        $this->EXPIRY_DATE->DbValue = $row['EXPIRY_DATE'];
        $this->FROM_ROOMS_ID->DbValue = $row['FROM_ROOMS_ID'];
        $this->DISTRIBUTION_TYPE->DbValue = $row['DISTRIBUTION_TYPE'];
        $this->CONDITION->DbValue = $row['CONDITION'];
        $this->ALLOCATED_DATE->DbValue = $row['ALLOCATED_DATE'];
        $this->STOCKOPNAME_DATE->DbValue = $row['STOCKOPNAME_DATE'];
        $this->INVOICE_ID->DbValue = $row['INVOICE_ID'];
        $this->ALLOCATED_FROM->DbValue = $row['ALLOCATED_FROM'];
        $this->PRICE->DbValue = $row['PRICE'];
        $this->ORDER_PRICE->DbValue = $row['ORDER_PRICE'];
        $this->ITEM_ID_FROM->DbValue = $row['ITEM_ID_FROM'];
        $this->MODIFIED_DATE->DbValue = $row['MODIFIED_DATE'];
        $this->MODIFIED_BY->DbValue = $row['MODIFIED_BY'];
        $this->STOCK_AVAILABLE->DbValue = $row['STOCK_AVAILABLE'];
        $this->STOCK_OPNAME->DbValue = $row['STOCK_OPNAME'];
        $this->STOK_AWAL->DbValue = $row['STOK_AWAL'];
        $this->STOCK_LALU->DbValue = $row['STOCK_LALU'];
        $this->STOCK_KOREKSI->DbValue = $row['STOCK_KOREKSI'];
        $this->DITERIMA->DbValue = $row['DITERIMA'];
        $this->DISTRIBUSI->DbValue = $row['DISTRIBUSI'];
        $this->DIJUAL->DbValue = $row['DIJUAL'];
        $this->DIHAPUS->DbValue = $row['DIHAPUS'];
        $this->DIMINTA->DbValue = $row['DIMINTA'];
        $this->DIRETUR->DbValue = $row['DIRETUR'];
        $this->PO->DbValue = $row['PO'];
        $this->FUND_ID->DbValue = $row['FUND_ID'];
        $this->INVOICE_ID2->DbValue = $row['INVOICE_ID2'];
        $this->MEASURE_ID3->DbValue = $row['MEASURE_ID3'];
        $this->SIZE_KEMASAN->DbValue = $row['SIZE_KEMASAN'];
        $this->BRAND_NAME->DbValue = $row['BRAND_NAME'];
        $this->MEASURE_ID2->DbValue = $row['MEASURE_ID2'];
        $this->MONTH_ID->DbValue = $row['MONTH_ID'];
        $this->YEAR_ID->DbValue = $row['YEAR_ID'];
        $this->DISCOUNT->DbValue = $row['DISCOUNT'];
        $this->QUANTITY->DbValue = $row['QUANTITY'];
        $this->MEASURE_ID->DbValue = $row['MEASURE_ID'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "[ORG_UNIT_CODE] = '@ORG_UNIT_CODE@' AND [ITEM_ID] = '@ITEM_ID@'";
    }

    // Get Key
    public function getKey($current = false)
    {
        $keys = [];
        $val = $current ? $this->ORG_UNIT_CODE->CurrentValue : $this->ORG_UNIT_CODE->OldValue;
        if (EmptyValue($val)) {
            return "";
        } else {
            $keys[] = $val;
        }
        $val = $current ? $this->ITEM_ID->CurrentValue : $this->ITEM_ID->OldValue;
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
        if (count($keys) == 2) {
            if ($current) {
                $this->ORG_UNIT_CODE->CurrentValue = $keys[0];
            } else {
                $this->ORG_UNIT_CODE->OldValue = $keys[0];
            }
            if ($current) {
                $this->ITEM_ID->CurrentValue = $keys[1];
            } else {
                $this->ITEM_ID->OldValue = $keys[1];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('ORG_UNIT_CODE', $row) ? $row['ORG_UNIT_CODE'] : null;
        } else {
            $val = $this->ORG_UNIT_CODE->OldValue !== null ? $this->ORG_UNIT_CODE->OldValue : $this->ORG_UNIT_CODE->CurrentValue;
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@ORG_UNIT_CODE@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
        }
        if (is_array($row)) {
            $val = array_key_exists('ITEM_ID', $row) ? $row['ITEM_ID'] : null;
        } else {
            $val = $this->ITEM_ID->OldValue !== null ? $this->ITEM_ID->OldValue : $this->ITEM_ID->CurrentValue;
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@ITEM_ID@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return $_SESSION[$name] ?? GetUrl("GoodnutritionAlocList");
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
        if ($pageName == "GoodnutritionAlocView") {
            return $Language->phrase("View");
        } elseif ($pageName == "GoodnutritionAlocEdit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "GoodnutritionAlocAdd") {
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
                return "GoodnutritionAlocView";
            case Config("API_ADD_ACTION"):
                return "GoodnutritionAlocAdd";
            case Config("API_EDIT_ACTION"):
                return "GoodnutritionAlocEdit";
            case Config("API_DELETE_ACTION"):
                return "GoodnutritionAlocDelete";
            case Config("API_LIST_ACTION"):
                return "GoodnutritionAlocList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "GoodnutritionAlocList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("GoodnutritionAlocView", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("GoodnutritionAlocView", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "GoodnutritionAlocAdd?" . $this->getUrlParm($parm);
        } else {
            $url = "GoodnutritionAlocAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("GoodnutritionAlocEdit", $this->getUrlParm($parm));
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
        $url = $this->keyUrl("GoodnutritionAlocAdd", $this->getUrlParm($parm));
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
        return $this->keyUrl("GoodnutritionAlocDelete", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json .= "ORG_UNIT_CODE:" . JsonEncode($this->ORG_UNIT_CODE->CurrentValue, "string");
        $json .= ",ITEM_ID:" . JsonEncode($this->ITEM_ID->CurrentValue, "string");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->ORG_UNIT_CODE->CurrentValue !== null) {
            $url .= "/" . rawurlencode($this->ORG_UNIT_CODE->CurrentValue);
        } else {
            return "javascript:ew.alert(ew.language.phrase('InvalidRecord'));";
        }
        if ($this->ITEM_ID->CurrentValue !== null) {
            $url .= "/" . rawurlencode($this->ITEM_ID->CurrentValue);
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
            for ($i = 0; $i < $cnt; $i++) {
                $arKeys[$i] = explode(Config("COMPOSITE_KEY_SEPARATOR"), $arKeys[$i]);
            }
        } else {
            if (($keyValue = Param("ORG_UNIT_CODE") ?? Route("ORG_UNIT_CODE")) !== null) {
                $arKey[] = $keyValue;
            } elseif (IsApi() && (($keyValue = Key(0) ?? Route(2)) !== null)) {
                $arKey[] = $keyValue;
            } else {
                $arKeys = null; // Do not setup
            }
            if (($keyValue = Param("ITEM_ID") ?? Route("ITEM_ID")) !== null) {
                $arKey[] = $keyValue;
            } elseif (IsApi() && (($keyValue = Key(1) ?? Route(3)) !== null)) {
                $arKey[] = $keyValue;
            } else {
                $arKeys = null; // Do not setup
            }
            if (is_array($arKeys)) {
                $arKeys[] = $arKey;
            }

            //return $arKeys; // Do not return yet, so the values will also be checked by the following code
        }
        // Check keys
        $ar = [];
        if (is_array($arKeys)) {
            foreach ($arKeys as $key) {
                if (!is_array($key) || count($key) != 2) {
                    continue; // Just skip so other keys will still work
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
                $this->ORG_UNIT_CODE->CurrentValue = $key[0];
            } else {
                $this->ORG_UNIT_CODE->OldValue = $key[0];
            }
            if ($setCurrent) {
                $this->ITEM_ID->CurrentValue = $key[1];
            } else {
                $this->ITEM_ID->OldValue = $key[1];
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
        $this->ORG_UNIT_CODE->setDbValue($row['ORG_UNIT_CODE']);
        $this->ITEM_ID->setDbValue($row['ITEM_ID']);
        $this->ORG_ID->setDbValue($row['ORG_ID']);
        $this->DOC_NO->setDbValue($row['DOC_NO']);
        $this->BATCH_NO->setDbValue($row['BATCH_NO']);
        $this->BRAND_ID->setDbValue($row['BRAND_ID']);
        $this->ROOMS_ID->setDbValue($row['ROOMS_ID']);
        $this->SHELF_NO->setDbValue($row['SHELF_NO']);
        $this->EXPIRY_DATE->setDbValue($row['EXPIRY_DATE']);
        $this->FROM_ROOMS_ID->setDbValue($row['FROM_ROOMS_ID']);
        $this->DISTRIBUTION_TYPE->setDbValue($row['DISTRIBUTION_TYPE']);
        $this->CONDITION->setDbValue($row['CONDITION']);
        $this->ALLOCATED_DATE->setDbValue($row['ALLOCATED_DATE']);
        $this->STOCKOPNAME_DATE->setDbValue($row['STOCKOPNAME_DATE']);
        $this->INVOICE_ID->setDbValue($row['INVOICE_ID']);
        $this->ALLOCATED_FROM->setDbValue($row['ALLOCATED_FROM']);
        $this->PRICE->setDbValue($row['PRICE']);
        $this->ORDER_PRICE->setDbValue($row['ORDER_PRICE']);
        $this->ITEM_ID_FROM->setDbValue($row['ITEM_ID_FROM']);
        $this->MODIFIED_DATE->setDbValue($row['MODIFIED_DATE']);
        $this->MODIFIED_BY->setDbValue($row['MODIFIED_BY']);
        $this->STOCK_AVAILABLE->setDbValue($row['STOCK_AVAILABLE']);
        $this->STOCK_OPNAME->setDbValue($row['STOCK_OPNAME']);
        $this->STOK_AWAL->setDbValue($row['STOK_AWAL']);
        $this->STOCK_LALU->setDbValue($row['STOCK_LALU']);
        $this->STOCK_KOREKSI->setDbValue($row['STOCK_KOREKSI']);
        $this->DITERIMA->setDbValue($row['DITERIMA']);
        $this->DISTRIBUSI->setDbValue($row['DISTRIBUSI']);
        $this->DIJUAL->setDbValue($row['DIJUAL']);
        $this->DIHAPUS->setDbValue($row['DIHAPUS']);
        $this->DIMINTA->setDbValue($row['DIMINTA']);
        $this->DIRETUR->setDbValue($row['DIRETUR']);
        $this->PO->setDbValue($row['PO']);
        $this->FUND_ID->setDbValue($row['FUND_ID']);
        $this->INVOICE_ID2->setDbValue($row['INVOICE_ID2']);
        $this->MEASURE_ID3->setDbValue($row['MEASURE_ID3']);
        $this->SIZE_KEMASAN->setDbValue($row['SIZE_KEMASAN']);
        $this->BRAND_NAME->setDbValue($row['BRAND_NAME']);
        $this->MEASURE_ID2->setDbValue($row['MEASURE_ID2']);
        $this->MONTH_ID->setDbValue($row['MONTH_ID']);
        $this->YEAR_ID->setDbValue($row['YEAR_ID']);
        $this->DISCOUNT->setDbValue($row['DISCOUNT']);
        $this->QUANTITY->setDbValue($row['QUANTITY']);
        $this->MEASURE_ID->setDbValue($row['MEASURE_ID']);
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // ORG_UNIT_CODE

        // ITEM_ID

        // ORG_ID

        // DOC_NO

        // BATCH_NO

        // BRAND_ID

        // ROOMS_ID

        // SHELF_NO

        // EXPIRY_DATE

        // FROM_ROOMS_ID

        // DISTRIBUTION_TYPE

        // CONDITION

        // ALLOCATED_DATE

        // STOCKOPNAME_DATE

        // INVOICE_ID

        // ALLOCATED_FROM

        // PRICE

        // ORDER_PRICE

        // ITEM_ID_FROM

        // MODIFIED_DATE

        // MODIFIED_BY

        // STOCK_AVAILABLE

        // STOCK_OPNAME

        // STOK_AWAL

        // STOCK_LALU

        // STOCK_KOREKSI

        // DITERIMA

        // DISTRIBUSI

        // DIJUAL

        // DIHAPUS

        // DIMINTA

        // DIRETUR

        // PO

        // FUND_ID

        // INVOICE_ID2

        // MEASURE_ID3

        // SIZE_KEMASAN

        // BRAND_NAME

        // MEASURE_ID2

        // MONTH_ID

        // YEAR_ID

        // DISCOUNT

        // QUANTITY

        // MEASURE_ID

        // ORG_UNIT_CODE
        $this->ORG_UNIT_CODE->ViewValue = $this->ORG_UNIT_CODE->CurrentValue;
        $this->ORG_UNIT_CODE->ViewCustomAttributes = "";

        // ITEM_ID
        $this->ITEM_ID->ViewValue = $this->ITEM_ID->CurrentValue;
        $this->ITEM_ID->ViewCustomAttributes = "";

        // ORG_ID
        $this->ORG_ID->ViewValue = $this->ORG_ID->CurrentValue;
        $this->ORG_ID->ViewCustomAttributes = "";

        // DOC_NO
        $this->DOC_NO->ViewValue = $this->DOC_NO->CurrentValue;
        $this->DOC_NO->ViewCustomAttributes = "";

        // BATCH_NO
        $this->BATCH_NO->ViewValue = $this->BATCH_NO->CurrentValue;
        $this->BATCH_NO->ViewCustomAttributes = "";

        // BRAND_ID
        $this->BRAND_ID->ViewValue = $this->BRAND_ID->CurrentValue;
        $this->BRAND_ID->ViewCustomAttributes = "";

        // ROOMS_ID
        $this->ROOMS_ID->ViewValue = $this->ROOMS_ID->CurrentValue;
        $this->ROOMS_ID->ViewCustomAttributes = "";

        // SHELF_NO
        $this->SHELF_NO->ViewValue = $this->SHELF_NO->CurrentValue;
        $this->SHELF_NO->ViewValue = FormatNumber($this->SHELF_NO->ViewValue, 0, -2, -2, -2);
        $this->SHELF_NO->ViewCustomAttributes = "";

        // EXPIRY_DATE
        $this->EXPIRY_DATE->ViewValue = $this->EXPIRY_DATE->CurrentValue;
        $this->EXPIRY_DATE->ViewValue = FormatDateTime($this->EXPIRY_DATE->ViewValue, 0);
        $this->EXPIRY_DATE->ViewCustomAttributes = "";

        // FROM_ROOMS_ID
        $this->FROM_ROOMS_ID->ViewValue = $this->FROM_ROOMS_ID->CurrentValue;
        $this->FROM_ROOMS_ID->ViewCustomAttributes = "";

        // DISTRIBUTION_TYPE
        $this->DISTRIBUTION_TYPE->ViewValue = $this->DISTRIBUTION_TYPE->CurrentValue;
        $this->DISTRIBUTION_TYPE->ViewValue = FormatNumber($this->DISTRIBUTION_TYPE->ViewValue, 0, -2, -2, -2);
        $this->DISTRIBUTION_TYPE->ViewCustomAttributes = "";

        // CONDITION
        $this->CONDITION->ViewValue = $this->CONDITION->CurrentValue;
        $this->CONDITION->ViewValue = FormatNumber($this->CONDITION->ViewValue, 0, -2, -2, -2);
        $this->CONDITION->ViewCustomAttributes = "";

        // ALLOCATED_DATE
        $this->ALLOCATED_DATE->ViewValue = $this->ALLOCATED_DATE->CurrentValue;
        $this->ALLOCATED_DATE->ViewValue = FormatDateTime($this->ALLOCATED_DATE->ViewValue, 0);
        $this->ALLOCATED_DATE->ViewCustomAttributes = "";

        // STOCKOPNAME_DATE
        $this->STOCKOPNAME_DATE->ViewValue = $this->STOCKOPNAME_DATE->CurrentValue;
        $this->STOCKOPNAME_DATE->ViewValue = FormatDateTime($this->STOCKOPNAME_DATE->ViewValue, 0);
        $this->STOCKOPNAME_DATE->ViewCustomAttributes = "";

        // INVOICE_ID
        $this->INVOICE_ID->ViewValue = $this->INVOICE_ID->CurrentValue;
        $this->INVOICE_ID->ViewCustomAttributes = "";

        // ALLOCATED_FROM
        $this->ALLOCATED_FROM->ViewValue = $this->ALLOCATED_FROM->CurrentValue;
        $this->ALLOCATED_FROM->ViewCustomAttributes = "";

        // PRICE
        $this->PRICE->ViewValue = $this->PRICE->CurrentValue;
        $this->PRICE->ViewValue = FormatNumber($this->PRICE->ViewValue, 2, -2, -2, -2);
        $this->PRICE->ViewCustomAttributes = "";

        // ORDER_PRICE
        $this->ORDER_PRICE->ViewValue = $this->ORDER_PRICE->CurrentValue;
        $this->ORDER_PRICE->ViewValue = FormatNumber($this->ORDER_PRICE->ViewValue, 2, -2, -2, -2);
        $this->ORDER_PRICE->ViewCustomAttributes = "";

        // ITEM_ID_FROM
        $this->ITEM_ID_FROM->ViewValue = $this->ITEM_ID_FROM->CurrentValue;
        $this->ITEM_ID_FROM->ViewCustomAttributes = "";

        // MODIFIED_DATE
        $this->MODIFIED_DATE->ViewValue = $this->MODIFIED_DATE->CurrentValue;
        $this->MODIFIED_DATE->ViewValue = FormatDateTime($this->MODIFIED_DATE->ViewValue, 0);
        $this->MODIFIED_DATE->ViewCustomAttributes = "";

        // MODIFIED_BY
        $this->MODIFIED_BY->ViewValue = $this->MODIFIED_BY->CurrentValue;
        $this->MODIFIED_BY->ViewCustomAttributes = "";

        // STOCK_AVAILABLE
        $this->STOCK_AVAILABLE->ViewValue = $this->STOCK_AVAILABLE->CurrentValue;
        $this->STOCK_AVAILABLE->ViewValue = FormatNumber($this->STOCK_AVAILABLE->ViewValue, 2, -2, -2, -2);
        $this->STOCK_AVAILABLE->ViewCustomAttributes = "";

        // STOCK_OPNAME
        $this->STOCK_OPNAME->ViewValue = $this->STOCK_OPNAME->CurrentValue;
        $this->STOCK_OPNAME->ViewValue = FormatNumber($this->STOCK_OPNAME->ViewValue, 2, -2, -2, -2);
        $this->STOCK_OPNAME->ViewCustomAttributes = "";

        // STOK_AWAL
        $this->STOK_AWAL->ViewValue = $this->STOK_AWAL->CurrentValue;
        $this->STOK_AWAL->ViewValue = FormatNumber($this->STOK_AWAL->ViewValue, 2, -2, -2, -2);
        $this->STOK_AWAL->ViewCustomAttributes = "";

        // STOCK_LALU
        $this->STOCK_LALU->ViewValue = $this->STOCK_LALU->CurrentValue;
        $this->STOCK_LALU->ViewValue = FormatNumber($this->STOCK_LALU->ViewValue, 2, -2, -2, -2);
        $this->STOCK_LALU->ViewCustomAttributes = "";

        // STOCK_KOREKSI
        $this->STOCK_KOREKSI->ViewValue = $this->STOCK_KOREKSI->CurrentValue;
        $this->STOCK_KOREKSI->ViewValue = FormatNumber($this->STOCK_KOREKSI->ViewValue, 2, -2, -2, -2);
        $this->STOCK_KOREKSI->ViewCustomAttributes = "";

        // DITERIMA
        $this->DITERIMA->ViewValue = $this->DITERIMA->CurrentValue;
        $this->DITERIMA->ViewValue = FormatNumber($this->DITERIMA->ViewValue, 2, -2, -2, -2);
        $this->DITERIMA->ViewCustomAttributes = "";

        // DISTRIBUSI
        $this->DISTRIBUSI->ViewValue = $this->DISTRIBUSI->CurrentValue;
        $this->DISTRIBUSI->ViewValue = FormatNumber($this->DISTRIBUSI->ViewValue, 2, -2, -2, -2);
        $this->DISTRIBUSI->ViewCustomAttributes = "";

        // DIJUAL
        $this->DIJUAL->ViewValue = $this->DIJUAL->CurrentValue;
        $this->DIJUAL->ViewValue = FormatNumber($this->DIJUAL->ViewValue, 2, -2, -2, -2);
        $this->DIJUAL->ViewCustomAttributes = "";

        // DIHAPUS
        $this->DIHAPUS->ViewValue = $this->DIHAPUS->CurrentValue;
        $this->DIHAPUS->ViewValue = FormatNumber($this->DIHAPUS->ViewValue, 2, -2, -2, -2);
        $this->DIHAPUS->ViewCustomAttributes = "";

        // DIMINTA
        $this->DIMINTA->ViewValue = $this->DIMINTA->CurrentValue;
        $this->DIMINTA->ViewValue = FormatNumber($this->DIMINTA->ViewValue, 2, -2, -2, -2);
        $this->DIMINTA->ViewCustomAttributes = "";

        // DIRETUR
        $this->DIRETUR->ViewValue = $this->DIRETUR->CurrentValue;
        $this->DIRETUR->ViewValue = FormatNumber($this->DIRETUR->ViewValue, 2, -2, -2, -2);
        $this->DIRETUR->ViewCustomAttributes = "";

        // PO
        $this->PO->ViewValue = $this->PO->CurrentValue;
        $this->PO->ViewCustomAttributes = "";

        // FUND_ID
        $this->FUND_ID->ViewValue = $this->FUND_ID->CurrentValue;
        $this->FUND_ID->ViewValue = FormatNumber($this->FUND_ID->ViewValue, 0, -2, -2, -2);
        $this->FUND_ID->ViewCustomAttributes = "";

        // INVOICE_ID2
        $this->INVOICE_ID2->ViewValue = $this->INVOICE_ID2->CurrentValue;
        $this->INVOICE_ID2->ViewCustomAttributes = "";

        // MEASURE_ID3
        $this->MEASURE_ID3->ViewValue = $this->MEASURE_ID3->CurrentValue;
        $this->MEASURE_ID3->ViewValue = FormatNumber($this->MEASURE_ID3->ViewValue, 0, -2, -2, -2);
        $this->MEASURE_ID3->ViewCustomAttributes = "";

        // SIZE_KEMASAN
        $this->SIZE_KEMASAN->ViewValue = $this->SIZE_KEMASAN->CurrentValue;
        $this->SIZE_KEMASAN->ViewValue = FormatNumber($this->SIZE_KEMASAN->ViewValue, 2, -2, -2, -2);
        $this->SIZE_KEMASAN->ViewCustomAttributes = "";

        // BRAND_NAME
        $this->BRAND_NAME->ViewValue = $this->BRAND_NAME->CurrentValue;
        $this->BRAND_NAME->ViewCustomAttributes = "";

        // MEASURE_ID2
        $this->MEASURE_ID2->ViewValue = $this->MEASURE_ID2->CurrentValue;
        $this->MEASURE_ID2->ViewValue = FormatNumber($this->MEASURE_ID2->ViewValue, 0, -2, -2, -2);
        $this->MEASURE_ID2->ViewCustomAttributes = "";

        // MONTH_ID
        $this->MONTH_ID->ViewValue = $this->MONTH_ID->CurrentValue;
        $this->MONTH_ID->ViewValue = FormatNumber($this->MONTH_ID->ViewValue, 0, -2, -2, -2);
        $this->MONTH_ID->ViewCustomAttributes = "";

        // YEAR_ID
        $this->YEAR_ID->ViewValue = $this->YEAR_ID->CurrentValue;
        $this->YEAR_ID->ViewValue = FormatNumber($this->YEAR_ID->ViewValue, 0, -2, -2, -2);
        $this->YEAR_ID->ViewCustomAttributes = "";

        // DISCOUNT
        $this->DISCOUNT->ViewValue = $this->DISCOUNT->CurrentValue;
        $this->DISCOUNT->ViewValue = FormatNumber($this->DISCOUNT->ViewValue, 2, -2, -2, -2);
        $this->DISCOUNT->ViewCustomAttributes = "";

        // QUANTITY
        $this->QUANTITY->ViewValue = $this->QUANTITY->CurrentValue;
        $this->QUANTITY->ViewValue = FormatNumber($this->QUANTITY->ViewValue, 2, -2, -2, -2);
        $this->QUANTITY->ViewCustomAttributes = "";

        // MEASURE_ID
        $this->MEASURE_ID->ViewValue = $this->MEASURE_ID->CurrentValue;
        $this->MEASURE_ID->ViewValue = FormatNumber($this->MEASURE_ID->ViewValue, 0, -2, -2, -2);
        $this->MEASURE_ID->ViewCustomAttributes = "";

        // ORG_UNIT_CODE
        $this->ORG_UNIT_CODE->LinkCustomAttributes = "";
        $this->ORG_UNIT_CODE->HrefValue = "";
        $this->ORG_UNIT_CODE->TooltipValue = "";

        // ITEM_ID
        $this->ITEM_ID->LinkCustomAttributes = "";
        $this->ITEM_ID->HrefValue = "";
        $this->ITEM_ID->TooltipValue = "";

        // ORG_ID
        $this->ORG_ID->LinkCustomAttributes = "";
        $this->ORG_ID->HrefValue = "";
        $this->ORG_ID->TooltipValue = "";

        // DOC_NO
        $this->DOC_NO->LinkCustomAttributes = "";
        $this->DOC_NO->HrefValue = "";
        $this->DOC_NO->TooltipValue = "";

        // BATCH_NO
        $this->BATCH_NO->LinkCustomAttributes = "";
        $this->BATCH_NO->HrefValue = "";
        $this->BATCH_NO->TooltipValue = "";

        // BRAND_ID
        $this->BRAND_ID->LinkCustomAttributes = "";
        $this->BRAND_ID->HrefValue = "";
        $this->BRAND_ID->TooltipValue = "";

        // ROOMS_ID
        $this->ROOMS_ID->LinkCustomAttributes = "";
        $this->ROOMS_ID->HrefValue = "";
        $this->ROOMS_ID->TooltipValue = "";

        // SHELF_NO
        $this->SHELF_NO->LinkCustomAttributes = "";
        $this->SHELF_NO->HrefValue = "";
        $this->SHELF_NO->TooltipValue = "";

        // EXPIRY_DATE
        $this->EXPIRY_DATE->LinkCustomAttributes = "";
        $this->EXPIRY_DATE->HrefValue = "";
        $this->EXPIRY_DATE->TooltipValue = "";

        // FROM_ROOMS_ID
        $this->FROM_ROOMS_ID->LinkCustomAttributes = "";
        $this->FROM_ROOMS_ID->HrefValue = "";
        $this->FROM_ROOMS_ID->TooltipValue = "";

        // DISTRIBUTION_TYPE
        $this->DISTRIBUTION_TYPE->LinkCustomAttributes = "";
        $this->DISTRIBUTION_TYPE->HrefValue = "";
        $this->DISTRIBUTION_TYPE->TooltipValue = "";

        // CONDITION
        $this->CONDITION->LinkCustomAttributes = "";
        $this->CONDITION->HrefValue = "";
        $this->CONDITION->TooltipValue = "";

        // ALLOCATED_DATE
        $this->ALLOCATED_DATE->LinkCustomAttributes = "";
        $this->ALLOCATED_DATE->HrefValue = "";
        $this->ALLOCATED_DATE->TooltipValue = "";

        // STOCKOPNAME_DATE
        $this->STOCKOPNAME_DATE->LinkCustomAttributes = "";
        $this->STOCKOPNAME_DATE->HrefValue = "";
        $this->STOCKOPNAME_DATE->TooltipValue = "";

        // INVOICE_ID
        $this->INVOICE_ID->LinkCustomAttributes = "";
        $this->INVOICE_ID->HrefValue = "";
        $this->INVOICE_ID->TooltipValue = "";

        // ALLOCATED_FROM
        $this->ALLOCATED_FROM->LinkCustomAttributes = "";
        $this->ALLOCATED_FROM->HrefValue = "";
        $this->ALLOCATED_FROM->TooltipValue = "";

        // PRICE
        $this->PRICE->LinkCustomAttributes = "";
        $this->PRICE->HrefValue = "";
        $this->PRICE->TooltipValue = "";

        // ORDER_PRICE
        $this->ORDER_PRICE->LinkCustomAttributes = "";
        $this->ORDER_PRICE->HrefValue = "";
        $this->ORDER_PRICE->TooltipValue = "";

        // ITEM_ID_FROM
        $this->ITEM_ID_FROM->LinkCustomAttributes = "";
        $this->ITEM_ID_FROM->HrefValue = "";
        $this->ITEM_ID_FROM->TooltipValue = "";

        // MODIFIED_DATE
        $this->MODIFIED_DATE->LinkCustomAttributes = "";
        $this->MODIFIED_DATE->HrefValue = "";
        $this->MODIFIED_DATE->TooltipValue = "";

        // MODIFIED_BY
        $this->MODIFIED_BY->LinkCustomAttributes = "";
        $this->MODIFIED_BY->HrefValue = "";
        $this->MODIFIED_BY->TooltipValue = "";

        // STOCK_AVAILABLE
        $this->STOCK_AVAILABLE->LinkCustomAttributes = "";
        $this->STOCK_AVAILABLE->HrefValue = "";
        $this->STOCK_AVAILABLE->TooltipValue = "";

        // STOCK_OPNAME
        $this->STOCK_OPNAME->LinkCustomAttributes = "";
        $this->STOCK_OPNAME->HrefValue = "";
        $this->STOCK_OPNAME->TooltipValue = "";

        // STOK_AWAL
        $this->STOK_AWAL->LinkCustomAttributes = "";
        $this->STOK_AWAL->HrefValue = "";
        $this->STOK_AWAL->TooltipValue = "";

        // STOCK_LALU
        $this->STOCK_LALU->LinkCustomAttributes = "";
        $this->STOCK_LALU->HrefValue = "";
        $this->STOCK_LALU->TooltipValue = "";

        // STOCK_KOREKSI
        $this->STOCK_KOREKSI->LinkCustomAttributes = "";
        $this->STOCK_KOREKSI->HrefValue = "";
        $this->STOCK_KOREKSI->TooltipValue = "";

        // DITERIMA
        $this->DITERIMA->LinkCustomAttributes = "";
        $this->DITERIMA->HrefValue = "";
        $this->DITERIMA->TooltipValue = "";

        // DISTRIBUSI
        $this->DISTRIBUSI->LinkCustomAttributes = "";
        $this->DISTRIBUSI->HrefValue = "";
        $this->DISTRIBUSI->TooltipValue = "";

        // DIJUAL
        $this->DIJUAL->LinkCustomAttributes = "";
        $this->DIJUAL->HrefValue = "";
        $this->DIJUAL->TooltipValue = "";

        // DIHAPUS
        $this->DIHAPUS->LinkCustomAttributes = "";
        $this->DIHAPUS->HrefValue = "";
        $this->DIHAPUS->TooltipValue = "";

        // DIMINTA
        $this->DIMINTA->LinkCustomAttributes = "";
        $this->DIMINTA->HrefValue = "";
        $this->DIMINTA->TooltipValue = "";

        // DIRETUR
        $this->DIRETUR->LinkCustomAttributes = "";
        $this->DIRETUR->HrefValue = "";
        $this->DIRETUR->TooltipValue = "";

        // PO
        $this->PO->LinkCustomAttributes = "";
        $this->PO->HrefValue = "";
        $this->PO->TooltipValue = "";

        // FUND_ID
        $this->FUND_ID->LinkCustomAttributes = "";
        $this->FUND_ID->HrefValue = "";
        $this->FUND_ID->TooltipValue = "";

        // INVOICE_ID2
        $this->INVOICE_ID2->LinkCustomAttributes = "";
        $this->INVOICE_ID2->HrefValue = "";
        $this->INVOICE_ID2->TooltipValue = "";

        // MEASURE_ID3
        $this->MEASURE_ID3->LinkCustomAttributes = "";
        $this->MEASURE_ID3->HrefValue = "";
        $this->MEASURE_ID3->TooltipValue = "";

        // SIZE_KEMASAN
        $this->SIZE_KEMASAN->LinkCustomAttributes = "";
        $this->SIZE_KEMASAN->HrefValue = "";
        $this->SIZE_KEMASAN->TooltipValue = "";

        // BRAND_NAME
        $this->BRAND_NAME->LinkCustomAttributes = "";
        $this->BRAND_NAME->HrefValue = "";
        $this->BRAND_NAME->TooltipValue = "";

        // MEASURE_ID2
        $this->MEASURE_ID2->LinkCustomAttributes = "";
        $this->MEASURE_ID2->HrefValue = "";
        $this->MEASURE_ID2->TooltipValue = "";

        // MONTH_ID
        $this->MONTH_ID->LinkCustomAttributes = "";
        $this->MONTH_ID->HrefValue = "";
        $this->MONTH_ID->TooltipValue = "";

        // YEAR_ID
        $this->YEAR_ID->LinkCustomAttributes = "";
        $this->YEAR_ID->HrefValue = "";
        $this->YEAR_ID->TooltipValue = "";

        // DISCOUNT
        $this->DISCOUNT->LinkCustomAttributes = "";
        $this->DISCOUNT->HrefValue = "";
        $this->DISCOUNT->TooltipValue = "";

        // QUANTITY
        $this->QUANTITY->LinkCustomAttributes = "";
        $this->QUANTITY->HrefValue = "";
        $this->QUANTITY->TooltipValue = "";

        // MEASURE_ID
        $this->MEASURE_ID->LinkCustomAttributes = "";
        $this->MEASURE_ID->HrefValue = "";
        $this->MEASURE_ID->TooltipValue = "";

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

        // ORG_UNIT_CODE
        $this->ORG_UNIT_CODE->EditAttrs["class"] = "form-control";
        $this->ORG_UNIT_CODE->EditCustomAttributes = "";
        if (!$this->ORG_UNIT_CODE->Raw) {
            $this->ORG_UNIT_CODE->CurrentValue = HtmlDecode($this->ORG_UNIT_CODE->CurrentValue);
        }
        $this->ORG_UNIT_CODE->EditValue = $this->ORG_UNIT_CODE->CurrentValue;
        $this->ORG_UNIT_CODE->PlaceHolder = RemoveHtml($this->ORG_UNIT_CODE->caption());

        // ITEM_ID
        $this->ITEM_ID->EditAttrs["class"] = "form-control";
        $this->ITEM_ID->EditCustomAttributes = "";
        if (!$this->ITEM_ID->Raw) {
            $this->ITEM_ID->CurrentValue = HtmlDecode($this->ITEM_ID->CurrentValue);
        }
        $this->ITEM_ID->EditValue = $this->ITEM_ID->CurrentValue;
        $this->ITEM_ID->PlaceHolder = RemoveHtml($this->ITEM_ID->caption());

        // ORG_ID
        $this->ORG_ID->EditAttrs["class"] = "form-control";
        $this->ORG_ID->EditCustomAttributes = "";
        if (!$this->ORG_ID->Raw) {
            $this->ORG_ID->CurrentValue = HtmlDecode($this->ORG_ID->CurrentValue);
        }
        $this->ORG_ID->EditValue = $this->ORG_ID->CurrentValue;
        $this->ORG_ID->PlaceHolder = RemoveHtml($this->ORG_ID->caption());

        // DOC_NO
        $this->DOC_NO->EditAttrs["class"] = "form-control";
        $this->DOC_NO->EditCustomAttributes = "";
        if (!$this->DOC_NO->Raw) {
            $this->DOC_NO->CurrentValue = HtmlDecode($this->DOC_NO->CurrentValue);
        }
        $this->DOC_NO->EditValue = $this->DOC_NO->CurrentValue;
        $this->DOC_NO->PlaceHolder = RemoveHtml($this->DOC_NO->caption());

        // BATCH_NO
        $this->BATCH_NO->EditAttrs["class"] = "form-control";
        $this->BATCH_NO->EditCustomAttributes = "";
        if (!$this->BATCH_NO->Raw) {
            $this->BATCH_NO->CurrentValue = HtmlDecode($this->BATCH_NO->CurrentValue);
        }
        $this->BATCH_NO->EditValue = $this->BATCH_NO->CurrentValue;
        $this->BATCH_NO->PlaceHolder = RemoveHtml($this->BATCH_NO->caption());

        // BRAND_ID
        $this->BRAND_ID->EditAttrs["class"] = "form-control";
        $this->BRAND_ID->EditCustomAttributes = "";
        if (!$this->BRAND_ID->Raw) {
            $this->BRAND_ID->CurrentValue = HtmlDecode($this->BRAND_ID->CurrentValue);
        }
        $this->BRAND_ID->EditValue = $this->BRAND_ID->CurrentValue;
        $this->BRAND_ID->PlaceHolder = RemoveHtml($this->BRAND_ID->caption());

        // ROOMS_ID
        $this->ROOMS_ID->EditAttrs["class"] = "form-control";
        $this->ROOMS_ID->EditCustomAttributes = "";
        if (!$this->ROOMS_ID->Raw) {
            $this->ROOMS_ID->CurrentValue = HtmlDecode($this->ROOMS_ID->CurrentValue);
        }
        $this->ROOMS_ID->EditValue = $this->ROOMS_ID->CurrentValue;
        $this->ROOMS_ID->PlaceHolder = RemoveHtml($this->ROOMS_ID->caption());

        // SHELF_NO
        $this->SHELF_NO->EditAttrs["class"] = "form-control";
        $this->SHELF_NO->EditCustomAttributes = "";
        $this->SHELF_NO->EditValue = $this->SHELF_NO->CurrentValue;
        $this->SHELF_NO->PlaceHolder = RemoveHtml($this->SHELF_NO->caption());

        // EXPIRY_DATE
        $this->EXPIRY_DATE->EditAttrs["class"] = "form-control";
        $this->EXPIRY_DATE->EditCustomAttributes = "";
        $this->EXPIRY_DATE->EditValue = FormatDateTime($this->EXPIRY_DATE->CurrentValue, 8);
        $this->EXPIRY_DATE->PlaceHolder = RemoveHtml($this->EXPIRY_DATE->caption());

        // FROM_ROOMS_ID
        $this->FROM_ROOMS_ID->EditAttrs["class"] = "form-control";
        $this->FROM_ROOMS_ID->EditCustomAttributes = "";
        if (!$this->FROM_ROOMS_ID->Raw) {
            $this->FROM_ROOMS_ID->CurrentValue = HtmlDecode($this->FROM_ROOMS_ID->CurrentValue);
        }
        $this->FROM_ROOMS_ID->EditValue = $this->FROM_ROOMS_ID->CurrentValue;
        $this->FROM_ROOMS_ID->PlaceHolder = RemoveHtml($this->FROM_ROOMS_ID->caption());

        // DISTRIBUTION_TYPE
        $this->DISTRIBUTION_TYPE->EditAttrs["class"] = "form-control";
        $this->DISTRIBUTION_TYPE->EditCustomAttributes = "";
        $this->DISTRIBUTION_TYPE->EditValue = $this->DISTRIBUTION_TYPE->CurrentValue;
        $this->DISTRIBUTION_TYPE->PlaceHolder = RemoveHtml($this->DISTRIBUTION_TYPE->caption());

        // CONDITION
        $this->CONDITION->EditAttrs["class"] = "form-control";
        $this->CONDITION->EditCustomAttributes = "";
        $this->CONDITION->EditValue = $this->CONDITION->CurrentValue;
        $this->CONDITION->PlaceHolder = RemoveHtml($this->CONDITION->caption());

        // ALLOCATED_DATE
        $this->ALLOCATED_DATE->EditAttrs["class"] = "form-control";
        $this->ALLOCATED_DATE->EditCustomAttributes = "";
        $this->ALLOCATED_DATE->EditValue = FormatDateTime($this->ALLOCATED_DATE->CurrentValue, 8);
        $this->ALLOCATED_DATE->PlaceHolder = RemoveHtml($this->ALLOCATED_DATE->caption());

        // STOCKOPNAME_DATE
        $this->STOCKOPNAME_DATE->EditAttrs["class"] = "form-control";
        $this->STOCKOPNAME_DATE->EditCustomAttributes = "";
        $this->STOCKOPNAME_DATE->EditValue = FormatDateTime($this->STOCKOPNAME_DATE->CurrentValue, 8);
        $this->STOCKOPNAME_DATE->PlaceHolder = RemoveHtml($this->STOCKOPNAME_DATE->caption());

        // INVOICE_ID
        $this->INVOICE_ID->EditAttrs["class"] = "form-control";
        $this->INVOICE_ID->EditCustomAttributes = "";
        if (!$this->INVOICE_ID->Raw) {
            $this->INVOICE_ID->CurrentValue = HtmlDecode($this->INVOICE_ID->CurrentValue);
        }
        $this->INVOICE_ID->EditValue = $this->INVOICE_ID->CurrentValue;
        $this->INVOICE_ID->PlaceHolder = RemoveHtml($this->INVOICE_ID->caption());

        // ALLOCATED_FROM
        $this->ALLOCATED_FROM->EditAttrs["class"] = "form-control";
        $this->ALLOCATED_FROM->EditCustomAttributes = "";
        if (!$this->ALLOCATED_FROM->Raw) {
            $this->ALLOCATED_FROM->CurrentValue = HtmlDecode($this->ALLOCATED_FROM->CurrentValue);
        }
        $this->ALLOCATED_FROM->EditValue = $this->ALLOCATED_FROM->CurrentValue;
        $this->ALLOCATED_FROM->PlaceHolder = RemoveHtml($this->ALLOCATED_FROM->caption());

        // PRICE
        $this->PRICE->EditAttrs["class"] = "form-control";
        $this->PRICE->EditCustomAttributes = "";
        $this->PRICE->EditValue = $this->PRICE->CurrentValue;
        $this->PRICE->PlaceHolder = RemoveHtml($this->PRICE->caption());
        if (strval($this->PRICE->EditValue) != "" && is_numeric($this->PRICE->EditValue)) {
            $this->PRICE->EditValue = FormatNumber($this->PRICE->EditValue, -2, -2, -2, -2);
        }

        // ORDER_PRICE
        $this->ORDER_PRICE->EditAttrs["class"] = "form-control";
        $this->ORDER_PRICE->EditCustomAttributes = "";
        $this->ORDER_PRICE->EditValue = $this->ORDER_PRICE->CurrentValue;
        $this->ORDER_PRICE->PlaceHolder = RemoveHtml($this->ORDER_PRICE->caption());
        if (strval($this->ORDER_PRICE->EditValue) != "" && is_numeric($this->ORDER_PRICE->EditValue)) {
            $this->ORDER_PRICE->EditValue = FormatNumber($this->ORDER_PRICE->EditValue, -2, -2, -2, -2);
        }

        // ITEM_ID_FROM
        $this->ITEM_ID_FROM->EditAttrs["class"] = "form-control";
        $this->ITEM_ID_FROM->EditCustomAttributes = "";
        if (!$this->ITEM_ID_FROM->Raw) {
            $this->ITEM_ID_FROM->CurrentValue = HtmlDecode($this->ITEM_ID_FROM->CurrentValue);
        }
        $this->ITEM_ID_FROM->EditValue = $this->ITEM_ID_FROM->CurrentValue;
        $this->ITEM_ID_FROM->PlaceHolder = RemoveHtml($this->ITEM_ID_FROM->caption());

        // MODIFIED_DATE
        $this->MODIFIED_DATE->EditAttrs["class"] = "form-control";
        $this->MODIFIED_DATE->EditCustomAttributes = "";
        $this->MODIFIED_DATE->EditValue = FormatDateTime($this->MODIFIED_DATE->CurrentValue, 8);
        $this->MODIFIED_DATE->PlaceHolder = RemoveHtml($this->MODIFIED_DATE->caption());

        // MODIFIED_BY
        $this->MODIFIED_BY->EditAttrs["class"] = "form-control";
        $this->MODIFIED_BY->EditCustomAttributes = "";
        if (!$this->MODIFIED_BY->Raw) {
            $this->MODIFIED_BY->CurrentValue = HtmlDecode($this->MODIFIED_BY->CurrentValue);
        }
        $this->MODIFIED_BY->EditValue = $this->MODIFIED_BY->CurrentValue;
        $this->MODIFIED_BY->PlaceHolder = RemoveHtml($this->MODIFIED_BY->caption());

        // STOCK_AVAILABLE
        $this->STOCK_AVAILABLE->EditAttrs["class"] = "form-control";
        $this->STOCK_AVAILABLE->EditCustomAttributes = "";
        $this->STOCK_AVAILABLE->EditValue = $this->STOCK_AVAILABLE->CurrentValue;
        $this->STOCK_AVAILABLE->PlaceHolder = RemoveHtml($this->STOCK_AVAILABLE->caption());
        if (strval($this->STOCK_AVAILABLE->EditValue) != "" && is_numeric($this->STOCK_AVAILABLE->EditValue)) {
            $this->STOCK_AVAILABLE->EditValue = FormatNumber($this->STOCK_AVAILABLE->EditValue, -2, -2, -2, -2);
        }

        // STOCK_OPNAME
        $this->STOCK_OPNAME->EditAttrs["class"] = "form-control";
        $this->STOCK_OPNAME->EditCustomAttributes = "";
        $this->STOCK_OPNAME->EditValue = $this->STOCK_OPNAME->CurrentValue;
        $this->STOCK_OPNAME->PlaceHolder = RemoveHtml($this->STOCK_OPNAME->caption());
        if (strval($this->STOCK_OPNAME->EditValue) != "" && is_numeric($this->STOCK_OPNAME->EditValue)) {
            $this->STOCK_OPNAME->EditValue = FormatNumber($this->STOCK_OPNAME->EditValue, -2, -2, -2, -2);
        }

        // STOK_AWAL
        $this->STOK_AWAL->EditAttrs["class"] = "form-control";
        $this->STOK_AWAL->EditCustomAttributes = "";
        $this->STOK_AWAL->EditValue = $this->STOK_AWAL->CurrentValue;
        $this->STOK_AWAL->PlaceHolder = RemoveHtml($this->STOK_AWAL->caption());
        if (strval($this->STOK_AWAL->EditValue) != "" && is_numeric($this->STOK_AWAL->EditValue)) {
            $this->STOK_AWAL->EditValue = FormatNumber($this->STOK_AWAL->EditValue, -2, -2, -2, -2);
        }

        // STOCK_LALU
        $this->STOCK_LALU->EditAttrs["class"] = "form-control";
        $this->STOCK_LALU->EditCustomAttributes = "";
        $this->STOCK_LALU->EditValue = $this->STOCK_LALU->CurrentValue;
        $this->STOCK_LALU->PlaceHolder = RemoveHtml($this->STOCK_LALU->caption());
        if (strval($this->STOCK_LALU->EditValue) != "" && is_numeric($this->STOCK_LALU->EditValue)) {
            $this->STOCK_LALU->EditValue = FormatNumber($this->STOCK_LALU->EditValue, -2, -2, -2, -2);
        }

        // STOCK_KOREKSI
        $this->STOCK_KOREKSI->EditAttrs["class"] = "form-control";
        $this->STOCK_KOREKSI->EditCustomAttributes = "";
        $this->STOCK_KOREKSI->EditValue = $this->STOCK_KOREKSI->CurrentValue;
        $this->STOCK_KOREKSI->PlaceHolder = RemoveHtml($this->STOCK_KOREKSI->caption());
        if (strval($this->STOCK_KOREKSI->EditValue) != "" && is_numeric($this->STOCK_KOREKSI->EditValue)) {
            $this->STOCK_KOREKSI->EditValue = FormatNumber($this->STOCK_KOREKSI->EditValue, -2, -2, -2, -2);
        }

        // DITERIMA
        $this->DITERIMA->EditAttrs["class"] = "form-control";
        $this->DITERIMA->EditCustomAttributes = "";
        $this->DITERIMA->EditValue = $this->DITERIMA->CurrentValue;
        $this->DITERIMA->PlaceHolder = RemoveHtml($this->DITERIMA->caption());
        if (strval($this->DITERIMA->EditValue) != "" && is_numeric($this->DITERIMA->EditValue)) {
            $this->DITERIMA->EditValue = FormatNumber($this->DITERIMA->EditValue, -2, -2, -2, -2);
        }

        // DISTRIBUSI
        $this->DISTRIBUSI->EditAttrs["class"] = "form-control";
        $this->DISTRIBUSI->EditCustomAttributes = "";
        $this->DISTRIBUSI->EditValue = $this->DISTRIBUSI->CurrentValue;
        $this->DISTRIBUSI->PlaceHolder = RemoveHtml($this->DISTRIBUSI->caption());
        if (strval($this->DISTRIBUSI->EditValue) != "" && is_numeric($this->DISTRIBUSI->EditValue)) {
            $this->DISTRIBUSI->EditValue = FormatNumber($this->DISTRIBUSI->EditValue, -2, -2, -2, -2);
        }

        // DIJUAL
        $this->DIJUAL->EditAttrs["class"] = "form-control";
        $this->DIJUAL->EditCustomAttributes = "";
        $this->DIJUAL->EditValue = $this->DIJUAL->CurrentValue;
        $this->DIJUAL->PlaceHolder = RemoveHtml($this->DIJUAL->caption());
        if (strval($this->DIJUAL->EditValue) != "" && is_numeric($this->DIJUAL->EditValue)) {
            $this->DIJUAL->EditValue = FormatNumber($this->DIJUAL->EditValue, -2, -2, -2, -2);
        }

        // DIHAPUS
        $this->DIHAPUS->EditAttrs["class"] = "form-control";
        $this->DIHAPUS->EditCustomAttributes = "";
        $this->DIHAPUS->EditValue = $this->DIHAPUS->CurrentValue;
        $this->DIHAPUS->PlaceHolder = RemoveHtml($this->DIHAPUS->caption());
        if (strval($this->DIHAPUS->EditValue) != "" && is_numeric($this->DIHAPUS->EditValue)) {
            $this->DIHAPUS->EditValue = FormatNumber($this->DIHAPUS->EditValue, -2, -2, -2, -2);
        }

        // DIMINTA
        $this->DIMINTA->EditAttrs["class"] = "form-control";
        $this->DIMINTA->EditCustomAttributes = "";
        $this->DIMINTA->EditValue = $this->DIMINTA->CurrentValue;
        $this->DIMINTA->PlaceHolder = RemoveHtml($this->DIMINTA->caption());
        if (strval($this->DIMINTA->EditValue) != "" && is_numeric($this->DIMINTA->EditValue)) {
            $this->DIMINTA->EditValue = FormatNumber($this->DIMINTA->EditValue, -2, -2, -2, -2);
        }

        // DIRETUR
        $this->DIRETUR->EditAttrs["class"] = "form-control";
        $this->DIRETUR->EditCustomAttributes = "";
        $this->DIRETUR->EditValue = $this->DIRETUR->CurrentValue;
        $this->DIRETUR->PlaceHolder = RemoveHtml($this->DIRETUR->caption());
        if (strval($this->DIRETUR->EditValue) != "" && is_numeric($this->DIRETUR->EditValue)) {
            $this->DIRETUR->EditValue = FormatNumber($this->DIRETUR->EditValue, -2, -2, -2, -2);
        }

        // PO
        $this->PO->EditAttrs["class"] = "form-control";
        $this->PO->EditCustomAttributes = "";
        if (!$this->PO->Raw) {
            $this->PO->CurrentValue = HtmlDecode($this->PO->CurrentValue);
        }
        $this->PO->EditValue = $this->PO->CurrentValue;
        $this->PO->PlaceHolder = RemoveHtml($this->PO->caption());

        // FUND_ID
        $this->FUND_ID->EditAttrs["class"] = "form-control";
        $this->FUND_ID->EditCustomAttributes = "";
        $this->FUND_ID->EditValue = $this->FUND_ID->CurrentValue;
        $this->FUND_ID->PlaceHolder = RemoveHtml($this->FUND_ID->caption());

        // INVOICE_ID2
        $this->INVOICE_ID2->EditAttrs["class"] = "form-control";
        $this->INVOICE_ID2->EditCustomAttributes = "";
        if (!$this->INVOICE_ID2->Raw) {
            $this->INVOICE_ID2->CurrentValue = HtmlDecode($this->INVOICE_ID2->CurrentValue);
        }
        $this->INVOICE_ID2->EditValue = $this->INVOICE_ID2->CurrentValue;
        $this->INVOICE_ID2->PlaceHolder = RemoveHtml($this->INVOICE_ID2->caption());

        // MEASURE_ID3
        $this->MEASURE_ID3->EditAttrs["class"] = "form-control";
        $this->MEASURE_ID3->EditCustomAttributes = "";
        $this->MEASURE_ID3->EditValue = $this->MEASURE_ID3->CurrentValue;
        $this->MEASURE_ID3->PlaceHolder = RemoveHtml($this->MEASURE_ID3->caption());

        // SIZE_KEMASAN
        $this->SIZE_KEMASAN->EditAttrs["class"] = "form-control";
        $this->SIZE_KEMASAN->EditCustomAttributes = "";
        $this->SIZE_KEMASAN->EditValue = $this->SIZE_KEMASAN->CurrentValue;
        $this->SIZE_KEMASAN->PlaceHolder = RemoveHtml($this->SIZE_KEMASAN->caption());
        if (strval($this->SIZE_KEMASAN->EditValue) != "" && is_numeric($this->SIZE_KEMASAN->EditValue)) {
            $this->SIZE_KEMASAN->EditValue = FormatNumber($this->SIZE_KEMASAN->EditValue, -2, -2, -2, -2);
        }

        // BRAND_NAME
        $this->BRAND_NAME->EditAttrs["class"] = "form-control";
        $this->BRAND_NAME->EditCustomAttributes = "";
        if (!$this->BRAND_NAME->Raw) {
            $this->BRAND_NAME->CurrentValue = HtmlDecode($this->BRAND_NAME->CurrentValue);
        }
        $this->BRAND_NAME->EditValue = $this->BRAND_NAME->CurrentValue;
        $this->BRAND_NAME->PlaceHolder = RemoveHtml($this->BRAND_NAME->caption());

        // MEASURE_ID2
        $this->MEASURE_ID2->EditAttrs["class"] = "form-control";
        $this->MEASURE_ID2->EditCustomAttributes = "";
        $this->MEASURE_ID2->EditValue = $this->MEASURE_ID2->CurrentValue;
        $this->MEASURE_ID2->PlaceHolder = RemoveHtml($this->MEASURE_ID2->caption());

        // MONTH_ID
        $this->MONTH_ID->EditAttrs["class"] = "form-control";
        $this->MONTH_ID->EditCustomAttributes = "";
        $this->MONTH_ID->EditValue = $this->MONTH_ID->CurrentValue;
        $this->MONTH_ID->PlaceHolder = RemoveHtml($this->MONTH_ID->caption());

        // YEAR_ID
        $this->YEAR_ID->EditAttrs["class"] = "form-control";
        $this->YEAR_ID->EditCustomAttributes = "";
        $this->YEAR_ID->EditValue = $this->YEAR_ID->CurrentValue;
        $this->YEAR_ID->PlaceHolder = RemoveHtml($this->YEAR_ID->caption());

        // DISCOUNT
        $this->DISCOUNT->EditAttrs["class"] = "form-control";
        $this->DISCOUNT->EditCustomAttributes = "";
        $this->DISCOUNT->EditValue = $this->DISCOUNT->CurrentValue;
        $this->DISCOUNT->PlaceHolder = RemoveHtml($this->DISCOUNT->caption());
        if (strval($this->DISCOUNT->EditValue) != "" && is_numeric($this->DISCOUNT->EditValue)) {
            $this->DISCOUNT->EditValue = FormatNumber($this->DISCOUNT->EditValue, -2, -2, -2, -2);
        }

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
                    $doc->exportCaption($this->ORG_UNIT_CODE);
                    $doc->exportCaption($this->ITEM_ID);
                    $doc->exportCaption($this->ORG_ID);
                    $doc->exportCaption($this->DOC_NO);
                    $doc->exportCaption($this->BATCH_NO);
                    $doc->exportCaption($this->BRAND_ID);
                    $doc->exportCaption($this->ROOMS_ID);
                    $doc->exportCaption($this->SHELF_NO);
                    $doc->exportCaption($this->EXPIRY_DATE);
                    $doc->exportCaption($this->FROM_ROOMS_ID);
                    $doc->exportCaption($this->DISTRIBUTION_TYPE);
                    $doc->exportCaption($this->CONDITION);
                    $doc->exportCaption($this->ALLOCATED_DATE);
                    $doc->exportCaption($this->STOCKOPNAME_DATE);
                    $doc->exportCaption($this->INVOICE_ID);
                    $doc->exportCaption($this->ALLOCATED_FROM);
                    $doc->exportCaption($this->PRICE);
                    $doc->exportCaption($this->ORDER_PRICE);
                    $doc->exportCaption($this->ITEM_ID_FROM);
                    $doc->exportCaption($this->MODIFIED_DATE);
                    $doc->exportCaption($this->MODIFIED_BY);
                    $doc->exportCaption($this->STOCK_AVAILABLE);
                    $doc->exportCaption($this->STOCK_OPNAME);
                    $doc->exportCaption($this->STOK_AWAL);
                    $doc->exportCaption($this->STOCK_LALU);
                    $doc->exportCaption($this->STOCK_KOREKSI);
                    $doc->exportCaption($this->DITERIMA);
                    $doc->exportCaption($this->DISTRIBUSI);
                    $doc->exportCaption($this->DIJUAL);
                    $doc->exportCaption($this->DIHAPUS);
                    $doc->exportCaption($this->DIMINTA);
                    $doc->exportCaption($this->DIRETUR);
                    $doc->exportCaption($this->PO);
                    $doc->exportCaption($this->FUND_ID);
                    $doc->exportCaption($this->INVOICE_ID2);
                    $doc->exportCaption($this->MEASURE_ID3);
                    $doc->exportCaption($this->SIZE_KEMASAN);
                    $doc->exportCaption($this->BRAND_NAME);
                    $doc->exportCaption($this->MEASURE_ID2);
                    $doc->exportCaption($this->MONTH_ID);
                    $doc->exportCaption($this->YEAR_ID);
                    $doc->exportCaption($this->DISCOUNT);
                    $doc->exportCaption($this->QUANTITY);
                    $doc->exportCaption($this->MEASURE_ID);
                } else {
                    $doc->exportCaption($this->ORG_UNIT_CODE);
                    $doc->exportCaption($this->ITEM_ID);
                    $doc->exportCaption($this->ORG_ID);
                    $doc->exportCaption($this->DOC_NO);
                    $doc->exportCaption($this->BATCH_NO);
                    $doc->exportCaption($this->BRAND_ID);
                    $doc->exportCaption($this->ROOMS_ID);
                    $doc->exportCaption($this->SHELF_NO);
                    $doc->exportCaption($this->EXPIRY_DATE);
                    $doc->exportCaption($this->FROM_ROOMS_ID);
                    $doc->exportCaption($this->DISTRIBUTION_TYPE);
                    $doc->exportCaption($this->CONDITION);
                    $doc->exportCaption($this->ALLOCATED_DATE);
                    $doc->exportCaption($this->STOCKOPNAME_DATE);
                    $doc->exportCaption($this->INVOICE_ID);
                    $doc->exportCaption($this->ALLOCATED_FROM);
                    $doc->exportCaption($this->PRICE);
                    $doc->exportCaption($this->ORDER_PRICE);
                    $doc->exportCaption($this->ITEM_ID_FROM);
                    $doc->exportCaption($this->MODIFIED_DATE);
                    $doc->exportCaption($this->MODIFIED_BY);
                    $doc->exportCaption($this->STOCK_AVAILABLE);
                    $doc->exportCaption($this->STOCK_OPNAME);
                    $doc->exportCaption($this->STOK_AWAL);
                    $doc->exportCaption($this->STOCK_LALU);
                    $doc->exportCaption($this->STOCK_KOREKSI);
                    $doc->exportCaption($this->DITERIMA);
                    $doc->exportCaption($this->DISTRIBUSI);
                    $doc->exportCaption($this->DIJUAL);
                    $doc->exportCaption($this->DIHAPUS);
                    $doc->exportCaption($this->DIMINTA);
                    $doc->exportCaption($this->DIRETUR);
                    $doc->exportCaption($this->PO);
                    $doc->exportCaption($this->FUND_ID);
                    $doc->exportCaption($this->INVOICE_ID2);
                    $doc->exportCaption($this->MEASURE_ID3);
                    $doc->exportCaption($this->SIZE_KEMASAN);
                    $doc->exportCaption($this->BRAND_NAME);
                    $doc->exportCaption($this->MEASURE_ID2);
                    $doc->exportCaption($this->MONTH_ID);
                    $doc->exportCaption($this->YEAR_ID);
                    $doc->exportCaption($this->DISCOUNT);
                    $doc->exportCaption($this->QUANTITY);
                    $doc->exportCaption($this->MEASURE_ID);
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
                        $doc->exportField($this->ORG_UNIT_CODE);
                        $doc->exportField($this->ITEM_ID);
                        $doc->exportField($this->ORG_ID);
                        $doc->exportField($this->DOC_NO);
                        $doc->exportField($this->BATCH_NO);
                        $doc->exportField($this->BRAND_ID);
                        $doc->exportField($this->ROOMS_ID);
                        $doc->exportField($this->SHELF_NO);
                        $doc->exportField($this->EXPIRY_DATE);
                        $doc->exportField($this->FROM_ROOMS_ID);
                        $doc->exportField($this->DISTRIBUTION_TYPE);
                        $doc->exportField($this->CONDITION);
                        $doc->exportField($this->ALLOCATED_DATE);
                        $doc->exportField($this->STOCKOPNAME_DATE);
                        $doc->exportField($this->INVOICE_ID);
                        $doc->exportField($this->ALLOCATED_FROM);
                        $doc->exportField($this->PRICE);
                        $doc->exportField($this->ORDER_PRICE);
                        $doc->exportField($this->ITEM_ID_FROM);
                        $doc->exportField($this->MODIFIED_DATE);
                        $doc->exportField($this->MODIFIED_BY);
                        $doc->exportField($this->STOCK_AVAILABLE);
                        $doc->exportField($this->STOCK_OPNAME);
                        $doc->exportField($this->STOK_AWAL);
                        $doc->exportField($this->STOCK_LALU);
                        $doc->exportField($this->STOCK_KOREKSI);
                        $doc->exportField($this->DITERIMA);
                        $doc->exportField($this->DISTRIBUSI);
                        $doc->exportField($this->DIJUAL);
                        $doc->exportField($this->DIHAPUS);
                        $doc->exportField($this->DIMINTA);
                        $doc->exportField($this->DIRETUR);
                        $doc->exportField($this->PO);
                        $doc->exportField($this->FUND_ID);
                        $doc->exportField($this->INVOICE_ID2);
                        $doc->exportField($this->MEASURE_ID3);
                        $doc->exportField($this->SIZE_KEMASAN);
                        $doc->exportField($this->BRAND_NAME);
                        $doc->exportField($this->MEASURE_ID2);
                        $doc->exportField($this->MONTH_ID);
                        $doc->exportField($this->YEAR_ID);
                        $doc->exportField($this->DISCOUNT);
                        $doc->exportField($this->QUANTITY);
                        $doc->exportField($this->MEASURE_ID);
                    } else {
                        $doc->exportField($this->ORG_UNIT_CODE);
                        $doc->exportField($this->ITEM_ID);
                        $doc->exportField($this->ORG_ID);
                        $doc->exportField($this->DOC_NO);
                        $doc->exportField($this->BATCH_NO);
                        $doc->exportField($this->BRAND_ID);
                        $doc->exportField($this->ROOMS_ID);
                        $doc->exportField($this->SHELF_NO);
                        $doc->exportField($this->EXPIRY_DATE);
                        $doc->exportField($this->FROM_ROOMS_ID);
                        $doc->exportField($this->DISTRIBUTION_TYPE);
                        $doc->exportField($this->CONDITION);
                        $doc->exportField($this->ALLOCATED_DATE);
                        $doc->exportField($this->STOCKOPNAME_DATE);
                        $doc->exportField($this->INVOICE_ID);
                        $doc->exportField($this->ALLOCATED_FROM);
                        $doc->exportField($this->PRICE);
                        $doc->exportField($this->ORDER_PRICE);
                        $doc->exportField($this->ITEM_ID_FROM);
                        $doc->exportField($this->MODIFIED_DATE);
                        $doc->exportField($this->MODIFIED_BY);
                        $doc->exportField($this->STOCK_AVAILABLE);
                        $doc->exportField($this->STOCK_OPNAME);
                        $doc->exportField($this->STOK_AWAL);
                        $doc->exportField($this->STOCK_LALU);
                        $doc->exportField($this->STOCK_KOREKSI);
                        $doc->exportField($this->DITERIMA);
                        $doc->exportField($this->DISTRIBUSI);
                        $doc->exportField($this->DIJUAL);
                        $doc->exportField($this->DIHAPUS);
                        $doc->exportField($this->DIMINTA);
                        $doc->exportField($this->DIRETUR);
                        $doc->exportField($this->PO);
                        $doc->exportField($this->FUND_ID);
                        $doc->exportField($this->INVOICE_ID2);
                        $doc->exportField($this->MEASURE_ID3);
                        $doc->exportField($this->SIZE_KEMASAN);
                        $doc->exportField($this->BRAND_NAME);
                        $doc->exportField($this->MEASURE_ID2);
                        $doc->exportField($this->MONTH_ID);
                        $doc->exportField($this->YEAR_ID);
                        $doc->exportField($this->DISCOUNT);
                        $doc->exportField($this->QUANTITY);
                        $doc->exportField($this->MEASURE_ID);
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
