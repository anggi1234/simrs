<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

// Page object
$YearsEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fYEARSedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fYEARSedit = currentForm = new ew.Form("fYEARSedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "YEARS")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.YEARS)
        ew.vars.tables.YEARS = currentTable;
    fYEARSedit.addFields([
        ["YEAR_ID", [fields.YEAR_ID.visible && fields.YEAR_ID.required ? ew.Validators.required(fields.YEAR_ID.caption) : null, ew.Validators.integer], fields.YEAR_ID.isInvalid],
        ["START_DATE", [fields.START_DATE.visible && fields.START_DATE.required ? ew.Validators.required(fields.START_DATE.caption) : null, ew.Validators.datetime(0)], fields.START_DATE.isInvalid],
        ["END_DATE", [fields.END_DATE.visible && fields.END_DATE.required ? ew.Validators.required(fields.END_DATE.caption) : null, ew.Validators.datetime(0)], fields.END_DATE.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fYEARSedit,
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
    fYEARSedit.validate = function () {
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
    fYEARSedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fYEARSedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fYEARSedit");
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
<form name="fYEARSedit" id="fYEARSedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="YEARS">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->YEAR_ID->Visible) { // YEAR_ID ?>
    <div id="r_YEAR_ID" class="form-group row">
        <label id="elh_YEARS_YEAR_ID" for="x_YEAR_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->YEAR_ID->caption() ?><?= $Page->YEAR_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->YEAR_ID->cellAttributes() ?>>
<input type="<?= $Page->YEAR_ID->getInputTextType() ?>" data-table="YEARS" data-field="x_YEAR_ID" name="x_YEAR_ID" id="x_YEAR_ID" size="30" placeholder="<?= HtmlEncode($Page->YEAR_ID->getPlaceHolder()) ?>" value="<?= $Page->YEAR_ID->EditValue ?>"<?= $Page->YEAR_ID->editAttributes() ?> aria-describedby="x_YEAR_ID_help">
<?= $Page->YEAR_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->YEAR_ID->getErrorMessage() ?></div>
<input type="hidden" data-table="YEARS" data-field="x_YEAR_ID" data-hidden="1" name="o_YEAR_ID" id="o_YEAR_ID" value="<?= HtmlEncode($Page->YEAR_ID->OldValue ?? $Page->YEAR_ID->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->START_DATE->Visible) { // START_DATE ?>
    <div id="r_START_DATE" class="form-group row">
        <label id="elh_YEARS_START_DATE" for="x_START_DATE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->START_DATE->caption() ?><?= $Page->START_DATE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->START_DATE->cellAttributes() ?>>
<span id="el_YEARS_START_DATE">
<input type="<?= $Page->START_DATE->getInputTextType() ?>" data-table="YEARS" data-field="x_START_DATE" name="x_START_DATE" id="x_START_DATE" placeholder="<?= HtmlEncode($Page->START_DATE->getPlaceHolder()) ?>" value="<?= $Page->START_DATE->EditValue ?>"<?= $Page->START_DATE->editAttributes() ?> aria-describedby="x_START_DATE_help">
<?= $Page->START_DATE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->START_DATE->getErrorMessage() ?></div>
<?php if (!$Page->START_DATE->ReadOnly && !$Page->START_DATE->Disabled && !isset($Page->START_DATE->EditAttrs["readonly"]) && !isset($Page->START_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fYEARSedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fYEARSedit", "x_START_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->END_DATE->Visible) { // END_DATE ?>
    <div id="r_END_DATE" class="form-group row">
        <label id="elh_YEARS_END_DATE" for="x_END_DATE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->END_DATE->caption() ?><?= $Page->END_DATE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->END_DATE->cellAttributes() ?>>
<span id="el_YEARS_END_DATE">
<input type="<?= $Page->END_DATE->getInputTextType() ?>" data-table="YEARS" data-field="x_END_DATE" name="x_END_DATE" id="x_END_DATE" placeholder="<?= HtmlEncode($Page->END_DATE->getPlaceHolder()) ?>" value="<?= $Page->END_DATE->EditValue ?>"<?= $Page->END_DATE->editAttributes() ?> aria-describedby="x_END_DATE_help">
<?= $Page->END_DATE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->END_DATE->getErrorMessage() ?></div>
<?php if (!$Page->END_DATE->ReadOnly && !$Page->END_DATE->Disabled && !isset($Page->END_DATE->EditAttrs["readonly"]) && !isset($Page->END_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fYEARSedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fYEARSedit", "x_END_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
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
    ew.addEventHandlers("YEARS");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
