<?php

namespace PHPMaker2021\SIMRSSQLSERVERGUDANGFARMASI;

// Page object
$PoItemView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fPO_ITEMview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fPO_ITEMview = currentForm = new ew.Form("fPO_ITEMview", "view");
    loadjs.done("fPO_ITEMview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.PO_ITEM) ew.vars.tables.PO_ITEM = <?= JsonEncode(GetClientVar("tables", "PO_ITEM")) ?>;
</script>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $Page->ExportOptions->render("body") ?>
<?php $Page->OtherOptions->render("body") ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fPO_ITEMview" id="fPO_ITEMview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="PO_ITEM">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-bordered table-hover ew-view-table">
<?php if ($Page->ORG_UNIT_CODE->Visible) { // ORG_UNIT_CODE ?>
    <tr id="r_ORG_UNIT_CODE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_ITEM_ORG_UNIT_CODE"><?= $Page->ORG_UNIT_CODE->caption() ?></span></td>
        <td data-name="ORG_UNIT_CODE" <?= $Page->ORG_UNIT_CODE->cellAttributes() ?>>
<span id="el_PO_ITEM_ORG_UNIT_CODE">
<span<?= $Page->ORG_UNIT_CODE->viewAttributes() ?>>
<?= $Page->ORG_UNIT_CODE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->PO->Visible) { // PO ?>
    <tr id="r_PO">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_ITEM_PO"><?= $Page->PO->caption() ?></span></td>
        <td data-name="PO" <?= $Page->PO->cellAttributes() ?>>
<span id="el_PO_ITEM_PO">
<span<?= $Page->PO->viewAttributes() ?>>
<?= $Page->PO->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->BRAND_ID->Visible) { // BRAND_ID ?>
    <tr id="r_BRAND_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_ITEM_BRAND_ID"><?= $Page->BRAND_ID->caption() ?></span></td>
        <td data-name="BRAND_ID" <?= $Page->BRAND_ID->cellAttributes() ?>>
<span id="el_PO_ITEM_BRAND_ID">
<span<?= $Page->BRAND_ID->viewAttributes() ?>>
<?= $Page->BRAND_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ORDER_DATE->Visible) { // ORDER_DATE ?>
    <tr id="r_ORDER_DATE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_ITEM_ORDER_DATE"><?= $Page->ORDER_DATE->caption() ?></span></td>
        <td data-name="ORDER_DATE" <?= $Page->ORDER_DATE->cellAttributes() ?>>
<span id="el_PO_ITEM_ORDER_DATE">
<span<?= $Page->ORDER_DATE->viewAttributes() ?>>
<?= $Page->ORDER_DATE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->PO_NO->Visible) { // PO_NO ?>
    <tr id="r_PO_NO">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_ITEM_PO_NO"><?= $Page->PO_NO->caption() ?></span></td>
        <td data-name="PO_NO" <?= $Page->PO_NO->cellAttributes() ?>>
<span id="el_PO_ITEM_PO_NO">
<span<?= $Page->PO_NO->viewAttributes() ?>>
<?= $Page->PO_NO->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->PURCHASE_PRICE->Visible) { // PURCHASE_PRICE ?>
    <tr id="r_PURCHASE_PRICE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_ITEM_PURCHASE_PRICE"><?= $Page->PURCHASE_PRICE->caption() ?></span></td>
        <td data-name="PURCHASE_PRICE" <?= $Page->PURCHASE_PRICE->cellAttributes() ?>>
<span id="el_PO_ITEM_PURCHASE_PRICE">
<span<?= $Page->PURCHASE_PRICE->viewAttributes() ?>>
<?= $Page->PURCHASE_PRICE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ORDER_QUANTITY->Visible) { // ORDER_QUANTITY ?>
    <tr id="r_ORDER_QUANTITY">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_ITEM_ORDER_QUANTITY"><?= $Page->ORDER_QUANTITY->caption() ?></span></td>
        <td data-name="ORDER_QUANTITY" <?= $Page->ORDER_QUANTITY->cellAttributes() ?>>
<span id="el_PO_ITEM_ORDER_QUANTITY">
<span<?= $Page->ORDER_QUANTITY->viewAttributes() ?>>
<?= $Page->ORDER_QUANTITY->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->RECEIVED_QUANTITY->Visible) { // RECEIVED_QUANTITY ?>
    <tr id="r_RECEIVED_QUANTITY">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_ITEM_RECEIVED_QUANTITY"><?= $Page->RECEIVED_QUANTITY->caption() ?></span></td>
        <td data-name="RECEIVED_QUANTITY" <?= $Page->RECEIVED_QUANTITY->cellAttributes() ?>>
<span id="el_PO_ITEM_RECEIVED_QUANTITY">
<span<?= $Page->RECEIVED_QUANTITY->viewAttributes() ?>>
<?= $Page->RECEIVED_QUANTITY->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->MEASURE_ID->Visible) { // MEASURE_ID ?>
    <tr id="r_MEASURE_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_ITEM_MEASURE_ID"><?= $Page->MEASURE_ID->caption() ?></span></td>
        <td data-name="MEASURE_ID" <?= $Page->MEASURE_ID->cellAttributes() ?>>
<span id="el_PO_ITEM_MEASURE_ID">
<span<?= $Page->MEASURE_ID->viewAttributes() ?>>
<?= $Page->MEASURE_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->DISCOUNT->Visible) { // DISCOUNT ?>
    <tr id="r_DISCOUNT">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_ITEM_DISCOUNT"><?= $Page->DISCOUNT->caption() ?></span></td>
        <td data-name="DISCOUNT" <?= $Page->DISCOUNT->cellAttributes() ?>>
<span id="el_PO_ITEM_DISCOUNT">
<span<?= $Page->DISCOUNT->viewAttributes() ?>>
<?= $Page->DISCOUNT->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->AMOUNT_PAID->Visible) { // AMOUNT_PAID ?>
    <tr id="r_AMOUNT_PAID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_ITEM_AMOUNT_PAID"><?= $Page->AMOUNT_PAID->caption() ?></span></td>
        <td data-name="AMOUNT_PAID" <?= $Page->AMOUNT_PAID->cellAttributes() ?>>
<span id="el_PO_ITEM_AMOUNT_PAID">
<span<?= $Page->AMOUNT_PAID->viewAttributes() ?>>
<?= $Page->AMOUNT_PAID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ATP_DATE->Visible) { // ATP_DATE ?>
    <tr id="r_ATP_DATE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_ITEM_ATP_DATE"><?= $Page->ATP_DATE->caption() ?></span></td>
        <td data-name="ATP_DATE" <?= $Page->ATP_DATE->cellAttributes() ?>>
<span id="el_PO_ITEM_ATP_DATE">
<span<?= $Page->ATP_DATE->viewAttributes() ?>>
<?= $Page->ATP_DATE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->DELIVERY_DATE->Visible) { // DELIVERY_DATE ?>
    <tr id="r_DELIVERY_DATE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_ITEM_DELIVERY_DATE"><?= $Page->DELIVERY_DATE->caption() ?></span></td>
        <td data-name="DELIVERY_DATE" <?= $Page->DELIVERY_DATE->cellAttributes() ?>>
<span id="el_PO_ITEM_DELIVERY_DATE">
<span<?= $Page->DELIVERY_DATE->viewAttributes() ?>>
<?= $Page->DELIVERY_DATE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->DESCRIPTION->Visible) { // DESCRIPTION ?>
    <tr id="r_DESCRIPTION">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_ITEM_DESCRIPTION"><?= $Page->DESCRIPTION->caption() ?></span></td>
        <td data-name="DESCRIPTION" <?= $Page->DESCRIPTION->cellAttributes() ?>>
<span id="el_PO_ITEM_DESCRIPTION">
<span<?= $Page->DESCRIPTION->viewAttributes() ?>>
<?= $Page->DESCRIPTION->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
    <tr id="r_MODIFIED_DATE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_ITEM_MODIFIED_DATE"><?= $Page->MODIFIED_DATE->caption() ?></span></td>
        <td data-name="MODIFIED_DATE" <?= $Page->MODIFIED_DATE->cellAttributes() ?>>
<span id="el_PO_ITEM_MODIFIED_DATE">
<span<?= $Page->MODIFIED_DATE->viewAttributes() ?>>
<?= $Page->MODIFIED_DATE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
    <tr id="r_MODIFIED_BY">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_ITEM_MODIFIED_BY"><?= $Page->MODIFIED_BY->caption() ?></span></td>
        <td data-name="MODIFIED_BY" <?= $Page->MODIFIED_BY->cellAttributes() ?>>
<span id="el_PO_ITEM_MODIFIED_BY">
<span<?= $Page->MODIFIED_BY->viewAttributes() ?>>
<?= $Page->MODIFIED_BY->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->company_id->Visible) { // company_id ?>
    <tr id="r_company_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_ITEM_company_id"><?= $Page->company_id->caption() ?></span></td>
        <td data-name="company_id" <?= $Page->company_id->cellAttributes() ?>>
<span id="el_PO_ITEM_company_id">
<span<?= $Page->company_id->viewAttributes() ?>>
<?= $Page->company_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->SIZE_KEMASAN->Visible) { // SIZE_KEMASAN ?>
    <tr id="r_SIZE_KEMASAN">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_ITEM_SIZE_KEMASAN"><?= $Page->SIZE_KEMASAN->caption() ?></span></td>
        <td data-name="SIZE_KEMASAN" <?= $Page->SIZE_KEMASAN->cellAttributes() ?>>
<span id="el_PO_ITEM_SIZE_KEMASAN">
<span<?= $Page->SIZE_KEMASAN->viewAttributes() ?>>
<?= $Page->SIZE_KEMASAN->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->MEASURE_ID2->Visible) { // MEASURE_ID2 ?>
    <tr id="r_MEASURE_ID2">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_ITEM_MEASURE_ID2"><?= $Page->MEASURE_ID2->caption() ?></span></td>
        <td data-name="MEASURE_ID2" <?= $Page->MEASURE_ID2->cellAttributes() ?>>
<span id="el_PO_ITEM_MEASURE_ID2">
<span<?= $Page->MEASURE_ID2->viewAttributes() ?>>
<?= $Page->MEASURE_ID2->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->SIZE_GOODS->Visible) { // SIZE_GOODS ?>
    <tr id="r_SIZE_GOODS">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_ITEM_SIZE_GOODS"><?= $Page->SIZE_GOODS->caption() ?></span></td>
        <td data-name="SIZE_GOODS" <?= $Page->SIZE_GOODS->cellAttributes() ?>>
<span id="el_PO_ITEM_SIZE_GOODS">
<span<?= $Page->SIZE_GOODS->viewAttributes() ?>>
<?= $Page->SIZE_GOODS->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->MEASURE_DOSIS->Visible) { // MEASURE_DOSIS ?>
    <tr id="r_MEASURE_DOSIS">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_ITEM_MEASURE_DOSIS"><?= $Page->MEASURE_DOSIS->caption() ?></span></td>
        <td data-name="MEASURE_DOSIS" <?= $Page->MEASURE_DOSIS->cellAttributes() ?>>
<span id="el_PO_ITEM_MEASURE_DOSIS">
<span<?= $Page->MEASURE_DOSIS->viewAttributes() ?>>
<?= $Page->MEASURE_DOSIS->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->QUANTITY->Visible) { // QUANTITY ?>
    <tr id="r_QUANTITY">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_ITEM_QUANTITY"><?= $Page->QUANTITY->caption() ?></span></td>
        <td data-name="QUANTITY" <?= $Page->QUANTITY->cellAttributes() ?>>
<span id="el_PO_ITEM_QUANTITY">
<span<?= $Page->QUANTITY->viewAttributes() ?>>
<?= $Page->QUANTITY->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->MEASURE_ID3->Visible) { // MEASURE_ID3 ?>
    <tr id="r_MEASURE_ID3">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_ITEM_MEASURE_ID3"><?= $Page->MEASURE_ID3->caption() ?></span></td>
        <td data-name="MEASURE_ID3" <?= $Page->MEASURE_ID3->cellAttributes() ?>>
<span id="el_PO_ITEM_MEASURE_ID3">
<span<?= $Page->MEASURE_ID3->viewAttributes() ?>>
<?= $Page->MEASURE_ID3->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ORDER_PRICE->Visible) { // ORDER_PRICE ?>
    <tr id="r_ORDER_PRICE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_ITEM_ORDER_PRICE"><?= $Page->ORDER_PRICE->caption() ?></span></td>
        <td data-name="ORDER_PRICE" <?= $Page->ORDER_PRICE->cellAttributes() ?>>
<span id="el_PO_ITEM_ORDER_PRICE">
<span<?= $Page->ORDER_PRICE->viewAttributes() ?>>
<?= $Page->ORDER_PRICE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->BRAND_NAME->Visible) { // BRAND_NAME ?>
    <tr id="r_BRAND_NAME">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_ITEM_BRAND_NAME"><?= $Page->BRAND_NAME->caption() ?></span></td>
        <td data-name="BRAND_NAME" <?= $Page->BRAND_NAME->cellAttributes() ?>>
<span id="el_PO_ITEM_BRAND_NAME">
<span<?= $Page->BRAND_NAME->viewAttributes() ?>>
<?= $Page->BRAND_NAME->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ISCETAK->Visible) { // ISCETAK ?>
    <tr id="r_ISCETAK">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_ITEM_ISCETAK"><?= $Page->ISCETAK->caption() ?></span></td>
        <td data-name="ISCETAK" <?= $Page->ISCETAK->cellAttributes() ?>>
<span id="el_PO_ITEM_ISCETAK">
<span<?= $Page->ISCETAK->viewAttributes() ?>>
<?= $Page->ISCETAK->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->PRINT_DATE->Visible) { // PRINT_DATE ?>
    <tr id="r_PRINT_DATE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_ITEM_PRINT_DATE"><?= $Page->PRINT_DATE->caption() ?></span></td>
        <td data-name="PRINT_DATE" <?= $Page->PRINT_DATE->cellAttributes() ?>>
<span id="el_PO_ITEM_PRINT_DATE">
<span<?= $Page->PRINT_DATE->viewAttributes() ?>>
<?= $Page->PRINT_DATE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->PRINTED_BY->Visible) { // PRINTED_BY ?>
    <tr id="r_PRINTED_BY">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_ITEM_PRINTED_BY"><?= $Page->PRINTED_BY->caption() ?></span></td>
        <td data-name="PRINTED_BY" <?= $Page->PRINTED_BY->cellAttributes() ?>>
<span id="el_PO_ITEM_PRINTED_BY">
<span<?= $Page->PRINTED_BY->viewAttributes() ?>>
<?= $Page->PRINTED_BY->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->PRINTQ->Visible) { // PRINTQ ?>
    <tr id="r_PRINTQ">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_ITEM_PRINTQ"><?= $Page->PRINTQ->caption() ?></span></td>
        <td data-name="PRINTQ" <?= $Page->PRINTQ->cellAttributes() ?>>
<span id="el_PO_ITEM_PRINTQ">
<span<?= $Page->PRINTQ->viewAttributes() ?>>
<?= $Page->PRINTQ->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->DISCOUNTOFF->Visible) { // DISCOUNTOFF ?>
    <tr id="r_DISCOUNTOFF">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_ITEM_DISCOUNTOFF"><?= $Page->DISCOUNTOFF->caption() ?></span></td>
        <td data-name="DISCOUNTOFF" <?= $Page->DISCOUNTOFF->cellAttributes() ?>>
<span id="el_PO_ITEM_DISCOUNTOFF">
<span<?= $Page->DISCOUNTOFF->viewAttributes() ?>>
<?= $Page->DISCOUNTOFF->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->IDX->Visible) { // IDX ?>
    <tr id="r_IDX">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_ITEM_IDX"><?= $Page->IDX->caption() ?></span></td>
        <td data-name="IDX" <?= $Page->IDX->cellAttributes() ?>>
<span id="el_PO_ITEM_IDX">
<span<?= $Page->IDX->viewAttributes() ?>>
<?= $Page->IDX->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->QUANTITY0->Visible) { // QUANTITY0 ?>
    <tr id="r_QUANTITY0">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_ITEM_QUANTITY0"><?= $Page->QUANTITY0->caption() ?></span></td>
        <td data-name="QUANTITY0" <?= $Page->QUANTITY0->cellAttributes() ?>>
<span id="el_PO_ITEM_QUANTITY0">
<span<?= $Page->QUANTITY0->viewAttributes() ?>>
<?= $Page->QUANTITY0->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->PROPOSEDQ->Visible) { // PROPOSEDQ ?>
    <tr id="r_PROPOSEDQ">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_ITEM_PROPOSEDQ"><?= $Page->PROPOSEDQ->caption() ?></span></td>
        <td data-name="PROPOSEDQ" <?= $Page->PROPOSEDQ->cellAttributes() ?>>
<span id="el_PO_ITEM_PROPOSEDQ">
<span<?= $Page->PROPOSEDQ->viewAttributes() ?>>
<?= $Page->PROPOSEDQ->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->STOCKQ->Visible) { // STOCKQ ?>
    <tr id="r_STOCKQ">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_ITEM_STOCKQ"><?= $Page->STOCKQ->caption() ?></span></td>
        <td data-name="STOCKQ" <?= $Page->STOCKQ->cellAttributes() ?>>
<span id="el_PO_ITEM_STOCKQ">
<span<?= $Page->STOCKQ->viewAttributes() ?>>
<?= $Page->STOCKQ->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
