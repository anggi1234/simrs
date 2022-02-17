<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

// Page object
$GoodMutationList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fGOOD_MUTATIONlist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fGOOD_MUTATIONlist = currentForm = new ew.Form("fGOOD_MUTATIONlist", "list");
    fGOOD_MUTATIONlist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("fGOOD_MUTATIONlist");
});
var fGOOD_MUTATIONlistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    fGOOD_MUTATIONlistsrch = currentSearchForm = new ew.Form("fGOOD_MUTATIONlistsrch");

    // Dynamic selection lists

    // Filters
    fGOOD_MUTATIONlistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fGOOD_MUTATIONlistsrch");
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
<form name="fGOOD_MUTATIONlistsrch" id="fGOOD_MUTATIONlistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fGOOD_MUTATIONlistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="GOOD_MUTATION">
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> GOOD_MUTATION">
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
<form name="fGOOD_MUTATIONlist" id="fGOOD_MUTATIONlist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="GOOD_MUTATION">
<div id="gmp_GOOD_MUTATION" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_GOOD_MUTATIONlist" class="table ew-table"><!-- .ew-table -->
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
        <th data-name="ORG_UNIT_CODE" class="<?= $Page->ORG_UNIT_CODE->headerCellClass() ?>"><div id="elh_GOOD_MUTATION_ORG_UNIT_CODE" class="GOOD_MUTATION_ORG_UNIT_CODE"><?= $Page->renderSort($Page->ORG_UNIT_CODE) ?></div></th>
<?php } ?>
<?php if ($Page->ITEM_ID->Visible) { // ITEM_ID ?>
        <th data-name="ITEM_ID" class="<?= $Page->ITEM_ID->headerCellClass() ?>"><div id="elh_GOOD_MUTATION_ITEM_ID" class="GOOD_MUTATION_ITEM_ID"><?= $Page->renderSort($Page->ITEM_ID) ?></div></th>
<?php } ?>
<?php if ($Page->ORG_ID->Visible) { // ORG_ID ?>
        <th data-name="ORG_ID" class="<?= $Page->ORG_ID->headerCellClass() ?>"><div id="elh_GOOD_MUTATION_ORG_ID" class="GOOD_MUTATION_ORG_ID"><?= $Page->renderSort($Page->ORG_ID) ?></div></th>
<?php } ?>
<?php if ($Page->RETUR_ID->Visible) { // RETUR_ID ?>
        <th data-name="RETUR_ID" class="<?= $Page->RETUR_ID->headerCellClass() ?>"><div id="elh_GOOD_MUTATION_RETUR_ID" class="GOOD_MUTATION_RETUR_ID"><?= $Page->renderSort($Page->RETUR_ID) ?></div></th>
<?php } ?>
<?php if ($Page->ORDER_ID->Visible) { // ORDER_ID ?>
        <th data-name="ORDER_ID" class="<?= $Page->ORDER_ID->headerCellClass() ?>"><div id="elh_GOOD_MUTATION_ORDER_ID" class="GOOD_MUTATION_ORDER_ID"><?= $Page->renderSort($Page->ORDER_ID) ?></div></th>
<?php } ?>
<?php if ($Page->BATCH_NO->Visible) { // BATCH_NO ?>
        <th data-name="BATCH_NO" class="<?= $Page->BATCH_NO->headerCellClass() ?>"><div id="elh_GOOD_MUTATION_BATCH_NO" class="GOOD_MUTATION_BATCH_NO"><?= $Page->renderSort($Page->BATCH_NO) ?></div></th>
<?php } ?>
<?php if ($Page->BRAND_ID->Visible) { // BRAND_ID ?>
        <th data-name="BRAND_ID" class="<?= $Page->BRAND_ID->headerCellClass() ?>"><div id="elh_GOOD_MUTATION_BRAND_ID" class="GOOD_MUTATION_BRAND_ID"><?= $Page->renderSort($Page->BRAND_ID) ?></div></th>
<?php } ?>
<?php if ($Page->ROOMS_ID->Visible) { // ROOMS_ID ?>
        <th data-name="ROOMS_ID" class="<?= $Page->ROOMS_ID->headerCellClass() ?>"><div id="elh_GOOD_MUTATION_ROOMS_ID" class="GOOD_MUTATION_ROOMS_ID"><?= $Page->renderSort($Page->ROOMS_ID) ?></div></th>
<?php } ?>
<?php if ($Page->SHELF_NO->Visible) { // SHELF_NO ?>
        <th data-name="SHELF_NO" class="<?= $Page->SHELF_NO->headerCellClass() ?>"><div id="elh_GOOD_MUTATION_SHELF_NO" class="GOOD_MUTATION_SHELF_NO"><?= $Page->renderSort($Page->SHELF_NO) ?></div></th>
<?php } ?>
<?php if ($Page->EXPIRY_DATE->Visible) { // EXPIRY_DATE ?>
        <th data-name="EXPIRY_DATE" class="<?= $Page->EXPIRY_DATE->headerCellClass() ?>"><div id="elh_GOOD_MUTATION_EXPIRY_DATE" class="GOOD_MUTATION_EXPIRY_DATE"><?= $Page->renderSort($Page->EXPIRY_DATE) ?></div></th>
<?php } ?>
<?php if ($Page->SERIAL_NB->Visible) { // SERIAL_NB ?>
        <th data-name="SERIAL_NB" class="<?= $Page->SERIAL_NB->headerCellClass() ?>"><div id="elh_GOOD_MUTATION_SERIAL_NB" class="GOOD_MUTATION_SERIAL_NB"><?= $Page->renderSort($Page->SERIAL_NB) ?></div></th>
<?php } ?>
<?php if ($Page->FROM_ROOMS_ID->Visible) { // FROM_ROOMS_ID ?>
        <th data-name="FROM_ROOMS_ID" class="<?= $Page->FROM_ROOMS_ID->headerCellClass() ?>"><div id="elh_GOOD_MUTATION_FROM_ROOMS_ID" class="GOOD_MUTATION_FROM_ROOMS_ID"><?= $Page->renderSort($Page->FROM_ROOMS_ID) ?></div></th>
<?php } ?>
<?php if ($Page->ISOUTLET->Visible) { // ISOUTLET ?>
        <th data-name="ISOUTLET" class="<?= $Page->ISOUTLET->headerCellClass() ?>"><div id="elh_GOOD_MUTATION_ISOUTLET" class="GOOD_MUTATION_ISOUTLET"><?= $Page->renderSort($Page->ISOUTLET) ?></div></th>
<?php } ?>
<?php if ($Page->QUANTITY->Visible) { // QUANTITY ?>
        <th data-name="QUANTITY" class="<?= $Page->QUANTITY->headerCellClass() ?>"><div id="elh_GOOD_MUTATION_QUANTITY" class="GOOD_MUTATION_QUANTITY"><?= $Page->renderSort($Page->QUANTITY) ?></div></th>
<?php } ?>
<?php if ($Page->MEASURE_ID->Visible) { // MEASURE_ID ?>
        <th data-name="MEASURE_ID" class="<?= $Page->MEASURE_ID->headerCellClass() ?>"><div id="elh_GOOD_MUTATION_MEASURE_ID" class="GOOD_MUTATION_MEASURE_ID"><?= $Page->renderSort($Page->MEASURE_ID) ?></div></th>
<?php } ?>
<?php if ($Page->DISTRIBUTION_TYPE->Visible) { // DISTRIBUTION_TYPE ?>
        <th data-name="DISTRIBUTION_TYPE" class="<?= $Page->DISTRIBUTION_TYPE->headerCellClass() ?>"><div id="elh_GOOD_MUTATION_DISTRIBUTION_TYPE" class="GOOD_MUTATION_DISTRIBUTION_TYPE"><?= $Page->renderSort($Page->DISTRIBUTION_TYPE) ?></div></th>
<?php } ?>
<?php if ($Page->CONDITION->Visible) { // CONDITION ?>
        <th data-name="CONDITION" class="<?= $Page->CONDITION->headerCellClass() ?>"><div id="elh_GOOD_MUTATION_CONDITION" class="GOOD_MUTATION_CONDITION"><?= $Page->renderSort($Page->CONDITION) ?></div></th>
<?php } ?>
<?php if ($Page->ALLOCATED_DATE->Visible) { // ALLOCATED_DATE ?>
        <th data-name="ALLOCATED_DATE" class="<?= $Page->ALLOCATED_DATE->headerCellClass() ?>"><div id="elh_GOOD_MUTATION_ALLOCATED_DATE" class="GOOD_MUTATION_ALLOCATED_DATE"><?= $Page->renderSort($Page->ALLOCATED_DATE) ?></div></th>
<?php } ?>
<?php if ($Page->STOCKOPNAME_DATE->Visible) { // STOCKOPNAME_DATE ?>
        <th data-name="STOCKOPNAME_DATE" class="<?= $Page->STOCKOPNAME_DATE->headerCellClass() ?>"><div id="elh_GOOD_MUTATION_STOCKOPNAME_DATE" class="GOOD_MUTATION_STOCKOPNAME_DATE"><?= $Page->renderSort($Page->STOCKOPNAME_DATE) ?></div></th>
<?php } ?>
<?php if ($Page->INVOICE_ID->Visible) { // INVOICE_ID ?>
        <th data-name="INVOICE_ID" class="<?= $Page->INVOICE_ID->headerCellClass() ?>"><div id="elh_GOOD_MUTATION_INVOICE_ID" class="GOOD_MUTATION_INVOICE_ID"><?= $Page->renderSort($Page->INVOICE_ID) ?></div></th>
<?php } ?>
<?php if ($Page->ALLOCATED_FROM->Visible) { // ALLOCATED_FROM ?>
        <th data-name="ALLOCATED_FROM" class="<?= $Page->ALLOCATED_FROM->headerCellClass() ?>"><div id="elh_GOOD_MUTATION_ALLOCATED_FROM" class="GOOD_MUTATION_ALLOCATED_FROM"><?= $Page->renderSort($Page->ALLOCATED_FROM) ?></div></th>
<?php } ?>
<?php if ($Page->PRICE->Visible) { // PRICE ?>
        <th data-name="PRICE" class="<?= $Page->PRICE->headerCellClass() ?>"><div id="elh_GOOD_MUTATION_PRICE" class="GOOD_MUTATION_PRICE"><?= $Page->renderSort($Page->PRICE) ?></div></th>
<?php } ?>
<?php if ($Page->ITEM_ID_FROM->Visible) { // ITEM_ID_FROM ?>
        <th data-name="ITEM_ID_FROM" class="<?= $Page->ITEM_ID_FROM->headerCellClass() ?>"><div id="elh_GOOD_MUTATION_ITEM_ID_FROM" class="GOOD_MUTATION_ITEM_ID_FROM"><?= $Page->renderSort($Page->ITEM_ID_FROM) ?></div></th>
<?php } ?>
<?php if ($Page->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
        <th data-name="MODIFIED_DATE" class="<?= $Page->MODIFIED_DATE->headerCellClass() ?>"><div id="elh_GOOD_MUTATION_MODIFIED_DATE" class="GOOD_MUTATION_MODIFIED_DATE"><?= $Page->renderSort($Page->MODIFIED_DATE) ?></div></th>
<?php } ?>
<?php if ($Page->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
        <th data-name="MODIFIED_BY" class="<?= $Page->MODIFIED_BY->headerCellClass() ?>"><div id="elh_GOOD_MUTATION_MODIFIED_BY" class="GOOD_MUTATION_MODIFIED_BY"><?= $Page->renderSort($Page->MODIFIED_BY) ?></div></th>
<?php } ?>
<?php if ($Page->STOCK_OPNAME->Visible) { // STOCK_OPNAME ?>
        <th data-name="STOCK_OPNAME" class="<?= $Page->STOCK_OPNAME->headerCellClass() ?>"><div id="elh_GOOD_MUTATION_STOCK_OPNAME" class="GOOD_MUTATION_STOCK_OPNAME"><?= $Page->renderSort($Page->STOCK_OPNAME) ?></div></th>
<?php } ?>
<?php if ($Page->STOK_AWAL->Visible) { // STOK_AWAL ?>
        <th data-name="STOK_AWAL" class="<?= $Page->STOK_AWAL->headerCellClass() ?>"><div id="elh_GOOD_MUTATION_STOK_AWAL" class="GOOD_MUTATION_STOK_AWAL"><?= $Page->renderSort($Page->STOK_AWAL) ?></div></th>
<?php } ?>
<?php if ($Page->STOCK_LALU->Visible) { // STOCK_LALU ?>
        <th data-name="STOCK_LALU" class="<?= $Page->STOCK_LALU->headerCellClass() ?>"><div id="elh_GOOD_MUTATION_STOCK_LALU" class="GOOD_MUTATION_STOCK_LALU"><?= $Page->renderSort($Page->STOCK_LALU) ?></div></th>
<?php } ?>
<?php if ($Page->STOCK_KOREKSI->Visible) { // STOCK_KOREKSI ?>
        <th data-name="STOCK_KOREKSI" class="<?= $Page->STOCK_KOREKSI->headerCellClass() ?>"><div id="elh_GOOD_MUTATION_STOCK_KOREKSI" class="GOOD_MUTATION_STOCK_KOREKSI"><?= $Page->renderSort($Page->STOCK_KOREKSI) ?></div></th>
<?php } ?>
<?php if ($Page->DITERIMA->Visible) { // DITERIMA ?>
        <th data-name="DITERIMA" class="<?= $Page->DITERIMA->headerCellClass() ?>"><div id="elh_GOOD_MUTATION_DITERIMA" class="GOOD_MUTATION_DITERIMA"><?= $Page->renderSort($Page->DITERIMA) ?></div></th>
<?php } ?>
<?php if ($Page->DISTRIBUSI->Visible) { // DISTRIBUSI ?>
        <th data-name="DISTRIBUSI" class="<?= $Page->DISTRIBUSI->headerCellClass() ?>"><div id="elh_GOOD_MUTATION_DISTRIBUSI" class="GOOD_MUTATION_DISTRIBUSI"><?= $Page->renderSort($Page->DISTRIBUSI) ?></div></th>
<?php } ?>
<?php if ($Page->DIJUAL->Visible) { // DIJUAL ?>
        <th data-name="DIJUAL" class="<?= $Page->DIJUAL->headerCellClass() ?>"><div id="elh_GOOD_MUTATION_DIJUAL" class="GOOD_MUTATION_DIJUAL"><?= $Page->renderSort($Page->DIJUAL) ?></div></th>
<?php } ?>
<?php if ($Page->DIHAPUS->Visible) { // DIHAPUS ?>
        <th data-name="DIHAPUS" class="<?= $Page->DIHAPUS->headerCellClass() ?>"><div id="elh_GOOD_MUTATION_DIHAPUS" class="GOOD_MUTATION_DIHAPUS"><?= $Page->renderSort($Page->DIHAPUS) ?></div></th>
<?php } ?>
<?php if ($Page->DIMINTA->Visible) { // DIMINTA ?>
        <th data-name="DIMINTA" class="<?= $Page->DIMINTA->headerCellClass() ?>"><div id="elh_GOOD_MUTATION_DIMINTA" class="GOOD_MUTATION_DIMINTA"><?= $Page->renderSort($Page->DIMINTA) ?></div></th>
<?php } ?>
<?php if ($Page->DIRETUR->Visible) { // DIRETUR ?>
        <th data-name="DIRETUR" class="<?= $Page->DIRETUR->headerCellClass() ?>"><div id="elh_GOOD_MUTATION_DIRETUR" class="GOOD_MUTATION_DIRETUR"><?= $Page->renderSort($Page->DIRETUR) ?></div></th>
<?php } ?>
<?php if ($Page->PO->Visible) { // PO ?>
        <th data-name="PO" class="<?= $Page->PO->headerCellClass() ?>"><div id="elh_GOOD_MUTATION_PO" class="GOOD_MUTATION_PO"><?= $Page->renderSort($Page->PO) ?></div></th>
<?php } ?>
<?php if ($Page->COMPANY_ID->Visible) { // COMPANY_ID ?>
        <th data-name="COMPANY_ID" class="<?= $Page->COMPANY_ID->headerCellClass() ?>"><div id="elh_GOOD_MUTATION_COMPANY_ID" class="GOOD_MUTATION_COMPANY_ID"><?= $Page->renderSort($Page->COMPANY_ID) ?></div></th>
<?php } ?>
<?php if ($Page->FUND_ID->Visible) { // FUND_ID ?>
        <th data-name="FUND_ID" class="<?= $Page->FUND_ID->headerCellClass() ?>"><div id="elh_GOOD_MUTATION_FUND_ID" class="GOOD_MUTATION_FUND_ID"><?= $Page->renderSort($Page->FUND_ID) ?></div></th>
<?php } ?>
<?php if ($Page->INVOICE_ID2->Visible) { // INVOICE_ID2 ?>
        <th data-name="INVOICE_ID2" class="<?= $Page->INVOICE_ID2->headerCellClass() ?>"><div id="elh_GOOD_MUTATION_INVOICE_ID2" class="GOOD_MUTATION_INVOICE_ID2"><?= $Page->renderSort($Page->INVOICE_ID2) ?></div></th>
<?php } ?>
<?php if ($Page->MEASURE_ID3->Visible) { // MEASURE_ID3 ?>
        <th data-name="MEASURE_ID3" class="<?= $Page->MEASURE_ID3->headerCellClass() ?>"><div id="elh_GOOD_MUTATION_MEASURE_ID3" class="GOOD_MUTATION_MEASURE_ID3"><?= $Page->renderSort($Page->MEASURE_ID3) ?></div></th>
<?php } ?>
<?php if ($Page->SIZE_KEMASAN->Visible) { // SIZE_KEMASAN ?>
        <th data-name="SIZE_KEMASAN" class="<?= $Page->SIZE_KEMASAN->headerCellClass() ?>"><div id="elh_GOOD_MUTATION_SIZE_KEMASAN" class="GOOD_MUTATION_SIZE_KEMASAN"><?= $Page->renderSort($Page->SIZE_KEMASAN) ?></div></th>
<?php } ?>
<?php if ($Page->BRAND_NAME->Visible) { // BRAND_NAME ?>
        <th data-name="BRAND_NAME" class="<?= $Page->BRAND_NAME->headerCellClass() ?>"><div id="elh_GOOD_MUTATION_BRAND_NAME" class="GOOD_MUTATION_BRAND_NAME"><?= $Page->renderSort($Page->BRAND_NAME) ?></div></th>
<?php } ?>
<?php if ($Page->MEASURE_ID2->Visible) { // MEASURE_ID2 ?>
        <th data-name="MEASURE_ID2" class="<?= $Page->MEASURE_ID2->headerCellClass() ?>"><div id="elh_GOOD_MUTATION_MEASURE_ID2" class="GOOD_MUTATION_MEASURE_ID2"><?= $Page->renderSort($Page->MEASURE_ID2) ?></div></th>
<?php } ?>
<?php if ($Page->SIZE_GOODS->Visible) { // SIZE_GOODS ?>
        <th data-name="SIZE_GOODS" class="<?= $Page->SIZE_GOODS->headerCellClass() ?>"><div id="elh_GOOD_MUTATION_SIZE_GOODS" class="GOOD_MUTATION_SIZE_GOODS"><?= $Page->renderSort($Page->SIZE_GOODS) ?></div></th>
<?php } ?>
<?php if ($Page->MEASURE_DOSIS->Visible) { // MEASURE_DOSIS ?>
        <th data-name="MEASURE_DOSIS" class="<?= $Page->MEASURE_DOSIS->headerCellClass() ?>"><div id="elh_GOOD_MUTATION_MEASURE_DOSIS" class="GOOD_MUTATION_MEASURE_DOSIS"><?= $Page->renderSort($Page->MEASURE_DOSIS) ?></div></th>
<?php } ?>
<?php if ($Page->DOC_NO->Visible) { // DOC_NO ?>
        <th data-name="DOC_NO" class="<?= $Page->DOC_NO->headerCellClass() ?>"><div id="elh_GOOD_MUTATION_DOC_NO" class="GOOD_MUTATION_DOC_NO"><?= $Page->renderSort($Page->DOC_NO) ?></div></th>
<?php } ?>
<?php if ($Page->ORDER_PRICE->Visible) { // ORDER_PRICE ?>
        <th data-name="ORDER_PRICE" class="<?= $Page->ORDER_PRICE->headerCellClass() ?>"><div id="elh_GOOD_MUTATION_ORDER_PRICE" class="GOOD_MUTATION_ORDER_PRICE"><?= $Page->renderSort($Page->ORDER_PRICE) ?></div></th>
<?php } ?>
<?php if ($Page->ISCETAK->Visible) { // ISCETAK ?>
        <th data-name="ISCETAK" class="<?= $Page->ISCETAK->headerCellClass() ?>"><div id="elh_GOOD_MUTATION_ISCETAK" class="GOOD_MUTATION_ISCETAK"><?= $Page->renderSort($Page->ISCETAK) ?></div></th>
<?php } ?>
<?php if ($Page->PRINT_DATE->Visible) { // PRINT_DATE ?>
        <th data-name="PRINT_DATE" class="<?= $Page->PRINT_DATE->headerCellClass() ?>"><div id="elh_GOOD_MUTATION_PRINT_DATE" class="GOOD_MUTATION_PRINT_DATE"><?= $Page->renderSort($Page->PRINT_DATE) ?></div></th>
<?php } ?>
<?php if ($Page->PRINTED_BY->Visible) { // PRINTED_BY ?>
        <th data-name="PRINTED_BY" class="<?= $Page->PRINTED_BY->headerCellClass() ?>"><div id="elh_GOOD_MUTATION_PRINTED_BY" class="GOOD_MUTATION_PRINTED_BY"><?= $Page->renderSort($Page->PRINTED_BY) ?></div></th>
<?php } ?>
<?php if ($Page->PRINTQ->Visible) { // PRINTQ ?>
        <th data-name="PRINTQ" class="<?= $Page->PRINTQ->headerCellClass() ?>"><div id="elh_GOOD_MUTATION_PRINTQ" class="GOOD_MUTATION_PRINTQ"><?= $Page->renderSort($Page->PRINTQ) ?></div></th>
<?php } ?>
<?php if ($Page->STOCK_AVAILABLE->Visible) { // STOCK_AVAILABLE ?>
        <th data-name="STOCK_AVAILABLE" class="<?= $Page->STOCK_AVAILABLE->headerCellClass() ?>"><div id="elh_GOOD_MUTATION_STOCK_AVAILABLE" class="GOOD_MUTATION_STOCK_AVAILABLE"><?= $Page->renderSort($Page->STOCK_AVAILABLE) ?></div></th>
<?php } ?>
<?php if ($Page->STATUS_PASIEN_ID->Visible) { // STATUS_PASIEN_ID ?>
        <th data-name="STATUS_PASIEN_ID" class="<?= $Page->STATUS_PASIEN_ID->headerCellClass() ?>"><div id="elh_GOOD_MUTATION_STATUS_PASIEN_ID" class="GOOD_MUTATION_STATUS_PASIEN_ID"><?= $Page->renderSort($Page->STATUS_PASIEN_ID) ?></div></th>
<?php } ?>
<?php if ($Page->MONTH_ID->Visible) { // MONTH_ID ?>
        <th data-name="MONTH_ID" class="<?= $Page->MONTH_ID->headerCellClass() ?>"><div id="elh_GOOD_MUTATION_MONTH_ID" class="GOOD_MUTATION_MONTH_ID"><?= $Page->renderSort($Page->MONTH_ID) ?></div></th>
<?php } ?>
<?php if ($Page->YEAR_ID->Visible) { // YEAR_ID ?>
        <th data-name="YEAR_ID" class="<?= $Page->YEAR_ID->headerCellClass() ?>"><div id="elh_GOOD_MUTATION_YEAR_ID" class="GOOD_MUTATION_YEAR_ID"><?= $Page->renderSort($Page->YEAR_ID) ?></div></th>
<?php } ?>
<?php if ($Page->CORRECTION_DOC->Visible) { // CORRECTION_DOC ?>
        <th data-name="CORRECTION_DOC" class="<?= $Page->CORRECTION_DOC->headerCellClass() ?>"><div id="elh_GOOD_MUTATION_CORRECTION_DOC" class="GOOD_MUTATION_CORRECTION_DOC"><?= $Page->renderSort($Page->CORRECTION_DOC) ?></div></th>
<?php } ?>
<?php if ($Page->CORRECTIONS->Visible) { // CORRECTIONS ?>
        <th data-name="CORRECTIONS" class="<?= $Page->CORRECTIONS->headerCellClass() ?>"><div id="elh_GOOD_MUTATION_CORRECTIONS" class="GOOD_MUTATION_CORRECTIONS"><?= $Page->renderSort($Page->CORRECTIONS) ?></div></th>
<?php } ?>
<?php if ($Page->CORRECTION_DATE->Visible) { // CORRECTION_DATE ?>
        <th data-name="CORRECTION_DATE" class="<?= $Page->CORRECTION_DATE->headerCellClass() ?>"><div id="elh_GOOD_MUTATION_CORRECTION_DATE" class="GOOD_MUTATION_CORRECTION_DATE"><?= $Page->renderSort($Page->CORRECTION_DATE) ?></div></th>
<?php } ?>
<?php if ($Page->DISCOUNT->Visible) { // DISCOUNT ?>
        <th data-name="DISCOUNT" class="<?= $Page->DISCOUNT->headerCellClass() ?>"><div id="elh_GOOD_MUTATION_DISCOUNT" class="GOOD_MUTATION_DISCOUNT"><?= $Page->renderSort($Page->DISCOUNT) ?></div></th>
<?php } ?>
<?php if ($Page->DISCOUNT2->Visible) { // DISCOUNT2 ?>
        <th data-name="DISCOUNT2" class="<?= $Page->DISCOUNT2->headerCellClass() ?>"><div id="elh_GOOD_MUTATION_DISCOUNT2" class="GOOD_MUTATION_DISCOUNT2"><?= $Page->renderSort($Page->DISCOUNT2) ?></div></th>
<?php } ?>
<?php if ($Page->ORG_UNIT_FROM->Visible) { // ORG_UNIT_FROM ?>
        <th data-name="ORG_UNIT_FROM" class="<?= $Page->ORG_UNIT_FROM->headerCellClass() ?>"><div id="elh_GOOD_MUTATION_ORG_UNIT_FROM" class="GOOD_MUTATION_ORG_UNIT_FROM"><?= $Page->renderSort($Page->ORG_UNIT_FROM) ?></div></th>
<?php } ?>
<?php if ($Page->DISCOUNTOFF->Visible) { // DISCOUNTOFF ?>
        <th data-name="DISCOUNTOFF" class="<?= $Page->DISCOUNTOFF->headerCellClass() ?>"><div id="elh_GOOD_MUTATION_DISCOUNTOFF" class="GOOD_MUTATION_DISCOUNTOFF"><?= $Page->renderSort($Page->DISCOUNTOFF) ?></div></th>
<?php } ?>
<?php if ($Page->avgprice->Visible) { // avgprice ?>
        <th data-name="avgprice" class="<?= $Page->avgprice->headerCellClass() ?>"><div id="elh_GOOD_MUTATION_avgprice" class="GOOD_MUTATION_avgprice"><?= $Page->renderSort($Page->avgprice) ?></div></th>
<?php } ?>
<?php if ($Page->idx->Visible) { // idx ?>
        <th data-name="idx" class="<?= $Page->idx->headerCellClass() ?>"><div id="elh_GOOD_MUTATION_idx" class="GOOD_MUTATION_idx"><?= $Page->renderSort($Page->idx) ?></div></th>
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_GOOD_MUTATION", "data-rowtype" => $Page->RowType]);

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
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_ORG_UNIT_CODE">
<span<?= $Page->ORG_UNIT_CODE->viewAttributes() ?>>
<?= $Page->ORG_UNIT_CODE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ITEM_ID->Visible) { // ITEM_ID ?>
        <td data-name="ITEM_ID" <?= $Page->ITEM_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_ITEM_ID">
<span<?= $Page->ITEM_ID->viewAttributes() ?>>
<?= $Page->ITEM_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ORG_ID->Visible) { // ORG_ID ?>
        <td data-name="ORG_ID" <?= $Page->ORG_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_ORG_ID">
<span<?= $Page->ORG_ID->viewAttributes() ?>>
<?= $Page->ORG_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->RETUR_ID->Visible) { // RETUR_ID ?>
        <td data-name="RETUR_ID" <?= $Page->RETUR_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_RETUR_ID">
<span<?= $Page->RETUR_ID->viewAttributes() ?>>
<?= $Page->RETUR_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ORDER_ID->Visible) { // ORDER_ID ?>
        <td data-name="ORDER_ID" <?= $Page->ORDER_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_ORDER_ID">
<span<?= $Page->ORDER_ID->viewAttributes() ?>>
<?= $Page->ORDER_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->BATCH_NO->Visible) { // BATCH_NO ?>
        <td data-name="BATCH_NO" <?= $Page->BATCH_NO->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_BATCH_NO">
<span<?= $Page->BATCH_NO->viewAttributes() ?>>
<?= $Page->BATCH_NO->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->BRAND_ID->Visible) { // BRAND_ID ?>
        <td data-name="BRAND_ID" <?= $Page->BRAND_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_BRAND_ID">
<span<?= $Page->BRAND_ID->viewAttributes() ?>>
<?= $Page->BRAND_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ROOMS_ID->Visible) { // ROOMS_ID ?>
        <td data-name="ROOMS_ID" <?= $Page->ROOMS_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_ROOMS_ID">
<span<?= $Page->ROOMS_ID->viewAttributes() ?>>
<?= $Page->ROOMS_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->SHELF_NO->Visible) { // SHELF_NO ?>
        <td data-name="SHELF_NO" <?= $Page->SHELF_NO->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_SHELF_NO">
<span<?= $Page->SHELF_NO->viewAttributes() ?>>
<?= $Page->SHELF_NO->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->EXPIRY_DATE->Visible) { // EXPIRY_DATE ?>
        <td data-name="EXPIRY_DATE" <?= $Page->EXPIRY_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_EXPIRY_DATE">
<span<?= $Page->EXPIRY_DATE->viewAttributes() ?>>
<?= $Page->EXPIRY_DATE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->SERIAL_NB->Visible) { // SERIAL_NB ?>
        <td data-name="SERIAL_NB" <?= $Page->SERIAL_NB->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_SERIAL_NB">
<span<?= $Page->SERIAL_NB->viewAttributes() ?>>
<?= $Page->SERIAL_NB->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->FROM_ROOMS_ID->Visible) { // FROM_ROOMS_ID ?>
        <td data-name="FROM_ROOMS_ID" <?= $Page->FROM_ROOMS_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_FROM_ROOMS_ID">
<span<?= $Page->FROM_ROOMS_ID->viewAttributes() ?>>
<?= $Page->FROM_ROOMS_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ISOUTLET->Visible) { // ISOUTLET ?>
        <td data-name="ISOUTLET" <?= $Page->ISOUTLET->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_ISOUTLET">
<span<?= $Page->ISOUTLET->viewAttributes() ?>>
<?= $Page->ISOUTLET->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->QUANTITY->Visible) { // QUANTITY ?>
        <td data-name="QUANTITY" <?= $Page->QUANTITY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_QUANTITY">
<span<?= $Page->QUANTITY->viewAttributes() ?>>
<?= $Page->QUANTITY->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->MEASURE_ID->Visible) { // MEASURE_ID ?>
        <td data-name="MEASURE_ID" <?= $Page->MEASURE_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_MEASURE_ID">
<span<?= $Page->MEASURE_ID->viewAttributes() ?>>
<?= $Page->MEASURE_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->DISTRIBUTION_TYPE->Visible) { // DISTRIBUTION_TYPE ?>
        <td data-name="DISTRIBUTION_TYPE" <?= $Page->DISTRIBUTION_TYPE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_DISTRIBUTION_TYPE">
<span<?= $Page->DISTRIBUTION_TYPE->viewAttributes() ?>>
<?= $Page->DISTRIBUTION_TYPE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->CONDITION->Visible) { // CONDITION ?>
        <td data-name="CONDITION" <?= $Page->CONDITION->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_CONDITION">
<span<?= $Page->CONDITION->viewAttributes() ?>>
<?= $Page->CONDITION->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ALLOCATED_DATE->Visible) { // ALLOCATED_DATE ?>
        <td data-name="ALLOCATED_DATE" <?= $Page->ALLOCATED_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_ALLOCATED_DATE">
<span<?= $Page->ALLOCATED_DATE->viewAttributes() ?>>
<?= $Page->ALLOCATED_DATE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->STOCKOPNAME_DATE->Visible) { // STOCKOPNAME_DATE ?>
        <td data-name="STOCKOPNAME_DATE" <?= $Page->STOCKOPNAME_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_STOCKOPNAME_DATE">
<span<?= $Page->STOCKOPNAME_DATE->viewAttributes() ?>>
<?= $Page->STOCKOPNAME_DATE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->INVOICE_ID->Visible) { // INVOICE_ID ?>
        <td data-name="INVOICE_ID" <?= $Page->INVOICE_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_INVOICE_ID">
<span<?= $Page->INVOICE_ID->viewAttributes() ?>>
<?= $Page->INVOICE_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ALLOCATED_FROM->Visible) { // ALLOCATED_FROM ?>
        <td data-name="ALLOCATED_FROM" <?= $Page->ALLOCATED_FROM->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_ALLOCATED_FROM">
<span<?= $Page->ALLOCATED_FROM->viewAttributes() ?>>
<?= $Page->ALLOCATED_FROM->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PRICE->Visible) { // PRICE ?>
        <td data-name="PRICE" <?= $Page->PRICE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_PRICE">
<span<?= $Page->PRICE->viewAttributes() ?>>
<?= $Page->PRICE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ITEM_ID_FROM->Visible) { // ITEM_ID_FROM ?>
        <td data-name="ITEM_ID_FROM" <?= $Page->ITEM_ID_FROM->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_ITEM_ID_FROM">
<span<?= $Page->ITEM_ID_FROM->viewAttributes() ?>>
<?= $Page->ITEM_ID_FROM->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
        <td data-name="MODIFIED_DATE" <?= $Page->MODIFIED_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_MODIFIED_DATE">
<span<?= $Page->MODIFIED_DATE->viewAttributes() ?>>
<?= $Page->MODIFIED_DATE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
        <td data-name="MODIFIED_BY" <?= $Page->MODIFIED_BY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_MODIFIED_BY">
<span<?= $Page->MODIFIED_BY->viewAttributes() ?>>
<?= $Page->MODIFIED_BY->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->STOCK_OPNAME->Visible) { // STOCK_OPNAME ?>
        <td data-name="STOCK_OPNAME" <?= $Page->STOCK_OPNAME->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_STOCK_OPNAME">
<span<?= $Page->STOCK_OPNAME->viewAttributes() ?>>
<?= $Page->STOCK_OPNAME->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->STOK_AWAL->Visible) { // STOK_AWAL ?>
        <td data-name="STOK_AWAL" <?= $Page->STOK_AWAL->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_STOK_AWAL">
<span<?= $Page->STOK_AWAL->viewAttributes() ?>>
<?= $Page->STOK_AWAL->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->STOCK_LALU->Visible) { // STOCK_LALU ?>
        <td data-name="STOCK_LALU" <?= $Page->STOCK_LALU->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_STOCK_LALU">
<span<?= $Page->STOCK_LALU->viewAttributes() ?>>
<?= $Page->STOCK_LALU->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->STOCK_KOREKSI->Visible) { // STOCK_KOREKSI ?>
        <td data-name="STOCK_KOREKSI" <?= $Page->STOCK_KOREKSI->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_STOCK_KOREKSI">
<span<?= $Page->STOCK_KOREKSI->viewAttributes() ?>>
<?= $Page->STOCK_KOREKSI->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->DITERIMA->Visible) { // DITERIMA ?>
        <td data-name="DITERIMA" <?= $Page->DITERIMA->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_DITERIMA">
<span<?= $Page->DITERIMA->viewAttributes() ?>>
<?= $Page->DITERIMA->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->DISTRIBUSI->Visible) { // DISTRIBUSI ?>
        <td data-name="DISTRIBUSI" <?= $Page->DISTRIBUSI->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_DISTRIBUSI">
<span<?= $Page->DISTRIBUSI->viewAttributes() ?>>
<?= $Page->DISTRIBUSI->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->DIJUAL->Visible) { // DIJUAL ?>
        <td data-name="DIJUAL" <?= $Page->DIJUAL->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_DIJUAL">
<span<?= $Page->DIJUAL->viewAttributes() ?>>
<?= $Page->DIJUAL->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->DIHAPUS->Visible) { // DIHAPUS ?>
        <td data-name="DIHAPUS" <?= $Page->DIHAPUS->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_DIHAPUS">
<span<?= $Page->DIHAPUS->viewAttributes() ?>>
<?= $Page->DIHAPUS->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->DIMINTA->Visible) { // DIMINTA ?>
        <td data-name="DIMINTA" <?= $Page->DIMINTA->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_DIMINTA">
<span<?= $Page->DIMINTA->viewAttributes() ?>>
<?= $Page->DIMINTA->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->DIRETUR->Visible) { // DIRETUR ?>
        <td data-name="DIRETUR" <?= $Page->DIRETUR->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_DIRETUR">
<span<?= $Page->DIRETUR->viewAttributes() ?>>
<?= $Page->DIRETUR->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PO->Visible) { // PO ?>
        <td data-name="PO" <?= $Page->PO->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_PO">
<span<?= $Page->PO->viewAttributes() ?>>
<?= $Page->PO->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->COMPANY_ID->Visible) { // COMPANY_ID ?>
        <td data-name="COMPANY_ID" <?= $Page->COMPANY_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_COMPANY_ID">
<span<?= $Page->COMPANY_ID->viewAttributes() ?>>
<?= $Page->COMPANY_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->FUND_ID->Visible) { // FUND_ID ?>
        <td data-name="FUND_ID" <?= $Page->FUND_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_FUND_ID">
<span<?= $Page->FUND_ID->viewAttributes() ?>>
<?= $Page->FUND_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->INVOICE_ID2->Visible) { // INVOICE_ID2 ?>
        <td data-name="INVOICE_ID2" <?= $Page->INVOICE_ID2->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_INVOICE_ID2">
<span<?= $Page->INVOICE_ID2->viewAttributes() ?>>
<?= $Page->INVOICE_ID2->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->MEASURE_ID3->Visible) { // MEASURE_ID3 ?>
        <td data-name="MEASURE_ID3" <?= $Page->MEASURE_ID3->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_MEASURE_ID3">
<span<?= $Page->MEASURE_ID3->viewAttributes() ?>>
<?= $Page->MEASURE_ID3->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->SIZE_KEMASAN->Visible) { // SIZE_KEMASAN ?>
        <td data-name="SIZE_KEMASAN" <?= $Page->SIZE_KEMASAN->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_SIZE_KEMASAN">
<span<?= $Page->SIZE_KEMASAN->viewAttributes() ?>>
<?= $Page->SIZE_KEMASAN->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->BRAND_NAME->Visible) { // BRAND_NAME ?>
        <td data-name="BRAND_NAME" <?= $Page->BRAND_NAME->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_BRAND_NAME">
<span<?= $Page->BRAND_NAME->viewAttributes() ?>>
<?= $Page->BRAND_NAME->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->MEASURE_ID2->Visible) { // MEASURE_ID2 ?>
        <td data-name="MEASURE_ID2" <?= $Page->MEASURE_ID2->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_MEASURE_ID2">
<span<?= $Page->MEASURE_ID2->viewAttributes() ?>>
<?= $Page->MEASURE_ID2->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->SIZE_GOODS->Visible) { // SIZE_GOODS ?>
        <td data-name="SIZE_GOODS" <?= $Page->SIZE_GOODS->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_SIZE_GOODS">
<span<?= $Page->SIZE_GOODS->viewAttributes() ?>>
<?= $Page->SIZE_GOODS->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->MEASURE_DOSIS->Visible) { // MEASURE_DOSIS ?>
        <td data-name="MEASURE_DOSIS" <?= $Page->MEASURE_DOSIS->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_MEASURE_DOSIS">
<span<?= $Page->MEASURE_DOSIS->viewAttributes() ?>>
<?= $Page->MEASURE_DOSIS->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->DOC_NO->Visible) { // DOC_NO ?>
        <td data-name="DOC_NO" <?= $Page->DOC_NO->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_DOC_NO">
<span<?= $Page->DOC_NO->viewAttributes() ?>>
<?= $Page->DOC_NO->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ORDER_PRICE->Visible) { // ORDER_PRICE ?>
        <td data-name="ORDER_PRICE" <?= $Page->ORDER_PRICE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_ORDER_PRICE">
<span<?= $Page->ORDER_PRICE->viewAttributes() ?>>
<?= $Page->ORDER_PRICE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ISCETAK->Visible) { // ISCETAK ?>
        <td data-name="ISCETAK" <?= $Page->ISCETAK->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_ISCETAK">
<span<?= $Page->ISCETAK->viewAttributes() ?>>
<?= $Page->ISCETAK->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PRINT_DATE->Visible) { // PRINT_DATE ?>
        <td data-name="PRINT_DATE" <?= $Page->PRINT_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_PRINT_DATE">
<span<?= $Page->PRINT_DATE->viewAttributes() ?>>
<?= $Page->PRINT_DATE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PRINTED_BY->Visible) { // PRINTED_BY ?>
        <td data-name="PRINTED_BY" <?= $Page->PRINTED_BY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_PRINTED_BY">
<span<?= $Page->PRINTED_BY->viewAttributes() ?>>
<?= $Page->PRINTED_BY->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PRINTQ->Visible) { // PRINTQ ?>
        <td data-name="PRINTQ" <?= $Page->PRINTQ->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_PRINTQ">
<span<?= $Page->PRINTQ->viewAttributes() ?>>
<?= $Page->PRINTQ->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->STOCK_AVAILABLE->Visible) { // STOCK_AVAILABLE ?>
        <td data-name="STOCK_AVAILABLE" <?= $Page->STOCK_AVAILABLE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_STOCK_AVAILABLE">
<span<?= $Page->STOCK_AVAILABLE->viewAttributes() ?>>
<?= $Page->STOCK_AVAILABLE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->STATUS_PASIEN_ID->Visible) { // STATUS_PASIEN_ID ?>
        <td data-name="STATUS_PASIEN_ID" <?= $Page->STATUS_PASIEN_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_STATUS_PASIEN_ID">
<span<?= $Page->STATUS_PASIEN_ID->viewAttributes() ?>>
<?= $Page->STATUS_PASIEN_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->MONTH_ID->Visible) { // MONTH_ID ?>
        <td data-name="MONTH_ID" <?= $Page->MONTH_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_MONTH_ID">
<span<?= $Page->MONTH_ID->viewAttributes() ?>>
<?= $Page->MONTH_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->YEAR_ID->Visible) { // YEAR_ID ?>
        <td data-name="YEAR_ID" <?= $Page->YEAR_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_YEAR_ID">
<span<?= $Page->YEAR_ID->viewAttributes() ?>>
<?= $Page->YEAR_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->CORRECTION_DOC->Visible) { // CORRECTION_DOC ?>
        <td data-name="CORRECTION_DOC" <?= $Page->CORRECTION_DOC->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_CORRECTION_DOC">
<span<?= $Page->CORRECTION_DOC->viewAttributes() ?>>
<?= $Page->CORRECTION_DOC->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->CORRECTIONS->Visible) { // CORRECTIONS ?>
        <td data-name="CORRECTIONS" <?= $Page->CORRECTIONS->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_CORRECTIONS">
<span<?= $Page->CORRECTIONS->viewAttributes() ?>>
<?= $Page->CORRECTIONS->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->CORRECTION_DATE->Visible) { // CORRECTION_DATE ?>
        <td data-name="CORRECTION_DATE" <?= $Page->CORRECTION_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_CORRECTION_DATE">
<span<?= $Page->CORRECTION_DATE->viewAttributes() ?>>
<?= $Page->CORRECTION_DATE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->DISCOUNT->Visible) { // DISCOUNT ?>
        <td data-name="DISCOUNT" <?= $Page->DISCOUNT->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_DISCOUNT">
<span<?= $Page->DISCOUNT->viewAttributes() ?>>
<?= $Page->DISCOUNT->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->DISCOUNT2->Visible) { // DISCOUNT2 ?>
        <td data-name="DISCOUNT2" <?= $Page->DISCOUNT2->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_DISCOUNT2">
<span<?= $Page->DISCOUNT2->viewAttributes() ?>>
<?= $Page->DISCOUNT2->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ORG_UNIT_FROM->Visible) { // ORG_UNIT_FROM ?>
        <td data-name="ORG_UNIT_FROM" <?= $Page->ORG_UNIT_FROM->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_ORG_UNIT_FROM">
<span<?= $Page->ORG_UNIT_FROM->viewAttributes() ?>>
<?= $Page->ORG_UNIT_FROM->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->DISCOUNTOFF->Visible) { // DISCOUNTOFF ?>
        <td data-name="DISCOUNTOFF" <?= $Page->DISCOUNTOFF->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_DISCOUNTOFF">
<span<?= $Page->DISCOUNTOFF->viewAttributes() ?>>
<?= $Page->DISCOUNTOFF->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->avgprice->Visible) { // avgprice ?>
        <td data-name="avgprice" <?= $Page->avgprice->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_avgprice">
<span<?= $Page->avgprice->viewAttributes() ?>>
<?= $Page->avgprice->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->idx->Visible) { // idx ?>
        <td data-name="idx" <?= $Page->idx->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_idx">
<span<?= $Page->idx->viewAttributes() ?>>
<?= $Page->idx->getViewValue() ?></span>
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
    ew.addEventHandlers("GOOD_MUTATION");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
