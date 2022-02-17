<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

// Page object
$YearsDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fYEARSdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fYEARSdelete = currentForm = new ew.Form("fYEARSdelete", "delete");
    loadjs.done("fYEARSdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.YEARS) ew.vars.tables.YEARS = <?= JsonEncode(GetClientVar("tables", "YEARS")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fYEARSdelete" id="fYEARSdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="YEARS">
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
<?php if ($Page->YEAR_ID->Visible) { // YEAR_ID ?>
        <th class="<?= $Page->YEAR_ID->headerCellClass() ?>"><span id="elh_YEARS_YEAR_ID" class="YEARS_YEAR_ID"><?= $Page->YEAR_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->START_DATE->Visible) { // START_DATE ?>
        <th class="<?= $Page->START_DATE->headerCellClass() ?>"><span id="elh_YEARS_START_DATE" class="YEARS_START_DATE"><?= $Page->START_DATE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->END_DATE->Visible) { // END_DATE ?>
        <th class="<?= $Page->END_DATE->headerCellClass() ?>"><span id="elh_YEARS_END_DATE" class="YEARS_END_DATE"><?= $Page->END_DATE->caption() ?></span></th>
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
<?php if ($Page->YEAR_ID->Visible) { // YEAR_ID ?>
        <td <?= $Page->YEAR_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_YEARS_YEAR_ID" class="YEARS_YEAR_ID">
<span<?= $Page->YEAR_ID->viewAttributes() ?>>
<?= $Page->YEAR_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->START_DATE->Visible) { // START_DATE ?>
        <td <?= $Page->START_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_YEARS_START_DATE" class="YEARS_START_DATE">
<span<?= $Page->START_DATE->viewAttributes() ?>>
<?= $Page->START_DATE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->END_DATE->Visible) { // END_DATE ?>
        <td <?= $Page->END_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_YEARS_END_DATE" class="YEARS_END_DATE">
<span<?= $Page->END_DATE->viewAttributes() ?>>
<?= $Page->END_DATE->getViewValue() ?></span>
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
