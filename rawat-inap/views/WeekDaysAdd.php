<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

// Page object
$WeekDaysAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fWEEK_DAYSadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fWEEK_DAYSadd = currentForm = new ew.Form("fWEEK_DAYSadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "WEEK_DAYS")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.WEEK_DAYS)
        ew.vars.tables.WEEK_DAYS = currentTable;
    fWEEK_DAYSadd.addFields([
        ["DAY_ID", [fields.DAY_ID.visible && fields.DAY_ID.required ? ew.Validators.required(fields.DAY_ID.caption) : null], fields.DAY_ID.isInvalid],
        ["WEEK_DAY", [fields.WEEK_DAY.visible && fields.WEEK_DAY.required ? ew.Validators.required(fields.WEEK_DAY.caption) : null], fields.WEEK_DAY.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fWEEK_DAYSadd,
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
    fWEEK_DAYSadd.validate = function () {
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
    fWEEK_DAYSadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fWEEK_DAYSadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fWEEK_DAYSadd");
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
<form name="fWEEK_DAYSadd" id="fWEEK_DAYSadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="WEEK_DAYS">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->DAY_ID->Visible) { // DAY_ID ?>
    <div id="r_DAY_ID" class="form-group row">
        <label id="elh_WEEK_DAYS_DAY_ID" for="x_DAY_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->DAY_ID->caption() ?><?= $Page->DAY_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->DAY_ID->cellAttributes() ?>>
<span id="el_WEEK_DAYS_DAY_ID">
<input type="<?= $Page->DAY_ID->getInputTextType() ?>" data-table="WEEK_DAYS" data-field="x_DAY_ID" name="x_DAY_ID" id="x_DAY_ID" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->DAY_ID->getPlaceHolder()) ?>" value="<?= $Page->DAY_ID->EditValue ?>"<?= $Page->DAY_ID->editAttributes() ?> aria-describedby="x_DAY_ID_help">
<?= $Page->DAY_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->DAY_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->WEEK_DAY->Visible) { // WEEK_DAY ?>
    <div id="r_WEEK_DAY" class="form-group row">
        <label id="elh_WEEK_DAYS_WEEK_DAY" for="x_WEEK_DAY" class="<?= $Page->LeftColumnClass ?>"><?= $Page->WEEK_DAY->caption() ?><?= $Page->WEEK_DAY->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->WEEK_DAY->cellAttributes() ?>>
<span id="el_WEEK_DAYS_WEEK_DAY">
<input type="<?= $Page->WEEK_DAY->getInputTextType() ?>" data-table="WEEK_DAYS" data-field="x_WEEK_DAY" name="x_WEEK_DAY" id="x_WEEK_DAY" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->WEEK_DAY->getPlaceHolder()) ?>" value="<?= $Page->WEEK_DAY->EditValue ?>"<?= $Page->WEEK_DAY->editAttributes() ?> aria-describedby="x_WEEK_DAY_help">
<?= $Page->WEEK_DAY->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->WEEK_DAY->getErrorMessage() ?></div>
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
    ew.addEventHandlers("WEEK_DAYS");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
