<?php

namespace PHPMaker2021\Online;

// Page object
$VDaftarantriView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fV_daftarantriview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fV_daftarantriview = currentForm = new ew.Form("fV_daftarantriview", "view");
    loadjs.done("fV_daftarantriview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.V_daftarantri) ew.vars.tables.V_daftarantri = <?= JsonEncode(GetClientVar("tables", "V_daftarantri")) ?>;
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
<form name="fV_daftarantriview" id="fV_daftarantriview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="V_daftarantri">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-bordered table-hover ew-view-table">
<?php if ($Page->no_urut->Visible) { // no_urut ?>
    <tr id="r_no_urut">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_V_daftarantri_no_urut"><?= $Page->no_urut->caption() ?></span></td>
        <td data-name="no_urut" <?= $Page->no_urut->cellAttributes() ?>>
<span id="el_V_daftarantri_no_urut">
<span<?= $Page->no_urut->viewAttributes() ?>>
<?= $Page->no_urut->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tanggal_daftar->Visible) { // tanggal_daftar ?>
    <tr id="r_tanggal_daftar">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_V_daftarantri_tanggal_daftar"><?= $Page->tanggal_daftar->caption() ?></span></td>
        <td data-name="tanggal_daftar" <?= $Page->tanggal_daftar->cellAttributes() ?>>
<span id="el_V_daftarantri_tanggal_daftar">
<span<?= $Page->tanggal_daftar->viewAttributes() ?>>
<?= $Page->tanggal_daftar->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->kdpoli->Visible) { // kdpoli ?>
    <tr id="r_kdpoli">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_V_daftarantri_kdpoli"><?= $Page->kdpoli->caption() ?></span></td>
        <td data-name="kdpoli" <?= $Page->kdpoli->cellAttributes() ?>>
<span id="el_V_daftarantri_kdpoli">
<span<?= $Page->kdpoli->viewAttributes() ?>>
<?= $Page->kdpoli->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tujuan->Visible) { // tujuan ?>
    <tr id="r_tujuan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_V_daftarantri_tujuan"><?= $Page->tujuan->caption() ?></span></td>
        <td data-name="tujuan" <?= $Page->tujuan->cellAttributes() ?>>
<span id="el_V_daftarantri_tujuan">
<span<?= $Page->tujuan->viewAttributes() ?>>
<?= $Page->tujuan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cetak->Visible) { // cetak ?>
    <tr id="r_cetak">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_V_daftarantri_cetak"><?= $Page->cetak->caption() ?></span></td>
        <td data-name="cetak" <?= $Page->cetak->cellAttributes() ?>>
<span id="el_V_daftarantri_cetak">
<span<?= $Page->cetak->viewAttributes() ?>><script>

function Buka(link="") {
	window.open(link, 'newwindow', 'width=800,height=400');
	return false;
}
</script>
<a href="cetak/jasper.php?id=<?php echo urlencode(CurrentPage()->Id->CurrentValue).'&r=ANTRIAN_PENDAFTARAN&no='.urlencode(CurrentPage()->no_urut->CurrentValue).'&tgl='.urlencode(CurrentPage()->tanggal_daftar->CurrentValue)?>" class="btn btn-info" role="button">Antrian</a>
</span>
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
