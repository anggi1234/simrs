<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

// Page object
$VTreatmentbillEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fV_TREATMENTBILLedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fV_TREATMENTBILLedit = currentForm = new ew.Form("fV_TREATMENTBILLedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "V_TREATMENTBILL")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.V_TREATMENTBILL)
        ew.vars.tables.V_TREATMENTBILL = currentTable;
    fV_TREATMENTBILLedit.addFields([
        ["NAME_OF_PASIEN", [fields.NAME_OF_PASIEN.visible && fields.NAME_OF_PASIEN.required ? ew.Validators.required(fields.NAME_OF_PASIEN.caption) : null], fields.NAME_OF_PASIEN.isInvalid],
        ["date_of_birth", [fields.date_of_birth.visible && fields.date_of_birth.required ? ew.Validators.required(fields.date_of_birth.caption) : null, ew.Validators.datetime(0)], fields.date_of_birth.isInvalid],
        ["CONTACT_ADDRESS", [fields.CONTACT_ADDRESS.visible && fields.CONTACT_ADDRESS.required ? ew.Validators.required(fields.CONTACT_ADDRESS.caption) : null], fields.CONTACT_ADDRESS.isInvalid],
        ["PHONE_NUMBER", [fields.PHONE_NUMBER.visible && fields.PHONE_NUMBER.required ? ew.Validators.required(fields.PHONE_NUMBER.caption) : null], fields.PHONE_NUMBER.isInvalid],
        ["MOBILE", [fields.MOBILE.visible && fields.MOBILE.required ? ew.Validators.required(fields.MOBILE.caption) : null], fields.MOBILE.isInvalid],
        ["PLACE_OF_BIRTH", [fields.PLACE_OF_BIRTH.visible && fields.PLACE_OF_BIRTH.required ? ew.Validators.required(fields.PLACE_OF_BIRTH.caption) : null], fields.PLACE_OF_BIRTH.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fV_TREATMENTBILLedit,
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
    fV_TREATMENTBILLedit.validate = function () {
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
    fV_TREATMENTBILLedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fV_TREATMENTBILLedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fV_TREATMENTBILLedit");
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
<form name="fV_TREATMENTBILLedit" id="fV_TREATMENTBILLedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="V_TREATMENTBILL">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
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
loadjs.ready(["fV_TREATMENTBILLedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fV_TREATMENTBILLedit", "x_date_of_birth", {"ignoreReadonly":true,"useCurrent":false,"format":0});
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
    <input type="hidden" data-table="V_TREATMENTBILL" data-field="x_visit_id" data-hidden="1" name="x_visit_id" id="x_visit_id" value="<?= HtmlEncode($Page->visit_id->CurrentValue) ?>">
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
    ew.addEventHandlers("V_TREATMENTBILL");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
