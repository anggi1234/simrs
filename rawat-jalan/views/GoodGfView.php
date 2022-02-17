<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAJALALTER;

// Page object
$GoodGfView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fGOOD_GFview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fGOOD_GFview = currentForm = new ew.Form("fGOOD_GFview", "view");
    loadjs.done("fGOOD_GFview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.GOOD_GF) ew.vars.tables.GOOD_GF = <?= JsonEncode(GetClientVar("tables", "GOOD_GF")) ?>;
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
<form name="fGOOD_GFview" id="fGOOD_GFview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="GOOD_GF">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-bordered table-hover ew-view-table">
<?php if ($Page->ORG_UNIT_CODE->Visible) { // ORG_UNIT_CODE ?>
    <tr id="r_ORG_UNIT_CODE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOOD_GF_ORG_UNIT_CODE"><?= $Page->ORG_UNIT_CODE->caption() ?></span></td>
        <td data-name="ORG_UNIT_CODE" <?= $Page->ORG_UNIT_CODE->cellAttributes() ?>>
<span id="el_GOOD_GF_ORG_UNIT_CODE">
<span<?= $Page->ORG_UNIT_CODE->viewAttributes() ?>>
<?= $Page->ORG_UNIT_CODE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ITEM_ID->Visible) { // ITEM_ID ?>
    <tr id="r_ITEM_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOOD_GF_ITEM_ID"><?= $Page->ITEM_ID->caption() ?></span></td>
        <td data-name="ITEM_ID" <?= $Page->ITEM_ID->cellAttributes() ?>>
<span id="el_GOOD_GF_ITEM_ID">
<span<?= $Page->ITEM_ID->viewAttributes() ?>>
<?= $Page->ITEM_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ORG_ID->Visible) { // ORG_ID ?>
    <tr id="r_ORG_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOOD_GF_ORG_ID"><?= $Page->ORG_ID->caption() ?></span></td>
        <td data-name="ORG_ID" <?= $Page->ORG_ID->cellAttributes() ?>>
<span id="el_GOOD_GF_ORG_ID">
<span<?= $Page->ORG_ID->viewAttributes() ?>>
<?= $Page->ORG_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->BATCH_NO->Visible) { // BATCH_NO ?>
    <tr id="r_BATCH_NO">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOOD_GF_BATCH_NO"><?= $Page->BATCH_NO->caption() ?></span></td>
        <td data-name="BATCH_NO" <?= $Page->BATCH_NO->cellAttributes() ?>>
<span id="el_GOOD_GF_BATCH_NO">
<span<?= $Page->BATCH_NO->viewAttributes() ?>>
<?= $Page->BATCH_NO->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->BRAND_ID->Visible) { // BRAND_ID ?>
    <tr id="r_BRAND_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOOD_GF_BRAND_ID"><?= $Page->BRAND_ID->caption() ?></span></td>
        <td data-name="BRAND_ID" <?= $Page->BRAND_ID->cellAttributes() ?>>
<span id="el_GOOD_GF_BRAND_ID">
<span<?= $Page->BRAND_ID->viewAttributes() ?>>
<?= $Page->BRAND_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->BRAND_NAME->Visible) { // BRAND_NAME ?>
    <tr id="r_BRAND_NAME">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOOD_GF_BRAND_NAME"><?= $Page->BRAND_NAME->caption() ?></span></td>
        <td data-name="BRAND_NAME" <?= $Page->BRAND_NAME->cellAttributes() ?>>
<span id="el_GOOD_GF_BRAND_NAME">
<span<?= $Page->BRAND_NAME->viewAttributes() ?>>
<?= $Page->BRAND_NAME->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ROOMS_ID->Visible) { // ROOMS_ID ?>
    <tr id="r_ROOMS_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOOD_GF_ROOMS_ID"><?= $Page->ROOMS_ID->caption() ?></span></td>
        <td data-name="ROOMS_ID" <?= $Page->ROOMS_ID->cellAttributes() ?>>
<span id="el_GOOD_GF_ROOMS_ID">
<span<?= $Page->ROOMS_ID->viewAttributes() ?>>
<?= $Page->ROOMS_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->SHELF_NO->Visible) { // SHELF_NO ?>
    <tr id="r_SHELF_NO">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOOD_GF_SHELF_NO"><?= $Page->SHELF_NO->caption() ?></span></td>
        <td data-name="SHELF_NO" <?= $Page->SHELF_NO->cellAttributes() ?>>
<span id="el_GOOD_GF_SHELF_NO">
<span<?= $Page->SHELF_NO->viewAttributes() ?>>
<?= $Page->SHELF_NO->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->EXPIRY_DATE->Visible) { // EXPIRY_DATE ?>
    <tr id="r_EXPIRY_DATE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOOD_GF_EXPIRY_DATE"><?= $Page->EXPIRY_DATE->caption() ?></span></td>
        <td data-name="EXPIRY_DATE" <?= $Page->EXPIRY_DATE->cellAttributes() ?>>
<span id="el_GOOD_GF_EXPIRY_DATE">
<span<?= $Page->EXPIRY_DATE->viewAttributes() ?>>
<?= $Page->EXPIRY_DATE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->SERIAL_NB->Visible) { // SERIAL_NB ?>
    <tr id="r_SERIAL_NB">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOOD_GF_SERIAL_NB"><?= $Page->SERIAL_NB->caption() ?></span></td>
        <td data-name="SERIAL_NB" <?= $Page->SERIAL_NB->cellAttributes() ?>>
<span id="el_GOOD_GF_SERIAL_NB">
<span<?= $Page->SERIAL_NB->viewAttributes() ?>>
<?= $Page->SERIAL_NB->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->FROM_ROOMS_ID->Visible) { // FROM_ROOMS_ID ?>
    <tr id="r_FROM_ROOMS_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOOD_GF_FROM_ROOMS_ID"><?= $Page->FROM_ROOMS_ID->caption() ?></span></td>
        <td data-name="FROM_ROOMS_ID" <?= $Page->FROM_ROOMS_ID->cellAttributes() ?>>
<span id="el_GOOD_GF_FROM_ROOMS_ID">
<span<?= $Page->FROM_ROOMS_ID->viewAttributes() ?>>
<?= $Page->FROM_ROOMS_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ISOUTLET->Visible) { // ISOUTLET ?>
    <tr id="r_ISOUTLET">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOOD_GF_ISOUTLET"><?= $Page->ISOUTLET->caption() ?></span></td>
        <td data-name="ISOUTLET" <?= $Page->ISOUTLET->cellAttributes() ?>>
<span id="el_GOOD_GF_ISOUTLET">
<span<?= $Page->ISOUTLET->viewAttributes() ?>>
<?= $Page->ISOUTLET->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->QUANTITY->Visible) { // QUANTITY ?>
    <tr id="r_QUANTITY">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOOD_GF_QUANTITY"><?= $Page->QUANTITY->caption() ?></span></td>
        <td data-name="QUANTITY" <?= $Page->QUANTITY->cellAttributes() ?>>
<span id="el_GOOD_GF_QUANTITY">
<span<?= $Page->QUANTITY->viewAttributes() ?>>
<?= $Page->QUANTITY->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->MEASURE_ID->Visible) { // MEASURE_ID ?>
    <tr id="r_MEASURE_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOOD_GF_MEASURE_ID"><?= $Page->MEASURE_ID->caption() ?></span></td>
        <td data-name="MEASURE_ID" <?= $Page->MEASURE_ID->cellAttributes() ?>>
<span id="el_GOOD_GF_MEASURE_ID">
<span<?= $Page->MEASURE_ID->viewAttributes() ?>>
<?= $Page->MEASURE_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->DISTRIBUTION_TYPE->Visible) { // DISTRIBUTION_TYPE ?>
    <tr id="r_DISTRIBUTION_TYPE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOOD_GF_DISTRIBUTION_TYPE"><?= $Page->DISTRIBUTION_TYPE->caption() ?></span></td>
        <td data-name="DISTRIBUTION_TYPE" <?= $Page->DISTRIBUTION_TYPE->cellAttributes() ?>>
<span id="el_GOOD_GF_DISTRIBUTION_TYPE">
<span<?= $Page->DISTRIBUTION_TYPE->viewAttributes() ?>>
<?= $Page->DISTRIBUTION_TYPE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->CONDITION->Visible) { // CONDITION ?>
    <tr id="r_CONDITION">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOOD_GF_CONDITION"><?= $Page->CONDITION->caption() ?></span></td>
        <td data-name="CONDITION" <?= $Page->CONDITION->cellAttributes() ?>>
<span id="el_GOOD_GF_CONDITION">
<span<?= $Page->CONDITION->viewAttributes() ?>>
<?= $Page->CONDITION->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ALLOCATED_DATE->Visible) { // ALLOCATED_DATE ?>
    <tr id="r_ALLOCATED_DATE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOOD_GF_ALLOCATED_DATE"><?= $Page->ALLOCATED_DATE->caption() ?></span></td>
        <td data-name="ALLOCATED_DATE" <?= $Page->ALLOCATED_DATE->cellAttributes() ?>>
<span id="el_GOOD_GF_ALLOCATED_DATE">
<span<?= $Page->ALLOCATED_DATE->viewAttributes() ?>>
<?= $Page->ALLOCATED_DATE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->STOCKOPNAME_DATE->Visible) { // STOCKOPNAME_DATE ?>
    <tr id="r_STOCKOPNAME_DATE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOOD_GF_STOCKOPNAME_DATE"><?= $Page->STOCKOPNAME_DATE->caption() ?></span></td>
        <td data-name="STOCKOPNAME_DATE" <?= $Page->STOCKOPNAME_DATE->cellAttributes() ?>>
<span id="el_GOOD_GF_STOCKOPNAME_DATE">
<span<?= $Page->STOCKOPNAME_DATE->viewAttributes() ?>>
<?= $Page->STOCKOPNAME_DATE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->INVOICE_ID->Visible) { // INVOICE_ID ?>
    <tr id="r_INVOICE_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOOD_GF_INVOICE_ID"><?= $Page->INVOICE_ID->caption() ?></span></td>
        <td data-name="INVOICE_ID" <?= $Page->INVOICE_ID->cellAttributes() ?>>
<span id="el_GOOD_GF_INVOICE_ID">
<span<?= $Page->INVOICE_ID->viewAttributes() ?>>
<?= $Page->INVOICE_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ALLOCATED_FROM->Visible) { // ALLOCATED_FROM ?>
    <tr id="r_ALLOCATED_FROM">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOOD_GF_ALLOCATED_FROM"><?= $Page->ALLOCATED_FROM->caption() ?></span></td>
        <td data-name="ALLOCATED_FROM" <?= $Page->ALLOCATED_FROM->cellAttributes() ?>>
<span id="el_GOOD_GF_ALLOCATED_FROM">
<span<?= $Page->ALLOCATED_FROM->viewAttributes() ?>>
<?= $Page->ALLOCATED_FROM->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->PRICE->Visible) { // PRICE ?>
    <tr id="r_PRICE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOOD_GF_PRICE"><?= $Page->PRICE->caption() ?></span></td>
        <td data-name="PRICE" <?= $Page->PRICE->cellAttributes() ?>>
<span id="el_GOOD_GF_PRICE">
<span<?= $Page->PRICE->viewAttributes() ?>>
<?= $Page->PRICE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->DISCOUNT->Visible) { // DISCOUNT ?>
    <tr id="r_DISCOUNT">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOOD_GF_DISCOUNT"><?= $Page->DISCOUNT->caption() ?></span></td>
        <td data-name="DISCOUNT" <?= $Page->DISCOUNT->cellAttributes() ?>>
<span id="el_GOOD_GF_DISCOUNT">
<span<?= $Page->DISCOUNT->viewAttributes() ?>>
<?= $Page->DISCOUNT->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->DISCOUNT2->Visible) { // DISCOUNT2 ?>
    <tr id="r_DISCOUNT2">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOOD_GF_DISCOUNT2"><?= $Page->DISCOUNT2->caption() ?></span></td>
        <td data-name="DISCOUNT2" <?= $Page->DISCOUNT2->cellAttributes() ?>>
<span id="el_GOOD_GF_DISCOUNT2">
<span<?= $Page->DISCOUNT2->viewAttributes() ?>>
<?= $Page->DISCOUNT2->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->DISCOUNTOFF->Visible) { // DISCOUNTOFF ?>
    <tr id="r_DISCOUNTOFF">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOOD_GF_DISCOUNTOFF"><?= $Page->DISCOUNTOFF->caption() ?></span></td>
        <td data-name="DISCOUNTOFF" <?= $Page->DISCOUNTOFF->cellAttributes() ?>>
<span id="el_GOOD_GF_DISCOUNTOFF">
<span<?= $Page->DISCOUNTOFF->viewAttributes() ?>>
<?= $Page->DISCOUNTOFF->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ORG_UNIT_FROM->Visible) { // ORG_UNIT_FROM ?>
    <tr id="r_ORG_UNIT_FROM">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOOD_GF_ORG_UNIT_FROM"><?= $Page->ORG_UNIT_FROM->caption() ?></span></td>
        <td data-name="ORG_UNIT_FROM" <?= $Page->ORG_UNIT_FROM->cellAttributes() ?>>
<span id="el_GOOD_GF_ORG_UNIT_FROM">
<span<?= $Page->ORG_UNIT_FROM->viewAttributes() ?>>
<?= $Page->ORG_UNIT_FROM->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ITEM_ID_FROM->Visible) { // ITEM_ID_FROM ?>
    <tr id="r_ITEM_ID_FROM">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOOD_GF_ITEM_ID_FROM"><?= $Page->ITEM_ID_FROM->caption() ?></span></td>
        <td data-name="ITEM_ID_FROM" <?= $Page->ITEM_ID_FROM->cellAttributes() ?>>
<span id="el_GOOD_GF_ITEM_ID_FROM">
<span<?= $Page->ITEM_ID_FROM->viewAttributes() ?>>
<?= $Page->ITEM_ID_FROM->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
    <tr id="r_MODIFIED_DATE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOOD_GF_MODIFIED_DATE"><?= $Page->MODIFIED_DATE->caption() ?></span></td>
        <td data-name="MODIFIED_DATE" <?= $Page->MODIFIED_DATE->cellAttributes() ?>>
<span id="el_GOOD_GF_MODIFIED_DATE">
<span<?= $Page->MODIFIED_DATE->viewAttributes() ?>>
<?= $Page->MODIFIED_DATE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
    <tr id="r_MODIFIED_BY">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOOD_GF_MODIFIED_BY"><?= $Page->MODIFIED_BY->caption() ?></span></td>
        <td data-name="MODIFIED_BY" <?= $Page->MODIFIED_BY->cellAttributes() ?>>
<span id="el_GOOD_GF_MODIFIED_BY">
<span<?= $Page->MODIFIED_BY->viewAttributes() ?>>
<?= $Page->MODIFIED_BY->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->STOCK_OPNAME->Visible) { // STOCK_OPNAME ?>
    <tr id="r_STOCK_OPNAME">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOOD_GF_STOCK_OPNAME"><?= $Page->STOCK_OPNAME->caption() ?></span></td>
        <td data-name="STOCK_OPNAME" <?= $Page->STOCK_OPNAME->cellAttributes() ?>>
<span id="el_GOOD_GF_STOCK_OPNAME">
<span<?= $Page->STOCK_OPNAME->viewAttributes() ?>>
<?= $Page->STOCK_OPNAME->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->STOK_AWAL->Visible) { // STOK_AWAL ?>
    <tr id="r_STOK_AWAL">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOOD_GF_STOK_AWAL"><?= $Page->STOK_AWAL->caption() ?></span></td>
        <td data-name="STOK_AWAL" <?= $Page->STOK_AWAL->cellAttributes() ?>>
<span id="el_GOOD_GF_STOK_AWAL">
<span<?= $Page->STOK_AWAL->viewAttributes() ?>>
<?= $Page->STOK_AWAL->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->STOCK_LALU->Visible) { // STOCK_LALU ?>
    <tr id="r_STOCK_LALU">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOOD_GF_STOCK_LALU"><?= $Page->STOCK_LALU->caption() ?></span></td>
        <td data-name="STOCK_LALU" <?= $Page->STOCK_LALU->cellAttributes() ?>>
<span id="el_GOOD_GF_STOCK_LALU">
<span<?= $Page->STOCK_LALU->viewAttributes() ?>>
<?= $Page->STOCK_LALU->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->STOCK_KOREKSI->Visible) { // STOCK_KOREKSI ?>
    <tr id="r_STOCK_KOREKSI">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOOD_GF_STOCK_KOREKSI"><?= $Page->STOCK_KOREKSI->caption() ?></span></td>
        <td data-name="STOCK_KOREKSI" <?= $Page->STOCK_KOREKSI->cellAttributes() ?>>
<span id="el_GOOD_GF_STOCK_KOREKSI">
<span<?= $Page->STOCK_KOREKSI->viewAttributes() ?>>
<?= $Page->STOCK_KOREKSI->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->DITERIMA->Visible) { // DITERIMA ?>
    <tr id="r_DITERIMA">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOOD_GF_DITERIMA"><?= $Page->DITERIMA->caption() ?></span></td>
        <td data-name="DITERIMA" <?= $Page->DITERIMA->cellAttributes() ?>>
<span id="el_GOOD_GF_DITERIMA">
<span<?= $Page->DITERIMA->viewAttributes() ?>>
<?= $Page->DITERIMA->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->DISTRIBUSI->Visible) { // DISTRIBUSI ?>
    <tr id="r_DISTRIBUSI">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOOD_GF_DISTRIBUSI"><?= $Page->DISTRIBUSI->caption() ?></span></td>
        <td data-name="DISTRIBUSI" <?= $Page->DISTRIBUSI->cellAttributes() ?>>
<span id="el_GOOD_GF_DISTRIBUSI">
<span<?= $Page->DISTRIBUSI->viewAttributes() ?>>
<?= $Page->DISTRIBUSI->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->DIJUAL->Visible) { // DIJUAL ?>
    <tr id="r_DIJUAL">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOOD_GF_DIJUAL"><?= $Page->DIJUAL->caption() ?></span></td>
        <td data-name="DIJUAL" <?= $Page->DIJUAL->cellAttributes() ?>>
<span id="el_GOOD_GF_DIJUAL">
<span<?= $Page->DIJUAL->viewAttributes() ?>>
<?= $Page->DIJUAL->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->DIHAPUS->Visible) { // DIHAPUS ?>
    <tr id="r_DIHAPUS">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOOD_GF_DIHAPUS"><?= $Page->DIHAPUS->caption() ?></span></td>
        <td data-name="DIHAPUS" <?= $Page->DIHAPUS->cellAttributes() ?>>
<span id="el_GOOD_GF_DIHAPUS">
<span<?= $Page->DIHAPUS->viewAttributes() ?>>
<?= $Page->DIHAPUS->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->DIMINTA->Visible) { // DIMINTA ?>
    <tr id="r_DIMINTA">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOOD_GF_DIMINTA"><?= $Page->DIMINTA->caption() ?></span></td>
        <td data-name="DIMINTA" <?= $Page->DIMINTA->cellAttributes() ?>>
<span id="el_GOOD_GF_DIMINTA">
<span<?= $Page->DIMINTA->viewAttributes() ?>>
<?= $Page->DIMINTA->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->DIRETUR->Visible) { // DIRETUR ?>
    <tr id="r_DIRETUR">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOOD_GF_DIRETUR"><?= $Page->DIRETUR->caption() ?></span></td>
        <td data-name="DIRETUR" <?= $Page->DIRETUR->cellAttributes() ?>>
<span id="el_GOOD_GF_DIRETUR">
<span<?= $Page->DIRETUR->viewAttributes() ?>>
<?= $Page->DIRETUR->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->PO->Visible) { // PO ?>
    <tr id="r_PO">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOOD_GF_PO"><?= $Page->PO->caption() ?></span></td>
        <td data-name="PO" <?= $Page->PO->cellAttributes() ?>>
<span id="el_GOOD_GF_PO">
<span<?= $Page->PO->viewAttributes() ?>>
<?= $Page->PO->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->COMPANY_ID->Visible) { // COMPANY_ID ?>
    <tr id="r_COMPANY_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOOD_GF_COMPANY_ID"><?= $Page->COMPANY_ID->caption() ?></span></td>
        <td data-name="COMPANY_ID" <?= $Page->COMPANY_ID->cellAttributes() ?>>
<span id="el_GOOD_GF_COMPANY_ID">
<span<?= $Page->COMPANY_ID->viewAttributes() ?>>
<?= $Page->COMPANY_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->FUND_ID->Visible) { // FUND_ID ?>
    <tr id="r_FUND_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOOD_GF_FUND_ID"><?= $Page->FUND_ID->caption() ?></span></td>
        <td data-name="FUND_ID" <?= $Page->FUND_ID->cellAttributes() ?>>
<span id="el_GOOD_GF_FUND_ID">
<span<?= $Page->FUND_ID->viewAttributes() ?>>
<?= $Page->FUND_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->INVOICE_ID2->Visible) { // INVOICE_ID2 ?>
    <tr id="r_INVOICE_ID2">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOOD_GF_INVOICE_ID2"><?= $Page->INVOICE_ID2->caption() ?></span></td>
        <td data-name="INVOICE_ID2" <?= $Page->INVOICE_ID2->cellAttributes() ?>>
<span id="el_GOOD_GF_INVOICE_ID2">
<span<?= $Page->INVOICE_ID2->viewAttributes() ?>>
<?= $Page->INVOICE_ID2->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->MEASURE_ID3->Visible) { // MEASURE_ID3 ?>
    <tr id="r_MEASURE_ID3">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOOD_GF_MEASURE_ID3"><?= $Page->MEASURE_ID3->caption() ?></span></td>
        <td data-name="MEASURE_ID3" <?= $Page->MEASURE_ID3->cellAttributes() ?>>
<span id="el_GOOD_GF_MEASURE_ID3">
<span<?= $Page->MEASURE_ID3->viewAttributes() ?>>
<?= $Page->MEASURE_ID3->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->SIZE_KEMASAN->Visible) { // SIZE_KEMASAN ?>
    <tr id="r_SIZE_KEMASAN">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOOD_GF_SIZE_KEMASAN"><?= $Page->SIZE_KEMASAN->caption() ?></span></td>
        <td data-name="SIZE_KEMASAN" <?= $Page->SIZE_KEMASAN->cellAttributes() ?>>
<span id="el_GOOD_GF_SIZE_KEMASAN">
<span<?= $Page->SIZE_KEMASAN->viewAttributes() ?>>
<?= $Page->SIZE_KEMASAN->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->MEASURE_ID2->Visible) { // MEASURE_ID2 ?>
    <tr id="r_MEASURE_ID2">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOOD_GF_MEASURE_ID2"><?= $Page->MEASURE_ID2->caption() ?></span></td>
        <td data-name="MEASURE_ID2" <?= $Page->MEASURE_ID2->cellAttributes() ?>>
<span id="el_GOOD_GF_MEASURE_ID2">
<span<?= $Page->MEASURE_ID2->viewAttributes() ?>>
<?= $Page->MEASURE_ID2->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->RETUR_ID->Visible) { // RETUR_ID ?>
    <tr id="r_RETUR_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOOD_GF_RETUR_ID"><?= $Page->RETUR_ID->caption() ?></span></td>
        <td data-name="RETUR_ID" <?= $Page->RETUR_ID->cellAttributes() ?>>
<span id="el_GOOD_GF_RETUR_ID">
<span<?= $Page->RETUR_ID->viewAttributes() ?>>
<?= $Page->RETUR_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->SIZE_GOODS->Visible) { // SIZE_GOODS ?>
    <tr id="r_SIZE_GOODS">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOOD_GF_SIZE_GOODS"><?= $Page->SIZE_GOODS->caption() ?></span></td>
        <td data-name="SIZE_GOODS" <?= $Page->SIZE_GOODS->cellAttributes() ?>>
<span id="el_GOOD_GF_SIZE_GOODS">
<span<?= $Page->SIZE_GOODS->viewAttributes() ?>>
<?= $Page->SIZE_GOODS->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->MEASURE_DOSIS->Visible) { // MEASURE_DOSIS ?>
    <tr id="r_MEASURE_DOSIS">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOOD_GF_MEASURE_DOSIS"><?= $Page->MEASURE_DOSIS->caption() ?></span></td>
        <td data-name="MEASURE_DOSIS" <?= $Page->MEASURE_DOSIS->cellAttributes() ?>>
<span id="el_GOOD_GF_MEASURE_DOSIS">
<span<?= $Page->MEASURE_DOSIS->viewAttributes() ?>>
<?= $Page->MEASURE_DOSIS->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ORDER_PRICE->Visible) { // ORDER_PRICE ?>
    <tr id="r_ORDER_PRICE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOOD_GF_ORDER_PRICE"><?= $Page->ORDER_PRICE->caption() ?></span></td>
        <td data-name="ORDER_PRICE" <?= $Page->ORDER_PRICE->cellAttributes() ?>>
<span id="el_GOOD_GF_ORDER_PRICE">
<span<?= $Page->ORDER_PRICE->viewAttributes() ?>>
<?= $Page->ORDER_PRICE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->STOCK_AVAILABLE->Visible) { // STOCK_AVAILABLE ?>
    <tr id="r_STOCK_AVAILABLE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOOD_GF_STOCK_AVAILABLE"><?= $Page->STOCK_AVAILABLE->caption() ?></span></td>
        <td data-name="STOCK_AVAILABLE" <?= $Page->STOCK_AVAILABLE->cellAttributes() ?>>
<span id="el_GOOD_GF_STOCK_AVAILABLE">
<span<?= $Page->STOCK_AVAILABLE->viewAttributes() ?>>
<?= $Page->STOCK_AVAILABLE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->STATUS_PASIEN_ID->Visible) { // STATUS_PASIEN_ID ?>
    <tr id="r_STATUS_PASIEN_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOOD_GF_STATUS_PASIEN_ID"><?= $Page->STATUS_PASIEN_ID->caption() ?></span></td>
        <td data-name="STATUS_PASIEN_ID" <?= $Page->STATUS_PASIEN_ID->cellAttributes() ?>>
<span id="el_GOOD_GF_STATUS_PASIEN_ID">
<span<?= $Page->STATUS_PASIEN_ID->viewAttributes() ?>>
<?= $Page->STATUS_PASIEN_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->MONTH_ID->Visible) { // MONTH_ID ?>
    <tr id="r_MONTH_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOOD_GF_MONTH_ID"><?= $Page->MONTH_ID->caption() ?></span></td>
        <td data-name="MONTH_ID" <?= $Page->MONTH_ID->cellAttributes() ?>>
<span id="el_GOOD_GF_MONTH_ID">
<span<?= $Page->MONTH_ID->viewAttributes() ?>>
<?= $Page->MONTH_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->YEAR_ID->Visible) { // YEAR_ID ?>
    <tr id="r_YEAR_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOOD_GF_YEAR_ID"><?= $Page->YEAR_ID->caption() ?></span></td>
        <td data-name="YEAR_ID" <?= $Page->YEAR_ID->cellAttributes() ?>>
<span id="el_GOOD_GF_YEAR_ID">
<span<?= $Page->YEAR_ID->viewAttributes() ?>>
<?= $Page->YEAR_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->CORRECTION_DOC->Visible) { // CORRECTION_DOC ?>
    <tr id="r_CORRECTION_DOC">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOOD_GF_CORRECTION_DOC"><?= $Page->CORRECTION_DOC->caption() ?></span></td>
        <td data-name="CORRECTION_DOC" <?= $Page->CORRECTION_DOC->cellAttributes() ?>>
<span id="el_GOOD_GF_CORRECTION_DOC">
<span<?= $Page->CORRECTION_DOC->viewAttributes() ?>>
<?= $Page->CORRECTION_DOC->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->CORRECTIONS->Visible) { // CORRECTIONS ?>
    <tr id="r_CORRECTIONS">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOOD_GF_CORRECTIONS"><?= $Page->CORRECTIONS->caption() ?></span></td>
        <td data-name="CORRECTIONS" <?= $Page->CORRECTIONS->cellAttributes() ?>>
<span id="el_GOOD_GF_CORRECTIONS">
<span<?= $Page->CORRECTIONS->viewAttributes() ?>>
<?= $Page->CORRECTIONS->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->CORRECTION_DATE->Visible) { // CORRECTION_DATE ?>
    <tr id="r_CORRECTION_DATE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOOD_GF_CORRECTION_DATE"><?= $Page->CORRECTION_DATE->caption() ?></span></td>
        <td data-name="CORRECTION_DATE" <?= $Page->CORRECTION_DATE->cellAttributes() ?>>
<span id="el_GOOD_GF_CORRECTION_DATE">
<span<?= $Page->CORRECTION_DATE->viewAttributes() ?>>
<?= $Page->CORRECTION_DATE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->DOC_NO->Visible) { // DOC_NO ?>
    <tr id="r_DOC_NO">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOOD_GF_DOC_NO"><?= $Page->DOC_NO->caption() ?></span></td>
        <td data-name="DOC_NO" <?= $Page->DOC_NO->cellAttributes() ?>>
<span id="el_GOOD_GF_DOC_NO">
<span<?= $Page->DOC_NO->viewAttributes() ?>>
<?= $Page->DOC_NO->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ORDER_ID->Visible) { // ORDER_ID ?>
    <tr id="r_ORDER_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOOD_GF_ORDER_ID"><?= $Page->ORDER_ID->caption() ?></span></td>
        <td data-name="ORDER_ID" <?= $Page->ORDER_ID->cellAttributes() ?>>
<span id="el_GOOD_GF_ORDER_ID">
<span<?= $Page->ORDER_ID->viewAttributes() ?>>
<?= $Page->ORDER_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ISCETAK->Visible) { // ISCETAK ?>
    <tr id="r_ISCETAK">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOOD_GF_ISCETAK"><?= $Page->ISCETAK->caption() ?></span></td>
        <td data-name="ISCETAK" <?= $Page->ISCETAK->cellAttributes() ?>>
<span id="el_GOOD_GF_ISCETAK">
<span<?= $Page->ISCETAK->viewAttributes() ?>>
<?= $Page->ISCETAK->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->PRINT_DATE->Visible) { // PRINT_DATE ?>
    <tr id="r_PRINT_DATE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOOD_GF_PRINT_DATE"><?= $Page->PRINT_DATE->caption() ?></span></td>
        <td data-name="PRINT_DATE" <?= $Page->PRINT_DATE->cellAttributes() ?>>
<span id="el_GOOD_GF_PRINT_DATE">
<span<?= $Page->PRINT_DATE->viewAttributes() ?>>
<?= $Page->PRINT_DATE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->PRINTED_BY->Visible) { // PRINTED_BY ?>
    <tr id="r_PRINTED_BY">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOOD_GF_PRINTED_BY"><?= $Page->PRINTED_BY->caption() ?></span></td>
        <td data-name="PRINTED_BY" <?= $Page->PRINTED_BY->cellAttributes() ?>>
<span id="el_GOOD_GF_PRINTED_BY">
<span<?= $Page->PRINTED_BY->viewAttributes() ?>>
<?= $Page->PRINTED_BY->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->PRINTQ->Visible) { // PRINTQ ?>
    <tr id="r_PRINTQ">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOOD_GF_PRINTQ"><?= $Page->PRINTQ->caption() ?></span></td>
        <td data-name="PRINTQ" <?= $Page->PRINTQ->cellAttributes() ?>>
<span id="el_GOOD_GF_PRINTQ">
<span<?= $Page->PRINTQ->viewAttributes() ?>>
<?= $Page->PRINTQ->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->avgprice->Visible) { // avgprice ?>
    <tr id="r_avgprice">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOOD_GF_avgprice"><?= $Page->avgprice->caption() ?></span></td>
        <td data-name="avgprice" <?= $Page->avgprice->cellAttributes() ?>>
<span id="el_GOOD_GF_avgprice">
<span<?= $Page->avgprice->viewAttributes() ?>>
<?= $Page->avgprice->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->idx->Visible) { // idx ?>
    <tr id="r_idx">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOOD_GF_idx"><?= $Page->idx->caption() ?></span></td>
        <td data-name="idx" <?= $Page->idx->cellAttributes() ?>>
<span id="el_GOOD_GF_idx">
<span<?= $Page->idx->viewAttributes() ?>>
<?= $Page->idx->getViewValue() ?></span>
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
