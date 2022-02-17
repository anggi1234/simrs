<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

// Page object
$UserMenuEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fUSER_MENUedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fUSER_MENUedit = currentForm = new ew.Form("fUSER_MENUedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "USER_MENU")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.USER_MENU)
        ew.vars.tables.USER_MENU = currentTable;
    fUSER_MENUedit.addFields([
        ["ORG_UNIT_CODE", [fields.ORG_UNIT_CODE.visible && fields.ORG_UNIT_CODE.required ? ew.Validators.required(fields.ORG_UNIT_CODE.caption) : null], fields.ORG_UNIT_CODE.isInvalid],
        ["GROUP_ID", [fields.GROUP_ID.visible && fields.GROUP_ID.required ? ew.Validators.required(fields.GROUP_ID.caption) : null, ew.Validators.integer], fields.GROUP_ID.isInvalid],
        ["MENU_ID", [fields.MENU_ID.visible && fields.MENU_ID.required ? ew.Validators.required(fields.MENU_ID.caption) : null], fields.MENU_ID.isInvalid],
        ["STYPE_ID", [fields.STYPE_ID.visible && fields.STYPE_ID.required ? ew.Validators.required(fields.STYPE_ID.caption) : null, ew.Validators.integer], fields.STYPE_ID.isInvalid],
        ["C", [fields.C.visible && fields.C.required ? ew.Validators.required(fields.C.caption) : null], fields.C.isInvalid],
        ["R", [fields.R.visible && fields.R.required ? ew.Validators.required(fields.R.caption) : null], fields.R.isInvalid],
        ["U", [fields.U.visible && fields.U.required ? ew.Validators.required(fields.U.caption) : null], fields.U.isInvalid],
        ["D", [fields.D.visible && fields.D.required ? ew.Validators.required(fields.D.caption) : null], fields.D.isInvalid],
        ["MODIFIED_DATE", [fields.MODIFIED_DATE.visible && fields.MODIFIED_DATE.required ? ew.Validators.required(fields.MODIFIED_DATE.caption) : null, ew.Validators.datetime(0)], fields.MODIFIED_DATE.isInvalid],
        ["MODIFIED_BY", [fields.MODIFIED_BY.visible && fields.MODIFIED_BY.required ? ew.Validators.required(fields.MODIFIED_BY.caption) : null], fields.MODIFIED_BY.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fUSER_MENUedit,
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
    fUSER_MENUedit.validate = function () {
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
    fUSER_MENUedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fUSER_MENUedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fUSER_MENUedit");
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
<form name="fUSER_MENUedit" id="fUSER_MENUedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="USER_MENU">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->ORG_UNIT_CODE->Visible) { // ORG_UNIT_CODE ?>
    <div id="r_ORG_UNIT_CODE" class="form-group row">
        <label id="elh_USER_MENU_ORG_UNIT_CODE" for="x_ORG_UNIT_CODE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ORG_UNIT_CODE->caption() ?><?= $Page->ORG_UNIT_CODE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ORG_UNIT_CODE->cellAttributes() ?>>
<input type="<?= $Page->ORG_UNIT_CODE->getInputTextType() ?>" data-table="USER_MENU" data-field="x_ORG_UNIT_CODE" name="x_ORG_UNIT_CODE" id="x_ORG_UNIT_CODE" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->ORG_UNIT_CODE->getPlaceHolder()) ?>" value="<?= $Page->ORG_UNIT_CODE->EditValue ?>"<?= $Page->ORG_UNIT_CODE->editAttributes() ?> aria-describedby="x_ORG_UNIT_CODE_help">
<?= $Page->ORG_UNIT_CODE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ORG_UNIT_CODE->getErrorMessage() ?></div>
<input type="hidden" data-table="USER_MENU" data-field="x_ORG_UNIT_CODE" data-hidden="1" name="o_ORG_UNIT_CODE" id="o_ORG_UNIT_CODE" value="<?= HtmlEncode($Page->ORG_UNIT_CODE->OldValue ?? $Page->ORG_UNIT_CODE->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->GROUP_ID->Visible) { // GROUP_ID ?>
    <div id="r_GROUP_ID" class="form-group row">
        <label id="elh_USER_MENU_GROUP_ID" for="x_GROUP_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->GROUP_ID->caption() ?><?= $Page->GROUP_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->GROUP_ID->cellAttributes() ?>>
<input type="<?= $Page->GROUP_ID->getInputTextType() ?>" data-table="USER_MENU" data-field="x_GROUP_ID" name="x_GROUP_ID" id="x_GROUP_ID" size="30" placeholder="<?= HtmlEncode($Page->GROUP_ID->getPlaceHolder()) ?>" value="<?= $Page->GROUP_ID->EditValue ?>"<?= $Page->GROUP_ID->editAttributes() ?> aria-describedby="x_GROUP_ID_help">
<?= $Page->GROUP_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->GROUP_ID->getErrorMessage() ?></div>
<input type="hidden" data-table="USER_MENU" data-field="x_GROUP_ID" data-hidden="1" name="o_GROUP_ID" id="o_GROUP_ID" value="<?= HtmlEncode($Page->GROUP_ID->OldValue ?? $Page->GROUP_ID->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->MENU_ID->Visible) { // MENU_ID ?>
    <div id="r_MENU_ID" class="form-group row">
        <label id="elh_USER_MENU_MENU_ID" for="x_MENU_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->MENU_ID->caption() ?><?= $Page->MENU_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->MENU_ID->cellAttributes() ?>>
<input type="<?= $Page->MENU_ID->getInputTextType() ?>" data-table="USER_MENU" data-field="x_MENU_ID" name="x_MENU_ID" id="x_MENU_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->MENU_ID->getPlaceHolder()) ?>" value="<?= $Page->MENU_ID->EditValue ?>"<?= $Page->MENU_ID->editAttributes() ?> aria-describedby="x_MENU_ID_help">
<?= $Page->MENU_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->MENU_ID->getErrorMessage() ?></div>
<input type="hidden" data-table="USER_MENU" data-field="x_MENU_ID" data-hidden="1" name="o_MENU_ID" id="o_MENU_ID" value="<?= HtmlEncode($Page->MENU_ID->OldValue ?? $Page->MENU_ID->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->STYPE_ID->Visible) { // STYPE_ID ?>
    <div id="r_STYPE_ID" class="form-group row">
        <label id="elh_USER_MENU_STYPE_ID" for="x_STYPE_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->STYPE_ID->caption() ?><?= $Page->STYPE_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->STYPE_ID->cellAttributes() ?>>
<input type="<?= $Page->STYPE_ID->getInputTextType() ?>" data-table="USER_MENU" data-field="x_STYPE_ID" name="x_STYPE_ID" id="x_STYPE_ID" size="30" placeholder="<?= HtmlEncode($Page->STYPE_ID->getPlaceHolder()) ?>" value="<?= $Page->STYPE_ID->EditValue ?>"<?= $Page->STYPE_ID->editAttributes() ?> aria-describedby="x_STYPE_ID_help">
<?= $Page->STYPE_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->STYPE_ID->getErrorMessage() ?></div>
<input type="hidden" data-table="USER_MENU" data-field="x_STYPE_ID" data-hidden="1" name="o_STYPE_ID" id="o_STYPE_ID" value="<?= HtmlEncode($Page->STYPE_ID->OldValue ?? $Page->STYPE_ID->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->C->Visible) { // C ?>
    <div id="r_C" class="form-group row">
        <label id="elh_USER_MENU_C" for="x_C" class="<?= $Page->LeftColumnClass ?>"><?= $Page->C->caption() ?><?= $Page->C->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->C->cellAttributes() ?>>
<span id="el_USER_MENU_C">
<input type="<?= $Page->C->getInputTextType() ?>" data-table="USER_MENU" data-field="x_C" name="x_C" id="x_C" size="30" maxlength="1" placeholder="<?= HtmlEncode($Page->C->getPlaceHolder()) ?>" value="<?= $Page->C->EditValue ?>"<?= $Page->C->editAttributes() ?> aria-describedby="x_C_help">
<?= $Page->C->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->C->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->R->Visible) { // R ?>
    <div id="r_R" class="form-group row">
        <label id="elh_USER_MENU_R" for="x_R" class="<?= $Page->LeftColumnClass ?>"><?= $Page->R->caption() ?><?= $Page->R->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->R->cellAttributes() ?>>
<span id="el_USER_MENU_R">
<input type="<?= $Page->R->getInputTextType() ?>" data-table="USER_MENU" data-field="x_R" name="x_R" id="x_R" size="30" maxlength="1" placeholder="<?= HtmlEncode($Page->R->getPlaceHolder()) ?>" value="<?= $Page->R->EditValue ?>"<?= $Page->R->editAttributes() ?> aria-describedby="x_R_help">
<?= $Page->R->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->R->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->U->Visible) { // U ?>
    <div id="r_U" class="form-group row">
        <label id="elh_USER_MENU_U" for="x_U" class="<?= $Page->LeftColumnClass ?>"><?= $Page->U->caption() ?><?= $Page->U->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->U->cellAttributes() ?>>
<span id="el_USER_MENU_U">
<input type="<?= $Page->U->getInputTextType() ?>" data-table="USER_MENU" data-field="x_U" name="x_U" id="x_U" size="30" maxlength="1" placeholder="<?= HtmlEncode($Page->U->getPlaceHolder()) ?>" value="<?= $Page->U->EditValue ?>"<?= $Page->U->editAttributes() ?> aria-describedby="x_U_help">
<?= $Page->U->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->U->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->D->Visible) { // D ?>
    <div id="r_D" class="form-group row">
        <label id="elh_USER_MENU_D" for="x_D" class="<?= $Page->LeftColumnClass ?>"><?= $Page->D->caption() ?><?= $Page->D->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->D->cellAttributes() ?>>
<span id="el_USER_MENU_D">
<input type="<?= $Page->D->getInputTextType() ?>" data-table="USER_MENU" data-field="x_D" name="x_D" id="x_D" size="30" maxlength="1" placeholder="<?= HtmlEncode($Page->D->getPlaceHolder()) ?>" value="<?= $Page->D->EditValue ?>"<?= $Page->D->editAttributes() ?> aria-describedby="x_D_help">
<?= $Page->D->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->D->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
    <div id="r_MODIFIED_DATE" class="form-group row">
        <label id="elh_USER_MENU_MODIFIED_DATE" for="x_MODIFIED_DATE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->MODIFIED_DATE->caption() ?><?= $Page->MODIFIED_DATE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->MODIFIED_DATE->cellAttributes() ?>>
<span id="el_USER_MENU_MODIFIED_DATE">
<input type="<?= $Page->MODIFIED_DATE->getInputTextType() ?>" data-table="USER_MENU" data-field="x_MODIFIED_DATE" name="x_MODIFIED_DATE" id="x_MODIFIED_DATE" placeholder="<?= HtmlEncode($Page->MODIFIED_DATE->getPlaceHolder()) ?>" value="<?= $Page->MODIFIED_DATE->EditValue ?>"<?= $Page->MODIFIED_DATE->editAttributes() ?> aria-describedby="x_MODIFIED_DATE_help">
<?= $Page->MODIFIED_DATE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->MODIFIED_DATE->getErrorMessage() ?></div>
<?php if (!$Page->MODIFIED_DATE->ReadOnly && !$Page->MODIFIED_DATE->Disabled && !isset($Page->MODIFIED_DATE->EditAttrs["readonly"]) && !isset($Page->MODIFIED_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fUSER_MENUedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fUSER_MENUedit", "x_MODIFIED_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
    <div id="r_MODIFIED_BY" class="form-group row">
        <label id="elh_USER_MENU_MODIFIED_BY" for="x_MODIFIED_BY" class="<?= $Page->LeftColumnClass ?>"><?= $Page->MODIFIED_BY->caption() ?><?= $Page->MODIFIED_BY->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->MODIFIED_BY->cellAttributes() ?>>
<span id="el_USER_MENU_MODIFIED_BY">
<input type="<?= $Page->MODIFIED_BY->getInputTextType() ?>" data-table="USER_MENU" data-field="x_MODIFIED_BY" name="x_MODIFIED_BY" id="x_MODIFIED_BY" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->MODIFIED_BY->getPlaceHolder()) ?>" value="<?= $Page->MODIFIED_BY->EditValue ?>"<?= $Page->MODIFIED_BY->editAttributes() ?> aria-describedby="x_MODIFIED_BY_help">
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
    ew.addEventHandlers("USER_MENU");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
