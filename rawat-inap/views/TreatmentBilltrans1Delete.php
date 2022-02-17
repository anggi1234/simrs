<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

// Page object
$TreatmentBilltrans1Delete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fTREATMENT_BILLTRANS1delete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fTREATMENT_BILLTRANS1delete = currentForm = new ew.Form("fTREATMENT_BILLTRANS1delete", "delete");
    loadjs.done("fTREATMENT_BILLTRANS1delete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.TREATMENT_BILLTRANS1) ew.vars.tables.TREATMENT_BILLTRANS1 = <?= JsonEncode(GetClientVar("tables", "TREATMENT_BILLTRANS1")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fTREATMENT_BILLTRANS1delete" id="fTREATMENT_BILLTRANS1delete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="TREATMENT_BILLTRANS1">
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
        <th class="<?= $Page->ORG_UNIT_CODE->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_ORG_UNIT_CODE" class="TREATMENT_BILLTRANS1_ORG_UNIT_CODE"><?= $Page->ORG_UNIT_CODE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->BILL_ID->Visible) { // BILL_ID ?>
        <th class="<?= $Page->BILL_ID->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_BILL_ID" class="TREATMENT_BILLTRANS1_BILL_ID"><?= $Page->BILL_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->NO_REGISTRATION->Visible) { // NO_REGISTRATION ?>
        <th class="<?= $Page->NO_REGISTRATION->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_NO_REGISTRATION" class="TREATMENT_BILLTRANS1_NO_REGISTRATION"><?= $Page->NO_REGISTRATION->caption() ?></span></th>
<?php } ?>
<?php if ($Page->VISIT_ID->Visible) { // VISIT_ID ?>
        <th class="<?= $Page->VISIT_ID->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_VISIT_ID" class="TREATMENT_BILLTRANS1_VISIT_ID"><?= $Page->VISIT_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->TARIF_ID->Visible) { // TARIF_ID ?>
        <th class="<?= $Page->TARIF_ID->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_TARIF_ID" class="TREATMENT_BILLTRANS1_TARIF_ID"><?= $Page->TARIF_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->CLASS_ID->Visible) { // CLASS_ID ?>
        <th class="<?= $Page->CLASS_ID->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_CLASS_ID" class="TREATMENT_BILLTRANS1_CLASS_ID"><?= $Page->CLASS_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->CLINIC_ID->Visible) { // CLINIC_ID ?>
        <th class="<?= $Page->CLINIC_ID->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_CLINIC_ID" class="TREATMENT_BILLTRANS1_CLINIC_ID"><?= $Page->CLINIC_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->CLINIC_ID_FROM->Visible) { // CLINIC_ID_FROM ?>
        <th class="<?= $Page->CLINIC_ID_FROM->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_CLINIC_ID_FROM" class="TREATMENT_BILLTRANS1_CLINIC_ID_FROM"><?= $Page->CLINIC_ID_FROM->caption() ?></span></th>
<?php } ?>
<?php if ($Page->TREATMENT->Visible) { // TREATMENT ?>
        <th class="<?= $Page->TREATMENT->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_TREATMENT" class="TREATMENT_BILLTRANS1_TREATMENT"><?= $Page->TREATMENT->caption() ?></span></th>
<?php } ?>
<?php if ($Page->TREAT_DATE->Visible) { // TREAT_DATE ?>
        <th class="<?= $Page->TREAT_DATE->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_TREAT_DATE" class="TREATMENT_BILLTRANS1_TREAT_DATE"><?= $Page->TREAT_DATE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->AMOUNT->Visible) { // AMOUNT ?>
        <th class="<?= $Page->AMOUNT->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_AMOUNT" class="TREATMENT_BILLTRANS1_AMOUNT"><?= $Page->AMOUNT->caption() ?></span></th>
<?php } ?>
<?php if ($Page->QUANTITY->Visible) { // QUANTITY ?>
        <th class="<?= $Page->QUANTITY->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_QUANTITY" class="TREATMENT_BILLTRANS1_QUANTITY"><?= $Page->QUANTITY->caption() ?></span></th>
<?php } ?>
<?php if ($Page->MEASURE_ID->Visible) { // MEASURE_ID ?>
        <th class="<?= $Page->MEASURE_ID->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_MEASURE_ID" class="TREATMENT_BILLTRANS1_MEASURE_ID"><?= $Page->MEASURE_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->POKOK_JUAL->Visible) { // POKOK_JUAL ?>
        <th class="<?= $Page->POKOK_JUAL->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_POKOK_JUAL" class="TREATMENT_BILLTRANS1_POKOK_JUAL"><?= $Page->POKOK_JUAL->caption() ?></span></th>
<?php } ?>
<?php if ($Page->PPN->Visible) { // PPN ?>
        <th class="<?= $Page->PPN->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_PPN" class="TREATMENT_BILLTRANS1_PPN"><?= $Page->PPN->caption() ?></span></th>
<?php } ?>
<?php if ($Page->MARGIN->Visible) { // MARGIN ?>
        <th class="<?= $Page->MARGIN->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_MARGIN" class="TREATMENT_BILLTRANS1_MARGIN"><?= $Page->MARGIN->caption() ?></span></th>
<?php } ?>
<?php if ($Page->SUBSIDI->Visible) { // SUBSIDI ?>
        <th class="<?= $Page->SUBSIDI->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_SUBSIDI" class="TREATMENT_BILLTRANS1_SUBSIDI"><?= $Page->SUBSIDI->caption() ?></span></th>
<?php } ?>
<?php if ($Page->EMBALACE->Visible) { // EMBALACE ?>
        <th class="<?= $Page->EMBALACE->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_EMBALACE" class="TREATMENT_BILLTRANS1_EMBALACE"><?= $Page->EMBALACE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->PROFESI->Visible) { // PROFESI ?>
        <th class="<?= $Page->PROFESI->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_PROFESI" class="TREATMENT_BILLTRANS1_PROFESI"><?= $Page->PROFESI->caption() ?></span></th>
<?php } ?>
<?php if ($Page->DISCOUNT->Visible) { // DISCOUNT ?>
        <th class="<?= $Page->DISCOUNT->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_DISCOUNT" class="TREATMENT_BILLTRANS1_DISCOUNT"><?= $Page->DISCOUNT->caption() ?></span></th>
<?php } ?>
<?php if ($Page->PAY_METHOD_ID->Visible) { // PAY_METHOD_ID ?>
        <th class="<?= $Page->PAY_METHOD_ID->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_PAY_METHOD_ID" class="TREATMENT_BILLTRANS1_PAY_METHOD_ID"><?= $Page->PAY_METHOD_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->PAYMENT_DATE->Visible) { // PAYMENT_DATE ?>
        <th class="<?= $Page->PAYMENT_DATE->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_PAYMENT_DATE" class="TREATMENT_BILLTRANS1_PAYMENT_DATE"><?= $Page->PAYMENT_DATE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ISLUNAS->Visible) { // ISLUNAS ?>
        <th class="<?= $Page->ISLUNAS->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_ISLUNAS" class="TREATMENT_BILLTRANS1_ISLUNAS"><?= $Page->ISLUNAS->caption() ?></span></th>
<?php } ?>
<?php if ($Page->DUEDATE_ANGSURAN->Visible) { // DUEDATE_ANGSURAN ?>
        <th class="<?= $Page->DUEDATE_ANGSURAN->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_DUEDATE_ANGSURAN" class="TREATMENT_BILLTRANS1_DUEDATE_ANGSURAN"><?= $Page->DUEDATE_ANGSURAN->caption() ?></span></th>
<?php } ?>
<?php if ($Page->DESCRIPTION->Visible) { // DESCRIPTION ?>
        <th class="<?= $Page->DESCRIPTION->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_DESCRIPTION" class="TREATMENT_BILLTRANS1_DESCRIPTION"><?= $Page->DESCRIPTION->caption() ?></span></th>
<?php } ?>
<?php if ($Page->KUITANSI_ID->Visible) { // KUITANSI_ID ?>
        <th class="<?= $Page->KUITANSI_ID->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_KUITANSI_ID" class="TREATMENT_BILLTRANS1_KUITANSI_ID"><?= $Page->KUITANSI_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->NOTA_NO->Visible) { // NOTA_NO ?>
        <th class="<?= $Page->NOTA_NO->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_NOTA_NO" class="TREATMENT_BILLTRANS1_NOTA_NO"><?= $Page->NOTA_NO->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ISCETAK->Visible) { // ISCETAK ?>
        <th class="<?= $Page->ISCETAK->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_ISCETAK" class="TREATMENT_BILLTRANS1_ISCETAK"><?= $Page->ISCETAK->caption() ?></span></th>
<?php } ?>
<?php if ($Page->PRINT_DATE->Visible) { // PRINT_DATE ?>
        <th class="<?= $Page->PRINT_DATE->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_PRINT_DATE" class="TREATMENT_BILLTRANS1_PRINT_DATE"><?= $Page->PRINT_DATE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->RESEP_NO->Visible) { // RESEP_NO ?>
        <th class="<?= $Page->RESEP_NO->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_RESEP_NO" class="TREATMENT_BILLTRANS1_RESEP_NO"><?= $Page->RESEP_NO->caption() ?></span></th>
<?php } ?>
<?php if ($Page->RESEP_KE->Visible) { // RESEP_KE ?>
        <th class="<?= $Page->RESEP_KE->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_RESEP_KE" class="TREATMENT_BILLTRANS1_RESEP_KE"><?= $Page->RESEP_KE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->DOSE->Visible) { // DOSE ?>
        <th class="<?= $Page->DOSE->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_DOSE" class="TREATMENT_BILLTRANS1_DOSE"><?= $Page->DOSE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ORIG_DOSE->Visible) { // ORIG_DOSE ?>
        <th class="<?= $Page->ORIG_DOSE->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_ORIG_DOSE" class="TREATMENT_BILLTRANS1_ORIG_DOSE"><?= $Page->ORIG_DOSE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->DOSE_PRESC->Visible) { // DOSE_PRESC ?>
        <th class="<?= $Page->DOSE_PRESC->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_DOSE_PRESC" class="TREATMENT_BILLTRANS1_DOSE_PRESC"><?= $Page->DOSE_PRESC->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ITER->Visible) { // ITER ?>
        <th class="<?= $Page->ITER->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_ITER" class="TREATMENT_BILLTRANS1_ITER"><?= $Page->ITER->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ITER_KE->Visible) { // ITER_KE ?>
        <th class="<?= $Page->ITER_KE->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_ITER_KE" class="TREATMENT_BILLTRANS1_ITER_KE"><?= $Page->ITER_KE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->SOLD_STATUS->Visible) { // SOLD_STATUS ?>
        <th class="<?= $Page->SOLD_STATUS->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_SOLD_STATUS" class="TREATMENT_BILLTRANS1_SOLD_STATUS"><?= $Page->SOLD_STATUS->caption() ?></span></th>
<?php } ?>
<?php if ($Page->RACIKAN->Visible) { // RACIKAN ?>
        <th class="<?= $Page->RACIKAN->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_RACIKAN" class="TREATMENT_BILLTRANS1_RACIKAN"><?= $Page->RACIKAN->caption() ?></span></th>
<?php } ?>
<?php if ($Page->CLASS_ROOM_ID->Visible) { // CLASS_ROOM_ID ?>
        <th class="<?= $Page->CLASS_ROOM_ID->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_CLASS_ROOM_ID" class="TREATMENT_BILLTRANS1_CLASS_ROOM_ID"><?= $Page->CLASS_ROOM_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->KELUAR_ID->Visible) { // KELUAR_ID ?>
        <th class="<?= $Page->KELUAR_ID->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_KELUAR_ID" class="TREATMENT_BILLTRANS1_KELUAR_ID"><?= $Page->KELUAR_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->BED_ID->Visible) { // BED_ID ?>
        <th class="<?= $Page->BED_ID->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_BED_ID" class="TREATMENT_BILLTRANS1_BED_ID"><?= $Page->BED_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->PERDA_ID->Visible) { // PERDA_ID ?>
        <th class="<?= $Page->PERDA_ID->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_PERDA_ID" class="TREATMENT_BILLTRANS1_PERDA_ID"><?= $Page->PERDA_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->EMPLOYEE_ID->Visible) { // EMPLOYEE_ID ?>
        <th class="<?= $Page->EMPLOYEE_ID->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_EMPLOYEE_ID" class="TREATMENT_BILLTRANS1_EMPLOYEE_ID"><?= $Page->EMPLOYEE_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->DESCRIPTION2->Visible) { // DESCRIPTION2 ?>
        <th class="<?= $Page->DESCRIPTION2->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_DESCRIPTION2" class="TREATMENT_BILLTRANS1_DESCRIPTION2"><?= $Page->DESCRIPTION2->caption() ?></span></th>
<?php } ?>
<?php if ($Page->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
        <th class="<?= $Page->MODIFIED_BY->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_MODIFIED_BY" class="TREATMENT_BILLTRANS1_MODIFIED_BY"><?= $Page->MODIFIED_BY->caption() ?></span></th>
<?php } ?>
<?php if ($Page->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
        <th class="<?= $Page->MODIFIED_DATE->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_MODIFIED_DATE" class="TREATMENT_BILLTRANS1_MODIFIED_DATE"><?= $Page->MODIFIED_DATE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->MODIFIED_FROM->Visible) { // MODIFIED_FROM ?>
        <th class="<?= $Page->MODIFIED_FROM->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_MODIFIED_FROM" class="TREATMENT_BILLTRANS1_MODIFIED_FROM"><?= $Page->MODIFIED_FROM->caption() ?></span></th>
<?php } ?>
<?php if ($Page->BRAND_ID->Visible) { // BRAND_ID ?>
        <th class="<?= $Page->BRAND_ID->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_BRAND_ID" class="TREATMENT_BILLTRANS1_BRAND_ID"><?= $Page->BRAND_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->DOCTOR->Visible) { // DOCTOR ?>
        <th class="<?= $Page->DOCTOR->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_DOCTOR" class="TREATMENT_BILLTRANS1_DOCTOR"><?= $Page->DOCTOR->caption() ?></span></th>
<?php } ?>
<?php if ($Page->JML_BKS->Visible) { // JML_BKS ?>
        <th class="<?= $Page->JML_BKS->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_JML_BKS" class="TREATMENT_BILLTRANS1_JML_BKS"><?= $Page->JML_BKS->caption() ?></span></th>
<?php } ?>
<?php if ($Page->EXIT_DATE->Visible) { // EXIT_DATE ?>
        <th class="<?= $Page->EXIT_DATE->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_EXIT_DATE" class="TREATMENT_BILLTRANS1_EXIT_DATE"><?= $Page->EXIT_DATE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->FA_V->Visible) { // FA_V ?>
        <th class="<?= $Page->FA_V->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_FA_V" class="TREATMENT_BILLTRANS1_FA_V"><?= $Page->FA_V->caption() ?></span></th>
<?php } ?>
<?php if ($Page->TASK_ID->Visible) { // TASK_ID ?>
        <th class="<?= $Page->TASK_ID->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_TASK_ID" class="TREATMENT_BILLTRANS1_TASK_ID"><?= $Page->TASK_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->EMPLOYEE_ID_FROM->Visible) { // EMPLOYEE_ID_FROM ?>
        <th class="<?= $Page->EMPLOYEE_ID_FROM->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_EMPLOYEE_ID_FROM" class="TREATMENT_BILLTRANS1_EMPLOYEE_ID_FROM"><?= $Page->EMPLOYEE_ID_FROM->caption() ?></span></th>
<?php } ?>
<?php if ($Page->DOCTOR_FROM->Visible) { // DOCTOR_FROM ?>
        <th class="<?= $Page->DOCTOR_FROM->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_DOCTOR_FROM" class="TREATMENT_BILLTRANS1_DOCTOR_FROM"><?= $Page->DOCTOR_FROM->caption() ?></span></th>
<?php } ?>
<?php if ($Page->status_pasien_id->Visible) { // status_pasien_id ?>
        <th class="<?= $Page->status_pasien_id->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_status_pasien_id" class="TREATMENT_BILLTRANS1_status_pasien_id"><?= $Page->status_pasien_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->AMOUNT_PAID->Visible) { // AMOUNT_PAID ?>
        <th class="<?= $Page->AMOUNT_PAID->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_AMOUNT_PAID" class="TREATMENT_BILLTRANS1_AMOUNT_PAID"><?= $Page->AMOUNT_PAID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->THENAME->Visible) { // THENAME ?>
        <th class="<?= $Page->THENAME->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_THENAME" class="TREATMENT_BILLTRANS1_THENAME"><?= $Page->THENAME->caption() ?></span></th>
<?php } ?>
<?php if ($Page->THEADDRESS->Visible) { // THEADDRESS ?>
        <th class="<?= $Page->THEADDRESS->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_THEADDRESS" class="TREATMENT_BILLTRANS1_THEADDRESS"><?= $Page->THEADDRESS->caption() ?></span></th>
<?php } ?>
<?php if ($Page->THEID->Visible) { // THEID ?>
        <th class="<?= $Page->THEID->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_THEID" class="TREATMENT_BILLTRANS1_THEID"><?= $Page->THEID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->SERIAL_NB->Visible) { // SERIAL_NB ?>
        <th class="<?= $Page->SERIAL_NB->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_SERIAL_NB" class="TREATMENT_BILLTRANS1_SERIAL_NB"><?= $Page->SERIAL_NB->caption() ?></span></th>
<?php } ?>
<?php if ($Page->TREATMENT_PLAFOND->Visible) { // TREATMENT_PLAFOND ?>
        <th class="<?= $Page->TREATMENT_PLAFOND->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_TREATMENT_PLAFOND" class="TREATMENT_BILLTRANS1_TREATMENT_PLAFOND"><?= $Page->TREATMENT_PLAFOND->caption() ?></span></th>
<?php } ?>
<?php if ($Page->AMOUNT_PLAFOND->Visible) { // AMOUNT_PLAFOND ?>
        <th class="<?= $Page->AMOUNT_PLAFOND->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_AMOUNT_PLAFOND" class="TREATMENT_BILLTRANS1_AMOUNT_PLAFOND"><?= $Page->AMOUNT_PLAFOND->caption() ?></span></th>
<?php } ?>
<?php if ($Page->AMOUNT_PAID_PLAFOND->Visible) { // AMOUNT_PAID_PLAFOND ?>
        <th class="<?= $Page->AMOUNT_PAID_PLAFOND->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_AMOUNT_PAID_PLAFOND" class="TREATMENT_BILLTRANS1_AMOUNT_PAID_PLAFOND"><?= $Page->AMOUNT_PAID_PLAFOND->caption() ?></span></th>
<?php } ?>
<?php if ($Page->CLASS_ID_PLAFOND->Visible) { // CLASS_ID_PLAFOND ?>
        <th class="<?= $Page->CLASS_ID_PLAFOND->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_CLASS_ID_PLAFOND" class="TREATMENT_BILLTRANS1_CLASS_ID_PLAFOND"><?= $Page->CLASS_ID_PLAFOND->caption() ?></span></th>
<?php } ?>
<?php if ($Page->PAYOR_ID->Visible) { // PAYOR_ID ?>
        <th class="<?= $Page->PAYOR_ID->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_PAYOR_ID" class="TREATMENT_BILLTRANS1_PAYOR_ID"><?= $Page->PAYOR_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->PEMBULATAN->Visible) { // PEMBULATAN ?>
        <th class="<?= $Page->PEMBULATAN->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_PEMBULATAN" class="TREATMENT_BILLTRANS1_PEMBULATAN"><?= $Page->PEMBULATAN->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ISRJ->Visible) { // ISRJ ?>
        <th class="<?= $Page->ISRJ->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_ISRJ" class="TREATMENT_BILLTRANS1_ISRJ"><?= $Page->ISRJ->caption() ?></span></th>
<?php } ?>
<?php if ($Page->AGEYEAR->Visible) { // AGEYEAR ?>
        <th class="<?= $Page->AGEYEAR->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_AGEYEAR" class="TREATMENT_BILLTRANS1_AGEYEAR"><?= $Page->AGEYEAR->caption() ?></span></th>
<?php } ?>
<?php if ($Page->AGEMONTH->Visible) { // AGEMONTH ?>
        <th class="<?= $Page->AGEMONTH->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_AGEMONTH" class="TREATMENT_BILLTRANS1_AGEMONTH"><?= $Page->AGEMONTH->caption() ?></span></th>
<?php } ?>
<?php if ($Page->AGEDAY->Visible) { // AGEDAY ?>
        <th class="<?= $Page->AGEDAY->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_AGEDAY" class="TREATMENT_BILLTRANS1_AGEDAY"><?= $Page->AGEDAY->caption() ?></span></th>
<?php } ?>
<?php if ($Page->GENDER->Visible) { // GENDER ?>
        <th class="<?= $Page->GENDER->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_GENDER" class="TREATMENT_BILLTRANS1_GENDER"><?= $Page->GENDER->caption() ?></span></th>
<?php } ?>
<?php if ($Page->KAL_ID->Visible) { // KAL_ID ?>
        <th class="<?= $Page->KAL_ID->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_KAL_ID" class="TREATMENT_BILLTRANS1_KAL_ID"><?= $Page->KAL_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->CORRECTION_ID->Visible) { // CORRECTION_ID ?>
        <th class="<?= $Page->CORRECTION_ID->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_CORRECTION_ID" class="TREATMENT_BILLTRANS1_CORRECTION_ID"><?= $Page->CORRECTION_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->CORRECTION_BY->Visible) { // CORRECTION_BY ?>
        <th class="<?= $Page->CORRECTION_BY->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_CORRECTION_BY" class="TREATMENT_BILLTRANS1_CORRECTION_BY"><?= $Page->CORRECTION_BY->caption() ?></span></th>
<?php } ?>
<?php if ($Page->KARYAWAN->Visible) { // KARYAWAN ?>
        <th class="<?= $Page->KARYAWAN->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_KARYAWAN" class="TREATMENT_BILLTRANS1_KARYAWAN"><?= $Page->KARYAWAN->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ACCOUNT_ID->Visible) { // ACCOUNT_ID ?>
        <th class="<?= $Page->ACCOUNT_ID->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_ACCOUNT_ID" class="TREATMENT_BILLTRANS1_ACCOUNT_ID"><?= $Page->ACCOUNT_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->sell_price->Visible) { // sell_price ?>
        <th class="<?= $Page->sell_price->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_sell_price" class="TREATMENT_BILLTRANS1_sell_price"><?= $Page->sell_price->caption() ?></span></th>
<?php } ?>
<?php if ($Page->diskon->Visible) { // diskon ?>
        <th class="<?= $Page->diskon->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_diskon" class="TREATMENT_BILLTRANS1_diskon"><?= $Page->diskon->caption() ?></span></th>
<?php } ?>
<?php if ($Page->INVOICE_ID->Visible) { // INVOICE_ID ?>
        <th class="<?= $Page->INVOICE_ID->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_INVOICE_ID" class="TREATMENT_BILLTRANS1_INVOICE_ID"><?= $Page->INVOICE_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->NUMER->Visible) { // NUMER ?>
        <th class="<?= $Page->NUMER->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_NUMER" class="TREATMENT_BILLTRANS1_NUMER"><?= $Page->NUMER->caption() ?></span></th>
<?php } ?>
<?php if ($Page->MEASURE_ID2->Visible) { // MEASURE_ID2 ?>
        <th class="<?= $Page->MEASURE_ID2->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_MEASURE_ID2" class="TREATMENT_BILLTRANS1_MEASURE_ID2"><?= $Page->MEASURE_ID2->caption() ?></span></th>
<?php } ?>
<?php if ($Page->POTONGAN->Visible) { // POTONGAN ?>
        <th class="<?= $Page->POTONGAN->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_POTONGAN" class="TREATMENT_BILLTRANS1_POTONGAN"><?= $Page->POTONGAN->caption() ?></span></th>
<?php } ?>
<?php if ($Page->BAYAR->Visible) { // BAYAR ?>
        <th class="<?= $Page->BAYAR->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_BAYAR" class="TREATMENT_BILLTRANS1_BAYAR"><?= $Page->BAYAR->caption() ?></span></th>
<?php } ?>
<?php if ($Page->RETUR->Visible) { // RETUR ?>
        <th class="<?= $Page->RETUR->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_RETUR" class="TREATMENT_BILLTRANS1_RETUR"><?= $Page->RETUR->caption() ?></span></th>
<?php } ?>
<?php if ($Page->TARIF_TYPE->Visible) { // TARIF_TYPE ?>
        <th class="<?= $Page->TARIF_TYPE->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_TARIF_TYPE" class="TREATMENT_BILLTRANS1_TARIF_TYPE"><?= $Page->TARIF_TYPE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->PPNVALUE->Visible) { // PPNVALUE ?>
        <th class="<?= $Page->PPNVALUE->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_PPNVALUE" class="TREATMENT_BILLTRANS1_PPNVALUE"><?= $Page->PPNVALUE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->TAGIHAN->Visible) { // TAGIHAN ?>
        <th class="<?= $Page->TAGIHAN->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_TAGIHAN" class="TREATMENT_BILLTRANS1_TAGIHAN"><?= $Page->TAGIHAN->caption() ?></span></th>
<?php } ?>
<?php if ($Page->KOREKSI->Visible) { // KOREKSI ?>
        <th class="<?= $Page->KOREKSI->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_KOREKSI" class="TREATMENT_BILLTRANS1_KOREKSI"><?= $Page->KOREKSI->caption() ?></span></th>
<?php } ?>
<?php if ($Page->STATUS_OBAT->Visible) { // STATUS_OBAT ?>
        <th class="<?= $Page->STATUS_OBAT->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_STATUS_OBAT" class="TREATMENT_BILLTRANS1_STATUS_OBAT"><?= $Page->STATUS_OBAT->caption() ?></span></th>
<?php } ?>
<?php if ($Page->SUBSIDISAT->Visible) { // SUBSIDISAT ?>
        <th class="<?= $Page->SUBSIDISAT->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_SUBSIDISAT" class="TREATMENT_BILLTRANS1_SUBSIDISAT"><?= $Page->SUBSIDISAT->caption() ?></span></th>
<?php } ?>
<?php if ($Page->PRINTQ->Visible) { // PRINTQ ?>
        <th class="<?= $Page->PRINTQ->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_PRINTQ" class="TREATMENT_BILLTRANS1_PRINTQ"><?= $Page->PRINTQ->caption() ?></span></th>
<?php } ?>
<?php if ($Page->PRINTED_BY->Visible) { // PRINTED_BY ?>
        <th class="<?= $Page->PRINTED_BY->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_PRINTED_BY" class="TREATMENT_BILLTRANS1_PRINTED_BY"><?= $Page->PRINTED_BY->caption() ?></span></th>
<?php } ?>
<?php if ($Page->STOCK_AVAILABLE->Visible) { // STOCK_AVAILABLE ?>
        <th class="<?= $Page->STOCK_AVAILABLE->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_STOCK_AVAILABLE" class="TREATMENT_BILLTRANS1_STOCK_AVAILABLE"><?= $Page->STOCK_AVAILABLE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->STATUS_TARIF->Visible) { // STATUS_TARIF ?>
        <th class="<?= $Page->STATUS_TARIF->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_STATUS_TARIF" class="TREATMENT_BILLTRANS1_STATUS_TARIF"><?= $Page->STATUS_TARIF->caption() ?></span></th>
<?php } ?>
<?php if ($Page->CLINIC_TYPE->Visible) { // CLINIC_TYPE ?>
        <th class="<?= $Page->CLINIC_TYPE->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_CLINIC_TYPE" class="TREATMENT_BILLTRANS1_CLINIC_TYPE"><?= $Page->CLINIC_TYPE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->PACKAGE_ID->Visible) { // PACKAGE_ID ?>
        <th class="<?= $Page->PACKAGE_ID->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_PACKAGE_ID" class="TREATMENT_BILLTRANS1_PACKAGE_ID"><?= $Page->PACKAGE_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->MODULE_ID->Visible) { // MODULE_ID ?>
        <th class="<?= $Page->MODULE_ID->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_MODULE_ID" class="TREATMENT_BILLTRANS1_MODULE_ID"><?= $Page->MODULE_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->profession->Visible) { // profession ?>
        <th class="<?= $Page->profession->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_profession" class="TREATMENT_BILLTRANS1_profession"><?= $Page->profession->caption() ?></span></th>
<?php } ?>
<?php if ($Page->THEORDER->Visible) { // THEORDER ?>
        <th class="<?= $Page->THEORDER->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_THEORDER" class="TREATMENT_BILLTRANS1_THEORDER"><?= $Page->THEORDER->caption() ?></span></th>
<?php } ?>
<?php if ($Page->CASHIER->Visible) { // CASHIER ?>
        <th class="<?= $Page->CASHIER->headerCellClass() ?>"><span id="elh_TREATMENT_BILLTRANS1_CASHIER" class="TREATMENT_BILLTRANS1_CASHIER"><?= $Page->CASHIER->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_ORG_UNIT_CODE" class="TREATMENT_BILLTRANS1_ORG_UNIT_CODE">
<span<?= $Page->ORG_UNIT_CODE->viewAttributes() ?>>
<?= $Page->ORG_UNIT_CODE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->BILL_ID->Visible) { // BILL_ID ?>
        <td <?= $Page->BILL_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_BILL_ID" class="TREATMENT_BILLTRANS1_BILL_ID">
<span<?= $Page->BILL_ID->viewAttributes() ?>>
<?= $Page->BILL_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->NO_REGISTRATION->Visible) { // NO_REGISTRATION ?>
        <td <?= $Page->NO_REGISTRATION->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_NO_REGISTRATION" class="TREATMENT_BILLTRANS1_NO_REGISTRATION">
<span<?= $Page->NO_REGISTRATION->viewAttributes() ?>>
<?= $Page->NO_REGISTRATION->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->VISIT_ID->Visible) { // VISIT_ID ?>
        <td <?= $Page->VISIT_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_VISIT_ID" class="TREATMENT_BILLTRANS1_VISIT_ID">
<span<?= $Page->VISIT_ID->viewAttributes() ?>>
<?= $Page->VISIT_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->TARIF_ID->Visible) { // TARIF_ID ?>
        <td <?= $Page->TARIF_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_TARIF_ID" class="TREATMENT_BILLTRANS1_TARIF_ID">
<span<?= $Page->TARIF_ID->viewAttributes() ?>>
<?= $Page->TARIF_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->CLASS_ID->Visible) { // CLASS_ID ?>
        <td <?= $Page->CLASS_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_CLASS_ID" class="TREATMENT_BILLTRANS1_CLASS_ID">
<span<?= $Page->CLASS_ID->viewAttributes() ?>>
<?= $Page->CLASS_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->CLINIC_ID->Visible) { // CLINIC_ID ?>
        <td <?= $Page->CLINIC_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_CLINIC_ID" class="TREATMENT_BILLTRANS1_CLINIC_ID">
<span<?= $Page->CLINIC_ID->viewAttributes() ?>>
<?= $Page->CLINIC_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->CLINIC_ID_FROM->Visible) { // CLINIC_ID_FROM ?>
        <td <?= $Page->CLINIC_ID_FROM->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_CLINIC_ID_FROM" class="TREATMENT_BILLTRANS1_CLINIC_ID_FROM">
<span<?= $Page->CLINIC_ID_FROM->viewAttributes() ?>>
<?= $Page->CLINIC_ID_FROM->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->TREATMENT->Visible) { // TREATMENT ?>
        <td <?= $Page->TREATMENT->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_TREATMENT" class="TREATMENT_BILLTRANS1_TREATMENT">
<span<?= $Page->TREATMENT->viewAttributes() ?>>
<?= $Page->TREATMENT->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->TREAT_DATE->Visible) { // TREAT_DATE ?>
        <td <?= $Page->TREAT_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_TREAT_DATE" class="TREATMENT_BILLTRANS1_TREAT_DATE">
<span<?= $Page->TREAT_DATE->viewAttributes() ?>>
<?= $Page->TREAT_DATE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->AMOUNT->Visible) { // AMOUNT ?>
        <td <?= $Page->AMOUNT->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_AMOUNT" class="TREATMENT_BILLTRANS1_AMOUNT">
<span<?= $Page->AMOUNT->viewAttributes() ?>>
<?= $Page->AMOUNT->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->QUANTITY->Visible) { // QUANTITY ?>
        <td <?= $Page->QUANTITY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_QUANTITY" class="TREATMENT_BILLTRANS1_QUANTITY">
<span<?= $Page->QUANTITY->viewAttributes() ?>>
<?= $Page->QUANTITY->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->MEASURE_ID->Visible) { // MEASURE_ID ?>
        <td <?= $Page->MEASURE_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_MEASURE_ID" class="TREATMENT_BILLTRANS1_MEASURE_ID">
<span<?= $Page->MEASURE_ID->viewAttributes() ?>>
<?= $Page->MEASURE_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->POKOK_JUAL->Visible) { // POKOK_JUAL ?>
        <td <?= $Page->POKOK_JUAL->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_POKOK_JUAL" class="TREATMENT_BILLTRANS1_POKOK_JUAL">
<span<?= $Page->POKOK_JUAL->viewAttributes() ?>>
<?= $Page->POKOK_JUAL->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->PPN->Visible) { // PPN ?>
        <td <?= $Page->PPN->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_PPN" class="TREATMENT_BILLTRANS1_PPN">
<span<?= $Page->PPN->viewAttributes() ?>>
<?= $Page->PPN->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->MARGIN->Visible) { // MARGIN ?>
        <td <?= $Page->MARGIN->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_MARGIN" class="TREATMENT_BILLTRANS1_MARGIN">
<span<?= $Page->MARGIN->viewAttributes() ?>>
<?= $Page->MARGIN->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->SUBSIDI->Visible) { // SUBSIDI ?>
        <td <?= $Page->SUBSIDI->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_SUBSIDI" class="TREATMENT_BILLTRANS1_SUBSIDI">
<span<?= $Page->SUBSIDI->viewAttributes() ?>>
<?= $Page->SUBSIDI->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->EMBALACE->Visible) { // EMBALACE ?>
        <td <?= $Page->EMBALACE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_EMBALACE" class="TREATMENT_BILLTRANS1_EMBALACE">
<span<?= $Page->EMBALACE->viewAttributes() ?>>
<?= $Page->EMBALACE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->PROFESI->Visible) { // PROFESI ?>
        <td <?= $Page->PROFESI->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_PROFESI" class="TREATMENT_BILLTRANS1_PROFESI">
<span<?= $Page->PROFESI->viewAttributes() ?>>
<?= $Page->PROFESI->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->DISCOUNT->Visible) { // DISCOUNT ?>
        <td <?= $Page->DISCOUNT->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_DISCOUNT" class="TREATMENT_BILLTRANS1_DISCOUNT">
<span<?= $Page->DISCOUNT->viewAttributes() ?>>
<?= $Page->DISCOUNT->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->PAY_METHOD_ID->Visible) { // PAY_METHOD_ID ?>
        <td <?= $Page->PAY_METHOD_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_PAY_METHOD_ID" class="TREATMENT_BILLTRANS1_PAY_METHOD_ID">
<span<?= $Page->PAY_METHOD_ID->viewAttributes() ?>>
<?= $Page->PAY_METHOD_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->PAYMENT_DATE->Visible) { // PAYMENT_DATE ?>
        <td <?= $Page->PAYMENT_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_PAYMENT_DATE" class="TREATMENT_BILLTRANS1_PAYMENT_DATE">
<span<?= $Page->PAYMENT_DATE->viewAttributes() ?>>
<?= $Page->PAYMENT_DATE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ISLUNAS->Visible) { // ISLUNAS ?>
        <td <?= $Page->ISLUNAS->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_ISLUNAS" class="TREATMENT_BILLTRANS1_ISLUNAS">
<span<?= $Page->ISLUNAS->viewAttributes() ?>>
<?= $Page->ISLUNAS->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->DUEDATE_ANGSURAN->Visible) { // DUEDATE_ANGSURAN ?>
        <td <?= $Page->DUEDATE_ANGSURAN->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_DUEDATE_ANGSURAN" class="TREATMENT_BILLTRANS1_DUEDATE_ANGSURAN">
<span<?= $Page->DUEDATE_ANGSURAN->viewAttributes() ?>>
<?= $Page->DUEDATE_ANGSURAN->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->DESCRIPTION->Visible) { // DESCRIPTION ?>
        <td <?= $Page->DESCRIPTION->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_DESCRIPTION" class="TREATMENT_BILLTRANS1_DESCRIPTION">
<span<?= $Page->DESCRIPTION->viewAttributes() ?>>
<?= $Page->DESCRIPTION->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->KUITANSI_ID->Visible) { // KUITANSI_ID ?>
        <td <?= $Page->KUITANSI_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_KUITANSI_ID" class="TREATMENT_BILLTRANS1_KUITANSI_ID">
<span<?= $Page->KUITANSI_ID->viewAttributes() ?>>
<?= $Page->KUITANSI_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->NOTA_NO->Visible) { // NOTA_NO ?>
        <td <?= $Page->NOTA_NO->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_NOTA_NO" class="TREATMENT_BILLTRANS1_NOTA_NO">
<span<?= $Page->NOTA_NO->viewAttributes() ?>>
<?= $Page->NOTA_NO->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ISCETAK->Visible) { // ISCETAK ?>
        <td <?= $Page->ISCETAK->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_ISCETAK" class="TREATMENT_BILLTRANS1_ISCETAK">
<span<?= $Page->ISCETAK->viewAttributes() ?>>
<?= $Page->ISCETAK->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->PRINT_DATE->Visible) { // PRINT_DATE ?>
        <td <?= $Page->PRINT_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_PRINT_DATE" class="TREATMENT_BILLTRANS1_PRINT_DATE">
<span<?= $Page->PRINT_DATE->viewAttributes() ?>>
<?= $Page->PRINT_DATE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->RESEP_NO->Visible) { // RESEP_NO ?>
        <td <?= $Page->RESEP_NO->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_RESEP_NO" class="TREATMENT_BILLTRANS1_RESEP_NO">
<span<?= $Page->RESEP_NO->viewAttributes() ?>>
<?= $Page->RESEP_NO->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->RESEP_KE->Visible) { // RESEP_KE ?>
        <td <?= $Page->RESEP_KE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_RESEP_KE" class="TREATMENT_BILLTRANS1_RESEP_KE">
<span<?= $Page->RESEP_KE->viewAttributes() ?>>
<?= $Page->RESEP_KE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->DOSE->Visible) { // DOSE ?>
        <td <?= $Page->DOSE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_DOSE" class="TREATMENT_BILLTRANS1_DOSE">
<span<?= $Page->DOSE->viewAttributes() ?>>
<?= $Page->DOSE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ORIG_DOSE->Visible) { // ORIG_DOSE ?>
        <td <?= $Page->ORIG_DOSE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_ORIG_DOSE" class="TREATMENT_BILLTRANS1_ORIG_DOSE">
<span<?= $Page->ORIG_DOSE->viewAttributes() ?>>
<?= $Page->ORIG_DOSE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->DOSE_PRESC->Visible) { // DOSE_PRESC ?>
        <td <?= $Page->DOSE_PRESC->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_DOSE_PRESC" class="TREATMENT_BILLTRANS1_DOSE_PRESC">
<span<?= $Page->DOSE_PRESC->viewAttributes() ?>>
<?= $Page->DOSE_PRESC->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ITER->Visible) { // ITER ?>
        <td <?= $Page->ITER->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_ITER" class="TREATMENT_BILLTRANS1_ITER">
<span<?= $Page->ITER->viewAttributes() ?>>
<?= $Page->ITER->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ITER_KE->Visible) { // ITER_KE ?>
        <td <?= $Page->ITER_KE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_ITER_KE" class="TREATMENT_BILLTRANS1_ITER_KE">
<span<?= $Page->ITER_KE->viewAttributes() ?>>
<?= $Page->ITER_KE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->SOLD_STATUS->Visible) { // SOLD_STATUS ?>
        <td <?= $Page->SOLD_STATUS->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_SOLD_STATUS" class="TREATMENT_BILLTRANS1_SOLD_STATUS">
<span<?= $Page->SOLD_STATUS->viewAttributes() ?>>
<?= $Page->SOLD_STATUS->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->RACIKAN->Visible) { // RACIKAN ?>
        <td <?= $Page->RACIKAN->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_RACIKAN" class="TREATMENT_BILLTRANS1_RACIKAN">
<span<?= $Page->RACIKAN->viewAttributes() ?>>
<?= $Page->RACIKAN->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->CLASS_ROOM_ID->Visible) { // CLASS_ROOM_ID ?>
        <td <?= $Page->CLASS_ROOM_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_CLASS_ROOM_ID" class="TREATMENT_BILLTRANS1_CLASS_ROOM_ID">
<span<?= $Page->CLASS_ROOM_ID->viewAttributes() ?>>
<?= $Page->CLASS_ROOM_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->KELUAR_ID->Visible) { // KELUAR_ID ?>
        <td <?= $Page->KELUAR_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_KELUAR_ID" class="TREATMENT_BILLTRANS1_KELUAR_ID">
<span<?= $Page->KELUAR_ID->viewAttributes() ?>>
<?= $Page->KELUAR_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->BED_ID->Visible) { // BED_ID ?>
        <td <?= $Page->BED_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_BED_ID" class="TREATMENT_BILLTRANS1_BED_ID">
<span<?= $Page->BED_ID->viewAttributes() ?>>
<?= $Page->BED_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->PERDA_ID->Visible) { // PERDA_ID ?>
        <td <?= $Page->PERDA_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_PERDA_ID" class="TREATMENT_BILLTRANS1_PERDA_ID">
<span<?= $Page->PERDA_ID->viewAttributes() ?>>
<?= $Page->PERDA_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->EMPLOYEE_ID->Visible) { // EMPLOYEE_ID ?>
        <td <?= $Page->EMPLOYEE_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_EMPLOYEE_ID" class="TREATMENT_BILLTRANS1_EMPLOYEE_ID">
<span<?= $Page->EMPLOYEE_ID->viewAttributes() ?>>
<?= $Page->EMPLOYEE_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->DESCRIPTION2->Visible) { // DESCRIPTION2 ?>
        <td <?= $Page->DESCRIPTION2->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_DESCRIPTION2" class="TREATMENT_BILLTRANS1_DESCRIPTION2">
<span<?= $Page->DESCRIPTION2->viewAttributes() ?>>
<?= $Page->DESCRIPTION2->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
        <td <?= $Page->MODIFIED_BY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_MODIFIED_BY" class="TREATMENT_BILLTRANS1_MODIFIED_BY">
<span<?= $Page->MODIFIED_BY->viewAttributes() ?>>
<?= $Page->MODIFIED_BY->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
        <td <?= $Page->MODIFIED_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_MODIFIED_DATE" class="TREATMENT_BILLTRANS1_MODIFIED_DATE">
<span<?= $Page->MODIFIED_DATE->viewAttributes() ?>>
<?= $Page->MODIFIED_DATE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->MODIFIED_FROM->Visible) { // MODIFIED_FROM ?>
        <td <?= $Page->MODIFIED_FROM->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_MODIFIED_FROM" class="TREATMENT_BILLTRANS1_MODIFIED_FROM">
<span<?= $Page->MODIFIED_FROM->viewAttributes() ?>>
<?= $Page->MODIFIED_FROM->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->BRAND_ID->Visible) { // BRAND_ID ?>
        <td <?= $Page->BRAND_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_BRAND_ID" class="TREATMENT_BILLTRANS1_BRAND_ID">
<span<?= $Page->BRAND_ID->viewAttributes() ?>>
<?= $Page->BRAND_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->DOCTOR->Visible) { // DOCTOR ?>
        <td <?= $Page->DOCTOR->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_DOCTOR" class="TREATMENT_BILLTRANS1_DOCTOR">
<span<?= $Page->DOCTOR->viewAttributes() ?>>
<?= $Page->DOCTOR->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->JML_BKS->Visible) { // JML_BKS ?>
        <td <?= $Page->JML_BKS->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_JML_BKS" class="TREATMENT_BILLTRANS1_JML_BKS">
<span<?= $Page->JML_BKS->viewAttributes() ?>>
<?= $Page->JML_BKS->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->EXIT_DATE->Visible) { // EXIT_DATE ?>
        <td <?= $Page->EXIT_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_EXIT_DATE" class="TREATMENT_BILLTRANS1_EXIT_DATE">
<span<?= $Page->EXIT_DATE->viewAttributes() ?>>
<?= $Page->EXIT_DATE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->FA_V->Visible) { // FA_V ?>
        <td <?= $Page->FA_V->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_FA_V" class="TREATMENT_BILLTRANS1_FA_V">
<span<?= $Page->FA_V->viewAttributes() ?>>
<?= $Page->FA_V->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->TASK_ID->Visible) { // TASK_ID ?>
        <td <?= $Page->TASK_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_TASK_ID" class="TREATMENT_BILLTRANS1_TASK_ID">
<span<?= $Page->TASK_ID->viewAttributes() ?>>
<?= $Page->TASK_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->EMPLOYEE_ID_FROM->Visible) { // EMPLOYEE_ID_FROM ?>
        <td <?= $Page->EMPLOYEE_ID_FROM->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_EMPLOYEE_ID_FROM" class="TREATMENT_BILLTRANS1_EMPLOYEE_ID_FROM">
<span<?= $Page->EMPLOYEE_ID_FROM->viewAttributes() ?>>
<?= $Page->EMPLOYEE_ID_FROM->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->DOCTOR_FROM->Visible) { // DOCTOR_FROM ?>
        <td <?= $Page->DOCTOR_FROM->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_DOCTOR_FROM" class="TREATMENT_BILLTRANS1_DOCTOR_FROM">
<span<?= $Page->DOCTOR_FROM->viewAttributes() ?>>
<?= $Page->DOCTOR_FROM->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->status_pasien_id->Visible) { // status_pasien_id ?>
        <td <?= $Page->status_pasien_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_status_pasien_id" class="TREATMENT_BILLTRANS1_status_pasien_id">
<span<?= $Page->status_pasien_id->viewAttributes() ?>>
<?= $Page->status_pasien_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->AMOUNT_PAID->Visible) { // AMOUNT_PAID ?>
        <td <?= $Page->AMOUNT_PAID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_AMOUNT_PAID" class="TREATMENT_BILLTRANS1_AMOUNT_PAID">
<span<?= $Page->AMOUNT_PAID->viewAttributes() ?>>
<?= $Page->AMOUNT_PAID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->THENAME->Visible) { // THENAME ?>
        <td <?= $Page->THENAME->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_THENAME" class="TREATMENT_BILLTRANS1_THENAME">
<span<?= $Page->THENAME->viewAttributes() ?>>
<?= $Page->THENAME->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->THEADDRESS->Visible) { // THEADDRESS ?>
        <td <?= $Page->THEADDRESS->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_THEADDRESS" class="TREATMENT_BILLTRANS1_THEADDRESS">
<span<?= $Page->THEADDRESS->viewAttributes() ?>>
<?= $Page->THEADDRESS->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->THEID->Visible) { // THEID ?>
        <td <?= $Page->THEID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_THEID" class="TREATMENT_BILLTRANS1_THEID">
<span<?= $Page->THEID->viewAttributes() ?>>
<?= $Page->THEID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->SERIAL_NB->Visible) { // SERIAL_NB ?>
        <td <?= $Page->SERIAL_NB->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_SERIAL_NB" class="TREATMENT_BILLTRANS1_SERIAL_NB">
<span<?= $Page->SERIAL_NB->viewAttributes() ?>>
<?= $Page->SERIAL_NB->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->TREATMENT_PLAFOND->Visible) { // TREATMENT_PLAFOND ?>
        <td <?= $Page->TREATMENT_PLAFOND->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_TREATMENT_PLAFOND" class="TREATMENT_BILLTRANS1_TREATMENT_PLAFOND">
<span<?= $Page->TREATMENT_PLAFOND->viewAttributes() ?>>
<?= $Page->TREATMENT_PLAFOND->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->AMOUNT_PLAFOND->Visible) { // AMOUNT_PLAFOND ?>
        <td <?= $Page->AMOUNT_PLAFOND->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_AMOUNT_PLAFOND" class="TREATMENT_BILLTRANS1_AMOUNT_PLAFOND">
<span<?= $Page->AMOUNT_PLAFOND->viewAttributes() ?>>
<?= $Page->AMOUNT_PLAFOND->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->AMOUNT_PAID_PLAFOND->Visible) { // AMOUNT_PAID_PLAFOND ?>
        <td <?= $Page->AMOUNT_PAID_PLAFOND->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_AMOUNT_PAID_PLAFOND" class="TREATMENT_BILLTRANS1_AMOUNT_PAID_PLAFOND">
<span<?= $Page->AMOUNT_PAID_PLAFOND->viewAttributes() ?>>
<?= $Page->AMOUNT_PAID_PLAFOND->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->CLASS_ID_PLAFOND->Visible) { // CLASS_ID_PLAFOND ?>
        <td <?= $Page->CLASS_ID_PLAFOND->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_CLASS_ID_PLAFOND" class="TREATMENT_BILLTRANS1_CLASS_ID_PLAFOND">
<span<?= $Page->CLASS_ID_PLAFOND->viewAttributes() ?>>
<?= $Page->CLASS_ID_PLAFOND->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->PAYOR_ID->Visible) { // PAYOR_ID ?>
        <td <?= $Page->PAYOR_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_PAYOR_ID" class="TREATMENT_BILLTRANS1_PAYOR_ID">
<span<?= $Page->PAYOR_ID->viewAttributes() ?>>
<?= $Page->PAYOR_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->PEMBULATAN->Visible) { // PEMBULATAN ?>
        <td <?= $Page->PEMBULATAN->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_PEMBULATAN" class="TREATMENT_BILLTRANS1_PEMBULATAN">
<span<?= $Page->PEMBULATAN->viewAttributes() ?>>
<?= $Page->PEMBULATAN->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ISRJ->Visible) { // ISRJ ?>
        <td <?= $Page->ISRJ->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_ISRJ" class="TREATMENT_BILLTRANS1_ISRJ">
<span<?= $Page->ISRJ->viewAttributes() ?>>
<?= $Page->ISRJ->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->AGEYEAR->Visible) { // AGEYEAR ?>
        <td <?= $Page->AGEYEAR->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_AGEYEAR" class="TREATMENT_BILLTRANS1_AGEYEAR">
<span<?= $Page->AGEYEAR->viewAttributes() ?>>
<?= $Page->AGEYEAR->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->AGEMONTH->Visible) { // AGEMONTH ?>
        <td <?= $Page->AGEMONTH->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_AGEMONTH" class="TREATMENT_BILLTRANS1_AGEMONTH">
<span<?= $Page->AGEMONTH->viewAttributes() ?>>
<?= $Page->AGEMONTH->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->AGEDAY->Visible) { // AGEDAY ?>
        <td <?= $Page->AGEDAY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_AGEDAY" class="TREATMENT_BILLTRANS1_AGEDAY">
<span<?= $Page->AGEDAY->viewAttributes() ?>>
<?= $Page->AGEDAY->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->GENDER->Visible) { // GENDER ?>
        <td <?= $Page->GENDER->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_GENDER" class="TREATMENT_BILLTRANS1_GENDER">
<span<?= $Page->GENDER->viewAttributes() ?>>
<?= $Page->GENDER->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->KAL_ID->Visible) { // KAL_ID ?>
        <td <?= $Page->KAL_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_KAL_ID" class="TREATMENT_BILLTRANS1_KAL_ID">
<span<?= $Page->KAL_ID->viewAttributes() ?>>
<?= $Page->KAL_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->CORRECTION_ID->Visible) { // CORRECTION_ID ?>
        <td <?= $Page->CORRECTION_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_CORRECTION_ID" class="TREATMENT_BILLTRANS1_CORRECTION_ID">
<span<?= $Page->CORRECTION_ID->viewAttributes() ?>>
<?= $Page->CORRECTION_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->CORRECTION_BY->Visible) { // CORRECTION_BY ?>
        <td <?= $Page->CORRECTION_BY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_CORRECTION_BY" class="TREATMENT_BILLTRANS1_CORRECTION_BY">
<span<?= $Page->CORRECTION_BY->viewAttributes() ?>>
<?= $Page->CORRECTION_BY->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->KARYAWAN->Visible) { // KARYAWAN ?>
        <td <?= $Page->KARYAWAN->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_KARYAWAN" class="TREATMENT_BILLTRANS1_KARYAWAN">
<span<?= $Page->KARYAWAN->viewAttributes() ?>>
<?= $Page->KARYAWAN->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ACCOUNT_ID->Visible) { // ACCOUNT_ID ?>
        <td <?= $Page->ACCOUNT_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_ACCOUNT_ID" class="TREATMENT_BILLTRANS1_ACCOUNT_ID">
<span<?= $Page->ACCOUNT_ID->viewAttributes() ?>>
<?= $Page->ACCOUNT_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->sell_price->Visible) { // sell_price ?>
        <td <?= $Page->sell_price->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_sell_price" class="TREATMENT_BILLTRANS1_sell_price">
<span<?= $Page->sell_price->viewAttributes() ?>>
<?= $Page->sell_price->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->diskon->Visible) { // diskon ?>
        <td <?= $Page->diskon->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_diskon" class="TREATMENT_BILLTRANS1_diskon">
<span<?= $Page->diskon->viewAttributes() ?>>
<?= $Page->diskon->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->INVOICE_ID->Visible) { // INVOICE_ID ?>
        <td <?= $Page->INVOICE_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_INVOICE_ID" class="TREATMENT_BILLTRANS1_INVOICE_ID">
<span<?= $Page->INVOICE_ID->viewAttributes() ?>>
<?= $Page->INVOICE_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->NUMER->Visible) { // NUMER ?>
        <td <?= $Page->NUMER->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_NUMER" class="TREATMENT_BILLTRANS1_NUMER">
<span<?= $Page->NUMER->viewAttributes() ?>>
<?= $Page->NUMER->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->MEASURE_ID2->Visible) { // MEASURE_ID2 ?>
        <td <?= $Page->MEASURE_ID2->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_MEASURE_ID2" class="TREATMENT_BILLTRANS1_MEASURE_ID2">
<span<?= $Page->MEASURE_ID2->viewAttributes() ?>>
<?= $Page->MEASURE_ID2->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->POTONGAN->Visible) { // POTONGAN ?>
        <td <?= $Page->POTONGAN->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_POTONGAN" class="TREATMENT_BILLTRANS1_POTONGAN">
<span<?= $Page->POTONGAN->viewAttributes() ?>>
<?= $Page->POTONGAN->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->BAYAR->Visible) { // BAYAR ?>
        <td <?= $Page->BAYAR->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_BAYAR" class="TREATMENT_BILLTRANS1_BAYAR">
<span<?= $Page->BAYAR->viewAttributes() ?>>
<?= $Page->BAYAR->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->RETUR->Visible) { // RETUR ?>
        <td <?= $Page->RETUR->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_RETUR" class="TREATMENT_BILLTRANS1_RETUR">
<span<?= $Page->RETUR->viewAttributes() ?>>
<?= $Page->RETUR->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->TARIF_TYPE->Visible) { // TARIF_TYPE ?>
        <td <?= $Page->TARIF_TYPE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_TARIF_TYPE" class="TREATMENT_BILLTRANS1_TARIF_TYPE">
<span<?= $Page->TARIF_TYPE->viewAttributes() ?>>
<?= $Page->TARIF_TYPE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->PPNVALUE->Visible) { // PPNVALUE ?>
        <td <?= $Page->PPNVALUE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_PPNVALUE" class="TREATMENT_BILLTRANS1_PPNVALUE">
<span<?= $Page->PPNVALUE->viewAttributes() ?>>
<?= $Page->PPNVALUE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->TAGIHAN->Visible) { // TAGIHAN ?>
        <td <?= $Page->TAGIHAN->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_TAGIHAN" class="TREATMENT_BILLTRANS1_TAGIHAN">
<span<?= $Page->TAGIHAN->viewAttributes() ?>>
<?= $Page->TAGIHAN->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->KOREKSI->Visible) { // KOREKSI ?>
        <td <?= $Page->KOREKSI->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_KOREKSI" class="TREATMENT_BILLTRANS1_KOREKSI">
<span<?= $Page->KOREKSI->viewAttributes() ?>>
<?= $Page->KOREKSI->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->STATUS_OBAT->Visible) { // STATUS_OBAT ?>
        <td <?= $Page->STATUS_OBAT->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_STATUS_OBAT" class="TREATMENT_BILLTRANS1_STATUS_OBAT">
<span<?= $Page->STATUS_OBAT->viewAttributes() ?>>
<?= $Page->STATUS_OBAT->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->SUBSIDISAT->Visible) { // SUBSIDISAT ?>
        <td <?= $Page->SUBSIDISAT->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_SUBSIDISAT" class="TREATMENT_BILLTRANS1_SUBSIDISAT">
<span<?= $Page->SUBSIDISAT->viewAttributes() ?>>
<?= $Page->SUBSIDISAT->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->PRINTQ->Visible) { // PRINTQ ?>
        <td <?= $Page->PRINTQ->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_PRINTQ" class="TREATMENT_BILLTRANS1_PRINTQ">
<span<?= $Page->PRINTQ->viewAttributes() ?>>
<?= $Page->PRINTQ->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->PRINTED_BY->Visible) { // PRINTED_BY ?>
        <td <?= $Page->PRINTED_BY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_PRINTED_BY" class="TREATMENT_BILLTRANS1_PRINTED_BY">
<span<?= $Page->PRINTED_BY->viewAttributes() ?>>
<?= $Page->PRINTED_BY->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->STOCK_AVAILABLE->Visible) { // STOCK_AVAILABLE ?>
        <td <?= $Page->STOCK_AVAILABLE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_STOCK_AVAILABLE" class="TREATMENT_BILLTRANS1_STOCK_AVAILABLE">
<span<?= $Page->STOCK_AVAILABLE->viewAttributes() ?>>
<?= $Page->STOCK_AVAILABLE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->STATUS_TARIF->Visible) { // STATUS_TARIF ?>
        <td <?= $Page->STATUS_TARIF->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_STATUS_TARIF" class="TREATMENT_BILLTRANS1_STATUS_TARIF">
<span<?= $Page->STATUS_TARIF->viewAttributes() ?>>
<?= $Page->STATUS_TARIF->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->CLINIC_TYPE->Visible) { // CLINIC_TYPE ?>
        <td <?= $Page->CLINIC_TYPE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_CLINIC_TYPE" class="TREATMENT_BILLTRANS1_CLINIC_TYPE">
<span<?= $Page->CLINIC_TYPE->viewAttributes() ?>>
<?= $Page->CLINIC_TYPE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->PACKAGE_ID->Visible) { // PACKAGE_ID ?>
        <td <?= $Page->PACKAGE_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_PACKAGE_ID" class="TREATMENT_BILLTRANS1_PACKAGE_ID">
<span<?= $Page->PACKAGE_ID->viewAttributes() ?>>
<?= $Page->PACKAGE_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->MODULE_ID->Visible) { // MODULE_ID ?>
        <td <?= $Page->MODULE_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_MODULE_ID" class="TREATMENT_BILLTRANS1_MODULE_ID">
<span<?= $Page->MODULE_ID->viewAttributes() ?>>
<?= $Page->MODULE_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->profession->Visible) { // profession ?>
        <td <?= $Page->profession->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_profession" class="TREATMENT_BILLTRANS1_profession">
<span<?= $Page->profession->viewAttributes() ?>>
<?= $Page->profession->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->THEORDER->Visible) { // THEORDER ?>
        <td <?= $Page->THEORDER->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_THEORDER" class="TREATMENT_BILLTRANS1_THEORDER">
<span<?= $Page->THEORDER->viewAttributes() ?>>
<?= $Page->THEORDER->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->CASHIER->Visible) { // CASHIER ?>
        <td <?= $Page->CASHIER->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILLTRANS1_CASHIER" class="TREATMENT_BILLTRANS1_CASHIER">
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
