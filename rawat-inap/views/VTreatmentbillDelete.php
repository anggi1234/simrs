<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

// Page object
$VTreatmentbillDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fV_TREATMENTBILLdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fV_TREATMENTBILLdelete = currentForm = new ew.Form("fV_TREATMENTBILLdelete", "delete");
    loadjs.done("fV_TREATMENTBILLdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.V_TREATMENTBILL) ew.vars.tables.V_TREATMENTBILL = <?= JsonEncode(GetClientVar("tables", "V_TREATMENTBILL")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fV_TREATMENTBILLdelete" id="fV_TREATMENTBILLdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="V_TREATMENTBILL">
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
<?php if ($Page->NAME_OF_PASIEN->Visible) { // NAME_OF_PASIEN ?>
        <th class="<?= $Page->NAME_OF_PASIEN->headerCellClass() ?>"><span id="elh_V_TREATMENTBILL_NAME_OF_PASIEN" class="V_TREATMENTBILL_NAME_OF_PASIEN"><?= $Page->NAME_OF_PASIEN->caption() ?></span></th>
<?php } ?>
<?php if ($Page->date_of_birth->Visible) { // date_of_birth ?>
        <th class="<?= $Page->date_of_birth->headerCellClass() ?>"><span id="elh_V_TREATMENTBILL_date_of_birth" class="V_TREATMENTBILL_date_of_birth"><?= $Page->date_of_birth->caption() ?></span></th>
<?php } ?>
<?php if ($Page->CONTACT_ADDRESS->Visible) { // CONTACT_ADDRESS ?>
        <th class="<?= $Page->CONTACT_ADDRESS->headerCellClass() ?>"><span id="elh_V_TREATMENTBILL_CONTACT_ADDRESS" class="V_TREATMENTBILL_CONTACT_ADDRESS"><?= $Page->CONTACT_ADDRESS->caption() ?></span></th>
<?php } ?>
<?php if ($Page->PHONE_NUMBER->Visible) { // PHONE_NUMBER ?>
        <th class="<?= $Page->PHONE_NUMBER->headerCellClass() ?>"><span id="elh_V_TREATMENTBILL_PHONE_NUMBER" class="V_TREATMENTBILL_PHONE_NUMBER"><?= $Page->PHONE_NUMBER->caption() ?></span></th>
<?php } ?>
<?php if ($Page->MOBILE->Visible) { // MOBILE ?>
        <th class="<?= $Page->MOBILE->headerCellClass() ?>"><span id="elh_V_TREATMENTBILL_MOBILE" class="V_TREATMENTBILL_MOBILE"><?= $Page->MOBILE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->PLACE_OF_BIRTH->Visible) { // PLACE_OF_BIRTH ?>
        <th class="<?= $Page->PLACE_OF_BIRTH->headerCellClass() ?>"><span id="elh_V_TREATMENTBILL_PLACE_OF_BIRTH" class="V_TREATMENTBILL_PLACE_OF_BIRTH"><?= $Page->PLACE_OF_BIRTH->caption() ?></span></th>
<?php } ?>
<?php if ($Page->KALURAHAN->Visible) { // KALURAHAN ?>
        <th class="<?= $Page->KALURAHAN->headerCellClass() ?>"><span id="elh_V_TREATMENTBILL_KALURAHAN" class="V_TREATMENTBILL_KALURAHAN"><?= $Page->KALURAHAN->caption() ?></span></th>
<?php } ?>
<?php if ($Page->name_of_clinic->Visible) { // name_of_clinic ?>
        <th class="<?= $Page->name_of_clinic->headerCellClass() ?>"><span id="elh_V_TREATMENTBILL_name_of_clinic" class="V_TREATMENTBILL_name_of_clinic"><?= $Page->name_of_clinic->caption() ?></span></th>
<?php } ?>
<?php if ($Page->booked_Date->Visible) { // booked_Date ?>
        <th class="<?= $Page->booked_Date->headerCellClass() ?>"><span id="elh_V_TREATMENTBILL_booked_Date" class="V_TREATMENTBILL_booked_Date"><?= $Page->booked_Date->caption() ?></span></th>
<?php } ?>
<?php if ($Page->visit_date->Visible) { // visit_date ?>
        <th class="<?= $Page->visit_date->headerCellClass() ?>"><span id="elh_V_TREATMENTBILL_visit_date" class="V_TREATMENTBILL_visit_date"><?= $Page->visit_date->caption() ?></span></th>
<?php } ?>
<?php if ($Page->visit_id->Visible) { // visit_id ?>
        <th class="<?= $Page->visit_id->headerCellClass() ?>"><span id="elh_V_TREATMENTBILL_visit_id" class="V_TREATMENTBILL_visit_id"><?= $Page->visit_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->isattended->Visible) { // isattended ?>
        <th class="<?= $Page->isattended->headerCellClass() ?>"><span id="elh_V_TREATMENTBILL_isattended" class="V_TREATMENTBILL_isattended"><?= $Page->isattended->caption() ?></span></th>
<?php } ?>
<?php if ($Page->diantar_oleh->Visible) { // diantar_oleh ?>
        <th class="<?= $Page->diantar_oleh->headerCellClass() ?>"><span id="elh_V_TREATMENTBILL_diantar_oleh" class="V_TREATMENTBILL_diantar_oleh"><?= $Page->diantar_oleh->caption() ?></span></th>
<?php } ?>
<?php if ($Page->visitor_address->Visible) { // visitor_address ?>
        <th class="<?= $Page->visitor_address->headerCellClass() ?>"><span id="elh_V_TREATMENTBILL_visitor_address" class="V_TREATMENTBILL_visitor_address"><?= $Page->visitor_address->caption() ?></span></th>
<?php } ?>
<?php if ($Page->address_of_rujukan->Visible) { // address_of_rujukan ?>
        <th class="<?= $Page->address_of_rujukan->headerCellClass() ?>"><span id="elh_V_TREATMENTBILL_address_of_rujukan" class="V_TREATMENTBILL_address_of_rujukan"><?= $Page->address_of_rujukan->caption() ?></span></th>
<?php } ?>
<?php if ($Page->rujukan_id->Visible) { // rujukan_id ?>
        <th class="<?= $Page->rujukan_id->headerCellClass() ?>"><span id="elh_V_TREATMENTBILL_rujukan_id" class="V_TREATMENTBILL_rujukan_id"><?= $Page->rujukan_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->patient_category_id->Visible) { // patient_category_id ?>
        <th class="<?= $Page->patient_category_id->headerCellClass() ?>"><span id="elh_V_TREATMENTBILL_patient_category_id" class="V_TREATMENTBILL_patient_category_id"><?= $Page->patient_category_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->payor_id->Visible) { // payor_id ?>
        <th class="<?= $Page->payor_id->headerCellClass() ?>"><span id="elh_V_TREATMENTBILL_payor_id" class="V_TREATMENTBILL_payor_id"><?= $Page->payor_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->reason_id->Visible) { // reason_id ?>
        <th class="<?= $Page->reason_id->headerCellClass() ?>"><span id="elh_V_TREATMENTBILL_reason_id" class="V_TREATMENTBILL_reason_id"><?= $Page->reason_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->way_id->Visible) { // way_id ?>
        <th class="<?= $Page->way_id->headerCellClass() ?>"><span id="elh_V_TREATMENTBILL_way_id" class="V_TREATMENTBILL_way_id"><?= $Page->way_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->follow_up->Visible) { // follow_up ?>
        <th class="<?= $Page->follow_up->headerCellClass() ?>"><span id="elh_V_TREATMENTBILL_follow_up" class="V_TREATMENTBILL_follow_up"><?= $Page->follow_up->caption() ?></span></th>
<?php } ?>
<?php if ($Page->isnew->Visible) { // isnew ?>
        <th class="<?= $Page->isnew->headerCellClass() ?>"><span id="elh_V_TREATMENTBILL_isnew" class="V_TREATMENTBILL_isnew"><?= $Page->isnew->caption() ?></span></th>
<?php } ?>
<?php if ($Page->family_status_id->Visible) { // family_status_id ?>
        <th class="<?= $Page->family_status_id->headerCellClass() ?>"><span id="elh_V_TREATMENTBILL_family_status_id" class="V_TREATMENTBILL_family_status_id"><?= $Page->family_status_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->class_room_id->Visible) { // class_room_id ?>
        <th class="<?= $Page->class_room_id->headerCellClass() ?>"><span id="elh_V_TREATMENTBILL_class_room_id" class="V_TREATMENTBILL_class_room_id"><?= $Page->class_room_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->STATUS_PASIEN_ID->Visible) { // STATUS_PASIEN_ID ?>
        <th class="<?= $Page->STATUS_PASIEN_ID->headerCellClass() ?>"><span id="elh_V_TREATMENTBILL_STATUS_PASIEN_ID" class="V_TREATMENTBILL_STATUS_PASIEN_ID"><?= $Page->STATUS_PASIEN_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->fullname->Visible) { // fullname ?>
        <th class="<?= $Page->fullname->headerCellClass() ?>"><span id="elh_V_TREATMENTBILL_fullname" class="V_TREATMENTBILL_fullname"><?= $Page->fullname->caption() ?></span></th>
<?php } ?>
<?php if ($Page->employee_id->Visible) { // employee_id ?>
        <th class="<?= $Page->employee_id->headerCellClass() ?>"><span id="elh_V_TREATMENTBILL_employee_id" class="V_TREATMENTBILL_employee_id"><?= $Page->employee_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->employee_id_from->Visible) { // employee_id_from ?>
        <th class="<?= $Page->employee_id_from->headerCellClass() ?>"><span id="elh_V_TREATMENTBILL_employee_id_from" class="V_TREATMENTBILL_employee_id_from"><?= $Page->employee_id_from->caption() ?></span></th>
<?php } ?>
<?php if ($Page->clinic_id->Visible) { // clinic_id ?>
        <th class="<?= $Page->clinic_id->headerCellClass() ?>"><span id="elh_V_TREATMENTBILL_clinic_id" class="V_TREATMENTBILL_clinic_id"><?= $Page->clinic_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->clinic_id_FROM->Visible) { // clinic_id_FROM ?>
        <th class="<?= $Page->clinic_id_FROM->headerCellClass() ?>"><span id="elh_V_TREATMENTBILL_clinic_id_FROM" class="V_TREATMENTBILL_clinic_id_FROM"><?= $Page->clinic_id_FROM->caption() ?></span></th>
<?php } ?>
<?php if ($Page->doctor->Visible) { // doctor ?>
        <th class="<?= $Page->doctor->headerCellClass() ?>"><span id="elh_V_TREATMENTBILL_doctor" class="V_TREATMENTBILL_doctor"><?= $Page->doctor->caption() ?></span></th>
<?php } ?>
<?php if ($Page->bed_id->Visible) { // bed_id ?>
        <th class="<?= $Page->bed_id->headerCellClass() ?>"><span id="elh_V_TREATMENTBILL_bed_id" class="V_TREATMENTBILL_bed_id"><?= $Page->bed_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->keluar_id->Visible) { // keluar_id ?>
        <th class="<?= $Page->keluar_id->headerCellClass() ?>"><span id="elh_V_TREATMENTBILL_keluar_id" class="V_TREATMENTBILL_keluar_id"><?= $Page->keluar_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->treat_date->Visible) { // treat_date ?>
        <th class="<?= $Page->treat_date->headerCellClass() ?>"><span id="elh_V_TREATMENTBILL_treat_date" class="V_TREATMENTBILL_treat_date"><?= $Page->treat_date->caption() ?></span></th>
<?php } ?>
<?php if ($Page->exit_date->Visible) { // exit_date ?>
        <th class="<?= $Page->exit_date->headerCellClass() ?>"><span id="elh_V_TREATMENTBILL_exit_date" class="V_TREATMENTBILL_exit_date"><?= $Page->exit_date->caption() ?></span></th>
<?php } ?>
<?php if ($Page->name_of_class->Visible) { // name_of_class ?>
        <th class="<?= $Page->name_of_class->headerCellClass() ?>"><span id="elh_V_TREATMENTBILL_name_of_class" class="V_TREATMENTBILL_name_of_class"><?= $Page->name_of_class->caption() ?></span></th>
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
<?php if ($Page->NAME_OF_PASIEN->Visible) { // NAME_OF_PASIEN ?>
        <td <?= $Page->NAME_OF_PASIEN->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREATMENTBILL_NAME_OF_PASIEN" class="V_TREATMENTBILL_NAME_OF_PASIEN">
<span<?= $Page->NAME_OF_PASIEN->viewAttributes() ?>>
<?= $Page->NAME_OF_PASIEN->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->date_of_birth->Visible) { // date_of_birth ?>
        <td <?= $Page->date_of_birth->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREATMENTBILL_date_of_birth" class="V_TREATMENTBILL_date_of_birth">
<span<?= $Page->date_of_birth->viewAttributes() ?>>
<?= $Page->date_of_birth->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->CONTACT_ADDRESS->Visible) { // CONTACT_ADDRESS ?>
        <td <?= $Page->CONTACT_ADDRESS->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREATMENTBILL_CONTACT_ADDRESS" class="V_TREATMENTBILL_CONTACT_ADDRESS">
<span<?= $Page->CONTACT_ADDRESS->viewAttributes() ?>>
<?= $Page->CONTACT_ADDRESS->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->PHONE_NUMBER->Visible) { // PHONE_NUMBER ?>
        <td <?= $Page->PHONE_NUMBER->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREATMENTBILL_PHONE_NUMBER" class="V_TREATMENTBILL_PHONE_NUMBER">
<span<?= $Page->PHONE_NUMBER->viewAttributes() ?>>
<?= $Page->PHONE_NUMBER->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->MOBILE->Visible) { // MOBILE ?>
        <td <?= $Page->MOBILE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREATMENTBILL_MOBILE" class="V_TREATMENTBILL_MOBILE">
<span<?= $Page->MOBILE->viewAttributes() ?>>
<?= $Page->MOBILE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->PLACE_OF_BIRTH->Visible) { // PLACE_OF_BIRTH ?>
        <td <?= $Page->PLACE_OF_BIRTH->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREATMENTBILL_PLACE_OF_BIRTH" class="V_TREATMENTBILL_PLACE_OF_BIRTH">
<span<?= $Page->PLACE_OF_BIRTH->viewAttributes() ?>>
<?= $Page->PLACE_OF_BIRTH->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->KALURAHAN->Visible) { // KALURAHAN ?>
        <td <?= $Page->KALURAHAN->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREATMENTBILL_KALURAHAN" class="V_TREATMENTBILL_KALURAHAN">
<span<?= $Page->KALURAHAN->viewAttributes() ?>>
<?= $Page->KALURAHAN->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->name_of_clinic->Visible) { // name_of_clinic ?>
        <td <?= $Page->name_of_clinic->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREATMENTBILL_name_of_clinic" class="V_TREATMENTBILL_name_of_clinic">
<span<?= $Page->name_of_clinic->viewAttributes() ?>>
<?= $Page->name_of_clinic->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->booked_Date->Visible) { // booked_Date ?>
        <td <?= $Page->booked_Date->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREATMENTBILL_booked_Date" class="V_TREATMENTBILL_booked_Date">
<span<?= $Page->booked_Date->viewAttributes() ?>>
<?= $Page->booked_Date->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->visit_date->Visible) { // visit_date ?>
        <td <?= $Page->visit_date->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREATMENTBILL_visit_date" class="V_TREATMENTBILL_visit_date">
<span<?= $Page->visit_date->viewAttributes() ?>>
<?= $Page->visit_date->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->visit_id->Visible) { // visit_id ?>
        <td <?= $Page->visit_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREATMENTBILL_visit_id" class="V_TREATMENTBILL_visit_id">
<span<?= $Page->visit_id->viewAttributes() ?>>
<?= $Page->visit_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->isattended->Visible) { // isattended ?>
        <td <?= $Page->isattended->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREATMENTBILL_isattended" class="V_TREATMENTBILL_isattended">
<span<?= $Page->isattended->viewAttributes() ?>>
<?= $Page->isattended->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->diantar_oleh->Visible) { // diantar_oleh ?>
        <td <?= $Page->diantar_oleh->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREATMENTBILL_diantar_oleh" class="V_TREATMENTBILL_diantar_oleh">
<span<?= $Page->diantar_oleh->viewAttributes() ?>>
<?= $Page->diantar_oleh->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->visitor_address->Visible) { // visitor_address ?>
        <td <?= $Page->visitor_address->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREATMENTBILL_visitor_address" class="V_TREATMENTBILL_visitor_address">
<span<?= $Page->visitor_address->viewAttributes() ?>>
<?= $Page->visitor_address->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->address_of_rujukan->Visible) { // address_of_rujukan ?>
        <td <?= $Page->address_of_rujukan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREATMENTBILL_address_of_rujukan" class="V_TREATMENTBILL_address_of_rujukan">
<span<?= $Page->address_of_rujukan->viewAttributes() ?>>
<?= $Page->address_of_rujukan->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->rujukan_id->Visible) { // rujukan_id ?>
        <td <?= $Page->rujukan_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREATMENTBILL_rujukan_id" class="V_TREATMENTBILL_rujukan_id">
<span<?= $Page->rujukan_id->viewAttributes() ?>>
<?= $Page->rujukan_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->patient_category_id->Visible) { // patient_category_id ?>
        <td <?= $Page->patient_category_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREATMENTBILL_patient_category_id" class="V_TREATMENTBILL_patient_category_id">
<span<?= $Page->patient_category_id->viewAttributes() ?>>
<?= $Page->patient_category_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->payor_id->Visible) { // payor_id ?>
        <td <?= $Page->payor_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREATMENTBILL_payor_id" class="V_TREATMENTBILL_payor_id">
<span<?= $Page->payor_id->viewAttributes() ?>>
<?= $Page->payor_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->reason_id->Visible) { // reason_id ?>
        <td <?= $Page->reason_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREATMENTBILL_reason_id" class="V_TREATMENTBILL_reason_id">
<span<?= $Page->reason_id->viewAttributes() ?>>
<?= $Page->reason_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->way_id->Visible) { // way_id ?>
        <td <?= $Page->way_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREATMENTBILL_way_id" class="V_TREATMENTBILL_way_id">
<span<?= $Page->way_id->viewAttributes() ?>>
<?= $Page->way_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->follow_up->Visible) { // follow_up ?>
        <td <?= $Page->follow_up->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREATMENTBILL_follow_up" class="V_TREATMENTBILL_follow_up">
<span<?= $Page->follow_up->viewAttributes() ?>>
<?= $Page->follow_up->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->isnew->Visible) { // isnew ?>
        <td <?= $Page->isnew->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREATMENTBILL_isnew" class="V_TREATMENTBILL_isnew">
<span<?= $Page->isnew->viewAttributes() ?>>
<?= $Page->isnew->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->family_status_id->Visible) { // family_status_id ?>
        <td <?= $Page->family_status_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREATMENTBILL_family_status_id" class="V_TREATMENTBILL_family_status_id">
<span<?= $Page->family_status_id->viewAttributes() ?>>
<?= $Page->family_status_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->class_room_id->Visible) { // class_room_id ?>
        <td <?= $Page->class_room_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREATMENTBILL_class_room_id" class="V_TREATMENTBILL_class_room_id">
<span<?= $Page->class_room_id->viewAttributes() ?>>
<?= $Page->class_room_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->STATUS_PASIEN_ID->Visible) { // STATUS_PASIEN_ID ?>
        <td <?= $Page->STATUS_PASIEN_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREATMENTBILL_STATUS_PASIEN_ID" class="V_TREATMENTBILL_STATUS_PASIEN_ID">
<span<?= $Page->STATUS_PASIEN_ID->viewAttributes() ?>>
<?= $Page->STATUS_PASIEN_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->fullname->Visible) { // fullname ?>
        <td <?= $Page->fullname->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREATMENTBILL_fullname" class="V_TREATMENTBILL_fullname">
<span<?= $Page->fullname->viewAttributes() ?>>
<?= $Page->fullname->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->employee_id->Visible) { // employee_id ?>
        <td <?= $Page->employee_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREATMENTBILL_employee_id" class="V_TREATMENTBILL_employee_id">
<span<?= $Page->employee_id->viewAttributes() ?>>
<?= $Page->employee_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->employee_id_from->Visible) { // employee_id_from ?>
        <td <?= $Page->employee_id_from->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREATMENTBILL_employee_id_from" class="V_TREATMENTBILL_employee_id_from">
<span<?= $Page->employee_id_from->viewAttributes() ?>>
<?= $Page->employee_id_from->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->clinic_id->Visible) { // clinic_id ?>
        <td <?= $Page->clinic_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREATMENTBILL_clinic_id" class="V_TREATMENTBILL_clinic_id">
<span<?= $Page->clinic_id->viewAttributes() ?>>
<?= $Page->clinic_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->clinic_id_FROM->Visible) { // clinic_id_FROM ?>
        <td <?= $Page->clinic_id_FROM->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREATMENTBILL_clinic_id_FROM" class="V_TREATMENTBILL_clinic_id_FROM">
<span<?= $Page->clinic_id_FROM->viewAttributes() ?>>
<?= $Page->clinic_id_FROM->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->doctor->Visible) { // doctor ?>
        <td <?= $Page->doctor->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREATMENTBILL_doctor" class="V_TREATMENTBILL_doctor">
<span<?= $Page->doctor->viewAttributes() ?>>
<?= $Page->doctor->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->bed_id->Visible) { // bed_id ?>
        <td <?= $Page->bed_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREATMENTBILL_bed_id" class="V_TREATMENTBILL_bed_id">
<span<?= $Page->bed_id->viewAttributes() ?>>
<?= $Page->bed_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->keluar_id->Visible) { // keluar_id ?>
        <td <?= $Page->keluar_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREATMENTBILL_keluar_id" class="V_TREATMENTBILL_keluar_id">
<span<?= $Page->keluar_id->viewAttributes() ?>>
<?= $Page->keluar_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->treat_date->Visible) { // treat_date ?>
        <td <?= $Page->treat_date->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREATMENTBILL_treat_date" class="V_TREATMENTBILL_treat_date">
<span<?= $Page->treat_date->viewAttributes() ?>>
<?= $Page->treat_date->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->exit_date->Visible) { // exit_date ?>
        <td <?= $Page->exit_date->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREATMENTBILL_exit_date" class="V_TREATMENTBILL_exit_date">
<span<?= $Page->exit_date->viewAttributes() ?>>
<?= $Page->exit_date->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->name_of_class->Visible) { // name_of_class ?>
        <td <?= $Page->name_of_class->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREATMENTBILL_name_of_class" class="V_TREATMENTBILL_name_of_class">
<span<?= $Page->name_of_class->viewAttributes() ?>>
<?= $Page->name_of_class->getViewValue() ?></span>
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
