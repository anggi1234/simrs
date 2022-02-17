<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAJALALTER;

// Set up and run Grid object
$Grid = Container("PasienDiagnosaGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fPASIEN_DIAGNOSAgrid;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    fPASIEN_DIAGNOSAgrid = new ew.Form("fPASIEN_DIAGNOSAgrid", "grid");
    fPASIEN_DIAGNOSAgrid.formKeyCountName = '<?= $Grid->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "PASIEN_DIAGNOSA")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.PASIEN_DIAGNOSA)
        ew.vars.tables.PASIEN_DIAGNOSA = currentTable;
    fPASIEN_DIAGNOSAgrid.addFields([
        ["NO_REGISTRATION", [fields.NO_REGISTRATION.visible && fields.NO_REGISTRATION.required ? ew.Validators.required(fields.NO_REGISTRATION.caption) : null], fields.NO_REGISTRATION.isInvalid],
        ["THENAME", [fields.THENAME.visible && fields.THENAME.required ? ew.Validators.required(fields.THENAME.caption) : null], fields.THENAME.isInvalid],
        ["VISIT_ID", [fields.VISIT_ID.visible && fields.VISIT_ID.required ? ew.Validators.required(fields.VISIT_ID.caption) : null], fields.VISIT_ID.isInvalid],
        ["DATE_OF_DIAGNOSA", [fields.DATE_OF_DIAGNOSA.visible && fields.DATE_OF_DIAGNOSA.required ? ew.Validators.required(fields.DATE_OF_DIAGNOSA.caption) : null, ew.Validators.datetime(11)], fields.DATE_OF_DIAGNOSA.isInvalid],
        ["DIAGNOSA_ID", [fields.DIAGNOSA_ID.visible && fields.DIAGNOSA_ID.required ? ew.Validators.required(fields.DIAGNOSA_ID.caption) : null], fields.DIAGNOSA_ID.isInvalid],
        ["DIAGNOSA_DESC", [fields.DIAGNOSA_DESC.visible && fields.DIAGNOSA_DESC.required ? ew.Validators.required(fields.DIAGNOSA_DESC.caption) : null], fields.DIAGNOSA_DESC.isInvalid],
        ["ANAMNASE", [fields.ANAMNASE.visible && fields.ANAMNASE.required ? ew.Validators.required(fields.ANAMNASE.caption) : null], fields.ANAMNASE.isInvalid],
        ["PEMERIKSAAN", [fields.PEMERIKSAAN.visible && fields.PEMERIKSAAN.required ? ew.Validators.required(fields.PEMERIKSAAN.caption) : null], fields.PEMERIKSAAN.isInvalid],
        ["TERAPHY_DESC", [fields.TERAPHY_DESC.visible && fields.TERAPHY_DESC.required ? ew.Validators.required(fields.TERAPHY_DESC.caption) : null], fields.TERAPHY_DESC.isInvalid],
        ["INSTRUCTION", [fields.INSTRUCTION.visible && fields.INSTRUCTION.required ? ew.Validators.required(fields.INSTRUCTION.caption) : null], fields.INSTRUCTION.isInvalid],
        ["THEADDRESS", [fields.THEADDRESS.visible && fields.THEADDRESS.required ? ew.Validators.required(fields.THEADDRESS.caption) : null], fields.THEADDRESS.isInvalid],
        ["THEID", [fields.THEID.visible && fields.THEID.required ? ew.Validators.required(fields.THEID.caption) : null], fields.THEID.isInvalid],
        ["GENDER", [fields.GENDER.visible && fields.GENDER.required ? ew.Validators.required(fields.GENDER.caption) : null], fields.GENDER.isInvalid],
        ["TGLKONTROL", [fields.TGLKONTROL.visible && fields.TGLKONTROL.required ? ew.Validators.required(fields.TGLKONTROL.caption) : null, ew.Validators.datetime(0)], fields.TGLKONTROL.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fPASIEN_DIAGNOSAgrid,
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
    fPASIEN_DIAGNOSAgrid.validate = function () {
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
    fPASIEN_DIAGNOSAgrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm();
        if (ew.valueChanged(fobj, rowIndex, "NO_REGISTRATION", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "THENAME", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "VISIT_ID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "DATE_OF_DIAGNOSA", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "DIAGNOSA_ID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "DIAGNOSA_DESC", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "ANAMNASE", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "PEMERIKSAAN", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "TERAPHY_DESC", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "INSTRUCTION", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "THEADDRESS", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "THEID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "GENDER", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "TGLKONTROL", false))
            return false;
        return true;
    }

    // Form_CustomValidate
    fPASIEN_DIAGNOSAgrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fPASIEN_DIAGNOSAgrid.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fPASIEN_DIAGNOSAgrid.lists.NO_REGISTRATION = <?= $Grid->NO_REGISTRATION->toClientList($Grid) ?>;
    fPASIEN_DIAGNOSAgrid.lists.DIAGNOSA_ID = <?= $Grid->DIAGNOSA_ID->toClientList($Grid) ?>;
    fPASIEN_DIAGNOSAgrid.lists.GENDER = <?= $Grid->GENDER->toClientList($Grid) ?>;
    loadjs.done("fPASIEN_DIAGNOSAgrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> PASIEN_DIAGNOSA">
<?php if ($Grid->ShowOtherOptions) { ?>
<div class="card-header ew-grid-upper-panel">
<?php $Grid->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="fPASIEN_DIAGNOSAgrid" class="ew-form ew-list-form form-inline">
<div id="gmp_PASIEN_DIAGNOSA" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_PASIEN_DIAGNOSAgrid" class="table ew-table"><!-- .ew-table -->
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
        <th data-name="NO_REGISTRATION" class="<?= $Grid->NO_REGISTRATION->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_PASIEN_DIAGNOSA_NO_REGISTRATION" class="PASIEN_DIAGNOSA_NO_REGISTRATION"><?= $Grid->renderSort($Grid->NO_REGISTRATION) ?></div></th>
<?php } ?>
<?php if ($Grid->THENAME->Visible) { // THENAME ?>
        <th data-name="THENAME" class="<?= $Grid->THENAME->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_PASIEN_DIAGNOSA_THENAME" class="PASIEN_DIAGNOSA_THENAME"><?= $Grid->renderSort($Grid->THENAME) ?></div></th>
<?php } ?>
<?php if ($Grid->VISIT_ID->Visible) { // VISIT_ID ?>
        <th data-name="VISIT_ID" class="<?= $Grid->VISIT_ID->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_PASIEN_DIAGNOSA_VISIT_ID" class="PASIEN_DIAGNOSA_VISIT_ID"><?= $Grid->renderSort($Grid->VISIT_ID) ?></div></th>
<?php } ?>
<?php if ($Grid->DATE_OF_DIAGNOSA->Visible) { // DATE_OF_DIAGNOSA ?>
        <th data-name="DATE_OF_DIAGNOSA" class="<?= $Grid->DATE_OF_DIAGNOSA->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_PASIEN_DIAGNOSA_DATE_OF_DIAGNOSA" class="PASIEN_DIAGNOSA_DATE_OF_DIAGNOSA"><?= $Grid->renderSort($Grid->DATE_OF_DIAGNOSA) ?></div></th>
<?php } ?>
<?php if ($Grid->DIAGNOSA_ID->Visible) { // DIAGNOSA_ID ?>
        <th data-name="DIAGNOSA_ID" class="<?= $Grid->DIAGNOSA_ID->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_PASIEN_DIAGNOSA_DIAGNOSA_ID" class="PASIEN_DIAGNOSA_DIAGNOSA_ID"><?= $Grid->renderSort($Grid->DIAGNOSA_ID) ?></div></th>
<?php } ?>
<?php if ($Grid->DIAGNOSA_DESC->Visible) { // DIAGNOSA_DESC ?>
        <th data-name="DIAGNOSA_DESC" class="<?= $Grid->DIAGNOSA_DESC->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_PASIEN_DIAGNOSA_DIAGNOSA_DESC" class="PASIEN_DIAGNOSA_DIAGNOSA_DESC"><?= $Grid->renderSort($Grid->DIAGNOSA_DESC) ?></div></th>
<?php } ?>
<?php if ($Grid->ANAMNASE->Visible) { // ANAMNASE ?>
        <th data-name="ANAMNASE" class="<?= $Grid->ANAMNASE->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_PASIEN_DIAGNOSA_ANAMNASE" class="PASIEN_DIAGNOSA_ANAMNASE"><?= $Grid->renderSort($Grid->ANAMNASE) ?></div></th>
<?php } ?>
<?php if ($Grid->PEMERIKSAAN->Visible) { // PEMERIKSAAN ?>
        <th data-name="PEMERIKSAAN" class="<?= $Grid->PEMERIKSAAN->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_PASIEN_DIAGNOSA_PEMERIKSAAN" class="PASIEN_DIAGNOSA_PEMERIKSAAN"><?= $Grid->renderSort($Grid->PEMERIKSAAN) ?></div></th>
<?php } ?>
<?php if ($Grid->TERAPHY_DESC->Visible) { // TERAPHY_DESC ?>
        <th data-name="TERAPHY_DESC" class="<?= $Grid->TERAPHY_DESC->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_PASIEN_DIAGNOSA_TERAPHY_DESC" class="PASIEN_DIAGNOSA_TERAPHY_DESC"><?= $Grid->renderSort($Grid->TERAPHY_DESC) ?></div></th>
<?php } ?>
<?php if ($Grid->INSTRUCTION->Visible) { // INSTRUCTION ?>
        <th data-name="INSTRUCTION" class="<?= $Grid->INSTRUCTION->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_PASIEN_DIAGNOSA_INSTRUCTION" class="PASIEN_DIAGNOSA_INSTRUCTION"><?= $Grid->renderSort($Grid->INSTRUCTION) ?></div></th>
<?php } ?>
<?php if ($Grid->THEADDRESS->Visible) { // THEADDRESS ?>
        <th data-name="THEADDRESS" class="<?= $Grid->THEADDRESS->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_PASIEN_DIAGNOSA_THEADDRESS" class="PASIEN_DIAGNOSA_THEADDRESS"><?= $Grid->renderSort($Grid->THEADDRESS) ?></div></th>
<?php } ?>
<?php if ($Grid->THEID->Visible) { // THEID ?>
        <th data-name="THEID" class="<?= $Grid->THEID->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_PASIEN_DIAGNOSA_THEID" class="PASIEN_DIAGNOSA_THEID"><?= $Grid->renderSort($Grid->THEID) ?></div></th>
<?php } ?>
<?php if ($Grid->GENDER->Visible) { // GENDER ?>
        <th data-name="GENDER" class="<?= $Grid->GENDER->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_PASIEN_DIAGNOSA_GENDER" class="PASIEN_DIAGNOSA_GENDER"><?= $Grid->renderSort($Grid->GENDER) ?></div></th>
<?php } ?>
<?php if ($Grid->TGLKONTROL->Visible) { // TGLKONTROL ?>
        <th data-name="TGLKONTROL" class="<?= $Grid->TGLKONTROL->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_PASIEN_DIAGNOSA_TGLKONTROL" class="PASIEN_DIAGNOSA_TGLKONTROL"><?= $Grid->renderSort($Grid->TGLKONTROL) ?></div></th>
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowCount, "id" => "r" . $Grid->RowCount . "_PASIEN_DIAGNOSA", "data-rowtype" => $Grid->RowType]);

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
<span id="el<?= $Grid->RowCount ?>_PASIEN_DIAGNOSA_NO_REGISTRATION" class="form-group">
<span<?= $Grid->NO_REGISTRATION->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->NO_REGISTRATION->getDisplayValue($Grid->NO_REGISTRATION->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" name="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" value="<?= HtmlEncode($Grid->NO_REGISTRATION->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_PASIEN_DIAGNOSA_NO_REGISTRATION" class="form-group">
<?php $Grid->NO_REGISTRATION->EditAttrs->prepend("onchange", "ew.autoFill(this);"); ?>
<div class="input-group ew-lookup-list">
    <div class="form-control ew-lookup-text" tabindex="-1" id="lu_x<?= $Grid->RowIndex ?>_NO_REGISTRATION"><?= EmptyValue(strval($Grid->NO_REGISTRATION->ViewValue)) ? $Language->phrase("PleaseSelect") : $Grid->NO_REGISTRATION->ViewValue ?></div>
    <div class="input-group-append">
        <button type="button" title="<?= HtmlEncode(str_replace("%s", RemoveHtml($Grid->NO_REGISTRATION->caption()), $Language->phrase("LookupLink", true))) ?>" class="ew-lookup-btn btn btn-default"<?= ($Grid->NO_REGISTRATION->ReadOnly || $Grid->NO_REGISTRATION->Disabled) ? " disabled" : "" ?> onclick="ew.modalLookupShow({lnk:this,el:'x<?= $Grid->RowIndex ?>_NO_REGISTRATION',m:0,n:10});"><i class="fas fa-search ew-icon"></i></button>
    </div>
</div>
<div class="invalid-feedback"><?= $Grid->NO_REGISTRATION->getErrorMessage() ?></div>
<?= $Grid->NO_REGISTRATION->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_NO_REGISTRATION") ?>
<input type="hidden" is="selection-list" data-table="PASIEN_DIAGNOSA" data-field="x_NO_REGISTRATION" data-type="text" data-multiple="0" data-lookup="1" data-value-separator="<?= $Grid->NO_REGISTRATION->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" id="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" value="<?= $Grid->NO_REGISTRATION->CurrentValue ?>"<?= $Grid->NO_REGISTRATION->editAttributes() ?>>
</span>
<?php } ?>
<input type="hidden" data-table="PASIEN_DIAGNOSA" data-field="x_NO_REGISTRATION" data-hidden="1" name="o<?= $Grid->RowIndex ?>_NO_REGISTRATION" id="o<?= $Grid->RowIndex ?>_NO_REGISTRATION" value="<?= HtmlEncode($Grid->NO_REGISTRATION->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_PASIEN_DIAGNOSA_NO_REGISTRATION" class="form-group">
<span<?= $Grid->NO_REGISTRATION->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->NO_REGISTRATION->getDisplayValue($Grid->NO_REGISTRATION->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="PASIEN_DIAGNOSA" data-field="x_NO_REGISTRATION" data-hidden="1" name="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" id="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" value="<?= HtmlEncode($Grid->NO_REGISTRATION->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_PASIEN_DIAGNOSA_NO_REGISTRATION">
<span<?= $Grid->NO_REGISTRATION->viewAttributes() ?>>
<?= $Grid->NO_REGISTRATION->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="PASIEN_DIAGNOSA" data-field="x_NO_REGISTRATION" data-hidden="1" name="fPASIEN_DIAGNOSAgrid$x<?= $Grid->RowIndex ?>_NO_REGISTRATION" id="fPASIEN_DIAGNOSAgrid$x<?= $Grid->RowIndex ?>_NO_REGISTRATION" value="<?= HtmlEncode($Grid->NO_REGISTRATION->FormValue) ?>">
<input type="hidden" data-table="PASIEN_DIAGNOSA" data-field="x_NO_REGISTRATION" data-hidden="1" name="fPASIEN_DIAGNOSAgrid$o<?= $Grid->RowIndex ?>_NO_REGISTRATION" id="fPASIEN_DIAGNOSAgrid$o<?= $Grid->RowIndex ?>_NO_REGISTRATION" value="<?= HtmlEncode($Grid->NO_REGISTRATION->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->THENAME->Visible) { // THENAME ?>
        <td data-name="THENAME" <?= $Grid->THENAME->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Grid->THENAME->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_PASIEN_DIAGNOSA_THENAME" class="form-group">
<span<?= $Grid->THENAME->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->THENAME->getDisplayValue($Grid->THENAME->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_THENAME" name="x<?= $Grid->RowIndex ?>_THENAME" value="<?= HtmlEncode($Grid->THENAME->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_PASIEN_DIAGNOSA_THENAME" class="form-group">
<input type="<?= $Grid->THENAME->getInputTextType() ?>" data-table="PASIEN_DIAGNOSA" data-field="x_THENAME" name="x<?= $Grid->RowIndex ?>_THENAME" id="x<?= $Grid->RowIndex ?>_THENAME" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->THENAME->getPlaceHolder()) ?>" value="<?= $Grid->THENAME->EditValue ?>"<?= $Grid->THENAME->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->THENAME->getErrorMessage() ?></div>
</span>
<?php } ?>
<input type="hidden" data-table="PASIEN_DIAGNOSA" data-field="x_THENAME" data-hidden="1" name="o<?= $Grid->RowIndex ?>_THENAME" id="o<?= $Grid->RowIndex ?>_THENAME" value="<?= HtmlEncode($Grid->THENAME->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_PASIEN_DIAGNOSA_THENAME" class="form-group">
<span<?= $Grid->THENAME->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->THENAME->getDisplayValue($Grid->THENAME->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="PASIEN_DIAGNOSA" data-field="x_THENAME" data-hidden="1" name="x<?= $Grid->RowIndex ?>_THENAME" id="x<?= $Grid->RowIndex ?>_THENAME" value="<?= HtmlEncode($Grid->THENAME->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_PASIEN_DIAGNOSA_THENAME">
<span<?= $Grid->THENAME->viewAttributes() ?>>
<?= $Grid->THENAME->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="PASIEN_DIAGNOSA" data-field="x_THENAME" data-hidden="1" name="fPASIEN_DIAGNOSAgrid$x<?= $Grid->RowIndex ?>_THENAME" id="fPASIEN_DIAGNOSAgrid$x<?= $Grid->RowIndex ?>_THENAME" value="<?= HtmlEncode($Grid->THENAME->FormValue) ?>">
<input type="hidden" data-table="PASIEN_DIAGNOSA" data-field="x_THENAME" data-hidden="1" name="fPASIEN_DIAGNOSAgrid$o<?= $Grid->RowIndex ?>_THENAME" id="fPASIEN_DIAGNOSAgrid$o<?= $Grid->RowIndex ?>_THENAME" value="<?= HtmlEncode($Grid->THENAME->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->VISIT_ID->Visible) { // VISIT_ID ?>
        <td data-name="VISIT_ID" <?= $Grid->VISIT_ID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Grid->VISIT_ID->getSessionValue() != "") { ?>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_VISIT_ID" name="x<?= $Grid->RowIndex ?>_VISIT_ID" value="<?= HtmlEncode($Grid->VISIT_ID->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_PASIEN_DIAGNOSA_VISIT_ID" class="form-group">
<input type="hidden" data-table="PASIEN_DIAGNOSA" data-field="x_VISIT_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_VISIT_ID" id="x<?= $Grid->RowIndex ?>_VISIT_ID" value="<?= HtmlEncode($Grid->VISIT_ID->CurrentValue) ?>">
</span>
<?php } ?>
<input type="hidden" data-table="PASIEN_DIAGNOSA" data-field="x_VISIT_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_VISIT_ID" id="o<?= $Grid->RowIndex ?>_VISIT_ID" value="<?= HtmlEncode($Grid->VISIT_ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Grid->VISIT_ID->getSessionValue() != "") { ?>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_VISIT_ID" name="x<?= $Grid->RowIndex ?>_VISIT_ID" value="<?= HtmlEncode($Grid->VISIT_ID->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_PASIEN_DIAGNOSA_VISIT_ID" class="form-group">
<input type="hidden" data-table="PASIEN_DIAGNOSA" data-field="x_VISIT_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_VISIT_ID" id="x<?= $Grid->RowIndex ?>_VISIT_ID" value="<?= HtmlEncode($Grid->VISIT_ID->CurrentValue) ?>">
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_PASIEN_DIAGNOSA_VISIT_ID">
<span<?= $Grid->VISIT_ID->viewAttributes() ?>>
<?= $Grid->VISIT_ID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="PASIEN_DIAGNOSA" data-field="x_VISIT_ID" data-hidden="1" name="fPASIEN_DIAGNOSAgrid$x<?= $Grid->RowIndex ?>_VISIT_ID" id="fPASIEN_DIAGNOSAgrid$x<?= $Grid->RowIndex ?>_VISIT_ID" value="<?= HtmlEncode($Grid->VISIT_ID->FormValue) ?>">
<input type="hidden" data-table="PASIEN_DIAGNOSA" data-field="x_VISIT_ID" data-hidden="1" name="fPASIEN_DIAGNOSAgrid$o<?= $Grid->RowIndex ?>_VISIT_ID" id="fPASIEN_DIAGNOSAgrid$o<?= $Grid->RowIndex ?>_VISIT_ID" value="<?= HtmlEncode($Grid->VISIT_ID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->DATE_OF_DIAGNOSA->Visible) { // DATE_OF_DIAGNOSA ?>
        <td data-name="DATE_OF_DIAGNOSA" <?= $Grid->DATE_OF_DIAGNOSA->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_PASIEN_DIAGNOSA_DATE_OF_DIAGNOSA" class="form-group">
<input type="<?= $Grid->DATE_OF_DIAGNOSA->getInputTextType() ?>" data-table="PASIEN_DIAGNOSA" data-field="x_DATE_OF_DIAGNOSA" data-format="11" name="x<?= $Grid->RowIndex ?>_DATE_OF_DIAGNOSA" id="x<?= $Grid->RowIndex ?>_DATE_OF_DIAGNOSA" placeholder="<?= HtmlEncode($Grid->DATE_OF_DIAGNOSA->getPlaceHolder()) ?>" value="<?= $Grid->DATE_OF_DIAGNOSA->EditValue ?>"<?= $Grid->DATE_OF_DIAGNOSA->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->DATE_OF_DIAGNOSA->getErrorMessage() ?></div>
<?php if (!$Grid->DATE_OF_DIAGNOSA->ReadOnly && !$Grid->DATE_OF_DIAGNOSA->Disabled && !isset($Grid->DATE_OF_DIAGNOSA->EditAttrs["readonly"]) && !isset($Grid->DATE_OF_DIAGNOSA->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fPASIEN_DIAGNOSAgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fPASIEN_DIAGNOSAgrid", "x<?= $Grid->RowIndex ?>_DATE_OF_DIAGNOSA", {"ignoreReadonly":true,"useCurrent":false,"format":11});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="PASIEN_DIAGNOSA" data-field="x_DATE_OF_DIAGNOSA" data-hidden="1" name="o<?= $Grid->RowIndex ?>_DATE_OF_DIAGNOSA" id="o<?= $Grid->RowIndex ?>_DATE_OF_DIAGNOSA" value="<?= HtmlEncode($Grid->DATE_OF_DIAGNOSA->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_PASIEN_DIAGNOSA_DATE_OF_DIAGNOSA" class="form-group">
<input type="<?= $Grid->DATE_OF_DIAGNOSA->getInputTextType() ?>" data-table="PASIEN_DIAGNOSA" data-field="x_DATE_OF_DIAGNOSA" data-format="11" name="x<?= $Grid->RowIndex ?>_DATE_OF_DIAGNOSA" id="x<?= $Grid->RowIndex ?>_DATE_OF_DIAGNOSA" placeholder="<?= HtmlEncode($Grid->DATE_OF_DIAGNOSA->getPlaceHolder()) ?>" value="<?= $Grid->DATE_OF_DIAGNOSA->EditValue ?>"<?= $Grid->DATE_OF_DIAGNOSA->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->DATE_OF_DIAGNOSA->getErrorMessage() ?></div>
<?php if (!$Grid->DATE_OF_DIAGNOSA->ReadOnly && !$Grid->DATE_OF_DIAGNOSA->Disabled && !isset($Grid->DATE_OF_DIAGNOSA->EditAttrs["readonly"]) && !isset($Grid->DATE_OF_DIAGNOSA->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fPASIEN_DIAGNOSAgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fPASIEN_DIAGNOSAgrid", "x<?= $Grid->RowIndex ?>_DATE_OF_DIAGNOSA", {"ignoreReadonly":true,"useCurrent":false,"format":11});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_PASIEN_DIAGNOSA_DATE_OF_DIAGNOSA">
<span<?= $Grid->DATE_OF_DIAGNOSA->viewAttributes() ?>>
<?= $Grid->DATE_OF_DIAGNOSA->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="PASIEN_DIAGNOSA" data-field="x_DATE_OF_DIAGNOSA" data-hidden="1" name="fPASIEN_DIAGNOSAgrid$x<?= $Grid->RowIndex ?>_DATE_OF_DIAGNOSA" id="fPASIEN_DIAGNOSAgrid$x<?= $Grid->RowIndex ?>_DATE_OF_DIAGNOSA" value="<?= HtmlEncode($Grid->DATE_OF_DIAGNOSA->FormValue) ?>">
<input type="hidden" data-table="PASIEN_DIAGNOSA" data-field="x_DATE_OF_DIAGNOSA" data-hidden="1" name="fPASIEN_DIAGNOSAgrid$o<?= $Grid->RowIndex ?>_DATE_OF_DIAGNOSA" id="fPASIEN_DIAGNOSAgrid$o<?= $Grid->RowIndex ?>_DATE_OF_DIAGNOSA" value="<?= HtmlEncode($Grid->DATE_OF_DIAGNOSA->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->DIAGNOSA_ID->Visible) { // DIAGNOSA_ID ?>
        <td data-name="DIAGNOSA_ID" <?= $Grid->DIAGNOSA_ID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_PASIEN_DIAGNOSA_DIAGNOSA_ID" class="form-group">
<div class="input-group ew-lookup-list">
    <div class="form-control ew-lookup-text" tabindex="-1" id="lu_x<?= $Grid->RowIndex ?>_DIAGNOSA_ID"><?= EmptyValue(strval($Grid->DIAGNOSA_ID->ViewValue)) ? $Language->phrase("PleaseSelect") : $Grid->DIAGNOSA_ID->ViewValue ?></div>
    <div class="input-group-append">
        <button type="button" title="<?= HtmlEncode(str_replace("%s", RemoveHtml($Grid->DIAGNOSA_ID->caption()), $Language->phrase("LookupLink", true))) ?>" class="ew-lookup-btn btn btn-default"<?= ($Grid->DIAGNOSA_ID->ReadOnly || $Grid->DIAGNOSA_ID->Disabled) ? " disabled" : "" ?> onclick="ew.modalLookupShow({lnk:this,el:'x<?= $Grid->RowIndex ?>_DIAGNOSA_ID',m:0,n:10});"><i class="fas fa-search ew-icon"></i></button>
    </div>
</div>
<div class="invalid-feedback"><?= $Grid->DIAGNOSA_ID->getErrorMessage() ?></div>
<?= $Grid->DIAGNOSA_ID->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_DIAGNOSA_ID") ?>
<input type="hidden" is="selection-list" data-table="PASIEN_DIAGNOSA" data-field="x_DIAGNOSA_ID" data-type="text" data-multiple="0" data-lookup="1" data-value-separator="<?= $Grid->DIAGNOSA_ID->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_DIAGNOSA_ID" id="x<?= $Grid->RowIndex ?>_DIAGNOSA_ID" value="<?= $Grid->DIAGNOSA_ID->CurrentValue ?>"<?= $Grid->DIAGNOSA_ID->editAttributes() ?>>
</span>
<input type="hidden" data-table="PASIEN_DIAGNOSA" data-field="x_DIAGNOSA_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_DIAGNOSA_ID" id="o<?= $Grid->RowIndex ?>_DIAGNOSA_ID" value="<?= HtmlEncode($Grid->DIAGNOSA_ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_PASIEN_DIAGNOSA_DIAGNOSA_ID" class="form-group">
<div class="input-group ew-lookup-list">
    <div class="form-control ew-lookup-text" tabindex="-1" id="lu_x<?= $Grid->RowIndex ?>_DIAGNOSA_ID"><?= EmptyValue(strval($Grid->DIAGNOSA_ID->ViewValue)) ? $Language->phrase("PleaseSelect") : $Grid->DIAGNOSA_ID->ViewValue ?></div>
    <div class="input-group-append">
        <button type="button" title="<?= HtmlEncode(str_replace("%s", RemoveHtml($Grid->DIAGNOSA_ID->caption()), $Language->phrase("LookupLink", true))) ?>" class="ew-lookup-btn btn btn-default"<?= ($Grid->DIAGNOSA_ID->ReadOnly || $Grid->DIAGNOSA_ID->Disabled) ? " disabled" : "" ?> onclick="ew.modalLookupShow({lnk:this,el:'x<?= $Grid->RowIndex ?>_DIAGNOSA_ID',m:0,n:10});"><i class="fas fa-search ew-icon"></i></button>
    </div>
</div>
<div class="invalid-feedback"><?= $Grid->DIAGNOSA_ID->getErrorMessage() ?></div>
<?= $Grid->DIAGNOSA_ID->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_DIAGNOSA_ID") ?>
<input type="hidden" is="selection-list" data-table="PASIEN_DIAGNOSA" data-field="x_DIAGNOSA_ID" data-type="text" data-multiple="0" data-lookup="1" data-value-separator="<?= $Grid->DIAGNOSA_ID->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_DIAGNOSA_ID" id="x<?= $Grid->RowIndex ?>_DIAGNOSA_ID" value="<?= $Grid->DIAGNOSA_ID->CurrentValue ?>"<?= $Grid->DIAGNOSA_ID->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_PASIEN_DIAGNOSA_DIAGNOSA_ID">
<span<?= $Grid->DIAGNOSA_ID->viewAttributes() ?>>
<?= $Grid->DIAGNOSA_ID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="PASIEN_DIAGNOSA" data-field="x_DIAGNOSA_ID" data-hidden="1" name="fPASIEN_DIAGNOSAgrid$x<?= $Grid->RowIndex ?>_DIAGNOSA_ID" id="fPASIEN_DIAGNOSAgrid$x<?= $Grid->RowIndex ?>_DIAGNOSA_ID" value="<?= HtmlEncode($Grid->DIAGNOSA_ID->FormValue) ?>">
<input type="hidden" data-table="PASIEN_DIAGNOSA" data-field="x_DIAGNOSA_ID" data-hidden="1" name="fPASIEN_DIAGNOSAgrid$o<?= $Grid->RowIndex ?>_DIAGNOSA_ID" id="fPASIEN_DIAGNOSAgrid$o<?= $Grid->RowIndex ?>_DIAGNOSA_ID" value="<?= HtmlEncode($Grid->DIAGNOSA_ID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->DIAGNOSA_DESC->Visible) { // DIAGNOSA_DESC ?>
        <td data-name="DIAGNOSA_DESC" <?= $Grid->DIAGNOSA_DESC->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_PASIEN_DIAGNOSA_DIAGNOSA_DESC" class="form-group">
<input type="<?= $Grid->DIAGNOSA_DESC->getInputTextType() ?>" data-table="PASIEN_DIAGNOSA" data-field="x_DIAGNOSA_DESC" name="x<?= $Grid->RowIndex ?>_DIAGNOSA_DESC" id="x<?= $Grid->RowIndex ?>_DIAGNOSA_DESC" size="30" maxlength="200" placeholder="<?= HtmlEncode($Grid->DIAGNOSA_DESC->getPlaceHolder()) ?>" value="<?= $Grid->DIAGNOSA_DESC->EditValue ?>"<?= $Grid->DIAGNOSA_DESC->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->DIAGNOSA_DESC->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="PASIEN_DIAGNOSA" data-field="x_DIAGNOSA_DESC" data-hidden="1" name="o<?= $Grid->RowIndex ?>_DIAGNOSA_DESC" id="o<?= $Grid->RowIndex ?>_DIAGNOSA_DESC" value="<?= HtmlEncode($Grid->DIAGNOSA_DESC->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_PASIEN_DIAGNOSA_DIAGNOSA_DESC" class="form-group">
<input type="<?= $Grid->DIAGNOSA_DESC->getInputTextType() ?>" data-table="PASIEN_DIAGNOSA" data-field="x_DIAGNOSA_DESC" name="x<?= $Grid->RowIndex ?>_DIAGNOSA_DESC" id="x<?= $Grid->RowIndex ?>_DIAGNOSA_DESC" size="30" maxlength="200" placeholder="<?= HtmlEncode($Grid->DIAGNOSA_DESC->getPlaceHolder()) ?>" value="<?= $Grid->DIAGNOSA_DESC->EditValue ?>"<?= $Grid->DIAGNOSA_DESC->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->DIAGNOSA_DESC->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_PASIEN_DIAGNOSA_DIAGNOSA_DESC">
<span<?= $Grid->DIAGNOSA_DESC->viewAttributes() ?>>
<?= $Grid->DIAGNOSA_DESC->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="PASIEN_DIAGNOSA" data-field="x_DIAGNOSA_DESC" data-hidden="1" name="fPASIEN_DIAGNOSAgrid$x<?= $Grid->RowIndex ?>_DIAGNOSA_DESC" id="fPASIEN_DIAGNOSAgrid$x<?= $Grid->RowIndex ?>_DIAGNOSA_DESC" value="<?= HtmlEncode($Grid->DIAGNOSA_DESC->FormValue) ?>">
<input type="hidden" data-table="PASIEN_DIAGNOSA" data-field="x_DIAGNOSA_DESC" data-hidden="1" name="fPASIEN_DIAGNOSAgrid$o<?= $Grid->RowIndex ?>_DIAGNOSA_DESC" id="fPASIEN_DIAGNOSAgrid$o<?= $Grid->RowIndex ?>_DIAGNOSA_DESC" value="<?= HtmlEncode($Grid->DIAGNOSA_DESC->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->ANAMNASE->Visible) { // ANAMNASE ?>
        <td data-name="ANAMNASE" <?= $Grid->ANAMNASE->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_PASIEN_DIAGNOSA_ANAMNASE" class="form-group">
<textarea data-table="PASIEN_DIAGNOSA" data-field="x_ANAMNASE" name="x<?= $Grid->RowIndex ?>_ANAMNASE" id="x<?= $Grid->RowIndex ?>_ANAMNASE" cols="35" rows="4" placeholder="<?= HtmlEncode($Grid->ANAMNASE->getPlaceHolder()) ?>"<?= $Grid->ANAMNASE->editAttributes() ?>><?= $Grid->ANAMNASE->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Grid->ANAMNASE->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="PASIEN_DIAGNOSA" data-field="x_ANAMNASE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ANAMNASE" id="o<?= $Grid->RowIndex ?>_ANAMNASE" value="<?= HtmlEncode($Grid->ANAMNASE->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_PASIEN_DIAGNOSA_ANAMNASE" class="form-group">
<textarea data-table="PASIEN_DIAGNOSA" data-field="x_ANAMNASE" name="x<?= $Grid->RowIndex ?>_ANAMNASE" id="x<?= $Grid->RowIndex ?>_ANAMNASE" cols="35" rows="4" placeholder="<?= HtmlEncode($Grid->ANAMNASE->getPlaceHolder()) ?>"<?= $Grid->ANAMNASE->editAttributes() ?>><?= $Grid->ANAMNASE->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Grid->ANAMNASE->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_PASIEN_DIAGNOSA_ANAMNASE">
<span<?= $Grid->ANAMNASE->viewAttributes() ?>>
<?= $Grid->ANAMNASE->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="PASIEN_DIAGNOSA" data-field="x_ANAMNASE" data-hidden="1" name="fPASIEN_DIAGNOSAgrid$x<?= $Grid->RowIndex ?>_ANAMNASE" id="fPASIEN_DIAGNOSAgrid$x<?= $Grid->RowIndex ?>_ANAMNASE" value="<?= HtmlEncode($Grid->ANAMNASE->FormValue) ?>">
<input type="hidden" data-table="PASIEN_DIAGNOSA" data-field="x_ANAMNASE" data-hidden="1" name="fPASIEN_DIAGNOSAgrid$o<?= $Grid->RowIndex ?>_ANAMNASE" id="fPASIEN_DIAGNOSAgrid$o<?= $Grid->RowIndex ?>_ANAMNASE" value="<?= HtmlEncode($Grid->ANAMNASE->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->PEMERIKSAAN->Visible) { // PEMERIKSAAN ?>
        <td data-name="PEMERIKSAAN" <?= $Grid->PEMERIKSAAN->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_PASIEN_DIAGNOSA_PEMERIKSAAN" class="form-group">
<input type="<?= $Grid->PEMERIKSAAN->getInputTextType() ?>" data-table="PASIEN_DIAGNOSA" data-field="x_PEMERIKSAAN" name="x<?= $Grid->RowIndex ?>_PEMERIKSAAN" id="x<?= $Grid->RowIndex ?>_PEMERIKSAAN" size="30" maxlength="200" placeholder="<?= HtmlEncode($Grid->PEMERIKSAAN->getPlaceHolder()) ?>" value="<?= $Grid->PEMERIKSAAN->EditValue ?>"<?= $Grid->PEMERIKSAAN->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->PEMERIKSAAN->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="PASIEN_DIAGNOSA" data-field="x_PEMERIKSAAN" data-hidden="1" name="o<?= $Grid->RowIndex ?>_PEMERIKSAAN" id="o<?= $Grid->RowIndex ?>_PEMERIKSAAN" value="<?= HtmlEncode($Grid->PEMERIKSAAN->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_PASIEN_DIAGNOSA_PEMERIKSAAN" class="form-group">
<input type="<?= $Grid->PEMERIKSAAN->getInputTextType() ?>" data-table="PASIEN_DIAGNOSA" data-field="x_PEMERIKSAAN" name="x<?= $Grid->RowIndex ?>_PEMERIKSAAN" id="x<?= $Grid->RowIndex ?>_PEMERIKSAAN" size="30" maxlength="200" placeholder="<?= HtmlEncode($Grid->PEMERIKSAAN->getPlaceHolder()) ?>" value="<?= $Grid->PEMERIKSAAN->EditValue ?>"<?= $Grid->PEMERIKSAAN->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->PEMERIKSAAN->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_PASIEN_DIAGNOSA_PEMERIKSAAN">
<span<?= $Grid->PEMERIKSAAN->viewAttributes() ?>>
<?= $Grid->PEMERIKSAAN->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="PASIEN_DIAGNOSA" data-field="x_PEMERIKSAAN" data-hidden="1" name="fPASIEN_DIAGNOSAgrid$x<?= $Grid->RowIndex ?>_PEMERIKSAAN" id="fPASIEN_DIAGNOSAgrid$x<?= $Grid->RowIndex ?>_PEMERIKSAAN" value="<?= HtmlEncode($Grid->PEMERIKSAAN->FormValue) ?>">
<input type="hidden" data-table="PASIEN_DIAGNOSA" data-field="x_PEMERIKSAAN" data-hidden="1" name="fPASIEN_DIAGNOSAgrid$o<?= $Grid->RowIndex ?>_PEMERIKSAAN" id="fPASIEN_DIAGNOSAgrid$o<?= $Grid->RowIndex ?>_PEMERIKSAAN" value="<?= HtmlEncode($Grid->PEMERIKSAAN->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->TERAPHY_DESC->Visible) { // TERAPHY_DESC ?>
        <td data-name="TERAPHY_DESC" <?= $Grid->TERAPHY_DESC->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_PASIEN_DIAGNOSA_TERAPHY_DESC" class="form-group">
<input type="<?= $Grid->TERAPHY_DESC->getInputTextType() ?>" data-table="PASIEN_DIAGNOSA" data-field="x_TERAPHY_DESC" name="x<?= $Grid->RowIndex ?>_TERAPHY_DESC" id="x<?= $Grid->RowIndex ?>_TERAPHY_DESC" size="30" maxlength="200" placeholder="<?= HtmlEncode($Grid->TERAPHY_DESC->getPlaceHolder()) ?>" value="<?= $Grid->TERAPHY_DESC->EditValue ?>"<?= $Grid->TERAPHY_DESC->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->TERAPHY_DESC->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="PASIEN_DIAGNOSA" data-field="x_TERAPHY_DESC" data-hidden="1" name="o<?= $Grid->RowIndex ?>_TERAPHY_DESC" id="o<?= $Grid->RowIndex ?>_TERAPHY_DESC" value="<?= HtmlEncode($Grid->TERAPHY_DESC->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_PASIEN_DIAGNOSA_TERAPHY_DESC" class="form-group">
<input type="<?= $Grid->TERAPHY_DESC->getInputTextType() ?>" data-table="PASIEN_DIAGNOSA" data-field="x_TERAPHY_DESC" name="x<?= $Grid->RowIndex ?>_TERAPHY_DESC" id="x<?= $Grid->RowIndex ?>_TERAPHY_DESC" size="30" maxlength="200" placeholder="<?= HtmlEncode($Grid->TERAPHY_DESC->getPlaceHolder()) ?>" value="<?= $Grid->TERAPHY_DESC->EditValue ?>"<?= $Grid->TERAPHY_DESC->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->TERAPHY_DESC->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_PASIEN_DIAGNOSA_TERAPHY_DESC">
<span<?= $Grid->TERAPHY_DESC->viewAttributes() ?>>
<?= $Grid->TERAPHY_DESC->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="PASIEN_DIAGNOSA" data-field="x_TERAPHY_DESC" data-hidden="1" name="fPASIEN_DIAGNOSAgrid$x<?= $Grid->RowIndex ?>_TERAPHY_DESC" id="fPASIEN_DIAGNOSAgrid$x<?= $Grid->RowIndex ?>_TERAPHY_DESC" value="<?= HtmlEncode($Grid->TERAPHY_DESC->FormValue) ?>">
<input type="hidden" data-table="PASIEN_DIAGNOSA" data-field="x_TERAPHY_DESC" data-hidden="1" name="fPASIEN_DIAGNOSAgrid$o<?= $Grid->RowIndex ?>_TERAPHY_DESC" id="fPASIEN_DIAGNOSAgrid$o<?= $Grid->RowIndex ?>_TERAPHY_DESC" value="<?= HtmlEncode($Grid->TERAPHY_DESC->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->INSTRUCTION->Visible) { // INSTRUCTION ?>
        <td data-name="INSTRUCTION" <?= $Grid->INSTRUCTION->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_PASIEN_DIAGNOSA_INSTRUCTION" class="form-group">
<input type="<?= $Grid->INSTRUCTION->getInputTextType() ?>" data-table="PASIEN_DIAGNOSA" data-field="x_INSTRUCTION" name="x<?= $Grid->RowIndex ?>_INSTRUCTION" id="x<?= $Grid->RowIndex ?>_INSTRUCTION" size="30" maxlength="200" placeholder="<?= HtmlEncode($Grid->INSTRUCTION->getPlaceHolder()) ?>" value="<?= $Grid->INSTRUCTION->EditValue ?>"<?= $Grid->INSTRUCTION->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->INSTRUCTION->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="PASIEN_DIAGNOSA" data-field="x_INSTRUCTION" data-hidden="1" name="o<?= $Grid->RowIndex ?>_INSTRUCTION" id="o<?= $Grid->RowIndex ?>_INSTRUCTION" value="<?= HtmlEncode($Grid->INSTRUCTION->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_PASIEN_DIAGNOSA_INSTRUCTION" class="form-group">
<input type="<?= $Grid->INSTRUCTION->getInputTextType() ?>" data-table="PASIEN_DIAGNOSA" data-field="x_INSTRUCTION" name="x<?= $Grid->RowIndex ?>_INSTRUCTION" id="x<?= $Grid->RowIndex ?>_INSTRUCTION" size="30" maxlength="200" placeholder="<?= HtmlEncode($Grid->INSTRUCTION->getPlaceHolder()) ?>" value="<?= $Grid->INSTRUCTION->EditValue ?>"<?= $Grid->INSTRUCTION->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->INSTRUCTION->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_PASIEN_DIAGNOSA_INSTRUCTION">
<span<?= $Grid->INSTRUCTION->viewAttributes() ?>>
<?= $Grid->INSTRUCTION->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="PASIEN_DIAGNOSA" data-field="x_INSTRUCTION" data-hidden="1" name="fPASIEN_DIAGNOSAgrid$x<?= $Grid->RowIndex ?>_INSTRUCTION" id="fPASIEN_DIAGNOSAgrid$x<?= $Grid->RowIndex ?>_INSTRUCTION" value="<?= HtmlEncode($Grid->INSTRUCTION->FormValue) ?>">
<input type="hidden" data-table="PASIEN_DIAGNOSA" data-field="x_INSTRUCTION" data-hidden="1" name="fPASIEN_DIAGNOSAgrid$o<?= $Grid->RowIndex ?>_INSTRUCTION" id="fPASIEN_DIAGNOSAgrid$o<?= $Grid->RowIndex ?>_INSTRUCTION" value="<?= HtmlEncode($Grid->INSTRUCTION->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->THEADDRESS->Visible) { // THEADDRESS ?>
        <td data-name="THEADDRESS" <?= $Grid->THEADDRESS->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Grid->THEADDRESS->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_PASIEN_DIAGNOSA_THEADDRESS" class="form-group">
<span<?= $Grid->THEADDRESS->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->THEADDRESS->getDisplayValue($Grid->THEADDRESS->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_THEADDRESS" name="x<?= $Grid->RowIndex ?>_THEADDRESS" value="<?= HtmlEncode($Grid->THEADDRESS->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_PASIEN_DIAGNOSA_THEADDRESS" class="form-group">
<input type="<?= $Grid->THEADDRESS->getInputTextType() ?>" data-table="PASIEN_DIAGNOSA" data-field="x_THEADDRESS" name="x<?= $Grid->RowIndex ?>_THEADDRESS" id="x<?= $Grid->RowIndex ?>_THEADDRESS" size="30" maxlength="150" placeholder="<?= HtmlEncode($Grid->THEADDRESS->getPlaceHolder()) ?>" value="<?= $Grid->THEADDRESS->EditValue ?>"<?= $Grid->THEADDRESS->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->THEADDRESS->getErrorMessage() ?></div>
</span>
<?php } ?>
<input type="hidden" data-table="PASIEN_DIAGNOSA" data-field="x_THEADDRESS" data-hidden="1" name="o<?= $Grid->RowIndex ?>_THEADDRESS" id="o<?= $Grid->RowIndex ?>_THEADDRESS" value="<?= HtmlEncode($Grid->THEADDRESS->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Grid->THEADDRESS->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_PASIEN_DIAGNOSA_THEADDRESS" class="form-group">
<span<?= $Grid->THEADDRESS->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->THEADDRESS->getDisplayValue($Grid->THEADDRESS->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_THEADDRESS" name="x<?= $Grid->RowIndex ?>_THEADDRESS" value="<?= HtmlEncode($Grid->THEADDRESS->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_PASIEN_DIAGNOSA_THEADDRESS" class="form-group">
<input type="<?= $Grid->THEADDRESS->getInputTextType() ?>" data-table="PASIEN_DIAGNOSA" data-field="x_THEADDRESS" name="x<?= $Grid->RowIndex ?>_THEADDRESS" id="x<?= $Grid->RowIndex ?>_THEADDRESS" size="30" maxlength="150" placeholder="<?= HtmlEncode($Grid->THEADDRESS->getPlaceHolder()) ?>" value="<?= $Grid->THEADDRESS->EditValue ?>"<?= $Grid->THEADDRESS->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->THEADDRESS->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_PASIEN_DIAGNOSA_THEADDRESS">
<span<?= $Grid->THEADDRESS->viewAttributes() ?>>
<?= $Grid->THEADDRESS->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="PASIEN_DIAGNOSA" data-field="x_THEADDRESS" data-hidden="1" name="fPASIEN_DIAGNOSAgrid$x<?= $Grid->RowIndex ?>_THEADDRESS" id="fPASIEN_DIAGNOSAgrid$x<?= $Grid->RowIndex ?>_THEADDRESS" value="<?= HtmlEncode($Grid->THEADDRESS->FormValue) ?>">
<input type="hidden" data-table="PASIEN_DIAGNOSA" data-field="x_THEADDRESS" data-hidden="1" name="fPASIEN_DIAGNOSAgrid$o<?= $Grid->RowIndex ?>_THEADDRESS" id="fPASIEN_DIAGNOSAgrid$o<?= $Grid->RowIndex ?>_THEADDRESS" value="<?= HtmlEncode($Grid->THEADDRESS->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->THEID->Visible) { // THEID ?>
        <td data-name="THEID" <?= $Grid->THEID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_PASIEN_DIAGNOSA_THEID" class="form-group">
<input type="<?= $Grid->THEID->getInputTextType() ?>" data-table="PASIEN_DIAGNOSA" data-field="x_THEID" name="x<?= $Grid->RowIndex ?>_THEID" id="x<?= $Grid->RowIndex ?>_THEID" size="30" maxlength="25" placeholder="<?= HtmlEncode($Grid->THEID->getPlaceHolder()) ?>" value="<?= $Grid->THEID->EditValue ?>"<?= $Grid->THEID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->THEID->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="PASIEN_DIAGNOSA" data-field="x_THEID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_THEID" id="o<?= $Grid->RowIndex ?>_THEID" value="<?= HtmlEncode($Grid->THEID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_PASIEN_DIAGNOSA_THEID" class="form-group">
<input type="<?= $Grid->THEID->getInputTextType() ?>" data-table="PASIEN_DIAGNOSA" data-field="x_THEID" name="x<?= $Grid->RowIndex ?>_THEID" id="x<?= $Grid->RowIndex ?>_THEID" size="30" maxlength="25" placeholder="<?= HtmlEncode($Grid->THEID->getPlaceHolder()) ?>" value="<?= $Grid->THEID->EditValue ?>"<?= $Grid->THEID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->THEID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_PASIEN_DIAGNOSA_THEID">
<span<?= $Grid->THEID->viewAttributes() ?>>
<?= $Grid->THEID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="PASIEN_DIAGNOSA" data-field="x_THEID" data-hidden="1" name="fPASIEN_DIAGNOSAgrid$x<?= $Grid->RowIndex ?>_THEID" id="fPASIEN_DIAGNOSAgrid$x<?= $Grid->RowIndex ?>_THEID" value="<?= HtmlEncode($Grid->THEID->FormValue) ?>">
<input type="hidden" data-table="PASIEN_DIAGNOSA" data-field="x_THEID" data-hidden="1" name="fPASIEN_DIAGNOSAgrid$o<?= $Grid->RowIndex ?>_THEID" id="fPASIEN_DIAGNOSAgrid$o<?= $Grid->RowIndex ?>_THEID" value="<?= HtmlEncode($Grid->THEID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->GENDER->Visible) { // GENDER ?>
        <td data-name="GENDER" <?= $Grid->GENDER->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_PASIEN_DIAGNOSA_GENDER" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_GENDER"
        name="x<?= $Grid->RowIndex ?>_GENDER"
        class="form-control ew-select<?= $Grid->GENDER->isInvalidClass() ?>"
        data-select2-id="PASIEN_DIAGNOSA_x<?= $Grid->RowIndex ?>_GENDER"
        data-table="PASIEN_DIAGNOSA"
        data-field="x_GENDER"
        data-value-separator="<?= $Grid->GENDER->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->GENDER->getPlaceHolder()) ?>"
        <?= $Grid->GENDER->editAttributes() ?>>
        <?= $Grid->GENDER->selectOptionListHtml("x{$Grid->RowIndex}_GENDER") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->GENDER->getErrorMessage() ?></div>
<?= $Grid->GENDER->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_GENDER") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='PASIEN_DIAGNOSA_x<?= $Grid->RowIndex ?>_GENDER']"),
        options = { name: "x<?= $Grid->RowIndex ?>_GENDER", selectId: "PASIEN_DIAGNOSA_x<?= $Grid->RowIndex ?>_GENDER", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.PASIEN_DIAGNOSA.fields.GENDER.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="PASIEN_DIAGNOSA" data-field="x_GENDER" data-hidden="1" name="o<?= $Grid->RowIndex ?>_GENDER" id="o<?= $Grid->RowIndex ?>_GENDER" value="<?= HtmlEncode($Grid->GENDER->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_PASIEN_DIAGNOSA_GENDER" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_GENDER"
        name="x<?= $Grid->RowIndex ?>_GENDER"
        class="form-control ew-select<?= $Grid->GENDER->isInvalidClass() ?>"
        data-select2-id="PASIEN_DIAGNOSA_x<?= $Grid->RowIndex ?>_GENDER"
        data-table="PASIEN_DIAGNOSA"
        data-field="x_GENDER"
        data-value-separator="<?= $Grid->GENDER->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->GENDER->getPlaceHolder()) ?>"
        <?= $Grid->GENDER->editAttributes() ?>>
        <?= $Grid->GENDER->selectOptionListHtml("x{$Grid->RowIndex}_GENDER") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->GENDER->getErrorMessage() ?></div>
<?= $Grid->GENDER->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_GENDER") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='PASIEN_DIAGNOSA_x<?= $Grid->RowIndex ?>_GENDER']"),
        options = { name: "x<?= $Grid->RowIndex ?>_GENDER", selectId: "PASIEN_DIAGNOSA_x<?= $Grid->RowIndex ?>_GENDER", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.PASIEN_DIAGNOSA.fields.GENDER.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_PASIEN_DIAGNOSA_GENDER">
<span<?= $Grid->GENDER->viewAttributes() ?>>
<?= $Grid->GENDER->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="PASIEN_DIAGNOSA" data-field="x_GENDER" data-hidden="1" name="fPASIEN_DIAGNOSAgrid$x<?= $Grid->RowIndex ?>_GENDER" id="fPASIEN_DIAGNOSAgrid$x<?= $Grid->RowIndex ?>_GENDER" value="<?= HtmlEncode($Grid->GENDER->FormValue) ?>">
<input type="hidden" data-table="PASIEN_DIAGNOSA" data-field="x_GENDER" data-hidden="1" name="fPASIEN_DIAGNOSAgrid$o<?= $Grid->RowIndex ?>_GENDER" id="fPASIEN_DIAGNOSAgrid$o<?= $Grid->RowIndex ?>_GENDER" value="<?= HtmlEncode($Grid->GENDER->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->TGLKONTROL->Visible) { // TGLKONTROL ?>
        <td data-name="TGLKONTROL" <?= $Grid->TGLKONTROL->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_PASIEN_DIAGNOSA_TGLKONTROL" class="form-group">
<input type="<?= $Grid->TGLKONTROL->getInputTextType() ?>" data-table="PASIEN_DIAGNOSA" data-field="x_TGLKONTROL" name="x<?= $Grid->RowIndex ?>_TGLKONTROL" id="x<?= $Grid->RowIndex ?>_TGLKONTROL" placeholder="<?= HtmlEncode($Grid->TGLKONTROL->getPlaceHolder()) ?>" value="<?= $Grid->TGLKONTROL->EditValue ?>"<?= $Grid->TGLKONTROL->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->TGLKONTROL->getErrorMessage() ?></div>
<?php if (!$Grid->TGLKONTROL->ReadOnly && !$Grid->TGLKONTROL->Disabled && !isset($Grid->TGLKONTROL->EditAttrs["readonly"]) && !isset($Grid->TGLKONTROL->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fPASIEN_DIAGNOSAgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fPASIEN_DIAGNOSAgrid", "x<?= $Grid->RowIndex ?>_TGLKONTROL", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="PASIEN_DIAGNOSA" data-field="x_TGLKONTROL" data-hidden="1" name="o<?= $Grid->RowIndex ?>_TGLKONTROL" id="o<?= $Grid->RowIndex ?>_TGLKONTROL" value="<?= HtmlEncode($Grid->TGLKONTROL->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_PASIEN_DIAGNOSA_TGLKONTROL" class="form-group">
<input type="<?= $Grid->TGLKONTROL->getInputTextType() ?>" data-table="PASIEN_DIAGNOSA" data-field="x_TGLKONTROL" name="x<?= $Grid->RowIndex ?>_TGLKONTROL" id="x<?= $Grid->RowIndex ?>_TGLKONTROL" placeholder="<?= HtmlEncode($Grid->TGLKONTROL->getPlaceHolder()) ?>" value="<?= $Grid->TGLKONTROL->EditValue ?>"<?= $Grid->TGLKONTROL->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->TGLKONTROL->getErrorMessage() ?></div>
<?php if (!$Grid->TGLKONTROL->ReadOnly && !$Grid->TGLKONTROL->Disabled && !isset($Grid->TGLKONTROL->EditAttrs["readonly"]) && !isset($Grid->TGLKONTROL->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fPASIEN_DIAGNOSAgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fPASIEN_DIAGNOSAgrid", "x<?= $Grid->RowIndex ?>_TGLKONTROL", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_PASIEN_DIAGNOSA_TGLKONTROL">
<span<?= $Grid->TGLKONTROL->viewAttributes() ?>>
<?= $Grid->TGLKONTROL->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="PASIEN_DIAGNOSA" data-field="x_TGLKONTROL" data-hidden="1" name="fPASIEN_DIAGNOSAgrid$x<?= $Grid->RowIndex ?>_TGLKONTROL" id="fPASIEN_DIAGNOSAgrid$x<?= $Grid->RowIndex ?>_TGLKONTROL" value="<?= HtmlEncode($Grid->TGLKONTROL->FormValue) ?>">
<input type="hidden" data-table="PASIEN_DIAGNOSA" data-field="x_TGLKONTROL" data-hidden="1" name="fPASIEN_DIAGNOSAgrid$o<?= $Grid->RowIndex ?>_TGLKONTROL" id="fPASIEN_DIAGNOSAgrid$o<?= $Grid->RowIndex ?>_TGLKONTROL" value="<?= HtmlEncode($Grid->TGLKONTROL->OldValue) ?>">
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
loadjs.ready(["fPASIEN_DIAGNOSAgrid","load"], function () {
    fPASIEN_DIAGNOSAgrid.updateLists(<?= $Grid->RowIndex ?>);
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_PASIEN_DIAGNOSA", "data-rowtype" => ROWTYPE_ADD]);
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
<span id="el$rowindex$_PASIEN_DIAGNOSA_NO_REGISTRATION" class="form-group PASIEN_DIAGNOSA_NO_REGISTRATION">
<span<?= $Grid->NO_REGISTRATION->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->NO_REGISTRATION->getDisplayValue($Grid->NO_REGISTRATION->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" name="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" value="<?= HtmlEncode($Grid->NO_REGISTRATION->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_PASIEN_DIAGNOSA_NO_REGISTRATION" class="form-group PASIEN_DIAGNOSA_NO_REGISTRATION">
<?php $Grid->NO_REGISTRATION->EditAttrs->prepend("onchange", "ew.autoFill(this);"); ?>
<div class="input-group ew-lookup-list">
    <div class="form-control ew-lookup-text" tabindex="-1" id="lu_x<?= $Grid->RowIndex ?>_NO_REGISTRATION"><?= EmptyValue(strval($Grid->NO_REGISTRATION->ViewValue)) ? $Language->phrase("PleaseSelect") : $Grid->NO_REGISTRATION->ViewValue ?></div>
    <div class="input-group-append">
        <button type="button" title="<?= HtmlEncode(str_replace("%s", RemoveHtml($Grid->NO_REGISTRATION->caption()), $Language->phrase("LookupLink", true))) ?>" class="ew-lookup-btn btn btn-default"<?= ($Grid->NO_REGISTRATION->ReadOnly || $Grid->NO_REGISTRATION->Disabled) ? " disabled" : "" ?> onclick="ew.modalLookupShow({lnk:this,el:'x<?= $Grid->RowIndex ?>_NO_REGISTRATION',m:0,n:10});"><i class="fas fa-search ew-icon"></i></button>
    </div>
</div>
<div class="invalid-feedback"><?= $Grid->NO_REGISTRATION->getErrorMessage() ?></div>
<?= $Grid->NO_REGISTRATION->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_NO_REGISTRATION") ?>
<input type="hidden" is="selection-list" data-table="PASIEN_DIAGNOSA" data-field="x_NO_REGISTRATION" data-type="text" data-multiple="0" data-lookup="1" data-value-separator="<?= $Grid->NO_REGISTRATION->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" id="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" value="<?= $Grid->NO_REGISTRATION->CurrentValue ?>"<?= $Grid->NO_REGISTRATION->editAttributes() ?>>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_PASIEN_DIAGNOSA_NO_REGISTRATION" class="form-group PASIEN_DIAGNOSA_NO_REGISTRATION">
<span<?= $Grid->NO_REGISTRATION->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->NO_REGISTRATION->getDisplayValue($Grid->NO_REGISTRATION->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="PASIEN_DIAGNOSA" data-field="x_NO_REGISTRATION" data-hidden="1" name="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" id="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" value="<?= HtmlEncode($Grid->NO_REGISTRATION->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="PASIEN_DIAGNOSA" data-field="x_NO_REGISTRATION" data-hidden="1" name="o<?= $Grid->RowIndex ?>_NO_REGISTRATION" id="o<?= $Grid->RowIndex ?>_NO_REGISTRATION" value="<?= HtmlEncode($Grid->NO_REGISTRATION->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->THENAME->Visible) { // THENAME ?>
        <td data-name="THENAME">
<?php if (!$Grid->isConfirm()) { ?>
<?php if ($Grid->THENAME->getSessionValue() != "") { ?>
<span id="el$rowindex$_PASIEN_DIAGNOSA_THENAME" class="form-group PASIEN_DIAGNOSA_THENAME">
<span<?= $Grid->THENAME->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->THENAME->getDisplayValue($Grid->THENAME->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_THENAME" name="x<?= $Grid->RowIndex ?>_THENAME" value="<?= HtmlEncode($Grid->THENAME->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_PASIEN_DIAGNOSA_THENAME" class="form-group PASIEN_DIAGNOSA_THENAME">
<input type="<?= $Grid->THENAME->getInputTextType() ?>" data-table="PASIEN_DIAGNOSA" data-field="x_THENAME" name="x<?= $Grid->RowIndex ?>_THENAME" id="x<?= $Grid->RowIndex ?>_THENAME" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->THENAME->getPlaceHolder()) ?>" value="<?= $Grid->THENAME->EditValue ?>"<?= $Grid->THENAME->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->THENAME->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_PASIEN_DIAGNOSA_THENAME" class="form-group PASIEN_DIAGNOSA_THENAME">
<span<?= $Grid->THENAME->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->THENAME->getDisplayValue($Grid->THENAME->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="PASIEN_DIAGNOSA" data-field="x_THENAME" data-hidden="1" name="x<?= $Grid->RowIndex ?>_THENAME" id="x<?= $Grid->RowIndex ?>_THENAME" value="<?= HtmlEncode($Grid->THENAME->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="PASIEN_DIAGNOSA" data-field="x_THENAME" data-hidden="1" name="o<?= $Grid->RowIndex ?>_THENAME" id="o<?= $Grid->RowIndex ?>_THENAME" value="<?= HtmlEncode($Grid->THENAME->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->VISIT_ID->Visible) { // VISIT_ID ?>
        <td data-name="VISIT_ID">
<?php if (!$Grid->isConfirm()) { ?>
<?php if ($Grid->VISIT_ID->getSessionValue() != "") { ?>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_VISIT_ID" name="x<?= $Grid->RowIndex ?>_VISIT_ID" value="<?= HtmlEncode($Grid->VISIT_ID->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_PASIEN_DIAGNOSA_VISIT_ID" class="form-group PASIEN_DIAGNOSA_VISIT_ID">
<input type="hidden" data-table="PASIEN_DIAGNOSA" data-field="x_VISIT_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_VISIT_ID" id="x<?= $Grid->RowIndex ?>_VISIT_ID" value="<?= HtmlEncode($Grid->VISIT_ID->CurrentValue) ?>">
</span>
<?php } ?>
<?php } else { ?>
<input type="hidden" data-table="PASIEN_DIAGNOSA" data-field="x_VISIT_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_VISIT_ID" id="x<?= $Grid->RowIndex ?>_VISIT_ID" value="<?= HtmlEncode($Grid->VISIT_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="PASIEN_DIAGNOSA" data-field="x_VISIT_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_VISIT_ID" id="o<?= $Grid->RowIndex ?>_VISIT_ID" value="<?= HtmlEncode($Grid->VISIT_ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->DATE_OF_DIAGNOSA->Visible) { // DATE_OF_DIAGNOSA ?>
        <td data-name="DATE_OF_DIAGNOSA">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_PASIEN_DIAGNOSA_DATE_OF_DIAGNOSA" class="form-group PASIEN_DIAGNOSA_DATE_OF_DIAGNOSA">
<input type="<?= $Grid->DATE_OF_DIAGNOSA->getInputTextType() ?>" data-table="PASIEN_DIAGNOSA" data-field="x_DATE_OF_DIAGNOSA" data-format="11" name="x<?= $Grid->RowIndex ?>_DATE_OF_DIAGNOSA" id="x<?= $Grid->RowIndex ?>_DATE_OF_DIAGNOSA" placeholder="<?= HtmlEncode($Grid->DATE_OF_DIAGNOSA->getPlaceHolder()) ?>" value="<?= $Grid->DATE_OF_DIAGNOSA->EditValue ?>"<?= $Grid->DATE_OF_DIAGNOSA->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->DATE_OF_DIAGNOSA->getErrorMessage() ?></div>
<?php if (!$Grid->DATE_OF_DIAGNOSA->ReadOnly && !$Grid->DATE_OF_DIAGNOSA->Disabled && !isset($Grid->DATE_OF_DIAGNOSA->EditAttrs["readonly"]) && !isset($Grid->DATE_OF_DIAGNOSA->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fPASIEN_DIAGNOSAgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fPASIEN_DIAGNOSAgrid", "x<?= $Grid->RowIndex ?>_DATE_OF_DIAGNOSA", {"ignoreReadonly":true,"useCurrent":false,"format":11});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_PASIEN_DIAGNOSA_DATE_OF_DIAGNOSA" class="form-group PASIEN_DIAGNOSA_DATE_OF_DIAGNOSA">
<span<?= $Grid->DATE_OF_DIAGNOSA->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->DATE_OF_DIAGNOSA->getDisplayValue($Grid->DATE_OF_DIAGNOSA->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="PASIEN_DIAGNOSA" data-field="x_DATE_OF_DIAGNOSA" data-hidden="1" name="x<?= $Grid->RowIndex ?>_DATE_OF_DIAGNOSA" id="x<?= $Grid->RowIndex ?>_DATE_OF_DIAGNOSA" value="<?= HtmlEncode($Grid->DATE_OF_DIAGNOSA->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="PASIEN_DIAGNOSA" data-field="x_DATE_OF_DIAGNOSA" data-hidden="1" name="o<?= $Grid->RowIndex ?>_DATE_OF_DIAGNOSA" id="o<?= $Grid->RowIndex ?>_DATE_OF_DIAGNOSA" value="<?= HtmlEncode($Grid->DATE_OF_DIAGNOSA->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->DIAGNOSA_ID->Visible) { // DIAGNOSA_ID ?>
        <td data-name="DIAGNOSA_ID">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_PASIEN_DIAGNOSA_DIAGNOSA_ID" class="form-group PASIEN_DIAGNOSA_DIAGNOSA_ID">
<div class="input-group ew-lookup-list">
    <div class="form-control ew-lookup-text" tabindex="-1" id="lu_x<?= $Grid->RowIndex ?>_DIAGNOSA_ID"><?= EmptyValue(strval($Grid->DIAGNOSA_ID->ViewValue)) ? $Language->phrase("PleaseSelect") : $Grid->DIAGNOSA_ID->ViewValue ?></div>
    <div class="input-group-append">
        <button type="button" title="<?= HtmlEncode(str_replace("%s", RemoveHtml($Grid->DIAGNOSA_ID->caption()), $Language->phrase("LookupLink", true))) ?>" class="ew-lookup-btn btn btn-default"<?= ($Grid->DIAGNOSA_ID->ReadOnly || $Grid->DIAGNOSA_ID->Disabled) ? " disabled" : "" ?> onclick="ew.modalLookupShow({lnk:this,el:'x<?= $Grid->RowIndex ?>_DIAGNOSA_ID',m:0,n:10});"><i class="fas fa-search ew-icon"></i></button>
    </div>
</div>
<div class="invalid-feedback"><?= $Grid->DIAGNOSA_ID->getErrorMessage() ?></div>
<?= $Grid->DIAGNOSA_ID->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_DIAGNOSA_ID") ?>
<input type="hidden" is="selection-list" data-table="PASIEN_DIAGNOSA" data-field="x_DIAGNOSA_ID" data-type="text" data-multiple="0" data-lookup="1" data-value-separator="<?= $Grid->DIAGNOSA_ID->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_DIAGNOSA_ID" id="x<?= $Grid->RowIndex ?>_DIAGNOSA_ID" value="<?= $Grid->DIAGNOSA_ID->CurrentValue ?>"<?= $Grid->DIAGNOSA_ID->editAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_PASIEN_DIAGNOSA_DIAGNOSA_ID" class="form-group PASIEN_DIAGNOSA_DIAGNOSA_ID">
<span<?= $Grid->DIAGNOSA_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->DIAGNOSA_ID->getDisplayValue($Grid->DIAGNOSA_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="PASIEN_DIAGNOSA" data-field="x_DIAGNOSA_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_DIAGNOSA_ID" id="x<?= $Grid->RowIndex ?>_DIAGNOSA_ID" value="<?= HtmlEncode($Grid->DIAGNOSA_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="PASIEN_DIAGNOSA" data-field="x_DIAGNOSA_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_DIAGNOSA_ID" id="o<?= $Grid->RowIndex ?>_DIAGNOSA_ID" value="<?= HtmlEncode($Grid->DIAGNOSA_ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->DIAGNOSA_DESC->Visible) { // DIAGNOSA_DESC ?>
        <td data-name="DIAGNOSA_DESC">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_PASIEN_DIAGNOSA_DIAGNOSA_DESC" class="form-group PASIEN_DIAGNOSA_DIAGNOSA_DESC">
<input type="<?= $Grid->DIAGNOSA_DESC->getInputTextType() ?>" data-table="PASIEN_DIAGNOSA" data-field="x_DIAGNOSA_DESC" name="x<?= $Grid->RowIndex ?>_DIAGNOSA_DESC" id="x<?= $Grid->RowIndex ?>_DIAGNOSA_DESC" size="30" maxlength="200" placeholder="<?= HtmlEncode($Grid->DIAGNOSA_DESC->getPlaceHolder()) ?>" value="<?= $Grid->DIAGNOSA_DESC->EditValue ?>"<?= $Grid->DIAGNOSA_DESC->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->DIAGNOSA_DESC->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_PASIEN_DIAGNOSA_DIAGNOSA_DESC" class="form-group PASIEN_DIAGNOSA_DIAGNOSA_DESC">
<span<?= $Grid->DIAGNOSA_DESC->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->DIAGNOSA_DESC->getDisplayValue($Grid->DIAGNOSA_DESC->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="PASIEN_DIAGNOSA" data-field="x_DIAGNOSA_DESC" data-hidden="1" name="x<?= $Grid->RowIndex ?>_DIAGNOSA_DESC" id="x<?= $Grid->RowIndex ?>_DIAGNOSA_DESC" value="<?= HtmlEncode($Grid->DIAGNOSA_DESC->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="PASIEN_DIAGNOSA" data-field="x_DIAGNOSA_DESC" data-hidden="1" name="o<?= $Grid->RowIndex ?>_DIAGNOSA_DESC" id="o<?= $Grid->RowIndex ?>_DIAGNOSA_DESC" value="<?= HtmlEncode($Grid->DIAGNOSA_DESC->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->ANAMNASE->Visible) { // ANAMNASE ?>
        <td data-name="ANAMNASE">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_PASIEN_DIAGNOSA_ANAMNASE" class="form-group PASIEN_DIAGNOSA_ANAMNASE">
<textarea data-table="PASIEN_DIAGNOSA" data-field="x_ANAMNASE" name="x<?= $Grid->RowIndex ?>_ANAMNASE" id="x<?= $Grid->RowIndex ?>_ANAMNASE" cols="35" rows="4" placeholder="<?= HtmlEncode($Grid->ANAMNASE->getPlaceHolder()) ?>"<?= $Grid->ANAMNASE->editAttributes() ?>><?= $Grid->ANAMNASE->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Grid->ANAMNASE->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_PASIEN_DIAGNOSA_ANAMNASE" class="form-group PASIEN_DIAGNOSA_ANAMNASE">
<span<?= $Grid->ANAMNASE->viewAttributes() ?>>
<?= $Grid->ANAMNASE->ViewValue ?></span>
</span>
<input type="hidden" data-table="PASIEN_DIAGNOSA" data-field="x_ANAMNASE" data-hidden="1" name="x<?= $Grid->RowIndex ?>_ANAMNASE" id="x<?= $Grid->RowIndex ?>_ANAMNASE" value="<?= HtmlEncode($Grid->ANAMNASE->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="PASIEN_DIAGNOSA" data-field="x_ANAMNASE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ANAMNASE" id="o<?= $Grid->RowIndex ?>_ANAMNASE" value="<?= HtmlEncode($Grid->ANAMNASE->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->PEMERIKSAAN->Visible) { // PEMERIKSAAN ?>
        <td data-name="PEMERIKSAAN">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_PASIEN_DIAGNOSA_PEMERIKSAAN" class="form-group PASIEN_DIAGNOSA_PEMERIKSAAN">
<input type="<?= $Grid->PEMERIKSAAN->getInputTextType() ?>" data-table="PASIEN_DIAGNOSA" data-field="x_PEMERIKSAAN" name="x<?= $Grid->RowIndex ?>_PEMERIKSAAN" id="x<?= $Grid->RowIndex ?>_PEMERIKSAAN" size="30" maxlength="200" placeholder="<?= HtmlEncode($Grid->PEMERIKSAAN->getPlaceHolder()) ?>" value="<?= $Grid->PEMERIKSAAN->EditValue ?>"<?= $Grid->PEMERIKSAAN->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->PEMERIKSAAN->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_PASIEN_DIAGNOSA_PEMERIKSAAN" class="form-group PASIEN_DIAGNOSA_PEMERIKSAAN">
<span<?= $Grid->PEMERIKSAAN->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->PEMERIKSAAN->getDisplayValue($Grid->PEMERIKSAAN->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="PASIEN_DIAGNOSA" data-field="x_PEMERIKSAAN" data-hidden="1" name="x<?= $Grid->RowIndex ?>_PEMERIKSAAN" id="x<?= $Grid->RowIndex ?>_PEMERIKSAAN" value="<?= HtmlEncode($Grid->PEMERIKSAAN->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="PASIEN_DIAGNOSA" data-field="x_PEMERIKSAAN" data-hidden="1" name="o<?= $Grid->RowIndex ?>_PEMERIKSAAN" id="o<?= $Grid->RowIndex ?>_PEMERIKSAAN" value="<?= HtmlEncode($Grid->PEMERIKSAAN->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->TERAPHY_DESC->Visible) { // TERAPHY_DESC ?>
        <td data-name="TERAPHY_DESC">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_PASIEN_DIAGNOSA_TERAPHY_DESC" class="form-group PASIEN_DIAGNOSA_TERAPHY_DESC">
<input type="<?= $Grid->TERAPHY_DESC->getInputTextType() ?>" data-table="PASIEN_DIAGNOSA" data-field="x_TERAPHY_DESC" name="x<?= $Grid->RowIndex ?>_TERAPHY_DESC" id="x<?= $Grid->RowIndex ?>_TERAPHY_DESC" size="30" maxlength="200" placeholder="<?= HtmlEncode($Grid->TERAPHY_DESC->getPlaceHolder()) ?>" value="<?= $Grid->TERAPHY_DESC->EditValue ?>"<?= $Grid->TERAPHY_DESC->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->TERAPHY_DESC->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_PASIEN_DIAGNOSA_TERAPHY_DESC" class="form-group PASIEN_DIAGNOSA_TERAPHY_DESC">
<span<?= $Grid->TERAPHY_DESC->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->TERAPHY_DESC->getDisplayValue($Grid->TERAPHY_DESC->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="PASIEN_DIAGNOSA" data-field="x_TERAPHY_DESC" data-hidden="1" name="x<?= $Grid->RowIndex ?>_TERAPHY_DESC" id="x<?= $Grid->RowIndex ?>_TERAPHY_DESC" value="<?= HtmlEncode($Grid->TERAPHY_DESC->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="PASIEN_DIAGNOSA" data-field="x_TERAPHY_DESC" data-hidden="1" name="o<?= $Grid->RowIndex ?>_TERAPHY_DESC" id="o<?= $Grid->RowIndex ?>_TERAPHY_DESC" value="<?= HtmlEncode($Grid->TERAPHY_DESC->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->INSTRUCTION->Visible) { // INSTRUCTION ?>
        <td data-name="INSTRUCTION">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_PASIEN_DIAGNOSA_INSTRUCTION" class="form-group PASIEN_DIAGNOSA_INSTRUCTION">
<input type="<?= $Grid->INSTRUCTION->getInputTextType() ?>" data-table="PASIEN_DIAGNOSA" data-field="x_INSTRUCTION" name="x<?= $Grid->RowIndex ?>_INSTRUCTION" id="x<?= $Grid->RowIndex ?>_INSTRUCTION" size="30" maxlength="200" placeholder="<?= HtmlEncode($Grid->INSTRUCTION->getPlaceHolder()) ?>" value="<?= $Grid->INSTRUCTION->EditValue ?>"<?= $Grid->INSTRUCTION->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->INSTRUCTION->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_PASIEN_DIAGNOSA_INSTRUCTION" class="form-group PASIEN_DIAGNOSA_INSTRUCTION">
<span<?= $Grid->INSTRUCTION->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->INSTRUCTION->getDisplayValue($Grid->INSTRUCTION->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="PASIEN_DIAGNOSA" data-field="x_INSTRUCTION" data-hidden="1" name="x<?= $Grid->RowIndex ?>_INSTRUCTION" id="x<?= $Grid->RowIndex ?>_INSTRUCTION" value="<?= HtmlEncode($Grid->INSTRUCTION->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="PASIEN_DIAGNOSA" data-field="x_INSTRUCTION" data-hidden="1" name="o<?= $Grid->RowIndex ?>_INSTRUCTION" id="o<?= $Grid->RowIndex ?>_INSTRUCTION" value="<?= HtmlEncode($Grid->INSTRUCTION->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->THEADDRESS->Visible) { // THEADDRESS ?>
        <td data-name="THEADDRESS">
<?php if (!$Grid->isConfirm()) { ?>
<?php if ($Grid->THEADDRESS->getSessionValue() != "") { ?>
<span id="el$rowindex$_PASIEN_DIAGNOSA_THEADDRESS" class="form-group PASIEN_DIAGNOSA_THEADDRESS">
<span<?= $Grid->THEADDRESS->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->THEADDRESS->getDisplayValue($Grid->THEADDRESS->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_THEADDRESS" name="x<?= $Grid->RowIndex ?>_THEADDRESS" value="<?= HtmlEncode($Grid->THEADDRESS->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_PASIEN_DIAGNOSA_THEADDRESS" class="form-group PASIEN_DIAGNOSA_THEADDRESS">
<input type="<?= $Grid->THEADDRESS->getInputTextType() ?>" data-table="PASIEN_DIAGNOSA" data-field="x_THEADDRESS" name="x<?= $Grid->RowIndex ?>_THEADDRESS" id="x<?= $Grid->RowIndex ?>_THEADDRESS" size="30" maxlength="150" placeholder="<?= HtmlEncode($Grid->THEADDRESS->getPlaceHolder()) ?>" value="<?= $Grid->THEADDRESS->EditValue ?>"<?= $Grid->THEADDRESS->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->THEADDRESS->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_PASIEN_DIAGNOSA_THEADDRESS" class="form-group PASIEN_DIAGNOSA_THEADDRESS">
<span<?= $Grid->THEADDRESS->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->THEADDRESS->getDisplayValue($Grid->THEADDRESS->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="PASIEN_DIAGNOSA" data-field="x_THEADDRESS" data-hidden="1" name="x<?= $Grid->RowIndex ?>_THEADDRESS" id="x<?= $Grid->RowIndex ?>_THEADDRESS" value="<?= HtmlEncode($Grid->THEADDRESS->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="PASIEN_DIAGNOSA" data-field="x_THEADDRESS" data-hidden="1" name="o<?= $Grid->RowIndex ?>_THEADDRESS" id="o<?= $Grid->RowIndex ?>_THEADDRESS" value="<?= HtmlEncode($Grid->THEADDRESS->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->THEID->Visible) { // THEID ?>
        <td data-name="THEID">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_PASIEN_DIAGNOSA_THEID" class="form-group PASIEN_DIAGNOSA_THEID">
<input type="<?= $Grid->THEID->getInputTextType() ?>" data-table="PASIEN_DIAGNOSA" data-field="x_THEID" name="x<?= $Grid->RowIndex ?>_THEID" id="x<?= $Grid->RowIndex ?>_THEID" size="30" maxlength="25" placeholder="<?= HtmlEncode($Grid->THEID->getPlaceHolder()) ?>" value="<?= $Grid->THEID->EditValue ?>"<?= $Grid->THEID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->THEID->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_PASIEN_DIAGNOSA_THEID" class="form-group PASIEN_DIAGNOSA_THEID">
<span<?= $Grid->THEID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->THEID->getDisplayValue($Grid->THEID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="PASIEN_DIAGNOSA" data-field="x_THEID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_THEID" id="x<?= $Grid->RowIndex ?>_THEID" value="<?= HtmlEncode($Grid->THEID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="PASIEN_DIAGNOSA" data-field="x_THEID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_THEID" id="o<?= $Grid->RowIndex ?>_THEID" value="<?= HtmlEncode($Grid->THEID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->GENDER->Visible) { // GENDER ?>
        <td data-name="GENDER">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_PASIEN_DIAGNOSA_GENDER" class="form-group PASIEN_DIAGNOSA_GENDER">
    <select
        id="x<?= $Grid->RowIndex ?>_GENDER"
        name="x<?= $Grid->RowIndex ?>_GENDER"
        class="form-control ew-select<?= $Grid->GENDER->isInvalidClass() ?>"
        data-select2-id="PASIEN_DIAGNOSA_x<?= $Grid->RowIndex ?>_GENDER"
        data-table="PASIEN_DIAGNOSA"
        data-field="x_GENDER"
        data-value-separator="<?= $Grid->GENDER->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->GENDER->getPlaceHolder()) ?>"
        <?= $Grid->GENDER->editAttributes() ?>>
        <?= $Grid->GENDER->selectOptionListHtml("x{$Grid->RowIndex}_GENDER") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->GENDER->getErrorMessage() ?></div>
<?= $Grid->GENDER->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_GENDER") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='PASIEN_DIAGNOSA_x<?= $Grid->RowIndex ?>_GENDER']"),
        options = { name: "x<?= $Grid->RowIndex ?>_GENDER", selectId: "PASIEN_DIAGNOSA_x<?= $Grid->RowIndex ?>_GENDER", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.PASIEN_DIAGNOSA.fields.GENDER.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_PASIEN_DIAGNOSA_GENDER" class="form-group PASIEN_DIAGNOSA_GENDER">
<span<?= $Grid->GENDER->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->GENDER->getDisplayValue($Grid->GENDER->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="PASIEN_DIAGNOSA" data-field="x_GENDER" data-hidden="1" name="x<?= $Grid->RowIndex ?>_GENDER" id="x<?= $Grid->RowIndex ?>_GENDER" value="<?= HtmlEncode($Grid->GENDER->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="PASIEN_DIAGNOSA" data-field="x_GENDER" data-hidden="1" name="o<?= $Grid->RowIndex ?>_GENDER" id="o<?= $Grid->RowIndex ?>_GENDER" value="<?= HtmlEncode($Grid->GENDER->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->TGLKONTROL->Visible) { // TGLKONTROL ?>
        <td data-name="TGLKONTROL">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_PASIEN_DIAGNOSA_TGLKONTROL" class="form-group PASIEN_DIAGNOSA_TGLKONTROL">
<input type="<?= $Grid->TGLKONTROL->getInputTextType() ?>" data-table="PASIEN_DIAGNOSA" data-field="x_TGLKONTROL" name="x<?= $Grid->RowIndex ?>_TGLKONTROL" id="x<?= $Grid->RowIndex ?>_TGLKONTROL" placeholder="<?= HtmlEncode($Grid->TGLKONTROL->getPlaceHolder()) ?>" value="<?= $Grid->TGLKONTROL->EditValue ?>"<?= $Grid->TGLKONTROL->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->TGLKONTROL->getErrorMessage() ?></div>
<?php if (!$Grid->TGLKONTROL->ReadOnly && !$Grid->TGLKONTROL->Disabled && !isset($Grid->TGLKONTROL->EditAttrs["readonly"]) && !isset($Grid->TGLKONTROL->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fPASIEN_DIAGNOSAgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fPASIEN_DIAGNOSAgrid", "x<?= $Grid->RowIndex ?>_TGLKONTROL", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_PASIEN_DIAGNOSA_TGLKONTROL" class="form-group PASIEN_DIAGNOSA_TGLKONTROL">
<span<?= $Grid->TGLKONTROL->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->TGLKONTROL->getDisplayValue($Grid->TGLKONTROL->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="PASIEN_DIAGNOSA" data-field="x_TGLKONTROL" data-hidden="1" name="x<?= $Grid->RowIndex ?>_TGLKONTROL" id="x<?= $Grid->RowIndex ?>_TGLKONTROL" value="<?= HtmlEncode($Grid->TGLKONTROL->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="PASIEN_DIAGNOSA" data-field="x_TGLKONTROL" data-hidden="1" name="o<?= $Grid->RowIndex ?>_TGLKONTROL" id="o<?= $Grid->RowIndex ?>_TGLKONTROL" value="<?= HtmlEncode($Grid->TGLKONTROL->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["fPASIEN_DIAGNOSAgrid","load"], function() {
    fPASIEN_DIAGNOSAgrid.updateLists(<?= $Grid->RowIndex ?>);
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
<input type="hidden" name="detailpage" value="fPASIEN_DIAGNOSAgrid">
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
    ew.addEventHandlers("PASIEN_DIAGNOSA");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
