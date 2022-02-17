<?php

namespace PHPMaker2021\SIMRSSQLSERVERGUDANGFARMASI;

// Page object
$PoItemList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fPO_ITEMlist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fPO_ITEMlist = currentForm = new ew.Form("fPO_ITEMlist", "list");
    fPO_ITEMlist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("fPO_ITEMlist");
});
var fPO_ITEMlistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    fPO_ITEMlistsrch = currentSearchForm = new ew.Form("fPO_ITEMlistsrch");

    // Dynamic selection lists

    // Filters
    fPO_ITEMlistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fPO_ITEMlistsrch");
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
<form name="fPO_ITEMlistsrch" id="fPO_ITEMlistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fPO_ITEMlistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="PO_ITEM">
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> PO_ITEM">
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
<form name="fPO_ITEMlist" id="fPO_ITEMlist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="PO_ITEM">
<div id="gmp_PO_ITEM" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_PO_ITEMlist" class="table ew-table"><!-- .ew-table -->
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
        <th data-name="ORG_UNIT_CODE" class="<?= $Page->ORG_UNIT_CODE->headerCellClass() ?>"><div id="elh_PO_ITEM_ORG_UNIT_CODE" class="PO_ITEM_ORG_UNIT_CODE"><?= $Page->renderSort($Page->ORG_UNIT_CODE) ?></div></th>
<?php } ?>
<?php if ($Page->PO->Visible) { // PO ?>
        <th data-name="PO" class="<?= $Page->PO->headerCellClass() ?>"><div id="elh_PO_ITEM_PO" class="PO_ITEM_PO"><?= $Page->renderSort($Page->PO) ?></div></th>
<?php } ?>
<?php if ($Page->BRAND_ID->Visible) { // BRAND_ID ?>
        <th data-name="BRAND_ID" class="<?= $Page->BRAND_ID->headerCellClass() ?>"><div id="elh_PO_ITEM_BRAND_ID" class="PO_ITEM_BRAND_ID"><?= $Page->renderSort($Page->BRAND_ID) ?></div></th>
<?php } ?>
<?php if ($Page->ORDER_DATE->Visible) { // ORDER_DATE ?>
        <th data-name="ORDER_DATE" class="<?= $Page->ORDER_DATE->headerCellClass() ?>"><div id="elh_PO_ITEM_ORDER_DATE" class="PO_ITEM_ORDER_DATE"><?= $Page->renderSort($Page->ORDER_DATE) ?></div></th>
<?php } ?>
<?php if ($Page->PO_NO->Visible) { // PO_NO ?>
        <th data-name="PO_NO" class="<?= $Page->PO_NO->headerCellClass() ?>"><div id="elh_PO_ITEM_PO_NO" class="PO_ITEM_PO_NO"><?= $Page->renderSort($Page->PO_NO) ?></div></th>
<?php } ?>
<?php if ($Page->PURCHASE_PRICE->Visible) { // PURCHASE_PRICE ?>
        <th data-name="PURCHASE_PRICE" class="<?= $Page->PURCHASE_PRICE->headerCellClass() ?>"><div id="elh_PO_ITEM_PURCHASE_PRICE" class="PO_ITEM_PURCHASE_PRICE"><?= $Page->renderSort($Page->PURCHASE_PRICE) ?></div></th>
<?php } ?>
<?php if ($Page->ORDER_QUANTITY->Visible) { // ORDER_QUANTITY ?>
        <th data-name="ORDER_QUANTITY" class="<?= $Page->ORDER_QUANTITY->headerCellClass() ?>"><div id="elh_PO_ITEM_ORDER_QUANTITY" class="PO_ITEM_ORDER_QUANTITY"><?= $Page->renderSort($Page->ORDER_QUANTITY) ?></div></th>
<?php } ?>
<?php if ($Page->RECEIVED_QUANTITY->Visible) { // RECEIVED_QUANTITY ?>
        <th data-name="RECEIVED_QUANTITY" class="<?= $Page->RECEIVED_QUANTITY->headerCellClass() ?>"><div id="elh_PO_ITEM_RECEIVED_QUANTITY" class="PO_ITEM_RECEIVED_QUANTITY"><?= $Page->renderSort($Page->RECEIVED_QUANTITY) ?></div></th>
<?php } ?>
<?php if ($Page->MEASURE_ID->Visible) { // MEASURE_ID ?>
        <th data-name="MEASURE_ID" class="<?= $Page->MEASURE_ID->headerCellClass() ?>"><div id="elh_PO_ITEM_MEASURE_ID" class="PO_ITEM_MEASURE_ID"><?= $Page->renderSort($Page->MEASURE_ID) ?></div></th>
<?php } ?>
<?php if ($Page->DISCOUNT->Visible) { // DISCOUNT ?>
        <th data-name="DISCOUNT" class="<?= $Page->DISCOUNT->headerCellClass() ?>"><div id="elh_PO_ITEM_DISCOUNT" class="PO_ITEM_DISCOUNT"><?= $Page->renderSort($Page->DISCOUNT) ?></div></th>
<?php } ?>
<?php if ($Page->AMOUNT_PAID->Visible) { // AMOUNT_PAID ?>
        <th data-name="AMOUNT_PAID" class="<?= $Page->AMOUNT_PAID->headerCellClass() ?>"><div id="elh_PO_ITEM_AMOUNT_PAID" class="PO_ITEM_AMOUNT_PAID"><?= $Page->renderSort($Page->AMOUNT_PAID) ?></div></th>
<?php } ?>
<?php if ($Page->ATP_DATE->Visible) { // ATP_DATE ?>
        <th data-name="ATP_DATE" class="<?= $Page->ATP_DATE->headerCellClass() ?>"><div id="elh_PO_ITEM_ATP_DATE" class="PO_ITEM_ATP_DATE"><?= $Page->renderSort($Page->ATP_DATE) ?></div></th>
<?php } ?>
<?php if ($Page->DELIVERY_DATE->Visible) { // DELIVERY_DATE ?>
        <th data-name="DELIVERY_DATE" class="<?= $Page->DELIVERY_DATE->headerCellClass() ?>"><div id="elh_PO_ITEM_DELIVERY_DATE" class="PO_ITEM_DELIVERY_DATE"><?= $Page->renderSort($Page->DELIVERY_DATE) ?></div></th>
<?php } ?>
<?php if ($Page->DESCRIPTION->Visible) { // DESCRIPTION ?>
        <th data-name="DESCRIPTION" class="<?= $Page->DESCRIPTION->headerCellClass() ?>"><div id="elh_PO_ITEM_DESCRIPTION" class="PO_ITEM_DESCRIPTION"><?= $Page->renderSort($Page->DESCRIPTION) ?></div></th>
<?php } ?>
<?php if ($Page->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
        <th data-name="MODIFIED_DATE" class="<?= $Page->MODIFIED_DATE->headerCellClass() ?>"><div id="elh_PO_ITEM_MODIFIED_DATE" class="PO_ITEM_MODIFIED_DATE"><?= $Page->renderSort($Page->MODIFIED_DATE) ?></div></th>
<?php } ?>
<?php if ($Page->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
        <th data-name="MODIFIED_BY" class="<?= $Page->MODIFIED_BY->headerCellClass() ?>"><div id="elh_PO_ITEM_MODIFIED_BY" class="PO_ITEM_MODIFIED_BY"><?= $Page->renderSort($Page->MODIFIED_BY) ?></div></th>
<?php } ?>
<?php if ($Page->company_id->Visible) { // company_id ?>
        <th data-name="company_id" class="<?= $Page->company_id->headerCellClass() ?>"><div id="elh_PO_ITEM_company_id" class="PO_ITEM_company_id"><?= $Page->renderSort($Page->company_id) ?></div></th>
<?php } ?>
<?php if ($Page->SIZE_KEMASAN->Visible) { // SIZE_KEMASAN ?>
        <th data-name="SIZE_KEMASAN" class="<?= $Page->SIZE_KEMASAN->headerCellClass() ?>"><div id="elh_PO_ITEM_SIZE_KEMASAN" class="PO_ITEM_SIZE_KEMASAN"><?= $Page->renderSort($Page->SIZE_KEMASAN) ?></div></th>
<?php } ?>
<?php if ($Page->MEASURE_ID2->Visible) { // MEASURE_ID2 ?>
        <th data-name="MEASURE_ID2" class="<?= $Page->MEASURE_ID2->headerCellClass() ?>"><div id="elh_PO_ITEM_MEASURE_ID2" class="PO_ITEM_MEASURE_ID2"><?= $Page->renderSort($Page->MEASURE_ID2) ?></div></th>
<?php } ?>
<?php if ($Page->SIZE_GOODS->Visible) { // SIZE_GOODS ?>
        <th data-name="SIZE_GOODS" class="<?= $Page->SIZE_GOODS->headerCellClass() ?>"><div id="elh_PO_ITEM_SIZE_GOODS" class="PO_ITEM_SIZE_GOODS"><?= $Page->renderSort($Page->SIZE_GOODS) ?></div></th>
<?php } ?>
<?php if ($Page->MEASURE_DOSIS->Visible) { // MEASURE_DOSIS ?>
        <th data-name="MEASURE_DOSIS" class="<?= $Page->MEASURE_DOSIS->headerCellClass() ?>"><div id="elh_PO_ITEM_MEASURE_DOSIS" class="PO_ITEM_MEASURE_DOSIS"><?= $Page->renderSort($Page->MEASURE_DOSIS) ?></div></th>
<?php } ?>
<?php if ($Page->QUANTITY->Visible) { // QUANTITY ?>
        <th data-name="QUANTITY" class="<?= $Page->QUANTITY->headerCellClass() ?>"><div id="elh_PO_ITEM_QUANTITY" class="PO_ITEM_QUANTITY"><?= $Page->renderSort($Page->QUANTITY) ?></div></th>
<?php } ?>
<?php if ($Page->MEASURE_ID3->Visible) { // MEASURE_ID3 ?>
        <th data-name="MEASURE_ID3" class="<?= $Page->MEASURE_ID3->headerCellClass() ?>"><div id="elh_PO_ITEM_MEASURE_ID3" class="PO_ITEM_MEASURE_ID3"><?= $Page->renderSort($Page->MEASURE_ID3) ?></div></th>
<?php } ?>
<?php if ($Page->ORDER_PRICE->Visible) { // ORDER_PRICE ?>
        <th data-name="ORDER_PRICE" class="<?= $Page->ORDER_PRICE->headerCellClass() ?>"><div id="elh_PO_ITEM_ORDER_PRICE" class="PO_ITEM_ORDER_PRICE"><?= $Page->renderSort($Page->ORDER_PRICE) ?></div></th>
<?php } ?>
<?php if ($Page->BRAND_NAME->Visible) { // BRAND_NAME ?>
        <th data-name="BRAND_NAME" class="<?= $Page->BRAND_NAME->headerCellClass() ?>"><div id="elh_PO_ITEM_BRAND_NAME" class="PO_ITEM_BRAND_NAME"><?= $Page->renderSort($Page->BRAND_NAME) ?></div></th>
<?php } ?>
<?php if ($Page->ISCETAK->Visible) { // ISCETAK ?>
        <th data-name="ISCETAK" class="<?= $Page->ISCETAK->headerCellClass() ?>"><div id="elh_PO_ITEM_ISCETAK" class="PO_ITEM_ISCETAK"><?= $Page->renderSort($Page->ISCETAK) ?></div></th>
<?php } ?>
<?php if ($Page->PRINT_DATE->Visible) { // PRINT_DATE ?>
        <th data-name="PRINT_DATE" class="<?= $Page->PRINT_DATE->headerCellClass() ?>"><div id="elh_PO_ITEM_PRINT_DATE" class="PO_ITEM_PRINT_DATE"><?= $Page->renderSort($Page->PRINT_DATE) ?></div></th>
<?php } ?>
<?php if ($Page->PRINTED_BY->Visible) { // PRINTED_BY ?>
        <th data-name="PRINTED_BY" class="<?= $Page->PRINTED_BY->headerCellClass() ?>"><div id="elh_PO_ITEM_PRINTED_BY" class="PO_ITEM_PRINTED_BY"><?= $Page->renderSort($Page->PRINTED_BY) ?></div></th>
<?php } ?>
<?php if ($Page->PRINTQ->Visible) { // PRINTQ ?>
        <th data-name="PRINTQ" class="<?= $Page->PRINTQ->headerCellClass() ?>"><div id="elh_PO_ITEM_PRINTQ" class="PO_ITEM_PRINTQ"><?= $Page->renderSort($Page->PRINTQ) ?></div></th>
<?php } ?>
<?php if ($Page->DISCOUNTOFF->Visible) { // DISCOUNTOFF ?>
        <th data-name="DISCOUNTOFF" class="<?= $Page->DISCOUNTOFF->headerCellClass() ?>"><div id="elh_PO_ITEM_DISCOUNTOFF" class="PO_ITEM_DISCOUNTOFF"><?= $Page->renderSort($Page->DISCOUNTOFF) ?></div></th>
<?php } ?>
<?php if ($Page->IDX->Visible) { // IDX ?>
        <th data-name="IDX" class="<?= $Page->IDX->headerCellClass() ?>"><div id="elh_PO_ITEM_IDX" class="PO_ITEM_IDX"><?= $Page->renderSort($Page->IDX) ?></div></th>
<?php } ?>
<?php if ($Page->QUANTITY0->Visible) { // QUANTITY0 ?>
        <th data-name="QUANTITY0" class="<?= $Page->QUANTITY0->headerCellClass() ?>"><div id="elh_PO_ITEM_QUANTITY0" class="PO_ITEM_QUANTITY0"><?= $Page->renderSort($Page->QUANTITY0) ?></div></th>
<?php } ?>
<?php if ($Page->PROPOSEDQ->Visible) { // PROPOSEDQ ?>
        <th data-name="PROPOSEDQ" class="<?= $Page->PROPOSEDQ->headerCellClass() ?>"><div id="elh_PO_ITEM_PROPOSEDQ" class="PO_ITEM_PROPOSEDQ"><?= $Page->renderSort($Page->PROPOSEDQ) ?></div></th>
<?php } ?>
<?php if ($Page->STOCKQ->Visible) { // STOCKQ ?>
        <th data-name="STOCKQ" class="<?= $Page->STOCKQ->headerCellClass() ?>"><div id="elh_PO_ITEM_STOCKQ" class="PO_ITEM_STOCKQ"><?= $Page->renderSort($Page->STOCKQ) ?></div></th>
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_PO_ITEM", "data-rowtype" => $Page->RowType]);

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
<span id="el<?= $Page->RowCount ?>_PO_ITEM_ORG_UNIT_CODE">
<span<?= $Page->ORG_UNIT_CODE->viewAttributes() ?>>
<?= $Page->ORG_UNIT_CODE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PO->Visible) { // PO ?>
        <td data-name="PO" <?= $Page->PO->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_ITEM_PO">
<span<?= $Page->PO->viewAttributes() ?>>
<?= $Page->PO->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->BRAND_ID->Visible) { // BRAND_ID ?>
        <td data-name="BRAND_ID" <?= $Page->BRAND_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_ITEM_BRAND_ID">
<span<?= $Page->BRAND_ID->viewAttributes() ?>>
<?= $Page->BRAND_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ORDER_DATE->Visible) { // ORDER_DATE ?>
        <td data-name="ORDER_DATE" <?= $Page->ORDER_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_ITEM_ORDER_DATE">
<span<?= $Page->ORDER_DATE->viewAttributes() ?>>
<?= $Page->ORDER_DATE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PO_NO->Visible) { // PO_NO ?>
        <td data-name="PO_NO" <?= $Page->PO_NO->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_ITEM_PO_NO">
<span<?= $Page->PO_NO->viewAttributes() ?>>
<?= $Page->PO_NO->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PURCHASE_PRICE->Visible) { // PURCHASE_PRICE ?>
        <td data-name="PURCHASE_PRICE" <?= $Page->PURCHASE_PRICE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_ITEM_PURCHASE_PRICE">
<span<?= $Page->PURCHASE_PRICE->viewAttributes() ?>>
<?= $Page->PURCHASE_PRICE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ORDER_QUANTITY->Visible) { // ORDER_QUANTITY ?>
        <td data-name="ORDER_QUANTITY" <?= $Page->ORDER_QUANTITY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_ITEM_ORDER_QUANTITY">
<span<?= $Page->ORDER_QUANTITY->viewAttributes() ?>>
<?= $Page->ORDER_QUANTITY->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->RECEIVED_QUANTITY->Visible) { // RECEIVED_QUANTITY ?>
        <td data-name="RECEIVED_QUANTITY" <?= $Page->RECEIVED_QUANTITY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_ITEM_RECEIVED_QUANTITY">
<span<?= $Page->RECEIVED_QUANTITY->viewAttributes() ?>>
<?= $Page->RECEIVED_QUANTITY->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->MEASURE_ID->Visible) { // MEASURE_ID ?>
        <td data-name="MEASURE_ID" <?= $Page->MEASURE_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_ITEM_MEASURE_ID">
<span<?= $Page->MEASURE_ID->viewAttributes() ?>>
<?= $Page->MEASURE_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->DISCOUNT->Visible) { // DISCOUNT ?>
        <td data-name="DISCOUNT" <?= $Page->DISCOUNT->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_ITEM_DISCOUNT">
<span<?= $Page->DISCOUNT->viewAttributes() ?>>
<?= $Page->DISCOUNT->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->AMOUNT_PAID->Visible) { // AMOUNT_PAID ?>
        <td data-name="AMOUNT_PAID" <?= $Page->AMOUNT_PAID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_ITEM_AMOUNT_PAID">
<span<?= $Page->AMOUNT_PAID->viewAttributes() ?>>
<?= $Page->AMOUNT_PAID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ATP_DATE->Visible) { // ATP_DATE ?>
        <td data-name="ATP_DATE" <?= $Page->ATP_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_ITEM_ATP_DATE">
<span<?= $Page->ATP_DATE->viewAttributes() ?>>
<?= $Page->ATP_DATE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->DELIVERY_DATE->Visible) { // DELIVERY_DATE ?>
        <td data-name="DELIVERY_DATE" <?= $Page->DELIVERY_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_ITEM_DELIVERY_DATE">
<span<?= $Page->DELIVERY_DATE->viewAttributes() ?>>
<?= $Page->DELIVERY_DATE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->DESCRIPTION->Visible) { // DESCRIPTION ?>
        <td data-name="DESCRIPTION" <?= $Page->DESCRIPTION->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_ITEM_DESCRIPTION">
<span<?= $Page->DESCRIPTION->viewAttributes() ?>>
<?= $Page->DESCRIPTION->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
        <td data-name="MODIFIED_DATE" <?= $Page->MODIFIED_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_ITEM_MODIFIED_DATE">
<span<?= $Page->MODIFIED_DATE->viewAttributes() ?>>
<?= $Page->MODIFIED_DATE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
        <td data-name="MODIFIED_BY" <?= $Page->MODIFIED_BY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_ITEM_MODIFIED_BY">
<span<?= $Page->MODIFIED_BY->viewAttributes() ?>>
<?= $Page->MODIFIED_BY->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->company_id->Visible) { // company_id ?>
        <td data-name="company_id" <?= $Page->company_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_ITEM_company_id">
<span<?= $Page->company_id->viewAttributes() ?>>
<?= $Page->company_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->SIZE_KEMASAN->Visible) { // SIZE_KEMASAN ?>
        <td data-name="SIZE_KEMASAN" <?= $Page->SIZE_KEMASAN->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_ITEM_SIZE_KEMASAN">
<span<?= $Page->SIZE_KEMASAN->viewAttributes() ?>>
<?= $Page->SIZE_KEMASAN->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->MEASURE_ID2->Visible) { // MEASURE_ID2 ?>
        <td data-name="MEASURE_ID2" <?= $Page->MEASURE_ID2->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_ITEM_MEASURE_ID2">
<span<?= $Page->MEASURE_ID2->viewAttributes() ?>>
<?= $Page->MEASURE_ID2->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->SIZE_GOODS->Visible) { // SIZE_GOODS ?>
        <td data-name="SIZE_GOODS" <?= $Page->SIZE_GOODS->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_ITEM_SIZE_GOODS">
<span<?= $Page->SIZE_GOODS->viewAttributes() ?>>
<?= $Page->SIZE_GOODS->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->MEASURE_DOSIS->Visible) { // MEASURE_DOSIS ?>
        <td data-name="MEASURE_DOSIS" <?= $Page->MEASURE_DOSIS->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_ITEM_MEASURE_DOSIS">
<span<?= $Page->MEASURE_DOSIS->viewAttributes() ?>>
<?= $Page->MEASURE_DOSIS->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->QUANTITY->Visible) { // QUANTITY ?>
        <td data-name="QUANTITY" <?= $Page->QUANTITY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_ITEM_QUANTITY">
<span<?= $Page->QUANTITY->viewAttributes() ?>>
<?= $Page->QUANTITY->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->MEASURE_ID3->Visible) { // MEASURE_ID3 ?>
        <td data-name="MEASURE_ID3" <?= $Page->MEASURE_ID3->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_ITEM_MEASURE_ID3">
<span<?= $Page->MEASURE_ID3->viewAttributes() ?>>
<?= $Page->MEASURE_ID3->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ORDER_PRICE->Visible) { // ORDER_PRICE ?>
        <td data-name="ORDER_PRICE" <?= $Page->ORDER_PRICE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_ITEM_ORDER_PRICE">
<span<?= $Page->ORDER_PRICE->viewAttributes() ?>>
<?= $Page->ORDER_PRICE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->BRAND_NAME->Visible) { // BRAND_NAME ?>
        <td data-name="BRAND_NAME" <?= $Page->BRAND_NAME->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_ITEM_BRAND_NAME">
<span<?= $Page->BRAND_NAME->viewAttributes() ?>>
<?= $Page->BRAND_NAME->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ISCETAK->Visible) { // ISCETAK ?>
        <td data-name="ISCETAK" <?= $Page->ISCETAK->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_ITEM_ISCETAK">
<span<?= $Page->ISCETAK->viewAttributes() ?>>
<?= $Page->ISCETAK->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PRINT_DATE->Visible) { // PRINT_DATE ?>
        <td data-name="PRINT_DATE" <?= $Page->PRINT_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_ITEM_PRINT_DATE">
<span<?= $Page->PRINT_DATE->viewAttributes() ?>>
<?= $Page->PRINT_DATE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PRINTED_BY->Visible) { // PRINTED_BY ?>
        <td data-name="PRINTED_BY" <?= $Page->PRINTED_BY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_ITEM_PRINTED_BY">
<span<?= $Page->PRINTED_BY->viewAttributes() ?>>
<?= $Page->PRINTED_BY->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PRINTQ->Visible) { // PRINTQ ?>
        <td data-name="PRINTQ" <?= $Page->PRINTQ->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_ITEM_PRINTQ">
<span<?= $Page->PRINTQ->viewAttributes() ?>>
<?= $Page->PRINTQ->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->DISCOUNTOFF->Visible) { // DISCOUNTOFF ?>
        <td data-name="DISCOUNTOFF" <?= $Page->DISCOUNTOFF->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_ITEM_DISCOUNTOFF">
<span<?= $Page->DISCOUNTOFF->viewAttributes() ?>>
<?= $Page->DISCOUNTOFF->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->IDX->Visible) { // IDX ?>
        <td data-name="IDX" <?= $Page->IDX->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_ITEM_IDX">
<span<?= $Page->IDX->viewAttributes() ?>>
<?= $Page->IDX->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->QUANTITY0->Visible) { // QUANTITY0 ?>
        <td data-name="QUANTITY0" <?= $Page->QUANTITY0->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_ITEM_QUANTITY0">
<span<?= $Page->QUANTITY0->viewAttributes() ?>>
<?= $Page->QUANTITY0->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PROPOSEDQ->Visible) { // PROPOSEDQ ?>
        <td data-name="PROPOSEDQ" <?= $Page->PROPOSEDQ->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_ITEM_PROPOSEDQ">
<span<?= $Page->PROPOSEDQ->viewAttributes() ?>>
<?= $Page->PROPOSEDQ->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->STOCKQ->Visible) { // STOCKQ ?>
        <td data-name="STOCKQ" <?= $Page->STOCKQ->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_ITEM_STOCKQ">
<span<?= $Page->STOCKQ->viewAttributes() ?>>
<?= $Page->STOCKQ->getViewValue() ?></span>
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
    ew.addEventHandlers("PO_ITEM");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
