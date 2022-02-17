<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

// Page object
$GoodMutationDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fGOOD_MUTATIONdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fGOOD_MUTATIONdelete = currentForm = new ew.Form("fGOOD_MUTATIONdelete", "delete");
    loadjs.done("fGOOD_MUTATIONdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.GOOD_MUTATION) ew.vars.tables.GOOD_MUTATION = <?= JsonEncode(GetClientVar("tables", "GOOD_MUTATION")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fGOOD_MUTATIONdelete" id="fGOOD_MUTATIONdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="GOOD_MUTATION">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($Page->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?= HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table class="table ew-table">
    <thead>
    <tr class="ew-table-header">
<?php if ($Page->ORG_UNIT_CODE->Visible) { // ORG_UNIT_CODE ?>
        <th class="<?= $Page->ORG_UNIT_CODE->headerCellClass() ?>"><span id="elh_GOOD_MUTATION_ORG_UNIT_CODE" class="GOOD_MUTATION_ORG_UNIT_CODE"><?= $Page->ORG_UNIT_CODE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ITEM_ID->Visible) { // ITEM_ID ?>
        <th class="<?= $Page->ITEM_ID->headerCellClass() ?>"><span id="elh_GOOD_MUTATION_ITEM_ID" class="GOOD_MUTATION_ITEM_ID"><?= $Page->ITEM_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ORG_ID->Visible) { // ORG_ID ?>
        <th class="<?= $Page->ORG_ID->headerCellClass() ?>"><span id="elh_GOOD_MUTATION_ORG_ID" class="GOOD_MUTATION_ORG_ID"><?= $Page->ORG_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->RETUR_ID->Visible) { // RETUR_ID ?>
        <th class="<?= $Page->RETUR_ID->headerCellClass() ?>"><span id="elh_GOOD_MUTATION_RETUR_ID" class="GOOD_MUTATION_RETUR_ID"><?= $Page->RETUR_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ORDER_ID->Visible) { // ORDER_ID ?>
        <th class="<?= $Page->ORDER_ID->headerCellClass() ?>"><span id="elh_GOOD_MUTATION_ORDER_ID" class="GOOD_MUTATION_ORDER_ID"><?= $Page->ORDER_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->BATCH_NO->Visible) { // BATCH_NO ?>
        <th class="<?= $Page->BATCH_NO->headerCellClass() ?>"><span id="elh_GOOD_MUTATION_BATCH_NO" class="GOOD_MUTATION_BATCH_NO"><?= $Page->BATCH_NO->caption() ?></span></th>
<?php } ?>
<?php if ($Page->BRAND_ID->Visible) { // BRAND_ID ?>
        <th class="<?= $Page->BRAND_ID->headerCellClass() ?>"><span id="elh_GOOD_MUTATION_BRAND_ID" class="GOOD_MUTATION_BRAND_ID"><?= $Page->BRAND_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ROOMS_ID->Visible) { // ROOMS_ID ?>
        <th class="<?= $Page->ROOMS_ID->headerCellClass() ?>"><span id="elh_GOOD_MUTATION_ROOMS_ID" class="GOOD_MUTATION_ROOMS_ID"><?= $Page->ROOMS_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->SHELF_NO->Visible) { // SHELF_NO ?>
        <th class="<?= $Page->SHELF_NO->headerCellClass() ?>"><span id="elh_GOOD_MUTATION_SHELF_NO" class="GOOD_MUTATION_SHELF_NO"><?= $Page->SHELF_NO->caption() ?></span></th>
<?php } ?>
<?php if ($Page->EXPIRY_DATE->Visible) { // EXPIRY_DATE ?>
        <th class="<?= $Page->EXPIRY_DATE->headerCellClass() ?>"><span id="elh_GOOD_MUTATION_EXPIRY_DATE" class="GOOD_MUTATION_EXPIRY_DATE"><?= $Page->EXPIRY_DATE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->SERIAL_NB->Visible) { // SERIAL_NB ?>
        <th class="<?= $Page->SERIAL_NB->headerCellClass() ?>"><span id="elh_GOOD_MUTATION_SERIAL_NB" class="GOOD_MUTATION_SERIAL_NB"><?= $Page->SERIAL_NB->caption() ?></span></th>
<?php } ?>
<?php if ($Page->FROM_ROOMS_ID->Visible) { // FROM_ROOMS_ID ?>
        <th class="<?= $Page->FROM_ROOMS_ID->headerCellClass() ?>"><span id="elh_GOOD_MUTATION_FROM_ROOMS_ID" class="GOOD_MUTATION_FROM_ROOMS_ID"><?= $Page->FROM_ROOMS_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ISOUTLET->Visible) { // ISOUTLET ?>
        <th class="<?= $Page->ISOUTLET->headerCellClass() ?>"><span id="elh_GOOD_MUTATION_ISOUTLET" class="GOOD_MUTATION_ISOUTLET"><?= $Page->ISOUTLET->caption() ?></span></th>
<?php } ?>
<?php if ($Page->QUANTITY->Visible) { // QUANTITY ?>
        <th class="<?= $Page->QUANTITY->headerCellClass() ?>"><span id="elh_GOOD_MUTATION_QUANTITY" class="GOOD_MUTATION_QUANTITY"><?= $Page->QUANTITY->caption() ?></span></th>
<?php } ?>
<?php if ($Page->MEASURE_ID->Visible) { // MEASURE_ID ?>
        <th class="<?= $Page->MEASURE_ID->headerCellClass() ?>"><span id="elh_GOOD_MUTATION_MEASURE_ID" class="GOOD_MUTATION_MEASURE_ID"><?= $Page->MEASURE_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->DISTRIBUTION_TYPE->Visible) { // DISTRIBUTION_TYPE ?>
        <th class="<?= $Page->DISTRIBUTION_TYPE->headerCellClass() ?>"><span id="elh_GOOD_MUTATION_DISTRIBUTION_TYPE" class="GOOD_MUTATION_DISTRIBUTION_TYPE"><?= $Page->DISTRIBUTION_TYPE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->CONDITION->Visible) { // CONDITION ?>
        <th class="<?= $Page->CONDITION->headerCellClass() ?>"><span id="elh_GOOD_MUTATION_CONDITION" class="GOOD_MUTATION_CONDITION"><?= $Page->CONDITION->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ALLOCATED_DATE->Visible) { // ALLOCATED_DATE ?>
        <th class="<?= $Page->ALLOCATED_DATE->headerCellClass() ?>"><span id="elh_GOOD_MUTATION_ALLOCATED_DATE" class="GOOD_MUTATION_ALLOCATED_DATE"><?= $Page->ALLOCATED_DATE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->STOCKOPNAME_DATE->Visible) { // STOCKOPNAME_DATE ?>
        <th class="<?= $Page->STOCKOPNAME_DATE->headerCellClass() ?>"><span id="elh_GOOD_MUTATION_STOCKOPNAME_DATE" class="GOOD_MUTATION_STOCKOPNAME_DATE"><?= $Page->STOCKOPNAME_DATE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->INVOICE_ID->Visible) { // INVOICE_ID ?>
        <th class="<?= $Page->INVOICE_ID->headerCellClass() ?>"><span id="elh_GOOD_MUTATION_INVOICE_ID" class="GOOD_MUTATION_INVOICE_ID"><?= $Page->INVOICE_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ALLOCATED_FROM->Visible) { // ALLOCATED_FROM ?>
        <th class="<?= $Page->ALLOCATED_FROM->headerCellClass() ?>"><span id="elh_GOOD_MUTATION_ALLOCATED_FROM" class="GOOD_MUTATION_ALLOCATED_FROM"><?= $Page->ALLOCATED_FROM->caption() ?></span></th>
<?php } ?>
<?php if ($Page->PRICE->Visible) { // PRICE ?>
        <th class="<?= $Page->PRICE->headerCellClass() ?>"><span id="elh_GOOD_MUTATION_PRICE" class="GOOD_MUTATION_PRICE"><?= $Page->PRICE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ITEM_ID_FROM->Visible) { // ITEM_ID_FROM ?>
        <th class="<?= $Page->ITEM_ID_FROM->headerCellClass() ?>"><span id="elh_GOOD_MUTATION_ITEM_ID_FROM" class="GOOD_MUTATION_ITEM_ID_FROM"><?= $Page->ITEM_ID_FROM->caption() ?></span></th>
<?php } ?>
<?php if ($Page->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
        <th class="<?= $Page->MODIFIED_DATE->headerCellClass() ?>"><span id="elh_GOOD_MUTATION_MODIFIED_DATE" class="GOOD_MUTATION_MODIFIED_DATE"><?= $Page->MODIFIED_DATE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
        <th class="<?= $Page->MODIFIED_BY->headerCellClass() ?>"><span id="elh_GOOD_MUTATION_MODIFIED_BY" class="GOOD_MUTATION_MODIFIED_BY"><?= $Page->MODIFIED_BY->caption() ?></span></th>
<?php } ?>
<?php if ($Page->STOCK_OPNAME->Visible) { // STOCK_OPNAME ?>
        <th class="<?= $Page->STOCK_OPNAME->headerCellClass() ?>"><span id="elh_GOOD_MUTATION_STOCK_OPNAME" class="GOOD_MUTATION_STOCK_OPNAME"><?= $Page->STOCK_OPNAME->caption() ?></span></th>
<?php } ?>
<?php if ($Page->STOK_AWAL->Visible) { // STOK_AWAL ?>
        <th class="<?= $Page->STOK_AWAL->headerCellClass() ?>"><span id="elh_GOOD_MUTATION_STOK_AWAL" class="GOOD_MUTATION_STOK_AWAL"><?= $Page->STOK_AWAL->caption() ?></span></th>
<?php } ?>
<?php if ($Page->STOCK_LALU->Visible) { // STOCK_LALU ?>
        <th class="<?= $Page->STOCK_LALU->headerCellClass() ?>"><span id="elh_GOOD_MUTATION_STOCK_LALU" class="GOOD_MUTATION_STOCK_LALU"><?= $Page->STOCK_LALU->caption() ?></span></th>
<?php } ?>
<?php if ($Page->STOCK_KOREKSI->Visible) { // STOCK_KOREKSI ?>
        <th class="<?= $Page->STOCK_KOREKSI->headerCellClass() ?>"><span id="elh_GOOD_MUTATION_STOCK_KOREKSI" class="GOOD_MUTATION_STOCK_KOREKSI"><?= $Page->STOCK_KOREKSI->caption() ?></span></th>
<?php } ?>
<?php if ($Page->DITERIMA->Visible) { // DITERIMA ?>
        <th class="<?= $Page->DITERIMA->headerCellClass() ?>"><span id="elh_GOOD_MUTATION_DITERIMA" class="GOOD_MUTATION_DITERIMA"><?= $Page->DITERIMA->caption() ?></span></th>
<?php } ?>
<?php if ($Page->DISTRIBUSI->Visible) { // DISTRIBUSI ?>
        <th class="<?= $Page->DISTRIBUSI->headerCellClass() ?>"><span id="elh_GOOD_MUTATION_DISTRIBUSI" class="GOOD_MUTATION_DISTRIBUSI"><?= $Page->DISTRIBUSI->caption() ?></span></th>
<?php } ?>
<?php if ($Page->DIJUAL->Visible) { // DIJUAL ?>
        <th class="<?= $Page->DIJUAL->headerCellClass() ?>"><span id="elh_GOOD_MUTATION_DIJUAL" class="GOOD_MUTATION_DIJUAL"><?= $Page->DIJUAL->caption() ?></span></th>
<?php } ?>
<?php if ($Page->DIHAPUS->Visible) { // DIHAPUS ?>
        <th class="<?= $Page->DIHAPUS->headerCellClass() ?>"><span id="elh_GOOD_MUTATION_DIHAPUS" class="GOOD_MUTATION_DIHAPUS"><?= $Page->DIHAPUS->caption() ?></span></th>
<?php } ?>
<?php if ($Page->DIMINTA->Visible) { // DIMINTA ?>
        <th class="<?= $Page->DIMINTA->headerCellClass() ?>"><span id="elh_GOOD_MUTATION_DIMINTA" class="GOOD_MUTATION_DIMINTA"><?= $Page->DIMINTA->caption() ?></span></th>
<?php } ?>
<?php if ($Page->DIRETUR->Visible) { // DIRETUR ?>
        <th class="<?= $Page->DIRETUR->headerCellClass() ?>"><span id="elh_GOOD_MUTATION_DIRETUR" class="GOOD_MUTATION_DIRETUR"><?= $Page->DIRETUR->caption() ?></span></th>
<?php } ?>
<?php if ($Page->PO->Visible) { // PO ?>
        <th class="<?= $Page->PO->headerCellClass() ?>"><span id="elh_GOOD_MUTATION_PO" class="GOOD_MUTATION_PO"><?= $Page->PO->caption() ?></span></th>
<?php } ?>
<?php if ($Page->COMPANY_ID->Visible) { // COMPANY_ID ?>
        <th class="<?= $Page->COMPANY_ID->headerCellClass() ?>"><span id="elh_GOOD_MUTATION_COMPANY_ID" class="GOOD_MUTATION_COMPANY_ID"><?= $Page->COMPANY_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->FUND_ID->Visible) { // FUND_ID ?>
        <th class="<?= $Page->FUND_ID->headerCellClass() ?>"><span id="elh_GOOD_MUTATION_FUND_ID" class="GOOD_MUTATION_FUND_ID"><?= $Page->FUND_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->INVOICE_ID2->Visible) { // INVOICE_ID2 ?>
        <th class="<?= $Page->INVOICE_ID2->headerCellClass() ?>"><span id="elh_GOOD_MUTATION_INVOICE_ID2" class="GOOD_MUTATION_INVOICE_ID2"><?= $Page->INVOICE_ID2->caption() ?></span></th>
<?php } ?>
<?php if ($Page->MEASURE_ID3->Visible) { // MEASURE_ID3 ?>
        <th class="<?= $Page->MEASURE_ID3->headerCellClass() ?>"><span id="elh_GOOD_MUTATION_MEASURE_ID3" class="GOOD_MUTATION_MEASURE_ID3"><?= $Page->MEASURE_ID3->caption() ?></span></th>
<?php } ?>
<?php if ($Page->SIZE_KEMASAN->Visible) { // SIZE_KEMASAN ?>
        <th class="<?= $Page->SIZE_KEMASAN->headerCellClass() ?>"><span id="elh_GOOD_MUTATION_SIZE_KEMASAN" class="GOOD_MUTATION_SIZE_KEMASAN"><?= $Page->SIZE_KEMASAN->caption() ?></span></th>
<?php } ?>
<?php if ($Page->BRAND_NAME->Visible) { // BRAND_NAME ?>
        <th class="<?= $Page->BRAND_NAME->headerCellClass() ?>"><span id="elh_GOOD_MUTATION_BRAND_NAME" class="GOOD_MUTATION_BRAND_NAME"><?= $Page->BRAND_NAME->caption() ?></span></th>
<?php } ?>
<?php if ($Page->MEASURE_ID2->Visible) { // MEASURE_ID2 ?>
        <th class="<?= $Page->MEASURE_ID2->headerCellClass() ?>"><span id="elh_GOOD_MUTATION_MEASURE_ID2" class="GOOD_MUTATION_MEASURE_ID2"><?= $Page->MEASURE_ID2->caption() ?></span></th>
<?php } ?>
<?php if ($Page->SIZE_GOODS->Visible) { // SIZE_GOODS ?>
        <th class="<?= $Page->SIZE_GOODS->headerCellClass() ?>"><span id="elh_GOOD_MUTATION_SIZE_GOODS" class="GOOD_MUTATION_SIZE_GOODS"><?= $Page->SIZE_GOODS->caption() ?></span></th>
<?php } ?>
<?php if ($Page->MEASURE_DOSIS->Visible) { // MEASURE_DOSIS ?>
        <th class="<?= $Page->MEASURE_DOSIS->headerCellClass() ?>"><span id="elh_GOOD_MUTATION_MEASURE_DOSIS" class="GOOD_MUTATION_MEASURE_DOSIS"><?= $Page->MEASURE_DOSIS->caption() ?></span></th>
<?php } ?>
<?php if ($Page->DOC_NO->Visible) { // DOC_NO ?>
        <th class="<?= $Page->DOC_NO->headerCellClass() ?>"><span id="elh_GOOD_MUTATION_DOC_NO" class="GOOD_MUTATION_DOC_NO"><?= $Page->DOC_NO->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ORDER_PRICE->Visible) { // ORDER_PRICE ?>
        <th class="<?= $Page->ORDER_PRICE->headerCellClass() ?>"><span id="elh_GOOD_MUTATION_ORDER_PRICE" class="GOOD_MUTATION_ORDER_PRICE"><?= $Page->ORDER_PRICE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ISCETAK->Visible) { // ISCETAK ?>
        <th class="<?= $Page->ISCETAK->headerCellClass() ?>"><span id="elh_GOOD_MUTATION_ISCETAK" class="GOOD_MUTATION_ISCETAK"><?= $Page->ISCETAK->caption() ?></span></th>
<?php } ?>
<?php if ($Page->PRINT_DATE->Visible) { // PRINT_DATE ?>
        <th class="<?= $Page->PRINT_DATE->headerCellClass() ?>"><span id="elh_GOOD_MUTATION_PRINT_DATE" class="GOOD_MUTATION_PRINT_DATE"><?= $Page->PRINT_DATE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->PRINTED_BY->Visible) { // PRINTED_BY ?>
        <th class="<?= $Page->PRINTED_BY->headerCellClass() ?>"><span id="elh_GOOD_MUTATION_PRINTED_BY" class="GOOD_MUTATION_PRINTED_BY"><?= $Page->PRINTED_BY->caption() ?></span></th>
<?php } ?>
<?php if ($Page->PRINTQ->Visible) { // PRINTQ ?>
        <th class="<?= $Page->PRINTQ->headerCellClass() ?>"><span id="elh_GOOD_MUTATION_PRINTQ" class="GOOD_MUTATION_PRINTQ"><?= $Page->PRINTQ->caption() ?></span></th>
<?php } ?>
<?php if ($Page->STOCK_AVAILABLE->Visible) { // STOCK_AVAILABLE ?>
        <th class="<?= $Page->STOCK_AVAILABLE->headerCellClass() ?>"><span id="elh_GOOD_MUTATION_STOCK_AVAILABLE" class="GOOD_MUTATION_STOCK_AVAILABLE"><?= $Page->STOCK_AVAILABLE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->STATUS_PASIEN_ID->Visible) { // STATUS_PASIEN_ID ?>
        <th class="<?= $Page->STATUS_PASIEN_ID->headerCellClass() ?>"><span id="elh_GOOD_MUTATION_STATUS_PASIEN_ID" class="GOOD_MUTATION_STATUS_PASIEN_ID"><?= $Page->STATUS_PASIEN_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->MONTH_ID->Visible) { // MONTH_ID ?>
        <th class="<?= $Page->MONTH_ID->headerCellClass() ?>"><span id="elh_GOOD_MUTATION_MONTH_ID" class="GOOD_MUTATION_MONTH_ID"><?= $Page->MONTH_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->YEAR_ID->Visible) { // YEAR_ID ?>
        <th class="<?= $Page->YEAR_ID->headerCellClass() ?>"><span id="elh_GOOD_MUTATION_YEAR_ID" class="GOOD_MUTATION_YEAR_ID"><?= $Page->YEAR_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->CORRECTION_DOC->Visible) { // CORRECTION_DOC ?>
        <th class="<?= $Page->CORRECTION_DOC->headerCellClass() ?>"><span id="elh_GOOD_MUTATION_CORRECTION_DOC" class="GOOD_MUTATION_CORRECTION_DOC"><?= $Page->CORRECTION_DOC->caption() ?></span></th>
<?php } ?>
<?php if ($Page->CORRECTIONS->Visible) { // CORRECTIONS ?>
        <th class="<?= $Page->CORRECTIONS->headerCellClass() ?>"><span id="elh_GOOD_MUTATION_CORRECTIONS" class="GOOD_MUTATION_CORRECTIONS"><?= $Page->CORRECTIONS->caption() ?></span></th>
<?php } ?>
<?php if ($Page->CORRECTION_DATE->Visible) { // CORRECTION_DATE ?>
        <th class="<?= $Page->CORRECTION_DATE->headerCellClass() ?>"><span id="elh_GOOD_MUTATION_CORRECTION_DATE" class="GOOD_MUTATION_CORRECTION_DATE"><?= $Page->CORRECTION_DATE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->DISCOUNT->Visible) { // DISCOUNT ?>
        <th class="<?= $Page->DISCOUNT->headerCellClass() ?>"><span id="elh_GOOD_MUTATION_DISCOUNT" class="GOOD_MUTATION_DISCOUNT"><?= $Page->DISCOUNT->caption() ?></span></th>
<?php } ?>
<?php if ($Page->DISCOUNT2->Visible) { // DISCOUNT2 ?>
        <th class="<?= $Page->DISCOUNT2->headerCellClass() ?>"><span id="elh_GOOD_MUTATION_DISCOUNT2" class="GOOD_MUTATION_DISCOUNT2"><?= $Page->DISCOUNT2->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ORG_UNIT_FROM->Visible) { // ORG_UNIT_FROM ?>
        <th class="<?= $Page->ORG_UNIT_FROM->headerCellClass() ?>"><span id="elh_GOOD_MUTATION_ORG_UNIT_FROM" class="GOOD_MUTATION_ORG_UNIT_FROM"><?= $Page->ORG_UNIT_FROM->caption() ?></span></th>
<?php } ?>
<?php if ($Page->DISCOUNTOFF->Visible) { // DISCOUNTOFF ?>
        <th class="<?= $Page->DISCOUNTOFF->headerCellClass() ?>"><span id="elh_GOOD_MUTATION_DISCOUNTOFF" class="GOOD_MUTATION_DISCOUNTOFF"><?= $Page->DISCOUNTOFF->caption() ?></span></th>
<?php } ?>
<?php if ($Page->avgprice->Visible) { // avgprice ?>
        <th class="<?= $Page->avgprice->headerCellClass() ?>"><span id="elh_GOOD_MUTATION_avgprice" class="GOOD_MUTATION_avgprice"><?= $Page->avgprice->caption() ?></span></th>
<?php } ?>
<?php if ($Page->idx->Visible) { // idx ?>
        <th class="<?= $Page->idx->headerCellClass() ?>"><span id="elh_GOOD_MUTATION_idx" class="GOOD_MUTATION_idx"><?= $Page->idx->caption() ?></span></th>
<?php } ?>
    </tr>
    </thead>
    <tbody>
<?php
$Page->RecordCount = 0;
$i = 0;
while (!$Page->Recordset->EOF) {
    $Page->RecordCount++;
    $Page->RowCount++;

    // Set row properties
    $Page->resetAttributes();
    $Page->RowType = ROWTYPE_VIEW; // View

    // Get the field contents
    $Page->loadRowValues($Page->Recordset);

    // Render row
    $Page->renderRow();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php if ($Page->ORG_UNIT_CODE->Visible) { // ORG_UNIT_CODE ?>
        <td <?= $Page->ORG_UNIT_CODE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_ORG_UNIT_CODE" class="GOOD_MUTATION_ORG_UNIT_CODE">
<span<?= $Page->ORG_UNIT_CODE->viewAttributes() ?>>
<?= $Page->ORG_UNIT_CODE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ITEM_ID->Visible) { // ITEM_ID ?>
        <td <?= $Page->ITEM_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_ITEM_ID" class="GOOD_MUTATION_ITEM_ID">
<span<?= $Page->ITEM_ID->viewAttributes() ?>>
<?= $Page->ITEM_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ORG_ID->Visible) { // ORG_ID ?>
        <td <?= $Page->ORG_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_ORG_ID" class="GOOD_MUTATION_ORG_ID">
<span<?= $Page->ORG_ID->viewAttributes() ?>>
<?= $Page->ORG_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->RETUR_ID->Visible) { // RETUR_ID ?>
        <td <?= $Page->RETUR_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_RETUR_ID" class="GOOD_MUTATION_RETUR_ID">
<span<?= $Page->RETUR_ID->viewAttributes() ?>>
<?= $Page->RETUR_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ORDER_ID->Visible) { // ORDER_ID ?>
        <td <?= $Page->ORDER_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_ORDER_ID" class="GOOD_MUTATION_ORDER_ID">
<span<?= $Page->ORDER_ID->viewAttributes() ?>>
<?= $Page->ORDER_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->BATCH_NO->Visible) { // BATCH_NO ?>
        <td <?= $Page->BATCH_NO->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_BATCH_NO" class="GOOD_MUTATION_BATCH_NO">
<span<?= $Page->BATCH_NO->viewAttributes() ?>>
<?= $Page->BATCH_NO->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->BRAND_ID->Visible) { // BRAND_ID ?>
        <td <?= $Page->BRAND_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_BRAND_ID" class="GOOD_MUTATION_BRAND_ID">
<span<?= $Page->BRAND_ID->viewAttributes() ?>>
<?= $Page->BRAND_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ROOMS_ID->Visible) { // ROOMS_ID ?>
        <td <?= $Page->ROOMS_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_ROOMS_ID" class="GOOD_MUTATION_ROOMS_ID">
<span<?= $Page->ROOMS_ID->viewAttributes() ?>>
<?= $Page->ROOMS_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->SHELF_NO->Visible) { // SHELF_NO ?>
        <td <?= $Page->SHELF_NO->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_SHELF_NO" class="GOOD_MUTATION_SHELF_NO">
<span<?= $Page->SHELF_NO->viewAttributes() ?>>
<?= $Page->SHELF_NO->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->EXPIRY_DATE->Visible) { // EXPIRY_DATE ?>
        <td <?= $Page->EXPIRY_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_EXPIRY_DATE" class="GOOD_MUTATION_EXPIRY_DATE">
<span<?= $Page->EXPIRY_DATE->viewAttributes() ?>>
<?= $Page->EXPIRY_DATE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->SERIAL_NB->Visible) { // SERIAL_NB ?>
        <td <?= $Page->SERIAL_NB->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_SERIAL_NB" class="GOOD_MUTATION_SERIAL_NB">
<span<?= $Page->SERIAL_NB->viewAttributes() ?>>
<?= $Page->SERIAL_NB->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->FROM_ROOMS_ID->Visible) { // FROM_ROOMS_ID ?>
        <td <?= $Page->FROM_ROOMS_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_FROM_ROOMS_ID" class="GOOD_MUTATION_FROM_ROOMS_ID">
<span<?= $Page->FROM_ROOMS_ID->viewAttributes() ?>>
<?= $Page->FROM_ROOMS_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ISOUTLET->Visible) { // ISOUTLET ?>
        <td <?= $Page->ISOUTLET->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_ISOUTLET" class="GOOD_MUTATION_ISOUTLET">
<span<?= $Page->ISOUTLET->viewAttributes() ?>>
<?= $Page->ISOUTLET->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->QUANTITY->Visible) { // QUANTITY ?>
        <td <?= $Page->QUANTITY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_QUANTITY" class="GOOD_MUTATION_QUANTITY">
<span<?= $Page->QUANTITY->viewAttributes() ?>>
<?= $Page->QUANTITY->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->MEASURE_ID->Visible) { // MEASURE_ID ?>
        <td <?= $Page->MEASURE_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_MEASURE_ID" class="GOOD_MUTATION_MEASURE_ID">
<span<?= $Page->MEASURE_ID->viewAttributes() ?>>
<?= $Page->MEASURE_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->DISTRIBUTION_TYPE->Visible) { // DISTRIBUTION_TYPE ?>
        <td <?= $Page->DISTRIBUTION_TYPE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_DISTRIBUTION_TYPE" class="GOOD_MUTATION_DISTRIBUTION_TYPE">
<span<?= $Page->DISTRIBUTION_TYPE->viewAttributes() ?>>
<?= $Page->DISTRIBUTION_TYPE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->CONDITION->Visible) { // CONDITION ?>
        <td <?= $Page->CONDITION->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_CONDITION" class="GOOD_MUTATION_CONDITION">
<span<?= $Page->CONDITION->viewAttributes() ?>>
<?= $Page->CONDITION->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ALLOCATED_DATE->Visible) { // ALLOCATED_DATE ?>
        <td <?= $Page->ALLOCATED_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_ALLOCATED_DATE" class="GOOD_MUTATION_ALLOCATED_DATE">
<span<?= $Page->ALLOCATED_DATE->viewAttributes() ?>>
<?= $Page->ALLOCATED_DATE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->STOCKOPNAME_DATE->Visible) { // STOCKOPNAME_DATE ?>
        <td <?= $Page->STOCKOPNAME_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_STOCKOPNAME_DATE" class="GOOD_MUTATION_STOCKOPNAME_DATE">
<span<?= $Page->STOCKOPNAME_DATE->viewAttributes() ?>>
<?= $Page->STOCKOPNAME_DATE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->INVOICE_ID->Visible) { // INVOICE_ID ?>
        <td <?= $Page->INVOICE_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_INVOICE_ID" class="GOOD_MUTATION_INVOICE_ID">
<span<?= $Page->INVOICE_ID->viewAttributes() ?>>
<?= $Page->INVOICE_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ALLOCATED_FROM->Visible) { // ALLOCATED_FROM ?>
        <td <?= $Page->ALLOCATED_FROM->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_ALLOCATED_FROM" class="GOOD_MUTATION_ALLOCATED_FROM">
<span<?= $Page->ALLOCATED_FROM->viewAttributes() ?>>
<?= $Page->ALLOCATED_FROM->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->PRICE->Visible) { // PRICE ?>
        <td <?= $Page->PRICE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_PRICE" class="GOOD_MUTATION_PRICE">
<span<?= $Page->PRICE->viewAttributes() ?>>
<?= $Page->PRICE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ITEM_ID_FROM->Visible) { // ITEM_ID_FROM ?>
        <td <?= $Page->ITEM_ID_FROM->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_ITEM_ID_FROM" class="GOOD_MUTATION_ITEM_ID_FROM">
<span<?= $Page->ITEM_ID_FROM->viewAttributes() ?>>
<?= $Page->ITEM_ID_FROM->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
        <td <?= $Page->MODIFIED_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_MODIFIED_DATE" class="GOOD_MUTATION_MODIFIED_DATE">
<span<?= $Page->MODIFIED_DATE->viewAttributes() ?>>
<?= $Page->MODIFIED_DATE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
        <td <?= $Page->MODIFIED_BY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_MODIFIED_BY" class="GOOD_MUTATION_MODIFIED_BY">
<span<?= $Page->MODIFIED_BY->viewAttributes() ?>>
<?= $Page->MODIFIED_BY->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->STOCK_OPNAME->Visible) { // STOCK_OPNAME ?>
        <td <?= $Page->STOCK_OPNAME->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_STOCK_OPNAME" class="GOOD_MUTATION_STOCK_OPNAME">
<span<?= $Page->STOCK_OPNAME->viewAttributes() ?>>
<?= $Page->STOCK_OPNAME->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->STOK_AWAL->Visible) { // STOK_AWAL ?>
        <td <?= $Page->STOK_AWAL->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_STOK_AWAL" class="GOOD_MUTATION_STOK_AWAL">
<span<?= $Page->STOK_AWAL->viewAttributes() ?>>
<?= $Page->STOK_AWAL->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->STOCK_LALU->Visible) { // STOCK_LALU ?>
        <td <?= $Page->STOCK_LALU->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_STOCK_LALU" class="GOOD_MUTATION_STOCK_LALU">
<span<?= $Page->STOCK_LALU->viewAttributes() ?>>
<?= $Page->STOCK_LALU->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->STOCK_KOREKSI->Visible) { // STOCK_KOREKSI ?>
        <td <?= $Page->STOCK_KOREKSI->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_STOCK_KOREKSI" class="GOOD_MUTATION_STOCK_KOREKSI">
<span<?= $Page->STOCK_KOREKSI->viewAttributes() ?>>
<?= $Page->STOCK_KOREKSI->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->DITERIMA->Visible) { // DITERIMA ?>
        <td <?= $Page->DITERIMA->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_DITERIMA" class="GOOD_MUTATION_DITERIMA">
<span<?= $Page->DITERIMA->viewAttributes() ?>>
<?= $Page->DITERIMA->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->DISTRIBUSI->Visible) { // DISTRIBUSI ?>
        <td <?= $Page->DISTRIBUSI->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_DISTRIBUSI" class="GOOD_MUTATION_DISTRIBUSI">
<span<?= $Page->DISTRIBUSI->viewAttributes() ?>>
<?= $Page->DISTRIBUSI->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->DIJUAL->Visible) { // DIJUAL ?>
        <td <?= $Page->DIJUAL->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_DIJUAL" class="GOOD_MUTATION_DIJUAL">
<span<?= $Page->DIJUAL->viewAttributes() ?>>
<?= $Page->DIJUAL->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->DIHAPUS->Visible) { // DIHAPUS ?>
        <td <?= $Page->DIHAPUS->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_DIHAPUS" class="GOOD_MUTATION_DIHAPUS">
<span<?= $Page->DIHAPUS->viewAttributes() ?>>
<?= $Page->DIHAPUS->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->DIMINTA->Visible) { // DIMINTA ?>
        <td <?= $Page->DIMINTA->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_DIMINTA" class="GOOD_MUTATION_DIMINTA">
<span<?= $Page->DIMINTA->viewAttributes() ?>>
<?= $Page->DIMINTA->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->DIRETUR->Visible) { // DIRETUR ?>
        <td <?= $Page->DIRETUR->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_DIRETUR" class="GOOD_MUTATION_DIRETUR">
<span<?= $Page->DIRETUR->viewAttributes() ?>>
<?= $Page->DIRETUR->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->PO->Visible) { // PO ?>
        <td <?= $Page->PO->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_PO" class="GOOD_MUTATION_PO">
<span<?= $Page->PO->viewAttributes() ?>>
<?= $Page->PO->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->COMPANY_ID->Visible) { // COMPANY_ID ?>
        <td <?= $Page->COMPANY_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_COMPANY_ID" class="GOOD_MUTATION_COMPANY_ID">
<span<?= $Page->COMPANY_ID->viewAttributes() ?>>
<?= $Page->COMPANY_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->FUND_ID->Visible) { // FUND_ID ?>
        <td <?= $Page->FUND_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_FUND_ID" class="GOOD_MUTATION_FUND_ID">
<span<?= $Page->FUND_ID->viewAttributes() ?>>
<?= $Page->FUND_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->INVOICE_ID2->Visible) { // INVOICE_ID2 ?>
        <td <?= $Page->INVOICE_ID2->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_INVOICE_ID2" class="GOOD_MUTATION_INVOICE_ID2">
<span<?= $Page->INVOICE_ID2->viewAttributes() ?>>
<?= $Page->INVOICE_ID2->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->MEASURE_ID3->Visible) { // MEASURE_ID3 ?>
        <td <?= $Page->MEASURE_ID3->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_MEASURE_ID3" class="GOOD_MUTATION_MEASURE_ID3">
<span<?= $Page->MEASURE_ID3->viewAttributes() ?>>
<?= $Page->MEASURE_ID3->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->SIZE_KEMASAN->Visible) { // SIZE_KEMASAN ?>
        <td <?= $Page->SIZE_KEMASAN->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_SIZE_KEMASAN" class="GOOD_MUTATION_SIZE_KEMASAN">
<span<?= $Page->SIZE_KEMASAN->viewAttributes() ?>>
<?= $Page->SIZE_KEMASAN->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->BRAND_NAME->Visible) { // BRAND_NAME ?>
        <td <?= $Page->BRAND_NAME->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_BRAND_NAME" class="GOOD_MUTATION_BRAND_NAME">
<span<?= $Page->BRAND_NAME->viewAttributes() ?>>
<?= $Page->BRAND_NAME->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->MEASURE_ID2->Visible) { // MEASURE_ID2 ?>
        <td <?= $Page->MEASURE_ID2->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_MEASURE_ID2" class="GOOD_MUTATION_MEASURE_ID2">
<span<?= $Page->MEASURE_ID2->viewAttributes() ?>>
<?= $Page->MEASURE_ID2->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->SIZE_GOODS->Visible) { // SIZE_GOODS ?>
        <td <?= $Page->SIZE_GOODS->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_SIZE_GOODS" class="GOOD_MUTATION_SIZE_GOODS">
<span<?= $Page->SIZE_GOODS->viewAttributes() ?>>
<?= $Page->SIZE_GOODS->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->MEASURE_DOSIS->Visible) { // MEASURE_DOSIS ?>
        <td <?= $Page->MEASURE_DOSIS->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_MEASURE_DOSIS" class="GOOD_MUTATION_MEASURE_DOSIS">
<span<?= $Page->MEASURE_DOSIS->viewAttributes() ?>>
<?= $Page->MEASURE_DOSIS->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->DOC_NO->Visible) { // DOC_NO ?>
        <td <?= $Page->DOC_NO->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_DOC_NO" class="GOOD_MUTATION_DOC_NO">
<span<?= $Page->DOC_NO->viewAttributes() ?>>
<?= $Page->DOC_NO->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ORDER_PRICE->Visible) { // ORDER_PRICE ?>
        <td <?= $Page->ORDER_PRICE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_ORDER_PRICE" class="GOOD_MUTATION_ORDER_PRICE">
<span<?= $Page->ORDER_PRICE->viewAttributes() ?>>
<?= $Page->ORDER_PRICE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ISCETAK->Visible) { // ISCETAK ?>
        <td <?= $Page->ISCETAK->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_ISCETAK" class="GOOD_MUTATION_ISCETAK">
<span<?= $Page->ISCETAK->viewAttributes() ?>>
<?= $Page->ISCETAK->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->PRINT_DATE->Visible) { // PRINT_DATE ?>
        <td <?= $Page->PRINT_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_PRINT_DATE" class="GOOD_MUTATION_PRINT_DATE">
<span<?= $Page->PRINT_DATE->viewAttributes() ?>>
<?= $Page->PRINT_DATE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->PRINTED_BY->Visible) { // PRINTED_BY ?>
        <td <?= $Page->PRINTED_BY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_PRINTED_BY" class="GOOD_MUTATION_PRINTED_BY">
<span<?= $Page->PRINTED_BY->viewAttributes() ?>>
<?= $Page->PRINTED_BY->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->PRINTQ->Visible) { // PRINTQ ?>
        <td <?= $Page->PRINTQ->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_PRINTQ" class="GOOD_MUTATION_PRINTQ">
<span<?= $Page->PRINTQ->viewAttributes() ?>>
<?= $Page->PRINTQ->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->STOCK_AVAILABLE->Visible) { // STOCK_AVAILABLE ?>
        <td <?= $Page->STOCK_AVAILABLE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_STOCK_AVAILABLE" class="GOOD_MUTATION_STOCK_AVAILABLE">
<span<?= $Page->STOCK_AVAILABLE->viewAttributes() ?>>
<?= $Page->STOCK_AVAILABLE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->STATUS_PASIEN_ID->Visible) { // STATUS_PASIEN_ID ?>
        <td <?= $Page->STATUS_PASIEN_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_STATUS_PASIEN_ID" class="GOOD_MUTATION_STATUS_PASIEN_ID">
<span<?= $Page->STATUS_PASIEN_ID->viewAttributes() ?>>
<?= $Page->STATUS_PASIEN_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->MONTH_ID->Visible) { // MONTH_ID ?>
        <td <?= $Page->MONTH_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_MONTH_ID" class="GOOD_MUTATION_MONTH_ID">
<span<?= $Page->MONTH_ID->viewAttributes() ?>>
<?= $Page->MONTH_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->YEAR_ID->Visible) { // YEAR_ID ?>
        <td <?= $Page->YEAR_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_YEAR_ID" class="GOOD_MUTATION_YEAR_ID">
<span<?= $Page->YEAR_ID->viewAttributes() ?>>
<?= $Page->YEAR_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->CORRECTION_DOC->Visible) { // CORRECTION_DOC ?>
        <td <?= $Page->CORRECTION_DOC->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_CORRECTION_DOC" class="GOOD_MUTATION_CORRECTION_DOC">
<span<?= $Page->CORRECTION_DOC->viewAttributes() ?>>
<?= $Page->CORRECTION_DOC->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->CORRECTIONS->Visible) { // CORRECTIONS ?>
        <td <?= $Page->CORRECTIONS->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_CORRECTIONS" class="GOOD_MUTATION_CORRECTIONS">
<span<?= $Page->CORRECTIONS->viewAttributes() ?>>
<?= $Page->CORRECTIONS->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->CORRECTION_DATE->Visible) { // CORRECTION_DATE ?>
        <td <?= $Page->CORRECTION_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_CORRECTION_DATE" class="GOOD_MUTATION_CORRECTION_DATE">
<span<?= $Page->CORRECTION_DATE->viewAttributes() ?>>
<?= $Page->CORRECTION_DATE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->DISCOUNT->Visible) { // DISCOUNT ?>
        <td <?= $Page->DISCOUNT->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_DISCOUNT" class="GOOD_MUTATION_DISCOUNT">
<span<?= $Page->DISCOUNT->viewAttributes() ?>>
<?= $Page->DISCOUNT->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->DISCOUNT2->Visible) { // DISCOUNT2 ?>
        <td <?= $Page->DISCOUNT2->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_DISCOUNT2" class="GOOD_MUTATION_DISCOUNT2">
<span<?= $Page->DISCOUNT2->viewAttributes() ?>>
<?= $Page->DISCOUNT2->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ORG_UNIT_FROM->Visible) { // ORG_UNIT_FROM ?>
        <td <?= $Page->ORG_UNIT_FROM->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_ORG_UNIT_FROM" class="GOOD_MUTATION_ORG_UNIT_FROM">
<span<?= $Page->ORG_UNIT_FROM->viewAttributes() ?>>
<?= $Page->ORG_UNIT_FROM->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->DISCOUNTOFF->Visible) { // DISCOUNTOFF ?>
        <td <?= $Page->DISCOUNTOFF->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_DISCOUNTOFF" class="GOOD_MUTATION_DISCOUNTOFF">
<span<?= $Page->DISCOUNTOFF->viewAttributes() ?>>
<?= $Page->DISCOUNTOFF->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->avgprice->Visible) { // avgprice ?>
        <td <?= $Page->avgprice->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_avgprice" class="GOOD_MUTATION_avgprice">
<span<?= $Page->avgprice->viewAttributes() ?>>
<?= $Page->avgprice->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->idx->Visible) { // idx ?>
        <td <?= $Page->idx->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_MUTATION_idx" class="GOOD_MUTATION_idx">
<span<?= $Page->idx->viewAttributes() ?>>
<?= $Page->idx->getViewValue() ?></span>
</span>
</td>
<?php } ?>
    </tr>
<?php
    $Page->Recordset->moveNext();
}
$Page->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
