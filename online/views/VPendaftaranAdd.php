<?php

namespace PHPMaker2021\ONLINEBARU;

// Page object
$VPendaftaranAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fv_pendaftaranadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fv_pendaftaranadd = currentForm = new ew.Form("fv_pendaftaranadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "v_pendaftaran")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.v_pendaftaran)
        ew.vars.tables.v_pendaftaran = currentTable;
    fv_pendaftaranadd.addFields([
        ["tanggal_daftar", [fields.tanggal_daftar.visible && fields.tanggal_daftar.required ? ew.Validators.required(fields.tanggal_daftar.caption) : null, ew.Validators.datetime(7)], fields.tanggal_daftar.isInvalid],
        ["status_panggil", [fields.status_panggil.visible && fields.status_panggil.required ? ew.Validators.required(fields.status_panggil.caption) : null], fields.status_panggil.isInvalid],
        ["user", [fields.user.visible && fields.user.required ? ew.Validators.required(fields.user.caption) : null], fields.user.isInvalid],
        ["newapp", [fields.newapp.visible && fields.newapp.required ? ew.Validators.required(fields.newapp.caption) : null], fields.newapp.isInvalid],
        ["kdpoli", [fields.kdpoli.visible && fields.kdpoli.required ? ew.Validators.required(fields.kdpoli.caption) : null], fields.kdpoli.isInvalid],
        ["tanggal_pesan", [fields.tanggal_pesan.visible && fields.tanggal_pesan.required ? ew.Validators.required(fields.tanggal_pesan.caption) : null], fields.tanggal_pesan.isInvalid],
        ["tujuan", [fields.tujuan.visible && fields.tujuan.required ? ew.Validators.required(fields.tujuan.caption) : null], fields.tujuan.isInvalid],
        ["disabilitas", [fields.disabilitas.visible && fields.disabilitas.required ? ew.Validators.required(fields.disabilitas.caption) : null, ew.Validators.integer], fields.disabilitas.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fv_pendaftaranadd,
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
    fv_pendaftaranadd.validate = function () {
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
    fv_pendaftaranadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fv_pendaftaranadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fv_pendaftaranadd.lists.kdpoli = <?= $Page->kdpoli->toClientList($Page) ?>;
    loadjs.done("fv_pendaftaranadd");
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
<form name="fv_pendaftaranadd" id="fv_pendaftaranadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="v_pendaftaran">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->tanggal_daftar->Visible) { // tanggal_daftar ?>
    <div id="r_tanggal_daftar" class="form-group row">
        <label id="elh_v_pendaftaran_tanggal_daftar" for="x_tanggal_daftar" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tanggal_daftar->caption() ?><?= $Page->tanggal_daftar->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tanggal_daftar->cellAttributes() ?>>
<span id="el_v_pendaftaran_tanggal_daftar">
<input type="<?= $Page->tanggal_daftar->getInputTextType() ?>" data-table="v_pendaftaran" data-field="x_tanggal_daftar" data-format="7" name="x_tanggal_daftar" id="x_tanggal_daftar" placeholder="<?= HtmlEncode($Page->tanggal_daftar->getPlaceHolder()) ?>" value="<?= $Page->tanggal_daftar->EditValue ?>"<?= $Page->tanggal_daftar->editAttributes() ?> aria-describedby="x_tanggal_daftar_help">
<?= $Page->tanggal_daftar->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tanggal_daftar->getErrorMessage() ?></div>
<?php if (!$Page->tanggal_daftar->ReadOnly && !$Page->tanggal_daftar->Disabled && !isset($Page->tanggal_daftar->EditAttrs["readonly"]) && !isset($Page->tanggal_daftar->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fv_pendaftaranadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fv_pendaftaranadd", "x_tanggal_daftar", {"ignoreReadonly":true,"useCurrent":false,"format":7});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
    <span id="el_v_pendaftaran_status_panggil">
    <input type="hidden" data-table="v_pendaftaran" data-field="x_status_panggil" data-hidden="1" name="x_status_panggil" id="x_status_panggil" value="<?= HtmlEncode($Page->status_panggil->CurrentValue) ?>">
    </span>
    <span id="el_v_pendaftaran_newapp">
    <input type="hidden" data-table="v_pendaftaran" data-field="x_newapp" data-hidden="1" name="x_newapp" id="x_newapp" value="<?= HtmlEncode($Page->newapp->CurrentValue) ?>">
    </span>
<?php if ($Page->kdpoli->Visible) { // kdpoli ?>
    <div id="r_kdpoli" class="form-group row">
        <label id="elh_v_pendaftaran_kdpoli" for="x_kdpoli" class="<?= $Page->LeftColumnClass ?>"><?= $Page->kdpoli->caption() ?><?= $Page->kdpoli->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->kdpoli->cellAttributes() ?>>
<span id="el_v_pendaftaran_kdpoli">
<div class="input-group ew-lookup-list" aria-describedby="x_kdpoli_help">
    <div class="form-control ew-lookup-text" tabindex="-1" id="lu_x_kdpoli"><?= EmptyValue(strval($Page->kdpoli->ViewValue)) ? $Language->phrase("PleaseSelect") : $Page->kdpoli->ViewValue ?></div>
    <div class="input-group-append">
        <button type="button" title="<?= HtmlEncode(str_replace("%s", RemoveHtml($Page->kdpoli->caption()), $Language->phrase("LookupLink", true))) ?>" class="ew-lookup-btn btn btn-default"<?= ($Page->kdpoli->ReadOnly || $Page->kdpoli->Disabled) ? " disabled" : "" ?> onclick="ew.modalLookupShow({lnk:this,el:'x_kdpoli',m:0,n:10});"><i class="fas fa-search ew-icon"></i></button>
    </div>
</div>
<div class="invalid-feedback"><?= $Page->kdpoli->getErrorMessage() ?></div>
<?= $Page->kdpoli->getCustomMessage() ?>
<?= $Page->kdpoli->Lookup->getParamTag($Page, "p_x_kdpoli") ?>
<input type="hidden" is="selection-list" data-table="v_pendaftaran" data-field="x_kdpoli" data-type="text" data-multiple="0" data-lookup="1" data-value-separator="<?= $Page->kdpoli->displayValueSeparatorAttribute() ?>" name="x_kdpoli" id="x_kdpoli" value="<?= $Page->kdpoli->CurrentValue ?>"<?= $Page->kdpoli->editAttributes() ?>>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tujuan->Visible) { // tujuan ?>
    <div id="r_tujuan" class="form-group row">
        <label id="elh_v_pendaftaran_tujuan" for="x_tujuan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tujuan->caption() ?><?= $Page->tujuan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tujuan->cellAttributes() ?>>
<span id="el_v_pendaftaran_tujuan">
<input type="<?= $Page->tujuan->getInputTextType() ?>" data-table="v_pendaftaran" data-field="x_tujuan" name="x_tujuan" id="x_tujuan" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->tujuan->getPlaceHolder()) ?>" value="<?= $Page->tujuan->EditValue ?>"<?= $Page->tujuan->editAttributes() ?> aria-describedby="x_tujuan_help">
<?= $Page->tujuan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tujuan->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->disabilitas->Visible) { // disabilitas ?>
    <div id="r_disabilitas" class="form-group row">
        <label id="elh_v_pendaftaran_disabilitas" for="x_disabilitas" class="<?= $Page->LeftColumnClass ?>"><?= $Page->disabilitas->caption() ?><?= $Page->disabilitas->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->disabilitas->cellAttributes() ?>>
<span id="el_v_pendaftaran_disabilitas">
<input type="<?= $Page->disabilitas->getInputTextType() ?>" data-table="v_pendaftaran" data-field="x_disabilitas" name="x_disabilitas" id="x_disabilitas" size="30" placeholder="<?= HtmlEncode($Page->disabilitas->getPlaceHolder()) ?>" value="<?= $Page->disabilitas->EditValue ?>"<?= $Page->disabilitas->editAttributes() ?> aria-describedby="x_disabilitas_help">
<?= $Page->disabilitas->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->disabilitas->getErrorMessage() ?></div>
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
    ew.addEventHandlers("v_pendaftaran");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
