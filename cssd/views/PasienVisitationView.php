<?php

namespace PHPMaker2021\SIMRSSQLSERVERCSSD;

// Page object
$PasienVisitationView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fPASIEN_VISITATIONview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fPASIEN_VISITATIONview = currentForm = new ew.Form("fPASIEN_VISITATIONview", "view");
    loadjs.done("fPASIEN_VISITATIONview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.PASIEN_VISITATION) ew.vars.tables.PASIEN_VISITATION = <?= JsonEncode(GetClientVar("tables", "PASIEN_VISITATION")) ?>;
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
<form name="fPASIEN_VISITATIONview" id="fPASIEN_VISITATIONview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="PASIEN_VISITATION">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-bordered table-hover ew-view-table">
<?php if ($Page->SEP->Visible) { // SEP ?>
    <tr id="r_SEP">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PASIEN_VISITATION_SEP"><?= $Page->SEP->caption() ?></span></td>
        <td data-name="SEP" <?= $Page->SEP->cellAttributes() ?>>
<span id="el_PASIEN_VISITATION_SEP">
<span<?= $Page->SEP->viewAttributes() ?>><script>

function Buka(link="") {
	window.open(link, 'newwindow', 'width=800,height=400');
	return false;
}
</script>
<?php
if (empty(CurrentPage()->no_sep->CurrentValue)){
?>
<a href="../simrs/bridging/rajalsep.php?key=<?php echo urlencode(CurrentPage()->no_kartu->CurrentValue).'&rujukan='.urlencode(CurrentPage()->no_rujuk->CurrentValue).'&eksekutif='.urlencode(CurrentPage()->eksekutif->CurrentValue).'&nosurat='.urlencode(CurrentPage()->no_surat_rujukan->CurrentValue).'&dpjp='.urlencode(CurrentPage()->kddokter->CurrentValue).'&id='.urlencode(CurrentPage()->idxdaftar->CurrentValue).'&catatan='.urlencode(CurrentPage()->catatan->CurrentValue)?>" class="btn btn-info btn-sm" role="button">BUAT SEP</a>
<?php } else {?>
<a href="#" onclick="Buka('../simrs/bridging/cetaksep.php?id=<?php echo urlencode(CurrentPage()->idxdaftar->CurrentValue) ;?>'); return false" class="btn btn-info btn-sm" role="button">CETAK SEP</a>
<?php } ?>
<div class="btn-group btn-group-sm ew-btn-group">
	<a class="btn bg-navy ew-row-link ew-detail" href="print.html"
	onclick="Buka('/simrs/reporting/nota_kwitansi_semua.php?id=<?php echo urlencode(CurrentPage()->VISIT_ID->CurrentValue)?>'); return false">NOTA</a>
	<button class="dropdown-toggle btn bg-navy ew-detail" data-toggle="dropdown" aria-expanded="false"></button>
	<ul class="dropdown-menu" style="">
		<li>
			<a class="dropdown-item ew-row-link ew-detail-edit" href="#"
			 onclick="Buka('/simrs/reporting/nota_rekap_total.php?id=<?php echo urlencode(CurrentPage()->VISIT_ID->CurrentValue)?>'); return false">Rekap Total</a>
		</li>
		<li>
			<a class="dropdown-item ew-row-link ew-detail-edit" href="#"
			 onclick="Buka('/simrs/reporting/nota_rincian_tindakan.php?id=<?php echo urlencode(CurrentPage()->VISIT_ID->CurrentValue)?>'); return false">Tindakan</a>
		</li>
		<li>
			<a class="dropdown-item ew-row-link ew-detail-edit" href="#"
			 onclick="Buka('/simrs/reporting/nota_pelayanan_kasir_ranap.php?id=<?php echo urlencode(CurrentPage()->VISIT_ID->CurrentValue)?>'); return false">CESMIX Ringkas</a>
		</li>
		<li class="divider" style="border-bottom:1px solid #ccc!important"></li>
		<li>
			<a class="dropdown-item ew-row-link ew-detail-edit" href="#"
			 onclick="Buka('/simrs/reporting/nota_rincian_inacbg.php?id=<?php echo urlencode(CurrentPage()->VISIT_ID->CurrentValue)?>'); return false">INACBG</a>
		</li>
		<li>
			<a class="dropdown-item ew-row-link ew-detail-edit" href="#"
			 onclick="Buka('/simrs/reporting/nota_rincian_inadrg.php?id=<?php echo urlencode(CurrentPage()->VISIT_ID->CurrentValue)?>'); return false">INADRG</a>
		</li>
	</ul>
</div>
<div class="btn-group btn-group-sm ew-btn-group">
	<a class="btn btn-primary ew-row-link ew-detail" href="print.html"
	onclick="Buka('/simrs/reporting/jasper.php?id=<?php echo urlencode(CurrentPage()->VISIT_ID->CurrentValue)?>'); return false">RESUME MEDIS</a>
	<button class="dropdown-toggle btn btn-primary ew-detail" data-toggle="dropdown" aria-expanded="false"></button>
	<ul class="dropdown-menu" style="">
		<li>
			<a class="dropdown-item ew-row-link ew-detail-edit" href="print.html"
			 onclick="Buka('/simrs/reporting/surat_keterangan_ranap.php?id=<?php echo urlencode(CurrentPage()->VISIT_ID->CurrentValue)?>'); return false">Surat Ket. Rawat Inap</a>
		</li>
		<li>
			<a class="dropdown-item ew-row-link ew-detail-edit" href="print.html"
			 onclick="Buka('/simrs/reporting/surat_keterangan_rajal.php?id=<?php echo urlencode(CurrentPage()->VISIT_ID->CurrentValue)?>'); return false">Surat Ket. Rawat Jalan</a>
		</li>
		<li>
			<a class="dropdown-item ew-row-link ew-detail-edit" href="print.html"
			 onclick="Buka('/simrs/reporting/surat_keterangan_pasien.php?id=<?php echo urlencode(CurrentPage()->VISIT_ID->CurrentValue)?>'); return false">Surat Ket. Pasien</a>
		</li>
		<li>
			<a class="dropdown-item ew-row-link ew-detail-edit" href="print.html"
			 onclick="Buka('/simrs/reporting/surat_keterangan_meninggal.php?id=<?php echo urlencode(CurrentPage()->VISIT_ID->CurrentValue)?>'); return false">Surat Ket. Meninggal</a>
		</li>
		<li class="divider" style="border-bottom:1px solid #ccc!important"></li>
		<li>
			<a class="dropdown-item ew-row-link ew-detail-edit" href="print.html"
			 onclick="Buka('/simrs/reporting/surat_kontrol.php?id=<?php echo urlencode(CurrentPage()->VISIT_ID->CurrentValue)?>'); return false">Surat Kontrol</a>
		</li>
	</ul>
</div>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->NO_REGISTRATION->Visible) { // NO_REGISTRATION ?>
    <tr id="r_NO_REGISTRATION">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PASIEN_VISITATION_NO_REGISTRATION"><?= $Page->NO_REGISTRATION->caption() ?></span></td>
        <td data-name="NO_REGISTRATION" <?= $Page->NO_REGISTRATION->cellAttributes() ?>>
<span id="el_PASIEN_VISITATION_NO_REGISTRATION">
<span<?= $Page->NO_REGISTRATION->viewAttributes() ?>>
<?= $Page->NO_REGISTRATION->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->STATUS_PASIEN_ID->Visible) { // STATUS_PASIEN_ID ?>
    <tr id="r_STATUS_PASIEN_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PASIEN_VISITATION_STATUS_PASIEN_ID"><?= $Page->STATUS_PASIEN_ID->caption() ?></span></td>
        <td data-name="STATUS_PASIEN_ID" <?= $Page->STATUS_PASIEN_ID->cellAttributes() ?>>
<span id="el_PASIEN_VISITATION_STATUS_PASIEN_ID">
<span<?= $Page->STATUS_PASIEN_ID->viewAttributes() ?>>
<?= $Page->STATUS_PASIEN_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->RUJUKAN_ID->Visible) { // RUJUKAN_ID ?>
    <tr id="r_RUJUKAN_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PASIEN_VISITATION_RUJUKAN_ID"><?= $Page->RUJUKAN_ID->caption() ?></span></td>
        <td data-name="RUJUKAN_ID" <?= $Page->RUJUKAN_ID->cellAttributes() ?>>
<span id="el_PASIEN_VISITATION_RUJUKAN_ID">
<span<?= $Page->RUJUKAN_ID->viewAttributes() ?>>
<?= $Page->RUJUKAN_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->REASON_ID->Visible) { // REASON_ID ?>
    <tr id="r_REASON_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PASIEN_VISITATION_REASON_ID"><?= $Page->REASON_ID->caption() ?></span></td>
        <td data-name="REASON_ID" <?= $Page->REASON_ID->cellAttributes() ?>>
<span id="el_PASIEN_VISITATION_REASON_ID">
<span<?= $Page->REASON_ID->viewAttributes() ?>>
<?= $Page->REASON_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->WAY_ID->Visible) { // WAY_ID ?>
    <tr id="r_WAY_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PASIEN_VISITATION_WAY_ID"><?= $Page->WAY_ID->caption() ?></span></td>
        <td data-name="WAY_ID" <?= $Page->WAY_ID->cellAttributes() ?>>
<span id="el_PASIEN_VISITATION_WAY_ID">
<span<?= $Page->WAY_ID->viewAttributes() ?>>
<?= $Page->WAY_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->BOOKED_DATE->Visible) { // BOOKED_DATE ?>
    <tr id="r_BOOKED_DATE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PASIEN_VISITATION_BOOKED_DATE"><?= $Page->BOOKED_DATE->caption() ?></span></td>
        <td data-name="BOOKED_DATE" <?= $Page->BOOKED_DATE->cellAttributes() ?>>
<span id="el_PASIEN_VISITATION_BOOKED_DATE">
<span<?= $Page->BOOKED_DATE->viewAttributes() ?>>
<?= $Page->BOOKED_DATE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->VISIT_DATE->Visible) { // VISIT_DATE ?>
    <tr id="r_VISIT_DATE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PASIEN_VISITATION_VISIT_DATE"><?= $Page->VISIT_DATE->caption() ?></span></td>
        <td data-name="VISIT_DATE" <?= $Page->VISIT_DATE->cellAttributes() ?>>
<span id="el_PASIEN_VISITATION_VISIT_DATE">
<span<?= $Page->VISIT_DATE->viewAttributes() ?>>
<?= $Page->VISIT_DATE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->CLINIC_ID->Visible) { // CLINIC_ID ?>
    <tr id="r_CLINIC_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PASIEN_VISITATION_CLINIC_ID"><?= $Page->CLINIC_ID->caption() ?></span></td>
        <td data-name="CLINIC_ID" <?= $Page->CLINIC_ID->cellAttributes() ?>>
<span id="el_PASIEN_VISITATION_CLINIC_ID">
<span<?= $Page->CLINIC_ID->viewAttributes() ?>>
<?= $Page->CLINIC_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->GENDER->Visible) { // GENDER ?>
    <tr id="r_GENDER">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PASIEN_VISITATION_GENDER"><?= $Page->GENDER->caption() ?></span></td>
        <td data-name="GENDER" <?= $Page->GENDER->cellAttributes() ?>>
<span id="el_PASIEN_VISITATION_GENDER">
<span<?= $Page->GENDER->viewAttributes() ?>>
<?= $Page->GENDER->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->EMPLOYEE_ID->Visible) { // EMPLOYEE_ID ?>
    <tr id="r_EMPLOYEE_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PASIEN_VISITATION_EMPLOYEE_ID"><?= $Page->EMPLOYEE_ID->caption() ?></span></td>
        <td data-name="EMPLOYEE_ID" <?= $Page->EMPLOYEE_ID->cellAttributes() ?>>
<span id="el_PASIEN_VISITATION_EMPLOYEE_ID">
<span<?= $Page->EMPLOYEE_ID->viewAttributes() ?>>
<?= $Page->EMPLOYEE_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->PAYOR_ID->Visible) { // PAYOR_ID ?>
    <tr id="r_PAYOR_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PASIEN_VISITATION_PAYOR_ID"><?= $Page->PAYOR_ID->caption() ?></span></td>
        <td data-name="PAYOR_ID" <?= $Page->PAYOR_ID->cellAttributes() ?>>
<span id="el_PASIEN_VISITATION_PAYOR_ID">
<span<?= $Page->PAYOR_ID->viewAttributes() ?>>
<?= $Page->PAYOR_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->CLASS_ID->Visible) { // CLASS_ID ?>
    <tr id="r_CLASS_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PASIEN_VISITATION_CLASS_ID"><?= $Page->CLASS_ID->caption() ?></span></td>
        <td data-name="CLASS_ID" <?= $Page->CLASS_ID->cellAttributes() ?>>
<span id="el_PASIEN_VISITATION_CLASS_ID">
<span<?= $Page->CLASS_ID->viewAttributes() ?>>
<?= $Page->CLASS_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->COVERAGE_ID->Visible) { // COVERAGE_ID ?>
    <tr id="r_COVERAGE_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PASIEN_VISITATION_COVERAGE_ID"><?= $Page->COVERAGE_ID->caption() ?></span></td>
        <td data-name="COVERAGE_ID" <?= $Page->COVERAGE_ID->cellAttributes() ?>>
<span id="el_PASIEN_VISITATION_COVERAGE_ID">
<span<?= $Page->COVERAGE_ID->viewAttributes() ?>>
<?= $Page->COVERAGE_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->NO_SKP->Visible) { // NO_SKP ?>
    <tr id="r_NO_SKP">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PASIEN_VISITATION_NO_SKP"><?= $Page->NO_SKP->caption() ?></span></td>
        <td data-name="NO_SKP" <?= $Page->NO_SKP->cellAttributes() ?>>
<span id="el_PASIEN_VISITATION_NO_SKP">
<span<?= $Page->NO_SKP->viewAttributes() ?>>
<?= $Page->NO_SKP->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->NO_SKPINAP->Visible) { // NO_SKPINAP ?>
    <tr id="r_NO_SKPINAP">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PASIEN_VISITATION_NO_SKPINAP"><?= $Page->NO_SKPINAP->caption() ?></span></td>
        <td data-name="NO_SKPINAP" <?= $Page->NO_SKPINAP->cellAttributes() ?>>
<span id="el_PASIEN_VISITATION_NO_SKPINAP">
<span<?= $Page->NO_SKPINAP->viewAttributes() ?>>
<?= $Page->NO_SKPINAP->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->DIAGNOSA_ID->Visible) { // DIAGNOSA_ID ?>
    <tr id="r_DIAGNOSA_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PASIEN_VISITATION_DIAGNOSA_ID"><?= $Page->DIAGNOSA_ID->caption() ?></span></td>
        <td data-name="DIAGNOSA_ID" <?= $Page->DIAGNOSA_ID->cellAttributes() ?>>
<span id="el_PASIEN_VISITATION_DIAGNOSA_ID">
<span<?= $Page->DIAGNOSA_ID->viewAttributes() ?>>
<?= $Page->DIAGNOSA_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->NORUJUKAN->Visible) { // NORUJUKAN ?>
    <tr id="r_NORUJUKAN">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PASIEN_VISITATION_NORUJUKAN"><?= $Page->NORUJUKAN->caption() ?></span></td>
        <td data-name="NORUJUKAN" <?= $Page->NORUJUKAN->cellAttributes() ?>>
<span id="el_PASIEN_VISITATION_NORUJUKAN">
<span<?= $Page->NORUJUKAN->viewAttributes() ?>>
<?= $Page->NORUJUKAN->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->PPKRUJUKAN->Visible) { // PPKRUJUKAN ?>
    <tr id="r_PPKRUJUKAN">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PASIEN_VISITATION_PPKRUJUKAN"><?= $Page->PPKRUJUKAN->caption() ?></span></td>
        <td data-name="PPKRUJUKAN" <?= $Page->PPKRUJUKAN->cellAttributes() ?>>
<span id="el_PASIEN_VISITATION_PPKRUJUKAN">
<span<?= $Page->PPKRUJUKAN->viewAttributes() ?>>
<?= $Page->PPKRUJUKAN->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->EDIT_SEP->Visible) { // EDIT_SEP ?>
    <tr id="r_EDIT_SEP">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PASIEN_VISITATION_EDIT_SEP"><?= $Page->EDIT_SEP->caption() ?></span></td>
        <td data-name="EDIT_SEP" <?= $Page->EDIT_SEP->cellAttributes() ?>>
<span id="el_PASIEN_VISITATION_EDIT_SEP">
<span<?= $Page->EDIT_SEP->viewAttributes() ?>>
<?= $Page->EDIT_SEP->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->DIAG_AWAL->Visible) { // DIAG_AWAL ?>
    <tr id="r_DIAG_AWAL">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PASIEN_VISITATION_DIAG_AWAL"><?= $Page->DIAG_AWAL->caption() ?></span></td>
        <td data-name="DIAG_AWAL" <?= $Page->DIAG_AWAL->cellAttributes() ?>>
<span id="el_PASIEN_VISITATION_DIAG_AWAL">
<span<?= $Page->DIAG_AWAL->viewAttributes() ?>>
<?= $Page->DIAG_AWAL->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->COB->Visible) { // COB ?>
    <tr id="r_COB">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PASIEN_VISITATION_COB"><?= $Page->COB->caption() ?></span></td>
        <td data-name="COB" <?= $Page->COB->cellAttributes() ?>>
<span id="el_PASIEN_VISITATION_COB">
<span<?= $Page->COB->viewAttributes() ?>>
<?= $Page->COB->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ASALRUJUKAN->Visible) { // ASALRUJUKAN ?>
    <tr id="r_ASALRUJUKAN">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PASIEN_VISITATION_ASALRUJUKAN"><?= $Page->ASALRUJUKAN->caption() ?></span></td>
        <td data-name="ASALRUJUKAN" <?= $Page->ASALRUJUKAN->cellAttributes() ?>>
<span id="el_PASIEN_VISITATION_ASALRUJUKAN">
<span<?= $Page->ASALRUJUKAN->viewAttributes() ?>>
<?= $Page->ASALRUJUKAN->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<?php
    $Page->DetailPages->ValidKeys = explode(",", $Page->getCurrentDetailTable());
    $firstActiveDetailTable = $Page->DetailPages->activePageIndex();
?>
<div class="ew-detail-pages"><!-- detail-pages -->
<div class="ew-nav-tabs" id="Page_details"><!-- tabs -->
    <ul class="<?= $Page->DetailPages->navStyle() ?>"><!-- .nav -->
<?php
    if (in_array("TREATMENT_OBAT", explode(",", $Page->getCurrentDetailTable())) && $TREATMENT_OBAT->DetailView) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "TREATMENT_OBAT") {
            $firstActiveDetailTable = "TREATMENT_OBAT";
        }
?>
        <li class="nav-item"><a class="nav-link <?= $Page->DetailPages->pageStyle("TREATMENT_OBAT") ?>" href="#tab_TREATMENT_OBAT" data-toggle="tab"><?= $Language->tablePhrase("TREATMENT_OBAT", "TblCaption") ?></a></li>
<?php
    }
?>
<?php
    if (in_array("TREATMENT_AKOMODASI", explode(",", $Page->getCurrentDetailTable())) && $TREATMENT_AKOMODASI->DetailView) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "TREATMENT_AKOMODASI") {
            $firstActiveDetailTable = "TREATMENT_AKOMODASI";
        }
?>
        <li class="nav-item"><a class="nav-link <?= $Page->DetailPages->pageStyle("TREATMENT_AKOMODASI") ?>" href="#tab_TREATMENT_AKOMODASI" data-toggle="tab"><?= $Language->tablePhrase("TREATMENT_AKOMODASI", "TblCaption") ?></a></li>
<?php
    }
?>
    </ul><!-- /.nav -->
    <div class="tab-content"><!-- .tab-content -->
<?php
    if (in_array("TREATMENT_OBAT", explode(",", $Page->getCurrentDetailTable())) && $TREATMENT_OBAT->DetailView) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "TREATMENT_OBAT") {
            $firstActiveDetailTable = "TREATMENT_OBAT";
        }
?>
        <div class="tab-pane <?= $Page->DetailPages->pageStyle("TREATMENT_OBAT") ?>" id="tab_TREATMENT_OBAT"><!-- page* -->
<?php include_once "TreatmentObatGrid.php" ?>
        </div><!-- /page* -->
<?php } ?>
<?php
    if (in_array("TREATMENT_AKOMODASI", explode(",", $Page->getCurrentDetailTable())) && $TREATMENT_AKOMODASI->DetailView) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "TREATMENT_AKOMODASI") {
            $firstActiveDetailTable = "TREATMENT_AKOMODASI";
        }
?>
        <div class="tab-pane <?= $Page->DetailPages->pageStyle("TREATMENT_AKOMODASI") ?>" id="tab_TREATMENT_AKOMODASI"><!-- page* -->
<?php include_once "TreatmentAkomodasiGrid.php" ?>
        </div><!-- /page* -->
<?php } ?>
    </div><!-- /.tab-content -->
</div><!-- /tabs -->
</div><!-- /detail-pages -->
<?php } ?>
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
