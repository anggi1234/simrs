<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

// Page object
$VactinationTypeDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fVACTINATION_TYPEdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fVACTINATION_TYPEdelete = currentForm = new ew.Form("fVACTINATION_TYPEdelete", "delete");
    loadjs.done("fVACTINATION_TYPEdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.VACTINATION_TYPE) ew.vars.tables.VACTINATION_TYPE = <?= JsonEncode(GetClientVar("tables", "VACTINATION_TYPE")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fVACTINATION_TYPEdelete" id="fVACTINATION_TYPEdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="VACTINATION_TYPE">
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
<?php if ($Page->VACTINATION_TYPE->Visible) { // VACTINATION_TYPE ?>
        <th class="<?= $Page->VACTINATION_TYPE->headerCellClass() ?>"><span id="elh_VACTINATION_TYPE_VACTINATION_TYPE" class="VACTINATION_TYPE_VACTINATION_TYPE"><?= $Page->VACTINATION_TYPE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->DIAGNOSA_ID->Visible) { // DIAGNOSA_ID ?>
        <th class="<?= $Page->DIAGNOSA_ID->headerCellClass() ?>"><span id="elh_VACTINATION_TYPE_DIAGNOSA_ID" class="VACTINATION_TYPE_DIAGNOSA_ID"><?= $Page->DIAGNOSA_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->VACTINATIONTYPE->Visible) { // VACTINATIONTYPE ?>
        <th class="<?= $Page->VACTINATIONTYPE->headerCellClass() ?>"><span id="elh_VACTINATION_TYPE_VACTINATIONTYPE" class="VACTINATION_TYPE_VACTINATIONTYPE"><?= $Page->VACTINATIONTYPE->caption() ?></span></th>
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
<?php if ($Page->VACTINATION_TYPE->Visible) { // VACTINATION_TYPE ?>
        <td <?= $Page->VACTINATION_TYPE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_VACTINATION_TYPE_VACTINATION_TYPE" class="VACTINATION_TYPE_VACTINATION_TYPE">
<span<?= $Page->VACTINATION_TYPE->viewAttributes() ?>>
<?= $Page->VACTINATION_TYPE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->DIAGNOSA_ID->Visible) { // DIAGNOSA_ID ?>
        <td <?= $Page->DIAGNOSA_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_VACTINATION_TYPE_DIAGNOSA_ID" class="VACTINATION_TYPE_DIAGNOSA_ID">
<span<?= $Page->DIAGNOSA_ID->viewAttributes() ?>>
<?= $Page->DIAGNOSA_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->VACTINATIONTYPE->Visible) { // VACTINATIONTYPE ?>
        <td <?= $Page->VACTINATIONTYPE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_VACTINATION_TYPE_VACTINATIONTYPE" class="VACTINATION_TYPE_VACTINATIONTYPE">
<span<?= $Page->VACTINATIONTYPE->viewAttributes() ?>>
<?= $Page->VACTINATIONTYPE->getViewValue() ?></span>
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
