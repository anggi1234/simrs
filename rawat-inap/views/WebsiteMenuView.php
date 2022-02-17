<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

// Page object
$WebsiteMenuView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fWEBSITE_MENUview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fWEBSITE_MENUview = currentForm = new ew.Form("fWEBSITE_MENUview", "view");
    loadjs.done("fWEBSITE_MENUview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.WEBSITE_MENU) ew.vars.tables.WEBSITE_MENU = <?= JsonEncode(GetClientVar("tables", "WEBSITE_MENU")) ?>;
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
<form name="fWEBSITE_MENUview" id="fWEBSITE_MENUview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="WEBSITE_MENU">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-bordered table-hover ew-view-table">
<?php if ($Page->MENU_ID->Visible) { // MENU_ID ?>
    <tr id="r_MENU_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_WEBSITE_MENU_MENU_ID"><?= $Page->MENU_ID->caption() ?></span></td>
        <td data-name="MENU_ID" <?= $Page->MENU_ID->cellAttributes() ?>>
<span id="el_WEBSITE_MENU_MENU_ID">
<span<?= $Page->MENU_ID->viewAttributes() ?>>
<?= $Page->MENU_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->javascript_id->Visible) { // javascript_id ?>
    <tr id="r_javascript_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_WEBSITE_MENU_javascript_id"><?= $Page->javascript_id->caption() ?></span></td>
        <td data-name="javascript_id" <?= $Page->javascript_id->cellAttributes() ?>>
<span id="el_WEBSITE_MENU_javascript_id">
<span<?= $Page->javascript_id->viewAttributes() ?>>
<?= $Page->javascript_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->file_name->Visible) { // file_name ?>
    <tr id="r_file_name">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_WEBSITE_MENU_file_name"><?= $Page->file_name->caption() ?></span></td>
        <td data-name="file_name" <?= $Page->file_name->cellAttributes() ?>>
<span id="el_WEBSITE_MENU_file_name">
<span<?= $Page->file_name->viewAttributes() ?>>
<?= $Page->file_name->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->menu_name->Visible) { // menu_name ?>
    <tr id="r_menu_name">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_WEBSITE_MENU_menu_name"><?= $Page->menu_name->caption() ?></span></td>
        <td data-name="menu_name" <?= $Page->menu_name->cellAttributes() ?>>
<span id="el_WEBSITE_MENU_menu_name">
<span<?= $Page->menu_name->viewAttributes() ?>>
<?= $Page->menu_name->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->isactive->Visible) { // isactive ?>
    <tr id="r_isactive">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_WEBSITE_MENU_isactive"><?= $Page->isactive->caption() ?></span></td>
        <td data-name="isactive" <?= $Page->isactive->cellAttributes() ?>>
<span id="el_WEBSITE_MENU_isactive">
<span<?= $Page->isactive->viewAttributes() ?>>
<?= $Page->isactive->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->menu_type->Visible) { // menu_type ?>
    <tr id="r_menu_type">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_WEBSITE_MENU_menu_type"><?= $Page->menu_type->caption() ?></span></td>
        <td data-name="menu_type" <?= $Page->menu_type->cellAttributes() ?>>
<span id="el_WEBSITE_MENU_menu_type">
<span<?= $Page->menu_type->viewAttributes() ?>>
<?= $Page->menu_type->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->header_name->Visible) { // header_name ?>
    <tr id="r_header_name">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_WEBSITE_MENU_header_name"><?= $Page->header_name->caption() ?></span></td>
        <td data-name="header_name" <?= $Page->header_name->cellAttributes() ?>>
<span id="el_WEBSITE_MENU_header_name">
<span<?= $Page->header_name->viewAttributes() ?>>
<?= $Page->header_name->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->isslide->Visible) { // isslide ?>
    <tr id="r_isslide">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_WEBSITE_MENU_isslide"><?= $Page->isslide->caption() ?></span></td>
        <td data-name="isslide" <?= $Page->isslide->cellAttributes() ?>>
<span id="el_WEBSITE_MENU_isslide">
<span<?= $Page->isslide->viewAttributes() ?>>
<?= $Page->isslide->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->timeslide->Visible) { // timeslide ?>
    <tr id="r_timeslide">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_WEBSITE_MENU_timeslide"><?= $Page->timeslide->caption() ?></span></td>
        <td data-name="timeslide" <?= $Page->timeslide->cellAttributes() ?>>
<span id="el_WEBSITE_MENU_timeslide">
<span<?= $Page->timeslide->viewAttributes() ?>>
<?= $Page->timeslide->getViewValue() ?></span>
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
