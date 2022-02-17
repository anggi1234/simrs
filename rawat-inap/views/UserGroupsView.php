<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

// Page object
$UserGroupsView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fUSER_GROUPSview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fUSER_GROUPSview = currentForm = new ew.Form("fUSER_GROUPSview", "view");
    loadjs.done("fUSER_GROUPSview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.USER_GROUPS) ew.vars.tables.USER_GROUPS = <?= JsonEncode(GetClientVar("tables", "USER_GROUPS")) ?>;
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
<form name="fUSER_GROUPSview" id="fUSER_GROUPSview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="USER_GROUPS">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-bordered table-hover ew-view-table">
<?php if ($Page->ORG_UNIT_CODE->Visible) { // ORG_UNIT_CODE ?>
    <tr id="r_ORG_UNIT_CODE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_USER_GROUPS_ORG_UNIT_CODE"><?= $Page->ORG_UNIT_CODE->caption() ?></span></td>
        <td data-name="ORG_UNIT_CODE" <?= $Page->ORG_UNIT_CODE->cellAttributes() ?>>
<span id="el_USER_GROUPS_ORG_UNIT_CODE">
<span<?= $Page->ORG_UNIT_CODE->viewAttributes() ?>>
<?= $Page->ORG_UNIT_CODE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->GROUP_ID->Visible) { // GROUP_ID ?>
    <tr id="r_GROUP_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_USER_GROUPS_GROUP_ID"><?= $Page->GROUP_ID->caption() ?></span></td>
        <td data-name="GROUP_ID" <?= $Page->GROUP_ID->cellAttributes() ?>>
<span id="el_USER_GROUPS_GROUP_ID">
<span<?= $Page->GROUP_ID->viewAttributes() ?>>
<?= $Page->GROUP_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->GROUP_NAME->Visible) { // GROUP_NAME ?>
    <tr id="r_GROUP_NAME">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_USER_GROUPS_GROUP_NAME"><?= $Page->GROUP_NAME->caption() ?></span></td>
        <td data-name="GROUP_NAME" <?= $Page->GROUP_NAME->cellAttributes() ?>>
<span id="el_USER_GROUPS_GROUP_NAME">
<span<?= $Page->GROUP_NAME->viewAttributes() ?>>
<?= $Page->GROUP_NAME->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ISUSED->Visible) { // ISUSED ?>
    <tr id="r_ISUSED">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_USER_GROUPS_ISUSED"><?= $Page->ISUSED->caption() ?></span></td>
        <td data-name="ISUSED" <?= $Page->ISUSED->cellAttributes() ?>>
<span id="el_USER_GROUPS_ISUSED">
<span<?= $Page->ISUSED->viewAttributes() ?>>
<?= $Page->ISUSED->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->STYPE_ID->Visible) { // STYPE_ID ?>
    <tr id="r_STYPE_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_USER_GROUPS_STYPE_ID"><?= $Page->STYPE_ID->caption() ?></span></td>
        <td data-name="STYPE_ID" <?= $Page->STYPE_ID->cellAttributes() ?>>
<span id="el_USER_GROUPS_STYPE_ID">
<span<?= $Page->STYPE_ID->viewAttributes() ?>>
<?= $Page->STYPE_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
    <tr id="r_MODIFIED_DATE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_USER_GROUPS_MODIFIED_DATE"><?= $Page->MODIFIED_DATE->caption() ?></span></td>
        <td data-name="MODIFIED_DATE" <?= $Page->MODIFIED_DATE->cellAttributes() ?>>
<span id="el_USER_GROUPS_MODIFIED_DATE">
<span<?= $Page->MODIFIED_DATE->viewAttributes() ?>>
<?= $Page->MODIFIED_DATE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
    <tr id="r_MODIFIED_BY">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_USER_GROUPS_MODIFIED_BY"><?= $Page->MODIFIED_BY->caption() ?></span></td>
        <td data-name="MODIFIED_BY" <?= $Page->MODIFIED_BY->cellAttributes() ?>>
<span id="el_USER_GROUPS_MODIFIED_BY">
<span<?= $Page->MODIFIED_BY->viewAttributes() ?>>
<?= $Page->MODIFIED_BY->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->THEID->Visible) { // THEID ?>
    <tr id="r_THEID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_USER_GROUPS_THEID"><?= $Page->THEID->caption() ?></span></td>
        <td data-name="THEID" <?= $Page->THEID->cellAttributes() ?>>
<span id="el_USER_GROUPS_THEID">
<span<?= $Page->THEID->viewAttributes() ?>>
<?= $Page->THEID->getViewValue() ?></span>
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
