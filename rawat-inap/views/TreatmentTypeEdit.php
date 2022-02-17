<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

// Page object
$TreatmentTypeEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fTREATMENT_TYPEedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fTREATMENT_TYPEedit = currentForm = new ew.Form("fTREATMENT_TYPEedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "TREATMENT_TYPE")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.TREATMENT_TYPE)
        ew.vars.tables.TREATMENT_TYPE = currentTable;
    fTREATMENT_TYPEedit.addFields([
        ["TREAT_TYPE", [fields.TREAT_TYPE.visible && fields.TREAT_TYPE.required ? ew.Validators.required(fields.TREAT_TYPE.caption) : null], fields.TREAT_TYPE.isInvalid],
        ["OBJECT_CATEGORY_ID", [fields.OBJECT_CATEGORY_ID.visible && fields.OBJECT_CATEGORY_ID.required ? ew.Validators.required(fields.OBJECT_CATEGORY_ID.caption) : null, ew.Validators.integer], fields.OBJECT_CATEGORY_ID.isInvalid],
        ["TYPE_OF_TREATMENT", [fields.TYPE_OF_TREATMENT.visible && fields.TYPE_OF_TREATMENT.required ? ew.Validators.required(fields.TYPE_OF_TREATMENT.caption) : null], fields.TYPE_OF_TREATMENT.isInvalid],
        ["ISSERVICE", [fields.ISSERVICE.visible && fields.ISSERVICE.required ? ew.Validators.required(fields.ISSERVICE.caption) : null], fields.ISSERVICE.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fTREATMENT_TYPEedit,
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
    fTREATMENT_TYPEedit.validate = function () {
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
    fTREATMENT_TYPEedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fTREATMENT_TYPEedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fTREATMENT_TYPEedit");
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
<form name="fTREATMENT_TYPEedit" id="fTREATMENT_TYPEedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="TREATMENT_TYPE">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->TREAT_TYPE->Visible) { // TREAT_TYPE ?>
    <div id="r_TREAT_TYPE" class="form-group row">
        <label id="elh_TREATMENT_TYPE_TREAT_TYPE" for="x_TREAT_TYPE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->TREAT_TYPE->caption() ?><?= $Page->TREAT_TYPE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->TREAT_TYPE->cellAttributes() ?>>
<input type="<?= $Page->TREAT_TYPE->getInputTextType() ?>" data-table="TREATMENT_TYPE" data-field="x_TREAT_TYPE" name="x_TREAT_TYPE" id="x_TREAT_TYPE" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->TREAT_TYPE->getPlaceHolder()) ?>" value="<?= $Page->TREAT_TYPE->EditValue ?>"<?= $Page->TREAT_TYPE->editAttributes() ?> aria-describedby="x_TREAT_TYPE_help">
<?= $Page->TREAT_TYPE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->TREAT_TYPE->getErrorMessage() ?></div>
<input type="hidden" data-table="TREATMENT_TYPE" data-field="x_TREAT_TYPE" data-hidden="1" name="o_TREAT_TYPE" id="o_TREAT_TYPE" value="<?= HtmlEncode($Page->TREAT_TYPE->OldValue ?? $Page->TREAT_TYPE->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->OBJECT_CATEGORY_ID->Visible) { // OBJECT_CATEGORY_ID ?>
    <div id="r_OBJECT_CATEGORY_ID" class="form-group row">
        <label id="elh_TREATMENT_TYPE_OBJECT_CATEGORY_ID" for="x_OBJECT_CATEGORY_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->OBJECT_CATEGORY_ID->caption() ?><?= $Page->OBJECT_CATEGORY_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->OBJECT_CATEGORY_ID->cellAttributes() ?>>
<span id="el_TREATMENT_TYPE_OBJECT_CATEGORY_ID">
<input type="<?= $Page->OBJECT_CATEGORY_ID->getInputTextType() ?>" data-table="TREATMENT_TYPE" data-field="x_OBJECT_CATEGORY_ID" name="x_OBJECT_CATEGORY_ID" id="x_OBJECT_CATEGORY_ID" size="30" placeholder="<?= HtmlEncode($Page->OBJECT_CATEGORY_ID->getPlaceHolder()) ?>" value="<?= $Page->OBJECT_CATEGORY_ID->EditValue ?>"<?= $Page->OBJECT_CATEGORY_ID->editAttributes() ?> aria-describedby="x_OBJECT_CATEGORY_ID_help">
<?= $Page->OBJECT_CATEGORY_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->OBJECT_CATEGORY_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->TYPE_OF_TREATMENT->Visible) { // TYPE_OF_TREATMENT ?>
    <div id="r_TYPE_OF_TREATMENT" class="form-group row">
        <label id="elh_TREATMENT_TYPE_TYPE_OF_TREATMENT" for="x_TYPE_OF_TREATMENT" class="<?= $Page->LeftColumnClass ?>"><?= $Page->TYPE_OF_TREATMENT->caption() ?><?= $Page->TYPE_OF_TREATMENT->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->TYPE_OF_TREATMENT->cellAttributes() ?>>
<span id="el_TREATMENT_TYPE_TYPE_OF_TREATMENT">
<input type="<?= $Page->TYPE_OF_TREATMENT->getInputTextType() ?>" data-table="TREATMENT_TYPE" data-field="x_TYPE_OF_TREATMENT" name="x_TYPE_OF_TREATMENT" id="x_TYPE_OF_TREATMENT" size="30" maxlength="200" placeholder="<?= HtmlEncode($Page->TYPE_OF_TREATMENT->getPlaceHolder()) ?>" value="<?= $Page->TYPE_OF_TREATMENT->EditValue ?>"<?= $Page->TYPE_OF_TREATMENT->editAttributes() ?> aria-describedby="x_TYPE_OF_TREATMENT_help">
<?= $Page->TYPE_OF_TREATMENT->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->TYPE_OF_TREATMENT->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ISSERVICE->Visible) { // ISSERVICE ?>
    <div id="r_ISSERVICE" class="form-group row">
        <label id="elh_TREATMENT_TYPE_ISSERVICE" for="x_ISSERVICE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ISSERVICE->caption() ?><?= $Page->ISSERVICE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ISSERVICE->cellAttributes() ?>>
<span id="el_TREATMENT_TYPE_ISSERVICE">
<input type="<?= $Page->ISSERVICE->getInputTextType() ?>" data-table="TREATMENT_TYPE" data-field="x_ISSERVICE" name="x_ISSERVICE" id="x_ISSERVICE" size="30" maxlength="1" placeholder="<?= HtmlEncode($Page->ISSERVICE->getPlaceHolder()) ?>" value="<?= $Page->ISSERVICE->EditValue ?>"<?= $Page->ISSERVICE->editAttributes() ?> aria-describedby="x_ISSERVICE_help">
<?= $Page->ISSERVICE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ISSERVICE->getErrorMessage() ?></div>
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
    ew.addEventHandlers("TREATMENT_TYPE");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
