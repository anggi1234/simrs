<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAJALALTER;

// Page object
$VKasirList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fV_KASIRlist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fV_KASIRlist = currentForm = new ew.Form("fV_KASIRlist", "list");
    fV_KASIRlist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("fV_KASIRlist");
});
var fV_KASIRlistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    fV_KASIRlistsrch = currentSearchForm = new ew.Form("fV_KASIRlistsrch");

    // Dynamic selection lists

    // Filters
    fV_KASIRlistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fV_KASIRlistsrch");
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
<?php if ($Security->canSearch()) { ?>
<?php if (!$Page->isExport() && !$Page->CurrentAction) { ?>
<form name="fV_KASIRlistsrch" id="fV_KASIRlistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fV_KASIRlistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="V_KASIR">
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> V_KASIR">
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
<form name="fV_KASIRlist" id="fV_KASIRlist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="V_KASIR">
<div id="gmp_V_KASIR" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_V_KASIRlist" class="table ew-table"><!-- .ew-table -->
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
        <th data-name="ORG_UNIT_CODE" class="<?= $Page->ORG_UNIT_CODE->headerCellClass() ?>"><div id="elh_V_KASIR_ORG_UNIT_CODE" class="V_KASIR_ORG_UNIT_CODE"><?= $Page->renderSort($Page->ORG_UNIT_CODE) ?></div></th>
<?php } ?>
<?php if ($Page->NO_REGISTRATION->Visible) { // NO_REGISTRATION ?>
        <th data-name="NO_REGISTRATION" class="<?= $Page->NO_REGISTRATION->headerCellClass() ?>"><div id="elh_V_KASIR_NO_REGISTRATION" class="V_KASIR_NO_REGISTRATION"><?= $Page->renderSort($Page->NO_REGISTRATION) ?></div></th>
<?php } ?>
<?php if ($Page->VISIT_ID->Visible) { // VISIT_ID ?>
        <th data-name="VISIT_ID" class="<?= $Page->VISIT_ID->headerCellClass() ?>"><div id="elh_V_KASIR_VISIT_ID" class="V_KASIR_VISIT_ID"><?= $Page->renderSort($Page->VISIT_ID) ?></div></th>
<?php } ?>
<?php if ($Page->STATUS_PASIEN_ID->Visible) { // STATUS_PASIEN_ID ?>
        <th data-name="STATUS_PASIEN_ID" class="<?= $Page->STATUS_PASIEN_ID->headerCellClass() ?>"><div id="elh_V_KASIR_STATUS_PASIEN_ID" class="V_KASIR_STATUS_PASIEN_ID"><?= $Page->renderSort($Page->STATUS_PASIEN_ID) ?></div></th>
<?php } ?>
<?php if ($Page->RUJUKAN_ID->Visible) { // RUJUKAN_ID ?>
        <th data-name="RUJUKAN_ID" class="<?= $Page->RUJUKAN_ID->headerCellClass() ?>"><div id="elh_V_KASIR_RUJUKAN_ID" class="V_KASIR_RUJUKAN_ID"><?= $Page->renderSort($Page->RUJUKAN_ID) ?></div></th>
<?php } ?>
<?php if ($Page->ADDRESS_OF_RUJUKAN->Visible) { // ADDRESS_OF_RUJUKAN ?>
        <th data-name="ADDRESS_OF_RUJUKAN" class="<?= $Page->ADDRESS_OF_RUJUKAN->headerCellClass() ?>"><div id="elh_V_KASIR_ADDRESS_OF_RUJUKAN" class="V_KASIR_ADDRESS_OF_RUJUKAN"><?= $Page->renderSort($Page->ADDRESS_OF_RUJUKAN) ?></div></th>
<?php } ?>
<?php if ($Page->REASON_ID->Visible) { // REASON_ID ?>
        <th data-name="REASON_ID" class="<?= $Page->REASON_ID->headerCellClass() ?>"><div id="elh_V_KASIR_REASON_ID" class="V_KASIR_REASON_ID"><?= $Page->renderSort($Page->REASON_ID) ?></div></th>
<?php } ?>
<?php if ($Page->WAY_ID->Visible) { // WAY_ID ?>
        <th data-name="WAY_ID" class="<?= $Page->WAY_ID->headerCellClass() ?>"><div id="elh_V_KASIR_WAY_ID" class="V_KASIR_WAY_ID"><?= $Page->renderSort($Page->WAY_ID) ?></div></th>
<?php } ?>
<?php if ($Page->PATIENT_CATEGORY_ID->Visible) { // PATIENT_CATEGORY_ID ?>
        <th data-name="PATIENT_CATEGORY_ID" class="<?= $Page->PATIENT_CATEGORY_ID->headerCellClass() ?>"><div id="elh_V_KASIR_PATIENT_CATEGORY_ID" class="V_KASIR_PATIENT_CATEGORY_ID"><?= $Page->renderSort($Page->PATIENT_CATEGORY_ID) ?></div></th>
<?php } ?>
<?php if ($Page->BOOKED_DATE->Visible) { // BOOKED_DATE ?>
        <th data-name="BOOKED_DATE" class="<?= $Page->BOOKED_DATE->headerCellClass() ?>"><div id="elh_V_KASIR_BOOKED_DATE" class="V_KASIR_BOOKED_DATE"><?= $Page->renderSort($Page->BOOKED_DATE) ?></div></th>
<?php } ?>
<?php if ($Page->VISIT_DATE->Visible) { // VISIT_DATE ?>
        <th data-name="VISIT_DATE" class="<?= $Page->VISIT_DATE->headerCellClass() ?>"><div id="elh_V_KASIR_VISIT_DATE" class="V_KASIR_VISIT_DATE"><?= $Page->renderSort($Page->VISIT_DATE) ?></div></th>
<?php } ?>
<?php if ($Page->ISNEW->Visible) { // ISNEW ?>
        <th data-name="ISNEW" class="<?= $Page->ISNEW->headerCellClass() ?>"><div id="elh_V_KASIR_ISNEW" class="V_KASIR_ISNEW"><?= $Page->renderSort($Page->ISNEW) ?></div></th>
<?php } ?>
<?php if ($Page->FOLLOW_UP->Visible) { // FOLLOW_UP ?>
        <th data-name="FOLLOW_UP" class="<?= $Page->FOLLOW_UP->headerCellClass() ?>"><div id="elh_V_KASIR_FOLLOW_UP" class="V_KASIR_FOLLOW_UP"><?= $Page->renderSort($Page->FOLLOW_UP) ?></div></th>
<?php } ?>
<?php if ($Page->PLACE_TYPE->Visible) { // PLACE_TYPE ?>
        <th data-name="PLACE_TYPE" class="<?= $Page->PLACE_TYPE->headerCellClass() ?>"><div id="elh_V_KASIR_PLACE_TYPE" class="V_KASIR_PLACE_TYPE"><?= $Page->renderSort($Page->PLACE_TYPE) ?></div></th>
<?php } ?>
<?php if ($Page->CLINIC_ID->Visible) { // CLINIC_ID ?>
        <th data-name="CLINIC_ID" class="<?= $Page->CLINIC_ID->headerCellClass() ?>"><div id="elh_V_KASIR_CLINIC_ID" class="V_KASIR_CLINIC_ID"><?= $Page->renderSort($Page->CLINIC_ID) ?></div></th>
<?php } ?>
<?php if ($Page->CLINIC_ID_FROM->Visible) { // CLINIC_ID_FROM ?>
        <th data-name="CLINIC_ID_FROM" class="<?= $Page->CLINIC_ID_FROM->headerCellClass() ?>"><div id="elh_V_KASIR_CLINIC_ID_FROM" class="V_KASIR_CLINIC_ID_FROM"><?= $Page->renderSort($Page->CLINIC_ID_FROM) ?></div></th>
<?php } ?>
<?php if ($Page->CLASS_ROOM_ID->Visible) { // CLASS_ROOM_ID ?>
        <th data-name="CLASS_ROOM_ID" class="<?= $Page->CLASS_ROOM_ID->headerCellClass() ?>"><div id="elh_V_KASIR_CLASS_ROOM_ID" class="V_KASIR_CLASS_ROOM_ID"><?= $Page->renderSort($Page->CLASS_ROOM_ID) ?></div></th>
<?php } ?>
<?php if ($Page->BED_ID->Visible) { // BED_ID ?>
        <th data-name="BED_ID" class="<?= $Page->BED_ID->headerCellClass() ?>"><div id="elh_V_KASIR_BED_ID" class="V_KASIR_BED_ID"><?= $Page->renderSort($Page->BED_ID) ?></div></th>
<?php } ?>
<?php if ($Page->KELUAR_ID->Visible) { // KELUAR_ID ?>
        <th data-name="KELUAR_ID" class="<?= $Page->KELUAR_ID->headerCellClass() ?>"><div id="elh_V_KASIR_KELUAR_ID" class="V_KASIR_KELUAR_ID"><?= $Page->renderSort($Page->KELUAR_ID) ?></div></th>
<?php } ?>
<?php if ($Page->IN_DATE->Visible) { // IN_DATE ?>
        <th data-name="IN_DATE" class="<?= $Page->IN_DATE->headerCellClass() ?>"><div id="elh_V_KASIR_IN_DATE" class="V_KASIR_IN_DATE"><?= $Page->renderSort($Page->IN_DATE) ?></div></th>
<?php } ?>
<?php if ($Page->EXIT_DATE->Visible) { // EXIT_DATE ?>
        <th data-name="EXIT_DATE" class="<?= $Page->EXIT_DATE->headerCellClass() ?>"><div id="elh_V_KASIR_EXIT_DATE" class="V_KASIR_EXIT_DATE"><?= $Page->renderSort($Page->EXIT_DATE) ?></div></th>
<?php } ?>
<?php if ($Page->DIANTAR_OLEH->Visible) { // DIANTAR_OLEH ?>
        <th data-name="DIANTAR_OLEH" class="<?= $Page->DIANTAR_OLEH->headerCellClass() ?>"><div id="elh_V_KASIR_DIANTAR_OLEH" class="V_KASIR_DIANTAR_OLEH"><?= $Page->renderSort($Page->DIANTAR_OLEH) ?></div></th>
<?php } ?>
<?php if ($Page->GENDER->Visible) { // GENDER ?>
        <th data-name="GENDER" class="<?= $Page->GENDER->headerCellClass() ?>"><div id="elh_V_KASIR_GENDER" class="V_KASIR_GENDER"><?= $Page->renderSort($Page->GENDER) ?></div></th>
<?php } ?>
<?php if ($Page->DESCRIPTION->Visible) { // DESCRIPTION ?>
        <th data-name="DESCRIPTION" class="<?= $Page->DESCRIPTION->headerCellClass() ?>"><div id="elh_V_KASIR_DESCRIPTION" class="V_KASIR_DESCRIPTION"><?= $Page->renderSort($Page->DESCRIPTION) ?></div></th>
<?php } ?>
<?php if ($Page->VISITOR_ADDRESS->Visible) { // VISITOR_ADDRESS ?>
        <th data-name="VISITOR_ADDRESS" class="<?= $Page->VISITOR_ADDRESS->headerCellClass() ?>"><div id="elh_V_KASIR_VISITOR_ADDRESS" class="V_KASIR_VISITOR_ADDRESS"><?= $Page->renderSort($Page->VISITOR_ADDRESS) ?></div></th>
<?php } ?>
<?php if ($Page->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
        <th data-name="MODIFIED_BY" class="<?= $Page->MODIFIED_BY->headerCellClass() ?>"><div id="elh_V_KASIR_MODIFIED_BY" class="V_KASIR_MODIFIED_BY"><?= $Page->renderSort($Page->MODIFIED_BY) ?></div></th>
<?php } ?>
<?php if ($Page->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
        <th data-name="MODIFIED_DATE" class="<?= $Page->MODIFIED_DATE->headerCellClass() ?>"><div id="elh_V_KASIR_MODIFIED_DATE" class="V_KASIR_MODIFIED_DATE"><?= $Page->renderSort($Page->MODIFIED_DATE) ?></div></th>
<?php } ?>
<?php if ($Page->MODIFIED_FROM->Visible) { // MODIFIED_FROM ?>
        <th data-name="MODIFIED_FROM" class="<?= $Page->MODIFIED_FROM->headerCellClass() ?>"><div id="elh_V_KASIR_MODIFIED_FROM" class="V_KASIR_MODIFIED_FROM"><?= $Page->renderSort($Page->MODIFIED_FROM) ?></div></th>
<?php } ?>
<?php if ($Page->EMPLOYEE_ID->Visible) { // EMPLOYEE_ID ?>
        <th data-name="EMPLOYEE_ID" class="<?= $Page->EMPLOYEE_ID->headerCellClass() ?>"><div id="elh_V_KASIR_EMPLOYEE_ID" class="V_KASIR_EMPLOYEE_ID"><?= $Page->renderSort($Page->EMPLOYEE_ID) ?></div></th>
<?php } ?>
<?php if ($Page->EMPLOYEE_ID_FROM->Visible) { // EMPLOYEE_ID_FROM ?>
        <th data-name="EMPLOYEE_ID_FROM" class="<?= $Page->EMPLOYEE_ID_FROM->headerCellClass() ?>"><div id="elh_V_KASIR_EMPLOYEE_ID_FROM" class="V_KASIR_EMPLOYEE_ID_FROM"><?= $Page->renderSort($Page->EMPLOYEE_ID_FROM) ?></div></th>
<?php } ?>
<?php if ($Page->RESPONSIBLE_ID->Visible) { // RESPONSIBLE_ID ?>
        <th data-name="RESPONSIBLE_ID" class="<?= $Page->RESPONSIBLE_ID->headerCellClass() ?>"><div id="elh_V_KASIR_RESPONSIBLE_ID" class="V_KASIR_RESPONSIBLE_ID"><?= $Page->renderSort($Page->RESPONSIBLE_ID) ?></div></th>
<?php } ?>
<?php if ($Page->RESPONSIBLE->Visible) { // RESPONSIBLE ?>
        <th data-name="RESPONSIBLE" class="<?= $Page->RESPONSIBLE->headerCellClass() ?>"><div id="elh_V_KASIR_RESPONSIBLE" class="V_KASIR_RESPONSIBLE"><?= $Page->renderSort($Page->RESPONSIBLE) ?></div></th>
<?php } ?>
<?php if ($Page->FAMILY_STATUS_ID->Visible) { // FAMILY_STATUS_ID ?>
        <th data-name="FAMILY_STATUS_ID" class="<?= $Page->FAMILY_STATUS_ID->headerCellClass() ?>"><div id="elh_V_KASIR_FAMILY_STATUS_ID" class="V_KASIR_FAMILY_STATUS_ID"><?= $Page->renderSort($Page->FAMILY_STATUS_ID) ?></div></th>
<?php } ?>
<?php if ($Page->TICKET_NO->Visible) { // TICKET_NO ?>
        <th data-name="TICKET_NO" class="<?= $Page->TICKET_NO->headerCellClass() ?>"><div id="elh_V_KASIR_TICKET_NO" class="V_KASIR_TICKET_NO"><?= $Page->renderSort($Page->TICKET_NO) ?></div></th>
<?php } ?>
<?php if ($Page->ISATTENDED->Visible) { // ISATTENDED ?>
        <th data-name="ISATTENDED" class="<?= $Page->ISATTENDED->headerCellClass() ?>"><div id="elh_V_KASIR_ISATTENDED" class="V_KASIR_ISATTENDED"><?= $Page->renderSort($Page->ISATTENDED) ?></div></th>
<?php } ?>
<?php if ($Page->PAYOR_ID->Visible) { // PAYOR_ID ?>
        <th data-name="PAYOR_ID" class="<?= $Page->PAYOR_ID->headerCellClass() ?>"><div id="elh_V_KASIR_PAYOR_ID" class="V_KASIR_PAYOR_ID"><?= $Page->renderSort($Page->PAYOR_ID) ?></div></th>
<?php } ?>
<?php if ($Page->CLASS_ID->Visible) { // CLASS_ID ?>
        <th data-name="CLASS_ID" class="<?= $Page->CLASS_ID->headerCellClass() ?>"><div id="elh_V_KASIR_CLASS_ID" class="V_KASIR_CLASS_ID"><?= $Page->renderSort($Page->CLASS_ID) ?></div></th>
<?php } ?>
<?php if ($Page->ISPERTARIF->Visible) { // ISPERTARIF ?>
        <th data-name="ISPERTARIF" class="<?= $Page->ISPERTARIF->headerCellClass() ?>"><div id="elh_V_KASIR_ISPERTARIF" class="V_KASIR_ISPERTARIF"><?= $Page->renderSort($Page->ISPERTARIF) ?></div></th>
<?php } ?>
<?php if ($Page->KAL_ID->Visible) { // KAL_ID ?>
        <th data-name="KAL_ID" class="<?= $Page->KAL_ID->headerCellClass() ?>"><div id="elh_V_KASIR_KAL_ID" class="V_KASIR_KAL_ID"><?= $Page->renderSort($Page->KAL_ID) ?></div></th>
<?php } ?>
<?php if ($Page->EMPLOYEE_INAP->Visible) { // EMPLOYEE_INAP ?>
        <th data-name="EMPLOYEE_INAP" class="<?= $Page->EMPLOYEE_INAP->headerCellClass() ?>"><div id="elh_V_KASIR_EMPLOYEE_INAP" class="V_KASIR_EMPLOYEE_INAP"><?= $Page->renderSort($Page->EMPLOYEE_INAP) ?></div></th>
<?php } ?>
<?php if ($Page->PASIEN_ID->Visible) { // PASIEN_ID ?>
        <th data-name="PASIEN_ID" class="<?= $Page->PASIEN_ID->headerCellClass() ?>"><div id="elh_V_KASIR_PASIEN_ID" class="V_KASIR_PASIEN_ID"><?= $Page->renderSort($Page->PASIEN_ID) ?></div></th>
<?php } ?>
<?php if ($Page->KARYAWAN->Visible) { // KARYAWAN ?>
        <th data-name="KARYAWAN" class="<?= $Page->KARYAWAN->headerCellClass() ?>"><div id="elh_V_KASIR_KARYAWAN" class="V_KASIR_KARYAWAN"><?= $Page->renderSort($Page->KARYAWAN) ?></div></th>
<?php } ?>
<?php if ($Page->ACCOUNT_ID->Visible) { // ACCOUNT_ID ?>
        <th data-name="ACCOUNT_ID" class="<?= $Page->ACCOUNT_ID->headerCellClass() ?>"><div id="elh_V_KASIR_ACCOUNT_ID" class="V_KASIR_ACCOUNT_ID"><?= $Page->renderSort($Page->ACCOUNT_ID) ?></div></th>
<?php } ?>
<?php if ($Page->CLASS_ID_PLAFOND->Visible) { // CLASS_ID_PLAFOND ?>
        <th data-name="CLASS_ID_PLAFOND" class="<?= $Page->CLASS_ID_PLAFOND->headerCellClass() ?>"><div id="elh_V_KASIR_CLASS_ID_PLAFOND" class="V_KASIR_CLASS_ID_PLAFOND"><?= $Page->renderSort($Page->CLASS_ID_PLAFOND) ?></div></th>
<?php } ?>
<?php if ($Page->BACKCHARGE->Visible) { // BACKCHARGE ?>
        <th data-name="BACKCHARGE" class="<?= $Page->BACKCHARGE->headerCellClass() ?>"><div id="elh_V_KASIR_BACKCHARGE" class="V_KASIR_BACKCHARGE"><?= $Page->renderSort($Page->BACKCHARGE) ?></div></th>
<?php } ?>
<?php if ($Page->COVERAGE_ID->Visible) { // COVERAGE_ID ?>
        <th data-name="COVERAGE_ID" class="<?= $Page->COVERAGE_ID->headerCellClass() ?>"><div id="elh_V_KASIR_COVERAGE_ID" class="V_KASIR_COVERAGE_ID"><?= $Page->renderSort($Page->COVERAGE_ID) ?></div></th>
<?php } ?>
<?php if ($Page->AGEYEAR->Visible) { // AGEYEAR ?>
        <th data-name="AGEYEAR" class="<?= $Page->AGEYEAR->headerCellClass() ?>"><div id="elh_V_KASIR_AGEYEAR" class="V_KASIR_AGEYEAR"><?= $Page->renderSort($Page->AGEYEAR) ?></div></th>
<?php } ?>
<?php if ($Page->AGEMONTH->Visible) { // AGEMONTH ?>
        <th data-name="AGEMONTH" class="<?= $Page->AGEMONTH->headerCellClass() ?>"><div id="elh_V_KASIR_AGEMONTH" class="V_KASIR_AGEMONTH"><?= $Page->renderSort($Page->AGEMONTH) ?></div></th>
<?php } ?>
<?php if ($Page->AGEDAY->Visible) { // AGEDAY ?>
        <th data-name="AGEDAY" class="<?= $Page->AGEDAY->headerCellClass() ?>"><div id="elh_V_KASIR_AGEDAY" class="V_KASIR_AGEDAY"><?= $Page->renderSort($Page->AGEDAY) ?></div></th>
<?php } ?>
<?php if ($Page->RECOMENDATION->Visible) { // RECOMENDATION ?>
        <th data-name="RECOMENDATION" class="<?= $Page->RECOMENDATION->headerCellClass() ?>"><div id="elh_V_KASIR_RECOMENDATION" class="V_KASIR_RECOMENDATION"><?= $Page->renderSort($Page->RECOMENDATION) ?></div></th>
<?php } ?>
<?php if ($Page->CONCLUSION->Visible) { // CONCLUSION ?>
        <th data-name="CONCLUSION" class="<?= $Page->CONCLUSION->headerCellClass() ?>"><div id="elh_V_KASIR_CONCLUSION" class="V_KASIR_CONCLUSION"><?= $Page->renderSort($Page->CONCLUSION) ?></div></th>
<?php } ?>
<?php if ($Page->SPECIMENNO->Visible) { // SPECIMENNO ?>
        <th data-name="SPECIMENNO" class="<?= $Page->SPECIMENNO->headerCellClass() ?>"><div id="elh_V_KASIR_SPECIMENNO" class="V_KASIR_SPECIMENNO"><?= $Page->renderSort($Page->SPECIMENNO) ?></div></th>
<?php } ?>
<?php if ($Page->LOCKED->Visible) { // LOCKED ?>
        <th data-name="LOCKED" class="<?= $Page->LOCKED->headerCellClass() ?>"><div id="elh_V_KASIR_LOCKED" class="V_KASIR_LOCKED"><?= $Page->renderSort($Page->LOCKED) ?></div></th>
<?php } ?>
<?php if ($Page->RM_OUT_DATE->Visible) { // RM_OUT_DATE ?>
        <th data-name="RM_OUT_DATE" class="<?= $Page->RM_OUT_DATE->headerCellClass() ?>"><div id="elh_V_KASIR_RM_OUT_DATE" class="V_KASIR_RM_OUT_DATE"><?= $Page->renderSort($Page->RM_OUT_DATE) ?></div></th>
<?php } ?>
<?php if ($Page->RM_IN_DATE->Visible) { // RM_IN_DATE ?>
        <th data-name="RM_IN_DATE" class="<?= $Page->RM_IN_DATE->headerCellClass() ?>"><div id="elh_V_KASIR_RM_IN_DATE" class="V_KASIR_RM_IN_DATE"><?= $Page->renderSort($Page->RM_IN_DATE) ?></div></th>
<?php } ?>
<?php if ($Page->LAMA_PINJAM->Visible) { // LAMA_PINJAM ?>
        <th data-name="LAMA_PINJAM" class="<?= $Page->LAMA_PINJAM->headerCellClass() ?>"><div id="elh_V_KASIR_LAMA_PINJAM" class="V_KASIR_LAMA_PINJAM"><?= $Page->renderSort($Page->LAMA_PINJAM) ?></div></th>
<?php } ?>
<?php if ($Page->STANDAR_RJ->Visible) { // STANDAR_RJ ?>
        <th data-name="STANDAR_RJ" class="<?= $Page->STANDAR_RJ->headerCellClass() ?>"><div id="elh_V_KASIR_STANDAR_RJ" class="V_KASIR_STANDAR_RJ"><?= $Page->renderSort($Page->STANDAR_RJ) ?></div></th>
<?php } ?>
<?php if ($Page->LENGKAP_RJ->Visible) { // LENGKAP_RJ ?>
        <th data-name="LENGKAP_RJ" class="<?= $Page->LENGKAP_RJ->headerCellClass() ?>"><div id="elh_V_KASIR_LENGKAP_RJ" class="V_KASIR_LENGKAP_RJ"><?= $Page->renderSort($Page->LENGKAP_RJ) ?></div></th>
<?php } ?>
<?php if ($Page->LENGKAP_RI->Visible) { // LENGKAP_RI ?>
        <th data-name="LENGKAP_RI" class="<?= $Page->LENGKAP_RI->headerCellClass() ?>"><div id="elh_V_KASIR_LENGKAP_RI" class="V_KASIR_LENGKAP_RI"><?= $Page->renderSort($Page->LENGKAP_RI) ?></div></th>
<?php } ?>
<?php if ($Page->RESEND_RM_DATE->Visible) { // RESEND_RM_DATE ?>
        <th data-name="RESEND_RM_DATE" class="<?= $Page->RESEND_RM_DATE->headerCellClass() ?>"><div id="elh_V_KASIR_RESEND_RM_DATE" class="V_KASIR_RESEND_RM_DATE"><?= $Page->renderSort($Page->RESEND_RM_DATE) ?></div></th>
<?php } ?>
<?php if ($Page->LENGKAP_RM1->Visible) { // LENGKAP_RM1 ?>
        <th data-name="LENGKAP_RM1" class="<?= $Page->LENGKAP_RM1->headerCellClass() ?>"><div id="elh_V_KASIR_LENGKAP_RM1" class="V_KASIR_LENGKAP_RM1"><?= $Page->renderSort($Page->LENGKAP_RM1) ?></div></th>
<?php } ?>
<?php if ($Page->LENGKAP_RESUME->Visible) { // LENGKAP_RESUME ?>
        <th data-name="LENGKAP_RESUME" class="<?= $Page->LENGKAP_RESUME->headerCellClass() ?>"><div id="elh_V_KASIR_LENGKAP_RESUME" class="V_KASIR_LENGKAP_RESUME"><?= $Page->renderSort($Page->LENGKAP_RESUME) ?></div></th>
<?php } ?>
<?php if ($Page->LENGKAP_ANAMNESIS->Visible) { // LENGKAP_ANAMNESIS ?>
        <th data-name="LENGKAP_ANAMNESIS" class="<?= $Page->LENGKAP_ANAMNESIS->headerCellClass() ?>"><div id="elh_V_KASIR_LENGKAP_ANAMNESIS" class="V_KASIR_LENGKAP_ANAMNESIS"><?= $Page->renderSort($Page->LENGKAP_ANAMNESIS) ?></div></th>
<?php } ?>
<?php if ($Page->LENGKAP_CONSENT->Visible) { // LENGKAP_CONSENT ?>
        <th data-name="LENGKAP_CONSENT" class="<?= $Page->LENGKAP_CONSENT->headerCellClass() ?>"><div id="elh_V_KASIR_LENGKAP_CONSENT" class="V_KASIR_LENGKAP_CONSENT"><?= $Page->renderSort($Page->LENGKAP_CONSENT) ?></div></th>
<?php } ?>
<?php if ($Page->LENGKAP_ANESTESI->Visible) { // LENGKAP_ANESTESI ?>
        <th data-name="LENGKAP_ANESTESI" class="<?= $Page->LENGKAP_ANESTESI->headerCellClass() ?>"><div id="elh_V_KASIR_LENGKAP_ANESTESI" class="V_KASIR_LENGKAP_ANESTESI"><?= $Page->renderSort($Page->LENGKAP_ANESTESI) ?></div></th>
<?php } ?>
<?php if ($Page->LENGKAP_OP->Visible) { // LENGKAP_OP ?>
        <th data-name="LENGKAP_OP" class="<?= $Page->LENGKAP_OP->headerCellClass() ?>"><div id="elh_V_KASIR_LENGKAP_OP" class="V_KASIR_LENGKAP_OP"><?= $Page->renderSort($Page->LENGKAP_OP) ?></div></th>
<?php } ?>
<?php if ($Page->BACK_RM_DATE->Visible) { // BACK_RM_DATE ?>
        <th data-name="BACK_RM_DATE" class="<?= $Page->BACK_RM_DATE->headerCellClass() ?>"><div id="elh_V_KASIR_BACK_RM_DATE" class="V_KASIR_BACK_RM_DATE"><?= $Page->renderSort($Page->BACK_RM_DATE) ?></div></th>
<?php } ?>
<?php if ($Page->VALID_RM_DATE->Visible) { // VALID_RM_DATE ?>
        <th data-name="VALID_RM_DATE" class="<?= $Page->VALID_RM_DATE->headerCellClass() ?>"><div id="elh_V_KASIR_VALID_RM_DATE" class="V_KASIR_VALID_RM_DATE"><?= $Page->renderSort($Page->VALID_RM_DATE) ?></div></th>
<?php } ?>
<?php if ($Page->NO_SKP->Visible) { // NO_SKP ?>
        <th data-name="NO_SKP" class="<?= $Page->NO_SKP->headerCellClass() ?>"><div id="elh_V_KASIR_NO_SKP" class="V_KASIR_NO_SKP"><?= $Page->renderSort($Page->NO_SKP) ?></div></th>
<?php } ?>
<?php if ($Page->NO_SKPINAP->Visible) { // NO_SKPINAP ?>
        <th data-name="NO_SKPINAP" class="<?= $Page->NO_SKPINAP->headerCellClass() ?>"><div id="elh_V_KASIR_NO_SKPINAP" class="V_KASIR_NO_SKPINAP"><?= $Page->renderSort($Page->NO_SKPINAP) ?></div></th>
<?php } ?>
<?php if ($Page->DIAGNOSA_ID->Visible) { // DIAGNOSA_ID ?>
        <th data-name="DIAGNOSA_ID" class="<?= $Page->DIAGNOSA_ID->headerCellClass() ?>"><div id="elh_V_KASIR_DIAGNOSA_ID" class="V_KASIR_DIAGNOSA_ID"><?= $Page->renderSort($Page->DIAGNOSA_ID) ?></div></th>
<?php } ?>
<?php if ($Page->ticket_all->Visible) { // ticket_all ?>
        <th data-name="ticket_all" class="<?= $Page->ticket_all->headerCellClass() ?>"><div id="elh_V_KASIR_ticket_all" class="V_KASIR_ticket_all"><?= $Page->renderSort($Page->ticket_all) ?></div></th>
<?php } ?>
<?php if ($Page->tanggal_rujukan->Visible) { // tanggal_rujukan ?>
        <th data-name="tanggal_rujukan" class="<?= $Page->tanggal_rujukan->headerCellClass() ?>"><div id="elh_V_KASIR_tanggal_rujukan" class="V_KASIR_tanggal_rujukan"><?= $Page->renderSort($Page->tanggal_rujukan) ?></div></th>
<?php } ?>
<?php if ($Page->ISRJ->Visible) { // ISRJ ?>
        <th data-name="ISRJ" class="<?= $Page->ISRJ->headerCellClass() ?>"><div id="elh_V_KASIR_ISRJ" class="V_KASIR_ISRJ"><?= $Page->renderSort($Page->ISRJ) ?></div></th>
<?php } ?>
<?php if ($Page->NORUJUKAN->Visible) { // NORUJUKAN ?>
        <th data-name="NORUJUKAN" class="<?= $Page->NORUJUKAN->headerCellClass() ?>"><div id="elh_V_KASIR_NORUJUKAN" class="V_KASIR_NORUJUKAN"><?= $Page->renderSort($Page->NORUJUKAN) ?></div></th>
<?php } ?>
<?php if ($Page->PPKRUJUKAN->Visible) { // PPKRUJUKAN ?>
        <th data-name="PPKRUJUKAN" class="<?= $Page->PPKRUJUKAN->headerCellClass() ?>"><div id="elh_V_KASIR_PPKRUJUKAN" class="V_KASIR_PPKRUJUKAN"><?= $Page->renderSort($Page->PPKRUJUKAN) ?></div></th>
<?php } ?>
<?php if ($Page->LOKASILAKA->Visible) { // LOKASILAKA ?>
        <th data-name="LOKASILAKA" class="<?= $Page->LOKASILAKA->headerCellClass() ?>"><div id="elh_V_KASIR_LOKASILAKA" class="V_KASIR_LOKASILAKA"><?= $Page->renderSort($Page->LOKASILAKA) ?></div></th>
<?php } ?>
<?php if ($Page->KDPOLI->Visible) { // KDPOLI ?>
        <th data-name="KDPOLI" class="<?= $Page->KDPOLI->headerCellClass() ?>"><div id="elh_V_KASIR_KDPOLI" class="V_KASIR_KDPOLI"><?= $Page->renderSort($Page->KDPOLI) ?></div></th>
<?php } ?>
<?php if ($Page->EDIT_SEP->Visible) { // EDIT_SEP ?>
        <th data-name="EDIT_SEP" class="<?= $Page->EDIT_SEP->headerCellClass() ?>"><div id="elh_V_KASIR_EDIT_SEP" class="V_KASIR_EDIT_SEP"><?= $Page->renderSort($Page->EDIT_SEP) ?></div></th>
<?php } ?>
<?php if ($Page->DELETE_SEP->Visible) { // DELETE_SEP ?>
        <th data-name="DELETE_SEP" class="<?= $Page->DELETE_SEP->headerCellClass() ?>"><div id="elh_V_KASIR_DELETE_SEP" class="V_KASIR_DELETE_SEP"><?= $Page->renderSort($Page->DELETE_SEP) ?></div></th>
<?php } ?>
<?php if ($Page->KODE_AGAMA->Visible) { // KODE_AGAMA ?>
        <th data-name="KODE_AGAMA" class="<?= $Page->KODE_AGAMA->headerCellClass() ?>"><div id="elh_V_KASIR_KODE_AGAMA" class="V_KASIR_KODE_AGAMA"><?= $Page->renderSort($Page->KODE_AGAMA) ?></div></th>
<?php } ?>
<?php if ($Page->DIAG_AWAL->Visible) { // DIAG_AWAL ?>
        <th data-name="DIAG_AWAL" class="<?= $Page->DIAG_AWAL->headerCellClass() ?>"><div id="elh_V_KASIR_DIAG_AWAL" class="V_KASIR_DIAG_AWAL"><?= $Page->renderSort($Page->DIAG_AWAL) ?></div></th>
<?php } ?>
<?php if ($Page->AKTIF->Visible) { // AKTIF ?>
        <th data-name="AKTIF" class="<?= $Page->AKTIF->headerCellClass() ?>"><div id="elh_V_KASIR_AKTIF" class="V_KASIR_AKTIF"><?= $Page->renderSort($Page->AKTIF) ?></div></th>
<?php } ?>
<?php if ($Page->BILL_INAP->Visible) { // BILL_INAP ?>
        <th data-name="BILL_INAP" class="<?= $Page->BILL_INAP->headerCellClass() ?>"><div id="elh_V_KASIR_BILL_INAP" class="V_KASIR_BILL_INAP"><?= $Page->renderSort($Page->BILL_INAP) ?></div></th>
<?php } ?>
<?php if ($Page->SEP_PRINTDATE->Visible) { // SEP_PRINTDATE ?>
        <th data-name="SEP_PRINTDATE" class="<?= $Page->SEP_PRINTDATE->headerCellClass() ?>"><div id="elh_V_KASIR_SEP_PRINTDATE" class="V_KASIR_SEP_PRINTDATE"><?= $Page->renderSort($Page->SEP_PRINTDATE) ?></div></th>
<?php } ?>
<?php if ($Page->MAPPING_SEP->Visible) { // MAPPING_SEP ?>
        <th data-name="MAPPING_SEP" class="<?= $Page->MAPPING_SEP->headerCellClass() ?>"><div id="elh_V_KASIR_MAPPING_SEP" class="V_KASIR_MAPPING_SEP"><?= $Page->renderSort($Page->MAPPING_SEP) ?></div></th>
<?php } ?>
<?php if ($Page->TRANS_ID->Visible) { // TRANS_ID ?>
        <th data-name="TRANS_ID" class="<?= $Page->TRANS_ID->headerCellClass() ?>"><div id="elh_V_KASIR_TRANS_ID" class="V_KASIR_TRANS_ID"><?= $Page->renderSort($Page->TRANS_ID) ?></div></th>
<?php } ?>
<?php if ($Page->KDPOLI_EKS->Visible) { // KDPOLI_EKS ?>
        <th data-name="KDPOLI_EKS" class="<?= $Page->KDPOLI_EKS->headerCellClass() ?>"><div id="elh_V_KASIR_KDPOLI_EKS" class="V_KASIR_KDPOLI_EKS"><?= $Page->renderSort($Page->KDPOLI_EKS) ?></div></th>
<?php } ?>
<?php if ($Page->COB->Visible) { // COB ?>
        <th data-name="COB" class="<?= $Page->COB->headerCellClass() ?>"><div id="elh_V_KASIR_COB" class="V_KASIR_COB"><?= $Page->renderSort($Page->COB) ?></div></th>
<?php } ?>
<?php if ($Page->PENJAMIN->Visible) { // PENJAMIN ?>
        <th data-name="PENJAMIN" class="<?= $Page->PENJAMIN->headerCellClass() ?>"><div id="elh_V_KASIR_PENJAMIN" class="V_KASIR_PENJAMIN"><?= $Page->renderSort($Page->PENJAMIN) ?></div></th>
<?php } ?>
<?php if ($Page->ASALRUJUKAN->Visible) { // ASALRUJUKAN ?>
        <th data-name="ASALRUJUKAN" class="<?= $Page->ASALRUJUKAN->headerCellClass() ?>"><div id="elh_V_KASIR_ASALRUJUKAN" class="V_KASIR_ASALRUJUKAN"><?= $Page->renderSort($Page->ASALRUJUKAN) ?></div></th>
<?php } ?>
<?php if ($Page->RESPONSEP->Visible) { // RESPONSEP ?>
        <th data-name="RESPONSEP" class="<?= $Page->RESPONSEP->headerCellClass() ?>"><div id="elh_V_KASIR_RESPONSEP" class="V_KASIR_RESPONSEP"><?= $Page->renderSort($Page->RESPONSEP) ?></div></th>
<?php } ?>
<?php if ($Page->APPROVAL_DESC->Visible) { // APPROVAL_DESC ?>
        <th data-name="APPROVAL_DESC" class="<?= $Page->APPROVAL_DESC->headerCellClass() ?>"><div id="elh_V_KASIR_APPROVAL_DESC" class="V_KASIR_APPROVAL_DESC"><?= $Page->renderSort($Page->APPROVAL_DESC) ?></div></th>
<?php } ?>
<?php if ($Page->APPROVAL_RESPONAJUKAN->Visible) { // APPROVAL_RESPONAJUKAN ?>
        <th data-name="APPROVAL_RESPONAJUKAN" class="<?= $Page->APPROVAL_RESPONAJUKAN->headerCellClass() ?>"><div id="elh_V_KASIR_APPROVAL_RESPONAJUKAN" class="V_KASIR_APPROVAL_RESPONAJUKAN"><?= $Page->renderSort($Page->APPROVAL_RESPONAJUKAN) ?></div></th>
<?php } ?>
<?php if ($Page->APPROVAL_RESPONAPPROV->Visible) { // APPROVAL_RESPONAPPROV ?>
        <th data-name="APPROVAL_RESPONAPPROV" class="<?= $Page->APPROVAL_RESPONAPPROV->headerCellClass() ?>"><div id="elh_V_KASIR_APPROVAL_RESPONAPPROV" class="V_KASIR_APPROVAL_RESPONAPPROV"><?= $Page->renderSort($Page->APPROVAL_RESPONAPPROV) ?></div></th>
<?php } ?>
<?php if ($Page->RESPONTGLPLG_DESC->Visible) { // RESPONTGLPLG_DESC ?>
        <th data-name="RESPONTGLPLG_DESC" class="<?= $Page->RESPONTGLPLG_DESC->headerCellClass() ?>"><div id="elh_V_KASIR_RESPONTGLPLG_DESC" class="V_KASIR_RESPONTGLPLG_DESC"><?= $Page->renderSort($Page->RESPONTGLPLG_DESC) ?></div></th>
<?php } ?>
<?php if ($Page->RESPONPOST_VKLAIM->Visible) { // RESPONPOST_VKLAIM ?>
        <th data-name="RESPONPOST_VKLAIM" class="<?= $Page->RESPONPOST_VKLAIM->headerCellClass() ?>"><div id="elh_V_KASIR_RESPONPOST_VKLAIM" class="V_KASIR_RESPONPOST_VKLAIM"><?= $Page->renderSort($Page->RESPONPOST_VKLAIM) ?></div></th>
<?php } ?>
<?php if ($Page->RESPONPUT_VKLAIM->Visible) { // RESPONPUT_VKLAIM ?>
        <th data-name="RESPONPUT_VKLAIM" class="<?= $Page->RESPONPUT_VKLAIM->headerCellClass() ?>"><div id="elh_V_KASIR_RESPONPUT_VKLAIM" class="V_KASIR_RESPONPUT_VKLAIM"><?= $Page->renderSort($Page->RESPONPUT_VKLAIM) ?></div></th>
<?php } ?>
<?php if ($Page->RESPONDEL_VKLAIM->Visible) { // RESPONDEL_VKLAIM ?>
        <th data-name="RESPONDEL_VKLAIM" class="<?= $Page->RESPONDEL_VKLAIM->headerCellClass() ?>"><div id="elh_V_KASIR_RESPONDEL_VKLAIM" class="V_KASIR_RESPONDEL_VKLAIM"><?= $Page->renderSort($Page->RESPONDEL_VKLAIM) ?></div></th>
<?php } ?>
<?php if ($Page->CALL_TIMES->Visible) { // CALL_TIMES ?>
        <th data-name="CALL_TIMES" class="<?= $Page->CALL_TIMES->headerCellClass() ?>"><div id="elh_V_KASIR_CALL_TIMES" class="V_KASIR_CALL_TIMES"><?= $Page->renderSort($Page->CALL_TIMES) ?></div></th>
<?php } ?>
<?php if ($Page->CALL_DATE->Visible) { // CALL_DATE ?>
        <th data-name="CALL_DATE" class="<?= $Page->CALL_DATE->headerCellClass() ?>"><div id="elh_V_KASIR_CALL_DATE" class="V_KASIR_CALL_DATE"><?= $Page->renderSort($Page->CALL_DATE) ?></div></th>
<?php } ?>
<?php if ($Page->CALL_DATES->Visible) { // CALL_DATES ?>
        <th data-name="CALL_DATES" class="<?= $Page->CALL_DATES->headerCellClass() ?>"><div id="elh_V_KASIR_CALL_DATES" class="V_KASIR_CALL_DATES"><?= $Page->renderSort($Page->CALL_DATES) ?></div></th>
<?php } ?>
<?php if ($Page->SERVED_DATE->Visible) { // SERVED_DATE ?>
        <th data-name="SERVED_DATE" class="<?= $Page->SERVED_DATE->headerCellClass() ?>"><div id="elh_V_KASIR_SERVED_DATE" class="V_KASIR_SERVED_DATE"><?= $Page->renderSort($Page->SERVED_DATE) ?></div></th>
<?php } ?>
<?php if ($Page->SERVED_INAP->Visible) { // SERVED_INAP ?>
        <th data-name="SERVED_INAP" class="<?= $Page->SERVED_INAP->headerCellClass() ?>"><div id="elh_V_KASIR_SERVED_INAP" class="V_KASIR_SERVED_INAP"><?= $Page->renderSort($Page->SERVED_INAP) ?></div></th>
<?php } ?>
<?php if ($Page->KDDPJP1->Visible) { // KDDPJP1 ?>
        <th data-name="KDDPJP1" class="<?= $Page->KDDPJP1->headerCellClass() ?>"><div id="elh_V_KASIR_KDDPJP1" class="V_KASIR_KDDPJP1"><?= $Page->renderSort($Page->KDDPJP1) ?></div></th>
<?php } ?>
<?php if ($Page->KDDPJP->Visible) { // KDDPJP ?>
        <th data-name="KDDPJP" class="<?= $Page->KDDPJP->headerCellClass() ?>"><div id="elh_V_KASIR_KDDPJP" class="V_KASIR_KDDPJP"><?= $Page->renderSort($Page->KDDPJP) ?></div></th>
<?php } ?>
<?php if ($Page->IDXDAFTAR->Visible) { // IDXDAFTAR ?>
        <th data-name="IDXDAFTAR" class="<?= $Page->IDXDAFTAR->headerCellClass() ?>"><div id="elh_V_KASIR_IDXDAFTAR" class="V_KASIR_IDXDAFTAR"><?= $Page->renderSort($Page->IDXDAFTAR) ?></div></th>
<?php } ?>
<?php if ($Page->tgl_kontrol->Visible) { // tgl_kontrol ?>
        <th data-name="tgl_kontrol" class="<?= $Page->tgl_kontrol->headerCellClass() ?>"><div id="elh_V_KASIR_tgl_kontrol" class="V_KASIR_tgl_kontrol"><?= $Page->renderSort($Page->tgl_kontrol) ?></div></th>
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_V_KASIR", "data-rowtype" => $Page->RowType]);

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
<span id="el<?= $Page->RowCount ?>_V_KASIR_ORG_UNIT_CODE">
<span<?= $Page->ORG_UNIT_CODE->viewAttributes() ?>>
<?= $Page->ORG_UNIT_CODE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->NO_REGISTRATION->Visible) { // NO_REGISTRATION ?>
        <td data-name="NO_REGISTRATION" <?= $Page->NO_REGISTRATION->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_NO_REGISTRATION">
<span<?= $Page->NO_REGISTRATION->viewAttributes() ?>>
<?= $Page->NO_REGISTRATION->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->VISIT_ID->Visible) { // VISIT_ID ?>
        <td data-name="VISIT_ID" <?= $Page->VISIT_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_VISIT_ID">
<span<?= $Page->VISIT_ID->viewAttributes() ?>>
<?= $Page->VISIT_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->STATUS_PASIEN_ID->Visible) { // STATUS_PASIEN_ID ?>
        <td data-name="STATUS_PASIEN_ID" <?= $Page->STATUS_PASIEN_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_STATUS_PASIEN_ID">
<span<?= $Page->STATUS_PASIEN_ID->viewAttributes() ?>>
<?= $Page->STATUS_PASIEN_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->RUJUKAN_ID->Visible) { // RUJUKAN_ID ?>
        <td data-name="RUJUKAN_ID" <?= $Page->RUJUKAN_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_RUJUKAN_ID">
<span<?= $Page->RUJUKAN_ID->viewAttributes() ?>>
<?= $Page->RUJUKAN_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ADDRESS_OF_RUJUKAN->Visible) { // ADDRESS_OF_RUJUKAN ?>
        <td data-name="ADDRESS_OF_RUJUKAN" <?= $Page->ADDRESS_OF_RUJUKAN->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_ADDRESS_OF_RUJUKAN">
<span<?= $Page->ADDRESS_OF_RUJUKAN->viewAttributes() ?>>
<?= $Page->ADDRESS_OF_RUJUKAN->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->REASON_ID->Visible) { // REASON_ID ?>
        <td data-name="REASON_ID" <?= $Page->REASON_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_REASON_ID">
<span<?= $Page->REASON_ID->viewAttributes() ?>>
<?= $Page->REASON_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->WAY_ID->Visible) { // WAY_ID ?>
        <td data-name="WAY_ID" <?= $Page->WAY_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_WAY_ID">
<span<?= $Page->WAY_ID->viewAttributes() ?>>
<?= $Page->WAY_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PATIENT_CATEGORY_ID->Visible) { // PATIENT_CATEGORY_ID ?>
        <td data-name="PATIENT_CATEGORY_ID" <?= $Page->PATIENT_CATEGORY_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_PATIENT_CATEGORY_ID">
<span<?= $Page->PATIENT_CATEGORY_ID->viewAttributes() ?>>
<?= $Page->PATIENT_CATEGORY_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->BOOKED_DATE->Visible) { // BOOKED_DATE ?>
        <td data-name="BOOKED_DATE" <?= $Page->BOOKED_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_BOOKED_DATE">
<span<?= $Page->BOOKED_DATE->viewAttributes() ?>>
<?= $Page->BOOKED_DATE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->VISIT_DATE->Visible) { // VISIT_DATE ?>
        <td data-name="VISIT_DATE" <?= $Page->VISIT_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_VISIT_DATE">
<span<?= $Page->VISIT_DATE->viewAttributes() ?>>
<?= $Page->VISIT_DATE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ISNEW->Visible) { // ISNEW ?>
        <td data-name="ISNEW" <?= $Page->ISNEW->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_ISNEW">
<span<?= $Page->ISNEW->viewAttributes() ?>>
<?= $Page->ISNEW->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->FOLLOW_UP->Visible) { // FOLLOW_UP ?>
        <td data-name="FOLLOW_UP" <?= $Page->FOLLOW_UP->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_FOLLOW_UP">
<span<?= $Page->FOLLOW_UP->viewAttributes() ?>>
<?= $Page->FOLLOW_UP->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PLACE_TYPE->Visible) { // PLACE_TYPE ?>
        <td data-name="PLACE_TYPE" <?= $Page->PLACE_TYPE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_PLACE_TYPE">
<span<?= $Page->PLACE_TYPE->viewAttributes() ?>>
<?= $Page->PLACE_TYPE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->CLINIC_ID->Visible) { // CLINIC_ID ?>
        <td data-name="CLINIC_ID" <?= $Page->CLINIC_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_CLINIC_ID">
<span<?= $Page->CLINIC_ID->viewAttributes() ?>>
<?= $Page->CLINIC_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->CLINIC_ID_FROM->Visible) { // CLINIC_ID_FROM ?>
        <td data-name="CLINIC_ID_FROM" <?= $Page->CLINIC_ID_FROM->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_CLINIC_ID_FROM">
<span<?= $Page->CLINIC_ID_FROM->viewAttributes() ?>>
<?= $Page->CLINIC_ID_FROM->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->CLASS_ROOM_ID->Visible) { // CLASS_ROOM_ID ?>
        <td data-name="CLASS_ROOM_ID" <?= $Page->CLASS_ROOM_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_CLASS_ROOM_ID">
<span<?= $Page->CLASS_ROOM_ID->viewAttributes() ?>>
<?= $Page->CLASS_ROOM_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->BED_ID->Visible) { // BED_ID ?>
        <td data-name="BED_ID" <?= $Page->BED_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_BED_ID">
<span<?= $Page->BED_ID->viewAttributes() ?>>
<?= $Page->BED_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->KELUAR_ID->Visible) { // KELUAR_ID ?>
        <td data-name="KELUAR_ID" <?= $Page->KELUAR_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_KELUAR_ID">
<span<?= $Page->KELUAR_ID->viewAttributes() ?>>
<?= $Page->KELUAR_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->IN_DATE->Visible) { // IN_DATE ?>
        <td data-name="IN_DATE" <?= $Page->IN_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_IN_DATE">
<span<?= $Page->IN_DATE->viewAttributes() ?>>
<?= $Page->IN_DATE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->EXIT_DATE->Visible) { // EXIT_DATE ?>
        <td data-name="EXIT_DATE" <?= $Page->EXIT_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_EXIT_DATE">
<span<?= $Page->EXIT_DATE->viewAttributes() ?>>
<?= $Page->EXIT_DATE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->DIANTAR_OLEH->Visible) { // DIANTAR_OLEH ?>
        <td data-name="DIANTAR_OLEH" <?= $Page->DIANTAR_OLEH->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_DIANTAR_OLEH">
<span<?= $Page->DIANTAR_OLEH->viewAttributes() ?>>
<?= $Page->DIANTAR_OLEH->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->GENDER->Visible) { // GENDER ?>
        <td data-name="GENDER" <?= $Page->GENDER->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_GENDER">
<span<?= $Page->GENDER->viewAttributes() ?>>
<?= $Page->GENDER->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->DESCRIPTION->Visible) { // DESCRIPTION ?>
        <td data-name="DESCRIPTION" <?= $Page->DESCRIPTION->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_DESCRIPTION">
<span<?= $Page->DESCRIPTION->viewAttributes() ?>>
<?= $Page->DESCRIPTION->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->VISITOR_ADDRESS->Visible) { // VISITOR_ADDRESS ?>
        <td data-name="VISITOR_ADDRESS" <?= $Page->VISITOR_ADDRESS->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_VISITOR_ADDRESS">
<span<?= $Page->VISITOR_ADDRESS->viewAttributes() ?>>
<?= $Page->VISITOR_ADDRESS->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
        <td data-name="MODIFIED_BY" <?= $Page->MODIFIED_BY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_MODIFIED_BY">
<span<?= $Page->MODIFIED_BY->viewAttributes() ?>>
<?= $Page->MODIFIED_BY->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
        <td data-name="MODIFIED_DATE" <?= $Page->MODIFIED_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_MODIFIED_DATE">
<span<?= $Page->MODIFIED_DATE->viewAttributes() ?>>
<?= $Page->MODIFIED_DATE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->MODIFIED_FROM->Visible) { // MODIFIED_FROM ?>
        <td data-name="MODIFIED_FROM" <?= $Page->MODIFIED_FROM->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_MODIFIED_FROM">
<span<?= $Page->MODIFIED_FROM->viewAttributes() ?>>
<?= $Page->MODIFIED_FROM->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->EMPLOYEE_ID->Visible) { // EMPLOYEE_ID ?>
        <td data-name="EMPLOYEE_ID" <?= $Page->EMPLOYEE_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_EMPLOYEE_ID">
<span<?= $Page->EMPLOYEE_ID->viewAttributes() ?>>
<?= $Page->EMPLOYEE_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->EMPLOYEE_ID_FROM->Visible) { // EMPLOYEE_ID_FROM ?>
        <td data-name="EMPLOYEE_ID_FROM" <?= $Page->EMPLOYEE_ID_FROM->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_EMPLOYEE_ID_FROM">
<span<?= $Page->EMPLOYEE_ID_FROM->viewAttributes() ?>>
<?= $Page->EMPLOYEE_ID_FROM->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->RESPONSIBLE_ID->Visible) { // RESPONSIBLE_ID ?>
        <td data-name="RESPONSIBLE_ID" <?= $Page->RESPONSIBLE_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_RESPONSIBLE_ID">
<span<?= $Page->RESPONSIBLE_ID->viewAttributes() ?>>
<?= $Page->RESPONSIBLE_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->RESPONSIBLE->Visible) { // RESPONSIBLE ?>
        <td data-name="RESPONSIBLE" <?= $Page->RESPONSIBLE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_RESPONSIBLE">
<span<?= $Page->RESPONSIBLE->viewAttributes() ?>>
<?= $Page->RESPONSIBLE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->FAMILY_STATUS_ID->Visible) { // FAMILY_STATUS_ID ?>
        <td data-name="FAMILY_STATUS_ID" <?= $Page->FAMILY_STATUS_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_FAMILY_STATUS_ID">
<span<?= $Page->FAMILY_STATUS_ID->viewAttributes() ?>>
<?= $Page->FAMILY_STATUS_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->TICKET_NO->Visible) { // TICKET_NO ?>
        <td data-name="TICKET_NO" <?= $Page->TICKET_NO->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_TICKET_NO">
<span<?= $Page->TICKET_NO->viewAttributes() ?>>
<?= $Page->TICKET_NO->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ISATTENDED->Visible) { // ISATTENDED ?>
        <td data-name="ISATTENDED" <?= $Page->ISATTENDED->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_ISATTENDED">
<span<?= $Page->ISATTENDED->viewAttributes() ?>>
<?= $Page->ISATTENDED->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PAYOR_ID->Visible) { // PAYOR_ID ?>
        <td data-name="PAYOR_ID" <?= $Page->PAYOR_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_PAYOR_ID">
<span<?= $Page->PAYOR_ID->viewAttributes() ?>>
<?= $Page->PAYOR_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->CLASS_ID->Visible) { // CLASS_ID ?>
        <td data-name="CLASS_ID" <?= $Page->CLASS_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_CLASS_ID">
<span<?= $Page->CLASS_ID->viewAttributes() ?>>
<?= $Page->CLASS_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ISPERTARIF->Visible) { // ISPERTARIF ?>
        <td data-name="ISPERTARIF" <?= $Page->ISPERTARIF->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_ISPERTARIF">
<span<?= $Page->ISPERTARIF->viewAttributes() ?>>
<?= $Page->ISPERTARIF->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->KAL_ID->Visible) { // KAL_ID ?>
        <td data-name="KAL_ID" <?= $Page->KAL_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_KAL_ID">
<span<?= $Page->KAL_ID->viewAttributes() ?>>
<?= $Page->KAL_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->EMPLOYEE_INAP->Visible) { // EMPLOYEE_INAP ?>
        <td data-name="EMPLOYEE_INAP" <?= $Page->EMPLOYEE_INAP->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_EMPLOYEE_INAP">
<span<?= $Page->EMPLOYEE_INAP->viewAttributes() ?>>
<?= $Page->EMPLOYEE_INAP->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PASIEN_ID->Visible) { // PASIEN_ID ?>
        <td data-name="PASIEN_ID" <?= $Page->PASIEN_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_PASIEN_ID">
<span<?= $Page->PASIEN_ID->viewAttributes() ?>>
<?= $Page->PASIEN_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->KARYAWAN->Visible) { // KARYAWAN ?>
        <td data-name="KARYAWAN" <?= $Page->KARYAWAN->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_KARYAWAN">
<span<?= $Page->KARYAWAN->viewAttributes() ?>>
<?= $Page->KARYAWAN->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ACCOUNT_ID->Visible) { // ACCOUNT_ID ?>
        <td data-name="ACCOUNT_ID" <?= $Page->ACCOUNT_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_ACCOUNT_ID">
<span<?= $Page->ACCOUNT_ID->viewAttributes() ?>>
<?= $Page->ACCOUNT_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->CLASS_ID_PLAFOND->Visible) { // CLASS_ID_PLAFOND ?>
        <td data-name="CLASS_ID_PLAFOND" <?= $Page->CLASS_ID_PLAFOND->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_CLASS_ID_PLAFOND">
<span<?= $Page->CLASS_ID_PLAFOND->viewAttributes() ?>>
<?= $Page->CLASS_ID_PLAFOND->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->BACKCHARGE->Visible) { // BACKCHARGE ?>
        <td data-name="BACKCHARGE" <?= $Page->BACKCHARGE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_BACKCHARGE">
<span<?= $Page->BACKCHARGE->viewAttributes() ?>>
<?= $Page->BACKCHARGE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->COVERAGE_ID->Visible) { // COVERAGE_ID ?>
        <td data-name="COVERAGE_ID" <?= $Page->COVERAGE_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_COVERAGE_ID">
<span<?= $Page->COVERAGE_ID->viewAttributes() ?>>
<?= $Page->COVERAGE_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->AGEYEAR->Visible) { // AGEYEAR ?>
        <td data-name="AGEYEAR" <?= $Page->AGEYEAR->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_AGEYEAR">
<span<?= $Page->AGEYEAR->viewAttributes() ?>>
<?= $Page->AGEYEAR->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->AGEMONTH->Visible) { // AGEMONTH ?>
        <td data-name="AGEMONTH" <?= $Page->AGEMONTH->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_AGEMONTH">
<span<?= $Page->AGEMONTH->viewAttributes() ?>>
<?= $Page->AGEMONTH->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->AGEDAY->Visible) { // AGEDAY ?>
        <td data-name="AGEDAY" <?= $Page->AGEDAY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_AGEDAY">
<span<?= $Page->AGEDAY->viewAttributes() ?>>
<?= $Page->AGEDAY->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->RECOMENDATION->Visible) { // RECOMENDATION ?>
        <td data-name="RECOMENDATION" <?= $Page->RECOMENDATION->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_RECOMENDATION">
<span<?= $Page->RECOMENDATION->viewAttributes() ?>>
<?= $Page->RECOMENDATION->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->CONCLUSION->Visible) { // CONCLUSION ?>
        <td data-name="CONCLUSION" <?= $Page->CONCLUSION->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_CONCLUSION">
<span<?= $Page->CONCLUSION->viewAttributes() ?>>
<?= $Page->CONCLUSION->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->SPECIMENNO->Visible) { // SPECIMENNO ?>
        <td data-name="SPECIMENNO" <?= $Page->SPECIMENNO->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_SPECIMENNO">
<span<?= $Page->SPECIMENNO->viewAttributes() ?>>
<?= $Page->SPECIMENNO->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->LOCKED->Visible) { // LOCKED ?>
        <td data-name="LOCKED" <?= $Page->LOCKED->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_LOCKED">
<span<?= $Page->LOCKED->viewAttributes() ?>>
<?= $Page->LOCKED->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->RM_OUT_DATE->Visible) { // RM_OUT_DATE ?>
        <td data-name="RM_OUT_DATE" <?= $Page->RM_OUT_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_RM_OUT_DATE">
<span<?= $Page->RM_OUT_DATE->viewAttributes() ?>>
<?= $Page->RM_OUT_DATE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->RM_IN_DATE->Visible) { // RM_IN_DATE ?>
        <td data-name="RM_IN_DATE" <?= $Page->RM_IN_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_RM_IN_DATE">
<span<?= $Page->RM_IN_DATE->viewAttributes() ?>>
<?= $Page->RM_IN_DATE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->LAMA_PINJAM->Visible) { // LAMA_PINJAM ?>
        <td data-name="LAMA_PINJAM" <?= $Page->LAMA_PINJAM->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_LAMA_PINJAM">
<span<?= $Page->LAMA_PINJAM->viewAttributes() ?>>
<?= $Page->LAMA_PINJAM->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->STANDAR_RJ->Visible) { // STANDAR_RJ ?>
        <td data-name="STANDAR_RJ" <?= $Page->STANDAR_RJ->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_STANDAR_RJ">
<span<?= $Page->STANDAR_RJ->viewAttributes() ?>>
<?= $Page->STANDAR_RJ->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->LENGKAP_RJ->Visible) { // LENGKAP_RJ ?>
        <td data-name="LENGKAP_RJ" <?= $Page->LENGKAP_RJ->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_LENGKAP_RJ">
<span<?= $Page->LENGKAP_RJ->viewAttributes() ?>>
<?= $Page->LENGKAP_RJ->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->LENGKAP_RI->Visible) { // LENGKAP_RI ?>
        <td data-name="LENGKAP_RI" <?= $Page->LENGKAP_RI->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_LENGKAP_RI">
<span<?= $Page->LENGKAP_RI->viewAttributes() ?>>
<?= $Page->LENGKAP_RI->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->RESEND_RM_DATE->Visible) { // RESEND_RM_DATE ?>
        <td data-name="RESEND_RM_DATE" <?= $Page->RESEND_RM_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_RESEND_RM_DATE">
<span<?= $Page->RESEND_RM_DATE->viewAttributes() ?>>
<?= $Page->RESEND_RM_DATE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->LENGKAP_RM1->Visible) { // LENGKAP_RM1 ?>
        <td data-name="LENGKAP_RM1" <?= $Page->LENGKAP_RM1->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_LENGKAP_RM1">
<span<?= $Page->LENGKAP_RM1->viewAttributes() ?>>
<?= $Page->LENGKAP_RM1->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->LENGKAP_RESUME->Visible) { // LENGKAP_RESUME ?>
        <td data-name="LENGKAP_RESUME" <?= $Page->LENGKAP_RESUME->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_LENGKAP_RESUME">
<span<?= $Page->LENGKAP_RESUME->viewAttributes() ?>>
<?= $Page->LENGKAP_RESUME->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->LENGKAP_ANAMNESIS->Visible) { // LENGKAP_ANAMNESIS ?>
        <td data-name="LENGKAP_ANAMNESIS" <?= $Page->LENGKAP_ANAMNESIS->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_LENGKAP_ANAMNESIS">
<span<?= $Page->LENGKAP_ANAMNESIS->viewAttributes() ?>>
<?= $Page->LENGKAP_ANAMNESIS->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->LENGKAP_CONSENT->Visible) { // LENGKAP_CONSENT ?>
        <td data-name="LENGKAP_CONSENT" <?= $Page->LENGKAP_CONSENT->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_LENGKAP_CONSENT">
<span<?= $Page->LENGKAP_CONSENT->viewAttributes() ?>>
<?= $Page->LENGKAP_CONSENT->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->LENGKAP_ANESTESI->Visible) { // LENGKAP_ANESTESI ?>
        <td data-name="LENGKAP_ANESTESI" <?= $Page->LENGKAP_ANESTESI->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_LENGKAP_ANESTESI">
<span<?= $Page->LENGKAP_ANESTESI->viewAttributes() ?>>
<?= $Page->LENGKAP_ANESTESI->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->LENGKAP_OP->Visible) { // LENGKAP_OP ?>
        <td data-name="LENGKAP_OP" <?= $Page->LENGKAP_OP->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_LENGKAP_OP">
<span<?= $Page->LENGKAP_OP->viewAttributes() ?>>
<?= $Page->LENGKAP_OP->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->BACK_RM_DATE->Visible) { // BACK_RM_DATE ?>
        <td data-name="BACK_RM_DATE" <?= $Page->BACK_RM_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_BACK_RM_DATE">
<span<?= $Page->BACK_RM_DATE->viewAttributes() ?>>
<?= $Page->BACK_RM_DATE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->VALID_RM_DATE->Visible) { // VALID_RM_DATE ?>
        <td data-name="VALID_RM_DATE" <?= $Page->VALID_RM_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_VALID_RM_DATE">
<span<?= $Page->VALID_RM_DATE->viewAttributes() ?>>
<?= $Page->VALID_RM_DATE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->NO_SKP->Visible) { // NO_SKP ?>
        <td data-name="NO_SKP" <?= $Page->NO_SKP->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_NO_SKP">
<span<?= $Page->NO_SKP->viewAttributes() ?>>
<?= $Page->NO_SKP->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->NO_SKPINAP->Visible) { // NO_SKPINAP ?>
        <td data-name="NO_SKPINAP" <?= $Page->NO_SKPINAP->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_NO_SKPINAP">
<span<?= $Page->NO_SKPINAP->viewAttributes() ?>>
<?= $Page->NO_SKPINAP->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->DIAGNOSA_ID->Visible) { // DIAGNOSA_ID ?>
        <td data-name="DIAGNOSA_ID" <?= $Page->DIAGNOSA_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_DIAGNOSA_ID">
<span<?= $Page->DIAGNOSA_ID->viewAttributes() ?>>
<?= $Page->DIAGNOSA_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ticket_all->Visible) { // ticket_all ?>
        <td data-name="ticket_all" <?= $Page->ticket_all->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_ticket_all">
<span<?= $Page->ticket_all->viewAttributes() ?>>
<?= $Page->ticket_all->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->tanggal_rujukan->Visible) { // tanggal_rujukan ?>
        <td data-name="tanggal_rujukan" <?= $Page->tanggal_rujukan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_tanggal_rujukan">
<span<?= $Page->tanggal_rujukan->viewAttributes() ?>>
<?= $Page->tanggal_rujukan->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ISRJ->Visible) { // ISRJ ?>
        <td data-name="ISRJ" <?= $Page->ISRJ->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_ISRJ">
<span<?= $Page->ISRJ->viewAttributes() ?>>
<?= $Page->ISRJ->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->NORUJUKAN->Visible) { // NORUJUKAN ?>
        <td data-name="NORUJUKAN" <?= $Page->NORUJUKAN->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_NORUJUKAN">
<span<?= $Page->NORUJUKAN->viewAttributes() ?>>
<?= $Page->NORUJUKAN->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PPKRUJUKAN->Visible) { // PPKRUJUKAN ?>
        <td data-name="PPKRUJUKAN" <?= $Page->PPKRUJUKAN->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_PPKRUJUKAN">
<span<?= $Page->PPKRUJUKAN->viewAttributes() ?>>
<?= $Page->PPKRUJUKAN->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->LOKASILAKA->Visible) { // LOKASILAKA ?>
        <td data-name="LOKASILAKA" <?= $Page->LOKASILAKA->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_LOKASILAKA">
<span<?= $Page->LOKASILAKA->viewAttributes() ?>>
<?= $Page->LOKASILAKA->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->KDPOLI->Visible) { // KDPOLI ?>
        <td data-name="KDPOLI" <?= $Page->KDPOLI->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_KDPOLI">
<span<?= $Page->KDPOLI->viewAttributes() ?>>
<?= $Page->KDPOLI->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->EDIT_SEP->Visible) { // EDIT_SEP ?>
        <td data-name="EDIT_SEP" <?= $Page->EDIT_SEP->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_EDIT_SEP">
<span<?= $Page->EDIT_SEP->viewAttributes() ?>>
<?= $Page->EDIT_SEP->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->DELETE_SEP->Visible) { // DELETE_SEP ?>
        <td data-name="DELETE_SEP" <?= $Page->DELETE_SEP->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_DELETE_SEP">
<span<?= $Page->DELETE_SEP->viewAttributes() ?>>
<?= $Page->DELETE_SEP->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->KODE_AGAMA->Visible) { // KODE_AGAMA ?>
        <td data-name="KODE_AGAMA" <?= $Page->KODE_AGAMA->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_KODE_AGAMA">
<span<?= $Page->KODE_AGAMA->viewAttributes() ?>>
<?= $Page->KODE_AGAMA->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->DIAG_AWAL->Visible) { // DIAG_AWAL ?>
        <td data-name="DIAG_AWAL" <?= $Page->DIAG_AWAL->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_DIAG_AWAL">
<span<?= $Page->DIAG_AWAL->viewAttributes() ?>>
<?= $Page->DIAG_AWAL->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->AKTIF->Visible) { // AKTIF ?>
        <td data-name="AKTIF" <?= $Page->AKTIF->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_AKTIF">
<span<?= $Page->AKTIF->viewAttributes() ?>>
<?= $Page->AKTIF->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->BILL_INAP->Visible) { // BILL_INAP ?>
        <td data-name="BILL_INAP" <?= $Page->BILL_INAP->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_BILL_INAP">
<span<?= $Page->BILL_INAP->viewAttributes() ?>>
<?= $Page->BILL_INAP->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->SEP_PRINTDATE->Visible) { // SEP_PRINTDATE ?>
        <td data-name="SEP_PRINTDATE" <?= $Page->SEP_PRINTDATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_SEP_PRINTDATE">
<span<?= $Page->SEP_PRINTDATE->viewAttributes() ?>>
<?= $Page->SEP_PRINTDATE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->MAPPING_SEP->Visible) { // MAPPING_SEP ?>
        <td data-name="MAPPING_SEP" <?= $Page->MAPPING_SEP->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_MAPPING_SEP">
<span<?= $Page->MAPPING_SEP->viewAttributes() ?>>
<?= $Page->MAPPING_SEP->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->TRANS_ID->Visible) { // TRANS_ID ?>
        <td data-name="TRANS_ID" <?= $Page->TRANS_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_TRANS_ID">
<span<?= $Page->TRANS_ID->viewAttributes() ?>>
<?= $Page->TRANS_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->KDPOLI_EKS->Visible) { // KDPOLI_EKS ?>
        <td data-name="KDPOLI_EKS" <?= $Page->KDPOLI_EKS->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_KDPOLI_EKS">
<span<?= $Page->KDPOLI_EKS->viewAttributes() ?>>
<?= $Page->KDPOLI_EKS->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->COB->Visible) { // COB ?>
        <td data-name="COB" <?= $Page->COB->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_COB">
<span<?= $Page->COB->viewAttributes() ?>>
<?= $Page->COB->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PENJAMIN->Visible) { // PENJAMIN ?>
        <td data-name="PENJAMIN" <?= $Page->PENJAMIN->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_PENJAMIN">
<span<?= $Page->PENJAMIN->viewAttributes() ?>>
<?= $Page->PENJAMIN->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ASALRUJUKAN->Visible) { // ASALRUJUKAN ?>
        <td data-name="ASALRUJUKAN" <?= $Page->ASALRUJUKAN->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_ASALRUJUKAN">
<span<?= $Page->ASALRUJUKAN->viewAttributes() ?>>
<?= $Page->ASALRUJUKAN->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->RESPONSEP->Visible) { // RESPONSEP ?>
        <td data-name="RESPONSEP" <?= $Page->RESPONSEP->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_RESPONSEP">
<span<?= $Page->RESPONSEP->viewAttributes() ?>>
<?= $Page->RESPONSEP->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->APPROVAL_DESC->Visible) { // APPROVAL_DESC ?>
        <td data-name="APPROVAL_DESC" <?= $Page->APPROVAL_DESC->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_APPROVAL_DESC">
<span<?= $Page->APPROVAL_DESC->viewAttributes() ?>>
<?= $Page->APPROVAL_DESC->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->APPROVAL_RESPONAJUKAN->Visible) { // APPROVAL_RESPONAJUKAN ?>
        <td data-name="APPROVAL_RESPONAJUKAN" <?= $Page->APPROVAL_RESPONAJUKAN->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_APPROVAL_RESPONAJUKAN">
<span<?= $Page->APPROVAL_RESPONAJUKAN->viewAttributes() ?>>
<?= $Page->APPROVAL_RESPONAJUKAN->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->APPROVAL_RESPONAPPROV->Visible) { // APPROVAL_RESPONAPPROV ?>
        <td data-name="APPROVAL_RESPONAPPROV" <?= $Page->APPROVAL_RESPONAPPROV->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_APPROVAL_RESPONAPPROV">
<span<?= $Page->APPROVAL_RESPONAPPROV->viewAttributes() ?>>
<?= $Page->APPROVAL_RESPONAPPROV->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->RESPONTGLPLG_DESC->Visible) { // RESPONTGLPLG_DESC ?>
        <td data-name="RESPONTGLPLG_DESC" <?= $Page->RESPONTGLPLG_DESC->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_RESPONTGLPLG_DESC">
<span<?= $Page->RESPONTGLPLG_DESC->viewAttributes() ?>>
<?= $Page->RESPONTGLPLG_DESC->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->RESPONPOST_VKLAIM->Visible) { // RESPONPOST_VKLAIM ?>
        <td data-name="RESPONPOST_VKLAIM" <?= $Page->RESPONPOST_VKLAIM->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_RESPONPOST_VKLAIM">
<span<?= $Page->RESPONPOST_VKLAIM->viewAttributes() ?>>
<?= $Page->RESPONPOST_VKLAIM->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->RESPONPUT_VKLAIM->Visible) { // RESPONPUT_VKLAIM ?>
        <td data-name="RESPONPUT_VKLAIM" <?= $Page->RESPONPUT_VKLAIM->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_RESPONPUT_VKLAIM">
<span<?= $Page->RESPONPUT_VKLAIM->viewAttributes() ?>>
<?= $Page->RESPONPUT_VKLAIM->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->RESPONDEL_VKLAIM->Visible) { // RESPONDEL_VKLAIM ?>
        <td data-name="RESPONDEL_VKLAIM" <?= $Page->RESPONDEL_VKLAIM->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_RESPONDEL_VKLAIM">
<span<?= $Page->RESPONDEL_VKLAIM->viewAttributes() ?>>
<?= $Page->RESPONDEL_VKLAIM->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->CALL_TIMES->Visible) { // CALL_TIMES ?>
        <td data-name="CALL_TIMES" <?= $Page->CALL_TIMES->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_CALL_TIMES">
<span<?= $Page->CALL_TIMES->viewAttributes() ?>>
<?= $Page->CALL_TIMES->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->CALL_DATE->Visible) { // CALL_DATE ?>
        <td data-name="CALL_DATE" <?= $Page->CALL_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_CALL_DATE">
<span<?= $Page->CALL_DATE->viewAttributes() ?>>
<?= $Page->CALL_DATE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->CALL_DATES->Visible) { // CALL_DATES ?>
        <td data-name="CALL_DATES" <?= $Page->CALL_DATES->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_CALL_DATES">
<span<?= $Page->CALL_DATES->viewAttributes() ?>>
<?= $Page->CALL_DATES->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->SERVED_DATE->Visible) { // SERVED_DATE ?>
        <td data-name="SERVED_DATE" <?= $Page->SERVED_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_SERVED_DATE">
<span<?= $Page->SERVED_DATE->viewAttributes() ?>>
<?= $Page->SERVED_DATE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->SERVED_INAP->Visible) { // SERVED_INAP ?>
        <td data-name="SERVED_INAP" <?= $Page->SERVED_INAP->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_SERVED_INAP">
<span<?= $Page->SERVED_INAP->viewAttributes() ?>>
<?= $Page->SERVED_INAP->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->KDDPJP1->Visible) { // KDDPJP1 ?>
        <td data-name="KDDPJP1" <?= $Page->KDDPJP1->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_KDDPJP1">
<span<?= $Page->KDDPJP1->viewAttributes() ?>>
<?= $Page->KDDPJP1->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->KDDPJP->Visible) { // KDDPJP ?>
        <td data-name="KDDPJP" <?= $Page->KDDPJP->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_KDDPJP">
<span<?= $Page->KDDPJP->viewAttributes() ?>>
<?= $Page->KDDPJP->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->IDXDAFTAR->Visible) { // IDXDAFTAR ?>
        <td data-name="IDXDAFTAR" <?= $Page->IDXDAFTAR->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_IDXDAFTAR">
<span<?= $Page->IDXDAFTAR->viewAttributes() ?>>
<?= $Page->IDXDAFTAR->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->tgl_kontrol->Visible) { // tgl_kontrol ?>
        <td data-name="tgl_kontrol" <?= $Page->tgl_kontrol->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_KASIR_tgl_kontrol">
<span<?= $Page->tgl_kontrol->viewAttributes() ?>>
<?= $Page->tgl_kontrol->getViewValue() ?></span>
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
    ew.addEventHandlers("V_KASIR");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
