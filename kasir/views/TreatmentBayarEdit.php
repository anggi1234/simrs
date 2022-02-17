<?php

namespace PHPMaker2021\SIMRSSQLSERVER;

// Page object
$TreatmentBayarEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fTREATMENT_BAYARedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fTREATMENT_BAYARedit = currentForm = new ew.Form("fTREATMENT_BAYARedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "TREATMENT_BAYAR")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.TREATMENT_BAYAR)
        ew.vars.tables.TREATMENT_BAYAR = currentTable;
    fTREATMENT_BAYARedit.addFields([
        ["ORG_UNIT_CODE", [fields.ORG_UNIT_CODE.visible && fields.ORG_UNIT_CODE.required ? ew.Validators.required(fields.ORG_UNIT_CODE.caption) : null], fields.ORG_UNIT_CODE.isInvalid],
        ["BILL_ID", [fields.BILL_ID.visible && fields.BILL_ID.required ? ew.Validators.required(fields.BILL_ID.caption) : null], fields.BILL_ID.isInvalid],
        ["NO_REGISTRATION", [fields.NO_REGISTRATION.visible && fields.NO_REGISTRATION.required ? ew.Validators.required(fields.NO_REGISTRATION.caption) : null], fields.NO_REGISTRATION.isInvalid],
        ["VISIT_ID", [fields.VISIT_ID.visible && fields.VISIT_ID.required ? ew.Validators.required(fields.VISIT_ID.caption) : null], fields.VISIT_ID.isInvalid],
        ["TARIF_ID", [fields.TARIF_ID.visible && fields.TARIF_ID.required ? ew.Validators.required(fields.TARIF_ID.caption) : null], fields.TARIF_ID.isInvalid],
        ["CLASS_ID", [fields.CLASS_ID.visible && fields.CLASS_ID.required ? ew.Validators.required(fields.CLASS_ID.caption) : null, ew.Validators.integer], fields.CLASS_ID.isInvalid],
        ["CLINIC_ID", [fields.CLINIC_ID.visible && fields.CLINIC_ID.required ? ew.Validators.required(fields.CLINIC_ID.caption) : null], fields.CLINIC_ID.isInvalid],
        ["CLINIC_ID_FROM", [fields.CLINIC_ID_FROM.visible && fields.CLINIC_ID_FROM.required ? ew.Validators.required(fields.CLINIC_ID_FROM.caption) : null], fields.CLINIC_ID_FROM.isInvalid],
        ["TREATMENT", [fields.TREATMENT.visible && fields.TREATMENT.required ? ew.Validators.required(fields.TREATMENT.caption) : null], fields.TREATMENT.isInvalid],
        ["TREAT_DATE", [fields.TREAT_DATE.visible && fields.TREAT_DATE.required ? ew.Validators.required(fields.TREAT_DATE.caption) : null, ew.Validators.datetime(0)], fields.TREAT_DATE.isInvalid],
        ["AMOUNT", [fields.AMOUNT.visible && fields.AMOUNT.required ? ew.Validators.required(fields.AMOUNT.caption) : null, ew.Validators.float], fields.AMOUNT.isInvalid],
        ["QUANTITY", [fields.QUANTITY.visible && fields.QUANTITY.required ? ew.Validators.required(fields.QUANTITY.caption) : null, ew.Validators.float], fields.QUANTITY.isInvalid],
        ["MEASURE_ID", [fields.MEASURE_ID.visible && fields.MEASURE_ID.required ? ew.Validators.required(fields.MEASURE_ID.caption) : null, ew.Validators.integer], fields.MEASURE_ID.isInvalid],
        ["POKOK_JUAL", [fields.POKOK_JUAL.visible && fields.POKOK_JUAL.required ? ew.Validators.required(fields.POKOK_JUAL.caption) : null, ew.Validators.float], fields.POKOK_JUAL.isInvalid],
        ["PPN", [fields.PPN.visible && fields.PPN.required ? ew.Validators.required(fields.PPN.caption) : null, ew.Validators.float], fields.PPN.isInvalid],
        ["MARGIN", [fields.MARGIN.visible && fields.MARGIN.required ? ew.Validators.required(fields.MARGIN.caption) : null, ew.Validators.float], fields.MARGIN.isInvalid],
        ["SUBSIDI", [fields.SUBSIDI.visible && fields.SUBSIDI.required ? ew.Validators.required(fields.SUBSIDI.caption) : null, ew.Validators.float], fields.SUBSIDI.isInvalid],
        ["EMBALACE", [fields.EMBALACE.visible && fields.EMBALACE.required ? ew.Validators.required(fields.EMBALACE.caption) : null, ew.Validators.float], fields.EMBALACE.isInvalid],
        ["PROFESI", [fields.PROFESI.visible && fields.PROFESI.required ? ew.Validators.required(fields.PROFESI.caption) : null, ew.Validators.float], fields.PROFESI.isInvalid],
        ["DISCOUNT", [fields.DISCOUNT.visible && fields.DISCOUNT.required ? ew.Validators.required(fields.DISCOUNT.caption) : null, ew.Validators.float], fields.DISCOUNT.isInvalid],
        ["PAY_METHOD_ID", [fields.PAY_METHOD_ID.visible && fields.PAY_METHOD_ID.required ? ew.Validators.required(fields.PAY_METHOD_ID.caption) : null, ew.Validators.integer], fields.PAY_METHOD_ID.isInvalid],
        ["PAYMENT_DATE", [fields.PAYMENT_DATE.visible && fields.PAYMENT_DATE.required ? ew.Validators.required(fields.PAYMENT_DATE.caption) : null, ew.Validators.datetime(0)], fields.PAYMENT_DATE.isInvalid],
        ["ISLUNAS", [fields.ISLUNAS.visible && fields.ISLUNAS.required ? ew.Validators.required(fields.ISLUNAS.caption) : null], fields.ISLUNAS.isInvalid],
        ["DUEDATE_ANGSURAN", [fields.DUEDATE_ANGSURAN.visible && fields.DUEDATE_ANGSURAN.required ? ew.Validators.required(fields.DUEDATE_ANGSURAN.caption) : null, ew.Validators.datetime(0)], fields.DUEDATE_ANGSURAN.isInvalid],
        ["DESCRIPTION", [fields.DESCRIPTION.visible && fields.DESCRIPTION.required ? ew.Validators.required(fields.DESCRIPTION.caption) : null], fields.DESCRIPTION.isInvalid],
        ["KUITANSI_ID", [fields.KUITANSI_ID.visible && fields.KUITANSI_ID.required ? ew.Validators.required(fields.KUITANSI_ID.caption) : null], fields.KUITANSI_ID.isInvalid],
        ["NOTA_NO", [fields.NOTA_NO.visible && fields.NOTA_NO.required ? ew.Validators.required(fields.NOTA_NO.caption) : null], fields.NOTA_NO.isInvalid],
        ["ISCETAK", [fields.ISCETAK.visible && fields.ISCETAK.required ? ew.Validators.required(fields.ISCETAK.caption) : null], fields.ISCETAK.isInvalid],
        ["PRINT_DATE", [fields.PRINT_DATE.visible && fields.PRINT_DATE.required ? ew.Validators.required(fields.PRINT_DATE.caption) : null, ew.Validators.datetime(0)], fields.PRINT_DATE.isInvalid],
        ["RESEP_NO", [fields.RESEP_NO.visible && fields.RESEP_NO.required ? ew.Validators.required(fields.RESEP_NO.caption) : null], fields.RESEP_NO.isInvalid],
        ["RESEP_KE", [fields.RESEP_KE.visible && fields.RESEP_KE.required ? ew.Validators.required(fields.RESEP_KE.caption) : null, ew.Validators.integer], fields.RESEP_KE.isInvalid],
        ["DOSE", [fields.DOSE.visible && fields.DOSE.required ? ew.Validators.required(fields.DOSE.caption) : null, ew.Validators.float], fields.DOSE.isInvalid],
        ["ORIG_DOSE", [fields.ORIG_DOSE.visible && fields.ORIG_DOSE.required ? ew.Validators.required(fields.ORIG_DOSE.caption) : null, ew.Validators.float], fields.ORIG_DOSE.isInvalid],
        ["DOSE_PRESC", [fields.DOSE_PRESC.visible && fields.DOSE_PRESC.required ? ew.Validators.required(fields.DOSE_PRESC.caption) : null, ew.Validators.float], fields.DOSE_PRESC.isInvalid],
        ["ITER", [fields.ITER.visible && fields.ITER.required ? ew.Validators.required(fields.ITER.caption) : null, ew.Validators.integer], fields.ITER.isInvalid],
        ["ITER_KE", [fields.ITER_KE.visible && fields.ITER_KE.required ? ew.Validators.required(fields.ITER_KE.caption) : null, ew.Validators.integer], fields.ITER_KE.isInvalid],
        ["SOLD_STATUS", [fields.SOLD_STATUS.visible && fields.SOLD_STATUS.required ? ew.Validators.required(fields.SOLD_STATUS.caption) : null, ew.Validators.integer], fields.SOLD_STATUS.isInvalid],
        ["RACIKAN", [fields.RACIKAN.visible && fields.RACIKAN.required ? ew.Validators.required(fields.RACIKAN.caption) : null, ew.Validators.integer], fields.RACIKAN.isInvalid],
        ["CLASS_ROOM_ID", [fields.CLASS_ROOM_ID.visible && fields.CLASS_ROOM_ID.required ? ew.Validators.required(fields.CLASS_ROOM_ID.caption) : null], fields.CLASS_ROOM_ID.isInvalid],
        ["KELUAR_ID", [fields.KELUAR_ID.visible && fields.KELUAR_ID.required ? ew.Validators.required(fields.KELUAR_ID.caption) : null, ew.Validators.integer], fields.KELUAR_ID.isInvalid],
        ["BED_ID", [fields.BED_ID.visible && fields.BED_ID.required ? ew.Validators.required(fields.BED_ID.caption) : null, ew.Validators.integer], fields.BED_ID.isInvalid],
        ["PERDA_ID", [fields.PERDA_ID.visible && fields.PERDA_ID.required ? ew.Validators.required(fields.PERDA_ID.caption) : null, ew.Validators.integer], fields.PERDA_ID.isInvalid],
        ["EMPLOYEE_ID", [fields.EMPLOYEE_ID.visible && fields.EMPLOYEE_ID.required ? ew.Validators.required(fields.EMPLOYEE_ID.caption) : null], fields.EMPLOYEE_ID.isInvalid],
        ["DESCRIPTION2", [fields.DESCRIPTION2.visible && fields.DESCRIPTION2.required ? ew.Validators.required(fields.DESCRIPTION2.caption) : null], fields.DESCRIPTION2.isInvalid],
        ["MODIFIED_BY", [fields.MODIFIED_BY.visible && fields.MODIFIED_BY.required ? ew.Validators.required(fields.MODIFIED_BY.caption) : null], fields.MODIFIED_BY.isInvalid],
        ["MODIFIED_DATE", [fields.MODIFIED_DATE.visible && fields.MODIFIED_DATE.required ? ew.Validators.required(fields.MODIFIED_DATE.caption) : null, ew.Validators.datetime(0)], fields.MODIFIED_DATE.isInvalid],
        ["MODIFIED_FROM", [fields.MODIFIED_FROM.visible && fields.MODIFIED_FROM.required ? ew.Validators.required(fields.MODIFIED_FROM.caption) : null], fields.MODIFIED_FROM.isInvalid],
        ["BRAND_ID", [fields.BRAND_ID.visible && fields.BRAND_ID.required ? ew.Validators.required(fields.BRAND_ID.caption) : null], fields.BRAND_ID.isInvalid],
        ["DOCTOR", [fields.DOCTOR.visible && fields.DOCTOR.required ? ew.Validators.required(fields.DOCTOR.caption) : null], fields.DOCTOR.isInvalid],
        ["JML_BKS", [fields.JML_BKS.visible && fields.JML_BKS.required ? ew.Validators.required(fields.JML_BKS.caption) : null, ew.Validators.integer], fields.JML_BKS.isInvalid],
        ["EXIT_DATE", [fields.EXIT_DATE.visible && fields.EXIT_DATE.required ? ew.Validators.required(fields.EXIT_DATE.caption) : null, ew.Validators.datetime(0)], fields.EXIT_DATE.isInvalid],
        ["FA_V", [fields.FA_V.visible && fields.FA_V.required ? ew.Validators.required(fields.FA_V.caption) : null, ew.Validators.integer], fields.FA_V.isInvalid],
        ["TASK_ID", [fields.TASK_ID.visible && fields.TASK_ID.required ? ew.Validators.required(fields.TASK_ID.caption) : null, ew.Validators.integer], fields.TASK_ID.isInvalid],
        ["EMPLOYEE_ID_FROM", [fields.EMPLOYEE_ID_FROM.visible && fields.EMPLOYEE_ID_FROM.required ? ew.Validators.required(fields.EMPLOYEE_ID_FROM.caption) : null], fields.EMPLOYEE_ID_FROM.isInvalid],
        ["DOCTOR_FROM", [fields.DOCTOR_FROM.visible && fields.DOCTOR_FROM.required ? ew.Validators.required(fields.DOCTOR_FROM.caption) : null], fields.DOCTOR_FROM.isInvalid],
        ["status_pasien_id", [fields.status_pasien_id.visible && fields.status_pasien_id.required ? ew.Validators.required(fields.status_pasien_id.caption) : null, ew.Validators.integer], fields.status_pasien_id.isInvalid],
        ["amount_paid", [fields.amount_paid.visible && fields.amount_paid.required ? ew.Validators.required(fields.amount_paid.caption) : null, ew.Validators.float], fields.amount_paid.isInvalid],
        ["THENAME", [fields.THENAME.visible && fields.THENAME.required ? ew.Validators.required(fields.THENAME.caption) : null], fields.THENAME.isInvalid],
        ["THEADDRESS", [fields.THEADDRESS.visible && fields.THEADDRESS.required ? ew.Validators.required(fields.THEADDRESS.caption) : null], fields.THEADDRESS.isInvalid],
        ["THEID", [fields.THEID.visible && fields.THEID.required ? ew.Validators.required(fields.THEID.caption) : null], fields.THEID.isInvalid],
        ["serial_nb", [fields.serial_nb.visible && fields.serial_nb.required ? ew.Validators.required(fields.serial_nb.caption) : null], fields.serial_nb.isInvalid],
        ["TREATMENT_PLAFOND", [fields.TREATMENT_PLAFOND.visible && fields.TREATMENT_PLAFOND.required ? ew.Validators.required(fields.TREATMENT_PLAFOND.caption) : null], fields.TREATMENT_PLAFOND.isInvalid],
        ["AMOUNT_PLAFOND", [fields.AMOUNT_PLAFOND.visible && fields.AMOUNT_PLAFOND.required ? ew.Validators.required(fields.AMOUNT_PLAFOND.caption) : null, ew.Validators.float], fields.AMOUNT_PLAFOND.isInvalid],
        ["AMOUNT_PAID_PLAFOND", [fields.AMOUNT_PAID_PLAFOND.visible && fields.AMOUNT_PAID_PLAFOND.required ? ew.Validators.required(fields.AMOUNT_PAID_PLAFOND.caption) : null, ew.Validators.float], fields.AMOUNT_PAID_PLAFOND.isInvalid],
        ["CLASS_ID_PLAFOND", [fields.CLASS_ID_PLAFOND.visible && fields.CLASS_ID_PLAFOND.required ? ew.Validators.required(fields.CLASS_ID_PLAFOND.caption) : null, ew.Validators.integer], fields.CLASS_ID_PLAFOND.isInvalid],
        ["PAYOR_ID", [fields.PAYOR_ID.visible && fields.PAYOR_ID.required ? ew.Validators.required(fields.PAYOR_ID.caption) : null], fields.PAYOR_ID.isInvalid],
        ["PEMBULATAN", [fields.PEMBULATAN.visible && fields.PEMBULATAN.required ? ew.Validators.required(fields.PEMBULATAN.caption) : null, ew.Validators.float], fields.PEMBULATAN.isInvalid],
        ["ISRJ", [fields.ISRJ.visible && fields.ISRJ.required ? ew.Validators.required(fields.ISRJ.caption) : null], fields.ISRJ.isInvalid],
        ["AGEYEAR", [fields.AGEYEAR.visible && fields.AGEYEAR.required ? ew.Validators.required(fields.AGEYEAR.caption) : null, ew.Validators.integer], fields.AGEYEAR.isInvalid],
        ["AGEMONTH", [fields.AGEMONTH.visible && fields.AGEMONTH.required ? ew.Validators.required(fields.AGEMONTH.caption) : null, ew.Validators.integer], fields.AGEMONTH.isInvalid],
        ["AGEDAY", [fields.AGEDAY.visible && fields.AGEDAY.required ? ew.Validators.required(fields.AGEDAY.caption) : null, ew.Validators.integer], fields.AGEDAY.isInvalid],
        ["GENDER", [fields.GENDER.visible && fields.GENDER.required ? ew.Validators.required(fields.GENDER.caption) : null], fields.GENDER.isInvalid],
        ["KAL_ID", [fields.KAL_ID.visible && fields.KAL_ID.required ? ew.Validators.required(fields.KAL_ID.caption) : null], fields.KAL_ID.isInvalid],
        ["CORRECTION_ID", [fields.CORRECTION_ID.visible && fields.CORRECTION_ID.required ? ew.Validators.required(fields.CORRECTION_ID.caption) : null], fields.CORRECTION_ID.isInvalid],
        ["CORRECTION_BY", [fields.CORRECTION_BY.visible && fields.CORRECTION_BY.required ? ew.Validators.required(fields.CORRECTION_BY.caption) : null], fields.CORRECTION_BY.isInvalid],
        ["KARYAWAN", [fields.KARYAWAN.visible && fields.KARYAWAN.required ? ew.Validators.required(fields.KARYAWAN.caption) : null], fields.KARYAWAN.isInvalid],
        ["ACCOUNT_ID", [fields.ACCOUNT_ID.visible && fields.ACCOUNT_ID.required ? ew.Validators.required(fields.ACCOUNT_ID.caption) : null], fields.ACCOUNT_ID.isInvalid],
        ["sell_price", [fields.sell_price.visible && fields.sell_price.required ? ew.Validators.required(fields.sell_price.caption) : null, ew.Validators.float], fields.sell_price.isInvalid],
        ["diskon", [fields.diskon.visible && fields.diskon.required ? ew.Validators.required(fields.diskon.caption) : null, ew.Validators.float], fields.diskon.isInvalid],
        ["INVOICE_ID", [fields.INVOICE_ID.visible && fields.INVOICE_ID.required ? ew.Validators.required(fields.INVOICE_ID.caption) : null], fields.INVOICE_ID.isInvalid],
        ["NUMER", [fields.NUMER.visible && fields.NUMER.required ? ew.Validators.required(fields.NUMER.caption) : null], fields.NUMER.isInvalid],
        ["MEASURE_ID2", [fields.MEASURE_ID2.visible && fields.MEASURE_ID2.required ? ew.Validators.required(fields.MEASURE_ID2.caption) : null, ew.Validators.integer], fields.MEASURE_ID2.isInvalid],
        ["POTONGAN", [fields.POTONGAN.visible && fields.POTONGAN.required ? ew.Validators.required(fields.POTONGAN.caption) : null, ew.Validators.float], fields.POTONGAN.isInvalid],
        ["BAYAR", [fields.BAYAR.visible && fields.BAYAR.required ? ew.Validators.required(fields.BAYAR.caption) : null, ew.Validators.float], fields.BAYAR.isInvalid],
        ["RETUR", [fields.RETUR.visible && fields.RETUR.required ? ew.Validators.required(fields.RETUR.caption) : null, ew.Validators.float], fields.RETUR.isInvalid],
        ["TARIF_TYPE", [fields.TARIF_TYPE.visible && fields.TARIF_TYPE.required ? ew.Validators.required(fields.TARIF_TYPE.caption) : null], fields.TARIF_TYPE.isInvalid],
        ["PPNVALUE", [fields.PPNVALUE.visible && fields.PPNVALUE.required ? ew.Validators.required(fields.PPNVALUE.caption) : null, ew.Validators.float], fields.PPNVALUE.isInvalid],
        ["TAGIHAN", [fields.TAGIHAN.visible && fields.TAGIHAN.required ? ew.Validators.required(fields.TAGIHAN.caption) : null, ew.Validators.float], fields.TAGIHAN.isInvalid],
        ["KOREKSI", [fields.KOREKSI.visible && fields.KOREKSI.required ? ew.Validators.required(fields.KOREKSI.caption) : null, ew.Validators.float], fields.KOREKSI.isInvalid],
        ["STATUS_OBAT", [fields.STATUS_OBAT.visible && fields.STATUS_OBAT.required ? ew.Validators.required(fields.STATUS_OBAT.caption) : null, ew.Validators.integer], fields.STATUS_OBAT.isInvalid],
        ["SUBSIDISAT", [fields.SUBSIDISAT.visible && fields.SUBSIDISAT.required ? ew.Validators.required(fields.SUBSIDISAT.caption) : null, ew.Validators.float], fields.SUBSIDISAT.isInvalid],
        ["PRINTQ", [fields.PRINTQ.visible && fields.PRINTQ.required ? ew.Validators.required(fields.PRINTQ.caption) : null, ew.Validators.integer], fields.PRINTQ.isInvalid],
        ["PRINTED_BY", [fields.PRINTED_BY.visible && fields.PRINTED_BY.required ? ew.Validators.required(fields.PRINTED_BY.caption) : null], fields.PRINTED_BY.isInvalid],
        ["STOCK_AVAILABLE", [fields.STOCK_AVAILABLE.visible && fields.STOCK_AVAILABLE.required ? ew.Validators.required(fields.STOCK_AVAILABLE.caption) : null, ew.Validators.float], fields.STOCK_AVAILABLE.isInvalid],
        ["STATUS_TARIF", [fields.STATUS_TARIF.visible && fields.STATUS_TARIF.required ? ew.Validators.required(fields.STATUS_TARIF.caption) : null, ew.Validators.integer], fields.STATUS_TARIF.isInvalid],
        ["CLINIC_TYPE", [fields.CLINIC_TYPE.visible && fields.CLINIC_TYPE.required ? ew.Validators.required(fields.CLINIC_TYPE.caption) : null, ew.Validators.integer], fields.CLINIC_TYPE.isInvalid],
        ["PACKAGE_ID", [fields.PACKAGE_ID.visible && fields.PACKAGE_ID.required ? ew.Validators.required(fields.PACKAGE_ID.caption) : null], fields.PACKAGE_ID.isInvalid],
        ["MODULE_ID", [fields.MODULE_ID.visible && fields.MODULE_ID.required ? ew.Validators.required(fields.MODULE_ID.caption) : null], fields.MODULE_ID.isInvalid],
        ["profession", [fields.profession.visible && fields.profession.required ? ew.Validators.required(fields.profession.caption) : null, ew.Validators.float], fields.profession.isInvalid],
        ["THEORDER", [fields.THEORDER.visible && fields.THEORDER.required ? ew.Validators.required(fields.THEORDER.caption) : null, ew.Validators.integer], fields.THEORDER.isInvalid],
        ["CASHIER", [fields.CASHIER.visible && fields.CASHIER.required ? ew.Validators.required(fields.CASHIER.caption) : null], fields.CASHIER.isInvalid],
        ["SPPFEE", [fields.SPPFEE.visible && fields.SPPFEE.required ? ew.Validators.required(fields.SPPFEE.caption) : null], fields.SPPFEE.isInvalid],
        ["SPPBILL", [fields.SPPBILL.visible && fields.SPPBILL.required ? ew.Validators.required(fields.SPPBILL.caption) : null], fields.SPPBILL.isInvalid],
        ["SPPRJK", [fields.SPPRJK.visible && fields.SPPRJK.required ? ew.Validators.required(fields.SPPRJK.caption) : null], fields.SPPRJK.isInvalid],
        ["SPPJMN", [fields.SPPJMN.visible && fields.SPPJMN.required ? ew.Validators.required(fields.SPPJMN.caption) : null], fields.SPPJMN.isInvalid],
        ["SPPKASIR", [fields.SPPKASIR.visible && fields.SPPKASIR.required ? ew.Validators.required(fields.SPPKASIR.caption) : null], fields.SPPKASIR.isInvalid],
        ["PERUJUK", [fields.PERUJUK.visible && fields.PERUJUK.required ? ew.Validators.required(fields.PERUJUK.caption) : null], fields.PERUJUK.isInvalid],
        ["PERUJUKFEE", [fields.PERUJUKFEE.visible && fields.PERUJUKFEE.required ? ew.Validators.required(fields.PERUJUKFEE.caption) : null, ew.Validators.float], fields.PERUJUKFEE.isInvalid],
        ["modified_datesys", [fields.modified_datesys.visible && fields.modified_datesys.required ? ew.Validators.required(fields.modified_datesys.caption) : null, ew.Validators.datetime(0)], fields.modified_datesys.isInvalid],
        ["TRANS_ID", [fields.TRANS_ID.visible && fields.TRANS_ID.required ? ew.Validators.required(fields.TRANS_ID.caption) : null], fields.TRANS_ID.isInvalid],
        ["SPPBILLDATE", [fields.SPPBILLDATE.visible && fields.SPPBILLDATE.required ? ew.Validators.required(fields.SPPBILLDATE.caption) : null, ew.Validators.datetime(0)], fields.SPPBILLDATE.isInvalid],
        ["SPPBILLUSER", [fields.SPPBILLUSER.visible && fields.SPPBILLUSER.required ? ew.Validators.required(fields.SPPBILLUSER.caption) : null], fields.SPPBILLUSER.isInvalid],
        ["SPPKASIRDATE", [fields.SPPKASIRDATE.visible && fields.SPPKASIRDATE.required ? ew.Validators.required(fields.SPPKASIRDATE.caption) : null, ew.Validators.datetime(0)], fields.SPPKASIRDATE.isInvalid],
        ["SPPKASIRUSER", [fields.SPPKASIRUSER.visible && fields.SPPKASIRUSER.required ? ew.Validators.required(fields.SPPKASIRUSER.caption) : null], fields.SPPKASIRUSER.isInvalid],
        ["SPPPOLI", [fields.SPPPOLI.visible && fields.SPPPOLI.required ? ew.Validators.required(fields.SPPPOLI.caption) : null], fields.SPPPOLI.isInvalid],
        ["SPPPOLIUSER", [fields.SPPPOLIUSER.visible && fields.SPPPOLIUSER.required ? ew.Validators.required(fields.SPPPOLIUSER.caption) : null], fields.SPPPOLIUSER.isInvalid],
        ["SPPPOLIDATE", [fields.SPPPOLIDATE.visible && fields.SPPPOLIDATE.required ? ew.Validators.required(fields.SPPPOLIDATE.caption) : null, ew.Validators.datetime(0)], fields.SPPPOLIDATE.isInvalid],
        ["ID", [fields.ID.visible && fields.ID.required ? ew.Validators.required(fields.ID.caption) : null], fields.ID.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fTREATMENT_BAYARedit,
            fobj = f.getForm(),
            $fobj = $(fobj),
            $k = $fobj.find("#" + f.formKeyCountName), // Get key_count
            rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1,
            startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
        for (var i = startcnt; i <= rowcnt; i++) {
            var rowIndex = ($k[0]) ? String(i) : "";
            f.setInvalid(rowIndex);
        }
    });

    // Validate form
    fTREATMENT_BAYARedit.validate = function () {
        if (!this.validateRequired)
            return true; // Ignore validation
        var fobj = this.getForm(),
            $fobj = $(fobj);
        if ($fobj.find("#confirm").val() == "confirm")
            return true;
        var addcnt = 0,
            $k = $fobj.find("#" + this.formKeyCountName), // Get key_count
            rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1,
            startcnt = (rowcnt == 0) ? 0 : 1, // Check rowcnt == 0 => Inline-Add
            gridinsert = ["insert", "gridinsert"].includes($fobj.find("#action").val()) && $k[0];
        for (var i = startcnt; i <= rowcnt; i++) {
            var rowIndex = ($k[0]) ? String(i) : "";
            $fobj.data("rowindex", rowIndex);

            // Validate fields
            if (!this.validateFields(rowIndex))
                return false;

            // Call Form_CustomValidate event
            if (!this.customValidate(fobj)) {
                this.focus();
                return false;
            }
        }

        // Process detail forms
        var dfs = $fobj.find("input[name='detailpage']").get();
        for (var i = 0; i < dfs.length; i++) {
            var df = dfs[i],
                val = df.value,
                frm = ew.forms.get(val);
            if (val && frm && !frm.validate())
                return false;
        }
        return true;
    }

    // Form_CustomValidate
    fTREATMENT_BAYARedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fTREATMENT_BAYARedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fTREATMENT_BAYARedit");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fTREATMENT_BAYARedit" id="fTREATMENT_BAYARedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="TREATMENT_BAYAR">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "V_KASIR") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="V_KASIR">
<input type="hidden" name="fk_VISIT_ID" value="<?= HtmlEncode($Page->VISIT_ID->getSessionValue()) ?>">
<input type="hidden" name="fk_NO_REGISTRATION" value="<?= HtmlEncode($Page->NO_REGISTRATION->getSessionValue()) ?>">
<?php } ?>
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->ORG_UNIT_CODE->Visible) { // ORG_UNIT_CODE ?>
    <div id="r_ORG_UNIT_CODE" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_ORG_UNIT_CODE" for="x_ORG_UNIT_CODE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ORG_UNIT_CODE->caption() ?><?= $Page->ORG_UNIT_CODE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ORG_UNIT_CODE->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_ORG_UNIT_CODE">
<input type="<?= $Page->ORG_UNIT_CODE->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_ORG_UNIT_CODE" name="x_ORG_UNIT_CODE" id="x_ORG_UNIT_CODE" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->ORG_UNIT_CODE->getPlaceHolder()) ?>" value="<?= $Page->ORG_UNIT_CODE->EditValue ?>"<?= $Page->ORG_UNIT_CODE->editAttributes() ?> aria-describedby="x_ORG_UNIT_CODE_help">
<?= $Page->ORG_UNIT_CODE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ORG_UNIT_CODE->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->BILL_ID->Visible) { // BILL_ID ?>
    <div id="r_BILL_ID" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_BILL_ID" for="x_BILL_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->BILL_ID->caption() ?><?= $Page->BILL_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->BILL_ID->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_BILL_ID">
<input type="<?= $Page->BILL_ID->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_BILL_ID" name="x_BILL_ID" id="x_BILL_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->BILL_ID->getPlaceHolder()) ?>" value="<?= $Page->BILL_ID->EditValue ?>"<?= $Page->BILL_ID->editAttributes() ?> aria-describedby="x_BILL_ID_help">
<?= $Page->BILL_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->BILL_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->NO_REGISTRATION->Visible) { // NO_REGISTRATION ?>
    <div id="r_NO_REGISTRATION" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_NO_REGISTRATION" for="x_NO_REGISTRATION" class="<?= $Page->LeftColumnClass ?>"><?= $Page->NO_REGISTRATION->caption() ?><?= $Page->NO_REGISTRATION->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->NO_REGISTRATION->cellAttributes() ?>>
<?php if ($Page->NO_REGISTRATION->getSessionValue() != "") { ?>
<span id="el_TREATMENT_BAYAR_NO_REGISTRATION">
<span<?= $Page->NO_REGISTRATION->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->NO_REGISTRATION->getDisplayValue($Page->NO_REGISTRATION->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x_NO_REGISTRATION" name="x_NO_REGISTRATION" value="<?= HtmlEncode($Page->NO_REGISTRATION->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_TREATMENT_BAYAR_NO_REGISTRATION">
<input type="<?= $Page->NO_REGISTRATION->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_NO_REGISTRATION" name="x_NO_REGISTRATION" id="x_NO_REGISTRATION" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->NO_REGISTRATION->getPlaceHolder()) ?>" value="<?= $Page->NO_REGISTRATION->EditValue ?>"<?= $Page->NO_REGISTRATION->editAttributes() ?> aria-describedby="x_NO_REGISTRATION_help">
<?= $Page->NO_REGISTRATION->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->NO_REGISTRATION->getErrorMessage() ?></div>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->VISIT_ID->Visible) { // VISIT_ID ?>
    <div id="r_VISIT_ID" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_VISIT_ID" for="x_VISIT_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->VISIT_ID->caption() ?><?= $Page->VISIT_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->VISIT_ID->cellAttributes() ?>>
<?php if ($Page->VISIT_ID->getSessionValue() != "") { ?>
<span id="el_TREATMENT_BAYAR_VISIT_ID">
<span<?= $Page->VISIT_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->VISIT_ID->getDisplayValue($Page->VISIT_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x_VISIT_ID" name="x_VISIT_ID" value="<?= HtmlEncode($Page->VISIT_ID->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_TREATMENT_BAYAR_VISIT_ID">
<input type="<?= $Page->VISIT_ID->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_VISIT_ID" name="x_VISIT_ID" id="x_VISIT_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->VISIT_ID->getPlaceHolder()) ?>" value="<?= $Page->VISIT_ID->EditValue ?>"<?= $Page->VISIT_ID->editAttributes() ?> aria-describedby="x_VISIT_ID_help">
<?= $Page->VISIT_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->VISIT_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->TARIF_ID->Visible) { // TARIF_ID ?>
    <div id="r_TARIF_ID" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_TARIF_ID" for="x_TARIF_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->TARIF_ID->caption() ?><?= $Page->TARIF_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->TARIF_ID->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_TARIF_ID">
<input type="<?= $Page->TARIF_ID->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_TARIF_ID" name="x_TARIF_ID" id="x_TARIF_ID" size="30" maxlength="25" placeholder="<?= HtmlEncode($Page->TARIF_ID->getPlaceHolder()) ?>" value="<?= $Page->TARIF_ID->EditValue ?>"<?= $Page->TARIF_ID->editAttributes() ?> aria-describedby="x_TARIF_ID_help">
<?= $Page->TARIF_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->TARIF_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->CLASS_ID->Visible) { // CLASS_ID ?>
    <div id="r_CLASS_ID" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_CLASS_ID" for="x_CLASS_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->CLASS_ID->caption() ?><?= $Page->CLASS_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->CLASS_ID->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_CLASS_ID">
<input type="<?= $Page->CLASS_ID->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_CLASS_ID" name="x_CLASS_ID" id="x_CLASS_ID" size="30" placeholder="<?= HtmlEncode($Page->CLASS_ID->getPlaceHolder()) ?>" value="<?= $Page->CLASS_ID->EditValue ?>"<?= $Page->CLASS_ID->editAttributes() ?> aria-describedby="x_CLASS_ID_help">
<?= $Page->CLASS_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->CLASS_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->CLINIC_ID->Visible) { // CLINIC_ID ?>
    <div id="r_CLINIC_ID" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_CLINIC_ID" for="x_CLINIC_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->CLINIC_ID->caption() ?><?= $Page->CLINIC_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->CLINIC_ID->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_CLINIC_ID">
<input type="<?= $Page->CLINIC_ID->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_CLINIC_ID" name="x_CLINIC_ID" id="x_CLINIC_ID" size="30" maxlength="15" placeholder="<?= HtmlEncode($Page->CLINIC_ID->getPlaceHolder()) ?>" value="<?= $Page->CLINIC_ID->EditValue ?>"<?= $Page->CLINIC_ID->editAttributes() ?> aria-describedby="x_CLINIC_ID_help">
<?= $Page->CLINIC_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->CLINIC_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->CLINIC_ID_FROM->Visible) { // CLINIC_ID_FROM ?>
    <div id="r_CLINIC_ID_FROM" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_CLINIC_ID_FROM" for="x_CLINIC_ID_FROM" class="<?= $Page->LeftColumnClass ?>"><?= $Page->CLINIC_ID_FROM->caption() ?><?= $Page->CLINIC_ID_FROM->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->CLINIC_ID_FROM->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_CLINIC_ID_FROM">
<input type="<?= $Page->CLINIC_ID_FROM->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_CLINIC_ID_FROM" name="x_CLINIC_ID_FROM" id="x_CLINIC_ID_FROM" size="30" maxlength="15" placeholder="<?= HtmlEncode($Page->CLINIC_ID_FROM->getPlaceHolder()) ?>" value="<?= $Page->CLINIC_ID_FROM->EditValue ?>"<?= $Page->CLINIC_ID_FROM->editAttributes() ?> aria-describedby="x_CLINIC_ID_FROM_help">
<?= $Page->CLINIC_ID_FROM->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->CLINIC_ID_FROM->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->TREATMENT->Visible) { // TREATMENT ?>
    <div id="r_TREATMENT" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_TREATMENT" for="x_TREATMENT" class="<?= $Page->LeftColumnClass ?>"><?= $Page->TREATMENT->caption() ?><?= $Page->TREATMENT->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->TREATMENT->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_TREATMENT">
<input type="<?= $Page->TREATMENT->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_TREATMENT" name="x_TREATMENT" id="x_TREATMENT" size="30" maxlength="200" placeholder="<?= HtmlEncode($Page->TREATMENT->getPlaceHolder()) ?>" value="<?= $Page->TREATMENT->EditValue ?>"<?= $Page->TREATMENT->editAttributes() ?> aria-describedby="x_TREATMENT_help">
<?= $Page->TREATMENT->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->TREATMENT->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->TREAT_DATE->Visible) { // TREAT_DATE ?>
    <div id="r_TREAT_DATE" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_TREAT_DATE" for="x_TREAT_DATE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->TREAT_DATE->caption() ?><?= $Page->TREAT_DATE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->TREAT_DATE->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_TREAT_DATE">
<input type="<?= $Page->TREAT_DATE->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_TREAT_DATE" name="x_TREAT_DATE" id="x_TREAT_DATE" placeholder="<?= HtmlEncode($Page->TREAT_DATE->getPlaceHolder()) ?>" value="<?= $Page->TREAT_DATE->EditValue ?>"<?= $Page->TREAT_DATE->editAttributes() ?> aria-describedby="x_TREAT_DATE_help">
<?= $Page->TREAT_DATE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->TREAT_DATE->getErrorMessage() ?></div>
<?php if (!$Page->TREAT_DATE->ReadOnly && !$Page->TREAT_DATE->Disabled && !isset($Page->TREAT_DATE->EditAttrs["readonly"]) && !isset($Page->TREAT_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fTREATMENT_BAYARedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fTREATMENT_BAYARedit", "x_TREAT_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->AMOUNT->Visible) { // AMOUNT ?>
    <div id="r_AMOUNT" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_AMOUNT" for="x_AMOUNT" class="<?= $Page->LeftColumnClass ?>"><?= $Page->AMOUNT->caption() ?><?= $Page->AMOUNT->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->AMOUNT->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_AMOUNT">
<input type="<?= $Page->AMOUNT->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_AMOUNT" name="x_AMOUNT" id="x_AMOUNT" size="30" placeholder="<?= HtmlEncode($Page->AMOUNT->getPlaceHolder()) ?>" value="<?= $Page->AMOUNT->EditValue ?>"<?= $Page->AMOUNT->editAttributes() ?> aria-describedby="x_AMOUNT_help">
<?= $Page->AMOUNT->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->AMOUNT->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->QUANTITY->Visible) { // QUANTITY ?>
    <div id="r_QUANTITY" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_QUANTITY" for="x_QUANTITY" class="<?= $Page->LeftColumnClass ?>"><?= $Page->QUANTITY->caption() ?><?= $Page->QUANTITY->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->QUANTITY->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_QUANTITY">
<input type="<?= $Page->QUANTITY->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_QUANTITY" name="x_QUANTITY" id="x_QUANTITY" size="30" placeholder="<?= HtmlEncode($Page->QUANTITY->getPlaceHolder()) ?>" value="<?= $Page->QUANTITY->EditValue ?>"<?= $Page->QUANTITY->editAttributes() ?> aria-describedby="x_QUANTITY_help">
<?= $Page->QUANTITY->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->QUANTITY->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->MEASURE_ID->Visible) { // MEASURE_ID ?>
    <div id="r_MEASURE_ID" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_MEASURE_ID" for="x_MEASURE_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->MEASURE_ID->caption() ?><?= $Page->MEASURE_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->MEASURE_ID->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_MEASURE_ID">
<input type="<?= $Page->MEASURE_ID->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_MEASURE_ID" name="x_MEASURE_ID" id="x_MEASURE_ID" size="30" placeholder="<?= HtmlEncode($Page->MEASURE_ID->getPlaceHolder()) ?>" value="<?= $Page->MEASURE_ID->EditValue ?>"<?= $Page->MEASURE_ID->editAttributes() ?> aria-describedby="x_MEASURE_ID_help">
<?= $Page->MEASURE_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->MEASURE_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->POKOK_JUAL->Visible) { // POKOK_JUAL ?>
    <div id="r_POKOK_JUAL" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_POKOK_JUAL" for="x_POKOK_JUAL" class="<?= $Page->LeftColumnClass ?>"><?= $Page->POKOK_JUAL->caption() ?><?= $Page->POKOK_JUAL->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->POKOK_JUAL->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_POKOK_JUAL">
<input type="<?= $Page->POKOK_JUAL->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_POKOK_JUAL" name="x_POKOK_JUAL" id="x_POKOK_JUAL" size="30" placeholder="<?= HtmlEncode($Page->POKOK_JUAL->getPlaceHolder()) ?>" value="<?= $Page->POKOK_JUAL->EditValue ?>"<?= $Page->POKOK_JUAL->editAttributes() ?> aria-describedby="x_POKOK_JUAL_help">
<?= $Page->POKOK_JUAL->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->POKOK_JUAL->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->PPN->Visible) { // PPN ?>
    <div id="r_PPN" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_PPN" for="x_PPN" class="<?= $Page->LeftColumnClass ?>"><?= $Page->PPN->caption() ?><?= $Page->PPN->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PPN->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_PPN">
<input type="<?= $Page->PPN->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_PPN" name="x_PPN" id="x_PPN" size="30" placeholder="<?= HtmlEncode($Page->PPN->getPlaceHolder()) ?>" value="<?= $Page->PPN->EditValue ?>"<?= $Page->PPN->editAttributes() ?> aria-describedby="x_PPN_help">
<?= $Page->PPN->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->PPN->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->MARGIN->Visible) { // MARGIN ?>
    <div id="r_MARGIN" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_MARGIN" for="x_MARGIN" class="<?= $Page->LeftColumnClass ?>"><?= $Page->MARGIN->caption() ?><?= $Page->MARGIN->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->MARGIN->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_MARGIN">
<input type="<?= $Page->MARGIN->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_MARGIN" name="x_MARGIN" id="x_MARGIN" size="30" placeholder="<?= HtmlEncode($Page->MARGIN->getPlaceHolder()) ?>" value="<?= $Page->MARGIN->EditValue ?>"<?= $Page->MARGIN->editAttributes() ?> aria-describedby="x_MARGIN_help">
<?= $Page->MARGIN->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->MARGIN->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->SUBSIDI->Visible) { // SUBSIDI ?>
    <div id="r_SUBSIDI" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_SUBSIDI" for="x_SUBSIDI" class="<?= $Page->LeftColumnClass ?>"><?= $Page->SUBSIDI->caption() ?><?= $Page->SUBSIDI->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->SUBSIDI->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_SUBSIDI">
<input type="<?= $Page->SUBSIDI->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_SUBSIDI" name="x_SUBSIDI" id="x_SUBSIDI" size="30" placeholder="<?= HtmlEncode($Page->SUBSIDI->getPlaceHolder()) ?>" value="<?= $Page->SUBSIDI->EditValue ?>"<?= $Page->SUBSIDI->editAttributes() ?> aria-describedby="x_SUBSIDI_help">
<?= $Page->SUBSIDI->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->SUBSIDI->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->EMBALACE->Visible) { // EMBALACE ?>
    <div id="r_EMBALACE" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_EMBALACE" for="x_EMBALACE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->EMBALACE->caption() ?><?= $Page->EMBALACE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->EMBALACE->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_EMBALACE">
<input type="<?= $Page->EMBALACE->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_EMBALACE" name="x_EMBALACE" id="x_EMBALACE" size="30" placeholder="<?= HtmlEncode($Page->EMBALACE->getPlaceHolder()) ?>" value="<?= $Page->EMBALACE->EditValue ?>"<?= $Page->EMBALACE->editAttributes() ?> aria-describedby="x_EMBALACE_help">
<?= $Page->EMBALACE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->EMBALACE->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->PROFESI->Visible) { // PROFESI ?>
    <div id="r_PROFESI" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_PROFESI" for="x_PROFESI" class="<?= $Page->LeftColumnClass ?>"><?= $Page->PROFESI->caption() ?><?= $Page->PROFESI->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PROFESI->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_PROFESI">
<input type="<?= $Page->PROFESI->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_PROFESI" name="x_PROFESI" id="x_PROFESI" size="30" placeholder="<?= HtmlEncode($Page->PROFESI->getPlaceHolder()) ?>" value="<?= $Page->PROFESI->EditValue ?>"<?= $Page->PROFESI->editAttributes() ?> aria-describedby="x_PROFESI_help">
<?= $Page->PROFESI->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->PROFESI->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->DISCOUNT->Visible) { // DISCOUNT ?>
    <div id="r_DISCOUNT" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_DISCOUNT" for="x_DISCOUNT" class="<?= $Page->LeftColumnClass ?>"><?= $Page->DISCOUNT->caption() ?><?= $Page->DISCOUNT->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->DISCOUNT->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_DISCOUNT">
<input type="<?= $Page->DISCOUNT->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_DISCOUNT" name="x_DISCOUNT" id="x_DISCOUNT" size="30" placeholder="<?= HtmlEncode($Page->DISCOUNT->getPlaceHolder()) ?>" value="<?= $Page->DISCOUNT->EditValue ?>"<?= $Page->DISCOUNT->editAttributes() ?> aria-describedby="x_DISCOUNT_help">
<?= $Page->DISCOUNT->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->DISCOUNT->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->PAY_METHOD_ID->Visible) { // PAY_METHOD_ID ?>
    <div id="r_PAY_METHOD_ID" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_PAY_METHOD_ID" for="x_PAY_METHOD_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->PAY_METHOD_ID->caption() ?><?= $Page->PAY_METHOD_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PAY_METHOD_ID->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_PAY_METHOD_ID">
<input type="<?= $Page->PAY_METHOD_ID->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_PAY_METHOD_ID" name="x_PAY_METHOD_ID" id="x_PAY_METHOD_ID" size="30" placeholder="<?= HtmlEncode($Page->PAY_METHOD_ID->getPlaceHolder()) ?>" value="<?= $Page->PAY_METHOD_ID->EditValue ?>"<?= $Page->PAY_METHOD_ID->editAttributes() ?> aria-describedby="x_PAY_METHOD_ID_help">
<?= $Page->PAY_METHOD_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->PAY_METHOD_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->PAYMENT_DATE->Visible) { // PAYMENT_DATE ?>
    <div id="r_PAYMENT_DATE" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_PAYMENT_DATE" for="x_PAYMENT_DATE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->PAYMENT_DATE->caption() ?><?= $Page->PAYMENT_DATE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PAYMENT_DATE->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_PAYMENT_DATE">
<input type="<?= $Page->PAYMENT_DATE->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_PAYMENT_DATE" name="x_PAYMENT_DATE" id="x_PAYMENT_DATE" placeholder="<?= HtmlEncode($Page->PAYMENT_DATE->getPlaceHolder()) ?>" value="<?= $Page->PAYMENT_DATE->EditValue ?>"<?= $Page->PAYMENT_DATE->editAttributes() ?> aria-describedby="x_PAYMENT_DATE_help">
<?= $Page->PAYMENT_DATE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->PAYMENT_DATE->getErrorMessage() ?></div>
<?php if (!$Page->PAYMENT_DATE->ReadOnly && !$Page->PAYMENT_DATE->Disabled && !isset($Page->PAYMENT_DATE->EditAttrs["readonly"]) && !isset($Page->PAYMENT_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fTREATMENT_BAYARedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fTREATMENT_BAYARedit", "x_PAYMENT_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ISLUNAS->Visible) { // ISLUNAS ?>
    <div id="r_ISLUNAS" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_ISLUNAS" for="x_ISLUNAS" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ISLUNAS->caption() ?><?= $Page->ISLUNAS->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ISLUNAS->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_ISLUNAS">
<input type="<?= $Page->ISLUNAS->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_ISLUNAS" name="x_ISLUNAS" id="x_ISLUNAS" size="30" maxlength="1" placeholder="<?= HtmlEncode($Page->ISLUNAS->getPlaceHolder()) ?>" value="<?= $Page->ISLUNAS->EditValue ?>"<?= $Page->ISLUNAS->editAttributes() ?> aria-describedby="x_ISLUNAS_help">
<?= $Page->ISLUNAS->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ISLUNAS->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->DUEDATE_ANGSURAN->Visible) { // DUEDATE_ANGSURAN ?>
    <div id="r_DUEDATE_ANGSURAN" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_DUEDATE_ANGSURAN" for="x_DUEDATE_ANGSURAN" class="<?= $Page->LeftColumnClass ?>"><?= $Page->DUEDATE_ANGSURAN->caption() ?><?= $Page->DUEDATE_ANGSURAN->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->DUEDATE_ANGSURAN->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_DUEDATE_ANGSURAN">
<input type="<?= $Page->DUEDATE_ANGSURAN->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_DUEDATE_ANGSURAN" name="x_DUEDATE_ANGSURAN" id="x_DUEDATE_ANGSURAN" placeholder="<?= HtmlEncode($Page->DUEDATE_ANGSURAN->getPlaceHolder()) ?>" value="<?= $Page->DUEDATE_ANGSURAN->EditValue ?>"<?= $Page->DUEDATE_ANGSURAN->editAttributes() ?> aria-describedby="x_DUEDATE_ANGSURAN_help">
<?= $Page->DUEDATE_ANGSURAN->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->DUEDATE_ANGSURAN->getErrorMessage() ?></div>
<?php if (!$Page->DUEDATE_ANGSURAN->ReadOnly && !$Page->DUEDATE_ANGSURAN->Disabled && !isset($Page->DUEDATE_ANGSURAN->EditAttrs["readonly"]) && !isset($Page->DUEDATE_ANGSURAN->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fTREATMENT_BAYARedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fTREATMENT_BAYARedit", "x_DUEDATE_ANGSURAN", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->DESCRIPTION->Visible) { // DESCRIPTION ?>
    <div id="r_DESCRIPTION" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_DESCRIPTION" for="x_DESCRIPTION" class="<?= $Page->LeftColumnClass ?>"><?= $Page->DESCRIPTION->caption() ?><?= $Page->DESCRIPTION->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->DESCRIPTION->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_DESCRIPTION">
<input type="<?= $Page->DESCRIPTION->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_DESCRIPTION" name="x_DESCRIPTION" id="x_DESCRIPTION" size="30" maxlength="200" placeholder="<?= HtmlEncode($Page->DESCRIPTION->getPlaceHolder()) ?>" value="<?= $Page->DESCRIPTION->EditValue ?>"<?= $Page->DESCRIPTION->editAttributes() ?> aria-describedby="x_DESCRIPTION_help">
<?= $Page->DESCRIPTION->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->DESCRIPTION->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->KUITANSI_ID->Visible) { // KUITANSI_ID ?>
    <div id="r_KUITANSI_ID" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_KUITANSI_ID" for="x_KUITANSI_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->KUITANSI_ID->caption() ?><?= $Page->KUITANSI_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->KUITANSI_ID->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_KUITANSI_ID">
<input type="<?= $Page->KUITANSI_ID->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_KUITANSI_ID" name="x_KUITANSI_ID" id="x_KUITANSI_ID" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->KUITANSI_ID->getPlaceHolder()) ?>" value="<?= $Page->KUITANSI_ID->EditValue ?>"<?= $Page->KUITANSI_ID->editAttributes() ?> aria-describedby="x_KUITANSI_ID_help">
<?= $Page->KUITANSI_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->KUITANSI_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->NOTA_NO->Visible) { // NOTA_NO ?>
    <div id="r_NOTA_NO" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_NOTA_NO" for="x_NOTA_NO" class="<?= $Page->LeftColumnClass ?>"><?= $Page->NOTA_NO->caption() ?><?= $Page->NOTA_NO->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->NOTA_NO->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_NOTA_NO">
<input type="<?= $Page->NOTA_NO->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_NOTA_NO" name="x_NOTA_NO" id="x_NOTA_NO" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->NOTA_NO->getPlaceHolder()) ?>" value="<?= $Page->NOTA_NO->EditValue ?>"<?= $Page->NOTA_NO->editAttributes() ?> aria-describedby="x_NOTA_NO_help">
<?= $Page->NOTA_NO->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->NOTA_NO->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ISCETAK->Visible) { // ISCETAK ?>
    <div id="r_ISCETAK" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_ISCETAK" for="x_ISCETAK" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ISCETAK->caption() ?><?= $Page->ISCETAK->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ISCETAK->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_ISCETAK">
<input type="<?= $Page->ISCETAK->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_ISCETAK" name="x_ISCETAK" id="x_ISCETAK" size="30" maxlength="1" placeholder="<?= HtmlEncode($Page->ISCETAK->getPlaceHolder()) ?>" value="<?= $Page->ISCETAK->EditValue ?>"<?= $Page->ISCETAK->editAttributes() ?> aria-describedby="x_ISCETAK_help">
<?= $Page->ISCETAK->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ISCETAK->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->PRINT_DATE->Visible) { // PRINT_DATE ?>
    <div id="r_PRINT_DATE" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_PRINT_DATE" for="x_PRINT_DATE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->PRINT_DATE->caption() ?><?= $Page->PRINT_DATE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PRINT_DATE->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_PRINT_DATE">
<input type="<?= $Page->PRINT_DATE->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_PRINT_DATE" name="x_PRINT_DATE" id="x_PRINT_DATE" placeholder="<?= HtmlEncode($Page->PRINT_DATE->getPlaceHolder()) ?>" value="<?= $Page->PRINT_DATE->EditValue ?>"<?= $Page->PRINT_DATE->editAttributes() ?> aria-describedby="x_PRINT_DATE_help">
<?= $Page->PRINT_DATE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->PRINT_DATE->getErrorMessage() ?></div>
<?php if (!$Page->PRINT_DATE->ReadOnly && !$Page->PRINT_DATE->Disabled && !isset($Page->PRINT_DATE->EditAttrs["readonly"]) && !isset($Page->PRINT_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fTREATMENT_BAYARedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fTREATMENT_BAYARedit", "x_PRINT_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->RESEP_NO->Visible) { // RESEP_NO ?>
    <div id="r_RESEP_NO" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_RESEP_NO" for="x_RESEP_NO" class="<?= $Page->LeftColumnClass ?>"><?= $Page->RESEP_NO->caption() ?><?= $Page->RESEP_NO->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->RESEP_NO->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_RESEP_NO">
<input type="<?= $Page->RESEP_NO->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_RESEP_NO" name="x_RESEP_NO" id="x_RESEP_NO" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->RESEP_NO->getPlaceHolder()) ?>" value="<?= $Page->RESEP_NO->EditValue ?>"<?= $Page->RESEP_NO->editAttributes() ?> aria-describedby="x_RESEP_NO_help">
<?= $Page->RESEP_NO->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->RESEP_NO->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->RESEP_KE->Visible) { // RESEP_KE ?>
    <div id="r_RESEP_KE" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_RESEP_KE" for="x_RESEP_KE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->RESEP_KE->caption() ?><?= $Page->RESEP_KE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->RESEP_KE->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_RESEP_KE">
<input type="<?= $Page->RESEP_KE->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_RESEP_KE" name="x_RESEP_KE" id="x_RESEP_KE" size="30" placeholder="<?= HtmlEncode($Page->RESEP_KE->getPlaceHolder()) ?>" value="<?= $Page->RESEP_KE->EditValue ?>"<?= $Page->RESEP_KE->editAttributes() ?> aria-describedby="x_RESEP_KE_help">
<?= $Page->RESEP_KE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->RESEP_KE->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->DOSE->Visible) { // DOSE ?>
    <div id="r_DOSE" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_DOSE" for="x_DOSE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->DOSE->caption() ?><?= $Page->DOSE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->DOSE->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_DOSE">
<input type="<?= $Page->DOSE->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_DOSE" name="x_DOSE" id="x_DOSE" size="30" placeholder="<?= HtmlEncode($Page->DOSE->getPlaceHolder()) ?>" value="<?= $Page->DOSE->EditValue ?>"<?= $Page->DOSE->editAttributes() ?> aria-describedby="x_DOSE_help">
<?= $Page->DOSE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->DOSE->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ORIG_DOSE->Visible) { // ORIG_DOSE ?>
    <div id="r_ORIG_DOSE" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_ORIG_DOSE" for="x_ORIG_DOSE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ORIG_DOSE->caption() ?><?= $Page->ORIG_DOSE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ORIG_DOSE->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_ORIG_DOSE">
<input type="<?= $Page->ORIG_DOSE->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_ORIG_DOSE" name="x_ORIG_DOSE" id="x_ORIG_DOSE" size="30" placeholder="<?= HtmlEncode($Page->ORIG_DOSE->getPlaceHolder()) ?>" value="<?= $Page->ORIG_DOSE->EditValue ?>"<?= $Page->ORIG_DOSE->editAttributes() ?> aria-describedby="x_ORIG_DOSE_help">
<?= $Page->ORIG_DOSE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ORIG_DOSE->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->DOSE_PRESC->Visible) { // DOSE_PRESC ?>
    <div id="r_DOSE_PRESC" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_DOSE_PRESC" for="x_DOSE_PRESC" class="<?= $Page->LeftColumnClass ?>"><?= $Page->DOSE_PRESC->caption() ?><?= $Page->DOSE_PRESC->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->DOSE_PRESC->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_DOSE_PRESC">
<input type="<?= $Page->DOSE_PRESC->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_DOSE_PRESC" name="x_DOSE_PRESC" id="x_DOSE_PRESC" size="30" placeholder="<?= HtmlEncode($Page->DOSE_PRESC->getPlaceHolder()) ?>" value="<?= $Page->DOSE_PRESC->EditValue ?>"<?= $Page->DOSE_PRESC->editAttributes() ?> aria-describedby="x_DOSE_PRESC_help">
<?= $Page->DOSE_PRESC->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->DOSE_PRESC->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ITER->Visible) { // ITER ?>
    <div id="r_ITER" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_ITER" for="x_ITER" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ITER->caption() ?><?= $Page->ITER->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ITER->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_ITER">
<input type="<?= $Page->ITER->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_ITER" name="x_ITER" id="x_ITER" size="30" placeholder="<?= HtmlEncode($Page->ITER->getPlaceHolder()) ?>" value="<?= $Page->ITER->EditValue ?>"<?= $Page->ITER->editAttributes() ?> aria-describedby="x_ITER_help">
<?= $Page->ITER->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ITER->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ITER_KE->Visible) { // ITER_KE ?>
    <div id="r_ITER_KE" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_ITER_KE" for="x_ITER_KE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ITER_KE->caption() ?><?= $Page->ITER_KE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ITER_KE->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_ITER_KE">
<input type="<?= $Page->ITER_KE->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_ITER_KE" name="x_ITER_KE" id="x_ITER_KE" size="30" placeholder="<?= HtmlEncode($Page->ITER_KE->getPlaceHolder()) ?>" value="<?= $Page->ITER_KE->EditValue ?>"<?= $Page->ITER_KE->editAttributes() ?> aria-describedby="x_ITER_KE_help">
<?= $Page->ITER_KE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ITER_KE->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->SOLD_STATUS->Visible) { // SOLD_STATUS ?>
    <div id="r_SOLD_STATUS" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_SOLD_STATUS" for="x_SOLD_STATUS" class="<?= $Page->LeftColumnClass ?>"><?= $Page->SOLD_STATUS->caption() ?><?= $Page->SOLD_STATUS->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->SOLD_STATUS->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_SOLD_STATUS">
<input type="<?= $Page->SOLD_STATUS->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_SOLD_STATUS" name="x_SOLD_STATUS" id="x_SOLD_STATUS" size="30" placeholder="<?= HtmlEncode($Page->SOLD_STATUS->getPlaceHolder()) ?>" value="<?= $Page->SOLD_STATUS->EditValue ?>"<?= $Page->SOLD_STATUS->editAttributes() ?> aria-describedby="x_SOLD_STATUS_help">
<?= $Page->SOLD_STATUS->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->SOLD_STATUS->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->RACIKAN->Visible) { // RACIKAN ?>
    <div id="r_RACIKAN" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_RACIKAN" for="x_RACIKAN" class="<?= $Page->LeftColumnClass ?>"><?= $Page->RACIKAN->caption() ?><?= $Page->RACIKAN->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->RACIKAN->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_RACIKAN">
<input type="<?= $Page->RACIKAN->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_RACIKAN" name="x_RACIKAN" id="x_RACIKAN" size="30" placeholder="<?= HtmlEncode($Page->RACIKAN->getPlaceHolder()) ?>" value="<?= $Page->RACIKAN->EditValue ?>"<?= $Page->RACIKAN->editAttributes() ?> aria-describedby="x_RACIKAN_help">
<?= $Page->RACIKAN->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->RACIKAN->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->CLASS_ROOM_ID->Visible) { // CLASS_ROOM_ID ?>
    <div id="r_CLASS_ROOM_ID" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_CLASS_ROOM_ID" for="x_CLASS_ROOM_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->CLASS_ROOM_ID->caption() ?><?= $Page->CLASS_ROOM_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->CLASS_ROOM_ID->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_CLASS_ROOM_ID">
<input type="<?= $Page->CLASS_ROOM_ID->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_CLASS_ROOM_ID" name="x_CLASS_ROOM_ID" id="x_CLASS_ROOM_ID" size="30" maxlength="16" placeholder="<?= HtmlEncode($Page->CLASS_ROOM_ID->getPlaceHolder()) ?>" value="<?= $Page->CLASS_ROOM_ID->EditValue ?>"<?= $Page->CLASS_ROOM_ID->editAttributes() ?> aria-describedby="x_CLASS_ROOM_ID_help">
<?= $Page->CLASS_ROOM_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->CLASS_ROOM_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->KELUAR_ID->Visible) { // KELUAR_ID ?>
    <div id="r_KELUAR_ID" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_KELUAR_ID" for="x_KELUAR_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->KELUAR_ID->caption() ?><?= $Page->KELUAR_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->KELUAR_ID->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_KELUAR_ID">
<input type="<?= $Page->KELUAR_ID->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_KELUAR_ID" name="x_KELUAR_ID" id="x_KELUAR_ID" size="30" placeholder="<?= HtmlEncode($Page->KELUAR_ID->getPlaceHolder()) ?>" value="<?= $Page->KELUAR_ID->EditValue ?>"<?= $Page->KELUAR_ID->editAttributes() ?> aria-describedby="x_KELUAR_ID_help">
<?= $Page->KELUAR_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->KELUAR_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->BED_ID->Visible) { // BED_ID ?>
    <div id="r_BED_ID" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_BED_ID" for="x_BED_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->BED_ID->caption() ?><?= $Page->BED_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->BED_ID->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_BED_ID">
<input type="<?= $Page->BED_ID->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_BED_ID" name="x_BED_ID" id="x_BED_ID" size="30" placeholder="<?= HtmlEncode($Page->BED_ID->getPlaceHolder()) ?>" value="<?= $Page->BED_ID->EditValue ?>"<?= $Page->BED_ID->editAttributes() ?> aria-describedby="x_BED_ID_help">
<?= $Page->BED_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->BED_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->PERDA_ID->Visible) { // PERDA_ID ?>
    <div id="r_PERDA_ID" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_PERDA_ID" for="x_PERDA_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->PERDA_ID->caption() ?><?= $Page->PERDA_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PERDA_ID->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_PERDA_ID">
<input type="<?= $Page->PERDA_ID->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_PERDA_ID" name="x_PERDA_ID" id="x_PERDA_ID" size="30" placeholder="<?= HtmlEncode($Page->PERDA_ID->getPlaceHolder()) ?>" value="<?= $Page->PERDA_ID->EditValue ?>"<?= $Page->PERDA_ID->editAttributes() ?> aria-describedby="x_PERDA_ID_help">
<?= $Page->PERDA_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->PERDA_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->EMPLOYEE_ID->Visible) { // EMPLOYEE_ID ?>
    <div id="r_EMPLOYEE_ID" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_EMPLOYEE_ID" for="x_EMPLOYEE_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->EMPLOYEE_ID->caption() ?><?= $Page->EMPLOYEE_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->EMPLOYEE_ID->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_EMPLOYEE_ID">
<input type="<?= $Page->EMPLOYEE_ID->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_EMPLOYEE_ID" name="x_EMPLOYEE_ID" id="x_EMPLOYEE_ID" size="30" maxlength="15" placeholder="<?= HtmlEncode($Page->EMPLOYEE_ID->getPlaceHolder()) ?>" value="<?= $Page->EMPLOYEE_ID->EditValue ?>"<?= $Page->EMPLOYEE_ID->editAttributes() ?> aria-describedby="x_EMPLOYEE_ID_help">
<?= $Page->EMPLOYEE_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->EMPLOYEE_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->DESCRIPTION2->Visible) { // DESCRIPTION2 ?>
    <div id="r_DESCRIPTION2" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_DESCRIPTION2" for="x_DESCRIPTION2" class="<?= $Page->LeftColumnClass ?>"><?= $Page->DESCRIPTION2->caption() ?><?= $Page->DESCRIPTION2->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->DESCRIPTION2->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_DESCRIPTION2">
<input type="<?= $Page->DESCRIPTION2->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_DESCRIPTION2" name="x_DESCRIPTION2" id="x_DESCRIPTION2" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->DESCRIPTION2->getPlaceHolder()) ?>" value="<?= $Page->DESCRIPTION2->EditValue ?>"<?= $Page->DESCRIPTION2->editAttributes() ?> aria-describedby="x_DESCRIPTION2_help">
<?= $Page->DESCRIPTION2->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->DESCRIPTION2->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
    <div id="r_MODIFIED_BY" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_MODIFIED_BY" for="x_MODIFIED_BY" class="<?= $Page->LeftColumnClass ?>"><?= $Page->MODIFIED_BY->caption() ?><?= $Page->MODIFIED_BY->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->MODIFIED_BY->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_MODIFIED_BY">
<input type="<?= $Page->MODIFIED_BY->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_MODIFIED_BY" name="x_MODIFIED_BY" id="x_MODIFIED_BY" size="30" maxlength="200" placeholder="<?= HtmlEncode($Page->MODIFIED_BY->getPlaceHolder()) ?>" value="<?= $Page->MODIFIED_BY->EditValue ?>"<?= $Page->MODIFIED_BY->editAttributes() ?> aria-describedby="x_MODIFIED_BY_help">
<?= $Page->MODIFIED_BY->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->MODIFIED_BY->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
    <div id="r_MODIFIED_DATE" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_MODIFIED_DATE" for="x_MODIFIED_DATE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->MODIFIED_DATE->caption() ?><?= $Page->MODIFIED_DATE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->MODIFIED_DATE->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_MODIFIED_DATE">
<input type="<?= $Page->MODIFIED_DATE->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_MODIFIED_DATE" name="x_MODIFIED_DATE" id="x_MODIFIED_DATE" placeholder="<?= HtmlEncode($Page->MODIFIED_DATE->getPlaceHolder()) ?>" value="<?= $Page->MODIFIED_DATE->EditValue ?>"<?= $Page->MODIFIED_DATE->editAttributes() ?> aria-describedby="x_MODIFIED_DATE_help">
<?= $Page->MODIFIED_DATE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->MODIFIED_DATE->getErrorMessage() ?></div>
<?php if (!$Page->MODIFIED_DATE->ReadOnly && !$Page->MODIFIED_DATE->Disabled && !isset($Page->MODIFIED_DATE->EditAttrs["readonly"]) && !isset($Page->MODIFIED_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fTREATMENT_BAYARedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fTREATMENT_BAYARedit", "x_MODIFIED_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->MODIFIED_FROM->Visible) { // MODIFIED_FROM ?>
    <div id="r_MODIFIED_FROM" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_MODIFIED_FROM" for="x_MODIFIED_FROM" class="<?= $Page->LeftColumnClass ?>"><?= $Page->MODIFIED_FROM->caption() ?><?= $Page->MODIFIED_FROM->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->MODIFIED_FROM->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_MODIFIED_FROM">
<input type="<?= $Page->MODIFIED_FROM->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_MODIFIED_FROM" name="x_MODIFIED_FROM" id="x_MODIFIED_FROM" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->MODIFIED_FROM->getPlaceHolder()) ?>" value="<?= $Page->MODIFIED_FROM->EditValue ?>"<?= $Page->MODIFIED_FROM->editAttributes() ?> aria-describedby="x_MODIFIED_FROM_help">
<?= $Page->MODIFIED_FROM->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->MODIFIED_FROM->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->BRAND_ID->Visible) { // BRAND_ID ?>
    <div id="r_BRAND_ID" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_BRAND_ID" for="x_BRAND_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->BRAND_ID->caption() ?><?= $Page->BRAND_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->BRAND_ID->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_BRAND_ID">
<input type="<?= $Page->BRAND_ID->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_BRAND_ID" name="x_BRAND_ID" id="x_BRAND_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->BRAND_ID->getPlaceHolder()) ?>" value="<?= $Page->BRAND_ID->EditValue ?>"<?= $Page->BRAND_ID->editAttributes() ?> aria-describedby="x_BRAND_ID_help">
<?= $Page->BRAND_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->BRAND_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->DOCTOR->Visible) { // DOCTOR ?>
    <div id="r_DOCTOR" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_DOCTOR" for="x_DOCTOR" class="<?= $Page->LeftColumnClass ?>"><?= $Page->DOCTOR->caption() ?><?= $Page->DOCTOR->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->DOCTOR->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_DOCTOR">
<input type="<?= $Page->DOCTOR->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_DOCTOR" name="x_DOCTOR" id="x_DOCTOR" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->DOCTOR->getPlaceHolder()) ?>" value="<?= $Page->DOCTOR->EditValue ?>"<?= $Page->DOCTOR->editAttributes() ?> aria-describedby="x_DOCTOR_help">
<?= $Page->DOCTOR->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->DOCTOR->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->JML_BKS->Visible) { // JML_BKS ?>
    <div id="r_JML_BKS" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_JML_BKS" for="x_JML_BKS" class="<?= $Page->LeftColumnClass ?>"><?= $Page->JML_BKS->caption() ?><?= $Page->JML_BKS->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->JML_BKS->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_JML_BKS">
<input type="<?= $Page->JML_BKS->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_JML_BKS" name="x_JML_BKS" id="x_JML_BKS" size="30" placeholder="<?= HtmlEncode($Page->JML_BKS->getPlaceHolder()) ?>" value="<?= $Page->JML_BKS->EditValue ?>"<?= $Page->JML_BKS->editAttributes() ?> aria-describedby="x_JML_BKS_help">
<?= $Page->JML_BKS->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->JML_BKS->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->EXIT_DATE->Visible) { // EXIT_DATE ?>
    <div id="r_EXIT_DATE" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_EXIT_DATE" for="x_EXIT_DATE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->EXIT_DATE->caption() ?><?= $Page->EXIT_DATE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->EXIT_DATE->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_EXIT_DATE">
<input type="<?= $Page->EXIT_DATE->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_EXIT_DATE" name="x_EXIT_DATE" id="x_EXIT_DATE" placeholder="<?= HtmlEncode($Page->EXIT_DATE->getPlaceHolder()) ?>" value="<?= $Page->EXIT_DATE->EditValue ?>"<?= $Page->EXIT_DATE->editAttributes() ?> aria-describedby="x_EXIT_DATE_help">
<?= $Page->EXIT_DATE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->EXIT_DATE->getErrorMessage() ?></div>
<?php if (!$Page->EXIT_DATE->ReadOnly && !$Page->EXIT_DATE->Disabled && !isset($Page->EXIT_DATE->EditAttrs["readonly"]) && !isset($Page->EXIT_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fTREATMENT_BAYARedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fTREATMENT_BAYARedit", "x_EXIT_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->FA_V->Visible) { // FA_V ?>
    <div id="r_FA_V" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_FA_V" for="x_FA_V" class="<?= $Page->LeftColumnClass ?>"><?= $Page->FA_V->caption() ?><?= $Page->FA_V->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->FA_V->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_FA_V">
<input type="<?= $Page->FA_V->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_FA_V" name="x_FA_V" id="x_FA_V" size="30" placeholder="<?= HtmlEncode($Page->FA_V->getPlaceHolder()) ?>" value="<?= $Page->FA_V->EditValue ?>"<?= $Page->FA_V->editAttributes() ?> aria-describedby="x_FA_V_help">
<?= $Page->FA_V->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->FA_V->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->TASK_ID->Visible) { // TASK_ID ?>
    <div id="r_TASK_ID" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_TASK_ID" for="x_TASK_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->TASK_ID->caption() ?><?= $Page->TASK_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->TASK_ID->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_TASK_ID">
<input type="<?= $Page->TASK_ID->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_TASK_ID" name="x_TASK_ID" id="x_TASK_ID" size="30" placeholder="<?= HtmlEncode($Page->TASK_ID->getPlaceHolder()) ?>" value="<?= $Page->TASK_ID->EditValue ?>"<?= $Page->TASK_ID->editAttributes() ?> aria-describedby="x_TASK_ID_help">
<?= $Page->TASK_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->TASK_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->EMPLOYEE_ID_FROM->Visible) { // EMPLOYEE_ID_FROM ?>
    <div id="r_EMPLOYEE_ID_FROM" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_EMPLOYEE_ID_FROM" for="x_EMPLOYEE_ID_FROM" class="<?= $Page->LeftColumnClass ?>"><?= $Page->EMPLOYEE_ID_FROM->caption() ?><?= $Page->EMPLOYEE_ID_FROM->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->EMPLOYEE_ID_FROM->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_EMPLOYEE_ID_FROM">
<input type="<?= $Page->EMPLOYEE_ID_FROM->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_EMPLOYEE_ID_FROM" name="x_EMPLOYEE_ID_FROM" id="x_EMPLOYEE_ID_FROM" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->EMPLOYEE_ID_FROM->getPlaceHolder()) ?>" value="<?= $Page->EMPLOYEE_ID_FROM->EditValue ?>"<?= $Page->EMPLOYEE_ID_FROM->editAttributes() ?> aria-describedby="x_EMPLOYEE_ID_FROM_help">
<?= $Page->EMPLOYEE_ID_FROM->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->EMPLOYEE_ID_FROM->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->DOCTOR_FROM->Visible) { // DOCTOR_FROM ?>
    <div id="r_DOCTOR_FROM" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_DOCTOR_FROM" for="x_DOCTOR_FROM" class="<?= $Page->LeftColumnClass ?>"><?= $Page->DOCTOR_FROM->caption() ?><?= $Page->DOCTOR_FROM->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->DOCTOR_FROM->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_DOCTOR_FROM">
<input type="<?= $Page->DOCTOR_FROM->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_DOCTOR_FROM" name="x_DOCTOR_FROM" id="x_DOCTOR_FROM" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->DOCTOR_FROM->getPlaceHolder()) ?>" value="<?= $Page->DOCTOR_FROM->EditValue ?>"<?= $Page->DOCTOR_FROM->editAttributes() ?> aria-describedby="x_DOCTOR_FROM_help">
<?= $Page->DOCTOR_FROM->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->DOCTOR_FROM->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->status_pasien_id->Visible) { // status_pasien_id ?>
    <div id="r_status_pasien_id" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_status_pasien_id" for="x_status_pasien_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->status_pasien_id->caption() ?><?= $Page->status_pasien_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->status_pasien_id->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_status_pasien_id">
<input type="<?= $Page->status_pasien_id->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_status_pasien_id" name="x_status_pasien_id" id="x_status_pasien_id" size="30" placeholder="<?= HtmlEncode($Page->status_pasien_id->getPlaceHolder()) ?>" value="<?= $Page->status_pasien_id->EditValue ?>"<?= $Page->status_pasien_id->editAttributes() ?> aria-describedby="x_status_pasien_id_help">
<?= $Page->status_pasien_id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->status_pasien_id->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->amount_paid->Visible) { // amount_paid ?>
    <div id="r_amount_paid" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_amount_paid" for="x_amount_paid" class="<?= $Page->LeftColumnClass ?>"><?= $Page->amount_paid->caption() ?><?= $Page->amount_paid->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->amount_paid->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_amount_paid">
<input type="<?= $Page->amount_paid->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_amount_paid" name="x_amount_paid" id="x_amount_paid" size="30" placeholder="<?= HtmlEncode($Page->amount_paid->getPlaceHolder()) ?>" value="<?= $Page->amount_paid->EditValue ?>"<?= $Page->amount_paid->editAttributes() ?> aria-describedby="x_amount_paid_help">
<?= $Page->amount_paid->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->amount_paid->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->THENAME->Visible) { // THENAME ?>
    <div id="r_THENAME" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_THENAME" for="x_THENAME" class="<?= $Page->LeftColumnClass ?>"><?= $Page->THENAME->caption() ?><?= $Page->THENAME->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->THENAME->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_THENAME">
<input type="<?= $Page->THENAME->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_THENAME" name="x_THENAME" id="x_THENAME" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->THENAME->getPlaceHolder()) ?>" value="<?= $Page->THENAME->EditValue ?>"<?= $Page->THENAME->editAttributes() ?> aria-describedby="x_THENAME_help">
<?= $Page->THENAME->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->THENAME->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->THEADDRESS->Visible) { // THEADDRESS ?>
    <div id="r_THEADDRESS" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_THEADDRESS" for="x_THEADDRESS" class="<?= $Page->LeftColumnClass ?>"><?= $Page->THEADDRESS->caption() ?><?= $Page->THEADDRESS->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->THEADDRESS->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_THEADDRESS">
<input type="<?= $Page->THEADDRESS->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_THEADDRESS" name="x_THEADDRESS" id="x_THEADDRESS" size="30" maxlength="150" placeholder="<?= HtmlEncode($Page->THEADDRESS->getPlaceHolder()) ?>" value="<?= $Page->THEADDRESS->EditValue ?>"<?= $Page->THEADDRESS->editAttributes() ?> aria-describedby="x_THEADDRESS_help">
<?= $Page->THEADDRESS->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->THEADDRESS->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->THEID->Visible) { // THEID ?>
    <div id="r_THEID" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_THEID" for="x_THEID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->THEID->caption() ?><?= $Page->THEID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->THEID->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_THEID">
<input type="<?= $Page->THEID->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_THEID" name="x_THEID" id="x_THEID" size="30" maxlength="25" placeholder="<?= HtmlEncode($Page->THEID->getPlaceHolder()) ?>" value="<?= $Page->THEID->EditValue ?>"<?= $Page->THEID->editAttributes() ?> aria-describedby="x_THEID_help">
<?= $Page->THEID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->THEID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->serial_nb->Visible) { // serial_nb ?>
    <div id="r_serial_nb" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_serial_nb" for="x_serial_nb" class="<?= $Page->LeftColumnClass ?>"><?= $Page->serial_nb->caption() ?><?= $Page->serial_nb->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->serial_nb->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_serial_nb">
<input type="<?= $Page->serial_nb->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_serial_nb" name="x_serial_nb" id="x_serial_nb" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->serial_nb->getPlaceHolder()) ?>" value="<?= $Page->serial_nb->EditValue ?>"<?= $Page->serial_nb->editAttributes() ?> aria-describedby="x_serial_nb_help">
<?= $Page->serial_nb->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->serial_nb->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->TREATMENT_PLAFOND->Visible) { // TREATMENT_PLAFOND ?>
    <div id="r_TREATMENT_PLAFOND" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_TREATMENT_PLAFOND" for="x_TREATMENT_PLAFOND" class="<?= $Page->LeftColumnClass ?>"><?= $Page->TREATMENT_PLAFOND->caption() ?><?= $Page->TREATMENT_PLAFOND->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->TREATMENT_PLAFOND->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_TREATMENT_PLAFOND">
<input type="<?= $Page->TREATMENT_PLAFOND->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_TREATMENT_PLAFOND" name="x_TREATMENT_PLAFOND" id="x_TREATMENT_PLAFOND" size="30" maxlength="150" placeholder="<?= HtmlEncode($Page->TREATMENT_PLAFOND->getPlaceHolder()) ?>" value="<?= $Page->TREATMENT_PLAFOND->EditValue ?>"<?= $Page->TREATMENT_PLAFOND->editAttributes() ?> aria-describedby="x_TREATMENT_PLAFOND_help">
<?= $Page->TREATMENT_PLAFOND->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->TREATMENT_PLAFOND->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->AMOUNT_PLAFOND->Visible) { // AMOUNT_PLAFOND ?>
    <div id="r_AMOUNT_PLAFOND" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_AMOUNT_PLAFOND" for="x_AMOUNT_PLAFOND" class="<?= $Page->LeftColumnClass ?>"><?= $Page->AMOUNT_PLAFOND->caption() ?><?= $Page->AMOUNT_PLAFOND->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->AMOUNT_PLAFOND->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_AMOUNT_PLAFOND">
<input type="<?= $Page->AMOUNT_PLAFOND->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_AMOUNT_PLAFOND" name="x_AMOUNT_PLAFOND" id="x_AMOUNT_PLAFOND" size="30" placeholder="<?= HtmlEncode($Page->AMOUNT_PLAFOND->getPlaceHolder()) ?>" value="<?= $Page->AMOUNT_PLAFOND->EditValue ?>"<?= $Page->AMOUNT_PLAFOND->editAttributes() ?> aria-describedby="x_AMOUNT_PLAFOND_help">
<?= $Page->AMOUNT_PLAFOND->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->AMOUNT_PLAFOND->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->AMOUNT_PAID_PLAFOND->Visible) { // AMOUNT_PAID_PLAFOND ?>
    <div id="r_AMOUNT_PAID_PLAFOND" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_AMOUNT_PAID_PLAFOND" for="x_AMOUNT_PAID_PLAFOND" class="<?= $Page->LeftColumnClass ?>"><?= $Page->AMOUNT_PAID_PLAFOND->caption() ?><?= $Page->AMOUNT_PAID_PLAFOND->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->AMOUNT_PAID_PLAFOND->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_AMOUNT_PAID_PLAFOND">
<input type="<?= $Page->AMOUNT_PAID_PLAFOND->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_AMOUNT_PAID_PLAFOND" name="x_AMOUNT_PAID_PLAFOND" id="x_AMOUNT_PAID_PLAFOND" size="30" placeholder="<?= HtmlEncode($Page->AMOUNT_PAID_PLAFOND->getPlaceHolder()) ?>" value="<?= $Page->AMOUNT_PAID_PLAFOND->EditValue ?>"<?= $Page->AMOUNT_PAID_PLAFOND->editAttributes() ?> aria-describedby="x_AMOUNT_PAID_PLAFOND_help">
<?= $Page->AMOUNT_PAID_PLAFOND->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->AMOUNT_PAID_PLAFOND->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->CLASS_ID_PLAFOND->Visible) { // CLASS_ID_PLAFOND ?>
    <div id="r_CLASS_ID_PLAFOND" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_CLASS_ID_PLAFOND" for="x_CLASS_ID_PLAFOND" class="<?= $Page->LeftColumnClass ?>"><?= $Page->CLASS_ID_PLAFOND->caption() ?><?= $Page->CLASS_ID_PLAFOND->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->CLASS_ID_PLAFOND->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_CLASS_ID_PLAFOND">
<input type="<?= $Page->CLASS_ID_PLAFOND->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_CLASS_ID_PLAFOND" name="x_CLASS_ID_PLAFOND" id="x_CLASS_ID_PLAFOND" size="30" placeholder="<?= HtmlEncode($Page->CLASS_ID_PLAFOND->getPlaceHolder()) ?>" value="<?= $Page->CLASS_ID_PLAFOND->EditValue ?>"<?= $Page->CLASS_ID_PLAFOND->editAttributes() ?> aria-describedby="x_CLASS_ID_PLAFOND_help">
<?= $Page->CLASS_ID_PLAFOND->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->CLASS_ID_PLAFOND->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->PAYOR_ID->Visible) { // PAYOR_ID ?>
    <div id="r_PAYOR_ID" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_PAYOR_ID" for="x_PAYOR_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->PAYOR_ID->caption() ?><?= $Page->PAYOR_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PAYOR_ID->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_PAYOR_ID">
<input type="<?= $Page->PAYOR_ID->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_PAYOR_ID" name="x_PAYOR_ID" id="x_PAYOR_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->PAYOR_ID->getPlaceHolder()) ?>" value="<?= $Page->PAYOR_ID->EditValue ?>"<?= $Page->PAYOR_ID->editAttributes() ?> aria-describedby="x_PAYOR_ID_help">
<?= $Page->PAYOR_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->PAYOR_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->PEMBULATAN->Visible) { // PEMBULATAN ?>
    <div id="r_PEMBULATAN" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_PEMBULATAN" for="x_PEMBULATAN" class="<?= $Page->LeftColumnClass ?>"><?= $Page->PEMBULATAN->caption() ?><?= $Page->PEMBULATAN->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PEMBULATAN->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_PEMBULATAN">
<input type="<?= $Page->PEMBULATAN->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_PEMBULATAN" name="x_PEMBULATAN" id="x_PEMBULATAN" size="30" placeholder="<?= HtmlEncode($Page->PEMBULATAN->getPlaceHolder()) ?>" value="<?= $Page->PEMBULATAN->EditValue ?>"<?= $Page->PEMBULATAN->editAttributes() ?> aria-describedby="x_PEMBULATAN_help">
<?= $Page->PEMBULATAN->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->PEMBULATAN->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ISRJ->Visible) { // ISRJ ?>
    <div id="r_ISRJ" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_ISRJ" for="x_ISRJ" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ISRJ->caption() ?><?= $Page->ISRJ->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ISRJ->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_ISRJ">
<input type="<?= $Page->ISRJ->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_ISRJ" name="x_ISRJ" id="x_ISRJ" size="30" maxlength="1" placeholder="<?= HtmlEncode($Page->ISRJ->getPlaceHolder()) ?>" value="<?= $Page->ISRJ->EditValue ?>"<?= $Page->ISRJ->editAttributes() ?> aria-describedby="x_ISRJ_help">
<?= $Page->ISRJ->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ISRJ->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->AGEYEAR->Visible) { // AGEYEAR ?>
    <div id="r_AGEYEAR" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_AGEYEAR" for="x_AGEYEAR" class="<?= $Page->LeftColumnClass ?>"><?= $Page->AGEYEAR->caption() ?><?= $Page->AGEYEAR->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->AGEYEAR->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_AGEYEAR">
<input type="<?= $Page->AGEYEAR->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_AGEYEAR" name="x_AGEYEAR" id="x_AGEYEAR" size="30" placeholder="<?= HtmlEncode($Page->AGEYEAR->getPlaceHolder()) ?>" value="<?= $Page->AGEYEAR->EditValue ?>"<?= $Page->AGEYEAR->editAttributes() ?> aria-describedby="x_AGEYEAR_help">
<?= $Page->AGEYEAR->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->AGEYEAR->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->AGEMONTH->Visible) { // AGEMONTH ?>
    <div id="r_AGEMONTH" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_AGEMONTH" for="x_AGEMONTH" class="<?= $Page->LeftColumnClass ?>"><?= $Page->AGEMONTH->caption() ?><?= $Page->AGEMONTH->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->AGEMONTH->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_AGEMONTH">
<input type="<?= $Page->AGEMONTH->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_AGEMONTH" name="x_AGEMONTH" id="x_AGEMONTH" size="30" placeholder="<?= HtmlEncode($Page->AGEMONTH->getPlaceHolder()) ?>" value="<?= $Page->AGEMONTH->EditValue ?>"<?= $Page->AGEMONTH->editAttributes() ?> aria-describedby="x_AGEMONTH_help">
<?= $Page->AGEMONTH->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->AGEMONTH->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->AGEDAY->Visible) { // AGEDAY ?>
    <div id="r_AGEDAY" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_AGEDAY" for="x_AGEDAY" class="<?= $Page->LeftColumnClass ?>"><?= $Page->AGEDAY->caption() ?><?= $Page->AGEDAY->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->AGEDAY->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_AGEDAY">
<input type="<?= $Page->AGEDAY->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_AGEDAY" name="x_AGEDAY" id="x_AGEDAY" size="30" placeholder="<?= HtmlEncode($Page->AGEDAY->getPlaceHolder()) ?>" value="<?= $Page->AGEDAY->EditValue ?>"<?= $Page->AGEDAY->editAttributes() ?> aria-describedby="x_AGEDAY_help">
<?= $Page->AGEDAY->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->AGEDAY->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->GENDER->Visible) { // GENDER ?>
    <div id="r_GENDER" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_GENDER" for="x_GENDER" class="<?= $Page->LeftColumnClass ?>"><?= $Page->GENDER->caption() ?><?= $Page->GENDER->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->GENDER->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_GENDER">
<input type="<?= $Page->GENDER->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_GENDER" name="x_GENDER" id="x_GENDER" size="30" maxlength="1" placeholder="<?= HtmlEncode($Page->GENDER->getPlaceHolder()) ?>" value="<?= $Page->GENDER->EditValue ?>"<?= $Page->GENDER->editAttributes() ?> aria-describedby="x_GENDER_help">
<?= $Page->GENDER->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->GENDER->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->KAL_ID->Visible) { // KAL_ID ?>
    <div id="r_KAL_ID" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_KAL_ID" for="x_KAL_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->KAL_ID->caption() ?><?= $Page->KAL_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->KAL_ID->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_KAL_ID">
<input type="<?= $Page->KAL_ID->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_KAL_ID" name="x_KAL_ID" id="x_KAL_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->KAL_ID->getPlaceHolder()) ?>" value="<?= $Page->KAL_ID->EditValue ?>"<?= $Page->KAL_ID->editAttributes() ?> aria-describedby="x_KAL_ID_help">
<?= $Page->KAL_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->KAL_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->CORRECTION_ID->Visible) { // CORRECTION_ID ?>
    <div id="r_CORRECTION_ID" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_CORRECTION_ID" for="x_CORRECTION_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->CORRECTION_ID->caption() ?><?= $Page->CORRECTION_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->CORRECTION_ID->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_CORRECTION_ID">
<input type="<?= $Page->CORRECTION_ID->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_CORRECTION_ID" name="x_CORRECTION_ID" id="x_CORRECTION_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->CORRECTION_ID->getPlaceHolder()) ?>" value="<?= $Page->CORRECTION_ID->EditValue ?>"<?= $Page->CORRECTION_ID->editAttributes() ?> aria-describedby="x_CORRECTION_ID_help">
<?= $Page->CORRECTION_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->CORRECTION_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->CORRECTION_BY->Visible) { // CORRECTION_BY ?>
    <div id="r_CORRECTION_BY" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_CORRECTION_BY" for="x_CORRECTION_BY" class="<?= $Page->LeftColumnClass ?>"><?= $Page->CORRECTION_BY->caption() ?><?= $Page->CORRECTION_BY->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->CORRECTION_BY->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_CORRECTION_BY">
<input type="<?= $Page->CORRECTION_BY->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_CORRECTION_BY" name="x_CORRECTION_BY" id="x_CORRECTION_BY" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->CORRECTION_BY->getPlaceHolder()) ?>" value="<?= $Page->CORRECTION_BY->EditValue ?>"<?= $Page->CORRECTION_BY->editAttributes() ?> aria-describedby="x_CORRECTION_BY_help">
<?= $Page->CORRECTION_BY->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->CORRECTION_BY->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->KARYAWAN->Visible) { // KARYAWAN ?>
    <div id="r_KARYAWAN" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_KARYAWAN" for="x_KARYAWAN" class="<?= $Page->LeftColumnClass ?>"><?= $Page->KARYAWAN->caption() ?><?= $Page->KARYAWAN->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->KARYAWAN->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_KARYAWAN">
<input type="<?= $Page->KARYAWAN->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_KARYAWAN" name="x_KARYAWAN" id="x_KARYAWAN" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->KARYAWAN->getPlaceHolder()) ?>" value="<?= $Page->KARYAWAN->EditValue ?>"<?= $Page->KARYAWAN->editAttributes() ?> aria-describedby="x_KARYAWAN_help">
<?= $Page->KARYAWAN->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->KARYAWAN->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ACCOUNT_ID->Visible) { // ACCOUNT_ID ?>
    <div id="r_ACCOUNT_ID" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_ACCOUNT_ID" for="x_ACCOUNT_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ACCOUNT_ID->caption() ?><?= $Page->ACCOUNT_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ACCOUNT_ID->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_ACCOUNT_ID">
<input type="<?= $Page->ACCOUNT_ID->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_ACCOUNT_ID" name="x_ACCOUNT_ID" id="x_ACCOUNT_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->ACCOUNT_ID->getPlaceHolder()) ?>" value="<?= $Page->ACCOUNT_ID->EditValue ?>"<?= $Page->ACCOUNT_ID->editAttributes() ?> aria-describedby="x_ACCOUNT_ID_help">
<?= $Page->ACCOUNT_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ACCOUNT_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->sell_price->Visible) { // sell_price ?>
    <div id="r_sell_price" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_sell_price" for="x_sell_price" class="<?= $Page->LeftColumnClass ?>"><?= $Page->sell_price->caption() ?><?= $Page->sell_price->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->sell_price->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_sell_price">
<input type="<?= $Page->sell_price->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_sell_price" name="x_sell_price" id="x_sell_price" size="30" placeholder="<?= HtmlEncode($Page->sell_price->getPlaceHolder()) ?>" value="<?= $Page->sell_price->EditValue ?>"<?= $Page->sell_price->editAttributes() ?> aria-describedby="x_sell_price_help">
<?= $Page->sell_price->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->sell_price->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->diskon->Visible) { // diskon ?>
    <div id="r_diskon" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_diskon" for="x_diskon" class="<?= $Page->LeftColumnClass ?>"><?= $Page->diskon->caption() ?><?= $Page->diskon->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->diskon->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_diskon">
<input type="<?= $Page->diskon->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_diskon" name="x_diskon" id="x_diskon" size="30" placeholder="<?= HtmlEncode($Page->diskon->getPlaceHolder()) ?>" value="<?= $Page->diskon->EditValue ?>"<?= $Page->diskon->editAttributes() ?> aria-describedby="x_diskon_help">
<?= $Page->diskon->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->diskon->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->INVOICE_ID->Visible) { // INVOICE_ID ?>
    <div id="r_INVOICE_ID" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_INVOICE_ID" for="x_INVOICE_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->INVOICE_ID->caption() ?><?= $Page->INVOICE_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->INVOICE_ID->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_INVOICE_ID">
<input type="<?= $Page->INVOICE_ID->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_INVOICE_ID" name="x_INVOICE_ID" id="x_INVOICE_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->INVOICE_ID->getPlaceHolder()) ?>" value="<?= $Page->INVOICE_ID->EditValue ?>"<?= $Page->INVOICE_ID->editAttributes() ?> aria-describedby="x_INVOICE_ID_help">
<?= $Page->INVOICE_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->INVOICE_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->NUMER->Visible) { // NUMER ?>
    <div id="r_NUMER" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_NUMER" for="x_NUMER" class="<?= $Page->LeftColumnClass ?>"><?= $Page->NUMER->caption() ?><?= $Page->NUMER->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->NUMER->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_NUMER">
<input type="<?= $Page->NUMER->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_NUMER" name="x_NUMER" id="x_NUMER" size="30" maxlength="15" placeholder="<?= HtmlEncode($Page->NUMER->getPlaceHolder()) ?>" value="<?= $Page->NUMER->EditValue ?>"<?= $Page->NUMER->editAttributes() ?> aria-describedby="x_NUMER_help">
<?= $Page->NUMER->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->NUMER->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->MEASURE_ID2->Visible) { // MEASURE_ID2 ?>
    <div id="r_MEASURE_ID2" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_MEASURE_ID2" for="x_MEASURE_ID2" class="<?= $Page->LeftColumnClass ?>"><?= $Page->MEASURE_ID2->caption() ?><?= $Page->MEASURE_ID2->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->MEASURE_ID2->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_MEASURE_ID2">
<input type="<?= $Page->MEASURE_ID2->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_MEASURE_ID2" name="x_MEASURE_ID2" id="x_MEASURE_ID2" size="30" placeholder="<?= HtmlEncode($Page->MEASURE_ID2->getPlaceHolder()) ?>" value="<?= $Page->MEASURE_ID2->EditValue ?>"<?= $Page->MEASURE_ID2->editAttributes() ?> aria-describedby="x_MEASURE_ID2_help">
<?= $Page->MEASURE_ID2->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->MEASURE_ID2->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->POTONGAN->Visible) { // POTONGAN ?>
    <div id="r_POTONGAN" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_POTONGAN" for="x_POTONGAN" class="<?= $Page->LeftColumnClass ?>"><?= $Page->POTONGAN->caption() ?><?= $Page->POTONGAN->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->POTONGAN->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_POTONGAN">
<input type="<?= $Page->POTONGAN->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_POTONGAN" name="x_POTONGAN" id="x_POTONGAN" size="30" placeholder="<?= HtmlEncode($Page->POTONGAN->getPlaceHolder()) ?>" value="<?= $Page->POTONGAN->EditValue ?>"<?= $Page->POTONGAN->editAttributes() ?> aria-describedby="x_POTONGAN_help">
<?= $Page->POTONGAN->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->POTONGAN->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->BAYAR->Visible) { // BAYAR ?>
    <div id="r_BAYAR" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_BAYAR" for="x_BAYAR" class="<?= $Page->LeftColumnClass ?>"><?= $Page->BAYAR->caption() ?><?= $Page->BAYAR->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->BAYAR->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_BAYAR">
<input type="<?= $Page->BAYAR->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_BAYAR" name="x_BAYAR" id="x_BAYAR" size="30" placeholder="<?= HtmlEncode($Page->BAYAR->getPlaceHolder()) ?>" value="<?= $Page->BAYAR->EditValue ?>"<?= $Page->BAYAR->editAttributes() ?> aria-describedby="x_BAYAR_help">
<?= $Page->BAYAR->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->BAYAR->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->RETUR->Visible) { // RETUR ?>
    <div id="r_RETUR" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_RETUR" for="x_RETUR" class="<?= $Page->LeftColumnClass ?>"><?= $Page->RETUR->caption() ?><?= $Page->RETUR->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->RETUR->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_RETUR">
<input type="<?= $Page->RETUR->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_RETUR" name="x_RETUR" id="x_RETUR" size="30" placeholder="<?= HtmlEncode($Page->RETUR->getPlaceHolder()) ?>" value="<?= $Page->RETUR->EditValue ?>"<?= $Page->RETUR->editAttributes() ?> aria-describedby="x_RETUR_help">
<?= $Page->RETUR->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->RETUR->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->TARIF_TYPE->Visible) { // TARIF_TYPE ?>
    <div id="r_TARIF_TYPE" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_TARIF_TYPE" for="x_TARIF_TYPE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->TARIF_TYPE->caption() ?><?= $Page->TARIF_TYPE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->TARIF_TYPE->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_TARIF_TYPE">
<input type="<?= $Page->TARIF_TYPE->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_TARIF_TYPE" name="x_TARIF_TYPE" id="x_TARIF_TYPE" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->TARIF_TYPE->getPlaceHolder()) ?>" value="<?= $Page->TARIF_TYPE->EditValue ?>"<?= $Page->TARIF_TYPE->editAttributes() ?> aria-describedby="x_TARIF_TYPE_help">
<?= $Page->TARIF_TYPE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->TARIF_TYPE->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->PPNVALUE->Visible) { // PPNVALUE ?>
    <div id="r_PPNVALUE" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_PPNVALUE" for="x_PPNVALUE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->PPNVALUE->caption() ?><?= $Page->PPNVALUE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PPNVALUE->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_PPNVALUE">
<input type="<?= $Page->PPNVALUE->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_PPNVALUE" name="x_PPNVALUE" id="x_PPNVALUE" size="30" placeholder="<?= HtmlEncode($Page->PPNVALUE->getPlaceHolder()) ?>" value="<?= $Page->PPNVALUE->EditValue ?>"<?= $Page->PPNVALUE->editAttributes() ?> aria-describedby="x_PPNVALUE_help">
<?= $Page->PPNVALUE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->PPNVALUE->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->TAGIHAN->Visible) { // TAGIHAN ?>
    <div id="r_TAGIHAN" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_TAGIHAN" for="x_TAGIHAN" class="<?= $Page->LeftColumnClass ?>"><?= $Page->TAGIHAN->caption() ?><?= $Page->TAGIHAN->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->TAGIHAN->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_TAGIHAN">
<input type="<?= $Page->TAGIHAN->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_TAGIHAN" name="x_TAGIHAN" id="x_TAGIHAN" size="30" placeholder="<?= HtmlEncode($Page->TAGIHAN->getPlaceHolder()) ?>" value="<?= $Page->TAGIHAN->EditValue ?>"<?= $Page->TAGIHAN->editAttributes() ?> aria-describedby="x_TAGIHAN_help">
<?= $Page->TAGIHAN->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->TAGIHAN->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->KOREKSI->Visible) { // KOREKSI ?>
    <div id="r_KOREKSI" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_KOREKSI" for="x_KOREKSI" class="<?= $Page->LeftColumnClass ?>"><?= $Page->KOREKSI->caption() ?><?= $Page->KOREKSI->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->KOREKSI->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_KOREKSI">
<input type="<?= $Page->KOREKSI->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_KOREKSI" name="x_KOREKSI" id="x_KOREKSI" size="30" placeholder="<?= HtmlEncode($Page->KOREKSI->getPlaceHolder()) ?>" value="<?= $Page->KOREKSI->EditValue ?>"<?= $Page->KOREKSI->editAttributes() ?> aria-describedby="x_KOREKSI_help">
<?= $Page->KOREKSI->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->KOREKSI->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->STATUS_OBAT->Visible) { // STATUS_OBAT ?>
    <div id="r_STATUS_OBAT" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_STATUS_OBAT" for="x_STATUS_OBAT" class="<?= $Page->LeftColumnClass ?>"><?= $Page->STATUS_OBAT->caption() ?><?= $Page->STATUS_OBAT->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->STATUS_OBAT->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_STATUS_OBAT">
<input type="<?= $Page->STATUS_OBAT->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_STATUS_OBAT" name="x_STATUS_OBAT" id="x_STATUS_OBAT" size="30" placeholder="<?= HtmlEncode($Page->STATUS_OBAT->getPlaceHolder()) ?>" value="<?= $Page->STATUS_OBAT->EditValue ?>"<?= $Page->STATUS_OBAT->editAttributes() ?> aria-describedby="x_STATUS_OBAT_help">
<?= $Page->STATUS_OBAT->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->STATUS_OBAT->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->SUBSIDISAT->Visible) { // SUBSIDISAT ?>
    <div id="r_SUBSIDISAT" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_SUBSIDISAT" for="x_SUBSIDISAT" class="<?= $Page->LeftColumnClass ?>"><?= $Page->SUBSIDISAT->caption() ?><?= $Page->SUBSIDISAT->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->SUBSIDISAT->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_SUBSIDISAT">
<input type="<?= $Page->SUBSIDISAT->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_SUBSIDISAT" name="x_SUBSIDISAT" id="x_SUBSIDISAT" size="30" placeholder="<?= HtmlEncode($Page->SUBSIDISAT->getPlaceHolder()) ?>" value="<?= $Page->SUBSIDISAT->EditValue ?>"<?= $Page->SUBSIDISAT->editAttributes() ?> aria-describedby="x_SUBSIDISAT_help">
<?= $Page->SUBSIDISAT->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->SUBSIDISAT->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->PRINTQ->Visible) { // PRINTQ ?>
    <div id="r_PRINTQ" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_PRINTQ" for="x_PRINTQ" class="<?= $Page->LeftColumnClass ?>"><?= $Page->PRINTQ->caption() ?><?= $Page->PRINTQ->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PRINTQ->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_PRINTQ">
<input type="<?= $Page->PRINTQ->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_PRINTQ" name="x_PRINTQ" id="x_PRINTQ" size="30" placeholder="<?= HtmlEncode($Page->PRINTQ->getPlaceHolder()) ?>" value="<?= $Page->PRINTQ->EditValue ?>"<?= $Page->PRINTQ->editAttributes() ?> aria-describedby="x_PRINTQ_help">
<?= $Page->PRINTQ->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->PRINTQ->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->PRINTED_BY->Visible) { // PRINTED_BY ?>
    <div id="r_PRINTED_BY" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_PRINTED_BY" for="x_PRINTED_BY" class="<?= $Page->LeftColumnClass ?>"><?= $Page->PRINTED_BY->caption() ?><?= $Page->PRINTED_BY->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PRINTED_BY->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_PRINTED_BY">
<input type="<?= $Page->PRINTED_BY->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_PRINTED_BY" name="x_PRINTED_BY" id="x_PRINTED_BY" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->PRINTED_BY->getPlaceHolder()) ?>" value="<?= $Page->PRINTED_BY->EditValue ?>"<?= $Page->PRINTED_BY->editAttributes() ?> aria-describedby="x_PRINTED_BY_help">
<?= $Page->PRINTED_BY->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->PRINTED_BY->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->STOCK_AVAILABLE->Visible) { // STOCK_AVAILABLE ?>
    <div id="r_STOCK_AVAILABLE" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_STOCK_AVAILABLE" for="x_STOCK_AVAILABLE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->STOCK_AVAILABLE->caption() ?><?= $Page->STOCK_AVAILABLE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->STOCK_AVAILABLE->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_STOCK_AVAILABLE">
<input type="<?= $Page->STOCK_AVAILABLE->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_STOCK_AVAILABLE" name="x_STOCK_AVAILABLE" id="x_STOCK_AVAILABLE" size="30" placeholder="<?= HtmlEncode($Page->STOCK_AVAILABLE->getPlaceHolder()) ?>" value="<?= $Page->STOCK_AVAILABLE->EditValue ?>"<?= $Page->STOCK_AVAILABLE->editAttributes() ?> aria-describedby="x_STOCK_AVAILABLE_help">
<?= $Page->STOCK_AVAILABLE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->STOCK_AVAILABLE->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->STATUS_TARIF->Visible) { // STATUS_TARIF ?>
    <div id="r_STATUS_TARIF" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_STATUS_TARIF" for="x_STATUS_TARIF" class="<?= $Page->LeftColumnClass ?>"><?= $Page->STATUS_TARIF->caption() ?><?= $Page->STATUS_TARIF->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->STATUS_TARIF->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_STATUS_TARIF">
<input type="<?= $Page->STATUS_TARIF->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_STATUS_TARIF" name="x_STATUS_TARIF" id="x_STATUS_TARIF" size="30" placeholder="<?= HtmlEncode($Page->STATUS_TARIF->getPlaceHolder()) ?>" value="<?= $Page->STATUS_TARIF->EditValue ?>"<?= $Page->STATUS_TARIF->editAttributes() ?> aria-describedby="x_STATUS_TARIF_help">
<?= $Page->STATUS_TARIF->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->STATUS_TARIF->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->CLINIC_TYPE->Visible) { // CLINIC_TYPE ?>
    <div id="r_CLINIC_TYPE" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_CLINIC_TYPE" for="x_CLINIC_TYPE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->CLINIC_TYPE->caption() ?><?= $Page->CLINIC_TYPE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->CLINIC_TYPE->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_CLINIC_TYPE">
<input type="<?= $Page->CLINIC_TYPE->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_CLINIC_TYPE" name="x_CLINIC_TYPE" id="x_CLINIC_TYPE" size="30" placeholder="<?= HtmlEncode($Page->CLINIC_TYPE->getPlaceHolder()) ?>" value="<?= $Page->CLINIC_TYPE->EditValue ?>"<?= $Page->CLINIC_TYPE->editAttributes() ?> aria-describedby="x_CLINIC_TYPE_help">
<?= $Page->CLINIC_TYPE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->CLINIC_TYPE->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->PACKAGE_ID->Visible) { // PACKAGE_ID ?>
    <div id="r_PACKAGE_ID" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_PACKAGE_ID" for="x_PACKAGE_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->PACKAGE_ID->caption() ?><?= $Page->PACKAGE_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PACKAGE_ID->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_PACKAGE_ID">
<input type="<?= $Page->PACKAGE_ID->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_PACKAGE_ID" name="x_PACKAGE_ID" id="x_PACKAGE_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->PACKAGE_ID->getPlaceHolder()) ?>" value="<?= $Page->PACKAGE_ID->EditValue ?>"<?= $Page->PACKAGE_ID->editAttributes() ?> aria-describedby="x_PACKAGE_ID_help">
<?= $Page->PACKAGE_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->PACKAGE_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->MODULE_ID->Visible) { // MODULE_ID ?>
    <div id="r_MODULE_ID" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_MODULE_ID" for="x_MODULE_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->MODULE_ID->caption() ?><?= $Page->MODULE_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->MODULE_ID->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_MODULE_ID">
<input type="<?= $Page->MODULE_ID->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_MODULE_ID" name="x_MODULE_ID" id="x_MODULE_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->MODULE_ID->getPlaceHolder()) ?>" value="<?= $Page->MODULE_ID->EditValue ?>"<?= $Page->MODULE_ID->editAttributes() ?> aria-describedby="x_MODULE_ID_help">
<?= $Page->MODULE_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->MODULE_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->profession->Visible) { // profession ?>
    <div id="r_profession" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_profession" for="x_profession" class="<?= $Page->LeftColumnClass ?>"><?= $Page->profession->caption() ?><?= $Page->profession->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->profession->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_profession">
<input type="<?= $Page->profession->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_profession" name="x_profession" id="x_profession" size="30" placeholder="<?= HtmlEncode($Page->profession->getPlaceHolder()) ?>" value="<?= $Page->profession->EditValue ?>"<?= $Page->profession->editAttributes() ?> aria-describedby="x_profession_help">
<?= $Page->profession->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->profession->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->THEORDER->Visible) { // THEORDER ?>
    <div id="r_THEORDER" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_THEORDER" for="x_THEORDER" class="<?= $Page->LeftColumnClass ?>"><?= $Page->THEORDER->caption() ?><?= $Page->THEORDER->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->THEORDER->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_THEORDER">
<input type="<?= $Page->THEORDER->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_THEORDER" name="x_THEORDER" id="x_THEORDER" size="30" placeholder="<?= HtmlEncode($Page->THEORDER->getPlaceHolder()) ?>" value="<?= $Page->THEORDER->EditValue ?>"<?= $Page->THEORDER->editAttributes() ?> aria-describedby="x_THEORDER_help">
<?= $Page->THEORDER->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->THEORDER->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->CASHIER->Visible) { // CASHIER ?>
    <div id="r_CASHIER" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_CASHIER" for="x_CASHIER" class="<?= $Page->LeftColumnClass ?>"><?= $Page->CASHIER->caption() ?><?= $Page->CASHIER->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->CASHIER->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_CASHIER">
<input type="<?= $Page->CASHIER->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_CASHIER" name="x_CASHIER" id="x_CASHIER" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->CASHIER->getPlaceHolder()) ?>" value="<?= $Page->CASHIER->EditValue ?>"<?= $Page->CASHIER->editAttributes() ?> aria-describedby="x_CASHIER_help">
<?= $Page->CASHIER->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->CASHIER->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->SPPFEE->Visible) { // SPPFEE ?>
    <div id="r_SPPFEE" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_SPPFEE" for="x_SPPFEE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->SPPFEE->caption() ?><?= $Page->SPPFEE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->SPPFEE->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_SPPFEE">
<input type="<?= $Page->SPPFEE->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_SPPFEE" name="x_SPPFEE" id="x_SPPFEE" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->SPPFEE->getPlaceHolder()) ?>" value="<?= $Page->SPPFEE->EditValue ?>"<?= $Page->SPPFEE->editAttributes() ?> aria-describedby="x_SPPFEE_help">
<?= $Page->SPPFEE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->SPPFEE->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->SPPBILL->Visible) { // SPPBILL ?>
    <div id="r_SPPBILL" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_SPPBILL" for="x_SPPBILL" class="<?= $Page->LeftColumnClass ?>"><?= $Page->SPPBILL->caption() ?><?= $Page->SPPBILL->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->SPPBILL->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_SPPBILL">
<input type="<?= $Page->SPPBILL->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_SPPBILL" name="x_SPPBILL" id="x_SPPBILL" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->SPPBILL->getPlaceHolder()) ?>" value="<?= $Page->SPPBILL->EditValue ?>"<?= $Page->SPPBILL->editAttributes() ?> aria-describedby="x_SPPBILL_help">
<?= $Page->SPPBILL->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->SPPBILL->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->SPPRJK->Visible) { // SPPRJK ?>
    <div id="r_SPPRJK" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_SPPRJK" for="x_SPPRJK" class="<?= $Page->LeftColumnClass ?>"><?= $Page->SPPRJK->caption() ?><?= $Page->SPPRJK->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->SPPRJK->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_SPPRJK">
<input type="<?= $Page->SPPRJK->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_SPPRJK" name="x_SPPRJK" id="x_SPPRJK" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->SPPRJK->getPlaceHolder()) ?>" value="<?= $Page->SPPRJK->EditValue ?>"<?= $Page->SPPRJK->editAttributes() ?> aria-describedby="x_SPPRJK_help">
<?= $Page->SPPRJK->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->SPPRJK->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->SPPJMN->Visible) { // SPPJMN ?>
    <div id="r_SPPJMN" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_SPPJMN" for="x_SPPJMN" class="<?= $Page->LeftColumnClass ?>"><?= $Page->SPPJMN->caption() ?><?= $Page->SPPJMN->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->SPPJMN->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_SPPJMN">
<input type="<?= $Page->SPPJMN->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_SPPJMN" name="x_SPPJMN" id="x_SPPJMN" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->SPPJMN->getPlaceHolder()) ?>" value="<?= $Page->SPPJMN->EditValue ?>"<?= $Page->SPPJMN->editAttributes() ?> aria-describedby="x_SPPJMN_help">
<?= $Page->SPPJMN->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->SPPJMN->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->SPPKASIR->Visible) { // SPPKASIR ?>
    <div id="r_SPPKASIR" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_SPPKASIR" for="x_SPPKASIR" class="<?= $Page->LeftColumnClass ?>"><?= $Page->SPPKASIR->caption() ?><?= $Page->SPPKASIR->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->SPPKASIR->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_SPPKASIR">
<input type="<?= $Page->SPPKASIR->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_SPPKASIR" name="x_SPPKASIR" id="x_SPPKASIR" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->SPPKASIR->getPlaceHolder()) ?>" value="<?= $Page->SPPKASIR->EditValue ?>"<?= $Page->SPPKASIR->editAttributes() ?> aria-describedby="x_SPPKASIR_help">
<?= $Page->SPPKASIR->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->SPPKASIR->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->PERUJUK->Visible) { // PERUJUK ?>
    <div id="r_PERUJUK" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_PERUJUK" for="x_PERUJUK" class="<?= $Page->LeftColumnClass ?>"><?= $Page->PERUJUK->caption() ?><?= $Page->PERUJUK->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PERUJUK->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_PERUJUK">
<input type="<?= $Page->PERUJUK->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_PERUJUK" name="x_PERUJUK" id="x_PERUJUK" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->PERUJUK->getPlaceHolder()) ?>" value="<?= $Page->PERUJUK->EditValue ?>"<?= $Page->PERUJUK->editAttributes() ?> aria-describedby="x_PERUJUK_help">
<?= $Page->PERUJUK->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->PERUJUK->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->PERUJUKFEE->Visible) { // PERUJUKFEE ?>
    <div id="r_PERUJUKFEE" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_PERUJUKFEE" for="x_PERUJUKFEE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->PERUJUKFEE->caption() ?><?= $Page->PERUJUKFEE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PERUJUKFEE->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_PERUJUKFEE">
<input type="<?= $Page->PERUJUKFEE->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_PERUJUKFEE" name="x_PERUJUKFEE" id="x_PERUJUKFEE" size="30" placeholder="<?= HtmlEncode($Page->PERUJUKFEE->getPlaceHolder()) ?>" value="<?= $Page->PERUJUKFEE->EditValue ?>"<?= $Page->PERUJUKFEE->editAttributes() ?> aria-describedby="x_PERUJUKFEE_help">
<?= $Page->PERUJUKFEE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->PERUJUKFEE->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->modified_datesys->Visible) { // modified_datesys ?>
    <div id="r_modified_datesys" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_modified_datesys" for="x_modified_datesys" class="<?= $Page->LeftColumnClass ?>"><?= $Page->modified_datesys->caption() ?><?= $Page->modified_datesys->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->modified_datesys->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_modified_datesys">
<input type="<?= $Page->modified_datesys->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_modified_datesys" name="x_modified_datesys" id="x_modified_datesys" placeholder="<?= HtmlEncode($Page->modified_datesys->getPlaceHolder()) ?>" value="<?= $Page->modified_datesys->EditValue ?>"<?= $Page->modified_datesys->editAttributes() ?> aria-describedby="x_modified_datesys_help">
<?= $Page->modified_datesys->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->modified_datesys->getErrorMessage() ?></div>
<?php if (!$Page->modified_datesys->ReadOnly && !$Page->modified_datesys->Disabled && !isset($Page->modified_datesys->EditAttrs["readonly"]) && !isset($Page->modified_datesys->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fTREATMENT_BAYARedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fTREATMENT_BAYARedit", "x_modified_datesys", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->TRANS_ID->Visible) { // TRANS_ID ?>
    <div id="r_TRANS_ID" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_TRANS_ID" for="x_TRANS_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->TRANS_ID->caption() ?><?= $Page->TRANS_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->TRANS_ID->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_TRANS_ID">
<input type="<?= $Page->TRANS_ID->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_TRANS_ID" name="x_TRANS_ID" id="x_TRANS_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->TRANS_ID->getPlaceHolder()) ?>" value="<?= $Page->TRANS_ID->EditValue ?>"<?= $Page->TRANS_ID->editAttributes() ?> aria-describedby="x_TRANS_ID_help">
<?= $Page->TRANS_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->TRANS_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->SPPBILLDATE->Visible) { // SPPBILLDATE ?>
    <div id="r_SPPBILLDATE" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_SPPBILLDATE" for="x_SPPBILLDATE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->SPPBILLDATE->caption() ?><?= $Page->SPPBILLDATE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->SPPBILLDATE->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_SPPBILLDATE">
<input type="<?= $Page->SPPBILLDATE->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_SPPBILLDATE" name="x_SPPBILLDATE" id="x_SPPBILLDATE" placeholder="<?= HtmlEncode($Page->SPPBILLDATE->getPlaceHolder()) ?>" value="<?= $Page->SPPBILLDATE->EditValue ?>"<?= $Page->SPPBILLDATE->editAttributes() ?> aria-describedby="x_SPPBILLDATE_help">
<?= $Page->SPPBILLDATE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->SPPBILLDATE->getErrorMessage() ?></div>
<?php if (!$Page->SPPBILLDATE->ReadOnly && !$Page->SPPBILLDATE->Disabled && !isset($Page->SPPBILLDATE->EditAttrs["readonly"]) && !isset($Page->SPPBILLDATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fTREATMENT_BAYARedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fTREATMENT_BAYARedit", "x_SPPBILLDATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->SPPBILLUSER->Visible) { // SPPBILLUSER ?>
    <div id="r_SPPBILLUSER" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_SPPBILLUSER" for="x_SPPBILLUSER" class="<?= $Page->LeftColumnClass ?>"><?= $Page->SPPBILLUSER->caption() ?><?= $Page->SPPBILLUSER->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->SPPBILLUSER->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_SPPBILLUSER">
<input type="<?= $Page->SPPBILLUSER->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_SPPBILLUSER" name="x_SPPBILLUSER" id="x_SPPBILLUSER" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->SPPBILLUSER->getPlaceHolder()) ?>" value="<?= $Page->SPPBILLUSER->EditValue ?>"<?= $Page->SPPBILLUSER->editAttributes() ?> aria-describedby="x_SPPBILLUSER_help">
<?= $Page->SPPBILLUSER->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->SPPBILLUSER->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->SPPKASIRDATE->Visible) { // SPPKASIRDATE ?>
    <div id="r_SPPKASIRDATE" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_SPPKASIRDATE" for="x_SPPKASIRDATE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->SPPKASIRDATE->caption() ?><?= $Page->SPPKASIRDATE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->SPPKASIRDATE->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_SPPKASIRDATE">
<input type="<?= $Page->SPPKASIRDATE->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_SPPKASIRDATE" name="x_SPPKASIRDATE" id="x_SPPKASIRDATE" placeholder="<?= HtmlEncode($Page->SPPKASIRDATE->getPlaceHolder()) ?>" value="<?= $Page->SPPKASIRDATE->EditValue ?>"<?= $Page->SPPKASIRDATE->editAttributes() ?> aria-describedby="x_SPPKASIRDATE_help">
<?= $Page->SPPKASIRDATE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->SPPKASIRDATE->getErrorMessage() ?></div>
<?php if (!$Page->SPPKASIRDATE->ReadOnly && !$Page->SPPKASIRDATE->Disabled && !isset($Page->SPPKASIRDATE->EditAttrs["readonly"]) && !isset($Page->SPPKASIRDATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fTREATMENT_BAYARedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fTREATMENT_BAYARedit", "x_SPPKASIRDATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->SPPKASIRUSER->Visible) { // SPPKASIRUSER ?>
    <div id="r_SPPKASIRUSER" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_SPPKASIRUSER" for="x_SPPKASIRUSER" class="<?= $Page->LeftColumnClass ?>"><?= $Page->SPPKASIRUSER->caption() ?><?= $Page->SPPKASIRUSER->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->SPPKASIRUSER->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_SPPKASIRUSER">
<input type="<?= $Page->SPPKASIRUSER->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_SPPKASIRUSER" name="x_SPPKASIRUSER" id="x_SPPKASIRUSER" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->SPPKASIRUSER->getPlaceHolder()) ?>" value="<?= $Page->SPPKASIRUSER->EditValue ?>"<?= $Page->SPPKASIRUSER->editAttributes() ?> aria-describedby="x_SPPKASIRUSER_help">
<?= $Page->SPPKASIRUSER->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->SPPKASIRUSER->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->SPPPOLI->Visible) { // SPPPOLI ?>
    <div id="r_SPPPOLI" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_SPPPOLI" for="x_SPPPOLI" class="<?= $Page->LeftColumnClass ?>"><?= $Page->SPPPOLI->caption() ?><?= $Page->SPPPOLI->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->SPPPOLI->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_SPPPOLI">
<input type="<?= $Page->SPPPOLI->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_SPPPOLI" name="x_SPPPOLI" id="x_SPPPOLI" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->SPPPOLI->getPlaceHolder()) ?>" value="<?= $Page->SPPPOLI->EditValue ?>"<?= $Page->SPPPOLI->editAttributes() ?> aria-describedby="x_SPPPOLI_help">
<?= $Page->SPPPOLI->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->SPPPOLI->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->SPPPOLIUSER->Visible) { // SPPPOLIUSER ?>
    <div id="r_SPPPOLIUSER" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_SPPPOLIUSER" for="x_SPPPOLIUSER" class="<?= $Page->LeftColumnClass ?>"><?= $Page->SPPPOLIUSER->caption() ?><?= $Page->SPPPOLIUSER->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->SPPPOLIUSER->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_SPPPOLIUSER">
<input type="<?= $Page->SPPPOLIUSER->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_SPPPOLIUSER" name="x_SPPPOLIUSER" id="x_SPPPOLIUSER" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->SPPPOLIUSER->getPlaceHolder()) ?>" value="<?= $Page->SPPPOLIUSER->EditValue ?>"<?= $Page->SPPPOLIUSER->editAttributes() ?> aria-describedby="x_SPPPOLIUSER_help">
<?= $Page->SPPPOLIUSER->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->SPPPOLIUSER->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->SPPPOLIDATE->Visible) { // SPPPOLIDATE ?>
    <div id="r_SPPPOLIDATE" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_SPPPOLIDATE" for="x_SPPPOLIDATE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->SPPPOLIDATE->caption() ?><?= $Page->SPPPOLIDATE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->SPPPOLIDATE->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_SPPPOLIDATE">
<input type="<?= $Page->SPPPOLIDATE->getInputTextType() ?>" data-table="TREATMENT_BAYAR" data-field="x_SPPPOLIDATE" name="x_SPPPOLIDATE" id="x_SPPPOLIDATE" placeholder="<?= HtmlEncode($Page->SPPPOLIDATE->getPlaceHolder()) ?>" value="<?= $Page->SPPPOLIDATE->EditValue ?>"<?= $Page->SPPPOLIDATE->editAttributes() ?> aria-describedby="x_SPPPOLIDATE_help">
<?= $Page->SPPPOLIDATE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->SPPPOLIDATE->getErrorMessage() ?></div>
<?php if (!$Page->SPPPOLIDATE->ReadOnly && !$Page->SPPPOLIDATE->Disabled && !isset($Page->SPPPOLIDATE->EditAttrs["readonly"]) && !isset($Page->SPPPOLIDATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fTREATMENT_BAYARedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fTREATMENT_BAYARedit", "x_SPPPOLIDATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ID->Visible) { // ID ?>
    <div id="r_ID" class="form-group row">
        <label id="elh_TREATMENT_BAYAR_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ID->caption() ?><?= $Page->ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ID->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_ID">
<span<?= $Page->ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->ID->getDisplayValue($Page->ID->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="TREATMENT_BAYAR" data-field="x_ID" data-hidden="1" name="x_ID" id="x_ID" value="<?= HtmlEncode($Page->ID->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$Page->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("SaveBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
    </div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("TREATMENT_BAYAR");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
