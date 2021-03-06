<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

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
        ["DIANTAR_OLEH", [fields.DIANTAR_OLEH.visible && fields.DIANTAR_OLEH.required ? ew.Validators.required(fields.DIANTAR_OLEH.caption) : null], fields.DIANTAR_OLEH.isInvalid],
        ["GENDER", [fields.GENDER.visible && fields.GENDER.required ? ew.Validators.required(fields.GENDER.caption) : null], fields.GENDER.isInvalid],
        ["STATUS_PASIEN_ID", [fields.STATUS_PASIEN_ID.visible && fields.STATUS_PASIEN_ID.required ? ew.Validators.required(fields.STATUS_PASIEN_ID.caption) : null], fields.STATUS_PASIEN_ID.isInvalid],
        ["SERVED_INAP", [fields.SERVED_INAP.visible && fields.SERVED_INAP.required ? ew.Validators.required(fields.SERVED_INAP.caption) : null, ew.Validators.datetime(11)], fields.SERVED_INAP.isInvalid],
        ["EXIT_DATE", [fields.EXIT_DATE.visible && fields.EXIT_DATE.required ? ew.Validators.required(fields.EXIT_DATE.caption) : null, ew.Validators.datetime(11)], fields.EXIT_DATE.isInvalid],
        ["KELUAR_ID", [fields.KELUAR_ID.visible && fields.KELUAR_ID.required ? ew.Validators.required(fields.KELUAR_ID.caption) : null], fields.KELUAR_ID.isInvalid],
        ["tgl_kontrol", [fields.tgl_kontrol.visible && fields.tgl_kontrol.required ? ew.Validators.required(fields.tgl_kontrol.caption) : null, ew.Validators.datetime(0)], fields.tgl_kontrol.isInvalid]
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
    fV_KUNJUNGAN_PASIENedit.lists.GENDER = <?= $Page->GENDER->toClientList($Page) ?>;
    fV_KUNJUNGAN_PASIENedit.lists.STATUS_PASIEN_ID = <?= $Page->STATUS_PASIEN_ID->toClientList($Page) ?>;
    fV_KUNJUNGAN_PASIENedit.lists.KELUAR_ID = <?= $Page->KELUAR_ID->toClientList($Page) ?>;
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
<span<?= $Page->NO_REGISTRATION->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->NO_REGISTRATION->getDisplayValue($Page->NO_REGISTRATION->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_KUNJUNGAN_PASIEN" data-field="x_NO_REGISTRATION" data-hidden="1" name="x_NO_REGISTRATION" id="x_NO_REGISTRATION" value="<?= HtmlEncode($Page->NO_REGISTRATION->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->DIANTAR_OLEH->Visible) { // DIANTAR_OLEH ?>
    <div id="r_DIANTAR_OLEH" class="form-group row">
        <label id="elh_V_KUNJUNGAN_PASIEN_DIANTAR_OLEH" for="x_DIANTAR_OLEH" class="<?= $Page->LeftColumnClass ?>"><?= $Page->DIANTAR_OLEH->caption() ?><?= $Page->DIANTAR_OLEH->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->DIANTAR_OLEH->cellAttributes() ?>>
<span id="el_V_KUNJUNGAN_PASIEN_DIANTAR_OLEH">
<span<?= $Page->DIANTAR_OLEH->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->DIANTAR_OLEH->getDisplayValue($Page->DIANTAR_OLEH->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_KUNJUNGAN_PASIEN" data-field="x_DIANTAR_OLEH" data-hidden="1" name="x_DIANTAR_OLEH" id="x_DIANTAR_OLEH" value="<?= HtmlEncode($Page->DIANTAR_OLEH->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->GENDER->Visible) { // GENDER ?>
    <div id="r_GENDER" class="form-group row">
        <label id="elh_V_KUNJUNGAN_PASIEN_GENDER" for="x_GENDER" class="<?= $Page->LeftColumnClass ?>"><?= $Page->GENDER->caption() ?><?= $Page->GENDER->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->GENDER->cellAttributes() ?>>
<span id="el_V_KUNJUNGAN_PASIEN_GENDER">
    <select
        id="x_GENDER"
        name="x_GENDER"
        class="form-control ew-select<?= $Page->GENDER->isInvalidClass() ?>"
        data-select2-id="V_KUNJUNGAN_PASIEN_x_GENDER"
        data-table="V_KUNJUNGAN_PASIEN"
        data-field="x_GENDER"
        data-value-separator="<?= $Page->GENDER->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->GENDER->getPlaceHolder()) ?>"
        <?= $Page->GENDER->editAttributes() ?>>
        <?= $Page->GENDER->selectOptionListHtml("x_GENDER") ?>
    </select>
    <?= $Page->GENDER->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->GENDER->getErrorMessage() ?></div>
<?= $Page->GENDER->Lookup->getParamTag($Page, "p_x_GENDER") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='V_KUNJUNGAN_PASIEN_x_GENDER']"),
        options = { name: "x_GENDER", selectId: "V_KUNJUNGAN_PASIEN_x_GENDER", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.V_KUNJUNGAN_PASIEN.fields.GENDER.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->STATUS_PASIEN_ID->Visible) { // STATUS_PASIEN_ID ?>
    <div id="r_STATUS_PASIEN_ID" class="form-group row">
        <label id="elh_V_KUNJUNGAN_PASIEN_STATUS_PASIEN_ID" for="x_STATUS_PASIEN_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->STATUS_PASIEN_ID->caption() ?><?= $Page->STATUS_PASIEN_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->STATUS_PASIEN_ID->cellAttributes() ?>>
<span id="el_V_KUNJUNGAN_PASIEN_STATUS_PASIEN_ID">
    <select
        id="x_STATUS_PASIEN_ID"
        name="x_STATUS_PASIEN_ID"
        class="form-control ew-select<?= $Page->STATUS_PASIEN_ID->isInvalidClass() ?>"
        data-select2-id="V_KUNJUNGAN_PASIEN_x_STATUS_PASIEN_ID"
        data-table="V_KUNJUNGAN_PASIEN"
        data-field="x_STATUS_PASIEN_ID"
        data-value-separator="<?= $Page->STATUS_PASIEN_ID->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->STATUS_PASIEN_ID->getPlaceHolder()) ?>"
        <?= $Page->STATUS_PASIEN_ID->editAttributes() ?>>
        <?= $Page->STATUS_PASIEN_ID->selectOptionListHtml("x_STATUS_PASIEN_ID") ?>
    </select>
    <?= $Page->STATUS_PASIEN_ID->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->STATUS_PASIEN_ID->getErrorMessage() ?></div>
<?= $Page->STATUS_PASIEN_ID->Lookup->getParamTag($Page, "p_x_STATUS_PASIEN_ID") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='V_KUNJUNGAN_PASIEN_x_STATUS_PASIEN_ID']"),
        options = { name: "x_STATUS_PASIEN_ID", selectId: "V_KUNJUNGAN_PASIEN_x_STATUS_PASIEN_ID", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.V_KUNJUNGAN_PASIEN.fields.STATUS_PASIEN_ID.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->SERVED_INAP->Visible) { // SERVED_INAP ?>
    <div id="r_SERVED_INAP" class="form-group row">
        <label id="elh_V_KUNJUNGAN_PASIEN_SERVED_INAP" for="x_SERVED_INAP" class="<?= $Page->LeftColumnClass ?>"><?= $Page->SERVED_INAP->caption() ?><?= $Page->SERVED_INAP->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->SERVED_INAP->cellAttributes() ?>>
<span id="el_V_KUNJUNGAN_PASIEN_SERVED_INAP">
<input type="<?= $Page->SERVED_INAP->getInputTextType() ?>" data-table="V_KUNJUNGAN_PASIEN" data-field="x_SERVED_INAP" data-format="11" name="x_SERVED_INAP" id="x_SERVED_INAP" placeholder="<?= HtmlEncode($Page->SERVED_INAP->getPlaceHolder()) ?>" value="<?= $Page->SERVED_INAP->EditValue ?>"<?= $Page->SERVED_INAP->editAttributes() ?> aria-describedby="x_SERVED_INAP_help">
<?= $Page->SERVED_INAP->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->SERVED_INAP->getErrorMessage() ?></div>
<?php if (!$Page->SERVED_INAP->ReadOnly && !$Page->SERVED_INAP->Disabled && !isset($Page->SERVED_INAP->EditAttrs["readonly"]) && !isset($Page->SERVED_INAP->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fV_KUNJUNGAN_PASIENedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fV_KUNJUNGAN_PASIENedit", "x_SERVED_INAP", {"ignoreReadonly":true,"useCurrent":false,"format":11});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->EXIT_DATE->Visible) { // EXIT_DATE ?>
    <div id="r_EXIT_DATE" class="form-group row">
        <label id="elh_V_KUNJUNGAN_PASIEN_EXIT_DATE" for="x_EXIT_DATE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->EXIT_DATE->caption() ?><?= $Page->EXIT_DATE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->EXIT_DATE->cellAttributes() ?>>
<span id="el_V_KUNJUNGAN_PASIEN_EXIT_DATE">
<input type="<?= $Page->EXIT_DATE->getInputTextType() ?>" data-table="V_KUNJUNGAN_PASIEN" data-field="x_EXIT_DATE" data-format="11" name="x_EXIT_DATE" id="x_EXIT_DATE" placeholder="<?= HtmlEncode($Page->EXIT_DATE->getPlaceHolder()) ?>" value="<?= $Page->EXIT_DATE->EditValue ?>"<?= $Page->EXIT_DATE->editAttributes() ?> aria-describedby="x_EXIT_DATE_help">
<?= $Page->EXIT_DATE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->EXIT_DATE->getErrorMessage() ?></div>
<?php if (!$Page->EXIT_DATE->ReadOnly && !$Page->EXIT_DATE->Disabled && !isset($Page->EXIT_DATE->EditAttrs["readonly"]) && !isset($Page->EXIT_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fV_KUNJUNGAN_PASIENedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fV_KUNJUNGAN_PASIENedit", "x_EXIT_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":11});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->KELUAR_ID->Visible) { // KELUAR_ID ?>
    <div id="r_KELUAR_ID" class="form-group row">
        <label id="elh_V_KUNJUNGAN_PASIEN_KELUAR_ID" for="x_KELUAR_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->KELUAR_ID->caption() ?><?= $Page->KELUAR_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->KELUAR_ID->cellAttributes() ?>>
<span id="el_V_KUNJUNGAN_PASIEN_KELUAR_ID">
    <select
        id="x_KELUAR_ID"
        name="x_KELUAR_ID"
        class="form-control ew-select<?= $Page->KELUAR_ID->isInvalidClass() ?>"
        data-select2-id="V_KUNJUNGAN_PASIEN_x_KELUAR_ID"
        data-table="V_KUNJUNGAN_PASIEN"
        data-field="x_KELUAR_ID"
        data-value-separator="<?= $Page->KELUAR_ID->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->KELUAR_ID->getPlaceHolder()) ?>"
        <?= $Page->KELUAR_ID->editAttributes() ?>>
        <?= $Page->KELUAR_ID->selectOptionListHtml("x_KELUAR_ID") ?>
    </select>
    <?= $Page->KELUAR_ID->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->KELUAR_ID->getErrorMessage() ?></div>
<?= $Page->KELUAR_ID->Lookup->getParamTag($Page, "p_x_KELUAR_ID") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='V_KUNJUNGAN_PASIEN_x_KELUAR_ID']"),
        options = { name: "x_KELUAR_ID", selectId: "V_KUNJUNGAN_PASIEN_x_KELUAR_ID", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.V_KUNJUNGAN_PASIEN.fields.KELUAR_ID.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tgl_kontrol->Visible) { // tgl_kontrol ?>
    <div id="r_tgl_kontrol" class="form-group row">
        <label id="elh_V_KUNJUNGAN_PASIEN_tgl_kontrol" for="x_tgl_kontrol" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tgl_kontrol->caption() ?><?= $Page->tgl_kontrol->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tgl_kontrol->cellAttributes() ?>>
<span id="el_V_KUNJUNGAN_PASIEN_tgl_kontrol">
<input type="<?= $Page->tgl_kontrol->getInputTextType() ?>" data-table="V_KUNJUNGAN_PASIEN" data-field="x_tgl_kontrol" name="x_tgl_kontrol" id="x_tgl_kontrol" placeholder="<?= HtmlEncode($Page->tgl_kontrol->getPlaceHolder()) ?>" value="<?= $Page->tgl_kontrol->EditValue ?>"<?= $Page->tgl_kontrol->editAttributes() ?> aria-describedby="x_tgl_kontrol_help">
<?= $Page->tgl_kontrol->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tgl_kontrol->getErrorMessage() ?></div>
<?php if (!$Page->tgl_kontrol->ReadOnly && !$Page->tgl_kontrol->Disabled && !isset($Page->tgl_kontrol->EditAttrs["readonly"]) && !isset($Page->tgl_kontrol->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fV_KUNJUNGAN_PASIENedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fV_KUNJUNGAN_PASIENedit", "x_tgl_kontrol", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
    <input type="hidden" data-table="V_KUNJUNGAN_PASIEN" data-field="x_IDXDAFTAR" data-hidden="1" name="x_IDXDAFTAR" id="x_IDXDAFTAR" value="<?= HtmlEncode($Page->IDXDAFTAR->CurrentValue) ?>">
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
