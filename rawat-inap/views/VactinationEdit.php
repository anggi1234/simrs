<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

// Page object
$VactinationEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fVACTINATIONedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fVACTINATIONedit = currentForm = new ew.Form("fVACTINATIONedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "VACTINATION")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.VACTINATION)
        ew.vars.tables.VACTINATION = currentTable;
    fVACTINATIONedit.addFields([
        ["ORG_UNIT_CODE", [fields.ORG_UNIT_CODE.visible && fields.ORG_UNIT_CODE.required ? ew.Validators.required(fields.ORG_UNIT_CODE.caption) : null], fields.ORG_UNIT_CODE.isInvalid],
        ["VACTINATION_ID", [fields.VACTINATION_ID.visible && fields.VACTINATION_ID.required ? ew.Validators.required(fields.VACTINATION_ID.caption) : null], fields.VACTINATION_ID.isInvalid],
        ["NO_REGISTRATION", [fields.NO_REGISTRATION.visible && fields.NO_REGISTRATION.required ? ew.Validators.required(fields.NO_REGISTRATION.caption) : null], fields.NO_REGISTRATION.isInvalid],
        ["VISIT_ID", [fields.VISIT_ID.visible && fields.VISIT_ID.required ? ew.Validators.required(fields.VISIT_ID.caption) : null], fields.VISIT_ID.isInvalid],
        ["BILL_ID", [fields.BILL_ID.visible && fields.BILL_ID.required ? ew.Validators.required(fields.BILL_ID.caption) : null], fields.BILL_ID.isInvalid],
        ["CLINIC_ID", [fields.CLINIC_ID.visible && fields.CLINIC_ID.required ? ew.Validators.required(fields.CLINIC_ID.caption) : null], fields.CLINIC_ID.isInvalid],
        ["VACTINATION_TYPE", [fields.VACTINATION_TYPE.visible && fields.VACTINATION_TYPE.required ? ew.Validators.required(fields.VACTINATION_TYPE.caption) : null, ew.Validators.integer], fields.VACTINATION_TYPE.isInvalid],
        ["LEVEL_ID", [fields.LEVEL_ID.visible && fields.LEVEL_ID.required ? ew.Validators.required(fields.LEVEL_ID.caption) : null, ew.Validators.integer], fields.LEVEL_ID.isInvalid],
        ["EMPLOYEE_ID", [fields.EMPLOYEE_ID.visible && fields.EMPLOYEE_ID.required ? ew.Validators.required(fields.EMPLOYEE_ID.caption) : null], fields.EMPLOYEE_ID.isInvalid],
        ["PATIENT_CATEGORY_ID", [fields.PATIENT_CATEGORY_ID.visible && fields.PATIENT_CATEGORY_ID.required ? ew.Validators.required(fields.PATIENT_CATEGORY_ID.caption) : null, ew.Validators.integer], fields.PATIENT_CATEGORY_ID.isInvalid],
        ["VACTINATION_DATE", [fields.VACTINATION_DATE.visible && fields.VACTINATION_DATE.required ? ew.Validators.required(fields.VACTINATION_DATE.caption) : null, ew.Validators.datetime(0)], fields.VACTINATION_DATE.isInvalid],
        ["DESCRIPTION", [fields.DESCRIPTION.visible && fields.DESCRIPTION.required ? ew.Validators.required(fields.DESCRIPTION.caption) : null], fields.DESCRIPTION.isInvalid],
        ["MODIFIED_DATE", [fields.MODIFIED_DATE.visible && fields.MODIFIED_DATE.required ? ew.Validators.required(fields.MODIFIED_DATE.caption) : null, ew.Validators.datetime(0)], fields.MODIFIED_DATE.isInvalid],
        ["MODIFIED_BY", [fields.MODIFIED_BY.visible && fields.MODIFIED_BY.required ? ew.Validators.required(fields.MODIFIED_BY.caption) : null], fields.MODIFIED_BY.isInvalid],
        ["MODIFIED_FROM", [fields.MODIFIED_FROM.visible && fields.MODIFIED_FROM.required ? ew.Validators.required(fields.MODIFIED_FROM.caption) : null], fields.MODIFIED_FROM.isInvalid],
        ["THENAME", [fields.THENAME.visible && fields.THENAME.required ? ew.Validators.required(fields.THENAME.caption) : null], fields.THENAME.isInvalid],
        ["THEADDRESS", [fields.THEADDRESS.visible && fields.THEADDRESS.required ? ew.Validators.required(fields.THEADDRESS.caption) : null], fields.THEADDRESS.isInvalid],
        ["THEID", [fields.THEID.visible && fields.THEID.required ? ew.Validators.required(fields.THEID.caption) : null], fields.THEID.isInvalid],
        ["ISRJ", [fields.ISRJ.visible && fields.ISRJ.required ? ew.Validators.required(fields.ISRJ.caption) : null], fields.ISRJ.isInvalid],
        ["AGEYEAR", [fields.AGEYEAR.visible && fields.AGEYEAR.required ? ew.Validators.required(fields.AGEYEAR.caption) : null, ew.Validators.integer], fields.AGEYEAR.isInvalid],
        ["AGEMONTH", [fields.AGEMONTH.visible && fields.AGEMONTH.required ? ew.Validators.required(fields.AGEMONTH.caption) : null, ew.Validators.integer], fields.AGEMONTH.isInvalid],
        ["AGEDAY", [fields.AGEDAY.visible && fields.AGEDAY.required ? ew.Validators.required(fields.AGEDAY.caption) : null, ew.Validators.integer], fields.AGEDAY.isInvalid],
        ["STATUS_PASIEN_ID", [fields.STATUS_PASIEN_ID.visible && fields.STATUS_PASIEN_ID.required ? ew.Validators.required(fields.STATUS_PASIEN_ID.caption) : null, ew.Validators.integer], fields.STATUS_PASIEN_ID.isInvalid],
        ["GENDER", [fields.GENDER.visible && fields.GENDER.required ? ew.Validators.required(fields.GENDER.caption) : null], fields.GENDER.isInvalid],
        ["DOCTOR", [fields.DOCTOR.visible && fields.DOCTOR.required ? ew.Validators.required(fields.DOCTOR.caption) : null], fields.DOCTOR.isInvalid],
        ["KAL_ID", [fields.KAL_ID.visible && fields.KAL_ID.required ? ew.Validators.required(fields.KAL_ID.caption) : null], fields.KAL_ID.isInvalid],
        ["CLASS_ROOM_ID", [fields.CLASS_ROOM_ID.visible && fields.CLASS_ROOM_ID.required ? ew.Validators.required(fields.CLASS_ROOM_ID.caption) : null], fields.CLASS_ROOM_ID.isInvalid],
        ["BED_ID", [fields.BED_ID.visible && fields.BED_ID.required ? ew.Validators.required(fields.BED_ID.caption) : null, ew.Validators.integer], fields.BED_ID.isInvalid],
        ["KELUAR_ID", [fields.KELUAR_ID.visible && fields.KELUAR_ID.required ? ew.Validators.required(fields.KELUAR_ID.caption) : null, ew.Validators.integer], fields.KELUAR_ID.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fVACTINATIONedit,
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
    fVACTINATIONedit.validate = function () {
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
    fVACTINATIONedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fVACTINATIONedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fVACTINATIONedit");
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
<form name="fVACTINATIONedit" id="fVACTINATIONedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="VACTINATION">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->ORG_UNIT_CODE->Visible) { // ORG_UNIT_CODE ?>
    <div id="r_ORG_UNIT_CODE" class="form-group row">
        <label id="elh_VACTINATION_ORG_UNIT_CODE" for="x_ORG_UNIT_CODE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ORG_UNIT_CODE->caption() ?><?= $Page->ORG_UNIT_CODE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ORG_UNIT_CODE->cellAttributes() ?>>
<input type="<?= $Page->ORG_UNIT_CODE->getInputTextType() ?>" data-table="VACTINATION" data-field="x_ORG_UNIT_CODE" name="x_ORG_UNIT_CODE" id="x_ORG_UNIT_CODE" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->ORG_UNIT_CODE->getPlaceHolder()) ?>" value="<?= $Page->ORG_UNIT_CODE->EditValue ?>"<?= $Page->ORG_UNIT_CODE->editAttributes() ?> aria-describedby="x_ORG_UNIT_CODE_help">
<?= $Page->ORG_UNIT_CODE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ORG_UNIT_CODE->getErrorMessage() ?></div>
<input type="hidden" data-table="VACTINATION" data-field="x_ORG_UNIT_CODE" data-hidden="1" name="o_ORG_UNIT_CODE" id="o_ORG_UNIT_CODE" value="<?= HtmlEncode($Page->ORG_UNIT_CODE->OldValue ?? $Page->ORG_UNIT_CODE->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->VACTINATION_ID->Visible) { // VACTINATION_ID ?>
    <div id="r_VACTINATION_ID" class="form-group row">
        <label id="elh_VACTINATION_VACTINATION_ID" for="x_VACTINATION_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->VACTINATION_ID->caption() ?><?= $Page->VACTINATION_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->VACTINATION_ID->cellAttributes() ?>>
<input type="<?= $Page->VACTINATION_ID->getInputTextType() ?>" data-table="VACTINATION" data-field="x_VACTINATION_ID" name="x_VACTINATION_ID" id="x_VACTINATION_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->VACTINATION_ID->getPlaceHolder()) ?>" value="<?= $Page->VACTINATION_ID->EditValue ?>"<?= $Page->VACTINATION_ID->editAttributes() ?> aria-describedby="x_VACTINATION_ID_help">
<?= $Page->VACTINATION_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->VACTINATION_ID->getErrorMessage() ?></div>
<input type="hidden" data-table="VACTINATION" data-field="x_VACTINATION_ID" data-hidden="1" name="o_VACTINATION_ID" id="o_VACTINATION_ID" value="<?= HtmlEncode($Page->VACTINATION_ID->OldValue ?? $Page->VACTINATION_ID->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->NO_REGISTRATION->Visible) { // NO_REGISTRATION ?>
    <div id="r_NO_REGISTRATION" class="form-group row">
        <label id="elh_VACTINATION_NO_REGISTRATION" for="x_NO_REGISTRATION" class="<?= $Page->LeftColumnClass ?>"><?= $Page->NO_REGISTRATION->caption() ?><?= $Page->NO_REGISTRATION->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->NO_REGISTRATION->cellAttributes() ?>>
<span id="el_VACTINATION_NO_REGISTRATION">
<input type="<?= $Page->NO_REGISTRATION->getInputTextType() ?>" data-table="VACTINATION" data-field="x_NO_REGISTRATION" name="x_NO_REGISTRATION" id="x_NO_REGISTRATION" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->NO_REGISTRATION->getPlaceHolder()) ?>" value="<?= $Page->NO_REGISTRATION->EditValue ?>"<?= $Page->NO_REGISTRATION->editAttributes() ?> aria-describedby="x_NO_REGISTRATION_help">
<?= $Page->NO_REGISTRATION->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->NO_REGISTRATION->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->VISIT_ID->Visible) { // VISIT_ID ?>
    <div id="r_VISIT_ID" class="form-group row">
        <label id="elh_VACTINATION_VISIT_ID" for="x_VISIT_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->VISIT_ID->caption() ?><?= $Page->VISIT_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->VISIT_ID->cellAttributes() ?>>
<span id="el_VACTINATION_VISIT_ID">
<input type="<?= $Page->VISIT_ID->getInputTextType() ?>" data-table="VACTINATION" data-field="x_VISIT_ID" name="x_VISIT_ID" id="x_VISIT_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->VISIT_ID->getPlaceHolder()) ?>" value="<?= $Page->VISIT_ID->EditValue ?>"<?= $Page->VISIT_ID->editAttributes() ?> aria-describedby="x_VISIT_ID_help">
<?= $Page->VISIT_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->VISIT_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->BILL_ID->Visible) { // BILL_ID ?>
    <div id="r_BILL_ID" class="form-group row">
        <label id="elh_VACTINATION_BILL_ID" for="x_BILL_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->BILL_ID->caption() ?><?= $Page->BILL_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->BILL_ID->cellAttributes() ?>>
<span id="el_VACTINATION_BILL_ID">
<input type="<?= $Page->BILL_ID->getInputTextType() ?>" data-table="VACTINATION" data-field="x_BILL_ID" name="x_BILL_ID" id="x_BILL_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->BILL_ID->getPlaceHolder()) ?>" value="<?= $Page->BILL_ID->EditValue ?>"<?= $Page->BILL_ID->editAttributes() ?> aria-describedby="x_BILL_ID_help">
<?= $Page->BILL_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->BILL_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->CLINIC_ID->Visible) { // CLINIC_ID ?>
    <div id="r_CLINIC_ID" class="form-group row">
        <label id="elh_VACTINATION_CLINIC_ID" for="x_CLINIC_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->CLINIC_ID->caption() ?><?= $Page->CLINIC_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->CLINIC_ID->cellAttributes() ?>>
<span id="el_VACTINATION_CLINIC_ID">
<input type="<?= $Page->CLINIC_ID->getInputTextType() ?>" data-table="VACTINATION" data-field="x_CLINIC_ID" name="x_CLINIC_ID" id="x_CLINIC_ID" size="30" maxlength="8" placeholder="<?= HtmlEncode($Page->CLINIC_ID->getPlaceHolder()) ?>" value="<?= $Page->CLINIC_ID->EditValue ?>"<?= $Page->CLINIC_ID->editAttributes() ?> aria-describedby="x_CLINIC_ID_help">
<?= $Page->CLINIC_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->CLINIC_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->VACTINATION_TYPE->Visible) { // VACTINATION_TYPE ?>
    <div id="r_VACTINATION_TYPE" class="form-group row">
        <label id="elh_VACTINATION_VACTINATION_TYPE" for="x_VACTINATION_TYPE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->VACTINATION_TYPE->caption() ?><?= $Page->VACTINATION_TYPE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->VACTINATION_TYPE->cellAttributes() ?>>
<span id="el_VACTINATION_VACTINATION_TYPE">
<input type="<?= $Page->VACTINATION_TYPE->getInputTextType() ?>" data-table="VACTINATION" data-field="x_VACTINATION_TYPE" name="x_VACTINATION_TYPE" id="x_VACTINATION_TYPE" size="30" placeholder="<?= HtmlEncode($Page->VACTINATION_TYPE->getPlaceHolder()) ?>" value="<?= $Page->VACTINATION_TYPE->EditValue ?>"<?= $Page->VACTINATION_TYPE->editAttributes() ?> aria-describedby="x_VACTINATION_TYPE_help">
<?= $Page->VACTINATION_TYPE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->VACTINATION_TYPE->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->LEVEL_ID->Visible) { // LEVEL_ID ?>
    <div id="r_LEVEL_ID" class="form-group row">
        <label id="elh_VACTINATION_LEVEL_ID" for="x_LEVEL_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->LEVEL_ID->caption() ?><?= $Page->LEVEL_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->LEVEL_ID->cellAttributes() ?>>
<span id="el_VACTINATION_LEVEL_ID">
<input type="<?= $Page->LEVEL_ID->getInputTextType() ?>" data-table="VACTINATION" data-field="x_LEVEL_ID" name="x_LEVEL_ID" id="x_LEVEL_ID" size="30" placeholder="<?= HtmlEncode($Page->LEVEL_ID->getPlaceHolder()) ?>" value="<?= $Page->LEVEL_ID->EditValue ?>"<?= $Page->LEVEL_ID->editAttributes() ?> aria-describedby="x_LEVEL_ID_help">
<?= $Page->LEVEL_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->LEVEL_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->EMPLOYEE_ID->Visible) { // EMPLOYEE_ID ?>
    <div id="r_EMPLOYEE_ID" class="form-group row">
        <label id="elh_VACTINATION_EMPLOYEE_ID" for="x_EMPLOYEE_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->EMPLOYEE_ID->caption() ?><?= $Page->EMPLOYEE_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->EMPLOYEE_ID->cellAttributes() ?>>
<span id="el_VACTINATION_EMPLOYEE_ID">
<input type="<?= $Page->EMPLOYEE_ID->getInputTextType() ?>" data-table="VACTINATION" data-field="x_EMPLOYEE_ID" name="x_EMPLOYEE_ID" id="x_EMPLOYEE_ID" size="30" maxlength="15" placeholder="<?= HtmlEncode($Page->EMPLOYEE_ID->getPlaceHolder()) ?>" value="<?= $Page->EMPLOYEE_ID->EditValue ?>"<?= $Page->EMPLOYEE_ID->editAttributes() ?> aria-describedby="x_EMPLOYEE_ID_help">
<?= $Page->EMPLOYEE_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->EMPLOYEE_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->PATIENT_CATEGORY_ID->Visible) { // PATIENT_CATEGORY_ID ?>
    <div id="r_PATIENT_CATEGORY_ID" class="form-group row">
        <label id="elh_VACTINATION_PATIENT_CATEGORY_ID" for="x_PATIENT_CATEGORY_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->PATIENT_CATEGORY_ID->caption() ?><?= $Page->PATIENT_CATEGORY_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PATIENT_CATEGORY_ID->cellAttributes() ?>>
<span id="el_VACTINATION_PATIENT_CATEGORY_ID">
<input type="<?= $Page->PATIENT_CATEGORY_ID->getInputTextType() ?>" data-table="VACTINATION" data-field="x_PATIENT_CATEGORY_ID" name="x_PATIENT_CATEGORY_ID" id="x_PATIENT_CATEGORY_ID" size="30" placeholder="<?= HtmlEncode($Page->PATIENT_CATEGORY_ID->getPlaceHolder()) ?>" value="<?= $Page->PATIENT_CATEGORY_ID->EditValue ?>"<?= $Page->PATIENT_CATEGORY_ID->editAttributes() ?> aria-describedby="x_PATIENT_CATEGORY_ID_help">
<?= $Page->PATIENT_CATEGORY_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->PATIENT_CATEGORY_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->VACTINATION_DATE->Visible) { // VACTINATION_DATE ?>
    <div id="r_VACTINATION_DATE" class="form-group row">
        <label id="elh_VACTINATION_VACTINATION_DATE" for="x_VACTINATION_DATE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->VACTINATION_DATE->caption() ?><?= $Page->VACTINATION_DATE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->VACTINATION_DATE->cellAttributes() ?>>
<span id="el_VACTINATION_VACTINATION_DATE">
<input type="<?= $Page->VACTINATION_DATE->getInputTextType() ?>" data-table="VACTINATION" data-field="x_VACTINATION_DATE" name="x_VACTINATION_DATE" id="x_VACTINATION_DATE" placeholder="<?= HtmlEncode($Page->VACTINATION_DATE->getPlaceHolder()) ?>" value="<?= $Page->VACTINATION_DATE->EditValue ?>"<?= $Page->VACTINATION_DATE->editAttributes() ?> aria-describedby="x_VACTINATION_DATE_help">
<?= $Page->VACTINATION_DATE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->VACTINATION_DATE->getErrorMessage() ?></div>
<?php if (!$Page->VACTINATION_DATE->ReadOnly && !$Page->VACTINATION_DATE->Disabled && !isset($Page->VACTINATION_DATE->EditAttrs["readonly"]) && !isset($Page->VACTINATION_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fVACTINATIONedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fVACTINATIONedit", "x_VACTINATION_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->DESCRIPTION->Visible) { // DESCRIPTION ?>
    <div id="r_DESCRIPTION" class="form-group row">
        <label id="elh_VACTINATION_DESCRIPTION" for="x_DESCRIPTION" class="<?= $Page->LeftColumnClass ?>"><?= $Page->DESCRIPTION->caption() ?><?= $Page->DESCRIPTION->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->DESCRIPTION->cellAttributes() ?>>
<span id="el_VACTINATION_DESCRIPTION">
<input type="<?= $Page->DESCRIPTION->getInputTextType() ?>" data-table="VACTINATION" data-field="x_DESCRIPTION" name="x_DESCRIPTION" id="x_DESCRIPTION" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->DESCRIPTION->getPlaceHolder()) ?>" value="<?= $Page->DESCRIPTION->EditValue ?>"<?= $Page->DESCRIPTION->editAttributes() ?> aria-describedby="x_DESCRIPTION_help">
<?= $Page->DESCRIPTION->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->DESCRIPTION->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
    <div id="r_MODIFIED_DATE" class="form-group row">
        <label id="elh_VACTINATION_MODIFIED_DATE" for="x_MODIFIED_DATE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->MODIFIED_DATE->caption() ?><?= $Page->MODIFIED_DATE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->MODIFIED_DATE->cellAttributes() ?>>
<span id="el_VACTINATION_MODIFIED_DATE">
<input type="<?= $Page->MODIFIED_DATE->getInputTextType() ?>" data-table="VACTINATION" data-field="x_MODIFIED_DATE" name="x_MODIFIED_DATE" id="x_MODIFIED_DATE" placeholder="<?= HtmlEncode($Page->MODIFIED_DATE->getPlaceHolder()) ?>" value="<?= $Page->MODIFIED_DATE->EditValue ?>"<?= $Page->MODIFIED_DATE->editAttributes() ?> aria-describedby="x_MODIFIED_DATE_help">
<?= $Page->MODIFIED_DATE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->MODIFIED_DATE->getErrorMessage() ?></div>
<?php if (!$Page->MODIFIED_DATE->ReadOnly && !$Page->MODIFIED_DATE->Disabled && !isset($Page->MODIFIED_DATE->EditAttrs["readonly"]) && !isset($Page->MODIFIED_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fVACTINATIONedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fVACTINATIONedit", "x_MODIFIED_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
    <div id="r_MODIFIED_BY" class="form-group row">
        <label id="elh_VACTINATION_MODIFIED_BY" for="x_MODIFIED_BY" class="<?= $Page->LeftColumnClass ?>"><?= $Page->MODIFIED_BY->caption() ?><?= $Page->MODIFIED_BY->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->MODIFIED_BY->cellAttributes() ?>>
<span id="el_VACTINATION_MODIFIED_BY">
<input type="<?= $Page->MODIFIED_BY->getInputTextType() ?>" data-table="VACTINATION" data-field="x_MODIFIED_BY" name="x_MODIFIED_BY" id="x_MODIFIED_BY" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->MODIFIED_BY->getPlaceHolder()) ?>" value="<?= $Page->MODIFIED_BY->EditValue ?>"<?= $Page->MODIFIED_BY->editAttributes() ?> aria-describedby="x_MODIFIED_BY_help">
<?= $Page->MODIFIED_BY->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->MODIFIED_BY->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->MODIFIED_FROM->Visible) { // MODIFIED_FROM ?>
    <div id="r_MODIFIED_FROM" class="form-group row">
        <label id="elh_VACTINATION_MODIFIED_FROM" for="x_MODIFIED_FROM" class="<?= $Page->LeftColumnClass ?>"><?= $Page->MODIFIED_FROM->caption() ?><?= $Page->MODIFIED_FROM->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->MODIFIED_FROM->cellAttributes() ?>>
<span id="el_VACTINATION_MODIFIED_FROM">
<input type="<?= $Page->MODIFIED_FROM->getInputTextType() ?>" data-table="VACTINATION" data-field="x_MODIFIED_FROM" name="x_MODIFIED_FROM" id="x_MODIFIED_FROM" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->MODIFIED_FROM->getPlaceHolder()) ?>" value="<?= $Page->MODIFIED_FROM->EditValue ?>"<?= $Page->MODIFIED_FROM->editAttributes() ?> aria-describedby="x_MODIFIED_FROM_help">
<?= $Page->MODIFIED_FROM->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->MODIFIED_FROM->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->THENAME->Visible) { // THENAME ?>
    <div id="r_THENAME" class="form-group row">
        <label id="elh_VACTINATION_THENAME" for="x_THENAME" class="<?= $Page->LeftColumnClass ?>"><?= $Page->THENAME->caption() ?><?= $Page->THENAME->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->THENAME->cellAttributes() ?>>
<span id="el_VACTINATION_THENAME">
<input type="<?= $Page->THENAME->getInputTextType() ?>" data-table="VACTINATION" data-field="x_THENAME" name="x_THENAME" id="x_THENAME" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->THENAME->getPlaceHolder()) ?>" value="<?= $Page->THENAME->EditValue ?>"<?= $Page->THENAME->editAttributes() ?> aria-describedby="x_THENAME_help">
<?= $Page->THENAME->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->THENAME->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->THEADDRESS->Visible) { // THEADDRESS ?>
    <div id="r_THEADDRESS" class="form-group row">
        <label id="elh_VACTINATION_THEADDRESS" for="x_THEADDRESS" class="<?= $Page->LeftColumnClass ?>"><?= $Page->THEADDRESS->caption() ?><?= $Page->THEADDRESS->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->THEADDRESS->cellAttributes() ?>>
<span id="el_VACTINATION_THEADDRESS">
<input type="<?= $Page->THEADDRESS->getInputTextType() ?>" data-table="VACTINATION" data-field="x_THEADDRESS" name="x_THEADDRESS" id="x_THEADDRESS" size="30" maxlength="150" placeholder="<?= HtmlEncode($Page->THEADDRESS->getPlaceHolder()) ?>" value="<?= $Page->THEADDRESS->EditValue ?>"<?= $Page->THEADDRESS->editAttributes() ?> aria-describedby="x_THEADDRESS_help">
<?= $Page->THEADDRESS->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->THEADDRESS->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->THEID->Visible) { // THEID ?>
    <div id="r_THEID" class="form-group row">
        <label id="elh_VACTINATION_THEID" for="x_THEID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->THEID->caption() ?><?= $Page->THEID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->THEID->cellAttributes() ?>>
<span id="el_VACTINATION_THEID">
<input type="<?= $Page->THEID->getInputTextType() ?>" data-table="VACTINATION" data-field="x_THEID" name="x_THEID" id="x_THEID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->THEID->getPlaceHolder()) ?>" value="<?= $Page->THEID->EditValue ?>"<?= $Page->THEID->editAttributes() ?> aria-describedby="x_THEID_help">
<?= $Page->THEID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->THEID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ISRJ->Visible) { // ISRJ ?>
    <div id="r_ISRJ" class="form-group row">
        <label id="elh_VACTINATION_ISRJ" for="x_ISRJ" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ISRJ->caption() ?><?= $Page->ISRJ->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ISRJ->cellAttributes() ?>>
<span id="el_VACTINATION_ISRJ">
<input type="<?= $Page->ISRJ->getInputTextType() ?>" data-table="VACTINATION" data-field="x_ISRJ" name="x_ISRJ" id="x_ISRJ" size="30" maxlength="1" placeholder="<?= HtmlEncode($Page->ISRJ->getPlaceHolder()) ?>" value="<?= $Page->ISRJ->EditValue ?>"<?= $Page->ISRJ->editAttributes() ?> aria-describedby="x_ISRJ_help">
<?= $Page->ISRJ->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ISRJ->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->AGEYEAR->Visible) { // AGEYEAR ?>
    <div id="r_AGEYEAR" class="form-group row">
        <label id="elh_VACTINATION_AGEYEAR" for="x_AGEYEAR" class="<?= $Page->LeftColumnClass ?>"><?= $Page->AGEYEAR->caption() ?><?= $Page->AGEYEAR->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->AGEYEAR->cellAttributes() ?>>
<span id="el_VACTINATION_AGEYEAR">
<input type="<?= $Page->AGEYEAR->getInputTextType() ?>" data-table="VACTINATION" data-field="x_AGEYEAR" name="x_AGEYEAR" id="x_AGEYEAR" size="30" placeholder="<?= HtmlEncode($Page->AGEYEAR->getPlaceHolder()) ?>" value="<?= $Page->AGEYEAR->EditValue ?>"<?= $Page->AGEYEAR->editAttributes() ?> aria-describedby="x_AGEYEAR_help">
<?= $Page->AGEYEAR->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->AGEYEAR->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->AGEMONTH->Visible) { // AGEMONTH ?>
    <div id="r_AGEMONTH" class="form-group row">
        <label id="elh_VACTINATION_AGEMONTH" for="x_AGEMONTH" class="<?= $Page->LeftColumnClass ?>"><?= $Page->AGEMONTH->caption() ?><?= $Page->AGEMONTH->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->AGEMONTH->cellAttributes() ?>>
<span id="el_VACTINATION_AGEMONTH">
<input type="<?= $Page->AGEMONTH->getInputTextType() ?>" data-table="VACTINATION" data-field="x_AGEMONTH" name="x_AGEMONTH" id="x_AGEMONTH" size="30" placeholder="<?= HtmlEncode($Page->AGEMONTH->getPlaceHolder()) ?>" value="<?= $Page->AGEMONTH->EditValue ?>"<?= $Page->AGEMONTH->editAttributes() ?> aria-describedby="x_AGEMONTH_help">
<?= $Page->AGEMONTH->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->AGEMONTH->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->AGEDAY->Visible) { // AGEDAY ?>
    <div id="r_AGEDAY" class="form-group row">
        <label id="elh_VACTINATION_AGEDAY" for="x_AGEDAY" class="<?= $Page->LeftColumnClass ?>"><?= $Page->AGEDAY->caption() ?><?= $Page->AGEDAY->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->AGEDAY->cellAttributes() ?>>
<span id="el_VACTINATION_AGEDAY">
<input type="<?= $Page->AGEDAY->getInputTextType() ?>" data-table="VACTINATION" data-field="x_AGEDAY" name="x_AGEDAY" id="x_AGEDAY" size="30" placeholder="<?= HtmlEncode($Page->AGEDAY->getPlaceHolder()) ?>" value="<?= $Page->AGEDAY->EditValue ?>"<?= $Page->AGEDAY->editAttributes() ?> aria-describedby="x_AGEDAY_help">
<?= $Page->AGEDAY->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->AGEDAY->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->STATUS_PASIEN_ID->Visible) { // STATUS_PASIEN_ID ?>
    <div id="r_STATUS_PASIEN_ID" class="form-group row">
        <label id="elh_VACTINATION_STATUS_PASIEN_ID" for="x_STATUS_PASIEN_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->STATUS_PASIEN_ID->caption() ?><?= $Page->STATUS_PASIEN_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->STATUS_PASIEN_ID->cellAttributes() ?>>
<span id="el_VACTINATION_STATUS_PASIEN_ID">
<input type="<?= $Page->STATUS_PASIEN_ID->getInputTextType() ?>" data-table="VACTINATION" data-field="x_STATUS_PASIEN_ID" name="x_STATUS_PASIEN_ID" id="x_STATUS_PASIEN_ID" size="30" placeholder="<?= HtmlEncode($Page->STATUS_PASIEN_ID->getPlaceHolder()) ?>" value="<?= $Page->STATUS_PASIEN_ID->EditValue ?>"<?= $Page->STATUS_PASIEN_ID->editAttributes() ?> aria-describedby="x_STATUS_PASIEN_ID_help">
<?= $Page->STATUS_PASIEN_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->STATUS_PASIEN_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->GENDER->Visible) { // GENDER ?>
    <div id="r_GENDER" class="form-group row">
        <label id="elh_VACTINATION_GENDER" for="x_GENDER" class="<?= $Page->LeftColumnClass ?>"><?= $Page->GENDER->caption() ?><?= $Page->GENDER->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->GENDER->cellAttributes() ?>>
<span id="el_VACTINATION_GENDER">
<input type="<?= $Page->GENDER->getInputTextType() ?>" data-table="VACTINATION" data-field="x_GENDER" name="x_GENDER" id="x_GENDER" size="30" maxlength="1" placeholder="<?= HtmlEncode($Page->GENDER->getPlaceHolder()) ?>" value="<?= $Page->GENDER->EditValue ?>"<?= $Page->GENDER->editAttributes() ?> aria-describedby="x_GENDER_help">
<?= $Page->GENDER->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->GENDER->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->DOCTOR->Visible) { // DOCTOR ?>
    <div id="r_DOCTOR" class="form-group row">
        <label id="elh_VACTINATION_DOCTOR" for="x_DOCTOR" class="<?= $Page->LeftColumnClass ?>"><?= $Page->DOCTOR->caption() ?><?= $Page->DOCTOR->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->DOCTOR->cellAttributes() ?>>
<span id="el_VACTINATION_DOCTOR">
<input type="<?= $Page->DOCTOR->getInputTextType() ?>" data-table="VACTINATION" data-field="x_DOCTOR" name="x_DOCTOR" id="x_DOCTOR" size="30" maxlength="150" placeholder="<?= HtmlEncode($Page->DOCTOR->getPlaceHolder()) ?>" value="<?= $Page->DOCTOR->EditValue ?>"<?= $Page->DOCTOR->editAttributes() ?> aria-describedby="x_DOCTOR_help">
<?= $Page->DOCTOR->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->DOCTOR->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->KAL_ID->Visible) { // KAL_ID ?>
    <div id="r_KAL_ID" class="form-group row">
        <label id="elh_VACTINATION_KAL_ID" for="x_KAL_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->KAL_ID->caption() ?><?= $Page->KAL_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->KAL_ID->cellAttributes() ?>>
<span id="el_VACTINATION_KAL_ID">
<input type="<?= $Page->KAL_ID->getInputTextType() ?>" data-table="VACTINATION" data-field="x_KAL_ID" name="x_KAL_ID" id="x_KAL_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->KAL_ID->getPlaceHolder()) ?>" value="<?= $Page->KAL_ID->EditValue ?>"<?= $Page->KAL_ID->editAttributes() ?> aria-describedby="x_KAL_ID_help">
<?= $Page->KAL_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->KAL_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->CLASS_ROOM_ID->Visible) { // CLASS_ROOM_ID ?>
    <div id="r_CLASS_ROOM_ID" class="form-group row">
        <label id="elh_VACTINATION_CLASS_ROOM_ID" for="x_CLASS_ROOM_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->CLASS_ROOM_ID->caption() ?><?= $Page->CLASS_ROOM_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->CLASS_ROOM_ID->cellAttributes() ?>>
<span id="el_VACTINATION_CLASS_ROOM_ID">
<input type="<?= $Page->CLASS_ROOM_ID->getInputTextType() ?>" data-table="VACTINATION" data-field="x_CLASS_ROOM_ID" name="x_CLASS_ROOM_ID" id="x_CLASS_ROOM_ID" size="30" maxlength="15" placeholder="<?= HtmlEncode($Page->CLASS_ROOM_ID->getPlaceHolder()) ?>" value="<?= $Page->CLASS_ROOM_ID->EditValue ?>"<?= $Page->CLASS_ROOM_ID->editAttributes() ?> aria-describedby="x_CLASS_ROOM_ID_help">
<?= $Page->CLASS_ROOM_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->CLASS_ROOM_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->BED_ID->Visible) { // BED_ID ?>
    <div id="r_BED_ID" class="form-group row">
        <label id="elh_VACTINATION_BED_ID" for="x_BED_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->BED_ID->caption() ?><?= $Page->BED_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->BED_ID->cellAttributes() ?>>
<span id="el_VACTINATION_BED_ID">
<input type="<?= $Page->BED_ID->getInputTextType() ?>" data-table="VACTINATION" data-field="x_BED_ID" name="x_BED_ID" id="x_BED_ID" size="30" placeholder="<?= HtmlEncode($Page->BED_ID->getPlaceHolder()) ?>" value="<?= $Page->BED_ID->EditValue ?>"<?= $Page->BED_ID->editAttributes() ?> aria-describedby="x_BED_ID_help">
<?= $Page->BED_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->BED_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->KELUAR_ID->Visible) { // KELUAR_ID ?>
    <div id="r_KELUAR_ID" class="form-group row">
        <label id="elh_VACTINATION_KELUAR_ID" for="x_KELUAR_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->KELUAR_ID->caption() ?><?= $Page->KELUAR_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->KELUAR_ID->cellAttributes() ?>>
<span id="el_VACTINATION_KELUAR_ID">
<input type="<?= $Page->KELUAR_ID->getInputTextType() ?>" data-table="VACTINATION" data-field="x_KELUAR_ID" name="x_KELUAR_ID" id="x_KELUAR_ID" size="30" placeholder="<?= HtmlEncode($Page->KELUAR_ID->getPlaceHolder()) ?>" value="<?= $Page->KELUAR_ID->EditValue ?>"<?= $Page->KELUAR_ID->editAttributes() ?> aria-describedby="x_KELUAR_ID_help">
<?= $Page->KELUAR_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->KELUAR_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$Page->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("SaveBtn") ?></button>
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
    ew.addEventHandlers("VACTINATION");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
