<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

// Page object
$UsersMenuDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fUSERS_MENUdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fUSERS_MENUdelete = currentForm = new ew.Form("fUSERS_MENUdelete", "delete");
    loadjs.done("fUSERS_MENUdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.USERS_MENU) ew.vars.tables.USERS_MENU = <?= JsonEncode(GetClientVar("tables", "USERS_MENU")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fUSERS_MENUdelete" id="fUSERS_MENUdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="USERS_MENU">
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
        <th class="<?= $Page->ORG_UNIT_CODE->headerCellClass() ?>"><span id="elh_USERS_MENU_ORG_UNIT_CODE" class="USERS_MENU_ORG_UNIT_CODE"><?= $Page->ORG_UNIT_CODE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->_USERNAME->Visible) { // USERNAME ?>
        <th class="<?= $Page->_USERNAME->headerCellClass() ?>"><span id="elh_USERS_MENU__USERNAME" class="USERS_MENU__USERNAME"><?= $Page->_USERNAME->caption() ?></span></th>
<?php } ?>
<?php if ($Page->MENU_ID->Visible) { // MENU_ID ?>
        <th class="<?= $Page->MENU_ID->headerCellClass() ?>"><span id="elh_USERS_MENU_MENU_ID" class="USERS_MENU_MENU_ID"><?= $Page->MENU_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->STYPE_ID->Visible) { // STYPE_ID ?>
        <th class="<?= $Page->STYPE_ID->headerCellClass() ?>"><span id="elh_USERS_MENU_STYPE_ID" class="USERS_MENU_STYPE_ID"><?= $Page->STYPE_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->GROUP_ID->Visible) { // GROUP_ID ?>
        <th class="<?= $Page->GROUP_ID->headerCellClass() ?>"><span id="elh_USERS_MENU_GROUP_ID" class="USERS_MENU_GROUP_ID"><?= $Page->GROUP_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->C->Visible) { // C ?>
        <th class="<?= $Page->C->headerCellClass() ?>"><span id="elh_USERS_MENU_C" class="USERS_MENU_C"><?= $Page->C->caption() ?></span></th>
<?php } ?>
<?php if ($Page->R->Visible) { // R ?>
        <th class="<?= $Page->R->headerCellClass() ?>"><span id="elh_USERS_MENU_R" class="USERS_MENU_R"><?= $Page->R->caption() ?></span></th>
<?php } ?>
<?php if ($Page->U->Visible) { // U ?>
        <th class="<?= $Page->U->headerCellClass() ?>"><span id="elh_USERS_MENU_U" class="USERS_MENU_U"><?= $Page->U->caption() ?></span></th>
<?php } ?>
<?php if ($Page->D->Visible) { // D ?>
        <th class="<?= $Page->D->headerCellClass() ?>"><span id="elh_USERS_MENU_D" class="USERS_MENU_D"><?= $Page->D->caption() ?></span></th>
<?php } ?>
<?php if ($Page->P->Visible) { // P ?>
        <th class="<?= $Page->P->headerCellClass() ?>"><span id="elh_USERS_MENU_P" class="USERS_MENU_P"><?= $Page->P->caption() ?></span></th>
<?php } ?>
<?php if ($Page->E->Visible) { // E ?>
        <th class="<?= $Page->E->headerCellClass() ?>"><span id="elh_USERS_MENU_E" class="USERS_MENU_E"><?= $Page->E->caption() ?></span></th>
<?php } ?>
<?php if ($Page->C_TIME->Visible) { // C_TIME ?>
        <th class="<?= $Page->C_TIME->headerCellClass() ?>"><span id="elh_USERS_MENU_C_TIME" class="USERS_MENU_C_TIME"><?= $Page->C_TIME->caption() ?></span></th>
<?php } ?>
<?php if ($Page->U_TIME->Visible) { // U_TIME ?>
        <th class="<?= $Page->U_TIME->headerCellClass() ?>"><span id="elh_USERS_MENU_U_TIME" class="USERS_MENU_U_TIME"><?= $Page->U_TIME->caption() ?></span></th>
<?php } ?>
<?php if ($Page->D_TIME->Visible) { // D_TIME ?>
        <th class="<?= $Page->D_TIME->headerCellClass() ?>"><span id="elh_USERS_MENU_D_TIME" class="USERS_MENU_D_TIME"><?= $Page->D_TIME->caption() ?></span></th>
<?php } ?>
<?php if ($Page->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
        <th class="<?= $Page->MODIFIED_DATE->headerCellClass() ?>"><span id="elh_USERS_MENU_MODIFIED_DATE" class="USERS_MENU_MODIFIED_DATE"><?= $Page->MODIFIED_DATE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
        <th class="<?= $Page->MODIFIED_BY->headerCellClass() ?>"><span id="elh_USERS_MENU_MODIFIED_BY" class="USERS_MENU_MODIFIED_BY"><?= $Page->MODIFIED_BY->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_USERS_MENU_ORG_UNIT_CODE" class="USERS_MENU_ORG_UNIT_CODE">
<span<?= $Page->ORG_UNIT_CODE->viewAttributes() ?>>
<?= $Page->ORG_UNIT_CODE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->_USERNAME->Visible) { // USERNAME ?>
        <td <?= $Page->_USERNAME->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_USERS_MENU__USERNAME" class="USERS_MENU__USERNAME">
<span<?= $Page->_USERNAME->viewAttributes() ?>>
<?= $Page->_USERNAME->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->MENU_ID->Visible) { // MENU_ID ?>
        <td <?= $Page->MENU_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_USERS_MENU_MENU_ID" class="USERS_MENU_MENU_ID">
<span<?= $Page->MENU_ID->viewAttributes() ?>>
<?= $Page->MENU_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->STYPE_ID->Visible) { // STYPE_ID ?>
        <td <?= $Page->STYPE_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_USERS_MENU_STYPE_ID" class="USERS_MENU_STYPE_ID">
<span<?= $Page->STYPE_ID->viewAttributes() ?>>
<?= $Page->STYPE_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->GROUP_ID->Visible) { // GROUP_ID ?>
        <td <?= $Page->GROUP_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_USERS_MENU_GROUP_ID" class="USERS_MENU_GROUP_ID">
<span<?= $Page->GROUP_ID->viewAttributes() ?>>
<?= $Page->GROUP_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->C->Visible) { // C ?>
        <td <?= $Page->C->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_USERS_MENU_C" class="USERS_MENU_C">
<span<?= $Page->C->viewAttributes() ?>>
<?= $Page->C->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->R->Visible) { // R ?>
        <td <?= $Page->R->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_USERS_MENU_R" class="USERS_MENU_R">
<span<?= $Page->R->viewAttributes() ?>>
<?= $Page->R->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->U->Visible) { // U ?>
        <td <?= $Page->U->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_USERS_MENU_U" class="USERS_MENU_U">
<span<?= $Page->U->viewAttributes() ?>>
<?= $Page->U->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->D->Visible) { // D ?>
        <td <?= $Page->D->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_USERS_MENU_D" class="USERS_MENU_D">
<span<?= $Page->D->viewAttributes() ?>>
<?= $Page->D->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->P->Visible) { // P ?>
        <td <?= $Page->P->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_USERS_MENU_P" class="USERS_MENU_P">
<span<?= $Page->P->viewAttributes() ?>>
<?= $Page->P->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->E->Visible) { // E ?>
        <td <?= $Page->E->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_USERS_MENU_E" class="USERS_MENU_E">
<span<?= $Page->E->viewAttributes() ?>>
<?= $Page->E->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->C_TIME->Visible) { // C_TIME ?>
        <td <?= $Page->C_TIME->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_USERS_MENU_C_TIME" class="USERS_MENU_C_TIME">
<span<?= $Page->C_TIME->viewAttributes() ?>>
<?= $Page->C_TIME->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->U_TIME->Visible) { // U_TIME ?>
        <td <?= $Page->U_TIME->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_USERS_MENU_U_TIME" class="USERS_MENU_U_TIME">
<span<?= $Page->U_TIME->viewAttributes() ?>>
<?= $Page->U_TIME->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->D_TIME->Visible) { // D_TIME ?>
        <td <?= $Page->D_TIME->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_USERS_MENU_D_TIME" class="USERS_MENU_D_TIME">
<span<?= $Page->D_TIME->viewAttributes() ?>>
<?= $Page->D_TIME->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
        <td <?= $Page->MODIFIED_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_USERS_MENU_MODIFIED_DATE" class="USERS_MENU_MODIFIED_DATE">
<span<?= $Page->MODIFIED_DATE->viewAttributes() ?>>
<?= $Page->MODIFIED_DATE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
        <td <?= $Page->MODIFIED_BY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_USERS_MENU_MODIFIED_BY" class="USERS_MENU_MODIFIED_BY">
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
