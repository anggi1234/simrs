<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

// Page object
$VisitWayView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fVISIT_WAYview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fVISIT_WAYview = currentForm = new ew.Form("fVISIT_WAYview", "view");
    loadjs.done("fVISIT_WAYview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.VISIT_WAY) ew.vars.tables.VISIT_WAY = <?= JsonEncode(GetClientVar("tables", "VISIT_WAY")) ?>;
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
<form name="fVISIT_WAYview" id="fVISIT_WAYview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="VISIT_WAY">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-bordered table-hover ew-view-table">
<?php if ($Page->WAY_ID->Visible) { // WAY_ID ?>
    <tr id="r_WAY_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_VISIT_WAY_WAY_ID"><?= $Page->WAY_ID->caption() ?></span></td>
        <td data-name="WAY_ID" <?= $Page->WAY_ID->cellAttributes() ?>>
<span id="el_VISIT_WAY_WAY_ID">
<span<?= $Page->WAY_ID->viewAttributes() ?>>
<?= $Page->WAY_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->WAY->Visible) { // WAY ?>
    <tr id="r_WAY">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_VISIT_WAY_WAY"><?= $Page->WAY->caption() ?></span></td>
        <td data-name="WAY" <?= $Page->WAY->cellAttributes() ?>>
<span id="el_VISIT_WAY_WAY">
<span<?= $Page->WAY->viewAttributes() ?>>
<?= $Page->WAY->getViewValue() ?></span>
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
