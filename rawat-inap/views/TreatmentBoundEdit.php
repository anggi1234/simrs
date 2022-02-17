<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

// Page object
$TreatmentBoundEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fTREATMENT_BOUNDedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fTREATMENT_BOUNDedit = currentForm = new ew.Form("fTREATMENT_BOUNDedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "TREATMENT_BOUND")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.TREATMENT_BOUND)
        ew.vars.tables.TREATMENT_BOUND = currentTable;
    fTREATMENT_BOUNDedit.addFields([
        ["ORG_UNIT_CODE", [fields.ORG_UNIT_CODE.visible && fields.ORG_UNIT_CODE.required ? ew.Validators.required(fields.ORG_UNIT_CODE.caption) : null], fields.ORG_UNIT_CODE.isInvalid],
        ["REAGENT_ID", [fields.REAGENT_ID.visible && fields.REAGENT_ID.required ? ew.Validators.required(fields.REAGENT_ID.caption) : null], fields.REAGENT_ID.isInvalid],
        ["CLINIC_ID", [fields.CLINIC_ID.visible && fields.CLINIC_ID.required ? ew.Validators.required(fields.CLINIC_ID.caption) : null], fields.CLINIC_ID.isInvalid],
        ["TREAT_ID", [fields.TREAT_ID.visible && fields.TREAT_ID.required ? ew.Validators.required(fields.TREAT_ID.caption) : null], fields.TREAT_ID.isInvalid],
        ["REAGENT_NAME", [fields.REAGENT_NAME.visible && fields.REAGENT_NAME.required ? ew.Validators.required(fields.REAGENT_NAME.caption) : null], fields.REAGENT_NAME.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fTREATMENT_BOUNDedit,
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
    fTREATMENT_BOUNDedit.validate = function () {
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
    fTREATMENT_BOUNDedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fTREATMENT_BOUNDedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fTREATMENT_BOUNDedit");
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
<form name="fTREATMENT_BOUNDedit" id="fTREATMENT_BOUNDedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="TREATMENT_BOUND">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->ORG_UNIT_CODE->Visible) { // ORG_UNIT_CODE ?>
    <div id="r_ORG_UNIT_CODE" class="form-group row">
        <label id="elh_TREATMENT_BOUND_ORG_UNIT_CODE" for="x_ORG_UNIT_CODE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ORG_UNIT_CODE->caption() ?><?= $Page->ORG_UNIT_CODE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ORG_UNIT_CODE->cellAttributes() ?>>
<input type="<?= $Page->ORG_UNIT_CODE->getInputTextType() ?>" data-table="TREATMENT_BOUND" data-field="x_ORG_UNIT_CODE" name="x_ORG_UNIT_CODE" id="x_ORG_UNIT_CODE" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->ORG_UNIT_CODE->getPlaceHolder()) ?>" value="<?= $Page->ORG_UNIT_CODE->EditValue ?>"<?= $Page->ORG_UNIT_CODE->editAttributes() ?> aria-describedby="x_ORG_UNIT_CODE_help">
<?= $Page->ORG_UNIT_CODE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ORG_UNIT_CODE->getErrorMessage() ?></div>
<input type="hidden" data-table="TREATMENT_BOUND" data-field="x_ORG_UNIT_CODE" data-hidden="1" name="o_ORG_UNIT_CODE" id="o_ORG_UNIT_CODE" value="<?= HtmlEncode($Page->ORG_UNIT_CODE->OldValue ?? $Page->ORG_UNIT_CODE->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->REAGENT_ID->Visible) { // REAGENT_ID ?>
    <div id="r_REAGENT_ID" class="form-group row">
        <label id="elh_TREATMENT_BOUND_REAGENT_ID" for="x_REAGENT_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->REAGENT_ID->caption() ?><?= $Page->REAGENT_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->REAGENT_ID->cellAttributes() ?>>
<input type="<?= $Page->REAGENT_ID->getInputTextType() ?>" data-table="TREATMENT_BOUND" data-field="x_REAGENT_ID" name="x_REAGENT_ID" id="x_REAGENT_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->REAGENT_ID->getPlaceHolder()) ?>" value="<?= $Page->REAGENT_ID->EditValue ?>"<?= $Page->REAGENT_ID->editAttributes() ?> aria-describedby="x_REAGENT_ID_help">
<?= $Page->REAGENT_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->REAGENT_ID->getErrorMessage() ?></div>
<input type="hidden" data-table="TREATMENT_BOUND" data-field="x_REAGENT_ID" data-hidden="1" name="o_REAGENT_ID" id="o_REAGENT_ID" value="<?= HtmlEncode($Page->REAGENT_ID->OldValue ?? $Page->REAGENT_ID->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->CLINIC_ID->Visible) { // CLINIC_ID ?>
    <div id="r_CLINIC_ID" class="form-group row">
        <label id="elh_TREATMENT_BOUND_CLINIC_ID" for="x_CLINIC_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->CLINIC_ID->caption() ?><?= $Page->CLINIC_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->CLINIC_ID->cellAttributes() ?>>
<span id="el_TREATMENT_BOUND_CLINIC_ID">
<input type="<?= $Page->CLINIC_ID->getInputTextType() ?>" data-table="TREATMENT_BOUND" data-field="x_CLINIC_ID" name="x_CLINIC_ID" id="x_CLINIC_ID" size="30" maxlength="8" placeholder="<?= HtmlEncode($Page->CLINIC_ID->getPlaceHolder()) ?>" value="<?= $Page->CLINIC_ID->EditValue ?>"<?= $Page->CLINIC_ID->editAttributes() ?> aria-describedby="x_CLINIC_ID_help">
<?= $Page->CLINIC_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->CLINIC_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->TREAT_ID->Visible) { // TREAT_ID ?>
    <div id="r_TREAT_ID" class="form-group row">
        <label id="elh_TREATMENT_BOUND_TREAT_ID" for="x_TREAT_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->TREAT_ID->caption() ?><?= $Page->TREAT_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->TREAT_ID->cellAttributes() ?>>
<span id="el_TREATMENT_BOUND_TREAT_ID">
<input type="<?= $Page->TREAT_ID->getInputTextType() ?>" data-table="TREATMENT_BOUND" data-field="x_TREAT_ID" name="x_TREAT_ID" id="x_TREAT_ID" size="30" maxlength="25" placeholder="<?= HtmlEncode($Page->TREAT_ID->getPlaceHolder()) ?>" value="<?= $Page->TREAT_ID->EditValue ?>"<?= $Page->TREAT_ID->editAttributes() ?> aria-describedby="x_TREAT_ID_help">
<?= $Page->TREAT_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->TREAT_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->REAGENT_NAME->Visible) { // REAGENT_NAME ?>
    <div id="r_REAGENT_NAME" class="form-group row">
        <label id="elh_TREATMENT_BOUND_REAGENT_NAME" for="x_REAGENT_NAME" class="<?= $Page->LeftColumnClass ?>"><?= $Page->REAGENT_NAME->caption() ?><?= $Page->REAGENT_NAME->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->REAGENT_NAME->cellAttributes() ?>>
<span id="el_TREATMENT_BOUND_REAGENT_NAME">
<input type="<?= $Page->REAGENT_NAME->getInputTextType() ?>" data-table="TREATMENT_BOUND" data-field="x_REAGENT_NAME" name="x_REAGENT_NAME" id="x_REAGENT_NAME" size="30" maxlength="200" placeholder="<?= HtmlEncode($Page->REAGENT_NAME->getPlaceHolder()) ?>" value="<?= $Page->REAGENT_NAME->EditValue ?>"<?= $Page->REAGENT_NAME->editAttributes() ?> aria-describedby="x_REAGENT_NAME_help">
<?= $Page->REAGENT_NAME->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->REAGENT_NAME->getErrorMessage() ?></div>
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
    ew.addEventHandlers("TREATMENT_BOUND");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
