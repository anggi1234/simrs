<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

// Page object
$TreatmentResultsEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fTREATMENT_RESULTSedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fTREATMENT_RESULTSedit = currentForm = new ew.Form("fTREATMENT_RESULTSedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "TREATMENT_RESULTS")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.TREATMENT_RESULTS)
        ew.vars.tables.TREATMENT_RESULTS = currentTable;
    fTREATMENT_RESULTSedit.addFields([
        ["RESULT_ID", [fields.RESULT_ID.visible && fields.RESULT_ID.required ? ew.Validators.required(fields.RESULT_ID.caption) : null, ew.Validators.integer], fields.RESULT_ID.isInvalid],
        ["RESULTS", [fields.RESULTS.visible && fields.RESULTS.required ? ew.Validators.required(fields.RESULTS.caption) : null], fields.RESULTS.isInvalid],
        ["DESCRIPTION", [fields.DESCRIPTION.visible && fields.DESCRIPTION.required ? ew.Validators.required(fields.DESCRIPTION.caption) : null], fields.DESCRIPTION.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fTREATMENT_RESULTSedit,
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
    fTREATMENT_RESULTSedit.validate = function () {
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
    fTREATMENT_RESULTSedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fTREATMENT_RESULTSedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fTREATMENT_RESULTSedit");
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
<form name="fTREATMENT_RESULTSedit" id="fTREATMENT_RESULTSedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="TREATMENT_RESULTS">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->RESULT_ID->Visible) { // RESULT_ID ?>
    <div id="r_RESULT_ID" class="form-group row">
        <label id="elh_TREATMENT_RESULTS_RESULT_ID" for="x_RESULT_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->RESULT_ID->caption() ?><?= $Page->RESULT_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->RESULT_ID->cellAttributes() ?>>
<input type="<?= $Page->RESULT_ID->getInputTextType() ?>" data-table="TREATMENT_RESULTS" data-field="x_RESULT_ID" name="x_RESULT_ID" id="x_RESULT_ID" size="30" placeholder="<?= HtmlEncode($Page->RESULT_ID->getPlaceHolder()) ?>" value="<?= $Page->RESULT_ID->EditValue ?>"<?= $Page->RESULT_ID->editAttributes() ?> aria-describedby="x_RESULT_ID_help">
<?= $Page->RESULT_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->RESULT_ID->getErrorMessage() ?></div>
<input type="hidden" data-table="TREATMENT_RESULTS" data-field="x_RESULT_ID" data-hidden="1" name="o_RESULT_ID" id="o_RESULT_ID" value="<?= HtmlEncode($Page->RESULT_ID->OldValue ?? $Page->RESULT_ID->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->RESULTS->Visible) { // RESULTS ?>
    <div id="r_RESULTS" class="form-group row">
        <label id="elh_TREATMENT_RESULTS_RESULTS" for="x_RESULTS" class="<?= $Page->LeftColumnClass ?>"><?= $Page->RESULTS->caption() ?><?= $Page->RESULTS->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->RESULTS->cellAttributes() ?>>
<span id="el_TREATMENT_RESULTS_RESULTS">
<input type="<?= $Page->RESULTS->getInputTextType() ?>" data-table="TREATMENT_RESULTS" data-field="x_RESULTS" name="x_RESULTS" id="x_RESULTS" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->RESULTS->getPlaceHolder()) ?>" value="<?= $Page->RESULTS->EditValue ?>"<?= $Page->RESULTS->editAttributes() ?> aria-describedby="x_RESULTS_help">
<?= $Page->RESULTS->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->RESULTS->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->DESCRIPTION->Visible) { // DESCRIPTION ?>
    <div id="r_DESCRIPTION" class="form-group row">
        <label id="elh_TREATMENT_RESULTS_DESCRIPTION" for="x_DESCRIPTION" class="<?= $Page->LeftColumnClass ?>"><?= $Page->DESCRIPTION->caption() ?><?= $Page->DESCRIPTION->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->DESCRIPTION->cellAttributes() ?>>
<span id="el_TREATMENT_RESULTS_DESCRIPTION">
<input type="<?= $Page->DESCRIPTION->getInputTextType() ?>" data-table="TREATMENT_RESULTS" data-field="x_DESCRIPTION" name="x_DESCRIPTION" id="x_DESCRIPTION" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->DESCRIPTION->getPlaceHolder()) ?>" value="<?= $Page->DESCRIPTION->EditValue ?>"<?= $Page->DESCRIPTION->editAttributes() ?> aria-describedby="x_DESCRIPTION_help">
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
    ew.addEventHandlers("TREATMENT_RESULTS");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
