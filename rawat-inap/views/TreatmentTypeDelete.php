<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

// Page object
$TreatmentTypeDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fTREATMENT_TYPEdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fTREATMENT_TYPEdelete = currentForm = new ew.Form("fTREATMENT_TYPEdelete", "delete");
    loadjs.done("fTREATMENT_TYPEdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.TREATMENT_TYPE) ew.vars.tables.TREATMENT_TYPE = <?= JsonEncode(GetClientVar("tables", "TREATMENT_TYPE")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fTREATMENT_TYPEdelete" id="fTREATMENT_TYPEdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="TREATMENT_TYPE">
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
<?php if ($Page->TREAT_TYPE->Visible) { // TREAT_TYPE ?>
        <th class="<?= $Page->TREAT_TYPE->headerCellClass() ?>"><span id="elh_TREATMENT_TYPE_TREAT_TYPE" class="TREATMENT_TYPE_TREAT_TYPE"><?= $Page->TREAT_TYPE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->OBJECT_CATEGORY_ID->Visible) { // OBJECT_CATEGORY_ID ?>
        <th class="<?= $Page->OBJECT_CATEGORY_ID->headerCellClass() ?>"><span id="elh_TREATMENT_TYPE_OBJECT_CATEGORY_ID" class="TREATMENT_TYPE_OBJECT_CATEGORY_ID"><?= $Page->OBJECT_CATEGORY_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->TYPE_OF_TREATMENT->Visible) { // TYPE_OF_TREATMENT ?>
        <th class="<?= $Page->TYPE_OF_TREATMENT->headerCellClass() ?>"><span id="elh_TREATMENT_TYPE_TYPE_OF_TREATMENT" class="TREATMENT_TYPE_TYPE_OF_TREATMENT"><?= $Page->TYPE_OF_TREATMENT->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ISSERVICE->Visible) { // ISSERVICE ?>
        <th class="<?= $Page->ISSERVICE->headerCellClass() ?>"><span id="elh_TREATMENT_TYPE_ISSERVICE" class="TREATMENT_TYPE_ISSERVICE"><?= $Page->ISSERVICE->caption() ?></span></th>
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
<?php if ($Page->TREAT_TYPE->Visible) { // TREAT_TYPE ?>
        <td <?= $Page->TREAT_TYPE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_TYPE_TREAT_TYPE" class="TREATMENT_TYPE_TREAT_TYPE">
<span<?= $Page->TREAT_TYPE->viewAttributes() ?>>
<?= $Page->TREAT_TYPE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->OBJECT_CATEGORY_ID->Visible) { // OBJECT_CATEGORY_ID ?>
        <td <?= $Page->OBJECT_CATEGORY_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_TYPE_OBJECT_CATEGORY_ID" class="TREATMENT_TYPE_OBJECT_CATEGORY_ID">
<span<?= $Page->OBJECT_CATEGORY_ID->viewAttributes() ?>>
<?= $Page->OBJECT_CATEGORY_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->TYPE_OF_TREATMENT->Visible) { // TYPE_OF_TREATMENT ?>
        <td <?= $Page->TYPE_OF_TREATMENT->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_TYPE_TYPE_OF_TREATMENT" class="TREATMENT_TYPE_TYPE_OF_TREATMENT">
<span<?= $Page->TYPE_OF_TREATMENT->viewAttributes() ?>>
<?= $Page->TYPE_OF_TREATMENT->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ISSERVICE->Visible) { // ISSERVICE ?>
        <td <?= $Page->ISSERVICE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_TYPE_ISSERVICE" class="TREATMENT_TYPE_ISSERVICE">
<span<?= $Page->ISSERVICE->viewAttributes() ?>>
<?= $Page->ISSERVICE->getViewValue() ?></span>
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
