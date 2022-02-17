<?php

namespace PHPMaker2021\SIMRSSQLSERVERGUDANGFARMASI;

// Page object
$PoVerificationDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fPO_VERIFICATIONdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fPO_VERIFICATIONdelete = currentForm = new ew.Form("fPO_VERIFICATIONdelete", "delete");
    loadjs.done("fPO_VERIFICATIONdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.PO_VERIFICATION) ew.vars.tables.PO_VERIFICATION = <?= JsonEncode(GetClientVar("tables", "PO_VERIFICATION")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fPO_VERIFICATIONdelete" id="fPO_VERIFICATIONdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="PO_VERIFICATION">
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
<?php if ($Page->PO->Visible) { // PO ?>
        <th class="<?= $Page->PO->headerCellClass() ?>"><span id="elh_PO_VERIFICATION_PO" class="PO_VERIFICATION_PO"><?= $Page->PO->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ISVALID->Visible) { // ISVALID ?>
        <th class="<?= $Page->ISVALID->headerCellClass() ?>"><span id="elh_PO_VERIFICATION_ISVALID" class="PO_VERIFICATION_ISVALID"><?= $Page->ISVALID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->VERIFIED_DATE->Visible) { // VERIFIED_DATE ?>
        <th class="<?= $Page->VERIFIED_DATE->headerCellClass() ?>"><span id="elh_PO_VERIFICATION_VERIFIED_DATE" class="PO_VERIFICATION_VERIFIED_DATE"><?= $Page->VERIFIED_DATE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->VERIFIED_BY->Visible) { // VERIFIED_BY ?>
        <th class="<?= $Page->VERIFIED_BY->headerCellClass() ?>"><span id="elh_PO_VERIFICATION_VERIFIED_BY" class="PO_VERIFICATION_VERIFIED_BY"><?= $Page->VERIFIED_BY->caption() ?></span></th>
<?php } ?>
<?php if ($Page->VERIFICATION_DESC->Visible) { // VERIFICATION_DESC ?>
        <th class="<?= $Page->VERIFICATION_DESC->headerCellClass() ?>"><span id="elh_PO_VERIFICATION_VERIFICATION_DESC" class="PO_VERIFICATION_VERIFICATION_DESC"><?= $Page->VERIFICATION_DESC->caption() ?></span></th>
<?php } ?>
<?php if ($Page->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
        <th class="<?= $Page->MODIFIED_DATE->headerCellClass() ?>"><span id="elh_PO_VERIFICATION_MODIFIED_DATE" class="PO_VERIFICATION_MODIFIED_DATE"><?= $Page->MODIFIED_DATE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
        <th class="<?= $Page->MODIFIED_BY->headerCellClass() ?>"><span id="elh_PO_VERIFICATION_MODIFIED_BY" class="PO_VERIFICATION_MODIFIED_BY"><?= $Page->MODIFIED_BY->caption() ?></span></th>
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
<?php if ($Page->PO->Visible) { // PO ?>
        <td <?= $Page->PO->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_VERIFICATION_PO" class="PO_VERIFICATION_PO">
<span<?= $Page->PO->viewAttributes() ?>>
<?= $Page->PO->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ISVALID->Visible) { // ISVALID ?>
        <td <?= $Page->ISVALID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_VERIFICATION_ISVALID" class="PO_VERIFICATION_ISVALID">
<span<?= $Page->ISVALID->viewAttributes() ?>>
<?= $Page->ISVALID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->VERIFIED_DATE->Visible) { // VERIFIED_DATE ?>
        <td <?= $Page->VERIFIED_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_VERIFICATION_VERIFIED_DATE" class="PO_VERIFICATION_VERIFIED_DATE">
<span<?= $Page->VERIFIED_DATE->viewAttributes() ?>>
<?= $Page->VERIFIED_DATE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->VERIFIED_BY->Visible) { // VERIFIED_BY ?>
        <td <?= $Page->VERIFIED_BY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_VERIFICATION_VERIFIED_BY" class="PO_VERIFICATION_VERIFIED_BY">
<span<?= $Page->VERIFIED_BY->viewAttributes() ?>>
<?= $Page->VERIFIED_BY->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->VERIFICATION_DESC->Visible) { // VERIFICATION_DESC ?>
        <td <?= $Page->VERIFICATION_DESC->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_VERIFICATION_VERIFICATION_DESC" class="PO_VERIFICATION_VERIFICATION_DESC">
<span<?= $Page->VERIFICATION_DESC->viewAttributes() ?>>
<?= $Page->VERIFICATION_DESC->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
        <td <?= $Page->MODIFIED_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_VERIFICATION_MODIFIED_DATE" class="PO_VERIFICATION_MODIFIED_DATE">
<span<?= $Page->MODIFIED_DATE->viewAttributes() ?>>
<?= $Page->MODIFIED_DATE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
        <td <?= $Page->MODIFIED_BY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_VERIFICATION_MODIFIED_BY" class="PO_VERIFICATION_MODIFIED_BY">
<span<?= $Page->MODIFIED_BY->viewAttributes() ?>>
<?= $Page->MODIFIED_BY->getViewValue() ?></span>
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
