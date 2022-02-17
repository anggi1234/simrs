<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

// Page object
$VactinationTypeView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fVACTINATION_TYPEview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fVACTINATION_TYPEview = currentForm = new ew.Form("fVACTINATION_TYPEview", "view");
    loadjs.done("fVACTINATION_TYPEview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.VACTINATION_TYPE) ew.vars.tables.VACTINATION_TYPE = <?= JsonEncode(GetClientVar("tables", "VACTINATION_TYPE")) ?>;
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
<form name="fVACTINATION_TYPEview" id="fVACTINATION_TYPEview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="VACTINATION_TYPE">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-bordered table-hover ew-view-table">
<?php if ($Page->VACTINATION_TYPE->Visible) { // VACTINATION_TYPE ?>
    <tr id="r_VACTINATION_TYPE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_VACTINATION_TYPE_VACTINATION_TYPE"><?= $Page->VACTINATION_TYPE->caption() ?></span></td>
        <td data-name="VACTINATION_TYPE" <?= $Page->VACTINATION_TYPE->cellAttributes() ?>>
<span id="el_VACTINATION_TYPE_VACTINATION_TYPE">
<span<?= $Page->VACTINATION_TYPE->viewAttributes() ?>>
<?= $Page->VACTINATION_TYPE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->DIAGNOSA_ID->Visible) { // DIAGNOSA_ID ?>
    <tr id="r_DIAGNOSA_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_VACTINATION_TYPE_DIAGNOSA_ID"><?= $Page->DIAGNOSA_ID->caption() ?></span></td>
        <td data-name="DIAGNOSA_ID" <?= $Page->DIAGNOSA_ID->cellAttributes() ?>>
<span id="el_VACTINATION_TYPE_DIAGNOSA_ID">
<span<?= $Page->DIAGNOSA_ID->viewAttributes() ?>>
<?= $Page->DIAGNOSA_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->VACTINATIONTYPE->Visible) { // VACTINATIONTYPE ?>
    <tr id="r_VACTINATIONTYPE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_VACTINATION_TYPE_VACTINATIONTYPE"><?= $Page->VACTINATIONTYPE->caption() ?></span></td>
        <td data-name="VACTINATIONTYPE" <?= $Page->VACTINATIONTYPE->cellAttributes() ?>>
<span id="el_VACTINATION_TYPE_VACTINATIONTYPE">
<span<?= $Page->VACTINATIONTYPE->viewAttributes() ?>>
<?= $Page->VACTINATIONTYPE->getViewValue() ?></span>
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
