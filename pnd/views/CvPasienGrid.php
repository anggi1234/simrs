<?php

namespace PHPMaker2021\SIMRSSQLSERVERPENDAFTARAN;

// Set up and run Grid object
$Grid = Container("CvPasienGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fCV_PASIENgrid;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    fCV_PASIENgrid = new ew.Form("fCV_PASIENgrid", "grid");
    fCV_PASIENgrid.formKeyCountName = '<?= $Grid->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "CV_PASIEN")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.CV_PASIEN)
        ew.vars.tables.CV_PASIEN = currentTable;
    fCV_PASIENgrid.addFields([
        ["NO_REGISTRATION", [fields.NO_REGISTRATION.visible && fields.NO_REGISTRATION.required ? ew.Validators.required(fields.NO_REGISTRATION.caption) : null], fields.NO_REGISTRATION.isInvalid],
        ["NAME_OF_PASIEN", [fields.NAME_OF_PASIEN.visible && fields.NAME_OF_PASIEN.required ? ew.Validators.required(fields.NAME_OF_PASIEN.caption) : null], fields.NAME_OF_PASIEN.isInvalid],
        ["PASIEN_ID", [fields.PASIEN_ID.visible && fields.PASIEN_ID.required ? ew.Validators.required(fields.PASIEN_ID.caption) : null], fields.PASIEN_ID.isInvalid],
        ["KK_NO", [fields.KK_NO.visible && fields.KK_NO.required ? ew.Validators.required(fields.KK_NO.caption) : null], fields.KK_NO.isInvalid],
        ["GENDER", [fields.GENDER.visible && fields.GENDER.required ? ew.Validators.required(fields.GENDER.caption) : null], fields.GENDER.isInvalid],
        ["STATUS_PASIEN_ID", [fields.STATUS_PASIEN_ID.visible && fields.STATUS_PASIEN_ID.required ? ew.Validators.required(fields.STATUS_PASIEN_ID.caption) : null], fields.STATUS_PASIEN_ID.isInvalid],
        ["CONTACT_ADDRESS", [fields.CONTACT_ADDRESS.visible && fields.CONTACT_ADDRESS.required ? ew.Validators.required(fields.CONTACT_ADDRESS.caption) : null], fields.CONTACT_ADDRESS.isInvalid],
        ["REGISTRATION_DATE", [fields.REGISTRATION_DATE.visible && fields.REGISTRATION_DATE.required ? ew.Validators.required(fields.REGISTRATION_DATE.caption) : null, ew.Validators.datetime(11)], fields.REGISTRATION_DATE.isInvalid],
        ["MOTHER", [fields.MOTHER.visible && fields.MOTHER.required ? ew.Validators.required(fields.MOTHER.caption) : null], fields.MOTHER.isInvalid],
        ["FATHER", [fields.FATHER.visible && fields.FATHER.required ? ew.Validators.required(fields.FATHER.caption) : null], fields.FATHER.isInvalid],
        ["SPOUSE", [fields.SPOUSE.visible && fields.SPOUSE.required ? ew.Validators.required(fields.SPOUSE.caption) : null], fields.SPOUSE.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fCV_PASIENgrid,
            fobj = f.getForm(),
            $fobj = $(fobj),
            $k = $fobj.find("#" + f.formKeyCountName), // Get key_count
            rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1,
            startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
        for (var i = startcnt; i <= rowcnt; i++) {
            var rowIndex = ($k[0]) ? String(i) : "";
            f.setInvalid(rowIndex);
        }
    });

    // Validate form
    fCV_PASIENgrid.validate = function () {
        if (!this.validateRequired)
            return true; // Ignore validation
        var fobj = this.getForm(),
            $fobj = $(fobj);
        if ($fobj.find("#confirm").val() == "confirm")
            return true;
        var addcnt = 0,
            $k = $fobj.find("#" + this.formKeyCountName), // Get key_count
            rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1,
            startcnt = (rowcnt == 0) ? 0 : 1, // Check rowcnt == 0 => Inline-Add
            gridinsert = ["insert", "gridinsert"].includes($fobj.find("#action").val()) && $k[0];
        for (var i = startcnt; i <= rowcnt; i++) {
            var rowIndex = ($k[0]) ? String(i) : "";
            $fobj.data("rowindex", rowIndex);
            var checkrow = (gridinsert) ? !this.emptyRow(rowIndex) : true;
            if (checkrow) {
                addcnt++;

            // Validate fields
            if (!this.validateFields(rowIndex))
                return false;

            // Call Form_CustomValidate event
            if (!this.customValidate(fobj)) {
                this.focus();
                return false;
            }
            } // End Grid Add checking
        }
        return true;
    }

    // Check empty row
    fCV_PASIENgrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm();
        if (ew.valueChanged(fobj, rowIndex, "NO_REGISTRATION", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "NAME_OF_PASIEN", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "PASIEN_ID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "KK_NO", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "GENDER", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "STATUS_PASIEN_ID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "CONTACT_ADDRESS", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "REGISTRATION_DATE", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "MOTHER", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "FATHER", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "SPOUSE", false))
            return false;
        return true;
    }

    // Form_CustomValidate
    fCV_PASIENgrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fCV_PASIENgrid.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fCV_PASIENgrid.lists.GENDER = <?= $Grid->GENDER->toClientList($Grid) ?>;
    fCV_PASIENgrid.lists.STATUS_PASIEN_ID = <?= $Grid->STATUS_PASIEN_ID->toClientList($Grid) ?>;
    loadjs.done("fCV_PASIENgrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> CV_PASIEN">
<?php if ($Grid->ShowOtherOptions) { ?>
<div class="card-header ew-grid-upper-panel">
<?php $Grid->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="fCV_PASIENgrid" class="ew-form ew-list-form form-inline">
<div id="gmp_CV_PASIEN" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_CV_PASIENgrid" class="table ew-table"><!-- .ew-table -->
<thead>
    <tr class="ew-table-header">
<?php
// Header row
$Grid->RowType = ROWTYPE_HEADER;

// Render list options
$Grid->renderListOptions();

// Render list options (header, left)
$Grid->ListOptions->render("header", "left");
?>
<?php if ($Grid->NO_REGISTRATION->Visible) { // NO_REGISTRATION ?>
        <th data-name="NO_REGISTRATION" class="<?= $Grid->NO_REGISTRATION->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_CV_PASIEN_NO_REGISTRATION" class="CV_PASIEN_NO_REGISTRATION"><?= $Grid->renderSort($Grid->NO_REGISTRATION) ?></div></th>
<?php } ?>
<?php if ($Grid->NAME_OF_PASIEN->Visible) { // NAME_OF_PASIEN ?>
        <th data-name="NAME_OF_PASIEN" class="<?= $Grid->NAME_OF_PASIEN->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_CV_PASIEN_NAME_OF_PASIEN" class="CV_PASIEN_NAME_OF_PASIEN"><?= $Grid->renderSort($Grid->NAME_OF_PASIEN) ?></div></th>
<?php } ?>
<?php if ($Grid->PASIEN_ID->Visible) { // PASIEN_ID ?>
        <th data-name="PASIEN_ID" class="<?= $Grid->PASIEN_ID->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_CV_PASIEN_PASIEN_ID" class="CV_PASIEN_PASIEN_ID"><?= $Grid->renderSort($Grid->PASIEN_ID) ?></div></th>
<?php } ?>
<?php if ($Grid->KK_NO->Visible) { // KK_NO ?>
        <th data-name="KK_NO" class="<?= $Grid->KK_NO->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_CV_PASIEN_KK_NO" class="CV_PASIEN_KK_NO"><?= $Grid->renderSort($Grid->KK_NO) ?></div></th>
<?php } ?>
<?php if ($Grid->GENDER->Visible) { // GENDER ?>
        <th data-name="GENDER" class="<?= $Grid->GENDER->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_CV_PASIEN_GENDER" class="CV_PASIEN_GENDER"><?= $Grid->renderSort($Grid->GENDER) ?></div></th>
<?php } ?>
<?php if ($Grid->STATUS_PASIEN_ID->Visible) { // STATUS_PASIEN_ID ?>
        <th data-name="STATUS_PASIEN_ID" class="<?= $Grid->STATUS_PASIEN_ID->headerCellClass() ?>"><div id="elh_CV_PASIEN_STATUS_PASIEN_ID" class="CV_PASIEN_STATUS_PASIEN_ID"><?= $Grid->renderSort($Grid->STATUS_PASIEN_ID) ?></div></th>
<?php } ?>
<?php if ($Grid->CONTACT_ADDRESS->Visible) { // CONTACT_ADDRESS ?>
        <th data-name="CONTACT_ADDRESS" class="<?= $Grid->CONTACT_ADDRESS->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_CV_PASIEN_CONTACT_ADDRESS" class="CV_PASIEN_CONTACT_ADDRESS"><?= $Grid->renderSort($Grid->CONTACT_ADDRESS) ?></div></th>
<?php } ?>
<?php if ($Grid->REGISTRATION_DATE->Visible) { // REGISTRATION_DATE ?>
        <th data-name="REGISTRATION_DATE" class="<?= $Grid->REGISTRATION_DATE->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_CV_PASIEN_REGISTRATION_DATE" class="CV_PASIEN_REGISTRATION_DATE"><?= $Grid->renderSort($Grid->REGISTRATION_DATE) ?></div></th>
<?php } ?>
<?php if ($Grid->MOTHER->Visible) { // MOTHER ?>
        <th data-name="MOTHER" class="<?= $Grid->MOTHER->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_CV_PASIEN_MOTHER" class="CV_PASIEN_MOTHER"><?= $Grid->renderSort($Grid->MOTHER) ?></div></th>
<?php } ?>
<?php if ($Grid->FATHER->Visible) { // FATHER ?>
        <th data-name="FATHER" class="<?= $Grid->FATHER->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_CV_PASIEN_FATHER" class="CV_PASIEN_FATHER"><?= $Grid->renderSort($Grid->FATHER) ?></div></th>
<?php } ?>
<?php if ($Grid->SPOUSE->Visible) { // SPOUSE ?>
        <th data-name="SPOUSE" class="<?= $Grid->SPOUSE->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_CV_PASIEN_SPOUSE" class="CV_PASIEN_SPOUSE"><?= $Grid->renderSort($Grid->SPOUSE) ?></div></th>
<?php } ?>
<?php
// Render list options (header, right)
$Grid->ListOptions->render("header", "right");
?>
    </tr>
</thead>
<tbody>
<?php
$Grid->StartRecord = 1;
$Grid->StopRecord = $Grid->TotalRecords; // Show all records

// Restore number of post back records
if ($CurrentForm && ($Grid->isConfirm() || $Grid->EventCancelled)) {
    $CurrentForm->Index = -1;
    if ($CurrentForm->hasValue($Grid->FormKeyCountName) && ($Grid->isGridAdd() || $Grid->isGridEdit() || $Grid->isConfirm())) {
        $Grid->KeyCount = $CurrentForm->getValue($Grid->FormKeyCountName);
        $Grid->StopRecord = $Grid->StartRecord + $Grid->KeyCount - 1;
    }
}
$Grid->RecordCount = $Grid->StartRecord - 1;
if ($Grid->Recordset && !$Grid->Recordset->EOF) {
    // Nothing to do
} elseif (!$Grid->AllowAddDeleteRow && $Grid->StopRecord == 0) {
    $Grid->StopRecord = $Grid->GridAddRowCount;
}

// Initialize aggregate
$Grid->RowType = ROWTYPE_AGGREGATEINIT;
$Grid->resetAttributes();
$Grid->renderRow();
if ($Grid->isGridAdd())
    $Grid->RowIndex = 0;
if ($Grid->isGridEdit())
    $Grid->RowIndex = 0;
while ($Grid->RecordCount < $Grid->StopRecord) {
    $Grid->RecordCount++;
    if ($Grid->RecordCount >= $Grid->StartRecord) {
        $Grid->RowCount++;
        if ($Grid->isGridAdd() || $Grid->isGridEdit() || $Grid->isConfirm()) {
            $Grid->RowIndex++;
            $CurrentForm->Index = $Grid->RowIndex;
            if ($CurrentForm->hasValue($Grid->FormActionName) && ($Grid->isConfirm() || $Grid->EventCancelled)) {
                $Grid->RowAction = strval($CurrentForm->getValue($Grid->FormActionName));
            } elseif ($Grid->isGridAdd()) {
                $Grid->RowAction = "insert";
            } else {
                $Grid->RowAction = "";
            }
        }

        // Set up key count
        $Grid->KeyCount = $Grid->RowIndex;

        // Init row class and style
        $Grid->resetAttributes();
        $Grid->CssClass = "";
        if ($Grid->isGridAdd()) {
            if ($Grid->CurrentMode == "copy") {
                $Grid->loadRowValues($Grid->Recordset); // Load row values
                $Grid->OldKey = $Grid->getKey(true); // Get from CurrentValue
            } else {
                $Grid->loadRowValues(); // Load default values
                $Grid->OldKey = "";
            }
        } else {
            $Grid->loadRowValues($Grid->Recordset); // Load row values
            $Grid->OldKey = $Grid->getKey(true); // Get from CurrentValue
        }
        $Grid->setKey($Grid->OldKey);
        $Grid->RowType = ROWTYPE_VIEW; // Render view
        if ($Grid->isGridAdd()) { // Grid add
            $Grid->RowType = ROWTYPE_ADD; // Render add
        }
        if ($Grid->isGridAdd() && $Grid->EventCancelled && !$CurrentForm->hasValue("k_blankrow")) { // Insert failed
            $Grid->restoreCurrentRowFormValues($Grid->RowIndex); // Restore form values
        }
        if ($Grid->isGridEdit()) { // Grid edit
            if ($Grid->EventCancelled) {
                $Grid->restoreCurrentRowFormValues($Grid->RowIndex); // Restore form values
            }
            if ($Grid->RowAction == "insert") {
                $Grid->RowType = ROWTYPE_ADD; // Render add
            } else {
                $Grid->RowType = ROWTYPE_EDIT; // Render edit
            }
        }
        if ($Grid->isGridEdit() && ($Grid->RowType == ROWTYPE_EDIT || $Grid->RowType == ROWTYPE_ADD) && $Grid->EventCancelled) { // Update failed
            $Grid->restoreCurrentRowFormValues($Grid->RowIndex); // Restore form values
        }
        if ($Grid->RowType == ROWTYPE_EDIT) { // Edit row
            $Grid->EditRowCount++;
        }
        if ($Grid->isConfirm()) { // Confirm row
            $Grid->restoreCurrentRowFormValues($Grid->RowIndex); // Restore form values
        }

        // Set up row id / data-rowindex
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowCount, "id" => "r" . $Grid->RowCount . "_CV_PASIEN", "data-rowtype" => $Grid->RowType]);

        // Render row
        $Grid->renderRow();

        // Render list options
        $Grid->renderListOptions();

        // Skip delete row / empty row for confirm page
        if ($Grid->RowAction != "delete" && $Grid->RowAction != "insertdelete" && !($Grid->RowAction == "insert" && $Grid->isConfirm() && $Grid->emptyRow())) {
?>
    <tr <?= $Grid->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Grid->ListOptions->render("body", "left", $Grid->RowCount);
?>
    <?php if ($Grid->NO_REGISTRATION->Visible) { // NO_REGISTRATION ?>
        <td data-name="NO_REGISTRATION" <?= $Grid->NO_REGISTRATION->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Grid->NO_REGISTRATION->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_CV_PASIEN_NO_REGISTRATION" class="form-group">
<span<?= $Grid->NO_REGISTRATION->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->NO_REGISTRATION->getDisplayValue($Grid->NO_REGISTRATION->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" name="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" value="<?= HtmlEncode($Grid->NO_REGISTRATION->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_CV_PASIEN_NO_REGISTRATION" class="form-group">
<input type="<?= $Grid->NO_REGISTRATION->getInputTextType() ?>" data-table="CV_PASIEN" data-field="x_NO_REGISTRATION" name="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" id="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" size="30" maxlength="25" placeholder="<?= HtmlEncode($Grid->NO_REGISTRATION->getPlaceHolder()) ?>" value="<?= $Grid->NO_REGISTRATION->EditValue ?>"<?= $Grid->NO_REGISTRATION->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->NO_REGISTRATION->getErrorMessage() ?></div>
</span>
<?php } ?>
<input type="hidden" data-table="CV_PASIEN" data-field="x_NO_REGISTRATION" data-hidden="1" name="o<?= $Grid->RowIndex ?>_NO_REGISTRATION" id="o<?= $Grid->RowIndex ?>_NO_REGISTRATION" value="<?= HtmlEncode($Grid->NO_REGISTRATION->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_CV_PASIEN_NO_REGISTRATION" class="form-group">
<span<?= $Grid->NO_REGISTRATION->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->NO_REGISTRATION->getDisplayValue($Grid->NO_REGISTRATION->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="CV_PASIEN" data-field="x_NO_REGISTRATION" data-hidden="1" name="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" id="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" value="<?= HtmlEncode($Grid->NO_REGISTRATION->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_CV_PASIEN_NO_REGISTRATION">
<span<?= $Grid->NO_REGISTRATION->viewAttributes() ?>>
<?= $Grid->NO_REGISTRATION->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="CV_PASIEN" data-field="x_NO_REGISTRATION" data-hidden="1" name="fCV_PASIENgrid$x<?= $Grid->RowIndex ?>_NO_REGISTRATION" id="fCV_PASIENgrid$x<?= $Grid->RowIndex ?>_NO_REGISTRATION" value="<?= HtmlEncode($Grid->NO_REGISTRATION->FormValue) ?>">
<input type="hidden" data-table="CV_PASIEN" data-field="x_NO_REGISTRATION" data-hidden="1" name="fCV_PASIENgrid$o<?= $Grid->RowIndex ?>_NO_REGISTRATION" id="fCV_PASIENgrid$o<?= $Grid->RowIndex ?>_NO_REGISTRATION" value="<?= HtmlEncode($Grid->NO_REGISTRATION->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->NAME_OF_PASIEN->Visible) { // NAME_OF_PASIEN ?>
        <td data-name="NAME_OF_PASIEN" <?= $Grid->NAME_OF_PASIEN->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_CV_PASIEN_NAME_OF_PASIEN" class="form-group">
<input type="<?= $Grid->NAME_OF_PASIEN->getInputTextType() ?>" data-table="CV_PASIEN" data-field="x_NAME_OF_PASIEN" name="x<?= $Grid->RowIndex ?>_NAME_OF_PASIEN" id="x<?= $Grid->RowIndex ?>_NAME_OF_PASIEN" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->NAME_OF_PASIEN->getPlaceHolder()) ?>" value="<?= $Grid->NAME_OF_PASIEN->EditValue ?>"<?= $Grid->NAME_OF_PASIEN->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->NAME_OF_PASIEN->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="CV_PASIEN" data-field="x_NAME_OF_PASIEN" data-hidden="1" name="o<?= $Grid->RowIndex ?>_NAME_OF_PASIEN" id="o<?= $Grid->RowIndex ?>_NAME_OF_PASIEN" value="<?= HtmlEncode($Grid->NAME_OF_PASIEN->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_CV_PASIEN_NAME_OF_PASIEN" class="form-group">
<input type="<?= $Grid->NAME_OF_PASIEN->getInputTextType() ?>" data-table="CV_PASIEN" data-field="x_NAME_OF_PASIEN" name="x<?= $Grid->RowIndex ?>_NAME_OF_PASIEN" id="x<?= $Grid->RowIndex ?>_NAME_OF_PASIEN" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->NAME_OF_PASIEN->getPlaceHolder()) ?>" value="<?= $Grid->NAME_OF_PASIEN->EditValue ?>"<?= $Grid->NAME_OF_PASIEN->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->NAME_OF_PASIEN->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_CV_PASIEN_NAME_OF_PASIEN">
<span<?= $Grid->NAME_OF_PASIEN->viewAttributes() ?>>
<?= $Grid->NAME_OF_PASIEN->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="CV_PASIEN" data-field="x_NAME_OF_PASIEN" data-hidden="1" name="fCV_PASIENgrid$x<?= $Grid->RowIndex ?>_NAME_OF_PASIEN" id="fCV_PASIENgrid$x<?= $Grid->RowIndex ?>_NAME_OF_PASIEN" value="<?= HtmlEncode($Grid->NAME_OF_PASIEN->FormValue) ?>">
<input type="hidden" data-table="CV_PASIEN" data-field="x_NAME_OF_PASIEN" data-hidden="1" name="fCV_PASIENgrid$o<?= $Grid->RowIndex ?>_NAME_OF_PASIEN" id="fCV_PASIENgrid$o<?= $Grid->RowIndex ?>_NAME_OF_PASIEN" value="<?= HtmlEncode($Grid->NAME_OF_PASIEN->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->PASIEN_ID->Visible) { // PASIEN_ID ?>
        <td data-name="PASIEN_ID" <?= $Grid->PASIEN_ID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_CV_PASIEN_PASIEN_ID" class="form-group">
<input type="<?= $Grid->PASIEN_ID->getInputTextType() ?>" data-table="CV_PASIEN" data-field="x_PASIEN_ID" name="x<?= $Grid->RowIndex ?>_PASIEN_ID" id="x<?= $Grid->RowIndex ?>_PASIEN_ID" size="30" maxlength="30" placeholder="<?= HtmlEncode($Grid->PASIEN_ID->getPlaceHolder()) ?>" value="<?= $Grid->PASIEN_ID->EditValue ?>"<?= $Grid->PASIEN_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->PASIEN_ID->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="CV_PASIEN" data-field="x_PASIEN_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_PASIEN_ID" id="o<?= $Grid->RowIndex ?>_PASIEN_ID" value="<?= HtmlEncode($Grid->PASIEN_ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_CV_PASIEN_PASIEN_ID" class="form-group">
<input type="<?= $Grid->PASIEN_ID->getInputTextType() ?>" data-table="CV_PASIEN" data-field="x_PASIEN_ID" name="x<?= $Grid->RowIndex ?>_PASIEN_ID" id="x<?= $Grid->RowIndex ?>_PASIEN_ID" size="30" maxlength="30" placeholder="<?= HtmlEncode($Grid->PASIEN_ID->getPlaceHolder()) ?>" value="<?= $Grid->PASIEN_ID->EditValue ?>"<?= $Grid->PASIEN_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->PASIEN_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_CV_PASIEN_PASIEN_ID">
<span<?= $Grid->PASIEN_ID->viewAttributes() ?>>
<?= $Grid->PASIEN_ID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="CV_PASIEN" data-field="x_PASIEN_ID" data-hidden="1" name="fCV_PASIENgrid$x<?= $Grid->RowIndex ?>_PASIEN_ID" id="fCV_PASIENgrid$x<?= $Grid->RowIndex ?>_PASIEN_ID" value="<?= HtmlEncode($Grid->PASIEN_ID->FormValue) ?>">
<input type="hidden" data-table="CV_PASIEN" data-field="x_PASIEN_ID" data-hidden="1" name="fCV_PASIENgrid$o<?= $Grid->RowIndex ?>_PASIEN_ID" id="fCV_PASIENgrid$o<?= $Grid->RowIndex ?>_PASIEN_ID" value="<?= HtmlEncode($Grid->PASIEN_ID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->KK_NO->Visible) { // KK_NO ?>
        <td data-name="KK_NO" <?= $Grid->KK_NO->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_CV_PASIEN_KK_NO" class="form-group">
<input type="<?= $Grid->KK_NO->getInputTextType() ?>" data-table="CV_PASIEN" data-field="x_KK_NO" name="x<?= $Grid->RowIndex ?>_KK_NO" id="x<?= $Grid->RowIndex ?>_KK_NO" size="30" maxlength="30" placeholder="<?= HtmlEncode($Grid->KK_NO->getPlaceHolder()) ?>" value="<?= $Grid->KK_NO->EditValue ?>"<?= $Grid->KK_NO->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->KK_NO->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="CV_PASIEN" data-field="x_KK_NO" data-hidden="1" name="o<?= $Grid->RowIndex ?>_KK_NO" id="o<?= $Grid->RowIndex ?>_KK_NO" value="<?= HtmlEncode($Grid->KK_NO->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_CV_PASIEN_KK_NO" class="form-group">
<input type="<?= $Grid->KK_NO->getInputTextType() ?>" data-table="CV_PASIEN" data-field="x_KK_NO" name="x<?= $Grid->RowIndex ?>_KK_NO" id="x<?= $Grid->RowIndex ?>_KK_NO" size="30" maxlength="30" placeholder="<?= HtmlEncode($Grid->KK_NO->getPlaceHolder()) ?>" value="<?= $Grid->KK_NO->EditValue ?>"<?= $Grid->KK_NO->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->KK_NO->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_CV_PASIEN_KK_NO">
<span<?= $Grid->KK_NO->viewAttributes() ?>>
<?= $Grid->KK_NO->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="CV_PASIEN" data-field="x_KK_NO" data-hidden="1" name="fCV_PASIENgrid$x<?= $Grid->RowIndex ?>_KK_NO" id="fCV_PASIENgrid$x<?= $Grid->RowIndex ?>_KK_NO" value="<?= HtmlEncode($Grid->KK_NO->FormValue) ?>">
<input type="hidden" data-table="CV_PASIEN" data-field="x_KK_NO" data-hidden="1" name="fCV_PASIENgrid$o<?= $Grid->RowIndex ?>_KK_NO" id="fCV_PASIENgrid$o<?= $Grid->RowIndex ?>_KK_NO" value="<?= HtmlEncode($Grid->KK_NO->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->GENDER->Visible) { // GENDER ?>
        <td data-name="GENDER" <?= $Grid->GENDER->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_CV_PASIEN_GENDER" class="form-group">
<?php
$onchange = $Grid->GENDER->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Grid->GENDER->EditAttrs["onchange"] = "";
?>
<span id="as_x<?= $Grid->RowIndex ?>_GENDER" class="ew-auto-suggest">
    <input type="<?= $Grid->GENDER->getInputTextType() ?>" class="form-control" name="sv_x<?= $Grid->RowIndex ?>_GENDER" id="sv_x<?= $Grid->RowIndex ?>_GENDER" value="<?= RemoveHtml($Grid->GENDER->EditValue) ?>" size="30" maxlength="1" placeholder="<?= HtmlEncode($Grid->GENDER->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Grid->GENDER->getPlaceHolder()) ?>"<?= $Grid->GENDER->editAttributes() ?>>
</span>
<input type="hidden" is="selection-list" class="form-control" data-table="CV_PASIEN" data-field="x_GENDER" data-input="sv_x<?= $Grid->RowIndex ?>_GENDER" data-value-separator="<?= $Grid->GENDER->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_GENDER" id="x<?= $Grid->RowIndex ?>_GENDER" value="<?= HtmlEncode($Grid->GENDER->CurrentValue) ?>"<?= $onchange ?>>
<div class="invalid-feedback"><?= $Grid->GENDER->getErrorMessage() ?></div>
<script>
loadjs.ready(["fCV_PASIENgrid"], function() {
    fCV_PASIENgrid.createAutoSuggest(Object.assign({"id":"x<?= $Grid->RowIndex ?>_GENDER","forceSelect":false}, ew.vars.tables.CV_PASIEN.fields.GENDER.autoSuggestOptions));
});
</script>
<?= $Grid->GENDER->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_GENDER") ?>
</span>
<input type="hidden" data-table="CV_PASIEN" data-field="x_GENDER" data-hidden="1" name="o<?= $Grid->RowIndex ?>_GENDER" id="o<?= $Grid->RowIndex ?>_GENDER" value="<?= HtmlEncode($Grid->GENDER->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_CV_PASIEN_GENDER" class="form-group">
<?php
$onchange = $Grid->GENDER->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Grid->GENDER->EditAttrs["onchange"] = "";
?>
<span id="as_x<?= $Grid->RowIndex ?>_GENDER" class="ew-auto-suggest">
    <input type="<?= $Grid->GENDER->getInputTextType() ?>" class="form-control" name="sv_x<?= $Grid->RowIndex ?>_GENDER" id="sv_x<?= $Grid->RowIndex ?>_GENDER" value="<?= RemoveHtml($Grid->GENDER->EditValue) ?>" size="30" maxlength="1" placeholder="<?= HtmlEncode($Grid->GENDER->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Grid->GENDER->getPlaceHolder()) ?>"<?= $Grid->GENDER->editAttributes() ?>>
</span>
<input type="hidden" is="selection-list" class="form-control" data-table="CV_PASIEN" data-field="x_GENDER" data-input="sv_x<?= $Grid->RowIndex ?>_GENDER" data-value-separator="<?= $Grid->GENDER->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_GENDER" id="x<?= $Grid->RowIndex ?>_GENDER" value="<?= HtmlEncode($Grid->GENDER->CurrentValue) ?>"<?= $onchange ?>>
<div class="invalid-feedback"><?= $Grid->GENDER->getErrorMessage() ?></div>
<script>
loadjs.ready(["fCV_PASIENgrid"], function() {
    fCV_PASIENgrid.createAutoSuggest(Object.assign({"id":"x<?= $Grid->RowIndex ?>_GENDER","forceSelect":false}, ew.vars.tables.CV_PASIEN.fields.GENDER.autoSuggestOptions));
});
</script>
<?= $Grid->GENDER->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_GENDER") ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_CV_PASIEN_GENDER">
<span<?= $Grid->GENDER->viewAttributes() ?>>
<?= $Grid->GENDER->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="CV_PASIEN" data-field="x_GENDER" data-hidden="1" name="fCV_PASIENgrid$x<?= $Grid->RowIndex ?>_GENDER" id="fCV_PASIENgrid$x<?= $Grid->RowIndex ?>_GENDER" value="<?= HtmlEncode($Grid->GENDER->FormValue) ?>">
<input type="hidden" data-table="CV_PASIEN" data-field="x_GENDER" data-hidden="1" name="fCV_PASIENgrid$o<?= $Grid->RowIndex ?>_GENDER" id="fCV_PASIENgrid$o<?= $Grid->RowIndex ?>_GENDER" value="<?= HtmlEncode($Grid->GENDER->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->STATUS_PASIEN_ID->Visible) { // STATUS_PASIEN_ID ?>
        <td data-name="STATUS_PASIEN_ID" <?= $Grid->STATUS_PASIEN_ID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_CV_PASIEN_STATUS_PASIEN_ID" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_STATUS_PASIEN_ID"
        name="x<?= $Grid->RowIndex ?>_STATUS_PASIEN_ID"
        class="form-control ew-select<?= $Grid->STATUS_PASIEN_ID->isInvalidClass() ?>"
        data-select2-id="CV_PASIEN_x<?= $Grid->RowIndex ?>_STATUS_PASIEN_ID"
        data-table="CV_PASIEN"
        data-field="x_STATUS_PASIEN_ID"
        data-value-separator="<?= $Grid->STATUS_PASIEN_ID->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->STATUS_PASIEN_ID->getPlaceHolder()) ?>"
        <?= $Grid->STATUS_PASIEN_ID->editAttributes() ?>>
        <?= $Grid->STATUS_PASIEN_ID->selectOptionListHtml("x{$Grid->RowIndex}_STATUS_PASIEN_ID") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->STATUS_PASIEN_ID->getErrorMessage() ?></div>
<?= $Grid->STATUS_PASIEN_ID->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_STATUS_PASIEN_ID") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='CV_PASIEN_x<?= $Grid->RowIndex ?>_STATUS_PASIEN_ID']"),
        options = { name: "x<?= $Grid->RowIndex ?>_STATUS_PASIEN_ID", selectId: "CV_PASIEN_x<?= $Grid->RowIndex ?>_STATUS_PASIEN_ID", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.CV_PASIEN.fields.STATUS_PASIEN_ID.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="CV_PASIEN" data-field="x_STATUS_PASIEN_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_STATUS_PASIEN_ID" id="o<?= $Grid->RowIndex ?>_STATUS_PASIEN_ID" value="<?= HtmlEncode($Grid->STATUS_PASIEN_ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_CV_PASIEN_STATUS_PASIEN_ID" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_STATUS_PASIEN_ID"
        name="x<?= $Grid->RowIndex ?>_STATUS_PASIEN_ID"
        class="form-control ew-select<?= $Grid->STATUS_PASIEN_ID->isInvalidClass() ?>"
        data-select2-id="CV_PASIEN_x<?= $Grid->RowIndex ?>_STATUS_PASIEN_ID"
        data-table="CV_PASIEN"
        data-field="x_STATUS_PASIEN_ID"
        data-value-separator="<?= $Grid->STATUS_PASIEN_ID->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->STATUS_PASIEN_ID->getPlaceHolder()) ?>"
        <?= $Grid->STATUS_PASIEN_ID->editAttributes() ?>>
        <?= $Grid->STATUS_PASIEN_ID->selectOptionListHtml("x{$Grid->RowIndex}_STATUS_PASIEN_ID") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->STATUS_PASIEN_ID->getErrorMessage() ?></div>
<?= $Grid->STATUS_PASIEN_ID->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_STATUS_PASIEN_ID") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='CV_PASIEN_x<?= $Grid->RowIndex ?>_STATUS_PASIEN_ID']"),
        options = { name: "x<?= $Grid->RowIndex ?>_STATUS_PASIEN_ID", selectId: "CV_PASIEN_x<?= $Grid->RowIndex ?>_STATUS_PASIEN_ID", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.CV_PASIEN.fields.STATUS_PASIEN_ID.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_CV_PASIEN_STATUS_PASIEN_ID">
<span<?= $Grid->STATUS_PASIEN_ID->viewAttributes() ?>>
<?= $Grid->STATUS_PASIEN_ID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="CV_PASIEN" data-field="x_STATUS_PASIEN_ID" data-hidden="1" name="fCV_PASIENgrid$x<?= $Grid->RowIndex ?>_STATUS_PASIEN_ID" id="fCV_PASIENgrid$x<?= $Grid->RowIndex ?>_STATUS_PASIEN_ID" value="<?= HtmlEncode($Grid->STATUS_PASIEN_ID->FormValue) ?>">
<input type="hidden" data-table="CV_PASIEN" data-field="x_STATUS_PASIEN_ID" data-hidden="1" name="fCV_PASIENgrid$o<?= $Grid->RowIndex ?>_STATUS_PASIEN_ID" id="fCV_PASIENgrid$o<?= $Grid->RowIndex ?>_STATUS_PASIEN_ID" value="<?= HtmlEncode($Grid->STATUS_PASIEN_ID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->CONTACT_ADDRESS->Visible) { // CONTACT_ADDRESS ?>
        <td data-name="CONTACT_ADDRESS" <?= $Grid->CONTACT_ADDRESS->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_CV_PASIEN_CONTACT_ADDRESS" class="form-group">
<input type="<?= $Grid->CONTACT_ADDRESS->getInputTextType() ?>" data-table="CV_PASIEN" data-field="x_CONTACT_ADDRESS" name="x<?= $Grid->RowIndex ?>_CONTACT_ADDRESS" id="x<?= $Grid->RowIndex ?>_CONTACT_ADDRESS" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->CONTACT_ADDRESS->getPlaceHolder()) ?>" value="<?= $Grid->CONTACT_ADDRESS->EditValue ?>"<?= $Grid->CONTACT_ADDRESS->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->CONTACT_ADDRESS->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="CV_PASIEN" data-field="x_CONTACT_ADDRESS" data-hidden="1" name="o<?= $Grid->RowIndex ?>_CONTACT_ADDRESS" id="o<?= $Grid->RowIndex ?>_CONTACT_ADDRESS" value="<?= HtmlEncode($Grid->CONTACT_ADDRESS->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_CV_PASIEN_CONTACT_ADDRESS" class="form-group">
<input type="<?= $Grid->CONTACT_ADDRESS->getInputTextType() ?>" data-table="CV_PASIEN" data-field="x_CONTACT_ADDRESS" name="x<?= $Grid->RowIndex ?>_CONTACT_ADDRESS" id="x<?= $Grid->RowIndex ?>_CONTACT_ADDRESS" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->CONTACT_ADDRESS->getPlaceHolder()) ?>" value="<?= $Grid->CONTACT_ADDRESS->EditValue ?>"<?= $Grid->CONTACT_ADDRESS->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->CONTACT_ADDRESS->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_CV_PASIEN_CONTACT_ADDRESS">
<span<?= $Grid->CONTACT_ADDRESS->viewAttributes() ?>>
<?= $Grid->CONTACT_ADDRESS->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="CV_PASIEN" data-field="x_CONTACT_ADDRESS" data-hidden="1" name="fCV_PASIENgrid$x<?= $Grid->RowIndex ?>_CONTACT_ADDRESS" id="fCV_PASIENgrid$x<?= $Grid->RowIndex ?>_CONTACT_ADDRESS" value="<?= HtmlEncode($Grid->CONTACT_ADDRESS->FormValue) ?>">
<input type="hidden" data-table="CV_PASIEN" data-field="x_CONTACT_ADDRESS" data-hidden="1" name="fCV_PASIENgrid$o<?= $Grid->RowIndex ?>_CONTACT_ADDRESS" id="fCV_PASIENgrid$o<?= $Grid->RowIndex ?>_CONTACT_ADDRESS" value="<?= HtmlEncode($Grid->CONTACT_ADDRESS->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->REGISTRATION_DATE->Visible) { // REGISTRATION_DATE ?>
        <td data-name="REGISTRATION_DATE" <?= $Grid->REGISTRATION_DATE->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_CV_PASIEN_REGISTRATION_DATE" class="form-group">
<input type="<?= $Grid->REGISTRATION_DATE->getInputTextType() ?>" data-table="CV_PASIEN" data-field="x_REGISTRATION_DATE" data-format="11" name="x<?= $Grid->RowIndex ?>_REGISTRATION_DATE" id="x<?= $Grid->RowIndex ?>_REGISTRATION_DATE" placeholder="<?= HtmlEncode($Grid->REGISTRATION_DATE->getPlaceHolder()) ?>" value="<?= $Grid->REGISTRATION_DATE->EditValue ?>"<?= $Grid->REGISTRATION_DATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->REGISTRATION_DATE->getErrorMessage() ?></div>
<?php if (!$Grid->REGISTRATION_DATE->ReadOnly && !$Grid->REGISTRATION_DATE->Disabled && !isset($Grid->REGISTRATION_DATE->EditAttrs["readonly"]) && !isset($Grid->REGISTRATION_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fCV_PASIENgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fCV_PASIENgrid", "x<?= $Grid->RowIndex ?>_REGISTRATION_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":11});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="CV_PASIEN" data-field="x_REGISTRATION_DATE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_REGISTRATION_DATE" id="o<?= $Grid->RowIndex ?>_REGISTRATION_DATE" value="<?= HtmlEncode($Grid->REGISTRATION_DATE->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_CV_PASIEN_REGISTRATION_DATE" class="form-group">
<input type="<?= $Grid->REGISTRATION_DATE->getInputTextType() ?>" data-table="CV_PASIEN" data-field="x_REGISTRATION_DATE" data-format="11" name="x<?= $Grid->RowIndex ?>_REGISTRATION_DATE" id="x<?= $Grid->RowIndex ?>_REGISTRATION_DATE" placeholder="<?= HtmlEncode($Grid->REGISTRATION_DATE->getPlaceHolder()) ?>" value="<?= $Grid->REGISTRATION_DATE->EditValue ?>"<?= $Grid->REGISTRATION_DATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->REGISTRATION_DATE->getErrorMessage() ?></div>
<?php if (!$Grid->REGISTRATION_DATE->ReadOnly && !$Grid->REGISTRATION_DATE->Disabled && !isset($Grid->REGISTRATION_DATE->EditAttrs["readonly"]) && !isset($Grid->REGISTRATION_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fCV_PASIENgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fCV_PASIENgrid", "x<?= $Grid->RowIndex ?>_REGISTRATION_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":11});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_CV_PASIEN_REGISTRATION_DATE">
<span<?= $Grid->REGISTRATION_DATE->viewAttributes() ?>>
<?= $Grid->REGISTRATION_DATE->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="CV_PASIEN" data-field="x_REGISTRATION_DATE" data-hidden="1" name="fCV_PASIENgrid$x<?= $Grid->RowIndex ?>_REGISTRATION_DATE" id="fCV_PASIENgrid$x<?= $Grid->RowIndex ?>_REGISTRATION_DATE" value="<?= HtmlEncode($Grid->REGISTRATION_DATE->FormValue) ?>">
<input type="hidden" data-table="CV_PASIEN" data-field="x_REGISTRATION_DATE" data-hidden="1" name="fCV_PASIENgrid$o<?= $Grid->RowIndex ?>_REGISTRATION_DATE" id="fCV_PASIENgrid$o<?= $Grid->RowIndex ?>_REGISTRATION_DATE" value="<?= HtmlEncode($Grid->REGISTRATION_DATE->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->MOTHER->Visible) { // MOTHER ?>
        <td data-name="MOTHER" <?= $Grid->MOTHER->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_CV_PASIEN_MOTHER" class="form-group">
<input type="<?= $Grid->MOTHER->getInputTextType() ?>" data-table="CV_PASIEN" data-field="x_MOTHER" name="x<?= $Grid->RowIndex ?>_MOTHER" id="x<?= $Grid->RowIndex ?>_MOTHER" size="30" maxlength="150" placeholder="<?= HtmlEncode($Grid->MOTHER->getPlaceHolder()) ?>" value="<?= $Grid->MOTHER->EditValue ?>"<?= $Grid->MOTHER->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->MOTHER->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="CV_PASIEN" data-field="x_MOTHER" data-hidden="1" name="o<?= $Grid->RowIndex ?>_MOTHER" id="o<?= $Grid->RowIndex ?>_MOTHER" value="<?= HtmlEncode($Grid->MOTHER->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_CV_PASIEN_MOTHER" class="form-group">
<input type="<?= $Grid->MOTHER->getInputTextType() ?>" data-table="CV_PASIEN" data-field="x_MOTHER" name="x<?= $Grid->RowIndex ?>_MOTHER" id="x<?= $Grid->RowIndex ?>_MOTHER" size="30" maxlength="150" placeholder="<?= HtmlEncode($Grid->MOTHER->getPlaceHolder()) ?>" value="<?= $Grid->MOTHER->EditValue ?>"<?= $Grid->MOTHER->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->MOTHER->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_CV_PASIEN_MOTHER">
<span<?= $Grid->MOTHER->viewAttributes() ?>>
<?= $Grid->MOTHER->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="CV_PASIEN" data-field="x_MOTHER" data-hidden="1" name="fCV_PASIENgrid$x<?= $Grid->RowIndex ?>_MOTHER" id="fCV_PASIENgrid$x<?= $Grid->RowIndex ?>_MOTHER" value="<?= HtmlEncode($Grid->MOTHER->FormValue) ?>">
<input type="hidden" data-table="CV_PASIEN" data-field="x_MOTHER" data-hidden="1" name="fCV_PASIENgrid$o<?= $Grid->RowIndex ?>_MOTHER" id="fCV_PASIENgrid$o<?= $Grid->RowIndex ?>_MOTHER" value="<?= HtmlEncode($Grid->MOTHER->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->FATHER->Visible) { // FATHER ?>
        <td data-name="FATHER" <?= $Grid->FATHER->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_CV_PASIEN_FATHER" class="form-group">
<input type="<?= $Grid->FATHER->getInputTextType() ?>" data-table="CV_PASIEN" data-field="x_FATHER" name="x<?= $Grid->RowIndex ?>_FATHER" id="x<?= $Grid->RowIndex ?>_FATHER" size="30" maxlength="150" placeholder="<?= HtmlEncode($Grid->FATHER->getPlaceHolder()) ?>" value="<?= $Grid->FATHER->EditValue ?>"<?= $Grid->FATHER->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->FATHER->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="CV_PASIEN" data-field="x_FATHER" data-hidden="1" name="o<?= $Grid->RowIndex ?>_FATHER" id="o<?= $Grid->RowIndex ?>_FATHER" value="<?= HtmlEncode($Grid->FATHER->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_CV_PASIEN_FATHER" class="form-group">
<input type="<?= $Grid->FATHER->getInputTextType() ?>" data-table="CV_PASIEN" data-field="x_FATHER" name="x<?= $Grid->RowIndex ?>_FATHER" id="x<?= $Grid->RowIndex ?>_FATHER" size="30" maxlength="150" placeholder="<?= HtmlEncode($Grid->FATHER->getPlaceHolder()) ?>" value="<?= $Grid->FATHER->EditValue ?>"<?= $Grid->FATHER->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->FATHER->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_CV_PASIEN_FATHER">
<span<?= $Grid->FATHER->viewAttributes() ?>>
<?= $Grid->FATHER->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="CV_PASIEN" data-field="x_FATHER" data-hidden="1" name="fCV_PASIENgrid$x<?= $Grid->RowIndex ?>_FATHER" id="fCV_PASIENgrid$x<?= $Grid->RowIndex ?>_FATHER" value="<?= HtmlEncode($Grid->FATHER->FormValue) ?>">
<input type="hidden" data-table="CV_PASIEN" data-field="x_FATHER" data-hidden="1" name="fCV_PASIENgrid$o<?= $Grid->RowIndex ?>_FATHER" id="fCV_PASIENgrid$o<?= $Grid->RowIndex ?>_FATHER" value="<?= HtmlEncode($Grid->FATHER->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->SPOUSE->Visible) { // SPOUSE ?>
        <td data-name="SPOUSE" <?= $Grid->SPOUSE->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_CV_PASIEN_SPOUSE" class="form-group">
<input type="<?= $Grid->SPOUSE->getInputTextType() ?>" data-table="CV_PASIEN" data-field="x_SPOUSE" name="x<?= $Grid->RowIndex ?>_SPOUSE" id="x<?= $Grid->RowIndex ?>_SPOUSE" size="30" maxlength="150" placeholder="<?= HtmlEncode($Grid->SPOUSE->getPlaceHolder()) ?>" value="<?= $Grid->SPOUSE->EditValue ?>"<?= $Grid->SPOUSE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->SPOUSE->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="CV_PASIEN" data-field="x_SPOUSE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_SPOUSE" id="o<?= $Grid->RowIndex ?>_SPOUSE" value="<?= HtmlEncode($Grid->SPOUSE->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_CV_PASIEN_SPOUSE" class="form-group">
<input type="<?= $Grid->SPOUSE->getInputTextType() ?>" data-table="CV_PASIEN" data-field="x_SPOUSE" name="x<?= $Grid->RowIndex ?>_SPOUSE" id="x<?= $Grid->RowIndex ?>_SPOUSE" size="30" maxlength="150" placeholder="<?= HtmlEncode($Grid->SPOUSE->getPlaceHolder()) ?>" value="<?= $Grid->SPOUSE->EditValue ?>"<?= $Grid->SPOUSE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->SPOUSE->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_CV_PASIEN_SPOUSE">
<span<?= $Grid->SPOUSE->viewAttributes() ?>>
<?= $Grid->SPOUSE->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="CV_PASIEN" data-field="x_SPOUSE" data-hidden="1" name="fCV_PASIENgrid$x<?= $Grid->RowIndex ?>_SPOUSE" id="fCV_PASIENgrid$x<?= $Grid->RowIndex ?>_SPOUSE" value="<?= HtmlEncode($Grid->SPOUSE->FormValue) ?>">
<input type="hidden" data-table="CV_PASIEN" data-field="x_SPOUSE" data-hidden="1" name="fCV_PASIENgrid$o<?= $Grid->RowIndex ?>_SPOUSE" id="fCV_PASIENgrid$o<?= $Grid->RowIndex ?>_SPOUSE" value="<?= HtmlEncode($Grid->SPOUSE->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowCount);
?>
    </tr>
<?php if ($Grid->RowType == ROWTYPE_ADD || $Grid->RowType == ROWTYPE_EDIT) { ?>
<script>
loadjs.ready(["fCV_PASIENgrid","load"], function () {
    fCV_PASIENgrid.updateLists(<?= $Grid->RowIndex ?>);
});
</script>
<?php } ?>
<?php
    }
    } // End delete row checking
    if (!$Grid->isGridAdd() || $Grid->CurrentMode == "copy")
        if (!$Grid->Recordset->EOF) {
            $Grid->Recordset->moveNext();
        }
}
?>
<?php
    if ($Grid->CurrentMode == "add" || $Grid->CurrentMode == "copy" || $Grid->CurrentMode == "edit") {
        $Grid->RowIndex = '$rowindex$';
        $Grid->loadRowValues();

        // Set row properties
        $Grid->resetAttributes();
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_CV_PASIEN", "data-rowtype" => ROWTYPE_ADD]);
        $Grid->RowAttrs->appendClass("ew-template");
        $Grid->RowType = ROWTYPE_ADD;

        // Render row
        $Grid->renderRow();

        // Render list options
        $Grid->renderListOptions();
        $Grid->StartRowCount = 0;
?>
    <tr <?= $Grid->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Grid->ListOptions->render("body", "left", $Grid->RowIndex);
?>
    <?php if ($Grid->NO_REGISTRATION->Visible) { // NO_REGISTRATION ?>
        <td data-name="NO_REGISTRATION">
<?php if (!$Grid->isConfirm()) { ?>
<?php if ($Grid->NO_REGISTRATION->getSessionValue() != "") { ?>
<span id="el$rowindex$_CV_PASIEN_NO_REGISTRATION" class="form-group CV_PASIEN_NO_REGISTRATION">
<span<?= $Grid->NO_REGISTRATION->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->NO_REGISTRATION->getDisplayValue($Grid->NO_REGISTRATION->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" name="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" value="<?= HtmlEncode($Grid->NO_REGISTRATION->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_CV_PASIEN_NO_REGISTRATION" class="form-group CV_PASIEN_NO_REGISTRATION">
<input type="<?= $Grid->NO_REGISTRATION->getInputTextType() ?>" data-table="CV_PASIEN" data-field="x_NO_REGISTRATION" name="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" id="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" size="30" maxlength="25" placeholder="<?= HtmlEncode($Grid->NO_REGISTRATION->getPlaceHolder()) ?>" value="<?= $Grid->NO_REGISTRATION->EditValue ?>"<?= $Grid->NO_REGISTRATION->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->NO_REGISTRATION->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_CV_PASIEN_NO_REGISTRATION" class="form-group CV_PASIEN_NO_REGISTRATION">
<span<?= $Grid->NO_REGISTRATION->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->NO_REGISTRATION->getDisplayValue($Grid->NO_REGISTRATION->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="CV_PASIEN" data-field="x_NO_REGISTRATION" data-hidden="1" name="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" id="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" value="<?= HtmlEncode($Grid->NO_REGISTRATION->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="CV_PASIEN" data-field="x_NO_REGISTRATION" data-hidden="1" name="o<?= $Grid->RowIndex ?>_NO_REGISTRATION" id="o<?= $Grid->RowIndex ?>_NO_REGISTRATION" value="<?= HtmlEncode($Grid->NO_REGISTRATION->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->NAME_OF_PASIEN->Visible) { // NAME_OF_PASIEN ?>
        <td data-name="NAME_OF_PASIEN">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_CV_PASIEN_NAME_OF_PASIEN" class="form-group CV_PASIEN_NAME_OF_PASIEN">
<input type="<?= $Grid->NAME_OF_PASIEN->getInputTextType() ?>" data-table="CV_PASIEN" data-field="x_NAME_OF_PASIEN" name="x<?= $Grid->RowIndex ?>_NAME_OF_PASIEN" id="x<?= $Grid->RowIndex ?>_NAME_OF_PASIEN" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->NAME_OF_PASIEN->getPlaceHolder()) ?>" value="<?= $Grid->NAME_OF_PASIEN->EditValue ?>"<?= $Grid->NAME_OF_PASIEN->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->NAME_OF_PASIEN->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_CV_PASIEN_NAME_OF_PASIEN" class="form-group CV_PASIEN_NAME_OF_PASIEN">
<span<?= $Grid->NAME_OF_PASIEN->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->NAME_OF_PASIEN->getDisplayValue($Grid->NAME_OF_PASIEN->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="CV_PASIEN" data-field="x_NAME_OF_PASIEN" data-hidden="1" name="x<?= $Grid->RowIndex ?>_NAME_OF_PASIEN" id="x<?= $Grid->RowIndex ?>_NAME_OF_PASIEN" value="<?= HtmlEncode($Grid->NAME_OF_PASIEN->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="CV_PASIEN" data-field="x_NAME_OF_PASIEN" data-hidden="1" name="o<?= $Grid->RowIndex ?>_NAME_OF_PASIEN" id="o<?= $Grid->RowIndex ?>_NAME_OF_PASIEN" value="<?= HtmlEncode($Grid->NAME_OF_PASIEN->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->PASIEN_ID->Visible) { // PASIEN_ID ?>
        <td data-name="PASIEN_ID">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_CV_PASIEN_PASIEN_ID" class="form-group CV_PASIEN_PASIEN_ID">
<input type="<?= $Grid->PASIEN_ID->getInputTextType() ?>" data-table="CV_PASIEN" data-field="x_PASIEN_ID" name="x<?= $Grid->RowIndex ?>_PASIEN_ID" id="x<?= $Grid->RowIndex ?>_PASIEN_ID" size="30" maxlength="30" placeholder="<?= HtmlEncode($Grid->PASIEN_ID->getPlaceHolder()) ?>" value="<?= $Grid->PASIEN_ID->EditValue ?>"<?= $Grid->PASIEN_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->PASIEN_ID->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_CV_PASIEN_PASIEN_ID" class="form-group CV_PASIEN_PASIEN_ID">
<span<?= $Grid->PASIEN_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->PASIEN_ID->getDisplayValue($Grid->PASIEN_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="CV_PASIEN" data-field="x_PASIEN_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_PASIEN_ID" id="x<?= $Grid->RowIndex ?>_PASIEN_ID" value="<?= HtmlEncode($Grid->PASIEN_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="CV_PASIEN" data-field="x_PASIEN_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_PASIEN_ID" id="o<?= $Grid->RowIndex ?>_PASIEN_ID" value="<?= HtmlEncode($Grid->PASIEN_ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->KK_NO->Visible) { // KK_NO ?>
        <td data-name="KK_NO">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_CV_PASIEN_KK_NO" class="form-group CV_PASIEN_KK_NO">
<input type="<?= $Grid->KK_NO->getInputTextType() ?>" data-table="CV_PASIEN" data-field="x_KK_NO" name="x<?= $Grid->RowIndex ?>_KK_NO" id="x<?= $Grid->RowIndex ?>_KK_NO" size="30" maxlength="30" placeholder="<?= HtmlEncode($Grid->KK_NO->getPlaceHolder()) ?>" value="<?= $Grid->KK_NO->EditValue ?>"<?= $Grid->KK_NO->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->KK_NO->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_CV_PASIEN_KK_NO" class="form-group CV_PASIEN_KK_NO">
<span<?= $Grid->KK_NO->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->KK_NO->getDisplayValue($Grid->KK_NO->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="CV_PASIEN" data-field="x_KK_NO" data-hidden="1" name="x<?= $Grid->RowIndex ?>_KK_NO" id="x<?= $Grid->RowIndex ?>_KK_NO" value="<?= HtmlEncode($Grid->KK_NO->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="CV_PASIEN" data-field="x_KK_NO" data-hidden="1" name="o<?= $Grid->RowIndex ?>_KK_NO" id="o<?= $Grid->RowIndex ?>_KK_NO" value="<?= HtmlEncode($Grid->KK_NO->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->GENDER->Visible) { // GENDER ?>
        <td data-name="GENDER">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_CV_PASIEN_GENDER" class="form-group CV_PASIEN_GENDER">
<?php
$onchange = $Grid->GENDER->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Grid->GENDER->EditAttrs["onchange"] = "";
?>
<span id="as_x<?= $Grid->RowIndex ?>_GENDER" class="ew-auto-suggest">
    <input type="<?= $Grid->GENDER->getInputTextType() ?>" class="form-control" name="sv_x<?= $Grid->RowIndex ?>_GENDER" id="sv_x<?= $Grid->RowIndex ?>_GENDER" value="<?= RemoveHtml($Grid->GENDER->EditValue) ?>" size="30" maxlength="1" placeholder="<?= HtmlEncode($Grid->GENDER->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Grid->GENDER->getPlaceHolder()) ?>"<?= $Grid->GENDER->editAttributes() ?>>
</span>
<input type="hidden" is="selection-list" class="form-control" data-table="CV_PASIEN" data-field="x_GENDER" data-input="sv_x<?= $Grid->RowIndex ?>_GENDER" data-value-separator="<?= $Grid->GENDER->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_GENDER" id="x<?= $Grid->RowIndex ?>_GENDER" value="<?= HtmlEncode($Grid->GENDER->CurrentValue) ?>"<?= $onchange ?>>
<div class="invalid-feedback"><?= $Grid->GENDER->getErrorMessage() ?></div>
<script>
loadjs.ready(["fCV_PASIENgrid"], function() {
    fCV_PASIENgrid.createAutoSuggest(Object.assign({"id":"x<?= $Grid->RowIndex ?>_GENDER","forceSelect":false}, ew.vars.tables.CV_PASIEN.fields.GENDER.autoSuggestOptions));
});
</script>
<?= $Grid->GENDER->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_GENDER") ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_CV_PASIEN_GENDER" class="form-group CV_PASIEN_GENDER">
<span<?= $Grid->GENDER->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->GENDER->getDisplayValue($Grid->GENDER->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="CV_PASIEN" data-field="x_GENDER" data-hidden="1" name="x<?= $Grid->RowIndex ?>_GENDER" id="x<?= $Grid->RowIndex ?>_GENDER" value="<?= HtmlEncode($Grid->GENDER->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="CV_PASIEN" data-field="x_GENDER" data-hidden="1" name="o<?= $Grid->RowIndex ?>_GENDER" id="o<?= $Grid->RowIndex ?>_GENDER" value="<?= HtmlEncode($Grid->GENDER->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->STATUS_PASIEN_ID->Visible) { // STATUS_PASIEN_ID ?>
        <td data-name="STATUS_PASIEN_ID">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_CV_PASIEN_STATUS_PASIEN_ID" class="form-group CV_PASIEN_STATUS_PASIEN_ID">
    <select
        id="x<?= $Grid->RowIndex ?>_STATUS_PASIEN_ID"
        name="x<?= $Grid->RowIndex ?>_STATUS_PASIEN_ID"
        class="form-control ew-select<?= $Grid->STATUS_PASIEN_ID->isInvalidClass() ?>"
        data-select2-id="CV_PASIEN_x<?= $Grid->RowIndex ?>_STATUS_PASIEN_ID"
        data-table="CV_PASIEN"
        data-field="x_STATUS_PASIEN_ID"
        data-value-separator="<?= $Grid->STATUS_PASIEN_ID->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->STATUS_PASIEN_ID->getPlaceHolder()) ?>"
        <?= $Grid->STATUS_PASIEN_ID->editAttributes() ?>>
        <?= $Grid->STATUS_PASIEN_ID->selectOptionListHtml("x{$Grid->RowIndex}_STATUS_PASIEN_ID") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->STATUS_PASIEN_ID->getErrorMessage() ?></div>
<?= $Grid->STATUS_PASIEN_ID->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_STATUS_PASIEN_ID") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='CV_PASIEN_x<?= $Grid->RowIndex ?>_STATUS_PASIEN_ID']"),
        options = { name: "x<?= $Grid->RowIndex ?>_STATUS_PASIEN_ID", selectId: "CV_PASIEN_x<?= $Grid->RowIndex ?>_STATUS_PASIEN_ID", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.CV_PASIEN.fields.STATUS_PASIEN_ID.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_CV_PASIEN_STATUS_PASIEN_ID" class="form-group CV_PASIEN_STATUS_PASIEN_ID">
<span<?= $Grid->STATUS_PASIEN_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->STATUS_PASIEN_ID->getDisplayValue($Grid->STATUS_PASIEN_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="CV_PASIEN" data-field="x_STATUS_PASIEN_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_STATUS_PASIEN_ID" id="x<?= $Grid->RowIndex ?>_STATUS_PASIEN_ID" value="<?= HtmlEncode($Grid->STATUS_PASIEN_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="CV_PASIEN" data-field="x_STATUS_PASIEN_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_STATUS_PASIEN_ID" id="o<?= $Grid->RowIndex ?>_STATUS_PASIEN_ID" value="<?= HtmlEncode($Grid->STATUS_PASIEN_ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->CONTACT_ADDRESS->Visible) { // CONTACT_ADDRESS ?>
        <td data-name="CONTACT_ADDRESS">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_CV_PASIEN_CONTACT_ADDRESS" class="form-group CV_PASIEN_CONTACT_ADDRESS">
<input type="<?= $Grid->CONTACT_ADDRESS->getInputTextType() ?>" data-table="CV_PASIEN" data-field="x_CONTACT_ADDRESS" name="x<?= $Grid->RowIndex ?>_CONTACT_ADDRESS" id="x<?= $Grid->RowIndex ?>_CONTACT_ADDRESS" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->CONTACT_ADDRESS->getPlaceHolder()) ?>" value="<?= $Grid->CONTACT_ADDRESS->EditValue ?>"<?= $Grid->CONTACT_ADDRESS->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->CONTACT_ADDRESS->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_CV_PASIEN_CONTACT_ADDRESS" class="form-group CV_PASIEN_CONTACT_ADDRESS">
<span<?= $Grid->CONTACT_ADDRESS->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->CONTACT_ADDRESS->getDisplayValue($Grid->CONTACT_ADDRESS->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="CV_PASIEN" data-field="x_CONTACT_ADDRESS" data-hidden="1" name="x<?= $Grid->RowIndex ?>_CONTACT_ADDRESS" id="x<?= $Grid->RowIndex ?>_CONTACT_ADDRESS" value="<?= HtmlEncode($Grid->CONTACT_ADDRESS->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="CV_PASIEN" data-field="x_CONTACT_ADDRESS" data-hidden="1" name="o<?= $Grid->RowIndex ?>_CONTACT_ADDRESS" id="o<?= $Grid->RowIndex ?>_CONTACT_ADDRESS" value="<?= HtmlEncode($Grid->CONTACT_ADDRESS->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->REGISTRATION_DATE->Visible) { // REGISTRATION_DATE ?>
        <td data-name="REGISTRATION_DATE">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_CV_PASIEN_REGISTRATION_DATE" class="form-group CV_PASIEN_REGISTRATION_DATE">
<input type="<?= $Grid->REGISTRATION_DATE->getInputTextType() ?>" data-table="CV_PASIEN" data-field="x_REGISTRATION_DATE" data-format="11" name="x<?= $Grid->RowIndex ?>_REGISTRATION_DATE" id="x<?= $Grid->RowIndex ?>_REGISTRATION_DATE" placeholder="<?= HtmlEncode($Grid->REGISTRATION_DATE->getPlaceHolder()) ?>" value="<?= $Grid->REGISTRATION_DATE->EditValue ?>"<?= $Grid->REGISTRATION_DATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->REGISTRATION_DATE->getErrorMessage() ?></div>
<?php if (!$Grid->REGISTRATION_DATE->ReadOnly && !$Grid->REGISTRATION_DATE->Disabled && !isset($Grid->REGISTRATION_DATE->EditAttrs["readonly"]) && !isset($Grid->REGISTRATION_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fCV_PASIENgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fCV_PASIENgrid", "x<?= $Grid->RowIndex ?>_REGISTRATION_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":11});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_CV_PASIEN_REGISTRATION_DATE" class="form-group CV_PASIEN_REGISTRATION_DATE">
<span<?= $Grid->REGISTRATION_DATE->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->REGISTRATION_DATE->getDisplayValue($Grid->REGISTRATION_DATE->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="CV_PASIEN" data-field="x_REGISTRATION_DATE" data-hidden="1" name="x<?= $Grid->RowIndex ?>_REGISTRATION_DATE" id="x<?= $Grid->RowIndex ?>_REGISTRATION_DATE" value="<?= HtmlEncode($Grid->REGISTRATION_DATE->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="CV_PASIEN" data-field="x_REGISTRATION_DATE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_REGISTRATION_DATE" id="o<?= $Grid->RowIndex ?>_REGISTRATION_DATE" value="<?= HtmlEncode($Grid->REGISTRATION_DATE->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->MOTHER->Visible) { // MOTHER ?>
        <td data-name="MOTHER">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_CV_PASIEN_MOTHER" class="form-group CV_PASIEN_MOTHER">
<input type="<?= $Grid->MOTHER->getInputTextType() ?>" data-table="CV_PASIEN" data-field="x_MOTHER" name="x<?= $Grid->RowIndex ?>_MOTHER" id="x<?= $Grid->RowIndex ?>_MOTHER" size="30" maxlength="150" placeholder="<?= HtmlEncode($Grid->MOTHER->getPlaceHolder()) ?>" value="<?= $Grid->MOTHER->EditValue ?>"<?= $Grid->MOTHER->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->MOTHER->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_CV_PASIEN_MOTHER" class="form-group CV_PASIEN_MOTHER">
<span<?= $Grid->MOTHER->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->MOTHER->getDisplayValue($Grid->MOTHER->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="CV_PASIEN" data-field="x_MOTHER" data-hidden="1" name="x<?= $Grid->RowIndex ?>_MOTHER" id="x<?= $Grid->RowIndex ?>_MOTHER" value="<?= HtmlEncode($Grid->MOTHER->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="CV_PASIEN" data-field="x_MOTHER" data-hidden="1" name="o<?= $Grid->RowIndex ?>_MOTHER" id="o<?= $Grid->RowIndex ?>_MOTHER" value="<?= HtmlEncode($Grid->MOTHER->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->FATHER->Visible) { // FATHER ?>
        <td data-name="FATHER">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_CV_PASIEN_FATHER" class="form-group CV_PASIEN_FATHER">
<input type="<?= $Grid->FATHER->getInputTextType() ?>" data-table="CV_PASIEN" data-field="x_FATHER" name="x<?= $Grid->RowIndex ?>_FATHER" id="x<?= $Grid->RowIndex ?>_FATHER" size="30" maxlength="150" placeholder="<?= HtmlEncode($Grid->FATHER->getPlaceHolder()) ?>" value="<?= $Grid->FATHER->EditValue ?>"<?= $Grid->FATHER->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->FATHER->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_CV_PASIEN_FATHER" class="form-group CV_PASIEN_FATHER">
<span<?= $Grid->FATHER->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->FATHER->getDisplayValue($Grid->FATHER->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="CV_PASIEN" data-field="x_FATHER" data-hidden="1" name="x<?= $Grid->RowIndex ?>_FATHER" id="x<?= $Grid->RowIndex ?>_FATHER" value="<?= HtmlEncode($Grid->FATHER->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="CV_PASIEN" data-field="x_FATHER" data-hidden="1" name="o<?= $Grid->RowIndex ?>_FATHER" id="o<?= $Grid->RowIndex ?>_FATHER" value="<?= HtmlEncode($Grid->FATHER->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->SPOUSE->Visible) { // SPOUSE ?>
        <td data-name="SPOUSE">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_CV_PASIEN_SPOUSE" class="form-group CV_PASIEN_SPOUSE">
<input type="<?= $Grid->SPOUSE->getInputTextType() ?>" data-table="CV_PASIEN" data-field="x_SPOUSE" name="x<?= $Grid->RowIndex ?>_SPOUSE" id="x<?= $Grid->RowIndex ?>_SPOUSE" size="30" maxlength="150" placeholder="<?= HtmlEncode($Grid->SPOUSE->getPlaceHolder()) ?>" value="<?= $Grid->SPOUSE->EditValue ?>"<?= $Grid->SPOUSE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->SPOUSE->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_CV_PASIEN_SPOUSE" class="form-group CV_PASIEN_SPOUSE">
<span<?= $Grid->SPOUSE->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->SPOUSE->getDisplayValue($Grid->SPOUSE->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="CV_PASIEN" data-field="x_SPOUSE" data-hidden="1" name="x<?= $Grid->RowIndex ?>_SPOUSE" id="x<?= $Grid->RowIndex ?>_SPOUSE" value="<?= HtmlEncode($Grid->SPOUSE->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="CV_PASIEN" data-field="x_SPOUSE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_SPOUSE" id="o<?= $Grid->RowIndex ?>_SPOUSE" value="<?= HtmlEncode($Grid->SPOUSE->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["fCV_PASIENgrid","load"], function() {
    fCV_PASIENgrid.updateLists(<?= $Grid->RowIndex ?>);
});
</script>
    </tr>
<?php
    }
?>
</tbody>
</table><!-- /.ew-table -->
</div><!-- /.ew-grid-middle-panel -->
<?php if ($Grid->CurrentMode == "add" || $Grid->CurrentMode == "copy") { ?>
<input type="hidden" name="<?= $Grid->FormKeyCountName ?>" id="<?= $Grid->FormKeyCountName ?>" value="<?= $Grid->KeyCount ?>">
<?= $Grid->MultiSelectKey ?>
<?php } ?>
<?php if ($Grid->CurrentMode == "edit") { ?>
<input type="hidden" name="<?= $Grid->FormKeyCountName ?>" id="<?= $Grid->FormKeyCountName ?>" value="<?= $Grid->KeyCount ?>">
<?= $Grid->MultiSelectKey ?>
<?php } ?>
<?php if ($Grid->CurrentMode == "") { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fCV_PASIENgrid">
</div><!-- /.ew-list-form -->
<?php
// Close recordset
if ($Grid->Recordset) {
    $Grid->Recordset->close();
}
?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($Grid->TotalRecords == 0 && !$Grid->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $Grid->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if (!$Grid->isExport()) { ?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("CV_PASIEN");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
