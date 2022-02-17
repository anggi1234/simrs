<?php

namespace PHPMaker2021\SIMRSSQLSERVERGUDANGFARMASI;

// Page object
$PoItemDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fPO_ITEMdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fPO_ITEMdelete = currentForm = new ew.Form("fPO_ITEMdelete", "delete");
    loadjs.done("fPO_ITEMdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.PO_ITEM) ew.vars.tables.PO_ITEM = <?= JsonEncode(GetClientVar("tables", "PO_ITEM")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fPO_ITEMdelete" id="fPO_ITEMdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="PO_ITEM">
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
        <th class="<?= $Page->ORG_UNIT_CODE->headerCellClass() ?>"><span id="elh_PO_ITEM_ORG_UNIT_CODE" class="PO_ITEM_ORG_UNIT_CODE"><?= $Page->ORG_UNIT_CODE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->PO->Visible) { // PO ?>
        <th class="<?= $Page->PO->headerCellClass() ?>"><span id="elh_PO_ITEM_PO" class="PO_ITEM_PO"><?= $Page->PO->caption() ?></span></th>
<?php } ?>
<?php if ($Page->BRAND_ID->Visible) { // BRAND_ID ?>
        <th class="<?= $Page->BRAND_ID->headerCellClass() ?>"><span id="elh_PO_ITEM_BRAND_ID" class="PO_ITEM_BRAND_ID"><?= $Page->BRAND_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ORDER_DATE->Visible) { // ORDER_DATE ?>
        <th class="<?= $Page->ORDER_DATE->headerCellClass() ?>"><span id="elh_PO_ITEM_ORDER_DATE" class="PO_ITEM_ORDER_DATE"><?= $Page->ORDER_DATE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->PO_NO->Visible) { // PO_NO ?>
        <th class="<?= $Page->PO_NO->headerCellClass() ?>"><span id="elh_PO_ITEM_PO_NO" class="PO_ITEM_PO_NO"><?= $Page->PO_NO->caption() ?></span></th>
<?php } ?>
<?php if ($Page->PURCHASE_PRICE->Visible) { // PURCHASE_PRICE ?>
        <th class="<?= $Page->PURCHASE_PRICE->headerCellClass() ?>"><span id="elh_PO_ITEM_PURCHASE_PRICE" class="PO_ITEM_PURCHASE_PRICE"><?= $Page->PURCHASE_PRICE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ORDER_QUANTITY->Visible) { // ORDER_QUANTITY ?>
        <th class="<?= $Page->ORDER_QUANTITY->headerCellClass() ?>"><span id="elh_PO_ITEM_ORDER_QUANTITY" class="PO_ITEM_ORDER_QUANTITY"><?= $Page->ORDER_QUANTITY->caption() ?></span></th>
<?php } ?>
<?php if ($Page->RECEIVED_QUANTITY->Visible) { // RECEIVED_QUANTITY ?>
        <th class="<?= $Page->RECEIVED_QUANTITY->headerCellClass() ?>"><span id="elh_PO_ITEM_RECEIVED_QUANTITY" class="PO_ITEM_RECEIVED_QUANTITY"><?= $Page->RECEIVED_QUANTITY->caption() ?></span></th>
<?php } ?>
<?php if ($Page->MEASURE_ID->Visible) { // MEASURE_ID ?>
        <th class="<?= $Page->MEASURE_ID->headerCellClass() ?>"><span id="elh_PO_ITEM_MEASURE_ID" class="PO_ITEM_MEASURE_ID"><?= $Page->MEASURE_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->DISCOUNT->Visible) { // DISCOUNT ?>
        <th class="<?= $Page->DISCOUNT->headerCellClass() ?>"><span id="elh_PO_ITEM_DISCOUNT" class="PO_ITEM_DISCOUNT"><?= $Page->DISCOUNT->caption() ?></span></th>
<?php } ?>
<?php if ($Page->AMOUNT_PAID->Visible) { // AMOUNT_PAID ?>
        <th class="<?= $Page->AMOUNT_PAID->headerCellClass() ?>"><span id="elh_PO_ITEM_AMOUNT_PAID" class="PO_ITEM_AMOUNT_PAID"><?= $Page->AMOUNT_PAID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ATP_DATE->Visible) { // ATP_DATE ?>
        <th class="<?= $Page->ATP_DATE->headerCellClass() ?>"><span id="elh_PO_ITEM_ATP_DATE" class="PO_ITEM_ATP_DATE"><?= $Page->ATP_DATE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->DELIVERY_DATE->Visible) { // DELIVERY_DATE ?>
        <th class="<?= $Page->DELIVERY_DATE->headerCellClass() ?>"><span id="elh_PO_ITEM_DELIVERY_DATE" class="PO_ITEM_DELIVERY_DATE"><?= $Page->DELIVERY_DATE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->DESCRIPTION->Visible) { // DESCRIPTION ?>
        <th class="<?= $Page->DESCRIPTION->headerCellClass() ?>"><span id="elh_PO_ITEM_DESCRIPTION" class="PO_ITEM_DESCRIPTION"><?= $Page->DESCRIPTION->caption() ?></span></th>
<?php } ?>
<?php if ($Page->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
        <th class="<?= $Page->MODIFIED_DATE->headerCellClass() ?>"><span id="elh_PO_ITEM_MODIFIED_DATE" class="PO_ITEM_MODIFIED_DATE"><?= $Page->MODIFIED_DATE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
        <th class="<?= $Page->MODIFIED_BY->headerCellClass() ?>"><span id="elh_PO_ITEM_MODIFIED_BY" class="PO_ITEM_MODIFIED_BY"><?= $Page->MODIFIED_BY->caption() ?></span></th>
<?php } ?>
<?php if ($Page->company_id->Visible) { // company_id ?>
        <th class="<?= $Page->company_id->headerCellClass() ?>"><span id="elh_PO_ITEM_company_id" class="PO_ITEM_company_id"><?= $Page->company_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->SIZE_KEMASAN->Visible) { // SIZE_KEMASAN ?>
        <th class="<?= $Page->SIZE_KEMASAN->headerCellClass() ?>"><span id="elh_PO_ITEM_SIZE_KEMASAN" class="PO_ITEM_SIZE_KEMASAN"><?= $Page->SIZE_KEMASAN->caption() ?></span></th>
<?php } ?>
<?php if ($Page->MEASURE_ID2->Visible) { // MEASURE_ID2 ?>
        <th class="<?= $Page->MEASURE_ID2->headerCellClass() ?>"><span id="elh_PO_ITEM_MEASURE_ID2" class="PO_ITEM_MEASURE_ID2"><?= $Page->MEASURE_ID2->caption() ?></span></th>
<?php } ?>
<?php if ($Page->SIZE_GOODS->Visible) { // SIZE_GOODS ?>
        <th class="<?= $Page->SIZE_GOODS->headerCellClass() ?>"><span id="elh_PO_ITEM_SIZE_GOODS" class="PO_ITEM_SIZE_GOODS"><?= $Page->SIZE_GOODS->caption() ?></span></th>
<?php } ?>
<?php if ($Page->MEASURE_DOSIS->Visible) { // MEASURE_DOSIS ?>
        <th class="<?= $Page->MEASURE_DOSIS->headerCellClass() ?>"><span id="elh_PO_ITEM_MEASURE_DOSIS" class="PO_ITEM_MEASURE_DOSIS"><?= $Page->MEASURE_DOSIS->caption() ?></span></th>
<?php } ?>
<?php if ($Page->QUANTITY->Visible) { // QUANTITY ?>
        <th class="<?= $Page->QUANTITY->headerCellClass() ?>"><span id="elh_PO_ITEM_QUANTITY" class="PO_ITEM_QUANTITY"><?= $Page->QUANTITY->caption() ?></span></th>
<?php } ?>
<?php if ($Page->MEASURE_ID3->Visible) { // MEASURE_ID3 ?>
        <th class="<?= $Page->MEASURE_ID3->headerCellClass() ?>"><span id="elh_PO_ITEM_MEASURE_ID3" class="PO_ITEM_MEASURE_ID3"><?= $Page->MEASURE_ID3->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ORDER_PRICE->Visible) { // ORDER_PRICE ?>
        <th class="<?= $Page->ORDER_PRICE->headerCellClass() ?>"><span id="elh_PO_ITEM_ORDER_PRICE" class="PO_ITEM_ORDER_PRICE"><?= $Page->ORDER_PRICE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->BRAND_NAME->Visible) { // BRAND_NAME ?>
        <th class="<?= $Page->BRAND_NAME->headerCellClass() ?>"><span id="elh_PO_ITEM_BRAND_NAME" class="PO_ITEM_BRAND_NAME"><?= $Page->BRAND_NAME->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ISCETAK->Visible) { // ISCETAK ?>
        <th class="<?= $Page->ISCETAK->headerCellClass() ?>"><span id="elh_PO_ITEM_ISCETAK" class="PO_ITEM_ISCETAK"><?= $Page->ISCETAK->caption() ?></span></th>
<?php } ?>
<?php if ($Page->PRINT_DATE->Visible) { // PRINT_DATE ?>
        <th class="<?= $Page->PRINT_DATE->headerCellClass() ?>"><span id="elh_PO_ITEM_PRINT_DATE" class="PO_ITEM_PRINT_DATE"><?= $Page->PRINT_DATE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->PRINTED_BY->Visible) { // PRINTED_BY ?>
        <th class="<?= $Page->PRINTED_BY->headerCellClass() ?>"><span id="elh_PO_ITEM_PRINTED_BY" class="PO_ITEM_PRINTED_BY"><?= $Page->PRINTED_BY->caption() ?></span></th>
<?php } ?>
<?php if ($Page->PRINTQ->Visible) { // PRINTQ ?>
        <th class="<?= $Page->PRINTQ->headerCellClass() ?>"><span id="elh_PO_ITEM_PRINTQ" class="PO_ITEM_PRINTQ"><?= $Page->PRINTQ->caption() ?></span></th>
<?php } ?>
<?php if ($Page->DISCOUNTOFF->Visible) { // DISCOUNTOFF ?>
        <th class="<?= $Page->DISCOUNTOFF->headerCellClass() ?>"><span id="elh_PO_ITEM_DISCOUNTOFF" class="PO_ITEM_DISCOUNTOFF"><?= $Page->DISCOUNTOFF->caption() ?></span></th>
<?php } ?>
<?php if ($Page->IDX->Visible) { // IDX ?>
        <th class="<?= $Page->IDX->headerCellClass() ?>"><span id="elh_PO_ITEM_IDX" class="PO_ITEM_IDX"><?= $Page->IDX->caption() ?></span></th>
<?php } ?>
<?php if ($Page->QUANTITY0->Visible) { // QUANTITY0 ?>
        <th class="<?= $Page->QUANTITY0->headerCellClass() ?>"><span id="elh_PO_ITEM_QUANTITY0" class="PO_ITEM_QUANTITY0"><?= $Page->QUANTITY0->caption() ?></span></th>
<?php } ?>
<?php if ($Page->PROPOSEDQ->Visible) { // PROPOSEDQ ?>
        <th class="<?= $Page->PROPOSEDQ->headerCellClass() ?>"><span id="elh_PO_ITEM_PROPOSEDQ" class="PO_ITEM_PROPOSEDQ"><?= $Page->PROPOSEDQ->caption() ?></span></th>
<?php } ?>
<?php if ($Page->STOCKQ->Visible) { // STOCKQ ?>
        <th class="<?= $Page->STOCKQ->headerCellClass() ?>"><span id="elh_PO_ITEM_STOCKQ" class="PO_ITEM_STOCKQ"><?= $Page->STOCKQ->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_PO_ITEM_ORG_UNIT_CODE" class="PO_ITEM_ORG_UNIT_CODE">
<span<?= $Page->ORG_UNIT_CODE->viewAttributes() ?>>
<?= $Page->ORG_UNIT_CODE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->PO->Visible) { // PO ?>
        <td <?= $Page->PO->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_ITEM_PO" class="PO_ITEM_PO">
<span<?= $Page->PO->viewAttributes() ?>>
<?= $Page->PO->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->BRAND_ID->Visible) { // BRAND_ID ?>
        <td <?= $Page->BRAND_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_ITEM_BRAND_ID" class="PO_ITEM_BRAND_ID">
<span<?= $Page->BRAND_ID->viewAttributes() ?>>
<?= $Page->BRAND_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ORDER_DATE->Visible) { // ORDER_DATE ?>
        <td <?= $Page->ORDER_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_ITEM_ORDER_DATE" class="PO_ITEM_ORDER_DATE">
<span<?= $Page->ORDER_DATE->viewAttributes() ?>>
<?= $Page->ORDER_DATE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->PO_NO->Visible) { // PO_NO ?>
        <td <?= $Page->PO_NO->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_ITEM_PO_NO" class="PO_ITEM_PO_NO">
<span<?= $Page->PO_NO->viewAttributes() ?>>
<?= $Page->PO_NO->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->PURCHASE_PRICE->Visible) { // PURCHASE_PRICE ?>
        <td <?= $Page->PURCHASE_PRICE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_ITEM_PURCHASE_PRICE" class="PO_ITEM_PURCHASE_PRICE">
<span<?= $Page->PURCHASE_PRICE->viewAttributes() ?>>
<?= $Page->PURCHASE_PRICE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ORDER_QUANTITY->Visible) { // ORDER_QUANTITY ?>
        <td <?= $Page->ORDER_QUANTITY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_ITEM_ORDER_QUANTITY" class="PO_ITEM_ORDER_QUANTITY">
<span<?= $Page->ORDER_QUANTITY->viewAttributes() ?>>
<?= $Page->ORDER_QUANTITY->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->RECEIVED_QUANTITY->Visible) { // RECEIVED_QUANTITY ?>
        <td <?= $Page->RECEIVED_QUANTITY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_ITEM_RECEIVED_QUANTITY" class="PO_ITEM_RECEIVED_QUANTITY">
<span<?= $Page->RECEIVED_QUANTITY->viewAttributes() ?>>
<?= $Page->RECEIVED_QUANTITY->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->MEASURE_ID->Visible) { // MEASURE_ID ?>
        <td <?= $Page->MEASURE_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_ITEM_MEASURE_ID" class="PO_ITEM_MEASURE_ID">
<span<?= $Page->MEASURE_ID->viewAttributes() ?>>
<?= $Page->MEASURE_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->DISCOUNT->Visible) { // DISCOUNT ?>
        <td <?= $Page->DISCOUNT->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_ITEM_DISCOUNT" class="PO_ITEM_DISCOUNT">
<span<?= $Page->DISCOUNT->viewAttributes() ?>>
<?= $Page->DISCOUNT->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->AMOUNT_PAID->Visible) { // AMOUNT_PAID ?>
        <td <?= $Page->AMOUNT_PAID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_ITEM_AMOUNT_PAID" class="PO_ITEM_AMOUNT_PAID">
<span<?= $Page->AMOUNT_PAID->viewAttributes() ?>>
<?= $Page->AMOUNT_PAID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ATP_DATE->Visible) { // ATP_DATE ?>
        <td <?= $Page->ATP_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_ITEM_ATP_DATE" class="PO_ITEM_ATP_DATE">
<span<?= $Page->ATP_DATE->viewAttributes() ?>>
<?= $Page->ATP_DATE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->DELIVERY_DATE->Visible) { // DELIVERY_DATE ?>
        <td <?= $Page->DELIVERY_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_ITEM_DELIVERY_DATE" class="PO_ITEM_DELIVERY_DATE">
<span<?= $Page->DELIVERY_DATE->viewAttributes() ?>>
<?= $Page->DELIVERY_DATE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->DESCRIPTION->Visible) { // DESCRIPTION ?>
        <td <?= $Page->DESCRIPTION->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_ITEM_DESCRIPTION" class="PO_ITEM_DESCRIPTION">
<span<?= $Page->DESCRIPTION->viewAttributes() ?>>
<?= $Page->DESCRIPTION->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
        <td <?= $Page->MODIFIED_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_ITEM_MODIFIED_DATE" class="PO_ITEM_MODIFIED_DATE">
<span<?= $Page->MODIFIED_DATE->viewAttributes() ?>>
<?= $Page->MODIFIED_DATE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
        <td <?= $Page->MODIFIED_BY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_ITEM_MODIFIED_BY" class="PO_ITEM_MODIFIED_BY">
<span<?= $Page->MODIFIED_BY->viewAttributes() ?>>
<?= $Page->MODIFIED_BY->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->company_id->Visible) { // company_id ?>
        <td <?= $Page->company_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_ITEM_company_id" class="PO_ITEM_company_id">
<span<?= $Page->company_id->viewAttributes() ?>>
<?= $Page->company_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->SIZE_KEMASAN->Visible) { // SIZE_KEMASAN ?>
        <td <?= $Page->SIZE_KEMASAN->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_ITEM_SIZE_KEMASAN" class="PO_ITEM_SIZE_KEMASAN">
<span<?= $Page->SIZE_KEMASAN->viewAttributes() ?>>
<?= $Page->SIZE_KEMASAN->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->MEASURE_ID2->Visible) { // MEASURE_ID2 ?>
        <td <?= $Page->MEASURE_ID2->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_ITEM_MEASURE_ID2" class="PO_ITEM_MEASURE_ID2">
<span<?= $Page->MEASURE_ID2->viewAttributes() ?>>
<?= $Page->MEASURE_ID2->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->SIZE_GOODS->Visible) { // SIZE_GOODS ?>
        <td <?= $Page->SIZE_GOODS->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_ITEM_SIZE_GOODS" class="PO_ITEM_SIZE_GOODS">
<span<?= $Page->SIZE_GOODS->viewAttributes() ?>>
<?= $Page->SIZE_GOODS->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->MEASURE_DOSIS->Visible) { // MEASURE_DOSIS ?>
        <td <?= $Page->MEASURE_DOSIS->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_ITEM_MEASURE_DOSIS" class="PO_ITEM_MEASURE_DOSIS">
<span<?= $Page->MEASURE_DOSIS->viewAttributes() ?>>
<?= $Page->MEASURE_DOSIS->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->QUANTITY->Visible) { // QUANTITY ?>
        <td <?= $Page->QUANTITY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_ITEM_QUANTITY" class="PO_ITEM_QUANTITY">
<span<?= $Page->QUANTITY->viewAttributes() ?>>
<?= $Page->QUANTITY->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->MEASURE_ID3->Visible) { // MEASURE_ID3 ?>
        <td <?= $Page->MEASURE_ID3->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_ITEM_MEASURE_ID3" class="PO_ITEM_MEASURE_ID3">
<span<?= $Page->MEASURE_ID3->viewAttributes() ?>>
<?= $Page->MEASURE_ID3->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ORDER_PRICE->Visible) { // ORDER_PRICE ?>
        <td <?= $Page->ORDER_PRICE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_ITEM_ORDER_PRICE" class="PO_ITEM_ORDER_PRICE">
<span<?= $Page->ORDER_PRICE->viewAttributes() ?>>
<?= $Page->ORDER_PRICE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->BRAND_NAME->Visible) { // BRAND_NAME ?>
        <td <?= $Page->BRAND_NAME->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_ITEM_BRAND_NAME" class="PO_ITEM_BRAND_NAME">
<span<?= $Page->BRAND_NAME->viewAttributes() ?>>
<?= $Page->BRAND_NAME->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ISCETAK->Visible) { // ISCETAK ?>
        <td <?= $Page->ISCETAK->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_ITEM_ISCETAK" class="PO_ITEM_ISCETAK">
<span<?= $Page->ISCETAK->viewAttributes() ?>>
<?= $Page->ISCETAK->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->PRINT_DATE->Visible) { // PRINT_DATE ?>
        <td <?= $Page->PRINT_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_ITEM_PRINT_DATE" class="PO_ITEM_PRINT_DATE">
<span<?= $Page->PRINT_DATE->viewAttributes() ?>>
<?= $Page->PRINT_DATE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->PRINTED_BY->Visible) { // PRINTED_BY ?>
        <td <?= $Page->PRINTED_BY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_ITEM_PRINTED_BY" class="PO_ITEM_PRINTED_BY">
<span<?= $Page->PRINTED_BY->viewAttributes() ?>>
<?= $Page->PRINTED_BY->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->PRINTQ->Visible) { // PRINTQ ?>
        <td <?= $Page->PRINTQ->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_ITEM_PRINTQ" class="PO_ITEM_PRINTQ">
<span<?= $Page->PRINTQ->viewAttributes() ?>>
<?= $Page->PRINTQ->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->DISCOUNTOFF->Visible) { // DISCOUNTOFF ?>
        <td <?= $Page->DISCOUNTOFF->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_ITEM_DISCOUNTOFF" class="PO_ITEM_DISCOUNTOFF">
<span<?= $Page->DISCOUNTOFF->viewAttributes() ?>>
<?= $Page->DISCOUNTOFF->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->IDX->Visible) { // IDX ?>
        <td <?= $Page->IDX->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_ITEM_IDX" class="PO_ITEM_IDX">
<span<?= $Page->IDX->viewAttributes() ?>>
<?= $Page->IDX->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->QUANTITY0->Visible) { // QUANTITY0 ?>
        <td <?= $Page->QUANTITY0->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_ITEM_QUANTITY0" class="PO_ITEM_QUANTITY0">
<span<?= $Page->QUANTITY0->viewAttributes() ?>>
<?= $Page->QUANTITY0->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->PROPOSEDQ->Visible) { // PROPOSEDQ ?>
        <td <?= $Page->PROPOSEDQ->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_ITEM_PROPOSEDQ" class="PO_ITEM_PROPOSEDQ">
<span<?= $Page->PROPOSEDQ->viewAttributes() ?>>
<?= $Page->PROPOSEDQ->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->STOCKQ->Visible) { // STOCKQ ?>
        <td <?= $Page->STOCKQ->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_ITEM_STOCKQ" class="PO_ITEM_STOCKQ">
<span<?= $Page->STOCKQ->viewAttributes() ?>>
<?= $Page->STOCKQ->getViewValue() ?></span>
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
