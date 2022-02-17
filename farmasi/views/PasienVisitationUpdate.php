<?php

namespace PHPMaker2021\SIMRS;

// Page object
$PasienVisitationUpdate = &$Page;
?>
<script>
var currentForm, currentPageID;
var fPASIEN_VISITATIONupdate;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "update";
    fPASIEN_VISITATIONupdate = currentForm = new ew.Form("fPASIEN_VISITATIONupdate", "update");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "PASIEN_VISITATION")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.PASIEN_VISITATION)
        ew.vars.tables.PASIEN_VISITATION = currentTable;
    fPASIEN_VISITATIONupdate.addFields([
        ["ORG_UNIT_CODE", [fields.ORG_UNIT_CODE.visible && fields.ORG_UNIT_CODE.required ? ew.Validators.required(fields.ORG_UNIT_CODE.caption) : null], fields.ORG_UNIT_CODE.isInvalid],
        ["VISIT_ID", [fields.VISIT_ID.visible && fields.VISIT_ID.required ? ew.Validators.required(fields.VISIT_ID.caption) : null], fields.VISIT_ID.isInvalid],
        ["NO_REGISTRATION", [fields.NO_REGISTRATION.visible && fields.NO_REGISTRATION.required ? ew.Validators.required(fields.NO_REGISTRATION.caption) : null], fields.NO_REGISTRATION.isInvalid],
        ["DIANTAR_OLEH", [fields.DIANTAR_OLEH.visible && fields.DIANTAR_OLEH.required ? ew.Validators.required(fields.DIANTAR_OLEH.caption) : null], fields.DIANTAR_OLEH.isInvalid],
        ["STATUS_PASIEN_ID", [fields.STATUS_PASIEN_ID.visible && fields.STATUS_PASIEN_ID.required ? ew.Validators.required(fields.STATUS_PASIEN_ID.caption) : null], fields.STATUS_PASIEN_ID.isInvalid],
        ["RUJUKAN_ID", [fields.RUJUKAN_ID.visible && fields.RUJUKAN_ID.required ? ew.Validators.required(fields.RUJUKAN_ID.caption) : null], fields.RUJUKAN_ID.isInvalid],
        ["ADDRESS_OF_RUJUKAN", [fields.ADDRESS_OF_RUJUKAN.visible && fields.ADDRESS_OF_RUJUKAN.required ? ew.Validators.required(fields.ADDRESS_OF_RUJUKAN.caption) : null], fields.ADDRESS_OF_RUJUKAN.isInvalid],
        ["REASON_ID", [fields.REASON_ID.visible && fields.REASON_ID.required ? ew.Validators.required(fields.REASON_ID.caption) : null], fields.REASON_ID.isInvalid],
        ["WAY_ID", [fields.WAY_ID.visible && fields.WAY_ID.required ? ew.Validators.required(fields.WAY_ID.caption) : null], fields.WAY_ID.isInvalid],
        ["PATIENT_CATEGORY_ID", [fields.PATIENT_CATEGORY_ID.visible && fields.PATIENT_CATEGORY_ID.required ? ew.Validators.required(fields.PATIENT_CATEGORY_ID.caption) : null], fields.PATIENT_CATEGORY_ID.isInvalid],
        ["BOOKED_DATE", [fields.BOOKED_DATE.visible && fields.BOOKED_DATE.required ? ew.Validators.required(fields.BOOKED_DATE.caption) : null], fields.BOOKED_DATE.isInvalid],
        ["VISIT_DATE", [fields.VISIT_DATE.visible && fields.VISIT_DATE.required ? ew.Validators.required(fields.VISIT_DATE.caption) : null], fields.VISIT_DATE.isInvalid],
        ["ISNEW", [fields.ISNEW.visible && fields.ISNEW.required ? ew.Validators.required(fields.ISNEW.caption) : null], fields.ISNEW.isInvalid],
        ["FOLLOW_UP", [fields.FOLLOW_UP.visible && fields.FOLLOW_UP.required ? ew.Validators.required(fields.FOLLOW_UP.caption) : null], fields.FOLLOW_UP.isInvalid],
        ["PLACE_TYPE", [fields.PLACE_TYPE.visible && fields.PLACE_TYPE.required ? ew.Validators.required(fields.PLACE_TYPE.caption) : null], fields.PLACE_TYPE.isInvalid],
        ["CLINIC_ID", [fields.CLINIC_ID.visible && fields.CLINIC_ID.required ? ew.Validators.required(fields.CLINIC_ID.caption) : null], fields.CLINIC_ID.isInvalid],
        ["CLINIC_ID_FROM", [fields.CLINIC_ID_FROM.visible && fields.CLINIC_ID_FROM.required ? ew.Validators.required(fields.CLINIC_ID_FROM.caption) : null], fields.CLINIC_ID_FROM.isInvalid],
        ["CLASS_ROOM_ID", [fields.CLASS_ROOM_ID.visible && fields.CLASS_ROOM_ID.required ? ew.Validators.required(fields.CLASS_ROOM_ID.caption) : null], fields.CLASS_ROOM_ID.isInvalid],
        ["BED_ID", [fields.BED_ID.visible && fields.BED_ID.required ? ew.Validators.required(fields.BED_ID.caption) : null], fields.BED_ID.isInvalid],
        ["KELUAR_ID", [fields.KELUAR_ID.visible && fields.KELUAR_ID.required ? ew.Validators.required(fields.KELUAR_ID.caption) : null], fields.KELUAR_ID.isInvalid],
        ["IN_DATE", [fields.IN_DATE.visible && fields.IN_DATE.required ? ew.Validators.required(fields.IN_DATE.caption) : null], fields.IN_DATE.isInvalid],
        ["EXIT_DATE", [fields.EXIT_DATE.visible && fields.EXIT_DATE.required ? ew.Validators.required(fields.EXIT_DATE.caption) : null], fields.EXIT_DATE.isInvalid],
        ["GENDER", [fields.GENDER.visible && fields.GENDER.required ? ew.Validators.required(fields.GENDER.caption) : null], fields.GENDER.isInvalid],
        ["KODE_AGAMA", [fields.KODE_AGAMA.visible && fields.KODE_AGAMA.required ? ew.Validators.required(fields.KODE_AGAMA.caption) : null], fields.KODE_AGAMA.isInvalid],
        ["DESCRIPTION", [fields.DESCRIPTION.visible && fields.DESCRIPTION.required ? ew.Validators.required(fields.DESCRIPTION.caption) : null], fields.DESCRIPTION.isInvalid],
        ["VISITOR_ADDRESS", [fields.VISITOR_ADDRESS.visible && fields.VISITOR_ADDRESS.required ? ew.Validators.required(fields.VISITOR_ADDRESS.caption) : null], fields.VISITOR_ADDRESS.isInvalid],
        ["MODIFIED_BY", [fields.MODIFIED_BY.visible && fields.MODIFIED_BY.required ? ew.Validators.required(fields.MODIFIED_BY.caption) : null], fields.MODIFIED_BY.isInvalid],
        ["MODIFIED_DATE", [fields.MODIFIED_DATE.visible && fields.MODIFIED_DATE.required ? ew.Validators.required(fields.MODIFIED_DATE.caption) : null], fields.MODIFIED_DATE.isInvalid],
        ["MODIFIED_FROM", [fields.MODIFIED_FROM.visible && fields.MODIFIED_FROM.required ? ew.Validators.required(fields.MODIFIED_FROM.caption) : null], fields.MODIFIED_FROM.isInvalid],
        ["EMPLOYEE_ID", [fields.EMPLOYEE_ID.visible && fields.EMPLOYEE_ID.required ? ew.Validators.required(fields.EMPLOYEE_ID.caption) : null], fields.EMPLOYEE_ID.isInvalid],
        ["EMPLOYEE_ID_FROM", [fields.EMPLOYEE_ID_FROM.visible && fields.EMPLOYEE_ID_FROM.required ? ew.Validators.required(fields.EMPLOYEE_ID_FROM.caption) : null], fields.EMPLOYEE_ID_FROM.isInvalid],
        ["RESPONSIBLE_ID", [fields.RESPONSIBLE_ID.visible && fields.RESPONSIBLE_ID.required ? ew.Validators.required(fields.RESPONSIBLE_ID.caption) : null], fields.RESPONSIBLE_ID.isInvalid],
        ["RESPONSIBLE", [fields.RESPONSIBLE.visible && fields.RESPONSIBLE.required ? ew.Validators.required(fields.RESPONSIBLE.caption) : null], fields.RESPONSIBLE.isInvalid],
        ["FAMILY_STATUS_ID", [fields.FAMILY_STATUS_ID.visible && fields.FAMILY_STATUS_ID.required ? ew.Validators.required(fields.FAMILY_STATUS_ID.caption) : null], fields.FAMILY_STATUS_ID.isInvalid],
        ["TICKET_NO", [fields.TICKET_NO.visible && fields.TICKET_NO.required ? ew.Validators.required(fields.TICKET_NO.caption) : null], fields.TICKET_NO.isInvalid],
        ["ISATTENDED", [fields.ISATTENDED.visible && fields.ISATTENDED.required ? ew.Validators.required(fields.ISATTENDED.caption) : null], fields.ISATTENDED.isInvalid],
        ["PAYOR_ID", [fields.PAYOR_ID.visible && fields.PAYOR_ID.required ? ew.Validators.required(fields.PAYOR_ID.caption) : null], fields.PAYOR_ID.isInvalid],
        ["CLASS_ID", [fields.CLASS_ID.visible && fields.CLASS_ID.required ? ew.Validators.required(fields.CLASS_ID.caption) : null], fields.CLASS_ID.isInvalid],
        ["ISPERTARIF", [fields.ISPERTARIF.visible && fields.ISPERTARIF.required ? ew.Validators.required(fields.ISPERTARIF.caption) : null], fields.ISPERTARIF.isInvalid],
        ["KAL_ID", [fields.KAL_ID.visible && fields.KAL_ID.required ? ew.Validators.required(fields.KAL_ID.caption) : null], fields.KAL_ID.isInvalid],
        ["EMPLOYEE_INAP", [fields.EMPLOYEE_INAP.visible && fields.EMPLOYEE_INAP.required ? ew.Validators.required(fields.EMPLOYEE_INAP.caption) : null], fields.EMPLOYEE_INAP.isInvalid],
        ["PASIEN_ID", [fields.PASIEN_ID.visible && fields.PASIEN_ID.required ? ew.Validators.required(fields.PASIEN_ID.caption) : null], fields.PASIEN_ID.isInvalid],
        ["KARYAWAN", [fields.KARYAWAN.visible && fields.KARYAWAN.required ? ew.Validators.required(fields.KARYAWAN.caption) : null], fields.KARYAWAN.isInvalid],
        ["ACCOUNT_ID", [fields.ACCOUNT_ID.visible && fields.ACCOUNT_ID.required ? ew.Validators.required(fields.ACCOUNT_ID.caption) : null], fields.ACCOUNT_ID.isInvalid],
        ["CLASS_ID_PLAFOND", [fields.CLASS_ID_PLAFOND.visible && fields.CLASS_ID_PLAFOND.required ? ew.Validators.required(fields.CLASS_ID_PLAFOND.caption) : null], fields.CLASS_ID_PLAFOND.isInvalid],
        ["BACKCHARGE", [fields.BACKCHARGE.visible && fields.BACKCHARGE.required ? ew.Validators.required(fields.BACKCHARGE.caption) : null], fields.BACKCHARGE.isInvalid],
        ["COVERAGE_ID", [fields.COVERAGE_ID.visible && fields.COVERAGE_ID.required ? ew.Validators.required(fields.COVERAGE_ID.caption) : null], fields.COVERAGE_ID.isInvalid],
        ["AGEYEAR", [fields.AGEYEAR.visible && fields.AGEYEAR.required ? ew.Validators.required(fields.AGEYEAR.caption) : null], fields.AGEYEAR.isInvalid],
        ["AGEMONTH", [fields.AGEMONTH.visible && fields.AGEMONTH.required ? ew.Validators.required(fields.AGEMONTH.caption) : null], fields.AGEMONTH.isInvalid],
        ["AGEDAY", [fields.AGEDAY.visible && fields.AGEDAY.required ? ew.Validators.required(fields.AGEDAY.caption) : null], fields.AGEDAY.isInvalid],
        ["RECOMENDATION", [fields.RECOMENDATION.visible && fields.RECOMENDATION.required ? ew.Validators.required(fields.RECOMENDATION.caption) : null], fields.RECOMENDATION.isInvalid],
        ["CONCLUSION", [fields.CONCLUSION.visible && fields.CONCLUSION.required ? ew.Validators.required(fields.CONCLUSION.caption) : null], fields.CONCLUSION.isInvalid],
        ["SPECIMENNO", [fields.SPECIMENNO.visible && fields.SPECIMENNO.required ? ew.Validators.required(fields.SPECIMENNO.caption) : null], fields.SPECIMENNO.isInvalid],
        ["LOCKED", [fields.LOCKED.visible && fields.LOCKED.required ? ew.Validators.required(fields.LOCKED.caption) : null], fields.LOCKED.isInvalid],
        ["RM_OUT_DATE", [fields.RM_OUT_DATE.visible && fields.RM_OUT_DATE.required ? ew.Validators.required(fields.RM_OUT_DATE.caption) : null], fields.RM_OUT_DATE.isInvalid],
        ["RM_IN_DATE", [fields.RM_IN_DATE.visible && fields.RM_IN_DATE.required ? ew.Validators.required(fields.RM_IN_DATE.caption) : null], fields.RM_IN_DATE.isInvalid],
        ["LAMA_PINJAM", [fields.LAMA_PINJAM.visible && fields.LAMA_PINJAM.required ? ew.Validators.required(fields.LAMA_PINJAM.caption) : null], fields.LAMA_PINJAM.isInvalid],
        ["STANDAR_RJ", [fields.STANDAR_RJ.visible && fields.STANDAR_RJ.required ? ew.Validators.required(fields.STANDAR_RJ.caption) : null], fields.STANDAR_RJ.isInvalid],
        ["LENGKAP_RJ", [fields.LENGKAP_RJ.visible && fields.LENGKAP_RJ.required ? ew.Validators.required(fields.LENGKAP_RJ.caption) : null], fields.LENGKAP_RJ.isInvalid],
        ["LENGKAP_RI", [fields.LENGKAP_RI.visible && fields.LENGKAP_RI.required ? ew.Validators.required(fields.LENGKAP_RI.caption) : null], fields.LENGKAP_RI.isInvalid],
        ["RESEND_RM_DATE", [fields.RESEND_RM_DATE.visible && fields.RESEND_RM_DATE.required ? ew.Validators.required(fields.RESEND_RM_DATE.caption) : null], fields.RESEND_RM_DATE.isInvalid],
        ["LENGKAP_RM1", [fields.LENGKAP_RM1.visible && fields.LENGKAP_RM1.required ? ew.Validators.required(fields.LENGKAP_RM1.caption) : null], fields.LENGKAP_RM1.isInvalid],
        ["LENGKAP_RESUME", [fields.LENGKAP_RESUME.visible && fields.LENGKAP_RESUME.required ? ew.Validators.required(fields.LENGKAP_RESUME.caption) : null], fields.LENGKAP_RESUME.isInvalid],
        ["LENGKAP_ANAMNESIS", [fields.LENGKAP_ANAMNESIS.visible && fields.LENGKAP_ANAMNESIS.required ? ew.Validators.required(fields.LENGKAP_ANAMNESIS.caption) : null], fields.LENGKAP_ANAMNESIS.isInvalid],
        ["LENGKAP_CONSENT", [fields.LENGKAP_CONSENT.visible && fields.LENGKAP_CONSENT.required ? ew.Validators.required(fields.LENGKAP_CONSENT.caption) : null], fields.LENGKAP_CONSENT.isInvalid],
        ["LENGKAP_ANESTESI", [fields.LENGKAP_ANESTESI.visible && fields.LENGKAP_ANESTESI.required ? ew.Validators.required(fields.LENGKAP_ANESTESI.caption) : null], fields.LENGKAP_ANESTESI.isInvalid],
        ["LENGKAP_OP", [fields.LENGKAP_OP.visible && fields.LENGKAP_OP.required ? ew.Validators.required(fields.LENGKAP_OP.caption) : null], fields.LENGKAP_OP.isInvalid],
        ["BACK_RM_DATE", [fields.BACK_RM_DATE.visible && fields.BACK_RM_DATE.required ? ew.Validators.required(fields.BACK_RM_DATE.caption) : null], fields.BACK_RM_DATE.isInvalid],
        ["VALID_RM_DATE", [fields.VALID_RM_DATE.visible && fields.VALID_RM_DATE.required ? ew.Validators.required(fields.VALID_RM_DATE.caption) : null], fields.VALID_RM_DATE.isInvalid],
        ["NO_SKP", [fields.NO_SKP.visible && fields.NO_SKP.required ? ew.Validators.required(fields.NO_SKP.caption) : null], fields.NO_SKP.isInvalid],
        ["NO_SKPINAP", [fields.NO_SKPINAP.visible && fields.NO_SKPINAP.required ? ew.Validators.required(fields.NO_SKPINAP.caption) : null], fields.NO_SKPINAP.isInvalid],
        ["DIAGNOSA_ID", [fields.DIAGNOSA_ID.visible && fields.DIAGNOSA_ID.required ? ew.Validators.required(fields.DIAGNOSA_ID.caption) : null], fields.DIAGNOSA_ID.isInvalid],
        ["ticket_all", [fields.ticket_all.visible && fields.ticket_all.required ? ew.Validators.required(fields.ticket_all.caption) : null], fields.ticket_all.isInvalid],
        ["tanggal_rujukan", [fields.tanggal_rujukan.visible && fields.tanggal_rujukan.required ? ew.Validators.required(fields.tanggal_rujukan.caption) : null], fields.tanggal_rujukan.isInvalid],
        ["ISRJ", [fields.ISRJ.visible && fields.ISRJ.required ? ew.Validators.required(fields.ISRJ.caption) : null], fields.ISRJ.isInvalid],
        ["NORUJUKAN", [fields.NORUJUKAN.visible && fields.NORUJUKAN.required ? ew.Validators.required(fields.NORUJUKAN.caption) : null], fields.NORUJUKAN.isInvalid],
        ["PPKRUJUKAN", [fields.PPKRUJUKAN.visible && fields.PPKRUJUKAN.required ? ew.Validators.required(fields.PPKRUJUKAN.caption) : null], fields.PPKRUJUKAN.isInvalid],
        ["LOKASILAKA", [fields.LOKASILAKA.visible && fields.LOKASILAKA.required ? ew.Validators.required(fields.LOKASILAKA.caption) : null], fields.LOKASILAKA.isInvalid],
        ["KDPOLI", [fields.KDPOLI.visible && fields.KDPOLI.required ? ew.Validators.required(fields.KDPOLI.caption) : null], fields.KDPOLI.isInvalid],
        ["EDIT_SEP", [fields.EDIT_SEP.visible && fields.EDIT_SEP.required ? ew.Validators.required(fields.EDIT_SEP.caption) : null], fields.EDIT_SEP.isInvalid],
        ["DELETE_SEP", [fields.DELETE_SEP.visible && fields.DELETE_SEP.required ? ew.Validators.required(fields.DELETE_SEP.caption) : null], fields.DELETE_SEP.isInvalid],
        ["DIAG_AWAL", [fields.DIAG_AWAL.visible && fields.DIAG_AWAL.required ? ew.Validators.required(fields.DIAG_AWAL.caption) : null], fields.DIAG_AWAL.isInvalid],
        ["AKTIF", [fields.AKTIF.visible && fields.AKTIF.required ? ew.Validators.required(fields.AKTIF.caption) : null], fields.AKTIF.isInvalid],
        ["BILL_INAP", [fields.BILL_INAP.visible && fields.BILL_INAP.required ? ew.Validators.required(fields.BILL_INAP.caption) : null], fields.BILL_INAP.isInvalid],
        ["SEP_PRINTDATE", [fields.SEP_PRINTDATE.visible && fields.SEP_PRINTDATE.required ? ew.Validators.required(fields.SEP_PRINTDATE.caption) : null], fields.SEP_PRINTDATE.isInvalid],
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
        ["CALL_TIMES", [fields.CALL_TIMES.visible && fields.CALL_TIMES.required ? ew.Validators.required(fields.CALL_TIMES.caption) : null], fields.CALL_TIMES.isInvalid],
        ["CALL_DATE", [fields.CALL_DATE.visible && fields.CALL_DATE.required ? ew.Validators.required(fields.CALL_DATE.caption) : null], fields.CALL_DATE.isInvalid],
        ["CALL_DATES", [fields.CALL_DATES.visible && fields.CALL_DATES.required ? ew.Validators.required(fields.CALL_DATES.caption) : null], fields.CALL_DATES.isInvalid],
        ["SERVED_DATE", [fields.SERVED_DATE.visible && fields.SERVED_DATE.required ? ew.Validators.required(fields.SERVED_DATE.caption) : null], fields.SERVED_DATE.isInvalid],
        ["SERVED_INAP", [fields.SERVED_INAP.visible && fields.SERVED_INAP.required ? ew.Validators.required(fields.SERVED_INAP.caption) : null], fields.SERVED_INAP.isInvalid],
        ["KDDPJP1", [fields.KDDPJP1.visible && fields.KDDPJP1.required ? ew.Validators.required(fields.KDDPJP1.caption) : null], fields.KDDPJP1.isInvalid],
        ["KDDPJP", [fields.KDDPJP.visible && fields.KDDPJP.required ? ew.Validators.required(fields.KDDPJP.caption) : null], fields.KDDPJP.isInvalid],
        ["SEP", [fields.SEP.visible && fields.SEP.required ? ew.Validators.required(fields.SEP.caption) : null], fields.SEP.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fPASIEN_VISITATIONupdate,
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
    fPASIEN_VISITATIONupdate.validate = function () {
        if (!this.validateRequired)
            return true; // Ignore validation
        var fobj = this.getForm(),
            $fobj = $(fobj);
        if ($fobj.find("#confirm").val() == "confirm")
            return true;
        if (!ew.updateSelected(fobj)) {
            ew.alert(ew.language.phrase("NoFieldSelected"));
            return false;
        }
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
        return true;
    }

    // Form_CustomValidate
    fPASIEN_VISITATIONupdate.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fPASIEN_VISITATIONupdate.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fPASIEN_VISITATIONupdate.lists.NO_REGISTRATION = <?= $Page->NO_REGISTRATION->toClientList($Page) ?>;
    fPASIEN_VISITATIONupdate.lists.STATUS_PASIEN_ID = <?= $Page->STATUS_PASIEN_ID->toClientList($Page) ?>;
    fPASIEN_VISITATIONupdate.lists.RUJUKAN_ID = <?= $Page->RUJUKAN_ID->toClientList($Page) ?>;
    fPASIEN_VISITATIONupdate.lists.ADDRESS_OF_RUJUKAN = <?= $Page->ADDRESS_OF_RUJUKAN->toClientList($Page) ?>;
    fPASIEN_VISITATIONupdate.lists.REASON_ID = <?= $Page->REASON_ID->toClientList($Page) ?>;
    fPASIEN_VISITATIONupdate.lists.WAY_ID = <?= $Page->WAY_ID->toClientList($Page) ?>;
    fPASIEN_VISITATIONupdate.lists.PATIENT_CATEGORY_ID = <?= $Page->PATIENT_CATEGORY_ID->toClientList($Page) ?>;
    fPASIEN_VISITATIONupdate.lists.ISNEW = <?= $Page->ISNEW->toClientList($Page) ?>;
    fPASIEN_VISITATIONupdate.lists.CLINIC_ID = <?= $Page->CLINIC_ID->toClientList($Page) ?>;
    fPASIEN_VISITATIONupdate.lists.CLINIC_ID_FROM = <?= $Page->CLINIC_ID_FROM->toClientList($Page) ?>;
    fPASIEN_VISITATIONupdate.lists.KELUAR_ID = <?= $Page->KELUAR_ID->toClientList($Page) ?>;
    fPASIEN_VISITATIONupdate.lists.GENDER = <?= $Page->GENDER->toClientList($Page) ?>;
    fPASIEN_VISITATIONupdate.lists.KODE_AGAMA = <?= $Page->KODE_AGAMA->toClientList($Page) ?>;
    fPASIEN_VISITATIONupdate.lists.EMPLOYEE_ID = <?= $Page->EMPLOYEE_ID->toClientList($Page) ?>;
    fPASIEN_VISITATIONupdate.lists.RESPONSIBLE_ID = <?= $Page->RESPONSIBLE_ID->toClientList($Page) ?>;
    fPASIEN_VISITATIONupdate.lists.PAYOR_ID = <?= $Page->PAYOR_ID->toClientList($Page) ?>;
    fPASIEN_VISITATIONupdate.lists.CLASS_ID = <?= $Page->CLASS_ID->toClientList($Page) ?>;
    fPASIEN_VISITATIONupdate.lists.KAL_ID = <?= $Page->KAL_ID->toClientList($Page) ?>;
    fPASIEN_VISITATIONupdate.lists.COVERAGE_ID = <?= $Page->COVERAGE_ID->toClientList($Page) ?>;
    fPASIEN_VISITATIONupdate.lists.DIAGNOSA_ID = <?= $Page->DIAGNOSA_ID->toClientList($Page) ?>;
    fPASIEN_VISITATIONupdate.lists.ISRJ = <?= $Page->ISRJ->toClientList($Page) ?>;
    fPASIEN_VISITATIONupdate.lists.PPKRUJUKAN = <?= $Page->PPKRUJUKAN->toClientList($Page) ?>;
    fPASIEN_VISITATIONupdate.lists.COB = <?= $Page->COB->toClientList($Page) ?>;
    loadjs.done("fPASIEN_VISITATIONupdate");
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
<form name="fPASIEN_VISITATIONupdate" id="fPASIEN_VISITATIONupdate" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="PASIEN_VISITATION">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php foreach ($Page->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?= HtmlEncode($keyvalue) ?>">
<?php } ?>
<div id="tbl_PASIEN_VISITATIONupdate" class="ew-update-div"><!-- page -->
    <?php if (!$Page->isConfirm()) { // Confirm page ?>
    <div class="custom-control custom-checkbox">
        <input type="checkbox" class="custom-control-input" name="u" id="u" onclick="ew.selectAll(this);"><label class="custom-control-label" for="u"><?= $Language->phrase("UpdateSelectAll") ?></label>
    </div>
    <?php } ?>
<?php if ($Page->SEP->Visible && (!$Page->isConfirm() || $Page->SEP->multiUpdateSelected())) { // SEP ?>
    <div id="r_SEP" class="form-group row">
        <label for="x_SEP" class="<?= $Page->LeftColumnClass ?>">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" name="u_SEP" id="u_SEP" class="custom-control-input ew-multi-select" value="1"<?= $Page->SEP->multiUpdateSelected() ? " checked" : "" ?>>
                <label class="custom-control-label" for="u_SEP"><?= $Page->SEP->caption() ?></label>
            </div>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div <?= $Page->SEP->cellAttributes() ?>>
                <span id="el_PASIEN_VISITATION_SEP">
                <script>

                function Buka(link="") {
                	window.open(link, 'newwindow', 'width=800,height=400');
                	return false;
                }
                </script>
                <!--<?php
                if (empty(CurrentPage()->no_sep->CurrentValue)){
                ?>
                <a href="../simrs/bridging/rajalsep.php?key=<?php echo urlencode(CurrentPage()->no_kartu->CurrentValue).'&rujukan='.urlencode(CurrentPage()->no_rujuk->CurrentValue).'&eksekutif='.urlencode(CurrentPage()->eksekutif->CurrentValue).'&nosurat='.urlencode(CurrentPage()->no_surat_rujukan->CurrentValue).'&dpjp='.urlencode(CurrentPage()->kddokter->CurrentValue).'&id='.urlencode(CurrentPage()->idxdaftar->CurrentValue).'&catatan='.urlencode(CurrentPage()->catatan->CurrentValue)?>" class="btn btn-info btn-sm" role="button">BUAT</a>
                <?php } else {?>
                <a href="#" onclick="Buka('../simrs/bridging/cetaksep.php?id=<?php echo urlencode(CurrentPage()->idxdaftar->CurrentValue) ;?>'); return false" class="btn btn-info btn-sm" role="button">CETAK</a>
                <?php } ?>-->
                <div class="btn-group btn-group-sm ew-btn-group">
                	<a class="btn btn-primary ew-row-link ew-detail" href="print.html"
                	onclick="Buka('/simrs/reporting/jasper.php?id=<?php echo urlencode(CurrentPage()->VISIT_ID->CurrentValue)?>'); return false">Label Obat</a>
                	<!--<button class="dropdown-toggle btn btn-primary ew-detail" data-toggle="dropdown" aria-expanded="false"></button>
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
                	</ul>-->
                </div>
                </span>
            </div>
        </div>
    </div>
<?php } ?>
</div><!-- /page -->
<?php if (!$Page->IsModal) { ?>
    <div class="form-group row"><!-- buttons .form-group -->
        <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("UpdateBtn") ?></button>
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
    ew.addEventHandlers("PASIEN_VISITATION");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
