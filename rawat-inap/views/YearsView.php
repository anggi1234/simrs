<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

// Page object
$YearsView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fYEARSview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fYEARSview = currentForm = new ew.Form("fYEARSview", "view");
    loadjs.done("fYEARSview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.YEARS) ew.vars.tables.YEARS = <?= JsonEncode(GetClientVar("tables", "YEARS")) ?>;
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
<form name="fYEARSview" id="fYEARSview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="YEARS">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-bordered table-hover ew-view-table">
<?php if ($Page->YEAR_ID->Visible) { // YEAR_ID ?>
    <tr id="r_YEAR_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_YEARS_YEAR_ID"><?= $Page->YEAR_ID->caption() ?></span></td>
        <td data-name="YEAR_ID" <?= $Page->YEAR_ID->cellAttributes() ?>>
<span id="el_YEARS_YEAR_ID">
<span<?= $Page->YEAR_ID->viewAttributes() ?>>
<?= $Page->YEAR_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->START_DATE->Visible) { // START_DATE ?>
    <tr id="r_START_DATE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_YEARS_START_DATE"><?= $Page->START_DATE->caption() ?></span></td>
        <td data-name="START_DATE" <?= $Page->START_DATE->cellAttributes() ?>>
<span id="el_YEARS_START_DATE">
<span<?= $Page->START_DATE->viewAttributes() ?>>
<?= $Page->START_DATE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->END_DATE->Visible) { // END_DATE ?>
    <tr id="r_END_DATE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_YEARS_END_DATE"><?= $Page->END_DATE->caption() ?></span></td>
        <td data-name="END_DATE" <?= $Page->END_DATE->cellAttributes() ?>>
<span id="el_YEARS_END_DATE">
<span<?= $Page->END_DATE->viewAttributes() ?>>
<?= $Page->END_DATE->getViewValue() ?></span>
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
