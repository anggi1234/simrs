<?php

namespace PHPMaker2021\SIMRSSQLSERVERREKAMMEDIK;

// Page object
$TreatmentBayarView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fTREATMENT_BAYARview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fTREATMENT_BAYARview = currentForm = new ew.Form("fTREATMENT_BAYARview", "view");
    loadjs.done("fTREATMENT_BAYARview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.TREATMENT_BAYAR) ew.vars.tables.TREATMENT_BAYAR = <?= JsonEncode(GetClientVar("tables", "TREATMENT_BAYAR")) ?>;
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
<form name="fTREATMENT_BAYARview" id="fTREATMENT_BAYARview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="TREATMENT_BAYAR">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-bordered table-hover ew-view-table">
<?php if ($Page->ORG_UNIT_CODE->Visible) { // ORG_UNIT_CODE ?>
    <tr id="r_ORG_UNIT_CODE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_ORG_UNIT_CODE"><?= $Page->ORG_UNIT_CODE->caption() ?></span></td>
        <td data-name="ORG_UNIT_CODE" <?= $Page->ORG_UNIT_CODE->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_ORG_UNIT_CODE">
<span<?= $Page->ORG_UNIT_CODE->viewAttributes() ?>>
<?= $Page->ORG_UNIT_CODE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->BILL_ID->Visible) { // BILL_ID ?>
    <tr id="r_BILL_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_BILL_ID"><?= $Page->BILL_ID->caption() ?></span></td>
        <td data-name="BILL_ID" <?= $Page->BILL_ID->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_BILL_ID">
<span<?= $Page->BILL_ID->viewAttributes() ?>>
<?= $Page->BILL_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->NO_REGISTRATION->Visible) { // NO_REGISTRATION ?>
    <tr id="r_NO_REGISTRATION">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_NO_REGISTRATION"><?= $Page->NO_REGISTRATION->caption() ?></span></td>
        <td data-name="NO_REGISTRATION" <?= $Page->NO_REGISTRATION->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_NO_REGISTRATION">
<span<?= $Page->NO_REGISTRATION->viewAttributes() ?>>
<?= $Page->NO_REGISTRATION->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->VISIT_ID->Visible) { // VISIT_ID ?>
    <tr id="r_VISIT_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_VISIT_ID"><?= $Page->VISIT_ID->caption() ?></span></td>
        <td data-name="VISIT_ID" <?= $Page->VISIT_ID->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_VISIT_ID">
<span<?= $Page->VISIT_ID->viewAttributes() ?>>
<?= $Page->VISIT_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->TARIF_ID->Visible) { // TARIF_ID ?>
    <tr id="r_TARIF_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_TARIF_ID"><?= $Page->TARIF_ID->caption() ?></span></td>
        <td data-name="TARIF_ID" <?= $Page->TARIF_ID->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_TARIF_ID">
<span<?= $Page->TARIF_ID->viewAttributes() ?>>
<?= $Page->TARIF_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->CLASS_ID->Visible) { // CLASS_ID ?>
    <tr id="r_CLASS_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_CLASS_ID"><?= $Page->CLASS_ID->caption() ?></span></td>
        <td data-name="CLASS_ID" <?= $Page->CLASS_ID->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_CLASS_ID">
<span<?= $Page->CLASS_ID->viewAttributes() ?>>
<?= $Page->CLASS_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->CLINIC_ID->Visible) { // CLINIC_ID ?>
    <tr id="r_CLINIC_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_CLINIC_ID"><?= $Page->CLINIC_ID->caption() ?></span></td>
        <td data-name="CLINIC_ID" <?= $Page->CLINIC_ID->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_CLINIC_ID">
<span<?= $Page->CLINIC_ID->viewAttributes() ?>>
<?= $Page->CLINIC_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->CLINIC_ID_FROM->Visible) { // CLINIC_ID_FROM ?>
    <tr id="r_CLINIC_ID_FROM">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_CLINIC_ID_FROM"><?= $Page->CLINIC_ID_FROM->caption() ?></span></td>
        <td data-name="CLINIC_ID_FROM" <?= $Page->CLINIC_ID_FROM->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_CLINIC_ID_FROM">
<span<?= $Page->CLINIC_ID_FROM->viewAttributes() ?>>
<?= $Page->CLINIC_ID_FROM->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->TREATMENT->Visible) { // TREATMENT ?>
    <tr id="r_TREATMENT">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_TREATMENT"><?= $Page->TREATMENT->caption() ?></span></td>
        <td data-name="TREATMENT" <?= $Page->TREATMENT->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_TREATMENT">
<span<?= $Page->TREATMENT->viewAttributes() ?>>
<?= $Page->TREATMENT->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->TREAT_DATE->Visible) { // TREAT_DATE ?>
    <tr id="r_TREAT_DATE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_TREAT_DATE"><?= $Page->TREAT_DATE->caption() ?></span></td>
        <td data-name="TREAT_DATE" <?= $Page->TREAT_DATE->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_TREAT_DATE">
<span<?= $Page->TREAT_DATE->viewAttributes() ?>>
<?= $Page->TREAT_DATE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->AMOUNT->Visible) { // AMOUNT ?>
    <tr id="r_AMOUNT">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_AMOUNT"><?= $Page->AMOUNT->caption() ?></span></td>
        <td data-name="AMOUNT" <?= $Page->AMOUNT->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_AMOUNT">
<span<?= $Page->AMOUNT->viewAttributes() ?>>
<?= $Page->AMOUNT->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->QUANTITY->Visible) { // QUANTITY ?>
    <tr id="r_QUANTITY">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_QUANTITY"><?= $Page->QUANTITY->caption() ?></span></td>
        <td data-name="QUANTITY" <?= $Page->QUANTITY->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_QUANTITY">
<span<?= $Page->QUANTITY->viewAttributes() ?>>
<?= $Page->QUANTITY->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->MEASURE_ID->Visible) { // MEASURE_ID ?>
    <tr id="r_MEASURE_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_MEASURE_ID"><?= $Page->MEASURE_ID->caption() ?></span></td>
        <td data-name="MEASURE_ID" <?= $Page->MEASURE_ID->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_MEASURE_ID">
<span<?= $Page->MEASURE_ID->viewAttributes() ?>>
<?= $Page->MEASURE_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->POKOK_JUAL->Visible) { // POKOK_JUAL ?>
    <tr id="r_POKOK_JUAL">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_POKOK_JUAL"><?= $Page->POKOK_JUAL->caption() ?></span></td>
        <td data-name="POKOK_JUAL" <?= $Page->POKOK_JUAL->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_POKOK_JUAL">
<span<?= $Page->POKOK_JUAL->viewAttributes() ?>>
<?= $Page->POKOK_JUAL->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->PPN->Visible) { // PPN ?>
    <tr id="r_PPN">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_PPN"><?= $Page->PPN->caption() ?></span></td>
        <td data-name="PPN" <?= $Page->PPN->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_PPN">
<span<?= $Page->PPN->viewAttributes() ?>>
<?= $Page->PPN->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->MARGIN->Visible) { // MARGIN ?>
    <tr id="r_MARGIN">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_MARGIN"><?= $Page->MARGIN->caption() ?></span></td>
        <td data-name="MARGIN" <?= $Page->MARGIN->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_MARGIN">
<span<?= $Page->MARGIN->viewAttributes() ?>>
<?= $Page->MARGIN->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->SUBSIDI->Visible) { // SUBSIDI ?>
    <tr id="r_SUBSIDI">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_SUBSIDI"><?= $Page->SUBSIDI->caption() ?></span></td>
        <td data-name="SUBSIDI" <?= $Page->SUBSIDI->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_SUBSIDI">
<span<?= $Page->SUBSIDI->viewAttributes() ?>>
<?= $Page->SUBSIDI->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->EMBALACE->Visible) { // EMBALACE ?>
    <tr id="r_EMBALACE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_EMBALACE"><?= $Page->EMBALACE->caption() ?></span></td>
        <td data-name="EMBALACE" <?= $Page->EMBALACE->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_EMBALACE">
<span<?= $Page->EMBALACE->viewAttributes() ?>>
<?= $Page->EMBALACE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->PROFESI->Visible) { // PROFESI ?>
    <tr id="r_PROFESI">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_PROFESI"><?= $Page->PROFESI->caption() ?></span></td>
        <td data-name="PROFESI" <?= $Page->PROFESI->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_PROFESI">
<span<?= $Page->PROFESI->viewAttributes() ?>>
<?= $Page->PROFESI->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->DISCOUNT->Visible) { // DISCOUNT ?>
    <tr id="r_DISCOUNT">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_DISCOUNT"><?= $Page->DISCOUNT->caption() ?></span></td>
        <td data-name="DISCOUNT" <?= $Page->DISCOUNT->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_DISCOUNT">
<span<?= $Page->DISCOUNT->viewAttributes() ?>>
<?= $Page->DISCOUNT->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->PAY_METHOD_ID->Visible) { // PAY_METHOD_ID ?>
    <tr id="r_PAY_METHOD_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_PAY_METHOD_ID"><?= $Page->PAY_METHOD_ID->caption() ?></span></td>
        <td data-name="PAY_METHOD_ID" <?= $Page->PAY_METHOD_ID->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_PAY_METHOD_ID">
<span<?= $Page->PAY_METHOD_ID->viewAttributes() ?>>
<?= $Page->PAY_METHOD_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->PAYMENT_DATE->Visible) { // PAYMENT_DATE ?>
    <tr id="r_PAYMENT_DATE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_PAYMENT_DATE"><?= $Page->PAYMENT_DATE->caption() ?></span></td>
        <td data-name="PAYMENT_DATE" <?= $Page->PAYMENT_DATE->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_PAYMENT_DATE">
<span<?= $Page->PAYMENT_DATE->viewAttributes() ?>>
<?= $Page->PAYMENT_DATE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ISLUNAS->Visible) { // ISLUNAS ?>
    <tr id="r_ISLUNAS">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_ISLUNAS"><?= $Page->ISLUNAS->caption() ?></span></td>
        <td data-name="ISLUNAS" <?= $Page->ISLUNAS->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_ISLUNAS">
<span<?= $Page->ISLUNAS->viewAttributes() ?>>
<?= $Page->ISLUNAS->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->DUEDATE_ANGSURAN->Visible) { // DUEDATE_ANGSURAN ?>
    <tr id="r_DUEDATE_ANGSURAN">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_DUEDATE_ANGSURAN"><?= $Page->DUEDATE_ANGSURAN->caption() ?></span></td>
        <td data-name="DUEDATE_ANGSURAN" <?= $Page->DUEDATE_ANGSURAN->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_DUEDATE_ANGSURAN">
<span<?= $Page->DUEDATE_ANGSURAN->viewAttributes() ?>>
<?= $Page->DUEDATE_ANGSURAN->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->DESCRIPTION->Visible) { // DESCRIPTION ?>
    <tr id="r_DESCRIPTION">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_DESCRIPTION"><?= $Page->DESCRIPTION->caption() ?></span></td>
        <td data-name="DESCRIPTION" <?= $Page->DESCRIPTION->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_DESCRIPTION">
<span<?= $Page->DESCRIPTION->viewAttributes() ?>>
<?= $Page->DESCRIPTION->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->KUITANSI_ID->Visible) { // KUITANSI_ID ?>
    <tr id="r_KUITANSI_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_KUITANSI_ID"><?= $Page->KUITANSI_ID->caption() ?></span></td>
        <td data-name="KUITANSI_ID" <?= $Page->KUITANSI_ID->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_KUITANSI_ID">
<span<?= $Page->KUITANSI_ID->viewAttributes() ?>>
<?= $Page->KUITANSI_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->NOTA_NO->Visible) { // NOTA_NO ?>
    <tr id="r_NOTA_NO">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_NOTA_NO"><?= $Page->NOTA_NO->caption() ?></span></td>
        <td data-name="NOTA_NO" <?= $Page->NOTA_NO->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_NOTA_NO">
<span<?= $Page->NOTA_NO->viewAttributes() ?>>
<?= $Page->NOTA_NO->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ISCETAK->Visible) { // ISCETAK ?>
    <tr id="r_ISCETAK">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_ISCETAK"><?= $Page->ISCETAK->caption() ?></span></td>
        <td data-name="ISCETAK" <?= $Page->ISCETAK->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_ISCETAK">
<span<?= $Page->ISCETAK->viewAttributes() ?>>
<?= $Page->ISCETAK->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->PRINT_DATE->Visible) { // PRINT_DATE ?>
    <tr id="r_PRINT_DATE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_PRINT_DATE"><?= $Page->PRINT_DATE->caption() ?></span></td>
        <td data-name="PRINT_DATE" <?= $Page->PRINT_DATE->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_PRINT_DATE">
<span<?= $Page->PRINT_DATE->viewAttributes() ?>>
<?= $Page->PRINT_DATE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->RESEP_NO->Visible) { // RESEP_NO ?>
    <tr id="r_RESEP_NO">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_RESEP_NO"><?= $Page->RESEP_NO->caption() ?></span></td>
        <td data-name="RESEP_NO" <?= $Page->RESEP_NO->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_RESEP_NO">
<span<?= $Page->RESEP_NO->viewAttributes() ?>>
<?= $Page->RESEP_NO->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->RESEP_KE->Visible) { // RESEP_KE ?>
    <tr id="r_RESEP_KE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_RESEP_KE"><?= $Page->RESEP_KE->caption() ?></span></td>
        <td data-name="RESEP_KE" <?= $Page->RESEP_KE->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_RESEP_KE">
<span<?= $Page->RESEP_KE->viewAttributes() ?>>
<?= $Page->RESEP_KE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->DOSE->Visible) { // DOSE ?>
    <tr id="r_DOSE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_DOSE"><?= $Page->DOSE->caption() ?></span></td>
        <td data-name="DOSE" <?= $Page->DOSE->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_DOSE">
<span<?= $Page->DOSE->viewAttributes() ?>>
<?= $Page->DOSE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ORIG_DOSE->Visible) { // ORIG_DOSE ?>
    <tr id="r_ORIG_DOSE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_ORIG_DOSE"><?= $Page->ORIG_DOSE->caption() ?></span></td>
        <td data-name="ORIG_DOSE" <?= $Page->ORIG_DOSE->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_ORIG_DOSE">
<span<?= $Page->ORIG_DOSE->viewAttributes() ?>>
<?= $Page->ORIG_DOSE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->DOSE_PRESC->Visible) { // DOSE_PRESC ?>
    <tr id="r_DOSE_PRESC">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_DOSE_PRESC"><?= $Page->DOSE_PRESC->caption() ?></span></td>
        <td data-name="DOSE_PRESC" <?= $Page->DOSE_PRESC->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_DOSE_PRESC">
<span<?= $Page->DOSE_PRESC->viewAttributes() ?>>
<?= $Page->DOSE_PRESC->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ITER->Visible) { // ITER ?>
    <tr id="r_ITER">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_ITER"><?= $Page->ITER->caption() ?></span></td>
        <td data-name="ITER" <?= $Page->ITER->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_ITER">
<span<?= $Page->ITER->viewAttributes() ?>>
<?= $Page->ITER->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ITER_KE->Visible) { // ITER_KE ?>
    <tr id="r_ITER_KE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_ITER_KE"><?= $Page->ITER_KE->caption() ?></span></td>
        <td data-name="ITER_KE" <?= $Page->ITER_KE->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_ITER_KE">
<span<?= $Page->ITER_KE->viewAttributes() ?>>
<?= $Page->ITER_KE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->SOLD_STATUS->Visible) { // SOLD_STATUS ?>
    <tr id="r_SOLD_STATUS">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_SOLD_STATUS"><?= $Page->SOLD_STATUS->caption() ?></span></td>
        <td data-name="SOLD_STATUS" <?= $Page->SOLD_STATUS->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_SOLD_STATUS">
<span<?= $Page->SOLD_STATUS->viewAttributes() ?>>
<?= $Page->SOLD_STATUS->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->RACIKAN->Visible) { // RACIKAN ?>
    <tr id="r_RACIKAN">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_RACIKAN"><?= $Page->RACIKAN->caption() ?></span></td>
        <td data-name="RACIKAN" <?= $Page->RACIKAN->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_RACIKAN">
<span<?= $Page->RACIKAN->viewAttributes() ?>>
<?= $Page->RACIKAN->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->CLASS_ROOM_ID->Visible) { // CLASS_ROOM_ID ?>
    <tr id="r_CLASS_ROOM_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_CLASS_ROOM_ID"><?= $Page->CLASS_ROOM_ID->caption() ?></span></td>
        <td data-name="CLASS_ROOM_ID" <?= $Page->CLASS_ROOM_ID->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_CLASS_ROOM_ID">
<span<?= $Page->CLASS_ROOM_ID->viewAttributes() ?>>
<?= $Page->CLASS_ROOM_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->KELUAR_ID->Visible) { // KELUAR_ID ?>
    <tr id="r_KELUAR_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_KELUAR_ID"><?= $Page->KELUAR_ID->caption() ?></span></td>
        <td data-name="KELUAR_ID" <?= $Page->KELUAR_ID->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_KELUAR_ID">
<span<?= $Page->KELUAR_ID->viewAttributes() ?>>
<?= $Page->KELUAR_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->BED_ID->Visible) { // BED_ID ?>
    <tr id="r_BED_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_BED_ID"><?= $Page->BED_ID->caption() ?></span></td>
        <td data-name="BED_ID" <?= $Page->BED_ID->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_BED_ID">
<span<?= $Page->BED_ID->viewAttributes() ?>>
<?= $Page->BED_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->PERDA_ID->Visible) { // PERDA_ID ?>
    <tr id="r_PERDA_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_PERDA_ID"><?= $Page->PERDA_ID->caption() ?></span></td>
        <td data-name="PERDA_ID" <?= $Page->PERDA_ID->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_PERDA_ID">
<span<?= $Page->PERDA_ID->viewAttributes() ?>>
<?= $Page->PERDA_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->EMPLOYEE_ID->Visible) { // EMPLOYEE_ID ?>
    <tr id="r_EMPLOYEE_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_EMPLOYEE_ID"><?= $Page->EMPLOYEE_ID->caption() ?></span></td>
        <td data-name="EMPLOYEE_ID" <?= $Page->EMPLOYEE_ID->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_EMPLOYEE_ID">
<span<?= $Page->EMPLOYEE_ID->viewAttributes() ?>>
<?= $Page->EMPLOYEE_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->DESCRIPTION2->Visible) { // DESCRIPTION2 ?>
    <tr id="r_DESCRIPTION2">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_DESCRIPTION2"><?= $Page->DESCRIPTION2->caption() ?></span></td>
        <td data-name="DESCRIPTION2" <?= $Page->DESCRIPTION2->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_DESCRIPTION2">
<span<?= $Page->DESCRIPTION2->viewAttributes() ?>>
<?= $Page->DESCRIPTION2->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
    <tr id="r_MODIFIED_BY">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_MODIFIED_BY"><?= $Page->MODIFIED_BY->caption() ?></span></td>
        <td data-name="MODIFIED_BY" <?= $Page->MODIFIED_BY->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_MODIFIED_BY">
<span<?= $Page->MODIFIED_BY->viewAttributes() ?>>
<?= $Page->MODIFIED_BY->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
    <tr id="r_MODIFIED_DATE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_MODIFIED_DATE"><?= $Page->MODIFIED_DATE->caption() ?></span></td>
        <td data-name="MODIFIED_DATE" <?= $Page->MODIFIED_DATE->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_MODIFIED_DATE">
<span<?= $Page->MODIFIED_DATE->viewAttributes() ?>>
<?= $Page->MODIFIED_DATE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->MODIFIED_FROM->Visible) { // MODIFIED_FROM ?>
    <tr id="r_MODIFIED_FROM">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_MODIFIED_FROM"><?= $Page->MODIFIED_FROM->caption() ?></span></td>
        <td data-name="MODIFIED_FROM" <?= $Page->MODIFIED_FROM->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_MODIFIED_FROM">
<span<?= $Page->MODIFIED_FROM->viewAttributes() ?>>
<?= $Page->MODIFIED_FROM->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->BRAND_ID->Visible) { // BRAND_ID ?>
    <tr id="r_BRAND_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_BRAND_ID"><?= $Page->BRAND_ID->caption() ?></span></td>
        <td data-name="BRAND_ID" <?= $Page->BRAND_ID->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_BRAND_ID">
<span<?= $Page->BRAND_ID->viewAttributes() ?>>
<?= $Page->BRAND_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->DOCTOR->Visible) { // DOCTOR ?>
    <tr id="r_DOCTOR">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_DOCTOR"><?= $Page->DOCTOR->caption() ?></span></td>
        <td data-name="DOCTOR" <?= $Page->DOCTOR->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_DOCTOR">
<span<?= $Page->DOCTOR->viewAttributes() ?>>
<?= $Page->DOCTOR->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->JML_BKS->Visible) { // JML_BKS ?>
    <tr id="r_JML_BKS">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_JML_BKS"><?= $Page->JML_BKS->caption() ?></span></td>
        <td data-name="JML_BKS" <?= $Page->JML_BKS->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_JML_BKS">
<span<?= $Page->JML_BKS->viewAttributes() ?>>
<?= $Page->JML_BKS->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->EXIT_DATE->Visible) { // EXIT_DATE ?>
    <tr id="r_EXIT_DATE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_EXIT_DATE"><?= $Page->EXIT_DATE->caption() ?></span></td>
        <td data-name="EXIT_DATE" <?= $Page->EXIT_DATE->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_EXIT_DATE">
<span<?= $Page->EXIT_DATE->viewAttributes() ?>>
<?= $Page->EXIT_DATE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->FA_V->Visible) { // FA_V ?>
    <tr id="r_FA_V">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_FA_V"><?= $Page->FA_V->caption() ?></span></td>
        <td data-name="FA_V" <?= $Page->FA_V->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_FA_V">
<span<?= $Page->FA_V->viewAttributes() ?>>
<?= $Page->FA_V->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->TASK_ID->Visible) { // TASK_ID ?>
    <tr id="r_TASK_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_TASK_ID"><?= $Page->TASK_ID->caption() ?></span></td>
        <td data-name="TASK_ID" <?= $Page->TASK_ID->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_TASK_ID">
<span<?= $Page->TASK_ID->viewAttributes() ?>>
<?= $Page->TASK_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->EMPLOYEE_ID_FROM->Visible) { // EMPLOYEE_ID_FROM ?>
    <tr id="r_EMPLOYEE_ID_FROM">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_EMPLOYEE_ID_FROM"><?= $Page->EMPLOYEE_ID_FROM->caption() ?></span></td>
        <td data-name="EMPLOYEE_ID_FROM" <?= $Page->EMPLOYEE_ID_FROM->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_EMPLOYEE_ID_FROM">
<span<?= $Page->EMPLOYEE_ID_FROM->viewAttributes() ?>>
<?= $Page->EMPLOYEE_ID_FROM->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->DOCTOR_FROM->Visible) { // DOCTOR_FROM ?>
    <tr id="r_DOCTOR_FROM">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_DOCTOR_FROM"><?= $Page->DOCTOR_FROM->caption() ?></span></td>
        <td data-name="DOCTOR_FROM" <?= $Page->DOCTOR_FROM->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_DOCTOR_FROM">
<span<?= $Page->DOCTOR_FROM->viewAttributes() ?>>
<?= $Page->DOCTOR_FROM->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->status_pasien_id->Visible) { // status_pasien_id ?>
    <tr id="r_status_pasien_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_status_pasien_id"><?= $Page->status_pasien_id->caption() ?></span></td>
        <td data-name="status_pasien_id" <?= $Page->status_pasien_id->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_status_pasien_id">
<span<?= $Page->status_pasien_id->viewAttributes() ?>>
<?= $Page->status_pasien_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->amount_paid->Visible) { // amount_paid ?>
    <tr id="r_amount_paid">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_amount_paid"><?= $Page->amount_paid->caption() ?></span></td>
        <td data-name="amount_paid" <?= $Page->amount_paid->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_amount_paid">
<span<?= $Page->amount_paid->viewAttributes() ?>>
<?= $Page->amount_paid->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->THENAME->Visible) { // THENAME ?>
    <tr id="r_THENAME">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_THENAME"><?= $Page->THENAME->caption() ?></span></td>
        <td data-name="THENAME" <?= $Page->THENAME->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_THENAME">
<span<?= $Page->THENAME->viewAttributes() ?>>
<?= $Page->THENAME->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->THEADDRESS->Visible) { // THEADDRESS ?>
    <tr id="r_THEADDRESS">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_THEADDRESS"><?= $Page->THEADDRESS->caption() ?></span></td>
        <td data-name="THEADDRESS" <?= $Page->THEADDRESS->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_THEADDRESS">
<span<?= $Page->THEADDRESS->viewAttributes() ?>>
<?= $Page->THEADDRESS->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->THEID->Visible) { // THEID ?>
    <tr id="r_THEID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_THEID"><?= $Page->THEID->caption() ?></span></td>
        <td data-name="THEID" <?= $Page->THEID->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_THEID">
<span<?= $Page->THEID->viewAttributes() ?>>
<?= $Page->THEID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->serial_nb->Visible) { // serial_nb ?>
    <tr id="r_serial_nb">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_serial_nb"><?= $Page->serial_nb->caption() ?></span></td>
        <td data-name="serial_nb" <?= $Page->serial_nb->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_serial_nb">
<span<?= $Page->serial_nb->viewAttributes() ?>>
<?= $Page->serial_nb->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->TREATMENT_PLAFOND->Visible) { // TREATMENT_PLAFOND ?>
    <tr id="r_TREATMENT_PLAFOND">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_TREATMENT_PLAFOND"><?= $Page->TREATMENT_PLAFOND->caption() ?></span></td>
        <td data-name="TREATMENT_PLAFOND" <?= $Page->TREATMENT_PLAFOND->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_TREATMENT_PLAFOND">
<span<?= $Page->TREATMENT_PLAFOND->viewAttributes() ?>>
<?= $Page->TREATMENT_PLAFOND->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->AMOUNT_PLAFOND->Visible) { // AMOUNT_PLAFOND ?>
    <tr id="r_AMOUNT_PLAFOND">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_AMOUNT_PLAFOND"><?= $Page->AMOUNT_PLAFOND->caption() ?></span></td>
        <td data-name="AMOUNT_PLAFOND" <?= $Page->AMOUNT_PLAFOND->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_AMOUNT_PLAFOND">
<span<?= $Page->AMOUNT_PLAFOND->viewAttributes() ?>>
<?= $Page->AMOUNT_PLAFOND->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->AMOUNT_PAID_PLAFOND->Visible) { // AMOUNT_PAID_PLAFOND ?>
    <tr id="r_AMOUNT_PAID_PLAFOND">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_AMOUNT_PAID_PLAFOND"><?= $Page->AMOUNT_PAID_PLAFOND->caption() ?></span></td>
        <td data-name="AMOUNT_PAID_PLAFOND" <?= $Page->AMOUNT_PAID_PLAFOND->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_AMOUNT_PAID_PLAFOND">
<span<?= $Page->AMOUNT_PAID_PLAFOND->viewAttributes() ?>>
<?= $Page->AMOUNT_PAID_PLAFOND->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->CLASS_ID_PLAFOND->Visible) { // CLASS_ID_PLAFOND ?>
    <tr id="r_CLASS_ID_PLAFOND">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_CLASS_ID_PLAFOND"><?= $Page->CLASS_ID_PLAFOND->caption() ?></span></td>
        <td data-name="CLASS_ID_PLAFOND" <?= $Page->CLASS_ID_PLAFOND->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_CLASS_ID_PLAFOND">
<span<?= $Page->CLASS_ID_PLAFOND->viewAttributes() ?>>
<?= $Page->CLASS_ID_PLAFOND->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->PAYOR_ID->Visible) { // PAYOR_ID ?>
    <tr id="r_PAYOR_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_PAYOR_ID"><?= $Page->PAYOR_ID->caption() ?></span></td>
        <td data-name="PAYOR_ID" <?= $Page->PAYOR_ID->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_PAYOR_ID">
<span<?= $Page->PAYOR_ID->viewAttributes() ?>>
<?= $Page->PAYOR_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->PEMBULATAN->Visible) { // PEMBULATAN ?>
    <tr id="r_PEMBULATAN">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_PEMBULATAN"><?= $Page->PEMBULATAN->caption() ?></span></td>
        <td data-name="PEMBULATAN" <?= $Page->PEMBULATAN->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_PEMBULATAN">
<span<?= $Page->PEMBULATAN->viewAttributes() ?>>
<?= $Page->PEMBULATAN->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ISRJ->Visible) { // ISRJ ?>
    <tr id="r_ISRJ">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_ISRJ"><?= $Page->ISRJ->caption() ?></span></td>
        <td data-name="ISRJ" <?= $Page->ISRJ->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_ISRJ">
<span<?= $Page->ISRJ->viewAttributes() ?>>
<?= $Page->ISRJ->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->AGEYEAR->Visible) { // AGEYEAR ?>
    <tr id="r_AGEYEAR">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_AGEYEAR"><?= $Page->AGEYEAR->caption() ?></span></td>
        <td data-name="AGEYEAR" <?= $Page->AGEYEAR->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_AGEYEAR">
<span<?= $Page->AGEYEAR->viewAttributes() ?>>
<?= $Page->AGEYEAR->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->AGEMONTH->Visible) { // AGEMONTH ?>
    <tr id="r_AGEMONTH">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_AGEMONTH"><?= $Page->AGEMONTH->caption() ?></span></td>
        <td data-name="AGEMONTH" <?= $Page->AGEMONTH->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_AGEMONTH">
<span<?= $Page->AGEMONTH->viewAttributes() ?>>
<?= $Page->AGEMONTH->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->AGEDAY->Visible) { // AGEDAY ?>
    <tr id="r_AGEDAY">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_AGEDAY"><?= $Page->AGEDAY->caption() ?></span></td>
        <td data-name="AGEDAY" <?= $Page->AGEDAY->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_AGEDAY">
<span<?= $Page->AGEDAY->viewAttributes() ?>>
<?= $Page->AGEDAY->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->GENDER->Visible) { // GENDER ?>
    <tr id="r_GENDER">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_GENDER"><?= $Page->GENDER->caption() ?></span></td>
        <td data-name="GENDER" <?= $Page->GENDER->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_GENDER">
<span<?= $Page->GENDER->viewAttributes() ?>>
<?= $Page->GENDER->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->KAL_ID->Visible) { // KAL_ID ?>
    <tr id="r_KAL_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_KAL_ID"><?= $Page->KAL_ID->caption() ?></span></td>
        <td data-name="KAL_ID" <?= $Page->KAL_ID->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_KAL_ID">
<span<?= $Page->KAL_ID->viewAttributes() ?>>
<?= $Page->KAL_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->CORRECTION_ID->Visible) { // CORRECTION_ID ?>
    <tr id="r_CORRECTION_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_CORRECTION_ID"><?= $Page->CORRECTION_ID->caption() ?></span></td>
        <td data-name="CORRECTION_ID" <?= $Page->CORRECTION_ID->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_CORRECTION_ID">
<span<?= $Page->CORRECTION_ID->viewAttributes() ?>>
<?= $Page->CORRECTION_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->CORRECTION_BY->Visible) { // CORRECTION_BY ?>
    <tr id="r_CORRECTION_BY">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_CORRECTION_BY"><?= $Page->CORRECTION_BY->caption() ?></span></td>
        <td data-name="CORRECTION_BY" <?= $Page->CORRECTION_BY->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_CORRECTION_BY">
<span<?= $Page->CORRECTION_BY->viewAttributes() ?>>
<?= $Page->CORRECTION_BY->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->KARYAWAN->Visible) { // KARYAWAN ?>
    <tr id="r_KARYAWAN">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_KARYAWAN"><?= $Page->KARYAWAN->caption() ?></span></td>
        <td data-name="KARYAWAN" <?= $Page->KARYAWAN->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_KARYAWAN">
<span<?= $Page->KARYAWAN->viewAttributes() ?>>
<?= $Page->KARYAWAN->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ACCOUNT_ID->Visible) { // ACCOUNT_ID ?>
    <tr id="r_ACCOUNT_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_ACCOUNT_ID"><?= $Page->ACCOUNT_ID->caption() ?></span></td>
        <td data-name="ACCOUNT_ID" <?= $Page->ACCOUNT_ID->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_ACCOUNT_ID">
<span<?= $Page->ACCOUNT_ID->viewAttributes() ?>>
<?= $Page->ACCOUNT_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->sell_price->Visible) { // sell_price ?>
    <tr id="r_sell_price">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_sell_price"><?= $Page->sell_price->caption() ?></span></td>
        <td data-name="sell_price" <?= $Page->sell_price->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_sell_price">
<span<?= $Page->sell_price->viewAttributes() ?>>
<?= $Page->sell_price->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->diskon->Visible) { // diskon ?>
    <tr id="r_diskon">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_diskon"><?= $Page->diskon->caption() ?></span></td>
        <td data-name="diskon" <?= $Page->diskon->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_diskon">
<span<?= $Page->diskon->viewAttributes() ?>>
<?= $Page->diskon->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->INVOICE_ID->Visible) { // INVOICE_ID ?>
    <tr id="r_INVOICE_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_INVOICE_ID"><?= $Page->INVOICE_ID->caption() ?></span></td>
        <td data-name="INVOICE_ID" <?= $Page->INVOICE_ID->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_INVOICE_ID">
<span<?= $Page->INVOICE_ID->viewAttributes() ?>>
<?= $Page->INVOICE_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->NUMER->Visible) { // NUMER ?>
    <tr id="r_NUMER">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_NUMER"><?= $Page->NUMER->caption() ?></span></td>
        <td data-name="NUMER" <?= $Page->NUMER->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_NUMER">
<span<?= $Page->NUMER->viewAttributes() ?>>
<?= $Page->NUMER->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->MEASURE_ID2->Visible) { // MEASURE_ID2 ?>
    <tr id="r_MEASURE_ID2">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_MEASURE_ID2"><?= $Page->MEASURE_ID2->caption() ?></span></td>
        <td data-name="MEASURE_ID2" <?= $Page->MEASURE_ID2->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_MEASURE_ID2">
<span<?= $Page->MEASURE_ID2->viewAttributes() ?>>
<?= $Page->MEASURE_ID2->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->POTONGAN->Visible) { // POTONGAN ?>
    <tr id="r_POTONGAN">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_POTONGAN"><?= $Page->POTONGAN->caption() ?></span></td>
        <td data-name="POTONGAN" <?= $Page->POTONGAN->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_POTONGAN">
<span<?= $Page->POTONGAN->viewAttributes() ?>>
<?= $Page->POTONGAN->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->BAYAR->Visible) { // BAYAR ?>
    <tr id="r_BAYAR">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_BAYAR"><?= $Page->BAYAR->caption() ?></span></td>
        <td data-name="BAYAR" <?= $Page->BAYAR->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_BAYAR">
<span<?= $Page->BAYAR->viewAttributes() ?>>
<?= $Page->BAYAR->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->RETUR->Visible) { // RETUR ?>
    <tr id="r_RETUR">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_RETUR"><?= $Page->RETUR->caption() ?></span></td>
        <td data-name="RETUR" <?= $Page->RETUR->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_RETUR">
<span<?= $Page->RETUR->viewAttributes() ?>>
<?= $Page->RETUR->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->TARIF_TYPE->Visible) { // TARIF_TYPE ?>
    <tr id="r_TARIF_TYPE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_TARIF_TYPE"><?= $Page->TARIF_TYPE->caption() ?></span></td>
        <td data-name="TARIF_TYPE" <?= $Page->TARIF_TYPE->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_TARIF_TYPE">
<span<?= $Page->TARIF_TYPE->viewAttributes() ?>>
<?= $Page->TARIF_TYPE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->PPNVALUE->Visible) { // PPNVALUE ?>
    <tr id="r_PPNVALUE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_PPNVALUE"><?= $Page->PPNVALUE->caption() ?></span></td>
        <td data-name="PPNVALUE" <?= $Page->PPNVALUE->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_PPNVALUE">
<span<?= $Page->PPNVALUE->viewAttributes() ?>>
<?= $Page->PPNVALUE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->TAGIHAN->Visible) { // TAGIHAN ?>
    <tr id="r_TAGIHAN">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_TAGIHAN"><?= $Page->TAGIHAN->caption() ?></span></td>
        <td data-name="TAGIHAN" <?= $Page->TAGIHAN->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_TAGIHAN">
<span<?= $Page->TAGIHAN->viewAttributes() ?>>
<?= $Page->TAGIHAN->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->KOREKSI->Visible) { // KOREKSI ?>
    <tr id="r_KOREKSI">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_KOREKSI"><?= $Page->KOREKSI->caption() ?></span></td>
        <td data-name="KOREKSI" <?= $Page->KOREKSI->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_KOREKSI">
<span<?= $Page->KOREKSI->viewAttributes() ?>>
<?= $Page->KOREKSI->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->STATUS_OBAT->Visible) { // STATUS_OBAT ?>
    <tr id="r_STATUS_OBAT">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_STATUS_OBAT"><?= $Page->STATUS_OBAT->caption() ?></span></td>
        <td data-name="STATUS_OBAT" <?= $Page->STATUS_OBAT->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_STATUS_OBAT">
<span<?= $Page->STATUS_OBAT->viewAttributes() ?>>
<?= $Page->STATUS_OBAT->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->SUBSIDISAT->Visible) { // SUBSIDISAT ?>
    <tr id="r_SUBSIDISAT">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_SUBSIDISAT"><?= $Page->SUBSIDISAT->caption() ?></span></td>
        <td data-name="SUBSIDISAT" <?= $Page->SUBSIDISAT->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_SUBSIDISAT">
<span<?= $Page->SUBSIDISAT->viewAttributes() ?>>
<?= $Page->SUBSIDISAT->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->PRINTQ->Visible) { // PRINTQ ?>
    <tr id="r_PRINTQ">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_PRINTQ"><?= $Page->PRINTQ->caption() ?></span></td>
        <td data-name="PRINTQ" <?= $Page->PRINTQ->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_PRINTQ">
<span<?= $Page->PRINTQ->viewAttributes() ?>>
<?= $Page->PRINTQ->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->PRINTED_BY->Visible) { // PRINTED_BY ?>
    <tr id="r_PRINTED_BY">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_PRINTED_BY"><?= $Page->PRINTED_BY->caption() ?></span></td>
        <td data-name="PRINTED_BY" <?= $Page->PRINTED_BY->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_PRINTED_BY">
<span<?= $Page->PRINTED_BY->viewAttributes() ?>>
<?= $Page->PRINTED_BY->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->STOCK_AVAILABLE->Visible) { // STOCK_AVAILABLE ?>
    <tr id="r_STOCK_AVAILABLE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_STOCK_AVAILABLE"><?= $Page->STOCK_AVAILABLE->caption() ?></span></td>
        <td data-name="STOCK_AVAILABLE" <?= $Page->STOCK_AVAILABLE->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_STOCK_AVAILABLE">
<span<?= $Page->STOCK_AVAILABLE->viewAttributes() ?>>
<?= $Page->STOCK_AVAILABLE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->STATUS_TARIF->Visible) { // STATUS_TARIF ?>
    <tr id="r_STATUS_TARIF">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_STATUS_TARIF"><?= $Page->STATUS_TARIF->caption() ?></span></td>
        <td data-name="STATUS_TARIF" <?= $Page->STATUS_TARIF->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_STATUS_TARIF">
<span<?= $Page->STATUS_TARIF->viewAttributes() ?>>
<?= $Page->STATUS_TARIF->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->CLINIC_TYPE->Visible) { // CLINIC_TYPE ?>
    <tr id="r_CLINIC_TYPE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_CLINIC_TYPE"><?= $Page->CLINIC_TYPE->caption() ?></span></td>
        <td data-name="CLINIC_TYPE" <?= $Page->CLINIC_TYPE->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_CLINIC_TYPE">
<span<?= $Page->CLINIC_TYPE->viewAttributes() ?>>
<?= $Page->CLINIC_TYPE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->PACKAGE_ID->Visible) { // PACKAGE_ID ?>
    <tr id="r_PACKAGE_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_PACKAGE_ID"><?= $Page->PACKAGE_ID->caption() ?></span></td>
        <td data-name="PACKAGE_ID" <?= $Page->PACKAGE_ID->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_PACKAGE_ID">
<span<?= $Page->PACKAGE_ID->viewAttributes() ?>>
<?= $Page->PACKAGE_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->MODULE_ID->Visible) { // MODULE_ID ?>
    <tr id="r_MODULE_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_MODULE_ID"><?= $Page->MODULE_ID->caption() ?></span></td>
        <td data-name="MODULE_ID" <?= $Page->MODULE_ID->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_MODULE_ID">
<span<?= $Page->MODULE_ID->viewAttributes() ?>>
<?= $Page->MODULE_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->profession->Visible) { // profession ?>
    <tr id="r_profession">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_profession"><?= $Page->profession->caption() ?></span></td>
        <td data-name="profession" <?= $Page->profession->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_profession">
<span<?= $Page->profession->viewAttributes() ?>>
<?= $Page->profession->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->THEORDER->Visible) { // THEORDER ?>
    <tr id="r_THEORDER">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_THEORDER"><?= $Page->THEORDER->caption() ?></span></td>
        <td data-name="THEORDER" <?= $Page->THEORDER->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_THEORDER">
<span<?= $Page->THEORDER->viewAttributes() ?>>
<?= $Page->THEORDER->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->CASHIER->Visible) { // CASHIER ?>
    <tr id="r_CASHIER">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_CASHIER"><?= $Page->CASHIER->caption() ?></span></td>
        <td data-name="CASHIER" <?= $Page->CASHIER->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_CASHIER">
<span<?= $Page->CASHIER->viewAttributes() ?>>
<?= $Page->CASHIER->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->SPPFEE->Visible) { // SPPFEE ?>
    <tr id="r_SPPFEE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_SPPFEE"><?= $Page->SPPFEE->caption() ?></span></td>
        <td data-name="SPPFEE" <?= $Page->SPPFEE->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_SPPFEE">
<span<?= $Page->SPPFEE->viewAttributes() ?>>
<?= $Page->SPPFEE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->SPPBILL->Visible) { // SPPBILL ?>
    <tr id="r_SPPBILL">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_SPPBILL"><?= $Page->SPPBILL->caption() ?></span></td>
        <td data-name="SPPBILL" <?= $Page->SPPBILL->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_SPPBILL">
<span<?= $Page->SPPBILL->viewAttributes() ?>>
<?= $Page->SPPBILL->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->SPPRJK->Visible) { // SPPRJK ?>
    <tr id="r_SPPRJK">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_SPPRJK"><?= $Page->SPPRJK->caption() ?></span></td>
        <td data-name="SPPRJK" <?= $Page->SPPRJK->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_SPPRJK">
<span<?= $Page->SPPRJK->viewAttributes() ?>>
<?= $Page->SPPRJK->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->SPPJMN->Visible) { // SPPJMN ?>
    <tr id="r_SPPJMN">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_SPPJMN"><?= $Page->SPPJMN->caption() ?></span></td>
        <td data-name="SPPJMN" <?= $Page->SPPJMN->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_SPPJMN">
<span<?= $Page->SPPJMN->viewAttributes() ?>>
<?= $Page->SPPJMN->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->SPPKASIR->Visible) { // SPPKASIR ?>
    <tr id="r_SPPKASIR">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_SPPKASIR"><?= $Page->SPPKASIR->caption() ?></span></td>
        <td data-name="SPPKASIR" <?= $Page->SPPKASIR->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_SPPKASIR">
<span<?= $Page->SPPKASIR->viewAttributes() ?>>
<?= $Page->SPPKASIR->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->PERUJUK->Visible) { // PERUJUK ?>
    <tr id="r_PERUJUK">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_PERUJUK"><?= $Page->PERUJUK->caption() ?></span></td>
        <td data-name="PERUJUK" <?= $Page->PERUJUK->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_PERUJUK">
<span<?= $Page->PERUJUK->viewAttributes() ?>>
<?= $Page->PERUJUK->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->PERUJUKFEE->Visible) { // PERUJUKFEE ?>
    <tr id="r_PERUJUKFEE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_PERUJUKFEE"><?= $Page->PERUJUKFEE->caption() ?></span></td>
        <td data-name="PERUJUKFEE" <?= $Page->PERUJUKFEE->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_PERUJUKFEE">
<span<?= $Page->PERUJUKFEE->viewAttributes() ?>>
<?= $Page->PERUJUKFEE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->modified_datesys->Visible) { // modified_datesys ?>
    <tr id="r_modified_datesys">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_modified_datesys"><?= $Page->modified_datesys->caption() ?></span></td>
        <td data-name="modified_datesys" <?= $Page->modified_datesys->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_modified_datesys">
<span<?= $Page->modified_datesys->viewAttributes() ?>>
<?= $Page->modified_datesys->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->TRANS_ID->Visible) { // TRANS_ID ?>
    <tr id="r_TRANS_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_TRANS_ID"><?= $Page->TRANS_ID->caption() ?></span></td>
        <td data-name="TRANS_ID" <?= $Page->TRANS_ID->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_TRANS_ID">
<span<?= $Page->TRANS_ID->viewAttributes() ?>>
<?= $Page->TRANS_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->SPPBILLDATE->Visible) { // SPPBILLDATE ?>
    <tr id="r_SPPBILLDATE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_SPPBILLDATE"><?= $Page->SPPBILLDATE->caption() ?></span></td>
        <td data-name="SPPBILLDATE" <?= $Page->SPPBILLDATE->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_SPPBILLDATE">
<span<?= $Page->SPPBILLDATE->viewAttributes() ?>>
<?= $Page->SPPBILLDATE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->SPPBILLUSER->Visible) { // SPPBILLUSER ?>
    <tr id="r_SPPBILLUSER">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_SPPBILLUSER"><?= $Page->SPPBILLUSER->caption() ?></span></td>
        <td data-name="SPPBILLUSER" <?= $Page->SPPBILLUSER->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_SPPBILLUSER">
<span<?= $Page->SPPBILLUSER->viewAttributes() ?>>
<?= $Page->SPPBILLUSER->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->SPPKASIRDATE->Visible) { // SPPKASIRDATE ?>
    <tr id="r_SPPKASIRDATE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_SPPKASIRDATE"><?= $Page->SPPKASIRDATE->caption() ?></span></td>
        <td data-name="SPPKASIRDATE" <?= $Page->SPPKASIRDATE->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_SPPKASIRDATE">
<span<?= $Page->SPPKASIRDATE->viewAttributes() ?>>
<?= $Page->SPPKASIRDATE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->SPPKASIRUSER->Visible) { // SPPKASIRUSER ?>
    <tr id="r_SPPKASIRUSER">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_SPPKASIRUSER"><?= $Page->SPPKASIRUSER->caption() ?></span></td>
        <td data-name="SPPKASIRUSER" <?= $Page->SPPKASIRUSER->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_SPPKASIRUSER">
<span<?= $Page->SPPKASIRUSER->viewAttributes() ?>>
<?= $Page->SPPKASIRUSER->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->SPPPOLI->Visible) { // SPPPOLI ?>
    <tr id="r_SPPPOLI">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_SPPPOLI"><?= $Page->SPPPOLI->caption() ?></span></td>
        <td data-name="SPPPOLI" <?= $Page->SPPPOLI->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_SPPPOLI">
<span<?= $Page->SPPPOLI->viewAttributes() ?>>
<?= $Page->SPPPOLI->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->SPPPOLIUSER->Visible) { // SPPPOLIUSER ?>
    <tr id="r_SPPPOLIUSER">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_SPPPOLIUSER"><?= $Page->SPPPOLIUSER->caption() ?></span></td>
        <td data-name="SPPPOLIUSER" <?= $Page->SPPPOLIUSER->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_SPPPOLIUSER">
<span<?= $Page->SPPPOLIUSER->viewAttributes() ?>>
<?= $Page->SPPPOLIUSER->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->SPPPOLIDATE->Visible) { // SPPPOLIDATE ?>
    <tr id="r_SPPPOLIDATE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_SPPPOLIDATE"><?= $Page->SPPPOLIDATE->caption() ?></span></td>
        <td data-name="SPPPOLIDATE" <?= $Page->SPPPOLIDATE->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_SPPPOLIDATE">
<span<?= $Page->SPPPOLIDATE->viewAttributes() ?>>
<?= $Page->SPPPOLIDATE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ID->Visible) { // ID ?>
    <tr id="r_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TREATMENT_BAYAR_ID"><?= $Page->ID->caption() ?></span></td>
        <td data-name="ID" <?= $Page->ID->cellAttributes() ?>>
<span id="el_TREATMENT_BAYAR_ID">
<span<?= $Page->ID->viewAttributes() ?>>
<?= $Page->ID->getViewValue() ?></span>
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
