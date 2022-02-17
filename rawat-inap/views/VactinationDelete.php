<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

// Page object
$VactinationDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fVACTINATIONdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fVACTINATIONdelete = currentForm = new ew.Form("fVACTINATIONdelete", "delete");
    loadjs.done("fVACTINATIONdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.VACTINATION) ew.vars.tables.VACTINATION = <?= JsonEncode(GetClientVar("tables", "VACTINATION")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fVACTINATIONdelete" id="fVACTINATIONdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="VACTINATION">
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
        <th class="<?= $Page->ORG_UNIT_CODE->headerCellClass() ?>"><span id="elh_VACTINATION_ORG_UNIT_CODE" class="VACTINATION_ORG_UNIT_CODE"><?= $Page->ORG_UNIT_CODE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->VACTINATION_ID->Visible) { // VACTINATION_ID ?>
        <th class="<?= $Page->VACTINATION_ID->headerCellClass() ?>"><span id="elh_VACTINATION_VACTINATION_ID" class="VACTINATION_VACTINATION_ID"><?= $Page->VACTINATION_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->NO_REGISTRATION->Visible) { // NO_REGISTRATION ?>
        <th class="<?= $Page->NO_REGISTRATION->headerCellClass() ?>"><span id="elh_VACTINATION_NO_REGISTRATION" class="VACTINATION_NO_REGISTRATION"><?= $Page->NO_REGISTRATION->caption() ?></span></th>
<?php } ?>
<?php if ($Page->VISIT_ID->Visible) { // VISIT_ID ?>
        <th class="<?= $Page->VISIT_ID->headerCellClass() ?>"><span id="elh_VACTINATION_VISIT_ID" class="VACTINATION_VISIT_ID"><?= $Page->VISIT_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->BILL_ID->Visible) { // BILL_ID ?>
        <th class="<?= $Page->BILL_ID->headerCellClass() ?>"><span id="elh_VACTINATION_BILL_ID" class="VACTINATION_BILL_ID"><?= $Page->BILL_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->CLINIC_ID->Visible) { // CLINIC_ID ?>
        <th class="<?= $Page->CLINIC_ID->headerCellClass() ?>"><span id="elh_VACTINATION_CLINIC_ID" class="VACTINATION_CLINIC_ID"><?= $Page->CLINIC_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->VACTINATION_TYPE->Visible) { // VACTINATION_TYPE ?>
        <th class="<?= $Page->VACTINATION_TYPE->headerCellClass() ?>"><span id="elh_VACTINATION_VACTINATION_TYPE" class="VACTINATION_VACTINATION_TYPE"><?= $Page->VACTINATION_TYPE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->LEVEL_ID->Visible) { // LEVEL_ID ?>
        <th class="<?= $Page->LEVEL_ID->headerCellClass() ?>"><span id="elh_VACTINATION_LEVEL_ID" class="VACTINATION_LEVEL_ID"><?= $Page->LEVEL_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->EMPLOYEE_ID->Visible) { // EMPLOYEE_ID ?>
        <th class="<?= $Page->EMPLOYEE_ID->headerCellClass() ?>"><span id="elh_VACTINATION_EMPLOYEE_ID" class="VACTINATION_EMPLOYEE_ID"><?= $Page->EMPLOYEE_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->PATIENT_CATEGORY_ID->Visible) { // PATIENT_CATEGORY_ID ?>
        <th class="<?= $Page->PATIENT_CATEGORY_ID->headerCellClass() ?>"><span id="elh_VACTINATION_PATIENT_CATEGORY_ID" class="VACTINATION_PATIENT_CATEGORY_ID"><?= $Page->PATIENT_CATEGORY_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->VACTINATION_DATE->Visible) { // VACTINATION_DATE ?>
        <th class="<?= $Page->VACTINATION_DATE->headerCellClass() ?>"><span id="elh_VACTINATION_VACTINATION_DATE" class="VACTINATION_VACTINATION_DATE"><?= $Page->VACTINATION_DATE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->DESCRIPTION->Visible) { // DESCRIPTION ?>
        <th class="<?= $Page->DESCRIPTION->headerCellClass() ?>"><span id="elh_VACTINATION_DESCRIPTION" class="VACTINATION_DESCRIPTION"><?= $Page->DESCRIPTION->caption() ?></span></th>
<?php } ?>
<?php if ($Page->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
        <th class="<?= $Page->MODIFIED_DATE->headerCellClass() ?>"><span id="elh_VACTINATION_MODIFIED_DATE" class="VACTINATION_MODIFIED_DATE"><?= $Page->MODIFIED_DATE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
        <th class="<?= $Page->MODIFIED_BY->headerCellClass() ?>"><span id="elh_VACTINATION_MODIFIED_BY" class="VACTINATION_MODIFIED_BY"><?= $Page->MODIFIED_BY->caption() ?></span></th>
<?php } ?>
<?php if ($Page->MODIFIED_FROM->Visible) { // MODIFIED_FROM ?>
        <th class="<?= $Page->MODIFIED_FROM->headerCellClass() ?>"><span id="elh_VACTINATION_MODIFIED_FROM" class="VACTINATION_MODIFIED_FROM"><?= $Page->MODIFIED_FROM->caption() ?></span></th>
<?php } ?>
<?php if ($Page->THENAME->Visible) { // THENAME ?>
        <th class="<?= $Page->THENAME->headerCellClass() ?>"><span id="elh_VACTINATION_THENAME" class="VACTINATION_THENAME"><?= $Page->THENAME->caption() ?></span></th>
<?php } ?>
<?php if ($Page->THEADDRESS->Visible) { // THEADDRESS ?>
        <th class="<?= $Page->THEADDRESS->headerCellClass() ?>"><span id="elh_VACTINATION_THEADDRESS" class="VACTINATION_THEADDRESS"><?= $Page->THEADDRESS->caption() ?></span></th>
<?php } ?>
<?php if ($Page->THEID->Visible) { // THEID ?>
        <th class="<?= $Page->THEID->headerCellClass() ?>"><span id="elh_VACTINATION_THEID" class="VACTINATION_THEID"><?= $Page->THEID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ISRJ->Visible) { // ISRJ ?>
        <th class="<?= $Page->ISRJ->headerCellClass() ?>"><span id="elh_VACTINATION_ISRJ" class="VACTINATION_ISRJ"><?= $Page->ISRJ->caption() ?></span></th>
<?php } ?>
<?php if ($Page->AGEYEAR->Visible) { // AGEYEAR ?>
        <th class="<?= $Page->AGEYEAR->headerCellClass() ?>"><span id="elh_VACTINATION_AGEYEAR" class="VACTINATION_AGEYEAR"><?= $Page->AGEYEAR->caption() ?></span></th>
<?php } ?>
<?php if ($Page->AGEMONTH->Visible) { // AGEMONTH ?>
        <th class="<?= $Page->AGEMONTH->headerCellClass() ?>"><span id="elh_VACTINATION_AGEMONTH" class="VACTINATION_AGEMONTH"><?= $Page->AGEMONTH->caption() ?></span></th>
<?php } ?>
<?php if ($Page->AGEDAY->Visible) { // AGEDAY ?>
        <th class="<?= $Page->AGEDAY->headerCellClass() ?>"><span id="elh_VACTINATION_AGEDAY" class="VACTINATION_AGEDAY"><?= $Page->AGEDAY->caption() ?></span></th>
<?php } ?>
<?php if ($Page->STATUS_PASIEN_ID->Visible) { // STATUS_PASIEN_ID ?>
        <th class="<?= $Page->STATUS_PASIEN_ID->headerCellClass() ?>"><span id="elh_VACTINATION_STATUS_PASIEN_ID" class="VACTINATION_STATUS_PASIEN_ID"><?= $Page->STATUS_PASIEN_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->GENDER->Visible) { // GENDER ?>
        <th class="<?= $Page->GENDER->headerCellClass() ?>"><span id="elh_VACTINATION_GENDER" class="VACTINATION_GENDER"><?= $Page->GENDER->caption() ?></span></th>
<?php } ?>
<?php if ($Page->DOCTOR->Visible) { // DOCTOR ?>
        <th class="<?= $Page->DOCTOR->headerCellClass() ?>"><span id="elh_VACTINATION_DOCTOR" class="VACTINATION_DOCTOR"><?= $Page->DOCTOR->caption() ?></span></th>
<?php } ?>
<?php if ($Page->KAL_ID->Visible) { // KAL_ID ?>
        <th class="<?= $Page->KAL_ID->headerCellClass() ?>"><span id="elh_VACTINATION_KAL_ID" class="VACTINATION_KAL_ID"><?= $Page->KAL_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->CLASS_ROOM_ID->Visible) { // CLASS_ROOM_ID ?>
        <th class="<?= $Page->CLASS_ROOM_ID->headerCellClass() ?>"><span id="elh_VACTINATION_CLASS_ROOM_ID" class="VACTINATION_CLASS_ROOM_ID"><?= $Page->CLASS_ROOM_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->BED_ID->Visible) { // BED_ID ?>
        <th class="<?= $Page->BED_ID->headerCellClass() ?>"><span id="elh_VACTINATION_BED_ID" class="VACTINATION_BED_ID"><?= $Page->BED_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->KELUAR_ID->Visible) { // KELUAR_ID ?>
        <th class="<?= $Page->KELUAR_ID->headerCellClass() ?>"><span id="elh_VACTINATION_KELUAR_ID" class="VACTINATION_KELUAR_ID"><?= $Page->KELUAR_ID->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_VACTINATION_ORG_UNIT_CODE" class="VACTINATION_ORG_UNIT_CODE">
<span<?= $Page->ORG_UNIT_CODE->viewAttributes() ?>>
<?= $Page->ORG_UNIT_CODE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->VACTINATION_ID->Visible) { // VACTINATION_ID ?>
        <td <?= $Page->VACTINATION_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_VACTINATION_VACTINATION_ID" class="VACTINATION_VACTINATION_ID">
<span<?= $Page->VACTINATION_ID->viewAttributes() ?>>
<?= $Page->VACTINATION_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->NO_REGISTRATION->Visible) { // NO_REGISTRATION ?>
        <td <?= $Page->NO_REGISTRATION->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_VACTINATION_NO_REGISTRATION" class="VACTINATION_NO_REGISTRATION">
<span<?= $Page->NO_REGISTRATION->viewAttributes() ?>>
<?= $Page->NO_REGISTRATION->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->VISIT_ID->Visible) { // VISIT_ID ?>
        <td <?= $Page->VISIT_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_VACTINATION_VISIT_ID" class="VACTINATION_VISIT_ID">
<span<?= $Page->VISIT_ID->viewAttributes() ?>>
<?= $Page->VISIT_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->BILL_ID->Visible) { // BILL_ID ?>
        <td <?= $Page->BILL_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_VACTINATION_BILL_ID" class="VACTINATION_BILL_ID">
<span<?= $Page->BILL_ID->viewAttributes() ?>>
<?= $Page->BILL_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->CLINIC_ID->Visible) { // CLINIC_ID ?>
        <td <?= $Page->CLINIC_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_VACTINATION_CLINIC_ID" class="VACTINATION_CLINIC_ID">
<span<?= $Page->CLINIC_ID->viewAttributes() ?>>
<?= $Page->CLINIC_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->VACTINATION_TYPE->Visible) { // VACTINATION_TYPE ?>
        <td <?= $Page->VACTINATION_TYPE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_VACTINATION_VACTINATION_TYPE" class="VACTINATION_VACTINATION_TYPE">
<span<?= $Page->VACTINATION_TYPE->viewAttributes() ?>>
<?= $Page->VACTINATION_TYPE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->LEVEL_ID->Visible) { // LEVEL_ID ?>
        <td <?= $Page->LEVEL_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_VACTINATION_LEVEL_ID" class="VACTINATION_LEVEL_ID">
<span<?= $Page->LEVEL_ID->viewAttributes() ?>>
<?= $Page->LEVEL_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->EMPLOYEE_ID->Visible) { // EMPLOYEE_ID ?>
        <td <?= $Page->EMPLOYEE_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_VACTINATION_EMPLOYEE_ID" class="VACTINATION_EMPLOYEE_ID">
<span<?= $Page->EMPLOYEE_ID->viewAttributes() ?>>
<?= $Page->EMPLOYEE_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->PATIENT_CATEGORY_ID->Visible) { // PATIENT_CATEGORY_ID ?>
        <td <?= $Page->PATIENT_CATEGORY_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_VACTINATION_PATIENT_CATEGORY_ID" class="VACTINATION_PATIENT_CATEGORY_ID">
<span<?= $Page->PATIENT_CATEGORY_ID->viewAttributes() ?>>
<?= $Page->PATIENT_CATEGORY_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->VACTINATION_DATE->Visible) { // VACTINATION_DATE ?>
        <td <?= $Page->VACTINATION_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_VACTINATION_VACTINATION_DATE" class="VACTINATION_VACTINATION_DATE">
<span<?= $Page->VACTINATION_DATE->viewAttributes() ?>>
<?= $Page->VACTINATION_DATE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->DESCRIPTION->Visible) { // DESCRIPTION ?>
        <td <?= $Page->DESCRIPTION->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_VACTINATION_DESCRIPTION" class="VACTINATION_DESCRIPTION">
<span<?= $Page->DESCRIPTION->viewAttributes() ?>>
<?= $Page->DESCRIPTION->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
        <td <?= $Page->MODIFIED_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_VACTINATION_MODIFIED_DATE" class="VACTINATION_MODIFIED_DATE">
<span<?= $Page->MODIFIED_DATE->viewAttributes() ?>>
<?= $Page->MODIFIED_DATE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
        <td <?= $Page->MODIFIED_BY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_VACTINATION_MODIFIED_BY" class="VACTINATION_MODIFIED_BY">
<span<?= $Page->MODIFIED_BY->viewAttributes() ?>>
<?= $Page->MODIFIED_BY->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->MODIFIED_FROM->Visible) { // MODIFIED_FROM ?>
        <td <?= $Page->MODIFIED_FROM->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_VACTINATION_MODIFIED_FROM" class="VACTINATION_MODIFIED_FROM">
<span<?= $Page->MODIFIED_FROM->viewAttributes() ?>>
<?= $Page->MODIFIED_FROM->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->THENAME->Visible) { // THENAME ?>
        <td <?= $Page->THENAME->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_VACTINATION_THENAME" class="VACTINATION_THENAME">
<span<?= $Page->THENAME->viewAttributes() ?>>
<?= $Page->THENAME->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->THEADDRESS->Visible) { // THEADDRESS ?>
        <td <?= $Page->THEADDRESS->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_VACTINATION_THEADDRESS" class="VACTINATION_THEADDRESS">
<span<?= $Page->THEADDRESS->viewAttributes() ?>>
<?= $Page->THEADDRESS->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->THEID->Visible) { // THEID ?>
        <td <?= $Page->THEID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_VACTINATION_THEID" class="VACTINATION_THEID">
<span<?= $Page->THEID->viewAttributes() ?>>
<?= $Page->THEID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ISRJ->Visible) { // ISRJ ?>
        <td <?= $Page->ISRJ->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_VACTINATION_ISRJ" class="VACTINATION_ISRJ">
<span<?= $Page->ISRJ->viewAttributes() ?>>
<?= $Page->ISRJ->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->AGEYEAR->Visible) { // AGEYEAR ?>
        <td <?= $Page->AGEYEAR->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_VACTINATION_AGEYEAR" class="VACTINATION_AGEYEAR">
<span<?= $Page->AGEYEAR->viewAttributes() ?>>
<?= $Page->AGEYEAR->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->AGEMONTH->Visible) { // AGEMONTH ?>
        <td <?= $Page->AGEMONTH->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_VACTINATION_AGEMONTH" class="VACTINATION_AGEMONTH">
<span<?= $Page->AGEMONTH->viewAttributes() ?>>
<?= $Page->AGEMONTH->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->AGEDAY->Visible) { // AGEDAY ?>
        <td <?= $Page->AGEDAY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_VACTINATION_AGEDAY" class="VACTINATION_AGEDAY">
<span<?= $Page->AGEDAY->viewAttributes() ?>>
<?= $Page->AGEDAY->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->STATUS_PASIEN_ID->Visible) { // STATUS_PASIEN_ID ?>
        <td <?= $Page->STATUS_PASIEN_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_VACTINATION_STATUS_PASIEN_ID" class="VACTINATION_STATUS_PASIEN_ID">
<span<?= $Page->STATUS_PASIEN_ID->viewAttributes() ?>>
<?= $Page->STATUS_PASIEN_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->GENDER->Visible) { // GENDER ?>
        <td <?= $Page->GENDER->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_VACTINATION_GENDER" class="VACTINATION_GENDER">
<span<?= $Page->GENDER->viewAttributes() ?>>
<?= $Page->GENDER->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->DOCTOR->Visible) { // DOCTOR ?>
        <td <?= $Page->DOCTOR->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_VACTINATION_DOCTOR" class="VACTINATION_DOCTOR">
<span<?= $Page->DOCTOR->viewAttributes() ?>>
<?= $Page->DOCTOR->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->KAL_ID->Visible) { // KAL_ID ?>
        <td <?= $Page->KAL_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_VACTINATION_KAL_ID" class="VACTINATION_KAL_ID">
<span<?= $Page->KAL_ID->viewAttributes() ?>>
<?= $Page->KAL_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->CLASS_ROOM_ID->Visible) { // CLASS_ROOM_ID ?>
        <td <?= $Page->CLASS_ROOM_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_VACTINATION_CLASS_ROOM_ID" class="VACTINATION_CLASS_ROOM_ID">
<span<?= $Page->CLASS_ROOM_ID->viewAttributes() ?>>
<?= $Page->CLASS_ROOM_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->BED_ID->Visible) { // BED_ID ?>
        <td <?= $Page->BED_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_VACTINATION_BED_ID" class="VACTINATION_BED_ID">
<span<?= $Page->BED_ID->viewAttributes() ?>>
<?= $Page->BED_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->KELUAR_ID->Visible) { // KELUAR_ID ?>
        <td <?= $Page->KELUAR_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_VACTINATION_KELUAR_ID" class="VACTINATION_KELUAR_ID">
<span<?= $Page->KELUAR_ID->viewAttributes() ?>>
<?= $Page->KELUAR_ID->getViewValue() ?></span>
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
