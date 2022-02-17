<?php

namespace PHPMaker2021\ONLINEBARU;

// Page object
$AntrianLoginAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fANTRIAN_LOGINadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fANTRIAN_LOGINadd = currentForm = new ew.Form("fANTRIAN_LOGINadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "ANTRIAN_LOGIN")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.ANTRIAN_LOGIN)
        ew.vars.tables.ANTRIAN_LOGIN = currentTable;
    fANTRIAN_LOGINadd.addFields([
        ["FOTO", [fields.FOTO.visible && fields.FOTO.required ? ew.Validators.fileRequired(fields.FOTO.caption) : null], fields.FOTO.isInvalid],
        ["NOMR", [fields.NOMR.visible && fields.NOMR.required ? ew.Validators.required(fields.NOMR.caption) : null], fields.NOMR.isInvalid],
        ["NO_BPJS", [fields.NO_BPJS.visible && fields.NO_BPJS.required ? ew.Validators.required(fields.NO_BPJS.caption) : null], fields.NO_BPJS.isInvalid],
        ["NAMA", [fields.NAMA.visible && fields.NAMA.required ? ew.Validators.required(fields.NAMA.caption) : null], fields.NAMA.isInvalid],
        ["TEMPAT_LAHIR", [fields.TEMPAT_LAHIR.visible && fields.TEMPAT_LAHIR.required ? ew.Validators.required(fields.TEMPAT_LAHIR.caption) : null], fields.TEMPAT_LAHIR.isInvalid],
        ["TANGGAL_LAHIR", [fields.TANGGAL_LAHIR.visible && fields.TANGGAL_LAHIR.required ? ew.Validators.required(fields.TANGGAL_LAHIR.caption) : null, ew.Validators.datetime(0)], fields.TANGGAL_LAHIR.isInvalid],
        ["JENIS_KELAMIN", [fields.JENIS_KELAMIN.visible && fields.JENIS_KELAMIN.required ? ew.Validators.required(fields.JENIS_KELAMIN.caption) : null], fields.JENIS_KELAMIN.isInvalid],
        ["AGAMA", [fields.AGAMA.visible && fields.AGAMA.required ? ew.Validators.required(fields.AGAMA.caption) : null], fields.AGAMA.isInvalid],
        ["PEKERJAAN", [fields.PEKERJAAN.visible && fields.PEKERJAAN.required ? ew.Validators.required(fields.PEKERJAAN.caption) : null], fields.PEKERJAAN.isInvalid],
        ["ALAMAT", [fields.ALAMAT.visible && fields.ALAMAT.required ? ew.Validators.required(fields.ALAMAT.caption) : null], fields.ALAMAT.isInvalid],
        ["NO_TELP", [fields.NO_TELP.visible && fields.NO_TELP.required ? ew.Validators.required(fields.NO_TELP.caption) : null], fields.NO_TELP.isInvalid],
        ["NO_HP", [fields.NO_HP.visible && fields.NO_HP.required ? ew.Validators.required(fields.NO_HP.caption) : null], fields.NO_HP.isInvalid],
        ["_EMAIL", [fields._EMAIL.visible && fields._EMAIL.required ? ew.Validators.required(fields._EMAIL.caption) : null], fields._EMAIL.isInvalid],
        ["TANGGAL_REGIS", [fields.TANGGAL_REGIS.visible && fields.TANGGAL_REGIS.required ? ew.Validators.required(fields.TANGGAL_REGIS.caption) : null], fields.TANGGAL_REGIS.isInvalid],
        ["NAMA_IBU", [fields.NAMA_IBU.visible && fields.NAMA_IBU.required ? ew.Validators.required(fields.NAMA_IBU.caption) : null], fields.NAMA_IBU.isInvalid],
        ["NAMA_AYAH", [fields.NAMA_AYAH.visible && fields.NAMA_AYAH.required ? ew.Validators.required(fields.NAMA_AYAH.caption) : null], fields.NAMA_AYAH.isInvalid],
        ["NAMA_PASANGAN", [fields.NAMA_PASANGAN.visible && fields.NAMA_PASANGAN.required ? ew.Validators.required(fields.NAMA_PASANGAN.caption) : null], fields.NAMA_PASANGAN.isInvalid],
        ["_PASSWORD", [fields._PASSWORD.visible && fields._PASSWORD.required ? ew.Validators.required(fields._PASSWORD.caption) : null], fields._PASSWORD.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fANTRIAN_LOGINadd,
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
    fANTRIAN_LOGINadd.validate = function () {
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
    fANTRIAN_LOGINadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fANTRIAN_LOGINadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fANTRIAN_LOGINadd.lists.JENIS_KELAMIN = <?= $Page->JENIS_KELAMIN->toClientList($Page) ?>;
    fANTRIAN_LOGINadd.lists.AGAMA = <?= $Page->AGAMA->toClientList($Page) ?>;
    fANTRIAN_LOGINadd.lists.PEKERJAAN = <?= $Page->PEKERJAAN->toClientList($Page) ?>;
    loadjs.done("fANTRIAN_LOGINadd");
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
<form name="fANTRIAN_LOGINadd" id="fANTRIAN_LOGINadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="ANTRIAN_LOGIN">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->FOTO->Visible) { // FOTO ?>
    <div id="r_FOTO" class="form-group row">
        <label id="elh_ANTRIAN_LOGIN_FOTO" class="<?= $Page->LeftColumnClass ?>"><?= $Page->FOTO->caption() ?><?= $Page->FOTO->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->FOTO->cellAttributes() ?>>
<span id="el_ANTRIAN_LOGIN_FOTO">
<div id="fd_x_FOTO">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Page->FOTO->title() ?>" data-table="ANTRIAN_LOGIN" data-field="x_FOTO" name="x_FOTO" id="x_FOTO" lang="<?= CurrentLanguageID() ?>"<?= $Page->FOTO->editAttributes() ?><?= ($Page->FOTO->ReadOnly || $Page->FOTO->Disabled) ? " disabled" : "" ?> aria-describedby="x_FOTO_help">
        <label class="custom-file-label ew-file-label" for="x_FOTO"><?= $Language->phrase("ChooseFile") ?></label>
    </div>
</div>
<?= $Page->FOTO->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->FOTO->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_FOTO" id= "fn_x_FOTO" value="<?= $Page->FOTO->Upload->FileName ?>">
<input type="hidden" name="fa_x_FOTO" id= "fa_x_FOTO" value="0">
<input type="hidden" name="fs_x_FOTO" id= "fs_x_FOTO" value="50">
<input type="hidden" name="fx_x_FOTO" id= "fx_x_FOTO" value="<?= $Page->FOTO->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_FOTO" id= "fm_x_FOTO" value="<?= $Page->FOTO->UploadMaxFileSize ?>">
</div>
<table id="ft_x_FOTO" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->NOMR->Visible) { // NOMR ?>
    <div id="r_NOMR" class="form-group row">
        <label id="elh_ANTRIAN_LOGIN_NOMR" for="x_NOMR" class="<?= $Page->LeftColumnClass ?>"><?= $Page->NOMR->caption() ?><?= $Page->NOMR->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->NOMR->cellAttributes() ?>>
<span id="el_ANTRIAN_LOGIN_NOMR">
<input type="<?= $Page->NOMR->getInputTextType() ?>" data-table="ANTRIAN_LOGIN" data-field="x_NOMR" name="x_NOMR" id="x_NOMR" size="30" maxlength="25" placeholder="<?= HtmlEncode($Page->NOMR->getPlaceHolder()) ?>" value="<?= $Page->NOMR->EditValue ?>"<?= $Page->NOMR->editAttributes() ?> aria-describedby="x_NOMR_help">
<?= $Page->NOMR->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->NOMR->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->NO_BPJS->Visible) { // NO_BPJS ?>
    <div id="r_NO_BPJS" class="form-group row">
        <label id="elh_ANTRIAN_LOGIN_NO_BPJS" for="x_NO_BPJS" class="<?= $Page->LeftColumnClass ?>"><?= $Page->NO_BPJS->caption() ?><?= $Page->NO_BPJS->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->NO_BPJS->cellAttributes() ?>>
<span id="el_ANTRIAN_LOGIN_NO_BPJS">
<input type="<?= $Page->NO_BPJS->getInputTextType() ?>" data-table="ANTRIAN_LOGIN" data-field="x_NO_BPJS" name="x_NO_BPJS" id="x_NO_BPJS" size="30" maxlength="30" placeholder="<?= HtmlEncode($Page->NO_BPJS->getPlaceHolder()) ?>" value="<?= $Page->NO_BPJS->EditValue ?>"<?= $Page->NO_BPJS->editAttributes() ?> aria-describedby="x_NO_BPJS_help">
<?= $Page->NO_BPJS->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->NO_BPJS->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->NAMA->Visible) { // NAMA ?>
    <div id="r_NAMA" class="form-group row">
        <label id="elh_ANTRIAN_LOGIN_NAMA" for="x_NAMA" class="<?= $Page->LeftColumnClass ?>"><?= $Page->NAMA->caption() ?><?= $Page->NAMA->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->NAMA->cellAttributes() ?>>
<span id="el_ANTRIAN_LOGIN_NAMA">
<input type="<?= $Page->NAMA->getInputTextType() ?>" data-table="ANTRIAN_LOGIN" data-field="x_NAMA" name="x_NAMA" id="x_NAMA" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->NAMA->getPlaceHolder()) ?>" value="<?= $Page->NAMA->EditValue ?>"<?= $Page->NAMA->editAttributes() ?> aria-describedby="x_NAMA_help">
<?= $Page->NAMA->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->NAMA->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->TEMPAT_LAHIR->Visible) { // TEMPAT_LAHIR ?>
    <div id="r_TEMPAT_LAHIR" class="form-group row">
        <label id="elh_ANTRIAN_LOGIN_TEMPAT_LAHIR" for="x_TEMPAT_LAHIR" class="<?= $Page->LeftColumnClass ?>"><?= $Page->TEMPAT_LAHIR->caption() ?><?= $Page->TEMPAT_LAHIR->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->TEMPAT_LAHIR->cellAttributes() ?>>
<span id="el_ANTRIAN_LOGIN_TEMPAT_LAHIR">
<input type="<?= $Page->TEMPAT_LAHIR->getInputTextType() ?>" data-table="ANTRIAN_LOGIN" data-field="x_TEMPAT_LAHIR" name="x_TEMPAT_LAHIR" id="x_TEMPAT_LAHIR" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->TEMPAT_LAHIR->getPlaceHolder()) ?>" value="<?= $Page->TEMPAT_LAHIR->EditValue ?>"<?= $Page->TEMPAT_LAHIR->editAttributes() ?> aria-describedby="x_TEMPAT_LAHIR_help">
<?= $Page->TEMPAT_LAHIR->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->TEMPAT_LAHIR->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->TANGGAL_LAHIR->Visible) { // TANGGAL_LAHIR ?>
    <div id="r_TANGGAL_LAHIR" class="form-group row">
        <label id="elh_ANTRIAN_LOGIN_TANGGAL_LAHIR" for="x_TANGGAL_LAHIR" class="<?= $Page->LeftColumnClass ?>"><?= $Page->TANGGAL_LAHIR->caption() ?><?= $Page->TANGGAL_LAHIR->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->TANGGAL_LAHIR->cellAttributes() ?>>
<span id="el_ANTRIAN_LOGIN_TANGGAL_LAHIR">
<input type="<?= $Page->TANGGAL_LAHIR->getInputTextType() ?>" data-table="ANTRIAN_LOGIN" data-field="x_TANGGAL_LAHIR" name="x_TANGGAL_LAHIR" id="x_TANGGAL_LAHIR" placeholder="<?= HtmlEncode($Page->TANGGAL_LAHIR->getPlaceHolder()) ?>" value="<?= $Page->TANGGAL_LAHIR->EditValue ?>"<?= $Page->TANGGAL_LAHIR->editAttributes() ?> aria-describedby="x_TANGGAL_LAHIR_help">
<?= $Page->TANGGAL_LAHIR->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->TANGGAL_LAHIR->getErrorMessage() ?></div>
<?php if (!$Page->TANGGAL_LAHIR->ReadOnly && !$Page->TANGGAL_LAHIR->Disabled && !isset($Page->TANGGAL_LAHIR->EditAttrs["readonly"]) && !isset($Page->TANGGAL_LAHIR->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fANTRIAN_LOGINadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fANTRIAN_LOGINadd", "x_TANGGAL_LAHIR", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->JENIS_KELAMIN->Visible) { // JENIS_KELAMIN ?>
    <div id="r_JENIS_KELAMIN" class="form-group row">
        <label id="elh_ANTRIAN_LOGIN_JENIS_KELAMIN" for="x_JENIS_KELAMIN" class="<?= $Page->LeftColumnClass ?>"><?= $Page->JENIS_KELAMIN->caption() ?><?= $Page->JENIS_KELAMIN->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->JENIS_KELAMIN->cellAttributes() ?>>
<span id="el_ANTRIAN_LOGIN_JENIS_KELAMIN">
    <select
        id="x_JENIS_KELAMIN"
        name="x_JENIS_KELAMIN"
        class="form-control ew-select<?= $Page->JENIS_KELAMIN->isInvalidClass() ?>"
        data-select2-id="ANTRIAN_LOGIN_x_JENIS_KELAMIN"
        data-table="ANTRIAN_LOGIN"
        data-field="x_JENIS_KELAMIN"
        data-value-separator="<?= $Page->JENIS_KELAMIN->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->JENIS_KELAMIN->getPlaceHolder()) ?>"
        <?= $Page->JENIS_KELAMIN->editAttributes() ?>>
        <?= $Page->JENIS_KELAMIN->selectOptionListHtml("x_JENIS_KELAMIN") ?>
    </select>
    <?= $Page->JENIS_KELAMIN->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->JENIS_KELAMIN->getErrorMessage() ?></div>
<?= $Page->JENIS_KELAMIN->Lookup->getParamTag($Page, "p_x_JENIS_KELAMIN") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='ANTRIAN_LOGIN_x_JENIS_KELAMIN']"),
        options = { name: "x_JENIS_KELAMIN", selectId: "ANTRIAN_LOGIN_x_JENIS_KELAMIN", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.ANTRIAN_LOGIN.fields.JENIS_KELAMIN.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->AGAMA->Visible) { // AGAMA ?>
    <div id="r_AGAMA" class="form-group row">
        <label id="elh_ANTRIAN_LOGIN_AGAMA" for="x_AGAMA" class="<?= $Page->LeftColumnClass ?>"><?= $Page->AGAMA->caption() ?><?= $Page->AGAMA->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->AGAMA->cellAttributes() ?>>
<span id="el_ANTRIAN_LOGIN_AGAMA">
    <select
        id="x_AGAMA"
        name="x_AGAMA"
        class="form-control ew-select<?= $Page->AGAMA->isInvalidClass() ?>"
        data-select2-id="ANTRIAN_LOGIN_x_AGAMA"
        data-table="ANTRIAN_LOGIN"
        data-field="x_AGAMA"
        data-value-separator="<?= $Page->AGAMA->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->AGAMA->getPlaceHolder()) ?>"
        <?= $Page->AGAMA->editAttributes() ?>>
        <?= $Page->AGAMA->selectOptionListHtml("x_AGAMA") ?>
    </select>
    <?= $Page->AGAMA->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->AGAMA->getErrorMessage() ?></div>
<?= $Page->AGAMA->Lookup->getParamTag($Page, "p_x_AGAMA") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='ANTRIAN_LOGIN_x_AGAMA']"),
        options = { name: "x_AGAMA", selectId: "ANTRIAN_LOGIN_x_AGAMA", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.ANTRIAN_LOGIN.fields.AGAMA.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->PEKERJAAN->Visible) { // PEKERJAAN ?>
    <div id="r_PEKERJAAN" class="form-group row">
        <label id="elh_ANTRIAN_LOGIN_PEKERJAAN" for="x_PEKERJAAN" class="<?= $Page->LeftColumnClass ?>"><?= $Page->PEKERJAAN->caption() ?><?= $Page->PEKERJAAN->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PEKERJAAN->cellAttributes() ?>>
<span id="el_ANTRIAN_LOGIN_PEKERJAAN">
    <select
        id="x_PEKERJAAN"
        name="x_PEKERJAAN"
        class="form-control ew-select<?= $Page->PEKERJAAN->isInvalidClass() ?>"
        data-select2-id="ANTRIAN_LOGIN_x_PEKERJAAN"
        data-table="ANTRIAN_LOGIN"
        data-field="x_PEKERJAAN"
        data-value-separator="<?= $Page->PEKERJAAN->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->PEKERJAAN->getPlaceHolder()) ?>"
        <?= $Page->PEKERJAAN->editAttributes() ?>>
        <?= $Page->PEKERJAAN->selectOptionListHtml("x_PEKERJAAN") ?>
    </select>
    <?= $Page->PEKERJAAN->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->PEKERJAAN->getErrorMessage() ?></div>
<?= $Page->PEKERJAAN->Lookup->getParamTag($Page, "p_x_PEKERJAAN") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='ANTRIAN_LOGIN_x_PEKERJAAN']"),
        options = { name: "x_PEKERJAAN", selectId: "ANTRIAN_LOGIN_x_PEKERJAAN", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.ANTRIAN_LOGIN.fields.PEKERJAAN.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ALAMAT->Visible) { // ALAMAT ?>
    <div id="r_ALAMAT" class="form-group row">
        <label id="elh_ANTRIAN_LOGIN_ALAMAT" for="x_ALAMAT" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ALAMAT->caption() ?><?= $Page->ALAMAT->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ALAMAT->cellAttributes() ?>>
<span id="el_ANTRIAN_LOGIN_ALAMAT">
<textarea data-table="ANTRIAN_LOGIN" data-field="x_ALAMAT" name="x_ALAMAT" id="x_ALAMAT" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->ALAMAT->getPlaceHolder()) ?>"<?= $Page->ALAMAT->editAttributes() ?> aria-describedby="x_ALAMAT_help"><?= $Page->ALAMAT->EditValue ?></textarea>
<?= $Page->ALAMAT->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ALAMAT->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->NO_TELP->Visible) { // NO_TELP ?>
    <div id="r_NO_TELP" class="form-group row">
        <label id="elh_ANTRIAN_LOGIN_NO_TELP" for="x_NO_TELP" class="<?= $Page->LeftColumnClass ?>"><?= $Page->NO_TELP->caption() ?><?= $Page->NO_TELP->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->NO_TELP->cellAttributes() ?>>
<span id="el_ANTRIAN_LOGIN_NO_TELP">
<input type="<?= $Page->NO_TELP->getInputTextType() ?>" data-table="ANTRIAN_LOGIN" data-field="x_NO_TELP" name="x_NO_TELP" id="x_NO_TELP" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->NO_TELP->getPlaceHolder()) ?>" value="<?= $Page->NO_TELP->EditValue ?>"<?= $Page->NO_TELP->editAttributes() ?> aria-describedby="x_NO_TELP_help">
<?= $Page->NO_TELP->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->NO_TELP->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->NO_HP->Visible) { // NO_HP ?>
    <div id="r_NO_HP" class="form-group row">
        <label id="elh_ANTRIAN_LOGIN_NO_HP" for="x_NO_HP" class="<?= $Page->LeftColumnClass ?>"><?= $Page->NO_HP->caption() ?><?= $Page->NO_HP->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->NO_HP->cellAttributes() ?>>
<span id="el_ANTRIAN_LOGIN_NO_HP">
<input type="<?= $Page->NO_HP->getInputTextType() ?>" data-table="ANTRIAN_LOGIN" data-field="x_NO_HP" name="x_NO_HP" id="x_NO_HP" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->NO_HP->getPlaceHolder()) ?>" value="<?= $Page->NO_HP->EditValue ?>"<?= $Page->NO_HP->editAttributes() ?> aria-describedby="x_NO_HP_help">
<?= $Page->NO_HP->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->NO_HP->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_EMAIL->Visible) { // EMAIL ?>
    <div id="r__EMAIL" class="form-group row">
        <label id="elh_ANTRIAN_LOGIN__EMAIL" for="x__EMAIL" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_EMAIL->caption() ?><?= $Page->_EMAIL->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->_EMAIL->cellAttributes() ?>>
<span id="el_ANTRIAN_LOGIN__EMAIL">
<input type="<?= $Page->_EMAIL->getInputTextType() ?>" data-table="ANTRIAN_LOGIN" data-field="x__EMAIL" name="x__EMAIL" id="x__EMAIL" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->_EMAIL->getPlaceHolder()) ?>" value="<?= $Page->_EMAIL->EditValue ?>"<?= $Page->_EMAIL->editAttributes() ?> aria-describedby="x__EMAIL_help">
<?= $Page->_EMAIL->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_EMAIL->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->NAMA_IBU->Visible) { // NAMA_IBU ?>
    <div id="r_NAMA_IBU" class="form-group row">
        <label id="elh_ANTRIAN_LOGIN_NAMA_IBU" for="x_NAMA_IBU" class="<?= $Page->LeftColumnClass ?>"><?= $Page->NAMA_IBU->caption() ?><?= $Page->NAMA_IBU->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->NAMA_IBU->cellAttributes() ?>>
<span id="el_ANTRIAN_LOGIN_NAMA_IBU">
<input type="<?= $Page->NAMA_IBU->getInputTextType() ?>" data-table="ANTRIAN_LOGIN" data-field="x_NAMA_IBU" name="x_NAMA_IBU" id="x_NAMA_IBU" size="30" maxlength="150" placeholder="<?= HtmlEncode($Page->NAMA_IBU->getPlaceHolder()) ?>" value="<?= $Page->NAMA_IBU->EditValue ?>"<?= $Page->NAMA_IBU->editAttributes() ?> aria-describedby="x_NAMA_IBU_help">
<?= $Page->NAMA_IBU->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->NAMA_IBU->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->NAMA_AYAH->Visible) { // NAMA_AYAH ?>
    <div id="r_NAMA_AYAH" class="form-group row">
        <label id="elh_ANTRIAN_LOGIN_NAMA_AYAH" for="x_NAMA_AYAH" class="<?= $Page->LeftColumnClass ?>"><?= $Page->NAMA_AYAH->caption() ?><?= $Page->NAMA_AYAH->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->NAMA_AYAH->cellAttributes() ?>>
<span id="el_ANTRIAN_LOGIN_NAMA_AYAH">
<input type="<?= $Page->NAMA_AYAH->getInputTextType() ?>" data-table="ANTRIAN_LOGIN" data-field="x_NAMA_AYAH" name="x_NAMA_AYAH" id="x_NAMA_AYAH" size="30" maxlength="150" placeholder="<?= HtmlEncode($Page->NAMA_AYAH->getPlaceHolder()) ?>" value="<?= $Page->NAMA_AYAH->EditValue ?>"<?= $Page->NAMA_AYAH->editAttributes() ?> aria-describedby="x_NAMA_AYAH_help">
<?= $Page->NAMA_AYAH->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->NAMA_AYAH->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->NAMA_PASANGAN->Visible) { // NAMA_PASANGAN ?>
    <div id="r_NAMA_PASANGAN" class="form-group row">
        <label id="elh_ANTRIAN_LOGIN_NAMA_PASANGAN" for="x_NAMA_PASANGAN" class="<?= $Page->LeftColumnClass ?>"><?= $Page->NAMA_PASANGAN->caption() ?><?= $Page->NAMA_PASANGAN->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->NAMA_PASANGAN->cellAttributes() ?>>
<span id="el_ANTRIAN_LOGIN_NAMA_PASANGAN">
<input type="<?= $Page->NAMA_PASANGAN->getInputTextType() ?>" data-table="ANTRIAN_LOGIN" data-field="x_NAMA_PASANGAN" name="x_NAMA_PASANGAN" id="x_NAMA_PASANGAN" size="30" maxlength="150" placeholder="<?= HtmlEncode($Page->NAMA_PASANGAN->getPlaceHolder()) ?>" value="<?= $Page->NAMA_PASANGAN->EditValue ?>"<?= $Page->NAMA_PASANGAN->editAttributes() ?> aria-describedby="x_NAMA_PASANGAN_help">
<?= $Page->NAMA_PASANGAN->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->NAMA_PASANGAN->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_PASSWORD->Visible) { // PASSWORD ?>
    <div id="r__PASSWORD" class="form-group row">
        <label id="elh_ANTRIAN_LOGIN__PASSWORD" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_PASSWORD->caption() ?><?= $Page->_PASSWORD->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->_PASSWORD->cellAttributes() ?>>
<span id="el_ANTRIAN_LOGIN__PASSWORD">
<input type="<?= $Page->_PASSWORD->getInputTextType() ?>" data-table="ANTRIAN_LOGIN" data-field="x__PASSWORD" name="x__PASSWORD" id="x__PASSWORD" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->_PASSWORD->getPlaceHolder()) ?>" value="<?= $Page->_PASSWORD->EditValue ?>"<?= $Page->_PASSWORD->editAttributes() ?> aria-describedby="x__PASSWORD_help">
<?= $Page->_PASSWORD->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_PASSWORD->getErrorMessage() ?></div>
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
    ew.addEventHandlers("ANTRIAN_LOGIN");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
