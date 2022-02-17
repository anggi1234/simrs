<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

// Page object
$UserPermissionDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fUSER_PERMISSIONdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fUSER_PERMISSIONdelete = currentForm = new ew.Form("fUSER_PERMISSIONdelete", "delete");
    loadjs.done("fUSER_PERMISSIONdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.USER_PERMISSION) ew.vars.tables.USER_PERMISSION = <?= JsonEncode(GetClientVar("tables", "USER_PERMISSION")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fUSER_PERMISSIONdelete" id="fUSER_PERMISSIONdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="USER_PERMISSION">
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
<?php if ($Page->PERMISSION_ID->Visible) { // PERMISSION_ID ?>
        <th class="<?= $Page->PERMISSION_ID->headerCellClass() ?>"><span id="elh_USER_PERMISSION_PERMISSION_ID" class="USER_PERMISSION_PERMISSION_ID"><?= $Page->PERMISSION_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->_PERMISSIONS->Visible) { // PERMISSIONS ?>
        <th class="<?= $Page->_PERMISSIONS->headerCellClass() ?>"><span id="elh_USER_PERMISSION__PERMISSIONS" class="USER_PERMISSION__PERMISSIONS"><?= $Page->_PERMISSIONS->caption() ?></span></th>
<?php } ?>
<?php if ($Page->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
        <th class="<?= $Page->MODIFIED_DATE->headerCellClass() ?>"><span id="elh_USER_PERMISSION_MODIFIED_DATE" class="USER_PERMISSION_MODIFIED_DATE"><?= $Page->MODIFIED_DATE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
        <th class="<?= $Page->MODIFIED_BY->headerCellClass() ?>"><span id="elh_USER_PERMISSION_MODIFIED_BY" class="USER_PERMISSION_MODIFIED_BY"><?= $Page->MODIFIED_BY->caption() ?></span></th>
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
<?php if ($Page->PERMISSION_ID->Visible) { // PERMISSION_ID ?>
        <td <?= $Page->PERMISSION_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_USER_PERMISSION_PERMISSION_ID" class="USER_PERMISSION_PERMISSION_ID">
<span<?= $Page->PERMISSION_ID->viewAttributes() ?>>
<?= $Page->PERMISSION_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->_PERMISSIONS->Visible) { // PERMISSIONS ?>
        <td <?= $Page->_PERMISSIONS->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_USER_PERMISSION__PERMISSIONS" class="USER_PERMISSION__PERMISSIONS">
<span<?= $Page->_PERMISSIONS->viewAttributes() ?>>
<?= $Page->_PERMISSIONS->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
        <td <?= $Page->MODIFIED_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_USER_PERMISSION_MODIFIED_DATE" class="USER_PERMISSION_MODIFIED_DATE">
<span<?= $Page->MODIFIED_DATE->viewAttributes() ?>>
<?= $Page->MODIFIED_DATE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
        <td <?= $Page->MODIFIED_BY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_USER_PERMISSION_MODIFIED_BY" class="USER_PERMISSION_MODIFIED_BY">
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
