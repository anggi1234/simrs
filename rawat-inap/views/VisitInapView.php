<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

// Page object
$VisitInapView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fVISIT_INAPview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fVISIT_INAPview = currentForm = new ew.Form("fVISIT_INAPview", "view");
    loadjs.done("fVISIT_INAPview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.VISIT_INAP) ew.vars.tables.VISIT_INAP = <?= JsonEncode(GetClientVar("tables", "VISIT_INAP")) ?>;
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
<form name="fVISIT_INAPview" id="fVISIT_INAPview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="VISIT_INAP">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-bordered table-hover ew-view-table">
<?php if ($Page->VISIT_INAP_ID->Visible) { // VISIT_INAP_ID ?>
    <tr id="r_VISIT_INAP_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_VISIT_INAP_VISIT_INAP_ID"><?= $Page->VISIT_INAP_ID->caption() ?></span></td>
        <td data-name="VISIT_INAP_ID" <?= $Page->VISIT_INAP_ID->cellAttributes() ?>>
<span id="el_VISIT_INAP_VISIT_INAP_ID">
<span<?= $Page->VISIT_INAP_ID->viewAttributes() ?>>
<?= $Page->VISIT_INAP_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->VISIT_INAP->Visible) { // VISIT_INAP ?>
    <tr id="r_VISIT_INAP">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_VISIT_INAP_VISIT_INAP"><?= $Page->VISIT_INAP->caption() ?></span></td>
        <td data-name="VISIT_INAP" <?= $Page->VISIT_INAP->cellAttributes() ?>>
<span id="el_VISIT_INAP_VISIT_INAP">
<span<?= $Page->VISIT_INAP->viewAttributes() ?>>
<?= $Page->VISIT_INAP->getViewValue() ?></span>
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
