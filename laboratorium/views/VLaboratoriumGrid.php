<?php

namespace PHPMaker2021\SIMRSSQLSERVERLABORATORIUM;

// Set up and run Grid object
$Grid = Container("VLaboratoriumGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fV_LABORATORIUMgrid;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    fV_LABORATORIUMgrid = new ew.Form("fV_LABORATORIUMgrid", "grid");
    fV_LABORATORIUMgrid.formKeyCountName = '<?= $Grid->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "V_LABORATORIUM")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.V_LABORATORIUM)
        ew.vars.tables.V_LABORATORIUM = currentTable;
    fV_LABORATORIUMgrid.addFields([
        ["NO_REGISTRATION", [fields.NO_REGISTRATION.visible && fields.NO_REGISTRATION.required ? ew.Validators.required(fields.NO_REGISTRATION.caption) : null], fields.NO_REGISTRATION.isInvalid],
        ["DIANTAR_OLEH", [fields.DIANTAR_OLEH.visible && fields.DIANTAR_OLEH.required ? ew.Validators.required(fields.DIANTAR_OLEH.caption) : null], fields.DIANTAR_OLEH.isInvalid],
        ["GENDER", [fields.GENDER.visible && fields.GENDER.required ? ew.Validators.required(fields.GENDER.caption) : null], fields.GENDER.isInvalid],
        ["VISITOR_ADDRESS", [fields.VISITOR_ADDRESS.visible && fields.VISITOR_ADDRESS.required ? ew.Validators.required(fields.VISITOR_ADDRESS.caption) : null], fields.VISITOR_ADDRESS.isInvalid],
        ["BOOKED_DATE", [fields.BOOKED_DATE.visible && fields.BOOKED_DATE.required ? ew.Validators.required(fields.BOOKED_DATE.caption) : null], fields.BOOKED_DATE.isInvalid],
        ["VISIT_DATE", [fields.VISIT_DATE.visible && fields.VISIT_DATE.required ? ew.Validators.required(fields.VISIT_DATE.caption) : null], fields.VISIT_DATE.isInvalid],
        ["CLINIC_ID", [fields.CLINIC_ID.visible && fields.CLINIC_ID.required ? ew.Validators.required(fields.CLINIC_ID.caption) : null], fields.CLINIC_ID.isInvalid],
        ["EMPLOYEE_ID", [fields.EMPLOYEE_ID.visible && fields.EMPLOYEE_ID.required ? ew.Validators.required(fields.EMPLOYEE_ID.caption) : null], fields.EMPLOYEE_ID.isInvalid],
        ["PAYOR_ID", [fields.PAYOR_ID.visible && fields.PAYOR_ID.required ? ew.Validators.required(fields.PAYOR_ID.caption) : null], fields.PAYOR_ID.isInvalid],
        ["CLASS_ID", [fields.CLASS_ID.visible && fields.CLASS_ID.required ? ew.Validators.required(fields.CLASS_ID.caption) : null], fields.CLASS_ID.isInvalid],
        ["PASIEN_ID", [fields.PASIEN_ID.visible && fields.PASIEN_ID.required ? ew.Validators.required(fields.PASIEN_ID.caption) : null], fields.PASIEN_ID.isInvalid],
        ["tgl_kontrol", [fields.tgl_kontrol.visible && fields.tgl_kontrol.required ? ew.Validators.required(fields.tgl_kontrol.caption) : null, ew.Validators.datetime(0)], fields.tgl_kontrol.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fV_LABORATORIUMgrid,
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
    fV_LABORATORIUMgrid.validate = function () {
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
    fV_LABORATORIUMgrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm();
        if (ew.valueChanged(fobj, rowIndex, "NO_REGISTRATION", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "DIANTAR_OLEH", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "GENDER", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "VISITOR_ADDRESS", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "VISIT_DATE", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "CLINIC_ID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "EMPLOYEE_ID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "PAYOR_ID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "CLASS_ID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "PASIEN_ID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "tgl_kontrol", false))
            return false;
        return true;
    }

    // Form_CustomValidate
    fV_LABORATORIUMgrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fV_LABORATORIUMgrid.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fV_LABORATORIUMgrid.lists.NO_REGISTRATION = <?= $Grid->NO_REGISTRATION->toClientList($Grid) ?>;
    fV_LABORATORIUMgrid.lists.GENDER = <?= $Grid->GENDER->toClientList($Grid) ?>;
    fV_LABORATORIUMgrid.lists.CLINIC_ID = <?= $Grid->CLINIC_ID->toClientList($Grid) ?>;
    fV_LABORATORIUMgrid.lists.EMPLOYEE_ID = <?= $Grid->EMPLOYEE_ID->toClientList($Grid) ?>;
    fV_LABORATORIUMgrid.lists.PAYOR_ID = <?= $Grid->PAYOR_ID->toClientList($Grid) ?>;
    fV_LABORATORIUMgrid.lists.CLASS_ID = <?= $Grid->CLASS_ID->toClientList($Grid) ?>;
    loadjs.done("fV_LABORATORIUMgrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> V_LABORATORIUM">
<?php if ($Grid->ShowOtherOptions) { ?>
<div class="card-header ew-grid-upper-panel">
<?php $Grid->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="fV_LABORATORIUMgrid" class="ew-form ew-list-form form-inline">
<div id="gmp_V_LABORATORIUM" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_V_LABORATORIUMgrid" class="table ew-table"><!-- .ew-table -->
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
        <th data-name="NO_REGISTRATION" class="<?= $Grid->NO_REGISTRATION->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_V_LABORATORIUM_NO_REGISTRATION" class="V_LABORATORIUM_NO_REGISTRATION"><?= $Grid->renderSort($Grid->NO_REGISTRATION) ?></div></th>
<?php } ?>
<?php if ($Grid->DIANTAR_OLEH->Visible) { // DIANTAR_OLEH ?>
        <th data-name="DIANTAR_OLEH" class="<?= $Grid->DIANTAR_OLEH->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_V_LABORATORIUM_DIANTAR_OLEH" class="V_LABORATORIUM_DIANTAR_OLEH"><?= $Grid->renderSort($Grid->DIANTAR_OLEH) ?></div></th>
<?php } ?>
<?php if ($Grid->GENDER->Visible) { // GENDER ?>
        <th data-name="GENDER" class="<?= $Grid->GENDER->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_V_LABORATORIUM_GENDER" class="V_LABORATORIUM_GENDER"><?= $Grid->renderSort($Grid->GENDER) ?></div></th>
<?php } ?>
<?php if ($Grid->VISITOR_ADDRESS->Visible) { // VISITOR_ADDRESS ?>
        <th data-name="VISITOR_ADDRESS" class="<?= $Grid->VISITOR_ADDRESS->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_V_LABORATORIUM_VISITOR_ADDRESS" class="V_LABORATORIUM_VISITOR_ADDRESS"><?= $Grid->renderSort($Grid->VISITOR_ADDRESS) ?></div></th>
<?php } ?>
<?php if ($Grid->BOOKED_DATE->Visible) { // BOOKED_DATE ?>
        <th data-name="BOOKED_DATE" class="<?= $Grid->BOOKED_DATE->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_V_LABORATORIUM_BOOKED_DATE" class="V_LABORATORIUM_BOOKED_DATE"><?= $Grid->renderSort($Grid->BOOKED_DATE) ?></div></th>
<?php } ?>
<?php if ($Grid->VISIT_DATE->Visible) { // VISIT_DATE ?>
        <th data-name="VISIT_DATE" class="<?= $Grid->VISIT_DATE->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_V_LABORATORIUM_VISIT_DATE" class="V_LABORATORIUM_VISIT_DATE"><?= $Grid->renderSort($Grid->VISIT_DATE) ?></div></th>
<?php } ?>
<?php if ($Grid->CLINIC_ID->Visible) { // CLINIC_ID ?>
        <th data-name="CLINIC_ID" class="<?= $Grid->CLINIC_ID->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_V_LABORATORIUM_CLINIC_ID" class="V_LABORATORIUM_CLINIC_ID"><?= $Grid->renderSort($Grid->CLINIC_ID) ?></div></th>
<?php } ?>
<?php if ($Grid->EMPLOYEE_ID->Visible) { // EMPLOYEE_ID ?>
        <th data-name="EMPLOYEE_ID" class="<?= $Grid->EMPLOYEE_ID->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_V_LABORATORIUM_EMPLOYEE_ID" class="V_LABORATORIUM_EMPLOYEE_ID"><?= $Grid->renderSort($Grid->EMPLOYEE_ID) ?></div></th>
<?php } ?>
<?php if ($Grid->PAYOR_ID->Visible) { // PAYOR_ID ?>
        <th data-name="PAYOR_ID" class="<?= $Grid->PAYOR_ID->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_V_LABORATORIUM_PAYOR_ID" class="V_LABORATORIUM_PAYOR_ID"><?= $Grid->renderSort($Grid->PAYOR_ID) ?></div></th>
<?php } ?>
<?php if ($Grid->CLASS_ID->Visible) { // CLASS_ID ?>
        <th data-name="CLASS_ID" class="<?= $Grid->CLASS_ID->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_V_LABORATORIUM_CLASS_ID" class="V_LABORATORIUM_CLASS_ID"><?= $Grid->renderSort($Grid->CLASS_ID) ?></div></th>
<?php } ?>
<?php if ($Grid->PASIEN_ID->Visible) { // PASIEN_ID ?>
        <th data-name="PASIEN_ID" class="<?= $Grid->PASIEN_ID->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_V_LABORATORIUM_PASIEN_ID" class="V_LABORATORIUM_PASIEN_ID"><?= $Grid->renderSort($Grid->PASIEN_ID) ?></div></th>
<?php } ?>
<?php if ($Grid->tgl_kontrol->Visible) { // tgl_kontrol ?>
        <th data-name="tgl_kontrol" class="<?= $Grid->tgl_kontrol->headerCellClass() ?>"><div id="elh_V_LABORATORIUM_tgl_kontrol" class="V_LABORATORIUM_tgl_kontrol"><?= $Grid->renderSort($Grid->tgl_kontrol) ?></div></th>
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowCount, "id" => "r" . $Grid->RowCount . "_V_LABORATORIUM", "data-rowtype" => $Grid->RowType]);

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
<span id="el<?= $Grid->RowCount ?>_V_LABORATORIUM_NO_REGISTRATION" class="form-group">
<span<?= $Grid->NO_REGISTRATION->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->NO_REGISTRATION->getDisplayValue($Grid->NO_REGISTRATION->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" name="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" value="<?= HtmlEncode($Grid->NO_REGISTRATION->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_V_LABORATORIUM_NO_REGISTRATION" class="form-group">
<div class="input-group ew-lookup-list">
    <div class="form-control ew-lookup-text" tabindex="-1" id="lu_x<?= $Grid->RowIndex ?>_NO_REGISTRATION"><?= EmptyValue(strval($Grid->NO_REGISTRATION->ViewValue)) ? $Language->phrase("PleaseSelect") : $Grid->NO_REGISTRATION->ViewValue ?></div>
    <div class="input-group-append">
        <button type="button" title="<?= HtmlEncode(str_replace("%s", RemoveHtml($Grid->NO_REGISTRATION->caption()), $Language->phrase("LookupLink", true))) ?>" class="ew-lookup-btn btn btn-default"<?= ($Grid->NO_REGISTRATION->ReadOnly || $Grid->NO_REGISTRATION->Disabled) ? " disabled" : "" ?> onclick="ew.modalLookupShow({lnk:this,el:'x<?= $Grid->RowIndex ?>_NO_REGISTRATION',m:0,n:10});"><i class="fas fa-search ew-icon"></i></button>
    </div>
</div>
<div class="invalid-feedback"><?= $Grid->NO_REGISTRATION->getErrorMessage() ?></div>
<?= $Grid->NO_REGISTRATION->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_NO_REGISTRATION") ?>
<input type="hidden" is="selection-list" data-table="V_LABORATORIUM" data-field="x_NO_REGISTRATION" data-type="text" data-multiple="0" data-lookup="1" data-value-separator="<?= $Grid->NO_REGISTRATION->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" id="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" value="<?= $Grid->NO_REGISTRATION->CurrentValue ?>"<?= $Grid->NO_REGISTRATION->editAttributes() ?>>
</span>
<?php } ?>
<input type="hidden" data-table="V_LABORATORIUM" data-field="x_NO_REGISTRATION" data-hidden="1" name="o<?= $Grid->RowIndex ?>_NO_REGISTRATION" id="o<?= $Grid->RowIndex ?>_NO_REGISTRATION" value="<?= HtmlEncode($Grid->NO_REGISTRATION->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_LABORATORIUM_NO_REGISTRATION" class="form-group">
<span<?= $Grid->NO_REGISTRATION->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->NO_REGISTRATION->getDisplayValue($Grid->NO_REGISTRATION->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_LABORATORIUM" data-field="x_NO_REGISTRATION" data-hidden="1" name="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" id="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" value="<?= HtmlEncode($Grid->NO_REGISTRATION->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_LABORATORIUM_NO_REGISTRATION">
<span<?= $Grid->NO_REGISTRATION->viewAttributes() ?>>
<?= $Grid->NO_REGISTRATION->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_LABORATORIUM" data-field="x_NO_REGISTRATION" data-hidden="1" name="fV_LABORATORIUMgrid$x<?= $Grid->RowIndex ?>_NO_REGISTRATION" id="fV_LABORATORIUMgrid$x<?= $Grid->RowIndex ?>_NO_REGISTRATION" value="<?= HtmlEncode($Grid->NO_REGISTRATION->FormValue) ?>">
<input type="hidden" data-table="V_LABORATORIUM" data-field="x_NO_REGISTRATION" data-hidden="1" name="fV_LABORATORIUMgrid$o<?= $Grid->RowIndex ?>_NO_REGISTRATION" id="fV_LABORATORIUMgrid$o<?= $Grid->RowIndex ?>_NO_REGISTRATION" value="<?= HtmlEncode($Grid->NO_REGISTRATION->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->DIANTAR_OLEH->Visible) { // DIANTAR_OLEH ?>
        <td data-name="DIANTAR_OLEH" <?= $Grid->DIANTAR_OLEH->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Grid->DIANTAR_OLEH->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_V_LABORATORIUM_DIANTAR_OLEH" class="form-group">
<span<?= $Grid->DIANTAR_OLEH->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->DIANTAR_OLEH->getDisplayValue($Grid->DIANTAR_OLEH->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_DIANTAR_OLEH" name="x<?= $Grid->RowIndex ?>_DIANTAR_OLEH" value="<?= HtmlEncode($Grid->DIANTAR_OLEH->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_V_LABORATORIUM_DIANTAR_OLEH" class="form-group">
<input type="<?= $Grid->DIANTAR_OLEH->getInputTextType() ?>" data-table="V_LABORATORIUM" data-field="x_DIANTAR_OLEH" name="x<?= $Grid->RowIndex ?>_DIANTAR_OLEH" id="x<?= $Grid->RowIndex ?>_DIANTAR_OLEH" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->DIANTAR_OLEH->getPlaceHolder()) ?>" value="<?= $Grid->DIANTAR_OLEH->EditValue ?>"<?= $Grid->DIANTAR_OLEH->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->DIANTAR_OLEH->getErrorMessage() ?></div>
</span>
<?php } ?>
<input type="hidden" data-table="V_LABORATORIUM" data-field="x_DIANTAR_OLEH" data-hidden="1" name="o<?= $Grid->RowIndex ?>_DIANTAR_OLEH" id="o<?= $Grid->RowIndex ?>_DIANTAR_OLEH" value="<?= HtmlEncode($Grid->DIANTAR_OLEH->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_LABORATORIUM_DIANTAR_OLEH" class="form-group">
<span<?= $Grid->DIANTAR_OLEH->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->DIANTAR_OLEH->getDisplayValue($Grid->DIANTAR_OLEH->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_LABORATORIUM" data-field="x_DIANTAR_OLEH" data-hidden="1" name="x<?= $Grid->RowIndex ?>_DIANTAR_OLEH" id="x<?= $Grid->RowIndex ?>_DIANTAR_OLEH" value="<?= HtmlEncode($Grid->DIANTAR_OLEH->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_LABORATORIUM_DIANTAR_OLEH">
<span<?= $Grid->DIANTAR_OLEH->viewAttributes() ?>>
<?= $Grid->DIANTAR_OLEH->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_LABORATORIUM" data-field="x_DIANTAR_OLEH" data-hidden="1" name="fV_LABORATORIUMgrid$x<?= $Grid->RowIndex ?>_DIANTAR_OLEH" id="fV_LABORATORIUMgrid$x<?= $Grid->RowIndex ?>_DIANTAR_OLEH" value="<?= HtmlEncode($Grid->DIANTAR_OLEH->FormValue) ?>">
<input type="hidden" data-table="V_LABORATORIUM" data-field="x_DIANTAR_OLEH" data-hidden="1" name="fV_LABORATORIUMgrid$o<?= $Grid->RowIndex ?>_DIANTAR_OLEH" id="fV_LABORATORIUMgrid$o<?= $Grid->RowIndex ?>_DIANTAR_OLEH" value="<?= HtmlEncode($Grid->DIANTAR_OLEH->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->GENDER->Visible) { // GENDER ?>
        <td data-name="GENDER" <?= $Grid->GENDER->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Grid->GENDER->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_V_LABORATORIUM_GENDER" class="form-group">
<span<?= $Grid->GENDER->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->GENDER->getDisplayValue($Grid->GENDER->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_GENDER" name="x<?= $Grid->RowIndex ?>_GENDER" value="<?= HtmlEncode($Grid->GENDER->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_V_LABORATORIUM_GENDER" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_GENDER"
        name="x<?= $Grid->RowIndex ?>_GENDER"
        class="form-control ew-select<?= $Grid->GENDER->isInvalidClass() ?>"
        data-select2-id="V_LABORATORIUM_x<?= $Grid->RowIndex ?>_GENDER"
        data-table="V_LABORATORIUM"
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
    var el = document.querySelector("select[data-select2-id='V_LABORATORIUM_x<?= $Grid->RowIndex ?>_GENDER']"),
        options = { name: "x<?= $Grid->RowIndex ?>_GENDER", selectId: "V_LABORATORIUM_x<?= $Grid->RowIndex ?>_GENDER", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.V_LABORATORIUM.fields.GENDER.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="V_LABORATORIUM" data-field="x_GENDER" data-hidden="1" name="o<?= $Grid->RowIndex ?>_GENDER" id="o<?= $Grid->RowIndex ?>_GENDER" value="<?= HtmlEncode($Grid->GENDER->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_LABORATORIUM_GENDER" class="form-group">
<span<?= $Grid->GENDER->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->GENDER->getDisplayValue($Grid->GENDER->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_LABORATORIUM" data-field="x_GENDER" data-hidden="1" name="x<?= $Grid->RowIndex ?>_GENDER" id="x<?= $Grid->RowIndex ?>_GENDER" value="<?= HtmlEncode($Grid->GENDER->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_LABORATORIUM_GENDER">
<span<?= $Grid->GENDER->viewAttributes() ?>>
<?= $Grid->GENDER->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_LABORATORIUM" data-field="x_GENDER" data-hidden="1" name="fV_LABORATORIUMgrid$x<?= $Grid->RowIndex ?>_GENDER" id="fV_LABORATORIUMgrid$x<?= $Grid->RowIndex ?>_GENDER" value="<?= HtmlEncode($Grid->GENDER->FormValue) ?>">
<input type="hidden" data-table="V_LABORATORIUM" data-field="x_GENDER" data-hidden="1" name="fV_LABORATORIUMgrid$o<?= $Grid->RowIndex ?>_GENDER" id="fV_LABORATORIUMgrid$o<?= $Grid->RowIndex ?>_GENDER" value="<?= HtmlEncode($Grid->GENDER->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->VISITOR_ADDRESS->Visible) { // VISITOR_ADDRESS ?>
        <td data-name="VISITOR_ADDRESS" <?= $Grid->VISITOR_ADDRESS->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Grid->VISITOR_ADDRESS->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_V_LABORATORIUM_VISITOR_ADDRESS" class="form-group">
<span<?= $Grid->VISITOR_ADDRESS->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->VISITOR_ADDRESS->getDisplayValue($Grid->VISITOR_ADDRESS->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_VISITOR_ADDRESS" name="x<?= $Grid->RowIndex ?>_VISITOR_ADDRESS" value="<?= HtmlEncode($Grid->VISITOR_ADDRESS->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_V_LABORATORIUM_VISITOR_ADDRESS" class="form-group">
<input type="<?= $Grid->VISITOR_ADDRESS->getInputTextType() ?>" data-table="V_LABORATORIUM" data-field="x_VISITOR_ADDRESS" name="x<?= $Grid->RowIndex ?>_VISITOR_ADDRESS" id="x<?= $Grid->RowIndex ?>_VISITOR_ADDRESS" size="30" maxlength="150" placeholder="<?= HtmlEncode($Grid->VISITOR_ADDRESS->getPlaceHolder()) ?>" value="<?= $Grid->VISITOR_ADDRESS->EditValue ?>"<?= $Grid->VISITOR_ADDRESS->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->VISITOR_ADDRESS->getErrorMessage() ?></div>
</span>
<?php } ?>
<input type="hidden" data-table="V_LABORATORIUM" data-field="x_VISITOR_ADDRESS" data-hidden="1" name="o<?= $Grid->RowIndex ?>_VISITOR_ADDRESS" id="o<?= $Grid->RowIndex ?>_VISITOR_ADDRESS" value="<?= HtmlEncode($Grid->VISITOR_ADDRESS->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_LABORATORIUM_VISITOR_ADDRESS" class="form-group">
<span<?= $Grid->VISITOR_ADDRESS->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->VISITOR_ADDRESS->getDisplayValue($Grid->VISITOR_ADDRESS->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_LABORATORIUM" data-field="x_VISITOR_ADDRESS" data-hidden="1" name="x<?= $Grid->RowIndex ?>_VISITOR_ADDRESS" id="x<?= $Grid->RowIndex ?>_VISITOR_ADDRESS" value="<?= HtmlEncode($Grid->VISITOR_ADDRESS->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_LABORATORIUM_VISITOR_ADDRESS">
<span<?= $Grid->VISITOR_ADDRESS->viewAttributes() ?>>
<?= $Grid->VISITOR_ADDRESS->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_LABORATORIUM" data-field="x_VISITOR_ADDRESS" data-hidden="1" name="fV_LABORATORIUMgrid$x<?= $Grid->RowIndex ?>_VISITOR_ADDRESS" id="fV_LABORATORIUMgrid$x<?= $Grid->RowIndex ?>_VISITOR_ADDRESS" value="<?= HtmlEncode($Grid->VISITOR_ADDRESS->FormValue) ?>">
<input type="hidden" data-table="V_LABORATORIUM" data-field="x_VISITOR_ADDRESS" data-hidden="1" name="fV_LABORATORIUMgrid$o<?= $Grid->RowIndex ?>_VISITOR_ADDRESS" id="fV_LABORATORIUMgrid$o<?= $Grid->RowIndex ?>_VISITOR_ADDRESS" value="<?= HtmlEncode($Grid->VISITOR_ADDRESS->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->BOOKED_DATE->Visible) { // BOOKED_DATE ?>
        <td data-name="BOOKED_DATE" <?= $Grid->BOOKED_DATE->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="V_LABORATORIUM" data-field="x_BOOKED_DATE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_BOOKED_DATE" id="o<?= $Grid->RowIndex ?>_BOOKED_DATE" value="<?= HtmlEncode($Grid->BOOKED_DATE->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_LABORATORIUM_BOOKED_DATE">
<span<?= $Grid->BOOKED_DATE->viewAttributes() ?>>
<?= $Grid->BOOKED_DATE->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_LABORATORIUM" data-field="x_BOOKED_DATE" data-hidden="1" name="fV_LABORATORIUMgrid$x<?= $Grid->RowIndex ?>_BOOKED_DATE" id="fV_LABORATORIUMgrid$x<?= $Grid->RowIndex ?>_BOOKED_DATE" value="<?= HtmlEncode($Grid->BOOKED_DATE->FormValue) ?>">
<input type="hidden" data-table="V_LABORATORIUM" data-field="x_BOOKED_DATE" data-hidden="1" name="fV_LABORATORIUMgrid$o<?= $Grid->RowIndex ?>_BOOKED_DATE" id="fV_LABORATORIUMgrid$o<?= $Grid->RowIndex ?>_BOOKED_DATE" value="<?= HtmlEncode($Grid->BOOKED_DATE->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->VISIT_DATE->Visible) { // VISIT_DATE ?>
        <td data-name="VISIT_DATE" <?= $Grid->VISIT_DATE->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_LABORATORIUM_VISIT_DATE" class="form-group">
<input type="<?= $Grid->VISIT_DATE->getInputTextType() ?>" data-table="V_LABORATORIUM" data-field="x_VISIT_DATE" data-format="11" name="x<?= $Grid->RowIndex ?>_VISIT_DATE" id="x<?= $Grid->RowIndex ?>_VISIT_DATE" placeholder="<?= HtmlEncode($Grid->VISIT_DATE->getPlaceHolder()) ?>" value="<?= $Grid->VISIT_DATE->EditValue ?>"<?= $Grid->VISIT_DATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->VISIT_DATE->getErrorMessage() ?></div>
<?php if (!$Grid->VISIT_DATE->ReadOnly && !$Grid->VISIT_DATE->Disabled && !isset($Grid->VISIT_DATE->EditAttrs["readonly"]) && !isset($Grid->VISIT_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fV_LABORATORIUMgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fV_LABORATORIUMgrid", "x<?= $Grid->RowIndex ?>_VISIT_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":11});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="V_LABORATORIUM" data-field="x_VISIT_DATE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_VISIT_DATE" id="o<?= $Grid->RowIndex ?>_VISIT_DATE" value="<?= HtmlEncode($Grid->VISIT_DATE->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_LABORATORIUM_VISIT_DATE" class="form-group">
<span<?= $Grid->VISIT_DATE->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->VISIT_DATE->getDisplayValue($Grid->VISIT_DATE->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_LABORATORIUM" data-field="x_VISIT_DATE" data-hidden="1" name="x<?= $Grid->RowIndex ?>_VISIT_DATE" id="x<?= $Grid->RowIndex ?>_VISIT_DATE" value="<?= HtmlEncode($Grid->VISIT_DATE->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_LABORATORIUM_VISIT_DATE">
<span<?= $Grid->VISIT_DATE->viewAttributes() ?>>
<?= $Grid->VISIT_DATE->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_LABORATORIUM" data-field="x_VISIT_DATE" data-hidden="1" name="fV_LABORATORIUMgrid$x<?= $Grid->RowIndex ?>_VISIT_DATE" id="fV_LABORATORIUMgrid$x<?= $Grid->RowIndex ?>_VISIT_DATE" value="<?= HtmlEncode($Grid->VISIT_DATE->FormValue) ?>">
<input type="hidden" data-table="V_LABORATORIUM" data-field="x_VISIT_DATE" data-hidden="1" name="fV_LABORATORIUMgrid$o<?= $Grid->RowIndex ?>_VISIT_DATE" id="fV_LABORATORIUMgrid$o<?= $Grid->RowIndex ?>_VISIT_DATE" value="<?= HtmlEncode($Grid->VISIT_DATE->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->CLINIC_ID->Visible) { // CLINIC_ID ?>
        <td data-name="CLINIC_ID" <?= $Grid->CLINIC_ID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_LABORATORIUM_CLINIC_ID" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_CLINIC_ID"
        name="x<?= $Grid->RowIndex ?>_CLINIC_ID"
        class="form-control ew-select<?= $Grid->CLINIC_ID->isInvalidClass() ?>"
        data-select2-id="V_LABORATORIUM_x<?= $Grid->RowIndex ?>_CLINIC_ID"
        data-table="V_LABORATORIUM"
        data-field="x_CLINIC_ID"
        data-value-separator="<?= $Grid->CLINIC_ID->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->CLINIC_ID->getPlaceHolder()) ?>"
        <?= $Grid->CLINIC_ID->editAttributes() ?>>
        <?= $Grid->CLINIC_ID->selectOptionListHtml("x{$Grid->RowIndex}_CLINIC_ID") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->CLINIC_ID->getErrorMessage() ?></div>
<?= $Grid->CLINIC_ID->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_CLINIC_ID") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='V_LABORATORIUM_x<?= $Grid->RowIndex ?>_CLINIC_ID']"),
        options = { name: "x<?= $Grid->RowIndex ?>_CLINIC_ID", selectId: "V_LABORATORIUM_x<?= $Grid->RowIndex ?>_CLINIC_ID", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.V_LABORATORIUM.fields.CLINIC_ID.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="V_LABORATORIUM" data-field="x_CLINIC_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_CLINIC_ID" id="o<?= $Grid->RowIndex ?>_CLINIC_ID" value="<?= HtmlEncode($Grid->CLINIC_ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_LABORATORIUM_CLINIC_ID" class="form-group">
<span<?= $Grid->CLINIC_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->CLINIC_ID->getDisplayValue($Grid->CLINIC_ID->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_LABORATORIUM" data-field="x_CLINIC_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_CLINIC_ID" id="x<?= $Grid->RowIndex ?>_CLINIC_ID" value="<?= HtmlEncode($Grid->CLINIC_ID->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_LABORATORIUM_CLINIC_ID">
<span<?= $Grid->CLINIC_ID->viewAttributes() ?>>
<?= $Grid->CLINIC_ID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_LABORATORIUM" data-field="x_CLINIC_ID" data-hidden="1" name="fV_LABORATORIUMgrid$x<?= $Grid->RowIndex ?>_CLINIC_ID" id="fV_LABORATORIUMgrid$x<?= $Grid->RowIndex ?>_CLINIC_ID" value="<?= HtmlEncode($Grid->CLINIC_ID->FormValue) ?>">
<input type="hidden" data-table="V_LABORATORIUM" data-field="x_CLINIC_ID" data-hidden="1" name="fV_LABORATORIUMgrid$o<?= $Grid->RowIndex ?>_CLINIC_ID" id="fV_LABORATORIUMgrid$o<?= $Grid->RowIndex ?>_CLINIC_ID" value="<?= HtmlEncode($Grid->CLINIC_ID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->EMPLOYEE_ID->Visible) { // EMPLOYEE_ID ?>
        <td data-name="EMPLOYEE_ID" <?= $Grid->EMPLOYEE_ID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_LABORATORIUM_EMPLOYEE_ID" class="form-group">
<?php
$onchange = $Grid->EMPLOYEE_ID->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Grid->EMPLOYEE_ID->EditAttrs["onchange"] = "";
?>
<span id="as_x<?= $Grid->RowIndex ?>_EMPLOYEE_ID" class="ew-auto-suggest">
    <input type="<?= $Grid->EMPLOYEE_ID->getInputTextType() ?>" class="form-control" name="sv_x<?= $Grid->RowIndex ?>_EMPLOYEE_ID" id="sv_x<?= $Grid->RowIndex ?>_EMPLOYEE_ID" value="<?= RemoveHtml($Grid->EMPLOYEE_ID->EditValue) ?>" size="30" maxlength="15" placeholder="<?= HtmlEncode($Grid->EMPLOYEE_ID->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Grid->EMPLOYEE_ID->getPlaceHolder()) ?>"<?= $Grid->EMPLOYEE_ID->editAttributes() ?>>
</span>
<input type="hidden" is="selection-list" class="form-control" data-table="V_LABORATORIUM" data-field="x_EMPLOYEE_ID" data-input="sv_x<?= $Grid->RowIndex ?>_EMPLOYEE_ID" data-value-separator="<?= $Grid->EMPLOYEE_ID->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_EMPLOYEE_ID" id="x<?= $Grid->RowIndex ?>_EMPLOYEE_ID" value="<?= HtmlEncode($Grid->EMPLOYEE_ID->CurrentValue) ?>"<?= $onchange ?>>
<div class="invalid-feedback"><?= $Grid->EMPLOYEE_ID->getErrorMessage() ?></div>
<script>
loadjs.ready(["fV_LABORATORIUMgrid"], function() {
    fV_LABORATORIUMgrid.createAutoSuggest(Object.assign({"id":"x<?= $Grid->RowIndex ?>_EMPLOYEE_ID","forceSelect":false}, ew.vars.tables.V_LABORATORIUM.fields.EMPLOYEE_ID.autoSuggestOptions));
});
</script>
<?= $Grid->EMPLOYEE_ID->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_EMPLOYEE_ID") ?>
</span>
<input type="hidden" data-table="V_LABORATORIUM" data-field="x_EMPLOYEE_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_EMPLOYEE_ID" id="o<?= $Grid->RowIndex ?>_EMPLOYEE_ID" value="<?= HtmlEncode($Grid->EMPLOYEE_ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_LABORATORIUM_EMPLOYEE_ID" class="form-group">
<?php
$onchange = $Grid->EMPLOYEE_ID->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Grid->EMPLOYEE_ID->EditAttrs["onchange"] = "";
?>
<span id="as_x<?= $Grid->RowIndex ?>_EMPLOYEE_ID" class="ew-auto-suggest">
    <input type="<?= $Grid->EMPLOYEE_ID->getInputTextType() ?>" class="form-control" name="sv_x<?= $Grid->RowIndex ?>_EMPLOYEE_ID" id="sv_x<?= $Grid->RowIndex ?>_EMPLOYEE_ID" value="<?= RemoveHtml($Grid->EMPLOYEE_ID->EditValue) ?>" size="30" maxlength="15" placeholder="<?= HtmlEncode($Grid->EMPLOYEE_ID->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Grid->EMPLOYEE_ID->getPlaceHolder()) ?>"<?= $Grid->EMPLOYEE_ID->editAttributes() ?>>
</span>
<input type="hidden" is="selection-list" class="form-control" data-table="V_LABORATORIUM" data-field="x_EMPLOYEE_ID" data-input="sv_x<?= $Grid->RowIndex ?>_EMPLOYEE_ID" data-value-separator="<?= $Grid->EMPLOYEE_ID->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_EMPLOYEE_ID" id="x<?= $Grid->RowIndex ?>_EMPLOYEE_ID" value="<?= HtmlEncode($Grid->EMPLOYEE_ID->CurrentValue) ?>"<?= $onchange ?>>
<div class="invalid-feedback"><?= $Grid->EMPLOYEE_ID->getErrorMessage() ?></div>
<script>
loadjs.ready(["fV_LABORATORIUMgrid"], function() {
    fV_LABORATORIUMgrid.createAutoSuggest(Object.assign({"id":"x<?= $Grid->RowIndex ?>_EMPLOYEE_ID","forceSelect":false}, ew.vars.tables.V_LABORATORIUM.fields.EMPLOYEE_ID.autoSuggestOptions));
});
</script>
<?= $Grid->EMPLOYEE_ID->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_EMPLOYEE_ID") ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_LABORATORIUM_EMPLOYEE_ID">
<span<?= $Grid->EMPLOYEE_ID->viewAttributes() ?>>
<?= $Grid->EMPLOYEE_ID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_LABORATORIUM" data-field="x_EMPLOYEE_ID" data-hidden="1" name="fV_LABORATORIUMgrid$x<?= $Grid->RowIndex ?>_EMPLOYEE_ID" id="fV_LABORATORIUMgrid$x<?= $Grid->RowIndex ?>_EMPLOYEE_ID" value="<?= HtmlEncode($Grid->EMPLOYEE_ID->FormValue) ?>">
<input type="hidden" data-table="V_LABORATORIUM" data-field="x_EMPLOYEE_ID" data-hidden="1" name="fV_LABORATORIUMgrid$o<?= $Grid->RowIndex ?>_EMPLOYEE_ID" id="fV_LABORATORIUMgrid$o<?= $Grid->RowIndex ?>_EMPLOYEE_ID" value="<?= HtmlEncode($Grid->EMPLOYEE_ID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->PAYOR_ID->Visible) { // PAYOR_ID ?>
        <td data-name="PAYOR_ID" <?= $Grid->PAYOR_ID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_LABORATORIUM_PAYOR_ID" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_PAYOR_ID"
        name="x<?= $Grid->RowIndex ?>_PAYOR_ID"
        class="form-control ew-select<?= $Grid->PAYOR_ID->isInvalidClass() ?>"
        data-select2-id="V_LABORATORIUM_x<?= $Grid->RowIndex ?>_PAYOR_ID"
        data-table="V_LABORATORIUM"
        data-field="x_PAYOR_ID"
        data-value-separator="<?= $Grid->PAYOR_ID->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->PAYOR_ID->getPlaceHolder()) ?>"
        <?= $Grid->PAYOR_ID->editAttributes() ?>>
        <?= $Grid->PAYOR_ID->selectOptionListHtml("x{$Grid->RowIndex}_PAYOR_ID") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->PAYOR_ID->getErrorMessage() ?></div>
<?= $Grid->PAYOR_ID->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_PAYOR_ID") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='V_LABORATORIUM_x<?= $Grid->RowIndex ?>_PAYOR_ID']"),
        options = { name: "x<?= $Grid->RowIndex ?>_PAYOR_ID", selectId: "V_LABORATORIUM_x<?= $Grid->RowIndex ?>_PAYOR_ID", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.V_LABORATORIUM.fields.PAYOR_ID.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="V_LABORATORIUM" data-field="x_PAYOR_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_PAYOR_ID" id="o<?= $Grid->RowIndex ?>_PAYOR_ID" value="<?= HtmlEncode($Grid->PAYOR_ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_LABORATORIUM_PAYOR_ID" class="form-group">
<span<?= $Grid->PAYOR_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->PAYOR_ID->getDisplayValue($Grid->PAYOR_ID->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_LABORATORIUM" data-field="x_PAYOR_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_PAYOR_ID" id="x<?= $Grid->RowIndex ?>_PAYOR_ID" value="<?= HtmlEncode($Grid->PAYOR_ID->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_LABORATORIUM_PAYOR_ID">
<span<?= $Grid->PAYOR_ID->viewAttributes() ?>>
<?= $Grid->PAYOR_ID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_LABORATORIUM" data-field="x_PAYOR_ID" data-hidden="1" name="fV_LABORATORIUMgrid$x<?= $Grid->RowIndex ?>_PAYOR_ID" id="fV_LABORATORIUMgrid$x<?= $Grid->RowIndex ?>_PAYOR_ID" value="<?= HtmlEncode($Grid->PAYOR_ID->FormValue) ?>">
<input type="hidden" data-table="V_LABORATORIUM" data-field="x_PAYOR_ID" data-hidden="1" name="fV_LABORATORIUMgrid$o<?= $Grid->RowIndex ?>_PAYOR_ID" id="fV_LABORATORIUMgrid$o<?= $Grid->RowIndex ?>_PAYOR_ID" value="<?= HtmlEncode($Grid->PAYOR_ID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->CLASS_ID->Visible) { // CLASS_ID ?>
        <td data-name="CLASS_ID" <?= $Grid->CLASS_ID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_LABORATORIUM_CLASS_ID" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_CLASS_ID"
        name="x<?= $Grid->RowIndex ?>_CLASS_ID"
        class="form-control ew-select<?= $Grid->CLASS_ID->isInvalidClass() ?>"
        data-select2-id="V_LABORATORIUM_x<?= $Grid->RowIndex ?>_CLASS_ID"
        data-table="V_LABORATORIUM"
        data-field="x_CLASS_ID"
        data-value-separator="<?= $Grid->CLASS_ID->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->CLASS_ID->getPlaceHolder()) ?>"
        <?= $Grid->CLASS_ID->editAttributes() ?>>
        <?= $Grid->CLASS_ID->selectOptionListHtml("x{$Grid->RowIndex}_CLASS_ID") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->CLASS_ID->getErrorMessage() ?></div>
<?= $Grid->CLASS_ID->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_CLASS_ID") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='V_LABORATORIUM_x<?= $Grid->RowIndex ?>_CLASS_ID']"),
        options = { name: "x<?= $Grid->RowIndex ?>_CLASS_ID", selectId: "V_LABORATORIUM_x<?= $Grid->RowIndex ?>_CLASS_ID", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.V_LABORATORIUM.fields.CLASS_ID.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="V_LABORATORIUM" data-field="x_CLASS_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_CLASS_ID" id="o<?= $Grid->RowIndex ?>_CLASS_ID" value="<?= HtmlEncode($Grid->CLASS_ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_LABORATORIUM_CLASS_ID" class="form-group">
<span<?= $Grid->CLASS_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->CLASS_ID->getDisplayValue($Grid->CLASS_ID->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_LABORATORIUM" data-field="x_CLASS_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_CLASS_ID" id="x<?= $Grid->RowIndex ?>_CLASS_ID" value="<?= HtmlEncode($Grid->CLASS_ID->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_LABORATORIUM_CLASS_ID">
<span<?= $Grid->CLASS_ID->viewAttributes() ?>>
<?= $Grid->CLASS_ID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_LABORATORIUM" data-field="x_CLASS_ID" data-hidden="1" name="fV_LABORATORIUMgrid$x<?= $Grid->RowIndex ?>_CLASS_ID" id="fV_LABORATORIUMgrid$x<?= $Grid->RowIndex ?>_CLASS_ID" value="<?= HtmlEncode($Grid->CLASS_ID->FormValue) ?>">
<input type="hidden" data-table="V_LABORATORIUM" data-field="x_CLASS_ID" data-hidden="1" name="fV_LABORATORIUMgrid$o<?= $Grid->RowIndex ?>_CLASS_ID" id="fV_LABORATORIUMgrid$o<?= $Grid->RowIndex ?>_CLASS_ID" value="<?= HtmlEncode($Grid->CLASS_ID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->PASIEN_ID->Visible) { // PASIEN_ID ?>
        <td data-name="PASIEN_ID" <?= $Grid->PASIEN_ID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_LABORATORIUM_PASIEN_ID" class="form-group">
<input type="<?= $Grid->PASIEN_ID->getInputTextType() ?>" data-table="V_LABORATORIUM" data-field="x_PASIEN_ID" name="x<?= $Grid->RowIndex ?>_PASIEN_ID" id="x<?= $Grid->RowIndex ?>_PASIEN_ID" size="30" maxlength="30" placeholder="<?= HtmlEncode($Grid->PASIEN_ID->getPlaceHolder()) ?>" value="<?= $Grid->PASIEN_ID->EditValue ?>"<?= $Grid->PASIEN_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->PASIEN_ID->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_LABORATORIUM" data-field="x_PASIEN_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_PASIEN_ID" id="o<?= $Grid->RowIndex ?>_PASIEN_ID" value="<?= HtmlEncode($Grid->PASIEN_ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_LABORATORIUM_PASIEN_ID" class="form-group">
<span<?= $Grid->PASIEN_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->PASIEN_ID->getDisplayValue($Grid->PASIEN_ID->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_LABORATORIUM" data-field="x_PASIEN_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_PASIEN_ID" id="x<?= $Grid->RowIndex ?>_PASIEN_ID" value="<?= HtmlEncode($Grid->PASIEN_ID->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_LABORATORIUM_PASIEN_ID">
<span<?= $Grid->PASIEN_ID->viewAttributes() ?>>
<?= $Grid->PASIEN_ID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_LABORATORIUM" data-field="x_PASIEN_ID" data-hidden="1" name="fV_LABORATORIUMgrid$x<?= $Grid->RowIndex ?>_PASIEN_ID" id="fV_LABORATORIUMgrid$x<?= $Grid->RowIndex ?>_PASIEN_ID" value="<?= HtmlEncode($Grid->PASIEN_ID->FormValue) ?>">
<input type="hidden" data-table="V_LABORATORIUM" data-field="x_PASIEN_ID" data-hidden="1" name="fV_LABORATORIUMgrid$o<?= $Grid->RowIndex ?>_PASIEN_ID" id="fV_LABORATORIUMgrid$o<?= $Grid->RowIndex ?>_PASIEN_ID" value="<?= HtmlEncode($Grid->PASIEN_ID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->tgl_kontrol->Visible) { // tgl_kontrol ?>
        <td data-name="tgl_kontrol" <?= $Grid->tgl_kontrol->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_LABORATORIUM_tgl_kontrol" class="form-group">
<input type="<?= $Grid->tgl_kontrol->getInputTextType() ?>" data-table="V_LABORATORIUM" data-field="x_tgl_kontrol" name="x<?= $Grid->RowIndex ?>_tgl_kontrol" id="x<?= $Grid->RowIndex ?>_tgl_kontrol" placeholder="<?= HtmlEncode($Grid->tgl_kontrol->getPlaceHolder()) ?>" value="<?= $Grid->tgl_kontrol->EditValue ?>"<?= $Grid->tgl_kontrol->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->tgl_kontrol->getErrorMessage() ?></div>
<?php if (!$Grid->tgl_kontrol->ReadOnly && !$Grid->tgl_kontrol->Disabled && !isset($Grid->tgl_kontrol->EditAttrs["readonly"]) && !isset($Grid->tgl_kontrol->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fV_LABORATORIUMgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fV_LABORATORIUMgrid", "x<?= $Grid->RowIndex ?>_tgl_kontrol", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="V_LABORATORIUM" data-field="x_tgl_kontrol" data-hidden="1" name="o<?= $Grid->RowIndex ?>_tgl_kontrol" id="o<?= $Grid->RowIndex ?>_tgl_kontrol" value="<?= HtmlEncode($Grid->tgl_kontrol->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_LABORATORIUM_tgl_kontrol" class="form-group">
<input type="<?= $Grid->tgl_kontrol->getInputTextType() ?>" data-table="V_LABORATORIUM" data-field="x_tgl_kontrol" name="x<?= $Grid->RowIndex ?>_tgl_kontrol" id="x<?= $Grid->RowIndex ?>_tgl_kontrol" placeholder="<?= HtmlEncode($Grid->tgl_kontrol->getPlaceHolder()) ?>" value="<?= $Grid->tgl_kontrol->EditValue ?>"<?= $Grid->tgl_kontrol->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->tgl_kontrol->getErrorMessage() ?></div>
<?php if (!$Grid->tgl_kontrol->ReadOnly && !$Grid->tgl_kontrol->Disabled && !isset($Grid->tgl_kontrol->EditAttrs["readonly"]) && !isset($Grid->tgl_kontrol->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fV_LABORATORIUMgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fV_LABORATORIUMgrid", "x<?= $Grid->RowIndex ?>_tgl_kontrol", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_LABORATORIUM_tgl_kontrol">
<span<?= $Grid->tgl_kontrol->viewAttributes() ?>>
<?= $Grid->tgl_kontrol->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_LABORATORIUM" data-field="x_tgl_kontrol" data-hidden="1" name="fV_LABORATORIUMgrid$x<?= $Grid->RowIndex ?>_tgl_kontrol" id="fV_LABORATORIUMgrid$x<?= $Grid->RowIndex ?>_tgl_kontrol" value="<?= HtmlEncode($Grid->tgl_kontrol->FormValue) ?>">
<input type="hidden" data-table="V_LABORATORIUM" data-field="x_tgl_kontrol" data-hidden="1" name="fV_LABORATORIUMgrid$o<?= $Grid->RowIndex ?>_tgl_kontrol" id="fV_LABORATORIUMgrid$o<?= $Grid->RowIndex ?>_tgl_kontrol" value="<?= HtmlEncode($Grid->tgl_kontrol->OldValue) ?>">
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
loadjs.ready(["fV_LABORATORIUMgrid","load"], function () {
    fV_LABORATORIUMgrid.updateLists(<?= $Grid->RowIndex ?>);
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_V_LABORATORIUM", "data-rowtype" => ROWTYPE_ADD]);
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
<span id="el$rowindex$_V_LABORATORIUM_NO_REGISTRATION" class="form-group V_LABORATORIUM_NO_REGISTRATION">
<span<?= $Grid->NO_REGISTRATION->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->NO_REGISTRATION->getDisplayValue($Grid->NO_REGISTRATION->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" name="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" value="<?= HtmlEncode($Grid->NO_REGISTRATION->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_V_LABORATORIUM_NO_REGISTRATION" class="form-group V_LABORATORIUM_NO_REGISTRATION">
<div class="input-group ew-lookup-list">
    <div class="form-control ew-lookup-text" tabindex="-1" id="lu_x<?= $Grid->RowIndex ?>_NO_REGISTRATION"><?= EmptyValue(strval($Grid->NO_REGISTRATION->ViewValue)) ? $Language->phrase("PleaseSelect") : $Grid->NO_REGISTRATION->ViewValue ?></div>
    <div class="input-group-append">
        <button type="button" title="<?= HtmlEncode(str_replace("%s", RemoveHtml($Grid->NO_REGISTRATION->caption()), $Language->phrase("LookupLink", true))) ?>" class="ew-lookup-btn btn btn-default"<?= ($Grid->NO_REGISTRATION->ReadOnly || $Grid->NO_REGISTRATION->Disabled) ? " disabled" : "" ?> onclick="ew.modalLookupShow({lnk:this,el:'x<?= $Grid->RowIndex ?>_NO_REGISTRATION',m:0,n:10});"><i class="fas fa-search ew-icon"></i></button>
    </div>
</div>
<div class="invalid-feedback"><?= $Grid->NO_REGISTRATION->getErrorMessage() ?></div>
<?= $Grid->NO_REGISTRATION->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_NO_REGISTRATION") ?>
<input type="hidden" is="selection-list" data-table="V_LABORATORIUM" data-field="x_NO_REGISTRATION" data-type="text" data-multiple="0" data-lookup="1" data-value-separator="<?= $Grid->NO_REGISTRATION->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" id="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" value="<?= $Grid->NO_REGISTRATION->CurrentValue ?>"<?= $Grid->NO_REGISTRATION->editAttributes() ?>>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_V_LABORATORIUM_NO_REGISTRATION" class="form-group V_LABORATORIUM_NO_REGISTRATION">
<span<?= $Grid->NO_REGISTRATION->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->NO_REGISTRATION->getDisplayValue($Grid->NO_REGISTRATION->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_LABORATORIUM" data-field="x_NO_REGISTRATION" data-hidden="1" name="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" id="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" value="<?= HtmlEncode($Grid->NO_REGISTRATION->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_LABORATORIUM" data-field="x_NO_REGISTRATION" data-hidden="1" name="o<?= $Grid->RowIndex ?>_NO_REGISTRATION" id="o<?= $Grid->RowIndex ?>_NO_REGISTRATION" value="<?= HtmlEncode($Grid->NO_REGISTRATION->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->DIANTAR_OLEH->Visible) { // DIANTAR_OLEH ?>
        <td data-name="DIANTAR_OLEH">
<?php if (!$Grid->isConfirm()) { ?>
<?php if ($Grid->DIANTAR_OLEH->getSessionValue() != "") { ?>
<span id="el$rowindex$_V_LABORATORIUM_DIANTAR_OLEH" class="form-group V_LABORATORIUM_DIANTAR_OLEH">
<span<?= $Grid->DIANTAR_OLEH->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->DIANTAR_OLEH->getDisplayValue($Grid->DIANTAR_OLEH->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_DIANTAR_OLEH" name="x<?= $Grid->RowIndex ?>_DIANTAR_OLEH" value="<?= HtmlEncode($Grid->DIANTAR_OLEH->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_V_LABORATORIUM_DIANTAR_OLEH" class="form-group V_LABORATORIUM_DIANTAR_OLEH">
<input type="<?= $Grid->DIANTAR_OLEH->getInputTextType() ?>" data-table="V_LABORATORIUM" data-field="x_DIANTAR_OLEH" name="x<?= $Grid->RowIndex ?>_DIANTAR_OLEH" id="x<?= $Grid->RowIndex ?>_DIANTAR_OLEH" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->DIANTAR_OLEH->getPlaceHolder()) ?>" value="<?= $Grid->DIANTAR_OLEH->EditValue ?>"<?= $Grid->DIANTAR_OLEH->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->DIANTAR_OLEH->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_V_LABORATORIUM_DIANTAR_OLEH" class="form-group V_LABORATORIUM_DIANTAR_OLEH">
<span<?= $Grid->DIANTAR_OLEH->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->DIANTAR_OLEH->getDisplayValue($Grid->DIANTAR_OLEH->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_LABORATORIUM" data-field="x_DIANTAR_OLEH" data-hidden="1" name="x<?= $Grid->RowIndex ?>_DIANTAR_OLEH" id="x<?= $Grid->RowIndex ?>_DIANTAR_OLEH" value="<?= HtmlEncode($Grid->DIANTAR_OLEH->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_LABORATORIUM" data-field="x_DIANTAR_OLEH" data-hidden="1" name="o<?= $Grid->RowIndex ?>_DIANTAR_OLEH" id="o<?= $Grid->RowIndex ?>_DIANTAR_OLEH" value="<?= HtmlEncode($Grid->DIANTAR_OLEH->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->GENDER->Visible) { // GENDER ?>
        <td data-name="GENDER">
<?php if (!$Grid->isConfirm()) { ?>
<?php if ($Grid->GENDER->getSessionValue() != "") { ?>
<span id="el$rowindex$_V_LABORATORIUM_GENDER" class="form-group V_LABORATORIUM_GENDER">
<span<?= $Grid->GENDER->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->GENDER->getDisplayValue($Grid->GENDER->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_GENDER" name="x<?= $Grid->RowIndex ?>_GENDER" value="<?= HtmlEncode($Grid->GENDER->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_V_LABORATORIUM_GENDER" class="form-group V_LABORATORIUM_GENDER">
    <select
        id="x<?= $Grid->RowIndex ?>_GENDER"
        name="x<?= $Grid->RowIndex ?>_GENDER"
        class="form-control ew-select<?= $Grid->GENDER->isInvalidClass() ?>"
        data-select2-id="V_LABORATORIUM_x<?= $Grid->RowIndex ?>_GENDER"
        data-table="V_LABORATORIUM"
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
    var el = document.querySelector("select[data-select2-id='V_LABORATORIUM_x<?= $Grid->RowIndex ?>_GENDER']"),
        options = { name: "x<?= $Grid->RowIndex ?>_GENDER", selectId: "V_LABORATORIUM_x<?= $Grid->RowIndex ?>_GENDER", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.V_LABORATORIUM.fields.GENDER.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_V_LABORATORIUM_GENDER" class="form-group V_LABORATORIUM_GENDER">
<span<?= $Grid->GENDER->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->GENDER->getDisplayValue($Grid->GENDER->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_LABORATORIUM" data-field="x_GENDER" data-hidden="1" name="x<?= $Grid->RowIndex ?>_GENDER" id="x<?= $Grid->RowIndex ?>_GENDER" value="<?= HtmlEncode($Grid->GENDER->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_LABORATORIUM" data-field="x_GENDER" data-hidden="1" name="o<?= $Grid->RowIndex ?>_GENDER" id="o<?= $Grid->RowIndex ?>_GENDER" value="<?= HtmlEncode($Grid->GENDER->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->VISITOR_ADDRESS->Visible) { // VISITOR_ADDRESS ?>
        <td data-name="VISITOR_ADDRESS">
<?php if (!$Grid->isConfirm()) { ?>
<?php if ($Grid->VISITOR_ADDRESS->getSessionValue() != "") { ?>
<span id="el$rowindex$_V_LABORATORIUM_VISITOR_ADDRESS" class="form-group V_LABORATORIUM_VISITOR_ADDRESS">
<span<?= $Grid->VISITOR_ADDRESS->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->VISITOR_ADDRESS->getDisplayValue($Grid->VISITOR_ADDRESS->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_VISITOR_ADDRESS" name="x<?= $Grid->RowIndex ?>_VISITOR_ADDRESS" value="<?= HtmlEncode($Grid->VISITOR_ADDRESS->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_V_LABORATORIUM_VISITOR_ADDRESS" class="form-group V_LABORATORIUM_VISITOR_ADDRESS">
<input type="<?= $Grid->VISITOR_ADDRESS->getInputTextType() ?>" data-table="V_LABORATORIUM" data-field="x_VISITOR_ADDRESS" name="x<?= $Grid->RowIndex ?>_VISITOR_ADDRESS" id="x<?= $Grid->RowIndex ?>_VISITOR_ADDRESS" size="30" maxlength="150" placeholder="<?= HtmlEncode($Grid->VISITOR_ADDRESS->getPlaceHolder()) ?>" value="<?= $Grid->VISITOR_ADDRESS->EditValue ?>"<?= $Grid->VISITOR_ADDRESS->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->VISITOR_ADDRESS->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_V_LABORATORIUM_VISITOR_ADDRESS" class="form-group V_LABORATORIUM_VISITOR_ADDRESS">
<span<?= $Grid->VISITOR_ADDRESS->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->VISITOR_ADDRESS->getDisplayValue($Grid->VISITOR_ADDRESS->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_LABORATORIUM" data-field="x_VISITOR_ADDRESS" data-hidden="1" name="x<?= $Grid->RowIndex ?>_VISITOR_ADDRESS" id="x<?= $Grid->RowIndex ?>_VISITOR_ADDRESS" value="<?= HtmlEncode($Grid->VISITOR_ADDRESS->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_LABORATORIUM" data-field="x_VISITOR_ADDRESS" data-hidden="1" name="o<?= $Grid->RowIndex ?>_VISITOR_ADDRESS" id="o<?= $Grid->RowIndex ?>_VISITOR_ADDRESS" value="<?= HtmlEncode($Grid->VISITOR_ADDRESS->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->BOOKED_DATE->Visible) { // BOOKED_DATE ?>
        <td data-name="BOOKED_DATE">
<?php if (!$Grid->isConfirm()) { ?>
<?php } else { ?>
<span id="el$rowindex$_V_LABORATORIUM_BOOKED_DATE" class="form-group V_LABORATORIUM_BOOKED_DATE">
<span<?= $Grid->BOOKED_DATE->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->BOOKED_DATE->getDisplayValue($Grid->BOOKED_DATE->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_LABORATORIUM" data-field="x_BOOKED_DATE" data-hidden="1" name="x<?= $Grid->RowIndex ?>_BOOKED_DATE" id="x<?= $Grid->RowIndex ?>_BOOKED_DATE" value="<?= HtmlEncode($Grid->BOOKED_DATE->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_LABORATORIUM" data-field="x_BOOKED_DATE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_BOOKED_DATE" id="o<?= $Grid->RowIndex ?>_BOOKED_DATE" value="<?= HtmlEncode($Grid->BOOKED_DATE->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->VISIT_DATE->Visible) { // VISIT_DATE ?>
        <td data-name="VISIT_DATE">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_LABORATORIUM_VISIT_DATE" class="form-group V_LABORATORIUM_VISIT_DATE">
<input type="<?= $Grid->VISIT_DATE->getInputTextType() ?>" data-table="V_LABORATORIUM" data-field="x_VISIT_DATE" data-format="11" name="x<?= $Grid->RowIndex ?>_VISIT_DATE" id="x<?= $Grid->RowIndex ?>_VISIT_DATE" placeholder="<?= HtmlEncode($Grid->VISIT_DATE->getPlaceHolder()) ?>" value="<?= $Grid->VISIT_DATE->EditValue ?>"<?= $Grid->VISIT_DATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->VISIT_DATE->getErrorMessage() ?></div>
<?php if (!$Grid->VISIT_DATE->ReadOnly && !$Grid->VISIT_DATE->Disabled && !isset($Grid->VISIT_DATE->EditAttrs["readonly"]) && !isset($Grid->VISIT_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fV_LABORATORIUMgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fV_LABORATORIUMgrid", "x<?= $Grid->RowIndex ?>_VISIT_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":11});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_LABORATORIUM_VISIT_DATE" class="form-group V_LABORATORIUM_VISIT_DATE">
<span<?= $Grid->VISIT_DATE->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->VISIT_DATE->getDisplayValue($Grid->VISIT_DATE->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_LABORATORIUM" data-field="x_VISIT_DATE" data-hidden="1" name="x<?= $Grid->RowIndex ?>_VISIT_DATE" id="x<?= $Grid->RowIndex ?>_VISIT_DATE" value="<?= HtmlEncode($Grid->VISIT_DATE->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_LABORATORIUM" data-field="x_VISIT_DATE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_VISIT_DATE" id="o<?= $Grid->RowIndex ?>_VISIT_DATE" value="<?= HtmlEncode($Grid->VISIT_DATE->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->CLINIC_ID->Visible) { // CLINIC_ID ?>
        <td data-name="CLINIC_ID">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_LABORATORIUM_CLINIC_ID" class="form-group V_LABORATORIUM_CLINIC_ID">
    <select
        id="x<?= $Grid->RowIndex ?>_CLINIC_ID"
        name="x<?= $Grid->RowIndex ?>_CLINIC_ID"
        class="form-control ew-select<?= $Grid->CLINIC_ID->isInvalidClass() ?>"
        data-select2-id="V_LABORATORIUM_x<?= $Grid->RowIndex ?>_CLINIC_ID"
        data-table="V_LABORATORIUM"
        data-field="x_CLINIC_ID"
        data-value-separator="<?= $Grid->CLINIC_ID->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->CLINIC_ID->getPlaceHolder()) ?>"
        <?= $Grid->CLINIC_ID->editAttributes() ?>>
        <?= $Grid->CLINIC_ID->selectOptionListHtml("x{$Grid->RowIndex}_CLINIC_ID") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->CLINIC_ID->getErrorMessage() ?></div>
<?= $Grid->CLINIC_ID->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_CLINIC_ID") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='V_LABORATORIUM_x<?= $Grid->RowIndex ?>_CLINIC_ID']"),
        options = { name: "x<?= $Grid->RowIndex ?>_CLINIC_ID", selectId: "V_LABORATORIUM_x<?= $Grid->RowIndex ?>_CLINIC_ID", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.V_LABORATORIUM.fields.CLINIC_ID.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_LABORATORIUM_CLINIC_ID" class="form-group V_LABORATORIUM_CLINIC_ID">
<span<?= $Grid->CLINIC_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->CLINIC_ID->getDisplayValue($Grid->CLINIC_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_LABORATORIUM" data-field="x_CLINIC_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_CLINIC_ID" id="x<?= $Grid->RowIndex ?>_CLINIC_ID" value="<?= HtmlEncode($Grid->CLINIC_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_LABORATORIUM" data-field="x_CLINIC_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_CLINIC_ID" id="o<?= $Grid->RowIndex ?>_CLINIC_ID" value="<?= HtmlEncode($Grid->CLINIC_ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->EMPLOYEE_ID->Visible) { // EMPLOYEE_ID ?>
        <td data-name="EMPLOYEE_ID">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_LABORATORIUM_EMPLOYEE_ID" class="form-group V_LABORATORIUM_EMPLOYEE_ID">
<?php
$onchange = $Grid->EMPLOYEE_ID->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Grid->EMPLOYEE_ID->EditAttrs["onchange"] = "";
?>
<span id="as_x<?= $Grid->RowIndex ?>_EMPLOYEE_ID" class="ew-auto-suggest">
    <input type="<?= $Grid->EMPLOYEE_ID->getInputTextType() ?>" class="form-control" name="sv_x<?= $Grid->RowIndex ?>_EMPLOYEE_ID" id="sv_x<?= $Grid->RowIndex ?>_EMPLOYEE_ID" value="<?= RemoveHtml($Grid->EMPLOYEE_ID->EditValue) ?>" size="30" maxlength="15" placeholder="<?= HtmlEncode($Grid->EMPLOYEE_ID->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Grid->EMPLOYEE_ID->getPlaceHolder()) ?>"<?= $Grid->EMPLOYEE_ID->editAttributes() ?>>
</span>
<input type="hidden" is="selection-list" class="form-control" data-table="V_LABORATORIUM" data-field="x_EMPLOYEE_ID" data-input="sv_x<?= $Grid->RowIndex ?>_EMPLOYEE_ID" data-value-separator="<?= $Grid->EMPLOYEE_ID->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_EMPLOYEE_ID" id="x<?= $Grid->RowIndex ?>_EMPLOYEE_ID" value="<?= HtmlEncode($Grid->EMPLOYEE_ID->CurrentValue) ?>"<?= $onchange ?>>
<div class="invalid-feedback"><?= $Grid->EMPLOYEE_ID->getErrorMessage() ?></div>
<script>
loadjs.ready(["fV_LABORATORIUMgrid"], function() {
    fV_LABORATORIUMgrid.createAutoSuggest(Object.assign({"id":"x<?= $Grid->RowIndex ?>_EMPLOYEE_ID","forceSelect":false}, ew.vars.tables.V_LABORATORIUM.fields.EMPLOYEE_ID.autoSuggestOptions));
});
</script>
<?= $Grid->EMPLOYEE_ID->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_EMPLOYEE_ID") ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_LABORATORIUM_EMPLOYEE_ID" class="form-group V_LABORATORIUM_EMPLOYEE_ID">
<span<?= $Grid->EMPLOYEE_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->EMPLOYEE_ID->getDisplayValue($Grid->EMPLOYEE_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_LABORATORIUM" data-field="x_EMPLOYEE_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_EMPLOYEE_ID" id="x<?= $Grid->RowIndex ?>_EMPLOYEE_ID" value="<?= HtmlEncode($Grid->EMPLOYEE_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_LABORATORIUM" data-field="x_EMPLOYEE_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_EMPLOYEE_ID" id="o<?= $Grid->RowIndex ?>_EMPLOYEE_ID" value="<?= HtmlEncode($Grid->EMPLOYEE_ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->PAYOR_ID->Visible) { // PAYOR_ID ?>
        <td data-name="PAYOR_ID">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_LABORATORIUM_PAYOR_ID" class="form-group V_LABORATORIUM_PAYOR_ID">
    <select
        id="x<?= $Grid->RowIndex ?>_PAYOR_ID"
        name="x<?= $Grid->RowIndex ?>_PAYOR_ID"
        class="form-control ew-select<?= $Grid->PAYOR_ID->isInvalidClass() ?>"
        data-select2-id="V_LABORATORIUM_x<?= $Grid->RowIndex ?>_PAYOR_ID"
        data-table="V_LABORATORIUM"
        data-field="x_PAYOR_ID"
        data-value-separator="<?= $Grid->PAYOR_ID->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->PAYOR_ID->getPlaceHolder()) ?>"
        <?= $Grid->PAYOR_ID->editAttributes() ?>>
        <?= $Grid->PAYOR_ID->selectOptionListHtml("x{$Grid->RowIndex}_PAYOR_ID") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->PAYOR_ID->getErrorMessage() ?></div>
<?= $Grid->PAYOR_ID->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_PAYOR_ID") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='V_LABORATORIUM_x<?= $Grid->RowIndex ?>_PAYOR_ID']"),
        options = { name: "x<?= $Grid->RowIndex ?>_PAYOR_ID", selectId: "V_LABORATORIUM_x<?= $Grid->RowIndex ?>_PAYOR_ID", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.V_LABORATORIUM.fields.PAYOR_ID.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_LABORATORIUM_PAYOR_ID" class="form-group V_LABORATORIUM_PAYOR_ID">
<span<?= $Grid->PAYOR_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->PAYOR_ID->getDisplayValue($Grid->PAYOR_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_LABORATORIUM" data-field="x_PAYOR_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_PAYOR_ID" id="x<?= $Grid->RowIndex ?>_PAYOR_ID" value="<?= HtmlEncode($Grid->PAYOR_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_LABORATORIUM" data-field="x_PAYOR_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_PAYOR_ID" id="o<?= $Grid->RowIndex ?>_PAYOR_ID" value="<?= HtmlEncode($Grid->PAYOR_ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->CLASS_ID->Visible) { // CLASS_ID ?>
        <td data-name="CLASS_ID">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_LABORATORIUM_CLASS_ID" class="form-group V_LABORATORIUM_CLASS_ID">
    <select
        id="x<?= $Grid->RowIndex ?>_CLASS_ID"
        name="x<?= $Grid->RowIndex ?>_CLASS_ID"
        class="form-control ew-select<?= $Grid->CLASS_ID->isInvalidClass() ?>"
        data-select2-id="V_LABORATORIUM_x<?= $Grid->RowIndex ?>_CLASS_ID"
        data-table="V_LABORATORIUM"
        data-field="x_CLASS_ID"
        data-value-separator="<?= $Grid->CLASS_ID->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->CLASS_ID->getPlaceHolder()) ?>"
        <?= $Grid->CLASS_ID->editAttributes() ?>>
        <?= $Grid->CLASS_ID->selectOptionListHtml("x{$Grid->RowIndex}_CLASS_ID") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->CLASS_ID->getErrorMessage() ?></div>
<?= $Grid->CLASS_ID->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_CLASS_ID") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='V_LABORATORIUM_x<?= $Grid->RowIndex ?>_CLASS_ID']"),
        options = { name: "x<?= $Grid->RowIndex ?>_CLASS_ID", selectId: "V_LABORATORIUM_x<?= $Grid->RowIndex ?>_CLASS_ID", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.V_LABORATORIUM.fields.CLASS_ID.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_LABORATORIUM_CLASS_ID" class="form-group V_LABORATORIUM_CLASS_ID">
<span<?= $Grid->CLASS_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->CLASS_ID->getDisplayValue($Grid->CLASS_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_LABORATORIUM" data-field="x_CLASS_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_CLASS_ID" id="x<?= $Grid->RowIndex ?>_CLASS_ID" value="<?= HtmlEncode($Grid->CLASS_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_LABORATORIUM" data-field="x_CLASS_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_CLASS_ID" id="o<?= $Grid->RowIndex ?>_CLASS_ID" value="<?= HtmlEncode($Grid->CLASS_ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->PASIEN_ID->Visible) { // PASIEN_ID ?>
        <td data-name="PASIEN_ID">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_LABORATORIUM_PASIEN_ID" class="form-group V_LABORATORIUM_PASIEN_ID">
<input type="<?= $Grid->PASIEN_ID->getInputTextType() ?>" data-table="V_LABORATORIUM" data-field="x_PASIEN_ID" name="x<?= $Grid->RowIndex ?>_PASIEN_ID" id="x<?= $Grid->RowIndex ?>_PASIEN_ID" size="30" maxlength="30" placeholder="<?= HtmlEncode($Grid->PASIEN_ID->getPlaceHolder()) ?>" value="<?= $Grid->PASIEN_ID->EditValue ?>"<?= $Grid->PASIEN_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->PASIEN_ID->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_LABORATORIUM_PASIEN_ID" class="form-group V_LABORATORIUM_PASIEN_ID">
<span<?= $Grid->PASIEN_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->PASIEN_ID->getDisplayValue($Grid->PASIEN_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_LABORATORIUM" data-field="x_PASIEN_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_PASIEN_ID" id="x<?= $Grid->RowIndex ?>_PASIEN_ID" value="<?= HtmlEncode($Grid->PASIEN_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_LABORATORIUM" data-field="x_PASIEN_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_PASIEN_ID" id="o<?= $Grid->RowIndex ?>_PASIEN_ID" value="<?= HtmlEncode($Grid->PASIEN_ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->tgl_kontrol->Visible) { // tgl_kontrol ?>
        <td data-name="tgl_kontrol">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_LABORATORIUM_tgl_kontrol" class="form-group V_LABORATORIUM_tgl_kontrol">
<input type="<?= $Grid->tgl_kontrol->getInputTextType() ?>" data-table="V_LABORATORIUM" data-field="x_tgl_kontrol" name="x<?= $Grid->RowIndex ?>_tgl_kontrol" id="x<?= $Grid->RowIndex ?>_tgl_kontrol" placeholder="<?= HtmlEncode($Grid->tgl_kontrol->getPlaceHolder()) ?>" value="<?= $Grid->tgl_kontrol->EditValue ?>"<?= $Grid->tgl_kontrol->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->tgl_kontrol->getErrorMessage() ?></div>
<?php if (!$Grid->tgl_kontrol->ReadOnly && !$Grid->tgl_kontrol->Disabled && !isset($Grid->tgl_kontrol->EditAttrs["readonly"]) && !isset($Grid->tgl_kontrol->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fV_LABORATORIUMgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fV_LABORATORIUMgrid", "x<?= $Grid->RowIndex ?>_tgl_kontrol", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_LABORATORIUM_tgl_kontrol" class="form-group V_LABORATORIUM_tgl_kontrol">
<span<?= $Grid->tgl_kontrol->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->tgl_kontrol->getDisplayValue($Grid->tgl_kontrol->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_LABORATORIUM" data-field="x_tgl_kontrol" data-hidden="1" name="x<?= $Grid->RowIndex ?>_tgl_kontrol" id="x<?= $Grid->RowIndex ?>_tgl_kontrol" value="<?= HtmlEncode($Grid->tgl_kontrol->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_LABORATORIUM" data-field="x_tgl_kontrol" data-hidden="1" name="o<?= $Grid->RowIndex ?>_tgl_kontrol" id="o<?= $Grid->RowIndex ?>_tgl_kontrol" value="<?= HtmlEncode($Grid->tgl_kontrol->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["fV_LABORATORIUMgrid","load"], function() {
    fV_LABORATORIUMgrid.updateLists(<?= $Grid->RowIndex ?>);
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
<input type="hidden" name="detailpage" value="fV_LABORATORIUMgrid">
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
    ew.addEventHandlers("V_LABORATORIUM");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
