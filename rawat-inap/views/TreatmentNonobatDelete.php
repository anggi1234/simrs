<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

// Page object
$TreatmentNonobatDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fTREATMENT_NONOBATdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fTREATMENT_NONOBATdelete = currentForm = new ew.Form("fTREATMENT_NONOBATdelete", "delete");
    loadjs.done("fTREATMENT_NONOBATdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.TREATMENT_NONOBAT) ew.vars.tables.TREATMENT_NONOBAT = <?= JsonEncode(GetClientVar("tables", "TREATMENT_NONOBAT")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fTREATMENT_NONOBATdelete" id="fTREATMENT_NONOBATdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="TREATMENT_NONOBAT">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($Page->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?= HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table class="table ew-table">
    <thead>
    <tr class="ew-table-header">
<?php if ($Page->ORG_UNIT_CODE->Visible) { // ORG_UNIT_CODE ?>
        <th class="<?= $Page->ORG_UNIT_CODE->headerCellClass() ?>"><span id="elh_TREATMENT_NONOBAT_ORG_UNIT_CODE" class="TREATMENT_NONOBAT_ORG_UNIT_CODE"><?= $Page->ORG_UNIT_CODE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->BILL_ID->Visible) { // BILL_ID ?>
        <th class="<?= $Page->BILL_ID->headerCellClass() ?>"><span id="elh_TREATMENT_NONOBAT_BILL_ID" class="TREATMENT_NONOBAT_BILL_ID"><?= $Page->BILL_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->NO_REGISTRATION->Visible) { // NO_REGISTRATION ?>
        <th class="<?= $Page->NO_REGISTRATION->headerCellClass() ?>"><span id="elh_TREATMENT_NONOBAT_NO_REGISTRATION" class="TREATMENT_NONOBAT_NO_REGISTRATION"><?= $Page->NO_REGISTRATION->caption() ?></span></th>
<?php } ?>
<?php if ($Page->VISIT_ID->Visible) { // VISIT_ID ?>
        <th class="<?= $Page->VISIT_ID->headerCellClass() ?>"><span id="elh_TREATMENT_NONOBAT_VISIT_ID" class="TREATMENT_NONOBAT_VISIT_ID"><?= $Page->VISIT_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->TARIF_ID->Visible) { // TARIF_ID ?>
        <th class="<?= $Page->TARIF_ID->headerCellClass() ?>"><span id="elh_TREATMENT_NONOBAT_TARIF_ID" class="TREATMENT_NONOBAT_TARIF_ID"><?= $Page->TARIF_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->CLASS_ID->Visible) { // CLASS_ID ?>
        <th class="<?= $Page->CLASS_ID->headerCellClass() ?>"><span id="elh_TREATMENT_NONOBAT_CLASS_ID" class="TREATMENT_NONOBAT_CLASS_ID"><?= $Page->CLASS_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->CLINIC_ID->Visible) { // CLINIC_ID ?>
        <th class="<?= $Page->CLINIC_ID->headerCellClass() ?>"><span id="elh_TREATMENT_NONOBAT_CLINIC_ID" class="TREATMENT_NONOBAT_CLINIC_ID"><?= $Page->CLINIC_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->CLINIC_ID_FROM->Visible) { // CLINIC_ID_FROM ?>
        <th class="<?= $Page->CLINIC_ID_FROM->headerCellClass() ?>"><span id="elh_TREATMENT_NONOBAT_CLINIC_ID_FROM" class="TREATMENT_NONOBAT_CLINIC_ID_FROM"><?= $Page->CLINIC_ID_FROM->caption() ?></span></th>
<?php } ?>
<?php if ($Page->TREATMENT->Visible) { // TREATMENT ?>
        <th class="<?= $Page->TREATMENT->headerCellClass() ?>"><span id="elh_TREATMENT_NONOBAT_TREATMENT" class="TREATMENT_NONOBAT_TREATMENT"><?= $Page->TREATMENT->caption() ?></span></th>
<?php } ?>
<?php if ($Page->TREAT_DATE->Visible) { // TREAT_DATE ?>
        <th class="<?= $Page->TREAT_DATE->headerCellClass() ?>"><span id="elh_TREATMENT_NONOBAT_TREAT_DATE" class="TREATMENT_NONOBAT_TREAT_DATE"><?= $Page->TREAT_DATE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->QUANTITY->Visible) { // QUANTITY ?>
        <th class="<?= $Page->QUANTITY->headerCellClass() ?>"><span id="elh_TREATMENT_NONOBAT_QUANTITY" class="TREATMENT_NONOBAT_QUANTITY"><?= $Page->QUANTITY->caption() ?></span></th>
<?php } ?>
<?php if ($Page->MEASURE_ID->Visible) { // MEASURE_ID ?>
        <th class="<?= $Page->MEASURE_ID->headerCellClass() ?>"><span id="elh_TREATMENT_NONOBAT_MEASURE_ID" class="TREATMENT_NONOBAT_MEASURE_ID"><?= $Page->MEASURE_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->DESCRIPTION->Visible) { // DESCRIPTION ?>
        <th class="<?= $Page->DESCRIPTION->headerCellClass() ?>"><span id="elh_TREATMENT_NONOBAT_DESCRIPTION" class="TREATMENT_NONOBAT_DESCRIPTION"><?= $Page->DESCRIPTION->caption() ?></span></th>
<?php } ?>
<?php if ($Page->CLASS_ROOM_ID->Visible) { // CLASS_ROOM_ID ?>
        <th class="<?= $Page->CLASS_ROOM_ID->headerCellClass() ?>"><span id="elh_TREATMENT_NONOBAT_CLASS_ROOM_ID" class="TREATMENT_NONOBAT_CLASS_ROOM_ID"><?= $Page->CLASS_ROOM_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->KELUAR_ID->Visible) { // KELUAR_ID ?>
        <th class="<?= $Page->KELUAR_ID->headerCellClass() ?>"><span id="elh_TREATMENT_NONOBAT_KELUAR_ID" class="TREATMENT_NONOBAT_KELUAR_ID"><?= $Page->KELUAR_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->BED_ID->Visible) { // BED_ID ?>
        <th class="<?= $Page->BED_ID->headerCellClass() ?>"><span id="elh_TREATMENT_NONOBAT_BED_ID" class="TREATMENT_NONOBAT_BED_ID"><?= $Page->BED_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->EMPLOYEE_ID->Visible) { // EMPLOYEE_ID ?>
        <th class="<?= $Page->EMPLOYEE_ID->headerCellClass() ?>"><span id="elh_TREATMENT_NONOBAT_EMPLOYEE_ID" class="TREATMENT_NONOBAT_EMPLOYEE_ID"><?= $Page->EMPLOYEE_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->DOCTOR->Visible) { // DOCTOR ?>
        <th class="<?= $Page->DOCTOR->headerCellClass() ?>"><span id="elh_TREATMENT_NONOBAT_DOCTOR" class="TREATMENT_NONOBAT_DOCTOR"><?= $Page->DOCTOR->caption() ?></span></th>
<?php } ?>
<?php if ($Page->EXIT_DATE->Visible) { // EXIT_DATE ?>
        <th class="<?= $Page->EXIT_DATE->headerCellClass() ?>"><span id="elh_TREATMENT_NONOBAT_EXIT_DATE" class="TREATMENT_NONOBAT_EXIT_DATE"><?= $Page->EXIT_DATE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->EMPLOYEE_ID_FROM->Visible) { // EMPLOYEE_ID_FROM ?>
        <th class="<?= $Page->EMPLOYEE_ID_FROM->headerCellClass() ?>"><span id="elh_TREATMENT_NONOBAT_EMPLOYEE_ID_FROM" class="TREATMENT_NONOBAT_EMPLOYEE_ID_FROM"><?= $Page->EMPLOYEE_ID_FROM->caption() ?></span></th>
<?php } ?>
<?php if ($Page->DOCTOR_FROM->Visible) { // DOCTOR_FROM ?>
        <th class="<?= $Page->DOCTOR_FROM->headerCellClass() ?>"><span id="elh_TREATMENT_NONOBAT_DOCTOR_FROM" class="TREATMENT_NONOBAT_DOCTOR_FROM"><?= $Page->DOCTOR_FROM->caption() ?></span></th>
<?php } ?>
<?php if ($Page->STATUS_PASIEN_ID->Visible) { // STATUS_PASIEN_ID ?>
        <th class="<?= $Page->STATUS_PASIEN_ID->headerCellClass() ?>"><span id="elh_TREATMENT_NONOBAT_STATUS_PASIEN_ID" class="TREATMENT_NONOBAT_STATUS_PASIEN_ID"><?= $Page->STATUS_PASIEN_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->THENAME->Visible) { // THENAME ?>
        <th class="<?= $Page->THENAME->headerCellClass() ?>"><span id="elh_TREATMENT_NONOBAT_THENAME" class="TREATMENT_NONOBAT_THENAME"><?= $Page->THENAME->caption() ?></span></th>
<?php } ?>
<?php if ($Page->THEADDRESS->Visible) { // THEADDRESS ?>
        <th class="<?= $Page->THEADDRESS->headerCellClass() ?>"><span id="elh_TREATMENT_NONOBAT_THEADDRESS" class="TREATMENT_NONOBAT_THEADDRESS"><?= $Page->THEADDRESS->caption() ?></span></th>
<?php } ?>
<?php if ($Page->THEID->Visible) { // THEID ?>
        <th class="<?= $Page->THEID->headerCellClass() ?>"><span id="elh_TREATMENT_NONOBAT_THEID" class="TREATMENT_NONOBAT_THEID"><?= $Page->THEID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->SERIAL_NB->Visible) { // SERIAL_NB ?>
        <th class="<?= $Page->SERIAL_NB->headerCellClass() ?>"><span id="elh_TREATMENT_NONOBAT_SERIAL_NB" class="TREATMENT_NONOBAT_SERIAL_NB"><?= $Page->SERIAL_NB->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ISRJ->Visible) { // ISRJ ?>
        <th class="<?= $Page->ISRJ->headerCellClass() ?>"><span id="elh_TREATMENT_NONOBAT_ISRJ" class="TREATMENT_NONOBAT_ISRJ"><?= $Page->ISRJ->caption() ?></span></th>
<?php } ?>
<?php if ($Page->AGEYEAR->Visible) { // AGEYEAR ?>
        <th class="<?= $Page->AGEYEAR->headerCellClass() ?>"><span id="elh_TREATMENT_NONOBAT_AGEYEAR" class="TREATMENT_NONOBAT_AGEYEAR"><?= $Page->AGEYEAR->caption() ?></span></th>
<?php } ?>
<?php if ($Page->AGEMONTH->Visible) { // AGEMONTH ?>
        <th class="<?= $Page->AGEMONTH->headerCellClass() ?>"><span id="elh_TREATMENT_NONOBAT_AGEMONTH" class="TREATMENT_NONOBAT_AGEMONTH"><?= $Page->AGEMONTH->caption() ?></span></th>
<?php } ?>
<?php if ($Page->AGEDAY->Visible) { // AGEDAY ?>
        <th class="<?= $Page->AGEDAY->headerCellClass() ?>"><span id="elh_TREATMENT_NONOBAT_AGEDAY" class="TREATMENT_NONOBAT_AGEDAY"><?= $Page->AGEDAY->caption() ?></span></th>
<?php } ?>
<?php if ($Page->GENDER->Visible) { // GENDER ?>
        <th class="<?= $Page->GENDER->headerCellClass() ?>"><span id="elh_TREATMENT_NONOBAT_GENDER" class="TREATMENT_NONOBAT_GENDER"><?= $Page->GENDER->caption() ?></span></th>
<?php } ?>
<?php if ($Page->KARYAWAN->Visible) { // KARYAWAN ?>
        <th class="<?= $Page->KARYAWAN->headerCellClass() ?>"><span id="elh_TREATMENT_NONOBAT_KARYAWAN" class="TREATMENT_NONOBAT_KARYAWAN"><?= $Page->KARYAWAN->caption() ?></span></th>
<?php } ?>
<?php if ($Page->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
        <th class="<?= $Page->MODIFIED_BY->headerCellClass() ?>"><span id="elh_TREATMENT_NONOBAT_MODIFIED_BY" class="TREATMENT_NONOBAT_MODIFIED_BY"><?= $Page->MODIFIED_BY->caption() ?></span></th>
<?php } ?>
<?php if ($Page->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
        <th class="<?= $Page->MODIFIED_DATE->headerCellClass() ?>"><span id="elh_TREATMENT_NONOBAT_MODIFIED_DATE" class="TREATMENT_NONOBAT_MODIFIED_DATE"><?= $Page->MODIFIED_DATE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->MODIFIED_FROM->Visible) { // MODIFIED_FROM ?>
        <th class="<?= $Page->MODIFIED_FROM->headerCellClass() ?>"><span id="elh_TREATMENT_NONOBAT_MODIFIED_FROM" class="TREATMENT_NONOBAT_MODIFIED_FROM"><?= $Page->MODIFIED_FROM->caption() ?></span></th>
<?php } ?>
<?php if ($Page->POTONGAN->Visible) { // POTONGAN ?>
        <th class="<?= $Page->POTONGAN->headerCellClass() ?>"><span id="elh_TREATMENT_NONOBAT_POTONGAN" class="TREATMENT_NONOBAT_POTONGAN"><?= $Page->POTONGAN->caption() ?></span></th>
<?php } ?>
<?php if ($Page->BAYAR->Visible) { // BAYAR ?>
        <th class="<?= $Page->BAYAR->headerCellClass() ?>"><span id="elh_TREATMENT_NONOBAT_BAYAR" class="TREATMENT_NONOBAT_BAYAR"><?= $Page->BAYAR->caption() ?></span></th>
<?php } ?>
<?php if ($Page->RETUR->Visible) { // RETUR ?>
        <th class="<?= $Page->RETUR->headerCellClass() ?>"><span id="elh_TREATMENT_NONOBAT_RETUR" class="TREATMENT_NONOBAT_RETUR"><?= $Page->RETUR->caption() ?></span></th>
<?php } ?>
<?php if ($Page->TARIF_TYPE->Visible) { // TARIF_TYPE ?>
        <th class="<?= $Page->TARIF_TYPE->headerCellClass() ?>"><span id="elh_TREATMENT_NONOBAT_TARIF_TYPE" class="TREATMENT_NONOBAT_TARIF_TYPE"><?= $Page->TARIF_TYPE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->PPNVALUE->Visible) { // PPNVALUE ?>
        <th class="<?= $Page->PPNVALUE->headerCellClass() ?>"><span id="elh_TREATMENT_NONOBAT_PPNVALUE" class="TREATMENT_NONOBAT_PPNVALUE"><?= $Page->PPNVALUE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->TAGIHAN->Visible) { // TAGIHAN ?>
        <th class="<?= $Page->TAGIHAN->headerCellClass() ?>"><span id="elh_TREATMENT_NONOBAT_TAGIHAN" class="TREATMENT_NONOBAT_TAGIHAN"><?= $Page->TAGIHAN->caption() ?></span></th>
<?php } ?>
<?php if ($Page->KOREKSI->Visible) { // KOREKSI ?>
        <th class="<?= $Page->KOREKSI->headerCellClass() ?>"><span id="elh_TREATMENT_NONOBAT_KOREKSI" class="TREATMENT_NONOBAT_KOREKSI"><?= $Page->KOREKSI->caption() ?></span></th>
<?php } ?>
<?php if ($Page->AMOUNT_PAID->Visible) { // AMOUNT_PAID ?>
        <th class="<?= $Page->AMOUNT_PAID->headerCellClass() ?>"><span id="elh_TREATMENT_NONOBAT_AMOUNT_PAID" class="TREATMENT_NONOBAT_AMOUNT_PAID"><?= $Page->AMOUNT_PAID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->DISKON->Visible) { // DISKON ?>
        <th class="<?= $Page->DISKON->headerCellClass() ?>"><span id="elh_TREATMENT_NONOBAT_DISKON" class="TREATMENT_NONOBAT_DISKON"><?= $Page->DISKON->caption() ?></span></th>
<?php } ?>
<?php if ($Page->NOTA_NO->Visible) { // NOTA_NO ?>
        <th class="<?= $Page->NOTA_NO->headerCellClass() ?>"><span id="elh_TREATMENT_NONOBAT_NOTA_NO" class="TREATMENT_NONOBAT_NOTA_NO"><?= $Page->NOTA_NO->caption() ?></span></th>
<?php } ?>
<?php if ($Page->SELL_PRICE->Visible) { // SELL_PRICE ?>
        <th class="<?= $Page->SELL_PRICE->headerCellClass() ?>"><span id="elh_TREATMENT_NONOBAT_SELL_PRICE" class="TREATMENT_NONOBAT_SELL_PRICE"><?= $Page->SELL_PRICE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ACCOUNT_ID->Visible) { // ACCOUNT_ID ?>
        <th class="<?= $Page->ACCOUNT_ID->headerCellClass() ?>"><span id="elh_TREATMENT_NONOBAT_ACCOUNT_ID" class="TREATMENT_NONOBAT_ACCOUNT_ID"><?= $Page->ACCOUNT_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->subsidi->Visible) { // subsidi ?>
        <th class="<?= $Page->subsidi->headerCellClass() ?>"><span id="elh_TREATMENT_NONOBAT_subsidi" class="TREATMENT_NONOBAT_subsidi"><?= $Page->subsidi->caption() ?></span></th>
<?php } ?>
<?php if ($Page->DISCOUNT->Visible) { // DISCOUNT ?>
        <th class="<?= $Page->DISCOUNT->headerCellClass() ?>"><span id="elh_TREATMENT_NONOBAT_DISCOUNT" class="TREATMENT_NONOBAT_DISCOUNT"><?= $Page->DISCOUNT->caption() ?></span></th>
<?php } ?>
<?php if ($Page->AMOUNT->Visible) { // AMOUNT ?>
        <th class="<?= $Page->AMOUNT->headerCellClass() ?>"><span id="elh_TREATMENT_NONOBAT_AMOUNT" class="TREATMENT_NONOBAT_AMOUNT"><?= $Page->AMOUNT->caption() ?></span></th>
<?php } ?>
<?php if ($Page->PPN->Visible) { // PPN ?>
        <th class="<?= $Page->PPN->headerCellClass() ?>"><span id="elh_TREATMENT_NONOBAT_PPN" class="TREATMENT_NONOBAT_PPN"><?= $Page->PPN->caption() ?></span></th>
<?php } ?>
<?php if ($Page->SUBSIDISAT->Visible) { // SUBSIDISAT ?>
        <th class="<?= $Page->SUBSIDISAT->headerCellClass() ?>"><span id="elh_TREATMENT_NONOBAT_SUBSIDISAT" class="TREATMENT_NONOBAT_SUBSIDISAT"><?= $Page->SUBSIDISAT->caption() ?></span></th>
<?php } ?>
<?php if ($Page->PRINTQ->Visible) { // PRINTQ ?>
        <th class="<?= $Page->PRINTQ->headerCellClass() ?>"><span id="elh_TREATMENT_NONOBAT_PRINTQ" class="TREATMENT_NONOBAT_PRINTQ"><?= $Page->PRINTQ->caption() ?></span></th>
<?php } ?>
<?php if ($Page->PRINTED_BY->Visible) { // PRINTED_BY ?>
        <th class="<?= $Page->PRINTED_BY->headerCellClass() ?>"><span id="elh_TREATMENT_NONOBAT_PRINTED_BY" class="TREATMENT_NONOBAT_PRINTED_BY"><?= $Page->PRINTED_BY->caption() ?></span></th>
<?php } ?>
<?php if ($Page->STATUS_TARIF->Visible) { // STATUS_TARIF ?>
        <th class="<?= $Page->STATUS_TARIF->headerCellClass() ?>"><span id="elh_TREATMENT_NONOBAT_STATUS_TARIF" class="TREATMENT_NONOBAT_STATUS_TARIF"><?= $Page->STATUS_TARIF->caption() ?></span></th>
<?php } ?>
<?php if ($Page->PACKAGE_ID->Visible) { // PACKAGE_ID ?>
        <th class="<?= $Page->PACKAGE_ID->headerCellClass() ?>"><span id="elh_TREATMENT_NONOBAT_PACKAGE_ID" class="TREATMENT_NONOBAT_PACKAGE_ID"><?= $Page->PACKAGE_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->MODULE_ID->Visible) { // MODULE_ID ?>
        <th class="<?= $Page->MODULE_ID->headerCellClass() ?>"><span id="elh_TREATMENT_NONOBAT_MODULE_ID" class="TREATMENT_NONOBAT_MODULE_ID"><?= $Page->MODULE_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->THEORDER->Visible) { // THEORDER ?>
        <th class="<?= $Page->THEORDER->headerCellClass() ?>"><span id="elh_TREATMENT_NONOBAT_THEORDER" class="TREATMENT_NONOBAT_THEORDER"><?= $Page->THEORDER->caption() ?></span></th>
<?php } ?>
<?php if ($Page->CORRECTION_ID->Visible) { // CORRECTION_ID ?>
        <th class="<?= $Page->CORRECTION_ID->headerCellClass() ?>"><span id="elh_TREATMENT_NONOBAT_CORRECTION_ID" class="TREATMENT_NONOBAT_CORRECTION_ID"><?= $Page->CORRECTION_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->CORRECTION_BY->Visible) { // CORRECTION_BY ?>
        <th class="<?= $Page->CORRECTION_BY->headerCellClass() ?>"><span id="elh_TREATMENT_NONOBAT_CORRECTION_BY" class="TREATMENT_NONOBAT_CORRECTION_BY"><?= $Page->CORRECTION_BY->caption() ?></span></th>
<?php } ?>
<?php if ($Page->CASHIER->Visible) { // CASHIER ?>
        <th class="<?= $Page->CASHIER->headerCellClass() ?>"><span id="elh_TREATMENT_NONOBAT_CASHIER" class="TREATMENT_NONOBAT_CASHIER"><?= $Page->CASHIER->caption() ?></span></th>
<?php } ?>
    </tr>
    </thead>
    <tbody>
<?php
$Page->RecordCount = 0;
$i = 0;
while (!$Page->Recordset->EOF) {
    $Page->RecordCount++;
    $Page->RowCount++;

    // Set row properties
    $Page->resetAttributes();
    $Page->RowType = ROWTYPE_VIEW; // View

    // Get the field contents
    $Page->loadRowValues($Page->Recordset);

    // Render row
    $Page->renderRow();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php if ($Page->ORG_UNIT_CODE->Visible) { // ORG_UNIT_CODE ?>
        <td <?= $Page->ORG_UNIT_CODE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_ORG_UNIT_CODE" class="TREATMENT_NONOBAT_ORG_UNIT_CODE">
<span<?= $Page->ORG_UNIT_CODE->viewAttributes() ?>>
<?= $Page->ORG_UNIT_CODE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->BILL_ID->Visible) { // BILL_ID ?>
        <td <?= $Page->BILL_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_BILL_ID" class="TREATMENT_NONOBAT_BILL_ID">
<span<?= $Page->BILL_ID->viewAttributes() ?>>
<?= $Page->BILL_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->NO_REGISTRATION->Visible) { // NO_REGISTRATION ?>
        <td <?= $Page->NO_REGISTRATION->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_NO_REGISTRATION" class="TREATMENT_NONOBAT_NO_REGISTRATION">
<span<?= $Page->NO_REGISTRATION->viewAttributes() ?>>
<?= $Page->NO_REGISTRATION->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->VISIT_ID->Visible) { // VISIT_ID ?>
        <td <?= $Page->VISIT_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_VISIT_ID" class="TREATMENT_NONOBAT_VISIT_ID">
<span<?= $Page->VISIT_ID->viewAttributes() ?>>
<?= $Page->VISIT_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->TARIF_ID->Visible) { // TARIF_ID ?>
        <td <?= $Page->TARIF_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_TARIF_ID" class="TREATMENT_NONOBAT_TARIF_ID">
<span<?= $Page->TARIF_ID->viewAttributes() ?>>
<?= $Page->TARIF_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->CLASS_ID->Visible) { // CLASS_ID ?>
        <td <?= $Page->CLASS_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_CLASS_ID" class="TREATMENT_NONOBAT_CLASS_ID">
<span<?= $Page->CLASS_ID->viewAttributes() ?>>
<?= $Page->CLASS_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->CLINIC_ID->Visible) { // CLINIC_ID ?>
        <td <?= $Page->CLINIC_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_CLINIC_ID" class="TREATMENT_NONOBAT_CLINIC_ID">
<span<?= $Page->CLINIC_ID->viewAttributes() ?>>
<?= $Page->CLINIC_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->CLINIC_ID_FROM->Visible) { // CLINIC_ID_FROM ?>
        <td <?= $Page->CLINIC_ID_FROM->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_CLINIC_ID_FROM" class="TREATMENT_NONOBAT_CLINIC_ID_FROM">
<span<?= $Page->CLINIC_ID_FROM->viewAttributes() ?>>
<?= $Page->CLINIC_ID_FROM->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->TREATMENT->Visible) { // TREATMENT ?>
        <td <?= $Page->TREATMENT->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_TREATMENT" class="TREATMENT_NONOBAT_TREATMENT">
<span<?= $Page->TREATMENT->viewAttributes() ?>>
<?= $Page->TREATMENT->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->TREAT_DATE->Visible) { // TREAT_DATE ?>
        <td <?= $Page->TREAT_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_TREAT_DATE" class="TREATMENT_NONOBAT_TREAT_DATE">
<span<?= $Page->TREAT_DATE->viewAttributes() ?>>
<?= $Page->TREAT_DATE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->QUANTITY->Visible) { // QUANTITY ?>
        <td <?= $Page->QUANTITY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_QUANTITY" class="TREATMENT_NONOBAT_QUANTITY">
<span<?= $Page->QUANTITY->viewAttributes() ?>>
<?= $Page->QUANTITY->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->MEASURE_ID->Visible) { // MEASURE_ID ?>
        <td <?= $Page->MEASURE_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_MEASURE_ID" class="TREATMENT_NONOBAT_MEASURE_ID">
<span<?= $Page->MEASURE_ID->viewAttributes() ?>>
<?= $Page->MEASURE_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->DESCRIPTION->Visible) { // DESCRIPTION ?>
        <td <?= $Page->DESCRIPTION->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_DESCRIPTION" class="TREATMENT_NONOBAT_DESCRIPTION">
<span<?= $Page->DESCRIPTION->viewAttributes() ?>>
<?= $Page->DESCRIPTION->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->CLASS_ROOM_ID->Visible) { // CLASS_ROOM_ID ?>
        <td <?= $Page->CLASS_ROOM_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_CLASS_ROOM_ID" class="TREATMENT_NONOBAT_CLASS_ROOM_ID">
<span<?= $Page->CLASS_ROOM_ID->viewAttributes() ?>>
<?= $Page->CLASS_ROOM_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->KELUAR_ID->Visible) { // KELUAR_ID ?>
        <td <?= $Page->KELUAR_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_KELUAR_ID" class="TREATMENT_NONOBAT_KELUAR_ID">
<span<?= $Page->KELUAR_ID->viewAttributes() ?>>
<?= $Page->KELUAR_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->BED_ID->Visible) { // BED_ID ?>
        <td <?= $Page->BED_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_BED_ID" class="TREATMENT_NONOBAT_BED_ID">
<span<?= $Page->BED_ID->viewAttributes() ?>>
<?= $Page->BED_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->EMPLOYEE_ID->Visible) { // EMPLOYEE_ID ?>
        <td <?= $Page->EMPLOYEE_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_EMPLOYEE_ID" class="TREATMENT_NONOBAT_EMPLOYEE_ID">
<span<?= $Page->EMPLOYEE_ID->viewAttributes() ?>>
<?= $Page->EMPLOYEE_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->DOCTOR->Visible) { // DOCTOR ?>
        <td <?= $Page->DOCTOR->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_DOCTOR" class="TREATMENT_NONOBAT_DOCTOR">
<span<?= $Page->DOCTOR->viewAttributes() ?>>
<?= $Page->DOCTOR->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->EXIT_DATE->Visible) { // EXIT_DATE ?>
        <td <?= $Page->EXIT_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_EXIT_DATE" class="TREATMENT_NONOBAT_EXIT_DATE">
<span<?= $Page->EXIT_DATE->viewAttributes() ?>>
<?= $Page->EXIT_DATE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->EMPLOYEE_ID_FROM->Visible) { // EMPLOYEE_ID_FROM ?>
        <td <?= $Page->EMPLOYEE_ID_FROM->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_EMPLOYEE_ID_FROM" class="TREATMENT_NONOBAT_EMPLOYEE_ID_FROM">
<span<?= $Page->EMPLOYEE_ID_FROM->viewAttributes() ?>>
<?= $Page->EMPLOYEE_ID_FROM->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->DOCTOR_FROM->Visible) { // DOCTOR_FROM ?>
        <td <?= $Page->DOCTOR_FROM->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_DOCTOR_FROM" class="TREATMENT_NONOBAT_DOCTOR_FROM">
<span<?= $Page->DOCTOR_FROM->viewAttributes() ?>>
<?= $Page->DOCTOR_FROM->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->STATUS_PASIEN_ID->Visible) { // STATUS_PASIEN_ID ?>
        <td <?= $Page->STATUS_PASIEN_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_STATUS_PASIEN_ID" class="TREATMENT_NONOBAT_STATUS_PASIEN_ID">
<span<?= $Page->STATUS_PASIEN_ID->viewAttributes() ?>>
<?= $Page->STATUS_PASIEN_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->THENAME->Visible) { // THENAME ?>
        <td <?= $Page->THENAME->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_THENAME" class="TREATMENT_NONOBAT_THENAME">
<span<?= $Page->THENAME->viewAttributes() ?>>
<?= $Page->THENAME->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->THEADDRESS->Visible) { // THEADDRESS ?>
        <td <?= $Page->THEADDRESS->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_THEADDRESS" class="TREATMENT_NONOBAT_THEADDRESS">
<span<?= $Page->THEADDRESS->viewAttributes() ?>>
<?= $Page->THEADDRESS->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->THEID->Visible) { // THEID ?>
        <td <?= $Page->THEID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_THEID" class="TREATMENT_NONOBAT_THEID">
<span<?= $Page->THEID->viewAttributes() ?>>
<?= $Page->THEID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->SERIAL_NB->Visible) { // SERIAL_NB ?>
        <td <?= $Page->SERIAL_NB->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_SERIAL_NB" class="TREATMENT_NONOBAT_SERIAL_NB">
<span<?= $Page->SERIAL_NB->viewAttributes() ?>>
<?= $Page->SERIAL_NB->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ISRJ->Visible) { // ISRJ ?>
        <td <?= $Page->ISRJ->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_ISRJ" class="TREATMENT_NONOBAT_ISRJ">
<span<?= $Page->ISRJ->viewAttributes() ?>>
<?= $Page->ISRJ->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->AGEYEAR->Visible) { // AGEYEAR ?>
        <td <?= $Page->AGEYEAR->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_AGEYEAR" class="TREATMENT_NONOBAT_AGEYEAR">
<span<?= $Page->AGEYEAR->viewAttributes() ?>>
<?= $Page->AGEYEAR->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->AGEMONTH->Visible) { // AGEMONTH ?>
        <td <?= $Page->AGEMONTH->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_AGEMONTH" class="TREATMENT_NONOBAT_AGEMONTH">
<span<?= $Page->AGEMONTH->viewAttributes() ?>>
<?= $Page->AGEMONTH->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->AGEDAY->Visible) { // AGEDAY ?>
        <td <?= $Page->AGEDAY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_AGEDAY" class="TREATMENT_NONOBAT_AGEDAY">
<span<?= $Page->AGEDAY->viewAttributes() ?>>
<?= $Page->AGEDAY->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->GENDER->Visible) { // GENDER ?>
        <td <?= $Page->GENDER->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_GENDER" class="TREATMENT_NONOBAT_GENDER">
<span<?= $Page->GENDER->viewAttributes() ?>>
<?= $Page->GENDER->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->KARYAWAN->Visible) { // KARYAWAN ?>
        <td <?= $Page->KARYAWAN->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_KARYAWAN" class="TREATMENT_NONOBAT_KARYAWAN">
<span<?= $Page->KARYAWAN->viewAttributes() ?>>
<?= $Page->KARYAWAN->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
        <td <?= $Page->MODIFIED_BY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_MODIFIED_BY" class="TREATMENT_NONOBAT_MODIFIED_BY">
<span<?= $Page->MODIFIED_BY->viewAttributes() ?>>
<?= $Page->MODIFIED_BY->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
        <td <?= $Page->MODIFIED_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_MODIFIED_DATE" class="TREATMENT_NONOBAT_MODIFIED_DATE">
<span<?= $Page->MODIFIED_DATE->viewAttributes() ?>>
<?= $Page->MODIFIED_DATE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->MODIFIED_FROM->Visible) { // MODIFIED_FROM ?>
        <td <?= $Page->MODIFIED_FROM->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_MODIFIED_FROM" class="TREATMENT_NONOBAT_MODIFIED_FROM">
<span<?= $Page->MODIFIED_FROM->viewAttributes() ?>>
<?= $Page->MODIFIED_FROM->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->POTONGAN->Visible) { // POTONGAN ?>
        <td <?= $Page->POTONGAN->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_POTONGAN" class="TREATMENT_NONOBAT_POTONGAN">
<span<?= $Page->POTONGAN->viewAttributes() ?>>
<?= $Page->POTONGAN->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->BAYAR->Visible) { // BAYAR ?>
        <td <?= $Page->BAYAR->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_BAYAR" class="TREATMENT_NONOBAT_BAYAR">
<span<?= $Page->BAYAR->viewAttributes() ?>>
<?= $Page->BAYAR->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->RETUR->Visible) { // RETUR ?>
        <td <?= $Page->RETUR->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_RETUR" class="TREATMENT_NONOBAT_RETUR">
<span<?= $Page->RETUR->viewAttributes() ?>>
<?= $Page->RETUR->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->TARIF_TYPE->Visible) { // TARIF_TYPE ?>
        <td <?= $Page->TARIF_TYPE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_TARIF_TYPE" class="TREATMENT_NONOBAT_TARIF_TYPE">
<span<?= $Page->TARIF_TYPE->viewAttributes() ?>>
<?= $Page->TARIF_TYPE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->PPNVALUE->Visible) { // PPNVALUE ?>
        <td <?= $Page->PPNVALUE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_PPNVALUE" class="TREATMENT_NONOBAT_PPNVALUE">
<span<?= $Page->PPNVALUE->viewAttributes() ?>>
<?= $Page->PPNVALUE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->TAGIHAN->Visible) { // TAGIHAN ?>
        <td <?= $Page->TAGIHAN->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_TAGIHAN" class="TREATMENT_NONOBAT_TAGIHAN">
<span<?= $Page->TAGIHAN->viewAttributes() ?>>
<?= $Page->TAGIHAN->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->KOREKSI->Visible) { // KOREKSI ?>
        <td <?= $Page->KOREKSI->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_KOREKSI" class="TREATMENT_NONOBAT_KOREKSI">
<span<?= $Page->KOREKSI->viewAttributes() ?>>
<?= $Page->KOREKSI->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->AMOUNT_PAID->Visible) { // AMOUNT_PAID ?>
        <td <?= $Page->AMOUNT_PAID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_AMOUNT_PAID" class="TREATMENT_NONOBAT_AMOUNT_PAID">
<span<?= $Page->AMOUNT_PAID->viewAttributes() ?>>
<?= $Page->AMOUNT_PAID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->DISKON->Visible) { // DISKON ?>
        <td <?= $Page->DISKON->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_DISKON" class="TREATMENT_NONOBAT_DISKON">
<span<?= $Page->DISKON->viewAttributes() ?>>
<?= $Page->DISKON->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->NOTA_NO->Visible) { // NOTA_NO ?>
        <td <?= $Page->NOTA_NO->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_NOTA_NO" class="TREATMENT_NONOBAT_NOTA_NO">
<span<?= $Page->NOTA_NO->viewAttributes() ?>>
<?= $Page->NOTA_NO->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->SELL_PRICE->Visible) { // SELL_PRICE ?>
        <td <?= $Page->SELL_PRICE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_SELL_PRICE" class="TREATMENT_NONOBAT_SELL_PRICE">
<span<?= $Page->SELL_PRICE->viewAttributes() ?>>
<?= $Page->SELL_PRICE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ACCOUNT_ID->Visible) { // ACCOUNT_ID ?>
        <td <?= $Page->ACCOUNT_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_ACCOUNT_ID" class="TREATMENT_NONOBAT_ACCOUNT_ID">
<span<?= $Page->ACCOUNT_ID->viewAttributes() ?>>
<?= $Page->ACCOUNT_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->subsidi->Visible) { // subsidi ?>
        <td <?= $Page->subsidi->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_subsidi" class="TREATMENT_NONOBAT_subsidi">
<span<?= $Page->subsidi->viewAttributes() ?>>
<?= $Page->subsidi->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->DISCOUNT->Visible) { // DISCOUNT ?>
        <td <?= $Page->DISCOUNT->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_DISCOUNT" class="TREATMENT_NONOBAT_DISCOUNT">
<span<?= $Page->DISCOUNT->viewAttributes() ?>>
<?= $Page->DISCOUNT->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->AMOUNT->Visible) { // AMOUNT ?>
        <td <?= $Page->AMOUNT->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_AMOUNT" class="TREATMENT_NONOBAT_AMOUNT">
<span<?= $Page->AMOUNT->viewAttributes() ?>>
<?= $Page->AMOUNT->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->PPN->Visible) { // PPN ?>
        <td <?= $Page->PPN->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_PPN" class="TREATMENT_NONOBAT_PPN">
<span<?= $Page->PPN->viewAttributes() ?>>
<?= $Page->PPN->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->SUBSIDISAT->Visible) { // SUBSIDISAT ?>
        <td <?= $Page->SUBSIDISAT->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_SUBSIDISAT" class="TREATMENT_NONOBAT_SUBSIDISAT">
<span<?= $Page->SUBSIDISAT->viewAttributes() ?>>
<?= $Page->SUBSIDISAT->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->PRINTQ->Visible) { // PRINTQ ?>
        <td <?= $Page->PRINTQ->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_PRINTQ" class="TREATMENT_NONOBAT_PRINTQ">
<span<?= $Page->PRINTQ->viewAttributes() ?>>
<?= $Page->PRINTQ->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->PRINTED_BY->Visible) { // PRINTED_BY ?>
        <td <?= $Page->PRINTED_BY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_PRINTED_BY" class="TREATMENT_NONOBAT_PRINTED_BY">
<span<?= $Page->PRINTED_BY->viewAttributes() ?>>
<?= $Page->PRINTED_BY->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->STATUS_TARIF->Visible) { // STATUS_TARIF ?>
        <td <?= $Page->STATUS_TARIF->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_STATUS_TARIF" class="TREATMENT_NONOBAT_STATUS_TARIF">
<span<?= $Page->STATUS_TARIF->viewAttributes() ?>>
<?= $Page->STATUS_TARIF->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->PACKAGE_ID->Visible) { // PACKAGE_ID ?>
        <td <?= $Page->PACKAGE_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_PACKAGE_ID" class="TREATMENT_NONOBAT_PACKAGE_ID">
<span<?= $Page->PACKAGE_ID->viewAttributes() ?>>
<?= $Page->PACKAGE_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->MODULE_ID->Visible) { // MODULE_ID ?>
        <td <?= $Page->MODULE_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_MODULE_ID" class="TREATMENT_NONOBAT_MODULE_ID">
<span<?= $Page->MODULE_ID->viewAttributes() ?>>
<?= $Page->MODULE_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->THEORDER->Visible) { // THEORDER ?>
        <td <?= $Page->THEORDER->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_THEORDER" class="TREATMENT_NONOBAT_THEORDER">
<span<?= $Page->THEORDER->viewAttributes() ?>>
<?= $Page->THEORDER->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->CORRECTION_ID->Visible) { // CORRECTION_ID ?>
        <td <?= $Page->CORRECTION_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_CORRECTION_ID" class="TREATMENT_NONOBAT_CORRECTION_ID">
<span<?= $Page->CORRECTION_ID->viewAttributes() ?>>
<?= $Page->CORRECTION_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->CORRECTION_BY->Visible) { // CORRECTION_BY ?>
        <td <?= $Page->CORRECTION_BY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_CORRECTION_BY" class="TREATMENT_NONOBAT_CORRECTION_BY">
<span<?= $Page->CORRECTION_BY->viewAttributes() ?>>
<?= $Page->CORRECTION_BY->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->CASHIER->Visible) { // CASHIER ?>
        <td <?= $Page->CASHIER->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_NONOBAT_CASHIER" class="TREATMENT_NONOBAT_CASHIER">
<span<?= $Page->CASHIER->viewAttributes() ?>>
<?= $Page->CASHIER->getViewValue() ?></span>
</span>
</td>
<?php } ?>
    </tr>
<?php
    $Page->Recordset->moveNext();
}
$Page->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
