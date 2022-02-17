<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

// Page object
$TreatmentBookingView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fTREATMENT_BOOKINGview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fTREATMENT_BOOKINGview = currentForm = new ew.Form("fTREATMENT_BOOKINGview", "view");
    loadjs.done("fTREATMENT_BOOKINGview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.TREATMENT_BOOKING) ew.vars.tables.TREATMENT_BOOKING = <?= JsonEncode(GetClientVar("tables", "TREATMENT_BOOKING")) ?>;
</script>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $Page->ExportOptions->render("body") ?>
<?php $Page->OtherOptions->render("body") ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fTREATMENT_BOOKINGview" id="fTREATMENT_BOOKINGview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="TREATMENT_BOOKING">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-bordered table-hover ew-view-table">
<?php if ($Page->ORG_UNIT_CODE->Visible) { // ORG_UNIT_CODE ?>
    <tr id="r_ORG_UNIT_CODE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BOOKING_ORG_UNIT_CODE"><?= $Page->ORG_UNIT_CODE->caption() ?></span></td>
        <td data-name="ORG_UNIT_CODE" <?= $Page->ORG_UNIT_CODE->cellAttributes() ?>>
<span id="el_TREATMENT_BOOKING_ORG_UNIT_CODE">
<span<?= $Page->ORG_UNIT_CODE->viewAttributes() ?>>
<?= $Page->ORG_UNIT_CODE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->BILL_ID->Visible) { // BILL_ID ?>
    <tr id="r_BILL_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BOOKING_BILL_ID"><?= $Page->BILL_ID->caption() ?></span></td>
        <td data-name="BILL_ID" <?= $Page->BILL_ID->cellAttributes() ?>>
<span id="el_TREATMENT_BOOKING_BILL_ID">
<span<?= $Page->BILL_ID->viewAttributes() ?>>
<?= $Page->BILL_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->NO_REGISTRATION->Visible) { // NO_REGISTRATION ?>
    <tr id="r_NO_REGISTRATION">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BOOKING_NO_REGISTRATION"><?= $Page->NO_REGISTRATION->caption() ?></span></td>
        <td data-name="NO_REGISTRATION" <?= $Page->NO_REGISTRATION->cellAttributes() ?>>
<span id="el_TREATMENT_BOOKING_NO_REGISTRATION">
<span<?= $Page->NO_REGISTRATION->viewAttributes() ?>>
<?= $Page->NO_REGISTRATION->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->VISIT_ID->Visible) { // VISIT_ID ?>
    <tr id="r_VISIT_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BOOKING_VISIT_ID"><?= $Page->VISIT_ID->caption() ?></span></td>
        <td data-name="VISIT_ID" <?= $Page->VISIT_ID->cellAttributes() ?>>
<span id="el_TREATMENT_BOOKING_VISIT_ID">
<span<?= $Page->VISIT_ID->viewAttributes() ?>>
<?= $Page->VISIT_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->TARIF_ID->Visible) { // TARIF_ID ?>
    <tr id="r_TARIF_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BOOKING_TARIF_ID"><?= $Page->TARIF_ID->caption() ?></span></td>
        <td data-name="TARIF_ID" <?= $Page->TARIF_ID->cellAttributes() ?>>
<span id="el_TREATMENT_BOOKING_TARIF_ID">
<span<?= $Page->TARIF_ID->viewAttributes() ?>>
<?= $Page->TARIF_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->CLASS_ID->Visible) { // CLASS_ID ?>
    <tr id="r_CLASS_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BOOKING_CLASS_ID"><?= $Page->CLASS_ID->caption() ?></span></td>
        <td data-name="CLASS_ID" <?= $Page->CLASS_ID->cellAttributes() ?>>
<span id="el_TREATMENT_BOOKING_CLASS_ID">
<span<?= $Page->CLASS_ID->viewAttributes() ?>>
<?= $Page->CLASS_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->CLINIC_ID->Visible) { // CLINIC_ID ?>
    <tr id="r_CLINIC_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BOOKING_CLINIC_ID"><?= $Page->CLINIC_ID->caption() ?></span></td>
        <td data-name="CLINIC_ID" <?= $Page->CLINIC_ID->cellAttributes() ?>>
<span id="el_TREATMENT_BOOKING_CLINIC_ID">
<span<?= $Page->CLINIC_ID->viewAttributes() ?>>
<?= $Page->CLINIC_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->CLINIC_ID_FROM->Visible) { // CLINIC_ID_FROM ?>
    <tr id="r_CLINIC_ID_FROM">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BOOKING_CLINIC_ID_FROM"><?= $Page->CLINIC_ID_FROM->caption() ?></span></td>
        <td data-name="CLINIC_ID_FROM" <?= $Page->CLINIC_ID_FROM->cellAttributes() ?>>
<span id="el_TREATMENT_BOOKING_CLINIC_ID_FROM">
<span<?= $Page->CLINIC_ID_FROM->viewAttributes() ?>>
<?= $Page->CLINIC_ID_FROM->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->TREATMENT->Visible) { // TREATMENT ?>
    <tr id="r_TREATMENT">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BOOKING_TREATMENT"><?= $Page->TREATMENT->caption() ?></span></td>
        <td data-name="TREATMENT" <?= $Page->TREATMENT->cellAttributes() ?>>
<span id="el_TREATMENT_BOOKING_TREATMENT">
<span<?= $Page->TREATMENT->viewAttributes() ?>>
<?= $Page->TREATMENT->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->TREAT_DATE->Visible) { // TREAT_DATE ?>
    <tr id="r_TREAT_DATE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BOOKING_TREAT_DATE"><?= $Page->TREAT_DATE->caption() ?></span></td>
        <td data-name="TREAT_DATE" <?= $Page->TREAT_DATE->cellAttributes() ?>>
<span id="el_TREATMENT_BOOKING_TREAT_DATE">
<span<?= $Page->TREAT_DATE->viewAttributes() ?>>
<?= $Page->TREAT_DATE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->QUANTITY->Visible) { // QUANTITY ?>
    <tr id="r_QUANTITY">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BOOKING_QUANTITY"><?= $Page->QUANTITY->caption() ?></span></td>
        <td data-name="QUANTITY" <?= $Page->QUANTITY->cellAttributes() ?>>
<span id="el_TREATMENT_BOOKING_QUANTITY">
<span<?= $Page->QUANTITY->viewAttributes() ?>>
<?= $Page->QUANTITY->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->MEASURE_ID->Visible) { // MEASURE_ID ?>
    <tr id="r_MEASURE_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BOOKING_MEASURE_ID"><?= $Page->MEASURE_ID->caption() ?></span></td>
        <td data-name="MEASURE_ID" <?= $Page->MEASURE_ID->cellAttributes() ?>>
<span id="el_TREATMENT_BOOKING_MEASURE_ID">
<span<?= $Page->MEASURE_ID->viewAttributes() ?>>
<?= $Page->MEASURE_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->DESCRIPTION->Visible) { // DESCRIPTION ?>
    <tr id="r_DESCRIPTION">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BOOKING_DESCRIPTION"><?= $Page->DESCRIPTION->caption() ?></span></td>
        <td data-name="DESCRIPTION" <?= $Page->DESCRIPTION->cellAttributes() ?>>
<span id="el_TREATMENT_BOOKING_DESCRIPTION">
<span<?= $Page->DESCRIPTION->viewAttributes() ?>>
<?= $Page->DESCRIPTION->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->CLASS_ROOM_ID->Visible) { // CLASS_ROOM_ID ?>
    <tr id="r_CLASS_ROOM_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BOOKING_CLASS_ROOM_ID"><?= $Page->CLASS_ROOM_ID->caption() ?></span></td>
        <td data-name="CLASS_ROOM_ID" <?= $Page->CLASS_ROOM_ID->cellAttributes() ?>>
<span id="el_TREATMENT_BOOKING_CLASS_ROOM_ID">
<span<?= $Page->CLASS_ROOM_ID->viewAttributes() ?>>
<?= $Page->CLASS_ROOM_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->KELUAR_ID->Visible) { // KELUAR_ID ?>
    <tr id="r_KELUAR_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BOOKING_KELUAR_ID"><?= $Page->KELUAR_ID->caption() ?></span></td>
        <td data-name="KELUAR_ID" <?= $Page->KELUAR_ID->cellAttributes() ?>>
<span id="el_TREATMENT_BOOKING_KELUAR_ID">
<span<?= $Page->KELUAR_ID->viewAttributes() ?>>
<?= $Page->KELUAR_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->BED_ID->Visible) { // BED_ID ?>
    <tr id="r_BED_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BOOKING_BED_ID"><?= $Page->BED_ID->caption() ?></span></td>
        <td data-name="BED_ID" <?= $Page->BED_ID->cellAttributes() ?>>
<span id="el_TREATMENT_BOOKING_BED_ID">
<span<?= $Page->BED_ID->viewAttributes() ?>>
<?= $Page->BED_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->EMPLOYEE_ID->Visible) { // EMPLOYEE_ID ?>
    <tr id="r_EMPLOYEE_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BOOKING_EMPLOYEE_ID"><?= $Page->EMPLOYEE_ID->caption() ?></span></td>
        <td data-name="EMPLOYEE_ID" <?= $Page->EMPLOYEE_ID->cellAttributes() ?>>
<span id="el_TREATMENT_BOOKING_EMPLOYEE_ID">
<span<?= $Page->EMPLOYEE_ID->viewAttributes() ?>>
<?= $Page->EMPLOYEE_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->DOCTOR->Visible) { // DOCTOR ?>
    <tr id="r_DOCTOR">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BOOKING_DOCTOR"><?= $Page->DOCTOR->caption() ?></span></td>
        <td data-name="DOCTOR" <?= $Page->DOCTOR->cellAttributes() ?>>
<span id="el_TREATMENT_BOOKING_DOCTOR">
<span<?= $Page->DOCTOR->viewAttributes() ?>>
<?= $Page->DOCTOR->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->EXIT_DATE->Visible) { // EXIT_DATE ?>
    <tr id="r_EXIT_DATE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BOOKING_EXIT_DATE"><?= $Page->EXIT_DATE->caption() ?></span></td>
        <td data-name="EXIT_DATE" <?= $Page->EXIT_DATE->cellAttributes() ?>>
<span id="el_TREATMENT_BOOKING_EXIT_DATE">
<span<?= $Page->EXIT_DATE->viewAttributes() ?>>
<?= $Page->EXIT_DATE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->EMPLOYEE_ID_FROM->Visible) { // EMPLOYEE_ID_FROM ?>
    <tr id="r_EMPLOYEE_ID_FROM">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BOOKING_EMPLOYEE_ID_FROM"><?= $Page->EMPLOYEE_ID_FROM->caption() ?></span></td>
        <td data-name="EMPLOYEE_ID_FROM" <?= $Page->EMPLOYEE_ID_FROM->cellAttributes() ?>>
<span id="el_TREATMENT_BOOKING_EMPLOYEE_ID_FROM">
<span<?= $Page->EMPLOYEE_ID_FROM->viewAttributes() ?>>
<?= $Page->EMPLOYEE_ID_FROM->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->DOCTOR_FROM->Visible) { // DOCTOR_FROM ?>
    <tr id="r_DOCTOR_FROM">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BOOKING_DOCTOR_FROM"><?= $Page->DOCTOR_FROM->caption() ?></span></td>
        <td data-name="DOCTOR_FROM" <?= $Page->DOCTOR_FROM->cellAttributes() ?>>
<span id="el_TREATMENT_BOOKING_DOCTOR_FROM">
<span<?= $Page->DOCTOR_FROM->viewAttributes() ?>>
<?= $Page->DOCTOR_FROM->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->STATUS_PASIEN_ID->Visible) { // STATUS_PASIEN_ID ?>
    <tr id="r_STATUS_PASIEN_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BOOKING_STATUS_PASIEN_ID"><?= $Page->STATUS_PASIEN_ID->caption() ?></span></td>
        <td data-name="STATUS_PASIEN_ID" <?= $Page->STATUS_PASIEN_ID->cellAttributes() ?>>
<span id="el_TREATMENT_BOOKING_STATUS_PASIEN_ID">
<span<?= $Page->STATUS_PASIEN_ID->viewAttributes() ?>>
<?= $Page->STATUS_PASIEN_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->DIAGNOSA_ID->Visible) { // DIAGNOSA_ID ?>
    <tr id="r_DIAGNOSA_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BOOKING_DIAGNOSA_ID"><?= $Page->DIAGNOSA_ID->caption() ?></span></td>
        <td data-name="DIAGNOSA_ID" <?= $Page->DIAGNOSA_ID->cellAttributes() ?>>
<span id="el_TREATMENT_BOOKING_DIAGNOSA_ID">
<span<?= $Page->DIAGNOSA_ID->viewAttributes() ?>>
<?= $Page->DIAGNOSA_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->THENAME->Visible) { // THENAME ?>
    <tr id="r_THENAME">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BOOKING_THENAME"><?= $Page->THENAME->caption() ?></span></td>
        <td data-name="THENAME" <?= $Page->THENAME->cellAttributes() ?>>
<span id="el_TREATMENT_BOOKING_THENAME">
<span<?= $Page->THENAME->viewAttributes() ?>>
<?= $Page->THENAME->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->THEADDRESS->Visible) { // THEADDRESS ?>
    <tr id="r_THEADDRESS">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BOOKING_THEADDRESS"><?= $Page->THEADDRESS->caption() ?></span></td>
        <td data-name="THEADDRESS" <?= $Page->THEADDRESS->cellAttributes() ?>>
<span id="el_TREATMENT_BOOKING_THEADDRESS">
<span<?= $Page->THEADDRESS->viewAttributes() ?>>
<?= $Page->THEADDRESS->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->THEID->Visible) { // THEID ?>
    <tr id="r_THEID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BOOKING_THEID"><?= $Page->THEID->caption() ?></span></td>
        <td data-name="THEID" <?= $Page->THEID->cellAttributes() ?>>
<span id="el_TREATMENT_BOOKING_THEID">
<span<?= $Page->THEID->viewAttributes() ?>>
<?= $Page->THEID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ISRJ->Visible) { // ISRJ ?>
    <tr id="r_ISRJ">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BOOKING_ISRJ"><?= $Page->ISRJ->caption() ?></span></td>
        <td data-name="ISRJ" <?= $Page->ISRJ->cellAttributes() ?>>
<span id="el_TREATMENT_BOOKING_ISRJ">
<span<?= $Page->ISRJ->viewAttributes() ?>>
<?= $Page->ISRJ->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->AGEYEAR->Visible) { // AGEYEAR ?>
    <tr id="r_AGEYEAR">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BOOKING_AGEYEAR"><?= $Page->AGEYEAR->caption() ?></span></td>
        <td data-name="AGEYEAR" <?= $Page->AGEYEAR->cellAttributes() ?>>
<span id="el_TREATMENT_BOOKING_AGEYEAR">
<span<?= $Page->AGEYEAR->viewAttributes() ?>>
<?= $Page->AGEYEAR->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->AGEMONTH->Visible) { // AGEMONTH ?>
    <tr id="r_AGEMONTH">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BOOKING_AGEMONTH"><?= $Page->AGEMONTH->caption() ?></span></td>
        <td data-name="AGEMONTH" <?= $Page->AGEMONTH->cellAttributes() ?>>
<span id="el_TREATMENT_BOOKING_AGEMONTH">
<span<?= $Page->AGEMONTH->viewAttributes() ?>>
<?= $Page->AGEMONTH->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->AGEDAY->Visible) { // AGEDAY ?>
    <tr id="r_AGEDAY">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BOOKING_AGEDAY"><?= $Page->AGEDAY->caption() ?></span></td>
        <td data-name="AGEDAY" <?= $Page->AGEDAY->cellAttributes() ?>>
<span id="el_TREATMENT_BOOKING_AGEDAY">
<span<?= $Page->AGEDAY->viewAttributes() ?>>
<?= $Page->AGEDAY->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->GENDER->Visible) { // GENDER ?>
    <tr id="r_GENDER">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BOOKING_GENDER"><?= $Page->GENDER->caption() ?></span></td>
        <td data-name="GENDER" <?= $Page->GENDER->cellAttributes() ?>>
<span id="el_TREATMENT_BOOKING_GENDER">
<span<?= $Page->GENDER->viewAttributes() ?>>
<?= $Page->GENDER->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->KARYAWAN->Visible) { // KARYAWAN ?>
    <tr id="r_KARYAWAN">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BOOKING_KARYAWAN"><?= $Page->KARYAWAN->caption() ?></span></td>
        <td data-name="KARYAWAN" <?= $Page->KARYAWAN->cellAttributes() ?>>
<span id="el_TREATMENT_BOOKING_KARYAWAN">
<span<?= $Page->KARYAWAN->viewAttributes() ?>>
<?= $Page->KARYAWAN->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
    <tr id="r_MODIFIED_BY">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BOOKING_MODIFIED_BY"><?= $Page->MODIFIED_BY->caption() ?></span></td>
        <td data-name="MODIFIED_BY" <?= $Page->MODIFIED_BY->cellAttributes() ?>>
<span id="el_TREATMENT_BOOKING_MODIFIED_BY">
<span<?= $Page->MODIFIED_BY->viewAttributes() ?>>
<?= $Page->MODIFIED_BY->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
    <tr id="r_MODIFIED_DATE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BOOKING_MODIFIED_DATE"><?= $Page->MODIFIED_DATE->caption() ?></span></td>
        <td data-name="MODIFIED_DATE" <?= $Page->MODIFIED_DATE->cellAttributes() ?>>
<span id="el_TREATMENT_BOOKING_MODIFIED_DATE">
<span<?= $Page->MODIFIED_DATE->viewAttributes() ?>>
<?= $Page->MODIFIED_DATE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->MODIFIED_FROM->Visible) { // MODIFIED_FROM ?>
    <tr id="r_MODIFIED_FROM">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BOOKING_MODIFIED_FROM"><?= $Page->MODIFIED_FROM->caption() ?></span></td>
        <td data-name="MODIFIED_FROM" <?= $Page->MODIFIED_FROM->cellAttributes() ?>>
<span id="el_TREATMENT_BOOKING_MODIFIED_FROM">
<span<?= $Page->MODIFIED_FROM->viewAttributes() ?>>
<?= $Page->MODIFIED_FROM->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->POTONGAN->Visible) { // POTONGAN ?>
    <tr id="r_POTONGAN">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BOOKING_POTONGAN"><?= $Page->POTONGAN->caption() ?></span></td>
        <td data-name="POTONGAN" <?= $Page->POTONGAN->cellAttributes() ?>>
<span id="el_TREATMENT_BOOKING_POTONGAN">
<span<?= $Page->POTONGAN->viewAttributes() ?>>
<?= $Page->POTONGAN->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->BAYAR->Visible) { // BAYAR ?>
    <tr id="r_BAYAR">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BOOKING_BAYAR"><?= $Page->BAYAR->caption() ?></span></td>
        <td data-name="BAYAR" <?= $Page->BAYAR->cellAttributes() ?>>
<span id="el_TREATMENT_BOOKING_BAYAR">
<span<?= $Page->BAYAR->viewAttributes() ?>>
<?= $Page->BAYAR->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->RETUR->Visible) { // RETUR ?>
    <tr id="r_RETUR">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BOOKING_RETUR"><?= $Page->RETUR->caption() ?></span></td>
        <td data-name="RETUR" <?= $Page->RETUR->cellAttributes() ?>>
<span id="el_TREATMENT_BOOKING_RETUR">
<span<?= $Page->RETUR->viewAttributes() ?>>
<?= $Page->RETUR->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->TARIF_TYPE->Visible) { // TARIF_TYPE ?>
    <tr id="r_TARIF_TYPE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BOOKING_TARIF_TYPE"><?= $Page->TARIF_TYPE->caption() ?></span></td>
        <td data-name="TARIF_TYPE" <?= $Page->TARIF_TYPE->cellAttributes() ?>>
<span id="el_TREATMENT_BOOKING_TARIF_TYPE">
<span<?= $Page->TARIF_TYPE->viewAttributes() ?>>
<?= $Page->TARIF_TYPE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->PPNVALUE->Visible) { // PPNVALUE ?>
    <tr id="r_PPNVALUE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BOOKING_PPNVALUE"><?= $Page->PPNVALUE->caption() ?></span></td>
        <td data-name="PPNVALUE" <?= $Page->PPNVALUE->cellAttributes() ?>>
<span id="el_TREATMENT_BOOKING_PPNVALUE">
<span<?= $Page->PPNVALUE->viewAttributes() ?>>
<?= $Page->PPNVALUE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->TAGIHAN->Visible) { // TAGIHAN ?>
    <tr id="r_TAGIHAN">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BOOKING_TAGIHAN"><?= $Page->TAGIHAN->caption() ?></span></td>
        <td data-name="TAGIHAN" <?= $Page->TAGIHAN->cellAttributes() ?>>
<span id="el_TREATMENT_BOOKING_TAGIHAN">
<span<?= $Page->TAGIHAN->viewAttributes() ?>>
<?= $Page->TAGIHAN->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->KOREKSI->Visible) { // KOREKSI ?>
    <tr id="r_KOREKSI">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BOOKING_KOREKSI"><?= $Page->KOREKSI->caption() ?></span></td>
        <td data-name="KOREKSI" <?= $Page->KOREKSI->cellAttributes() ?>>
<span id="el_TREATMENT_BOOKING_KOREKSI">
<span<?= $Page->KOREKSI->viewAttributes() ?>>
<?= $Page->KOREKSI->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->AMOUNT_PAID->Visible) { // AMOUNT_PAID ?>
    <tr id="r_AMOUNT_PAID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BOOKING_AMOUNT_PAID"><?= $Page->AMOUNT_PAID->caption() ?></span></td>
        <td data-name="AMOUNT_PAID" <?= $Page->AMOUNT_PAID->cellAttributes() ?>>
<span id="el_TREATMENT_BOOKING_AMOUNT_PAID">
<span<?= $Page->AMOUNT_PAID->viewAttributes() ?>>
<?= $Page->AMOUNT_PAID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->DISKON->Visible) { // DISKON ?>
    <tr id="r_DISKON">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BOOKING_DISKON"><?= $Page->DISKON->caption() ?></span></td>
        <td data-name="DISKON" <?= $Page->DISKON->cellAttributes() ?>>
<span id="el_TREATMENT_BOOKING_DISKON">
<span<?= $Page->DISKON->viewAttributes() ?>>
<?= $Page->DISKON->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->NOTA_NO->Visible) { // NOTA_NO ?>
    <tr id="r_NOTA_NO">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BOOKING_NOTA_NO"><?= $Page->NOTA_NO->caption() ?></span></td>
        <td data-name="NOTA_NO" <?= $Page->NOTA_NO->cellAttributes() ?>>
<span id="el_TREATMENT_BOOKING_NOTA_NO">
<span<?= $Page->NOTA_NO->viewAttributes() ?>>
<?= $Page->NOTA_NO->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->SELL_PRICE->Visible) { // SELL_PRICE ?>
    <tr id="r_SELL_PRICE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BOOKING_SELL_PRICE"><?= $Page->SELL_PRICE->caption() ?></span></td>
        <td data-name="SELL_PRICE" <?= $Page->SELL_PRICE->cellAttributes() ?>>
<span id="el_TREATMENT_BOOKING_SELL_PRICE">
<span<?= $Page->SELL_PRICE->viewAttributes() ?>>
<?= $Page->SELL_PRICE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ACCOUNT_ID->Visible) { // ACCOUNT_ID ?>
    <tr id="r_ACCOUNT_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BOOKING_ACCOUNT_ID"><?= $Page->ACCOUNT_ID->caption() ?></span></td>
        <td data-name="ACCOUNT_ID" <?= $Page->ACCOUNT_ID->cellAttributes() ?>>
<span id="el_TREATMENT_BOOKING_ACCOUNT_ID">
<span<?= $Page->ACCOUNT_ID->viewAttributes() ?>>
<?= $Page->ACCOUNT_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->subsidi->Visible) { // subsidi ?>
    <tr id="r_subsidi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BOOKING_subsidi"><?= $Page->subsidi->caption() ?></span></td>
        <td data-name="subsidi" <?= $Page->subsidi->cellAttributes() ?>>
<span id="el_TREATMENT_BOOKING_subsidi">
<span<?= $Page->subsidi->viewAttributes() ?>>
<?= $Page->subsidi->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->DISCOUNT->Visible) { // DISCOUNT ?>
    <tr id="r_DISCOUNT">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BOOKING_DISCOUNT"><?= $Page->DISCOUNT->caption() ?></span></td>
        <td data-name="DISCOUNT" <?= $Page->DISCOUNT->cellAttributes() ?>>
<span id="el_TREATMENT_BOOKING_DISCOUNT">
<span<?= $Page->DISCOUNT->viewAttributes() ?>>
<?= $Page->DISCOUNT->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->AMOUNT->Visible) { // AMOUNT ?>
    <tr id="r_AMOUNT">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BOOKING_AMOUNT"><?= $Page->AMOUNT->caption() ?></span></td>
        <td data-name="AMOUNT" <?= $Page->AMOUNT->cellAttributes() ?>>
<span id="el_TREATMENT_BOOKING_AMOUNT">
<span<?= $Page->AMOUNT->viewAttributes() ?>>
<?= $Page->AMOUNT->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->PPN->Visible) { // PPN ?>
    <tr id="r_PPN">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BOOKING_PPN"><?= $Page->PPN->caption() ?></span></td>
        <td data-name="PPN" <?= $Page->PPN->cellAttributes() ?>>
<span id="el_TREATMENT_BOOKING_PPN">
<span<?= $Page->PPN->viewAttributes() ?>>
<?= $Page->PPN->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->SUBSIDISAT->Visible) { // SUBSIDISAT ?>
    <tr id="r_SUBSIDISAT">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BOOKING_SUBSIDISAT"><?= $Page->SUBSIDISAT->caption() ?></span></td>
        <td data-name="SUBSIDISAT" <?= $Page->SUBSIDISAT->cellAttributes() ?>>
<span id="el_TREATMENT_BOOKING_SUBSIDISAT">
<span<?= $Page->SUBSIDISAT->viewAttributes() ?>>
<?= $Page->SUBSIDISAT->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->PRINTQ->Visible) { // PRINTQ ?>
    <tr id="r_PRINTQ">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BOOKING_PRINTQ"><?= $Page->PRINTQ->caption() ?></span></td>
        <td data-name="PRINTQ" <?= $Page->PRINTQ->cellAttributes() ?>>
<span id="el_TREATMENT_BOOKING_PRINTQ">
<span<?= $Page->PRINTQ->viewAttributes() ?>>
<?= $Page->PRINTQ->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->PRINTED_BY->Visible) { // PRINTED_BY ?>
    <tr id="r_PRINTED_BY">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BOOKING_PRINTED_BY"><?= $Page->PRINTED_BY->caption() ?></span></td>
        <td data-name="PRINTED_BY" <?= $Page->PRINTED_BY->cellAttributes() ?>>
<span id="el_TREATMENT_BOOKING_PRINTED_BY">
<span<?= $Page->PRINTED_BY->viewAttributes() ?>>
<?= $Page->PRINTED_BY->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->STATUS_TARIF->Visible) { // STATUS_TARIF ?>
    <tr id="r_STATUS_TARIF">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BOOKING_STATUS_TARIF"><?= $Page->STATUS_TARIF->caption() ?></span></td>
        <td data-name="STATUS_TARIF" <?= $Page->STATUS_TARIF->cellAttributes() ?>>
<span id="el_TREATMENT_BOOKING_STATUS_TARIF">
<span<?= $Page->STATUS_TARIF->viewAttributes() ?>>
<?= $Page->STATUS_TARIF->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->CLINIC_TYPE->Visible) { // CLINIC_TYPE ?>
    <tr id="r_CLINIC_TYPE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BOOKING_CLINIC_TYPE"><?= $Page->CLINIC_TYPE->caption() ?></span></td>
        <td data-name="CLINIC_TYPE" <?= $Page->CLINIC_TYPE->cellAttributes() ?>>
<span id="el_TREATMENT_BOOKING_CLINIC_TYPE">
<span<?= $Page->CLINIC_TYPE->viewAttributes() ?>>
<?= $Page->CLINIC_TYPE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->PACKAGE_ID->Visible) { // PACKAGE_ID ?>
    <tr id="r_PACKAGE_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BOOKING_PACKAGE_ID"><?= $Page->PACKAGE_ID->caption() ?></span></td>
        <td data-name="PACKAGE_ID" <?= $Page->PACKAGE_ID->cellAttributes() ?>>
<span id="el_TREATMENT_BOOKING_PACKAGE_ID">
<span<?= $Page->PACKAGE_ID->viewAttributes() ?>>
<?= $Page->PACKAGE_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->MODULE_ID->Visible) { // MODULE_ID ?>
    <tr id="r_MODULE_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BOOKING_MODULE_ID"><?= $Page->MODULE_ID->caption() ?></span></td>
        <td data-name="MODULE_ID" <?= $Page->MODULE_ID->cellAttributes() ?>>
<span id="el_TREATMENT_BOOKING_MODULE_ID">
<span<?= $Page->MODULE_ID->viewAttributes() ?>>
<?= $Page->MODULE_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->THEORDER->Visible) { // THEORDER ?>
    <tr id="r_THEORDER">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BOOKING_THEORDER"><?= $Page->THEORDER->caption() ?></span></td>
        <td data-name="THEORDER" <?= $Page->THEORDER->cellAttributes() ?>>
<span id="el_TREATMENT_BOOKING_THEORDER">
<span<?= $Page->THEORDER->viewAttributes() ?>>
<?= $Page->THEORDER->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->CORRECTION_ID->Visible) { // CORRECTION_ID ?>
    <tr id="r_CORRECTION_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BOOKING_CORRECTION_ID"><?= $Page->CORRECTION_ID->caption() ?></span></td>
        <td data-name="CORRECTION_ID" <?= $Page->CORRECTION_ID->cellAttributes() ?>>
<span id="el_TREATMENT_BOOKING_CORRECTION_ID">
<span<?= $Page->CORRECTION_ID->viewAttributes() ?>>
<?= $Page->CORRECTION_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->CORRECTION_BY->Visible) { // CORRECTION_BY ?>
    <tr id="r_CORRECTION_BY">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BOOKING_CORRECTION_BY"><?= $Page->CORRECTION_BY->caption() ?></span></td>
        <td data-name="CORRECTION_BY" <?= $Page->CORRECTION_BY->cellAttributes() ?>>
<span id="el_TREATMENT_BOOKING_CORRECTION_BY">
<span<?= $Page->CORRECTION_BY->viewAttributes() ?>>
<?= $Page->CORRECTION_BY->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->CASHIER->Visible) { // CASHIER ?>
    <tr id="r_CASHIER">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BOOKING_CASHIER"><?= $Page->CASHIER->caption() ?></span></td>
        <td data-name="CASHIER" <?= $Page->CASHIER->cellAttributes() ?>>
<span id="el_TREATMENT_BOOKING_CASHIER">
<span<?= $Page->CASHIER->viewAttributes() ?>>
<?= $Page->CASHIER->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->PAYOR_ID->Visible) { // PAYOR_ID ?>
    <tr id="r_PAYOR_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BOOKING_PAYOR_ID"><?= $Page->PAYOR_ID->caption() ?></span></td>
        <td data-name="PAYOR_ID" <?= $Page->PAYOR_ID->cellAttributes() ?>>
<span id="el_TREATMENT_BOOKING_PAYOR_ID">
<span<?= $Page->PAYOR_ID->viewAttributes() ?>>
<?= $Page->PAYOR_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->KAL_ID->Visible) { // KAL_ID ?>
    <tr id="r_KAL_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BOOKING_KAL_ID"><?= $Page->KAL_ID->caption() ?></span></td>
        <td data-name="KAL_ID" <?= $Page->KAL_ID->cellAttributes() ?>>
<span id="el_TREATMENT_BOOKING_KAL_ID">
<span<?= $Page->KAL_ID->viewAttributes() ?>>
<?= $Page->KAL_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
