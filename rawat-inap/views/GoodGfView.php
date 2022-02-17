<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

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
