<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

// Page object
$WeeksAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fWEEKSadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fWEEKSadd = currentForm = new ew.Form("fWEEKSadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "WEEKS")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.WEEKS)
        ew.vars.tables.WEEKS = currentTable;
    fWEEKSadd.addFields([
        ["WEEK_ID", [fields.WEEK_ID.visible && fields.WEEK_ID.required ? ew.Validators.required(fields.WEEK_ID.caption) : null, ew.Validators.integer], fields.WEEK_ID.isInvalid],
        ["WEEK_NAME", [fields.WEEK_NAME.visible && fields.WEEK_NAME.required ? ew.Validators.required(fields.WEEK_NAME.caption) : null], fields.WEEK_NAME.isInvalid],
        ["KODE_HURUF", [fields.KODE_HURUF.visible && fields.KODE_HURUF.required ? ew.Validators.required(fields.KODE_HURUF.caption) : null], fields.KODE_HURUF.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fWEEKSadd,
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
    fWEEKSadd.validate = function () {
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
    fWEEKSadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fWEEKSadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fWEEKSadd");
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
<form name="fWEEKSadd" id="fWEEKSadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="WEEKS">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->WEEK_ID->Visible) { // WEEK_ID ?>
    <div id="r_WEEK_ID" class="form-group row">
        <label id="elh_WEEKS_WEEK_ID" for="x_WEEK_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->WEEK_ID->caption() ?><?= $Page->WEEK_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->WEEK_ID->cellAttributes() ?>>
<span id="el_WEEKS_WEEK_ID">
<input type="<?= $Page->WEEK_ID->getInputTextType() ?>" data-table="WEEKS" data-field="x_WEEK_ID" name="x_WEEK_ID" id="x_WEEK_ID" size="30" placeholder="<?= HtmlEncode($Page->WEEK_ID->getPlaceHolder()) ?>" value="<?= $Page->WEEK_ID->EditValue ?>"<?= $Page->WEEK_ID->editAttributes() ?> aria-describedby="x_WEEK_ID_help">
<?= $Page->WEEK_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->WEEK_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->WEEK_NAME->Visible) { // WEEK_NAME ?>
    <div id="r_WEEK_NAME" class="form-group row">
        <label id="elh_WEEKS_WEEK_NAME" for="x_WEEK_NAME" class="<?= $Page->LeftColumnClass ?>"><?= $Page->WEEK_NAME->caption() ?><?= $Page->WEEK_NAME->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->WEEK_NAME->cellAttributes() ?>>
<span id="el_WEEKS_WEEK_NAME">
<input type="<?= $Page->WEEK_NAME->getInputTextType() ?>" data-table="WEEKS" data-field="x_WEEK_NAME" name="x_WEEK_NAME" id="x_WEEK_NAME" size="30" maxlength="200" placeholder="<?= HtmlEncode($Page->WEEK_NAME->getPlaceHolder()) ?>" value="<?= $Page->WEEK_NAME->EditValue ?>"<?= $Page->WEEK_NAME->editAttributes() ?> aria-describedby="x_WEEK_NAME_help">
<?= $Page->WEEK_NAME->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->WEEK_NAME->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->KODE_HURUF->Visible) { // KODE_HURUF ?>
    <div id="r_KODE_HURUF" class="form-group row">
        <label id="elh_WEEKS_KODE_HURUF" for="x_KODE_HURUF" class="<?= $Page->LeftColumnClass ?>"><?= $Page->KODE_HURUF->caption() ?><?= $Page->KODE_HURUF->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->KODE_HURUF->cellAttributes() ?>>
<span id="el_WEEKS_KODE_HURUF">
<input type="<?= $Page->KODE_HURUF->getInputTextType() ?>" data-table="WEEKS" data-field="x_KODE_HURUF" name="x_KODE_HURUF" id="x_KODE_HURUF" size="30" maxlength="5" placeholder="<?= HtmlEncode($Page->KODE_HURUF->getPlaceHolder()) ?>" value="<?= $Page->KODE_HURUF->EditValue ?>"<?= $Page->KODE_HURUF->editAttributes() ?> aria-describedby="x_KODE_HURUF_help">
<?= $Page->KODE_HURUF->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->KODE_HURUF->getErrorMessage() ?></div>
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
    ew.addEventHandlers("WEEKS");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
