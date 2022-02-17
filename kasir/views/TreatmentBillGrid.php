<?php

namespace PHPMaker2021\SIMRSSQLSERVER;

// Set up and run Grid object
$Grid = Container("TreatmentBillGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fTREATMENT_BILLgrid;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    fTREATMENT_BILLgrid = new ew.Form("fTREATMENT_BILLgrid", "grid");
    fTREATMENT_BILLgrid.formKeyCountName = '<?= $Grid->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "TREATMENT_BILL")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.TREATMENT_BILL)
        ew.vars.tables.TREATMENT_BILL = currentTable;
    fTREATMENT_BILLgrid.addFields([
        ["NOTA_NO", [fields.NOTA_NO.visible && fields.NOTA_NO.required ? ew.Validators.required(fields.NOTA_NO.caption) : null], fields.NOTA_NO.isInvalid],
        ["TARIF_ID", [fields.TARIF_ID.visible && fields.TARIF_ID.required ? ew.Validators.required(fields.TARIF_ID.caption) : null], fields.TARIF_ID.isInvalid],
        ["CLINIC_ID", [fields.CLINIC_ID.visible && fields.CLINIC_ID.required ? ew.Validators.required(fields.CLINIC_ID.caption) : null], fields.CLINIC_ID.isInvalid],
        ["TREATMENT", [fields.TREATMENT.visible && fields.TREATMENT.required ? ew.Validators.required(fields.TREATMENT.caption) : null], fields.TREATMENT.isInvalid],
        ["TREAT_DATE", [fields.TREAT_DATE.visible && fields.TREAT_DATE.required ? ew.Validators.required(fields.TREAT_DATE.caption) : null, ew.Validators.datetime(11)], fields.TREAT_DATE.isInvalid],
        ["AMOUNT", [fields.AMOUNT.visible && fields.AMOUNT.required ? ew.Validators.required(fields.AMOUNT.caption) : null, ew.Validators.float], fields.AMOUNT.isInvalid],
        ["QUANTITY", [fields.QUANTITY.visible && fields.QUANTITY.required ? ew.Validators.required(fields.QUANTITY.caption) : null, ew.Validators.float], fields.QUANTITY.isInvalid],
        ["PAYMENT_DATE", [fields.PAYMENT_DATE.visible && fields.PAYMENT_DATE.required ? ew.Validators.required(fields.PAYMENT_DATE.caption) : null, ew.Validators.datetime(11)], fields.PAYMENT_DATE.isInvalid],
        ["ISLUNAS", [fields.ISLUNAS.visible && fields.ISLUNAS.required ? ew.Validators.required(fields.ISLUNAS.caption) : null], fields.ISLUNAS.isInvalid],
        ["EMPLOYEE_ID", [fields.EMPLOYEE_ID.visible && fields.EMPLOYEE_ID.required ? ew.Validators.required(fields.EMPLOYEE_ID.caption) : null], fields.EMPLOYEE_ID.isInvalid],
        ["amount_paid", [fields.amount_paid.visible && fields.amount_paid.required ? ew.Validators.required(fields.amount_paid.caption) : null, ew.Validators.float], fields.amount_paid.isInvalid],
        ["TRANS_ID", [fields.TRANS_ID.visible && fields.TRANS_ID.required ? ew.Validators.required(fields.TRANS_ID.caption) : null], fields.TRANS_ID.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fTREATMENT_BILLgrid,
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
    fTREATMENT_BILLgrid.validate = function () {
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
    fTREATMENT_BILLgrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm();
        if (ew.valueChanged(fobj, rowIndex, "NOTA_NO", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "TARIF_ID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "CLINIC_ID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "TREATMENT", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "TREAT_DATE", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "AMOUNT", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "QUANTITY", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "PAYMENT_DATE", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "ISLUNAS[]", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "EMPLOYEE_ID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "amount_paid", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "TRANS_ID", false))
            return false;
        return true;
    }

    // Form_CustomValidate
    fTREATMENT_BILLgrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fTREATMENT_BILLgrid.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fTREATMENT_BILLgrid.lists.TARIF_ID = <?= $Grid->TARIF_ID->toClientList($Grid) ?>;
    fTREATMENT_BILLgrid.lists.CLINIC_ID = <?= $Grid->CLINIC_ID->toClientList($Grid) ?>;
    fTREATMENT_BILLgrid.lists.ISLUNAS = <?= $Grid->ISLUNAS->toClientList($Grid) ?>;
    fTREATMENT_BILLgrid.lists.EMPLOYEE_ID = <?= $Grid->EMPLOYEE_ID->toClientList($Grid) ?>;
    loadjs.done("fTREATMENT_BILLgrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> TREATMENT_BILL">
<?php if ($Grid->ShowOtherOptions) { ?>
<div class="card-header ew-grid-upper-panel">
<?php $Grid->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="fTREATMENT_BILLgrid" class="ew-form ew-list-form form-inline">
<div id="gmp_TREATMENT_BILL" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_TREATMENT_BILLgrid" class="table ew-table"><!-- .ew-table -->
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
<?php if ($Grid->NOTA_NO->Visible) { // NOTA_NO ?>
        <th data-name="NOTA_NO" class="<?= $Grid->NOTA_NO->headerCellClass() ?>"><div id="elh_TREATMENT_BILL_NOTA_NO" class="TREATMENT_BILL_NOTA_NO"><?= $Grid->renderSort($Grid->NOTA_NO) ?></div></th>
<?php } ?>
<?php if ($Grid->TARIF_ID->Visible) { // TARIF_ID ?>
        <th data-name="TARIF_ID" class="<?= $Grid->TARIF_ID->headerCellClass() ?>"><div id="elh_TREATMENT_BILL_TARIF_ID" class="TREATMENT_BILL_TARIF_ID"><?= $Grid->renderSort($Grid->TARIF_ID) ?></div></th>
<?php } ?>
<?php if ($Grid->CLINIC_ID->Visible) { // CLINIC_ID ?>
        <th data-name="CLINIC_ID" class="<?= $Grid->CLINIC_ID->headerCellClass() ?>"><div id="elh_TREATMENT_BILL_CLINIC_ID" class="TREATMENT_BILL_CLINIC_ID"><?= $Grid->renderSort($Grid->CLINIC_ID) ?></div></th>
<?php } ?>
<?php if ($Grid->TREATMENT->Visible) { // TREATMENT ?>
        <th data-name="TREATMENT" class="<?= $Grid->TREATMENT->headerCellClass() ?>"><div id="elh_TREATMENT_BILL_TREATMENT" class="TREATMENT_BILL_TREATMENT"><?= $Grid->renderSort($Grid->TREATMENT) ?></div></th>
<?php } ?>
<?php if ($Grid->TREAT_DATE->Visible) { // TREAT_DATE ?>
        <th data-name="TREAT_DATE" class="<?= $Grid->TREAT_DATE->headerCellClass() ?>"><div id="elh_TREATMENT_BILL_TREAT_DATE" class="TREATMENT_BILL_TREAT_DATE"><?= $Grid->renderSort($Grid->TREAT_DATE) ?></div></th>
<?php } ?>
<?php if ($Grid->AMOUNT->Visible) { // AMOUNT ?>
        <th data-name="AMOUNT" class="<?= $Grid->AMOUNT->headerCellClass() ?>"><div id="elh_TREATMENT_BILL_AMOUNT" class="TREATMENT_BILL_AMOUNT"><?= $Grid->renderSort($Grid->AMOUNT) ?></div></th>
<?php } ?>
<?php if ($Grid->QUANTITY->Visible) { // QUANTITY ?>
        <th data-name="QUANTITY" class="<?= $Grid->QUANTITY->headerCellClass() ?>"><div id="elh_TREATMENT_BILL_QUANTITY" class="TREATMENT_BILL_QUANTITY"><?= $Grid->renderSort($Grid->QUANTITY) ?></div></th>
<?php } ?>
<?php if ($Grid->PAYMENT_DATE->Visible) { // PAYMENT_DATE ?>
        <th data-name="PAYMENT_DATE" class="<?= $Grid->PAYMENT_DATE->headerCellClass() ?>"><div id="elh_TREATMENT_BILL_PAYMENT_DATE" class="TREATMENT_BILL_PAYMENT_DATE"><?= $Grid->renderSort($Grid->PAYMENT_DATE) ?></div></th>
<?php } ?>
<?php if ($Grid->ISLUNAS->Visible) { // ISLUNAS ?>
        <th data-name="ISLUNAS" class="<?= $Grid->ISLUNAS->headerCellClass() ?>"><div id="elh_TREATMENT_BILL_ISLUNAS" class="TREATMENT_BILL_ISLUNAS"><?= $Grid->renderSort($Grid->ISLUNAS) ?></div></th>
<?php } ?>
<?php if ($Grid->EMPLOYEE_ID->Visible) { // EMPLOYEE_ID ?>
        <th data-name="EMPLOYEE_ID" class="<?= $Grid->EMPLOYEE_ID->headerCellClass() ?>"><div id="elh_TREATMENT_BILL_EMPLOYEE_ID" class="TREATMENT_BILL_EMPLOYEE_ID"><?= $Grid->renderSort($Grid->EMPLOYEE_ID) ?></div></th>
<?php } ?>
<?php if ($Grid->amount_paid->Visible) { // amount_paid ?>
        <th data-name="amount_paid" class="<?= $Grid->amount_paid->headerCellClass() ?>"><div id="elh_TREATMENT_BILL_amount_paid" class="TREATMENT_BILL_amount_paid"><?= $Grid->renderSort($Grid->amount_paid) ?></div></th>
<?php } ?>
<?php if ($Grid->TRANS_ID->Visible) { // TRANS_ID ?>
        <th data-name="TRANS_ID" class="<?= $Grid->TRANS_ID->headerCellClass() ?>"><div id="elh_TREATMENT_BILL_TRANS_ID" class="TREATMENT_BILL_TRANS_ID"><?= $Grid->renderSort($Grid->TRANS_ID) ?></div></th>
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowCount, "id" => "r" . $Grid->RowCount . "_TREATMENT_BILL", "data-rowtype" => $Grid->RowType]);

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
    <?php if ($Grid->NOTA_NO->Visible) { // NOTA_NO ?>
        <td data-name="NOTA_NO" <?= $Grid->NOTA_NO->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_BILL_NOTA_NO" class="form-group">
<input type="<?= $Grid->NOTA_NO->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_NOTA_NO" name="x<?= $Grid->RowIndex ?>_NOTA_NO" id="x<?= $Grid->RowIndex ?>_NOTA_NO" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->NOTA_NO->getPlaceHolder()) ?>" value="<?= $Grid->NOTA_NO->EditValue ?>"<?= $Grid->NOTA_NO->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->NOTA_NO->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="TREATMENT_BILL" data-field="x_NOTA_NO" data-hidden="1" name="o<?= $Grid->RowIndex ?>_NOTA_NO" id="o<?= $Grid->RowIndex ?>_NOTA_NO" value="<?= HtmlEncode($Grid->NOTA_NO->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_BILL_NOTA_NO" class="form-group">
<input type="<?= $Grid->NOTA_NO->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_NOTA_NO" name="x<?= $Grid->RowIndex ?>_NOTA_NO" id="x<?= $Grid->RowIndex ?>_NOTA_NO" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->NOTA_NO->getPlaceHolder()) ?>" value="<?= $Grid->NOTA_NO->EditValue ?>"<?= $Grid->NOTA_NO->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->NOTA_NO->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_BILL_NOTA_NO">
<span<?= $Grid->NOTA_NO->viewAttributes() ?>>
<?= $Grid->NOTA_NO->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="TREATMENT_BILL" data-field="x_NOTA_NO" data-hidden="1" name="fTREATMENT_BILLgrid$x<?= $Grid->RowIndex ?>_NOTA_NO" id="fTREATMENT_BILLgrid$x<?= $Grid->RowIndex ?>_NOTA_NO" value="<?= HtmlEncode($Grid->NOTA_NO->FormValue) ?>">
<input type="hidden" data-table="TREATMENT_BILL" data-field="x_NOTA_NO" data-hidden="1" name="fTREATMENT_BILLgrid$o<?= $Grid->RowIndex ?>_NOTA_NO" id="fTREATMENT_BILLgrid$o<?= $Grid->RowIndex ?>_NOTA_NO" value="<?= HtmlEncode($Grid->NOTA_NO->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->TARIF_ID->Visible) { // TARIF_ID ?>
        <td data-name="TARIF_ID" <?= $Grid->TARIF_ID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_BILL_TARIF_ID" class="form-group">
<?php $Grid->TARIF_ID->EditAttrs->prepend("onchange", "ew.autoFill(this);"); ?>
<div class="input-group ew-lookup-list">
    <div class="form-control ew-lookup-text" tabindex="-1" id="lu_x<?= $Grid->RowIndex ?>_TARIF_ID"><?= EmptyValue(strval($Grid->TARIF_ID->ViewValue)) ? $Language->phrase("PleaseSelect") : $Grid->TARIF_ID->ViewValue ?></div>
    <div class="input-group-append">
        <button type="button" title="<?= HtmlEncode(str_replace("%s", RemoveHtml($Grid->TARIF_ID->caption()), $Language->phrase("LookupLink", true))) ?>" class="ew-lookup-btn btn btn-default"<?= ($Grid->TARIF_ID->ReadOnly || $Grid->TARIF_ID->Disabled) ? " disabled" : "" ?> onclick="ew.modalLookupShow({lnk:this,el:'x<?= $Grid->RowIndex ?>_TARIF_ID',m:0,n:10});"><i class="fas fa-search ew-icon"></i></button>
    </div>
</div>
<div class="invalid-feedback"><?= $Grid->TARIF_ID->getErrorMessage() ?></div>
<?= $Grid->TARIF_ID->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_TARIF_ID") ?>
<input type="hidden" is="selection-list" data-table="TREATMENT_BILL" data-field="x_TARIF_ID" data-type="text" data-multiple="0" data-lookup="1" data-value-separator="<?= $Grid->TARIF_ID->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_TARIF_ID" id="x<?= $Grid->RowIndex ?>_TARIF_ID" value="<?= $Grid->TARIF_ID->CurrentValue ?>"<?= $Grid->TARIF_ID->editAttributes() ?>>
</span>
<input type="hidden" data-table="TREATMENT_BILL" data-field="x_TARIF_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_TARIF_ID" id="o<?= $Grid->RowIndex ?>_TARIF_ID" value="<?= HtmlEncode($Grid->TARIF_ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_BILL_TARIF_ID" class="form-group">
<?php $Grid->TARIF_ID->EditAttrs->prepend("onchange", "ew.autoFill(this);"); ?>
<div class="input-group ew-lookup-list">
    <div class="form-control ew-lookup-text" tabindex="-1" id="lu_x<?= $Grid->RowIndex ?>_TARIF_ID"><?= EmptyValue(strval($Grid->TARIF_ID->ViewValue)) ? $Language->phrase("PleaseSelect") : $Grid->TARIF_ID->ViewValue ?></div>
    <div class="input-group-append">
        <button type="button" title="<?= HtmlEncode(str_replace("%s", RemoveHtml($Grid->TARIF_ID->caption()), $Language->phrase("LookupLink", true))) ?>" class="ew-lookup-btn btn btn-default"<?= ($Grid->TARIF_ID->ReadOnly || $Grid->TARIF_ID->Disabled) ? " disabled" : "" ?> onclick="ew.modalLookupShow({lnk:this,el:'x<?= $Grid->RowIndex ?>_TARIF_ID',m:0,n:10});"><i class="fas fa-search ew-icon"></i></button>
    </div>
</div>
<div class="invalid-feedback"><?= $Grid->TARIF_ID->getErrorMessage() ?></div>
<?= $Grid->TARIF_ID->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_TARIF_ID") ?>
<input type="hidden" is="selection-list" data-table="TREATMENT_BILL" data-field="x_TARIF_ID" data-type="text" data-multiple="0" data-lookup="1" data-value-separator="<?= $Grid->TARIF_ID->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_TARIF_ID" id="x<?= $Grid->RowIndex ?>_TARIF_ID" value="<?= $Grid->TARIF_ID->CurrentValue ?>"<?= $Grid->TARIF_ID->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_BILL_TARIF_ID">
<span<?= $Grid->TARIF_ID->viewAttributes() ?>>
<?= $Grid->TARIF_ID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="TREATMENT_BILL" data-field="x_TARIF_ID" data-hidden="1" name="fTREATMENT_BILLgrid$x<?= $Grid->RowIndex ?>_TARIF_ID" id="fTREATMENT_BILLgrid$x<?= $Grid->RowIndex ?>_TARIF_ID" value="<?= HtmlEncode($Grid->TARIF_ID->FormValue) ?>">
<input type="hidden" data-table="TREATMENT_BILL" data-field="x_TARIF_ID" data-hidden="1" name="fTREATMENT_BILLgrid$o<?= $Grid->RowIndex ?>_TARIF_ID" id="fTREATMENT_BILLgrid$o<?= $Grid->RowIndex ?>_TARIF_ID" value="<?= HtmlEncode($Grid->TARIF_ID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->CLINIC_ID->Visible) { // CLINIC_ID ?>
        <td data-name="CLINIC_ID" <?= $Grid->CLINIC_ID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_BILL_CLINIC_ID" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_CLINIC_ID"
        name="x<?= $Grid->RowIndex ?>_CLINIC_ID"
        class="form-control ew-select<?= $Grid->CLINIC_ID->isInvalidClass() ?>"
        data-select2-id="TREATMENT_BILL_x<?= $Grid->RowIndex ?>_CLINIC_ID"
        data-table="TREATMENT_BILL"
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
    var el = document.querySelector("select[data-select2-id='TREATMENT_BILL_x<?= $Grid->RowIndex ?>_CLINIC_ID']"),
        options = { name: "x<?= $Grid->RowIndex ?>_CLINIC_ID", selectId: "TREATMENT_BILL_x<?= $Grid->RowIndex ?>_CLINIC_ID", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.TREATMENT_BILL.fields.CLINIC_ID.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="TREATMENT_BILL" data-field="x_CLINIC_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_CLINIC_ID" id="o<?= $Grid->RowIndex ?>_CLINIC_ID" value="<?= HtmlEncode($Grid->CLINIC_ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_BILL_CLINIC_ID" class="form-group">
<span<?= $Grid->CLINIC_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->CLINIC_ID->getDisplayValue($Grid->CLINIC_ID->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="TREATMENT_BILL" data-field="x_CLINIC_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_CLINIC_ID" id="x<?= $Grid->RowIndex ?>_CLINIC_ID" value="<?= HtmlEncode($Grid->CLINIC_ID->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_BILL_CLINIC_ID">
<span<?= $Grid->CLINIC_ID->viewAttributes() ?>>
<?= $Grid->CLINIC_ID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="TREATMENT_BILL" data-field="x_CLINIC_ID" data-hidden="1" name="fTREATMENT_BILLgrid$x<?= $Grid->RowIndex ?>_CLINIC_ID" id="fTREATMENT_BILLgrid$x<?= $Grid->RowIndex ?>_CLINIC_ID" value="<?= HtmlEncode($Grid->CLINIC_ID->FormValue) ?>">
<input type="hidden" data-table="TREATMENT_BILL" data-field="x_CLINIC_ID" data-hidden="1" name="fTREATMENT_BILLgrid$o<?= $Grid->RowIndex ?>_CLINIC_ID" id="fTREATMENT_BILLgrid$o<?= $Grid->RowIndex ?>_CLINIC_ID" value="<?= HtmlEncode($Grid->CLINIC_ID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->TREATMENT->Visible) { // TREATMENT ?>
        <td data-name="TREATMENT" <?= $Grid->TREATMENT->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_BILL_TREATMENT" class="form-group">
<input type="<?= $Grid->TREATMENT->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_TREATMENT" name="x<?= $Grid->RowIndex ?>_TREATMENT" id="x<?= $Grid->RowIndex ?>_TREATMENT" size="30" maxlength="200" placeholder="<?= HtmlEncode($Grid->TREATMENT->getPlaceHolder()) ?>" value="<?= $Grid->TREATMENT->EditValue ?>"<?= $Grid->TREATMENT->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->TREATMENT->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="TREATMENT_BILL" data-field="x_TREATMENT" data-hidden="1" name="o<?= $Grid->RowIndex ?>_TREATMENT" id="o<?= $Grid->RowIndex ?>_TREATMENT" value="<?= HtmlEncode($Grid->TREATMENT->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_BILL_TREATMENT" class="form-group">
<input type="<?= $Grid->TREATMENT->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_TREATMENT" name="x<?= $Grid->RowIndex ?>_TREATMENT" id="x<?= $Grid->RowIndex ?>_TREATMENT" size="30" maxlength="200" placeholder="<?= HtmlEncode($Grid->TREATMENT->getPlaceHolder()) ?>" value="<?= $Grid->TREATMENT->EditValue ?>"<?= $Grid->TREATMENT->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->TREATMENT->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_BILL_TREATMENT">
<span<?= $Grid->TREATMENT->viewAttributes() ?>>
<?= $Grid->TREATMENT->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="TREATMENT_BILL" data-field="x_TREATMENT" data-hidden="1" name="fTREATMENT_BILLgrid$x<?= $Grid->RowIndex ?>_TREATMENT" id="fTREATMENT_BILLgrid$x<?= $Grid->RowIndex ?>_TREATMENT" value="<?= HtmlEncode($Grid->TREATMENT->FormValue) ?>">
<input type="hidden" data-table="TREATMENT_BILL" data-field="x_TREATMENT" data-hidden="1" name="fTREATMENT_BILLgrid$o<?= $Grid->RowIndex ?>_TREATMENT" id="fTREATMENT_BILLgrid$o<?= $Grid->RowIndex ?>_TREATMENT" value="<?= HtmlEncode($Grid->TREATMENT->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->TREAT_DATE->Visible) { // TREAT_DATE ?>
        <td data-name="TREAT_DATE" <?= $Grid->TREAT_DATE->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_BILL_TREAT_DATE" class="form-group">
<input type="<?= $Grid->TREAT_DATE->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_TREAT_DATE" data-format="11" name="x<?= $Grid->RowIndex ?>_TREAT_DATE" id="x<?= $Grid->RowIndex ?>_TREAT_DATE" placeholder="<?= HtmlEncode($Grid->TREAT_DATE->getPlaceHolder()) ?>" value="<?= $Grid->TREAT_DATE->EditValue ?>"<?= $Grid->TREAT_DATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->TREAT_DATE->getErrorMessage() ?></div>
<?php if (!$Grid->TREAT_DATE->ReadOnly && !$Grid->TREAT_DATE->Disabled && !isset($Grid->TREAT_DATE->EditAttrs["readonly"]) && !isset($Grid->TREAT_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fTREATMENT_BILLgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fTREATMENT_BILLgrid", "x<?= $Grid->RowIndex ?>_TREAT_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":11});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="TREATMENT_BILL" data-field="x_TREAT_DATE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_TREAT_DATE" id="o<?= $Grid->RowIndex ?>_TREAT_DATE" value="<?= HtmlEncode($Grid->TREAT_DATE->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_BILL_TREAT_DATE" class="form-group">
<input type="<?= $Grid->TREAT_DATE->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_TREAT_DATE" data-format="11" name="x<?= $Grid->RowIndex ?>_TREAT_DATE" id="x<?= $Grid->RowIndex ?>_TREAT_DATE" placeholder="<?= HtmlEncode($Grid->TREAT_DATE->getPlaceHolder()) ?>" value="<?= $Grid->TREAT_DATE->EditValue ?>"<?= $Grid->TREAT_DATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->TREAT_DATE->getErrorMessage() ?></div>
<?php if (!$Grid->TREAT_DATE->ReadOnly && !$Grid->TREAT_DATE->Disabled && !isset($Grid->TREAT_DATE->EditAttrs["readonly"]) && !isset($Grid->TREAT_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fTREATMENT_BILLgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fTREATMENT_BILLgrid", "x<?= $Grid->RowIndex ?>_TREAT_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":11});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_BILL_TREAT_DATE">
<span<?= $Grid->TREAT_DATE->viewAttributes() ?>>
<?= $Grid->TREAT_DATE->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="TREATMENT_BILL" data-field="x_TREAT_DATE" data-hidden="1" name="fTREATMENT_BILLgrid$x<?= $Grid->RowIndex ?>_TREAT_DATE" id="fTREATMENT_BILLgrid$x<?= $Grid->RowIndex ?>_TREAT_DATE" value="<?= HtmlEncode($Grid->TREAT_DATE->FormValue) ?>">
<input type="hidden" data-table="TREATMENT_BILL" data-field="x_TREAT_DATE" data-hidden="1" name="fTREATMENT_BILLgrid$o<?= $Grid->RowIndex ?>_TREAT_DATE" id="fTREATMENT_BILLgrid$o<?= $Grid->RowIndex ?>_TREAT_DATE" value="<?= HtmlEncode($Grid->TREAT_DATE->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->AMOUNT->Visible) { // AMOUNT ?>
        <td data-name="AMOUNT" <?= $Grid->AMOUNT->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_BILL_AMOUNT" class="form-group">
<input type="<?= $Grid->AMOUNT->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_AMOUNT" name="x<?= $Grid->RowIndex ?>_AMOUNT" id="x<?= $Grid->RowIndex ?>_AMOUNT" size="30" placeholder="<?= HtmlEncode($Grid->AMOUNT->getPlaceHolder()) ?>" value="<?= $Grid->AMOUNT->EditValue ?>"<?= $Grid->AMOUNT->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->AMOUNT->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="TREATMENT_BILL" data-field="x_AMOUNT" data-hidden="1" name="o<?= $Grid->RowIndex ?>_AMOUNT" id="o<?= $Grid->RowIndex ?>_AMOUNT" value="<?= HtmlEncode($Grid->AMOUNT->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_BILL_AMOUNT" class="form-group">
<input type="<?= $Grid->AMOUNT->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_AMOUNT" name="x<?= $Grid->RowIndex ?>_AMOUNT" id="x<?= $Grid->RowIndex ?>_AMOUNT" size="30" placeholder="<?= HtmlEncode($Grid->AMOUNT->getPlaceHolder()) ?>" value="<?= $Grid->AMOUNT->EditValue ?>"<?= $Grid->AMOUNT->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->AMOUNT->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_BILL_AMOUNT">
<span<?= $Grid->AMOUNT->viewAttributes() ?>>
<?= $Grid->AMOUNT->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="TREATMENT_BILL" data-field="x_AMOUNT" data-hidden="1" name="fTREATMENT_BILLgrid$x<?= $Grid->RowIndex ?>_AMOUNT" id="fTREATMENT_BILLgrid$x<?= $Grid->RowIndex ?>_AMOUNT" value="<?= HtmlEncode($Grid->AMOUNT->FormValue) ?>">
<input type="hidden" data-table="TREATMENT_BILL" data-field="x_AMOUNT" data-hidden="1" name="fTREATMENT_BILLgrid$o<?= $Grid->RowIndex ?>_AMOUNT" id="fTREATMENT_BILLgrid$o<?= $Grid->RowIndex ?>_AMOUNT" value="<?= HtmlEncode($Grid->AMOUNT->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->QUANTITY->Visible) { // QUANTITY ?>
        <td data-name="QUANTITY" <?= $Grid->QUANTITY->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_BILL_QUANTITY" class="form-group">
<input type="<?= $Grid->QUANTITY->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_QUANTITY" name="x<?= $Grid->RowIndex ?>_QUANTITY" id="x<?= $Grid->RowIndex ?>_QUANTITY" size="30" placeholder="<?= HtmlEncode($Grid->QUANTITY->getPlaceHolder()) ?>" value="<?= $Grid->QUANTITY->EditValue ?>"<?= $Grid->QUANTITY->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->QUANTITY->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="TREATMENT_BILL" data-field="x_QUANTITY" data-hidden="1" name="o<?= $Grid->RowIndex ?>_QUANTITY" id="o<?= $Grid->RowIndex ?>_QUANTITY" value="<?= HtmlEncode($Grid->QUANTITY->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_BILL_QUANTITY" class="form-group">
<input type="<?= $Grid->QUANTITY->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_QUANTITY" name="x<?= $Grid->RowIndex ?>_QUANTITY" id="x<?= $Grid->RowIndex ?>_QUANTITY" size="30" placeholder="<?= HtmlEncode($Grid->QUANTITY->getPlaceHolder()) ?>" value="<?= $Grid->QUANTITY->EditValue ?>"<?= $Grid->QUANTITY->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->QUANTITY->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_BILL_QUANTITY">
<span<?= $Grid->QUANTITY->viewAttributes() ?>>
<?= $Grid->QUANTITY->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="TREATMENT_BILL" data-field="x_QUANTITY" data-hidden="1" name="fTREATMENT_BILLgrid$x<?= $Grid->RowIndex ?>_QUANTITY" id="fTREATMENT_BILLgrid$x<?= $Grid->RowIndex ?>_QUANTITY" value="<?= HtmlEncode($Grid->QUANTITY->FormValue) ?>">
<input type="hidden" data-table="TREATMENT_BILL" data-field="x_QUANTITY" data-hidden="1" name="fTREATMENT_BILLgrid$o<?= $Grid->RowIndex ?>_QUANTITY" id="fTREATMENT_BILLgrid$o<?= $Grid->RowIndex ?>_QUANTITY" value="<?= HtmlEncode($Grid->QUANTITY->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->PAYMENT_DATE->Visible) { // PAYMENT_DATE ?>
        <td data-name="PAYMENT_DATE" <?= $Grid->PAYMENT_DATE->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_BILL_PAYMENT_DATE" class="form-group">
<input type="<?= $Grid->PAYMENT_DATE->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_PAYMENT_DATE" data-format="11" name="x<?= $Grid->RowIndex ?>_PAYMENT_DATE" id="x<?= $Grid->RowIndex ?>_PAYMENT_DATE" placeholder="<?= HtmlEncode($Grid->PAYMENT_DATE->getPlaceHolder()) ?>" value="<?= $Grid->PAYMENT_DATE->EditValue ?>"<?= $Grid->PAYMENT_DATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->PAYMENT_DATE->getErrorMessage() ?></div>
<?php if (!$Grid->PAYMENT_DATE->ReadOnly && !$Grid->PAYMENT_DATE->Disabled && !isset($Grid->PAYMENT_DATE->EditAttrs["readonly"]) && !isset($Grid->PAYMENT_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fTREATMENT_BILLgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fTREATMENT_BILLgrid", "x<?= $Grid->RowIndex ?>_PAYMENT_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":11});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="TREATMENT_BILL" data-field="x_PAYMENT_DATE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_PAYMENT_DATE" id="o<?= $Grid->RowIndex ?>_PAYMENT_DATE" value="<?= HtmlEncode($Grid->PAYMENT_DATE->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_BILL_PAYMENT_DATE" class="form-group">
<input type="<?= $Grid->PAYMENT_DATE->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_PAYMENT_DATE" data-format="11" name="x<?= $Grid->RowIndex ?>_PAYMENT_DATE" id="x<?= $Grid->RowIndex ?>_PAYMENT_DATE" placeholder="<?= HtmlEncode($Grid->PAYMENT_DATE->getPlaceHolder()) ?>" value="<?= $Grid->PAYMENT_DATE->EditValue ?>"<?= $Grid->PAYMENT_DATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->PAYMENT_DATE->getErrorMessage() ?></div>
<?php if (!$Grid->PAYMENT_DATE->ReadOnly && !$Grid->PAYMENT_DATE->Disabled && !isset($Grid->PAYMENT_DATE->EditAttrs["readonly"]) && !isset($Grid->PAYMENT_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fTREATMENT_BILLgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fTREATMENT_BILLgrid", "x<?= $Grid->RowIndex ?>_PAYMENT_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":11});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_BILL_PAYMENT_DATE">
<span<?= $Grid->PAYMENT_DATE->viewAttributes() ?>>
<?= $Grid->PAYMENT_DATE->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="TREATMENT_BILL" data-field="x_PAYMENT_DATE" data-hidden="1" name="fTREATMENT_BILLgrid$x<?= $Grid->RowIndex ?>_PAYMENT_DATE" id="fTREATMENT_BILLgrid$x<?= $Grid->RowIndex ?>_PAYMENT_DATE" value="<?= HtmlEncode($Grid->PAYMENT_DATE->FormValue) ?>">
<input type="hidden" data-table="TREATMENT_BILL" data-field="x_PAYMENT_DATE" data-hidden="1" name="fTREATMENT_BILLgrid$o<?= $Grid->RowIndex ?>_PAYMENT_DATE" id="fTREATMENT_BILLgrid$o<?= $Grid->RowIndex ?>_PAYMENT_DATE" value="<?= HtmlEncode($Grid->PAYMENT_DATE->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->ISLUNAS->Visible) { // ISLUNAS ?>
        <td data-name="ISLUNAS" <?= $Grid->ISLUNAS->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_BILL_ISLUNAS" class="form-group">
<template id="tp_x<?= $Grid->RowIndex ?>_ISLUNAS">
    <div class="custom-control custom-checkbox">
        <input type="checkbox" class="custom-control-input" data-table="TREATMENT_BILL" data-field="x_ISLUNAS" name="x<?= $Grid->RowIndex ?>_ISLUNAS" id="x<?= $Grid->RowIndex ?>_ISLUNAS"<?= $Grid->ISLUNAS->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_ISLUNAS" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x<?= $Grid->RowIndex ?>_ISLUNAS[]"
    name="x<?= $Grid->RowIndex ?>_ISLUNAS[]"
    value="<?= HtmlEncode($Grid->ISLUNAS->CurrentValue) ?>"
    data-type="select-multiple"
    data-template="tp_x<?= $Grid->RowIndex ?>_ISLUNAS"
    data-target="dsl_x<?= $Grid->RowIndex ?>_ISLUNAS"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->ISLUNAS->isInvalidClass() ?>"
    data-table="TREATMENT_BILL"
    data-field="x_ISLUNAS"
    data-value-separator="<?= $Grid->ISLUNAS->displayValueSeparatorAttribute() ?>"
    <?= $Grid->ISLUNAS->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ISLUNAS->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="TREATMENT_BILL" data-field="x_ISLUNAS" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ISLUNAS[]" id="o<?= $Grid->RowIndex ?>_ISLUNAS[]" value="<?= HtmlEncode($Grid->ISLUNAS->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_BILL_ISLUNAS" class="form-group">
<template id="tp_x<?= $Grid->RowIndex ?>_ISLUNAS">
    <div class="custom-control custom-checkbox">
        <input type="checkbox" class="custom-control-input" data-table="TREATMENT_BILL" data-field="x_ISLUNAS" name="x<?= $Grid->RowIndex ?>_ISLUNAS" id="x<?= $Grid->RowIndex ?>_ISLUNAS"<?= $Grid->ISLUNAS->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_ISLUNAS" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x<?= $Grid->RowIndex ?>_ISLUNAS[]"
    name="x<?= $Grid->RowIndex ?>_ISLUNAS[]"
    value="<?= HtmlEncode($Grid->ISLUNAS->CurrentValue) ?>"
    data-type="select-multiple"
    data-template="tp_x<?= $Grid->RowIndex ?>_ISLUNAS"
    data-target="dsl_x<?= $Grid->RowIndex ?>_ISLUNAS"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->ISLUNAS->isInvalidClass() ?>"
    data-table="TREATMENT_BILL"
    data-field="x_ISLUNAS"
    data-value-separator="<?= $Grid->ISLUNAS->displayValueSeparatorAttribute() ?>"
    <?= $Grid->ISLUNAS->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ISLUNAS->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_BILL_ISLUNAS">
<span<?= $Grid->ISLUNAS->viewAttributes() ?>>
<?= $Grid->ISLUNAS->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="TREATMENT_BILL" data-field="x_ISLUNAS" data-hidden="1" name="fTREATMENT_BILLgrid$x<?= $Grid->RowIndex ?>_ISLUNAS" id="fTREATMENT_BILLgrid$x<?= $Grid->RowIndex ?>_ISLUNAS" value="<?= HtmlEncode($Grid->ISLUNAS->FormValue) ?>">
<input type="hidden" data-table="TREATMENT_BILL" data-field="x_ISLUNAS" data-hidden="1" name="fTREATMENT_BILLgrid$o<?= $Grid->RowIndex ?>_ISLUNAS[]" id="fTREATMENT_BILLgrid$o<?= $Grid->RowIndex ?>_ISLUNAS[]" value="<?= HtmlEncode($Grid->ISLUNAS->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->EMPLOYEE_ID->Visible) { // EMPLOYEE_ID ?>
        <td data-name="EMPLOYEE_ID" <?= $Grid->EMPLOYEE_ID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_BILL_EMPLOYEE_ID" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_EMPLOYEE_ID"
        name="x<?= $Grid->RowIndex ?>_EMPLOYEE_ID"
        class="form-control ew-select<?= $Grid->EMPLOYEE_ID->isInvalidClass() ?>"
        data-select2-id="TREATMENT_BILL_x<?= $Grid->RowIndex ?>_EMPLOYEE_ID"
        data-table="TREATMENT_BILL"
        data-field="x_EMPLOYEE_ID"
        data-value-separator="<?= $Grid->EMPLOYEE_ID->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->EMPLOYEE_ID->getPlaceHolder()) ?>"
        <?= $Grid->EMPLOYEE_ID->editAttributes() ?>>
        <?= $Grid->EMPLOYEE_ID->selectOptionListHtml("x{$Grid->RowIndex}_EMPLOYEE_ID") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->EMPLOYEE_ID->getErrorMessage() ?></div>
<?= $Grid->EMPLOYEE_ID->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_EMPLOYEE_ID") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='TREATMENT_BILL_x<?= $Grid->RowIndex ?>_EMPLOYEE_ID']"),
        options = { name: "x<?= $Grid->RowIndex ?>_EMPLOYEE_ID", selectId: "TREATMENT_BILL_x<?= $Grid->RowIndex ?>_EMPLOYEE_ID", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.TREATMENT_BILL.fields.EMPLOYEE_ID.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="TREATMENT_BILL" data-field="x_EMPLOYEE_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_EMPLOYEE_ID" id="o<?= $Grid->RowIndex ?>_EMPLOYEE_ID" value="<?= HtmlEncode($Grid->EMPLOYEE_ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_BILL_EMPLOYEE_ID" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_EMPLOYEE_ID"
        name="x<?= $Grid->RowIndex ?>_EMPLOYEE_ID"
        class="form-control ew-select<?= $Grid->EMPLOYEE_ID->isInvalidClass() ?>"
        data-select2-id="TREATMENT_BILL_x<?= $Grid->RowIndex ?>_EMPLOYEE_ID"
        data-table="TREATMENT_BILL"
        data-field="x_EMPLOYEE_ID"
        data-value-separator="<?= $Grid->EMPLOYEE_ID->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->EMPLOYEE_ID->getPlaceHolder()) ?>"
        <?= $Grid->EMPLOYEE_ID->editAttributes() ?>>
        <?= $Grid->EMPLOYEE_ID->selectOptionListHtml("x{$Grid->RowIndex}_EMPLOYEE_ID") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->EMPLOYEE_ID->getErrorMessage() ?></div>
<?= $Grid->EMPLOYEE_ID->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_EMPLOYEE_ID") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='TREATMENT_BILL_x<?= $Grid->RowIndex ?>_EMPLOYEE_ID']"),
        options = { name: "x<?= $Grid->RowIndex ?>_EMPLOYEE_ID", selectId: "TREATMENT_BILL_x<?= $Grid->RowIndex ?>_EMPLOYEE_ID", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.TREATMENT_BILL.fields.EMPLOYEE_ID.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_BILL_EMPLOYEE_ID">
<span<?= $Grid->EMPLOYEE_ID->viewAttributes() ?>>
<?= $Grid->EMPLOYEE_ID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="TREATMENT_BILL" data-field="x_EMPLOYEE_ID" data-hidden="1" name="fTREATMENT_BILLgrid$x<?= $Grid->RowIndex ?>_EMPLOYEE_ID" id="fTREATMENT_BILLgrid$x<?= $Grid->RowIndex ?>_EMPLOYEE_ID" value="<?= HtmlEncode($Grid->EMPLOYEE_ID->FormValue) ?>">
<input type="hidden" data-table="TREATMENT_BILL" data-field="x_EMPLOYEE_ID" data-hidden="1" name="fTREATMENT_BILLgrid$o<?= $Grid->RowIndex ?>_EMPLOYEE_ID" id="fTREATMENT_BILLgrid$o<?= $Grid->RowIndex ?>_EMPLOYEE_ID" value="<?= HtmlEncode($Grid->EMPLOYEE_ID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->amount_paid->Visible) { // amount_paid ?>
        <td data-name="amount_paid" <?= $Grid->amount_paid->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_BILL_amount_paid" class="form-group">
<input type="<?= $Grid->amount_paid->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_amount_paid" name="x<?= $Grid->RowIndex ?>_amount_paid" id="x<?= $Grid->RowIndex ?>_amount_paid" size="30" placeholder="<?= HtmlEncode($Grid->amount_paid->getPlaceHolder()) ?>" value="<?= $Grid->amount_paid->EditValue ?>"<?= $Grid->amount_paid->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->amount_paid->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="TREATMENT_BILL" data-field="x_amount_paid" data-hidden="1" name="o<?= $Grid->RowIndex ?>_amount_paid" id="o<?= $Grid->RowIndex ?>_amount_paid" value="<?= HtmlEncode($Grid->amount_paid->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_BILL_amount_paid" class="form-group">
<input type="<?= $Grid->amount_paid->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_amount_paid" name="x<?= $Grid->RowIndex ?>_amount_paid" id="x<?= $Grid->RowIndex ?>_amount_paid" size="30" placeholder="<?= HtmlEncode($Grid->amount_paid->getPlaceHolder()) ?>" value="<?= $Grid->amount_paid->EditValue ?>"<?= $Grid->amount_paid->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->amount_paid->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_BILL_amount_paid">
<span<?= $Grid->amount_paid->viewAttributes() ?>>
<?= $Grid->amount_paid->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="TREATMENT_BILL" data-field="x_amount_paid" data-hidden="1" name="fTREATMENT_BILLgrid$x<?= $Grid->RowIndex ?>_amount_paid" id="fTREATMENT_BILLgrid$x<?= $Grid->RowIndex ?>_amount_paid" value="<?= HtmlEncode($Grid->amount_paid->FormValue) ?>">
<input type="hidden" data-table="TREATMENT_BILL" data-field="x_amount_paid" data-hidden="1" name="fTREATMENT_BILLgrid$o<?= $Grid->RowIndex ?>_amount_paid" id="fTREATMENT_BILLgrid$o<?= $Grid->RowIndex ?>_amount_paid" value="<?= HtmlEncode($Grid->amount_paid->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->TRANS_ID->Visible) { // TRANS_ID ?>
        <td data-name="TRANS_ID" <?= $Grid->TRANS_ID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_BILL_TRANS_ID" class="form-group">
<input type="<?= $Grid->TRANS_ID->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_TRANS_ID" name="x<?= $Grid->RowIndex ?>_TRANS_ID" id="x<?= $Grid->RowIndex ?>_TRANS_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->TRANS_ID->getPlaceHolder()) ?>" value="<?= $Grid->TRANS_ID->EditValue ?>"<?= $Grid->TRANS_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->TRANS_ID->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="TREATMENT_BILL" data-field="x_TRANS_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_TRANS_ID" id="o<?= $Grid->RowIndex ?>_TRANS_ID" value="<?= HtmlEncode($Grid->TRANS_ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_BILL_TRANS_ID" class="form-group">
<input type="<?= $Grid->TRANS_ID->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_TRANS_ID" name="x<?= $Grid->RowIndex ?>_TRANS_ID" id="x<?= $Grid->RowIndex ?>_TRANS_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->TRANS_ID->getPlaceHolder()) ?>" value="<?= $Grid->TRANS_ID->EditValue ?>"<?= $Grid->TRANS_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->TRANS_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_BILL_TRANS_ID">
<span<?= $Grid->TRANS_ID->viewAttributes() ?>>
<?= $Grid->TRANS_ID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="TREATMENT_BILL" data-field="x_TRANS_ID" data-hidden="1" name="fTREATMENT_BILLgrid$x<?= $Grid->RowIndex ?>_TRANS_ID" id="fTREATMENT_BILLgrid$x<?= $Grid->RowIndex ?>_TRANS_ID" value="<?= HtmlEncode($Grid->TRANS_ID->FormValue) ?>">
<input type="hidden" data-table="TREATMENT_BILL" data-field="x_TRANS_ID" data-hidden="1" name="fTREATMENT_BILLgrid$o<?= $Grid->RowIndex ?>_TRANS_ID" id="fTREATMENT_BILLgrid$o<?= $Grid->RowIndex ?>_TRANS_ID" value="<?= HtmlEncode($Grid->TRANS_ID->OldValue) ?>">
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
loadjs.ready(["fTREATMENT_BILLgrid","load"], function () {
    fTREATMENT_BILLgrid.updateLists(<?= $Grid->RowIndex ?>);
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_TREATMENT_BILL", "data-rowtype" => ROWTYPE_ADD]);
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
    <?php if ($Grid->NOTA_NO->Visible) { // NOTA_NO ?>
        <td data-name="NOTA_NO">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_TREATMENT_BILL_NOTA_NO" class="form-group TREATMENT_BILL_NOTA_NO">
<input type="<?= $Grid->NOTA_NO->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_NOTA_NO" name="x<?= $Grid->RowIndex ?>_NOTA_NO" id="x<?= $Grid->RowIndex ?>_NOTA_NO" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->NOTA_NO->getPlaceHolder()) ?>" value="<?= $Grid->NOTA_NO->EditValue ?>"<?= $Grid->NOTA_NO->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->NOTA_NO->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_TREATMENT_BILL_NOTA_NO" class="form-group TREATMENT_BILL_NOTA_NO">
<span<?= $Grid->NOTA_NO->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->NOTA_NO->getDisplayValue($Grid->NOTA_NO->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="TREATMENT_BILL" data-field="x_NOTA_NO" data-hidden="1" name="x<?= $Grid->RowIndex ?>_NOTA_NO" id="x<?= $Grid->RowIndex ?>_NOTA_NO" value="<?= HtmlEncode($Grid->NOTA_NO->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="TREATMENT_BILL" data-field="x_NOTA_NO" data-hidden="1" name="o<?= $Grid->RowIndex ?>_NOTA_NO" id="o<?= $Grid->RowIndex ?>_NOTA_NO" value="<?= HtmlEncode($Grid->NOTA_NO->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->TARIF_ID->Visible) { // TARIF_ID ?>
        <td data-name="TARIF_ID">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_TREATMENT_BILL_TARIF_ID" class="form-group TREATMENT_BILL_TARIF_ID">
<?php $Grid->TARIF_ID->EditAttrs->prepend("onchange", "ew.autoFill(this);"); ?>
<div class="input-group ew-lookup-list">
    <div class="form-control ew-lookup-text" tabindex="-1" id="lu_x<?= $Grid->RowIndex ?>_TARIF_ID"><?= EmptyValue(strval($Grid->TARIF_ID->ViewValue)) ? $Language->phrase("PleaseSelect") : $Grid->TARIF_ID->ViewValue ?></div>
    <div class="input-group-append">
        <button type="button" title="<?= HtmlEncode(str_replace("%s", RemoveHtml($Grid->TARIF_ID->caption()), $Language->phrase("LookupLink", true))) ?>" class="ew-lookup-btn btn btn-default"<?= ($Grid->TARIF_ID->ReadOnly || $Grid->TARIF_ID->Disabled) ? " disabled" : "" ?> onclick="ew.modalLookupShow({lnk:this,el:'x<?= $Grid->RowIndex ?>_TARIF_ID',m:0,n:10});"><i class="fas fa-search ew-icon"></i></button>
    </div>
</div>
<div class="invalid-feedback"><?= $Grid->TARIF_ID->getErrorMessage() ?></div>
<?= $Grid->TARIF_ID->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_TARIF_ID") ?>
<input type="hidden" is="selection-list" data-table="TREATMENT_BILL" data-field="x_TARIF_ID" data-type="text" data-multiple="0" data-lookup="1" data-value-separator="<?= $Grid->TARIF_ID->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_TARIF_ID" id="x<?= $Grid->RowIndex ?>_TARIF_ID" value="<?= $Grid->TARIF_ID->CurrentValue ?>"<?= $Grid->TARIF_ID->editAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_TREATMENT_BILL_TARIF_ID" class="form-group TREATMENT_BILL_TARIF_ID">
<span<?= $Grid->TARIF_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->TARIF_ID->getDisplayValue($Grid->TARIF_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="TREATMENT_BILL" data-field="x_TARIF_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_TARIF_ID" id="x<?= $Grid->RowIndex ?>_TARIF_ID" value="<?= HtmlEncode($Grid->TARIF_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="TREATMENT_BILL" data-field="x_TARIF_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_TARIF_ID" id="o<?= $Grid->RowIndex ?>_TARIF_ID" value="<?= HtmlEncode($Grid->TARIF_ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->CLINIC_ID->Visible) { // CLINIC_ID ?>
        <td data-name="CLINIC_ID">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_TREATMENT_BILL_CLINIC_ID" class="form-group TREATMENT_BILL_CLINIC_ID">
    <select
        id="x<?= $Grid->RowIndex ?>_CLINIC_ID"
        name="x<?= $Grid->RowIndex ?>_CLINIC_ID"
        class="form-control ew-select<?= $Grid->CLINIC_ID->isInvalidClass() ?>"
        data-select2-id="TREATMENT_BILL_x<?= $Grid->RowIndex ?>_CLINIC_ID"
        data-table="TREATMENT_BILL"
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
    var el = document.querySelector("select[data-select2-id='TREATMENT_BILL_x<?= $Grid->RowIndex ?>_CLINIC_ID']"),
        options = { name: "x<?= $Grid->RowIndex ?>_CLINIC_ID", selectId: "TREATMENT_BILL_x<?= $Grid->RowIndex ?>_CLINIC_ID", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.TREATMENT_BILL.fields.CLINIC_ID.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_TREATMENT_BILL_CLINIC_ID" class="form-group TREATMENT_BILL_CLINIC_ID">
<span<?= $Grid->CLINIC_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->CLINIC_ID->getDisplayValue($Grid->CLINIC_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="TREATMENT_BILL" data-field="x_CLINIC_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_CLINIC_ID" id="x<?= $Grid->RowIndex ?>_CLINIC_ID" value="<?= HtmlEncode($Grid->CLINIC_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="TREATMENT_BILL" data-field="x_CLINIC_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_CLINIC_ID" id="o<?= $Grid->RowIndex ?>_CLINIC_ID" value="<?= HtmlEncode($Grid->CLINIC_ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->TREATMENT->Visible) { // TREATMENT ?>
        <td data-name="TREATMENT">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_TREATMENT_BILL_TREATMENT" class="form-group TREATMENT_BILL_TREATMENT">
<input type="<?= $Grid->TREATMENT->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_TREATMENT" name="x<?= $Grid->RowIndex ?>_TREATMENT" id="x<?= $Grid->RowIndex ?>_TREATMENT" size="30" maxlength="200" placeholder="<?= HtmlEncode($Grid->TREATMENT->getPlaceHolder()) ?>" value="<?= $Grid->TREATMENT->EditValue ?>"<?= $Grid->TREATMENT->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->TREATMENT->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_TREATMENT_BILL_TREATMENT" class="form-group TREATMENT_BILL_TREATMENT">
<span<?= $Grid->TREATMENT->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->TREATMENT->getDisplayValue($Grid->TREATMENT->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="TREATMENT_BILL" data-field="x_TREATMENT" data-hidden="1" name="x<?= $Grid->RowIndex ?>_TREATMENT" id="x<?= $Grid->RowIndex ?>_TREATMENT" value="<?= HtmlEncode($Grid->TREATMENT->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="TREATMENT_BILL" data-field="x_TREATMENT" data-hidden="1" name="o<?= $Grid->RowIndex ?>_TREATMENT" id="o<?= $Grid->RowIndex ?>_TREATMENT" value="<?= HtmlEncode($Grid->TREATMENT->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->TREAT_DATE->Visible) { // TREAT_DATE ?>
        <td data-name="TREAT_DATE">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_TREATMENT_BILL_TREAT_DATE" class="form-group TREATMENT_BILL_TREAT_DATE">
<input type="<?= $Grid->TREAT_DATE->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_TREAT_DATE" data-format="11" name="x<?= $Grid->RowIndex ?>_TREAT_DATE" id="x<?= $Grid->RowIndex ?>_TREAT_DATE" placeholder="<?= HtmlEncode($Grid->TREAT_DATE->getPlaceHolder()) ?>" value="<?= $Grid->TREAT_DATE->EditValue ?>"<?= $Grid->TREAT_DATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->TREAT_DATE->getErrorMessage() ?></div>
<?php if (!$Grid->TREAT_DATE->ReadOnly && !$Grid->TREAT_DATE->Disabled && !isset($Grid->TREAT_DATE->EditAttrs["readonly"]) && !isset($Grid->TREAT_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fTREATMENT_BILLgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fTREATMENT_BILLgrid", "x<?= $Grid->RowIndex ?>_TREAT_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":11});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_TREATMENT_BILL_TREAT_DATE" class="form-group TREATMENT_BILL_TREAT_DATE">
<span<?= $Grid->TREAT_DATE->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->TREAT_DATE->getDisplayValue($Grid->TREAT_DATE->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="TREATMENT_BILL" data-field="x_TREAT_DATE" data-hidden="1" name="x<?= $Grid->RowIndex ?>_TREAT_DATE" id="x<?= $Grid->RowIndex ?>_TREAT_DATE" value="<?= HtmlEncode($Grid->TREAT_DATE->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="TREATMENT_BILL" data-field="x_TREAT_DATE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_TREAT_DATE" id="o<?= $Grid->RowIndex ?>_TREAT_DATE" value="<?= HtmlEncode($Grid->TREAT_DATE->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->AMOUNT->Visible) { // AMOUNT ?>
        <td data-name="AMOUNT">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_TREATMENT_BILL_AMOUNT" class="form-group TREATMENT_BILL_AMOUNT">
<input type="<?= $Grid->AMOUNT->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_AMOUNT" name="x<?= $Grid->RowIndex ?>_AMOUNT" id="x<?= $Grid->RowIndex ?>_AMOUNT" size="30" placeholder="<?= HtmlEncode($Grid->AMOUNT->getPlaceHolder()) ?>" value="<?= $Grid->AMOUNT->EditValue ?>"<?= $Grid->AMOUNT->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->AMOUNT->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_TREATMENT_BILL_AMOUNT" class="form-group TREATMENT_BILL_AMOUNT">
<span<?= $Grid->AMOUNT->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->AMOUNT->getDisplayValue($Grid->AMOUNT->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="TREATMENT_BILL" data-field="x_AMOUNT" data-hidden="1" name="x<?= $Grid->RowIndex ?>_AMOUNT" id="x<?= $Grid->RowIndex ?>_AMOUNT" value="<?= HtmlEncode($Grid->AMOUNT->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="TREATMENT_BILL" data-field="x_AMOUNT" data-hidden="1" name="o<?= $Grid->RowIndex ?>_AMOUNT" id="o<?= $Grid->RowIndex ?>_AMOUNT" value="<?= HtmlEncode($Grid->AMOUNT->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->QUANTITY->Visible) { // QUANTITY ?>
        <td data-name="QUANTITY">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_TREATMENT_BILL_QUANTITY" class="form-group TREATMENT_BILL_QUANTITY">
<input type="<?= $Grid->QUANTITY->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_QUANTITY" name="x<?= $Grid->RowIndex ?>_QUANTITY" id="x<?= $Grid->RowIndex ?>_QUANTITY" size="30" placeholder="<?= HtmlEncode($Grid->QUANTITY->getPlaceHolder()) ?>" value="<?= $Grid->QUANTITY->EditValue ?>"<?= $Grid->QUANTITY->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->QUANTITY->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_TREATMENT_BILL_QUANTITY" class="form-group TREATMENT_BILL_QUANTITY">
<span<?= $Grid->QUANTITY->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->QUANTITY->getDisplayValue($Grid->QUANTITY->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="TREATMENT_BILL" data-field="x_QUANTITY" data-hidden="1" name="x<?= $Grid->RowIndex ?>_QUANTITY" id="x<?= $Grid->RowIndex ?>_QUANTITY" value="<?= HtmlEncode($Grid->QUANTITY->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="TREATMENT_BILL" data-field="x_QUANTITY" data-hidden="1" name="o<?= $Grid->RowIndex ?>_QUANTITY" id="o<?= $Grid->RowIndex ?>_QUANTITY" value="<?= HtmlEncode($Grid->QUANTITY->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->PAYMENT_DATE->Visible) { // PAYMENT_DATE ?>
        <td data-name="PAYMENT_DATE">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_TREATMENT_BILL_PAYMENT_DATE" class="form-group TREATMENT_BILL_PAYMENT_DATE">
<input type="<?= $Grid->PAYMENT_DATE->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_PAYMENT_DATE" data-format="11" name="x<?= $Grid->RowIndex ?>_PAYMENT_DATE" id="x<?= $Grid->RowIndex ?>_PAYMENT_DATE" placeholder="<?= HtmlEncode($Grid->PAYMENT_DATE->getPlaceHolder()) ?>" value="<?= $Grid->PAYMENT_DATE->EditValue ?>"<?= $Grid->PAYMENT_DATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->PAYMENT_DATE->getErrorMessage() ?></div>
<?php if (!$Grid->PAYMENT_DATE->ReadOnly && !$Grid->PAYMENT_DATE->Disabled && !isset($Grid->PAYMENT_DATE->EditAttrs["readonly"]) && !isset($Grid->PAYMENT_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fTREATMENT_BILLgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fTREATMENT_BILLgrid", "x<?= $Grid->RowIndex ?>_PAYMENT_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":11});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_TREATMENT_BILL_PAYMENT_DATE" class="form-group TREATMENT_BILL_PAYMENT_DATE">
<span<?= $Grid->PAYMENT_DATE->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->PAYMENT_DATE->getDisplayValue($Grid->PAYMENT_DATE->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="TREATMENT_BILL" data-field="x_PAYMENT_DATE" data-hidden="1" name="x<?= $Grid->RowIndex ?>_PAYMENT_DATE" id="x<?= $Grid->RowIndex ?>_PAYMENT_DATE" value="<?= HtmlEncode($Grid->PAYMENT_DATE->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="TREATMENT_BILL" data-field="x_PAYMENT_DATE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_PAYMENT_DATE" id="o<?= $Grid->RowIndex ?>_PAYMENT_DATE" value="<?= HtmlEncode($Grid->PAYMENT_DATE->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->ISLUNAS->Visible) { // ISLUNAS ?>
        <td data-name="ISLUNAS">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_TREATMENT_BILL_ISLUNAS" class="form-group TREATMENT_BILL_ISLUNAS">
<template id="tp_x<?= $Grid->RowIndex ?>_ISLUNAS">
    <div class="custom-control custom-checkbox">
        <input type="checkbox" class="custom-control-input" data-table="TREATMENT_BILL" data-field="x_ISLUNAS" name="x<?= $Grid->RowIndex ?>_ISLUNAS" id="x<?= $Grid->RowIndex ?>_ISLUNAS"<?= $Grid->ISLUNAS->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_ISLUNAS" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x<?= $Grid->RowIndex ?>_ISLUNAS[]"
    name="x<?= $Grid->RowIndex ?>_ISLUNAS[]"
    value="<?= HtmlEncode($Grid->ISLUNAS->CurrentValue) ?>"
    data-type="select-multiple"
    data-template="tp_x<?= $Grid->RowIndex ?>_ISLUNAS"
    data-target="dsl_x<?= $Grid->RowIndex ?>_ISLUNAS"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->ISLUNAS->isInvalidClass() ?>"
    data-table="TREATMENT_BILL"
    data-field="x_ISLUNAS"
    data-value-separator="<?= $Grid->ISLUNAS->displayValueSeparatorAttribute() ?>"
    <?= $Grid->ISLUNAS->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ISLUNAS->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_TREATMENT_BILL_ISLUNAS" class="form-group TREATMENT_BILL_ISLUNAS">
<span<?= $Grid->ISLUNAS->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->ISLUNAS->getDisplayValue($Grid->ISLUNAS->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="TREATMENT_BILL" data-field="x_ISLUNAS" data-hidden="1" name="x<?= $Grid->RowIndex ?>_ISLUNAS" id="x<?= $Grid->RowIndex ?>_ISLUNAS" value="<?= HtmlEncode($Grid->ISLUNAS->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="TREATMENT_BILL" data-field="x_ISLUNAS" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ISLUNAS[]" id="o<?= $Grid->RowIndex ?>_ISLUNAS[]" value="<?= HtmlEncode($Grid->ISLUNAS->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->EMPLOYEE_ID->Visible) { // EMPLOYEE_ID ?>
        <td data-name="EMPLOYEE_ID">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_TREATMENT_BILL_EMPLOYEE_ID" class="form-group TREATMENT_BILL_EMPLOYEE_ID">
    <select
        id="x<?= $Grid->RowIndex ?>_EMPLOYEE_ID"
        name="x<?= $Grid->RowIndex ?>_EMPLOYEE_ID"
        class="form-control ew-select<?= $Grid->EMPLOYEE_ID->isInvalidClass() ?>"
        data-select2-id="TREATMENT_BILL_x<?= $Grid->RowIndex ?>_EMPLOYEE_ID"
        data-table="TREATMENT_BILL"
        data-field="x_EMPLOYEE_ID"
        data-value-separator="<?= $Grid->EMPLOYEE_ID->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->EMPLOYEE_ID->getPlaceHolder()) ?>"
        <?= $Grid->EMPLOYEE_ID->editAttributes() ?>>
        <?= $Grid->EMPLOYEE_ID->selectOptionListHtml("x{$Grid->RowIndex}_EMPLOYEE_ID") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->EMPLOYEE_ID->getErrorMessage() ?></div>
<?= $Grid->EMPLOYEE_ID->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_EMPLOYEE_ID") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='TREATMENT_BILL_x<?= $Grid->RowIndex ?>_EMPLOYEE_ID']"),
        options = { name: "x<?= $Grid->RowIndex ?>_EMPLOYEE_ID", selectId: "TREATMENT_BILL_x<?= $Grid->RowIndex ?>_EMPLOYEE_ID", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.TREATMENT_BILL.fields.EMPLOYEE_ID.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_TREATMENT_BILL_EMPLOYEE_ID" class="form-group TREATMENT_BILL_EMPLOYEE_ID">
<span<?= $Grid->EMPLOYEE_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->EMPLOYEE_ID->getDisplayValue($Grid->EMPLOYEE_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="TREATMENT_BILL" data-field="x_EMPLOYEE_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_EMPLOYEE_ID" id="x<?= $Grid->RowIndex ?>_EMPLOYEE_ID" value="<?= HtmlEncode($Grid->EMPLOYEE_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="TREATMENT_BILL" data-field="x_EMPLOYEE_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_EMPLOYEE_ID" id="o<?= $Grid->RowIndex ?>_EMPLOYEE_ID" value="<?= HtmlEncode($Grid->EMPLOYEE_ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->amount_paid->Visible) { // amount_paid ?>
        <td data-name="amount_paid">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_TREATMENT_BILL_amount_paid" class="form-group TREATMENT_BILL_amount_paid">
<input type="<?= $Grid->amount_paid->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_amount_paid" name="x<?= $Grid->RowIndex ?>_amount_paid" id="x<?= $Grid->RowIndex ?>_amount_paid" size="30" placeholder="<?= HtmlEncode($Grid->amount_paid->getPlaceHolder()) ?>" value="<?= $Grid->amount_paid->EditValue ?>"<?= $Grid->amount_paid->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->amount_paid->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_TREATMENT_BILL_amount_paid" class="form-group TREATMENT_BILL_amount_paid">
<span<?= $Grid->amount_paid->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->amount_paid->getDisplayValue($Grid->amount_paid->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="TREATMENT_BILL" data-field="x_amount_paid" data-hidden="1" name="x<?= $Grid->RowIndex ?>_amount_paid" id="x<?= $Grid->RowIndex ?>_amount_paid" value="<?= HtmlEncode($Grid->amount_paid->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="TREATMENT_BILL" data-field="x_amount_paid" data-hidden="1" name="o<?= $Grid->RowIndex ?>_amount_paid" id="o<?= $Grid->RowIndex ?>_amount_paid" value="<?= HtmlEncode($Grid->amount_paid->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->TRANS_ID->Visible) { // TRANS_ID ?>
        <td data-name="TRANS_ID">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_TREATMENT_BILL_TRANS_ID" class="form-group TREATMENT_BILL_TRANS_ID">
<input type="<?= $Grid->TRANS_ID->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_TRANS_ID" name="x<?= $Grid->RowIndex ?>_TRANS_ID" id="x<?= $Grid->RowIndex ?>_TRANS_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->TRANS_ID->getPlaceHolder()) ?>" value="<?= $Grid->TRANS_ID->EditValue ?>"<?= $Grid->TRANS_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->TRANS_ID->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_TREATMENT_BILL_TRANS_ID" class="form-group TREATMENT_BILL_TRANS_ID">
<span<?= $Grid->TRANS_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->TRANS_ID->getDisplayValue($Grid->TRANS_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="TREATMENT_BILL" data-field="x_TRANS_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_TRANS_ID" id="x<?= $Grid->RowIndex ?>_TRANS_ID" value="<?= HtmlEncode($Grid->TRANS_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="TREATMENT_BILL" data-field="x_TRANS_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_TRANS_ID" id="o<?= $Grid->RowIndex ?>_TRANS_ID" value="<?= HtmlEncode($Grid->TRANS_ID->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["fTREATMENT_BILLgrid","load"], function() {
    fTREATMENT_BILLgrid.updateLists(<?= $Grid->RowIndex ?>);
});
</script>
    </tr>
<?php
    }
?>
</tbody>
<?php
// Render aggregate row
$Grid->RowType = ROWTYPE_AGGREGATE;
$Grid->resetAttributes();
$Grid->renderRow();
?>
<?php if ($Grid->TotalRecords > 0 && $Grid->CurrentMode == "view") { ?>
<tfoot><!-- Table footer -->
    <tr class="ew-table-footer">
<?php
// Render list options
$Grid->renderListOptions();

// Render list options (footer, left)
$Grid->ListOptions->render("footer", "left");
?>
    <?php if ($Grid->NOTA_NO->Visible) { // NOTA_NO ?>
        <td data-name="NOTA_NO" class="<?= $Grid->NOTA_NO->footerCellClass() ?>"><span id="elf_TREATMENT_BILL_NOTA_NO" class="TREATMENT_BILL_NOTA_NO">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Grid->TARIF_ID->Visible) { // TARIF_ID ?>
        <td data-name="TARIF_ID" class="<?= $Grid->TARIF_ID->footerCellClass() ?>"><span id="elf_TREATMENT_BILL_TARIF_ID" class="TREATMENT_BILL_TARIF_ID">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Grid->CLINIC_ID->Visible) { // CLINIC_ID ?>
        <td data-name="CLINIC_ID" class="<?= $Grid->CLINIC_ID->footerCellClass() ?>"><span id="elf_TREATMENT_BILL_CLINIC_ID" class="TREATMENT_BILL_CLINIC_ID">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Grid->TREATMENT->Visible) { // TREATMENT ?>
        <td data-name="TREATMENT" class="<?= $Grid->TREATMENT->footerCellClass() ?>"><span id="elf_TREATMENT_BILL_TREATMENT" class="TREATMENT_BILL_TREATMENT">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Grid->TREAT_DATE->Visible) { // TREAT_DATE ?>
        <td data-name="TREAT_DATE" class="<?= $Grid->TREAT_DATE->footerCellClass() ?>"><span id="elf_TREATMENT_BILL_TREAT_DATE" class="TREATMENT_BILL_TREAT_DATE">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Grid->AMOUNT->Visible) { // AMOUNT ?>
        <td data-name="AMOUNT" class="<?= $Grid->AMOUNT->footerCellClass() ?>"><span id="elf_TREATMENT_BILL_AMOUNT" class="TREATMENT_BILL_AMOUNT">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Grid->QUANTITY->Visible) { // QUANTITY ?>
        <td data-name="QUANTITY" class="<?= $Grid->QUANTITY->footerCellClass() ?>"><span id="elf_TREATMENT_BILL_QUANTITY" class="TREATMENT_BILL_QUANTITY">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Grid->PAYMENT_DATE->Visible) { // PAYMENT_DATE ?>
        <td data-name="PAYMENT_DATE" class="<?= $Grid->PAYMENT_DATE->footerCellClass() ?>"><span id="elf_TREATMENT_BILL_PAYMENT_DATE" class="TREATMENT_BILL_PAYMENT_DATE">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Grid->ISLUNAS->Visible) { // ISLUNAS ?>
        <td data-name="ISLUNAS" class="<?= $Grid->ISLUNAS->footerCellClass() ?>"><span id="elf_TREATMENT_BILL_ISLUNAS" class="TREATMENT_BILL_ISLUNAS">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Grid->EMPLOYEE_ID->Visible) { // EMPLOYEE_ID ?>
        <td data-name="EMPLOYEE_ID" class="<?= $Grid->EMPLOYEE_ID->footerCellClass() ?>"><span id="elf_TREATMENT_BILL_EMPLOYEE_ID" class="TREATMENT_BILL_EMPLOYEE_ID">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Grid->amount_paid->Visible) { // amount_paid ?>
        <td data-name="amount_paid" class="<?= $Grid->amount_paid->footerCellClass() ?>"><span id="elf_TREATMENT_BILL_amount_paid" class="TREATMENT_BILL_amount_paid">
        <span class="ew-aggregate"><?= $Language->phrase("TOTAL") ?></span><span class="ew-aggregate-value">
        <?= $Grid->amount_paid->ViewValue ?></span>
        </span></td>
    <?php } ?>
    <?php if ($Grid->TRANS_ID->Visible) { // TRANS_ID ?>
        <td data-name="TRANS_ID" class="<?= $Grid->TRANS_ID->footerCellClass() ?>"><span id="elf_TREATMENT_BILL_TRANS_ID" class="TREATMENT_BILL_TRANS_ID">
        &nbsp;
        </span></td>
    <?php } ?>
<?php
// Render list options (footer, right)
$Grid->ListOptions->render("footer", "right");
?>
    </tr>
</tfoot>
<?php } ?>
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
<input type="hidden" name="detailpage" value="fTREATMENT_BILLgrid">
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
    ew.addEventHandlers("TREATMENT_BILL");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
