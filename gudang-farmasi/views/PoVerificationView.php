<?php

namespace PHPMaker2021\SIMRSSQLSERVERGUDANGFARMASI;

// Page object
$PoVerificationView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fPO_VERIFICATIONview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fPO_VERIFICATIONview = currentForm = new ew.Form("fPO_VERIFICATIONview", "view");
    loadjs.done("fPO_VERIFICATIONview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.PO_VERIFICATION) ew.vars.tables.PO_VERIFICATION = <?= JsonEncode(GetClientVar("tables", "PO_VERIFICATION")) ?>;
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
<form name="fPO_VERIFICATIONview" id="fPO_VERIFICATIONview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="PO_VERIFICATION">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-bordered table-hover ew-view-table">
<?php if ($Page->PO->Visible) { // PO ?>
    <tr id="r_PO">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_VERIFICATION_PO"><?= $Page->PO->caption() ?></span></td>
        <td data-name="PO" <?= $Page->PO->cellAttributes() ?>>
<span id="el_PO_VERIFICATION_PO">
<span<?= $Page->PO->viewAttributes() ?>>
<?= $Page->PO->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ISVALID->Visible) { // ISVALID ?>
    <tr id="r_ISVALID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_VERIFICATION_ISVALID"><?= $Page->ISVALID->caption() ?></span></td>
        <td data-name="ISVALID" <?= $Page->ISVALID->cellAttributes() ?>>
<span id="el_PO_VERIFICATION_ISVALID">
<span<?= $Page->ISVALID->viewAttributes() ?>>
<?= $Page->ISVALID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->VERIFIED_DATE->Visible) { // VERIFIED_DATE ?>
    <tr id="r_VERIFIED_DATE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_VERIFICATION_VERIFIED_DATE"><?= $Page->VERIFIED_DATE->caption() ?></span></td>
        <td data-name="VERIFIED_DATE" <?= $Page->VERIFIED_DATE->cellAttributes() ?>>
<span id="el_PO_VERIFICATION_VERIFIED_DATE">
<span<?= $Page->VERIFIED_DATE->viewAttributes() ?>>
<?= $Page->VERIFIED_DATE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->VERIFIED_BY->Visible) { // VERIFIED_BY ?>
    <tr id="r_VERIFIED_BY">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_VERIFICATION_VERIFIED_BY"><?= $Page->VERIFIED_BY->caption() ?></span></td>
        <td data-name="VERIFIED_BY" <?= $Page->VERIFIED_BY->cellAttributes() ?>>
<span id="el_PO_VERIFICATION_VERIFIED_BY">
<span<?= $Page->VERIFIED_BY->viewAttributes() ?>>
<?= $Page->VERIFIED_BY->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->VERIFICATION_DESC->Visible) { // VERIFICATION_DESC ?>
    <tr id="r_VERIFICATION_DESC">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_VERIFICATION_VERIFICATION_DESC"><?= $Page->VERIFICATION_DESC->caption() ?></span></td>
        <td data-name="VERIFICATION_DESC" <?= $Page->VERIFICATION_DESC->cellAttributes() ?>>
<span id="el_PO_VERIFICATION_VERIFICATION_DESC">
<span<?= $Page->VERIFICATION_DESC->viewAttributes() ?>>
<?= $Page->VERIFICATION_DESC->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
    <tr id="r_MODIFIED_DATE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_VERIFICATION_MODIFIED_DATE"><?= $Page->MODIFIED_DATE->caption() ?></span></td>
        <td data-name="MODIFIED_DATE" <?= $Page->MODIFIED_DATE->cellAttributes() ?>>
<span id="el_PO_VERIFICATION_MODIFIED_DATE">
<span<?= $Page->MODIFIED_DATE->viewAttributes() ?>>
<?= $Page->MODIFIED_DATE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
    <tr id="r_MODIFIED_BY">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_VERIFICATION_MODIFIED_BY"><?= $Page->MODIFIED_BY->caption() ?></span></td>
        <td data-name="MODIFIED_BY" <?= $Page->MODIFIED_BY->cellAttributes() ?>>
<span id="el_PO_VERIFICATION_MODIFIED_BY">
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
