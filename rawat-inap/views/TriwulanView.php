<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

// Page object
$TriwulanView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var ftriwulanview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    ftriwulanview = currentForm = new ew.Form("ftriwulanview", "view");
    loadjs.done("ftriwulanview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.triwulan) ew.vars.tables.triwulan = <?= JsonEncode(GetClientVar("tables", "triwulan")) ?>;
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
<form name="ftriwulanview" id="ftriwulanview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="triwulan">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-bordered table-hover ew-view-table">
<?php if ($Page->triwulan->Visible) { // triwulan ?>
    <tr id="r_triwulan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_triwulan_triwulan"><?= $Page->triwulan->caption() ?></span></td>
        <td data-name="triwulan" <?= $Page->triwulan->cellAttributes() ?>>
<span id="el_triwulan_triwulan">
<span<?= $Page->triwulan->viewAttributes() ?>>
<?= $Page->triwulan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->keterangan->Visible) { // keterangan ?>
    <tr id="r_keterangan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_triwulan_keterangan"><?= $Page->keterangan->caption() ?></span></td>
        <td data-name="keterangan" <?= $Page->keterangan->cellAttributes() ?>>
<span id="el_triwulan_keterangan">
<span<?= $Page->keterangan->viewAttributes() ?>>
<?= $Page->keterangan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->mulai->Visible) { // mulai ?>
    <tr id="r_mulai">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_triwulan_mulai"><?= $Page->mulai->caption() ?></span></td>
        <td data-name="mulai" <?= $Page->mulai->cellAttributes() ?>>
<span id="el_triwulan_mulai">
<span<?= $Page->mulai->viewAttributes() ?>>
<?= $Page->mulai->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->akhir->Visible) { // akhir ?>
    <tr id="r_akhir">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_triwulan_akhir"><?= $Page->akhir->caption() ?></span></td>
        <td data-name="akhir" <?= $Page->akhir->cellAttributes() ?>>
<span id="el_triwulan_akhir">
<span<?= $Page->akhir->viewAttributes() ?>>
<?= $Page->akhir->getViewValue() ?></span>
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
