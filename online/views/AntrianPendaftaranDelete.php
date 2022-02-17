<?php

namespace PHPMaker2021\ONLINEBARU;

// Page object
$AntrianPendaftaranDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fANTRIAN_PENDAFTARANdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fANTRIAN_PENDAFTARANdelete = currentForm = new ew.Form("fANTRIAN_PENDAFTARANdelete", "delete");
    loadjs.done("fANTRIAN_PENDAFTARANdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.ANTRIAN_PENDAFTARAN) ew.vars.tables.ANTRIAN_PENDAFTARAN = <?= JsonEncode(GetClientVar("tables", "ANTRIAN_PENDAFTARAN")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fANTRIAN_PENDAFTARANdelete" id="fANTRIAN_PENDAFTARANdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="ANTRIAN_PENDAFTARAN">
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
<?php if ($Page->no_urut->Visible) { // no_urut ?>
        <th class="<?= $Page->no_urut->headerCellClass() ?>"><span id="elh_ANTRIAN_PENDAFTARAN_no_urut" class="ANTRIAN_PENDAFTARAN_no_urut"><?= $Page->no_urut->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tanggal_daftar->Visible) { // tanggal_daftar ?>
        <th class="<?= $Page->tanggal_daftar->headerCellClass() ?>"><span id="elh_ANTRIAN_PENDAFTARAN_tanggal_daftar" class="ANTRIAN_PENDAFTARAN_tanggal_daftar"><?= $Page->tanggal_daftar->caption() ?></span></th>
<?php } ?>
<?php if ($Page->kdpoli->Visible) { // kdpoli ?>
        <th class="<?= $Page->kdpoli->headerCellClass() ?>"><span id="elh_ANTRIAN_PENDAFTARAN_kdpoli" class="ANTRIAN_PENDAFTARAN_kdpoli"><?= $Page->kdpoli->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tujuan->Visible) { // tujuan ?>
        <th class="<?= $Page->tujuan->headerCellClass() ?>"><span id="elh_ANTRIAN_PENDAFTARAN_tujuan" class="ANTRIAN_PENDAFTARAN_tujuan"><?= $Page->tujuan->caption() ?></span></th>
<?php } ?>
<?php if ($Page->cetak->Visible) { // cetak ?>
        <th class="<?= $Page->cetak->headerCellClass() ?>"><span id="elh_ANTRIAN_PENDAFTARAN_cetak" class="ANTRIAN_PENDAFTARAN_cetak"><?= $Page->cetak->caption() ?></span></th>
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
<?php if ($Page->no_urut->Visible) { // no_urut ?>
        <td <?= $Page->no_urut->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_ANTRIAN_PENDAFTARAN_no_urut" class="ANTRIAN_PENDAFTARAN_no_urut">
<span<?= $Page->no_urut->viewAttributes() ?>>
<?= $Page->no_urut->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tanggal_daftar->Visible) { // tanggal_daftar ?>
        <td <?= $Page->tanggal_daftar->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_ANTRIAN_PENDAFTARAN_tanggal_daftar" class="ANTRIAN_PENDAFTARAN_tanggal_daftar">
<span<?= $Page->tanggal_daftar->viewAttributes() ?>>
<?= $Page->tanggal_daftar->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->kdpoli->Visible) { // kdpoli ?>
        <td <?= $Page->kdpoli->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_ANTRIAN_PENDAFTARAN_kdpoli" class="ANTRIAN_PENDAFTARAN_kdpoli">
<span<?= $Page->kdpoli->viewAttributes() ?>>
<?= $Page->kdpoli->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tujuan->Visible) { // tujuan ?>
        <td <?= $Page->tujuan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_ANTRIAN_PENDAFTARAN_tujuan" class="ANTRIAN_PENDAFTARAN_tujuan">
<span<?= $Page->tujuan->viewAttributes() ?>>
<?= $Page->tujuan->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->cetak->Visible) { // cetak ?>
        <td <?= $Page->cetak->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_ANTRIAN_PENDAFTARAN_cetak" class="ANTRIAN_PENDAFTARAN_cetak">
<span<?= $Page->cetak->viewAttributes() ?>><script>

function Buka(link="") {
	window.open(link, 'newwindow', 'width=800,height=400');
	return false;
}
</script>
<a href="/online/cetak/jasper.php?id=<?php echo urlencode(CurrentPage()->Id->CurrentValue).'&no='.urlencode(CurrentPage()->no_urut->CurrentValue).'&tgl='.urlencode(CurrentPage()->tanggal_daftar->CurrentValue)?>" class="btn btn-info" role="button">Antrian</a>
</span>
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
