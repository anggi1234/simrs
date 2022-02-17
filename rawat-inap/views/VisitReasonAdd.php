<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

// Page object
$VisitReasonAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fVISIT_REASONadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fVISIT_REASONadd = currentForm = new ew.Form("fVISIT_REASONadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "VISIT_REASON")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.VISIT_REASON)
        ew.vars.tables.VISIT_REASON = currentTable;
    fVISIT_REASONadd.addFields([
        ["REASON_ID", [fields.REASON_ID.visible && fields.REASON_ID.required ? ew.Validators.required(fields.REASON_ID.caption) : null, ew.Validators.integer], fields.REASON_ID.isInvalid],
        ["REASON", [fields.REASON.visible && fields.REASON.required ? ew.Validators.required(fields.REASON.caption) : null], fields.REASON.isInvalid],
        ["LAKALANTAS", [fields.LAKALANTAS.visible && fields.LAKALANTAS.required ? ew.Validators.required(fields.LAKALANTAS.caption) : null], fields.LAKALANTAS.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fVISIT_REASONadd,
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
    fVISIT_REASONadd.validate = function () {
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
    fVISIT_REASONadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fVISIT_REASONadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fVISIT_REASONadd");
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
<form name="fVISIT_REASONadd" id="fVISIT_REASONadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="VISIT_REASON">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->REASON_ID->Visible) { // REASON_ID ?>
    <div id="r_REASON_ID" class="form-group row">
        <label id="elh_VISIT_REASON_REASON_ID" for="x_REASON_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->REASON_ID->caption() ?><?= $Page->REASON_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->REASON_ID->cellAttributes() ?>>
<span id="el_VISIT_REASON_REASON_ID">
<input type="<?= $Page->REASON_ID->getInputTextType() ?>" data-table="VISIT_REASON" data-field="x_REASON_ID" name="x_REASON_ID" id="x_REASON_ID" size="30" placeholder="<?= HtmlEncode($Page->REASON_ID->getPlaceHolder()) ?>" value="<?= $Page->REASON_ID->EditValue ?>"<?= $Page->REASON_ID->editAttributes() ?> aria-describedby="x_REASON_ID_help">
<?= $Page->REASON_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->REASON_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->REASON->Visible) { // REASON ?>
    <div id="r_REASON" class="form-group row">
        <label id="elh_VISIT_REASON_REASON" for="x_REASON" class="<?= $Page->LeftColumnClass ?>"><?= $Page->REASON->caption() ?><?= $Page->REASON->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->REASON->cellAttributes() ?>>
<span id="el_VISIT_REASON_REASON">
<input type="<?= $Page->REASON->getInputTextType() ?>" data-table="VISIT_REASON" data-field="x_REASON" name="x_REASON" id="x_REASON" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->REASON->getPlaceHolder()) ?>" value="<?= $Page->REASON->EditValue ?>"<?= $Page->REASON->editAttributes() ?> aria-describedby="x_REASON_help">
<?= $Page->REASON->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->REASON->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->LAKALANTAS->Visible) { // LAKALANTAS ?>
    <div id="r_LAKALANTAS" class="form-group row">
        <label id="elh_VISIT_REASON_LAKALANTAS" for="x_LAKALANTAS" class="<?= $Page->LeftColumnClass ?>"><?= $Page->LAKALANTAS->caption() ?><?= $Page->LAKALANTAS->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->LAKALANTAS->cellAttributes() ?>>
<span id="el_VISIT_REASON_LAKALANTAS">
<input type="<?= $Page->LAKALANTAS->getInputTextType() ?>" data-table="VISIT_REASON" data-field="x_LAKALANTAS" name="x_LAKALANTAS" id="x_LAKALANTAS" size="30" maxlength="1" placeholder="<?= HtmlEncode($Page->LAKALANTAS->getPlaceHolder()) ?>" value="<?= $Page->LAKALANTAS->EditValue ?>"<?= $Page->LAKALANTAS->editAttributes() ?> aria-describedby="x_LAKALANTAS_help">
<?= $Page->LAKALANTAS->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->LAKALANTAS->getErrorMessage() ?></div>
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
    ew.addEventHandlers("VISIT_REASON");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
