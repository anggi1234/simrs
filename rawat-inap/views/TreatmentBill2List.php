<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

// Page object
$TreatmentBill2List = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var ftreatment_bill2list;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    ftreatment_bill2list = currentForm = new ew.Form("ftreatment_bill2list", "list");
    ftreatment_bill2list.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("ftreatment_bill2list");
});
var ftreatment_bill2listsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    ftreatment_bill2listsrch = currentSearchForm = new ew.Form("ftreatment_bill2listsrch");

    // Dynamic selection lists

    // Filters
    ftreatment_bill2listsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("ftreatment_bill2listsrch");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($Page->TotalRecords > 0 && $Page->ExportOptions->visible()) { ?>
<?php $Page->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($Page->ImportOptions->visible()) { ?>
<?php $Page->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($Page->SearchOptions->visible()) { ?>
<?php $Page->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($Page->FilterOptions->visible()) { ?>
<?php $Page->FilterOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
$Page->renderOtherOptions();
?>
<?php if (!$Page->isExport() && !$Page->CurrentAction) { ?>
<form name="ftreatment_bill2listsrch" id="ftreatment_bill2listsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="ftreatment_bill2listsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="treatment_bill2">
    <div class="ew-extended-search">
<div id="xsr_<?= $Page->SearchRowCount + 1 ?>" class="ew-row d-sm-flex">
    <div class="ew-quick-search input-group">
        <input type="text" name="<?= Config("TABLE_BASIC_SEARCH") ?>" id="<?= Config("TABLE_BASIC_SEARCH") ?>" class="form-control" value="<?= HtmlEncode($Page->BasicSearch->getKeyword()) ?>" placeholder="<?= HtmlEncode($Language->phrase("Search")) ?>">
        <input type="hidden" name="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" id="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" value="<?= HtmlEncode($Page->BasicSearch->getType()) ?>">
        <div class="input-group-append">
            <button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?= $Language->phrase("SearchBtn") ?></button>
            <button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false"><span id="searchtype"><?= $Page->BasicSearch->getTypeNameShort() ?></span></button>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item<?php if ($Page->BasicSearch->getType() == "") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this);"><?= $Language->phrase("QuickSearchAuto") ?></a>
                <a class="dropdown-item<?php if ($Page->BasicSearch->getType() == "=") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, '=');"><?= $Language->phrase("QuickSearchExact") ?></a>
                <a class="dropdown-item<?php if ($Page->BasicSearch->getType() == "AND") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'AND');"><?= $Language->phrase("QuickSearchAll") ?></a>
                <a class="dropdown-item<?php if ($Page->BasicSearch->getType() == "OR") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'OR');"><?= $Language->phrase("QuickSearchAny") ?></a>
            </div>
        </div>
    </div>
</div>
    </div><!-- /.ew-extended-search -->
</div><!-- /.ew-search-panel -->
</form>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<?php if ($Page->TotalRecords > 0 || $Page->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> treatment_bill2">
<?php if (!$Page->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if (!$Page->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?= CurrentPageUrl(false) ?>">
<?= $Page->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="ftreatment_bill2list" id="ftreatment_bill2list" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="treatment_bill2">
<div id="gmp_treatment_bill2" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_treatment_bill2list" class="table ew-table"><!-- .ew-table -->
<thead>
    <tr class="ew-table-header">
<?php
// Header row
$Page->RowType = ROWTYPE_HEADER;

// Render list options
$Page->renderListOptions();

// Render list options (header, left)
$Page->ListOptions->render("header", "left");
?>
<?php if ($Page->ORG_UNIT_CODE->Visible) { // ORG_UNIT_CODE ?>
        <th data-name="ORG_UNIT_CODE" class="<?= $Page->ORG_UNIT_CODE->headerCellClass() ?>"><div id="elh_treatment_bill2_ORG_UNIT_CODE" class="treatment_bill2_ORG_UNIT_CODE"><?= $Page->renderSort($Page->ORG_UNIT_CODE) ?></div></th>
<?php } ?>
<?php if ($Page->BILL_ID->Visible) { // BILL_ID ?>
        <th data-name="BILL_ID" class="<?= $Page->BILL_ID->headerCellClass() ?>"><div id="elh_treatment_bill2_BILL_ID" class="treatment_bill2_BILL_ID"><?= $Page->renderSort($Page->BILL_ID) ?></div></th>
<?php } ?>
<?php if ($Page->NO_REGISTRATION->Visible) { // NO_REGISTRATION ?>
        <th data-name="NO_REGISTRATION" class="<?= $Page->NO_REGISTRATION->headerCellClass() ?>"><div id="elh_treatment_bill2_NO_REGISTRATION" class="treatment_bill2_NO_REGISTRATION"><?= $Page->renderSort($Page->NO_REGISTRATION) ?></div></th>
<?php } ?>
<?php if ($Page->VISIT_ID->Visible) { // VISIT_ID ?>
        <th data-name="VISIT_ID" class="<?= $Page->VISIT_ID->headerCellClass() ?>"><div id="elh_treatment_bill2_VISIT_ID" class="treatment_bill2_VISIT_ID"><?= $Page->renderSort($Page->VISIT_ID) ?></div></th>
<?php } ?>
<?php if ($Page->TARIF_ID->Visible) { // TARIF_ID ?>
        <th data-name="TARIF_ID" class="<?= $Page->TARIF_ID->headerCellClass() ?>"><div id="elh_treatment_bill2_TARIF_ID" class="treatment_bill2_TARIF_ID"><?= $Page->renderSort($Page->TARIF_ID) ?></div></th>
<?php } ?>
<?php if ($Page->CLASS_ID->Visible) { // CLASS_ID ?>
        <th data-name="CLASS_ID" class="<?= $Page->CLASS_ID->headerCellClass() ?>"><div id="elh_treatment_bill2_CLASS_ID" class="treatment_bill2_CLASS_ID"><?= $Page->renderSort($Page->CLASS_ID) ?></div></th>
<?php } ?>
<?php if ($Page->CLINIC_ID->Visible) { // CLINIC_ID ?>
        <th data-name="CLINIC_ID" class="<?= $Page->CLINIC_ID->headerCellClass() ?>"><div id="elh_treatment_bill2_CLINIC_ID" class="treatment_bill2_CLINIC_ID"><?= $Page->renderSort($Page->CLINIC_ID) ?></div></th>
<?php } ?>
<?php if ($Page->CLINIC_ID_FROM->Visible) { // CLINIC_ID_FROM ?>
        <th data-name="CLINIC_ID_FROM" class="<?= $Page->CLINIC_ID_FROM->headerCellClass() ?>"><div id="elh_treatment_bill2_CLINIC_ID_FROM" class="treatment_bill2_CLINIC_ID_FROM"><?= $Page->renderSort($Page->CLINIC_ID_FROM) ?></div></th>
<?php } ?>
<?php if ($Page->TREATMENT->Visible) { // TREATMENT ?>
        <th data-name="TREATMENT" class="<?= $Page->TREATMENT->headerCellClass() ?>"><div id="elh_treatment_bill2_TREATMENT" class="treatment_bill2_TREATMENT"><?= $Page->renderSort($Page->TREATMENT) ?></div></th>
<?php } ?>
<?php if ($Page->TREAT_DATE->Visible) { // TREAT_DATE ?>
        <th data-name="TREAT_DATE" class="<?= $Page->TREAT_DATE->headerCellClass() ?>"><div id="elh_treatment_bill2_TREAT_DATE" class="treatment_bill2_TREAT_DATE"><?= $Page->renderSort($Page->TREAT_DATE) ?></div></th>
<?php } ?>
<?php if ($Page->AMOUNT->Visible) { // AMOUNT ?>
        <th data-name="AMOUNT" class="<?= $Page->AMOUNT->headerCellClass() ?>"><div id="elh_treatment_bill2_AMOUNT" class="treatment_bill2_AMOUNT"><?= $Page->renderSort($Page->AMOUNT) ?></div></th>
<?php } ?>
<?php if ($Page->QUANTITY->Visible) { // QUANTITY ?>
        <th data-name="QUANTITY" class="<?= $Page->QUANTITY->headerCellClass() ?>"><div id="elh_treatment_bill2_QUANTITY" class="treatment_bill2_QUANTITY"><?= $Page->renderSort($Page->QUANTITY) ?></div></th>
<?php } ?>
<?php if ($Page->MEASURE_ID->Visible) { // MEASURE_ID ?>
        <th data-name="MEASURE_ID" class="<?= $Page->MEASURE_ID->headerCellClass() ?>"><div id="elh_treatment_bill2_MEASURE_ID" class="treatment_bill2_MEASURE_ID"><?= $Page->renderSort($Page->MEASURE_ID) ?></div></th>
<?php } ?>
<?php if ($Page->POKOK_JUAL->Visible) { // POKOK_JUAL ?>
        <th data-name="POKOK_JUAL" class="<?= $Page->POKOK_JUAL->headerCellClass() ?>"><div id="elh_treatment_bill2_POKOK_JUAL" class="treatment_bill2_POKOK_JUAL"><?= $Page->renderSort($Page->POKOK_JUAL) ?></div></th>
<?php } ?>
<?php if ($Page->PPN->Visible) { // PPN ?>
        <th data-name="PPN" class="<?= $Page->PPN->headerCellClass() ?>"><div id="elh_treatment_bill2_PPN" class="treatment_bill2_PPN"><?= $Page->renderSort($Page->PPN) ?></div></th>
<?php } ?>
<?php if ($Page->MARGIN->Visible) { // MARGIN ?>
        <th data-name="MARGIN" class="<?= $Page->MARGIN->headerCellClass() ?>"><div id="elh_treatment_bill2_MARGIN" class="treatment_bill2_MARGIN"><?= $Page->renderSort($Page->MARGIN) ?></div></th>
<?php } ?>
<?php if ($Page->SUBSIDI->Visible) { // SUBSIDI ?>
        <th data-name="SUBSIDI" class="<?= $Page->SUBSIDI->headerCellClass() ?>"><div id="elh_treatment_bill2_SUBSIDI" class="treatment_bill2_SUBSIDI"><?= $Page->renderSort($Page->SUBSIDI) ?></div></th>
<?php } ?>
<?php if ($Page->EMBALACE->Visible) { // EMBALACE ?>
        <th data-name="EMBALACE" class="<?= $Page->EMBALACE->headerCellClass() ?>"><div id="elh_treatment_bill2_EMBALACE" class="treatment_bill2_EMBALACE"><?= $Page->renderSort($Page->EMBALACE) ?></div></th>
<?php } ?>
<?php if ($Page->PROFESI->Visible) { // PROFESI ?>
        <th data-name="PROFESI" class="<?= $Page->PROFESI->headerCellClass() ?>"><div id="elh_treatment_bill2_PROFESI" class="treatment_bill2_PROFESI"><?= $Page->renderSort($Page->PROFESI) ?></div></th>
<?php } ?>
<?php if ($Page->DISCOUNT->Visible) { // DISCOUNT ?>
        <th data-name="DISCOUNT" class="<?= $Page->DISCOUNT->headerCellClass() ?>"><div id="elh_treatment_bill2_DISCOUNT" class="treatment_bill2_DISCOUNT"><?= $Page->renderSort($Page->DISCOUNT) ?></div></th>
<?php } ?>
<?php if ($Page->PAY_METHOD_ID->Visible) { // PAY_METHOD_ID ?>
        <th data-name="PAY_METHOD_ID" class="<?= $Page->PAY_METHOD_ID->headerCellClass() ?>"><div id="elh_treatment_bill2_PAY_METHOD_ID" class="treatment_bill2_PAY_METHOD_ID"><?= $Page->renderSort($Page->PAY_METHOD_ID) ?></div></th>
<?php } ?>
<?php if ($Page->PAYMENT_DATE->Visible) { // PAYMENT_DATE ?>
        <th data-name="PAYMENT_DATE" class="<?= $Page->PAYMENT_DATE->headerCellClass() ?>"><div id="elh_treatment_bill2_PAYMENT_DATE" class="treatment_bill2_PAYMENT_DATE"><?= $Page->renderSort($Page->PAYMENT_DATE) ?></div></th>
<?php } ?>
<?php if ($Page->ISLUNAS->Visible) { // ISLUNAS ?>
        <th data-name="ISLUNAS" class="<?= $Page->ISLUNAS->headerCellClass() ?>"><div id="elh_treatment_bill2_ISLUNAS" class="treatment_bill2_ISLUNAS"><?= $Page->renderSort($Page->ISLUNAS) ?></div></th>
<?php } ?>
<?php if ($Page->DUEDATE_ANGSURAN->Visible) { // DUEDATE_ANGSURAN ?>
        <th data-name="DUEDATE_ANGSURAN" class="<?= $Page->DUEDATE_ANGSURAN->headerCellClass() ?>"><div id="elh_treatment_bill2_DUEDATE_ANGSURAN" class="treatment_bill2_DUEDATE_ANGSURAN"><?= $Page->renderSort($Page->DUEDATE_ANGSURAN) ?></div></th>
<?php } ?>
<?php if ($Page->DESCRIPTION->Visible) { // DESCRIPTION ?>
        <th data-name="DESCRIPTION" class="<?= $Page->DESCRIPTION->headerCellClass() ?>"><div id="elh_treatment_bill2_DESCRIPTION" class="treatment_bill2_DESCRIPTION"><?= $Page->renderSort($Page->DESCRIPTION) ?></div></th>
<?php } ?>
<?php if ($Page->KUITANSI_ID->Visible) { // KUITANSI_ID ?>
        <th data-name="KUITANSI_ID" class="<?= $Page->KUITANSI_ID->headerCellClass() ?>"><div id="elh_treatment_bill2_KUITANSI_ID" class="treatment_bill2_KUITANSI_ID"><?= $Page->renderSort($Page->KUITANSI_ID) ?></div></th>
<?php } ?>
<?php if ($Page->NOTA_NO->Visible) { // NOTA_NO ?>
        <th data-name="NOTA_NO" class="<?= $Page->NOTA_NO->headerCellClass() ?>"><div id="elh_treatment_bill2_NOTA_NO" class="treatment_bill2_NOTA_NO"><?= $Page->renderSort($Page->NOTA_NO) ?></div></th>
<?php } ?>
<?php if ($Page->ISCETAK->Visible) { // ISCETAK ?>
        <th data-name="ISCETAK" class="<?= $Page->ISCETAK->headerCellClass() ?>"><div id="elh_treatment_bill2_ISCETAK" class="treatment_bill2_ISCETAK"><?= $Page->renderSort($Page->ISCETAK) ?></div></th>
<?php } ?>
<?php if ($Page->PRINT_DATE->Visible) { // PRINT_DATE ?>
        <th data-name="PRINT_DATE" class="<?= $Page->PRINT_DATE->headerCellClass() ?>"><div id="elh_treatment_bill2_PRINT_DATE" class="treatment_bill2_PRINT_DATE"><?= $Page->renderSort($Page->PRINT_DATE) ?></div></th>
<?php } ?>
<?php if ($Page->RESEP_NO->Visible) { // RESEP_NO ?>
        <th data-name="RESEP_NO" class="<?= $Page->RESEP_NO->headerCellClass() ?>"><div id="elh_treatment_bill2_RESEP_NO" class="treatment_bill2_RESEP_NO"><?= $Page->renderSort($Page->RESEP_NO) ?></div></th>
<?php } ?>
<?php if ($Page->RESEP_KE->Visible) { // RESEP_KE ?>
        <th data-name="RESEP_KE" class="<?= $Page->RESEP_KE->headerCellClass() ?>"><div id="elh_treatment_bill2_RESEP_KE" class="treatment_bill2_RESEP_KE"><?= $Page->renderSort($Page->RESEP_KE) ?></div></th>
<?php } ?>
<?php if ($Page->DOSE->Visible) { // DOSE ?>
        <th data-name="DOSE" class="<?= $Page->DOSE->headerCellClass() ?>"><div id="elh_treatment_bill2_DOSE" class="treatment_bill2_DOSE"><?= $Page->renderSort($Page->DOSE) ?></div></th>
<?php } ?>
<?php if ($Page->ORIG_DOSE->Visible) { // ORIG_DOSE ?>
        <th data-name="ORIG_DOSE" class="<?= $Page->ORIG_DOSE->headerCellClass() ?>"><div id="elh_treatment_bill2_ORIG_DOSE" class="treatment_bill2_ORIG_DOSE"><?= $Page->renderSort($Page->ORIG_DOSE) ?></div></th>
<?php } ?>
<?php if ($Page->DOSE_PRESC->Visible) { // DOSE_PRESC ?>
        <th data-name="DOSE_PRESC" class="<?= $Page->DOSE_PRESC->headerCellClass() ?>"><div id="elh_treatment_bill2_DOSE_PRESC" class="treatment_bill2_DOSE_PRESC"><?= $Page->renderSort($Page->DOSE_PRESC) ?></div></th>
<?php } ?>
<?php if ($Page->ITER->Visible) { // ITER ?>
        <th data-name="ITER" class="<?= $Page->ITER->headerCellClass() ?>"><div id="elh_treatment_bill2_ITER" class="treatment_bill2_ITER"><?= $Page->renderSort($Page->ITER) ?></div></th>
<?php } ?>
<?php if ($Page->ITER_KE->Visible) { // ITER_KE ?>
        <th data-name="ITER_KE" class="<?= $Page->ITER_KE->headerCellClass() ?>"><div id="elh_treatment_bill2_ITER_KE" class="treatment_bill2_ITER_KE"><?= $Page->renderSort($Page->ITER_KE) ?></div></th>
<?php } ?>
<?php if ($Page->SOLD_STATUS->Visible) { // SOLD_STATUS ?>
        <th data-name="SOLD_STATUS" class="<?= $Page->SOLD_STATUS->headerCellClass() ?>"><div id="elh_treatment_bill2_SOLD_STATUS" class="treatment_bill2_SOLD_STATUS"><?= $Page->renderSort($Page->SOLD_STATUS) ?></div></th>
<?php } ?>
<?php if ($Page->RACIKAN->Visible) { // RACIKAN ?>
        <th data-name="RACIKAN" class="<?= $Page->RACIKAN->headerCellClass() ?>"><div id="elh_treatment_bill2_RACIKAN" class="treatment_bill2_RACIKAN"><?= $Page->renderSort($Page->RACIKAN) ?></div></th>
<?php } ?>
<?php if ($Page->CLASS_ROOM_ID->Visible) { // CLASS_ROOM_ID ?>
        <th data-name="CLASS_ROOM_ID" class="<?= $Page->CLASS_ROOM_ID->headerCellClass() ?>"><div id="elh_treatment_bill2_CLASS_ROOM_ID" class="treatment_bill2_CLASS_ROOM_ID"><?= $Page->renderSort($Page->CLASS_ROOM_ID) ?></div></th>
<?php } ?>
<?php if ($Page->KELUAR_ID->Visible) { // KELUAR_ID ?>
        <th data-name="KELUAR_ID" class="<?= $Page->KELUAR_ID->headerCellClass() ?>"><div id="elh_treatment_bill2_KELUAR_ID" class="treatment_bill2_KELUAR_ID"><?= $Page->renderSort($Page->KELUAR_ID) ?></div></th>
<?php } ?>
<?php if ($Page->BED_ID->Visible) { // BED_ID ?>
        <th data-name="BED_ID" class="<?= $Page->BED_ID->headerCellClass() ?>"><div id="elh_treatment_bill2_BED_ID" class="treatment_bill2_BED_ID"><?= $Page->renderSort($Page->BED_ID) ?></div></th>
<?php } ?>
<?php if ($Page->PERDA_ID->Visible) { // PERDA_ID ?>
        <th data-name="PERDA_ID" class="<?= $Page->PERDA_ID->headerCellClass() ?>"><div id="elh_treatment_bill2_PERDA_ID" class="treatment_bill2_PERDA_ID"><?= $Page->renderSort($Page->PERDA_ID) ?></div></th>
<?php } ?>
<?php if ($Page->EMPLOYEE_ID->Visible) { // EMPLOYEE_ID ?>
        <th data-name="EMPLOYEE_ID" class="<?= $Page->EMPLOYEE_ID->headerCellClass() ?>"><div id="elh_treatment_bill2_EMPLOYEE_ID" class="treatment_bill2_EMPLOYEE_ID"><?= $Page->renderSort($Page->EMPLOYEE_ID) ?></div></th>
<?php } ?>
<?php if ($Page->DESCRIPTION2->Visible) { // DESCRIPTION2 ?>
        <th data-name="DESCRIPTION2" class="<?= $Page->DESCRIPTION2->headerCellClass() ?>"><div id="elh_treatment_bill2_DESCRIPTION2" class="treatment_bill2_DESCRIPTION2"><?= $Page->renderSort($Page->DESCRIPTION2) ?></div></th>
<?php } ?>
<?php if ($Page->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
        <th data-name="MODIFIED_BY" class="<?= $Page->MODIFIED_BY->headerCellClass() ?>"><div id="elh_treatment_bill2_MODIFIED_BY" class="treatment_bill2_MODIFIED_BY"><?= $Page->renderSort($Page->MODIFIED_BY) ?></div></th>
<?php } ?>
<?php if ($Page->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
        <th data-name="MODIFIED_DATE" class="<?= $Page->MODIFIED_DATE->headerCellClass() ?>"><div id="elh_treatment_bill2_MODIFIED_DATE" class="treatment_bill2_MODIFIED_DATE"><?= $Page->renderSort($Page->MODIFIED_DATE) ?></div></th>
<?php } ?>
<?php if ($Page->MODIFIED_FROM->Visible) { // MODIFIED_FROM ?>
        <th data-name="MODIFIED_FROM" class="<?= $Page->MODIFIED_FROM->headerCellClass() ?>"><div id="elh_treatment_bill2_MODIFIED_FROM" class="treatment_bill2_MODIFIED_FROM"><?= $Page->renderSort($Page->MODIFIED_FROM) ?></div></th>
<?php } ?>
<?php if ($Page->BRAND_ID->Visible) { // BRAND_ID ?>
        <th data-name="BRAND_ID" class="<?= $Page->BRAND_ID->headerCellClass() ?>"><div id="elh_treatment_bill2_BRAND_ID" class="treatment_bill2_BRAND_ID"><?= $Page->renderSort($Page->BRAND_ID) ?></div></th>
<?php } ?>
<?php if ($Page->DOCTOR->Visible) { // DOCTOR ?>
        <th data-name="DOCTOR" class="<?= $Page->DOCTOR->headerCellClass() ?>"><div id="elh_treatment_bill2_DOCTOR" class="treatment_bill2_DOCTOR"><?= $Page->renderSort($Page->DOCTOR) ?></div></th>
<?php } ?>
<?php if ($Page->JML_BKS->Visible) { // JML_BKS ?>
        <th data-name="JML_BKS" class="<?= $Page->JML_BKS->headerCellClass() ?>"><div id="elh_treatment_bill2_JML_BKS" class="treatment_bill2_JML_BKS"><?= $Page->renderSort($Page->JML_BKS) ?></div></th>
<?php } ?>
<?php if ($Page->EXIT_DATE->Visible) { // EXIT_DATE ?>
        <th data-name="EXIT_DATE" class="<?= $Page->EXIT_DATE->headerCellClass() ?>"><div id="elh_treatment_bill2_EXIT_DATE" class="treatment_bill2_EXIT_DATE"><?= $Page->renderSort($Page->EXIT_DATE) ?></div></th>
<?php } ?>
<?php if ($Page->FA_V->Visible) { // FA_V ?>
        <th data-name="FA_V" class="<?= $Page->FA_V->headerCellClass() ?>"><div id="elh_treatment_bill2_FA_V" class="treatment_bill2_FA_V"><?= $Page->renderSort($Page->FA_V) ?></div></th>
<?php } ?>
<?php if ($Page->TASK_ID->Visible) { // TASK_ID ?>
        <th data-name="TASK_ID" class="<?= $Page->TASK_ID->headerCellClass() ?>"><div id="elh_treatment_bill2_TASK_ID" class="treatment_bill2_TASK_ID"><?= $Page->renderSort($Page->TASK_ID) ?></div></th>
<?php } ?>
<?php if ($Page->EMPLOYEE_ID_FROM->Visible) { // EMPLOYEE_ID_FROM ?>
        <th data-name="EMPLOYEE_ID_FROM" class="<?= $Page->EMPLOYEE_ID_FROM->headerCellClass() ?>"><div id="elh_treatment_bill2_EMPLOYEE_ID_FROM" class="treatment_bill2_EMPLOYEE_ID_FROM"><?= $Page->renderSort($Page->EMPLOYEE_ID_FROM) ?></div></th>
<?php } ?>
<?php if ($Page->DOCTOR_FROM->Visible) { // DOCTOR_FROM ?>
        <th data-name="DOCTOR_FROM" class="<?= $Page->DOCTOR_FROM->headerCellClass() ?>"><div id="elh_treatment_bill2_DOCTOR_FROM" class="treatment_bill2_DOCTOR_FROM"><?= $Page->renderSort($Page->DOCTOR_FROM) ?></div></th>
<?php } ?>
<?php if ($Page->status_pasien_id->Visible) { // status_pasien_id ?>
        <th data-name="status_pasien_id" class="<?= $Page->status_pasien_id->headerCellClass() ?>"><div id="elh_treatment_bill2_status_pasien_id" class="treatment_bill2_status_pasien_id"><?= $Page->renderSort($Page->status_pasien_id) ?></div></th>
<?php } ?>
<?php if ($Page->amount_paid->Visible) { // amount_paid ?>
        <th data-name="amount_paid" class="<?= $Page->amount_paid->headerCellClass() ?>"><div id="elh_treatment_bill2_amount_paid" class="treatment_bill2_amount_paid"><?= $Page->renderSort($Page->amount_paid) ?></div></th>
<?php } ?>
<?php if ($Page->THENAME->Visible) { // THENAME ?>
        <th data-name="THENAME" class="<?= $Page->THENAME->headerCellClass() ?>"><div id="elh_treatment_bill2_THENAME" class="treatment_bill2_THENAME"><?= $Page->renderSort($Page->THENAME) ?></div></th>
<?php } ?>
<?php if ($Page->THEADDRESS->Visible) { // THEADDRESS ?>
        <th data-name="THEADDRESS" class="<?= $Page->THEADDRESS->headerCellClass() ?>"><div id="elh_treatment_bill2_THEADDRESS" class="treatment_bill2_THEADDRESS"><?= $Page->renderSort($Page->THEADDRESS) ?></div></th>
<?php } ?>
<?php if ($Page->THEID->Visible) { // THEID ?>
        <th data-name="THEID" class="<?= $Page->THEID->headerCellClass() ?>"><div id="elh_treatment_bill2_THEID" class="treatment_bill2_THEID"><?= $Page->renderSort($Page->THEID) ?></div></th>
<?php } ?>
<?php if ($Page->serial_nb->Visible) { // serial_nb ?>
        <th data-name="serial_nb" class="<?= $Page->serial_nb->headerCellClass() ?>"><div id="elh_treatment_bill2_serial_nb" class="treatment_bill2_serial_nb"><?= $Page->renderSort($Page->serial_nb) ?></div></th>
<?php } ?>
<?php if ($Page->TREATMENT_PLAFOND->Visible) { // TREATMENT_PLAFOND ?>
        <th data-name="TREATMENT_PLAFOND" class="<?= $Page->TREATMENT_PLAFOND->headerCellClass() ?>"><div id="elh_treatment_bill2_TREATMENT_PLAFOND" class="treatment_bill2_TREATMENT_PLAFOND"><?= $Page->renderSort($Page->TREATMENT_PLAFOND) ?></div></th>
<?php } ?>
<?php if ($Page->AMOUNT_PLAFOND->Visible) { // AMOUNT_PLAFOND ?>
        <th data-name="AMOUNT_PLAFOND" class="<?= $Page->AMOUNT_PLAFOND->headerCellClass() ?>"><div id="elh_treatment_bill2_AMOUNT_PLAFOND" class="treatment_bill2_AMOUNT_PLAFOND"><?= $Page->renderSort($Page->AMOUNT_PLAFOND) ?></div></th>
<?php } ?>
<?php if ($Page->AMOUNT_PAID_PLAFOND->Visible) { // AMOUNT_PAID_PLAFOND ?>
        <th data-name="AMOUNT_PAID_PLAFOND" class="<?= $Page->AMOUNT_PAID_PLAFOND->headerCellClass() ?>"><div id="elh_treatment_bill2_AMOUNT_PAID_PLAFOND" class="treatment_bill2_AMOUNT_PAID_PLAFOND"><?= $Page->renderSort($Page->AMOUNT_PAID_PLAFOND) ?></div></th>
<?php } ?>
<?php if ($Page->CLASS_ID_PLAFOND->Visible) { // CLASS_ID_PLAFOND ?>
        <th data-name="CLASS_ID_PLAFOND" class="<?= $Page->CLASS_ID_PLAFOND->headerCellClass() ?>"><div id="elh_treatment_bill2_CLASS_ID_PLAFOND" class="treatment_bill2_CLASS_ID_PLAFOND"><?= $Page->renderSort($Page->CLASS_ID_PLAFOND) ?></div></th>
<?php } ?>
<?php if ($Page->PAYOR_ID->Visible) { // PAYOR_ID ?>
        <th data-name="PAYOR_ID" class="<?= $Page->PAYOR_ID->headerCellClass() ?>"><div id="elh_treatment_bill2_PAYOR_ID" class="treatment_bill2_PAYOR_ID"><?= $Page->renderSort($Page->PAYOR_ID) ?></div></th>
<?php } ?>
<?php if ($Page->PEMBULATAN->Visible) { // PEMBULATAN ?>
        <th data-name="PEMBULATAN" class="<?= $Page->PEMBULATAN->headerCellClass() ?>"><div id="elh_treatment_bill2_PEMBULATAN" class="treatment_bill2_PEMBULATAN"><?= $Page->renderSort($Page->PEMBULATAN) ?></div></th>
<?php } ?>
<?php if ($Page->ISRJ->Visible) { // ISRJ ?>
        <th data-name="ISRJ" class="<?= $Page->ISRJ->headerCellClass() ?>"><div id="elh_treatment_bill2_ISRJ" class="treatment_bill2_ISRJ"><?= $Page->renderSort($Page->ISRJ) ?></div></th>
<?php } ?>
<?php if ($Page->AGEYEAR->Visible) { // AGEYEAR ?>
        <th data-name="AGEYEAR" class="<?= $Page->AGEYEAR->headerCellClass() ?>"><div id="elh_treatment_bill2_AGEYEAR" class="treatment_bill2_AGEYEAR"><?= $Page->renderSort($Page->AGEYEAR) ?></div></th>
<?php } ?>
<?php if ($Page->AGEMONTH->Visible) { // AGEMONTH ?>
        <th data-name="AGEMONTH" class="<?= $Page->AGEMONTH->headerCellClass() ?>"><div id="elh_treatment_bill2_AGEMONTH" class="treatment_bill2_AGEMONTH"><?= $Page->renderSort($Page->AGEMONTH) ?></div></th>
<?php } ?>
<?php if ($Page->AGEDAY->Visible) { // AGEDAY ?>
        <th data-name="AGEDAY" class="<?= $Page->AGEDAY->headerCellClass() ?>"><div id="elh_treatment_bill2_AGEDAY" class="treatment_bill2_AGEDAY"><?= $Page->renderSort($Page->AGEDAY) ?></div></th>
<?php } ?>
<?php if ($Page->GENDER->Visible) { // GENDER ?>
        <th data-name="GENDER" class="<?= $Page->GENDER->headerCellClass() ?>"><div id="elh_treatment_bill2_GENDER" class="treatment_bill2_GENDER"><?= $Page->renderSort($Page->GENDER) ?></div></th>
<?php } ?>
<?php if ($Page->KAL_ID->Visible) { // KAL_ID ?>
        <th data-name="KAL_ID" class="<?= $Page->KAL_ID->headerCellClass() ?>"><div id="elh_treatment_bill2_KAL_ID" class="treatment_bill2_KAL_ID"><?= $Page->renderSort($Page->KAL_ID) ?></div></th>
<?php } ?>
<?php if ($Page->CORRECTION_ID->Visible) { // CORRECTION_ID ?>
        <th data-name="CORRECTION_ID" class="<?= $Page->CORRECTION_ID->headerCellClass() ?>"><div id="elh_treatment_bill2_CORRECTION_ID" class="treatment_bill2_CORRECTION_ID"><?= $Page->renderSort($Page->CORRECTION_ID) ?></div></th>
<?php } ?>
<?php if ($Page->CORRECTION_BY->Visible) { // CORRECTION_BY ?>
        <th data-name="CORRECTION_BY" class="<?= $Page->CORRECTION_BY->headerCellClass() ?>"><div id="elh_treatment_bill2_CORRECTION_BY" class="treatment_bill2_CORRECTION_BY"><?= $Page->renderSort($Page->CORRECTION_BY) ?></div></th>
<?php } ?>
<?php if ($Page->KARYAWAN->Visible) { // KARYAWAN ?>
        <th data-name="KARYAWAN" class="<?= $Page->KARYAWAN->headerCellClass() ?>"><div id="elh_treatment_bill2_KARYAWAN" class="treatment_bill2_KARYAWAN"><?= $Page->renderSort($Page->KARYAWAN) ?></div></th>
<?php } ?>
<?php if ($Page->ACCOUNT_ID->Visible) { // ACCOUNT_ID ?>
        <th data-name="ACCOUNT_ID" class="<?= $Page->ACCOUNT_ID->headerCellClass() ?>"><div id="elh_treatment_bill2_ACCOUNT_ID" class="treatment_bill2_ACCOUNT_ID"><?= $Page->renderSort($Page->ACCOUNT_ID) ?></div></th>
<?php } ?>
<?php if ($Page->sell_price->Visible) { // sell_price ?>
        <th data-name="sell_price" class="<?= $Page->sell_price->headerCellClass() ?>"><div id="elh_treatment_bill2_sell_price" class="treatment_bill2_sell_price"><?= $Page->renderSort($Page->sell_price) ?></div></th>
<?php } ?>
<?php if ($Page->diskon->Visible) { // diskon ?>
        <th data-name="diskon" class="<?= $Page->diskon->headerCellClass() ?>"><div id="elh_treatment_bill2_diskon" class="treatment_bill2_diskon"><?= $Page->renderSort($Page->diskon) ?></div></th>
<?php } ?>
<?php if ($Page->INVOICE_ID->Visible) { // INVOICE_ID ?>
        <th data-name="INVOICE_ID" class="<?= $Page->INVOICE_ID->headerCellClass() ?>"><div id="elh_treatment_bill2_INVOICE_ID" class="treatment_bill2_INVOICE_ID"><?= $Page->renderSort($Page->INVOICE_ID) ?></div></th>
<?php } ?>
<?php if ($Page->NUMER->Visible) { // NUMER ?>
        <th data-name="NUMER" class="<?= $Page->NUMER->headerCellClass() ?>"><div id="elh_treatment_bill2_NUMER" class="treatment_bill2_NUMER"><?= $Page->renderSort($Page->NUMER) ?></div></th>
<?php } ?>
<?php if ($Page->MEASURE_ID2->Visible) { // MEASURE_ID2 ?>
        <th data-name="MEASURE_ID2" class="<?= $Page->MEASURE_ID2->headerCellClass() ?>"><div id="elh_treatment_bill2_MEASURE_ID2" class="treatment_bill2_MEASURE_ID2"><?= $Page->renderSort($Page->MEASURE_ID2) ?></div></th>
<?php } ?>
<?php if ($Page->POTONGAN->Visible) { // POTONGAN ?>
        <th data-name="POTONGAN" class="<?= $Page->POTONGAN->headerCellClass() ?>"><div id="elh_treatment_bill2_POTONGAN" class="treatment_bill2_POTONGAN"><?= $Page->renderSort($Page->POTONGAN) ?></div></th>
<?php } ?>
<?php if ($Page->BAYAR->Visible) { // BAYAR ?>
        <th data-name="BAYAR" class="<?= $Page->BAYAR->headerCellClass() ?>"><div id="elh_treatment_bill2_BAYAR" class="treatment_bill2_BAYAR"><?= $Page->renderSort($Page->BAYAR) ?></div></th>
<?php } ?>
<?php if ($Page->RETUR->Visible) { // RETUR ?>
        <th data-name="RETUR" class="<?= $Page->RETUR->headerCellClass() ?>"><div id="elh_treatment_bill2_RETUR" class="treatment_bill2_RETUR"><?= $Page->renderSort($Page->RETUR) ?></div></th>
<?php } ?>
<?php if ($Page->TARIF_TYPE->Visible) { // TARIF_TYPE ?>
        <th data-name="TARIF_TYPE" class="<?= $Page->TARIF_TYPE->headerCellClass() ?>"><div id="elh_treatment_bill2_TARIF_TYPE" class="treatment_bill2_TARIF_TYPE"><?= $Page->renderSort($Page->TARIF_TYPE) ?></div></th>
<?php } ?>
<?php if ($Page->PPNVALUE->Visible) { // PPNVALUE ?>
        <th data-name="PPNVALUE" class="<?= $Page->PPNVALUE->headerCellClass() ?>"><div id="elh_treatment_bill2_PPNVALUE" class="treatment_bill2_PPNVALUE"><?= $Page->renderSort($Page->PPNVALUE) ?></div></th>
<?php } ?>
<?php if ($Page->TAGIHAN->Visible) { // TAGIHAN ?>
        <th data-name="TAGIHAN" class="<?= $Page->TAGIHAN->headerCellClass() ?>"><div id="elh_treatment_bill2_TAGIHAN" class="treatment_bill2_TAGIHAN"><?= $Page->renderSort($Page->TAGIHAN) ?></div></th>
<?php } ?>
<?php if ($Page->KOREKSI->Visible) { // KOREKSI ?>
        <th data-name="KOREKSI" class="<?= $Page->KOREKSI->headerCellClass() ?>"><div id="elh_treatment_bill2_KOREKSI" class="treatment_bill2_KOREKSI"><?= $Page->renderSort($Page->KOREKSI) ?></div></th>
<?php } ?>
<?php if ($Page->STATUS_OBAT->Visible) { // STATUS_OBAT ?>
        <th data-name="STATUS_OBAT" class="<?= $Page->STATUS_OBAT->headerCellClass() ?>"><div id="elh_treatment_bill2_STATUS_OBAT" class="treatment_bill2_STATUS_OBAT"><?= $Page->renderSort($Page->STATUS_OBAT) ?></div></th>
<?php } ?>
<?php if ($Page->SUBSIDISAT->Visible) { // SUBSIDISAT ?>
        <th data-name="SUBSIDISAT" class="<?= $Page->SUBSIDISAT->headerCellClass() ?>"><div id="elh_treatment_bill2_SUBSIDISAT" class="treatment_bill2_SUBSIDISAT"><?= $Page->renderSort($Page->SUBSIDISAT) ?></div></th>
<?php } ?>
<?php if ($Page->PRINTQ->Visible) { // PRINTQ ?>
        <th data-name="PRINTQ" class="<?= $Page->PRINTQ->headerCellClass() ?>"><div id="elh_treatment_bill2_PRINTQ" class="treatment_bill2_PRINTQ"><?= $Page->renderSort($Page->PRINTQ) ?></div></th>
<?php } ?>
<?php if ($Page->PRINTED_BY->Visible) { // PRINTED_BY ?>
        <th data-name="PRINTED_BY" class="<?= $Page->PRINTED_BY->headerCellClass() ?>"><div id="elh_treatment_bill2_PRINTED_BY" class="treatment_bill2_PRINTED_BY"><?= $Page->renderSort($Page->PRINTED_BY) ?></div></th>
<?php } ?>
<?php if ($Page->STOCK_AVAILABLE->Visible) { // STOCK_AVAILABLE ?>
        <th data-name="STOCK_AVAILABLE" class="<?= $Page->STOCK_AVAILABLE->headerCellClass() ?>"><div id="elh_treatment_bill2_STOCK_AVAILABLE" class="treatment_bill2_STOCK_AVAILABLE"><?= $Page->renderSort($Page->STOCK_AVAILABLE) ?></div></th>
<?php } ?>
<?php if ($Page->STATUS_TARIF->Visible) { // STATUS_TARIF ?>
        <th data-name="STATUS_TARIF" class="<?= $Page->STATUS_TARIF->headerCellClass() ?>"><div id="elh_treatment_bill2_STATUS_TARIF" class="treatment_bill2_STATUS_TARIF"><?= $Page->renderSort($Page->STATUS_TARIF) ?></div></th>
<?php } ?>
<?php if ($Page->CLINIC_TYPE->Visible) { // CLINIC_TYPE ?>
        <th data-name="CLINIC_TYPE" class="<?= $Page->CLINIC_TYPE->headerCellClass() ?>"><div id="elh_treatment_bill2_CLINIC_TYPE" class="treatment_bill2_CLINIC_TYPE"><?= $Page->renderSort($Page->CLINIC_TYPE) ?></div></th>
<?php } ?>
<?php if ($Page->PACKAGE_ID->Visible) { // PACKAGE_ID ?>
        <th data-name="PACKAGE_ID" class="<?= $Page->PACKAGE_ID->headerCellClass() ?>"><div id="elh_treatment_bill2_PACKAGE_ID" class="treatment_bill2_PACKAGE_ID"><?= $Page->renderSort($Page->PACKAGE_ID) ?></div></th>
<?php } ?>
<?php if ($Page->MODULE_ID->Visible) { // MODULE_ID ?>
        <th data-name="MODULE_ID" class="<?= $Page->MODULE_ID->headerCellClass() ?>"><div id="elh_treatment_bill2_MODULE_ID" class="treatment_bill2_MODULE_ID"><?= $Page->renderSort($Page->MODULE_ID) ?></div></th>
<?php } ?>
<?php if ($Page->profession->Visible) { // profession ?>
        <th data-name="profession" class="<?= $Page->profession->headerCellClass() ?>"><div id="elh_treatment_bill2_profession" class="treatment_bill2_profession"><?= $Page->renderSort($Page->profession) ?></div></th>
<?php } ?>
<?php if ($Page->THEORDER->Visible) { // THEORDER ?>
        <th data-name="THEORDER" class="<?= $Page->THEORDER->headerCellClass() ?>"><div id="elh_treatment_bill2_THEORDER" class="treatment_bill2_THEORDER"><?= $Page->renderSort($Page->THEORDER) ?></div></th>
<?php } ?>
<?php if ($Page->CASHIER->Visible) { // CASHIER ?>
        <th data-name="CASHIER" class="<?= $Page->CASHIER->headerCellClass() ?>"><div id="elh_treatment_bill2_CASHIER" class="treatment_bill2_CASHIER"><?= $Page->renderSort($Page->CASHIER) ?></div></th>
<?php } ?>
<?php
// Render list options (header, right)
$Page->ListOptions->render("header", "right");
?>
    </tr>
</thead>
<tbody>
<?php
if ($Page->ExportAll && $Page->isExport()) {
    $Page->StopRecord = $Page->TotalRecords;
} else {
    // Set the last record to display
    if ($Page->TotalRecords > $Page->StartRecord + $Page->DisplayRecords - 1) {
        $Page->StopRecord = $Page->StartRecord + $Page->DisplayRecords - 1;
    } else {
        $Page->StopRecord = $Page->TotalRecords;
    }
}
$Page->RecordCount = $Page->StartRecord - 1;
if ($Page->Recordset && !$Page->Recordset->EOF) {
    // Nothing to do
} elseif (!$Page->AllowAddDeleteRow && $Page->StopRecord == 0) {
    $Page->StopRecord = $Page->GridAddRowCount;
}

// Initialize aggregate
$Page->RowType = ROWTYPE_AGGREGATEINIT;
$Page->resetAttributes();
$Page->renderRow();
while ($Page->RecordCount < $Page->StopRecord) {
    $Page->RecordCount++;
    if ($Page->RecordCount >= $Page->StartRecord) {
        $Page->RowCount++;

        // Set up key count
        $Page->KeyCount = $Page->RowIndex;

        // Init row class and style
        $Page->resetAttributes();
        $Page->CssClass = "";
        if ($Page->isGridAdd()) {
            $Page->loadRowValues(); // Load default values
            $Page->OldKey = "";
            $Page->setKey($Page->OldKey);
        } else {
            $Page->loadRowValues($Page->Recordset); // Load row values
            if ($Page->isGridEdit()) {
                $Page->OldKey = $Page->getKey(true); // Get from CurrentValue
                $Page->setKey($Page->OldKey);
            }
        }
        $Page->RowType = ROWTYPE_VIEW; // Render view

        // Set up row id / data-rowindex
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_treatment_bill2", "data-rowtype" => $Page->RowType]);

        // Render row
        $Page->renderRow();

        // Render list options
        $Page->renderListOptions();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount);
?>
    <?php if ($Page->ORG_UNIT_CODE->Visible) { // ORG_UNIT_CODE ?>
        <td data-name="ORG_UNIT_CODE" <?= $Page->ORG_UNIT_CODE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_ORG_UNIT_CODE">
<span<?= $Page->ORG_UNIT_CODE->viewAttributes() ?>>
<?= $Page->ORG_UNIT_CODE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->BILL_ID->Visible) { // BILL_ID ?>
        <td data-name="BILL_ID" <?= $Page->BILL_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_BILL_ID">
<span<?= $Page->BILL_ID->viewAttributes() ?>>
<?= $Page->BILL_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->NO_REGISTRATION->Visible) { // NO_REGISTRATION ?>
        <td data-name="NO_REGISTRATION" <?= $Page->NO_REGISTRATION->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_NO_REGISTRATION">
<span<?= $Page->NO_REGISTRATION->viewAttributes() ?>>
<?= $Page->NO_REGISTRATION->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->VISIT_ID->Visible) { // VISIT_ID ?>
        <td data-name="VISIT_ID" <?= $Page->VISIT_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_VISIT_ID">
<span<?= $Page->VISIT_ID->viewAttributes() ?>>
<?= $Page->VISIT_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->TARIF_ID->Visible) { // TARIF_ID ?>
        <td data-name="TARIF_ID" <?= $Page->TARIF_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_TARIF_ID">
<span<?= $Page->TARIF_ID->viewAttributes() ?>>
<?= $Page->TARIF_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->CLASS_ID->Visible) { // CLASS_ID ?>
        <td data-name="CLASS_ID" <?= $Page->CLASS_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_CLASS_ID">
<span<?= $Page->CLASS_ID->viewAttributes() ?>>
<?= $Page->CLASS_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->CLINIC_ID->Visible) { // CLINIC_ID ?>
        <td data-name="CLINIC_ID" <?= $Page->CLINIC_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_CLINIC_ID">
<span<?= $Page->CLINIC_ID->viewAttributes() ?>>
<?= $Page->CLINIC_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->CLINIC_ID_FROM->Visible) { // CLINIC_ID_FROM ?>
        <td data-name="CLINIC_ID_FROM" <?= $Page->CLINIC_ID_FROM->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_CLINIC_ID_FROM">
<span<?= $Page->CLINIC_ID_FROM->viewAttributes() ?>>
<?= $Page->CLINIC_ID_FROM->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->TREATMENT->Visible) { // TREATMENT ?>
        <td data-name="TREATMENT" <?= $Page->TREATMENT->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_TREATMENT">
<span<?= $Page->TREATMENT->viewAttributes() ?>>
<?= $Page->TREATMENT->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->TREAT_DATE->Visible) { // TREAT_DATE ?>
        <td data-name="TREAT_DATE" <?= $Page->TREAT_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_TREAT_DATE">
<span<?= $Page->TREAT_DATE->viewAttributes() ?>>
<?= $Page->TREAT_DATE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->AMOUNT->Visible) { // AMOUNT ?>
        <td data-name="AMOUNT" <?= $Page->AMOUNT->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_AMOUNT">
<span<?= $Page->AMOUNT->viewAttributes() ?>>
<?= $Page->AMOUNT->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->QUANTITY->Visible) { // QUANTITY ?>
        <td data-name="QUANTITY" <?= $Page->QUANTITY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_QUANTITY">
<span<?= $Page->QUANTITY->viewAttributes() ?>>
<?= $Page->QUANTITY->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->MEASURE_ID->Visible) { // MEASURE_ID ?>
        <td data-name="MEASURE_ID" <?= $Page->MEASURE_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_MEASURE_ID">
<span<?= $Page->MEASURE_ID->viewAttributes() ?>>
<?= $Page->MEASURE_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->POKOK_JUAL->Visible) { // POKOK_JUAL ?>
        <td data-name="POKOK_JUAL" <?= $Page->POKOK_JUAL->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_POKOK_JUAL">
<span<?= $Page->POKOK_JUAL->viewAttributes() ?>>
<?= $Page->POKOK_JUAL->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PPN->Visible) { // PPN ?>
        <td data-name="PPN" <?= $Page->PPN->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_PPN">
<span<?= $Page->PPN->viewAttributes() ?>>
<?= $Page->PPN->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->MARGIN->Visible) { // MARGIN ?>
        <td data-name="MARGIN" <?= $Page->MARGIN->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_MARGIN">
<span<?= $Page->MARGIN->viewAttributes() ?>>
<?= $Page->MARGIN->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->SUBSIDI->Visible) { // SUBSIDI ?>
        <td data-name="SUBSIDI" <?= $Page->SUBSIDI->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_SUBSIDI">
<span<?= $Page->SUBSIDI->viewAttributes() ?>>
<?= $Page->SUBSIDI->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->EMBALACE->Visible) { // EMBALACE ?>
        <td data-name="EMBALACE" <?= $Page->EMBALACE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_EMBALACE">
<span<?= $Page->EMBALACE->viewAttributes() ?>>
<?= $Page->EMBALACE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PROFESI->Visible) { // PROFESI ?>
        <td data-name="PROFESI" <?= $Page->PROFESI->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_PROFESI">
<span<?= $Page->PROFESI->viewAttributes() ?>>
<?= $Page->PROFESI->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->DISCOUNT->Visible) { // DISCOUNT ?>
        <td data-name="DISCOUNT" <?= $Page->DISCOUNT->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_DISCOUNT">
<span<?= $Page->DISCOUNT->viewAttributes() ?>>
<?= $Page->DISCOUNT->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PAY_METHOD_ID->Visible) { // PAY_METHOD_ID ?>
        <td data-name="PAY_METHOD_ID" <?= $Page->PAY_METHOD_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_PAY_METHOD_ID">
<span<?= $Page->PAY_METHOD_ID->viewAttributes() ?>>
<?= $Page->PAY_METHOD_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PAYMENT_DATE->Visible) { // PAYMENT_DATE ?>
        <td data-name="PAYMENT_DATE" <?= $Page->PAYMENT_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_PAYMENT_DATE">
<span<?= $Page->PAYMENT_DATE->viewAttributes() ?>>
<?= $Page->PAYMENT_DATE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ISLUNAS->Visible) { // ISLUNAS ?>
        <td data-name="ISLUNAS" <?= $Page->ISLUNAS->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_ISLUNAS">
<span<?= $Page->ISLUNAS->viewAttributes() ?>>
<?= $Page->ISLUNAS->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->DUEDATE_ANGSURAN->Visible) { // DUEDATE_ANGSURAN ?>
        <td data-name="DUEDATE_ANGSURAN" <?= $Page->DUEDATE_ANGSURAN->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_DUEDATE_ANGSURAN">
<span<?= $Page->DUEDATE_ANGSURAN->viewAttributes() ?>>
<?= $Page->DUEDATE_ANGSURAN->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->DESCRIPTION->Visible) { // DESCRIPTION ?>
        <td data-name="DESCRIPTION" <?= $Page->DESCRIPTION->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_DESCRIPTION">
<span<?= $Page->DESCRIPTION->viewAttributes() ?>>
<?= $Page->DESCRIPTION->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->KUITANSI_ID->Visible) { // KUITANSI_ID ?>
        <td data-name="KUITANSI_ID" <?= $Page->KUITANSI_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_KUITANSI_ID">
<span<?= $Page->KUITANSI_ID->viewAttributes() ?>>
<?= $Page->KUITANSI_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->NOTA_NO->Visible) { // NOTA_NO ?>
        <td data-name="NOTA_NO" <?= $Page->NOTA_NO->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_NOTA_NO">
<span<?= $Page->NOTA_NO->viewAttributes() ?>>
<?= $Page->NOTA_NO->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ISCETAK->Visible) { // ISCETAK ?>
        <td data-name="ISCETAK" <?= $Page->ISCETAK->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_ISCETAK">
<span<?= $Page->ISCETAK->viewAttributes() ?>>
<?= $Page->ISCETAK->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PRINT_DATE->Visible) { // PRINT_DATE ?>
        <td data-name="PRINT_DATE" <?= $Page->PRINT_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_PRINT_DATE">
<span<?= $Page->PRINT_DATE->viewAttributes() ?>>
<?= $Page->PRINT_DATE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->RESEP_NO->Visible) { // RESEP_NO ?>
        <td data-name="RESEP_NO" <?= $Page->RESEP_NO->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_RESEP_NO">
<span<?= $Page->RESEP_NO->viewAttributes() ?>>
<?= $Page->RESEP_NO->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->RESEP_KE->Visible) { // RESEP_KE ?>
        <td data-name="RESEP_KE" <?= $Page->RESEP_KE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_RESEP_KE">
<span<?= $Page->RESEP_KE->viewAttributes() ?>>
<?= $Page->RESEP_KE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->DOSE->Visible) { // DOSE ?>
        <td data-name="DOSE" <?= $Page->DOSE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_DOSE">
<span<?= $Page->DOSE->viewAttributes() ?>>
<?= $Page->DOSE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ORIG_DOSE->Visible) { // ORIG_DOSE ?>
        <td data-name="ORIG_DOSE" <?= $Page->ORIG_DOSE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_ORIG_DOSE">
<span<?= $Page->ORIG_DOSE->viewAttributes() ?>>
<?= $Page->ORIG_DOSE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->DOSE_PRESC->Visible) { // DOSE_PRESC ?>
        <td data-name="DOSE_PRESC" <?= $Page->DOSE_PRESC->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_DOSE_PRESC">
<span<?= $Page->DOSE_PRESC->viewAttributes() ?>>
<?= $Page->DOSE_PRESC->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ITER->Visible) { // ITER ?>
        <td data-name="ITER" <?= $Page->ITER->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_ITER">
<span<?= $Page->ITER->viewAttributes() ?>>
<?= $Page->ITER->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ITER_KE->Visible) { // ITER_KE ?>
        <td data-name="ITER_KE" <?= $Page->ITER_KE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_ITER_KE">
<span<?= $Page->ITER_KE->viewAttributes() ?>>
<?= $Page->ITER_KE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->SOLD_STATUS->Visible) { // SOLD_STATUS ?>
        <td data-name="SOLD_STATUS" <?= $Page->SOLD_STATUS->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_SOLD_STATUS">
<span<?= $Page->SOLD_STATUS->viewAttributes() ?>>
<?= $Page->SOLD_STATUS->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->RACIKAN->Visible) { // RACIKAN ?>
        <td data-name="RACIKAN" <?= $Page->RACIKAN->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_RACIKAN">
<span<?= $Page->RACIKAN->viewAttributes() ?>>
<?= $Page->RACIKAN->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->CLASS_ROOM_ID->Visible) { // CLASS_ROOM_ID ?>
        <td data-name="CLASS_ROOM_ID" <?= $Page->CLASS_ROOM_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_CLASS_ROOM_ID">
<span<?= $Page->CLASS_ROOM_ID->viewAttributes() ?>>
<?= $Page->CLASS_ROOM_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->KELUAR_ID->Visible) { // KELUAR_ID ?>
        <td data-name="KELUAR_ID" <?= $Page->KELUAR_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_KELUAR_ID">
<span<?= $Page->KELUAR_ID->viewAttributes() ?>>
<?= $Page->KELUAR_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->BED_ID->Visible) { // BED_ID ?>
        <td data-name="BED_ID" <?= $Page->BED_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_BED_ID">
<span<?= $Page->BED_ID->viewAttributes() ?>>
<?= $Page->BED_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PERDA_ID->Visible) { // PERDA_ID ?>
        <td data-name="PERDA_ID" <?= $Page->PERDA_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_PERDA_ID">
<span<?= $Page->PERDA_ID->viewAttributes() ?>>
<?= $Page->PERDA_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->EMPLOYEE_ID->Visible) { // EMPLOYEE_ID ?>
        <td data-name="EMPLOYEE_ID" <?= $Page->EMPLOYEE_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_EMPLOYEE_ID">
<span<?= $Page->EMPLOYEE_ID->viewAttributes() ?>>
<?= $Page->EMPLOYEE_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->DESCRIPTION2->Visible) { // DESCRIPTION2 ?>
        <td data-name="DESCRIPTION2" <?= $Page->DESCRIPTION2->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_DESCRIPTION2">
<span<?= $Page->DESCRIPTION2->viewAttributes() ?>>
<?= $Page->DESCRIPTION2->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
        <td data-name="MODIFIED_BY" <?= $Page->MODIFIED_BY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_MODIFIED_BY">
<span<?= $Page->MODIFIED_BY->viewAttributes() ?>>
<?= $Page->MODIFIED_BY->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
        <td data-name="MODIFIED_DATE" <?= $Page->MODIFIED_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_MODIFIED_DATE">
<span<?= $Page->MODIFIED_DATE->viewAttributes() ?>>
<?= $Page->MODIFIED_DATE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->MODIFIED_FROM->Visible) { // MODIFIED_FROM ?>
        <td data-name="MODIFIED_FROM" <?= $Page->MODIFIED_FROM->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_MODIFIED_FROM">
<span<?= $Page->MODIFIED_FROM->viewAttributes() ?>>
<?= $Page->MODIFIED_FROM->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->BRAND_ID->Visible) { // BRAND_ID ?>
        <td data-name="BRAND_ID" <?= $Page->BRAND_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_BRAND_ID">
<span<?= $Page->BRAND_ID->viewAttributes() ?>>
<?= $Page->BRAND_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->DOCTOR->Visible) { // DOCTOR ?>
        <td data-name="DOCTOR" <?= $Page->DOCTOR->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_DOCTOR">
<span<?= $Page->DOCTOR->viewAttributes() ?>>
<?= $Page->DOCTOR->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->JML_BKS->Visible) { // JML_BKS ?>
        <td data-name="JML_BKS" <?= $Page->JML_BKS->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_JML_BKS">
<span<?= $Page->JML_BKS->viewAttributes() ?>>
<?= $Page->JML_BKS->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->EXIT_DATE->Visible) { // EXIT_DATE ?>
        <td data-name="EXIT_DATE" <?= $Page->EXIT_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_EXIT_DATE">
<span<?= $Page->EXIT_DATE->viewAttributes() ?>>
<?= $Page->EXIT_DATE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->FA_V->Visible) { // FA_V ?>
        <td data-name="FA_V" <?= $Page->FA_V->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_FA_V">
<span<?= $Page->FA_V->viewAttributes() ?>>
<?= $Page->FA_V->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->TASK_ID->Visible) { // TASK_ID ?>
        <td data-name="TASK_ID" <?= $Page->TASK_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_TASK_ID">
<span<?= $Page->TASK_ID->viewAttributes() ?>>
<?= $Page->TASK_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->EMPLOYEE_ID_FROM->Visible) { // EMPLOYEE_ID_FROM ?>
        <td data-name="EMPLOYEE_ID_FROM" <?= $Page->EMPLOYEE_ID_FROM->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_EMPLOYEE_ID_FROM">
<span<?= $Page->EMPLOYEE_ID_FROM->viewAttributes() ?>>
<?= $Page->EMPLOYEE_ID_FROM->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->DOCTOR_FROM->Visible) { // DOCTOR_FROM ?>
        <td data-name="DOCTOR_FROM" <?= $Page->DOCTOR_FROM->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_DOCTOR_FROM">
<span<?= $Page->DOCTOR_FROM->viewAttributes() ?>>
<?= $Page->DOCTOR_FROM->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->status_pasien_id->Visible) { // status_pasien_id ?>
        <td data-name="status_pasien_id" <?= $Page->status_pasien_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_status_pasien_id">
<span<?= $Page->status_pasien_id->viewAttributes() ?>>
<?= $Page->status_pasien_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->amount_paid->Visible) { // amount_paid ?>
        <td data-name="amount_paid" <?= $Page->amount_paid->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_amount_paid">
<span<?= $Page->amount_paid->viewAttributes() ?>>
<?= $Page->amount_paid->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->THENAME->Visible) { // THENAME ?>
        <td data-name="THENAME" <?= $Page->THENAME->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_THENAME">
<span<?= $Page->THENAME->viewAttributes() ?>>
<?= $Page->THENAME->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->THEADDRESS->Visible) { // THEADDRESS ?>
        <td data-name="THEADDRESS" <?= $Page->THEADDRESS->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_THEADDRESS">
<span<?= $Page->THEADDRESS->viewAttributes() ?>>
<?= $Page->THEADDRESS->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->THEID->Visible) { // THEID ?>
        <td data-name="THEID" <?= $Page->THEID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_THEID">
<span<?= $Page->THEID->viewAttributes() ?>>
<?= $Page->THEID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->serial_nb->Visible) { // serial_nb ?>
        <td data-name="serial_nb" <?= $Page->serial_nb->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_serial_nb">
<span<?= $Page->serial_nb->viewAttributes() ?>>
<?= $Page->serial_nb->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->TREATMENT_PLAFOND->Visible) { // TREATMENT_PLAFOND ?>
        <td data-name="TREATMENT_PLAFOND" <?= $Page->TREATMENT_PLAFOND->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_TREATMENT_PLAFOND">
<span<?= $Page->TREATMENT_PLAFOND->viewAttributes() ?>>
<?= $Page->TREATMENT_PLAFOND->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->AMOUNT_PLAFOND->Visible) { // AMOUNT_PLAFOND ?>
        <td data-name="AMOUNT_PLAFOND" <?= $Page->AMOUNT_PLAFOND->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_AMOUNT_PLAFOND">
<span<?= $Page->AMOUNT_PLAFOND->viewAttributes() ?>>
<?= $Page->AMOUNT_PLAFOND->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->AMOUNT_PAID_PLAFOND->Visible) { // AMOUNT_PAID_PLAFOND ?>
        <td data-name="AMOUNT_PAID_PLAFOND" <?= $Page->AMOUNT_PAID_PLAFOND->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_AMOUNT_PAID_PLAFOND">
<span<?= $Page->AMOUNT_PAID_PLAFOND->viewAttributes() ?>>
<?= $Page->AMOUNT_PAID_PLAFOND->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->CLASS_ID_PLAFOND->Visible) { // CLASS_ID_PLAFOND ?>
        <td data-name="CLASS_ID_PLAFOND" <?= $Page->CLASS_ID_PLAFOND->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_CLASS_ID_PLAFOND">
<span<?= $Page->CLASS_ID_PLAFOND->viewAttributes() ?>>
<?= $Page->CLASS_ID_PLAFOND->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PAYOR_ID->Visible) { // PAYOR_ID ?>
        <td data-name="PAYOR_ID" <?= $Page->PAYOR_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_PAYOR_ID">
<span<?= $Page->PAYOR_ID->viewAttributes() ?>>
<?= $Page->PAYOR_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PEMBULATAN->Visible) { // PEMBULATAN ?>
        <td data-name="PEMBULATAN" <?= $Page->PEMBULATAN->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_PEMBULATAN">
<span<?= $Page->PEMBULATAN->viewAttributes() ?>>
<?= $Page->PEMBULATAN->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ISRJ->Visible) { // ISRJ ?>
        <td data-name="ISRJ" <?= $Page->ISRJ->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_ISRJ">
<span<?= $Page->ISRJ->viewAttributes() ?>>
<?= $Page->ISRJ->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->AGEYEAR->Visible) { // AGEYEAR ?>
        <td data-name="AGEYEAR" <?= $Page->AGEYEAR->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_AGEYEAR">
<span<?= $Page->AGEYEAR->viewAttributes() ?>>
<?= $Page->AGEYEAR->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->AGEMONTH->Visible) { // AGEMONTH ?>
        <td data-name="AGEMONTH" <?= $Page->AGEMONTH->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_AGEMONTH">
<span<?= $Page->AGEMONTH->viewAttributes() ?>>
<?= $Page->AGEMONTH->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->AGEDAY->Visible) { // AGEDAY ?>
        <td data-name="AGEDAY" <?= $Page->AGEDAY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_AGEDAY">
<span<?= $Page->AGEDAY->viewAttributes() ?>>
<?= $Page->AGEDAY->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->GENDER->Visible) { // GENDER ?>
        <td data-name="GENDER" <?= $Page->GENDER->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_GENDER">
<span<?= $Page->GENDER->viewAttributes() ?>>
<?= $Page->GENDER->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->KAL_ID->Visible) { // KAL_ID ?>
        <td data-name="KAL_ID" <?= $Page->KAL_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_KAL_ID">
<span<?= $Page->KAL_ID->viewAttributes() ?>>
<?= $Page->KAL_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->CORRECTION_ID->Visible) { // CORRECTION_ID ?>
        <td data-name="CORRECTION_ID" <?= $Page->CORRECTION_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_CORRECTION_ID">
<span<?= $Page->CORRECTION_ID->viewAttributes() ?>>
<?= $Page->CORRECTION_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->CORRECTION_BY->Visible) { // CORRECTION_BY ?>
        <td data-name="CORRECTION_BY" <?= $Page->CORRECTION_BY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_CORRECTION_BY">
<span<?= $Page->CORRECTION_BY->viewAttributes() ?>>
<?= $Page->CORRECTION_BY->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->KARYAWAN->Visible) { // KARYAWAN ?>
        <td data-name="KARYAWAN" <?= $Page->KARYAWAN->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_KARYAWAN">
<span<?= $Page->KARYAWAN->viewAttributes() ?>>
<?= $Page->KARYAWAN->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ACCOUNT_ID->Visible) { // ACCOUNT_ID ?>
        <td data-name="ACCOUNT_ID" <?= $Page->ACCOUNT_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_ACCOUNT_ID">
<span<?= $Page->ACCOUNT_ID->viewAttributes() ?>>
<?= $Page->ACCOUNT_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->sell_price->Visible) { // sell_price ?>
        <td data-name="sell_price" <?= $Page->sell_price->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_sell_price">
<span<?= $Page->sell_price->viewAttributes() ?>>
<?= $Page->sell_price->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->diskon->Visible) { // diskon ?>
        <td data-name="diskon" <?= $Page->diskon->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_diskon">
<span<?= $Page->diskon->viewAttributes() ?>>
<?= $Page->diskon->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->INVOICE_ID->Visible) { // INVOICE_ID ?>
        <td data-name="INVOICE_ID" <?= $Page->INVOICE_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_INVOICE_ID">
<span<?= $Page->INVOICE_ID->viewAttributes() ?>>
<?= $Page->INVOICE_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->NUMER->Visible) { // NUMER ?>
        <td data-name="NUMER" <?= $Page->NUMER->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_NUMER">
<span<?= $Page->NUMER->viewAttributes() ?>>
<?= $Page->NUMER->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->MEASURE_ID2->Visible) { // MEASURE_ID2 ?>
        <td data-name="MEASURE_ID2" <?= $Page->MEASURE_ID2->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_MEASURE_ID2">
<span<?= $Page->MEASURE_ID2->viewAttributes() ?>>
<?= $Page->MEASURE_ID2->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->POTONGAN->Visible) { // POTONGAN ?>
        <td data-name="POTONGAN" <?= $Page->POTONGAN->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_POTONGAN">
<span<?= $Page->POTONGAN->viewAttributes() ?>>
<?= $Page->POTONGAN->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->BAYAR->Visible) { // BAYAR ?>
        <td data-name="BAYAR" <?= $Page->BAYAR->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_BAYAR">
<span<?= $Page->BAYAR->viewAttributes() ?>>
<?= $Page->BAYAR->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->RETUR->Visible) { // RETUR ?>
        <td data-name="RETUR" <?= $Page->RETUR->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_RETUR">
<span<?= $Page->RETUR->viewAttributes() ?>>
<?= $Page->RETUR->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->TARIF_TYPE->Visible) { // TARIF_TYPE ?>
        <td data-name="TARIF_TYPE" <?= $Page->TARIF_TYPE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_TARIF_TYPE">
<span<?= $Page->TARIF_TYPE->viewAttributes() ?>>
<?= $Page->TARIF_TYPE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PPNVALUE->Visible) { // PPNVALUE ?>
        <td data-name="PPNVALUE" <?= $Page->PPNVALUE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_PPNVALUE">
<span<?= $Page->PPNVALUE->viewAttributes() ?>>
<?= $Page->PPNVALUE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->TAGIHAN->Visible) { // TAGIHAN ?>
        <td data-name="TAGIHAN" <?= $Page->TAGIHAN->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_TAGIHAN">
<span<?= $Page->TAGIHAN->viewAttributes() ?>>
<?= $Page->TAGIHAN->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->KOREKSI->Visible) { // KOREKSI ?>
        <td data-name="KOREKSI" <?= $Page->KOREKSI->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_KOREKSI">
<span<?= $Page->KOREKSI->viewAttributes() ?>>
<?= $Page->KOREKSI->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->STATUS_OBAT->Visible) { // STATUS_OBAT ?>
        <td data-name="STATUS_OBAT" <?= $Page->STATUS_OBAT->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_STATUS_OBAT">
<span<?= $Page->STATUS_OBAT->viewAttributes() ?>>
<?= $Page->STATUS_OBAT->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->SUBSIDISAT->Visible) { // SUBSIDISAT ?>
        <td data-name="SUBSIDISAT" <?= $Page->SUBSIDISAT->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_SUBSIDISAT">
<span<?= $Page->SUBSIDISAT->viewAttributes() ?>>
<?= $Page->SUBSIDISAT->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PRINTQ->Visible) { // PRINTQ ?>
        <td data-name="PRINTQ" <?= $Page->PRINTQ->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_PRINTQ">
<span<?= $Page->PRINTQ->viewAttributes() ?>>
<?= $Page->PRINTQ->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PRINTED_BY->Visible) { // PRINTED_BY ?>
        <td data-name="PRINTED_BY" <?= $Page->PRINTED_BY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_PRINTED_BY">
<span<?= $Page->PRINTED_BY->viewAttributes() ?>>
<?= $Page->PRINTED_BY->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->STOCK_AVAILABLE->Visible) { // STOCK_AVAILABLE ?>
        <td data-name="STOCK_AVAILABLE" <?= $Page->STOCK_AVAILABLE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_STOCK_AVAILABLE">
<span<?= $Page->STOCK_AVAILABLE->viewAttributes() ?>>
<?= $Page->STOCK_AVAILABLE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->STATUS_TARIF->Visible) { // STATUS_TARIF ?>
        <td data-name="STATUS_TARIF" <?= $Page->STATUS_TARIF->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_STATUS_TARIF">
<span<?= $Page->STATUS_TARIF->viewAttributes() ?>>
<?= $Page->STATUS_TARIF->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->CLINIC_TYPE->Visible) { // CLINIC_TYPE ?>
        <td data-name="CLINIC_TYPE" <?= $Page->CLINIC_TYPE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_CLINIC_TYPE">
<span<?= $Page->CLINIC_TYPE->viewAttributes() ?>>
<?= $Page->CLINIC_TYPE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PACKAGE_ID->Visible) { // PACKAGE_ID ?>
        <td data-name="PACKAGE_ID" <?= $Page->PACKAGE_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_PACKAGE_ID">
<span<?= $Page->PACKAGE_ID->viewAttributes() ?>>
<?= $Page->PACKAGE_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->MODULE_ID->Visible) { // MODULE_ID ?>
        <td data-name="MODULE_ID" <?= $Page->MODULE_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_MODULE_ID">
<span<?= $Page->MODULE_ID->viewAttributes() ?>>
<?= $Page->MODULE_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->profession->Visible) { // profession ?>
        <td data-name="profession" <?= $Page->profession->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_profession">
<span<?= $Page->profession->viewAttributes() ?>>
<?= $Page->profession->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->THEORDER->Visible) { // THEORDER ?>
        <td data-name="THEORDER" <?= $Page->THEORDER->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_THEORDER">
<span<?= $Page->THEORDER->viewAttributes() ?>>
<?= $Page->THEORDER->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->CASHIER->Visible) { // CASHIER ?>
        <td data-name="CASHIER" <?= $Page->CASHIER->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_treatment_bill2_CASHIER">
<span<?= $Page->CASHIER->viewAttributes() ?>>
<?= $Page->CASHIER->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
    </tr>
<?php
    }
    if (!$Page->isGridAdd()) {
        $Page->Recordset->moveNext();
    }
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
<?php if (!$Page->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</form><!-- /.ew-list-form -->
<?php
// Close recordset
if ($Page->Recordset) {
    $Page->Recordset->close();
}
?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($Page->TotalRecords == 0 && !$Page->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("treatment_bill2");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
