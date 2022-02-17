<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

// Page object
$WebsiteMenuTypeView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fWEBSITE_MENU_TYPEview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fWEBSITE_MENU_TYPEview = currentForm = new ew.Form("fWEBSITE_MENU_TYPEview", "view");
    loadjs.done("fWEBSITE_MENU_TYPEview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.WEBSITE_MENU_TYPE) ew.vars.tables.WEBSITE_MENU_TYPE = <?= JsonEncode(GetClientVar("tables", "WEBSITE_MENU_TYPE")) ?>;
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
<form name="fWEBSITE_MENU_TYPEview" id="fWEBSITE_MENU_TYPEview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="WEBSITE_MENU_TYPE">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-bordered table-hover ew-view-table">
<?php if ($Page->menu_type->Visible) { // menu_type ?>
    <tr id="r_menu_type">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_WEBSITE_MENU_TYPE_menu_type"><?= $Page->menu_type->caption() ?></span></td>
        <td data-name="menu_type" <?= $Page->menu_type->cellAttributes() ?>>
<span id="el_WEBSITE_MENU_TYPE_menu_type">
<span<?= $Page->menu_type->viewAttributes() ?>>
<?= $Page->menu_type->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->menutype->Visible) { // menutype ?>
    <tr id="r_menutype">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_WEBSITE_MENU_TYPE_menutype"><?= $Page->menutype->caption() ?></span></td>
        <td data-name="menutype" <?= $Page->menutype->cellAttributes() ?>>
<span id="el_WEBSITE_MENU_TYPE_menutype">
<span<?= $Page->menutype->viewAttributes() ?>>
<?= $Page->menutype->getViewValue() ?></span>
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
