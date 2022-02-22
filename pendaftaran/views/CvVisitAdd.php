<?php

namespace PHPMaker2021\SIMRSSQLSERVER;

// Page object
$CvVisitAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fcv_visitadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fcv_visitadd = currentForm = new ew.Form("fcv_visitadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "cv_visit")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.cv_visit)
        ew.vars.tables.cv_visit = currentTable;
    fcv_visitadd.addFields([
        ["ORG_UNIT_CODE", [fields.ORG_UNIT_CODE.visible && fields.ORG_UNIT_CODE.required ? ew.Validators.required(fields.ORG_UNIT_CODE.caption) : null], fields.ORG_UNIT_CODE.isInvalid],
        ["NO_REGISTRATION", [fields.NO_REGISTRATION.visible && fields.NO_REGISTRATION.required ? ew.Validators.required(fields.NO_REGISTRATION.caption) : null], fields.NO_REGISTRATION.isInvalid],
        ["STATUS_PASIEN_ID", [fields.STATUS_PASIEN_ID.visible && fields.STATUS_PASIEN_ID.required ? ew.Validators.required(fields.STATUS_PASIEN_ID.caption) : null], fields.STATUS_PASIEN_ID.isInvalid],
        ["RUJUKAN_ID", [fields.RUJUKAN_ID.visible && fields.RUJUKAN_ID.required ? ew.Validators.required(fields.RUJUKAN_ID.caption) : null], fields.RUJUKAN_ID.isInvalid],
        ["REASON_ID", [fields.REASON_ID.visible && fields.REASON_ID.required ? ew.Validators.required(fields.REASON_ID.caption) : null], fields.REASON_ID.isInvalid],
        ["WAY_ID", [fields.WAY_ID.visible && fields.WAY_ID.required ? ew.Validators.required(fields.WAY_ID.caption) : null], fields.WAY_ID.isInvalid],
        ["PATIENT_CATEGORY_ID", [fields.PATIENT_CATEGORY_ID.visible && fields.PATIENT_CATEGORY_ID.required ? ew.Validators.required(fields.PATIENT_CATEGORY_ID.caption) : null], fields.PATIENT_CATEGORY_ID.isInvalid],
        ["BOOKED_DATE", [fields.BOOKED_DATE.visible && fields.BOOKED_DATE.required ? ew.Validators.required(fields.BOOKED_DATE.caption) : null, ew.Validators.datetime(11)], fields.BOOKED_DATE.isInvalid],
        ["VISIT_DATE", [fields.VISIT_DATE.visible && fields.VISIT_DATE.required ? ew.Validators.required(fields.VISIT_DATE.caption) : null, ew.Validators.datetime(11)], fields.VISIT_DATE.isInvalid],
        ["ISNEW", [fields.ISNEW.visible && fields.ISNEW.required ? ew.Validators.required(fields.ISNEW.caption) : null], fields.ISNEW.isInvalid],
        ["FOLLOW_UP", [fields.FOLLOW_UP.visible && fields.FOLLOW_UP.required ? ew.Validators.required(fields.FOLLOW_UP.caption) : null], fields.FOLLOW_UP.isInvalid],
        ["PLACE_TYPE", [fields.PLACE_TYPE.visible && fields.PLACE_TYPE.required ? ew.Validators.required(fields.PLACE_TYPE.caption) : null], fields.PLACE_TYPE.isInvalid],
        ["CLINIC_ID", [fields.CLINIC_ID.visible && fields.CLINIC_ID.required ? ew.Validators.required(fields.CLINIC_ID.caption) : null], fields.CLINIC_ID.isInvalid],
        ["CLINIC_ID_FROM", [fields.CLINIC_ID_FROM.visible && fields.CLINIC_ID_FROM.required ? ew.Validators.required(fields.CLINIC_ID_FROM.caption) : null], fields.CLINIC_ID_FROM.isInvalid],
        ["DESCRIPTION", [fields.DESCRIPTION.visible && fields.DESCRIPTION.required ? ew.Validators.required(fields.DESCRIPTION.caption) : null], fields.DESCRIPTION.isInvalid],
        ["MODIFIED_BY", [fields.MODIFIED_BY.visible && fields.MODIFIED_BY.required ? ew.Validators.required(fields.MODIFIED_BY.caption) : null], fields.MODIFIED_BY.isInvalid],
        ["MODIFIED_DATE", [fields.MODIFIED_DATE.visible && fields.MODIFIED_DATE.required ? ew.Validators.required(fields.MODIFIED_DATE.caption) : null], fields.MODIFIED_DATE.isInvalid],
        ["MODIFIED_FROM", [fields.MODIFIED_FROM.visible && fields.MODIFIED_FROM.required ? ew.Validators.required(fields.MODIFIED_FROM.caption) : null], fields.MODIFIED_FROM.isInvalid],
        ["EMPLOYEE_ID", [fields.EMPLOYEE_ID.visible && fields.EMPLOYEE_ID.required ? ew.Validators.required(fields.EMPLOYEE_ID.caption) : null], fields.EMPLOYEE_ID.isInvalid],
        ["RESPONSIBLE_ID", [fields.RESPONSIBLE_ID.visible && fields.RESPONSIBLE_ID.required ? ew.Validators.required(fields.RESPONSIBLE_ID.caption) : null], fields.RESPONSIBLE_ID.isInvalid],
        ["ISPERTARIF", [fields.ISPERTARIF.visible && fields.ISPERTARIF.required ? ew.Validators.required(fields.ISPERTARIF.caption) : null], fields.ISPERTARIF.isInvalid],
        ["CLASS_ID_PLAFOND", [fields.CLASS_ID_PLAFOND.visible && fields.CLASS_ID_PLAFOND.required ? ew.Validators.required(fields.CLASS_ID_PLAFOND.caption) : null], fields.CLASS_ID_PLAFOND.isInvalid],
        ["BACKCHARGE", [fields.BACKCHARGE.visible && fields.BACKCHARGE.required ? ew.Validators.required(fields.BACKCHARGE.caption) : null], fields.BACKCHARGE.isInvalid],
        ["LOCKED", [fields.LOCKED.visible && fields.LOCKED.required ? ew.Validators.required(fields.LOCKED.caption) : null], fields.LOCKED.isInvalid],
        ["tanggal_rujukan", [fields.tanggal_rujukan.visible && fields.tanggal_rujukan.required ? ew.Validators.required(fields.tanggal_rujukan.caption) : null, ew.Validators.datetime(17)], fields.tanggal_rujukan.isInvalid],
        ["ISRJ", [fields.ISRJ.visible && fields.ISRJ.required ? ew.Validators.required(fields.ISRJ.caption) : null], fields.ISRJ.isInvalid],
        ["NORUJUKAN", [fields.NORUJUKAN.visible && fields.NORUJUKAN.required ? ew.Validators.required(fields.NORUJUKAN.caption) : null], fields.NORUJUKAN.isInvalid],
        ["KDPOLI_EKS", [fields.KDPOLI_EKS.visible && fields.KDPOLI_EKS.required ? ew.Validators.required(fields.KDPOLI_EKS.caption) : null], fields.KDPOLI_EKS.isInvalid],
        ["RESPONTGLPLG_DESC", [fields.RESPONTGLPLG_DESC.visible && fields.RESPONTGLPLG_DESC.required ? ew.Validators.required(fields.RESPONTGLPLG_DESC.caption) : null], fields.RESPONTGLPLG_DESC.isInvalid],
        ["CALL_TIMES", [fields.CALL_TIMES.visible && fields.CALL_TIMES.required ? ew.Validators.required(fields.CALL_TIMES.caption) : null], fields.CALL_TIMES.isInvalid],
        ["KDDPJP", [fields.KDDPJP.visible && fields.KDDPJP.required ? ew.Validators.required(fields.KDDPJP.caption) : null], fields.KDDPJP.isInvalid],
        ["tgl_kontrol", [fields.tgl_kontrol.visible && fields.tgl_kontrol.required ? ew.Validators.required(fields.tgl_kontrol.caption) : null, ew.Validators.datetime(0)], fields.tgl_kontrol.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fcv_visitadd,
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
    fcv_visitadd.validate = function () {
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
    fcv_visitadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fcv_visitadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fcv_visitadd.lists.NO_REGISTRATION = <?= $Page->NO_REGISTRATION->toClientList($Page) ?>;
    fcv_visitadd.lists.STATUS_PASIEN_ID = <?= $Page->STATUS_PASIEN_ID->toClientList($Page) ?>;
    fcv_visitadd.lists.REASON_ID = <?= $Page->REASON_ID->toClientList($Page) ?>;
    fcv_visitadd.lists.WAY_ID = <?= $Page->WAY_ID->toClientList($Page) ?>;
    fcv_visitadd.lists.ISNEW = <?= $Page->ISNEW->toClientList($Page) ?>;
    fcv_visitadd.lists.CLINIC_ID = <?= $Page->CLINIC_ID->toClientList($Page) ?>;
    fcv_visitadd.lists.EMPLOYEE_ID = <?= $Page->EMPLOYEE_ID->toClientList($Page) ?>;
    fcv_visitadd.lists.KDPOLI_EKS = <?= $Page->KDPOLI_EKS->toClientList($Page) ?>;
    fcv_visitadd.lists.RESPONTGLPLG_DESC = <?= $Page->RESPONTGLPLG_DESC->toClientList($Page) ?>;
    loadjs.done("fcv_visitadd");
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
<form name="fcv_visitadd" id="fcv_visitadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="cv_visit">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
    <span id="el_cv_visit_ORG_UNIT_CODE">
    <input type="hidden" data-table="cv_visit" data-field="x_ORG_UNIT_CODE" data-hidden="1" data-page="1" name="x_ORG_UNIT_CODE" id="x_ORG_UNIT_CODE" value="<?= HtmlEncode($Page->ORG_UNIT_CODE->CurrentValue) ?>">
    </span>
<?php if ($Page->NO_REGISTRATION->Visible) { // NO_REGISTRATION ?>
    <div id="r_NO_REGISTRATION" class="form-group row">
        <label id="elh_cv_visit_NO_REGISTRATION" for="x_NO_REGISTRATION" class="<?= $Page->LeftColumnClass ?>"><?= $Page->NO_REGISTRATION->caption() ?><?= $Page->NO_REGISTRATION->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->NO_REGISTRATION->cellAttributes() ?>>
<span id="el_cv_visit_NO_REGISTRATION">
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
<input type="hidden" is="selection-list" data-table="cv_visit" data-field="x_NO_REGISTRATION" data-page="1" data-type="text" data-multiple="0" data-lookup="1" data-value-separator="<?= $Page->NO_REGISTRATION->displayValueSeparatorAttribute() ?>" name="x_NO_REGISTRATION" id="x_NO_REGISTRATION" value="<?= $Page->NO_REGISTRATION->CurrentValue ?>"<?= $Page->NO_REGISTRATION->editAttributes() ?>>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->STATUS_PASIEN_ID->Visible) { // STATUS_PASIEN_ID ?>
    <div id="r_STATUS_PASIEN_ID" class="form-group row">
        <label id="elh_cv_visit_STATUS_PASIEN_ID" for="x_STATUS_PASIEN_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->STATUS_PASIEN_ID->caption() ?><?= $Page->STATUS_PASIEN_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->STATUS_PASIEN_ID->cellAttributes() ?>>
<span id="el_cv_visit_STATUS_PASIEN_ID">
<?php $Page->STATUS_PASIEN_ID->EditAttrs->prepend("onchange", "ew.autoFill(this);"); ?>
    <select
        id="x_STATUS_PASIEN_ID"
        name="x_STATUS_PASIEN_ID"
        class="form-control ew-select<?= $Page->STATUS_PASIEN_ID->isInvalidClass() ?>"
        data-select2-id="cv_visit_x_STATUS_PASIEN_ID"
        data-table="cv_visit"
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
    var el = document.querySelector("select[data-select2-id='cv_visit_x_STATUS_PASIEN_ID']"),
        options = { name: "x_STATUS_PASIEN_ID", selectId: "cv_visit_x_STATUS_PASIEN_ID", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.cv_visit.fields.STATUS_PASIEN_ID.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
    <span id="el_cv_visit_RUJUKAN_ID">
    <input type="hidden" data-table="cv_visit" data-field="x_RUJUKAN_ID" data-hidden="1" data-page="1" name="x_RUJUKAN_ID" id="x_RUJUKAN_ID" value="<?= HtmlEncode($Page->RUJUKAN_ID->CurrentValue) ?>">
    </span>
<?php if ($Page->REASON_ID->Visible) { // REASON_ID ?>
    <div id="r_REASON_ID" class="form-group row">
        <label id="elh_cv_visit_REASON_ID" for="x_REASON_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->REASON_ID->caption() ?><?= $Page->REASON_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->REASON_ID->cellAttributes() ?>>
<span id="el_cv_visit_REASON_ID">
    <select
        id="x_REASON_ID"
        name="x_REASON_ID"
        class="form-control ew-select<?= $Page->REASON_ID->isInvalidClass() ?>"
        data-select2-id="cv_visit_x_REASON_ID"
        data-table="cv_visit"
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
    var el = document.querySelector("select[data-select2-id='cv_visit_x_REASON_ID']"),
        options = { name: "x_REASON_ID", selectId: "cv_visit_x_REASON_ID", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.cv_visit.fields.REASON_ID.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->WAY_ID->Visible) { // WAY_ID ?>
    <div id="r_WAY_ID" class="form-group row">
        <label id="elh_cv_visit_WAY_ID" for="x_WAY_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->WAY_ID->caption() ?><?= $Page->WAY_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->WAY_ID->cellAttributes() ?>>
<span id="el_cv_visit_WAY_ID">
    <select
        id="x_WAY_ID"
        name="x_WAY_ID"
        class="form-control ew-select<?= $Page->WAY_ID->isInvalidClass() ?>"
        data-select2-id="cv_visit_x_WAY_ID"
        data-table="cv_visit"
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
    var el = document.querySelector("select[data-select2-id='cv_visit_x_WAY_ID']"),
        options = { name: "x_WAY_ID", selectId: "cv_visit_x_WAY_ID", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.cv_visit.fields.WAY_ID.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
    <span id="el_cv_visit_PATIENT_CATEGORY_ID">
    <input type="hidden" data-table="cv_visit" data-field="x_PATIENT_CATEGORY_ID" data-hidden="1" data-page="1" name="x_PATIENT_CATEGORY_ID" id="x_PATIENT_CATEGORY_ID" value="<?= HtmlEncode($Page->PATIENT_CATEGORY_ID->CurrentValue) ?>">
    </span>
<?php if ($Page->BOOKED_DATE->Visible) { // BOOKED_DATE ?>
    <div id="r_BOOKED_DATE" class="form-group row">
        <label id="elh_cv_visit_BOOKED_DATE" for="x_BOOKED_DATE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->BOOKED_DATE->caption() ?><?= $Page->BOOKED_DATE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->BOOKED_DATE->cellAttributes() ?>>
<span id="el_cv_visit_BOOKED_DATE">
<input type="<?= $Page->BOOKED_DATE->getInputTextType() ?>" data-table="cv_visit" data-field="x_BOOKED_DATE" data-page="1" data-format="11" name="x_BOOKED_DATE" id="x_BOOKED_DATE" placeholder="<?= HtmlEncode($Page->BOOKED_DATE->getPlaceHolder()) ?>" value="<?= $Page->BOOKED_DATE->EditValue ?>"<?= $Page->BOOKED_DATE->editAttributes() ?> aria-describedby="x_BOOKED_DATE_help">
<?= $Page->BOOKED_DATE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->BOOKED_DATE->getErrorMessage() ?></div>
<?php if (!$Page->BOOKED_DATE->ReadOnly && !$Page->BOOKED_DATE->Disabled && !isset($Page->BOOKED_DATE->EditAttrs["readonly"]) && !isset($Page->BOOKED_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fcv_visitadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fcv_visitadd", "x_BOOKED_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":11});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->VISIT_DATE->Visible) { // VISIT_DATE ?>
    <div id="r_VISIT_DATE" class="form-group row">
        <label id="elh_cv_visit_VISIT_DATE" for="x_VISIT_DATE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->VISIT_DATE->caption() ?><?= $Page->VISIT_DATE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->VISIT_DATE->cellAttributes() ?>>
<span id="el_cv_visit_VISIT_DATE">
<input type="<?= $Page->VISIT_DATE->getInputTextType() ?>" data-table="cv_visit" data-field="x_VISIT_DATE" data-page="1" data-format="11" name="x_VISIT_DATE" id="x_VISIT_DATE" placeholder="<?= HtmlEncode($Page->VISIT_DATE->getPlaceHolder()) ?>" value="<?= $Page->VISIT_DATE->EditValue ?>"<?= $Page->VISIT_DATE->editAttributes() ?> aria-describedby="x_VISIT_DATE_help">
<?= $Page->VISIT_DATE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->VISIT_DATE->getErrorMessage() ?></div>
<?php if (!$Page->VISIT_DATE->ReadOnly && !$Page->VISIT_DATE->Disabled && !isset($Page->VISIT_DATE->EditAttrs["readonly"]) && !isset($Page->VISIT_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fcv_visitadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fcv_visitadd", "x_VISIT_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":11});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ISNEW->Visible) { // ISNEW ?>
    <div id="r_ISNEW" class="form-group row">
        <label id="elh_cv_visit_ISNEW" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ISNEW->caption() ?><?= $Page->ISNEW->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ISNEW->cellAttributes() ?>>
<span id="el_cv_visit_ISNEW">
<template id="tp_x_ISNEW">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="cv_visit" data-field="x_ISNEW" name="x_ISNEW" id="x_ISNEW"<?= $Page->ISNEW->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x_ISNEW" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x_ISNEW"
    name="x_ISNEW"
    value="<?= HtmlEncode($Page->ISNEW->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_ISNEW"
    data-target="dsl_x_ISNEW"
    data-repeatcolumn="5"
    class="form-control<?= $Page->ISNEW->isInvalidClass() ?>"
    data-table="cv_visit"
    data-field="x_ISNEW"
    data-page="1"
    data-value-separator="<?= $Page->ISNEW->displayValueSeparatorAttribute() ?>"
    <?= $Page->ISNEW->editAttributes() ?>>
<?= $Page->ISNEW->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ISNEW->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
    <span id="el_cv_visit_FOLLOW_UP">
    <input type="hidden" data-table="cv_visit" data-field="x_FOLLOW_UP" data-hidden="1" data-page="1" name="x_FOLLOW_UP" id="x_FOLLOW_UP" value="<?= HtmlEncode($Page->FOLLOW_UP->CurrentValue) ?>">
    </span>
    <span id="el_cv_visit_PLACE_TYPE">
    <input type="hidden" data-table="cv_visit" data-field="x_PLACE_TYPE" data-hidden="1" data-page="1" name="x_PLACE_TYPE" id="x_PLACE_TYPE" value="<?= HtmlEncode($Page->PLACE_TYPE->CurrentValue) ?>">
    </span>
<?php if ($Page->CLINIC_ID->Visible) { // CLINIC_ID ?>
    <div id="r_CLINIC_ID" class="form-group row">
        <label id="elh_cv_visit_CLINIC_ID" for="x_CLINIC_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->CLINIC_ID->caption() ?><?= $Page->CLINIC_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->CLINIC_ID->cellAttributes() ?>>
<span id="el_cv_visit_CLINIC_ID">
<?php $Page->CLINIC_ID->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x_CLINIC_ID"
        name="x_CLINIC_ID"
        class="form-control ew-select<?= $Page->CLINIC_ID->isInvalidClass() ?>"
        data-select2-id="cv_visit_x_CLINIC_ID"
        data-table="cv_visit"
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
    var el = document.querySelector("select[data-select2-id='cv_visit_x_CLINIC_ID']"),
        options = { name: "x_CLINIC_ID", selectId: "cv_visit_x_CLINIC_ID", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.cv_visit.fields.CLINIC_ID.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
    <span id="el_cv_visit_CLINIC_ID_FROM">
    <input type="hidden" data-table="cv_visit" data-field="x_CLINIC_ID_FROM" data-hidden="1" data-page="1" name="x_CLINIC_ID_FROM" id="x_CLINIC_ID_FROM" value="<?= HtmlEncode($Page->CLINIC_ID_FROM->CurrentValue) ?>">
    </span>
<?php if ($Page->DESCRIPTION->Visible) { // DESCRIPTION ?>
    <div id="r_DESCRIPTION" class="form-group row">
        <label id="elh_cv_visit_DESCRIPTION" for="x_DESCRIPTION" class="<?= $Page->LeftColumnClass ?>"><?= $Page->DESCRIPTION->caption() ?><?= $Page->DESCRIPTION->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->DESCRIPTION->cellAttributes() ?>>
<span id="el_cv_visit_DESCRIPTION">
<textarea data-table="cv_visit" data-field="x_DESCRIPTION" data-page="1" name="x_DESCRIPTION" id="x_DESCRIPTION" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->DESCRIPTION->getPlaceHolder()) ?>"<?= $Page->DESCRIPTION->editAttributes() ?> aria-describedby="x_DESCRIPTION_help"><?= $Page->DESCRIPTION->EditValue ?></textarea>
<?= $Page->DESCRIPTION->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->DESCRIPTION->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->EMPLOYEE_ID->Visible) { // EMPLOYEE_ID ?>
    <div id="r_EMPLOYEE_ID" class="form-group row">
        <label id="elh_cv_visit_EMPLOYEE_ID" for="x_EMPLOYEE_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->EMPLOYEE_ID->caption() ?><?= $Page->EMPLOYEE_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->EMPLOYEE_ID->cellAttributes() ?>>
<span id="el_cv_visit_EMPLOYEE_ID">
<?php $Page->EMPLOYEE_ID->EditAttrs->prepend("onchange", "ew.autoFill(this);"); ?>
    <select
        id="x_EMPLOYEE_ID"
        name="x_EMPLOYEE_ID"
        class="form-control ew-select<?= $Page->EMPLOYEE_ID->isInvalidClass() ?>"
        data-select2-id="cv_visit_x_EMPLOYEE_ID"
        data-table="cv_visit"
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
    var el = document.querySelector("select[data-select2-id='cv_visit_x_EMPLOYEE_ID']"),
        options = { name: "x_EMPLOYEE_ID", selectId: "cv_visit_x_EMPLOYEE_ID", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.cv_visit.fields.EMPLOYEE_ID.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
    <span id="el_cv_visit_RESPONSIBLE_ID">
    <input type="hidden" data-table="cv_visit" data-field="x_RESPONSIBLE_ID" data-hidden="1" data-page="1" name="x_RESPONSIBLE_ID" id="x_RESPONSIBLE_ID" value="<?= HtmlEncode($Page->RESPONSIBLE_ID->CurrentValue) ?>">
    </span>
    <span id="el_cv_visit_ISPERTARIF">
    <input type="hidden" data-table="cv_visit" data-field="x_ISPERTARIF" data-hidden="1" data-page="1" name="x_ISPERTARIF" id="x_ISPERTARIF" value="<?= HtmlEncode($Page->ISPERTARIF->CurrentValue) ?>">
    </span>
    <span id="el_cv_visit_CLASS_ID_PLAFOND">
    <input type="hidden" data-table="cv_visit" data-field="x_CLASS_ID_PLAFOND" data-hidden="1" data-page="1" name="x_CLASS_ID_PLAFOND" id="x_CLASS_ID_PLAFOND" value="<?= HtmlEncode($Page->CLASS_ID_PLAFOND->CurrentValue) ?>">
    </span>
    <span id="el_cv_visit_BACKCHARGE">
    <input type="hidden" data-table="cv_visit" data-field="x_BACKCHARGE" data-hidden="1" data-page="1" name="x_BACKCHARGE" id="x_BACKCHARGE" value="<?= HtmlEncode($Page->BACKCHARGE->CurrentValue) ?>">
    </span>
    <span id="el_cv_visit_LOCKED">
    <input type="hidden" data-table="cv_visit" data-field="x_LOCKED" data-hidden="1" data-page="1" name="x_LOCKED" id="x_LOCKED" value="<?= HtmlEncode($Page->LOCKED->CurrentValue) ?>">
    </span>
<?php if ($Page->tanggal_rujukan->Visible) { // tanggal_rujukan ?>
    <div id="r_tanggal_rujukan" class="form-group row">
        <label id="elh_cv_visit_tanggal_rujukan" for="x_tanggal_rujukan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tanggal_rujukan->caption() ?><?= $Page->tanggal_rujukan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tanggal_rujukan->cellAttributes() ?>>
<span id="el_cv_visit_tanggal_rujukan">
<input type="<?= $Page->tanggal_rujukan->getInputTextType() ?>" data-table="cv_visit" data-field="x_tanggal_rujukan" data-page="1" data-format="17" name="x_tanggal_rujukan" id="x_tanggal_rujukan" placeholder="<?= HtmlEncode($Page->tanggal_rujukan->getPlaceHolder()) ?>" value="<?= $Page->tanggal_rujukan->EditValue ?>"<?= $Page->tanggal_rujukan->editAttributes() ?> aria-describedby="x_tanggal_rujukan_help">
<?= $Page->tanggal_rujukan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tanggal_rujukan->getErrorMessage() ?></div>
<?php if (!$Page->tanggal_rujukan->ReadOnly && !$Page->tanggal_rujukan->Disabled && !isset($Page->tanggal_rujukan->EditAttrs["readonly"]) && !isset($Page->tanggal_rujukan->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fcv_visitadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fcv_visitadd", "x_tanggal_rujukan", {"ignoreReadonly":true,"useCurrent":false,"format":17});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
    <span id="el_cv_visit_ISRJ">
    <input type="hidden" data-table="cv_visit" data-field="x_ISRJ" data-hidden="1" data-page="1" name="x_ISRJ" id="x_ISRJ" value="<?= HtmlEncode($Page->ISRJ->CurrentValue) ?>">
    </span>
<?php if ($Page->NORUJUKAN->Visible) { // NORUJUKAN ?>
    <div id="r_NORUJUKAN" class="form-group row">
        <label id="elh_cv_visit_NORUJUKAN" for="x_NORUJUKAN" class="<?= $Page->LeftColumnClass ?>"><?= $Page->NORUJUKAN->caption() ?><?= $Page->NORUJUKAN->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->NORUJUKAN->cellAttributes() ?>>
<span id="el_cv_visit_NORUJUKAN">
<input type="<?= $Page->NORUJUKAN->getInputTextType() ?>" data-table="cv_visit" data-field="x_NORUJUKAN" data-page="1" name="x_NORUJUKAN" id="x_NORUJUKAN" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->NORUJUKAN->getPlaceHolder()) ?>" value="<?= $Page->NORUJUKAN->EditValue ?>"<?= $Page->NORUJUKAN->editAttributes() ?> aria-describedby="x_NORUJUKAN_help">
<?= $Page->NORUJUKAN->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->NORUJUKAN->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->KDPOLI_EKS->Visible) { // KDPOLI_EKS ?>
    <div id="r_KDPOLI_EKS" class="form-group row">
        <label id="elh_cv_visit_KDPOLI_EKS" class="<?= $Page->LeftColumnClass ?>"><?= $Page->KDPOLI_EKS->caption() ?><?= $Page->KDPOLI_EKS->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->KDPOLI_EKS->cellAttributes() ?>>
<span id="el_cv_visit_KDPOLI_EKS">
<template id="tp_x_KDPOLI_EKS">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="cv_visit" data-field="x_KDPOLI_EKS" name="x_KDPOLI_EKS" id="x_KDPOLI_EKS"<?= $Page->KDPOLI_EKS->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x_KDPOLI_EKS" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x_KDPOLI_EKS"
    name="x_KDPOLI_EKS"
    value="<?= HtmlEncode($Page->KDPOLI_EKS->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_KDPOLI_EKS"
    data-target="dsl_x_KDPOLI_EKS"
    data-repeatcolumn="5"
    class="form-control<?= $Page->KDPOLI_EKS->isInvalidClass() ?>"
    data-table="cv_visit"
    data-field="x_KDPOLI_EKS"
    data-page="1"
    data-value-separator="<?= $Page->KDPOLI_EKS->displayValueSeparatorAttribute() ?>"
    <?= $Page->KDPOLI_EKS->editAttributes() ?>>
<?= $Page->KDPOLI_EKS->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->KDPOLI_EKS->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->RESPONTGLPLG_DESC->Visible) { // RESPONTGLPLG_DESC ?>
    <div id="r_RESPONTGLPLG_DESC" class="form-group row">
        <label id="elh_cv_visit_RESPONTGLPLG_DESC" for="x_RESPONTGLPLG_DESC" class="<?= $Page->LeftColumnClass ?>"><?= $Page->RESPONTGLPLG_DESC->caption() ?><?= $Page->RESPONTGLPLG_DESC->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->RESPONTGLPLG_DESC->cellAttributes() ?>>
<span id="el_cv_visit_RESPONTGLPLG_DESC">
    <select
        id="x_RESPONTGLPLG_DESC"
        name="x_RESPONTGLPLG_DESC"
        class="form-control ew-select<?= $Page->RESPONTGLPLG_DESC->isInvalidClass() ?>"
        data-select2-id="cv_visit_x_RESPONTGLPLG_DESC"
        data-table="cv_visit"
        data-field="x_RESPONTGLPLG_DESC"
        data-page="1"
        data-value-separator="<?= $Page->RESPONTGLPLG_DESC->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->RESPONTGLPLG_DESC->getPlaceHolder()) ?>"
        <?= $Page->RESPONTGLPLG_DESC->editAttributes() ?>>
        <?= $Page->RESPONTGLPLG_DESC->selectOptionListHtml("x_RESPONTGLPLG_DESC") ?>
    </select>
    <?= $Page->RESPONTGLPLG_DESC->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->RESPONTGLPLG_DESC->getErrorMessage() ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='cv_visit_x_RESPONTGLPLG_DESC']"),
        options = { name: "x_RESPONTGLPLG_DESC", selectId: "cv_visit_x_RESPONTGLPLG_DESC", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.data = ew.vars.tables.cv_visit.fields.RESPONTGLPLG_DESC.lookupOptions;
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.cv_visit.fields.RESPONTGLPLG_DESC.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
    <span id="el_cv_visit_CALL_TIMES">
    <input type="hidden" data-table="cv_visit" data-field="x_CALL_TIMES" data-hidden="1" data-page="1" name="x_CALL_TIMES" id="x_CALL_TIMES" value="<?= HtmlEncode($Page->CALL_TIMES->CurrentValue) ?>">
    </span>
<?php if ($Page->KDDPJP->Visible) { // KDDPJP ?>
    <div id="r_KDDPJP" class="form-group row">
        <label id="elh_cv_visit_KDDPJP" for="x_KDDPJP" class="<?= $Page->LeftColumnClass ?>"><?= $Page->KDDPJP->caption() ?><?= $Page->KDDPJP->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->KDDPJP->cellAttributes() ?>>
<span id="el_cv_visit_KDDPJP">
<input type="<?= $Page->KDDPJP->getInputTextType() ?>" data-table="cv_visit" data-field="x_KDDPJP" data-page="1" name="x_KDDPJP" id="x_KDDPJP" size="30" maxlength="25" placeholder="<?= HtmlEncode($Page->KDDPJP->getPlaceHolder()) ?>" value="<?= $Page->KDDPJP->EditValue ?>"<?= $Page->KDDPJP->editAttributes() ?> aria-describedby="x_KDDPJP_help">
<?= $Page->KDDPJP->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->KDDPJP->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tgl_kontrol->Visible) { // tgl_kontrol ?>
    <div id="r_tgl_kontrol" class="form-group row">
        <label id="elh_cv_visit_tgl_kontrol" for="x_tgl_kontrol" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tgl_kontrol->caption() ?><?= $Page->tgl_kontrol->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tgl_kontrol->cellAttributes() ?>>
<span id="el_cv_visit_tgl_kontrol">
<input type="<?= $Page->tgl_kontrol->getInputTextType() ?>" data-table="cv_visit" data-field="x_tgl_kontrol" data-page="1" name="x_tgl_kontrol" id="x_tgl_kontrol" placeholder="<?= HtmlEncode($Page->tgl_kontrol->getPlaceHolder()) ?>" value="<?= $Page->tgl_kontrol->EditValue ?>"<?= $Page->tgl_kontrol->editAttributes() ?> aria-describedby="x_tgl_kontrol_help">
<?= $Page->tgl_kontrol->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tgl_kontrol->getErrorMessage() ?></div>
<?php if (!$Page->tgl_kontrol->ReadOnly && !$Page->tgl_kontrol->Disabled && !isset($Page->tgl_kontrol->EditAttrs["readonly"]) && !isset($Page->tgl_kontrol->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fcv_visitadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fcv_visitadd", "x_tgl_kontrol", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
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
    ew.addEventHandlers("cv_visit");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
