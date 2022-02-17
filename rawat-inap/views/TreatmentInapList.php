<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

// Page object
$TreatmentInapList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fTREATMENT_INAPlist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fTREATMENT_INAPlist = currentForm = new ew.Form("fTREATMENT_INAPlist", "list");
    fTREATMENT_INAPlist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "TREATMENT_INAP")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.TREATMENT_INAP)
        ew.vars.tables.TREATMENT_INAP = currentTable;
    fTREATMENT_INAPlist.addFields([
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
        var f = fTREATMENT_INAPlist,
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
    fTREATMENT_INAPlist.validate = function () {
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
        if (gridinsert && addcnt == 0) { // No row added
            ew.alert(ew.language.phrase("NoAddRecord"));
            return false;
        }
        return true;
    }

    // Check empty row
    fTREATMENT_INAPlist.emptyRow = function (rowIndex) {
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
    fTREATMENT_INAPlist.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fTREATMENT_INAPlist.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fTREATMENT_INAPlist.lists.NO_REGISTRATION = <?= $Page->NO_REGISTRATION->toClientList($Page) ?>;
    fTREATMENT_INAPlist.lists.TARIF_ID = <?= $Page->TARIF_ID->toClientList($Page) ?>;
    fTREATMENT_INAPlist.lists.CLINIC_ID = <?= $Page->CLINIC_ID->toClientList($Page) ?>;
    loadjs.done("fTREATMENT_INAPlist");
});
var fTREATMENT_INAPlistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    fTREATMENT_INAPlistsrch = currentSearchForm = new ew.Form("fTREATMENT_INAPlistsrch");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "TREATMENT_INAP")) ?>,
        fields = currentTable.fields;
    fTREATMENT_INAPlistsrch.addFields([
        ["NO_REGISTRATION", [], fields.NO_REGISTRATION.isInvalid],
        ["VISIT_ID", [], fields.VISIT_ID.isInvalid],
        ["TARIF_ID", [], fields.TARIF_ID.isInvalid],
        ["CLINIC_ID", [], fields.CLINIC_ID.isInvalid],
        ["TREATMENT", [], fields.TREATMENT.isInvalid],
        ["TREAT_DATE", [ew.Validators.datetime(11)], fields.TREAT_DATE.isInvalid],
        ["QUANTITY", [], fields.QUANTITY.isInvalid],
        ["TRANS_ID", [], fields.TRANS_ID.isInvalid],
        ["ID", [], fields.ID.isInvalid],
        ["AMOUNT", [], fields.AMOUNT.isInvalid],
        ["POKOK_JUAL", [], fields.POKOK_JUAL.isInvalid],
        ["PPN", [], fields.PPN.isInvalid],
        ["SUBSIDI", [], fields.SUBSIDI.isInvalid],
        ["PRINT_DATE", [], fields.PRINT_DATE.isInvalid],
        ["ISCETAK", [], fields.ISCETAK.isInvalid],
        ["NOTA_NO", [], fields.NOTA_NO.isInvalid],
        ["KUITANSI_ID", [], fields.KUITANSI_ID.isInvalid],
        ["amount_paid", [], fields.amount_paid.isInvalid],
        ["sell_price", [], fields.sell_price.isInvalid],
        ["diskon", [], fields.diskon.isInvalid],
        ["TAGIHAN", [], fields.TAGIHAN.isInvalid],
        ["CLINIC_TYPE", [], fields.CLINIC_TYPE.isInvalid],
        ["ID_1", [], fields.ID_1.isInvalid],
        ["ORG_UNIT_CODE", [], fields.ORG_UNIT_CODE.isInvalid],
        ["BILL_ID_1", [], fields.BILL_ID_1.isInvalid],
        ["NO_REGISTRATION_1", [], fields.NO_REGISTRATION_1.isInvalid],
        ["VISIT_ID_1", [], fields.VISIT_ID_1.isInvalid],
        ["TARIF_ID_1", [], fields.TARIF_ID_1.isInvalid],
        ["CLASS_ID_1", [], fields.CLASS_ID_1.isInvalid],
        ["CLINIC_ID_1", [], fields.CLINIC_ID_1.isInvalid],
        ["CLINIC_ID_FROM_1", [], fields.CLINIC_ID_FROM_1.isInvalid],
        ["TREATMENT_1", [], fields.TREATMENT_1.isInvalid],
        ["TREAT_DATE_1", [], fields.TREAT_DATE_1.isInvalid],
        ["QUANTITY_1", [], fields.QUANTITY_1.isInvalid],
        ["MEASURE_ID", [], fields.MEASURE_ID.isInvalid],
        ["MEASURE_ID_1", [], fields.MEASURE_ID_1.isInvalid],
        ["TRANS_ID_1", [], fields.TRANS_ID_1.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        fTREATMENT_INAPlistsrch.setInvalid();
    });

    // Validate form
    fTREATMENT_INAPlistsrch.validate = function () {
        if (!this.validateRequired)
            return true; // Ignore validation
        var fobj = this.getForm(),
            $fobj = $(fobj),
            rowIndex = "";
        $fobj.data("rowindex", rowIndex);

        // Validate fields
        if (!this.validateFields(rowIndex))
            return false;

        // Call Form_CustomValidate event
        if (!this.customValidate(fobj)) {
            this.focus();
            return false;
        }
        return true;
    }

    // Form_CustomValidate
    fTREATMENT_INAPlistsrch.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fTREATMENT_INAPlistsrch.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fTREATMENT_INAPlistsrch.lists.CLINIC_ID = <?= $Page->CLINIC_ID->toClientList($Page) ?>;

    // Filters
    fTREATMENT_INAPlistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fTREATMENT_INAPlistsrch");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($Page->TotalRecords > 0 && $Page->ExportOptions->visible()) { ?>
<?php $Page->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($Page->ImportOptions->visible()) { ?>
<?php $Page->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($Page->SearchOptions->visible()) { ?>
<?php $Page->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($Page->FilterOptions->visible()) { ?>
<?php $Page->FilterOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php if (!$Page->isExport() || Config("EXPORT_MASTER_RECORD") && $Page->isExport("print")) { ?>
<?php
if ($Page->DbMasterFilter != "" && $Page->getCurrentMasterTable() == "PASIEN_VISITATION") {
    if ($Page->MasterRecordExists) {
        include_once "views/PasienVisitationMaster.php";
    }
}
?>
<?php } ?>
<?php
$Page->renderOtherOptions();
?>
<?php if ($Security->canSearch()) { ?>
<?php if (!$Page->isExport() && !$Page->CurrentAction) { ?>
<form name="fTREATMENT_INAPlistsrch" id="fTREATMENT_INAPlistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fTREATMENT_INAPlistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="TREATMENT_INAP">
    <div class="ew-extended-search">
<?php
// Render search row
$Page->RowType = ROWTYPE_SEARCH;
$Page->resetAttributes();
$Page->renderRow();
?>
<?php if ($Page->CLINIC_ID->Visible) { // CLINIC_ID ?>
    <?php
        $Page->SearchColumnCount++;
        if (($Page->SearchColumnCount - 1) % $Page->SearchFieldsPerRow == 0) {
            $Page->SearchRowCount++;
    ?>
<div id="xsr_<?= $Page->SearchRowCount ?>" class="ew-row d-sm-flex">
    <?php
        }
     ?>
    <div id="xsc_CLINIC_ID" class="ew-cell form-group">
        <label for="x_CLINIC_ID" class="ew-search-caption ew-label"><?= $Page->CLINIC_ID->caption() ?></label>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_CLINIC_ID" id="z_CLINIC_ID" value="LIKE">
</span>
        <span id="el_TREATMENT_INAP_CLINIC_ID" class="ew-search-field">
    <select
        id="x_CLINIC_ID"
        name="x_CLINIC_ID"
        class="form-control ew-select<?= $Page->CLINIC_ID->isInvalidClass() ?>"
        data-select2-id="TREATMENT_INAP_x_CLINIC_ID"
        data-table="TREATMENT_INAP"
        data-field="x_CLINIC_ID"
        data-value-separator="<?= $Page->CLINIC_ID->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->CLINIC_ID->getPlaceHolder()) ?>"
        <?= $Page->CLINIC_ID->editAttributes() ?>>
        <?= $Page->CLINIC_ID->selectOptionListHtml("x_CLINIC_ID") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->CLINIC_ID->getErrorMessage(false) ?></div>
<?= $Page->CLINIC_ID->Lookup->getParamTag($Page, "p_x_CLINIC_ID") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='TREATMENT_INAP_x_CLINIC_ID']"),
        options = { name: "x_CLINIC_ID", selectId: "TREATMENT_INAP_x_CLINIC_ID", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.TREATMENT_INAP.fields.CLINIC_ID.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
    </div>
    <?php if ($Page->SearchColumnCount % $Page->SearchFieldsPerRow == 0) { ?>
</div>
    <?php } ?>
<?php } ?>
<?php if ($Page->TREAT_DATE->Visible) { // TREAT_DATE ?>
    <?php
        $Page->SearchColumnCount++;
        if (($Page->SearchColumnCount - 1) % $Page->SearchFieldsPerRow == 0) {
            $Page->SearchRowCount++;
    ?>
<div id="xsr_<?= $Page->SearchRowCount ?>" class="ew-row d-sm-flex">
    <?php
        }
     ?>
    <div id="xsc_TREAT_DATE" class="ew-cell form-group">
        <label for="x_TREAT_DATE" class="ew-search-caption ew-label"><?= $Page->TREAT_DATE->caption() ?></label>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_TREAT_DATE" id="z_TREAT_DATE" value="=">
</span>
        <span id="el_TREATMENT_INAP_TREAT_DATE" class="ew-search-field">
<input type="<?= $Page->TREAT_DATE->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_TREAT_DATE" data-format="11" name="x_TREAT_DATE" id="x_TREAT_DATE" placeholder="<?= HtmlEncode($Page->TREAT_DATE->getPlaceHolder()) ?>" value="<?= $Page->TREAT_DATE->EditValue ?>"<?= $Page->TREAT_DATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->TREAT_DATE->getErrorMessage(false) ?></div>
<?php if (!$Page->TREAT_DATE->ReadOnly && !$Page->TREAT_DATE->Disabled && !isset($Page->TREAT_DATE->EditAttrs["readonly"]) && !isset($Page->TREAT_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fTREATMENT_INAPlistsrch", "datetimepicker"], function() {
    ew.createDateTimePicker("fTREATMENT_INAPlistsrch", "x_TREAT_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":11});
});
</script>
<?php } ?>
</span>
    </div>
    <?php if ($Page->SearchColumnCount % $Page->SearchFieldsPerRow == 0) { ?>
</div>
    <?php } ?>
<?php } ?>
    <?php if ($Page->SearchColumnCount % $Page->SearchFieldsPerRow > 0) { ?>
</div>
    <?php } ?>
<div id="xsr_<?= $Page->SearchRowCount + 1 ?>" class="ew-row d-sm-flex">
    <div class="ew-quick-search input-group">
        <input type="text" name="<?= Config("TABLE_BASIC_SEARCH") ?>" id="<?= Config("TABLE_BASIC_SEARCH") ?>" class="form-control" value="<?= HtmlEncode($Page->BasicSearch->getKeyword()) ?>" placeholder="<?= HtmlEncode($Language->phrase("Search")) ?>">
        <input type="hidden" name="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" id="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" value="<?= HtmlEncode($Page->BasicSearch->getType()) ?>">
        <div class="input-group-append">
            <button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?= $Language->phrase("SearchBtn") ?></button>
            <button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false"><span id="searchtype"><?= $Page->BasicSearch->getTypeNameShort() ?></span></button>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item<?php if ($Page->BasicSearch->getType() == "") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this);"><?= $Language->phrase("QuickSearchAuto") ?></a>
                <a class="dropdown-item<?php if ($Page->BasicSearch->getType() == "=") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, '=');"><?= $Language->phrase("QuickSearchExact") ?></a>
                <a class="dropdown-item<?php if ($Page->BasicSearch->getType() == "AND") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'AND');"><?= $Language->phrase("QuickSearchAll") ?></a>
                <a class="dropdown-item<?php if ($Page->BasicSearch->getType() == "OR") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'OR');"><?= $Language->phrase("QuickSearchAny") ?></a>
            </div>
        </div>
    </div>
</div>
    </div><!-- /.ew-extended-search -->
</div><!-- /.ew-search-panel -->
</form>
<?php } ?>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<?php if ($Page->TotalRecords > 0 || $Page->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> TREATMENT_INAP">
<?php if (!$Page->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if (!$Page->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?= CurrentPageUrl(false) ?>">
<?= $Page->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="fTREATMENT_INAPlist" id="fTREATMENT_INAPlist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="TREATMENT_INAP">
<?php if ($Page->getCurrentMasterTable() == "PASIEN_VISITATION" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="PASIEN_VISITATION">
<input type="hidden" name="fk_VISIT_ID" value="<?= HtmlEncode($Page->VISIT_ID->getSessionValue()) ?>">
<input type="hidden" name="fk_NO_REGISTRATION" value="<?= HtmlEncode($Page->NO_REGISTRATION->getSessionValue()) ?>">
<input type="hidden" name="fk_TRANS_ID" value="<?= HtmlEncode($Page->TRANS_ID->getSessionValue()) ?>">
<input type="hidden" name="fk_DIANTAR_OLEH" value="<?= HtmlEncode($Page->THENAME->getSessionValue()) ?>">
<input type="hidden" name="fk_VISITOR_ADDRESS" value="<?= HtmlEncode($Page->THEADDRESS->getSessionValue()) ?>">
<?php } ?>
<div id="gmp_TREATMENT_INAP" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_TREATMENT_INAPlist" class="table ew-table"><!-- .ew-table -->
<thead>
    <tr class="ew-table-header">
<?php
// Header row
$Page->RowType = ROWTYPE_HEADER;

// Render list options
$Page->renderListOptions();

// Render list options (header, left)
$Page->ListOptions->render("header", "left");
?>
<?php if ($Page->NO_REGISTRATION->Visible) { // NO_REGISTRATION ?>
        <th data-name="NO_REGISTRATION" class="<?= $Page->NO_REGISTRATION->headerCellClass() ?>"><div id="elh_TREATMENT_INAP_NO_REGISTRATION" class="TREATMENT_INAP_NO_REGISTRATION"><?= $Page->renderSort($Page->NO_REGISTRATION) ?></div></th>
<?php } ?>
<?php if ($Page->VISIT_ID->Visible) { // VISIT_ID ?>
        <th data-name="VISIT_ID" class="<?= $Page->VISIT_ID->headerCellClass() ?>"><div id="elh_TREATMENT_INAP_VISIT_ID" class="TREATMENT_INAP_VISIT_ID"><?= $Page->renderSort($Page->VISIT_ID) ?></div></th>
<?php } ?>
<?php if ($Page->TARIF_ID->Visible) { // TARIF_ID ?>
        <th data-name="TARIF_ID" class="<?= $Page->TARIF_ID->headerCellClass() ?>"><div id="elh_TREATMENT_INAP_TARIF_ID" class="TREATMENT_INAP_TARIF_ID"><?= $Page->renderSort($Page->TARIF_ID) ?></div></th>
<?php } ?>
<?php if ($Page->CLINIC_ID->Visible) { // CLINIC_ID ?>
        <th data-name="CLINIC_ID" class="<?= $Page->CLINIC_ID->headerCellClass() ?>"><div id="elh_TREATMENT_INAP_CLINIC_ID" class="TREATMENT_INAP_CLINIC_ID"><?= $Page->renderSort($Page->CLINIC_ID) ?></div></th>
<?php } ?>
<?php if ($Page->TREATMENT->Visible) { // TREATMENT ?>
        <th data-name="TREATMENT" class="<?= $Page->TREATMENT->headerCellClass() ?>"><div id="elh_TREATMENT_INAP_TREATMENT" class="TREATMENT_INAP_TREATMENT"><?= $Page->renderSort($Page->TREATMENT) ?></div></th>
<?php } ?>
<?php if ($Page->TREAT_DATE->Visible) { // TREAT_DATE ?>
        <th data-name="TREAT_DATE" class="<?= $Page->TREAT_DATE->headerCellClass() ?>"><div id="elh_TREATMENT_INAP_TREAT_DATE" class="TREATMENT_INAP_TREAT_DATE"><?= $Page->renderSort($Page->TREAT_DATE) ?></div></th>
<?php } ?>
<?php if ($Page->QUANTITY->Visible) { // QUANTITY ?>
        <th data-name="QUANTITY" class="<?= $Page->QUANTITY->headerCellClass() ?>"><div id="elh_TREATMENT_INAP_QUANTITY" class="TREATMENT_INAP_QUANTITY"><?= $Page->renderSort($Page->QUANTITY) ?></div></th>
<?php } ?>
<?php if ($Page->TRANS_ID->Visible) { // TRANS_ID ?>
        <th data-name="TRANS_ID" class="<?= $Page->TRANS_ID->headerCellClass() ?>"><div id="elh_TREATMENT_INAP_TRANS_ID" class="TREATMENT_INAP_TRANS_ID"><?= $Page->renderSort($Page->TRANS_ID) ?></div></th>
<?php } ?>
<?php if ($Page->ID->Visible) { // ID ?>
        <th data-name="ID" class="<?= $Page->ID->headerCellClass() ?>"><div id="elh_TREATMENT_INAP_ID" class="TREATMENT_INAP_ID"><?= $Page->renderSort($Page->ID) ?></div></th>
<?php } ?>
<?php if ($Page->AMOUNT->Visible) { // AMOUNT ?>
        <th data-name="AMOUNT" class="<?= $Page->AMOUNT->headerCellClass() ?>"><div id="elh_TREATMENT_INAP_AMOUNT" class="TREATMENT_INAP_AMOUNT"><?= $Page->renderSort($Page->AMOUNT) ?></div></th>
<?php } ?>
<?php if ($Page->POKOK_JUAL->Visible) { // POKOK_JUAL ?>
        <th data-name="POKOK_JUAL" class="<?= $Page->POKOK_JUAL->headerCellClass() ?>"><div id="elh_TREATMENT_INAP_POKOK_JUAL" class="TREATMENT_INAP_POKOK_JUAL"><?= $Page->renderSort($Page->POKOK_JUAL) ?></div></th>
<?php } ?>
<?php if ($Page->PPN->Visible) { // PPN ?>
        <th data-name="PPN" class="<?= $Page->PPN->headerCellClass() ?>"><div id="elh_TREATMENT_INAP_PPN" class="TREATMENT_INAP_PPN"><?= $Page->renderSort($Page->PPN) ?></div></th>
<?php } ?>
<?php if ($Page->SUBSIDI->Visible) { // SUBSIDI ?>
        <th data-name="SUBSIDI" class="<?= $Page->SUBSIDI->headerCellClass() ?>"><div id="elh_TREATMENT_INAP_SUBSIDI" class="TREATMENT_INAP_SUBSIDI"><?= $Page->renderSort($Page->SUBSIDI) ?></div></th>
<?php } ?>
<?php if ($Page->PRINT_DATE->Visible) { // PRINT_DATE ?>
        <th data-name="PRINT_DATE" class="<?= $Page->PRINT_DATE->headerCellClass() ?>"><div id="elh_TREATMENT_INAP_PRINT_DATE" class="TREATMENT_INAP_PRINT_DATE"><?= $Page->renderSort($Page->PRINT_DATE) ?></div></th>
<?php } ?>
<?php if ($Page->ISCETAK->Visible) { // ISCETAK ?>
        <th data-name="ISCETAK" class="<?= $Page->ISCETAK->headerCellClass() ?>"><div id="elh_TREATMENT_INAP_ISCETAK" class="TREATMENT_INAP_ISCETAK"><?= $Page->renderSort($Page->ISCETAK) ?></div></th>
<?php } ?>
<?php if ($Page->NOTA_NO->Visible) { // NOTA_NO ?>
        <th data-name="NOTA_NO" class="<?= $Page->NOTA_NO->headerCellClass() ?>"><div id="elh_TREATMENT_INAP_NOTA_NO" class="TREATMENT_INAP_NOTA_NO"><?= $Page->renderSort($Page->NOTA_NO) ?></div></th>
<?php } ?>
<?php if ($Page->KUITANSI_ID->Visible) { // KUITANSI_ID ?>
        <th data-name="KUITANSI_ID" class="<?= $Page->KUITANSI_ID->headerCellClass() ?>"><div id="elh_TREATMENT_INAP_KUITANSI_ID" class="TREATMENT_INAP_KUITANSI_ID"><?= $Page->renderSort($Page->KUITANSI_ID) ?></div></th>
<?php } ?>
<?php if ($Page->amount_paid->Visible) { // amount_paid ?>
        <th data-name="amount_paid" class="<?= $Page->amount_paid->headerCellClass() ?>"><div id="elh_TREATMENT_INAP_amount_paid" class="TREATMENT_INAP_amount_paid"><?= $Page->renderSort($Page->amount_paid) ?></div></th>
<?php } ?>
<?php if ($Page->sell_price->Visible) { // sell_price ?>
        <th data-name="sell_price" class="<?= $Page->sell_price->headerCellClass() ?>"><div id="elh_TREATMENT_INAP_sell_price" class="TREATMENT_INAP_sell_price"><?= $Page->renderSort($Page->sell_price) ?></div></th>
<?php } ?>
<?php if ($Page->diskon->Visible) { // diskon ?>
        <th data-name="diskon" class="<?= $Page->diskon->headerCellClass() ?>"><div id="elh_TREATMENT_INAP_diskon" class="TREATMENT_INAP_diskon"><?= $Page->renderSort($Page->diskon) ?></div></th>
<?php } ?>
<?php if ($Page->TAGIHAN->Visible) { // TAGIHAN ?>
        <th data-name="TAGIHAN" class="<?= $Page->TAGIHAN->headerCellClass() ?>"><div id="elh_TREATMENT_INAP_TAGIHAN" class="TREATMENT_INAP_TAGIHAN"><?= $Page->renderSort($Page->TAGIHAN) ?></div></th>
<?php } ?>
<?php if ($Page->CLINIC_TYPE->Visible) { // CLINIC_TYPE ?>
        <th data-name="CLINIC_TYPE" class="<?= $Page->CLINIC_TYPE->headerCellClass() ?>"><div id="elh_TREATMENT_INAP_CLINIC_TYPE" class="TREATMENT_INAP_CLINIC_TYPE"><?= $Page->renderSort($Page->CLINIC_TYPE) ?></div></th>
<?php } ?>
<?php if ($Page->ID_1->Visible) { // ID_1 ?>
        <th data-name="ID_1" class="<?= $Page->ID_1->headerCellClass() ?>"><div id="elh_TREATMENT_INAP_ID_1" class="TREATMENT_INAP_ID_1"><?= $Page->renderSort($Page->ID_1) ?></div></th>
<?php } ?>
<?php if ($Page->ORG_UNIT_CODE->Visible) { // ORG_UNIT_CODE ?>
        <th data-name="ORG_UNIT_CODE" class="<?= $Page->ORG_UNIT_CODE->headerCellClass() ?>"><div id="elh_TREATMENT_INAP_ORG_UNIT_CODE" class="TREATMENT_INAP_ORG_UNIT_CODE"><?= $Page->renderSort($Page->ORG_UNIT_CODE) ?></div></th>
<?php } ?>
<?php if ($Page->BILL_ID_1->Visible) { // BILL_ID_1 ?>
        <th data-name="BILL_ID_1" class="<?= $Page->BILL_ID_1->headerCellClass() ?>"><div id="elh_TREATMENT_INAP_BILL_ID_1" class="TREATMENT_INAP_BILL_ID_1"><?= $Page->renderSort($Page->BILL_ID_1) ?></div></th>
<?php } ?>
<?php if ($Page->NO_REGISTRATION_1->Visible) { // NO_REGISTRATION_1 ?>
        <th data-name="NO_REGISTRATION_1" class="<?= $Page->NO_REGISTRATION_1->headerCellClass() ?>"><div id="elh_TREATMENT_INAP_NO_REGISTRATION_1" class="TREATMENT_INAP_NO_REGISTRATION_1"><?= $Page->renderSort($Page->NO_REGISTRATION_1) ?></div></th>
<?php } ?>
<?php if ($Page->VISIT_ID_1->Visible) { // VISIT_ID_1 ?>
        <th data-name="VISIT_ID_1" class="<?= $Page->VISIT_ID_1->headerCellClass() ?>"><div id="elh_TREATMENT_INAP_VISIT_ID_1" class="TREATMENT_INAP_VISIT_ID_1"><?= $Page->renderSort($Page->VISIT_ID_1) ?></div></th>
<?php } ?>
<?php if ($Page->TARIF_ID_1->Visible) { // TARIF_ID_1 ?>
        <th data-name="TARIF_ID_1" class="<?= $Page->TARIF_ID_1->headerCellClass() ?>"><div id="elh_TREATMENT_INAP_TARIF_ID_1" class="TREATMENT_INAP_TARIF_ID_1"><?= $Page->renderSort($Page->TARIF_ID_1) ?></div></th>
<?php } ?>
<?php if ($Page->CLASS_ID_1->Visible) { // CLASS_ID_1 ?>
        <th data-name="CLASS_ID_1" class="<?= $Page->CLASS_ID_1->headerCellClass() ?>"><div id="elh_TREATMENT_INAP_CLASS_ID_1" class="TREATMENT_INAP_CLASS_ID_1"><?= $Page->renderSort($Page->CLASS_ID_1) ?></div></th>
<?php } ?>
<?php if ($Page->CLINIC_ID_1->Visible) { // CLINIC_ID_1 ?>
        <th data-name="CLINIC_ID_1" class="<?= $Page->CLINIC_ID_1->headerCellClass() ?>"><div id="elh_TREATMENT_INAP_CLINIC_ID_1" class="TREATMENT_INAP_CLINIC_ID_1"><?= $Page->renderSort($Page->CLINIC_ID_1) ?></div></th>
<?php } ?>
<?php if ($Page->CLINIC_ID_FROM_1->Visible) { // CLINIC_ID_FROM_1 ?>
        <th data-name="CLINIC_ID_FROM_1" class="<?= $Page->CLINIC_ID_FROM_1->headerCellClass() ?>"><div id="elh_TREATMENT_INAP_CLINIC_ID_FROM_1" class="TREATMENT_INAP_CLINIC_ID_FROM_1"><?= $Page->renderSort($Page->CLINIC_ID_FROM_1) ?></div></th>
<?php } ?>
<?php if ($Page->TREATMENT_1->Visible) { // TREATMENT_1 ?>
        <th data-name="TREATMENT_1" class="<?= $Page->TREATMENT_1->headerCellClass() ?>"><div id="elh_TREATMENT_INAP_TREATMENT_1" class="TREATMENT_INAP_TREATMENT_1"><?= $Page->renderSort($Page->TREATMENT_1) ?></div></th>
<?php } ?>
<?php if ($Page->TREAT_DATE_1->Visible) { // TREAT_DATE_1 ?>
        <th data-name="TREAT_DATE_1" class="<?= $Page->TREAT_DATE_1->headerCellClass() ?>"><div id="elh_TREATMENT_INAP_TREAT_DATE_1" class="TREATMENT_INAP_TREAT_DATE_1"><?= $Page->renderSort($Page->TREAT_DATE_1) ?></div></th>
<?php } ?>
<?php if ($Page->QUANTITY_1->Visible) { // QUANTITY_1 ?>
        <th data-name="QUANTITY_1" class="<?= $Page->QUANTITY_1->headerCellClass() ?>"><div id="elh_TREATMENT_INAP_QUANTITY_1" class="TREATMENT_INAP_QUANTITY_1"><?= $Page->renderSort($Page->QUANTITY_1) ?></div></th>
<?php } ?>
<?php if ($Page->MEASURE_ID->Visible) { // MEASURE_ID ?>
        <th data-name="MEASURE_ID" class="<?= $Page->MEASURE_ID->headerCellClass() ?>"><div id="elh_TREATMENT_INAP_MEASURE_ID" class="TREATMENT_INAP_MEASURE_ID"><?= $Page->renderSort($Page->MEASURE_ID) ?></div></th>
<?php } ?>
<?php if ($Page->MEASURE_ID_1->Visible) { // MEASURE_ID_1 ?>
        <th data-name="MEASURE_ID_1" class="<?= $Page->MEASURE_ID_1->headerCellClass() ?>"><div id="elh_TREATMENT_INAP_MEASURE_ID_1" class="TREATMENT_INAP_MEASURE_ID_1"><?= $Page->renderSort($Page->MEASURE_ID_1) ?></div></th>
<?php } ?>
<?php if ($Page->TRANS_ID_1->Visible) { // TRANS_ID_1 ?>
        <th data-name="TRANS_ID_1" class="<?= $Page->TRANS_ID_1->headerCellClass() ?>"><div id="elh_TREATMENT_INAP_TRANS_ID_1" class="TREATMENT_INAP_TRANS_ID_1"><?= $Page->renderSort($Page->TRANS_ID_1) ?></div></th>
<?php } ?>
<?php
// Render list options (header, right)
$Page->ListOptions->render("header", "right");
?>
    </tr>
</thead>
<tbody>
<?php
if ($Page->ExportAll && $Page->isExport()) {
    $Page->StopRecord = $Page->TotalRecords;
} else {
    // Set the last record to display
    if ($Page->TotalRecords > $Page->StartRecord + $Page->DisplayRecords - 1) {
        $Page->StopRecord = $Page->StartRecord + $Page->DisplayRecords - 1;
    } else {
        $Page->StopRecord = $Page->TotalRecords;
    }
}

// Restore number of post back records
if ($CurrentForm && ($Page->isConfirm() || $Page->EventCancelled)) {
    $CurrentForm->Index = -1;
    if ($CurrentForm->hasValue($Page->FormKeyCountName) && ($Page->isGridAdd() || $Page->isGridEdit() || $Page->isConfirm())) {
        $Page->KeyCount = $CurrentForm->getValue($Page->FormKeyCountName);
        $Page->StopRecord = $Page->StartRecord + $Page->KeyCount - 1;
    }
}
$Page->RecordCount = $Page->StartRecord - 1;
if ($Page->Recordset && !$Page->Recordset->EOF) {
    // Nothing to do
} elseif (!$Page->AllowAddDeleteRow && $Page->StopRecord == 0) {
    $Page->StopRecord = $Page->GridAddRowCount;
}

// Initialize aggregate
$Page->RowType = ROWTYPE_AGGREGATEINIT;
$Page->resetAttributes();
$Page->renderRow();
if ($Page->isGridAdd())
    $Page->RowIndex = 0;
if ($Page->isGridEdit())
    $Page->RowIndex = 0;
while ($Page->RecordCount < $Page->StopRecord) {
    $Page->RecordCount++;
    if ($Page->RecordCount >= $Page->StartRecord) {
        $Page->RowCount++;
        if ($Page->isGridAdd() || $Page->isGridEdit() || $Page->isConfirm()) {
            $Page->RowIndex++;
            $CurrentForm->Index = $Page->RowIndex;
            if ($CurrentForm->hasValue($Page->FormActionName) && ($Page->isConfirm() || $Page->EventCancelled)) {
                $Page->RowAction = strval($CurrentForm->getValue($Page->FormActionName));
            } elseif ($Page->isGridAdd()) {
                $Page->RowAction = "insert";
            } else {
                $Page->RowAction = "";
            }
        }

        // Set up key count
        $Page->KeyCount = $Page->RowIndex;

        // Init row class and style
        $Page->resetAttributes();
        $Page->CssClass = "";
        if ($Page->isGridAdd()) {
            $Page->loadRowValues(); // Load default values
            $Page->OldKey = "";
            $Page->setKey($Page->OldKey);
        } else {
            $Page->loadRowValues($Page->Recordset); // Load row values
            if ($Page->isGridEdit()) {
                $Page->OldKey = $Page->getKey(true); // Get from CurrentValue
                $Page->setKey($Page->OldKey);
            }
        }
        $Page->RowType = ROWTYPE_VIEW; // Render view
        if ($Page->isGridAdd()) { // Grid add
            $Page->RowType = ROWTYPE_ADD; // Render add
        }
        if ($Page->isGridAdd() && $Page->EventCancelled && !$CurrentForm->hasValue("k_blankrow")) { // Insert failed
            $Page->restoreCurrentRowFormValues($Page->RowIndex); // Restore form values
        }
        if ($Page->isGridEdit()) { // Grid edit
            if ($Page->EventCancelled) {
                $Page->restoreCurrentRowFormValues($Page->RowIndex); // Restore form values
            }
            if ($Page->RowAction == "insert") {
                $Page->RowType = ROWTYPE_ADD; // Render add
            } else {
                $Page->RowType = ROWTYPE_EDIT; // Render edit
            }
        }
        if ($Page->isGridEdit() && ($Page->RowType == ROWTYPE_EDIT || $Page->RowType == ROWTYPE_ADD) && $Page->EventCancelled) { // Update failed
            $Page->restoreCurrentRowFormValues($Page->RowIndex); // Restore form values
        }
        if ($Page->RowType == ROWTYPE_EDIT) { // Edit row
            $Page->EditRowCount++;
        }

        // Set up row id / data-rowindex
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_TREATMENT_INAP", "data-rowtype" => $Page->RowType]);

        // Render row
        $Page->renderRow();

        // Render list options
        $Page->renderListOptions();

        // Skip delete row / empty row for confirm page
        if ($Page->RowAction != "delete" && $Page->RowAction != "insertdelete" && !($Page->RowAction == "insert" && $Page->isConfirm() && $Page->emptyRow())) {
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount);
?>
    <?php if ($Page->NO_REGISTRATION->Visible) { // NO_REGISTRATION ?>
        <td data-name="NO_REGISTRATION" <?= $Page->NO_REGISTRATION->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Page->NO_REGISTRATION->getSessionValue() != "") { ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_NO_REGISTRATION" class="form-group">
<span<?= $Page->NO_REGISTRATION->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->NO_REGISTRATION->getDisplayValue($Page->NO_REGISTRATION->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_NO_REGISTRATION" name="x<?= $Page->RowIndex ?>_NO_REGISTRATION" value="<?= HtmlEncode($Page->NO_REGISTRATION->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_NO_REGISTRATION" class="form-group">
<div class="input-group ew-lookup-list">
    <div class="form-control ew-lookup-text" tabindex="-1" id="lu_x<?= $Page->RowIndex ?>_NO_REGISTRATION"><?= EmptyValue(strval($Page->NO_REGISTRATION->ViewValue)) ? $Language->phrase("PleaseSelect") : $Page->NO_REGISTRATION->ViewValue ?></div>
    <div class="input-group-append">
        <button type="button" title="<?= HtmlEncode(str_replace("%s", RemoveHtml($Page->NO_REGISTRATION->caption()), $Language->phrase("LookupLink", true))) ?>" class="ew-lookup-btn btn btn-default"<?= ($Page->NO_REGISTRATION->ReadOnly || $Page->NO_REGISTRATION->Disabled) ? " disabled" : "" ?> onclick="ew.modalLookupShow({lnk:this,el:'x<?= $Page->RowIndex ?>_NO_REGISTRATION',m:0,n:10});"><i class="fas fa-search ew-icon"></i></button>
    </div>
</div>
<div class="invalid-feedback"><?= $Page->NO_REGISTRATION->getErrorMessage() ?></div>
<?= $Page->NO_REGISTRATION->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_NO_REGISTRATION") ?>
<input type="hidden" is="selection-list" data-table="TREATMENT_INAP" data-field="x_NO_REGISTRATION" data-type="text" data-multiple="0" data-lookup="1" data-value-separator="<?= $Page->NO_REGISTRATION->displayValueSeparatorAttribute() ?>" name="x<?= $Page->RowIndex ?>_NO_REGISTRATION" id="x<?= $Page->RowIndex ?>_NO_REGISTRATION" value="<?= $Page->NO_REGISTRATION->CurrentValue ?>"<?= $Page->NO_REGISTRATION->editAttributes() ?>>
</span>
<?php } ?>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_NO_REGISTRATION" data-hidden="1" name="o<?= $Page->RowIndex ?>_NO_REGISTRATION" id="o<?= $Page->RowIndex ?>_NO_REGISTRATION" value="<?= HtmlEncode($Page->NO_REGISTRATION->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Page->NO_REGISTRATION->getSessionValue() != "") { ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_NO_REGISTRATION" class="form-group">
<span<?= $Page->NO_REGISTRATION->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->NO_REGISTRATION->getDisplayValue($Page->NO_REGISTRATION->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_NO_REGISTRATION" name="x<?= $Page->RowIndex ?>_NO_REGISTRATION" value="<?= HtmlEncode($Page->NO_REGISTRATION->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_NO_REGISTRATION" class="form-group">
<div class="input-group ew-lookup-list">
    <div class="form-control ew-lookup-text" tabindex="-1" id="lu_x<?= $Page->RowIndex ?>_NO_REGISTRATION"><?= EmptyValue(strval($Page->NO_REGISTRATION->ViewValue)) ? $Language->phrase("PleaseSelect") : $Page->NO_REGISTRATION->ViewValue ?></div>
    <div class="input-group-append">
        <button type="button" title="<?= HtmlEncode(str_replace("%s", RemoveHtml($Page->NO_REGISTRATION->caption()), $Language->phrase("LookupLink", true))) ?>" class="ew-lookup-btn btn btn-default"<?= ($Page->NO_REGISTRATION->ReadOnly || $Page->NO_REGISTRATION->Disabled) ? " disabled" : "" ?> onclick="ew.modalLookupShow({lnk:this,el:'x<?= $Page->RowIndex ?>_NO_REGISTRATION',m:0,n:10});"><i class="fas fa-search ew-icon"></i></button>
    </div>
</div>
<div class="invalid-feedback"><?= $Page->NO_REGISTRATION->getErrorMessage() ?></div>
<?= $Page->NO_REGISTRATION->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_NO_REGISTRATION") ?>
<input type="hidden" is="selection-list" data-table="TREATMENT_INAP" data-field="x_NO_REGISTRATION" data-type="text" data-multiple="0" data-lookup="1" data-value-separator="<?= $Page->NO_REGISTRATION->displayValueSeparatorAttribute() ?>" name="x<?= $Page->RowIndex ?>_NO_REGISTRATION" id="x<?= $Page->RowIndex ?>_NO_REGISTRATION" value="<?= $Page->NO_REGISTRATION->CurrentValue ?>"<?= $Page->NO_REGISTRATION->editAttributes() ?>>
</span>
<?php } ?>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_NO_REGISTRATION">
<span<?= $Page->NO_REGISTRATION->viewAttributes() ?>>
<?= $Page->NO_REGISTRATION->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->VISIT_ID->Visible) { // VISIT_ID ?>
        <td data-name="VISIT_ID" <?= $Page->VISIT_ID->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Page->VISIT_ID->getSessionValue() != "") { ?>
<input type="hidden" id="x<?= $Page->RowIndex ?>_VISIT_ID" name="x<?= $Page->RowIndex ?>_VISIT_ID" value="<?= HtmlEncode($Page->VISIT_ID->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_VISIT_ID" class="form-group">
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_VISIT_ID" data-hidden="1" name="x<?= $Page->RowIndex ?>_VISIT_ID" id="x<?= $Page->RowIndex ?>_VISIT_ID" value="<?= HtmlEncode($Page->VISIT_ID->CurrentValue) ?>">
</span>
<?php } ?>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_VISIT_ID" data-hidden="1" name="o<?= $Page->RowIndex ?>_VISIT_ID" id="o<?= $Page->RowIndex ?>_VISIT_ID" value="<?= HtmlEncode($Page->VISIT_ID->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Page->VISIT_ID->getSessionValue() != "") { ?>
<input type="hidden" id="x<?= $Page->RowIndex ?>_VISIT_ID" name="x<?= $Page->RowIndex ?>_VISIT_ID" value="<?= HtmlEncode($Page->VISIT_ID->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_VISIT_ID" class="form-group">
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_VISIT_ID" data-hidden="1" name="x<?= $Page->RowIndex ?>_VISIT_ID" id="x<?= $Page->RowIndex ?>_VISIT_ID" value="<?= HtmlEncode($Page->VISIT_ID->CurrentValue) ?>">
</span>
<?php } ?>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_VISIT_ID">
<span<?= $Page->VISIT_ID->viewAttributes() ?>>
<?= $Page->VISIT_ID->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->TARIF_ID->Visible) { // TARIF_ID ?>
        <td data-name="TARIF_ID" <?= $Page->TARIF_ID->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_TARIF_ID" class="form-group">
<?php $Page->TARIF_ID->EditAttrs->prepend("onchange", "ew.autoFill(this);"); ?>
<div class="input-group ew-lookup-list">
    <div class="form-control ew-lookup-text" tabindex="-1" id="lu_x<?= $Page->RowIndex ?>_TARIF_ID"><?= EmptyValue(strval($Page->TARIF_ID->ViewValue)) ? $Language->phrase("PleaseSelect") : $Page->TARIF_ID->ViewValue ?></div>
    <div class="input-group-append">
        <button type="button" title="<?= HtmlEncode(str_replace("%s", RemoveHtml($Page->TARIF_ID->caption()), $Language->phrase("LookupLink", true))) ?>" class="ew-lookup-btn btn btn-default"<?= ($Page->TARIF_ID->ReadOnly || $Page->TARIF_ID->Disabled) ? " disabled" : "" ?> onclick="ew.modalLookupShow({lnk:this,el:'x<?= $Page->RowIndex ?>_TARIF_ID',m:0,n:10});"><i class="fas fa-search ew-icon"></i></button>
    </div>
</div>
<div class="invalid-feedback"><?= $Page->TARIF_ID->getErrorMessage() ?></div>
<?= $Page->TARIF_ID->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_TARIF_ID") ?>
<input type="hidden" is="selection-list" data-table="TREATMENT_INAP" data-field="x_TARIF_ID" data-type="text" data-multiple="0" data-lookup="1" data-value-separator="<?= $Page->TARIF_ID->displayValueSeparatorAttribute() ?>" name="x<?= $Page->RowIndex ?>_TARIF_ID" id="x<?= $Page->RowIndex ?>_TARIF_ID" value="<?= $Page->TARIF_ID->CurrentValue ?>"<?= $Page->TARIF_ID->editAttributes() ?>>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_TARIF_ID" data-hidden="1" name="o<?= $Page->RowIndex ?>_TARIF_ID" id="o<?= $Page->RowIndex ?>_TARIF_ID" value="<?= HtmlEncode($Page->TARIF_ID->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_TARIF_ID" class="form-group">
<?php $Page->TARIF_ID->EditAttrs->prepend("onchange", "ew.autoFill(this);"); ?>
<div class="input-group ew-lookup-list">
    <div class="form-control ew-lookup-text" tabindex="-1" id="lu_x<?= $Page->RowIndex ?>_TARIF_ID"><?= EmptyValue(strval($Page->TARIF_ID->ViewValue)) ? $Language->phrase("PleaseSelect") : $Page->TARIF_ID->ViewValue ?></div>
    <div class="input-group-append">
        <button type="button" title="<?= HtmlEncode(str_replace("%s", RemoveHtml($Page->TARIF_ID->caption()), $Language->phrase("LookupLink", true))) ?>" class="ew-lookup-btn btn btn-default"<?= ($Page->TARIF_ID->ReadOnly || $Page->TARIF_ID->Disabled) ? " disabled" : "" ?> onclick="ew.modalLookupShow({lnk:this,el:'x<?= $Page->RowIndex ?>_TARIF_ID',m:0,n:10});"><i class="fas fa-search ew-icon"></i></button>
    </div>
</div>
<div class="invalid-feedback"><?= $Page->TARIF_ID->getErrorMessage() ?></div>
<?= $Page->TARIF_ID->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_TARIF_ID") ?>
<input type="hidden" is="selection-list" data-table="TREATMENT_INAP" data-field="x_TARIF_ID" data-type="text" data-multiple="0" data-lookup="1" data-value-separator="<?= $Page->TARIF_ID->displayValueSeparatorAttribute() ?>" name="x<?= $Page->RowIndex ?>_TARIF_ID" id="x<?= $Page->RowIndex ?>_TARIF_ID" value="<?= $Page->TARIF_ID->CurrentValue ?>"<?= $Page->TARIF_ID->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_TARIF_ID">
<span<?= $Page->TARIF_ID->viewAttributes() ?>>
<?= $Page->TARIF_ID->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->CLINIC_ID->Visible) { // CLINIC_ID ?>
        <td data-name="CLINIC_ID" <?= $Page->CLINIC_ID->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_CLINIC_ID" class="form-group">
    <select
        id="x<?= $Page->RowIndex ?>_CLINIC_ID"
        name="x<?= $Page->RowIndex ?>_CLINIC_ID"
        class="form-control ew-select<?= $Page->CLINIC_ID->isInvalidClass() ?>"
        data-select2-id="TREATMENT_INAP_x<?= $Page->RowIndex ?>_CLINIC_ID"
        data-table="TREATMENT_INAP"
        data-field="x_CLINIC_ID"
        data-value-separator="<?= $Page->CLINIC_ID->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->CLINIC_ID->getPlaceHolder()) ?>"
        <?= $Page->CLINIC_ID->editAttributes() ?>>
        <?= $Page->CLINIC_ID->selectOptionListHtml("x{$Page->RowIndex}_CLINIC_ID") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->CLINIC_ID->getErrorMessage() ?></div>
<?= $Page->CLINIC_ID->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_CLINIC_ID") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='TREATMENT_INAP_x<?= $Page->RowIndex ?>_CLINIC_ID']"),
        options = { name: "x<?= $Page->RowIndex ?>_CLINIC_ID", selectId: "TREATMENT_INAP_x<?= $Page->RowIndex ?>_CLINIC_ID", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.TREATMENT_INAP.fields.CLINIC_ID.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_CLINIC_ID" data-hidden="1" name="o<?= $Page->RowIndex ?>_CLINIC_ID" id="o<?= $Page->RowIndex ?>_CLINIC_ID" value="<?= HtmlEncode($Page->CLINIC_ID->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_CLINIC_ID" class="form-group">
<span<?= $Page->CLINIC_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->CLINIC_ID->getDisplayValue($Page->CLINIC_ID->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_CLINIC_ID" data-hidden="1" name="x<?= $Page->RowIndex ?>_CLINIC_ID" id="x<?= $Page->RowIndex ?>_CLINIC_ID" value="<?= HtmlEncode($Page->CLINIC_ID->CurrentValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_CLINIC_ID">
<span<?= $Page->CLINIC_ID->viewAttributes() ?>>
<?= $Page->CLINIC_ID->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->TREATMENT->Visible) { // TREATMENT ?>
        <td data-name="TREATMENT" <?= $Page->TREATMENT->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_TREATMENT" class="form-group">
<input type="<?= $Page->TREATMENT->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_TREATMENT" name="x<?= $Page->RowIndex ?>_TREATMENT" id="x<?= $Page->RowIndex ?>_TREATMENT" size="30" maxlength="200" placeholder="<?= HtmlEncode($Page->TREATMENT->getPlaceHolder()) ?>" value="<?= $Page->TREATMENT->EditValue ?>"<?= $Page->TREATMENT->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->TREATMENT->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_TREATMENT" data-hidden="1" name="o<?= $Page->RowIndex ?>_TREATMENT" id="o<?= $Page->RowIndex ?>_TREATMENT" value="<?= HtmlEncode($Page->TREATMENT->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_TREATMENT" class="form-group">
<input type="<?= $Page->TREATMENT->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_TREATMENT" name="x<?= $Page->RowIndex ?>_TREATMENT" id="x<?= $Page->RowIndex ?>_TREATMENT" size="30" maxlength="200" placeholder="<?= HtmlEncode($Page->TREATMENT->getPlaceHolder()) ?>" value="<?= $Page->TREATMENT->EditValue ?>"<?= $Page->TREATMENT->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->TREATMENT->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_TREATMENT">
<span<?= $Page->TREATMENT->viewAttributes() ?>>
<?= $Page->TREATMENT->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->TREAT_DATE->Visible) { // TREAT_DATE ?>
        <td data-name="TREAT_DATE" <?= $Page->TREAT_DATE->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_TREAT_DATE" class="form-group">
<input type="<?= $Page->TREAT_DATE->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_TREAT_DATE" data-format="11" name="x<?= $Page->RowIndex ?>_TREAT_DATE" id="x<?= $Page->RowIndex ?>_TREAT_DATE" placeholder="<?= HtmlEncode($Page->TREAT_DATE->getPlaceHolder()) ?>" value="<?= $Page->TREAT_DATE->EditValue ?>"<?= $Page->TREAT_DATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->TREAT_DATE->getErrorMessage() ?></div>
<?php if (!$Page->TREAT_DATE->ReadOnly && !$Page->TREAT_DATE->Disabled && !isset($Page->TREAT_DATE->EditAttrs["readonly"]) && !isset($Page->TREAT_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fTREATMENT_INAPlist", "datetimepicker"], function() {
    ew.createDateTimePicker("fTREATMENT_INAPlist", "x<?= $Page->RowIndex ?>_TREAT_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":11});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_TREAT_DATE" data-hidden="1" name="o<?= $Page->RowIndex ?>_TREAT_DATE" id="o<?= $Page->RowIndex ?>_TREAT_DATE" value="<?= HtmlEncode($Page->TREAT_DATE->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_TREAT_DATE" class="form-group">
<input type="<?= $Page->TREAT_DATE->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_TREAT_DATE" data-format="11" name="x<?= $Page->RowIndex ?>_TREAT_DATE" id="x<?= $Page->RowIndex ?>_TREAT_DATE" placeholder="<?= HtmlEncode($Page->TREAT_DATE->getPlaceHolder()) ?>" value="<?= $Page->TREAT_DATE->EditValue ?>"<?= $Page->TREAT_DATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->TREAT_DATE->getErrorMessage() ?></div>
<?php if (!$Page->TREAT_DATE->ReadOnly && !$Page->TREAT_DATE->Disabled && !isset($Page->TREAT_DATE->EditAttrs["readonly"]) && !isset($Page->TREAT_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fTREATMENT_INAPlist", "datetimepicker"], function() {
    ew.createDateTimePicker("fTREATMENT_INAPlist", "x<?= $Page->RowIndex ?>_TREAT_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":11});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_TREAT_DATE">
<span<?= $Page->TREAT_DATE->viewAttributes() ?>>
<?= $Page->TREAT_DATE->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->QUANTITY->Visible) { // QUANTITY ?>
        <td data-name="QUANTITY" <?= $Page->QUANTITY->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_QUANTITY" class="form-group">
<input type="<?= $Page->QUANTITY->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_QUANTITY" name="x<?= $Page->RowIndex ?>_QUANTITY" id="x<?= $Page->RowIndex ?>_QUANTITY" size="30" placeholder="<?= HtmlEncode($Page->QUANTITY->getPlaceHolder()) ?>" value="<?= $Page->QUANTITY->EditValue ?>"<?= $Page->QUANTITY->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->QUANTITY->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_QUANTITY" data-hidden="1" name="o<?= $Page->RowIndex ?>_QUANTITY" id="o<?= $Page->RowIndex ?>_QUANTITY" value="<?= HtmlEncode($Page->QUANTITY->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_QUANTITY" class="form-group">
<input type="<?= $Page->QUANTITY->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_QUANTITY" name="x<?= $Page->RowIndex ?>_QUANTITY" id="x<?= $Page->RowIndex ?>_QUANTITY" size="30" placeholder="<?= HtmlEncode($Page->QUANTITY->getPlaceHolder()) ?>" value="<?= $Page->QUANTITY->EditValue ?>"<?= $Page->QUANTITY->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->QUANTITY->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_QUANTITY">
<span<?= $Page->QUANTITY->viewAttributes() ?>>
<?= $Page->QUANTITY->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->TRANS_ID->Visible) { // TRANS_ID ?>
        <td data-name="TRANS_ID" <?= $Page->TRANS_ID->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Page->TRANS_ID->getSessionValue() != "") { ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_TRANS_ID" class="form-group">
<span<?= $Page->TRANS_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->TRANS_ID->getDisplayValue($Page->TRANS_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_TRANS_ID" name="x<?= $Page->RowIndex ?>_TRANS_ID" value="<?= HtmlEncode($Page->TRANS_ID->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_TRANS_ID" class="form-group">
<input type="<?= $Page->TRANS_ID->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_TRANS_ID" name="x<?= $Page->RowIndex ?>_TRANS_ID" id="x<?= $Page->RowIndex ?>_TRANS_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->TRANS_ID->getPlaceHolder()) ?>" value="<?= $Page->TRANS_ID->EditValue ?>"<?= $Page->TRANS_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->TRANS_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_TRANS_ID" data-hidden="1" name="o<?= $Page->RowIndex ?>_TRANS_ID" id="o<?= $Page->RowIndex ?>_TRANS_ID" value="<?= HtmlEncode($Page->TRANS_ID->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Page->TRANS_ID->getSessionValue() != "") { ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_TRANS_ID" class="form-group">
<span<?= $Page->TRANS_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->TRANS_ID->getDisplayValue($Page->TRANS_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_TRANS_ID" name="x<?= $Page->RowIndex ?>_TRANS_ID" value="<?= HtmlEncode($Page->TRANS_ID->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_TRANS_ID" class="form-group">
<input type="<?= $Page->TRANS_ID->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_TRANS_ID" name="x<?= $Page->RowIndex ?>_TRANS_ID" id="x<?= $Page->RowIndex ?>_TRANS_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->TRANS_ID->getPlaceHolder()) ?>" value="<?= $Page->TRANS_ID->EditValue ?>"<?= $Page->TRANS_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->TRANS_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_TRANS_ID">
<span<?= $Page->TRANS_ID->viewAttributes() ?>>
<?= $Page->TRANS_ID->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->ID->Visible) { // ID ?>
        <td data-name="ID" <?= $Page->ID->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_ID" class="form-group"></span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_ID" data-hidden="1" name="o<?= $Page->RowIndex ?>_ID" id="o<?= $Page->RowIndex ?>_ID" value="<?= HtmlEncode($Page->ID->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_ID" class="form-group">
<span<?= $Page->ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->ID->getDisplayValue($Page->ID->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_ID" data-hidden="1" name="x<?= $Page->RowIndex ?>_ID" id="x<?= $Page->RowIndex ?>_ID" value="<?= HtmlEncode($Page->ID->CurrentValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_ID">
<span<?= $Page->ID->viewAttributes() ?>>
<?= $Page->ID->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="TREATMENT_INAP" data-field="x_ID" data-hidden="1" name="x<?= $Page->RowIndex ?>_ID" id="x<?= $Page->RowIndex ?>_ID" value="<?= HtmlEncode($Page->ID->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Page->AMOUNT->Visible) { // AMOUNT ?>
        <td data-name="AMOUNT" <?= $Page->AMOUNT->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_AMOUNT" class="form-group">
<input type="<?= $Page->AMOUNT->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_AMOUNT" name="x<?= $Page->RowIndex ?>_AMOUNT" id="x<?= $Page->RowIndex ?>_AMOUNT" size="30" placeholder="<?= HtmlEncode($Page->AMOUNT->getPlaceHolder()) ?>" value="<?= $Page->AMOUNT->EditValue ?>"<?= $Page->AMOUNT->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->AMOUNT->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_AMOUNT" data-hidden="1" name="o<?= $Page->RowIndex ?>_AMOUNT" id="o<?= $Page->RowIndex ?>_AMOUNT" value="<?= HtmlEncode($Page->AMOUNT->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_AMOUNT" class="form-group">
<input type="<?= $Page->AMOUNT->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_AMOUNT" name="x<?= $Page->RowIndex ?>_AMOUNT" id="x<?= $Page->RowIndex ?>_AMOUNT" size="30" placeholder="<?= HtmlEncode($Page->AMOUNT->getPlaceHolder()) ?>" value="<?= $Page->AMOUNT->EditValue ?>"<?= $Page->AMOUNT->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->AMOUNT->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_AMOUNT">
<span<?= $Page->AMOUNT->viewAttributes() ?>>
<?= $Page->AMOUNT->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->POKOK_JUAL->Visible) { // POKOK_JUAL ?>
        <td data-name="POKOK_JUAL" <?= $Page->POKOK_JUAL->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_POKOK_JUAL" class="form-group">
<input type="<?= $Page->POKOK_JUAL->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_POKOK_JUAL" name="x<?= $Page->RowIndex ?>_POKOK_JUAL" id="x<?= $Page->RowIndex ?>_POKOK_JUAL" size="30" placeholder="<?= HtmlEncode($Page->POKOK_JUAL->getPlaceHolder()) ?>" value="<?= $Page->POKOK_JUAL->EditValue ?>"<?= $Page->POKOK_JUAL->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->POKOK_JUAL->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_POKOK_JUAL" data-hidden="1" name="o<?= $Page->RowIndex ?>_POKOK_JUAL" id="o<?= $Page->RowIndex ?>_POKOK_JUAL" value="<?= HtmlEncode($Page->POKOK_JUAL->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_POKOK_JUAL" class="form-group">
<input type="<?= $Page->POKOK_JUAL->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_POKOK_JUAL" name="x<?= $Page->RowIndex ?>_POKOK_JUAL" id="x<?= $Page->RowIndex ?>_POKOK_JUAL" size="30" placeholder="<?= HtmlEncode($Page->POKOK_JUAL->getPlaceHolder()) ?>" value="<?= $Page->POKOK_JUAL->EditValue ?>"<?= $Page->POKOK_JUAL->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->POKOK_JUAL->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_POKOK_JUAL">
<span<?= $Page->POKOK_JUAL->viewAttributes() ?>>
<?= $Page->POKOK_JUAL->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->PPN->Visible) { // PPN ?>
        <td data-name="PPN" <?= $Page->PPN->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_PPN" class="form-group">
<input type="<?= $Page->PPN->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_PPN" name="x<?= $Page->RowIndex ?>_PPN" id="x<?= $Page->RowIndex ?>_PPN" size="30" placeholder="<?= HtmlEncode($Page->PPN->getPlaceHolder()) ?>" value="<?= $Page->PPN->EditValue ?>"<?= $Page->PPN->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->PPN->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_PPN" data-hidden="1" name="o<?= $Page->RowIndex ?>_PPN" id="o<?= $Page->RowIndex ?>_PPN" value="<?= HtmlEncode($Page->PPN->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_PPN" class="form-group">
<input type="<?= $Page->PPN->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_PPN" name="x<?= $Page->RowIndex ?>_PPN" id="x<?= $Page->RowIndex ?>_PPN" size="30" placeholder="<?= HtmlEncode($Page->PPN->getPlaceHolder()) ?>" value="<?= $Page->PPN->EditValue ?>"<?= $Page->PPN->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->PPN->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_PPN">
<span<?= $Page->PPN->viewAttributes() ?>>
<?= $Page->PPN->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->SUBSIDI->Visible) { // SUBSIDI ?>
        <td data-name="SUBSIDI" <?= $Page->SUBSIDI->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_SUBSIDI" class="form-group">
<input type="<?= $Page->SUBSIDI->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_SUBSIDI" name="x<?= $Page->RowIndex ?>_SUBSIDI" id="x<?= $Page->RowIndex ?>_SUBSIDI" size="30" placeholder="<?= HtmlEncode($Page->SUBSIDI->getPlaceHolder()) ?>" value="<?= $Page->SUBSIDI->EditValue ?>"<?= $Page->SUBSIDI->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->SUBSIDI->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_SUBSIDI" data-hidden="1" name="o<?= $Page->RowIndex ?>_SUBSIDI" id="o<?= $Page->RowIndex ?>_SUBSIDI" value="<?= HtmlEncode($Page->SUBSIDI->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_SUBSIDI" class="form-group">
<input type="<?= $Page->SUBSIDI->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_SUBSIDI" name="x<?= $Page->RowIndex ?>_SUBSIDI" id="x<?= $Page->RowIndex ?>_SUBSIDI" size="30" placeholder="<?= HtmlEncode($Page->SUBSIDI->getPlaceHolder()) ?>" value="<?= $Page->SUBSIDI->EditValue ?>"<?= $Page->SUBSIDI->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->SUBSIDI->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_SUBSIDI">
<span<?= $Page->SUBSIDI->viewAttributes() ?>>
<?= $Page->SUBSIDI->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->PRINT_DATE->Visible) { // PRINT_DATE ?>
        <td data-name="PRINT_DATE" <?= $Page->PRINT_DATE->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_PRINT_DATE" class="form-group">
<input type="<?= $Page->PRINT_DATE->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_PRINT_DATE" name="x<?= $Page->RowIndex ?>_PRINT_DATE" id="x<?= $Page->RowIndex ?>_PRINT_DATE" placeholder="<?= HtmlEncode($Page->PRINT_DATE->getPlaceHolder()) ?>" value="<?= $Page->PRINT_DATE->EditValue ?>"<?= $Page->PRINT_DATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->PRINT_DATE->getErrorMessage() ?></div>
<?php if (!$Page->PRINT_DATE->ReadOnly && !$Page->PRINT_DATE->Disabled && !isset($Page->PRINT_DATE->EditAttrs["readonly"]) && !isset($Page->PRINT_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fTREATMENT_INAPlist", "datetimepicker"], function() {
    ew.createDateTimePicker("fTREATMENT_INAPlist", "x<?= $Page->RowIndex ?>_PRINT_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_PRINT_DATE" data-hidden="1" name="o<?= $Page->RowIndex ?>_PRINT_DATE" id="o<?= $Page->RowIndex ?>_PRINT_DATE" value="<?= HtmlEncode($Page->PRINT_DATE->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_PRINT_DATE" class="form-group">
<input type="<?= $Page->PRINT_DATE->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_PRINT_DATE" name="x<?= $Page->RowIndex ?>_PRINT_DATE" id="x<?= $Page->RowIndex ?>_PRINT_DATE" placeholder="<?= HtmlEncode($Page->PRINT_DATE->getPlaceHolder()) ?>" value="<?= $Page->PRINT_DATE->EditValue ?>"<?= $Page->PRINT_DATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->PRINT_DATE->getErrorMessage() ?></div>
<?php if (!$Page->PRINT_DATE->ReadOnly && !$Page->PRINT_DATE->Disabled && !isset($Page->PRINT_DATE->EditAttrs["readonly"]) && !isset($Page->PRINT_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fTREATMENT_INAPlist", "datetimepicker"], function() {
    ew.createDateTimePicker("fTREATMENT_INAPlist", "x<?= $Page->RowIndex ?>_PRINT_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_PRINT_DATE">
<span<?= $Page->PRINT_DATE->viewAttributes() ?>>
<?= $Page->PRINT_DATE->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->ISCETAK->Visible) { // ISCETAK ?>
        <td data-name="ISCETAK" <?= $Page->ISCETAK->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_ISCETAK" class="form-group">
<input type="<?= $Page->ISCETAK->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_ISCETAK" name="x<?= $Page->RowIndex ?>_ISCETAK" id="x<?= $Page->RowIndex ?>_ISCETAK" size="30" maxlength="1" placeholder="<?= HtmlEncode($Page->ISCETAK->getPlaceHolder()) ?>" value="<?= $Page->ISCETAK->EditValue ?>"<?= $Page->ISCETAK->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->ISCETAK->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_ISCETAK" data-hidden="1" name="o<?= $Page->RowIndex ?>_ISCETAK" id="o<?= $Page->RowIndex ?>_ISCETAK" value="<?= HtmlEncode($Page->ISCETAK->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_ISCETAK" class="form-group">
<input type="<?= $Page->ISCETAK->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_ISCETAK" name="x<?= $Page->RowIndex ?>_ISCETAK" id="x<?= $Page->RowIndex ?>_ISCETAK" size="30" maxlength="1" placeholder="<?= HtmlEncode($Page->ISCETAK->getPlaceHolder()) ?>" value="<?= $Page->ISCETAK->EditValue ?>"<?= $Page->ISCETAK->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->ISCETAK->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_ISCETAK">
<span<?= $Page->ISCETAK->viewAttributes() ?>>
<?= $Page->ISCETAK->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->NOTA_NO->Visible) { // NOTA_NO ?>
        <td data-name="NOTA_NO" <?= $Page->NOTA_NO->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_NOTA_NO" class="form-group">
<input type="<?= $Page->NOTA_NO->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_NOTA_NO" name="x<?= $Page->RowIndex ?>_NOTA_NO" id="x<?= $Page->RowIndex ?>_NOTA_NO" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->NOTA_NO->getPlaceHolder()) ?>" value="<?= $Page->NOTA_NO->EditValue ?>"<?= $Page->NOTA_NO->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->NOTA_NO->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_NOTA_NO" data-hidden="1" name="o<?= $Page->RowIndex ?>_NOTA_NO" id="o<?= $Page->RowIndex ?>_NOTA_NO" value="<?= HtmlEncode($Page->NOTA_NO->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_NOTA_NO" class="form-group">
<input type="<?= $Page->NOTA_NO->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_NOTA_NO" name="x<?= $Page->RowIndex ?>_NOTA_NO" id="x<?= $Page->RowIndex ?>_NOTA_NO" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->NOTA_NO->getPlaceHolder()) ?>" value="<?= $Page->NOTA_NO->EditValue ?>"<?= $Page->NOTA_NO->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->NOTA_NO->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_NOTA_NO">
<span<?= $Page->NOTA_NO->viewAttributes() ?>>
<?= $Page->NOTA_NO->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->KUITANSI_ID->Visible) { // KUITANSI_ID ?>
        <td data-name="KUITANSI_ID" <?= $Page->KUITANSI_ID->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_KUITANSI_ID" class="form-group">
<input type="<?= $Page->KUITANSI_ID->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_KUITANSI_ID" name="x<?= $Page->RowIndex ?>_KUITANSI_ID" id="x<?= $Page->RowIndex ?>_KUITANSI_ID" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->KUITANSI_ID->getPlaceHolder()) ?>" value="<?= $Page->KUITANSI_ID->EditValue ?>"<?= $Page->KUITANSI_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->KUITANSI_ID->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_KUITANSI_ID" data-hidden="1" name="o<?= $Page->RowIndex ?>_KUITANSI_ID" id="o<?= $Page->RowIndex ?>_KUITANSI_ID" value="<?= HtmlEncode($Page->KUITANSI_ID->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_KUITANSI_ID" class="form-group">
<input type="<?= $Page->KUITANSI_ID->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_KUITANSI_ID" name="x<?= $Page->RowIndex ?>_KUITANSI_ID" id="x<?= $Page->RowIndex ?>_KUITANSI_ID" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->KUITANSI_ID->getPlaceHolder()) ?>" value="<?= $Page->KUITANSI_ID->EditValue ?>"<?= $Page->KUITANSI_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->KUITANSI_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_KUITANSI_ID">
<span<?= $Page->KUITANSI_ID->viewAttributes() ?>>
<?= $Page->KUITANSI_ID->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->amount_paid->Visible) { // amount_paid ?>
        <td data-name="amount_paid" <?= $Page->amount_paid->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_amount_paid" class="form-group">
<input type="<?= $Page->amount_paid->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_amount_paid" name="x<?= $Page->RowIndex ?>_amount_paid" id="x<?= $Page->RowIndex ?>_amount_paid" size="30" placeholder="<?= HtmlEncode($Page->amount_paid->getPlaceHolder()) ?>" value="<?= $Page->amount_paid->EditValue ?>"<?= $Page->amount_paid->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->amount_paid->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_amount_paid" data-hidden="1" name="o<?= $Page->RowIndex ?>_amount_paid" id="o<?= $Page->RowIndex ?>_amount_paid" value="<?= HtmlEncode($Page->amount_paid->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_amount_paid" class="form-group">
<input type="<?= $Page->amount_paid->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_amount_paid" name="x<?= $Page->RowIndex ?>_amount_paid" id="x<?= $Page->RowIndex ?>_amount_paid" size="30" placeholder="<?= HtmlEncode($Page->amount_paid->getPlaceHolder()) ?>" value="<?= $Page->amount_paid->EditValue ?>"<?= $Page->amount_paid->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->amount_paid->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_amount_paid">
<span<?= $Page->amount_paid->viewAttributes() ?>>
<?= $Page->amount_paid->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->sell_price->Visible) { // sell_price ?>
        <td data-name="sell_price" <?= $Page->sell_price->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_sell_price" class="form-group">
<input type="<?= $Page->sell_price->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_sell_price" name="x<?= $Page->RowIndex ?>_sell_price" id="x<?= $Page->RowIndex ?>_sell_price" size="30" placeholder="<?= HtmlEncode($Page->sell_price->getPlaceHolder()) ?>" value="<?= $Page->sell_price->EditValue ?>"<?= $Page->sell_price->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->sell_price->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_sell_price" data-hidden="1" name="o<?= $Page->RowIndex ?>_sell_price" id="o<?= $Page->RowIndex ?>_sell_price" value="<?= HtmlEncode($Page->sell_price->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_sell_price" class="form-group">
<input type="<?= $Page->sell_price->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_sell_price" name="x<?= $Page->RowIndex ?>_sell_price" id="x<?= $Page->RowIndex ?>_sell_price" size="30" placeholder="<?= HtmlEncode($Page->sell_price->getPlaceHolder()) ?>" value="<?= $Page->sell_price->EditValue ?>"<?= $Page->sell_price->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->sell_price->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_sell_price">
<span<?= $Page->sell_price->viewAttributes() ?>>
<?= $Page->sell_price->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->diskon->Visible) { // diskon ?>
        <td data-name="diskon" <?= $Page->diskon->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_diskon" class="form-group">
<input type="<?= $Page->diskon->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_diskon" name="x<?= $Page->RowIndex ?>_diskon" id="x<?= $Page->RowIndex ?>_diskon" size="30" placeholder="<?= HtmlEncode($Page->diskon->getPlaceHolder()) ?>" value="<?= $Page->diskon->EditValue ?>"<?= $Page->diskon->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->diskon->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_diskon" data-hidden="1" name="o<?= $Page->RowIndex ?>_diskon" id="o<?= $Page->RowIndex ?>_diskon" value="<?= HtmlEncode($Page->diskon->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_diskon" class="form-group">
<input type="<?= $Page->diskon->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_diskon" name="x<?= $Page->RowIndex ?>_diskon" id="x<?= $Page->RowIndex ?>_diskon" size="30" placeholder="<?= HtmlEncode($Page->diskon->getPlaceHolder()) ?>" value="<?= $Page->diskon->EditValue ?>"<?= $Page->diskon->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->diskon->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_diskon">
<span<?= $Page->diskon->viewAttributes() ?>>
<?= $Page->diskon->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->TAGIHAN->Visible) { // TAGIHAN ?>
        <td data-name="TAGIHAN" <?= $Page->TAGIHAN->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_TAGIHAN" class="form-group">
<input type="<?= $Page->TAGIHAN->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_TAGIHAN" name="x<?= $Page->RowIndex ?>_TAGIHAN" id="x<?= $Page->RowIndex ?>_TAGIHAN" size="30" placeholder="<?= HtmlEncode($Page->TAGIHAN->getPlaceHolder()) ?>" value="<?= $Page->TAGIHAN->EditValue ?>"<?= $Page->TAGIHAN->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->TAGIHAN->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_TAGIHAN" data-hidden="1" name="o<?= $Page->RowIndex ?>_TAGIHAN" id="o<?= $Page->RowIndex ?>_TAGIHAN" value="<?= HtmlEncode($Page->TAGIHAN->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_TAGIHAN" class="form-group">
<input type="<?= $Page->TAGIHAN->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_TAGIHAN" name="x<?= $Page->RowIndex ?>_TAGIHAN" id="x<?= $Page->RowIndex ?>_TAGIHAN" size="30" placeholder="<?= HtmlEncode($Page->TAGIHAN->getPlaceHolder()) ?>" value="<?= $Page->TAGIHAN->EditValue ?>"<?= $Page->TAGIHAN->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->TAGIHAN->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_TAGIHAN">
<span<?= $Page->TAGIHAN->viewAttributes() ?>>
<?= $Page->TAGIHAN->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->CLINIC_TYPE->Visible) { // CLINIC_TYPE ?>
        <td data-name="CLINIC_TYPE" <?= $Page->CLINIC_TYPE->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_CLINIC_TYPE" class="form-group">
<input type="<?= $Page->CLINIC_TYPE->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_CLINIC_TYPE" name="x<?= $Page->RowIndex ?>_CLINIC_TYPE" id="x<?= $Page->RowIndex ?>_CLINIC_TYPE" size="30" placeholder="<?= HtmlEncode($Page->CLINIC_TYPE->getPlaceHolder()) ?>" value="<?= $Page->CLINIC_TYPE->EditValue ?>"<?= $Page->CLINIC_TYPE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->CLINIC_TYPE->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_CLINIC_TYPE" data-hidden="1" name="o<?= $Page->RowIndex ?>_CLINIC_TYPE" id="o<?= $Page->RowIndex ?>_CLINIC_TYPE" value="<?= HtmlEncode($Page->CLINIC_TYPE->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_CLINIC_TYPE" class="form-group">
<input type="<?= $Page->CLINIC_TYPE->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_CLINIC_TYPE" name="x<?= $Page->RowIndex ?>_CLINIC_TYPE" id="x<?= $Page->RowIndex ?>_CLINIC_TYPE" size="30" placeholder="<?= HtmlEncode($Page->CLINIC_TYPE->getPlaceHolder()) ?>" value="<?= $Page->CLINIC_TYPE->EditValue ?>"<?= $Page->CLINIC_TYPE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->CLINIC_TYPE->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_CLINIC_TYPE">
<span<?= $Page->CLINIC_TYPE->viewAttributes() ?>>
<?= $Page->CLINIC_TYPE->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->ID_1->Visible) { // ID_1 ?>
        <td data-name="ID_1" <?= $Page->ID_1->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_ID_1" class="form-group"></span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_ID_1" data-hidden="1" name="o<?= $Page->RowIndex ?>_ID_1" id="o<?= $Page->RowIndex ?>_ID_1" value="<?= HtmlEncode($Page->ID_1->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_ID_1" class="form-group">
<input type="<?= $Page->ID_1->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_ID_1" name="x<?= $Page->RowIndex ?>_ID_1" id="x<?= $Page->RowIndex ?>_ID_1" placeholder="<?= HtmlEncode($Page->ID_1->getPlaceHolder()) ?>" value="<?= $Page->ID_1->EditValue ?>"<?= $Page->ID_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->ID_1->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_ID_1">
<span<?= $Page->ID_1->viewAttributes() ?>>
<?= $Page->ID_1->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->ORG_UNIT_CODE->Visible) { // ORG_UNIT_CODE ?>
        <td data-name="ORG_UNIT_CODE" <?= $Page->ORG_UNIT_CODE->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_ORG_UNIT_CODE" class="form-group">
<input type="<?= $Page->ORG_UNIT_CODE->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_ORG_UNIT_CODE" name="x<?= $Page->RowIndex ?>_ORG_UNIT_CODE" id="x<?= $Page->RowIndex ?>_ORG_UNIT_CODE" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->ORG_UNIT_CODE->getPlaceHolder()) ?>" value="<?= $Page->ORG_UNIT_CODE->EditValue ?>"<?= $Page->ORG_UNIT_CODE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->ORG_UNIT_CODE->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_ORG_UNIT_CODE" data-hidden="1" name="o<?= $Page->RowIndex ?>_ORG_UNIT_CODE" id="o<?= $Page->RowIndex ?>_ORG_UNIT_CODE" value="<?= HtmlEncode($Page->ORG_UNIT_CODE->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_ORG_UNIT_CODE" class="form-group">
<input type="<?= $Page->ORG_UNIT_CODE->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_ORG_UNIT_CODE" name="x<?= $Page->RowIndex ?>_ORG_UNIT_CODE" id="x<?= $Page->RowIndex ?>_ORG_UNIT_CODE" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->ORG_UNIT_CODE->getPlaceHolder()) ?>" value="<?= $Page->ORG_UNIT_CODE->EditValue ?>"<?= $Page->ORG_UNIT_CODE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->ORG_UNIT_CODE->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_ORG_UNIT_CODE">
<span<?= $Page->ORG_UNIT_CODE->viewAttributes() ?>>
<?= $Page->ORG_UNIT_CODE->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->BILL_ID_1->Visible) { // BILL_ID_1 ?>
        <td data-name="BILL_ID_1" <?= $Page->BILL_ID_1->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_BILL_ID_1" class="form-group">
<input type="<?= $Page->BILL_ID_1->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_BILL_ID_1" name="x<?= $Page->RowIndex ?>_BILL_ID_1" id="x<?= $Page->RowIndex ?>_BILL_ID_1" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->BILL_ID_1->getPlaceHolder()) ?>" value="<?= $Page->BILL_ID_1->EditValue ?>"<?= $Page->BILL_ID_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->BILL_ID_1->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_BILL_ID_1" data-hidden="1" name="o<?= $Page->RowIndex ?>_BILL_ID_1" id="o<?= $Page->RowIndex ?>_BILL_ID_1" value="<?= HtmlEncode($Page->BILL_ID_1->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_BILL_ID_1" class="form-group">
<input type="<?= $Page->BILL_ID_1->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_BILL_ID_1" name="x<?= $Page->RowIndex ?>_BILL_ID_1" id="x<?= $Page->RowIndex ?>_BILL_ID_1" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->BILL_ID_1->getPlaceHolder()) ?>" value="<?= $Page->BILL_ID_1->EditValue ?>"<?= $Page->BILL_ID_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->BILL_ID_1->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_BILL_ID_1">
<span<?= $Page->BILL_ID_1->viewAttributes() ?>>
<?= $Page->BILL_ID_1->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->NO_REGISTRATION_1->Visible) { // NO_REGISTRATION_1 ?>
        <td data-name="NO_REGISTRATION_1" <?= $Page->NO_REGISTRATION_1->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_NO_REGISTRATION_1" class="form-group">
<input type="<?= $Page->NO_REGISTRATION_1->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_NO_REGISTRATION_1" name="x<?= $Page->RowIndex ?>_NO_REGISTRATION_1" id="x<?= $Page->RowIndex ?>_NO_REGISTRATION_1" size="30" maxlength="25" placeholder="<?= HtmlEncode($Page->NO_REGISTRATION_1->getPlaceHolder()) ?>" value="<?= $Page->NO_REGISTRATION_1->EditValue ?>"<?= $Page->NO_REGISTRATION_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->NO_REGISTRATION_1->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_NO_REGISTRATION_1" data-hidden="1" name="o<?= $Page->RowIndex ?>_NO_REGISTRATION_1" id="o<?= $Page->RowIndex ?>_NO_REGISTRATION_1" value="<?= HtmlEncode($Page->NO_REGISTRATION_1->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_NO_REGISTRATION_1" class="form-group">
<input type="<?= $Page->NO_REGISTRATION_1->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_NO_REGISTRATION_1" name="x<?= $Page->RowIndex ?>_NO_REGISTRATION_1" id="x<?= $Page->RowIndex ?>_NO_REGISTRATION_1" size="30" maxlength="25" placeholder="<?= HtmlEncode($Page->NO_REGISTRATION_1->getPlaceHolder()) ?>" value="<?= $Page->NO_REGISTRATION_1->EditValue ?>"<?= $Page->NO_REGISTRATION_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->NO_REGISTRATION_1->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_NO_REGISTRATION_1">
<span<?= $Page->NO_REGISTRATION_1->viewAttributes() ?>>
<?= $Page->NO_REGISTRATION_1->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->VISIT_ID_1->Visible) { // VISIT_ID_1 ?>
        <td data-name="VISIT_ID_1" <?= $Page->VISIT_ID_1->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_VISIT_ID_1" class="form-group">
<input type="<?= $Page->VISIT_ID_1->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_VISIT_ID_1" name="x<?= $Page->RowIndex ?>_VISIT_ID_1" id="x<?= $Page->RowIndex ?>_VISIT_ID_1" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->VISIT_ID_1->getPlaceHolder()) ?>" value="<?= $Page->VISIT_ID_1->EditValue ?>"<?= $Page->VISIT_ID_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->VISIT_ID_1->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_VISIT_ID_1" data-hidden="1" name="o<?= $Page->RowIndex ?>_VISIT_ID_1" id="o<?= $Page->RowIndex ?>_VISIT_ID_1" value="<?= HtmlEncode($Page->VISIT_ID_1->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_VISIT_ID_1" class="form-group">
<input type="<?= $Page->VISIT_ID_1->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_VISIT_ID_1" name="x<?= $Page->RowIndex ?>_VISIT_ID_1" id="x<?= $Page->RowIndex ?>_VISIT_ID_1" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->VISIT_ID_1->getPlaceHolder()) ?>" value="<?= $Page->VISIT_ID_1->EditValue ?>"<?= $Page->VISIT_ID_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->VISIT_ID_1->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_VISIT_ID_1">
<span<?= $Page->VISIT_ID_1->viewAttributes() ?>>
<?= $Page->VISIT_ID_1->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->TARIF_ID_1->Visible) { // TARIF_ID_1 ?>
        <td data-name="TARIF_ID_1" <?= $Page->TARIF_ID_1->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_TARIF_ID_1" class="form-group">
<input type="<?= $Page->TARIF_ID_1->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_TARIF_ID_1" name="x<?= $Page->RowIndex ?>_TARIF_ID_1" id="x<?= $Page->RowIndex ?>_TARIF_ID_1" size="30" maxlength="25" placeholder="<?= HtmlEncode($Page->TARIF_ID_1->getPlaceHolder()) ?>" value="<?= $Page->TARIF_ID_1->EditValue ?>"<?= $Page->TARIF_ID_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->TARIF_ID_1->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_TARIF_ID_1" data-hidden="1" name="o<?= $Page->RowIndex ?>_TARIF_ID_1" id="o<?= $Page->RowIndex ?>_TARIF_ID_1" value="<?= HtmlEncode($Page->TARIF_ID_1->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_TARIF_ID_1" class="form-group">
<input type="<?= $Page->TARIF_ID_1->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_TARIF_ID_1" name="x<?= $Page->RowIndex ?>_TARIF_ID_1" id="x<?= $Page->RowIndex ?>_TARIF_ID_1" size="30" maxlength="25" placeholder="<?= HtmlEncode($Page->TARIF_ID_1->getPlaceHolder()) ?>" value="<?= $Page->TARIF_ID_1->EditValue ?>"<?= $Page->TARIF_ID_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->TARIF_ID_1->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_TARIF_ID_1">
<span<?= $Page->TARIF_ID_1->viewAttributes() ?>>
<?= $Page->TARIF_ID_1->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->CLASS_ID_1->Visible) { // CLASS_ID_1 ?>
        <td data-name="CLASS_ID_1" <?= $Page->CLASS_ID_1->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_CLASS_ID_1" class="form-group">
<input type="<?= $Page->CLASS_ID_1->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_CLASS_ID_1" name="x<?= $Page->RowIndex ?>_CLASS_ID_1" id="x<?= $Page->RowIndex ?>_CLASS_ID_1" size="30" placeholder="<?= HtmlEncode($Page->CLASS_ID_1->getPlaceHolder()) ?>" value="<?= $Page->CLASS_ID_1->EditValue ?>"<?= $Page->CLASS_ID_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->CLASS_ID_1->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_CLASS_ID_1" data-hidden="1" name="o<?= $Page->RowIndex ?>_CLASS_ID_1" id="o<?= $Page->RowIndex ?>_CLASS_ID_1" value="<?= HtmlEncode($Page->CLASS_ID_1->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_CLASS_ID_1" class="form-group">
<input type="<?= $Page->CLASS_ID_1->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_CLASS_ID_1" name="x<?= $Page->RowIndex ?>_CLASS_ID_1" id="x<?= $Page->RowIndex ?>_CLASS_ID_1" size="30" placeholder="<?= HtmlEncode($Page->CLASS_ID_1->getPlaceHolder()) ?>" value="<?= $Page->CLASS_ID_1->EditValue ?>"<?= $Page->CLASS_ID_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->CLASS_ID_1->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_CLASS_ID_1">
<span<?= $Page->CLASS_ID_1->viewAttributes() ?>>
<?= $Page->CLASS_ID_1->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->CLINIC_ID_1->Visible) { // CLINIC_ID_1 ?>
        <td data-name="CLINIC_ID_1" <?= $Page->CLINIC_ID_1->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_CLINIC_ID_1" class="form-group">
<input type="<?= $Page->CLINIC_ID_1->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_CLINIC_ID_1" name="x<?= $Page->RowIndex ?>_CLINIC_ID_1" id="x<?= $Page->RowIndex ?>_CLINIC_ID_1" size="30" maxlength="15" placeholder="<?= HtmlEncode($Page->CLINIC_ID_1->getPlaceHolder()) ?>" value="<?= $Page->CLINIC_ID_1->EditValue ?>"<?= $Page->CLINIC_ID_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->CLINIC_ID_1->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_CLINIC_ID_1" data-hidden="1" name="o<?= $Page->RowIndex ?>_CLINIC_ID_1" id="o<?= $Page->RowIndex ?>_CLINIC_ID_1" value="<?= HtmlEncode($Page->CLINIC_ID_1->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_CLINIC_ID_1" class="form-group">
<input type="<?= $Page->CLINIC_ID_1->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_CLINIC_ID_1" name="x<?= $Page->RowIndex ?>_CLINIC_ID_1" id="x<?= $Page->RowIndex ?>_CLINIC_ID_1" size="30" maxlength="15" placeholder="<?= HtmlEncode($Page->CLINIC_ID_1->getPlaceHolder()) ?>" value="<?= $Page->CLINIC_ID_1->EditValue ?>"<?= $Page->CLINIC_ID_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->CLINIC_ID_1->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_CLINIC_ID_1">
<span<?= $Page->CLINIC_ID_1->viewAttributes() ?>>
<?= $Page->CLINIC_ID_1->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->CLINIC_ID_FROM_1->Visible) { // CLINIC_ID_FROM_1 ?>
        <td data-name="CLINIC_ID_FROM_1" <?= $Page->CLINIC_ID_FROM_1->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_CLINIC_ID_FROM_1" class="form-group">
<input type="<?= $Page->CLINIC_ID_FROM_1->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_CLINIC_ID_FROM_1" name="x<?= $Page->RowIndex ?>_CLINIC_ID_FROM_1" id="x<?= $Page->RowIndex ?>_CLINIC_ID_FROM_1" size="30" maxlength="15" placeholder="<?= HtmlEncode($Page->CLINIC_ID_FROM_1->getPlaceHolder()) ?>" value="<?= $Page->CLINIC_ID_FROM_1->EditValue ?>"<?= $Page->CLINIC_ID_FROM_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->CLINIC_ID_FROM_1->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_CLINIC_ID_FROM_1" data-hidden="1" name="o<?= $Page->RowIndex ?>_CLINIC_ID_FROM_1" id="o<?= $Page->RowIndex ?>_CLINIC_ID_FROM_1" value="<?= HtmlEncode($Page->CLINIC_ID_FROM_1->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_CLINIC_ID_FROM_1" class="form-group">
<input type="<?= $Page->CLINIC_ID_FROM_1->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_CLINIC_ID_FROM_1" name="x<?= $Page->RowIndex ?>_CLINIC_ID_FROM_1" id="x<?= $Page->RowIndex ?>_CLINIC_ID_FROM_1" size="30" maxlength="15" placeholder="<?= HtmlEncode($Page->CLINIC_ID_FROM_1->getPlaceHolder()) ?>" value="<?= $Page->CLINIC_ID_FROM_1->EditValue ?>"<?= $Page->CLINIC_ID_FROM_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->CLINIC_ID_FROM_1->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_CLINIC_ID_FROM_1">
<span<?= $Page->CLINIC_ID_FROM_1->viewAttributes() ?>>
<?= $Page->CLINIC_ID_FROM_1->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->TREATMENT_1->Visible) { // TREATMENT_1 ?>
        <td data-name="TREATMENT_1" <?= $Page->TREATMENT_1->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_TREATMENT_1" class="form-group">
<input type="<?= $Page->TREATMENT_1->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_TREATMENT_1" name="x<?= $Page->RowIndex ?>_TREATMENT_1" id="x<?= $Page->RowIndex ?>_TREATMENT_1" size="30" maxlength="200" placeholder="<?= HtmlEncode($Page->TREATMENT_1->getPlaceHolder()) ?>" value="<?= $Page->TREATMENT_1->EditValue ?>"<?= $Page->TREATMENT_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->TREATMENT_1->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_TREATMENT_1" data-hidden="1" name="o<?= $Page->RowIndex ?>_TREATMENT_1" id="o<?= $Page->RowIndex ?>_TREATMENT_1" value="<?= HtmlEncode($Page->TREATMENT_1->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_TREATMENT_1" class="form-group">
<input type="<?= $Page->TREATMENT_1->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_TREATMENT_1" name="x<?= $Page->RowIndex ?>_TREATMENT_1" id="x<?= $Page->RowIndex ?>_TREATMENT_1" size="30" maxlength="200" placeholder="<?= HtmlEncode($Page->TREATMENT_1->getPlaceHolder()) ?>" value="<?= $Page->TREATMENT_1->EditValue ?>"<?= $Page->TREATMENT_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->TREATMENT_1->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_TREATMENT_1">
<span<?= $Page->TREATMENT_1->viewAttributes() ?>>
<?= $Page->TREATMENT_1->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->TREAT_DATE_1->Visible) { // TREAT_DATE_1 ?>
        <td data-name="TREAT_DATE_1" <?= $Page->TREAT_DATE_1->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_TREAT_DATE_1" class="form-group">
<input type="<?= $Page->TREAT_DATE_1->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_TREAT_DATE_1" name="x<?= $Page->RowIndex ?>_TREAT_DATE_1" id="x<?= $Page->RowIndex ?>_TREAT_DATE_1" placeholder="<?= HtmlEncode($Page->TREAT_DATE_1->getPlaceHolder()) ?>" value="<?= $Page->TREAT_DATE_1->EditValue ?>"<?= $Page->TREAT_DATE_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->TREAT_DATE_1->getErrorMessage() ?></div>
<?php if (!$Page->TREAT_DATE_1->ReadOnly && !$Page->TREAT_DATE_1->Disabled && !isset($Page->TREAT_DATE_1->EditAttrs["readonly"]) && !isset($Page->TREAT_DATE_1->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fTREATMENT_INAPlist", "datetimepicker"], function() {
    ew.createDateTimePicker("fTREATMENT_INAPlist", "x<?= $Page->RowIndex ?>_TREAT_DATE_1", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_TREAT_DATE_1" data-hidden="1" name="o<?= $Page->RowIndex ?>_TREAT_DATE_1" id="o<?= $Page->RowIndex ?>_TREAT_DATE_1" value="<?= HtmlEncode($Page->TREAT_DATE_1->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_TREAT_DATE_1" class="form-group">
<input type="<?= $Page->TREAT_DATE_1->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_TREAT_DATE_1" name="x<?= $Page->RowIndex ?>_TREAT_DATE_1" id="x<?= $Page->RowIndex ?>_TREAT_DATE_1" placeholder="<?= HtmlEncode($Page->TREAT_DATE_1->getPlaceHolder()) ?>" value="<?= $Page->TREAT_DATE_1->EditValue ?>"<?= $Page->TREAT_DATE_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->TREAT_DATE_1->getErrorMessage() ?></div>
<?php if (!$Page->TREAT_DATE_1->ReadOnly && !$Page->TREAT_DATE_1->Disabled && !isset($Page->TREAT_DATE_1->EditAttrs["readonly"]) && !isset($Page->TREAT_DATE_1->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fTREATMENT_INAPlist", "datetimepicker"], function() {
    ew.createDateTimePicker("fTREATMENT_INAPlist", "x<?= $Page->RowIndex ?>_TREAT_DATE_1", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_TREAT_DATE_1">
<span<?= $Page->TREAT_DATE_1->viewAttributes() ?>>
<?= $Page->TREAT_DATE_1->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->QUANTITY_1->Visible) { // QUANTITY_1 ?>
        <td data-name="QUANTITY_1" <?= $Page->QUANTITY_1->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_QUANTITY_1" class="form-group">
<input type="<?= $Page->QUANTITY_1->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_QUANTITY_1" name="x<?= $Page->RowIndex ?>_QUANTITY_1" id="x<?= $Page->RowIndex ?>_QUANTITY_1" size="30" placeholder="<?= HtmlEncode($Page->QUANTITY_1->getPlaceHolder()) ?>" value="<?= $Page->QUANTITY_1->EditValue ?>"<?= $Page->QUANTITY_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->QUANTITY_1->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_QUANTITY_1" data-hidden="1" name="o<?= $Page->RowIndex ?>_QUANTITY_1" id="o<?= $Page->RowIndex ?>_QUANTITY_1" value="<?= HtmlEncode($Page->QUANTITY_1->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_QUANTITY_1" class="form-group">
<input type="<?= $Page->QUANTITY_1->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_QUANTITY_1" name="x<?= $Page->RowIndex ?>_QUANTITY_1" id="x<?= $Page->RowIndex ?>_QUANTITY_1" size="30" placeholder="<?= HtmlEncode($Page->QUANTITY_1->getPlaceHolder()) ?>" value="<?= $Page->QUANTITY_1->EditValue ?>"<?= $Page->QUANTITY_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->QUANTITY_1->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_QUANTITY_1">
<span<?= $Page->QUANTITY_1->viewAttributes() ?>>
<?= $Page->QUANTITY_1->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->MEASURE_ID->Visible) { // MEASURE_ID ?>
        <td data-name="MEASURE_ID" <?= $Page->MEASURE_ID->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_MEASURE_ID" class="form-group">
<input type="<?= $Page->MEASURE_ID->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_MEASURE_ID" name="x<?= $Page->RowIndex ?>_MEASURE_ID" id="x<?= $Page->RowIndex ?>_MEASURE_ID" size="30" placeholder="<?= HtmlEncode($Page->MEASURE_ID->getPlaceHolder()) ?>" value="<?= $Page->MEASURE_ID->EditValue ?>"<?= $Page->MEASURE_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->MEASURE_ID->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_MEASURE_ID" data-hidden="1" name="o<?= $Page->RowIndex ?>_MEASURE_ID" id="o<?= $Page->RowIndex ?>_MEASURE_ID" value="<?= HtmlEncode($Page->MEASURE_ID->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_MEASURE_ID" class="form-group">
<input type="<?= $Page->MEASURE_ID->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_MEASURE_ID" name="x<?= $Page->RowIndex ?>_MEASURE_ID" id="x<?= $Page->RowIndex ?>_MEASURE_ID" size="30" placeholder="<?= HtmlEncode($Page->MEASURE_ID->getPlaceHolder()) ?>" value="<?= $Page->MEASURE_ID->EditValue ?>"<?= $Page->MEASURE_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->MEASURE_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_MEASURE_ID">
<span<?= $Page->MEASURE_ID->viewAttributes() ?>>
<?= $Page->MEASURE_ID->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->MEASURE_ID_1->Visible) { // MEASURE_ID_1 ?>
        <td data-name="MEASURE_ID_1" <?= $Page->MEASURE_ID_1->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_MEASURE_ID_1" class="form-group">
<input type="<?= $Page->MEASURE_ID_1->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_MEASURE_ID_1" name="x<?= $Page->RowIndex ?>_MEASURE_ID_1" id="x<?= $Page->RowIndex ?>_MEASURE_ID_1" size="30" placeholder="<?= HtmlEncode($Page->MEASURE_ID_1->getPlaceHolder()) ?>" value="<?= $Page->MEASURE_ID_1->EditValue ?>"<?= $Page->MEASURE_ID_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->MEASURE_ID_1->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_MEASURE_ID_1" data-hidden="1" name="o<?= $Page->RowIndex ?>_MEASURE_ID_1" id="o<?= $Page->RowIndex ?>_MEASURE_ID_1" value="<?= HtmlEncode($Page->MEASURE_ID_1->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_MEASURE_ID_1" class="form-group">
<input type="<?= $Page->MEASURE_ID_1->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_MEASURE_ID_1" name="x<?= $Page->RowIndex ?>_MEASURE_ID_1" id="x<?= $Page->RowIndex ?>_MEASURE_ID_1" size="30" placeholder="<?= HtmlEncode($Page->MEASURE_ID_1->getPlaceHolder()) ?>" value="<?= $Page->MEASURE_ID_1->EditValue ?>"<?= $Page->MEASURE_ID_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->MEASURE_ID_1->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_MEASURE_ID_1">
<span<?= $Page->MEASURE_ID_1->viewAttributes() ?>>
<?= $Page->MEASURE_ID_1->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->TRANS_ID_1->Visible) { // TRANS_ID_1 ?>
        <td data-name="TRANS_ID_1" <?= $Page->TRANS_ID_1->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_TRANS_ID_1" class="form-group">
<input type="<?= $Page->TRANS_ID_1->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_TRANS_ID_1" name="x<?= $Page->RowIndex ?>_TRANS_ID_1" id="x<?= $Page->RowIndex ?>_TRANS_ID_1" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->TRANS_ID_1->getPlaceHolder()) ?>" value="<?= $Page->TRANS_ID_1->EditValue ?>"<?= $Page->TRANS_ID_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->TRANS_ID_1->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_TRANS_ID_1" data-hidden="1" name="o<?= $Page->RowIndex ?>_TRANS_ID_1" id="o<?= $Page->RowIndex ?>_TRANS_ID_1" value="<?= HtmlEncode($Page->TRANS_ID_1->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_TRANS_ID_1" class="form-group">
<input type="<?= $Page->TRANS_ID_1->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_TRANS_ID_1" name="x<?= $Page->RowIndex ?>_TRANS_ID_1" id="x<?= $Page->RowIndex ?>_TRANS_ID_1" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->TRANS_ID_1->getPlaceHolder()) ?>" value="<?= $Page->TRANS_ID_1->EditValue ?>"<?= $Page->TRANS_ID_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->TRANS_ID_1->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_TREATMENT_INAP_TRANS_ID_1">
<span<?= $Page->TRANS_ID_1->viewAttributes() ?>>
<?= $Page->TRANS_ID_1->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
    </tr>
<?php if ($Page->RowType == ROWTYPE_ADD || $Page->RowType == ROWTYPE_EDIT) { ?>
<script>
loadjs.ready(["fTREATMENT_INAPlist","load"], function () {
    fTREATMENT_INAPlist.updateLists(<?= $Page->RowIndex ?>);
});
</script>
<?php } ?>
<?php
    }
    } // End delete row checking
    if (!$Page->isGridAdd())
        if (!$Page->Recordset->EOF) {
            $Page->Recordset->moveNext();
        }
}
?>
<?php
    if ($Page->isGridAdd() || $Page->isGridEdit()) {
        $Page->RowIndex = '$rowindex$';
        $Page->loadRowValues();

        // Set row properties
        $Page->resetAttributes();
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowIndex, "id" => "r0_TREATMENT_INAP", "data-rowtype" => ROWTYPE_ADD]);
        $Page->RowAttrs->appendClass("ew-template");
        $Page->RowType = ROWTYPE_ADD;

        // Render row
        $Page->renderRow();

        // Render list options
        $Page->renderListOptions();
        $Page->StartRowCount = 0;
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowIndex);
?>
    <?php if ($Page->NO_REGISTRATION->Visible) { // NO_REGISTRATION ?>
        <td data-name="NO_REGISTRATION">
<?php if ($Page->NO_REGISTRATION->getSessionValue() != "") { ?>
<span id="el$rowindex$_TREATMENT_INAP_NO_REGISTRATION" class="form-group TREATMENT_INAP_NO_REGISTRATION">
<span<?= $Page->NO_REGISTRATION->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->NO_REGISTRATION->getDisplayValue($Page->NO_REGISTRATION->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_NO_REGISTRATION" name="x<?= $Page->RowIndex ?>_NO_REGISTRATION" value="<?= HtmlEncode($Page->NO_REGISTRATION->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_TREATMENT_INAP_NO_REGISTRATION" class="form-group TREATMENT_INAP_NO_REGISTRATION">
<div class="input-group ew-lookup-list">
    <div class="form-control ew-lookup-text" tabindex="-1" id="lu_x<?= $Page->RowIndex ?>_NO_REGISTRATION"><?= EmptyValue(strval($Page->NO_REGISTRATION->ViewValue)) ? $Language->phrase("PleaseSelect") : $Page->NO_REGISTRATION->ViewValue ?></div>
    <div class="input-group-append">
        <button type="button" title="<?= HtmlEncode(str_replace("%s", RemoveHtml($Page->NO_REGISTRATION->caption()), $Language->phrase("LookupLink", true))) ?>" class="ew-lookup-btn btn btn-default"<?= ($Page->NO_REGISTRATION->ReadOnly || $Page->NO_REGISTRATION->Disabled) ? " disabled" : "" ?> onclick="ew.modalLookupShow({lnk:this,el:'x<?= $Page->RowIndex ?>_NO_REGISTRATION',m:0,n:10});"><i class="fas fa-search ew-icon"></i></button>
    </div>
</div>
<div class="invalid-feedback"><?= $Page->NO_REGISTRATION->getErrorMessage() ?></div>
<?= $Page->NO_REGISTRATION->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_NO_REGISTRATION") ?>
<input type="hidden" is="selection-list" data-table="TREATMENT_INAP" data-field="x_NO_REGISTRATION" data-type="text" data-multiple="0" data-lookup="1" data-value-separator="<?= $Page->NO_REGISTRATION->displayValueSeparatorAttribute() ?>" name="x<?= $Page->RowIndex ?>_NO_REGISTRATION" id="x<?= $Page->RowIndex ?>_NO_REGISTRATION" value="<?= $Page->NO_REGISTRATION->CurrentValue ?>"<?= $Page->NO_REGISTRATION->editAttributes() ?>>
</span>
<?php } ?>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_NO_REGISTRATION" data-hidden="1" name="o<?= $Page->RowIndex ?>_NO_REGISTRATION" id="o<?= $Page->RowIndex ?>_NO_REGISTRATION" value="<?= HtmlEncode($Page->NO_REGISTRATION->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->VISIT_ID->Visible) { // VISIT_ID ?>
        <td data-name="VISIT_ID">
<?php if ($Page->VISIT_ID->getSessionValue() != "") { ?>
<input type="hidden" id="x<?= $Page->RowIndex ?>_VISIT_ID" name="x<?= $Page->RowIndex ?>_VISIT_ID" value="<?= HtmlEncode($Page->VISIT_ID->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_TREATMENT_INAP_VISIT_ID" class="form-group TREATMENT_INAP_VISIT_ID">
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_VISIT_ID" data-hidden="1" name="x<?= $Page->RowIndex ?>_VISIT_ID" id="x<?= $Page->RowIndex ?>_VISIT_ID" value="<?= HtmlEncode($Page->VISIT_ID->CurrentValue) ?>">
</span>
<?php } ?>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_VISIT_ID" data-hidden="1" name="o<?= $Page->RowIndex ?>_VISIT_ID" id="o<?= $Page->RowIndex ?>_VISIT_ID" value="<?= HtmlEncode($Page->VISIT_ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->TARIF_ID->Visible) { // TARIF_ID ?>
        <td data-name="TARIF_ID">
<span id="el$rowindex$_TREATMENT_INAP_TARIF_ID" class="form-group TREATMENT_INAP_TARIF_ID">
<?php $Page->TARIF_ID->EditAttrs->prepend("onchange", "ew.autoFill(this);"); ?>
<div class="input-group ew-lookup-list">
    <div class="form-control ew-lookup-text" tabindex="-1" id="lu_x<?= $Page->RowIndex ?>_TARIF_ID"><?= EmptyValue(strval($Page->TARIF_ID->ViewValue)) ? $Language->phrase("PleaseSelect") : $Page->TARIF_ID->ViewValue ?></div>
    <div class="input-group-append">
        <button type="button" title="<?= HtmlEncode(str_replace("%s", RemoveHtml($Page->TARIF_ID->caption()), $Language->phrase("LookupLink", true))) ?>" class="ew-lookup-btn btn btn-default"<?= ($Page->TARIF_ID->ReadOnly || $Page->TARIF_ID->Disabled) ? " disabled" : "" ?> onclick="ew.modalLookupShow({lnk:this,el:'x<?= $Page->RowIndex ?>_TARIF_ID',m:0,n:10});"><i class="fas fa-search ew-icon"></i></button>
    </div>
</div>
<div class="invalid-feedback"><?= $Page->TARIF_ID->getErrorMessage() ?></div>
<?= $Page->TARIF_ID->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_TARIF_ID") ?>
<input type="hidden" is="selection-list" data-table="TREATMENT_INAP" data-field="x_TARIF_ID" data-type="text" data-multiple="0" data-lookup="1" data-value-separator="<?= $Page->TARIF_ID->displayValueSeparatorAttribute() ?>" name="x<?= $Page->RowIndex ?>_TARIF_ID" id="x<?= $Page->RowIndex ?>_TARIF_ID" value="<?= $Page->TARIF_ID->CurrentValue ?>"<?= $Page->TARIF_ID->editAttributes() ?>>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_TARIF_ID" data-hidden="1" name="o<?= $Page->RowIndex ?>_TARIF_ID" id="o<?= $Page->RowIndex ?>_TARIF_ID" value="<?= HtmlEncode($Page->TARIF_ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->CLINIC_ID->Visible) { // CLINIC_ID ?>
        <td data-name="CLINIC_ID">
<span id="el$rowindex$_TREATMENT_INAP_CLINIC_ID" class="form-group TREATMENT_INAP_CLINIC_ID">
    <select
        id="x<?= $Page->RowIndex ?>_CLINIC_ID"
        name="x<?= $Page->RowIndex ?>_CLINIC_ID"
        class="form-control ew-select<?= $Page->CLINIC_ID->isInvalidClass() ?>"
        data-select2-id="TREATMENT_INAP_x<?= $Page->RowIndex ?>_CLINIC_ID"
        data-table="TREATMENT_INAP"
        data-field="x_CLINIC_ID"
        data-value-separator="<?= $Page->CLINIC_ID->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->CLINIC_ID->getPlaceHolder()) ?>"
        <?= $Page->CLINIC_ID->editAttributes() ?>>
        <?= $Page->CLINIC_ID->selectOptionListHtml("x{$Page->RowIndex}_CLINIC_ID") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->CLINIC_ID->getErrorMessage() ?></div>
<?= $Page->CLINIC_ID->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_CLINIC_ID") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='TREATMENT_INAP_x<?= $Page->RowIndex ?>_CLINIC_ID']"),
        options = { name: "x<?= $Page->RowIndex ?>_CLINIC_ID", selectId: "TREATMENT_INAP_x<?= $Page->RowIndex ?>_CLINIC_ID", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.TREATMENT_INAP.fields.CLINIC_ID.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_CLINIC_ID" data-hidden="1" name="o<?= $Page->RowIndex ?>_CLINIC_ID" id="o<?= $Page->RowIndex ?>_CLINIC_ID" value="<?= HtmlEncode($Page->CLINIC_ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->TREATMENT->Visible) { // TREATMENT ?>
        <td data-name="TREATMENT">
<span id="el$rowindex$_TREATMENT_INAP_TREATMENT" class="form-group TREATMENT_INAP_TREATMENT">
<input type="<?= $Page->TREATMENT->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_TREATMENT" name="x<?= $Page->RowIndex ?>_TREATMENT" id="x<?= $Page->RowIndex ?>_TREATMENT" size="30" maxlength="200" placeholder="<?= HtmlEncode($Page->TREATMENT->getPlaceHolder()) ?>" value="<?= $Page->TREATMENT->EditValue ?>"<?= $Page->TREATMENT->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->TREATMENT->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_TREATMENT" data-hidden="1" name="o<?= $Page->RowIndex ?>_TREATMENT" id="o<?= $Page->RowIndex ?>_TREATMENT" value="<?= HtmlEncode($Page->TREATMENT->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->TREAT_DATE->Visible) { // TREAT_DATE ?>
        <td data-name="TREAT_DATE">
<span id="el$rowindex$_TREATMENT_INAP_TREAT_DATE" class="form-group TREATMENT_INAP_TREAT_DATE">
<input type="<?= $Page->TREAT_DATE->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_TREAT_DATE" data-format="11" name="x<?= $Page->RowIndex ?>_TREAT_DATE" id="x<?= $Page->RowIndex ?>_TREAT_DATE" placeholder="<?= HtmlEncode($Page->TREAT_DATE->getPlaceHolder()) ?>" value="<?= $Page->TREAT_DATE->EditValue ?>"<?= $Page->TREAT_DATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->TREAT_DATE->getErrorMessage() ?></div>
<?php if (!$Page->TREAT_DATE->ReadOnly && !$Page->TREAT_DATE->Disabled && !isset($Page->TREAT_DATE->EditAttrs["readonly"]) && !isset($Page->TREAT_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fTREATMENT_INAPlist", "datetimepicker"], function() {
    ew.createDateTimePicker("fTREATMENT_INAPlist", "x<?= $Page->RowIndex ?>_TREAT_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":11});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_TREAT_DATE" data-hidden="1" name="o<?= $Page->RowIndex ?>_TREAT_DATE" id="o<?= $Page->RowIndex ?>_TREAT_DATE" value="<?= HtmlEncode($Page->TREAT_DATE->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->QUANTITY->Visible) { // QUANTITY ?>
        <td data-name="QUANTITY">
<span id="el$rowindex$_TREATMENT_INAP_QUANTITY" class="form-group TREATMENT_INAP_QUANTITY">
<input type="<?= $Page->QUANTITY->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_QUANTITY" name="x<?= $Page->RowIndex ?>_QUANTITY" id="x<?= $Page->RowIndex ?>_QUANTITY" size="30" placeholder="<?= HtmlEncode($Page->QUANTITY->getPlaceHolder()) ?>" value="<?= $Page->QUANTITY->EditValue ?>"<?= $Page->QUANTITY->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->QUANTITY->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_QUANTITY" data-hidden="1" name="o<?= $Page->RowIndex ?>_QUANTITY" id="o<?= $Page->RowIndex ?>_QUANTITY" value="<?= HtmlEncode($Page->QUANTITY->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->TRANS_ID->Visible) { // TRANS_ID ?>
        <td data-name="TRANS_ID">
<?php if ($Page->TRANS_ID->getSessionValue() != "") { ?>
<span id="el$rowindex$_TREATMENT_INAP_TRANS_ID" class="form-group TREATMENT_INAP_TRANS_ID">
<span<?= $Page->TRANS_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->TRANS_ID->getDisplayValue($Page->TRANS_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_TRANS_ID" name="x<?= $Page->RowIndex ?>_TRANS_ID" value="<?= HtmlEncode($Page->TRANS_ID->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_TREATMENT_INAP_TRANS_ID" class="form-group TREATMENT_INAP_TRANS_ID">
<input type="<?= $Page->TRANS_ID->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_TRANS_ID" name="x<?= $Page->RowIndex ?>_TRANS_ID" id="x<?= $Page->RowIndex ?>_TRANS_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->TRANS_ID->getPlaceHolder()) ?>" value="<?= $Page->TRANS_ID->EditValue ?>"<?= $Page->TRANS_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->TRANS_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_TRANS_ID" data-hidden="1" name="o<?= $Page->RowIndex ?>_TRANS_ID" id="o<?= $Page->RowIndex ?>_TRANS_ID" value="<?= HtmlEncode($Page->TRANS_ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->ID->Visible) { // ID ?>
        <td data-name="ID">
<span id="el$rowindex$_TREATMENT_INAP_ID" class="form-group TREATMENT_INAP_ID"></span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_ID" data-hidden="1" name="o<?= $Page->RowIndex ?>_ID" id="o<?= $Page->RowIndex ?>_ID" value="<?= HtmlEncode($Page->ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->AMOUNT->Visible) { // AMOUNT ?>
        <td data-name="AMOUNT">
<span id="el$rowindex$_TREATMENT_INAP_AMOUNT" class="form-group TREATMENT_INAP_AMOUNT">
<input type="<?= $Page->AMOUNT->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_AMOUNT" name="x<?= $Page->RowIndex ?>_AMOUNT" id="x<?= $Page->RowIndex ?>_AMOUNT" size="30" placeholder="<?= HtmlEncode($Page->AMOUNT->getPlaceHolder()) ?>" value="<?= $Page->AMOUNT->EditValue ?>"<?= $Page->AMOUNT->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->AMOUNT->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_AMOUNT" data-hidden="1" name="o<?= $Page->RowIndex ?>_AMOUNT" id="o<?= $Page->RowIndex ?>_AMOUNT" value="<?= HtmlEncode($Page->AMOUNT->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->POKOK_JUAL->Visible) { // POKOK_JUAL ?>
        <td data-name="POKOK_JUAL">
<span id="el$rowindex$_TREATMENT_INAP_POKOK_JUAL" class="form-group TREATMENT_INAP_POKOK_JUAL">
<input type="<?= $Page->POKOK_JUAL->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_POKOK_JUAL" name="x<?= $Page->RowIndex ?>_POKOK_JUAL" id="x<?= $Page->RowIndex ?>_POKOK_JUAL" size="30" placeholder="<?= HtmlEncode($Page->POKOK_JUAL->getPlaceHolder()) ?>" value="<?= $Page->POKOK_JUAL->EditValue ?>"<?= $Page->POKOK_JUAL->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->POKOK_JUAL->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_POKOK_JUAL" data-hidden="1" name="o<?= $Page->RowIndex ?>_POKOK_JUAL" id="o<?= $Page->RowIndex ?>_POKOK_JUAL" value="<?= HtmlEncode($Page->POKOK_JUAL->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->PPN->Visible) { // PPN ?>
        <td data-name="PPN">
<span id="el$rowindex$_TREATMENT_INAP_PPN" class="form-group TREATMENT_INAP_PPN">
<input type="<?= $Page->PPN->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_PPN" name="x<?= $Page->RowIndex ?>_PPN" id="x<?= $Page->RowIndex ?>_PPN" size="30" placeholder="<?= HtmlEncode($Page->PPN->getPlaceHolder()) ?>" value="<?= $Page->PPN->EditValue ?>"<?= $Page->PPN->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->PPN->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_PPN" data-hidden="1" name="o<?= $Page->RowIndex ?>_PPN" id="o<?= $Page->RowIndex ?>_PPN" value="<?= HtmlEncode($Page->PPN->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->SUBSIDI->Visible) { // SUBSIDI ?>
        <td data-name="SUBSIDI">
<span id="el$rowindex$_TREATMENT_INAP_SUBSIDI" class="form-group TREATMENT_INAP_SUBSIDI">
<input type="<?= $Page->SUBSIDI->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_SUBSIDI" name="x<?= $Page->RowIndex ?>_SUBSIDI" id="x<?= $Page->RowIndex ?>_SUBSIDI" size="30" placeholder="<?= HtmlEncode($Page->SUBSIDI->getPlaceHolder()) ?>" value="<?= $Page->SUBSIDI->EditValue ?>"<?= $Page->SUBSIDI->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->SUBSIDI->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_SUBSIDI" data-hidden="1" name="o<?= $Page->RowIndex ?>_SUBSIDI" id="o<?= $Page->RowIndex ?>_SUBSIDI" value="<?= HtmlEncode($Page->SUBSIDI->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->PRINT_DATE->Visible) { // PRINT_DATE ?>
        <td data-name="PRINT_DATE">
<span id="el$rowindex$_TREATMENT_INAP_PRINT_DATE" class="form-group TREATMENT_INAP_PRINT_DATE">
<input type="<?= $Page->PRINT_DATE->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_PRINT_DATE" name="x<?= $Page->RowIndex ?>_PRINT_DATE" id="x<?= $Page->RowIndex ?>_PRINT_DATE" placeholder="<?= HtmlEncode($Page->PRINT_DATE->getPlaceHolder()) ?>" value="<?= $Page->PRINT_DATE->EditValue ?>"<?= $Page->PRINT_DATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->PRINT_DATE->getErrorMessage() ?></div>
<?php if (!$Page->PRINT_DATE->ReadOnly && !$Page->PRINT_DATE->Disabled && !isset($Page->PRINT_DATE->EditAttrs["readonly"]) && !isset($Page->PRINT_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fTREATMENT_INAPlist", "datetimepicker"], function() {
    ew.createDateTimePicker("fTREATMENT_INAPlist", "x<?= $Page->RowIndex ?>_PRINT_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_PRINT_DATE" data-hidden="1" name="o<?= $Page->RowIndex ?>_PRINT_DATE" id="o<?= $Page->RowIndex ?>_PRINT_DATE" value="<?= HtmlEncode($Page->PRINT_DATE->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->ISCETAK->Visible) { // ISCETAK ?>
        <td data-name="ISCETAK">
<span id="el$rowindex$_TREATMENT_INAP_ISCETAK" class="form-group TREATMENT_INAP_ISCETAK">
<input type="<?= $Page->ISCETAK->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_ISCETAK" name="x<?= $Page->RowIndex ?>_ISCETAK" id="x<?= $Page->RowIndex ?>_ISCETAK" size="30" maxlength="1" placeholder="<?= HtmlEncode($Page->ISCETAK->getPlaceHolder()) ?>" value="<?= $Page->ISCETAK->EditValue ?>"<?= $Page->ISCETAK->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->ISCETAK->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_ISCETAK" data-hidden="1" name="o<?= $Page->RowIndex ?>_ISCETAK" id="o<?= $Page->RowIndex ?>_ISCETAK" value="<?= HtmlEncode($Page->ISCETAK->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->NOTA_NO->Visible) { // NOTA_NO ?>
        <td data-name="NOTA_NO">
<span id="el$rowindex$_TREATMENT_INAP_NOTA_NO" class="form-group TREATMENT_INAP_NOTA_NO">
<input type="<?= $Page->NOTA_NO->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_NOTA_NO" name="x<?= $Page->RowIndex ?>_NOTA_NO" id="x<?= $Page->RowIndex ?>_NOTA_NO" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->NOTA_NO->getPlaceHolder()) ?>" value="<?= $Page->NOTA_NO->EditValue ?>"<?= $Page->NOTA_NO->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->NOTA_NO->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_NOTA_NO" data-hidden="1" name="o<?= $Page->RowIndex ?>_NOTA_NO" id="o<?= $Page->RowIndex ?>_NOTA_NO" value="<?= HtmlEncode($Page->NOTA_NO->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->KUITANSI_ID->Visible) { // KUITANSI_ID ?>
        <td data-name="KUITANSI_ID">
<span id="el$rowindex$_TREATMENT_INAP_KUITANSI_ID" class="form-group TREATMENT_INAP_KUITANSI_ID">
<input type="<?= $Page->KUITANSI_ID->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_KUITANSI_ID" name="x<?= $Page->RowIndex ?>_KUITANSI_ID" id="x<?= $Page->RowIndex ?>_KUITANSI_ID" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->KUITANSI_ID->getPlaceHolder()) ?>" value="<?= $Page->KUITANSI_ID->EditValue ?>"<?= $Page->KUITANSI_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->KUITANSI_ID->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_KUITANSI_ID" data-hidden="1" name="o<?= $Page->RowIndex ?>_KUITANSI_ID" id="o<?= $Page->RowIndex ?>_KUITANSI_ID" value="<?= HtmlEncode($Page->KUITANSI_ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->amount_paid->Visible) { // amount_paid ?>
        <td data-name="amount_paid">
<span id="el$rowindex$_TREATMENT_INAP_amount_paid" class="form-group TREATMENT_INAP_amount_paid">
<input type="<?= $Page->amount_paid->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_amount_paid" name="x<?= $Page->RowIndex ?>_amount_paid" id="x<?= $Page->RowIndex ?>_amount_paid" size="30" placeholder="<?= HtmlEncode($Page->amount_paid->getPlaceHolder()) ?>" value="<?= $Page->amount_paid->EditValue ?>"<?= $Page->amount_paid->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->amount_paid->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_amount_paid" data-hidden="1" name="o<?= $Page->RowIndex ?>_amount_paid" id="o<?= $Page->RowIndex ?>_amount_paid" value="<?= HtmlEncode($Page->amount_paid->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->sell_price->Visible) { // sell_price ?>
        <td data-name="sell_price">
<span id="el$rowindex$_TREATMENT_INAP_sell_price" class="form-group TREATMENT_INAP_sell_price">
<input type="<?= $Page->sell_price->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_sell_price" name="x<?= $Page->RowIndex ?>_sell_price" id="x<?= $Page->RowIndex ?>_sell_price" size="30" placeholder="<?= HtmlEncode($Page->sell_price->getPlaceHolder()) ?>" value="<?= $Page->sell_price->EditValue ?>"<?= $Page->sell_price->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->sell_price->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_sell_price" data-hidden="1" name="o<?= $Page->RowIndex ?>_sell_price" id="o<?= $Page->RowIndex ?>_sell_price" value="<?= HtmlEncode($Page->sell_price->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->diskon->Visible) { // diskon ?>
        <td data-name="diskon">
<span id="el$rowindex$_TREATMENT_INAP_diskon" class="form-group TREATMENT_INAP_diskon">
<input type="<?= $Page->diskon->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_diskon" name="x<?= $Page->RowIndex ?>_diskon" id="x<?= $Page->RowIndex ?>_diskon" size="30" placeholder="<?= HtmlEncode($Page->diskon->getPlaceHolder()) ?>" value="<?= $Page->diskon->EditValue ?>"<?= $Page->diskon->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->diskon->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_diskon" data-hidden="1" name="o<?= $Page->RowIndex ?>_diskon" id="o<?= $Page->RowIndex ?>_diskon" value="<?= HtmlEncode($Page->diskon->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->TAGIHAN->Visible) { // TAGIHAN ?>
        <td data-name="TAGIHAN">
<span id="el$rowindex$_TREATMENT_INAP_TAGIHAN" class="form-group TREATMENT_INAP_TAGIHAN">
<input type="<?= $Page->TAGIHAN->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_TAGIHAN" name="x<?= $Page->RowIndex ?>_TAGIHAN" id="x<?= $Page->RowIndex ?>_TAGIHAN" size="30" placeholder="<?= HtmlEncode($Page->TAGIHAN->getPlaceHolder()) ?>" value="<?= $Page->TAGIHAN->EditValue ?>"<?= $Page->TAGIHAN->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->TAGIHAN->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_TAGIHAN" data-hidden="1" name="o<?= $Page->RowIndex ?>_TAGIHAN" id="o<?= $Page->RowIndex ?>_TAGIHAN" value="<?= HtmlEncode($Page->TAGIHAN->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->CLINIC_TYPE->Visible) { // CLINIC_TYPE ?>
        <td data-name="CLINIC_TYPE">
<span id="el$rowindex$_TREATMENT_INAP_CLINIC_TYPE" class="form-group TREATMENT_INAP_CLINIC_TYPE">
<input type="<?= $Page->CLINIC_TYPE->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_CLINIC_TYPE" name="x<?= $Page->RowIndex ?>_CLINIC_TYPE" id="x<?= $Page->RowIndex ?>_CLINIC_TYPE" size="30" placeholder="<?= HtmlEncode($Page->CLINIC_TYPE->getPlaceHolder()) ?>" value="<?= $Page->CLINIC_TYPE->EditValue ?>"<?= $Page->CLINIC_TYPE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->CLINIC_TYPE->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_CLINIC_TYPE" data-hidden="1" name="o<?= $Page->RowIndex ?>_CLINIC_TYPE" id="o<?= $Page->RowIndex ?>_CLINIC_TYPE" value="<?= HtmlEncode($Page->CLINIC_TYPE->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->ID_1->Visible) { // ID_1 ?>
        <td data-name="ID_1">
<span id="el$rowindex$_TREATMENT_INAP_ID_1" class="form-group TREATMENT_INAP_ID_1"></span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_ID_1" data-hidden="1" name="o<?= $Page->RowIndex ?>_ID_1" id="o<?= $Page->RowIndex ?>_ID_1" value="<?= HtmlEncode($Page->ID_1->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->ORG_UNIT_CODE->Visible) { // ORG_UNIT_CODE ?>
        <td data-name="ORG_UNIT_CODE">
<span id="el$rowindex$_TREATMENT_INAP_ORG_UNIT_CODE" class="form-group TREATMENT_INAP_ORG_UNIT_CODE">
<input type="<?= $Page->ORG_UNIT_CODE->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_ORG_UNIT_CODE" name="x<?= $Page->RowIndex ?>_ORG_UNIT_CODE" id="x<?= $Page->RowIndex ?>_ORG_UNIT_CODE" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->ORG_UNIT_CODE->getPlaceHolder()) ?>" value="<?= $Page->ORG_UNIT_CODE->EditValue ?>"<?= $Page->ORG_UNIT_CODE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->ORG_UNIT_CODE->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_ORG_UNIT_CODE" data-hidden="1" name="o<?= $Page->RowIndex ?>_ORG_UNIT_CODE" id="o<?= $Page->RowIndex ?>_ORG_UNIT_CODE" value="<?= HtmlEncode($Page->ORG_UNIT_CODE->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->BILL_ID_1->Visible) { // BILL_ID_1 ?>
        <td data-name="BILL_ID_1">
<span id="el$rowindex$_TREATMENT_INAP_BILL_ID_1" class="form-group TREATMENT_INAP_BILL_ID_1">
<input type="<?= $Page->BILL_ID_1->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_BILL_ID_1" name="x<?= $Page->RowIndex ?>_BILL_ID_1" id="x<?= $Page->RowIndex ?>_BILL_ID_1" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->BILL_ID_1->getPlaceHolder()) ?>" value="<?= $Page->BILL_ID_1->EditValue ?>"<?= $Page->BILL_ID_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->BILL_ID_1->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_BILL_ID_1" data-hidden="1" name="o<?= $Page->RowIndex ?>_BILL_ID_1" id="o<?= $Page->RowIndex ?>_BILL_ID_1" value="<?= HtmlEncode($Page->BILL_ID_1->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->NO_REGISTRATION_1->Visible) { // NO_REGISTRATION_1 ?>
        <td data-name="NO_REGISTRATION_1">
<span id="el$rowindex$_TREATMENT_INAP_NO_REGISTRATION_1" class="form-group TREATMENT_INAP_NO_REGISTRATION_1">
<input type="<?= $Page->NO_REGISTRATION_1->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_NO_REGISTRATION_1" name="x<?= $Page->RowIndex ?>_NO_REGISTRATION_1" id="x<?= $Page->RowIndex ?>_NO_REGISTRATION_1" size="30" maxlength="25" placeholder="<?= HtmlEncode($Page->NO_REGISTRATION_1->getPlaceHolder()) ?>" value="<?= $Page->NO_REGISTRATION_1->EditValue ?>"<?= $Page->NO_REGISTRATION_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->NO_REGISTRATION_1->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_NO_REGISTRATION_1" data-hidden="1" name="o<?= $Page->RowIndex ?>_NO_REGISTRATION_1" id="o<?= $Page->RowIndex ?>_NO_REGISTRATION_1" value="<?= HtmlEncode($Page->NO_REGISTRATION_1->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->VISIT_ID_1->Visible) { // VISIT_ID_1 ?>
        <td data-name="VISIT_ID_1">
<span id="el$rowindex$_TREATMENT_INAP_VISIT_ID_1" class="form-group TREATMENT_INAP_VISIT_ID_1">
<input type="<?= $Page->VISIT_ID_1->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_VISIT_ID_1" name="x<?= $Page->RowIndex ?>_VISIT_ID_1" id="x<?= $Page->RowIndex ?>_VISIT_ID_1" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->VISIT_ID_1->getPlaceHolder()) ?>" value="<?= $Page->VISIT_ID_1->EditValue ?>"<?= $Page->VISIT_ID_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->VISIT_ID_1->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_VISIT_ID_1" data-hidden="1" name="o<?= $Page->RowIndex ?>_VISIT_ID_1" id="o<?= $Page->RowIndex ?>_VISIT_ID_1" value="<?= HtmlEncode($Page->VISIT_ID_1->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->TARIF_ID_1->Visible) { // TARIF_ID_1 ?>
        <td data-name="TARIF_ID_1">
<span id="el$rowindex$_TREATMENT_INAP_TARIF_ID_1" class="form-group TREATMENT_INAP_TARIF_ID_1">
<input type="<?= $Page->TARIF_ID_1->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_TARIF_ID_1" name="x<?= $Page->RowIndex ?>_TARIF_ID_1" id="x<?= $Page->RowIndex ?>_TARIF_ID_1" size="30" maxlength="25" placeholder="<?= HtmlEncode($Page->TARIF_ID_1->getPlaceHolder()) ?>" value="<?= $Page->TARIF_ID_1->EditValue ?>"<?= $Page->TARIF_ID_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->TARIF_ID_1->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_TARIF_ID_1" data-hidden="1" name="o<?= $Page->RowIndex ?>_TARIF_ID_1" id="o<?= $Page->RowIndex ?>_TARIF_ID_1" value="<?= HtmlEncode($Page->TARIF_ID_1->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->CLASS_ID_1->Visible) { // CLASS_ID_1 ?>
        <td data-name="CLASS_ID_1">
<span id="el$rowindex$_TREATMENT_INAP_CLASS_ID_1" class="form-group TREATMENT_INAP_CLASS_ID_1">
<input type="<?= $Page->CLASS_ID_1->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_CLASS_ID_1" name="x<?= $Page->RowIndex ?>_CLASS_ID_1" id="x<?= $Page->RowIndex ?>_CLASS_ID_1" size="30" placeholder="<?= HtmlEncode($Page->CLASS_ID_1->getPlaceHolder()) ?>" value="<?= $Page->CLASS_ID_1->EditValue ?>"<?= $Page->CLASS_ID_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->CLASS_ID_1->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_CLASS_ID_1" data-hidden="1" name="o<?= $Page->RowIndex ?>_CLASS_ID_1" id="o<?= $Page->RowIndex ?>_CLASS_ID_1" value="<?= HtmlEncode($Page->CLASS_ID_1->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->CLINIC_ID_1->Visible) { // CLINIC_ID_1 ?>
        <td data-name="CLINIC_ID_1">
<span id="el$rowindex$_TREATMENT_INAP_CLINIC_ID_1" class="form-group TREATMENT_INAP_CLINIC_ID_1">
<input type="<?= $Page->CLINIC_ID_1->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_CLINIC_ID_1" name="x<?= $Page->RowIndex ?>_CLINIC_ID_1" id="x<?= $Page->RowIndex ?>_CLINIC_ID_1" size="30" maxlength="15" placeholder="<?= HtmlEncode($Page->CLINIC_ID_1->getPlaceHolder()) ?>" value="<?= $Page->CLINIC_ID_1->EditValue ?>"<?= $Page->CLINIC_ID_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->CLINIC_ID_1->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_CLINIC_ID_1" data-hidden="1" name="o<?= $Page->RowIndex ?>_CLINIC_ID_1" id="o<?= $Page->RowIndex ?>_CLINIC_ID_1" value="<?= HtmlEncode($Page->CLINIC_ID_1->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->CLINIC_ID_FROM_1->Visible) { // CLINIC_ID_FROM_1 ?>
        <td data-name="CLINIC_ID_FROM_1">
<span id="el$rowindex$_TREATMENT_INAP_CLINIC_ID_FROM_1" class="form-group TREATMENT_INAP_CLINIC_ID_FROM_1">
<input type="<?= $Page->CLINIC_ID_FROM_1->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_CLINIC_ID_FROM_1" name="x<?= $Page->RowIndex ?>_CLINIC_ID_FROM_1" id="x<?= $Page->RowIndex ?>_CLINIC_ID_FROM_1" size="30" maxlength="15" placeholder="<?= HtmlEncode($Page->CLINIC_ID_FROM_1->getPlaceHolder()) ?>" value="<?= $Page->CLINIC_ID_FROM_1->EditValue ?>"<?= $Page->CLINIC_ID_FROM_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->CLINIC_ID_FROM_1->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_CLINIC_ID_FROM_1" data-hidden="1" name="o<?= $Page->RowIndex ?>_CLINIC_ID_FROM_1" id="o<?= $Page->RowIndex ?>_CLINIC_ID_FROM_1" value="<?= HtmlEncode($Page->CLINIC_ID_FROM_1->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->TREATMENT_1->Visible) { // TREATMENT_1 ?>
        <td data-name="TREATMENT_1">
<span id="el$rowindex$_TREATMENT_INAP_TREATMENT_1" class="form-group TREATMENT_INAP_TREATMENT_1">
<input type="<?= $Page->TREATMENT_1->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_TREATMENT_1" name="x<?= $Page->RowIndex ?>_TREATMENT_1" id="x<?= $Page->RowIndex ?>_TREATMENT_1" size="30" maxlength="200" placeholder="<?= HtmlEncode($Page->TREATMENT_1->getPlaceHolder()) ?>" value="<?= $Page->TREATMENT_1->EditValue ?>"<?= $Page->TREATMENT_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->TREATMENT_1->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_TREATMENT_1" data-hidden="1" name="o<?= $Page->RowIndex ?>_TREATMENT_1" id="o<?= $Page->RowIndex ?>_TREATMENT_1" value="<?= HtmlEncode($Page->TREATMENT_1->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->TREAT_DATE_1->Visible) { // TREAT_DATE_1 ?>
        <td data-name="TREAT_DATE_1">
<span id="el$rowindex$_TREATMENT_INAP_TREAT_DATE_1" class="form-group TREATMENT_INAP_TREAT_DATE_1">
<input type="<?= $Page->TREAT_DATE_1->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_TREAT_DATE_1" name="x<?= $Page->RowIndex ?>_TREAT_DATE_1" id="x<?= $Page->RowIndex ?>_TREAT_DATE_1" placeholder="<?= HtmlEncode($Page->TREAT_DATE_1->getPlaceHolder()) ?>" value="<?= $Page->TREAT_DATE_1->EditValue ?>"<?= $Page->TREAT_DATE_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->TREAT_DATE_1->getErrorMessage() ?></div>
<?php if (!$Page->TREAT_DATE_1->ReadOnly && !$Page->TREAT_DATE_1->Disabled && !isset($Page->TREAT_DATE_1->EditAttrs["readonly"]) && !isset($Page->TREAT_DATE_1->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fTREATMENT_INAPlist", "datetimepicker"], function() {
    ew.createDateTimePicker("fTREATMENT_INAPlist", "x<?= $Page->RowIndex ?>_TREAT_DATE_1", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_TREAT_DATE_1" data-hidden="1" name="o<?= $Page->RowIndex ?>_TREAT_DATE_1" id="o<?= $Page->RowIndex ?>_TREAT_DATE_1" value="<?= HtmlEncode($Page->TREAT_DATE_1->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->QUANTITY_1->Visible) { // QUANTITY_1 ?>
        <td data-name="QUANTITY_1">
<span id="el$rowindex$_TREATMENT_INAP_QUANTITY_1" class="form-group TREATMENT_INAP_QUANTITY_1">
<input type="<?= $Page->QUANTITY_1->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_QUANTITY_1" name="x<?= $Page->RowIndex ?>_QUANTITY_1" id="x<?= $Page->RowIndex ?>_QUANTITY_1" size="30" placeholder="<?= HtmlEncode($Page->QUANTITY_1->getPlaceHolder()) ?>" value="<?= $Page->QUANTITY_1->EditValue ?>"<?= $Page->QUANTITY_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->QUANTITY_1->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_QUANTITY_1" data-hidden="1" name="o<?= $Page->RowIndex ?>_QUANTITY_1" id="o<?= $Page->RowIndex ?>_QUANTITY_1" value="<?= HtmlEncode($Page->QUANTITY_1->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->MEASURE_ID->Visible) { // MEASURE_ID ?>
        <td data-name="MEASURE_ID">
<span id="el$rowindex$_TREATMENT_INAP_MEASURE_ID" class="form-group TREATMENT_INAP_MEASURE_ID">
<input type="<?= $Page->MEASURE_ID->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_MEASURE_ID" name="x<?= $Page->RowIndex ?>_MEASURE_ID" id="x<?= $Page->RowIndex ?>_MEASURE_ID" size="30" placeholder="<?= HtmlEncode($Page->MEASURE_ID->getPlaceHolder()) ?>" value="<?= $Page->MEASURE_ID->EditValue ?>"<?= $Page->MEASURE_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->MEASURE_ID->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_MEASURE_ID" data-hidden="1" name="o<?= $Page->RowIndex ?>_MEASURE_ID" id="o<?= $Page->RowIndex ?>_MEASURE_ID" value="<?= HtmlEncode($Page->MEASURE_ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->MEASURE_ID_1->Visible) { // MEASURE_ID_1 ?>
        <td data-name="MEASURE_ID_1">
<span id="el$rowindex$_TREATMENT_INAP_MEASURE_ID_1" class="form-group TREATMENT_INAP_MEASURE_ID_1">
<input type="<?= $Page->MEASURE_ID_1->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_MEASURE_ID_1" name="x<?= $Page->RowIndex ?>_MEASURE_ID_1" id="x<?= $Page->RowIndex ?>_MEASURE_ID_1" size="30" placeholder="<?= HtmlEncode($Page->MEASURE_ID_1->getPlaceHolder()) ?>" value="<?= $Page->MEASURE_ID_1->EditValue ?>"<?= $Page->MEASURE_ID_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->MEASURE_ID_1->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_MEASURE_ID_1" data-hidden="1" name="o<?= $Page->RowIndex ?>_MEASURE_ID_1" id="o<?= $Page->RowIndex ?>_MEASURE_ID_1" value="<?= HtmlEncode($Page->MEASURE_ID_1->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->TRANS_ID_1->Visible) { // TRANS_ID_1 ?>
        <td data-name="TRANS_ID_1">
<span id="el$rowindex$_TREATMENT_INAP_TRANS_ID_1" class="form-group TREATMENT_INAP_TRANS_ID_1">
<input type="<?= $Page->TRANS_ID_1->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_TRANS_ID_1" name="x<?= $Page->RowIndex ?>_TRANS_ID_1" id="x<?= $Page->RowIndex ?>_TRANS_ID_1" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->TRANS_ID_1->getPlaceHolder()) ?>" value="<?= $Page->TRANS_ID_1->EditValue ?>"<?= $Page->TRANS_ID_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->TRANS_ID_1->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_TRANS_ID_1" data-hidden="1" name="o<?= $Page->RowIndex ?>_TRANS_ID_1" id="o<?= $Page->RowIndex ?>_TRANS_ID_1" value="<?= HtmlEncode($Page->TRANS_ID_1->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowIndex);
?>
<script>
loadjs.ready(["fTREATMENT_INAPlist","load"], function() {
    fTREATMENT_INAPlist.updateLists(<?= $Page->RowIndex ?>);
});
</script>
    </tr>
<?php
    }
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
<?php if ($Page->isGridAdd()) { ?>
<input type="hidden" name="action" id="action" value="gridinsert">
<input type="hidden" name="<?= $Page->FormKeyCountName ?>" id="<?= $Page->FormKeyCountName ?>" value="<?= $Page->KeyCount ?>">
<?= $Page->MultiSelectKey ?>
<?php } ?>
<?php if ($Page->isGridEdit()) { ?>
<input type="hidden" name="action" id="action" value="gridupdate">
<input type="hidden" name="<?= $Page->FormKeyCountName ?>" id="<?= $Page->FormKeyCountName ?>" value="<?= $Page->KeyCount ?>">
<?= $Page->MultiSelectKey ?>
<?php } ?>
<?php if (!$Page->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</form><!-- /.ew-list-form -->
<?php
// Close recordset
if ($Page->Recordset) {
    $Page->Recordset->close();
}
?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($Page->TotalRecords == 0 && !$Page->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
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
