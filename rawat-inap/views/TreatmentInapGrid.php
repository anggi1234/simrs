<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

// Set up and run Grid object
$Grid = Container("TreatmentInapGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fTREATMENT_INAPgrid;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    fTREATMENT_INAPgrid = new ew.Form("fTREATMENT_INAPgrid", "grid");
    fTREATMENT_INAPgrid.formKeyCountName = '<?= $Grid->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "TREATMENT_INAP")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.TREATMENT_INAP)
        ew.vars.tables.TREATMENT_INAP = currentTable;
    fTREATMENT_INAPgrid.addFields([
        ["NO_REGISTRATION", [fields.NO_REGISTRATION.visible && fields.NO_REGISTRATION.required ? ew.Validators.required(fields.NO_REGISTRATION.caption) : null], fields.NO_REGISTRATION.isInvalid],
        ["VISIT_ID", [fields.VISIT_ID.visible && fields.VISIT_ID.required ? ew.Validators.required(fields.VISIT_ID.caption) : null], fields.VISIT_ID.isInvalid],
        ["TARIF_ID", [fields.TARIF_ID.visible && fields.TARIF_ID.required ? ew.Validators.required(fields.TARIF_ID.caption) : null], fields.TARIF_ID.isInvalid],
        ["CLINIC_ID", [fields.CLINIC_ID.visible && fields.CLINIC_ID.required ? ew.Validators.required(fields.CLINIC_ID.caption) : null], fields.CLINIC_ID.isInvalid],
        ["TREATMENT", [fields.TREATMENT.visible && fields.TREATMENT.required ? ew.Validators.required(fields.TREATMENT.caption) : null], fields.TREATMENT.isInvalid],
        ["TREAT_DATE", [fields.TREAT_DATE.visible && fields.TREAT_DATE.required ? ew.Validators.required(fields.TREAT_DATE.caption) : null, ew.Validators.datetime(11)], fields.TREAT_DATE.isInvalid],
        ["QUANTITY", [fields.QUANTITY.visible && fields.QUANTITY.required ? ew.Validators.required(fields.QUANTITY.caption) : null, ew.Validators.float], fields.QUANTITY.isInvalid],
        ["TRANS_ID", [fields.TRANS_ID.visible && fields.TRANS_ID.required ? ew.Validators.required(fields.TRANS_ID.caption) : null], fields.TRANS_ID.isInvalid],
        ["ID", [fields.ID.visible && fields.ID.required ? ew.Validators.required(fields.ID.caption) : null], fields.ID.isInvalid],
        ["AMOUNT", [fields.AMOUNT.visible && fields.AMOUNT.required ? ew.Validators.required(fields.AMOUNT.caption) : null, ew.Validators.float], fields.AMOUNT.isInvalid],
        ["POKOK_JUAL", [fields.POKOK_JUAL.visible && fields.POKOK_JUAL.required ? ew.Validators.required(fields.POKOK_JUAL.caption) : null, ew.Validators.float], fields.POKOK_JUAL.isInvalid],
        ["PPN", [fields.PPN.visible && fields.PPN.required ? ew.Validators.required(fields.PPN.caption) : null, ew.Validators.float], fields.PPN.isInvalid],
        ["SUBSIDI", [fields.SUBSIDI.visible && fields.SUBSIDI.required ? ew.Validators.required(fields.SUBSIDI.caption) : null, ew.Validators.float], fields.SUBSIDI.isInvalid],
        ["PRINT_DATE", [fields.PRINT_DATE.visible && fields.PRINT_DATE.required ? ew.Validators.required(fields.PRINT_DATE.caption) : null, ew.Validators.datetime(0)], fields.PRINT_DATE.isInvalid],
        ["ISCETAK", [fields.ISCETAK.visible && fields.ISCETAK.required ? ew.Validators.required(fields.ISCETAK.caption) : null], fields.ISCETAK.isInvalid],
        ["NOTA_NO", [fields.NOTA_NO.visible && fields.NOTA_NO.required ? ew.Validators.required(fields.NOTA_NO.caption) : null], fields.NOTA_NO.isInvalid],
        ["KUITANSI_ID", [fields.KUITANSI_ID.visible && fields.KUITANSI_ID.required ? ew.Validators.required(fields.KUITANSI_ID.caption) : null], fields.KUITANSI_ID.isInvalid],
        ["amount_paid", [fields.amount_paid.visible && fields.amount_paid.required ? ew.Validators.required(fields.amount_paid.caption) : null, ew.Validators.float], fields.amount_paid.isInvalid],
        ["sell_price", [fields.sell_price.visible && fields.sell_price.required ? ew.Validators.required(fields.sell_price.caption) : null, ew.Validators.float], fields.sell_price.isInvalid],
        ["diskon", [fields.diskon.visible && fields.diskon.required ? ew.Validators.required(fields.diskon.caption) : null, ew.Validators.float], fields.diskon.isInvalid],
        ["TAGIHAN", [fields.TAGIHAN.visible && fields.TAGIHAN.required ? ew.Validators.required(fields.TAGIHAN.caption) : null, ew.Validators.float], fields.TAGIHAN.isInvalid],
        ["CLINIC_TYPE", [fields.CLINIC_TYPE.visible && fields.CLINIC_TYPE.required ? ew.Validators.required(fields.CLINIC_TYPE.caption) : null, ew.Validators.integer], fields.CLINIC_TYPE.isInvalid],
        ["ID_1", [fields.ID_1.visible && fields.ID_1.required ? ew.Validators.required(fields.ID_1.caption) : null], fields.ID_1.isInvalid],
        ["ORG_UNIT_CODE", [fields.ORG_UNIT_CODE.visible && fields.ORG_UNIT_CODE.required ? ew.Validators.required(fields.ORG_UNIT_CODE.caption) : null], fields.ORG_UNIT_CODE.isInvalid],
        ["BILL_ID_1", [fields.BILL_ID_1.visible && fields.BILL_ID_1.required ? ew.Validators.required(fields.BILL_ID_1.caption) : null], fields.BILL_ID_1.isInvalid],
        ["NO_REGISTRATION_1", [fields.NO_REGISTRATION_1.visible && fields.NO_REGISTRATION_1.required ? ew.Validators.required(fields.NO_REGISTRATION_1.caption) : null], fields.NO_REGISTRATION_1.isInvalid],
        ["VISIT_ID_1", [fields.VISIT_ID_1.visible && fields.VISIT_ID_1.required ? ew.Validators.required(fields.VISIT_ID_1.caption) : null], fields.VISIT_ID_1.isInvalid],
        ["TARIF_ID_1", [fields.TARIF_ID_1.visible && fields.TARIF_ID_1.required ? ew.Validators.required(fields.TARIF_ID_1.caption) : null], fields.TARIF_ID_1.isInvalid],
        ["CLASS_ID_1", [fields.CLASS_ID_1.visible && fields.CLASS_ID_1.required ? ew.Validators.required(fields.CLASS_ID_1.caption) : null, ew.Validators.integer], fields.CLASS_ID_1.isInvalid],
        ["CLINIC_ID_1", [fields.CLINIC_ID_1.visible && fields.CLINIC_ID_1.required ? ew.Validators.required(fields.CLINIC_ID_1.caption) : null], fields.CLINIC_ID_1.isInvalid],
        ["CLINIC_ID_FROM_1", [fields.CLINIC_ID_FROM_1.visible && fields.CLINIC_ID_FROM_1.required ? ew.Validators.required(fields.CLINIC_ID_FROM_1.caption) : null], fields.CLINIC_ID_FROM_1.isInvalid],
        ["TREATMENT_1", [fields.TREATMENT_1.visible && fields.TREATMENT_1.required ? ew.Validators.required(fields.TREATMENT_1.caption) : null], fields.TREATMENT_1.isInvalid],
        ["TREAT_DATE_1", [fields.TREAT_DATE_1.visible && fields.TREAT_DATE_1.required ? ew.Validators.required(fields.TREAT_DATE_1.caption) : null, ew.Validators.datetime(0)], fields.TREAT_DATE_1.isInvalid],
        ["QUANTITY_1", [fields.QUANTITY_1.visible && fields.QUANTITY_1.required ? ew.Validators.required(fields.QUANTITY_1.caption) : null, ew.Validators.float], fields.QUANTITY_1.isInvalid],
        ["MEASURE_ID", [fields.MEASURE_ID.visible && fields.MEASURE_ID.required ? ew.Validators.required(fields.MEASURE_ID.caption) : null, ew.Validators.integer], fields.MEASURE_ID.isInvalid],
        ["MEASURE_ID_1", [fields.MEASURE_ID_1.visible && fields.MEASURE_ID_1.required ? ew.Validators.required(fields.MEASURE_ID_1.caption) : null, ew.Validators.integer], fields.MEASURE_ID_1.isInvalid],
        ["TRANS_ID_1", [fields.TRANS_ID_1.visible && fields.TRANS_ID_1.required ? ew.Validators.required(fields.TRANS_ID_1.caption) : null], fields.TRANS_ID_1.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fTREATMENT_INAPgrid,
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
    fTREATMENT_INAPgrid.validate = function () {
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
    fTREATMENT_INAPgrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm();
        if (ew.valueChanged(fobj, rowIndex, "NO_REGISTRATION", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "VISIT_ID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "TARIF_ID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "CLINIC_ID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "TREATMENT", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "TREAT_DATE", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "QUANTITY", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "TRANS_ID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "AMOUNT", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "POKOK_JUAL", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "PPN", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "SUBSIDI", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "PRINT_DATE", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "ISCETAK", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "NOTA_NO", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "KUITANSI_ID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "amount_paid", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "sell_price", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "diskon", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "TAGIHAN", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "CLINIC_TYPE", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "ORG_UNIT_CODE", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "BILL_ID_1", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "NO_REGISTRATION_1", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "VISIT_ID_1", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "TARIF_ID_1", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "CLASS_ID_1", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "CLINIC_ID_1", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "CLINIC_ID_FROM_1", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "TREATMENT_1", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "TREAT_DATE_1", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "QUANTITY_1", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "MEASURE_ID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "MEASURE_ID_1", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "TRANS_ID_1", false))
            return false;
        return true;
    }

    // Form_CustomValidate
    fTREATMENT_INAPgrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fTREATMENT_INAPgrid.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fTREATMENT_INAPgrid.lists.NO_REGISTRATION = <?= $Grid->NO_REGISTRATION->toClientList($Grid) ?>;
    fTREATMENT_INAPgrid.lists.TARIF_ID = <?= $Grid->TARIF_ID->toClientList($Grid) ?>;
    fTREATMENT_INAPgrid.lists.CLINIC_ID = <?= $Grid->CLINIC_ID->toClientList($Grid) ?>;
    loadjs.done("fTREATMENT_INAPgrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> TREATMENT_INAP">
<?php if ($Grid->ShowOtherOptions) { ?>
<div class="card-header ew-grid-upper-panel">
<?php $Grid->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="fTREATMENT_INAPgrid" class="ew-form ew-list-form form-inline">
<div id="gmp_TREATMENT_INAP" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_TREATMENT_INAPgrid" class="table ew-table"><!-- .ew-table -->
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
        <th data-name="NO_REGISTRATION" class="<?= $Grid->NO_REGISTRATION->headerCellClass() ?>"><div id="elh_TREATMENT_INAP_NO_REGISTRATION" class="TREATMENT_INAP_NO_REGISTRATION"><?= $Grid->renderSort($Grid->NO_REGISTRATION) ?></div></th>
<?php } ?>
<?php if ($Grid->VISIT_ID->Visible) { // VISIT_ID ?>
        <th data-name="VISIT_ID" class="<?= $Grid->VISIT_ID->headerCellClass() ?>"><div id="elh_TREATMENT_INAP_VISIT_ID" class="TREATMENT_INAP_VISIT_ID"><?= $Grid->renderSort($Grid->VISIT_ID) ?></div></th>
<?php } ?>
<?php if ($Grid->TARIF_ID->Visible) { // TARIF_ID ?>
        <th data-name="TARIF_ID" class="<?= $Grid->TARIF_ID->headerCellClass() ?>"><div id="elh_TREATMENT_INAP_TARIF_ID" class="TREATMENT_INAP_TARIF_ID"><?= $Grid->renderSort($Grid->TARIF_ID) ?></div></th>
<?php } ?>
<?php if ($Grid->CLINIC_ID->Visible) { // CLINIC_ID ?>
        <th data-name="CLINIC_ID" class="<?= $Grid->CLINIC_ID->headerCellClass() ?>"><div id="elh_TREATMENT_INAP_CLINIC_ID" class="TREATMENT_INAP_CLINIC_ID"><?= $Grid->renderSort($Grid->CLINIC_ID) ?></div></th>
<?php } ?>
<?php if ($Grid->TREATMENT->Visible) { // TREATMENT ?>
        <th data-name="TREATMENT" class="<?= $Grid->TREATMENT->headerCellClass() ?>"><div id="elh_TREATMENT_INAP_TREATMENT" class="TREATMENT_INAP_TREATMENT"><?= $Grid->renderSort($Grid->TREATMENT) ?></div></th>
<?php } ?>
<?php if ($Grid->TREAT_DATE->Visible) { // TREAT_DATE ?>
        <th data-name="TREAT_DATE" class="<?= $Grid->TREAT_DATE->headerCellClass() ?>"><div id="elh_TREATMENT_INAP_TREAT_DATE" class="TREATMENT_INAP_TREAT_DATE"><?= $Grid->renderSort($Grid->TREAT_DATE) ?></div></th>
<?php } ?>
<?php if ($Grid->QUANTITY->Visible) { // QUANTITY ?>
        <th data-name="QUANTITY" class="<?= $Grid->QUANTITY->headerCellClass() ?>"><div id="elh_TREATMENT_INAP_QUANTITY" class="TREATMENT_INAP_QUANTITY"><?= $Grid->renderSort($Grid->QUANTITY) ?></div></th>
<?php } ?>
<?php if ($Grid->TRANS_ID->Visible) { // TRANS_ID ?>
        <th data-name="TRANS_ID" class="<?= $Grid->TRANS_ID->headerCellClass() ?>"><div id="elh_TREATMENT_INAP_TRANS_ID" class="TREATMENT_INAP_TRANS_ID"><?= $Grid->renderSort($Grid->TRANS_ID) ?></div></th>
<?php } ?>
<?php if ($Grid->ID->Visible) { // ID ?>
        <th data-name="ID" class="<?= $Grid->ID->headerCellClass() ?>"><div id="elh_TREATMENT_INAP_ID" class="TREATMENT_INAP_ID"><?= $Grid->renderSort($Grid->ID) ?></div></th>
<?php } ?>
<?php if ($Grid->AMOUNT->Visible) { // AMOUNT ?>
        <th data-name="AMOUNT" class="<?= $Grid->AMOUNT->headerCellClass() ?>"><div id="elh_TREATMENT_INAP_AMOUNT" class="TREATMENT_INAP_AMOUNT"><?= $Grid->renderSort($Grid->AMOUNT) ?></div></th>
<?php } ?>
<?php if ($Grid->POKOK_JUAL->Visible) { // POKOK_JUAL ?>
        <th data-name="POKOK_JUAL" class="<?= $Grid->POKOK_JUAL->headerCellClass() ?>"><div id="elh_TREATMENT_INAP_POKOK_JUAL" class="TREATMENT_INAP_POKOK_JUAL"><?= $Grid->renderSort($Grid->POKOK_JUAL) ?></div></th>
<?php } ?>
<?php if ($Grid->PPN->Visible) { // PPN ?>
        <th data-name="PPN" class="<?= $Grid->PPN->headerCellClass() ?>"><div id="elh_TREATMENT_INAP_PPN" class="TREATMENT_INAP_PPN"><?= $Grid->renderSort($Grid->PPN) ?></div></th>
<?php } ?>
<?php if ($Grid->SUBSIDI->Visible) { // SUBSIDI ?>
        <th data-name="SUBSIDI" class="<?= $Grid->SUBSIDI->headerCellClass() ?>"><div id="elh_TREATMENT_INAP_SUBSIDI" class="TREATMENT_INAP_SUBSIDI"><?= $Grid->renderSort($Grid->SUBSIDI) ?></div></th>
<?php } ?>
<?php if ($Grid->PRINT_DATE->Visible) { // PRINT_DATE ?>
        <th data-name="PRINT_DATE" class="<?= $Grid->PRINT_DATE->headerCellClass() ?>"><div id="elh_TREATMENT_INAP_PRINT_DATE" class="TREATMENT_INAP_PRINT_DATE"><?= $Grid->renderSort($Grid->PRINT_DATE) ?></div></th>
<?php } ?>
<?php if ($Grid->ISCETAK->Visible) { // ISCETAK ?>
        <th data-name="ISCETAK" class="<?= $Grid->ISCETAK->headerCellClass() ?>"><div id="elh_TREATMENT_INAP_ISCETAK" class="TREATMENT_INAP_ISCETAK"><?= $Grid->renderSort($Grid->ISCETAK) ?></div></th>
<?php } ?>
<?php if ($Grid->NOTA_NO->Visible) { // NOTA_NO ?>
        <th data-name="NOTA_NO" class="<?= $Grid->NOTA_NO->headerCellClass() ?>"><div id="elh_TREATMENT_INAP_NOTA_NO" class="TREATMENT_INAP_NOTA_NO"><?= $Grid->renderSort($Grid->NOTA_NO) ?></div></th>
<?php } ?>
<?php if ($Grid->KUITANSI_ID->Visible) { // KUITANSI_ID ?>
        <th data-name="KUITANSI_ID" class="<?= $Grid->KUITANSI_ID->headerCellClass() ?>"><div id="elh_TREATMENT_INAP_KUITANSI_ID" class="TREATMENT_INAP_KUITANSI_ID"><?= $Grid->renderSort($Grid->KUITANSI_ID) ?></div></th>
<?php } ?>
<?php if ($Grid->amount_paid->Visible) { // amount_paid ?>
        <th data-name="amount_paid" class="<?= $Grid->amount_paid->headerCellClass() ?>"><div id="elh_TREATMENT_INAP_amount_paid" class="TREATMENT_INAP_amount_paid"><?= $Grid->renderSort($Grid->amount_paid) ?></div></th>
<?php } ?>
<?php if ($Grid->sell_price->Visible) { // sell_price ?>
        <th data-name="sell_price" class="<?= $Grid->sell_price->headerCellClass() ?>"><div id="elh_TREATMENT_INAP_sell_price" class="TREATMENT_INAP_sell_price"><?= $Grid->renderSort($Grid->sell_price) ?></div></th>
<?php } ?>
<?php if ($Grid->diskon->Visible) { // diskon ?>
        <th data-name="diskon" class="<?= $Grid->diskon->headerCellClass() ?>"><div id="elh_TREATMENT_INAP_diskon" class="TREATMENT_INAP_diskon"><?= $Grid->renderSort($Grid->diskon) ?></div></th>
<?php } ?>
<?php if ($Grid->TAGIHAN->Visible) { // TAGIHAN ?>
        <th data-name="TAGIHAN" class="<?= $Grid->TAGIHAN->headerCellClass() ?>"><div id="elh_TREATMENT_INAP_TAGIHAN" class="TREATMENT_INAP_TAGIHAN"><?= $Grid->renderSort($Grid->TAGIHAN) ?></div></th>
<?php } ?>
<?php if ($Grid->CLINIC_TYPE->Visible) { // CLINIC_TYPE ?>
        <th data-name="CLINIC_TYPE" class="<?= $Grid->CLINIC_TYPE->headerCellClass() ?>"><div id="elh_TREATMENT_INAP_CLINIC_TYPE" class="TREATMENT_INAP_CLINIC_TYPE"><?= $Grid->renderSort($Grid->CLINIC_TYPE) ?></div></th>
<?php } ?>
<?php if ($Grid->ID_1->Visible) { // ID_1 ?>
        <th data-name="ID_1" class="<?= $Grid->ID_1->headerCellClass() ?>"><div id="elh_TREATMENT_INAP_ID_1" class="TREATMENT_INAP_ID_1"><?= $Grid->renderSort($Grid->ID_1) ?></div></th>
<?php } ?>
<?php if ($Grid->ORG_UNIT_CODE->Visible) { // ORG_UNIT_CODE ?>
        <th data-name="ORG_UNIT_CODE" class="<?= $Grid->ORG_UNIT_CODE->headerCellClass() ?>"><div id="elh_TREATMENT_INAP_ORG_UNIT_CODE" class="TREATMENT_INAP_ORG_UNIT_CODE"><?= $Grid->renderSort($Grid->ORG_UNIT_CODE) ?></div></th>
<?php } ?>
<?php if ($Grid->BILL_ID_1->Visible) { // BILL_ID_1 ?>
        <th data-name="BILL_ID_1" class="<?= $Grid->BILL_ID_1->headerCellClass() ?>"><div id="elh_TREATMENT_INAP_BILL_ID_1" class="TREATMENT_INAP_BILL_ID_1"><?= $Grid->renderSort($Grid->BILL_ID_1) ?></div></th>
<?php } ?>
<?php if ($Grid->NO_REGISTRATION_1->Visible) { // NO_REGISTRATION_1 ?>
        <th data-name="NO_REGISTRATION_1" class="<?= $Grid->NO_REGISTRATION_1->headerCellClass() ?>"><div id="elh_TREATMENT_INAP_NO_REGISTRATION_1" class="TREATMENT_INAP_NO_REGISTRATION_1"><?= $Grid->renderSort($Grid->NO_REGISTRATION_1) ?></div></th>
<?php } ?>
<?php if ($Grid->VISIT_ID_1->Visible) { // VISIT_ID_1 ?>
        <th data-name="VISIT_ID_1" class="<?= $Grid->VISIT_ID_1->headerCellClass() ?>"><div id="elh_TREATMENT_INAP_VISIT_ID_1" class="TREATMENT_INAP_VISIT_ID_1"><?= $Grid->renderSort($Grid->VISIT_ID_1) ?></div></th>
<?php } ?>
<?php if ($Grid->TARIF_ID_1->Visible) { // TARIF_ID_1 ?>
        <th data-name="TARIF_ID_1" class="<?= $Grid->TARIF_ID_1->headerCellClass() ?>"><div id="elh_TREATMENT_INAP_TARIF_ID_1" class="TREATMENT_INAP_TARIF_ID_1"><?= $Grid->renderSort($Grid->TARIF_ID_1) ?></div></th>
<?php } ?>
<?php if ($Grid->CLASS_ID_1->Visible) { // CLASS_ID_1 ?>
        <th data-name="CLASS_ID_1" class="<?= $Grid->CLASS_ID_1->headerCellClass() ?>"><div id="elh_TREATMENT_INAP_CLASS_ID_1" class="TREATMENT_INAP_CLASS_ID_1"><?= $Grid->renderSort($Grid->CLASS_ID_1) ?></div></th>
<?php } ?>
<?php if ($Grid->CLINIC_ID_1->Visible) { // CLINIC_ID_1 ?>
        <th data-name="CLINIC_ID_1" class="<?= $Grid->CLINIC_ID_1->headerCellClass() ?>"><div id="elh_TREATMENT_INAP_CLINIC_ID_1" class="TREATMENT_INAP_CLINIC_ID_1"><?= $Grid->renderSort($Grid->CLINIC_ID_1) ?></div></th>
<?php } ?>
<?php if ($Grid->CLINIC_ID_FROM_1->Visible) { // CLINIC_ID_FROM_1 ?>
        <th data-name="CLINIC_ID_FROM_1" class="<?= $Grid->CLINIC_ID_FROM_1->headerCellClass() ?>"><div id="elh_TREATMENT_INAP_CLINIC_ID_FROM_1" class="TREATMENT_INAP_CLINIC_ID_FROM_1"><?= $Grid->renderSort($Grid->CLINIC_ID_FROM_1) ?></div></th>
<?php } ?>
<?php if ($Grid->TREATMENT_1->Visible) { // TREATMENT_1 ?>
        <th data-name="TREATMENT_1" class="<?= $Grid->TREATMENT_1->headerCellClass() ?>"><div id="elh_TREATMENT_INAP_TREATMENT_1" class="TREATMENT_INAP_TREATMENT_1"><?= $Grid->renderSort($Grid->TREATMENT_1) ?></div></th>
<?php } ?>
<?php if ($Grid->TREAT_DATE_1->Visible) { // TREAT_DATE_1 ?>
        <th data-name="TREAT_DATE_1" class="<?= $Grid->TREAT_DATE_1->headerCellClass() ?>"><div id="elh_TREATMENT_INAP_TREAT_DATE_1" class="TREATMENT_INAP_TREAT_DATE_1"><?= $Grid->renderSort($Grid->TREAT_DATE_1) ?></div></th>
<?php } ?>
<?php if ($Grid->QUANTITY_1->Visible) { // QUANTITY_1 ?>
        <th data-name="QUANTITY_1" class="<?= $Grid->QUANTITY_1->headerCellClass() ?>"><div id="elh_TREATMENT_INAP_QUANTITY_1" class="TREATMENT_INAP_QUANTITY_1"><?= $Grid->renderSort($Grid->QUANTITY_1) ?></div></th>
<?php } ?>
<?php if ($Grid->MEASURE_ID->Visible) { // MEASURE_ID ?>
        <th data-name="MEASURE_ID" class="<?= $Grid->MEASURE_ID->headerCellClass() ?>"><div id="elh_TREATMENT_INAP_MEASURE_ID" class="TREATMENT_INAP_MEASURE_ID"><?= $Grid->renderSort($Grid->MEASURE_ID) ?></div></th>
<?php } ?>
<?php if ($Grid->MEASURE_ID_1->Visible) { // MEASURE_ID_1 ?>
        <th data-name="MEASURE_ID_1" class="<?= $Grid->MEASURE_ID_1->headerCellClass() ?>"><div id="elh_TREATMENT_INAP_MEASURE_ID_1" class="TREATMENT_INAP_MEASURE_ID_1"><?= $Grid->renderSort($Grid->MEASURE_ID_1) ?></div></th>
<?php } ?>
<?php if ($Grid->TRANS_ID_1->Visible) { // TRANS_ID_1 ?>
        <th data-name="TRANS_ID_1" class="<?= $Grid->TRANS_ID_1->headerCellClass() ?>"><div id="elh_TREATMENT_INAP_TRANS_ID_1" class="TREATMENT_INAP_TRANS_ID_1"><?= $Grid->renderSort($Grid->TRANS_ID_1) ?></div></th>
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowCount, "id" => "r" . $Grid->RowCount . "_TREATMENT_INAP", "data-rowtype" => $Grid->RowType]);

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
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_NO_REGISTRATION" class="form-group">
<span<?= $Grid->NO_REGISTRATION->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->NO_REGISTRATION->getDisplayValue($Grid->NO_REGISTRATION->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" name="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" value="<?= HtmlEncode($Grid->NO_REGISTRATION->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_NO_REGISTRATION" class="form-group">
<div class="input-group ew-lookup-list">
    <div class="form-control ew-lookup-text" tabindex="-1" id="lu_x<?= $Grid->RowIndex ?>_NO_REGISTRATION"><?= EmptyValue(strval($Grid->NO_REGISTRATION->ViewValue)) ? $Language->phrase("PleaseSelect") : $Grid->NO_REGISTRATION->ViewValue ?></div>
    <div class="input-group-append">
        <button type="button" title="<?= HtmlEncode(str_replace("%s", RemoveHtml($Grid->NO_REGISTRATION->caption()), $Language->phrase("LookupLink", true))) ?>" class="ew-lookup-btn btn btn-default"<?= ($Grid->NO_REGISTRATION->ReadOnly || $Grid->NO_REGISTRATION->Disabled) ? " disabled" : "" ?> onclick="ew.modalLookupShow({lnk:this,el:'x<?= $Grid->RowIndex ?>_NO_REGISTRATION',m:0,n:10});"><i class="fas fa-search ew-icon"></i></button>
    </div>
</div>
<div class="invalid-feedback"><?= $Grid->NO_REGISTRATION->getErrorMessage() ?></div>
<?= $Grid->NO_REGISTRATION->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_NO_REGISTRATION") ?>
<input type="hidden" is="selection-list" data-table="TREATMENT_INAP" data-field="x_NO_REGISTRATION" data-type="text" data-multiple="0" data-lookup="1" data-value-separator="<?= $Grid->NO_REGISTRATION->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" id="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" value="<?= $Grid->NO_REGISTRATION->CurrentValue ?>"<?= $Grid->NO_REGISTRATION->editAttributes() ?>>
</span>
<?php } ?>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_NO_REGISTRATION" data-hidden="1" name="o<?= $Grid->RowIndex ?>_NO_REGISTRATION" id="o<?= $Grid->RowIndex ?>_NO_REGISTRATION" value="<?= HtmlEncode($Grid->NO_REGISTRATION->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Grid->NO_REGISTRATION->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_NO_REGISTRATION" class="form-group">
<span<?= $Grid->NO_REGISTRATION->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->NO_REGISTRATION->getDisplayValue($Grid->NO_REGISTRATION->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" name="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" value="<?= HtmlEncode($Grid->NO_REGISTRATION->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_NO_REGISTRATION" class="form-group">
<div class="input-group ew-lookup-list">
    <div class="form-control ew-lookup-text" tabindex="-1" id="lu_x<?= $Grid->RowIndex ?>_NO_REGISTRATION"><?= EmptyValue(strval($Grid->NO_REGISTRATION->ViewValue)) ? $Language->phrase("PleaseSelect") : $Grid->NO_REGISTRATION->ViewValue ?></div>
    <div class="input-group-append">
        <button type="button" title="<?= HtmlEncode(str_replace("%s", RemoveHtml($Grid->NO_REGISTRATION->caption()), $Language->phrase("LookupLink", true))) ?>" class="ew-lookup-btn btn btn-default"<?= ($Grid->NO_REGISTRATION->ReadOnly || $Grid->NO_REGISTRATION->Disabled) ? " disabled" : "" ?> onclick="ew.modalLookupShow({lnk:this,el:'x<?= $Grid->RowIndex ?>_NO_REGISTRATION',m:0,n:10});"><i class="fas fa-search ew-icon"></i></button>
    </div>
</div>
<div class="invalid-feedback"><?= $Grid->NO_REGISTRATION->getErrorMessage() ?></div>
<?= $Grid->NO_REGISTRATION->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_NO_REGISTRATION") ?>
<input type="hidden" is="selection-list" data-table="TREATMENT_INAP" data-field="x_NO_REGISTRATION" data-type="text" data-multiple="0" data-lookup="1" data-value-separator="<?= $Grid->NO_REGISTRATION->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" id="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" value="<?= $Grid->NO_REGISTRATION->CurrentValue ?>"<?= $Grid->NO_REGISTRATION->editAttributes() ?>>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_NO_REGISTRATION">
<span<?= $Grid->NO_REGISTRATION->viewAttributes() ?>>
<?= $Grid->NO_REGISTRATION->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_NO_REGISTRATION" data-hidden="1" name="fTREATMENT_INAPgrid$x<?= $Grid->RowIndex ?>_NO_REGISTRATION" id="fTREATMENT_INAPgrid$x<?= $Grid->RowIndex ?>_NO_REGISTRATION" value="<?= HtmlEncode($Grid->NO_REGISTRATION->FormValue) ?>">
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_NO_REGISTRATION" data-hidden="1" name="fTREATMENT_INAPgrid$o<?= $Grid->RowIndex ?>_NO_REGISTRATION" id="fTREATMENT_INAPgrid$o<?= $Grid->RowIndex ?>_NO_REGISTRATION" value="<?= HtmlEncode($Grid->NO_REGISTRATION->OldValue) ?>">
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
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_VISIT_ID" class="form-group">
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_VISIT_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_VISIT_ID" id="x<?= $Grid->RowIndex ?>_VISIT_ID" value="<?= HtmlEncode($Grid->VISIT_ID->CurrentValue) ?>">
</span>
<?php } ?>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_VISIT_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_VISIT_ID" id="o<?= $Grid->RowIndex ?>_VISIT_ID" value="<?= HtmlEncode($Grid->VISIT_ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Grid->VISIT_ID->getSessionValue() != "") { ?>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_VISIT_ID" name="x<?= $Grid->RowIndex ?>_VISIT_ID" value="<?= HtmlEncode($Grid->VISIT_ID->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_VISIT_ID" class="form-group">
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_VISIT_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_VISIT_ID" id="x<?= $Grid->RowIndex ?>_VISIT_ID" value="<?= HtmlEncode($Grid->VISIT_ID->CurrentValue) ?>">
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_VISIT_ID">
<span<?= $Grid->VISIT_ID->viewAttributes() ?>>
<?= $Grid->VISIT_ID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_VISIT_ID" data-hidden="1" name="fTREATMENT_INAPgrid$x<?= $Grid->RowIndex ?>_VISIT_ID" id="fTREATMENT_INAPgrid$x<?= $Grid->RowIndex ?>_VISIT_ID" value="<?= HtmlEncode($Grid->VISIT_ID->FormValue) ?>">
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_VISIT_ID" data-hidden="1" name="fTREATMENT_INAPgrid$o<?= $Grid->RowIndex ?>_VISIT_ID" id="fTREATMENT_INAPgrid$o<?= $Grid->RowIndex ?>_VISIT_ID" value="<?= HtmlEncode($Grid->VISIT_ID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->TARIF_ID->Visible) { // TARIF_ID ?>
        <td data-name="TARIF_ID" <?= $Grid->TARIF_ID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_TARIF_ID" class="form-group">
<?php $Grid->TARIF_ID->EditAttrs->prepend("onchange", "ew.autoFill(this);"); ?>
<div class="input-group ew-lookup-list">
    <div class="form-control ew-lookup-text" tabindex="-1" id="lu_x<?= $Grid->RowIndex ?>_TARIF_ID"><?= EmptyValue(strval($Grid->TARIF_ID->ViewValue)) ? $Language->phrase("PleaseSelect") : $Grid->TARIF_ID->ViewValue ?></div>
    <div class="input-group-append">
        <button type="button" title="<?= HtmlEncode(str_replace("%s", RemoveHtml($Grid->TARIF_ID->caption()), $Language->phrase("LookupLink", true))) ?>" class="ew-lookup-btn btn btn-default"<?= ($Grid->TARIF_ID->ReadOnly || $Grid->TARIF_ID->Disabled) ? " disabled" : "" ?> onclick="ew.modalLookupShow({lnk:this,el:'x<?= $Grid->RowIndex ?>_TARIF_ID',m:0,n:10});"><i class="fas fa-search ew-icon"></i></button>
    </div>
</div>
<div class="invalid-feedback"><?= $Grid->TARIF_ID->getErrorMessage() ?></div>
<?= $Grid->TARIF_ID->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_TARIF_ID") ?>
<input type="hidden" is="selection-list" data-table="TREATMENT_INAP" data-field="x_TARIF_ID" data-type="text" data-multiple="0" data-lookup="1" data-value-separator="<?= $Grid->TARIF_ID->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_TARIF_ID" id="x<?= $Grid->RowIndex ?>_TARIF_ID" value="<?= $Grid->TARIF_ID->CurrentValue ?>"<?= $Grid->TARIF_ID->editAttributes() ?>>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_TARIF_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_TARIF_ID" id="o<?= $Grid->RowIndex ?>_TARIF_ID" value="<?= HtmlEncode($Grid->TARIF_ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_TARIF_ID" class="form-group">
<?php $Grid->TARIF_ID->EditAttrs->prepend("onchange", "ew.autoFill(this);"); ?>
<div class="input-group ew-lookup-list">
    <div class="form-control ew-lookup-text" tabindex="-1" id="lu_x<?= $Grid->RowIndex ?>_TARIF_ID"><?= EmptyValue(strval($Grid->TARIF_ID->ViewValue)) ? $Language->phrase("PleaseSelect") : $Grid->TARIF_ID->ViewValue ?></div>
    <div class="input-group-append">
        <button type="button" title="<?= HtmlEncode(str_replace("%s", RemoveHtml($Grid->TARIF_ID->caption()), $Language->phrase("LookupLink", true))) ?>" class="ew-lookup-btn btn btn-default"<?= ($Grid->TARIF_ID->ReadOnly || $Grid->TARIF_ID->Disabled) ? " disabled" : "" ?> onclick="ew.modalLookupShow({lnk:this,el:'x<?= $Grid->RowIndex ?>_TARIF_ID',m:0,n:10});"><i class="fas fa-search ew-icon"></i></button>
    </div>
</div>
<div class="invalid-feedback"><?= $Grid->TARIF_ID->getErrorMessage() ?></div>
<?= $Grid->TARIF_ID->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_TARIF_ID") ?>
<input type="hidden" is="selection-list" data-table="TREATMENT_INAP" data-field="x_TARIF_ID" data-type="text" data-multiple="0" data-lookup="1" data-value-separator="<?= $Grid->TARIF_ID->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_TARIF_ID" id="x<?= $Grid->RowIndex ?>_TARIF_ID" value="<?= $Grid->TARIF_ID->CurrentValue ?>"<?= $Grid->TARIF_ID->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_TARIF_ID">
<span<?= $Grid->TARIF_ID->viewAttributes() ?>>
<?= $Grid->TARIF_ID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_TARIF_ID" data-hidden="1" name="fTREATMENT_INAPgrid$x<?= $Grid->RowIndex ?>_TARIF_ID" id="fTREATMENT_INAPgrid$x<?= $Grid->RowIndex ?>_TARIF_ID" value="<?= HtmlEncode($Grid->TARIF_ID->FormValue) ?>">
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_TARIF_ID" data-hidden="1" name="fTREATMENT_INAPgrid$o<?= $Grid->RowIndex ?>_TARIF_ID" id="fTREATMENT_INAPgrid$o<?= $Grid->RowIndex ?>_TARIF_ID" value="<?= HtmlEncode($Grid->TARIF_ID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->CLINIC_ID->Visible) { // CLINIC_ID ?>
        <td data-name="CLINIC_ID" <?= $Grid->CLINIC_ID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_CLINIC_ID" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_CLINIC_ID"
        name="x<?= $Grid->RowIndex ?>_CLINIC_ID"
        class="form-control ew-select<?= $Grid->CLINIC_ID->isInvalidClass() ?>"
        data-select2-id="TREATMENT_INAP_x<?= $Grid->RowIndex ?>_CLINIC_ID"
        data-table="TREATMENT_INAP"
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
    var el = document.querySelector("select[data-select2-id='TREATMENT_INAP_x<?= $Grid->RowIndex ?>_CLINIC_ID']"),
        options = { name: "x<?= $Grid->RowIndex ?>_CLINIC_ID", selectId: "TREATMENT_INAP_x<?= $Grid->RowIndex ?>_CLINIC_ID", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.TREATMENT_INAP.fields.CLINIC_ID.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_CLINIC_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_CLINIC_ID" id="o<?= $Grid->RowIndex ?>_CLINIC_ID" value="<?= HtmlEncode($Grid->CLINIC_ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_CLINIC_ID" class="form-group">
<span<?= $Grid->CLINIC_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->CLINIC_ID->getDisplayValue($Grid->CLINIC_ID->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_CLINIC_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_CLINIC_ID" id="x<?= $Grid->RowIndex ?>_CLINIC_ID" value="<?= HtmlEncode($Grid->CLINIC_ID->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_CLINIC_ID">
<span<?= $Grid->CLINIC_ID->viewAttributes() ?>>
<?= $Grid->CLINIC_ID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_CLINIC_ID" data-hidden="1" name="fTREATMENT_INAPgrid$x<?= $Grid->RowIndex ?>_CLINIC_ID" id="fTREATMENT_INAPgrid$x<?= $Grid->RowIndex ?>_CLINIC_ID" value="<?= HtmlEncode($Grid->CLINIC_ID->FormValue) ?>">
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_CLINIC_ID" data-hidden="1" name="fTREATMENT_INAPgrid$o<?= $Grid->RowIndex ?>_CLINIC_ID" id="fTREATMENT_INAPgrid$o<?= $Grid->RowIndex ?>_CLINIC_ID" value="<?= HtmlEncode($Grid->CLINIC_ID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->TREATMENT->Visible) { // TREATMENT ?>
        <td data-name="TREATMENT" <?= $Grid->TREATMENT->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_TREATMENT" class="form-group">
<input type="<?= $Grid->TREATMENT->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_TREATMENT" name="x<?= $Grid->RowIndex ?>_TREATMENT" id="x<?= $Grid->RowIndex ?>_TREATMENT" size="30" maxlength="200" placeholder="<?= HtmlEncode($Grid->TREATMENT->getPlaceHolder()) ?>" value="<?= $Grid->TREATMENT->EditValue ?>"<?= $Grid->TREATMENT->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->TREATMENT->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_TREATMENT" data-hidden="1" name="o<?= $Grid->RowIndex ?>_TREATMENT" id="o<?= $Grid->RowIndex ?>_TREATMENT" value="<?= HtmlEncode($Grid->TREATMENT->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_TREATMENT" class="form-group">
<input type="<?= $Grid->TREATMENT->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_TREATMENT" name="x<?= $Grid->RowIndex ?>_TREATMENT" id="x<?= $Grid->RowIndex ?>_TREATMENT" size="30" maxlength="200" placeholder="<?= HtmlEncode($Grid->TREATMENT->getPlaceHolder()) ?>" value="<?= $Grid->TREATMENT->EditValue ?>"<?= $Grid->TREATMENT->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->TREATMENT->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_TREATMENT">
<span<?= $Grid->TREATMENT->viewAttributes() ?>>
<?= $Grid->TREATMENT->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_TREATMENT" data-hidden="1" name="fTREATMENT_INAPgrid$x<?= $Grid->RowIndex ?>_TREATMENT" id="fTREATMENT_INAPgrid$x<?= $Grid->RowIndex ?>_TREATMENT" value="<?= HtmlEncode($Grid->TREATMENT->FormValue) ?>">
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_TREATMENT" data-hidden="1" name="fTREATMENT_INAPgrid$o<?= $Grid->RowIndex ?>_TREATMENT" id="fTREATMENT_INAPgrid$o<?= $Grid->RowIndex ?>_TREATMENT" value="<?= HtmlEncode($Grid->TREATMENT->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->TREAT_DATE->Visible) { // TREAT_DATE ?>
        <td data-name="TREAT_DATE" <?= $Grid->TREAT_DATE->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_TREAT_DATE" class="form-group">
<input type="<?= $Grid->TREAT_DATE->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_TREAT_DATE" data-format="11" name="x<?= $Grid->RowIndex ?>_TREAT_DATE" id="x<?= $Grid->RowIndex ?>_TREAT_DATE" placeholder="<?= HtmlEncode($Grid->TREAT_DATE->getPlaceHolder()) ?>" value="<?= $Grid->TREAT_DATE->EditValue ?>"<?= $Grid->TREAT_DATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->TREAT_DATE->getErrorMessage() ?></div>
<?php if (!$Grid->TREAT_DATE->ReadOnly && !$Grid->TREAT_DATE->Disabled && !isset($Grid->TREAT_DATE->EditAttrs["readonly"]) && !isset($Grid->TREAT_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fTREATMENT_INAPgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fTREATMENT_INAPgrid", "x<?= $Grid->RowIndex ?>_TREAT_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":11});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_TREAT_DATE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_TREAT_DATE" id="o<?= $Grid->RowIndex ?>_TREAT_DATE" value="<?= HtmlEncode($Grid->TREAT_DATE->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_TREAT_DATE" class="form-group">
<input type="<?= $Grid->TREAT_DATE->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_TREAT_DATE" data-format="11" name="x<?= $Grid->RowIndex ?>_TREAT_DATE" id="x<?= $Grid->RowIndex ?>_TREAT_DATE" placeholder="<?= HtmlEncode($Grid->TREAT_DATE->getPlaceHolder()) ?>" value="<?= $Grid->TREAT_DATE->EditValue ?>"<?= $Grid->TREAT_DATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->TREAT_DATE->getErrorMessage() ?></div>
<?php if (!$Grid->TREAT_DATE->ReadOnly && !$Grid->TREAT_DATE->Disabled && !isset($Grid->TREAT_DATE->EditAttrs["readonly"]) && !isset($Grid->TREAT_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fTREATMENT_INAPgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fTREATMENT_INAPgrid", "x<?= $Grid->RowIndex ?>_TREAT_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":11});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_TREAT_DATE">
<span<?= $Grid->TREAT_DATE->viewAttributes() ?>>
<?= $Grid->TREAT_DATE->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_TREAT_DATE" data-hidden="1" name="fTREATMENT_INAPgrid$x<?= $Grid->RowIndex ?>_TREAT_DATE" id="fTREATMENT_INAPgrid$x<?= $Grid->RowIndex ?>_TREAT_DATE" value="<?= HtmlEncode($Grid->TREAT_DATE->FormValue) ?>">
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_TREAT_DATE" data-hidden="1" name="fTREATMENT_INAPgrid$o<?= $Grid->RowIndex ?>_TREAT_DATE" id="fTREATMENT_INAPgrid$o<?= $Grid->RowIndex ?>_TREAT_DATE" value="<?= HtmlEncode($Grid->TREAT_DATE->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->QUANTITY->Visible) { // QUANTITY ?>
        <td data-name="QUANTITY" <?= $Grid->QUANTITY->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_QUANTITY" class="form-group">
<input type="<?= $Grid->QUANTITY->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_QUANTITY" name="x<?= $Grid->RowIndex ?>_QUANTITY" id="x<?= $Grid->RowIndex ?>_QUANTITY" size="30" placeholder="<?= HtmlEncode($Grid->QUANTITY->getPlaceHolder()) ?>" value="<?= $Grid->QUANTITY->EditValue ?>"<?= $Grid->QUANTITY->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->QUANTITY->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_QUANTITY" data-hidden="1" name="o<?= $Grid->RowIndex ?>_QUANTITY" id="o<?= $Grid->RowIndex ?>_QUANTITY" value="<?= HtmlEncode($Grid->QUANTITY->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_QUANTITY" class="form-group">
<input type="<?= $Grid->QUANTITY->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_QUANTITY" name="x<?= $Grid->RowIndex ?>_QUANTITY" id="x<?= $Grid->RowIndex ?>_QUANTITY" size="30" placeholder="<?= HtmlEncode($Grid->QUANTITY->getPlaceHolder()) ?>" value="<?= $Grid->QUANTITY->EditValue ?>"<?= $Grid->QUANTITY->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->QUANTITY->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_QUANTITY">
<span<?= $Grid->QUANTITY->viewAttributes() ?>>
<?= $Grid->QUANTITY->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_QUANTITY" data-hidden="1" name="fTREATMENT_INAPgrid$x<?= $Grid->RowIndex ?>_QUANTITY" id="fTREATMENT_INAPgrid$x<?= $Grid->RowIndex ?>_QUANTITY" value="<?= HtmlEncode($Grid->QUANTITY->FormValue) ?>">
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_QUANTITY" data-hidden="1" name="fTREATMENT_INAPgrid$o<?= $Grid->RowIndex ?>_QUANTITY" id="fTREATMENT_INAPgrid$o<?= $Grid->RowIndex ?>_QUANTITY" value="<?= HtmlEncode($Grid->QUANTITY->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->TRANS_ID->Visible) { // TRANS_ID ?>
        <td data-name="TRANS_ID" <?= $Grid->TRANS_ID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Grid->TRANS_ID->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_TRANS_ID" class="form-group">
<span<?= $Grid->TRANS_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->TRANS_ID->getDisplayValue($Grid->TRANS_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_TRANS_ID" name="x<?= $Grid->RowIndex ?>_TRANS_ID" value="<?= HtmlEncode($Grid->TRANS_ID->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_TRANS_ID" class="form-group">
<input type="<?= $Grid->TRANS_ID->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_TRANS_ID" name="x<?= $Grid->RowIndex ?>_TRANS_ID" id="x<?= $Grid->RowIndex ?>_TRANS_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->TRANS_ID->getPlaceHolder()) ?>" value="<?= $Grid->TRANS_ID->EditValue ?>"<?= $Grid->TRANS_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->TRANS_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_TRANS_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_TRANS_ID" id="o<?= $Grid->RowIndex ?>_TRANS_ID" value="<?= HtmlEncode($Grid->TRANS_ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Grid->TRANS_ID->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_TRANS_ID" class="form-group">
<span<?= $Grid->TRANS_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->TRANS_ID->getDisplayValue($Grid->TRANS_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_TRANS_ID" name="x<?= $Grid->RowIndex ?>_TRANS_ID" value="<?= HtmlEncode($Grid->TRANS_ID->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_TRANS_ID" class="form-group">
<input type="<?= $Grid->TRANS_ID->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_TRANS_ID" name="x<?= $Grid->RowIndex ?>_TRANS_ID" id="x<?= $Grid->RowIndex ?>_TRANS_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->TRANS_ID->getPlaceHolder()) ?>" value="<?= $Grid->TRANS_ID->EditValue ?>"<?= $Grid->TRANS_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->TRANS_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_TRANS_ID">
<span<?= $Grid->TRANS_ID->viewAttributes() ?>>
<?= $Grid->TRANS_ID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_TRANS_ID" data-hidden="1" name="fTREATMENT_INAPgrid$x<?= $Grid->RowIndex ?>_TRANS_ID" id="fTREATMENT_INAPgrid$x<?= $Grid->RowIndex ?>_TRANS_ID" value="<?= HtmlEncode($Grid->TRANS_ID->FormValue) ?>">
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_TRANS_ID" data-hidden="1" name="fTREATMENT_INAPgrid$o<?= $Grid->RowIndex ?>_TRANS_ID" id="fTREATMENT_INAPgrid$o<?= $Grid->RowIndex ?>_TRANS_ID" value="<?= HtmlEncode($Grid->TRANS_ID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->ID->Visible) { // ID ?>
        <td data-name="ID" <?= $Grid->ID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_ID" class="form-group"></span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ID" id="o<?= $Grid->RowIndex ?>_ID" value="<?= HtmlEncode($Grid->ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_ID" class="form-group">
<span<?= $Grid->ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->ID->getDisplayValue($Grid->ID->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_ID" id="x<?= $Grid->RowIndex ?>_ID" value="<?= HtmlEncode($Grid->ID->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_ID">
<span<?= $Grid->ID->viewAttributes() ?>>
<?= $Grid->ID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_ID" data-hidden="1" name="fTREATMENT_INAPgrid$x<?= $Grid->RowIndex ?>_ID" id="fTREATMENT_INAPgrid$x<?= $Grid->RowIndex ?>_ID" value="<?= HtmlEncode($Grid->ID->FormValue) ?>">
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_ID" data-hidden="1" name="fTREATMENT_INAPgrid$o<?= $Grid->RowIndex ?>_ID" id="fTREATMENT_INAPgrid$o<?= $Grid->RowIndex ?>_ID" value="<?= HtmlEncode($Grid->ID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="TREATMENT_INAP" data-field="x_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_ID" id="x<?= $Grid->RowIndex ?>_ID" value="<?= HtmlEncode($Grid->ID->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Grid->AMOUNT->Visible) { // AMOUNT ?>
        <td data-name="AMOUNT" <?= $Grid->AMOUNT->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_AMOUNT" class="form-group">
<input type="<?= $Grid->AMOUNT->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_AMOUNT" name="x<?= $Grid->RowIndex ?>_AMOUNT" id="x<?= $Grid->RowIndex ?>_AMOUNT" size="30" placeholder="<?= HtmlEncode($Grid->AMOUNT->getPlaceHolder()) ?>" value="<?= $Grid->AMOUNT->EditValue ?>"<?= $Grid->AMOUNT->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->AMOUNT->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_AMOUNT" data-hidden="1" name="o<?= $Grid->RowIndex ?>_AMOUNT" id="o<?= $Grid->RowIndex ?>_AMOUNT" value="<?= HtmlEncode($Grid->AMOUNT->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_AMOUNT" class="form-group">
<input type="<?= $Grid->AMOUNT->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_AMOUNT" name="x<?= $Grid->RowIndex ?>_AMOUNT" id="x<?= $Grid->RowIndex ?>_AMOUNT" size="30" placeholder="<?= HtmlEncode($Grid->AMOUNT->getPlaceHolder()) ?>" value="<?= $Grid->AMOUNT->EditValue ?>"<?= $Grid->AMOUNT->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->AMOUNT->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_AMOUNT">
<span<?= $Grid->AMOUNT->viewAttributes() ?>>
<?= $Grid->AMOUNT->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_AMOUNT" data-hidden="1" name="fTREATMENT_INAPgrid$x<?= $Grid->RowIndex ?>_AMOUNT" id="fTREATMENT_INAPgrid$x<?= $Grid->RowIndex ?>_AMOUNT" value="<?= HtmlEncode($Grid->AMOUNT->FormValue) ?>">
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_AMOUNT" data-hidden="1" name="fTREATMENT_INAPgrid$o<?= $Grid->RowIndex ?>_AMOUNT" id="fTREATMENT_INAPgrid$o<?= $Grid->RowIndex ?>_AMOUNT" value="<?= HtmlEncode($Grid->AMOUNT->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->POKOK_JUAL->Visible) { // POKOK_JUAL ?>
        <td data-name="POKOK_JUAL" <?= $Grid->POKOK_JUAL->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_POKOK_JUAL" class="form-group">
<input type="<?= $Grid->POKOK_JUAL->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_POKOK_JUAL" name="x<?= $Grid->RowIndex ?>_POKOK_JUAL" id="x<?= $Grid->RowIndex ?>_POKOK_JUAL" size="30" placeholder="<?= HtmlEncode($Grid->POKOK_JUAL->getPlaceHolder()) ?>" value="<?= $Grid->POKOK_JUAL->EditValue ?>"<?= $Grid->POKOK_JUAL->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->POKOK_JUAL->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_POKOK_JUAL" data-hidden="1" name="o<?= $Grid->RowIndex ?>_POKOK_JUAL" id="o<?= $Grid->RowIndex ?>_POKOK_JUAL" value="<?= HtmlEncode($Grid->POKOK_JUAL->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_POKOK_JUAL" class="form-group">
<input type="<?= $Grid->POKOK_JUAL->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_POKOK_JUAL" name="x<?= $Grid->RowIndex ?>_POKOK_JUAL" id="x<?= $Grid->RowIndex ?>_POKOK_JUAL" size="30" placeholder="<?= HtmlEncode($Grid->POKOK_JUAL->getPlaceHolder()) ?>" value="<?= $Grid->POKOK_JUAL->EditValue ?>"<?= $Grid->POKOK_JUAL->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->POKOK_JUAL->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_POKOK_JUAL">
<span<?= $Grid->POKOK_JUAL->viewAttributes() ?>>
<?= $Grid->POKOK_JUAL->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_POKOK_JUAL" data-hidden="1" name="fTREATMENT_INAPgrid$x<?= $Grid->RowIndex ?>_POKOK_JUAL" id="fTREATMENT_INAPgrid$x<?= $Grid->RowIndex ?>_POKOK_JUAL" value="<?= HtmlEncode($Grid->POKOK_JUAL->FormValue) ?>">
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_POKOK_JUAL" data-hidden="1" name="fTREATMENT_INAPgrid$o<?= $Grid->RowIndex ?>_POKOK_JUAL" id="fTREATMENT_INAPgrid$o<?= $Grid->RowIndex ?>_POKOK_JUAL" value="<?= HtmlEncode($Grid->POKOK_JUAL->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->PPN->Visible) { // PPN ?>
        <td data-name="PPN" <?= $Grid->PPN->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_PPN" class="form-group">
<input type="<?= $Grid->PPN->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_PPN" name="x<?= $Grid->RowIndex ?>_PPN" id="x<?= $Grid->RowIndex ?>_PPN" size="30" placeholder="<?= HtmlEncode($Grid->PPN->getPlaceHolder()) ?>" value="<?= $Grid->PPN->EditValue ?>"<?= $Grid->PPN->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->PPN->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_PPN" data-hidden="1" name="o<?= $Grid->RowIndex ?>_PPN" id="o<?= $Grid->RowIndex ?>_PPN" value="<?= HtmlEncode($Grid->PPN->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_PPN" class="form-group">
<input type="<?= $Grid->PPN->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_PPN" name="x<?= $Grid->RowIndex ?>_PPN" id="x<?= $Grid->RowIndex ?>_PPN" size="30" placeholder="<?= HtmlEncode($Grid->PPN->getPlaceHolder()) ?>" value="<?= $Grid->PPN->EditValue ?>"<?= $Grid->PPN->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->PPN->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_PPN">
<span<?= $Grid->PPN->viewAttributes() ?>>
<?= $Grid->PPN->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_PPN" data-hidden="1" name="fTREATMENT_INAPgrid$x<?= $Grid->RowIndex ?>_PPN" id="fTREATMENT_INAPgrid$x<?= $Grid->RowIndex ?>_PPN" value="<?= HtmlEncode($Grid->PPN->FormValue) ?>">
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_PPN" data-hidden="1" name="fTREATMENT_INAPgrid$o<?= $Grid->RowIndex ?>_PPN" id="fTREATMENT_INAPgrid$o<?= $Grid->RowIndex ?>_PPN" value="<?= HtmlEncode($Grid->PPN->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->SUBSIDI->Visible) { // SUBSIDI ?>
        <td data-name="SUBSIDI" <?= $Grid->SUBSIDI->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_SUBSIDI" class="form-group">
<input type="<?= $Grid->SUBSIDI->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_SUBSIDI" name="x<?= $Grid->RowIndex ?>_SUBSIDI" id="x<?= $Grid->RowIndex ?>_SUBSIDI" size="30" placeholder="<?= HtmlEncode($Grid->SUBSIDI->getPlaceHolder()) ?>" value="<?= $Grid->SUBSIDI->EditValue ?>"<?= $Grid->SUBSIDI->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->SUBSIDI->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_SUBSIDI" data-hidden="1" name="o<?= $Grid->RowIndex ?>_SUBSIDI" id="o<?= $Grid->RowIndex ?>_SUBSIDI" value="<?= HtmlEncode($Grid->SUBSIDI->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_SUBSIDI" class="form-group">
<input type="<?= $Grid->SUBSIDI->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_SUBSIDI" name="x<?= $Grid->RowIndex ?>_SUBSIDI" id="x<?= $Grid->RowIndex ?>_SUBSIDI" size="30" placeholder="<?= HtmlEncode($Grid->SUBSIDI->getPlaceHolder()) ?>" value="<?= $Grid->SUBSIDI->EditValue ?>"<?= $Grid->SUBSIDI->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->SUBSIDI->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_SUBSIDI">
<span<?= $Grid->SUBSIDI->viewAttributes() ?>>
<?= $Grid->SUBSIDI->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_SUBSIDI" data-hidden="1" name="fTREATMENT_INAPgrid$x<?= $Grid->RowIndex ?>_SUBSIDI" id="fTREATMENT_INAPgrid$x<?= $Grid->RowIndex ?>_SUBSIDI" value="<?= HtmlEncode($Grid->SUBSIDI->FormValue) ?>">
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_SUBSIDI" data-hidden="1" name="fTREATMENT_INAPgrid$o<?= $Grid->RowIndex ?>_SUBSIDI" id="fTREATMENT_INAPgrid$o<?= $Grid->RowIndex ?>_SUBSIDI" value="<?= HtmlEncode($Grid->SUBSIDI->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->PRINT_DATE->Visible) { // PRINT_DATE ?>
        <td data-name="PRINT_DATE" <?= $Grid->PRINT_DATE->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_PRINT_DATE" class="form-group">
<input type="<?= $Grid->PRINT_DATE->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_PRINT_DATE" name="x<?= $Grid->RowIndex ?>_PRINT_DATE" id="x<?= $Grid->RowIndex ?>_PRINT_DATE" placeholder="<?= HtmlEncode($Grid->PRINT_DATE->getPlaceHolder()) ?>" value="<?= $Grid->PRINT_DATE->EditValue ?>"<?= $Grid->PRINT_DATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->PRINT_DATE->getErrorMessage() ?></div>
<?php if (!$Grid->PRINT_DATE->ReadOnly && !$Grid->PRINT_DATE->Disabled && !isset($Grid->PRINT_DATE->EditAttrs["readonly"]) && !isset($Grid->PRINT_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fTREATMENT_INAPgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fTREATMENT_INAPgrid", "x<?= $Grid->RowIndex ?>_PRINT_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_PRINT_DATE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_PRINT_DATE" id="o<?= $Grid->RowIndex ?>_PRINT_DATE" value="<?= HtmlEncode($Grid->PRINT_DATE->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_PRINT_DATE" class="form-group">
<input type="<?= $Grid->PRINT_DATE->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_PRINT_DATE" name="x<?= $Grid->RowIndex ?>_PRINT_DATE" id="x<?= $Grid->RowIndex ?>_PRINT_DATE" placeholder="<?= HtmlEncode($Grid->PRINT_DATE->getPlaceHolder()) ?>" value="<?= $Grid->PRINT_DATE->EditValue ?>"<?= $Grid->PRINT_DATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->PRINT_DATE->getErrorMessage() ?></div>
<?php if (!$Grid->PRINT_DATE->ReadOnly && !$Grid->PRINT_DATE->Disabled && !isset($Grid->PRINT_DATE->EditAttrs["readonly"]) && !isset($Grid->PRINT_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fTREATMENT_INAPgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fTREATMENT_INAPgrid", "x<?= $Grid->RowIndex ?>_PRINT_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_PRINT_DATE">
<span<?= $Grid->PRINT_DATE->viewAttributes() ?>>
<?= $Grid->PRINT_DATE->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_PRINT_DATE" data-hidden="1" name="fTREATMENT_INAPgrid$x<?= $Grid->RowIndex ?>_PRINT_DATE" id="fTREATMENT_INAPgrid$x<?= $Grid->RowIndex ?>_PRINT_DATE" value="<?= HtmlEncode($Grid->PRINT_DATE->FormValue) ?>">
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_PRINT_DATE" data-hidden="1" name="fTREATMENT_INAPgrid$o<?= $Grid->RowIndex ?>_PRINT_DATE" id="fTREATMENT_INAPgrid$o<?= $Grid->RowIndex ?>_PRINT_DATE" value="<?= HtmlEncode($Grid->PRINT_DATE->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->ISCETAK->Visible) { // ISCETAK ?>
        <td data-name="ISCETAK" <?= $Grid->ISCETAK->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_ISCETAK" class="form-group">
<input type="<?= $Grid->ISCETAK->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_ISCETAK" name="x<?= $Grid->RowIndex ?>_ISCETAK" id="x<?= $Grid->RowIndex ?>_ISCETAK" size="30" maxlength="1" placeholder="<?= HtmlEncode($Grid->ISCETAK->getPlaceHolder()) ?>" value="<?= $Grid->ISCETAK->EditValue ?>"<?= $Grid->ISCETAK->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ISCETAK->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_ISCETAK" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ISCETAK" id="o<?= $Grid->RowIndex ?>_ISCETAK" value="<?= HtmlEncode($Grid->ISCETAK->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_ISCETAK" class="form-group">
<input type="<?= $Grid->ISCETAK->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_ISCETAK" name="x<?= $Grid->RowIndex ?>_ISCETAK" id="x<?= $Grid->RowIndex ?>_ISCETAK" size="30" maxlength="1" placeholder="<?= HtmlEncode($Grid->ISCETAK->getPlaceHolder()) ?>" value="<?= $Grid->ISCETAK->EditValue ?>"<?= $Grid->ISCETAK->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ISCETAK->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_ISCETAK">
<span<?= $Grid->ISCETAK->viewAttributes() ?>>
<?= $Grid->ISCETAK->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_ISCETAK" data-hidden="1" name="fTREATMENT_INAPgrid$x<?= $Grid->RowIndex ?>_ISCETAK" id="fTREATMENT_INAPgrid$x<?= $Grid->RowIndex ?>_ISCETAK" value="<?= HtmlEncode($Grid->ISCETAK->FormValue) ?>">
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_ISCETAK" data-hidden="1" name="fTREATMENT_INAPgrid$o<?= $Grid->RowIndex ?>_ISCETAK" id="fTREATMENT_INAPgrid$o<?= $Grid->RowIndex ?>_ISCETAK" value="<?= HtmlEncode($Grid->ISCETAK->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->NOTA_NO->Visible) { // NOTA_NO ?>
        <td data-name="NOTA_NO" <?= $Grid->NOTA_NO->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_NOTA_NO" class="form-group">
<input type="<?= $Grid->NOTA_NO->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_NOTA_NO" name="x<?= $Grid->RowIndex ?>_NOTA_NO" id="x<?= $Grid->RowIndex ?>_NOTA_NO" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->NOTA_NO->getPlaceHolder()) ?>" value="<?= $Grid->NOTA_NO->EditValue ?>"<?= $Grid->NOTA_NO->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->NOTA_NO->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_NOTA_NO" data-hidden="1" name="o<?= $Grid->RowIndex ?>_NOTA_NO" id="o<?= $Grid->RowIndex ?>_NOTA_NO" value="<?= HtmlEncode($Grid->NOTA_NO->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_NOTA_NO" class="form-group">
<input type="<?= $Grid->NOTA_NO->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_NOTA_NO" name="x<?= $Grid->RowIndex ?>_NOTA_NO" id="x<?= $Grid->RowIndex ?>_NOTA_NO" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->NOTA_NO->getPlaceHolder()) ?>" value="<?= $Grid->NOTA_NO->EditValue ?>"<?= $Grid->NOTA_NO->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->NOTA_NO->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_NOTA_NO">
<span<?= $Grid->NOTA_NO->viewAttributes() ?>>
<?= $Grid->NOTA_NO->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_NOTA_NO" data-hidden="1" name="fTREATMENT_INAPgrid$x<?= $Grid->RowIndex ?>_NOTA_NO" id="fTREATMENT_INAPgrid$x<?= $Grid->RowIndex ?>_NOTA_NO" value="<?= HtmlEncode($Grid->NOTA_NO->FormValue) ?>">
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_NOTA_NO" data-hidden="1" name="fTREATMENT_INAPgrid$o<?= $Grid->RowIndex ?>_NOTA_NO" id="fTREATMENT_INAPgrid$o<?= $Grid->RowIndex ?>_NOTA_NO" value="<?= HtmlEncode($Grid->NOTA_NO->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->KUITANSI_ID->Visible) { // KUITANSI_ID ?>
        <td data-name="KUITANSI_ID" <?= $Grid->KUITANSI_ID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_KUITANSI_ID" class="form-group">
<input type="<?= $Grid->KUITANSI_ID->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_KUITANSI_ID" name="x<?= $Grid->RowIndex ?>_KUITANSI_ID" id="x<?= $Grid->RowIndex ?>_KUITANSI_ID" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->KUITANSI_ID->getPlaceHolder()) ?>" value="<?= $Grid->KUITANSI_ID->EditValue ?>"<?= $Grid->KUITANSI_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->KUITANSI_ID->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_KUITANSI_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_KUITANSI_ID" id="o<?= $Grid->RowIndex ?>_KUITANSI_ID" value="<?= HtmlEncode($Grid->KUITANSI_ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_KUITANSI_ID" class="form-group">
<input type="<?= $Grid->KUITANSI_ID->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_KUITANSI_ID" name="x<?= $Grid->RowIndex ?>_KUITANSI_ID" id="x<?= $Grid->RowIndex ?>_KUITANSI_ID" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->KUITANSI_ID->getPlaceHolder()) ?>" value="<?= $Grid->KUITANSI_ID->EditValue ?>"<?= $Grid->KUITANSI_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->KUITANSI_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_KUITANSI_ID">
<span<?= $Grid->KUITANSI_ID->viewAttributes() ?>>
<?= $Grid->KUITANSI_ID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_KUITANSI_ID" data-hidden="1" name="fTREATMENT_INAPgrid$x<?= $Grid->RowIndex ?>_KUITANSI_ID" id="fTREATMENT_INAPgrid$x<?= $Grid->RowIndex ?>_KUITANSI_ID" value="<?= HtmlEncode($Grid->KUITANSI_ID->FormValue) ?>">
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_KUITANSI_ID" data-hidden="1" name="fTREATMENT_INAPgrid$o<?= $Grid->RowIndex ?>_KUITANSI_ID" id="fTREATMENT_INAPgrid$o<?= $Grid->RowIndex ?>_KUITANSI_ID" value="<?= HtmlEncode($Grid->KUITANSI_ID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->amount_paid->Visible) { // amount_paid ?>
        <td data-name="amount_paid" <?= $Grid->amount_paid->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_amount_paid" class="form-group">
<input type="<?= $Grid->amount_paid->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_amount_paid" name="x<?= $Grid->RowIndex ?>_amount_paid" id="x<?= $Grid->RowIndex ?>_amount_paid" size="30" placeholder="<?= HtmlEncode($Grid->amount_paid->getPlaceHolder()) ?>" value="<?= $Grid->amount_paid->EditValue ?>"<?= $Grid->amount_paid->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->amount_paid->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_amount_paid" data-hidden="1" name="o<?= $Grid->RowIndex ?>_amount_paid" id="o<?= $Grid->RowIndex ?>_amount_paid" value="<?= HtmlEncode($Grid->amount_paid->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_amount_paid" class="form-group">
<input type="<?= $Grid->amount_paid->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_amount_paid" name="x<?= $Grid->RowIndex ?>_amount_paid" id="x<?= $Grid->RowIndex ?>_amount_paid" size="30" placeholder="<?= HtmlEncode($Grid->amount_paid->getPlaceHolder()) ?>" value="<?= $Grid->amount_paid->EditValue ?>"<?= $Grid->amount_paid->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->amount_paid->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_amount_paid">
<span<?= $Grid->amount_paid->viewAttributes() ?>>
<?= $Grid->amount_paid->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_amount_paid" data-hidden="1" name="fTREATMENT_INAPgrid$x<?= $Grid->RowIndex ?>_amount_paid" id="fTREATMENT_INAPgrid$x<?= $Grid->RowIndex ?>_amount_paid" value="<?= HtmlEncode($Grid->amount_paid->FormValue) ?>">
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_amount_paid" data-hidden="1" name="fTREATMENT_INAPgrid$o<?= $Grid->RowIndex ?>_amount_paid" id="fTREATMENT_INAPgrid$o<?= $Grid->RowIndex ?>_amount_paid" value="<?= HtmlEncode($Grid->amount_paid->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->sell_price->Visible) { // sell_price ?>
        <td data-name="sell_price" <?= $Grid->sell_price->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_sell_price" class="form-group">
<input type="<?= $Grid->sell_price->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_sell_price" name="x<?= $Grid->RowIndex ?>_sell_price" id="x<?= $Grid->RowIndex ?>_sell_price" size="30" placeholder="<?= HtmlEncode($Grid->sell_price->getPlaceHolder()) ?>" value="<?= $Grid->sell_price->EditValue ?>"<?= $Grid->sell_price->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->sell_price->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_sell_price" data-hidden="1" name="o<?= $Grid->RowIndex ?>_sell_price" id="o<?= $Grid->RowIndex ?>_sell_price" value="<?= HtmlEncode($Grid->sell_price->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_sell_price" class="form-group">
<input type="<?= $Grid->sell_price->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_sell_price" name="x<?= $Grid->RowIndex ?>_sell_price" id="x<?= $Grid->RowIndex ?>_sell_price" size="30" placeholder="<?= HtmlEncode($Grid->sell_price->getPlaceHolder()) ?>" value="<?= $Grid->sell_price->EditValue ?>"<?= $Grid->sell_price->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->sell_price->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_sell_price">
<span<?= $Grid->sell_price->viewAttributes() ?>>
<?= $Grid->sell_price->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_sell_price" data-hidden="1" name="fTREATMENT_INAPgrid$x<?= $Grid->RowIndex ?>_sell_price" id="fTREATMENT_INAPgrid$x<?= $Grid->RowIndex ?>_sell_price" value="<?= HtmlEncode($Grid->sell_price->FormValue) ?>">
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_sell_price" data-hidden="1" name="fTREATMENT_INAPgrid$o<?= $Grid->RowIndex ?>_sell_price" id="fTREATMENT_INAPgrid$o<?= $Grid->RowIndex ?>_sell_price" value="<?= HtmlEncode($Grid->sell_price->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->diskon->Visible) { // diskon ?>
        <td data-name="diskon" <?= $Grid->diskon->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_diskon" class="form-group">
<input type="<?= $Grid->diskon->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_diskon" name="x<?= $Grid->RowIndex ?>_diskon" id="x<?= $Grid->RowIndex ?>_diskon" size="30" placeholder="<?= HtmlEncode($Grid->diskon->getPlaceHolder()) ?>" value="<?= $Grid->diskon->EditValue ?>"<?= $Grid->diskon->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->diskon->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_diskon" data-hidden="1" name="o<?= $Grid->RowIndex ?>_diskon" id="o<?= $Grid->RowIndex ?>_diskon" value="<?= HtmlEncode($Grid->diskon->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_diskon" class="form-group">
<input type="<?= $Grid->diskon->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_diskon" name="x<?= $Grid->RowIndex ?>_diskon" id="x<?= $Grid->RowIndex ?>_diskon" size="30" placeholder="<?= HtmlEncode($Grid->diskon->getPlaceHolder()) ?>" value="<?= $Grid->diskon->EditValue ?>"<?= $Grid->diskon->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->diskon->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_diskon">
<span<?= $Grid->diskon->viewAttributes() ?>>
<?= $Grid->diskon->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_diskon" data-hidden="1" name="fTREATMENT_INAPgrid$x<?= $Grid->RowIndex ?>_diskon" id="fTREATMENT_INAPgrid$x<?= $Grid->RowIndex ?>_diskon" value="<?= HtmlEncode($Grid->diskon->FormValue) ?>">
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_diskon" data-hidden="1" name="fTREATMENT_INAPgrid$o<?= $Grid->RowIndex ?>_diskon" id="fTREATMENT_INAPgrid$o<?= $Grid->RowIndex ?>_diskon" value="<?= HtmlEncode($Grid->diskon->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->TAGIHAN->Visible) { // TAGIHAN ?>
        <td data-name="TAGIHAN" <?= $Grid->TAGIHAN->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_TAGIHAN" class="form-group">
<input type="<?= $Grid->TAGIHAN->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_TAGIHAN" name="x<?= $Grid->RowIndex ?>_TAGIHAN" id="x<?= $Grid->RowIndex ?>_TAGIHAN" size="30" placeholder="<?= HtmlEncode($Grid->TAGIHAN->getPlaceHolder()) ?>" value="<?= $Grid->TAGIHAN->EditValue ?>"<?= $Grid->TAGIHAN->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->TAGIHAN->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_TAGIHAN" data-hidden="1" name="o<?= $Grid->RowIndex ?>_TAGIHAN" id="o<?= $Grid->RowIndex ?>_TAGIHAN" value="<?= HtmlEncode($Grid->TAGIHAN->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_TAGIHAN" class="form-group">
<input type="<?= $Grid->TAGIHAN->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_TAGIHAN" name="x<?= $Grid->RowIndex ?>_TAGIHAN" id="x<?= $Grid->RowIndex ?>_TAGIHAN" size="30" placeholder="<?= HtmlEncode($Grid->TAGIHAN->getPlaceHolder()) ?>" value="<?= $Grid->TAGIHAN->EditValue ?>"<?= $Grid->TAGIHAN->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->TAGIHAN->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_TAGIHAN">
<span<?= $Grid->TAGIHAN->viewAttributes() ?>>
<?= $Grid->TAGIHAN->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_TAGIHAN" data-hidden="1" name="fTREATMENT_INAPgrid$x<?= $Grid->RowIndex ?>_TAGIHAN" id="fTREATMENT_INAPgrid$x<?= $Grid->RowIndex ?>_TAGIHAN" value="<?= HtmlEncode($Grid->TAGIHAN->FormValue) ?>">
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_TAGIHAN" data-hidden="1" name="fTREATMENT_INAPgrid$o<?= $Grid->RowIndex ?>_TAGIHAN" id="fTREATMENT_INAPgrid$o<?= $Grid->RowIndex ?>_TAGIHAN" value="<?= HtmlEncode($Grid->TAGIHAN->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->CLINIC_TYPE->Visible) { // CLINIC_TYPE ?>
        <td data-name="CLINIC_TYPE" <?= $Grid->CLINIC_TYPE->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_CLINIC_TYPE" class="form-group">
<input type="<?= $Grid->CLINIC_TYPE->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_CLINIC_TYPE" name="x<?= $Grid->RowIndex ?>_CLINIC_TYPE" id="x<?= $Grid->RowIndex ?>_CLINIC_TYPE" size="30" placeholder="<?= HtmlEncode($Grid->CLINIC_TYPE->getPlaceHolder()) ?>" value="<?= $Grid->CLINIC_TYPE->EditValue ?>"<?= $Grid->CLINIC_TYPE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->CLINIC_TYPE->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_CLINIC_TYPE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_CLINIC_TYPE" id="o<?= $Grid->RowIndex ?>_CLINIC_TYPE" value="<?= HtmlEncode($Grid->CLINIC_TYPE->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_CLINIC_TYPE" class="form-group">
<input type="<?= $Grid->CLINIC_TYPE->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_CLINIC_TYPE" name="x<?= $Grid->RowIndex ?>_CLINIC_TYPE" id="x<?= $Grid->RowIndex ?>_CLINIC_TYPE" size="30" placeholder="<?= HtmlEncode($Grid->CLINIC_TYPE->getPlaceHolder()) ?>" value="<?= $Grid->CLINIC_TYPE->EditValue ?>"<?= $Grid->CLINIC_TYPE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->CLINIC_TYPE->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_CLINIC_TYPE">
<span<?= $Grid->CLINIC_TYPE->viewAttributes() ?>>
<?= $Grid->CLINIC_TYPE->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_CLINIC_TYPE" data-hidden="1" name="fTREATMENT_INAPgrid$x<?= $Grid->RowIndex ?>_CLINIC_TYPE" id="fTREATMENT_INAPgrid$x<?= $Grid->RowIndex ?>_CLINIC_TYPE" value="<?= HtmlEncode($Grid->CLINIC_TYPE->FormValue) ?>">
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_CLINIC_TYPE" data-hidden="1" name="fTREATMENT_INAPgrid$o<?= $Grid->RowIndex ?>_CLINIC_TYPE" id="fTREATMENT_INAPgrid$o<?= $Grid->RowIndex ?>_CLINIC_TYPE" value="<?= HtmlEncode($Grid->CLINIC_TYPE->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->ID_1->Visible) { // ID_1 ?>
        <td data-name="ID_1" <?= $Grid->ID_1->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_ID_1" class="form-group"></span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_ID_1" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ID_1" id="o<?= $Grid->RowIndex ?>_ID_1" value="<?= HtmlEncode($Grid->ID_1->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_ID_1" class="form-group">
<input type="<?= $Grid->ID_1->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_ID_1" name="x<?= $Grid->RowIndex ?>_ID_1" id="x<?= $Grid->RowIndex ?>_ID_1" placeholder="<?= HtmlEncode($Grid->ID_1->getPlaceHolder()) ?>" value="<?= $Grid->ID_1->EditValue ?>"<?= $Grid->ID_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ID_1->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_ID_1">
<span<?= $Grid->ID_1->viewAttributes() ?>>
<?= $Grid->ID_1->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_ID_1" data-hidden="1" name="fTREATMENT_INAPgrid$x<?= $Grid->RowIndex ?>_ID_1" id="fTREATMENT_INAPgrid$x<?= $Grid->RowIndex ?>_ID_1" value="<?= HtmlEncode($Grid->ID_1->FormValue) ?>">
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_ID_1" data-hidden="1" name="fTREATMENT_INAPgrid$o<?= $Grid->RowIndex ?>_ID_1" id="fTREATMENT_INAPgrid$o<?= $Grid->RowIndex ?>_ID_1" value="<?= HtmlEncode($Grid->ID_1->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->ORG_UNIT_CODE->Visible) { // ORG_UNIT_CODE ?>
        <td data-name="ORG_UNIT_CODE" <?= $Grid->ORG_UNIT_CODE->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_ORG_UNIT_CODE" class="form-group">
<input type="<?= $Grid->ORG_UNIT_CODE->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_ORG_UNIT_CODE" name="x<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" id="x<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->ORG_UNIT_CODE->getPlaceHolder()) ?>" value="<?= $Grid->ORG_UNIT_CODE->EditValue ?>"<?= $Grid->ORG_UNIT_CODE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ORG_UNIT_CODE->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_ORG_UNIT_CODE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" id="o<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" value="<?= HtmlEncode($Grid->ORG_UNIT_CODE->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_ORG_UNIT_CODE" class="form-group">
<input type="<?= $Grid->ORG_UNIT_CODE->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_ORG_UNIT_CODE" name="x<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" id="x<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->ORG_UNIT_CODE->getPlaceHolder()) ?>" value="<?= $Grid->ORG_UNIT_CODE->EditValue ?>"<?= $Grid->ORG_UNIT_CODE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ORG_UNIT_CODE->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_ORG_UNIT_CODE">
<span<?= $Grid->ORG_UNIT_CODE->viewAttributes() ?>>
<?= $Grid->ORG_UNIT_CODE->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_ORG_UNIT_CODE" data-hidden="1" name="fTREATMENT_INAPgrid$x<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" id="fTREATMENT_INAPgrid$x<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" value="<?= HtmlEncode($Grid->ORG_UNIT_CODE->FormValue) ?>">
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_ORG_UNIT_CODE" data-hidden="1" name="fTREATMENT_INAPgrid$o<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" id="fTREATMENT_INAPgrid$o<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" value="<?= HtmlEncode($Grid->ORG_UNIT_CODE->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->BILL_ID_1->Visible) { // BILL_ID_1 ?>
        <td data-name="BILL_ID_1" <?= $Grid->BILL_ID_1->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_BILL_ID_1" class="form-group">
<input type="<?= $Grid->BILL_ID_1->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_BILL_ID_1" name="x<?= $Grid->RowIndex ?>_BILL_ID_1" id="x<?= $Grid->RowIndex ?>_BILL_ID_1" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->BILL_ID_1->getPlaceHolder()) ?>" value="<?= $Grid->BILL_ID_1->EditValue ?>"<?= $Grid->BILL_ID_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->BILL_ID_1->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_BILL_ID_1" data-hidden="1" name="o<?= $Grid->RowIndex ?>_BILL_ID_1" id="o<?= $Grid->RowIndex ?>_BILL_ID_1" value="<?= HtmlEncode($Grid->BILL_ID_1->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_BILL_ID_1" class="form-group">
<input type="<?= $Grid->BILL_ID_1->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_BILL_ID_1" name="x<?= $Grid->RowIndex ?>_BILL_ID_1" id="x<?= $Grid->RowIndex ?>_BILL_ID_1" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->BILL_ID_1->getPlaceHolder()) ?>" value="<?= $Grid->BILL_ID_1->EditValue ?>"<?= $Grid->BILL_ID_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->BILL_ID_1->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_BILL_ID_1">
<span<?= $Grid->BILL_ID_1->viewAttributes() ?>>
<?= $Grid->BILL_ID_1->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_BILL_ID_1" data-hidden="1" name="fTREATMENT_INAPgrid$x<?= $Grid->RowIndex ?>_BILL_ID_1" id="fTREATMENT_INAPgrid$x<?= $Grid->RowIndex ?>_BILL_ID_1" value="<?= HtmlEncode($Grid->BILL_ID_1->FormValue) ?>">
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_BILL_ID_1" data-hidden="1" name="fTREATMENT_INAPgrid$o<?= $Grid->RowIndex ?>_BILL_ID_1" id="fTREATMENT_INAPgrid$o<?= $Grid->RowIndex ?>_BILL_ID_1" value="<?= HtmlEncode($Grid->BILL_ID_1->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->NO_REGISTRATION_1->Visible) { // NO_REGISTRATION_1 ?>
        <td data-name="NO_REGISTRATION_1" <?= $Grid->NO_REGISTRATION_1->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_NO_REGISTRATION_1" class="form-group">
<input type="<?= $Grid->NO_REGISTRATION_1->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_NO_REGISTRATION_1" name="x<?= $Grid->RowIndex ?>_NO_REGISTRATION_1" id="x<?= $Grid->RowIndex ?>_NO_REGISTRATION_1" size="30" maxlength="25" placeholder="<?= HtmlEncode($Grid->NO_REGISTRATION_1->getPlaceHolder()) ?>" value="<?= $Grid->NO_REGISTRATION_1->EditValue ?>"<?= $Grid->NO_REGISTRATION_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->NO_REGISTRATION_1->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_NO_REGISTRATION_1" data-hidden="1" name="o<?= $Grid->RowIndex ?>_NO_REGISTRATION_1" id="o<?= $Grid->RowIndex ?>_NO_REGISTRATION_1" value="<?= HtmlEncode($Grid->NO_REGISTRATION_1->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_NO_REGISTRATION_1" class="form-group">
<input type="<?= $Grid->NO_REGISTRATION_1->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_NO_REGISTRATION_1" name="x<?= $Grid->RowIndex ?>_NO_REGISTRATION_1" id="x<?= $Grid->RowIndex ?>_NO_REGISTRATION_1" size="30" maxlength="25" placeholder="<?= HtmlEncode($Grid->NO_REGISTRATION_1->getPlaceHolder()) ?>" value="<?= $Grid->NO_REGISTRATION_1->EditValue ?>"<?= $Grid->NO_REGISTRATION_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->NO_REGISTRATION_1->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_NO_REGISTRATION_1">
<span<?= $Grid->NO_REGISTRATION_1->viewAttributes() ?>>
<?= $Grid->NO_REGISTRATION_1->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_NO_REGISTRATION_1" data-hidden="1" name="fTREATMENT_INAPgrid$x<?= $Grid->RowIndex ?>_NO_REGISTRATION_1" id="fTREATMENT_INAPgrid$x<?= $Grid->RowIndex ?>_NO_REGISTRATION_1" value="<?= HtmlEncode($Grid->NO_REGISTRATION_1->FormValue) ?>">
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_NO_REGISTRATION_1" data-hidden="1" name="fTREATMENT_INAPgrid$o<?= $Grid->RowIndex ?>_NO_REGISTRATION_1" id="fTREATMENT_INAPgrid$o<?= $Grid->RowIndex ?>_NO_REGISTRATION_1" value="<?= HtmlEncode($Grid->NO_REGISTRATION_1->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->VISIT_ID_1->Visible) { // VISIT_ID_1 ?>
        <td data-name="VISIT_ID_1" <?= $Grid->VISIT_ID_1->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_VISIT_ID_1" class="form-group">
<input type="<?= $Grid->VISIT_ID_1->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_VISIT_ID_1" name="x<?= $Grid->RowIndex ?>_VISIT_ID_1" id="x<?= $Grid->RowIndex ?>_VISIT_ID_1" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->VISIT_ID_1->getPlaceHolder()) ?>" value="<?= $Grid->VISIT_ID_1->EditValue ?>"<?= $Grid->VISIT_ID_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->VISIT_ID_1->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_VISIT_ID_1" data-hidden="1" name="o<?= $Grid->RowIndex ?>_VISIT_ID_1" id="o<?= $Grid->RowIndex ?>_VISIT_ID_1" value="<?= HtmlEncode($Grid->VISIT_ID_1->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_VISIT_ID_1" class="form-group">
<input type="<?= $Grid->VISIT_ID_1->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_VISIT_ID_1" name="x<?= $Grid->RowIndex ?>_VISIT_ID_1" id="x<?= $Grid->RowIndex ?>_VISIT_ID_1" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->VISIT_ID_1->getPlaceHolder()) ?>" value="<?= $Grid->VISIT_ID_1->EditValue ?>"<?= $Grid->VISIT_ID_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->VISIT_ID_1->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_VISIT_ID_1">
<span<?= $Grid->VISIT_ID_1->viewAttributes() ?>>
<?= $Grid->VISIT_ID_1->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_VISIT_ID_1" data-hidden="1" name="fTREATMENT_INAPgrid$x<?= $Grid->RowIndex ?>_VISIT_ID_1" id="fTREATMENT_INAPgrid$x<?= $Grid->RowIndex ?>_VISIT_ID_1" value="<?= HtmlEncode($Grid->VISIT_ID_1->FormValue) ?>">
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_VISIT_ID_1" data-hidden="1" name="fTREATMENT_INAPgrid$o<?= $Grid->RowIndex ?>_VISIT_ID_1" id="fTREATMENT_INAPgrid$o<?= $Grid->RowIndex ?>_VISIT_ID_1" value="<?= HtmlEncode($Grid->VISIT_ID_1->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->TARIF_ID_1->Visible) { // TARIF_ID_1 ?>
        <td data-name="TARIF_ID_1" <?= $Grid->TARIF_ID_1->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_TARIF_ID_1" class="form-group">
<input type="<?= $Grid->TARIF_ID_1->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_TARIF_ID_1" name="x<?= $Grid->RowIndex ?>_TARIF_ID_1" id="x<?= $Grid->RowIndex ?>_TARIF_ID_1" size="30" maxlength="25" placeholder="<?= HtmlEncode($Grid->TARIF_ID_1->getPlaceHolder()) ?>" value="<?= $Grid->TARIF_ID_1->EditValue ?>"<?= $Grid->TARIF_ID_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->TARIF_ID_1->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_TARIF_ID_1" data-hidden="1" name="o<?= $Grid->RowIndex ?>_TARIF_ID_1" id="o<?= $Grid->RowIndex ?>_TARIF_ID_1" value="<?= HtmlEncode($Grid->TARIF_ID_1->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_TARIF_ID_1" class="form-group">
<input type="<?= $Grid->TARIF_ID_1->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_TARIF_ID_1" name="x<?= $Grid->RowIndex ?>_TARIF_ID_1" id="x<?= $Grid->RowIndex ?>_TARIF_ID_1" size="30" maxlength="25" placeholder="<?= HtmlEncode($Grid->TARIF_ID_1->getPlaceHolder()) ?>" value="<?= $Grid->TARIF_ID_1->EditValue ?>"<?= $Grid->TARIF_ID_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->TARIF_ID_1->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_TARIF_ID_1">
<span<?= $Grid->TARIF_ID_1->viewAttributes() ?>>
<?= $Grid->TARIF_ID_1->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_TARIF_ID_1" data-hidden="1" name="fTREATMENT_INAPgrid$x<?= $Grid->RowIndex ?>_TARIF_ID_1" id="fTREATMENT_INAPgrid$x<?= $Grid->RowIndex ?>_TARIF_ID_1" value="<?= HtmlEncode($Grid->TARIF_ID_1->FormValue) ?>">
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_TARIF_ID_1" data-hidden="1" name="fTREATMENT_INAPgrid$o<?= $Grid->RowIndex ?>_TARIF_ID_1" id="fTREATMENT_INAPgrid$o<?= $Grid->RowIndex ?>_TARIF_ID_1" value="<?= HtmlEncode($Grid->TARIF_ID_1->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->CLASS_ID_1->Visible) { // CLASS_ID_1 ?>
        <td data-name="CLASS_ID_1" <?= $Grid->CLASS_ID_1->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_CLASS_ID_1" class="form-group">
<input type="<?= $Grid->CLASS_ID_1->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_CLASS_ID_1" name="x<?= $Grid->RowIndex ?>_CLASS_ID_1" id="x<?= $Grid->RowIndex ?>_CLASS_ID_1" size="30" placeholder="<?= HtmlEncode($Grid->CLASS_ID_1->getPlaceHolder()) ?>" value="<?= $Grid->CLASS_ID_1->EditValue ?>"<?= $Grid->CLASS_ID_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->CLASS_ID_1->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_CLASS_ID_1" data-hidden="1" name="o<?= $Grid->RowIndex ?>_CLASS_ID_1" id="o<?= $Grid->RowIndex ?>_CLASS_ID_1" value="<?= HtmlEncode($Grid->CLASS_ID_1->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_CLASS_ID_1" class="form-group">
<input type="<?= $Grid->CLASS_ID_1->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_CLASS_ID_1" name="x<?= $Grid->RowIndex ?>_CLASS_ID_1" id="x<?= $Grid->RowIndex ?>_CLASS_ID_1" size="30" placeholder="<?= HtmlEncode($Grid->CLASS_ID_1->getPlaceHolder()) ?>" value="<?= $Grid->CLASS_ID_1->EditValue ?>"<?= $Grid->CLASS_ID_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->CLASS_ID_1->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_CLASS_ID_1">
<span<?= $Grid->CLASS_ID_1->viewAttributes() ?>>
<?= $Grid->CLASS_ID_1->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_CLASS_ID_1" data-hidden="1" name="fTREATMENT_INAPgrid$x<?= $Grid->RowIndex ?>_CLASS_ID_1" id="fTREATMENT_INAPgrid$x<?= $Grid->RowIndex ?>_CLASS_ID_1" value="<?= HtmlEncode($Grid->CLASS_ID_1->FormValue) ?>">
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_CLASS_ID_1" data-hidden="1" name="fTREATMENT_INAPgrid$o<?= $Grid->RowIndex ?>_CLASS_ID_1" id="fTREATMENT_INAPgrid$o<?= $Grid->RowIndex ?>_CLASS_ID_1" value="<?= HtmlEncode($Grid->CLASS_ID_1->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->CLINIC_ID_1->Visible) { // CLINIC_ID_1 ?>
        <td data-name="CLINIC_ID_1" <?= $Grid->CLINIC_ID_1->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_CLINIC_ID_1" class="form-group">
<input type="<?= $Grid->CLINIC_ID_1->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_CLINIC_ID_1" name="x<?= $Grid->RowIndex ?>_CLINIC_ID_1" id="x<?= $Grid->RowIndex ?>_CLINIC_ID_1" size="30" maxlength="15" placeholder="<?= HtmlEncode($Grid->CLINIC_ID_1->getPlaceHolder()) ?>" value="<?= $Grid->CLINIC_ID_1->EditValue ?>"<?= $Grid->CLINIC_ID_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->CLINIC_ID_1->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_CLINIC_ID_1" data-hidden="1" name="o<?= $Grid->RowIndex ?>_CLINIC_ID_1" id="o<?= $Grid->RowIndex ?>_CLINIC_ID_1" value="<?= HtmlEncode($Grid->CLINIC_ID_1->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_CLINIC_ID_1" class="form-group">
<input type="<?= $Grid->CLINIC_ID_1->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_CLINIC_ID_1" name="x<?= $Grid->RowIndex ?>_CLINIC_ID_1" id="x<?= $Grid->RowIndex ?>_CLINIC_ID_1" size="30" maxlength="15" placeholder="<?= HtmlEncode($Grid->CLINIC_ID_1->getPlaceHolder()) ?>" value="<?= $Grid->CLINIC_ID_1->EditValue ?>"<?= $Grid->CLINIC_ID_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->CLINIC_ID_1->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_CLINIC_ID_1">
<span<?= $Grid->CLINIC_ID_1->viewAttributes() ?>>
<?= $Grid->CLINIC_ID_1->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_CLINIC_ID_1" data-hidden="1" name="fTREATMENT_INAPgrid$x<?= $Grid->RowIndex ?>_CLINIC_ID_1" id="fTREATMENT_INAPgrid$x<?= $Grid->RowIndex ?>_CLINIC_ID_1" value="<?= HtmlEncode($Grid->CLINIC_ID_1->FormValue) ?>">
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_CLINIC_ID_1" data-hidden="1" name="fTREATMENT_INAPgrid$o<?= $Grid->RowIndex ?>_CLINIC_ID_1" id="fTREATMENT_INAPgrid$o<?= $Grid->RowIndex ?>_CLINIC_ID_1" value="<?= HtmlEncode($Grid->CLINIC_ID_1->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->CLINIC_ID_FROM_1->Visible) { // CLINIC_ID_FROM_1 ?>
        <td data-name="CLINIC_ID_FROM_1" <?= $Grid->CLINIC_ID_FROM_1->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_CLINIC_ID_FROM_1" class="form-group">
<input type="<?= $Grid->CLINIC_ID_FROM_1->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_CLINIC_ID_FROM_1" name="x<?= $Grid->RowIndex ?>_CLINIC_ID_FROM_1" id="x<?= $Grid->RowIndex ?>_CLINIC_ID_FROM_1" size="30" maxlength="15" placeholder="<?= HtmlEncode($Grid->CLINIC_ID_FROM_1->getPlaceHolder()) ?>" value="<?= $Grid->CLINIC_ID_FROM_1->EditValue ?>"<?= $Grid->CLINIC_ID_FROM_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->CLINIC_ID_FROM_1->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_CLINIC_ID_FROM_1" data-hidden="1" name="o<?= $Grid->RowIndex ?>_CLINIC_ID_FROM_1" id="o<?= $Grid->RowIndex ?>_CLINIC_ID_FROM_1" value="<?= HtmlEncode($Grid->CLINIC_ID_FROM_1->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_CLINIC_ID_FROM_1" class="form-group">
<input type="<?= $Grid->CLINIC_ID_FROM_1->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_CLINIC_ID_FROM_1" name="x<?= $Grid->RowIndex ?>_CLINIC_ID_FROM_1" id="x<?= $Grid->RowIndex ?>_CLINIC_ID_FROM_1" size="30" maxlength="15" placeholder="<?= HtmlEncode($Grid->CLINIC_ID_FROM_1->getPlaceHolder()) ?>" value="<?= $Grid->CLINIC_ID_FROM_1->EditValue ?>"<?= $Grid->CLINIC_ID_FROM_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->CLINIC_ID_FROM_1->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_CLINIC_ID_FROM_1">
<span<?= $Grid->CLINIC_ID_FROM_1->viewAttributes() ?>>
<?= $Grid->CLINIC_ID_FROM_1->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_CLINIC_ID_FROM_1" data-hidden="1" name="fTREATMENT_INAPgrid$x<?= $Grid->RowIndex ?>_CLINIC_ID_FROM_1" id="fTREATMENT_INAPgrid$x<?= $Grid->RowIndex ?>_CLINIC_ID_FROM_1" value="<?= HtmlEncode($Grid->CLINIC_ID_FROM_1->FormValue) ?>">
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_CLINIC_ID_FROM_1" data-hidden="1" name="fTREATMENT_INAPgrid$o<?= $Grid->RowIndex ?>_CLINIC_ID_FROM_1" id="fTREATMENT_INAPgrid$o<?= $Grid->RowIndex ?>_CLINIC_ID_FROM_1" value="<?= HtmlEncode($Grid->CLINIC_ID_FROM_1->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->TREATMENT_1->Visible) { // TREATMENT_1 ?>
        <td data-name="TREATMENT_1" <?= $Grid->TREATMENT_1->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_TREATMENT_1" class="form-group">
<input type="<?= $Grid->TREATMENT_1->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_TREATMENT_1" name="x<?= $Grid->RowIndex ?>_TREATMENT_1" id="x<?= $Grid->RowIndex ?>_TREATMENT_1" size="30" maxlength="200" placeholder="<?= HtmlEncode($Grid->TREATMENT_1->getPlaceHolder()) ?>" value="<?= $Grid->TREATMENT_1->EditValue ?>"<?= $Grid->TREATMENT_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->TREATMENT_1->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_TREATMENT_1" data-hidden="1" name="o<?= $Grid->RowIndex ?>_TREATMENT_1" id="o<?= $Grid->RowIndex ?>_TREATMENT_1" value="<?= HtmlEncode($Grid->TREATMENT_1->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_TREATMENT_1" class="form-group">
<input type="<?= $Grid->TREATMENT_1->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_TREATMENT_1" name="x<?= $Grid->RowIndex ?>_TREATMENT_1" id="x<?= $Grid->RowIndex ?>_TREATMENT_1" size="30" maxlength="200" placeholder="<?= HtmlEncode($Grid->TREATMENT_1->getPlaceHolder()) ?>" value="<?= $Grid->TREATMENT_1->EditValue ?>"<?= $Grid->TREATMENT_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->TREATMENT_1->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_TREATMENT_1">
<span<?= $Grid->TREATMENT_1->viewAttributes() ?>>
<?= $Grid->TREATMENT_1->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_TREATMENT_1" data-hidden="1" name="fTREATMENT_INAPgrid$x<?= $Grid->RowIndex ?>_TREATMENT_1" id="fTREATMENT_INAPgrid$x<?= $Grid->RowIndex ?>_TREATMENT_1" value="<?= HtmlEncode($Grid->TREATMENT_1->FormValue) ?>">
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_TREATMENT_1" data-hidden="1" name="fTREATMENT_INAPgrid$o<?= $Grid->RowIndex ?>_TREATMENT_1" id="fTREATMENT_INAPgrid$o<?= $Grid->RowIndex ?>_TREATMENT_1" value="<?= HtmlEncode($Grid->TREATMENT_1->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->TREAT_DATE_1->Visible) { // TREAT_DATE_1 ?>
        <td data-name="TREAT_DATE_1" <?= $Grid->TREAT_DATE_1->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_TREAT_DATE_1" class="form-group">
<input type="<?= $Grid->TREAT_DATE_1->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_TREAT_DATE_1" name="x<?= $Grid->RowIndex ?>_TREAT_DATE_1" id="x<?= $Grid->RowIndex ?>_TREAT_DATE_1" placeholder="<?= HtmlEncode($Grid->TREAT_DATE_1->getPlaceHolder()) ?>" value="<?= $Grid->TREAT_DATE_1->EditValue ?>"<?= $Grid->TREAT_DATE_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->TREAT_DATE_1->getErrorMessage() ?></div>
<?php if (!$Grid->TREAT_DATE_1->ReadOnly && !$Grid->TREAT_DATE_1->Disabled && !isset($Grid->TREAT_DATE_1->EditAttrs["readonly"]) && !isset($Grid->TREAT_DATE_1->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fTREATMENT_INAPgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fTREATMENT_INAPgrid", "x<?= $Grid->RowIndex ?>_TREAT_DATE_1", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_TREAT_DATE_1" data-hidden="1" name="o<?= $Grid->RowIndex ?>_TREAT_DATE_1" id="o<?= $Grid->RowIndex ?>_TREAT_DATE_1" value="<?= HtmlEncode($Grid->TREAT_DATE_1->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_TREAT_DATE_1" class="form-group">
<input type="<?= $Grid->TREAT_DATE_1->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_TREAT_DATE_1" name="x<?= $Grid->RowIndex ?>_TREAT_DATE_1" id="x<?= $Grid->RowIndex ?>_TREAT_DATE_1" placeholder="<?= HtmlEncode($Grid->TREAT_DATE_1->getPlaceHolder()) ?>" value="<?= $Grid->TREAT_DATE_1->EditValue ?>"<?= $Grid->TREAT_DATE_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->TREAT_DATE_1->getErrorMessage() ?></div>
<?php if (!$Grid->TREAT_DATE_1->ReadOnly && !$Grid->TREAT_DATE_1->Disabled && !isset($Grid->TREAT_DATE_1->EditAttrs["readonly"]) && !isset($Grid->TREAT_DATE_1->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fTREATMENT_INAPgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fTREATMENT_INAPgrid", "x<?= $Grid->RowIndex ?>_TREAT_DATE_1", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_TREAT_DATE_1">
<span<?= $Grid->TREAT_DATE_1->viewAttributes() ?>>
<?= $Grid->TREAT_DATE_1->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_TREAT_DATE_1" data-hidden="1" name="fTREATMENT_INAPgrid$x<?= $Grid->RowIndex ?>_TREAT_DATE_1" id="fTREATMENT_INAPgrid$x<?= $Grid->RowIndex ?>_TREAT_DATE_1" value="<?= HtmlEncode($Grid->TREAT_DATE_1->FormValue) ?>">
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_TREAT_DATE_1" data-hidden="1" name="fTREATMENT_INAPgrid$o<?= $Grid->RowIndex ?>_TREAT_DATE_1" id="fTREATMENT_INAPgrid$o<?= $Grid->RowIndex ?>_TREAT_DATE_1" value="<?= HtmlEncode($Grid->TREAT_DATE_1->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->QUANTITY_1->Visible) { // QUANTITY_1 ?>
        <td data-name="QUANTITY_1" <?= $Grid->QUANTITY_1->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_QUANTITY_1" class="form-group">
<input type="<?= $Grid->QUANTITY_1->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_QUANTITY_1" name="x<?= $Grid->RowIndex ?>_QUANTITY_1" id="x<?= $Grid->RowIndex ?>_QUANTITY_1" size="30" placeholder="<?= HtmlEncode($Grid->QUANTITY_1->getPlaceHolder()) ?>" value="<?= $Grid->QUANTITY_1->EditValue ?>"<?= $Grid->QUANTITY_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->QUANTITY_1->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_QUANTITY_1" data-hidden="1" name="o<?= $Grid->RowIndex ?>_QUANTITY_1" id="o<?= $Grid->RowIndex ?>_QUANTITY_1" value="<?= HtmlEncode($Grid->QUANTITY_1->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_QUANTITY_1" class="form-group">
<input type="<?= $Grid->QUANTITY_1->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_QUANTITY_1" name="x<?= $Grid->RowIndex ?>_QUANTITY_1" id="x<?= $Grid->RowIndex ?>_QUANTITY_1" size="30" placeholder="<?= HtmlEncode($Grid->QUANTITY_1->getPlaceHolder()) ?>" value="<?= $Grid->QUANTITY_1->EditValue ?>"<?= $Grid->QUANTITY_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->QUANTITY_1->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_QUANTITY_1">
<span<?= $Grid->QUANTITY_1->viewAttributes() ?>>
<?= $Grid->QUANTITY_1->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_QUANTITY_1" data-hidden="1" name="fTREATMENT_INAPgrid$x<?= $Grid->RowIndex ?>_QUANTITY_1" id="fTREATMENT_INAPgrid$x<?= $Grid->RowIndex ?>_QUANTITY_1" value="<?= HtmlEncode($Grid->QUANTITY_1->FormValue) ?>">
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_QUANTITY_1" data-hidden="1" name="fTREATMENT_INAPgrid$o<?= $Grid->RowIndex ?>_QUANTITY_1" id="fTREATMENT_INAPgrid$o<?= $Grid->RowIndex ?>_QUANTITY_1" value="<?= HtmlEncode($Grid->QUANTITY_1->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->MEASURE_ID->Visible) { // MEASURE_ID ?>
        <td data-name="MEASURE_ID" <?= $Grid->MEASURE_ID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_MEASURE_ID" class="form-group">
<input type="<?= $Grid->MEASURE_ID->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_MEASURE_ID" name="x<?= $Grid->RowIndex ?>_MEASURE_ID" id="x<?= $Grid->RowIndex ?>_MEASURE_ID" size="30" placeholder="<?= HtmlEncode($Grid->MEASURE_ID->getPlaceHolder()) ?>" value="<?= $Grid->MEASURE_ID->EditValue ?>"<?= $Grid->MEASURE_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->MEASURE_ID->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_MEASURE_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_MEASURE_ID" id="o<?= $Grid->RowIndex ?>_MEASURE_ID" value="<?= HtmlEncode($Grid->MEASURE_ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_MEASURE_ID" class="form-group">
<input type="<?= $Grid->MEASURE_ID->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_MEASURE_ID" name="x<?= $Grid->RowIndex ?>_MEASURE_ID" id="x<?= $Grid->RowIndex ?>_MEASURE_ID" size="30" placeholder="<?= HtmlEncode($Grid->MEASURE_ID->getPlaceHolder()) ?>" value="<?= $Grid->MEASURE_ID->EditValue ?>"<?= $Grid->MEASURE_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->MEASURE_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_MEASURE_ID">
<span<?= $Grid->MEASURE_ID->viewAttributes() ?>>
<?= $Grid->MEASURE_ID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_MEASURE_ID" data-hidden="1" name="fTREATMENT_INAPgrid$x<?= $Grid->RowIndex ?>_MEASURE_ID" id="fTREATMENT_INAPgrid$x<?= $Grid->RowIndex ?>_MEASURE_ID" value="<?= HtmlEncode($Grid->MEASURE_ID->FormValue) ?>">
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_MEASURE_ID" data-hidden="1" name="fTREATMENT_INAPgrid$o<?= $Grid->RowIndex ?>_MEASURE_ID" id="fTREATMENT_INAPgrid$o<?= $Grid->RowIndex ?>_MEASURE_ID" value="<?= HtmlEncode($Grid->MEASURE_ID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->MEASURE_ID_1->Visible) { // MEASURE_ID_1 ?>
        <td data-name="MEASURE_ID_1" <?= $Grid->MEASURE_ID_1->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_MEASURE_ID_1" class="form-group">
<input type="<?= $Grid->MEASURE_ID_1->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_MEASURE_ID_1" name="x<?= $Grid->RowIndex ?>_MEASURE_ID_1" id="x<?= $Grid->RowIndex ?>_MEASURE_ID_1" size="30" placeholder="<?= HtmlEncode($Grid->MEASURE_ID_1->getPlaceHolder()) ?>" value="<?= $Grid->MEASURE_ID_1->EditValue ?>"<?= $Grid->MEASURE_ID_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->MEASURE_ID_1->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_MEASURE_ID_1" data-hidden="1" name="o<?= $Grid->RowIndex ?>_MEASURE_ID_1" id="o<?= $Grid->RowIndex ?>_MEASURE_ID_1" value="<?= HtmlEncode($Grid->MEASURE_ID_1->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_MEASURE_ID_1" class="form-group">
<input type="<?= $Grid->MEASURE_ID_1->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_MEASURE_ID_1" name="x<?= $Grid->RowIndex ?>_MEASURE_ID_1" id="x<?= $Grid->RowIndex ?>_MEASURE_ID_1" size="30" placeholder="<?= HtmlEncode($Grid->MEASURE_ID_1->getPlaceHolder()) ?>" value="<?= $Grid->MEASURE_ID_1->EditValue ?>"<?= $Grid->MEASURE_ID_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->MEASURE_ID_1->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_MEASURE_ID_1">
<span<?= $Grid->MEASURE_ID_1->viewAttributes() ?>>
<?= $Grid->MEASURE_ID_1->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_MEASURE_ID_1" data-hidden="1" name="fTREATMENT_INAPgrid$x<?= $Grid->RowIndex ?>_MEASURE_ID_1" id="fTREATMENT_INAPgrid$x<?= $Grid->RowIndex ?>_MEASURE_ID_1" value="<?= HtmlEncode($Grid->MEASURE_ID_1->FormValue) ?>">
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_MEASURE_ID_1" data-hidden="1" name="fTREATMENT_INAPgrid$o<?= $Grid->RowIndex ?>_MEASURE_ID_1" id="fTREATMENT_INAPgrid$o<?= $Grid->RowIndex ?>_MEASURE_ID_1" value="<?= HtmlEncode($Grid->MEASURE_ID_1->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->TRANS_ID_1->Visible) { // TRANS_ID_1 ?>
        <td data-name="TRANS_ID_1" <?= $Grid->TRANS_ID_1->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_TRANS_ID_1" class="form-group">
<input type="<?= $Grid->TRANS_ID_1->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_TRANS_ID_1" name="x<?= $Grid->RowIndex ?>_TRANS_ID_1" id="x<?= $Grid->RowIndex ?>_TRANS_ID_1" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->TRANS_ID_1->getPlaceHolder()) ?>" value="<?= $Grid->TRANS_ID_1->EditValue ?>"<?= $Grid->TRANS_ID_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->TRANS_ID_1->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_TRANS_ID_1" data-hidden="1" name="o<?= $Grid->RowIndex ?>_TRANS_ID_1" id="o<?= $Grid->RowIndex ?>_TRANS_ID_1" value="<?= HtmlEncode($Grid->TRANS_ID_1->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_TRANS_ID_1" class="form-group">
<input type="<?= $Grid->TRANS_ID_1->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_TRANS_ID_1" name="x<?= $Grid->RowIndex ?>_TRANS_ID_1" id="x<?= $Grid->RowIndex ?>_TRANS_ID_1" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->TRANS_ID_1->getPlaceHolder()) ?>" value="<?= $Grid->TRANS_ID_1->EditValue ?>"<?= $Grid->TRANS_ID_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->TRANS_ID_1->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_TREATMENT_INAP_TRANS_ID_1">
<span<?= $Grid->TRANS_ID_1->viewAttributes() ?>>
<?= $Grid->TRANS_ID_1->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_TRANS_ID_1" data-hidden="1" name="fTREATMENT_INAPgrid$x<?= $Grid->RowIndex ?>_TRANS_ID_1" id="fTREATMENT_INAPgrid$x<?= $Grid->RowIndex ?>_TRANS_ID_1" value="<?= HtmlEncode($Grid->TRANS_ID_1->FormValue) ?>">
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_TRANS_ID_1" data-hidden="1" name="fTREATMENT_INAPgrid$o<?= $Grid->RowIndex ?>_TRANS_ID_1" id="fTREATMENT_INAPgrid$o<?= $Grid->RowIndex ?>_TRANS_ID_1" value="<?= HtmlEncode($Grid->TRANS_ID_1->OldValue) ?>">
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
loadjs.ready(["fTREATMENT_INAPgrid","load"], function () {
    fTREATMENT_INAPgrid.updateLists(<?= $Grid->RowIndex ?>);
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_TREATMENT_INAP", "data-rowtype" => ROWTYPE_ADD]);
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
<span id="el$rowindex$_TREATMENT_INAP_NO_REGISTRATION" class="form-group TREATMENT_INAP_NO_REGISTRATION">
<span<?= $Grid->NO_REGISTRATION->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->NO_REGISTRATION->getDisplayValue($Grid->NO_REGISTRATION->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" name="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" value="<?= HtmlEncode($Grid->NO_REGISTRATION->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_TREATMENT_INAP_NO_REGISTRATION" class="form-group TREATMENT_INAP_NO_REGISTRATION">
<div class="input-group ew-lookup-list">
    <div class="form-control ew-lookup-text" tabindex="-1" id="lu_x<?= $Grid->RowIndex ?>_NO_REGISTRATION"><?= EmptyValue(strval($Grid->NO_REGISTRATION->ViewValue)) ? $Language->phrase("PleaseSelect") : $Grid->NO_REGISTRATION->ViewValue ?></div>
    <div class="input-group-append">
        <button type="button" title="<?= HtmlEncode(str_replace("%s", RemoveHtml($Grid->NO_REGISTRATION->caption()), $Language->phrase("LookupLink", true))) ?>" class="ew-lookup-btn btn btn-default"<?= ($Grid->NO_REGISTRATION->ReadOnly || $Grid->NO_REGISTRATION->Disabled) ? " disabled" : "" ?> onclick="ew.modalLookupShow({lnk:this,el:'x<?= $Grid->RowIndex ?>_NO_REGISTRATION',m:0,n:10});"><i class="fas fa-search ew-icon"></i></button>
    </div>
</div>
<div class="invalid-feedback"><?= $Grid->NO_REGISTRATION->getErrorMessage() ?></div>
<?= $Grid->NO_REGISTRATION->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_NO_REGISTRATION") ?>
<input type="hidden" is="selection-list" data-table="TREATMENT_INAP" data-field="x_NO_REGISTRATION" data-type="text" data-multiple="0" data-lookup="1" data-value-separator="<?= $Grid->NO_REGISTRATION->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" id="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" value="<?= $Grid->NO_REGISTRATION->CurrentValue ?>"<?= $Grid->NO_REGISTRATION->editAttributes() ?>>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_TREATMENT_INAP_NO_REGISTRATION" class="form-group TREATMENT_INAP_NO_REGISTRATION">
<span<?= $Grid->NO_REGISTRATION->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->NO_REGISTRATION->getDisplayValue($Grid->NO_REGISTRATION->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_NO_REGISTRATION" data-hidden="1" name="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" id="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" value="<?= HtmlEncode($Grid->NO_REGISTRATION->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_NO_REGISTRATION" data-hidden="1" name="o<?= $Grid->RowIndex ?>_NO_REGISTRATION" id="o<?= $Grid->RowIndex ?>_NO_REGISTRATION" value="<?= HtmlEncode($Grid->NO_REGISTRATION->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->VISIT_ID->Visible) { // VISIT_ID ?>
        <td data-name="VISIT_ID">
<?php if (!$Grid->isConfirm()) { ?>
<?php if ($Grid->VISIT_ID->getSessionValue() != "") { ?>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_VISIT_ID" name="x<?= $Grid->RowIndex ?>_VISIT_ID" value="<?= HtmlEncode($Grid->VISIT_ID->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_TREATMENT_INAP_VISIT_ID" class="form-group TREATMENT_INAP_VISIT_ID">
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_VISIT_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_VISIT_ID" id="x<?= $Grid->RowIndex ?>_VISIT_ID" value="<?= HtmlEncode($Grid->VISIT_ID->CurrentValue) ?>">
</span>
<?php } ?>
<?php } else { ?>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_VISIT_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_VISIT_ID" id="x<?= $Grid->RowIndex ?>_VISIT_ID" value="<?= HtmlEncode($Grid->VISIT_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_VISIT_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_VISIT_ID" id="o<?= $Grid->RowIndex ?>_VISIT_ID" value="<?= HtmlEncode($Grid->VISIT_ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->TARIF_ID->Visible) { // TARIF_ID ?>
        <td data-name="TARIF_ID">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_TREATMENT_INAP_TARIF_ID" class="form-group TREATMENT_INAP_TARIF_ID">
<?php $Grid->TARIF_ID->EditAttrs->prepend("onchange", "ew.autoFill(this);"); ?>
<div class="input-group ew-lookup-list">
    <div class="form-control ew-lookup-text" tabindex="-1" id="lu_x<?= $Grid->RowIndex ?>_TARIF_ID"><?= EmptyValue(strval($Grid->TARIF_ID->ViewValue)) ? $Language->phrase("PleaseSelect") : $Grid->TARIF_ID->ViewValue ?></div>
    <div class="input-group-append">
        <button type="button" title="<?= HtmlEncode(str_replace("%s", RemoveHtml($Grid->TARIF_ID->caption()), $Language->phrase("LookupLink", true))) ?>" class="ew-lookup-btn btn btn-default"<?= ($Grid->TARIF_ID->ReadOnly || $Grid->TARIF_ID->Disabled) ? " disabled" : "" ?> onclick="ew.modalLookupShow({lnk:this,el:'x<?= $Grid->RowIndex ?>_TARIF_ID',m:0,n:10});"><i class="fas fa-search ew-icon"></i></button>
    </div>
</div>
<div class="invalid-feedback"><?= $Grid->TARIF_ID->getErrorMessage() ?></div>
<?= $Grid->TARIF_ID->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_TARIF_ID") ?>
<input type="hidden" is="selection-list" data-table="TREATMENT_INAP" data-field="x_TARIF_ID" data-type="text" data-multiple="0" data-lookup="1" data-value-separator="<?= $Grid->TARIF_ID->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_TARIF_ID" id="x<?= $Grid->RowIndex ?>_TARIF_ID" value="<?= $Grid->TARIF_ID->CurrentValue ?>"<?= $Grid->TARIF_ID->editAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_TREATMENT_INAP_TARIF_ID" class="form-group TREATMENT_INAP_TARIF_ID">
<span<?= $Grid->TARIF_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->TARIF_ID->getDisplayValue($Grid->TARIF_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_TARIF_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_TARIF_ID" id="x<?= $Grid->RowIndex ?>_TARIF_ID" value="<?= HtmlEncode($Grid->TARIF_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_TARIF_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_TARIF_ID" id="o<?= $Grid->RowIndex ?>_TARIF_ID" value="<?= HtmlEncode($Grid->TARIF_ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->CLINIC_ID->Visible) { // CLINIC_ID ?>
        <td data-name="CLINIC_ID">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_TREATMENT_INAP_CLINIC_ID" class="form-group TREATMENT_INAP_CLINIC_ID">
    <select
        id="x<?= $Grid->RowIndex ?>_CLINIC_ID"
        name="x<?= $Grid->RowIndex ?>_CLINIC_ID"
        class="form-control ew-select<?= $Grid->CLINIC_ID->isInvalidClass() ?>"
        data-select2-id="TREATMENT_INAP_x<?= $Grid->RowIndex ?>_CLINIC_ID"
        data-table="TREATMENT_INAP"
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
    var el = document.querySelector("select[data-select2-id='TREATMENT_INAP_x<?= $Grid->RowIndex ?>_CLINIC_ID']"),
        options = { name: "x<?= $Grid->RowIndex ?>_CLINIC_ID", selectId: "TREATMENT_INAP_x<?= $Grid->RowIndex ?>_CLINIC_ID", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.TREATMENT_INAP.fields.CLINIC_ID.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_TREATMENT_INAP_CLINIC_ID" class="form-group TREATMENT_INAP_CLINIC_ID">
<span<?= $Grid->CLINIC_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->CLINIC_ID->getDisplayValue($Grid->CLINIC_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_CLINIC_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_CLINIC_ID" id="x<?= $Grid->RowIndex ?>_CLINIC_ID" value="<?= HtmlEncode($Grid->CLINIC_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_CLINIC_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_CLINIC_ID" id="o<?= $Grid->RowIndex ?>_CLINIC_ID" value="<?= HtmlEncode($Grid->CLINIC_ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->TREATMENT->Visible) { // TREATMENT ?>
        <td data-name="TREATMENT">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_TREATMENT_INAP_TREATMENT" class="form-group TREATMENT_INAP_TREATMENT">
<input type="<?= $Grid->TREATMENT->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_TREATMENT" name="x<?= $Grid->RowIndex ?>_TREATMENT" id="x<?= $Grid->RowIndex ?>_TREATMENT" size="30" maxlength="200" placeholder="<?= HtmlEncode($Grid->TREATMENT->getPlaceHolder()) ?>" value="<?= $Grid->TREATMENT->EditValue ?>"<?= $Grid->TREATMENT->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->TREATMENT->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_TREATMENT_INAP_TREATMENT" class="form-group TREATMENT_INAP_TREATMENT">
<span<?= $Grid->TREATMENT->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->TREATMENT->getDisplayValue($Grid->TREATMENT->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_TREATMENT" data-hidden="1" name="x<?= $Grid->RowIndex ?>_TREATMENT" id="x<?= $Grid->RowIndex ?>_TREATMENT" value="<?= HtmlEncode($Grid->TREATMENT->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_TREATMENT" data-hidden="1" name="o<?= $Grid->RowIndex ?>_TREATMENT" id="o<?= $Grid->RowIndex ?>_TREATMENT" value="<?= HtmlEncode($Grid->TREATMENT->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->TREAT_DATE->Visible) { // TREAT_DATE ?>
        <td data-name="TREAT_DATE">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_TREATMENT_INAP_TREAT_DATE" class="form-group TREATMENT_INAP_TREAT_DATE">
<input type="<?= $Grid->TREAT_DATE->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_TREAT_DATE" data-format="11" name="x<?= $Grid->RowIndex ?>_TREAT_DATE" id="x<?= $Grid->RowIndex ?>_TREAT_DATE" placeholder="<?= HtmlEncode($Grid->TREAT_DATE->getPlaceHolder()) ?>" value="<?= $Grid->TREAT_DATE->EditValue ?>"<?= $Grid->TREAT_DATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->TREAT_DATE->getErrorMessage() ?></div>
<?php if (!$Grid->TREAT_DATE->ReadOnly && !$Grid->TREAT_DATE->Disabled && !isset($Grid->TREAT_DATE->EditAttrs["readonly"]) && !isset($Grid->TREAT_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fTREATMENT_INAPgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fTREATMENT_INAPgrid", "x<?= $Grid->RowIndex ?>_TREAT_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":11});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_TREATMENT_INAP_TREAT_DATE" class="form-group TREATMENT_INAP_TREAT_DATE">
<span<?= $Grid->TREAT_DATE->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->TREAT_DATE->getDisplayValue($Grid->TREAT_DATE->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_TREAT_DATE" data-hidden="1" name="x<?= $Grid->RowIndex ?>_TREAT_DATE" id="x<?= $Grid->RowIndex ?>_TREAT_DATE" value="<?= HtmlEncode($Grid->TREAT_DATE->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_TREAT_DATE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_TREAT_DATE" id="o<?= $Grid->RowIndex ?>_TREAT_DATE" value="<?= HtmlEncode($Grid->TREAT_DATE->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->QUANTITY->Visible) { // QUANTITY ?>
        <td data-name="QUANTITY">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_TREATMENT_INAP_QUANTITY" class="form-group TREATMENT_INAP_QUANTITY">
<input type="<?= $Grid->QUANTITY->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_QUANTITY" name="x<?= $Grid->RowIndex ?>_QUANTITY" id="x<?= $Grid->RowIndex ?>_QUANTITY" size="30" placeholder="<?= HtmlEncode($Grid->QUANTITY->getPlaceHolder()) ?>" value="<?= $Grid->QUANTITY->EditValue ?>"<?= $Grid->QUANTITY->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->QUANTITY->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_TREATMENT_INAP_QUANTITY" class="form-group TREATMENT_INAP_QUANTITY">
<span<?= $Grid->QUANTITY->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->QUANTITY->getDisplayValue($Grid->QUANTITY->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_QUANTITY" data-hidden="1" name="x<?= $Grid->RowIndex ?>_QUANTITY" id="x<?= $Grid->RowIndex ?>_QUANTITY" value="<?= HtmlEncode($Grid->QUANTITY->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_QUANTITY" data-hidden="1" name="o<?= $Grid->RowIndex ?>_QUANTITY" id="o<?= $Grid->RowIndex ?>_QUANTITY" value="<?= HtmlEncode($Grid->QUANTITY->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->TRANS_ID->Visible) { // TRANS_ID ?>
        <td data-name="TRANS_ID">
<?php if (!$Grid->isConfirm()) { ?>
<?php if ($Grid->TRANS_ID->getSessionValue() != "") { ?>
<span id="el$rowindex$_TREATMENT_INAP_TRANS_ID" class="form-group TREATMENT_INAP_TRANS_ID">
<span<?= $Grid->TRANS_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->TRANS_ID->getDisplayValue($Grid->TRANS_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_TRANS_ID" name="x<?= $Grid->RowIndex ?>_TRANS_ID" value="<?= HtmlEncode($Grid->TRANS_ID->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_TREATMENT_INAP_TRANS_ID" class="form-group TREATMENT_INAP_TRANS_ID">
<input type="<?= $Grid->TRANS_ID->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_TRANS_ID" name="x<?= $Grid->RowIndex ?>_TRANS_ID" id="x<?= $Grid->RowIndex ?>_TRANS_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->TRANS_ID->getPlaceHolder()) ?>" value="<?= $Grid->TRANS_ID->EditValue ?>"<?= $Grid->TRANS_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->TRANS_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_TREATMENT_INAP_TRANS_ID" class="form-group TREATMENT_INAP_TRANS_ID">
<span<?= $Grid->TRANS_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->TRANS_ID->getDisplayValue($Grid->TRANS_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_TRANS_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_TRANS_ID" id="x<?= $Grid->RowIndex ?>_TRANS_ID" value="<?= HtmlEncode($Grid->TRANS_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_TRANS_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_TRANS_ID" id="o<?= $Grid->RowIndex ?>_TRANS_ID" value="<?= HtmlEncode($Grid->TRANS_ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->ID->Visible) { // ID ?>
        <td data-name="ID">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_TREATMENT_INAP_ID" class="form-group TREATMENT_INAP_ID"></span>
<?php } else { ?>
<span id="el$rowindex$_TREATMENT_INAP_ID" class="form-group TREATMENT_INAP_ID">
<span<?= $Grid->ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->ID->getDisplayValue($Grid->ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_ID" id="x<?= $Grid->RowIndex ?>_ID" value="<?= HtmlEncode($Grid->ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ID" id="o<?= $Grid->RowIndex ?>_ID" value="<?= HtmlEncode($Grid->ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->AMOUNT->Visible) { // AMOUNT ?>
        <td data-name="AMOUNT">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_TREATMENT_INAP_AMOUNT" class="form-group TREATMENT_INAP_AMOUNT">
<input type="<?= $Grid->AMOUNT->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_AMOUNT" name="x<?= $Grid->RowIndex ?>_AMOUNT" id="x<?= $Grid->RowIndex ?>_AMOUNT" size="30" placeholder="<?= HtmlEncode($Grid->AMOUNT->getPlaceHolder()) ?>" value="<?= $Grid->AMOUNT->EditValue ?>"<?= $Grid->AMOUNT->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->AMOUNT->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_TREATMENT_INAP_AMOUNT" class="form-group TREATMENT_INAP_AMOUNT">
<span<?= $Grid->AMOUNT->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->AMOUNT->getDisplayValue($Grid->AMOUNT->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_AMOUNT" data-hidden="1" name="x<?= $Grid->RowIndex ?>_AMOUNT" id="x<?= $Grid->RowIndex ?>_AMOUNT" value="<?= HtmlEncode($Grid->AMOUNT->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_AMOUNT" data-hidden="1" name="o<?= $Grid->RowIndex ?>_AMOUNT" id="o<?= $Grid->RowIndex ?>_AMOUNT" value="<?= HtmlEncode($Grid->AMOUNT->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->POKOK_JUAL->Visible) { // POKOK_JUAL ?>
        <td data-name="POKOK_JUAL">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_TREATMENT_INAP_POKOK_JUAL" class="form-group TREATMENT_INAP_POKOK_JUAL">
<input type="<?= $Grid->POKOK_JUAL->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_POKOK_JUAL" name="x<?= $Grid->RowIndex ?>_POKOK_JUAL" id="x<?= $Grid->RowIndex ?>_POKOK_JUAL" size="30" placeholder="<?= HtmlEncode($Grid->POKOK_JUAL->getPlaceHolder()) ?>" value="<?= $Grid->POKOK_JUAL->EditValue ?>"<?= $Grid->POKOK_JUAL->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->POKOK_JUAL->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_TREATMENT_INAP_POKOK_JUAL" class="form-group TREATMENT_INAP_POKOK_JUAL">
<span<?= $Grid->POKOK_JUAL->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->POKOK_JUAL->getDisplayValue($Grid->POKOK_JUAL->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_POKOK_JUAL" data-hidden="1" name="x<?= $Grid->RowIndex ?>_POKOK_JUAL" id="x<?= $Grid->RowIndex ?>_POKOK_JUAL" value="<?= HtmlEncode($Grid->POKOK_JUAL->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_POKOK_JUAL" data-hidden="1" name="o<?= $Grid->RowIndex ?>_POKOK_JUAL" id="o<?= $Grid->RowIndex ?>_POKOK_JUAL" value="<?= HtmlEncode($Grid->POKOK_JUAL->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->PPN->Visible) { // PPN ?>
        <td data-name="PPN">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_TREATMENT_INAP_PPN" class="form-group TREATMENT_INAP_PPN">
<input type="<?= $Grid->PPN->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_PPN" name="x<?= $Grid->RowIndex ?>_PPN" id="x<?= $Grid->RowIndex ?>_PPN" size="30" placeholder="<?= HtmlEncode($Grid->PPN->getPlaceHolder()) ?>" value="<?= $Grid->PPN->EditValue ?>"<?= $Grid->PPN->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->PPN->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_TREATMENT_INAP_PPN" class="form-group TREATMENT_INAP_PPN">
<span<?= $Grid->PPN->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->PPN->getDisplayValue($Grid->PPN->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_PPN" data-hidden="1" name="x<?= $Grid->RowIndex ?>_PPN" id="x<?= $Grid->RowIndex ?>_PPN" value="<?= HtmlEncode($Grid->PPN->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_PPN" data-hidden="1" name="o<?= $Grid->RowIndex ?>_PPN" id="o<?= $Grid->RowIndex ?>_PPN" value="<?= HtmlEncode($Grid->PPN->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->SUBSIDI->Visible) { // SUBSIDI ?>
        <td data-name="SUBSIDI">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_TREATMENT_INAP_SUBSIDI" class="form-group TREATMENT_INAP_SUBSIDI">
<input type="<?= $Grid->SUBSIDI->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_SUBSIDI" name="x<?= $Grid->RowIndex ?>_SUBSIDI" id="x<?= $Grid->RowIndex ?>_SUBSIDI" size="30" placeholder="<?= HtmlEncode($Grid->SUBSIDI->getPlaceHolder()) ?>" value="<?= $Grid->SUBSIDI->EditValue ?>"<?= $Grid->SUBSIDI->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->SUBSIDI->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_TREATMENT_INAP_SUBSIDI" class="form-group TREATMENT_INAP_SUBSIDI">
<span<?= $Grid->SUBSIDI->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->SUBSIDI->getDisplayValue($Grid->SUBSIDI->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_SUBSIDI" data-hidden="1" name="x<?= $Grid->RowIndex ?>_SUBSIDI" id="x<?= $Grid->RowIndex ?>_SUBSIDI" value="<?= HtmlEncode($Grid->SUBSIDI->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_SUBSIDI" data-hidden="1" name="o<?= $Grid->RowIndex ?>_SUBSIDI" id="o<?= $Grid->RowIndex ?>_SUBSIDI" value="<?= HtmlEncode($Grid->SUBSIDI->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->PRINT_DATE->Visible) { // PRINT_DATE ?>
        <td data-name="PRINT_DATE">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_TREATMENT_INAP_PRINT_DATE" class="form-group TREATMENT_INAP_PRINT_DATE">
<input type="<?= $Grid->PRINT_DATE->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_PRINT_DATE" name="x<?= $Grid->RowIndex ?>_PRINT_DATE" id="x<?= $Grid->RowIndex ?>_PRINT_DATE" placeholder="<?= HtmlEncode($Grid->PRINT_DATE->getPlaceHolder()) ?>" value="<?= $Grid->PRINT_DATE->EditValue ?>"<?= $Grid->PRINT_DATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->PRINT_DATE->getErrorMessage() ?></div>
<?php if (!$Grid->PRINT_DATE->ReadOnly && !$Grid->PRINT_DATE->Disabled && !isset($Grid->PRINT_DATE->EditAttrs["readonly"]) && !isset($Grid->PRINT_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fTREATMENT_INAPgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fTREATMENT_INAPgrid", "x<?= $Grid->RowIndex ?>_PRINT_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_TREATMENT_INAP_PRINT_DATE" class="form-group TREATMENT_INAP_PRINT_DATE">
<span<?= $Grid->PRINT_DATE->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->PRINT_DATE->getDisplayValue($Grid->PRINT_DATE->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_PRINT_DATE" data-hidden="1" name="x<?= $Grid->RowIndex ?>_PRINT_DATE" id="x<?= $Grid->RowIndex ?>_PRINT_DATE" value="<?= HtmlEncode($Grid->PRINT_DATE->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_PRINT_DATE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_PRINT_DATE" id="o<?= $Grid->RowIndex ?>_PRINT_DATE" value="<?= HtmlEncode($Grid->PRINT_DATE->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->ISCETAK->Visible) { // ISCETAK ?>
        <td data-name="ISCETAK">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_TREATMENT_INAP_ISCETAK" class="form-group TREATMENT_INAP_ISCETAK">
<input type="<?= $Grid->ISCETAK->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_ISCETAK" name="x<?= $Grid->RowIndex ?>_ISCETAK" id="x<?= $Grid->RowIndex ?>_ISCETAK" size="30" maxlength="1" placeholder="<?= HtmlEncode($Grid->ISCETAK->getPlaceHolder()) ?>" value="<?= $Grid->ISCETAK->EditValue ?>"<?= $Grid->ISCETAK->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ISCETAK->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_TREATMENT_INAP_ISCETAK" class="form-group TREATMENT_INAP_ISCETAK">
<span<?= $Grid->ISCETAK->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->ISCETAK->getDisplayValue($Grid->ISCETAK->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_ISCETAK" data-hidden="1" name="x<?= $Grid->RowIndex ?>_ISCETAK" id="x<?= $Grid->RowIndex ?>_ISCETAK" value="<?= HtmlEncode($Grid->ISCETAK->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_ISCETAK" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ISCETAK" id="o<?= $Grid->RowIndex ?>_ISCETAK" value="<?= HtmlEncode($Grid->ISCETAK->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->NOTA_NO->Visible) { // NOTA_NO ?>
        <td data-name="NOTA_NO">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_TREATMENT_INAP_NOTA_NO" class="form-group TREATMENT_INAP_NOTA_NO">
<input type="<?= $Grid->NOTA_NO->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_NOTA_NO" name="x<?= $Grid->RowIndex ?>_NOTA_NO" id="x<?= $Grid->RowIndex ?>_NOTA_NO" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->NOTA_NO->getPlaceHolder()) ?>" value="<?= $Grid->NOTA_NO->EditValue ?>"<?= $Grid->NOTA_NO->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->NOTA_NO->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_TREATMENT_INAP_NOTA_NO" class="form-group TREATMENT_INAP_NOTA_NO">
<span<?= $Grid->NOTA_NO->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->NOTA_NO->getDisplayValue($Grid->NOTA_NO->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_NOTA_NO" data-hidden="1" name="x<?= $Grid->RowIndex ?>_NOTA_NO" id="x<?= $Grid->RowIndex ?>_NOTA_NO" value="<?= HtmlEncode($Grid->NOTA_NO->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_NOTA_NO" data-hidden="1" name="o<?= $Grid->RowIndex ?>_NOTA_NO" id="o<?= $Grid->RowIndex ?>_NOTA_NO" value="<?= HtmlEncode($Grid->NOTA_NO->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->KUITANSI_ID->Visible) { // KUITANSI_ID ?>
        <td data-name="KUITANSI_ID">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_TREATMENT_INAP_KUITANSI_ID" class="form-group TREATMENT_INAP_KUITANSI_ID">
<input type="<?= $Grid->KUITANSI_ID->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_KUITANSI_ID" name="x<?= $Grid->RowIndex ?>_KUITANSI_ID" id="x<?= $Grid->RowIndex ?>_KUITANSI_ID" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->KUITANSI_ID->getPlaceHolder()) ?>" value="<?= $Grid->KUITANSI_ID->EditValue ?>"<?= $Grid->KUITANSI_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->KUITANSI_ID->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_TREATMENT_INAP_KUITANSI_ID" class="form-group TREATMENT_INAP_KUITANSI_ID">
<span<?= $Grid->KUITANSI_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->KUITANSI_ID->getDisplayValue($Grid->KUITANSI_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_KUITANSI_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_KUITANSI_ID" id="x<?= $Grid->RowIndex ?>_KUITANSI_ID" value="<?= HtmlEncode($Grid->KUITANSI_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_KUITANSI_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_KUITANSI_ID" id="o<?= $Grid->RowIndex ?>_KUITANSI_ID" value="<?= HtmlEncode($Grid->KUITANSI_ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->amount_paid->Visible) { // amount_paid ?>
        <td data-name="amount_paid">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_TREATMENT_INAP_amount_paid" class="form-group TREATMENT_INAP_amount_paid">
<input type="<?= $Grid->amount_paid->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_amount_paid" name="x<?= $Grid->RowIndex ?>_amount_paid" id="x<?= $Grid->RowIndex ?>_amount_paid" size="30" placeholder="<?= HtmlEncode($Grid->amount_paid->getPlaceHolder()) ?>" value="<?= $Grid->amount_paid->EditValue ?>"<?= $Grid->amount_paid->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->amount_paid->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_TREATMENT_INAP_amount_paid" class="form-group TREATMENT_INAP_amount_paid">
<span<?= $Grid->amount_paid->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->amount_paid->getDisplayValue($Grid->amount_paid->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_amount_paid" data-hidden="1" name="x<?= $Grid->RowIndex ?>_amount_paid" id="x<?= $Grid->RowIndex ?>_amount_paid" value="<?= HtmlEncode($Grid->amount_paid->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_amount_paid" data-hidden="1" name="o<?= $Grid->RowIndex ?>_amount_paid" id="o<?= $Grid->RowIndex ?>_amount_paid" value="<?= HtmlEncode($Grid->amount_paid->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->sell_price->Visible) { // sell_price ?>
        <td data-name="sell_price">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_TREATMENT_INAP_sell_price" class="form-group TREATMENT_INAP_sell_price">
<input type="<?= $Grid->sell_price->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_sell_price" name="x<?= $Grid->RowIndex ?>_sell_price" id="x<?= $Grid->RowIndex ?>_sell_price" size="30" placeholder="<?= HtmlEncode($Grid->sell_price->getPlaceHolder()) ?>" value="<?= $Grid->sell_price->EditValue ?>"<?= $Grid->sell_price->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->sell_price->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_TREATMENT_INAP_sell_price" class="form-group TREATMENT_INAP_sell_price">
<span<?= $Grid->sell_price->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->sell_price->getDisplayValue($Grid->sell_price->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_sell_price" data-hidden="1" name="x<?= $Grid->RowIndex ?>_sell_price" id="x<?= $Grid->RowIndex ?>_sell_price" value="<?= HtmlEncode($Grid->sell_price->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_sell_price" data-hidden="1" name="o<?= $Grid->RowIndex ?>_sell_price" id="o<?= $Grid->RowIndex ?>_sell_price" value="<?= HtmlEncode($Grid->sell_price->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->diskon->Visible) { // diskon ?>
        <td data-name="diskon">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_TREATMENT_INAP_diskon" class="form-group TREATMENT_INAP_diskon">
<input type="<?= $Grid->diskon->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_diskon" name="x<?= $Grid->RowIndex ?>_diskon" id="x<?= $Grid->RowIndex ?>_diskon" size="30" placeholder="<?= HtmlEncode($Grid->diskon->getPlaceHolder()) ?>" value="<?= $Grid->diskon->EditValue ?>"<?= $Grid->diskon->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->diskon->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_TREATMENT_INAP_diskon" class="form-group TREATMENT_INAP_diskon">
<span<?= $Grid->diskon->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->diskon->getDisplayValue($Grid->diskon->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_diskon" data-hidden="1" name="x<?= $Grid->RowIndex ?>_diskon" id="x<?= $Grid->RowIndex ?>_diskon" value="<?= HtmlEncode($Grid->diskon->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_diskon" data-hidden="1" name="o<?= $Grid->RowIndex ?>_diskon" id="o<?= $Grid->RowIndex ?>_diskon" value="<?= HtmlEncode($Grid->diskon->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->TAGIHAN->Visible) { // TAGIHAN ?>
        <td data-name="TAGIHAN">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_TREATMENT_INAP_TAGIHAN" class="form-group TREATMENT_INAP_TAGIHAN">
<input type="<?= $Grid->TAGIHAN->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_TAGIHAN" name="x<?= $Grid->RowIndex ?>_TAGIHAN" id="x<?= $Grid->RowIndex ?>_TAGIHAN" size="30" placeholder="<?= HtmlEncode($Grid->TAGIHAN->getPlaceHolder()) ?>" value="<?= $Grid->TAGIHAN->EditValue ?>"<?= $Grid->TAGIHAN->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->TAGIHAN->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_TREATMENT_INAP_TAGIHAN" class="form-group TREATMENT_INAP_TAGIHAN">
<span<?= $Grid->TAGIHAN->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->TAGIHAN->getDisplayValue($Grid->TAGIHAN->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_TAGIHAN" data-hidden="1" name="x<?= $Grid->RowIndex ?>_TAGIHAN" id="x<?= $Grid->RowIndex ?>_TAGIHAN" value="<?= HtmlEncode($Grid->TAGIHAN->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_TAGIHAN" data-hidden="1" name="o<?= $Grid->RowIndex ?>_TAGIHAN" id="o<?= $Grid->RowIndex ?>_TAGIHAN" value="<?= HtmlEncode($Grid->TAGIHAN->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->CLINIC_TYPE->Visible) { // CLINIC_TYPE ?>
        <td data-name="CLINIC_TYPE">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_TREATMENT_INAP_CLINIC_TYPE" class="form-group TREATMENT_INAP_CLINIC_TYPE">
<input type="<?= $Grid->CLINIC_TYPE->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_CLINIC_TYPE" name="x<?= $Grid->RowIndex ?>_CLINIC_TYPE" id="x<?= $Grid->RowIndex ?>_CLINIC_TYPE" size="30" placeholder="<?= HtmlEncode($Grid->CLINIC_TYPE->getPlaceHolder()) ?>" value="<?= $Grid->CLINIC_TYPE->EditValue ?>"<?= $Grid->CLINIC_TYPE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->CLINIC_TYPE->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_TREATMENT_INAP_CLINIC_TYPE" class="form-group TREATMENT_INAP_CLINIC_TYPE">
<span<?= $Grid->CLINIC_TYPE->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->CLINIC_TYPE->getDisplayValue($Grid->CLINIC_TYPE->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_CLINIC_TYPE" data-hidden="1" name="x<?= $Grid->RowIndex ?>_CLINIC_TYPE" id="x<?= $Grid->RowIndex ?>_CLINIC_TYPE" value="<?= HtmlEncode($Grid->CLINIC_TYPE->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_CLINIC_TYPE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_CLINIC_TYPE" id="o<?= $Grid->RowIndex ?>_CLINIC_TYPE" value="<?= HtmlEncode($Grid->CLINIC_TYPE->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->ID_1->Visible) { // ID_1 ?>
        <td data-name="ID_1">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_TREATMENT_INAP_ID_1" class="form-group TREATMENT_INAP_ID_1"></span>
<?php } else { ?>
<span id="el$rowindex$_TREATMENT_INAP_ID_1" class="form-group TREATMENT_INAP_ID_1">
<span<?= $Grid->ID_1->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->ID_1->getDisplayValue($Grid->ID_1->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_ID_1" data-hidden="1" name="x<?= $Grid->RowIndex ?>_ID_1" id="x<?= $Grid->RowIndex ?>_ID_1" value="<?= HtmlEncode($Grid->ID_1->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_ID_1" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ID_1" id="o<?= $Grid->RowIndex ?>_ID_1" value="<?= HtmlEncode($Grid->ID_1->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->ORG_UNIT_CODE->Visible) { // ORG_UNIT_CODE ?>
        <td data-name="ORG_UNIT_CODE">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_TREATMENT_INAP_ORG_UNIT_CODE" class="form-group TREATMENT_INAP_ORG_UNIT_CODE">
<input type="<?= $Grid->ORG_UNIT_CODE->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_ORG_UNIT_CODE" name="x<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" id="x<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->ORG_UNIT_CODE->getPlaceHolder()) ?>" value="<?= $Grid->ORG_UNIT_CODE->EditValue ?>"<?= $Grid->ORG_UNIT_CODE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ORG_UNIT_CODE->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_TREATMENT_INAP_ORG_UNIT_CODE" class="form-group TREATMENT_INAP_ORG_UNIT_CODE">
<span<?= $Grid->ORG_UNIT_CODE->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->ORG_UNIT_CODE->getDisplayValue($Grid->ORG_UNIT_CODE->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_ORG_UNIT_CODE" data-hidden="1" name="x<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" id="x<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" value="<?= HtmlEncode($Grid->ORG_UNIT_CODE->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_ORG_UNIT_CODE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" id="o<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" value="<?= HtmlEncode($Grid->ORG_UNIT_CODE->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->BILL_ID_1->Visible) { // BILL_ID_1 ?>
        <td data-name="BILL_ID_1">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_TREATMENT_INAP_BILL_ID_1" class="form-group TREATMENT_INAP_BILL_ID_1">
<input type="<?= $Grid->BILL_ID_1->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_BILL_ID_1" name="x<?= $Grid->RowIndex ?>_BILL_ID_1" id="x<?= $Grid->RowIndex ?>_BILL_ID_1" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->BILL_ID_1->getPlaceHolder()) ?>" value="<?= $Grid->BILL_ID_1->EditValue ?>"<?= $Grid->BILL_ID_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->BILL_ID_1->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_TREATMENT_INAP_BILL_ID_1" class="form-group TREATMENT_INAP_BILL_ID_1">
<span<?= $Grid->BILL_ID_1->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->BILL_ID_1->getDisplayValue($Grid->BILL_ID_1->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_BILL_ID_1" data-hidden="1" name="x<?= $Grid->RowIndex ?>_BILL_ID_1" id="x<?= $Grid->RowIndex ?>_BILL_ID_1" value="<?= HtmlEncode($Grid->BILL_ID_1->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_BILL_ID_1" data-hidden="1" name="o<?= $Grid->RowIndex ?>_BILL_ID_1" id="o<?= $Grid->RowIndex ?>_BILL_ID_1" value="<?= HtmlEncode($Grid->BILL_ID_1->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->NO_REGISTRATION_1->Visible) { // NO_REGISTRATION_1 ?>
        <td data-name="NO_REGISTRATION_1">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_TREATMENT_INAP_NO_REGISTRATION_1" class="form-group TREATMENT_INAP_NO_REGISTRATION_1">
<input type="<?= $Grid->NO_REGISTRATION_1->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_NO_REGISTRATION_1" name="x<?= $Grid->RowIndex ?>_NO_REGISTRATION_1" id="x<?= $Grid->RowIndex ?>_NO_REGISTRATION_1" size="30" maxlength="25" placeholder="<?= HtmlEncode($Grid->NO_REGISTRATION_1->getPlaceHolder()) ?>" value="<?= $Grid->NO_REGISTRATION_1->EditValue ?>"<?= $Grid->NO_REGISTRATION_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->NO_REGISTRATION_1->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_TREATMENT_INAP_NO_REGISTRATION_1" class="form-group TREATMENT_INAP_NO_REGISTRATION_1">
<span<?= $Grid->NO_REGISTRATION_1->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->NO_REGISTRATION_1->getDisplayValue($Grid->NO_REGISTRATION_1->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_NO_REGISTRATION_1" data-hidden="1" name="x<?= $Grid->RowIndex ?>_NO_REGISTRATION_1" id="x<?= $Grid->RowIndex ?>_NO_REGISTRATION_1" value="<?= HtmlEncode($Grid->NO_REGISTRATION_1->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_NO_REGISTRATION_1" data-hidden="1" name="o<?= $Grid->RowIndex ?>_NO_REGISTRATION_1" id="o<?= $Grid->RowIndex ?>_NO_REGISTRATION_1" value="<?= HtmlEncode($Grid->NO_REGISTRATION_1->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->VISIT_ID_1->Visible) { // VISIT_ID_1 ?>
        <td data-name="VISIT_ID_1">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_TREATMENT_INAP_VISIT_ID_1" class="form-group TREATMENT_INAP_VISIT_ID_1">
<input type="<?= $Grid->VISIT_ID_1->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_VISIT_ID_1" name="x<?= $Grid->RowIndex ?>_VISIT_ID_1" id="x<?= $Grid->RowIndex ?>_VISIT_ID_1" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->VISIT_ID_1->getPlaceHolder()) ?>" value="<?= $Grid->VISIT_ID_1->EditValue ?>"<?= $Grid->VISIT_ID_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->VISIT_ID_1->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_TREATMENT_INAP_VISIT_ID_1" class="form-group TREATMENT_INAP_VISIT_ID_1">
<span<?= $Grid->VISIT_ID_1->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->VISIT_ID_1->getDisplayValue($Grid->VISIT_ID_1->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_VISIT_ID_1" data-hidden="1" name="x<?= $Grid->RowIndex ?>_VISIT_ID_1" id="x<?= $Grid->RowIndex ?>_VISIT_ID_1" value="<?= HtmlEncode($Grid->VISIT_ID_1->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_VISIT_ID_1" data-hidden="1" name="o<?= $Grid->RowIndex ?>_VISIT_ID_1" id="o<?= $Grid->RowIndex ?>_VISIT_ID_1" value="<?= HtmlEncode($Grid->VISIT_ID_1->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->TARIF_ID_1->Visible) { // TARIF_ID_1 ?>
        <td data-name="TARIF_ID_1">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_TREATMENT_INAP_TARIF_ID_1" class="form-group TREATMENT_INAP_TARIF_ID_1">
<input type="<?= $Grid->TARIF_ID_1->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_TARIF_ID_1" name="x<?= $Grid->RowIndex ?>_TARIF_ID_1" id="x<?= $Grid->RowIndex ?>_TARIF_ID_1" size="30" maxlength="25" placeholder="<?= HtmlEncode($Grid->TARIF_ID_1->getPlaceHolder()) ?>" value="<?= $Grid->TARIF_ID_1->EditValue ?>"<?= $Grid->TARIF_ID_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->TARIF_ID_1->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_TREATMENT_INAP_TARIF_ID_1" class="form-group TREATMENT_INAP_TARIF_ID_1">
<span<?= $Grid->TARIF_ID_1->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->TARIF_ID_1->getDisplayValue($Grid->TARIF_ID_1->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_TARIF_ID_1" data-hidden="1" name="x<?= $Grid->RowIndex ?>_TARIF_ID_1" id="x<?= $Grid->RowIndex ?>_TARIF_ID_1" value="<?= HtmlEncode($Grid->TARIF_ID_1->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_TARIF_ID_1" data-hidden="1" name="o<?= $Grid->RowIndex ?>_TARIF_ID_1" id="o<?= $Grid->RowIndex ?>_TARIF_ID_1" value="<?= HtmlEncode($Grid->TARIF_ID_1->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->CLASS_ID_1->Visible) { // CLASS_ID_1 ?>
        <td data-name="CLASS_ID_1">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_TREATMENT_INAP_CLASS_ID_1" class="form-group TREATMENT_INAP_CLASS_ID_1">
<input type="<?= $Grid->CLASS_ID_1->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_CLASS_ID_1" name="x<?= $Grid->RowIndex ?>_CLASS_ID_1" id="x<?= $Grid->RowIndex ?>_CLASS_ID_1" size="30" placeholder="<?= HtmlEncode($Grid->CLASS_ID_1->getPlaceHolder()) ?>" value="<?= $Grid->CLASS_ID_1->EditValue ?>"<?= $Grid->CLASS_ID_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->CLASS_ID_1->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_TREATMENT_INAP_CLASS_ID_1" class="form-group TREATMENT_INAP_CLASS_ID_1">
<span<?= $Grid->CLASS_ID_1->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->CLASS_ID_1->getDisplayValue($Grid->CLASS_ID_1->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_CLASS_ID_1" data-hidden="1" name="x<?= $Grid->RowIndex ?>_CLASS_ID_1" id="x<?= $Grid->RowIndex ?>_CLASS_ID_1" value="<?= HtmlEncode($Grid->CLASS_ID_1->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_CLASS_ID_1" data-hidden="1" name="o<?= $Grid->RowIndex ?>_CLASS_ID_1" id="o<?= $Grid->RowIndex ?>_CLASS_ID_1" value="<?= HtmlEncode($Grid->CLASS_ID_1->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->CLINIC_ID_1->Visible) { // CLINIC_ID_1 ?>
        <td data-name="CLINIC_ID_1">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_TREATMENT_INAP_CLINIC_ID_1" class="form-group TREATMENT_INAP_CLINIC_ID_1">
<input type="<?= $Grid->CLINIC_ID_1->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_CLINIC_ID_1" name="x<?= $Grid->RowIndex ?>_CLINIC_ID_1" id="x<?= $Grid->RowIndex ?>_CLINIC_ID_1" size="30" maxlength="15" placeholder="<?= HtmlEncode($Grid->CLINIC_ID_1->getPlaceHolder()) ?>" value="<?= $Grid->CLINIC_ID_1->EditValue ?>"<?= $Grid->CLINIC_ID_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->CLINIC_ID_1->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_TREATMENT_INAP_CLINIC_ID_1" class="form-group TREATMENT_INAP_CLINIC_ID_1">
<span<?= $Grid->CLINIC_ID_1->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->CLINIC_ID_1->getDisplayValue($Grid->CLINIC_ID_1->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_CLINIC_ID_1" data-hidden="1" name="x<?= $Grid->RowIndex ?>_CLINIC_ID_1" id="x<?= $Grid->RowIndex ?>_CLINIC_ID_1" value="<?= HtmlEncode($Grid->CLINIC_ID_1->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_CLINIC_ID_1" data-hidden="1" name="o<?= $Grid->RowIndex ?>_CLINIC_ID_1" id="o<?= $Grid->RowIndex ?>_CLINIC_ID_1" value="<?= HtmlEncode($Grid->CLINIC_ID_1->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->CLINIC_ID_FROM_1->Visible) { // CLINIC_ID_FROM_1 ?>
        <td data-name="CLINIC_ID_FROM_1">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_TREATMENT_INAP_CLINIC_ID_FROM_1" class="form-group TREATMENT_INAP_CLINIC_ID_FROM_1">
<input type="<?= $Grid->CLINIC_ID_FROM_1->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_CLINIC_ID_FROM_1" name="x<?= $Grid->RowIndex ?>_CLINIC_ID_FROM_1" id="x<?= $Grid->RowIndex ?>_CLINIC_ID_FROM_1" size="30" maxlength="15" placeholder="<?= HtmlEncode($Grid->CLINIC_ID_FROM_1->getPlaceHolder()) ?>" value="<?= $Grid->CLINIC_ID_FROM_1->EditValue ?>"<?= $Grid->CLINIC_ID_FROM_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->CLINIC_ID_FROM_1->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_TREATMENT_INAP_CLINIC_ID_FROM_1" class="form-group TREATMENT_INAP_CLINIC_ID_FROM_1">
<span<?= $Grid->CLINIC_ID_FROM_1->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->CLINIC_ID_FROM_1->getDisplayValue($Grid->CLINIC_ID_FROM_1->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_CLINIC_ID_FROM_1" data-hidden="1" name="x<?= $Grid->RowIndex ?>_CLINIC_ID_FROM_1" id="x<?= $Grid->RowIndex ?>_CLINIC_ID_FROM_1" value="<?= HtmlEncode($Grid->CLINIC_ID_FROM_1->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_CLINIC_ID_FROM_1" data-hidden="1" name="o<?= $Grid->RowIndex ?>_CLINIC_ID_FROM_1" id="o<?= $Grid->RowIndex ?>_CLINIC_ID_FROM_1" value="<?= HtmlEncode($Grid->CLINIC_ID_FROM_1->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->TREATMENT_1->Visible) { // TREATMENT_1 ?>
        <td data-name="TREATMENT_1">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_TREATMENT_INAP_TREATMENT_1" class="form-group TREATMENT_INAP_TREATMENT_1">
<input type="<?= $Grid->TREATMENT_1->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_TREATMENT_1" name="x<?= $Grid->RowIndex ?>_TREATMENT_1" id="x<?= $Grid->RowIndex ?>_TREATMENT_1" size="30" maxlength="200" placeholder="<?= HtmlEncode($Grid->TREATMENT_1->getPlaceHolder()) ?>" value="<?= $Grid->TREATMENT_1->EditValue ?>"<?= $Grid->TREATMENT_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->TREATMENT_1->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_TREATMENT_INAP_TREATMENT_1" class="form-group TREATMENT_INAP_TREATMENT_1">
<span<?= $Grid->TREATMENT_1->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->TREATMENT_1->getDisplayValue($Grid->TREATMENT_1->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_TREATMENT_1" data-hidden="1" name="x<?= $Grid->RowIndex ?>_TREATMENT_1" id="x<?= $Grid->RowIndex ?>_TREATMENT_1" value="<?= HtmlEncode($Grid->TREATMENT_1->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_TREATMENT_1" data-hidden="1" name="o<?= $Grid->RowIndex ?>_TREATMENT_1" id="o<?= $Grid->RowIndex ?>_TREATMENT_1" value="<?= HtmlEncode($Grid->TREATMENT_1->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->TREAT_DATE_1->Visible) { // TREAT_DATE_1 ?>
        <td data-name="TREAT_DATE_1">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_TREATMENT_INAP_TREAT_DATE_1" class="form-group TREATMENT_INAP_TREAT_DATE_1">
<input type="<?= $Grid->TREAT_DATE_1->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_TREAT_DATE_1" name="x<?= $Grid->RowIndex ?>_TREAT_DATE_1" id="x<?= $Grid->RowIndex ?>_TREAT_DATE_1" placeholder="<?= HtmlEncode($Grid->TREAT_DATE_1->getPlaceHolder()) ?>" value="<?= $Grid->TREAT_DATE_1->EditValue ?>"<?= $Grid->TREAT_DATE_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->TREAT_DATE_1->getErrorMessage() ?></div>
<?php if (!$Grid->TREAT_DATE_1->ReadOnly && !$Grid->TREAT_DATE_1->Disabled && !isset($Grid->TREAT_DATE_1->EditAttrs["readonly"]) && !isset($Grid->TREAT_DATE_1->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fTREATMENT_INAPgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fTREATMENT_INAPgrid", "x<?= $Grid->RowIndex ?>_TREAT_DATE_1", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_TREATMENT_INAP_TREAT_DATE_1" class="form-group TREATMENT_INAP_TREAT_DATE_1">
<span<?= $Grid->TREAT_DATE_1->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->TREAT_DATE_1->getDisplayValue($Grid->TREAT_DATE_1->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_TREAT_DATE_1" data-hidden="1" name="x<?= $Grid->RowIndex ?>_TREAT_DATE_1" id="x<?= $Grid->RowIndex ?>_TREAT_DATE_1" value="<?= HtmlEncode($Grid->TREAT_DATE_1->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_TREAT_DATE_1" data-hidden="1" name="o<?= $Grid->RowIndex ?>_TREAT_DATE_1" id="o<?= $Grid->RowIndex ?>_TREAT_DATE_1" value="<?= HtmlEncode($Grid->TREAT_DATE_1->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->QUANTITY_1->Visible) { // QUANTITY_1 ?>
        <td data-name="QUANTITY_1">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_TREATMENT_INAP_QUANTITY_1" class="form-group TREATMENT_INAP_QUANTITY_1">
<input type="<?= $Grid->QUANTITY_1->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_QUANTITY_1" name="x<?= $Grid->RowIndex ?>_QUANTITY_1" id="x<?= $Grid->RowIndex ?>_QUANTITY_1" size="30" placeholder="<?= HtmlEncode($Grid->QUANTITY_1->getPlaceHolder()) ?>" value="<?= $Grid->QUANTITY_1->EditValue ?>"<?= $Grid->QUANTITY_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->QUANTITY_1->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_TREATMENT_INAP_QUANTITY_1" class="form-group TREATMENT_INAP_QUANTITY_1">
<span<?= $Grid->QUANTITY_1->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->QUANTITY_1->getDisplayValue($Grid->QUANTITY_1->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_QUANTITY_1" data-hidden="1" name="x<?= $Grid->RowIndex ?>_QUANTITY_1" id="x<?= $Grid->RowIndex ?>_QUANTITY_1" value="<?= HtmlEncode($Grid->QUANTITY_1->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_QUANTITY_1" data-hidden="1" name="o<?= $Grid->RowIndex ?>_QUANTITY_1" id="o<?= $Grid->RowIndex ?>_QUANTITY_1" value="<?= HtmlEncode($Grid->QUANTITY_1->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->MEASURE_ID->Visible) { // MEASURE_ID ?>
        <td data-name="MEASURE_ID">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_TREATMENT_INAP_MEASURE_ID" class="form-group TREATMENT_INAP_MEASURE_ID">
<input type="<?= $Grid->MEASURE_ID->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_MEASURE_ID" name="x<?= $Grid->RowIndex ?>_MEASURE_ID" id="x<?= $Grid->RowIndex ?>_MEASURE_ID" size="30" placeholder="<?= HtmlEncode($Grid->MEASURE_ID->getPlaceHolder()) ?>" value="<?= $Grid->MEASURE_ID->EditValue ?>"<?= $Grid->MEASURE_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->MEASURE_ID->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_TREATMENT_INAP_MEASURE_ID" class="form-group TREATMENT_INAP_MEASURE_ID">
<span<?= $Grid->MEASURE_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->MEASURE_ID->getDisplayValue($Grid->MEASURE_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_MEASURE_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_MEASURE_ID" id="x<?= $Grid->RowIndex ?>_MEASURE_ID" value="<?= HtmlEncode($Grid->MEASURE_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_MEASURE_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_MEASURE_ID" id="o<?= $Grid->RowIndex ?>_MEASURE_ID" value="<?= HtmlEncode($Grid->MEASURE_ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->MEASURE_ID_1->Visible) { // MEASURE_ID_1 ?>
        <td data-name="MEASURE_ID_1">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_TREATMENT_INAP_MEASURE_ID_1" class="form-group TREATMENT_INAP_MEASURE_ID_1">
<input type="<?= $Grid->MEASURE_ID_1->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_MEASURE_ID_1" name="x<?= $Grid->RowIndex ?>_MEASURE_ID_1" id="x<?= $Grid->RowIndex ?>_MEASURE_ID_1" size="30" placeholder="<?= HtmlEncode($Grid->MEASURE_ID_1->getPlaceHolder()) ?>" value="<?= $Grid->MEASURE_ID_1->EditValue ?>"<?= $Grid->MEASURE_ID_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->MEASURE_ID_1->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_TREATMENT_INAP_MEASURE_ID_1" class="form-group TREATMENT_INAP_MEASURE_ID_1">
<span<?= $Grid->MEASURE_ID_1->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->MEASURE_ID_1->getDisplayValue($Grid->MEASURE_ID_1->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_MEASURE_ID_1" data-hidden="1" name="x<?= $Grid->RowIndex ?>_MEASURE_ID_1" id="x<?= $Grid->RowIndex ?>_MEASURE_ID_1" value="<?= HtmlEncode($Grid->MEASURE_ID_1->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_MEASURE_ID_1" data-hidden="1" name="o<?= $Grid->RowIndex ?>_MEASURE_ID_1" id="o<?= $Grid->RowIndex ?>_MEASURE_ID_1" value="<?= HtmlEncode($Grid->MEASURE_ID_1->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->TRANS_ID_1->Visible) { // TRANS_ID_1 ?>
        <td data-name="TRANS_ID_1">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_TREATMENT_INAP_TRANS_ID_1" class="form-group TREATMENT_INAP_TRANS_ID_1">
<input type="<?= $Grid->TRANS_ID_1->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_TRANS_ID_1" name="x<?= $Grid->RowIndex ?>_TRANS_ID_1" id="x<?= $Grid->RowIndex ?>_TRANS_ID_1" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->TRANS_ID_1->getPlaceHolder()) ?>" value="<?= $Grid->TRANS_ID_1->EditValue ?>"<?= $Grid->TRANS_ID_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->TRANS_ID_1->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_TREATMENT_INAP_TRANS_ID_1" class="form-group TREATMENT_INAP_TRANS_ID_1">
<span<?= $Grid->TRANS_ID_1->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->TRANS_ID_1->getDisplayValue($Grid->TRANS_ID_1->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_TRANS_ID_1" data-hidden="1" name="x<?= $Grid->RowIndex ?>_TRANS_ID_1" id="x<?= $Grid->RowIndex ?>_TRANS_ID_1" value="<?= HtmlEncode($Grid->TRANS_ID_1->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_TRANS_ID_1" data-hidden="1" name="o<?= $Grid->RowIndex ?>_TRANS_ID_1" id="o<?= $Grid->RowIndex ?>_TRANS_ID_1" value="<?= HtmlEncode($Grid->TRANS_ID_1->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["fTREATMENT_INAPgrid","load"], function() {
    fTREATMENT_INAPgrid.updateLists(<?= $Grid->RowIndex ?>);
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
<input type="hidden" name="detailpage" value="fTREATMENT_INAPgrid">
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
    ew.addEventHandlers("TREATMENT_INAP");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
