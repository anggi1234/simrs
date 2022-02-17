<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

// Page object
$WebsiteMenuTypeDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fWEBSITE_MENU_TYPEdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fWEBSITE_MENU_TYPEdelete = currentForm = new ew.Form("fWEBSITE_MENU_TYPEdelete", "delete");
    loadjs.done("fWEBSITE_MENU_TYPEdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.WEBSITE_MENU_TYPE) ew.vars.tables.WEBSITE_MENU_TYPE = <?= JsonEncode(GetClientVar("tables", "WEBSITE_MENU_TYPE")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fWEBSITE_MENU_TYPEdelete" id="fWEBSITE_MENU_TYPEdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="WEBSITE_MENU_TYPE">
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
<?php if ($Page->menu_type->Visible) { // menu_type ?>
        <th class="<?= $Page->menu_type->headerCellClass() ?>"><span id="elh_WEBSITE_MENU_TYPE_menu_type" class="WEBSITE_MENU_TYPE_menu_type"><?= $Page->menu_type->caption() ?></span></th>
<?php } ?>
<?php if ($Page->menutype->Visible) { // menutype ?>
        <th class="<?= $Page->menutype->headerCellClass() ?>"><span id="elh_WEBSITE_MENU_TYPE_menutype" class="WEBSITE_MENU_TYPE_menutype"><?= $Page->menutype->caption() ?></span></th>
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
<?php if ($Page->menu_type->Visible) { // menu_type ?>
        <td <?= $Page->menu_type->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_WEBSITE_MENU_TYPE_menu_type" class="WEBSITE_MENU_TYPE_menu_type">
<span<?= $Page->menu_type->viewAttributes() ?>>
<?= $Page->menu_type->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->menutype->Visible) { // menutype ?>
        <td <?= $Page->menutype->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_WEBSITE_MENU_TYPE_menutype" class="WEBSITE_MENU_TYPE_menutype">
<span<?= $Page->menutype->viewAttributes() ?>>
<?= $Page->menutype->getViewValue() ?></span>
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
