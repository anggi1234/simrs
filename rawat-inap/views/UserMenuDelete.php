<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

// Page object
$UserMenuDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fUSER_MENUdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fUSER_MENUdelete = currentForm = new ew.Form("fUSER_MENUdelete", "delete");
    loadjs.done("fUSER_MENUdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.USER_MENU) ew.vars.tables.USER_MENU = <?= JsonEncode(GetClientVar("tables", "USER_MENU")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fUSER_MENUdelete" id="fUSER_MENUdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="USER_MENU">
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
<?php if ($Page->ORG_UNIT_CODE->Visible) { // ORG_UNIT_CODE ?>
        <th class="<?= $Page->ORG_UNIT_CODE->headerCellClass() ?>"><span id="elh_USER_MENU_ORG_UNIT_CODE" class="USER_MENU_ORG_UNIT_CODE"><?= $Page->ORG_UNIT_CODE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->GROUP_ID->Visible) { // GROUP_ID ?>
        <th class="<?= $Page->GROUP_ID->headerCellClass() ?>"><span id="elh_USER_MENU_GROUP_ID" class="USER_MENU_GROUP_ID"><?= $Page->GROUP_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->MENU_ID->Visible) { // MENU_ID ?>
        <th class="<?= $Page->MENU_ID->headerCellClass() ?>"><span id="elh_USER_MENU_MENU_ID" class="USER_MENU_MENU_ID"><?= $Page->MENU_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->STYPE_ID->Visible) { // STYPE_ID ?>
        <th class="<?= $Page->STYPE_ID->headerCellClass() ?>"><span id="elh_USER_MENU_STYPE_ID" class="USER_MENU_STYPE_ID"><?= $Page->STYPE_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->C->Visible) { // C ?>
        <th class="<?= $Page->C->headerCellClass() ?>"><span id="elh_USER_MENU_C" class="USER_MENU_C"><?= $Page->C->caption() ?></span></th>
<?php } ?>
<?php if ($Page->R->Visible) { // R ?>
        <th class="<?= $Page->R->headerCellClass() ?>"><span id="elh_USER_MENU_R" class="USER_MENU_R"><?= $Page->R->caption() ?></span></th>
<?php } ?>
<?php if ($Page->U->Visible) { // U ?>
        <th class="<?= $Page->U->headerCellClass() ?>"><span id="elh_USER_MENU_U" class="USER_MENU_U"><?= $Page->U->caption() ?></span></th>
<?php } ?>
<?php if ($Page->D->Visible) { // D ?>
        <th class="<?= $Page->D->headerCellClass() ?>"><span id="elh_USER_MENU_D" class="USER_MENU_D"><?= $Page->D->caption() ?></span></th>
<?php } ?>
<?php if ($Page->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
        <th class="<?= $Page->MODIFIED_DATE->headerCellClass() ?>"><span id="elh_USER_MENU_MODIFIED_DATE" class="USER_MENU_MODIFIED_DATE"><?= $Page->MODIFIED_DATE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
        <th class="<?= $Page->MODIFIED_BY->headerCellClass() ?>"><span id="elh_USER_MENU_MODIFIED_BY" class="USER_MENU_MODIFIED_BY"><?= $Page->MODIFIED_BY->caption() ?></span></th>
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
<?php if ($Page->ORG_UNIT_CODE->Visible) { // ORG_UNIT_CODE ?>
        <td <?= $Page->ORG_UNIT_CODE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_USER_MENU_ORG_UNIT_CODE" class="USER_MENU_ORG_UNIT_CODE">
<span<?= $Page->ORG_UNIT_CODE->viewAttributes() ?>>
<?= $Page->ORG_UNIT_CODE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->GROUP_ID->Visible) { // GROUP_ID ?>
        <td <?= $Page->GROUP_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_USER_MENU_GROUP_ID" class="USER_MENU_GROUP_ID">
<span<?= $Page->GROUP_ID->viewAttributes() ?>>
<?= $Page->GROUP_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->MENU_ID->Visible) { // MENU_ID ?>
        <td <?= $Page->MENU_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_USER_MENU_MENU_ID" class="USER_MENU_MENU_ID">
<span<?= $Page->MENU_ID->viewAttributes() ?>>
<?= $Page->MENU_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->STYPE_ID->Visible) { // STYPE_ID ?>
        <td <?= $Page->STYPE_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_USER_MENU_STYPE_ID" class="USER_MENU_STYPE_ID">
<span<?= $Page->STYPE_ID->viewAttributes() ?>>
<?= $Page->STYPE_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->C->Visible) { // C ?>
        <td <?= $Page->C->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_USER_MENU_C" class="USER_MENU_C">
<span<?= $Page->C->viewAttributes() ?>>
<?= $Page->C->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->R->Visible) { // R ?>
        <td <?= $Page->R->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_USER_MENU_R" class="USER_MENU_R">
<span<?= $Page->R->viewAttributes() ?>>
<?= $Page->R->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->U->Visible) { // U ?>
        <td <?= $Page->U->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_USER_MENU_U" class="USER_MENU_U">
<span<?= $Page->U->viewAttributes() ?>>
<?= $Page->U->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->D->Visible) { // D ?>
        <td <?= $Page->D->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_USER_MENU_D" class="USER_MENU_D">
<span<?= $Page->D->viewAttributes() ?>>
<?= $Page->D->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
        <td <?= $Page->MODIFIED_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_USER_MENU_MODIFIED_DATE" class="USER_MENU_MODIFIED_DATE">
<span<?= $Page->MODIFIED_DATE->viewAttributes() ?>>
<?= $Page->MODIFIED_DATE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
        <td <?= $Page->MODIFIED_BY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_USER_MENU_MODIFIED_BY" class="USER_MENU_MODIFIED_BY">
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
