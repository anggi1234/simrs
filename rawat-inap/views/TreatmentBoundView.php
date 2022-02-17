<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

// Page object
$TreatmentBoundView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fTREATMENT_BOUNDview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fTREATMENT_BOUNDview = currentForm = new ew.Form("fTREATMENT_BOUNDview", "view");
    loadjs.done("fTREATMENT_BOUNDview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.TREATMENT_BOUND) ew.vars.tables.TREATMENT_BOUND = <?= JsonEncode(GetClientVar("tables", "TREATMENT_BOUND")) ?>;
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
<form name="fTREATMENT_BOUNDview" id="fTREATMENT_BOUNDview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="TREATMENT_BOUND">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-bordered table-hover ew-view-table">
<?php if ($Page->ORG_UNIT_CODE->Visible) { // ORG_UNIT_CODE ?>
    <tr id="r_ORG_UNIT_CODE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BOUND_ORG_UNIT_CODE"><?= $Page->ORG_UNIT_CODE->caption() ?></span></td>
        <td data-name="ORG_UNIT_CODE" <?= $Page->ORG_UNIT_CODE->cellAttributes() ?>>
<span id="el_TREATMENT_BOUND_ORG_UNIT_CODE">
<span<?= $Page->ORG_UNIT_CODE->viewAttributes() ?>>
<?= $Page->ORG_UNIT_CODE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->REAGENT_ID->Visible) { // REAGENT_ID ?>
    <tr id="r_REAGENT_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BOUND_REAGENT_ID"><?= $Page->REAGENT_ID->caption() ?></span></td>
        <td data-name="REAGENT_ID" <?= $Page->REAGENT_ID->cellAttributes() ?>>
<span id="el_TREATMENT_BOUND_REAGENT_ID">
<span<?= $Page->REAGENT_ID->viewAttributes() ?>>
<?= $Page->REAGENT_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->CLINIC_ID->Visible) { // CLINIC_ID ?>
    <tr id="r_CLINIC_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BOUND_CLINIC_ID"><?= $Page->CLINIC_ID->caption() ?></span></td>
        <td data-name="CLINIC_ID" <?= $Page->CLINIC_ID->cellAttributes() ?>>
<span id="el_TREATMENT_BOUND_CLINIC_ID">
<span<?= $Page->CLINIC_ID->viewAttributes() ?>>
<?= $Page->CLINIC_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->TREAT_ID->Visible) { // TREAT_ID ?>
    <tr id="r_TREAT_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BOUND_TREAT_ID"><?= $Page->TREAT_ID->caption() ?></span></td>
        <td data-name="TREAT_ID" <?= $Page->TREAT_ID->cellAttributes() ?>>
<span id="el_TREATMENT_BOUND_TREAT_ID">
<span<?= $Page->TREAT_ID->viewAttributes() ?>>
<?= $Page->TREAT_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->REAGENT_NAME->Visible) { // REAGENT_NAME ?>
    <tr id="r_REAGENT_NAME">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BOUND_REAGENT_NAME"><?= $Page->REAGENT_NAME->caption() ?></span></td>
        <td data-name="REAGENT_NAME" <?= $Page->REAGENT_NAME->cellAttributes() ?>>
<span id="el_TREATMENT_BOUND_REAGENT_NAME">
<span<?= $Page->REAGENT_NAME->viewAttributes() ?>>
<?= $Page->REAGENT_NAME->getViewValue() ?></span>
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
