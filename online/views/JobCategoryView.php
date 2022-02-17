<?php

namespace PHPMaker2021\Online;

// Page object
$JobCategoryView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fJOB_CATEGORYview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fJOB_CATEGORYview = currentForm = new ew.Form("fJOB_CATEGORYview", "view");
    loadjs.done("fJOB_CATEGORYview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.JOB_CATEGORY) ew.vars.tables.JOB_CATEGORY = <?= JsonEncode(GetClientVar("tables", "JOB_CATEGORY")) ?>;
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
<form name="fJOB_CATEGORYview" id="fJOB_CATEGORYview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="JOB_CATEGORY">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-bordered table-hover ew-view-table">
<?php if ($Page->JOB_ID->Visible) { // JOB_ID ?>
    <tr id="r_JOB_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_JOB_CATEGORY_JOB_ID"><?= $Page->JOB_ID->caption() ?></span></td>
        <td data-name="JOB_ID" <?= $Page->JOB_ID->cellAttributes() ?>>
<span id="el_JOB_CATEGORY_JOB_ID">
<span<?= $Page->JOB_ID->viewAttributes() ?>>
<?= $Page->JOB_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->NAME_OF_JOB->Visible) { // NAME_OF_JOB ?>
    <tr id="r_NAME_OF_JOB">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_JOB_CATEGORY_NAME_OF_JOB"><?= $Page->NAME_OF_JOB->caption() ?></span></td>
        <td data-name="NAME_OF_JOB" <?= $Page->NAME_OF_JOB->cellAttributes() ?>>
<span id="el_JOB_CATEGORY_NAME_OF_JOB">
<span<?= $Page->NAME_OF_JOB->viewAttributes() ?>>
<?= $Page->NAME_OF_JOB->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->DESCRIPTION->Visible) { // DESCRIPTION ?>
    <tr id="r_DESCRIPTION">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_JOB_CATEGORY_DESCRIPTION"><?= $Page->DESCRIPTION->caption() ?></span></td>
        <td data-name="DESCRIPTION" <?= $Page->DESCRIPTION->cellAttributes() ?>>
<span id="el_JOB_CATEGORY_DESCRIPTION">
<span<?= $Page->DESCRIPTION->viewAttributes() ?>>
<?= $Page->DESCRIPTION->getViewValue() ?></span>
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
