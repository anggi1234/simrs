<?php

namespace PHPMaker2021\SIMRSSQLSERVERRADIOLOGI;

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
        ["ORG_UNIT_CODE", [fields.ORG_UNIT_CODE.visible && fields.ORG_UNIT_CODE.required ? ew.Validators.required(fields.ORG_UNIT_CODE.caption) : null], fields.ORG_UNIT_CODE.isInvalid],
        ["ITEM_ID", [fields.ITEM_ID.visible && fields.ITEM_ID.required ? ew.Validators.required(fields.ITEM_ID.caption) : null], fields.ITEM_ID.isInvalid],
        ["ORG_ID", [fields.ORG_ID.visible && fields.ORG_ID.required ? ew.Validators.required(fields.ORG_ID.caption) : null], fields.ORG_ID.isInvalid],
        ["BATCH_NO", [fields.BATCH_NO.visible && fields.BATCH_NO.required ? ew.Validators.required(fields.BATCH_NO.caption) : null], fields.BATCH_NO.isInvalid],
        ["BRAND_ID", [fields.BRAND_ID.visible && fields.BRAND_ID.required ? ew.Validators.required(fields.BRAND_ID.caption) : null], fields.BRAND_ID.isInvalid],
        ["ROOMS_ID", [fields.ROOMS_ID.visible && fields.ROOMS_ID.required ? ew.Validators.required(fields.ROOMS_ID.caption) : null], fields.ROOMS_ID.isInvalid],
        ["SHELF_NO", [fields.SHELF_NO.visible && fields.SHELF_NO.required ? ew.Validators.required(fields.SHELF_NO.caption) : null, ew.Validators.integer], fields.SHELF_NO.isInvalid],
        ["EXPIRY_DATE", [fields.EXPIRY_DATE.visible && fields.EXPIRY_DATE.required ? ew.Validators.required(fields.EXPIRY_DATE.caption) : null, ew.Validators.datetime(0)], fields.EXPIRY_DATE.isInvalid],
        ["SERIAL_NB", [fields.SERIAL_NB.visible && fields.SERIAL_NB.required ? ew.Validators.required(fields.SERIAL_NB.caption) : null], fields.SERIAL_NB.isInvalid],
        ["FROM_ROOMS_ID", [fields.FROM_ROOMS_ID.visible && fields.FROM_ROOMS_ID.required ? ew.Validators.required(fields.FROM_ROOMS_ID.caption) : null], fields.FROM_ROOMS_ID.isInvalid],
        ["ISOUTLET", [fields.ISOUTLET.visible && fields.ISOUTLET.required ? ew.Validators.required(fields.ISOUTLET.caption) : null], fields.ISOUTLET.isInvalid],
        ["QUANTITY", [fields.QUANTITY.visible && fields.QUANTITY.required ? ew.Validators.required(fields.QUANTITY.caption) : null, ew.Validators.float], fields.QUANTITY.isInvalid],
        ["MEASURE_ID", [fields.MEASURE_ID.visible && fields.MEASURE_ID.required ? ew.Validators.required(fields.MEASURE_ID.caption) : null, ew.Validators.integer], fields.MEASURE_ID.isInvalid],
        ["DISTRIBUTION_TYPE", [fields.DISTRIBUTION_TYPE.visible && fields.DISTRIBUTION_TYPE.required ? ew.Validators.required(fields.DISTRIBUTION_TYPE.caption) : null, ew.Validators.integer], fields.DISTRIBUTION_TYPE.isInvalid],
        ["CONDITION", [fields.CONDITION.visible && fields.CONDITION.required ? ew.Validators.required(fields.CONDITION.caption) : null, ew.Validators.integer], fields.CONDITION.isInvalid],
        ["ALLOCATED_DATE", [fields.ALLOCATED_DATE.visible && fields.ALLOCATED_DATE.required ? ew.Validators.required(fields.ALLOCATED_DATE.caption) : null, ew.Validators.datetime(0)], fields.ALLOCATED_DATE.isInvalid],
        ["STOCKOPNAME_DATE", [fields.STOCKOPNAME_DATE.visible && fields.STOCKOPNAME_DATE.required ? ew.Validators.required(fields.STOCKOPNAME_DATE.caption) : null, ew.Validators.datetime(0)], fields.STOCKOPNAME_DATE.isInvalid],
        ["INVOICE_ID", [fields.INVOICE_ID.visible && fields.INVOICE_ID.required ? ew.Validators.required(fields.INVOICE_ID.caption) : null], fields.INVOICE_ID.isInvalid],
        ["ALLOCATED_FROM", [fields.ALLOCATED_FROM.visible && fields.ALLOCATED_FROM.required ? ew.Validators.required(fields.ALLOCATED_FROM.caption) : null], fields.ALLOCATED_FROM.isInvalid],
        ["PRICE", [fields.PRICE.visible && fields.PRICE.required ? ew.Validators.required(fields.PRICE.caption) : null, ew.Validators.float], fields.PRICE.isInvalid],
        ["DISCOUNT", [fields.DISCOUNT.visible && fields.DISCOUNT.required ? ew.Validators.required(fields.DISCOUNT.caption) : null, ew.Validators.float], fields.DISCOUNT.isInvalid],
        ["DISCOUNT2", [fields.DISCOUNT2.visible && fields.DISCOUNT2.required ? ew.Validators.required(fields.DISCOUNT2.caption) : null, ew.Validators.float], fields.DISCOUNT2.isInvalid],
        ["DISCOUNTOFF", [fields.DISCOUNTOFF.visible && fields.DISCOUNTOFF.required ? ew.Validators.required(fields.DISCOUNTOFF.caption) : null, ew.Validators.float], fields.DISCOUNTOFF.isInvalid],
        ["ORG_UNIT_FROM", [fields.ORG_UNIT_FROM.visible && fields.ORG_UNIT_FROM.required ? ew.Validators.required(fields.ORG_UNIT_FROM.caption) : null], fields.ORG_UNIT_FROM.isInvalid],
        ["ITEM_ID_FROM", [fields.ITEM_ID_FROM.visible && fields.ITEM_ID_FROM.required ? ew.Validators.required(fields.ITEM_ID_FROM.caption) : null], fields.ITEM_ID_FROM.isInvalid],
        ["MODIFIED_DATE", [fields.MODIFIED_DATE.visible && fields.MODIFIED_DATE.required ? ew.Validators.required(fields.MODIFIED_DATE.caption) : null, ew.Validators.datetime(0)], fields.MODIFIED_DATE.isInvalid],
        ["MODIFIED_BY", [fields.MODIFIED_BY.visible && fields.MODIFIED_BY.required ? ew.Validators.required(fields.MODIFIED_BY.caption) : null], fields.MODIFIED_BY.isInvalid],
        ["STOCK_OPNAME", [fields.STOCK_OPNAME.visible && fields.STOCK_OPNAME.required ? ew.Validators.required(fields.STOCK_OPNAME.caption) : null, ew.Validators.float], fields.STOCK_OPNAME.isInvalid],
        ["STOK_AWAL", [fields.STOK_AWAL.visible && fields.STOK_AWAL.required ? ew.Validators.required(fields.STOK_AWAL.caption) : null, ew.Validators.float], fields.STOK_AWAL.isInvalid],
        ["STOCK_LALU", [fields.STOCK_LALU.visible && fields.STOCK_LALU.required ? ew.Validators.required(fields.STOCK_LALU.caption) : null, ew.Validators.float], fields.STOCK_LALU.isInvalid],
        ["STOCK_KOREKSI", [fields.STOCK_KOREKSI.visible && fields.STOCK_KOREKSI.required ? ew.Validators.required(fields.STOCK_KOREKSI.caption) : null, ew.Validators.float], fields.STOCK_KOREKSI.isInvalid],
        ["DITERIMA", [fields.DITERIMA.visible && fields.DITERIMA.required ? ew.Validators.required(fields.DITERIMA.caption) : null, ew.Validators.float], fields.DITERIMA.isInvalid],
        ["DISTRIBUSI", [fields.DISTRIBUSI.visible && fields.DISTRIBUSI.required ? ew.Validators.required(fields.DISTRIBUSI.caption) : null, ew.Validators.float], fields.DISTRIBUSI.isInvalid],
        ["DIJUAL", [fields.DIJUAL.visible && fields.DIJUAL.required ? ew.Validators.required(fields.DIJUAL.caption) : null, ew.Validators.float], fields.DIJUAL.isInvalid],
        ["DIHAPUS", [fields.DIHAPUS.visible && fields.DIHAPUS.required ? ew.Validators.required(fields.DIHAPUS.caption) : null, ew.Validators.float], fields.DIHAPUS.isInvalid],
        ["DIMINTA", [fields.DIMINTA.visible && fields.DIMINTA.required ? ew.Validators.required(fields.DIMINTA.caption) : null, ew.Validators.float], fields.DIMINTA.isInvalid],
        ["DIRETUR", [fields.DIRETUR.visible && fields.DIRETUR.required ? ew.Validators.required(fields.DIRETUR.caption) : null, ew.Validators.float], fields.DIRETUR.isInvalid],
        ["PO", [fields.PO.visible && fields.PO.required ? ew.Validators.required(fields.PO.caption) : null], fields.PO.isInvalid],
        ["COMPANY_ID", [fields.COMPANY_ID.visible && fields.COMPANY_ID.required ? ew.Validators.required(fields.COMPANY_ID.caption) : null], fields.COMPANY_ID.isInvalid],
        ["FUND_ID", [fields.FUND_ID.visible && fields.FUND_ID.required ? ew.Validators.required(fields.FUND_ID.caption) : null, ew.Validators.integer], fields.FUND_ID.isInvalid],
        ["INVOICE_ID2", [fields.INVOICE_ID2.visible && fields.INVOICE_ID2.required ? ew.Validators.required(fields.INVOICE_ID2.caption) : null], fields.INVOICE_ID2.isInvalid],
        ["MEASURE_ID3", [fields.MEASURE_ID3.visible && fields.MEASURE_ID3.required ? ew.Validators.required(fields.MEASURE_ID3.caption) : null, ew.Validators.integer], fields.MEASURE_ID3.isInvalid],
        ["SIZE_KEMASAN", [fields.SIZE_KEMASAN.visible && fields.SIZE_KEMASAN.required ? ew.Validators.required(fields.SIZE_KEMASAN.caption) : null, ew.Validators.float], fields.SIZE_KEMASAN.isInvalid],
        ["BRAND_NAME", [fields.BRAND_NAME.visible && fields.BRAND_NAME.required ? ew.Validators.required(fields.BRAND_NAME.caption) : null], fields.BRAND_NAME.isInvalid],
        ["MEASURE_ID2", [fields.MEASURE_ID2.visible && fields.MEASURE_ID2.required ? ew.Validators.required(fields.MEASURE_ID2.caption) : null, ew.Validators.integer], fields.MEASURE_ID2.isInvalid],
        ["RETUR_ID", [fields.RETUR_ID.visible && fields.RETUR_ID.required ? ew.Validators.required(fields.RETUR_ID.caption) : null], fields.RETUR_ID.isInvalid],
        ["SIZE_GOODS", [fields.SIZE_GOODS.visible && fields.SIZE_GOODS.required ? ew.Validators.required(fields.SIZE_GOODS.caption) : null, ew.Validators.float], fields.SIZE_GOODS.isInvalid],
        ["MEASURE_DOSIS", [fields.MEASURE_DOSIS.visible && fields.MEASURE_DOSIS.required ? ew.Validators.required(fields.MEASURE_DOSIS.caption) : null, ew.Validators.integer], fields.MEASURE_DOSIS.isInvalid],
        ["ORDER_PRICE", [fields.ORDER_PRICE.visible && fields.ORDER_PRICE.required ? ew.Validators.required(fields.ORDER_PRICE.caption) : null, ew.Validators.float], fields.ORDER_PRICE.isInvalid],
        ["STOCK_AVAILABLE", [fields.STOCK_AVAILABLE.visible && fields.STOCK_AVAILABLE.required ? ew.Validators.required(fields.STOCK_AVAILABLE.caption) : null, ew.Validators.float], fields.STOCK_AVAILABLE.isInvalid],
        ["STATUS_PASIEN_ID", [fields.STATUS_PASIEN_ID.visible && fields.STATUS_PASIEN_ID.required ? ew.Validators.required(fields.STATUS_PASIEN_ID.caption) : null, ew.Validators.integer], fields.STATUS_PASIEN_ID.isInvalid],
        ["MONTH_ID", [fields.MONTH_ID.visible && fields.MONTH_ID.required ? ew.Validators.required(fields.MONTH_ID.caption) : null, ew.Validators.integer], fields.MONTH_ID.isInvalid],
        ["YEAR_ID", [fields.YEAR_ID.visible && fields.YEAR_ID.required ? ew.Validators.required(fields.YEAR_ID.caption) : null, ew.Validators.integer], fields.YEAR_ID.isInvalid],
        ["CORRECTION_DOC", [fields.CORRECTION_DOC.visible && fields.CORRECTION_DOC.required ? ew.Validators.required(fields.CORRECTION_DOC.caption) : null], fields.CORRECTION_DOC.isInvalid],
        ["CORRECTIONS", [fields.CORRECTIONS.visible && fields.CORRECTIONS.required ? ew.Validators.required(fields.CORRECTIONS.caption) : null], fields.CORRECTIONS.isInvalid],
        ["CORRECTION_DATE", [fields.CORRECTION_DATE.visible && fields.CORRECTION_DATE.required ? ew.Validators.required(fields.CORRECTION_DATE.caption) : null, ew.Validators.datetime(0)], fields.CORRECTION_DATE.isInvalid],
        ["DOC_NO", [fields.DOC_NO.visible && fields.DOC_NO.required ? ew.Validators.required(fields.DOC_NO.caption) : null], fields.DOC_NO.isInvalid],
        ["ORDER_ID", [fields.ORDER_ID.visible && fields.ORDER_ID.required ? ew.Validators.required(fields.ORDER_ID.caption) : null], fields.ORDER_ID.isInvalid],
        ["ISCETAK", [fields.ISCETAK.visible && fields.ISCETAK.required ? ew.Validators.required(fields.ISCETAK.caption) : null], fields.ISCETAK.isInvalid],
        ["PRINT_DATE", [fields.PRINT_DATE.visible && fields.PRINT_DATE.required ? ew.Validators.required(fields.PRINT_DATE.caption) : null, ew.Validators.datetime(0)], fields.PRINT_DATE.isInvalid],
        ["PRINTED_BY", [fields.PRINTED_BY.visible && fields.PRINTED_BY.required ? ew.Validators.required(fields.PRINTED_BY.caption) : null], fields.PRINTED_BY.isInvalid],
        ["PRINTQ", [fields.PRINTQ.visible && fields.PRINTQ.required ? ew.Validators.required(fields.PRINTQ.caption) : null, ew.Validators.integer], fields.PRINTQ.isInvalid],
        ["avgprice", [fields.avgprice.visible && fields.avgprice.required ? ew.Validators.required(fields.avgprice.caption) : null, ew.Validators.float], fields.avgprice.isInvalid],
        ["idx", [fields.idx.visible && fields.idx.required ? ew.Validators.required(fields.idx.caption) : null], fields.idx.isInvalid]
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
        if (ew.valueChanged(fobj, rowIndex, "ORG_UNIT_CODE", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "ITEM_ID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "ORG_ID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "BATCH_NO", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "BRAND_ID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "ROOMS_ID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "SHELF_NO", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "EXPIRY_DATE", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "SERIAL_NB", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "FROM_ROOMS_ID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "ISOUTLET", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "QUANTITY", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "MEASURE_ID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "DISTRIBUTION_TYPE", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "CONDITION", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "ALLOCATED_DATE", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "STOCKOPNAME_DATE", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "INVOICE_ID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "ALLOCATED_FROM", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "PRICE", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "DISCOUNT", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "DISCOUNT2", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "DISCOUNTOFF", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "ORG_UNIT_FROM", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "ITEM_ID_FROM", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "MODIFIED_DATE", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "MODIFIED_BY", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "STOCK_OPNAME", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "STOK_AWAL", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "STOCK_LALU", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "STOCK_KOREKSI", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "DITERIMA", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "DISTRIBUSI", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "DIJUAL", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "DIHAPUS", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "DIMINTA", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "DIRETUR", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "PO", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "COMPANY_ID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "FUND_ID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "INVOICE_ID2", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "MEASURE_ID3", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "SIZE_KEMASAN", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "BRAND_NAME", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "MEASURE_ID2", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "RETUR_ID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "SIZE_GOODS", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "MEASURE_DOSIS", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "ORDER_PRICE", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "STOCK_AVAILABLE", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "STATUS_PASIEN_ID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "MONTH_ID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "YEAR_ID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "CORRECTION_DOC", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "CORRECTIONS", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "CORRECTION_DATE", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "DOC_NO", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "ORDER_ID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "ISCETAK", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "PRINT_DATE", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "PRINTED_BY", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "PRINTQ", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "avgprice", false))
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
<?php if ($Grid->ORG_UNIT_CODE->Visible) { // ORG_UNIT_CODE ?>
        <th data-name="ORG_UNIT_CODE" class="<?= $Grid->ORG_UNIT_CODE->headerCellClass() ?>"><div id="elh_GOOD_GF_ORG_UNIT_CODE" class="GOOD_GF_ORG_UNIT_CODE"><?= $Grid->renderSort($Grid->ORG_UNIT_CODE) ?></div></th>
<?php } ?>
<?php if ($Grid->ITEM_ID->Visible) { // ITEM_ID ?>
        <th data-name="ITEM_ID" class="<?= $Grid->ITEM_ID->headerCellClass() ?>"><div id="elh_GOOD_GF_ITEM_ID" class="GOOD_GF_ITEM_ID"><?= $Grid->renderSort($Grid->ITEM_ID) ?></div></th>
<?php } ?>
<?php if ($Grid->ORG_ID->Visible) { // ORG_ID ?>
        <th data-name="ORG_ID" class="<?= $Grid->ORG_ID->headerCellClass() ?>"><div id="elh_GOOD_GF_ORG_ID" class="GOOD_GF_ORG_ID"><?= $Grid->renderSort($Grid->ORG_ID) ?></div></th>
<?php } ?>
<?php if ($Grid->BATCH_NO->Visible) { // BATCH_NO ?>
        <th data-name="BATCH_NO" class="<?= $Grid->BATCH_NO->headerCellClass() ?>"><div id="elh_GOOD_GF_BATCH_NO" class="GOOD_GF_BATCH_NO"><?= $Grid->renderSort($Grid->BATCH_NO) ?></div></th>
<?php } ?>
<?php if ($Grid->BRAND_ID->Visible) { // BRAND_ID ?>
        <th data-name="BRAND_ID" class="<?= $Grid->BRAND_ID->headerCellClass() ?>"><div id="elh_GOOD_GF_BRAND_ID" class="GOOD_GF_BRAND_ID"><?= $Grid->renderSort($Grid->BRAND_ID) ?></div></th>
<?php } ?>
<?php if ($Grid->ROOMS_ID->Visible) { // ROOMS_ID ?>
        <th data-name="ROOMS_ID" class="<?= $Grid->ROOMS_ID->headerCellClass() ?>"><div id="elh_GOOD_GF_ROOMS_ID" class="GOOD_GF_ROOMS_ID"><?= $Grid->renderSort($Grid->ROOMS_ID) ?></div></th>
<?php } ?>
<?php if ($Grid->SHELF_NO->Visible) { // SHELF_NO ?>
        <th data-name="SHELF_NO" class="<?= $Grid->SHELF_NO->headerCellClass() ?>"><div id="elh_GOOD_GF_SHELF_NO" class="GOOD_GF_SHELF_NO"><?= $Grid->renderSort($Grid->SHELF_NO) ?></div></th>
<?php } ?>
<?php if ($Grid->EXPIRY_DATE->Visible) { // EXPIRY_DATE ?>
        <th data-name="EXPIRY_DATE" class="<?= $Grid->EXPIRY_DATE->headerCellClass() ?>"><div id="elh_GOOD_GF_EXPIRY_DATE" class="GOOD_GF_EXPIRY_DATE"><?= $Grid->renderSort($Grid->EXPIRY_DATE) ?></div></th>
<?php } ?>
<?php if ($Grid->SERIAL_NB->Visible) { // SERIAL_NB ?>
        <th data-name="SERIAL_NB" class="<?= $Grid->SERIAL_NB->headerCellClass() ?>"><div id="elh_GOOD_GF_SERIAL_NB" class="GOOD_GF_SERIAL_NB"><?= $Grid->renderSort($Grid->SERIAL_NB) ?></div></th>
<?php } ?>
<?php if ($Grid->FROM_ROOMS_ID->Visible) { // FROM_ROOMS_ID ?>
        <th data-name="FROM_ROOMS_ID" class="<?= $Grid->FROM_ROOMS_ID->headerCellClass() ?>"><div id="elh_GOOD_GF_FROM_ROOMS_ID" class="GOOD_GF_FROM_ROOMS_ID"><?= $Grid->renderSort($Grid->FROM_ROOMS_ID) ?></div></th>
<?php } ?>
<?php if ($Grid->ISOUTLET->Visible) { // ISOUTLET ?>
        <th data-name="ISOUTLET" class="<?= $Grid->ISOUTLET->headerCellClass() ?>"><div id="elh_GOOD_GF_ISOUTLET" class="GOOD_GF_ISOUTLET"><?= $Grid->renderSort($Grid->ISOUTLET) ?></div></th>
<?php } ?>
<?php if ($Grid->QUANTITY->Visible) { // QUANTITY ?>
        <th data-name="QUANTITY" class="<?= $Grid->QUANTITY->headerCellClass() ?>"><div id="elh_GOOD_GF_QUANTITY" class="GOOD_GF_QUANTITY"><?= $Grid->renderSort($Grid->QUANTITY) ?></div></th>
<?php } ?>
<?php if ($Grid->MEASURE_ID->Visible) { // MEASURE_ID ?>
        <th data-name="MEASURE_ID" class="<?= $Grid->MEASURE_ID->headerCellClass() ?>"><div id="elh_GOOD_GF_MEASURE_ID" class="GOOD_GF_MEASURE_ID"><?= $Grid->renderSort($Grid->MEASURE_ID) ?></div></th>
<?php } ?>
<?php if ($Grid->DISTRIBUTION_TYPE->Visible) { // DISTRIBUTION_TYPE ?>
        <th data-name="DISTRIBUTION_TYPE" class="<?= $Grid->DISTRIBUTION_TYPE->headerCellClass() ?>"><div id="elh_GOOD_GF_DISTRIBUTION_TYPE" class="GOOD_GF_DISTRIBUTION_TYPE"><?= $Grid->renderSort($Grid->DISTRIBUTION_TYPE) ?></div></th>
<?php } ?>
<?php if ($Grid->CONDITION->Visible) { // CONDITION ?>
        <th data-name="CONDITION" class="<?= $Grid->CONDITION->headerCellClass() ?>"><div id="elh_GOOD_GF_CONDITION" class="GOOD_GF_CONDITION"><?= $Grid->renderSort($Grid->CONDITION) ?></div></th>
<?php } ?>
<?php if ($Grid->ALLOCATED_DATE->Visible) { // ALLOCATED_DATE ?>
        <th data-name="ALLOCATED_DATE" class="<?= $Grid->ALLOCATED_DATE->headerCellClass() ?>"><div id="elh_GOOD_GF_ALLOCATED_DATE" class="GOOD_GF_ALLOCATED_DATE"><?= $Grid->renderSort($Grid->ALLOCATED_DATE) ?></div></th>
<?php } ?>
<?php if ($Grid->STOCKOPNAME_DATE->Visible) { // STOCKOPNAME_DATE ?>
        <th data-name="STOCKOPNAME_DATE" class="<?= $Grid->STOCKOPNAME_DATE->headerCellClass() ?>"><div id="elh_GOOD_GF_STOCKOPNAME_DATE" class="GOOD_GF_STOCKOPNAME_DATE"><?= $Grid->renderSort($Grid->STOCKOPNAME_DATE) ?></div></th>
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
<?php if ($Grid->DISCOUNT->Visible) { // DISCOUNT ?>
        <th data-name="DISCOUNT" class="<?= $Grid->DISCOUNT->headerCellClass() ?>"><div id="elh_GOOD_GF_DISCOUNT" class="GOOD_GF_DISCOUNT"><?= $Grid->renderSort($Grid->DISCOUNT) ?></div></th>
<?php } ?>
<?php if ($Grid->DISCOUNT2->Visible) { // DISCOUNT2 ?>
        <th data-name="DISCOUNT2" class="<?= $Grid->DISCOUNT2->headerCellClass() ?>"><div id="elh_GOOD_GF_DISCOUNT2" class="GOOD_GF_DISCOUNT2"><?= $Grid->renderSort($Grid->DISCOUNT2) ?></div></th>
<?php } ?>
<?php if ($Grid->DISCOUNTOFF->Visible) { // DISCOUNTOFF ?>
        <th data-name="DISCOUNTOFF" class="<?= $Grid->DISCOUNTOFF->headerCellClass() ?>"><div id="elh_GOOD_GF_DISCOUNTOFF" class="GOOD_GF_DISCOUNTOFF"><?= $Grid->renderSort($Grid->DISCOUNTOFF) ?></div></th>
<?php } ?>
<?php if ($Grid->ORG_UNIT_FROM->Visible) { // ORG_UNIT_FROM ?>
        <th data-name="ORG_UNIT_FROM" class="<?= $Grid->ORG_UNIT_FROM->headerCellClass() ?>"><div id="elh_GOOD_GF_ORG_UNIT_FROM" class="GOOD_GF_ORG_UNIT_FROM"><?= $Grid->renderSort($Grid->ORG_UNIT_FROM) ?></div></th>
<?php } ?>
<?php if ($Grid->ITEM_ID_FROM->Visible) { // ITEM_ID_FROM ?>
        <th data-name="ITEM_ID_FROM" class="<?= $Grid->ITEM_ID_FROM->headerCellClass() ?>"><div id="elh_GOOD_GF_ITEM_ID_FROM" class="GOOD_GF_ITEM_ID_FROM"><?= $Grid->renderSort($Grid->ITEM_ID_FROM) ?></div></th>
<?php } ?>
<?php if ($Grid->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
        <th data-name="MODIFIED_DATE" class="<?= $Grid->MODIFIED_DATE->headerCellClass() ?>"><div id="elh_GOOD_GF_MODIFIED_DATE" class="GOOD_GF_MODIFIED_DATE"><?= $Grid->renderSort($Grid->MODIFIED_DATE) ?></div></th>
<?php } ?>
<?php if ($Grid->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
        <th data-name="MODIFIED_BY" class="<?= $Grid->MODIFIED_BY->headerCellClass() ?>"><div id="elh_GOOD_GF_MODIFIED_BY" class="GOOD_GF_MODIFIED_BY"><?= $Grid->renderSort($Grid->MODIFIED_BY) ?></div></th>
<?php } ?>
<?php if ($Grid->STOCK_OPNAME->Visible) { // STOCK_OPNAME ?>
        <th data-name="STOCK_OPNAME" class="<?= $Grid->STOCK_OPNAME->headerCellClass() ?>"><div id="elh_GOOD_GF_STOCK_OPNAME" class="GOOD_GF_STOCK_OPNAME"><?= $Grid->renderSort($Grid->STOCK_OPNAME) ?></div></th>
<?php } ?>
<?php if ($Grid->STOK_AWAL->Visible) { // STOK_AWAL ?>
        <th data-name="STOK_AWAL" class="<?= $Grid->STOK_AWAL->headerCellClass() ?>"><div id="elh_GOOD_GF_STOK_AWAL" class="GOOD_GF_STOK_AWAL"><?= $Grid->renderSort($Grid->STOK_AWAL) ?></div></th>
<?php } ?>
<?php if ($Grid->STOCK_LALU->Visible) { // STOCK_LALU ?>
        <th data-name="STOCK_LALU" class="<?= $Grid->STOCK_LALU->headerCellClass() ?>"><div id="elh_GOOD_GF_STOCK_LALU" class="GOOD_GF_STOCK_LALU"><?= $Grid->renderSort($Grid->STOCK_LALU) ?></div></th>
<?php } ?>
<?php if ($Grid->STOCK_KOREKSI->Visible) { // STOCK_KOREKSI ?>
        <th data-name="STOCK_KOREKSI" class="<?= $Grid->STOCK_KOREKSI->headerCellClass() ?>"><div id="elh_GOOD_GF_STOCK_KOREKSI" class="GOOD_GF_STOCK_KOREKSI"><?= $Grid->renderSort($Grid->STOCK_KOREKSI) ?></div></th>
<?php } ?>
<?php if ($Grid->DITERIMA->Visible) { // DITERIMA ?>
        <th data-name="DITERIMA" class="<?= $Grid->DITERIMA->headerCellClass() ?>"><div id="elh_GOOD_GF_DITERIMA" class="GOOD_GF_DITERIMA"><?= $Grid->renderSort($Grid->DITERIMA) ?></div></th>
<?php } ?>
<?php if ($Grid->DISTRIBUSI->Visible) { // DISTRIBUSI ?>
        <th data-name="DISTRIBUSI" class="<?= $Grid->DISTRIBUSI->headerCellClass() ?>"><div id="elh_GOOD_GF_DISTRIBUSI" class="GOOD_GF_DISTRIBUSI"><?= $Grid->renderSort($Grid->DISTRIBUSI) ?></div></th>
<?php } ?>
<?php if ($Grid->DIJUAL->Visible) { // DIJUAL ?>
        <th data-name="DIJUAL" class="<?= $Grid->DIJUAL->headerCellClass() ?>"><div id="elh_GOOD_GF_DIJUAL" class="GOOD_GF_DIJUAL"><?= $Grid->renderSort($Grid->DIJUAL) ?></div></th>
<?php } ?>
<?php if ($Grid->DIHAPUS->Visible) { // DIHAPUS ?>
        <th data-name="DIHAPUS" class="<?= $Grid->DIHAPUS->headerCellClass() ?>"><div id="elh_GOOD_GF_DIHAPUS" class="GOOD_GF_DIHAPUS"><?= $Grid->renderSort($Grid->DIHAPUS) ?></div></th>
<?php } ?>
<?php if ($Grid->DIMINTA->Visible) { // DIMINTA ?>
        <th data-name="DIMINTA" class="<?= $Grid->DIMINTA->headerCellClass() ?>"><div id="elh_GOOD_GF_DIMINTA" class="GOOD_GF_DIMINTA"><?= $Grid->renderSort($Grid->DIMINTA) ?></div></th>
<?php } ?>
<?php if ($Grid->DIRETUR->Visible) { // DIRETUR ?>
        <th data-name="DIRETUR" class="<?= $Grid->DIRETUR->headerCellClass() ?>"><div id="elh_GOOD_GF_DIRETUR" class="GOOD_GF_DIRETUR"><?= $Grid->renderSort($Grid->DIRETUR) ?></div></th>
<?php } ?>
<?php if ($Grid->PO->Visible) { // PO ?>
        <th data-name="PO" class="<?= $Grid->PO->headerCellClass() ?>"><div id="elh_GOOD_GF_PO" class="GOOD_GF_PO"><?= $Grid->renderSort($Grid->PO) ?></div></th>
<?php } ?>
<?php if ($Grid->COMPANY_ID->Visible) { // COMPANY_ID ?>
        <th data-name="COMPANY_ID" class="<?= $Grid->COMPANY_ID->headerCellClass() ?>"><div id="elh_GOOD_GF_COMPANY_ID" class="GOOD_GF_COMPANY_ID"><?= $Grid->renderSort($Grid->COMPANY_ID) ?></div></th>
<?php } ?>
<?php if ($Grid->FUND_ID->Visible) { // FUND_ID ?>
        <th data-name="FUND_ID" class="<?= $Grid->FUND_ID->headerCellClass() ?>"><div id="elh_GOOD_GF_FUND_ID" class="GOOD_GF_FUND_ID"><?= $Grid->renderSort($Grid->FUND_ID) ?></div></th>
<?php } ?>
<?php if ($Grid->INVOICE_ID2->Visible) { // INVOICE_ID2 ?>
        <th data-name="INVOICE_ID2" class="<?= $Grid->INVOICE_ID2->headerCellClass() ?>"><div id="elh_GOOD_GF_INVOICE_ID2" class="GOOD_GF_INVOICE_ID2"><?= $Grid->renderSort($Grid->INVOICE_ID2) ?></div></th>
<?php } ?>
<?php if ($Grid->MEASURE_ID3->Visible) { // MEASURE_ID3 ?>
        <th data-name="MEASURE_ID3" class="<?= $Grid->MEASURE_ID3->headerCellClass() ?>"><div id="elh_GOOD_GF_MEASURE_ID3" class="GOOD_GF_MEASURE_ID3"><?= $Grid->renderSort($Grid->MEASURE_ID3) ?></div></th>
<?php } ?>
<?php if ($Grid->SIZE_KEMASAN->Visible) { // SIZE_KEMASAN ?>
        <th data-name="SIZE_KEMASAN" class="<?= $Grid->SIZE_KEMASAN->headerCellClass() ?>"><div id="elh_GOOD_GF_SIZE_KEMASAN" class="GOOD_GF_SIZE_KEMASAN"><?= $Grid->renderSort($Grid->SIZE_KEMASAN) ?></div></th>
<?php } ?>
<?php if ($Grid->BRAND_NAME->Visible) { // BRAND_NAME ?>
        <th data-name="BRAND_NAME" class="<?= $Grid->BRAND_NAME->headerCellClass() ?>"><div id="elh_GOOD_GF_BRAND_NAME" class="GOOD_GF_BRAND_NAME"><?= $Grid->renderSort($Grid->BRAND_NAME) ?></div></th>
<?php } ?>
<?php if ($Grid->MEASURE_ID2->Visible) { // MEASURE_ID2 ?>
        <th data-name="MEASURE_ID2" class="<?= $Grid->MEASURE_ID2->headerCellClass() ?>"><div id="elh_GOOD_GF_MEASURE_ID2" class="GOOD_GF_MEASURE_ID2"><?= $Grid->renderSort($Grid->MEASURE_ID2) ?></div></th>
<?php } ?>
<?php if ($Grid->RETUR_ID->Visible) { // RETUR_ID ?>
        <th data-name="RETUR_ID" class="<?= $Grid->RETUR_ID->headerCellClass() ?>"><div id="elh_GOOD_GF_RETUR_ID" class="GOOD_GF_RETUR_ID"><?= $Grid->renderSort($Grid->RETUR_ID) ?></div></th>
<?php } ?>
<?php if ($Grid->SIZE_GOODS->Visible) { // SIZE_GOODS ?>
        <th data-name="SIZE_GOODS" class="<?= $Grid->SIZE_GOODS->headerCellClass() ?>"><div id="elh_GOOD_GF_SIZE_GOODS" class="GOOD_GF_SIZE_GOODS"><?= $Grid->renderSort($Grid->SIZE_GOODS) ?></div></th>
<?php } ?>
<?php if ($Grid->MEASURE_DOSIS->Visible) { // MEASURE_DOSIS ?>
        <th data-name="MEASURE_DOSIS" class="<?= $Grid->MEASURE_DOSIS->headerCellClass() ?>"><div id="elh_GOOD_GF_MEASURE_DOSIS" class="GOOD_GF_MEASURE_DOSIS"><?= $Grid->renderSort($Grid->MEASURE_DOSIS) ?></div></th>
<?php } ?>
<?php if ($Grid->ORDER_PRICE->Visible) { // ORDER_PRICE ?>
        <th data-name="ORDER_PRICE" class="<?= $Grid->ORDER_PRICE->headerCellClass() ?>"><div id="elh_GOOD_GF_ORDER_PRICE" class="GOOD_GF_ORDER_PRICE"><?= $Grid->renderSort($Grid->ORDER_PRICE) ?></div></th>
<?php } ?>
<?php if ($Grid->STOCK_AVAILABLE->Visible) { // STOCK_AVAILABLE ?>
        <th data-name="STOCK_AVAILABLE" class="<?= $Grid->STOCK_AVAILABLE->headerCellClass() ?>"><div id="elh_GOOD_GF_STOCK_AVAILABLE" class="GOOD_GF_STOCK_AVAILABLE"><?= $Grid->renderSort($Grid->STOCK_AVAILABLE) ?></div></th>
<?php } ?>
<?php if ($Grid->STATUS_PASIEN_ID->Visible) { // STATUS_PASIEN_ID ?>
        <th data-name="STATUS_PASIEN_ID" class="<?= $Grid->STATUS_PASIEN_ID->headerCellClass() ?>"><div id="elh_GOOD_GF_STATUS_PASIEN_ID" class="GOOD_GF_STATUS_PASIEN_ID"><?= $Grid->renderSort($Grid->STATUS_PASIEN_ID) ?></div></th>
<?php } ?>
<?php if ($Grid->MONTH_ID->Visible) { // MONTH_ID ?>
        <th data-name="MONTH_ID" class="<?= $Grid->MONTH_ID->headerCellClass() ?>"><div id="elh_GOOD_GF_MONTH_ID" class="GOOD_GF_MONTH_ID"><?= $Grid->renderSort($Grid->MONTH_ID) ?></div></th>
<?php } ?>
<?php if ($Grid->YEAR_ID->Visible) { // YEAR_ID ?>
        <th data-name="YEAR_ID" class="<?= $Grid->YEAR_ID->headerCellClass() ?>"><div id="elh_GOOD_GF_YEAR_ID" class="GOOD_GF_YEAR_ID"><?= $Grid->renderSort($Grid->YEAR_ID) ?></div></th>
<?php } ?>
<?php if ($Grid->CORRECTION_DOC->Visible) { // CORRECTION_DOC ?>
        <th data-name="CORRECTION_DOC" class="<?= $Grid->CORRECTION_DOC->headerCellClass() ?>"><div id="elh_GOOD_GF_CORRECTION_DOC" class="GOOD_GF_CORRECTION_DOC"><?= $Grid->renderSort($Grid->CORRECTION_DOC) ?></div></th>
<?php } ?>
<?php if ($Grid->CORRECTIONS->Visible) { // CORRECTIONS ?>
        <th data-name="CORRECTIONS" class="<?= $Grid->CORRECTIONS->headerCellClass() ?>"><div id="elh_GOOD_GF_CORRECTIONS" class="GOOD_GF_CORRECTIONS"><?= $Grid->renderSort($Grid->CORRECTIONS) ?></div></th>
<?php } ?>
<?php if ($Grid->CORRECTION_DATE->Visible) { // CORRECTION_DATE ?>
        <th data-name="CORRECTION_DATE" class="<?= $Grid->CORRECTION_DATE->headerCellClass() ?>"><div id="elh_GOOD_GF_CORRECTION_DATE" class="GOOD_GF_CORRECTION_DATE"><?= $Grid->renderSort($Grid->CORRECTION_DATE) ?></div></th>
<?php } ?>
<?php if ($Grid->DOC_NO->Visible) { // DOC_NO ?>
        <th data-name="DOC_NO" class="<?= $Grid->DOC_NO->headerCellClass() ?>"><div id="elh_GOOD_GF_DOC_NO" class="GOOD_GF_DOC_NO"><?= $Grid->renderSort($Grid->DOC_NO) ?></div></th>
<?php } ?>
<?php if ($Grid->ORDER_ID->Visible) { // ORDER_ID ?>
        <th data-name="ORDER_ID" class="<?= $Grid->ORDER_ID->headerCellClass() ?>"><div id="elh_GOOD_GF_ORDER_ID" class="GOOD_GF_ORDER_ID"><?= $Grid->renderSort($Grid->ORDER_ID) ?></div></th>
<?php } ?>
<?php if ($Grid->ISCETAK->Visible) { // ISCETAK ?>
        <th data-name="ISCETAK" class="<?= $Grid->ISCETAK->headerCellClass() ?>"><div id="elh_GOOD_GF_ISCETAK" class="GOOD_GF_ISCETAK"><?= $Grid->renderSort($Grid->ISCETAK) ?></div></th>
<?php } ?>
<?php if ($Grid->PRINT_DATE->Visible) { // PRINT_DATE ?>
        <th data-name="PRINT_DATE" class="<?= $Grid->PRINT_DATE->headerCellClass() ?>"><div id="elh_GOOD_GF_PRINT_DATE" class="GOOD_GF_PRINT_DATE"><?= $Grid->renderSort($Grid->PRINT_DATE) ?></div></th>
<?php } ?>
<?php if ($Grid->PRINTED_BY->Visible) { // PRINTED_BY ?>
        <th data-name="PRINTED_BY" class="<?= $Grid->PRINTED_BY->headerCellClass() ?>"><div id="elh_GOOD_GF_PRINTED_BY" class="GOOD_GF_PRINTED_BY"><?= $Grid->renderSort($Grid->PRINTED_BY) ?></div></th>
<?php } ?>
<?php if ($Grid->PRINTQ->Visible) { // PRINTQ ?>
        <th data-name="PRINTQ" class="<?= $Grid->PRINTQ->headerCellClass() ?>"><div id="elh_GOOD_GF_PRINTQ" class="GOOD_GF_PRINTQ"><?= $Grid->renderSort($Grid->PRINTQ) ?></div></th>
<?php } ?>
<?php if ($Grid->avgprice->Visible) { // avgprice ?>
        <th data-name="avgprice" class="<?= $Grid->avgprice->headerCellClass() ?>"><div id="elh_GOOD_GF_avgprice" class="GOOD_GF_avgprice"><?= $Grid->renderSort($Grid->avgprice) ?></div></th>
<?php } ?>
<?php if ($Grid->idx->Visible) { // idx ?>
        <th data-name="idx" class="<?= $Grid->idx->headerCellClass() ?>"><div id="elh_GOOD_GF_idx" class="GOOD_GF_idx"><?= $Grid->renderSort($Grid->idx) ?></div></th>
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
    <?php if ($Grid->ORG_UNIT_CODE->Visible) { // ORG_UNIT_CODE ?>
        <td data-name="ORG_UNIT_CODE" <?= $Grid->ORG_UNIT_CODE->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_ORG_UNIT_CODE" class="form-group">
<input type="<?= $Grid->ORG_UNIT_CODE->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_ORG_UNIT_CODE" name="x<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" id="x<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->ORG_UNIT_CODE->getPlaceHolder()) ?>" value="<?= $Grid->ORG_UNIT_CODE->EditValue ?>"<?= $Grid->ORG_UNIT_CODE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ORG_UNIT_CODE->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_ORG_UNIT_CODE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" id="o<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" value="<?= HtmlEncode($Grid->ORG_UNIT_CODE->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_ORG_UNIT_CODE" class="form-group">
<input type="<?= $Grid->ORG_UNIT_CODE->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_ORG_UNIT_CODE" name="x<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" id="x<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->ORG_UNIT_CODE->getPlaceHolder()) ?>" value="<?= $Grid->ORG_UNIT_CODE->EditValue ?>"<?= $Grid->ORG_UNIT_CODE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ORG_UNIT_CODE->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_ORG_UNIT_CODE">
<span<?= $Grid->ORG_UNIT_CODE->viewAttributes() ?>>
<?= $Grid->ORG_UNIT_CODE->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_ORG_UNIT_CODE" data-hidden="1" name="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" id="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" value="<?= HtmlEncode($Grid->ORG_UNIT_CODE->FormValue) ?>">
<input type="hidden" data-table="GOOD_GF" data-field="x_ORG_UNIT_CODE" data-hidden="1" name="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" id="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" value="<?= HtmlEncode($Grid->ORG_UNIT_CODE->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->ITEM_ID->Visible) { // ITEM_ID ?>
        <td data-name="ITEM_ID" <?= $Grid->ITEM_ID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_ITEM_ID" class="form-group">
<input type="<?= $Grid->ITEM_ID->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_ITEM_ID" name="x<?= $Grid->RowIndex ?>_ITEM_ID" id="x<?= $Grid->RowIndex ?>_ITEM_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->ITEM_ID->getPlaceHolder()) ?>" value="<?= $Grid->ITEM_ID->EditValue ?>"<?= $Grid->ITEM_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ITEM_ID->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_ITEM_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ITEM_ID" id="o<?= $Grid->RowIndex ?>_ITEM_ID" value="<?= HtmlEncode($Grid->ITEM_ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_ITEM_ID" class="form-group">
<input type="<?= $Grid->ITEM_ID->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_ITEM_ID" name="x<?= $Grid->RowIndex ?>_ITEM_ID" id="x<?= $Grid->RowIndex ?>_ITEM_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->ITEM_ID->getPlaceHolder()) ?>" value="<?= $Grid->ITEM_ID->EditValue ?>"<?= $Grid->ITEM_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ITEM_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_ITEM_ID">
<span<?= $Grid->ITEM_ID->viewAttributes() ?>>
<?= $Grid->ITEM_ID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_ITEM_ID" data-hidden="1" name="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_ITEM_ID" id="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_ITEM_ID" value="<?= HtmlEncode($Grid->ITEM_ID->FormValue) ?>">
<input type="hidden" data-table="GOOD_GF" data-field="x_ITEM_ID" data-hidden="1" name="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_ITEM_ID" id="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_ITEM_ID" value="<?= HtmlEncode($Grid->ITEM_ID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
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
    <?php if ($Grid->BATCH_NO->Visible) { // BATCH_NO ?>
        <td data-name="BATCH_NO" <?= $Grid->BATCH_NO->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_BATCH_NO" class="form-group">
<input type="<?= $Grid->BATCH_NO->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_BATCH_NO" name="x<?= $Grid->RowIndex ?>_BATCH_NO" id="x<?= $Grid->RowIndex ?>_BATCH_NO" size="30" maxlength="75" placeholder="<?= HtmlEncode($Grid->BATCH_NO->getPlaceHolder()) ?>" value="<?= $Grid->BATCH_NO->EditValue ?>"<?= $Grid->BATCH_NO->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->BATCH_NO->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_BATCH_NO" data-hidden="1" name="o<?= $Grid->RowIndex ?>_BATCH_NO" id="o<?= $Grid->RowIndex ?>_BATCH_NO" value="<?= HtmlEncode($Grid->BATCH_NO->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_BATCH_NO" class="form-group">
<input type="<?= $Grid->BATCH_NO->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_BATCH_NO" name="x<?= $Grid->RowIndex ?>_BATCH_NO" id="x<?= $Grid->RowIndex ?>_BATCH_NO" size="30" maxlength="75" placeholder="<?= HtmlEncode($Grid->BATCH_NO->getPlaceHolder()) ?>" value="<?= $Grid->BATCH_NO->EditValue ?>"<?= $Grid->BATCH_NO->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->BATCH_NO->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_BATCH_NO">
<span<?= $Grid->BATCH_NO->viewAttributes() ?>>
<?= $Grid->BATCH_NO->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_BATCH_NO" data-hidden="1" name="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_BATCH_NO" id="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_BATCH_NO" value="<?= HtmlEncode($Grid->BATCH_NO->FormValue) ?>">
<input type="hidden" data-table="GOOD_GF" data-field="x_BATCH_NO" data-hidden="1" name="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_BATCH_NO" id="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_BATCH_NO" value="<?= HtmlEncode($Grid->BATCH_NO->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->BRAND_ID->Visible) { // BRAND_ID ?>
        <td data-name="BRAND_ID" <?= $Grid->BRAND_ID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_BRAND_ID" class="form-group">
<input type="<?= $Grid->BRAND_ID->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_BRAND_ID" name="x<?= $Grid->RowIndex ?>_BRAND_ID" id="x<?= $Grid->RowIndex ?>_BRAND_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->BRAND_ID->getPlaceHolder()) ?>" value="<?= $Grid->BRAND_ID->EditValue ?>"<?= $Grid->BRAND_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->BRAND_ID->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_BRAND_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_BRAND_ID" id="o<?= $Grid->RowIndex ?>_BRAND_ID" value="<?= HtmlEncode($Grid->BRAND_ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_BRAND_ID" class="form-group">
<input type="<?= $Grid->BRAND_ID->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_BRAND_ID" name="x<?= $Grid->RowIndex ?>_BRAND_ID" id="x<?= $Grid->RowIndex ?>_BRAND_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->BRAND_ID->getPlaceHolder()) ?>" value="<?= $Grid->BRAND_ID->EditValue ?>"<?= $Grid->BRAND_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->BRAND_ID->getErrorMessage() ?></div>
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
    <?php if ($Grid->SHELF_NO->Visible) { // SHELF_NO ?>
        <td data-name="SHELF_NO" <?= $Grid->SHELF_NO->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_SHELF_NO" class="form-group">
<input type="<?= $Grid->SHELF_NO->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_SHELF_NO" name="x<?= $Grid->RowIndex ?>_SHELF_NO" id="x<?= $Grid->RowIndex ?>_SHELF_NO" size="30" placeholder="<?= HtmlEncode($Grid->SHELF_NO->getPlaceHolder()) ?>" value="<?= $Grid->SHELF_NO->EditValue ?>"<?= $Grid->SHELF_NO->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->SHELF_NO->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_SHELF_NO" data-hidden="1" name="o<?= $Grid->RowIndex ?>_SHELF_NO" id="o<?= $Grid->RowIndex ?>_SHELF_NO" value="<?= HtmlEncode($Grid->SHELF_NO->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_SHELF_NO" class="form-group">
<input type="<?= $Grid->SHELF_NO->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_SHELF_NO" name="x<?= $Grid->RowIndex ?>_SHELF_NO" id="x<?= $Grid->RowIndex ?>_SHELF_NO" size="30" placeholder="<?= HtmlEncode($Grid->SHELF_NO->getPlaceHolder()) ?>" value="<?= $Grid->SHELF_NO->EditValue ?>"<?= $Grid->SHELF_NO->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->SHELF_NO->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_SHELF_NO">
<span<?= $Grid->SHELF_NO->viewAttributes() ?>>
<?= $Grid->SHELF_NO->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_SHELF_NO" data-hidden="1" name="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_SHELF_NO" id="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_SHELF_NO" value="<?= HtmlEncode($Grid->SHELF_NO->FormValue) ?>">
<input type="hidden" data-table="GOOD_GF" data-field="x_SHELF_NO" data-hidden="1" name="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_SHELF_NO" id="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_SHELF_NO" value="<?= HtmlEncode($Grid->SHELF_NO->OldValue) ?>">
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
    <?php if ($Grid->SERIAL_NB->Visible) { // SERIAL_NB ?>
        <td data-name="SERIAL_NB" <?= $Grid->SERIAL_NB->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_SERIAL_NB" class="form-group">
<input type="<?= $Grid->SERIAL_NB->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_SERIAL_NB" name="x<?= $Grid->RowIndex ?>_SERIAL_NB" id="x<?= $Grid->RowIndex ?>_SERIAL_NB" size="30" maxlength="200" placeholder="<?= HtmlEncode($Grid->SERIAL_NB->getPlaceHolder()) ?>" value="<?= $Grid->SERIAL_NB->EditValue ?>"<?= $Grid->SERIAL_NB->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->SERIAL_NB->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_SERIAL_NB" data-hidden="1" name="o<?= $Grid->RowIndex ?>_SERIAL_NB" id="o<?= $Grid->RowIndex ?>_SERIAL_NB" value="<?= HtmlEncode($Grid->SERIAL_NB->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_SERIAL_NB" class="form-group">
<input type="<?= $Grid->SERIAL_NB->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_SERIAL_NB" name="x<?= $Grid->RowIndex ?>_SERIAL_NB" id="x<?= $Grid->RowIndex ?>_SERIAL_NB" size="30" maxlength="200" placeholder="<?= HtmlEncode($Grid->SERIAL_NB->getPlaceHolder()) ?>" value="<?= $Grid->SERIAL_NB->EditValue ?>"<?= $Grid->SERIAL_NB->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->SERIAL_NB->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_SERIAL_NB">
<span<?= $Grid->SERIAL_NB->viewAttributes() ?>>
<?= $Grid->SERIAL_NB->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_SERIAL_NB" data-hidden="1" name="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_SERIAL_NB" id="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_SERIAL_NB" value="<?= HtmlEncode($Grid->SERIAL_NB->FormValue) ?>">
<input type="hidden" data-table="GOOD_GF" data-field="x_SERIAL_NB" data-hidden="1" name="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_SERIAL_NB" id="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_SERIAL_NB" value="<?= HtmlEncode($Grid->SERIAL_NB->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->FROM_ROOMS_ID->Visible) { // FROM_ROOMS_ID ?>
        <td data-name="FROM_ROOMS_ID" <?= $Grid->FROM_ROOMS_ID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_FROM_ROOMS_ID" class="form-group">
<input type="<?= $Grid->FROM_ROOMS_ID->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_FROM_ROOMS_ID" name="x<?= $Grid->RowIndex ?>_FROM_ROOMS_ID" id="x<?= $Grid->RowIndex ?>_FROM_ROOMS_ID" size="30" maxlength="10" placeholder="<?= HtmlEncode($Grid->FROM_ROOMS_ID->getPlaceHolder()) ?>" value="<?= $Grid->FROM_ROOMS_ID->EditValue ?>"<?= $Grid->FROM_ROOMS_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->FROM_ROOMS_ID->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_FROM_ROOMS_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_FROM_ROOMS_ID" id="o<?= $Grid->RowIndex ?>_FROM_ROOMS_ID" value="<?= HtmlEncode($Grid->FROM_ROOMS_ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_FROM_ROOMS_ID" class="form-group">
<input type="<?= $Grid->FROM_ROOMS_ID->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_FROM_ROOMS_ID" name="x<?= $Grid->RowIndex ?>_FROM_ROOMS_ID" id="x<?= $Grid->RowIndex ?>_FROM_ROOMS_ID" size="30" maxlength="10" placeholder="<?= HtmlEncode($Grid->FROM_ROOMS_ID->getPlaceHolder()) ?>" value="<?= $Grid->FROM_ROOMS_ID->EditValue ?>"<?= $Grid->FROM_ROOMS_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->FROM_ROOMS_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_FROM_ROOMS_ID">
<span<?= $Grid->FROM_ROOMS_ID->viewAttributes() ?>>
<?= $Grid->FROM_ROOMS_ID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_FROM_ROOMS_ID" data-hidden="1" name="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_FROM_ROOMS_ID" id="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_FROM_ROOMS_ID" value="<?= HtmlEncode($Grid->FROM_ROOMS_ID->FormValue) ?>">
<input type="hidden" data-table="GOOD_GF" data-field="x_FROM_ROOMS_ID" data-hidden="1" name="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_FROM_ROOMS_ID" id="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_FROM_ROOMS_ID" value="<?= HtmlEncode($Grid->FROM_ROOMS_ID->OldValue) ?>">
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
    <?php if ($Grid->DISTRIBUTION_TYPE->Visible) { // DISTRIBUTION_TYPE ?>
        <td data-name="DISTRIBUTION_TYPE" <?= $Grid->DISTRIBUTION_TYPE->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_DISTRIBUTION_TYPE" class="form-group">
<input type="<?= $Grid->DISTRIBUTION_TYPE->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_DISTRIBUTION_TYPE" name="x<?= $Grid->RowIndex ?>_DISTRIBUTION_TYPE" id="x<?= $Grid->RowIndex ?>_DISTRIBUTION_TYPE" size="30" placeholder="<?= HtmlEncode($Grid->DISTRIBUTION_TYPE->getPlaceHolder()) ?>" value="<?= $Grid->DISTRIBUTION_TYPE->EditValue ?>"<?= $Grid->DISTRIBUTION_TYPE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->DISTRIBUTION_TYPE->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_DISTRIBUTION_TYPE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_DISTRIBUTION_TYPE" id="o<?= $Grid->RowIndex ?>_DISTRIBUTION_TYPE" value="<?= HtmlEncode($Grid->DISTRIBUTION_TYPE->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_DISTRIBUTION_TYPE" class="form-group">
<input type="<?= $Grid->DISTRIBUTION_TYPE->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_DISTRIBUTION_TYPE" name="x<?= $Grid->RowIndex ?>_DISTRIBUTION_TYPE" id="x<?= $Grid->RowIndex ?>_DISTRIBUTION_TYPE" size="30" placeholder="<?= HtmlEncode($Grid->DISTRIBUTION_TYPE->getPlaceHolder()) ?>" value="<?= $Grid->DISTRIBUTION_TYPE->EditValue ?>"<?= $Grid->DISTRIBUTION_TYPE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->DISTRIBUTION_TYPE->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_DISTRIBUTION_TYPE">
<span<?= $Grid->DISTRIBUTION_TYPE->viewAttributes() ?>>
<?= $Grid->DISTRIBUTION_TYPE->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_DISTRIBUTION_TYPE" data-hidden="1" name="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_DISTRIBUTION_TYPE" id="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_DISTRIBUTION_TYPE" value="<?= HtmlEncode($Grid->DISTRIBUTION_TYPE->FormValue) ?>">
<input type="hidden" data-table="GOOD_GF" data-field="x_DISTRIBUTION_TYPE" data-hidden="1" name="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_DISTRIBUTION_TYPE" id="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_DISTRIBUTION_TYPE" value="<?= HtmlEncode($Grid->DISTRIBUTION_TYPE->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->CONDITION->Visible) { // CONDITION ?>
        <td data-name="CONDITION" <?= $Grid->CONDITION->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_CONDITION" class="form-group">
<input type="<?= $Grid->CONDITION->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_CONDITION" name="x<?= $Grid->RowIndex ?>_CONDITION" id="x<?= $Grid->RowIndex ?>_CONDITION" size="30" placeholder="<?= HtmlEncode($Grid->CONDITION->getPlaceHolder()) ?>" value="<?= $Grid->CONDITION->EditValue ?>"<?= $Grid->CONDITION->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->CONDITION->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_CONDITION" data-hidden="1" name="o<?= $Grid->RowIndex ?>_CONDITION" id="o<?= $Grid->RowIndex ?>_CONDITION" value="<?= HtmlEncode($Grid->CONDITION->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_CONDITION" class="form-group">
<input type="<?= $Grid->CONDITION->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_CONDITION" name="x<?= $Grid->RowIndex ?>_CONDITION" id="x<?= $Grid->RowIndex ?>_CONDITION" size="30" placeholder="<?= HtmlEncode($Grid->CONDITION->getPlaceHolder()) ?>" value="<?= $Grid->CONDITION->EditValue ?>"<?= $Grid->CONDITION->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->CONDITION->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_CONDITION">
<span<?= $Grid->CONDITION->viewAttributes() ?>>
<?= $Grid->CONDITION->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_CONDITION" data-hidden="1" name="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_CONDITION" id="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_CONDITION" value="<?= HtmlEncode($Grid->CONDITION->FormValue) ?>">
<input type="hidden" data-table="GOOD_GF" data-field="x_CONDITION" data-hidden="1" name="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_CONDITION" id="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_CONDITION" value="<?= HtmlEncode($Grid->CONDITION->OldValue) ?>">
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
    <?php if ($Grid->STOCKOPNAME_DATE->Visible) { // STOCKOPNAME_DATE ?>
        <td data-name="STOCKOPNAME_DATE" <?= $Grid->STOCKOPNAME_DATE->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_STOCKOPNAME_DATE" class="form-group">
<input type="<?= $Grid->STOCKOPNAME_DATE->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_STOCKOPNAME_DATE" name="x<?= $Grid->RowIndex ?>_STOCKOPNAME_DATE" id="x<?= $Grid->RowIndex ?>_STOCKOPNAME_DATE" placeholder="<?= HtmlEncode($Grid->STOCKOPNAME_DATE->getPlaceHolder()) ?>" value="<?= $Grid->STOCKOPNAME_DATE->EditValue ?>"<?= $Grid->STOCKOPNAME_DATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->STOCKOPNAME_DATE->getErrorMessage() ?></div>
<?php if (!$Grid->STOCKOPNAME_DATE->ReadOnly && !$Grid->STOCKOPNAME_DATE->Disabled && !isset($Grid->STOCKOPNAME_DATE->EditAttrs["readonly"]) && !isset($Grid->STOCKOPNAME_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fGOOD_GFgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fGOOD_GFgrid", "x<?= $Grid->RowIndex ?>_STOCKOPNAME_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_STOCKOPNAME_DATE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_STOCKOPNAME_DATE" id="o<?= $Grid->RowIndex ?>_STOCKOPNAME_DATE" value="<?= HtmlEncode($Grid->STOCKOPNAME_DATE->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_STOCKOPNAME_DATE" class="form-group">
<input type="<?= $Grid->STOCKOPNAME_DATE->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_STOCKOPNAME_DATE" name="x<?= $Grid->RowIndex ?>_STOCKOPNAME_DATE" id="x<?= $Grid->RowIndex ?>_STOCKOPNAME_DATE" placeholder="<?= HtmlEncode($Grid->STOCKOPNAME_DATE->getPlaceHolder()) ?>" value="<?= $Grid->STOCKOPNAME_DATE->EditValue ?>"<?= $Grid->STOCKOPNAME_DATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->STOCKOPNAME_DATE->getErrorMessage() ?></div>
<?php if (!$Grid->STOCKOPNAME_DATE->ReadOnly && !$Grid->STOCKOPNAME_DATE->Disabled && !isset($Grid->STOCKOPNAME_DATE->EditAttrs["readonly"]) && !isset($Grid->STOCKOPNAME_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fGOOD_GFgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fGOOD_GFgrid", "x<?= $Grid->RowIndex ?>_STOCKOPNAME_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_STOCKOPNAME_DATE">
<span<?= $Grid->STOCKOPNAME_DATE->viewAttributes() ?>>
<?= $Grid->STOCKOPNAME_DATE->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_STOCKOPNAME_DATE" data-hidden="1" name="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_STOCKOPNAME_DATE" id="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_STOCKOPNAME_DATE" value="<?= HtmlEncode($Grid->STOCKOPNAME_DATE->FormValue) ?>">
<input type="hidden" data-table="GOOD_GF" data-field="x_STOCKOPNAME_DATE" data-hidden="1" name="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_STOCKOPNAME_DATE" id="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_STOCKOPNAME_DATE" value="<?= HtmlEncode($Grid->STOCKOPNAME_DATE->OldValue) ?>">
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
    <?php if ($Grid->DISCOUNT->Visible) { // DISCOUNT ?>
        <td data-name="DISCOUNT" <?= $Grid->DISCOUNT->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_DISCOUNT" class="form-group">
<input type="<?= $Grid->DISCOUNT->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_DISCOUNT" name="x<?= $Grid->RowIndex ?>_DISCOUNT" id="x<?= $Grid->RowIndex ?>_DISCOUNT" size="30" placeholder="<?= HtmlEncode($Grid->DISCOUNT->getPlaceHolder()) ?>" value="<?= $Grid->DISCOUNT->EditValue ?>"<?= $Grid->DISCOUNT->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->DISCOUNT->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_DISCOUNT" data-hidden="1" name="o<?= $Grid->RowIndex ?>_DISCOUNT" id="o<?= $Grid->RowIndex ?>_DISCOUNT" value="<?= HtmlEncode($Grid->DISCOUNT->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_DISCOUNT" class="form-group">
<input type="<?= $Grid->DISCOUNT->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_DISCOUNT" name="x<?= $Grid->RowIndex ?>_DISCOUNT" id="x<?= $Grid->RowIndex ?>_DISCOUNT" size="30" placeholder="<?= HtmlEncode($Grid->DISCOUNT->getPlaceHolder()) ?>" value="<?= $Grid->DISCOUNT->EditValue ?>"<?= $Grid->DISCOUNT->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->DISCOUNT->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_DISCOUNT">
<span<?= $Grid->DISCOUNT->viewAttributes() ?>>
<?= $Grid->DISCOUNT->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_DISCOUNT" data-hidden="1" name="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_DISCOUNT" id="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_DISCOUNT" value="<?= HtmlEncode($Grid->DISCOUNT->FormValue) ?>">
<input type="hidden" data-table="GOOD_GF" data-field="x_DISCOUNT" data-hidden="1" name="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_DISCOUNT" id="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_DISCOUNT" value="<?= HtmlEncode($Grid->DISCOUNT->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->DISCOUNT2->Visible) { // DISCOUNT2 ?>
        <td data-name="DISCOUNT2" <?= $Grid->DISCOUNT2->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_DISCOUNT2" class="form-group">
<input type="<?= $Grid->DISCOUNT2->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_DISCOUNT2" name="x<?= $Grid->RowIndex ?>_DISCOUNT2" id="x<?= $Grid->RowIndex ?>_DISCOUNT2" size="30" placeholder="<?= HtmlEncode($Grid->DISCOUNT2->getPlaceHolder()) ?>" value="<?= $Grid->DISCOUNT2->EditValue ?>"<?= $Grid->DISCOUNT2->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->DISCOUNT2->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_DISCOUNT2" data-hidden="1" name="o<?= $Grid->RowIndex ?>_DISCOUNT2" id="o<?= $Grid->RowIndex ?>_DISCOUNT2" value="<?= HtmlEncode($Grid->DISCOUNT2->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_DISCOUNT2" class="form-group">
<input type="<?= $Grid->DISCOUNT2->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_DISCOUNT2" name="x<?= $Grid->RowIndex ?>_DISCOUNT2" id="x<?= $Grid->RowIndex ?>_DISCOUNT2" size="30" placeholder="<?= HtmlEncode($Grid->DISCOUNT2->getPlaceHolder()) ?>" value="<?= $Grid->DISCOUNT2->EditValue ?>"<?= $Grid->DISCOUNT2->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->DISCOUNT2->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_DISCOUNT2">
<span<?= $Grid->DISCOUNT2->viewAttributes() ?>>
<?= $Grid->DISCOUNT2->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_DISCOUNT2" data-hidden="1" name="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_DISCOUNT2" id="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_DISCOUNT2" value="<?= HtmlEncode($Grid->DISCOUNT2->FormValue) ?>">
<input type="hidden" data-table="GOOD_GF" data-field="x_DISCOUNT2" data-hidden="1" name="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_DISCOUNT2" id="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_DISCOUNT2" value="<?= HtmlEncode($Grid->DISCOUNT2->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->DISCOUNTOFF->Visible) { // DISCOUNTOFF ?>
        <td data-name="DISCOUNTOFF" <?= $Grid->DISCOUNTOFF->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_DISCOUNTOFF" class="form-group">
<input type="<?= $Grid->DISCOUNTOFF->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_DISCOUNTOFF" name="x<?= $Grid->RowIndex ?>_DISCOUNTOFF" id="x<?= $Grid->RowIndex ?>_DISCOUNTOFF" size="30" placeholder="<?= HtmlEncode($Grid->DISCOUNTOFF->getPlaceHolder()) ?>" value="<?= $Grid->DISCOUNTOFF->EditValue ?>"<?= $Grid->DISCOUNTOFF->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->DISCOUNTOFF->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_DISCOUNTOFF" data-hidden="1" name="o<?= $Grid->RowIndex ?>_DISCOUNTOFF" id="o<?= $Grid->RowIndex ?>_DISCOUNTOFF" value="<?= HtmlEncode($Grid->DISCOUNTOFF->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_DISCOUNTOFF" class="form-group">
<input type="<?= $Grid->DISCOUNTOFF->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_DISCOUNTOFF" name="x<?= $Grid->RowIndex ?>_DISCOUNTOFF" id="x<?= $Grid->RowIndex ?>_DISCOUNTOFF" size="30" placeholder="<?= HtmlEncode($Grid->DISCOUNTOFF->getPlaceHolder()) ?>" value="<?= $Grid->DISCOUNTOFF->EditValue ?>"<?= $Grid->DISCOUNTOFF->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->DISCOUNTOFF->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_DISCOUNTOFF">
<span<?= $Grid->DISCOUNTOFF->viewAttributes() ?>>
<?= $Grid->DISCOUNTOFF->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_DISCOUNTOFF" data-hidden="1" name="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_DISCOUNTOFF" id="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_DISCOUNTOFF" value="<?= HtmlEncode($Grid->DISCOUNTOFF->FormValue) ?>">
<input type="hidden" data-table="GOOD_GF" data-field="x_DISCOUNTOFF" data-hidden="1" name="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_DISCOUNTOFF" id="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_DISCOUNTOFF" value="<?= HtmlEncode($Grid->DISCOUNTOFF->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->ORG_UNIT_FROM->Visible) { // ORG_UNIT_FROM ?>
        <td data-name="ORG_UNIT_FROM" <?= $Grid->ORG_UNIT_FROM->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_ORG_UNIT_FROM" class="form-group">
<input type="<?= $Grid->ORG_UNIT_FROM->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_ORG_UNIT_FROM" name="x<?= $Grid->RowIndex ?>_ORG_UNIT_FROM" id="x<?= $Grid->RowIndex ?>_ORG_UNIT_FROM" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->ORG_UNIT_FROM->getPlaceHolder()) ?>" value="<?= $Grid->ORG_UNIT_FROM->EditValue ?>"<?= $Grid->ORG_UNIT_FROM->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ORG_UNIT_FROM->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_ORG_UNIT_FROM" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ORG_UNIT_FROM" id="o<?= $Grid->RowIndex ?>_ORG_UNIT_FROM" value="<?= HtmlEncode($Grid->ORG_UNIT_FROM->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_ORG_UNIT_FROM" class="form-group">
<input type="<?= $Grid->ORG_UNIT_FROM->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_ORG_UNIT_FROM" name="x<?= $Grid->RowIndex ?>_ORG_UNIT_FROM" id="x<?= $Grid->RowIndex ?>_ORG_UNIT_FROM" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->ORG_UNIT_FROM->getPlaceHolder()) ?>" value="<?= $Grid->ORG_UNIT_FROM->EditValue ?>"<?= $Grid->ORG_UNIT_FROM->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ORG_UNIT_FROM->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_ORG_UNIT_FROM">
<span<?= $Grid->ORG_UNIT_FROM->viewAttributes() ?>>
<?= $Grid->ORG_UNIT_FROM->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_ORG_UNIT_FROM" data-hidden="1" name="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_ORG_UNIT_FROM" id="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_ORG_UNIT_FROM" value="<?= HtmlEncode($Grid->ORG_UNIT_FROM->FormValue) ?>">
<input type="hidden" data-table="GOOD_GF" data-field="x_ORG_UNIT_FROM" data-hidden="1" name="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_ORG_UNIT_FROM" id="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_ORG_UNIT_FROM" value="<?= HtmlEncode($Grid->ORG_UNIT_FROM->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->ITEM_ID_FROM->Visible) { // ITEM_ID_FROM ?>
        <td data-name="ITEM_ID_FROM" <?= $Grid->ITEM_ID_FROM->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_ITEM_ID_FROM" class="form-group">
<input type="<?= $Grid->ITEM_ID_FROM->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_ITEM_ID_FROM" name="x<?= $Grid->RowIndex ?>_ITEM_ID_FROM" id="x<?= $Grid->RowIndex ?>_ITEM_ID_FROM" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->ITEM_ID_FROM->getPlaceHolder()) ?>" value="<?= $Grid->ITEM_ID_FROM->EditValue ?>"<?= $Grid->ITEM_ID_FROM->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ITEM_ID_FROM->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_ITEM_ID_FROM" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ITEM_ID_FROM" id="o<?= $Grid->RowIndex ?>_ITEM_ID_FROM" value="<?= HtmlEncode($Grid->ITEM_ID_FROM->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_ITEM_ID_FROM" class="form-group">
<input type="<?= $Grid->ITEM_ID_FROM->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_ITEM_ID_FROM" name="x<?= $Grid->RowIndex ?>_ITEM_ID_FROM" id="x<?= $Grid->RowIndex ?>_ITEM_ID_FROM" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->ITEM_ID_FROM->getPlaceHolder()) ?>" value="<?= $Grid->ITEM_ID_FROM->EditValue ?>"<?= $Grid->ITEM_ID_FROM->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ITEM_ID_FROM->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_ITEM_ID_FROM">
<span<?= $Grid->ITEM_ID_FROM->viewAttributes() ?>>
<?= $Grid->ITEM_ID_FROM->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_ITEM_ID_FROM" data-hidden="1" name="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_ITEM_ID_FROM" id="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_ITEM_ID_FROM" value="<?= HtmlEncode($Grid->ITEM_ID_FROM->FormValue) ?>">
<input type="hidden" data-table="GOOD_GF" data-field="x_ITEM_ID_FROM" data-hidden="1" name="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_ITEM_ID_FROM" id="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_ITEM_ID_FROM" value="<?= HtmlEncode($Grid->ITEM_ID_FROM->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
        <td data-name="MODIFIED_DATE" <?= $Grid->MODIFIED_DATE->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_MODIFIED_DATE" class="form-group">
<input type="<?= $Grid->MODIFIED_DATE->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_MODIFIED_DATE" name="x<?= $Grid->RowIndex ?>_MODIFIED_DATE" id="x<?= $Grid->RowIndex ?>_MODIFIED_DATE" placeholder="<?= HtmlEncode($Grid->MODIFIED_DATE->getPlaceHolder()) ?>" value="<?= $Grid->MODIFIED_DATE->EditValue ?>"<?= $Grid->MODIFIED_DATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->MODIFIED_DATE->getErrorMessage() ?></div>
<?php if (!$Grid->MODIFIED_DATE->ReadOnly && !$Grid->MODIFIED_DATE->Disabled && !isset($Grid->MODIFIED_DATE->EditAttrs["readonly"]) && !isset($Grid->MODIFIED_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fGOOD_GFgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fGOOD_GFgrid", "x<?= $Grid->RowIndex ?>_MODIFIED_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_MODIFIED_DATE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_MODIFIED_DATE" id="o<?= $Grid->RowIndex ?>_MODIFIED_DATE" value="<?= HtmlEncode($Grid->MODIFIED_DATE->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_MODIFIED_DATE" class="form-group">
<input type="<?= $Grid->MODIFIED_DATE->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_MODIFIED_DATE" name="x<?= $Grid->RowIndex ?>_MODIFIED_DATE" id="x<?= $Grid->RowIndex ?>_MODIFIED_DATE" placeholder="<?= HtmlEncode($Grid->MODIFIED_DATE->getPlaceHolder()) ?>" value="<?= $Grid->MODIFIED_DATE->EditValue ?>"<?= $Grid->MODIFIED_DATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->MODIFIED_DATE->getErrorMessage() ?></div>
<?php if (!$Grid->MODIFIED_DATE->ReadOnly && !$Grid->MODIFIED_DATE->Disabled && !isset($Grid->MODIFIED_DATE->EditAttrs["readonly"]) && !isset($Grid->MODIFIED_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fGOOD_GFgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fGOOD_GFgrid", "x<?= $Grid->RowIndex ?>_MODIFIED_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_MODIFIED_DATE">
<span<?= $Grid->MODIFIED_DATE->viewAttributes() ?>>
<?= $Grid->MODIFIED_DATE->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_MODIFIED_DATE" data-hidden="1" name="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_MODIFIED_DATE" id="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_MODIFIED_DATE" value="<?= HtmlEncode($Grid->MODIFIED_DATE->FormValue) ?>">
<input type="hidden" data-table="GOOD_GF" data-field="x_MODIFIED_DATE" data-hidden="1" name="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_MODIFIED_DATE" id="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_MODIFIED_DATE" value="<?= HtmlEncode($Grid->MODIFIED_DATE->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
        <td data-name="MODIFIED_BY" <?= $Grid->MODIFIED_BY->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_MODIFIED_BY" class="form-group">
<input type="<?= $Grid->MODIFIED_BY->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_MODIFIED_BY" name="x<?= $Grid->RowIndex ?>_MODIFIED_BY" id="x<?= $Grid->RowIndex ?>_MODIFIED_BY" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->MODIFIED_BY->getPlaceHolder()) ?>" value="<?= $Grid->MODIFIED_BY->EditValue ?>"<?= $Grid->MODIFIED_BY->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->MODIFIED_BY->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_MODIFIED_BY" data-hidden="1" name="o<?= $Grid->RowIndex ?>_MODIFIED_BY" id="o<?= $Grid->RowIndex ?>_MODIFIED_BY" value="<?= HtmlEncode($Grid->MODIFIED_BY->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_MODIFIED_BY" class="form-group">
<input type="<?= $Grid->MODIFIED_BY->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_MODIFIED_BY" name="x<?= $Grid->RowIndex ?>_MODIFIED_BY" id="x<?= $Grid->RowIndex ?>_MODIFIED_BY" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->MODIFIED_BY->getPlaceHolder()) ?>" value="<?= $Grid->MODIFIED_BY->EditValue ?>"<?= $Grid->MODIFIED_BY->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->MODIFIED_BY->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_MODIFIED_BY">
<span<?= $Grid->MODIFIED_BY->viewAttributes() ?>>
<?= $Grid->MODIFIED_BY->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_MODIFIED_BY" data-hidden="1" name="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_MODIFIED_BY" id="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_MODIFIED_BY" value="<?= HtmlEncode($Grid->MODIFIED_BY->FormValue) ?>">
<input type="hidden" data-table="GOOD_GF" data-field="x_MODIFIED_BY" data-hidden="1" name="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_MODIFIED_BY" id="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_MODIFIED_BY" value="<?= HtmlEncode($Grid->MODIFIED_BY->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->STOCK_OPNAME->Visible) { // STOCK_OPNAME ?>
        <td data-name="STOCK_OPNAME" <?= $Grid->STOCK_OPNAME->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_STOCK_OPNAME" class="form-group">
<input type="<?= $Grid->STOCK_OPNAME->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_STOCK_OPNAME" name="x<?= $Grid->RowIndex ?>_STOCK_OPNAME" id="x<?= $Grid->RowIndex ?>_STOCK_OPNAME" size="30" placeholder="<?= HtmlEncode($Grid->STOCK_OPNAME->getPlaceHolder()) ?>" value="<?= $Grid->STOCK_OPNAME->EditValue ?>"<?= $Grid->STOCK_OPNAME->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->STOCK_OPNAME->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_STOCK_OPNAME" data-hidden="1" name="o<?= $Grid->RowIndex ?>_STOCK_OPNAME" id="o<?= $Grid->RowIndex ?>_STOCK_OPNAME" value="<?= HtmlEncode($Grid->STOCK_OPNAME->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_STOCK_OPNAME" class="form-group">
<input type="<?= $Grid->STOCK_OPNAME->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_STOCK_OPNAME" name="x<?= $Grid->RowIndex ?>_STOCK_OPNAME" id="x<?= $Grid->RowIndex ?>_STOCK_OPNAME" size="30" placeholder="<?= HtmlEncode($Grid->STOCK_OPNAME->getPlaceHolder()) ?>" value="<?= $Grid->STOCK_OPNAME->EditValue ?>"<?= $Grid->STOCK_OPNAME->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->STOCK_OPNAME->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_STOCK_OPNAME">
<span<?= $Grid->STOCK_OPNAME->viewAttributes() ?>>
<?= $Grid->STOCK_OPNAME->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_STOCK_OPNAME" data-hidden="1" name="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_STOCK_OPNAME" id="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_STOCK_OPNAME" value="<?= HtmlEncode($Grid->STOCK_OPNAME->FormValue) ?>">
<input type="hidden" data-table="GOOD_GF" data-field="x_STOCK_OPNAME" data-hidden="1" name="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_STOCK_OPNAME" id="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_STOCK_OPNAME" value="<?= HtmlEncode($Grid->STOCK_OPNAME->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->STOK_AWAL->Visible) { // STOK_AWAL ?>
        <td data-name="STOK_AWAL" <?= $Grid->STOK_AWAL->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_STOK_AWAL" class="form-group">
<input type="<?= $Grid->STOK_AWAL->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_STOK_AWAL" name="x<?= $Grid->RowIndex ?>_STOK_AWAL" id="x<?= $Grid->RowIndex ?>_STOK_AWAL" size="30" placeholder="<?= HtmlEncode($Grid->STOK_AWAL->getPlaceHolder()) ?>" value="<?= $Grid->STOK_AWAL->EditValue ?>"<?= $Grid->STOK_AWAL->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->STOK_AWAL->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_STOK_AWAL" data-hidden="1" name="o<?= $Grid->RowIndex ?>_STOK_AWAL" id="o<?= $Grid->RowIndex ?>_STOK_AWAL" value="<?= HtmlEncode($Grid->STOK_AWAL->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_STOK_AWAL" class="form-group">
<input type="<?= $Grid->STOK_AWAL->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_STOK_AWAL" name="x<?= $Grid->RowIndex ?>_STOK_AWAL" id="x<?= $Grid->RowIndex ?>_STOK_AWAL" size="30" placeholder="<?= HtmlEncode($Grid->STOK_AWAL->getPlaceHolder()) ?>" value="<?= $Grid->STOK_AWAL->EditValue ?>"<?= $Grid->STOK_AWAL->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->STOK_AWAL->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_STOK_AWAL">
<span<?= $Grid->STOK_AWAL->viewAttributes() ?>>
<?= $Grid->STOK_AWAL->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_STOK_AWAL" data-hidden="1" name="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_STOK_AWAL" id="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_STOK_AWAL" value="<?= HtmlEncode($Grid->STOK_AWAL->FormValue) ?>">
<input type="hidden" data-table="GOOD_GF" data-field="x_STOK_AWAL" data-hidden="1" name="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_STOK_AWAL" id="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_STOK_AWAL" value="<?= HtmlEncode($Grid->STOK_AWAL->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->STOCK_LALU->Visible) { // STOCK_LALU ?>
        <td data-name="STOCK_LALU" <?= $Grid->STOCK_LALU->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_STOCK_LALU" class="form-group">
<input type="<?= $Grid->STOCK_LALU->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_STOCK_LALU" name="x<?= $Grid->RowIndex ?>_STOCK_LALU" id="x<?= $Grid->RowIndex ?>_STOCK_LALU" size="30" placeholder="<?= HtmlEncode($Grid->STOCK_LALU->getPlaceHolder()) ?>" value="<?= $Grid->STOCK_LALU->EditValue ?>"<?= $Grid->STOCK_LALU->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->STOCK_LALU->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_STOCK_LALU" data-hidden="1" name="o<?= $Grid->RowIndex ?>_STOCK_LALU" id="o<?= $Grid->RowIndex ?>_STOCK_LALU" value="<?= HtmlEncode($Grid->STOCK_LALU->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_STOCK_LALU" class="form-group">
<input type="<?= $Grid->STOCK_LALU->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_STOCK_LALU" name="x<?= $Grid->RowIndex ?>_STOCK_LALU" id="x<?= $Grid->RowIndex ?>_STOCK_LALU" size="30" placeholder="<?= HtmlEncode($Grid->STOCK_LALU->getPlaceHolder()) ?>" value="<?= $Grid->STOCK_LALU->EditValue ?>"<?= $Grid->STOCK_LALU->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->STOCK_LALU->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_STOCK_LALU">
<span<?= $Grid->STOCK_LALU->viewAttributes() ?>>
<?= $Grid->STOCK_LALU->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_STOCK_LALU" data-hidden="1" name="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_STOCK_LALU" id="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_STOCK_LALU" value="<?= HtmlEncode($Grid->STOCK_LALU->FormValue) ?>">
<input type="hidden" data-table="GOOD_GF" data-field="x_STOCK_LALU" data-hidden="1" name="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_STOCK_LALU" id="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_STOCK_LALU" value="<?= HtmlEncode($Grid->STOCK_LALU->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->STOCK_KOREKSI->Visible) { // STOCK_KOREKSI ?>
        <td data-name="STOCK_KOREKSI" <?= $Grid->STOCK_KOREKSI->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_STOCK_KOREKSI" class="form-group">
<input type="<?= $Grid->STOCK_KOREKSI->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_STOCK_KOREKSI" name="x<?= $Grid->RowIndex ?>_STOCK_KOREKSI" id="x<?= $Grid->RowIndex ?>_STOCK_KOREKSI" size="30" placeholder="<?= HtmlEncode($Grid->STOCK_KOREKSI->getPlaceHolder()) ?>" value="<?= $Grid->STOCK_KOREKSI->EditValue ?>"<?= $Grid->STOCK_KOREKSI->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->STOCK_KOREKSI->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_STOCK_KOREKSI" data-hidden="1" name="o<?= $Grid->RowIndex ?>_STOCK_KOREKSI" id="o<?= $Grid->RowIndex ?>_STOCK_KOREKSI" value="<?= HtmlEncode($Grid->STOCK_KOREKSI->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_STOCK_KOREKSI" class="form-group">
<input type="<?= $Grid->STOCK_KOREKSI->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_STOCK_KOREKSI" name="x<?= $Grid->RowIndex ?>_STOCK_KOREKSI" id="x<?= $Grid->RowIndex ?>_STOCK_KOREKSI" size="30" placeholder="<?= HtmlEncode($Grid->STOCK_KOREKSI->getPlaceHolder()) ?>" value="<?= $Grid->STOCK_KOREKSI->EditValue ?>"<?= $Grid->STOCK_KOREKSI->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->STOCK_KOREKSI->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_STOCK_KOREKSI">
<span<?= $Grid->STOCK_KOREKSI->viewAttributes() ?>>
<?= $Grid->STOCK_KOREKSI->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_STOCK_KOREKSI" data-hidden="1" name="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_STOCK_KOREKSI" id="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_STOCK_KOREKSI" value="<?= HtmlEncode($Grid->STOCK_KOREKSI->FormValue) ?>">
<input type="hidden" data-table="GOOD_GF" data-field="x_STOCK_KOREKSI" data-hidden="1" name="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_STOCK_KOREKSI" id="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_STOCK_KOREKSI" value="<?= HtmlEncode($Grid->STOCK_KOREKSI->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->DITERIMA->Visible) { // DITERIMA ?>
        <td data-name="DITERIMA" <?= $Grid->DITERIMA->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_DITERIMA" class="form-group">
<input type="<?= $Grid->DITERIMA->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_DITERIMA" name="x<?= $Grid->RowIndex ?>_DITERIMA" id="x<?= $Grid->RowIndex ?>_DITERIMA" size="30" placeholder="<?= HtmlEncode($Grid->DITERIMA->getPlaceHolder()) ?>" value="<?= $Grid->DITERIMA->EditValue ?>"<?= $Grid->DITERIMA->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->DITERIMA->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_DITERIMA" data-hidden="1" name="o<?= $Grid->RowIndex ?>_DITERIMA" id="o<?= $Grid->RowIndex ?>_DITERIMA" value="<?= HtmlEncode($Grid->DITERIMA->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_DITERIMA" class="form-group">
<input type="<?= $Grid->DITERIMA->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_DITERIMA" name="x<?= $Grid->RowIndex ?>_DITERIMA" id="x<?= $Grid->RowIndex ?>_DITERIMA" size="30" placeholder="<?= HtmlEncode($Grid->DITERIMA->getPlaceHolder()) ?>" value="<?= $Grid->DITERIMA->EditValue ?>"<?= $Grid->DITERIMA->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->DITERIMA->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_DITERIMA">
<span<?= $Grid->DITERIMA->viewAttributes() ?>>
<?= $Grid->DITERIMA->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_DITERIMA" data-hidden="1" name="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_DITERIMA" id="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_DITERIMA" value="<?= HtmlEncode($Grid->DITERIMA->FormValue) ?>">
<input type="hidden" data-table="GOOD_GF" data-field="x_DITERIMA" data-hidden="1" name="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_DITERIMA" id="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_DITERIMA" value="<?= HtmlEncode($Grid->DITERIMA->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->DISTRIBUSI->Visible) { // DISTRIBUSI ?>
        <td data-name="DISTRIBUSI" <?= $Grid->DISTRIBUSI->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_DISTRIBUSI" class="form-group">
<input type="<?= $Grid->DISTRIBUSI->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_DISTRIBUSI" name="x<?= $Grid->RowIndex ?>_DISTRIBUSI" id="x<?= $Grid->RowIndex ?>_DISTRIBUSI" size="30" placeholder="<?= HtmlEncode($Grid->DISTRIBUSI->getPlaceHolder()) ?>" value="<?= $Grid->DISTRIBUSI->EditValue ?>"<?= $Grid->DISTRIBUSI->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->DISTRIBUSI->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_DISTRIBUSI" data-hidden="1" name="o<?= $Grid->RowIndex ?>_DISTRIBUSI" id="o<?= $Grid->RowIndex ?>_DISTRIBUSI" value="<?= HtmlEncode($Grid->DISTRIBUSI->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_DISTRIBUSI" class="form-group">
<input type="<?= $Grid->DISTRIBUSI->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_DISTRIBUSI" name="x<?= $Grid->RowIndex ?>_DISTRIBUSI" id="x<?= $Grid->RowIndex ?>_DISTRIBUSI" size="30" placeholder="<?= HtmlEncode($Grid->DISTRIBUSI->getPlaceHolder()) ?>" value="<?= $Grid->DISTRIBUSI->EditValue ?>"<?= $Grid->DISTRIBUSI->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->DISTRIBUSI->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_DISTRIBUSI">
<span<?= $Grid->DISTRIBUSI->viewAttributes() ?>>
<?= $Grid->DISTRIBUSI->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_DISTRIBUSI" data-hidden="1" name="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_DISTRIBUSI" id="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_DISTRIBUSI" value="<?= HtmlEncode($Grid->DISTRIBUSI->FormValue) ?>">
<input type="hidden" data-table="GOOD_GF" data-field="x_DISTRIBUSI" data-hidden="1" name="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_DISTRIBUSI" id="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_DISTRIBUSI" value="<?= HtmlEncode($Grid->DISTRIBUSI->OldValue) ?>">
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
    <?php if ($Grid->DIHAPUS->Visible) { // DIHAPUS ?>
        <td data-name="DIHAPUS" <?= $Grid->DIHAPUS->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_DIHAPUS" class="form-group">
<input type="<?= $Grid->DIHAPUS->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_DIHAPUS" name="x<?= $Grid->RowIndex ?>_DIHAPUS" id="x<?= $Grid->RowIndex ?>_DIHAPUS" size="30" placeholder="<?= HtmlEncode($Grid->DIHAPUS->getPlaceHolder()) ?>" value="<?= $Grid->DIHAPUS->EditValue ?>"<?= $Grid->DIHAPUS->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->DIHAPUS->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_DIHAPUS" data-hidden="1" name="o<?= $Grid->RowIndex ?>_DIHAPUS" id="o<?= $Grid->RowIndex ?>_DIHAPUS" value="<?= HtmlEncode($Grid->DIHAPUS->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_DIHAPUS" class="form-group">
<input type="<?= $Grid->DIHAPUS->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_DIHAPUS" name="x<?= $Grid->RowIndex ?>_DIHAPUS" id="x<?= $Grid->RowIndex ?>_DIHAPUS" size="30" placeholder="<?= HtmlEncode($Grid->DIHAPUS->getPlaceHolder()) ?>" value="<?= $Grid->DIHAPUS->EditValue ?>"<?= $Grid->DIHAPUS->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->DIHAPUS->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_DIHAPUS">
<span<?= $Grid->DIHAPUS->viewAttributes() ?>>
<?= $Grid->DIHAPUS->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_DIHAPUS" data-hidden="1" name="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_DIHAPUS" id="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_DIHAPUS" value="<?= HtmlEncode($Grid->DIHAPUS->FormValue) ?>">
<input type="hidden" data-table="GOOD_GF" data-field="x_DIHAPUS" data-hidden="1" name="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_DIHAPUS" id="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_DIHAPUS" value="<?= HtmlEncode($Grid->DIHAPUS->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->DIMINTA->Visible) { // DIMINTA ?>
        <td data-name="DIMINTA" <?= $Grid->DIMINTA->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_DIMINTA" class="form-group">
<input type="<?= $Grid->DIMINTA->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_DIMINTA" name="x<?= $Grid->RowIndex ?>_DIMINTA" id="x<?= $Grid->RowIndex ?>_DIMINTA" size="30" placeholder="<?= HtmlEncode($Grid->DIMINTA->getPlaceHolder()) ?>" value="<?= $Grid->DIMINTA->EditValue ?>"<?= $Grid->DIMINTA->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->DIMINTA->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_DIMINTA" data-hidden="1" name="o<?= $Grid->RowIndex ?>_DIMINTA" id="o<?= $Grid->RowIndex ?>_DIMINTA" value="<?= HtmlEncode($Grid->DIMINTA->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_DIMINTA" class="form-group">
<input type="<?= $Grid->DIMINTA->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_DIMINTA" name="x<?= $Grid->RowIndex ?>_DIMINTA" id="x<?= $Grid->RowIndex ?>_DIMINTA" size="30" placeholder="<?= HtmlEncode($Grid->DIMINTA->getPlaceHolder()) ?>" value="<?= $Grid->DIMINTA->EditValue ?>"<?= $Grid->DIMINTA->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->DIMINTA->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_DIMINTA">
<span<?= $Grid->DIMINTA->viewAttributes() ?>>
<?= $Grid->DIMINTA->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_DIMINTA" data-hidden="1" name="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_DIMINTA" id="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_DIMINTA" value="<?= HtmlEncode($Grid->DIMINTA->FormValue) ?>">
<input type="hidden" data-table="GOOD_GF" data-field="x_DIMINTA" data-hidden="1" name="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_DIMINTA" id="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_DIMINTA" value="<?= HtmlEncode($Grid->DIMINTA->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->DIRETUR->Visible) { // DIRETUR ?>
        <td data-name="DIRETUR" <?= $Grid->DIRETUR->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_DIRETUR" class="form-group">
<input type="<?= $Grid->DIRETUR->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_DIRETUR" name="x<?= $Grid->RowIndex ?>_DIRETUR" id="x<?= $Grid->RowIndex ?>_DIRETUR" size="30" placeholder="<?= HtmlEncode($Grid->DIRETUR->getPlaceHolder()) ?>" value="<?= $Grid->DIRETUR->EditValue ?>"<?= $Grid->DIRETUR->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->DIRETUR->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_DIRETUR" data-hidden="1" name="o<?= $Grid->RowIndex ?>_DIRETUR" id="o<?= $Grid->RowIndex ?>_DIRETUR" value="<?= HtmlEncode($Grid->DIRETUR->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_DIRETUR" class="form-group">
<input type="<?= $Grid->DIRETUR->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_DIRETUR" name="x<?= $Grid->RowIndex ?>_DIRETUR" id="x<?= $Grid->RowIndex ?>_DIRETUR" size="30" placeholder="<?= HtmlEncode($Grid->DIRETUR->getPlaceHolder()) ?>" value="<?= $Grid->DIRETUR->EditValue ?>"<?= $Grid->DIRETUR->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->DIRETUR->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_DIRETUR">
<span<?= $Grid->DIRETUR->viewAttributes() ?>>
<?= $Grid->DIRETUR->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_DIRETUR" data-hidden="1" name="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_DIRETUR" id="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_DIRETUR" value="<?= HtmlEncode($Grid->DIRETUR->FormValue) ?>">
<input type="hidden" data-table="GOOD_GF" data-field="x_DIRETUR" data-hidden="1" name="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_DIRETUR" id="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_DIRETUR" value="<?= HtmlEncode($Grid->DIRETUR->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->PO->Visible) { // PO ?>
        <td data-name="PO" <?= $Grid->PO->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_PO" class="form-group">
<input type="<?= $Grid->PO->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_PO" name="x<?= $Grid->RowIndex ?>_PO" id="x<?= $Grid->RowIndex ?>_PO" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->PO->getPlaceHolder()) ?>" value="<?= $Grid->PO->EditValue ?>"<?= $Grid->PO->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->PO->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_PO" data-hidden="1" name="o<?= $Grid->RowIndex ?>_PO" id="o<?= $Grid->RowIndex ?>_PO" value="<?= HtmlEncode($Grid->PO->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_PO" class="form-group">
<input type="<?= $Grid->PO->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_PO" name="x<?= $Grid->RowIndex ?>_PO" id="x<?= $Grid->RowIndex ?>_PO" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->PO->getPlaceHolder()) ?>" value="<?= $Grid->PO->EditValue ?>"<?= $Grid->PO->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->PO->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_PO">
<span<?= $Grid->PO->viewAttributes() ?>>
<?= $Grid->PO->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_PO" data-hidden="1" name="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_PO" id="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_PO" value="<?= HtmlEncode($Grid->PO->FormValue) ?>">
<input type="hidden" data-table="GOOD_GF" data-field="x_PO" data-hidden="1" name="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_PO" id="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_PO" value="<?= HtmlEncode($Grid->PO->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->COMPANY_ID->Visible) { // COMPANY_ID ?>
        <td data-name="COMPANY_ID" <?= $Grid->COMPANY_ID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_COMPANY_ID" class="form-group">
<input type="<?= $Grid->COMPANY_ID->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_COMPANY_ID" name="x<?= $Grid->RowIndex ?>_COMPANY_ID" id="x<?= $Grid->RowIndex ?>_COMPANY_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->COMPANY_ID->getPlaceHolder()) ?>" value="<?= $Grid->COMPANY_ID->EditValue ?>"<?= $Grid->COMPANY_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->COMPANY_ID->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_COMPANY_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_COMPANY_ID" id="o<?= $Grid->RowIndex ?>_COMPANY_ID" value="<?= HtmlEncode($Grid->COMPANY_ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_COMPANY_ID" class="form-group">
<input type="<?= $Grid->COMPANY_ID->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_COMPANY_ID" name="x<?= $Grid->RowIndex ?>_COMPANY_ID" id="x<?= $Grid->RowIndex ?>_COMPANY_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->COMPANY_ID->getPlaceHolder()) ?>" value="<?= $Grid->COMPANY_ID->EditValue ?>"<?= $Grid->COMPANY_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->COMPANY_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_COMPANY_ID">
<span<?= $Grid->COMPANY_ID->viewAttributes() ?>>
<?= $Grid->COMPANY_ID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_COMPANY_ID" data-hidden="1" name="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_COMPANY_ID" id="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_COMPANY_ID" value="<?= HtmlEncode($Grid->COMPANY_ID->FormValue) ?>">
<input type="hidden" data-table="GOOD_GF" data-field="x_COMPANY_ID" data-hidden="1" name="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_COMPANY_ID" id="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_COMPANY_ID" value="<?= HtmlEncode($Grid->COMPANY_ID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->FUND_ID->Visible) { // FUND_ID ?>
        <td data-name="FUND_ID" <?= $Grid->FUND_ID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_FUND_ID" class="form-group">
<input type="<?= $Grid->FUND_ID->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_FUND_ID" name="x<?= $Grid->RowIndex ?>_FUND_ID" id="x<?= $Grid->RowIndex ?>_FUND_ID" size="30" placeholder="<?= HtmlEncode($Grid->FUND_ID->getPlaceHolder()) ?>" value="<?= $Grid->FUND_ID->EditValue ?>"<?= $Grid->FUND_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->FUND_ID->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_FUND_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_FUND_ID" id="o<?= $Grid->RowIndex ?>_FUND_ID" value="<?= HtmlEncode($Grid->FUND_ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_FUND_ID" class="form-group">
<input type="<?= $Grid->FUND_ID->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_FUND_ID" name="x<?= $Grid->RowIndex ?>_FUND_ID" id="x<?= $Grid->RowIndex ?>_FUND_ID" size="30" placeholder="<?= HtmlEncode($Grid->FUND_ID->getPlaceHolder()) ?>" value="<?= $Grid->FUND_ID->EditValue ?>"<?= $Grid->FUND_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->FUND_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_FUND_ID">
<span<?= $Grid->FUND_ID->viewAttributes() ?>>
<?= $Grid->FUND_ID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_FUND_ID" data-hidden="1" name="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_FUND_ID" id="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_FUND_ID" value="<?= HtmlEncode($Grid->FUND_ID->FormValue) ?>">
<input type="hidden" data-table="GOOD_GF" data-field="x_FUND_ID" data-hidden="1" name="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_FUND_ID" id="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_FUND_ID" value="<?= HtmlEncode($Grid->FUND_ID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->INVOICE_ID2->Visible) { // INVOICE_ID2 ?>
        <td data-name="INVOICE_ID2" <?= $Grid->INVOICE_ID2->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_INVOICE_ID2" class="form-group">
<input type="<?= $Grid->INVOICE_ID2->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_INVOICE_ID2" name="x<?= $Grid->RowIndex ?>_INVOICE_ID2" id="x<?= $Grid->RowIndex ?>_INVOICE_ID2" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->INVOICE_ID2->getPlaceHolder()) ?>" value="<?= $Grid->INVOICE_ID2->EditValue ?>"<?= $Grid->INVOICE_ID2->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->INVOICE_ID2->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_INVOICE_ID2" data-hidden="1" name="o<?= $Grid->RowIndex ?>_INVOICE_ID2" id="o<?= $Grid->RowIndex ?>_INVOICE_ID2" value="<?= HtmlEncode($Grid->INVOICE_ID2->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_INVOICE_ID2" class="form-group">
<input type="<?= $Grid->INVOICE_ID2->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_INVOICE_ID2" name="x<?= $Grid->RowIndex ?>_INVOICE_ID2" id="x<?= $Grid->RowIndex ?>_INVOICE_ID2" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->INVOICE_ID2->getPlaceHolder()) ?>" value="<?= $Grid->INVOICE_ID2->EditValue ?>"<?= $Grid->INVOICE_ID2->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->INVOICE_ID2->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_INVOICE_ID2">
<span<?= $Grid->INVOICE_ID2->viewAttributes() ?>>
<?= $Grid->INVOICE_ID2->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_INVOICE_ID2" data-hidden="1" name="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_INVOICE_ID2" id="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_INVOICE_ID2" value="<?= HtmlEncode($Grid->INVOICE_ID2->FormValue) ?>">
<input type="hidden" data-table="GOOD_GF" data-field="x_INVOICE_ID2" data-hidden="1" name="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_INVOICE_ID2" id="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_INVOICE_ID2" value="<?= HtmlEncode($Grid->INVOICE_ID2->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->MEASURE_ID3->Visible) { // MEASURE_ID3 ?>
        <td data-name="MEASURE_ID3" <?= $Grid->MEASURE_ID3->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_MEASURE_ID3" class="form-group">
<input type="<?= $Grid->MEASURE_ID3->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_MEASURE_ID3" name="x<?= $Grid->RowIndex ?>_MEASURE_ID3" id="x<?= $Grid->RowIndex ?>_MEASURE_ID3" size="30" placeholder="<?= HtmlEncode($Grid->MEASURE_ID3->getPlaceHolder()) ?>" value="<?= $Grid->MEASURE_ID3->EditValue ?>"<?= $Grid->MEASURE_ID3->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->MEASURE_ID3->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_MEASURE_ID3" data-hidden="1" name="o<?= $Grid->RowIndex ?>_MEASURE_ID3" id="o<?= $Grid->RowIndex ?>_MEASURE_ID3" value="<?= HtmlEncode($Grid->MEASURE_ID3->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_MEASURE_ID3" class="form-group">
<input type="<?= $Grid->MEASURE_ID3->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_MEASURE_ID3" name="x<?= $Grid->RowIndex ?>_MEASURE_ID3" id="x<?= $Grid->RowIndex ?>_MEASURE_ID3" size="30" placeholder="<?= HtmlEncode($Grid->MEASURE_ID3->getPlaceHolder()) ?>" value="<?= $Grid->MEASURE_ID3->EditValue ?>"<?= $Grid->MEASURE_ID3->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->MEASURE_ID3->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_MEASURE_ID3">
<span<?= $Grid->MEASURE_ID3->viewAttributes() ?>>
<?= $Grid->MEASURE_ID3->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_MEASURE_ID3" data-hidden="1" name="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_MEASURE_ID3" id="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_MEASURE_ID3" value="<?= HtmlEncode($Grid->MEASURE_ID3->FormValue) ?>">
<input type="hidden" data-table="GOOD_GF" data-field="x_MEASURE_ID3" data-hidden="1" name="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_MEASURE_ID3" id="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_MEASURE_ID3" value="<?= HtmlEncode($Grid->MEASURE_ID3->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->SIZE_KEMASAN->Visible) { // SIZE_KEMASAN ?>
        <td data-name="SIZE_KEMASAN" <?= $Grid->SIZE_KEMASAN->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_SIZE_KEMASAN" class="form-group">
<input type="<?= $Grid->SIZE_KEMASAN->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_SIZE_KEMASAN" name="x<?= $Grid->RowIndex ?>_SIZE_KEMASAN" id="x<?= $Grid->RowIndex ?>_SIZE_KEMASAN" size="30" placeholder="<?= HtmlEncode($Grid->SIZE_KEMASAN->getPlaceHolder()) ?>" value="<?= $Grid->SIZE_KEMASAN->EditValue ?>"<?= $Grid->SIZE_KEMASAN->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->SIZE_KEMASAN->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_SIZE_KEMASAN" data-hidden="1" name="o<?= $Grid->RowIndex ?>_SIZE_KEMASAN" id="o<?= $Grid->RowIndex ?>_SIZE_KEMASAN" value="<?= HtmlEncode($Grid->SIZE_KEMASAN->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_SIZE_KEMASAN" class="form-group">
<input type="<?= $Grid->SIZE_KEMASAN->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_SIZE_KEMASAN" name="x<?= $Grid->RowIndex ?>_SIZE_KEMASAN" id="x<?= $Grid->RowIndex ?>_SIZE_KEMASAN" size="30" placeholder="<?= HtmlEncode($Grid->SIZE_KEMASAN->getPlaceHolder()) ?>" value="<?= $Grid->SIZE_KEMASAN->EditValue ?>"<?= $Grid->SIZE_KEMASAN->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->SIZE_KEMASAN->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_SIZE_KEMASAN">
<span<?= $Grid->SIZE_KEMASAN->viewAttributes() ?>>
<?= $Grid->SIZE_KEMASAN->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_SIZE_KEMASAN" data-hidden="1" name="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_SIZE_KEMASAN" id="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_SIZE_KEMASAN" value="<?= HtmlEncode($Grid->SIZE_KEMASAN->FormValue) ?>">
<input type="hidden" data-table="GOOD_GF" data-field="x_SIZE_KEMASAN" data-hidden="1" name="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_SIZE_KEMASAN" id="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_SIZE_KEMASAN" value="<?= HtmlEncode($Grid->SIZE_KEMASAN->OldValue) ?>">
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
    <?php if ($Grid->MEASURE_ID2->Visible) { // MEASURE_ID2 ?>
        <td data-name="MEASURE_ID2" <?= $Grid->MEASURE_ID2->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_MEASURE_ID2" class="form-group">
<input type="<?= $Grid->MEASURE_ID2->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_MEASURE_ID2" name="x<?= $Grid->RowIndex ?>_MEASURE_ID2" id="x<?= $Grid->RowIndex ?>_MEASURE_ID2" size="30" placeholder="<?= HtmlEncode($Grid->MEASURE_ID2->getPlaceHolder()) ?>" value="<?= $Grid->MEASURE_ID2->EditValue ?>"<?= $Grid->MEASURE_ID2->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->MEASURE_ID2->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_MEASURE_ID2" data-hidden="1" name="o<?= $Grid->RowIndex ?>_MEASURE_ID2" id="o<?= $Grid->RowIndex ?>_MEASURE_ID2" value="<?= HtmlEncode($Grid->MEASURE_ID2->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_MEASURE_ID2" class="form-group">
<input type="<?= $Grid->MEASURE_ID2->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_MEASURE_ID2" name="x<?= $Grid->RowIndex ?>_MEASURE_ID2" id="x<?= $Grid->RowIndex ?>_MEASURE_ID2" size="30" placeholder="<?= HtmlEncode($Grid->MEASURE_ID2->getPlaceHolder()) ?>" value="<?= $Grid->MEASURE_ID2->EditValue ?>"<?= $Grid->MEASURE_ID2->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->MEASURE_ID2->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_MEASURE_ID2">
<span<?= $Grid->MEASURE_ID2->viewAttributes() ?>>
<?= $Grid->MEASURE_ID2->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_MEASURE_ID2" data-hidden="1" name="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_MEASURE_ID2" id="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_MEASURE_ID2" value="<?= HtmlEncode($Grid->MEASURE_ID2->FormValue) ?>">
<input type="hidden" data-table="GOOD_GF" data-field="x_MEASURE_ID2" data-hidden="1" name="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_MEASURE_ID2" id="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_MEASURE_ID2" value="<?= HtmlEncode($Grid->MEASURE_ID2->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->RETUR_ID->Visible) { // RETUR_ID ?>
        <td data-name="RETUR_ID" <?= $Grid->RETUR_ID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_RETUR_ID" class="form-group">
<input type="<?= $Grid->RETUR_ID->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_RETUR_ID" name="x<?= $Grid->RowIndex ?>_RETUR_ID" id="x<?= $Grid->RowIndex ?>_RETUR_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->RETUR_ID->getPlaceHolder()) ?>" value="<?= $Grid->RETUR_ID->EditValue ?>"<?= $Grid->RETUR_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->RETUR_ID->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_RETUR_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_RETUR_ID" id="o<?= $Grid->RowIndex ?>_RETUR_ID" value="<?= HtmlEncode($Grid->RETUR_ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_RETUR_ID" class="form-group">
<input type="<?= $Grid->RETUR_ID->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_RETUR_ID" name="x<?= $Grid->RowIndex ?>_RETUR_ID" id="x<?= $Grid->RowIndex ?>_RETUR_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->RETUR_ID->getPlaceHolder()) ?>" value="<?= $Grid->RETUR_ID->EditValue ?>"<?= $Grid->RETUR_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->RETUR_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_RETUR_ID">
<span<?= $Grid->RETUR_ID->viewAttributes() ?>>
<?= $Grid->RETUR_ID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_RETUR_ID" data-hidden="1" name="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_RETUR_ID" id="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_RETUR_ID" value="<?= HtmlEncode($Grid->RETUR_ID->FormValue) ?>">
<input type="hidden" data-table="GOOD_GF" data-field="x_RETUR_ID" data-hidden="1" name="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_RETUR_ID" id="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_RETUR_ID" value="<?= HtmlEncode($Grid->RETUR_ID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->SIZE_GOODS->Visible) { // SIZE_GOODS ?>
        <td data-name="SIZE_GOODS" <?= $Grid->SIZE_GOODS->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_SIZE_GOODS" class="form-group">
<input type="<?= $Grid->SIZE_GOODS->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_SIZE_GOODS" name="x<?= $Grid->RowIndex ?>_SIZE_GOODS" id="x<?= $Grid->RowIndex ?>_SIZE_GOODS" size="30" placeholder="<?= HtmlEncode($Grid->SIZE_GOODS->getPlaceHolder()) ?>" value="<?= $Grid->SIZE_GOODS->EditValue ?>"<?= $Grid->SIZE_GOODS->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->SIZE_GOODS->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_SIZE_GOODS" data-hidden="1" name="o<?= $Grid->RowIndex ?>_SIZE_GOODS" id="o<?= $Grid->RowIndex ?>_SIZE_GOODS" value="<?= HtmlEncode($Grid->SIZE_GOODS->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_SIZE_GOODS" class="form-group">
<input type="<?= $Grid->SIZE_GOODS->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_SIZE_GOODS" name="x<?= $Grid->RowIndex ?>_SIZE_GOODS" id="x<?= $Grid->RowIndex ?>_SIZE_GOODS" size="30" placeholder="<?= HtmlEncode($Grid->SIZE_GOODS->getPlaceHolder()) ?>" value="<?= $Grid->SIZE_GOODS->EditValue ?>"<?= $Grid->SIZE_GOODS->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->SIZE_GOODS->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_SIZE_GOODS">
<span<?= $Grid->SIZE_GOODS->viewAttributes() ?>>
<?= $Grid->SIZE_GOODS->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_SIZE_GOODS" data-hidden="1" name="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_SIZE_GOODS" id="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_SIZE_GOODS" value="<?= HtmlEncode($Grid->SIZE_GOODS->FormValue) ?>">
<input type="hidden" data-table="GOOD_GF" data-field="x_SIZE_GOODS" data-hidden="1" name="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_SIZE_GOODS" id="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_SIZE_GOODS" value="<?= HtmlEncode($Grid->SIZE_GOODS->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->MEASURE_DOSIS->Visible) { // MEASURE_DOSIS ?>
        <td data-name="MEASURE_DOSIS" <?= $Grid->MEASURE_DOSIS->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_MEASURE_DOSIS" class="form-group">
<input type="<?= $Grid->MEASURE_DOSIS->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_MEASURE_DOSIS" name="x<?= $Grid->RowIndex ?>_MEASURE_DOSIS" id="x<?= $Grid->RowIndex ?>_MEASURE_DOSIS" size="30" placeholder="<?= HtmlEncode($Grid->MEASURE_DOSIS->getPlaceHolder()) ?>" value="<?= $Grid->MEASURE_DOSIS->EditValue ?>"<?= $Grid->MEASURE_DOSIS->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->MEASURE_DOSIS->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_MEASURE_DOSIS" data-hidden="1" name="o<?= $Grid->RowIndex ?>_MEASURE_DOSIS" id="o<?= $Grid->RowIndex ?>_MEASURE_DOSIS" value="<?= HtmlEncode($Grid->MEASURE_DOSIS->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_MEASURE_DOSIS" class="form-group">
<input type="<?= $Grid->MEASURE_DOSIS->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_MEASURE_DOSIS" name="x<?= $Grid->RowIndex ?>_MEASURE_DOSIS" id="x<?= $Grid->RowIndex ?>_MEASURE_DOSIS" size="30" placeholder="<?= HtmlEncode($Grid->MEASURE_DOSIS->getPlaceHolder()) ?>" value="<?= $Grid->MEASURE_DOSIS->EditValue ?>"<?= $Grid->MEASURE_DOSIS->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->MEASURE_DOSIS->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_MEASURE_DOSIS">
<span<?= $Grid->MEASURE_DOSIS->viewAttributes() ?>>
<?= $Grid->MEASURE_DOSIS->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_MEASURE_DOSIS" data-hidden="1" name="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_MEASURE_DOSIS" id="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_MEASURE_DOSIS" value="<?= HtmlEncode($Grid->MEASURE_DOSIS->FormValue) ?>">
<input type="hidden" data-table="GOOD_GF" data-field="x_MEASURE_DOSIS" data-hidden="1" name="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_MEASURE_DOSIS" id="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_MEASURE_DOSIS" value="<?= HtmlEncode($Grid->MEASURE_DOSIS->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->ORDER_PRICE->Visible) { // ORDER_PRICE ?>
        <td data-name="ORDER_PRICE" <?= $Grid->ORDER_PRICE->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_ORDER_PRICE" class="form-group">
<input type="<?= $Grid->ORDER_PRICE->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_ORDER_PRICE" name="x<?= $Grid->RowIndex ?>_ORDER_PRICE" id="x<?= $Grid->RowIndex ?>_ORDER_PRICE" size="30" placeholder="<?= HtmlEncode($Grid->ORDER_PRICE->getPlaceHolder()) ?>" value="<?= $Grid->ORDER_PRICE->EditValue ?>"<?= $Grid->ORDER_PRICE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ORDER_PRICE->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_ORDER_PRICE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ORDER_PRICE" id="o<?= $Grid->RowIndex ?>_ORDER_PRICE" value="<?= HtmlEncode($Grid->ORDER_PRICE->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_ORDER_PRICE" class="form-group">
<input type="<?= $Grid->ORDER_PRICE->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_ORDER_PRICE" name="x<?= $Grid->RowIndex ?>_ORDER_PRICE" id="x<?= $Grid->RowIndex ?>_ORDER_PRICE" size="30" placeholder="<?= HtmlEncode($Grid->ORDER_PRICE->getPlaceHolder()) ?>" value="<?= $Grid->ORDER_PRICE->EditValue ?>"<?= $Grid->ORDER_PRICE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ORDER_PRICE->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_ORDER_PRICE">
<span<?= $Grid->ORDER_PRICE->viewAttributes() ?>>
<?= $Grid->ORDER_PRICE->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_ORDER_PRICE" data-hidden="1" name="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_ORDER_PRICE" id="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_ORDER_PRICE" value="<?= HtmlEncode($Grid->ORDER_PRICE->FormValue) ?>">
<input type="hidden" data-table="GOOD_GF" data-field="x_ORDER_PRICE" data-hidden="1" name="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_ORDER_PRICE" id="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_ORDER_PRICE" value="<?= HtmlEncode($Grid->ORDER_PRICE->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->STOCK_AVAILABLE->Visible) { // STOCK_AVAILABLE ?>
        <td data-name="STOCK_AVAILABLE" <?= $Grid->STOCK_AVAILABLE->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_STOCK_AVAILABLE" class="form-group">
<input type="<?= $Grid->STOCK_AVAILABLE->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_STOCK_AVAILABLE" name="x<?= $Grid->RowIndex ?>_STOCK_AVAILABLE" id="x<?= $Grid->RowIndex ?>_STOCK_AVAILABLE" size="30" placeholder="<?= HtmlEncode($Grid->STOCK_AVAILABLE->getPlaceHolder()) ?>" value="<?= $Grid->STOCK_AVAILABLE->EditValue ?>"<?= $Grid->STOCK_AVAILABLE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->STOCK_AVAILABLE->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_STOCK_AVAILABLE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_STOCK_AVAILABLE" id="o<?= $Grid->RowIndex ?>_STOCK_AVAILABLE" value="<?= HtmlEncode($Grid->STOCK_AVAILABLE->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_STOCK_AVAILABLE" class="form-group">
<input type="<?= $Grid->STOCK_AVAILABLE->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_STOCK_AVAILABLE" name="x<?= $Grid->RowIndex ?>_STOCK_AVAILABLE" id="x<?= $Grid->RowIndex ?>_STOCK_AVAILABLE" size="30" placeholder="<?= HtmlEncode($Grid->STOCK_AVAILABLE->getPlaceHolder()) ?>" value="<?= $Grid->STOCK_AVAILABLE->EditValue ?>"<?= $Grid->STOCK_AVAILABLE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->STOCK_AVAILABLE->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_STOCK_AVAILABLE">
<span<?= $Grid->STOCK_AVAILABLE->viewAttributes() ?>>
<?= $Grid->STOCK_AVAILABLE->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_STOCK_AVAILABLE" data-hidden="1" name="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_STOCK_AVAILABLE" id="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_STOCK_AVAILABLE" value="<?= HtmlEncode($Grid->STOCK_AVAILABLE->FormValue) ?>">
<input type="hidden" data-table="GOOD_GF" data-field="x_STOCK_AVAILABLE" data-hidden="1" name="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_STOCK_AVAILABLE" id="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_STOCK_AVAILABLE" value="<?= HtmlEncode($Grid->STOCK_AVAILABLE->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->STATUS_PASIEN_ID->Visible) { // STATUS_PASIEN_ID ?>
        <td data-name="STATUS_PASIEN_ID" <?= $Grid->STATUS_PASIEN_ID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_STATUS_PASIEN_ID" class="form-group">
<input type="<?= $Grid->STATUS_PASIEN_ID->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_STATUS_PASIEN_ID" name="x<?= $Grid->RowIndex ?>_STATUS_PASIEN_ID" id="x<?= $Grid->RowIndex ?>_STATUS_PASIEN_ID" size="30" placeholder="<?= HtmlEncode($Grid->STATUS_PASIEN_ID->getPlaceHolder()) ?>" value="<?= $Grid->STATUS_PASIEN_ID->EditValue ?>"<?= $Grid->STATUS_PASIEN_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->STATUS_PASIEN_ID->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_STATUS_PASIEN_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_STATUS_PASIEN_ID" id="o<?= $Grid->RowIndex ?>_STATUS_PASIEN_ID" value="<?= HtmlEncode($Grid->STATUS_PASIEN_ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_STATUS_PASIEN_ID" class="form-group">
<input type="<?= $Grid->STATUS_PASIEN_ID->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_STATUS_PASIEN_ID" name="x<?= $Grid->RowIndex ?>_STATUS_PASIEN_ID" id="x<?= $Grid->RowIndex ?>_STATUS_PASIEN_ID" size="30" placeholder="<?= HtmlEncode($Grid->STATUS_PASIEN_ID->getPlaceHolder()) ?>" value="<?= $Grid->STATUS_PASIEN_ID->EditValue ?>"<?= $Grid->STATUS_PASIEN_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->STATUS_PASIEN_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_STATUS_PASIEN_ID">
<span<?= $Grid->STATUS_PASIEN_ID->viewAttributes() ?>>
<?= $Grid->STATUS_PASIEN_ID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_STATUS_PASIEN_ID" data-hidden="1" name="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_STATUS_PASIEN_ID" id="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_STATUS_PASIEN_ID" value="<?= HtmlEncode($Grid->STATUS_PASIEN_ID->FormValue) ?>">
<input type="hidden" data-table="GOOD_GF" data-field="x_STATUS_PASIEN_ID" data-hidden="1" name="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_STATUS_PASIEN_ID" id="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_STATUS_PASIEN_ID" value="<?= HtmlEncode($Grid->STATUS_PASIEN_ID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->MONTH_ID->Visible) { // MONTH_ID ?>
        <td data-name="MONTH_ID" <?= $Grid->MONTH_ID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_MONTH_ID" class="form-group">
<input type="<?= $Grid->MONTH_ID->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_MONTH_ID" name="x<?= $Grid->RowIndex ?>_MONTH_ID" id="x<?= $Grid->RowIndex ?>_MONTH_ID" size="30" placeholder="<?= HtmlEncode($Grid->MONTH_ID->getPlaceHolder()) ?>" value="<?= $Grid->MONTH_ID->EditValue ?>"<?= $Grid->MONTH_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->MONTH_ID->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_MONTH_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_MONTH_ID" id="o<?= $Grid->RowIndex ?>_MONTH_ID" value="<?= HtmlEncode($Grid->MONTH_ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_MONTH_ID" class="form-group">
<input type="<?= $Grid->MONTH_ID->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_MONTH_ID" name="x<?= $Grid->RowIndex ?>_MONTH_ID" id="x<?= $Grid->RowIndex ?>_MONTH_ID" size="30" placeholder="<?= HtmlEncode($Grid->MONTH_ID->getPlaceHolder()) ?>" value="<?= $Grid->MONTH_ID->EditValue ?>"<?= $Grid->MONTH_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->MONTH_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_MONTH_ID">
<span<?= $Grid->MONTH_ID->viewAttributes() ?>>
<?= $Grid->MONTH_ID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_MONTH_ID" data-hidden="1" name="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_MONTH_ID" id="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_MONTH_ID" value="<?= HtmlEncode($Grid->MONTH_ID->FormValue) ?>">
<input type="hidden" data-table="GOOD_GF" data-field="x_MONTH_ID" data-hidden="1" name="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_MONTH_ID" id="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_MONTH_ID" value="<?= HtmlEncode($Grid->MONTH_ID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->YEAR_ID->Visible) { // YEAR_ID ?>
        <td data-name="YEAR_ID" <?= $Grid->YEAR_ID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_YEAR_ID" class="form-group">
<input type="<?= $Grid->YEAR_ID->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_YEAR_ID" name="x<?= $Grid->RowIndex ?>_YEAR_ID" id="x<?= $Grid->RowIndex ?>_YEAR_ID" size="30" placeholder="<?= HtmlEncode($Grid->YEAR_ID->getPlaceHolder()) ?>" value="<?= $Grid->YEAR_ID->EditValue ?>"<?= $Grid->YEAR_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->YEAR_ID->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_YEAR_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_YEAR_ID" id="o<?= $Grid->RowIndex ?>_YEAR_ID" value="<?= HtmlEncode($Grid->YEAR_ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_YEAR_ID" class="form-group">
<input type="<?= $Grid->YEAR_ID->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_YEAR_ID" name="x<?= $Grid->RowIndex ?>_YEAR_ID" id="x<?= $Grid->RowIndex ?>_YEAR_ID" size="30" placeholder="<?= HtmlEncode($Grid->YEAR_ID->getPlaceHolder()) ?>" value="<?= $Grid->YEAR_ID->EditValue ?>"<?= $Grid->YEAR_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->YEAR_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_YEAR_ID">
<span<?= $Grid->YEAR_ID->viewAttributes() ?>>
<?= $Grid->YEAR_ID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_YEAR_ID" data-hidden="1" name="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_YEAR_ID" id="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_YEAR_ID" value="<?= HtmlEncode($Grid->YEAR_ID->FormValue) ?>">
<input type="hidden" data-table="GOOD_GF" data-field="x_YEAR_ID" data-hidden="1" name="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_YEAR_ID" id="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_YEAR_ID" value="<?= HtmlEncode($Grid->YEAR_ID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->CORRECTION_DOC->Visible) { // CORRECTION_DOC ?>
        <td data-name="CORRECTION_DOC" <?= $Grid->CORRECTION_DOC->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_CORRECTION_DOC" class="form-group">
<input type="<?= $Grid->CORRECTION_DOC->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_CORRECTION_DOC" name="x<?= $Grid->RowIndex ?>_CORRECTION_DOC" id="x<?= $Grid->RowIndex ?>_CORRECTION_DOC" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->CORRECTION_DOC->getPlaceHolder()) ?>" value="<?= $Grid->CORRECTION_DOC->EditValue ?>"<?= $Grid->CORRECTION_DOC->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->CORRECTION_DOC->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_CORRECTION_DOC" data-hidden="1" name="o<?= $Grid->RowIndex ?>_CORRECTION_DOC" id="o<?= $Grid->RowIndex ?>_CORRECTION_DOC" value="<?= HtmlEncode($Grid->CORRECTION_DOC->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_CORRECTION_DOC" class="form-group">
<input type="<?= $Grid->CORRECTION_DOC->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_CORRECTION_DOC" name="x<?= $Grid->RowIndex ?>_CORRECTION_DOC" id="x<?= $Grid->RowIndex ?>_CORRECTION_DOC" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->CORRECTION_DOC->getPlaceHolder()) ?>" value="<?= $Grid->CORRECTION_DOC->EditValue ?>"<?= $Grid->CORRECTION_DOC->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->CORRECTION_DOC->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_CORRECTION_DOC">
<span<?= $Grid->CORRECTION_DOC->viewAttributes() ?>>
<?= $Grid->CORRECTION_DOC->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_CORRECTION_DOC" data-hidden="1" name="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_CORRECTION_DOC" id="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_CORRECTION_DOC" value="<?= HtmlEncode($Grid->CORRECTION_DOC->FormValue) ?>">
<input type="hidden" data-table="GOOD_GF" data-field="x_CORRECTION_DOC" data-hidden="1" name="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_CORRECTION_DOC" id="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_CORRECTION_DOC" value="<?= HtmlEncode($Grid->CORRECTION_DOC->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->CORRECTIONS->Visible) { // CORRECTIONS ?>
        <td data-name="CORRECTIONS" <?= $Grid->CORRECTIONS->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_CORRECTIONS" class="form-group">
<input type="<?= $Grid->CORRECTIONS->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_CORRECTIONS" name="x<?= $Grid->RowIndex ?>_CORRECTIONS" id="x<?= $Grid->RowIndex ?>_CORRECTIONS" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->CORRECTIONS->getPlaceHolder()) ?>" value="<?= $Grid->CORRECTIONS->EditValue ?>"<?= $Grid->CORRECTIONS->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->CORRECTIONS->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_CORRECTIONS" data-hidden="1" name="o<?= $Grid->RowIndex ?>_CORRECTIONS" id="o<?= $Grid->RowIndex ?>_CORRECTIONS" value="<?= HtmlEncode($Grid->CORRECTIONS->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_CORRECTIONS" class="form-group">
<input type="<?= $Grid->CORRECTIONS->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_CORRECTIONS" name="x<?= $Grid->RowIndex ?>_CORRECTIONS" id="x<?= $Grid->RowIndex ?>_CORRECTIONS" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->CORRECTIONS->getPlaceHolder()) ?>" value="<?= $Grid->CORRECTIONS->EditValue ?>"<?= $Grid->CORRECTIONS->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->CORRECTIONS->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_CORRECTIONS">
<span<?= $Grid->CORRECTIONS->viewAttributes() ?>>
<?= $Grid->CORRECTIONS->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_CORRECTIONS" data-hidden="1" name="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_CORRECTIONS" id="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_CORRECTIONS" value="<?= HtmlEncode($Grid->CORRECTIONS->FormValue) ?>">
<input type="hidden" data-table="GOOD_GF" data-field="x_CORRECTIONS" data-hidden="1" name="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_CORRECTIONS" id="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_CORRECTIONS" value="<?= HtmlEncode($Grid->CORRECTIONS->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->CORRECTION_DATE->Visible) { // CORRECTION_DATE ?>
        <td data-name="CORRECTION_DATE" <?= $Grid->CORRECTION_DATE->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_CORRECTION_DATE" class="form-group">
<input type="<?= $Grid->CORRECTION_DATE->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_CORRECTION_DATE" name="x<?= $Grid->RowIndex ?>_CORRECTION_DATE" id="x<?= $Grid->RowIndex ?>_CORRECTION_DATE" placeholder="<?= HtmlEncode($Grid->CORRECTION_DATE->getPlaceHolder()) ?>" value="<?= $Grid->CORRECTION_DATE->EditValue ?>"<?= $Grid->CORRECTION_DATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->CORRECTION_DATE->getErrorMessage() ?></div>
<?php if (!$Grid->CORRECTION_DATE->ReadOnly && !$Grid->CORRECTION_DATE->Disabled && !isset($Grid->CORRECTION_DATE->EditAttrs["readonly"]) && !isset($Grid->CORRECTION_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fGOOD_GFgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fGOOD_GFgrid", "x<?= $Grid->RowIndex ?>_CORRECTION_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_CORRECTION_DATE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_CORRECTION_DATE" id="o<?= $Grid->RowIndex ?>_CORRECTION_DATE" value="<?= HtmlEncode($Grid->CORRECTION_DATE->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_CORRECTION_DATE" class="form-group">
<input type="<?= $Grid->CORRECTION_DATE->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_CORRECTION_DATE" name="x<?= $Grid->RowIndex ?>_CORRECTION_DATE" id="x<?= $Grid->RowIndex ?>_CORRECTION_DATE" placeholder="<?= HtmlEncode($Grid->CORRECTION_DATE->getPlaceHolder()) ?>" value="<?= $Grid->CORRECTION_DATE->EditValue ?>"<?= $Grid->CORRECTION_DATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->CORRECTION_DATE->getErrorMessage() ?></div>
<?php if (!$Grid->CORRECTION_DATE->ReadOnly && !$Grid->CORRECTION_DATE->Disabled && !isset($Grid->CORRECTION_DATE->EditAttrs["readonly"]) && !isset($Grid->CORRECTION_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fGOOD_GFgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fGOOD_GFgrid", "x<?= $Grid->RowIndex ?>_CORRECTION_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_CORRECTION_DATE">
<span<?= $Grid->CORRECTION_DATE->viewAttributes() ?>>
<?= $Grid->CORRECTION_DATE->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_CORRECTION_DATE" data-hidden="1" name="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_CORRECTION_DATE" id="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_CORRECTION_DATE" value="<?= HtmlEncode($Grid->CORRECTION_DATE->FormValue) ?>">
<input type="hidden" data-table="GOOD_GF" data-field="x_CORRECTION_DATE" data-hidden="1" name="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_CORRECTION_DATE" id="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_CORRECTION_DATE" value="<?= HtmlEncode($Grid->CORRECTION_DATE->OldValue) ?>">
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
    <?php if ($Grid->ORDER_ID->Visible) { // ORDER_ID ?>
        <td data-name="ORDER_ID" <?= $Grid->ORDER_ID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_ORDER_ID" class="form-group">
<input type="<?= $Grid->ORDER_ID->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_ORDER_ID" name="x<?= $Grid->RowIndex ?>_ORDER_ID" id="x<?= $Grid->RowIndex ?>_ORDER_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->ORDER_ID->getPlaceHolder()) ?>" value="<?= $Grid->ORDER_ID->EditValue ?>"<?= $Grid->ORDER_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ORDER_ID->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_ORDER_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ORDER_ID" id="o<?= $Grid->RowIndex ?>_ORDER_ID" value="<?= HtmlEncode($Grid->ORDER_ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_ORDER_ID" class="form-group">
<input type="<?= $Grid->ORDER_ID->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_ORDER_ID" name="x<?= $Grid->RowIndex ?>_ORDER_ID" id="x<?= $Grid->RowIndex ?>_ORDER_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->ORDER_ID->getPlaceHolder()) ?>" value="<?= $Grid->ORDER_ID->EditValue ?>"<?= $Grid->ORDER_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ORDER_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_ORDER_ID">
<span<?= $Grid->ORDER_ID->viewAttributes() ?>>
<?= $Grid->ORDER_ID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_ORDER_ID" data-hidden="1" name="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_ORDER_ID" id="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_ORDER_ID" value="<?= HtmlEncode($Grid->ORDER_ID->FormValue) ?>">
<input type="hidden" data-table="GOOD_GF" data-field="x_ORDER_ID" data-hidden="1" name="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_ORDER_ID" id="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_ORDER_ID" value="<?= HtmlEncode($Grid->ORDER_ID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->ISCETAK->Visible) { // ISCETAK ?>
        <td data-name="ISCETAK" <?= $Grid->ISCETAK->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_ISCETAK" class="form-group">
<input type="<?= $Grid->ISCETAK->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_ISCETAK" name="x<?= $Grid->RowIndex ?>_ISCETAK" id="x<?= $Grid->RowIndex ?>_ISCETAK" size="30" maxlength="1" placeholder="<?= HtmlEncode($Grid->ISCETAK->getPlaceHolder()) ?>" value="<?= $Grid->ISCETAK->EditValue ?>"<?= $Grid->ISCETAK->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ISCETAK->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_ISCETAK" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ISCETAK" id="o<?= $Grid->RowIndex ?>_ISCETAK" value="<?= HtmlEncode($Grid->ISCETAK->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_ISCETAK" class="form-group">
<input type="<?= $Grid->ISCETAK->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_ISCETAK" name="x<?= $Grid->RowIndex ?>_ISCETAK" id="x<?= $Grid->RowIndex ?>_ISCETAK" size="30" maxlength="1" placeholder="<?= HtmlEncode($Grid->ISCETAK->getPlaceHolder()) ?>" value="<?= $Grid->ISCETAK->EditValue ?>"<?= $Grid->ISCETAK->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ISCETAK->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_ISCETAK">
<span<?= $Grid->ISCETAK->viewAttributes() ?>>
<?= $Grid->ISCETAK->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_ISCETAK" data-hidden="1" name="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_ISCETAK" id="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_ISCETAK" value="<?= HtmlEncode($Grid->ISCETAK->FormValue) ?>">
<input type="hidden" data-table="GOOD_GF" data-field="x_ISCETAK" data-hidden="1" name="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_ISCETAK" id="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_ISCETAK" value="<?= HtmlEncode($Grid->ISCETAK->OldValue) ?>">
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
    <?php if ($Grid->PRINTQ->Visible) { // PRINTQ ?>
        <td data-name="PRINTQ" <?= $Grid->PRINTQ->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_PRINTQ" class="form-group">
<input type="<?= $Grid->PRINTQ->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_PRINTQ" name="x<?= $Grid->RowIndex ?>_PRINTQ" id="x<?= $Grid->RowIndex ?>_PRINTQ" size="30" placeholder="<?= HtmlEncode($Grid->PRINTQ->getPlaceHolder()) ?>" value="<?= $Grid->PRINTQ->EditValue ?>"<?= $Grid->PRINTQ->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->PRINTQ->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_PRINTQ" data-hidden="1" name="o<?= $Grid->RowIndex ?>_PRINTQ" id="o<?= $Grid->RowIndex ?>_PRINTQ" value="<?= HtmlEncode($Grid->PRINTQ->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_PRINTQ" class="form-group">
<input type="<?= $Grid->PRINTQ->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_PRINTQ" name="x<?= $Grid->RowIndex ?>_PRINTQ" id="x<?= $Grid->RowIndex ?>_PRINTQ" size="30" placeholder="<?= HtmlEncode($Grid->PRINTQ->getPlaceHolder()) ?>" value="<?= $Grid->PRINTQ->EditValue ?>"<?= $Grid->PRINTQ->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->PRINTQ->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_PRINTQ">
<span<?= $Grid->PRINTQ->viewAttributes() ?>>
<?= $Grid->PRINTQ->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_PRINTQ" data-hidden="1" name="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_PRINTQ" id="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_PRINTQ" value="<?= HtmlEncode($Grid->PRINTQ->FormValue) ?>">
<input type="hidden" data-table="GOOD_GF" data-field="x_PRINTQ" data-hidden="1" name="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_PRINTQ" id="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_PRINTQ" value="<?= HtmlEncode($Grid->PRINTQ->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->avgprice->Visible) { // avgprice ?>
        <td data-name="avgprice" <?= $Grid->avgprice->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_avgprice" class="form-group">
<input type="<?= $Grid->avgprice->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_avgprice" name="x<?= $Grid->RowIndex ?>_avgprice" id="x<?= $Grid->RowIndex ?>_avgprice" size="30" placeholder="<?= HtmlEncode($Grid->avgprice->getPlaceHolder()) ?>" value="<?= $Grid->avgprice->EditValue ?>"<?= $Grid->avgprice->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->avgprice->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_avgprice" data-hidden="1" name="o<?= $Grid->RowIndex ?>_avgprice" id="o<?= $Grid->RowIndex ?>_avgprice" value="<?= HtmlEncode($Grid->avgprice->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_avgprice" class="form-group">
<input type="<?= $Grid->avgprice->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_avgprice" name="x<?= $Grid->RowIndex ?>_avgprice" id="x<?= $Grid->RowIndex ?>_avgprice" size="30" placeholder="<?= HtmlEncode($Grid->avgprice->getPlaceHolder()) ?>" value="<?= $Grid->avgprice->EditValue ?>"<?= $Grid->avgprice->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->avgprice->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_avgprice">
<span<?= $Grid->avgprice->viewAttributes() ?>>
<?= $Grid->avgprice->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_avgprice" data-hidden="1" name="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_avgprice" id="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_avgprice" value="<?= HtmlEncode($Grid->avgprice->FormValue) ?>">
<input type="hidden" data-table="GOOD_GF" data-field="x_avgprice" data-hidden="1" name="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_avgprice" id="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_avgprice" value="<?= HtmlEncode($Grid->avgprice->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->idx->Visible) { // idx ?>
        <td data-name="idx" <?= $Grid->idx->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_idx" class="form-group"></span>
<input type="hidden" data-table="GOOD_GF" data-field="x_idx" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idx" id="o<?= $Grid->RowIndex ?>_idx" value="<?= HtmlEncode($Grid->idx->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_idx" class="form-group">
<span<?= $Grid->idx->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idx->getDisplayValue($Grid->idx->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_idx" data-hidden="1" name="x<?= $Grid->RowIndex ?>_idx" id="x<?= $Grid->RowIndex ?>_idx" value="<?= HtmlEncode($Grid->idx->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_idx">
<span<?= $Grid->idx->viewAttributes() ?>>
<?= $Grid->idx->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_idx" data-hidden="1" name="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_idx" id="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_idx" value="<?= HtmlEncode($Grid->idx->FormValue) ?>">
<input type="hidden" data-table="GOOD_GF" data-field="x_idx" data-hidden="1" name="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_idx" id="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_idx" value="<?= HtmlEncode($Grid->idx->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="GOOD_GF" data-field="x_idx" data-hidden="1" name="x<?= $Grid->RowIndex ?>_idx" id="x<?= $Grid->RowIndex ?>_idx" value="<?= HtmlEncode($Grid->idx->CurrentValue) ?>">
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
    <?php if ($Grid->ORG_UNIT_CODE->Visible) { // ORG_UNIT_CODE ?>
        <td data-name="ORG_UNIT_CODE">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_GOOD_GF_ORG_UNIT_CODE" class="form-group GOOD_GF_ORG_UNIT_CODE">
<input type="<?= $Grid->ORG_UNIT_CODE->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_ORG_UNIT_CODE" name="x<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" id="x<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->ORG_UNIT_CODE->getPlaceHolder()) ?>" value="<?= $Grid->ORG_UNIT_CODE->EditValue ?>"<?= $Grid->ORG_UNIT_CODE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ORG_UNIT_CODE->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_ORG_UNIT_CODE" class="form-group GOOD_GF_ORG_UNIT_CODE">
<span<?= $Grid->ORG_UNIT_CODE->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->ORG_UNIT_CODE->getDisplayValue($Grid->ORG_UNIT_CODE->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_ORG_UNIT_CODE" data-hidden="1" name="x<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" id="x<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" value="<?= HtmlEncode($Grid->ORG_UNIT_CODE->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_ORG_UNIT_CODE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" id="o<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" value="<?= HtmlEncode($Grid->ORG_UNIT_CODE->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->ITEM_ID->Visible) { // ITEM_ID ?>
        <td data-name="ITEM_ID">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_GOOD_GF_ITEM_ID" class="form-group GOOD_GF_ITEM_ID">
<input type="<?= $Grid->ITEM_ID->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_ITEM_ID" name="x<?= $Grid->RowIndex ?>_ITEM_ID" id="x<?= $Grid->RowIndex ?>_ITEM_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->ITEM_ID->getPlaceHolder()) ?>" value="<?= $Grid->ITEM_ID->EditValue ?>"<?= $Grid->ITEM_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ITEM_ID->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_ITEM_ID" class="form-group GOOD_GF_ITEM_ID">
<span<?= $Grid->ITEM_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->ITEM_ID->getDisplayValue($Grid->ITEM_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_ITEM_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_ITEM_ID" id="x<?= $Grid->RowIndex ?>_ITEM_ID" value="<?= HtmlEncode($Grid->ITEM_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_ITEM_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ITEM_ID" id="o<?= $Grid->RowIndex ?>_ITEM_ID" value="<?= HtmlEncode($Grid->ITEM_ID->OldValue) ?>">
</td>
    <?php } ?>
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
    <?php if ($Grid->BATCH_NO->Visible) { // BATCH_NO ?>
        <td data-name="BATCH_NO">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_GOOD_GF_BATCH_NO" class="form-group GOOD_GF_BATCH_NO">
<input type="<?= $Grid->BATCH_NO->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_BATCH_NO" name="x<?= $Grid->RowIndex ?>_BATCH_NO" id="x<?= $Grid->RowIndex ?>_BATCH_NO" size="30" maxlength="75" placeholder="<?= HtmlEncode($Grid->BATCH_NO->getPlaceHolder()) ?>" value="<?= $Grid->BATCH_NO->EditValue ?>"<?= $Grid->BATCH_NO->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->BATCH_NO->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_BATCH_NO" class="form-group GOOD_GF_BATCH_NO">
<span<?= $Grid->BATCH_NO->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->BATCH_NO->getDisplayValue($Grid->BATCH_NO->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_BATCH_NO" data-hidden="1" name="x<?= $Grid->RowIndex ?>_BATCH_NO" id="x<?= $Grid->RowIndex ?>_BATCH_NO" value="<?= HtmlEncode($Grid->BATCH_NO->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_BATCH_NO" data-hidden="1" name="o<?= $Grid->RowIndex ?>_BATCH_NO" id="o<?= $Grid->RowIndex ?>_BATCH_NO" value="<?= HtmlEncode($Grid->BATCH_NO->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->BRAND_ID->Visible) { // BRAND_ID ?>
        <td data-name="BRAND_ID">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_GOOD_GF_BRAND_ID" class="form-group GOOD_GF_BRAND_ID">
<input type="<?= $Grid->BRAND_ID->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_BRAND_ID" name="x<?= $Grid->RowIndex ?>_BRAND_ID" id="x<?= $Grid->RowIndex ?>_BRAND_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->BRAND_ID->getPlaceHolder()) ?>" value="<?= $Grid->BRAND_ID->EditValue ?>"<?= $Grid->BRAND_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->BRAND_ID->getErrorMessage() ?></div>
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
    <?php if ($Grid->SHELF_NO->Visible) { // SHELF_NO ?>
        <td data-name="SHELF_NO">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_GOOD_GF_SHELF_NO" class="form-group GOOD_GF_SHELF_NO">
<input type="<?= $Grid->SHELF_NO->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_SHELF_NO" name="x<?= $Grid->RowIndex ?>_SHELF_NO" id="x<?= $Grid->RowIndex ?>_SHELF_NO" size="30" placeholder="<?= HtmlEncode($Grid->SHELF_NO->getPlaceHolder()) ?>" value="<?= $Grid->SHELF_NO->EditValue ?>"<?= $Grid->SHELF_NO->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->SHELF_NO->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_SHELF_NO" class="form-group GOOD_GF_SHELF_NO">
<span<?= $Grid->SHELF_NO->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->SHELF_NO->getDisplayValue($Grid->SHELF_NO->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_SHELF_NO" data-hidden="1" name="x<?= $Grid->RowIndex ?>_SHELF_NO" id="x<?= $Grid->RowIndex ?>_SHELF_NO" value="<?= HtmlEncode($Grid->SHELF_NO->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_SHELF_NO" data-hidden="1" name="o<?= $Grid->RowIndex ?>_SHELF_NO" id="o<?= $Grid->RowIndex ?>_SHELF_NO" value="<?= HtmlEncode($Grid->SHELF_NO->OldValue) ?>">
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
    <?php if ($Grid->SERIAL_NB->Visible) { // SERIAL_NB ?>
        <td data-name="SERIAL_NB">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_GOOD_GF_SERIAL_NB" class="form-group GOOD_GF_SERIAL_NB">
<input type="<?= $Grid->SERIAL_NB->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_SERIAL_NB" name="x<?= $Grid->RowIndex ?>_SERIAL_NB" id="x<?= $Grid->RowIndex ?>_SERIAL_NB" size="30" maxlength="200" placeholder="<?= HtmlEncode($Grid->SERIAL_NB->getPlaceHolder()) ?>" value="<?= $Grid->SERIAL_NB->EditValue ?>"<?= $Grid->SERIAL_NB->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->SERIAL_NB->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_SERIAL_NB" class="form-group GOOD_GF_SERIAL_NB">
<span<?= $Grid->SERIAL_NB->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->SERIAL_NB->getDisplayValue($Grid->SERIAL_NB->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_SERIAL_NB" data-hidden="1" name="x<?= $Grid->RowIndex ?>_SERIAL_NB" id="x<?= $Grid->RowIndex ?>_SERIAL_NB" value="<?= HtmlEncode($Grid->SERIAL_NB->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_SERIAL_NB" data-hidden="1" name="o<?= $Grid->RowIndex ?>_SERIAL_NB" id="o<?= $Grid->RowIndex ?>_SERIAL_NB" value="<?= HtmlEncode($Grid->SERIAL_NB->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->FROM_ROOMS_ID->Visible) { // FROM_ROOMS_ID ?>
        <td data-name="FROM_ROOMS_ID">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_GOOD_GF_FROM_ROOMS_ID" class="form-group GOOD_GF_FROM_ROOMS_ID">
<input type="<?= $Grid->FROM_ROOMS_ID->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_FROM_ROOMS_ID" name="x<?= $Grid->RowIndex ?>_FROM_ROOMS_ID" id="x<?= $Grid->RowIndex ?>_FROM_ROOMS_ID" size="30" maxlength="10" placeholder="<?= HtmlEncode($Grid->FROM_ROOMS_ID->getPlaceHolder()) ?>" value="<?= $Grid->FROM_ROOMS_ID->EditValue ?>"<?= $Grid->FROM_ROOMS_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->FROM_ROOMS_ID->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_FROM_ROOMS_ID" class="form-group GOOD_GF_FROM_ROOMS_ID">
<span<?= $Grid->FROM_ROOMS_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->FROM_ROOMS_ID->getDisplayValue($Grid->FROM_ROOMS_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_FROM_ROOMS_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_FROM_ROOMS_ID" id="x<?= $Grid->RowIndex ?>_FROM_ROOMS_ID" value="<?= HtmlEncode($Grid->FROM_ROOMS_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_FROM_ROOMS_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_FROM_ROOMS_ID" id="o<?= $Grid->RowIndex ?>_FROM_ROOMS_ID" value="<?= HtmlEncode($Grid->FROM_ROOMS_ID->OldValue) ?>">
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
    <?php if ($Grid->DISTRIBUTION_TYPE->Visible) { // DISTRIBUTION_TYPE ?>
        <td data-name="DISTRIBUTION_TYPE">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_GOOD_GF_DISTRIBUTION_TYPE" class="form-group GOOD_GF_DISTRIBUTION_TYPE">
<input type="<?= $Grid->DISTRIBUTION_TYPE->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_DISTRIBUTION_TYPE" name="x<?= $Grid->RowIndex ?>_DISTRIBUTION_TYPE" id="x<?= $Grid->RowIndex ?>_DISTRIBUTION_TYPE" size="30" placeholder="<?= HtmlEncode($Grid->DISTRIBUTION_TYPE->getPlaceHolder()) ?>" value="<?= $Grid->DISTRIBUTION_TYPE->EditValue ?>"<?= $Grid->DISTRIBUTION_TYPE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->DISTRIBUTION_TYPE->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_DISTRIBUTION_TYPE" class="form-group GOOD_GF_DISTRIBUTION_TYPE">
<span<?= $Grid->DISTRIBUTION_TYPE->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->DISTRIBUTION_TYPE->getDisplayValue($Grid->DISTRIBUTION_TYPE->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_DISTRIBUTION_TYPE" data-hidden="1" name="x<?= $Grid->RowIndex ?>_DISTRIBUTION_TYPE" id="x<?= $Grid->RowIndex ?>_DISTRIBUTION_TYPE" value="<?= HtmlEncode($Grid->DISTRIBUTION_TYPE->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_DISTRIBUTION_TYPE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_DISTRIBUTION_TYPE" id="o<?= $Grid->RowIndex ?>_DISTRIBUTION_TYPE" value="<?= HtmlEncode($Grid->DISTRIBUTION_TYPE->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->CONDITION->Visible) { // CONDITION ?>
        <td data-name="CONDITION">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_GOOD_GF_CONDITION" class="form-group GOOD_GF_CONDITION">
<input type="<?= $Grid->CONDITION->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_CONDITION" name="x<?= $Grid->RowIndex ?>_CONDITION" id="x<?= $Grid->RowIndex ?>_CONDITION" size="30" placeholder="<?= HtmlEncode($Grid->CONDITION->getPlaceHolder()) ?>" value="<?= $Grid->CONDITION->EditValue ?>"<?= $Grid->CONDITION->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->CONDITION->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_CONDITION" class="form-group GOOD_GF_CONDITION">
<span<?= $Grid->CONDITION->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->CONDITION->getDisplayValue($Grid->CONDITION->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_CONDITION" data-hidden="1" name="x<?= $Grid->RowIndex ?>_CONDITION" id="x<?= $Grid->RowIndex ?>_CONDITION" value="<?= HtmlEncode($Grid->CONDITION->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_CONDITION" data-hidden="1" name="o<?= $Grid->RowIndex ?>_CONDITION" id="o<?= $Grid->RowIndex ?>_CONDITION" value="<?= HtmlEncode($Grid->CONDITION->OldValue) ?>">
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
    <?php if ($Grid->STOCKOPNAME_DATE->Visible) { // STOCKOPNAME_DATE ?>
        <td data-name="STOCKOPNAME_DATE">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_GOOD_GF_STOCKOPNAME_DATE" class="form-group GOOD_GF_STOCKOPNAME_DATE">
<input type="<?= $Grid->STOCKOPNAME_DATE->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_STOCKOPNAME_DATE" name="x<?= $Grid->RowIndex ?>_STOCKOPNAME_DATE" id="x<?= $Grid->RowIndex ?>_STOCKOPNAME_DATE" placeholder="<?= HtmlEncode($Grid->STOCKOPNAME_DATE->getPlaceHolder()) ?>" value="<?= $Grid->STOCKOPNAME_DATE->EditValue ?>"<?= $Grid->STOCKOPNAME_DATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->STOCKOPNAME_DATE->getErrorMessage() ?></div>
<?php if (!$Grid->STOCKOPNAME_DATE->ReadOnly && !$Grid->STOCKOPNAME_DATE->Disabled && !isset($Grid->STOCKOPNAME_DATE->EditAttrs["readonly"]) && !isset($Grid->STOCKOPNAME_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fGOOD_GFgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fGOOD_GFgrid", "x<?= $Grid->RowIndex ?>_STOCKOPNAME_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_STOCKOPNAME_DATE" class="form-group GOOD_GF_STOCKOPNAME_DATE">
<span<?= $Grid->STOCKOPNAME_DATE->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->STOCKOPNAME_DATE->getDisplayValue($Grid->STOCKOPNAME_DATE->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_STOCKOPNAME_DATE" data-hidden="1" name="x<?= $Grid->RowIndex ?>_STOCKOPNAME_DATE" id="x<?= $Grid->RowIndex ?>_STOCKOPNAME_DATE" value="<?= HtmlEncode($Grid->STOCKOPNAME_DATE->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_STOCKOPNAME_DATE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_STOCKOPNAME_DATE" id="o<?= $Grid->RowIndex ?>_STOCKOPNAME_DATE" value="<?= HtmlEncode($Grid->STOCKOPNAME_DATE->OldValue) ?>">
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
    <?php if ($Grid->DISCOUNT->Visible) { // DISCOUNT ?>
        <td data-name="DISCOUNT">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_GOOD_GF_DISCOUNT" class="form-group GOOD_GF_DISCOUNT">
<input type="<?= $Grid->DISCOUNT->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_DISCOUNT" name="x<?= $Grid->RowIndex ?>_DISCOUNT" id="x<?= $Grid->RowIndex ?>_DISCOUNT" size="30" placeholder="<?= HtmlEncode($Grid->DISCOUNT->getPlaceHolder()) ?>" value="<?= $Grid->DISCOUNT->EditValue ?>"<?= $Grid->DISCOUNT->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->DISCOUNT->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_DISCOUNT" class="form-group GOOD_GF_DISCOUNT">
<span<?= $Grid->DISCOUNT->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->DISCOUNT->getDisplayValue($Grid->DISCOUNT->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_DISCOUNT" data-hidden="1" name="x<?= $Grid->RowIndex ?>_DISCOUNT" id="x<?= $Grid->RowIndex ?>_DISCOUNT" value="<?= HtmlEncode($Grid->DISCOUNT->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_DISCOUNT" data-hidden="1" name="o<?= $Grid->RowIndex ?>_DISCOUNT" id="o<?= $Grid->RowIndex ?>_DISCOUNT" value="<?= HtmlEncode($Grid->DISCOUNT->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->DISCOUNT2->Visible) { // DISCOUNT2 ?>
        <td data-name="DISCOUNT2">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_GOOD_GF_DISCOUNT2" class="form-group GOOD_GF_DISCOUNT2">
<input type="<?= $Grid->DISCOUNT2->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_DISCOUNT2" name="x<?= $Grid->RowIndex ?>_DISCOUNT2" id="x<?= $Grid->RowIndex ?>_DISCOUNT2" size="30" placeholder="<?= HtmlEncode($Grid->DISCOUNT2->getPlaceHolder()) ?>" value="<?= $Grid->DISCOUNT2->EditValue ?>"<?= $Grid->DISCOUNT2->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->DISCOUNT2->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_DISCOUNT2" class="form-group GOOD_GF_DISCOUNT2">
<span<?= $Grid->DISCOUNT2->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->DISCOUNT2->getDisplayValue($Grid->DISCOUNT2->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_DISCOUNT2" data-hidden="1" name="x<?= $Grid->RowIndex ?>_DISCOUNT2" id="x<?= $Grid->RowIndex ?>_DISCOUNT2" value="<?= HtmlEncode($Grid->DISCOUNT2->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_DISCOUNT2" data-hidden="1" name="o<?= $Grid->RowIndex ?>_DISCOUNT2" id="o<?= $Grid->RowIndex ?>_DISCOUNT2" value="<?= HtmlEncode($Grid->DISCOUNT2->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->DISCOUNTOFF->Visible) { // DISCOUNTOFF ?>
        <td data-name="DISCOUNTOFF">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_GOOD_GF_DISCOUNTOFF" class="form-group GOOD_GF_DISCOUNTOFF">
<input type="<?= $Grid->DISCOUNTOFF->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_DISCOUNTOFF" name="x<?= $Grid->RowIndex ?>_DISCOUNTOFF" id="x<?= $Grid->RowIndex ?>_DISCOUNTOFF" size="30" placeholder="<?= HtmlEncode($Grid->DISCOUNTOFF->getPlaceHolder()) ?>" value="<?= $Grid->DISCOUNTOFF->EditValue ?>"<?= $Grid->DISCOUNTOFF->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->DISCOUNTOFF->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_DISCOUNTOFF" class="form-group GOOD_GF_DISCOUNTOFF">
<span<?= $Grid->DISCOUNTOFF->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->DISCOUNTOFF->getDisplayValue($Grid->DISCOUNTOFF->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_DISCOUNTOFF" data-hidden="1" name="x<?= $Grid->RowIndex ?>_DISCOUNTOFF" id="x<?= $Grid->RowIndex ?>_DISCOUNTOFF" value="<?= HtmlEncode($Grid->DISCOUNTOFF->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_DISCOUNTOFF" data-hidden="1" name="o<?= $Grid->RowIndex ?>_DISCOUNTOFF" id="o<?= $Grid->RowIndex ?>_DISCOUNTOFF" value="<?= HtmlEncode($Grid->DISCOUNTOFF->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->ORG_UNIT_FROM->Visible) { // ORG_UNIT_FROM ?>
        <td data-name="ORG_UNIT_FROM">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_GOOD_GF_ORG_UNIT_FROM" class="form-group GOOD_GF_ORG_UNIT_FROM">
<input type="<?= $Grid->ORG_UNIT_FROM->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_ORG_UNIT_FROM" name="x<?= $Grid->RowIndex ?>_ORG_UNIT_FROM" id="x<?= $Grid->RowIndex ?>_ORG_UNIT_FROM" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->ORG_UNIT_FROM->getPlaceHolder()) ?>" value="<?= $Grid->ORG_UNIT_FROM->EditValue ?>"<?= $Grid->ORG_UNIT_FROM->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ORG_UNIT_FROM->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_ORG_UNIT_FROM" class="form-group GOOD_GF_ORG_UNIT_FROM">
<span<?= $Grid->ORG_UNIT_FROM->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->ORG_UNIT_FROM->getDisplayValue($Grid->ORG_UNIT_FROM->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_ORG_UNIT_FROM" data-hidden="1" name="x<?= $Grid->RowIndex ?>_ORG_UNIT_FROM" id="x<?= $Grid->RowIndex ?>_ORG_UNIT_FROM" value="<?= HtmlEncode($Grid->ORG_UNIT_FROM->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_ORG_UNIT_FROM" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ORG_UNIT_FROM" id="o<?= $Grid->RowIndex ?>_ORG_UNIT_FROM" value="<?= HtmlEncode($Grid->ORG_UNIT_FROM->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->ITEM_ID_FROM->Visible) { // ITEM_ID_FROM ?>
        <td data-name="ITEM_ID_FROM">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_GOOD_GF_ITEM_ID_FROM" class="form-group GOOD_GF_ITEM_ID_FROM">
<input type="<?= $Grid->ITEM_ID_FROM->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_ITEM_ID_FROM" name="x<?= $Grid->RowIndex ?>_ITEM_ID_FROM" id="x<?= $Grid->RowIndex ?>_ITEM_ID_FROM" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->ITEM_ID_FROM->getPlaceHolder()) ?>" value="<?= $Grid->ITEM_ID_FROM->EditValue ?>"<?= $Grid->ITEM_ID_FROM->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ITEM_ID_FROM->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_ITEM_ID_FROM" class="form-group GOOD_GF_ITEM_ID_FROM">
<span<?= $Grid->ITEM_ID_FROM->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->ITEM_ID_FROM->getDisplayValue($Grid->ITEM_ID_FROM->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_ITEM_ID_FROM" data-hidden="1" name="x<?= $Grid->RowIndex ?>_ITEM_ID_FROM" id="x<?= $Grid->RowIndex ?>_ITEM_ID_FROM" value="<?= HtmlEncode($Grid->ITEM_ID_FROM->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_ITEM_ID_FROM" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ITEM_ID_FROM" id="o<?= $Grid->RowIndex ?>_ITEM_ID_FROM" value="<?= HtmlEncode($Grid->ITEM_ID_FROM->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
        <td data-name="MODIFIED_DATE">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_GOOD_GF_MODIFIED_DATE" class="form-group GOOD_GF_MODIFIED_DATE">
<input type="<?= $Grid->MODIFIED_DATE->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_MODIFIED_DATE" name="x<?= $Grid->RowIndex ?>_MODIFIED_DATE" id="x<?= $Grid->RowIndex ?>_MODIFIED_DATE" placeholder="<?= HtmlEncode($Grid->MODIFIED_DATE->getPlaceHolder()) ?>" value="<?= $Grid->MODIFIED_DATE->EditValue ?>"<?= $Grid->MODIFIED_DATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->MODIFIED_DATE->getErrorMessage() ?></div>
<?php if (!$Grid->MODIFIED_DATE->ReadOnly && !$Grid->MODIFIED_DATE->Disabled && !isset($Grid->MODIFIED_DATE->EditAttrs["readonly"]) && !isset($Grid->MODIFIED_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fGOOD_GFgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fGOOD_GFgrid", "x<?= $Grid->RowIndex ?>_MODIFIED_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_MODIFIED_DATE" class="form-group GOOD_GF_MODIFIED_DATE">
<span<?= $Grid->MODIFIED_DATE->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->MODIFIED_DATE->getDisplayValue($Grid->MODIFIED_DATE->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_MODIFIED_DATE" data-hidden="1" name="x<?= $Grid->RowIndex ?>_MODIFIED_DATE" id="x<?= $Grid->RowIndex ?>_MODIFIED_DATE" value="<?= HtmlEncode($Grid->MODIFIED_DATE->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_MODIFIED_DATE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_MODIFIED_DATE" id="o<?= $Grid->RowIndex ?>_MODIFIED_DATE" value="<?= HtmlEncode($Grid->MODIFIED_DATE->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
        <td data-name="MODIFIED_BY">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_GOOD_GF_MODIFIED_BY" class="form-group GOOD_GF_MODIFIED_BY">
<input type="<?= $Grid->MODIFIED_BY->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_MODIFIED_BY" name="x<?= $Grid->RowIndex ?>_MODIFIED_BY" id="x<?= $Grid->RowIndex ?>_MODIFIED_BY" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->MODIFIED_BY->getPlaceHolder()) ?>" value="<?= $Grid->MODIFIED_BY->EditValue ?>"<?= $Grid->MODIFIED_BY->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->MODIFIED_BY->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_MODIFIED_BY" class="form-group GOOD_GF_MODIFIED_BY">
<span<?= $Grid->MODIFIED_BY->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->MODIFIED_BY->getDisplayValue($Grid->MODIFIED_BY->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_MODIFIED_BY" data-hidden="1" name="x<?= $Grid->RowIndex ?>_MODIFIED_BY" id="x<?= $Grid->RowIndex ?>_MODIFIED_BY" value="<?= HtmlEncode($Grid->MODIFIED_BY->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_MODIFIED_BY" data-hidden="1" name="o<?= $Grid->RowIndex ?>_MODIFIED_BY" id="o<?= $Grid->RowIndex ?>_MODIFIED_BY" value="<?= HtmlEncode($Grid->MODIFIED_BY->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->STOCK_OPNAME->Visible) { // STOCK_OPNAME ?>
        <td data-name="STOCK_OPNAME">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_GOOD_GF_STOCK_OPNAME" class="form-group GOOD_GF_STOCK_OPNAME">
<input type="<?= $Grid->STOCK_OPNAME->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_STOCK_OPNAME" name="x<?= $Grid->RowIndex ?>_STOCK_OPNAME" id="x<?= $Grid->RowIndex ?>_STOCK_OPNAME" size="30" placeholder="<?= HtmlEncode($Grid->STOCK_OPNAME->getPlaceHolder()) ?>" value="<?= $Grid->STOCK_OPNAME->EditValue ?>"<?= $Grid->STOCK_OPNAME->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->STOCK_OPNAME->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_STOCK_OPNAME" class="form-group GOOD_GF_STOCK_OPNAME">
<span<?= $Grid->STOCK_OPNAME->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->STOCK_OPNAME->getDisplayValue($Grid->STOCK_OPNAME->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_STOCK_OPNAME" data-hidden="1" name="x<?= $Grid->RowIndex ?>_STOCK_OPNAME" id="x<?= $Grid->RowIndex ?>_STOCK_OPNAME" value="<?= HtmlEncode($Grid->STOCK_OPNAME->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_STOCK_OPNAME" data-hidden="1" name="o<?= $Grid->RowIndex ?>_STOCK_OPNAME" id="o<?= $Grid->RowIndex ?>_STOCK_OPNAME" value="<?= HtmlEncode($Grid->STOCK_OPNAME->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->STOK_AWAL->Visible) { // STOK_AWAL ?>
        <td data-name="STOK_AWAL">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_GOOD_GF_STOK_AWAL" class="form-group GOOD_GF_STOK_AWAL">
<input type="<?= $Grid->STOK_AWAL->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_STOK_AWAL" name="x<?= $Grid->RowIndex ?>_STOK_AWAL" id="x<?= $Grid->RowIndex ?>_STOK_AWAL" size="30" placeholder="<?= HtmlEncode($Grid->STOK_AWAL->getPlaceHolder()) ?>" value="<?= $Grid->STOK_AWAL->EditValue ?>"<?= $Grid->STOK_AWAL->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->STOK_AWAL->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_STOK_AWAL" class="form-group GOOD_GF_STOK_AWAL">
<span<?= $Grid->STOK_AWAL->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->STOK_AWAL->getDisplayValue($Grid->STOK_AWAL->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_STOK_AWAL" data-hidden="1" name="x<?= $Grid->RowIndex ?>_STOK_AWAL" id="x<?= $Grid->RowIndex ?>_STOK_AWAL" value="<?= HtmlEncode($Grid->STOK_AWAL->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_STOK_AWAL" data-hidden="1" name="o<?= $Grid->RowIndex ?>_STOK_AWAL" id="o<?= $Grid->RowIndex ?>_STOK_AWAL" value="<?= HtmlEncode($Grid->STOK_AWAL->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->STOCK_LALU->Visible) { // STOCK_LALU ?>
        <td data-name="STOCK_LALU">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_GOOD_GF_STOCK_LALU" class="form-group GOOD_GF_STOCK_LALU">
<input type="<?= $Grid->STOCK_LALU->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_STOCK_LALU" name="x<?= $Grid->RowIndex ?>_STOCK_LALU" id="x<?= $Grid->RowIndex ?>_STOCK_LALU" size="30" placeholder="<?= HtmlEncode($Grid->STOCK_LALU->getPlaceHolder()) ?>" value="<?= $Grid->STOCK_LALU->EditValue ?>"<?= $Grid->STOCK_LALU->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->STOCK_LALU->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_STOCK_LALU" class="form-group GOOD_GF_STOCK_LALU">
<span<?= $Grid->STOCK_LALU->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->STOCK_LALU->getDisplayValue($Grid->STOCK_LALU->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_STOCK_LALU" data-hidden="1" name="x<?= $Grid->RowIndex ?>_STOCK_LALU" id="x<?= $Grid->RowIndex ?>_STOCK_LALU" value="<?= HtmlEncode($Grid->STOCK_LALU->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_STOCK_LALU" data-hidden="1" name="o<?= $Grid->RowIndex ?>_STOCK_LALU" id="o<?= $Grid->RowIndex ?>_STOCK_LALU" value="<?= HtmlEncode($Grid->STOCK_LALU->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->STOCK_KOREKSI->Visible) { // STOCK_KOREKSI ?>
        <td data-name="STOCK_KOREKSI">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_GOOD_GF_STOCK_KOREKSI" class="form-group GOOD_GF_STOCK_KOREKSI">
<input type="<?= $Grid->STOCK_KOREKSI->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_STOCK_KOREKSI" name="x<?= $Grid->RowIndex ?>_STOCK_KOREKSI" id="x<?= $Grid->RowIndex ?>_STOCK_KOREKSI" size="30" placeholder="<?= HtmlEncode($Grid->STOCK_KOREKSI->getPlaceHolder()) ?>" value="<?= $Grid->STOCK_KOREKSI->EditValue ?>"<?= $Grid->STOCK_KOREKSI->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->STOCK_KOREKSI->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_STOCK_KOREKSI" class="form-group GOOD_GF_STOCK_KOREKSI">
<span<?= $Grid->STOCK_KOREKSI->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->STOCK_KOREKSI->getDisplayValue($Grid->STOCK_KOREKSI->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_STOCK_KOREKSI" data-hidden="1" name="x<?= $Grid->RowIndex ?>_STOCK_KOREKSI" id="x<?= $Grid->RowIndex ?>_STOCK_KOREKSI" value="<?= HtmlEncode($Grid->STOCK_KOREKSI->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_STOCK_KOREKSI" data-hidden="1" name="o<?= $Grid->RowIndex ?>_STOCK_KOREKSI" id="o<?= $Grid->RowIndex ?>_STOCK_KOREKSI" value="<?= HtmlEncode($Grid->STOCK_KOREKSI->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->DITERIMA->Visible) { // DITERIMA ?>
        <td data-name="DITERIMA">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_GOOD_GF_DITERIMA" class="form-group GOOD_GF_DITERIMA">
<input type="<?= $Grid->DITERIMA->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_DITERIMA" name="x<?= $Grid->RowIndex ?>_DITERIMA" id="x<?= $Grid->RowIndex ?>_DITERIMA" size="30" placeholder="<?= HtmlEncode($Grid->DITERIMA->getPlaceHolder()) ?>" value="<?= $Grid->DITERIMA->EditValue ?>"<?= $Grid->DITERIMA->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->DITERIMA->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_DITERIMA" class="form-group GOOD_GF_DITERIMA">
<span<?= $Grid->DITERIMA->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->DITERIMA->getDisplayValue($Grid->DITERIMA->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_DITERIMA" data-hidden="1" name="x<?= $Grid->RowIndex ?>_DITERIMA" id="x<?= $Grid->RowIndex ?>_DITERIMA" value="<?= HtmlEncode($Grid->DITERIMA->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_DITERIMA" data-hidden="1" name="o<?= $Grid->RowIndex ?>_DITERIMA" id="o<?= $Grid->RowIndex ?>_DITERIMA" value="<?= HtmlEncode($Grid->DITERIMA->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->DISTRIBUSI->Visible) { // DISTRIBUSI ?>
        <td data-name="DISTRIBUSI">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_GOOD_GF_DISTRIBUSI" class="form-group GOOD_GF_DISTRIBUSI">
<input type="<?= $Grid->DISTRIBUSI->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_DISTRIBUSI" name="x<?= $Grid->RowIndex ?>_DISTRIBUSI" id="x<?= $Grid->RowIndex ?>_DISTRIBUSI" size="30" placeholder="<?= HtmlEncode($Grid->DISTRIBUSI->getPlaceHolder()) ?>" value="<?= $Grid->DISTRIBUSI->EditValue ?>"<?= $Grid->DISTRIBUSI->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->DISTRIBUSI->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_DISTRIBUSI" class="form-group GOOD_GF_DISTRIBUSI">
<span<?= $Grid->DISTRIBUSI->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->DISTRIBUSI->getDisplayValue($Grid->DISTRIBUSI->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_DISTRIBUSI" data-hidden="1" name="x<?= $Grid->RowIndex ?>_DISTRIBUSI" id="x<?= $Grid->RowIndex ?>_DISTRIBUSI" value="<?= HtmlEncode($Grid->DISTRIBUSI->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_DISTRIBUSI" data-hidden="1" name="o<?= $Grid->RowIndex ?>_DISTRIBUSI" id="o<?= $Grid->RowIndex ?>_DISTRIBUSI" value="<?= HtmlEncode($Grid->DISTRIBUSI->OldValue) ?>">
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
    <?php if ($Grid->DIHAPUS->Visible) { // DIHAPUS ?>
        <td data-name="DIHAPUS">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_GOOD_GF_DIHAPUS" class="form-group GOOD_GF_DIHAPUS">
<input type="<?= $Grid->DIHAPUS->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_DIHAPUS" name="x<?= $Grid->RowIndex ?>_DIHAPUS" id="x<?= $Grid->RowIndex ?>_DIHAPUS" size="30" placeholder="<?= HtmlEncode($Grid->DIHAPUS->getPlaceHolder()) ?>" value="<?= $Grid->DIHAPUS->EditValue ?>"<?= $Grid->DIHAPUS->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->DIHAPUS->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_DIHAPUS" class="form-group GOOD_GF_DIHAPUS">
<span<?= $Grid->DIHAPUS->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->DIHAPUS->getDisplayValue($Grid->DIHAPUS->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_DIHAPUS" data-hidden="1" name="x<?= $Grid->RowIndex ?>_DIHAPUS" id="x<?= $Grid->RowIndex ?>_DIHAPUS" value="<?= HtmlEncode($Grid->DIHAPUS->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_DIHAPUS" data-hidden="1" name="o<?= $Grid->RowIndex ?>_DIHAPUS" id="o<?= $Grid->RowIndex ?>_DIHAPUS" value="<?= HtmlEncode($Grid->DIHAPUS->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->DIMINTA->Visible) { // DIMINTA ?>
        <td data-name="DIMINTA">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_GOOD_GF_DIMINTA" class="form-group GOOD_GF_DIMINTA">
<input type="<?= $Grid->DIMINTA->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_DIMINTA" name="x<?= $Grid->RowIndex ?>_DIMINTA" id="x<?= $Grid->RowIndex ?>_DIMINTA" size="30" placeholder="<?= HtmlEncode($Grid->DIMINTA->getPlaceHolder()) ?>" value="<?= $Grid->DIMINTA->EditValue ?>"<?= $Grid->DIMINTA->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->DIMINTA->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_DIMINTA" class="form-group GOOD_GF_DIMINTA">
<span<?= $Grid->DIMINTA->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->DIMINTA->getDisplayValue($Grid->DIMINTA->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_DIMINTA" data-hidden="1" name="x<?= $Grid->RowIndex ?>_DIMINTA" id="x<?= $Grid->RowIndex ?>_DIMINTA" value="<?= HtmlEncode($Grid->DIMINTA->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_DIMINTA" data-hidden="1" name="o<?= $Grid->RowIndex ?>_DIMINTA" id="o<?= $Grid->RowIndex ?>_DIMINTA" value="<?= HtmlEncode($Grid->DIMINTA->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->DIRETUR->Visible) { // DIRETUR ?>
        <td data-name="DIRETUR">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_GOOD_GF_DIRETUR" class="form-group GOOD_GF_DIRETUR">
<input type="<?= $Grid->DIRETUR->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_DIRETUR" name="x<?= $Grid->RowIndex ?>_DIRETUR" id="x<?= $Grid->RowIndex ?>_DIRETUR" size="30" placeholder="<?= HtmlEncode($Grid->DIRETUR->getPlaceHolder()) ?>" value="<?= $Grid->DIRETUR->EditValue ?>"<?= $Grid->DIRETUR->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->DIRETUR->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_DIRETUR" class="form-group GOOD_GF_DIRETUR">
<span<?= $Grid->DIRETUR->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->DIRETUR->getDisplayValue($Grid->DIRETUR->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_DIRETUR" data-hidden="1" name="x<?= $Grid->RowIndex ?>_DIRETUR" id="x<?= $Grid->RowIndex ?>_DIRETUR" value="<?= HtmlEncode($Grid->DIRETUR->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_DIRETUR" data-hidden="1" name="o<?= $Grid->RowIndex ?>_DIRETUR" id="o<?= $Grid->RowIndex ?>_DIRETUR" value="<?= HtmlEncode($Grid->DIRETUR->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->PO->Visible) { // PO ?>
        <td data-name="PO">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_GOOD_GF_PO" class="form-group GOOD_GF_PO">
<input type="<?= $Grid->PO->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_PO" name="x<?= $Grid->RowIndex ?>_PO" id="x<?= $Grid->RowIndex ?>_PO" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->PO->getPlaceHolder()) ?>" value="<?= $Grid->PO->EditValue ?>"<?= $Grid->PO->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->PO->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_PO" class="form-group GOOD_GF_PO">
<span<?= $Grid->PO->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->PO->getDisplayValue($Grid->PO->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_PO" data-hidden="1" name="x<?= $Grid->RowIndex ?>_PO" id="x<?= $Grid->RowIndex ?>_PO" value="<?= HtmlEncode($Grid->PO->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_PO" data-hidden="1" name="o<?= $Grid->RowIndex ?>_PO" id="o<?= $Grid->RowIndex ?>_PO" value="<?= HtmlEncode($Grid->PO->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->COMPANY_ID->Visible) { // COMPANY_ID ?>
        <td data-name="COMPANY_ID">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_GOOD_GF_COMPANY_ID" class="form-group GOOD_GF_COMPANY_ID">
<input type="<?= $Grid->COMPANY_ID->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_COMPANY_ID" name="x<?= $Grid->RowIndex ?>_COMPANY_ID" id="x<?= $Grid->RowIndex ?>_COMPANY_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->COMPANY_ID->getPlaceHolder()) ?>" value="<?= $Grid->COMPANY_ID->EditValue ?>"<?= $Grid->COMPANY_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->COMPANY_ID->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_COMPANY_ID" class="form-group GOOD_GF_COMPANY_ID">
<span<?= $Grid->COMPANY_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->COMPANY_ID->getDisplayValue($Grid->COMPANY_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_COMPANY_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_COMPANY_ID" id="x<?= $Grid->RowIndex ?>_COMPANY_ID" value="<?= HtmlEncode($Grid->COMPANY_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_COMPANY_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_COMPANY_ID" id="o<?= $Grid->RowIndex ?>_COMPANY_ID" value="<?= HtmlEncode($Grid->COMPANY_ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->FUND_ID->Visible) { // FUND_ID ?>
        <td data-name="FUND_ID">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_GOOD_GF_FUND_ID" class="form-group GOOD_GF_FUND_ID">
<input type="<?= $Grid->FUND_ID->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_FUND_ID" name="x<?= $Grid->RowIndex ?>_FUND_ID" id="x<?= $Grid->RowIndex ?>_FUND_ID" size="30" placeholder="<?= HtmlEncode($Grid->FUND_ID->getPlaceHolder()) ?>" value="<?= $Grid->FUND_ID->EditValue ?>"<?= $Grid->FUND_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->FUND_ID->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_FUND_ID" class="form-group GOOD_GF_FUND_ID">
<span<?= $Grid->FUND_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->FUND_ID->getDisplayValue($Grid->FUND_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_FUND_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_FUND_ID" id="x<?= $Grid->RowIndex ?>_FUND_ID" value="<?= HtmlEncode($Grid->FUND_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_FUND_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_FUND_ID" id="o<?= $Grid->RowIndex ?>_FUND_ID" value="<?= HtmlEncode($Grid->FUND_ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->INVOICE_ID2->Visible) { // INVOICE_ID2 ?>
        <td data-name="INVOICE_ID2">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_GOOD_GF_INVOICE_ID2" class="form-group GOOD_GF_INVOICE_ID2">
<input type="<?= $Grid->INVOICE_ID2->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_INVOICE_ID2" name="x<?= $Grid->RowIndex ?>_INVOICE_ID2" id="x<?= $Grid->RowIndex ?>_INVOICE_ID2" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->INVOICE_ID2->getPlaceHolder()) ?>" value="<?= $Grid->INVOICE_ID2->EditValue ?>"<?= $Grid->INVOICE_ID2->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->INVOICE_ID2->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_INVOICE_ID2" class="form-group GOOD_GF_INVOICE_ID2">
<span<?= $Grid->INVOICE_ID2->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->INVOICE_ID2->getDisplayValue($Grid->INVOICE_ID2->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_INVOICE_ID2" data-hidden="1" name="x<?= $Grid->RowIndex ?>_INVOICE_ID2" id="x<?= $Grid->RowIndex ?>_INVOICE_ID2" value="<?= HtmlEncode($Grid->INVOICE_ID2->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_INVOICE_ID2" data-hidden="1" name="o<?= $Grid->RowIndex ?>_INVOICE_ID2" id="o<?= $Grid->RowIndex ?>_INVOICE_ID2" value="<?= HtmlEncode($Grid->INVOICE_ID2->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->MEASURE_ID3->Visible) { // MEASURE_ID3 ?>
        <td data-name="MEASURE_ID3">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_GOOD_GF_MEASURE_ID3" class="form-group GOOD_GF_MEASURE_ID3">
<input type="<?= $Grid->MEASURE_ID3->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_MEASURE_ID3" name="x<?= $Grid->RowIndex ?>_MEASURE_ID3" id="x<?= $Grid->RowIndex ?>_MEASURE_ID3" size="30" placeholder="<?= HtmlEncode($Grid->MEASURE_ID3->getPlaceHolder()) ?>" value="<?= $Grid->MEASURE_ID3->EditValue ?>"<?= $Grid->MEASURE_ID3->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->MEASURE_ID3->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_MEASURE_ID3" class="form-group GOOD_GF_MEASURE_ID3">
<span<?= $Grid->MEASURE_ID3->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->MEASURE_ID3->getDisplayValue($Grid->MEASURE_ID3->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_MEASURE_ID3" data-hidden="1" name="x<?= $Grid->RowIndex ?>_MEASURE_ID3" id="x<?= $Grid->RowIndex ?>_MEASURE_ID3" value="<?= HtmlEncode($Grid->MEASURE_ID3->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_MEASURE_ID3" data-hidden="1" name="o<?= $Grid->RowIndex ?>_MEASURE_ID3" id="o<?= $Grid->RowIndex ?>_MEASURE_ID3" value="<?= HtmlEncode($Grid->MEASURE_ID3->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->SIZE_KEMASAN->Visible) { // SIZE_KEMASAN ?>
        <td data-name="SIZE_KEMASAN">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_GOOD_GF_SIZE_KEMASAN" class="form-group GOOD_GF_SIZE_KEMASAN">
<input type="<?= $Grid->SIZE_KEMASAN->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_SIZE_KEMASAN" name="x<?= $Grid->RowIndex ?>_SIZE_KEMASAN" id="x<?= $Grid->RowIndex ?>_SIZE_KEMASAN" size="30" placeholder="<?= HtmlEncode($Grid->SIZE_KEMASAN->getPlaceHolder()) ?>" value="<?= $Grid->SIZE_KEMASAN->EditValue ?>"<?= $Grid->SIZE_KEMASAN->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->SIZE_KEMASAN->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_SIZE_KEMASAN" class="form-group GOOD_GF_SIZE_KEMASAN">
<span<?= $Grid->SIZE_KEMASAN->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->SIZE_KEMASAN->getDisplayValue($Grid->SIZE_KEMASAN->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_SIZE_KEMASAN" data-hidden="1" name="x<?= $Grid->RowIndex ?>_SIZE_KEMASAN" id="x<?= $Grid->RowIndex ?>_SIZE_KEMASAN" value="<?= HtmlEncode($Grid->SIZE_KEMASAN->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_SIZE_KEMASAN" data-hidden="1" name="o<?= $Grid->RowIndex ?>_SIZE_KEMASAN" id="o<?= $Grid->RowIndex ?>_SIZE_KEMASAN" value="<?= HtmlEncode($Grid->SIZE_KEMASAN->OldValue) ?>">
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
    <?php if ($Grid->MEASURE_ID2->Visible) { // MEASURE_ID2 ?>
        <td data-name="MEASURE_ID2">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_GOOD_GF_MEASURE_ID2" class="form-group GOOD_GF_MEASURE_ID2">
<input type="<?= $Grid->MEASURE_ID2->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_MEASURE_ID2" name="x<?= $Grid->RowIndex ?>_MEASURE_ID2" id="x<?= $Grid->RowIndex ?>_MEASURE_ID2" size="30" placeholder="<?= HtmlEncode($Grid->MEASURE_ID2->getPlaceHolder()) ?>" value="<?= $Grid->MEASURE_ID2->EditValue ?>"<?= $Grid->MEASURE_ID2->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->MEASURE_ID2->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_MEASURE_ID2" class="form-group GOOD_GF_MEASURE_ID2">
<span<?= $Grid->MEASURE_ID2->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->MEASURE_ID2->getDisplayValue($Grid->MEASURE_ID2->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_MEASURE_ID2" data-hidden="1" name="x<?= $Grid->RowIndex ?>_MEASURE_ID2" id="x<?= $Grid->RowIndex ?>_MEASURE_ID2" value="<?= HtmlEncode($Grid->MEASURE_ID2->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_MEASURE_ID2" data-hidden="1" name="o<?= $Grid->RowIndex ?>_MEASURE_ID2" id="o<?= $Grid->RowIndex ?>_MEASURE_ID2" value="<?= HtmlEncode($Grid->MEASURE_ID2->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->RETUR_ID->Visible) { // RETUR_ID ?>
        <td data-name="RETUR_ID">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_GOOD_GF_RETUR_ID" class="form-group GOOD_GF_RETUR_ID">
<input type="<?= $Grid->RETUR_ID->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_RETUR_ID" name="x<?= $Grid->RowIndex ?>_RETUR_ID" id="x<?= $Grid->RowIndex ?>_RETUR_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->RETUR_ID->getPlaceHolder()) ?>" value="<?= $Grid->RETUR_ID->EditValue ?>"<?= $Grid->RETUR_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->RETUR_ID->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_RETUR_ID" class="form-group GOOD_GF_RETUR_ID">
<span<?= $Grid->RETUR_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->RETUR_ID->getDisplayValue($Grid->RETUR_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_RETUR_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_RETUR_ID" id="x<?= $Grid->RowIndex ?>_RETUR_ID" value="<?= HtmlEncode($Grid->RETUR_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_RETUR_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_RETUR_ID" id="o<?= $Grid->RowIndex ?>_RETUR_ID" value="<?= HtmlEncode($Grid->RETUR_ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->SIZE_GOODS->Visible) { // SIZE_GOODS ?>
        <td data-name="SIZE_GOODS">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_GOOD_GF_SIZE_GOODS" class="form-group GOOD_GF_SIZE_GOODS">
<input type="<?= $Grid->SIZE_GOODS->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_SIZE_GOODS" name="x<?= $Grid->RowIndex ?>_SIZE_GOODS" id="x<?= $Grid->RowIndex ?>_SIZE_GOODS" size="30" placeholder="<?= HtmlEncode($Grid->SIZE_GOODS->getPlaceHolder()) ?>" value="<?= $Grid->SIZE_GOODS->EditValue ?>"<?= $Grid->SIZE_GOODS->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->SIZE_GOODS->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_SIZE_GOODS" class="form-group GOOD_GF_SIZE_GOODS">
<span<?= $Grid->SIZE_GOODS->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->SIZE_GOODS->getDisplayValue($Grid->SIZE_GOODS->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_SIZE_GOODS" data-hidden="1" name="x<?= $Grid->RowIndex ?>_SIZE_GOODS" id="x<?= $Grid->RowIndex ?>_SIZE_GOODS" value="<?= HtmlEncode($Grid->SIZE_GOODS->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_SIZE_GOODS" data-hidden="1" name="o<?= $Grid->RowIndex ?>_SIZE_GOODS" id="o<?= $Grid->RowIndex ?>_SIZE_GOODS" value="<?= HtmlEncode($Grid->SIZE_GOODS->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->MEASURE_DOSIS->Visible) { // MEASURE_DOSIS ?>
        <td data-name="MEASURE_DOSIS">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_GOOD_GF_MEASURE_DOSIS" class="form-group GOOD_GF_MEASURE_DOSIS">
<input type="<?= $Grid->MEASURE_DOSIS->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_MEASURE_DOSIS" name="x<?= $Grid->RowIndex ?>_MEASURE_DOSIS" id="x<?= $Grid->RowIndex ?>_MEASURE_DOSIS" size="30" placeholder="<?= HtmlEncode($Grid->MEASURE_DOSIS->getPlaceHolder()) ?>" value="<?= $Grid->MEASURE_DOSIS->EditValue ?>"<?= $Grid->MEASURE_DOSIS->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->MEASURE_DOSIS->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_MEASURE_DOSIS" class="form-group GOOD_GF_MEASURE_DOSIS">
<span<?= $Grid->MEASURE_DOSIS->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->MEASURE_DOSIS->getDisplayValue($Grid->MEASURE_DOSIS->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_MEASURE_DOSIS" data-hidden="1" name="x<?= $Grid->RowIndex ?>_MEASURE_DOSIS" id="x<?= $Grid->RowIndex ?>_MEASURE_DOSIS" value="<?= HtmlEncode($Grid->MEASURE_DOSIS->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_MEASURE_DOSIS" data-hidden="1" name="o<?= $Grid->RowIndex ?>_MEASURE_DOSIS" id="o<?= $Grid->RowIndex ?>_MEASURE_DOSIS" value="<?= HtmlEncode($Grid->MEASURE_DOSIS->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->ORDER_PRICE->Visible) { // ORDER_PRICE ?>
        <td data-name="ORDER_PRICE">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_GOOD_GF_ORDER_PRICE" class="form-group GOOD_GF_ORDER_PRICE">
<input type="<?= $Grid->ORDER_PRICE->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_ORDER_PRICE" name="x<?= $Grid->RowIndex ?>_ORDER_PRICE" id="x<?= $Grid->RowIndex ?>_ORDER_PRICE" size="30" placeholder="<?= HtmlEncode($Grid->ORDER_PRICE->getPlaceHolder()) ?>" value="<?= $Grid->ORDER_PRICE->EditValue ?>"<?= $Grid->ORDER_PRICE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ORDER_PRICE->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_ORDER_PRICE" class="form-group GOOD_GF_ORDER_PRICE">
<span<?= $Grid->ORDER_PRICE->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->ORDER_PRICE->getDisplayValue($Grid->ORDER_PRICE->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_ORDER_PRICE" data-hidden="1" name="x<?= $Grid->RowIndex ?>_ORDER_PRICE" id="x<?= $Grid->RowIndex ?>_ORDER_PRICE" value="<?= HtmlEncode($Grid->ORDER_PRICE->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_ORDER_PRICE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ORDER_PRICE" id="o<?= $Grid->RowIndex ?>_ORDER_PRICE" value="<?= HtmlEncode($Grid->ORDER_PRICE->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->STOCK_AVAILABLE->Visible) { // STOCK_AVAILABLE ?>
        <td data-name="STOCK_AVAILABLE">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_GOOD_GF_STOCK_AVAILABLE" class="form-group GOOD_GF_STOCK_AVAILABLE">
<input type="<?= $Grid->STOCK_AVAILABLE->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_STOCK_AVAILABLE" name="x<?= $Grid->RowIndex ?>_STOCK_AVAILABLE" id="x<?= $Grid->RowIndex ?>_STOCK_AVAILABLE" size="30" placeholder="<?= HtmlEncode($Grid->STOCK_AVAILABLE->getPlaceHolder()) ?>" value="<?= $Grid->STOCK_AVAILABLE->EditValue ?>"<?= $Grid->STOCK_AVAILABLE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->STOCK_AVAILABLE->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_STOCK_AVAILABLE" class="form-group GOOD_GF_STOCK_AVAILABLE">
<span<?= $Grid->STOCK_AVAILABLE->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->STOCK_AVAILABLE->getDisplayValue($Grid->STOCK_AVAILABLE->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_STOCK_AVAILABLE" data-hidden="1" name="x<?= $Grid->RowIndex ?>_STOCK_AVAILABLE" id="x<?= $Grid->RowIndex ?>_STOCK_AVAILABLE" value="<?= HtmlEncode($Grid->STOCK_AVAILABLE->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_STOCK_AVAILABLE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_STOCK_AVAILABLE" id="o<?= $Grid->RowIndex ?>_STOCK_AVAILABLE" value="<?= HtmlEncode($Grid->STOCK_AVAILABLE->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->STATUS_PASIEN_ID->Visible) { // STATUS_PASIEN_ID ?>
        <td data-name="STATUS_PASIEN_ID">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_GOOD_GF_STATUS_PASIEN_ID" class="form-group GOOD_GF_STATUS_PASIEN_ID">
<input type="<?= $Grid->STATUS_PASIEN_ID->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_STATUS_PASIEN_ID" name="x<?= $Grid->RowIndex ?>_STATUS_PASIEN_ID" id="x<?= $Grid->RowIndex ?>_STATUS_PASIEN_ID" size="30" placeholder="<?= HtmlEncode($Grid->STATUS_PASIEN_ID->getPlaceHolder()) ?>" value="<?= $Grid->STATUS_PASIEN_ID->EditValue ?>"<?= $Grid->STATUS_PASIEN_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->STATUS_PASIEN_ID->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_STATUS_PASIEN_ID" class="form-group GOOD_GF_STATUS_PASIEN_ID">
<span<?= $Grid->STATUS_PASIEN_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->STATUS_PASIEN_ID->getDisplayValue($Grid->STATUS_PASIEN_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_STATUS_PASIEN_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_STATUS_PASIEN_ID" id="x<?= $Grid->RowIndex ?>_STATUS_PASIEN_ID" value="<?= HtmlEncode($Grid->STATUS_PASIEN_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_STATUS_PASIEN_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_STATUS_PASIEN_ID" id="o<?= $Grid->RowIndex ?>_STATUS_PASIEN_ID" value="<?= HtmlEncode($Grid->STATUS_PASIEN_ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->MONTH_ID->Visible) { // MONTH_ID ?>
        <td data-name="MONTH_ID">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_GOOD_GF_MONTH_ID" class="form-group GOOD_GF_MONTH_ID">
<input type="<?= $Grid->MONTH_ID->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_MONTH_ID" name="x<?= $Grid->RowIndex ?>_MONTH_ID" id="x<?= $Grid->RowIndex ?>_MONTH_ID" size="30" placeholder="<?= HtmlEncode($Grid->MONTH_ID->getPlaceHolder()) ?>" value="<?= $Grid->MONTH_ID->EditValue ?>"<?= $Grid->MONTH_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->MONTH_ID->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_MONTH_ID" class="form-group GOOD_GF_MONTH_ID">
<span<?= $Grid->MONTH_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->MONTH_ID->getDisplayValue($Grid->MONTH_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_MONTH_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_MONTH_ID" id="x<?= $Grid->RowIndex ?>_MONTH_ID" value="<?= HtmlEncode($Grid->MONTH_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_MONTH_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_MONTH_ID" id="o<?= $Grid->RowIndex ?>_MONTH_ID" value="<?= HtmlEncode($Grid->MONTH_ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->YEAR_ID->Visible) { // YEAR_ID ?>
        <td data-name="YEAR_ID">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_GOOD_GF_YEAR_ID" class="form-group GOOD_GF_YEAR_ID">
<input type="<?= $Grid->YEAR_ID->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_YEAR_ID" name="x<?= $Grid->RowIndex ?>_YEAR_ID" id="x<?= $Grid->RowIndex ?>_YEAR_ID" size="30" placeholder="<?= HtmlEncode($Grid->YEAR_ID->getPlaceHolder()) ?>" value="<?= $Grid->YEAR_ID->EditValue ?>"<?= $Grid->YEAR_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->YEAR_ID->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_YEAR_ID" class="form-group GOOD_GF_YEAR_ID">
<span<?= $Grid->YEAR_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->YEAR_ID->getDisplayValue($Grid->YEAR_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_YEAR_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_YEAR_ID" id="x<?= $Grid->RowIndex ?>_YEAR_ID" value="<?= HtmlEncode($Grid->YEAR_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_YEAR_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_YEAR_ID" id="o<?= $Grid->RowIndex ?>_YEAR_ID" value="<?= HtmlEncode($Grid->YEAR_ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->CORRECTION_DOC->Visible) { // CORRECTION_DOC ?>
        <td data-name="CORRECTION_DOC">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_GOOD_GF_CORRECTION_DOC" class="form-group GOOD_GF_CORRECTION_DOC">
<input type="<?= $Grid->CORRECTION_DOC->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_CORRECTION_DOC" name="x<?= $Grid->RowIndex ?>_CORRECTION_DOC" id="x<?= $Grid->RowIndex ?>_CORRECTION_DOC" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->CORRECTION_DOC->getPlaceHolder()) ?>" value="<?= $Grid->CORRECTION_DOC->EditValue ?>"<?= $Grid->CORRECTION_DOC->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->CORRECTION_DOC->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_CORRECTION_DOC" class="form-group GOOD_GF_CORRECTION_DOC">
<span<?= $Grid->CORRECTION_DOC->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->CORRECTION_DOC->getDisplayValue($Grid->CORRECTION_DOC->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_CORRECTION_DOC" data-hidden="1" name="x<?= $Grid->RowIndex ?>_CORRECTION_DOC" id="x<?= $Grid->RowIndex ?>_CORRECTION_DOC" value="<?= HtmlEncode($Grid->CORRECTION_DOC->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_CORRECTION_DOC" data-hidden="1" name="o<?= $Grid->RowIndex ?>_CORRECTION_DOC" id="o<?= $Grid->RowIndex ?>_CORRECTION_DOC" value="<?= HtmlEncode($Grid->CORRECTION_DOC->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->CORRECTIONS->Visible) { // CORRECTIONS ?>
        <td data-name="CORRECTIONS">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_GOOD_GF_CORRECTIONS" class="form-group GOOD_GF_CORRECTIONS">
<input type="<?= $Grid->CORRECTIONS->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_CORRECTIONS" name="x<?= $Grid->RowIndex ?>_CORRECTIONS" id="x<?= $Grid->RowIndex ?>_CORRECTIONS" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->CORRECTIONS->getPlaceHolder()) ?>" value="<?= $Grid->CORRECTIONS->EditValue ?>"<?= $Grid->CORRECTIONS->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->CORRECTIONS->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_CORRECTIONS" class="form-group GOOD_GF_CORRECTIONS">
<span<?= $Grid->CORRECTIONS->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->CORRECTIONS->getDisplayValue($Grid->CORRECTIONS->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_CORRECTIONS" data-hidden="1" name="x<?= $Grid->RowIndex ?>_CORRECTIONS" id="x<?= $Grid->RowIndex ?>_CORRECTIONS" value="<?= HtmlEncode($Grid->CORRECTIONS->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_CORRECTIONS" data-hidden="1" name="o<?= $Grid->RowIndex ?>_CORRECTIONS" id="o<?= $Grid->RowIndex ?>_CORRECTIONS" value="<?= HtmlEncode($Grid->CORRECTIONS->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->CORRECTION_DATE->Visible) { // CORRECTION_DATE ?>
        <td data-name="CORRECTION_DATE">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_GOOD_GF_CORRECTION_DATE" class="form-group GOOD_GF_CORRECTION_DATE">
<input type="<?= $Grid->CORRECTION_DATE->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_CORRECTION_DATE" name="x<?= $Grid->RowIndex ?>_CORRECTION_DATE" id="x<?= $Grid->RowIndex ?>_CORRECTION_DATE" placeholder="<?= HtmlEncode($Grid->CORRECTION_DATE->getPlaceHolder()) ?>" value="<?= $Grid->CORRECTION_DATE->EditValue ?>"<?= $Grid->CORRECTION_DATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->CORRECTION_DATE->getErrorMessage() ?></div>
<?php if (!$Grid->CORRECTION_DATE->ReadOnly && !$Grid->CORRECTION_DATE->Disabled && !isset($Grid->CORRECTION_DATE->EditAttrs["readonly"]) && !isset($Grid->CORRECTION_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fGOOD_GFgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fGOOD_GFgrid", "x<?= $Grid->RowIndex ?>_CORRECTION_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_CORRECTION_DATE" class="form-group GOOD_GF_CORRECTION_DATE">
<span<?= $Grid->CORRECTION_DATE->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->CORRECTION_DATE->getDisplayValue($Grid->CORRECTION_DATE->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_CORRECTION_DATE" data-hidden="1" name="x<?= $Grid->RowIndex ?>_CORRECTION_DATE" id="x<?= $Grid->RowIndex ?>_CORRECTION_DATE" value="<?= HtmlEncode($Grid->CORRECTION_DATE->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_CORRECTION_DATE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_CORRECTION_DATE" id="o<?= $Grid->RowIndex ?>_CORRECTION_DATE" value="<?= HtmlEncode($Grid->CORRECTION_DATE->OldValue) ?>">
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
    <?php if ($Grid->ORDER_ID->Visible) { // ORDER_ID ?>
        <td data-name="ORDER_ID">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_GOOD_GF_ORDER_ID" class="form-group GOOD_GF_ORDER_ID">
<input type="<?= $Grid->ORDER_ID->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_ORDER_ID" name="x<?= $Grid->RowIndex ?>_ORDER_ID" id="x<?= $Grid->RowIndex ?>_ORDER_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->ORDER_ID->getPlaceHolder()) ?>" value="<?= $Grid->ORDER_ID->EditValue ?>"<?= $Grid->ORDER_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ORDER_ID->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_ORDER_ID" class="form-group GOOD_GF_ORDER_ID">
<span<?= $Grid->ORDER_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->ORDER_ID->getDisplayValue($Grid->ORDER_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_ORDER_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_ORDER_ID" id="x<?= $Grid->RowIndex ?>_ORDER_ID" value="<?= HtmlEncode($Grid->ORDER_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_ORDER_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ORDER_ID" id="o<?= $Grid->RowIndex ?>_ORDER_ID" value="<?= HtmlEncode($Grid->ORDER_ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->ISCETAK->Visible) { // ISCETAK ?>
        <td data-name="ISCETAK">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_GOOD_GF_ISCETAK" class="form-group GOOD_GF_ISCETAK">
<input type="<?= $Grid->ISCETAK->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_ISCETAK" name="x<?= $Grid->RowIndex ?>_ISCETAK" id="x<?= $Grid->RowIndex ?>_ISCETAK" size="30" maxlength="1" placeholder="<?= HtmlEncode($Grid->ISCETAK->getPlaceHolder()) ?>" value="<?= $Grid->ISCETAK->EditValue ?>"<?= $Grid->ISCETAK->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ISCETAK->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_ISCETAK" class="form-group GOOD_GF_ISCETAK">
<span<?= $Grid->ISCETAK->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->ISCETAK->getDisplayValue($Grid->ISCETAK->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_ISCETAK" data-hidden="1" name="x<?= $Grid->RowIndex ?>_ISCETAK" id="x<?= $Grid->RowIndex ?>_ISCETAK" value="<?= HtmlEncode($Grid->ISCETAK->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_ISCETAK" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ISCETAK" id="o<?= $Grid->RowIndex ?>_ISCETAK" value="<?= HtmlEncode($Grid->ISCETAK->OldValue) ?>">
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
    <?php if ($Grid->PRINTQ->Visible) { // PRINTQ ?>
        <td data-name="PRINTQ">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_GOOD_GF_PRINTQ" class="form-group GOOD_GF_PRINTQ">
<input type="<?= $Grid->PRINTQ->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_PRINTQ" name="x<?= $Grid->RowIndex ?>_PRINTQ" id="x<?= $Grid->RowIndex ?>_PRINTQ" size="30" placeholder="<?= HtmlEncode($Grid->PRINTQ->getPlaceHolder()) ?>" value="<?= $Grid->PRINTQ->EditValue ?>"<?= $Grid->PRINTQ->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->PRINTQ->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_PRINTQ" class="form-group GOOD_GF_PRINTQ">
<span<?= $Grid->PRINTQ->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->PRINTQ->getDisplayValue($Grid->PRINTQ->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_PRINTQ" data-hidden="1" name="x<?= $Grid->RowIndex ?>_PRINTQ" id="x<?= $Grid->RowIndex ?>_PRINTQ" value="<?= HtmlEncode($Grid->PRINTQ->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_PRINTQ" data-hidden="1" name="o<?= $Grid->RowIndex ?>_PRINTQ" id="o<?= $Grid->RowIndex ?>_PRINTQ" value="<?= HtmlEncode($Grid->PRINTQ->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->avgprice->Visible) { // avgprice ?>
        <td data-name="avgprice">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_GOOD_GF_avgprice" class="form-group GOOD_GF_avgprice">
<input type="<?= $Grid->avgprice->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_avgprice" name="x<?= $Grid->RowIndex ?>_avgprice" id="x<?= $Grid->RowIndex ?>_avgprice" size="30" placeholder="<?= HtmlEncode($Grid->avgprice->getPlaceHolder()) ?>" value="<?= $Grid->avgprice->EditValue ?>"<?= $Grid->avgprice->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->avgprice->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_avgprice" class="form-group GOOD_GF_avgprice">
<span<?= $Grid->avgprice->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->avgprice->getDisplayValue($Grid->avgprice->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_avgprice" data-hidden="1" name="x<?= $Grid->RowIndex ?>_avgprice" id="x<?= $Grid->RowIndex ?>_avgprice" value="<?= HtmlEncode($Grid->avgprice->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_avgprice" data-hidden="1" name="o<?= $Grid->RowIndex ?>_avgprice" id="o<?= $Grid->RowIndex ?>_avgprice" value="<?= HtmlEncode($Grid->avgprice->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->idx->Visible) { // idx ?>
        <td data-name="idx">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_GOOD_GF_idx" class="form-group GOOD_GF_idx"></span>
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_idx" class="form-group GOOD_GF_idx">
<span<?= $Grid->idx->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idx->getDisplayValue($Grid->idx->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_idx" data-hidden="1" name="x<?= $Grid->RowIndex ?>_idx" id="x<?= $Grid->RowIndex ?>_idx" value="<?= HtmlEncode($Grid->idx->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_idx" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idx" id="o<?= $Grid->RowIndex ?>_idx" value="<?= HtmlEncode($Grid->idx->OldValue) ?>">
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
