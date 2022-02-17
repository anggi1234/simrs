<?php

namespace PHPMaker2021\SIMRSSQLSERVER;

// Set up and run Grid object
$Grid = Container("PasienGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fPASIENgrid;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    fPASIENgrid = new ew.Form("fPASIENgrid", "grid");
    fPASIENgrid.formKeyCountName = '<?= $Grid->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "PASIEN")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.PASIEN)
        ew.vars.tables.PASIEN = currentTable;
    fPASIENgrid.addFields([
        ["ORG_UNIT_CODE", [fields.ORG_UNIT_CODE.visible && fields.ORG_UNIT_CODE.required ? ew.Validators.required(fields.ORG_UNIT_CODE.caption) : null], fields.ORG_UNIT_CODE.isInvalid],
        ["NO_REGISTRATION", [fields.NO_REGISTRATION.visible && fields.NO_REGISTRATION.required ? ew.Validators.required(fields.NO_REGISTRATION.caption) : null], fields.NO_REGISTRATION.isInvalid],
        ["NAME_OF_PASIEN", [fields.NAME_OF_PASIEN.visible && fields.NAME_OF_PASIEN.required ? ew.Validators.required(fields.NAME_OF_PASIEN.caption) : null], fields.NAME_OF_PASIEN.isInvalid],
        ["KK_NO", [fields.KK_NO.visible && fields.KK_NO.required ? ew.Validators.required(fields.KK_NO.caption) : null], fields.KK_NO.isInvalid],
        ["GENDER", [fields.GENDER.visible && fields.GENDER.required ? ew.Validators.required(fields.GENDER.caption) : null], fields.GENDER.isInvalid],
        ["STATUS_PASIEN_ID", [fields.STATUS_PASIEN_ID.visible && fields.STATUS_PASIEN_ID.required ? ew.Validators.required(fields.STATUS_PASIEN_ID.caption) : null], fields.STATUS_PASIEN_ID.isInvalid],
        ["REGISTRATION_DATE", [fields.REGISTRATION_DATE.visible && fields.REGISTRATION_DATE.required ? ew.Validators.required(fields.REGISTRATION_DATE.caption) : null], fields.REGISTRATION_DATE.isInvalid],
        ["_PASSWORD", [fields._PASSWORD.visible && fields._PASSWORD.required ? ew.Validators.required(fields._PASSWORD.caption) : null], fields._PASSWORD.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fPASIENgrid,
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
    fPASIENgrid.validate = function () {
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
    fPASIENgrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm();
        if (ew.valueChanged(fobj, rowIndex, "NO_REGISTRATION", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "NAME_OF_PASIEN", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "KK_NO", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "GENDER", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "STATUS_PASIEN_ID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "REGISTRATION_DATE", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "_PASSWORD", false))
            return false;
        return true;
    }

    // Form_CustomValidate
    fPASIENgrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fPASIENgrid.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fPASIENgrid.lists.GENDER = <?= $Grid->GENDER->toClientList($Grid) ?>;
    fPASIENgrid.lists.STATUS_PASIEN_ID = <?= $Grid->STATUS_PASIEN_ID->toClientList($Grid) ?>;
    loadjs.done("fPASIENgrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> PASIEN">
<?php if ($Grid->ShowOtherOptions) { ?>
<div class="card-header ew-grid-upper-panel">
<?php $Grid->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="fPASIENgrid" class="ew-form ew-list-form form-inline">
<div id="gmp_PASIEN" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_PASIENgrid" class="table ew-table"><!-- .ew-table -->
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
<?php if ($Grid->ORG_UNIT_CODE->Visible) { // ORG_UNIT_CODE ?>
        <th data-name="ORG_UNIT_CODE" class="<?= $Grid->ORG_UNIT_CODE->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_PASIEN_ORG_UNIT_CODE" class="PASIEN_ORG_UNIT_CODE"><?= $Grid->renderSort($Grid->ORG_UNIT_CODE) ?></div></th>
<?php } ?>
<?php if ($Grid->NO_REGISTRATION->Visible) { // NO_REGISTRATION ?>
        <th data-name="NO_REGISTRATION" class="<?= $Grid->NO_REGISTRATION->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_PASIEN_NO_REGISTRATION" class="PASIEN_NO_REGISTRATION"><?= $Grid->renderSort($Grid->NO_REGISTRATION) ?></div></th>
<?php } ?>
<?php if ($Grid->NAME_OF_PASIEN->Visible) { // NAME_OF_PASIEN ?>
        <th data-name="NAME_OF_PASIEN" class="<?= $Grid->NAME_OF_PASIEN->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_PASIEN_NAME_OF_PASIEN" class="PASIEN_NAME_OF_PASIEN"><?= $Grid->renderSort($Grid->NAME_OF_PASIEN) ?></div></th>
<?php } ?>
<?php if ($Grid->KK_NO->Visible) { // KK_NO ?>
        <th data-name="KK_NO" class="<?= $Grid->KK_NO->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_PASIEN_KK_NO" class="PASIEN_KK_NO"><?= $Grid->renderSort($Grid->KK_NO) ?></div></th>
<?php } ?>
<?php if ($Grid->GENDER->Visible) { // GENDER ?>
        <th data-name="GENDER" class="<?= $Grid->GENDER->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_PASIEN_GENDER" class="PASIEN_GENDER"><?= $Grid->renderSort($Grid->GENDER) ?></div></th>
<?php } ?>
<?php if ($Grid->STATUS_PASIEN_ID->Visible) { // STATUS_PASIEN_ID ?>
        <th data-name="STATUS_PASIEN_ID" class="<?= $Grid->STATUS_PASIEN_ID->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_PASIEN_STATUS_PASIEN_ID" class="PASIEN_STATUS_PASIEN_ID"><?= $Grid->renderSort($Grid->STATUS_PASIEN_ID) ?></div></th>
<?php } ?>
<?php if ($Grid->REGISTRATION_DATE->Visible) { // REGISTRATION_DATE ?>
        <th data-name="REGISTRATION_DATE" class="<?= $Grid->REGISTRATION_DATE->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_PASIEN_REGISTRATION_DATE" class="PASIEN_REGISTRATION_DATE"><?= $Grid->renderSort($Grid->REGISTRATION_DATE) ?></div></th>
<?php } ?>
<?php if ($Grid->_PASSWORD->Visible) { // PASSWORD ?>
        <th data-name="_PASSWORD" class="<?= $Grid->_PASSWORD->headerCellClass() ?>"><div id="elh_PASIEN__PASSWORD" class="PASIEN__PASSWORD"><?= $Grid->renderSort($Grid->_PASSWORD) ?></div></th>
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowCount, "id" => "r" . $Grid->RowCount . "_PASIEN", "data-rowtype" => $Grid->RowType]);

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
    <?php if ($Grid->ORG_UNIT_CODE->Visible) { // ORG_UNIT_CODE ?>
        <td data-name="ORG_UNIT_CODE" <?= $Grid->ORG_UNIT_CODE->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="PASIEN" data-field="x_ORG_UNIT_CODE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" id="o<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" value="<?= HtmlEncode($Grid->ORG_UNIT_CODE->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_PASIEN_ORG_UNIT_CODE">
<span<?= $Grid->ORG_UNIT_CODE->viewAttributes() ?>>
<?= $Grid->ORG_UNIT_CODE->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="PASIEN" data-field="x_ORG_UNIT_CODE" data-hidden="1" name="fPASIENgrid$x<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" id="fPASIENgrid$x<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" value="<?= HtmlEncode($Grid->ORG_UNIT_CODE->FormValue) ?>">
<input type="hidden" data-table="PASIEN" data-field="x_ORG_UNIT_CODE" data-hidden="1" name="fPASIENgrid$o<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" id="fPASIENgrid$o<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" value="<?= HtmlEncode($Grid->ORG_UNIT_CODE->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="PASIEN" data-field="x_ORG_UNIT_CODE" data-hidden="1" name="x<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" id="x<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" value="<?= HtmlEncode($Grid->ORG_UNIT_CODE->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Grid->NO_REGISTRATION->Visible) { // NO_REGISTRATION ?>
        <td data-name="NO_REGISTRATION" <?= $Grid->NO_REGISTRATION->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_PASIEN_NO_REGISTRATION" class="form-group">
<input type="<?= $Grid->NO_REGISTRATION->getInputTextType() ?>" data-table="PASIEN" data-field="x_NO_REGISTRATION" name="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" id="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" size="30" maxlength="25" placeholder="<?= HtmlEncode($Grid->NO_REGISTRATION->getPlaceHolder()) ?>" value="<?= $Grid->NO_REGISTRATION->EditValue ?>"<?= $Grid->NO_REGISTRATION->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->NO_REGISTRATION->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="PASIEN" data-field="x_NO_REGISTRATION" data-hidden="1" name="o<?= $Grid->RowIndex ?>_NO_REGISTRATION" id="o<?= $Grid->RowIndex ?>_NO_REGISTRATION" value="<?= HtmlEncode($Grid->NO_REGISTRATION->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<input type="<?= $Grid->NO_REGISTRATION->getInputTextType() ?>" data-table="PASIEN" data-field="x_NO_REGISTRATION" name="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" id="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" size="30" maxlength="25" placeholder="<?= HtmlEncode($Grid->NO_REGISTRATION->getPlaceHolder()) ?>" value="<?= $Grid->NO_REGISTRATION->EditValue ?>"<?= $Grid->NO_REGISTRATION->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->NO_REGISTRATION->getErrorMessage() ?></div>
<input type="hidden" data-table="PASIEN" data-field="x_NO_REGISTRATION" data-hidden="1" name="o<?= $Grid->RowIndex ?>_NO_REGISTRATION" id="o<?= $Grid->RowIndex ?>_NO_REGISTRATION" value="<?= HtmlEncode($Grid->NO_REGISTRATION->OldValue ?? $Grid->NO_REGISTRATION->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_PASIEN_NO_REGISTRATION">
<span<?= $Grid->NO_REGISTRATION->viewAttributes() ?>>
<?= $Grid->NO_REGISTRATION->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="PASIEN" data-field="x_NO_REGISTRATION" data-hidden="1" name="fPASIENgrid$x<?= $Grid->RowIndex ?>_NO_REGISTRATION" id="fPASIENgrid$x<?= $Grid->RowIndex ?>_NO_REGISTRATION" value="<?= HtmlEncode($Grid->NO_REGISTRATION->FormValue) ?>">
<input type="hidden" data-table="PASIEN" data-field="x_NO_REGISTRATION" data-hidden="1" name="fPASIENgrid$o<?= $Grid->RowIndex ?>_NO_REGISTRATION" id="fPASIENgrid$o<?= $Grid->RowIndex ?>_NO_REGISTRATION" value="<?= HtmlEncode($Grid->NO_REGISTRATION->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="PASIEN" data-field="x_NO_REGISTRATION" data-hidden="1" name="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" id="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" value="<?= HtmlEncode($Grid->NO_REGISTRATION->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Grid->NAME_OF_PASIEN->Visible) { // NAME_OF_PASIEN ?>
        <td data-name="NAME_OF_PASIEN" <?= $Grid->NAME_OF_PASIEN->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Grid->NAME_OF_PASIEN->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_PASIEN_NAME_OF_PASIEN" class="form-group">
<span<?= $Grid->NAME_OF_PASIEN->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->NAME_OF_PASIEN->getDisplayValue($Grid->NAME_OF_PASIEN->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_NAME_OF_PASIEN" name="x<?= $Grid->RowIndex ?>_NAME_OF_PASIEN" value="<?= HtmlEncode($Grid->NAME_OF_PASIEN->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_PASIEN_NAME_OF_PASIEN" class="form-group">
<input type="<?= $Grid->NAME_OF_PASIEN->getInputTextType() ?>" data-table="PASIEN" data-field="x_NAME_OF_PASIEN" name="x<?= $Grid->RowIndex ?>_NAME_OF_PASIEN" id="x<?= $Grid->RowIndex ?>_NAME_OF_PASIEN" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->NAME_OF_PASIEN->getPlaceHolder()) ?>" value="<?= $Grid->NAME_OF_PASIEN->EditValue ?>"<?= $Grid->NAME_OF_PASIEN->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->NAME_OF_PASIEN->getErrorMessage() ?></div>
</span>
<?php } ?>
<input type="hidden" data-table="PASIEN" data-field="x_NAME_OF_PASIEN" data-hidden="1" name="o<?= $Grid->RowIndex ?>_NAME_OF_PASIEN" id="o<?= $Grid->RowIndex ?>_NAME_OF_PASIEN" value="<?= HtmlEncode($Grid->NAME_OF_PASIEN->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Grid->NAME_OF_PASIEN->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_PASIEN_NAME_OF_PASIEN" class="form-group">
<span<?= $Grid->NAME_OF_PASIEN->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->NAME_OF_PASIEN->getDisplayValue($Grid->NAME_OF_PASIEN->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_NAME_OF_PASIEN" name="x<?= $Grid->RowIndex ?>_NAME_OF_PASIEN" value="<?= HtmlEncode($Grid->NAME_OF_PASIEN->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_PASIEN_NAME_OF_PASIEN" class="form-group">
<input type="<?= $Grid->NAME_OF_PASIEN->getInputTextType() ?>" data-table="PASIEN" data-field="x_NAME_OF_PASIEN" name="x<?= $Grid->RowIndex ?>_NAME_OF_PASIEN" id="x<?= $Grid->RowIndex ?>_NAME_OF_PASIEN" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->NAME_OF_PASIEN->getPlaceHolder()) ?>" value="<?= $Grid->NAME_OF_PASIEN->EditValue ?>"<?= $Grid->NAME_OF_PASIEN->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->NAME_OF_PASIEN->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_PASIEN_NAME_OF_PASIEN">
<span<?= $Grid->NAME_OF_PASIEN->viewAttributes() ?>>
<?= $Grid->NAME_OF_PASIEN->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="PASIEN" data-field="x_NAME_OF_PASIEN" data-hidden="1" name="fPASIENgrid$x<?= $Grid->RowIndex ?>_NAME_OF_PASIEN" id="fPASIENgrid$x<?= $Grid->RowIndex ?>_NAME_OF_PASIEN" value="<?= HtmlEncode($Grid->NAME_OF_PASIEN->FormValue) ?>">
<input type="hidden" data-table="PASIEN" data-field="x_NAME_OF_PASIEN" data-hidden="1" name="fPASIENgrid$o<?= $Grid->RowIndex ?>_NAME_OF_PASIEN" id="fPASIENgrid$o<?= $Grid->RowIndex ?>_NAME_OF_PASIEN" value="<?= HtmlEncode($Grid->NAME_OF_PASIEN->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->KK_NO->Visible) { // KK_NO ?>
        <td data-name="KK_NO" <?= $Grid->KK_NO->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_PASIEN_KK_NO" class="form-group">
<input type="<?= $Grid->KK_NO->getInputTextType() ?>" data-table="PASIEN" data-field="x_KK_NO" name="x<?= $Grid->RowIndex ?>_KK_NO" id="x<?= $Grid->RowIndex ?>_KK_NO" size="30" maxlength="30" placeholder="<?= HtmlEncode($Grid->KK_NO->getPlaceHolder()) ?>" value="<?= $Grid->KK_NO->EditValue ?>"<?= $Grid->KK_NO->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->KK_NO->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="PASIEN" data-field="x_KK_NO" data-hidden="1" name="o<?= $Grid->RowIndex ?>_KK_NO" id="o<?= $Grid->RowIndex ?>_KK_NO" value="<?= HtmlEncode($Grid->KK_NO->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_PASIEN_KK_NO" class="form-group">
<input type="<?= $Grid->KK_NO->getInputTextType() ?>" data-table="PASIEN" data-field="x_KK_NO" name="x<?= $Grid->RowIndex ?>_KK_NO" id="x<?= $Grid->RowIndex ?>_KK_NO" size="30" maxlength="30" placeholder="<?= HtmlEncode($Grid->KK_NO->getPlaceHolder()) ?>" value="<?= $Grid->KK_NO->EditValue ?>"<?= $Grid->KK_NO->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->KK_NO->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_PASIEN_KK_NO">
<span<?= $Grid->KK_NO->viewAttributes() ?>>
<?= $Grid->KK_NO->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="PASIEN" data-field="x_KK_NO" data-hidden="1" name="fPASIENgrid$x<?= $Grid->RowIndex ?>_KK_NO" id="fPASIENgrid$x<?= $Grid->RowIndex ?>_KK_NO" value="<?= HtmlEncode($Grid->KK_NO->FormValue) ?>">
<input type="hidden" data-table="PASIEN" data-field="x_KK_NO" data-hidden="1" name="fPASIENgrid$o<?= $Grid->RowIndex ?>_KK_NO" id="fPASIENgrid$o<?= $Grid->RowIndex ?>_KK_NO" value="<?= HtmlEncode($Grid->KK_NO->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->GENDER->Visible) { // GENDER ?>
        <td data-name="GENDER" <?= $Grid->GENDER->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_PASIEN_GENDER" class="form-group">
<template id="tp_x<?= $Grid->RowIndex ?>_GENDER">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="PASIEN" data-field="x_GENDER" name="x<?= $Grid->RowIndex ?>_GENDER" id="x<?= $Grid->RowIndex ?>_GENDER"<?= $Grid->GENDER->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_GENDER" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x<?= $Grid->RowIndex ?>_GENDER"
    name="x<?= $Grid->RowIndex ?>_GENDER"
    value="<?= HtmlEncode($Grid->GENDER->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_GENDER"
    data-target="dsl_x<?= $Grid->RowIndex ?>_GENDER"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->GENDER->isInvalidClass() ?>"
    data-table="PASIEN"
    data-field="x_GENDER"
    data-value-separator="<?= $Grid->GENDER->displayValueSeparatorAttribute() ?>"
    <?= $Grid->GENDER->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->GENDER->getErrorMessage() ?></div>
<?= $Grid->GENDER->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_GENDER") ?>
</span>
<input type="hidden" data-table="PASIEN" data-field="x_GENDER" data-hidden="1" name="o<?= $Grid->RowIndex ?>_GENDER" id="o<?= $Grid->RowIndex ?>_GENDER" value="<?= HtmlEncode($Grid->GENDER->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_PASIEN_GENDER" class="form-group">
<template id="tp_x<?= $Grid->RowIndex ?>_GENDER">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="PASIEN" data-field="x_GENDER" name="x<?= $Grid->RowIndex ?>_GENDER" id="x<?= $Grid->RowIndex ?>_GENDER"<?= $Grid->GENDER->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_GENDER" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x<?= $Grid->RowIndex ?>_GENDER"
    name="x<?= $Grid->RowIndex ?>_GENDER"
    value="<?= HtmlEncode($Grid->GENDER->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_GENDER"
    data-target="dsl_x<?= $Grid->RowIndex ?>_GENDER"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->GENDER->isInvalidClass() ?>"
    data-table="PASIEN"
    data-field="x_GENDER"
    data-value-separator="<?= $Grid->GENDER->displayValueSeparatorAttribute() ?>"
    <?= $Grid->GENDER->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->GENDER->getErrorMessage() ?></div>
<?= $Grid->GENDER->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_GENDER") ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_PASIEN_GENDER">
<span<?= $Grid->GENDER->viewAttributes() ?>>
<?= $Grid->GENDER->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="PASIEN" data-field="x_GENDER" data-hidden="1" name="fPASIENgrid$x<?= $Grid->RowIndex ?>_GENDER" id="fPASIENgrid$x<?= $Grid->RowIndex ?>_GENDER" value="<?= HtmlEncode($Grid->GENDER->FormValue) ?>">
<input type="hidden" data-table="PASIEN" data-field="x_GENDER" data-hidden="1" name="fPASIENgrid$o<?= $Grid->RowIndex ?>_GENDER" id="fPASIENgrid$o<?= $Grid->RowIndex ?>_GENDER" value="<?= HtmlEncode($Grid->GENDER->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->STATUS_PASIEN_ID->Visible) { // STATUS_PASIEN_ID ?>
        <td data-name="STATUS_PASIEN_ID" <?= $Grid->STATUS_PASIEN_ID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_PASIEN_STATUS_PASIEN_ID" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_STATUS_PASIEN_ID"
        name="x<?= $Grid->RowIndex ?>_STATUS_PASIEN_ID"
        class="form-control ew-select<?= $Grid->STATUS_PASIEN_ID->isInvalidClass() ?>"
        data-select2-id="PASIEN_x<?= $Grid->RowIndex ?>_STATUS_PASIEN_ID"
        data-table="PASIEN"
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
    var el = document.querySelector("select[data-select2-id='PASIEN_x<?= $Grid->RowIndex ?>_STATUS_PASIEN_ID']"),
        options = { name: "x<?= $Grid->RowIndex ?>_STATUS_PASIEN_ID", selectId: "PASIEN_x<?= $Grid->RowIndex ?>_STATUS_PASIEN_ID", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.PASIEN.fields.STATUS_PASIEN_ID.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="PASIEN" data-field="x_STATUS_PASIEN_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_STATUS_PASIEN_ID" id="o<?= $Grid->RowIndex ?>_STATUS_PASIEN_ID" value="<?= HtmlEncode($Grid->STATUS_PASIEN_ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_PASIEN_STATUS_PASIEN_ID" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_STATUS_PASIEN_ID"
        name="x<?= $Grid->RowIndex ?>_STATUS_PASIEN_ID"
        class="form-control ew-select<?= $Grid->STATUS_PASIEN_ID->isInvalidClass() ?>"
        data-select2-id="PASIEN_x<?= $Grid->RowIndex ?>_STATUS_PASIEN_ID"
        data-table="PASIEN"
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
    var el = document.querySelector("select[data-select2-id='PASIEN_x<?= $Grid->RowIndex ?>_STATUS_PASIEN_ID']"),
        options = { name: "x<?= $Grid->RowIndex ?>_STATUS_PASIEN_ID", selectId: "PASIEN_x<?= $Grid->RowIndex ?>_STATUS_PASIEN_ID", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.PASIEN.fields.STATUS_PASIEN_ID.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_PASIEN_STATUS_PASIEN_ID">
<span<?= $Grid->STATUS_PASIEN_ID->viewAttributes() ?>>
<?= $Grid->STATUS_PASIEN_ID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="PASIEN" data-field="x_STATUS_PASIEN_ID" data-hidden="1" name="fPASIENgrid$x<?= $Grid->RowIndex ?>_STATUS_PASIEN_ID" id="fPASIENgrid$x<?= $Grid->RowIndex ?>_STATUS_PASIEN_ID" value="<?= HtmlEncode($Grid->STATUS_PASIEN_ID->FormValue) ?>">
<input type="hidden" data-table="PASIEN" data-field="x_STATUS_PASIEN_ID" data-hidden="1" name="fPASIENgrid$o<?= $Grid->RowIndex ?>_STATUS_PASIEN_ID" id="fPASIENgrid$o<?= $Grid->RowIndex ?>_STATUS_PASIEN_ID" value="<?= HtmlEncode($Grid->STATUS_PASIEN_ID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->REGISTRATION_DATE->Visible) { // REGISTRATION_DATE ?>
        <td data-name="REGISTRATION_DATE" <?= $Grid->REGISTRATION_DATE->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_PASIEN_REGISTRATION_DATE" class="form-group">
<input type="<?= $Grid->REGISTRATION_DATE->getInputTextType() ?>" data-table="PASIEN" data-field="x_REGISTRATION_DATE" name="x<?= $Grid->RowIndex ?>_REGISTRATION_DATE" id="x<?= $Grid->RowIndex ?>_REGISTRATION_DATE" placeholder="<?= HtmlEncode($Grid->REGISTRATION_DATE->getPlaceHolder()) ?>" value="<?= $Grid->REGISTRATION_DATE->EditValue ?>"<?= $Grid->REGISTRATION_DATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->REGISTRATION_DATE->getErrorMessage() ?></div>
<?php if (!$Grid->REGISTRATION_DATE->ReadOnly && !$Grid->REGISTRATION_DATE->Disabled && !isset($Grid->REGISTRATION_DATE->EditAttrs["readonly"]) && !isset($Grid->REGISTRATION_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fPASIENgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fPASIENgrid", "x<?= $Grid->RowIndex ?>_REGISTRATION_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="PASIEN" data-field="x_REGISTRATION_DATE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_REGISTRATION_DATE" id="o<?= $Grid->RowIndex ?>_REGISTRATION_DATE" value="<?= HtmlEncode($Grid->REGISTRATION_DATE->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_PASIEN_REGISTRATION_DATE" class="form-group">
<span<?= $Grid->REGISTRATION_DATE->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->REGISTRATION_DATE->getDisplayValue($Grid->REGISTRATION_DATE->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="PASIEN" data-field="x_REGISTRATION_DATE" data-hidden="1" name="x<?= $Grid->RowIndex ?>_REGISTRATION_DATE" id="x<?= $Grid->RowIndex ?>_REGISTRATION_DATE" value="<?= HtmlEncode($Grid->REGISTRATION_DATE->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_PASIEN_REGISTRATION_DATE">
<span<?= $Grid->REGISTRATION_DATE->viewAttributes() ?>>
<?= $Grid->REGISTRATION_DATE->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="PASIEN" data-field="x_REGISTRATION_DATE" data-hidden="1" name="fPASIENgrid$x<?= $Grid->RowIndex ?>_REGISTRATION_DATE" id="fPASIENgrid$x<?= $Grid->RowIndex ?>_REGISTRATION_DATE" value="<?= HtmlEncode($Grid->REGISTRATION_DATE->FormValue) ?>">
<input type="hidden" data-table="PASIEN" data-field="x_REGISTRATION_DATE" data-hidden="1" name="fPASIENgrid$o<?= $Grid->RowIndex ?>_REGISTRATION_DATE" id="fPASIENgrid$o<?= $Grid->RowIndex ?>_REGISTRATION_DATE" value="<?= HtmlEncode($Grid->REGISTRATION_DATE->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->_PASSWORD->Visible) { // PASSWORD ?>
        <td data-name="_PASSWORD" <?= $Grid->_PASSWORD->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_PASIEN__PASSWORD" class="form-group">
<input type="<?= $Grid->_PASSWORD->getInputTextType() ?>" data-table="PASIEN" data-field="x__PASSWORD" name="x<?= $Grid->RowIndex ?>__PASSWORD" id="x<?= $Grid->RowIndex ?>__PASSWORD" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->_PASSWORD->getPlaceHolder()) ?>" value="<?= $Grid->_PASSWORD->EditValue ?>"<?= $Grid->_PASSWORD->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->_PASSWORD->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="PASIEN" data-field="x__PASSWORD" data-hidden="1" name="o<?= $Grid->RowIndex ?>__PASSWORD" id="o<?= $Grid->RowIndex ?>__PASSWORD" value="<?= HtmlEncode($Grid->_PASSWORD->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_PASIEN__PASSWORD" class="form-group">
<input type="<?= $Grid->_PASSWORD->getInputTextType() ?>" data-table="PASIEN" data-field="x__PASSWORD" name="x<?= $Grid->RowIndex ?>__PASSWORD" id="x<?= $Grid->RowIndex ?>__PASSWORD" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->_PASSWORD->getPlaceHolder()) ?>" value="<?= $Grid->_PASSWORD->EditValue ?>"<?= $Grid->_PASSWORD->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->_PASSWORD->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_PASIEN__PASSWORD">
<span<?= $Grid->_PASSWORD->viewAttributes() ?>>
<?= $Grid->_PASSWORD->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="PASIEN" data-field="x__PASSWORD" data-hidden="1" name="fPASIENgrid$x<?= $Grid->RowIndex ?>__PASSWORD" id="fPASIENgrid$x<?= $Grid->RowIndex ?>__PASSWORD" value="<?= HtmlEncode($Grid->_PASSWORD->FormValue) ?>">
<input type="hidden" data-table="PASIEN" data-field="x__PASSWORD" data-hidden="1" name="fPASIENgrid$o<?= $Grid->RowIndex ?>__PASSWORD" id="fPASIENgrid$o<?= $Grid->RowIndex ?>__PASSWORD" value="<?= HtmlEncode($Grid->_PASSWORD->OldValue) ?>">
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
loadjs.ready(["fPASIENgrid","load"], function () {
    fPASIENgrid.updateLists(<?= $Grid->RowIndex ?>);
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_PASIEN", "data-rowtype" => ROWTYPE_ADD]);
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
    <?php if ($Grid->ORG_UNIT_CODE->Visible) { // ORG_UNIT_CODE ?>
        <td data-name="ORG_UNIT_CODE">
<?php if (!$Grid->isConfirm()) { ?>
<?php } else { ?>
<input type="hidden" data-table="PASIEN" data-field="x_ORG_UNIT_CODE" data-hidden="1" name="x<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" id="x<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" value="<?= HtmlEncode($Grid->ORG_UNIT_CODE->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="PASIEN" data-field="x_ORG_UNIT_CODE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" id="o<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" value="<?= HtmlEncode($Grid->ORG_UNIT_CODE->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->NO_REGISTRATION->Visible) { // NO_REGISTRATION ?>
        <td data-name="NO_REGISTRATION">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_PASIEN_NO_REGISTRATION" class="form-group PASIEN_NO_REGISTRATION">
<input type="<?= $Grid->NO_REGISTRATION->getInputTextType() ?>" data-table="PASIEN" data-field="x_NO_REGISTRATION" name="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" id="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" size="30" maxlength="25" placeholder="<?= HtmlEncode($Grid->NO_REGISTRATION->getPlaceHolder()) ?>" value="<?= $Grid->NO_REGISTRATION->EditValue ?>"<?= $Grid->NO_REGISTRATION->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->NO_REGISTRATION->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_PASIEN_NO_REGISTRATION" class="form-group PASIEN_NO_REGISTRATION">
<span<?= $Grid->NO_REGISTRATION->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->NO_REGISTRATION->getDisplayValue($Grid->NO_REGISTRATION->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="PASIEN" data-field="x_NO_REGISTRATION" data-hidden="1" name="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" id="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" value="<?= HtmlEncode($Grid->NO_REGISTRATION->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="PASIEN" data-field="x_NO_REGISTRATION" data-hidden="1" name="o<?= $Grid->RowIndex ?>_NO_REGISTRATION" id="o<?= $Grid->RowIndex ?>_NO_REGISTRATION" value="<?= HtmlEncode($Grid->NO_REGISTRATION->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->NAME_OF_PASIEN->Visible) { // NAME_OF_PASIEN ?>
        <td data-name="NAME_OF_PASIEN">
<?php if (!$Grid->isConfirm()) { ?>
<?php if ($Grid->NAME_OF_PASIEN->getSessionValue() != "") { ?>
<span id="el$rowindex$_PASIEN_NAME_OF_PASIEN" class="form-group PASIEN_NAME_OF_PASIEN">
<span<?= $Grid->NAME_OF_PASIEN->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->NAME_OF_PASIEN->getDisplayValue($Grid->NAME_OF_PASIEN->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_NAME_OF_PASIEN" name="x<?= $Grid->RowIndex ?>_NAME_OF_PASIEN" value="<?= HtmlEncode($Grid->NAME_OF_PASIEN->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_PASIEN_NAME_OF_PASIEN" class="form-group PASIEN_NAME_OF_PASIEN">
<input type="<?= $Grid->NAME_OF_PASIEN->getInputTextType() ?>" data-table="PASIEN" data-field="x_NAME_OF_PASIEN" name="x<?= $Grid->RowIndex ?>_NAME_OF_PASIEN" id="x<?= $Grid->RowIndex ?>_NAME_OF_PASIEN" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->NAME_OF_PASIEN->getPlaceHolder()) ?>" value="<?= $Grid->NAME_OF_PASIEN->EditValue ?>"<?= $Grid->NAME_OF_PASIEN->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->NAME_OF_PASIEN->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_PASIEN_NAME_OF_PASIEN" class="form-group PASIEN_NAME_OF_PASIEN">
<span<?= $Grid->NAME_OF_PASIEN->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->NAME_OF_PASIEN->getDisplayValue($Grid->NAME_OF_PASIEN->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="PASIEN" data-field="x_NAME_OF_PASIEN" data-hidden="1" name="x<?= $Grid->RowIndex ?>_NAME_OF_PASIEN" id="x<?= $Grid->RowIndex ?>_NAME_OF_PASIEN" value="<?= HtmlEncode($Grid->NAME_OF_PASIEN->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="PASIEN" data-field="x_NAME_OF_PASIEN" data-hidden="1" name="o<?= $Grid->RowIndex ?>_NAME_OF_PASIEN" id="o<?= $Grid->RowIndex ?>_NAME_OF_PASIEN" value="<?= HtmlEncode($Grid->NAME_OF_PASIEN->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->KK_NO->Visible) { // KK_NO ?>
        <td data-name="KK_NO">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_PASIEN_KK_NO" class="form-group PASIEN_KK_NO">
<input type="<?= $Grid->KK_NO->getInputTextType() ?>" data-table="PASIEN" data-field="x_KK_NO" name="x<?= $Grid->RowIndex ?>_KK_NO" id="x<?= $Grid->RowIndex ?>_KK_NO" size="30" maxlength="30" placeholder="<?= HtmlEncode($Grid->KK_NO->getPlaceHolder()) ?>" value="<?= $Grid->KK_NO->EditValue ?>"<?= $Grid->KK_NO->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->KK_NO->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_PASIEN_KK_NO" class="form-group PASIEN_KK_NO">
<span<?= $Grid->KK_NO->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->KK_NO->getDisplayValue($Grid->KK_NO->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="PASIEN" data-field="x_KK_NO" data-hidden="1" name="x<?= $Grid->RowIndex ?>_KK_NO" id="x<?= $Grid->RowIndex ?>_KK_NO" value="<?= HtmlEncode($Grid->KK_NO->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="PASIEN" data-field="x_KK_NO" data-hidden="1" name="o<?= $Grid->RowIndex ?>_KK_NO" id="o<?= $Grid->RowIndex ?>_KK_NO" value="<?= HtmlEncode($Grid->KK_NO->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->GENDER->Visible) { // GENDER ?>
        <td data-name="GENDER">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_PASIEN_GENDER" class="form-group PASIEN_GENDER">
<template id="tp_x<?= $Grid->RowIndex ?>_GENDER">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="PASIEN" data-field="x_GENDER" name="x<?= $Grid->RowIndex ?>_GENDER" id="x<?= $Grid->RowIndex ?>_GENDER"<?= $Grid->GENDER->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_GENDER" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x<?= $Grid->RowIndex ?>_GENDER"
    name="x<?= $Grid->RowIndex ?>_GENDER"
    value="<?= HtmlEncode($Grid->GENDER->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_GENDER"
    data-target="dsl_x<?= $Grid->RowIndex ?>_GENDER"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->GENDER->isInvalidClass() ?>"
    data-table="PASIEN"
    data-field="x_GENDER"
    data-value-separator="<?= $Grid->GENDER->displayValueSeparatorAttribute() ?>"
    <?= $Grid->GENDER->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->GENDER->getErrorMessage() ?></div>
<?= $Grid->GENDER->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_GENDER") ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_PASIEN_GENDER" class="form-group PASIEN_GENDER">
<span<?= $Grid->GENDER->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->GENDER->getDisplayValue($Grid->GENDER->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="PASIEN" data-field="x_GENDER" data-hidden="1" name="x<?= $Grid->RowIndex ?>_GENDER" id="x<?= $Grid->RowIndex ?>_GENDER" value="<?= HtmlEncode($Grid->GENDER->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="PASIEN" data-field="x_GENDER" data-hidden="1" name="o<?= $Grid->RowIndex ?>_GENDER" id="o<?= $Grid->RowIndex ?>_GENDER" value="<?= HtmlEncode($Grid->GENDER->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->STATUS_PASIEN_ID->Visible) { // STATUS_PASIEN_ID ?>
        <td data-name="STATUS_PASIEN_ID">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_PASIEN_STATUS_PASIEN_ID" class="form-group PASIEN_STATUS_PASIEN_ID">
    <select
        id="x<?= $Grid->RowIndex ?>_STATUS_PASIEN_ID"
        name="x<?= $Grid->RowIndex ?>_STATUS_PASIEN_ID"
        class="form-control ew-select<?= $Grid->STATUS_PASIEN_ID->isInvalidClass() ?>"
        data-select2-id="PASIEN_x<?= $Grid->RowIndex ?>_STATUS_PASIEN_ID"
        data-table="PASIEN"
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
    var el = document.querySelector("select[data-select2-id='PASIEN_x<?= $Grid->RowIndex ?>_STATUS_PASIEN_ID']"),
        options = { name: "x<?= $Grid->RowIndex ?>_STATUS_PASIEN_ID", selectId: "PASIEN_x<?= $Grid->RowIndex ?>_STATUS_PASIEN_ID", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.PASIEN.fields.STATUS_PASIEN_ID.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_PASIEN_STATUS_PASIEN_ID" class="form-group PASIEN_STATUS_PASIEN_ID">
<span<?= $Grid->STATUS_PASIEN_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->STATUS_PASIEN_ID->getDisplayValue($Grid->STATUS_PASIEN_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="PASIEN" data-field="x_STATUS_PASIEN_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_STATUS_PASIEN_ID" id="x<?= $Grid->RowIndex ?>_STATUS_PASIEN_ID" value="<?= HtmlEncode($Grid->STATUS_PASIEN_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="PASIEN" data-field="x_STATUS_PASIEN_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_STATUS_PASIEN_ID" id="o<?= $Grid->RowIndex ?>_STATUS_PASIEN_ID" value="<?= HtmlEncode($Grid->STATUS_PASIEN_ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->REGISTRATION_DATE->Visible) { // REGISTRATION_DATE ?>
        <td data-name="REGISTRATION_DATE">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_PASIEN_REGISTRATION_DATE" class="form-group PASIEN_REGISTRATION_DATE">
<input type="<?= $Grid->REGISTRATION_DATE->getInputTextType() ?>" data-table="PASIEN" data-field="x_REGISTRATION_DATE" name="x<?= $Grid->RowIndex ?>_REGISTRATION_DATE" id="x<?= $Grid->RowIndex ?>_REGISTRATION_DATE" placeholder="<?= HtmlEncode($Grid->REGISTRATION_DATE->getPlaceHolder()) ?>" value="<?= $Grid->REGISTRATION_DATE->EditValue ?>"<?= $Grid->REGISTRATION_DATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->REGISTRATION_DATE->getErrorMessage() ?></div>
<?php if (!$Grid->REGISTRATION_DATE->ReadOnly && !$Grid->REGISTRATION_DATE->Disabled && !isset($Grid->REGISTRATION_DATE->EditAttrs["readonly"]) && !isset($Grid->REGISTRATION_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fPASIENgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fPASIENgrid", "x<?= $Grid->RowIndex ?>_REGISTRATION_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_PASIEN_REGISTRATION_DATE" class="form-group PASIEN_REGISTRATION_DATE">
<span<?= $Grid->REGISTRATION_DATE->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->REGISTRATION_DATE->getDisplayValue($Grid->REGISTRATION_DATE->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="PASIEN" data-field="x_REGISTRATION_DATE" data-hidden="1" name="x<?= $Grid->RowIndex ?>_REGISTRATION_DATE" id="x<?= $Grid->RowIndex ?>_REGISTRATION_DATE" value="<?= HtmlEncode($Grid->REGISTRATION_DATE->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="PASIEN" data-field="x_REGISTRATION_DATE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_REGISTRATION_DATE" id="o<?= $Grid->RowIndex ?>_REGISTRATION_DATE" value="<?= HtmlEncode($Grid->REGISTRATION_DATE->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->_PASSWORD->Visible) { // PASSWORD ?>
        <td data-name="_PASSWORD">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_PASIEN__PASSWORD" class="form-group PASIEN__PASSWORD">
<input type="<?= $Grid->_PASSWORD->getInputTextType() ?>" data-table="PASIEN" data-field="x__PASSWORD" name="x<?= $Grid->RowIndex ?>__PASSWORD" id="x<?= $Grid->RowIndex ?>__PASSWORD" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->_PASSWORD->getPlaceHolder()) ?>" value="<?= $Grid->_PASSWORD->EditValue ?>"<?= $Grid->_PASSWORD->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->_PASSWORD->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_PASIEN__PASSWORD" class="form-group PASIEN__PASSWORD">
<span<?= $Grid->_PASSWORD->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->_PASSWORD->getDisplayValue($Grid->_PASSWORD->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="PASIEN" data-field="x__PASSWORD" data-hidden="1" name="x<?= $Grid->RowIndex ?>__PASSWORD" id="x<?= $Grid->RowIndex ?>__PASSWORD" value="<?= HtmlEncode($Grid->_PASSWORD->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="PASIEN" data-field="x__PASSWORD" data-hidden="1" name="o<?= $Grid->RowIndex ?>__PASSWORD" id="o<?= $Grid->RowIndex ?>__PASSWORD" value="<?= HtmlEncode($Grid->_PASSWORD->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["fPASIENgrid","load"], function() {
    fPASIENgrid.updateLists(<?= $Grid->RowIndex ?>);
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
<input type="hidden" name="detailpage" value="fPASIENgrid">
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
    ew.addEventHandlers("PASIEN");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
