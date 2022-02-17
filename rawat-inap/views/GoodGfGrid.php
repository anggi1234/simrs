<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

// Set up and run Grid object
$Grid = Container("GoodGfGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fGOOD_GFgrid;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    fGOOD_GFgrid = new ew.Form("fGOOD_GFgrid", "grid");
    fGOOD_GFgrid.formKeyCountName = '<?= $Grid->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "GOOD_GF")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.GOOD_GF)
        ew.vars.tables.GOOD_GF = currentTable;
    fGOOD_GFgrid.addFields([
        ["BRAND_ID", [fields.BRAND_ID.visible && fields.BRAND_ID.required ? ew.Validators.required(fields.BRAND_ID.caption) : null], fields.BRAND_ID.isInvalid],
        ["ROOMS_ID", [fields.ROOMS_ID.visible && fields.ROOMS_ID.required ? ew.Validators.required(fields.ROOMS_ID.caption) : null], fields.ROOMS_ID.isInvalid],
        ["EXPIRY_DATE", [fields.EXPIRY_DATE.visible && fields.EXPIRY_DATE.required ? ew.Validators.required(fields.EXPIRY_DATE.caption) : null, ew.Validators.datetime(0)], fields.EXPIRY_DATE.isInvalid],
        ["ISOUTLET", [fields.ISOUTLET.visible && fields.ISOUTLET.required ? ew.Validators.required(fields.ISOUTLET.caption) : null], fields.ISOUTLET.isInvalid],
        ["QUANTITY", [fields.QUANTITY.visible && fields.QUANTITY.required ? ew.Validators.required(fields.QUANTITY.caption) : null, ew.Validators.float], fields.QUANTITY.isInvalid],
        ["ALLOCATED_FROM", [fields.ALLOCATED_FROM.visible && fields.ALLOCATED_FROM.required ? ew.Validators.required(fields.ALLOCATED_FROM.caption) : null], fields.ALLOCATED_FROM.isInvalid],
        ["DIJUAL", [fields.DIJUAL.visible && fields.DIJUAL.required ? ew.Validators.required(fields.DIJUAL.caption) : null, ew.Validators.float], fields.DIJUAL.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fGOOD_GFgrid,
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
    fGOOD_GFgrid.validate = function () {
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
    fGOOD_GFgrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm();
        if (ew.valueChanged(fobj, rowIndex, "BRAND_ID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "ROOMS_ID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "EXPIRY_DATE", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "ISOUTLET", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "QUANTITY", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "ALLOCATED_FROM", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "DIJUAL", false))
            return false;
        return true;
    }

    // Form_CustomValidate
    fGOOD_GFgrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fGOOD_GFgrid.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fGOOD_GFgrid.lists.BRAND_ID = <?= $Grid->BRAND_ID->toClientList($Grid) ?>;
    loadjs.done("fGOOD_GFgrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> GOOD_GF">
<?php if ($Grid->ShowOtherOptions) { ?>
<div class="card-header ew-grid-upper-panel">
<?php $Grid->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="fGOOD_GFgrid" class="ew-form ew-list-form form-inline">
<div id="gmp_GOOD_GF" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_GOOD_GFgrid" class="table ew-table"><!-- .ew-table -->
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
<?php if ($Grid->BRAND_ID->Visible) { // BRAND_ID ?>
        <th data-name="BRAND_ID" class="<?= $Grid->BRAND_ID->headerCellClass() ?>"><div id="elh_GOOD_GF_BRAND_ID" class="GOOD_GF_BRAND_ID"><?= $Grid->renderSort($Grid->BRAND_ID) ?></div></th>
<?php } ?>
<?php if ($Grid->ROOMS_ID->Visible) { // ROOMS_ID ?>
        <th data-name="ROOMS_ID" class="<?= $Grid->ROOMS_ID->headerCellClass() ?>"><div id="elh_GOOD_GF_ROOMS_ID" class="GOOD_GF_ROOMS_ID"><?= $Grid->renderSort($Grid->ROOMS_ID) ?></div></th>
<?php } ?>
<?php if ($Grid->EXPIRY_DATE->Visible) { // EXPIRY_DATE ?>
        <th data-name="EXPIRY_DATE" class="<?= $Grid->EXPIRY_DATE->headerCellClass() ?>"><div id="elh_GOOD_GF_EXPIRY_DATE" class="GOOD_GF_EXPIRY_DATE"><?= $Grid->renderSort($Grid->EXPIRY_DATE) ?></div></th>
<?php } ?>
<?php if ($Grid->ISOUTLET->Visible) { // ISOUTLET ?>
        <th data-name="ISOUTLET" class="<?= $Grid->ISOUTLET->headerCellClass() ?>"><div id="elh_GOOD_GF_ISOUTLET" class="GOOD_GF_ISOUTLET"><?= $Grid->renderSort($Grid->ISOUTLET) ?></div></th>
<?php } ?>
<?php if ($Grid->QUANTITY->Visible) { // QUANTITY ?>
        <th data-name="QUANTITY" class="<?= $Grid->QUANTITY->headerCellClass() ?>"><div id="elh_GOOD_GF_QUANTITY" class="GOOD_GF_QUANTITY"><?= $Grid->renderSort($Grid->QUANTITY) ?></div></th>
<?php } ?>
<?php if ($Grid->ALLOCATED_FROM->Visible) { // ALLOCATED_FROM ?>
        <th data-name="ALLOCATED_FROM" class="<?= $Grid->ALLOCATED_FROM->headerCellClass() ?>"><div id="elh_GOOD_GF_ALLOCATED_FROM" class="GOOD_GF_ALLOCATED_FROM"><?= $Grid->renderSort($Grid->ALLOCATED_FROM) ?></div></th>
<?php } ?>
<?php if ($Grid->DIJUAL->Visible) { // DIJUAL ?>
        <th data-name="DIJUAL" class="<?= $Grid->DIJUAL->headerCellClass() ?>"><div id="elh_GOOD_GF_DIJUAL" class="GOOD_GF_DIJUAL"><?= $Grid->renderSort($Grid->DIJUAL) ?></div></th>
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowCount, "id" => "r" . $Grid->RowCount . "_GOOD_GF", "data-rowtype" => $Grid->RowType]);

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
    <?php if ($Grid->BRAND_ID->Visible) { // BRAND_ID ?>
        <td data-name="BRAND_ID" <?= $Grid->BRAND_ID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_BRAND_ID" class="form-group">
<div class="input-group ew-lookup-list">
    <div class="form-control ew-lookup-text" tabindex="-1" id="lu_x<?= $Grid->RowIndex ?>_BRAND_ID"><?= EmptyValue(strval($Grid->BRAND_ID->ViewValue)) ? $Language->phrase("PleaseSelect") : $Grid->BRAND_ID->ViewValue ?></div>
    <div class="input-group-append">
        <button type="button" title="<?= HtmlEncode(str_replace("%s", RemoveHtml($Grid->BRAND_ID->caption()), $Language->phrase("LookupLink", true))) ?>" class="ew-lookup-btn btn btn-default"<?= ($Grid->BRAND_ID->ReadOnly || $Grid->BRAND_ID->Disabled) ? " disabled" : "" ?> onclick="ew.modalLookupShow({lnk:this,el:'x<?= $Grid->RowIndex ?>_BRAND_ID',m:0,n:10});"><i class="fas fa-search ew-icon"></i></button>
    </div>
</div>
<div class="invalid-feedback"><?= $Grid->BRAND_ID->getErrorMessage() ?></div>
<?= $Grid->BRAND_ID->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_BRAND_ID") ?>
<input type="hidden" is="selection-list" data-table="GOOD_GF" data-field="x_BRAND_ID" data-type="text" data-multiple="0" data-lookup="1" data-value-separator="<?= $Grid->BRAND_ID->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_BRAND_ID" id="x<?= $Grid->RowIndex ?>_BRAND_ID" value="<?= $Grid->BRAND_ID->CurrentValue ?>"<?= $Grid->BRAND_ID->editAttributes() ?>>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_BRAND_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_BRAND_ID" id="o<?= $Grid->RowIndex ?>_BRAND_ID" value="<?= HtmlEncode($Grid->BRAND_ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_BRAND_ID" class="form-group">
<div class="input-group ew-lookup-list">
    <div class="form-control ew-lookup-text" tabindex="-1" id="lu_x<?= $Grid->RowIndex ?>_BRAND_ID"><?= EmptyValue(strval($Grid->BRAND_ID->ViewValue)) ? $Language->phrase("PleaseSelect") : $Grid->BRAND_ID->ViewValue ?></div>
    <div class="input-group-append">
        <button type="button" title="<?= HtmlEncode(str_replace("%s", RemoveHtml($Grid->BRAND_ID->caption()), $Language->phrase("LookupLink", true))) ?>" class="ew-lookup-btn btn btn-default"<?= ($Grid->BRAND_ID->ReadOnly || $Grid->BRAND_ID->Disabled) ? " disabled" : "" ?> onclick="ew.modalLookupShow({lnk:this,el:'x<?= $Grid->RowIndex ?>_BRAND_ID',m:0,n:10});"><i class="fas fa-search ew-icon"></i></button>
    </div>
</div>
<div class="invalid-feedback"><?= $Grid->BRAND_ID->getErrorMessage() ?></div>
<?= $Grid->BRAND_ID->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_BRAND_ID") ?>
<input type="hidden" is="selection-list" data-table="GOOD_GF" data-field="x_BRAND_ID" data-type="text" data-multiple="0" data-lookup="1" data-value-separator="<?= $Grid->BRAND_ID->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_BRAND_ID" id="x<?= $Grid->RowIndex ?>_BRAND_ID" value="<?= $Grid->BRAND_ID->CurrentValue ?>"<?= $Grid->BRAND_ID->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_BRAND_ID">
<span<?= $Grid->BRAND_ID->viewAttributes() ?>>
<?= $Grid->BRAND_ID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_BRAND_ID" data-hidden="1" name="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_BRAND_ID" id="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_BRAND_ID" value="<?= HtmlEncode($Grid->BRAND_ID->FormValue) ?>">
<input type="hidden" data-table="GOOD_GF" data-field="x_BRAND_ID" data-hidden="1" name="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_BRAND_ID" id="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_BRAND_ID" value="<?= HtmlEncode($Grid->BRAND_ID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->ROOMS_ID->Visible) { // ROOMS_ID ?>
        <td data-name="ROOMS_ID" <?= $Grid->ROOMS_ID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Grid->ROOMS_ID->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_ROOMS_ID" class="form-group">
<span<?= $Grid->ROOMS_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->ROOMS_ID->getDisplayValue($Grid->ROOMS_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_ROOMS_ID" name="x<?= $Grid->RowIndex ?>_ROOMS_ID" value="<?= HtmlEncode($Grid->ROOMS_ID->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_ROOMS_ID" class="form-group">
<input type="<?= $Grid->ROOMS_ID->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_ROOMS_ID" name="x<?= $Grid->RowIndex ?>_ROOMS_ID" id="x<?= $Grid->RowIndex ?>_ROOMS_ID" size="30" maxlength="10" placeholder="<?= HtmlEncode($Grid->ROOMS_ID->getPlaceHolder()) ?>" value="<?= $Grid->ROOMS_ID->EditValue ?>"<?= $Grid->ROOMS_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ROOMS_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_ROOMS_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ROOMS_ID" id="o<?= $Grid->RowIndex ?>_ROOMS_ID" value="<?= HtmlEncode($Grid->ROOMS_ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Grid->ROOMS_ID->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_ROOMS_ID" class="form-group">
<span<?= $Grid->ROOMS_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->ROOMS_ID->getDisplayValue($Grid->ROOMS_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_ROOMS_ID" name="x<?= $Grid->RowIndex ?>_ROOMS_ID" value="<?= HtmlEncode($Grid->ROOMS_ID->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_ROOMS_ID" class="form-group">
<input type="<?= $Grid->ROOMS_ID->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_ROOMS_ID" name="x<?= $Grid->RowIndex ?>_ROOMS_ID" id="x<?= $Grid->RowIndex ?>_ROOMS_ID" size="30" maxlength="10" placeholder="<?= HtmlEncode($Grid->ROOMS_ID->getPlaceHolder()) ?>" value="<?= $Grid->ROOMS_ID->EditValue ?>"<?= $Grid->ROOMS_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ROOMS_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_ROOMS_ID">
<span<?= $Grid->ROOMS_ID->viewAttributes() ?>>
<?= $Grid->ROOMS_ID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_ROOMS_ID" data-hidden="1" name="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_ROOMS_ID" id="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_ROOMS_ID" value="<?= HtmlEncode($Grid->ROOMS_ID->FormValue) ?>">
<input type="hidden" data-table="GOOD_GF" data-field="x_ROOMS_ID" data-hidden="1" name="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_ROOMS_ID" id="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_ROOMS_ID" value="<?= HtmlEncode($Grid->ROOMS_ID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->EXPIRY_DATE->Visible) { // EXPIRY_DATE ?>
        <td data-name="EXPIRY_DATE" <?= $Grid->EXPIRY_DATE->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_EXPIRY_DATE" class="form-group">
<input type="<?= $Grid->EXPIRY_DATE->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_EXPIRY_DATE" name="x<?= $Grid->RowIndex ?>_EXPIRY_DATE" id="x<?= $Grid->RowIndex ?>_EXPIRY_DATE" placeholder="<?= HtmlEncode($Grid->EXPIRY_DATE->getPlaceHolder()) ?>" value="<?= $Grid->EXPIRY_DATE->EditValue ?>"<?= $Grid->EXPIRY_DATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->EXPIRY_DATE->getErrorMessage() ?></div>
<?php if (!$Grid->EXPIRY_DATE->ReadOnly && !$Grid->EXPIRY_DATE->Disabled && !isset($Grid->EXPIRY_DATE->EditAttrs["readonly"]) && !isset($Grid->EXPIRY_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fGOOD_GFgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fGOOD_GFgrid", "x<?= $Grid->RowIndex ?>_EXPIRY_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_EXPIRY_DATE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_EXPIRY_DATE" id="o<?= $Grid->RowIndex ?>_EXPIRY_DATE" value="<?= HtmlEncode($Grid->EXPIRY_DATE->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_EXPIRY_DATE" class="form-group">
<input type="<?= $Grid->EXPIRY_DATE->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_EXPIRY_DATE" name="x<?= $Grid->RowIndex ?>_EXPIRY_DATE" id="x<?= $Grid->RowIndex ?>_EXPIRY_DATE" placeholder="<?= HtmlEncode($Grid->EXPIRY_DATE->getPlaceHolder()) ?>" value="<?= $Grid->EXPIRY_DATE->EditValue ?>"<?= $Grid->EXPIRY_DATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->EXPIRY_DATE->getErrorMessage() ?></div>
<?php if (!$Grid->EXPIRY_DATE->ReadOnly && !$Grid->EXPIRY_DATE->Disabled && !isset($Grid->EXPIRY_DATE->EditAttrs["readonly"]) && !isset($Grid->EXPIRY_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fGOOD_GFgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fGOOD_GFgrid", "x<?= $Grid->RowIndex ?>_EXPIRY_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_EXPIRY_DATE">
<span<?= $Grid->EXPIRY_DATE->viewAttributes() ?>>
<?= $Grid->EXPIRY_DATE->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_EXPIRY_DATE" data-hidden="1" name="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_EXPIRY_DATE" id="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_EXPIRY_DATE" value="<?= HtmlEncode($Grid->EXPIRY_DATE->FormValue) ?>">
<input type="hidden" data-table="GOOD_GF" data-field="x_EXPIRY_DATE" data-hidden="1" name="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_EXPIRY_DATE" id="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_EXPIRY_DATE" value="<?= HtmlEncode($Grid->EXPIRY_DATE->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->ISOUTLET->Visible) { // ISOUTLET ?>
        <td data-name="ISOUTLET" <?= $Grid->ISOUTLET->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_ISOUTLET" class="form-group">
<input type="<?= $Grid->ISOUTLET->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_ISOUTLET" name="x<?= $Grid->RowIndex ?>_ISOUTLET" id="x<?= $Grid->RowIndex ?>_ISOUTLET" size="30" maxlength="1" placeholder="<?= HtmlEncode($Grid->ISOUTLET->getPlaceHolder()) ?>" value="<?= $Grid->ISOUTLET->EditValue ?>"<?= $Grid->ISOUTLET->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ISOUTLET->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_ISOUTLET" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ISOUTLET" id="o<?= $Grid->RowIndex ?>_ISOUTLET" value="<?= HtmlEncode($Grid->ISOUTLET->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_ISOUTLET" class="form-group">
<input type="<?= $Grid->ISOUTLET->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_ISOUTLET" name="x<?= $Grid->RowIndex ?>_ISOUTLET" id="x<?= $Grid->RowIndex ?>_ISOUTLET" size="30" maxlength="1" placeholder="<?= HtmlEncode($Grid->ISOUTLET->getPlaceHolder()) ?>" value="<?= $Grid->ISOUTLET->EditValue ?>"<?= $Grid->ISOUTLET->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ISOUTLET->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_ISOUTLET">
<span<?= $Grid->ISOUTLET->viewAttributes() ?>>
<?= $Grid->ISOUTLET->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_ISOUTLET" data-hidden="1" name="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_ISOUTLET" id="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_ISOUTLET" value="<?= HtmlEncode($Grid->ISOUTLET->FormValue) ?>">
<input type="hidden" data-table="GOOD_GF" data-field="x_ISOUTLET" data-hidden="1" name="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_ISOUTLET" id="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_ISOUTLET" value="<?= HtmlEncode($Grid->ISOUTLET->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->QUANTITY->Visible) { // QUANTITY ?>
        <td data-name="QUANTITY" <?= $Grid->QUANTITY->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_QUANTITY" class="form-group">
<input type="<?= $Grid->QUANTITY->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_QUANTITY" name="x<?= $Grid->RowIndex ?>_QUANTITY" id="x<?= $Grid->RowIndex ?>_QUANTITY" size="30" placeholder="<?= HtmlEncode($Grid->QUANTITY->getPlaceHolder()) ?>" value="<?= $Grid->QUANTITY->EditValue ?>"<?= $Grid->QUANTITY->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->QUANTITY->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_QUANTITY" data-hidden="1" name="o<?= $Grid->RowIndex ?>_QUANTITY" id="o<?= $Grid->RowIndex ?>_QUANTITY" value="<?= HtmlEncode($Grid->QUANTITY->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_QUANTITY" class="form-group">
<input type="<?= $Grid->QUANTITY->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_QUANTITY" name="x<?= $Grid->RowIndex ?>_QUANTITY" id="x<?= $Grid->RowIndex ?>_QUANTITY" size="30" placeholder="<?= HtmlEncode($Grid->QUANTITY->getPlaceHolder()) ?>" value="<?= $Grid->QUANTITY->EditValue ?>"<?= $Grid->QUANTITY->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->QUANTITY->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_QUANTITY">
<span<?= $Grid->QUANTITY->viewAttributes() ?>>
<?= $Grid->QUANTITY->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_QUANTITY" data-hidden="1" name="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_QUANTITY" id="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_QUANTITY" value="<?= HtmlEncode($Grid->QUANTITY->FormValue) ?>">
<input type="hidden" data-table="GOOD_GF" data-field="x_QUANTITY" data-hidden="1" name="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_QUANTITY" id="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_QUANTITY" value="<?= HtmlEncode($Grid->QUANTITY->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->ALLOCATED_FROM->Visible) { // ALLOCATED_FROM ?>
        <td data-name="ALLOCATED_FROM" <?= $Grid->ALLOCATED_FROM->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_ALLOCATED_FROM" class="form-group">
<input type="<?= $Grid->ALLOCATED_FROM->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_ALLOCATED_FROM" name="x<?= $Grid->RowIndex ?>_ALLOCATED_FROM" id="x<?= $Grid->RowIndex ?>_ALLOCATED_FROM" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->ALLOCATED_FROM->getPlaceHolder()) ?>" value="<?= $Grid->ALLOCATED_FROM->EditValue ?>"<?= $Grid->ALLOCATED_FROM->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ALLOCATED_FROM->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_ALLOCATED_FROM" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ALLOCATED_FROM" id="o<?= $Grid->RowIndex ?>_ALLOCATED_FROM" value="<?= HtmlEncode($Grid->ALLOCATED_FROM->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_ALLOCATED_FROM" class="form-group">
<input type="<?= $Grid->ALLOCATED_FROM->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_ALLOCATED_FROM" name="x<?= $Grid->RowIndex ?>_ALLOCATED_FROM" id="x<?= $Grid->RowIndex ?>_ALLOCATED_FROM" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->ALLOCATED_FROM->getPlaceHolder()) ?>" value="<?= $Grid->ALLOCATED_FROM->EditValue ?>"<?= $Grid->ALLOCATED_FROM->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ALLOCATED_FROM->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_ALLOCATED_FROM">
<span<?= $Grid->ALLOCATED_FROM->viewAttributes() ?>>
<?= $Grid->ALLOCATED_FROM->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_ALLOCATED_FROM" data-hidden="1" name="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_ALLOCATED_FROM" id="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_ALLOCATED_FROM" value="<?= HtmlEncode($Grid->ALLOCATED_FROM->FormValue) ?>">
<input type="hidden" data-table="GOOD_GF" data-field="x_ALLOCATED_FROM" data-hidden="1" name="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_ALLOCATED_FROM" id="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_ALLOCATED_FROM" value="<?= HtmlEncode($Grid->ALLOCATED_FROM->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->DIJUAL->Visible) { // DIJUAL ?>
        <td data-name="DIJUAL" <?= $Grid->DIJUAL->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_DIJUAL" class="form-group">
<input type="<?= $Grid->DIJUAL->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_DIJUAL" name="x<?= $Grid->RowIndex ?>_DIJUAL" id="x<?= $Grid->RowIndex ?>_DIJUAL" size="30" placeholder="<?= HtmlEncode($Grid->DIJUAL->getPlaceHolder()) ?>" value="<?= $Grid->DIJUAL->EditValue ?>"<?= $Grid->DIJUAL->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->DIJUAL->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_DIJUAL" data-hidden="1" name="o<?= $Grid->RowIndex ?>_DIJUAL" id="o<?= $Grid->RowIndex ?>_DIJUAL" value="<?= HtmlEncode($Grid->DIJUAL->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_DIJUAL" class="form-group">
<input type="<?= $Grid->DIJUAL->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_DIJUAL" name="x<?= $Grid->RowIndex ?>_DIJUAL" id="x<?= $Grid->RowIndex ?>_DIJUAL" size="30" placeholder="<?= HtmlEncode($Grid->DIJUAL->getPlaceHolder()) ?>" value="<?= $Grid->DIJUAL->EditValue ?>"<?= $Grid->DIJUAL->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->DIJUAL->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_DIJUAL">
<span<?= $Grid->DIJUAL->viewAttributes() ?>>
<?= $Grid->DIJUAL->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_DIJUAL" data-hidden="1" name="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_DIJUAL" id="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_DIJUAL" value="<?= HtmlEncode($Grid->DIJUAL->FormValue) ?>">
<input type="hidden" data-table="GOOD_GF" data-field="x_DIJUAL" data-hidden="1" name="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_DIJUAL" id="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_DIJUAL" value="<?= HtmlEncode($Grid->DIJUAL->OldValue) ?>">
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
loadjs.ready(["fGOOD_GFgrid","load"], function () {
    fGOOD_GFgrid.updateLists(<?= $Grid->RowIndex ?>);
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_GOOD_GF", "data-rowtype" => ROWTYPE_ADD]);
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
    <?php if ($Grid->BRAND_ID->Visible) { // BRAND_ID ?>
        <td data-name="BRAND_ID">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_GOOD_GF_BRAND_ID" class="form-group GOOD_GF_BRAND_ID">
<div class="input-group ew-lookup-list">
    <div class="form-control ew-lookup-text" tabindex="-1" id="lu_x<?= $Grid->RowIndex ?>_BRAND_ID"><?= EmptyValue(strval($Grid->BRAND_ID->ViewValue)) ? $Language->phrase("PleaseSelect") : $Grid->BRAND_ID->ViewValue ?></div>
    <div class="input-group-append">
        <button type="button" title="<?= HtmlEncode(str_replace("%s", RemoveHtml($Grid->BRAND_ID->caption()), $Language->phrase("LookupLink", true))) ?>" class="ew-lookup-btn btn btn-default"<?= ($Grid->BRAND_ID->ReadOnly || $Grid->BRAND_ID->Disabled) ? " disabled" : "" ?> onclick="ew.modalLookupShow({lnk:this,el:'x<?= $Grid->RowIndex ?>_BRAND_ID',m:0,n:10});"><i class="fas fa-search ew-icon"></i></button>
    </div>
</div>
<div class="invalid-feedback"><?= $Grid->BRAND_ID->getErrorMessage() ?></div>
<?= $Grid->BRAND_ID->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_BRAND_ID") ?>
<input type="hidden" is="selection-list" data-table="GOOD_GF" data-field="x_BRAND_ID" data-type="text" data-multiple="0" data-lookup="1" data-value-separator="<?= $Grid->BRAND_ID->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_BRAND_ID" id="x<?= $Grid->RowIndex ?>_BRAND_ID" value="<?= $Grid->BRAND_ID->CurrentValue ?>"<?= $Grid->BRAND_ID->editAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_BRAND_ID" class="form-group GOOD_GF_BRAND_ID">
<span<?= $Grid->BRAND_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->BRAND_ID->getDisplayValue($Grid->BRAND_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_BRAND_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_BRAND_ID" id="x<?= $Grid->RowIndex ?>_BRAND_ID" value="<?= HtmlEncode($Grid->BRAND_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_BRAND_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_BRAND_ID" id="o<?= $Grid->RowIndex ?>_BRAND_ID" value="<?= HtmlEncode($Grid->BRAND_ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->ROOMS_ID->Visible) { // ROOMS_ID ?>
        <td data-name="ROOMS_ID">
<?php if (!$Grid->isConfirm()) { ?>
<?php if ($Grid->ROOMS_ID->getSessionValue() != "") { ?>
<span id="el$rowindex$_GOOD_GF_ROOMS_ID" class="form-group GOOD_GF_ROOMS_ID">
<span<?= $Grid->ROOMS_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->ROOMS_ID->getDisplayValue($Grid->ROOMS_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_ROOMS_ID" name="x<?= $Grid->RowIndex ?>_ROOMS_ID" value="<?= HtmlEncode($Grid->ROOMS_ID->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_ROOMS_ID" class="form-group GOOD_GF_ROOMS_ID">
<input type="<?= $Grid->ROOMS_ID->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_ROOMS_ID" name="x<?= $Grid->RowIndex ?>_ROOMS_ID" id="x<?= $Grid->RowIndex ?>_ROOMS_ID" size="30" maxlength="10" placeholder="<?= HtmlEncode($Grid->ROOMS_ID->getPlaceHolder()) ?>" value="<?= $Grid->ROOMS_ID->EditValue ?>"<?= $Grid->ROOMS_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ROOMS_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_ROOMS_ID" class="form-group GOOD_GF_ROOMS_ID">
<span<?= $Grid->ROOMS_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->ROOMS_ID->getDisplayValue($Grid->ROOMS_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_ROOMS_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_ROOMS_ID" id="x<?= $Grid->RowIndex ?>_ROOMS_ID" value="<?= HtmlEncode($Grid->ROOMS_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_ROOMS_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ROOMS_ID" id="o<?= $Grid->RowIndex ?>_ROOMS_ID" value="<?= HtmlEncode($Grid->ROOMS_ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->EXPIRY_DATE->Visible) { // EXPIRY_DATE ?>
        <td data-name="EXPIRY_DATE">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_GOOD_GF_EXPIRY_DATE" class="form-group GOOD_GF_EXPIRY_DATE">
<input type="<?= $Grid->EXPIRY_DATE->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_EXPIRY_DATE" name="x<?= $Grid->RowIndex ?>_EXPIRY_DATE" id="x<?= $Grid->RowIndex ?>_EXPIRY_DATE" placeholder="<?= HtmlEncode($Grid->EXPIRY_DATE->getPlaceHolder()) ?>" value="<?= $Grid->EXPIRY_DATE->EditValue ?>"<?= $Grid->EXPIRY_DATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->EXPIRY_DATE->getErrorMessage() ?></div>
<?php if (!$Grid->EXPIRY_DATE->ReadOnly && !$Grid->EXPIRY_DATE->Disabled && !isset($Grid->EXPIRY_DATE->EditAttrs["readonly"]) && !isset($Grid->EXPIRY_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fGOOD_GFgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fGOOD_GFgrid", "x<?= $Grid->RowIndex ?>_EXPIRY_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_EXPIRY_DATE" class="form-group GOOD_GF_EXPIRY_DATE">
<span<?= $Grid->EXPIRY_DATE->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->EXPIRY_DATE->getDisplayValue($Grid->EXPIRY_DATE->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_EXPIRY_DATE" data-hidden="1" name="x<?= $Grid->RowIndex ?>_EXPIRY_DATE" id="x<?= $Grid->RowIndex ?>_EXPIRY_DATE" value="<?= HtmlEncode($Grid->EXPIRY_DATE->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_EXPIRY_DATE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_EXPIRY_DATE" id="o<?= $Grid->RowIndex ?>_EXPIRY_DATE" value="<?= HtmlEncode($Grid->EXPIRY_DATE->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->ISOUTLET->Visible) { // ISOUTLET ?>
        <td data-name="ISOUTLET">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_GOOD_GF_ISOUTLET" class="form-group GOOD_GF_ISOUTLET">
<input type="<?= $Grid->ISOUTLET->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_ISOUTLET" name="x<?= $Grid->RowIndex ?>_ISOUTLET" id="x<?= $Grid->RowIndex ?>_ISOUTLET" size="30" maxlength="1" placeholder="<?= HtmlEncode($Grid->ISOUTLET->getPlaceHolder()) ?>" value="<?= $Grid->ISOUTLET->EditValue ?>"<?= $Grid->ISOUTLET->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ISOUTLET->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_ISOUTLET" class="form-group GOOD_GF_ISOUTLET">
<span<?= $Grid->ISOUTLET->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->ISOUTLET->getDisplayValue($Grid->ISOUTLET->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_ISOUTLET" data-hidden="1" name="x<?= $Grid->RowIndex ?>_ISOUTLET" id="x<?= $Grid->RowIndex ?>_ISOUTLET" value="<?= HtmlEncode($Grid->ISOUTLET->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_ISOUTLET" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ISOUTLET" id="o<?= $Grid->RowIndex ?>_ISOUTLET" value="<?= HtmlEncode($Grid->ISOUTLET->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->QUANTITY->Visible) { // QUANTITY ?>
        <td data-name="QUANTITY">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_GOOD_GF_QUANTITY" class="form-group GOOD_GF_QUANTITY">
<input type="<?= $Grid->QUANTITY->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_QUANTITY" name="x<?= $Grid->RowIndex ?>_QUANTITY" id="x<?= $Grid->RowIndex ?>_QUANTITY" size="30" placeholder="<?= HtmlEncode($Grid->QUANTITY->getPlaceHolder()) ?>" value="<?= $Grid->QUANTITY->EditValue ?>"<?= $Grid->QUANTITY->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->QUANTITY->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_QUANTITY" class="form-group GOOD_GF_QUANTITY">
<span<?= $Grid->QUANTITY->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->QUANTITY->getDisplayValue($Grid->QUANTITY->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_QUANTITY" data-hidden="1" name="x<?= $Grid->RowIndex ?>_QUANTITY" id="x<?= $Grid->RowIndex ?>_QUANTITY" value="<?= HtmlEncode($Grid->QUANTITY->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_QUANTITY" data-hidden="1" name="o<?= $Grid->RowIndex ?>_QUANTITY" id="o<?= $Grid->RowIndex ?>_QUANTITY" value="<?= HtmlEncode($Grid->QUANTITY->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->ALLOCATED_FROM->Visible) { // ALLOCATED_FROM ?>
        <td data-name="ALLOCATED_FROM">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_GOOD_GF_ALLOCATED_FROM" class="form-group GOOD_GF_ALLOCATED_FROM">
<input type="<?= $Grid->ALLOCATED_FROM->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_ALLOCATED_FROM" name="x<?= $Grid->RowIndex ?>_ALLOCATED_FROM" id="x<?= $Grid->RowIndex ?>_ALLOCATED_FROM" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->ALLOCATED_FROM->getPlaceHolder()) ?>" value="<?= $Grid->ALLOCATED_FROM->EditValue ?>"<?= $Grid->ALLOCATED_FROM->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ALLOCATED_FROM->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_ALLOCATED_FROM" class="form-group GOOD_GF_ALLOCATED_FROM">
<span<?= $Grid->ALLOCATED_FROM->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->ALLOCATED_FROM->getDisplayValue($Grid->ALLOCATED_FROM->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_ALLOCATED_FROM" data-hidden="1" name="x<?= $Grid->RowIndex ?>_ALLOCATED_FROM" id="x<?= $Grid->RowIndex ?>_ALLOCATED_FROM" value="<?= HtmlEncode($Grid->ALLOCATED_FROM->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_ALLOCATED_FROM" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ALLOCATED_FROM" id="o<?= $Grid->RowIndex ?>_ALLOCATED_FROM" value="<?= HtmlEncode($Grid->ALLOCATED_FROM->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->DIJUAL->Visible) { // DIJUAL ?>
        <td data-name="DIJUAL">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_GOOD_GF_DIJUAL" class="form-group GOOD_GF_DIJUAL">
<input type="<?= $Grid->DIJUAL->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_DIJUAL" name="x<?= $Grid->RowIndex ?>_DIJUAL" id="x<?= $Grid->RowIndex ?>_DIJUAL" size="30" placeholder="<?= HtmlEncode($Grid->DIJUAL->getPlaceHolder()) ?>" value="<?= $Grid->DIJUAL->EditValue ?>"<?= $Grid->DIJUAL->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->DIJUAL->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_DIJUAL" class="form-group GOOD_GF_DIJUAL">
<span<?= $Grid->DIJUAL->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->DIJUAL->getDisplayValue($Grid->DIJUAL->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_DIJUAL" data-hidden="1" name="x<?= $Grid->RowIndex ?>_DIJUAL" id="x<?= $Grid->RowIndex ?>_DIJUAL" value="<?= HtmlEncode($Grid->DIJUAL->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_DIJUAL" data-hidden="1" name="o<?= $Grid->RowIndex ?>_DIJUAL" id="o<?= $Grid->RowIndex ?>_DIJUAL" value="<?= HtmlEncode($Grid->DIJUAL->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["fGOOD_GFgrid","load"], function() {
    fGOOD_GFgrid.updateLists(<?= $Grid->RowIndex ?>);
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
<input type="hidden" name="detailpage" value="fGOOD_GFgrid">
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
    ew.addEventHandlers("GOOD_GF");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
