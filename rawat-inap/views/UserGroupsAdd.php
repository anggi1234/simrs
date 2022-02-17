<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

// Page object
$UserGroupsAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fUSER_GROUPSadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fUSER_GROUPSadd = currentForm = new ew.Form("fUSER_GROUPSadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "USER_GROUPS")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.USER_GROUPS)
        ew.vars.tables.USER_GROUPS = currentTable;
    fUSER_GROUPSadd.addFields([
        ["ORG_UNIT_CODE", [fields.ORG_UNIT_CODE.visible && fields.ORG_UNIT_CODE.required ? ew.Validators.required(fields.ORG_UNIT_CODE.caption) : null], fields.ORG_UNIT_CODE.isInvalid],
        ["GROUP_ID", [fields.GROUP_ID.visible && fields.GROUP_ID.required ? ew.Validators.required(fields.GROUP_ID.caption) : null, ew.Validators.integer], fields.GROUP_ID.isInvalid],
        ["GROUP_NAME", [fields.GROUP_NAME.visible && fields.GROUP_NAME.required ? ew.Validators.required(fields.GROUP_NAME.caption) : null], fields.GROUP_NAME.isInvalid],
        ["ISUSED", [fields.ISUSED.visible && fields.ISUSED.required ? ew.Validators.required(fields.ISUSED.caption) : null], fields.ISUSED.isInvalid],
        ["STYPE_ID", [fields.STYPE_ID.visible && fields.STYPE_ID.required ? ew.Validators.required(fields.STYPE_ID.caption) : null, ew.Validators.integer], fields.STYPE_ID.isInvalid],
        ["MODIFIED_DATE", [fields.MODIFIED_DATE.visible && fields.MODIFIED_DATE.required ? ew.Validators.required(fields.MODIFIED_DATE.caption) : null, ew.Validators.datetime(0)], fields.MODIFIED_DATE.isInvalid],
        ["MODIFIED_BY", [fields.MODIFIED_BY.visible && fields.MODIFIED_BY.required ? ew.Validators.required(fields.MODIFIED_BY.caption) : null], fields.MODIFIED_BY.isInvalid],
        ["THEID", [fields.THEID.visible && fields.THEID.required ? ew.Validators.required(fields.THEID.caption) : null], fields.THEID.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fUSER_GROUPSadd,
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
    fUSER_GROUPSadd.validate = function () {
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
    fUSER_GROUPSadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fUSER_GROUPSadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fUSER_GROUPSadd");
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
<form name="fUSER_GROUPSadd" id="fUSER_GROUPSadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="USER_GROUPS">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->ORG_UNIT_CODE->Visible) { // ORG_UNIT_CODE ?>
    <div id="r_ORG_UNIT_CODE" class="form-group row">
        <label id="elh_USER_GROUPS_ORG_UNIT_CODE" for="x_ORG_UNIT_CODE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ORG_UNIT_CODE->caption() ?><?= $Page->ORG_UNIT_CODE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ORG_UNIT_CODE->cellAttributes() ?>>
<span id="el_USER_GROUPS_ORG_UNIT_CODE">
<input type="<?= $Page->ORG_UNIT_CODE->getInputTextType() ?>" data-table="USER_GROUPS" data-field="x_ORG_UNIT_CODE" name="x_ORG_UNIT_CODE" id="x_ORG_UNIT_CODE" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->ORG_UNIT_CODE->getPlaceHolder()) ?>" value="<?= $Page->ORG_UNIT_CODE->EditValue ?>"<?= $Page->ORG_UNIT_CODE->editAttributes() ?> aria-describedby="x_ORG_UNIT_CODE_help">
<?= $Page->ORG_UNIT_CODE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ORG_UNIT_CODE->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->GROUP_ID->Visible) { // GROUP_ID ?>
    <div id="r_GROUP_ID" class="form-group row">
        <label id="elh_USER_GROUPS_GROUP_ID" for="x_GROUP_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->GROUP_ID->caption() ?><?= $Page->GROUP_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->GROUP_ID->cellAttributes() ?>>
<span id="el_USER_GROUPS_GROUP_ID">
<input type="<?= $Page->GROUP_ID->getInputTextType() ?>" data-table="USER_GROUPS" data-field="x_GROUP_ID" name="x_GROUP_ID" id="x_GROUP_ID" size="30" placeholder="<?= HtmlEncode($Page->GROUP_ID->getPlaceHolder()) ?>" value="<?= $Page->GROUP_ID->EditValue ?>"<?= $Page->GROUP_ID->editAttributes() ?> aria-describedby="x_GROUP_ID_help">
<?= $Page->GROUP_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->GROUP_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->GROUP_NAME->Visible) { // GROUP_NAME ?>
    <div id="r_GROUP_NAME" class="form-group row">
        <label id="elh_USER_GROUPS_GROUP_NAME" for="x_GROUP_NAME" class="<?= $Page->LeftColumnClass ?>"><?= $Page->GROUP_NAME->caption() ?><?= $Page->GROUP_NAME->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->GROUP_NAME->cellAttributes() ?>>
<span id="el_USER_GROUPS_GROUP_NAME">
<input type="<?= $Page->GROUP_NAME->getInputTextType() ?>" data-table="USER_GROUPS" data-field="x_GROUP_NAME" name="x_GROUP_NAME" id="x_GROUP_NAME" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->GROUP_NAME->getPlaceHolder()) ?>" value="<?= $Page->GROUP_NAME->EditValue ?>"<?= $Page->GROUP_NAME->editAttributes() ?> aria-describedby="x_GROUP_NAME_help">
<?= $Page->GROUP_NAME->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->GROUP_NAME->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ISUSED->Visible) { // ISUSED ?>
    <div id="r_ISUSED" class="form-group row">
        <label id="elh_USER_GROUPS_ISUSED" for="x_ISUSED" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ISUSED->caption() ?><?= $Page->ISUSED->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ISUSED->cellAttributes() ?>>
<span id="el_USER_GROUPS_ISUSED">
<input type="<?= $Page->ISUSED->getInputTextType() ?>" data-table="USER_GROUPS" data-field="x_ISUSED" name="x_ISUSED" id="x_ISUSED" size="30" maxlength="1" placeholder="<?= HtmlEncode($Page->ISUSED->getPlaceHolder()) ?>" value="<?= $Page->ISUSED->EditValue ?>"<?= $Page->ISUSED->editAttributes() ?> aria-describedby="x_ISUSED_help">
<?= $Page->ISUSED->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ISUSED->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->STYPE_ID->Visible) { // STYPE_ID ?>
    <div id="r_STYPE_ID" class="form-group row">
        <label id="elh_USER_GROUPS_STYPE_ID" for="x_STYPE_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->STYPE_ID->caption() ?><?= $Page->STYPE_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->STYPE_ID->cellAttributes() ?>>
<span id="el_USER_GROUPS_STYPE_ID">
<input type="<?= $Page->STYPE_ID->getInputTextType() ?>" data-table="USER_GROUPS" data-field="x_STYPE_ID" name="x_STYPE_ID" id="x_STYPE_ID" size="30" placeholder="<?= HtmlEncode($Page->STYPE_ID->getPlaceHolder()) ?>" value="<?= $Page->STYPE_ID->EditValue ?>"<?= $Page->STYPE_ID->editAttributes() ?> aria-describedby="x_STYPE_ID_help">
<?= $Page->STYPE_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->STYPE_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
    <div id="r_MODIFIED_DATE" class="form-group row">
        <label id="elh_USER_GROUPS_MODIFIED_DATE" for="x_MODIFIED_DATE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->MODIFIED_DATE->caption() ?><?= $Page->MODIFIED_DATE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->MODIFIED_DATE->cellAttributes() ?>>
<span id="el_USER_GROUPS_MODIFIED_DATE">
<input type="<?= $Page->MODIFIED_DATE->getInputTextType() ?>" data-table="USER_GROUPS" data-field="x_MODIFIED_DATE" name="x_MODIFIED_DATE" id="x_MODIFIED_DATE" placeholder="<?= HtmlEncode($Page->MODIFIED_DATE->getPlaceHolder()) ?>" value="<?= $Page->MODIFIED_DATE->EditValue ?>"<?= $Page->MODIFIED_DATE->editAttributes() ?> aria-describedby="x_MODIFIED_DATE_help">
<?= $Page->MODIFIED_DATE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->MODIFIED_DATE->getErrorMessage() ?></div>
<?php if (!$Page->MODIFIED_DATE->ReadOnly && !$Page->MODIFIED_DATE->Disabled && !isset($Page->MODIFIED_DATE->EditAttrs["readonly"]) && !isset($Page->MODIFIED_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fUSER_GROUPSadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fUSER_GROUPSadd", "x_MODIFIED_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
    <div id="r_MODIFIED_BY" class="form-group row">
        <label id="elh_USER_GROUPS_MODIFIED_BY" for="x_MODIFIED_BY" class="<?= $Page->LeftColumnClass ?>"><?= $Page->MODIFIED_BY->caption() ?><?= $Page->MODIFIED_BY->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->MODIFIED_BY->cellAttributes() ?>>
<span id="el_USER_GROUPS_MODIFIED_BY">
<input type="<?= $Page->MODIFIED_BY->getInputTextType() ?>" data-table="USER_GROUPS" data-field="x_MODIFIED_BY" name="x_MODIFIED_BY" id="x_MODIFIED_BY" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->MODIFIED_BY->getPlaceHolder()) ?>" value="<?= $Page->MODIFIED_BY->EditValue ?>"<?= $Page->MODIFIED_BY->editAttributes() ?> aria-describedby="x_MODIFIED_BY_help">
<?= $Page->MODIFIED_BY->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->MODIFIED_BY->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->THEID->Visible) { // THEID ?>
    <div id="r_THEID" class="form-group row">
        <label id="elh_USER_GROUPS_THEID" for="x_THEID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->THEID->caption() ?><?= $Page->THEID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->THEID->cellAttributes() ?>>
<span id="el_USER_GROUPS_THEID">
<input type="<?= $Page->THEID->getInputTextType() ?>" data-table="USER_GROUPS" data-field="x_THEID" name="x_THEID" id="x_THEID" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->THEID->getPlaceHolder()) ?>" value="<?= $Page->THEID->EditValue ?>"<?= $Page->THEID->editAttributes() ?> aria-describedby="x_THEID_help">
<?= $Page->THEID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->THEID->getErrorMessage() ?></div>
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
    ew.addEventHandlers("USER_GROUPS");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
