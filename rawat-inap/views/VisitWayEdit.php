<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

// Page object
$VisitWayEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fVISIT_WAYedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fVISIT_WAYedit = currentForm = new ew.Form("fVISIT_WAYedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "VISIT_WAY")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.VISIT_WAY)
        ew.vars.tables.VISIT_WAY = currentTable;
    fVISIT_WAYedit.addFields([
        ["WAY_ID", [fields.WAY_ID.visible && fields.WAY_ID.required ? ew.Validators.required(fields.WAY_ID.caption) : null, ew.Validators.integer], fields.WAY_ID.isInvalid],
        ["WAY", [fields.WAY.visible && fields.WAY.required ? ew.Validators.required(fields.WAY.caption) : null], fields.WAY.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fVISIT_WAYedit,
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
    fVISIT_WAYedit.validate = function () {
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
    fVISIT_WAYedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fVISIT_WAYedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fVISIT_WAYedit");
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
<form name="fVISIT_WAYedit" id="fVISIT_WAYedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="VISIT_WAY">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->WAY_ID->Visible) { // WAY_ID ?>
    <div id="r_WAY_ID" class="form-group row">
        <label id="elh_VISIT_WAY_WAY_ID" for="x_WAY_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->WAY_ID->caption() ?><?= $Page->WAY_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->WAY_ID->cellAttributes() ?>>
<input type="<?= $Page->WAY_ID->getInputTextType() ?>" data-table="VISIT_WAY" data-field="x_WAY_ID" name="x_WAY_ID" id="x_WAY_ID" size="30" placeholder="<?= HtmlEncode($Page->WAY_ID->getPlaceHolder()) ?>" value="<?= $Page->WAY_ID->EditValue ?>"<?= $Page->WAY_ID->editAttributes() ?> aria-describedby="x_WAY_ID_help">
<?= $Page->WAY_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->WAY_ID->getErrorMessage() ?></div>
<input type="hidden" data-table="VISIT_WAY" data-field="x_WAY_ID" data-hidden="1" name="o_WAY_ID" id="o_WAY_ID" value="<?= HtmlEncode($Page->WAY_ID->OldValue ?? $Page->WAY_ID->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->WAY->Visible) { // WAY ?>
    <div id="r_WAY" class="form-group row">
        <label id="elh_VISIT_WAY_WAY" for="x_WAY" class="<?= $Page->LeftColumnClass ?>"><?= $Page->WAY->caption() ?><?= $Page->WAY->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->WAY->cellAttributes() ?>>
<span id="el_VISIT_WAY_WAY">
<input type="<?= $Page->WAY->getInputTextType() ?>" data-table="VISIT_WAY" data-field="x_WAY" name="x_WAY" id="x_WAY" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->WAY->getPlaceHolder()) ?>" value="<?= $Page->WAY->EditValue ?>"<?= $Page->WAY->editAttributes() ?> aria-describedby="x_WAY_help">
<?= $Page->WAY->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->WAY->getErrorMessage() ?></div>
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
    ew.addEventHandlers("VISIT_WAY");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
