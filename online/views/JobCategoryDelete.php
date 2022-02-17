<?php

namespace PHPMaker2021\Online;

// Page object
$JobCategoryDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fJOB_CATEGORYdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fJOB_CATEGORYdelete = currentForm = new ew.Form("fJOB_CATEGORYdelete", "delete");
    loadjs.done("fJOB_CATEGORYdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.JOB_CATEGORY) ew.vars.tables.JOB_CATEGORY = <?= JsonEncode(GetClientVar("tables", "JOB_CATEGORY")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fJOB_CATEGORYdelete" id="fJOB_CATEGORYdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="JOB_CATEGORY">
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
<?php if ($Page->JOB_ID->Visible) { // JOB_ID ?>
        <th class="<?= $Page->JOB_ID->headerCellClass() ?>"><span id="elh_JOB_CATEGORY_JOB_ID" class="JOB_CATEGORY_JOB_ID"><?= $Page->JOB_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->NAME_OF_JOB->Visible) { // NAME_OF_JOB ?>
        <th class="<?= $Page->NAME_OF_JOB->headerCellClass() ?>"><span id="elh_JOB_CATEGORY_NAME_OF_JOB" class="JOB_CATEGORY_NAME_OF_JOB"><?= $Page->NAME_OF_JOB->caption() ?></span></th>
<?php } ?>
<?php if ($Page->DESCRIPTION->Visible) { // DESCRIPTION ?>
        <th class="<?= $Page->DESCRIPTION->headerCellClass() ?>"><span id="elh_JOB_CATEGORY_DESCRIPTION" class="JOB_CATEGORY_DESCRIPTION"><?= $Page->DESCRIPTION->caption() ?></span></th>
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
<?php if ($Page->JOB_ID->Visible) { // JOB_ID ?>
        <td <?= $Page->JOB_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_JOB_CATEGORY_JOB_ID" class="JOB_CATEGORY_JOB_ID">
<span<?= $Page->JOB_ID->viewAttributes() ?>>
<?= $Page->JOB_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->NAME_OF_JOB->Visible) { // NAME_OF_JOB ?>
        <td <?= $Page->NAME_OF_JOB->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_JOB_CATEGORY_NAME_OF_JOB" class="JOB_CATEGORY_NAME_OF_JOB">
<span<?= $Page->NAME_OF_JOB->viewAttributes() ?>>
<?= $Page->NAME_OF_JOB->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->DESCRIPTION->Visible) { // DESCRIPTION ?>
        <td <?= $Page->DESCRIPTION->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_JOB_CATEGORY_DESCRIPTION" class="JOB_CATEGORY_DESCRIPTION">
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
