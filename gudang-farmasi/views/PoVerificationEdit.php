<?php

namespace PHPMaker2021\SIMRSSQLSERVERGUDANGFARMASI;

// Page object
$PoVerificationEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fPO_VERIFICATIONedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fPO_VERIFICATIONedit = currentForm = new ew.Form("fPO_VERIFICATIONedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "PO_VERIFICATION")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.PO_VERIFICATION)
        ew.vars.tables.PO_VERIFICATION = currentTable;
    fPO_VERIFICATIONedit.addFields([
        ["PO", [fields.PO.visible && fields.PO.required ? ew.Validators.required(fields.PO.caption) : null], fields.PO.isInvalid],
        ["ISVALID", [fields.ISVALID.visible && fields.ISVALID.required ? ew.Validators.required(fields.ISVALID.caption) : null], fields.ISVALID.isInvalid],
        ["VERIFIED_DATE", [fields.VERIFIED_DATE.visible && fields.VERIFIED_DATE.required ? ew.Validators.required(fields.VERIFIED_DATE.caption) : null, ew.Validators.datetime(0)], fields.VERIFIED_DATE.isInvalid],
        ["VERIFIED_BY", [fields.VERIFIED_BY.visible && fields.VERIFIED_BY.required ? ew.Validators.required(fields.VERIFIED_BY.caption) : null], fields.VERIFIED_BY.isInvalid],
        ["VERIFICATION_DESC", [fields.VERIFICATION_DESC.visible && fields.VERIFICATION_DESC.required ? ew.Validators.required(fields.VERIFICATION_DESC.caption) : null], fields.VERIFICATION_DESC.isInvalid],
        ["MODIFIED_DATE", [fields.MODIFIED_DATE.visible && fields.MODIFIED_DATE.required ? ew.Validators.required(fields.MODIFIED_DATE.caption) : null, ew.Validators.datetime(0)], fields.MODIFIED_DATE.isInvalid],
        ["MODIFIED_BY", [fields.MODIFIED_BY.visible && fields.MODIFIED_BY.required ? ew.Validators.required(fields.MODIFIED_BY.caption) : null], fields.MODIFIED_BY.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fPO_VERIFICATIONedit,
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
    fPO_VERIFICATIONedit.validate = function () {
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
    fPO_VERIFICATIONedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fPO_VERIFICATIONedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fPO_VERIFICATIONedit");
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
<form name="fPO_VERIFICATIONedit" id="fPO_VERIFICATIONedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="PO_VERIFICATION">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->PO->Visible) { // PO ?>
    <div id="r_PO" class="form-group row">
        <label id="elh_PO_VERIFICATION_PO" for="x_PO" class="<?= $Page->LeftColumnClass ?>"><?= $Page->PO->caption() ?><?= $Page->PO->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PO->cellAttributes() ?>>
<input type="<?= $Page->PO->getInputTextType() ?>" data-table="PO_VERIFICATION" data-field="x_PO" name="x_PO" id="x_PO" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->PO->getPlaceHolder()) ?>" value="<?= $Page->PO->EditValue ?>"<?= $Page->PO->editAttributes() ?> aria-describedby="x_PO_help">
<?= $Page->PO->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->PO->getErrorMessage() ?></div>
<input type="hidden" data-table="PO_VERIFICATION" data-field="x_PO" data-hidden="1" name="o_PO" id="o_PO" value="<?= HtmlEncode($Page->PO->OldValue ?? $Page->PO->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ISVALID->Visible) { // ISVALID ?>
    <div id="r_ISVALID" class="form-group row">
        <label id="elh_PO_VERIFICATION_ISVALID" for="x_ISVALID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ISVALID->caption() ?><?= $Page->ISVALID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ISVALID->cellAttributes() ?>>
<input type="<?= $Page->ISVALID->getInputTextType() ?>" data-table="PO_VERIFICATION" data-field="x_ISVALID" name="x_ISVALID" id="x_ISVALID" size="30" maxlength="1" placeholder="<?= HtmlEncode($Page->ISVALID->getPlaceHolder()) ?>" value="<?= $Page->ISVALID->EditValue ?>"<?= $Page->ISVALID->editAttributes() ?> aria-describedby="x_ISVALID_help">
<?= $Page->ISVALID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ISVALID->getErrorMessage() ?></div>
<input type="hidden" data-table="PO_VERIFICATION" data-field="x_ISVALID" data-hidden="1" name="o_ISVALID" id="o_ISVALID" value="<?= HtmlEncode($Page->ISVALID->OldValue ?? $Page->ISVALID->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->VERIFIED_DATE->Visible) { // VERIFIED_DATE ?>
    <div id="r_VERIFIED_DATE" class="form-group row">
        <label id="elh_PO_VERIFICATION_VERIFIED_DATE" for="x_VERIFIED_DATE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->VERIFIED_DATE->caption() ?><?= $Page->VERIFIED_DATE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->VERIFIED_DATE->cellAttributes() ?>>
<input type="<?= $Page->VERIFIED_DATE->getInputTextType() ?>" data-table="PO_VERIFICATION" data-field="x_VERIFIED_DATE" name="x_VERIFIED_DATE" id="x_VERIFIED_DATE" placeholder="<?= HtmlEncode($Page->VERIFIED_DATE->getPlaceHolder()) ?>" value="<?= $Page->VERIFIED_DATE->EditValue ?>"<?= $Page->VERIFIED_DATE->editAttributes() ?> aria-describedby="x_VERIFIED_DATE_help">
<?= $Page->VERIFIED_DATE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->VERIFIED_DATE->getErrorMessage() ?></div>
<?php if (!$Page->VERIFIED_DATE->ReadOnly && !$Page->VERIFIED_DATE->Disabled && !isset($Page->VERIFIED_DATE->EditAttrs["readonly"]) && !isset($Page->VERIFIED_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fPO_VERIFICATIONedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fPO_VERIFICATIONedit", "x_VERIFIED_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
<input type="hidden" data-table="PO_VERIFICATION" data-field="x_VERIFIED_DATE" data-hidden="1" name="o_VERIFIED_DATE" id="o_VERIFIED_DATE" value="<?= HtmlEncode($Page->VERIFIED_DATE->OldValue ?? $Page->VERIFIED_DATE->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->VERIFIED_BY->Visible) { // VERIFIED_BY ?>
    <div id="r_VERIFIED_BY" class="form-group row">
        <label id="elh_PO_VERIFICATION_VERIFIED_BY" for="x_VERIFIED_BY" class="<?= $Page->LeftColumnClass ?>"><?= $Page->VERIFIED_BY->caption() ?><?= $Page->VERIFIED_BY->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->VERIFIED_BY->cellAttributes() ?>>
<span id="el_PO_VERIFICATION_VERIFIED_BY">
<input type="<?= $Page->VERIFIED_BY->getInputTextType() ?>" data-table="PO_VERIFICATION" data-field="x_VERIFIED_BY" name="x_VERIFIED_BY" id="x_VERIFIED_BY" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->VERIFIED_BY->getPlaceHolder()) ?>" value="<?= $Page->VERIFIED_BY->EditValue ?>"<?= $Page->VERIFIED_BY->editAttributes() ?> aria-describedby="x_VERIFIED_BY_help">
<?= $Page->VERIFIED_BY->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->VERIFIED_BY->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->VERIFICATION_DESC->Visible) { // VERIFICATION_DESC ?>
    <div id="r_VERIFICATION_DESC" class="form-group row">
        <label id="elh_PO_VERIFICATION_VERIFICATION_DESC" for="x_VERIFICATION_DESC" class="<?= $Page->LeftColumnClass ?>"><?= $Page->VERIFICATION_DESC->caption() ?><?= $Page->VERIFICATION_DESC->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->VERIFICATION_DESC->cellAttributes() ?>>
<span id="el_PO_VERIFICATION_VERIFICATION_DESC">
<input type="<?= $Page->VERIFICATION_DESC->getInputTextType() ?>" data-table="PO_VERIFICATION" data-field="x_VERIFICATION_DESC" name="x_VERIFICATION_DESC" id="x_VERIFICATION_DESC" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->VERIFICATION_DESC->getPlaceHolder()) ?>" value="<?= $Page->VERIFICATION_DESC->EditValue ?>"<?= $Page->VERIFICATION_DESC->editAttributes() ?> aria-describedby="x_VERIFICATION_DESC_help">
<?= $Page->VERIFICATION_DESC->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->VERIFICATION_DESC->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
    <div id="r_MODIFIED_DATE" class="form-group row">
        <label id="elh_PO_VERIFICATION_MODIFIED_DATE" for="x_MODIFIED_DATE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->MODIFIED_DATE->caption() ?><?= $Page->MODIFIED_DATE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->MODIFIED_DATE->cellAttributes() ?>>
<span id="el_PO_VERIFICATION_MODIFIED_DATE">
<input type="<?= $Page->MODIFIED_DATE->getInputTextType() ?>" data-table="PO_VERIFICATION" data-field="x_MODIFIED_DATE" name="x_MODIFIED_DATE" id="x_MODIFIED_DATE" placeholder="<?= HtmlEncode($Page->MODIFIED_DATE->getPlaceHolder()) ?>" value="<?= $Page->MODIFIED_DATE->EditValue ?>"<?= $Page->MODIFIED_DATE->editAttributes() ?> aria-describedby="x_MODIFIED_DATE_help">
<?= $Page->MODIFIED_DATE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->MODIFIED_DATE->getErrorMessage() ?></div>
<?php if (!$Page->MODIFIED_DATE->ReadOnly && !$Page->MODIFIED_DATE->Disabled && !isset($Page->MODIFIED_DATE->EditAttrs["readonly"]) && !isset($Page->MODIFIED_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fPO_VERIFICATIONedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fPO_VERIFICATIONedit", "x_MODIFIED_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
    <div id="r_MODIFIED_BY" class="form-group row">
        <label id="elh_PO_VERIFICATION_MODIFIED_BY" for="x_MODIFIED_BY" class="<?= $Page->LeftColumnClass ?>"><?= $Page->MODIFIED_BY->caption() ?><?= $Page->MODIFIED_BY->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->MODIFIED_BY->cellAttributes() ?>>
<span id="el_PO_VERIFICATION_MODIFIED_BY">
<input type="<?= $Page->MODIFIED_BY->getInputTextType() ?>" data-table="PO_VERIFICATION" data-field="x_MODIFIED_BY" name="x_MODIFIED_BY" id="x_MODIFIED_BY" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->MODIFIED_BY->getPlaceHolder()) ?>" value="<?= $Page->MODIFIED_BY->EditValue ?>"<?= $Page->MODIFIED_BY->editAttributes() ?> aria-describedby="x_MODIFIED_BY_help">
<?= $Page->MODIFIED_BY->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->MODIFIED_BY->getErrorMessage() ?></div>
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
    ew.addEventHandlers("PO_VERIFICATION");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
