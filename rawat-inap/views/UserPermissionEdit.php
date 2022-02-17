<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

// Page object
$UserPermissionEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fUSER_PERMISSIONedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fUSER_PERMISSIONedit = currentForm = new ew.Form("fUSER_PERMISSIONedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "USER_PERMISSION")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.USER_PERMISSION)
        ew.vars.tables.USER_PERMISSION = currentTable;
    fUSER_PERMISSIONedit.addFields([
        ["PERMISSION_ID", [fields.PERMISSION_ID.visible && fields.PERMISSION_ID.required ? ew.Validators.required(fields.PERMISSION_ID.caption) : null, ew.Validators.integer], fields.PERMISSION_ID.isInvalid],
        ["_PERMISSIONS", [fields._PERMISSIONS.visible && fields._PERMISSIONS.required ? ew.Validators.required(fields._PERMISSIONS.caption) : null], fields._PERMISSIONS.isInvalid],
        ["MODIFIED_DATE", [fields.MODIFIED_DATE.visible && fields.MODIFIED_DATE.required ? ew.Validators.required(fields.MODIFIED_DATE.caption) : null, ew.Validators.datetime(0)], fields.MODIFIED_DATE.isInvalid],
        ["MODIFIED_BY", [fields.MODIFIED_BY.visible && fields.MODIFIED_BY.required ? ew.Validators.required(fields.MODIFIED_BY.caption) : null], fields.MODIFIED_BY.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fUSER_PERMISSIONedit,
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
    fUSER_PERMISSIONedit.validate = function () {
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
    fUSER_PERMISSIONedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fUSER_PERMISSIONedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fUSER_PERMISSIONedit");
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
<form name="fUSER_PERMISSIONedit" id="fUSER_PERMISSIONedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="USER_PERMISSION">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->PERMISSION_ID->Visible) { // PERMISSION_ID ?>
    <div id="r_PERMISSION_ID" class="form-group row">
        <label id="elh_USER_PERMISSION_PERMISSION_ID" for="x_PERMISSION_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->PERMISSION_ID->caption() ?><?= $Page->PERMISSION_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PERMISSION_ID->cellAttributes() ?>>
<input type="<?= $Page->PERMISSION_ID->getInputTextType() ?>" data-table="USER_PERMISSION" data-field="x_PERMISSION_ID" name="x_PERMISSION_ID" id="x_PERMISSION_ID" size="30" placeholder="<?= HtmlEncode($Page->PERMISSION_ID->getPlaceHolder()) ?>" value="<?= $Page->PERMISSION_ID->EditValue ?>"<?= $Page->PERMISSION_ID->editAttributes() ?> aria-describedby="x_PERMISSION_ID_help">
<?= $Page->PERMISSION_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->PERMISSION_ID->getErrorMessage() ?></div>
<input type="hidden" data-table="USER_PERMISSION" data-field="x_PERMISSION_ID" data-hidden="1" name="o_PERMISSION_ID" id="o_PERMISSION_ID" value="<?= HtmlEncode($Page->PERMISSION_ID->OldValue ?? $Page->PERMISSION_ID->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_PERMISSIONS->Visible) { // PERMISSIONS ?>
    <div id="r__PERMISSIONS" class="form-group row">
        <label id="elh_USER_PERMISSION__PERMISSIONS" for="x__PERMISSIONS" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_PERMISSIONS->caption() ?><?= $Page->_PERMISSIONS->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->_PERMISSIONS->cellAttributes() ?>>
<span id="el_USER_PERMISSION__PERMISSIONS">
<input type="<?= $Page->_PERMISSIONS->getInputTextType() ?>" data-table="USER_PERMISSION" data-field="x__PERMISSIONS" name="x__PERMISSIONS" id="x__PERMISSIONS" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->_PERMISSIONS->getPlaceHolder()) ?>" value="<?= $Page->_PERMISSIONS->EditValue ?>"<?= $Page->_PERMISSIONS->editAttributes() ?> aria-describedby="x__PERMISSIONS_help">
<?= $Page->_PERMISSIONS->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_PERMISSIONS->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
    <div id="r_MODIFIED_DATE" class="form-group row">
        <label id="elh_USER_PERMISSION_MODIFIED_DATE" for="x_MODIFIED_DATE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->MODIFIED_DATE->caption() ?><?= $Page->MODIFIED_DATE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->MODIFIED_DATE->cellAttributes() ?>>
<span id="el_USER_PERMISSION_MODIFIED_DATE">
<input type="<?= $Page->MODIFIED_DATE->getInputTextType() ?>" data-table="USER_PERMISSION" data-field="x_MODIFIED_DATE" name="x_MODIFIED_DATE" id="x_MODIFIED_DATE" placeholder="<?= HtmlEncode($Page->MODIFIED_DATE->getPlaceHolder()) ?>" value="<?= $Page->MODIFIED_DATE->EditValue ?>"<?= $Page->MODIFIED_DATE->editAttributes() ?> aria-describedby="x_MODIFIED_DATE_help">
<?= $Page->MODIFIED_DATE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->MODIFIED_DATE->getErrorMessage() ?></div>
<?php if (!$Page->MODIFIED_DATE->ReadOnly && !$Page->MODIFIED_DATE->Disabled && !isset($Page->MODIFIED_DATE->EditAttrs["readonly"]) && !isset($Page->MODIFIED_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fUSER_PERMISSIONedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fUSER_PERMISSIONedit", "x_MODIFIED_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
    <div id="r_MODIFIED_BY" class="form-group row">
        <label id="elh_USER_PERMISSION_MODIFIED_BY" for="x_MODIFIED_BY" class="<?= $Page->LeftColumnClass ?>"><?= $Page->MODIFIED_BY->caption() ?><?= $Page->MODIFIED_BY->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->MODIFIED_BY->cellAttributes() ?>>
<span id="el_USER_PERMISSION_MODIFIED_BY">
<input type="<?= $Page->MODIFIED_BY->getInputTextType() ?>" data-table="USER_PERMISSION" data-field="x_MODIFIED_BY" name="x_MODIFIED_BY" id="x_MODIFIED_BY" size="30" maxlength="25" placeholder="<?= HtmlEncode($Page->MODIFIED_BY->getPlaceHolder()) ?>" value="<?= $Page->MODIFIED_BY->EditValue ?>"<?= $Page->MODIFIED_BY->editAttributes() ?> aria-describedby="x_MODIFIED_BY_help">
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
    ew.addEventHandlers("USER_PERMISSION");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
