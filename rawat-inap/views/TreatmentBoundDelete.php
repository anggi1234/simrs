<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

// Page object
$TreatmentBoundDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fTREATMENT_BOUNDdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fTREATMENT_BOUNDdelete = currentForm = new ew.Form("fTREATMENT_BOUNDdelete", "delete");
    loadjs.done("fTREATMENT_BOUNDdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.TREATMENT_BOUND) ew.vars.tables.TREATMENT_BOUND = <?= JsonEncode(GetClientVar("tables", "TREATMENT_BOUND")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fTREATMENT_BOUNDdelete" id="fTREATMENT_BOUNDdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="TREATMENT_BOUND">
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
        <th class="<?= $Page->ORG_UNIT_CODE->headerCellClass() ?>"><span id="elh_TREATMENT_BOUND_ORG_UNIT_CODE" class="TREATMENT_BOUND_ORG_UNIT_CODE"><?= $Page->ORG_UNIT_CODE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->REAGENT_ID->Visible) { // REAGENT_ID ?>
        <th class="<?= $Page->REAGENT_ID->headerCellClass() ?>"><span id="elh_TREATMENT_BOUND_REAGENT_ID" class="TREATMENT_BOUND_REAGENT_ID"><?= $Page->REAGENT_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->CLINIC_ID->Visible) { // CLINIC_ID ?>
        <th class="<?= $Page->CLINIC_ID->headerCellClass() ?>"><span id="elh_TREATMENT_BOUND_CLINIC_ID" class="TREATMENT_BOUND_CLINIC_ID"><?= $Page->CLINIC_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->TREAT_ID->Visible) { // TREAT_ID ?>
        <th class="<?= $Page->TREAT_ID->headerCellClass() ?>"><span id="elh_TREATMENT_BOUND_TREAT_ID" class="TREATMENT_BOUND_TREAT_ID"><?= $Page->TREAT_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->REAGENT_NAME->Visible) { // REAGENT_NAME ?>
        <th class="<?= $Page->REAGENT_NAME->headerCellClass() ?>"><span id="elh_TREATMENT_BOUND_REAGENT_NAME" class="TREATMENT_BOUND_REAGENT_NAME"><?= $Page->REAGENT_NAME->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_TREATMENT_BOUND_ORG_UNIT_CODE" class="TREATMENT_BOUND_ORG_UNIT_CODE">
<span<?= $Page->ORG_UNIT_CODE->viewAttributes() ?>>
<?= $Page->ORG_UNIT_CODE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->REAGENT_ID->Visible) { // REAGENT_ID ?>
        <td <?= $Page->REAGENT_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BOUND_REAGENT_ID" class="TREATMENT_BOUND_REAGENT_ID">
<span<?= $Page->REAGENT_ID->viewAttributes() ?>>
<?= $Page->REAGENT_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->CLINIC_ID->Visible) { // CLINIC_ID ?>
        <td <?= $Page->CLINIC_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BOUND_CLINIC_ID" class="TREATMENT_BOUND_CLINIC_ID">
<span<?= $Page->CLINIC_ID->viewAttributes() ?>>
<?= $Page->CLINIC_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->TREAT_ID->Visible) { // TREAT_ID ?>
        <td <?= $Page->TREAT_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BOUND_TREAT_ID" class="TREATMENT_BOUND_TREAT_ID">
<span<?= $Page->TREAT_ID->viewAttributes() ?>>
<?= $Page->TREAT_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->REAGENT_NAME->Visible) { // REAGENT_NAME ?>
        <td <?= $Page->REAGENT_NAME->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BOUND_REAGENT_NAME" class="TREATMENT_BOUND_REAGENT_NAME">
<span<?= $Page->REAGENT_NAME->viewAttributes() ?>>
<?= $Page->REAGENT_NAME->getViewValue() ?></span>
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
