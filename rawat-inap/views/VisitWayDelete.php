<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

// Page object
$VisitWayDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fVISIT_WAYdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fVISIT_WAYdelete = currentForm = new ew.Form("fVISIT_WAYdelete", "delete");
    loadjs.done("fVISIT_WAYdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.VISIT_WAY) ew.vars.tables.VISIT_WAY = <?= JsonEncode(GetClientVar("tables", "VISIT_WAY")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fVISIT_WAYdelete" id="fVISIT_WAYdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="VISIT_WAY">
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
<?php if ($Page->WAY_ID->Visible) { // WAY_ID ?>
        <th class="<?= $Page->WAY_ID->headerCellClass() ?>"><span id="elh_VISIT_WAY_WAY_ID" class="VISIT_WAY_WAY_ID"><?= $Page->WAY_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->WAY->Visible) { // WAY ?>
        <th class="<?= $Page->WAY->headerCellClass() ?>"><span id="elh_VISIT_WAY_WAY" class="VISIT_WAY_WAY"><?= $Page->WAY->caption() ?></span></th>
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
<?php if ($Page->WAY_ID->Visible) { // WAY_ID ?>
        <td <?= $Page->WAY_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_VISIT_WAY_WAY_ID" class="VISIT_WAY_WAY_ID">
<span<?= $Page->WAY_ID->viewAttributes() ?>>
<?= $Page->WAY_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->WAY->Visible) { // WAY ?>
        <td <?= $Page->WAY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_VISIT_WAY_WAY" class="VISIT_WAY_WAY">
<span<?= $Page->WAY->viewAttributes() ?>>
<?= $Page->WAY->getViewValue() ?></span>
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
