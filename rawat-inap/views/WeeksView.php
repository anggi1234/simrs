<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

// Page object
$WeeksView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fWEEKSview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fWEEKSview = currentForm = new ew.Form("fWEEKSview", "view");
    loadjs.done("fWEEKSview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.WEEKS) ew.vars.tables.WEEKS = <?= JsonEncode(GetClientVar("tables", "WEEKS")) ?>;
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
<form name="fWEEKSview" id="fWEEKSview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="WEEKS">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-bordered table-hover ew-view-table">
<?php if ($Page->WEEK_ID->Visible) { // WEEK_ID ?>
    <tr id="r_WEEK_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_WEEKS_WEEK_ID"><?= $Page->WEEK_ID->caption() ?></span></td>
        <td data-name="WEEK_ID" <?= $Page->WEEK_ID->cellAttributes() ?>>
<span id="el_WEEKS_WEEK_ID">
<span<?= $Page->WEEK_ID->viewAttributes() ?>>
<?= $Page->WEEK_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->WEEK_NAME->Visible) { // WEEK_NAME ?>
    <tr id="r_WEEK_NAME">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_WEEKS_WEEK_NAME"><?= $Page->WEEK_NAME->caption() ?></span></td>
        <td data-name="WEEK_NAME" <?= $Page->WEEK_NAME->cellAttributes() ?>>
<span id="el_WEEKS_WEEK_NAME">
<span<?= $Page->WEEK_NAME->viewAttributes() ?>>
<?= $Page->WEEK_NAME->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->KODE_HURUF->Visible) { // KODE_HURUF ?>
    <tr id="r_KODE_HURUF">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_WEEKS_KODE_HURUF"><?= $Page->KODE_HURUF->caption() ?></span></td>
        <td data-name="KODE_HURUF" <?= $Page->KODE_HURUF->cellAttributes() ?>>
<span id="el_WEEKS_KODE_HURUF">
<span<?= $Page->KODE_HURUF->viewAttributes() ?>>
<?= $Page->KODE_HURUF->getViewValue() ?></span>
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
