<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

// Page object
$AntrianPendaftaranDisabilitasAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fANTRIAN_PENDAFTARAN_DISABILITASadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fANTRIAN_PENDAFTARAN_DISABILITASadd = currentForm = new ew.Form("fANTRIAN_PENDAFTARAN_DISABILITASadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "ANTRIAN_PENDAFTARAN_DISABILITAS")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.ANTRIAN_PENDAFTARAN_DISABILITAS)
        ew.vars.tables.ANTRIAN_PENDAFTARAN_DISABILITAS = currentTable;
    fANTRIAN_PENDAFTARAN_DISABILITASadd.addFields([
        ["no_urut", [fields.no_urut.visible && fields.no_urut.required ? ew.Validators.required(fields.no_urut.caption) : null, ew.Validators.integer], fields.no_urut.isInvalid],
        ["tanggal_daftar", [fields.tanggal_daftar.visible && fields.tanggal_daftar.required ? ew.Validators.required(fields.tanggal_daftar.caption) : null, ew.Validators.datetime(0)], fields.tanggal_daftar.isInvalid],
        ["tanggal_panggil", [fields.tanggal_panggil.visible && fields.tanggal_panggil.required ? ew.Validators.required(fields.tanggal_panggil.caption) : null, ew.Validators.datetime(0)], fields.tanggal_panggil.isInvalid],
        ["loket", [fields.loket.visible && fields.loket.required ? ew.Validators.required(fields.loket.caption) : null], fields.loket.isInvalid],
        ["status_panggil", [fields.status_panggil.visible && fields.status_panggil.required ? ew.Validators.required(fields.status_panggil.caption) : null, ew.Validators.integer], fields.status_panggil.isInvalid],
        ["user", [fields.user.visible && fields.user.required ? ew.Validators.required(fields.user.caption) : null, ew.Validators.integer], fields.user.isInvalid],
        ["newapp", [fields.newapp.visible && fields.newapp.required ? ew.Validators.required(fields.newapp.caption) : null, ew.Validators.integer], fields.newapp.isInvalid],
        ["kdpoli", [fields.kdpoli.visible && fields.kdpoli.required ? ew.Validators.required(fields.kdpoli.caption) : null], fields.kdpoli.isInvalid],
        ["tanggal_pesan", [fields.tanggal_pesan.visible && fields.tanggal_pesan.required ? ew.Validators.required(fields.tanggal_pesan.caption) : null, ew.Validators.datetime(0)], fields.tanggal_pesan.isInvalid],
        ["tujuan", [fields.tujuan.visible && fields.tujuan.required ? ew.Validators.required(fields.tujuan.caption) : null], fields.tujuan.isInvalid],
        ["disabilitas", [fields.disabilitas.visible && fields.disabilitas.required ? ew.Validators.required(fields.disabilitas.caption) : null, ew.Validators.integer], fields.disabilitas.isInvalid],
        ["nama", [fields.nama.visible && fields.nama.required ? ew.Validators.required(fields.nama.caption) : null], fields.nama.isInvalid],
        ["no_bpjs", [fields.no_bpjs.visible && fields.no_bpjs.required ? ew.Validators.required(fields.no_bpjs.caption) : null, ew.Validators.integer], fields.no_bpjs.isInvalid],
        ["nomr", [fields.nomr.visible && fields.nomr.required ? ew.Validators.required(fields.nomr.caption) : null, ew.Validators.integer], fields.nomr.isInvalid],
        ["tempat_lahir", [fields.tempat_lahir.visible && fields.tempat_lahir.required ? ew.Validators.required(fields.tempat_lahir.caption) : null], fields.tempat_lahir.isInvalid],
        ["tanggal_lahir", [fields.tanggal_lahir.visible && fields.tanggal_lahir.required ? ew.Validators.required(fields.tanggal_lahir.caption) : null, ew.Validators.datetime(0)], fields.tanggal_lahir.isInvalid],
        ["jk", [fields.jk.visible && fields.jk.required ? ew.Validators.required(fields.jk.caption) : null, ew.Validators.integer], fields.jk.isInvalid],
        ["alamat", [fields.alamat.visible && fields.alamat.required ? ew.Validators.required(fields.alamat.caption) : null], fields.alamat.isInvalid],
        ["agama", [fields.agama.visible && fields.agama.required ? ew.Validators.required(fields.agama.caption) : null, ew.Validators.integer], fields.agama.isInvalid],
        ["pekerjaan", [fields.pekerjaan.visible && fields.pekerjaan.required ? ew.Validators.required(fields.pekerjaan.caption) : null, ew.Validators.integer], fields.pekerjaan.isInvalid],
        ["no_telp", [fields.no_telp.visible && fields.no_telp.required ? ew.Validators.required(fields.no_telp.caption) : null, ew.Validators.integer], fields.no_telp.isInvalid],
        ["nama_ibu", [fields.nama_ibu.visible && fields.nama_ibu.required ? ew.Validators.required(fields.nama_ibu.caption) : null], fields.nama_ibu.isInvalid],
        ["nama_ayah", [fields.nama_ayah.visible && fields.nama_ayah.required ? ew.Validators.required(fields.nama_ayah.caption) : null], fields.nama_ayah.isInvalid],
        ["nama_pasangan", [fields.nama_pasangan.visible && fields.nama_pasangan.required ? ew.Validators.required(fields.nama_pasangan.caption) : null], fields.nama_pasangan.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fANTRIAN_PENDAFTARAN_DISABILITASadd,
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
    fANTRIAN_PENDAFTARAN_DISABILITASadd.validate = function () {
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
    fANTRIAN_PENDAFTARAN_DISABILITASadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fANTRIAN_PENDAFTARAN_DISABILITASadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fANTRIAN_PENDAFTARAN_DISABILITASadd");
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
<form name="fANTRIAN_PENDAFTARAN_DISABILITASadd" id="fANTRIAN_PENDAFTARAN_DISABILITASadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="ANTRIAN_PENDAFTARAN_DISABILITAS">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->no_urut->Visible) { // no_urut ?>
    <div id="r_no_urut" class="form-group row">
        <label id="elh_ANTRIAN_PENDAFTARAN_DISABILITAS_no_urut" for="x_no_urut" class="<?= $Page->LeftColumnClass ?>"><?= $Page->no_urut->caption() ?><?= $Page->no_urut->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->no_urut->cellAttributes() ?>>
<span id="el_ANTRIAN_PENDAFTARAN_DISABILITAS_no_urut">
<input type="<?= $Page->no_urut->getInputTextType() ?>" data-table="ANTRIAN_PENDAFTARAN_DISABILITAS" data-field="x_no_urut" name="x_no_urut" id="x_no_urut" size="30" placeholder="<?= HtmlEncode($Page->no_urut->getPlaceHolder()) ?>" value="<?= $Page->no_urut->EditValue ?>"<?= $Page->no_urut->editAttributes() ?> aria-describedby="x_no_urut_help">
<?= $Page->no_urut->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->no_urut->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tanggal_daftar->Visible) { // tanggal_daftar ?>
    <div id="r_tanggal_daftar" class="form-group row">
        <label id="elh_ANTRIAN_PENDAFTARAN_DISABILITAS_tanggal_daftar" for="x_tanggal_daftar" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tanggal_daftar->caption() ?><?= $Page->tanggal_daftar->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tanggal_daftar->cellAttributes() ?>>
<span id="el_ANTRIAN_PENDAFTARAN_DISABILITAS_tanggal_daftar">
<input type="<?= $Page->tanggal_daftar->getInputTextType() ?>" data-table="ANTRIAN_PENDAFTARAN_DISABILITAS" data-field="x_tanggal_daftar" name="x_tanggal_daftar" id="x_tanggal_daftar" placeholder="<?= HtmlEncode($Page->tanggal_daftar->getPlaceHolder()) ?>" value="<?= $Page->tanggal_daftar->EditValue ?>"<?= $Page->tanggal_daftar->editAttributes() ?> aria-describedby="x_tanggal_daftar_help">
<?= $Page->tanggal_daftar->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tanggal_daftar->getErrorMessage() ?></div>
<?php if (!$Page->tanggal_daftar->ReadOnly && !$Page->tanggal_daftar->Disabled && !isset($Page->tanggal_daftar->EditAttrs["readonly"]) && !isset($Page->tanggal_daftar->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fANTRIAN_PENDAFTARAN_DISABILITASadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fANTRIAN_PENDAFTARAN_DISABILITASadd", "x_tanggal_daftar", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tanggal_panggil->Visible) { // tanggal_panggil ?>
    <div id="r_tanggal_panggil" class="form-group row">
        <label id="elh_ANTRIAN_PENDAFTARAN_DISABILITAS_tanggal_panggil" for="x_tanggal_panggil" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tanggal_panggil->caption() ?><?= $Page->tanggal_panggil->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tanggal_panggil->cellAttributes() ?>>
<span id="el_ANTRIAN_PENDAFTARAN_DISABILITAS_tanggal_panggil">
<input type="<?= $Page->tanggal_panggil->getInputTextType() ?>" data-table="ANTRIAN_PENDAFTARAN_DISABILITAS" data-field="x_tanggal_panggil" name="x_tanggal_panggil" id="x_tanggal_panggil" placeholder="<?= HtmlEncode($Page->tanggal_panggil->getPlaceHolder()) ?>" value="<?= $Page->tanggal_panggil->EditValue ?>"<?= $Page->tanggal_panggil->editAttributes() ?> aria-describedby="x_tanggal_panggil_help">
<?= $Page->tanggal_panggil->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tanggal_panggil->getErrorMessage() ?></div>
<?php if (!$Page->tanggal_panggil->ReadOnly && !$Page->tanggal_panggil->Disabled && !isset($Page->tanggal_panggil->EditAttrs["readonly"]) && !isset($Page->tanggal_panggil->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fANTRIAN_PENDAFTARAN_DISABILITASadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fANTRIAN_PENDAFTARAN_DISABILITASadd", "x_tanggal_panggil", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->loket->Visible) { // loket ?>
    <div id="r_loket" class="form-group row">
        <label id="elh_ANTRIAN_PENDAFTARAN_DISABILITAS_loket" for="x_loket" class="<?= $Page->LeftColumnClass ?>"><?= $Page->loket->caption() ?><?= $Page->loket->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->loket->cellAttributes() ?>>
<span id="el_ANTRIAN_PENDAFTARAN_DISABILITAS_loket">
<input type="<?= $Page->loket->getInputTextType() ?>" data-table="ANTRIAN_PENDAFTARAN_DISABILITAS" data-field="x_loket" name="x_loket" id="x_loket" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->loket->getPlaceHolder()) ?>" value="<?= $Page->loket->EditValue ?>"<?= $Page->loket->editAttributes() ?> aria-describedby="x_loket_help">
<?= $Page->loket->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->loket->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->status_panggil->Visible) { // status_panggil ?>
    <div id="r_status_panggil" class="form-group row">
        <label id="elh_ANTRIAN_PENDAFTARAN_DISABILITAS_status_panggil" for="x_status_panggil" class="<?= $Page->LeftColumnClass ?>"><?= $Page->status_panggil->caption() ?><?= $Page->status_panggil->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->status_panggil->cellAttributes() ?>>
<span id="el_ANTRIAN_PENDAFTARAN_DISABILITAS_status_panggil">
<input type="<?= $Page->status_panggil->getInputTextType() ?>" data-table="ANTRIAN_PENDAFTARAN_DISABILITAS" data-field="x_status_panggil" name="x_status_panggil" id="x_status_panggil" size="30" placeholder="<?= HtmlEncode($Page->status_panggil->getPlaceHolder()) ?>" value="<?= $Page->status_panggil->EditValue ?>"<?= $Page->status_panggil->editAttributes() ?> aria-describedby="x_status_panggil_help">
<?= $Page->status_panggil->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->status_panggil->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->user->Visible) { // user ?>
    <div id="r_user" class="form-group row">
        <label id="elh_ANTRIAN_PENDAFTARAN_DISABILITAS_user" for="x_user" class="<?= $Page->LeftColumnClass ?>"><?= $Page->user->caption() ?><?= $Page->user->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->user->cellAttributes() ?>>
<span id="el_ANTRIAN_PENDAFTARAN_DISABILITAS_user">
<input type="<?= $Page->user->getInputTextType() ?>" data-table="ANTRIAN_PENDAFTARAN_DISABILITAS" data-field="x_user" name="x_user" id="x_user" size="30" placeholder="<?= HtmlEncode($Page->user->getPlaceHolder()) ?>" value="<?= $Page->user->EditValue ?>"<?= $Page->user->editAttributes() ?> aria-describedby="x_user_help">
<?= $Page->user->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->user->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->newapp->Visible) { // newapp ?>
    <div id="r_newapp" class="form-group row">
        <label id="elh_ANTRIAN_PENDAFTARAN_DISABILITAS_newapp" for="x_newapp" class="<?= $Page->LeftColumnClass ?>"><?= $Page->newapp->caption() ?><?= $Page->newapp->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->newapp->cellAttributes() ?>>
<span id="el_ANTRIAN_PENDAFTARAN_DISABILITAS_newapp">
<input type="<?= $Page->newapp->getInputTextType() ?>" data-table="ANTRIAN_PENDAFTARAN_DISABILITAS" data-field="x_newapp" name="x_newapp" id="x_newapp" size="30" placeholder="<?= HtmlEncode($Page->newapp->getPlaceHolder()) ?>" value="<?= $Page->newapp->EditValue ?>"<?= $Page->newapp->editAttributes() ?> aria-describedby="x_newapp_help">
<?= $Page->newapp->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->newapp->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->kdpoli->Visible) { // kdpoli ?>
    <div id="r_kdpoli" class="form-group row">
        <label id="elh_ANTRIAN_PENDAFTARAN_DISABILITAS_kdpoli" for="x_kdpoli" class="<?= $Page->LeftColumnClass ?>"><?= $Page->kdpoli->caption() ?><?= $Page->kdpoli->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->kdpoli->cellAttributes() ?>>
<span id="el_ANTRIAN_PENDAFTARAN_DISABILITAS_kdpoli">
<input type="<?= $Page->kdpoli->getInputTextType() ?>" data-table="ANTRIAN_PENDAFTARAN_DISABILITAS" data-field="x_kdpoli" name="x_kdpoli" id="x_kdpoli" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->kdpoli->getPlaceHolder()) ?>" value="<?= $Page->kdpoli->EditValue ?>"<?= $Page->kdpoli->editAttributes() ?> aria-describedby="x_kdpoli_help">
<?= $Page->kdpoli->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->kdpoli->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tanggal_pesan->Visible) { // tanggal_pesan ?>
    <div id="r_tanggal_pesan" class="form-group row">
        <label id="elh_ANTRIAN_PENDAFTARAN_DISABILITAS_tanggal_pesan" for="x_tanggal_pesan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tanggal_pesan->caption() ?><?= $Page->tanggal_pesan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tanggal_pesan->cellAttributes() ?>>
<span id="el_ANTRIAN_PENDAFTARAN_DISABILITAS_tanggal_pesan">
<input type="<?= $Page->tanggal_pesan->getInputTextType() ?>" data-table="ANTRIAN_PENDAFTARAN_DISABILITAS" data-field="x_tanggal_pesan" name="x_tanggal_pesan" id="x_tanggal_pesan" placeholder="<?= HtmlEncode($Page->tanggal_pesan->getPlaceHolder()) ?>" value="<?= $Page->tanggal_pesan->EditValue ?>"<?= $Page->tanggal_pesan->editAttributes() ?> aria-describedby="x_tanggal_pesan_help">
<?= $Page->tanggal_pesan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tanggal_pesan->getErrorMessage() ?></div>
<?php if (!$Page->tanggal_pesan->ReadOnly && !$Page->tanggal_pesan->Disabled && !isset($Page->tanggal_pesan->EditAttrs["readonly"]) && !isset($Page->tanggal_pesan->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fANTRIAN_PENDAFTARAN_DISABILITASadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fANTRIAN_PENDAFTARAN_DISABILITASadd", "x_tanggal_pesan", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tujuan->Visible) { // tujuan ?>
    <div id="r_tujuan" class="form-group row">
        <label id="elh_ANTRIAN_PENDAFTARAN_DISABILITAS_tujuan" for="x_tujuan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tujuan->caption() ?><?= $Page->tujuan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tujuan->cellAttributes() ?>>
<span id="el_ANTRIAN_PENDAFTARAN_DISABILITAS_tujuan">
<input type="<?= $Page->tujuan->getInputTextType() ?>" data-table="ANTRIAN_PENDAFTARAN_DISABILITAS" data-field="x_tujuan" name="x_tujuan" id="x_tujuan" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->tujuan->getPlaceHolder()) ?>" value="<?= $Page->tujuan->EditValue ?>"<?= $Page->tujuan->editAttributes() ?> aria-describedby="x_tujuan_help">
<?= $Page->tujuan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tujuan->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->disabilitas->Visible) { // disabilitas ?>
    <div id="r_disabilitas" class="form-group row">
        <label id="elh_ANTRIAN_PENDAFTARAN_DISABILITAS_disabilitas" for="x_disabilitas" class="<?= $Page->LeftColumnClass ?>"><?= $Page->disabilitas->caption() ?><?= $Page->disabilitas->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->disabilitas->cellAttributes() ?>>
<span id="el_ANTRIAN_PENDAFTARAN_DISABILITAS_disabilitas">
<input type="<?= $Page->disabilitas->getInputTextType() ?>" data-table="ANTRIAN_PENDAFTARAN_DISABILITAS" data-field="x_disabilitas" name="x_disabilitas" id="x_disabilitas" size="30" placeholder="<?= HtmlEncode($Page->disabilitas->getPlaceHolder()) ?>" value="<?= $Page->disabilitas->EditValue ?>"<?= $Page->disabilitas->editAttributes() ?> aria-describedby="x_disabilitas_help">
<?= $Page->disabilitas->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->disabilitas->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
    <div id="r_nama" class="form-group row">
        <label id="elh_ANTRIAN_PENDAFTARAN_DISABILITAS_nama" for="x_nama" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nama->caption() ?><?= $Page->nama->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->nama->cellAttributes() ?>>
<span id="el_ANTRIAN_PENDAFTARAN_DISABILITAS_nama">
<input type="<?= $Page->nama->getInputTextType() ?>" data-table="ANTRIAN_PENDAFTARAN_DISABILITAS" data-field="x_nama" name="x_nama" id="x_nama" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->nama->getPlaceHolder()) ?>" value="<?= $Page->nama->EditValue ?>"<?= $Page->nama->editAttributes() ?> aria-describedby="x_nama_help">
<?= $Page->nama->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nama->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->no_bpjs->Visible) { // no_bpjs ?>
    <div id="r_no_bpjs" class="form-group row">
        <label id="elh_ANTRIAN_PENDAFTARAN_DISABILITAS_no_bpjs" for="x_no_bpjs" class="<?= $Page->LeftColumnClass ?>"><?= $Page->no_bpjs->caption() ?><?= $Page->no_bpjs->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->no_bpjs->cellAttributes() ?>>
<span id="el_ANTRIAN_PENDAFTARAN_DISABILITAS_no_bpjs">
<input type="<?= $Page->no_bpjs->getInputTextType() ?>" data-table="ANTRIAN_PENDAFTARAN_DISABILITAS" data-field="x_no_bpjs" name="x_no_bpjs" id="x_no_bpjs" size="30" placeholder="<?= HtmlEncode($Page->no_bpjs->getPlaceHolder()) ?>" value="<?= $Page->no_bpjs->EditValue ?>"<?= $Page->no_bpjs->editAttributes() ?> aria-describedby="x_no_bpjs_help">
<?= $Page->no_bpjs->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->no_bpjs->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nomr->Visible) { // nomr ?>
    <div id="r_nomr" class="form-group row">
        <label id="elh_ANTRIAN_PENDAFTARAN_DISABILITAS_nomr" for="x_nomr" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nomr->caption() ?><?= $Page->nomr->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->nomr->cellAttributes() ?>>
<span id="el_ANTRIAN_PENDAFTARAN_DISABILITAS_nomr">
<input type="<?= $Page->nomr->getInputTextType() ?>" data-table="ANTRIAN_PENDAFTARAN_DISABILITAS" data-field="x_nomr" name="x_nomr" id="x_nomr" size="30" placeholder="<?= HtmlEncode($Page->nomr->getPlaceHolder()) ?>" value="<?= $Page->nomr->EditValue ?>"<?= $Page->nomr->editAttributes() ?> aria-describedby="x_nomr_help">
<?= $Page->nomr->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nomr->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tempat_lahir->Visible) { // tempat_lahir ?>
    <div id="r_tempat_lahir" class="form-group row">
        <label id="elh_ANTRIAN_PENDAFTARAN_DISABILITAS_tempat_lahir" for="x_tempat_lahir" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tempat_lahir->caption() ?><?= $Page->tempat_lahir->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tempat_lahir->cellAttributes() ?>>
<span id="el_ANTRIAN_PENDAFTARAN_DISABILITAS_tempat_lahir">
<input type="<?= $Page->tempat_lahir->getInputTextType() ?>" data-table="ANTRIAN_PENDAFTARAN_DISABILITAS" data-field="x_tempat_lahir" name="x_tempat_lahir" id="x_tempat_lahir" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->tempat_lahir->getPlaceHolder()) ?>" value="<?= $Page->tempat_lahir->EditValue ?>"<?= $Page->tempat_lahir->editAttributes() ?> aria-describedby="x_tempat_lahir_help">
<?= $Page->tempat_lahir->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tempat_lahir->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tanggal_lahir->Visible) { // tanggal_lahir ?>
    <div id="r_tanggal_lahir" class="form-group row">
        <label id="elh_ANTRIAN_PENDAFTARAN_DISABILITAS_tanggal_lahir" for="x_tanggal_lahir" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tanggal_lahir->caption() ?><?= $Page->tanggal_lahir->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tanggal_lahir->cellAttributes() ?>>
<span id="el_ANTRIAN_PENDAFTARAN_DISABILITAS_tanggal_lahir">
<input type="<?= $Page->tanggal_lahir->getInputTextType() ?>" data-table="ANTRIAN_PENDAFTARAN_DISABILITAS" data-field="x_tanggal_lahir" name="x_tanggal_lahir" id="x_tanggal_lahir" placeholder="<?= HtmlEncode($Page->tanggal_lahir->getPlaceHolder()) ?>" value="<?= $Page->tanggal_lahir->EditValue ?>"<?= $Page->tanggal_lahir->editAttributes() ?> aria-describedby="x_tanggal_lahir_help">
<?= $Page->tanggal_lahir->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tanggal_lahir->getErrorMessage() ?></div>
<?php if (!$Page->tanggal_lahir->ReadOnly && !$Page->tanggal_lahir->Disabled && !isset($Page->tanggal_lahir->EditAttrs["readonly"]) && !isset($Page->tanggal_lahir->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fANTRIAN_PENDAFTARAN_DISABILITASadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fANTRIAN_PENDAFTARAN_DISABILITASadd", "x_tanggal_lahir", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->jk->Visible) { // jk ?>
    <div id="r_jk" class="form-group row">
        <label id="elh_ANTRIAN_PENDAFTARAN_DISABILITAS_jk" for="x_jk" class="<?= $Page->LeftColumnClass ?>"><?= $Page->jk->caption() ?><?= $Page->jk->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->jk->cellAttributes() ?>>
<span id="el_ANTRIAN_PENDAFTARAN_DISABILITAS_jk">
<input type="<?= $Page->jk->getInputTextType() ?>" data-table="ANTRIAN_PENDAFTARAN_DISABILITAS" data-field="x_jk" name="x_jk" id="x_jk" size="30" placeholder="<?= HtmlEncode($Page->jk->getPlaceHolder()) ?>" value="<?= $Page->jk->EditValue ?>"<?= $Page->jk->editAttributes() ?> aria-describedby="x_jk_help">
<?= $Page->jk->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->jk->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->alamat->Visible) { // alamat ?>
    <div id="r_alamat" class="form-group row">
        <label id="elh_ANTRIAN_PENDAFTARAN_DISABILITAS_alamat" for="x_alamat" class="<?= $Page->LeftColumnClass ?>"><?= $Page->alamat->caption() ?><?= $Page->alamat->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->alamat->cellAttributes() ?>>
<span id="el_ANTRIAN_PENDAFTARAN_DISABILITAS_alamat">
<input type="<?= $Page->alamat->getInputTextType() ?>" data-table="ANTRIAN_PENDAFTARAN_DISABILITAS" data-field="x_alamat" name="x_alamat" id="x_alamat" size="30" maxlength="150" placeholder="<?= HtmlEncode($Page->alamat->getPlaceHolder()) ?>" value="<?= $Page->alamat->EditValue ?>"<?= $Page->alamat->editAttributes() ?> aria-describedby="x_alamat_help">
<?= $Page->alamat->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->alamat->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->agama->Visible) { // agama ?>
    <div id="r_agama" class="form-group row">
        <label id="elh_ANTRIAN_PENDAFTARAN_DISABILITAS_agama" for="x_agama" class="<?= $Page->LeftColumnClass ?>"><?= $Page->agama->caption() ?><?= $Page->agama->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->agama->cellAttributes() ?>>
<span id="el_ANTRIAN_PENDAFTARAN_DISABILITAS_agama">
<input type="<?= $Page->agama->getInputTextType() ?>" data-table="ANTRIAN_PENDAFTARAN_DISABILITAS" data-field="x_agama" name="x_agama" id="x_agama" size="30" placeholder="<?= HtmlEncode($Page->agama->getPlaceHolder()) ?>" value="<?= $Page->agama->EditValue ?>"<?= $Page->agama->editAttributes() ?> aria-describedby="x_agama_help">
<?= $Page->agama->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->agama->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->pekerjaan->Visible) { // pekerjaan ?>
    <div id="r_pekerjaan" class="form-group row">
        <label id="elh_ANTRIAN_PENDAFTARAN_DISABILITAS_pekerjaan" for="x_pekerjaan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->pekerjaan->caption() ?><?= $Page->pekerjaan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->pekerjaan->cellAttributes() ?>>
<span id="el_ANTRIAN_PENDAFTARAN_DISABILITAS_pekerjaan">
<input type="<?= $Page->pekerjaan->getInputTextType() ?>" data-table="ANTRIAN_PENDAFTARAN_DISABILITAS" data-field="x_pekerjaan" name="x_pekerjaan" id="x_pekerjaan" size="30" placeholder="<?= HtmlEncode($Page->pekerjaan->getPlaceHolder()) ?>" value="<?= $Page->pekerjaan->EditValue ?>"<?= $Page->pekerjaan->editAttributes() ?> aria-describedby="x_pekerjaan_help">
<?= $Page->pekerjaan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->pekerjaan->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->no_telp->Visible) { // no_telp ?>
    <div id="r_no_telp" class="form-group row">
        <label id="elh_ANTRIAN_PENDAFTARAN_DISABILITAS_no_telp" for="x_no_telp" class="<?= $Page->LeftColumnClass ?>"><?= $Page->no_telp->caption() ?><?= $Page->no_telp->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->no_telp->cellAttributes() ?>>
<span id="el_ANTRIAN_PENDAFTARAN_DISABILITAS_no_telp">
<input type="<?= $Page->no_telp->getInputTextType() ?>" data-table="ANTRIAN_PENDAFTARAN_DISABILITAS" data-field="x_no_telp" name="x_no_telp" id="x_no_telp" size="30" placeholder="<?= HtmlEncode($Page->no_telp->getPlaceHolder()) ?>" value="<?= $Page->no_telp->EditValue ?>"<?= $Page->no_telp->editAttributes() ?> aria-describedby="x_no_telp_help">
<?= $Page->no_telp->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->no_telp->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nama_ibu->Visible) { // nama_ibu ?>
    <div id="r_nama_ibu" class="form-group row">
        <label id="elh_ANTRIAN_PENDAFTARAN_DISABILITAS_nama_ibu" for="x_nama_ibu" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nama_ibu->caption() ?><?= $Page->nama_ibu->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->nama_ibu->cellAttributes() ?>>
<span id="el_ANTRIAN_PENDAFTARAN_DISABILITAS_nama_ibu">
<input type="<?= $Page->nama_ibu->getInputTextType() ?>" data-table="ANTRIAN_PENDAFTARAN_DISABILITAS" data-field="x_nama_ibu" name="x_nama_ibu" id="x_nama_ibu" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->nama_ibu->getPlaceHolder()) ?>" value="<?= $Page->nama_ibu->EditValue ?>"<?= $Page->nama_ibu->editAttributes() ?> aria-describedby="x_nama_ibu_help">
<?= $Page->nama_ibu->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nama_ibu->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nama_ayah->Visible) { // nama_ayah ?>
    <div id="r_nama_ayah" class="form-group row">
        <label id="elh_ANTRIAN_PENDAFTARAN_DISABILITAS_nama_ayah" for="x_nama_ayah" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nama_ayah->caption() ?><?= $Page->nama_ayah->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->nama_ayah->cellAttributes() ?>>
<span id="el_ANTRIAN_PENDAFTARAN_DISABILITAS_nama_ayah">
<input type="<?= $Page->nama_ayah->getInputTextType() ?>" data-table="ANTRIAN_PENDAFTARAN_DISABILITAS" data-field="x_nama_ayah" name="x_nama_ayah" id="x_nama_ayah" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->nama_ayah->getPlaceHolder()) ?>" value="<?= $Page->nama_ayah->EditValue ?>"<?= $Page->nama_ayah->editAttributes() ?> aria-describedby="x_nama_ayah_help">
<?= $Page->nama_ayah->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nama_ayah->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nama_pasangan->Visible) { // nama_pasangan ?>
    <div id="r_nama_pasangan" class="form-group row">
        <label id="elh_ANTRIAN_PENDAFTARAN_DISABILITAS_nama_pasangan" for="x_nama_pasangan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nama_pasangan->caption() ?><?= $Page->nama_pasangan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->nama_pasangan->cellAttributes() ?>>
<span id="el_ANTRIAN_PENDAFTARAN_DISABILITAS_nama_pasangan">
<input type="<?= $Page->nama_pasangan->getInputTextType() ?>" data-table="ANTRIAN_PENDAFTARAN_DISABILITAS" data-field="x_nama_pasangan" name="x_nama_pasangan" id="x_nama_pasangan" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->nama_pasangan->getPlaceHolder()) ?>" value="<?= $Page->nama_pasangan->EditValue ?>"<?= $Page->nama_pasangan->editAttributes() ?> aria-describedby="x_nama_pasangan_help">
<?= $Page->nama_pasangan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nama_pasangan->getErrorMessage() ?></div>
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
    ew.addEventHandlers("ANTRIAN_PENDAFTARAN_DISABILITAS");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
