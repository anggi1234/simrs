<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

// Page object
$UserPermissionView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fUSER_PERMISSIONview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fUSER_PERMISSIONview = currentForm = new ew.Form("fUSER_PERMISSIONview", "view");
    loadjs.done("fUSER_PERMISSIONview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.USER_PERMISSION) ew.vars.tables.USER_PERMISSION = <?= JsonEncode(GetClientVar("tables", "USER_PERMISSION")) ?>;
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
<form name="fUSER_PERMISSIONview" id="fUSER_PERMISSIONview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="USER_PERMISSION">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-bordered table-hover ew-view-table">
<?php if ($Page->PERMISSION_ID->Visible) { // PERMISSION_ID ?>
    <tr id="r_PERMISSION_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_USER_PERMISSION_PERMISSION_ID"><?= $Page->PERMISSION_ID->caption() ?></span></td>
        <td data-name="PERMISSION_ID" <?= $Page->PERMISSION_ID->cellAttributes() ?>>
<span id="el_USER_PERMISSION_PERMISSION_ID">
<span<?= $Page->PERMISSION_ID->viewAttributes() ?>>
<?= $Page->PERMISSION_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_PERMISSIONS->Visible) { // PERMISSIONS ?>
    <tr id="r__PERMISSIONS">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_USER_PERMISSION__PERMISSIONS"><?= $Page->_PERMISSIONS->caption() ?></span></td>
        <td data-name="_PERMISSIONS" <?= $Page->_PERMISSIONS->cellAttributes() ?>>
<span id="el_USER_PERMISSION__PERMISSIONS">
<span<?= $Page->_PERMISSIONS->viewAttributes() ?>>
<?= $Page->_PERMISSIONS->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
    <tr id="r_MODIFIED_DATE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_USER_PERMISSION_MODIFIED_DATE"><?= $Page->MODIFIED_DATE->caption() ?></span></td>
        <td data-name="MODIFIED_DATE" <?= $Page->MODIFIED_DATE->cellAttributes() ?>>
<span id="el_USER_PERMISSION_MODIFIED_DATE">
<span<?= $Page->MODIFIED_DATE->viewAttributes() ?>>
<?= $Page->MODIFIED_DATE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
    <tr id="r_MODIFIED_BY">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_USER_PERMISSION_MODIFIED_BY"><?= $Page->MODIFIED_BY->caption() ?></span></td>
        <td data-name="MODIFIED_BY" <?= $Page->MODIFIED_BY->cellAttributes() ?>>
<span id="el_USER_PERMISSION_MODIFIED_BY">
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
