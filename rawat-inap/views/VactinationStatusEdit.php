<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

// Page object
$VactinationStatusEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fVACTINATION_STATUSedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fVACTINATION_STATUSedit = currentForm = new ew.Form("fVACTINATION_STATUSedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "VACTINATION_STATUS")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.VACTINATION_STATUS)
        ew.vars.tables.VACTINATION_STATUS = currentTable;
    fVACTINATION_STATUSedit.addFields([
        ["VACTINATION_STATUS", [fields.VACTINATION_STATUS.visible && fields.VACTINATION_STATUS.required ? ew.Validators.required(fields.VACTINATION_STATUS.caption) : null], fields.VACTINATION_STATUS.isInvalid],
        ["DESCRIPTION", [fields.DESCRIPTION.visible && fields.DESCRIPTION.required ? ew.Validators.required(fields.DESCRIPTION.caption) : null], fields.DESCRIPTION.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fVACTINATION_STATUSedit,
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
    fVACTINATION_STATUSedit.validate = function () {
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
    fVACTINATION_STATUSedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fVACTINATION_STATUSedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fVACTINATION_STATUSedit");
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
<form name="fVACTINATION_STATUSedit" id="fVACTINATION_STATUSedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="VACTINATION_STATUS">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->VACTINATION_STATUS->Visible) { // VACTINATION_STATUS ?>
    <div id="r_VACTINATION_STATUS" class="form-group row">
        <label id="elh_VACTINATION_STATUS_VACTINATION_STATUS" for="x_VACTINATION_STATUS" class="<?= $Page->LeftColumnClass ?>"><?= $Page->VACTINATION_STATUS->caption() ?><?= $Page->VACTINATION_STATUS->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->VACTINATION_STATUS->cellAttributes() ?>>
<input type="<?= $Page->VACTINATION_STATUS->getInputTextType() ?>" data-table="VACTINATION_STATUS" data-field="x_VACTINATION_STATUS" name="x_VACTINATION_STATUS" id="x_VACTINATION_STATUS" size="30" maxlength="2" placeholder="<?= HtmlEncode($Page->VACTINATION_STATUS->getPlaceHolder()) ?>" value="<?= $Page->VACTINATION_STATUS->EditValue ?>"<?= $Page->VACTINATION_STATUS->editAttributes() ?> aria-describedby="x_VACTINATION_STATUS_help">
<?= $Page->VACTINATION_STATUS->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->VACTINATION_STATUS->getErrorMessage() ?></div>
<input type="hidden" data-table="VACTINATION_STATUS" data-field="x_VACTINATION_STATUS" data-hidden="1" name="o_VACTINATION_STATUS" id="o_VACTINATION_STATUS" value="<?= HtmlEncode($Page->VACTINATION_STATUS->OldValue ?? $Page->VACTINATION_STATUS->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->DESCRIPTION->Visible) { // DESCRIPTION ?>
    <div id="r_DESCRIPTION" class="form-group row">
        <label id="elh_VACTINATION_STATUS_DESCRIPTION" for="x_DESCRIPTION" class="<?= $Page->LeftColumnClass ?>"><?= $Page->DESCRIPTION->caption() ?><?= $Page->DESCRIPTION->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->DESCRIPTION->cellAttributes() ?>>
<span id="el_VACTINATION_STATUS_DESCRIPTION">
<input type="<?= $Page->DESCRIPTION->getInputTextType() ?>" data-table="VACTINATION_STATUS" data-field="x_DESCRIPTION" name="x_DESCRIPTION" id="x_DESCRIPTION" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->DESCRIPTION->getPlaceHolder()) ?>" value="<?= $Page->DESCRIPTION->EditValue ?>"<?= $Page->DESCRIPTION->editAttributes() ?> aria-describedby="x_DESCRIPTION_help">
<?= $Page->DESCRIPTION->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->DESCRIPTION->getErrorMessage() ?></div>
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
    ew.addEventHandlers("VACTINATION_STATUS");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
