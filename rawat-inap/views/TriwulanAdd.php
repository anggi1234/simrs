<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

// Page object
$TriwulanAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var ftriwulanadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    ftriwulanadd = currentForm = new ew.Form("ftriwulanadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "triwulan")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.triwulan)
        ew.vars.tables.triwulan = currentTable;
    ftriwulanadd.addFields([
        ["triwulan", [fields.triwulan.visible && fields.triwulan.required ? ew.Validators.required(fields.triwulan.caption) : null, ew.Validators.integer], fields.triwulan.isInvalid],
        ["keterangan", [fields.keterangan.visible && fields.keterangan.required ? ew.Validators.required(fields.keterangan.caption) : null], fields.keterangan.isInvalid],
        ["mulai", [fields.mulai.visible && fields.mulai.required ? ew.Validators.required(fields.mulai.caption) : null, ew.Validators.datetime(0)], fields.mulai.isInvalid],
        ["akhir", [fields.akhir.visible && fields.akhir.required ? ew.Validators.required(fields.akhir.caption) : null, ew.Validators.datetime(0)], fields.akhir.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = ftriwulanadd,
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
    ftriwulanadd.validate = function () {
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
    ftriwulanadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    ftriwulanadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("ftriwulanadd");
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
<form name="ftriwulanadd" id="ftriwulanadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="triwulan">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->triwulan->Visible) { // triwulan ?>
    <div id="r_triwulan" class="form-group row">
        <label id="elh_triwulan_triwulan" for="x_triwulan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->triwulan->caption() ?><?= $Page->triwulan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->triwulan->cellAttributes() ?>>
<span id="el_triwulan_triwulan">
<input type="<?= $Page->triwulan->getInputTextType() ?>" data-table="triwulan" data-field="x_triwulan" name="x_triwulan" id="x_triwulan" size="30" placeholder="<?= HtmlEncode($Page->triwulan->getPlaceHolder()) ?>" value="<?= $Page->triwulan->EditValue ?>"<?= $Page->triwulan->editAttributes() ?> aria-describedby="x_triwulan_help">
<?= $Page->triwulan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->triwulan->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->keterangan->Visible) { // keterangan ?>
    <div id="r_keterangan" class="form-group row">
        <label id="elh_triwulan_keterangan" for="x_keterangan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->keterangan->caption() ?><?= $Page->keterangan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->keterangan->cellAttributes() ?>>
<span id="el_triwulan_keterangan">
<input type="<?= $Page->keterangan->getInputTextType() ?>" data-table="triwulan" data-field="x_keterangan" name="x_keterangan" id="x_keterangan" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->keterangan->getPlaceHolder()) ?>" value="<?= $Page->keterangan->EditValue ?>"<?= $Page->keterangan->editAttributes() ?> aria-describedby="x_keterangan_help">
<?= $Page->keterangan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->keterangan->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->mulai->Visible) { // mulai ?>
    <div id="r_mulai" class="form-group row">
        <label id="elh_triwulan_mulai" for="x_mulai" class="<?= $Page->LeftColumnClass ?>"><?= $Page->mulai->caption() ?><?= $Page->mulai->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->mulai->cellAttributes() ?>>
<span id="el_triwulan_mulai">
<input type="<?= $Page->mulai->getInputTextType() ?>" data-table="triwulan" data-field="x_mulai" name="x_mulai" id="x_mulai" placeholder="<?= HtmlEncode($Page->mulai->getPlaceHolder()) ?>" value="<?= $Page->mulai->EditValue ?>"<?= $Page->mulai->editAttributes() ?> aria-describedby="x_mulai_help">
<?= $Page->mulai->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->mulai->getErrorMessage() ?></div>
<?php if (!$Page->mulai->ReadOnly && !$Page->mulai->Disabled && !isset($Page->mulai->EditAttrs["readonly"]) && !isset($Page->mulai->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["ftriwulanadd", "datetimepicker"], function() {
    ew.createDateTimePicker("ftriwulanadd", "x_mulai", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->akhir->Visible) { // akhir ?>
    <div id="r_akhir" class="form-group row">
        <label id="elh_triwulan_akhir" for="x_akhir" class="<?= $Page->LeftColumnClass ?>"><?= $Page->akhir->caption() ?><?= $Page->akhir->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->akhir->cellAttributes() ?>>
<span id="el_triwulan_akhir">
<input type="<?= $Page->akhir->getInputTextType() ?>" data-table="triwulan" data-field="x_akhir" name="x_akhir" id="x_akhir" placeholder="<?= HtmlEncode($Page->akhir->getPlaceHolder()) ?>" value="<?= $Page->akhir->EditValue ?>"<?= $Page->akhir->editAttributes() ?> aria-describedby="x_akhir_help">
<?= $Page->akhir->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->akhir->getErrorMessage() ?></div>
<?php if (!$Page->akhir->ReadOnly && !$Page->akhir->Disabled && !isset($Page->akhir->EditAttrs["readonly"]) && !isset($Page->akhir->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["ftriwulanadd", "datetimepicker"], function() {
    ew.createDateTimePicker("ftriwulanadd", "x_akhir", {"ignoreReadonly":true,"useCurrent":false,"format":0});
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
    ew.addEventHandlers("triwulan");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
