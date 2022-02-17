<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

// Page object
$TreatmentTypeView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fTREATMENT_TYPEview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fTREATMENT_TYPEview = currentForm = new ew.Form("fTREATMENT_TYPEview", "view");
    loadjs.done("fTREATMENT_TYPEview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.TREATMENT_TYPE) ew.vars.tables.TREATMENT_TYPE = <?= JsonEncode(GetClientVar("tables", "TREATMENT_TYPE")) ?>;
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
<form name="fTREATMENT_TYPEview" id="fTREATMENT_TYPEview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="TREATMENT_TYPE">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-bordered table-hover ew-view-table">
<?php if ($Page->TREAT_TYPE->Visible) { // TREAT_TYPE ?>
    <tr id="r_TREAT_TYPE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_TYPE_TREAT_TYPE"><?= $Page->TREAT_TYPE->caption() ?></span></td>
        <td data-name="TREAT_TYPE" <?= $Page->TREAT_TYPE->cellAttributes() ?>>
<span id="el_TREATMENT_TYPE_TREAT_TYPE">
<span<?= $Page->TREAT_TYPE->viewAttributes() ?>>
<?= $Page->TREAT_TYPE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->OBJECT_CATEGORY_ID->Visible) { // OBJECT_CATEGORY_ID ?>
    <tr id="r_OBJECT_CATEGORY_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_TYPE_OBJECT_CATEGORY_ID"><?= $Page->OBJECT_CATEGORY_ID->caption() ?></span></td>
        <td data-name="OBJECT_CATEGORY_ID" <?= $Page->OBJECT_CATEGORY_ID->cellAttributes() ?>>
<span id="el_TREATMENT_TYPE_OBJECT_CATEGORY_ID">
<span<?= $Page->OBJECT_CATEGORY_ID->viewAttributes() ?>>
<?= $Page->OBJECT_CATEGORY_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->TYPE_OF_TREATMENT->Visible) { // TYPE_OF_TREATMENT ?>
    <tr id="r_TYPE_OF_TREATMENT">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_TYPE_TYPE_OF_TREATMENT"><?= $Page->TYPE_OF_TREATMENT->caption() ?></span></td>
        <td data-name="TYPE_OF_TREATMENT" <?= $Page->TYPE_OF_TREATMENT->cellAttributes() ?>>
<span id="el_TREATMENT_TYPE_TYPE_OF_TREATMENT">
<span<?= $Page->TYPE_OF_TREATMENT->viewAttributes() ?>>
<?= $Page->TYPE_OF_TREATMENT->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ISSERVICE->Visible) { // ISSERVICE ?>
    <tr id="r_ISSERVICE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_TYPE_ISSERVICE"><?= $Page->ISSERVICE->caption() ?></span></td>
        <td data-name="ISSERVICE" <?= $Page->ISSERVICE->cellAttributes() ?>>
<span id="el_TREATMENT_TYPE_ISSERVICE">
<span<?= $Page->ISSERVICE->viewAttributes() ?>>
<?= $Page->ISSERVICE->getViewValue() ?></span>
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
