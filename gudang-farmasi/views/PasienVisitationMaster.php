<?php

namespace PHPMaker2021\SIMRSSQLSERVERGUDANGFARMASI;

// Table
$PASIEN_VISITATION = Container("PASIEN_VISITATION");
?>
<?php if ($PASIEN_VISITATION->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_PASIEN_VISITATIONmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($PASIEN_VISITATION->NO_REGISTRATION->Visible) { // NO_REGISTRATION ?>
        <tr id="r_NO_REGISTRATION">
            <td class="<?= $PASIEN_VISITATION->TableLeftColumnClass ?>"><?= $PASIEN_VISITATION->NO_REGISTRATION->caption() ?></td>
            <td <?= $PASIEN_VISITATION->NO_REGISTRATION->cellAttributes() ?>>
<span id="el_PASIEN_VISITATION_NO_REGISTRATION">
<span<?= $PASIEN_VISITATION->NO_REGISTRATION->viewAttributes() ?>>
<?= $PASIEN_VISITATION->NO_REGISTRATION->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($PASIEN_VISITATION->DIANTAR_OLEH->Visible) { // DIANTAR_OLEH ?>
        <tr id="r_DIANTAR_OLEH">
            <td class="<?= $PASIEN_VISITATION->TableLeftColumnClass ?>"><?= $PASIEN_VISITATION->DIANTAR_OLEH->caption() ?></td>
            <td <?= $PASIEN_VISITATION->DIANTAR_OLEH->cellAttributes() ?>>
<span id="el_PASIEN_VISITATION_DIANTAR_OLEH">
<span<?= $PASIEN_VISITATION->DIANTAR_OLEH->viewAttributes() ?>>
<?= $PASIEN_VISITATION->DIANTAR_OLEH->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($PASIEN_VISITATION->GENDER->Visible) { // GENDER ?>
        <tr id="r_GENDER">
            <td class="<?= $PASIEN_VISITATION->TableLeftColumnClass ?>"><?= $PASIEN_VISITATION->GENDER->caption() ?></td>
            <td <?= $PASIEN_VISITATION->GENDER->cellAttributes() ?>>
<span id="el_PASIEN_VISITATION_GENDER">
<span<?= $PASIEN_VISITATION->GENDER->viewAttributes() ?>>
<?= $PASIEN_VISITATION->GENDER->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($PASIEN_VISITATION->VISITOR_ADDRESS->Visible) { // VISITOR_ADDRESS ?>
        <tr id="r_VISITOR_ADDRESS">
            <td class="<?= $PASIEN_VISITATION->TableLeftColumnClass ?>"><?= $PASIEN_VISITATION->VISITOR_ADDRESS->caption() ?></td>
            <td <?= $PASIEN_VISITATION->VISITOR_ADDRESS->cellAttributes() ?>>
<span id="el_PASIEN_VISITATION_VISITOR_ADDRESS">
<span<?= $PASIEN_VISITATION->VISITOR_ADDRESS->viewAttributes() ?>>
<?= $PASIEN_VISITATION->VISITOR_ADDRESS->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($PASIEN_VISITATION->VISIT_DATE->Visible) { // VISIT_DATE ?>
        <tr id="r_VISIT_DATE">
            <td class="<?= $PASIEN_VISITATION->TableLeftColumnClass ?>"><?= $PASIEN_VISITATION->VISIT_DATE->caption() ?></td>
            <td <?= $PASIEN_VISITATION->VISIT_DATE->cellAttributes() ?>>
<span id="el_PASIEN_VISITATION_VISIT_DATE">
<span<?= $PASIEN_VISITATION->VISIT_DATE->viewAttributes() ?>>
<?= $PASIEN_VISITATION->VISIT_DATE->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($PASIEN_VISITATION->CLINIC_ID->Visible) { // CLINIC_ID ?>
        <tr id="r_CLINIC_ID">
            <td class="<?= $PASIEN_VISITATION->TableLeftColumnClass ?>"><?= $PASIEN_VISITATION->CLINIC_ID->caption() ?></td>
            <td <?= $PASIEN_VISITATION->CLINIC_ID->cellAttributes() ?>>
<span id="el_PASIEN_VISITATION_CLINIC_ID">
<span<?= $PASIEN_VISITATION->CLINIC_ID->viewAttributes() ?>>
<?= $PASIEN_VISITATION->CLINIC_ID->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($PASIEN_VISITATION->EMPLOYEE_ID->Visible) { // EMPLOYEE_ID ?>
        <tr id="r_EMPLOYEE_ID">
            <td class="<?= $PASIEN_VISITATION->TableLeftColumnClass ?>"><?= $PASIEN_VISITATION->EMPLOYEE_ID->caption() ?></td>
            <td <?= $PASIEN_VISITATION->EMPLOYEE_ID->cellAttributes() ?>>
<span id="el_PASIEN_VISITATION_EMPLOYEE_ID">
<span<?= $PASIEN_VISITATION->EMPLOYEE_ID->viewAttributes() ?>>
<?= $PASIEN_VISITATION->EMPLOYEE_ID->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($PASIEN_VISITATION->PAYOR_ID->Visible) { // PAYOR_ID ?>
        <tr id="r_PAYOR_ID">
            <td class="<?= $PASIEN_VISITATION->TableLeftColumnClass ?>"><?= $PASIEN_VISITATION->PAYOR_ID->caption() ?></td>
            <td <?= $PASIEN_VISITATION->PAYOR_ID->cellAttributes() ?>>
<span id="el_PASIEN_VISITATION_PAYOR_ID">
<span<?= $PASIEN_VISITATION->PAYOR_ID->viewAttributes() ?>>
<?= $PASIEN_VISITATION->PAYOR_ID->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($PASIEN_VISITATION->CLASS_ID->Visible) { // CLASS_ID ?>
        <tr id="r_CLASS_ID">
            <td class="<?= $PASIEN_VISITATION->TableLeftColumnClass ?>"><?= $PASIEN_VISITATION->CLASS_ID->caption() ?></td>
            <td <?= $PASIEN_VISITATION->CLASS_ID->cellAttributes() ?>>
<span id="el_PASIEN_VISITATION_CLASS_ID">
<span<?= $PASIEN_VISITATION->CLASS_ID->viewAttributes() ?>>
<?= $PASIEN_VISITATION->CLASS_ID->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($PASIEN_VISITATION->PASIEN_ID->Visible) { // PASIEN_ID ?>
        <tr id="r_PASIEN_ID">
            <td class="<?= $PASIEN_VISITATION->TableLeftColumnClass ?>"><?= $PASIEN_VISITATION->PASIEN_ID->caption() ?></td>
            <td <?= $PASIEN_VISITATION->PASIEN_ID->cellAttributes() ?>>
<span id="el_PASIEN_VISITATION_PASIEN_ID">
<span<?= $PASIEN_VISITATION->PASIEN_ID->viewAttributes() ?>>
<?= $PASIEN_VISITATION->PASIEN_ID->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($PASIEN_VISITATION->AGEYEAR->Visible) { // AGEYEAR ?>
        <tr id="r_AGEYEAR">
            <td class="<?= $PASIEN_VISITATION->TableLeftColumnClass ?>"><?= $PASIEN_VISITATION->AGEYEAR->caption() ?></td>
            <td <?= $PASIEN_VISITATION->AGEYEAR->cellAttributes() ?>>
<span id="el_PASIEN_VISITATION_AGEYEAR">
<span<?= $PASIEN_VISITATION->AGEYEAR->viewAttributes() ?>>
<?= $PASIEN_VISITATION->AGEYEAR->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($PASIEN_VISITATION->IDXDAFTAR->Visible) { // IDXDAFTAR ?>
        <tr id="r_IDXDAFTAR">
            <td class="<?= $PASIEN_VISITATION->TableLeftColumnClass ?>"><?= $PASIEN_VISITATION->IDXDAFTAR->caption() ?></td>
            <td <?= $PASIEN_VISITATION->IDXDAFTAR->cellAttributes() ?>>
<span id="el_PASIEN_VISITATION_IDXDAFTAR">
<span<?= $PASIEN_VISITATION->IDXDAFTAR->viewAttributes() ?>><script>

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
<?php if ($PASIEN_VISITATION->tgl_kontrol->Visible) { // tgl_kontrol ?>
        <tr id="r_tgl_kontrol">
            <td class="<?= $PASIEN_VISITATION->TableLeftColumnClass ?>"><?= $PASIEN_VISITATION->tgl_kontrol->caption() ?></td>
            <td <?= $PASIEN_VISITATION->tgl_kontrol->cellAttributes() ?>>
<span id="el_PASIEN_VISITATION_tgl_kontrol">
<span<?= $PASIEN_VISITATION->tgl_kontrol->viewAttributes() ?>>
<?= $PASIEN_VISITATION->tgl_kontrol->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
