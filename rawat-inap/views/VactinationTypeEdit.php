<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

// Page object
$VactinationTypeEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fVACTINATION_TYPEedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fVACTINATION_TYPEedit = currentForm = new ew.Form("fVACTINATION_TYPEedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "VACTINATION_TYPE")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.VACTINATION_TYPE)
        ew.vars.tables.VACTINATION_TYPE = currentTable;
    fVACTINATION_TYPEedit.addFields([
        ["VACTINATION_TYPE", [fields.VACTINATION_TYPE.visible && fields.VACTINATION_TYPE.required ? ew.Validators.required(fields.VACTINATION_TYPE.caption) : null, ew.Validators.integer], fields.VACTINATION_TYPE.isInvalid],
        ["DIAGNOSA_ID", [fields.DIAGNOSA_ID.visible && fields.DIAGNOSA_ID.required ? ew.Validators.required(fields.DIAGNOSA_ID.caption) : null], fields.DIAGNOSA_ID.isInvalid],
        ["VACTINATIONTYPE", [fields.VACTINATIONTYPE.visible && fields.VACTINATIONTYPE.required ? ew.Validators.required(fields.VACTINATIONTYPE.caption) : null], fields.VACTINATIONTYPE.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fVACTINATION_TYPEedit,
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
    fVACTINATION_TYPEedit.validate = function () {
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
    fVACTINATION_TYPEedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fVACTINATION_TYPEedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fVACTINATION_TYPEedit");
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
<form name="fVACTINATION_TYPEedit" id="fVACTINATION_TYPEedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="VACTINATION_TYPE">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->VACTINATION_TYPE->Visible) { // VACTINATION_TYPE ?>
    <div id="r_VACTINATION_TYPE" class="form-group row">
        <label id="elh_VACTINATION_TYPE_VACTINATION_TYPE" for="x_VACTINATION_TYPE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->VACTINATION_TYPE->caption() ?><?= $Page->VACTINATION_TYPE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->VACTINATION_TYPE->cellAttributes() ?>>
<input type="<?= $Page->VACTINATION_TYPE->getInputTextType() ?>" data-table="VACTINATION_TYPE" data-field="x_VACTINATION_TYPE" name="x_VACTINATION_TYPE" id="x_VACTINATION_TYPE" size="30" placeholder="<?= HtmlEncode($Page->VACTINATION_TYPE->getPlaceHolder()) ?>" value="<?= $Page->VACTINATION_TYPE->EditValue ?>"<?= $Page->VACTINATION_TYPE->editAttributes() ?> aria-describedby="x_VACTINATION_TYPE_help">
<?= $Page->VACTINATION_TYPE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->VACTINATION_TYPE->getErrorMessage() ?></div>
<input type="hidden" data-table="VACTINATION_TYPE" data-field="x_VACTINATION_TYPE" data-hidden="1" name="o_VACTINATION_TYPE" id="o_VACTINATION_TYPE" value="<?= HtmlEncode($Page->VACTINATION_TYPE->OldValue ?? $Page->VACTINATION_TYPE->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->DIAGNOSA_ID->Visible) { // DIAGNOSA_ID ?>
    <div id="r_DIAGNOSA_ID" class="form-group row">
        <label id="elh_VACTINATION_TYPE_DIAGNOSA_ID" for="x_DIAGNOSA_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->DIAGNOSA_ID->caption() ?><?= $Page->DIAGNOSA_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->DIAGNOSA_ID->cellAttributes() ?>>
<span id="el_VACTINATION_TYPE_DIAGNOSA_ID">
<input type="<?= $Page->DIAGNOSA_ID->getInputTextType() ?>" data-table="VACTINATION_TYPE" data-field="x_DIAGNOSA_ID" name="x_DIAGNOSA_ID" id="x_DIAGNOSA_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->DIAGNOSA_ID->getPlaceHolder()) ?>" value="<?= $Page->DIAGNOSA_ID->EditValue ?>"<?= $Page->DIAGNOSA_ID->editAttributes() ?> aria-describedby="x_DIAGNOSA_ID_help">
<?= $Page->DIAGNOSA_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->DIAGNOSA_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->VACTINATIONTYPE->Visible) { // VACTINATIONTYPE ?>
    <div id="r_VACTINATIONTYPE" class="form-group row">
        <label id="elh_VACTINATION_TYPE_VACTINATIONTYPE" for="x_VACTINATIONTYPE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->VACTINATIONTYPE->caption() ?><?= $Page->VACTINATIONTYPE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->VACTINATIONTYPE->cellAttributes() ?>>
<span id="el_VACTINATION_TYPE_VACTINATIONTYPE">
<input type="<?= $Page->VACTINATIONTYPE->getInputTextType() ?>" data-table="VACTINATION_TYPE" data-field="x_VACTINATIONTYPE" name="x_VACTINATIONTYPE" id="x_VACTINATIONTYPE" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->VACTINATIONTYPE->getPlaceHolder()) ?>" value="<?= $Page->VACTINATIONTYPE->EditValue ?>"<?= $Page->VACTINATIONTYPE->editAttributes() ?> aria-describedby="x_VACTINATIONTYPE_help">
<?= $Page->VACTINATIONTYPE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->VACTINATIONTYPE->getErrorMessage() ?></div>
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
    ew.addEventHandlers("VACTINATION_TYPE");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
