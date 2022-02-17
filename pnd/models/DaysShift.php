<?php

namespace PHPMaker2021\SIMRSSQLSERVERPENDAFTARAN;

use Doctrine\DBAL\ParameterType;

/**
 * Table class for DAYS_SHIFT
 */
class DaysShift extends DbTable
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
    public $SHIFT_ID;
    public $HOUR_START;
    public $MINUTE_START;
    public $HOUR_END;
    public $MINUTE_END;
    public $SHIFT_DESC;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'DAYS_SHIFT';
        $this->TableName = 'DAYS_SHIFT';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "[dbo].[DAYS_SHIFT]";
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

        // SHIFT_ID
        $this->SHIFT_ID = new DbField('DAYS_SHIFT', 'DAYS_SHIFT', 'x_SHIFT_ID', 'SHIFT_ID', '[SHIFT_ID]', 'CAST([SHIFT_ID] AS NVARCHAR)', 3, 4, -1, false, '[SHIFT_ID]', false, false, false, 'FORMATTED TEXT', 'NO');
        $this->SHIFT_ID->IsAutoIncrement = true; // Autoincrement field
        $this->SHIFT_ID->IsPrimaryKey = true; // Primary key field
        $this->SHIFT_ID->Nullable = false; // NOT NULL field
        $this->SHIFT_ID->Sortable = true; // Allow sort
        $this->SHIFT_ID->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->SHIFT_ID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->SHIFT_ID->Param, "CustomMsg");
        $this->Fields['SHIFT_ID'] = &$this->SHIFT_ID;

        // HOUR_START
        $this->HOUR_START = new DbField('DAYS_SHIFT', 'DAYS_SHIFT', 'x_HOUR_START', 'HOUR_START', '[HOUR_START]', 'CAST([HOUR_START] AS NVARCHAR)', 3, 4, -1, false, '[HOUR_START]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->HOUR_START->Sortable = true; // Allow sort
        $this->HOUR_START->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->HOUR_START->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->HOUR_START->Param, "CustomMsg");
        $this->Fields['HOUR_START'] = &$this->HOUR_START;

        // MINUTE_START
        $this->MINUTE_START = new DbField('DAYS_SHIFT', 'DAYS_SHIFT', 'x_MINUTE_START', 'MINUTE_START', '[MINUTE_START]', 'CAST([MINUTE_START] AS NVARCHAR)', 3, 4, -1, false, '[MINUTE_START]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->MINUTE_START->Sortable = true; // Allow sort
        $this->MINUTE_START->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->MINUTE_START->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->MINUTE_START->Param, "CustomMsg");
        $this->Fields['MINUTE_START'] = &$this->MINUTE_START;

        // HOUR_END
        $this->HOUR_END = new DbField('DAYS_SHIFT', 'DAYS_SHIFT', 'x_HOUR_END', 'HOUR_END', '[HOUR_END]', 'CAST([HOUR_END] AS NVARCHAR)', 3, 4, -1, false, '[HOUR_END]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->HOUR_END->Sortable = true; // Allow sort
        $this->HOUR_END->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->HOUR_END->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->HOUR_END->Param, "CustomMsg");
        $this->Fields['HOUR_END'] = &$this->HOUR_END;

        // MINUTE_END
        $this->MINUTE_END = new DbField('DAYS_SHIFT', 'DAYS_SHIFT', 'x_MINUTE_END', 'MINUTE_END', '[MINUTE_END]', 'CAST([MINUTE_END] AS NVARCHAR)', 3, 4, -1, false, '[MINUTE_END]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->MINUTE_END->Sortable = true; // Allow sort
        $this->MINUTE_END->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->MINUTE_END->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->MINUTE_END->Param, "CustomMsg");
        $this->Fields['MINUTE_END'] = &$this->MINUTE_END;

        // SHIFT_DESC
        $this->SHIFT_DESC = new DbField('DAYS_SHIFT', 'DAYS_SHIFT', 'x_SHIFT_DESC', 'SHIFT_DESC', '[SHIFT_DESC]', '[SHIFT_DESC]', 200, 50, -1, false, '[SHIFT_DESC]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->SHIFT_DESC->Sortable = true; // Allow sort
        $this->SHIFT_DESC->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->SHIFT_DESC->Param, "CustomMsg");
        $this->Fields['SHIFT_DESC'] = &$this->SHIFT_DESC;
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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "[dbo].[DAYS_SHIFT]";
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
            // Get insert id if necessary
            $this->SHIFT_ID->setDbValue($conn->lastInsertId());
            $rs['SHIFT_ID'] = $this->SHIFT_ID->DbValue;
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
            if (array_key_exists('SHIFT_ID', $rs)) {
                AddFilter($where, QuotedName('SHIFT_ID', $this->Dbid) . '=' . QuotedValue($rs['SHIFT_ID'], $this->SHIFT_ID->DataType, $this->Dbid));
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
        $this->SHIFT_ID->DbValue = $row['SHIFT_ID'];
        $this->HOUR_START->DbValue = $row['HOUR_START'];
        $this->MINUTE_START->DbValue = $row['MINUTE_START'];
        $this->HOUR_END->DbValue = $row['HOUR_END'];
        $this->MINUTE_END->DbValue = $row['MINUTE_END'];
        $this->SHIFT_DESC->DbValue = $row['SHIFT_DESC'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "[SHIFT_ID] = @SHIFT_ID@";
    }

    // Get Key
    public function getKey($current = false)
    {
        $keys = [];
        $val = $current ? $this->SHIFT_ID->CurrentValue : $this->SHIFT_ID->OldValue;
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
                $this->SHIFT_ID->CurrentValue = $keys[0];
            } else {
                $this->SHIFT_ID->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('SHIFT_ID', $row) ? $row['SHIFT_ID'] : null;
        } else {
            $val = $this->SHIFT_ID->OldValue !== null ? $this->SHIFT_ID->OldValue : $this->SHIFT_ID->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@SHIFT_ID@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return $_SESSION[$name] ?? GetUrl("DaysShiftList");
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
        if ($pageName == "DaysShiftView") {
            return $Language->phrase("View");
        } elseif ($pageName == "DaysShiftEdit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "DaysShiftAdd") {
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
                return "DaysShiftView";
            case Config("API_ADD_ACTION"):
                return "DaysShiftAdd";
            case Config("API_EDIT_ACTION"):
                return "DaysShiftEdit";
            case Config("API_DELETE_ACTION"):
                return "DaysShiftDelete";
            case Config("API_LIST_ACTION"):
                return "DaysShiftList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "DaysShiftList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("DaysShiftView", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("DaysShiftView", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "DaysShiftAdd?" . $this->getUrlParm($parm);
        } else {
            $url = "DaysShiftAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("DaysShiftEdit", $this->getUrlParm($parm));
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
        $url = $this->keyUrl("DaysShiftAdd", $this->getUrlParm($parm));
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
        return $this->keyUrl("DaysShiftDelete", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json .= "SHIFT_ID:" . JsonEncode($this->SHIFT_ID->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->SHIFT_ID->CurrentValue !== null) {
            $url .= "/" . rawurlencode($this->SHIFT_ID->CurrentValue);
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
            if (($keyValue = Param("SHIFT_ID") ?? Route("SHIFT_ID")) !== null) {
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
                $this->SHIFT_ID->CurrentValue = $key;
            } else {
                $this->SHIFT_ID->OldValue = $key;
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
        $this->SHIFT_ID->setDbValue($row['SHIFT_ID']);
        $this->HOUR_START->setDbValue($row['HOUR_START']);
        $this->MINUTE_START->setDbValue($row['MINUTE_START']);
        $this->HOUR_END->setDbValue($row['HOUR_END']);
        $this->MINUTE_END->setDbValue($row['MINUTE_END']);
        $this->SHIFT_DESC->setDbValue($row['SHIFT_DESC']);
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // SHIFT_ID

        // HOUR_START

        // MINUTE_START

        // HOUR_END

        // MINUTE_END

        // SHIFT_DESC

        // SHIFT_ID
        $this->SHIFT_ID->ViewValue = $this->SHIFT_ID->CurrentValue;
        $this->SHIFT_ID->ViewCustomAttributes = "";

        // HOUR_START
        $this->HOUR_START->ViewValue = $this->HOUR_START->CurrentValue;
        $this->HOUR_START->ViewValue = FormatNumber($this->HOUR_START->ViewValue, 0, -2, -2, -2);
        $this->HOUR_START->ViewCustomAttributes = "";

        // MINUTE_START
        $this->MINUTE_START->ViewValue = $this->MINUTE_START->CurrentValue;
        $this->MINUTE_START->ViewValue = FormatNumber($this->MINUTE_START->ViewValue, 0, -2, -2, -2);
        $this->MINUTE_START->ViewCustomAttributes = "";

        // HOUR_END
        $this->HOUR_END->ViewValue = $this->HOUR_END->CurrentValue;
        $this->HOUR_END->ViewValue = FormatNumber($this->HOUR_END->ViewValue, 0, -2, -2, -2);
        $this->HOUR_END->ViewCustomAttributes = "";

        // MINUTE_END
        $this->MINUTE_END->ViewValue = $this->MINUTE_END->CurrentValue;
        $this->MINUTE_END->ViewValue = FormatNumber($this->MINUTE_END->ViewValue, 0, -2, -2, -2);
        $this->MINUTE_END->ViewCustomAttributes = "";

        // SHIFT_DESC
        $this->SHIFT_DESC->ViewValue = $this->SHIFT_DESC->CurrentValue;
        $this->SHIFT_DESC->ViewCustomAttributes = "";

        // SHIFT_ID
        $this->SHIFT_ID->LinkCustomAttributes = "";
        $this->SHIFT_ID->HrefValue = "";
        $this->SHIFT_ID->TooltipValue = "";

        // HOUR_START
        $this->HOUR_START->LinkCustomAttributes = "";
        $this->HOUR_START->HrefValue = "";
        $this->HOUR_START->TooltipValue = "";

        // MINUTE_START
        $this->MINUTE_START->LinkCustomAttributes = "";
        $this->MINUTE_START->HrefValue = "";
        $this->MINUTE_START->TooltipValue = "";

        // HOUR_END
        $this->HOUR_END->LinkCustomAttributes = "";
        $this->HOUR_END->HrefValue = "";
        $this->HOUR_END->TooltipValue = "";

        // MINUTE_END
        $this->MINUTE_END->LinkCustomAttributes = "";
        $this->MINUTE_END->HrefValue = "";
        $this->MINUTE_END->TooltipValue = "";

        // SHIFT_DESC
        $this->SHIFT_DESC->LinkCustomAttributes = "";
        $this->SHIFT_DESC->HrefValue = "";
        $this->SHIFT_DESC->TooltipValue = "";

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

        // SHIFT_ID
        $this->SHIFT_ID->EditAttrs["class"] = "form-control";
        $this->SHIFT_ID->EditCustomAttributes = "";
        $this->SHIFT_ID->EditValue = $this->SHIFT_ID->CurrentValue;
        $this->SHIFT_ID->ViewCustomAttributes = "";

        // HOUR_START
        $this->HOUR_START->EditAttrs["class"] = "form-control";
        $this->HOUR_START->EditCustomAttributes = "";
        $this->HOUR_START->EditValue = $this->HOUR_START->CurrentValue;
        $this->HOUR_START->PlaceHolder = RemoveHtml($this->HOUR_START->caption());

        // MINUTE_START
        $this->MINUTE_START->EditAttrs["class"] = "form-control";
        $this->MINUTE_START->EditCustomAttributes = "";
        $this->MINUTE_START->EditValue = $this->MINUTE_START->CurrentValue;
        $this->MINUTE_START->PlaceHolder = RemoveHtml($this->MINUTE_START->caption());

        // HOUR_END
        $this->HOUR_END->EditAttrs["class"] = "form-control";
        $this->HOUR_END->EditCustomAttributes = "";
        $this->HOUR_END->EditValue = $this->HOUR_END->CurrentValue;
        $this->HOUR_END->PlaceHolder = RemoveHtml($this->HOUR_END->caption());

        // MINUTE_END
        $this->MINUTE_END->EditAttrs["class"] = "form-control";
        $this->MINUTE_END->EditCustomAttributes = "";
        $this->MINUTE_END->EditValue = $this->MINUTE_END->CurrentValue;
        $this->MINUTE_END->PlaceHolder = RemoveHtml($this->MINUTE_END->caption());

        // SHIFT_DESC
        $this->SHIFT_DESC->EditAttrs["class"] = "form-control";
        $this->SHIFT_DESC->EditCustomAttributes = "";
        if (!$this->SHIFT_DESC->Raw) {
            $this->SHIFT_DESC->CurrentValue = HtmlDecode($this->SHIFT_DESC->CurrentValue);
        }
        $this->SHIFT_DESC->EditValue = $this->SHIFT_DESC->CurrentValue;
        $this->SHIFT_DESC->PlaceHolder = RemoveHtml($this->SHIFT_DESC->caption());

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
                    $doc->exportCaption($this->SHIFT_ID);
                    $doc->exportCaption($this->HOUR_START);
                    $doc->exportCaption($this->MINUTE_START);
                    $doc->exportCaption($this->HOUR_END);
                    $doc->exportCaption($this->MINUTE_END);
                    $doc->exportCaption($this->SHIFT_DESC);
                } else {
                    $doc->exportCaption($this->SHIFT_ID);
                    $doc->exportCaption($this->HOUR_START);
                    $doc->exportCaption($this->MINUTE_START);
                    $doc->exportCaption($this->HOUR_END);
                    $doc->exportCaption($this->MINUTE_END);
                    $doc->exportCaption($this->SHIFT_DESC);
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
                        $doc->exportField($this->SHIFT_ID);
                        $doc->exportField($this->HOUR_START);
                        $doc->exportField($this->MINUTE_START);
                        $doc->exportField($this->HOUR_END);
                        $doc->exportField($this->MINUTE_END);
                        $doc->exportField($this->SHIFT_DESC);
                    } else {
                        $doc->exportField($this->SHIFT_ID);
                        $doc->exportField($this->HOUR_START);
                        $doc->exportField($this->MINUTE_START);
                        $doc->exportField($this->HOUR_END);
                        $doc->exportField($this->MINUTE_END);
                        $doc->exportField($this->SHIFT_DESC);
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
