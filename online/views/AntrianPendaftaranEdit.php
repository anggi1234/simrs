<?php

namespace PHPMaker2021\ONLINEBARU;

// Page object
$AntrianPendaftaranEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fANTRIAN_PENDAFTARANedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fANTRIAN_PENDAFTARANedit = currentForm = new ew.Form("fANTRIAN_PENDAFTARANedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "ANTRIAN_PENDAFTARAN")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.ANTRIAN_PENDAFTARAN)
        ew.vars.tables.ANTRIAN_PENDAFTARAN = currentTable;
    fANTRIAN_PENDAFTARANedit.addFields([
        ["Id", [fields.Id.visible && fields.Id.required ? ew.Validators.required(fields.Id.caption) : null], fields.Id.isInvalid],
        ["no_urut", [fields.no_urut.visible && fields.no_urut.required ? ew.Validators.required(fields.no_urut.caption) : null, ew.Validators.integer], fields.no_urut.isInvalid],
        ["tanggal_daftar", [fields.tanggal_daftar.visible && fields.tanggal_daftar.required ? ew.Validators.required(fields.tanggal_daftar.caption) : null], fields.tanggal_daftar.isInvalid],
        ["tanggal_panggil", [fields.tanggal_panggil.visible && fields.tanggal_panggil.required ? ew.Validators.required(fields.tanggal_panggil.caption) : null, ew.Validators.datetime(0)], fields.tanggal_panggil.isInvalid],
        ["loket", [fields.loket.visible && fields.loket.required ? ew.Validators.required(fields.loket.caption) : null], fields.loket.isInvalid],
        ["status_panggil", [fields.status_panggil.visible && fields.status_panggil.required ? ew.Validators.required(fields.status_panggil.caption) : null, ew.Validators.integer], fields.status_panggil.isInvalid],
        ["user", [fields.user.visible && fields.user.required ? ew.Validators.required(fields.user.caption) : null], fields.user.isInvalid],
        ["newapp", [fields.newapp.visible && fields.newapp.required ? ew.Validators.required(fields.newapp.caption) : null], fields.newapp.isInvalid],
        ["kdpoli", [fields.kdpoli.visible && fields.kdpoli.required ? ew.Validators.required(fields.kdpoli.caption) : null], fields.kdpoli.isInvalid],
        ["tanggal_pesan", [fields.tanggal_pesan.visible && fields.tanggal_pesan.required ? ew.Validators.required(fields.tanggal_pesan.caption) : null, ew.Validators.datetime(0)], fields.tanggal_pesan.isInvalid],
        ["tujuan", [fields.tujuan.visible && fields.tujuan.required ? ew.Validators.required(fields.tujuan.caption) : null], fields.tujuan.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fANTRIAN_PENDAFTARANedit,
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
    fANTRIAN_PENDAFTARANedit.validate = function () {
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
    fANTRIAN_PENDAFTARANedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fANTRIAN_PENDAFTARANedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fANTRIAN_PENDAFTARANedit");
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
<form name="fANTRIAN_PENDAFTARANedit" id="fANTRIAN_PENDAFTARANedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="ANTRIAN_PENDAFTARAN">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->Id->Visible) { // Id ?>
    <div id="r_Id" class="form-group row">
        <label id="elh_ANTRIAN_PENDAFTARAN_Id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Id->caption() ?><?= $Page->Id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Id->cellAttributes() ?>>
<span id="el_ANTRIAN_PENDAFTARAN_Id">
<span<?= $Page->Id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->Id->getDisplayValue($Page->Id->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="ANTRIAN_PENDAFTARAN" data-field="x_Id" data-hidden="1" name="x_Id" id="x_Id" value="<?= HtmlEncode($Page->Id->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->no_urut->Visible) { // no_urut ?>
    <div id="r_no_urut" class="form-group row">
        <label id="elh_ANTRIAN_PENDAFTARAN_no_urut" for="x_no_urut" class="<?= $Page->LeftColumnClass ?>"><?= $Page->no_urut->caption() ?><?= $Page->no_urut->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->no_urut->cellAttributes() ?>>
<span id="el_ANTRIAN_PENDAFTARAN_no_urut">
<input type="<?= $Page->no_urut->getInputTextType() ?>" data-table="ANTRIAN_PENDAFTARAN" data-field="x_no_urut" name="x_no_urut" id="x_no_urut" size="30" placeholder="<?= HtmlEncode($Page->no_urut->getPlaceHolder()) ?>" value="<?= $Page->no_urut->EditValue ?>"<?= $Page->no_urut->editAttributes() ?> aria-describedby="x_no_urut_help">
<?= $Page->no_urut->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->no_urut->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tanggal_panggil->Visible) { // tanggal_panggil ?>
    <div id="r_tanggal_panggil" class="form-group row">
        <label id="elh_ANTRIAN_PENDAFTARAN_tanggal_panggil" for="x_tanggal_panggil" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tanggal_panggil->caption() ?><?= $Page->tanggal_panggil->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tanggal_panggil->cellAttributes() ?>>
<span id="el_ANTRIAN_PENDAFTARAN_tanggal_panggil">
<input type="<?= $Page->tanggal_panggil->getInputTextType() ?>" data-table="ANTRIAN_PENDAFTARAN" data-field="x_tanggal_panggil" name="x_tanggal_panggil" id="x_tanggal_panggil" placeholder="<?= HtmlEncode($Page->tanggal_panggil->getPlaceHolder()) ?>" value="<?= $Page->tanggal_panggil->EditValue ?>"<?= $Page->tanggal_panggil->editAttributes() ?> aria-describedby="x_tanggal_panggil_help">
<?= $Page->tanggal_panggil->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tanggal_panggil->getErrorMessage() ?></div>
<?php if (!$Page->tanggal_panggil->ReadOnly && !$Page->tanggal_panggil->Disabled && !isset($Page->tanggal_panggil->EditAttrs["readonly"]) && !isset($Page->tanggal_panggil->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fANTRIAN_PENDAFTARANedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fANTRIAN_PENDAFTARANedit", "x_tanggal_panggil", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->loket->Visible) { // loket ?>
    <div id="r_loket" class="form-group row">
        <label id="elh_ANTRIAN_PENDAFTARAN_loket" for="x_loket" class="<?= $Page->LeftColumnClass ?>"><?= $Page->loket->caption() ?><?= $Page->loket->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->loket->cellAttributes() ?>>
<span id="el_ANTRIAN_PENDAFTARAN_loket">
<input type="<?= $Page->loket->getInputTextType() ?>" data-table="ANTRIAN_PENDAFTARAN" data-field="x_loket" name="x_loket" id="x_loket" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->loket->getPlaceHolder()) ?>" value="<?= $Page->loket->EditValue ?>"<?= $Page->loket->editAttributes() ?> aria-describedby="x_loket_help">
<?= $Page->loket->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->loket->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->status_panggil->Visible) { // status_panggil ?>
    <div id="r_status_panggil" class="form-group row">
        <label id="elh_ANTRIAN_PENDAFTARAN_status_panggil" for="x_status_panggil" class="<?= $Page->LeftColumnClass ?>"><?= $Page->status_panggil->caption() ?><?= $Page->status_panggil->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->status_panggil->cellAttributes() ?>>
<span id="el_ANTRIAN_PENDAFTARAN_status_panggil">
<input type="<?= $Page->status_panggil->getInputTextType() ?>" data-table="ANTRIAN_PENDAFTARAN" data-field="x_status_panggil" name="x_status_panggil" id="x_status_panggil" size="30" placeholder="<?= HtmlEncode($Page->status_panggil->getPlaceHolder()) ?>" value="<?= $Page->status_panggil->EditValue ?>"<?= $Page->status_panggil->editAttributes() ?> aria-describedby="x_status_panggil_help">
<?= $Page->status_panggil->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->status_panggil->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->kdpoli->Visible) { // kdpoli ?>
    <div id="r_kdpoli" class="form-group row">
        <label id="elh_ANTRIAN_PENDAFTARAN_kdpoli" for="x_kdpoli" class="<?= $Page->LeftColumnClass ?>"><?= $Page->kdpoli->caption() ?><?= $Page->kdpoli->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->kdpoli->cellAttributes() ?>>
<span id="el_ANTRIAN_PENDAFTARAN_kdpoli">
<input type="<?= $Page->kdpoli->getInputTextType() ?>" data-table="ANTRIAN_PENDAFTARAN" data-field="x_kdpoli" name="x_kdpoli" id="x_kdpoli" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->kdpoli->getPlaceHolder()) ?>" value="<?= $Page->kdpoli->EditValue ?>"<?= $Page->kdpoli->editAttributes() ?> aria-describedby="x_kdpoli_help">
<?= $Page->kdpoli->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->kdpoli->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tanggal_pesan->Visible) { // tanggal_pesan ?>
    <div id="r_tanggal_pesan" class="form-group row">
        <label id="elh_ANTRIAN_PENDAFTARAN_tanggal_pesan" for="x_tanggal_pesan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tanggal_pesan->caption() ?><?= $Page->tanggal_pesan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tanggal_pesan->cellAttributes() ?>>
<span id="el_ANTRIAN_PENDAFTARAN_tanggal_pesan">
<input type="<?= $Page->tanggal_pesan->getInputTextType() ?>" data-table="ANTRIAN_PENDAFTARAN" data-field="x_tanggal_pesan" name="x_tanggal_pesan" id="x_tanggal_pesan" placeholder="<?= HtmlEncode($Page->tanggal_pesan->getPlaceHolder()) ?>" value="<?= $Page->tanggal_pesan->EditValue ?>"<?= $Page->tanggal_pesan->editAttributes() ?> aria-describedby="x_tanggal_pesan_help">
<?= $Page->tanggal_pesan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tanggal_pesan->getErrorMessage() ?></div>
<?php if (!$Page->tanggal_pesan->ReadOnly && !$Page->tanggal_pesan->Disabled && !isset($Page->tanggal_pesan->EditAttrs["readonly"]) && !isset($Page->tanggal_pesan->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fANTRIAN_PENDAFTARANedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fANTRIAN_PENDAFTARANedit", "x_tanggal_pesan", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tujuan->Visible) { // tujuan ?>
    <div id="r_tujuan" class="form-group row">
        <label id="elh_ANTRIAN_PENDAFTARAN_tujuan" for="x_tujuan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tujuan->caption() ?><?= $Page->tujuan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tujuan->cellAttributes() ?>>
<span id="el_ANTRIAN_PENDAFTARAN_tujuan">
<input type="<?= $Page->tujuan->getInputTextType() ?>" data-table="ANTRIAN_PENDAFTARAN" data-field="x_tujuan" name="x_tujuan" id="x_tujuan" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->tujuan->getPlaceHolder()) ?>" value="<?= $Page->tujuan->EditValue ?>"<?= $Page->tujuan->editAttributes() ?> aria-describedby="x_tujuan_help">
<?= $Page->tujuan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tujuan->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<span id="el_ANTRIAN_PENDAFTARAN_newapp">
<input type="hidden" data-table="ANTRIAN_PENDAFTARAN" data-field="x_newapp" data-hidden="1" name="x_newapp" id="x_newapp" value="<?= HtmlEncode($Page->newapp->CurrentValue) ?>">
</span>
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
    ew.addEventHandlers("ANTRIAN_PENDAFTARAN");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
