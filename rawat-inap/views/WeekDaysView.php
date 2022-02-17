<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

// Page object
$WeekDaysView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fWEEK_DAYSview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fWEEK_DAYSview = currentForm = new ew.Form("fWEEK_DAYSview", "view");
    loadjs.done("fWEEK_DAYSview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.WEEK_DAYS) ew.vars.tables.WEEK_DAYS = <?= JsonEncode(GetClientVar("tables", "WEEK_DAYS")) ?>;
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
<form name="fWEEK_DAYSview" id="fWEEK_DAYSview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="WEEK_DAYS">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-bordered table-hover ew-view-table">
<?php if ($Page->DAY_ID->Visible) { // DAY_ID ?>
    <tr id="r_DAY_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_WEEK_DAYS_DAY_ID"><?= $Page->DAY_ID->caption() ?></span></td>
        <td data-name="DAY_ID" <?= $Page->DAY_ID->cellAttributes() ?>>
<span id="el_WEEK_DAYS_DAY_ID">
<span<?= $Page->DAY_ID->viewAttributes() ?>>
<?= $Page->DAY_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->WEEK_DAY->Visible) { // WEEK_DAY ?>
    <tr id="r_WEEK_DAY">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_WEEK_DAYS_WEEK_DAY"><?= $Page->WEEK_DAY->caption() ?></span></td>
        <td data-name="WEEK_DAY" <?= $Page->WEEK_DAY->cellAttributes() ?>>
<span id="el_WEEK_DAYS_WEEK_DAY">
<span<?= $Page->WEEK_DAY->viewAttributes() ?>>
<?= $Page->WEEK_DAY->getViewValue() ?></span>
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
