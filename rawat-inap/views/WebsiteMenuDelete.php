<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

// Page object
$WebsiteMenuDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fWEBSITE_MENUdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fWEBSITE_MENUdelete = currentForm = new ew.Form("fWEBSITE_MENUdelete", "delete");
    loadjs.done("fWEBSITE_MENUdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.WEBSITE_MENU) ew.vars.tables.WEBSITE_MENU = <?= JsonEncode(GetClientVar("tables", "WEBSITE_MENU")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fWEBSITE_MENUdelete" id="fWEBSITE_MENUdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="WEBSITE_MENU">
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
<?php if ($Page->MENU_ID->Visible) { // MENU_ID ?>
        <th class="<?= $Page->MENU_ID->headerCellClass() ?>"><span id="elh_WEBSITE_MENU_MENU_ID" class="WEBSITE_MENU_MENU_ID"><?= $Page->MENU_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->javascript_id->Visible) { // javascript_id ?>
        <th class="<?= $Page->javascript_id->headerCellClass() ?>"><span id="elh_WEBSITE_MENU_javascript_id" class="WEBSITE_MENU_javascript_id"><?= $Page->javascript_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->file_name->Visible) { // file_name ?>
        <th class="<?= $Page->file_name->headerCellClass() ?>"><span id="elh_WEBSITE_MENU_file_name" class="WEBSITE_MENU_file_name"><?= $Page->file_name->caption() ?></span></th>
<?php } ?>
<?php if ($Page->menu_name->Visible) { // menu_name ?>
        <th class="<?= $Page->menu_name->headerCellClass() ?>"><span id="elh_WEBSITE_MENU_menu_name" class="WEBSITE_MENU_menu_name"><?= $Page->menu_name->caption() ?></span></th>
<?php } ?>
<?php if ($Page->isactive->Visible) { // isactive ?>
        <th class="<?= $Page->isactive->headerCellClass() ?>"><span id="elh_WEBSITE_MENU_isactive" class="WEBSITE_MENU_isactive"><?= $Page->isactive->caption() ?></span></th>
<?php } ?>
<?php if ($Page->menu_type->Visible) { // menu_type ?>
        <th class="<?= $Page->menu_type->headerCellClass() ?>"><span id="elh_WEBSITE_MENU_menu_type" class="WEBSITE_MENU_menu_type"><?= $Page->menu_type->caption() ?></span></th>
<?php } ?>
<?php if ($Page->header_name->Visible) { // header_name ?>
        <th class="<?= $Page->header_name->headerCellClass() ?>"><span id="elh_WEBSITE_MENU_header_name" class="WEBSITE_MENU_header_name"><?= $Page->header_name->caption() ?></span></th>
<?php } ?>
<?php if ($Page->isslide->Visible) { // isslide ?>
        <th class="<?= $Page->isslide->headerCellClass() ?>"><span id="elh_WEBSITE_MENU_isslide" class="WEBSITE_MENU_isslide"><?= $Page->isslide->caption() ?></span></th>
<?php } ?>
<?php if ($Page->timeslide->Visible) { // timeslide ?>
        <th class="<?= $Page->timeslide->headerCellClass() ?>"><span id="elh_WEBSITE_MENU_timeslide" class="WEBSITE_MENU_timeslide"><?= $Page->timeslide->caption() ?></span></th>
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
<?php if ($Page->MENU_ID->Visible) { // MENU_ID ?>
        <td <?= $Page->MENU_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_WEBSITE_MENU_MENU_ID" class="WEBSITE_MENU_MENU_ID">
<span<?= $Page->MENU_ID->viewAttributes() ?>>
<?= $Page->MENU_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->javascript_id->Visible) { // javascript_id ?>
        <td <?= $Page->javascript_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_WEBSITE_MENU_javascript_id" class="WEBSITE_MENU_javascript_id">
<span<?= $Page->javascript_id->viewAttributes() ?>>
<?= $Page->javascript_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->file_name->Visible) { // file_name ?>
        <td <?= $Page->file_name->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_WEBSITE_MENU_file_name" class="WEBSITE_MENU_file_name">
<span<?= $Page->file_name->viewAttributes() ?>>
<?= $Page->file_name->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->menu_name->Visible) { // menu_name ?>
        <td <?= $Page->menu_name->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_WEBSITE_MENU_menu_name" class="WEBSITE_MENU_menu_name">
<span<?= $Page->menu_name->viewAttributes() ?>>
<?= $Page->menu_name->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->isactive->Visible) { // isactive ?>
        <td <?= $Page->isactive->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_WEBSITE_MENU_isactive" class="WEBSITE_MENU_isactive">
<span<?= $Page->isactive->viewAttributes() ?>>
<?= $Page->isactive->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->menu_type->Visible) { // menu_type ?>
        <td <?= $Page->menu_type->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_WEBSITE_MENU_menu_type" class="WEBSITE_MENU_menu_type">
<span<?= $Page->menu_type->viewAttributes() ?>>
<?= $Page->menu_type->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->header_name->Visible) { // header_name ?>
        <td <?= $Page->header_name->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_WEBSITE_MENU_header_name" class="WEBSITE_MENU_header_name">
<span<?= $Page->header_name->viewAttributes() ?>>
<?= $Page->header_name->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->isslide->Visible) { // isslide ?>
        <td <?= $Page->isslide->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_WEBSITE_MENU_isslide" class="WEBSITE_MENU_isslide">
<span<?= $Page->isslide->viewAttributes() ?>>
<?= $Page->isslide->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->timeslide->Visible) { // timeslide ?>
        <td <?= $Page->timeslide->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_WEBSITE_MENU_timeslide" class="WEBSITE_MENU_timeslide">
<span<?= $Page->timeslide->viewAttributes() ?>>
<?= $Page->timeslide->getViewValue() ?></span>
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
