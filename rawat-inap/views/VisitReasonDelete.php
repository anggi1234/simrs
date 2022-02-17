<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

// Page object
$VisitReasonDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fVISIT_REASONdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fVISIT_REASONdelete = currentForm = new ew.Form("fVISIT_REASONdelete", "delete");
    loadjs.done("fVISIT_REASONdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.VISIT_REASON) ew.vars.tables.VISIT_REASON = <?= JsonEncode(GetClientVar("tables", "VISIT_REASON")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fVISIT_REASONdelete" id="fVISIT_REASONdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="VISIT_REASON">
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
<?php if ($Page->REASON_ID->Visible) { // REASON_ID ?>
        <th class="<?= $Page->REASON_ID->headerCellClass() ?>"><span id="elh_VISIT_REASON_REASON_ID" class="VISIT_REASON_REASON_ID"><?= $Page->REASON_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->REASON->Visible) { // REASON ?>
        <th class="<?= $Page->REASON->headerCellClass() ?>"><span id="elh_VISIT_REASON_REASON" class="VISIT_REASON_REASON"><?= $Page->REASON->caption() ?></span></th>
<?php } ?>
<?php if ($Page->LAKALANTAS->Visible) { // LAKALANTAS ?>
        <th class="<?= $Page->LAKALANTAS->headerCellClass() ?>"><span id="elh_VISIT_REASON_LAKALANTAS" class="VISIT_REASON_LAKALANTAS"><?= $Page->LAKALANTAS->caption() ?></span></th>
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
<?php if ($Page->REASON_ID->Visible) { // REASON_ID ?>
        <td <?= $Page->REASON_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_VISIT_REASON_REASON_ID" class="VISIT_REASON_REASON_ID">
<span<?= $Page->REASON_ID->viewAttributes() ?>>
<?= $Page->REASON_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->REASON->Visible) { // REASON ?>
        <td <?= $Page->REASON->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_VISIT_REASON_REASON" class="VISIT_REASON_REASON">
<span<?= $Page->REASON->viewAttributes() ?>>
<?= $Page->REASON->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->LAKALANTAS->Visible) { // LAKALANTAS ?>
        <td <?= $Page->LAKALANTAS->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_VISIT_REASON_LAKALANTAS" class="VISIT_REASON_LAKALANTAS">
<span<?= $Page->LAKALANTAS->viewAttributes() ?>>
<?= $Page->LAKALANTAS->getViewValue() ?></span>
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
