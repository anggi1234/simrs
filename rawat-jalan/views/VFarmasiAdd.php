<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAJALALTER;

// Page object
$VFarmasiAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fV_FARMASIadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fV_FARMASIadd = currentForm = new ew.Form("fV_FARMASIadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "V_FARMASI")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.V_FARMASI)
        ew.vars.tables.V_FARMASI = currentTable;
    fV_FARMASIadd.addFields([
        ["ORG_UNIT_CODE", [fields.ORG_UNIT_CODE.visible && fields.ORG_UNIT_CODE.required ? ew.Validators.required(fields.ORG_UNIT_CODE.caption) : null], fields.ORG_UNIT_CODE.isInvalid],
        ["NO_REGISTRATION", [fields.NO_REGISTRATION.visible && fields.NO_REGISTRATION.required ? ew.Validators.required(fields.NO_REGISTRATION.caption) : null], fields.NO_REGISTRATION.isInvalid],
        ["VISIT_ID", [fields.VISIT_ID.visible && fields.VISIT_ID.required ? ew.Validators.required(fields.VISIT_ID.caption) : null], fields.VISIT_ID.isInvalid],
        ["STATUS_PASIEN_ID", [fields.STATUS_PASIEN_ID.visible && fields.STATUS_PASIEN_ID.required ? ew.Validators.required(fields.STATUS_PASIEN_ID.caption) : null, ew.Validators.integer], fields.STATUS_PASIEN_ID.isInvalid],
        ["RUJUKAN_ID", [fields.RUJUKAN_ID.visible && fields.RUJUKAN_ID.required ? ew.Validators.required(fields.RUJUKAN_ID.caption) : null, ew.Validators.integer], fields.RUJUKAN_ID.isInvalid],
        ["ADDRESS_OF_RUJUKAN", [fields.ADDRESS_OF_RUJUKAN.visible && fields.ADDRESS_OF_RUJUKAN.required ? ew.Validators.required(fields.ADDRESS_OF_RUJUKAN.caption) : null], fields.ADDRESS_OF_RUJUKAN.isInvalid],
        ["REASON_ID", [fields.REASON_ID.visible && fields.REASON_ID.required ? ew.Validators.required(fields.REASON_ID.caption) : null, ew.Validators.integer], fields.REASON_ID.isInvalid],
        ["WAY_ID", [fields.WAY_ID.visible && fields.WAY_ID.required ? ew.Validators.required(fields.WAY_ID.caption) : null, ew.Validators.integer], fields.WAY_ID.isInvalid],
        ["PATIENT_CATEGORY_ID", [fields.PATIENT_CATEGORY_ID.visible && fields.PATIENT_CATEGORY_ID.required ? ew.Validators.required(fields.PATIENT_CATEGORY_ID.caption) : null, ew.Validators.integer], fields.PATIENT_CATEGORY_ID.isInvalid],
        ["BOOKED_DATE", [fields.BOOKED_DATE.visible && fields.BOOKED_DATE.required ? ew.Validators.required(fields.BOOKED_DATE.caption) : null, ew.Validators.datetime(0)], fields.BOOKED_DATE.isInvalid],
        ["VISIT_DATE", [fields.VISIT_DATE.visible && fields.VISIT_DATE.required ? ew.Validators.required(fields.VISIT_DATE.caption) : null, ew.Validators.datetime(0)], fields.VISIT_DATE.isInvalid],
        ["ISNEW", [fields.ISNEW.visible && fields.ISNEW.required ? ew.Validators.required(fields.ISNEW.caption) : null], fields.ISNEW.isInvalid],
        ["FOLLOW_UP", [fields.FOLLOW_UP.visible && fields.FOLLOW_UP.required ? ew.Validators.required(fields.FOLLOW_UP.caption) : null, ew.Validators.integer], fields.FOLLOW_UP.isInvalid],
        ["PLACE_TYPE", [fields.PLACE_TYPE.visible && fields.PLACE_TYPE.required ? ew.Validators.required(fields.PLACE_TYPE.caption) : null, ew.Validators.integer], fields.PLACE_TYPE.isInvalid],
        ["CLINIC_ID", [fields.CLINIC_ID.visible && fields.CLINIC_ID.required ? ew.Validators.required(fields.CLINIC_ID.caption) : null], fields.CLINIC_ID.isInvalid],
        ["CLINIC_ID_FROM", [fields.CLINIC_ID_FROM.visible && fields.CLINIC_ID_FROM.required ? ew.Validators.required(fields.CLINIC_ID_FROM.caption) : null], fields.CLINIC_ID_FROM.isInvalid],
        ["CLASS_ROOM_ID", [fields.CLASS_ROOM_ID.visible && fields.CLASS_ROOM_ID.required ? ew.Validators.required(fields.CLASS_ROOM_ID.caption) : null], fields.CLASS_ROOM_ID.isInvalid],
        ["BED_ID", [fields.BED_ID.visible && fields.BED_ID.required ? ew.Validators.required(fields.BED_ID.caption) : null, ew.Validators.integer], fields.BED_ID.isInvalid],
        ["KELUAR_ID", [fields.KELUAR_ID.visible && fields.KELUAR_ID.required ? ew.Validators.required(fields.KELUAR_ID.caption) : null, ew.Validators.integer], fields.KELUAR_ID.isInvalid],
        ["IN_DATE", [fields.IN_DATE.visible && fields.IN_DATE.required ? ew.Validators.required(fields.IN_DATE.caption) : null, ew.Validators.datetime(0)], fields.IN_DATE.isInvalid],
        ["EXIT_DATE", [fields.EXIT_DATE.visible && fields.EXIT_DATE.required ? ew.Validators.required(fields.EXIT_DATE.caption) : null, ew.Validators.datetime(0)], fields.EXIT_DATE.isInvalid],
        ["DIANTAR_OLEH", [fields.DIANTAR_OLEH.visible && fields.DIANTAR_OLEH.required ? ew.Validators.required(fields.DIANTAR_OLEH.caption) : null], fields.DIANTAR_OLEH.isInvalid],
        ["GENDER", [fields.GENDER.visible && fields.GENDER.required ? ew.Validators.required(fields.GENDER.caption) : null], fields.GENDER.isInvalid],
        ["DESCRIPTION", [fields.DESCRIPTION.visible && fields.DESCRIPTION.required ? ew.Validators.required(fields.DESCRIPTION.caption) : null], fields.DESCRIPTION.isInvalid],
        ["VISITOR_ADDRESS", [fields.VISITOR_ADDRESS.visible && fields.VISITOR_ADDRESS.required ? ew.Validators.required(fields.VISITOR_ADDRESS.caption) : null], fields.VISITOR_ADDRESS.isInvalid],
        ["MODIFIED_BY", [fields.MODIFIED_BY.visible && fields.MODIFIED_BY.required ? ew.Validators.required(fields.MODIFIED_BY.caption) : null], fields.MODIFIED_BY.isInvalid],
        ["MODIFIED_DATE", [fields.MODIFIED_DATE.visible && fields.MODIFIED_DATE.required ? ew.Validators.required(fields.MODIFIED_DATE.caption) : null, ew.Validators.datetime(0)], fields.MODIFIED_DATE.isInvalid],
        ["MODIFIED_FROM", [fields.MODIFIED_FROM.visible && fields.MODIFIED_FROM.required ? ew.Validators.required(fields.MODIFIED_FROM.caption) : null], fields.MODIFIED_FROM.isInvalid],
        ["EMPLOYEE_ID", [fields.EMPLOYEE_ID.visible && fields.EMPLOYEE_ID.required ? ew.Validators.required(fields.EMPLOYEE_ID.caption) : null], fields.EMPLOYEE_ID.isInvalid],
        ["EMPLOYEE_ID_FROM", [fields.EMPLOYEE_ID_FROM.visible && fields.EMPLOYEE_ID_FROM.required ? ew.Validators.required(fields.EMPLOYEE_ID_FROM.caption) : null], fields.EMPLOYEE_ID_FROM.isInvalid],
        ["RESPONSIBLE_ID", [fields.RESPONSIBLE_ID.visible && fields.RESPONSIBLE_ID.required ? ew.Validators.required(fields.RESPONSIBLE_ID.caption) : null, ew.Validators.integer], fields.RESPONSIBLE_ID.isInvalid],
        ["RESPONSIBLE", [fields.RESPONSIBLE.visible && fields.RESPONSIBLE.required ? ew.Validators.required(fields.RESPONSIBLE.caption) : null], fields.RESPONSIBLE.isInvalid],
        ["FAMILY_STATUS_ID", [fields.FAMILY_STATUS_ID.visible && fields.FAMILY_STATUS_ID.required ? ew.Validators.required(fields.FAMILY_STATUS_ID.caption) : null, ew.Validators.integer], fields.FAMILY_STATUS_ID.isInvalid],
        ["TICKET_NO", [fields.TICKET_NO.visible && fields.TICKET_NO.required ? ew.Validators.required(fields.TICKET_NO.caption) : null, ew.Validators.integer], fields.TICKET_NO.isInvalid],
        ["ISATTENDED", [fields.ISATTENDED.visible && fields.ISATTENDED.required ? ew.Validators.required(fields.ISATTENDED.caption) : null], fields.ISATTENDED.isInvalid],
        ["PAYOR_ID", [fields.PAYOR_ID.visible && fields.PAYOR_ID.required ? ew.Validators.required(fields.PAYOR_ID.caption) : null], fields.PAYOR_ID.isInvalid],
        ["CLASS_ID", [fields.CLASS_ID.visible && fields.CLASS_ID.required ? ew.Validators.required(fields.CLASS_ID.caption) : null, ew.Validators.integer], fields.CLASS_ID.isInvalid],
        ["ISPERTARIF", [fields.ISPERTARIF.visible && fields.ISPERTARIF.required ? ew.Validators.required(fields.ISPERTARIF.caption) : null], fields.ISPERTARIF.isInvalid],
        ["KAL_ID", [fields.KAL_ID.visible && fields.KAL_ID.required ? ew.Validators.required(fields.KAL_ID.caption) : null], fields.KAL_ID.isInvalid],
        ["EMPLOYEE_INAP", [fields.EMPLOYEE_INAP.visible && fields.EMPLOYEE_INAP.required ? ew.Validators.required(fields.EMPLOYEE_INAP.caption) : null], fields.EMPLOYEE_INAP.isInvalid],
        ["PASIEN_ID", [fields.PASIEN_ID.visible && fields.PASIEN_ID.required ? ew.Validators.required(fields.PASIEN_ID.caption) : null], fields.PASIEN_ID.isInvalid],
        ["KARYAWAN", [fields.KARYAWAN.visible && fields.KARYAWAN.required ? ew.Validators.required(fields.KARYAWAN.caption) : null], fields.KARYAWAN.isInvalid],
        ["ACCOUNT_ID", [fields.ACCOUNT_ID.visible && fields.ACCOUNT_ID.required ? ew.Validators.required(fields.ACCOUNT_ID.caption) : null], fields.ACCOUNT_ID.isInvalid],
        ["CLASS_ID_PLAFOND", [fields.CLASS_ID_PLAFOND.visible && fields.CLASS_ID_PLAFOND.required ? ew.Validators.required(fields.CLASS_ID_PLAFOND.caption) : null, ew.Validators.integer], fields.CLASS_ID_PLAFOND.isInvalid],
        ["BACKCHARGE", [fields.BACKCHARGE.visible && fields.BACKCHARGE.required ? ew.Validators.required(fields.BACKCHARGE.caption) : null], fields.BACKCHARGE.isInvalid],
        ["COVERAGE_ID", [fields.COVERAGE_ID.visible && fields.COVERAGE_ID.required ? ew.Validators.required(fields.COVERAGE_ID.caption) : null, ew.Validators.integer], fields.COVERAGE_ID.isInvalid],
        ["AGEYEAR", [fields.AGEYEAR.visible && fields.AGEYEAR.required ? ew.Validators.required(fields.AGEYEAR.caption) : null, ew.Validators.integer], fields.AGEYEAR.isInvalid],
        ["AGEMONTH", [fields.AGEMONTH.visible && fields.AGEMONTH.required ? ew.Validators.required(fields.AGEMONTH.caption) : null, ew.Validators.integer], fields.AGEMONTH.isInvalid],
        ["AGEDAY", [fields.AGEDAY.visible && fields.AGEDAY.required ? ew.Validators.required(fields.AGEDAY.caption) : null, ew.Validators.integer], fields.AGEDAY.isInvalid],
        ["RECOMENDATION", [fields.RECOMENDATION.visible && fields.RECOMENDATION.required ? ew.Validators.required(fields.RECOMENDATION.caption) : null], fields.RECOMENDATION.isInvalid],
        ["CONCLUSION", [fields.CONCLUSION.visible && fields.CONCLUSION.required ? ew.Validators.required(fields.CONCLUSION.caption) : null], fields.CONCLUSION.isInvalid],
        ["SPECIMENNO", [fields.SPECIMENNO.visible && fields.SPECIMENNO.required ? ew.Validators.required(fields.SPECIMENNO.caption) : null], fields.SPECIMENNO.isInvalid],
        ["LOCKED", [fields.LOCKED.visible && fields.LOCKED.required ? ew.Validators.required(fields.LOCKED.caption) : null], fields.LOCKED.isInvalid],
        ["RM_OUT_DATE", [fields.RM_OUT_DATE.visible && fields.RM_OUT_DATE.required ? ew.Validators.required(fields.RM_OUT_DATE.caption) : null, ew.Validators.datetime(0)], fields.RM_OUT_DATE.isInvalid],
        ["RM_IN_DATE", [fields.RM_IN_DATE.visible && fields.RM_IN_DATE.required ? ew.Validators.required(fields.RM_IN_DATE.caption) : null, ew.Validators.datetime(0)], fields.RM_IN_DATE.isInvalid],
        ["LAMA_PINJAM", [fields.LAMA_PINJAM.visible && fields.LAMA_PINJAM.required ? ew.Validators.required(fields.LAMA_PINJAM.caption) : null, ew.Validators.datetime(0)], fields.LAMA_PINJAM.isInvalid],
        ["STANDAR_RJ", [fields.STANDAR_RJ.visible && fields.STANDAR_RJ.required ? ew.Validators.required(fields.STANDAR_RJ.caption) : null], fields.STANDAR_RJ.isInvalid],
        ["LENGKAP_RJ", [fields.LENGKAP_RJ.visible && fields.LENGKAP_RJ.required ? ew.Validators.required(fields.LENGKAP_RJ.caption) : null], fields.LENGKAP_RJ.isInvalid],
        ["LENGKAP_RI", [fields.LENGKAP_RI.visible && fields.LENGKAP_RI.required ? ew.Validators.required(fields.LENGKAP_RI.caption) : null], fields.LENGKAP_RI.isInvalid],
        ["RESEND_RM_DATE", [fields.RESEND_RM_DATE.visible && fields.RESEND_RM_DATE.required ? ew.Validators.required(fields.RESEND_RM_DATE.caption) : null, ew.Validators.datetime(0)], fields.RESEND_RM_DATE.isInvalid],
        ["LENGKAP_RM1", [fields.LENGKAP_RM1.visible && fields.LENGKAP_RM1.required ? ew.Validators.required(fields.LENGKAP_RM1.caption) : null], fields.LENGKAP_RM1.isInvalid],
        ["LENGKAP_RESUME", [fields.LENGKAP_RESUME.visible && fields.LENGKAP_RESUME.required ? ew.Validators.required(fields.LENGKAP_RESUME.caption) : null], fields.LENGKAP_RESUME.isInvalid],
        ["LENGKAP_ANAMNESIS", [fields.LENGKAP_ANAMNESIS.visible && fields.LENGKAP_ANAMNESIS.required ? ew.Validators.required(fields.LENGKAP_ANAMNESIS.caption) : null], fields.LENGKAP_ANAMNESIS.isInvalid],
        ["LENGKAP_CONSENT", [fields.LENGKAP_CONSENT.visible && fields.LENGKAP_CONSENT.required ? ew.Validators.required(fields.LENGKAP_CONSENT.caption) : null], fields.LENGKAP_CONSENT.isInvalid],
        ["LENGKAP_ANESTESI", [fields.LENGKAP_ANESTESI.visible && fields.LENGKAP_ANESTESI.required ? ew.Validators.required(fields.LENGKAP_ANESTESI.caption) : null], fields.LENGKAP_ANESTESI.isInvalid],
        ["LENGKAP_OP", [fields.LENGKAP_OP.visible && fields.LENGKAP_OP.required ? ew.Validators.required(fields.LENGKAP_OP.caption) : null], fields.LENGKAP_OP.isInvalid],
        ["BACK_RM_DATE", [fields.BACK_RM_DATE.visible && fields.BACK_RM_DATE.required ? ew.Validators.required(fields.BACK_RM_DATE.caption) : null, ew.Validators.datetime(0)], fields.BACK_RM_DATE.isInvalid],
        ["VALID_RM_DATE", [fields.VALID_RM_DATE.visible && fields.VALID_RM_DATE.required ? ew.Validators.required(fields.VALID_RM_DATE.caption) : null, ew.Validators.datetime(0)], fields.VALID_RM_DATE.isInvalid],
        ["NO_SKP", [fields.NO_SKP.visible && fields.NO_SKP.required ? ew.Validators.required(fields.NO_SKP.caption) : null], fields.NO_SKP.isInvalid],
        ["NO_SKPINAP", [fields.NO_SKPINAP.visible && fields.NO_SKPINAP.required ? ew.Validators.required(fields.NO_SKPINAP.caption) : null], fields.NO_SKPINAP.isInvalid],
        ["DIAGNOSA_ID", [fields.DIAGNOSA_ID.visible && fields.DIAGNOSA_ID.required ? ew.Validators.required(fields.DIAGNOSA_ID.caption) : null], fields.DIAGNOSA_ID.isInvalid],
        ["ticket_all", [fields.ticket_all.visible && fields.ticket_all.required ? ew.Validators.required(fields.ticket_all.caption) : null, ew.Validators.integer], fields.ticket_all.isInvalid],
        ["tanggal_rujukan", [fields.tanggal_rujukan.visible && fields.tanggal_rujukan.required ? ew.Validators.required(fields.tanggal_rujukan.caption) : null, ew.Validators.datetime(0)], fields.tanggal_rujukan.isInvalid],
        ["ISRJ", [fields.ISRJ.visible && fields.ISRJ.required ? ew.Validators.required(fields.ISRJ.caption) : null], fields.ISRJ.isInvalid],
        ["NORUJUKAN", [fields.NORUJUKAN.visible && fields.NORUJUKAN.required ? ew.Validators.required(fields.NORUJUKAN.caption) : null], fields.NORUJUKAN.isInvalid],
        ["PPKRUJUKAN", [fields.PPKRUJUKAN.visible && fields.PPKRUJUKAN.required ? ew.Validators.required(fields.PPKRUJUKAN.caption) : null], fields.PPKRUJUKAN.isInvalid],
        ["LOKASILAKA", [fields.LOKASILAKA.visible && fields.LOKASILAKA.required ? ew.Validators.required(fields.LOKASILAKA.caption) : null], fields.LOKASILAKA.isInvalid],
        ["KDPOLI", [fields.KDPOLI.visible && fields.KDPOLI.required ? ew.Validators.required(fields.KDPOLI.caption) : null], fields.KDPOLI.isInvalid],
        ["EDIT_SEP", [fields.EDIT_SEP.visible && fields.EDIT_SEP.required ? ew.Validators.required(fields.EDIT_SEP.caption) : null], fields.EDIT_SEP.isInvalid],
        ["DELETE_SEP", [fields.DELETE_SEP.visible && fields.DELETE_SEP.required ? ew.Validators.required(fields.DELETE_SEP.caption) : null], fields.DELETE_SEP.isInvalid],
        ["KODE_AGAMA", [fields.KODE_AGAMA.visible && fields.KODE_AGAMA.required ? ew.Validators.required(fields.KODE_AGAMA.caption) : null, ew.Validators.integer], fields.KODE_AGAMA.isInvalid],
        ["DIAG_AWAL", [fields.DIAG_AWAL.visible && fields.DIAG_AWAL.required ? ew.Validators.required(fields.DIAG_AWAL.caption) : null], fields.DIAG_AWAL.isInvalid],
        ["AKTIF", [fields.AKTIF.visible && fields.AKTIF.required ? ew.Validators.required(fields.AKTIF.caption) : null], fields.AKTIF.isInvalid],
        ["BILL_INAP", [fields.BILL_INAP.visible && fields.BILL_INAP.required ? ew.Validators.required(fields.BILL_INAP.caption) : null], fields.BILL_INAP.isInvalid],
        ["SEP_PRINTDATE", [fields.SEP_PRINTDATE.visible && fields.SEP_PRINTDATE.required ? ew.Validators.required(fields.SEP_PRINTDATE.caption) : null, ew.Validators.datetime(0)], fields.SEP_PRINTDATE.isInvalid],
        ["MAPPING_SEP", [fields.MAPPING_SEP.visible && fields.MAPPING_SEP.required ? ew.Validators.required(fields.MAPPING_SEP.caption) : null], fields.MAPPING_SEP.isInvalid],
        ["TRANS_ID", [fields.TRANS_ID.visible && fields.TRANS_ID.required ? ew.Validators.required(fields.TRANS_ID.caption) : null], fields.TRANS_ID.isInvalid],
        ["KDPOLI_EKS", [fields.KDPOLI_EKS.visible && fields.KDPOLI_EKS.required ? ew.Validators.required(fields.KDPOLI_EKS.caption) : null], fields.KDPOLI_EKS.isInvalid],
        ["COB", [fields.COB.visible && fields.COB.required ? ew.Validators.required(fields.COB.caption) : null], fields.COB.isInvalid],
        ["PENJAMIN", [fields.PENJAMIN.visible && fields.PENJAMIN.required ? ew.Validators.required(fields.PENJAMIN.caption) : null], fields.PENJAMIN.isInvalid],
        ["ASALRUJUKAN", [fields.ASALRUJUKAN.visible && fields.ASALRUJUKAN.required ? ew.Validators.required(fields.ASALRUJUKAN.caption) : null], fields.ASALRUJUKAN.isInvalid],
        ["RESPONSEP", [fields.RESPONSEP.visible && fields.RESPONSEP.required ? ew.Validators.required(fields.RESPONSEP.caption) : null], fields.RESPONSEP.isInvalid],
        ["APPROVAL_DESC", [fields.APPROVAL_DESC.visible && fields.APPROVAL_DESC.required ? ew.Validators.required(fields.APPROVAL_DESC.caption) : null], fields.APPROVAL_DESC.isInvalid],
        ["APPROVAL_RESPONAJUKAN", [fields.APPROVAL_RESPONAJUKAN.visible && fields.APPROVAL_RESPONAJUKAN.required ? ew.Validators.required(fields.APPROVAL_RESPONAJUKAN.caption) : null], fields.APPROVAL_RESPONAJUKAN.isInvalid],
        ["APPROVAL_RESPONAPPROV", [fields.APPROVAL_RESPONAPPROV.visible && fields.APPROVAL_RESPONAPPROV.required ? ew.Validators.required(fields.APPROVAL_RESPONAPPROV.caption) : null], fields.APPROVAL_RESPONAPPROV.isInvalid],
        ["RESPONTGLPLG_DESC", [fields.RESPONTGLPLG_DESC.visible && fields.RESPONTGLPLG_DESC.required ? ew.Validators.required(fields.RESPONTGLPLG_DESC.caption) : null], fields.RESPONTGLPLG_DESC.isInvalid],
        ["RESPONPOST_VKLAIM", [fields.RESPONPOST_VKLAIM.visible && fields.RESPONPOST_VKLAIM.required ? ew.Validators.required(fields.RESPONPOST_VKLAIM.caption) : null], fields.RESPONPOST_VKLAIM.isInvalid],
        ["RESPONPUT_VKLAIM", [fields.RESPONPUT_VKLAIM.visible && fields.RESPONPUT_VKLAIM.required ? ew.Validators.required(fields.RESPONPUT_VKLAIM.caption) : null], fields.RESPONPUT_VKLAIM.isInvalid],
        ["RESPONDEL_VKLAIM", [fields.RESPONDEL_VKLAIM.visible && fields.RESPONDEL_VKLAIM.required ? ew.Validators.required(fields.RESPONDEL_VKLAIM.caption) : null], fields.RESPONDEL_VKLAIM.isInvalid],
        ["CALL_TIMES", [fields.CALL_TIMES.visible && fields.CALL_TIMES.required ? ew.Validators.required(fields.CALL_TIMES.caption) : null, ew.Validators.integer], fields.CALL_TIMES.isInvalid],
        ["CALL_DATE", [fields.CALL_DATE.visible && fields.CALL_DATE.required ? ew.Validators.required(fields.CALL_DATE.caption) : null, ew.Validators.datetime(0)], fields.CALL_DATE.isInvalid],
        ["CALL_DATES", [fields.CALL_DATES.visible && fields.CALL_DATES.required ? ew.Validators.required(fields.CALL_DATES.caption) : null, ew.Validators.datetime(0)], fields.CALL_DATES.isInvalid],
        ["SERVED_DATE", [fields.SERVED_DATE.visible && fields.SERVED_DATE.required ? ew.Validators.required(fields.SERVED_DATE.caption) : null, ew.Validators.datetime(0)], fields.SERVED_DATE.isInvalid],
        ["SERVED_INAP", [fields.SERVED_INAP.visible && fields.SERVED_INAP.required ? ew.Validators.required(fields.SERVED_INAP.caption) : null, ew.Validators.datetime(0)], fields.SERVED_INAP.isInvalid],
        ["KDDPJP1", [fields.KDDPJP1.visible && fields.KDDPJP1.required ? ew.Validators.required(fields.KDDPJP1.caption) : null], fields.KDDPJP1.isInvalid],
        ["KDDPJP", [fields.KDDPJP.visible && fields.KDDPJP.required ? ew.Validators.required(fields.KDDPJP.caption) : null], fields.KDDPJP.isInvalid],
        ["tgl_kontrol", [fields.tgl_kontrol.visible && fields.tgl_kontrol.required ? ew.Validators.required(fields.tgl_kontrol.caption) : null, ew.Validators.datetime(0)], fields.tgl_kontrol.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fV_FARMASIadd,
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
    fV_FARMASIadd.validate = function () {
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
    fV_FARMASIadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fV_FARMASIadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fV_FARMASIadd");
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
<form name="fV_FARMASIadd" id="fV_FARMASIadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="V_FARMASI">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->ORG_UNIT_CODE->Visible) { // ORG_UNIT_CODE ?>
    <div id="r_ORG_UNIT_CODE" class="form-group row">
        <label id="elh_V_FARMASI_ORG_UNIT_CODE" for="x_ORG_UNIT_CODE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ORG_UNIT_CODE->caption() ?><?= $Page->ORG_UNIT_CODE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ORG_UNIT_CODE->cellAttributes() ?>>
<span id="el_V_FARMASI_ORG_UNIT_CODE">
<input type="<?= $Page->ORG_UNIT_CODE->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_ORG_UNIT_CODE" data-page="1" name="x_ORG_UNIT_CODE" id="x_ORG_UNIT_CODE" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->ORG_UNIT_CODE->getPlaceHolder()) ?>" value="<?= $Page->ORG_UNIT_CODE->EditValue ?>"<?= $Page->ORG_UNIT_CODE->editAttributes() ?> aria-describedby="x_ORG_UNIT_CODE_help">
<?= $Page->ORG_UNIT_CODE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ORG_UNIT_CODE->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->NO_REGISTRATION->Visible) { // NO_REGISTRATION ?>
    <div id="r_NO_REGISTRATION" class="form-group row">
        <label id="elh_V_FARMASI_NO_REGISTRATION" for="x_NO_REGISTRATION" class="<?= $Page->LeftColumnClass ?>"><?= $Page->NO_REGISTRATION->caption() ?><?= $Page->NO_REGISTRATION->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->NO_REGISTRATION->cellAttributes() ?>>
<span id="el_V_FARMASI_NO_REGISTRATION">
<input type="<?= $Page->NO_REGISTRATION->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_NO_REGISTRATION" data-page="1" name="x_NO_REGISTRATION" id="x_NO_REGISTRATION" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->NO_REGISTRATION->getPlaceHolder()) ?>" value="<?= $Page->NO_REGISTRATION->EditValue ?>"<?= $Page->NO_REGISTRATION->editAttributes() ?> aria-describedby="x_NO_REGISTRATION_help">
<?= $Page->NO_REGISTRATION->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->NO_REGISTRATION->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->VISIT_ID->Visible) { // VISIT_ID ?>
    <div id="r_VISIT_ID" class="form-group row">
        <label id="elh_V_FARMASI_VISIT_ID" for="x_VISIT_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->VISIT_ID->caption() ?><?= $Page->VISIT_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->VISIT_ID->cellAttributes() ?>>
<span id="el_V_FARMASI_VISIT_ID">
<input type="<?= $Page->VISIT_ID->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_VISIT_ID" data-page="1" name="x_VISIT_ID" id="x_VISIT_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->VISIT_ID->getPlaceHolder()) ?>" value="<?= $Page->VISIT_ID->EditValue ?>"<?= $Page->VISIT_ID->editAttributes() ?> aria-describedby="x_VISIT_ID_help">
<?= $Page->VISIT_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->VISIT_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->STATUS_PASIEN_ID->Visible) { // STATUS_PASIEN_ID ?>
    <div id="r_STATUS_PASIEN_ID" class="form-group row">
        <label id="elh_V_FARMASI_STATUS_PASIEN_ID" for="x_STATUS_PASIEN_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->STATUS_PASIEN_ID->caption() ?><?= $Page->STATUS_PASIEN_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->STATUS_PASIEN_ID->cellAttributes() ?>>
<span id="el_V_FARMASI_STATUS_PASIEN_ID">
<input type="<?= $Page->STATUS_PASIEN_ID->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_STATUS_PASIEN_ID" data-page="1" name="x_STATUS_PASIEN_ID" id="x_STATUS_PASIEN_ID" size="30" placeholder="<?= HtmlEncode($Page->STATUS_PASIEN_ID->getPlaceHolder()) ?>" value="<?= $Page->STATUS_PASIEN_ID->EditValue ?>"<?= $Page->STATUS_PASIEN_ID->editAttributes() ?> aria-describedby="x_STATUS_PASIEN_ID_help">
<?= $Page->STATUS_PASIEN_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->STATUS_PASIEN_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->RUJUKAN_ID->Visible) { // RUJUKAN_ID ?>
    <div id="r_RUJUKAN_ID" class="form-group row">
        <label id="elh_V_FARMASI_RUJUKAN_ID" for="x_RUJUKAN_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->RUJUKAN_ID->caption() ?><?= $Page->RUJUKAN_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->RUJUKAN_ID->cellAttributes() ?>>
<span id="el_V_FARMASI_RUJUKAN_ID">
<input type="<?= $Page->RUJUKAN_ID->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_RUJUKAN_ID" data-page="1" name="x_RUJUKAN_ID" id="x_RUJUKAN_ID" size="30" placeholder="<?= HtmlEncode($Page->RUJUKAN_ID->getPlaceHolder()) ?>" value="<?= $Page->RUJUKAN_ID->EditValue ?>"<?= $Page->RUJUKAN_ID->editAttributes() ?> aria-describedby="x_RUJUKAN_ID_help">
<?= $Page->RUJUKAN_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->RUJUKAN_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ADDRESS_OF_RUJUKAN->Visible) { // ADDRESS_OF_RUJUKAN ?>
    <div id="r_ADDRESS_OF_RUJUKAN" class="form-group row">
        <label id="elh_V_FARMASI_ADDRESS_OF_RUJUKAN" for="x_ADDRESS_OF_RUJUKAN" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ADDRESS_OF_RUJUKAN->caption() ?><?= $Page->ADDRESS_OF_RUJUKAN->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ADDRESS_OF_RUJUKAN->cellAttributes() ?>>
<span id="el_V_FARMASI_ADDRESS_OF_RUJUKAN">
<input type="<?= $Page->ADDRESS_OF_RUJUKAN->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_ADDRESS_OF_RUJUKAN" data-page="1" name="x_ADDRESS_OF_RUJUKAN" id="x_ADDRESS_OF_RUJUKAN" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->ADDRESS_OF_RUJUKAN->getPlaceHolder()) ?>" value="<?= $Page->ADDRESS_OF_RUJUKAN->EditValue ?>"<?= $Page->ADDRESS_OF_RUJUKAN->editAttributes() ?> aria-describedby="x_ADDRESS_OF_RUJUKAN_help">
<?= $Page->ADDRESS_OF_RUJUKAN->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ADDRESS_OF_RUJUKAN->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->REASON_ID->Visible) { // REASON_ID ?>
    <div id="r_REASON_ID" class="form-group row">
        <label id="elh_V_FARMASI_REASON_ID" for="x_REASON_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->REASON_ID->caption() ?><?= $Page->REASON_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->REASON_ID->cellAttributes() ?>>
<span id="el_V_FARMASI_REASON_ID">
<input type="<?= $Page->REASON_ID->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_REASON_ID" data-page="1" name="x_REASON_ID" id="x_REASON_ID" size="30" placeholder="<?= HtmlEncode($Page->REASON_ID->getPlaceHolder()) ?>" value="<?= $Page->REASON_ID->EditValue ?>"<?= $Page->REASON_ID->editAttributes() ?> aria-describedby="x_REASON_ID_help">
<?= $Page->REASON_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->REASON_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->WAY_ID->Visible) { // WAY_ID ?>
    <div id="r_WAY_ID" class="form-group row">
        <label id="elh_V_FARMASI_WAY_ID" for="x_WAY_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->WAY_ID->caption() ?><?= $Page->WAY_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->WAY_ID->cellAttributes() ?>>
<span id="el_V_FARMASI_WAY_ID">
<input type="<?= $Page->WAY_ID->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_WAY_ID" data-page="1" name="x_WAY_ID" id="x_WAY_ID" size="30" placeholder="<?= HtmlEncode($Page->WAY_ID->getPlaceHolder()) ?>" value="<?= $Page->WAY_ID->EditValue ?>"<?= $Page->WAY_ID->editAttributes() ?> aria-describedby="x_WAY_ID_help">
<?= $Page->WAY_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->WAY_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->PATIENT_CATEGORY_ID->Visible) { // PATIENT_CATEGORY_ID ?>
    <div id="r_PATIENT_CATEGORY_ID" class="form-group row">
        <label id="elh_V_FARMASI_PATIENT_CATEGORY_ID" for="x_PATIENT_CATEGORY_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->PATIENT_CATEGORY_ID->caption() ?><?= $Page->PATIENT_CATEGORY_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PATIENT_CATEGORY_ID->cellAttributes() ?>>
<span id="el_V_FARMASI_PATIENT_CATEGORY_ID">
<input type="<?= $Page->PATIENT_CATEGORY_ID->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_PATIENT_CATEGORY_ID" data-page="1" name="x_PATIENT_CATEGORY_ID" id="x_PATIENT_CATEGORY_ID" size="30" placeholder="<?= HtmlEncode($Page->PATIENT_CATEGORY_ID->getPlaceHolder()) ?>" value="<?= $Page->PATIENT_CATEGORY_ID->EditValue ?>"<?= $Page->PATIENT_CATEGORY_ID->editAttributes() ?> aria-describedby="x_PATIENT_CATEGORY_ID_help">
<?= $Page->PATIENT_CATEGORY_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->PATIENT_CATEGORY_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->BOOKED_DATE->Visible) { // BOOKED_DATE ?>
    <div id="r_BOOKED_DATE" class="form-group row">
        <label id="elh_V_FARMASI_BOOKED_DATE" for="x_BOOKED_DATE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->BOOKED_DATE->caption() ?><?= $Page->BOOKED_DATE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->BOOKED_DATE->cellAttributes() ?>>
<span id="el_V_FARMASI_BOOKED_DATE">
<input type="<?= $Page->BOOKED_DATE->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_BOOKED_DATE" data-page="1" name="x_BOOKED_DATE" id="x_BOOKED_DATE" placeholder="<?= HtmlEncode($Page->BOOKED_DATE->getPlaceHolder()) ?>" value="<?= $Page->BOOKED_DATE->EditValue ?>"<?= $Page->BOOKED_DATE->editAttributes() ?> aria-describedby="x_BOOKED_DATE_help">
<?= $Page->BOOKED_DATE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->BOOKED_DATE->getErrorMessage() ?></div>
<?php if (!$Page->BOOKED_DATE->ReadOnly && !$Page->BOOKED_DATE->Disabled && !isset($Page->BOOKED_DATE->EditAttrs["readonly"]) && !isset($Page->BOOKED_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fV_FARMASIadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fV_FARMASIadd", "x_BOOKED_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->VISIT_DATE->Visible) { // VISIT_DATE ?>
    <div id="r_VISIT_DATE" class="form-group row">
        <label id="elh_V_FARMASI_VISIT_DATE" for="x_VISIT_DATE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->VISIT_DATE->caption() ?><?= $Page->VISIT_DATE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->VISIT_DATE->cellAttributes() ?>>
<span id="el_V_FARMASI_VISIT_DATE">
<input type="<?= $Page->VISIT_DATE->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_VISIT_DATE" data-page="1" name="x_VISIT_DATE" id="x_VISIT_DATE" placeholder="<?= HtmlEncode($Page->VISIT_DATE->getPlaceHolder()) ?>" value="<?= $Page->VISIT_DATE->EditValue ?>"<?= $Page->VISIT_DATE->editAttributes() ?> aria-describedby="x_VISIT_DATE_help">
<?= $Page->VISIT_DATE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->VISIT_DATE->getErrorMessage() ?></div>
<?php if (!$Page->VISIT_DATE->ReadOnly && !$Page->VISIT_DATE->Disabled && !isset($Page->VISIT_DATE->EditAttrs["readonly"]) && !isset($Page->VISIT_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fV_FARMASIadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fV_FARMASIadd", "x_VISIT_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ISNEW->Visible) { // ISNEW ?>
    <div id="r_ISNEW" class="form-group row">
        <label id="elh_V_FARMASI_ISNEW" for="x_ISNEW" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ISNEW->caption() ?><?= $Page->ISNEW->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ISNEW->cellAttributes() ?>>
<span id="el_V_FARMASI_ISNEW">
<input type="<?= $Page->ISNEW->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_ISNEW" data-page="1" name="x_ISNEW" id="x_ISNEW" size="30" maxlength="1" placeholder="<?= HtmlEncode($Page->ISNEW->getPlaceHolder()) ?>" value="<?= $Page->ISNEW->EditValue ?>"<?= $Page->ISNEW->editAttributes() ?> aria-describedby="x_ISNEW_help">
<?= $Page->ISNEW->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ISNEW->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->FOLLOW_UP->Visible) { // FOLLOW_UP ?>
    <div id="r_FOLLOW_UP" class="form-group row">
        <label id="elh_V_FARMASI_FOLLOW_UP" for="x_FOLLOW_UP" class="<?= $Page->LeftColumnClass ?>"><?= $Page->FOLLOW_UP->caption() ?><?= $Page->FOLLOW_UP->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->FOLLOW_UP->cellAttributes() ?>>
<span id="el_V_FARMASI_FOLLOW_UP">
<input type="<?= $Page->FOLLOW_UP->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_FOLLOW_UP" data-page="1" name="x_FOLLOW_UP" id="x_FOLLOW_UP" size="30" placeholder="<?= HtmlEncode($Page->FOLLOW_UP->getPlaceHolder()) ?>" value="<?= $Page->FOLLOW_UP->EditValue ?>"<?= $Page->FOLLOW_UP->editAttributes() ?> aria-describedby="x_FOLLOW_UP_help">
<?= $Page->FOLLOW_UP->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->FOLLOW_UP->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->PLACE_TYPE->Visible) { // PLACE_TYPE ?>
    <div id="r_PLACE_TYPE" class="form-group row">
        <label id="elh_V_FARMASI_PLACE_TYPE" for="x_PLACE_TYPE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->PLACE_TYPE->caption() ?><?= $Page->PLACE_TYPE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PLACE_TYPE->cellAttributes() ?>>
<span id="el_V_FARMASI_PLACE_TYPE">
<input type="<?= $Page->PLACE_TYPE->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_PLACE_TYPE" data-page="1" name="x_PLACE_TYPE" id="x_PLACE_TYPE" size="30" placeholder="<?= HtmlEncode($Page->PLACE_TYPE->getPlaceHolder()) ?>" value="<?= $Page->PLACE_TYPE->EditValue ?>"<?= $Page->PLACE_TYPE->editAttributes() ?> aria-describedby="x_PLACE_TYPE_help">
<?= $Page->PLACE_TYPE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->PLACE_TYPE->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->CLINIC_ID->Visible) { // CLINIC_ID ?>
    <div id="r_CLINIC_ID" class="form-group row">
        <label id="elh_V_FARMASI_CLINIC_ID" for="x_CLINIC_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->CLINIC_ID->caption() ?><?= $Page->CLINIC_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->CLINIC_ID->cellAttributes() ?>>
<span id="el_V_FARMASI_CLINIC_ID">
<input type="<?= $Page->CLINIC_ID->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_CLINIC_ID" data-page="1" name="x_CLINIC_ID" id="x_CLINIC_ID" size="30" maxlength="8" placeholder="<?= HtmlEncode($Page->CLINIC_ID->getPlaceHolder()) ?>" value="<?= $Page->CLINIC_ID->EditValue ?>"<?= $Page->CLINIC_ID->editAttributes() ?> aria-describedby="x_CLINIC_ID_help">
<?= $Page->CLINIC_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->CLINIC_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->CLINIC_ID_FROM->Visible) { // CLINIC_ID_FROM ?>
    <div id="r_CLINIC_ID_FROM" class="form-group row">
        <label id="elh_V_FARMASI_CLINIC_ID_FROM" for="x_CLINIC_ID_FROM" class="<?= $Page->LeftColumnClass ?>"><?= $Page->CLINIC_ID_FROM->caption() ?><?= $Page->CLINIC_ID_FROM->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->CLINIC_ID_FROM->cellAttributes() ?>>
<span id="el_V_FARMASI_CLINIC_ID_FROM">
<input type="<?= $Page->CLINIC_ID_FROM->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_CLINIC_ID_FROM" data-page="1" name="x_CLINIC_ID_FROM" id="x_CLINIC_ID_FROM" size="30" maxlength="8" placeholder="<?= HtmlEncode($Page->CLINIC_ID_FROM->getPlaceHolder()) ?>" value="<?= $Page->CLINIC_ID_FROM->EditValue ?>"<?= $Page->CLINIC_ID_FROM->editAttributes() ?> aria-describedby="x_CLINIC_ID_FROM_help">
<?= $Page->CLINIC_ID_FROM->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->CLINIC_ID_FROM->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->CLASS_ROOM_ID->Visible) { // CLASS_ROOM_ID ?>
    <div id="r_CLASS_ROOM_ID" class="form-group row">
        <label id="elh_V_FARMASI_CLASS_ROOM_ID" for="x_CLASS_ROOM_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->CLASS_ROOM_ID->caption() ?><?= $Page->CLASS_ROOM_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->CLASS_ROOM_ID->cellAttributes() ?>>
<span id="el_V_FARMASI_CLASS_ROOM_ID">
<input type="<?= $Page->CLASS_ROOM_ID->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_CLASS_ROOM_ID" data-page="1" name="x_CLASS_ROOM_ID" id="x_CLASS_ROOM_ID" size="30" maxlength="16" placeholder="<?= HtmlEncode($Page->CLASS_ROOM_ID->getPlaceHolder()) ?>" value="<?= $Page->CLASS_ROOM_ID->EditValue ?>"<?= $Page->CLASS_ROOM_ID->editAttributes() ?> aria-describedby="x_CLASS_ROOM_ID_help">
<?= $Page->CLASS_ROOM_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->CLASS_ROOM_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->BED_ID->Visible) { // BED_ID ?>
    <div id="r_BED_ID" class="form-group row">
        <label id="elh_V_FARMASI_BED_ID" for="x_BED_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->BED_ID->caption() ?><?= $Page->BED_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->BED_ID->cellAttributes() ?>>
<span id="el_V_FARMASI_BED_ID">
<input type="<?= $Page->BED_ID->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_BED_ID" data-page="1" name="x_BED_ID" id="x_BED_ID" size="30" placeholder="<?= HtmlEncode($Page->BED_ID->getPlaceHolder()) ?>" value="<?= $Page->BED_ID->EditValue ?>"<?= $Page->BED_ID->editAttributes() ?> aria-describedby="x_BED_ID_help">
<?= $Page->BED_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->BED_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->KELUAR_ID->Visible) { // KELUAR_ID ?>
    <div id="r_KELUAR_ID" class="form-group row">
        <label id="elh_V_FARMASI_KELUAR_ID" for="x_KELUAR_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->KELUAR_ID->caption() ?><?= $Page->KELUAR_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->KELUAR_ID->cellAttributes() ?>>
<span id="el_V_FARMASI_KELUAR_ID">
<input type="<?= $Page->KELUAR_ID->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_KELUAR_ID" data-page="1" name="x_KELUAR_ID" id="x_KELUAR_ID" size="30" placeholder="<?= HtmlEncode($Page->KELUAR_ID->getPlaceHolder()) ?>" value="<?= $Page->KELUAR_ID->EditValue ?>"<?= $Page->KELUAR_ID->editAttributes() ?> aria-describedby="x_KELUAR_ID_help">
<?= $Page->KELUAR_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->KELUAR_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->IN_DATE->Visible) { // IN_DATE ?>
    <div id="r_IN_DATE" class="form-group row">
        <label id="elh_V_FARMASI_IN_DATE" for="x_IN_DATE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->IN_DATE->caption() ?><?= $Page->IN_DATE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->IN_DATE->cellAttributes() ?>>
<span id="el_V_FARMASI_IN_DATE">
<input type="<?= $Page->IN_DATE->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_IN_DATE" data-page="1" name="x_IN_DATE" id="x_IN_DATE" placeholder="<?= HtmlEncode($Page->IN_DATE->getPlaceHolder()) ?>" value="<?= $Page->IN_DATE->EditValue ?>"<?= $Page->IN_DATE->editAttributes() ?> aria-describedby="x_IN_DATE_help">
<?= $Page->IN_DATE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->IN_DATE->getErrorMessage() ?></div>
<?php if (!$Page->IN_DATE->ReadOnly && !$Page->IN_DATE->Disabled && !isset($Page->IN_DATE->EditAttrs["readonly"]) && !isset($Page->IN_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fV_FARMASIadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fV_FARMASIadd", "x_IN_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->EXIT_DATE->Visible) { // EXIT_DATE ?>
    <div id="r_EXIT_DATE" class="form-group row">
        <label id="elh_V_FARMASI_EXIT_DATE" for="x_EXIT_DATE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->EXIT_DATE->caption() ?><?= $Page->EXIT_DATE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->EXIT_DATE->cellAttributes() ?>>
<span id="el_V_FARMASI_EXIT_DATE">
<input type="<?= $Page->EXIT_DATE->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_EXIT_DATE" data-page="1" name="x_EXIT_DATE" id="x_EXIT_DATE" placeholder="<?= HtmlEncode($Page->EXIT_DATE->getPlaceHolder()) ?>" value="<?= $Page->EXIT_DATE->EditValue ?>"<?= $Page->EXIT_DATE->editAttributes() ?> aria-describedby="x_EXIT_DATE_help">
<?= $Page->EXIT_DATE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->EXIT_DATE->getErrorMessage() ?></div>
<?php if (!$Page->EXIT_DATE->ReadOnly && !$Page->EXIT_DATE->Disabled && !isset($Page->EXIT_DATE->EditAttrs["readonly"]) && !isset($Page->EXIT_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fV_FARMASIadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fV_FARMASIadd", "x_EXIT_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->DIANTAR_OLEH->Visible) { // DIANTAR_OLEH ?>
    <div id="r_DIANTAR_OLEH" class="form-group row">
        <label id="elh_V_FARMASI_DIANTAR_OLEH" for="x_DIANTAR_OLEH" class="<?= $Page->LeftColumnClass ?>"><?= $Page->DIANTAR_OLEH->caption() ?><?= $Page->DIANTAR_OLEH->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->DIANTAR_OLEH->cellAttributes() ?>>
<span id="el_V_FARMASI_DIANTAR_OLEH">
<input type="<?= $Page->DIANTAR_OLEH->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_DIANTAR_OLEH" data-page="1" name="x_DIANTAR_OLEH" id="x_DIANTAR_OLEH" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->DIANTAR_OLEH->getPlaceHolder()) ?>" value="<?= $Page->DIANTAR_OLEH->EditValue ?>"<?= $Page->DIANTAR_OLEH->editAttributes() ?> aria-describedby="x_DIANTAR_OLEH_help">
<?= $Page->DIANTAR_OLEH->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->DIANTAR_OLEH->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->GENDER->Visible) { // GENDER ?>
    <div id="r_GENDER" class="form-group row">
        <label id="elh_V_FARMASI_GENDER" for="x_GENDER" class="<?= $Page->LeftColumnClass ?>"><?= $Page->GENDER->caption() ?><?= $Page->GENDER->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->GENDER->cellAttributes() ?>>
<span id="el_V_FARMASI_GENDER">
<input type="<?= $Page->GENDER->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_GENDER" data-page="1" name="x_GENDER" id="x_GENDER" size="30" maxlength="1" placeholder="<?= HtmlEncode($Page->GENDER->getPlaceHolder()) ?>" value="<?= $Page->GENDER->EditValue ?>"<?= $Page->GENDER->editAttributes() ?> aria-describedby="x_GENDER_help">
<?= $Page->GENDER->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->GENDER->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->DESCRIPTION->Visible) { // DESCRIPTION ?>
    <div id="r_DESCRIPTION" class="form-group row">
        <label id="elh_V_FARMASI_DESCRIPTION" for="x_DESCRIPTION" class="<?= $Page->LeftColumnClass ?>"><?= $Page->DESCRIPTION->caption() ?><?= $Page->DESCRIPTION->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->DESCRIPTION->cellAttributes() ?>>
<span id="el_V_FARMASI_DESCRIPTION">
<input type="<?= $Page->DESCRIPTION->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_DESCRIPTION" data-page="1" name="x_DESCRIPTION" id="x_DESCRIPTION" size="30" maxlength="200" placeholder="<?= HtmlEncode($Page->DESCRIPTION->getPlaceHolder()) ?>" value="<?= $Page->DESCRIPTION->EditValue ?>"<?= $Page->DESCRIPTION->editAttributes() ?> aria-describedby="x_DESCRIPTION_help">
<?= $Page->DESCRIPTION->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->DESCRIPTION->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->VISITOR_ADDRESS->Visible) { // VISITOR_ADDRESS ?>
    <div id="r_VISITOR_ADDRESS" class="form-group row">
        <label id="elh_V_FARMASI_VISITOR_ADDRESS" for="x_VISITOR_ADDRESS" class="<?= $Page->LeftColumnClass ?>"><?= $Page->VISITOR_ADDRESS->caption() ?><?= $Page->VISITOR_ADDRESS->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->VISITOR_ADDRESS->cellAttributes() ?>>
<span id="el_V_FARMASI_VISITOR_ADDRESS">
<input type="<?= $Page->VISITOR_ADDRESS->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_VISITOR_ADDRESS" data-page="1" name="x_VISITOR_ADDRESS" id="x_VISITOR_ADDRESS" size="30" maxlength="150" placeholder="<?= HtmlEncode($Page->VISITOR_ADDRESS->getPlaceHolder()) ?>" value="<?= $Page->VISITOR_ADDRESS->EditValue ?>"<?= $Page->VISITOR_ADDRESS->editAttributes() ?> aria-describedby="x_VISITOR_ADDRESS_help">
<?= $Page->VISITOR_ADDRESS->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->VISITOR_ADDRESS->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
    <div id="r_MODIFIED_BY" class="form-group row">
        <label id="elh_V_FARMASI_MODIFIED_BY" for="x_MODIFIED_BY" class="<?= $Page->LeftColumnClass ?>"><?= $Page->MODIFIED_BY->caption() ?><?= $Page->MODIFIED_BY->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->MODIFIED_BY->cellAttributes() ?>>
<span id="el_V_FARMASI_MODIFIED_BY">
<input type="<?= $Page->MODIFIED_BY->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_MODIFIED_BY" data-page="1" name="x_MODIFIED_BY" id="x_MODIFIED_BY" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->MODIFIED_BY->getPlaceHolder()) ?>" value="<?= $Page->MODIFIED_BY->EditValue ?>"<?= $Page->MODIFIED_BY->editAttributes() ?> aria-describedby="x_MODIFIED_BY_help">
<?= $Page->MODIFIED_BY->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->MODIFIED_BY->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
    <div id="r_MODIFIED_DATE" class="form-group row">
        <label id="elh_V_FARMASI_MODIFIED_DATE" for="x_MODIFIED_DATE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->MODIFIED_DATE->caption() ?><?= $Page->MODIFIED_DATE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->MODIFIED_DATE->cellAttributes() ?>>
<span id="el_V_FARMASI_MODIFIED_DATE">
<input type="<?= $Page->MODIFIED_DATE->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_MODIFIED_DATE" data-page="1" name="x_MODIFIED_DATE" id="x_MODIFIED_DATE" placeholder="<?= HtmlEncode($Page->MODIFIED_DATE->getPlaceHolder()) ?>" value="<?= $Page->MODIFIED_DATE->EditValue ?>"<?= $Page->MODIFIED_DATE->editAttributes() ?> aria-describedby="x_MODIFIED_DATE_help">
<?= $Page->MODIFIED_DATE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->MODIFIED_DATE->getErrorMessage() ?></div>
<?php if (!$Page->MODIFIED_DATE->ReadOnly && !$Page->MODIFIED_DATE->Disabled && !isset($Page->MODIFIED_DATE->EditAttrs["readonly"]) && !isset($Page->MODIFIED_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fV_FARMASIadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fV_FARMASIadd", "x_MODIFIED_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->MODIFIED_FROM->Visible) { // MODIFIED_FROM ?>
    <div id="r_MODIFIED_FROM" class="form-group row">
        <label id="elh_V_FARMASI_MODIFIED_FROM" for="x_MODIFIED_FROM" class="<?= $Page->LeftColumnClass ?>"><?= $Page->MODIFIED_FROM->caption() ?><?= $Page->MODIFIED_FROM->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->MODIFIED_FROM->cellAttributes() ?>>
<span id="el_V_FARMASI_MODIFIED_FROM">
<input type="<?= $Page->MODIFIED_FROM->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_MODIFIED_FROM" data-page="1" name="x_MODIFIED_FROM" id="x_MODIFIED_FROM" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->MODIFIED_FROM->getPlaceHolder()) ?>" value="<?= $Page->MODIFIED_FROM->EditValue ?>"<?= $Page->MODIFIED_FROM->editAttributes() ?> aria-describedby="x_MODIFIED_FROM_help">
<?= $Page->MODIFIED_FROM->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->MODIFIED_FROM->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->EMPLOYEE_ID->Visible) { // EMPLOYEE_ID ?>
    <div id="r_EMPLOYEE_ID" class="form-group row">
        <label id="elh_V_FARMASI_EMPLOYEE_ID" for="x_EMPLOYEE_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->EMPLOYEE_ID->caption() ?><?= $Page->EMPLOYEE_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->EMPLOYEE_ID->cellAttributes() ?>>
<span id="el_V_FARMASI_EMPLOYEE_ID">
<input type="<?= $Page->EMPLOYEE_ID->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_EMPLOYEE_ID" data-page="1" name="x_EMPLOYEE_ID" id="x_EMPLOYEE_ID" size="30" maxlength="15" placeholder="<?= HtmlEncode($Page->EMPLOYEE_ID->getPlaceHolder()) ?>" value="<?= $Page->EMPLOYEE_ID->EditValue ?>"<?= $Page->EMPLOYEE_ID->editAttributes() ?> aria-describedby="x_EMPLOYEE_ID_help">
<?= $Page->EMPLOYEE_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->EMPLOYEE_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->EMPLOYEE_ID_FROM->Visible) { // EMPLOYEE_ID_FROM ?>
    <div id="r_EMPLOYEE_ID_FROM" class="form-group row">
        <label id="elh_V_FARMASI_EMPLOYEE_ID_FROM" for="x_EMPLOYEE_ID_FROM" class="<?= $Page->LeftColumnClass ?>"><?= $Page->EMPLOYEE_ID_FROM->caption() ?><?= $Page->EMPLOYEE_ID_FROM->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->EMPLOYEE_ID_FROM->cellAttributes() ?>>
<span id="el_V_FARMASI_EMPLOYEE_ID_FROM">
<input type="<?= $Page->EMPLOYEE_ID_FROM->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_EMPLOYEE_ID_FROM" data-page="1" name="x_EMPLOYEE_ID_FROM" id="x_EMPLOYEE_ID_FROM" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->EMPLOYEE_ID_FROM->getPlaceHolder()) ?>" value="<?= $Page->EMPLOYEE_ID_FROM->EditValue ?>"<?= $Page->EMPLOYEE_ID_FROM->editAttributes() ?> aria-describedby="x_EMPLOYEE_ID_FROM_help">
<?= $Page->EMPLOYEE_ID_FROM->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->EMPLOYEE_ID_FROM->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->RESPONSIBLE_ID->Visible) { // RESPONSIBLE_ID ?>
    <div id="r_RESPONSIBLE_ID" class="form-group row">
        <label id="elh_V_FARMASI_RESPONSIBLE_ID" for="x_RESPONSIBLE_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->RESPONSIBLE_ID->caption() ?><?= $Page->RESPONSIBLE_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->RESPONSIBLE_ID->cellAttributes() ?>>
<span id="el_V_FARMASI_RESPONSIBLE_ID">
<input type="<?= $Page->RESPONSIBLE_ID->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_RESPONSIBLE_ID" data-page="1" name="x_RESPONSIBLE_ID" id="x_RESPONSIBLE_ID" size="30" placeholder="<?= HtmlEncode($Page->RESPONSIBLE_ID->getPlaceHolder()) ?>" value="<?= $Page->RESPONSIBLE_ID->EditValue ?>"<?= $Page->RESPONSIBLE_ID->editAttributes() ?> aria-describedby="x_RESPONSIBLE_ID_help">
<?= $Page->RESPONSIBLE_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->RESPONSIBLE_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->RESPONSIBLE->Visible) { // RESPONSIBLE ?>
    <div id="r_RESPONSIBLE" class="form-group row">
        <label id="elh_V_FARMASI_RESPONSIBLE" for="x_RESPONSIBLE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->RESPONSIBLE->caption() ?><?= $Page->RESPONSIBLE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->RESPONSIBLE->cellAttributes() ?>>
<span id="el_V_FARMASI_RESPONSIBLE">
<input type="<?= $Page->RESPONSIBLE->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_RESPONSIBLE" data-page="1" name="x_RESPONSIBLE" id="x_RESPONSIBLE" size="30" maxlength="150" placeholder="<?= HtmlEncode($Page->RESPONSIBLE->getPlaceHolder()) ?>" value="<?= $Page->RESPONSIBLE->EditValue ?>"<?= $Page->RESPONSIBLE->editAttributes() ?> aria-describedby="x_RESPONSIBLE_help">
<?= $Page->RESPONSIBLE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->RESPONSIBLE->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->FAMILY_STATUS_ID->Visible) { // FAMILY_STATUS_ID ?>
    <div id="r_FAMILY_STATUS_ID" class="form-group row">
        <label id="elh_V_FARMASI_FAMILY_STATUS_ID" for="x_FAMILY_STATUS_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->FAMILY_STATUS_ID->caption() ?><?= $Page->FAMILY_STATUS_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->FAMILY_STATUS_ID->cellAttributes() ?>>
<span id="el_V_FARMASI_FAMILY_STATUS_ID">
<input type="<?= $Page->FAMILY_STATUS_ID->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_FAMILY_STATUS_ID" data-page="1" name="x_FAMILY_STATUS_ID" id="x_FAMILY_STATUS_ID" size="30" placeholder="<?= HtmlEncode($Page->FAMILY_STATUS_ID->getPlaceHolder()) ?>" value="<?= $Page->FAMILY_STATUS_ID->EditValue ?>"<?= $Page->FAMILY_STATUS_ID->editAttributes() ?> aria-describedby="x_FAMILY_STATUS_ID_help">
<?= $Page->FAMILY_STATUS_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->FAMILY_STATUS_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->TICKET_NO->Visible) { // TICKET_NO ?>
    <div id="r_TICKET_NO" class="form-group row">
        <label id="elh_V_FARMASI_TICKET_NO" for="x_TICKET_NO" class="<?= $Page->LeftColumnClass ?>"><?= $Page->TICKET_NO->caption() ?><?= $Page->TICKET_NO->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->TICKET_NO->cellAttributes() ?>>
<span id="el_V_FARMASI_TICKET_NO">
<input type="<?= $Page->TICKET_NO->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_TICKET_NO" data-page="1" name="x_TICKET_NO" id="x_TICKET_NO" size="30" placeholder="<?= HtmlEncode($Page->TICKET_NO->getPlaceHolder()) ?>" value="<?= $Page->TICKET_NO->EditValue ?>"<?= $Page->TICKET_NO->editAttributes() ?> aria-describedby="x_TICKET_NO_help">
<?= $Page->TICKET_NO->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->TICKET_NO->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ISATTENDED->Visible) { // ISATTENDED ?>
    <div id="r_ISATTENDED" class="form-group row">
        <label id="elh_V_FARMASI_ISATTENDED" for="x_ISATTENDED" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ISATTENDED->caption() ?><?= $Page->ISATTENDED->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ISATTENDED->cellAttributes() ?>>
<span id="el_V_FARMASI_ISATTENDED">
<input type="<?= $Page->ISATTENDED->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_ISATTENDED" data-page="1" name="x_ISATTENDED" id="x_ISATTENDED" size="30" maxlength="1" placeholder="<?= HtmlEncode($Page->ISATTENDED->getPlaceHolder()) ?>" value="<?= $Page->ISATTENDED->EditValue ?>"<?= $Page->ISATTENDED->editAttributes() ?> aria-describedby="x_ISATTENDED_help">
<?= $Page->ISATTENDED->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ISATTENDED->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->PAYOR_ID->Visible) { // PAYOR_ID ?>
    <div id="r_PAYOR_ID" class="form-group row">
        <label id="elh_V_FARMASI_PAYOR_ID" for="x_PAYOR_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->PAYOR_ID->caption() ?><?= $Page->PAYOR_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PAYOR_ID->cellAttributes() ?>>
<span id="el_V_FARMASI_PAYOR_ID">
<input type="<?= $Page->PAYOR_ID->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_PAYOR_ID" data-page="1" name="x_PAYOR_ID" id="x_PAYOR_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->PAYOR_ID->getPlaceHolder()) ?>" value="<?= $Page->PAYOR_ID->EditValue ?>"<?= $Page->PAYOR_ID->editAttributes() ?> aria-describedby="x_PAYOR_ID_help">
<?= $Page->PAYOR_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->PAYOR_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->CLASS_ID->Visible) { // CLASS_ID ?>
    <div id="r_CLASS_ID" class="form-group row">
        <label id="elh_V_FARMASI_CLASS_ID" for="x_CLASS_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->CLASS_ID->caption() ?><?= $Page->CLASS_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->CLASS_ID->cellAttributes() ?>>
<span id="el_V_FARMASI_CLASS_ID">
<input type="<?= $Page->CLASS_ID->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_CLASS_ID" data-page="1" name="x_CLASS_ID" id="x_CLASS_ID" size="30" placeholder="<?= HtmlEncode($Page->CLASS_ID->getPlaceHolder()) ?>" value="<?= $Page->CLASS_ID->EditValue ?>"<?= $Page->CLASS_ID->editAttributes() ?> aria-describedby="x_CLASS_ID_help">
<?= $Page->CLASS_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->CLASS_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ISPERTARIF->Visible) { // ISPERTARIF ?>
    <div id="r_ISPERTARIF" class="form-group row">
        <label id="elh_V_FARMASI_ISPERTARIF" for="x_ISPERTARIF" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ISPERTARIF->caption() ?><?= $Page->ISPERTARIF->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ISPERTARIF->cellAttributes() ?>>
<span id="el_V_FARMASI_ISPERTARIF">
<input type="<?= $Page->ISPERTARIF->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_ISPERTARIF" data-page="1" name="x_ISPERTARIF" id="x_ISPERTARIF" size="30" maxlength="1" placeholder="<?= HtmlEncode($Page->ISPERTARIF->getPlaceHolder()) ?>" value="<?= $Page->ISPERTARIF->EditValue ?>"<?= $Page->ISPERTARIF->editAttributes() ?> aria-describedby="x_ISPERTARIF_help">
<?= $Page->ISPERTARIF->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ISPERTARIF->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->KAL_ID->Visible) { // KAL_ID ?>
    <div id="r_KAL_ID" class="form-group row">
        <label id="elh_V_FARMASI_KAL_ID" for="x_KAL_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->KAL_ID->caption() ?><?= $Page->KAL_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->KAL_ID->cellAttributes() ?>>
<span id="el_V_FARMASI_KAL_ID">
<input type="<?= $Page->KAL_ID->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_KAL_ID" data-page="1" name="x_KAL_ID" id="x_KAL_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->KAL_ID->getPlaceHolder()) ?>" value="<?= $Page->KAL_ID->EditValue ?>"<?= $Page->KAL_ID->editAttributes() ?> aria-describedby="x_KAL_ID_help">
<?= $Page->KAL_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->KAL_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->EMPLOYEE_INAP->Visible) { // EMPLOYEE_INAP ?>
    <div id="r_EMPLOYEE_INAP" class="form-group row">
        <label id="elh_V_FARMASI_EMPLOYEE_INAP" for="x_EMPLOYEE_INAP" class="<?= $Page->LeftColumnClass ?>"><?= $Page->EMPLOYEE_INAP->caption() ?><?= $Page->EMPLOYEE_INAP->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->EMPLOYEE_INAP->cellAttributes() ?>>
<span id="el_V_FARMASI_EMPLOYEE_INAP">
<input type="<?= $Page->EMPLOYEE_INAP->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_EMPLOYEE_INAP" data-page="1" name="x_EMPLOYEE_INAP" id="x_EMPLOYEE_INAP" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->EMPLOYEE_INAP->getPlaceHolder()) ?>" value="<?= $Page->EMPLOYEE_INAP->EditValue ?>"<?= $Page->EMPLOYEE_INAP->editAttributes() ?> aria-describedby="x_EMPLOYEE_INAP_help">
<?= $Page->EMPLOYEE_INAP->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->EMPLOYEE_INAP->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->PASIEN_ID->Visible) { // PASIEN_ID ?>
    <div id="r_PASIEN_ID" class="form-group row">
        <label id="elh_V_FARMASI_PASIEN_ID" for="x_PASIEN_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->PASIEN_ID->caption() ?><?= $Page->PASIEN_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PASIEN_ID->cellAttributes() ?>>
<span id="el_V_FARMASI_PASIEN_ID">
<input type="<?= $Page->PASIEN_ID->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_PASIEN_ID" data-page="1" name="x_PASIEN_ID" id="x_PASIEN_ID" size="30" maxlength="30" placeholder="<?= HtmlEncode($Page->PASIEN_ID->getPlaceHolder()) ?>" value="<?= $Page->PASIEN_ID->EditValue ?>"<?= $Page->PASIEN_ID->editAttributes() ?> aria-describedby="x_PASIEN_ID_help">
<?= $Page->PASIEN_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->PASIEN_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->KARYAWAN->Visible) { // KARYAWAN ?>
    <div id="r_KARYAWAN" class="form-group row">
        <label id="elh_V_FARMASI_KARYAWAN" for="x_KARYAWAN" class="<?= $Page->LeftColumnClass ?>"><?= $Page->KARYAWAN->caption() ?><?= $Page->KARYAWAN->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->KARYAWAN->cellAttributes() ?>>
<span id="el_V_FARMASI_KARYAWAN">
<input type="<?= $Page->KARYAWAN->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_KARYAWAN" data-page="1" name="x_KARYAWAN" id="x_KARYAWAN" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->KARYAWAN->getPlaceHolder()) ?>" value="<?= $Page->KARYAWAN->EditValue ?>"<?= $Page->KARYAWAN->editAttributes() ?> aria-describedby="x_KARYAWAN_help">
<?= $Page->KARYAWAN->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->KARYAWAN->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ACCOUNT_ID->Visible) { // ACCOUNT_ID ?>
    <div id="r_ACCOUNT_ID" class="form-group row">
        <label id="elh_V_FARMASI_ACCOUNT_ID" for="x_ACCOUNT_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ACCOUNT_ID->caption() ?><?= $Page->ACCOUNT_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ACCOUNT_ID->cellAttributes() ?>>
<span id="el_V_FARMASI_ACCOUNT_ID">
<input type="<?= $Page->ACCOUNT_ID->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_ACCOUNT_ID" data-page="1" name="x_ACCOUNT_ID" id="x_ACCOUNT_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->ACCOUNT_ID->getPlaceHolder()) ?>" value="<?= $Page->ACCOUNT_ID->EditValue ?>"<?= $Page->ACCOUNT_ID->editAttributes() ?> aria-describedby="x_ACCOUNT_ID_help">
<?= $Page->ACCOUNT_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ACCOUNT_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->CLASS_ID_PLAFOND->Visible) { // CLASS_ID_PLAFOND ?>
    <div id="r_CLASS_ID_PLAFOND" class="form-group row">
        <label id="elh_V_FARMASI_CLASS_ID_PLAFOND" for="x_CLASS_ID_PLAFOND" class="<?= $Page->LeftColumnClass ?>"><?= $Page->CLASS_ID_PLAFOND->caption() ?><?= $Page->CLASS_ID_PLAFOND->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->CLASS_ID_PLAFOND->cellAttributes() ?>>
<span id="el_V_FARMASI_CLASS_ID_PLAFOND">
<input type="<?= $Page->CLASS_ID_PLAFOND->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_CLASS_ID_PLAFOND" data-page="1" name="x_CLASS_ID_PLAFOND" id="x_CLASS_ID_PLAFOND" size="30" placeholder="<?= HtmlEncode($Page->CLASS_ID_PLAFOND->getPlaceHolder()) ?>" value="<?= $Page->CLASS_ID_PLAFOND->EditValue ?>"<?= $Page->CLASS_ID_PLAFOND->editAttributes() ?> aria-describedby="x_CLASS_ID_PLAFOND_help">
<?= $Page->CLASS_ID_PLAFOND->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->CLASS_ID_PLAFOND->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->BACKCHARGE->Visible) { // BACKCHARGE ?>
    <div id="r_BACKCHARGE" class="form-group row">
        <label id="elh_V_FARMASI_BACKCHARGE" for="x_BACKCHARGE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->BACKCHARGE->caption() ?><?= $Page->BACKCHARGE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->BACKCHARGE->cellAttributes() ?>>
<span id="el_V_FARMASI_BACKCHARGE">
<input type="<?= $Page->BACKCHARGE->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_BACKCHARGE" data-page="1" name="x_BACKCHARGE" id="x_BACKCHARGE" size="30" maxlength="1" placeholder="<?= HtmlEncode($Page->BACKCHARGE->getPlaceHolder()) ?>" value="<?= $Page->BACKCHARGE->EditValue ?>"<?= $Page->BACKCHARGE->editAttributes() ?> aria-describedby="x_BACKCHARGE_help">
<?= $Page->BACKCHARGE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->BACKCHARGE->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->COVERAGE_ID->Visible) { // COVERAGE_ID ?>
    <div id="r_COVERAGE_ID" class="form-group row">
        <label id="elh_V_FARMASI_COVERAGE_ID" for="x_COVERAGE_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->COVERAGE_ID->caption() ?><?= $Page->COVERAGE_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->COVERAGE_ID->cellAttributes() ?>>
<span id="el_V_FARMASI_COVERAGE_ID">
<input type="<?= $Page->COVERAGE_ID->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_COVERAGE_ID" data-page="1" name="x_COVERAGE_ID" id="x_COVERAGE_ID" size="30" placeholder="<?= HtmlEncode($Page->COVERAGE_ID->getPlaceHolder()) ?>" value="<?= $Page->COVERAGE_ID->EditValue ?>"<?= $Page->COVERAGE_ID->editAttributes() ?> aria-describedby="x_COVERAGE_ID_help">
<?= $Page->COVERAGE_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->COVERAGE_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->AGEYEAR->Visible) { // AGEYEAR ?>
    <div id="r_AGEYEAR" class="form-group row">
        <label id="elh_V_FARMASI_AGEYEAR" for="x_AGEYEAR" class="<?= $Page->LeftColumnClass ?>"><?= $Page->AGEYEAR->caption() ?><?= $Page->AGEYEAR->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->AGEYEAR->cellAttributes() ?>>
<span id="el_V_FARMASI_AGEYEAR">
<input type="<?= $Page->AGEYEAR->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_AGEYEAR" data-page="1" name="x_AGEYEAR" id="x_AGEYEAR" size="30" placeholder="<?= HtmlEncode($Page->AGEYEAR->getPlaceHolder()) ?>" value="<?= $Page->AGEYEAR->EditValue ?>"<?= $Page->AGEYEAR->editAttributes() ?> aria-describedby="x_AGEYEAR_help">
<?= $Page->AGEYEAR->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->AGEYEAR->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->AGEMONTH->Visible) { // AGEMONTH ?>
    <div id="r_AGEMONTH" class="form-group row">
        <label id="elh_V_FARMASI_AGEMONTH" for="x_AGEMONTH" class="<?= $Page->LeftColumnClass ?>"><?= $Page->AGEMONTH->caption() ?><?= $Page->AGEMONTH->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->AGEMONTH->cellAttributes() ?>>
<span id="el_V_FARMASI_AGEMONTH">
<input type="<?= $Page->AGEMONTH->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_AGEMONTH" data-page="1" name="x_AGEMONTH" id="x_AGEMONTH" size="30" placeholder="<?= HtmlEncode($Page->AGEMONTH->getPlaceHolder()) ?>" value="<?= $Page->AGEMONTH->EditValue ?>"<?= $Page->AGEMONTH->editAttributes() ?> aria-describedby="x_AGEMONTH_help">
<?= $Page->AGEMONTH->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->AGEMONTH->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->AGEDAY->Visible) { // AGEDAY ?>
    <div id="r_AGEDAY" class="form-group row">
        <label id="elh_V_FARMASI_AGEDAY" for="x_AGEDAY" class="<?= $Page->LeftColumnClass ?>"><?= $Page->AGEDAY->caption() ?><?= $Page->AGEDAY->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->AGEDAY->cellAttributes() ?>>
<span id="el_V_FARMASI_AGEDAY">
<input type="<?= $Page->AGEDAY->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_AGEDAY" data-page="1" name="x_AGEDAY" id="x_AGEDAY" size="30" placeholder="<?= HtmlEncode($Page->AGEDAY->getPlaceHolder()) ?>" value="<?= $Page->AGEDAY->EditValue ?>"<?= $Page->AGEDAY->editAttributes() ?> aria-describedby="x_AGEDAY_help">
<?= $Page->AGEDAY->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->AGEDAY->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->RECOMENDATION->Visible) { // RECOMENDATION ?>
    <div id="r_RECOMENDATION" class="form-group row">
        <label id="elh_V_FARMASI_RECOMENDATION" for="x_RECOMENDATION" class="<?= $Page->LeftColumnClass ?>"><?= $Page->RECOMENDATION->caption() ?><?= $Page->RECOMENDATION->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->RECOMENDATION->cellAttributes() ?>>
<span id="el_V_FARMASI_RECOMENDATION">
<input type="<?= $Page->RECOMENDATION->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_RECOMENDATION" data-page="1" name="x_RECOMENDATION" id="x_RECOMENDATION" size="30" maxlength="8000" placeholder="<?= HtmlEncode($Page->RECOMENDATION->getPlaceHolder()) ?>" value="<?= $Page->RECOMENDATION->EditValue ?>"<?= $Page->RECOMENDATION->editAttributes() ?> aria-describedby="x_RECOMENDATION_help">
<?= $Page->RECOMENDATION->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->RECOMENDATION->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->CONCLUSION->Visible) { // CONCLUSION ?>
    <div id="r_CONCLUSION" class="form-group row">
        <label id="elh_V_FARMASI_CONCLUSION" for="x_CONCLUSION" class="<?= $Page->LeftColumnClass ?>"><?= $Page->CONCLUSION->caption() ?><?= $Page->CONCLUSION->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->CONCLUSION->cellAttributes() ?>>
<span id="el_V_FARMASI_CONCLUSION">
<input type="<?= $Page->CONCLUSION->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_CONCLUSION" data-page="1" name="x_CONCLUSION" id="x_CONCLUSION" size="30" maxlength="8000" placeholder="<?= HtmlEncode($Page->CONCLUSION->getPlaceHolder()) ?>" value="<?= $Page->CONCLUSION->EditValue ?>"<?= $Page->CONCLUSION->editAttributes() ?> aria-describedby="x_CONCLUSION_help">
<?= $Page->CONCLUSION->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->CONCLUSION->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->SPECIMENNO->Visible) { // SPECIMENNO ?>
    <div id="r_SPECIMENNO" class="form-group row">
        <label id="elh_V_FARMASI_SPECIMENNO" for="x_SPECIMENNO" class="<?= $Page->LeftColumnClass ?>"><?= $Page->SPECIMENNO->caption() ?><?= $Page->SPECIMENNO->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->SPECIMENNO->cellAttributes() ?>>
<span id="el_V_FARMASI_SPECIMENNO">
<input type="<?= $Page->SPECIMENNO->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_SPECIMENNO" data-page="1" name="x_SPECIMENNO" id="x_SPECIMENNO" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->SPECIMENNO->getPlaceHolder()) ?>" value="<?= $Page->SPECIMENNO->EditValue ?>"<?= $Page->SPECIMENNO->editAttributes() ?> aria-describedby="x_SPECIMENNO_help">
<?= $Page->SPECIMENNO->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->SPECIMENNO->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->LOCKED->Visible) { // LOCKED ?>
    <div id="r_LOCKED" class="form-group row">
        <label id="elh_V_FARMASI_LOCKED" for="x_LOCKED" class="<?= $Page->LeftColumnClass ?>"><?= $Page->LOCKED->caption() ?><?= $Page->LOCKED->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->LOCKED->cellAttributes() ?>>
<span id="el_V_FARMASI_LOCKED">
<input type="<?= $Page->LOCKED->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_LOCKED" data-page="1" name="x_LOCKED" id="x_LOCKED" size="30" maxlength="1" placeholder="<?= HtmlEncode($Page->LOCKED->getPlaceHolder()) ?>" value="<?= $Page->LOCKED->EditValue ?>"<?= $Page->LOCKED->editAttributes() ?> aria-describedby="x_LOCKED_help">
<?= $Page->LOCKED->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->LOCKED->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->RM_OUT_DATE->Visible) { // RM_OUT_DATE ?>
    <div id="r_RM_OUT_DATE" class="form-group row">
        <label id="elh_V_FARMASI_RM_OUT_DATE" for="x_RM_OUT_DATE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->RM_OUT_DATE->caption() ?><?= $Page->RM_OUT_DATE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->RM_OUT_DATE->cellAttributes() ?>>
<span id="el_V_FARMASI_RM_OUT_DATE">
<input type="<?= $Page->RM_OUT_DATE->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_RM_OUT_DATE" data-page="1" name="x_RM_OUT_DATE" id="x_RM_OUT_DATE" placeholder="<?= HtmlEncode($Page->RM_OUT_DATE->getPlaceHolder()) ?>" value="<?= $Page->RM_OUT_DATE->EditValue ?>"<?= $Page->RM_OUT_DATE->editAttributes() ?> aria-describedby="x_RM_OUT_DATE_help">
<?= $Page->RM_OUT_DATE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->RM_OUT_DATE->getErrorMessage() ?></div>
<?php if (!$Page->RM_OUT_DATE->ReadOnly && !$Page->RM_OUT_DATE->Disabled && !isset($Page->RM_OUT_DATE->EditAttrs["readonly"]) && !isset($Page->RM_OUT_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fV_FARMASIadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fV_FARMASIadd", "x_RM_OUT_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->RM_IN_DATE->Visible) { // RM_IN_DATE ?>
    <div id="r_RM_IN_DATE" class="form-group row">
        <label id="elh_V_FARMASI_RM_IN_DATE" for="x_RM_IN_DATE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->RM_IN_DATE->caption() ?><?= $Page->RM_IN_DATE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->RM_IN_DATE->cellAttributes() ?>>
<span id="el_V_FARMASI_RM_IN_DATE">
<input type="<?= $Page->RM_IN_DATE->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_RM_IN_DATE" data-page="1" name="x_RM_IN_DATE" id="x_RM_IN_DATE" placeholder="<?= HtmlEncode($Page->RM_IN_DATE->getPlaceHolder()) ?>" value="<?= $Page->RM_IN_DATE->EditValue ?>"<?= $Page->RM_IN_DATE->editAttributes() ?> aria-describedby="x_RM_IN_DATE_help">
<?= $Page->RM_IN_DATE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->RM_IN_DATE->getErrorMessage() ?></div>
<?php if (!$Page->RM_IN_DATE->ReadOnly && !$Page->RM_IN_DATE->Disabled && !isset($Page->RM_IN_DATE->EditAttrs["readonly"]) && !isset($Page->RM_IN_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fV_FARMASIadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fV_FARMASIadd", "x_RM_IN_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->LAMA_PINJAM->Visible) { // LAMA_PINJAM ?>
    <div id="r_LAMA_PINJAM" class="form-group row">
        <label id="elh_V_FARMASI_LAMA_PINJAM" for="x_LAMA_PINJAM" class="<?= $Page->LeftColumnClass ?>"><?= $Page->LAMA_PINJAM->caption() ?><?= $Page->LAMA_PINJAM->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->LAMA_PINJAM->cellAttributes() ?>>
<span id="el_V_FARMASI_LAMA_PINJAM">
<input type="<?= $Page->LAMA_PINJAM->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_LAMA_PINJAM" data-page="1" name="x_LAMA_PINJAM" id="x_LAMA_PINJAM" placeholder="<?= HtmlEncode($Page->LAMA_PINJAM->getPlaceHolder()) ?>" value="<?= $Page->LAMA_PINJAM->EditValue ?>"<?= $Page->LAMA_PINJAM->editAttributes() ?> aria-describedby="x_LAMA_PINJAM_help">
<?= $Page->LAMA_PINJAM->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->LAMA_PINJAM->getErrorMessage() ?></div>
<?php if (!$Page->LAMA_PINJAM->ReadOnly && !$Page->LAMA_PINJAM->Disabled && !isset($Page->LAMA_PINJAM->EditAttrs["readonly"]) && !isset($Page->LAMA_PINJAM->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fV_FARMASIadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fV_FARMASIadd", "x_LAMA_PINJAM", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->STANDAR_RJ->Visible) { // STANDAR_RJ ?>
    <div id="r_STANDAR_RJ" class="form-group row">
        <label id="elh_V_FARMASI_STANDAR_RJ" for="x_STANDAR_RJ" class="<?= $Page->LeftColumnClass ?>"><?= $Page->STANDAR_RJ->caption() ?><?= $Page->STANDAR_RJ->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->STANDAR_RJ->cellAttributes() ?>>
<span id="el_V_FARMASI_STANDAR_RJ">
<input type="<?= $Page->STANDAR_RJ->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_STANDAR_RJ" data-page="1" name="x_STANDAR_RJ" id="x_STANDAR_RJ" size="30" maxlength="1" placeholder="<?= HtmlEncode($Page->STANDAR_RJ->getPlaceHolder()) ?>" value="<?= $Page->STANDAR_RJ->EditValue ?>"<?= $Page->STANDAR_RJ->editAttributes() ?> aria-describedby="x_STANDAR_RJ_help">
<?= $Page->STANDAR_RJ->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->STANDAR_RJ->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->LENGKAP_RJ->Visible) { // LENGKAP_RJ ?>
    <div id="r_LENGKAP_RJ" class="form-group row">
        <label id="elh_V_FARMASI_LENGKAP_RJ" for="x_LENGKAP_RJ" class="<?= $Page->LeftColumnClass ?>"><?= $Page->LENGKAP_RJ->caption() ?><?= $Page->LENGKAP_RJ->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->LENGKAP_RJ->cellAttributes() ?>>
<span id="el_V_FARMASI_LENGKAP_RJ">
<input type="<?= $Page->LENGKAP_RJ->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_LENGKAP_RJ" data-page="1" name="x_LENGKAP_RJ" id="x_LENGKAP_RJ" size="30" maxlength="1" placeholder="<?= HtmlEncode($Page->LENGKAP_RJ->getPlaceHolder()) ?>" value="<?= $Page->LENGKAP_RJ->EditValue ?>"<?= $Page->LENGKAP_RJ->editAttributes() ?> aria-describedby="x_LENGKAP_RJ_help">
<?= $Page->LENGKAP_RJ->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->LENGKAP_RJ->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->LENGKAP_RI->Visible) { // LENGKAP_RI ?>
    <div id="r_LENGKAP_RI" class="form-group row">
        <label id="elh_V_FARMASI_LENGKAP_RI" for="x_LENGKAP_RI" class="<?= $Page->LeftColumnClass ?>"><?= $Page->LENGKAP_RI->caption() ?><?= $Page->LENGKAP_RI->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->LENGKAP_RI->cellAttributes() ?>>
<span id="el_V_FARMASI_LENGKAP_RI">
<input type="<?= $Page->LENGKAP_RI->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_LENGKAP_RI" data-page="1" name="x_LENGKAP_RI" id="x_LENGKAP_RI" size="30" maxlength="1" placeholder="<?= HtmlEncode($Page->LENGKAP_RI->getPlaceHolder()) ?>" value="<?= $Page->LENGKAP_RI->EditValue ?>"<?= $Page->LENGKAP_RI->editAttributes() ?> aria-describedby="x_LENGKAP_RI_help">
<?= $Page->LENGKAP_RI->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->LENGKAP_RI->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->RESEND_RM_DATE->Visible) { // RESEND_RM_DATE ?>
    <div id="r_RESEND_RM_DATE" class="form-group row">
        <label id="elh_V_FARMASI_RESEND_RM_DATE" for="x_RESEND_RM_DATE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->RESEND_RM_DATE->caption() ?><?= $Page->RESEND_RM_DATE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->RESEND_RM_DATE->cellAttributes() ?>>
<span id="el_V_FARMASI_RESEND_RM_DATE">
<input type="<?= $Page->RESEND_RM_DATE->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_RESEND_RM_DATE" data-page="1" name="x_RESEND_RM_DATE" id="x_RESEND_RM_DATE" placeholder="<?= HtmlEncode($Page->RESEND_RM_DATE->getPlaceHolder()) ?>" value="<?= $Page->RESEND_RM_DATE->EditValue ?>"<?= $Page->RESEND_RM_DATE->editAttributes() ?> aria-describedby="x_RESEND_RM_DATE_help">
<?= $Page->RESEND_RM_DATE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->RESEND_RM_DATE->getErrorMessage() ?></div>
<?php if (!$Page->RESEND_RM_DATE->ReadOnly && !$Page->RESEND_RM_DATE->Disabled && !isset($Page->RESEND_RM_DATE->EditAttrs["readonly"]) && !isset($Page->RESEND_RM_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fV_FARMASIadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fV_FARMASIadd", "x_RESEND_RM_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->LENGKAP_RM1->Visible) { // LENGKAP_RM1 ?>
    <div id="r_LENGKAP_RM1" class="form-group row">
        <label id="elh_V_FARMASI_LENGKAP_RM1" for="x_LENGKAP_RM1" class="<?= $Page->LeftColumnClass ?>"><?= $Page->LENGKAP_RM1->caption() ?><?= $Page->LENGKAP_RM1->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->LENGKAP_RM1->cellAttributes() ?>>
<span id="el_V_FARMASI_LENGKAP_RM1">
<input type="<?= $Page->LENGKAP_RM1->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_LENGKAP_RM1" data-page="1" name="x_LENGKAP_RM1" id="x_LENGKAP_RM1" size="30" maxlength="1" placeholder="<?= HtmlEncode($Page->LENGKAP_RM1->getPlaceHolder()) ?>" value="<?= $Page->LENGKAP_RM1->EditValue ?>"<?= $Page->LENGKAP_RM1->editAttributes() ?> aria-describedby="x_LENGKAP_RM1_help">
<?= $Page->LENGKAP_RM1->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->LENGKAP_RM1->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->LENGKAP_RESUME->Visible) { // LENGKAP_RESUME ?>
    <div id="r_LENGKAP_RESUME" class="form-group row">
        <label id="elh_V_FARMASI_LENGKAP_RESUME" for="x_LENGKAP_RESUME" class="<?= $Page->LeftColumnClass ?>"><?= $Page->LENGKAP_RESUME->caption() ?><?= $Page->LENGKAP_RESUME->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->LENGKAP_RESUME->cellAttributes() ?>>
<span id="el_V_FARMASI_LENGKAP_RESUME">
<input type="<?= $Page->LENGKAP_RESUME->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_LENGKAP_RESUME" data-page="1" name="x_LENGKAP_RESUME" id="x_LENGKAP_RESUME" size="30" maxlength="1" placeholder="<?= HtmlEncode($Page->LENGKAP_RESUME->getPlaceHolder()) ?>" value="<?= $Page->LENGKAP_RESUME->EditValue ?>"<?= $Page->LENGKAP_RESUME->editAttributes() ?> aria-describedby="x_LENGKAP_RESUME_help">
<?= $Page->LENGKAP_RESUME->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->LENGKAP_RESUME->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->LENGKAP_ANAMNESIS->Visible) { // LENGKAP_ANAMNESIS ?>
    <div id="r_LENGKAP_ANAMNESIS" class="form-group row">
        <label id="elh_V_FARMASI_LENGKAP_ANAMNESIS" for="x_LENGKAP_ANAMNESIS" class="<?= $Page->LeftColumnClass ?>"><?= $Page->LENGKAP_ANAMNESIS->caption() ?><?= $Page->LENGKAP_ANAMNESIS->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->LENGKAP_ANAMNESIS->cellAttributes() ?>>
<span id="el_V_FARMASI_LENGKAP_ANAMNESIS">
<input type="<?= $Page->LENGKAP_ANAMNESIS->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_LENGKAP_ANAMNESIS" data-page="1" name="x_LENGKAP_ANAMNESIS" id="x_LENGKAP_ANAMNESIS" size="30" maxlength="1" placeholder="<?= HtmlEncode($Page->LENGKAP_ANAMNESIS->getPlaceHolder()) ?>" value="<?= $Page->LENGKAP_ANAMNESIS->EditValue ?>"<?= $Page->LENGKAP_ANAMNESIS->editAttributes() ?> aria-describedby="x_LENGKAP_ANAMNESIS_help">
<?= $Page->LENGKAP_ANAMNESIS->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->LENGKAP_ANAMNESIS->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->LENGKAP_CONSENT->Visible) { // LENGKAP_CONSENT ?>
    <div id="r_LENGKAP_CONSENT" class="form-group row">
        <label id="elh_V_FARMASI_LENGKAP_CONSENT" for="x_LENGKAP_CONSENT" class="<?= $Page->LeftColumnClass ?>"><?= $Page->LENGKAP_CONSENT->caption() ?><?= $Page->LENGKAP_CONSENT->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->LENGKAP_CONSENT->cellAttributes() ?>>
<span id="el_V_FARMASI_LENGKAP_CONSENT">
<input type="<?= $Page->LENGKAP_CONSENT->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_LENGKAP_CONSENT" data-page="1" name="x_LENGKAP_CONSENT" id="x_LENGKAP_CONSENT" size="30" maxlength="1" placeholder="<?= HtmlEncode($Page->LENGKAP_CONSENT->getPlaceHolder()) ?>" value="<?= $Page->LENGKAP_CONSENT->EditValue ?>"<?= $Page->LENGKAP_CONSENT->editAttributes() ?> aria-describedby="x_LENGKAP_CONSENT_help">
<?= $Page->LENGKAP_CONSENT->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->LENGKAP_CONSENT->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->LENGKAP_ANESTESI->Visible) { // LENGKAP_ANESTESI ?>
    <div id="r_LENGKAP_ANESTESI" class="form-group row">
        <label id="elh_V_FARMASI_LENGKAP_ANESTESI" for="x_LENGKAP_ANESTESI" class="<?= $Page->LeftColumnClass ?>"><?= $Page->LENGKAP_ANESTESI->caption() ?><?= $Page->LENGKAP_ANESTESI->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->LENGKAP_ANESTESI->cellAttributes() ?>>
<span id="el_V_FARMASI_LENGKAP_ANESTESI">
<input type="<?= $Page->LENGKAP_ANESTESI->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_LENGKAP_ANESTESI" data-page="1" name="x_LENGKAP_ANESTESI" id="x_LENGKAP_ANESTESI" size="30" maxlength="1" placeholder="<?= HtmlEncode($Page->LENGKAP_ANESTESI->getPlaceHolder()) ?>" value="<?= $Page->LENGKAP_ANESTESI->EditValue ?>"<?= $Page->LENGKAP_ANESTESI->editAttributes() ?> aria-describedby="x_LENGKAP_ANESTESI_help">
<?= $Page->LENGKAP_ANESTESI->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->LENGKAP_ANESTESI->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->LENGKAP_OP->Visible) { // LENGKAP_OP ?>
    <div id="r_LENGKAP_OP" class="form-group row">
        <label id="elh_V_FARMASI_LENGKAP_OP" for="x_LENGKAP_OP" class="<?= $Page->LeftColumnClass ?>"><?= $Page->LENGKAP_OP->caption() ?><?= $Page->LENGKAP_OP->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->LENGKAP_OP->cellAttributes() ?>>
<span id="el_V_FARMASI_LENGKAP_OP">
<input type="<?= $Page->LENGKAP_OP->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_LENGKAP_OP" data-page="1" name="x_LENGKAP_OP" id="x_LENGKAP_OP" size="30" maxlength="1" placeholder="<?= HtmlEncode($Page->LENGKAP_OP->getPlaceHolder()) ?>" value="<?= $Page->LENGKAP_OP->EditValue ?>"<?= $Page->LENGKAP_OP->editAttributes() ?> aria-describedby="x_LENGKAP_OP_help">
<?= $Page->LENGKAP_OP->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->LENGKAP_OP->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->BACK_RM_DATE->Visible) { // BACK_RM_DATE ?>
    <div id="r_BACK_RM_DATE" class="form-group row">
        <label id="elh_V_FARMASI_BACK_RM_DATE" for="x_BACK_RM_DATE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->BACK_RM_DATE->caption() ?><?= $Page->BACK_RM_DATE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->BACK_RM_DATE->cellAttributes() ?>>
<span id="el_V_FARMASI_BACK_RM_DATE">
<input type="<?= $Page->BACK_RM_DATE->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_BACK_RM_DATE" data-page="1" name="x_BACK_RM_DATE" id="x_BACK_RM_DATE" placeholder="<?= HtmlEncode($Page->BACK_RM_DATE->getPlaceHolder()) ?>" value="<?= $Page->BACK_RM_DATE->EditValue ?>"<?= $Page->BACK_RM_DATE->editAttributes() ?> aria-describedby="x_BACK_RM_DATE_help">
<?= $Page->BACK_RM_DATE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->BACK_RM_DATE->getErrorMessage() ?></div>
<?php if (!$Page->BACK_RM_DATE->ReadOnly && !$Page->BACK_RM_DATE->Disabled && !isset($Page->BACK_RM_DATE->EditAttrs["readonly"]) && !isset($Page->BACK_RM_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fV_FARMASIadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fV_FARMASIadd", "x_BACK_RM_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->VALID_RM_DATE->Visible) { // VALID_RM_DATE ?>
    <div id="r_VALID_RM_DATE" class="form-group row">
        <label id="elh_V_FARMASI_VALID_RM_DATE" for="x_VALID_RM_DATE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->VALID_RM_DATE->caption() ?><?= $Page->VALID_RM_DATE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->VALID_RM_DATE->cellAttributes() ?>>
<span id="el_V_FARMASI_VALID_RM_DATE">
<input type="<?= $Page->VALID_RM_DATE->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_VALID_RM_DATE" data-page="1" name="x_VALID_RM_DATE" id="x_VALID_RM_DATE" placeholder="<?= HtmlEncode($Page->VALID_RM_DATE->getPlaceHolder()) ?>" value="<?= $Page->VALID_RM_DATE->EditValue ?>"<?= $Page->VALID_RM_DATE->editAttributes() ?> aria-describedby="x_VALID_RM_DATE_help">
<?= $Page->VALID_RM_DATE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->VALID_RM_DATE->getErrorMessage() ?></div>
<?php if (!$Page->VALID_RM_DATE->ReadOnly && !$Page->VALID_RM_DATE->Disabled && !isset($Page->VALID_RM_DATE->EditAttrs["readonly"]) && !isset($Page->VALID_RM_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fV_FARMASIadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fV_FARMASIadd", "x_VALID_RM_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->NO_SKP->Visible) { // NO_SKP ?>
    <div id="r_NO_SKP" class="form-group row">
        <label id="elh_V_FARMASI_NO_SKP" for="x_NO_SKP" class="<?= $Page->LeftColumnClass ?>"><?= $Page->NO_SKP->caption() ?><?= $Page->NO_SKP->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->NO_SKP->cellAttributes() ?>>
<span id="el_V_FARMASI_NO_SKP">
<input type="<?= $Page->NO_SKP->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_NO_SKP" data-page="1" name="x_NO_SKP" id="x_NO_SKP" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->NO_SKP->getPlaceHolder()) ?>" value="<?= $Page->NO_SKP->EditValue ?>"<?= $Page->NO_SKP->editAttributes() ?> aria-describedby="x_NO_SKP_help">
<?= $Page->NO_SKP->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->NO_SKP->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->NO_SKPINAP->Visible) { // NO_SKPINAP ?>
    <div id="r_NO_SKPINAP" class="form-group row">
        <label id="elh_V_FARMASI_NO_SKPINAP" for="x_NO_SKPINAP" class="<?= $Page->LeftColumnClass ?>"><?= $Page->NO_SKPINAP->caption() ?><?= $Page->NO_SKPINAP->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->NO_SKPINAP->cellAttributes() ?>>
<span id="el_V_FARMASI_NO_SKPINAP">
<input type="<?= $Page->NO_SKPINAP->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_NO_SKPINAP" data-page="1" name="x_NO_SKPINAP" id="x_NO_SKPINAP" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->NO_SKPINAP->getPlaceHolder()) ?>" value="<?= $Page->NO_SKPINAP->EditValue ?>"<?= $Page->NO_SKPINAP->editAttributes() ?> aria-describedby="x_NO_SKPINAP_help">
<?= $Page->NO_SKPINAP->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->NO_SKPINAP->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->DIAGNOSA_ID->Visible) { // DIAGNOSA_ID ?>
    <div id="r_DIAGNOSA_ID" class="form-group row">
        <label id="elh_V_FARMASI_DIAGNOSA_ID" for="x_DIAGNOSA_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->DIAGNOSA_ID->caption() ?><?= $Page->DIAGNOSA_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->DIAGNOSA_ID->cellAttributes() ?>>
<span id="el_V_FARMASI_DIAGNOSA_ID">
<input type="<?= $Page->DIAGNOSA_ID->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_DIAGNOSA_ID" data-page="1" name="x_DIAGNOSA_ID" id="x_DIAGNOSA_ID" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->DIAGNOSA_ID->getPlaceHolder()) ?>" value="<?= $Page->DIAGNOSA_ID->EditValue ?>"<?= $Page->DIAGNOSA_ID->editAttributes() ?> aria-describedby="x_DIAGNOSA_ID_help">
<?= $Page->DIAGNOSA_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->DIAGNOSA_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ticket_all->Visible) { // ticket_all ?>
    <div id="r_ticket_all" class="form-group row">
        <label id="elh_V_FARMASI_ticket_all" for="x_ticket_all" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ticket_all->caption() ?><?= $Page->ticket_all->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ticket_all->cellAttributes() ?>>
<span id="el_V_FARMASI_ticket_all">
<input type="<?= $Page->ticket_all->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_ticket_all" data-page="1" name="x_ticket_all" id="x_ticket_all" size="30" placeholder="<?= HtmlEncode($Page->ticket_all->getPlaceHolder()) ?>" value="<?= $Page->ticket_all->EditValue ?>"<?= $Page->ticket_all->editAttributes() ?> aria-describedby="x_ticket_all_help">
<?= $Page->ticket_all->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ticket_all->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tanggal_rujukan->Visible) { // tanggal_rujukan ?>
    <div id="r_tanggal_rujukan" class="form-group row">
        <label id="elh_V_FARMASI_tanggal_rujukan" for="x_tanggal_rujukan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tanggal_rujukan->caption() ?><?= $Page->tanggal_rujukan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tanggal_rujukan->cellAttributes() ?>>
<span id="el_V_FARMASI_tanggal_rujukan">
<input type="<?= $Page->tanggal_rujukan->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_tanggal_rujukan" data-page="1" name="x_tanggal_rujukan" id="x_tanggal_rujukan" placeholder="<?= HtmlEncode($Page->tanggal_rujukan->getPlaceHolder()) ?>" value="<?= $Page->tanggal_rujukan->EditValue ?>"<?= $Page->tanggal_rujukan->editAttributes() ?> aria-describedby="x_tanggal_rujukan_help">
<?= $Page->tanggal_rujukan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tanggal_rujukan->getErrorMessage() ?></div>
<?php if (!$Page->tanggal_rujukan->ReadOnly && !$Page->tanggal_rujukan->Disabled && !isset($Page->tanggal_rujukan->EditAttrs["readonly"]) && !isset($Page->tanggal_rujukan->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fV_FARMASIadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fV_FARMASIadd", "x_tanggal_rujukan", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ISRJ->Visible) { // ISRJ ?>
    <div id="r_ISRJ" class="form-group row">
        <label id="elh_V_FARMASI_ISRJ" for="x_ISRJ" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ISRJ->caption() ?><?= $Page->ISRJ->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ISRJ->cellAttributes() ?>>
<span id="el_V_FARMASI_ISRJ">
<input type="<?= $Page->ISRJ->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_ISRJ" data-page="1" name="x_ISRJ" id="x_ISRJ" size="30" maxlength="1" placeholder="<?= HtmlEncode($Page->ISRJ->getPlaceHolder()) ?>" value="<?= $Page->ISRJ->EditValue ?>"<?= $Page->ISRJ->editAttributes() ?> aria-describedby="x_ISRJ_help">
<?= $Page->ISRJ->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ISRJ->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->NORUJUKAN->Visible) { // NORUJUKAN ?>
    <div id="r_NORUJUKAN" class="form-group row">
        <label id="elh_V_FARMASI_NORUJUKAN" for="x_NORUJUKAN" class="<?= $Page->LeftColumnClass ?>"><?= $Page->NORUJUKAN->caption() ?><?= $Page->NORUJUKAN->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->NORUJUKAN->cellAttributes() ?>>
<span id="el_V_FARMASI_NORUJUKAN">
<input type="<?= $Page->NORUJUKAN->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_NORUJUKAN" data-page="1" name="x_NORUJUKAN" id="x_NORUJUKAN" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->NORUJUKAN->getPlaceHolder()) ?>" value="<?= $Page->NORUJUKAN->EditValue ?>"<?= $Page->NORUJUKAN->editAttributes() ?> aria-describedby="x_NORUJUKAN_help">
<?= $Page->NORUJUKAN->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->NORUJUKAN->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->PPKRUJUKAN->Visible) { // PPKRUJUKAN ?>
    <div id="r_PPKRUJUKAN" class="form-group row">
        <label id="elh_V_FARMASI_PPKRUJUKAN" for="x_PPKRUJUKAN" class="<?= $Page->LeftColumnClass ?>"><?= $Page->PPKRUJUKAN->caption() ?><?= $Page->PPKRUJUKAN->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PPKRUJUKAN->cellAttributes() ?>>
<span id="el_V_FARMASI_PPKRUJUKAN">
<input type="<?= $Page->PPKRUJUKAN->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_PPKRUJUKAN" data-page="1" name="x_PPKRUJUKAN" id="x_PPKRUJUKAN" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->PPKRUJUKAN->getPlaceHolder()) ?>" value="<?= $Page->PPKRUJUKAN->EditValue ?>"<?= $Page->PPKRUJUKAN->editAttributes() ?> aria-describedby="x_PPKRUJUKAN_help">
<?= $Page->PPKRUJUKAN->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->PPKRUJUKAN->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->LOKASILAKA->Visible) { // LOKASILAKA ?>
    <div id="r_LOKASILAKA" class="form-group row">
        <label id="elh_V_FARMASI_LOKASILAKA" for="x_LOKASILAKA" class="<?= $Page->LeftColumnClass ?>"><?= $Page->LOKASILAKA->caption() ?><?= $Page->LOKASILAKA->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->LOKASILAKA->cellAttributes() ?>>
<span id="el_V_FARMASI_LOKASILAKA">
<input type="<?= $Page->LOKASILAKA->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_LOKASILAKA" data-page="1" name="x_LOKASILAKA" id="x_LOKASILAKA" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->LOKASILAKA->getPlaceHolder()) ?>" value="<?= $Page->LOKASILAKA->EditValue ?>"<?= $Page->LOKASILAKA->editAttributes() ?> aria-describedby="x_LOKASILAKA_help">
<?= $Page->LOKASILAKA->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->LOKASILAKA->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->KDPOLI->Visible) { // KDPOLI ?>
    <div id="r_KDPOLI" class="form-group row">
        <label id="elh_V_FARMASI_KDPOLI" for="x_KDPOLI" class="<?= $Page->LeftColumnClass ?>"><?= $Page->KDPOLI->caption() ?><?= $Page->KDPOLI->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->KDPOLI->cellAttributes() ?>>
<span id="el_V_FARMASI_KDPOLI">
<input type="<?= $Page->KDPOLI->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_KDPOLI" data-page="1" name="x_KDPOLI" id="x_KDPOLI" size="30" maxlength="3" placeholder="<?= HtmlEncode($Page->KDPOLI->getPlaceHolder()) ?>" value="<?= $Page->KDPOLI->EditValue ?>"<?= $Page->KDPOLI->editAttributes() ?> aria-describedby="x_KDPOLI_help">
<?= $Page->KDPOLI->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->KDPOLI->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->EDIT_SEP->Visible) { // EDIT_SEP ?>
    <div id="r_EDIT_SEP" class="form-group row">
        <label id="elh_V_FARMASI_EDIT_SEP" for="x_EDIT_SEP" class="<?= $Page->LeftColumnClass ?>"><?= $Page->EDIT_SEP->caption() ?><?= $Page->EDIT_SEP->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->EDIT_SEP->cellAttributes() ?>>
<span id="el_V_FARMASI_EDIT_SEP">
<input type="<?= $Page->EDIT_SEP->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_EDIT_SEP" data-page="1" name="x_EDIT_SEP" id="x_EDIT_SEP" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->EDIT_SEP->getPlaceHolder()) ?>" value="<?= $Page->EDIT_SEP->EditValue ?>"<?= $Page->EDIT_SEP->editAttributes() ?> aria-describedby="x_EDIT_SEP_help">
<?= $Page->EDIT_SEP->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->EDIT_SEP->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->DELETE_SEP->Visible) { // DELETE_SEP ?>
    <div id="r_DELETE_SEP" class="form-group row">
        <label id="elh_V_FARMASI_DELETE_SEP" for="x_DELETE_SEP" class="<?= $Page->LeftColumnClass ?>"><?= $Page->DELETE_SEP->caption() ?><?= $Page->DELETE_SEP->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->DELETE_SEP->cellAttributes() ?>>
<span id="el_V_FARMASI_DELETE_SEP">
<input type="<?= $Page->DELETE_SEP->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_DELETE_SEP" data-page="1" name="x_DELETE_SEP" id="x_DELETE_SEP" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->DELETE_SEP->getPlaceHolder()) ?>" value="<?= $Page->DELETE_SEP->EditValue ?>"<?= $Page->DELETE_SEP->editAttributes() ?> aria-describedby="x_DELETE_SEP_help">
<?= $Page->DELETE_SEP->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->DELETE_SEP->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->KODE_AGAMA->Visible) { // KODE_AGAMA ?>
    <div id="r_KODE_AGAMA" class="form-group row">
        <label id="elh_V_FARMASI_KODE_AGAMA" for="x_KODE_AGAMA" class="<?= $Page->LeftColumnClass ?>"><?= $Page->KODE_AGAMA->caption() ?><?= $Page->KODE_AGAMA->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->KODE_AGAMA->cellAttributes() ?>>
<span id="el_V_FARMASI_KODE_AGAMA">
<input type="<?= $Page->KODE_AGAMA->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_KODE_AGAMA" data-page="1" name="x_KODE_AGAMA" id="x_KODE_AGAMA" size="30" placeholder="<?= HtmlEncode($Page->KODE_AGAMA->getPlaceHolder()) ?>" value="<?= $Page->KODE_AGAMA->EditValue ?>"<?= $Page->KODE_AGAMA->editAttributes() ?> aria-describedby="x_KODE_AGAMA_help">
<?= $Page->KODE_AGAMA->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->KODE_AGAMA->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->DIAG_AWAL->Visible) { // DIAG_AWAL ?>
    <div id="r_DIAG_AWAL" class="form-group row">
        <label id="elh_V_FARMASI_DIAG_AWAL" for="x_DIAG_AWAL" class="<?= $Page->LeftColumnClass ?>"><?= $Page->DIAG_AWAL->caption() ?><?= $Page->DIAG_AWAL->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->DIAG_AWAL->cellAttributes() ?>>
<span id="el_V_FARMASI_DIAG_AWAL">
<input type="<?= $Page->DIAG_AWAL->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_DIAG_AWAL" data-page="1" name="x_DIAG_AWAL" id="x_DIAG_AWAL" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->DIAG_AWAL->getPlaceHolder()) ?>" value="<?= $Page->DIAG_AWAL->EditValue ?>"<?= $Page->DIAG_AWAL->editAttributes() ?> aria-describedby="x_DIAG_AWAL_help">
<?= $Page->DIAG_AWAL->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->DIAG_AWAL->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->AKTIF->Visible) { // AKTIF ?>
    <div id="r_AKTIF" class="form-group row">
        <label id="elh_V_FARMASI_AKTIF" for="x_AKTIF" class="<?= $Page->LeftColumnClass ?>"><?= $Page->AKTIF->caption() ?><?= $Page->AKTIF->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->AKTIF->cellAttributes() ?>>
<span id="el_V_FARMASI_AKTIF">
<input type="<?= $Page->AKTIF->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_AKTIF" data-page="1" name="x_AKTIF" id="x_AKTIF" size="30" maxlength="2" placeholder="<?= HtmlEncode($Page->AKTIF->getPlaceHolder()) ?>" value="<?= $Page->AKTIF->EditValue ?>"<?= $Page->AKTIF->editAttributes() ?> aria-describedby="x_AKTIF_help">
<?= $Page->AKTIF->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->AKTIF->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->BILL_INAP->Visible) { // BILL_INAP ?>
    <div id="r_BILL_INAP" class="form-group row">
        <label id="elh_V_FARMASI_BILL_INAP" for="x_BILL_INAP" class="<?= $Page->LeftColumnClass ?>"><?= $Page->BILL_INAP->caption() ?><?= $Page->BILL_INAP->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->BILL_INAP->cellAttributes() ?>>
<span id="el_V_FARMASI_BILL_INAP">
<input type="<?= $Page->BILL_INAP->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_BILL_INAP" data-page="1" name="x_BILL_INAP" id="x_BILL_INAP" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->BILL_INAP->getPlaceHolder()) ?>" value="<?= $Page->BILL_INAP->EditValue ?>"<?= $Page->BILL_INAP->editAttributes() ?> aria-describedby="x_BILL_INAP_help">
<?= $Page->BILL_INAP->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->BILL_INAP->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->SEP_PRINTDATE->Visible) { // SEP_PRINTDATE ?>
    <div id="r_SEP_PRINTDATE" class="form-group row">
        <label id="elh_V_FARMASI_SEP_PRINTDATE" for="x_SEP_PRINTDATE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->SEP_PRINTDATE->caption() ?><?= $Page->SEP_PRINTDATE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->SEP_PRINTDATE->cellAttributes() ?>>
<span id="el_V_FARMASI_SEP_PRINTDATE">
<input type="<?= $Page->SEP_PRINTDATE->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_SEP_PRINTDATE" data-page="1" name="x_SEP_PRINTDATE" id="x_SEP_PRINTDATE" placeholder="<?= HtmlEncode($Page->SEP_PRINTDATE->getPlaceHolder()) ?>" value="<?= $Page->SEP_PRINTDATE->EditValue ?>"<?= $Page->SEP_PRINTDATE->editAttributes() ?> aria-describedby="x_SEP_PRINTDATE_help">
<?= $Page->SEP_PRINTDATE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->SEP_PRINTDATE->getErrorMessage() ?></div>
<?php if (!$Page->SEP_PRINTDATE->ReadOnly && !$Page->SEP_PRINTDATE->Disabled && !isset($Page->SEP_PRINTDATE->EditAttrs["readonly"]) && !isset($Page->SEP_PRINTDATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fV_FARMASIadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fV_FARMASIadd", "x_SEP_PRINTDATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->MAPPING_SEP->Visible) { // MAPPING_SEP ?>
    <div id="r_MAPPING_SEP" class="form-group row">
        <label id="elh_V_FARMASI_MAPPING_SEP" for="x_MAPPING_SEP" class="<?= $Page->LeftColumnClass ?>"><?= $Page->MAPPING_SEP->caption() ?><?= $Page->MAPPING_SEP->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->MAPPING_SEP->cellAttributes() ?>>
<span id="el_V_FARMASI_MAPPING_SEP">
<input type="<?= $Page->MAPPING_SEP->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_MAPPING_SEP" data-page="1" name="x_MAPPING_SEP" id="x_MAPPING_SEP" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->MAPPING_SEP->getPlaceHolder()) ?>" value="<?= $Page->MAPPING_SEP->EditValue ?>"<?= $Page->MAPPING_SEP->editAttributes() ?> aria-describedby="x_MAPPING_SEP_help">
<?= $Page->MAPPING_SEP->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->MAPPING_SEP->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->TRANS_ID->Visible) { // TRANS_ID ?>
    <div id="r_TRANS_ID" class="form-group row">
        <label id="elh_V_FARMASI_TRANS_ID" for="x_TRANS_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->TRANS_ID->caption() ?><?= $Page->TRANS_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->TRANS_ID->cellAttributes() ?>>
<span id="el_V_FARMASI_TRANS_ID">
<input type="<?= $Page->TRANS_ID->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_TRANS_ID" data-page="1" name="x_TRANS_ID" id="x_TRANS_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->TRANS_ID->getPlaceHolder()) ?>" value="<?= $Page->TRANS_ID->EditValue ?>"<?= $Page->TRANS_ID->editAttributes() ?> aria-describedby="x_TRANS_ID_help">
<?= $Page->TRANS_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->TRANS_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->KDPOLI_EKS->Visible) { // KDPOLI_EKS ?>
    <div id="r_KDPOLI_EKS" class="form-group row">
        <label id="elh_V_FARMASI_KDPOLI_EKS" for="x_KDPOLI_EKS" class="<?= $Page->LeftColumnClass ?>"><?= $Page->KDPOLI_EKS->caption() ?><?= $Page->KDPOLI_EKS->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->KDPOLI_EKS->cellAttributes() ?>>
<span id="el_V_FARMASI_KDPOLI_EKS">
<input type="<?= $Page->KDPOLI_EKS->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_KDPOLI_EKS" data-page="1" name="x_KDPOLI_EKS" id="x_KDPOLI_EKS" size="30" maxlength="1" placeholder="<?= HtmlEncode($Page->KDPOLI_EKS->getPlaceHolder()) ?>" value="<?= $Page->KDPOLI_EKS->EditValue ?>"<?= $Page->KDPOLI_EKS->editAttributes() ?> aria-describedby="x_KDPOLI_EKS_help">
<?= $Page->KDPOLI_EKS->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->KDPOLI_EKS->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->COB->Visible) { // COB ?>
    <div id="r_COB" class="form-group row">
        <label id="elh_V_FARMASI_COB" for="x_COB" class="<?= $Page->LeftColumnClass ?>"><?= $Page->COB->caption() ?><?= $Page->COB->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->COB->cellAttributes() ?>>
<span id="el_V_FARMASI_COB">
<input type="<?= $Page->COB->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_COB" data-page="1" name="x_COB" id="x_COB" size="30" maxlength="1" placeholder="<?= HtmlEncode($Page->COB->getPlaceHolder()) ?>" value="<?= $Page->COB->EditValue ?>"<?= $Page->COB->editAttributes() ?> aria-describedby="x_COB_help">
<?= $Page->COB->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->COB->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->PENJAMIN->Visible) { // PENJAMIN ?>
    <div id="r_PENJAMIN" class="form-group row">
        <label id="elh_V_FARMASI_PENJAMIN" for="x_PENJAMIN" class="<?= $Page->LeftColumnClass ?>"><?= $Page->PENJAMIN->caption() ?><?= $Page->PENJAMIN->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PENJAMIN->cellAttributes() ?>>
<span id="el_V_FARMASI_PENJAMIN">
<input type="<?= $Page->PENJAMIN->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_PENJAMIN" data-page="1" name="x_PENJAMIN" id="x_PENJAMIN" size="30" maxlength="25" placeholder="<?= HtmlEncode($Page->PENJAMIN->getPlaceHolder()) ?>" value="<?= $Page->PENJAMIN->EditValue ?>"<?= $Page->PENJAMIN->editAttributes() ?> aria-describedby="x_PENJAMIN_help">
<?= $Page->PENJAMIN->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->PENJAMIN->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ASALRUJUKAN->Visible) { // ASALRUJUKAN ?>
    <div id="r_ASALRUJUKAN" class="form-group row">
        <label id="elh_V_FARMASI_ASALRUJUKAN" for="x_ASALRUJUKAN" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ASALRUJUKAN->caption() ?><?= $Page->ASALRUJUKAN->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ASALRUJUKAN->cellAttributes() ?>>
<span id="el_V_FARMASI_ASALRUJUKAN">
<input type="<?= $Page->ASALRUJUKAN->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_ASALRUJUKAN" data-page="1" name="x_ASALRUJUKAN" id="x_ASALRUJUKAN" size="30" maxlength="1" placeholder="<?= HtmlEncode($Page->ASALRUJUKAN->getPlaceHolder()) ?>" value="<?= $Page->ASALRUJUKAN->EditValue ?>"<?= $Page->ASALRUJUKAN->editAttributes() ?> aria-describedby="x_ASALRUJUKAN_help">
<?= $Page->ASALRUJUKAN->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ASALRUJUKAN->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->RESPONSEP->Visible) { // RESPONSEP ?>
    <div id="r_RESPONSEP" class="form-group row">
        <label id="elh_V_FARMASI_RESPONSEP" for="x_RESPONSEP" class="<?= $Page->LeftColumnClass ?>"><?= $Page->RESPONSEP->caption() ?><?= $Page->RESPONSEP->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->RESPONSEP->cellAttributes() ?>>
<span id="el_V_FARMASI_RESPONSEP">
<input type="<?= $Page->RESPONSEP->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_RESPONSEP" data-page="1" name="x_RESPONSEP" id="x_RESPONSEP" size="30" placeholder="<?= HtmlEncode($Page->RESPONSEP->getPlaceHolder()) ?>" value="<?= $Page->RESPONSEP->EditValue ?>"<?= $Page->RESPONSEP->editAttributes() ?> aria-describedby="x_RESPONSEP_help">
<?= $Page->RESPONSEP->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->RESPONSEP->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->APPROVAL_DESC->Visible) { // APPROVAL_DESC ?>
    <div id="r_APPROVAL_DESC" class="form-group row">
        <label id="elh_V_FARMASI_APPROVAL_DESC" for="x_APPROVAL_DESC" class="<?= $Page->LeftColumnClass ?>"><?= $Page->APPROVAL_DESC->caption() ?><?= $Page->APPROVAL_DESC->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->APPROVAL_DESC->cellAttributes() ?>>
<span id="el_V_FARMASI_APPROVAL_DESC">
<input type="<?= $Page->APPROVAL_DESC->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_APPROVAL_DESC" data-page="1" name="x_APPROVAL_DESC" id="x_APPROVAL_DESC" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->APPROVAL_DESC->getPlaceHolder()) ?>" value="<?= $Page->APPROVAL_DESC->EditValue ?>"<?= $Page->APPROVAL_DESC->editAttributes() ?> aria-describedby="x_APPROVAL_DESC_help">
<?= $Page->APPROVAL_DESC->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->APPROVAL_DESC->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->APPROVAL_RESPONAJUKAN->Visible) { // APPROVAL_RESPONAJUKAN ?>
    <div id="r_APPROVAL_RESPONAJUKAN" class="form-group row">
        <label id="elh_V_FARMASI_APPROVAL_RESPONAJUKAN" for="x_APPROVAL_RESPONAJUKAN" class="<?= $Page->LeftColumnClass ?>"><?= $Page->APPROVAL_RESPONAJUKAN->caption() ?><?= $Page->APPROVAL_RESPONAJUKAN->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->APPROVAL_RESPONAJUKAN->cellAttributes() ?>>
<span id="el_V_FARMASI_APPROVAL_RESPONAJUKAN">
<input type="<?= $Page->APPROVAL_RESPONAJUKAN->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_APPROVAL_RESPONAJUKAN" data-page="1" name="x_APPROVAL_RESPONAJUKAN" id="x_APPROVAL_RESPONAJUKAN" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->APPROVAL_RESPONAJUKAN->getPlaceHolder()) ?>" value="<?= $Page->APPROVAL_RESPONAJUKAN->EditValue ?>"<?= $Page->APPROVAL_RESPONAJUKAN->editAttributes() ?> aria-describedby="x_APPROVAL_RESPONAJUKAN_help">
<?= $Page->APPROVAL_RESPONAJUKAN->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->APPROVAL_RESPONAJUKAN->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->APPROVAL_RESPONAPPROV->Visible) { // APPROVAL_RESPONAPPROV ?>
    <div id="r_APPROVAL_RESPONAPPROV" class="form-group row">
        <label id="elh_V_FARMASI_APPROVAL_RESPONAPPROV" for="x_APPROVAL_RESPONAPPROV" class="<?= $Page->LeftColumnClass ?>"><?= $Page->APPROVAL_RESPONAPPROV->caption() ?><?= $Page->APPROVAL_RESPONAPPROV->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->APPROVAL_RESPONAPPROV->cellAttributes() ?>>
<span id="el_V_FARMASI_APPROVAL_RESPONAPPROV">
<input type="<?= $Page->APPROVAL_RESPONAPPROV->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_APPROVAL_RESPONAPPROV" data-page="1" name="x_APPROVAL_RESPONAPPROV" id="x_APPROVAL_RESPONAPPROV" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->APPROVAL_RESPONAPPROV->getPlaceHolder()) ?>" value="<?= $Page->APPROVAL_RESPONAPPROV->EditValue ?>"<?= $Page->APPROVAL_RESPONAPPROV->editAttributes() ?> aria-describedby="x_APPROVAL_RESPONAPPROV_help">
<?= $Page->APPROVAL_RESPONAPPROV->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->APPROVAL_RESPONAPPROV->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->RESPONTGLPLG_DESC->Visible) { // RESPONTGLPLG_DESC ?>
    <div id="r_RESPONTGLPLG_DESC" class="form-group row">
        <label id="elh_V_FARMASI_RESPONTGLPLG_DESC" for="x_RESPONTGLPLG_DESC" class="<?= $Page->LeftColumnClass ?>"><?= $Page->RESPONTGLPLG_DESC->caption() ?><?= $Page->RESPONTGLPLG_DESC->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->RESPONTGLPLG_DESC->cellAttributes() ?>>
<span id="el_V_FARMASI_RESPONTGLPLG_DESC">
<input type="<?= $Page->RESPONTGLPLG_DESC->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_RESPONTGLPLG_DESC" data-page="1" name="x_RESPONTGLPLG_DESC" id="x_RESPONTGLPLG_DESC" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->RESPONTGLPLG_DESC->getPlaceHolder()) ?>" value="<?= $Page->RESPONTGLPLG_DESC->EditValue ?>"<?= $Page->RESPONTGLPLG_DESC->editAttributes() ?> aria-describedby="x_RESPONTGLPLG_DESC_help">
<?= $Page->RESPONTGLPLG_DESC->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->RESPONTGLPLG_DESC->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->RESPONPOST_VKLAIM->Visible) { // RESPONPOST_VKLAIM ?>
    <div id="r_RESPONPOST_VKLAIM" class="form-group row">
        <label id="elh_V_FARMASI_RESPONPOST_VKLAIM" for="x_RESPONPOST_VKLAIM" class="<?= $Page->LeftColumnClass ?>"><?= $Page->RESPONPOST_VKLAIM->caption() ?><?= $Page->RESPONPOST_VKLAIM->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->RESPONPOST_VKLAIM->cellAttributes() ?>>
<span id="el_V_FARMASI_RESPONPOST_VKLAIM">
<input type="<?= $Page->RESPONPOST_VKLAIM->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_RESPONPOST_VKLAIM" data-page="1" name="x_RESPONPOST_VKLAIM" id="x_RESPONPOST_VKLAIM" size="30" placeholder="<?= HtmlEncode($Page->RESPONPOST_VKLAIM->getPlaceHolder()) ?>" value="<?= $Page->RESPONPOST_VKLAIM->EditValue ?>"<?= $Page->RESPONPOST_VKLAIM->editAttributes() ?> aria-describedby="x_RESPONPOST_VKLAIM_help">
<?= $Page->RESPONPOST_VKLAIM->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->RESPONPOST_VKLAIM->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->RESPONPUT_VKLAIM->Visible) { // RESPONPUT_VKLAIM ?>
    <div id="r_RESPONPUT_VKLAIM" class="form-group row">
        <label id="elh_V_FARMASI_RESPONPUT_VKLAIM" for="x_RESPONPUT_VKLAIM" class="<?= $Page->LeftColumnClass ?>"><?= $Page->RESPONPUT_VKLAIM->caption() ?><?= $Page->RESPONPUT_VKLAIM->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->RESPONPUT_VKLAIM->cellAttributes() ?>>
<span id="el_V_FARMASI_RESPONPUT_VKLAIM">
<input type="<?= $Page->RESPONPUT_VKLAIM->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_RESPONPUT_VKLAIM" data-page="1" name="x_RESPONPUT_VKLAIM" id="x_RESPONPUT_VKLAIM" size="30" placeholder="<?= HtmlEncode($Page->RESPONPUT_VKLAIM->getPlaceHolder()) ?>" value="<?= $Page->RESPONPUT_VKLAIM->EditValue ?>"<?= $Page->RESPONPUT_VKLAIM->editAttributes() ?> aria-describedby="x_RESPONPUT_VKLAIM_help">
<?= $Page->RESPONPUT_VKLAIM->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->RESPONPUT_VKLAIM->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->RESPONDEL_VKLAIM->Visible) { // RESPONDEL_VKLAIM ?>
    <div id="r_RESPONDEL_VKLAIM" class="form-group row">
        <label id="elh_V_FARMASI_RESPONDEL_VKLAIM" for="x_RESPONDEL_VKLAIM" class="<?= $Page->LeftColumnClass ?>"><?= $Page->RESPONDEL_VKLAIM->caption() ?><?= $Page->RESPONDEL_VKLAIM->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->RESPONDEL_VKLAIM->cellAttributes() ?>>
<span id="el_V_FARMASI_RESPONDEL_VKLAIM">
<input type="<?= $Page->RESPONDEL_VKLAIM->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_RESPONDEL_VKLAIM" data-page="1" name="x_RESPONDEL_VKLAIM" id="x_RESPONDEL_VKLAIM" size="30" placeholder="<?= HtmlEncode($Page->RESPONDEL_VKLAIM->getPlaceHolder()) ?>" value="<?= $Page->RESPONDEL_VKLAIM->EditValue ?>"<?= $Page->RESPONDEL_VKLAIM->editAttributes() ?> aria-describedby="x_RESPONDEL_VKLAIM_help">
<?= $Page->RESPONDEL_VKLAIM->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->RESPONDEL_VKLAIM->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->CALL_TIMES->Visible) { // CALL_TIMES ?>
    <div id="r_CALL_TIMES" class="form-group row">
        <label id="elh_V_FARMASI_CALL_TIMES" for="x_CALL_TIMES" class="<?= $Page->LeftColumnClass ?>"><?= $Page->CALL_TIMES->caption() ?><?= $Page->CALL_TIMES->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->CALL_TIMES->cellAttributes() ?>>
<span id="el_V_FARMASI_CALL_TIMES">
<input type="<?= $Page->CALL_TIMES->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_CALL_TIMES" data-page="1" name="x_CALL_TIMES" id="x_CALL_TIMES" size="30" placeholder="<?= HtmlEncode($Page->CALL_TIMES->getPlaceHolder()) ?>" value="<?= $Page->CALL_TIMES->EditValue ?>"<?= $Page->CALL_TIMES->editAttributes() ?> aria-describedby="x_CALL_TIMES_help">
<?= $Page->CALL_TIMES->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->CALL_TIMES->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->CALL_DATE->Visible) { // CALL_DATE ?>
    <div id="r_CALL_DATE" class="form-group row">
        <label id="elh_V_FARMASI_CALL_DATE" for="x_CALL_DATE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->CALL_DATE->caption() ?><?= $Page->CALL_DATE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->CALL_DATE->cellAttributes() ?>>
<span id="el_V_FARMASI_CALL_DATE">
<input type="<?= $Page->CALL_DATE->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_CALL_DATE" data-page="1" name="x_CALL_DATE" id="x_CALL_DATE" placeholder="<?= HtmlEncode($Page->CALL_DATE->getPlaceHolder()) ?>" value="<?= $Page->CALL_DATE->EditValue ?>"<?= $Page->CALL_DATE->editAttributes() ?> aria-describedby="x_CALL_DATE_help">
<?= $Page->CALL_DATE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->CALL_DATE->getErrorMessage() ?></div>
<?php if (!$Page->CALL_DATE->ReadOnly && !$Page->CALL_DATE->Disabled && !isset($Page->CALL_DATE->EditAttrs["readonly"]) && !isset($Page->CALL_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fV_FARMASIadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fV_FARMASIadd", "x_CALL_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->CALL_DATES->Visible) { // CALL_DATES ?>
    <div id="r_CALL_DATES" class="form-group row">
        <label id="elh_V_FARMASI_CALL_DATES" for="x_CALL_DATES" class="<?= $Page->LeftColumnClass ?>"><?= $Page->CALL_DATES->caption() ?><?= $Page->CALL_DATES->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->CALL_DATES->cellAttributes() ?>>
<span id="el_V_FARMASI_CALL_DATES">
<input type="<?= $Page->CALL_DATES->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_CALL_DATES" data-page="1" name="x_CALL_DATES" id="x_CALL_DATES" placeholder="<?= HtmlEncode($Page->CALL_DATES->getPlaceHolder()) ?>" value="<?= $Page->CALL_DATES->EditValue ?>"<?= $Page->CALL_DATES->editAttributes() ?> aria-describedby="x_CALL_DATES_help">
<?= $Page->CALL_DATES->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->CALL_DATES->getErrorMessage() ?></div>
<?php if (!$Page->CALL_DATES->ReadOnly && !$Page->CALL_DATES->Disabled && !isset($Page->CALL_DATES->EditAttrs["readonly"]) && !isset($Page->CALL_DATES->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fV_FARMASIadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fV_FARMASIadd", "x_CALL_DATES", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->SERVED_DATE->Visible) { // SERVED_DATE ?>
    <div id="r_SERVED_DATE" class="form-group row">
        <label id="elh_V_FARMASI_SERVED_DATE" for="x_SERVED_DATE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->SERVED_DATE->caption() ?><?= $Page->SERVED_DATE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->SERVED_DATE->cellAttributes() ?>>
<span id="el_V_FARMASI_SERVED_DATE">
<input type="<?= $Page->SERVED_DATE->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_SERVED_DATE" data-page="1" name="x_SERVED_DATE" id="x_SERVED_DATE" placeholder="<?= HtmlEncode($Page->SERVED_DATE->getPlaceHolder()) ?>" value="<?= $Page->SERVED_DATE->EditValue ?>"<?= $Page->SERVED_DATE->editAttributes() ?> aria-describedby="x_SERVED_DATE_help">
<?= $Page->SERVED_DATE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->SERVED_DATE->getErrorMessage() ?></div>
<?php if (!$Page->SERVED_DATE->ReadOnly && !$Page->SERVED_DATE->Disabled && !isset($Page->SERVED_DATE->EditAttrs["readonly"]) && !isset($Page->SERVED_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fV_FARMASIadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fV_FARMASIadd", "x_SERVED_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->SERVED_INAP->Visible) { // SERVED_INAP ?>
    <div id="r_SERVED_INAP" class="form-group row">
        <label id="elh_V_FARMASI_SERVED_INAP" for="x_SERVED_INAP" class="<?= $Page->LeftColumnClass ?>"><?= $Page->SERVED_INAP->caption() ?><?= $Page->SERVED_INAP->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->SERVED_INAP->cellAttributes() ?>>
<span id="el_V_FARMASI_SERVED_INAP">
<input type="<?= $Page->SERVED_INAP->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_SERVED_INAP" data-page="1" name="x_SERVED_INAP" id="x_SERVED_INAP" placeholder="<?= HtmlEncode($Page->SERVED_INAP->getPlaceHolder()) ?>" value="<?= $Page->SERVED_INAP->EditValue ?>"<?= $Page->SERVED_INAP->editAttributes() ?> aria-describedby="x_SERVED_INAP_help">
<?= $Page->SERVED_INAP->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->SERVED_INAP->getErrorMessage() ?></div>
<?php if (!$Page->SERVED_INAP->ReadOnly && !$Page->SERVED_INAP->Disabled && !isset($Page->SERVED_INAP->EditAttrs["readonly"]) && !isset($Page->SERVED_INAP->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fV_FARMASIadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fV_FARMASIadd", "x_SERVED_INAP", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->KDDPJP1->Visible) { // KDDPJP1 ?>
    <div id="r_KDDPJP1" class="form-group row">
        <label id="elh_V_FARMASI_KDDPJP1" for="x_KDDPJP1" class="<?= $Page->LeftColumnClass ?>"><?= $Page->KDDPJP1->caption() ?><?= $Page->KDDPJP1->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->KDDPJP1->cellAttributes() ?>>
<span id="el_V_FARMASI_KDDPJP1">
<input type="<?= $Page->KDDPJP1->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_KDDPJP1" data-page="1" name="x_KDDPJP1" id="x_KDDPJP1" size="30" maxlength="25" placeholder="<?= HtmlEncode($Page->KDDPJP1->getPlaceHolder()) ?>" value="<?= $Page->KDDPJP1->EditValue ?>"<?= $Page->KDDPJP1->editAttributes() ?> aria-describedby="x_KDDPJP1_help">
<?= $Page->KDDPJP1->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->KDDPJP1->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->KDDPJP->Visible) { // KDDPJP ?>
    <div id="r_KDDPJP" class="form-group row">
        <label id="elh_V_FARMASI_KDDPJP" for="x_KDDPJP" class="<?= $Page->LeftColumnClass ?>"><?= $Page->KDDPJP->caption() ?><?= $Page->KDDPJP->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->KDDPJP->cellAttributes() ?>>
<span id="el_V_FARMASI_KDDPJP">
<input type="<?= $Page->KDDPJP->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_KDDPJP" data-page="1" name="x_KDDPJP" id="x_KDDPJP" size="30" maxlength="25" placeholder="<?= HtmlEncode($Page->KDDPJP->getPlaceHolder()) ?>" value="<?= $Page->KDDPJP->EditValue ?>"<?= $Page->KDDPJP->editAttributes() ?> aria-describedby="x_KDDPJP_help">
<?= $Page->KDDPJP->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->KDDPJP->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tgl_kontrol->Visible) { // tgl_kontrol ?>
    <div id="r_tgl_kontrol" class="form-group row">
        <label id="elh_V_FARMASI_tgl_kontrol" for="x_tgl_kontrol" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tgl_kontrol->caption() ?><?= $Page->tgl_kontrol->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tgl_kontrol->cellAttributes() ?>>
<span id="el_V_FARMASI_tgl_kontrol">
<input type="<?= $Page->tgl_kontrol->getInputTextType() ?>" data-table="V_FARMASI" data-field="x_tgl_kontrol" data-page="1" name="x_tgl_kontrol" id="x_tgl_kontrol" placeholder="<?= HtmlEncode($Page->tgl_kontrol->getPlaceHolder()) ?>" value="<?= $Page->tgl_kontrol->EditValue ?>"<?= $Page->tgl_kontrol->editAttributes() ?> aria-describedby="x_tgl_kontrol_help">
<?= $Page->tgl_kontrol->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tgl_kontrol->getErrorMessage() ?></div>
<?php if (!$Page->tgl_kontrol->ReadOnly && !$Page->tgl_kontrol->Disabled && !isset($Page->tgl_kontrol->EditAttrs["readonly"]) && !isset($Page->tgl_kontrol->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fV_FARMASIadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fV_FARMASIadd", "x_tgl_kontrol", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$Page->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("AddBtn") ?></button>
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
    ew.addEventHandlers("V_FARMASI");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
