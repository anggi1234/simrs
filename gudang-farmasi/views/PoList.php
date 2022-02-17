<?php

namespace PHPMaker2021\SIMRSSQLSERVERGUDANGFARMASI;

// Page object
$PoList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fPOlist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fPOlist = currentForm = new ew.Form("fPOlist", "list");
    fPOlist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("fPOlist");
});
var fPOlistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    fPOlistsrch = currentSearchForm = new ew.Form("fPOlistsrch");

    // Dynamic selection lists

    // Filters
    fPOlistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fPOlistsrch");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($Page->TotalRecords > 0 && $Page->ExportOptions->visible()) { ?>
<?php $Page->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($Page->ImportOptions->visible()) { ?>
<?php $Page->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($Page->SearchOptions->visible()) { ?>
<?php $Page->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($Page->FilterOptions->visible()) { ?>
<?php $Page->FilterOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
$Page->renderOtherOptions();
?>
<?php if ($Security->canSearch()) { ?>
<?php if (!$Page->isExport() && !$Page->CurrentAction) { ?>
<form name="fPOlistsrch" id="fPOlistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fPOlistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="PO">
    <div class="ew-extended-search">
<div id="xsr_<?= $Page->SearchRowCount + 1 ?>" class="ew-row d-sm-flex">
    <div class="ew-quick-search input-group">
        <input type="text" name="<?= Config("TABLE_BASIC_SEARCH") ?>" id="<?= Config("TABLE_BASIC_SEARCH") ?>" class="form-control" value="<?= HtmlEncode($Page->BasicSearch->getKeyword()) ?>" placeholder="<?= HtmlEncode($Language->phrase("Search")) ?>">
        <input type="hidden" name="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" id="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" value="<?= HtmlEncode($Page->BasicSearch->getType()) ?>">
        <div class="input-group-append">
            <button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?= $Language->phrase("SearchBtn") ?></button>
            <button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false"><span id="searchtype"><?= $Page->BasicSearch->getTypeNameShort() ?></span></button>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item<?php if ($Page->BasicSearch->getType() == "") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this);"><?= $Language->phrase("QuickSearchAuto") ?></a>
                <a class="dropdown-item<?php if ($Page->BasicSearch->getType() == "=") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, '=');"><?= $Language->phrase("QuickSearchExact") ?></a>
                <a class="dropdown-item<?php if ($Page->BasicSearch->getType() == "AND") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'AND');"><?= $Language->phrase("QuickSearchAll") ?></a>
                <a class="dropdown-item<?php if ($Page->BasicSearch->getType() == "OR") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'OR');"><?= $Language->phrase("QuickSearchAny") ?></a>
            </div>
        </div>
    </div>
</div>
    </div><!-- /.ew-extended-search -->
</div><!-- /.ew-search-panel -->
</form>
<?php } ?>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<?php if ($Page->TotalRecords > 0 || $Page->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> PO">
<?php if (!$Page->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if (!$Page->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?= CurrentPageUrl(false) ?>">
<?= $Page->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="fPOlist" id="fPOlist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="PO">
<div id="gmp_PO" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_POlist" class="table ew-table"><!-- .ew-table -->
<thead>
    <tr class="ew-table-header">
<?php
// Header row
$Page->RowType = ROWTYPE_HEADER;

// Render list options
$Page->renderListOptions();

// Render list options (header, left)
$Page->ListOptions->render("header", "left");
?>
<?php if ($Page->ORG_UNIT_CODE->Visible) { // ORG_UNIT_CODE ?>
        <th data-name="ORG_UNIT_CODE" class="<?= $Page->ORG_UNIT_CODE->headerCellClass() ?>"><div id="elh_PO_ORG_UNIT_CODE" class="PO_ORG_UNIT_CODE"><?= $Page->renderSort($Page->ORG_UNIT_CODE) ?></div></th>
<?php } ?>
<?php if ($Page->PO->Visible) { // PO ?>
        <th data-name="PO" class="<?= $Page->PO->headerCellClass() ?>"><div id="elh_PO_PO" class="PO_PO"><?= $Page->renderSort($Page->PO) ?></div></th>
<?php } ?>
<?php if ($Page->PO_DATE->Visible) { // PO_DATE ?>
        <th data-name="PO_DATE" class="<?= $Page->PO_DATE->headerCellClass() ?>"><div id="elh_PO_PO_DATE" class="PO_PO_DATE"><?= $Page->renderSort($Page->PO_DATE) ?></div></th>
<?php } ?>
<?php if ($Page->ORDER_VALUE->Visible) { // ORDER_VALUE ?>
        <th data-name="ORDER_VALUE" class="<?= $Page->ORDER_VALUE->headerCellClass() ?>"><div id="elh_PO_ORDER_VALUE" class="PO_ORDER_VALUE"><?= $Page->renderSort($Page->ORDER_VALUE) ?></div></th>
<?php } ?>
<?php if ($Page->RECEIVED_VALUE->Visible) { // RECEIVED_VALUE ?>
        <th data-name="RECEIVED_VALUE" class="<?= $Page->RECEIVED_VALUE->headerCellClass() ?>"><div id="elh_PO_RECEIVED_VALUE" class="PO_RECEIVED_VALUE"><?= $Page->renderSort($Page->RECEIVED_VALUE) ?></div></th>
<?php } ?>
<?php if ($Page->PROCURE_METHOD->Visible) { // PROCURE_METHOD ?>
        <th data-name="PROCURE_METHOD" class="<?= $Page->PROCURE_METHOD->headerCellClass() ?>"><div id="elh_PO_PROCURE_METHOD" class="PO_PROCURE_METHOD"><?= $Page->renderSort($Page->PROCURE_METHOD) ?></div></th>
<?php } ?>
<?php if ($Page->COMPANY_ID->Visible) { // COMPANY_ID ?>
        <th data-name="COMPANY_ID" class="<?= $Page->COMPANY_ID->headerCellClass() ?>"><div id="elh_PO_COMPANY_ID" class="PO_COMPANY_ID"><?= $Page->renderSort($Page->COMPANY_ID) ?></div></th>
<?php } ?>
<?php if ($Page->FUND_ID->Visible) { // FUND_ID ?>
        <th data-name="FUND_ID" class="<?= $Page->FUND_ID->headerCellClass() ?>"><div id="elh_PO_FUND_ID" class="PO_FUND_ID"><?= $Page->renderSort($Page->FUND_ID) ?></div></th>
<?php } ?>
<?php if ($Page->FUND_NO->Visible) { // FUND_NO ?>
        <th data-name="FUND_NO" class="<?= $Page->FUND_NO->headerCellClass() ?>"><div id="elh_PO_FUND_NO" class="PO_FUND_NO"><?= $Page->renderSort($Page->FUND_NO) ?></div></th>
<?php } ?>
<?php if ($Page->DESCRIPTION->Visible) { // DESCRIPTION ?>
        <th data-name="DESCRIPTION" class="<?= $Page->DESCRIPTION->headerCellClass() ?>"><div id="elh_PO_DESCRIPTION" class="PO_DESCRIPTION"><?= $Page->renderSort($Page->DESCRIPTION) ?></div></th>
<?php } ?>
<?php if ($Page->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
        <th data-name="MODIFIED_DATE" class="<?= $Page->MODIFIED_DATE->headerCellClass() ?>"><div id="elh_PO_MODIFIED_DATE" class="PO_MODIFIED_DATE"><?= $Page->renderSort($Page->MODIFIED_DATE) ?></div></th>
<?php } ?>
<?php if ($Page->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
        <th data-name="MODIFIED_BY" class="<?= $Page->MODIFIED_BY->headerCellClass() ?>"><div id="elh_PO_MODIFIED_BY" class="PO_MODIFIED_BY"><?= $Page->renderSort($Page->MODIFIED_BY) ?></div></th>
<?php } ?>
<?php if ($Page->ORDER_BY->Visible) { // ORDER_BY ?>
        <th data-name="ORDER_BY" class="<?= $Page->ORDER_BY->headerCellClass() ?>"><div id="elh_PO_ORDER_BY" class="PO_ORDER_BY"><?= $Page->renderSort($Page->ORDER_BY) ?></div></th>
<?php } ?>
<?php if ($Page->SENT_TO->Visible) { // SENT_TO ?>
        <th data-name="SENT_TO" class="<?= $Page->SENT_TO->headerCellClass() ?>"><div id="elh_PO_SENT_TO" class="PO_SENT_TO"><?= $Page->renderSort($Page->SENT_TO) ?></div></th>
<?php } ?>
<?php if ($Page->ISVALID->Visible) { // ISVALID ?>
        <th data-name="ISVALID" class="<?= $Page->ISVALID->headerCellClass() ?>"><div id="elh_PO_ISVALID" class="PO_ISVALID"><?= $Page->renderSort($Page->ISVALID) ?></div></th>
<?php } ?>
<?php if ($Page->START_VALID->Visible) { // START_VALID ?>
        <th data-name="START_VALID" class="<?= $Page->START_VALID->headerCellClass() ?>"><div id="elh_PO_START_VALID" class="PO_START_VALID"><?= $Page->renderSort($Page->START_VALID) ?></div></th>
<?php } ?>
<?php if ($Page->END_VALID->Visible) { // END_VALID ?>
        <th data-name="END_VALID" class="<?= $Page->END_VALID->headerCellClass() ?>"><div id="elh_PO_END_VALID" class="PO_END_VALID"><?= $Page->renderSort($Page->END_VALID) ?></div></th>
<?php } ?>
<?php if ($Page->CONTRACT_NO->Visible) { // CONTRACT_NO ?>
        <th data-name="CONTRACT_NO" class="<?= $Page->CONTRACT_NO->headerCellClass() ?>"><div id="elh_PO_CONTRACT_NO" class="PO_CONTRACT_NO"><?= $Page->renderSort($Page->CONTRACT_NO) ?></div></th>
<?php } ?>
<?php if ($Page->ORG_ID->Visible) { // ORG_ID ?>
        <th data-name="ORG_ID" class="<?= $Page->ORG_ID->headerCellClass() ?>"><div id="elh_PO_ORG_ID" class="PO_ORG_ID"><?= $Page->renderSort($Page->ORG_ID) ?></div></th>
<?php } ?>
<?php if ($Page->CLINIC_ID->Visible) { // CLINIC_ID ?>
        <th data-name="CLINIC_ID" class="<?= $Page->CLINIC_ID->headerCellClass() ?>"><div id="elh_PO_CLINIC_ID" class="PO_CLINIC_ID"><?= $Page->renderSort($Page->CLINIC_ID) ?></div></th>
<?php } ?>
<?php if ($Page->ACCOUNT_ID->Visible) { // ACCOUNT_ID ?>
        <th data-name="ACCOUNT_ID" class="<?= $Page->ACCOUNT_ID->headerCellClass() ?>"><div id="elh_PO_ACCOUNT_ID" class="PO_ACCOUNT_ID"><?= $Page->renderSort($Page->ACCOUNT_ID) ?></div></th>
<?php } ?>
<?php if ($Page->PAID_VALUE->Visible) { // PAID_VALUE ?>
        <th data-name="PAID_VALUE" class="<?= $Page->PAID_VALUE->headerCellClass() ?>"><div id="elh_PO_PAID_VALUE" class="PO_PAID_VALUE"><?= $Page->renderSort($Page->PAID_VALUE) ?></div></th>
<?php } ?>
<?php if ($Page->PPN->Visible) { // PPN ?>
        <th data-name="PPN" class="<?= $Page->PPN->headerCellClass() ?>"><div id="elh_PO_PPN" class="PO_PPN"><?= $Page->renderSort($Page->PPN) ?></div></th>
<?php } ?>
<?php if ($Page->MATERAI->Visible) { // MATERAI ?>
        <th data-name="MATERAI" class="<?= $Page->MATERAI->headerCellClass() ?>"><div id="elh_PO_MATERAI" class="PO_MATERAI"><?= $Page->renderSort($Page->MATERAI) ?></div></th>
<?php } ?>
<?php if ($Page->PPN_VALUE->Visible) { // PPN_VALUE ?>
        <th data-name="PPN_VALUE" class="<?= $Page->PPN_VALUE->headerCellClass() ?>"><div id="elh_PO_PPN_VALUE" class="PO_PPN_VALUE"><?= $Page->renderSort($Page->PPN_VALUE) ?></div></th>
<?php } ?>
<?php if ($Page->DISCOUNT_VALUE->Visible) { // DISCOUNT_VALUE ?>
        <th data-name="DISCOUNT_VALUE" class="<?= $Page->DISCOUNT_VALUE->headerCellClass() ?>"><div id="elh_PO_DISCOUNT_VALUE" class="PO_DISCOUNT_VALUE"><?= $Page->renderSort($Page->DISCOUNT_VALUE) ?></div></th>
<?php } ?>
<?php if ($Page->ISCETAK->Visible) { // ISCETAK ?>
        <th data-name="ISCETAK" class="<?= $Page->ISCETAK->headerCellClass() ?>"><div id="elh_PO_ISCETAK" class="PO_ISCETAK"><?= $Page->renderSort($Page->ISCETAK) ?></div></th>
<?php } ?>
<?php if ($Page->PRINT_DATE->Visible) { // PRINT_DATE ?>
        <th data-name="PRINT_DATE" class="<?= $Page->PRINT_DATE->headerCellClass() ?>"><div id="elh_PO_PRINT_DATE" class="PO_PRINT_DATE"><?= $Page->renderSort($Page->PRINT_DATE) ?></div></th>
<?php } ?>
<?php if ($Page->PRINTED_BY->Visible) { // PRINTED_BY ?>
        <th data-name="PRINTED_BY" class="<?= $Page->PRINTED_BY->headerCellClass() ?>"><div id="elh_PO_PRINTED_BY" class="PO_PRINTED_BY"><?= $Page->renderSort($Page->PRINTED_BY) ?></div></th>
<?php } ?>
<?php if ($Page->PRINTQ->Visible) { // PRINTQ ?>
        <th data-name="PRINTQ" class="<?= $Page->PRINTQ->headerCellClass() ?>"><div id="elh_PO_PRINTQ" class="PO_PRINTQ"><?= $Page->renderSort($Page->PRINTQ) ?></div></th>
<?php } ?>
<?php if ($Page->TAGIHAN_VALUE->Visible) { // TAGIHAN_VALUE ?>
        <th data-name="TAGIHAN_VALUE" class="<?= $Page->TAGIHAN_VALUE->headerCellClass() ?>"><div id="elh_PO_TAGIHAN_VALUE" class="PO_TAGIHAN_VALUE"><?= $Page->renderSort($Page->TAGIHAN_VALUE) ?></div></th>
<?php } ?>
<?php if ($Page->ACKNOWLEDGEBY->Visible) { // ACKNOWLEDGEBY ?>
        <th data-name="ACKNOWLEDGEBY" class="<?= $Page->ACKNOWLEDGEBY->headerCellClass() ?>"><div id="elh_PO_ACKNOWLEDGEBY" class="PO_ACKNOWLEDGEBY"><?= $Page->renderSort($Page->ACKNOWLEDGEBY) ?></div></th>
<?php } ?>
<?php if ($Page->NUM->Visible) { // NUM ?>
        <th data-name="NUM" class="<?= $Page->NUM->headerCellClass() ?>"><div id="elh_PO_NUM" class="PO_NUM"><?= $Page->renderSort($Page->NUM) ?></div></th>
<?php } ?>
<?php if ($Page->ID->Visible) { // ID ?>
        <th data-name="ID" class="<?= $Page->ID->headerCellClass() ?>"><div id="elh_PO_ID" class="PO_ID"><?= $Page->renderSort($Page->ID) ?></div></th>
<?php } ?>
<?php
// Render list options (header, right)
$Page->ListOptions->render("header", "right");
?>
    </tr>
</thead>
<tbody>
<?php
if ($Page->ExportAll && $Page->isExport()) {
    $Page->StopRecord = $Page->TotalRecords;
} else {
    // Set the last record to display
    if ($Page->TotalRecords > $Page->StartRecord + $Page->DisplayRecords - 1) {
        $Page->StopRecord = $Page->StartRecord + $Page->DisplayRecords - 1;
    } else {
        $Page->StopRecord = $Page->TotalRecords;
    }
}
$Page->RecordCount = $Page->StartRecord - 1;
if ($Page->Recordset && !$Page->Recordset->EOF) {
    // Nothing to do
} elseif (!$Page->AllowAddDeleteRow && $Page->StopRecord == 0) {
    $Page->StopRecord = $Page->GridAddRowCount;
}

// Initialize aggregate
$Page->RowType = ROWTYPE_AGGREGATEINIT;
$Page->resetAttributes();
$Page->renderRow();
while ($Page->RecordCount < $Page->StopRecord) {
    $Page->RecordCount++;
    if ($Page->RecordCount >= $Page->StartRecord) {
        $Page->RowCount++;

        // Set up key count
        $Page->KeyCount = $Page->RowIndex;

        // Init row class and style
        $Page->resetAttributes();
        $Page->CssClass = "";
        if ($Page->isGridAdd()) {
            $Page->loadRowValues(); // Load default values
            $Page->OldKey = "";
            $Page->setKey($Page->OldKey);
        } else {
            $Page->loadRowValues($Page->Recordset); // Load row values
            if ($Page->isGridEdit()) {
                $Page->OldKey = $Page->getKey(true); // Get from CurrentValue
                $Page->setKey($Page->OldKey);
            }
        }
        $Page->RowType = ROWTYPE_VIEW; // Render view

        // Set up row id / data-rowindex
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_PO", "data-rowtype" => $Page->RowType]);

        // Render row
        $Page->renderRow();

        // Render list options
        $Page->renderListOptions();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount);
?>
    <?php if ($Page->ORG_UNIT_CODE->Visible) { // ORG_UNIT_CODE ?>
        <td data-name="ORG_UNIT_CODE" <?= $Page->ORG_UNIT_CODE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_ORG_UNIT_CODE">
<span<?= $Page->ORG_UNIT_CODE->viewAttributes() ?>>
<?= $Page->ORG_UNIT_CODE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PO->Visible) { // PO ?>
        <td data-name="PO" <?= $Page->PO->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_PO">
<span<?= $Page->PO->viewAttributes() ?>>
<?= $Page->PO->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PO_DATE->Visible) { // PO_DATE ?>
        <td data-name="PO_DATE" <?= $Page->PO_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_PO_DATE">
<span<?= $Page->PO_DATE->viewAttributes() ?>>
<?= $Page->PO_DATE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ORDER_VALUE->Visible) { // ORDER_VALUE ?>
        <td data-name="ORDER_VALUE" <?= $Page->ORDER_VALUE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_ORDER_VALUE">
<span<?= $Page->ORDER_VALUE->viewAttributes() ?>>
<?= $Page->ORDER_VALUE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->RECEIVED_VALUE->Visible) { // RECEIVED_VALUE ?>
        <td data-name="RECEIVED_VALUE" <?= $Page->RECEIVED_VALUE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_RECEIVED_VALUE">
<span<?= $Page->RECEIVED_VALUE->viewAttributes() ?>>
<?= $Page->RECEIVED_VALUE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PROCURE_METHOD->Visible) { // PROCURE_METHOD ?>
        <td data-name="PROCURE_METHOD" <?= $Page->PROCURE_METHOD->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_PROCURE_METHOD">
<span<?= $Page->PROCURE_METHOD->viewAttributes() ?>>
<?= $Page->PROCURE_METHOD->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->COMPANY_ID->Visible) { // COMPANY_ID ?>
        <td data-name="COMPANY_ID" <?= $Page->COMPANY_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_COMPANY_ID">
<span<?= $Page->COMPANY_ID->viewAttributes() ?>>
<?= $Page->COMPANY_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->FUND_ID->Visible) { // FUND_ID ?>
        <td data-name="FUND_ID" <?= $Page->FUND_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_FUND_ID">
<span<?= $Page->FUND_ID->viewAttributes() ?>>
<?= $Page->FUND_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->FUND_NO->Visible) { // FUND_NO ?>
        <td data-name="FUND_NO" <?= $Page->FUND_NO->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_FUND_NO">
<span<?= $Page->FUND_NO->viewAttributes() ?>>
<?= $Page->FUND_NO->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->DESCRIPTION->Visible) { // DESCRIPTION ?>
        <td data-name="DESCRIPTION" <?= $Page->DESCRIPTION->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_DESCRIPTION">
<span<?= $Page->DESCRIPTION->viewAttributes() ?>>
<?= $Page->DESCRIPTION->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
        <td data-name="MODIFIED_DATE" <?= $Page->MODIFIED_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_MODIFIED_DATE">
<span<?= $Page->MODIFIED_DATE->viewAttributes() ?>>
<?= $Page->MODIFIED_DATE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
        <td data-name="MODIFIED_BY" <?= $Page->MODIFIED_BY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_MODIFIED_BY">
<span<?= $Page->MODIFIED_BY->viewAttributes() ?>>
<?= $Page->MODIFIED_BY->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ORDER_BY->Visible) { // ORDER_BY ?>
        <td data-name="ORDER_BY" <?= $Page->ORDER_BY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_ORDER_BY">
<span<?= $Page->ORDER_BY->viewAttributes() ?>>
<?= $Page->ORDER_BY->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->SENT_TO->Visible) { // SENT_TO ?>
        <td data-name="SENT_TO" <?= $Page->SENT_TO->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_SENT_TO">
<span<?= $Page->SENT_TO->viewAttributes() ?>>
<?= $Page->SENT_TO->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ISVALID->Visible) { // ISVALID ?>
        <td data-name="ISVALID" <?= $Page->ISVALID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_ISVALID">
<span<?= $Page->ISVALID->viewAttributes() ?>>
<?= $Page->ISVALID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->START_VALID->Visible) { // START_VALID ?>
        <td data-name="START_VALID" <?= $Page->START_VALID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_START_VALID">
<span<?= $Page->START_VALID->viewAttributes() ?>>
<?= $Page->START_VALID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->END_VALID->Visible) { // END_VALID ?>
        <td data-name="END_VALID" <?= $Page->END_VALID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_END_VALID">
<span<?= $Page->END_VALID->viewAttributes() ?>>
<?= $Page->END_VALID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->CONTRACT_NO->Visible) { // CONTRACT_NO ?>
        <td data-name="CONTRACT_NO" <?= $Page->CONTRACT_NO->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_CONTRACT_NO">
<span<?= $Page->CONTRACT_NO->viewAttributes() ?>>
<?= $Page->CONTRACT_NO->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ORG_ID->Visible) { // ORG_ID ?>
        <td data-name="ORG_ID" <?= $Page->ORG_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_ORG_ID">
<span<?= $Page->ORG_ID->viewAttributes() ?>>
<?= $Page->ORG_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->CLINIC_ID->Visible) { // CLINIC_ID ?>
        <td data-name="CLINIC_ID" <?= $Page->CLINIC_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_CLINIC_ID">
<span<?= $Page->CLINIC_ID->viewAttributes() ?>>
<?= $Page->CLINIC_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ACCOUNT_ID->Visible) { // ACCOUNT_ID ?>
        <td data-name="ACCOUNT_ID" <?= $Page->ACCOUNT_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_ACCOUNT_ID">
<span<?= $Page->ACCOUNT_ID->viewAttributes() ?>>
<?= $Page->ACCOUNT_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PAID_VALUE->Visible) { // PAID_VALUE ?>
        <td data-name="PAID_VALUE" <?= $Page->PAID_VALUE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_PAID_VALUE">
<span<?= $Page->PAID_VALUE->viewAttributes() ?>>
<?= $Page->PAID_VALUE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PPN->Visible) { // PPN ?>
        <td data-name="PPN" <?= $Page->PPN->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_PPN">
<span<?= $Page->PPN->viewAttributes() ?>>
<?= $Page->PPN->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->MATERAI->Visible) { // MATERAI ?>
        <td data-name="MATERAI" <?= $Page->MATERAI->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_MATERAI">
<span<?= $Page->MATERAI->viewAttributes() ?>>
<?= $Page->MATERAI->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PPN_VALUE->Visible) { // PPN_VALUE ?>
        <td data-name="PPN_VALUE" <?= $Page->PPN_VALUE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_PPN_VALUE">
<span<?= $Page->PPN_VALUE->viewAttributes() ?>>
<?= $Page->PPN_VALUE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->DISCOUNT_VALUE->Visible) { // DISCOUNT_VALUE ?>
        <td data-name="DISCOUNT_VALUE" <?= $Page->DISCOUNT_VALUE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_DISCOUNT_VALUE">
<span<?= $Page->DISCOUNT_VALUE->viewAttributes() ?>>
<?= $Page->DISCOUNT_VALUE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ISCETAK->Visible) { // ISCETAK ?>
        <td data-name="ISCETAK" <?= $Page->ISCETAK->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_ISCETAK">
<span<?= $Page->ISCETAK->viewAttributes() ?>>
<?= $Page->ISCETAK->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PRINT_DATE->Visible) { // PRINT_DATE ?>
        <td data-name="PRINT_DATE" <?= $Page->PRINT_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_PRINT_DATE">
<span<?= $Page->PRINT_DATE->viewAttributes() ?>>
<?= $Page->PRINT_DATE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PRINTED_BY->Visible) { // PRINTED_BY ?>
        <td data-name="PRINTED_BY" <?= $Page->PRINTED_BY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_PRINTED_BY">
<span<?= $Page->PRINTED_BY->viewAttributes() ?>>
<?= $Page->PRINTED_BY->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PRINTQ->Visible) { // PRINTQ ?>
        <td data-name="PRINTQ" <?= $Page->PRINTQ->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_PRINTQ">
<span<?= $Page->PRINTQ->viewAttributes() ?>>
<?= $Page->PRINTQ->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->TAGIHAN_VALUE->Visible) { // TAGIHAN_VALUE ?>
        <td data-name="TAGIHAN_VALUE" <?= $Page->TAGIHAN_VALUE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_TAGIHAN_VALUE">
<span<?= $Page->TAGIHAN_VALUE->viewAttributes() ?>>
<?= $Page->TAGIHAN_VALUE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ACKNOWLEDGEBY->Visible) { // ACKNOWLEDGEBY ?>
        <td data-name="ACKNOWLEDGEBY" <?= $Page->ACKNOWLEDGEBY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_ACKNOWLEDGEBY">
<span<?= $Page->ACKNOWLEDGEBY->viewAttributes() ?>>
<?= $Page->ACKNOWLEDGEBY->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->NUM->Visible) { // NUM ?>
        <td data-name="NUM" <?= $Page->NUM->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_NUM">
<span<?= $Page->NUM->viewAttributes() ?>>
<?= $Page->NUM->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ID->Visible) { // ID ?>
        <td data-name="ID" <?= $Page->ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_ID">
<span<?= $Page->ID->viewAttributes() ?>>
<?= $Page->ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
    </tr>
<?php
    }
    if (!$Page->isGridAdd()) {
        $Page->Recordset->moveNext();
    }
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
<?php if (!$Page->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</form><!-- /.ew-list-form -->
<?php
// Close recordset
if ($Page->Recordset) {
    $Page->Recordset->close();
}
?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($Page->TotalRecords == 0 && !$Page->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("PO");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
