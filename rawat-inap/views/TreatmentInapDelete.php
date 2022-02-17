<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

// Page object
$TreatmentInapDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fTREATMENT_INAPdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fTREATMENT_INAPdelete = currentForm = new ew.Form("fTREATMENT_INAPdelete", "delete");
    loadjs.done("fTREATMENT_INAPdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.TREATMENT_INAP) ew.vars.tables.TREATMENT_INAP = <?= JsonEncode(GetClientVar("tables", "TREATMENT_INAP")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fTREATMENT_INAPdelete" id="fTREATMENT_INAPdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="TREATMENT_INAP">
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
<?php if ($Page->NO_REGISTRATION->Visible) { // NO_REGISTRATION ?>
        <th class="<?= $Page->NO_REGISTRATION->headerCellClass() ?>"><span id="elh_TREATMENT_INAP_NO_REGISTRATION" class="TREATMENT_INAP_NO_REGISTRATION"><?= $Page->NO_REGISTRATION->caption() ?></span></th>
<?php } ?>
<?php if ($Page->VISIT_ID->Visible) { // VISIT_ID ?>
        <th class="<?= $Page->VISIT_ID->headerCellClass() ?>"><span id="elh_TREATMENT_INAP_VISIT_ID" class="TREATMENT_INAP_VISIT_ID"><?= $Page->VISIT_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->TARIF_ID->Visible) { // TARIF_ID ?>
        <th class="<?= $Page->TARIF_ID->headerCellClass() ?>"><span id="elh_TREATMENT_INAP_TARIF_ID" class="TREATMENT_INAP_TARIF_ID"><?= $Page->TARIF_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->CLINIC_ID->Visible) { // CLINIC_ID ?>
        <th class="<?= $Page->CLINIC_ID->headerCellClass() ?>"><span id="elh_TREATMENT_INAP_CLINIC_ID" class="TREATMENT_INAP_CLINIC_ID"><?= $Page->CLINIC_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->TREATMENT->Visible) { // TREATMENT ?>
        <th class="<?= $Page->TREATMENT->headerCellClass() ?>"><span id="elh_TREATMENT_INAP_TREATMENT" class="TREATMENT_INAP_TREATMENT"><?= $Page->TREATMENT->caption() ?></span></th>
<?php } ?>
<?php if ($Page->TREAT_DATE->Visible) { // TREAT_DATE ?>
        <th class="<?= $Page->TREAT_DATE->headerCellClass() ?>"><span id="elh_TREATMENT_INAP_TREAT_DATE" class="TREATMENT_INAP_TREAT_DATE"><?= $Page->TREAT_DATE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->QUANTITY->Visible) { // QUANTITY ?>
        <th class="<?= $Page->QUANTITY->headerCellClass() ?>"><span id="elh_TREATMENT_INAP_QUANTITY" class="TREATMENT_INAP_QUANTITY"><?= $Page->QUANTITY->caption() ?></span></th>
<?php } ?>
<?php if ($Page->TRANS_ID->Visible) { // TRANS_ID ?>
        <th class="<?= $Page->TRANS_ID->headerCellClass() ?>"><span id="elh_TREATMENT_INAP_TRANS_ID" class="TREATMENT_INAP_TRANS_ID"><?= $Page->TRANS_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ID->Visible) { // ID ?>
        <th class="<?= $Page->ID->headerCellClass() ?>"><span id="elh_TREATMENT_INAP_ID" class="TREATMENT_INAP_ID"><?= $Page->ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->AMOUNT->Visible) { // AMOUNT ?>
        <th class="<?= $Page->AMOUNT->headerCellClass() ?>"><span id="elh_TREATMENT_INAP_AMOUNT" class="TREATMENT_INAP_AMOUNT"><?= $Page->AMOUNT->caption() ?></span></th>
<?php } ?>
<?php if ($Page->POKOK_JUAL->Visible) { // POKOK_JUAL ?>
        <th class="<?= $Page->POKOK_JUAL->headerCellClass() ?>"><span id="elh_TREATMENT_INAP_POKOK_JUAL" class="TREATMENT_INAP_POKOK_JUAL"><?= $Page->POKOK_JUAL->caption() ?></span></th>
<?php } ?>
<?php if ($Page->PPN->Visible) { // PPN ?>
        <th class="<?= $Page->PPN->headerCellClass() ?>"><span id="elh_TREATMENT_INAP_PPN" class="TREATMENT_INAP_PPN"><?= $Page->PPN->caption() ?></span></th>
<?php } ?>
<?php if ($Page->SUBSIDI->Visible) { // SUBSIDI ?>
        <th class="<?= $Page->SUBSIDI->headerCellClass() ?>"><span id="elh_TREATMENT_INAP_SUBSIDI" class="TREATMENT_INAP_SUBSIDI"><?= $Page->SUBSIDI->caption() ?></span></th>
<?php } ?>
<?php if ($Page->PRINT_DATE->Visible) { // PRINT_DATE ?>
        <th class="<?= $Page->PRINT_DATE->headerCellClass() ?>"><span id="elh_TREATMENT_INAP_PRINT_DATE" class="TREATMENT_INAP_PRINT_DATE"><?= $Page->PRINT_DATE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ISCETAK->Visible) { // ISCETAK ?>
        <th class="<?= $Page->ISCETAK->headerCellClass() ?>"><span id="elh_TREATMENT_INAP_ISCETAK" class="TREATMENT_INAP_ISCETAK"><?= $Page->ISCETAK->caption() ?></span></th>
<?php } ?>
<?php if ($Page->NOTA_NO->Visible) { // NOTA_NO ?>
        <th class="<?= $Page->NOTA_NO->headerCellClass() ?>"><span id="elh_TREATMENT_INAP_NOTA_NO" class="TREATMENT_INAP_NOTA_NO"><?= $Page->NOTA_NO->caption() ?></span></th>
<?php } ?>
<?php if ($Page->KUITANSI_ID->Visible) { // KUITANSI_ID ?>
        <th class="<?= $Page->KUITANSI_ID->headerCellClass() ?>"><span id="elh_TREATMENT_INAP_KUITANSI_ID" class="TREATMENT_INAP_KUITANSI_ID"><?= $Page->KUITANSI_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->amount_paid->Visible) { // amount_paid ?>
        <th class="<?= $Page->amount_paid->headerCellClass() ?>"><span id="elh_TREATMENT_INAP_amount_paid" class="TREATMENT_INAP_amount_paid"><?= $Page->amount_paid->caption() ?></span></th>
<?php } ?>
<?php if ($Page->sell_price->Visible) { // sell_price ?>
        <th class="<?= $Page->sell_price->headerCellClass() ?>"><span id="elh_TREATMENT_INAP_sell_price" class="TREATMENT_INAP_sell_price"><?= $Page->sell_price->caption() ?></span></th>
<?php } ?>
<?php if ($Page->diskon->Visible) { // diskon ?>
        <th class="<?= $Page->diskon->headerCellClass() ?>"><span id="elh_TREATMENT_INAP_diskon" class="TREATMENT_INAP_diskon"><?= $Page->diskon->caption() ?></span></th>
<?php } ?>
<?php if ($Page->TAGIHAN->Visible) { // TAGIHAN ?>
        <th class="<?= $Page->TAGIHAN->headerCellClass() ?>"><span id="elh_TREATMENT_INAP_TAGIHAN" class="TREATMENT_INAP_TAGIHAN"><?= $Page->TAGIHAN->caption() ?></span></th>
<?php } ?>
<?php if ($Page->CLINIC_TYPE->Visible) { // CLINIC_TYPE ?>
        <th class="<?= $Page->CLINIC_TYPE->headerCellClass() ?>"><span id="elh_TREATMENT_INAP_CLINIC_TYPE" class="TREATMENT_INAP_CLINIC_TYPE"><?= $Page->CLINIC_TYPE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ID_1->Visible) { // ID_1 ?>
        <th class="<?= $Page->ID_1->headerCellClass() ?>"><span id="elh_TREATMENT_INAP_ID_1" class="TREATMENT_INAP_ID_1"><?= $Page->ID_1->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ORG_UNIT_CODE->Visible) { // ORG_UNIT_CODE ?>
        <th class="<?= $Page->ORG_UNIT_CODE->headerCellClass() ?>"><span id="elh_TREATMENT_INAP_ORG_UNIT_CODE" class="TREATMENT_INAP_ORG_UNIT_CODE"><?= $Page->ORG_UNIT_CODE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->BILL_ID_1->Visible) { // BILL_ID_1 ?>
        <th class="<?= $Page->BILL_ID_1->headerCellClass() ?>"><span id="elh_TREATMENT_INAP_BILL_ID_1" class="TREATMENT_INAP_BILL_ID_1"><?= $Page->BILL_ID_1->caption() ?></span></th>
<?php } ?>
<?php if ($Page->NO_REGISTRATION_1->Visible) { // NO_REGISTRATION_1 ?>
        <th class="<?= $Page->NO_REGISTRATION_1->headerCellClass() ?>"><span id="elh_TREATMENT_INAP_NO_REGISTRATION_1" class="TREATMENT_INAP_NO_REGISTRATION_1"><?= $Page->NO_REGISTRATION_1->caption() ?></span></th>
<?php } ?>
<?php if ($Page->VISIT_ID_1->Visible) { // VISIT_ID_1 ?>
        <th class="<?= $Page->VISIT_ID_1->headerCellClass() ?>"><span id="elh_TREATMENT_INAP_VISIT_ID_1" class="TREATMENT_INAP_VISIT_ID_1"><?= $Page->VISIT_ID_1->caption() ?></span></th>
<?php } ?>
<?php if ($Page->TARIF_ID_1->Visible) { // TARIF_ID_1 ?>
        <th class="<?= $Page->TARIF_ID_1->headerCellClass() ?>"><span id="elh_TREATMENT_INAP_TARIF_ID_1" class="TREATMENT_INAP_TARIF_ID_1"><?= $Page->TARIF_ID_1->caption() ?></span></th>
<?php } ?>
<?php if ($Page->CLASS_ID_1->Visible) { // CLASS_ID_1 ?>
        <th class="<?= $Page->CLASS_ID_1->headerCellClass() ?>"><span id="elh_TREATMENT_INAP_CLASS_ID_1" class="TREATMENT_INAP_CLASS_ID_1"><?= $Page->CLASS_ID_1->caption() ?></span></th>
<?php } ?>
<?php if ($Page->CLINIC_ID_1->Visible) { // CLINIC_ID_1 ?>
        <th class="<?= $Page->CLINIC_ID_1->headerCellClass() ?>"><span id="elh_TREATMENT_INAP_CLINIC_ID_1" class="TREATMENT_INAP_CLINIC_ID_1"><?= $Page->CLINIC_ID_1->caption() ?></span></th>
<?php } ?>
<?php if ($Page->CLINIC_ID_FROM_1->Visible) { // CLINIC_ID_FROM_1 ?>
        <th class="<?= $Page->CLINIC_ID_FROM_1->headerCellClass() ?>"><span id="elh_TREATMENT_INAP_CLINIC_ID_FROM_1" class="TREATMENT_INAP_CLINIC_ID_FROM_1"><?= $Page->CLINIC_ID_FROM_1->caption() ?></span></th>
<?php } ?>
<?php if ($Page->TREATMENT_1->Visible) { // TREATMENT_1 ?>
        <th class="<?= $Page->TREATMENT_1->headerCellClass() ?>"><span id="elh_TREATMENT_INAP_TREATMENT_1" class="TREATMENT_INAP_TREATMENT_1"><?= $Page->TREATMENT_1->caption() ?></span></th>
<?php } ?>
<?php if ($Page->TREAT_DATE_1->Visible) { // TREAT_DATE_1 ?>
        <th class="<?= $Page->TREAT_DATE_1->headerCellClass() ?>"><span id="elh_TREATMENT_INAP_TREAT_DATE_1" class="TREATMENT_INAP_TREAT_DATE_1"><?= $Page->TREAT_DATE_1->caption() ?></span></th>
<?php } ?>
<?php if ($Page->QUANTITY_1->Visible) { // QUANTITY_1 ?>
        <th class="<?= $Page->QUANTITY_1->headerCellClass() ?>"><span id="elh_TREATMENT_INAP_QUANTITY_1" class="TREATMENT_INAP_QUANTITY_1"><?= $Page->QUANTITY_1->caption() ?></span></th>
<?php } ?>
<?php if ($Page->MEASURE_ID->Visible) { // MEASURE_ID ?>
        <th class="<?= $Page->MEASURE_ID->headerCellClass() ?>"><span id="elh_TREATMENT_INAP_MEASURE_ID" class="TREATMENT_INAP_MEASURE_ID"><?= $Page->MEASURE_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->MEASURE_ID_1->Visible) { // MEASURE_ID_1 ?>
        <th class="<?= $Page->MEASURE_ID_1->headerCellClass() ?>"><span id="elh_TREATMENT_INAP_MEASURE_ID_1" class="TREATMENT_INAP_MEASURE_ID_1"><?= $Page->MEASURE_ID_1->caption() ?></span></th>
<?php } ?>
<?php if ($Page->TRANS_ID_1->Visible) { // TRANS_ID_1 ?>
        <th class="<?= $Page->TRANS_ID_1->headerCellClass() ?>"><span id="elh_TREATMENT_INAP_TRANS_ID_1" class="TREATMENT_INAP_TRANS_ID_1"><?= $Page->TRANS_ID_1->caption() ?></span></th>
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
<?php if ($Page->NO_REGISTRATION->Visible) { // NO_REGISTRATION ?>
        <td <?= $Page->NO_REGISTRATION->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_NO_REGISTRATION" class="TREATMENT_INAP_NO_REGISTRATION">
<span<?= $Page->NO_REGISTRATION->viewAttributes() ?>>
<?= $Page->NO_REGISTRATION->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->VISIT_ID->Visible) { // VISIT_ID ?>
        <td <?= $Page->VISIT_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_VISIT_ID" class="TREATMENT_INAP_VISIT_ID">
<span<?= $Page->VISIT_ID->viewAttributes() ?>>
<?= $Page->VISIT_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->TARIF_ID->Visible) { // TARIF_ID ?>
        <td <?= $Page->TARIF_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_TARIF_ID" class="TREATMENT_INAP_TARIF_ID">
<span<?= $Page->TARIF_ID->viewAttributes() ?>>
<?= $Page->TARIF_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->CLINIC_ID->Visible) { // CLINIC_ID ?>
        <td <?= $Page->CLINIC_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_CLINIC_ID" class="TREATMENT_INAP_CLINIC_ID">
<span<?= $Page->CLINIC_ID->viewAttributes() ?>>
<?= $Page->CLINIC_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->TREATMENT->Visible) { // TREATMENT ?>
        <td <?= $Page->TREATMENT->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_TREATMENT" class="TREATMENT_INAP_TREATMENT">
<span<?= $Page->TREATMENT->viewAttributes() ?>>
<?= $Page->TREATMENT->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->TREAT_DATE->Visible) { // TREAT_DATE ?>
        <td <?= $Page->TREAT_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_TREAT_DATE" class="TREATMENT_INAP_TREAT_DATE">
<span<?= $Page->TREAT_DATE->viewAttributes() ?>>
<?= $Page->TREAT_DATE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->QUANTITY->Visible) { // QUANTITY ?>
        <td <?= $Page->QUANTITY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_QUANTITY" class="TREATMENT_INAP_QUANTITY">
<span<?= $Page->QUANTITY->viewAttributes() ?>>
<?= $Page->QUANTITY->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->TRANS_ID->Visible) { // TRANS_ID ?>
        <td <?= $Page->TRANS_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_TRANS_ID" class="TREATMENT_INAP_TRANS_ID">
<span<?= $Page->TRANS_ID->viewAttributes() ?>>
<?= $Page->TRANS_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ID->Visible) { // ID ?>
        <td <?= $Page->ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_ID" class="TREATMENT_INAP_ID">
<span<?= $Page->ID->viewAttributes() ?>>
<?= $Page->ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->AMOUNT->Visible) { // AMOUNT ?>
        <td <?= $Page->AMOUNT->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_AMOUNT" class="TREATMENT_INAP_AMOUNT">
<span<?= $Page->AMOUNT->viewAttributes() ?>>
<?= $Page->AMOUNT->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->POKOK_JUAL->Visible) { // POKOK_JUAL ?>
        <td <?= $Page->POKOK_JUAL->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_POKOK_JUAL" class="TREATMENT_INAP_POKOK_JUAL">
<span<?= $Page->POKOK_JUAL->viewAttributes() ?>>
<?= $Page->POKOK_JUAL->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->PPN->Visible) { // PPN ?>
        <td <?= $Page->PPN->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_PPN" class="TREATMENT_INAP_PPN">
<span<?= $Page->PPN->viewAttributes() ?>>
<?= $Page->PPN->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->SUBSIDI->Visible) { // SUBSIDI ?>
        <td <?= $Page->SUBSIDI->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_SUBSIDI" class="TREATMENT_INAP_SUBSIDI">
<span<?= $Page->SUBSIDI->viewAttributes() ?>>
<?= $Page->SUBSIDI->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->PRINT_DATE->Visible) { // PRINT_DATE ?>
        <td <?= $Page->PRINT_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_PRINT_DATE" class="TREATMENT_INAP_PRINT_DATE">
<span<?= $Page->PRINT_DATE->viewAttributes() ?>>
<?= $Page->PRINT_DATE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ISCETAK->Visible) { // ISCETAK ?>
        <td <?= $Page->ISCETAK->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_ISCETAK" class="TREATMENT_INAP_ISCETAK">
<span<?= $Page->ISCETAK->viewAttributes() ?>>
<?= $Page->ISCETAK->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->NOTA_NO->Visible) { // NOTA_NO ?>
        <td <?= $Page->NOTA_NO->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_NOTA_NO" class="TREATMENT_INAP_NOTA_NO">
<span<?= $Page->NOTA_NO->viewAttributes() ?>>
<?= $Page->NOTA_NO->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->KUITANSI_ID->Visible) { // KUITANSI_ID ?>
        <td <?= $Page->KUITANSI_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_KUITANSI_ID" class="TREATMENT_INAP_KUITANSI_ID">
<span<?= $Page->KUITANSI_ID->viewAttributes() ?>>
<?= $Page->KUITANSI_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->amount_paid->Visible) { // amount_paid ?>
        <td <?= $Page->amount_paid->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_amount_paid" class="TREATMENT_INAP_amount_paid">
<span<?= $Page->amount_paid->viewAttributes() ?>>
<?= $Page->amount_paid->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->sell_price->Visible) { // sell_price ?>
        <td <?= $Page->sell_price->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_sell_price" class="TREATMENT_INAP_sell_price">
<span<?= $Page->sell_price->viewAttributes() ?>>
<?= $Page->sell_price->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->diskon->Visible) { // diskon ?>
        <td <?= $Page->diskon->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_diskon" class="TREATMENT_INAP_diskon">
<span<?= $Page->diskon->viewAttributes() ?>>
<?= $Page->diskon->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->TAGIHAN->Visible) { // TAGIHAN ?>
        <td <?= $Page->TAGIHAN->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_TAGIHAN" class="TREATMENT_INAP_TAGIHAN">
<span<?= $Page->TAGIHAN->viewAttributes() ?>>
<?= $Page->TAGIHAN->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->CLINIC_TYPE->Visible) { // CLINIC_TYPE ?>
        <td <?= $Page->CLINIC_TYPE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_CLINIC_TYPE" class="TREATMENT_INAP_CLINIC_TYPE">
<span<?= $Page->CLINIC_TYPE->viewAttributes() ?>>
<?= $Page->CLINIC_TYPE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ID_1->Visible) { // ID_1 ?>
        <td <?= $Page->ID_1->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_ID_1" class="TREATMENT_INAP_ID_1">
<span<?= $Page->ID_1->viewAttributes() ?>>
<?= $Page->ID_1->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ORG_UNIT_CODE->Visible) { // ORG_UNIT_CODE ?>
        <td <?= $Page->ORG_UNIT_CODE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_ORG_UNIT_CODE" class="TREATMENT_INAP_ORG_UNIT_CODE">
<span<?= $Page->ORG_UNIT_CODE->viewAttributes() ?>>
<?= $Page->ORG_UNIT_CODE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->BILL_ID_1->Visible) { // BILL_ID_1 ?>
        <td <?= $Page->BILL_ID_1->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_BILL_ID_1" class="TREATMENT_INAP_BILL_ID_1">
<span<?= $Page->BILL_ID_1->viewAttributes() ?>>
<?= $Page->BILL_ID_1->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->NO_REGISTRATION_1->Visible) { // NO_REGISTRATION_1 ?>
        <td <?= $Page->NO_REGISTRATION_1->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_NO_REGISTRATION_1" class="TREATMENT_INAP_NO_REGISTRATION_1">
<span<?= $Page->NO_REGISTRATION_1->viewAttributes() ?>>
<?= $Page->NO_REGISTRATION_1->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->VISIT_ID_1->Visible) { // VISIT_ID_1 ?>
        <td <?= $Page->VISIT_ID_1->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_VISIT_ID_1" class="TREATMENT_INAP_VISIT_ID_1">
<span<?= $Page->VISIT_ID_1->viewAttributes() ?>>
<?= $Page->VISIT_ID_1->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->TARIF_ID_1->Visible) { // TARIF_ID_1 ?>
        <td <?= $Page->TARIF_ID_1->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_TARIF_ID_1" class="TREATMENT_INAP_TARIF_ID_1">
<span<?= $Page->TARIF_ID_1->viewAttributes() ?>>
<?= $Page->TARIF_ID_1->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->CLASS_ID_1->Visible) { // CLASS_ID_1 ?>
        <td <?= $Page->CLASS_ID_1->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_CLASS_ID_1" class="TREATMENT_INAP_CLASS_ID_1">
<span<?= $Page->CLASS_ID_1->viewAttributes() ?>>
<?= $Page->CLASS_ID_1->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->CLINIC_ID_1->Visible) { // CLINIC_ID_1 ?>
        <td <?= $Page->CLINIC_ID_1->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_CLINIC_ID_1" class="TREATMENT_INAP_CLINIC_ID_1">
<span<?= $Page->CLINIC_ID_1->viewAttributes() ?>>
<?= $Page->CLINIC_ID_1->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->CLINIC_ID_FROM_1->Visible) { // CLINIC_ID_FROM_1 ?>
        <td <?= $Page->CLINIC_ID_FROM_1->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_CLINIC_ID_FROM_1" class="TREATMENT_INAP_CLINIC_ID_FROM_1">
<span<?= $Page->CLINIC_ID_FROM_1->viewAttributes() ?>>
<?= $Page->CLINIC_ID_FROM_1->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->TREATMENT_1->Visible) { // TREATMENT_1 ?>
        <td <?= $Page->TREATMENT_1->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_TREATMENT_1" class="TREATMENT_INAP_TREATMENT_1">
<span<?= $Page->TREATMENT_1->viewAttributes() ?>>
<?= $Page->TREATMENT_1->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->TREAT_DATE_1->Visible) { // TREAT_DATE_1 ?>
        <td <?= $Page->TREAT_DATE_1->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_TREAT_DATE_1" class="TREATMENT_INAP_TREAT_DATE_1">
<span<?= $Page->TREAT_DATE_1->viewAttributes() ?>>
<?= $Page->TREAT_DATE_1->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->QUANTITY_1->Visible) { // QUANTITY_1 ?>
        <td <?= $Page->QUANTITY_1->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_QUANTITY_1" class="TREATMENT_INAP_QUANTITY_1">
<span<?= $Page->QUANTITY_1->viewAttributes() ?>>
<?= $Page->QUANTITY_1->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->MEASURE_ID->Visible) { // MEASURE_ID ?>
        <td <?= $Page->MEASURE_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_MEASURE_ID" class="TREATMENT_INAP_MEASURE_ID">
<span<?= $Page->MEASURE_ID->viewAttributes() ?>>
<?= $Page->MEASURE_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->MEASURE_ID_1->Visible) { // MEASURE_ID_1 ?>
        <td <?= $Page->MEASURE_ID_1->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_MEASURE_ID_1" class="TREATMENT_INAP_MEASURE_ID_1">
<span<?= $Page->MEASURE_ID_1->viewAttributes() ?>>
<?= $Page->MEASURE_ID_1->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->TRANS_ID_1->Visible) { // TRANS_ID_1 ?>
        <td <?= $Page->TRANS_ID_1->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_TRANS_ID_1" class="TREATMENT_INAP_TRANS_ID_1">
<span<?= $Page->TRANS_ID_1->viewAttributes() ?>>
<?= $Page->TRANS_ID_1->getViewValue() ?></span>
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
