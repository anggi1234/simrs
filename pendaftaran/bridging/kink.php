<script>
	function Buka(link = "") {
		window.open(link, 'newwindow', 'width=800,height=400');
		return false;
	}
</script>
<?php
if (empty(CurrentPage()->no_sep->CurrentValue)) {
?>
	<a href="../simrs/bridging/rajalsep.php?key=<?php echo urlencode(CurrentPage()->no_kartu->CurrentValue) . '&rujukan=' . urlencode(CurrentPage()->no_rujuk->CurrentValue) . '&eksekutif=' . urlencode(CurrentPage()->eksekutif->CurrentValue) . '&nosurat=' . urlencode(CurrentPage()->no_surat_rujukan->CurrentValue) . '&dpjp=' . urlencode(CurrentPage()->kddokter->CurrentValue) . '&id=' . urlencode(CurrentPage()->idxdaftar->CurrentValue) . '&catatan=' . urlencode(CurrentPage()->catatan->CurrentValue) ?>" class="btn btn-info btn-sm" role="button">BUAT SEP</a>
<?php } else { ?>
	<a href="#" onclick="Buka('../simrs/bridging/cetaksep.php?id=<?php echo urlencode(CurrentPage()->idxdaftar->CurrentValue); ?>'); return false" class="btn btn-info btn-sm" role="button">CETAK SEP</a>
<?php } ?>

<div class="btn-group btn-group-sm ew-btn-group">
	<a class="btn bg-navy ew-row-link ew-detail" href="print.html" onclick="Buka('/simrs/reporting/nota_kwitansi_semua.php?id=<?php echo urlencode(CurrentPage()->VISIT_ID->CurrentValue) ?>'); return false">NOTA</a>

	<button class="dropdown-toggle btn bg-navy ew-detail" data-toggle="dropdown" aria-expanded="false"></button>
	<ul class="dropdown-menu" style="">
		<li>
			<a class="dropdown-item ew-row-link ew-detail-edit" href="#" onclick="Buka('/simrs/reporting/nota_rekap_total.php?id=<?php echo urlencode(CurrentPage()->VISIT_ID->CurrentValue) ?>'); return false">Rekap Total</a>
		</li>
		<li>
			<a class="dropdown-item ew-row-link ew-detail-edit" href="#" onclick="Buka('/simrs/reporting/nota_rincian_tindakan.php?id=<?php echo urlencode(CurrentPage()->VISIT_ID->CurrentValue) ?>'); return false">Tindakan</a>
		</li>
		<li>
			<a class="dropdown-item ew-row-link ew-detail-edit" href="#" onclick="Buka('/simrs/reporting/nota_pelayanan_kasir_ranap.php?id=<?php echo urlencode(CurrentPage()->VISIT_ID->CurrentValue) ?>'); return false">CESMIX Ringkas</a>
		</li>
		<li class="divider" style="border-bottom:1px solid #ccc!important"></li>
		<li>
			<a class="dropdown-item ew-row-link ew-detail-edit" href="#" onclick="Buka('/simrs/reporting/nota_rincian_inacbg.php?id=<?php echo urlencode(CurrentPage()->VISIT_ID->CurrentValue) ?>'); return false">INACBG</a>
		</li>
		<li>
			<a class="dropdown-item ew-row-link ew-detail-edit" href="#" onclick="Buka('/simrs/reporting/nota_rincian_inadrg.php?id=<?php echo urlencode(CurrentPage()->VISIT_ID->CurrentValue) ?>'); return false">INADRG</a>
		</li>
	</ul>
</div>

<div class="btn-group btn-group-sm ew-btn-group">
	<a class="btn btn-primary ew-row-link ew-detail" href="print.html" onclick="Buka('/simrs/reporting/jasper.php?id=<?php echo urlencode(CurrentPage()->VISIT_ID->CurrentValue) ?>'); return false">RESUME MEDIS</a>

	<button class="dropdown-toggle btn btn-primary ew-detail" data-toggle="dropdown" aria-expanded="false"></button>
	<ul class="dropdown-menu" style="">
		<li>
			<a class="dropdown-item ew-row-link ew-detail-edit" href="print.html" onclick="Buka('/simrs/reporting/surat_keterangan_ranap.php?id=<?php echo urlencode(CurrentPage()->VISIT_ID->CurrentValue) ?>'); return false">Surat Ket. Rawat Inap</a>
		</li>
		<li>
			<a class="dropdown-item ew-row-link ew-detail-edit" href="print.html" onclick="Buka('/simrs/reporting/surat_keterangan_rajal.php?id=<?php echo urlencode(CurrentPage()->VISIT_ID->CurrentValue) ?>'); return false">Surat Ket. Rawat Jalan</a>
		</li>
		<li>
			<a class="dropdown-item ew-row-link ew-detail-edit" href="print.html" onclick="Buka('/simrs/reporting/surat_keterangan_pasien.php?id=<?php echo urlencode(CurrentPage()->VISIT_ID->CurrentValue) ?>'); return false">Surat Ket. Pasien</a>
		</li>
		<li>
			<a class="dropdown-item ew-row-link ew-detail-edit" href="print.html" onclick="Buka('/simrs/reporting/surat_keterangan_meninggal.php?id=<?php echo urlencode(CurrentPage()->VISIT_ID->CurrentValue) ?>'); return false">Surat Ket. Meninggal</a>
		</li>
		<li class="divider" style="border-bottom:1px solid #ccc!important"></li>
		<li>
			<a class="dropdown-item ew-row-link ew-detail-edit" href="print.html" onclick="Buka('/simrs/reporting/surat_kontrol.php?id=<?php echo urlencode(CurrentPage()->VISIT_ID->CurrentValue) ?>'); return false">Surat Kontrol</a>
		</li>
	</ul>
</div>

<a href="../simrs/pendaftaran/bridging/getrujukan.php?key=<?php echo urlencode(CurrentPage()->PASIEN_ID->CurrentValue) . '&id=' . urlencode(CurrentPage()->IDXDAFTAR->CurrentValue) ?>" class="btn btn-info btn-sm" role="button">Get Rujukan</a>
<?PHP
"https://localhost:8060/simrs/pendaftaran/PasienVisitationEdit/" . urlencode(CurrentPage()->IDXDAFTAR->CurrentValue) . "?showmaster=cv_pasien&fk_NO_REGISTRATION=" . urlencode(CurrentPage()->NO_REGISTRATION->CurrentValue)




?>
<a href="../simrs/pendaftaran/bridging/getrujukan.php?key=<?php echo urlencode(CurrentPage()->PASIEN_ID->CurrentValue) . '&id=' . urlencode(CurrentPage()->IDXDAFTAR->CurrentValue) . '&no=' . urlencode(CurrentPage()->NO_REGISTRATION->CurrentValue) ?>" class="btn btn-info btn-sm" role="button">Get Rujukan</a>



https://localhost:8060/simrs/pendaftaran/bridging/getrujukan.php?key=0000030400479&id=807514

https://localhost:8060/simrs/pendaftaran/PasienEdit/807643?showmaster=cv_pasien&fk_NO_REGISTRATION=088924
https://localhost:8060/simrs/pendaftaran/PasienVisitationEdit/807643?showmaster=cv_pasien&fk_NO_REGISTRATION=088924

'PasienVisitationList?showmaster=cv_pasien&fk_NO_REGISTRATION='.urlencode(CurrentPage()->NO_REGISTRATION->CurrentValue)

https://localhost:8060/simrs/pendaftaran/PasienVisitationEdit/807645?showmaster=cv_pasien&fk_NO_REGISTRATION=088924

"https://localhost:8060/simrs/pendaftaran/PasienVisitationEdit/".urlencode(CurrentPage()->IDXDAFTAR->CurrentValue)."?showmaster=cv_pasien&fk_NO_REGISTRATION=".urlencode(CurrentPage()->NO_REGISTRATION->CurrentValue)

'PasienVisitationList?showmaster=cv_pasien&fk_NO_REGISTRATION='.urlencode(CurrentPage()->NO_REGISTRATION->CurrentValue)


<?PHP
"PasienVisitationEdit/" . urlencode($this->IDXDAFTAR->CurrentValue) . "?showmaster=cv_pasien&fk_NO_REGISTRATION=" . urlencode($this->NO_REGISTRATION->CurrentValue)
?>
"https://localhost:8060/simrs/pendaftaran/PasienVisitationEdit/".urlencode($this->IDXDAFTAR->CurrentValue)."?showmaster=cv_pasien&fk_NO_REGISTRATION=".urlencode($this->NO_REGISTRATION->CurrentValue)

https://localhost:8060/simrs/pendaftaran/bridging/getrujukan.php?key=0000030400479&pelayanan=2&id=807655&catatan=-&nosurat=000000&eksekutif=0&dpjp=31418&no=088924






<a href="../bridging/insert_skdp.php?id=<?php echo urlencode(CurrentPage()->IDXDAFTAR->CurrentValue).'&poli='.urlencode(CurrentPage()->KDPOLI->CurrentValue).'&sep='.urlencode(CurrentPage()->NO_SKP->CurrentValue).'&tgl='.urlencode(CurrentPage()->tgl_kontrol->CurrentValue).'&dpjp='.urlencode(CurrentPage()->KDDPJP->CurrentValue)?>" class="btn btn-info btn-sm" role="button">Buat Kontrol</a>

<a href="../bridging/getrujukan.php?key=<?php echo urlencode(CurrentPage()->PASIEN_ID->CurrentValue) . '&pelayanan=' . urlencode(CurrentPage()->RESPONTGLPLG_DESC->CurrentValue) . '&id=' . urlencode(CurrentPage()->IDXDAFTAR->CurrentValue). '&catatan=' . urlencode(CurrentPage()->DESCRIPTION->CurrentValue). '&nosurat=' . urlencode(CurrentPage()->EDIT_SEP->CurrentValue). '&eksekutif=' . urlencode(CurrentPage()->KDPOLI_EKS->CurrentValue). '&dpjp=' . urlencode(CurrentPage()->KDDPJP->CurrentValue) . '&no=' . urlencode(CurrentPage()->NO_REGISTRATION->CurrentValue) ?>" class="btn btn-info btn-sm" role="button">Insert SEP</a>