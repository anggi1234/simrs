<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAJALALTER;

// Page object
$VKunjunganPasienEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fV_KUNJUNGAN_PASIENedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fV_KUNJUNGAN_PASIENedit = currentForm = new ew.Form("fV_KUNJUNGAN_PASIENedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "V_KUNJUNGAN_PASIEN")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.V_KUNJUNGAN_PASIEN)
        ew.vars.tables.V_KUNJUNGAN_PASIEN = currentTable;
    fV_KUNJUNGAN_PASIENedit.addFields([
        ["NO_REGISTRATION", [fields.NO_REGISTRATION.visible && fields.NO_REGISTRATION.required ? ew.Validators.required(fields.NO_REGISTRATION.caption) : null], fields.NO_REGISTRATION.isInvalid],
        ["STATUS_PASIEN_ID", [fields.STATUS_PASIEN_ID.visible && fields.STATUS_PASIEN_ID.required ? ew.Validators.required(fields.STATUS_PASIEN_ID.caption) : null, ew.Validators.integer], fields.STATUS_PASIEN_ID.isInvalid],
        ["GENDER", [fields.GENDER.visible && fields.GENDER.required ? ew.Validators.required(fields.GENDER.caption) : null], fields.GENDER.isInvalid],
        ["IDXDAFTAR", [fields.IDXDAFTAR.visible && fields.IDXDAFTAR.required ? ew.Validators.required(fields.IDXDAFTAR.caption) : null], fields.IDXDAFTAR.isInvalid],
        ["ISRJ", [fields.ISRJ.visible && fields.ISRJ.required ? ew.Validators.required(fields.ISRJ.caption) : null], fields.ISRJ.isInvalid],
        ["SERVED_INAP", [fields.SERVED_INAP.visible && fields.SERVED_INAP.required ? ew.Validators.required(fields.SERVED_INAP.caption) : null, ew.Validators.datetime(0)], fields.SERVED_INAP.isInvalid],
        ["VISIT_ID", [fields.VISIT_ID.visible && fields.VISIT_ID.required ? ew.Validators.required(fields.VISIT_ID.caption) : null], fields.VISIT_ID.isInvalid],
        ["DIANTAR_OLEH", [fields.DIANTAR_OLEH.visible && fields.DIANTAR_OLEH.required ? ew.Validators.required(fields.DIANTAR_OLEH.caption) : null], fields.DIANTAR_OLEH.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fV_KUNJUNGAN_PASIENedit,
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
    fV_KUNJUNGAN_PASIENedit.validate = function () {
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
    fV_KUNJUNGAN_PASIENedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fV_KUNJUNGAN_PASIENedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fV_KUNJUNGAN_PASIENedit");
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
<form name="fV_KUNJUNGAN_PASIENedit" id="fV_KUNJUNGAN_PASIENedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="V_KUNJUNGAN_PASIEN">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->NO_REGISTRATION->Visible) { // NO_REGISTRATION ?>
    <div id="r_NO_REGISTRATION" class="form-group row">
        <label id="elh_V_KUNJUNGAN_PASIEN_NO_REGISTRATION" for="x_NO_REGISTRATION" class="<?= $Page->LeftColumnClass ?>"><?= $Page->NO_REGISTRATION->caption() ?><?= $Page->NO_REGISTRATION->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->NO_REGISTRATION->cellAttributes() ?>>
<span id="el_V_KUNJUNGAN_PASIEN_NO_REGISTRATION">
<input type="<?= $Page->NO_REGISTRATION->getInputTextType() ?>" data-table="V_KUNJUNGAN_PASIEN" data-field="x_NO_REGISTRATION" name="x_NO_REGISTRATION" id="x_NO_REGISTRATION" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->NO_REGISTRATION->getPlaceHolder()) ?>" value="<?= $Page->NO_REGISTRATION->EditValue ?>"<?= $Page->NO_REGISTRATION->editAttributes() ?> aria-describedby="x_NO_REGISTRATION_help">
<?= $Page->NO_REGISTRATION->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->NO_REGISTRATION->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->STATUS_PASIEN_ID->Visible) { // STATUS_PASIEN_ID ?>
    <div id="r_STATUS_PASIEN_ID" class="form-group row">
        <label id="elh_V_KUNJUNGAN_PASIEN_STATUS_PASIEN_ID" for="x_STATUS_PASIEN_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->STATUS_PASIEN_ID->caption() ?><?= $Page->STATUS_PASIEN_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->STATUS_PASIEN_ID->cellAttributes() ?>>
<span id="el_V_KUNJUNGAN_PASIEN_STATUS_PASIEN_ID">
<input type="<?= $Page->STATUS_PASIEN_ID->getInputTextType() ?>" data-table="V_KUNJUNGAN_PASIEN" data-field="x_STATUS_PASIEN_ID" name="x_STATUS_PASIEN_ID" id="x_STATUS_PASIEN_ID" size="30" placeholder="<?= HtmlEncode($Page->STATUS_PASIEN_ID->getPlaceHolder()) ?>" value="<?= $Page->STATUS_PASIEN_ID->EditValue ?>"<?= $Page->STATUS_PASIEN_ID->editAttributes() ?> aria-describedby="x_STATUS_PASIEN_ID_help">
<?= $Page->STATUS_PASIEN_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->STATUS_PASIEN_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->GENDER->Visible) { // GENDER ?>
    <div id="r_GENDER" class="form-group row">
        <label id="elh_V_KUNJUNGAN_PASIEN_GENDER" for="x_GENDER" class="<?= $Page->LeftColumnClass ?>"><?= $Page->GENDER->caption() ?><?= $Page->GENDER->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->GENDER->cellAttributes() ?>>
<span id="el_V_KUNJUNGAN_PASIEN_GENDER">
<input type="<?= $Page->GENDER->getInputTextType() ?>" data-table="V_KUNJUNGAN_PASIEN" data-field="x_GENDER" name="x_GENDER" id="x_GENDER" size="30" maxlength="1" placeholder="<?= HtmlEncode($Page->GENDER->getPlaceHolder()) ?>" value="<?= $Page->GENDER->EditValue ?>"<?= $Page->GENDER->editAttributes() ?> aria-describedby="x_GENDER_help">
<?= $Page->GENDER->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->GENDER->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->IDXDAFTAR->Visible) { // IDXDAFTAR ?>
    <div id="r_IDXDAFTAR" class="form-group row">
        <label id="elh_V_KUNJUNGAN_PASIEN_IDXDAFTAR" class="<?= $Page->LeftColumnClass ?>"><?= $Page->IDXDAFTAR->caption() ?><?= $Page->IDXDAFTAR->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->IDXDAFTAR->cellAttributes() ?>>
<span id="el_V_KUNJUNGAN_PASIEN_IDXDAFTAR">
<span<?= $Page->IDXDAFTAR->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->IDXDAFTAR->getDisplayValue($Page->IDXDAFTAR->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_KUNJUNGAN_PASIEN" data-field="x_IDXDAFTAR" data-hidden="1" name="x_IDXDAFTAR" id="x_IDXDAFTAR" value="<?= HtmlEncode($Page->IDXDAFTAR->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ISRJ->Visible) { // ISRJ ?>
    <div id="r_ISRJ" class="form-group row">
        <label id="elh_V_KUNJUNGAN_PASIEN_ISRJ" for="x_ISRJ" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ISRJ->caption() ?><?= $Page->ISRJ->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ISRJ->cellAttributes() ?>>
<span id="el_V_KUNJUNGAN_PASIEN_ISRJ">
<input type="<?= $Page->ISRJ->getInputTextType() ?>" data-table="V_KUNJUNGAN_PASIEN" data-field="x_ISRJ" name="x_ISRJ" id="x_ISRJ" size="30" maxlength="1" placeholder="<?= HtmlEncode($Page->ISRJ->getPlaceHolder()) ?>" value="<?= $Page->ISRJ->EditValue ?>"<?= $Page->ISRJ->editAttributes() ?> aria-describedby="x_ISRJ_help">
<?= $Page->ISRJ->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ISRJ->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->SERVED_INAP->Visible) { // SERVED_INAP ?>
    <div id="r_SERVED_INAP" class="form-group row">
        <label id="elh_V_KUNJUNGAN_PASIEN_SERVED_INAP" for="x_SERVED_INAP" class="<?= $Page->LeftColumnClass ?>"><?= $Page->SERVED_INAP->caption() ?><?= $Page->SERVED_INAP->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->SERVED_INAP->cellAttributes() ?>>
<span id="el_V_KUNJUNGAN_PASIEN_SERVED_INAP">
<input type="<?= $Page->SERVED_INAP->getInputTextType() ?>" data-table="V_KUNJUNGAN_PASIEN" data-field="x_SERVED_INAP" name="x_SERVED_INAP" id="x_SERVED_INAP" placeholder="<?= HtmlEncode($Page->SERVED_INAP->getPlaceHolder()) ?>" value="<?= $Page->SERVED_INAP->EditValue ?>"<?= $Page->SERVED_INAP->editAttributes() ?> aria-describedby="x_SERVED_INAP_help">
<?= $Page->SERVED_INAP->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->SERVED_INAP->getErrorMessage() ?></div>
<?php if (!$Page->SERVED_INAP->ReadOnly && !$Page->SERVED_INAP->Disabled && !isset($Page->SERVED_INAP->EditAttrs["readonly"]) && !isset($Page->SERVED_INAP->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fV_KUNJUNGAN_PASIENedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fV_KUNJUNGAN_PASIENedit", "x_SERVED_INAP", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->VISIT_ID->Visible) { // VISIT_ID ?>
    <div id="r_VISIT_ID" class="form-group row">
        <label id="elh_V_KUNJUNGAN_PASIEN_VISIT_ID" for="x_VISIT_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->VISIT_ID->caption() ?><?= $Page->VISIT_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->VISIT_ID->cellAttributes() ?>>
<span id="el_V_KUNJUNGAN_PASIEN_VISIT_ID">
<input type="<?= $Page->VISIT_ID->getInputTextType() ?>" data-table="V_KUNJUNGAN_PASIEN" data-field="x_VISIT_ID" name="x_VISIT_ID" id="x_VISIT_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->VISIT_ID->getPlaceHolder()) ?>" value="<?= $Page->VISIT_ID->EditValue ?>"<?= $Page->VISIT_ID->editAttributes() ?> aria-describedby="x_VISIT_ID_help">
<?= $Page->VISIT_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->VISIT_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->DIANTAR_OLEH->Visible) { // DIANTAR_OLEH ?>
    <div id="r_DIANTAR_OLEH" class="form-group row">
        <label id="elh_V_KUNJUNGAN_PASIEN_DIANTAR_OLEH" for="x_DIANTAR_OLEH" class="<?= $Page->LeftColumnClass ?>"><?= $Page->DIANTAR_OLEH->caption() ?><?= $Page->DIANTAR_OLEH->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->DIANTAR_OLEH->cellAttributes() ?>>
<span id="el_V_KUNJUNGAN_PASIEN_DIANTAR_OLEH">
<input type="<?= $Page->DIANTAR_OLEH->getInputTextType() ?>" data-table="V_KUNJUNGAN_PASIEN" data-field="x_DIANTAR_OLEH" name="x_DIANTAR_OLEH" id="x_DIANTAR_OLEH" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->DIANTAR_OLEH->getPlaceHolder()) ?>" value="<?= $Page->DIANTAR_OLEH->EditValue ?>"<?= $Page->DIANTAR_OLEH->editAttributes() ?> aria-describedby="x_DIANTAR_OLEH_help">
<?= $Page->DIANTAR_OLEH->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->DIANTAR_OLEH->getErrorMessage() ?></div>
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
    ew.addEventHandlers("V_KUNJUNGAN_PASIEN");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
