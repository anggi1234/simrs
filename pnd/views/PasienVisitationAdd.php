<?php

namespace PHPMaker2021\SIMRSSQLSERVERPENDAFTARAN;

// Page object
$PasienVisitationAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fPASIEN_VISITATIONadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fPASIEN_VISITATIONadd = currentForm = new ew.Form("fPASIEN_VISITATIONadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "PASIEN_VISITATION")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.PASIEN_VISITATION)
        ew.vars.tables.PASIEN_VISITATION = currentTable;
    fPASIEN_VISITATIONadd.addFields([
        ["NO_REGISTRATION", [fields.NO_REGISTRATION.visible && fields.NO_REGISTRATION.required ? ew.Validators.required(fields.NO_REGISTRATION.caption) : null], fields.NO_REGISTRATION.isInvalid],
        ["DIANTAR_OLEH", [fields.DIANTAR_OLEH.visible && fields.DIANTAR_OLEH.required ? ew.Validators.required(fields.DIANTAR_OLEH.caption) : null], fields.DIANTAR_OLEH.isInvalid],
        ["STATUS_PASIEN_ID", [fields.STATUS_PASIEN_ID.visible && fields.STATUS_PASIEN_ID.required ? ew.Validators.required(fields.STATUS_PASIEN_ID.caption) : null], fields.STATUS_PASIEN_ID.isInvalid],
        ["RUJUKAN_ID", [fields.RUJUKAN_ID.visible && fields.RUJUKAN_ID.required ? ew.Validators.required(fields.RUJUKAN_ID.caption) : null], fields.RUJUKAN_ID.isInvalid],
        ["REASON_ID", [fields.REASON_ID.visible && fields.REASON_ID.required ? ew.Validators.required(fields.REASON_ID.caption) : null], fields.REASON_ID.isInvalid],
        ["WAY_ID", [fields.WAY_ID.visible && fields.WAY_ID.required ? ew.Validators.required(fields.WAY_ID.caption) : null], fields.WAY_ID.isInvalid],
        ["BOOKED_DATE", [fields.BOOKED_DATE.visible && fields.BOOKED_DATE.required ? ew.Validators.required(fields.BOOKED_DATE.caption) : null], fields.BOOKED_DATE.isInvalid],
        ["VISIT_DATE", [fields.VISIT_DATE.visible && fields.VISIT_DATE.required ? ew.Validators.required(fields.VISIT_DATE.caption) : null, ew.Validators.datetime(11)], fields.VISIT_DATE.isInvalid],
        ["CLINIC_ID", [fields.CLINIC_ID.visible && fields.CLINIC_ID.required ? ew.Validators.required(fields.CLINIC_ID.caption) : null], fields.CLINIC_ID.isInvalid],
        ["GENDER", [fields.GENDER.visible && fields.GENDER.required ? ew.Validators.required(fields.GENDER.caption) : null], fields.GENDER.isInvalid],
        ["EMPLOYEE_ID", [fields.EMPLOYEE_ID.visible && fields.EMPLOYEE_ID.required ? ew.Validators.required(fields.EMPLOYEE_ID.caption) : null], fields.EMPLOYEE_ID.isInvalid],
        ["PAYOR_ID", [fields.PAYOR_ID.visible && fields.PAYOR_ID.required ? ew.Validators.required(fields.PAYOR_ID.caption) : null], fields.PAYOR_ID.isInvalid],
        ["CLASS_ID", [fields.CLASS_ID.visible && fields.CLASS_ID.required ? ew.Validators.required(fields.CLASS_ID.caption) : null], fields.CLASS_ID.isInvalid],
        ["COVERAGE_ID", [fields.COVERAGE_ID.visible && fields.COVERAGE_ID.required ? ew.Validators.required(fields.COVERAGE_ID.caption) : null], fields.COVERAGE_ID.isInvalid],
        ["NO_SKP", [fields.NO_SKP.visible && fields.NO_SKP.required ? ew.Validators.required(fields.NO_SKP.caption) : null], fields.NO_SKP.isInvalid],
        ["NO_SKPINAP", [fields.NO_SKPINAP.visible && fields.NO_SKPINAP.required ? ew.Validators.required(fields.NO_SKPINAP.caption) : null], fields.NO_SKPINAP.isInvalid],
        ["ISRJ", [fields.ISRJ.visible && fields.ISRJ.required ? ew.Validators.required(fields.ISRJ.caption) : null], fields.ISRJ.isInvalid],
        ["NORUJUKAN", [fields.NORUJUKAN.visible && fields.NORUJUKAN.required ? ew.Validators.required(fields.NORUJUKAN.caption) : null], fields.NORUJUKAN.isInvalid],
        ["PPKRUJUKAN", [fields.PPKRUJUKAN.visible && fields.PPKRUJUKAN.required ? ew.Validators.required(fields.PPKRUJUKAN.caption) : null], fields.PPKRUJUKAN.isInvalid],
        ["EDIT_SEP", [fields.EDIT_SEP.visible && fields.EDIT_SEP.required ? ew.Validators.required(fields.EDIT_SEP.caption) : null], fields.EDIT_SEP.isInvalid],
        ["DIAG_AWAL", [fields.DIAG_AWAL.visible && fields.DIAG_AWAL.required ? ew.Validators.required(fields.DIAG_AWAL.caption) : null], fields.DIAG_AWAL.isInvalid],
        ["COB", [fields.COB.visible && fields.COB.required ? ew.Validators.required(fields.COB.caption) : null], fields.COB.isInvalid],
        ["ASALRUJUKAN", [fields.ASALRUJUKAN.visible && fields.ASALRUJUKAN.required ? ew.Validators.required(fields.ASALRUJUKAN.caption) : null], fields.ASALRUJUKAN.isInvalid],
        ["tgl_kontrol", [fields.tgl_kontrol.visible && fields.tgl_kontrol.required ? ew.Validators.required(fields.tgl_kontrol.caption) : null, ew.Validators.datetime(0)], fields.tgl_kontrol.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fPASIEN_VISITATIONadd,
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
    fPASIEN_VISITATIONadd.validate = function () {
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

            // Validate fields
            if (!this.validateFields(rowIndex))
                return false;

            // Call Form_CustomValidate event
            if (!this.customValidate(fobj)) {
                this.focus();
                return false;
            }
        }

        // Process detail forms
        var dfs = $fobj.find("input[name='detailpage']").get();
        for (var i = 0; i < dfs.length; i++) {
            var df = dfs[i],
                val = df.value,
                frm = ew.forms.get(val);
            if (val && frm && !frm.validate())
                return false;
        }
        return true;
    }

    // Form_CustomValidate
    fPASIEN_VISITATIONadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fPASIEN_VISITATIONadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fPASIEN_VISITATIONadd.lists.NO_REGISTRATION = <?= $Page->NO_REGISTRATION->toClientList($Page) ?>;
    fPASIEN_VISITATIONadd.lists.STATUS_PASIEN_ID = <?= $Page->STATUS_PASIEN_ID->toClientList($Page) ?>;
    fPASIEN_VISITATIONadd.lists.RUJUKAN_ID = <?= $Page->RUJUKAN_ID->toClientList($Page) ?>;
    fPASIEN_VISITATIONadd.lists.REASON_ID = <?= $Page->REASON_ID->toClientList($Page) ?>;
    fPASIEN_VISITATIONadd.lists.WAY_ID = <?= $Page->WAY_ID->toClientList($Page) ?>;
    fPASIEN_VISITATIONadd.lists.CLINIC_ID = <?= $Page->CLINIC_ID->toClientList($Page) ?>;
    fPASIEN_VISITATIONadd.lists.GENDER = <?= $Page->GENDER->toClientList($Page) ?>;
    fPASIEN_VISITATIONadd.lists.EMPLOYEE_ID = <?= $Page->EMPLOYEE_ID->toClientList($Page) ?>;
    fPASIEN_VISITATIONadd.lists.PAYOR_ID = <?= $Page->PAYOR_ID->toClientList($Page) ?>;
    fPASIEN_VISITATIONadd.lists.CLASS_ID = <?= $Page->CLASS_ID->toClientList($Page) ?>;
    fPASIEN_VISITATIONadd.lists.COVERAGE_ID = <?= $Page->COVERAGE_ID->toClientList($Page) ?>;
    fPASIEN_VISITATIONadd.lists.ISRJ = <?= $Page->ISRJ->toClientList($Page) ?>;
    fPASIEN_VISITATIONadd.lists.PPKRUJUKAN = <?= $Page->PPKRUJUKAN->toClientList($Page) ?>;
    fPASIEN_VISITATIONadd.lists.COB = <?= $Page->COB->toClientList($Page) ?>;
    loadjs.done("fPASIEN_VISITATIONadd");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fPASIEN_VISITATIONadd" id="fPASIEN_VISITATIONadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="PASIEN_VISITATION">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "CV_PASIEN") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="CV_PASIEN">
<input type="hidden" name="fk_NO_REGISTRATION" value="<?= HtmlEncode($Page->NO_REGISTRATION->getSessionValue()) ?>">
<?php } ?>
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->NO_REGISTRATION->Visible) { // NO_REGISTRATION ?>
    <div id="r_NO_REGISTRATION" class="form-group row">
        <label id="elh_PASIEN_VISITATION_NO_REGISTRATION" for="x_NO_REGISTRATION" class="<?= $Page->LeftColumnClass ?>"><?= $Page->NO_REGISTRATION->caption() ?><?= $Page->NO_REGISTRATION->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->NO_REGISTRATION->cellAttributes() ?>>
<?php if ($Page->NO_REGISTRATION->getSessionValue() != "") { ?>
<span id="el_PASIEN_VISITATION_NO_REGISTRATION">
<span<?= $Page->NO_REGISTRATION->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->NO_REGISTRATION->getDisplayValue($Page->NO_REGISTRATION->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x_NO_REGISTRATION" name="x_NO_REGISTRATION" value="<?= HtmlEncode($Page->NO_REGISTRATION->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_PASIEN_VISITATION_NO_REGISTRATION">
<?php $Page->NO_REGISTRATION->EditAttrs->prepend("onchange", "ew.autoFill(this);"); ?>
<div class="input-group ew-lookup-list" aria-describedby="x_NO_REGISTRATION_help">
    <div class="form-control ew-lookup-text" tabindex="-1" id="lu_x_NO_REGISTRATION"><?= EmptyValue(strval($Page->NO_REGISTRATION->ViewValue)) ? $Language->phrase("PleaseSelect") : $Page->NO_REGISTRATION->ViewValue ?></div>
    <div class="input-group-append">
        <button type="button" title="<?= HtmlEncode(str_replace("%s", RemoveHtml($Page->NO_REGISTRATION->caption()), $Language->phrase("LookupLink", true))) ?>" class="ew-lookup-btn btn btn-default"<?= ($Page->NO_REGISTRATION->ReadOnly || $Page->NO_REGISTRATION->Disabled) ? " disabled" : "" ?> onclick="ew.modalLookupShow({lnk:this,el:'x_NO_REGISTRATION',m:0,n:10});"><i class="fas fa-search ew-icon"></i></button>
    </div>
</div>
<div class="invalid-feedback"><?= $Page->NO_REGISTRATION->getErrorMessage() ?></div>
<?= $Page->NO_REGISTRATION->getCustomMessage() ?>
<?= $Page->NO_REGISTRATION->Lookup->getParamTag($Page, "p_x_NO_REGISTRATION") ?>
<input type="hidden" is="selection-list" data-table="PASIEN_VISITATION" data-field="x_NO_REGISTRATION" data-page="1" data-type="text" data-multiple="0" data-lookup="1" data-value-separator="<?= $Page->NO_REGISTRATION->displayValueSeparatorAttribute() ?>" name="x_NO_REGISTRATION" id="x_NO_REGISTRATION" value="<?= $Page->NO_REGISTRATION->CurrentValue ?>"<?= $Page->NO_REGISTRATION->editAttributes() ?>>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->DIANTAR_OLEH->Visible) { // DIANTAR_OLEH ?>
    <div id="r_DIANTAR_OLEH" class="form-group row">
        <label id="elh_PASIEN_VISITATION_DIANTAR_OLEH" for="x_DIANTAR_OLEH" class="<?= $Page->LeftColumnClass ?>"><?= $Page->DIANTAR_OLEH->caption() ?><?= $Page->DIANTAR_OLEH->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->DIANTAR_OLEH->cellAttributes() ?>>
<span id="el_PASIEN_VISITATION_DIANTAR_OLEH">
<input type="<?= $Page->DIANTAR_OLEH->getInputTextType() ?>" data-table="PASIEN_VISITATION" data-field="x_DIANTAR_OLEH" data-page="1" name="x_DIANTAR_OLEH" id="x_DIANTAR_OLEH" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->DIANTAR_OLEH->getPlaceHolder()) ?>" value="<?= $Page->DIANTAR_OLEH->EditValue ?>"<?= $Page->DIANTAR_OLEH->editAttributes() ?> aria-describedby="x_DIANTAR_OLEH_help">
<?= $Page->DIANTAR_OLEH->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->DIANTAR_OLEH->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->STATUS_PASIEN_ID->Visible) { // STATUS_PASIEN_ID ?>
    <div id="r_STATUS_PASIEN_ID" class="form-group row">
        <label id="elh_PASIEN_VISITATION_STATUS_PASIEN_ID" for="x_STATUS_PASIEN_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->STATUS_PASIEN_ID->caption() ?><?= $Page->STATUS_PASIEN_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->STATUS_PASIEN_ID->cellAttributes() ?>>
<span id="el_PASIEN_VISITATION_STATUS_PASIEN_ID">
<?php $Page->STATUS_PASIEN_ID->EditAttrs->prepend("onchange", "ew.autoFill(this);"); ?>
    <select
        id="x_STATUS_PASIEN_ID"
        name="x_STATUS_PASIEN_ID"
        class="form-control ew-select<?= $Page->STATUS_PASIEN_ID->isInvalidClass() ?>"
        data-select2-id="PASIEN_VISITATION_x_STATUS_PASIEN_ID"
        data-table="PASIEN_VISITATION"
        data-field="x_STATUS_PASIEN_ID"
        data-page="1"
        data-value-separator="<?= $Page->STATUS_PASIEN_ID->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->STATUS_PASIEN_ID->getPlaceHolder()) ?>"
        <?= $Page->STATUS_PASIEN_ID->editAttributes() ?>>
        <?= $Page->STATUS_PASIEN_ID->selectOptionListHtml("x_STATUS_PASIEN_ID") ?>
    </select>
    <?= $Page->STATUS_PASIEN_ID->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->STATUS_PASIEN_ID->getErrorMessage() ?></div>
<?= $Page->STATUS_PASIEN_ID->Lookup->getParamTag($Page, "p_x_STATUS_PASIEN_ID") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='PASIEN_VISITATION_x_STATUS_PASIEN_ID']"),
        options = { name: "x_STATUS_PASIEN_ID", selectId: "PASIEN_VISITATION_x_STATUS_PASIEN_ID", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.PASIEN_VISITATION.fields.STATUS_PASIEN_ID.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->RUJUKAN_ID->Visible) { // RUJUKAN_ID ?>
    <div id="r_RUJUKAN_ID" class="form-group row">
        <label id="elh_PASIEN_VISITATION_RUJUKAN_ID" for="x_RUJUKAN_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->RUJUKAN_ID->caption() ?><?= $Page->RUJUKAN_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->RUJUKAN_ID->cellAttributes() ?>>
<span id="el_PASIEN_VISITATION_RUJUKAN_ID">
    <select
        id="x_RUJUKAN_ID"
        name="x_RUJUKAN_ID"
        class="form-control ew-select<?= $Page->RUJUKAN_ID->isInvalidClass() ?>"
        data-select2-id="PASIEN_VISITATION_x_RUJUKAN_ID"
        data-table="PASIEN_VISITATION"
        data-field="x_RUJUKAN_ID"
        data-page="1"
        data-value-separator="<?= $Page->RUJUKAN_ID->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->RUJUKAN_ID->getPlaceHolder()) ?>"
        <?= $Page->RUJUKAN_ID->editAttributes() ?>>
        <?= $Page->RUJUKAN_ID->selectOptionListHtml("x_RUJUKAN_ID") ?>
    </select>
    <?= $Page->RUJUKAN_ID->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->RUJUKAN_ID->getErrorMessage() ?></div>
<?= $Page->RUJUKAN_ID->Lookup->getParamTag($Page, "p_x_RUJUKAN_ID") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='PASIEN_VISITATION_x_RUJUKAN_ID']"),
        options = { name: "x_RUJUKAN_ID", selectId: "PASIEN_VISITATION_x_RUJUKAN_ID", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.PASIEN_VISITATION.fields.RUJUKAN_ID.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->REASON_ID->Visible) { // REASON_ID ?>
    <div id="r_REASON_ID" class="form-group row">
        <label id="elh_PASIEN_VISITATION_REASON_ID" for="x_REASON_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->REASON_ID->caption() ?><?= $Page->REASON_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->REASON_ID->cellAttributes() ?>>
<span id="el_PASIEN_VISITATION_REASON_ID">
    <select
        id="x_REASON_ID"
        name="x_REASON_ID"
        class="form-control ew-select<?= $Page->REASON_ID->isInvalidClass() ?>"
        data-select2-id="PASIEN_VISITATION_x_REASON_ID"
        data-table="PASIEN_VISITATION"
        data-field="x_REASON_ID"
        data-page="1"
        data-value-separator="<?= $Page->REASON_ID->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->REASON_ID->getPlaceHolder()) ?>"
        <?= $Page->REASON_ID->editAttributes() ?>>
        <?= $Page->REASON_ID->selectOptionListHtml("x_REASON_ID") ?>
    </select>
    <?= $Page->REASON_ID->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->REASON_ID->getErrorMessage() ?></div>
<?= $Page->REASON_ID->Lookup->getParamTag($Page, "p_x_REASON_ID") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='PASIEN_VISITATION_x_REASON_ID']"),
        options = { name: "x_REASON_ID", selectId: "PASIEN_VISITATION_x_REASON_ID", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.PASIEN_VISITATION.fields.REASON_ID.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->WAY_ID->Visible) { // WAY_ID ?>
    <div id="r_WAY_ID" class="form-group row">
        <label id="elh_PASIEN_VISITATION_WAY_ID" for="x_WAY_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->WAY_ID->caption() ?><?= $Page->WAY_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->WAY_ID->cellAttributes() ?>>
<span id="el_PASIEN_VISITATION_WAY_ID">
    <select
        id="x_WAY_ID"
        name="x_WAY_ID"
        class="form-control ew-select<?= $Page->WAY_ID->isInvalidClass() ?>"
        data-select2-id="PASIEN_VISITATION_x_WAY_ID"
        data-table="PASIEN_VISITATION"
        data-field="x_WAY_ID"
        data-page="1"
        data-value-separator="<?= $Page->WAY_ID->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->WAY_ID->getPlaceHolder()) ?>"
        <?= $Page->WAY_ID->editAttributes() ?>>
        <?= $Page->WAY_ID->selectOptionListHtml("x_WAY_ID") ?>
    </select>
    <?= $Page->WAY_ID->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->WAY_ID->getErrorMessage() ?></div>
<?= $Page->WAY_ID->Lookup->getParamTag($Page, "p_x_WAY_ID") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='PASIEN_VISITATION_x_WAY_ID']"),
        options = { name: "x_WAY_ID", selectId: "PASIEN_VISITATION_x_WAY_ID", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.PASIEN_VISITATION.fields.WAY_ID.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->VISIT_DATE->Visible) { // VISIT_DATE ?>
    <div id="r_VISIT_DATE" class="form-group row">
        <label id="elh_PASIEN_VISITATION_VISIT_DATE" for="x_VISIT_DATE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->VISIT_DATE->caption() ?><?= $Page->VISIT_DATE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->VISIT_DATE->cellAttributes() ?>>
<span id="el_PASIEN_VISITATION_VISIT_DATE">
<input type="<?= $Page->VISIT_DATE->getInputTextType() ?>" data-table="PASIEN_VISITATION" data-field="x_VISIT_DATE" data-page="1" data-format="11" name="x_VISIT_DATE" id="x_VISIT_DATE" placeholder="<?= HtmlEncode($Page->VISIT_DATE->getPlaceHolder()) ?>" value="<?= $Page->VISIT_DATE->EditValue ?>"<?= $Page->VISIT_DATE->editAttributes() ?> aria-describedby="x_VISIT_DATE_help">
<?= $Page->VISIT_DATE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->VISIT_DATE->getErrorMessage() ?></div>
<?php if (!$Page->VISIT_DATE->ReadOnly && !$Page->VISIT_DATE->Disabled && !isset($Page->VISIT_DATE->EditAttrs["readonly"]) && !isset($Page->VISIT_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fPASIEN_VISITATIONadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fPASIEN_VISITATIONadd", "x_VISIT_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":11});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->CLINIC_ID->Visible) { // CLINIC_ID ?>
    <div id="r_CLINIC_ID" class="form-group row">
        <label id="elh_PASIEN_VISITATION_CLINIC_ID" for="x_CLINIC_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->CLINIC_ID->caption() ?><?= $Page->CLINIC_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->CLINIC_ID->cellAttributes() ?>>
<span id="el_PASIEN_VISITATION_CLINIC_ID">
    <select
        id="x_CLINIC_ID"
        name="x_CLINIC_ID"
        class="form-control ew-select<?= $Page->CLINIC_ID->isInvalidClass() ?>"
        data-select2-id="PASIEN_VISITATION_x_CLINIC_ID"
        data-table="PASIEN_VISITATION"
        data-field="x_CLINIC_ID"
        data-page="1"
        data-value-separator="<?= $Page->CLINIC_ID->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->CLINIC_ID->getPlaceHolder()) ?>"
        <?= $Page->CLINIC_ID->editAttributes() ?>>
        <?= $Page->CLINIC_ID->selectOptionListHtml("x_CLINIC_ID") ?>
    </select>
    <?= $Page->CLINIC_ID->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->CLINIC_ID->getErrorMessage() ?></div>
<?= $Page->CLINIC_ID->Lookup->getParamTag($Page, "p_x_CLINIC_ID") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='PASIEN_VISITATION_x_CLINIC_ID']"),
        options = { name: "x_CLINIC_ID", selectId: "PASIEN_VISITATION_x_CLINIC_ID", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.PASIEN_VISITATION.fields.CLINIC_ID.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->GENDER->Visible) { // GENDER ?>
    <div id="r_GENDER" class="form-group row">
        <label id="elh_PASIEN_VISITATION_GENDER" class="<?= $Page->LeftColumnClass ?>"><?= $Page->GENDER->caption() ?><?= $Page->GENDER->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->GENDER->cellAttributes() ?>>
<span id="el_PASIEN_VISITATION_GENDER">
<template id="tp_x_GENDER">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="PASIEN_VISITATION" data-field="x_GENDER" name="x_GENDER" id="x_GENDER"<?= $Page->GENDER->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x_GENDER" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x_GENDER"
    name="x_GENDER"
    value="<?= HtmlEncode($Page->GENDER->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_GENDER"
    data-target="dsl_x_GENDER"
    data-repeatcolumn="5"
    class="form-control<?= $Page->GENDER->isInvalidClass() ?>"
    data-table="PASIEN_VISITATION"
    data-field="x_GENDER"
    data-page="1"
    data-value-separator="<?= $Page->GENDER->displayValueSeparatorAttribute() ?>"
    <?= $Page->GENDER->editAttributes() ?>>
<?= $Page->GENDER->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->GENDER->getErrorMessage() ?></div>
<?= $Page->GENDER->Lookup->getParamTag($Page, "p_x_GENDER") ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->EMPLOYEE_ID->Visible) { // EMPLOYEE_ID ?>
    <div id="r_EMPLOYEE_ID" class="form-group row">
        <label id="elh_PASIEN_VISITATION_EMPLOYEE_ID" for="x_EMPLOYEE_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->EMPLOYEE_ID->caption() ?><?= $Page->EMPLOYEE_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->EMPLOYEE_ID->cellAttributes() ?>>
<span id="el_PASIEN_VISITATION_EMPLOYEE_ID">
    <select
        id="x_EMPLOYEE_ID"
        name="x_EMPLOYEE_ID"
        class="form-control ew-select<?= $Page->EMPLOYEE_ID->isInvalidClass() ?>"
        data-select2-id="PASIEN_VISITATION_x_EMPLOYEE_ID"
        data-table="PASIEN_VISITATION"
        data-field="x_EMPLOYEE_ID"
        data-page="1"
        data-value-separator="<?= $Page->EMPLOYEE_ID->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->EMPLOYEE_ID->getPlaceHolder()) ?>"
        <?= $Page->EMPLOYEE_ID->editAttributes() ?>>
        <?= $Page->EMPLOYEE_ID->selectOptionListHtml("x_EMPLOYEE_ID") ?>
    </select>
    <?= $Page->EMPLOYEE_ID->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->EMPLOYEE_ID->getErrorMessage() ?></div>
<?= $Page->EMPLOYEE_ID->Lookup->getParamTag($Page, "p_x_EMPLOYEE_ID") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='PASIEN_VISITATION_x_EMPLOYEE_ID']"),
        options = { name: "x_EMPLOYEE_ID", selectId: "PASIEN_VISITATION_x_EMPLOYEE_ID", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.PASIEN_VISITATION.fields.EMPLOYEE_ID.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->PAYOR_ID->Visible) { // PAYOR_ID ?>
    <div id="r_PAYOR_ID" class="form-group row">
        <label id="elh_PASIEN_VISITATION_PAYOR_ID" for="x_PAYOR_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->PAYOR_ID->caption() ?><?= $Page->PAYOR_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PAYOR_ID->cellAttributes() ?>>
<span id="el_PASIEN_VISITATION_PAYOR_ID">
    <select
        id="x_PAYOR_ID"
        name="x_PAYOR_ID"
        class="form-control ew-select<?= $Page->PAYOR_ID->isInvalidClass() ?>"
        data-select2-id="PASIEN_VISITATION_x_PAYOR_ID"
        data-table="PASIEN_VISITATION"
        data-field="x_PAYOR_ID"
        data-page="1"
        data-value-separator="<?= $Page->PAYOR_ID->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->PAYOR_ID->getPlaceHolder()) ?>"
        <?= $Page->PAYOR_ID->editAttributes() ?>>
        <?= $Page->PAYOR_ID->selectOptionListHtml("x_PAYOR_ID") ?>
    </select>
    <?= $Page->PAYOR_ID->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->PAYOR_ID->getErrorMessage() ?></div>
<?= $Page->PAYOR_ID->Lookup->getParamTag($Page, "p_x_PAYOR_ID") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='PASIEN_VISITATION_x_PAYOR_ID']"),
        options = { name: "x_PAYOR_ID", selectId: "PASIEN_VISITATION_x_PAYOR_ID", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.PASIEN_VISITATION.fields.PAYOR_ID.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->CLASS_ID->Visible) { // CLASS_ID ?>
    <div id="r_CLASS_ID" class="form-group row">
        <label id="elh_PASIEN_VISITATION_CLASS_ID" for="x_CLASS_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->CLASS_ID->caption() ?><?= $Page->CLASS_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->CLASS_ID->cellAttributes() ?>>
<span id="el_PASIEN_VISITATION_CLASS_ID">
    <select
        id="x_CLASS_ID"
        name="x_CLASS_ID"
        class="form-control ew-select<?= $Page->CLASS_ID->isInvalidClass() ?>"
        data-select2-id="PASIEN_VISITATION_x_CLASS_ID"
        data-table="PASIEN_VISITATION"
        data-field="x_CLASS_ID"
        data-page="1"
        data-value-separator="<?= $Page->CLASS_ID->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->CLASS_ID->getPlaceHolder()) ?>"
        <?= $Page->CLASS_ID->editAttributes() ?>>
        <?= $Page->CLASS_ID->selectOptionListHtml("x_CLASS_ID") ?>
    </select>
    <?= $Page->CLASS_ID->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->CLASS_ID->getErrorMessage() ?></div>
<?= $Page->CLASS_ID->Lookup->getParamTag($Page, "p_x_CLASS_ID") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='PASIEN_VISITATION_x_CLASS_ID']"),
        options = { name: "x_CLASS_ID", selectId: "PASIEN_VISITATION_x_CLASS_ID", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.PASIEN_VISITATION.fields.CLASS_ID.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->COVERAGE_ID->Visible) { // COVERAGE_ID ?>
    <div id="r_COVERAGE_ID" class="form-group row">
        <label id="elh_PASIEN_VISITATION_COVERAGE_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->COVERAGE_ID->caption() ?><?= $Page->COVERAGE_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->COVERAGE_ID->cellAttributes() ?>>
<span id="el_PASIEN_VISITATION_COVERAGE_ID">
<template id="tp_x_COVERAGE_ID">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="PASIEN_VISITATION" data-field="x_COVERAGE_ID" name="x_COVERAGE_ID" id="x_COVERAGE_ID"<?= $Page->COVERAGE_ID->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x_COVERAGE_ID" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x_COVERAGE_ID"
    name="x_COVERAGE_ID"
    value="<?= HtmlEncode($Page->COVERAGE_ID->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_COVERAGE_ID"
    data-target="dsl_x_COVERAGE_ID"
    data-repeatcolumn="5"
    class="form-control<?= $Page->COVERAGE_ID->isInvalidClass() ?>"
    data-table="PASIEN_VISITATION"
    data-field="x_COVERAGE_ID"
    data-page="1"
    data-value-separator="<?= $Page->COVERAGE_ID->displayValueSeparatorAttribute() ?>"
    <?= $Page->COVERAGE_ID->editAttributes() ?>>
<?= $Page->COVERAGE_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->COVERAGE_ID->getErrorMessage() ?></div>
<?= $Page->COVERAGE_ID->Lookup->getParamTag($Page, "p_x_COVERAGE_ID") ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->NO_SKP->Visible) { // NO_SKP ?>
    <div id="r_NO_SKP" class="form-group row">
        <label id="elh_PASIEN_VISITATION_NO_SKP" for="x_NO_SKP" class="<?= $Page->LeftColumnClass ?>"><?= $Page->NO_SKP->caption() ?><?= $Page->NO_SKP->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->NO_SKP->cellAttributes() ?>>
<span id="el_PASIEN_VISITATION_NO_SKP">
<input type="<?= $Page->NO_SKP->getInputTextType() ?>" data-table="PASIEN_VISITATION" data-field="x_NO_SKP" data-page="1" name="x_NO_SKP" id="x_NO_SKP" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->NO_SKP->getPlaceHolder()) ?>" value="<?= $Page->NO_SKP->EditValue ?>"<?= $Page->NO_SKP->editAttributes() ?> aria-describedby="x_NO_SKP_help">
<?= $Page->NO_SKP->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->NO_SKP->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->NO_SKPINAP->Visible) { // NO_SKPINAP ?>
    <div id="r_NO_SKPINAP" class="form-group row">
        <label id="elh_PASIEN_VISITATION_NO_SKPINAP" for="x_NO_SKPINAP" class="<?= $Page->LeftColumnClass ?>"><?= $Page->NO_SKPINAP->caption() ?><?= $Page->NO_SKPINAP->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->NO_SKPINAP->cellAttributes() ?>>
<span id="el_PASIEN_VISITATION_NO_SKPINAP">
<input type="<?= $Page->NO_SKPINAP->getInputTextType() ?>" data-table="PASIEN_VISITATION" data-field="x_NO_SKPINAP" data-page="1" name="x_NO_SKPINAP" id="x_NO_SKPINAP" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->NO_SKPINAP->getPlaceHolder()) ?>" value="<?= $Page->NO_SKPINAP->EditValue ?>"<?= $Page->NO_SKPINAP->editAttributes() ?> aria-describedby="x_NO_SKPINAP_help">
<?= $Page->NO_SKPINAP->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->NO_SKPINAP->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ISRJ->Visible) { // ISRJ ?>
    <div id="r_ISRJ" class="form-group row">
        <label id="elh_PASIEN_VISITATION_ISRJ" for="x_ISRJ" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ISRJ->caption() ?><?= $Page->ISRJ->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ISRJ->cellAttributes() ?>>
<span id="el_PASIEN_VISITATION_ISRJ">
    <select
        id="x_ISRJ"
        name="x_ISRJ"
        class="form-control ew-select<?= $Page->ISRJ->isInvalidClass() ?>"
        data-select2-id="PASIEN_VISITATION_x_ISRJ"
        data-table="PASIEN_VISITATION"
        data-field="x_ISRJ"
        data-page="1"
        data-value-separator="<?= $Page->ISRJ->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->ISRJ->getPlaceHolder()) ?>"
        <?= $Page->ISRJ->editAttributes() ?>>
        <?= $Page->ISRJ->selectOptionListHtml("x_ISRJ") ?>
    </select>
    <?= $Page->ISRJ->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->ISRJ->getErrorMessage() ?></div>
<?= $Page->ISRJ->Lookup->getParamTag($Page, "p_x_ISRJ") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='PASIEN_VISITATION_x_ISRJ']"),
        options = { name: "x_ISRJ", selectId: "PASIEN_VISITATION_x_ISRJ", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.PASIEN_VISITATION.fields.ISRJ.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->NORUJUKAN->Visible) { // NORUJUKAN ?>
    <div id="r_NORUJUKAN" class="form-group row">
        <label id="elh_PASIEN_VISITATION_NORUJUKAN" for="x_NORUJUKAN" class="<?= $Page->LeftColumnClass ?>"><?= $Page->NORUJUKAN->caption() ?><?= $Page->NORUJUKAN->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->NORUJUKAN->cellAttributes() ?>>
<span id="el_PASIEN_VISITATION_NORUJUKAN">
<input type="<?= $Page->NORUJUKAN->getInputTextType() ?>" data-table="PASIEN_VISITATION" data-field="x_NORUJUKAN" data-page="1" name="x_NORUJUKAN" id="x_NORUJUKAN" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->NORUJUKAN->getPlaceHolder()) ?>" value="<?= $Page->NORUJUKAN->EditValue ?>"<?= $Page->NORUJUKAN->editAttributes() ?> aria-describedby="x_NORUJUKAN_help">
<?= $Page->NORUJUKAN->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->NORUJUKAN->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->PPKRUJUKAN->Visible) { // PPKRUJUKAN ?>
    <div id="r_PPKRUJUKAN" class="form-group row">
        <label id="elh_PASIEN_VISITATION_PPKRUJUKAN" for="x_PPKRUJUKAN" class="<?= $Page->LeftColumnClass ?>"><?= $Page->PPKRUJUKAN->caption() ?><?= $Page->PPKRUJUKAN->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PPKRUJUKAN->cellAttributes() ?>>
<span id="el_PASIEN_VISITATION_PPKRUJUKAN">
<div class="input-group ew-lookup-list" aria-describedby="x_PPKRUJUKAN_help">
    <div class="form-control ew-lookup-text" tabindex="-1" id="lu_x_PPKRUJUKAN"><?= EmptyValue(strval($Page->PPKRUJUKAN->ViewValue)) ? $Language->phrase("PleaseSelect") : $Page->PPKRUJUKAN->ViewValue ?></div>
    <div class="input-group-append">
        <button type="button" title="<?= HtmlEncode(str_replace("%s", RemoveHtml($Page->PPKRUJUKAN->caption()), $Language->phrase("LookupLink", true))) ?>" class="ew-lookup-btn btn btn-default"<?= ($Page->PPKRUJUKAN->ReadOnly || $Page->PPKRUJUKAN->Disabled) ? " disabled" : "" ?> onclick="ew.modalLookupShow({lnk:this,el:'x_PPKRUJUKAN',m:0,n:10});"><i class="fas fa-search ew-icon"></i></button>
    </div>
</div>
<div class="invalid-feedback"><?= $Page->PPKRUJUKAN->getErrorMessage() ?></div>
<?= $Page->PPKRUJUKAN->getCustomMessage() ?>
<?= $Page->PPKRUJUKAN->Lookup->getParamTag($Page, "p_x_PPKRUJUKAN") ?>
<input type="hidden" is="selection-list" data-table="PASIEN_VISITATION" data-field="x_PPKRUJUKAN" data-page="1" data-type="text" data-multiple="0" data-lookup="1" data-value-separator="<?= $Page->PPKRUJUKAN->displayValueSeparatorAttribute() ?>" name="x_PPKRUJUKAN" id="x_PPKRUJUKAN" value="<?= $Page->PPKRUJUKAN->CurrentValue ?>"<?= $Page->PPKRUJUKAN->editAttributes() ?>>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->EDIT_SEP->Visible) { // EDIT_SEP ?>
    <div id="r_EDIT_SEP" class="form-group row">
        <label id="elh_PASIEN_VISITATION_EDIT_SEP" for="x_EDIT_SEP" class="<?= $Page->LeftColumnClass ?>"><?= $Page->EDIT_SEP->caption() ?><?= $Page->EDIT_SEP->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->EDIT_SEP->cellAttributes() ?>>
<span id="el_PASIEN_VISITATION_EDIT_SEP">
<input type="<?= $Page->EDIT_SEP->getInputTextType() ?>" data-table="PASIEN_VISITATION" data-field="x_EDIT_SEP" data-page="1" name="x_EDIT_SEP" id="x_EDIT_SEP" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->EDIT_SEP->getPlaceHolder()) ?>" value="<?= $Page->EDIT_SEP->EditValue ?>"<?= $Page->EDIT_SEP->editAttributes() ?> aria-describedby="x_EDIT_SEP_help">
<?= $Page->EDIT_SEP->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->EDIT_SEP->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->DIAG_AWAL->Visible) { // DIAG_AWAL ?>
    <div id="r_DIAG_AWAL" class="form-group row">
        <label id="elh_PASIEN_VISITATION_DIAG_AWAL" for="x_DIAG_AWAL" class="<?= $Page->LeftColumnClass ?>"><?= $Page->DIAG_AWAL->caption() ?><?= $Page->DIAG_AWAL->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->DIAG_AWAL->cellAttributes() ?>>
<span id="el_PASIEN_VISITATION_DIAG_AWAL">
<input type="<?= $Page->DIAG_AWAL->getInputTextType() ?>" data-table="PASIEN_VISITATION" data-field="x_DIAG_AWAL" data-page="1" name="x_DIAG_AWAL" id="x_DIAG_AWAL" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->DIAG_AWAL->getPlaceHolder()) ?>" value="<?= $Page->DIAG_AWAL->EditValue ?>"<?= $Page->DIAG_AWAL->editAttributes() ?> aria-describedby="x_DIAG_AWAL_help">
<?= $Page->DIAG_AWAL->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->DIAG_AWAL->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->COB->Visible) { // COB ?>
    <div id="r_COB" class="form-group row">
        <label id="elh_PASIEN_VISITATION_COB" class="<?= $Page->LeftColumnClass ?>"><?= $Page->COB->caption() ?><?= $Page->COB->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->COB->cellAttributes() ?>>
<span id="el_PASIEN_VISITATION_COB">
<template id="tp_x_COB">
    <div class="custom-control custom-checkbox">
        <input type="checkbox" class="custom-control-input" data-table="PASIEN_VISITATION" data-field="x_COB" name="x_COB" id="x_COB"<?= $Page->COB->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x_COB" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x_COB[]"
    name="x_COB[]"
    value="<?= HtmlEncode($Page->COB->CurrentValue) ?>"
    data-type="select-multiple"
    data-template="tp_x_COB"
    data-target="dsl_x_COB"
    data-repeatcolumn="5"
    class="form-control<?= $Page->COB->isInvalidClass() ?>"
    data-table="PASIEN_VISITATION"
    data-field="x_COB"
    data-page="1"
    data-value-separator="<?= $Page->COB->displayValueSeparatorAttribute() ?>"
    <?= $Page->COB->editAttributes() ?>>
<?= $Page->COB->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->COB->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ASALRUJUKAN->Visible) { // ASALRUJUKAN ?>
    <div id="r_ASALRUJUKAN" class="form-group row">
        <label id="elh_PASIEN_VISITATION_ASALRUJUKAN" for="x_ASALRUJUKAN" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ASALRUJUKAN->caption() ?><?= $Page->ASALRUJUKAN->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ASALRUJUKAN->cellAttributes() ?>>
<span id="el_PASIEN_VISITATION_ASALRUJUKAN">
<input type="<?= $Page->ASALRUJUKAN->getInputTextType() ?>" data-table="PASIEN_VISITATION" data-field="x_ASALRUJUKAN" data-page="1" name="x_ASALRUJUKAN" id="x_ASALRUJUKAN" size="30" maxlength="1" placeholder="<?= HtmlEncode($Page->ASALRUJUKAN->getPlaceHolder()) ?>" value="<?= $Page->ASALRUJUKAN->EditValue ?>"<?= $Page->ASALRUJUKAN->editAttributes() ?> aria-describedby="x_ASALRUJUKAN_help">
<?= $Page->ASALRUJUKAN->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ASALRUJUKAN->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tgl_kontrol->Visible) { // tgl_kontrol ?>
    <div id="r_tgl_kontrol" class="form-group row">
        <label id="elh_PASIEN_VISITATION_tgl_kontrol" for="x_tgl_kontrol" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tgl_kontrol->caption() ?><?= $Page->tgl_kontrol->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tgl_kontrol->cellAttributes() ?>>
<span id="el_PASIEN_VISITATION_tgl_kontrol">
<input type="<?= $Page->tgl_kontrol->getInputTextType() ?>" data-table="PASIEN_VISITATION" data-field="x_tgl_kontrol" data-page="1" name="x_tgl_kontrol" id="x_tgl_kontrol" placeholder="<?= HtmlEncode($Page->tgl_kontrol->getPlaceHolder()) ?>" value="<?= $Page->tgl_kontrol->EditValue ?>"<?= $Page->tgl_kontrol->editAttributes() ?> aria-describedby="x_tgl_kontrol_help">
<?= $Page->tgl_kontrol->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tgl_kontrol->getErrorMessage() ?></div>
<?php if (!$Page->tgl_kontrol->ReadOnly && !$Page->tgl_kontrol->Disabled && !isset($Page->tgl_kontrol->EditAttrs["readonly"]) && !isset($Page->tgl_kontrol->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fPASIEN_VISITATIONadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fPASIEN_VISITATIONadd", "x_tgl_kontrol", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<?php
    $Page->DetailPages->ValidKeys = explode(",", $Page->getCurrentDetailTable());
    $firstActiveDetailTable = $Page->DetailPages->activePageIndex();
?>
<div class="ew-detail-pages"><!-- detail-pages -->
<div class="ew-nav-tabs" id="Page_details"><!-- tabs -->
    <ul class="<?= $Page->DetailPages->navStyle() ?>"><!-- .nav -->
<?php
    if (in_array("TREATMENT_OBAT", explode(",", $Page->getCurrentDetailTable())) && $TREATMENT_OBAT->DetailAdd) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "TREATMENT_OBAT") {
            $firstActiveDetailTable = "TREATMENT_OBAT";
        }
?>
        <li class="nav-item"><a class="nav-link <?= $Page->DetailPages->pageStyle("TREATMENT_OBAT") ?>" href="#tab_TREATMENT_OBAT" data-toggle="tab"><?= $Language->tablePhrase("TREATMENT_OBAT", "TblCaption") ?></a></li>
<?php
    }
?>
<?php
    if (in_array("TREATMENT_AKOMODASI", explode(",", $Page->getCurrentDetailTable())) && $TREATMENT_AKOMODASI->DetailAdd) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "TREATMENT_AKOMODASI") {
            $firstActiveDetailTable = "TREATMENT_AKOMODASI";
        }
?>
        <li class="nav-item"><a class="nav-link <?= $Page->DetailPages->pageStyle("TREATMENT_AKOMODASI") ?>" href="#tab_TREATMENT_AKOMODASI" data-toggle="tab"><?= $Language->tablePhrase("TREATMENT_AKOMODASI", "TblCaption") ?></a></li>
<?php
    }
?>
<?php
    if (in_array("CV_PASIEN", explode(",", $Page->getCurrentDetailTable())) && $CV_PASIEN->DetailAdd) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "CV_PASIEN") {
            $firstActiveDetailTable = "CV_PASIEN";
        }
?>
        <li class="nav-item"><a class="nav-link <?= $Page->DetailPages->pageStyle("CV_PASIEN") ?>" href="#tab_CV_PASIEN" data-toggle="tab"><?= $Language->tablePhrase("CV_PASIEN", "TblCaption") ?></a></li>
<?php
    }
?>
    </ul><!-- /.nav -->
    <div class="tab-content"><!-- .tab-content -->
<?php
    if (in_array("TREATMENT_OBAT", explode(",", $Page->getCurrentDetailTable())) && $TREATMENT_OBAT->DetailAdd) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "TREATMENT_OBAT") {
            $firstActiveDetailTable = "TREATMENT_OBAT";
        }
?>
        <div class="tab-pane <?= $Page->DetailPages->pageStyle("TREATMENT_OBAT") ?>" id="tab_TREATMENT_OBAT"><!-- page* -->
<?php include_once "TreatmentObatGrid.php" ?>
        </div><!-- /page* -->
<?php } ?>
<?php
    if (in_array("TREATMENT_AKOMODASI", explode(",", $Page->getCurrentDetailTable())) && $TREATMENT_AKOMODASI->DetailAdd) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "TREATMENT_AKOMODASI") {
            $firstActiveDetailTable = "TREATMENT_AKOMODASI";
        }
?>
        <div class="tab-pane <?= $Page->DetailPages->pageStyle("TREATMENT_AKOMODASI") ?>" id="tab_TREATMENT_AKOMODASI"><!-- page* -->
<?php include_once "TreatmentAkomodasiGrid.php" ?>
        </div><!-- /page* -->
<?php } ?>
<?php
    if (in_array("CV_PASIEN", explode(",", $Page->getCurrentDetailTable())) && $CV_PASIEN->DetailAdd) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "CV_PASIEN") {
            $firstActiveDetailTable = "CV_PASIEN";
        }
?>
        <div class="tab-pane <?= $Page->DetailPages->pageStyle("CV_PASIEN") ?>" id="tab_CV_PASIEN"><!-- page* -->
<?php include_once "CvPasienGrid.php" ?>
        </div><!-- /page* -->
<?php } ?>
    </div><!-- /.tab-content -->
</div><!-- /tabs -->
</div><!-- /detail-pages -->
<?php } ?>
<?php if (!$Page->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("AddBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
    </div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("PASIEN_VISITATION");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
