<?php

namespace PHPMaker2021\Online;

use Doctrine\DBAL\ParameterType;

/**
 * Table class for V_daftardis
 */
class VDaftardis extends DbTable
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
    public $Id;
    public $no_urut;
    public $tanggal_daftar;
    public $tanggal_panggil;
    public $loket;
    public $status_panggil;
    public $user;
    public $newapp;
    public $kdpoli;
    public $tanggal_pesan;
    public $tujuan;
    public $disabilitas;
    public $cetak;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'V_daftardis';
        $this->TableName = 'V_daftardis';
        $this->TableType = 'CUSTOMVIEW';

        // Update Table
        $this->UpdateTable = "dbo.ANTRIAN_PENDAFTARAN";
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
        $this->BasicSearch = new BasicSearch($this->TableVar);

        // Id
        $this->Id = new DbField('V_daftardis', 'V_daftardis', 'x_Id', 'Id', '[Id]', 'CAST([Id] AS NVARCHAR)', 20, 8, -1, false, '[Id]', false, false, false, 'FORMATTED TEXT', 'NO');
        $this->Id->IsAutoIncrement = true; // Autoincrement field
        $this->Id->IsPrimaryKey = true; // Primary key field
        $this->Id->Nullable = false; // NOT NULL field
        $this->Id->Sortable = false; // Allow sort
        $this->Id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Id->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->Id->Param, "CustomMsg");
        $this->Fields['Id'] = &$this->Id;

        // no_urut
        $this->no_urut = new DbField('V_daftardis', 'V_daftardis', 'x_no_urut', 'no_urut', '[no_urut]', 'CAST([no_urut] AS NVARCHAR)', 20, 8, -1, false, '[no_urut]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->no_urut->Sortable = false; // Allow sort
        $this->no_urut->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->no_urut->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->no_urut->Param, "CustomMsg");
        $this->Fields['no_urut'] = &$this->no_urut;

        // tanggal_daftar
        $this->tanggal_daftar = new DbField('V_daftardis', 'V_daftardis', 'x_tanggal_daftar', 'tanggal_daftar', '[tanggal_daftar]', CastDateFieldForLike("[tanggal_daftar]", 7, "DB"), 135, 8, 7, false, '[tanggal_daftar]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->tanggal_daftar->Sortable = false; // Allow sort
        $this->tanggal_daftar->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_SEPARATOR"], $Language->phrase("IncorrectDateDMY"));
        $this->tanggal_daftar->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->tanggal_daftar->Param, "CustomMsg");
        $this->Fields['tanggal_daftar'] = &$this->tanggal_daftar;

        // tanggal_panggil
        $this->tanggal_panggil = new DbField('V_daftardis', 'V_daftardis', 'x_tanggal_panggil', 'tanggal_panggil', '[tanggal_panggil]', CastDateFieldForLike("[tanggal_panggil]", 0, "DB"), 135, 8, 0, false, '[tanggal_panggil]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->tanggal_panggil->Sortable = false; // Allow sort
        $this->tanggal_panggil->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->tanggal_panggil->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->tanggal_panggil->Param, "CustomMsg");
        $this->Fields['tanggal_panggil'] = &$this->tanggal_panggil;

        // loket
        $this->loket = new DbField('V_daftardis', 'V_daftardis', 'x_loket', 'loket', '[loket]', '[loket]', 200, 10, -1, false, '[loket]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->loket->Sortable = false; // Allow sort
        $this->loket->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->loket->Param, "CustomMsg");
        $this->Fields['loket'] = &$this->loket;

        // status_panggil
        $this->status_panggil = new DbField('V_daftardis', 'V_daftardis', 'x_status_panggil', 'status_panggil', '[status_panggil]', 'CAST([status_panggil] AS NVARCHAR)', 3, 4, -1, false, '[status_panggil]', false, false, false, 'FORMATTED TEXT', 'HIDDEN');
        $this->status_panggil->Sortable = false; // Allow sort
        $this->status_panggil->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->status_panggil->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->status_panggil->Param, "CustomMsg");
        $this->Fields['status_panggil'] = &$this->status_panggil;

        // user
        $this->user = new DbField('V_daftardis', 'V_daftardis', 'x_user', 'user', '[user]', 'CAST([user] AS NVARCHAR)', 20, 8, -1, false, '[user]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->user->Sortable = false; // Allow sort
        switch ($CurrentLanguage) {
            case "en":
                $this->user->Lookup = new Lookup('user', 'ANTRIAN_LOGIN', false, 'ID', ["NAMA","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->user->Lookup = new Lookup('user', 'ANTRIAN_LOGIN', false, 'ID', ["NAMA","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->user->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->user->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->user->Param, "CustomMsg");
        $this->Fields['user'] = &$this->user;

        // newapp
        $this->newapp = new DbField('V_daftardis', 'V_daftardis', 'x_newapp', 'newapp', 'dbo.ANTRIAN_PENDAFTARAN.newapp', 'CAST(dbo.ANTRIAN_PENDAFTARAN.newapp AS NVARCHAR)', 3, 4, -1, false, 'dbo.ANTRIAN_PENDAFTARAN.newapp', false, false, false, 'FORMATTED TEXT', 'HIDDEN');
        $this->newapp->Sortable = false; // Allow sort
        $this->newapp->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->newapp->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->newapp->Param, "CustomMsg");
        $this->Fields['newapp'] = &$this->newapp;

        // kdpoli
        $this->kdpoli = new DbField('V_daftardis', 'V_daftardis', 'x_kdpoli', 'kdpoli', '[kdpoli]', '[kdpoli]', 200, 10, -1, false, '[kdpoli]', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->kdpoli->Sortable = false; // Allow sort
        $this->kdpoli->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->kdpoli->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->kdpoli->Lookup = new Lookup('kdpoli', 'CLINIC', false, 'CLINIC_ID', ["NAME_OF_CLINIC","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->kdpoli->Lookup = new Lookup('kdpoli', 'CLINIC', false, 'CLINIC_ID', ["NAME_OF_CLINIC","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->kdpoli->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->kdpoli->Param, "CustomMsg");
        $this->Fields['kdpoli'] = &$this->kdpoli;

        // tanggal_pesan
        $this->tanggal_pesan = new DbField('V_daftardis', 'V_daftardis', 'x_tanggal_pesan', 'tanggal_pesan', '[tanggal_pesan]', CastDateFieldForLike("[tanggal_pesan]", 0, "DB"), 135, 8, 0, false, '[tanggal_pesan]', false, false, false, 'FORMATTED TEXT', 'HIDDEN');
        $this->tanggal_pesan->Sortable = false; // Allow sort
        $this->tanggal_pesan->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->tanggal_pesan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->tanggal_pesan->Param, "CustomMsg");
        $this->Fields['tanggal_pesan'] = &$this->tanggal_pesan;

        // tujuan
        $this->tujuan = new DbField('V_daftardis', 'V_daftardis', 'x_tujuan', 'tujuan', '[tujuan]', '[tujuan]', 200, 255, -1, false, '[tujuan]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->tujuan->Sortable = false; // Allow sort
        $this->tujuan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->tujuan->Param, "CustomMsg");
        $this->Fields['tujuan'] = &$this->tujuan;

        // disabilitas
        $this->disabilitas = new DbField('V_daftardis', 'V_daftardis', 'x_disabilitas', 'disabilitas', 'dbo.ANTRIAN_PENDAFTARAN.disabilitas', 'CAST(dbo.ANTRIAN_PENDAFTARAN.disabilitas AS NVARCHAR)', 3, 4, -1, false, 'dbo.ANTRIAN_PENDAFTARAN.disabilitas', false, false, false, 'FORMATTED TEXT', 'HIDDEN');
        $this->disabilitas->Sortable = true; // Allow sort
        $this->disabilitas->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->disabilitas->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->disabilitas->Param, "CustomMsg");
        $this->Fields['disabilitas'] = &$this->disabilitas;

        // cetak
        $this->cetak = new DbField('V_daftardis', 'V_daftardis', 'x_cetak', 'cetak', '\'\'', '\'\'', 200, 1, -1, false, '\'\'', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->cetak->IsCustom = true; // Custom field
        $this->cetak->Sortable = true; // Allow sort
        $this->cetak->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->cetak->Param, "CustomMsg");
        $this->Fields['cetak'] = &$this->cetak;
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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "dbo.ANTRIAN_PENDAFTARAN";
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
        return $this->SqlSelect ?? $this->getQueryBuilder()->select("*, '' AS [cetak]");
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
        $where = ($this->SqlWhere != "") ? $this->SqlWhere : "dbo.ANTRIAN_PENDAFTARAN.newapp = 1 AND dbo.ANTRIAN_PENDAFTARAN.disabilitas = 1";
        $this->DefaultFilter = "[newapp] = 1 and [disabilitas] = 1";
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
        global $Security;
        // Add User ID filter
        if ($Security->currentUserID() != "" && !$Security->isAdmin()) { // Non system admin
            $filter = $this->addUserIDFilter($filter);
        }
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
            $this->Id->setDbValue($conn->lastInsertId());
            $rs['Id'] = $this->Id->DbValue;
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
            if (array_key_exists('Id', $rs)) {
                AddFilter($where, QuotedName('Id', $this->Dbid) . '=' . QuotedValue($rs['Id'], $this->Id->DataType, $this->Dbid));
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
        $this->Id->DbValue = $row['Id'];
        $this->no_urut->DbValue = $row['no_urut'];
        $this->tanggal_daftar->DbValue = $row['tanggal_daftar'];
        $this->tanggal_panggil->DbValue = $row['tanggal_panggil'];
        $this->loket->DbValue = $row['loket'];
        $this->status_panggil->DbValue = $row['status_panggil'];
        $this->user->DbValue = $row['user'];
        $this->newapp->DbValue = $row['newapp'];
        $this->kdpoli->DbValue = $row['kdpoli'];
        $this->tanggal_pesan->DbValue = $row['tanggal_pesan'];
        $this->tujuan->DbValue = $row['tujuan'];
        $this->disabilitas->DbValue = $row['disabilitas'];
        $this->cetak->DbValue = $row['cetak'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "[Id] = @Id@";
    }

    // Get Key
    public function getKey($current = false)
    {
        $keys = [];
        $val = $current ? $this->Id->CurrentValue : $this->Id->OldValue;
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
                $this->Id->CurrentValue = $keys[0];
            } else {
                $this->Id->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('Id', $row) ? $row['Id'] : null;
        } else {
            $val = $this->Id->OldValue !== null ? $this->Id->OldValue : $this->Id->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@Id@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return $_SESSION[$name] ?? GetUrl("VDaftardisList");
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
        if ($pageName == "VDaftardisView") {
            return $Language->phrase("View");
        } elseif ($pageName == "VDaftardisEdit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "VDaftardisAdd") {
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
                return "VDaftardisView";
            case Config("API_ADD_ACTION"):
                return "VDaftardisAdd";
            case Config("API_EDIT_ACTION"):
                return "VDaftardisEdit";
            case Config("API_DELETE_ACTION"):
                return "VDaftardisDelete";
            case Config("API_LIST_ACTION"):
                return "VDaftardisList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "VDaftardisList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("VDaftardisView", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("VDaftardisView", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "VDaftardisAdd?" . $this->getUrlParm($parm);
        } else {
            $url = "VDaftardisAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("VDaftardisEdit", $this->getUrlParm($parm));
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
        $url = $this->keyUrl("VDaftardisAdd", $this->getUrlParm($parm));
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
        return $this->keyUrl("VDaftardisDelete", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json .= "Id:" . JsonEncode($this->Id->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->Id->CurrentValue !== null) {
            $url .= "/" . rawurlencode($this->Id->CurrentValue);
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
            if (($keyValue = Param("Id") ?? Route("Id")) !== null) {
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
                $this->Id->CurrentValue = $key;
            } else {
                $this->Id->OldValue = $key;
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
        $this->Id->setDbValue($row['Id']);
        $this->no_urut->setDbValue($row['no_urut']);
        $this->tanggal_daftar->setDbValue($row['tanggal_daftar']);
        $this->tanggal_panggil->setDbValue($row['tanggal_panggil']);
        $this->loket->setDbValue($row['loket']);
        $this->status_panggil->setDbValue($row['status_panggil']);
        $this->user->setDbValue($row['user']);
        $this->newapp->setDbValue($row['newapp']);
        $this->kdpoli->setDbValue($row['kdpoli']);
        $this->tanggal_pesan->setDbValue($row['tanggal_pesan']);
        $this->tujuan->setDbValue($row['tujuan']);
        $this->disabilitas->setDbValue($row['disabilitas']);
        $this->cetak->setDbValue($row['cetak']);
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // Id

        // no_urut
        $this->no_urut->CellCssStyle = "width: 80px;";

        // tanggal_daftar
        $this->tanggal_daftar->CellCssStyle = "width: 150px;";

        // tanggal_panggil

        // loket

        // status_panggil

        // user
        $this->user->CellCssStyle = "width: 190px;";

        // newapp

        // kdpoli
        $this->kdpoli->CellCssStyle = "width: 180px;";

        // tanggal_pesan

        // tujuan

        // disabilitas
        $this->disabilitas->CellCssStyle = "white-space: nowrap;";

        // cetak
        $this->cetak->CellCssStyle = "width: 80px;";

        // Id
        $this->Id->ViewValue = $this->Id->CurrentValue;
        $this->Id->ViewCustomAttributes = "";

        // no_urut
        $this->no_urut->ViewValue = $this->no_urut->CurrentValue;
        $this->no_urut->ViewValue = FormatNumber($this->no_urut->ViewValue, 0, -2, -2, -2);
        $this->no_urut->CellCssStyle .= "text-align: center;";
        $this->no_urut->ViewCustomAttributes = "";

        // tanggal_daftar
        $this->tanggal_daftar->ViewValue = $this->tanggal_daftar->CurrentValue;
        $this->tanggal_daftar->ViewValue = FormatDateTime($this->tanggal_daftar->ViewValue, 7);
        $this->tanggal_daftar->CellCssStyle .= "text-align: center;";
        $this->tanggal_daftar->ViewCustomAttributes = "";

        // tanggal_panggil
        $this->tanggal_panggil->ViewValue = $this->tanggal_panggil->CurrentValue;
        $this->tanggal_panggil->ViewValue = FormatDateTime($this->tanggal_panggil->ViewValue, 0);
        $this->tanggal_panggil->ViewCustomAttributes = "";

        // loket
        $this->loket->ViewValue = $this->loket->CurrentValue;
        $this->loket->ViewCustomAttributes = "";

        // status_panggil
        $this->status_panggil->ViewValue = $this->status_panggil->CurrentValue;
        $this->status_panggil->ViewValue = FormatNumber($this->status_panggil->ViewValue, 0, -2, -2, -2);
        $this->status_panggil->ViewCustomAttributes = "";

        // user
        $this->user->ViewValue = $this->user->CurrentValue;
        $curVal = trim(strval($this->user->CurrentValue));
        if ($curVal != "") {
            $this->user->ViewValue = $this->user->lookupCacheOption($curVal);
            if ($this->user->ViewValue === null) { // Lookup from database
                $filterWrk = "[ID]" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->user->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->user->Lookup->renderViewRow($rswrk[0]);
                    $this->user->ViewValue = $this->user->displayValue($arwrk);
                } else {
                    $this->user->ViewValue = $this->user->CurrentValue;
                }
            }
        } else {
            $this->user->ViewValue = null;
        }
        $this->user->CellCssStyle .= "text-align: center;";
        $this->user->ViewCustomAttributes = "";

        // newapp
        $this->newapp->ViewValue = $this->newapp->CurrentValue;
        $this->newapp->ViewValue = FormatNumber($this->newapp->ViewValue, 0, -2, -2, -2);
        $this->newapp->ViewCustomAttributes = "";

        // kdpoli
        $curVal = trim(strval($this->kdpoli->CurrentValue));
        if ($curVal != "") {
            $this->kdpoli->ViewValue = $this->kdpoli->lookupCacheOption($curVal);
            if ($this->kdpoli->ViewValue === null) { // Lookup from database
                $filterWrk = "[CLINIC_ID]" . SearchString("=", $curVal, DATATYPE_STRING, "");
                $lookupFilter = function() {
                    return "[STYPE_ID] = 1";
                };
                $lookupFilter = $lookupFilter->bindTo($this);
                $sqlWrk = $this->kdpoli->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->kdpoli->Lookup->renderViewRow($rswrk[0]);
                    $this->kdpoli->ViewValue = $this->kdpoli->displayValue($arwrk);
                } else {
                    $this->kdpoli->ViewValue = $this->kdpoli->CurrentValue;
                }
            }
        } else {
            $this->kdpoli->ViewValue = null;
        }
        $this->kdpoli->CellCssStyle .= "text-align: center;";
        $this->kdpoli->ViewCustomAttributes = "";

        // tanggal_pesan
        $this->tanggal_pesan->ViewValue = $this->tanggal_pesan->CurrentValue;
        $this->tanggal_pesan->ViewValue = FormatDateTime($this->tanggal_pesan->ViewValue, 0);
        $this->tanggal_pesan->ViewCustomAttributes = "";

        // tujuan
        $this->tujuan->ViewValue = $this->tujuan->CurrentValue;
        $this->tujuan->ViewCustomAttributes = "";

        // disabilitas
        $this->disabilitas->ViewValue = $this->disabilitas->CurrentValue;
        $this->disabilitas->ViewValue = FormatNumber($this->disabilitas->ViewValue, 0, -2, -2, -2);
        $this->disabilitas->ViewCustomAttributes = "";

        // cetak
        $this->cetak->ViewValue = $this->cetak->CurrentValue;
        $this->cetak->ViewCustomAttributes = "";

        // Id
        $this->Id->LinkCustomAttributes = "";
        $this->Id->HrefValue = "";
        $this->Id->TooltipValue = "";

        // no_urut
        $this->no_urut->LinkCustomAttributes = "";
        $this->no_urut->HrefValue = "";
        $this->no_urut->TooltipValue = "";

        // tanggal_daftar
        $this->tanggal_daftar->LinkCustomAttributes = "";
        $this->tanggal_daftar->HrefValue = "";
        $this->tanggal_daftar->TooltipValue = "";

        // tanggal_panggil
        $this->tanggal_panggil->LinkCustomAttributes = "";
        $this->tanggal_panggil->HrefValue = "";
        $this->tanggal_panggil->TooltipValue = "";

        // loket
        $this->loket->LinkCustomAttributes = "";
        $this->loket->HrefValue = "";
        $this->loket->TooltipValue = "";

        // status_panggil
        $this->status_panggil->LinkCustomAttributes = "";
        $this->status_panggil->HrefValue = "";
        $this->status_panggil->TooltipValue = "";

        // user
        $this->user->LinkCustomAttributes = "";
        $this->user->HrefValue = "";
        $this->user->TooltipValue = "";

        // newapp
        $this->newapp->LinkCustomAttributes = "";
        $this->newapp->HrefValue = "";
        $this->newapp->TooltipValue = "";

        // kdpoli
        $this->kdpoli->LinkCustomAttributes = "";
        $this->kdpoli->HrefValue = "";
        $this->kdpoli->TooltipValue = "";

        // tanggal_pesan
        $this->tanggal_pesan->LinkCustomAttributes = "";
        $this->tanggal_pesan->HrefValue = "";
        $this->tanggal_pesan->TooltipValue = "";

        // tujuan
        $this->tujuan->LinkCustomAttributes = "";
        $this->tujuan->HrefValue = "";
        $this->tujuan->TooltipValue = "";

        // disabilitas
        $this->disabilitas->LinkCustomAttributes = "";
        $this->disabilitas->HrefValue = "";
        $this->disabilitas->TooltipValue = "";

        // cetak
        $this->cetak->LinkCustomAttributes = "";
        $this->cetak->HrefValue = "";
        $this->cetak->TooltipValue = "";

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

        // Id
        $this->Id->EditAttrs["class"] = "form-control";
        $this->Id->EditCustomAttributes = "";
        $this->Id->EditValue = $this->Id->CurrentValue;
        $this->Id->ViewCustomAttributes = "";

        // no_urut
        $this->no_urut->EditAttrs["class"] = "form-control";
        $this->no_urut->EditCustomAttributes = "";
        $this->no_urut->EditValue = $this->no_urut->CurrentValue;
        $this->no_urut->EditValue = FormatNumber($this->no_urut->EditValue, 0, -2, -2, -2);
        $this->no_urut->CellCssStyle .= "text-align: center;";
        $this->no_urut->ViewCustomAttributes = "";

        // tanggal_daftar
        $this->tanggal_daftar->EditAttrs["class"] = "form-control";
        $this->tanggal_daftar->EditCustomAttributes = "";
        $this->tanggal_daftar->EditValue = $this->tanggal_daftar->CurrentValue;
        $this->tanggal_daftar->EditValue = FormatDateTime($this->tanggal_daftar->EditValue, 7);
        $this->tanggal_daftar->CellCssStyle .= "text-align: center;";
        $this->tanggal_daftar->ViewCustomAttributes = "";

        // tanggal_panggil
        $this->tanggal_panggil->EditAttrs["class"] = "form-control";
        $this->tanggal_panggil->EditCustomAttributes = "";
        $this->tanggal_panggil->EditValue = FormatDateTime($this->tanggal_panggil->CurrentValue, 8);
        $this->tanggal_panggil->PlaceHolder = RemoveHtml($this->tanggal_panggil->caption());

        // loket
        $this->loket->EditAttrs["class"] = "form-control";
        $this->loket->EditCustomAttributes = "";
        if (!$this->loket->Raw) {
            $this->loket->CurrentValue = HtmlDecode($this->loket->CurrentValue);
        }
        $this->loket->EditValue = $this->loket->CurrentValue;
        $this->loket->PlaceHolder = RemoveHtml($this->loket->caption());

        // status_panggil
        $this->status_panggil->EditAttrs["class"] = "form-control";
        $this->status_panggil->EditCustomAttributes = "";

        // user

        // newapp
        $this->newapp->EditAttrs["class"] = "form-control";
        $this->newapp->EditCustomAttributes = "";

        // kdpoli
        $this->kdpoli->EditAttrs["class"] = "form-control";
        $this->kdpoli->EditCustomAttributes = "";
        $curVal = trim(strval($this->kdpoli->CurrentValue));
        if ($curVal != "") {
            $this->kdpoli->EditValue = $this->kdpoli->lookupCacheOption($curVal);
            if ($this->kdpoli->EditValue === null) { // Lookup from database
                $filterWrk = "[CLINIC_ID]" . SearchString("=", $curVal, DATATYPE_STRING, "");
                $lookupFilter = function() {
                    return "[STYPE_ID] = 1";
                };
                $lookupFilter = $lookupFilter->bindTo($this);
                $sqlWrk = $this->kdpoli->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->kdpoli->Lookup->renderViewRow($rswrk[0]);
                    $this->kdpoli->EditValue = $this->kdpoli->displayValue($arwrk);
                } else {
                    $this->kdpoli->EditValue = $this->kdpoli->CurrentValue;
                }
            }
        } else {
            $this->kdpoli->EditValue = null;
        }
        $this->kdpoli->CellCssStyle .= "text-align: center;";
        $this->kdpoli->ViewCustomAttributes = "";

        // tanggal_pesan

        // tujuan
        $this->tujuan->EditAttrs["class"] = "form-control";
        $this->tujuan->EditCustomAttributes = "";
        $this->tujuan->EditValue = $this->tujuan->CurrentValue;
        $this->tujuan->ViewCustomAttributes = "";

        // disabilitas
        $this->disabilitas->EditAttrs["class"] = "form-control";
        $this->disabilitas->EditCustomAttributes = "";

        // cetak
        $this->cetak->EditAttrs["class"] = "form-control";
        $this->cetak->EditCustomAttributes = "";
        if (!$this->cetak->Raw) {
            $this->cetak->CurrentValue = HtmlDecode($this->cetak->CurrentValue);
        }
        $this->cetak->EditValue = $this->cetak->CurrentValue;
        $this->cetak->PlaceHolder = RemoveHtml($this->cetak->caption());

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
                    $doc->exportCaption($this->no_urut);
                    $doc->exportCaption($this->tanggal_daftar);
                    $doc->exportCaption($this->kdpoli);
                    $doc->exportCaption($this->tujuan);
                    $doc->exportCaption($this->cetak);
                } else {
                    $doc->exportCaption($this->disabilitas);
                    $doc->exportCaption($this->cetak);
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
                        $doc->exportField($this->no_urut);
                        $doc->exportField($this->tanggal_daftar);
                        $doc->exportField($this->kdpoli);
                        $doc->exportField($this->tujuan);
                        $doc->exportField($this->cetak);
                    } else {
                        $doc->exportField($this->disabilitas);
                        $doc->exportField($this->cetak);
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

    // Add User ID filter
    public function addUserIDFilter($filter = "")
    {
        global $Security;
        $filterWrk = "";
        $id = (CurrentPageID() == "list") ? $this->CurrentAction : CurrentPageID();
        if (!$this->userIDAllow($id) && !$Security->isAdmin()) {
            $filterWrk = $Security->userIdList();
            if ($filterWrk != "") {
                $filterWrk = '[user] IN (' . $filterWrk . ')';
            }
        }

        // Call User ID Filtering event
        $this->userIdFiltering($filterWrk);
        AddFilter($filter, $filterWrk);
        return $filter;
    }

    // User ID subquery
    public function getUserIDSubquery(&$fld, &$masterfld)
    {
        global $UserTable;
        $wrk = "";
        $sql = "SELECT " . $masterfld->Expression . " FROM dbo.ANTRIAN_PENDAFTARAN";
        $filter = $this->addUserIDFilter("");
        if ($filter != "") {
            $sql .= " WHERE " . $filter;
        }

        // List all values
        if ($rs = Conn($UserTable->Dbid)->executeQuery($sql)->fetchAll(\PDO::FETCH_NUM)) {
            foreach ($rs as $row) {
                if ($wrk != "") {
                    $wrk .= ",";
                }
                $wrk .= QuotedValue($row[0], $masterfld->DataType, Config("USER_TABLE_DBID"));
            }
        }
        if ($wrk != "") {
            $wrk = $fld->Expression . " IN (" . $wrk . ")";
        } else { // No User ID value found
            $wrk = "0=1";
        }
        return $wrk;
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
