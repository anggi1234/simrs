<?php

namespace PHPMaker2021\ONLINEBARU;

// Page object
$VPendaftaranDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fv_pendaftarandelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fv_pendaftarandelete = currentForm = new ew.Form("fv_pendaftarandelete", "delete");
    loadjs.done("fv_pendaftarandelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.v_pendaftaran) ew.vars.tables.v_pendaftaran = <?= JsonEncode(GetClientVar("tables", "v_pendaftaran")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fv_pendaftarandelete" id="fv_pendaftarandelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="v_pendaftaran">
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
        <th class="<?= $Page->no_urut->headerCellClass() ?>"><span id="elh_v_pendaftaran_no_urut" class="v_pendaftaran_no_urut"><?= $Page->no_urut->caption() ?></span></th>
<?php } ?>
<?php if ($Page->NAMA->Visible) { // NAMA ?>
        <th class="<?= $Page->NAMA->headerCellClass() ?>"><span id="elh_v_pendaftaran_NAMA" class="v_pendaftaran_NAMA"><?= $Page->NAMA->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tanggal_daftar->Visible) { // tanggal_daftar ?>
        <th class="<?= $Page->tanggal_daftar->headerCellClass() ?>"><span id="elh_v_pendaftaran_tanggal_daftar" class="v_pendaftaran_tanggal_daftar"><?= $Page->tanggal_daftar->caption() ?></span></th>
<?php } ?>
<?php if ($Page->kdpoli->Visible) { // kdpoli ?>
        <th class="<?= $Page->kdpoli->headerCellClass() ?>"><span id="elh_v_pendaftaran_kdpoli" class="v_pendaftaran_kdpoli"><?= $Page->kdpoli->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tujuan->Visible) { // tujuan ?>
        <th class="<?= $Page->tujuan->headerCellClass() ?>"><span id="elh_v_pendaftaran_tujuan" class="v_pendaftaran_tujuan"><?= $Page->tujuan->caption() ?></span></th>
<?php } ?>
<?php if ($Page->disabilitas->Visible) { // disabilitas ?>
        <th class="<?= $Page->disabilitas->headerCellClass() ?>"><span id="elh_v_pendaftaran_disabilitas" class="v_pendaftaran_disabilitas"><?= $Page->disabilitas->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_v_pendaftaran_no_urut" class="v_pendaftaran_no_urut">
<span<?= $Page->no_urut->viewAttributes() ?>>
<?= $Page->no_urut->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->NAMA->Visible) { // NAMA ?>
        <td <?= $Page->NAMA->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_v_pendaftaran_NAMA" class="v_pendaftaran_NAMA">
<span<?= $Page->NAMA->viewAttributes() ?>>
<?= $Page->NAMA->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tanggal_daftar->Visible) { // tanggal_daftar ?>
        <td <?= $Page->tanggal_daftar->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_v_pendaftaran_tanggal_daftar" class="v_pendaftaran_tanggal_daftar">
<span<?= $Page->tanggal_daftar->viewAttributes() ?>>
<?= $Page->tanggal_daftar->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->kdpoli->Visible) { // kdpoli ?>
        <td <?= $Page->kdpoli->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_v_pendaftaran_kdpoli" class="v_pendaftaran_kdpoli">
<span<?= $Page->kdpoli->viewAttributes() ?>>
<?= $Page->kdpoli->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tujuan->Visible) { // tujuan ?>
        <td <?= $Page->tujuan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_v_pendaftaran_tujuan" class="v_pendaftaran_tujuan">
<span<?= $Page->tujuan->viewAttributes() ?>>
<?= $Page->tujuan->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->disabilitas->Visible) { // disabilitas ?>
        <td <?= $Page->disabilitas->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_v_pendaftaran_disabilitas" class="v_pendaftaran_disabilitas">
<span<?= $Page->disabilitas->viewAttributes() ?>>
<?= $Page->disabilitas->getViewValue() ?></span>
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
