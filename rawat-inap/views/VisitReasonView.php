<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

// Page object
$VisitReasonView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fVISIT_REASONview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fVISIT_REASONview = currentForm = new ew.Form("fVISIT_REASONview", "view");
    loadjs.done("fVISIT_REASONview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.VISIT_REASON) ew.vars.tables.VISIT_REASON = <?= JsonEncode(GetClientVar("tables", "VISIT_REASON")) ?>;
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
<form name="fVISIT_REASONview" id="fVISIT_REASONview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="VISIT_REASON">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-bordered table-hover ew-view-table">
<?php if ($Page->REASON_ID->Visible) { // REASON_ID ?>
    <tr id="r_REASON_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_VISIT_REASON_REASON_ID"><?= $Page->REASON_ID->caption() ?></span></td>
        <td data-name="REASON_ID" <?= $Page->REASON_ID->cellAttributes() ?>>
<span id="el_VISIT_REASON_REASON_ID">
<span<?= $Page->REASON_ID->viewAttributes() ?>>
<?= $Page->REASON_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->REASON->Visible) { // REASON ?>
    <tr id="r_REASON">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_VISIT_REASON_REASON"><?= $Page->REASON->caption() ?></span></td>
        <td data-name="REASON" <?= $Page->REASON->cellAttributes() ?>>
<span id="el_VISIT_REASON_REASON">
<span<?= $Page->REASON->viewAttributes() ?>>
<?= $Page->REASON->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->LAKALANTAS->Visible) { // LAKALANTAS ?>
    <tr id="r_LAKALANTAS">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_VISIT_REASON_LAKALANTAS"><?= $Page->LAKALANTAS->caption() ?></span></td>
        <td data-name="LAKALANTAS" <?= $Page->LAKALANTAS->cellAttributes() ?>>
<span id="el_VISIT_REASON_LAKALANTAS">
<span<?= $Page->LAKALANTAS->viewAttributes() ?>>
<?= $Page->LAKALANTAS->getViewValue() ?></span>
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
