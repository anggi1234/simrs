<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

// Page object
$VisitInapEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fVISIT_INAPedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fVISIT_INAPedit = currentForm = new ew.Form("fVISIT_INAPedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "VISIT_INAP")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.VISIT_INAP)
        ew.vars.tables.VISIT_INAP = currentTable;
    fVISIT_INAPedit.addFields([
        ["VISIT_INAP_ID", [fields.VISIT_INAP_ID.visible && fields.VISIT_INAP_ID.required ? ew.Validators.required(fields.VISIT_INAP_ID.caption) : null, ew.Validators.integer], fields.VISIT_INAP_ID.isInvalid],
        ["VISIT_INAP", [fields.VISIT_INAP.visible && fields.VISIT_INAP.required ? ew.Validators.required(fields.VISIT_INAP.caption) : null], fields.VISIT_INAP.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fVISIT_INAPedit,
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
    fVISIT_INAPedit.validate = function () {
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
    fVISIT_INAPedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fVISIT_INAPedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fVISIT_INAPedit");
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
<form name="fVISIT_INAPedit" id="fVISIT_INAPedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="VISIT_INAP">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->VISIT_INAP_ID->Visible) { // VISIT_INAP_ID ?>
    <div id="r_VISIT_INAP_ID" class="form-group row">
        <label id="elh_VISIT_INAP_VISIT_INAP_ID" for="x_VISIT_INAP_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->VISIT_INAP_ID->caption() ?><?= $Page->VISIT_INAP_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->VISIT_INAP_ID->cellAttributes() ?>>
<input type="<?= $Page->VISIT_INAP_ID->getInputTextType() ?>" data-table="VISIT_INAP" data-field="x_VISIT_INAP_ID" name="x_VISIT_INAP_ID" id="x_VISIT_INAP_ID" size="30" placeholder="<?= HtmlEncode($Page->VISIT_INAP_ID->getPlaceHolder()) ?>" value="<?= $Page->VISIT_INAP_ID->EditValue ?>"<?= $Page->VISIT_INAP_ID->editAttributes() ?> aria-describedby="x_VISIT_INAP_ID_help">
<?= $Page->VISIT_INAP_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->VISIT_INAP_ID->getErrorMessage() ?></div>
<input type="hidden" data-table="VISIT_INAP" data-field="x_VISIT_INAP_ID" data-hidden="1" name="o_VISIT_INAP_ID" id="o_VISIT_INAP_ID" value="<?= HtmlEncode($Page->VISIT_INAP_ID->OldValue ?? $Page->VISIT_INAP_ID->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->VISIT_INAP->Visible) { // VISIT_INAP ?>
    <div id="r_VISIT_INAP" class="form-group row">
        <label id="elh_VISIT_INAP_VISIT_INAP" for="x_VISIT_INAP" class="<?= $Page->LeftColumnClass ?>"><?= $Page->VISIT_INAP->caption() ?><?= $Page->VISIT_INAP->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->VISIT_INAP->cellAttributes() ?>>
<span id="el_VISIT_INAP_VISIT_INAP">
<input type="<?= $Page->VISIT_INAP->getInputTextType() ?>" data-table="VISIT_INAP" data-field="x_VISIT_INAP" name="x_VISIT_INAP" id="x_VISIT_INAP" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->VISIT_INAP->getPlaceHolder()) ?>" value="<?= $Page->VISIT_INAP->EditValue ?>"<?= $Page->VISIT_INAP->editAttributes() ?> aria-describedby="x_VISIT_INAP_help">
<?= $Page->VISIT_INAP->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->VISIT_INAP->getErrorMessage() ?></div>
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
    ew.addEventHandlers("VISIT_INAP");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
