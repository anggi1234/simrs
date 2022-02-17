<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

// Page object
$TreatmentResultsView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fTREATMENT_RESULTSview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fTREATMENT_RESULTSview = currentForm = new ew.Form("fTREATMENT_RESULTSview", "view");
    loadjs.done("fTREATMENT_RESULTSview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.TREATMENT_RESULTS) ew.vars.tables.TREATMENT_RESULTS = <?= JsonEncode(GetClientVar("tables", "TREATMENT_RESULTS")) ?>;
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
<form name="fTREATMENT_RESULTSview" id="fTREATMENT_RESULTSview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="TREATMENT_RESULTS">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-bordered table-hover ew-view-table">
<?php if ($Page->RESULT_ID->Visible) { // RESULT_ID ?>
    <tr id="r_RESULT_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_RESULTS_RESULT_ID"><?= $Page->RESULT_ID->caption() ?></span></td>
        <td data-name="RESULT_ID" <?= $Page->RESULT_ID->cellAttributes() ?>>
<span id="el_TREATMENT_RESULTS_RESULT_ID">
<span<?= $Page->RESULT_ID->viewAttributes() ?>>
<?= $Page->RESULT_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->RESULTS->Visible) { // RESULTS ?>
    <tr id="r_RESULTS">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_RESULTS_RESULTS"><?= $Page->RESULTS->caption() ?></span></td>
        <td data-name="RESULTS" <?= $Page->RESULTS->cellAttributes() ?>>
<span id="el_TREATMENT_RESULTS_RESULTS">
<span<?= $Page->RESULTS->viewAttributes() ?>>
<?= $Page->RESULTS->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->DESCRIPTION->Visible) { // DESCRIPTION ?>
    <tr id="r_DESCRIPTION">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_RESULTS_DESCRIPTION"><?= $Page->DESCRIPTION->caption() ?></span></td>
        <td data-name="DESCRIPTION" <?= $Page->DESCRIPTION->cellAttributes() ?>>
<span id="el_TREATMENT_RESULTS_DESCRIPTION">
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
