<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

// Page object
$WeeksDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fWEEKSdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fWEEKSdelete = currentForm = new ew.Form("fWEEKSdelete", "delete");
    loadjs.done("fWEEKSdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.WEEKS) ew.vars.tables.WEEKS = <?= JsonEncode(GetClientVar("tables", "WEEKS")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fWEEKSdelete" id="fWEEKSdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="WEEKS">
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
<?php if ($Page->WEEK_ID->Visible) { // WEEK_ID ?>
        <th class="<?= $Page->WEEK_ID->headerCellClass() ?>"><span id="elh_WEEKS_WEEK_ID" class="WEEKS_WEEK_ID"><?= $Page->WEEK_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->WEEK_NAME->Visible) { // WEEK_NAME ?>
        <th class="<?= $Page->WEEK_NAME->headerCellClass() ?>"><span id="elh_WEEKS_WEEK_NAME" class="WEEKS_WEEK_NAME"><?= $Page->WEEK_NAME->caption() ?></span></th>
<?php } ?>
<?php if ($Page->KODE_HURUF->Visible) { // KODE_HURUF ?>
        <th class="<?= $Page->KODE_HURUF->headerCellClass() ?>"><span id="elh_WEEKS_KODE_HURUF" class="WEEKS_KODE_HURUF"><?= $Page->KODE_HURUF->caption() ?></span></th>
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
<?php if ($Page->WEEK_ID->Visible) { // WEEK_ID ?>
        <td <?= $Page->WEEK_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_WEEKS_WEEK_ID" class="WEEKS_WEEK_ID">
<span<?= $Page->WEEK_ID->viewAttributes() ?>>
<?= $Page->WEEK_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->WEEK_NAME->Visible) { // WEEK_NAME ?>
        <td <?= $Page->WEEK_NAME->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_WEEKS_WEEK_NAME" class="WEEKS_WEEK_NAME">
<span<?= $Page->WEEK_NAME->viewAttributes() ?>>
<?= $Page->WEEK_NAME->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->KODE_HURUF->Visible) { // KODE_HURUF ?>
        <td <?= $Page->KODE_HURUF->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_WEEKS_KODE_HURUF" class="WEEKS_KODE_HURUF">
<span<?= $Page->KODE_HURUF->viewAttributes() ?>>
<?= $Page->KODE_HURUF->getViewValue() ?></span>
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
