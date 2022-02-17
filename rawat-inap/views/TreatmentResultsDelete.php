<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

// Page object
$TreatmentResultsDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fTREATMENT_RESULTSdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fTREATMENT_RESULTSdelete = currentForm = new ew.Form("fTREATMENT_RESULTSdelete", "delete");
    loadjs.done("fTREATMENT_RESULTSdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.TREATMENT_RESULTS) ew.vars.tables.TREATMENT_RESULTS = <?= JsonEncode(GetClientVar("tables", "TREATMENT_RESULTS")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fTREATMENT_RESULTSdelete" id="fTREATMENT_RESULTSdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="TREATMENT_RESULTS">
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
<?php if ($Page->RESULT_ID->Visible) { // RESULT_ID ?>
        <th class="<?= $Page->RESULT_ID->headerCellClass() ?>"><span id="elh_TREATMENT_RESULTS_RESULT_ID" class="TREATMENT_RESULTS_RESULT_ID"><?= $Page->RESULT_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->RESULTS->Visible) { // RESULTS ?>
        <th class="<?= $Page->RESULTS->headerCellClass() ?>"><span id="elh_TREATMENT_RESULTS_RESULTS" class="TREATMENT_RESULTS_RESULTS"><?= $Page->RESULTS->caption() ?></span></th>
<?php } ?>
<?php if ($Page->DESCRIPTION->Visible) { // DESCRIPTION ?>
        <th class="<?= $Page->DESCRIPTION->headerCellClass() ?>"><span id="elh_TREATMENT_RESULTS_DESCRIPTION" class="TREATMENT_RESULTS_DESCRIPTION"><?= $Page->DESCRIPTION->caption() ?></span></th>
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
<?php if ($Page->RESULT_ID->Visible) { // RESULT_ID ?>
        <td <?= $Page->RESULT_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_RESULTS_RESULT_ID" class="TREATMENT_RESULTS_RESULT_ID">
<span<?= $Page->RESULT_ID->viewAttributes() ?>>
<?= $Page->RESULT_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->RESULTS->Visible) { // RESULTS ?>
        <td <?= $Page->RESULTS->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_RESULTS_RESULTS" class="TREATMENT_RESULTS_RESULTS">
<span<?= $Page->RESULTS->viewAttributes() ?>>
<?= $Page->RESULTS->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->DESCRIPTION->Visible) { // DESCRIPTION ?>
        <td <?= $Page->DESCRIPTION->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_RESULTS_DESCRIPTION" class="TREATMENT_RESULTS_DESCRIPTION">
<span<?= $Page->DESCRIPTION->viewAttributes() ?>>
<?= $Page->DESCRIPTION->getViewValue() ?></span>
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
