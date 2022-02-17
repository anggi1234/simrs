<?php

namespace PHPMaker2021\SIMRS;

// Set up and run Grid object
$Grid = Container("VTreatGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fV_TREATgrid;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    fV_TREATgrid = new ew.Form("fV_TREATgrid", "grid");
    fV_TREATgrid.formKeyCountName = '<?= $Grid->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "V_TREAT")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.V_TREAT)
        ew.vars.tables.V_TREAT = currentTable;
    fV_TREATgrid.addFields([
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
        ["QUANTITY", [fields.QUANTITY.visible && fields.QUANTITY.required ? ew.Validators.required(fields.QUANTITY.caption) : null, ew.Validators.float], fields.QUANTITY.isInvalid],
        ["MEASURE_ID", [fields.MEASURE_ID.visible && fields.MEASURE_ID.required ? ew.Validators.required(fields.MEASURE_ID.caption) : null, ew.Validators.integer], fields.MEASURE_ID.isInvalid],
        ["DESCRIPTION", [fields.DESCRIPTION.visible && fields.DESCRIPTION.required ? ew.Validators.required(fields.DESCRIPTION.caption) : null], fields.DESCRIPTION.isInvalid],
        ["RESEP_NO", [fields.RESEP_NO.visible && fields.RESEP_NO.required ? ew.Validators.required(fields.RESEP_NO.caption) : null], fields.RESEP_NO.isInvalid],
        ["DOSE_PRESC", [fields.DOSE_PRESC.visible && fields.DOSE_PRESC.required ? ew.Validators.required(fields.DOSE_PRESC.caption) : null, ew.Validators.float], fields.DOSE_PRESC.isInvalid],
        ["SOLD_STATUS", [fields.SOLD_STATUS.visible && fields.SOLD_STATUS.required ? ew.Validators.required(fields.SOLD_STATUS.caption) : null, ew.Validators.integer], fields.SOLD_STATUS.isInvalid],
        ["RACIKAN", [fields.RACIKAN.visible && fields.RACIKAN.required ? ew.Validators.required(fields.RACIKAN.caption) : null, ew.Validators.integer], fields.RACIKAN.isInvalid],
        ["CLASS_ROOM_ID", [fields.CLASS_ROOM_ID.visible && fields.CLASS_ROOM_ID.required ? ew.Validators.required(fields.CLASS_ROOM_ID.caption) : null], fields.CLASS_ROOM_ID.isInvalid],
        ["KELUAR_ID", [fields.KELUAR_ID.visible && fields.KELUAR_ID.required ? ew.Validators.required(fields.KELUAR_ID.caption) : null, ew.Validators.integer], fields.KELUAR_ID.isInvalid],
        ["BED_ID", [fields.BED_ID.visible && fields.BED_ID.required ? ew.Validators.required(fields.BED_ID.caption) : null, ew.Validators.integer], fields.BED_ID.isInvalid],
        ["EMPLOYEE_ID", [fields.EMPLOYEE_ID.visible && fields.EMPLOYEE_ID.required ? ew.Validators.required(fields.EMPLOYEE_ID.caption) : null], fields.EMPLOYEE_ID.isInvalid],
        ["DESCRIPTION2", [fields.DESCRIPTION2.visible && fields.DESCRIPTION2.required ? ew.Validators.required(fields.DESCRIPTION2.caption) : null], fields.DESCRIPTION2.isInvalid],
        ["BRAND_ID", [fields.BRAND_ID.visible && fields.BRAND_ID.required ? ew.Validators.required(fields.BRAND_ID.caption) : null], fields.BRAND_ID.isInvalid],
        ["DOCTOR", [fields.DOCTOR.visible && fields.DOCTOR.required ? ew.Validators.required(fields.DOCTOR.caption) : null], fields.DOCTOR.isInvalid],
        ["EXIT_DATE", [fields.EXIT_DATE.visible && fields.EXIT_DATE.required ? ew.Validators.required(fields.EXIT_DATE.caption) : null, ew.Validators.datetime(0)], fields.EXIT_DATE.isInvalid],
        ["EMPLOYEE_ID_FROM", [fields.EMPLOYEE_ID_FROM.visible && fields.EMPLOYEE_ID_FROM.required ? ew.Validators.required(fields.EMPLOYEE_ID_FROM.caption) : null], fields.EMPLOYEE_ID_FROM.isInvalid],
        ["DOCTOR_FROM", [fields.DOCTOR_FROM.visible && fields.DOCTOR_FROM.required ? ew.Validators.required(fields.DOCTOR_FROM.caption) : null], fields.DOCTOR_FROM.isInvalid],
        ["status_pasien_id", [fields.status_pasien_id.visible && fields.status_pasien_id.required ? ew.Validators.required(fields.status_pasien_id.caption) : null, ew.Validators.integer], fields.status_pasien_id.isInvalid],
        ["THENAME", [fields.THENAME.visible && fields.THENAME.required ? ew.Validators.required(fields.THENAME.caption) : null], fields.THENAME.isInvalid],
        ["THEADDRESS", [fields.THEADDRESS.visible && fields.THEADDRESS.required ? ew.Validators.required(fields.THEADDRESS.caption) : null], fields.THEADDRESS.isInvalid],
        ["THEID", [fields.THEID.visible && fields.THEID.required ? ew.Validators.required(fields.THEID.caption) : null], fields.THEID.isInvalid],
        ["SERIAL_NB", [fields.SERIAL_NB.visible && fields.SERIAL_NB.required ? ew.Validators.required(fields.SERIAL_NB.caption) : null], fields.SERIAL_NB.isInvalid],
        ["ISRJ", [fields.ISRJ.visible && fields.ISRJ.required ? ew.Validators.required(fields.ISRJ.caption) : null], fields.ISRJ.isInvalid],
        ["AGEYEAR", [fields.AGEYEAR.visible && fields.AGEYEAR.required ? ew.Validators.required(fields.AGEYEAR.caption) : null, ew.Validators.integer], fields.AGEYEAR.isInvalid],
        ["AGEMONTH", [fields.AGEMONTH.visible && fields.AGEMONTH.required ? ew.Validators.required(fields.AGEMONTH.caption) : null, ew.Validators.integer], fields.AGEMONTH.isInvalid],
        ["AGEDAY", [fields.AGEDAY.visible && fields.AGEDAY.required ? ew.Validators.required(fields.AGEDAY.caption) : null, ew.Validators.integer], fields.AGEDAY.isInvalid],
        ["GENDER", [fields.GENDER.visible && fields.GENDER.required ? ew.Validators.required(fields.GENDER.caption) : null], fields.GENDER.isInvalid],
        ["KARYAWAN", [fields.KARYAWAN.visible && fields.KARYAWAN.required ? ew.Validators.required(fields.KARYAWAN.caption) : null], fields.KARYAWAN.isInvalid],
        ["MODIFIED_BY", [fields.MODIFIED_BY.visible && fields.MODIFIED_BY.required ? ew.Validators.required(fields.MODIFIED_BY.caption) : null], fields.MODIFIED_BY.isInvalid],
        ["MODIFIED_DATE", [fields.MODIFIED_DATE.visible && fields.MODIFIED_DATE.required ? ew.Validators.required(fields.MODIFIED_DATE.caption) : null, ew.Validators.datetime(0)], fields.MODIFIED_DATE.isInvalid],
        ["MODIFIED_FROM", [fields.MODIFIED_FROM.visible && fields.MODIFIED_FROM.required ? ew.Validators.required(fields.MODIFIED_FROM.caption) : null], fields.MODIFIED_FROM.isInvalid],
        ["NUMER", [fields.NUMER.visible && fields.NUMER.required ? ew.Validators.required(fields.NUMER.caption) : null], fields.NUMER.isInvalid],
        ["NOTA_NO", [fields.NOTA_NO.visible && fields.NOTA_NO.required ? ew.Validators.required(fields.NOTA_NO.caption) : null], fields.NOTA_NO.isInvalid],
        ["MEASURE_ID2", [fields.MEASURE_ID2.visible && fields.MEASURE_ID2.required ? ew.Validators.required(fields.MEASURE_ID2.caption) : null, ew.Validators.integer], fields.MEASURE_ID2.isInvalid],
        ["POTONGAN", [fields.POTONGAN.visible && fields.POTONGAN.required ? ew.Validators.required(fields.POTONGAN.caption) : null, ew.Validators.float], fields.POTONGAN.isInvalid],
        ["BAYAR", [fields.BAYAR.visible && fields.BAYAR.required ? ew.Validators.required(fields.BAYAR.caption) : null, ew.Validators.float], fields.BAYAR.isInvalid],
        ["RETUR", [fields.RETUR.visible && fields.RETUR.required ? ew.Validators.required(fields.RETUR.caption) : null, ew.Validators.float], fields.RETUR.isInvalid],
        ["TARIF_TYPE", [fields.TARIF_TYPE.visible && fields.TARIF_TYPE.required ? ew.Validators.required(fields.TARIF_TYPE.caption) : null], fields.TARIF_TYPE.isInvalid],
        ["PPNVALUE", [fields.PPNVALUE.visible && fields.PPNVALUE.required ? ew.Validators.required(fields.PPNVALUE.caption) : null, ew.Validators.float], fields.PPNVALUE.isInvalid],
        ["TAGIHAN", [fields.TAGIHAN.visible && fields.TAGIHAN.required ? ew.Validators.required(fields.TAGIHAN.caption) : null, ew.Validators.float], fields.TAGIHAN.isInvalid],
        ["KOREKSI", [fields.KOREKSI.visible && fields.KOREKSI.required ? ew.Validators.required(fields.KOREKSI.caption) : null, ew.Validators.float], fields.KOREKSI.isInvalid],
        ["AMOUNT_PAID", [fields.AMOUNT_PAID.visible && fields.AMOUNT_PAID.required ? ew.Validators.required(fields.AMOUNT_PAID.caption) : null, ew.Validators.float], fields.AMOUNT_PAID.isInvalid],
        ["DISKON", [fields.DISKON.visible && fields.DISKON.required ? ew.Validators.required(fields.DISKON.caption) : null, ew.Validators.float], fields.DISKON.isInvalid],
        ["SELL_PRICE", [fields.SELL_PRICE.visible && fields.SELL_PRICE.required ? ew.Validators.required(fields.SELL_PRICE.caption) : null, ew.Validators.float], fields.SELL_PRICE.isInvalid],
        ["ACCOUNT_ID", [fields.ACCOUNT_ID.visible && fields.ACCOUNT_ID.required ? ew.Validators.required(fields.ACCOUNT_ID.caption) : null], fields.ACCOUNT_ID.isInvalid],
        ["subsidi", [fields.subsidi.visible && fields.subsidi.required ? ew.Validators.required(fields.subsidi.caption) : null, ew.Validators.float], fields.subsidi.isInvalid],
        ["PROFESI", [fields.PROFESI.visible && fields.PROFESI.required ? ew.Validators.required(fields.PROFESI.caption) : null, ew.Validators.float], fields.PROFESI.isInvalid],
        ["EMBALACE", [fields.EMBALACE.visible && fields.EMBALACE.required ? ew.Validators.required(fields.EMBALACE.caption) : null, ew.Validators.float], fields.EMBALACE.isInvalid],
        ["DISCOUNT", [fields.DISCOUNT.visible && fields.DISCOUNT.required ? ew.Validators.required(fields.DISCOUNT.caption) : null, ew.Validators.float], fields.DISCOUNT.isInvalid],
        ["AMOUNT", [fields.AMOUNT.visible && fields.AMOUNT.required ? ew.Validators.required(fields.AMOUNT.caption) : null, ew.Validators.float], fields.AMOUNT.isInvalid],
        ["PPN", [fields.PPN.visible && fields.PPN.required ? ew.Validators.required(fields.PPN.caption) : null, ew.Validators.float], fields.PPN.isInvalid],
        ["ITER", [fields.ITER.visible && fields.ITER.required ? ew.Validators.required(fields.ITER.caption) : null, ew.Validators.integer], fields.ITER.isInvalid],
        ["PAYOR_ID", [fields.PAYOR_ID.visible && fields.PAYOR_ID.required ? ew.Validators.required(fields.PAYOR_ID.caption) : null], fields.PAYOR_ID.isInvalid],
        ["STATUS_OBAT", [fields.STATUS_OBAT.visible && fields.STATUS_OBAT.required ? ew.Validators.required(fields.STATUS_OBAT.caption) : null, ew.Validators.integer], fields.STATUS_OBAT.isInvalid],
        ["SUBSIDISAT", [fields.SUBSIDISAT.visible && fields.SUBSIDISAT.required ? ew.Validators.required(fields.SUBSIDISAT.caption) : null, ew.Validators.float], fields.SUBSIDISAT.isInvalid],
        ["MARGIN", [fields.MARGIN.visible && fields.MARGIN.required ? ew.Validators.required(fields.MARGIN.caption) : null, ew.Validators.float], fields.MARGIN.isInvalid],
        ["POKOK_JUAL", [fields.POKOK_JUAL.visible && fields.POKOK_JUAL.required ? ew.Validators.required(fields.POKOK_JUAL.caption) : null, ew.Validators.float], fields.POKOK_JUAL.isInvalid],
        ["PRINTQ", [fields.PRINTQ.visible && fields.PRINTQ.required ? ew.Validators.required(fields.PRINTQ.caption) : null, ew.Validators.integer], fields.PRINTQ.isInvalid],
        ["PRINTED_BY", [fields.PRINTED_BY.visible && fields.PRINTED_BY.required ? ew.Validators.required(fields.PRINTED_BY.caption) : null], fields.PRINTED_BY.isInvalid],
        ["STOCK_AVAILABLE", [fields.STOCK_AVAILABLE.visible && fields.STOCK_AVAILABLE.required ? ew.Validators.required(fields.STOCK_AVAILABLE.caption) : null, ew.Validators.float], fields.STOCK_AVAILABLE.isInvalid],
        ["STATUS_TARIF", [fields.STATUS_TARIF.visible && fields.STATUS_TARIF.required ? ew.Validators.required(fields.STATUS_TARIF.caption) : null, ew.Validators.integer], fields.STATUS_TARIF.isInvalid],
        ["PACKAGE_ID", [fields.PACKAGE_ID.visible && fields.PACKAGE_ID.required ? ew.Validators.required(fields.PACKAGE_ID.caption) : null], fields.PACKAGE_ID.isInvalid],
        ["MODULE_ID", [fields.MODULE_ID.visible && fields.MODULE_ID.required ? ew.Validators.required(fields.MODULE_ID.caption) : null], fields.MODULE_ID.isInvalid],
        ["profession", [fields.profession.visible && fields.profession.required ? ew.Validators.required(fields.profession.caption) : null, ew.Validators.float], fields.profession.isInvalid],
        ["THEORDER", [fields.THEORDER.visible && fields.THEORDER.required ? ew.Validators.required(fields.THEORDER.caption) : null, ew.Validators.integer], fields.THEORDER.isInvalid],
        ["CORRECTION_ID", [fields.CORRECTION_ID.visible && fields.CORRECTION_ID.required ? ew.Validators.required(fields.CORRECTION_ID.caption) : null], fields.CORRECTION_ID.isInvalid],
        ["CORRECTION_BY", [fields.CORRECTION_BY.visible && fields.CORRECTION_BY.required ? ew.Validators.required(fields.CORRECTION_BY.caption) : null], fields.CORRECTION_BY.isInvalid],
        ["CASHIER", [fields.CASHIER.visible && fields.CASHIER.required ? ew.Validators.required(fields.CASHIER.caption) : null], fields.CASHIER.isInvalid],
        ["islunas", [fields.islunas.visible && fields.islunas.required ? ew.Validators.required(fields.islunas.caption) : null], fields.islunas.isInvalid],
        ["PAY_METHOD_ID", [fields.PAY_METHOD_ID.visible && fields.PAY_METHOD_ID.required ? ew.Validators.required(fields.PAY_METHOD_ID.caption) : null, ew.Validators.integer], fields.PAY_METHOD_ID.isInvalid],
        ["PAYMENT_DATE", [fields.PAYMENT_DATE.visible && fields.PAYMENT_DATE.required ? ew.Validators.required(fields.PAYMENT_DATE.caption) : null, ew.Validators.datetime(0)], fields.PAYMENT_DATE.isInvalid],
        ["ISCETAK", [fields.ISCETAK.visible && fields.ISCETAK.required ? ew.Validators.required(fields.ISCETAK.caption) : null], fields.ISCETAK.isInvalid],
        ["print_date", [fields.print_date.visible && fields.print_date.required ? ew.Validators.required(fields.print_date.caption) : null, ew.Validators.datetime(0)], fields.print_date.isInvalid],
        ["DOSE", [fields.DOSE.visible && fields.DOSE.required ? ew.Validators.required(fields.DOSE.caption) : null, ew.Validators.float], fields.DOSE.isInvalid],
        ["JML_BKS", [fields.JML_BKS.visible && fields.JML_BKS.required ? ew.Validators.required(fields.JML_BKS.caption) : null, ew.Validators.integer], fields.JML_BKS.isInvalid],
        ["ORIG_DOSE", [fields.ORIG_DOSE.visible && fields.ORIG_DOSE.required ? ew.Validators.required(fields.ORIG_DOSE.caption) : null, ew.Validators.float], fields.ORIG_DOSE.isInvalid],
        ["RESEP_KE", [fields.RESEP_KE.visible && fields.RESEP_KE.required ? ew.Validators.required(fields.RESEP_KE.caption) : null, ew.Validators.integer], fields.RESEP_KE.isInvalid],
        ["ITER_KE", [fields.ITER_KE.visible && fields.ITER_KE.required ? ew.Validators.required(fields.ITER_KE.caption) : null, ew.Validators.integer], fields.ITER_KE.isInvalid],
        ["KUITANSI_ID", [fields.KUITANSI_ID.visible && fields.KUITANSI_ID.required ? ew.Validators.required(fields.KUITANSI_ID.caption) : null], fields.KUITANSI_ID.isInvalid],
        ["PEMBULATAN", [fields.PEMBULATAN.visible && fields.PEMBULATAN.required ? ew.Validators.required(fields.PEMBULATAN.caption) : null, ew.Validators.float], fields.PEMBULATAN.isInvalid],
        ["KAL_ID", [fields.KAL_ID.visible && fields.KAL_ID.required ? ew.Validators.required(fields.KAL_ID.caption) : null], fields.KAL_ID.isInvalid],
        ["INVOICE_ID", [fields.INVOICE_ID.visible && fields.INVOICE_ID.required ? ew.Validators.required(fields.INVOICE_ID.caption) : null], fields.INVOICE_ID.isInvalid],
        ["SERVICE_TIME", [fields.SERVICE_TIME.visible && fields.SERVICE_TIME.required ? ew.Validators.required(fields.SERVICE_TIME.caption) : null, ew.Validators.datetime(0)], fields.SERVICE_TIME.isInvalid],
        ["TAKEN_TIME", [fields.TAKEN_TIME.visible && fields.TAKEN_TIME.required ? ew.Validators.required(fields.TAKEN_TIME.caption) : null, ew.Validators.datetime(0)], fields.TAKEN_TIME.isInvalid],
        ["modified_datesys", [fields.modified_datesys.visible && fields.modified_datesys.required ? ew.Validators.required(fields.modified_datesys.caption) : null, ew.Validators.datetime(0)], fields.modified_datesys.isInvalid],
        ["TRANS_ID", [fields.TRANS_ID.visible && fields.TRANS_ID.required ? ew.Validators.required(fields.TRANS_ID.caption) : null], fields.TRANS_ID.isInvalid],
        ["SPPBILL", [fields.SPPBILL.visible && fields.SPPBILL.required ? ew.Validators.required(fields.SPPBILL.caption) : null], fields.SPPBILL.isInvalid],
        ["SPPBILLDATE", [fields.SPPBILLDATE.visible && fields.SPPBILLDATE.required ? ew.Validators.required(fields.SPPBILLDATE.caption) : null, ew.Validators.datetime(0)], fields.SPPBILLDATE.isInvalid],
        ["SPPBILLUSER", [fields.SPPBILLUSER.visible && fields.SPPBILLUSER.required ? ew.Validators.required(fields.SPPBILLUSER.caption) : null], fields.SPPBILLUSER.isInvalid],
        ["SPPKASIR", [fields.SPPKASIR.visible && fields.SPPKASIR.required ? ew.Validators.required(fields.SPPKASIR.caption) : null], fields.SPPKASIR.isInvalid],
        ["SPPKASIRDATE", [fields.SPPKASIRDATE.visible && fields.SPPKASIRDATE.required ? ew.Validators.required(fields.SPPKASIRDATE.caption) : null, ew.Validators.datetime(0)], fields.SPPKASIRDATE.isInvalid],
        ["SPPKASIRUSER", [fields.SPPKASIRUSER.visible && fields.SPPKASIRUSER.required ? ew.Validators.required(fields.SPPKASIRUSER.caption) : null], fields.SPPKASIRUSER.isInvalid],
        ["SPPPOLI", [fields.SPPPOLI.visible && fields.SPPPOLI.required ? ew.Validators.required(fields.SPPPOLI.caption) : null], fields.SPPPOLI.isInvalid],
        ["SPPPOLIUSER", [fields.SPPPOLIUSER.visible && fields.SPPPOLIUSER.required ? ew.Validators.required(fields.SPPPOLIUSER.caption) : null], fields.SPPPOLIUSER.isInvalid],
        ["SPPPOLIDATE", [fields.SPPPOLIDATE.visible && fields.SPPPOLIDATE.required ? ew.Validators.required(fields.SPPPOLIDATE.caption) : null, ew.Validators.datetime(0)], fields.SPPPOLIDATE.isInvalid],
        ["NOSEP", [fields.NOSEP.visible && fields.NOSEP.required ? ew.Validators.required(fields.NOSEP.caption) : null], fields.NOSEP.isInvalid],
        ["ID", [fields.ID.visible && fields.ID.required ? ew.Validators.required(fields.ID.caption) : null], fields.ID.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fV_TREATgrid,
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
    fV_TREATgrid.validate = function () {
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
            var checkrow = (gridinsert) ? !this.emptyRow(rowIndex) : true;
            if (checkrow) {
                addcnt++;

            // Validate fields
            if (!this.validateFields(rowIndex))
                return false;

            // Call Form_CustomValidate event
            if (!this.customValidate(fobj)) {
                this.focus();
                return false;
            }
            } // End Grid Add checking
        }
        return true;
    }

    // Check empty row
    fV_TREATgrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm();
        if (ew.valueChanged(fobj, rowIndex, "ORG_UNIT_CODE", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "BILL_ID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "NO_REGISTRATION", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "VISIT_ID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "TARIF_ID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "CLASS_ID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "CLINIC_ID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "CLINIC_ID_FROM", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "TREATMENT", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "TREAT_DATE", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "QUANTITY", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "MEASURE_ID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "DESCRIPTION", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "RESEP_NO", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "DOSE_PRESC", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "SOLD_STATUS", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "RACIKAN", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "CLASS_ROOM_ID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "KELUAR_ID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "BED_ID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "EMPLOYEE_ID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "DESCRIPTION2", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "BRAND_ID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "DOCTOR", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "EXIT_DATE", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "EMPLOYEE_ID_FROM", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "DOCTOR_FROM", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "status_pasien_id", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "THENAME", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "THEADDRESS", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "THEID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "SERIAL_NB", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "ISRJ", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "AGEYEAR", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "AGEMONTH", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "AGEDAY", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "GENDER", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "KARYAWAN", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "MODIFIED_BY", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "MODIFIED_DATE", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "MODIFIED_FROM", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "NUMER", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "NOTA_NO", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "MEASURE_ID2", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "POTONGAN", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "BAYAR", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "RETUR", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "TARIF_TYPE", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "PPNVALUE", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "TAGIHAN", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "KOREKSI", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "AMOUNT_PAID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "DISKON", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "SELL_PRICE", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "ACCOUNT_ID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "subsidi", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "PROFESI", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "EMBALACE", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "DISCOUNT", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "AMOUNT", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "PPN", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "ITER", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "PAYOR_ID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "STATUS_OBAT", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "SUBSIDISAT", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "MARGIN", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "POKOK_JUAL", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "PRINTQ", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "PRINTED_BY", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "STOCK_AVAILABLE", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "STATUS_TARIF", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "PACKAGE_ID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "MODULE_ID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "profession", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "THEORDER", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "CORRECTION_ID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "CORRECTION_BY", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "CASHIER", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "islunas", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "PAY_METHOD_ID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "PAYMENT_DATE", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "ISCETAK", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "print_date", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "DOSE", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "JML_BKS", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "ORIG_DOSE", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "RESEP_KE", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "ITER_KE", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "KUITANSI_ID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "PEMBULATAN", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "KAL_ID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "INVOICE_ID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "SERVICE_TIME", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "TAKEN_TIME", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "modified_datesys", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "TRANS_ID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "SPPBILL", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "SPPBILLDATE", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "SPPBILLUSER", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "SPPKASIR", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "SPPKASIRDATE", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "SPPKASIRUSER", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "SPPPOLI", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "SPPPOLIUSER", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "SPPPOLIDATE", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "NOSEP", false))
            return false;
        return true;
    }

    // Form_CustomValidate
    fV_TREATgrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fV_TREATgrid.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fV_TREATgrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> V_TREAT">
<?php if ($Grid->ShowOtherOptions) { ?>
<div class="card-header ew-grid-upper-panel">
<?php $Grid->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="fV_TREATgrid" class="ew-form ew-list-form form-inline">
<div id="gmp_V_TREAT" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_V_TREATgrid" class="table ew-table"><!-- .ew-table -->
<thead>
    <tr class="ew-table-header">
<?php
// Header row
$Grid->RowType = ROWTYPE_HEADER;

// Render list options
$Grid->renderListOptions();

// Render list options (header, left)
$Grid->ListOptions->render("header", "left");
?>
<?php if ($Grid->ORG_UNIT_CODE->Visible) { // ORG_UNIT_CODE ?>
        <th data-name="ORG_UNIT_CODE" class="<?= $Grid->ORG_UNIT_CODE->headerCellClass() ?>"><div id="elh_V_TREAT_ORG_UNIT_CODE" class="V_TREAT_ORG_UNIT_CODE"><?= $Grid->renderSort($Grid->ORG_UNIT_CODE) ?></div></th>
<?php } ?>
<?php if ($Grid->BILL_ID->Visible) { // BILL_ID ?>
        <th data-name="BILL_ID" class="<?= $Grid->BILL_ID->headerCellClass() ?>"><div id="elh_V_TREAT_BILL_ID" class="V_TREAT_BILL_ID"><?= $Grid->renderSort($Grid->BILL_ID) ?></div></th>
<?php } ?>
<?php if ($Grid->NO_REGISTRATION->Visible) { // NO_REGISTRATION ?>
        <th data-name="NO_REGISTRATION" class="<?= $Grid->NO_REGISTRATION->headerCellClass() ?>"><div id="elh_V_TREAT_NO_REGISTRATION" class="V_TREAT_NO_REGISTRATION"><?= $Grid->renderSort($Grid->NO_REGISTRATION) ?></div></th>
<?php } ?>
<?php if ($Grid->VISIT_ID->Visible) { // VISIT_ID ?>
        <th data-name="VISIT_ID" class="<?= $Grid->VISIT_ID->headerCellClass() ?>"><div id="elh_V_TREAT_VISIT_ID" class="V_TREAT_VISIT_ID"><?= $Grid->renderSort($Grid->VISIT_ID) ?></div></th>
<?php } ?>
<?php if ($Grid->TARIF_ID->Visible) { // TARIF_ID ?>
        <th data-name="TARIF_ID" class="<?= $Grid->TARIF_ID->headerCellClass() ?>"><div id="elh_V_TREAT_TARIF_ID" class="V_TREAT_TARIF_ID"><?= $Grid->renderSort($Grid->TARIF_ID) ?></div></th>
<?php } ?>
<?php if ($Grid->CLASS_ID->Visible) { // CLASS_ID ?>
        <th data-name="CLASS_ID" class="<?= $Grid->CLASS_ID->headerCellClass() ?>"><div id="elh_V_TREAT_CLASS_ID" class="V_TREAT_CLASS_ID"><?= $Grid->renderSort($Grid->CLASS_ID) ?></div></th>
<?php } ?>
<?php if ($Grid->CLINIC_ID->Visible) { // CLINIC_ID ?>
        <th data-name="CLINIC_ID" class="<?= $Grid->CLINIC_ID->headerCellClass() ?>"><div id="elh_V_TREAT_CLINIC_ID" class="V_TREAT_CLINIC_ID"><?= $Grid->renderSort($Grid->CLINIC_ID) ?></div></th>
<?php } ?>
<?php if ($Grid->CLINIC_ID_FROM->Visible) { // CLINIC_ID_FROM ?>
        <th data-name="CLINIC_ID_FROM" class="<?= $Grid->CLINIC_ID_FROM->headerCellClass() ?>"><div id="elh_V_TREAT_CLINIC_ID_FROM" class="V_TREAT_CLINIC_ID_FROM"><?= $Grid->renderSort($Grid->CLINIC_ID_FROM) ?></div></th>
<?php } ?>
<?php if ($Grid->TREATMENT->Visible) { // TREATMENT ?>
        <th data-name="TREATMENT" class="<?= $Grid->TREATMENT->headerCellClass() ?>"><div id="elh_V_TREAT_TREATMENT" class="V_TREAT_TREATMENT"><?= $Grid->renderSort($Grid->TREATMENT) ?></div></th>
<?php } ?>
<?php if ($Grid->TREAT_DATE->Visible) { // TREAT_DATE ?>
        <th data-name="TREAT_DATE" class="<?= $Grid->TREAT_DATE->headerCellClass() ?>"><div id="elh_V_TREAT_TREAT_DATE" class="V_TREAT_TREAT_DATE"><?= $Grid->renderSort($Grid->TREAT_DATE) ?></div></th>
<?php } ?>
<?php if ($Grid->QUANTITY->Visible) { // QUANTITY ?>
        <th data-name="QUANTITY" class="<?= $Grid->QUANTITY->headerCellClass() ?>"><div id="elh_V_TREAT_QUANTITY" class="V_TREAT_QUANTITY"><?= $Grid->renderSort($Grid->QUANTITY) ?></div></th>
<?php } ?>
<?php if ($Grid->MEASURE_ID->Visible) { // MEASURE_ID ?>
        <th data-name="MEASURE_ID" class="<?= $Grid->MEASURE_ID->headerCellClass() ?>"><div id="elh_V_TREAT_MEASURE_ID" class="V_TREAT_MEASURE_ID"><?= $Grid->renderSort($Grid->MEASURE_ID) ?></div></th>
<?php } ?>
<?php if ($Grid->DESCRIPTION->Visible) { // DESCRIPTION ?>
        <th data-name="DESCRIPTION" class="<?= $Grid->DESCRIPTION->headerCellClass() ?>"><div id="elh_V_TREAT_DESCRIPTION" class="V_TREAT_DESCRIPTION"><?= $Grid->renderSort($Grid->DESCRIPTION) ?></div></th>
<?php } ?>
<?php if ($Grid->RESEP_NO->Visible) { // RESEP_NO ?>
        <th data-name="RESEP_NO" class="<?= $Grid->RESEP_NO->headerCellClass() ?>"><div id="elh_V_TREAT_RESEP_NO" class="V_TREAT_RESEP_NO"><?= $Grid->renderSort($Grid->RESEP_NO) ?></div></th>
<?php } ?>
<?php if ($Grid->DOSE_PRESC->Visible) { // DOSE_PRESC ?>
        <th data-name="DOSE_PRESC" class="<?= $Grid->DOSE_PRESC->headerCellClass() ?>"><div id="elh_V_TREAT_DOSE_PRESC" class="V_TREAT_DOSE_PRESC"><?= $Grid->renderSort($Grid->DOSE_PRESC) ?></div></th>
<?php } ?>
<?php if ($Grid->SOLD_STATUS->Visible) { // SOLD_STATUS ?>
        <th data-name="SOLD_STATUS" class="<?= $Grid->SOLD_STATUS->headerCellClass() ?>"><div id="elh_V_TREAT_SOLD_STATUS" class="V_TREAT_SOLD_STATUS"><?= $Grid->renderSort($Grid->SOLD_STATUS) ?></div></th>
<?php } ?>
<?php if ($Grid->RACIKAN->Visible) { // RACIKAN ?>
        <th data-name="RACIKAN" class="<?= $Grid->RACIKAN->headerCellClass() ?>"><div id="elh_V_TREAT_RACIKAN" class="V_TREAT_RACIKAN"><?= $Grid->renderSort($Grid->RACIKAN) ?></div></th>
<?php } ?>
<?php if ($Grid->CLASS_ROOM_ID->Visible) { // CLASS_ROOM_ID ?>
        <th data-name="CLASS_ROOM_ID" class="<?= $Grid->CLASS_ROOM_ID->headerCellClass() ?>"><div id="elh_V_TREAT_CLASS_ROOM_ID" class="V_TREAT_CLASS_ROOM_ID"><?= $Grid->renderSort($Grid->CLASS_ROOM_ID) ?></div></th>
<?php } ?>
<?php if ($Grid->KELUAR_ID->Visible) { // KELUAR_ID ?>
        <th data-name="KELUAR_ID" class="<?= $Grid->KELUAR_ID->headerCellClass() ?>"><div id="elh_V_TREAT_KELUAR_ID" class="V_TREAT_KELUAR_ID"><?= $Grid->renderSort($Grid->KELUAR_ID) ?></div></th>
<?php } ?>
<?php if ($Grid->BED_ID->Visible) { // BED_ID ?>
        <th data-name="BED_ID" class="<?= $Grid->BED_ID->headerCellClass() ?>"><div id="elh_V_TREAT_BED_ID" class="V_TREAT_BED_ID"><?= $Grid->renderSort($Grid->BED_ID) ?></div></th>
<?php } ?>
<?php if ($Grid->EMPLOYEE_ID->Visible) { // EMPLOYEE_ID ?>
        <th data-name="EMPLOYEE_ID" class="<?= $Grid->EMPLOYEE_ID->headerCellClass() ?>"><div id="elh_V_TREAT_EMPLOYEE_ID" class="V_TREAT_EMPLOYEE_ID"><?= $Grid->renderSort($Grid->EMPLOYEE_ID) ?></div></th>
<?php } ?>
<?php if ($Grid->DESCRIPTION2->Visible) { // DESCRIPTION2 ?>
        <th data-name="DESCRIPTION2" class="<?= $Grid->DESCRIPTION2->headerCellClass() ?>"><div id="elh_V_TREAT_DESCRIPTION2" class="V_TREAT_DESCRIPTION2"><?= $Grid->renderSort($Grid->DESCRIPTION2) ?></div></th>
<?php } ?>
<?php if ($Grid->BRAND_ID->Visible) { // BRAND_ID ?>
        <th data-name="BRAND_ID" class="<?= $Grid->BRAND_ID->headerCellClass() ?>"><div id="elh_V_TREAT_BRAND_ID" class="V_TREAT_BRAND_ID"><?= $Grid->renderSort($Grid->BRAND_ID) ?></div></th>
<?php } ?>
<?php if ($Grid->DOCTOR->Visible) { // DOCTOR ?>
        <th data-name="DOCTOR" class="<?= $Grid->DOCTOR->headerCellClass() ?>"><div id="elh_V_TREAT_DOCTOR" class="V_TREAT_DOCTOR"><?= $Grid->renderSort($Grid->DOCTOR) ?></div></th>
<?php } ?>
<?php if ($Grid->EXIT_DATE->Visible) { // EXIT_DATE ?>
        <th data-name="EXIT_DATE" class="<?= $Grid->EXIT_DATE->headerCellClass() ?>"><div id="elh_V_TREAT_EXIT_DATE" class="V_TREAT_EXIT_DATE"><?= $Grid->renderSort($Grid->EXIT_DATE) ?></div></th>
<?php } ?>
<?php if ($Grid->EMPLOYEE_ID_FROM->Visible) { // EMPLOYEE_ID_FROM ?>
        <th data-name="EMPLOYEE_ID_FROM" class="<?= $Grid->EMPLOYEE_ID_FROM->headerCellClass() ?>"><div id="elh_V_TREAT_EMPLOYEE_ID_FROM" class="V_TREAT_EMPLOYEE_ID_FROM"><?= $Grid->renderSort($Grid->EMPLOYEE_ID_FROM) ?></div></th>
<?php } ?>
<?php if ($Grid->DOCTOR_FROM->Visible) { // DOCTOR_FROM ?>
        <th data-name="DOCTOR_FROM" class="<?= $Grid->DOCTOR_FROM->headerCellClass() ?>"><div id="elh_V_TREAT_DOCTOR_FROM" class="V_TREAT_DOCTOR_FROM"><?= $Grid->renderSort($Grid->DOCTOR_FROM) ?></div></th>
<?php } ?>
<?php if ($Grid->status_pasien_id->Visible) { // status_pasien_id ?>
        <th data-name="status_pasien_id" class="<?= $Grid->status_pasien_id->headerCellClass() ?>"><div id="elh_V_TREAT_status_pasien_id" class="V_TREAT_status_pasien_id"><?= $Grid->renderSort($Grid->status_pasien_id) ?></div></th>
<?php } ?>
<?php if ($Grid->THENAME->Visible) { // THENAME ?>
        <th data-name="THENAME" class="<?= $Grid->THENAME->headerCellClass() ?>"><div id="elh_V_TREAT_THENAME" class="V_TREAT_THENAME"><?= $Grid->renderSort($Grid->THENAME) ?></div></th>
<?php } ?>
<?php if ($Grid->THEADDRESS->Visible) { // THEADDRESS ?>
        <th data-name="THEADDRESS" class="<?= $Grid->THEADDRESS->headerCellClass() ?>"><div id="elh_V_TREAT_THEADDRESS" class="V_TREAT_THEADDRESS"><?= $Grid->renderSort($Grid->THEADDRESS) ?></div></th>
<?php } ?>
<?php if ($Grid->THEID->Visible) { // THEID ?>
        <th data-name="THEID" class="<?= $Grid->THEID->headerCellClass() ?>"><div id="elh_V_TREAT_THEID" class="V_TREAT_THEID"><?= $Grid->renderSort($Grid->THEID) ?></div></th>
<?php } ?>
<?php if ($Grid->SERIAL_NB->Visible) { // SERIAL_NB ?>
        <th data-name="SERIAL_NB" class="<?= $Grid->SERIAL_NB->headerCellClass() ?>"><div id="elh_V_TREAT_SERIAL_NB" class="V_TREAT_SERIAL_NB"><?= $Grid->renderSort($Grid->SERIAL_NB) ?></div></th>
<?php } ?>
<?php if ($Grid->ISRJ->Visible) { // ISRJ ?>
        <th data-name="ISRJ" class="<?= $Grid->ISRJ->headerCellClass() ?>"><div id="elh_V_TREAT_ISRJ" class="V_TREAT_ISRJ"><?= $Grid->renderSort($Grid->ISRJ) ?></div></th>
<?php } ?>
<?php if ($Grid->AGEYEAR->Visible) { // AGEYEAR ?>
        <th data-name="AGEYEAR" class="<?= $Grid->AGEYEAR->headerCellClass() ?>"><div id="elh_V_TREAT_AGEYEAR" class="V_TREAT_AGEYEAR"><?= $Grid->renderSort($Grid->AGEYEAR) ?></div></th>
<?php } ?>
<?php if ($Grid->AGEMONTH->Visible) { // AGEMONTH ?>
        <th data-name="AGEMONTH" class="<?= $Grid->AGEMONTH->headerCellClass() ?>"><div id="elh_V_TREAT_AGEMONTH" class="V_TREAT_AGEMONTH"><?= $Grid->renderSort($Grid->AGEMONTH) ?></div></th>
<?php } ?>
<?php if ($Grid->AGEDAY->Visible) { // AGEDAY ?>
        <th data-name="AGEDAY" class="<?= $Grid->AGEDAY->headerCellClass() ?>"><div id="elh_V_TREAT_AGEDAY" class="V_TREAT_AGEDAY"><?= $Grid->renderSort($Grid->AGEDAY) ?></div></th>
<?php } ?>
<?php if ($Grid->GENDER->Visible) { // GENDER ?>
        <th data-name="GENDER" class="<?= $Grid->GENDER->headerCellClass() ?>"><div id="elh_V_TREAT_GENDER" class="V_TREAT_GENDER"><?= $Grid->renderSort($Grid->GENDER) ?></div></th>
<?php } ?>
<?php if ($Grid->KARYAWAN->Visible) { // KARYAWAN ?>
        <th data-name="KARYAWAN" class="<?= $Grid->KARYAWAN->headerCellClass() ?>"><div id="elh_V_TREAT_KARYAWAN" class="V_TREAT_KARYAWAN"><?= $Grid->renderSort($Grid->KARYAWAN) ?></div></th>
<?php } ?>
<?php if ($Grid->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
        <th data-name="MODIFIED_BY" class="<?= $Grid->MODIFIED_BY->headerCellClass() ?>"><div id="elh_V_TREAT_MODIFIED_BY" class="V_TREAT_MODIFIED_BY"><?= $Grid->renderSort($Grid->MODIFIED_BY) ?></div></th>
<?php } ?>
<?php if ($Grid->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
        <th data-name="MODIFIED_DATE" class="<?= $Grid->MODIFIED_DATE->headerCellClass() ?>"><div id="elh_V_TREAT_MODIFIED_DATE" class="V_TREAT_MODIFIED_DATE"><?= $Grid->renderSort($Grid->MODIFIED_DATE) ?></div></th>
<?php } ?>
<?php if ($Grid->MODIFIED_FROM->Visible) { // MODIFIED_FROM ?>
        <th data-name="MODIFIED_FROM" class="<?= $Grid->MODIFIED_FROM->headerCellClass() ?>"><div id="elh_V_TREAT_MODIFIED_FROM" class="V_TREAT_MODIFIED_FROM"><?= $Grid->renderSort($Grid->MODIFIED_FROM) ?></div></th>
<?php } ?>
<?php if ($Grid->NUMER->Visible) { // NUMER ?>
        <th data-name="NUMER" class="<?= $Grid->NUMER->headerCellClass() ?>"><div id="elh_V_TREAT_NUMER" class="V_TREAT_NUMER"><?= $Grid->renderSort($Grid->NUMER) ?></div></th>
<?php } ?>
<?php if ($Grid->NOTA_NO->Visible) { // NOTA_NO ?>
        <th data-name="NOTA_NO" class="<?= $Grid->NOTA_NO->headerCellClass() ?>"><div id="elh_V_TREAT_NOTA_NO" class="V_TREAT_NOTA_NO"><?= $Grid->renderSort($Grid->NOTA_NO) ?></div></th>
<?php } ?>
<?php if ($Grid->MEASURE_ID2->Visible) { // MEASURE_ID2 ?>
        <th data-name="MEASURE_ID2" class="<?= $Grid->MEASURE_ID2->headerCellClass() ?>"><div id="elh_V_TREAT_MEASURE_ID2" class="V_TREAT_MEASURE_ID2"><?= $Grid->renderSort($Grid->MEASURE_ID2) ?></div></th>
<?php } ?>
<?php if ($Grid->POTONGAN->Visible) { // POTONGAN ?>
        <th data-name="POTONGAN" class="<?= $Grid->POTONGAN->headerCellClass() ?>"><div id="elh_V_TREAT_POTONGAN" class="V_TREAT_POTONGAN"><?= $Grid->renderSort($Grid->POTONGAN) ?></div></th>
<?php } ?>
<?php if ($Grid->BAYAR->Visible) { // BAYAR ?>
        <th data-name="BAYAR" class="<?= $Grid->BAYAR->headerCellClass() ?>"><div id="elh_V_TREAT_BAYAR" class="V_TREAT_BAYAR"><?= $Grid->renderSort($Grid->BAYAR) ?></div></th>
<?php } ?>
<?php if ($Grid->RETUR->Visible) { // RETUR ?>
        <th data-name="RETUR" class="<?= $Grid->RETUR->headerCellClass() ?>"><div id="elh_V_TREAT_RETUR" class="V_TREAT_RETUR"><?= $Grid->renderSort($Grid->RETUR) ?></div></th>
<?php } ?>
<?php if ($Grid->TARIF_TYPE->Visible) { // TARIF_TYPE ?>
        <th data-name="TARIF_TYPE" class="<?= $Grid->TARIF_TYPE->headerCellClass() ?>"><div id="elh_V_TREAT_TARIF_TYPE" class="V_TREAT_TARIF_TYPE"><?= $Grid->renderSort($Grid->TARIF_TYPE) ?></div></th>
<?php } ?>
<?php if ($Grid->PPNVALUE->Visible) { // PPNVALUE ?>
        <th data-name="PPNVALUE" class="<?= $Grid->PPNVALUE->headerCellClass() ?>"><div id="elh_V_TREAT_PPNVALUE" class="V_TREAT_PPNVALUE"><?= $Grid->renderSort($Grid->PPNVALUE) ?></div></th>
<?php } ?>
<?php if ($Grid->TAGIHAN->Visible) { // TAGIHAN ?>
        <th data-name="TAGIHAN" class="<?= $Grid->TAGIHAN->headerCellClass() ?>"><div id="elh_V_TREAT_TAGIHAN" class="V_TREAT_TAGIHAN"><?= $Grid->renderSort($Grid->TAGIHAN) ?></div></th>
<?php } ?>
<?php if ($Grid->KOREKSI->Visible) { // KOREKSI ?>
        <th data-name="KOREKSI" class="<?= $Grid->KOREKSI->headerCellClass() ?>"><div id="elh_V_TREAT_KOREKSI" class="V_TREAT_KOREKSI"><?= $Grid->renderSort($Grid->KOREKSI) ?></div></th>
<?php } ?>
<?php if ($Grid->AMOUNT_PAID->Visible) { // AMOUNT_PAID ?>
        <th data-name="AMOUNT_PAID" class="<?= $Grid->AMOUNT_PAID->headerCellClass() ?>"><div id="elh_V_TREAT_AMOUNT_PAID" class="V_TREAT_AMOUNT_PAID"><?= $Grid->renderSort($Grid->AMOUNT_PAID) ?></div></th>
<?php } ?>
<?php if ($Grid->DISKON->Visible) { // DISKON ?>
        <th data-name="DISKON" class="<?= $Grid->DISKON->headerCellClass() ?>"><div id="elh_V_TREAT_DISKON" class="V_TREAT_DISKON"><?= $Grid->renderSort($Grid->DISKON) ?></div></th>
<?php } ?>
<?php if ($Grid->SELL_PRICE->Visible) { // SELL_PRICE ?>
        <th data-name="SELL_PRICE" class="<?= $Grid->SELL_PRICE->headerCellClass() ?>"><div id="elh_V_TREAT_SELL_PRICE" class="V_TREAT_SELL_PRICE"><?= $Grid->renderSort($Grid->SELL_PRICE) ?></div></th>
<?php } ?>
<?php if ($Grid->ACCOUNT_ID->Visible) { // ACCOUNT_ID ?>
        <th data-name="ACCOUNT_ID" class="<?= $Grid->ACCOUNT_ID->headerCellClass() ?>"><div id="elh_V_TREAT_ACCOUNT_ID" class="V_TREAT_ACCOUNT_ID"><?= $Grid->renderSort($Grid->ACCOUNT_ID) ?></div></th>
<?php } ?>
<?php if ($Grid->subsidi->Visible) { // subsidi ?>
        <th data-name="subsidi" class="<?= $Grid->subsidi->headerCellClass() ?>"><div id="elh_V_TREAT_subsidi" class="V_TREAT_subsidi"><?= $Grid->renderSort($Grid->subsidi) ?></div></th>
<?php } ?>
<?php if ($Grid->PROFESI->Visible) { // PROFESI ?>
        <th data-name="PROFESI" class="<?= $Grid->PROFESI->headerCellClass() ?>"><div id="elh_V_TREAT_PROFESI" class="V_TREAT_PROFESI"><?= $Grid->renderSort($Grid->PROFESI) ?></div></th>
<?php } ?>
<?php if ($Grid->EMBALACE->Visible) { // EMBALACE ?>
        <th data-name="EMBALACE" class="<?= $Grid->EMBALACE->headerCellClass() ?>"><div id="elh_V_TREAT_EMBALACE" class="V_TREAT_EMBALACE"><?= $Grid->renderSort($Grid->EMBALACE) ?></div></th>
<?php } ?>
<?php if ($Grid->DISCOUNT->Visible) { // DISCOUNT ?>
        <th data-name="DISCOUNT" class="<?= $Grid->DISCOUNT->headerCellClass() ?>"><div id="elh_V_TREAT_DISCOUNT" class="V_TREAT_DISCOUNT"><?= $Grid->renderSort($Grid->DISCOUNT) ?></div></th>
<?php } ?>
<?php if ($Grid->AMOUNT->Visible) { // AMOUNT ?>
        <th data-name="AMOUNT" class="<?= $Grid->AMOUNT->headerCellClass() ?>"><div id="elh_V_TREAT_AMOUNT" class="V_TREAT_AMOUNT"><?= $Grid->renderSort($Grid->AMOUNT) ?></div></th>
<?php } ?>
<?php if ($Grid->PPN->Visible) { // PPN ?>
        <th data-name="PPN" class="<?= $Grid->PPN->headerCellClass() ?>"><div id="elh_V_TREAT_PPN" class="V_TREAT_PPN"><?= $Grid->renderSort($Grid->PPN) ?></div></th>
<?php } ?>
<?php if ($Grid->ITER->Visible) { // ITER ?>
        <th data-name="ITER" class="<?= $Grid->ITER->headerCellClass() ?>"><div id="elh_V_TREAT_ITER" class="V_TREAT_ITER"><?= $Grid->renderSort($Grid->ITER) ?></div></th>
<?php } ?>
<?php if ($Grid->PAYOR_ID->Visible) { // PAYOR_ID ?>
        <th data-name="PAYOR_ID" class="<?= $Grid->PAYOR_ID->headerCellClass() ?>"><div id="elh_V_TREAT_PAYOR_ID" class="V_TREAT_PAYOR_ID"><?= $Grid->renderSort($Grid->PAYOR_ID) ?></div></th>
<?php } ?>
<?php if ($Grid->STATUS_OBAT->Visible) { // STATUS_OBAT ?>
        <th data-name="STATUS_OBAT" class="<?= $Grid->STATUS_OBAT->headerCellClass() ?>"><div id="elh_V_TREAT_STATUS_OBAT" class="V_TREAT_STATUS_OBAT"><?= $Grid->renderSort($Grid->STATUS_OBAT) ?></div></th>
<?php } ?>
<?php if ($Grid->SUBSIDISAT->Visible) { // SUBSIDISAT ?>
        <th data-name="SUBSIDISAT" class="<?= $Grid->SUBSIDISAT->headerCellClass() ?>"><div id="elh_V_TREAT_SUBSIDISAT" class="V_TREAT_SUBSIDISAT"><?= $Grid->renderSort($Grid->SUBSIDISAT) ?></div></th>
<?php } ?>
<?php if ($Grid->MARGIN->Visible) { // MARGIN ?>
        <th data-name="MARGIN" class="<?= $Grid->MARGIN->headerCellClass() ?>"><div id="elh_V_TREAT_MARGIN" class="V_TREAT_MARGIN"><?= $Grid->renderSort($Grid->MARGIN) ?></div></th>
<?php } ?>
<?php if ($Grid->POKOK_JUAL->Visible) { // POKOK_JUAL ?>
        <th data-name="POKOK_JUAL" class="<?= $Grid->POKOK_JUAL->headerCellClass() ?>"><div id="elh_V_TREAT_POKOK_JUAL" class="V_TREAT_POKOK_JUAL"><?= $Grid->renderSort($Grid->POKOK_JUAL) ?></div></th>
<?php } ?>
<?php if ($Grid->PRINTQ->Visible) { // PRINTQ ?>
        <th data-name="PRINTQ" class="<?= $Grid->PRINTQ->headerCellClass() ?>"><div id="elh_V_TREAT_PRINTQ" class="V_TREAT_PRINTQ"><?= $Grid->renderSort($Grid->PRINTQ) ?></div></th>
<?php } ?>
<?php if ($Grid->PRINTED_BY->Visible) { // PRINTED_BY ?>
        <th data-name="PRINTED_BY" class="<?= $Grid->PRINTED_BY->headerCellClass() ?>"><div id="elh_V_TREAT_PRINTED_BY" class="V_TREAT_PRINTED_BY"><?= $Grid->renderSort($Grid->PRINTED_BY) ?></div></th>
<?php } ?>
<?php if ($Grid->STOCK_AVAILABLE->Visible) { // STOCK_AVAILABLE ?>
        <th data-name="STOCK_AVAILABLE" class="<?= $Grid->STOCK_AVAILABLE->headerCellClass() ?>"><div id="elh_V_TREAT_STOCK_AVAILABLE" class="V_TREAT_STOCK_AVAILABLE"><?= $Grid->renderSort($Grid->STOCK_AVAILABLE) ?></div></th>
<?php } ?>
<?php if ($Grid->STATUS_TARIF->Visible) { // STATUS_TARIF ?>
        <th data-name="STATUS_TARIF" class="<?= $Grid->STATUS_TARIF->headerCellClass() ?>"><div id="elh_V_TREAT_STATUS_TARIF" class="V_TREAT_STATUS_TARIF"><?= $Grid->renderSort($Grid->STATUS_TARIF) ?></div></th>
<?php } ?>
<?php if ($Grid->PACKAGE_ID->Visible) { // PACKAGE_ID ?>
        <th data-name="PACKAGE_ID" class="<?= $Grid->PACKAGE_ID->headerCellClass() ?>"><div id="elh_V_TREAT_PACKAGE_ID" class="V_TREAT_PACKAGE_ID"><?= $Grid->renderSort($Grid->PACKAGE_ID) ?></div></th>
<?php } ?>
<?php if ($Grid->MODULE_ID->Visible) { // MODULE_ID ?>
        <th data-name="MODULE_ID" class="<?= $Grid->MODULE_ID->headerCellClass() ?>"><div id="elh_V_TREAT_MODULE_ID" class="V_TREAT_MODULE_ID"><?= $Grid->renderSort($Grid->MODULE_ID) ?></div></th>
<?php } ?>
<?php if ($Grid->profession->Visible) { // profession ?>
        <th data-name="profession" class="<?= $Grid->profession->headerCellClass() ?>"><div id="elh_V_TREAT_profession" class="V_TREAT_profession"><?= $Grid->renderSort($Grid->profession) ?></div></th>
<?php } ?>
<?php if ($Grid->THEORDER->Visible) { // THEORDER ?>
        <th data-name="THEORDER" class="<?= $Grid->THEORDER->headerCellClass() ?>"><div id="elh_V_TREAT_THEORDER" class="V_TREAT_THEORDER"><?= $Grid->renderSort($Grid->THEORDER) ?></div></th>
<?php } ?>
<?php if ($Grid->CORRECTION_ID->Visible) { // CORRECTION_ID ?>
        <th data-name="CORRECTION_ID" class="<?= $Grid->CORRECTION_ID->headerCellClass() ?>"><div id="elh_V_TREAT_CORRECTION_ID" class="V_TREAT_CORRECTION_ID"><?= $Grid->renderSort($Grid->CORRECTION_ID) ?></div></th>
<?php } ?>
<?php if ($Grid->CORRECTION_BY->Visible) { // CORRECTION_BY ?>
        <th data-name="CORRECTION_BY" class="<?= $Grid->CORRECTION_BY->headerCellClass() ?>"><div id="elh_V_TREAT_CORRECTION_BY" class="V_TREAT_CORRECTION_BY"><?= $Grid->renderSort($Grid->CORRECTION_BY) ?></div></th>
<?php } ?>
<?php if ($Grid->CASHIER->Visible) { // CASHIER ?>
        <th data-name="CASHIER" class="<?= $Grid->CASHIER->headerCellClass() ?>"><div id="elh_V_TREAT_CASHIER" class="V_TREAT_CASHIER"><?= $Grid->renderSort($Grid->CASHIER) ?></div></th>
<?php } ?>
<?php if ($Grid->islunas->Visible) { // islunas ?>
        <th data-name="islunas" class="<?= $Grid->islunas->headerCellClass() ?>"><div id="elh_V_TREAT_islunas" class="V_TREAT_islunas"><?= $Grid->renderSort($Grid->islunas) ?></div></th>
<?php } ?>
<?php if ($Grid->PAY_METHOD_ID->Visible) { // PAY_METHOD_ID ?>
        <th data-name="PAY_METHOD_ID" class="<?= $Grid->PAY_METHOD_ID->headerCellClass() ?>"><div id="elh_V_TREAT_PAY_METHOD_ID" class="V_TREAT_PAY_METHOD_ID"><?= $Grid->renderSort($Grid->PAY_METHOD_ID) ?></div></th>
<?php } ?>
<?php if ($Grid->PAYMENT_DATE->Visible) { // PAYMENT_DATE ?>
        <th data-name="PAYMENT_DATE" class="<?= $Grid->PAYMENT_DATE->headerCellClass() ?>"><div id="elh_V_TREAT_PAYMENT_DATE" class="V_TREAT_PAYMENT_DATE"><?= $Grid->renderSort($Grid->PAYMENT_DATE) ?></div></th>
<?php } ?>
<?php if ($Grid->ISCETAK->Visible) { // ISCETAK ?>
        <th data-name="ISCETAK" class="<?= $Grid->ISCETAK->headerCellClass() ?>"><div id="elh_V_TREAT_ISCETAK" class="V_TREAT_ISCETAK"><?= $Grid->renderSort($Grid->ISCETAK) ?></div></th>
<?php } ?>
<?php if ($Grid->print_date->Visible) { // print_date ?>
        <th data-name="print_date" class="<?= $Grid->print_date->headerCellClass() ?>"><div id="elh_V_TREAT_print_date" class="V_TREAT_print_date"><?= $Grid->renderSort($Grid->print_date) ?></div></th>
<?php } ?>
<?php if ($Grid->DOSE->Visible) { // DOSE ?>
        <th data-name="DOSE" class="<?= $Grid->DOSE->headerCellClass() ?>"><div id="elh_V_TREAT_DOSE" class="V_TREAT_DOSE"><?= $Grid->renderSort($Grid->DOSE) ?></div></th>
<?php } ?>
<?php if ($Grid->JML_BKS->Visible) { // JML_BKS ?>
        <th data-name="JML_BKS" class="<?= $Grid->JML_BKS->headerCellClass() ?>"><div id="elh_V_TREAT_JML_BKS" class="V_TREAT_JML_BKS"><?= $Grid->renderSort($Grid->JML_BKS) ?></div></th>
<?php } ?>
<?php if ($Grid->ORIG_DOSE->Visible) { // ORIG_DOSE ?>
        <th data-name="ORIG_DOSE" class="<?= $Grid->ORIG_DOSE->headerCellClass() ?>"><div id="elh_V_TREAT_ORIG_DOSE" class="V_TREAT_ORIG_DOSE"><?= $Grid->renderSort($Grid->ORIG_DOSE) ?></div></th>
<?php } ?>
<?php if ($Grid->RESEP_KE->Visible) { // RESEP_KE ?>
        <th data-name="RESEP_KE" class="<?= $Grid->RESEP_KE->headerCellClass() ?>"><div id="elh_V_TREAT_RESEP_KE" class="V_TREAT_RESEP_KE"><?= $Grid->renderSort($Grid->RESEP_KE) ?></div></th>
<?php } ?>
<?php if ($Grid->ITER_KE->Visible) { // ITER_KE ?>
        <th data-name="ITER_KE" class="<?= $Grid->ITER_KE->headerCellClass() ?>"><div id="elh_V_TREAT_ITER_KE" class="V_TREAT_ITER_KE"><?= $Grid->renderSort($Grid->ITER_KE) ?></div></th>
<?php } ?>
<?php if ($Grid->KUITANSI_ID->Visible) { // KUITANSI_ID ?>
        <th data-name="KUITANSI_ID" class="<?= $Grid->KUITANSI_ID->headerCellClass() ?>"><div id="elh_V_TREAT_KUITANSI_ID" class="V_TREAT_KUITANSI_ID"><?= $Grid->renderSort($Grid->KUITANSI_ID) ?></div></th>
<?php } ?>
<?php if ($Grid->PEMBULATAN->Visible) { // PEMBULATAN ?>
        <th data-name="PEMBULATAN" class="<?= $Grid->PEMBULATAN->headerCellClass() ?>"><div id="elh_V_TREAT_PEMBULATAN" class="V_TREAT_PEMBULATAN"><?= $Grid->renderSort($Grid->PEMBULATAN) ?></div></th>
<?php } ?>
<?php if ($Grid->KAL_ID->Visible) { // KAL_ID ?>
        <th data-name="KAL_ID" class="<?= $Grid->KAL_ID->headerCellClass() ?>"><div id="elh_V_TREAT_KAL_ID" class="V_TREAT_KAL_ID"><?= $Grid->renderSort($Grid->KAL_ID) ?></div></th>
<?php } ?>
<?php if ($Grid->INVOICE_ID->Visible) { // INVOICE_ID ?>
        <th data-name="INVOICE_ID" class="<?= $Grid->INVOICE_ID->headerCellClass() ?>"><div id="elh_V_TREAT_INVOICE_ID" class="V_TREAT_INVOICE_ID"><?= $Grid->renderSort($Grid->INVOICE_ID) ?></div></th>
<?php } ?>
<?php if ($Grid->SERVICE_TIME->Visible) { // SERVICE_TIME ?>
        <th data-name="SERVICE_TIME" class="<?= $Grid->SERVICE_TIME->headerCellClass() ?>"><div id="elh_V_TREAT_SERVICE_TIME" class="V_TREAT_SERVICE_TIME"><?= $Grid->renderSort($Grid->SERVICE_TIME) ?></div></th>
<?php } ?>
<?php if ($Grid->TAKEN_TIME->Visible) { // TAKEN_TIME ?>
        <th data-name="TAKEN_TIME" class="<?= $Grid->TAKEN_TIME->headerCellClass() ?>"><div id="elh_V_TREAT_TAKEN_TIME" class="V_TREAT_TAKEN_TIME"><?= $Grid->renderSort($Grid->TAKEN_TIME) ?></div></th>
<?php } ?>
<?php if ($Grid->modified_datesys->Visible) { // modified_datesys ?>
        <th data-name="modified_datesys" class="<?= $Grid->modified_datesys->headerCellClass() ?>"><div id="elh_V_TREAT_modified_datesys" class="V_TREAT_modified_datesys"><?= $Grid->renderSort($Grid->modified_datesys) ?></div></th>
<?php } ?>
<?php if ($Grid->TRANS_ID->Visible) { // TRANS_ID ?>
        <th data-name="TRANS_ID" class="<?= $Grid->TRANS_ID->headerCellClass() ?>"><div id="elh_V_TREAT_TRANS_ID" class="V_TREAT_TRANS_ID"><?= $Grid->renderSort($Grid->TRANS_ID) ?></div></th>
<?php } ?>
<?php if ($Grid->SPPBILL->Visible) { // SPPBILL ?>
        <th data-name="SPPBILL" class="<?= $Grid->SPPBILL->headerCellClass() ?>"><div id="elh_V_TREAT_SPPBILL" class="V_TREAT_SPPBILL"><?= $Grid->renderSort($Grid->SPPBILL) ?></div></th>
<?php } ?>
<?php if ($Grid->SPPBILLDATE->Visible) { // SPPBILLDATE ?>
        <th data-name="SPPBILLDATE" class="<?= $Grid->SPPBILLDATE->headerCellClass() ?>"><div id="elh_V_TREAT_SPPBILLDATE" class="V_TREAT_SPPBILLDATE"><?= $Grid->renderSort($Grid->SPPBILLDATE) ?></div></th>
<?php } ?>
<?php if ($Grid->SPPBILLUSER->Visible) { // SPPBILLUSER ?>
        <th data-name="SPPBILLUSER" class="<?= $Grid->SPPBILLUSER->headerCellClass() ?>"><div id="elh_V_TREAT_SPPBILLUSER" class="V_TREAT_SPPBILLUSER"><?= $Grid->renderSort($Grid->SPPBILLUSER) ?></div></th>
<?php } ?>
<?php if ($Grid->SPPKASIR->Visible) { // SPPKASIR ?>
        <th data-name="SPPKASIR" class="<?= $Grid->SPPKASIR->headerCellClass() ?>"><div id="elh_V_TREAT_SPPKASIR" class="V_TREAT_SPPKASIR"><?= $Grid->renderSort($Grid->SPPKASIR) ?></div></th>
<?php } ?>
<?php if ($Grid->SPPKASIRDATE->Visible) { // SPPKASIRDATE ?>
        <th data-name="SPPKASIRDATE" class="<?= $Grid->SPPKASIRDATE->headerCellClass() ?>"><div id="elh_V_TREAT_SPPKASIRDATE" class="V_TREAT_SPPKASIRDATE"><?= $Grid->renderSort($Grid->SPPKASIRDATE) ?></div></th>
<?php } ?>
<?php if ($Grid->SPPKASIRUSER->Visible) { // SPPKASIRUSER ?>
        <th data-name="SPPKASIRUSER" class="<?= $Grid->SPPKASIRUSER->headerCellClass() ?>"><div id="elh_V_TREAT_SPPKASIRUSER" class="V_TREAT_SPPKASIRUSER"><?= $Grid->renderSort($Grid->SPPKASIRUSER) ?></div></th>
<?php } ?>
<?php if ($Grid->SPPPOLI->Visible) { // SPPPOLI ?>
        <th data-name="SPPPOLI" class="<?= $Grid->SPPPOLI->headerCellClass() ?>"><div id="elh_V_TREAT_SPPPOLI" class="V_TREAT_SPPPOLI"><?= $Grid->renderSort($Grid->SPPPOLI) ?></div></th>
<?php } ?>
<?php if ($Grid->SPPPOLIUSER->Visible) { // SPPPOLIUSER ?>
        <th data-name="SPPPOLIUSER" class="<?= $Grid->SPPPOLIUSER->headerCellClass() ?>"><div id="elh_V_TREAT_SPPPOLIUSER" class="V_TREAT_SPPPOLIUSER"><?= $Grid->renderSort($Grid->SPPPOLIUSER) ?></div></th>
<?php } ?>
<?php if ($Grid->SPPPOLIDATE->Visible) { // SPPPOLIDATE ?>
        <th data-name="SPPPOLIDATE" class="<?= $Grid->SPPPOLIDATE->headerCellClass() ?>"><div id="elh_V_TREAT_SPPPOLIDATE" class="V_TREAT_SPPPOLIDATE"><?= $Grid->renderSort($Grid->SPPPOLIDATE) ?></div></th>
<?php } ?>
<?php if ($Grid->NOSEP->Visible) { // NOSEP ?>
        <th data-name="NOSEP" class="<?= $Grid->NOSEP->headerCellClass() ?>"><div id="elh_V_TREAT_NOSEP" class="V_TREAT_NOSEP"><?= $Grid->renderSort($Grid->NOSEP) ?></div></th>
<?php } ?>
<?php if ($Grid->ID->Visible) { // ID ?>
        <th data-name="ID" class="<?= $Grid->ID->headerCellClass() ?>"><div id="elh_V_TREAT_ID" class="V_TREAT_ID"><?= $Grid->renderSort($Grid->ID) ?></div></th>
<?php } ?>
<?php
// Render list options (header, right)
$Grid->ListOptions->render("header", "right");
?>
    </tr>
</thead>
<tbody>
<?php
$Grid->StartRecord = 1;
$Grid->StopRecord = $Grid->TotalRecords; // Show all records

// Restore number of post back records
if ($CurrentForm && ($Grid->isConfirm() || $Grid->EventCancelled)) {
    $CurrentForm->Index = -1;
    if ($CurrentForm->hasValue($Grid->FormKeyCountName) && ($Grid->isGridAdd() || $Grid->isGridEdit() || $Grid->isConfirm())) {
        $Grid->KeyCount = $CurrentForm->getValue($Grid->FormKeyCountName);
        $Grid->StopRecord = $Grid->StartRecord + $Grid->KeyCount - 1;
    }
}
$Grid->RecordCount = $Grid->StartRecord - 1;
if ($Grid->Recordset && !$Grid->Recordset->EOF) {
    // Nothing to do
} elseif (!$Grid->AllowAddDeleteRow && $Grid->StopRecord == 0) {
    $Grid->StopRecord = $Grid->GridAddRowCount;
}

// Initialize aggregate
$Grid->RowType = ROWTYPE_AGGREGATEINIT;
$Grid->resetAttributes();
$Grid->renderRow();
if ($Grid->isGridAdd())
    $Grid->RowIndex = 0;
if ($Grid->isGridEdit())
    $Grid->RowIndex = 0;
while ($Grid->RecordCount < $Grid->StopRecord) {
    $Grid->RecordCount++;
    if ($Grid->RecordCount >= $Grid->StartRecord) {
        $Grid->RowCount++;
        if ($Grid->isGridAdd() || $Grid->isGridEdit() || $Grid->isConfirm()) {
            $Grid->RowIndex++;
            $CurrentForm->Index = $Grid->RowIndex;
            if ($CurrentForm->hasValue($Grid->FormActionName) && ($Grid->isConfirm() || $Grid->EventCancelled)) {
                $Grid->RowAction = strval($CurrentForm->getValue($Grid->FormActionName));
            } elseif ($Grid->isGridAdd()) {
                $Grid->RowAction = "insert";
            } else {
                $Grid->RowAction = "";
            }
        }

        // Set up key count
        $Grid->KeyCount = $Grid->RowIndex;

        // Init row class and style
        $Grid->resetAttributes();
        $Grid->CssClass = "";
        if ($Grid->isGridAdd()) {
            if ($Grid->CurrentMode == "copy") {
                $Grid->loadRowValues($Grid->Recordset); // Load row values
                $Grid->OldKey = $Grid->getKey(true); // Get from CurrentValue
            } else {
                $Grid->loadRowValues(); // Load default values
                $Grid->OldKey = "";
            }
        } else {
            $Grid->loadRowValues($Grid->Recordset); // Load row values
            $Grid->OldKey = $Grid->getKey(true); // Get from CurrentValue
        }
        $Grid->setKey($Grid->OldKey);
        $Grid->RowType = ROWTYPE_VIEW; // Render view
        if ($Grid->isGridAdd()) { // Grid add
            $Grid->RowType = ROWTYPE_ADD; // Render add
        }
        if ($Grid->isGridAdd() && $Grid->EventCancelled && !$CurrentForm->hasValue("k_blankrow")) { // Insert failed
            $Grid->restoreCurrentRowFormValues($Grid->RowIndex); // Restore form values
        }
        if ($Grid->isGridEdit()) { // Grid edit
            if ($Grid->EventCancelled) {
                $Grid->restoreCurrentRowFormValues($Grid->RowIndex); // Restore form values
            }
            if ($Grid->RowAction == "insert") {
                $Grid->RowType = ROWTYPE_ADD; // Render add
            } else {
                $Grid->RowType = ROWTYPE_EDIT; // Render edit
            }
        }
        if ($Grid->isGridEdit() && ($Grid->RowType == ROWTYPE_EDIT || $Grid->RowType == ROWTYPE_ADD) && $Grid->EventCancelled) { // Update failed
            $Grid->restoreCurrentRowFormValues($Grid->RowIndex); // Restore form values
        }
        if ($Grid->RowType == ROWTYPE_EDIT) { // Edit row
            $Grid->EditRowCount++;
        }
        if ($Grid->isConfirm()) { // Confirm row
            $Grid->restoreCurrentRowFormValues($Grid->RowIndex); // Restore form values
        }

        // Set up row id / data-rowindex
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowCount, "id" => "r" . $Grid->RowCount . "_V_TREAT", "data-rowtype" => $Grid->RowType]);

        // Render row
        $Grid->renderRow();

        // Render list options
        $Grid->renderListOptions();

        // Skip delete row / empty row for confirm page
        if ($Grid->RowAction != "delete" && $Grid->RowAction != "insertdelete" && !($Grid->RowAction == "insert" && $Grid->isConfirm() && $Grid->emptyRow())) {
?>
    <tr <?= $Grid->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Grid->ListOptions->render("body", "left", $Grid->RowCount);
?>
    <?php if ($Grid->ORG_UNIT_CODE->Visible) { // ORG_UNIT_CODE ?>
        <td data-name="ORG_UNIT_CODE" <?= $Grid->ORG_UNIT_CODE->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_ORG_UNIT_CODE" class="form-group">
<input type="<?= $Grid->ORG_UNIT_CODE->getInputTextType() ?>" data-table="V_TREAT" data-field="x_ORG_UNIT_CODE" name="x<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" id="x<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->ORG_UNIT_CODE->getPlaceHolder()) ?>" value="<?= $Grid->ORG_UNIT_CODE->EditValue ?>"<?= $Grid->ORG_UNIT_CODE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ORG_UNIT_CODE->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_ORG_UNIT_CODE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" id="o<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" value="<?= HtmlEncode($Grid->ORG_UNIT_CODE->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_ORG_UNIT_CODE" class="form-group">
<input type="<?= $Grid->ORG_UNIT_CODE->getInputTextType() ?>" data-table="V_TREAT" data-field="x_ORG_UNIT_CODE" name="x<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" id="x<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->ORG_UNIT_CODE->getPlaceHolder()) ?>" value="<?= $Grid->ORG_UNIT_CODE->EditValue ?>"<?= $Grid->ORG_UNIT_CODE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ORG_UNIT_CODE->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_ORG_UNIT_CODE">
<span<?= $Grid->ORG_UNIT_CODE->viewAttributes() ?>>
<?= $Grid->ORG_UNIT_CODE->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_ORG_UNIT_CODE" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" value="<?= HtmlEncode($Grid->ORG_UNIT_CODE->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_ORG_UNIT_CODE" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" value="<?= HtmlEncode($Grid->ORG_UNIT_CODE->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->BILL_ID->Visible) { // BILL_ID ?>
        <td data-name="BILL_ID" <?= $Grid->BILL_ID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_BILL_ID" class="form-group">
<input type="<?= $Grid->BILL_ID->getInputTextType() ?>" data-table="V_TREAT" data-field="x_BILL_ID" name="x<?= $Grid->RowIndex ?>_BILL_ID" id="x<?= $Grid->RowIndex ?>_BILL_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->BILL_ID->getPlaceHolder()) ?>" value="<?= $Grid->BILL_ID->EditValue ?>"<?= $Grid->BILL_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->BILL_ID->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_BILL_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_BILL_ID" id="o<?= $Grid->RowIndex ?>_BILL_ID" value="<?= HtmlEncode($Grid->BILL_ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_BILL_ID" class="form-group">
<input type="<?= $Grid->BILL_ID->getInputTextType() ?>" data-table="V_TREAT" data-field="x_BILL_ID" name="x<?= $Grid->RowIndex ?>_BILL_ID" id="x<?= $Grid->RowIndex ?>_BILL_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->BILL_ID->getPlaceHolder()) ?>" value="<?= $Grid->BILL_ID->EditValue ?>"<?= $Grid->BILL_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->BILL_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_BILL_ID">
<span<?= $Grid->BILL_ID->viewAttributes() ?>>
<?= $Grid->BILL_ID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_BILL_ID" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_BILL_ID" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_BILL_ID" value="<?= HtmlEncode($Grid->BILL_ID->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_BILL_ID" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_BILL_ID" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_BILL_ID" value="<?= HtmlEncode($Grid->BILL_ID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->NO_REGISTRATION->Visible) { // NO_REGISTRATION ?>
        <td data-name="NO_REGISTRATION" <?= $Grid->NO_REGISTRATION->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_NO_REGISTRATION" class="form-group">
<input type="<?= $Grid->NO_REGISTRATION->getInputTextType() ?>" data-table="V_TREAT" data-field="x_NO_REGISTRATION" name="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" id="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" size="30" maxlength="25" placeholder="<?= HtmlEncode($Grid->NO_REGISTRATION->getPlaceHolder()) ?>" value="<?= $Grid->NO_REGISTRATION->EditValue ?>"<?= $Grid->NO_REGISTRATION->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->NO_REGISTRATION->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_NO_REGISTRATION" data-hidden="1" name="o<?= $Grid->RowIndex ?>_NO_REGISTRATION" id="o<?= $Grid->RowIndex ?>_NO_REGISTRATION" value="<?= HtmlEncode($Grid->NO_REGISTRATION->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_NO_REGISTRATION" class="form-group">
<input type="<?= $Grid->NO_REGISTRATION->getInputTextType() ?>" data-table="V_TREAT" data-field="x_NO_REGISTRATION" name="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" id="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" size="30" maxlength="25" placeholder="<?= HtmlEncode($Grid->NO_REGISTRATION->getPlaceHolder()) ?>" value="<?= $Grid->NO_REGISTRATION->EditValue ?>"<?= $Grid->NO_REGISTRATION->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->NO_REGISTRATION->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_NO_REGISTRATION">
<span<?= $Grid->NO_REGISTRATION->viewAttributes() ?>>
<?= $Grid->NO_REGISTRATION->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_NO_REGISTRATION" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_NO_REGISTRATION" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_NO_REGISTRATION" value="<?= HtmlEncode($Grid->NO_REGISTRATION->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_NO_REGISTRATION" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_NO_REGISTRATION" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_NO_REGISTRATION" value="<?= HtmlEncode($Grid->NO_REGISTRATION->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->VISIT_ID->Visible) { // VISIT_ID ?>
        <td data-name="VISIT_ID" <?= $Grid->VISIT_ID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Grid->VISIT_ID->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_VISIT_ID" class="form-group">
<span<?= $Grid->VISIT_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->VISIT_ID->getDisplayValue($Grid->VISIT_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_VISIT_ID" name="x<?= $Grid->RowIndex ?>_VISIT_ID" value="<?= HtmlEncode($Grid->VISIT_ID->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_VISIT_ID" class="form-group">
<input type="<?= $Grid->VISIT_ID->getInputTextType() ?>" data-table="V_TREAT" data-field="x_VISIT_ID" name="x<?= $Grid->RowIndex ?>_VISIT_ID" id="x<?= $Grid->RowIndex ?>_VISIT_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->VISIT_ID->getPlaceHolder()) ?>" value="<?= $Grid->VISIT_ID->EditValue ?>"<?= $Grid->VISIT_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->VISIT_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_VISIT_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_VISIT_ID" id="o<?= $Grid->RowIndex ?>_VISIT_ID" value="<?= HtmlEncode($Grid->VISIT_ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Grid->VISIT_ID->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_VISIT_ID" class="form-group">
<span<?= $Grid->VISIT_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->VISIT_ID->getDisplayValue($Grid->VISIT_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_VISIT_ID" name="x<?= $Grid->RowIndex ?>_VISIT_ID" value="<?= HtmlEncode($Grid->VISIT_ID->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_VISIT_ID" class="form-group">
<input type="<?= $Grid->VISIT_ID->getInputTextType() ?>" data-table="V_TREAT" data-field="x_VISIT_ID" name="x<?= $Grid->RowIndex ?>_VISIT_ID" id="x<?= $Grid->RowIndex ?>_VISIT_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->VISIT_ID->getPlaceHolder()) ?>" value="<?= $Grid->VISIT_ID->EditValue ?>"<?= $Grid->VISIT_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->VISIT_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_VISIT_ID">
<span<?= $Grid->VISIT_ID->viewAttributes() ?>>
<?= $Grid->VISIT_ID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_VISIT_ID" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_VISIT_ID" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_VISIT_ID" value="<?= HtmlEncode($Grid->VISIT_ID->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_VISIT_ID" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_VISIT_ID" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_VISIT_ID" value="<?= HtmlEncode($Grid->VISIT_ID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->TARIF_ID->Visible) { // TARIF_ID ?>
        <td data-name="TARIF_ID" <?= $Grid->TARIF_ID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_TARIF_ID" class="form-group">
<input type="<?= $Grid->TARIF_ID->getInputTextType() ?>" data-table="V_TREAT" data-field="x_TARIF_ID" name="x<?= $Grid->RowIndex ?>_TARIF_ID" id="x<?= $Grid->RowIndex ?>_TARIF_ID" size="30" maxlength="25" placeholder="<?= HtmlEncode($Grid->TARIF_ID->getPlaceHolder()) ?>" value="<?= $Grid->TARIF_ID->EditValue ?>"<?= $Grid->TARIF_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->TARIF_ID->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_TARIF_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_TARIF_ID" id="o<?= $Grid->RowIndex ?>_TARIF_ID" value="<?= HtmlEncode($Grid->TARIF_ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_TARIF_ID" class="form-group">
<input type="<?= $Grid->TARIF_ID->getInputTextType() ?>" data-table="V_TREAT" data-field="x_TARIF_ID" name="x<?= $Grid->RowIndex ?>_TARIF_ID" id="x<?= $Grid->RowIndex ?>_TARIF_ID" size="30" maxlength="25" placeholder="<?= HtmlEncode($Grid->TARIF_ID->getPlaceHolder()) ?>" value="<?= $Grid->TARIF_ID->EditValue ?>"<?= $Grid->TARIF_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->TARIF_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_TARIF_ID">
<span<?= $Grid->TARIF_ID->viewAttributes() ?>>
<?= $Grid->TARIF_ID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_TARIF_ID" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_TARIF_ID" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_TARIF_ID" value="<?= HtmlEncode($Grid->TARIF_ID->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_TARIF_ID" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_TARIF_ID" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_TARIF_ID" value="<?= HtmlEncode($Grid->TARIF_ID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->CLASS_ID->Visible) { // CLASS_ID ?>
        <td data-name="CLASS_ID" <?= $Grid->CLASS_ID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_CLASS_ID" class="form-group">
<input type="<?= $Grid->CLASS_ID->getInputTextType() ?>" data-table="V_TREAT" data-field="x_CLASS_ID" name="x<?= $Grid->RowIndex ?>_CLASS_ID" id="x<?= $Grid->RowIndex ?>_CLASS_ID" size="30" placeholder="<?= HtmlEncode($Grid->CLASS_ID->getPlaceHolder()) ?>" value="<?= $Grid->CLASS_ID->EditValue ?>"<?= $Grid->CLASS_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->CLASS_ID->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_CLASS_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_CLASS_ID" id="o<?= $Grid->RowIndex ?>_CLASS_ID" value="<?= HtmlEncode($Grid->CLASS_ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_CLASS_ID" class="form-group">
<input type="<?= $Grid->CLASS_ID->getInputTextType() ?>" data-table="V_TREAT" data-field="x_CLASS_ID" name="x<?= $Grid->RowIndex ?>_CLASS_ID" id="x<?= $Grid->RowIndex ?>_CLASS_ID" size="30" placeholder="<?= HtmlEncode($Grid->CLASS_ID->getPlaceHolder()) ?>" value="<?= $Grid->CLASS_ID->EditValue ?>"<?= $Grid->CLASS_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->CLASS_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_CLASS_ID">
<span<?= $Grid->CLASS_ID->viewAttributes() ?>>
<?= $Grid->CLASS_ID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_CLASS_ID" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_CLASS_ID" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_CLASS_ID" value="<?= HtmlEncode($Grid->CLASS_ID->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_CLASS_ID" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_CLASS_ID" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_CLASS_ID" value="<?= HtmlEncode($Grid->CLASS_ID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->CLINIC_ID->Visible) { // CLINIC_ID ?>
        <td data-name="CLINIC_ID" <?= $Grid->CLINIC_ID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_CLINIC_ID" class="form-group">
<input type="<?= $Grid->CLINIC_ID->getInputTextType() ?>" data-table="V_TREAT" data-field="x_CLINIC_ID" name="x<?= $Grid->RowIndex ?>_CLINIC_ID" id="x<?= $Grid->RowIndex ?>_CLINIC_ID" size="30" maxlength="15" placeholder="<?= HtmlEncode($Grid->CLINIC_ID->getPlaceHolder()) ?>" value="<?= $Grid->CLINIC_ID->EditValue ?>"<?= $Grid->CLINIC_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->CLINIC_ID->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_CLINIC_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_CLINIC_ID" id="o<?= $Grid->RowIndex ?>_CLINIC_ID" value="<?= HtmlEncode($Grid->CLINIC_ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_CLINIC_ID" class="form-group">
<input type="<?= $Grid->CLINIC_ID->getInputTextType() ?>" data-table="V_TREAT" data-field="x_CLINIC_ID" name="x<?= $Grid->RowIndex ?>_CLINIC_ID" id="x<?= $Grid->RowIndex ?>_CLINIC_ID" size="30" maxlength="15" placeholder="<?= HtmlEncode($Grid->CLINIC_ID->getPlaceHolder()) ?>" value="<?= $Grid->CLINIC_ID->EditValue ?>"<?= $Grid->CLINIC_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->CLINIC_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_CLINIC_ID">
<span<?= $Grid->CLINIC_ID->viewAttributes() ?>>
<?= $Grid->CLINIC_ID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_CLINIC_ID" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_CLINIC_ID" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_CLINIC_ID" value="<?= HtmlEncode($Grid->CLINIC_ID->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_CLINIC_ID" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_CLINIC_ID" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_CLINIC_ID" value="<?= HtmlEncode($Grid->CLINIC_ID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->CLINIC_ID_FROM->Visible) { // CLINIC_ID_FROM ?>
        <td data-name="CLINIC_ID_FROM" <?= $Grid->CLINIC_ID_FROM->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_CLINIC_ID_FROM" class="form-group">
<input type="<?= $Grid->CLINIC_ID_FROM->getInputTextType() ?>" data-table="V_TREAT" data-field="x_CLINIC_ID_FROM" name="x<?= $Grid->RowIndex ?>_CLINIC_ID_FROM" id="x<?= $Grid->RowIndex ?>_CLINIC_ID_FROM" size="30" maxlength="15" placeholder="<?= HtmlEncode($Grid->CLINIC_ID_FROM->getPlaceHolder()) ?>" value="<?= $Grid->CLINIC_ID_FROM->EditValue ?>"<?= $Grid->CLINIC_ID_FROM->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->CLINIC_ID_FROM->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_CLINIC_ID_FROM" data-hidden="1" name="o<?= $Grid->RowIndex ?>_CLINIC_ID_FROM" id="o<?= $Grid->RowIndex ?>_CLINIC_ID_FROM" value="<?= HtmlEncode($Grid->CLINIC_ID_FROM->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_CLINIC_ID_FROM" class="form-group">
<input type="<?= $Grid->CLINIC_ID_FROM->getInputTextType() ?>" data-table="V_TREAT" data-field="x_CLINIC_ID_FROM" name="x<?= $Grid->RowIndex ?>_CLINIC_ID_FROM" id="x<?= $Grid->RowIndex ?>_CLINIC_ID_FROM" size="30" maxlength="15" placeholder="<?= HtmlEncode($Grid->CLINIC_ID_FROM->getPlaceHolder()) ?>" value="<?= $Grid->CLINIC_ID_FROM->EditValue ?>"<?= $Grid->CLINIC_ID_FROM->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->CLINIC_ID_FROM->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_CLINIC_ID_FROM">
<span<?= $Grid->CLINIC_ID_FROM->viewAttributes() ?>>
<?= $Grid->CLINIC_ID_FROM->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_CLINIC_ID_FROM" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_CLINIC_ID_FROM" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_CLINIC_ID_FROM" value="<?= HtmlEncode($Grid->CLINIC_ID_FROM->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_CLINIC_ID_FROM" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_CLINIC_ID_FROM" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_CLINIC_ID_FROM" value="<?= HtmlEncode($Grid->CLINIC_ID_FROM->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->TREATMENT->Visible) { // TREATMENT ?>
        <td data-name="TREATMENT" <?= $Grid->TREATMENT->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_TREATMENT" class="form-group">
<input type="<?= $Grid->TREATMENT->getInputTextType() ?>" data-table="V_TREAT" data-field="x_TREATMENT" name="x<?= $Grid->RowIndex ?>_TREATMENT" id="x<?= $Grid->RowIndex ?>_TREATMENT" size="30" maxlength="200" placeholder="<?= HtmlEncode($Grid->TREATMENT->getPlaceHolder()) ?>" value="<?= $Grid->TREATMENT->EditValue ?>"<?= $Grid->TREATMENT->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->TREATMENT->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_TREATMENT" data-hidden="1" name="o<?= $Grid->RowIndex ?>_TREATMENT" id="o<?= $Grid->RowIndex ?>_TREATMENT" value="<?= HtmlEncode($Grid->TREATMENT->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_TREATMENT" class="form-group">
<input type="<?= $Grid->TREATMENT->getInputTextType() ?>" data-table="V_TREAT" data-field="x_TREATMENT" name="x<?= $Grid->RowIndex ?>_TREATMENT" id="x<?= $Grid->RowIndex ?>_TREATMENT" size="30" maxlength="200" placeholder="<?= HtmlEncode($Grid->TREATMENT->getPlaceHolder()) ?>" value="<?= $Grid->TREATMENT->EditValue ?>"<?= $Grid->TREATMENT->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->TREATMENT->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_TREATMENT">
<span<?= $Grid->TREATMENT->viewAttributes() ?>>
<?= $Grid->TREATMENT->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_TREATMENT" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_TREATMENT" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_TREATMENT" value="<?= HtmlEncode($Grid->TREATMENT->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_TREATMENT" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_TREATMENT" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_TREATMENT" value="<?= HtmlEncode($Grid->TREATMENT->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->TREAT_DATE->Visible) { // TREAT_DATE ?>
        <td data-name="TREAT_DATE" <?= $Grid->TREAT_DATE->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_TREAT_DATE" class="form-group">
<input type="<?= $Grid->TREAT_DATE->getInputTextType() ?>" data-table="V_TREAT" data-field="x_TREAT_DATE" name="x<?= $Grid->RowIndex ?>_TREAT_DATE" id="x<?= $Grid->RowIndex ?>_TREAT_DATE" placeholder="<?= HtmlEncode($Grid->TREAT_DATE->getPlaceHolder()) ?>" value="<?= $Grid->TREAT_DATE->EditValue ?>"<?= $Grid->TREAT_DATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->TREAT_DATE->getErrorMessage() ?></div>
<?php if (!$Grid->TREAT_DATE->ReadOnly && !$Grid->TREAT_DATE->Disabled && !isset($Grid->TREAT_DATE->EditAttrs["readonly"]) && !isset($Grid->TREAT_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fV_TREATgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fV_TREATgrid", "x<?= $Grid->RowIndex ?>_TREAT_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_TREAT_DATE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_TREAT_DATE" id="o<?= $Grid->RowIndex ?>_TREAT_DATE" value="<?= HtmlEncode($Grid->TREAT_DATE->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_TREAT_DATE" class="form-group">
<input type="<?= $Grid->TREAT_DATE->getInputTextType() ?>" data-table="V_TREAT" data-field="x_TREAT_DATE" name="x<?= $Grid->RowIndex ?>_TREAT_DATE" id="x<?= $Grid->RowIndex ?>_TREAT_DATE" placeholder="<?= HtmlEncode($Grid->TREAT_DATE->getPlaceHolder()) ?>" value="<?= $Grid->TREAT_DATE->EditValue ?>"<?= $Grid->TREAT_DATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->TREAT_DATE->getErrorMessage() ?></div>
<?php if (!$Grid->TREAT_DATE->ReadOnly && !$Grid->TREAT_DATE->Disabled && !isset($Grid->TREAT_DATE->EditAttrs["readonly"]) && !isset($Grid->TREAT_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fV_TREATgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fV_TREATgrid", "x<?= $Grid->RowIndex ?>_TREAT_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_TREAT_DATE">
<span<?= $Grid->TREAT_DATE->viewAttributes() ?>>
<?= $Grid->TREAT_DATE->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_TREAT_DATE" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_TREAT_DATE" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_TREAT_DATE" value="<?= HtmlEncode($Grid->TREAT_DATE->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_TREAT_DATE" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_TREAT_DATE" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_TREAT_DATE" value="<?= HtmlEncode($Grid->TREAT_DATE->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->QUANTITY->Visible) { // QUANTITY ?>
        <td data-name="QUANTITY" <?= $Grid->QUANTITY->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_QUANTITY" class="form-group">
<input type="<?= $Grid->QUANTITY->getInputTextType() ?>" data-table="V_TREAT" data-field="x_QUANTITY" name="x<?= $Grid->RowIndex ?>_QUANTITY" id="x<?= $Grid->RowIndex ?>_QUANTITY" size="30" placeholder="<?= HtmlEncode($Grid->QUANTITY->getPlaceHolder()) ?>" value="<?= $Grid->QUANTITY->EditValue ?>"<?= $Grid->QUANTITY->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->QUANTITY->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_QUANTITY" data-hidden="1" name="o<?= $Grid->RowIndex ?>_QUANTITY" id="o<?= $Grid->RowIndex ?>_QUANTITY" value="<?= HtmlEncode($Grid->QUANTITY->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_QUANTITY" class="form-group">
<input type="<?= $Grid->QUANTITY->getInputTextType() ?>" data-table="V_TREAT" data-field="x_QUANTITY" name="x<?= $Grid->RowIndex ?>_QUANTITY" id="x<?= $Grid->RowIndex ?>_QUANTITY" size="30" placeholder="<?= HtmlEncode($Grid->QUANTITY->getPlaceHolder()) ?>" value="<?= $Grid->QUANTITY->EditValue ?>"<?= $Grid->QUANTITY->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->QUANTITY->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_QUANTITY">
<span<?= $Grid->QUANTITY->viewAttributes() ?>>
<?= $Grid->QUANTITY->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_QUANTITY" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_QUANTITY" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_QUANTITY" value="<?= HtmlEncode($Grid->QUANTITY->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_QUANTITY" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_QUANTITY" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_QUANTITY" value="<?= HtmlEncode($Grid->QUANTITY->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->MEASURE_ID->Visible) { // MEASURE_ID ?>
        <td data-name="MEASURE_ID" <?= $Grid->MEASURE_ID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_MEASURE_ID" class="form-group">
<input type="<?= $Grid->MEASURE_ID->getInputTextType() ?>" data-table="V_TREAT" data-field="x_MEASURE_ID" name="x<?= $Grid->RowIndex ?>_MEASURE_ID" id="x<?= $Grid->RowIndex ?>_MEASURE_ID" size="30" placeholder="<?= HtmlEncode($Grid->MEASURE_ID->getPlaceHolder()) ?>" value="<?= $Grid->MEASURE_ID->EditValue ?>"<?= $Grid->MEASURE_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->MEASURE_ID->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_MEASURE_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_MEASURE_ID" id="o<?= $Grid->RowIndex ?>_MEASURE_ID" value="<?= HtmlEncode($Grid->MEASURE_ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_MEASURE_ID" class="form-group">
<input type="<?= $Grid->MEASURE_ID->getInputTextType() ?>" data-table="V_TREAT" data-field="x_MEASURE_ID" name="x<?= $Grid->RowIndex ?>_MEASURE_ID" id="x<?= $Grid->RowIndex ?>_MEASURE_ID" size="30" placeholder="<?= HtmlEncode($Grid->MEASURE_ID->getPlaceHolder()) ?>" value="<?= $Grid->MEASURE_ID->EditValue ?>"<?= $Grid->MEASURE_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->MEASURE_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_MEASURE_ID">
<span<?= $Grid->MEASURE_ID->viewAttributes() ?>>
<?= $Grid->MEASURE_ID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_MEASURE_ID" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_MEASURE_ID" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_MEASURE_ID" value="<?= HtmlEncode($Grid->MEASURE_ID->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_MEASURE_ID" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_MEASURE_ID" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_MEASURE_ID" value="<?= HtmlEncode($Grid->MEASURE_ID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->DESCRIPTION->Visible) { // DESCRIPTION ?>
        <td data-name="DESCRIPTION" <?= $Grid->DESCRIPTION->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_DESCRIPTION" class="form-group">
<input type="<?= $Grid->DESCRIPTION->getInputTextType() ?>" data-table="V_TREAT" data-field="x_DESCRIPTION" name="x<?= $Grid->RowIndex ?>_DESCRIPTION" id="x<?= $Grid->RowIndex ?>_DESCRIPTION" size="30" maxlength="200" placeholder="<?= HtmlEncode($Grid->DESCRIPTION->getPlaceHolder()) ?>" value="<?= $Grid->DESCRIPTION->EditValue ?>"<?= $Grid->DESCRIPTION->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->DESCRIPTION->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_DESCRIPTION" data-hidden="1" name="o<?= $Grid->RowIndex ?>_DESCRIPTION" id="o<?= $Grid->RowIndex ?>_DESCRIPTION" value="<?= HtmlEncode($Grid->DESCRIPTION->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_DESCRIPTION" class="form-group">
<input type="<?= $Grid->DESCRIPTION->getInputTextType() ?>" data-table="V_TREAT" data-field="x_DESCRIPTION" name="x<?= $Grid->RowIndex ?>_DESCRIPTION" id="x<?= $Grid->RowIndex ?>_DESCRIPTION" size="30" maxlength="200" placeholder="<?= HtmlEncode($Grid->DESCRIPTION->getPlaceHolder()) ?>" value="<?= $Grid->DESCRIPTION->EditValue ?>"<?= $Grid->DESCRIPTION->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->DESCRIPTION->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_DESCRIPTION">
<span<?= $Grid->DESCRIPTION->viewAttributes() ?>>
<?= $Grid->DESCRIPTION->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_DESCRIPTION" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_DESCRIPTION" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_DESCRIPTION" value="<?= HtmlEncode($Grid->DESCRIPTION->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_DESCRIPTION" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_DESCRIPTION" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_DESCRIPTION" value="<?= HtmlEncode($Grid->DESCRIPTION->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->RESEP_NO->Visible) { // RESEP_NO ?>
        <td data-name="RESEP_NO" <?= $Grid->RESEP_NO->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_RESEP_NO" class="form-group">
<input type="<?= $Grid->RESEP_NO->getInputTextType() ?>" data-table="V_TREAT" data-field="x_RESEP_NO" name="x<?= $Grid->RowIndex ?>_RESEP_NO" id="x<?= $Grid->RowIndex ?>_RESEP_NO" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->RESEP_NO->getPlaceHolder()) ?>" value="<?= $Grid->RESEP_NO->EditValue ?>"<?= $Grid->RESEP_NO->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->RESEP_NO->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_RESEP_NO" data-hidden="1" name="o<?= $Grid->RowIndex ?>_RESEP_NO" id="o<?= $Grid->RowIndex ?>_RESEP_NO" value="<?= HtmlEncode($Grid->RESEP_NO->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_RESEP_NO" class="form-group">
<input type="<?= $Grid->RESEP_NO->getInputTextType() ?>" data-table="V_TREAT" data-field="x_RESEP_NO" name="x<?= $Grid->RowIndex ?>_RESEP_NO" id="x<?= $Grid->RowIndex ?>_RESEP_NO" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->RESEP_NO->getPlaceHolder()) ?>" value="<?= $Grid->RESEP_NO->EditValue ?>"<?= $Grid->RESEP_NO->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->RESEP_NO->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_RESEP_NO">
<span<?= $Grid->RESEP_NO->viewAttributes() ?>>
<?= $Grid->RESEP_NO->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_RESEP_NO" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_RESEP_NO" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_RESEP_NO" value="<?= HtmlEncode($Grid->RESEP_NO->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_RESEP_NO" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_RESEP_NO" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_RESEP_NO" value="<?= HtmlEncode($Grid->RESEP_NO->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->DOSE_PRESC->Visible) { // DOSE_PRESC ?>
        <td data-name="DOSE_PRESC" <?= $Grid->DOSE_PRESC->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_DOSE_PRESC" class="form-group">
<input type="<?= $Grid->DOSE_PRESC->getInputTextType() ?>" data-table="V_TREAT" data-field="x_DOSE_PRESC" name="x<?= $Grid->RowIndex ?>_DOSE_PRESC" id="x<?= $Grid->RowIndex ?>_DOSE_PRESC" size="30" placeholder="<?= HtmlEncode($Grid->DOSE_PRESC->getPlaceHolder()) ?>" value="<?= $Grid->DOSE_PRESC->EditValue ?>"<?= $Grid->DOSE_PRESC->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->DOSE_PRESC->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_DOSE_PRESC" data-hidden="1" name="o<?= $Grid->RowIndex ?>_DOSE_PRESC" id="o<?= $Grid->RowIndex ?>_DOSE_PRESC" value="<?= HtmlEncode($Grid->DOSE_PRESC->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_DOSE_PRESC" class="form-group">
<input type="<?= $Grid->DOSE_PRESC->getInputTextType() ?>" data-table="V_TREAT" data-field="x_DOSE_PRESC" name="x<?= $Grid->RowIndex ?>_DOSE_PRESC" id="x<?= $Grid->RowIndex ?>_DOSE_PRESC" size="30" placeholder="<?= HtmlEncode($Grid->DOSE_PRESC->getPlaceHolder()) ?>" value="<?= $Grid->DOSE_PRESC->EditValue ?>"<?= $Grid->DOSE_PRESC->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->DOSE_PRESC->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_DOSE_PRESC">
<span<?= $Grid->DOSE_PRESC->viewAttributes() ?>>
<?= $Grid->DOSE_PRESC->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_DOSE_PRESC" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_DOSE_PRESC" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_DOSE_PRESC" value="<?= HtmlEncode($Grid->DOSE_PRESC->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_DOSE_PRESC" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_DOSE_PRESC" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_DOSE_PRESC" value="<?= HtmlEncode($Grid->DOSE_PRESC->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->SOLD_STATUS->Visible) { // SOLD_STATUS ?>
        <td data-name="SOLD_STATUS" <?= $Grid->SOLD_STATUS->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_SOLD_STATUS" class="form-group">
<input type="<?= $Grid->SOLD_STATUS->getInputTextType() ?>" data-table="V_TREAT" data-field="x_SOLD_STATUS" name="x<?= $Grid->RowIndex ?>_SOLD_STATUS" id="x<?= $Grid->RowIndex ?>_SOLD_STATUS" size="30" placeholder="<?= HtmlEncode($Grid->SOLD_STATUS->getPlaceHolder()) ?>" value="<?= $Grid->SOLD_STATUS->EditValue ?>"<?= $Grid->SOLD_STATUS->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->SOLD_STATUS->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_SOLD_STATUS" data-hidden="1" name="o<?= $Grid->RowIndex ?>_SOLD_STATUS" id="o<?= $Grid->RowIndex ?>_SOLD_STATUS" value="<?= HtmlEncode($Grid->SOLD_STATUS->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_SOLD_STATUS" class="form-group">
<input type="<?= $Grid->SOLD_STATUS->getInputTextType() ?>" data-table="V_TREAT" data-field="x_SOLD_STATUS" name="x<?= $Grid->RowIndex ?>_SOLD_STATUS" id="x<?= $Grid->RowIndex ?>_SOLD_STATUS" size="30" placeholder="<?= HtmlEncode($Grid->SOLD_STATUS->getPlaceHolder()) ?>" value="<?= $Grid->SOLD_STATUS->EditValue ?>"<?= $Grid->SOLD_STATUS->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->SOLD_STATUS->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_SOLD_STATUS">
<span<?= $Grid->SOLD_STATUS->viewAttributes() ?>>
<?= $Grid->SOLD_STATUS->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_SOLD_STATUS" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_SOLD_STATUS" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_SOLD_STATUS" value="<?= HtmlEncode($Grid->SOLD_STATUS->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_SOLD_STATUS" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_SOLD_STATUS" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_SOLD_STATUS" value="<?= HtmlEncode($Grid->SOLD_STATUS->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->RACIKAN->Visible) { // RACIKAN ?>
        <td data-name="RACIKAN" <?= $Grid->RACIKAN->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_RACIKAN" class="form-group">
<input type="<?= $Grid->RACIKAN->getInputTextType() ?>" data-table="V_TREAT" data-field="x_RACIKAN" name="x<?= $Grid->RowIndex ?>_RACIKAN" id="x<?= $Grid->RowIndex ?>_RACIKAN" size="30" placeholder="<?= HtmlEncode($Grid->RACIKAN->getPlaceHolder()) ?>" value="<?= $Grid->RACIKAN->EditValue ?>"<?= $Grid->RACIKAN->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->RACIKAN->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_RACIKAN" data-hidden="1" name="o<?= $Grid->RowIndex ?>_RACIKAN" id="o<?= $Grid->RowIndex ?>_RACIKAN" value="<?= HtmlEncode($Grid->RACIKAN->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_RACIKAN" class="form-group">
<input type="<?= $Grid->RACIKAN->getInputTextType() ?>" data-table="V_TREAT" data-field="x_RACIKAN" name="x<?= $Grid->RowIndex ?>_RACIKAN" id="x<?= $Grid->RowIndex ?>_RACIKAN" size="30" placeholder="<?= HtmlEncode($Grid->RACIKAN->getPlaceHolder()) ?>" value="<?= $Grid->RACIKAN->EditValue ?>"<?= $Grid->RACIKAN->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->RACIKAN->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_RACIKAN">
<span<?= $Grid->RACIKAN->viewAttributes() ?>>
<?= $Grid->RACIKAN->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_RACIKAN" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_RACIKAN" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_RACIKAN" value="<?= HtmlEncode($Grid->RACIKAN->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_RACIKAN" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_RACIKAN" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_RACIKAN" value="<?= HtmlEncode($Grid->RACIKAN->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->CLASS_ROOM_ID->Visible) { // CLASS_ROOM_ID ?>
        <td data-name="CLASS_ROOM_ID" <?= $Grid->CLASS_ROOM_ID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_CLASS_ROOM_ID" class="form-group">
<input type="<?= $Grid->CLASS_ROOM_ID->getInputTextType() ?>" data-table="V_TREAT" data-field="x_CLASS_ROOM_ID" name="x<?= $Grid->RowIndex ?>_CLASS_ROOM_ID" id="x<?= $Grid->RowIndex ?>_CLASS_ROOM_ID" size="30" maxlength="16" placeholder="<?= HtmlEncode($Grid->CLASS_ROOM_ID->getPlaceHolder()) ?>" value="<?= $Grid->CLASS_ROOM_ID->EditValue ?>"<?= $Grid->CLASS_ROOM_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->CLASS_ROOM_ID->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_CLASS_ROOM_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_CLASS_ROOM_ID" id="o<?= $Grid->RowIndex ?>_CLASS_ROOM_ID" value="<?= HtmlEncode($Grid->CLASS_ROOM_ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_CLASS_ROOM_ID" class="form-group">
<input type="<?= $Grid->CLASS_ROOM_ID->getInputTextType() ?>" data-table="V_TREAT" data-field="x_CLASS_ROOM_ID" name="x<?= $Grid->RowIndex ?>_CLASS_ROOM_ID" id="x<?= $Grid->RowIndex ?>_CLASS_ROOM_ID" size="30" maxlength="16" placeholder="<?= HtmlEncode($Grid->CLASS_ROOM_ID->getPlaceHolder()) ?>" value="<?= $Grid->CLASS_ROOM_ID->EditValue ?>"<?= $Grid->CLASS_ROOM_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->CLASS_ROOM_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_CLASS_ROOM_ID">
<span<?= $Grid->CLASS_ROOM_ID->viewAttributes() ?>>
<?= $Grid->CLASS_ROOM_ID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_CLASS_ROOM_ID" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_CLASS_ROOM_ID" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_CLASS_ROOM_ID" value="<?= HtmlEncode($Grid->CLASS_ROOM_ID->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_CLASS_ROOM_ID" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_CLASS_ROOM_ID" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_CLASS_ROOM_ID" value="<?= HtmlEncode($Grid->CLASS_ROOM_ID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->KELUAR_ID->Visible) { // KELUAR_ID ?>
        <td data-name="KELUAR_ID" <?= $Grid->KELUAR_ID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_KELUAR_ID" class="form-group">
<input type="<?= $Grid->KELUAR_ID->getInputTextType() ?>" data-table="V_TREAT" data-field="x_KELUAR_ID" name="x<?= $Grid->RowIndex ?>_KELUAR_ID" id="x<?= $Grid->RowIndex ?>_KELUAR_ID" size="30" placeholder="<?= HtmlEncode($Grid->KELUAR_ID->getPlaceHolder()) ?>" value="<?= $Grid->KELUAR_ID->EditValue ?>"<?= $Grid->KELUAR_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->KELUAR_ID->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_KELUAR_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_KELUAR_ID" id="o<?= $Grid->RowIndex ?>_KELUAR_ID" value="<?= HtmlEncode($Grid->KELUAR_ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_KELUAR_ID" class="form-group">
<input type="<?= $Grid->KELUAR_ID->getInputTextType() ?>" data-table="V_TREAT" data-field="x_KELUAR_ID" name="x<?= $Grid->RowIndex ?>_KELUAR_ID" id="x<?= $Grid->RowIndex ?>_KELUAR_ID" size="30" placeholder="<?= HtmlEncode($Grid->KELUAR_ID->getPlaceHolder()) ?>" value="<?= $Grid->KELUAR_ID->EditValue ?>"<?= $Grid->KELUAR_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->KELUAR_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_KELUAR_ID">
<span<?= $Grid->KELUAR_ID->viewAttributes() ?>>
<?= $Grid->KELUAR_ID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_KELUAR_ID" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_KELUAR_ID" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_KELUAR_ID" value="<?= HtmlEncode($Grid->KELUAR_ID->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_KELUAR_ID" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_KELUAR_ID" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_KELUAR_ID" value="<?= HtmlEncode($Grid->KELUAR_ID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->BED_ID->Visible) { // BED_ID ?>
        <td data-name="BED_ID" <?= $Grid->BED_ID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_BED_ID" class="form-group">
<input type="<?= $Grid->BED_ID->getInputTextType() ?>" data-table="V_TREAT" data-field="x_BED_ID" name="x<?= $Grid->RowIndex ?>_BED_ID" id="x<?= $Grid->RowIndex ?>_BED_ID" size="30" placeholder="<?= HtmlEncode($Grid->BED_ID->getPlaceHolder()) ?>" value="<?= $Grid->BED_ID->EditValue ?>"<?= $Grid->BED_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->BED_ID->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_BED_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_BED_ID" id="o<?= $Grid->RowIndex ?>_BED_ID" value="<?= HtmlEncode($Grid->BED_ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_BED_ID" class="form-group">
<input type="<?= $Grid->BED_ID->getInputTextType() ?>" data-table="V_TREAT" data-field="x_BED_ID" name="x<?= $Grid->RowIndex ?>_BED_ID" id="x<?= $Grid->RowIndex ?>_BED_ID" size="30" placeholder="<?= HtmlEncode($Grid->BED_ID->getPlaceHolder()) ?>" value="<?= $Grid->BED_ID->EditValue ?>"<?= $Grid->BED_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->BED_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_BED_ID">
<span<?= $Grid->BED_ID->viewAttributes() ?>>
<?= $Grid->BED_ID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_BED_ID" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_BED_ID" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_BED_ID" value="<?= HtmlEncode($Grid->BED_ID->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_BED_ID" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_BED_ID" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_BED_ID" value="<?= HtmlEncode($Grid->BED_ID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->EMPLOYEE_ID->Visible) { // EMPLOYEE_ID ?>
        <td data-name="EMPLOYEE_ID" <?= $Grid->EMPLOYEE_ID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_EMPLOYEE_ID" class="form-group">
<input type="<?= $Grid->EMPLOYEE_ID->getInputTextType() ?>" data-table="V_TREAT" data-field="x_EMPLOYEE_ID" name="x<?= $Grid->RowIndex ?>_EMPLOYEE_ID" id="x<?= $Grid->RowIndex ?>_EMPLOYEE_ID" size="30" maxlength="15" placeholder="<?= HtmlEncode($Grid->EMPLOYEE_ID->getPlaceHolder()) ?>" value="<?= $Grid->EMPLOYEE_ID->EditValue ?>"<?= $Grid->EMPLOYEE_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->EMPLOYEE_ID->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_EMPLOYEE_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_EMPLOYEE_ID" id="o<?= $Grid->RowIndex ?>_EMPLOYEE_ID" value="<?= HtmlEncode($Grid->EMPLOYEE_ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_EMPLOYEE_ID" class="form-group">
<input type="<?= $Grid->EMPLOYEE_ID->getInputTextType() ?>" data-table="V_TREAT" data-field="x_EMPLOYEE_ID" name="x<?= $Grid->RowIndex ?>_EMPLOYEE_ID" id="x<?= $Grid->RowIndex ?>_EMPLOYEE_ID" size="30" maxlength="15" placeholder="<?= HtmlEncode($Grid->EMPLOYEE_ID->getPlaceHolder()) ?>" value="<?= $Grid->EMPLOYEE_ID->EditValue ?>"<?= $Grid->EMPLOYEE_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->EMPLOYEE_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_EMPLOYEE_ID">
<span<?= $Grid->EMPLOYEE_ID->viewAttributes() ?>>
<?= $Grid->EMPLOYEE_ID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_EMPLOYEE_ID" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_EMPLOYEE_ID" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_EMPLOYEE_ID" value="<?= HtmlEncode($Grid->EMPLOYEE_ID->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_EMPLOYEE_ID" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_EMPLOYEE_ID" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_EMPLOYEE_ID" value="<?= HtmlEncode($Grid->EMPLOYEE_ID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->DESCRIPTION2->Visible) { // DESCRIPTION2 ?>
        <td data-name="DESCRIPTION2" <?= $Grid->DESCRIPTION2->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_DESCRIPTION2" class="form-group">
<input type="<?= $Grid->DESCRIPTION2->getInputTextType() ?>" data-table="V_TREAT" data-field="x_DESCRIPTION2" name="x<?= $Grid->RowIndex ?>_DESCRIPTION2" id="x<?= $Grid->RowIndex ?>_DESCRIPTION2" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->DESCRIPTION2->getPlaceHolder()) ?>" value="<?= $Grid->DESCRIPTION2->EditValue ?>"<?= $Grid->DESCRIPTION2->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->DESCRIPTION2->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_DESCRIPTION2" data-hidden="1" name="o<?= $Grid->RowIndex ?>_DESCRIPTION2" id="o<?= $Grid->RowIndex ?>_DESCRIPTION2" value="<?= HtmlEncode($Grid->DESCRIPTION2->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_DESCRIPTION2" class="form-group">
<input type="<?= $Grid->DESCRIPTION2->getInputTextType() ?>" data-table="V_TREAT" data-field="x_DESCRIPTION2" name="x<?= $Grid->RowIndex ?>_DESCRIPTION2" id="x<?= $Grid->RowIndex ?>_DESCRIPTION2" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->DESCRIPTION2->getPlaceHolder()) ?>" value="<?= $Grid->DESCRIPTION2->EditValue ?>"<?= $Grid->DESCRIPTION2->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->DESCRIPTION2->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_DESCRIPTION2">
<span<?= $Grid->DESCRIPTION2->viewAttributes() ?>>
<?= $Grid->DESCRIPTION2->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_DESCRIPTION2" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_DESCRIPTION2" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_DESCRIPTION2" value="<?= HtmlEncode($Grid->DESCRIPTION2->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_DESCRIPTION2" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_DESCRIPTION2" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_DESCRIPTION2" value="<?= HtmlEncode($Grid->DESCRIPTION2->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->BRAND_ID->Visible) { // BRAND_ID ?>
        <td data-name="BRAND_ID" <?= $Grid->BRAND_ID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_BRAND_ID" class="form-group">
<input type="<?= $Grid->BRAND_ID->getInputTextType() ?>" data-table="V_TREAT" data-field="x_BRAND_ID" name="x<?= $Grid->RowIndex ?>_BRAND_ID" id="x<?= $Grid->RowIndex ?>_BRAND_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->BRAND_ID->getPlaceHolder()) ?>" value="<?= $Grid->BRAND_ID->EditValue ?>"<?= $Grid->BRAND_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->BRAND_ID->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_BRAND_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_BRAND_ID" id="o<?= $Grid->RowIndex ?>_BRAND_ID" value="<?= HtmlEncode($Grid->BRAND_ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_BRAND_ID" class="form-group">
<input type="<?= $Grid->BRAND_ID->getInputTextType() ?>" data-table="V_TREAT" data-field="x_BRAND_ID" name="x<?= $Grid->RowIndex ?>_BRAND_ID" id="x<?= $Grid->RowIndex ?>_BRAND_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->BRAND_ID->getPlaceHolder()) ?>" value="<?= $Grid->BRAND_ID->EditValue ?>"<?= $Grid->BRAND_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->BRAND_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_BRAND_ID">
<span<?= $Grid->BRAND_ID->viewAttributes() ?>>
<?= $Grid->BRAND_ID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_BRAND_ID" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_BRAND_ID" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_BRAND_ID" value="<?= HtmlEncode($Grid->BRAND_ID->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_BRAND_ID" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_BRAND_ID" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_BRAND_ID" value="<?= HtmlEncode($Grid->BRAND_ID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->DOCTOR->Visible) { // DOCTOR ?>
        <td data-name="DOCTOR" <?= $Grid->DOCTOR->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_DOCTOR" class="form-group">
<input type="<?= $Grid->DOCTOR->getInputTextType() ?>" data-table="V_TREAT" data-field="x_DOCTOR" name="x<?= $Grid->RowIndex ?>_DOCTOR" id="x<?= $Grid->RowIndex ?>_DOCTOR" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->DOCTOR->getPlaceHolder()) ?>" value="<?= $Grid->DOCTOR->EditValue ?>"<?= $Grid->DOCTOR->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->DOCTOR->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_DOCTOR" data-hidden="1" name="o<?= $Grid->RowIndex ?>_DOCTOR" id="o<?= $Grid->RowIndex ?>_DOCTOR" value="<?= HtmlEncode($Grid->DOCTOR->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_DOCTOR" class="form-group">
<input type="<?= $Grid->DOCTOR->getInputTextType() ?>" data-table="V_TREAT" data-field="x_DOCTOR" name="x<?= $Grid->RowIndex ?>_DOCTOR" id="x<?= $Grid->RowIndex ?>_DOCTOR" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->DOCTOR->getPlaceHolder()) ?>" value="<?= $Grid->DOCTOR->EditValue ?>"<?= $Grid->DOCTOR->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->DOCTOR->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_DOCTOR">
<span<?= $Grid->DOCTOR->viewAttributes() ?>>
<?= $Grid->DOCTOR->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_DOCTOR" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_DOCTOR" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_DOCTOR" value="<?= HtmlEncode($Grid->DOCTOR->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_DOCTOR" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_DOCTOR" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_DOCTOR" value="<?= HtmlEncode($Grid->DOCTOR->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->EXIT_DATE->Visible) { // EXIT_DATE ?>
        <td data-name="EXIT_DATE" <?= $Grid->EXIT_DATE->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_EXIT_DATE" class="form-group">
<input type="<?= $Grid->EXIT_DATE->getInputTextType() ?>" data-table="V_TREAT" data-field="x_EXIT_DATE" name="x<?= $Grid->RowIndex ?>_EXIT_DATE" id="x<?= $Grid->RowIndex ?>_EXIT_DATE" placeholder="<?= HtmlEncode($Grid->EXIT_DATE->getPlaceHolder()) ?>" value="<?= $Grid->EXIT_DATE->EditValue ?>"<?= $Grid->EXIT_DATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->EXIT_DATE->getErrorMessage() ?></div>
<?php if (!$Grid->EXIT_DATE->ReadOnly && !$Grid->EXIT_DATE->Disabled && !isset($Grid->EXIT_DATE->EditAttrs["readonly"]) && !isset($Grid->EXIT_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fV_TREATgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fV_TREATgrid", "x<?= $Grid->RowIndex ?>_EXIT_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_EXIT_DATE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_EXIT_DATE" id="o<?= $Grid->RowIndex ?>_EXIT_DATE" value="<?= HtmlEncode($Grid->EXIT_DATE->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_EXIT_DATE" class="form-group">
<input type="<?= $Grid->EXIT_DATE->getInputTextType() ?>" data-table="V_TREAT" data-field="x_EXIT_DATE" name="x<?= $Grid->RowIndex ?>_EXIT_DATE" id="x<?= $Grid->RowIndex ?>_EXIT_DATE" placeholder="<?= HtmlEncode($Grid->EXIT_DATE->getPlaceHolder()) ?>" value="<?= $Grid->EXIT_DATE->EditValue ?>"<?= $Grid->EXIT_DATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->EXIT_DATE->getErrorMessage() ?></div>
<?php if (!$Grid->EXIT_DATE->ReadOnly && !$Grid->EXIT_DATE->Disabled && !isset($Grid->EXIT_DATE->EditAttrs["readonly"]) && !isset($Grid->EXIT_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fV_TREATgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fV_TREATgrid", "x<?= $Grid->RowIndex ?>_EXIT_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_EXIT_DATE">
<span<?= $Grid->EXIT_DATE->viewAttributes() ?>>
<?= $Grid->EXIT_DATE->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_EXIT_DATE" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_EXIT_DATE" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_EXIT_DATE" value="<?= HtmlEncode($Grid->EXIT_DATE->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_EXIT_DATE" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_EXIT_DATE" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_EXIT_DATE" value="<?= HtmlEncode($Grid->EXIT_DATE->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->EMPLOYEE_ID_FROM->Visible) { // EMPLOYEE_ID_FROM ?>
        <td data-name="EMPLOYEE_ID_FROM" <?= $Grid->EMPLOYEE_ID_FROM->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_EMPLOYEE_ID_FROM" class="form-group">
<input type="<?= $Grid->EMPLOYEE_ID_FROM->getInputTextType() ?>" data-table="V_TREAT" data-field="x_EMPLOYEE_ID_FROM" name="x<?= $Grid->RowIndex ?>_EMPLOYEE_ID_FROM" id="x<?= $Grid->RowIndex ?>_EMPLOYEE_ID_FROM" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->EMPLOYEE_ID_FROM->getPlaceHolder()) ?>" value="<?= $Grid->EMPLOYEE_ID_FROM->EditValue ?>"<?= $Grid->EMPLOYEE_ID_FROM->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->EMPLOYEE_ID_FROM->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_EMPLOYEE_ID_FROM" data-hidden="1" name="o<?= $Grid->RowIndex ?>_EMPLOYEE_ID_FROM" id="o<?= $Grid->RowIndex ?>_EMPLOYEE_ID_FROM" value="<?= HtmlEncode($Grid->EMPLOYEE_ID_FROM->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_EMPLOYEE_ID_FROM" class="form-group">
<input type="<?= $Grid->EMPLOYEE_ID_FROM->getInputTextType() ?>" data-table="V_TREAT" data-field="x_EMPLOYEE_ID_FROM" name="x<?= $Grid->RowIndex ?>_EMPLOYEE_ID_FROM" id="x<?= $Grid->RowIndex ?>_EMPLOYEE_ID_FROM" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->EMPLOYEE_ID_FROM->getPlaceHolder()) ?>" value="<?= $Grid->EMPLOYEE_ID_FROM->EditValue ?>"<?= $Grid->EMPLOYEE_ID_FROM->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->EMPLOYEE_ID_FROM->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_EMPLOYEE_ID_FROM">
<span<?= $Grid->EMPLOYEE_ID_FROM->viewAttributes() ?>>
<?= $Grid->EMPLOYEE_ID_FROM->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_EMPLOYEE_ID_FROM" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_EMPLOYEE_ID_FROM" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_EMPLOYEE_ID_FROM" value="<?= HtmlEncode($Grid->EMPLOYEE_ID_FROM->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_EMPLOYEE_ID_FROM" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_EMPLOYEE_ID_FROM" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_EMPLOYEE_ID_FROM" value="<?= HtmlEncode($Grid->EMPLOYEE_ID_FROM->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->DOCTOR_FROM->Visible) { // DOCTOR_FROM ?>
        <td data-name="DOCTOR_FROM" <?= $Grid->DOCTOR_FROM->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_DOCTOR_FROM" class="form-group">
<input type="<?= $Grid->DOCTOR_FROM->getInputTextType() ?>" data-table="V_TREAT" data-field="x_DOCTOR_FROM" name="x<?= $Grid->RowIndex ?>_DOCTOR_FROM" id="x<?= $Grid->RowIndex ?>_DOCTOR_FROM" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->DOCTOR_FROM->getPlaceHolder()) ?>" value="<?= $Grid->DOCTOR_FROM->EditValue ?>"<?= $Grid->DOCTOR_FROM->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->DOCTOR_FROM->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_DOCTOR_FROM" data-hidden="1" name="o<?= $Grid->RowIndex ?>_DOCTOR_FROM" id="o<?= $Grid->RowIndex ?>_DOCTOR_FROM" value="<?= HtmlEncode($Grid->DOCTOR_FROM->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_DOCTOR_FROM" class="form-group">
<input type="<?= $Grid->DOCTOR_FROM->getInputTextType() ?>" data-table="V_TREAT" data-field="x_DOCTOR_FROM" name="x<?= $Grid->RowIndex ?>_DOCTOR_FROM" id="x<?= $Grid->RowIndex ?>_DOCTOR_FROM" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->DOCTOR_FROM->getPlaceHolder()) ?>" value="<?= $Grid->DOCTOR_FROM->EditValue ?>"<?= $Grid->DOCTOR_FROM->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->DOCTOR_FROM->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_DOCTOR_FROM">
<span<?= $Grid->DOCTOR_FROM->viewAttributes() ?>>
<?= $Grid->DOCTOR_FROM->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_DOCTOR_FROM" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_DOCTOR_FROM" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_DOCTOR_FROM" value="<?= HtmlEncode($Grid->DOCTOR_FROM->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_DOCTOR_FROM" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_DOCTOR_FROM" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_DOCTOR_FROM" value="<?= HtmlEncode($Grid->DOCTOR_FROM->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->status_pasien_id->Visible) { // status_pasien_id ?>
        <td data-name="status_pasien_id" <?= $Grid->status_pasien_id->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_status_pasien_id" class="form-group">
<input type="<?= $Grid->status_pasien_id->getInputTextType() ?>" data-table="V_TREAT" data-field="x_status_pasien_id" name="x<?= $Grid->RowIndex ?>_status_pasien_id" id="x<?= $Grid->RowIndex ?>_status_pasien_id" size="30" placeholder="<?= HtmlEncode($Grid->status_pasien_id->getPlaceHolder()) ?>" value="<?= $Grid->status_pasien_id->EditValue ?>"<?= $Grid->status_pasien_id->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->status_pasien_id->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_status_pasien_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_status_pasien_id" id="o<?= $Grid->RowIndex ?>_status_pasien_id" value="<?= HtmlEncode($Grid->status_pasien_id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_status_pasien_id" class="form-group">
<input type="<?= $Grid->status_pasien_id->getInputTextType() ?>" data-table="V_TREAT" data-field="x_status_pasien_id" name="x<?= $Grid->RowIndex ?>_status_pasien_id" id="x<?= $Grid->RowIndex ?>_status_pasien_id" size="30" placeholder="<?= HtmlEncode($Grid->status_pasien_id->getPlaceHolder()) ?>" value="<?= $Grid->status_pasien_id->EditValue ?>"<?= $Grid->status_pasien_id->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->status_pasien_id->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_status_pasien_id">
<span<?= $Grid->status_pasien_id->viewAttributes() ?>>
<?= $Grid->status_pasien_id->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_status_pasien_id" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_status_pasien_id" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_status_pasien_id" value="<?= HtmlEncode($Grid->status_pasien_id->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_status_pasien_id" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_status_pasien_id" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_status_pasien_id" value="<?= HtmlEncode($Grid->status_pasien_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->THENAME->Visible) { // THENAME ?>
        <td data-name="THENAME" <?= $Grid->THENAME->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_THENAME" class="form-group">
<input type="<?= $Grid->THENAME->getInputTextType() ?>" data-table="V_TREAT" data-field="x_THENAME" name="x<?= $Grid->RowIndex ?>_THENAME" id="x<?= $Grid->RowIndex ?>_THENAME" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->THENAME->getPlaceHolder()) ?>" value="<?= $Grid->THENAME->EditValue ?>"<?= $Grid->THENAME->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->THENAME->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_THENAME" data-hidden="1" name="o<?= $Grid->RowIndex ?>_THENAME" id="o<?= $Grid->RowIndex ?>_THENAME" value="<?= HtmlEncode($Grid->THENAME->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_THENAME" class="form-group">
<input type="<?= $Grid->THENAME->getInputTextType() ?>" data-table="V_TREAT" data-field="x_THENAME" name="x<?= $Grid->RowIndex ?>_THENAME" id="x<?= $Grid->RowIndex ?>_THENAME" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->THENAME->getPlaceHolder()) ?>" value="<?= $Grid->THENAME->EditValue ?>"<?= $Grid->THENAME->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->THENAME->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_THENAME">
<span<?= $Grid->THENAME->viewAttributes() ?>>
<?= $Grid->THENAME->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_THENAME" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_THENAME" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_THENAME" value="<?= HtmlEncode($Grid->THENAME->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_THENAME" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_THENAME" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_THENAME" value="<?= HtmlEncode($Grid->THENAME->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->THEADDRESS->Visible) { // THEADDRESS ?>
        <td data-name="THEADDRESS" <?= $Grid->THEADDRESS->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_THEADDRESS" class="form-group">
<input type="<?= $Grid->THEADDRESS->getInputTextType() ?>" data-table="V_TREAT" data-field="x_THEADDRESS" name="x<?= $Grid->RowIndex ?>_THEADDRESS" id="x<?= $Grid->RowIndex ?>_THEADDRESS" size="30" maxlength="150" placeholder="<?= HtmlEncode($Grid->THEADDRESS->getPlaceHolder()) ?>" value="<?= $Grid->THEADDRESS->EditValue ?>"<?= $Grid->THEADDRESS->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->THEADDRESS->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_THEADDRESS" data-hidden="1" name="o<?= $Grid->RowIndex ?>_THEADDRESS" id="o<?= $Grid->RowIndex ?>_THEADDRESS" value="<?= HtmlEncode($Grid->THEADDRESS->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_THEADDRESS" class="form-group">
<input type="<?= $Grid->THEADDRESS->getInputTextType() ?>" data-table="V_TREAT" data-field="x_THEADDRESS" name="x<?= $Grid->RowIndex ?>_THEADDRESS" id="x<?= $Grid->RowIndex ?>_THEADDRESS" size="30" maxlength="150" placeholder="<?= HtmlEncode($Grid->THEADDRESS->getPlaceHolder()) ?>" value="<?= $Grid->THEADDRESS->EditValue ?>"<?= $Grid->THEADDRESS->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->THEADDRESS->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_THEADDRESS">
<span<?= $Grid->THEADDRESS->viewAttributes() ?>>
<?= $Grid->THEADDRESS->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_THEADDRESS" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_THEADDRESS" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_THEADDRESS" value="<?= HtmlEncode($Grid->THEADDRESS->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_THEADDRESS" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_THEADDRESS" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_THEADDRESS" value="<?= HtmlEncode($Grid->THEADDRESS->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->THEID->Visible) { // THEID ?>
        <td data-name="THEID" <?= $Grid->THEID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_THEID" class="form-group">
<input type="<?= $Grid->THEID->getInputTextType() ?>" data-table="V_TREAT" data-field="x_THEID" name="x<?= $Grid->RowIndex ?>_THEID" id="x<?= $Grid->RowIndex ?>_THEID" size="30" maxlength="25" placeholder="<?= HtmlEncode($Grid->THEID->getPlaceHolder()) ?>" value="<?= $Grid->THEID->EditValue ?>"<?= $Grid->THEID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->THEID->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_THEID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_THEID" id="o<?= $Grid->RowIndex ?>_THEID" value="<?= HtmlEncode($Grid->THEID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_THEID" class="form-group">
<input type="<?= $Grid->THEID->getInputTextType() ?>" data-table="V_TREAT" data-field="x_THEID" name="x<?= $Grid->RowIndex ?>_THEID" id="x<?= $Grid->RowIndex ?>_THEID" size="30" maxlength="25" placeholder="<?= HtmlEncode($Grid->THEID->getPlaceHolder()) ?>" value="<?= $Grid->THEID->EditValue ?>"<?= $Grid->THEID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->THEID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_THEID">
<span<?= $Grid->THEID->viewAttributes() ?>>
<?= $Grid->THEID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_THEID" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_THEID" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_THEID" value="<?= HtmlEncode($Grid->THEID->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_THEID" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_THEID" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_THEID" value="<?= HtmlEncode($Grid->THEID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->SERIAL_NB->Visible) { // SERIAL_NB ?>
        <td data-name="SERIAL_NB" <?= $Grid->SERIAL_NB->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_SERIAL_NB" class="form-group">
<input type="<?= $Grid->SERIAL_NB->getInputTextType() ?>" data-table="V_TREAT" data-field="x_SERIAL_NB" name="x<?= $Grid->RowIndex ?>_SERIAL_NB" id="x<?= $Grid->RowIndex ?>_SERIAL_NB" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->SERIAL_NB->getPlaceHolder()) ?>" value="<?= $Grid->SERIAL_NB->EditValue ?>"<?= $Grid->SERIAL_NB->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->SERIAL_NB->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_SERIAL_NB" data-hidden="1" name="o<?= $Grid->RowIndex ?>_SERIAL_NB" id="o<?= $Grid->RowIndex ?>_SERIAL_NB" value="<?= HtmlEncode($Grid->SERIAL_NB->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_SERIAL_NB" class="form-group">
<input type="<?= $Grid->SERIAL_NB->getInputTextType() ?>" data-table="V_TREAT" data-field="x_SERIAL_NB" name="x<?= $Grid->RowIndex ?>_SERIAL_NB" id="x<?= $Grid->RowIndex ?>_SERIAL_NB" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->SERIAL_NB->getPlaceHolder()) ?>" value="<?= $Grid->SERIAL_NB->EditValue ?>"<?= $Grid->SERIAL_NB->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->SERIAL_NB->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_SERIAL_NB">
<span<?= $Grid->SERIAL_NB->viewAttributes() ?>>
<?= $Grid->SERIAL_NB->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_SERIAL_NB" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_SERIAL_NB" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_SERIAL_NB" value="<?= HtmlEncode($Grid->SERIAL_NB->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_SERIAL_NB" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_SERIAL_NB" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_SERIAL_NB" value="<?= HtmlEncode($Grid->SERIAL_NB->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->ISRJ->Visible) { // ISRJ ?>
        <td data-name="ISRJ" <?= $Grid->ISRJ->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_ISRJ" class="form-group">
<input type="<?= $Grid->ISRJ->getInputTextType() ?>" data-table="V_TREAT" data-field="x_ISRJ" name="x<?= $Grid->RowIndex ?>_ISRJ" id="x<?= $Grid->RowIndex ?>_ISRJ" size="30" maxlength="1" placeholder="<?= HtmlEncode($Grid->ISRJ->getPlaceHolder()) ?>" value="<?= $Grid->ISRJ->EditValue ?>"<?= $Grid->ISRJ->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ISRJ->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_ISRJ" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ISRJ" id="o<?= $Grid->RowIndex ?>_ISRJ" value="<?= HtmlEncode($Grid->ISRJ->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_ISRJ" class="form-group">
<input type="<?= $Grid->ISRJ->getInputTextType() ?>" data-table="V_TREAT" data-field="x_ISRJ" name="x<?= $Grid->RowIndex ?>_ISRJ" id="x<?= $Grid->RowIndex ?>_ISRJ" size="30" maxlength="1" placeholder="<?= HtmlEncode($Grid->ISRJ->getPlaceHolder()) ?>" value="<?= $Grid->ISRJ->EditValue ?>"<?= $Grid->ISRJ->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ISRJ->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_ISRJ">
<span<?= $Grid->ISRJ->viewAttributes() ?>>
<?= $Grid->ISRJ->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_ISRJ" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_ISRJ" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_ISRJ" value="<?= HtmlEncode($Grid->ISRJ->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_ISRJ" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_ISRJ" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_ISRJ" value="<?= HtmlEncode($Grid->ISRJ->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->AGEYEAR->Visible) { // AGEYEAR ?>
        <td data-name="AGEYEAR" <?= $Grid->AGEYEAR->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_AGEYEAR" class="form-group">
<input type="<?= $Grid->AGEYEAR->getInputTextType() ?>" data-table="V_TREAT" data-field="x_AGEYEAR" name="x<?= $Grid->RowIndex ?>_AGEYEAR" id="x<?= $Grid->RowIndex ?>_AGEYEAR" size="30" placeholder="<?= HtmlEncode($Grid->AGEYEAR->getPlaceHolder()) ?>" value="<?= $Grid->AGEYEAR->EditValue ?>"<?= $Grid->AGEYEAR->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->AGEYEAR->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_AGEYEAR" data-hidden="1" name="o<?= $Grid->RowIndex ?>_AGEYEAR" id="o<?= $Grid->RowIndex ?>_AGEYEAR" value="<?= HtmlEncode($Grid->AGEYEAR->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_AGEYEAR" class="form-group">
<input type="<?= $Grid->AGEYEAR->getInputTextType() ?>" data-table="V_TREAT" data-field="x_AGEYEAR" name="x<?= $Grid->RowIndex ?>_AGEYEAR" id="x<?= $Grid->RowIndex ?>_AGEYEAR" size="30" placeholder="<?= HtmlEncode($Grid->AGEYEAR->getPlaceHolder()) ?>" value="<?= $Grid->AGEYEAR->EditValue ?>"<?= $Grid->AGEYEAR->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->AGEYEAR->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_AGEYEAR">
<span<?= $Grid->AGEYEAR->viewAttributes() ?>>
<?= $Grid->AGEYEAR->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_AGEYEAR" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_AGEYEAR" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_AGEYEAR" value="<?= HtmlEncode($Grid->AGEYEAR->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_AGEYEAR" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_AGEYEAR" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_AGEYEAR" value="<?= HtmlEncode($Grid->AGEYEAR->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->AGEMONTH->Visible) { // AGEMONTH ?>
        <td data-name="AGEMONTH" <?= $Grid->AGEMONTH->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_AGEMONTH" class="form-group">
<input type="<?= $Grid->AGEMONTH->getInputTextType() ?>" data-table="V_TREAT" data-field="x_AGEMONTH" name="x<?= $Grid->RowIndex ?>_AGEMONTH" id="x<?= $Grid->RowIndex ?>_AGEMONTH" size="30" placeholder="<?= HtmlEncode($Grid->AGEMONTH->getPlaceHolder()) ?>" value="<?= $Grid->AGEMONTH->EditValue ?>"<?= $Grid->AGEMONTH->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->AGEMONTH->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_AGEMONTH" data-hidden="1" name="o<?= $Grid->RowIndex ?>_AGEMONTH" id="o<?= $Grid->RowIndex ?>_AGEMONTH" value="<?= HtmlEncode($Grid->AGEMONTH->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_AGEMONTH" class="form-group">
<input type="<?= $Grid->AGEMONTH->getInputTextType() ?>" data-table="V_TREAT" data-field="x_AGEMONTH" name="x<?= $Grid->RowIndex ?>_AGEMONTH" id="x<?= $Grid->RowIndex ?>_AGEMONTH" size="30" placeholder="<?= HtmlEncode($Grid->AGEMONTH->getPlaceHolder()) ?>" value="<?= $Grid->AGEMONTH->EditValue ?>"<?= $Grid->AGEMONTH->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->AGEMONTH->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_AGEMONTH">
<span<?= $Grid->AGEMONTH->viewAttributes() ?>>
<?= $Grid->AGEMONTH->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_AGEMONTH" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_AGEMONTH" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_AGEMONTH" value="<?= HtmlEncode($Grid->AGEMONTH->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_AGEMONTH" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_AGEMONTH" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_AGEMONTH" value="<?= HtmlEncode($Grid->AGEMONTH->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->AGEDAY->Visible) { // AGEDAY ?>
        <td data-name="AGEDAY" <?= $Grid->AGEDAY->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_AGEDAY" class="form-group">
<input type="<?= $Grid->AGEDAY->getInputTextType() ?>" data-table="V_TREAT" data-field="x_AGEDAY" name="x<?= $Grid->RowIndex ?>_AGEDAY" id="x<?= $Grid->RowIndex ?>_AGEDAY" size="30" placeholder="<?= HtmlEncode($Grid->AGEDAY->getPlaceHolder()) ?>" value="<?= $Grid->AGEDAY->EditValue ?>"<?= $Grid->AGEDAY->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->AGEDAY->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_AGEDAY" data-hidden="1" name="o<?= $Grid->RowIndex ?>_AGEDAY" id="o<?= $Grid->RowIndex ?>_AGEDAY" value="<?= HtmlEncode($Grid->AGEDAY->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_AGEDAY" class="form-group">
<input type="<?= $Grid->AGEDAY->getInputTextType() ?>" data-table="V_TREAT" data-field="x_AGEDAY" name="x<?= $Grid->RowIndex ?>_AGEDAY" id="x<?= $Grid->RowIndex ?>_AGEDAY" size="30" placeholder="<?= HtmlEncode($Grid->AGEDAY->getPlaceHolder()) ?>" value="<?= $Grid->AGEDAY->EditValue ?>"<?= $Grid->AGEDAY->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->AGEDAY->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_AGEDAY">
<span<?= $Grid->AGEDAY->viewAttributes() ?>>
<?= $Grid->AGEDAY->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_AGEDAY" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_AGEDAY" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_AGEDAY" value="<?= HtmlEncode($Grid->AGEDAY->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_AGEDAY" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_AGEDAY" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_AGEDAY" value="<?= HtmlEncode($Grid->AGEDAY->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->GENDER->Visible) { // GENDER ?>
        <td data-name="GENDER" <?= $Grid->GENDER->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_GENDER" class="form-group">
<input type="<?= $Grid->GENDER->getInputTextType() ?>" data-table="V_TREAT" data-field="x_GENDER" name="x<?= $Grid->RowIndex ?>_GENDER" id="x<?= $Grid->RowIndex ?>_GENDER" size="30" maxlength="1" placeholder="<?= HtmlEncode($Grid->GENDER->getPlaceHolder()) ?>" value="<?= $Grid->GENDER->EditValue ?>"<?= $Grid->GENDER->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->GENDER->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_GENDER" data-hidden="1" name="o<?= $Grid->RowIndex ?>_GENDER" id="o<?= $Grid->RowIndex ?>_GENDER" value="<?= HtmlEncode($Grid->GENDER->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_GENDER" class="form-group">
<input type="<?= $Grid->GENDER->getInputTextType() ?>" data-table="V_TREAT" data-field="x_GENDER" name="x<?= $Grid->RowIndex ?>_GENDER" id="x<?= $Grid->RowIndex ?>_GENDER" size="30" maxlength="1" placeholder="<?= HtmlEncode($Grid->GENDER->getPlaceHolder()) ?>" value="<?= $Grid->GENDER->EditValue ?>"<?= $Grid->GENDER->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->GENDER->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_GENDER">
<span<?= $Grid->GENDER->viewAttributes() ?>>
<?= $Grid->GENDER->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_GENDER" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_GENDER" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_GENDER" value="<?= HtmlEncode($Grid->GENDER->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_GENDER" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_GENDER" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_GENDER" value="<?= HtmlEncode($Grid->GENDER->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->KARYAWAN->Visible) { // KARYAWAN ?>
        <td data-name="KARYAWAN" <?= $Grid->KARYAWAN->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_KARYAWAN" class="form-group">
<input type="<?= $Grid->KARYAWAN->getInputTextType() ?>" data-table="V_TREAT" data-field="x_KARYAWAN" name="x<?= $Grid->RowIndex ?>_KARYAWAN" id="x<?= $Grid->RowIndex ?>_KARYAWAN" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->KARYAWAN->getPlaceHolder()) ?>" value="<?= $Grid->KARYAWAN->EditValue ?>"<?= $Grid->KARYAWAN->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->KARYAWAN->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_KARYAWAN" data-hidden="1" name="o<?= $Grid->RowIndex ?>_KARYAWAN" id="o<?= $Grid->RowIndex ?>_KARYAWAN" value="<?= HtmlEncode($Grid->KARYAWAN->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_KARYAWAN" class="form-group">
<input type="<?= $Grid->KARYAWAN->getInputTextType() ?>" data-table="V_TREAT" data-field="x_KARYAWAN" name="x<?= $Grid->RowIndex ?>_KARYAWAN" id="x<?= $Grid->RowIndex ?>_KARYAWAN" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->KARYAWAN->getPlaceHolder()) ?>" value="<?= $Grid->KARYAWAN->EditValue ?>"<?= $Grid->KARYAWAN->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->KARYAWAN->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_KARYAWAN">
<span<?= $Grid->KARYAWAN->viewAttributes() ?>>
<?= $Grid->KARYAWAN->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_KARYAWAN" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_KARYAWAN" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_KARYAWAN" value="<?= HtmlEncode($Grid->KARYAWAN->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_KARYAWAN" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_KARYAWAN" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_KARYAWAN" value="<?= HtmlEncode($Grid->KARYAWAN->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
        <td data-name="MODIFIED_BY" <?= $Grid->MODIFIED_BY->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_MODIFIED_BY" class="form-group">
<input type="<?= $Grid->MODIFIED_BY->getInputTextType() ?>" data-table="V_TREAT" data-field="x_MODIFIED_BY" name="x<?= $Grid->RowIndex ?>_MODIFIED_BY" id="x<?= $Grid->RowIndex ?>_MODIFIED_BY" size="30" maxlength="200" placeholder="<?= HtmlEncode($Grid->MODIFIED_BY->getPlaceHolder()) ?>" value="<?= $Grid->MODIFIED_BY->EditValue ?>"<?= $Grid->MODIFIED_BY->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->MODIFIED_BY->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_MODIFIED_BY" data-hidden="1" name="o<?= $Grid->RowIndex ?>_MODIFIED_BY" id="o<?= $Grid->RowIndex ?>_MODIFIED_BY" value="<?= HtmlEncode($Grid->MODIFIED_BY->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_MODIFIED_BY" class="form-group">
<input type="<?= $Grid->MODIFIED_BY->getInputTextType() ?>" data-table="V_TREAT" data-field="x_MODIFIED_BY" name="x<?= $Grid->RowIndex ?>_MODIFIED_BY" id="x<?= $Grid->RowIndex ?>_MODIFIED_BY" size="30" maxlength="200" placeholder="<?= HtmlEncode($Grid->MODIFIED_BY->getPlaceHolder()) ?>" value="<?= $Grid->MODIFIED_BY->EditValue ?>"<?= $Grid->MODIFIED_BY->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->MODIFIED_BY->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_MODIFIED_BY">
<span<?= $Grid->MODIFIED_BY->viewAttributes() ?>>
<?= $Grid->MODIFIED_BY->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_MODIFIED_BY" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_MODIFIED_BY" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_MODIFIED_BY" value="<?= HtmlEncode($Grid->MODIFIED_BY->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_MODIFIED_BY" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_MODIFIED_BY" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_MODIFIED_BY" value="<?= HtmlEncode($Grid->MODIFIED_BY->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
        <td data-name="MODIFIED_DATE" <?= $Grid->MODIFIED_DATE->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_MODIFIED_DATE" class="form-group">
<input type="<?= $Grid->MODIFIED_DATE->getInputTextType() ?>" data-table="V_TREAT" data-field="x_MODIFIED_DATE" name="x<?= $Grid->RowIndex ?>_MODIFIED_DATE" id="x<?= $Grid->RowIndex ?>_MODIFIED_DATE" placeholder="<?= HtmlEncode($Grid->MODIFIED_DATE->getPlaceHolder()) ?>" value="<?= $Grid->MODIFIED_DATE->EditValue ?>"<?= $Grid->MODIFIED_DATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->MODIFIED_DATE->getErrorMessage() ?></div>
<?php if (!$Grid->MODIFIED_DATE->ReadOnly && !$Grid->MODIFIED_DATE->Disabled && !isset($Grid->MODIFIED_DATE->EditAttrs["readonly"]) && !isset($Grid->MODIFIED_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fV_TREATgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fV_TREATgrid", "x<?= $Grid->RowIndex ?>_MODIFIED_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_MODIFIED_DATE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_MODIFIED_DATE" id="o<?= $Grid->RowIndex ?>_MODIFIED_DATE" value="<?= HtmlEncode($Grid->MODIFIED_DATE->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_MODIFIED_DATE" class="form-group">
<input type="<?= $Grid->MODIFIED_DATE->getInputTextType() ?>" data-table="V_TREAT" data-field="x_MODIFIED_DATE" name="x<?= $Grid->RowIndex ?>_MODIFIED_DATE" id="x<?= $Grid->RowIndex ?>_MODIFIED_DATE" placeholder="<?= HtmlEncode($Grid->MODIFIED_DATE->getPlaceHolder()) ?>" value="<?= $Grid->MODIFIED_DATE->EditValue ?>"<?= $Grid->MODIFIED_DATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->MODIFIED_DATE->getErrorMessage() ?></div>
<?php if (!$Grid->MODIFIED_DATE->ReadOnly && !$Grid->MODIFIED_DATE->Disabled && !isset($Grid->MODIFIED_DATE->EditAttrs["readonly"]) && !isset($Grid->MODIFIED_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fV_TREATgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fV_TREATgrid", "x<?= $Grid->RowIndex ?>_MODIFIED_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_MODIFIED_DATE">
<span<?= $Grid->MODIFIED_DATE->viewAttributes() ?>>
<?= $Grid->MODIFIED_DATE->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_MODIFIED_DATE" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_MODIFIED_DATE" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_MODIFIED_DATE" value="<?= HtmlEncode($Grid->MODIFIED_DATE->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_MODIFIED_DATE" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_MODIFIED_DATE" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_MODIFIED_DATE" value="<?= HtmlEncode($Grid->MODIFIED_DATE->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->MODIFIED_FROM->Visible) { // MODIFIED_FROM ?>
        <td data-name="MODIFIED_FROM" <?= $Grid->MODIFIED_FROM->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_MODIFIED_FROM" class="form-group">
<input type="<?= $Grid->MODIFIED_FROM->getInputTextType() ?>" data-table="V_TREAT" data-field="x_MODIFIED_FROM" name="x<?= $Grid->RowIndex ?>_MODIFIED_FROM" id="x<?= $Grid->RowIndex ?>_MODIFIED_FROM" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->MODIFIED_FROM->getPlaceHolder()) ?>" value="<?= $Grid->MODIFIED_FROM->EditValue ?>"<?= $Grid->MODIFIED_FROM->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->MODIFIED_FROM->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_MODIFIED_FROM" data-hidden="1" name="o<?= $Grid->RowIndex ?>_MODIFIED_FROM" id="o<?= $Grid->RowIndex ?>_MODIFIED_FROM" value="<?= HtmlEncode($Grid->MODIFIED_FROM->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_MODIFIED_FROM" class="form-group">
<input type="<?= $Grid->MODIFIED_FROM->getInputTextType() ?>" data-table="V_TREAT" data-field="x_MODIFIED_FROM" name="x<?= $Grid->RowIndex ?>_MODIFIED_FROM" id="x<?= $Grid->RowIndex ?>_MODIFIED_FROM" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->MODIFIED_FROM->getPlaceHolder()) ?>" value="<?= $Grid->MODIFIED_FROM->EditValue ?>"<?= $Grid->MODIFIED_FROM->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->MODIFIED_FROM->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_MODIFIED_FROM">
<span<?= $Grid->MODIFIED_FROM->viewAttributes() ?>>
<?= $Grid->MODIFIED_FROM->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_MODIFIED_FROM" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_MODIFIED_FROM" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_MODIFIED_FROM" value="<?= HtmlEncode($Grid->MODIFIED_FROM->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_MODIFIED_FROM" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_MODIFIED_FROM" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_MODIFIED_FROM" value="<?= HtmlEncode($Grid->MODIFIED_FROM->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->NUMER->Visible) { // NUMER ?>
        <td data-name="NUMER" <?= $Grid->NUMER->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_NUMER" class="form-group">
<input type="<?= $Grid->NUMER->getInputTextType() ?>" data-table="V_TREAT" data-field="x_NUMER" name="x<?= $Grid->RowIndex ?>_NUMER" id="x<?= $Grid->RowIndex ?>_NUMER" size="30" maxlength="15" placeholder="<?= HtmlEncode($Grid->NUMER->getPlaceHolder()) ?>" value="<?= $Grid->NUMER->EditValue ?>"<?= $Grid->NUMER->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->NUMER->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_NUMER" data-hidden="1" name="o<?= $Grid->RowIndex ?>_NUMER" id="o<?= $Grid->RowIndex ?>_NUMER" value="<?= HtmlEncode($Grid->NUMER->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_NUMER" class="form-group">
<input type="<?= $Grid->NUMER->getInputTextType() ?>" data-table="V_TREAT" data-field="x_NUMER" name="x<?= $Grid->RowIndex ?>_NUMER" id="x<?= $Grid->RowIndex ?>_NUMER" size="30" maxlength="15" placeholder="<?= HtmlEncode($Grid->NUMER->getPlaceHolder()) ?>" value="<?= $Grid->NUMER->EditValue ?>"<?= $Grid->NUMER->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->NUMER->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_NUMER">
<span<?= $Grid->NUMER->viewAttributes() ?>>
<?= $Grid->NUMER->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_NUMER" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_NUMER" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_NUMER" value="<?= HtmlEncode($Grid->NUMER->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_NUMER" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_NUMER" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_NUMER" value="<?= HtmlEncode($Grid->NUMER->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->NOTA_NO->Visible) { // NOTA_NO ?>
        <td data-name="NOTA_NO" <?= $Grid->NOTA_NO->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_NOTA_NO" class="form-group">
<input type="<?= $Grid->NOTA_NO->getInputTextType() ?>" data-table="V_TREAT" data-field="x_NOTA_NO" name="x<?= $Grid->RowIndex ?>_NOTA_NO" id="x<?= $Grid->RowIndex ?>_NOTA_NO" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->NOTA_NO->getPlaceHolder()) ?>" value="<?= $Grid->NOTA_NO->EditValue ?>"<?= $Grid->NOTA_NO->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->NOTA_NO->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_NOTA_NO" data-hidden="1" name="o<?= $Grid->RowIndex ?>_NOTA_NO" id="o<?= $Grid->RowIndex ?>_NOTA_NO" value="<?= HtmlEncode($Grid->NOTA_NO->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_NOTA_NO" class="form-group">
<input type="<?= $Grid->NOTA_NO->getInputTextType() ?>" data-table="V_TREAT" data-field="x_NOTA_NO" name="x<?= $Grid->RowIndex ?>_NOTA_NO" id="x<?= $Grid->RowIndex ?>_NOTA_NO" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->NOTA_NO->getPlaceHolder()) ?>" value="<?= $Grid->NOTA_NO->EditValue ?>"<?= $Grid->NOTA_NO->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->NOTA_NO->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_NOTA_NO">
<span<?= $Grid->NOTA_NO->viewAttributes() ?>>
<?= $Grid->NOTA_NO->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_NOTA_NO" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_NOTA_NO" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_NOTA_NO" value="<?= HtmlEncode($Grid->NOTA_NO->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_NOTA_NO" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_NOTA_NO" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_NOTA_NO" value="<?= HtmlEncode($Grid->NOTA_NO->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->MEASURE_ID2->Visible) { // MEASURE_ID2 ?>
        <td data-name="MEASURE_ID2" <?= $Grid->MEASURE_ID2->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_MEASURE_ID2" class="form-group">
<input type="<?= $Grid->MEASURE_ID2->getInputTextType() ?>" data-table="V_TREAT" data-field="x_MEASURE_ID2" name="x<?= $Grid->RowIndex ?>_MEASURE_ID2" id="x<?= $Grid->RowIndex ?>_MEASURE_ID2" size="30" placeholder="<?= HtmlEncode($Grid->MEASURE_ID2->getPlaceHolder()) ?>" value="<?= $Grid->MEASURE_ID2->EditValue ?>"<?= $Grid->MEASURE_ID2->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->MEASURE_ID2->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_MEASURE_ID2" data-hidden="1" name="o<?= $Grid->RowIndex ?>_MEASURE_ID2" id="o<?= $Grid->RowIndex ?>_MEASURE_ID2" value="<?= HtmlEncode($Grid->MEASURE_ID2->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_MEASURE_ID2" class="form-group">
<input type="<?= $Grid->MEASURE_ID2->getInputTextType() ?>" data-table="V_TREAT" data-field="x_MEASURE_ID2" name="x<?= $Grid->RowIndex ?>_MEASURE_ID2" id="x<?= $Grid->RowIndex ?>_MEASURE_ID2" size="30" placeholder="<?= HtmlEncode($Grid->MEASURE_ID2->getPlaceHolder()) ?>" value="<?= $Grid->MEASURE_ID2->EditValue ?>"<?= $Grid->MEASURE_ID2->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->MEASURE_ID2->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_MEASURE_ID2">
<span<?= $Grid->MEASURE_ID2->viewAttributes() ?>>
<?= $Grid->MEASURE_ID2->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_MEASURE_ID2" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_MEASURE_ID2" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_MEASURE_ID2" value="<?= HtmlEncode($Grid->MEASURE_ID2->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_MEASURE_ID2" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_MEASURE_ID2" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_MEASURE_ID2" value="<?= HtmlEncode($Grid->MEASURE_ID2->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->POTONGAN->Visible) { // POTONGAN ?>
        <td data-name="POTONGAN" <?= $Grid->POTONGAN->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_POTONGAN" class="form-group">
<input type="<?= $Grid->POTONGAN->getInputTextType() ?>" data-table="V_TREAT" data-field="x_POTONGAN" name="x<?= $Grid->RowIndex ?>_POTONGAN" id="x<?= $Grid->RowIndex ?>_POTONGAN" size="30" placeholder="<?= HtmlEncode($Grid->POTONGAN->getPlaceHolder()) ?>" value="<?= $Grid->POTONGAN->EditValue ?>"<?= $Grid->POTONGAN->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->POTONGAN->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_POTONGAN" data-hidden="1" name="o<?= $Grid->RowIndex ?>_POTONGAN" id="o<?= $Grid->RowIndex ?>_POTONGAN" value="<?= HtmlEncode($Grid->POTONGAN->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_POTONGAN" class="form-group">
<input type="<?= $Grid->POTONGAN->getInputTextType() ?>" data-table="V_TREAT" data-field="x_POTONGAN" name="x<?= $Grid->RowIndex ?>_POTONGAN" id="x<?= $Grid->RowIndex ?>_POTONGAN" size="30" placeholder="<?= HtmlEncode($Grid->POTONGAN->getPlaceHolder()) ?>" value="<?= $Grid->POTONGAN->EditValue ?>"<?= $Grid->POTONGAN->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->POTONGAN->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_POTONGAN">
<span<?= $Grid->POTONGAN->viewAttributes() ?>>
<?= $Grid->POTONGAN->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_POTONGAN" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_POTONGAN" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_POTONGAN" value="<?= HtmlEncode($Grid->POTONGAN->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_POTONGAN" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_POTONGAN" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_POTONGAN" value="<?= HtmlEncode($Grid->POTONGAN->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->BAYAR->Visible) { // BAYAR ?>
        <td data-name="BAYAR" <?= $Grid->BAYAR->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_BAYAR" class="form-group">
<input type="<?= $Grid->BAYAR->getInputTextType() ?>" data-table="V_TREAT" data-field="x_BAYAR" name="x<?= $Grid->RowIndex ?>_BAYAR" id="x<?= $Grid->RowIndex ?>_BAYAR" size="30" placeholder="<?= HtmlEncode($Grid->BAYAR->getPlaceHolder()) ?>" value="<?= $Grid->BAYAR->EditValue ?>"<?= $Grid->BAYAR->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->BAYAR->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_BAYAR" data-hidden="1" name="o<?= $Grid->RowIndex ?>_BAYAR" id="o<?= $Grid->RowIndex ?>_BAYAR" value="<?= HtmlEncode($Grid->BAYAR->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_BAYAR" class="form-group">
<input type="<?= $Grid->BAYAR->getInputTextType() ?>" data-table="V_TREAT" data-field="x_BAYAR" name="x<?= $Grid->RowIndex ?>_BAYAR" id="x<?= $Grid->RowIndex ?>_BAYAR" size="30" placeholder="<?= HtmlEncode($Grid->BAYAR->getPlaceHolder()) ?>" value="<?= $Grid->BAYAR->EditValue ?>"<?= $Grid->BAYAR->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->BAYAR->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_BAYAR">
<span<?= $Grid->BAYAR->viewAttributes() ?>>
<?= $Grid->BAYAR->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_BAYAR" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_BAYAR" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_BAYAR" value="<?= HtmlEncode($Grid->BAYAR->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_BAYAR" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_BAYAR" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_BAYAR" value="<?= HtmlEncode($Grid->BAYAR->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->RETUR->Visible) { // RETUR ?>
        <td data-name="RETUR" <?= $Grid->RETUR->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_RETUR" class="form-group">
<input type="<?= $Grid->RETUR->getInputTextType() ?>" data-table="V_TREAT" data-field="x_RETUR" name="x<?= $Grid->RowIndex ?>_RETUR" id="x<?= $Grid->RowIndex ?>_RETUR" size="30" placeholder="<?= HtmlEncode($Grid->RETUR->getPlaceHolder()) ?>" value="<?= $Grid->RETUR->EditValue ?>"<?= $Grid->RETUR->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->RETUR->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_RETUR" data-hidden="1" name="o<?= $Grid->RowIndex ?>_RETUR" id="o<?= $Grid->RowIndex ?>_RETUR" value="<?= HtmlEncode($Grid->RETUR->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_RETUR" class="form-group">
<input type="<?= $Grid->RETUR->getInputTextType() ?>" data-table="V_TREAT" data-field="x_RETUR" name="x<?= $Grid->RowIndex ?>_RETUR" id="x<?= $Grid->RowIndex ?>_RETUR" size="30" placeholder="<?= HtmlEncode($Grid->RETUR->getPlaceHolder()) ?>" value="<?= $Grid->RETUR->EditValue ?>"<?= $Grid->RETUR->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->RETUR->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_RETUR">
<span<?= $Grid->RETUR->viewAttributes() ?>>
<?= $Grid->RETUR->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_RETUR" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_RETUR" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_RETUR" value="<?= HtmlEncode($Grid->RETUR->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_RETUR" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_RETUR" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_RETUR" value="<?= HtmlEncode($Grid->RETUR->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->TARIF_TYPE->Visible) { // TARIF_TYPE ?>
        <td data-name="TARIF_TYPE" <?= $Grid->TARIF_TYPE->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_TARIF_TYPE" class="form-group">
<input type="<?= $Grid->TARIF_TYPE->getInputTextType() ?>" data-table="V_TREAT" data-field="x_TARIF_TYPE" name="x<?= $Grid->RowIndex ?>_TARIF_TYPE" id="x<?= $Grid->RowIndex ?>_TARIF_TYPE" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->TARIF_TYPE->getPlaceHolder()) ?>" value="<?= $Grid->TARIF_TYPE->EditValue ?>"<?= $Grid->TARIF_TYPE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->TARIF_TYPE->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_TARIF_TYPE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_TARIF_TYPE" id="o<?= $Grid->RowIndex ?>_TARIF_TYPE" value="<?= HtmlEncode($Grid->TARIF_TYPE->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_TARIF_TYPE" class="form-group">
<input type="<?= $Grid->TARIF_TYPE->getInputTextType() ?>" data-table="V_TREAT" data-field="x_TARIF_TYPE" name="x<?= $Grid->RowIndex ?>_TARIF_TYPE" id="x<?= $Grid->RowIndex ?>_TARIF_TYPE" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->TARIF_TYPE->getPlaceHolder()) ?>" value="<?= $Grid->TARIF_TYPE->EditValue ?>"<?= $Grid->TARIF_TYPE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->TARIF_TYPE->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_TARIF_TYPE">
<span<?= $Grid->TARIF_TYPE->viewAttributes() ?>>
<?= $Grid->TARIF_TYPE->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_TARIF_TYPE" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_TARIF_TYPE" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_TARIF_TYPE" value="<?= HtmlEncode($Grid->TARIF_TYPE->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_TARIF_TYPE" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_TARIF_TYPE" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_TARIF_TYPE" value="<?= HtmlEncode($Grid->TARIF_TYPE->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->PPNVALUE->Visible) { // PPNVALUE ?>
        <td data-name="PPNVALUE" <?= $Grid->PPNVALUE->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_PPNVALUE" class="form-group">
<input type="<?= $Grid->PPNVALUE->getInputTextType() ?>" data-table="V_TREAT" data-field="x_PPNVALUE" name="x<?= $Grid->RowIndex ?>_PPNVALUE" id="x<?= $Grid->RowIndex ?>_PPNVALUE" size="30" placeholder="<?= HtmlEncode($Grid->PPNVALUE->getPlaceHolder()) ?>" value="<?= $Grid->PPNVALUE->EditValue ?>"<?= $Grid->PPNVALUE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->PPNVALUE->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_PPNVALUE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_PPNVALUE" id="o<?= $Grid->RowIndex ?>_PPNVALUE" value="<?= HtmlEncode($Grid->PPNVALUE->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_PPNVALUE" class="form-group">
<input type="<?= $Grid->PPNVALUE->getInputTextType() ?>" data-table="V_TREAT" data-field="x_PPNVALUE" name="x<?= $Grid->RowIndex ?>_PPNVALUE" id="x<?= $Grid->RowIndex ?>_PPNVALUE" size="30" placeholder="<?= HtmlEncode($Grid->PPNVALUE->getPlaceHolder()) ?>" value="<?= $Grid->PPNVALUE->EditValue ?>"<?= $Grid->PPNVALUE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->PPNVALUE->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_PPNVALUE">
<span<?= $Grid->PPNVALUE->viewAttributes() ?>>
<?= $Grid->PPNVALUE->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_PPNVALUE" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_PPNVALUE" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_PPNVALUE" value="<?= HtmlEncode($Grid->PPNVALUE->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_PPNVALUE" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_PPNVALUE" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_PPNVALUE" value="<?= HtmlEncode($Grid->PPNVALUE->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->TAGIHAN->Visible) { // TAGIHAN ?>
        <td data-name="TAGIHAN" <?= $Grid->TAGIHAN->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_TAGIHAN" class="form-group">
<input type="<?= $Grid->TAGIHAN->getInputTextType() ?>" data-table="V_TREAT" data-field="x_TAGIHAN" name="x<?= $Grid->RowIndex ?>_TAGIHAN" id="x<?= $Grid->RowIndex ?>_TAGIHAN" size="30" placeholder="<?= HtmlEncode($Grid->TAGIHAN->getPlaceHolder()) ?>" value="<?= $Grid->TAGIHAN->EditValue ?>"<?= $Grid->TAGIHAN->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->TAGIHAN->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_TAGIHAN" data-hidden="1" name="o<?= $Grid->RowIndex ?>_TAGIHAN" id="o<?= $Grid->RowIndex ?>_TAGIHAN" value="<?= HtmlEncode($Grid->TAGIHAN->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_TAGIHAN" class="form-group">
<input type="<?= $Grid->TAGIHAN->getInputTextType() ?>" data-table="V_TREAT" data-field="x_TAGIHAN" name="x<?= $Grid->RowIndex ?>_TAGIHAN" id="x<?= $Grid->RowIndex ?>_TAGIHAN" size="30" placeholder="<?= HtmlEncode($Grid->TAGIHAN->getPlaceHolder()) ?>" value="<?= $Grid->TAGIHAN->EditValue ?>"<?= $Grid->TAGIHAN->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->TAGIHAN->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_TAGIHAN">
<span<?= $Grid->TAGIHAN->viewAttributes() ?>>
<?= $Grid->TAGIHAN->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_TAGIHAN" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_TAGIHAN" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_TAGIHAN" value="<?= HtmlEncode($Grid->TAGIHAN->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_TAGIHAN" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_TAGIHAN" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_TAGIHAN" value="<?= HtmlEncode($Grid->TAGIHAN->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->KOREKSI->Visible) { // KOREKSI ?>
        <td data-name="KOREKSI" <?= $Grid->KOREKSI->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_KOREKSI" class="form-group">
<input type="<?= $Grid->KOREKSI->getInputTextType() ?>" data-table="V_TREAT" data-field="x_KOREKSI" name="x<?= $Grid->RowIndex ?>_KOREKSI" id="x<?= $Grid->RowIndex ?>_KOREKSI" size="30" placeholder="<?= HtmlEncode($Grid->KOREKSI->getPlaceHolder()) ?>" value="<?= $Grid->KOREKSI->EditValue ?>"<?= $Grid->KOREKSI->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->KOREKSI->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_KOREKSI" data-hidden="1" name="o<?= $Grid->RowIndex ?>_KOREKSI" id="o<?= $Grid->RowIndex ?>_KOREKSI" value="<?= HtmlEncode($Grid->KOREKSI->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_KOREKSI" class="form-group">
<input type="<?= $Grid->KOREKSI->getInputTextType() ?>" data-table="V_TREAT" data-field="x_KOREKSI" name="x<?= $Grid->RowIndex ?>_KOREKSI" id="x<?= $Grid->RowIndex ?>_KOREKSI" size="30" placeholder="<?= HtmlEncode($Grid->KOREKSI->getPlaceHolder()) ?>" value="<?= $Grid->KOREKSI->EditValue ?>"<?= $Grid->KOREKSI->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->KOREKSI->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_KOREKSI">
<span<?= $Grid->KOREKSI->viewAttributes() ?>>
<?= $Grid->KOREKSI->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_KOREKSI" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_KOREKSI" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_KOREKSI" value="<?= HtmlEncode($Grid->KOREKSI->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_KOREKSI" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_KOREKSI" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_KOREKSI" value="<?= HtmlEncode($Grid->KOREKSI->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->AMOUNT_PAID->Visible) { // AMOUNT_PAID ?>
        <td data-name="AMOUNT_PAID" <?= $Grid->AMOUNT_PAID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_AMOUNT_PAID" class="form-group">
<input type="<?= $Grid->AMOUNT_PAID->getInputTextType() ?>" data-table="V_TREAT" data-field="x_AMOUNT_PAID" name="x<?= $Grid->RowIndex ?>_AMOUNT_PAID" id="x<?= $Grid->RowIndex ?>_AMOUNT_PAID" size="30" placeholder="<?= HtmlEncode($Grid->AMOUNT_PAID->getPlaceHolder()) ?>" value="<?= $Grid->AMOUNT_PAID->EditValue ?>"<?= $Grid->AMOUNT_PAID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->AMOUNT_PAID->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_AMOUNT_PAID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_AMOUNT_PAID" id="o<?= $Grid->RowIndex ?>_AMOUNT_PAID" value="<?= HtmlEncode($Grid->AMOUNT_PAID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_AMOUNT_PAID" class="form-group">
<input type="<?= $Grid->AMOUNT_PAID->getInputTextType() ?>" data-table="V_TREAT" data-field="x_AMOUNT_PAID" name="x<?= $Grid->RowIndex ?>_AMOUNT_PAID" id="x<?= $Grid->RowIndex ?>_AMOUNT_PAID" size="30" placeholder="<?= HtmlEncode($Grid->AMOUNT_PAID->getPlaceHolder()) ?>" value="<?= $Grid->AMOUNT_PAID->EditValue ?>"<?= $Grid->AMOUNT_PAID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->AMOUNT_PAID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_AMOUNT_PAID">
<span<?= $Grid->AMOUNT_PAID->viewAttributes() ?>>
<?= $Grid->AMOUNT_PAID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_AMOUNT_PAID" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_AMOUNT_PAID" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_AMOUNT_PAID" value="<?= HtmlEncode($Grid->AMOUNT_PAID->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_AMOUNT_PAID" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_AMOUNT_PAID" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_AMOUNT_PAID" value="<?= HtmlEncode($Grid->AMOUNT_PAID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->DISKON->Visible) { // DISKON ?>
        <td data-name="DISKON" <?= $Grid->DISKON->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_DISKON" class="form-group">
<input type="<?= $Grid->DISKON->getInputTextType() ?>" data-table="V_TREAT" data-field="x_DISKON" name="x<?= $Grid->RowIndex ?>_DISKON" id="x<?= $Grid->RowIndex ?>_DISKON" size="30" placeholder="<?= HtmlEncode($Grid->DISKON->getPlaceHolder()) ?>" value="<?= $Grid->DISKON->EditValue ?>"<?= $Grid->DISKON->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->DISKON->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_DISKON" data-hidden="1" name="o<?= $Grid->RowIndex ?>_DISKON" id="o<?= $Grid->RowIndex ?>_DISKON" value="<?= HtmlEncode($Grid->DISKON->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_DISKON" class="form-group">
<input type="<?= $Grid->DISKON->getInputTextType() ?>" data-table="V_TREAT" data-field="x_DISKON" name="x<?= $Grid->RowIndex ?>_DISKON" id="x<?= $Grid->RowIndex ?>_DISKON" size="30" placeholder="<?= HtmlEncode($Grid->DISKON->getPlaceHolder()) ?>" value="<?= $Grid->DISKON->EditValue ?>"<?= $Grid->DISKON->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->DISKON->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_DISKON">
<span<?= $Grid->DISKON->viewAttributes() ?>>
<?= $Grid->DISKON->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_DISKON" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_DISKON" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_DISKON" value="<?= HtmlEncode($Grid->DISKON->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_DISKON" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_DISKON" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_DISKON" value="<?= HtmlEncode($Grid->DISKON->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->SELL_PRICE->Visible) { // SELL_PRICE ?>
        <td data-name="SELL_PRICE" <?= $Grid->SELL_PRICE->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_SELL_PRICE" class="form-group">
<input type="<?= $Grid->SELL_PRICE->getInputTextType() ?>" data-table="V_TREAT" data-field="x_SELL_PRICE" name="x<?= $Grid->RowIndex ?>_SELL_PRICE" id="x<?= $Grid->RowIndex ?>_SELL_PRICE" size="30" placeholder="<?= HtmlEncode($Grid->SELL_PRICE->getPlaceHolder()) ?>" value="<?= $Grid->SELL_PRICE->EditValue ?>"<?= $Grid->SELL_PRICE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->SELL_PRICE->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_SELL_PRICE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_SELL_PRICE" id="o<?= $Grid->RowIndex ?>_SELL_PRICE" value="<?= HtmlEncode($Grid->SELL_PRICE->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_SELL_PRICE" class="form-group">
<input type="<?= $Grid->SELL_PRICE->getInputTextType() ?>" data-table="V_TREAT" data-field="x_SELL_PRICE" name="x<?= $Grid->RowIndex ?>_SELL_PRICE" id="x<?= $Grid->RowIndex ?>_SELL_PRICE" size="30" placeholder="<?= HtmlEncode($Grid->SELL_PRICE->getPlaceHolder()) ?>" value="<?= $Grid->SELL_PRICE->EditValue ?>"<?= $Grid->SELL_PRICE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->SELL_PRICE->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_SELL_PRICE">
<span<?= $Grid->SELL_PRICE->viewAttributes() ?>>
<?= $Grid->SELL_PRICE->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_SELL_PRICE" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_SELL_PRICE" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_SELL_PRICE" value="<?= HtmlEncode($Grid->SELL_PRICE->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_SELL_PRICE" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_SELL_PRICE" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_SELL_PRICE" value="<?= HtmlEncode($Grid->SELL_PRICE->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->ACCOUNT_ID->Visible) { // ACCOUNT_ID ?>
        <td data-name="ACCOUNT_ID" <?= $Grid->ACCOUNT_ID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_ACCOUNT_ID" class="form-group">
<input type="<?= $Grid->ACCOUNT_ID->getInputTextType() ?>" data-table="V_TREAT" data-field="x_ACCOUNT_ID" name="x<?= $Grid->RowIndex ?>_ACCOUNT_ID" id="x<?= $Grid->RowIndex ?>_ACCOUNT_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->ACCOUNT_ID->getPlaceHolder()) ?>" value="<?= $Grid->ACCOUNT_ID->EditValue ?>"<?= $Grid->ACCOUNT_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ACCOUNT_ID->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_ACCOUNT_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ACCOUNT_ID" id="o<?= $Grid->RowIndex ?>_ACCOUNT_ID" value="<?= HtmlEncode($Grid->ACCOUNT_ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_ACCOUNT_ID" class="form-group">
<input type="<?= $Grid->ACCOUNT_ID->getInputTextType() ?>" data-table="V_TREAT" data-field="x_ACCOUNT_ID" name="x<?= $Grid->RowIndex ?>_ACCOUNT_ID" id="x<?= $Grid->RowIndex ?>_ACCOUNT_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->ACCOUNT_ID->getPlaceHolder()) ?>" value="<?= $Grid->ACCOUNT_ID->EditValue ?>"<?= $Grid->ACCOUNT_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ACCOUNT_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_ACCOUNT_ID">
<span<?= $Grid->ACCOUNT_ID->viewAttributes() ?>>
<?= $Grid->ACCOUNT_ID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_ACCOUNT_ID" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_ACCOUNT_ID" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_ACCOUNT_ID" value="<?= HtmlEncode($Grid->ACCOUNT_ID->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_ACCOUNT_ID" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_ACCOUNT_ID" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_ACCOUNT_ID" value="<?= HtmlEncode($Grid->ACCOUNT_ID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->subsidi->Visible) { // subsidi ?>
        <td data-name="subsidi" <?= $Grid->subsidi->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_subsidi" class="form-group">
<input type="<?= $Grid->subsidi->getInputTextType() ?>" data-table="V_TREAT" data-field="x_subsidi" name="x<?= $Grid->RowIndex ?>_subsidi" id="x<?= $Grid->RowIndex ?>_subsidi" size="30" placeholder="<?= HtmlEncode($Grid->subsidi->getPlaceHolder()) ?>" value="<?= $Grid->subsidi->EditValue ?>"<?= $Grid->subsidi->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->subsidi->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_subsidi" data-hidden="1" name="o<?= $Grid->RowIndex ?>_subsidi" id="o<?= $Grid->RowIndex ?>_subsidi" value="<?= HtmlEncode($Grid->subsidi->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_subsidi" class="form-group">
<input type="<?= $Grid->subsidi->getInputTextType() ?>" data-table="V_TREAT" data-field="x_subsidi" name="x<?= $Grid->RowIndex ?>_subsidi" id="x<?= $Grid->RowIndex ?>_subsidi" size="30" placeholder="<?= HtmlEncode($Grid->subsidi->getPlaceHolder()) ?>" value="<?= $Grid->subsidi->EditValue ?>"<?= $Grid->subsidi->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->subsidi->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_subsidi">
<span<?= $Grid->subsidi->viewAttributes() ?>>
<?= $Grid->subsidi->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_subsidi" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_subsidi" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_subsidi" value="<?= HtmlEncode($Grid->subsidi->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_subsidi" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_subsidi" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_subsidi" value="<?= HtmlEncode($Grid->subsidi->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->PROFESI->Visible) { // PROFESI ?>
        <td data-name="PROFESI" <?= $Grid->PROFESI->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_PROFESI" class="form-group">
<input type="<?= $Grid->PROFESI->getInputTextType() ?>" data-table="V_TREAT" data-field="x_PROFESI" name="x<?= $Grid->RowIndex ?>_PROFESI" id="x<?= $Grid->RowIndex ?>_PROFESI" size="30" placeholder="<?= HtmlEncode($Grid->PROFESI->getPlaceHolder()) ?>" value="<?= $Grid->PROFESI->EditValue ?>"<?= $Grid->PROFESI->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->PROFESI->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_PROFESI" data-hidden="1" name="o<?= $Grid->RowIndex ?>_PROFESI" id="o<?= $Grid->RowIndex ?>_PROFESI" value="<?= HtmlEncode($Grid->PROFESI->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_PROFESI" class="form-group">
<input type="<?= $Grid->PROFESI->getInputTextType() ?>" data-table="V_TREAT" data-field="x_PROFESI" name="x<?= $Grid->RowIndex ?>_PROFESI" id="x<?= $Grid->RowIndex ?>_PROFESI" size="30" placeholder="<?= HtmlEncode($Grid->PROFESI->getPlaceHolder()) ?>" value="<?= $Grid->PROFESI->EditValue ?>"<?= $Grid->PROFESI->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->PROFESI->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_PROFESI">
<span<?= $Grid->PROFESI->viewAttributes() ?>>
<?= $Grid->PROFESI->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_PROFESI" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_PROFESI" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_PROFESI" value="<?= HtmlEncode($Grid->PROFESI->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_PROFESI" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_PROFESI" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_PROFESI" value="<?= HtmlEncode($Grid->PROFESI->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->EMBALACE->Visible) { // EMBALACE ?>
        <td data-name="EMBALACE" <?= $Grid->EMBALACE->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_EMBALACE" class="form-group">
<input type="<?= $Grid->EMBALACE->getInputTextType() ?>" data-table="V_TREAT" data-field="x_EMBALACE" name="x<?= $Grid->RowIndex ?>_EMBALACE" id="x<?= $Grid->RowIndex ?>_EMBALACE" size="30" placeholder="<?= HtmlEncode($Grid->EMBALACE->getPlaceHolder()) ?>" value="<?= $Grid->EMBALACE->EditValue ?>"<?= $Grid->EMBALACE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->EMBALACE->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_EMBALACE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_EMBALACE" id="o<?= $Grid->RowIndex ?>_EMBALACE" value="<?= HtmlEncode($Grid->EMBALACE->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_EMBALACE" class="form-group">
<input type="<?= $Grid->EMBALACE->getInputTextType() ?>" data-table="V_TREAT" data-field="x_EMBALACE" name="x<?= $Grid->RowIndex ?>_EMBALACE" id="x<?= $Grid->RowIndex ?>_EMBALACE" size="30" placeholder="<?= HtmlEncode($Grid->EMBALACE->getPlaceHolder()) ?>" value="<?= $Grid->EMBALACE->EditValue ?>"<?= $Grid->EMBALACE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->EMBALACE->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_EMBALACE">
<span<?= $Grid->EMBALACE->viewAttributes() ?>>
<?= $Grid->EMBALACE->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_EMBALACE" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_EMBALACE" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_EMBALACE" value="<?= HtmlEncode($Grid->EMBALACE->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_EMBALACE" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_EMBALACE" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_EMBALACE" value="<?= HtmlEncode($Grid->EMBALACE->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->DISCOUNT->Visible) { // DISCOUNT ?>
        <td data-name="DISCOUNT" <?= $Grid->DISCOUNT->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_DISCOUNT" class="form-group">
<input type="<?= $Grid->DISCOUNT->getInputTextType() ?>" data-table="V_TREAT" data-field="x_DISCOUNT" name="x<?= $Grid->RowIndex ?>_DISCOUNT" id="x<?= $Grid->RowIndex ?>_DISCOUNT" size="30" placeholder="<?= HtmlEncode($Grid->DISCOUNT->getPlaceHolder()) ?>" value="<?= $Grid->DISCOUNT->EditValue ?>"<?= $Grid->DISCOUNT->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->DISCOUNT->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_DISCOUNT" data-hidden="1" name="o<?= $Grid->RowIndex ?>_DISCOUNT" id="o<?= $Grid->RowIndex ?>_DISCOUNT" value="<?= HtmlEncode($Grid->DISCOUNT->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_DISCOUNT" class="form-group">
<input type="<?= $Grid->DISCOUNT->getInputTextType() ?>" data-table="V_TREAT" data-field="x_DISCOUNT" name="x<?= $Grid->RowIndex ?>_DISCOUNT" id="x<?= $Grid->RowIndex ?>_DISCOUNT" size="30" placeholder="<?= HtmlEncode($Grid->DISCOUNT->getPlaceHolder()) ?>" value="<?= $Grid->DISCOUNT->EditValue ?>"<?= $Grid->DISCOUNT->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->DISCOUNT->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_DISCOUNT">
<span<?= $Grid->DISCOUNT->viewAttributes() ?>>
<?= $Grid->DISCOUNT->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_DISCOUNT" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_DISCOUNT" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_DISCOUNT" value="<?= HtmlEncode($Grid->DISCOUNT->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_DISCOUNT" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_DISCOUNT" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_DISCOUNT" value="<?= HtmlEncode($Grid->DISCOUNT->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->AMOUNT->Visible) { // AMOUNT ?>
        <td data-name="AMOUNT" <?= $Grid->AMOUNT->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_AMOUNT" class="form-group">
<input type="<?= $Grid->AMOUNT->getInputTextType() ?>" data-table="V_TREAT" data-field="x_AMOUNT" name="x<?= $Grid->RowIndex ?>_AMOUNT" id="x<?= $Grid->RowIndex ?>_AMOUNT" size="30" placeholder="<?= HtmlEncode($Grid->AMOUNT->getPlaceHolder()) ?>" value="<?= $Grid->AMOUNT->EditValue ?>"<?= $Grid->AMOUNT->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->AMOUNT->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_AMOUNT" data-hidden="1" name="o<?= $Grid->RowIndex ?>_AMOUNT" id="o<?= $Grid->RowIndex ?>_AMOUNT" value="<?= HtmlEncode($Grid->AMOUNT->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_AMOUNT" class="form-group">
<input type="<?= $Grid->AMOUNT->getInputTextType() ?>" data-table="V_TREAT" data-field="x_AMOUNT" name="x<?= $Grid->RowIndex ?>_AMOUNT" id="x<?= $Grid->RowIndex ?>_AMOUNT" size="30" placeholder="<?= HtmlEncode($Grid->AMOUNT->getPlaceHolder()) ?>" value="<?= $Grid->AMOUNT->EditValue ?>"<?= $Grid->AMOUNT->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->AMOUNT->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_AMOUNT">
<span<?= $Grid->AMOUNT->viewAttributes() ?>>
<?= $Grid->AMOUNT->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_AMOUNT" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_AMOUNT" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_AMOUNT" value="<?= HtmlEncode($Grid->AMOUNT->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_AMOUNT" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_AMOUNT" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_AMOUNT" value="<?= HtmlEncode($Grid->AMOUNT->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->PPN->Visible) { // PPN ?>
        <td data-name="PPN" <?= $Grid->PPN->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_PPN" class="form-group">
<input type="<?= $Grid->PPN->getInputTextType() ?>" data-table="V_TREAT" data-field="x_PPN" name="x<?= $Grid->RowIndex ?>_PPN" id="x<?= $Grid->RowIndex ?>_PPN" size="30" placeholder="<?= HtmlEncode($Grid->PPN->getPlaceHolder()) ?>" value="<?= $Grid->PPN->EditValue ?>"<?= $Grid->PPN->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->PPN->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_PPN" data-hidden="1" name="o<?= $Grid->RowIndex ?>_PPN" id="o<?= $Grid->RowIndex ?>_PPN" value="<?= HtmlEncode($Grid->PPN->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_PPN" class="form-group">
<input type="<?= $Grid->PPN->getInputTextType() ?>" data-table="V_TREAT" data-field="x_PPN" name="x<?= $Grid->RowIndex ?>_PPN" id="x<?= $Grid->RowIndex ?>_PPN" size="30" placeholder="<?= HtmlEncode($Grid->PPN->getPlaceHolder()) ?>" value="<?= $Grid->PPN->EditValue ?>"<?= $Grid->PPN->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->PPN->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_PPN">
<span<?= $Grid->PPN->viewAttributes() ?>>
<?= $Grid->PPN->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_PPN" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_PPN" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_PPN" value="<?= HtmlEncode($Grid->PPN->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_PPN" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_PPN" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_PPN" value="<?= HtmlEncode($Grid->PPN->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->ITER->Visible) { // ITER ?>
        <td data-name="ITER" <?= $Grid->ITER->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_ITER" class="form-group">
<input type="<?= $Grid->ITER->getInputTextType() ?>" data-table="V_TREAT" data-field="x_ITER" name="x<?= $Grid->RowIndex ?>_ITER" id="x<?= $Grid->RowIndex ?>_ITER" size="30" placeholder="<?= HtmlEncode($Grid->ITER->getPlaceHolder()) ?>" value="<?= $Grid->ITER->EditValue ?>"<?= $Grid->ITER->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ITER->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_ITER" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ITER" id="o<?= $Grid->RowIndex ?>_ITER" value="<?= HtmlEncode($Grid->ITER->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_ITER" class="form-group">
<input type="<?= $Grid->ITER->getInputTextType() ?>" data-table="V_TREAT" data-field="x_ITER" name="x<?= $Grid->RowIndex ?>_ITER" id="x<?= $Grid->RowIndex ?>_ITER" size="30" placeholder="<?= HtmlEncode($Grid->ITER->getPlaceHolder()) ?>" value="<?= $Grid->ITER->EditValue ?>"<?= $Grid->ITER->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ITER->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_ITER">
<span<?= $Grid->ITER->viewAttributes() ?>>
<?= $Grid->ITER->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_ITER" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_ITER" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_ITER" value="<?= HtmlEncode($Grid->ITER->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_ITER" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_ITER" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_ITER" value="<?= HtmlEncode($Grid->ITER->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->PAYOR_ID->Visible) { // PAYOR_ID ?>
        <td data-name="PAYOR_ID" <?= $Grid->PAYOR_ID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_PAYOR_ID" class="form-group">
<input type="<?= $Grid->PAYOR_ID->getInputTextType() ?>" data-table="V_TREAT" data-field="x_PAYOR_ID" name="x<?= $Grid->RowIndex ?>_PAYOR_ID" id="x<?= $Grid->RowIndex ?>_PAYOR_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->PAYOR_ID->getPlaceHolder()) ?>" value="<?= $Grid->PAYOR_ID->EditValue ?>"<?= $Grid->PAYOR_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->PAYOR_ID->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_PAYOR_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_PAYOR_ID" id="o<?= $Grid->RowIndex ?>_PAYOR_ID" value="<?= HtmlEncode($Grid->PAYOR_ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_PAYOR_ID" class="form-group">
<input type="<?= $Grid->PAYOR_ID->getInputTextType() ?>" data-table="V_TREAT" data-field="x_PAYOR_ID" name="x<?= $Grid->RowIndex ?>_PAYOR_ID" id="x<?= $Grid->RowIndex ?>_PAYOR_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->PAYOR_ID->getPlaceHolder()) ?>" value="<?= $Grid->PAYOR_ID->EditValue ?>"<?= $Grid->PAYOR_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->PAYOR_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_PAYOR_ID">
<span<?= $Grid->PAYOR_ID->viewAttributes() ?>>
<?= $Grid->PAYOR_ID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_PAYOR_ID" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_PAYOR_ID" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_PAYOR_ID" value="<?= HtmlEncode($Grid->PAYOR_ID->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_PAYOR_ID" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_PAYOR_ID" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_PAYOR_ID" value="<?= HtmlEncode($Grid->PAYOR_ID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->STATUS_OBAT->Visible) { // STATUS_OBAT ?>
        <td data-name="STATUS_OBAT" <?= $Grid->STATUS_OBAT->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_STATUS_OBAT" class="form-group">
<input type="<?= $Grid->STATUS_OBAT->getInputTextType() ?>" data-table="V_TREAT" data-field="x_STATUS_OBAT" name="x<?= $Grid->RowIndex ?>_STATUS_OBAT" id="x<?= $Grid->RowIndex ?>_STATUS_OBAT" size="30" placeholder="<?= HtmlEncode($Grid->STATUS_OBAT->getPlaceHolder()) ?>" value="<?= $Grid->STATUS_OBAT->EditValue ?>"<?= $Grid->STATUS_OBAT->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->STATUS_OBAT->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_STATUS_OBAT" data-hidden="1" name="o<?= $Grid->RowIndex ?>_STATUS_OBAT" id="o<?= $Grid->RowIndex ?>_STATUS_OBAT" value="<?= HtmlEncode($Grid->STATUS_OBAT->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_STATUS_OBAT" class="form-group">
<input type="<?= $Grid->STATUS_OBAT->getInputTextType() ?>" data-table="V_TREAT" data-field="x_STATUS_OBAT" name="x<?= $Grid->RowIndex ?>_STATUS_OBAT" id="x<?= $Grid->RowIndex ?>_STATUS_OBAT" size="30" placeholder="<?= HtmlEncode($Grid->STATUS_OBAT->getPlaceHolder()) ?>" value="<?= $Grid->STATUS_OBAT->EditValue ?>"<?= $Grid->STATUS_OBAT->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->STATUS_OBAT->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_STATUS_OBAT">
<span<?= $Grid->STATUS_OBAT->viewAttributes() ?>>
<?= $Grid->STATUS_OBAT->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_STATUS_OBAT" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_STATUS_OBAT" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_STATUS_OBAT" value="<?= HtmlEncode($Grid->STATUS_OBAT->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_STATUS_OBAT" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_STATUS_OBAT" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_STATUS_OBAT" value="<?= HtmlEncode($Grid->STATUS_OBAT->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->SUBSIDISAT->Visible) { // SUBSIDISAT ?>
        <td data-name="SUBSIDISAT" <?= $Grid->SUBSIDISAT->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_SUBSIDISAT" class="form-group">
<input type="<?= $Grid->SUBSIDISAT->getInputTextType() ?>" data-table="V_TREAT" data-field="x_SUBSIDISAT" name="x<?= $Grid->RowIndex ?>_SUBSIDISAT" id="x<?= $Grid->RowIndex ?>_SUBSIDISAT" size="30" placeholder="<?= HtmlEncode($Grid->SUBSIDISAT->getPlaceHolder()) ?>" value="<?= $Grid->SUBSIDISAT->EditValue ?>"<?= $Grid->SUBSIDISAT->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->SUBSIDISAT->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_SUBSIDISAT" data-hidden="1" name="o<?= $Grid->RowIndex ?>_SUBSIDISAT" id="o<?= $Grid->RowIndex ?>_SUBSIDISAT" value="<?= HtmlEncode($Grid->SUBSIDISAT->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_SUBSIDISAT" class="form-group">
<input type="<?= $Grid->SUBSIDISAT->getInputTextType() ?>" data-table="V_TREAT" data-field="x_SUBSIDISAT" name="x<?= $Grid->RowIndex ?>_SUBSIDISAT" id="x<?= $Grid->RowIndex ?>_SUBSIDISAT" size="30" placeholder="<?= HtmlEncode($Grid->SUBSIDISAT->getPlaceHolder()) ?>" value="<?= $Grid->SUBSIDISAT->EditValue ?>"<?= $Grid->SUBSIDISAT->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->SUBSIDISAT->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_SUBSIDISAT">
<span<?= $Grid->SUBSIDISAT->viewAttributes() ?>>
<?= $Grid->SUBSIDISAT->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_SUBSIDISAT" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_SUBSIDISAT" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_SUBSIDISAT" value="<?= HtmlEncode($Grid->SUBSIDISAT->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_SUBSIDISAT" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_SUBSIDISAT" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_SUBSIDISAT" value="<?= HtmlEncode($Grid->SUBSIDISAT->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->MARGIN->Visible) { // MARGIN ?>
        <td data-name="MARGIN" <?= $Grid->MARGIN->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_MARGIN" class="form-group">
<input type="<?= $Grid->MARGIN->getInputTextType() ?>" data-table="V_TREAT" data-field="x_MARGIN" name="x<?= $Grid->RowIndex ?>_MARGIN" id="x<?= $Grid->RowIndex ?>_MARGIN" size="30" placeholder="<?= HtmlEncode($Grid->MARGIN->getPlaceHolder()) ?>" value="<?= $Grid->MARGIN->EditValue ?>"<?= $Grid->MARGIN->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->MARGIN->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_MARGIN" data-hidden="1" name="o<?= $Grid->RowIndex ?>_MARGIN" id="o<?= $Grid->RowIndex ?>_MARGIN" value="<?= HtmlEncode($Grid->MARGIN->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_MARGIN" class="form-group">
<input type="<?= $Grid->MARGIN->getInputTextType() ?>" data-table="V_TREAT" data-field="x_MARGIN" name="x<?= $Grid->RowIndex ?>_MARGIN" id="x<?= $Grid->RowIndex ?>_MARGIN" size="30" placeholder="<?= HtmlEncode($Grid->MARGIN->getPlaceHolder()) ?>" value="<?= $Grid->MARGIN->EditValue ?>"<?= $Grid->MARGIN->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->MARGIN->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_MARGIN">
<span<?= $Grid->MARGIN->viewAttributes() ?>>
<?= $Grid->MARGIN->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_MARGIN" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_MARGIN" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_MARGIN" value="<?= HtmlEncode($Grid->MARGIN->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_MARGIN" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_MARGIN" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_MARGIN" value="<?= HtmlEncode($Grid->MARGIN->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->POKOK_JUAL->Visible) { // POKOK_JUAL ?>
        <td data-name="POKOK_JUAL" <?= $Grid->POKOK_JUAL->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_POKOK_JUAL" class="form-group">
<input type="<?= $Grid->POKOK_JUAL->getInputTextType() ?>" data-table="V_TREAT" data-field="x_POKOK_JUAL" name="x<?= $Grid->RowIndex ?>_POKOK_JUAL" id="x<?= $Grid->RowIndex ?>_POKOK_JUAL" size="30" placeholder="<?= HtmlEncode($Grid->POKOK_JUAL->getPlaceHolder()) ?>" value="<?= $Grid->POKOK_JUAL->EditValue ?>"<?= $Grid->POKOK_JUAL->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->POKOK_JUAL->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_POKOK_JUAL" data-hidden="1" name="o<?= $Grid->RowIndex ?>_POKOK_JUAL" id="o<?= $Grid->RowIndex ?>_POKOK_JUAL" value="<?= HtmlEncode($Grid->POKOK_JUAL->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_POKOK_JUAL" class="form-group">
<input type="<?= $Grid->POKOK_JUAL->getInputTextType() ?>" data-table="V_TREAT" data-field="x_POKOK_JUAL" name="x<?= $Grid->RowIndex ?>_POKOK_JUAL" id="x<?= $Grid->RowIndex ?>_POKOK_JUAL" size="30" placeholder="<?= HtmlEncode($Grid->POKOK_JUAL->getPlaceHolder()) ?>" value="<?= $Grid->POKOK_JUAL->EditValue ?>"<?= $Grid->POKOK_JUAL->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->POKOK_JUAL->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_POKOK_JUAL">
<span<?= $Grid->POKOK_JUAL->viewAttributes() ?>>
<?= $Grid->POKOK_JUAL->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_POKOK_JUAL" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_POKOK_JUAL" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_POKOK_JUAL" value="<?= HtmlEncode($Grid->POKOK_JUAL->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_POKOK_JUAL" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_POKOK_JUAL" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_POKOK_JUAL" value="<?= HtmlEncode($Grid->POKOK_JUAL->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->PRINTQ->Visible) { // PRINTQ ?>
        <td data-name="PRINTQ" <?= $Grid->PRINTQ->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_PRINTQ" class="form-group">
<input type="<?= $Grid->PRINTQ->getInputTextType() ?>" data-table="V_TREAT" data-field="x_PRINTQ" name="x<?= $Grid->RowIndex ?>_PRINTQ" id="x<?= $Grid->RowIndex ?>_PRINTQ" size="30" placeholder="<?= HtmlEncode($Grid->PRINTQ->getPlaceHolder()) ?>" value="<?= $Grid->PRINTQ->EditValue ?>"<?= $Grid->PRINTQ->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->PRINTQ->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_PRINTQ" data-hidden="1" name="o<?= $Grid->RowIndex ?>_PRINTQ" id="o<?= $Grid->RowIndex ?>_PRINTQ" value="<?= HtmlEncode($Grid->PRINTQ->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_PRINTQ" class="form-group">
<input type="<?= $Grid->PRINTQ->getInputTextType() ?>" data-table="V_TREAT" data-field="x_PRINTQ" name="x<?= $Grid->RowIndex ?>_PRINTQ" id="x<?= $Grid->RowIndex ?>_PRINTQ" size="30" placeholder="<?= HtmlEncode($Grid->PRINTQ->getPlaceHolder()) ?>" value="<?= $Grid->PRINTQ->EditValue ?>"<?= $Grid->PRINTQ->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->PRINTQ->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_PRINTQ">
<span<?= $Grid->PRINTQ->viewAttributes() ?>>
<?= $Grid->PRINTQ->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_PRINTQ" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_PRINTQ" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_PRINTQ" value="<?= HtmlEncode($Grid->PRINTQ->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_PRINTQ" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_PRINTQ" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_PRINTQ" value="<?= HtmlEncode($Grid->PRINTQ->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->PRINTED_BY->Visible) { // PRINTED_BY ?>
        <td data-name="PRINTED_BY" <?= $Grid->PRINTED_BY->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_PRINTED_BY" class="form-group">
<input type="<?= $Grid->PRINTED_BY->getInputTextType() ?>" data-table="V_TREAT" data-field="x_PRINTED_BY" name="x<?= $Grid->RowIndex ?>_PRINTED_BY" id="x<?= $Grid->RowIndex ?>_PRINTED_BY" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->PRINTED_BY->getPlaceHolder()) ?>" value="<?= $Grid->PRINTED_BY->EditValue ?>"<?= $Grid->PRINTED_BY->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->PRINTED_BY->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_PRINTED_BY" data-hidden="1" name="o<?= $Grid->RowIndex ?>_PRINTED_BY" id="o<?= $Grid->RowIndex ?>_PRINTED_BY" value="<?= HtmlEncode($Grid->PRINTED_BY->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_PRINTED_BY" class="form-group">
<input type="<?= $Grid->PRINTED_BY->getInputTextType() ?>" data-table="V_TREAT" data-field="x_PRINTED_BY" name="x<?= $Grid->RowIndex ?>_PRINTED_BY" id="x<?= $Grid->RowIndex ?>_PRINTED_BY" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->PRINTED_BY->getPlaceHolder()) ?>" value="<?= $Grid->PRINTED_BY->EditValue ?>"<?= $Grid->PRINTED_BY->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->PRINTED_BY->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_PRINTED_BY">
<span<?= $Grid->PRINTED_BY->viewAttributes() ?>>
<?= $Grid->PRINTED_BY->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_PRINTED_BY" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_PRINTED_BY" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_PRINTED_BY" value="<?= HtmlEncode($Grid->PRINTED_BY->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_PRINTED_BY" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_PRINTED_BY" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_PRINTED_BY" value="<?= HtmlEncode($Grid->PRINTED_BY->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->STOCK_AVAILABLE->Visible) { // STOCK_AVAILABLE ?>
        <td data-name="STOCK_AVAILABLE" <?= $Grid->STOCK_AVAILABLE->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_STOCK_AVAILABLE" class="form-group">
<input type="<?= $Grid->STOCK_AVAILABLE->getInputTextType() ?>" data-table="V_TREAT" data-field="x_STOCK_AVAILABLE" name="x<?= $Grid->RowIndex ?>_STOCK_AVAILABLE" id="x<?= $Grid->RowIndex ?>_STOCK_AVAILABLE" size="30" placeholder="<?= HtmlEncode($Grid->STOCK_AVAILABLE->getPlaceHolder()) ?>" value="<?= $Grid->STOCK_AVAILABLE->EditValue ?>"<?= $Grid->STOCK_AVAILABLE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->STOCK_AVAILABLE->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_STOCK_AVAILABLE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_STOCK_AVAILABLE" id="o<?= $Grid->RowIndex ?>_STOCK_AVAILABLE" value="<?= HtmlEncode($Grid->STOCK_AVAILABLE->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_STOCK_AVAILABLE" class="form-group">
<input type="<?= $Grid->STOCK_AVAILABLE->getInputTextType() ?>" data-table="V_TREAT" data-field="x_STOCK_AVAILABLE" name="x<?= $Grid->RowIndex ?>_STOCK_AVAILABLE" id="x<?= $Grid->RowIndex ?>_STOCK_AVAILABLE" size="30" placeholder="<?= HtmlEncode($Grid->STOCK_AVAILABLE->getPlaceHolder()) ?>" value="<?= $Grid->STOCK_AVAILABLE->EditValue ?>"<?= $Grid->STOCK_AVAILABLE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->STOCK_AVAILABLE->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_STOCK_AVAILABLE">
<span<?= $Grid->STOCK_AVAILABLE->viewAttributes() ?>>
<?= $Grid->STOCK_AVAILABLE->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_STOCK_AVAILABLE" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_STOCK_AVAILABLE" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_STOCK_AVAILABLE" value="<?= HtmlEncode($Grid->STOCK_AVAILABLE->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_STOCK_AVAILABLE" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_STOCK_AVAILABLE" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_STOCK_AVAILABLE" value="<?= HtmlEncode($Grid->STOCK_AVAILABLE->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->STATUS_TARIF->Visible) { // STATUS_TARIF ?>
        <td data-name="STATUS_TARIF" <?= $Grid->STATUS_TARIF->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_STATUS_TARIF" class="form-group">
<input type="<?= $Grid->STATUS_TARIF->getInputTextType() ?>" data-table="V_TREAT" data-field="x_STATUS_TARIF" name="x<?= $Grid->RowIndex ?>_STATUS_TARIF" id="x<?= $Grid->RowIndex ?>_STATUS_TARIF" size="30" placeholder="<?= HtmlEncode($Grid->STATUS_TARIF->getPlaceHolder()) ?>" value="<?= $Grid->STATUS_TARIF->EditValue ?>"<?= $Grid->STATUS_TARIF->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->STATUS_TARIF->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_STATUS_TARIF" data-hidden="1" name="o<?= $Grid->RowIndex ?>_STATUS_TARIF" id="o<?= $Grid->RowIndex ?>_STATUS_TARIF" value="<?= HtmlEncode($Grid->STATUS_TARIF->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_STATUS_TARIF" class="form-group">
<input type="<?= $Grid->STATUS_TARIF->getInputTextType() ?>" data-table="V_TREAT" data-field="x_STATUS_TARIF" name="x<?= $Grid->RowIndex ?>_STATUS_TARIF" id="x<?= $Grid->RowIndex ?>_STATUS_TARIF" size="30" placeholder="<?= HtmlEncode($Grid->STATUS_TARIF->getPlaceHolder()) ?>" value="<?= $Grid->STATUS_TARIF->EditValue ?>"<?= $Grid->STATUS_TARIF->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->STATUS_TARIF->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_STATUS_TARIF">
<span<?= $Grid->STATUS_TARIF->viewAttributes() ?>>
<?= $Grid->STATUS_TARIF->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_STATUS_TARIF" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_STATUS_TARIF" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_STATUS_TARIF" value="<?= HtmlEncode($Grid->STATUS_TARIF->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_STATUS_TARIF" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_STATUS_TARIF" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_STATUS_TARIF" value="<?= HtmlEncode($Grid->STATUS_TARIF->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->PACKAGE_ID->Visible) { // PACKAGE_ID ?>
        <td data-name="PACKAGE_ID" <?= $Grid->PACKAGE_ID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_PACKAGE_ID" class="form-group">
<input type="<?= $Grid->PACKAGE_ID->getInputTextType() ?>" data-table="V_TREAT" data-field="x_PACKAGE_ID" name="x<?= $Grid->RowIndex ?>_PACKAGE_ID" id="x<?= $Grid->RowIndex ?>_PACKAGE_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->PACKAGE_ID->getPlaceHolder()) ?>" value="<?= $Grid->PACKAGE_ID->EditValue ?>"<?= $Grid->PACKAGE_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->PACKAGE_ID->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_PACKAGE_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_PACKAGE_ID" id="o<?= $Grid->RowIndex ?>_PACKAGE_ID" value="<?= HtmlEncode($Grid->PACKAGE_ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_PACKAGE_ID" class="form-group">
<input type="<?= $Grid->PACKAGE_ID->getInputTextType() ?>" data-table="V_TREAT" data-field="x_PACKAGE_ID" name="x<?= $Grid->RowIndex ?>_PACKAGE_ID" id="x<?= $Grid->RowIndex ?>_PACKAGE_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->PACKAGE_ID->getPlaceHolder()) ?>" value="<?= $Grid->PACKAGE_ID->EditValue ?>"<?= $Grid->PACKAGE_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->PACKAGE_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_PACKAGE_ID">
<span<?= $Grid->PACKAGE_ID->viewAttributes() ?>>
<?= $Grid->PACKAGE_ID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_PACKAGE_ID" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_PACKAGE_ID" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_PACKAGE_ID" value="<?= HtmlEncode($Grid->PACKAGE_ID->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_PACKAGE_ID" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_PACKAGE_ID" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_PACKAGE_ID" value="<?= HtmlEncode($Grid->PACKAGE_ID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->MODULE_ID->Visible) { // MODULE_ID ?>
        <td data-name="MODULE_ID" <?= $Grid->MODULE_ID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_MODULE_ID" class="form-group">
<input type="<?= $Grid->MODULE_ID->getInputTextType() ?>" data-table="V_TREAT" data-field="x_MODULE_ID" name="x<?= $Grid->RowIndex ?>_MODULE_ID" id="x<?= $Grid->RowIndex ?>_MODULE_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->MODULE_ID->getPlaceHolder()) ?>" value="<?= $Grid->MODULE_ID->EditValue ?>"<?= $Grid->MODULE_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->MODULE_ID->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_MODULE_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_MODULE_ID" id="o<?= $Grid->RowIndex ?>_MODULE_ID" value="<?= HtmlEncode($Grid->MODULE_ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_MODULE_ID" class="form-group">
<input type="<?= $Grid->MODULE_ID->getInputTextType() ?>" data-table="V_TREAT" data-field="x_MODULE_ID" name="x<?= $Grid->RowIndex ?>_MODULE_ID" id="x<?= $Grid->RowIndex ?>_MODULE_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->MODULE_ID->getPlaceHolder()) ?>" value="<?= $Grid->MODULE_ID->EditValue ?>"<?= $Grid->MODULE_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->MODULE_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_MODULE_ID">
<span<?= $Grid->MODULE_ID->viewAttributes() ?>>
<?= $Grid->MODULE_ID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_MODULE_ID" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_MODULE_ID" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_MODULE_ID" value="<?= HtmlEncode($Grid->MODULE_ID->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_MODULE_ID" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_MODULE_ID" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_MODULE_ID" value="<?= HtmlEncode($Grid->MODULE_ID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->profession->Visible) { // profession ?>
        <td data-name="profession" <?= $Grid->profession->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_profession" class="form-group">
<input type="<?= $Grid->profession->getInputTextType() ?>" data-table="V_TREAT" data-field="x_profession" name="x<?= $Grid->RowIndex ?>_profession" id="x<?= $Grid->RowIndex ?>_profession" size="30" placeholder="<?= HtmlEncode($Grid->profession->getPlaceHolder()) ?>" value="<?= $Grid->profession->EditValue ?>"<?= $Grid->profession->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->profession->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_profession" data-hidden="1" name="o<?= $Grid->RowIndex ?>_profession" id="o<?= $Grid->RowIndex ?>_profession" value="<?= HtmlEncode($Grid->profession->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_profession" class="form-group">
<input type="<?= $Grid->profession->getInputTextType() ?>" data-table="V_TREAT" data-field="x_profession" name="x<?= $Grid->RowIndex ?>_profession" id="x<?= $Grid->RowIndex ?>_profession" size="30" placeholder="<?= HtmlEncode($Grid->profession->getPlaceHolder()) ?>" value="<?= $Grid->profession->EditValue ?>"<?= $Grid->profession->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->profession->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_profession">
<span<?= $Grid->profession->viewAttributes() ?>>
<?= $Grid->profession->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_profession" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_profession" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_profession" value="<?= HtmlEncode($Grid->profession->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_profession" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_profession" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_profession" value="<?= HtmlEncode($Grid->profession->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->THEORDER->Visible) { // THEORDER ?>
        <td data-name="THEORDER" <?= $Grid->THEORDER->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_THEORDER" class="form-group">
<input type="<?= $Grid->THEORDER->getInputTextType() ?>" data-table="V_TREAT" data-field="x_THEORDER" name="x<?= $Grid->RowIndex ?>_THEORDER" id="x<?= $Grid->RowIndex ?>_THEORDER" size="30" placeholder="<?= HtmlEncode($Grid->THEORDER->getPlaceHolder()) ?>" value="<?= $Grid->THEORDER->EditValue ?>"<?= $Grid->THEORDER->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->THEORDER->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_THEORDER" data-hidden="1" name="o<?= $Grid->RowIndex ?>_THEORDER" id="o<?= $Grid->RowIndex ?>_THEORDER" value="<?= HtmlEncode($Grid->THEORDER->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_THEORDER" class="form-group">
<input type="<?= $Grid->THEORDER->getInputTextType() ?>" data-table="V_TREAT" data-field="x_THEORDER" name="x<?= $Grid->RowIndex ?>_THEORDER" id="x<?= $Grid->RowIndex ?>_THEORDER" size="30" placeholder="<?= HtmlEncode($Grid->THEORDER->getPlaceHolder()) ?>" value="<?= $Grid->THEORDER->EditValue ?>"<?= $Grid->THEORDER->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->THEORDER->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_THEORDER">
<span<?= $Grid->THEORDER->viewAttributes() ?>>
<?= $Grid->THEORDER->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_THEORDER" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_THEORDER" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_THEORDER" value="<?= HtmlEncode($Grid->THEORDER->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_THEORDER" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_THEORDER" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_THEORDER" value="<?= HtmlEncode($Grid->THEORDER->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->CORRECTION_ID->Visible) { // CORRECTION_ID ?>
        <td data-name="CORRECTION_ID" <?= $Grid->CORRECTION_ID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_CORRECTION_ID" class="form-group">
<input type="<?= $Grid->CORRECTION_ID->getInputTextType() ?>" data-table="V_TREAT" data-field="x_CORRECTION_ID" name="x<?= $Grid->RowIndex ?>_CORRECTION_ID" id="x<?= $Grid->RowIndex ?>_CORRECTION_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->CORRECTION_ID->getPlaceHolder()) ?>" value="<?= $Grid->CORRECTION_ID->EditValue ?>"<?= $Grid->CORRECTION_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->CORRECTION_ID->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_CORRECTION_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_CORRECTION_ID" id="o<?= $Grid->RowIndex ?>_CORRECTION_ID" value="<?= HtmlEncode($Grid->CORRECTION_ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_CORRECTION_ID" class="form-group">
<input type="<?= $Grid->CORRECTION_ID->getInputTextType() ?>" data-table="V_TREAT" data-field="x_CORRECTION_ID" name="x<?= $Grid->RowIndex ?>_CORRECTION_ID" id="x<?= $Grid->RowIndex ?>_CORRECTION_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->CORRECTION_ID->getPlaceHolder()) ?>" value="<?= $Grid->CORRECTION_ID->EditValue ?>"<?= $Grid->CORRECTION_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->CORRECTION_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_CORRECTION_ID">
<span<?= $Grid->CORRECTION_ID->viewAttributes() ?>>
<?= $Grid->CORRECTION_ID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_CORRECTION_ID" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_CORRECTION_ID" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_CORRECTION_ID" value="<?= HtmlEncode($Grid->CORRECTION_ID->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_CORRECTION_ID" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_CORRECTION_ID" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_CORRECTION_ID" value="<?= HtmlEncode($Grid->CORRECTION_ID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->CORRECTION_BY->Visible) { // CORRECTION_BY ?>
        <td data-name="CORRECTION_BY" <?= $Grid->CORRECTION_BY->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_CORRECTION_BY" class="form-group">
<input type="<?= $Grid->CORRECTION_BY->getInputTextType() ?>" data-table="V_TREAT" data-field="x_CORRECTION_BY" name="x<?= $Grid->RowIndex ?>_CORRECTION_BY" id="x<?= $Grid->RowIndex ?>_CORRECTION_BY" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->CORRECTION_BY->getPlaceHolder()) ?>" value="<?= $Grid->CORRECTION_BY->EditValue ?>"<?= $Grid->CORRECTION_BY->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->CORRECTION_BY->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_CORRECTION_BY" data-hidden="1" name="o<?= $Grid->RowIndex ?>_CORRECTION_BY" id="o<?= $Grid->RowIndex ?>_CORRECTION_BY" value="<?= HtmlEncode($Grid->CORRECTION_BY->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_CORRECTION_BY" class="form-group">
<input type="<?= $Grid->CORRECTION_BY->getInputTextType() ?>" data-table="V_TREAT" data-field="x_CORRECTION_BY" name="x<?= $Grid->RowIndex ?>_CORRECTION_BY" id="x<?= $Grid->RowIndex ?>_CORRECTION_BY" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->CORRECTION_BY->getPlaceHolder()) ?>" value="<?= $Grid->CORRECTION_BY->EditValue ?>"<?= $Grid->CORRECTION_BY->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->CORRECTION_BY->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_CORRECTION_BY">
<span<?= $Grid->CORRECTION_BY->viewAttributes() ?>>
<?= $Grid->CORRECTION_BY->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_CORRECTION_BY" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_CORRECTION_BY" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_CORRECTION_BY" value="<?= HtmlEncode($Grid->CORRECTION_BY->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_CORRECTION_BY" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_CORRECTION_BY" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_CORRECTION_BY" value="<?= HtmlEncode($Grid->CORRECTION_BY->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->CASHIER->Visible) { // CASHIER ?>
        <td data-name="CASHIER" <?= $Grid->CASHIER->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_CASHIER" class="form-group">
<input type="<?= $Grid->CASHIER->getInputTextType() ?>" data-table="V_TREAT" data-field="x_CASHIER" name="x<?= $Grid->RowIndex ?>_CASHIER" id="x<?= $Grid->RowIndex ?>_CASHIER" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->CASHIER->getPlaceHolder()) ?>" value="<?= $Grid->CASHIER->EditValue ?>"<?= $Grid->CASHIER->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->CASHIER->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_CASHIER" data-hidden="1" name="o<?= $Grid->RowIndex ?>_CASHIER" id="o<?= $Grid->RowIndex ?>_CASHIER" value="<?= HtmlEncode($Grid->CASHIER->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_CASHIER" class="form-group">
<input type="<?= $Grid->CASHIER->getInputTextType() ?>" data-table="V_TREAT" data-field="x_CASHIER" name="x<?= $Grid->RowIndex ?>_CASHIER" id="x<?= $Grid->RowIndex ?>_CASHIER" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->CASHIER->getPlaceHolder()) ?>" value="<?= $Grid->CASHIER->EditValue ?>"<?= $Grid->CASHIER->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->CASHIER->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_CASHIER">
<span<?= $Grid->CASHIER->viewAttributes() ?>>
<?= $Grid->CASHIER->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_CASHIER" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_CASHIER" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_CASHIER" value="<?= HtmlEncode($Grid->CASHIER->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_CASHIER" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_CASHIER" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_CASHIER" value="<?= HtmlEncode($Grid->CASHIER->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->islunas->Visible) { // islunas ?>
        <td data-name="islunas" <?= $Grid->islunas->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_islunas" class="form-group">
<input type="<?= $Grid->islunas->getInputTextType() ?>" data-table="V_TREAT" data-field="x_islunas" name="x<?= $Grid->RowIndex ?>_islunas" id="x<?= $Grid->RowIndex ?>_islunas" size="30" maxlength="1" placeholder="<?= HtmlEncode($Grid->islunas->getPlaceHolder()) ?>" value="<?= $Grid->islunas->EditValue ?>"<?= $Grid->islunas->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->islunas->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_islunas" data-hidden="1" name="o<?= $Grid->RowIndex ?>_islunas" id="o<?= $Grid->RowIndex ?>_islunas" value="<?= HtmlEncode($Grid->islunas->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_islunas" class="form-group">
<input type="<?= $Grid->islunas->getInputTextType() ?>" data-table="V_TREAT" data-field="x_islunas" name="x<?= $Grid->RowIndex ?>_islunas" id="x<?= $Grid->RowIndex ?>_islunas" size="30" maxlength="1" placeholder="<?= HtmlEncode($Grid->islunas->getPlaceHolder()) ?>" value="<?= $Grid->islunas->EditValue ?>"<?= $Grid->islunas->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->islunas->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_islunas">
<span<?= $Grid->islunas->viewAttributes() ?>>
<?= $Grid->islunas->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_islunas" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_islunas" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_islunas" value="<?= HtmlEncode($Grid->islunas->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_islunas" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_islunas" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_islunas" value="<?= HtmlEncode($Grid->islunas->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->PAY_METHOD_ID->Visible) { // PAY_METHOD_ID ?>
        <td data-name="PAY_METHOD_ID" <?= $Grid->PAY_METHOD_ID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_PAY_METHOD_ID" class="form-group">
<input type="<?= $Grid->PAY_METHOD_ID->getInputTextType() ?>" data-table="V_TREAT" data-field="x_PAY_METHOD_ID" name="x<?= $Grid->RowIndex ?>_PAY_METHOD_ID" id="x<?= $Grid->RowIndex ?>_PAY_METHOD_ID" size="30" placeholder="<?= HtmlEncode($Grid->PAY_METHOD_ID->getPlaceHolder()) ?>" value="<?= $Grid->PAY_METHOD_ID->EditValue ?>"<?= $Grid->PAY_METHOD_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->PAY_METHOD_ID->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_PAY_METHOD_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_PAY_METHOD_ID" id="o<?= $Grid->RowIndex ?>_PAY_METHOD_ID" value="<?= HtmlEncode($Grid->PAY_METHOD_ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_PAY_METHOD_ID" class="form-group">
<input type="<?= $Grid->PAY_METHOD_ID->getInputTextType() ?>" data-table="V_TREAT" data-field="x_PAY_METHOD_ID" name="x<?= $Grid->RowIndex ?>_PAY_METHOD_ID" id="x<?= $Grid->RowIndex ?>_PAY_METHOD_ID" size="30" placeholder="<?= HtmlEncode($Grid->PAY_METHOD_ID->getPlaceHolder()) ?>" value="<?= $Grid->PAY_METHOD_ID->EditValue ?>"<?= $Grid->PAY_METHOD_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->PAY_METHOD_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_PAY_METHOD_ID">
<span<?= $Grid->PAY_METHOD_ID->viewAttributes() ?>>
<?= $Grid->PAY_METHOD_ID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_PAY_METHOD_ID" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_PAY_METHOD_ID" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_PAY_METHOD_ID" value="<?= HtmlEncode($Grid->PAY_METHOD_ID->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_PAY_METHOD_ID" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_PAY_METHOD_ID" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_PAY_METHOD_ID" value="<?= HtmlEncode($Grid->PAY_METHOD_ID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->PAYMENT_DATE->Visible) { // PAYMENT_DATE ?>
        <td data-name="PAYMENT_DATE" <?= $Grid->PAYMENT_DATE->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_PAYMENT_DATE" class="form-group">
<input type="<?= $Grid->PAYMENT_DATE->getInputTextType() ?>" data-table="V_TREAT" data-field="x_PAYMENT_DATE" name="x<?= $Grid->RowIndex ?>_PAYMENT_DATE" id="x<?= $Grid->RowIndex ?>_PAYMENT_DATE" placeholder="<?= HtmlEncode($Grid->PAYMENT_DATE->getPlaceHolder()) ?>" value="<?= $Grid->PAYMENT_DATE->EditValue ?>"<?= $Grid->PAYMENT_DATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->PAYMENT_DATE->getErrorMessage() ?></div>
<?php if (!$Grid->PAYMENT_DATE->ReadOnly && !$Grid->PAYMENT_DATE->Disabled && !isset($Grid->PAYMENT_DATE->EditAttrs["readonly"]) && !isset($Grid->PAYMENT_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fV_TREATgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fV_TREATgrid", "x<?= $Grid->RowIndex ?>_PAYMENT_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_PAYMENT_DATE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_PAYMENT_DATE" id="o<?= $Grid->RowIndex ?>_PAYMENT_DATE" value="<?= HtmlEncode($Grid->PAYMENT_DATE->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_PAYMENT_DATE" class="form-group">
<input type="<?= $Grid->PAYMENT_DATE->getInputTextType() ?>" data-table="V_TREAT" data-field="x_PAYMENT_DATE" name="x<?= $Grid->RowIndex ?>_PAYMENT_DATE" id="x<?= $Grid->RowIndex ?>_PAYMENT_DATE" placeholder="<?= HtmlEncode($Grid->PAYMENT_DATE->getPlaceHolder()) ?>" value="<?= $Grid->PAYMENT_DATE->EditValue ?>"<?= $Grid->PAYMENT_DATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->PAYMENT_DATE->getErrorMessage() ?></div>
<?php if (!$Grid->PAYMENT_DATE->ReadOnly && !$Grid->PAYMENT_DATE->Disabled && !isset($Grid->PAYMENT_DATE->EditAttrs["readonly"]) && !isset($Grid->PAYMENT_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fV_TREATgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fV_TREATgrid", "x<?= $Grid->RowIndex ?>_PAYMENT_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_PAYMENT_DATE">
<span<?= $Grid->PAYMENT_DATE->viewAttributes() ?>>
<?= $Grid->PAYMENT_DATE->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_PAYMENT_DATE" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_PAYMENT_DATE" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_PAYMENT_DATE" value="<?= HtmlEncode($Grid->PAYMENT_DATE->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_PAYMENT_DATE" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_PAYMENT_DATE" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_PAYMENT_DATE" value="<?= HtmlEncode($Grid->PAYMENT_DATE->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->ISCETAK->Visible) { // ISCETAK ?>
        <td data-name="ISCETAK" <?= $Grid->ISCETAK->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_ISCETAK" class="form-group">
<input type="<?= $Grid->ISCETAK->getInputTextType() ?>" data-table="V_TREAT" data-field="x_ISCETAK" name="x<?= $Grid->RowIndex ?>_ISCETAK" id="x<?= $Grid->RowIndex ?>_ISCETAK" size="30" maxlength="1" placeholder="<?= HtmlEncode($Grid->ISCETAK->getPlaceHolder()) ?>" value="<?= $Grid->ISCETAK->EditValue ?>"<?= $Grid->ISCETAK->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ISCETAK->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_ISCETAK" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ISCETAK" id="o<?= $Grid->RowIndex ?>_ISCETAK" value="<?= HtmlEncode($Grid->ISCETAK->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_ISCETAK" class="form-group">
<input type="<?= $Grid->ISCETAK->getInputTextType() ?>" data-table="V_TREAT" data-field="x_ISCETAK" name="x<?= $Grid->RowIndex ?>_ISCETAK" id="x<?= $Grid->RowIndex ?>_ISCETAK" size="30" maxlength="1" placeholder="<?= HtmlEncode($Grid->ISCETAK->getPlaceHolder()) ?>" value="<?= $Grid->ISCETAK->EditValue ?>"<?= $Grid->ISCETAK->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ISCETAK->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_ISCETAK">
<span<?= $Grid->ISCETAK->viewAttributes() ?>>
<?= $Grid->ISCETAK->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_ISCETAK" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_ISCETAK" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_ISCETAK" value="<?= HtmlEncode($Grid->ISCETAK->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_ISCETAK" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_ISCETAK" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_ISCETAK" value="<?= HtmlEncode($Grid->ISCETAK->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->print_date->Visible) { // print_date ?>
        <td data-name="print_date" <?= $Grid->print_date->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_print_date" class="form-group">
<input type="<?= $Grid->print_date->getInputTextType() ?>" data-table="V_TREAT" data-field="x_print_date" name="x<?= $Grid->RowIndex ?>_print_date" id="x<?= $Grid->RowIndex ?>_print_date" placeholder="<?= HtmlEncode($Grid->print_date->getPlaceHolder()) ?>" value="<?= $Grid->print_date->EditValue ?>"<?= $Grid->print_date->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->print_date->getErrorMessage() ?></div>
<?php if (!$Grid->print_date->ReadOnly && !$Grid->print_date->Disabled && !isset($Grid->print_date->EditAttrs["readonly"]) && !isset($Grid->print_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fV_TREATgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fV_TREATgrid", "x<?= $Grid->RowIndex ?>_print_date", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_print_date" data-hidden="1" name="o<?= $Grid->RowIndex ?>_print_date" id="o<?= $Grid->RowIndex ?>_print_date" value="<?= HtmlEncode($Grid->print_date->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_print_date" class="form-group">
<input type="<?= $Grid->print_date->getInputTextType() ?>" data-table="V_TREAT" data-field="x_print_date" name="x<?= $Grid->RowIndex ?>_print_date" id="x<?= $Grid->RowIndex ?>_print_date" placeholder="<?= HtmlEncode($Grid->print_date->getPlaceHolder()) ?>" value="<?= $Grid->print_date->EditValue ?>"<?= $Grid->print_date->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->print_date->getErrorMessage() ?></div>
<?php if (!$Grid->print_date->ReadOnly && !$Grid->print_date->Disabled && !isset($Grid->print_date->EditAttrs["readonly"]) && !isset($Grid->print_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fV_TREATgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fV_TREATgrid", "x<?= $Grid->RowIndex ?>_print_date", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_print_date">
<span<?= $Grid->print_date->viewAttributes() ?>>
<?= $Grid->print_date->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_print_date" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_print_date" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_print_date" value="<?= HtmlEncode($Grid->print_date->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_print_date" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_print_date" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_print_date" value="<?= HtmlEncode($Grid->print_date->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->DOSE->Visible) { // DOSE ?>
        <td data-name="DOSE" <?= $Grid->DOSE->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_DOSE" class="form-group">
<input type="<?= $Grid->DOSE->getInputTextType() ?>" data-table="V_TREAT" data-field="x_DOSE" name="x<?= $Grid->RowIndex ?>_DOSE" id="x<?= $Grid->RowIndex ?>_DOSE" size="30" placeholder="<?= HtmlEncode($Grid->DOSE->getPlaceHolder()) ?>" value="<?= $Grid->DOSE->EditValue ?>"<?= $Grid->DOSE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->DOSE->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_DOSE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_DOSE" id="o<?= $Grid->RowIndex ?>_DOSE" value="<?= HtmlEncode($Grid->DOSE->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_DOSE" class="form-group">
<input type="<?= $Grid->DOSE->getInputTextType() ?>" data-table="V_TREAT" data-field="x_DOSE" name="x<?= $Grid->RowIndex ?>_DOSE" id="x<?= $Grid->RowIndex ?>_DOSE" size="30" placeholder="<?= HtmlEncode($Grid->DOSE->getPlaceHolder()) ?>" value="<?= $Grid->DOSE->EditValue ?>"<?= $Grid->DOSE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->DOSE->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_DOSE">
<span<?= $Grid->DOSE->viewAttributes() ?>>
<?= $Grid->DOSE->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_DOSE" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_DOSE" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_DOSE" value="<?= HtmlEncode($Grid->DOSE->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_DOSE" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_DOSE" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_DOSE" value="<?= HtmlEncode($Grid->DOSE->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->JML_BKS->Visible) { // JML_BKS ?>
        <td data-name="JML_BKS" <?= $Grid->JML_BKS->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_JML_BKS" class="form-group">
<input type="<?= $Grid->JML_BKS->getInputTextType() ?>" data-table="V_TREAT" data-field="x_JML_BKS" name="x<?= $Grid->RowIndex ?>_JML_BKS" id="x<?= $Grid->RowIndex ?>_JML_BKS" size="30" placeholder="<?= HtmlEncode($Grid->JML_BKS->getPlaceHolder()) ?>" value="<?= $Grid->JML_BKS->EditValue ?>"<?= $Grid->JML_BKS->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->JML_BKS->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_JML_BKS" data-hidden="1" name="o<?= $Grid->RowIndex ?>_JML_BKS" id="o<?= $Grid->RowIndex ?>_JML_BKS" value="<?= HtmlEncode($Grid->JML_BKS->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_JML_BKS" class="form-group">
<input type="<?= $Grid->JML_BKS->getInputTextType() ?>" data-table="V_TREAT" data-field="x_JML_BKS" name="x<?= $Grid->RowIndex ?>_JML_BKS" id="x<?= $Grid->RowIndex ?>_JML_BKS" size="30" placeholder="<?= HtmlEncode($Grid->JML_BKS->getPlaceHolder()) ?>" value="<?= $Grid->JML_BKS->EditValue ?>"<?= $Grid->JML_BKS->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->JML_BKS->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_JML_BKS">
<span<?= $Grid->JML_BKS->viewAttributes() ?>>
<?= $Grid->JML_BKS->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_JML_BKS" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_JML_BKS" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_JML_BKS" value="<?= HtmlEncode($Grid->JML_BKS->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_JML_BKS" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_JML_BKS" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_JML_BKS" value="<?= HtmlEncode($Grid->JML_BKS->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->ORIG_DOSE->Visible) { // ORIG_DOSE ?>
        <td data-name="ORIG_DOSE" <?= $Grid->ORIG_DOSE->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_ORIG_DOSE" class="form-group">
<input type="<?= $Grid->ORIG_DOSE->getInputTextType() ?>" data-table="V_TREAT" data-field="x_ORIG_DOSE" name="x<?= $Grid->RowIndex ?>_ORIG_DOSE" id="x<?= $Grid->RowIndex ?>_ORIG_DOSE" size="30" placeholder="<?= HtmlEncode($Grid->ORIG_DOSE->getPlaceHolder()) ?>" value="<?= $Grid->ORIG_DOSE->EditValue ?>"<?= $Grid->ORIG_DOSE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ORIG_DOSE->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_ORIG_DOSE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ORIG_DOSE" id="o<?= $Grid->RowIndex ?>_ORIG_DOSE" value="<?= HtmlEncode($Grid->ORIG_DOSE->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_ORIG_DOSE" class="form-group">
<input type="<?= $Grid->ORIG_DOSE->getInputTextType() ?>" data-table="V_TREAT" data-field="x_ORIG_DOSE" name="x<?= $Grid->RowIndex ?>_ORIG_DOSE" id="x<?= $Grid->RowIndex ?>_ORIG_DOSE" size="30" placeholder="<?= HtmlEncode($Grid->ORIG_DOSE->getPlaceHolder()) ?>" value="<?= $Grid->ORIG_DOSE->EditValue ?>"<?= $Grid->ORIG_DOSE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ORIG_DOSE->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_ORIG_DOSE">
<span<?= $Grid->ORIG_DOSE->viewAttributes() ?>>
<?= $Grid->ORIG_DOSE->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_ORIG_DOSE" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_ORIG_DOSE" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_ORIG_DOSE" value="<?= HtmlEncode($Grid->ORIG_DOSE->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_ORIG_DOSE" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_ORIG_DOSE" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_ORIG_DOSE" value="<?= HtmlEncode($Grid->ORIG_DOSE->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->RESEP_KE->Visible) { // RESEP_KE ?>
        <td data-name="RESEP_KE" <?= $Grid->RESEP_KE->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_RESEP_KE" class="form-group">
<input type="<?= $Grid->RESEP_KE->getInputTextType() ?>" data-table="V_TREAT" data-field="x_RESEP_KE" name="x<?= $Grid->RowIndex ?>_RESEP_KE" id="x<?= $Grid->RowIndex ?>_RESEP_KE" size="30" placeholder="<?= HtmlEncode($Grid->RESEP_KE->getPlaceHolder()) ?>" value="<?= $Grid->RESEP_KE->EditValue ?>"<?= $Grid->RESEP_KE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->RESEP_KE->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_RESEP_KE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_RESEP_KE" id="o<?= $Grid->RowIndex ?>_RESEP_KE" value="<?= HtmlEncode($Grid->RESEP_KE->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_RESEP_KE" class="form-group">
<input type="<?= $Grid->RESEP_KE->getInputTextType() ?>" data-table="V_TREAT" data-field="x_RESEP_KE" name="x<?= $Grid->RowIndex ?>_RESEP_KE" id="x<?= $Grid->RowIndex ?>_RESEP_KE" size="30" placeholder="<?= HtmlEncode($Grid->RESEP_KE->getPlaceHolder()) ?>" value="<?= $Grid->RESEP_KE->EditValue ?>"<?= $Grid->RESEP_KE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->RESEP_KE->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_RESEP_KE">
<span<?= $Grid->RESEP_KE->viewAttributes() ?>>
<?= $Grid->RESEP_KE->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_RESEP_KE" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_RESEP_KE" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_RESEP_KE" value="<?= HtmlEncode($Grid->RESEP_KE->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_RESEP_KE" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_RESEP_KE" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_RESEP_KE" value="<?= HtmlEncode($Grid->RESEP_KE->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->ITER_KE->Visible) { // ITER_KE ?>
        <td data-name="ITER_KE" <?= $Grid->ITER_KE->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_ITER_KE" class="form-group">
<input type="<?= $Grid->ITER_KE->getInputTextType() ?>" data-table="V_TREAT" data-field="x_ITER_KE" name="x<?= $Grid->RowIndex ?>_ITER_KE" id="x<?= $Grid->RowIndex ?>_ITER_KE" size="30" placeholder="<?= HtmlEncode($Grid->ITER_KE->getPlaceHolder()) ?>" value="<?= $Grid->ITER_KE->EditValue ?>"<?= $Grid->ITER_KE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ITER_KE->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_ITER_KE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ITER_KE" id="o<?= $Grid->RowIndex ?>_ITER_KE" value="<?= HtmlEncode($Grid->ITER_KE->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_ITER_KE" class="form-group">
<input type="<?= $Grid->ITER_KE->getInputTextType() ?>" data-table="V_TREAT" data-field="x_ITER_KE" name="x<?= $Grid->RowIndex ?>_ITER_KE" id="x<?= $Grid->RowIndex ?>_ITER_KE" size="30" placeholder="<?= HtmlEncode($Grid->ITER_KE->getPlaceHolder()) ?>" value="<?= $Grid->ITER_KE->EditValue ?>"<?= $Grid->ITER_KE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ITER_KE->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_ITER_KE">
<span<?= $Grid->ITER_KE->viewAttributes() ?>>
<?= $Grid->ITER_KE->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_ITER_KE" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_ITER_KE" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_ITER_KE" value="<?= HtmlEncode($Grid->ITER_KE->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_ITER_KE" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_ITER_KE" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_ITER_KE" value="<?= HtmlEncode($Grid->ITER_KE->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->KUITANSI_ID->Visible) { // KUITANSI_ID ?>
        <td data-name="KUITANSI_ID" <?= $Grid->KUITANSI_ID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_KUITANSI_ID" class="form-group">
<input type="<?= $Grid->KUITANSI_ID->getInputTextType() ?>" data-table="V_TREAT" data-field="x_KUITANSI_ID" name="x<?= $Grid->RowIndex ?>_KUITANSI_ID" id="x<?= $Grid->RowIndex ?>_KUITANSI_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->KUITANSI_ID->getPlaceHolder()) ?>" value="<?= $Grid->KUITANSI_ID->EditValue ?>"<?= $Grid->KUITANSI_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->KUITANSI_ID->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_KUITANSI_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_KUITANSI_ID" id="o<?= $Grid->RowIndex ?>_KUITANSI_ID" value="<?= HtmlEncode($Grid->KUITANSI_ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_KUITANSI_ID" class="form-group">
<input type="<?= $Grid->KUITANSI_ID->getInputTextType() ?>" data-table="V_TREAT" data-field="x_KUITANSI_ID" name="x<?= $Grid->RowIndex ?>_KUITANSI_ID" id="x<?= $Grid->RowIndex ?>_KUITANSI_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->KUITANSI_ID->getPlaceHolder()) ?>" value="<?= $Grid->KUITANSI_ID->EditValue ?>"<?= $Grid->KUITANSI_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->KUITANSI_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_KUITANSI_ID">
<span<?= $Grid->KUITANSI_ID->viewAttributes() ?>>
<?= $Grid->KUITANSI_ID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_KUITANSI_ID" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_KUITANSI_ID" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_KUITANSI_ID" value="<?= HtmlEncode($Grid->KUITANSI_ID->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_KUITANSI_ID" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_KUITANSI_ID" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_KUITANSI_ID" value="<?= HtmlEncode($Grid->KUITANSI_ID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->PEMBULATAN->Visible) { // PEMBULATAN ?>
        <td data-name="PEMBULATAN" <?= $Grid->PEMBULATAN->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_PEMBULATAN" class="form-group">
<input type="<?= $Grid->PEMBULATAN->getInputTextType() ?>" data-table="V_TREAT" data-field="x_PEMBULATAN" name="x<?= $Grid->RowIndex ?>_PEMBULATAN" id="x<?= $Grid->RowIndex ?>_PEMBULATAN" size="30" placeholder="<?= HtmlEncode($Grid->PEMBULATAN->getPlaceHolder()) ?>" value="<?= $Grid->PEMBULATAN->EditValue ?>"<?= $Grid->PEMBULATAN->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->PEMBULATAN->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_PEMBULATAN" data-hidden="1" name="o<?= $Grid->RowIndex ?>_PEMBULATAN" id="o<?= $Grid->RowIndex ?>_PEMBULATAN" value="<?= HtmlEncode($Grid->PEMBULATAN->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_PEMBULATAN" class="form-group">
<input type="<?= $Grid->PEMBULATAN->getInputTextType() ?>" data-table="V_TREAT" data-field="x_PEMBULATAN" name="x<?= $Grid->RowIndex ?>_PEMBULATAN" id="x<?= $Grid->RowIndex ?>_PEMBULATAN" size="30" placeholder="<?= HtmlEncode($Grid->PEMBULATAN->getPlaceHolder()) ?>" value="<?= $Grid->PEMBULATAN->EditValue ?>"<?= $Grid->PEMBULATAN->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->PEMBULATAN->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_PEMBULATAN">
<span<?= $Grid->PEMBULATAN->viewAttributes() ?>>
<?= $Grid->PEMBULATAN->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_PEMBULATAN" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_PEMBULATAN" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_PEMBULATAN" value="<?= HtmlEncode($Grid->PEMBULATAN->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_PEMBULATAN" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_PEMBULATAN" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_PEMBULATAN" value="<?= HtmlEncode($Grid->PEMBULATAN->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->KAL_ID->Visible) { // KAL_ID ?>
        <td data-name="KAL_ID" <?= $Grid->KAL_ID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_KAL_ID" class="form-group">
<input type="<?= $Grid->KAL_ID->getInputTextType() ?>" data-table="V_TREAT" data-field="x_KAL_ID" name="x<?= $Grid->RowIndex ?>_KAL_ID" id="x<?= $Grid->RowIndex ?>_KAL_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->KAL_ID->getPlaceHolder()) ?>" value="<?= $Grid->KAL_ID->EditValue ?>"<?= $Grid->KAL_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->KAL_ID->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_KAL_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_KAL_ID" id="o<?= $Grid->RowIndex ?>_KAL_ID" value="<?= HtmlEncode($Grid->KAL_ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_KAL_ID" class="form-group">
<input type="<?= $Grid->KAL_ID->getInputTextType() ?>" data-table="V_TREAT" data-field="x_KAL_ID" name="x<?= $Grid->RowIndex ?>_KAL_ID" id="x<?= $Grid->RowIndex ?>_KAL_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->KAL_ID->getPlaceHolder()) ?>" value="<?= $Grid->KAL_ID->EditValue ?>"<?= $Grid->KAL_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->KAL_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_KAL_ID">
<span<?= $Grid->KAL_ID->viewAttributes() ?>>
<?= $Grid->KAL_ID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_KAL_ID" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_KAL_ID" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_KAL_ID" value="<?= HtmlEncode($Grid->KAL_ID->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_KAL_ID" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_KAL_ID" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_KAL_ID" value="<?= HtmlEncode($Grid->KAL_ID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->INVOICE_ID->Visible) { // INVOICE_ID ?>
        <td data-name="INVOICE_ID" <?= $Grid->INVOICE_ID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_INVOICE_ID" class="form-group">
<input type="<?= $Grid->INVOICE_ID->getInputTextType() ?>" data-table="V_TREAT" data-field="x_INVOICE_ID" name="x<?= $Grid->RowIndex ?>_INVOICE_ID" id="x<?= $Grid->RowIndex ?>_INVOICE_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->INVOICE_ID->getPlaceHolder()) ?>" value="<?= $Grid->INVOICE_ID->EditValue ?>"<?= $Grid->INVOICE_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->INVOICE_ID->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_INVOICE_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_INVOICE_ID" id="o<?= $Grid->RowIndex ?>_INVOICE_ID" value="<?= HtmlEncode($Grid->INVOICE_ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_INVOICE_ID" class="form-group">
<input type="<?= $Grid->INVOICE_ID->getInputTextType() ?>" data-table="V_TREAT" data-field="x_INVOICE_ID" name="x<?= $Grid->RowIndex ?>_INVOICE_ID" id="x<?= $Grid->RowIndex ?>_INVOICE_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->INVOICE_ID->getPlaceHolder()) ?>" value="<?= $Grid->INVOICE_ID->EditValue ?>"<?= $Grid->INVOICE_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->INVOICE_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_INVOICE_ID">
<span<?= $Grid->INVOICE_ID->viewAttributes() ?>>
<?= $Grid->INVOICE_ID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_INVOICE_ID" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_INVOICE_ID" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_INVOICE_ID" value="<?= HtmlEncode($Grid->INVOICE_ID->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_INVOICE_ID" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_INVOICE_ID" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_INVOICE_ID" value="<?= HtmlEncode($Grid->INVOICE_ID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->SERVICE_TIME->Visible) { // SERVICE_TIME ?>
        <td data-name="SERVICE_TIME" <?= $Grid->SERVICE_TIME->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_SERVICE_TIME" class="form-group">
<input type="<?= $Grid->SERVICE_TIME->getInputTextType() ?>" data-table="V_TREAT" data-field="x_SERVICE_TIME" name="x<?= $Grid->RowIndex ?>_SERVICE_TIME" id="x<?= $Grid->RowIndex ?>_SERVICE_TIME" placeholder="<?= HtmlEncode($Grid->SERVICE_TIME->getPlaceHolder()) ?>" value="<?= $Grid->SERVICE_TIME->EditValue ?>"<?= $Grid->SERVICE_TIME->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->SERVICE_TIME->getErrorMessage() ?></div>
<?php if (!$Grid->SERVICE_TIME->ReadOnly && !$Grid->SERVICE_TIME->Disabled && !isset($Grid->SERVICE_TIME->EditAttrs["readonly"]) && !isset($Grid->SERVICE_TIME->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fV_TREATgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fV_TREATgrid", "x<?= $Grid->RowIndex ?>_SERVICE_TIME", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_SERVICE_TIME" data-hidden="1" name="o<?= $Grid->RowIndex ?>_SERVICE_TIME" id="o<?= $Grid->RowIndex ?>_SERVICE_TIME" value="<?= HtmlEncode($Grid->SERVICE_TIME->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_SERVICE_TIME" class="form-group">
<input type="<?= $Grid->SERVICE_TIME->getInputTextType() ?>" data-table="V_TREAT" data-field="x_SERVICE_TIME" name="x<?= $Grid->RowIndex ?>_SERVICE_TIME" id="x<?= $Grid->RowIndex ?>_SERVICE_TIME" placeholder="<?= HtmlEncode($Grid->SERVICE_TIME->getPlaceHolder()) ?>" value="<?= $Grid->SERVICE_TIME->EditValue ?>"<?= $Grid->SERVICE_TIME->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->SERVICE_TIME->getErrorMessage() ?></div>
<?php if (!$Grid->SERVICE_TIME->ReadOnly && !$Grid->SERVICE_TIME->Disabled && !isset($Grid->SERVICE_TIME->EditAttrs["readonly"]) && !isset($Grid->SERVICE_TIME->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fV_TREATgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fV_TREATgrid", "x<?= $Grid->RowIndex ?>_SERVICE_TIME", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_SERVICE_TIME">
<span<?= $Grid->SERVICE_TIME->viewAttributes() ?>>
<?= $Grid->SERVICE_TIME->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_SERVICE_TIME" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_SERVICE_TIME" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_SERVICE_TIME" value="<?= HtmlEncode($Grid->SERVICE_TIME->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_SERVICE_TIME" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_SERVICE_TIME" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_SERVICE_TIME" value="<?= HtmlEncode($Grid->SERVICE_TIME->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->TAKEN_TIME->Visible) { // TAKEN_TIME ?>
        <td data-name="TAKEN_TIME" <?= $Grid->TAKEN_TIME->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_TAKEN_TIME" class="form-group">
<input type="<?= $Grid->TAKEN_TIME->getInputTextType() ?>" data-table="V_TREAT" data-field="x_TAKEN_TIME" name="x<?= $Grid->RowIndex ?>_TAKEN_TIME" id="x<?= $Grid->RowIndex ?>_TAKEN_TIME" placeholder="<?= HtmlEncode($Grid->TAKEN_TIME->getPlaceHolder()) ?>" value="<?= $Grid->TAKEN_TIME->EditValue ?>"<?= $Grid->TAKEN_TIME->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->TAKEN_TIME->getErrorMessage() ?></div>
<?php if (!$Grid->TAKEN_TIME->ReadOnly && !$Grid->TAKEN_TIME->Disabled && !isset($Grid->TAKEN_TIME->EditAttrs["readonly"]) && !isset($Grid->TAKEN_TIME->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fV_TREATgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fV_TREATgrid", "x<?= $Grid->RowIndex ?>_TAKEN_TIME", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_TAKEN_TIME" data-hidden="1" name="o<?= $Grid->RowIndex ?>_TAKEN_TIME" id="o<?= $Grid->RowIndex ?>_TAKEN_TIME" value="<?= HtmlEncode($Grid->TAKEN_TIME->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_TAKEN_TIME" class="form-group">
<input type="<?= $Grid->TAKEN_TIME->getInputTextType() ?>" data-table="V_TREAT" data-field="x_TAKEN_TIME" name="x<?= $Grid->RowIndex ?>_TAKEN_TIME" id="x<?= $Grid->RowIndex ?>_TAKEN_TIME" placeholder="<?= HtmlEncode($Grid->TAKEN_TIME->getPlaceHolder()) ?>" value="<?= $Grid->TAKEN_TIME->EditValue ?>"<?= $Grid->TAKEN_TIME->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->TAKEN_TIME->getErrorMessage() ?></div>
<?php if (!$Grid->TAKEN_TIME->ReadOnly && !$Grid->TAKEN_TIME->Disabled && !isset($Grid->TAKEN_TIME->EditAttrs["readonly"]) && !isset($Grid->TAKEN_TIME->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fV_TREATgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fV_TREATgrid", "x<?= $Grid->RowIndex ?>_TAKEN_TIME", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_TAKEN_TIME">
<span<?= $Grid->TAKEN_TIME->viewAttributes() ?>>
<?= $Grid->TAKEN_TIME->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_TAKEN_TIME" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_TAKEN_TIME" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_TAKEN_TIME" value="<?= HtmlEncode($Grid->TAKEN_TIME->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_TAKEN_TIME" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_TAKEN_TIME" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_TAKEN_TIME" value="<?= HtmlEncode($Grid->TAKEN_TIME->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->modified_datesys->Visible) { // modified_datesys ?>
        <td data-name="modified_datesys" <?= $Grid->modified_datesys->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_modified_datesys" class="form-group">
<input type="<?= $Grid->modified_datesys->getInputTextType() ?>" data-table="V_TREAT" data-field="x_modified_datesys" name="x<?= $Grid->RowIndex ?>_modified_datesys" id="x<?= $Grid->RowIndex ?>_modified_datesys" placeholder="<?= HtmlEncode($Grid->modified_datesys->getPlaceHolder()) ?>" value="<?= $Grid->modified_datesys->EditValue ?>"<?= $Grid->modified_datesys->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->modified_datesys->getErrorMessage() ?></div>
<?php if (!$Grid->modified_datesys->ReadOnly && !$Grid->modified_datesys->Disabled && !isset($Grid->modified_datesys->EditAttrs["readonly"]) && !isset($Grid->modified_datesys->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fV_TREATgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fV_TREATgrid", "x<?= $Grid->RowIndex ?>_modified_datesys", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_modified_datesys" data-hidden="1" name="o<?= $Grid->RowIndex ?>_modified_datesys" id="o<?= $Grid->RowIndex ?>_modified_datesys" value="<?= HtmlEncode($Grid->modified_datesys->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_modified_datesys" class="form-group">
<input type="<?= $Grid->modified_datesys->getInputTextType() ?>" data-table="V_TREAT" data-field="x_modified_datesys" name="x<?= $Grid->RowIndex ?>_modified_datesys" id="x<?= $Grid->RowIndex ?>_modified_datesys" placeholder="<?= HtmlEncode($Grid->modified_datesys->getPlaceHolder()) ?>" value="<?= $Grid->modified_datesys->EditValue ?>"<?= $Grid->modified_datesys->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->modified_datesys->getErrorMessage() ?></div>
<?php if (!$Grid->modified_datesys->ReadOnly && !$Grid->modified_datesys->Disabled && !isset($Grid->modified_datesys->EditAttrs["readonly"]) && !isset($Grid->modified_datesys->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fV_TREATgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fV_TREATgrid", "x<?= $Grid->RowIndex ?>_modified_datesys", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_modified_datesys">
<span<?= $Grid->modified_datesys->viewAttributes() ?>>
<?= $Grid->modified_datesys->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_modified_datesys" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_modified_datesys" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_modified_datesys" value="<?= HtmlEncode($Grid->modified_datesys->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_modified_datesys" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_modified_datesys" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_modified_datesys" value="<?= HtmlEncode($Grid->modified_datesys->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->TRANS_ID->Visible) { // TRANS_ID ?>
        <td data-name="TRANS_ID" <?= $Grid->TRANS_ID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_TRANS_ID" class="form-group">
<input type="<?= $Grid->TRANS_ID->getInputTextType() ?>" data-table="V_TREAT" data-field="x_TRANS_ID" name="x<?= $Grid->RowIndex ?>_TRANS_ID" id="x<?= $Grid->RowIndex ?>_TRANS_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->TRANS_ID->getPlaceHolder()) ?>" value="<?= $Grid->TRANS_ID->EditValue ?>"<?= $Grid->TRANS_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->TRANS_ID->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_TRANS_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_TRANS_ID" id="o<?= $Grid->RowIndex ?>_TRANS_ID" value="<?= HtmlEncode($Grid->TRANS_ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_TRANS_ID" class="form-group">
<input type="<?= $Grid->TRANS_ID->getInputTextType() ?>" data-table="V_TREAT" data-field="x_TRANS_ID" name="x<?= $Grid->RowIndex ?>_TRANS_ID" id="x<?= $Grid->RowIndex ?>_TRANS_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->TRANS_ID->getPlaceHolder()) ?>" value="<?= $Grid->TRANS_ID->EditValue ?>"<?= $Grid->TRANS_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->TRANS_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_TRANS_ID">
<span<?= $Grid->TRANS_ID->viewAttributes() ?>>
<?= $Grid->TRANS_ID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_TRANS_ID" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_TRANS_ID" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_TRANS_ID" value="<?= HtmlEncode($Grid->TRANS_ID->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_TRANS_ID" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_TRANS_ID" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_TRANS_ID" value="<?= HtmlEncode($Grid->TRANS_ID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->SPPBILL->Visible) { // SPPBILL ?>
        <td data-name="SPPBILL" <?= $Grid->SPPBILL->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_SPPBILL" class="form-group">
<input type="<?= $Grid->SPPBILL->getInputTextType() ?>" data-table="V_TREAT" data-field="x_SPPBILL" name="x<?= $Grid->RowIndex ?>_SPPBILL" id="x<?= $Grid->RowIndex ?>_SPPBILL" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->SPPBILL->getPlaceHolder()) ?>" value="<?= $Grid->SPPBILL->EditValue ?>"<?= $Grid->SPPBILL->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->SPPBILL->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_SPPBILL" data-hidden="1" name="o<?= $Grid->RowIndex ?>_SPPBILL" id="o<?= $Grid->RowIndex ?>_SPPBILL" value="<?= HtmlEncode($Grid->SPPBILL->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_SPPBILL" class="form-group">
<input type="<?= $Grid->SPPBILL->getInputTextType() ?>" data-table="V_TREAT" data-field="x_SPPBILL" name="x<?= $Grid->RowIndex ?>_SPPBILL" id="x<?= $Grid->RowIndex ?>_SPPBILL" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->SPPBILL->getPlaceHolder()) ?>" value="<?= $Grid->SPPBILL->EditValue ?>"<?= $Grid->SPPBILL->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->SPPBILL->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_SPPBILL">
<span<?= $Grid->SPPBILL->viewAttributes() ?>>
<?= $Grid->SPPBILL->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_SPPBILL" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_SPPBILL" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_SPPBILL" value="<?= HtmlEncode($Grid->SPPBILL->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_SPPBILL" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_SPPBILL" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_SPPBILL" value="<?= HtmlEncode($Grid->SPPBILL->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->SPPBILLDATE->Visible) { // SPPBILLDATE ?>
        <td data-name="SPPBILLDATE" <?= $Grid->SPPBILLDATE->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_SPPBILLDATE" class="form-group">
<input type="<?= $Grid->SPPBILLDATE->getInputTextType() ?>" data-table="V_TREAT" data-field="x_SPPBILLDATE" name="x<?= $Grid->RowIndex ?>_SPPBILLDATE" id="x<?= $Grid->RowIndex ?>_SPPBILLDATE" placeholder="<?= HtmlEncode($Grid->SPPBILLDATE->getPlaceHolder()) ?>" value="<?= $Grid->SPPBILLDATE->EditValue ?>"<?= $Grid->SPPBILLDATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->SPPBILLDATE->getErrorMessage() ?></div>
<?php if (!$Grid->SPPBILLDATE->ReadOnly && !$Grid->SPPBILLDATE->Disabled && !isset($Grid->SPPBILLDATE->EditAttrs["readonly"]) && !isset($Grid->SPPBILLDATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fV_TREATgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fV_TREATgrid", "x<?= $Grid->RowIndex ?>_SPPBILLDATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_SPPBILLDATE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_SPPBILLDATE" id="o<?= $Grid->RowIndex ?>_SPPBILLDATE" value="<?= HtmlEncode($Grid->SPPBILLDATE->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_SPPBILLDATE" class="form-group">
<input type="<?= $Grid->SPPBILLDATE->getInputTextType() ?>" data-table="V_TREAT" data-field="x_SPPBILLDATE" name="x<?= $Grid->RowIndex ?>_SPPBILLDATE" id="x<?= $Grid->RowIndex ?>_SPPBILLDATE" placeholder="<?= HtmlEncode($Grid->SPPBILLDATE->getPlaceHolder()) ?>" value="<?= $Grid->SPPBILLDATE->EditValue ?>"<?= $Grid->SPPBILLDATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->SPPBILLDATE->getErrorMessage() ?></div>
<?php if (!$Grid->SPPBILLDATE->ReadOnly && !$Grid->SPPBILLDATE->Disabled && !isset($Grid->SPPBILLDATE->EditAttrs["readonly"]) && !isset($Grid->SPPBILLDATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fV_TREATgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fV_TREATgrid", "x<?= $Grid->RowIndex ?>_SPPBILLDATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_SPPBILLDATE">
<span<?= $Grid->SPPBILLDATE->viewAttributes() ?>>
<?= $Grid->SPPBILLDATE->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_SPPBILLDATE" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_SPPBILLDATE" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_SPPBILLDATE" value="<?= HtmlEncode($Grid->SPPBILLDATE->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_SPPBILLDATE" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_SPPBILLDATE" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_SPPBILLDATE" value="<?= HtmlEncode($Grid->SPPBILLDATE->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->SPPBILLUSER->Visible) { // SPPBILLUSER ?>
        <td data-name="SPPBILLUSER" <?= $Grid->SPPBILLUSER->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_SPPBILLUSER" class="form-group">
<input type="<?= $Grid->SPPBILLUSER->getInputTextType() ?>" data-table="V_TREAT" data-field="x_SPPBILLUSER" name="x<?= $Grid->RowIndex ?>_SPPBILLUSER" id="x<?= $Grid->RowIndex ?>_SPPBILLUSER" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->SPPBILLUSER->getPlaceHolder()) ?>" value="<?= $Grid->SPPBILLUSER->EditValue ?>"<?= $Grid->SPPBILLUSER->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->SPPBILLUSER->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_SPPBILLUSER" data-hidden="1" name="o<?= $Grid->RowIndex ?>_SPPBILLUSER" id="o<?= $Grid->RowIndex ?>_SPPBILLUSER" value="<?= HtmlEncode($Grid->SPPBILLUSER->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_SPPBILLUSER" class="form-group">
<input type="<?= $Grid->SPPBILLUSER->getInputTextType() ?>" data-table="V_TREAT" data-field="x_SPPBILLUSER" name="x<?= $Grid->RowIndex ?>_SPPBILLUSER" id="x<?= $Grid->RowIndex ?>_SPPBILLUSER" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->SPPBILLUSER->getPlaceHolder()) ?>" value="<?= $Grid->SPPBILLUSER->EditValue ?>"<?= $Grid->SPPBILLUSER->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->SPPBILLUSER->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_SPPBILLUSER">
<span<?= $Grid->SPPBILLUSER->viewAttributes() ?>>
<?= $Grid->SPPBILLUSER->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_SPPBILLUSER" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_SPPBILLUSER" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_SPPBILLUSER" value="<?= HtmlEncode($Grid->SPPBILLUSER->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_SPPBILLUSER" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_SPPBILLUSER" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_SPPBILLUSER" value="<?= HtmlEncode($Grid->SPPBILLUSER->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->SPPKASIR->Visible) { // SPPKASIR ?>
        <td data-name="SPPKASIR" <?= $Grid->SPPKASIR->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_SPPKASIR" class="form-group">
<input type="<?= $Grid->SPPKASIR->getInputTextType() ?>" data-table="V_TREAT" data-field="x_SPPKASIR" name="x<?= $Grid->RowIndex ?>_SPPKASIR" id="x<?= $Grid->RowIndex ?>_SPPKASIR" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->SPPKASIR->getPlaceHolder()) ?>" value="<?= $Grid->SPPKASIR->EditValue ?>"<?= $Grid->SPPKASIR->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->SPPKASIR->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_SPPKASIR" data-hidden="1" name="o<?= $Grid->RowIndex ?>_SPPKASIR" id="o<?= $Grid->RowIndex ?>_SPPKASIR" value="<?= HtmlEncode($Grid->SPPKASIR->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_SPPKASIR" class="form-group">
<input type="<?= $Grid->SPPKASIR->getInputTextType() ?>" data-table="V_TREAT" data-field="x_SPPKASIR" name="x<?= $Grid->RowIndex ?>_SPPKASIR" id="x<?= $Grid->RowIndex ?>_SPPKASIR" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->SPPKASIR->getPlaceHolder()) ?>" value="<?= $Grid->SPPKASIR->EditValue ?>"<?= $Grid->SPPKASIR->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->SPPKASIR->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_SPPKASIR">
<span<?= $Grid->SPPKASIR->viewAttributes() ?>>
<?= $Grid->SPPKASIR->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_SPPKASIR" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_SPPKASIR" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_SPPKASIR" value="<?= HtmlEncode($Grid->SPPKASIR->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_SPPKASIR" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_SPPKASIR" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_SPPKASIR" value="<?= HtmlEncode($Grid->SPPKASIR->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->SPPKASIRDATE->Visible) { // SPPKASIRDATE ?>
        <td data-name="SPPKASIRDATE" <?= $Grid->SPPKASIRDATE->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_SPPKASIRDATE" class="form-group">
<input type="<?= $Grid->SPPKASIRDATE->getInputTextType() ?>" data-table="V_TREAT" data-field="x_SPPKASIRDATE" name="x<?= $Grid->RowIndex ?>_SPPKASIRDATE" id="x<?= $Grid->RowIndex ?>_SPPKASIRDATE" placeholder="<?= HtmlEncode($Grid->SPPKASIRDATE->getPlaceHolder()) ?>" value="<?= $Grid->SPPKASIRDATE->EditValue ?>"<?= $Grid->SPPKASIRDATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->SPPKASIRDATE->getErrorMessage() ?></div>
<?php if (!$Grid->SPPKASIRDATE->ReadOnly && !$Grid->SPPKASIRDATE->Disabled && !isset($Grid->SPPKASIRDATE->EditAttrs["readonly"]) && !isset($Grid->SPPKASIRDATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fV_TREATgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fV_TREATgrid", "x<?= $Grid->RowIndex ?>_SPPKASIRDATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_SPPKASIRDATE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_SPPKASIRDATE" id="o<?= $Grid->RowIndex ?>_SPPKASIRDATE" value="<?= HtmlEncode($Grid->SPPKASIRDATE->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_SPPKASIRDATE" class="form-group">
<input type="<?= $Grid->SPPKASIRDATE->getInputTextType() ?>" data-table="V_TREAT" data-field="x_SPPKASIRDATE" name="x<?= $Grid->RowIndex ?>_SPPKASIRDATE" id="x<?= $Grid->RowIndex ?>_SPPKASIRDATE" placeholder="<?= HtmlEncode($Grid->SPPKASIRDATE->getPlaceHolder()) ?>" value="<?= $Grid->SPPKASIRDATE->EditValue ?>"<?= $Grid->SPPKASIRDATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->SPPKASIRDATE->getErrorMessage() ?></div>
<?php if (!$Grid->SPPKASIRDATE->ReadOnly && !$Grid->SPPKASIRDATE->Disabled && !isset($Grid->SPPKASIRDATE->EditAttrs["readonly"]) && !isset($Grid->SPPKASIRDATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fV_TREATgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fV_TREATgrid", "x<?= $Grid->RowIndex ?>_SPPKASIRDATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_SPPKASIRDATE">
<span<?= $Grid->SPPKASIRDATE->viewAttributes() ?>>
<?= $Grid->SPPKASIRDATE->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_SPPKASIRDATE" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_SPPKASIRDATE" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_SPPKASIRDATE" value="<?= HtmlEncode($Grid->SPPKASIRDATE->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_SPPKASIRDATE" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_SPPKASIRDATE" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_SPPKASIRDATE" value="<?= HtmlEncode($Grid->SPPKASIRDATE->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->SPPKASIRUSER->Visible) { // SPPKASIRUSER ?>
        <td data-name="SPPKASIRUSER" <?= $Grid->SPPKASIRUSER->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_SPPKASIRUSER" class="form-group">
<input type="<?= $Grid->SPPKASIRUSER->getInputTextType() ?>" data-table="V_TREAT" data-field="x_SPPKASIRUSER" name="x<?= $Grid->RowIndex ?>_SPPKASIRUSER" id="x<?= $Grid->RowIndex ?>_SPPKASIRUSER" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->SPPKASIRUSER->getPlaceHolder()) ?>" value="<?= $Grid->SPPKASIRUSER->EditValue ?>"<?= $Grid->SPPKASIRUSER->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->SPPKASIRUSER->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_SPPKASIRUSER" data-hidden="1" name="o<?= $Grid->RowIndex ?>_SPPKASIRUSER" id="o<?= $Grid->RowIndex ?>_SPPKASIRUSER" value="<?= HtmlEncode($Grid->SPPKASIRUSER->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_SPPKASIRUSER" class="form-group">
<input type="<?= $Grid->SPPKASIRUSER->getInputTextType() ?>" data-table="V_TREAT" data-field="x_SPPKASIRUSER" name="x<?= $Grid->RowIndex ?>_SPPKASIRUSER" id="x<?= $Grid->RowIndex ?>_SPPKASIRUSER" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->SPPKASIRUSER->getPlaceHolder()) ?>" value="<?= $Grid->SPPKASIRUSER->EditValue ?>"<?= $Grid->SPPKASIRUSER->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->SPPKASIRUSER->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_SPPKASIRUSER">
<span<?= $Grid->SPPKASIRUSER->viewAttributes() ?>>
<?= $Grid->SPPKASIRUSER->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_SPPKASIRUSER" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_SPPKASIRUSER" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_SPPKASIRUSER" value="<?= HtmlEncode($Grid->SPPKASIRUSER->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_SPPKASIRUSER" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_SPPKASIRUSER" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_SPPKASIRUSER" value="<?= HtmlEncode($Grid->SPPKASIRUSER->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->SPPPOLI->Visible) { // SPPPOLI ?>
        <td data-name="SPPPOLI" <?= $Grid->SPPPOLI->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_SPPPOLI" class="form-group">
<input type="<?= $Grid->SPPPOLI->getInputTextType() ?>" data-table="V_TREAT" data-field="x_SPPPOLI" name="x<?= $Grid->RowIndex ?>_SPPPOLI" id="x<?= $Grid->RowIndex ?>_SPPPOLI" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->SPPPOLI->getPlaceHolder()) ?>" value="<?= $Grid->SPPPOLI->EditValue ?>"<?= $Grid->SPPPOLI->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->SPPPOLI->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_SPPPOLI" data-hidden="1" name="o<?= $Grid->RowIndex ?>_SPPPOLI" id="o<?= $Grid->RowIndex ?>_SPPPOLI" value="<?= HtmlEncode($Grid->SPPPOLI->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_SPPPOLI" class="form-group">
<input type="<?= $Grid->SPPPOLI->getInputTextType() ?>" data-table="V_TREAT" data-field="x_SPPPOLI" name="x<?= $Grid->RowIndex ?>_SPPPOLI" id="x<?= $Grid->RowIndex ?>_SPPPOLI" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->SPPPOLI->getPlaceHolder()) ?>" value="<?= $Grid->SPPPOLI->EditValue ?>"<?= $Grid->SPPPOLI->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->SPPPOLI->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_SPPPOLI">
<span<?= $Grid->SPPPOLI->viewAttributes() ?>>
<?= $Grid->SPPPOLI->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_SPPPOLI" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_SPPPOLI" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_SPPPOLI" value="<?= HtmlEncode($Grid->SPPPOLI->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_SPPPOLI" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_SPPPOLI" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_SPPPOLI" value="<?= HtmlEncode($Grid->SPPPOLI->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->SPPPOLIUSER->Visible) { // SPPPOLIUSER ?>
        <td data-name="SPPPOLIUSER" <?= $Grid->SPPPOLIUSER->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_SPPPOLIUSER" class="form-group">
<input type="<?= $Grid->SPPPOLIUSER->getInputTextType() ?>" data-table="V_TREAT" data-field="x_SPPPOLIUSER" name="x<?= $Grid->RowIndex ?>_SPPPOLIUSER" id="x<?= $Grid->RowIndex ?>_SPPPOLIUSER" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->SPPPOLIUSER->getPlaceHolder()) ?>" value="<?= $Grid->SPPPOLIUSER->EditValue ?>"<?= $Grid->SPPPOLIUSER->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->SPPPOLIUSER->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_SPPPOLIUSER" data-hidden="1" name="o<?= $Grid->RowIndex ?>_SPPPOLIUSER" id="o<?= $Grid->RowIndex ?>_SPPPOLIUSER" value="<?= HtmlEncode($Grid->SPPPOLIUSER->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_SPPPOLIUSER" class="form-group">
<input type="<?= $Grid->SPPPOLIUSER->getInputTextType() ?>" data-table="V_TREAT" data-field="x_SPPPOLIUSER" name="x<?= $Grid->RowIndex ?>_SPPPOLIUSER" id="x<?= $Grid->RowIndex ?>_SPPPOLIUSER" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->SPPPOLIUSER->getPlaceHolder()) ?>" value="<?= $Grid->SPPPOLIUSER->EditValue ?>"<?= $Grid->SPPPOLIUSER->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->SPPPOLIUSER->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_SPPPOLIUSER">
<span<?= $Grid->SPPPOLIUSER->viewAttributes() ?>>
<?= $Grid->SPPPOLIUSER->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_SPPPOLIUSER" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_SPPPOLIUSER" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_SPPPOLIUSER" value="<?= HtmlEncode($Grid->SPPPOLIUSER->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_SPPPOLIUSER" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_SPPPOLIUSER" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_SPPPOLIUSER" value="<?= HtmlEncode($Grid->SPPPOLIUSER->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->SPPPOLIDATE->Visible) { // SPPPOLIDATE ?>
        <td data-name="SPPPOLIDATE" <?= $Grid->SPPPOLIDATE->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_SPPPOLIDATE" class="form-group">
<input type="<?= $Grid->SPPPOLIDATE->getInputTextType() ?>" data-table="V_TREAT" data-field="x_SPPPOLIDATE" name="x<?= $Grid->RowIndex ?>_SPPPOLIDATE" id="x<?= $Grid->RowIndex ?>_SPPPOLIDATE" placeholder="<?= HtmlEncode($Grid->SPPPOLIDATE->getPlaceHolder()) ?>" value="<?= $Grid->SPPPOLIDATE->EditValue ?>"<?= $Grid->SPPPOLIDATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->SPPPOLIDATE->getErrorMessage() ?></div>
<?php if (!$Grid->SPPPOLIDATE->ReadOnly && !$Grid->SPPPOLIDATE->Disabled && !isset($Grid->SPPPOLIDATE->EditAttrs["readonly"]) && !isset($Grid->SPPPOLIDATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fV_TREATgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fV_TREATgrid", "x<?= $Grid->RowIndex ?>_SPPPOLIDATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_SPPPOLIDATE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_SPPPOLIDATE" id="o<?= $Grid->RowIndex ?>_SPPPOLIDATE" value="<?= HtmlEncode($Grid->SPPPOLIDATE->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_SPPPOLIDATE" class="form-group">
<input type="<?= $Grid->SPPPOLIDATE->getInputTextType() ?>" data-table="V_TREAT" data-field="x_SPPPOLIDATE" name="x<?= $Grid->RowIndex ?>_SPPPOLIDATE" id="x<?= $Grid->RowIndex ?>_SPPPOLIDATE" placeholder="<?= HtmlEncode($Grid->SPPPOLIDATE->getPlaceHolder()) ?>" value="<?= $Grid->SPPPOLIDATE->EditValue ?>"<?= $Grid->SPPPOLIDATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->SPPPOLIDATE->getErrorMessage() ?></div>
<?php if (!$Grid->SPPPOLIDATE->ReadOnly && !$Grid->SPPPOLIDATE->Disabled && !isset($Grid->SPPPOLIDATE->EditAttrs["readonly"]) && !isset($Grid->SPPPOLIDATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fV_TREATgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fV_TREATgrid", "x<?= $Grid->RowIndex ?>_SPPPOLIDATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_SPPPOLIDATE">
<span<?= $Grid->SPPPOLIDATE->viewAttributes() ?>>
<?= $Grid->SPPPOLIDATE->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_SPPPOLIDATE" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_SPPPOLIDATE" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_SPPPOLIDATE" value="<?= HtmlEncode($Grid->SPPPOLIDATE->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_SPPPOLIDATE" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_SPPPOLIDATE" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_SPPPOLIDATE" value="<?= HtmlEncode($Grid->SPPPOLIDATE->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->NOSEP->Visible) { // NOSEP ?>
        <td data-name="NOSEP" <?= $Grid->NOSEP->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_NOSEP" class="form-group">
<input type="<?= $Grid->NOSEP->getInputTextType() ?>" data-table="V_TREAT" data-field="x_NOSEP" name="x<?= $Grid->RowIndex ?>_NOSEP" id="x<?= $Grid->RowIndex ?>_NOSEP" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->NOSEP->getPlaceHolder()) ?>" value="<?= $Grid->NOSEP->EditValue ?>"<?= $Grid->NOSEP->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->NOSEP->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_NOSEP" data-hidden="1" name="o<?= $Grid->RowIndex ?>_NOSEP" id="o<?= $Grid->RowIndex ?>_NOSEP" value="<?= HtmlEncode($Grid->NOSEP->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_NOSEP" class="form-group">
<input type="<?= $Grid->NOSEP->getInputTextType() ?>" data-table="V_TREAT" data-field="x_NOSEP" name="x<?= $Grid->RowIndex ?>_NOSEP" id="x<?= $Grid->RowIndex ?>_NOSEP" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->NOSEP->getPlaceHolder()) ?>" value="<?= $Grid->NOSEP->EditValue ?>"<?= $Grid->NOSEP->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->NOSEP->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_NOSEP">
<span<?= $Grid->NOSEP->viewAttributes() ?>>
<?= $Grid->NOSEP->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_NOSEP" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_NOSEP" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_NOSEP" value="<?= HtmlEncode($Grid->NOSEP->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_NOSEP" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_NOSEP" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_NOSEP" value="<?= HtmlEncode($Grid->NOSEP->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->ID->Visible) { // ID ?>
        <td data-name="ID" <?= $Grid->ID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_ID" class="form-group"></span>
<input type="hidden" data-table="V_TREAT" data-field="x_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ID" id="o<?= $Grid->RowIndex ?>_ID" value="<?= HtmlEncode($Grid->ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_ID" class="form-group">
<span<?= $Grid->ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->ID->getDisplayValue($Grid->ID->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_ID" id="x<?= $Grid->RowIndex ?>_ID" value="<?= HtmlEncode($Grid->ID->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_TREAT_ID">
<span<?= $Grid->ID->viewAttributes() ?>>
<?= $Grid->ID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_TREAT" data-field="x_ID" data-hidden="1" name="fV_TREATgrid$x<?= $Grid->RowIndex ?>_ID" id="fV_TREATgrid$x<?= $Grid->RowIndex ?>_ID" value="<?= HtmlEncode($Grid->ID->FormValue) ?>">
<input type="hidden" data-table="V_TREAT" data-field="x_ID" data-hidden="1" name="fV_TREATgrid$o<?= $Grid->RowIndex ?>_ID" id="fV_TREATgrid$o<?= $Grid->RowIndex ?>_ID" value="<?= HtmlEncode($Grid->ID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="V_TREAT" data-field="x_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_ID" id="x<?= $Grid->RowIndex ?>_ID" value="<?= HtmlEncode($Grid->ID->CurrentValue) ?>">
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowCount);
?>
    </tr>
<?php if ($Grid->RowType == ROWTYPE_ADD || $Grid->RowType == ROWTYPE_EDIT) { ?>
<script>
loadjs.ready(["fV_TREATgrid","load"], function () {
    fV_TREATgrid.updateLists(<?= $Grid->RowIndex ?>);
});
</script>
<?php } ?>
<?php
    }
    } // End delete row checking
    if (!$Grid->isGridAdd() || $Grid->CurrentMode == "copy")
        if (!$Grid->Recordset->EOF) {
            $Grid->Recordset->moveNext();
        }
}
?>
<?php
    if ($Grid->CurrentMode == "add" || $Grid->CurrentMode == "copy" || $Grid->CurrentMode == "edit") {
        $Grid->RowIndex = '$rowindex$';
        $Grid->loadRowValues();

        // Set row properties
        $Grid->resetAttributes();
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_V_TREAT", "data-rowtype" => ROWTYPE_ADD]);
        $Grid->RowAttrs->appendClass("ew-template");
        $Grid->RowType = ROWTYPE_ADD;

        // Render row
        $Grid->renderRow();

        // Render list options
        $Grid->renderListOptions();
        $Grid->StartRowCount = 0;
?>
    <tr <?= $Grid->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Grid->ListOptions->render("body", "left", $Grid->RowIndex);
?>
    <?php if ($Grid->ORG_UNIT_CODE->Visible) { // ORG_UNIT_CODE ?>
        <td data-name="ORG_UNIT_CODE">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_ORG_UNIT_CODE" class="form-group V_TREAT_ORG_UNIT_CODE">
<input type="<?= $Grid->ORG_UNIT_CODE->getInputTextType() ?>" data-table="V_TREAT" data-field="x_ORG_UNIT_CODE" name="x<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" id="x<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->ORG_UNIT_CODE->getPlaceHolder()) ?>" value="<?= $Grid->ORG_UNIT_CODE->EditValue ?>"<?= $Grid->ORG_UNIT_CODE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ORG_UNIT_CODE->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_ORG_UNIT_CODE" class="form-group V_TREAT_ORG_UNIT_CODE">
<span<?= $Grid->ORG_UNIT_CODE->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->ORG_UNIT_CODE->getDisplayValue($Grid->ORG_UNIT_CODE->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_ORG_UNIT_CODE" data-hidden="1" name="x<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" id="x<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" value="<?= HtmlEncode($Grid->ORG_UNIT_CODE->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_ORG_UNIT_CODE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" id="o<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" value="<?= HtmlEncode($Grid->ORG_UNIT_CODE->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->BILL_ID->Visible) { // BILL_ID ?>
        <td data-name="BILL_ID">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_BILL_ID" class="form-group V_TREAT_BILL_ID">
<input type="<?= $Grid->BILL_ID->getInputTextType() ?>" data-table="V_TREAT" data-field="x_BILL_ID" name="x<?= $Grid->RowIndex ?>_BILL_ID" id="x<?= $Grid->RowIndex ?>_BILL_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->BILL_ID->getPlaceHolder()) ?>" value="<?= $Grid->BILL_ID->EditValue ?>"<?= $Grid->BILL_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->BILL_ID->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_BILL_ID" class="form-group V_TREAT_BILL_ID">
<span<?= $Grid->BILL_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->BILL_ID->getDisplayValue($Grid->BILL_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_BILL_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_BILL_ID" id="x<?= $Grid->RowIndex ?>_BILL_ID" value="<?= HtmlEncode($Grid->BILL_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_BILL_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_BILL_ID" id="o<?= $Grid->RowIndex ?>_BILL_ID" value="<?= HtmlEncode($Grid->BILL_ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->NO_REGISTRATION->Visible) { // NO_REGISTRATION ?>
        <td data-name="NO_REGISTRATION">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_NO_REGISTRATION" class="form-group V_TREAT_NO_REGISTRATION">
<input type="<?= $Grid->NO_REGISTRATION->getInputTextType() ?>" data-table="V_TREAT" data-field="x_NO_REGISTRATION" name="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" id="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" size="30" maxlength="25" placeholder="<?= HtmlEncode($Grid->NO_REGISTRATION->getPlaceHolder()) ?>" value="<?= $Grid->NO_REGISTRATION->EditValue ?>"<?= $Grid->NO_REGISTRATION->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->NO_REGISTRATION->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_NO_REGISTRATION" class="form-group V_TREAT_NO_REGISTRATION">
<span<?= $Grid->NO_REGISTRATION->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->NO_REGISTRATION->getDisplayValue($Grid->NO_REGISTRATION->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_NO_REGISTRATION" data-hidden="1" name="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" id="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" value="<?= HtmlEncode($Grid->NO_REGISTRATION->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_NO_REGISTRATION" data-hidden="1" name="o<?= $Grid->RowIndex ?>_NO_REGISTRATION" id="o<?= $Grid->RowIndex ?>_NO_REGISTRATION" value="<?= HtmlEncode($Grid->NO_REGISTRATION->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->VISIT_ID->Visible) { // VISIT_ID ?>
        <td data-name="VISIT_ID">
<?php if (!$Grid->isConfirm()) { ?>
<?php if ($Grid->VISIT_ID->getSessionValue() != "") { ?>
<span id="el$rowindex$_V_TREAT_VISIT_ID" class="form-group V_TREAT_VISIT_ID">
<span<?= $Grid->VISIT_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->VISIT_ID->getDisplayValue($Grid->VISIT_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_VISIT_ID" name="x<?= $Grid->RowIndex ?>_VISIT_ID" value="<?= HtmlEncode($Grid->VISIT_ID->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_VISIT_ID" class="form-group V_TREAT_VISIT_ID">
<input type="<?= $Grid->VISIT_ID->getInputTextType() ?>" data-table="V_TREAT" data-field="x_VISIT_ID" name="x<?= $Grid->RowIndex ?>_VISIT_ID" id="x<?= $Grid->RowIndex ?>_VISIT_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->VISIT_ID->getPlaceHolder()) ?>" value="<?= $Grid->VISIT_ID->EditValue ?>"<?= $Grid->VISIT_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->VISIT_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_VISIT_ID" class="form-group V_TREAT_VISIT_ID">
<span<?= $Grid->VISIT_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->VISIT_ID->getDisplayValue($Grid->VISIT_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_VISIT_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_VISIT_ID" id="x<?= $Grid->RowIndex ?>_VISIT_ID" value="<?= HtmlEncode($Grid->VISIT_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_VISIT_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_VISIT_ID" id="o<?= $Grid->RowIndex ?>_VISIT_ID" value="<?= HtmlEncode($Grid->VISIT_ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->TARIF_ID->Visible) { // TARIF_ID ?>
        <td data-name="TARIF_ID">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_TARIF_ID" class="form-group V_TREAT_TARIF_ID">
<input type="<?= $Grid->TARIF_ID->getInputTextType() ?>" data-table="V_TREAT" data-field="x_TARIF_ID" name="x<?= $Grid->RowIndex ?>_TARIF_ID" id="x<?= $Grid->RowIndex ?>_TARIF_ID" size="30" maxlength="25" placeholder="<?= HtmlEncode($Grid->TARIF_ID->getPlaceHolder()) ?>" value="<?= $Grid->TARIF_ID->EditValue ?>"<?= $Grid->TARIF_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->TARIF_ID->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_TARIF_ID" class="form-group V_TREAT_TARIF_ID">
<span<?= $Grid->TARIF_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->TARIF_ID->getDisplayValue($Grid->TARIF_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_TARIF_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_TARIF_ID" id="x<?= $Grid->RowIndex ?>_TARIF_ID" value="<?= HtmlEncode($Grid->TARIF_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_TARIF_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_TARIF_ID" id="o<?= $Grid->RowIndex ?>_TARIF_ID" value="<?= HtmlEncode($Grid->TARIF_ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->CLASS_ID->Visible) { // CLASS_ID ?>
        <td data-name="CLASS_ID">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_CLASS_ID" class="form-group V_TREAT_CLASS_ID">
<input type="<?= $Grid->CLASS_ID->getInputTextType() ?>" data-table="V_TREAT" data-field="x_CLASS_ID" name="x<?= $Grid->RowIndex ?>_CLASS_ID" id="x<?= $Grid->RowIndex ?>_CLASS_ID" size="30" placeholder="<?= HtmlEncode($Grid->CLASS_ID->getPlaceHolder()) ?>" value="<?= $Grid->CLASS_ID->EditValue ?>"<?= $Grid->CLASS_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->CLASS_ID->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_CLASS_ID" class="form-group V_TREAT_CLASS_ID">
<span<?= $Grid->CLASS_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->CLASS_ID->getDisplayValue($Grid->CLASS_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_CLASS_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_CLASS_ID" id="x<?= $Grid->RowIndex ?>_CLASS_ID" value="<?= HtmlEncode($Grid->CLASS_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_CLASS_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_CLASS_ID" id="o<?= $Grid->RowIndex ?>_CLASS_ID" value="<?= HtmlEncode($Grid->CLASS_ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->CLINIC_ID->Visible) { // CLINIC_ID ?>
        <td data-name="CLINIC_ID">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_CLINIC_ID" class="form-group V_TREAT_CLINIC_ID">
<input type="<?= $Grid->CLINIC_ID->getInputTextType() ?>" data-table="V_TREAT" data-field="x_CLINIC_ID" name="x<?= $Grid->RowIndex ?>_CLINIC_ID" id="x<?= $Grid->RowIndex ?>_CLINIC_ID" size="30" maxlength="15" placeholder="<?= HtmlEncode($Grid->CLINIC_ID->getPlaceHolder()) ?>" value="<?= $Grid->CLINIC_ID->EditValue ?>"<?= $Grid->CLINIC_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->CLINIC_ID->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_CLINIC_ID" class="form-group V_TREAT_CLINIC_ID">
<span<?= $Grid->CLINIC_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->CLINIC_ID->getDisplayValue($Grid->CLINIC_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_CLINIC_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_CLINIC_ID" id="x<?= $Grid->RowIndex ?>_CLINIC_ID" value="<?= HtmlEncode($Grid->CLINIC_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_CLINIC_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_CLINIC_ID" id="o<?= $Grid->RowIndex ?>_CLINIC_ID" value="<?= HtmlEncode($Grid->CLINIC_ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->CLINIC_ID_FROM->Visible) { // CLINIC_ID_FROM ?>
        <td data-name="CLINIC_ID_FROM">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_CLINIC_ID_FROM" class="form-group V_TREAT_CLINIC_ID_FROM">
<input type="<?= $Grid->CLINIC_ID_FROM->getInputTextType() ?>" data-table="V_TREAT" data-field="x_CLINIC_ID_FROM" name="x<?= $Grid->RowIndex ?>_CLINIC_ID_FROM" id="x<?= $Grid->RowIndex ?>_CLINIC_ID_FROM" size="30" maxlength="15" placeholder="<?= HtmlEncode($Grid->CLINIC_ID_FROM->getPlaceHolder()) ?>" value="<?= $Grid->CLINIC_ID_FROM->EditValue ?>"<?= $Grid->CLINIC_ID_FROM->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->CLINIC_ID_FROM->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_CLINIC_ID_FROM" class="form-group V_TREAT_CLINIC_ID_FROM">
<span<?= $Grid->CLINIC_ID_FROM->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->CLINIC_ID_FROM->getDisplayValue($Grid->CLINIC_ID_FROM->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_CLINIC_ID_FROM" data-hidden="1" name="x<?= $Grid->RowIndex ?>_CLINIC_ID_FROM" id="x<?= $Grid->RowIndex ?>_CLINIC_ID_FROM" value="<?= HtmlEncode($Grid->CLINIC_ID_FROM->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_CLINIC_ID_FROM" data-hidden="1" name="o<?= $Grid->RowIndex ?>_CLINIC_ID_FROM" id="o<?= $Grid->RowIndex ?>_CLINIC_ID_FROM" value="<?= HtmlEncode($Grid->CLINIC_ID_FROM->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->TREATMENT->Visible) { // TREATMENT ?>
        <td data-name="TREATMENT">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_TREATMENT" class="form-group V_TREAT_TREATMENT">
<input type="<?= $Grid->TREATMENT->getInputTextType() ?>" data-table="V_TREAT" data-field="x_TREATMENT" name="x<?= $Grid->RowIndex ?>_TREATMENT" id="x<?= $Grid->RowIndex ?>_TREATMENT" size="30" maxlength="200" placeholder="<?= HtmlEncode($Grid->TREATMENT->getPlaceHolder()) ?>" value="<?= $Grid->TREATMENT->EditValue ?>"<?= $Grid->TREATMENT->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->TREATMENT->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_TREATMENT" class="form-group V_TREAT_TREATMENT">
<span<?= $Grid->TREATMENT->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->TREATMENT->getDisplayValue($Grid->TREATMENT->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_TREATMENT" data-hidden="1" name="x<?= $Grid->RowIndex ?>_TREATMENT" id="x<?= $Grid->RowIndex ?>_TREATMENT" value="<?= HtmlEncode($Grid->TREATMENT->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_TREATMENT" data-hidden="1" name="o<?= $Grid->RowIndex ?>_TREATMENT" id="o<?= $Grid->RowIndex ?>_TREATMENT" value="<?= HtmlEncode($Grid->TREATMENT->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->TREAT_DATE->Visible) { // TREAT_DATE ?>
        <td data-name="TREAT_DATE">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_TREAT_DATE" class="form-group V_TREAT_TREAT_DATE">
<input type="<?= $Grid->TREAT_DATE->getInputTextType() ?>" data-table="V_TREAT" data-field="x_TREAT_DATE" name="x<?= $Grid->RowIndex ?>_TREAT_DATE" id="x<?= $Grid->RowIndex ?>_TREAT_DATE" placeholder="<?= HtmlEncode($Grid->TREAT_DATE->getPlaceHolder()) ?>" value="<?= $Grid->TREAT_DATE->EditValue ?>"<?= $Grid->TREAT_DATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->TREAT_DATE->getErrorMessage() ?></div>
<?php if (!$Grid->TREAT_DATE->ReadOnly && !$Grid->TREAT_DATE->Disabled && !isset($Grid->TREAT_DATE->EditAttrs["readonly"]) && !isset($Grid->TREAT_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fV_TREATgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fV_TREATgrid", "x<?= $Grid->RowIndex ?>_TREAT_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_TREAT_DATE" class="form-group V_TREAT_TREAT_DATE">
<span<?= $Grid->TREAT_DATE->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->TREAT_DATE->getDisplayValue($Grid->TREAT_DATE->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_TREAT_DATE" data-hidden="1" name="x<?= $Grid->RowIndex ?>_TREAT_DATE" id="x<?= $Grid->RowIndex ?>_TREAT_DATE" value="<?= HtmlEncode($Grid->TREAT_DATE->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_TREAT_DATE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_TREAT_DATE" id="o<?= $Grid->RowIndex ?>_TREAT_DATE" value="<?= HtmlEncode($Grid->TREAT_DATE->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->QUANTITY->Visible) { // QUANTITY ?>
        <td data-name="QUANTITY">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_QUANTITY" class="form-group V_TREAT_QUANTITY">
<input type="<?= $Grid->QUANTITY->getInputTextType() ?>" data-table="V_TREAT" data-field="x_QUANTITY" name="x<?= $Grid->RowIndex ?>_QUANTITY" id="x<?= $Grid->RowIndex ?>_QUANTITY" size="30" placeholder="<?= HtmlEncode($Grid->QUANTITY->getPlaceHolder()) ?>" value="<?= $Grid->QUANTITY->EditValue ?>"<?= $Grid->QUANTITY->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->QUANTITY->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_QUANTITY" class="form-group V_TREAT_QUANTITY">
<span<?= $Grid->QUANTITY->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->QUANTITY->getDisplayValue($Grid->QUANTITY->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_QUANTITY" data-hidden="1" name="x<?= $Grid->RowIndex ?>_QUANTITY" id="x<?= $Grid->RowIndex ?>_QUANTITY" value="<?= HtmlEncode($Grid->QUANTITY->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_QUANTITY" data-hidden="1" name="o<?= $Grid->RowIndex ?>_QUANTITY" id="o<?= $Grid->RowIndex ?>_QUANTITY" value="<?= HtmlEncode($Grid->QUANTITY->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->MEASURE_ID->Visible) { // MEASURE_ID ?>
        <td data-name="MEASURE_ID">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_MEASURE_ID" class="form-group V_TREAT_MEASURE_ID">
<input type="<?= $Grid->MEASURE_ID->getInputTextType() ?>" data-table="V_TREAT" data-field="x_MEASURE_ID" name="x<?= $Grid->RowIndex ?>_MEASURE_ID" id="x<?= $Grid->RowIndex ?>_MEASURE_ID" size="30" placeholder="<?= HtmlEncode($Grid->MEASURE_ID->getPlaceHolder()) ?>" value="<?= $Grid->MEASURE_ID->EditValue ?>"<?= $Grid->MEASURE_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->MEASURE_ID->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_MEASURE_ID" class="form-group V_TREAT_MEASURE_ID">
<span<?= $Grid->MEASURE_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->MEASURE_ID->getDisplayValue($Grid->MEASURE_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_MEASURE_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_MEASURE_ID" id="x<?= $Grid->RowIndex ?>_MEASURE_ID" value="<?= HtmlEncode($Grid->MEASURE_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_MEASURE_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_MEASURE_ID" id="o<?= $Grid->RowIndex ?>_MEASURE_ID" value="<?= HtmlEncode($Grid->MEASURE_ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->DESCRIPTION->Visible) { // DESCRIPTION ?>
        <td data-name="DESCRIPTION">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_DESCRIPTION" class="form-group V_TREAT_DESCRIPTION">
<input type="<?= $Grid->DESCRIPTION->getInputTextType() ?>" data-table="V_TREAT" data-field="x_DESCRIPTION" name="x<?= $Grid->RowIndex ?>_DESCRIPTION" id="x<?= $Grid->RowIndex ?>_DESCRIPTION" size="30" maxlength="200" placeholder="<?= HtmlEncode($Grid->DESCRIPTION->getPlaceHolder()) ?>" value="<?= $Grid->DESCRIPTION->EditValue ?>"<?= $Grid->DESCRIPTION->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->DESCRIPTION->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_DESCRIPTION" class="form-group V_TREAT_DESCRIPTION">
<span<?= $Grid->DESCRIPTION->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->DESCRIPTION->getDisplayValue($Grid->DESCRIPTION->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_DESCRIPTION" data-hidden="1" name="x<?= $Grid->RowIndex ?>_DESCRIPTION" id="x<?= $Grid->RowIndex ?>_DESCRIPTION" value="<?= HtmlEncode($Grid->DESCRIPTION->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_DESCRIPTION" data-hidden="1" name="o<?= $Grid->RowIndex ?>_DESCRIPTION" id="o<?= $Grid->RowIndex ?>_DESCRIPTION" value="<?= HtmlEncode($Grid->DESCRIPTION->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->RESEP_NO->Visible) { // RESEP_NO ?>
        <td data-name="RESEP_NO">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_RESEP_NO" class="form-group V_TREAT_RESEP_NO">
<input type="<?= $Grid->RESEP_NO->getInputTextType() ?>" data-table="V_TREAT" data-field="x_RESEP_NO" name="x<?= $Grid->RowIndex ?>_RESEP_NO" id="x<?= $Grid->RowIndex ?>_RESEP_NO" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->RESEP_NO->getPlaceHolder()) ?>" value="<?= $Grid->RESEP_NO->EditValue ?>"<?= $Grid->RESEP_NO->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->RESEP_NO->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_RESEP_NO" class="form-group V_TREAT_RESEP_NO">
<span<?= $Grid->RESEP_NO->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->RESEP_NO->getDisplayValue($Grid->RESEP_NO->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_RESEP_NO" data-hidden="1" name="x<?= $Grid->RowIndex ?>_RESEP_NO" id="x<?= $Grid->RowIndex ?>_RESEP_NO" value="<?= HtmlEncode($Grid->RESEP_NO->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_RESEP_NO" data-hidden="1" name="o<?= $Grid->RowIndex ?>_RESEP_NO" id="o<?= $Grid->RowIndex ?>_RESEP_NO" value="<?= HtmlEncode($Grid->RESEP_NO->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->DOSE_PRESC->Visible) { // DOSE_PRESC ?>
        <td data-name="DOSE_PRESC">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_DOSE_PRESC" class="form-group V_TREAT_DOSE_PRESC">
<input type="<?= $Grid->DOSE_PRESC->getInputTextType() ?>" data-table="V_TREAT" data-field="x_DOSE_PRESC" name="x<?= $Grid->RowIndex ?>_DOSE_PRESC" id="x<?= $Grid->RowIndex ?>_DOSE_PRESC" size="30" placeholder="<?= HtmlEncode($Grid->DOSE_PRESC->getPlaceHolder()) ?>" value="<?= $Grid->DOSE_PRESC->EditValue ?>"<?= $Grid->DOSE_PRESC->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->DOSE_PRESC->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_DOSE_PRESC" class="form-group V_TREAT_DOSE_PRESC">
<span<?= $Grid->DOSE_PRESC->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->DOSE_PRESC->getDisplayValue($Grid->DOSE_PRESC->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_DOSE_PRESC" data-hidden="1" name="x<?= $Grid->RowIndex ?>_DOSE_PRESC" id="x<?= $Grid->RowIndex ?>_DOSE_PRESC" value="<?= HtmlEncode($Grid->DOSE_PRESC->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_DOSE_PRESC" data-hidden="1" name="o<?= $Grid->RowIndex ?>_DOSE_PRESC" id="o<?= $Grid->RowIndex ?>_DOSE_PRESC" value="<?= HtmlEncode($Grid->DOSE_PRESC->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->SOLD_STATUS->Visible) { // SOLD_STATUS ?>
        <td data-name="SOLD_STATUS">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_SOLD_STATUS" class="form-group V_TREAT_SOLD_STATUS">
<input type="<?= $Grid->SOLD_STATUS->getInputTextType() ?>" data-table="V_TREAT" data-field="x_SOLD_STATUS" name="x<?= $Grid->RowIndex ?>_SOLD_STATUS" id="x<?= $Grid->RowIndex ?>_SOLD_STATUS" size="30" placeholder="<?= HtmlEncode($Grid->SOLD_STATUS->getPlaceHolder()) ?>" value="<?= $Grid->SOLD_STATUS->EditValue ?>"<?= $Grid->SOLD_STATUS->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->SOLD_STATUS->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_SOLD_STATUS" class="form-group V_TREAT_SOLD_STATUS">
<span<?= $Grid->SOLD_STATUS->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->SOLD_STATUS->getDisplayValue($Grid->SOLD_STATUS->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_SOLD_STATUS" data-hidden="1" name="x<?= $Grid->RowIndex ?>_SOLD_STATUS" id="x<?= $Grid->RowIndex ?>_SOLD_STATUS" value="<?= HtmlEncode($Grid->SOLD_STATUS->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_SOLD_STATUS" data-hidden="1" name="o<?= $Grid->RowIndex ?>_SOLD_STATUS" id="o<?= $Grid->RowIndex ?>_SOLD_STATUS" value="<?= HtmlEncode($Grid->SOLD_STATUS->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->RACIKAN->Visible) { // RACIKAN ?>
        <td data-name="RACIKAN">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_RACIKAN" class="form-group V_TREAT_RACIKAN">
<input type="<?= $Grid->RACIKAN->getInputTextType() ?>" data-table="V_TREAT" data-field="x_RACIKAN" name="x<?= $Grid->RowIndex ?>_RACIKAN" id="x<?= $Grid->RowIndex ?>_RACIKAN" size="30" placeholder="<?= HtmlEncode($Grid->RACIKAN->getPlaceHolder()) ?>" value="<?= $Grid->RACIKAN->EditValue ?>"<?= $Grid->RACIKAN->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->RACIKAN->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_RACIKAN" class="form-group V_TREAT_RACIKAN">
<span<?= $Grid->RACIKAN->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->RACIKAN->getDisplayValue($Grid->RACIKAN->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_RACIKAN" data-hidden="1" name="x<?= $Grid->RowIndex ?>_RACIKAN" id="x<?= $Grid->RowIndex ?>_RACIKAN" value="<?= HtmlEncode($Grid->RACIKAN->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_RACIKAN" data-hidden="1" name="o<?= $Grid->RowIndex ?>_RACIKAN" id="o<?= $Grid->RowIndex ?>_RACIKAN" value="<?= HtmlEncode($Grid->RACIKAN->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->CLASS_ROOM_ID->Visible) { // CLASS_ROOM_ID ?>
        <td data-name="CLASS_ROOM_ID">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_CLASS_ROOM_ID" class="form-group V_TREAT_CLASS_ROOM_ID">
<input type="<?= $Grid->CLASS_ROOM_ID->getInputTextType() ?>" data-table="V_TREAT" data-field="x_CLASS_ROOM_ID" name="x<?= $Grid->RowIndex ?>_CLASS_ROOM_ID" id="x<?= $Grid->RowIndex ?>_CLASS_ROOM_ID" size="30" maxlength="16" placeholder="<?= HtmlEncode($Grid->CLASS_ROOM_ID->getPlaceHolder()) ?>" value="<?= $Grid->CLASS_ROOM_ID->EditValue ?>"<?= $Grid->CLASS_ROOM_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->CLASS_ROOM_ID->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_CLASS_ROOM_ID" class="form-group V_TREAT_CLASS_ROOM_ID">
<span<?= $Grid->CLASS_ROOM_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->CLASS_ROOM_ID->getDisplayValue($Grid->CLASS_ROOM_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_CLASS_ROOM_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_CLASS_ROOM_ID" id="x<?= $Grid->RowIndex ?>_CLASS_ROOM_ID" value="<?= HtmlEncode($Grid->CLASS_ROOM_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_CLASS_ROOM_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_CLASS_ROOM_ID" id="o<?= $Grid->RowIndex ?>_CLASS_ROOM_ID" value="<?= HtmlEncode($Grid->CLASS_ROOM_ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->KELUAR_ID->Visible) { // KELUAR_ID ?>
        <td data-name="KELUAR_ID">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_KELUAR_ID" class="form-group V_TREAT_KELUAR_ID">
<input type="<?= $Grid->KELUAR_ID->getInputTextType() ?>" data-table="V_TREAT" data-field="x_KELUAR_ID" name="x<?= $Grid->RowIndex ?>_KELUAR_ID" id="x<?= $Grid->RowIndex ?>_KELUAR_ID" size="30" placeholder="<?= HtmlEncode($Grid->KELUAR_ID->getPlaceHolder()) ?>" value="<?= $Grid->KELUAR_ID->EditValue ?>"<?= $Grid->KELUAR_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->KELUAR_ID->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_KELUAR_ID" class="form-group V_TREAT_KELUAR_ID">
<span<?= $Grid->KELUAR_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->KELUAR_ID->getDisplayValue($Grid->KELUAR_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_KELUAR_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_KELUAR_ID" id="x<?= $Grid->RowIndex ?>_KELUAR_ID" value="<?= HtmlEncode($Grid->KELUAR_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_KELUAR_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_KELUAR_ID" id="o<?= $Grid->RowIndex ?>_KELUAR_ID" value="<?= HtmlEncode($Grid->KELUAR_ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->BED_ID->Visible) { // BED_ID ?>
        <td data-name="BED_ID">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_BED_ID" class="form-group V_TREAT_BED_ID">
<input type="<?= $Grid->BED_ID->getInputTextType() ?>" data-table="V_TREAT" data-field="x_BED_ID" name="x<?= $Grid->RowIndex ?>_BED_ID" id="x<?= $Grid->RowIndex ?>_BED_ID" size="30" placeholder="<?= HtmlEncode($Grid->BED_ID->getPlaceHolder()) ?>" value="<?= $Grid->BED_ID->EditValue ?>"<?= $Grid->BED_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->BED_ID->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_BED_ID" class="form-group V_TREAT_BED_ID">
<span<?= $Grid->BED_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->BED_ID->getDisplayValue($Grid->BED_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_BED_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_BED_ID" id="x<?= $Grid->RowIndex ?>_BED_ID" value="<?= HtmlEncode($Grid->BED_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_BED_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_BED_ID" id="o<?= $Grid->RowIndex ?>_BED_ID" value="<?= HtmlEncode($Grid->BED_ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->EMPLOYEE_ID->Visible) { // EMPLOYEE_ID ?>
        <td data-name="EMPLOYEE_ID">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_EMPLOYEE_ID" class="form-group V_TREAT_EMPLOYEE_ID">
<input type="<?= $Grid->EMPLOYEE_ID->getInputTextType() ?>" data-table="V_TREAT" data-field="x_EMPLOYEE_ID" name="x<?= $Grid->RowIndex ?>_EMPLOYEE_ID" id="x<?= $Grid->RowIndex ?>_EMPLOYEE_ID" size="30" maxlength="15" placeholder="<?= HtmlEncode($Grid->EMPLOYEE_ID->getPlaceHolder()) ?>" value="<?= $Grid->EMPLOYEE_ID->EditValue ?>"<?= $Grid->EMPLOYEE_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->EMPLOYEE_ID->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_EMPLOYEE_ID" class="form-group V_TREAT_EMPLOYEE_ID">
<span<?= $Grid->EMPLOYEE_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->EMPLOYEE_ID->getDisplayValue($Grid->EMPLOYEE_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_EMPLOYEE_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_EMPLOYEE_ID" id="x<?= $Grid->RowIndex ?>_EMPLOYEE_ID" value="<?= HtmlEncode($Grid->EMPLOYEE_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_EMPLOYEE_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_EMPLOYEE_ID" id="o<?= $Grid->RowIndex ?>_EMPLOYEE_ID" value="<?= HtmlEncode($Grid->EMPLOYEE_ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->DESCRIPTION2->Visible) { // DESCRIPTION2 ?>
        <td data-name="DESCRIPTION2">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_DESCRIPTION2" class="form-group V_TREAT_DESCRIPTION2">
<input type="<?= $Grid->DESCRIPTION2->getInputTextType() ?>" data-table="V_TREAT" data-field="x_DESCRIPTION2" name="x<?= $Grid->RowIndex ?>_DESCRIPTION2" id="x<?= $Grid->RowIndex ?>_DESCRIPTION2" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->DESCRIPTION2->getPlaceHolder()) ?>" value="<?= $Grid->DESCRIPTION2->EditValue ?>"<?= $Grid->DESCRIPTION2->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->DESCRIPTION2->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_DESCRIPTION2" class="form-group V_TREAT_DESCRIPTION2">
<span<?= $Grid->DESCRIPTION2->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->DESCRIPTION2->getDisplayValue($Grid->DESCRIPTION2->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_DESCRIPTION2" data-hidden="1" name="x<?= $Grid->RowIndex ?>_DESCRIPTION2" id="x<?= $Grid->RowIndex ?>_DESCRIPTION2" value="<?= HtmlEncode($Grid->DESCRIPTION2->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_DESCRIPTION2" data-hidden="1" name="o<?= $Grid->RowIndex ?>_DESCRIPTION2" id="o<?= $Grid->RowIndex ?>_DESCRIPTION2" value="<?= HtmlEncode($Grid->DESCRIPTION2->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->BRAND_ID->Visible) { // BRAND_ID ?>
        <td data-name="BRAND_ID">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_BRAND_ID" class="form-group V_TREAT_BRAND_ID">
<input type="<?= $Grid->BRAND_ID->getInputTextType() ?>" data-table="V_TREAT" data-field="x_BRAND_ID" name="x<?= $Grid->RowIndex ?>_BRAND_ID" id="x<?= $Grid->RowIndex ?>_BRAND_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->BRAND_ID->getPlaceHolder()) ?>" value="<?= $Grid->BRAND_ID->EditValue ?>"<?= $Grid->BRAND_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->BRAND_ID->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_BRAND_ID" class="form-group V_TREAT_BRAND_ID">
<span<?= $Grid->BRAND_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->BRAND_ID->getDisplayValue($Grid->BRAND_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_BRAND_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_BRAND_ID" id="x<?= $Grid->RowIndex ?>_BRAND_ID" value="<?= HtmlEncode($Grid->BRAND_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_BRAND_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_BRAND_ID" id="o<?= $Grid->RowIndex ?>_BRAND_ID" value="<?= HtmlEncode($Grid->BRAND_ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->DOCTOR->Visible) { // DOCTOR ?>
        <td data-name="DOCTOR">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_DOCTOR" class="form-group V_TREAT_DOCTOR">
<input type="<?= $Grid->DOCTOR->getInputTextType() ?>" data-table="V_TREAT" data-field="x_DOCTOR" name="x<?= $Grid->RowIndex ?>_DOCTOR" id="x<?= $Grid->RowIndex ?>_DOCTOR" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->DOCTOR->getPlaceHolder()) ?>" value="<?= $Grid->DOCTOR->EditValue ?>"<?= $Grid->DOCTOR->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->DOCTOR->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_DOCTOR" class="form-group V_TREAT_DOCTOR">
<span<?= $Grid->DOCTOR->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->DOCTOR->getDisplayValue($Grid->DOCTOR->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_DOCTOR" data-hidden="1" name="x<?= $Grid->RowIndex ?>_DOCTOR" id="x<?= $Grid->RowIndex ?>_DOCTOR" value="<?= HtmlEncode($Grid->DOCTOR->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_DOCTOR" data-hidden="1" name="o<?= $Grid->RowIndex ?>_DOCTOR" id="o<?= $Grid->RowIndex ?>_DOCTOR" value="<?= HtmlEncode($Grid->DOCTOR->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->EXIT_DATE->Visible) { // EXIT_DATE ?>
        <td data-name="EXIT_DATE">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_EXIT_DATE" class="form-group V_TREAT_EXIT_DATE">
<input type="<?= $Grid->EXIT_DATE->getInputTextType() ?>" data-table="V_TREAT" data-field="x_EXIT_DATE" name="x<?= $Grid->RowIndex ?>_EXIT_DATE" id="x<?= $Grid->RowIndex ?>_EXIT_DATE" placeholder="<?= HtmlEncode($Grid->EXIT_DATE->getPlaceHolder()) ?>" value="<?= $Grid->EXIT_DATE->EditValue ?>"<?= $Grid->EXIT_DATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->EXIT_DATE->getErrorMessage() ?></div>
<?php if (!$Grid->EXIT_DATE->ReadOnly && !$Grid->EXIT_DATE->Disabled && !isset($Grid->EXIT_DATE->EditAttrs["readonly"]) && !isset($Grid->EXIT_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fV_TREATgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fV_TREATgrid", "x<?= $Grid->RowIndex ?>_EXIT_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_EXIT_DATE" class="form-group V_TREAT_EXIT_DATE">
<span<?= $Grid->EXIT_DATE->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->EXIT_DATE->getDisplayValue($Grid->EXIT_DATE->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_EXIT_DATE" data-hidden="1" name="x<?= $Grid->RowIndex ?>_EXIT_DATE" id="x<?= $Grid->RowIndex ?>_EXIT_DATE" value="<?= HtmlEncode($Grid->EXIT_DATE->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_EXIT_DATE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_EXIT_DATE" id="o<?= $Grid->RowIndex ?>_EXIT_DATE" value="<?= HtmlEncode($Grid->EXIT_DATE->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->EMPLOYEE_ID_FROM->Visible) { // EMPLOYEE_ID_FROM ?>
        <td data-name="EMPLOYEE_ID_FROM">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_EMPLOYEE_ID_FROM" class="form-group V_TREAT_EMPLOYEE_ID_FROM">
<input type="<?= $Grid->EMPLOYEE_ID_FROM->getInputTextType() ?>" data-table="V_TREAT" data-field="x_EMPLOYEE_ID_FROM" name="x<?= $Grid->RowIndex ?>_EMPLOYEE_ID_FROM" id="x<?= $Grid->RowIndex ?>_EMPLOYEE_ID_FROM" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->EMPLOYEE_ID_FROM->getPlaceHolder()) ?>" value="<?= $Grid->EMPLOYEE_ID_FROM->EditValue ?>"<?= $Grid->EMPLOYEE_ID_FROM->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->EMPLOYEE_ID_FROM->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_EMPLOYEE_ID_FROM" class="form-group V_TREAT_EMPLOYEE_ID_FROM">
<span<?= $Grid->EMPLOYEE_ID_FROM->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->EMPLOYEE_ID_FROM->getDisplayValue($Grid->EMPLOYEE_ID_FROM->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_EMPLOYEE_ID_FROM" data-hidden="1" name="x<?= $Grid->RowIndex ?>_EMPLOYEE_ID_FROM" id="x<?= $Grid->RowIndex ?>_EMPLOYEE_ID_FROM" value="<?= HtmlEncode($Grid->EMPLOYEE_ID_FROM->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_EMPLOYEE_ID_FROM" data-hidden="1" name="o<?= $Grid->RowIndex ?>_EMPLOYEE_ID_FROM" id="o<?= $Grid->RowIndex ?>_EMPLOYEE_ID_FROM" value="<?= HtmlEncode($Grid->EMPLOYEE_ID_FROM->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->DOCTOR_FROM->Visible) { // DOCTOR_FROM ?>
        <td data-name="DOCTOR_FROM">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_DOCTOR_FROM" class="form-group V_TREAT_DOCTOR_FROM">
<input type="<?= $Grid->DOCTOR_FROM->getInputTextType() ?>" data-table="V_TREAT" data-field="x_DOCTOR_FROM" name="x<?= $Grid->RowIndex ?>_DOCTOR_FROM" id="x<?= $Grid->RowIndex ?>_DOCTOR_FROM" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->DOCTOR_FROM->getPlaceHolder()) ?>" value="<?= $Grid->DOCTOR_FROM->EditValue ?>"<?= $Grid->DOCTOR_FROM->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->DOCTOR_FROM->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_DOCTOR_FROM" class="form-group V_TREAT_DOCTOR_FROM">
<span<?= $Grid->DOCTOR_FROM->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->DOCTOR_FROM->getDisplayValue($Grid->DOCTOR_FROM->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_DOCTOR_FROM" data-hidden="1" name="x<?= $Grid->RowIndex ?>_DOCTOR_FROM" id="x<?= $Grid->RowIndex ?>_DOCTOR_FROM" value="<?= HtmlEncode($Grid->DOCTOR_FROM->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_DOCTOR_FROM" data-hidden="1" name="o<?= $Grid->RowIndex ?>_DOCTOR_FROM" id="o<?= $Grid->RowIndex ?>_DOCTOR_FROM" value="<?= HtmlEncode($Grid->DOCTOR_FROM->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->status_pasien_id->Visible) { // status_pasien_id ?>
        <td data-name="status_pasien_id">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_status_pasien_id" class="form-group V_TREAT_status_pasien_id">
<input type="<?= $Grid->status_pasien_id->getInputTextType() ?>" data-table="V_TREAT" data-field="x_status_pasien_id" name="x<?= $Grid->RowIndex ?>_status_pasien_id" id="x<?= $Grid->RowIndex ?>_status_pasien_id" size="30" placeholder="<?= HtmlEncode($Grid->status_pasien_id->getPlaceHolder()) ?>" value="<?= $Grid->status_pasien_id->EditValue ?>"<?= $Grid->status_pasien_id->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->status_pasien_id->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_status_pasien_id" class="form-group V_TREAT_status_pasien_id">
<span<?= $Grid->status_pasien_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->status_pasien_id->getDisplayValue($Grid->status_pasien_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_status_pasien_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_status_pasien_id" id="x<?= $Grid->RowIndex ?>_status_pasien_id" value="<?= HtmlEncode($Grid->status_pasien_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_status_pasien_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_status_pasien_id" id="o<?= $Grid->RowIndex ?>_status_pasien_id" value="<?= HtmlEncode($Grid->status_pasien_id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->THENAME->Visible) { // THENAME ?>
        <td data-name="THENAME">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_THENAME" class="form-group V_TREAT_THENAME">
<input type="<?= $Grid->THENAME->getInputTextType() ?>" data-table="V_TREAT" data-field="x_THENAME" name="x<?= $Grid->RowIndex ?>_THENAME" id="x<?= $Grid->RowIndex ?>_THENAME" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->THENAME->getPlaceHolder()) ?>" value="<?= $Grid->THENAME->EditValue ?>"<?= $Grid->THENAME->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->THENAME->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_THENAME" class="form-group V_TREAT_THENAME">
<span<?= $Grid->THENAME->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->THENAME->getDisplayValue($Grid->THENAME->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_THENAME" data-hidden="1" name="x<?= $Grid->RowIndex ?>_THENAME" id="x<?= $Grid->RowIndex ?>_THENAME" value="<?= HtmlEncode($Grid->THENAME->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_THENAME" data-hidden="1" name="o<?= $Grid->RowIndex ?>_THENAME" id="o<?= $Grid->RowIndex ?>_THENAME" value="<?= HtmlEncode($Grid->THENAME->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->THEADDRESS->Visible) { // THEADDRESS ?>
        <td data-name="THEADDRESS">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_THEADDRESS" class="form-group V_TREAT_THEADDRESS">
<input type="<?= $Grid->THEADDRESS->getInputTextType() ?>" data-table="V_TREAT" data-field="x_THEADDRESS" name="x<?= $Grid->RowIndex ?>_THEADDRESS" id="x<?= $Grid->RowIndex ?>_THEADDRESS" size="30" maxlength="150" placeholder="<?= HtmlEncode($Grid->THEADDRESS->getPlaceHolder()) ?>" value="<?= $Grid->THEADDRESS->EditValue ?>"<?= $Grid->THEADDRESS->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->THEADDRESS->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_THEADDRESS" class="form-group V_TREAT_THEADDRESS">
<span<?= $Grid->THEADDRESS->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->THEADDRESS->getDisplayValue($Grid->THEADDRESS->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_THEADDRESS" data-hidden="1" name="x<?= $Grid->RowIndex ?>_THEADDRESS" id="x<?= $Grid->RowIndex ?>_THEADDRESS" value="<?= HtmlEncode($Grid->THEADDRESS->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_THEADDRESS" data-hidden="1" name="o<?= $Grid->RowIndex ?>_THEADDRESS" id="o<?= $Grid->RowIndex ?>_THEADDRESS" value="<?= HtmlEncode($Grid->THEADDRESS->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->THEID->Visible) { // THEID ?>
        <td data-name="THEID">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_THEID" class="form-group V_TREAT_THEID">
<input type="<?= $Grid->THEID->getInputTextType() ?>" data-table="V_TREAT" data-field="x_THEID" name="x<?= $Grid->RowIndex ?>_THEID" id="x<?= $Grid->RowIndex ?>_THEID" size="30" maxlength="25" placeholder="<?= HtmlEncode($Grid->THEID->getPlaceHolder()) ?>" value="<?= $Grid->THEID->EditValue ?>"<?= $Grid->THEID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->THEID->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_THEID" class="form-group V_TREAT_THEID">
<span<?= $Grid->THEID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->THEID->getDisplayValue($Grid->THEID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_THEID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_THEID" id="x<?= $Grid->RowIndex ?>_THEID" value="<?= HtmlEncode($Grid->THEID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_THEID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_THEID" id="o<?= $Grid->RowIndex ?>_THEID" value="<?= HtmlEncode($Grid->THEID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->SERIAL_NB->Visible) { // SERIAL_NB ?>
        <td data-name="SERIAL_NB">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_SERIAL_NB" class="form-group V_TREAT_SERIAL_NB">
<input type="<?= $Grid->SERIAL_NB->getInputTextType() ?>" data-table="V_TREAT" data-field="x_SERIAL_NB" name="x<?= $Grid->RowIndex ?>_SERIAL_NB" id="x<?= $Grid->RowIndex ?>_SERIAL_NB" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->SERIAL_NB->getPlaceHolder()) ?>" value="<?= $Grid->SERIAL_NB->EditValue ?>"<?= $Grid->SERIAL_NB->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->SERIAL_NB->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_SERIAL_NB" class="form-group V_TREAT_SERIAL_NB">
<span<?= $Grid->SERIAL_NB->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->SERIAL_NB->getDisplayValue($Grid->SERIAL_NB->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_SERIAL_NB" data-hidden="1" name="x<?= $Grid->RowIndex ?>_SERIAL_NB" id="x<?= $Grid->RowIndex ?>_SERIAL_NB" value="<?= HtmlEncode($Grid->SERIAL_NB->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_SERIAL_NB" data-hidden="1" name="o<?= $Grid->RowIndex ?>_SERIAL_NB" id="o<?= $Grid->RowIndex ?>_SERIAL_NB" value="<?= HtmlEncode($Grid->SERIAL_NB->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->ISRJ->Visible) { // ISRJ ?>
        <td data-name="ISRJ">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_ISRJ" class="form-group V_TREAT_ISRJ">
<input type="<?= $Grid->ISRJ->getInputTextType() ?>" data-table="V_TREAT" data-field="x_ISRJ" name="x<?= $Grid->RowIndex ?>_ISRJ" id="x<?= $Grid->RowIndex ?>_ISRJ" size="30" maxlength="1" placeholder="<?= HtmlEncode($Grid->ISRJ->getPlaceHolder()) ?>" value="<?= $Grid->ISRJ->EditValue ?>"<?= $Grid->ISRJ->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ISRJ->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_ISRJ" class="form-group V_TREAT_ISRJ">
<span<?= $Grid->ISRJ->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->ISRJ->getDisplayValue($Grid->ISRJ->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_ISRJ" data-hidden="1" name="x<?= $Grid->RowIndex ?>_ISRJ" id="x<?= $Grid->RowIndex ?>_ISRJ" value="<?= HtmlEncode($Grid->ISRJ->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_ISRJ" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ISRJ" id="o<?= $Grid->RowIndex ?>_ISRJ" value="<?= HtmlEncode($Grid->ISRJ->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->AGEYEAR->Visible) { // AGEYEAR ?>
        <td data-name="AGEYEAR">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_AGEYEAR" class="form-group V_TREAT_AGEYEAR">
<input type="<?= $Grid->AGEYEAR->getInputTextType() ?>" data-table="V_TREAT" data-field="x_AGEYEAR" name="x<?= $Grid->RowIndex ?>_AGEYEAR" id="x<?= $Grid->RowIndex ?>_AGEYEAR" size="30" placeholder="<?= HtmlEncode($Grid->AGEYEAR->getPlaceHolder()) ?>" value="<?= $Grid->AGEYEAR->EditValue ?>"<?= $Grid->AGEYEAR->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->AGEYEAR->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_AGEYEAR" class="form-group V_TREAT_AGEYEAR">
<span<?= $Grid->AGEYEAR->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->AGEYEAR->getDisplayValue($Grid->AGEYEAR->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_AGEYEAR" data-hidden="1" name="x<?= $Grid->RowIndex ?>_AGEYEAR" id="x<?= $Grid->RowIndex ?>_AGEYEAR" value="<?= HtmlEncode($Grid->AGEYEAR->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_AGEYEAR" data-hidden="1" name="o<?= $Grid->RowIndex ?>_AGEYEAR" id="o<?= $Grid->RowIndex ?>_AGEYEAR" value="<?= HtmlEncode($Grid->AGEYEAR->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->AGEMONTH->Visible) { // AGEMONTH ?>
        <td data-name="AGEMONTH">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_AGEMONTH" class="form-group V_TREAT_AGEMONTH">
<input type="<?= $Grid->AGEMONTH->getInputTextType() ?>" data-table="V_TREAT" data-field="x_AGEMONTH" name="x<?= $Grid->RowIndex ?>_AGEMONTH" id="x<?= $Grid->RowIndex ?>_AGEMONTH" size="30" placeholder="<?= HtmlEncode($Grid->AGEMONTH->getPlaceHolder()) ?>" value="<?= $Grid->AGEMONTH->EditValue ?>"<?= $Grid->AGEMONTH->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->AGEMONTH->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_AGEMONTH" class="form-group V_TREAT_AGEMONTH">
<span<?= $Grid->AGEMONTH->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->AGEMONTH->getDisplayValue($Grid->AGEMONTH->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_AGEMONTH" data-hidden="1" name="x<?= $Grid->RowIndex ?>_AGEMONTH" id="x<?= $Grid->RowIndex ?>_AGEMONTH" value="<?= HtmlEncode($Grid->AGEMONTH->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_AGEMONTH" data-hidden="1" name="o<?= $Grid->RowIndex ?>_AGEMONTH" id="o<?= $Grid->RowIndex ?>_AGEMONTH" value="<?= HtmlEncode($Grid->AGEMONTH->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->AGEDAY->Visible) { // AGEDAY ?>
        <td data-name="AGEDAY">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_AGEDAY" class="form-group V_TREAT_AGEDAY">
<input type="<?= $Grid->AGEDAY->getInputTextType() ?>" data-table="V_TREAT" data-field="x_AGEDAY" name="x<?= $Grid->RowIndex ?>_AGEDAY" id="x<?= $Grid->RowIndex ?>_AGEDAY" size="30" placeholder="<?= HtmlEncode($Grid->AGEDAY->getPlaceHolder()) ?>" value="<?= $Grid->AGEDAY->EditValue ?>"<?= $Grid->AGEDAY->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->AGEDAY->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_AGEDAY" class="form-group V_TREAT_AGEDAY">
<span<?= $Grid->AGEDAY->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->AGEDAY->getDisplayValue($Grid->AGEDAY->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_AGEDAY" data-hidden="1" name="x<?= $Grid->RowIndex ?>_AGEDAY" id="x<?= $Grid->RowIndex ?>_AGEDAY" value="<?= HtmlEncode($Grid->AGEDAY->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_AGEDAY" data-hidden="1" name="o<?= $Grid->RowIndex ?>_AGEDAY" id="o<?= $Grid->RowIndex ?>_AGEDAY" value="<?= HtmlEncode($Grid->AGEDAY->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->GENDER->Visible) { // GENDER ?>
        <td data-name="GENDER">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_GENDER" class="form-group V_TREAT_GENDER">
<input type="<?= $Grid->GENDER->getInputTextType() ?>" data-table="V_TREAT" data-field="x_GENDER" name="x<?= $Grid->RowIndex ?>_GENDER" id="x<?= $Grid->RowIndex ?>_GENDER" size="30" maxlength="1" placeholder="<?= HtmlEncode($Grid->GENDER->getPlaceHolder()) ?>" value="<?= $Grid->GENDER->EditValue ?>"<?= $Grid->GENDER->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->GENDER->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_GENDER" class="form-group V_TREAT_GENDER">
<span<?= $Grid->GENDER->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->GENDER->getDisplayValue($Grid->GENDER->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_GENDER" data-hidden="1" name="x<?= $Grid->RowIndex ?>_GENDER" id="x<?= $Grid->RowIndex ?>_GENDER" value="<?= HtmlEncode($Grid->GENDER->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_GENDER" data-hidden="1" name="o<?= $Grid->RowIndex ?>_GENDER" id="o<?= $Grid->RowIndex ?>_GENDER" value="<?= HtmlEncode($Grid->GENDER->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->KARYAWAN->Visible) { // KARYAWAN ?>
        <td data-name="KARYAWAN">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_KARYAWAN" class="form-group V_TREAT_KARYAWAN">
<input type="<?= $Grid->KARYAWAN->getInputTextType() ?>" data-table="V_TREAT" data-field="x_KARYAWAN" name="x<?= $Grid->RowIndex ?>_KARYAWAN" id="x<?= $Grid->RowIndex ?>_KARYAWAN" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->KARYAWAN->getPlaceHolder()) ?>" value="<?= $Grid->KARYAWAN->EditValue ?>"<?= $Grid->KARYAWAN->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->KARYAWAN->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_KARYAWAN" class="form-group V_TREAT_KARYAWAN">
<span<?= $Grid->KARYAWAN->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->KARYAWAN->getDisplayValue($Grid->KARYAWAN->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_KARYAWAN" data-hidden="1" name="x<?= $Grid->RowIndex ?>_KARYAWAN" id="x<?= $Grid->RowIndex ?>_KARYAWAN" value="<?= HtmlEncode($Grid->KARYAWAN->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_KARYAWAN" data-hidden="1" name="o<?= $Grid->RowIndex ?>_KARYAWAN" id="o<?= $Grid->RowIndex ?>_KARYAWAN" value="<?= HtmlEncode($Grid->KARYAWAN->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
        <td data-name="MODIFIED_BY">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_MODIFIED_BY" class="form-group V_TREAT_MODIFIED_BY">
<input type="<?= $Grid->MODIFIED_BY->getInputTextType() ?>" data-table="V_TREAT" data-field="x_MODIFIED_BY" name="x<?= $Grid->RowIndex ?>_MODIFIED_BY" id="x<?= $Grid->RowIndex ?>_MODIFIED_BY" size="30" maxlength="200" placeholder="<?= HtmlEncode($Grid->MODIFIED_BY->getPlaceHolder()) ?>" value="<?= $Grid->MODIFIED_BY->EditValue ?>"<?= $Grid->MODIFIED_BY->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->MODIFIED_BY->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_MODIFIED_BY" class="form-group V_TREAT_MODIFIED_BY">
<span<?= $Grid->MODIFIED_BY->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->MODIFIED_BY->getDisplayValue($Grid->MODIFIED_BY->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_MODIFIED_BY" data-hidden="1" name="x<?= $Grid->RowIndex ?>_MODIFIED_BY" id="x<?= $Grid->RowIndex ?>_MODIFIED_BY" value="<?= HtmlEncode($Grid->MODIFIED_BY->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_MODIFIED_BY" data-hidden="1" name="o<?= $Grid->RowIndex ?>_MODIFIED_BY" id="o<?= $Grid->RowIndex ?>_MODIFIED_BY" value="<?= HtmlEncode($Grid->MODIFIED_BY->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
        <td data-name="MODIFIED_DATE">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_MODIFIED_DATE" class="form-group V_TREAT_MODIFIED_DATE">
<input type="<?= $Grid->MODIFIED_DATE->getInputTextType() ?>" data-table="V_TREAT" data-field="x_MODIFIED_DATE" name="x<?= $Grid->RowIndex ?>_MODIFIED_DATE" id="x<?= $Grid->RowIndex ?>_MODIFIED_DATE" placeholder="<?= HtmlEncode($Grid->MODIFIED_DATE->getPlaceHolder()) ?>" value="<?= $Grid->MODIFIED_DATE->EditValue ?>"<?= $Grid->MODIFIED_DATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->MODIFIED_DATE->getErrorMessage() ?></div>
<?php if (!$Grid->MODIFIED_DATE->ReadOnly && !$Grid->MODIFIED_DATE->Disabled && !isset($Grid->MODIFIED_DATE->EditAttrs["readonly"]) && !isset($Grid->MODIFIED_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fV_TREATgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fV_TREATgrid", "x<?= $Grid->RowIndex ?>_MODIFIED_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_MODIFIED_DATE" class="form-group V_TREAT_MODIFIED_DATE">
<span<?= $Grid->MODIFIED_DATE->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->MODIFIED_DATE->getDisplayValue($Grid->MODIFIED_DATE->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_MODIFIED_DATE" data-hidden="1" name="x<?= $Grid->RowIndex ?>_MODIFIED_DATE" id="x<?= $Grid->RowIndex ?>_MODIFIED_DATE" value="<?= HtmlEncode($Grid->MODIFIED_DATE->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_MODIFIED_DATE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_MODIFIED_DATE" id="o<?= $Grid->RowIndex ?>_MODIFIED_DATE" value="<?= HtmlEncode($Grid->MODIFIED_DATE->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->MODIFIED_FROM->Visible) { // MODIFIED_FROM ?>
        <td data-name="MODIFIED_FROM">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_MODIFIED_FROM" class="form-group V_TREAT_MODIFIED_FROM">
<input type="<?= $Grid->MODIFIED_FROM->getInputTextType() ?>" data-table="V_TREAT" data-field="x_MODIFIED_FROM" name="x<?= $Grid->RowIndex ?>_MODIFIED_FROM" id="x<?= $Grid->RowIndex ?>_MODIFIED_FROM" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->MODIFIED_FROM->getPlaceHolder()) ?>" value="<?= $Grid->MODIFIED_FROM->EditValue ?>"<?= $Grid->MODIFIED_FROM->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->MODIFIED_FROM->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_MODIFIED_FROM" class="form-group V_TREAT_MODIFIED_FROM">
<span<?= $Grid->MODIFIED_FROM->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->MODIFIED_FROM->getDisplayValue($Grid->MODIFIED_FROM->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_MODIFIED_FROM" data-hidden="1" name="x<?= $Grid->RowIndex ?>_MODIFIED_FROM" id="x<?= $Grid->RowIndex ?>_MODIFIED_FROM" value="<?= HtmlEncode($Grid->MODIFIED_FROM->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_MODIFIED_FROM" data-hidden="1" name="o<?= $Grid->RowIndex ?>_MODIFIED_FROM" id="o<?= $Grid->RowIndex ?>_MODIFIED_FROM" value="<?= HtmlEncode($Grid->MODIFIED_FROM->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->NUMER->Visible) { // NUMER ?>
        <td data-name="NUMER">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_NUMER" class="form-group V_TREAT_NUMER">
<input type="<?= $Grid->NUMER->getInputTextType() ?>" data-table="V_TREAT" data-field="x_NUMER" name="x<?= $Grid->RowIndex ?>_NUMER" id="x<?= $Grid->RowIndex ?>_NUMER" size="30" maxlength="15" placeholder="<?= HtmlEncode($Grid->NUMER->getPlaceHolder()) ?>" value="<?= $Grid->NUMER->EditValue ?>"<?= $Grid->NUMER->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->NUMER->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_NUMER" class="form-group V_TREAT_NUMER">
<span<?= $Grid->NUMER->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->NUMER->getDisplayValue($Grid->NUMER->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_NUMER" data-hidden="1" name="x<?= $Grid->RowIndex ?>_NUMER" id="x<?= $Grid->RowIndex ?>_NUMER" value="<?= HtmlEncode($Grid->NUMER->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_NUMER" data-hidden="1" name="o<?= $Grid->RowIndex ?>_NUMER" id="o<?= $Grid->RowIndex ?>_NUMER" value="<?= HtmlEncode($Grid->NUMER->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->NOTA_NO->Visible) { // NOTA_NO ?>
        <td data-name="NOTA_NO">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_NOTA_NO" class="form-group V_TREAT_NOTA_NO">
<input type="<?= $Grid->NOTA_NO->getInputTextType() ?>" data-table="V_TREAT" data-field="x_NOTA_NO" name="x<?= $Grid->RowIndex ?>_NOTA_NO" id="x<?= $Grid->RowIndex ?>_NOTA_NO" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->NOTA_NO->getPlaceHolder()) ?>" value="<?= $Grid->NOTA_NO->EditValue ?>"<?= $Grid->NOTA_NO->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->NOTA_NO->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_NOTA_NO" class="form-group V_TREAT_NOTA_NO">
<span<?= $Grid->NOTA_NO->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->NOTA_NO->getDisplayValue($Grid->NOTA_NO->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_NOTA_NO" data-hidden="1" name="x<?= $Grid->RowIndex ?>_NOTA_NO" id="x<?= $Grid->RowIndex ?>_NOTA_NO" value="<?= HtmlEncode($Grid->NOTA_NO->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_NOTA_NO" data-hidden="1" name="o<?= $Grid->RowIndex ?>_NOTA_NO" id="o<?= $Grid->RowIndex ?>_NOTA_NO" value="<?= HtmlEncode($Grid->NOTA_NO->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->MEASURE_ID2->Visible) { // MEASURE_ID2 ?>
        <td data-name="MEASURE_ID2">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_MEASURE_ID2" class="form-group V_TREAT_MEASURE_ID2">
<input type="<?= $Grid->MEASURE_ID2->getInputTextType() ?>" data-table="V_TREAT" data-field="x_MEASURE_ID2" name="x<?= $Grid->RowIndex ?>_MEASURE_ID2" id="x<?= $Grid->RowIndex ?>_MEASURE_ID2" size="30" placeholder="<?= HtmlEncode($Grid->MEASURE_ID2->getPlaceHolder()) ?>" value="<?= $Grid->MEASURE_ID2->EditValue ?>"<?= $Grid->MEASURE_ID2->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->MEASURE_ID2->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_MEASURE_ID2" class="form-group V_TREAT_MEASURE_ID2">
<span<?= $Grid->MEASURE_ID2->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->MEASURE_ID2->getDisplayValue($Grid->MEASURE_ID2->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_MEASURE_ID2" data-hidden="1" name="x<?= $Grid->RowIndex ?>_MEASURE_ID2" id="x<?= $Grid->RowIndex ?>_MEASURE_ID2" value="<?= HtmlEncode($Grid->MEASURE_ID2->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_MEASURE_ID2" data-hidden="1" name="o<?= $Grid->RowIndex ?>_MEASURE_ID2" id="o<?= $Grid->RowIndex ?>_MEASURE_ID2" value="<?= HtmlEncode($Grid->MEASURE_ID2->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->POTONGAN->Visible) { // POTONGAN ?>
        <td data-name="POTONGAN">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_POTONGAN" class="form-group V_TREAT_POTONGAN">
<input type="<?= $Grid->POTONGAN->getInputTextType() ?>" data-table="V_TREAT" data-field="x_POTONGAN" name="x<?= $Grid->RowIndex ?>_POTONGAN" id="x<?= $Grid->RowIndex ?>_POTONGAN" size="30" placeholder="<?= HtmlEncode($Grid->POTONGAN->getPlaceHolder()) ?>" value="<?= $Grid->POTONGAN->EditValue ?>"<?= $Grid->POTONGAN->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->POTONGAN->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_POTONGAN" class="form-group V_TREAT_POTONGAN">
<span<?= $Grid->POTONGAN->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->POTONGAN->getDisplayValue($Grid->POTONGAN->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_POTONGAN" data-hidden="1" name="x<?= $Grid->RowIndex ?>_POTONGAN" id="x<?= $Grid->RowIndex ?>_POTONGAN" value="<?= HtmlEncode($Grid->POTONGAN->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_POTONGAN" data-hidden="1" name="o<?= $Grid->RowIndex ?>_POTONGAN" id="o<?= $Grid->RowIndex ?>_POTONGAN" value="<?= HtmlEncode($Grid->POTONGAN->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->BAYAR->Visible) { // BAYAR ?>
        <td data-name="BAYAR">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_BAYAR" class="form-group V_TREAT_BAYAR">
<input type="<?= $Grid->BAYAR->getInputTextType() ?>" data-table="V_TREAT" data-field="x_BAYAR" name="x<?= $Grid->RowIndex ?>_BAYAR" id="x<?= $Grid->RowIndex ?>_BAYAR" size="30" placeholder="<?= HtmlEncode($Grid->BAYAR->getPlaceHolder()) ?>" value="<?= $Grid->BAYAR->EditValue ?>"<?= $Grid->BAYAR->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->BAYAR->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_BAYAR" class="form-group V_TREAT_BAYAR">
<span<?= $Grid->BAYAR->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->BAYAR->getDisplayValue($Grid->BAYAR->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_BAYAR" data-hidden="1" name="x<?= $Grid->RowIndex ?>_BAYAR" id="x<?= $Grid->RowIndex ?>_BAYAR" value="<?= HtmlEncode($Grid->BAYAR->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_BAYAR" data-hidden="1" name="o<?= $Grid->RowIndex ?>_BAYAR" id="o<?= $Grid->RowIndex ?>_BAYAR" value="<?= HtmlEncode($Grid->BAYAR->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->RETUR->Visible) { // RETUR ?>
        <td data-name="RETUR">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_RETUR" class="form-group V_TREAT_RETUR">
<input type="<?= $Grid->RETUR->getInputTextType() ?>" data-table="V_TREAT" data-field="x_RETUR" name="x<?= $Grid->RowIndex ?>_RETUR" id="x<?= $Grid->RowIndex ?>_RETUR" size="30" placeholder="<?= HtmlEncode($Grid->RETUR->getPlaceHolder()) ?>" value="<?= $Grid->RETUR->EditValue ?>"<?= $Grid->RETUR->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->RETUR->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_RETUR" class="form-group V_TREAT_RETUR">
<span<?= $Grid->RETUR->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->RETUR->getDisplayValue($Grid->RETUR->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_RETUR" data-hidden="1" name="x<?= $Grid->RowIndex ?>_RETUR" id="x<?= $Grid->RowIndex ?>_RETUR" value="<?= HtmlEncode($Grid->RETUR->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_RETUR" data-hidden="1" name="o<?= $Grid->RowIndex ?>_RETUR" id="o<?= $Grid->RowIndex ?>_RETUR" value="<?= HtmlEncode($Grid->RETUR->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->TARIF_TYPE->Visible) { // TARIF_TYPE ?>
        <td data-name="TARIF_TYPE">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_TARIF_TYPE" class="form-group V_TREAT_TARIF_TYPE">
<input type="<?= $Grid->TARIF_TYPE->getInputTextType() ?>" data-table="V_TREAT" data-field="x_TARIF_TYPE" name="x<?= $Grid->RowIndex ?>_TARIF_TYPE" id="x<?= $Grid->RowIndex ?>_TARIF_TYPE" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->TARIF_TYPE->getPlaceHolder()) ?>" value="<?= $Grid->TARIF_TYPE->EditValue ?>"<?= $Grid->TARIF_TYPE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->TARIF_TYPE->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_TARIF_TYPE" class="form-group V_TREAT_TARIF_TYPE">
<span<?= $Grid->TARIF_TYPE->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->TARIF_TYPE->getDisplayValue($Grid->TARIF_TYPE->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_TARIF_TYPE" data-hidden="1" name="x<?= $Grid->RowIndex ?>_TARIF_TYPE" id="x<?= $Grid->RowIndex ?>_TARIF_TYPE" value="<?= HtmlEncode($Grid->TARIF_TYPE->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_TARIF_TYPE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_TARIF_TYPE" id="o<?= $Grid->RowIndex ?>_TARIF_TYPE" value="<?= HtmlEncode($Grid->TARIF_TYPE->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->PPNVALUE->Visible) { // PPNVALUE ?>
        <td data-name="PPNVALUE">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_PPNVALUE" class="form-group V_TREAT_PPNVALUE">
<input type="<?= $Grid->PPNVALUE->getInputTextType() ?>" data-table="V_TREAT" data-field="x_PPNVALUE" name="x<?= $Grid->RowIndex ?>_PPNVALUE" id="x<?= $Grid->RowIndex ?>_PPNVALUE" size="30" placeholder="<?= HtmlEncode($Grid->PPNVALUE->getPlaceHolder()) ?>" value="<?= $Grid->PPNVALUE->EditValue ?>"<?= $Grid->PPNVALUE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->PPNVALUE->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_PPNVALUE" class="form-group V_TREAT_PPNVALUE">
<span<?= $Grid->PPNVALUE->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->PPNVALUE->getDisplayValue($Grid->PPNVALUE->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_PPNVALUE" data-hidden="1" name="x<?= $Grid->RowIndex ?>_PPNVALUE" id="x<?= $Grid->RowIndex ?>_PPNVALUE" value="<?= HtmlEncode($Grid->PPNVALUE->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_PPNVALUE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_PPNVALUE" id="o<?= $Grid->RowIndex ?>_PPNVALUE" value="<?= HtmlEncode($Grid->PPNVALUE->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->TAGIHAN->Visible) { // TAGIHAN ?>
        <td data-name="TAGIHAN">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_TAGIHAN" class="form-group V_TREAT_TAGIHAN">
<input type="<?= $Grid->TAGIHAN->getInputTextType() ?>" data-table="V_TREAT" data-field="x_TAGIHAN" name="x<?= $Grid->RowIndex ?>_TAGIHAN" id="x<?= $Grid->RowIndex ?>_TAGIHAN" size="30" placeholder="<?= HtmlEncode($Grid->TAGIHAN->getPlaceHolder()) ?>" value="<?= $Grid->TAGIHAN->EditValue ?>"<?= $Grid->TAGIHAN->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->TAGIHAN->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_TAGIHAN" class="form-group V_TREAT_TAGIHAN">
<span<?= $Grid->TAGIHAN->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->TAGIHAN->getDisplayValue($Grid->TAGIHAN->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_TAGIHAN" data-hidden="1" name="x<?= $Grid->RowIndex ?>_TAGIHAN" id="x<?= $Grid->RowIndex ?>_TAGIHAN" value="<?= HtmlEncode($Grid->TAGIHAN->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_TAGIHAN" data-hidden="1" name="o<?= $Grid->RowIndex ?>_TAGIHAN" id="o<?= $Grid->RowIndex ?>_TAGIHAN" value="<?= HtmlEncode($Grid->TAGIHAN->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->KOREKSI->Visible) { // KOREKSI ?>
        <td data-name="KOREKSI">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_KOREKSI" class="form-group V_TREAT_KOREKSI">
<input type="<?= $Grid->KOREKSI->getInputTextType() ?>" data-table="V_TREAT" data-field="x_KOREKSI" name="x<?= $Grid->RowIndex ?>_KOREKSI" id="x<?= $Grid->RowIndex ?>_KOREKSI" size="30" placeholder="<?= HtmlEncode($Grid->KOREKSI->getPlaceHolder()) ?>" value="<?= $Grid->KOREKSI->EditValue ?>"<?= $Grid->KOREKSI->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->KOREKSI->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_KOREKSI" class="form-group V_TREAT_KOREKSI">
<span<?= $Grid->KOREKSI->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->KOREKSI->getDisplayValue($Grid->KOREKSI->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_KOREKSI" data-hidden="1" name="x<?= $Grid->RowIndex ?>_KOREKSI" id="x<?= $Grid->RowIndex ?>_KOREKSI" value="<?= HtmlEncode($Grid->KOREKSI->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_KOREKSI" data-hidden="1" name="o<?= $Grid->RowIndex ?>_KOREKSI" id="o<?= $Grid->RowIndex ?>_KOREKSI" value="<?= HtmlEncode($Grid->KOREKSI->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->AMOUNT_PAID->Visible) { // AMOUNT_PAID ?>
        <td data-name="AMOUNT_PAID">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_AMOUNT_PAID" class="form-group V_TREAT_AMOUNT_PAID">
<input type="<?= $Grid->AMOUNT_PAID->getInputTextType() ?>" data-table="V_TREAT" data-field="x_AMOUNT_PAID" name="x<?= $Grid->RowIndex ?>_AMOUNT_PAID" id="x<?= $Grid->RowIndex ?>_AMOUNT_PAID" size="30" placeholder="<?= HtmlEncode($Grid->AMOUNT_PAID->getPlaceHolder()) ?>" value="<?= $Grid->AMOUNT_PAID->EditValue ?>"<?= $Grid->AMOUNT_PAID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->AMOUNT_PAID->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_AMOUNT_PAID" class="form-group V_TREAT_AMOUNT_PAID">
<span<?= $Grid->AMOUNT_PAID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->AMOUNT_PAID->getDisplayValue($Grid->AMOUNT_PAID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_AMOUNT_PAID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_AMOUNT_PAID" id="x<?= $Grid->RowIndex ?>_AMOUNT_PAID" value="<?= HtmlEncode($Grid->AMOUNT_PAID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_AMOUNT_PAID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_AMOUNT_PAID" id="o<?= $Grid->RowIndex ?>_AMOUNT_PAID" value="<?= HtmlEncode($Grid->AMOUNT_PAID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->DISKON->Visible) { // DISKON ?>
        <td data-name="DISKON">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_DISKON" class="form-group V_TREAT_DISKON">
<input type="<?= $Grid->DISKON->getInputTextType() ?>" data-table="V_TREAT" data-field="x_DISKON" name="x<?= $Grid->RowIndex ?>_DISKON" id="x<?= $Grid->RowIndex ?>_DISKON" size="30" placeholder="<?= HtmlEncode($Grid->DISKON->getPlaceHolder()) ?>" value="<?= $Grid->DISKON->EditValue ?>"<?= $Grid->DISKON->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->DISKON->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_DISKON" class="form-group V_TREAT_DISKON">
<span<?= $Grid->DISKON->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->DISKON->getDisplayValue($Grid->DISKON->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_DISKON" data-hidden="1" name="x<?= $Grid->RowIndex ?>_DISKON" id="x<?= $Grid->RowIndex ?>_DISKON" value="<?= HtmlEncode($Grid->DISKON->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_DISKON" data-hidden="1" name="o<?= $Grid->RowIndex ?>_DISKON" id="o<?= $Grid->RowIndex ?>_DISKON" value="<?= HtmlEncode($Grid->DISKON->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->SELL_PRICE->Visible) { // SELL_PRICE ?>
        <td data-name="SELL_PRICE">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_SELL_PRICE" class="form-group V_TREAT_SELL_PRICE">
<input type="<?= $Grid->SELL_PRICE->getInputTextType() ?>" data-table="V_TREAT" data-field="x_SELL_PRICE" name="x<?= $Grid->RowIndex ?>_SELL_PRICE" id="x<?= $Grid->RowIndex ?>_SELL_PRICE" size="30" placeholder="<?= HtmlEncode($Grid->SELL_PRICE->getPlaceHolder()) ?>" value="<?= $Grid->SELL_PRICE->EditValue ?>"<?= $Grid->SELL_PRICE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->SELL_PRICE->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_SELL_PRICE" class="form-group V_TREAT_SELL_PRICE">
<span<?= $Grid->SELL_PRICE->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->SELL_PRICE->getDisplayValue($Grid->SELL_PRICE->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_SELL_PRICE" data-hidden="1" name="x<?= $Grid->RowIndex ?>_SELL_PRICE" id="x<?= $Grid->RowIndex ?>_SELL_PRICE" value="<?= HtmlEncode($Grid->SELL_PRICE->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_SELL_PRICE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_SELL_PRICE" id="o<?= $Grid->RowIndex ?>_SELL_PRICE" value="<?= HtmlEncode($Grid->SELL_PRICE->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->ACCOUNT_ID->Visible) { // ACCOUNT_ID ?>
        <td data-name="ACCOUNT_ID">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_ACCOUNT_ID" class="form-group V_TREAT_ACCOUNT_ID">
<input type="<?= $Grid->ACCOUNT_ID->getInputTextType() ?>" data-table="V_TREAT" data-field="x_ACCOUNT_ID" name="x<?= $Grid->RowIndex ?>_ACCOUNT_ID" id="x<?= $Grid->RowIndex ?>_ACCOUNT_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->ACCOUNT_ID->getPlaceHolder()) ?>" value="<?= $Grid->ACCOUNT_ID->EditValue ?>"<?= $Grid->ACCOUNT_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ACCOUNT_ID->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_ACCOUNT_ID" class="form-group V_TREAT_ACCOUNT_ID">
<span<?= $Grid->ACCOUNT_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->ACCOUNT_ID->getDisplayValue($Grid->ACCOUNT_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_ACCOUNT_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_ACCOUNT_ID" id="x<?= $Grid->RowIndex ?>_ACCOUNT_ID" value="<?= HtmlEncode($Grid->ACCOUNT_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_ACCOUNT_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ACCOUNT_ID" id="o<?= $Grid->RowIndex ?>_ACCOUNT_ID" value="<?= HtmlEncode($Grid->ACCOUNT_ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->subsidi->Visible) { // subsidi ?>
        <td data-name="subsidi">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_subsidi" class="form-group V_TREAT_subsidi">
<input type="<?= $Grid->subsidi->getInputTextType() ?>" data-table="V_TREAT" data-field="x_subsidi" name="x<?= $Grid->RowIndex ?>_subsidi" id="x<?= $Grid->RowIndex ?>_subsidi" size="30" placeholder="<?= HtmlEncode($Grid->subsidi->getPlaceHolder()) ?>" value="<?= $Grid->subsidi->EditValue ?>"<?= $Grid->subsidi->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->subsidi->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_subsidi" class="form-group V_TREAT_subsidi">
<span<?= $Grid->subsidi->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->subsidi->getDisplayValue($Grid->subsidi->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_subsidi" data-hidden="1" name="x<?= $Grid->RowIndex ?>_subsidi" id="x<?= $Grid->RowIndex ?>_subsidi" value="<?= HtmlEncode($Grid->subsidi->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_subsidi" data-hidden="1" name="o<?= $Grid->RowIndex ?>_subsidi" id="o<?= $Grid->RowIndex ?>_subsidi" value="<?= HtmlEncode($Grid->subsidi->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->PROFESI->Visible) { // PROFESI ?>
        <td data-name="PROFESI">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_PROFESI" class="form-group V_TREAT_PROFESI">
<input type="<?= $Grid->PROFESI->getInputTextType() ?>" data-table="V_TREAT" data-field="x_PROFESI" name="x<?= $Grid->RowIndex ?>_PROFESI" id="x<?= $Grid->RowIndex ?>_PROFESI" size="30" placeholder="<?= HtmlEncode($Grid->PROFESI->getPlaceHolder()) ?>" value="<?= $Grid->PROFESI->EditValue ?>"<?= $Grid->PROFESI->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->PROFESI->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_PROFESI" class="form-group V_TREAT_PROFESI">
<span<?= $Grid->PROFESI->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->PROFESI->getDisplayValue($Grid->PROFESI->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_PROFESI" data-hidden="1" name="x<?= $Grid->RowIndex ?>_PROFESI" id="x<?= $Grid->RowIndex ?>_PROFESI" value="<?= HtmlEncode($Grid->PROFESI->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_PROFESI" data-hidden="1" name="o<?= $Grid->RowIndex ?>_PROFESI" id="o<?= $Grid->RowIndex ?>_PROFESI" value="<?= HtmlEncode($Grid->PROFESI->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->EMBALACE->Visible) { // EMBALACE ?>
        <td data-name="EMBALACE">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_EMBALACE" class="form-group V_TREAT_EMBALACE">
<input type="<?= $Grid->EMBALACE->getInputTextType() ?>" data-table="V_TREAT" data-field="x_EMBALACE" name="x<?= $Grid->RowIndex ?>_EMBALACE" id="x<?= $Grid->RowIndex ?>_EMBALACE" size="30" placeholder="<?= HtmlEncode($Grid->EMBALACE->getPlaceHolder()) ?>" value="<?= $Grid->EMBALACE->EditValue ?>"<?= $Grid->EMBALACE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->EMBALACE->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_EMBALACE" class="form-group V_TREAT_EMBALACE">
<span<?= $Grid->EMBALACE->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->EMBALACE->getDisplayValue($Grid->EMBALACE->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_EMBALACE" data-hidden="1" name="x<?= $Grid->RowIndex ?>_EMBALACE" id="x<?= $Grid->RowIndex ?>_EMBALACE" value="<?= HtmlEncode($Grid->EMBALACE->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_EMBALACE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_EMBALACE" id="o<?= $Grid->RowIndex ?>_EMBALACE" value="<?= HtmlEncode($Grid->EMBALACE->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->DISCOUNT->Visible) { // DISCOUNT ?>
        <td data-name="DISCOUNT">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_DISCOUNT" class="form-group V_TREAT_DISCOUNT">
<input type="<?= $Grid->DISCOUNT->getInputTextType() ?>" data-table="V_TREAT" data-field="x_DISCOUNT" name="x<?= $Grid->RowIndex ?>_DISCOUNT" id="x<?= $Grid->RowIndex ?>_DISCOUNT" size="30" placeholder="<?= HtmlEncode($Grid->DISCOUNT->getPlaceHolder()) ?>" value="<?= $Grid->DISCOUNT->EditValue ?>"<?= $Grid->DISCOUNT->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->DISCOUNT->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_DISCOUNT" class="form-group V_TREAT_DISCOUNT">
<span<?= $Grid->DISCOUNT->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->DISCOUNT->getDisplayValue($Grid->DISCOUNT->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_DISCOUNT" data-hidden="1" name="x<?= $Grid->RowIndex ?>_DISCOUNT" id="x<?= $Grid->RowIndex ?>_DISCOUNT" value="<?= HtmlEncode($Grid->DISCOUNT->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_DISCOUNT" data-hidden="1" name="o<?= $Grid->RowIndex ?>_DISCOUNT" id="o<?= $Grid->RowIndex ?>_DISCOUNT" value="<?= HtmlEncode($Grid->DISCOUNT->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->AMOUNT->Visible) { // AMOUNT ?>
        <td data-name="AMOUNT">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_AMOUNT" class="form-group V_TREAT_AMOUNT">
<input type="<?= $Grid->AMOUNT->getInputTextType() ?>" data-table="V_TREAT" data-field="x_AMOUNT" name="x<?= $Grid->RowIndex ?>_AMOUNT" id="x<?= $Grid->RowIndex ?>_AMOUNT" size="30" placeholder="<?= HtmlEncode($Grid->AMOUNT->getPlaceHolder()) ?>" value="<?= $Grid->AMOUNT->EditValue ?>"<?= $Grid->AMOUNT->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->AMOUNT->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_AMOUNT" class="form-group V_TREAT_AMOUNT">
<span<?= $Grid->AMOUNT->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->AMOUNT->getDisplayValue($Grid->AMOUNT->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_AMOUNT" data-hidden="1" name="x<?= $Grid->RowIndex ?>_AMOUNT" id="x<?= $Grid->RowIndex ?>_AMOUNT" value="<?= HtmlEncode($Grid->AMOUNT->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_AMOUNT" data-hidden="1" name="o<?= $Grid->RowIndex ?>_AMOUNT" id="o<?= $Grid->RowIndex ?>_AMOUNT" value="<?= HtmlEncode($Grid->AMOUNT->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->PPN->Visible) { // PPN ?>
        <td data-name="PPN">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_PPN" class="form-group V_TREAT_PPN">
<input type="<?= $Grid->PPN->getInputTextType() ?>" data-table="V_TREAT" data-field="x_PPN" name="x<?= $Grid->RowIndex ?>_PPN" id="x<?= $Grid->RowIndex ?>_PPN" size="30" placeholder="<?= HtmlEncode($Grid->PPN->getPlaceHolder()) ?>" value="<?= $Grid->PPN->EditValue ?>"<?= $Grid->PPN->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->PPN->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_PPN" class="form-group V_TREAT_PPN">
<span<?= $Grid->PPN->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->PPN->getDisplayValue($Grid->PPN->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_PPN" data-hidden="1" name="x<?= $Grid->RowIndex ?>_PPN" id="x<?= $Grid->RowIndex ?>_PPN" value="<?= HtmlEncode($Grid->PPN->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_PPN" data-hidden="1" name="o<?= $Grid->RowIndex ?>_PPN" id="o<?= $Grid->RowIndex ?>_PPN" value="<?= HtmlEncode($Grid->PPN->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->ITER->Visible) { // ITER ?>
        <td data-name="ITER">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_ITER" class="form-group V_TREAT_ITER">
<input type="<?= $Grid->ITER->getInputTextType() ?>" data-table="V_TREAT" data-field="x_ITER" name="x<?= $Grid->RowIndex ?>_ITER" id="x<?= $Grid->RowIndex ?>_ITER" size="30" placeholder="<?= HtmlEncode($Grid->ITER->getPlaceHolder()) ?>" value="<?= $Grid->ITER->EditValue ?>"<?= $Grid->ITER->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ITER->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_ITER" class="form-group V_TREAT_ITER">
<span<?= $Grid->ITER->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->ITER->getDisplayValue($Grid->ITER->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_ITER" data-hidden="1" name="x<?= $Grid->RowIndex ?>_ITER" id="x<?= $Grid->RowIndex ?>_ITER" value="<?= HtmlEncode($Grid->ITER->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_ITER" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ITER" id="o<?= $Grid->RowIndex ?>_ITER" value="<?= HtmlEncode($Grid->ITER->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->PAYOR_ID->Visible) { // PAYOR_ID ?>
        <td data-name="PAYOR_ID">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_PAYOR_ID" class="form-group V_TREAT_PAYOR_ID">
<input type="<?= $Grid->PAYOR_ID->getInputTextType() ?>" data-table="V_TREAT" data-field="x_PAYOR_ID" name="x<?= $Grid->RowIndex ?>_PAYOR_ID" id="x<?= $Grid->RowIndex ?>_PAYOR_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->PAYOR_ID->getPlaceHolder()) ?>" value="<?= $Grid->PAYOR_ID->EditValue ?>"<?= $Grid->PAYOR_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->PAYOR_ID->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_PAYOR_ID" class="form-group V_TREAT_PAYOR_ID">
<span<?= $Grid->PAYOR_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->PAYOR_ID->getDisplayValue($Grid->PAYOR_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_PAYOR_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_PAYOR_ID" id="x<?= $Grid->RowIndex ?>_PAYOR_ID" value="<?= HtmlEncode($Grid->PAYOR_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_PAYOR_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_PAYOR_ID" id="o<?= $Grid->RowIndex ?>_PAYOR_ID" value="<?= HtmlEncode($Grid->PAYOR_ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->STATUS_OBAT->Visible) { // STATUS_OBAT ?>
        <td data-name="STATUS_OBAT">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_STATUS_OBAT" class="form-group V_TREAT_STATUS_OBAT">
<input type="<?= $Grid->STATUS_OBAT->getInputTextType() ?>" data-table="V_TREAT" data-field="x_STATUS_OBAT" name="x<?= $Grid->RowIndex ?>_STATUS_OBAT" id="x<?= $Grid->RowIndex ?>_STATUS_OBAT" size="30" placeholder="<?= HtmlEncode($Grid->STATUS_OBAT->getPlaceHolder()) ?>" value="<?= $Grid->STATUS_OBAT->EditValue ?>"<?= $Grid->STATUS_OBAT->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->STATUS_OBAT->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_STATUS_OBAT" class="form-group V_TREAT_STATUS_OBAT">
<span<?= $Grid->STATUS_OBAT->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->STATUS_OBAT->getDisplayValue($Grid->STATUS_OBAT->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_STATUS_OBAT" data-hidden="1" name="x<?= $Grid->RowIndex ?>_STATUS_OBAT" id="x<?= $Grid->RowIndex ?>_STATUS_OBAT" value="<?= HtmlEncode($Grid->STATUS_OBAT->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_STATUS_OBAT" data-hidden="1" name="o<?= $Grid->RowIndex ?>_STATUS_OBAT" id="o<?= $Grid->RowIndex ?>_STATUS_OBAT" value="<?= HtmlEncode($Grid->STATUS_OBAT->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->SUBSIDISAT->Visible) { // SUBSIDISAT ?>
        <td data-name="SUBSIDISAT">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_SUBSIDISAT" class="form-group V_TREAT_SUBSIDISAT">
<input type="<?= $Grid->SUBSIDISAT->getInputTextType() ?>" data-table="V_TREAT" data-field="x_SUBSIDISAT" name="x<?= $Grid->RowIndex ?>_SUBSIDISAT" id="x<?= $Grid->RowIndex ?>_SUBSIDISAT" size="30" placeholder="<?= HtmlEncode($Grid->SUBSIDISAT->getPlaceHolder()) ?>" value="<?= $Grid->SUBSIDISAT->EditValue ?>"<?= $Grid->SUBSIDISAT->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->SUBSIDISAT->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_SUBSIDISAT" class="form-group V_TREAT_SUBSIDISAT">
<span<?= $Grid->SUBSIDISAT->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->SUBSIDISAT->getDisplayValue($Grid->SUBSIDISAT->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_SUBSIDISAT" data-hidden="1" name="x<?= $Grid->RowIndex ?>_SUBSIDISAT" id="x<?= $Grid->RowIndex ?>_SUBSIDISAT" value="<?= HtmlEncode($Grid->SUBSIDISAT->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_SUBSIDISAT" data-hidden="1" name="o<?= $Grid->RowIndex ?>_SUBSIDISAT" id="o<?= $Grid->RowIndex ?>_SUBSIDISAT" value="<?= HtmlEncode($Grid->SUBSIDISAT->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->MARGIN->Visible) { // MARGIN ?>
        <td data-name="MARGIN">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_MARGIN" class="form-group V_TREAT_MARGIN">
<input type="<?= $Grid->MARGIN->getInputTextType() ?>" data-table="V_TREAT" data-field="x_MARGIN" name="x<?= $Grid->RowIndex ?>_MARGIN" id="x<?= $Grid->RowIndex ?>_MARGIN" size="30" placeholder="<?= HtmlEncode($Grid->MARGIN->getPlaceHolder()) ?>" value="<?= $Grid->MARGIN->EditValue ?>"<?= $Grid->MARGIN->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->MARGIN->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_MARGIN" class="form-group V_TREAT_MARGIN">
<span<?= $Grid->MARGIN->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->MARGIN->getDisplayValue($Grid->MARGIN->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_MARGIN" data-hidden="1" name="x<?= $Grid->RowIndex ?>_MARGIN" id="x<?= $Grid->RowIndex ?>_MARGIN" value="<?= HtmlEncode($Grid->MARGIN->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_MARGIN" data-hidden="1" name="o<?= $Grid->RowIndex ?>_MARGIN" id="o<?= $Grid->RowIndex ?>_MARGIN" value="<?= HtmlEncode($Grid->MARGIN->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->POKOK_JUAL->Visible) { // POKOK_JUAL ?>
        <td data-name="POKOK_JUAL">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_POKOK_JUAL" class="form-group V_TREAT_POKOK_JUAL">
<input type="<?= $Grid->POKOK_JUAL->getInputTextType() ?>" data-table="V_TREAT" data-field="x_POKOK_JUAL" name="x<?= $Grid->RowIndex ?>_POKOK_JUAL" id="x<?= $Grid->RowIndex ?>_POKOK_JUAL" size="30" placeholder="<?= HtmlEncode($Grid->POKOK_JUAL->getPlaceHolder()) ?>" value="<?= $Grid->POKOK_JUAL->EditValue ?>"<?= $Grid->POKOK_JUAL->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->POKOK_JUAL->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_POKOK_JUAL" class="form-group V_TREAT_POKOK_JUAL">
<span<?= $Grid->POKOK_JUAL->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->POKOK_JUAL->getDisplayValue($Grid->POKOK_JUAL->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_POKOK_JUAL" data-hidden="1" name="x<?= $Grid->RowIndex ?>_POKOK_JUAL" id="x<?= $Grid->RowIndex ?>_POKOK_JUAL" value="<?= HtmlEncode($Grid->POKOK_JUAL->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_POKOK_JUAL" data-hidden="1" name="o<?= $Grid->RowIndex ?>_POKOK_JUAL" id="o<?= $Grid->RowIndex ?>_POKOK_JUAL" value="<?= HtmlEncode($Grid->POKOK_JUAL->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->PRINTQ->Visible) { // PRINTQ ?>
        <td data-name="PRINTQ">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_PRINTQ" class="form-group V_TREAT_PRINTQ">
<input type="<?= $Grid->PRINTQ->getInputTextType() ?>" data-table="V_TREAT" data-field="x_PRINTQ" name="x<?= $Grid->RowIndex ?>_PRINTQ" id="x<?= $Grid->RowIndex ?>_PRINTQ" size="30" placeholder="<?= HtmlEncode($Grid->PRINTQ->getPlaceHolder()) ?>" value="<?= $Grid->PRINTQ->EditValue ?>"<?= $Grid->PRINTQ->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->PRINTQ->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_PRINTQ" class="form-group V_TREAT_PRINTQ">
<span<?= $Grid->PRINTQ->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->PRINTQ->getDisplayValue($Grid->PRINTQ->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_PRINTQ" data-hidden="1" name="x<?= $Grid->RowIndex ?>_PRINTQ" id="x<?= $Grid->RowIndex ?>_PRINTQ" value="<?= HtmlEncode($Grid->PRINTQ->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_PRINTQ" data-hidden="1" name="o<?= $Grid->RowIndex ?>_PRINTQ" id="o<?= $Grid->RowIndex ?>_PRINTQ" value="<?= HtmlEncode($Grid->PRINTQ->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->PRINTED_BY->Visible) { // PRINTED_BY ?>
        <td data-name="PRINTED_BY">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_PRINTED_BY" class="form-group V_TREAT_PRINTED_BY">
<input type="<?= $Grid->PRINTED_BY->getInputTextType() ?>" data-table="V_TREAT" data-field="x_PRINTED_BY" name="x<?= $Grid->RowIndex ?>_PRINTED_BY" id="x<?= $Grid->RowIndex ?>_PRINTED_BY" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->PRINTED_BY->getPlaceHolder()) ?>" value="<?= $Grid->PRINTED_BY->EditValue ?>"<?= $Grid->PRINTED_BY->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->PRINTED_BY->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_PRINTED_BY" class="form-group V_TREAT_PRINTED_BY">
<span<?= $Grid->PRINTED_BY->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->PRINTED_BY->getDisplayValue($Grid->PRINTED_BY->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_PRINTED_BY" data-hidden="1" name="x<?= $Grid->RowIndex ?>_PRINTED_BY" id="x<?= $Grid->RowIndex ?>_PRINTED_BY" value="<?= HtmlEncode($Grid->PRINTED_BY->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_PRINTED_BY" data-hidden="1" name="o<?= $Grid->RowIndex ?>_PRINTED_BY" id="o<?= $Grid->RowIndex ?>_PRINTED_BY" value="<?= HtmlEncode($Grid->PRINTED_BY->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->STOCK_AVAILABLE->Visible) { // STOCK_AVAILABLE ?>
        <td data-name="STOCK_AVAILABLE">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_STOCK_AVAILABLE" class="form-group V_TREAT_STOCK_AVAILABLE">
<input type="<?= $Grid->STOCK_AVAILABLE->getInputTextType() ?>" data-table="V_TREAT" data-field="x_STOCK_AVAILABLE" name="x<?= $Grid->RowIndex ?>_STOCK_AVAILABLE" id="x<?= $Grid->RowIndex ?>_STOCK_AVAILABLE" size="30" placeholder="<?= HtmlEncode($Grid->STOCK_AVAILABLE->getPlaceHolder()) ?>" value="<?= $Grid->STOCK_AVAILABLE->EditValue ?>"<?= $Grid->STOCK_AVAILABLE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->STOCK_AVAILABLE->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_STOCK_AVAILABLE" class="form-group V_TREAT_STOCK_AVAILABLE">
<span<?= $Grid->STOCK_AVAILABLE->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->STOCK_AVAILABLE->getDisplayValue($Grid->STOCK_AVAILABLE->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_STOCK_AVAILABLE" data-hidden="1" name="x<?= $Grid->RowIndex ?>_STOCK_AVAILABLE" id="x<?= $Grid->RowIndex ?>_STOCK_AVAILABLE" value="<?= HtmlEncode($Grid->STOCK_AVAILABLE->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_STOCK_AVAILABLE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_STOCK_AVAILABLE" id="o<?= $Grid->RowIndex ?>_STOCK_AVAILABLE" value="<?= HtmlEncode($Grid->STOCK_AVAILABLE->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->STATUS_TARIF->Visible) { // STATUS_TARIF ?>
        <td data-name="STATUS_TARIF">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_STATUS_TARIF" class="form-group V_TREAT_STATUS_TARIF">
<input type="<?= $Grid->STATUS_TARIF->getInputTextType() ?>" data-table="V_TREAT" data-field="x_STATUS_TARIF" name="x<?= $Grid->RowIndex ?>_STATUS_TARIF" id="x<?= $Grid->RowIndex ?>_STATUS_TARIF" size="30" placeholder="<?= HtmlEncode($Grid->STATUS_TARIF->getPlaceHolder()) ?>" value="<?= $Grid->STATUS_TARIF->EditValue ?>"<?= $Grid->STATUS_TARIF->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->STATUS_TARIF->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_STATUS_TARIF" class="form-group V_TREAT_STATUS_TARIF">
<span<?= $Grid->STATUS_TARIF->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->STATUS_TARIF->getDisplayValue($Grid->STATUS_TARIF->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_STATUS_TARIF" data-hidden="1" name="x<?= $Grid->RowIndex ?>_STATUS_TARIF" id="x<?= $Grid->RowIndex ?>_STATUS_TARIF" value="<?= HtmlEncode($Grid->STATUS_TARIF->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_STATUS_TARIF" data-hidden="1" name="o<?= $Grid->RowIndex ?>_STATUS_TARIF" id="o<?= $Grid->RowIndex ?>_STATUS_TARIF" value="<?= HtmlEncode($Grid->STATUS_TARIF->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->PACKAGE_ID->Visible) { // PACKAGE_ID ?>
        <td data-name="PACKAGE_ID">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_PACKAGE_ID" class="form-group V_TREAT_PACKAGE_ID">
<input type="<?= $Grid->PACKAGE_ID->getInputTextType() ?>" data-table="V_TREAT" data-field="x_PACKAGE_ID" name="x<?= $Grid->RowIndex ?>_PACKAGE_ID" id="x<?= $Grid->RowIndex ?>_PACKAGE_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->PACKAGE_ID->getPlaceHolder()) ?>" value="<?= $Grid->PACKAGE_ID->EditValue ?>"<?= $Grid->PACKAGE_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->PACKAGE_ID->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_PACKAGE_ID" class="form-group V_TREAT_PACKAGE_ID">
<span<?= $Grid->PACKAGE_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->PACKAGE_ID->getDisplayValue($Grid->PACKAGE_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_PACKAGE_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_PACKAGE_ID" id="x<?= $Grid->RowIndex ?>_PACKAGE_ID" value="<?= HtmlEncode($Grid->PACKAGE_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_PACKAGE_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_PACKAGE_ID" id="o<?= $Grid->RowIndex ?>_PACKAGE_ID" value="<?= HtmlEncode($Grid->PACKAGE_ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->MODULE_ID->Visible) { // MODULE_ID ?>
        <td data-name="MODULE_ID">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_MODULE_ID" class="form-group V_TREAT_MODULE_ID">
<input type="<?= $Grid->MODULE_ID->getInputTextType() ?>" data-table="V_TREAT" data-field="x_MODULE_ID" name="x<?= $Grid->RowIndex ?>_MODULE_ID" id="x<?= $Grid->RowIndex ?>_MODULE_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->MODULE_ID->getPlaceHolder()) ?>" value="<?= $Grid->MODULE_ID->EditValue ?>"<?= $Grid->MODULE_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->MODULE_ID->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_MODULE_ID" class="form-group V_TREAT_MODULE_ID">
<span<?= $Grid->MODULE_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->MODULE_ID->getDisplayValue($Grid->MODULE_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_MODULE_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_MODULE_ID" id="x<?= $Grid->RowIndex ?>_MODULE_ID" value="<?= HtmlEncode($Grid->MODULE_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_MODULE_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_MODULE_ID" id="o<?= $Grid->RowIndex ?>_MODULE_ID" value="<?= HtmlEncode($Grid->MODULE_ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->profession->Visible) { // profession ?>
        <td data-name="profession">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_profession" class="form-group V_TREAT_profession">
<input type="<?= $Grid->profession->getInputTextType() ?>" data-table="V_TREAT" data-field="x_profession" name="x<?= $Grid->RowIndex ?>_profession" id="x<?= $Grid->RowIndex ?>_profession" size="30" placeholder="<?= HtmlEncode($Grid->profession->getPlaceHolder()) ?>" value="<?= $Grid->profession->EditValue ?>"<?= $Grid->profession->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->profession->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_profession" class="form-group V_TREAT_profession">
<span<?= $Grid->profession->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->profession->getDisplayValue($Grid->profession->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_profession" data-hidden="1" name="x<?= $Grid->RowIndex ?>_profession" id="x<?= $Grid->RowIndex ?>_profession" value="<?= HtmlEncode($Grid->profession->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_profession" data-hidden="1" name="o<?= $Grid->RowIndex ?>_profession" id="o<?= $Grid->RowIndex ?>_profession" value="<?= HtmlEncode($Grid->profession->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->THEORDER->Visible) { // THEORDER ?>
        <td data-name="THEORDER">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_THEORDER" class="form-group V_TREAT_THEORDER">
<input type="<?= $Grid->THEORDER->getInputTextType() ?>" data-table="V_TREAT" data-field="x_THEORDER" name="x<?= $Grid->RowIndex ?>_THEORDER" id="x<?= $Grid->RowIndex ?>_THEORDER" size="30" placeholder="<?= HtmlEncode($Grid->THEORDER->getPlaceHolder()) ?>" value="<?= $Grid->THEORDER->EditValue ?>"<?= $Grid->THEORDER->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->THEORDER->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_THEORDER" class="form-group V_TREAT_THEORDER">
<span<?= $Grid->THEORDER->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->THEORDER->getDisplayValue($Grid->THEORDER->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_THEORDER" data-hidden="1" name="x<?= $Grid->RowIndex ?>_THEORDER" id="x<?= $Grid->RowIndex ?>_THEORDER" value="<?= HtmlEncode($Grid->THEORDER->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_THEORDER" data-hidden="1" name="o<?= $Grid->RowIndex ?>_THEORDER" id="o<?= $Grid->RowIndex ?>_THEORDER" value="<?= HtmlEncode($Grid->THEORDER->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->CORRECTION_ID->Visible) { // CORRECTION_ID ?>
        <td data-name="CORRECTION_ID">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_CORRECTION_ID" class="form-group V_TREAT_CORRECTION_ID">
<input type="<?= $Grid->CORRECTION_ID->getInputTextType() ?>" data-table="V_TREAT" data-field="x_CORRECTION_ID" name="x<?= $Grid->RowIndex ?>_CORRECTION_ID" id="x<?= $Grid->RowIndex ?>_CORRECTION_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->CORRECTION_ID->getPlaceHolder()) ?>" value="<?= $Grid->CORRECTION_ID->EditValue ?>"<?= $Grid->CORRECTION_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->CORRECTION_ID->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_CORRECTION_ID" class="form-group V_TREAT_CORRECTION_ID">
<span<?= $Grid->CORRECTION_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->CORRECTION_ID->getDisplayValue($Grid->CORRECTION_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_CORRECTION_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_CORRECTION_ID" id="x<?= $Grid->RowIndex ?>_CORRECTION_ID" value="<?= HtmlEncode($Grid->CORRECTION_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_CORRECTION_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_CORRECTION_ID" id="o<?= $Grid->RowIndex ?>_CORRECTION_ID" value="<?= HtmlEncode($Grid->CORRECTION_ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->CORRECTION_BY->Visible) { // CORRECTION_BY ?>
        <td data-name="CORRECTION_BY">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_CORRECTION_BY" class="form-group V_TREAT_CORRECTION_BY">
<input type="<?= $Grid->CORRECTION_BY->getInputTextType() ?>" data-table="V_TREAT" data-field="x_CORRECTION_BY" name="x<?= $Grid->RowIndex ?>_CORRECTION_BY" id="x<?= $Grid->RowIndex ?>_CORRECTION_BY" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->CORRECTION_BY->getPlaceHolder()) ?>" value="<?= $Grid->CORRECTION_BY->EditValue ?>"<?= $Grid->CORRECTION_BY->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->CORRECTION_BY->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_CORRECTION_BY" class="form-group V_TREAT_CORRECTION_BY">
<span<?= $Grid->CORRECTION_BY->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->CORRECTION_BY->getDisplayValue($Grid->CORRECTION_BY->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_CORRECTION_BY" data-hidden="1" name="x<?= $Grid->RowIndex ?>_CORRECTION_BY" id="x<?= $Grid->RowIndex ?>_CORRECTION_BY" value="<?= HtmlEncode($Grid->CORRECTION_BY->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_CORRECTION_BY" data-hidden="1" name="o<?= $Grid->RowIndex ?>_CORRECTION_BY" id="o<?= $Grid->RowIndex ?>_CORRECTION_BY" value="<?= HtmlEncode($Grid->CORRECTION_BY->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->CASHIER->Visible) { // CASHIER ?>
        <td data-name="CASHIER">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_CASHIER" class="form-group V_TREAT_CASHIER">
<input type="<?= $Grid->CASHIER->getInputTextType() ?>" data-table="V_TREAT" data-field="x_CASHIER" name="x<?= $Grid->RowIndex ?>_CASHIER" id="x<?= $Grid->RowIndex ?>_CASHIER" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->CASHIER->getPlaceHolder()) ?>" value="<?= $Grid->CASHIER->EditValue ?>"<?= $Grid->CASHIER->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->CASHIER->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_CASHIER" class="form-group V_TREAT_CASHIER">
<span<?= $Grid->CASHIER->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->CASHIER->getDisplayValue($Grid->CASHIER->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_CASHIER" data-hidden="1" name="x<?= $Grid->RowIndex ?>_CASHIER" id="x<?= $Grid->RowIndex ?>_CASHIER" value="<?= HtmlEncode($Grid->CASHIER->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_CASHIER" data-hidden="1" name="o<?= $Grid->RowIndex ?>_CASHIER" id="o<?= $Grid->RowIndex ?>_CASHIER" value="<?= HtmlEncode($Grid->CASHIER->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->islunas->Visible) { // islunas ?>
        <td data-name="islunas">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_islunas" class="form-group V_TREAT_islunas">
<input type="<?= $Grid->islunas->getInputTextType() ?>" data-table="V_TREAT" data-field="x_islunas" name="x<?= $Grid->RowIndex ?>_islunas" id="x<?= $Grid->RowIndex ?>_islunas" size="30" maxlength="1" placeholder="<?= HtmlEncode($Grid->islunas->getPlaceHolder()) ?>" value="<?= $Grid->islunas->EditValue ?>"<?= $Grid->islunas->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->islunas->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_islunas" class="form-group V_TREAT_islunas">
<span<?= $Grid->islunas->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->islunas->getDisplayValue($Grid->islunas->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_islunas" data-hidden="1" name="x<?= $Grid->RowIndex ?>_islunas" id="x<?= $Grid->RowIndex ?>_islunas" value="<?= HtmlEncode($Grid->islunas->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_islunas" data-hidden="1" name="o<?= $Grid->RowIndex ?>_islunas" id="o<?= $Grid->RowIndex ?>_islunas" value="<?= HtmlEncode($Grid->islunas->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->PAY_METHOD_ID->Visible) { // PAY_METHOD_ID ?>
        <td data-name="PAY_METHOD_ID">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_PAY_METHOD_ID" class="form-group V_TREAT_PAY_METHOD_ID">
<input type="<?= $Grid->PAY_METHOD_ID->getInputTextType() ?>" data-table="V_TREAT" data-field="x_PAY_METHOD_ID" name="x<?= $Grid->RowIndex ?>_PAY_METHOD_ID" id="x<?= $Grid->RowIndex ?>_PAY_METHOD_ID" size="30" placeholder="<?= HtmlEncode($Grid->PAY_METHOD_ID->getPlaceHolder()) ?>" value="<?= $Grid->PAY_METHOD_ID->EditValue ?>"<?= $Grid->PAY_METHOD_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->PAY_METHOD_ID->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_PAY_METHOD_ID" class="form-group V_TREAT_PAY_METHOD_ID">
<span<?= $Grid->PAY_METHOD_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->PAY_METHOD_ID->getDisplayValue($Grid->PAY_METHOD_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_PAY_METHOD_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_PAY_METHOD_ID" id="x<?= $Grid->RowIndex ?>_PAY_METHOD_ID" value="<?= HtmlEncode($Grid->PAY_METHOD_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_PAY_METHOD_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_PAY_METHOD_ID" id="o<?= $Grid->RowIndex ?>_PAY_METHOD_ID" value="<?= HtmlEncode($Grid->PAY_METHOD_ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->PAYMENT_DATE->Visible) { // PAYMENT_DATE ?>
        <td data-name="PAYMENT_DATE">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_PAYMENT_DATE" class="form-group V_TREAT_PAYMENT_DATE">
<input type="<?= $Grid->PAYMENT_DATE->getInputTextType() ?>" data-table="V_TREAT" data-field="x_PAYMENT_DATE" name="x<?= $Grid->RowIndex ?>_PAYMENT_DATE" id="x<?= $Grid->RowIndex ?>_PAYMENT_DATE" placeholder="<?= HtmlEncode($Grid->PAYMENT_DATE->getPlaceHolder()) ?>" value="<?= $Grid->PAYMENT_DATE->EditValue ?>"<?= $Grid->PAYMENT_DATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->PAYMENT_DATE->getErrorMessage() ?></div>
<?php if (!$Grid->PAYMENT_DATE->ReadOnly && !$Grid->PAYMENT_DATE->Disabled && !isset($Grid->PAYMENT_DATE->EditAttrs["readonly"]) && !isset($Grid->PAYMENT_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fV_TREATgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fV_TREATgrid", "x<?= $Grid->RowIndex ?>_PAYMENT_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_PAYMENT_DATE" class="form-group V_TREAT_PAYMENT_DATE">
<span<?= $Grid->PAYMENT_DATE->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->PAYMENT_DATE->getDisplayValue($Grid->PAYMENT_DATE->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_PAYMENT_DATE" data-hidden="1" name="x<?= $Grid->RowIndex ?>_PAYMENT_DATE" id="x<?= $Grid->RowIndex ?>_PAYMENT_DATE" value="<?= HtmlEncode($Grid->PAYMENT_DATE->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_PAYMENT_DATE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_PAYMENT_DATE" id="o<?= $Grid->RowIndex ?>_PAYMENT_DATE" value="<?= HtmlEncode($Grid->PAYMENT_DATE->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->ISCETAK->Visible) { // ISCETAK ?>
        <td data-name="ISCETAK">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_ISCETAK" class="form-group V_TREAT_ISCETAK">
<input type="<?= $Grid->ISCETAK->getInputTextType() ?>" data-table="V_TREAT" data-field="x_ISCETAK" name="x<?= $Grid->RowIndex ?>_ISCETAK" id="x<?= $Grid->RowIndex ?>_ISCETAK" size="30" maxlength="1" placeholder="<?= HtmlEncode($Grid->ISCETAK->getPlaceHolder()) ?>" value="<?= $Grid->ISCETAK->EditValue ?>"<?= $Grid->ISCETAK->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ISCETAK->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_ISCETAK" class="form-group V_TREAT_ISCETAK">
<span<?= $Grid->ISCETAK->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->ISCETAK->getDisplayValue($Grid->ISCETAK->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_ISCETAK" data-hidden="1" name="x<?= $Grid->RowIndex ?>_ISCETAK" id="x<?= $Grid->RowIndex ?>_ISCETAK" value="<?= HtmlEncode($Grid->ISCETAK->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_ISCETAK" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ISCETAK" id="o<?= $Grid->RowIndex ?>_ISCETAK" value="<?= HtmlEncode($Grid->ISCETAK->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->print_date->Visible) { // print_date ?>
        <td data-name="print_date">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_print_date" class="form-group V_TREAT_print_date">
<input type="<?= $Grid->print_date->getInputTextType() ?>" data-table="V_TREAT" data-field="x_print_date" name="x<?= $Grid->RowIndex ?>_print_date" id="x<?= $Grid->RowIndex ?>_print_date" placeholder="<?= HtmlEncode($Grid->print_date->getPlaceHolder()) ?>" value="<?= $Grid->print_date->EditValue ?>"<?= $Grid->print_date->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->print_date->getErrorMessage() ?></div>
<?php if (!$Grid->print_date->ReadOnly && !$Grid->print_date->Disabled && !isset($Grid->print_date->EditAttrs["readonly"]) && !isset($Grid->print_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fV_TREATgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fV_TREATgrid", "x<?= $Grid->RowIndex ?>_print_date", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_print_date" class="form-group V_TREAT_print_date">
<span<?= $Grid->print_date->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->print_date->getDisplayValue($Grid->print_date->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_print_date" data-hidden="1" name="x<?= $Grid->RowIndex ?>_print_date" id="x<?= $Grid->RowIndex ?>_print_date" value="<?= HtmlEncode($Grid->print_date->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_print_date" data-hidden="1" name="o<?= $Grid->RowIndex ?>_print_date" id="o<?= $Grid->RowIndex ?>_print_date" value="<?= HtmlEncode($Grid->print_date->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->DOSE->Visible) { // DOSE ?>
        <td data-name="DOSE">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_DOSE" class="form-group V_TREAT_DOSE">
<input type="<?= $Grid->DOSE->getInputTextType() ?>" data-table="V_TREAT" data-field="x_DOSE" name="x<?= $Grid->RowIndex ?>_DOSE" id="x<?= $Grid->RowIndex ?>_DOSE" size="30" placeholder="<?= HtmlEncode($Grid->DOSE->getPlaceHolder()) ?>" value="<?= $Grid->DOSE->EditValue ?>"<?= $Grid->DOSE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->DOSE->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_DOSE" class="form-group V_TREAT_DOSE">
<span<?= $Grid->DOSE->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->DOSE->getDisplayValue($Grid->DOSE->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_DOSE" data-hidden="1" name="x<?= $Grid->RowIndex ?>_DOSE" id="x<?= $Grid->RowIndex ?>_DOSE" value="<?= HtmlEncode($Grid->DOSE->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_DOSE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_DOSE" id="o<?= $Grid->RowIndex ?>_DOSE" value="<?= HtmlEncode($Grid->DOSE->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->JML_BKS->Visible) { // JML_BKS ?>
        <td data-name="JML_BKS">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_JML_BKS" class="form-group V_TREAT_JML_BKS">
<input type="<?= $Grid->JML_BKS->getInputTextType() ?>" data-table="V_TREAT" data-field="x_JML_BKS" name="x<?= $Grid->RowIndex ?>_JML_BKS" id="x<?= $Grid->RowIndex ?>_JML_BKS" size="30" placeholder="<?= HtmlEncode($Grid->JML_BKS->getPlaceHolder()) ?>" value="<?= $Grid->JML_BKS->EditValue ?>"<?= $Grid->JML_BKS->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->JML_BKS->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_JML_BKS" class="form-group V_TREAT_JML_BKS">
<span<?= $Grid->JML_BKS->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->JML_BKS->getDisplayValue($Grid->JML_BKS->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_JML_BKS" data-hidden="1" name="x<?= $Grid->RowIndex ?>_JML_BKS" id="x<?= $Grid->RowIndex ?>_JML_BKS" value="<?= HtmlEncode($Grid->JML_BKS->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_JML_BKS" data-hidden="1" name="o<?= $Grid->RowIndex ?>_JML_BKS" id="o<?= $Grid->RowIndex ?>_JML_BKS" value="<?= HtmlEncode($Grid->JML_BKS->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->ORIG_DOSE->Visible) { // ORIG_DOSE ?>
        <td data-name="ORIG_DOSE">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_ORIG_DOSE" class="form-group V_TREAT_ORIG_DOSE">
<input type="<?= $Grid->ORIG_DOSE->getInputTextType() ?>" data-table="V_TREAT" data-field="x_ORIG_DOSE" name="x<?= $Grid->RowIndex ?>_ORIG_DOSE" id="x<?= $Grid->RowIndex ?>_ORIG_DOSE" size="30" placeholder="<?= HtmlEncode($Grid->ORIG_DOSE->getPlaceHolder()) ?>" value="<?= $Grid->ORIG_DOSE->EditValue ?>"<?= $Grid->ORIG_DOSE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ORIG_DOSE->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_ORIG_DOSE" class="form-group V_TREAT_ORIG_DOSE">
<span<?= $Grid->ORIG_DOSE->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->ORIG_DOSE->getDisplayValue($Grid->ORIG_DOSE->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_ORIG_DOSE" data-hidden="1" name="x<?= $Grid->RowIndex ?>_ORIG_DOSE" id="x<?= $Grid->RowIndex ?>_ORIG_DOSE" value="<?= HtmlEncode($Grid->ORIG_DOSE->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_ORIG_DOSE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ORIG_DOSE" id="o<?= $Grid->RowIndex ?>_ORIG_DOSE" value="<?= HtmlEncode($Grid->ORIG_DOSE->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->RESEP_KE->Visible) { // RESEP_KE ?>
        <td data-name="RESEP_KE">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_RESEP_KE" class="form-group V_TREAT_RESEP_KE">
<input type="<?= $Grid->RESEP_KE->getInputTextType() ?>" data-table="V_TREAT" data-field="x_RESEP_KE" name="x<?= $Grid->RowIndex ?>_RESEP_KE" id="x<?= $Grid->RowIndex ?>_RESEP_KE" size="30" placeholder="<?= HtmlEncode($Grid->RESEP_KE->getPlaceHolder()) ?>" value="<?= $Grid->RESEP_KE->EditValue ?>"<?= $Grid->RESEP_KE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->RESEP_KE->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_RESEP_KE" class="form-group V_TREAT_RESEP_KE">
<span<?= $Grid->RESEP_KE->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->RESEP_KE->getDisplayValue($Grid->RESEP_KE->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_RESEP_KE" data-hidden="1" name="x<?= $Grid->RowIndex ?>_RESEP_KE" id="x<?= $Grid->RowIndex ?>_RESEP_KE" value="<?= HtmlEncode($Grid->RESEP_KE->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_RESEP_KE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_RESEP_KE" id="o<?= $Grid->RowIndex ?>_RESEP_KE" value="<?= HtmlEncode($Grid->RESEP_KE->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->ITER_KE->Visible) { // ITER_KE ?>
        <td data-name="ITER_KE">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_ITER_KE" class="form-group V_TREAT_ITER_KE">
<input type="<?= $Grid->ITER_KE->getInputTextType() ?>" data-table="V_TREAT" data-field="x_ITER_KE" name="x<?= $Grid->RowIndex ?>_ITER_KE" id="x<?= $Grid->RowIndex ?>_ITER_KE" size="30" placeholder="<?= HtmlEncode($Grid->ITER_KE->getPlaceHolder()) ?>" value="<?= $Grid->ITER_KE->EditValue ?>"<?= $Grid->ITER_KE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ITER_KE->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_ITER_KE" class="form-group V_TREAT_ITER_KE">
<span<?= $Grid->ITER_KE->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->ITER_KE->getDisplayValue($Grid->ITER_KE->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_ITER_KE" data-hidden="1" name="x<?= $Grid->RowIndex ?>_ITER_KE" id="x<?= $Grid->RowIndex ?>_ITER_KE" value="<?= HtmlEncode($Grid->ITER_KE->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_ITER_KE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ITER_KE" id="o<?= $Grid->RowIndex ?>_ITER_KE" value="<?= HtmlEncode($Grid->ITER_KE->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->KUITANSI_ID->Visible) { // KUITANSI_ID ?>
        <td data-name="KUITANSI_ID">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_KUITANSI_ID" class="form-group V_TREAT_KUITANSI_ID">
<input type="<?= $Grid->KUITANSI_ID->getInputTextType() ?>" data-table="V_TREAT" data-field="x_KUITANSI_ID" name="x<?= $Grid->RowIndex ?>_KUITANSI_ID" id="x<?= $Grid->RowIndex ?>_KUITANSI_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->KUITANSI_ID->getPlaceHolder()) ?>" value="<?= $Grid->KUITANSI_ID->EditValue ?>"<?= $Grid->KUITANSI_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->KUITANSI_ID->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_KUITANSI_ID" class="form-group V_TREAT_KUITANSI_ID">
<span<?= $Grid->KUITANSI_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->KUITANSI_ID->getDisplayValue($Grid->KUITANSI_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_KUITANSI_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_KUITANSI_ID" id="x<?= $Grid->RowIndex ?>_KUITANSI_ID" value="<?= HtmlEncode($Grid->KUITANSI_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_KUITANSI_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_KUITANSI_ID" id="o<?= $Grid->RowIndex ?>_KUITANSI_ID" value="<?= HtmlEncode($Grid->KUITANSI_ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->PEMBULATAN->Visible) { // PEMBULATAN ?>
        <td data-name="PEMBULATAN">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_PEMBULATAN" class="form-group V_TREAT_PEMBULATAN">
<input type="<?= $Grid->PEMBULATAN->getInputTextType() ?>" data-table="V_TREAT" data-field="x_PEMBULATAN" name="x<?= $Grid->RowIndex ?>_PEMBULATAN" id="x<?= $Grid->RowIndex ?>_PEMBULATAN" size="30" placeholder="<?= HtmlEncode($Grid->PEMBULATAN->getPlaceHolder()) ?>" value="<?= $Grid->PEMBULATAN->EditValue ?>"<?= $Grid->PEMBULATAN->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->PEMBULATAN->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_PEMBULATAN" class="form-group V_TREAT_PEMBULATAN">
<span<?= $Grid->PEMBULATAN->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->PEMBULATAN->getDisplayValue($Grid->PEMBULATAN->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_PEMBULATAN" data-hidden="1" name="x<?= $Grid->RowIndex ?>_PEMBULATAN" id="x<?= $Grid->RowIndex ?>_PEMBULATAN" value="<?= HtmlEncode($Grid->PEMBULATAN->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_PEMBULATAN" data-hidden="1" name="o<?= $Grid->RowIndex ?>_PEMBULATAN" id="o<?= $Grid->RowIndex ?>_PEMBULATAN" value="<?= HtmlEncode($Grid->PEMBULATAN->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->KAL_ID->Visible) { // KAL_ID ?>
        <td data-name="KAL_ID">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_KAL_ID" class="form-group V_TREAT_KAL_ID">
<input type="<?= $Grid->KAL_ID->getInputTextType() ?>" data-table="V_TREAT" data-field="x_KAL_ID" name="x<?= $Grid->RowIndex ?>_KAL_ID" id="x<?= $Grid->RowIndex ?>_KAL_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->KAL_ID->getPlaceHolder()) ?>" value="<?= $Grid->KAL_ID->EditValue ?>"<?= $Grid->KAL_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->KAL_ID->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_KAL_ID" class="form-group V_TREAT_KAL_ID">
<span<?= $Grid->KAL_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->KAL_ID->getDisplayValue($Grid->KAL_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_KAL_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_KAL_ID" id="x<?= $Grid->RowIndex ?>_KAL_ID" value="<?= HtmlEncode($Grid->KAL_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_KAL_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_KAL_ID" id="o<?= $Grid->RowIndex ?>_KAL_ID" value="<?= HtmlEncode($Grid->KAL_ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->INVOICE_ID->Visible) { // INVOICE_ID ?>
        <td data-name="INVOICE_ID">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_INVOICE_ID" class="form-group V_TREAT_INVOICE_ID">
<input type="<?= $Grid->INVOICE_ID->getInputTextType() ?>" data-table="V_TREAT" data-field="x_INVOICE_ID" name="x<?= $Grid->RowIndex ?>_INVOICE_ID" id="x<?= $Grid->RowIndex ?>_INVOICE_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->INVOICE_ID->getPlaceHolder()) ?>" value="<?= $Grid->INVOICE_ID->EditValue ?>"<?= $Grid->INVOICE_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->INVOICE_ID->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_INVOICE_ID" class="form-group V_TREAT_INVOICE_ID">
<span<?= $Grid->INVOICE_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->INVOICE_ID->getDisplayValue($Grid->INVOICE_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_INVOICE_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_INVOICE_ID" id="x<?= $Grid->RowIndex ?>_INVOICE_ID" value="<?= HtmlEncode($Grid->INVOICE_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_INVOICE_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_INVOICE_ID" id="o<?= $Grid->RowIndex ?>_INVOICE_ID" value="<?= HtmlEncode($Grid->INVOICE_ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->SERVICE_TIME->Visible) { // SERVICE_TIME ?>
        <td data-name="SERVICE_TIME">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_SERVICE_TIME" class="form-group V_TREAT_SERVICE_TIME">
<input type="<?= $Grid->SERVICE_TIME->getInputTextType() ?>" data-table="V_TREAT" data-field="x_SERVICE_TIME" name="x<?= $Grid->RowIndex ?>_SERVICE_TIME" id="x<?= $Grid->RowIndex ?>_SERVICE_TIME" placeholder="<?= HtmlEncode($Grid->SERVICE_TIME->getPlaceHolder()) ?>" value="<?= $Grid->SERVICE_TIME->EditValue ?>"<?= $Grid->SERVICE_TIME->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->SERVICE_TIME->getErrorMessage() ?></div>
<?php if (!$Grid->SERVICE_TIME->ReadOnly && !$Grid->SERVICE_TIME->Disabled && !isset($Grid->SERVICE_TIME->EditAttrs["readonly"]) && !isset($Grid->SERVICE_TIME->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fV_TREATgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fV_TREATgrid", "x<?= $Grid->RowIndex ?>_SERVICE_TIME", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_SERVICE_TIME" class="form-group V_TREAT_SERVICE_TIME">
<span<?= $Grid->SERVICE_TIME->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->SERVICE_TIME->getDisplayValue($Grid->SERVICE_TIME->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_SERVICE_TIME" data-hidden="1" name="x<?= $Grid->RowIndex ?>_SERVICE_TIME" id="x<?= $Grid->RowIndex ?>_SERVICE_TIME" value="<?= HtmlEncode($Grid->SERVICE_TIME->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_SERVICE_TIME" data-hidden="1" name="o<?= $Grid->RowIndex ?>_SERVICE_TIME" id="o<?= $Grid->RowIndex ?>_SERVICE_TIME" value="<?= HtmlEncode($Grid->SERVICE_TIME->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->TAKEN_TIME->Visible) { // TAKEN_TIME ?>
        <td data-name="TAKEN_TIME">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_TAKEN_TIME" class="form-group V_TREAT_TAKEN_TIME">
<input type="<?= $Grid->TAKEN_TIME->getInputTextType() ?>" data-table="V_TREAT" data-field="x_TAKEN_TIME" name="x<?= $Grid->RowIndex ?>_TAKEN_TIME" id="x<?= $Grid->RowIndex ?>_TAKEN_TIME" placeholder="<?= HtmlEncode($Grid->TAKEN_TIME->getPlaceHolder()) ?>" value="<?= $Grid->TAKEN_TIME->EditValue ?>"<?= $Grid->TAKEN_TIME->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->TAKEN_TIME->getErrorMessage() ?></div>
<?php if (!$Grid->TAKEN_TIME->ReadOnly && !$Grid->TAKEN_TIME->Disabled && !isset($Grid->TAKEN_TIME->EditAttrs["readonly"]) && !isset($Grid->TAKEN_TIME->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fV_TREATgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fV_TREATgrid", "x<?= $Grid->RowIndex ?>_TAKEN_TIME", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_TAKEN_TIME" class="form-group V_TREAT_TAKEN_TIME">
<span<?= $Grid->TAKEN_TIME->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->TAKEN_TIME->getDisplayValue($Grid->TAKEN_TIME->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_TAKEN_TIME" data-hidden="1" name="x<?= $Grid->RowIndex ?>_TAKEN_TIME" id="x<?= $Grid->RowIndex ?>_TAKEN_TIME" value="<?= HtmlEncode($Grid->TAKEN_TIME->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_TAKEN_TIME" data-hidden="1" name="o<?= $Grid->RowIndex ?>_TAKEN_TIME" id="o<?= $Grid->RowIndex ?>_TAKEN_TIME" value="<?= HtmlEncode($Grid->TAKEN_TIME->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->modified_datesys->Visible) { // modified_datesys ?>
        <td data-name="modified_datesys">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_modified_datesys" class="form-group V_TREAT_modified_datesys">
<input type="<?= $Grid->modified_datesys->getInputTextType() ?>" data-table="V_TREAT" data-field="x_modified_datesys" name="x<?= $Grid->RowIndex ?>_modified_datesys" id="x<?= $Grid->RowIndex ?>_modified_datesys" placeholder="<?= HtmlEncode($Grid->modified_datesys->getPlaceHolder()) ?>" value="<?= $Grid->modified_datesys->EditValue ?>"<?= $Grid->modified_datesys->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->modified_datesys->getErrorMessage() ?></div>
<?php if (!$Grid->modified_datesys->ReadOnly && !$Grid->modified_datesys->Disabled && !isset($Grid->modified_datesys->EditAttrs["readonly"]) && !isset($Grid->modified_datesys->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fV_TREATgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fV_TREATgrid", "x<?= $Grid->RowIndex ?>_modified_datesys", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_modified_datesys" class="form-group V_TREAT_modified_datesys">
<span<?= $Grid->modified_datesys->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->modified_datesys->getDisplayValue($Grid->modified_datesys->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_modified_datesys" data-hidden="1" name="x<?= $Grid->RowIndex ?>_modified_datesys" id="x<?= $Grid->RowIndex ?>_modified_datesys" value="<?= HtmlEncode($Grid->modified_datesys->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_modified_datesys" data-hidden="1" name="o<?= $Grid->RowIndex ?>_modified_datesys" id="o<?= $Grid->RowIndex ?>_modified_datesys" value="<?= HtmlEncode($Grid->modified_datesys->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->TRANS_ID->Visible) { // TRANS_ID ?>
        <td data-name="TRANS_ID">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_TRANS_ID" class="form-group V_TREAT_TRANS_ID">
<input type="<?= $Grid->TRANS_ID->getInputTextType() ?>" data-table="V_TREAT" data-field="x_TRANS_ID" name="x<?= $Grid->RowIndex ?>_TRANS_ID" id="x<?= $Grid->RowIndex ?>_TRANS_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->TRANS_ID->getPlaceHolder()) ?>" value="<?= $Grid->TRANS_ID->EditValue ?>"<?= $Grid->TRANS_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->TRANS_ID->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_TRANS_ID" class="form-group V_TREAT_TRANS_ID">
<span<?= $Grid->TRANS_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->TRANS_ID->getDisplayValue($Grid->TRANS_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_TRANS_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_TRANS_ID" id="x<?= $Grid->RowIndex ?>_TRANS_ID" value="<?= HtmlEncode($Grid->TRANS_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_TRANS_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_TRANS_ID" id="o<?= $Grid->RowIndex ?>_TRANS_ID" value="<?= HtmlEncode($Grid->TRANS_ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->SPPBILL->Visible) { // SPPBILL ?>
        <td data-name="SPPBILL">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_SPPBILL" class="form-group V_TREAT_SPPBILL">
<input type="<?= $Grid->SPPBILL->getInputTextType() ?>" data-table="V_TREAT" data-field="x_SPPBILL" name="x<?= $Grid->RowIndex ?>_SPPBILL" id="x<?= $Grid->RowIndex ?>_SPPBILL" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->SPPBILL->getPlaceHolder()) ?>" value="<?= $Grid->SPPBILL->EditValue ?>"<?= $Grid->SPPBILL->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->SPPBILL->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_SPPBILL" class="form-group V_TREAT_SPPBILL">
<span<?= $Grid->SPPBILL->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->SPPBILL->getDisplayValue($Grid->SPPBILL->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_SPPBILL" data-hidden="1" name="x<?= $Grid->RowIndex ?>_SPPBILL" id="x<?= $Grid->RowIndex ?>_SPPBILL" value="<?= HtmlEncode($Grid->SPPBILL->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_SPPBILL" data-hidden="1" name="o<?= $Grid->RowIndex ?>_SPPBILL" id="o<?= $Grid->RowIndex ?>_SPPBILL" value="<?= HtmlEncode($Grid->SPPBILL->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->SPPBILLDATE->Visible) { // SPPBILLDATE ?>
        <td data-name="SPPBILLDATE">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_SPPBILLDATE" class="form-group V_TREAT_SPPBILLDATE">
<input type="<?= $Grid->SPPBILLDATE->getInputTextType() ?>" data-table="V_TREAT" data-field="x_SPPBILLDATE" name="x<?= $Grid->RowIndex ?>_SPPBILLDATE" id="x<?= $Grid->RowIndex ?>_SPPBILLDATE" placeholder="<?= HtmlEncode($Grid->SPPBILLDATE->getPlaceHolder()) ?>" value="<?= $Grid->SPPBILLDATE->EditValue ?>"<?= $Grid->SPPBILLDATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->SPPBILLDATE->getErrorMessage() ?></div>
<?php if (!$Grid->SPPBILLDATE->ReadOnly && !$Grid->SPPBILLDATE->Disabled && !isset($Grid->SPPBILLDATE->EditAttrs["readonly"]) && !isset($Grid->SPPBILLDATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fV_TREATgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fV_TREATgrid", "x<?= $Grid->RowIndex ?>_SPPBILLDATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_SPPBILLDATE" class="form-group V_TREAT_SPPBILLDATE">
<span<?= $Grid->SPPBILLDATE->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->SPPBILLDATE->getDisplayValue($Grid->SPPBILLDATE->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_SPPBILLDATE" data-hidden="1" name="x<?= $Grid->RowIndex ?>_SPPBILLDATE" id="x<?= $Grid->RowIndex ?>_SPPBILLDATE" value="<?= HtmlEncode($Grid->SPPBILLDATE->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_SPPBILLDATE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_SPPBILLDATE" id="o<?= $Grid->RowIndex ?>_SPPBILLDATE" value="<?= HtmlEncode($Grid->SPPBILLDATE->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->SPPBILLUSER->Visible) { // SPPBILLUSER ?>
        <td data-name="SPPBILLUSER">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_SPPBILLUSER" class="form-group V_TREAT_SPPBILLUSER">
<input type="<?= $Grid->SPPBILLUSER->getInputTextType() ?>" data-table="V_TREAT" data-field="x_SPPBILLUSER" name="x<?= $Grid->RowIndex ?>_SPPBILLUSER" id="x<?= $Grid->RowIndex ?>_SPPBILLUSER" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->SPPBILLUSER->getPlaceHolder()) ?>" value="<?= $Grid->SPPBILLUSER->EditValue ?>"<?= $Grid->SPPBILLUSER->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->SPPBILLUSER->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_SPPBILLUSER" class="form-group V_TREAT_SPPBILLUSER">
<span<?= $Grid->SPPBILLUSER->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->SPPBILLUSER->getDisplayValue($Grid->SPPBILLUSER->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_SPPBILLUSER" data-hidden="1" name="x<?= $Grid->RowIndex ?>_SPPBILLUSER" id="x<?= $Grid->RowIndex ?>_SPPBILLUSER" value="<?= HtmlEncode($Grid->SPPBILLUSER->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_SPPBILLUSER" data-hidden="1" name="o<?= $Grid->RowIndex ?>_SPPBILLUSER" id="o<?= $Grid->RowIndex ?>_SPPBILLUSER" value="<?= HtmlEncode($Grid->SPPBILLUSER->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->SPPKASIR->Visible) { // SPPKASIR ?>
        <td data-name="SPPKASIR">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_SPPKASIR" class="form-group V_TREAT_SPPKASIR">
<input type="<?= $Grid->SPPKASIR->getInputTextType() ?>" data-table="V_TREAT" data-field="x_SPPKASIR" name="x<?= $Grid->RowIndex ?>_SPPKASIR" id="x<?= $Grid->RowIndex ?>_SPPKASIR" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->SPPKASIR->getPlaceHolder()) ?>" value="<?= $Grid->SPPKASIR->EditValue ?>"<?= $Grid->SPPKASIR->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->SPPKASIR->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_SPPKASIR" class="form-group V_TREAT_SPPKASIR">
<span<?= $Grid->SPPKASIR->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->SPPKASIR->getDisplayValue($Grid->SPPKASIR->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_SPPKASIR" data-hidden="1" name="x<?= $Grid->RowIndex ?>_SPPKASIR" id="x<?= $Grid->RowIndex ?>_SPPKASIR" value="<?= HtmlEncode($Grid->SPPKASIR->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_SPPKASIR" data-hidden="1" name="o<?= $Grid->RowIndex ?>_SPPKASIR" id="o<?= $Grid->RowIndex ?>_SPPKASIR" value="<?= HtmlEncode($Grid->SPPKASIR->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->SPPKASIRDATE->Visible) { // SPPKASIRDATE ?>
        <td data-name="SPPKASIRDATE">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_SPPKASIRDATE" class="form-group V_TREAT_SPPKASIRDATE">
<input type="<?= $Grid->SPPKASIRDATE->getInputTextType() ?>" data-table="V_TREAT" data-field="x_SPPKASIRDATE" name="x<?= $Grid->RowIndex ?>_SPPKASIRDATE" id="x<?= $Grid->RowIndex ?>_SPPKASIRDATE" placeholder="<?= HtmlEncode($Grid->SPPKASIRDATE->getPlaceHolder()) ?>" value="<?= $Grid->SPPKASIRDATE->EditValue ?>"<?= $Grid->SPPKASIRDATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->SPPKASIRDATE->getErrorMessage() ?></div>
<?php if (!$Grid->SPPKASIRDATE->ReadOnly && !$Grid->SPPKASIRDATE->Disabled && !isset($Grid->SPPKASIRDATE->EditAttrs["readonly"]) && !isset($Grid->SPPKASIRDATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fV_TREATgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fV_TREATgrid", "x<?= $Grid->RowIndex ?>_SPPKASIRDATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_SPPKASIRDATE" class="form-group V_TREAT_SPPKASIRDATE">
<span<?= $Grid->SPPKASIRDATE->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->SPPKASIRDATE->getDisplayValue($Grid->SPPKASIRDATE->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_SPPKASIRDATE" data-hidden="1" name="x<?= $Grid->RowIndex ?>_SPPKASIRDATE" id="x<?= $Grid->RowIndex ?>_SPPKASIRDATE" value="<?= HtmlEncode($Grid->SPPKASIRDATE->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_SPPKASIRDATE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_SPPKASIRDATE" id="o<?= $Grid->RowIndex ?>_SPPKASIRDATE" value="<?= HtmlEncode($Grid->SPPKASIRDATE->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->SPPKASIRUSER->Visible) { // SPPKASIRUSER ?>
        <td data-name="SPPKASIRUSER">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_SPPKASIRUSER" class="form-group V_TREAT_SPPKASIRUSER">
<input type="<?= $Grid->SPPKASIRUSER->getInputTextType() ?>" data-table="V_TREAT" data-field="x_SPPKASIRUSER" name="x<?= $Grid->RowIndex ?>_SPPKASIRUSER" id="x<?= $Grid->RowIndex ?>_SPPKASIRUSER" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->SPPKASIRUSER->getPlaceHolder()) ?>" value="<?= $Grid->SPPKASIRUSER->EditValue ?>"<?= $Grid->SPPKASIRUSER->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->SPPKASIRUSER->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_SPPKASIRUSER" class="form-group V_TREAT_SPPKASIRUSER">
<span<?= $Grid->SPPKASIRUSER->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->SPPKASIRUSER->getDisplayValue($Grid->SPPKASIRUSER->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_SPPKASIRUSER" data-hidden="1" name="x<?= $Grid->RowIndex ?>_SPPKASIRUSER" id="x<?= $Grid->RowIndex ?>_SPPKASIRUSER" value="<?= HtmlEncode($Grid->SPPKASIRUSER->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_SPPKASIRUSER" data-hidden="1" name="o<?= $Grid->RowIndex ?>_SPPKASIRUSER" id="o<?= $Grid->RowIndex ?>_SPPKASIRUSER" value="<?= HtmlEncode($Grid->SPPKASIRUSER->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->SPPPOLI->Visible) { // SPPPOLI ?>
        <td data-name="SPPPOLI">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_SPPPOLI" class="form-group V_TREAT_SPPPOLI">
<input type="<?= $Grid->SPPPOLI->getInputTextType() ?>" data-table="V_TREAT" data-field="x_SPPPOLI" name="x<?= $Grid->RowIndex ?>_SPPPOLI" id="x<?= $Grid->RowIndex ?>_SPPPOLI" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->SPPPOLI->getPlaceHolder()) ?>" value="<?= $Grid->SPPPOLI->EditValue ?>"<?= $Grid->SPPPOLI->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->SPPPOLI->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_SPPPOLI" class="form-group V_TREAT_SPPPOLI">
<span<?= $Grid->SPPPOLI->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->SPPPOLI->getDisplayValue($Grid->SPPPOLI->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_SPPPOLI" data-hidden="1" name="x<?= $Grid->RowIndex ?>_SPPPOLI" id="x<?= $Grid->RowIndex ?>_SPPPOLI" value="<?= HtmlEncode($Grid->SPPPOLI->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_SPPPOLI" data-hidden="1" name="o<?= $Grid->RowIndex ?>_SPPPOLI" id="o<?= $Grid->RowIndex ?>_SPPPOLI" value="<?= HtmlEncode($Grid->SPPPOLI->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->SPPPOLIUSER->Visible) { // SPPPOLIUSER ?>
        <td data-name="SPPPOLIUSER">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_SPPPOLIUSER" class="form-group V_TREAT_SPPPOLIUSER">
<input type="<?= $Grid->SPPPOLIUSER->getInputTextType() ?>" data-table="V_TREAT" data-field="x_SPPPOLIUSER" name="x<?= $Grid->RowIndex ?>_SPPPOLIUSER" id="x<?= $Grid->RowIndex ?>_SPPPOLIUSER" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->SPPPOLIUSER->getPlaceHolder()) ?>" value="<?= $Grid->SPPPOLIUSER->EditValue ?>"<?= $Grid->SPPPOLIUSER->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->SPPPOLIUSER->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_SPPPOLIUSER" class="form-group V_TREAT_SPPPOLIUSER">
<span<?= $Grid->SPPPOLIUSER->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->SPPPOLIUSER->getDisplayValue($Grid->SPPPOLIUSER->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_SPPPOLIUSER" data-hidden="1" name="x<?= $Grid->RowIndex ?>_SPPPOLIUSER" id="x<?= $Grid->RowIndex ?>_SPPPOLIUSER" value="<?= HtmlEncode($Grid->SPPPOLIUSER->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_SPPPOLIUSER" data-hidden="1" name="o<?= $Grid->RowIndex ?>_SPPPOLIUSER" id="o<?= $Grid->RowIndex ?>_SPPPOLIUSER" value="<?= HtmlEncode($Grid->SPPPOLIUSER->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->SPPPOLIDATE->Visible) { // SPPPOLIDATE ?>
        <td data-name="SPPPOLIDATE">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_SPPPOLIDATE" class="form-group V_TREAT_SPPPOLIDATE">
<input type="<?= $Grid->SPPPOLIDATE->getInputTextType() ?>" data-table="V_TREAT" data-field="x_SPPPOLIDATE" name="x<?= $Grid->RowIndex ?>_SPPPOLIDATE" id="x<?= $Grid->RowIndex ?>_SPPPOLIDATE" placeholder="<?= HtmlEncode($Grid->SPPPOLIDATE->getPlaceHolder()) ?>" value="<?= $Grid->SPPPOLIDATE->EditValue ?>"<?= $Grid->SPPPOLIDATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->SPPPOLIDATE->getErrorMessage() ?></div>
<?php if (!$Grid->SPPPOLIDATE->ReadOnly && !$Grid->SPPPOLIDATE->Disabled && !isset($Grid->SPPPOLIDATE->EditAttrs["readonly"]) && !isset($Grid->SPPPOLIDATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fV_TREATgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fV_TREATgrid", "x<?= $Grid->RowIndex ?>_SPPPOLIDATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_SPPPOLIDATE" class="form-group V_TREAT_SPPPOLIDATE">
<span<?= $Grid->SPPPOLIDATE->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->SPPPOLIDATE->getDisplayValue($Grid->SPPPOLIDATE->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_SPPPOLIDATE" data-hidden="1" name="x<?= $Grid->RowIndex ?>_SPPPOLIDATE" id="x<?= $Grid->RowIndex ?>_SPPPOLIDATE" value="<?= HtmlEncode($Grid->SPPPOLIDATE->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_SPPPOLIDATE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_SPPPOLIDATE" id="o<?= $Grid->RowIndex ?>_SPPPOLIDATE" value="<?= HtmlEncode($Grid->SPPPOLIDATE->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->NOSEP->Visible) { // NOSEP ?>
        <td data-name="NOSEP">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_NOSEP" class="form-group V_TREAT_NOSEP">
<input type="<?= $Grid->NOSEP->getInputTextType() ?>" data-table="V_TREAT" data-field="x_NOSEP" name="x<?= $Grid->RowIndex ?>_NOSEP" id="x<?= $Grid->RowIndex ?>_NOSEP" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->NOSEP->getPlaceHolder()) ?>" value="<?= $Grid->NOSEP->EditValue ?>"<?= $Grid->NOSEP->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->NOSEP->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_NOSEP" class="form-group V_TREAT_NOSEP">
<span<?= $Grid->NOSEP->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->NOSEP->getDisplayValue($Grid->NOSEP->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_NOSEP" data-hidden="1" name="x<?= $Grid->RowIndex ?>_NOSEP" id="x<?= $Grid->RowIndex ?>_NOSEP" value="<?= HtmlEncode($Grid->NOSEP->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_NOSEP" data-hidden="1" name="o<?= $Grid->RowIndex ?>_NOSEP" id="o<?= $Grid->RowIndex ?>_NOSEP" value="<?= HtmlEncode($Grid->NOSEP->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->ID->Visible) { // ID ?>
        <td data-name="ID">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_TREAT_ID" class="form-group V_TREAT_ID"></span>
<?php } else { ?>
<span id="el$rowindex$_V_TREAT_ID" class="form-group V_TREAT_ID">
<span<?= $Grid->ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->ID->getDisplayValue($Grid->ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_TREAT" data-field="x_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_ID" id="x<?= $Grid->RowIndex ?>_ID" value="<?= HtmlEncode($Grid->ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_TREAT" data-field="x_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ID" id="o<?= $Grid->RowIndex ?>_ID" value="<?= HtmlEncode($Grid->ID->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["fV_TREATgrid","load"], function() {
    fV_TREATgrid.updateLists(<?= $Grid->RowIndex ?>);
});
</script>
    </tr>
<?php
    }
?>
</tbody>
</table><!-- /.ew-table -->
</div><!-- /.ew-grid-middle-panel -->
<?php if ($Grid->CurrentMode == "add" || $Grid->CurrentMode == "copy") { ?>
<input type="hidden" name="<?= $Grid->FormKeyCountName ?>" id="<?= $Grid->FormKeyCountName ?>" value="<?= $Grid->KeyCount ?>">
<?= $Grid->MultiSelectKey ?>
<?php } ?>
<?php if ($Grid->CurrentMode == "edit") { ?>
<input type="hidden" name="<?= $Grid->FormKeyCountName ?>" id="<?= $Grid->FormKeyCountName ?>" value="<?= $Grid->KeyCount ?>">
<?= $Grid->MultiSelectKey ?>
<?php } ?>
<?php if ($Grid->CurrentMode == "") { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fV_TREATgrid">
</div><!-- /.ew-list-form -->
<?php
// Close recordset
if ($Grid->Recordset) {
    $Grid->Recordset->close();
}
?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($Grid->TotalRecords == 0 && !$Grid->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $Grid->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if (!$Grid->isExport()) { ?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("V_TREAT");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
