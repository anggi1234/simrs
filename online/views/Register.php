<?php

namespace PHPMaker2021\Online;

// Page object
$Register = &$Page;
?>
<script>
var currentForm, currentPageID;
var fregister;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "register";
    fregister = currentForm = new ew.Form("fregister", "register");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "ANTRIAN_LOGIN")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.ANTRIAN_LOGIN)
        ew.vars.tables.ANTRIAN_LOGIN = currentTable;
    fregister.addFields([
        ["FOTO", [fields.FOTO.visible && fields.FOTO.required ? ew.Validators.fileRequired(fields.FOTO.caption) : null], fields.FOTO.isInvalid],
        ["NOMR", [fields.NOMR.visible && fields.NOMR.required ? ew.Validators.required(fields.NOMR.caption) : null], fields.NOMR.isInvalid],
        ["NO_BPJS", [fields.NO_BPJS.visible && fields.NO_BPJS.required ? ew.Validators.required(fields.NO_BPJS.caption) : null], fields.NO_BPJS.isInvalid],
        ["NAMA", [fields.NAMA.visible && fields.NAMA.required ? ew.Validators.required(fields.NAMA.caption) : null], fields.NAMA.isInvalid],
        ["TEMPAT_LAHIR", [fields.TEMPAT_LAHIR.visible && fields.TEMPAT_LAHIR.required ? ew.Validators.required(fields.TEMPAT_LAHIR.caption) : null], fields.TEMPAT_LAHIR.isInvalid],
        ["TANGGAL_LAHIR", [fields.TANGGAL_LAHIR.visible && fields.TANGGAL_LAHIR.required ? ew.Validators.required(fields.TANGGAL_LAHIR.caption) : null, ew.Validators.datetime(0)], fields.TANGGAL_LAHIR.isInvalid],
        ["ALAMAT", [fields.ALAMAT.visible && fields.ALAMAT.required ? ew.Validators.required(fields.ALAMAT.caption) : null], fields.ALAMAT.isInvalid],
        ["_EMAIL", [fields._EMAIL.visible && fields._EMAIL.required ? ew.Validators.required(fields._EMAIL.caption) : null], fields._EMAIL.isInvalid],
        ["NO_HP", [fields.NO_HP.visible && fields.NO_HP.required ? ew.Validators.required(fields.NO_HP.caption) : null, ew.Validators.username(fields.NO_HP.raw)], fields.NO_HP.isInvalid],
        ["c__PASSWORD", [ew.Validators.required(ew.language.phrase("ConfirmPassword")), ew.Validators.mismatchPassword], fields._PASSWORD.isInvalid],
        ["_PASSWORD", [fields._PASSWORD.visible && fields._PASSWORD.required ? ew.Validators.required(fields._PASSWORD.caption) : null, ew.Validators.password(fields._PASSWORD.raw)], fields._PASSWORD.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fregister,
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
    fregister.validate = function () {
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
        return true;
    }

    // Form_CustomValidate
    fregister.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fregister.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fregister");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your client script here, no need to add script tags.
});
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fregister" id="fregister" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="t" value="ANTRIAN_LOGIN">
<input type="hidden" name="action" id="action" value="insert">
<div class="ew-register-div"><!-- page* -->
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
loadjs.ready(["fregister", "datetimepicker"], function() {
    ew.createDateTimePicker("fregister", "x_TANGGAL_LAHIR", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
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
<?php if ($Page->_PASSWORD->Visible) { // PASSWORD ?>
    <div id="r__PASSWORD" class="form-group row">
        <label id="elh_ANTRIAN_LOGIN__PASSWORD" for="x__PASSWORD" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_PASSWORD->caption() ?><?= $Page->_PASSWORD->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->_PASSWORD->cellAttributes() ?>>
<span id="el_ANTRIAN_LOGIN__PASSWORD">
<div class="input-group">
    <input type="password" name="x__PASSWORD" id="x__PASSWORD" autocomplete="new-password" data-field="x__PASSWORD" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->_PASSWORD->getPlaceHolder()) ?>"<?= $Page->_PASSWORD->editAttributes() ?> aria-describedby="x__PASSWORD_help">
    <div class="input-group-append"><button type="button" class="btn btn-default ew-toggle-password rounded-right" onclick="ew.togglePassword(event);"><i class="fas fa-eye"></i></button></div>
</div>
<?= $Page->_PASSWORD->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_PASSWORD->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_PASSWORD->Visible) { // PASSWORD ?>
    <div id="r_c__PASSWORD" class="form-group row">
        <label id="elh_c_ANTRIAN_LOGIN__PASSWORD" for="c__PASSWORD" class="<?= $Page->LeftColumnClass ?>"><?= $Language->phrase("Confirm") ?> <?= $Page->_PASSWORD->caption() ?><?= $Page->_PASSWORD->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->_PASSWORD->cellAttributes() ?>>
<span id="el_c_ANTRIAN_LOGIN__PASSWORD">
<div class="input-group">
    <input type="password" name="c__PASSWORD" id="c__PASSWORD" autocomplete="new-password" data-field="x__PASSWORD" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->_PASSWORD->getPlaceHolder()) ?>"<?= $Page->_PASSWORD->editAttributes() ?> aria-describedby="x__PASSWORD_help">
    <div class="input-group-append"><button type="button" class="btn btn-default ew-toggle-password rounded-right" onclick="ew.togglePassword(event);"><i class="fas fa-eye"></i></button></div>
</div>
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
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("RegisterBtn") ?></button>
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
    // Write your startup script here, no need to add script tags.
});
</script>
