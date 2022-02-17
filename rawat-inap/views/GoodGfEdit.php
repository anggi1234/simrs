<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

// Page object
$GoodGfEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fGOOD_GFedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fGOOD_GFedit = currentForm = new ew.Form("fGOOD_GFedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "GOOD_GF")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.GOOD_GF)
        ew.vars.tables.GOOD_GF = currentTable;
    fGOOD_GFedit.addFields([
        ["BATCH_NO", [fields.BATCH_NO.visible && fields.BATCH_NO.required ? ew.Validators.required(fields.BATCH_NO.caption) : null], fields.BATCH_NO.isInvalid],
        ["BRAND_ID", [fields.BRAND_ID.visible && fields.BRAND_ID.required ? ew.Validators.required(fields.BRAND_ID.caption) : null], fields.BRAND_ID.isInvalid],
        ["ROOMS_ID", [fields.ROOMS_ID.visible && fields.ROOMS_ID.required ? ew.Validators.required(fields.ROOMS_ID.caption) : null], fields.ROOMS_ID.isInvalid],
        ["EXPIRY_DATE", [fields.EXPIRY_DATE.visible && fields.EXPIRY_DATE.required ? ew.Validators.required(fields.EXPIRY_DATE.caption) : null, ew.Validators.datetime(0)], fields.EXPIRY_DATE.isInvalid],
        ["ALLOCATED_FROM", [fields.ALLOCATED_FROM.visible && fields.ALLOCATED_FROM.required ? ew.Validators.required(fields.ALLOCATED_FROM.caption) : null], fields.ALLOCATED_FROM.isInvalid],
        ["DIJUAL", [fields.DIJUAL.visible && fields.DIJUAL.required ? ew.Validators.required(fields.DIJUAL.caption) : null, ew.Validators.float], fields.DIJUAL.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fGOOD_GFedit,
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
    fGOOD_GFedit.validate = function () {
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
    fGOOD_GFedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fGOOD_GFedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fGOOD_GFedit.lists.BRAND_ID = <?= $Page->BRAND_ID->toClientList($Page) ?>;
    loadjs.done("fGOOD_GFedit");
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
<form name="fGOOD_GFedit" id="fGOOD_GFedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="GOOD_GF">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "MUTATION_DOCS") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="MUTATION_DOCS">
<input type="hidden" name="fk_DOC_NO" value="<?= HtmlEncode($Page->DOC_NO->getSessionValue()) ?>">
<input type="hidden" name="fk_CLINIC_ID_TO" value="<?= HtmlEncode($Page->ROOMS_ID->getSessionValue()) ?>">
<input type="hidden" name="fk_CLINIC_ID" value="<?= HtmlEncode($Page->FROM_ROOMS_ID->getSessionValue()) ?>">
<?php } ?>
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->BATCH_NO->Visible) { // BATCH_NO ?>
    <div id="r_BATCH_NO" class="form-group row">
        <label id="elh_GOOD_GF_BATCH_NO" for="x_BATCH_NO" class="<?= $Page->LeftColumnClass ?>"><?= $Page->BATCH_NO->caption() ?><?= $Page->BATCH_NO->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->BATCH_NO->cellAttributes() ?>>
<span id="el_GOOD_GF_BATCH_NO">
<input type="<?= $Page->BATCH_NO->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_BATCH_NO" name="x_BATCH_NO" id="x_BATCH_NO" size="30" maxlength="75" placeholder="<?= HtmlEncode($Page->BATCH_NO->getPlaceHolder()) ?>" value="<?= $Page->BATCH_NO->EditValue ?>"<?= $Page->BATCH_NO->editAttributes() ?> aria-describedby="x_BATCH_NO_help">
<?= $Page->BATCH_NO->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->BATCH_NO->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->BRAND_ID->Visible) { // BRAND_ID ?>
    <div id="r_BRAND_ID" class="form-group row">
        <label id="elh_GOOD_GF_BRAND_ID" for="x_BRAND_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->BRAND_ID->caption() ?><?= $Page->BRAND_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->BRAND_ID->cellAttributes() ?>>
<span id="el_GOOD_GF_BRAND_ID">
<div class="input-group ew-lookup-list" aria-describedby="x_BRAND_ID_help">
    <div class="form-control ew-lookup-text" tabindex="-1" id="lu_x_BRAND_ID"><?= EmptyValue(strval($Page->BRAND_ID->ViewValue)) ? $Language->phrase("PleaseSelect") : $Page->BRAND_ID->ViewValue ?></div>
    <div class="input-group-append">
        <button type="button" title="<?= HtmlEncode(str_replace("%s", RemoveHtml($Page->BRAND_ID->caption()), $Language->phrase("LookupLink", true))) ?>" class="ew-lookup-btn btn btn-default"<?= ($Page->BRAND_ID->ReadOnly || $Page->BRAND_ID->Disabled) ? " disabled" : "" ?> onclick="ew.modalLookupShow({lnk:this,el:'x_BRAND_ID',m:0,n:10});"><i class="fas fa-search ew-icon"></i></button>
    </div>
</div>
<div class="invalid-feedback"><?= $Page->BRAND_ID->getErrorMessage() ?></div>
<?= $Page->BRAND_ID->getCustomMessage() ?>
<?= $Page->BRAND_ID->Lookup->getParamTag($Page, "p_x_BRAND_ID") ?>
<input type="hidden" is="selection-list" data-table="GOOD_GF" data-field="x_BRAND_ID" data-type="text" data-multiple="0" data-lookup="1" data-value-separator="<?= $Page->BRAND_ID->displayValueSeparatorAttribute() ?>" name="x_BRAND_ID" id="x_BRAND_ID" value="<?= $Page->BRAND_ID->CurrentValue ?>"<?= $Page->BRAND_ID->editAttributes() ?>>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ROOMS_ID->Visible) { // ROOMS_ID ?>
    <div id="r_ROOMS_ID" class="form-group row">
        <label id="elh_GOOD_GF_ROOMS_ID" for="x_ROOMS_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ROOMS_ID->caption() ?><?= $Page->ROOMS_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ROOMS_ID->cellAttributes() ?>>
<?php if ($Page->ROOMS_ID->getSessionValue() != "") { ?>
<span id="el_GOOD_GF_ROOMS_ID">
<span<?= $Page->ROOMS_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->ROOMS_ID->getDisplayValue($Page->ROOMS_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x_ROOMS_ID" name="x_ROOMS_ID" value="<?= HtmlEncode($Page->ROOMS_ID->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_GOOD_GF_ROOMS_ID">
<input type="<?= $Page->ROOMS_ID->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_ROOMS_ID" name="x_ROOMS_ID" id="x_ROOMS_ID" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->ROOMS_ID->getPlaceHolder()) ?>" value="<?= $Page->ROOMS_ID->EditValue ?>"<?= $Page->ROOMS_ID->editAttributes() ?> aria-describedby="x_ROOMS_ID_help">
<?= $Page->ROOMS_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ROOMS_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->EXPIRY_DATE->Visible) { // EXPIRY_DATE ?>
    <div id="r_EXPIRY_DATE" class="form-group row">
        <label id="elh_GOOD_GF_EXPIRY_DATE" for="x_EXPIRY_DATE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->EXPIRY_DATE->caption() ?><?= $Page->EXPIRY_DATE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->EXPIRY_DATE->cellAttributes() ?>>
<span id="el_GOOD_GF_EXPIRY_DATE">
<input type="<?= $Page->EXPIRY_DATE->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_EXPIRY_DATE" name="x_EXPIRY_DATE" id="x_EXPIRY_DATE" placeholder="<?= HtmlEncode($Page->EXPIRY_DATE->getPlaceHolder()) ?>" value="<?= $Page->EXPIRY_DATE->EditValue ?>"<?= $Page->EXPIRY_DATE->editAttributes() ?> aria-describedby="x_EXPIRY_DATE_help">
<?= $Page->EXPIRY_DATE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->EXPIRY_DATE->getErrorMessage() ?></div>
<?php if (!$Page->EXPIRY_DATE->ReadOnly && !$Page->EXPIRY_DATE->Disabled && !isset($Page->EXPIRY_DATE->EditAttrs["readonly"]) && !isset($Page->EXPIRY_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fGOOD_GFedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fGOOD_GFedit", "x_EXPIRY_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ALLOCATED_FROM->Visible) { // ALLOCATED_FROM ?>
    <div id="r_ALLOCATED_FROM" class="form-group row">
        <label id="elh_GOOD_GF_ALLOCATED_FROM" for="x_ALLOCATED_FROM" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ALLOCATED_FROM->caption() ?><?= $Page->ALLOCATED_FROM->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ALLOCATED_FROM->cellAttributes() ?>>
<span id="el_GOOD_GF_ALLOCATED_FROM">
<input type="<?= $Page->ALLOCATED_FROM->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_ALLOCATED_FROM" name="x_ALLOCATED_FROM" id="x_ALLOCATED_FROM" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->ALLOCATED_FROM->getPlaceHolder()) ?>" value="<?= $Page->ALLOCATED_FROM->EditValue ?>"<?= $Page->ALLOCATED_FROM->editAttributes() ?> aria-describedby="x_ALLOCATED_FROM_help">
<?= $Page->ALLOCATED_FROM->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ALLOCATED_FROM->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->DIJUAL->Visible) { // DIJUAL ?>
    <div id="r_DIJUAL" class="form-group row">
        <label id="elh_GOOD_GF_DIJUAL" for="x_DIJUAL" class="<?= $Page->LeftColumnClass ?>"><?= $Page->DIJUAL->caption() ?><?= $Page->DIJUAL->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->DIJUAL->cellAttributes() ?>>
<span id="el_GOOD_GF_DIJUAL">
<input type="<?= $Page->DIJUAL->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_DIJUAL" name="x_DIJUAL" id="x_DIJUAL" size="30" placeholder="<?= HtmlEncode($Page->DIJUAL->getPlaceHolder()) ?>" value="<?= $Page->DIJUAL->EditValue ?>"<?= $Page->DIJUAL->editAttributes() ?> aria-describedby="x_DIJUAL_help">
<?= $Page->DIJUAL->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->DIJUAL->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
    <input type="hidden" data-table="GOOD_GF" data-field="x_idx" data-hidden="1" name="x_idx" id="x_idx" value="<?= HtmlEncode($Page->idx->CurrentValue) ?>">
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
    ew.addEventHandlers("GOOD_GF");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
