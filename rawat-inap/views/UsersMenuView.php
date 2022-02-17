<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

// Page object
$UsersMenuView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fUSERS_MENUview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fUSERS_MENUview = currentForm = new ew.Form("fUSERS_MENUview", "view");
    loadjs.done("fUSERS_MENUview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.USERS_MENU) ew.vars.tables.USERS_MENU = <?= JsonEncode(GetClientVar("tables", "USERS_MENU")) ?>;
</script>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $Page->ExportOptions->render("body") ?>
<?php $Page->OtherOptions->render("body") ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fUSERS_MENUview" id="fUSERS_MENUview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="USERS_MENU">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-bordered table-hover ew-view-table">
<?php if ($Page->ORG_UNIT_CODE->Visible) { // ORG_UNIT_CODE ?>
    <tr id="r_ORG_UNIT_CODE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_USERS_MENU_ORG_UNIT_CODE"><?= $Page->ORG_UNIT_CODE->caption() ?></span></td>
        <td data-name="ORG_UNIT_CODE" <?= $Page->ORG_UNIT_CODE->cellAttributes() ?>>
<span id="el_USERS_MENU_ORG_UNIT_CODE">
<span<?= $Page->ORG_UNIT_CODE->viewAttributes() ?>>
<?= $Page->ORG_UNIT_CODE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_USERNAME->Visible) { // USERNAME ?>
    <tr id="r__USERNAME">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_USERS_MENU__USERNAME"><?= $Page->_USERNAME->caption() ?></span></td>
        <td data-name="_USERNAME" <?= $Page->_USERNAME->cellAttributes() ?>>
<span id="el_USERS_MENU__USERNAME">
<span<?= $Page->_USERNAME->viewAttributes() ?>>
<?= $Page->_USERNAME->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->MENU_ID->Visible) { // MENU_ID ?>
    <tr id="r_MENU_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_USERS_MENU_MENU_ID"><?= $Page->MENU_ID->caption() ?></span></td>
        <td data-name="MENU_ID" <?= $Page->MENU_ID->cellAttributes() ?>>
<span id="el_USERS_MENU_MENU_ID">
<span<?= $Page->MENU_ID->viewAttributes() ?>>
<?= $Page->MENU_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->STYPE_ID->Visible) { // STYPE_ID ?>
    <tr id="r_STYPE_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_USERS_MENU_STYPE_ID"><?= $Page->STYPE_ID->caption() ?></span></td>
        <td data-name="STYPE_ID" <?= $Page->STYPE_ID->cellAttributes() ?>>
<span id="el_USERS_MENU_STYPE_ID">
<span<?= $Page->STYPE_ID->viewAttributes() ?>>
<?= $Page->STYPE_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->GROUP_ID->Visible) { // GROUP_ID ?>
    <tr id="r_GROUP_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_USERS_MENU_GROUP_ID"><?= $Page->GROUP_ID->caption() ?></span></td>
        <td data-name="GROUP_ID" <?= $Page->GROUP_ID->cellAttributes() ?>>
<span id="el_USERS_MENU_GROUP_ID">
<span<?= $Page->GROUP_ID->viewAttributes() ?>>
<?= $Page->GROUP_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->C->Visible) { // C ?>
    <tr id="r_C">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_USERS_MENU_C"><?= $Page->C->caption() ?></span></td>
        <td data-name="C" <?= $Page->C->cellAttributes() ?>>
<span id="el_USERS_MENU_C">
<span<?= $Page->C->viewAttributes() ?>>
<?= $Page->C->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->R->Visible) { // R ?>
    <tr id="r_R">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_USERS_MENU_R"><?= $Page->R->caption() ?></span></td>
        <td data-name="R" <?= $Page->R->cellAttributes() ?>>
<span id="el_USERS_MENU_R">
<span<?= $Page->R->viewAttributes() ?>>
<?= $Page->R->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->U->Visible) { // U ?>
    <tr id="r_U">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_USERS_MENU_U"><?= $Page->U->caption() ?></span></td>
        <td data-name="U" <?= $Page->U->cellAttributes() ?>>
<span id="el_USERS_MENU_U">
<span<?= $Page->U->viewAttributes() ?>>
<?= $Page->U->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->D->Visible) { // D ?>
    <tr id="r_D">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_USERS_MENU_D"><?= $Page->D->caption() ?></span></td>
        <td data-name="D" <?= $Page->D->cellAttributes() ?>>
<span id="el_USERS_MENU_D">
<span<?= $Page->D->viewAttributes() ?>>
<?= $Page->D->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->P->Visible) { // P ?>
    <tr id="r_P">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_USERS_MENU_P"><?= $Page->P->caption() ?></span></td>
        <td data-name="P" <?= $Page->P->cellAttributes() ?>>
<span id="el_USERS_MENU_P">
<span<?= $Page->P->viewAttributes() ?>>
<?= $Page->P->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->E->Visible) { // E ?>
    <tr id="r_E">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_USERS_MENU_E"><?= $Page->E->caption() ?></span></td>
        <td data-name="E" <?= $Page->E->cellAttributes() ?>>
<span id="el_USERS_MENU_E">
<span<?= $Page->E->viewAttributes() ?>>
<?= $Page->E->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->C_TIME->Visible) { // C_TIME ?>
    <tr id="r_C_TIME">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_USERS_MENU_C_TIME"><?= $Page->C_TIME->caption() ?></span></td>
        <td data-name="C_TIME" <?= $Page->C_TIME->cellAttributes() ?>>
<span id="el_USERS_MENU_C_TIME">
<span<?= $Page->C_TIME->viewAttributes() ?>>
<?= $Page->C_TIME->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->U_TIME->Visible) { // U_TIME ?>
    <tr id="r_U_TIME">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_USERS_MENU_U_TIME"><?= $Page->U_TIME->caption() ?></span></td>
        <td data-name="U_TIME" <?= $Page->U_TIME->cellAttributes() ?>>
<span id="el_USERS_MENU_U_TIME">
<span<?= $Page->U_TIME->viewAttributes() ?>>
<?= $Page->U_TIME->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->D_TIME->Visible) { // D_TIME ?>
    <tr id="r_D_TIME">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_USERS_MENU_D_TIME"><?= $Page->D_TIME->caption() ?></span></td>
        <td data-name="D_TIME" <?= $Page->D_TIME->cellAttributes() ?>>
<span id="el_USERS_MENU_D_TIME">
<span<?= $Page->D_TIME->viewAttributes() ?>>
<?= $Page->D_TIME->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
    <tr id="r_MODIFIED_DATE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_USERS_MENU_MODIFIED_DATE"><?= $Page->MODIFIED_DATE->caption() ?></span></td>
        <td data-name="MODIFIED_DATE" <?= $Page->MODIFIED_DATE->cellAttributes() ?>>
<span id="el_USERS_MENU_MODIFIED_DATE">
<span<?= $Page->MODIFIED_DATE->viewAttributes() ?>>
<?= $Page->MODIFIED_DATE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
    <tr id="r_MODIFIED_BY">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_USERS_MENU_MODIFIED_BY"><?= $Page->MODIFIED_BY->caption() ?></span></td>
        <td data-name="MODIFIED_BY" <?= $Page->MODIFIED_BY->cellAttributes() ?>>
<span id="el_USERS_MENU_MODIFIED_BY">
<span<?= $Page->MODIFIED_BY->viewAttributes() ?>>
<?= $Page->MODIFIED_BY->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
