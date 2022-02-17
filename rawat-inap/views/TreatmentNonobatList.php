<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

// Page object
$TreatmentNonobatList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fTREATMENT_NONOBATlist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fTREATMENT_NONOBATlist = currentForm = new ew.Form("fTREATMENT_NONOBATlist", "list");
    fTREATMENT_NONOBATlist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("fTREATMENT_NONOBATlist");
});
var fTREATMENT_NONOBATlistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    fTREATMENT_NONOBATlistsrch = currentSearchForm = new ew.Form("fTREATMENT_NONOBATlistsrch");

    // Dynamic selection lists

    // Filters
    fTREATMENT_NONOBATlistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fTREATMENT_NONOBATlistsrch");
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
<form name="fTREATMENT_NONOBATlistsrch" id="fTREATMENT_NONOBATlistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fTREATMENT_NONOBATlistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="TREATMENT_NONOBAT">
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> TREATMENT_NONOBAT">
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
<form name="fTREATMENT_NONOBATlist" id="fTREATMENT_NONOBATlist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="TREATMENT_NONOBAT">
<div id="gmp_TREATMENT_NONOBAT" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_TREATMENT_NONOBATlist" class="table ew-table"><!-- .ew-table -->
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
        <th data-name="ORG_UNIT_CODE" class="<?= $Page->ORG_UNIT_CODE->headerCellClass() ?>"><div id="elh_TREATMENT_NONOBAT_ORG_UNIT_CODE" class="TREATMENT_NONOBAT_ORG_UNIT_CODE"><?= $Page->renderSort($Page->ORG_UNIT_CODE) ?></div></th>
<?php } ?>
<?php if ($Page->BILL_ID->Visible) { // BILL_ID ?>
        <th data-name="BILL_ID" class="<?= $Page->BILL_ID->headerCellClass() ?>"><div id="elh_TREATMENT_NONOBAT_BILL_ID" class="TREATMENT_NONOBAT_BILL_ID"><?= $Page->renderSort($Page->BILL_ID) ?></div></th>
<?php } ?>
<?php if ($Page->NO_REGISTRATION->Visible) { // NO_REGISTRATION ?>
        <th data-name="NO_REGISTRATION" class="<?= $Page->NO_REGISTRATION->headerCellClass() ?>"><div id="elh_TREATMENT_NONOBAT_NO_REGISTRATION" class="TREATMENT_NONOBAT_NO_REGISTRATION"><?= $Page->renderSort($Page->NO_REGISTRATION) ?></div></th>
<?php } ?>
<?php if ($Page->VISIT_ID->Visible) { // VISIT_ID ?>
        <th data-name="VISIT_ID" class="<?= $Page->VISIT_ID->headerCellClass() ?>"><div id="elh_TREATMENT_NONOBAT_VISIT_ID" class="TREATMENT_NONOBAT_VISIT_ID"><?= $Page->renderSort($Page->VISIT_ID) ?></div></th>
<?php } ?>
<?php if ($Page->TARIF_ID->Visible) { // TARIF_ID ?>
        <th data-name="TARIF_ID" class="<?= $Page->TARIF_ID->headerCellClass() ?>"><div id="elh_TREATMENT_NONOBAT_TARIF_ID" class="TREATMENT_NONOBAT_TARIF_ID"><?= $Page->renderSort($Page->TARIF_ID) ?></div></th>
<?php } ?>
<?php if ($Page->CLASS_ID->Visible) { // CLASS_ID ?>
        <th data-name="CLASS_ID" class="<?= $Page->CLASS_ID->headerCellClass() ?>"><div id="elh_TREATMENT_NONOBAT_CLASS_ID" class="TREATMENT_NONOBAT_CLASS_ID"><?= $Page->renderSort($Page->CLASS_ID) ?></div></th>
<?php } ?>
<?php if ($Page->CLINIC_ID->Visible) { // CLINIC_ID ?>
        <th data-name="CLINIC_ID" class="<?= $Page->CLINIC_ID->headerCellClass() ?>"><div id="elh_TREATMENT_NONOBAT_CLINIC_ID" class="TREATMENT_NONOBAT_CLINIC_ID"><?= $Page->renderSort($Page->CLINIC_ID) ?></div></th>
<?php } ?>
<?php if ($Page->CLINIC_ID_FROM->Visible) { // CLINIC_ID_FROM ?>
        <th data-name="CLINIC_ID_FROM" class="<?= $Page->CLINIC_ID_FROM->headerCellClass() ?>"><div id="elh_TREATMENT_NONOBAT_CLINIC_ID_FROM" class="TREATMENT_NONOBAT_CLINIC_ID_FROM"><?= $Page->renderSort($Page->CLINIC_ID_FROM) ?></div></th>
<?php } ?>
<?php if ($Page->TREATMENT->Visible) { // TREATMENT ?>
        <th data-name="TREATMENT" class="<?= $Page->TREATMENT->headerCellClass() ?>"><div id="elh_TREATMENT_NONOBAT_TREATMENT" class="TREATMENT_NONOBAT_TREATMENT"><?= $Page->renderSort($Page->TREATMENT) ?></div></th>
<?php } ?>
<?php if ($Page->TREAT_DATE->Visible) { // TREAT_DATE ?>
        <th data-name="TREAT_DATE" class="<?= $Page->TREAT_DATE->headerCellClass() ?>"><div id="elh_TREATMENT_NONOBAT_TREAT_DATE" class="TREATMENT_NONOBAT_TREAT_DATE"><?= $Page->renderSort($Page->TREAT_DATE) ?></div></th>
<?php } ?>
<?php if ($Page->QUANTITY->Visible) { // QUANTITY ?>
        <th data-name="QUANTITY" class="<?= $Page->QUANTITY->headerCellClass() ?>"><div id="elh_TREATMENT_NONOBAT_QUANTITY" class="TREATMENT_NONOBAT_QUANTITY"><?= $Page->renderSort($Page->QUANTITY) ?></div></th>
<?php } ?>
<?php if ($Page->MEASURE_ID->Visible) { // MEASURE_ID ?>
        <th data-name="MEASURE_ID" class="<?= $Page->MEASURE_ID->headerCellClass() ?>"><div id="elh_TREATMENT_NONOBAT_MEASURE_ID" class="TREATMENT_NONOBAT_MEASURE_ID"><?= $Page->renderSort($Page->MEASURE_ID) ?></div></th>
<?php } ?>
<?php if ($Page->DESCRIPTION->Visible) { // DESCRIPTION ?>
        <th data-name="DESCRIPTION" class="<?= $Page->DESCRIPTION->headerCellClass() ?>"><div id="elh_TREATMENT_NONOBAT_DESCRIPTION" class="TREATMENT_NONOBAT_DESCRIPTION"><?= $Page->renderSort($Page->DESCRIPTION) ?></div></th>
<?php } ?>
<?php if ($Page->CLASS_ROOM_ID->Visible) { // CLASS_ROOM_ID ?>
        <th data-name="CLASS_ROOM_ID" class="<?= $Page->CLASS_ROOM_ID->headerCellClass() ?>"><div id="elh_TREATMENT_NONOBAT_CLASS_ROOM_ID" class="TREATMENT_NONOBAT_CLASS_ROOM_ID"><?= $Page->renderSort($Page->CLASS_ROOM_ID) ?></div></th>
<?php } ?>
<?php if ($Page->KELUAR_ID->Visible) { // KELUAR_ID ?>
        <th data-name="KELUAR_ID" class="<?= $Page->KELUAR_ID->headerCellClass() ?>"><div id="elh_TREATMENT_NONOBAT_KELUAR_ID" class="TREATMENT_NONOBAT_KELUAR_ID"><?= $Page->renderSort($Page->KELUAR_ID) ?></div></th>
<?php } ?>
<?php if ($Page->BED_ID->Visible) { // BED_ID ?>
        <th data-name="BED_ID" class="<?= $Page->BED_ID->headerCellClass() ?>"><div id="elh_TREATMENT_NONOBAT_BED_ID" class="TREATMENT_NONOBAT_BED_ID"><?= $Page->renderSort($Page->BED_ID) ?></div></th>
<?php } ?>
<?php if ($Page->EMPLOYEE_ID->Visible) { // EMPLOYEE_ID ?>
        <th data-name="EMPLOYEE_ID" class="<?= $Page->EMPLOYEE_ID->headerCellClass() ?>"><div id="elh_TREATMENT_NONOBAT_EMPLOYEE_ID" class="TREATMENT_NONOBAT_EMPLOYEE_ID"><?= $Page->renderSort($Page->EMPLOYEE_ID) ?></div></th>
<?php } ?>
<?php if ($Page->DOCTOR->Visible) { // DOCTOR ?>
        <th data-name="DOCTOR" class="<?= $Page->DOCTOR->headerCellClass() ?>"><div id="elh_TREATMENT_NONOBAT_DOCTOR" class="TREATMENT_NONOBAT_DOCTOR"><?= $Page->renderSort($Page->DOCTOR) ?></div></th>
<?php } ?>
<?php if ($Page->EXIT_DATE->Visible) { // EXIT_DATE ?>
        <th data-name="EXIT_DATE" class="<?= $Page->EXIT_DATE->headerCellClass() ?>"><div id="elh_TREATMENT_NONOBAT_EXIT_DATE" class="TREATMENT_NONOBAT_EXIT_DATE"><?= $Page->renderSort($Page->EXIT_DATE) ?></div></th>
<?php } ?>
<?php if ($Page->EMPLOYEE_ID_FROM->Visible) { // EMPLOYEE_ID_FROM ?>
        <th data-name="EMPLOYEE_ID_FROM" class="<?= $Page->EMPLOYEE_ID_FROM->headerCellClass() ?>"><div id="elh_TREATMENT_NONOBAT_EMPLOYEE_ID_FROM" class="TREATMENT_NONOBAT_EMPLOYEE_ID_FROM"><?= $Page->renderSort($Page->EMPLOYEE_ID_FROM) ?></div></th>
<?php } ?>
<?php if ($Page->DOCTOR_FROM->Visible) { // DOCTOR_FROM ?>
        <th data-name="DOCTOR_FROM" class="<?= $Page->DOCTOR_FROM->headerCellClass() ?>"><div id="elh_TREATMENT_NONOBAT_DOCTOR_FROM" class="TREATMENT_NONOBAT_DOCTOR_FROM"><?= $Page->renderSort($Page->DOCTOR_FROM) ?></div></th>
<?php } ?>
<?php if ($Page->STATUS_PASIEN_ID->Visible) { // STATUS_PASIEN_ID ?>
        <th data-name="STATUS_PASIEN_ID" class="<?= $Page->STATUS_PASIEN_ID->headerCellClass() ?>"><div id="elh_TREATMENT_NONOBAT_STATUS_PASIEN_ID" class="TREATMENT_NONOBAT_STATUS_PASIEN_ID"><?= $Page->renderSort($Page->STATUS_PASIEN_ID) ?></div></th>
<?php } ?>
<?php if ($Page->THENAME->Visible) { // THENAME ?>
        <th data-name="THENAME" class="<?= $Page->THENAME->headerCellClass() ?>"><div id="elh_TREATMENT_NONOBAT_THENAME" class="TREATMENT_NONOBAT_THENAME"><?= $Page->renderSort($Page->THENAME) ?></div></th>
<?php } ?>
<?php if ($Page->THEADDRESS->Visible) { // THEADDRESS ?>
        <th data-name="THEADDRESS" class="<?= $Page->THEADDRESS->headerCellClass() ?>"><div id="elh_TREATMENT_NONOBAT_THEADDRESS" class="TREATMENT_NONOBAT_THEADDRESS"><?= $Page->renderSort($Page->THEADDRESS) ?></div></th>
<?php } ?>
<?php if ($Page->THEID->Visible) { // THEID ?>
        <th data-name="THEID" class="<?= $Page->THEID->headerCellClass() ?>"><div id="elh_TREATMENT_NONOBAT_THEID" class="TREATMENT_NONOBAT_THEID"><?= $Page->renderSort($Page->THEID) ?></div></th>
<?php } ?>
<?php if ($Page->SERIAL_NB->Visible) { // SERIAL_NB ?>
        <th data-name="SERIAL_NB" class="<?= $Page->SERIAL_NB->headerCellClass() ?>"><div id="elh_TREATMENT_NONOBAT_SERIAL_NB" class="TREATMENT_NONOBAT_SERIAL_NB"><?= $Page->renderSort($Page->SERIAL_NB) ?></div></th>
<?php } ?>
<?php if ($Page->ISRJ->Visible) { // ISRJ ?>
        <th data-name="ISRJ" class="<?= $Page->ISRJ->headerCellClass() ?>"><div id="elh_TREATMENT_NONOBAT_ISRJ" class="TREATMENT_NONOBAT_ISRJ"><?= $Page->renderSort($Page->ISRJ) ?></div></th>
<?php } ?>
<?php if ($Page->AGEYEAR->Visible) { // AGEYEAR ?>
        <th data-name="AGEYEAR" class="<?= $Page->AGEYEAR->headerCellClass() ?>"><div id="elh_TREATMENT_NONOBAT_AGEYEAR" class="TREATMENT_NONOBAT_AGEYEAR"><?= $Page->renderSort($Page->AGEYEAR) ?></div></th>
<?php } ?>
<?php if ($Page->AGEMONTH->Visible) { // AGEMONTH ?>
        <th data-name="AGEMONTH" class="<?= $Page->AGEMONTH->headerCellClass() ?>"><div id="elh_TREATMENT_NONOBAT_AGEMONTH" class="TREATMENT_NONOBAT_AGEMONTH"><?= $Page->renderSort($Page->AGEMONTH) ?></div></th>
<?php } ?>
<?php if ($Page->AGEDAY->Visible) { // AGEDAY ?>
        <th data-name="AGEDAY" class="<?= $Page->AGEDAY->headerCellClass() ?>"><div id="elh_TREATMENT_NONOBAT_AGEDAY" class="TREATMENT_NONOBAT_AGEDAY"><?= $Page->renderSort($Page->AGEDAY) ?></div></th>
<?php } ?>
<?php if ($Page->GENDER->Visible) { // GENDER ?>
        <th data-name="GENDER" class="<?= $Page->GENDER->headerCellClass() ?>"><div id="elh_TREATMENT_NONOBAT_GENDER" class="TREATMENT_NONOBAT_GENDER"><?= $Page->renderSort($Page->GENDER) ?></div></th>
<?php } ?>
<?php if ($Page->KARYAWAN->Visible) { // KARYAWAN ?>
        <th data-name="KARYAWAN" class="<?= $Page->KARYAWAN->headerCellClass() ?>"><div id="elh_TREATMENT_NONOBAT_KARYAWAN" class="TREATMENT_NONOBAT_KARYAWAN"><?= $Page->renderSort($Page->KARYAWAN) ?></div></th>
<?php } ?>
<?php if ($Page->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
        <th data-name="MODIFIED_BY" class="<?= $Page->MODIFIED_BY->headerCellClass() ?>"><div id="elh_TREATMENT_NONOBAT_MODIFIED_BY" class="TREATMENT_NONOBAT_MODIFIED_BY"><?= $Page->renderSort($Page->MODIFIED_BY) ?></div></th>
<?php } ?>
<?php if ($Page->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
        <th data-name="MODIFIED_DATE" class="<?= $Page->MODIFIED_DATE->headerCellClass() ?>"><div id="elh_TREATMENT_NONOBAT_MODIFIED_DATE" class="TREATMENT_NONOBAT_MODIFIED_DATE"><?= $Page->renderSort($Page->MODIFIED_DATE) ?></div></th>
<?php } ?>
<?php if ($Page->MODIFIED_FROM->Visible) { // MODIFIED_FROM ?>
        <th data-name="MODIFIED_FROM" class="<?= $Page->MODIFIED_FROM->headerCellClass() ?>"><div id="elh_TREATMENT_NONOBAT_MODIFIED_FROM" class="TREATMENT_NONOBAT_MODIFIED_FROM"><?= $Page->renderSort($Page->MODIFIED_FROM) ?></div></th>
<?php } ?>
<?php if ($Page->POTONGAN->Visible) { // POTONGAN ?>
        <th data-name="POTONGAN" class="<?= $Page->POTONGAN->headerCellClass() ?>"><div id="elh_TREATMENT_NONOBAT_POTONGAN" class="TREATMENT_NONOBAT_POTONGAN"><?= $Page->renderSort($Page->POTONGAN) ?></div></th>
<?php } ?>
<?php if ($Page->BAYAR->Visible) { // BAYAR ?>
        <th data-name="BAYAR" class="<?= $Page->BAYAR->headerCellClass() ?>"><div id="elh_TREATMENT_NONOBAT_BAYAR" class="TREATMENT_NONOBAT_BAYAR"><?= $Page->renderSort($Page->BAYAR) ?></div></th>
<?php } ?>
<?php if ($Page->RETUR->Visible) { // RETUR ?>
        <th data-name="RETUR" class="<?= $Page->RETUR->headerCellClass() ?>"><div id="elh_TREATMENT_NONOBAT_RETUR" class="TREATMENT_NONOBAT_RETUR"><?= $Page->renderSort($Page->RETUR) ?></div></th>
<?php } ?>
<?php if ($Page->TARIF_TYPE->Visible) { // TARIF_TYPE ?>
        <th data-name="TARIF_TYPE" class="<?= $Page->TARIF_TYPE->headerCellClass() ?>"><div id="elh_TREATMENT_NONOBAT_TARIF_TYPE" class="TREATMENT_NONOBAT_TARIF_TYPE"><?= $Page->renderSort($Page->TARIF_TYPE) ?></div></th>
<?php } ?>
<?php if ($Page->PPNVALUE->Visible) { // PPNVALUE ?>
        <th data-name="PPNVALUE" class="<?= $Page->PPNVALUE->headerCellClass() ?>"><div id="elh_TREATMENT_NONOBAT_PPNVALUE" class="TREATMENT_NONOBAT_PPNVALUE"><?= $Page->renderSort($Page->PPNVALUE) ?></div></th>
<?php } ?>
<?php if ($Page->TAGIHAN->Visible) { // TAGIHAN ?>
        <th data-name="TAGIHAN" class="<?= $Page->TAGIHAN->headerCellClass() ?>"><div id="elh_TREATMENT_NONOBAT_TAGIHAN" class="TREATMENT_NONOBAT_TAGIHAN"><?= $Page->renderSort($Page->TAGIHAN) ?></div></th>
<?php } ?>
<?php if ($Page->KOREKSI->Visible) { // KOREKSI ?>
        <th data-name="KOREKSI" class="<?= $Page->KOREKSI->headerCellClass() ?>"><div id="elh_TREATMENT_NONOBAT_KOREKSI" class="TREATMENT_NONOBAT_KOREKSI"><?= $Page->renderSort($Page->KOREKSI) ?></div></th>
<?php } ?>
<?php if ($Page->AMOUNT_PAID->Visible) { // AMOUNT_PAID ?>
        <th data-name="AMOUNT_PAID" class="<?= $Page->AMOUNT_PAID->headerCellClass() ?>"><div id="elh_TREATMENT_NONOBAT_AMOUNT_PAID" class="TREATMENT_NONOBAT_AMOUNT_PAID"><?= $Page->renderSort($Page->AMOUNT_PAID) ?></div></th>
<?php } ?>
<?php if ($Page->DISKON->Visible) { // DISKON ?>
        <th data-name="DISKON" class="<?= $Page->DISKON->headerCellClass() ?>"><div id="elh_TREATMENT_NONOBAT_DISKON" class="TREATMENT_NONOBAT_DISKON"><?= $Page->renderSort($Page->DISKON) ?></div></th>
<?php } ?>
<?php if ($Page->NOTA_NO->Visible) { // NOTA_NO ?>
        <th data-name="NOTA_NO" class="<?= $Page->NOTA_NO->headerCellClass() ?>"><div id="elh_TREATMENT_NONOBAT_NOTA_NO" class="TREATMENT_NONOBAT_NOTA_NO"><?= $Page->renderSort($Page->NOTA_NO) ?></div></th>
<?php } ?>
<?php if ($Page->SELL_PRICE->Visible) { // SELL_PRICE ?>
        <th data-name="SELL_PRICE" class="<?= $Page->SELL_PRICE->headerCellClass() ?>"><div id="elh_TREATMENT_NONOBAT_SELL_PRICE" class="TREATMENT_NONOBAT_SELL_PRICE"><?= $Page->renderSort($Page->SELL_PRICE) ?></div></th>
<?php } ?>
<?php if ($Page->ACCOUNT_ID->Visible) { // ACCOUNT_ID ?>
        <th data-name="ACCOUNT_ID" class="<?= $Page->ACCOUNT_ID->headerCellClass() ?>"><div id="elh_TREATMENT_NONOBAT_ACCOUNT_ID" class="TREATMENT_NONOBAT_ACCOUNT_ID"><?= $Page->renderSort($Page->ACCOUNT_ID) ?></div></th>
<?php } ?>
<?php if ($Page->subsidi->Visible) { // subsidi ?>
        <th data-name="subsidi" class="<?= $Page->subsidi->headerCellClass() ?>"><div id="elh_TREATMENT_NONOBAT_subsidi" class="TREATMENT_NONOBAT_subsidi"><?= $Page->renderSort($Page->subsidi) ?></div></th>
<?php } ?>
<?php if ($Page->DISCOUNT->Visible) { // DISCOUNT ?>
        <th data-name="DISCOUNT" class="<?= $Page->DISCOUNT->headerCellClass() ?>"><div id="elh_TREATMENT_NONOBAT_DISCOUNT" class="TREATMENT_NONOBAT_DISCOUNT"><?= $Page->renderSort($Page->DISCOUNT) ?></div></th>
<?php } ?>
<?php if ($Page->AMOUNT->Visible) { // AMOUNT ?>
        <th data-name="AMOUNT" class="<?= $Page->AMOUNT->headerCellClass() ?>"><div id="elh_TREATMENT_NONOBAT_AMOUNT" class="TREATMENT_NONOBAT_AMOUNT"><?= $Page->renderSort($Page->AMOUNT) ?></div></th>
<?php } ?>
<?php if ($Page->PPN->Visible) { // PPN ?>
        <th data-name="PPN" class="<?= $Page->PPN->headerCellClass() ?>"><div id="elh_TREATMENT_NONOBAT_PPN" class="TREATMENT_NONOBAT_PPN"><?= $Page->renderSort($Page->PPN) ?></div></th>
<?php } ?>
<?php if ($Page->SUBSIDISAT->Visible) { // SUBSIDISAT ?>
        <th data-name="SUBSIDISAT" class="<?= $Page->SUBSIDISAT->headerCellClass() ?>"><div id="elh_TREATMENT_NONOBAT_SUBSIDISAT" class="TREATMENT_NONOBAT_SUBSIDISAT"><?= $Page->renderSort($Page->SUBSIDISAT) ?></div></th>
<?php } ?>
<?php if ($Page->PRINTQ->Visible) { // PRINTQ ?>
        <th data-name="PRINTQ" class="<?= $Page->PRINTQ->headerCellClass() ?>"><div id="elh_TREATMENT_NONOBAT_PRINTQ" class="TREATMENT_NONOBAT_PRINTQ"><?= $Page->renderSort($Page->PRINTQ) ?></div></th>
<?php } ?>
<?php if ($Page->PRINTED_BY->Visible) { // PRINTED_BY ?>
        <th data-name="PRINTED_BY" class="<?= $Page->PRINTED_BY->headerCellClass() ?>"><div id="elh_TREATMENT_NONOBAT_PRINTED_BY" class="TREATMENT_NONOBAT_PRINTED_BY"><?= $Page->renderSort($Page->PRINTED_BY) ?></div></th>
<?php } ?>
<?php if ($Page->STATUS_TARIF->Visible) { // STATUS_TARIF ?>
        <th data-name="STATUS_TARIF" class="<?= $Page->STATUS_TARIF->headerCellClass() ?>"><div id="elh_TREATMENT_NONOBAT_STATUS_TARIF" class="TREATMENT_NONOBAT_STATUS_TARIF"><?= $Page->renderSort($Page->STATUS_TARIF) ?></div></th>
<?php } ?>
<?php if ($Page->PACKAGE_ID->Visible) { // PACKAGE_ID ?>
        <th data-name="PACKAGE_ID" class="<?= $Page->PACKAGE_ID->headerCellClass() ?>"><div id="elh_TREATMENT_NONOBAT_PACKAGE_ID" class="TREATMENT_NONOBAT_PACKAGE_ID"><?= $Page->renderSort($Page->PACKAGE_ID) ?></div></th>
<?php } ?>
<?php if ($Page->MODULE_ID->Visible) { // MODULE_ID ?>
        <th data-name="MODULE_ID" class="<?= $Page->MODULE_ID->headerCellClass() ?>"><div id="elh_TREATMENT_NONOBAT_MODULE_ID" class="TREATMENT_NONOBAT_MODULE_ID"><?= $Page->renderSort($Page->MODULE_ID) ?></div></th>
<?php } ?>
<?php if ($Page->THEORDER->Visible) { // THEORDER ?>
        <th data-name="THEORDER" class="<?= $Page->THEORDER->headerCellClass() ?>"><div id="elh_TREATMENT_NONOBAT_THEORDER" class="TREATMENT_NONOBAT_THEORDER"><?= $Page->renderSort($Page->THEORDER) ?></div></th>
<?php } ?>
<?php if ($Page->CORRECTION_ID->Visible) { // CORRECTION_ID ?>
        <th data-name="CORRECTION_ID" class="<?= $Page->CORRECTION_ID->headerCellClass() ?>"><div id="elh_TREATMENT_NONOBAT_CORRECTION_ID" class="TREATMENT_NONOBAT_CORRECTION_ID"><?= $Page->renderSort($Page->CORRECTION_ID) ?></div></th>
<?php } ?>
<?php if ($Page->CORRECTION_BY->Visible) { // CORRECTION_BY ?>
        <th data-name="CORRECTION_BY" class="<?= $Page->CORRECTION_BY->headerCellClass() ?>"><div id="elh_TREATMENT_NONOBAT_CORRECTION_BY" class="TREATMENT_NONOBAT_CORRECTION_BY"><?= $Page->renderSort($Page->CORRECTION_BY) ?></div></th>
<?php } ?>
<?php if ($Page->CASHIER->Visible) { // CASHIER ?>
        <th data-name="CASHIER" class="<?= $Page->CASHIER->headerCellClass() ?>"><div id="elh_TREATMENT_NONOBAT_CASHIER" class="TREATMENT_NONOBAT_CASHIER"><?= $Page->renderSort($Page->CASHIER) ?></div></th>
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_TREATMENT_NONOBAT", "data-rowtype" => $Page->RowType]);

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
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_ORG_UNIT_CODE">
<span<?= $Page->ORG_UNIT_CODE->viewAttributes() ?>>
<?= $Page->ORG_UNIT_CODE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->BILL_ID->Visible) { // BILL_ID ?>
        <td data-name="BILL_ID" <?= $Page->BILL_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_BILL_ID">
<span<?= $Page->BILL_ID->viewAttributes() ?>>
<?= $Page->BILL_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->NO_REGISTRATION->Visible) { // NO_REGISTRATION ?>
        <td data-name="NO_REGISTRATION" <?= $Page->NO_REGISTRATION->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_NO_REGISTRATION">
<span<?= $Page->NO_REGISTRATION->viewAttributes() ?>>
<?= $Page->NO_REGISTRATION->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->VISIT_ID->Visible) { // VISIT_ID ?>
        <td data-name="VISIT_ID" <?= $Page->VISIT_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_VISIT_ID">
<span<?= $Page->VISIT_ID->viewAttributes() ?>>
<?= $Page->VISIT_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->TARIF_ID->Visible) { // TARIF_ID ?>
        <td data-name="TARIF_ID" <?= $Page->TARIF_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_TARIF_ID">
<span<?= $Page->TARIF_ID->viewAttributes() ?>>
<?= $Page->TARIF_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->CLASS_ID->Visible) { // CLASS_ID ?>
        <td data-name="CLASS_ID" <?= $Page->CLASS_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_CLASS_ID">
<span<?= $Page->CLASS_ID->viewAttributes() ?>>
<?= $Page->CLASS_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->CLINIC_ID->Visible) { // CLINIC_ID ?>
        <td data-name="CLINIC_ID" <?= $Page->CLINIC_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_CLINIC_ID">
<span<?= $Page->CLINIC_ID->viewAttributes() ?>>
<?= $Page->CLINIC_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->CLINIC_ID_FROM->Visible) { // CLINIC_ID_FROM ?>
        <td data-name="CLINIC_ID_FROM" <?= $Page->CLINIC_ID_FROM->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_CLINIC_ID_FROM">
<span<?= $Page->CLINIC_ID_FROM->viewAttributes() ?>>
<?= $Page->CLINIC_ID_FROM->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->TREATMENT->Visible) { // TREATMENT ?>
        <td data-name="TREATMENT" <?= $Page->TREATMENT->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_TREATMENT">
<span<?= $Page->TREATMENT->viewAttributes() ?>>
<?= $Page->TREATMENT->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->TREAT_DATE->Visible) { // TREAT_DATE ?>
        <td data-name="TREAT_DATE" <?= $Page->TREAT_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_TREAT_DATE">
<span<?= $Page->TREAT_DATE->viewAttributes() ?>>
<?= $Page->TREAT_DATE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->QUANTITY->Visible) { // QUANTITY ?>
        <td data-name="QUANTITY" <?= $Page->QUANTITY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_QUANTITY">
<span<?= $Page->QUANTITY->viewAttributes() ?>>
<?= $Page->QUANTITY->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->MEASURE_ID->Visible) { // MEASURE_ID ?>
        <td data-name="MEASURE_ID" <?= $Page->MEASURE_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_MEASURE_ID">
<span<?= $Page->MEASURE_ID->viewAttributes() ?>>
<?= $Page->MEASURE_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->DESCRIPTION->Visible) { // DESCRIPTION ?>
        <td data-name="DESCRIPTION" <?= $Page->DESCRIPTION->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_DESCRIPTION">
<span<?= $Page->DESCRIPTION->viewAttributes() ?>>
<?= $Page->DESCRIPTION->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->CLASS_ROOM_ID->Visible) { // CLASS_ROOM_ID ?>
        <td data-name="CLASS_ROOM_ID" <?= $Page->CLASS_ROOM_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_CLASS_ROOM_ID">
<span<?= $Page->CLASS_ROOM_ID->viewAttributes() ?>>
<?= $Page->CLASS_ROOM_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->KELUAR_ID->Visible) { // KELUAR_ID ?>
        <td data-name="KELUAR_ID" <?= $Page->KELUAR_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_KELUAR_ID">
<span<?= $Page->KELUAR_ID->viewAttributes() ?>>
<?= $Page->KELUAR_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->BED_ID->Visible) { // BED_ID ?>
        <td data-name="BED_ID" <?= $Page->BED_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_BED_ID">
<span<?= $Page->BED_ID->viewAttributes() ?>>
<?= $Page->BED_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->EMPLOYEE_ID->Visible) { // EMPLOYEE_ID ?>
        <td data-name="EMPLOYEE_ID" <?= $Page->EMPLOYEE_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_EMPLOYEE_ID">
<span<?= $Page->EMPLOYEE_ID->viewAttributes() ?>>
<?= $Page->EMPLOYEE_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->DOCTOR->Visible) { // DOCTOR ?>
        <td data-name="DOCTOR" <?= $Page->DOCTOR->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_DOCTOR">
<span<?= $Page->DOCTOR->viewAttributes() ?>>
<?= $Page->DOCTOR->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->EXIT_DATE->Visible) { // EXIT_DATE ?>
        <td data-name="EXIT_DATE" <?= $Page->EXIT_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_EXIT_DATE">
<span<?= $Page->EXIT_DATE->viewAttributes() ?>>
<?= $Page->EXIT_DATE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->EMPLOYEE_ID_FROM->Visible) { // EMPLOYEE_ID_FROM ?>
        <td data-name="EMPLOYEE_ID_FROM" <?= $Page->EMPLOYEE_ID_FROM->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_EMPLOYEE_ID_FROM">
<span<?= $Page->EMPLOYEE_ID_FROM->viewAttributes() ?>>
<?= $Page->EMPLOYEE_ID_FROM->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->DOCTOR_FROM->Visible) { // DOCTOR_FROM ?>
        <td data-name="DOCTOR_FROM" <?= $Page->DOCTOR_FROM->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_DOCTOR_FROM">
<span<?= $Page->DOCTOR_FROM->viewAttributes() ?>>
<?= $Page->DOCTOR_FROM->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->STATUS_PASIEN_ID->Visible) { // STATUS_PASIEN_ID ?>
        <td data-name="STATUS_PASIEN_ID" <?= $Page->STATUS_PASIEN_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_STATUS_PASIEN_ID">
<span<?= $Page->STATUS_PASIEN_ID->viewAttributes() ?>>
<?= $Page->STATUS_PASIEN_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->THENAME->Visible) { // THENAME ?>
        <td data-name="THENAME" <?= $Page->THENAME->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_THENAME">
<span<?= $Page->THENAME->viewAttributes() ?>>
<?= $Page->THENAME->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->THEADDRESS->Visible) { // THEADDRESS ?>
        <td data-name="THEADDRESS" <?= $Page->THEADDRESS->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_THEADDRESS">
<span<?= $Page->THEADDRESS->viewAttributes() ?>>
<?= $Page->THEADDRESS->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->THEID->Visible) { // THEID ?>
        <td data-name="THEID" <?= $Page->THEID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_THEID">
<span<?= $Page->THEID->viewAttributes() ?>>
<?= $Page->THEID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->SERIAL_NB->Visible) { // SERIAL_NB ?>
        <td data-name="SERIAL_NB" <?= $Page->SERIAL_NB->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_SERIAL_NB">
<span<?= $Page->SERIAL_NB->viewAttributes() ?>>
<?= $Page->SERIAL_NB->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ISRJ->Visible) { // ISRJ ?>
        <td data-name="ISRJ" <?= $Page->ISRJ->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_ISRJ">
<span<?= $Page->ISRJ->viewAttributes() ?>>
<?= $Page->ISRJ->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->AGEYEAR->Visible) { // AGEYEAR ?>
        <td data-name="AGEYEAR" <?= $Page->AGEYEAR->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_AGEYEAR">
<span<?= $Page->AGEYEAR->viewAttributes() ?>>
<?= $Page->AGEYEAR->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->AGEMONTH->Visible) { // AGEMONTH ?>
        <td data-name="AGEMONTH" <?= $Page->AGEMONTH->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_AGEMONTH">
<span<?= $Page->AGEMONTH->viewAttributes() ?>>
<?= $Page->AGEMONTH->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->AGEDAY->Visible) { // AGEDAY ?>
        <td data-name="AGEDAY" <?= $Page->AGEDAY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_AGEDAY">
<span<?= $Page->AGEDAY->viewAttributes() ?>>
<?= $Page->AGEDAY->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->GENDER->Visible) { // GENDER ?>
        <td data-name="GENDER" <?= $Page->GENDER->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_GENDER">
<span<?= $Page->GENDER->viewAttributes() ?>>
<?= $Page->GENDER->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->KARYAWAN->Visible) { // KARYAWAN ?>
        <td data-name="KARYAWAN" <?= $Page->KARYAWAN->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_KARYAWAN">
<span<?= $Page->KARYAWAN->viewAttributes() ?>>
<?= $Page->KARYAWAN->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
        <td data-name="MODIFIED_BY" <?= $Page->MODIFIED_BY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_MODIFIED_BY">
<span<?= $Page->MODIFIED_BY->viewAttributes() ?>>
<?= $Page->MODIFIED_BY->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
        <td data-name="MODIFIED_DATE" <?= $Page->MODIFIED_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_MODIFIED_DATE">
<span<?= $Page->MODIFIED_DATE->viewAttributes() ?>>
<?= $Page->MODIFIED_DATE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->MODIFIED_FROM->Visible) { // MODIFIED_FROM ?>
        <td data-name="MODIFIED_FROM" <?= $Page->MODIFIED_FROM->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_MODIFIED_FROM">
<span<?= $Page->MODIFIED_FROM->viewAttributes() ?>>
<?= $Page->MODIFIED_FROM->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->POTONGAN->Visible) { // POTONGAN ?>
        <td data-name="POTONGAN" <?= $Page->POTONGAN->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_POTONGAN">
<span<?= $Page->POTONGAN->viewAttributes() ?>>
<?= $Page->POTONGAN->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->BAYAR->Visible) { // BAYAR ?>
        <td data-name="BAYAR" <?= $Page->BAYAR->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_BAYAR">
<span<?= $Page->BAYAR->viewAttributes() ?>>
<?= $Page->BAYAR->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->RETUR->Visible) { // RETUR ?>
        <td data-name="RETUR" <?= $Page->RETUR->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_RETUR">
<span<?= $Page->RETUR->viewAttributes() ?>>
<?= $Page->RETUR->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->TARIF_TYPE->Visible) { // TARIF_TYPE ?>
        <td data-name="TARIF_TYPE" <?= $Page->TARIF_TYPE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_TARIF_TYPE">
<span<?= $Page->TARIF_TYPE->viewAttributes() ?>>
<?= $Page->TARIF_TYPE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PPNVALUE->Visible) { // PPNVALUE ?>
        <td data-name="PPNVALUE" <?= $Page->PPNVALUE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_PPNVALUE">
<span<?= $Page->PPNVALUE->viewAttributes() ?>>
<?= $Page->PPNVALUE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->TAGIHAN->Visible) { // TAGIHAN ?>
        <td data-name="TAGIHAN" <?= $Page->TAGIHAN->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_TAGIHAN">
<span<?= $Page->TAGIHAN->viewAttributes() ?>>
<?= $Page->TAGIHAN->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->KOREKSI->Visible) { // KOREKSI ?>
        <td data-name="KOREKSI" <?= $Page->KOREKSI->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_KOREKSI">
<span<?= $Page->KOREKSI->viewAttributes() ?>>
<?= $Page->KOREKSI->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->AMOUNT_PAID->Visible) { // AMOUNT_PAID ?>
        <td data-name="AMOUNT_PAID" <?= $Page->AMOUNT_PAID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_AMOUNT_PAID">
<span<?= $Page->AMOUNT_PAID->viewAttributes() ?>>
<?= $Page->AMOUNT_PAID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->DISKON->Visible) { // DISKON ?>
        <td data-name="DISKON" <?= $Page->DISKON->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_DISKON">
<span<?= $Page->DISKON->viewAttributes() ?>>
<?= $Page->DISKON->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->NOTA_NO->Visible) { // NOTA_NO ?>
        <td data-name="NOTA_NO" <?= $Page->NOTA_NO->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_NOTA_NO">
<span<?= $Page->NOTA_NO->viewAttributes() ?>>
<?= $Page->NOTA_NO->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->SELL_PRICE->Visible) { // SELL_PRICE ?>
        <td data-name="SELL_PRICE" <?= $Page->SELL_PRICE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_SELL_PRICE">
<span<?= $Page->SELL_PRICE->viewAttributes() ?>>
<?= $Page->SELL_PRICE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ACCOUNT_ID->Visible) { // ACCOUNT_ID ?>
        <td data-name="ACCOUNT_ID" <?= $Page->ACCOUNT_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_ACCOUNT_ID">
<span<?= $Page->ACCOUNT_ID->viewAttributes() ?>>
<?= $Page->ACCOUNT_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->subsidi->Visible) { // subsidi ?>
        <td data-name="subsidi" <?= $Page->subsidi->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_subsidi">
<span<?= $Page->subsidi->viewAttributes() ?>>
<?= $Page->subsidi->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->DISCOUNT->Visible) { // DISCOUNT ?>
        <td data-name="DISCOUNT" <?= $Page->DISCOUNT->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_DISCOUNT">
<span<?= $Page->DISCOUNT->viewAttributes() ?>>
<?= $Page->DISCOUNT->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->AMOUNT->Visible) { // AMOUNT ?>
        <td data-name="AMOUNT" <?= $Page->AMOUNT->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_AMOUNT">
<span<?= $Page->AMOUNT->viewAttributes() ?>>
<?= $Page->AMOUNT->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PPN->Visible) { // PPN ?>
        <td data-name="PPN" <?= $Page->PPN->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_PPN">
<span<?= $Page->PPN->viewAttributes() ?>>
<?= $Page->PPN->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->SUBSIDISAT->Visible) { // SUBSIDISAT ?>
        <td data-name="SUBSIDISAT" <?= $Page->SUBSIDISAT->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_SUBSIDISAT">
<span<?= $Page->SUBSIDISAT->viewAttributes() ?>>
<?= $Page->SUBSIDISAT->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PRINTQ->Visible) { // PRINTQ ?>
        <td data-name="PRINTQ" <?= $Page->PRINTQ->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_PRINTQ">
<span<?= $Page->PRINTQ->viewAttributes() ?>>
<?= $Page->PRINTQ->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PRINTED_BY->Visible) { // PRINTED_BY ?>
        <td data-name="PRINTED_BY" <?= $Page->PRINTED_BY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_PRINTED_BY">
<span<?= $Page->PRINTED_BY->viewAttributes() ?>>
<?= $Page->PRINTED_BY->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->STATUS_TARIF->Visible) { // STATUS_TARIF ?>
        <td data-name="STATUS_TARIF" <?= $Page->STATUS_TARIF->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_STATUS_TARIF">
<span<?= $Page->STATUS_TARIF->viewAttributes() ?>>
<?= $Page->STATUS_TARIF->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PACKAGE_ID->Visible) { // PACKAGE_ID ?>
        <td data-name="PACKAGE_ID" <?= $Page->PACKAGE_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_PACKAGE_ID">
<span<?= $Page->PACKAGE_ID->viewAttributes() ?>>
<?= $Page->PACKAGE_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->MODULE_ID->Visible) { // MODULE_ID ?>
        <td data-name="MODULE_ID" <?= $Page->MODULE_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_MODULE_ID">
<span<?= $Page->MODULE_ID->viewAttributes() ?>>
<?= $Page->MODULE_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->THEORDER->Visible) { // THEORDER ?>
        <td data-name="THEORDER" <?= $Page->THEORDER->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_THEORDER">
<span<?= $Page->THEORDER->viewAttributes() ?>>
<?= $Page->THEORDER->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->CORRECTION_ID->Visible) { // CORRECTION_ID ?>
        <td data-name="CORRECTION_ID" <?= $Page->CORRECTION_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_CORRECTION_ID">
<span<?= $Page->CORRECTION_ID->viewAttributes() ?>>
<?= $Page->CORRECTION_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->CORRECTION_BY->Visible) { // CORRECTION_BY ?>
        <td data-name="CORRECTION_BY" <?= $Page->CORRECTION_BY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_CORRECTION_BY">
<span<?= $Page->CORRECTION_BY->viewAttributes() ?>>
<?= $Page->CORRECTION_BY->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->CASHIER->Visible) { // CASHIER ?>
        <td data-name="CASHIER" <?= $Page->CASHIER->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_CASHIER">
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
    ew.addEventHandlers("TREATMENT_NONOBAT");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
