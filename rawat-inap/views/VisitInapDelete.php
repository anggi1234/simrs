<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

// Page object
$VisitInapDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fVISIT_INAPdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fVISIT_INAPdelete = currentForm = new ew.Form("fVISIT_INAPdelete", "delete");
    loadjs.done("fVISIT_INAPdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.VISIT_INAP) ew.vars.tables.VISIT_INAP = <?= JsonEncode(GetClientVar("tables", "VISIT_INAP")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fVISIT_INAPdelete" id="fVISIT_INAPdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="VISIT_INAP">
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
<?php if ($Page->VISIT_INAP_ID->Visible) { // VISIT_INAP_ID ?>
        <th class="<?= $Page->VISIT_INAP_ID->headerCellClass() ?>"><span id="elh_VISIT_INAP_VISIT_INAP_ID" class="VISIT_INAP_VISIT_INAP_ID"><?= $Page->VISIT_INAP_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->VISIT_INAP->Visible) { // VISIT_INAP ?>
        <th class="<?= $Page->VISIT_INAP->headerCellClass() ?>"><span id="elh_VISIT_INAP_VISIT_INAP" class="VISIT_INAP_VISIT_INAP"><?= $Page->VISIT_INAP->caption() ?></span></th>
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
<?php if ($Page->VISIT_INAP_ID->Visible) { // VISIT_INAP_ID ?>
        <td <?= $Page->VISIT_INAP_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_VISIT_INAP_VISIT_INAP_ID" class="VISIT_INAP_VISIT_INAP_ID">
<span<?= $Page->VISIT_INAP_ID->viewAttributes() ?>>
<?= $Page->VISIT_INAP_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->VISIT_INAP->Visible) { // VISIT_INAP ?>
        <td <?= $Page->VISIT_INAP->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_VISIT_INAP_VISIT_INAP" class="VISIT_INAP_VISIT_INAP">
<span<?= $Page->VISIT_INAP->viewAttributes() ?>>
<?= $Page->VISIT_INAP->getViewValue() ?></span>
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
