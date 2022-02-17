<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

// Page object
$WeekDaysDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fWEEK_DAYSdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fWEEK_DAYSdelete = currentForm = new ew.Form("fWEEK_DAYSdelete", "delete");
    loadjs.done("fWEEK_DAYSdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.WEEK_DAYS) ew.vars.tables.WEEK_DAYS = <?= JsonEncode(GetClientVar("tables", "WEEK_DAYS")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fWEEK_DAYSdelete" id="fWEEK_DAYSdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="WEEK_DAYS">
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
<?php if ($Page->DAY_ID->Visible) { // DAY_ID ?>
        <th class="<?= $Page->DAY_ID->headerCellClass() ?>"><span id="elh_WEEK_DAYS_DAY_ID" class="WEEK_DAYS_DAY_ID"><?= $Page->DAY_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->WEEK_DAY->Visible) { // WEEK_DAY ?>
        <th class="<?= $Page->WEEK_DAY->headerCellClass() ?>"><span id="elh_WEEK_DAYS_WEEK_DAY" class="WEEK_DAYS_WEEK_DAY"><?= $Page->WEEK_DAY->caption() ?></span></th>
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
<?php if ($Page->DAY_ID->Visible) { // DAY_ID ?>
        <td <?= $Page->DAY_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_WEEK_DAYS_DAY_ID" class="WEEK_DAYS_DAY_ID">
<span<?= $Page->DAY_ID->viewAttributes() ?>>
<?= $Page->DAY_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->WEEK_DAY->Visible) { // WEEK_DAY ?>
        <td <?= $Page->WEEK_DAY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_WEEK_DAYS_WEEK_DAY" class="WEEK_DAYS_WEEK_DAY">
<span<?= $Page->WEEK_DAY->viewAttributes() ?>>
<?= $Page->WEEK_DAY->getViewValue() ?></span>
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
