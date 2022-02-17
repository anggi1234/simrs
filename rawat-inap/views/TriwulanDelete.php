<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

// Page object
$TriwulanDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var ftriwulandelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    ftriwulandelete = currentForm = new ew.Form("ftriwulandelete", "delete");
    loadjs.done("ftriwulandelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.triwulan) ew.vars.tables.triwulan = <?= JsonEncode(GetClientVar("tables", "triwulan")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="ftriwulandelete" id="ftriwulandelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="triwulan">
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
<?php if ($Page->triwulan->Visible) { // triwulan ?>
        <th class="<?= $Page->triwulan->headerCellClass() ?>"><span id="elh_triwulan_triwulan" class="triwulan_triwulan"><?= $Page->triwulan->caption() ?></span></th>
<?php } ?>
<?php if ($Page->keterangan->Visible) { // keterangan ?>
        <th class="<?= $Page->keterangan->headerCellClass() ?>"><span id="elh_triwulan_keterangan" class="triwulan_keterangan"><?= $Page->keterangan->caption() ?></span></th>
<?php } ?>
<?php if ($Page->mulai->Visible) { // mulai ?>
        <th class="<?= $Page->mulai->headerCellClass() ?>"><span id="elh_triwulan_mulai" class="triwulan_mulai"><?= $Page->mulai->caption() ?></span></th>
<?php } ?>
<?php if ($Page->akhir->Visible) { // akhir ?>
        <th class="<?= $Page->akhir->headerCellClass() ?>"><span id="elh_triwulan_akhir" class="triwulan_akhir"><?= $Page->akhir->caption() ?></span></th>
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
<?php if ($Page->triwulan->Visible) { // triwulan ?>
        <td <?= $Page->triwulan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_triwulan_triwulan" class="triwulan_triwulan">
<span<?= $Page->triwulan->viewAttributes() ?>>
<?= $Page->triwulan->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->keterangan->Visible) { // keterangan ?>
        <td <?= $Page->keterangan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_triwulan_keterangan" class="triwulan_keterangan">
<span<?= $Page->keterangan->viewAttributes() ?>>
<?= $Page->keterangan->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->mulai->Visible) { // mulai ?>
        <td <?= $Page->mulai->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_triwulan_mulai" class="triwulan_mulai">
<span<?= $Page->mulai->viewAttributes() ?>>
<?= $Page->mulai->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->akhir->Visible) { // akhir ?>
        <td <?= $Page->akhir->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_triwulan_akhir" class="triwulan_akhir">
<span<?= $Page->akhir->viewAttributes() ?>>
<?= $Page->akhir->getViewValue() ?></span>
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
