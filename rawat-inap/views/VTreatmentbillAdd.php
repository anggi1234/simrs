<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

// Page object
$VTreatmentbillAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fV_TREATMENTBILLadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fV_TREATMENTBILLadd = currentForm = new ew.Form("fV_TREATMENTBILLadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "V_TREATMENTBILL")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.V_TREATMENTBILL)
        ew.vars.tables.V_TREATMENTBILL = currentTable;
    fV_TREATMENTBILLadd.addFields([
        ["NAME_OF_PASIEN", [fields.NAME_OF_PASIEN.visible && fields.NAME_OF_PASIEN.required ? ew.Validators.required(fields.NAME_OF_PASIEN.caption) : null], fields.NAME_OF_PASIEN.isInvalid],
        ["NO_REGISTRATION", [fields.NO_REGISTRATION.visible && fields.NO_REGISTRATION.required ? ew.Validators.required(fields.NO_REGISTRATION.caption) : null], fields.NO_REGISTRATION.isInvalid],
        ["ORG_UNIT_CODE", [fields.ORG_UNIT_CODE.visible && fields.ORG_UNIT_CODE.required ? ew.Validators.required(fields.ORG_UNIT_CODE.caption) : null], fields.ORG_UNIT_CODE.isInvalid],
        ["date_of_birth", [fields.date_of_birth.visible && fields.date_of_birth.required ? ew.Validators.required(fields.date_of_birth.caption) : null, ew.Validators.datetime(0)], fields.date_of_birth.isInvalid],
        ["CONTACT_ADDRESS", [fields.CONTACT_ADDRESS.visible && fields.CONTACT_ADDRESS.required ? ew.Validators.required(fields.CONTACT_ADDRESS.caption) : null], fields.CONTACT_ADDRESS.isInvalid],
        ["PHONE_NUMBER", [fields.PHONE_NUMBER.visible && fields.PHONE_NUMBER.required ? ew.Validators.required(fields.PHONE_NUMBER.caption) : null], fields.PHONE_NUMBER.isInvalid],
        ["MOBILE", [fields.MOBILE.visible && fields.MOBILE.required ? ew.Validators.required(fields.MOBILE.caption) : null], fields.MOBILE.isInvalid],
        ["PLACE_OF_BIRTH", [fields.PLACE_OF_BIRTH.visible && fields.PLACE_OF_BIRTH.required ? ew.Validators.required(fields.PLACE_OF_BIRTH.caption) : null], fields.PLACE_OF_BIRTH.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fV_TREATMENTBILLadd,
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
    fV_TREATMENTBILLadd.validate = function () {
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
    fV_TREATMENTBILLadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fV_TREATMENTBILLadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fV_TREATMENTBILLadd.lists.NO_REGISTRATION = <?= $Page->NO_REGISTRATION->toClientList($Page) ?>;
    loadjs.done("fV_TREATMENTBILLadd");
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
<form name="fV_TREATMENTBILLadd" id="fV_TREATMENTBILLadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="V_TREATMENTBILL">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->NAME_OF_PASIEN->Visible) { // NAME_OF_PASIEN ?>
    <div id="r_NAME_OF_PASIEN" class="form-group row">
        <label id="elh_V_TREATMENTBILL_NAME_OF_PASIEN" for="x_NAME_OF_PASIEN" class="<?= $Page->LeftColumnClass ?>"><?= $Page->NAME_OF_PASIEN->caption() ?><?= $Page->NAME_OF_PASIEN->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->NAME_OF_PASIEN->cellAttributes() ?>>
<span id="el_V_TREATMENTBILL_NAME_OF_PASIEN">
<input type="<?= $Page->NAME_OF_PASIEN->getInputTextType() ?>" data-table="V_TREATMENTBILL" data-field="x_NAME_OF_PASIEN" name="x_NAME_OF_PASIEN" id="x_NAME_OF_PASIEN" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->NAME_OF_PASIEN->getPlaceHolder()) ?>" value="<?= $Page->NAME_OF_PASIEN->EditValue ?>"<?= $Page->NAME_OF_PASIEN->editAttributes() ?> aria-describedby="x_NAME_OF_PASIEN_help">
<?= $Page->NAME_OF_PASIEN->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->NAME_OF_PASIEN->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->NO_REGISTRATION->Visible) { // NO_REGISTRATION ?>
    <div id="r_NO_REGISTRATION" class="form-group row">
        <label id="elh_V_TREATMENTBILL_NO_REGISTRATION" for="x_NO_REGISTRATION" class="<?= $Page->LeftColumnClass ?>"><?= $Page->NO_REGISTRATION->caption() ?><?= $Page->NO_REGISTRATION->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->NO_REGISTRATION->cellAttributes() ?>>
<span id="el_V_TREATMENTBILL_NO_REGISTRATION">
<div class="input-group ew-lookup-list" aria-describedby="x_NO_REGISTRATION_help">
    <div class="form-control ew-lookup-text" tabindex="-1" id="lu_x_NO_REGISTRATION"><?= EmptyValue(strval($Page->NO_REGISTRATION->ViewValue)) ? $Language->phrase("PleaseSelect") : $Page->NO_REGISTRATION->ViewValue ?></div>
    <div class="input-group-append">
        <button type="button" title="<?= HtmlEncode(str_replace("%s", RemoveHtml($Page->NO_REGISTRATION->caption()), $Language->phrase("LookupLink", true))) ?>" class="ew-lookup-btn btn btn-default"<?= ($Page->NO_REGISTRATION->ReadOnly || $Page->NO_REGISTRATION->Disabled) ? " disabled" : "" ?> onclick="ew.modalLookupShow({lnk:this,el:'x_NO_REGISTRATION',m:0,n:10});"><i class="fas fa-search ew-icon"></i></button>
    </div>
</div>
<div class="invalid-feedback"><?= $Page->NO_REGISTRATION->getErrorMessage() ?></div>
<?= $Page->NO_REGISTRATION->getCustomMessage() ?>
<?= $Page->NO_REGISTRATION->Lookup->getParamTag($Page, "p_x_NO_REGISTRATION") ?>
<input type="hidden" is="selection-list" data-table="V_TREATMENTBILL" data-field="x_NO_REGISTRATION" data-type="text" data-multiple="0" data-lookup="1" data-value-separator="<?= $Page->NO_REGISTRATION->displayValueSeparatorAttribute() ?>" name="x_NO_REGISTRATION" id="x_NO_REGISTRATION" value="<?= $Page->NO_REGISTRATION->CurrentValue ?>"<?= $Page->NO_REGISTRATION->editAttributes() ?>>
</span>
</div></div>
    </div>
<?php } ?>
    <span id="el_V_TREATMENTBILL_ORG_UNIT_CODE">
    <input type="hidden" data-table="V_TREATMENTBILL" data-field="x_ORG_UNIT_CODE" data-hidden="1" name="x_ORG_UNIT_CODE" id="x_ORG_UNIT_CODE" value="<?= HtmlEncode($Page->ORG_UNIT_CODE->CurrentValue) ?>">
    </span>
<?php if ($Page->date_of_birth->Visible) { // date_of_birth ?>
    <div id="r_date_of_birth" class="form-group row">
        <label id="elh_V_TREATMENTBILL_date_of_birth" for="x_date_of_birth" class="<?= $Page->LeftColumnClass ?>"><?= $Page->date_of_birth->caption() ?><?= $Page->date_of_birth->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->date_of_birth->cellAttributes() ?>>
<span id="el_V_TREATMENTBILL_date_of_birth">
<input type="<?= $Page->date_of_birth->getInputTextType() ?>" data-table="V_TREATMENTBILL" data-field="x_date_of_birth" name="x_date_of_birth" id="x_date_of_birth" placeholder="<?= HtmlEncode($Page->date_of_birth->getPlaceHolder()) ?>" value="<?= $Page->date_of_birth->EditValue ?>"<?= $Page->date_of_birth->editAttributes() ?> aria-describedby="x_date_of_birth_help">
<?= $Page->date_of_birth->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->date_of_birth->getErrorMessage() ?></div>
<?php if (!$Page->date_of_birth->ReadOnly && !$Page->date_of_birth->Disabled && !isset($Page->date_of_birth->EditAttrs["readonly"]) && !isset($Page->date_of_birth->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fV_TREATMENTBILLadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fV_TREATMENTBILLadd", "x_date_of_birth", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->CONTACT_ADDRESS->Visible) { // CONTACT_ADDRESS ?>
    <div id="r_CONTACT_ADDRESS" class="form-group row">
        <label id="elh_V_TREATMENTBILL_CONTACT_ADDRESS" for="x_CONTACT_ADDRESS" class="<?= $Page->LeftColumnClass ?>"><?= $Page->CONTACT_ADDRESS->caption() ?><?= $Page->CONTACT_ADDRESS->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->CONTACT_ADDRESS->cellAttributes() ?>>
<span id="el_V_TREATMENTBILL_CONTACT_ADDRESS">
<input type="<?= $Page->CONTACT_ADDRESS->getInputTextType() ?>" data-table="V_TREATMENTBILL" data-field="x_CONTACT_ADDRESS" name="x_CONTACT_ADDRESS" id="x_CONTACT_ADDRESS" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->CONTACT_ADDRESS->getPlaceHolder()) ?>" value="<?= $Page->CONTACT_ADDRESS->EditValue ?>"<?= $Page->CONTACT_ADDRESS->editAttributes() ?> aria-describedby="x_CONTACT_ADDRESS_help">
<?= $Page->CONTACT_ADDRESS->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->CONTACT_ADDRESS->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->PHONE_NUMBER->Visible) { // PHONE_NUMBER ?>
    <div id="r_PHONE_NUMBER" class="form-group row">
        <label id="elh_V_TREATMENTBILL_PHONE_NUMBER" for="x_PHONE_NUMBER" class="<?= $Page->LeftColumnClass ?>"><?= $Page->PHONE_NUMBER->caption() ?><?= $Page->PHONE_NUMBER->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PHONE_NUMBER->cellAttributes() ?>>
<span id="el_V_TREATMENTBILL_PHONE_NUMBER">
<input type="<?= $Page->PHONE_NUMBER->getInputTextType() ?>" data-table="V_TREATMENTBILL" data-field="x_PHONE_NUMBER" name="x_PHONE_NUMBER" id="x_PHONE_NUMBER" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->PHONE_NUMBER->getPlaceHolder()) ?>" value="<?= $Page->PHONE_NUMBER->EditValue ?>"<?= $Page->PHONE_NUMBER->editAttributes() ?> aria-describedby="x_PHONE_NUMBER_help">
<?= $Page->PHONE_NUMBER->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->PHONE_NUMBER->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->MOBILE->Visible) { // MOBILE ?>
    <div id="r_MOBILE" class="form-group row">
        <label id="elh_V_TREATMENTBILL_MOBILE" for="x_MOBILE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->MOBILE->caption() ?><?= $Page->MOBILE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->MOBILE->cellAttributes() ?>>
<span id="el_V_TREATMENTBILL_MOBILE">
<input type="<?= $Page->MOBILE->getInputTextType() ?>" data-table="V_TREATMENTBILL" data-field="x_MOBILE" name="x_MOBILE" id="x_MOBILE" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->MOBILE->getPlaceHolder()) ?>" value="<?= $Page->MOBILE->EditValue ?>"<?= $Page->MOBILE->editAttributes() ?> aria-describedby="x_MOBILE_help">
<?= $Page->MOBILE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->MOBILE->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->PLACE_OF_BIRTH->Visible) { // PLACE_OF_BIRTH ?>
    <div id="r_PLACE_OF_BIRTH" class="form-group row">
        <label id="elh_V_TREATMENTBILL_PLACE_OF_BIRTH" for="x_PLACE_OF_BIRTH" class="<?= $Page->LeftColumnClass ?>"><?= $Page->PLACE_OF_BIRTH->caption() ?><?= $Page->PLACE_OF_BIRTH->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PLACE_OF_BIRTH->cellAttributes() ?>>
<span id="el_V_TREATMENTBILL_PLACE_OF_BIRTH">
<input type="<?= $Page->PLACE_OF_BIRTH->getInputTextType() ?>" data-table="V_TREATMENTBILL" data-field="x_PLACE_OF_BIRTH" name="x_PLACE_OF_BIRTH" id="x_PLACE_OF_BIRTH" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->PLACE_OF_BIRTH->getPlaceHolder()) ?>" value="<?= $Page->PLACE_OF_BIRTH->EditValue ?>"<?= $Page->PLACE_OF_BIRTH->editAttributes() ?> aria-describedby="x_PLACE_OF_BIRTH_help">
<?= $Page->PLACE_OF_BIRTH->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->PLACE_OF_BIRTH->getErrorMessage() ?></div>
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
    ew.addEventHandlers("V_TREATMENTBILL");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
