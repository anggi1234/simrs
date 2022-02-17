<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAJALALTER;

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
        ["ORG_ID", [fields.ORG_ID.visible && fields.ORG_ID.required ? ew.Validators.required(fields.ORG_ID.caption) : null], fields.ORG_ID.isInvalid],
        ["BRAND_ID", [fields.BRAND_ID.visible && fields.BRAND_ID.required ? ew.Validators.required(fields.BRAND_ID.caption) : null], fields.BRAND_ID.isInvalid],
        ["BRAND_NAME", [fields.BRAND_NAME.visible && fields.BRAND_NAME.required ? ew.Validators.required(fields.BRAND_NAME.caption) : null], fields.BRAND_NAME.isInvalid],
        ["ROOMS_ID", [fields.ROOMS_ID.visible && fields.ROOMS_ID.required ? ew.Validators.required(fields.ROOMS_ID.caption) : null], fields.ROOMS_ID.isInvalid],
        ["QUANTITY", [fields.QUANTITY.visible && fields.QUANTITY.required ? ew.Validators.required(fields.QUANTITY.caption) : null, ew.Validators.float], fields.QUANTITY.isInvalid],
        ["MEASURE_ID", [fields.MEASURE_ID.visible && fields.MEASURE_ID.required ? ew.Validators.required(fields.MEASURE_ID.caption) : null, ew.Validators.integer], fields.MEASURE_ID.isInvalid],
        ["ALLOCATED_DATE", [fields.ALLOCATED_DATE.visible && fields.ALLOCATED_DATE.required ? ew.Validators.required(fields.ALLOCATED_DATE.caption) : null, ew.Validators.datetime(0)], fields.ALLOCATED_DATE.isInvalid],
        ["INVOICE_ID", [fields.INVOICE_ID.visible && fields.INVOICE_ID.required ? ew.Validators.required(fields.INVOICE_ID.caption) : null], fields.INVOICE_ID.isInvalid],
        ["ALLOCATED_FROM", [fields.ALLOCATED_FROM.visible && fields.ALLOCATED_FROM.required ? ew.Validators.required(fields.ALLOCATED_FROM.caption) : null], fields.ALLOCATED_FROM.isInvalid],
        ["PRICE", [fields.PRICE.visible && fields.PRICE.required ? ew.Validators.required(fields.PRICE.caption) : null, ew.Validators.float], fields.PRICE.isInvalid],
        ["DIJUAL", [fields.DIJUAL.visible && fields.DIJUAL.required ? ew.Validators.required(fields.DIJUAL.caption) : null, ew.Validators.float], fields.DIJUAL.isInvalid],
        ["DOC_NO", [fields.DOC_NO.visible && fields.DOC_NO.required ? ew.Validators.required(fields.DOC_NO.caption) : null], fields.DOC_NO.isInvalid],
        ["PRINT_DATE", [fields.PRINT_DATE.visible && fields.PRINT_DATE.required ? ew.Validators.required(fields.PRINT_DATE.caption) : null, ew.Validators.datetime(0)], fields.PRINT_DATE.isInvalid],
        ["PRINTED_BY", [fields.PRINTED_BY.visible && fields.PRINTED_BY.required ? ew.Validators.required(fields.PRINTED_BY.caption) : null], fields.PRINTED_BY.isInvalid]
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
        if (ew.valueChanged(fobj, rowIndex, "ORG_ID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "BRAND_ID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "BRAND_NAME", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "ROOMS_ID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "QUANTITY", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "MEASURE_ID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "ALLOCATED_DATE", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "INVOICE_ID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "ALLOCATED_FROM", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "PRICE", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "DIJUAL", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "DOC_NO", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "PRINT_DATE", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "PRINTED_BY", false))
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
<?php if ($Grid->ORG_ID->Visible) { // ORG_ID ?>
        <th data-name="ORG_ID" class="<?= $Grid->ORG_ID->headerCellClass() ?>"><div id="elh_GOOD_GF_ORG_ID" class="GOOD_GF_ORG_ID"><?= $Grid->renderSort($Grid->ORG_ID) ?></div></th>
<?php } ?>
<?php if ($Grid->BRAND_ID->Visible) { // BRAND_ID ?>
        <th data-name="BRAND_ID" class="<?= $Grid->BRAND_ID->headerCellClass() ?>"><div id="elh_GOOD_GF_BRAND_ID" class="GOOD_GF_BRAND_ID"><?= $Grid->renderSort($Grid->BRAND_ID) ?></div></th>
<?php } ?>
<?php if ($Grid->BRAND_NAME->Visible) { // BRAND_NAME ?>
        <th data-name="BRAND_NAME" class="<?= $Grid->BRAND_NAME->headerCellClass() ?>"><div id="elh_GOOD_GF_BRAND_NAME" class="GOOD_GF_BRAND_NAME"><?= $Grid->renderSort($Grid->BRAND_NAME) ?></div></th>
<?php } ?>
<?php if ($Grid->ROOMS_ID->Visible) { // ROOMS_ID ?>
        <th data-name="ROOMS_ID" class="<?= $Grid->ROOMS_ID->headerCellClass() ?>"><div id="elh_GOOD_GF_ROOMS_ID" class="GOOD_GF_ROOMS_ID"><?= $Grid->renderSort($Grid->ROOMS_ID) ?></div></th>
<?php } ?>
<?php if ($Grid->QUANTITY->Visible) { // QUANTITY ?>
        <th data-name="QUANTITY" class="<?= $Grid->QUANTITY->headerCellClass() ?>"><div id="elh_GOOD_GF_QUANTITY" class="GOOD_GF_QUANTITY"><?= $Grid->renderSort($Grid->QUANTITY) ?></div></th>
<?php } ?>
<?php if ($Grid->MEASURE_ID->Visible) { // MEASURE_ID ?>
        <th data-name="MEASURE_ID" class="<?= $Grid->MEASURE_ID->headerCellClass() ?>"><div id="elh_GOOD_GF_MEASURE_ID" class="GOOD_GF_MEASURE_ID"><?= $Grid->renderSort($Grid->MEASURE_ID) ?></div></th>
<?php } ?>
<?php if ($Grid->ALLOCATED_DATE->Visible) { // ALLOCATED_DATE ?>
        <th data-name="ALLOCATED_DATE" class="<?= $Grid->ALLOCATED_DATE->headerCellClass() ?>"><div id="elh_GOOD_GF_ALLOCATED_DATE" class="GOOD_GF_ALLOCATED_DATE"><?= $Grid->renderSort($Grid->ALLOCATED_DATE) ?></div></th>
<?php } ?>
<?php if ($Grid->INVOICE_ID->Visible) { // INVOICE_ID ?>
        <th data-name="INVOICE_ID" class="<?= $Grid->INVOICE_ID->headerCellClass() ?>"><div id="elh_GOOD_GF_INVOICE_ID" class="GOOD_GF_INVOICE_ID"><?= $Grid->renderSort($Grid->INVOICE_ID) ?></div></th>
<?php } ?>
<?php if ($Grid->ALLOCATED_FROM->Visible) { // ALLOCATED_FROM ?>
        <th data-name="ALLOCATED_FROM" class="<?= $Grid->ALLOCATED_FROM->headerCellClass() ?>"><div id="elh_GOOD_GF_ALLOCATED_FROM" class="GOOD_GF_ALLOCATED_FROM"><?= $Grid->renderSort($Grid->ALLOCATED_FROM) ?></div></th>
<?php } ?>
<?php if ($Grid->PRICE->Visible) { // PRICE ?>
        <th data-name="PRICE" class="<?= $Grid->PRICE->headerCellClass() ?>"><div id="elh_GOOD_GF_PRICE" class="GOOD_GF_PRICE"><?= $Grid->renderSort($Grid->PRICE) ?></div></th>
<?php } ?>
<?php if ($Grid->DIJUAL->Visible) { // DIJUAL ?>
        <th data-name="DIJUAL" class="<?= $Grid->DIJUAL->headerCellClass() ?>"><div id="elh_GOOD_GF_DIJUAL" class="GOOD_GF_DIJUAL"><?= $Grid->renderSort($Grid->DIJUAL) ?></div></th>
<?php } ?>
<?php if ($Grid->DOC_NO->Visible) { // DOC_NO ?>
        <th data-name="DOC_NO" class="<?= $Grid->DOC_NO->headerCellClass() ?>"><div id="elh_GOOD_GF_DOC_NO" class="GOOD_GF_DOC_NO"><?= $Grid->renderSort($Grid->DOC_NO) ?></div></th>
<?php } ?>
<?php if ($Grid->PRINT_DATE->Visible) { // PRINT_DATE ?>
        <th data-name="PRINT_DATE" class="<?= $Grid->PRINT_DATE->headerCellClass() ?>"><div id="elh_GOOD_GF_PRINT_DATE" class="GOOD_GF_PRINT_DATE"><?= $Grid->renderSort($Grid->PRINT_DATE) ?></div></th>
<?php } ?>
<?php if ($Grid->PRINTED_BY->Visible) { // PRINTED_BY ?>
        <th data-name="PRINTED_BY" class="<?= $Grid->PRINTED_BY->headerCellClass() ?>"><div id="elh_GOOD_GF_PRINTED_BY" class="GOOD_GF_PRINTED_BY"><?= $Grid->renderSort($Grid->PRINTED_BY) ?></div></th>
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
    <?php if ($Grid->ORG_ID->Visible) { // ORG_ID ?>
        <td data-name="ORG_ID" <?= $Grid->ORG_ID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_ORG_ID" class="form-group">
<input type="<?= $Grid->ORG_ID->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_ORG_ID" name="x<?= $Grid->RowIndex ?>_ORG_ID" id="x<?= $Grid->RowIndex ?>_ORG_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->ORG_ID->getPlaceHolder()) ?>" value="<?= $Grid->ORG_ID->EditValue ?>"<?= $Grid->ORG_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ORG_ID->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_ORG_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ORG_ID" id="o<?= $Grid->RowIndex ?>_ORG_ID" value="<?= HtmlEncode($Grid->ORG_ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_ORG_ID" class="form-group">
<input type="<?= $Grid->ORG_ID->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_ORG_ID" name="x<?= $Grid->RowIndex ?>_ORG_ID" id="x<?= $Grid->RowIndex ?>_ORG_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->ORG_ID->getPlaceHolder()) ?>" value="<?= $Grid->ORG_ID->EditValue ?>"<?= $Grid->ORG_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ORG_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_ORG_ID">
<span<?= $Grid->ORG_ID->viewAttributes() ?>>
<?= $Grid->ORG_ID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_ORG_ID" data-hidden="1" name="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_ORG_ID" id="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_ORG_ID" value="<?= HtmlEncode($Grid->ORG_ID->FormValue) ?>">
<input type="hidden" data-table="GOOD_GF" data-field="x_ORG_ID" data-hidden="1" name="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_ORG_ID" id="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_ORG_ID" value="<?= HtmlEncode($Grid->ORG_ID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
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
    <?php if ($Grid->BRAND_NAME->Visible) { // BRAND_NAME ?>
        <td data-name="BRAND_NAME" <?= $Grid->BRAND_NAME->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_BRAND_NAME" class="form-group">
<input type="<?= $Grid->BRAND_NAME->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_BRAND_NAME" name="x<?= $Grid->RowIndex ?>_BRAND_NAME" id="x<?= $Grid->RowIndex ?>_BRAND_NAME" size="30" maxlength="150" placeholder="<?= HtmlEncode($Grid->BRAND_NAME->getPlaceHolder()) ?>" value="<?= $Grid->BRAND_NAME->EditValue ?>"<?= $Grid->BRAND_NAME->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->BRAND_NAME->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_BRAND_NAME" data-hidden="1" name="o<?= $Grid->RowIndex ?>_BRAND_NAME" id="o<?= $Grid->RowIndex ?>_BRAND_NAME" value="<?= HtmlEncode($Grid->BRAND_NAME->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_BRAND_NAME" class="form-group">
<input type="<?= $Grid->BRAND_NAME->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_BRAND_NAME" name="x<?= $Grid->RowIndex ?>_BRAND_NAME" id="x<?= $Grid->RowIndex ?>_BRAND_NAME" size="30" maxlength="150" placeholder="<?= HtmlEncode($Grid->BRAND_NAME->getPlaceHolder()) ?>" value="<?= $Grid->BRAND_NAME->EditValue ?>"<?= $Grid->BRAND_NAME->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->BRAND_NAME->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_BRAND_NAME">
<span<?= $Grid->BRAND_NAME->viewAttributes() ?>>
<?= $Grid->BRAND_NAME->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_BRAND_NAME" data-hidden="1" name="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_BRAND_NAME" id="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_BRAND_NAME" value="<?= HtmlEncode($Grid->BRAND_NAME->FormValue) ?>">
<input type="hidden" data-table="GOOD_GF" data-field="x_BRAND_NAME" data-hidden="1" name="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_BRAND_NAME" id="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_BRAND_NAME" value="<?= HtmlEncode($Grid->BRAND_NAME->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->ROOMS_ID->Visible) { // ROOMS_ID ?>
        <td data-name="ROOMS_ID" <?= $Grid->ROOMS_ID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_ROOMS_ID" class="form-group">
<input type="<?= $Grid->ROOMS_ID->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_ROOMS_ID" name="x<?= $Grid->RowIndex ?>_ROOMS_ID" id="x<?= $Grid->RowIndex ?>_ROOMS_ID" size="30" maxlength="10" placeholder="<?= HtmlEncode($Grid->ROOMS_ID->getPlaceHolder()) ?>" value="<?= $Grid->ROOMS_ID->EditValue ?>"<?= $Grid->ROOMS_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ROOMS_ID->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_ROOMS_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ROOMS_ID" id="o<?= $Grid->RowIndex ?>_ROOMS_ID" value="<?= HtmlEncode($Grid->ROOMS_ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_ROOMS_ID" class="form-group">
<input type="<?= $Grid->ROOMS_ID->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_ROOMS_ID" name="x<?= $Grid->RowIndex ?>_ROOMS_ID" id="x<?= $Grid->RowIndex ?>_ROOMS_ID" size="30" maxlength="10" placeholder="<?= HtmlEncode($Grid->ROOMS_ID->getPlaceHolder()) ?>" value="<?= $Grid->ROOMS_ID->EditValue ?>"<?= $Grid->ROOMS_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ROOMS_ID->getErrorMessage() ?></div>
</span>
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
    <?php if ($Grid->MEASURE_ID->Visible) { // MEASURE_ID ?>
        <td data-name="MEASURE_ID" <?= $Grid->MEASURE_ID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_MEASURE_ID" class="form-group">
<input type="<?= $Grid->MEASURE_ID->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_MEASURE_ID" name="x<?= $Grid->RowIndex ?>_MEASURE_ID" id="x<?= $Grid->RowIndex ?>_MEASURE_ID" size="30" placeholder="<?= HtmlEncode($Grid->MEASURE_ID->getPlaceHolder()) ?>" value="<?= $Grid->MEASURE_ID->EditValue ?>"<?= $Grid->MEASURE_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->MEASURE_ID->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_MEASURE_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_MEASURE_ID" id="o<?= $Grid->RowIndex ?>_MEASURE_ID" value="<?= HtmlEncode($Grid->MEASURE_ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_MEASURE_ID" class="form-group">
<input type="<?= $Grid->MEASURE_ID->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_MEASURE_ID" name="x<?= $Grid->RowIndex ?>_MEASURE_ID" id="x<?= $Grid->RowIndex ?>_MEASURE_ID" size="30" placeholder="<?= HtmlEncode($Grid->MEASURE_ID->getPlaceHolder()) ?>" value="<?= $Grid->MEASURE_ID->EditValue ?>"<?= $Grid->MEASURE_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->MEASURE_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_MEASURE_ID">
<span<?= $Grid->MEASURE_ID->viewAttributes() ?>>
<?= $Grid->MEASURE_ID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_MEASURE_ID" data-hidden="1" name="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_MEASURE_ID" id="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_MEASURE_ID" value="<?= HtmlEncode($Grid->MEASURE_ID->FormValue) ?>">
<input type="hidden" data-table="GOOD_GF" data-field="x_MEASURE_ID" data-hidden="1" name="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_MEASURE_ID" id="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_MEASURE_ID" value="<?= HtmlEncode($Grid->MEASURE_ID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->ALLOCATED_DATE->Visible) { // ALLOCATED_DATE ?>
        <td data-name="ALLOCATED_DATE" <?= $Grid->ALLOCATED_DATE->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_ALLOCATED_DATE" class="form-group">
<input type="<?= $Grid->ALLOCATED_DATE->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_ALLOCATED_DATE" name="x<?= $Grid->RowIndex ?>_ALLOCATED_DATE" id="x<?= $Grid->RowIndex ?>_ALLOCATED_DATE" placeholder="<?= HtmlEncode($Grid->ALLOCATED_DATE->getPlaceHolder()) ?>" value="<?= $Grid->ALLOCATED_DATE->EditValue ?>"<?= $Grid->ALLOCATED_DATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ALLOCATED_DATE->getErrorMessage() ?></div>
<?php if (!$Grid->ALLOCATED_DATE->ReadOnly && !$Grid->ALLOCATED_DATE->Disabled && !isset($Grid->ALLOCATED_DATE->EditAttrs["readonly"]) && !isset($Grid->ALLOCATED_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fGOOD_GFgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fGOOD_GFgrid", "x<?= $Grid->RowIndex ?>_ALLOCATED_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_ALLOCATED_DATE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ALLOCATED_DATE" id="o<?= $Grid->RowIndex ?>_ALLOCATED_DATE" value="<?= HtmlEncode($Grid->ALLOCATED_DATE->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_ALLOCATED_DATE" class="form-group">
<input type="<?= $Grid->ALLOCATED_DATE->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_ALLOCATED_DATE" name="x<?= $Grid->RowIndex ?>_ALLOCATED_DATE" id="x<?= $Grid->RowIndex ?>_ALLOCATED_DATE" placeholder="<?= HtmlEncode($Grid->ALLOCATED_DATE->getPlaceHolder()) ?>" value="<?= $Grid->ALLOCATED_DATE->EditValue ?>"<?= $Grid->ALLOCATED_DATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ALLOCATED_DATE->getErrorMessage() ?></div>
<?php if (!$Grid->ALLOCATED_DATE->ReadOnly && !$Grid->ALLOCATED_DATE->Disabled && !isset($Grid->ALLOCATED_DATE->EditAttrs["readonly"]) && !isset($Grid->ALLOCATED_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fGOOD_GFgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fGOOD_GFgrid", "x<?= $Grid->RowIndex ?>_ALLOCATED_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_ALLOCATED_DATE">
<span<?= $Grid->ALLOCATED_DATE->viewAttributes() ?>>
<?= $Grid->ALLOCATED_DATE->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_ALLOCATED_DATE" data-hidden="1" name="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_ALLOCATED_DATE" id="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_ALLOCATED_DATE" value="<?= HtmlEncode($Grid->ALLOCATED_DATE->FormValue) ?>">
<input type="hidden" data-table="GOOD_GF" data-field="x_ALLOCATED_DATE" data-hidden="1" name="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_ALLOCATED_DATE" id="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_ALLOCATED_DATE" value="<?= HtmlEncode($Grid->ALLOCATED_DATE->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->INVOICE_ID->Visible) { // INVOICE_ID ?>
        <td data-name="INVOICE_ID" <?= $Grid->INVOICE_ID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_INVOICE_ID" class="form-group">
<input type="<?= $Grid->INVOICE_ID->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_INVOICE_ID" name="x<?= $Grid->RowIndex ?>_INVOICE_ID" id="x<?= $Grid->RowIndex ?>_INVOICE_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->INVOICE_ID->getPlaceHolder()) ?>" value="<?= $Grid->INVOICE_ID->EditValue ?>"<?= $Grid->INVOICE_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->INVOICE_ID->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_INVOICE_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_INVOICE_ID" id="o<?= $Grid->RowIndex ?>_INVOICE_ID" value="<?= HtmlEncode($Grid->INVOICE_ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_INVOICE_ID" class="form-group">
<input type="<?= $Grid->INVOICE_ID->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_INVOICE_ID" name="x<?= $Grid->RowIndex ?>_INVOICE_ID" id="x<?= $Grid->RowIndex ?>_INVOICE_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->INVOICE_ID->getPlaceHolder()) ?>" value="<?= $Grid->INVOICE_ID->EditValue ?>"<?= $Grid->INVOICE_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->INVOICE_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_INVOICE_ID">
<span<?= $Grid->INVOICE_ID->viewAttributes() ?>>
<?= $Grid->INVOICE_ID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_INVOICE_ID" data-hidden="1" name="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_INVOICE_ID" id="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_INVOICE_ID" value="<?= HtmlEncode($Grid->INVOICE_ID->FormValue) ?>">
<input type="hidden" data-table="GOOD_GF" data-field="x_INVOICE_ID" data-hidden="1" name="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_INVOICE_ID" id="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_INVOICE_ID" value="<?= HtmlEncode($Grid->INVOICE_ID->OldValue) ?>">
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
    <?php if ($Grid->PRICE->Visible) { // PRICE ?>
        <td data-name="PRICE" <?= $Grid->PRICE->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_PRICE" class="form-group">
<input type="<?= $Grid->PRICE->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_PRICE" name="x<?= $Grid->RowIndex ?>_PRICE" id="x<?= $Grid->RowIndex ?>_PRICE" size="30" placeholder="<?= HtmlEncode($Grid->PRICE->getPlaceHolder()) ?>" value="<?= $Grid->PRICE->EditValue ?>"<?= $Grid->PRICE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->PRICE->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_PRICE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_PRICE" id="o<?= $Grid->RowIndex ?>_PRICE" value="<?= HtmlEncode($Grid->PRICE->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_PRICE" class="form-group">
<input type="<?= $Grid->PRICE->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_PRICE" name="x<?= $Grid->RowIndex ?>_PRICE" id="x<?= $Grid->RowIndex ?>_PRICE" size="30" placeholder="<?= HtmlEncode($Grid->PRICE->getPlaceHolder()) ?>" value="<?= $Grid->PRICE->EditValue ?>"<?= $Grid->PRICE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->PRICE->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_PRICE">
<span<?= $Grid->PRICE->viewAttributes() ?>>
<?= $Grid->PRICE->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_PRICE" data-hidden="1" name="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_PRICE" id="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_PRICE" value="<?= HtmlEncode($Grid->PRICE->FormValue) ?>">
<input type="hidden" data-table="GOOD_GF" data-field="x_PRICE" data-hidden="1" name="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_PRICE" id="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_PRICE" value="<?= HtmlEncode($Grid->PRICE->OldValue) ?>">
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
    <?php if ($Grid->DOC_NO->Visible) { // DOC_NO ?>
        <td data-name="DOC_NO" <?= $Grid->DOC_NO->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Grid->DOC_NO->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_DOC_NO" class="form-group">
<span<?= $Grid->DOC_NO->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->DOC_NO->getDisplayValue($Grid->DOC_NO->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_DOC_NO" name="x<?= $Grid->RowIndex ?>_DOC_NO" value="<?= HtmlEncode($Grid->DOC_NO->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_DOC_NO" class="form-group">
<input type="<?= $Grid->DOC_NO->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_DOC_NO" name="x<?= $Grid->RowIndex ?>_DOC_NO" id="x<?= $Grid->RowIndex ?>_DOC_NO" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->DOC_NO->getPlaceHolder()) ?>" value="<?= $Grid->DOC_NO->EditValue ?>"<?= $Grid->DOC_NO->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->DOC_NO->getErrorMessage() ?></div>
</span>
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_DOC_NO" data-hidden="1" name="o<?= $Grid->RowIndex ?>_DOC_NO" id="o<?= $Grid->RowIndex ?>_DOC_NO" value="<?= HtmlEncode($Grid->DOC_NO->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Grid->DOC_NO->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_DOC_NO" class="form-group">
<span<?= $Grid->DOC_NO->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->DOC_NO->getDisplayValue($Grid->DOC_NO->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_DOC_NO" name="x<?= $Grid->RowIndex ?>_DOC_NO" value="<?= HtmlEncode($Grid->DOC_NO->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_DOC_NO" class="form-group">
<input type="<?= $Grid->DOC_NO->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_DOC_NO" name="x<?= $Grid->RowIndex ?>_DOC_NO" id="x<?= $Grid->RowIndex ?>_DOC_NO" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->DOC_NO->getPlaceHolder()) ?>" value="<?= $Grid->DOC_NO->EditValue ?>"<?= $Grid->DOC_NO->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->DOC_NO->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_DOC_NO">
<span<?= $Grid->DOC_NO->viewAttributes() ?>>
<?= $Grid->DOC_NO->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_DOC_NO" data-hidden="1" name="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_DOC_NO" id="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_DOC_NO" value="<?= HtmlEncode($Grid->DOC_NO->FormValue) ?>">
<input type="hidden" data-table="GOOD_GF" data-field="x_DOC_NO" data-hidden="1" name="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_DOC_NO" id="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_DOC_NO" value="<?= HtmlEncode($Grid->DOC_NO->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->PRINT_DATE->Visible) { // PRINT_DATE ?>
        <td data-name="PRINT_DATE" <?= $Grid->PRINT_DATE->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_PRINT_DATE" class="form-group">
<input type="<?= $Grid->PRINT_DATE->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_PRINT_DATE" name="x<?= $Grid->RowIndex ?>_PRINT_DATE" id="x<?= $Grid->RowIndex ?>_PRINT_DATE" placeholder="<?= HtmlEncode($Grid->PRINT_DATE->getPlaceHolder()) ?>" value="<?= $Grid->PRINT_DATE->EditValue ?>"<?= $Grid->PRINT_DATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->PRINT_DATE->getErrorMessage() ?></div>
<?php if (!$Grid->PRINT_DATE->ReadOnly && !$Grid->PRINT_DATE->Disabled && !isset($Grid->PRINT_DATE->EditAttrs["readonly"]) && !isset($Grid->PRINT_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fGOOD_GFgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fGOOD_GFgrid", "x<?= $Grid->RowIndex ?>_PRINT_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_PRINT_DATE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_PRINT_DATE" id="o<?= $Grid->RowIndex ?>_PRINT_DATE" value="<?= HtmlEncode($Grid->PRINT_DATE->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_PRINT_DATE" class="form-group">
<input type="<?= $Grid->PRINT_DATE->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_PRINT_DATE" name="x<?= $Grid->RowIndex ?>_PRINT_DATE" id="x<?= $Grid->RowIndex ?>_PRINT_DATE" placeholder="<?= HtmlEncode($Grid->PRINT_DATE->getPlaceHolder()) ?>" value="<?= $Grid->PRINT_DATE->EditValue ?>"<?= $Grid->PRINT_DATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->PRINT_DATE->getErrorMessage() ?></div>
<?php if (!$Grid->PRINT_DATE->ReadOnly && !$Grid->PRINT_DATE->Disabled && !isset($Grid->PRINT_DATE->EditAttrs["readonly"]) && !isset($Grid->PRINT_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fGOOD_GFgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fGOOD_GFgrid", "x<?= $Grid->RowIndex ?>_PRINT_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_PRINT_DATE">
<span<?= $Grid->PRINT_DATE->viewAttributes() ?>>
<?= $Grid->PRINT_DATE->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_PRINT_DATE" data-hidden="1" name="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_PRINT_DATE" id="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_PRINT_DATE" value="<?= HtmlEncode($Grid->PRINT_DATE->FormValue) ?>">
<input type="hidden" data-table="GOOD_GF" data-field="x_PRINT_DATE" data-hidden="1" name="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_PRINT_DATE" id="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_PRINT_DATE" value="<?= HtmlEncode($Grid->PRINT_DATE->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->PRINTED_BY->Visible) { // PRINTED_BY ?>
        <td data-name="PRINTED_BY" <?= $Grid->PRINTED_BY->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_PRINTED_BY" class="form-group">
<input type="<?= $Grid->PRINTED_BY->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_PRINTED_BY" name="x<?= $Grid->RowIndex ?>_PRINTED_BY" id="x<?= $Grid->RowIndex ?>_PRINTED_BY" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->PRINTED_BY->getPlaceHolder()) ?>" value="<?= $Grid->PRINTED_BY->EditValue ?>"<?= $Grid->PRINTED_BY->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->PRINTED_BY->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_PRINTED_BY" data-hidden="1" name="o<?= $Grid->RowIndex ?>_PRINTED_BY" id="o<?= $Grid->RowIndex ?>_PRINTED_BY" value="<?= HtmlEncode($Grid->PRINTED_BY->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_PRINTED_BY" class="form-group">
<input type="<?= $Grid->PRINTED_BY->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_PRINTED_BY" name="x<?= $Grid->RowIndex ?>_PRINTED_BY" id="x<?= $Grid->RowIndex ?>_PRINTED_BY" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->PRINTED_BY->getPlaceHolder()) ?>" value="<?= $Grid->PRINTED_BY->EditValue ?>"<?= $Grid->PRINTED_BY->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->PRINTED_BY->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_PRINTED_BY">
<span<?= $Grid->PRINTED_BY->viewAttributes() ?>>
<?= $Grid->PRINTED_BY->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_PRINTED_BY" data-hidden="1" name="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_PRINTED_BY" id="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_PRINTED_BY" value="<?= HtmlEncode($Grid->PRINTED_BY->FormValue) ?>">
<input type="hidden" data-table="GOOD_GF" data-field="x_PRINTED_BY" data-hidden="1" name="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_PRINTED_BY" id="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_PRINTED_BY" value="<?= HtmlEncode($Grid->PRINTED_BY->OldValue) ?>">
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
    <?php if ($Grid->ORG_ID->Visible) { // ORG_ID ?>
        <td data-name="ORG_ID">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_GOOD_GF_ORG_ID" class="form-group GOOD_GF_ORG_ID">
<input type="<?= $Grid->ORG_ID->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_ORG_ID" name="x<?= $Grid->RowIndex ?>_ORG_ID" id="x<?= $Grid->RowIndex ?>_ORG_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->ORG_ID->getPlaceHolder()) ?>" value="<?= $Grid->ORG_ID->EditValue ?>"<?= $Grid->ORG_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ORG_ID->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_ORG_ID" class="form-group GOOD_GF_ORG_ID">
<span<?= $Grid->ORG_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->ORG_ID->getDisplayValue($Grid->ORG_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_ORG_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_ORG_ID" id="x<?= $Grid->RowIndex ?>_ORG_ID" value="<?= HtmlEncode($Grid->ORG_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_ORG_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ORG_ID" id="o<?= $Grid->RowIndex ?>_ORG_ID" value="<?= HtmlEncode($Grid->ORG_ID->OldValue) ?>">
</td>
    <?php } ?>
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
    <?php if ($Grid->BRAND_NAME->Visible) { // BRAND_NAME ?>
        <td data-name="BRAND_NAME">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_GOOD_GF_BRAND_NAME" class="form-group GOOD_GF_BRAND_NAME">
<input type="<?= $Grid->BRAND_NAME->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_BRAND_NAME" name="x<?= $Grid->RowIndex ?>_BRAND_NAME" id="x<?= $Grid->RowIndex ?>_BRAND_NAME" size="30" maxlength="150" placeholder="<?= HtmlEncode($Grid->BRAND_NAME->getPlaceHolder()) ?>" value="<?= $Grid->BRAND_NAME->EditValue ?>"<?= $Grid->BRAND_NAME->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->BRAND_NAME->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_BRAND_NAME" class="form-group GOOD_GF_BRAND_NAME">
<span<?= $Grid->BRAND_NAME->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->BRAND_NAME->getDisplayValue($Grid->BRAND_NAME->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_BRAND_NAME" data-hidden="1" name="x<?= $Grid->RowIndex ?>_BRAND_NAME" id="x<?= $Grid->RowIndex ?>_BRAND_NAME" value="<?= HtmlEncode($Grid->BRAND_NAME->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_BRAND_NAME" data-hidden="1" name="o<?= $Grid->RowIndex ?>_BRAND_NAME" id="o<?= $Grid->RowIndex ?>_BRAND_NAME" value="<?= HtmlEncode($Grid->BRAND_NAME->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->ROOMS_ID->Visible) { // ROOMS_ID ?>
        <td data-name="ROOMS_ID">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_GOOD_GF_ROOMS_ID" class="form-group GOOD_GF_ROOMS_ID">
<input type="<?= $Grid->ROOMS_ID->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_ROOMS_ID" name="x<?= $Grid->RowIndex ?>_ROOMS_ID" id="x<?= $Grid->RowIndex ?>_ROOMS_ID" size="30" maxlength="10" placeholder="<?= HtmlEncode($Grid->ROOMS_ID->getPlaceHolder()) ?>" value="<?= $Grid->ROOMS_ID->EditValue ?>"<?= $Grid->ROOMS_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ROOMS_ID->getErrorMessage() ?></div>
</span>
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
    <?php if ($Grid->MEASURE_ID->Visible) { // MEASURE_ID ?>
        <td data-name="MEASURE_ID">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_GOOD_GF_MEASURE_ID" class="form-group GOOD_GF_MEASURE_ID">
<input type="<?= $Grid->MEASURE_ID->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_MEASURE_ID" name="x<?= $Grid->RowIndex ?>_MEASURE_ID" id="x<?= $Grid->RowIndex ?>_MEASURE_ID" size="30" placeholder="<?= HtmlEncode($Grid->MEASURE_ID->getPlaceHolder()) ?>" value="<?= $Grid->MEASURE_ID->EditValue ?>"<?= $Grid->MEASURE_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->MEASURE_ID->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_MEASURE_ID" class="form-group GOOD_GF_MEASURE_ID">
<span<?= $Grid->MEASURE_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->MEASURE_ID->getDisplayValue($Grid->MEASURE_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_MEASURE_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_MEASURE_ID" id="x<?= $Grid->RowIndex ?>_MEASURE_ID" value="<?= HtmlEncode($Grid->MEASURE_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_MEASURE_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_MEASURE_ID" id="o<?= $Grid->RowIndex ?>_MEASURE_ID" value="<?= HtmlEncode($Grid->MEASURE_ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->ALLOCATED_DATE->Visible) { // ALLOCATED_DATE ?>
        <td data-name="ALLOCATED_DATE">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_GOOD_GF_ALLOCATED_DATE" class="form-group GOOD_GF_ALLOCATED_DATE">
<input type="<?= $Grid->ALLOCATED_DATE->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_ALLOCATED_DATE" name="x<?= $Grid->RowIndex ?>_ALLOCATED_DATE" id="x<?= $Grid->RowIndex ?>_ALLOCATED_DATE" placeholder="<?= HtmlEncode($Grid->ALLOCATED_DATE->getPlaceHolder()) ?>" value="<?= $Grid->ALLOCATED_DATE->EditValue ?>"<?= $Grid->ALLOCATED_DATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ALLOCATED_DATE->getErrorMessage() ?></div>
<?php if (!$Grid->ALLOCATED_DATE->ReadOnly && !$Grid->ALLOCATED_DATE->Disabled && !isset($Grid->ALLOCATED_DATE->EditAttrs["readonly"]) && !isset($Grid->ALLOCATED_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fGOOD_GFgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fGOOD_GFgrid", "x<?= $Grid->RowIndex ?>_ALLOCATED_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_ALLOCATED_DATE" class="form-group GOOD_GF_ALLOCATED_DATE">
<span<?= $Grid->ALLOCATED_DATE->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->ALLOCATED_DATE->getDisplayValue($Grid->ALLOCATED_DATE->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_ALLOCATED_DATE" data-hidden="1" name="x<?= $Grid->RowIndex ?>_ALLOCATED_DATE" id="x<?= $Grid->RowIndex ?>_ALLOCATED_DATE" value="<?= HtmlEncode($Grid->ALLOCATED_DATE->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_ALLOCATED_DATE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ALLOCATED_DATE" id="o<?= $Grid->RowIndex ?>_ALLOCATED_DATE" value="<?= HtmlEncode($Grid->ALLOCATED_DATE->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->INVOICE_ID->Visible) { // INVOICE_ID ?>
        <td data-name="INVOICE_ID">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_GOOD_GF_INVOICE_ID" class="form-group GOOD_GF_INVOICE_ID">
<input type="<?= $Grid->INVOICE_ID->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_INVOICE_ID" name="x<?= $Grid->RowIndex ?>_INVOICE_ID" id="x<?= $Grid->RowIndex ?>_INVOICE_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->INVOICE_ID->getPlaceHolder()) ?>" value="<?= $Grid->INVOICE_ID->EditValue ?>"<?= $Grid->INVOICE_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->INVOICE_ID->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_INVOICE_ID" class="form-group GOOD_GF_INVOICE_ID">
<span<?= $Grid->INVOICE_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->INVOICE_ID->getDisplayValue($Grid->INVOICE_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_INVOICE_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_INVOICE_ID" id="x<?= $Grid->RowIndex ?>_INVOICE_ID" value="<?= HtmlEncode($Grid->INVOICE_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_INVOICE_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_INVOICE_ID" id="o<?= $Grid->RowIndex ?>_INVOICE_ID" value="<?= HtmlEncode($Grid->INVOICE_ID->OldValue) ?>">
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
    <?php if ($Grid->PRICE->Visible) { // PRICE ?>
        <td data-name="PRICE">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_GOOD_GF_PRICE" class="form-group GOOD_GF_PRICE">
<input type="<?= $Grid->PRICE->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_PRICE" name="x<?= $Grid->RowIndex ?>_PRICE" id="x<?= $Grid->RowIndex ?>_PRICE" size="30" placeholder="<?= HtmlEncode($Grid->PRICE->getPlaceHolder()) ?>" value="<?= $Grid->PRICE->EditValue ?>"<?= $Grid->PRICE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->PRICE->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_PRICE" class="form-group GOOD_GF_PRICE">
<span<?= $Grid->PRICE->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->PRICE->getDisplayValue($Grid->PRICE->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_PRICE" data-hidden="1" name="x<?= $Grid->RowIndex ?>_PRICE" id="x<?= $Grid->RowIndex ?>_PRICE" value="<?= HtmlEncode($Grid->PRICE->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_PRICE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_PRICE" id="o<?= $Grid->RowIndex ?>_PRICE" value="<?= HtmlEncode($Grid->PRICE->OldValue) ?>">
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
    <?php if ($Grid->DOC_NO->Visible) { // DOC_NO ?>
        <td data-name="DOC_NO">
<?php if (!$Grid->isConfirm()) { ?>
<?php if ($Grid->DOC_NO->getSessionValue() != "") { ?>
<span id="el$rowindex$_GOOD_GF_DOC_NO" class="form-group GOOD_GF_DOC_NO">
<span<?= $Grid->DOC_NO->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->DOC_NO->getDisplayValue($Grid->DOC_NO->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_DOC_NO" name="x<?= $Grid->RowIndex ?>_DOC_NO" value="<?= HtmlEncode($Grid->DOC_NO->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_DOC_NO" class="form-group GOOD_GF_DOC_NO">
<input type="<?= $Grid->DOC_NO->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_DOC_NO" name="x<?= $Grid->RowIndex ?>_DOC_NO" id="x<?= $Grid->RowIndex ?>_DOC_NO" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->DOC_NO->getPlaceHolder()) ?>" value="<?= $Grid->DOC_NO->EditValue ?>"<?= $Grid->DOC_NO->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->DOC_NO->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_DOC_NO" class="form-group GOOD_GF_DOC_NO">
<span<?= $Grid->DOC_NO->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->DOC_NO->getDisplayValue($Grid->DOC_NO->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_DOC_NO" data-hidden="1" name="x<?= $Grid->RowIndex ?>_DOC_NO" id="x<?= $Grid->RowIndex ?>_DOC_NO" value="<?= HtmlEncode($Grid->DOC_NO->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_DOC_NO" data-hidden="1" name="o<?= $Grid->RowIndex ?>_DOC_NO" id="o<?= $Grid->RowIndex ?>_DOC_NO" value="<?= HtmlEncode($Grid->DOC_NO->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->PRINT_DATE->Visible) { // PRINT_DATE ?>
        <td data-name="PRINT_DATE">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_GOOD_GF_PRINT_DATE" class="form-group GOOD_GF_PRINT_DATE">
<input type="<?= $Grid->PRINT_DATE->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_PRINT_DATE" name="x<?= $Grid->RowIndex ?>_PRINT_DATE" id="x<?= $Grid->RowIndex ?>_PRINT_DATE" placeholder="<?= HtmlEncode($Grid->PRINT_DATE->getPlaceHolder()) ?>" value="<?= $Grid->PRINT_DATE->EditValue ?>"<?= $Grid->PRINT_DATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->PRINT_DATE->getErrorMessage() ?></div>
<?php if (!$Grid->PRINT_DATE->ReadOnly && !$Grid->PRINT_DATE->Disabled && !isset($Grid->PRINT_DATE->EditAttrs["readonly"]) && !isset($Grid->PRINT_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fGOOD_GFgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fGOOD_GFgrid", "x<?= $Grid->RowIndex ?>_PRINT_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_PRINT_DATE" class="form-group GOOD_GF_PRINT_DATE">
<span<?= $Grid->PRINT_DATE->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->PRINT_DATE->getDisplayValue($Grid->PRINT_DATE->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_PRINT_DATE" data-hidden="1" name="x<?= $Grid->RowIndex ?>_PRINT_DATE" id="x<?= $Grid->RowIndex ?>_PRINT_DATE" value="<?= HtmlEncode($Grid->PRINT_DATE->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_PRINT_DATE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_PRINT_DATE" id="o<?= $Grid->RowIndex ?>_PRINT_DATE" value="<?= HtmlEncode($Grid->PRINT_DATE->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->PRINTED_BY->Visible) { // PRINTED_BY ?>
        <td data-name="PRINTED_BY">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_GOOD_GF_PRINTED_BY" class="form-group GOOD_GF_PRINTED_BY">
<input type="<?= $Grid->PRINTED_BY->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_PRINTED_BY" name="x<?= $Grid->RowIndex ?>_PRINTED_BY" id="x<?= $Grid->RowIndex ?>_PRINTED_BY" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->PRINTED_BY->getPlaceHolder()) ?>" value="<?= $Grid->PRINTED_BY->EditValue ?>"<?= $Grid->PRINTED_BY->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->PRINTED_BY->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_PRINTED_BY" class="form-group GOOD_GF_PRINTED_BY">
<span<?= $Grid->PRINTED_BY->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->PRINTED_BY->getDisplayValue($Grid->PRINTED_BY->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_PRINTED_BY" data-hidden="1" name="x<?= $Grid->RowIndex ?>_PRINTED_BY" id="x<?= $Grid->RowIndex ?>_PRINTED_BY" value="<?= HtmlEncode($Grid->PRINTED_BY->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_PRINTED_BY" data-hidden="1" name="o<?= $Grid->RowIndex ?>_PRINTED_BY" id="o<?= $Grid->RowIndex ?>_PRINTED_BY" value="<?= HtmlEncode($Grid->PRINTED_BY->OldValue) ?>">
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
