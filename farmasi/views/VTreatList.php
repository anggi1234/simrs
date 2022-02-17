<?php

namespace PHPMaker2021\SIMRS;

// Page object
$VTreatList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fV_TREATlist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fV_TREATlist = currentForm = new ew.Form("fV_TREATlist", "list");
    fV_TREATlist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("fV_TREATlist");
});
var fV_TREATlistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    fV_TREATlistsrch = currentSearchForm = new ew.Form("fV_TREATlistsrch");

    // Dynamic selection lists

    // Filters
    fV_TREATlistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fV_TREATlistsrch");
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
<?php if (!$Page->isExport() || Config("EXPORT_MASTER_RECORD") && $Page->isExport("print")) { ?>
<?php
if ($Page->DbMasterFilter != "" && $Page->getCurrentMasterTable() == "PASIEN_VISITATION") {
    if ($Page->MasterRecordExists) {
        include_once "views/PasienVisitationMaster.php";
    }
}
?>
<?php } ?>
<?php
$Page->renderOtherOptions();
?>
<?php if ($Security->canSearch()) { ?>
<?php if (!$Page->isExport() && !$Page->CurrentAction) { ?>
<form name="fV_TREATlistsrch" id="fV_TREATlistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fV_TREATlistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="V_TREAT">
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
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<?php if ($Page->TotalRecords > 0 || $Page->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> V_TREAT">
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
<form name="fV_TREATlist" id="fV_TREATlist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="V_TREAT">
<?php if ($Page->getCurrentMasterTable() == "PASIEN_VISITATION" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="PASIEN_VISITATION">
<input type="hidden" name="fk_VISIT_ID" value="<?= HtmlEncode($Page->VISIT_ID->getSessionValue()) ?>">
<?php } ?>
<div id="gmp_V_TREAT" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_V_TREATlist" class="table ew-table"><!-- .ew-table -->
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
        <th data-name="ORG_UNIT_CODE" class="<?= $Page->ORG_UNIT_CODE->headerCellClass() ?>"><div id="elh_V_TREAT_ORG_UNIT_CODE" class="V_TREAT_ORG_UNIT_CODE"><?= $Page->renderSort($Page->ORG_UNIT_CODE) ?></div></th>
<?php } ?>
<?php if ($Page->BILL_ID->Visible) { // BILL_ID ?>
        <th data-name="BILL_ID" class="<?= $Page->BILL_ID->headerCellClass() ?>"><div id="elh_V_TREAT_BILL_ID" class="V_TREAT_BILL_ID"><?= $Page->renderSort($Page->BILL_ID) ?></div></th>
<?php } ?>
<?php if ($Page->NO_REGISTRATION->Visible) { // NO_REGISTRATION ?>
        <th data-name="NO_REGISTRATION" class="<?= $Page->NO_REGISTRATION->headerCellClass() ?>"><div id="elh_V_TREAT_NO_REGISTRATION" class="V_TREAT_NO_REGISTRATION"><?= $Page->renderSort($Page->NO_REGISTRATION) ?></div></th>
<?php } ?>
<?php if ($Page->VISIT_ID->Visible) { // VISIT_ID ?>
        <th data-name="VISIT_ID" class="<?= $Page->VISIT_ID->headerCellClass() ?>"><div id="elh_V_TREAT_VISIT_ID" class="V_TREAT_VISIT_ID"><?= $Page->renderSort($Page->VISIT_ID) ?></div></th>
<?php } ?>
<?php if ($Page->TARIF_ID->Visible) { // TARIF_ID ?>
        <th data-name="TARIF_ID" class="<?= $Page->TARIF_ID->headerCellClass() ?>"><div id="elh_V_TREAT_TARIF_ID" class="V_TREAT_TARIF_ID"><?= $Page->renderSort($Page->TARIF_ID) ?></div></th>
<?php } ?>
<?php if ($Page->CLASS_ID->Visible) { // CLASS_ID ?>
        <th data-name="CLASS_ID" class="<?= $Page->CLASS_ID->headerCellClass() ?>"><div id="elh_V_TREAT_CLASS_ID" class="V_TREAT_CLASS_ID"><?= $Page->renderSort($Page->CLASS_ID) ?></div></th>
<?php } ?>
<?php if ($Page->CLINIC_ID->Visible) { // CLINIC_ID ?>
        <th data-name="CLINIC_ID" class="<?= $Page->CLINIC_ID->headerCellClass() ?>"><div id="elh_V_TREAT_CLINIC_ID" class="V_TREAT_CLINIC_ID"><?= $Page->renderSort($Page->CLINIC_ID) ?></div></th>
<?php } ?>
<?php if ($Page->CLINIC_ID_FROM->Visible) { // CLINIC_ID_FROM ?>
        <th data-name="CLINIC_ID_FROM" class="<?= $Page->CLINIC_ID_FROM->headerCellClass() ?>"><div id="elh_V_TREAT_CLINIC_ID_FROM" class="V_TREAT_CLINIC_ID_FROM"><?= $Page->renderSort($Page->CLINIC_ID_FROM) ?></div></th>
<?php } ?>
<?php if ($Page->TREATMENT->Visible) { // TREATMENT ?>
        <th data-name="TREATMENT" class="<?= $Page->TREATMENT->headerCellClass() ?>"><div id="elh_V_TREAT_TREATMENT" class="V_TREAT_TREATMENT"><?= $Page->renderSort($Page->TREATMENT) ?></div></th>
<?php } ?>
<?php if ($Page->TREAT_DATE->Visible) { // TREAT_DATE ?>
        <th data-name="TREAT_DATE" class="<?= $Page->TREAT_DATE->headerCellClass() ?>"><div id="elh_V_TREAT_TREAT_DATE" class="V_TREAT_TREAT_DATE"><?= $Page->renderSort($Page->TREAT_DATE) ?></div></th>
<?php } ?>
<?php if ($Page->QUANTITY->Visible) { // QUANTITY ?>
        <th data-name="QUANTITY" class="<?= $Page->QUANTITY->headerCellClass() ?>"><div id="elh_V_TREAT_QUANTITY" class="V_TREAT_QUANTITY"><?= $Page->renderSort($Page->QUANTITY) ?></div></th>
<?php } ?>
<?php if ($Page->MEASURE_ID->Visible) { // MEASURE_ID ?>
        <th data-name="MEASURE_ID" class="<?= $Page->MEASURE_ID->headerCellClass() ?>"><div id="elh_V_TREAT_MEASURE_ID" class="V_TREAT_MEASURE_ID"><?= $Page->renderSort($Page->MEASURE_ID) ?></div></th>
<?php } ?>
<?php if ($Page->DESCRIPTION->Visible) { // DESCRIPTION ?>
        <th data-name="DESCRIPTION" class="<?= $Page->DESCRIPTION->headerCellClass() ?>"><div id="elh_V_TREAT_DESCRIPTION" class="V_TREAT_DESCRIPTION"><?= $Page->renderSort($Page->DESCRIPTION) ?></div></th>
<?php } ?>
<?php if ($Page->RESEP_NO->Visible) { // RESEP_NO ?>
        <th data-name="RESEP_NO" class="<?= $Page->RESEP_NO->headerCellClass() ?>"><div id="elh_V_TREAT_RESEP_NO" class="V_TREAT_RESEP_NO"><?= $Page->renderSort($Page->RESEP_NO) ?></div></th>
<?php } ?>
<?php if ($Page->DOSE_PRESC->Visible) { // DOSE_PRESC ?>
        <th data-name="DOSE_PRESC" class="<?= $Page->DOSE_PRESC->headerCellClass() ?>"><div id="elh_V_TREAT_DOSE_PRESC" class="V_TREAT_DOSE_PRESC"><?= $Page->renderSort($Page->DOSE_PRESC) ?></div></th>
<?php } ?>
<?php if ($Page->SOLD_STATUS->Visible) { // SOLD_STATUS ?>
        <th data-name="SOLD_STATUS" class="<?= $Page->SOLD_STATUS->headerCellClass() ?>"><div id="elh_V_TREAT_SOLD_STATUS" class="V_TREAT_SOLD_STATUS"><?= $Page->renderSort($Page->SOLD_STATUS) ?></div></th>
<?php } ?>
<?php if ($Page->RACIKAN->Visible) { // RACIKAN ?>
        <th data-name="RACIKAN" class="<?= $Page->RACIKAN->headerCellClass() ?>"><div id="elh_V_TREAT_RACIKAN" class="V_TREAT_RACIKAN"><?= $Page->renderSort($Page->RACIKAN) ?></div></th>
<?php } ?>
<?php if ($Page->CLASS_ROOM_ID->Visible) { // CLASS_ROOM_ID ?>
        <th data-name="CLASS_ROOM_ID" class="<?= $Page->CLASS_ROOM_ID->headerCellClass() ?>"><div id="elh_V_TREAT_CLASS_ROOM_ID" class="V_TREAT_CLASS_ROOM_ID"><?= $Page->renderSort($Page->CLASS_ROOM_ID) ?></div></th>
<?php } ?>
<?php if ($Page->KELUAR_ID->Visible) { // KELUAR_ID ?>
        <th data-name="KELUAR_ID" class="<?= $Page->KELUAR_ID->headerCellClass() ?>"><div id="elh_V_TREAT_KELUAR_ID" class="V_TREAT_KELUAR_ID"><?= $Page->renderSort($Page->KELUAR_ID) ?></div></th>
<?php } ?>
<?php if ($Page->BED_ID->Visible) { // BED_ID ?>
        <th data-name="BED_ID" class="<?= $Page->BED_ID->headerCellClass() ?>"><div id="elh_V_TREAT_BED_ID" class="V_TREAT_BED_ID"><?= $Page->renderSort($Page->BED_ID) ?></div></th>
<?php } ?>
<?php if ($Page->EMPLOYEE_ID->Visible) { // EMPLOYEE_ID ?>
        <th data-name="EMPLOYEE_ID" class="<?= $Page->EMPLOYEE_ID->headerCellClass() ?>"><div id="elh_V_TREAT_EMPLOYEE_ID" class="V_TREAT_EMPLOYEE_ID"><?= $Page->renderSort($Page->EMPLOYEE_ID) ?></div></th>
<?php } ?>
<?php if ($Page->DESCRIPTION2->Visible) { // DESCRIPTION2 ?>
        <th data-name="DESCRIPTION2" class="<?= $Page->DESCRIPTION2->headerCellClass() ?>"><div id="elh_V_TREAT_DESCRIPTION2" class="V_TREAT_DESCRIPTION2"><?= $Page->renderSort($Page->DESCRIPTION2) ?></div></th>
<?php } ?>
<?php if ($Page->BRAND_ID->Visible) { // BRAND_ID ?>
        <th data-name="BRAND_ID" class="<?= $Page->BRAND_ID->headerCellClass() ?>"><div id="elh_V_TREAT_BRAND_ID" class="V_TREAT_BRAND_ID"><?= $Page->renderSort($Page->BRAND_ID) ?></div></th>
<?php } ?>
<?php if ($Page->DOCTOR->Visible) { // DOCTOR ?>
        <th data-name="DOCTOR" class="<?= $Page->DOCTOR->headerCellClass() ?>"><div id="elh_V_TREAT_DOCTOR" class="V_TREAT_DOCTOR"><?= $Page->renderSort($Page->DOCTOR) ?></div></th>
<?php } ?>
<?php if ($Page->EXIT_DATE->Visible) { // EXIT_DATE ?>
        <th data-name="EXIT_DATE" class="<?= $Page->EXIT_DATE->headerCellClass() ?>"><div id="elh_V_TREAT_EXIT_DATE" class="V_TREAT_EXIT_DATE"><?= $Page->renderSort($Page->EXIT_DATE) ?></div></th>
<?php } ?>
<?php if ($Page->EMPLOYEE_ID_FROM->Visible) { // EMPLOYEE_ID_FROM ?>
        <th data-name="EMPLOYEE_ID_FROM" class="<?= $Page->EMPLOYEE_ID_FROM->headerCellClass() ?>"><div id="elh_V_TREAT_EMPLOYEE_ID_FROM" class="V_TREAT_EMPLOYEE_ID_FROM"><?= $Page->renderSort($Page->EMPLOYEE_ID_FROM) ?></div></th>
<?php } ?>
<?php if ($Page->DOCTOR_FROM->Visible) { // DOCTOR_FROM ?>
        <th data-name="DOCTOR_FROM" class="<?= $Page->DOCTOR_FROM->headerCellClass() ?>"><div id="elh_V_TREAT_DOCTOR_FROM" class="V_TREAT_DOCTOR_FROM"><?= $Page->renderSort($Page->DOCTOR_FROM) ?></div></th>
<?php } ?>
<?php if ($Page->status_pasien_id->Visible) { // status_pasien_id ?>
        <th data-name="status_pasien_id" class="<?= $Page->status_pasien_id->headerCellClass() ?>"><div id="elh_V_TREAT_status_pasien_id" class="V_TREAT_status_pasien_id"><?= $Page->renderSort($Page->status_pasien_id) ?></div></th>
<?php } ?>
<?php if ($Page->THENAME->Visible) { // THENAME ?>
        <th data-name="THENAME" class="<?= $Page->THENAME->headerCellClass() ?>"><div id="elh_V_TREAT_THENAME" class="V_TREAT_THENAME"><?= $Page->renderSort($Page->THENAME) ?></div></th>
<?php } ?>
<?php if ($Page->THEADDRESS->Visible) { // THEADDRESS ?>
        <th data-name="THEADDRESS" class="<?= $Page->THEADDRESS->headerCellClass() ?>"><div id="elh_V_TREAT_THEADDRESS" class="V_TREAT_THEADDRESS"><?= $Page->renderSort($Page->THEADDRESS) ?></div></th>
<?php } ?>
<?php if ($Page->THEID->Visible) { // THEID ?>
        <th data-name="THEID" class="<?= $Page->THEID->headerCellClass() ?>"><div id="elh_V_TREAT_THEID" class="V_TREAT_THEID"><?= $Page->renderSort($Page->THEID) ?></div></th>
<?php } ?>
<?php if ($Page->SERIAL_NB->Visible) { // SERIAL_NB ?>
        <th data-name="SERIAL_NB" class="<?= $Page->SERIAL_NB->headerCellClass() ?>"><div id="elh_V_TREAT_SERIAL_NB" class="V_TREAT_SERIAL_NB"><?= $Page->renderSort($Page->SERIAL_NB) ?></div></th>
<?php } ?>
<?php if ($Page->ISRJ->Visible) { // ISRJ ?>
        <th data-name="ISRJ" class="<?= $Page->ISRJ->headerCellClass() ?>"><div id="elh_V_TREAT_ISRJ" class="V_TREAT_ISRJ"><?= $Page->renderSort($Page->ISRJ) ?></div></th>
<?php } ?>
<?php if ($Page->AGEYEAR->Visible) { // AGEYEAR ?>
        <th data-name="AGEYEAR" class="<?= $Page->AGEYEAR->headerCellClass() ?>"><div id="elh_V_TREAT_AGEYEAR" class="V_TREAT_AGEYEAR"><?= $Page->renderSort($Page->AGEYEAR) ?></div></th>
<?php } ?>
<?php if ($Page->AGEMONTH->Visible) { // AGEMONTH ?>
        <th data-name="AGEMONTH" class="<?= $Page->AGEMONTH->headerCellClass() ?>"><div id="elh_V_TREAT_AGEMONTH" class="V_TREAT_AGEMONTH"><?= $Page->renderSort($Page->AGEMONTH) ?></div></th>
<?php } ?>
<?php if ($Page->AGEDAY->Visible) { // AGEDAY ?>
        <th data-name="AGEDAY" class="<?= $Page->AGEDAY->headerCellClass() ?>"><div id="elh_V_TREAT_AGEDAY" class="V_TREAT_AGEDAY"><?= $Page->renderSort($Page->AGEDAY) ?></div></th>
<?php } ?>
<?php if ($Page->GENDER->Visible) { // GENDER ?>
        <th data-name="GENDER" class="<?= $Page->GENDER->headerCellClass() ?>"><div id="elh_V_TREAT_GENDER" class="V_TREAT_GENDER"><?= $Page->renderSort($Page->GENDER) ?></div></th>
<?php } ?>
<?php if ($Page->KARYAWAN->Visible) { // KARYAWAN ?>
        <th data-name="KARYAWAN" class="<?= $Page->KARYAWAN->headerCellClass() ?>"><div id="elh_V_TREAT_KARYAWAN" class="V_TREAT_KARYAWAN"><?= $Page->renderSort($Page->KARYAWAN) ?></div></th>
<?php } ?>
<?php if ($Page->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
        <th data-name="MODIFIED_BY" class="<?= $Page->MODIFIED_BY->headerCellClass() ?>"><div id="elh_V_TREAT_MODIFIED_BY" class="V_TREAT_MODIFIED_BY"><?= $Page->renderSort($Page->MODIFIED_BY) ?></div></th>
<?php } ?>
<?php if ($Page->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
        <th data-name="MODIFIED_DATE" class="<?= $Page->MODIFIED_DATE->headerCellClass() ?>"><div id="elh_V_TREAT_MODIFIED_DATE" class="V_TREAT_MODIFIED_DATE"><?= $Page->renderSort($Page->MODIFIED_DATE) ?></div></th>
<?php } ?>
<?php if ($Page->MODIFIED_FROM->Visible) { // MODIFIED_FROM ?>
        <th data-name="MODIFIED_FROM" class="<?= $Page->MODIFIED_FROM->headerCellClass() ?>"><div id="elh_V_TREAT_MODIFIED_FROM" class="V_TREAT_MODIFIED_FROM"><?= $Page->renderSort($Page->MODIFIED_FROM) ?></div></th>
<?php } ?>
<?php if ($Page->NUMER->Visible) { // NUMER ?>
        <th data-name="NUMER" class="<?= $Page->NUMER->headerCellClass() ?>"><div id="elh_V_TREAT_NUMER" class="V_TREAT_NUMER"><?= $Page->renderSort($Page->NUMER) ?></div></th>
<?php } ?>
<?php if ($Page->NOTA_NO->Visible) { // NOTA_NO ?>
        <th data-name="NOTA_NO" class="<?= $Page->NOTA_NO->headerCellClass() ?>"><div id="elh_V_TREAT_NOTA_NO" class="V_TREAT_NOTA_NO"><?= $Page->renderSort($Page->NOTA_NO) ?></div></th>
<?php } ?>
<?php if ($Page->MEASURE_ID2->Visible) { // MEASURE_ID2 ?>
        <th data-name="MEASURE_ID2" class="<?= $Page->MEASURE_ID2->headerCellClass() ?>"><div id="elh_V_TREAT_MEASURE_ID2" class="V_TREAT_MEASURE_ID2"><?= $Page->renderSort($Page->MEASURE_ID2) ?></div></th>
<?php } ?>
<?php if ($Page->POTONGAN->Visible) { // POTONGAN ?>
        <th data-name="POTONGAN" class="<?= $Page->POTONGAN->headerCellClass() ?>"><div id="elh_V_TREAT_POTONGAN" class="V_TREAT_POTONGAN"><?= $Page->renderSort($Page->POTONGAN) ?></div></th>
<?php } ?>
<?php if ($Page->BAYAR->Visible) { // BAYAR ?>
        <th data-name="BAYAR" class="<?= $Page->BAYAR->headerCellClass() ?>"><div id="elh_V_TREAT_BAYAR" class="V_TREAT_BAYAR"><?= $Page->renderSort($Page->BAYAR) ?></div></th>
<?php } ?>
<?php if ($Page->RETUR->Visible) { // RETUR ?>
        <th data-name="RETUR" class="<?= $Page->RETUR->headerCellClass() ?>"><div id="elh_V_TREAT_RETUR" class="V_TREAT_RETUR"><?= $Page->renderSort($Page->RETUR) ?></div></th>
<?php } ?>
<?php if ($Page->TARIF_TYPE->Visible) { // TARIF_TYPE ?>
        <th data-name="TARIF_TYPE" class="<?= $Page->TARIF_TYPE->headerCellClass() ?>"><div id="elh_V_TREAT_TARIF_TYPE" class="V_TREAT_TARIF_TYPE"><?= $Page->renderSort($Page->TARIF_TYPE) ?></div></th>
<?php } ?>
<?php if ($Page->PPNVALUE->Visible) { // PPNVALUE ?>
        <th data-name="PPNVALUE" class="<?= $Page->PPNVALUE->headerCellClass() ?>"><div id="elh_V_TREAT_PPNVALUE" class="V_TREAT_PPNVALUE"><?= $Page->renderSort($Page->PPNVALUE) ?></div></th>
<?php } ?>
<?php if ($Page->TAGIHAN->Visible) { // TAGIHAN ?>
        <th data-name="TAGIHAN" class="<?= $Page->TAGIHAN->headerCellClass() ?>"><div id="elh_V_TREAT_TAGIHAN" class="V_TREAT_TAGIHAN"><?= $Page->renderSort($Page->TAGIHAN) ?></div></th>
<?php } ?>
<?php if ($Page->KOREKSI->Visible) { // KOREKSI ?>
        <th data-name="KOREKSI" class="<?= $Page->KOREKSI->headerCellClass() ?>"><div id="elh_V_TREAT_KOREKSI" class="V_TREAT_KOREKSI"><?= $Page->renderSort($Page->KOREKSI) ?></div></th>
<?php } ?>
<?php if ($Page->AMOUNT_PAID->Visible) { // AMOUNT_PAID ?>
        <th data-name="AMOUNT_PAID" class="<?= $Page->AMOUNT_PAID->headerCellClass() ?>"><div id="elh_V_TREAT_AMOUNT_PAID" class="V_TREAT_AMOUNT_PAID"><?= $Page->renderSort($Page->AMOUNT_PAID) ?></div></th>
<?php } ?>
<?php if ($Page->DISKON->Visible) { // DISKON ?>
        <th data-name="DISKON" class="<?= $Page->DISKON->headerCellClass() ?>"><div id="elh_V_TREAT_DISKON" class="V_TREAT_DISKON"><?= $Page->renderSort($Page->DISKON) ?></div></th>
<?php } ?>
<?php if ($Page->SELL_PRICE->Visible) { // SELL_PRICE ?>
        <th data-name="SELL_PRICE" class="<?= $Page->SELL_PRICE->headerCellClass() ?>"><div id="elh_V_TREAT_SELL_PRICE" class="V_TREAT_SELL_PRICE"><?= $Page->renderSort($Page->SELL_PRICE) ?></div></th>
<?php } ?>
<?php if ($Page->ACCOUNT_ID->Visible) { // ACCOUNT_ID ?>
        <th data-name="ACCOUNT_ID" class="<?= $Page->ACCOUNT_ID->headerCellClass() ?>"><div id="elh_V_TREAT_ACCOUNT_ID" class="V_TREAT_ACCOUNT_ID"><?= $Page->renderSort($Page->ACCOUNT_ID) ?></div></th>
<?php } ?>
<?php if ($Page->subsidi->Visible) { // subsidi ?>
        <th data-name="subsidi" class="<?= $Page->subsidi->headerCellClass() ?>"><div id="elh_V_TREAT_subsidi" class="V_TREAT_subsidi"><?= $Page->renderSort($Page->subsidi) ?></div></th>
<?php } ?>
<?php if ($Page->PROFESI->Visible) { // PROFESI ?>
        <th data-name="PROFESI" class="<?= $Page->PROFESI->headerCellClass() ?>"><div id="elh_V_TREAT_PROFESI" class="V_TREAT_PROFESI"><?= $Page->renderSort($Page->PROFESI) ?></div></th>
<?php } ?>
<?php if ($Page->EMBALACE->Visible) { // EMBALACE ?>
        <th data-name="EMBALACE" class="<?= $Page->EMBALACE->headerCellClass() ?>"><div id="elh_V_TREAT_EMBALACE" class="V_TREAT_EMBALACE"><?= $Page->renderSort($Page->EMBALACE) ?></div></th>
<?php } ?>
<?php if ($Page->DISCOUNT->Visible) { // DISCOUNT ?>
        <th data-name="DISCOUNT" class="<?= $Page->DISCOUNT->headerCellClass() ?>"><div id="elh_V_TREAT_DISCOUNT" class="V_TREAT_DISCOUNT"><?= $Page->renderSort($Page->DISCOUNT) ?></div></th>
<?php } ?>
<?php if ($Page->AMOUNT->Visible) { // AMOUNT ?>
        <th data-name="AMOUNT" class="<?= $Page->AMOUNT->headerCellClass() ?>"><div id="elh_V_TREAT_AMOUNT" class="V_TREAT_AMOUNT"><?= $Page->renderSort($Page->AMOUNT) ?></div></th>
<?php } ?>
<?php if ($Page->PPN->Visible) { // PPN ?>
        <th data-name="PPN" class="<?= $Page->PPN->headerCellClass() ?>"><div id="elh_V_TREAT_PPN" class="V_TREAT_PPN"><?= $Page->renderSort($Page->PPN) ?></div></th>
<?php } ?>
<?php if ($Page->ITER->Visible) { // ITER ?>
        <th data-name="ITER" class="<?= $Page->ITER->headerCellClass() ?>"><div id="elh_V_TREAT_ITER" class="V_TREAT_ITER"><?= $Page->renderSort($Page->ITER) ?></div></th>
<?php } ?>
<?php if ($Page->PAYOR_ID->Visible) { // PAYOR_ID ?>
        <th data-name="PAYOR_ID" class="<?= $Page->PAYOR_ID->headerCellClass() ?>"><div id="elh_V_TREAT_PAYOR_ID" class="V_TREAT_PAYOR_ID"><?= $Page->renderSort($Page->PAYOR_ID) ?></div></th>
<?php } ?>
<?php if ($Page->STATUS_OBAT->Visible) { // STATUS_OBAT ?>
        <th data-name="STATUS_OBAT" class="<?= $Page->STATUS_OBAT->headerCellClass() ?>"><div id="elh_V_TREAT_STATUS_OBAT" class="V_TREAT_STATUS_OBAT"><?= $Page->renderSort($Page->STATUS_OBAT) ?></div></th>
<?php } ?>
<?php if ($Page->SUBSIDISAT->Visible) { // SUBSIDISAT ?>
        <th data-name="SUBSIDISAT" class="<?= $Page->SUBSIDISAT->headerCellClass() ?>"><div id="elh_V_TREAT_SUBSIDISAT" class="V_TREAT_SUBSIDISAT"><?= $Page->renderSort($Page->SUBSIDISAT) ?></div></th>
<?php } ?>
<?php if ($Page->MARGIN->Visible) { // MARGIN ?>
        <th data-name="MARGIN" class="<?= $Page->MARGIN->headerCellClass() ?>"><div id="elh_V_TREAT_MARGIN" class="V_TREAT_MARGIN"><?= $Page->renderSort($Page->MARGIN) ?></div></th>
<?php } ?>
<?php if ($Page->POKOK_JUAL->Visible) { // POKOK_JUAL ?>
        <th data-name="POKOK_JUAL" class="<?= $Page->POKOK_JUAL->headerCellClass() ?>"><div id="elh_V_TREAT_POKOK_JUAL" class="V_TREAT_POKOK_JUAL"><?= $Page->renderSort($Page->POKOK_JUAL) ?></div></th>
<?php } ?>
<?php if ($Page->PRINTQ->Visible) { // PRINTQ ?>
        <th data-name="PRINTQ" class="<?= $Page->PRINTQ->headerCellClass() ?>"><div id="elh_V_TREAT_PRINTQ" class="V_TREAT_PRINTQ"><?= $Page->renderSort($Page->PRINTQ) ?></div></th>
<?php } ?>
<?php if ($Page->PRINTED_BY->Visible) { // PRINTED_BY ?>
        <th data-name="PRINTED_BY" class="<?= $Page->PRINTED_BY->headerCellClass() ?>"><div id="elh_V_TREAT_PRINTED_BY" class="V_TREAT_PRINTED_BY"><?= $Page->renderSort($Page->PRINTED_BY) ?></div></th>
<?php } ?>
<?php if ($Page->STOCK_AVAILABLE->Visible) { // STOCK_AVAILABLE ?>
        <th data-name="STOCK_AVAILABLE" class="<?= $Page->STOCK_AVAILABLE->headerCellClass() ?>"><div id="elh_V_TREAT_STOCK_AVAILABLE" class="V_TREAT_STOCK_AVAILABLE"><?= $Page->renderSort($Page->STOCK_AVAILABLE) ?></div></th>
<?php } ?>
<?php if ($Page->STATUS_TARIF->Visible) { // STATUS_TARIF ?>
        <th data-name="STATUS_TARIF" class="<?= $Page->STATUS_TARIF->headerCellClass() ?>"><div id="elh_V_TREAT_STATUS_TARIF" class="V_TREAT_STATUS_TARIF"><?= $Page->renderSort($Page->STATUS_TARIF) ?></div></th>
<?php } ?>
<?php if ($Page->PACKAGE_ID->Visible) { // PACKAGE_ID ?>
        <th data-name="PACKAGE_ID" class="<?= $Page->PACKAGE_ID->headerCellClass() ?>"><div id="elh_V_TREAT_PACKAGE_ID" class="V_TREAT_PACKAGE_ID"><?= $Page->renderSort($Page->PACKAGE_ID) ?></div></th>
<?php } ?>
<?php if ($Page->MODULE_ID->Visible) { // MODULE_ID ?>
        <th data-name="MODULE_ID" class="<?= $Page->MODULE_ID->headerCellClass() ?>"><div id="elh_V_TREAT_MODULE_ID" class="V_TREAT_MODULE_ID"><?= $Page->renderSort($Page->MODULE_ID) ?></div></th>
<?php } ?>
<?php if ($Page->profession->Visible) { // profession ?>
        <th data-name="profession" class="<?= $Page->profession->headerCellClass() ?>"><div id="elh_V_TREAT_profession" class="V_TREAT_profession"><?= $Page->renderSort($Page->profession) ?></div></th>
<?php } ?>
<?php if ($Page->THEORDER->Visible) { // THEORDER ?>
        <th data-name="THEORDER" class="<?= $Page->THEORDER->headerCellClass() ?>"><div id="elh_V_TREAT_THEORDER" class="V_TREAT_THEORDER"><?= $Page->renderSort($Page->THEORDER) ?></div></th>
<?php } ?>
<?php if ($Page->CORRECTION_ID->Visible) { // CORRECTION_ID ?>
        <th data-name="CORRECTION_ID" class="<?= $Page->CORRECTION_ID->headerCellClass() ?>"><div id="elh_V_TREAT_CORRECTION_ID" class="V_TREAT_CORRECTION_ID"><?= $Page->renderSort($Page->CORRECTION_ID) ?></div></th>
<?php } ?>
<?php if ($Page->CORRECTION_BY->Visible) { // CORRECTION_BY ?>
        <th data-name="CORRECTION_BY" class="<?= $Page->CORRECTION_BY->headerCellClass() ?>"><div id="elh_V_TREAT_CORRECTION_BY" class="V_TREAT_CORRECTION_BY"><?= $Page->renderSort($Page->CORRECTION_BY) ?></div></th>
<?php } ?>
<?php if ($Page->CASHIER->Visible) { // CASHIER ?>
        <th data-name="CASHIER" class="<?= $Page->CASHIER->headerCellClass() ?>"><div id="elh_V_TREAT_CASHIER" class="V_TREAT_CASHIER"><?= $Page->renderSort($Page->CASHIER) ?></div></th>
<?php } ?>
<?php if ($Page->islunas->Visible) { // islunas ?>
        <th data-name="islunas" class="<?= $Page->islunas->headerCellClass() ?>"><div id="elh_V_TREAT_islunas" class="V_TREAT_islunas"><?= $Page->renderSort($Page->islunas) ?></div></th>
<?php } ?>
<?php if ($Page->PAY_METHOD_ID->Visible) { // PAY_METHOD_ID ?>
        <th data-name="PAY_METHOD_ID" class="<?= $Page->PAY_METHOD_ID->headerCellClass() ?>"><div id="elh_V_TREAT_PAY_METHOD_ID" class="V_TREAT_PAY_METHOD_ID"><?= $Page->renderSort($Page->PAY_METHOD_ID) ?></div></th>
<?php } ?>
<?php if ($Page->PAYMENT_DATE->Visible) { // PAYMENT_DATE ?>
        <th data-name="PAYMENT_DATE" class="<?= $Page->PAYMENT_DATE->headerCellClass() ?>"><div id="elh_V_TREAT_PAYMENT_DATE" class="V_TREAT_PAYMENT_DATE"><?= $Page->renderSort($Page->PAYMENT_DATE) ?></div></th>
<?php } ?>
<?php if ($Page->ISCETAK->Visible) { // ISCETAK ?>
        <th data-name="ISCETAK" class="<?= $Page->ISCETAK->headerCellClass() ?>"><div id="elh_V_TREAT_ISCETAK" class="V_TREAT_ISCETAK"><?= $Page->renderSort($Page->ISCETAK) ?></div></th>
<?php } ?>
<?php if ($Page->print_date->Visible) { // print_date ?>
        <th data-name="print_date" class="<?= $Page->print_date->headerCellClass() ?>"><div id="elh_V_TREAT_print_date" class="V_TREAT_print_date"><?= $Page->renderSort($Page->print_date) ?></div></th>
<?php } ?>
<?php if ($Page->DOSE->Visible) { // DOSE ?>
        <th data-name="DOSE" class="<?= $Page->DOSE->headerCellClass() ?>"><div id="elh_V_TREAT_DOSE" class="V_TREAT_DOSE"><?= $Page->renderSort($Page->DOSE) ?></div></th>
<?php } ?>
<?php if ($Page->JML_BKS->Visible) { // JML_BKS ?>
        <th data-name="JML_BKS" class="<?= $Page->JML_BKS->headerCellClass() ?>"><div id="elh_V_TREAT_JML_BKS" class="V_TREAT_JML_BKS"><?= $Page->renderSort($Page->JML_BKS) ?></div></th>
<?php } ?>
<?php if ($Page->ORIG_DOSE->Visible) { // ORIG_DOSE ?>
        <th data-name="ORIG_DOSE" class="<?= $Page->ORIG_DOSE->headerCellClass() ?>"><div id="elh_V_TREAT_ORIG_DOSE" class="V_TREAT_ORIG_DOSE"><?= $Page->renderSort($Page->ORIG_DOSE) ?></div></th>
<?php } ?>
<?php if ($Page->RESEP_KE->Visible) { // RESEP_KE ?>
        <th data-name="RESEP_KE" class="<?= $Page->RESEP_KE->headerCellClass() ?>"><div id="elh_V_TREAT_RESEP_KE" class="V_TREAT_RESEP_KE"><?= $Page->renderSort($Page->RESEP_KE) ?></div></th>
<?php } ?>
<?php if ($Page->ITER_KE->Visible) { // ITER_KE ?>
        <th data-name="ITER_KE" class="<?= $Page->ITER_KE->headerCellClass() ?>"><div id="elh_V_TREAT_ITER_KE" class="V_TREAT_ITER_KE"><?= $Page->renderSort($Page->ITER_KE) ?></div></th>
<?php } ?>
<?php if ($Page->KUITANSI_ID->Visible) { // KUITANSI_ID ?>
        <th data-name="KUITANSI_ID" class="<?= $Page->KUITANSI_ID->headerCellClass() ?>"><div id="elh_V_TREAT_KUITANSI_ID" class="V_TREAT_KUITANSI_ID"><?= $Page->renderSort($Page->KUITANSI_ID) ?></div></th>
<?php } ?>
<?php if ($Page->PEMBULATAN->Visible) { // PEMBULATAN ?>
        <th data-name="PEMBULATAN" class="<?= $Page->PEMBULATAN->headerCellClass() ?>"><div id="elh_V_TREAT_PEMBULATAN" class="V_TREAT_PEMBULATAN"><?= $Page->renderSort($Page->PEMBULATAN) ?></div></th>
<?php } ?>
<?php if ($Page->KAL_ID->Visible) { // KAL_ID ?>
        <th data-name="KAL_ID" class="<?= $Page->KAL_ID->headerCellClass() ?>"><div id="elh_V_TREAT_KAL_ID" class="V_TREAT_KAL_ID"><?= $Page->renderSort($Page->KAL_ID) ?></div></th>
<?php } ?>
<?php if ($Page->INVOICE_ID->Visible) { // INVOICE_ID ?>
        <th data-name="INVOICE_ID" class="<?= $Page->INVOICE_ID->headerCellClass() ?>"><div id="elh_V_TREAT_INVOICE_ID" class="V_TREAT_INVOICE_ID"><?= $Page->renderSort($Page->INVOICE_ID) ?></div></th>
<?php } ?>
<?php if ($Page->SERVICE_TIME->Visible) { // SERVICE_TIME ?>
        <th data-name="SERVICE_TIME" class="<?= $Page->SERVICE_TIME->headerCellClass() ?>"><div id="elh_V_TREAT_SERVICE_TIME" class="V_TREAT_SERVICE_TIME"><?= $Page->renderSort($Page->SERVICE_TIME) ?></div></th>
<?php } ?>
<?php if ($Page->TAKEN_TIME->Visible) { // TAKEN_TIME ?>
        <th data-name="TAKEN_TIME" class="<?= $Page->TAKEN_TIME->headerCellClass() ?>"><div id="elh_V_TREAT_TAKEN_TIME" class="V_TREAT_TAKEN_TIME"><?= $Page->renderSort($Page->TAKEN_TIME) ?></div></th>
<?php } ?>
<?php if ($Page->modified_datesys->Visible) { // modified_datesys ?>
        <th data-name="modified_datesys" class="<?= $Page->modified_datesys->headerCellClass() ?>"><div id="elh_V_TREAT_modified_datesys" class="V_TREAT_modified_datesys"><?= $Page->renderSort($Page->modified_datesys) ?></div></th>
<?php } ?>
<?php if ($Page->TRANS_ID->Visible) { // TRANS_ID ?>
        <th data-name="TRANS_ID" class="<?= $Page->TRANS_ID->headerCellClass() ?>"><div id="elh_V_TREAT_TRANS_ID" class="V_TREAT_TRANS_ID"><?= $Page->renderSort($Page->TRANS_ID) ?></div></th>
<?php } ?>
<?php if ($Page->SPPBILL->Visible) { // SPPBILL ?>
        <th data-name="SPPBILL" class="<?= $Page->SPPBILL->headerCellClass() ?>"><div id="elh_V_TREAT_SPPBILL" class="V_TREAT_SPPBILL"><?= $Page->renderSort($Page->SPPBILL) ?></div></th>
<?php } ?>
<?php if ($Page->SPPBILLDATE->Visible) { // SPPBILLDATE ?>
        <th data-name="SPPBILLDATE" class="<?= $Page->SPPBILLDATE->headerCellClass() ?>"><div id="elh_V_TREAT_SPPBILLDATE" class="V_TREAT_SPPBILLDATE"><?= $Page->renderSort($Page->SPPBILLDATE) ?></div></th>
<?php } ?>
<?php if ($Page->SPPBILLUSER->Visible) { // SPPBILLUSER ?>
        <th data-name="SPPBILLUSER" class="<?= $Page->SPPBILLUSER->headerCellClass() ?>"><div id="elh_V_TREAT_SPPBILLUSER" class="V_TREAT_SPPBILLUSER"><?= $Page->renderSort($Page->SPPBILLUSER) ?></div></th>
<?php } ?>
<?php if ($Page->SPPKASIR->Visible) { // SPPKASIR ?>
        <th data-name="SPPKASIR" class="<?= $Page->SPPKASIR->headerCellClass() ?>"><div id="elh_V_TREAT_SPPKASIR" class="V_TREAT_SPPKASIR"><?= $Page->renderSort($Page->SPPKASIR) ?></div></th>
<?php } ?>
<?php if ($Page->SPPKASIRDATE->Visible) { // SPPKASIRDATE ?>
        <th data-name="SPPKASIRDATE" class="<?= $Page->SPPKASIRDATE->headerCellClass() ?>"><div id="elh_V_TREAT_SPPKASIRDATE" class="V_TREAT_SPPKASIRDATE"><?= $Page->renderSort($Page->SPPKASIRDATE) ?></div></th>
<?php } ?>
<?php if ($Page->SPPKASIRUSER->Visible) { // SPPKASIRUSER ?>
        <th data-name="SPPKASIRUSER" class="<?= $Page->SPPKASIRUSER->headerCellClass() ?>"><div id="elh_V_TREAT_SPPKASIRUSER" class="V_TREAT_SPPKASIRUSER"><?= $Page->renderSort($Page->SPPKASIRUSER) ?></div></th>
<?php } ?>
<?php if ($Page->SPPPOLI->Visible) { // SPPPOLI ?>
        <th data-name="SPPPOLI" class="<?= $Page->SPPPOLI->headerCellClass() ?>"><div id="elh_V_TREAT_SPPPOLI" class="V_TREAT_SPPPOLI"><?= $Page->renderSort($Page->SPPPOLI) ?></div></th>
<?php } ?>
<?php if ($Page->SPPPOLIUSER->Visible) { // SPPPOLIUSER ?>
        <th data-name="SPPPOLIUSER" class="<?= $Page->SPPPOLIUSER->headerCellClass() ?>"><div id="elh_V_TREAT_SPPPOLIUSER" class="V_TREAT_SPPPOLIUSER"><?= $Page->renderSort($Page->SPPPOLIUSER) ?></div></th>
<?php } ?>
<?php if ($Page->SPPPOLIDATE->Visible) { // SPPPOLIDATE ?>
        <th data-name="SPPPOLIDATE" class="<?= $Page->SPPPOLIDATE->headerCellClass() ?>"><div id="elh_V_TREAT_SPPPOLIDATE" class="V_TREAT_SPPPOLIDATE"><?= $Page->renderSort($Page->SPPPOLIDATE) ?></div></th>
<?php } ?>
<?php if ($Page->NOSEP->Visible) { // NOSEP ?>
        <th data-name="NOSEP" class="<?= $Page->NOSEP->headerCellClass() ?>"><div id="elh_V_TREAT_NOSEP" class="V_TREAT_NOSEP"><?= $Page->renderSort($Page->NOSEP) ?></div></th>
<?php } ?>
<?php if ($Page->ID->Visible) { // ID ?>
        <th data-name="ID" class="<?= $Page->ID->headerCellClass() ?>"><div id="elh_V_TREAT_ID" class="V_TREAT_ID"><?= $Page->renderSort($Page->ID) ?></div></th>
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_V_TREAT", "data-rowtype" => $Page->RowType]);

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
<span id="el<?= $Page->RowCount ?>_V_TREAT_ORG_UNIT_CODE">
<span<?= $Page->ORG_UNIT_CODE->viewAttributes() ?>>
<?= $Page->ORG_UNIT_CODE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->BILL_ID->Visible) { // BILL_ID ?>
        <td data-name="BILL_ID" <?= $Page->BILL_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_BILL_ID">
<span<?= $Page->BILL_ID->viewAttributes() ?>>
<?= $Page->BILL_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->NO_REGISTRATION->Visible) { // NO_REGISTRATION ?>
        <td data-name="NO_REGISTRATION" <?= $Page->NO_REGISTRATION->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_NO_REGISTRATION">
<span<?= $Page->NO_REGISTRATION->viewAttributes() ?>>
<?= $Page->NO_REGISTRATION->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->VISIT_ID->Visible) { // VISIT_ID ?>
        <td data-name="VISIT_ID" <?= $Page->VISIT_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_VISIT_ID">
<span<?= $Page->VISIT_ID->viewAttributes() ?>>
<?= $Page->VISIT_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->TARIF_ID->Visible) { // TARIF_ID ?>
        <td data-name="TARIF_ID" <?= $Page->TARIF_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_TARIF_ID">
<span<?= $Page->TARIF_ID->viewAttributes() ?>>
<?= $Page->TARIF_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->CLASS_ID->Visible) { // CLASS_ID ?>
        <td data-name="CLASS_ID" <?= $Page->CLASS_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_CLASS_ID">
<span<?= $Page->CLASS_ID->viewAttributes() ?>>
<?= $Page->CLASS_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->CLINIC_ID->Visible) { // CLINIC_ID ?>
        <td data-name="CLINIC_ID" <?= $Page->CLINIC_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_CLINIC_ID">
<span<?= $Page->CLINIC_ID->viewAttributes() ?>>
<?= $Page->CLINIC_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->CLINIC_ID_FROM->Visible) { // CLINIC_ID_FROM ?>
        <td data-name="CLINIC_ID_FROM" <?= $Page->CLINIC_ID_FROM->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_CLINIC_ID_FROM">
<span<?= $Page->CLINIC_ID_FROM->viewAttributes() ?>>
<?= $Page->CLINIC_ID_FROM->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->TREATMENT->Visible) { // TREATMENT ?>
        <td data-name="TREATMENT" <?= $Page->TREATMENT->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_TREATMENT">
<span<?= $Page->TREATMENT->viewAttributes() ?>>
<?= $Page->TREATMENT->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->TREAT_DATE->Visible) { // TREAT_DATE ?>
        <td data-name="TREAT_DATE" <?= $Page->TREAT_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_TREAT_DATE">
<span<?= $Page->TREAT_DATE->viewAttributes() ?>>
<?= $Page->TREAT_DATE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->QUANTITY->Visible) { // QUANTITY ?>
        <td data-name="QUANTITY" <?= $Page->QUANTITY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_QUANTITY">
<span<?= $Page->QUANTITY->viewAttributes() ?>>
<?= $Page->QUANTITY->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->MEASURE_ID->Visible) { // MEASURE_ID ?>
        <td data-name="MEASURE_ID" <?= $Page->MEASURE_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_MEASURE_ID">
<span<?= $Page->MEASURE_ID->viewAttributes() ?>>
<?= $Page->MEASURE_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->DESCRIPTION->Visible) { // DESCRIPTION ?>
        <td data-name="DESCRIPTION" <?= $Page->DESCRIPTION->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_DESCRIPTION">
<span<?= $Page->DESCRIPTION->viewAttributes() ?>>
<?= $Page->DESCRIPTION->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->RESEP_NO->Visible) { // RESEP_NO ?>
        <td data-name="RESEP_NO" <?= $Page->RESEP_NO->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_RESEP_NO">
<span<?= $Page->RESEP_NO->viewAttributes() ?>>
<?= $Page->RESEP_NO->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->DOSE_PRESC->Visible) { // DOSE_PRESC ?>
        <td data-name="DOSE_PRESC" <?= $Page->DOSE_PRESC->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_DOSE_PRESC">
<span<?= $Page->DOSE_PRESC->viewAttributes() ?>>
<?= $Page->DOSE_PRESC->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->SOLD_STATUS->Visible) { // SOLD_STATUS ?>
        <td data-name="SOLD_STATUS" <?= $Page->SOLD_STATUS->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_SOLD_STATUS">
<span<?= $Page->SOLD_STATUS->viewAttributes() ?>>
<?= $Page->SOLD_STATUS->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->RACIKAN->Visible) { // RACIKAN ?>
        <td data-name="RACIKAN" <?= $Page->RACIKAN->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_RACIKAN">
<span<?= $Page->RACIKAN->viewAttributes() ?>>
<?= $Page->RACIKAN->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->CLASS_ROOM_ID->Visible) { // CLASS_ROOM_ID ?>
        <td data-name="CLASS_ROOM_ID" <?= $Page->CLASS_ROOM_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_CLASS_ROOM_ID">
<span<?= $Page->CLASS_ROOM_ID->viewAttributes() ?>>
<?= $Page->CLASS_ROOM_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->KELUAR_ID->Visible) { // KELUAR_ID ?>
        <td data-name="KELUAR_ID" <?= $Page->KELUAR_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_KELUAR_ID">
<span<?= $Page->KELUAR_ID->viewAttributes() ?>>
<?= $Page->KELUAR_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->BED_ID->Visible) { // BED_ID ?>
        <td data-name="BED_ID" <?= $Page->BED_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_BED_ID">
<span<?= $Page->BED_ID->viewAttributes() ?>>
<?= $Page->BED_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->EMPLOYEE_ID->Visible) { // EMPLOYEE_ID ?>
        <td data-name="EMPLOYEE_ID" <?= $Page->EMPLOYEE_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_EMPLOYEE_ID">
<span<?= $Page->EMPLOYEE_ID->viewAttributes() ?>>
<?= $Page->EMPLOYEE_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->DESCRIPTION2->Visible) { // DESCRIPTION2 ?>
        <td data-name="DESCRIPTION2" <?= $Page->DESCRIPTION2->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_DESCRIPTION2">
<span<?= $Page->DESCRIPTION2->viewAttributes() ?>>
<?= $Page->DESCRIPTION2->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->BRAND_ID->Visible) { // BRAND_ID ?>
        <td data-name="BRAND_ID" <?= $Page->BRAND_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_BRAND_ID">
<span<?= $Page->BRAND_ID->viewAttributes() ?>>
<?= $Page->BRAND_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->DOCTOR->Visible) { // DOCTOR ?>
        <td data-name="DOCTOR" <?= $Page->DOCTOR->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_DOCTOR">
<span<?= $Page->DOCTOR->viewAttributes() ?>>
<?= $Page->DOCTOR->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->EXIT_DATE->Visible) { // EXIT_DATE ?>
        <td data-name="EXIT_DATE" <?= $Page->EXIT_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_EXIT_DATE">
<span<?= $Page->EXIT_DATE->viewAttributes() ?>>
<?= $Page->EXIT_DATE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->EMPLOYEE_ID_FROM->Visible) { // EMPLOYEE_ID_FROM ?>
        <td data-name="EMPLOYEE_ID_FROM" <?= $Page->EMPLOYEE_ID_FROM->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_EMPLOYEE_ID_FROM">
<span<?= $Page->EMPLOYEE_ID_FROM->viewAttributes() ?>>
<?= $Page->EMPLOYEE_ID_FROM->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->DOCTOR_FROM->Visible) { // DOCTOR_FROM ?>
        <td data-name="DOCTOR_FROM" <?= $Page->DOCTOR_FROM->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_DOCTOR_FROM">
<span<?= $Page->DOCTOR_FROM->viewAttributes() ?>>
<?= $Page->DOCTOR_FROM->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->status_pasien_id->Visible) { // status_pasien_id ?>
        <td data-name="status_pasien_id" <?= $Page->status_pasien_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_status_pasien_id">
<span<?= $Page->status_pasien_id->viewAttributes() ?>>
<?= $Page->status_pasien_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->THENAME->Visible) { // THENAME ?>
        <td data-name="THENAME" <?= $Page->THENAME->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_THENAME">
<span<?= $Page->THENAME->viewAttributes() ?>>
<?= $Page->THENAME->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->THEADDRESS->Visible) { // THEADDRESS ?>
        <td data-name="THEADDRESS" <?= $Page->THEADDRESS->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_THEADDRESS">
<span<?= $Page->THEADDRESS->viewAttributes() ?>>
<?= $Page->THEADDRESS->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->THEID->Visible) { // THEID ?>
        <td data-name="THEID" <?= $Page->THEID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_THEID">
<span<?= $Page->THEID->viewAttributes() ?>>
<?= $Page->THEID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->SERIAL_NB->Visible) { // SERIAL_NB ?>
        <td data-name="SERIAL_NB" <?= $Page->SERIAL_NB->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_SERIAL_NB">
<span<?= $Page->SERIAL_NB->viewAttributes() ?>>
<?= $Page->SERIAL_NB->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ISRJ->Visible) { // ISRJ ?>
        <td data-name="ISRJ" <?= $Page->ISRJ->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_ISRJ">
<span<?= $Page->ISRJ->viewAttributes() ?>>
<?= $Page->ISRJ->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->AGEYEAR->Visible) { // AGEYEAR ?>
        <td data-name="AGEYEAR" <?= $Page->AGEYEAR->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_AGEYEAR">
<span<?= $Page->AGEYEAR->viewAttributes() ?>>
<?= $Page->AGEYEAR->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->AGEMONTH->Visible) { // AGEMONTH ?>
        <td data-name="AGEMONTH" <?= $Page->AGEMONTH->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_AGEMONTH">
<span<?= $Page->AGEMONTH->viewAttributes() ?>>
<?= $Page->AGEMONTH->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->AGEDAY->Visible) { // AGEDAY ?>
        <td data-name="AGEDAY" <?= $Page->AGEDAY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_AGEDAY">
<span<?= $Page->AGEDAY->viewAttributes() ?>>
<?= $Page->AGEDAY->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->GENDER->Visible) { // GENDER ?>
        <td data-name="GENDER" <?= $Page->GENDER->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_GENDER">
<span<?= $Page->GENDER->viewAttributes() ?>>
<?= $Page->GENDER->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->KARYAWAN->Visible) { // KARYAWAN ?>
        <td data-name="KARYAWAN" <?= $Page->KARYAWAN->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_KARYAWAN">
<span<?= $Page->KARYAWAN->viewAttributes() ?>>
<?= $Page->KARYAWAN->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
        <td data-name="MODIFIED_BY" <?= $Page->MODIFIED_BY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_MODIFIED_BY">
<span<?= $Page->MODIFIED_BY->viewAttributes() ?>>
<?= $Page->MODIFIED_BY->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
        <td data-name="MODIFIED_DATE" <?= $Page->MODIFIED_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_MODIFIED_DATE">
<span<?= $Page->MODIFIED_DATE->viewAttributes() ?>>
<?= $Page->MODIFIED_DATE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->MODIFIED_FROM->Visible) { // MODIFIED_FROM ?>
        <td data-name="MODIFIED_FROM" <?= $Page->MODIFIED_FROM->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_MODIFIED_FROM">
<span<?= $Page->MODIFIED_FROM->viewAttributes() ?>>
<?= $Page->MODIFIED_FROM->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->NUMER->Visible) { // NUMER ?>
        <td data-name="NUMER" <?= $Page->NUMER->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_NUMER">
<span<?= $Page->NUMER->viewAttributes() ?>>
<?= $Page->NUMER->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->NOTA_NO->Visible) { // NOTA_NO ?>
        <td data-name="NOTA_NO" <?= $Page->NOTA_NO->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_NOTA_NO">
<span<?= $Page->NOTA_NO->viewAttributes() ?>>
<?= $Page->NOTA_NO->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->MEASURE_ID2->Visible) { // MEASURE_ID2 ?>
        <td data-name="MEASURE_ID2" <?= $Page->MEASURE_ID2->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_MEASURE_ID2">
<span<?= $Page->MEASURE_ID2->viewAttributes() ?>>
<?= $Page->MEASURE_ID2->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->POTONGAN->Visible) { // POTONGAN ?>
        <td data-name="POTONGAN" <?= $Page->POTONGAN->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_POTONGAN">
<span<?= $Page->POTONGAN->viewAttributes() ?>>
<?= $Page->POTONGAN->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->BAYAR->Visible) { // BAYAR ?>
        <td data-name="BAYAR" <?= $Page->BAYAR->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_BAYAR">
<span<?= $Page->BAYAR->viewAttributes() ?>>
<?= $Page->BAYAR->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->RETUR->Visible) { // RETUR ?>
        <td data-name="RETUR" <?= $Page->RETUR->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_RETUR">
<span<?= $Page->RETUR->viewAttributes() ?>>
<?= $Page->RETUR->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->TARIF_TYPE->Visible) { // TARIF_TYPE ?>
        <td data-name="TARIF_TYPE" <?= $Page->TARIF_TYPE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_TARIF_TYPE">
<span<?= $Page->TARIF_TYPE->viewAttributes() ?>>
<?= $Page->TARIF_TYPE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PPNVALUE->Visible) { // PPNVALUE ?>
        <td data-name="PPNVALUE" <?= $Page->PPNVALUE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_PPNVALUE">
<span<?= $Page->PPNVALUE->viewAttributes() ?>>
<?= $Page->PPNVALUE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->TAGIHAN->Visible) { // TAGIHAN ?>
        <td data-name="TAGIHAN" <?= $Page->TAGIHAN->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_TAGIHAN">
<span<?= $Page->TAGIHAN->viewAttributes() ?>>
<?= $Page->TAGIHAN->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->KOREKSI->Visible) { // KOREKSI ?>
        <td data-name="KOREKSI" <?= $Page->KOREKSI->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_KOREKSI">
<span<?= $Page->KOREKSI->viewAttributes() ?>>
<?= $Page->KOREKSI->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->AMOUNT_PAID->Visible) { // AMOUNT_PAID ?>
        <td data-name="AMOUNT_PAID" <?= $Page->AMOUNT_PAID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_AMOUNT_PAID">
<span<?= $Page->AMOUNT_PAID->viewAttributes() ?>>
<?= $Page->AMOUNT_PAID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->DISKON->Visible) { // DISKON ?>
        <td data-name="DISKON" <?= $Page->DISKON->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_DISKON">
<span<?= $Page->DISKON->viewAttributes() ?>>
<?= $Page->DISKON->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->SELL_PRICE->Visible) { // SELL_PRICE ?>
        <td data-name="SELL_PRICE" <?= $Page->SELL_PRICE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_SELL_PRICE">
<span<?= $Page->SELL_PRICE->viewAttributes() ?>>
<?= $Page->SELL_PRICE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ACCOUNT_ID->Visible) { // ACCOUNT_ID ?>
        <td data-name="ACCOUNT_ID" <?= $Page->ACCOUNT_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_ACCOUNT_ID">
<span<?= $Page->ACCOUNT_ID->viewAttributes() ?>>
<?= $Page->ACCOUNT_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->subsidi->Visible) { // subsidi ?>
        <td data-name="subsidi" <?= $Page->subsidi->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_subsidi">
<span<?= $Page->subsidi->viewAttributes() ?>>
<?= $Page->subsidi->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PROFESI->Visible) { // PROFESI ?>
        <td data-name="PROFESI" <?= $Page->PROFESI->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_PROFESI">
<span<?= $Page->PROFESI->viewAttributes() ?>>
<?= $Page->PROFESI->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->EMBALACE->Visible) { // EMBALACE ?>
        <td data-name="EMBALACE" <?= $Page->EMBALACE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_EMBALACE">
<span<?= $Page->EMBALACE->viewAttributes() ?>>
<?= $Page->EMBALACE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->DISCOUNT->Visible) { // DISCOUNT ?>
        <td data-name="DISCOUNT" <?= $Page->DISCOUNT->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_DISCOUNT">
<span<?= $Page->DISCOUNT->viewAttributes() ?>>
<?= $Page->DISCOUNT->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->AMOUNT->Visible) { // AMOUNT ?>
        <td data-name="AMOUNT" <?= $Page->AMOUNT->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_AMOUNT">
<span<?= $Page->AMOUNT->viewAttributes() ?>>
<?= $Page->AMOUNT->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PPN->Visible) { // PPN ?>
        <td data-name="PPN" <?= $Page->PPN->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_PPN">
<span<?= $Page->PPN->viewAttributes() ?>>
<?= $Page->PPN->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ITER->Visible) { // ITER ?>
        <td data-name="ITER" <?= $Page->ITER->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_ITER">
<span<?= $Page->ITER->viewAttributes() ?>>
<?= $Page->ITER->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PAYOR_ID->Visible) { // PAYOR_ID ?>
        <td data-name="PAYOR_ID" <?= $Page->PAYOR_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_PAYOR_ID">
<span<?= $Page->PAYOR_ID->viewAttributes() ?>>
<?= $Page->PAYOR_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->STATUS_OBAT->Visible) { // STATUS_OBAT ?>
        <td data-name="STATUS_OBAT" <?= $Page->STATUS_OBAT->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_STATUS_OBAT">
<span<?= $Page->STATUS_OBAT->viewAttributes() ?>>
<?= $Page->STATUS_OBAT->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->SUBSIDISAT->Visible) { // SUBSIDISAT ?>
        <td data-name="SUBSIDISAT" <?= $Page->SUBSIDISAT->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_SUBSIDISAT">
<span<?= $Page->SUBSIDISAT->viewAttributes() ?>>
<?= $Page->SUBSIDISAT->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->MARGIN->Visible) { // MARGIN ?>
        <td data-name="MARGIN" <?= $Page->MARGIN->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_MARGIN">
<span<?= $Page->MARGIN->viewAttributes() ?>>
<?= $Page->MARGIN->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->POKOK_JUAL->Visible) { // POKOK_JUAL ?>
        <td data-name="POKOK_JUAL" <?= $Page->POKOK_JUAL->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_POKOK_JUAL">
<span<?= $Page->POKOK_JUAL->viewAttributes() ?>>
<?= $Page->POKOK_JUAL->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PRINTQ->Visible) { // PRINTQ ?>
        <td data-name="PRINTQ" <?= $Page->PRINTQ->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_PRINTQ">
<span<?= $Page->PRINTQ->viewAttributes() ?>>
<?= $Page->PRINTQ->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PRINTED_BY->Visible) { // PRINTED_BY ?>
        <td data-name="PRINTED_BY" <?= $Page->PRINTED_BY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_PRINTED_BY">
<span<?= $Page->PRINTED_BY->viewAttributes() ?>>
<?= $Page->PRINTED_BY->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->STOCK_AVAILABLE->Visible) { // STOCK_AVAILABLE ?>
        <td data-name="STOCK_AVAILABLE" <?= $Page->STOCK_AVAILABLE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_STOCK_AVAILABLE">
<span<?= $Page->STOCK_AVAILABLE->viewAttributes() ?>>
<?= $Page->STOCK_AVAILABLE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->STATUS_TARIF->Visible) { // STATUS_TARIF ?>
        <td data-name="STATUS_TARIF" <?= $Page->STATUS_TARIF->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_STATUS_TARIF">
<span<?= $Page->STATUS_TARIF->viewAttributes() ?>>
<?= $Page->STATUS_TARIF->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PACKAGE_ID->Visible) { // PACKAGE_ID ?>
        <td data-name="PACKAGE_ID" <?= $Page->PACKAGE_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_PACKAGE_ID">
<span<?= $Page->PACKAGE_ID->viewAttributes() ?>>
<?= $Page->PACKAGE_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->MODULE_ID->Visible) { // MODULE_ID ?>
        <td data-name="MODULE_ID" <?= $Page->MODULE_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_MODULE_ID">
<span<?= $Page->MODULE_ID->viewAttributes() ?>>
<?= $Page->MODULE_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->profession->Visible) { // profession ?>
        <td data-name="profession" <?= $Page->profession->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_profession">
<span<?= $Page->profession->viewAttributes() ?>>
<?= $Page->profession->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->THEORDER->Visible) { // THEORDER ?>
        <td data-name="THEORDER" <?= $Page->THEORDER->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_THEORDER">
<span<?= $Page->THEORDER->viewAttributes() ?>>
<?= $Page->THEORDER->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->CORRECTION_ID->Visible) { // CORRECTION_ID ?>
        <td data-name="CORRECTION_ID" <?= $Page->CORRECTION_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_CORRECTION_ID">
<span<?= $Page->CORRECTION_ID->viewAttributes() ?>>
<?= $Page->CORRECTION_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->CORRECTION_BY->Visible) { // CORRECTION_BY ?>
        <td data-name="CORRECTION_BY" <?= $Page->CORRECTION_BY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_CORRECTION_BY">
<span<?= $Page->CORRECTION_BY->viewAttributes() ?>>
<?= $Page->CORRECTION_BY->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->CASHIER->Visible) { // CASHIER ?>
        <td data-name="CASHIER" <?= $Page->CASHIER->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_CASHIER">
<span<?= $Page->CASHIER->viewAttributes() ?>>
<?= $Page->CASHIER->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->islunas->Visible) { // islunas ?>
        <td data-name="islunas" <?= $Page->islunas->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_islunas">
<span<?= $Page->islunas->viewAttributes() ?>>
<?= $Page->islunas->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PAY_METHOD_ID->Visible) { // PAY_METHOD_ID ?>
        <td data-name="PAY_METHOD_ID" <?= $Page->PAY_METHOD_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_PAY_METHOD_ID">
<span<?= $Page->PAY_METHOD_ID->viewAttributes() ?>>
<?= $Page->PAY_METHOD_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PAYMENT_DATE->Visible) { // PAYMENT_DATE ?>
        <td data-name="PAYMENT_DATE" <?= $Page->PAYMENT_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_PAYMENT_DATE">
<span<?= $Page->PAYMENT_DATE->viewAttributes() ?>>
<?= $Page->PAYMENT_DATE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ISCETAK->Visible) { // ISCETAK ?>
        <td data-name="ISCETAK" <?= $Page->ISCETAK->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_ISCETAK">
<span<?= $Page->ISCETAK->viewAttributes() ?>>
<?= $Page->ISCETAK->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->print_date->Visible) { // print_date ?>
        <td data-name="print_date" <?= $Page->print_date->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_print_date">
<span<?= $Page->print_date->viewAttributes() ?>>
<?= $Page->print_date->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->DOSE->Visible) { // DOSE ?>
        <td data-name="DOSE" <?= $Page->DOSE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_DOSE">
<span<?= $Page->DOSE->viewAttributes() ?>>
<?= $Page->DOSE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->JML_BKS->Visible) { // JML_BKS ?>
        <td data-name="JML_BKS" <?= $Page->JML_BKS->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_JML_BKS">
<span<?= $Page->JML_BKS->viewAttributes() ?>>
<?= $Page->JML_BKS->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ORIG_DOSE->Visible) { // ORIG_DOSE ?>
        <td data-name="ORIG_DOSE" <?= $Page->ORIG_DOSE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_ORIG_DOSE">
<span<?= $Page->ORIG_DOSE->viewAttributes() ?>>
<?= $Page->ORIG_DOSE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->RESEP_KE->Visible) { // RESEP_KE ?>
        <td data-name="RESEP_KE" <?= $Page->RESEP_KE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_RESEP_KE">
<span<?= $Page->RESEP_KE->viewAttributes() ?>>
<?= $Page->RESEP_KE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ITER_KE->Visible) { // ITER_KE ?>
        <td data-name="ITER_KE" <?= $Page->ITER_KE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_ITER_KE">
<span<?= $Page->ITER_KE->viewAttributes() ?>>
<?= $Page->ITER_KE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->KUITANSI_ID->Visible) { // KUITANSI_ID ?>
        <td data-name="KUITANSI_ID" <?= $Page->KUITANSI_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_KUITANSI_ID">
<span<?= $Page->KUITANSI_ID->viewAttributes() ?>>
<?= $Page->KUITANSI_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PEMBULATAN->Visible) { // PEMBULATAN ?>
        <td data-name="PEMBULATAN" <?= $Page->PEMBULATAN->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_PEMBULATAN">
<span<?= $Page->PEMBULATAN->viewAttributes() ?>>
<?= $Page->PEMBULATAN->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->KAL_ID->Visible) { // KAL_ID ?>
        <td data-name="KAL_ID" <?= $Page->KAL_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_KAL_ID">
<span<?= $Page->KAL_ID->viewAttributes() ?>>
<?= $Page->KAL_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->INVOICE_ID->Visible) { // INVOICE_ID ?>
        <td data-name="INVOICE_ID" <?= $Page->INVOICE_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_INVOICE_ID">
<span<?= $Page->INVOICE_ID->viewAttributes() ?>>
<?= $Page->INVOICE_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->SERVICE_TIME->Visible) { // SERVICE_TIME ?>
        <td data-name="SERVICE_TIME" <?= $Page->SERVICE_TIME->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_SERVICE_TIME">
<span<?= $Page->SERVICE_TIME->viewAttributes() ?>>
<?= $Page->SERVICE_TIME->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->TAKEN_TIME->Visible) { // TAKEN_TIME ?>
        <td data-name="TAKEN_TIME" <?= $Page->TAKEN_TIME->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_TAKEN_TIME">
<span<?= $Page->TAKEN_TIME->viewAttributes() ?>>
<?= $Page->TAKEN_TIME->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->modified_datesys->Visible) { // modified_datesys ?>
        <td data-name="modified_datesys" <?= $Page->modified_datesys->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_modified_datesys">
<span<?= $Page->modified_datesys->viewAttributes() ?>>
<?= $Page->modified_datesys->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->TRANS_ID->Visible) { // TRANS_ID ?>
        <td data-name="TRANS_ID" <?= $Page->TRANS_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_TRANS_ID">
<span<?= $Page->TRANS_ID->viewAttributes() ?>>
<?= $Page->TRANS_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->SPPBILL->Visible) { // SPPBILL ?>
        <td data-name="SPPBILL" <?= $Page->SPPBILL->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_SPPBILL">
<span<?= $Page->SPPBILL->viewAttributes() ?>>
<?= $Page->SPPBILL->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->SPPBILLDATE->Visible) { // SPPBILLDATE ?>
        <td data-name="SPPBILLDATE" <?= $Page->SPPBILLDATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_SPPBILLDATE">
<span<?= $Page->SPPBILLDATE->viewAttributes() ?>>
<?= $Page->SPPBILLDATE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->SPPBILLUSER->Visible) { // SPPBILLUSER ?>
        <td data-name="SPPBILLUSER" <?= $Page->SPPBILLUSER->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_SPPBILLUSER">
<span<?= $Page->SPPBILLUSER->viewAttributes() ?>>
<?= $Page->SPPBILLUSER->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->SPPKASIR->Visible) { // SPPKASIR ?>
        <td data-name="SPPKASIR" <?= $Page->SPPKASIR->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_SPPKASIR">
<span<?= $Page->SPPKASIR->viewAttributes() ?>>
<?= $Page->SPPKASIR->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->SPPKASIRDATE->Visible) { // SPPKASIRDATE ?>
        <td data-name="SPPKASIRDATE" <?= $Page->SPPKASIRDATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_SPPKASIRDATE">
<span<?= $Page->SPPKASIRDATE->viewAttributes() ?>>
<?= $Page->SPPKASIRDATE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->SPPKASIRUSER->Visible) { // SPPKASIRUSER ?>
        <td data-name="SPPKASIRUSER" <?= $Page->SPPKASIRUSER->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_SPPKASIRUSER">
<span<?= $Page->SPPKASIRUSER->viewAttributes() ?>>
<?= $Page->SPPKASIRUSER->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->SPPPOLI->Visible) { // SPPPOLI ?>
        <td data-name="SPPPOLI" <?= $Page->SPPPOLI->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_SPPPOLI">
<span<?= $Page->SPPPOLI->viewAttributes() ?>>
<?= $Page->SPPPOLI->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->SPPPOLIUSER->Visible) { // SPPPOLIUSER ?>
        <td data-name="SPPPOLIUSER" <?= $Page->SPPPOLIUSER->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_SPPPOLIUSER">
<span<?= $Page->SPPPOLIUSER->viewAttributes() ?>>
<?= $Page->SPPPOLIUSER->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->SPPPOLIDATE->Visible) { // SPPPOLIDATE ?>
        <td data-name="SPPPOLIDATE" <?= $Page->SPPPOLIDATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_SPPPOLIDATE">
<span<?= $Page->SPPPOLIDATE->viewAttributes() ?>>
<?= $Page->SPPPOLIDATE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->NOSEP->Visible) { // NOSEP ?>
        <td data-name="NOSEP" <?= $Page->NOSEP->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_NOSEP">
<span<?= $Page->NOSEP->viewAttributes() ?>>
<?= $Page->NOSEP->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ID->Visible) { // ID ?>
        <td data-name="ID" <?= $Page->ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREAT_ID">
<span<?= $Page->ID->viewAttributes() ?>>
<?= $Page->ID->getViewValue() ?></span>
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
    ew.addEventHandlers("V_TREAT");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
