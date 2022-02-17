<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

// Page object
$RegisterRanapSummary = &$Page;
?>
<?php if (!$Page->isExport() && !$Page->DrillDown && !$DashboardReport) { ?>
<script>
var currentForm, currentPageID;
var fsummary, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    fsummary = currentForm = new ew.Form("fsummary", "summary");
    currentPageID = ew.PAGE_ID = "summary";

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "register_ranap")) ?>,
        fields = currentTable.fields;
    fsummary.addFields([
        ["NO_REGISTRATION", [], fields.NO_REGISTRATION.isInvalid],
        ["GENDER", [], fields.GENDER.isInvalid],
        ["CLASS_ROOM_ID", [], fields.CLASS_ROOM_ID.isInvalid],
        ["BED_ID", [], fields.BED_ID.isInvalid],
        ["SERVED_INAP", [ew.Validators.datetime(7)], fields.SERVED_INAP.isInvalid],
        ["STATUS_PASIEN_ID", [], fields.STATUS_PASIEN_ID.isInvalid],
        ["ISRJ", [], fields.ISRJ.isInvalid],
        ["VISIT_ID", [], fields.VISIT_ID.isInvalid],
        ["IDXDAFTAR", [], fields.IDXDAFTAR.isInvalid],
        ["DIANTAR_OLEH", [], fields.DIANTAR_OLEH.isInvalid],
        ["EXIT_DATE", [], fields.EXIT_DATE.isInvalid],
        ["KELUAR_ID", [], fields.KELUAR_ID.isInvalid],
        ["AGEYEAR", [], fields.AGEYEAR.isInvalid],
        ["ORG_UNIT_CODE", [], fields.ORG_UNIT_CODE.isInvalid],
        ["RUJUKAN_ID", [], fields.RUJUKAN_ID.isInvalid],
        ["ADDRESS_OF_RUJUKAN", [], fields.ADDRESS_OF_RUJUKAN.isInvalid],
        ["REASON_ID", [], fields.REASON_ID.isInvalid],
        ["WAY_ID", [], fields.WAY_ID.isInvalid],
        ["PATIENT_CATEGORY_ID", [], fields.PATIENT_CATEGORY_ID.isInvalid],
        ["BOOKED_DATE", [], fields.BOOKED_DATE.isInvalid],
        ["VISIT_DATE", [], fields.VISIT_DATE.isInvalid],
        ["ISNEW", [], fields.ISNEW.isInvalid],
        ["FOLLOW_UP", [], fields.FOLLOW_UP.isInvalid],
        ["PLACE_TYPE", [], fields.PLACE_TYPE.isInvalid],
        ["CLINIC_ID", [], fields.CLINIC_ID.isInvalid],
        ["CLINIC_ID_FROM", [], fields.CLINIC_ID_FROM.isInvalid],
        ["IN_DATE", [], fields.IN_DATE.isInvalid],
        ["DESCRIPTION", [], fields.DESCRIPTION.isInvalid],
        ["VISITOR_ADDRESS", [], fields.VISITOR_ADDRESS.isInvalid],
        ["MODIFIED_BY", [], fields.MODIFIED_BY.isInvalid],
        ["MODIFIED_DATE", [], fields.MODIFIED_DATE.isInvalid],
        ["MODIFIED_FROM", [], fields.MODIFIED_FROM.isInvalid],
        ["EMPLOYEE_ID", [], fields.EMPLOYEE_ID.isInvalid],
        ["EMPLOYEE_ID_FROM", [], fields.EMPLOYEE_ID_FROM.isInvalid],
        ["RESPONSIBLE_ID", [], fields.RESPONSIBLE_ID.isInvalid],
        ["RESPONSIBLE", [], fields.RESPONSIBLE.isInvalid],
        ["FAMILY_STATUS_ID", [], fields.FAMILY_STATUS_ID.isInvalid],
        ["TICKET_NO", [], fields.TICKET_NO.isInvalid],
        ["ISATTENDED", [], fields.ISATTENDED.isInvalid],
        ["PAYOR_ID", [], fields.PAYOR_ID.isInvalid],
        ["CLASS_ID", [], fields.CLASS_ID.isInvalid],
        ["ISPERTARIF", [], fields.ISPERTARIF.isInvalid],
        ["KAL_ID", [], fields.KAL_ID.isInvalid],
        ["EMPLOYEE_INAP", [], fields.EMPLOYEE_INAP.isInvalid],
        ["PASIEN_ID", [], fields.PASIEN_ID.isInvalid],
        ["KARYAWAN", [], fields.KARYAWAN.isInvalid],
        ["ACCOUNT_ID", [], fields.ACCOUNT_ID.isInvalid],
        ["CLASS_ID_PLAFOND", [], fields.CLASS_ID_PLAFOND.isInvalid],
        ["BACKCHARGE", [], fields.BACKCHARGE.isInvalid],
        ["COVERAGE_ID", [], fields.COVERAGE_ID.isInvalid],
        ["AGEMONTH", [], fields.AGEMONTH.isInvalid],
        ["AGEDAY", [], fields.AGEDAY.isInvalid],
        ["RECOMENDATION", [], fields.RECOMENDATION.isInvalid],
        ["CONCLUSION", [], fields.CONCLUSION.isInvalid],
        ["SPECIMENNO", [], fields.SPECIMENNO.isInvalid],
        ["LOCKED", [], fields.LOCKED.isInvalid],
        ["RM_OUT_DATE", [], fields.RM_OUT_DATE.isInvalid],
        ["RM_IN_DATE", [], fields.RM_IN_DATE.isInvalid],
        ["LAMA_PINJAM", [], fields.LAMA_PINJAM.isInvalid],
        ["STANDAR_RJ", [], fields.STANDAR_RJ.isInvalid],
        ["LENGKAP_RJ", [], fields.LENGKAP_RJ.isInvalid],
        ["LENGKAP_RI", [], fields.LENGKAP_RI.isInvalid],
        ["RESEND_RM_DATE", [], fields.RESEND_RM_DATE.isInvalid],
        ["LENGKAP_RM1", [], fields.LENGKAP_RM1.isInvalid],
        ["LENGKAP_RESUME", [], fields.LENGKAP_RESUME.isInvalid],
        ["LENGKAP_ANAMNESIS", [], fields.LENGKAP_ANAMNESIS.isInvalid],
        ["LENGKAP_CONSENT", [], fields.LENGKAP_CONSENT.isInvalid],
        ["LENGKAP_ANESTESI", [], fields.LENGKAP_ANESTESI.isInvalid],
        ["LENGKAP_OP", [], fields.LENGKAP_OP.isInvalid],
        ["BACK_RM_DATE", [], fields.BACK_RM_DATE.isInvalid],
        ["VALID_RM_DATE", [], fields.VALID_RM_DATE.isInvalid],
        ["NO_SKP", [], fields.NO_SKP.isInvalid],
        ["NO_SKPINAP", [], fields.NO_SKPINAP.isInvalid],
        ["DIAGNOSA_ID", [], fields.DIAGNOSA_ID.isInvalid],
        ["ticket_all", [], fields.ticket_all.isInvalid],
        ["tanggal_rujukan", [], fields.tanggal_rujukan.isInvalid],
        ["NORUJUKAN", [], fields.NORUJUKAN.isInvalid],
        ["PPKRUJUKAN", [], fields.PPKRUJUKAN.isInvalid],
        ["LOKASILAKA", [], fields.LOKASILAKA.isInvalid],
        ["KDPOLI", [], fields.KDPOLI.isInvalid],
        ["EDIT_SEP", [], fields.EDIT_SEP.isInvalid],
        ["DELETE_SEP", [], fields.DELETE_SEP.isInvalid],
        ["KODE_AGAMA", [], fields.KODE_AGAMA.isInvalid],
        ["DIAG_AWAL", [], fields.DIAG_AWAL.isInvalid],
        ["AKTIF", [], fields.AKTIF.isInvalid],
        ["BILL_INAP", [], fields.BILL_INAP.isInvalid],
        ["SEP_PRINTDATE", [], fields.SEP_PRINTDATE.isInvalid],
        ["MAPPING_SEP", [], fields.MAPPING_SEP.isInvalid],
        ["TRANS_ID", [], fields.TRANS_ID.isInvalid],
        ["KDPOLI_EKS", [], fields.KDPOLI_EKS.isInvalid],
        ["COB", [], fields.COB.isInvalid],
        ["PENJAMIN", [], fields.PENJAMIN.isInvalid],
        ["ASALRUJUKAN", [], fields.ASALRUJUKAN.isInvalid],
        ["RESPONSEP", [], fields.RESPONSEP.isInvalid],
        ["APPROVAL_DESC", [], fields.APPROVAL_DESC.isInvalid],
        ["APPROVAL_RESPONAJUKAN", [], fields.APPROVAL_RESPONAJUKAN.isInvalid],
        ["APPROVAL_RESPONAPPROV", [], fields.APPROVAL_RESPONAPPROV.isInvalid],
        ["RESPONTGLPLG_DESC", [], fields.RESPONTGLPLG_DESC.isInvalid],
        ["RESPONPOST_VKLAIM", [], fields.RESPONPOST_VKLAIM.isInvalid],
        ["RESPONPUT_VKLAIM", [], fields.RESPONPUT_VKLAIM.isInvalid],
        ["RESPONDEL_VKLAIM", [], fields.RESPONDEL_VKLAIM.isInvalid],
        ["CALL_TIMES", [], fields.CALL_TIMES.isInvalid],
        ["CALL_DATE", [], fields.CALL_DATE.isInvalid],
        ["CALL_DATES", [], fields.CALL_DATES.isInvalid],
        ["SERVED_DATE", [], fields.SERVED_DATE.isInvalid],
        ["KDDPJP1", [], fields.KDDPJP1.isInvalid],
        ["KDDPJP", [], fields.KDDPJP.isInvalid],
        ["tgl_kontrol", [], fields.tgl_kontrol.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        fsummary.setInvalid();
    });

    // Validate form
    fsummary.validate = function () {
        if (!this.validateRequired)
            return true; // Ignore validation
        var fobj = this.getForm(),
            $fobj = $(fobj),
            rowIndex = "";
        $fobj.data("rowindex", rowIndex);

        // Validate fields
        if (!this.validateFields(rowIndex))
            return false;

        // Call Form_CustomValidate event
        if (!this.customValidate(fobj)) {
            this.focus();
            return false;
        }
        return true;
    }

    // Form_CustomValidate
    fsummary.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fsummary.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fsummary.lists.CLASS_ROOM_ID = <?= $Page->CLASS_ROOM_ID->toClientList($Page) ?>;

    // Filters
    fsummary.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fsummary");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<a id="top"></a>
<?php if ((!$Page->isExport() || $Page->isExport("print")) && !$DashboardReport) { ?>
<!-- Content Container -->
<div id="ew-report" class="ew-report container-fluid">
<?php } ?>
<?php if ($Page->ShowCurrentFilter) { ?>
<?php $Page->showFilterList() ?>
<?php } ?>
<div class="btn-toolbar ew-toolbar">
<?php
if (!$Page->DrillDownInPanel) {
    $Page->ExportOptions->render("body");
    $Page->SearchOptions->render("body");
    $Page->FilterOptions->render("body");
}
?>
</div>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<?php if ((!$Page->isExport() || $Page->isExport("print")) && !$DashboardReport) { ?>
<div class="row">
<?php } ?>
<?php if ((!$Page->isExport() || $Page->isExport("print")) && !$DashboardReport) { ?>
<!-- Center Container -->
<div id="ew-center" class="<?= $Page->CenterContentClass ?>">
<?php } ?>
<!-- Summary report (begin) -->
<div id="report_summary">
<?php if (!$Page->isExport() && !$Page->DrillDown && !$DashboardReport) { ?>
<?php if ($Security->canSearch()) { ?>
<?php if (!$Page->isExport() && !$Page->CurrentAction) { ?>
<form name="fsummary" id="fsummary" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fsummary-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="register_ranap">
    <div class="ew-extended-search">
<?php
// Render search row
$Page->RowType = ROWTYPE_SEARCH;
$Page->resetAttributes();
$Page->renderRow();
?>
<?php if ($Page->CLASS_ROOM_ID->Visible) { // CLASS_ROOM_ID ?>
    <?php
        $Page->SearchColumnCount++;
        if (($Page->SearchColumnCount - 1) % $Page->SearchFieldsPerRow == 0) {
            $Page->SearchRowCount++;
    ?>
<div id="xsr_<?= $Page->SearchRowCount ?>" class="ew-row d-sm-flex">
    <?php
        }
     ?>
    <div id="xsc_CLASS_ROOM_ID" class="ew-cell form-group">
        <label for="x_CLASS_ROOM_ID" class="ew-search-caption ew-label"><?= $Page->CLASS_ROOM_ID->caption() ?></label>
        <span id="el_register_ranap_CLASS_ROOM_ID" class="ew-search-field">
    <select
        id="x_CLASS_ROOM_ID"
        name="x_CLASS_ROOM_ID"
        class="form-control ew-select<?= $Page->CLASS_ROOM_ID->isInvalidClass() ?>"
        data-select2-id="register_ranap_x_CLASS_ROOM_ID"
        data-table="register_ranap"
        data-field="x_CLASS_ROOM_ID"
        data-value-separator="<?= $Page->CLASS_ROOM_ID->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->CLASS_ROOM_ID->getPlaceHolder()) ?>"
        <?= $Page->CLASS_ROOM_ID->editAttributes() ?>>
        <?= $Page->CLASS_ROOM_ID->selectOptionListHtml("x_CLASS_ROOM_ID") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->CLASS_ROOM_ID->getErrorMessage() ?></div>
<?= $Page->CLASS_ROOM_ID->Lookup->getParamTag($Page, "p_x_CLASS_ROOM_ID") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='register_ranap_x_CLASS_ROOM_ID']"),
        options = { name: "x_CLASS_ROOM_ID", selectId: "register_ranap_x_CLASS_ROOM_ID", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.register_ranap.fields.CLASS_ROOM_ID.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
    </div>
    <?php if ($Page->SearchColumnCount % $Page->SearchFieldsPerRow == 0) { ?>
</div>
    <?php } ?>
<?php } ?>
<?php if ($Page->SERVED_INAP->Visible) { // SERVED_INAP ?>
    <?php
        $Page->SearchColumnCount++;
        if (($Page->SearchColumnCount - 1) % $Page->SearchFieldsPerRow == 0) {
            $Page->SearchRowCount++;
    ?>
<div id="xsr_<?= $Page->SearchRowCount ?>" class="ew-row d-sm-flex">
    <?php
        }
     ?>
    <div id="xsc_SERVED_INAP" class="ew-cell form-group">
        <label for="x_SERVED_INAP" class="ew-search-caption ew-label"><?= $Page->SERVED_INAP->caption() ?></label>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_SERVED_INAP" id="z_SERVED_INAP" value="=">
</span>
        <span id="el_register_ranap_SERVED_INAP" class="ew-search-field">
<input type="<?= $Page->SERVED_INAP->getInputTextType() ?>" data-table="register_ranap" data-field="x_SERVED_INAP" data-format="7" name="x_SERVED_INAP" id="x_SERVED_INAP" placeholder="<?= HtmlEncode($Page->SERVED_INAP->getPlaceHolder()) ?>" value="<?= $Page->SERVED_INAP->EditValue ?>"<?= $Page->SERVED_INAP->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->SERVED_INAP->getErrorMessage() ?></div>
<?php if (!$Page->SERVED_INAP->ReadOnly && !$Page->SERVED_INAP->Disabled && !isset($Page->SERVED_INAP->EditAttrs["readonly"]) && !isset($Page->SERVED_INAP->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fsummary", "datetimepicker"], function() {
    ew.createDateTimePicker("fsummary", "x_SERVED_INAP", {"ignoreReadonly":true,"useCurrent":false,"format":7});
});
</script>
<?php } ?>
</span>
    </div>
    <?php if ($Page->SearchColumnCount % $Page->SearchFieldsPerRow == 0) { ?>
</div>
    <?php } ?>
<?php } ?>
    <?php if ($Page->SearchColumnCount % $Page->SearchFieldsPerRow > 0) { ?>
</div>
    <?php } ?>
<div id="xsr_<?= $Page->SearchRowCount + 1 ?>" class="ew-row d-sm-flex">
    <button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?= $Language->phrase("SearchBtn") ?></button>
</div>
    </div><!-- /.ew-extended-search -->
</div><!-- /.ew-search-panel -->
</form>
<?php } ?>
<?php } ?>
<?php } ?>
<?php
while ($Page->RecordCount < count($Page->DetailRecords) && $Page->RecordCount < $Page->DisplayGroups) {
?>
<?php
    // Show header
    if ($Page->ShowHeader) {
?>
<div class="<?php if (!$Page->isExport("word") && !$Page->isExport("excel")) { ?>card ew-card <?php } ?>ew-grid"<?= $Page->ReportTableStyle ?>>
<?php if (!$Page->isExport() && !($Page->DrillDown && $Page->TotalGroups > 0)) { ?>
<!-- Top pager -->
<div class="card-header ew-grid-upper-panel">
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?= CurrentPageUrl(false) ?>">
<?= $Page->Pager->render() ?>
</form>
<div class="clearfix"></div>
</div>
<?php } ?>
<!-- Report grid (begin) -->
<div id="gmp_register_ranap" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table class="<?= $Page->ReportTableClass ?>">
<thead>
	<!-- Table header -->
    <tr class="ew-table-header">
<?php if ($Page->NO_REGISTRATION->Visible) { ?>
    <th data-name="NO_REGISTRATION" class="<?= $Page->NO_REGISTRATION->headerCellClass() ?>" style="white-space: nowrap;"><div class="register_ranap_NO_REGISTRATION"><?= $Page->renderSort($Page->NO_REGISTRATION) ?></div></th>
<?php } ?>
<?php if ($Page->GENDER->Visible) { ?>
    <th data-name="GENDER" class="<?= $Page->GENDER->headerCellClass() ?>" style="white-space: nowrap;"><div class="register_ranap_GENDER"><?= $Page->renderSort($Page->GENDER) ?></div></th>
<?php } ?>
<?php if ($Page->CLASS_ROOM_ID->Visible) { ?>
    <th data-name="CLASS_ROOM_ID" class="<?= $Page->CLASS_ROOM_ID->headerCellClass() ?>" style="white-space: nowrap;"><div class="register_ranap_CLASS_ROOM_ID"><?= $Page->renderSort($Page->CLASS_ROOM_ID) ?></div></th>
<?php } ?>
<?php if ($Page->BED_ID->Visible) { ?>
    <th data-name="BED_ID" class="<?= $Page->BED_ID->headerCellClass() ?>"><div class="register_ranap_BED_ID"><?= $Page->renderSort($Page->BED_ID) ?></div></th>
<?php } ?>
<?php if ($Page->SERVED_INAP->Visible) { ?>
    <th data-name="SERVED_INAP" class="<?= $Page->SERVED_INAP->headerCellClass() ?>"><div class="register_ranap_SERVED_INAP"><?= $Page->renderSort($Page->SERVED_INAP) ?></div></th>
<?php } ?>
<?php if ($Page->STATUS_PASIEN_ID->Visible) { ?>
    <th data-name="STATUS_PASIEN_ID" class="<?= $Page->STATUS_PASIEN_ID->headerCellClass() ?>"><div class="register_ranap_STATUS_PASIEN_ID"><?= $Page->renderSort($Page->STATUS_PASIEN_ID) ?></div></th>
<?php } ?>
<?php if ($Page->ISRJ->Visible) { ?>
    <th data-name="ISRJ" class="<?= $Page->ISRJ->headerCellClass() ?>" style="white-space: nowrap;"><div class="register_ranap_ISRJ"><?= $Page->renderSort($Page->ISRJ) ?></div></th>
<?php } ?>
<?php if ($Page->VISIT_ID->Visible) { ?>
    <th data-name="VISIT_ID" class="<?= $Page->VISIT_ID->headerCellClass() ?>" style="white-space: nowrap;"><div class="register_ranap_VISIT_ID"><?= $Page->renderSort($Page->VISIT_ID) ?></div></th>
<?php } ?>
<?php if ($Page->IDXDAFTAR->Visible) { ?>
    <th data-name="IDXDAFTAR" class="<?= $Page->IDXDAFTAR->headerCellClass() ?>" style="white-space: nowrap;"><div class="register_ranap_IDXDAFTAR"><?= $Page->renderSort($Page->IDXDAFTAR) ?></div></th>
<?php } ?>
<?php if ($Page->DIANTAR_OLEH->Visible) { ?>
    <th data-name="DIANTAR_OLEH" class="<?= $Page->DIANTAR_OLEH->headerCellClass() ?>" style="white-space: nowrap;"><div class="register_ranap_DIANTAR_OLEH"><?= $Page->renderSort($Page->DIANTAR_OLEH) ?></div></th>
<?php } ?>
<?php if ($Page->EXIT_DATE->Visible) { ?>
    <th data-name="EXIT_DATE" class="<?= $Page->EXIT_DATE->headerCellClass() ?>"><div class="register_ranap_EXIT_DATE"><?= $Page->renderSort($Page->EXIT_DATE) ?></div></th>
<?php } ?>
<?php if ($Page->KELUAR_ID->Visible) { ?>
    <th data-name="KELUAR_ID" class="<?= $Page->KELUAR_ID->headerCellClass() ?>"><div class="register_ranap_KELUAR_ID"><?= $Page->renderSort($Page->KELUAR_ID) ?></div></th>
<?php } ?>
<?php if ($Page->AGEYEAR->Visible) { ?>
    <th data-name="AGEYEAR" class="<?= $Page->AGEYEAR->headerCellClass() ?>"><div class="register_ranap_AGEYEAR"><?= $Page->renderSort($Page->AGEYEAR) ?></div></th>
<?php } ?>
<?php if ($Page->ORG_UNIT_CODE->Visible) { ?>
    <th data-name="ORG_UNIT_CODE" class="<?= $Page->ORG_UNIT_CODE->headerCellClass() ?>"><div class="register_ranap_ORG_UNIT_CODE"><?= $Page->renderSort($Page->ORG_UNIT_CODE) ?></div></th>
<?php } ?>
<?php if ($Page->RUJUKAN_ID->Visible) { ?>
    <th data-name="RUJUKAN_ID" class="<?= $Page->RUJUKAN_ID->headerCellClass() ?>"><div class="register_ranap_RUJUKAN_ID"><?= $Page->renderSort($Page->RUJUKAN_ID) ?></div></th>
<?php } ?>
<?php if ($Page->ADDRESS_OF_RUJUKAN->Visible) { ?>
    <th data-name="ADDRESS_OF_RUJUKAN" class="<?= $Page->ADDRESS_OF_RUJUKAN->headerCellClass() ?>"><div class="register_ranap_ADDRESS_OF_RUJUKAN"><?= $Page->renderSort($Page->ADDRESS_OF_RUJUKAN) ?></div></th>
<?php } ?>
<?php if ($Page->REASON_ID->Visible) { ?>
    <th data-name="REASON_ID" class="<?= $Page->REASON_ID->headerCellClass() ?>"><div class="register_ranap_REASON_ID"><?= $Page->renderSort($Page->REASON_ID) ?></div></th>
<?php } ?>
<?php if ($Page->WAY_ID->Visible) { ?>
    <th data-name="WAY_ID" class="<?= $Page->WAY_ID->headerCellClass() ?>"><div class="register_ranap_WAY_ID"><?= $Page->renderSort($Page->WAY_ID) ?></div></th>
<?php } ?>
<?php if ($Page->PATIENT_CATEGORY_ID->Visible) { ?>
    <th data-name="PATIENT_CATEGORY_ID" class="<?= $Page->PATIENT_CATEGORY_ID->headerCellClass() ?>"><div class="register_ranap_PATIENT_CATEGORY_ID"><?= $Page->renderSort($Page->PATIENT_CATEGORY_ID) ?></div></th>
<?php } ?>
<?php if ($Page->BOOKED_DATE->Visible) { ?>
    <th data-name="BOOKED_DATE" class="<?= $Page->BOOKED_DATE->headerCellClass() ?>"><div class="register_ranap_BOOKED_DATE"><?= $Page->renderSort($Page->BOOKED_DATE) ?></div></th>
<?php } ?>
<?php if ($Page->VISIT_DATE->Visible) { ?>
    <th data-name="VISIT_DATE" class="<?= $Page->VISIT_DATE->headerCellClass() ?>"><div class="register_ranap_VISIT_DATE"><?= $Page->renderSort($Page->VISIT_DATE) ?></div></th>
<?php } ?>
<?php if ($Page->ISNEW->Visible) { ?>
    <th data-name="ISNEW" class="<?= $Page->ISNEW->headerCellClass() ?>"><div class="register_ranap_ISNEW"><?= $Page->renderSort($Page->ISNEW) ?></div></th>
<?php } ?>
<?php if ($Page->FOLLOW_UP->Visible) { ?>
    <th data-name="FOLLOW_UP" class="<?= $Page->FOLLOW_UP->headerCellClass() ?>"><div class="register_ranap_FOLLOW_UP"><?= $Page->renderSort($Page->FOLLOW_UP) ?></div></th>
<?php } ?>
<?php if ($Page->PLACE_TYPE->Visible) { ?>
    <th data-name="PLACE_TYPE" class="<?= $Page->PLACE_TYPE->headerCellClass() ?>"><div class="register_ranap_PLACE_TYPE"><?= $Page->renderSort($Page->PLACE_TYPE) ?></div></th>
<?php } ?>
<?php if ($Page->CLINIC_ID->Visible) { ?>
    <th data-name="CLINIC_ID" class="<?= $Page->CLINIC_ID->headerCellClass() ?>"><div class="register_ranap_CLINIC_ID"><?= $Page->renderSort($Page->CLINIC_ID) ?></div></th>
<?php } ?>
<?php if ($Page->CLINIC_ID_FROM->Visible) { ?>
    <th data-name="CLINIC_ID_FROM" class="<?= $Page->CLINIC_ID_FROM->headerCellClass() ?>"><div class="register_ranap_CLINIC_ID_FROM"><?= $Page->renderSort($Page->CLINIC_ID_FROM) ?></div></th>
<?php } ?>
<?php if ($Page->IN_DATE->Visible) { ?>
    <th data-name="IN_DATE" class="<?= $Page->IN_DATE->headerCellClass() ?>"><div class="register_ranap_IN_DATE"><?= $Page->renderSort($Page->IN_DATE) ?></div></th>
<?php } ?>
<?php if ($Page->DESCRIPTION->Visible) { ?>
    <th data-name="DESCRIPTION" class="<?= $Page->DESCRIPTION->headerCellClass() ?>"><div class="register_ranap_DESCRIPTION"><?= $Page->renderSort($Page->DESCRIPTION) ?></div></th>
<?php } ?>
<?php if ($Page->VISITOR_ADDRESS->Visible) { ?>
    <th data-name="VISITOR_ADDRESS" class="<?= $Page->VISITOR_ADDRESS->headerCellClass() ?>"><div class="register_ranap_VISITOR_ADDRESS"><?= $Page->renderSort($Page->VISITOR_ADDRESS) ?></div></th>
<?php } ?>
<?php if ($Page->MODIFIED_BY->Visible) { ?>
    <th data-name="MODIFIED_BY" class="<?= $Page->MODIFIED_BY->headerCellClass() ?>"><div class="register_ranap_MODIFIED_BY"><?= $Page->renderSort($Page->MODIFIED_BY) ?></div></th>
<?php } ?>
<?php if ($Page->MODIFIED_DATE->Visible) { ?>
    <th data-name="MODIFIED_DATE" class="<?= $Page->MODIFIED_DATE->headerCellClass() ?>"><div class="register_ranap_MODIFIED_DATE"><?= $Page->renderSort($Page->MODIFIED_DATE) ?></div></th>
<?php } ?>
<?php if ($Page->MODIFIED_FROM->Visible) { ?>
    <th data-name="MODIFIED_FROM" class="<?= $Page->MODIFIED_FROM->headerCellClass() ?>"><div class="register_ranap_MODIFIED_FROM"><?= $Page->renderSort($Page->MODIFIED_FROM) ?></div></th>
<?php } ?>
<?php if ($Page->EMPLOYEE_ID->Visible) { ?>
    <th data-name="EMPLOYEE_ID" class="<?= $Page->EMPLOYEE_ID->headerCellClass() ?>"><div class="register_ranap_EMPLOYEE_ID"><?= $Page->renderSort($Page->EMPLOYEE_ID) ?></div></th>
<?php } ?>
<?php if ($Page->EMPLOYEE_ID_FROM->Visible) { ?>
    <th data-name="EMPLOYEE_ID_FROM" class="<?= $Page->EMPLOYEE_ID_FROM->headerCellClass() ?>"><div class="register_ranap_EMPLOYEE_ID_FROM"><?= $Page->renderSort($Page->EMPLOYEE_ID_FROM) ?></div></th>
<?php } ?>
<?php if ($Page->RESPONSIBLE_ID->Visible) { ?>
    <th data-name="RESPONSIBLE_ID" class="<?= $Page->RESPONSIBLE_ID->headerCellClass() ?>"><div class="register_ranap_RESPONSIBLE_ID"><?= $Page->renderSort($Page->RESPONSIBLE_ID) ?></div></th>
<?php } ?>
<?php if ($Page->RESPONSIBLE->Visible) { ?>
    <th data-name="RESPONSIBLE" class="<?= $Page->RESPONSIBLE->headerCellClass() ?>"><div class="register_ranap_RESPONSIBLE"><?= $Page->renderSort($Page->RESPONSIBLE) ?></div></th>
<?php } ?>
<?php if ($Page->FAMILY_STATUS_ID->Visible) { ?>
    <th data-name="FAMILY_STATUS_ID" class="<?= $Page->FAMILY_STATUS_ID->headerCellClass() ?>"><div class="register_ranap_FAMILY_STATUS_ID"><?= $Page->renderSort($Page->FAMILY_STATUS_ID) ?></div></th>
<?php } ?>
<?php if ($Page->TICKET_NO->Visible) { ?>
    <th data-name="TICKET_NO" class="<?= $Page->TICKET_NO->headerCellClass() ?>"><div class="register_ranap_TICKET_NO"><?= $Page->renderSort($Page->TICKET_NO) ?></div></th>
<?php } ?>
<?php if ($Page->ISATTENDED->Visible) { ?>
    <th data-name="ISATTENDED" class="<?= $Page->ISATTENDED->headerCellClass() ?>"><div class="register_ranap_ISATTENDED"><?= $Page->renderSort($Page->ISATTENDED) ?></div></th>
<?php } ?>
<?php if ($Page->PAYOR_ID->Visible) { ?>
    <th data-name="PAYOR_ID" class="<?= $Page->PAYOR_ID->headerCellClass() ?>"><div class="register_ranap_PAYOR_ID"><?= $Page->renderSort($Page->PAYOR_ID) ?></div></th>
<?php } ?>
<?php if ($Page->CLASS_ID->Visible) { ?>
    <th data-name="CLASS_ID" class="<?= $Page->CLASS_ID->headerCellClass() ?>"><div class="register_ranap_CLASS_ID"><?= $Page->renderSort($Page->CLASS_ID) ?></div></th>
<?php } ?>
<?php if ($Page->ISPERTARIF->Visible) { ?>
    <th data-name="ISPERTARIF" class="<?= $Page->ISPERTARIF->headerCellClass() ?>"><div class="register_ranap_ISPERTARIF"><?= $Page->renderSort($Page->ISPERTARIF) ?></div></th>
<?php } ?>
<?php if ($Page->KAL_ID->Visible) { ?>
    <th data-name="KAL_ID" class="<?= $Page->KAL_ID->headerCellClass() ?>"><div class="register_ranap_KAL_ID"><?= $Page->renderSort($Page->KAL_ID) ?></div></th>
<?php } ?>
<?php if ($Page->EMPLOYEE_INAP->Visible) { ?>
    <th data-name="EMPLOYEE_INAP" class="<?= $Page->EMPLOYEE_INAP->headerCellClass() ?>"><div class="register_ranap_EMPLOYEE_INAP"><?= $Page->renderSort($Page->EMPLOYEE_INAP) ?></div></th>
<?php } ?>
<?php if ($Page->PASIEN_ID->Visible) { ?>
    <th data-name="PASIEN_ID" class="<?= $Page->PASIEN_ID->headerCellClass() ?>"><div class="register_ranap_PASIEN_ID"><?= $Page->renderSort($Page->PASIEN_ID) ?></div></th>
<?php } ?>
<?php if ($Page->KARYAWAN->Visible) { ?>
    <th data-name="KARYAWAN" class="<?= $Page->KARYAWAN->headerCellClass() ?>"><div class="register_ranap_KARYAWAN"><?= $Page->renderSort($Page->KARYAWAN) ?></div></th>
<?php } ?>
<?php if ($Page->ACCOUNT_ID->Visible) { ?>
    <th data-name="ACCOUNT_ID" class="<?= $Page->ACCOUNT_ID->headerCellClass() ?>"><div class="register_ranap_ACCOUNT_ID"><?= $Page->renderSort($Page->ACCOUNT_ID) ?></div></th>
<?php } ?>
<?php if ($Page->CLASS_ID_PLAFOND->Visible) { ?>
    <th data-name="CLASS_ID_PLAFOND" class="<?= $Page->CLASS_ID_PLAFOND->headerCellClass() ?>"><div class="register_ranap_CLASS_ID_PLAFOND"><?= $Page->renderSort($Page->CLASS_ID_PLAFOND) ?></div></th>
<?php } ?>
<?php if ($Page->BACKCHARGE->Visible) { ?>
    <th data-name="BACKCHARGE" class="<?= $Page->BACKCHARGE->headerCellClass() ?>"><div class="register_ranap_BACKCHARGE"><?= $Page->renderSort($Page->BACKCHARGE) ?></div></th>
<?php } ?>
<?php if ($Page->COVERAGE_ID->Visible) { ?>
    <th data-name="COVERAGE_ID" class="<?= $Page->COVERAGE_ID->headerCellClass() ?>"><div class="register_ranap_COVERAGE_ID"><?= $Page->renderSort($Page->COVERAGE_ID) ?></div></th>
<?php } ?>
<?php if ($Page->AGEMONTH->Visible) { ?>
    <th data-name="AGEMONTH" class="<?= $Page->AGEMONTH->headerCellClass() ?>"><div class="register_ranap_AGEMONTH"><?= $Page->renderSort($Page->AGEMONTH) ?></div></th>
<?php } ?>
<?php if ($Page->AGEDAY->Visible) { ?>
    <th data-name="AGEDAY" class="<?= $Page->AGEDAY->headerCellClass() ?>"><div class="register_ranap_AGEDAY"><?= $Page->renderSort($Page->AGEDAY) ?></div></th>
<?php } ?>
<?php if ($Page->RECOMENDATION->Visible) { ?>
    <th data-name="RECOMENDATION" class="<?= $Page->RECOMENDATION->headerCellClass() ?>"><div class="register_ranap_RECOMENDATION"><?= $Page->renderSort($Page->RECOMENDATION) ?></div></th>
<?php } ?>
<?php if ($Page->CONCLUSION->Visible) { ?>
    <th data-name="CONCLUSION" class="<?= $Page->CONCLUSION->headerCellClass() ?>"><div class="register_ranap_CONCLUSION"><?= $Page->renderSort($Page->CONCLUSION) ?></div></th>
<?php } ?>
<?php if ($Page->SPECIMENNO->Visible) { ?>
    <th data-name="SPECIMENNO" class="<?= $Page->SPECIMENNO->headerCellClass() ?>"><div class="register_ranap_SPECIMENNO"><?= $Page->renderSort($Page->SPECIMENNO) ?></div></th>
<?php } ?>
<?php if ($Page->LOCKED->Visible) { ?>
    <th data-name="LOCKED" class="<?= $Page->LOCKED->headerCellClass() ?>"><div class="register_ranap_LOCKED"><?= $Page->renderSort($Page->LOCKED) ?></div></th>
<?php } ?>
<?php if ($Page->RM_OUT_DATE->Visible) { ?>
    <th data-name="RM_OUT_DATE" class="<?= $Page->RM_OUT_DATE->headerCellClass() ?>"><div class="register_ranap_RM_OUT_DATE"><?= $Page->renderSort($Page->RM_OUT_DATE) ?></div></th>
<?php } ?>
<?php if ($Page->RM_IN_DATE->Visible) { ?>
    <th data-name="RM_IN_DATE" class="<?= $Page->RM_IN_DATE->headerCellClass() ?>"><div class="register_ranap_RM_IN_DATE"><?= $Page->renderSort($Page->RM_IN_DATE) ?></div></th>
<?php } ?>
<?php if ($Page->LAMA_PINJAM->Visible) { ?>
    <th data-name="LAMA_PINJAM" class="<?= $Page->LAMA_PINJAM->headerCellClass() ?>"><div class="register_ranap_LAMA_PINJAM"><?= $Page->renderSort($Page->LAMA_PINJAM) ?></div></th>
<?php } ?>
<?php if ($Page->STANDAR_RJ->Visible) { ?>
    <th data-name="STANDAR_RJ" class="<?= $Page->STANDAR_RJ->headerCellClass() ?>"><div class="register_ranap_STANDAR_RJ"><?= $Page->renderSort($Page->STANDAR_RJ) ?></div></th>
<?php } ?>
<?php if ($Page->LENGKAP_RJ->Visible) { ?>
    <th data-name="LENGKAP_RJ" class="<?= $Page->LENGKAP_RJ->headerCellClass() ?>"><div class="register_ranap_LENGKAP_RJ"><?= $Page->renderSort($Page->LENGKAP_RJ) ?></div></th>
<?php } ?>
<?php if ($Page->LENGKAP_RI->Visible) { ?>
    <th data-name="LENGKAP_RI" class="<?= $Page->LENGKAP_RI->headerCellClass() ?>"><div class="register_ranap_LENGKAP_RI"><?= $Page->renderSort($Page->LENGKAP_RI) ?></div></th>
<?php } ?>
<?php if ($Page->RESEND_RM_DATE->Visible) { ?>
    <th data-name="RESEND_RM_DATE" class="<?= $Page->RESEND_RM_DATE->headerCellClass() ?>"><div class="register_ranap_RESEND_RM_DATE"><?= $Page->renderSort($Page->RESEND_RM_DATE) ?></div></th>
<?php } ?>
<?php if ($Page->LENGKAP_RM1->Visible) { ?>
    <th data-name="LENGKAP_RM1" class="<?= $Page->LENGKAP_RM1->headerCellClass() ?>"><div class="register_ranap_LENGKAP_RM1"><?= $Page->renderSort($Page->LENGKAP_RM1) ?></div></th>
<?php } ?>
<?php if ($Page->LENGKAP_RESUME->Visible) { ?>
    <th data-name="LENGKAP_RESUME" class="<?= $Page->LENGKAP_RESUME->headerCellClass() ?>"><div class="register_ranap_LENGKAP_RESUME"><?= $Page->renderSort($Page->LENGKAP_RESUME) ?></div></th>
<?php } ?>
<?php if ($Page->LENGKAP_ANAMNESIS->Visible) { ?>
    <th data-name="LENGKAP_ANAMNESIS" class="<?= $Page->LENGKAP_ANAMNESIS->headerCellClass() ?>"><div class="register_ranap_LENGKAP_ANAMNESIS"><?= $Page->renderSort($Page->LENGKAP_ANAMNESIS) ?></div></th>
<?php } ?>
<?php if ($Page->LENGKAP_CONSENT->Visible) { ?>
    <th data-name="LENGKAP_CONSENT" class="<?= $Page->LENGKAP_CONSENT->headerCellClass() ?>"><div class="register_ranap_LENGKAP_CONSENT"><?= $Page->renderSort($Page->LENGKAP_CONSENT) ?></div></th>
<?php } ?>
<?php if ($Page->LENGKAP_ANESTESI->Visible) { ?>
    <th data-name="LENGKAP_ANESTESI" class="<?= $Page->LENGKAP_ANESTESI->headerCellClass() ?>"><div class="register_ranap_LENGKAP_ANESTESI"><?= $Page->renderSort($Page->LENGKAP_ANESTESI) ?></div></th>
<?php } ?>
<?php if ($Page->LENGKAP_OP->Visible) { ?>
    <th data-name="LENGKAP_OP" class="<?= $Page->LENGKAP_OP->headerCellClass() ?>"><div class="register_ranap_LENGKAP_OP"><?= $Page->renderSort($Page->LENGKAP_OP) ?></div></th>
<?php } ?>
<?php if ($Page->BACK_RM_DATE->Visible) { ?>
    <th data-name="BACK_RM_DATE" class="<?= $Page->BACK_RM_DATE->headerCellClass() ?>"><div class="register_ranap_BACK_RM_DATE"><?= $Page->renderSort($Page->BACK_RM_DATE) ?></div></th>
<?php } ?>
<?php if ($Page->VALID_RM_DATE->Visible) { ?>
    <th data-name="VALID_RM_DATE" class="<?= $Page->VALID_RM_DATE->headerCellClass() ?>"><div class="register_ranap_VALID_RM_DATE"><?= $Page->renderSort($Page->VALID_RM_DATE) ?></div></th>
<?php } ?>
<?php if ($Page->NO_SKP->Visible) { ?>
    <th data-name="NO_SKP" class="<?= $Page->NO_SKP->headerCellClass() ?>"><div class="register_ranap_NO_SKP"><?= $Page->renderSort($Page->NO_SKP) ?></div></th>
<?php } ?>
<?php if ($Page->NO_SKPINAP->Visible) { ?>
    <th data-name="NO_SKPINAP" class="<?= $Page->NO_SKPINAP->headerCellClass() ?>"><div class="register_ranap_NO_SKPINAP"><?= $Page->renderSort($Page->NO_SKPINAP) ?></div></th>
<?php } ?>
<?php if ($Page->DIAGNOSA_ID->Visible) { ?>
    <th data-name="DIAGNOSA_ID" class="<?= $Page->DIAGNOSA_ID->headerCellClass() ?>"><div class="register_ranap_DIAGNOSA_ID"><?= $Page->renderSort($Page->DIAGNOSA_ID) ?></div></th>
<?php } ?>
<?php if ($Page->ticket_all->Visible) { ?>
    <th data-name="ticket_all" class="<?= $Page->ticket_all->headerCellClass() ?>"><div class="register_ranap_ticket_all"><?= $Page->renderSort($Page->ticket_all) ?></div></th>
<?php } ?>
<?php if ($Page->tanggal_rujukan->Visible) { ?>
    <th data-name="tanggal_rujukan" class="<?= $Page->tanggal_rujukan->headerCellClass() ?>"><div class="register_ranap_tanggal_rujukan"><?= $Page->renderSort($Page->tanggal_rujukan) ?></div></th>
<?php } ?>
<?php if ($Page->NORUJUKAN->Visible) { ?>
    <th data-name="NORUJUKAN" class="<?= $Page->NORUJUKAN->headerCellClass() ?>"><div class="register_ranap_NORUJUKAN"><?= $Page->renderSort($Page->NORUJUKAN) ?></div></th>
<?php } ?>
<?php if ($Page->PPKRUJUKAN->Visible) { ?>
    <th data-name="PPKRUJUKAN" class="<?= $Page->PPKRUJUKAN->headerCellClass() ?>"><div class="register_ranap_PPKRUJUKAN"><?= $Page->renderSort($Page->PPKRUJUKAN) ?></div></th>
<?php } ?>
<?php if ($Page->LOKASILAKA->Visible) { ?>
    <th data-name="LOKASILAKA" class="<?= $Page->LOKASILAKA->headerCellClass() ?>"><div class="register_ranap_LOKASILAKA"><?= $Page->renderSort($Page->LOKASILAKA) ?></div></th>
<?php } ?>
<?php if ($Page->KDPOLI->Visible) { ?>
    <th data-name="KDPOLI" class="<?= $Page->KDPOLI->headerCellClass() ?>"><div class="register_ranap_KDPOLI"><?= $Page->renderSort($Page->KDPOLI) ?></div></th>
<?php } ?>
<?php if ($Page->EDIT_SEP->Visible) { ?>
    <th data-name="EDIT_SEP" class="<?= $Page->EDIT_SEP->headerCellClass() ?>"><div class="register_ranap_EDIT_SEP"><?= $Page->renderSort($Page->EDIT_SEP) ?></div></th>
<?php } ?>
<?php if ($Page->DELETE_SEP->Visible) { ?>
    <th data-name="DELETE_SEP" class="<?= $Page->DELETE_SEP->headerCellClass() ?>"><div class="register_ranap_DELETE_SEP"><?= $Page->renderSort($Page->DELETE_SEP) ?></div></th>
<?php } ?>
<?php if ($Page->KODE_AGAMA->Visible) { ?>
    <th data-name="KODE_AGAMA" class="<?= $Page->KODE_AGAMA->headerCellClass() ?>"><div class="register_ranap_KODE_AGAMA"><?= $Page->renderSort($Page->KODE_AGAMA) ?></div></th>
<?php } ?>
<?php if ($Page->DIAG_AWAL->Visible) { ?>
    <th data-name="DIAG_AWAL" class="<?= $Page->DIAG_AWAL->headerCellClass() ?>"><div class="register_ranap_DIAG_AWAL"><?= $Page->renderSort($Page->DIAG_AWAL) ?></div></th>
<?php } ?>
<?php if ($Page->AKTIF->Visible) { ?>
    <th data-name="AKTIF" class="<?= $Page->AKTIF->headerCellClass() ?>"><div class="register_ranap_AKTIF"><?= $Page->renderSort($Page->AKTIF) ?></div></th>
<?php } ?>
<?php if ($Page->BILL_INAP->Visible) { ?>
    <th data-name="BILL_INAP" class="<?= $Page->BILL_INAP->headerCellClass() ?>"><div class="register_ranap_BILL_INAP"><?= $Page->renderSort($Page->BILL_INAP) ?></div></th>
<?php } ?>
<?php if ($Page->SEP_PRINTDATE->Visible) { ?>
    <th data-name="SEP_PRINTDATE" class="<?= $Page->SEP_PRINTDATE->headerCellClass() ?>"><div class="register_ranap_SEP_PRINTDATE"><?= $Page->renderSort($Page->SEP_PRINTDATE) ?></div></th>
<?php } ?>
<?php if ($Page->MAPPING_SEP->Visible) { ?>
    <th data-name="MAPPING_SEP" class="<?= $Page->MAPPING_SEP->headerCellClass() ?>"><div class="register_ranap_MAPPING_SEP"><?= $Page->renderSort($Page->MAPPING_SEP) ?></div></th>
<?php } ?>
<?php if ($Page->TRANS_ID->Visible) { ?>
    <th data-name="TRANS_ID" class="<?= $Page->TRANS_ID->headerCellClass() ?>"><div class="register_ranap_TRANS_ID"><?= $Page->renderSort($Page->TRANS_ID) ?></div></th>
<?php } ?>
<?php if ($Page->KDPOLI_EKS->Visible) { ?>
    <th data-name="KDPOLI_EKS" class="<?= $Page->KDPOLI_EKS->headerCellClass() ?>"><div class="register_ranap_KDPOLI_EKS"><?= $Page->renderSort($Page->KDPOLI_EKS) ?></div></th>
<?php } ?>
<?php if ($Page->COB->Visible) { ?>
    <th data-name="COB" class="<?= $Page->COB->headerCellClass() ?>"><div class="register_ranap_COB"><?= $Page->renderSort($Page->COB) ?></div></th>
<?php } ?>
<?php if ($Page->PENJAMIN->Visible) { ?>
    <th data-name="PENJAMIN" class="<?= $Page->PENJAMIN->headerCellClass() ?>"><div class="register_ranap_PENJAMIN"><?= $Page->renderSort($Page->PENJAMIN) ?></div></th>
<?php } ?>
<?php if ($Page->ASALRUJUKAN->Visible) { ?>
    <th data-name="ASALRUJUKAN" class="<?= $Page->ASALRUJUKAN->headerCellClass() ?>"><div class="register_ranap_ASALRUJUKAN"><?= $Page->renderSort($Page->ASALRUJUKAN) ?></div></th>
<?php } ?>
<?php if ($Page->RESPONSEP->Visible) { ?>
    <th data-name="RESPONSEP" class="<?= $Page->RESPONSEP->headerCellClass() ?>"><div class="register_ranap_RESPONSEP"><?= $Page->renderSort($Page->RESPONSEP) ?></div></th>
<?php } ?>
<?php if ($Page->APPROVAL_DESC->Visible) { ?>
    <th data-name="APPROVAL_DESC" class="<?= $Page->APPROVAL_DESC->headerCellClass() ?>"><div class="register_ranap_APPROVAL_DESC"><?= $Page->renderSort($Page->APPROVAL_DESC) ?></div></th>
<?php } ?>
<?php if ($Page->APPROVAL_RESPONAJUKAN->Visible) { ?>
    <th data-name="APPROVAL_RESPONAJUKAN" class="<?= $Page->APPROVAL_RESPONAJUKAN->headerCellClass() ?>"><div class="register_ranap_APPROVAL_RESPONAJUKAN"><?= $Page->renderSort($Page->APPROVAL_RESPONAJUKAN) ?></div></th>
<?php } ?>
<?php if ($Page->APPROVAL_RESPONAPPROV->Visible) { ?>
    <th data-name="APPROVAL_RESPONAPPROV" class="<?= $Page->APPROVAL_RESPONAPPROV->headerCellClass() ?>"><div class="register_ranap_APPROVAL_RESPONAPPROV"><?= $Page->renderSort($Page->APPROVAL_RESPONAPPROV) ?></div></th>
<?php } ?>
<?php if ($Page->RESPONTGLPLG_DESC->Visible) { ?>
    <th data-name="RESPONTGLPLG_DESC" class="<?= $Page->RESPONTGLPLG_DESC->headerCellClass() ?>"><div class="register_ranap_RESPONTGLPLG_DESC"><?= $Page->renderSort($Page->RESPONTGLPLG_DESC) ?></div></th>
<?php } ?>
<?php if ($Page->RESPONPOST_VKLAIM->Visible) { ?>
    <th data-name="RESPONPOST_VKLAIM" class="<?= $Page->RESPONPOST_VKLAIM->headerCellClass() ?>"><div class="register_ranap_RESPONPOST_VKLAIM"><?= $Page->renderSort($Page->RESPONPOST_VKLAIM) ?></div></th>
<?php } ?>
<?php if ($Page->RESPONPUT_VKLAIM->Visible) { ?>
    <th data-name="RESPONPUT_VKLAIM" class="<?= $Page->RESPONPUT_VKLAIM->headerCellClass() ?>"><div class="register_ranap_RESPONPUT_VKLAIM"><?= $Page->renderSort($Page->RESPONPUT_VKLAIM) ?></div></th>
<?php } ?>
<?php if ($Page->RESPONDEL_VKLAIM->Visible) { ?>
    <th data-name="RESPONDEL_VKLAIM" class="<?= $Page->RESPONDEL_VKLAIM->headerCellClass() ?>"><div class="register_ranap_RESPONDEL_VKLAIM"><?= $Page->renderSort($Page->RESPONDEL_VKLAIM) ?></div></th>
<?php } ?>
<?php if ($Page->CALL_TIMES->Visible) { ?>
    <th data-name="CALL_TIMES" class="<?= $Page->CALL_TIMES->headerCellClass() ?>"><div class="register_ranap_CALL_TIMES"><?= $Page->renderSort($Page->CALL_TIMES) ?></div></th>
<?php } ?>
<?php if ($Page->CALL_DATE->Visible) { ?>
    <th data-name="CALL_DATE" class="<?= $Page->CALL_DATE->headerCellClass() ?>"><div class="register_ranap_CALL_DATE"><?= $Page->renderSort($Page->CALL_DATE) ?></div></th>
<?php } ?>
<?php if ($Page->CALL_DATES->Visible) { ?>
    <th data-name="CALL_DATES" class="<?= $Page->CALL_DATES->headerCellClass() ?>"><div class="register_ranap_CALL_DATES"><?= $Page->renderSort($Page->CALL_DATES) ?></div></th>
<?php } ?>
<?php if ($Page->SERVED_DATE->Visible) { ?>
    <th data-name="SERVED_DATE" class="<?= $Page->SERVED_DATE->headerCellClass() ?>"><div class="register_ranap_SERVED_DATE"><?= $Page->renderSort($Page->SERVED_DATE) ?></div></th>
<?php } ?>
<?php if ($Page->KDDPJP1->Visible) { ?>
    <th data-name="KDDPJP1" class="<?= $Page->KDDPJP1->headerCellClass() ?>"><div class="register_ranap_KDDPJP1"><?= $Page->renderSort($Page->KDDPJP1) ?></div></th>
<?php } ?>
<?php if ($Page->KDDPJP->Visible) { ?>
    <th data-name="KDDPJP" class="<?= $Page->KDDPJP->headerCellClass() ?>"><div class="register_ranap_KDDPJP"><?= $Page->renderSort($Page->KDDPJP) ?></div></th>
<?php } ?>
<?php if ($Page->tgl_kontrol->Visible) { ?>
    <th data-name="tgl_kontrol" class="<?= $Page->tgl_kontrol->headerCellClass() ?>"><div class="register_ranap_tgl_kontrol"><?= $Page->renderSort($Page->tgl_kontrol) ?></div></th>
<?php } ?>
    </tr>
</thead>
<tbody>
<?php
        if ($Page->TotalGroups == 0) {
            break; // Show header only
        }
        $Page->ShowHeader = false;
    } // End show header
?>
<?php
    $Page->loadRowValues($Page->DetailRecords[$Page->RecordCount]);
    $Page->RecordCount++;
    $Page->RecordIndex++;
?>
<?php
        // Render detail row
        $Page->resetAttributes();
        $Page->RowType = ROWTYPE_DETAIL;
        $Page->renderRow();
?>
    <tr<?= $Page->rowAttributes(); ?>>
<?php if ($Page->NO_REGISTRATION->Visible) { ?>
        <td data-field="NO_REGISTRATION"<?= $Page->NO_REGISTRATION->cellAttributes() ?>>
<span<?= $Page->NO_REGISTRATION->viewAttributes() ?>>
<?= $Page->NO_REGISTRATION->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->GENDER->Visible) { ?>
        <td data-field="GENDER"<?= $Page->GENDER->cellAttributes() ?>>
<span<?= $Page->GENDER->viewAttributes() ?>>
<?= $Page->GENDER->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->CLASS_ROOM_ID->Visible) { ?>
        <td data-field="CLASS_ROOM_ID"<?= $Page->CLASS_ROOM_ID->cellAttributes() ?>>
<span<?= $Page->CLASS_ROOM_ID->viewAttributes() ?>>
<?= $Page->CLASS_ROOM_ID->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->BED_ID->Visible) { ?>
        <td data-field="BED_ID"<?= $Page->BED_ID->cellAttributes() ?>>
<span<?= $Page->BED_ID->viewAttributes() ?>>
<?= $Page->BED_ID->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->SERVED_INAP->Visible) { ?>
        <td data-field="SERVED_INAP"<?= $Page->SERVED_INAP->cellAttributes() ?>>
<span<?= $Page->SERVED_INAP->viewAttributes() ?>>
<?= $Page->SERVED_INAP->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->STATUS_PASIEN_ID->Visible) { ?>
        <td data-field="STATUS_PASIEN_ID"<?= $Page->STATUS_PASIEN_ID->cellAttributes() ?>>
<span<?= $Page->STATUS_PASIEN_ID->viewAttributes() ?>>
<?= $Page->STATUS_PASIEN_ID->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->ISRJ->Visible) { ?>
        <td data-field="ISRJ"<?= $Page->ISRJ->cellAttributes() ?>>
<span<?= $Page->ISRJ->viewAttributes() ?>>
<?= $Page->ISRJ->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->VISIT_ID->Visible) { ?>
        <td data-field="VISIT_ID"<?= $Page->VISIT_ID->cellAttributes() ?>>
<span<?= $Page->VISIT_ID->viewAttributes() ?>>
<?= $Page->VISIT_ID->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->IDXDAFTAR->Visible) { ?>
        <td data-field="IDXDAFTAR"<?= $Page->IDXDAFTAR->cellAttributes() ?>>
<span<?= $Page->IDXDAFTAR->viewAttributes() ?>>
<?= $Page->IDXDAFTAR->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->DIANTAR_OLEH->Visible) { ?>
        <td data-field="DIANTAR_OLEH"<?= $Page->DIANTAR_OLEH->cellAttributes() ?>>
<span<?= $Page->DIANTAR_OLEH->viewAttributes() ?>>
<?= $Page->DIANTAR_OLEH->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->EXIT_DATE->Visible) { ?>
        <td data-field="EXIT_DATE"<?= $Page->EXIT_DATE->cellAttributes() ?>>
<span<?= $Page->EXIT_DATE->viewAttributes() ?>>
<?= $Page->EXIT_DATE->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->KELUAR_ID->Visible) { ?>
        <td data-field="KELUAR_ID"<?= $Page->KELUAR_ID->cellAttributes() ?>>
<span<?= $Page->KELUAR_ID->viewAttributes() ?>>
<?= $Page->KELUAR_ID->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->AGEYEAR->Visible) { ?>
        <td data-field="AGEYEAR"<?= $Page->AGEYEAR->cellAttributes() ?>>
<span<?= $Page->AGEYEAR->viewAttributes() ?>>
<?= $Page->AGEYEAR->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->ORG_UNIT_CODE->Visible) { ?>
        <td data-field="ORG_UNIT_CODE"<?= $Page->ORG_UNIT_CODE->cellAttributes() ?>>
<span<?= $Page->ORG_UNIT_CODE->viewAttributes() ?>>
<?= $Page->ORG_UNIT_CODE->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->RUJUKAN_ID->Visible) { ?>
        <td data-field="RUJUKAN_ID"<?= $Page->RUJUKAN_ID->cellAttributes() ?>>
<span<?= $Page->RUJUKAN_ID->viewAttributes() ?>>
<?= $Page->RUJUKAN_ID->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->ADDRESS_OF_RUJUKAN->Visible) { ?>
        <td data-field="ADDRESS_OF_RUJUKAN"<?= $Page->ADDRESS_OF_RUJUKAN->cellAttributes() ?>>
<span<?= $Page->ADDRESS_OF_RUJUKAN->viewAttributes() ?>>
<?= $Page->ADDRESS_OF_RUJUKAN->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->REASON_ID->Visible) { ?>
        <td data-field="REASON_ID"<?= $Page->REASON_ID->cellAttributes() ?>>
<span<?= $Page->REASON_ID->viewAttributes() ?>>
<?= $Page->REASON_ID->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->WAY_ID->Visible) { ?>
        <td data-field="WAY_ID"<?= $Page->WAY_ID->cellAttributes() ?>>
<span<?= $Page->WAY_ID->viewAttributes() ?>>
<?= $Page->WAY_ID->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->PATIENT_CATEGORY_ID->Visible) { ?>
        <td data-field="PATIENT_CATEGORY_ID"<?= $Page->PATIENT_CATEGORY_ID->cellAttributes() ?>>
<span<?= $Page->PATIENT_CATEGORY_ID->viewAttributes() ?>>
<?= $Page->PATIENT_CATEGORY_ID->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->BOOKED_DATE->Visible) { ?>
        <td data-field="BOOKED_DATE"<?= $Page->BOOKED_DATE->cellAttributes() ?>>
<span<?= $Page->BOOKED_DATE->viewAttributes() ?>>
<?= $Page->BOOKED_DATE->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->VISIT_DATE->Visible) { ?>
        <td data-field="VISIT_DATE"<?= $Page->VISIT_DATE->cellAttributes() ?>>
<span<?= $Page->VISIT_DATE->viewAttributes() ?>>
<?= $Page->VISIT_DATE->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->ISNEW->Visible) { ?>
        <td data-field="ISNEW"<?= $Page->ISNEW->cellAttributes() ?>>
<span<?= $Page->ISNEW->viewAttributes() ?>>
<?= $Page->ISNEW->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->FOLLOW_UP->Visible) { ?>
        <td data-field="FOLLOW_UP"<?= $Page->FOLLOW_UP->cellAttributes() ?>>
<span<?= $Page->FOLLOW_UP->viewAttributes() ?>>
<?= $Page->FOLLOW_UP->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->PLACE_TYPE->Visible) { ?>
        <td data-field="PLACE_TYPE"<?= $Page->PLACE_TYPE->cellAttributes() ?>>
<span<?= $Page->PLACE_TYPE->viewAttributes() ?>>
<?= $Page->PLACE_TYPE->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->CLINIC_ID->Visible) { ?>
        <td data-field="CLINIC_ID"<?= $Page->CLINIC_ID->cellAttributes() ?>>
<span<?= $Page->CLINIC_ID->viewAttributes() ?>>
<?= $Page->CLINIC_ID->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->CLINIC_ID_FROM->Visible) { ?>
        <td data-field="CLINIC_ID_FROM"<?= $Page->CLINIC_ID_FROM->cellAttributes() ?>>
<span<?= $Page->CLINIC_ID_FROM->viewAttributes() ?>>
<?= $Page->CLINIC_ID_FROM->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->IN_DATE->Visible) { ?>
        <td data-field="IN_DATE"<?= $Page->IN_DATE->cellAttributes() ?>>
<span<?= $Page->IN_DATE->viewAttributes() ?>>
<?= $Page->IN_DATE->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->DESCRIPTION->Visible) { ?>
        <td data-field="DESCRIPTION"<?= $Page->DESCRIPTION->cellAttributes() ?>>
<span<?= $Page->DESCRIPTION->viewAttributes() ?>>
<?= $Page->DESCRIPTION->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->VISITOR_ADDRESS->Visible) { ?>
        <td data-field="VISITOR_ADDRESS"<?= $Page->VISITOR_ADDRESS->cellAttributes() ?>>
<span<?= $Page->VISITOR_ADDRESS->viewAttributes() ?>>
<?= $Page->VISITOR_ADDRESS->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->MODIFIED_BY->Visible) { ?>
        <td data-field="MODIFIED_BY"<?= $Page->MODIFIED_BY->cellAttributes() ?>>
<span<?= $Page->MODIFIED_BY->viewAttributes() ?>>
<?= $Page->MODIFIED_BY->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->MODIFIED_DATE->Visible) { ?>
        <td data-field="MODIFIED_DATE"<?= $Page->MODIFIED_DATE->cellAttributes() ?>>
<span<?= $Page->MODIFIED_DATE->viewAttributes() ?>>
<?= $Page->MODIFIED_DATE->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->MODIFIED_FROM->Visible) { ?>
        <td data-field="MODIFIED_FROM"<?= $Page->MODIFIED_FROM->cellAttributes() ?>>
<span<?= $Page->MODIFIED_FROM->viewAttributes() ?>>
<?= $Page->MODIFIED_FROM->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->EMPLOYEE_ID->Visible) { ?>
        <td data-field="EMPLOYEE_ID"<?= $Page->EMPLOYEE_ID->cellAttributes() ?>>
<span<?= $Page->EMPLOYEE_ID->viewAttributes() ?>>
<?= $Page->EMPLOYEE_ID->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->EMPLOYEE_ID_FROM->Visible) { ?>
        <td data-field="EMPLOYEE_ID_FROM"<?= $Page->EMPLOYEE_ID_FROM->cellAttributes() ?>>
<span<?= $Page->EMPLOYEE_ID_FROM->viewAttributes() ?>>
<?= $Page->EMPLOYEE_ID_FROM->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->RESPONSIBLE_ID->Visible) { ?>
        <td data-field="RESPONSIBLE_ID"<?= $Page->RESPONSIBLE_ID->cellAttributes() ?>>
<span<?= $Page->RESPONSIBLE_ID->viewAttributes() ?>>
<?= $Page->RESPONSIBLE_ID->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->RESPONSIBLE->Visible) { ?>
        <td data-field="RESPONSIBLE"<?= $Page->RESPONSIBLE->cellAttributes() ?>>
<span<?= $Page->RESPONSIBLE->viewAttributes() ?>>
<?= $Page->RESPONSIBLE->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->FAMILY_STATUS_ID->Visible) { ?>
        <td data-field="FAMILY_STATUS_ID"<?= $Page->FAMILY_STATUS_ID->cellAttributes() ?>>
<span<?= $Page->FAMILY_STATUS_ID->viewAttributes() ?>>
<?= $Page->FAMILY_STATUS_ID->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->TICKET_NO->Visible) { ?>
        <td data-field="TICKET_NO"<?= $Page->TICKET_NO->cellAttributes() ?>>
<span<?= $Page->TICKET_NO->viewAttributes() ?>>
<?= $Page->TICKET_NO->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->ISATTENDED->Visible) { ?>
        <td data-field="ISATTENDED"<?= $Page->ISATTENDED->cellAttributes() ?>>
<span<?= $Page->ISATTENDED->viewAttributes() ?>>
<?= $Page->ISATTENDED->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->PAYOR_ID->Visible) { ?>
        <td data-field="PAYOR_ID"<?= $Page->PAYOR_ID->cellAttributes() ?>>
<span<?= $Page->PAYOR_ID->viewAttributes() ?>>
<?= $Page->PAYOR_ID->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->CLASS_ID->Visible) { ?>
        <td data-field="CLASS_ID"<?= $Page->CLASS_ID->cellAttributes() ?>>
<span<?= $Page->CLASS_ID->viewAttributes() ?>>
<?= $Page->CLASS_ID->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->ISPERTARIF->Visible) { ?>
        <td data-field="ISPERTARIF"<?= $Page->ISPERTARIF->cellAttributes() ?>>
<span<?= $Page->ISPERTARIF->viewAttributes() ?>>
<?= $Page->ISPERTARIF->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->KAL_ID->Visible) { ?>
        <td data-field="KAL_ID"<?= $Page->KAL_ID->cellAttributes() ?>>
<span<?= $Page->KAL_ID->viewAttributes() ?>>
<?= $Page->KAL_ID->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->EMPLOYEE_INAP->Visible) { ?>
        <td data-field="EMPLOYEE_INAP"<?= $Page->EMPLOYEE_INAP->cellAttributes() ?>>
<span<?= $Page->EMPLOYEE_INAP->viewAttributes() ?>>
<?= $Page->EMPLOYEE_INAP->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->PASIEN_ID->Visible) { ?>
        <td data-field="PASIEN_ID"<?= $Page->PASIEN_ID->cellAttributes() ?>>
<span<?= $Page->PASIEN_ID->viewAttributes() ?>>
<?= $Page->PASIEN_ID->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->KARYAWAN->Visible) { ?>
        <td data-field="KARYAWAN"<?= $Page->KARYAWAN->cellAttributes() ?>>
<span<?= $Page->KARYAWAN->viewAttributes() ?>>
<?= $Page->KARYAWAN->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->ACCOUNT_ID->Visible) { ?>
        <td data-field="ACCOUNT_ID"<?= $Page->ACCOUNT_ID->cellAttributes() ?>>
<span<?= $Page->ACCOUNT_ID->viewAttributes() ?>>
<?= $Page->ACCOUNT_ID->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->CLASS_ID_PLAFOND->Visible) { ?>
        <td data-field="CLASS_ID_PLAFOND"<?= $Page->CLASS_ID_PLAFOND->cellAttributes() ?>>
<span<?= $Page->CLASS_ID_PLAFOND->viewAttributes() ?>>
<?= $Page->CLASS_ID_PLAFOND->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->BACKCHARGE->Visible) { ?>
        <td data-field="BACKCHARGE"<?= $Page->BACKCHARGE->cellAttributes() ?>>
<span<?= $Page->BACKCHARGE->viewAttributes() ?>>
<?= $Page->BACKCHARGE->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->COVERAGE_ID->Visible) { ?>
        <td data-field="COVERAGE_ID"<?= $Page->COVERAGE_ID->cellAttributes() ?>>
<span<?= $Page->COVERAGE_ID->viewAttributes() ?>>
<?= $Page->COVERAGE_ID->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->AGEMONTH->Visible) { ?>
        <td data-field="AGEMONTH"<?= $Page->AGEMONTH->cellAttributes() ?>>
<span<?= $Page->AGEMONTH->viewAttributes() ?>>
<?= $Page->AGEMONTH->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->AGEDAY->Visible) { ?>
        <td data-field="AGEDAY"<?= $Page->AGEDAY->cellAttributes() ?>>
<span<?= $Page->AGEDAY->viewAttributes() ?>>
<?= $Page->AGEDAY->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->RECOMENDATION->Visible) { ?>
        <td data-field="RECOMENDATION"<?= $Page->RECOMENDATION->cellAttributes() ?>>
<span<?= $Page->RECOMENDATION->viewAttributes() ?>>
<?= $Page->RECOMENDATION->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->CONCLUSION->Visible) { ?>
        <td data-field="CONCLUSION"<?= $Page->CONCLUSION->cellAttributes() ?>>
<span<?= $Page->CONCLUSION->viewAttributes() ?>>
<?= $Page->CONCLUSION->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->SPECIMENNO->Visible) { ?>
        <td data-field="SPECIMENNO"<?= $Page->SPECIMENNO->cellAttributes() ?>>
<span<?= $Page->SPECIMENNO->viewAttributes() ?>>
<?= $Page->SPECIMENNO->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->LOCKED->Visible) { ?>
        <td data-field="LOCKED"<?= $Page->LOCKED->cellAttributes() ?>>
<span<?= $Page->LOCKED->viewAttributes() ?>>
<?= $Page->LOCKED->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->RM_OUT_DATE->Visible) { ?>
        <td data-field="RM_OUT_DATE"<?= $Page->RM_OUT_DATE->cellAttributes() ?>>
<span<?= $Page->RM_OUT_DATE->viewAttributes() ?>>
<?= $Page->RM_OUT_DATE->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->RM_IN_DATE->Visible) { ?>
        <td data-field="RM_IN_DATE"<?= $Page->RM_IN_DATE->cellAttributes() ?>>
<span<?= $Page->RM_IN_DATE->viewAttributes() ?>>
<?= $Page->RM_IN_DATE->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->LAMA_PINJAM->Visible) { ?>
        <td data-field="LAMA_PINJAM"<?= $Page->LAMA_PINJAM->cellAttributes() ?>>
<span<?= $Page->LAMA_PINJAM->viewAttributes() ?>>
<?= $Page->LAMA_PINJAM->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->STANDAR_RJ->Visible) { ?>
        <td data-field="STANDAR_RJ"<?= $Page->STANDAR_RJ->cellAttributes() ?>>
<span<?= $Page->STANDAR_RJ->viewAttributes() ?>>
<?= $Page->STANDAR_RJ->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->LENGKAP_RJ->Visible) { ?>
        <td data-field="LENGKAP_RJ"<?= $Page->LENGKAP_RJ->cellAttributes() ?>>
<span<?= $Page->LENGKAP_RJ->viewAttributes() ?>>
<?= $Page->LENGKAP_RJ->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->LENGKAP_RI->Visible) { ?>
        <td data-field="LENGKAP_RI"<?= $Page->LENGKAP_RI->cellAttributes() ?>>
<span<?= $Page->LENGKAP_RI->viewAttributes() ?>>
<?= $Page->LENGKAP_RI->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->RESEND_RM_DATE->Visible) { ?>
        <td data-field="RESEND_RM_DATE"<?= $Page->RESEND_RM_DATE->cellAttributes() ?>>
<span<?= $Page->RESEND_RM_DATE->viewAttributes() ?>>
<?= $Page->RESEND_RM_DATE->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->LENGKAP_RM1->Visible) { ?>
        <td data-field="LENGKAP_RM1"<?= $Page->LENGKAP_RM1->cellAttributes() ?>>
<span<?= $Page->LENGKAP_RM1->viewAttributes() ?>>
<?= $Page->LENGKAP_RM1->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->LENGKAP_RESUME->Visible) { ?>
        <td data-field="LENGKAP_RESUME"<?= $Page->LENGKAP_RESUME->cellAttributes() ?>>
<span<?= $Page->LENGKAP_RESUME->viewAttributes() ?>>
<?= $Page->LENGKAP_RESUME->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->LENGKAP_ANAMNESIS->Visible) { ?>
        <td data-field="LENGKAP_ANAMNESIS"<?= $Page->LENGKAP_ANAMNESIS->cellAttributes() ?>>
<span<?= $Page->LENGKAP_ANAMNESIS->viewAttributes() ?>>
<?= $Page->LENGKAP_ANAMNESIS->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->LENGKAP_CONSENT->Visible) { ?>
        <td data-field="LENGKAP_CONSENT"<?= $Page->LENGKAP_CONSENT->cellAttributes() ?>>
<span<?= $Page->LENGKAP_CONSENT->viewAttributes() ?>>
<?= $Page->LENGKAP_CONSENT->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->LENGKAP_ANESTESI->Visible) { ?>
        <td data-field="LENGKAP_ANESTESI"<?= $Page->LENGKAP_ANESTESI->cellAttributes() ?>>
<span<?= $Page->LENGKAP_ANESTESI->viewAttributes() ?>>
<?= $Page->LENGKAP_ANESTESI->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->LENGKAP_OP->Visible) { ?>
        <td data-field="LENGKAP_OP"<?= $Page->LENGKAP_OP->cellAttributes() ?>>
<span<?= $Page->LENGKAP_OP->viewAttributes() ?>>
<?= $Page->LENGKAP_OP->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->BACK_RM_DATE->Visible) { ?>
        <td data-field="BACK_RM_DATE"<?= $Page->BACK_RM_DATE->cellAttributes() ?>>
<span<?= $Page->BACK_RM_DATE->viewAttributes() ?>>
<?= $Page->BACK_RM_DATE->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->VALID_RM_DATE->Visible) { ?>
        <td data-field="VALID_RM_DATE"<?= $Page->VALID_RM_DATE->cellAttributes() ?>>
<span<?= $Page->VALID_RM_DATE->viewAttributes() ?>>
<?= $Page->VALID_RM_DATE->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->NO_SKP->Visible) { ?>
        <td data-field="NO_SKP"<?= $Page->NO_SKP->cellAttributes() ?>>
<span<?= $Page->NO_SKP->viewAttributes() ?>>
<?= $Page->NO_SKP->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->NO_SKPINAP->Visible) { ?>
        <td data-field="NO_SKPINAP"<?= $Page->NO_SKPINAP->cellAttributes() ?>>
<span<?= $Page->NO_SKPINAP->viewAttributes() ?>>
<?= $Page->NO_SKPINAP->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->DIAGNOSA_ID->Visible) { ?>
        <td data-field="DIAGNOSA_ID"<?= $Page->DIAGNOSA_ID->cellAttributes() ?>>
<span<?= $Page->DIAGNOSA_ID->viewAttributes() ?>>
<?= $Page->DIAGNOSA_ID->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->ticket_all->Visible) { ?>
        <td data-field="ticket_all"<?= $Page->ticket_all->cellAttributes() ?>>
<span<?= $Page->ticket_all->viewAttributes() ?>>
<?= $Page->ticket_all->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->tanggal_rujukan->Visible) { ?>
        <td data-field="tanggal_rujukan"<?= $Page->tanggal_rujukan->cellAttributes() ?>>
<span<?= $Page->tanggal_rujukan->viewAttributes() ?>>
<?= $Page->tanggal_rujukan->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->NORUJUKAN->Visible) { ?>
        <td data-field="NORUJUKAN"<?= $Page->NORUJUKAN->cellAttributes() ?>>
<span<?= $Page->NORUJUKAN->viewAttributes() ?>>
<?= $Page->NORUJUKAN->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->PPKRUJUKAN->Visible) { ?>
        <td data-field="PPKRUJUKAN"<?= $Page->PPKRUJUKAN->cellAttributes() ?>>
<span<?= $Page->PPKRUJUKAN->viewAttributes() ?>>
<?= $Page->PPKRUJUKAN->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->LOKASILAKA->Visible) { ?>
        <td data-field="LOKASILAKA"<?= $Page->LOKASILAKA->cellAttributes() ?>>
<span<?= $Page->LOKASILAKA->viewAttributes() ?>>
<?= $Page->LOKASILAKA->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->KDPOLI->Visible) { ?>
        <td data-field="KDPOLI"<?= $Page->KDPOLI->cellAttributes() ?>>
<span<?= $Page->KDPOLI->viewAttributes() ?>>
<?= $Page->KDPOLI->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->EDIT_SEP->Visible) { ?>
        <td data-field="EDIT_SEP"<?= $Page->EDIT_SEP->cellAttributes() ?>>
<span<?= $Page->EDIT_SEP->viewAttributes() ?>>
<?= $Page->EDIT_SEP->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->DELETE_SEP->Visible) { ?>
        <td data-field="DELETE_SEP"<?= $Page->DELETE_SEP->cellAttributes() ?>>
<span<?= $Page->DELETE_SEP->viewAttributes() ?>>
<?= $Page->DELETE_SEP->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->KODE_AGAMA->Visible) { ?>
        <td data-field="KODE_AGAMA"<?= $Page->KODE_AGAMA->cellAttributes() ?>>
<span<?= $Page->KODE_AGAMA->viewAttributes() ?>>
<?= $Page->KODE_AGAMA->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->DIAG_AWAL->Visible) { ?>
        <td data-field="DIAG_AWAL"<?= $Page->DIAG_AWAL->cellAttributes() ?>>
<span<?= $Page->DIAG_AWAL->viewAttributes() ?>>
<?= $Page->DIAG_AWAL->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->AKTIF->Visible) { ?>
        <td data-field="AKTIF"<?= $Page->AKTIF->cellAttributes() ?>>
<span<?= $Page->AKTIF->viewAttributes() ?>>
<?= $Page->AKTIF->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->BILL_INAP->Visible) { ?>
        <td data-field="BILL_INAP"<?= $Page->BILL_INAP->cellAttributes() ?>>
<span<?= $Page->BILL_INAP->viewAttributes() ?>>
<?= $Page->BILL_INAP->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->SEP_PRINTDATE->Visible) { ?>
        <td data-field="SEP_PRINTDATE"<?= $Page->SEP_PRINTDATE->cellAttributes() ?>>
<span<?= $Page->SEP_PRINTDATE->viewAttributes() ?>>
<?= $Page->SEP_PRINTDATE->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->MAPPING_SEP->Visible) { ?>
        <td data-field="MAPPING_SEP"<?= $Page->MAPPING_SEP->cellAttributes() ?>>
<span<?= $Page->MAPPING_SEP->viewAttributes() ?>>
<?= $Page->MAPPING_SEP->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->TRANS_ID->Visible) { ?>
        <td data-field="TRANS_ID"<?= $Page->TRANS_ID->cellAttributes() ?>>
<span<?= $Page->TRANS_ID->viewAttributes() ?>>
<?= $Page->TRANS_ID->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->KDPOLI_EKS->Visible) { ?>
        <td data-field="KDPOLI_EKS"<?= $Page->KDPOLI_EKS->cellAttributes() ?>>
<span<?= $Page->KDPOLI_EKS->viewAttributes() ?>>
<?= $Page->KDPOLI_EKS->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->COB->Visible) { ?>
        <td data-field="COB"<?= $Page->COB->cellAttributes() ?>>
<span<?= $Page->COB->viewAttributes() ?>>
<?= $Page->COB->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->PENJAMIN->Visible) { ?>
        <td data-field="PENJAMIN"<?= $Page->PENJAMIN->cellAttributes() ?>>
<span<?= $Page->PENJAMIN->viewAttributes() ?>>
<?= $Page->PENJAMIN->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->ASALRUJUKAN->Visible) { ?>
        <td data-field="ASALRUJUKAN"<?= $Page->ASALRUJUKAN->cellAttributes() ?>>
<span<?= $Page->ASALRUJUKAN->viewAttributes() ?>>
<?= $Page->ASALRUJUKAN->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->RESPONSEP->Visible) { ?>
        <td data-field="RESPONSEP"<?= $Page->RESPONSEP->cellAttributes() ?>>
<span<?= $Page->RESPONSEP->viewAttributes() ?>>
<?= $Page->RESPONSEP->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->APPROVAL_DESC->Visible) { ?>
        <td data-field="APPROVAL_DESC"<?= $Page->APPROVAL_DESC->cellAttributes() ?>>
<span<?= $Page->APPROVAL_DESC->viewAttributes() ?>>
<?= $Page->APPROVAL_DESC->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->APPROVAL_RESPONAJUKAN->Visible) { ?>
        <td data-field="APPROVAL_RESPONAJUKAN"<?= $Page->APPROVAL_RESPONAJUKAN->cellAttributes() ?>>
<span<?= $Page->APPROVAL_RESPONAJUKAN->viewAttributes() ?>>
<?= $Page->APPROVAL_RESPONAJUKAN->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->APPROVAL_RESPONAPPROV->Visible) { ?>
        <td data-field="APPROVAL_RESPONAPPROV"<?= $Page->APPROVAL_RESPONAPPROV->cellAttributes() ?>>
<span<?= $Page->APPROVAL_RESPONAPPROV->viewAttributes() ?>>
<?= $Page->APPROVAL_RESPONAPPROV->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->RESPONTGLPLG_DESC->Visible) { ?>
        <td data-field="RESPONTGLPLG_DESC"<?= $Page->RESPONTGLPLG_DESC->cellAttributes() ?>>
<span<?= $Page->RESPONTGLPLG_DESC->viewAttributes() ?>>
<?= $Page->RESPONTGLPLG_DESC->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->RESPONPOST_VKLAIM->Visible) { ?>
        <td data-field="RESPONPOST_VKLAIM"<?= $Page->RESPONPOST_VKLAIM->cellAttributes() ?>>
<span<?= $Page->RESPONPOST_VKLAIM->viewAttributes() ?>>
<?= $Page->RESPONPOST_VKLAIM->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->RESPONPUT_VKLAIM->Visible) { ?>
        <td data-field="RESPONPUT_VKLAIM"<?= $Page->RESPONPUT_VKLAIM->cellAttributes() ?>>
<span<?= $Page->RESPONPUT_VKLAIM->viewAttributes() ?>>
<?= $Page->RESPONPUT_VKLAIM->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->RESPONDEL_VKLAIM->Visible) { ?>
        <td data-field="RESPONDEL_VKLAIM"<?= $Page->RESPONDEL_VKLAIM->cellAttributes() ?>>
<span<?= $Page->RESPONDEL_VKLAIM->viewAttributes() ?>>
<?= $Page->RESPONDEL_VKLAIM->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->CALL_TIMES->Visible) { ?>
        <td data-field="CALL_TIMES"<?= $Page->CALL_TIMES->cellAttributes() ?>>
<span<?= $Page->CALL_TIMES->viewAttributes() ?>>
<?= $Page->CALL_TIMES->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->CALL_DATE->Visible) { ?>
        <td data-field="CALL_DATE"<?= $Page->CALL_DATE->cellAttributes() ?>>
<span<?= $Page->CALL_DATE->viewAttributes() ?>>
<?= $Page->CALL_DATE->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->CALL_DATES->Visible) { ?>
        <td data-field="CALL_DATES"<?= $Page->CALL_DATES->cellAttributes() ?>>
<span<?= $Page->CALL_DATES->viewAttributes() ?>>
<?= $Page->CALL_DATES->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->SERVED_DATE->Visible) { ?>
        <td data-field="SERVED_DATE"<?= $Page->SERVED_DATE->cellAttributes() ?>>
<span<?= $Page->SERVED_DATE->viewAttributes() ?>>
<?= $Page->SERVED_DATE->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->KDDPJP1->Visible) { ?>
        <td data-field="KDDPJP1"<?= $Page->KDDPJP1->cellAttributes() ?>>
<span<?= $Page->KDDPJP1->viewAttributes() ?>>
<?= $Page->KDDPJP1->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->KDDPJP->Visible) { ?>
        <td data-field="KDDPJP"<?= $Page->KDDPJP->cellAttributes() ?>>
<span<?= $Page->KDDPJP->viewAttributes() ?>>
<?= $Page->KDDPJP->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->tgl_kontrol->Visible) { ?>
        <td data-field="tgl_kontrol"<?= $Page->tgl_kontrol->cellAttributes() ?>>
<span<?= $Page->tgl_kontrol->viewAttributes() ?>>
<?= $Page->tgl_kontrol->getViewValue() ?></span>
</td>
<?php } ?>
    </tr>
<?php
} // End while
?>
<?php if ($Page->TotalGroups > 0) { ?>
</tbody>
<tfoot>
<?php
    $Page->resetAttributes();
    $Page->RowType = ROWTYPE_TOTAL;
    $Page->RowTotalType = ROWTOTAL_GRAND;
    $Page->RowTotalSubType = ROWTOTAL_FOOTER;
    $Page->RowAttrs["class"] = "ew-rpt-grand-summary";
    $Page->renderRow();
?>
<?php if ($Page->ShowCompactSummaryFooter) { ?>
    <tr<?= $Page->rowAttributes() ?>><td colspan="<?= ($Page->GroupColumnCount + $Page->DetailColumnCount) ?>"><?= $Language->phrase("RptGrandSummary") ?> <span class="ew-summary-count">(<span class="ew-aggregate-caption"><?= $Language->phrase("RptCnt") ?></span><?= $Language->phrase("AggregateEqual") ?><span class="ew-aggregate-value"><?= FormatNumber($Page->TotalCount, 0); ?></span>)</span></td></tr>
    <tr<?= $Page->rowAttributes() ?>>
<?php if ($Page->GroupColumnCount > 0) { ?>
        <td colspan="<?= $Page->GroupColumnCount ?>" class="ew-rpt-grp-aggregate">&nbsp;</td>
<?php } ?>
<?php if ($Page->NO_REGISTRATION->Visible) { ?>
        <td data-field="NO_REGISTRATION"<?= $Page->NO_REGISTRATION->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->GENDER->Visible) { ?>
        <td data-field="GENDER"<?= $Page->GENDER->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->CLASS_ROOM_ID->Visible) { ?>
        <td data-field="CLASS_ROOM_ID"<?= $Page->CLASS_ROOM_ID->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->BED_ID->Visible) { ?>
        <td data-field="BED_ID"<?= $Page->BED_ID->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->SERVED_INAP->Visible) { ?>
        <td data-field="SERVED_INAP"<?= $Page->SERVED_INAP->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->STATUS_PASIEN_ID->Visible) { ?>
        <td data-field="STATUS_PASIEN_ID"<?= $Page->STATUS_PASIEN_ID->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->ISRJ->Visible) { ?>
        <td data-field="ISRJ"<?= $Page->ISRJ->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->VISIT_ID->Visible) { ?>
        <td data-field="VISIT_ID"<?= $Page->VISIT_ID->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->IDXDAFTAR->Visible) { ?>
        <td data-field="IDXDAFTAR"<?= $Page->IDXDAFTAR->cellAttributes() ?>><span class="ew-aggregate-caption"><?= $Language->phrase("RptCnt") ?></span><?= $Language->phrase("AggregateEqual") ?><span class="ew-aggregate-value"><span<?= $Page->IDXDAFTAR->viewAttributes() ?>><?= $Page->IDXDAFTAR->CntViewValue ?></span></span></td>
<?php } ?>
<?php if ($Page->DIANTAR_OLEH->Visible) { ?>
        <td data-field="DIANTAR_OLEH"<?= $Page->DIANTAR_OLEH->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->EXIT_DATE->Visible) { ?>
        <td data-field="EXIT_DATE"<?= $Page->EXIT_DATE->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->KELUAR_ID->Visible) { ?>
        <td data-field="KELUAR_ID"<?= $Page->KELUAR_ID->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->AGEYEAR->Visible) { ?>
        <td data-field="AGEYEAR"<?= $Page->AGEYEAR->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->ORG_UNIT_CODE->Visible) { ?>
        <td data-field="ORG_UNIT_CODE"<?= $Page->ORG_UNIT_CODE->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->RUJUKAN_ID->Visible) { ?>
        <td data-field="RUJUKAN_ID"<?= $Page->RUJUKAN_ID->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->ADDRESS_OF_RUJUKAN->Visible) { ?>
        <td data-field="ADDRESS_OF_RUJUKAN"<?= $Page->ADDRESS_OF_RUJUKAN->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->REASON_ID->Visible) { ?>
        <td data-field="REASON_ID"<?= $Page->REASON_ID->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->WAY_ID->Visible) { ?>
        <td data-field="WAY_ID"<?= $Page->WAY_ID->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->PATIENT_CATEGORY_ID->Visible) { ?>
        <td data-field="PATIENT_CATEGORY_ID"<?= $Page->PATIENT_CATEGORY_ID->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->BOOKED_DATE->Visible) { ?>
        <td data-field="BOOKED_DATE"<?= $Page->BOOKED_DATE->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->VISIT_DATE->Visible) { ?>
        <td data-field="VISIT_DATE"<?= $Page->VISIT_DATE->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->ISNEW->Visible) { ?>
        <td data-field="ISNEW"<?= $Page->ISNEW->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->FOLLOW_UP->Visible) { ?>
        <td data-field="FOLLOW_UP"<?= $Page->FOLLOW_UP->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->PLACE_TYPE->Visible) { ?>
        <td data-field="PLACE_TYPE"<?= $Page->PLACE_TYPE->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->CLINIC_ID->Visible) { ?>
        <td data-field="CLINIC_ID"<?= $Page->CLINIC_ID->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->CLINIC_ID_FROM->Visible) { ?>
        <td data-field="CLINIC_ID_FROM"<?= $Page->CLINIC_ID_FROM->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->IN_DATE->Visible) { ?>
        <td data-field="IN_DATE"<?= $Page->IN_DATE->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->DESCRIPTION->Visible) { ?>
        <td data-field="DESCRIPTION"<?= $Page->DESCRIPTION->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->VISITOR_ADDRESS->Visible) { ?>
        <td data-field="VISITOR_ADDRESS"<?= $Page->VISITOR_ADDRESS->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->MODIFIED_BY->Visible) { ?>
        <td data-field="MODIFIED_BY"<?= $Page->MODIFIED_BY->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->MODIFIED_DATE->Visible) { ?>
        <td data-field="MODIFIED_DATE"<?= $Page->MODIFIED_DATE->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->MODIFIED_FROM->Visible) { ?>
        <td data-field="MODIFIED_FROM"<?= $Page->MODIFIED_FROM->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->EMPLOYEE_ID->Visible) { ?>
        <td data-field="EMPLOYEE_ID"<?= $Page->EMPLOYEE_ID->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->EMPLOYEE_ID_FROM->Visible) { ?>
        <td data-field="EMPLOYEE_ID_FROM"<?= $Page->EMPLOYEE_ID_FROM->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->RESPONSIBLE_ID->Visible) { ?>
        <td data-field="RESPONSIBLE_ID"<?= $Page->RESPONSIBLE_ID->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->RESPONSIBLE->Visible) { ?>
        <td data-field="RESPONSIBLE"<?= $Page->RESPONSIBLE->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->FAMILY_STATUS_ID->Visible) { ?>
        <td data-field="FAMILY_STATUS_ID"<?= $Page->FAMILY_STATUS_ID->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->TICKET_NO->Visible) { ?>
        <td data-field="TICKET_NO"<?= $Page->TICKET_NO->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->ISATTENDED->Visible) { ?>
        <td data-field="ISATTENDED"<?= $Page->ISATTENDED->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->PAYOR_ID->Visible) { ?>
        <td data-field="PAYOR_ID"<?= $Page->PAYOR_ID->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->CLASS_ID->Visible) { ?>
        <td data-field="CLASS_ID"<?= $Page->CLASS_ID->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->ISPERTARIF->Visible) { ?>
        <td data-field="ISPERTARIF"<?= $Page->ISPERTARIF->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->KAL_ID->Visible) { ?>
        <td data-field="KAL_ID"<?= $Page->KAL_ID->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->EMPLOYEE_INAP->Visible) { ?>
        <td data-field="EMPLOYEE_INAP"<?= $Page->EMPLOYEE_INAP->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->PASIEN_ID->Visible) { ?>
        <td data-field="PASIEN_ID"<?= $Page->PASIEN_ID->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->KARYAWAN->Visible) { ?>
        <td data-field="KARYAWAN"<?= $Page->KARYAWAN->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->ACCOUNT_ID->Visible) { ?>
        <td data-field="ACCOUNT_ID"<?= $Page->ACCOUNT_ID->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->CLASS_ID_PLAFOND->Visible) { ?>
        <td data-field="CLASS_ID_PLAFOND"<?= $Page->CLASS_ID_PLAFOND->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->BACKCHARGE->Visible) { ?>
        <td data-field="BACKCHARGE"<?= $Page->BACKCHARGE->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->COVERAGE_ID->Visible) { ?>
        <td data-field="COVERAGE_ID"<?= $Page->COVERAGE_ID->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->AGEMONTH->Visible) { ?>
        <td data-field="AGEMONTH"<?= $Page->AGEMONTH->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->AGEDAY->Visible) { ?>
        <td data-field="AGEDAY"<?= $Page->AGEDAY->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->RECOMENDATION->Visible) { ?>
        <td data-field="RECOMENDATION"<?= $Page->RECOMENDATION->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->CONCLUSION->Visible) { ?>
        <td data-field="CONCLUSION"<?= $Page->CONCLUSION->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->SPECIMENNO->Visible) { ?>
        <td data-field="SPECIMENNO"<?= $Page->SPECIMENNO->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->LOCKED->Visible) { ?>
        <td data-field="LOCKED"<?= $Page->LOCKED->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->RM_OUT_DATE->Visible) { ?>
        <td data-field="RM_OUT_DATE"<?= $Page->RM_OUT_DATE->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->RM_IN_DATE->Visible) { ?>
        <td data-field="RM_IN_DATE"<?= $Page->RM_IN_DATE->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->LAMA_PINJAM->Visible) { ?>
        <td data-field="LAMA_PINJAM"<?= $Page->LAMA_PINJAM->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->STANDAR_RJ->Visible) { ?>
        <td data-field="STANDAR_RJ"<?= $Page->STANDAR_RJ->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->LENGKAP_RJ->Visible) { ?>
        <td data-field="LENGKAP_RJ"<?= $Page->LENGKAP_RJ->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->LENGKAP_RI->Visible) { ?>
        <td data-field="LENGKAP_RI"<?= $Page->LENGKAP_RI->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->RESEND_RM_DATE->Visible) { ?>
        <td data-field="RESEND_RM_DATE"<?= $Page->RESEND_RM_DATE->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->LENGKAP_RM1->Visible) { ?>
        <td data-field="LENGKAP_RM1"<?= $Page->LENGKAP_RM1->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->LENGKAP_RESUME->Visible) { ?>
        <td data-field="LENGKAP_RESUME"<?= $Page->LENGKAP_RESUME->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->LENGKAP_ANAMNESIS->Visible) { ?>
        <td data-field="LENGKAP_ANAMNESIS"<?= $Page->LENGKAP_ANAMNESIS->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->LENGKAP_CONSENT->Visible) { ?>
        <td data-field="LENGKAP_CONSENT"<?= $Page->LENGKAP_CONSENT->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->LENGKAP_ANESTESI->Visible) { ?>
        <td data-field="LENGKAP_ANESTESI"<?= $Page->LENGKAP_ANESTESI->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->LENGKAP_OP->Visible) { ?>
        <td data-field="LENGKAP_OP"<?= $Page->LENGKAP_OP->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->BACK_RM_DATE->Visible) { ?>
        <td data-field="BACK_RM_DATE"<?= $Page->BACK_RM_DATE->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->VALID_RM_DATE->Visible) { ?>
        <td data-field="VALID_RM_DATE"<?= $Page->VALID_RM_DATE->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->NO_SKP->Visible) { ?>
        <td data-field="NO_SKP"<?= $Page->NO_SKP->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->NO_SKPINAP->Visible) { ?>
        <td data-field="NO_SKPINAP"<?= $Page->NO_SKPINAP->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->DIAGNOSA_ID->Visible) { ?>
        <td data-field="DIAGNOSA_ID"<?= $Page->DIAGNOSA_ID->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->ticket_all->Visible) { ?>
        <td data-field="ticket_all"<?= $Page->ticket_all->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->tanggal_rujukan->Visible) { ?>
        <td data-field="tanggal_rujukan"<?= $Page->tanggal_rujukan->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->NORUJUKAN->Visible) { ?>
        <td data-field="NORUJUKAN"<?= $Page->NORUJUKAN->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->PPKRUJUKAN->Visible) { ?>
        <td data-field="PPKRUJUKAN"<?= $Page->PPKRUJUKAN->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->LOKASILAKA->Visible) { ?>
        <td data-field="LOKASILAKA"<?= $Page->LOKASILAKA->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->KDPOLI->Visible) { ?>
        <td data-field="KDPOLI"<?= $Page->KDPOLI->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->EDIT_SEP->Visible) { ?>
        <td data-field="EDIT_SEP"<?= $Page->EDIT_SEP->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->DELETE_SEP->Visible) { ?>
        <td data-field="DELETE_SEP"<?= $Page->DELETE_SEP->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->KODE_AGAMA->Visible) { ?>
        <td data-field="KODE_AGAMA"<?= $Page->KODE_AGAMA->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->DIAG_AWAL->Visible) { ?>
        <td data-field="DIAG_AWAL"<?= $Page->DIAG_AWAL->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->AKTIF->Visible) { ?>
        <td data-field="AKTIF"<?= $Page->AKTIF->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->BILL_INAP->Visible) { ?>
        <td data-field="BILL_INAP"<?= $Page->BILL_INAP->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->SEP_PRINTDATE->Visible) { ?>
        <td data-field="SEP_PRINTDATE"<?= $Page->SEP_PRINTDATE->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->MAPPING_SEP->Visible) { ?>
        <td data-field="MAPPING_SEP"<?= $Page->MAPPING_SEP->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->TRANS_ID->Visible) { ?>
        <td data-field="TRANS_ID"<?= $Page->TRANS_ID->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->KDPOLI_EKS->Visible) { ?>
        <td data-field="KDPOLI_EKS"<?= $Page->KDPOLI_EKS->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->COB->Visible) { ?>
        <td data-field="COB"<?= $Page->COB->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->PENJAMIN->Visible) { ?>
        <td data-field="PENJAMIN"<?= $Page->PENJAMIN->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->ASALRUJUKAN->Visible) { ?>
        <td data-field="ASALRUJUKAN"<?= $Page->ASALRUJUKAN->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->RESPONSEP->Visible) { ?>
        <td data-field="RESPONSEP"<?= $Page->RESPONSEP->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->APPROVAL_DESC->Visible) { ?>
        <td data-field="APPROVAL_DESC"<?= $Page->APPROVAL_DESC->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->APPROVAL_RESPONAJUKAN->Visible) { ?>
        <td data-field="APPROVAL_RESPONAJUKAN"<?= $Page->APPROVAL_RESPONAJUKAN->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->APPROVAL_RESPONAPPROV->Visible) { ?>
        <td data-field="APPROVAL_RESPONAPPROV"<?= $Page->APPROVAL_RESPONAPPROV->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->RESPONTGLPLG_DESC->Visible) { ?>
        <td data-field="RESPONTGLPLG_DESC"<?= $Page->RESPONTGLPLG_DESC->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->RESPONPOST_VKLAIM->Visible) { ?>
        <td data-field="RESPONPOST_VKLAIM"<?= $Page->RESPONPOST_VKLAIM->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->RESPONPUT_VKLAIM->Visible) { ?>
        <td data-field="RESPONPUT_VKLAIM"<?= $Page->RESPONPUT_VKLAIM->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->RESPONDEL_VKLAIM->Visible) { ?>
        <td data-field="RESPONDEL_VKLAIM"<?= $Page->RESPONDEL_VKLAIM->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->CALL_TIMES->Visible) { ?>
        <td data-field="CALL_TIMES"<?= $Page->CALL_TIMES->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->CALL_DATE->Visible) { ?>
        <td data-field="CALL_DATE"<?= $Page->CALL_DATE->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->CALL_DATES->Visible) { ?>
        <td data-field="CALL_DATES"<?= $Page->CALL_DATES->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->SERVED_DATE->Visible) { ?>
        <td data-field="SERVED_DATE"<?= $Page->SERVED_DATE->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->KDDPJP1->Visible) { ?>
        <td data-field="KDDPJP1"<?= $Page->KDDPJP1->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->KDDPJP->Visible) { ?>
        <td data-field="KDDPJP"<?= $Page->KDDPJP->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->tgl_kontrol->Visible) { ?>
        <td data-field="tgl_kontrol"<?= $Page->tgl_kontrol->cellAttributes() ?>></td>
<?php } ?>
    </tr>
<?php } else { ?>
    <tr<?= $Page->rowAttributes() ?>><td colspan="<?= ($Page->GroupColumnCount + $Page->DetailColumnCount) ?>"><?= $Language->phrase("RptGrandSummary") ?> <span class="ew-summary-count">(<?= FormatNumber($Page->TotalCount, 0); ?><?= $Language->phrase("RptDtlRec") ?>)</span></td></tr>
    <tr<?= $Page->rowAttributes() ?>>
<?php if ($Page->NO_REGISTRATION->Visible) { ?>
        <td data-field="NO_REGISTRATION"<?= $Page->NO_REGISTRATION->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->GENDER->Visible) { ?>
        <td data-field="GENDER"<?= $Page->GENDER->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->CLASS_ROOM_ID->Visible) { ?>
        <td data-field="CLASS_ROOM_ID"<?= $Page->CLASS_ROOM_ID->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->BED_ID->Visible) { ?>
        <td data-field="BED_ID"<?= $Page->BED_ID->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->SERVED_INAP->Visible) { ?>
        <td data-field="SERVED_INAP"<?= $Page->SERVED_INAP->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->STATUS_PASIEN_ID->Visible) { ?>
        <td data-field="STATUS_PASIEN_ID"<?= $Page->STATUS_PASIEN_ID->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->ISRJ->Visible) { ?>
        <td data-field="ISRJ"<?= $Page->ISRJ->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->VISIT_ID->Visible) { ?>
        <td data-field="VISIT_ID"<?= $Page->VISIT_ID->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->IDXDAFTAR->Visible) { ?>
        <td data-field="IDXDAFTAR"<?= $Page->IDXDAFTAR->cellAttributes() ?>><span class="ew-aggregate"><?= $Language->phrase("RptCnt") ?></span><?= $Language->phrase("AggregateColon") ?>
<span<?= $Page->IDXDAFTAR->viewAttributes() ?>>
<?= $Page->IDXDAFTAR->CntViewValue ?></span>
</td>
<?php } ?>
<?php if ($Page->DIANTAR_OLEH->Visible) { ?>
        <td data-field="DIANTAR_OLEH"<?= $Page->DIANTAR_OLEH->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->EXIT_DATE->Visible) { ?>
        <td data-field="EXIT_DATE"<?= $Page->EXIT_DATE->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->KELUAR_ID->Visible) { ?>
        <td data-field="KELUAR_ID"<?= $Page->KELUAR_ID->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->AGEYEAR->Visible) { ?>
        <td data-field="AGEYEAR"<?= $Page->AGEYEAR->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->ORG_UNIT_CODE->Visible) { ?>
        <td data-field="ORG_UNIT_CODE"<?= $Page->ORG_UNIT_CODE->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->RUJUKAN_ID->Visible) { ?>
        <td data-field="RUJUKAN_ID"<?= $Page->RUJUKAN_ID->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->ADDRESS_OF_RUJUKAN->Visible) { ?>
        <td data-field="ADDRESS_OF_RUJUKAN"<?= $Page->ADDRESS_OF_RUJUKAN->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->REASON_ID->Visible) { ?>
        <td data-field="REASON_ID"<?= $Page->REASON_ID->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->WAY_ID->Visible) { ?>
        <td data-field="WAY_ID"<?= $Page->WAY_ID->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->PATIENT_CATEGORY_ID->Visible) { ?>
        <td data-field="PATIENT_CATEGORY_ID"<?= $Page->PATIENT_CATEGORY_ID->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->BOOKED_DATE->Visible) { ?>
        <td data-field="BOOKED_DATE"<?= $Page->BOOKED_DATE->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->VISIT_DATE->Visible) { ?>
        <td data-field="VISIT_DATE"<?= $Page->VISIT_DATE->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->ISNEW->Visible) { ?>
        <td data-field="ISNEW"<?= $Page->ISNEW->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->FOLLOW_UP->Visible) { ?>
        <td data-field="FOLLOW_UP"<?= $Page->FOLLOW_UP->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->PLACE_TYPE->Visible) { ?>
        <td data-field="PLACE_TYPE"<?= $Page->PLACE_TYPE->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->CLINIC_ID->Visible) { ?>
        <td data-field="CLINIC_ID"<?= $Page->CLINIC_ID->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->CLINIC_ID_FROM->Visible) { ?>
        <td data-field="CLINIC_ID_FROM"<?= $Page->CLINIC_ID_FROM->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->IN_DATE->Visible) { ?>
        <td data-field="IN_DATE"<?= $Page->IN_DATE->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->DESCRIPTION->Visible) { ?>
        <td data-field="DESCRIPTION"<?= $Page->DESCRIPTION->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->VISITOR_ADDRESS->Visible) { ?>
        <td data-field="VISITOR_ADDRESS"<?= $Page->VISITOR_ADDRESS->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->MODIFIED_BY->Visible) { ?>
        <td data-field="MODIFIED_BY"<?= $Page->MODIFIED_BY->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->MODIFIED_DATE->Visible) { ?>
        <td data-field="MODIFIED_DATE"<?= $Page->MODIFIED_DATE->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->MODIFIED_FROM->Visible) { ?>
        <td data-field="MODIFIED_FROM"<?= $Page->MODIFIED_FROM->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->EMPLOYEE_ID->Visible) { ?>
        <td data-field="EMPLOYEE_ID"<?= $Page->EMPLOYEE_ID->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->EMPLOYEE_ID_FROM->Visible) { ?>
        <td data-field="EMPLOYEE_ID_FROM"<?= $Page->EMPLOYEE_ID_FROM->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->RESPONSIBLE_ID->Visible) { ?>
        <td data-field="RESPONSIBLE_ID"<?= $Page->RESPONSIBLE_ID->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->RESPONSIBLE->Visible) { ?>
        <td data-field="RESPONSIBLE"<?= $Page->RESPONSIBLE->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->FAMILY_STATUS_ID->Visible) { ?>
        <td data-field="FAMILY_STATUS_ID"<?= $Page->FAMILY_STATUS_ID->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->TICKET_NO->Visible) { ?>
        <td data-field="TICKET_NO"<?= $Page->TICKET_NO->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->ISATTENDED->Visible) { ?>
        <td data-field="ISATTENDED"<?= $Page->ISATTENDED->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->PAYOR_ID->Visible) { ?>
        <td data-field="PAYOR_ID"<?= $Page->PAYOR_ID->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->CLASS_ID->Visible) { ?>
        <td data-field="CLASS_ID"<?= $Page->CLASS_ID->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->ISPERTARIF->Visible) { ?>
        <td data-field="ISPERTARIF"<?= $Page->ISPERTARIF->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->KAL_ID->Visible) { ?>
        <td data-field="KAL_ID"<?= $Page->KAL_ID->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->EMPLOYEE_INAP->Visible) { ?>
        <td data-field="EMPLOYEE_INAP"<?= $Page->EMPLOYEE_INAP->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->PASIEN_ID->Visible) { ?>
        <td data-field="PASIEN_ID"<?= $Page->PASIEN_ID->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->KARYAWAN->Visible) { ?>
        <td data-field="KARYAWAN"<?= $Page->KARYAWAN->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->ACCOUNT_ID->Visible) { ?>
        <td data-field="ACCOUNT_ID"<?= $Page->ACCOUNT_ID->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->CLASS_ID_PLAFOND->Visible) { ?>
        <td data-field="CLASS_ID_PLAFOND"<?= $Page->CLASS_ID_PLAFOND->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->BACKCHARGE->Visible) { ?>
        <td data-field="BACKCHARGE"<?= $Page->BACKCHARGE->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->COVERAGE_ID->Visible) { ?>
        <td data-field="COVERAGE_ID"<?= $Page->COVERAGE_ID->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->AGEMONTH->Visible) { ?>
        <td data-field="AGEMONTH"<?= $Page->AGEMONTH->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->AGEDAY->Visible) { ?>
        <td data-field="AGEDAY"<?= $Page->AGEDAY->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->RECOMENDATION->Visible) { ?>
        <td data-field="RECOMENDATION"<?= $Page->RECOMENDATION->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->CONCLUSION->Visible) { ?>
        <td data-field="CONCLUSION"<?= $Page->CONCLUSION->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->SPECIMENNO->Visible) { ?>
        <td data-field="SPECIMENNO"<?= $Page->SPECIMENNO->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->LOCKED->Visible) { ?>
        <td data-field="LOCKED"<?= $Page->LOCKED->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->RM_OUT_DATE->Visible) { ?>
        <td data-field="RM_OUT_DATE"<?= $Page->RM_OUT_DATE->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->RM_IN_DATE->Visible) { ?>
        <td data-field="RM_IN_DATE"<?= $Page->RM_IN_DATE->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->LAMA_PINJAM->Visible) { ?>
        <td data-field="LAMA_PINJAM"<?= $Page->LAMA_PINJAM->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->STANDAR_RJ->Visible) { ?>
        <td data-field="STANDAR_RJ"<?= $Page->STANDAR_RJ->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->LENGKAP_RJ->Visible) { ?>
        <td data-field="LENGKAP_RJ"<?= $Page->LENGKAP_RJ->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->LENGKAP_RI->Visible) { ?>
        <td data-field="LENGKAP_RI"<?= $Page->LENGKAP_RI->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->RESEND_RM_DATE->Visible) { ?>
        <td data-field="RESEND_RM_DATE"<?= $Page->RESEND_RM_DATE->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->LENGKAP_RM1->Visible) { ?>
        <td data-field="LENGKAP_RM1"<?= $Page->LENGKAP_RM1->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->LENGKAP_RESUME->Visible) { ?>
        <td data-field="LENGKAP_RESUME"<?= $Page->LENGKAP_RESUME->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->LENGKAP_ANAMNESIS->Visible) { ?>
        <td data-field="LENGKAP_ANAMNESIS"<?= $Page->LENGKAP_ANAMNESIS->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->LENGKAP_CONSENT->Visible) { ?>
        <td data-field="LENGKAP_CONSENT"<?= $Page->LENGKAP_CONSENT->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->LENGKAP_ANESTESI->Visible) { ?>
        <td data-field="LENGKAP_ANESTESI"<?= $Page->LENGKAP_ANESTESI->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->LENGKAP_OP->Visible) { ?>
        <td data-field="LENGKAP_OP"<?= $Page->LENGKAP_OP->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->BACK_RM_DATE->Visible) { ?>
        <td data-field="BACK_RM_DATE"<?= $Page->BACK_RM_DATE->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->VALID_RM_DATE->Visible) { ?>
        <td data-field="VALID_RM_DATE"<?= $Page->VALID_RM_DATE->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->NO_SKP->Visible) { ?>
        <td data-field="NO_SKP"<?= $Page->NO_SKP->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->NO_SKPINAP->Visible) { ?>
        <td data-field="NO_SKPINAP"<?= $Page->NO_SKPINAP->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->DIAGNOSA_ID->Visible) { ?>
        <td data-field="DIAGNOSA_ID"<?= $Page->DIAGNOSA_ID->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->ticket_all->Visible) { ?>
        <td data-field="ticket_all"<?= $Page->ticket_all->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->tanggal_rujukan->Visible) { ?>
        <td data-field="tanggal_rujukan"<?= $Page->tanggal_rujukan->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->NORUJUKAN->Visible) { ?>
        <td data-field="NORUJUKAN"<?= $Page->NORUJUKAN->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->PPKRUJUKAN->Visible) { ?>
        <td data-field="PPKRUJUKAN"<?= $Page->PPKRUJUKAN->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->LOKASILAKA->Visible) { ?>
        <td data-field="LOKASILAKA"<?= $Page->LOKASILAKA->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->KDPOLI->Visible) { ?>
        <td data-field="KDPOLI"<?= $Page->KDPOLI->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->EDIT_SEP->Visible) { ?>
        <td data-field="EDIT_SEP"<?= $Page->EDIT_SEP->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->DELETE_SEP->Visible) { ?>
        <td data-field="DELETE_SEP"<?= $Page->DELETE_SEP->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->KODE_AGAMA->Visible) { ?>
        <td data-field="KODE_AGAMA"<?= $Page->KODE_AGAMA->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->DIAG_AWAL->Visible) { ?>
        <td data-field="DIAG_AWAL"<?= $Page->DIAG_AWAL->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->AKTIF->Visible) { ?>
        <td data-field="AKTIF"<?= $Page->AKTIF->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->BILL_INAP->Visible) { ?>
        <td data-field="BILL_INAP"<?= $Page->BILL_INAP->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->SEP_PRINTDATE->Visible) { ?>
        <td data-field="SEP_PRINTDATE"<?= $Page->SEP_PRINTDATE->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->MAPPING_SEP->Visible) { ?>
        <td data-field="MAPPING_SEP"<?= $Page->MAPPING_SEP->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->TRANS_ID->Visible) { ?>
        <td data-field="TRANS_ID"<?= $Page->TRANS_ID->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->KDPOLI_EKS->Visible) { ?>
        <td data-field="KDPOLI_EKS"<?= $Page->KDPOLI_EKS->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->COB->Visible) { ?>
        <td data-field="COB"<?= $Page->COB->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->PENJAMIN->Visible) { ?>
        <td data-field="PENJAMIN"<?= $Page->PENJAMIN->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->ASALRUJUKAN->Visible) { ?>
        <td data-field="ASALRUJUKAN"<?= $Page->ASALRUJUKAN->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->RESPONSEP->Visible) { ?>
        <td data-field="RESPONSEP"<?= $Page->RESPONSEP->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->APPROVAL_DESC->Visible) { ?>
        <td data-field="APPROVAL_DESC"<?= $Page->APPROVAL_DESC->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->APPROVAL_RESPONAJUKAN->Visible) { ?>
        <td data-field="APPROVAL_RESPONAJUKAN"<?= $Page->APPROVAL_RESPONAJUKAN->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->APPROVAL_RESPONAPPROV->Visible) { ?>
        <td data-field="APPROVAL_RESPONAPPROV"<?= $Page->APPROVAL_RESPONAPPROV->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->RESPONTGLPLG_DESC->Visible) { ?>
        <td data-field="RESPONTGLPLG_DESC"<?= $Page->RESPONTGLPLG_DESC->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->RESPONPOST_VKLAIM->Visible) { ?>
        <td data-field="RESPONPOST_VKLAIM"<?= $Page->RESPONPOST_VKLAIM->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->RESPONPUT_VKLAIM->Visible) { ?>
        <td data-field="RESPONPUT_VKLAIM"<?= $Page->RESPONPUT_VKLAIM->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->RESPONDEL_VKLAIM->Visible) { ?>
        <td data-field="RESPONDEL_VKLAIM"<?= $Page->RESPONDEL_VKLAIM->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->CALL_TIMES->Visible) { ?>
        <td data-field="CALL_TIMES"<?= $Page->CALL_TIMES->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->CALL_DATE->Visible) { ?>
        <td data-field="CALL_DATE"<?= $Page->CALL_DATE->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->CALL_DATES->Visible) { ?>
        <td data-field="CALL_DATES"<?= $Page->CALL_DATES->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->SERVED_DATE->Visible) { ?>
        <td data-field="SERVED_DATE"<?= $Page->SERVED_DATE->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->KDDPJP1->Visible) { ?>
        <td data-field="KDDPJP1"<?= $Page->KDDPJP1->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->KDDPJP->Visible) { ?>
        <td data-field="KDDPJP"<?= $Page->KDDPJP->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->tgl_kontrol->Visible) { ?>
        <td data-field="tgl_kontrol"<?= $Page->tgl_kontrol->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
    </tr>
<?php } ?>
</tfoot>
</table>
</div>
<!-- /.ew-grid-middle-panel -->
<!-- Report grid (end) -->
</div>
<!-- /.ew-grid -->
<?php } ?>
</div>
<!-- /#report-summary -->
<!-- Summary report (end) -->
<?php if ((!$Page->isExport() || $Page->isExport("print")) && !$DashboardReport) { ?>
</div>
<!-- /#ew-center -->
<?php } ?>
<?php if ((!$Page->isExport() || $Page->isExport("print")) && !$DashboardReport) { ?>
</div>
<!-- /.row -->
<?php } ?>
<?php if ((!$Page->isExport() || $Page->isExport("print")) && !$DashboardReport) { ?>
</div>
<!-- /.ew-report -->
<?php } ?>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport() && !$Page->DrillDown && !$DashboardReport) { ?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
