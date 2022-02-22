<?php

namespace PHPMaker2021\SIMRSSQLSERVERPENDAFTARAN;

// Page object
$CvPasienEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fCV_PASIENedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fCV_PASIENedit = currentForm = new ew.Form("fCV_PASIENedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "CV_PASIEN")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.CV_PASIEN)
        ew.vars.tables.CV_PASIEN = currentTable;
    fCV_PASIENedit.addFields([
        ["NO_REGISTRATION", [fields.NO_REGISTRATION.visible && fields.NO_REGISTRATION.required ? ew.Validators.required(fields.NO_REGISTRATION.caption) : null], fields.NO_REGISTRATION.isInvalid],
        ["NAME_OF_PASIEN", [fields.NAME_OF_PASIEN.visible && fields.NAME_OF_PASIEN.required ? ew.Validators.required(fields.NAME_OF_PASIEN.caption) : null], fields.NAME_OF_PASIEN.isInvalid],
        ["PASIEN_ID", [fields.PASIEN_ID.visible && fields.PASIEN_ID.required ? ew.Validators.required(fields.PASIEN_ID.caption) : null], fields.PASIEN_ID.isInvalid],
        ["KK_NO", [fields.KK_NO.visible && fields.KK_NO.required ? ew.Validators.required(fields.KK_NO.caption) : null], fields.KK_NO.isInvalid],
        ["PLACE_OF_BIRTH", [fields.PLACE_OF_BIRTH.visible && fields.PLACE_OF_BIRTH.required ? ew.Validators.required(fields.PLACE_OF_BIRTH.caption) : null], fields.PLACE_OF_BIRTH.isInvalid],
        ["DATE_OF_BIRTH", [fields.DATE_OF_BIRTH.visible && fields.DATE_OF_BIRTH.required ? ew.Validators.required(fields.DATE_OF_BIRTH.caption) : null, ew.Validators.datetime(7)], fields.DATE_OF_BIRTH.isInvalid],
        ["GENDER", [fields.GENDER.visible && fields.GENDER.required ? ew.Validators.required(fields.GENDER.caption) : null], fields.GENDER.isInvalid],
        ["MARITALSTATUSID", [fields.MARITALSTATUSID.visible && fields.MARITALSTATUSID.required ? ew.Validators.required(fields.MARITALSTATUSID.caption) : null], fields.MARITALSTATUSID.isInvalid],
        ["KODE_AGAMA", [fields.KODE_AGAMA.visible && fields.KODE_AGAMA.required ? ew.Validators.required(fields.KODE_AGAMA.caption) : null], fields.KODE_AGAMA.isInvalid],
        ["JOB_ID", [fields.JOB_ID.visible && fields.JOB_ID.required ? ew.Validators.required(fields.JOB_ID.caption) : null, ew.Validators.integer], fields.JOB_ID.isInvalid],
        ["REGISTRATION_DATE", [fields.REGISTRATION_DATE.visible && fields.REGISTRATION_DATE.required ? ew.Validators.required(fields.REGISTRATION_DATE.caption) : null, ew.Validators.datetime(11)], fields.REGISTRATION_DATE.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fCV_PASIENedit,
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
    fCV_PASIENedit.validate = function () {
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
    fCV_PASIENedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fCV_PASIENedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fCV_PASIENedit.lists.GENDER = <?= $Page->GENDER->toClientList($Page) ?>;
    fCV_PASIENedit.lists.MARITALSTATUSID = <?= $Page->MARITALSTATUSID->toClientList($Page) ?>;
    fCV_PASIENedit.lists.KODE_AGAMA = <?= $Page->KODE_AGAMA->toClientList($Page) ?>;
    loadjs.done("fCV_PASIENedit");
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
<form name="fCV_PASIENedit" id="fCV_PASIENedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="CV_PASIEN">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "PASIEN_VISITATION") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="PASIEN_VISITATION">
<input type="hidden" name="fk_NO_REGISTRATION" value="<?= HtmlEncode($Page->NO_REGISTRATION->getSessionValue()) ?>">
<?php } ?>
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->NO_REGISTRATION->Visible) { // NO_REGISTRATION ?>
    <div id="r_NO_REGISTRATION" class="form-group row">
        <label id="elh_CV_PASIEN_NO_REGISTRATION" for="x_NO_REGISTRATION" class="<?= $Page->LeftColumnClass ?>"><?= $Page->NO_REGISTRATION->caption() ?><?= $Page->NO_REGISTRATION->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->NO_REGISTRATION->cellAttributes() ?>>
<span id="el_CV_PASIEN_NO_REGISTRATION">
<span<?= $Page->NO_REGISTRATION->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->NO_REGISTRATION->getDisplayValue($Page->NO_REGISTRATION->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="CV_PASIEN" data-field="x_NO_REGISTRATION" data-hidden="1" name="x_NO_REGISTRATION" id="x_NO_REGISTRATION" value="<?= HtmlEncode($Page->NO_REGISTRATION->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->NAME_OF_PASIEN->Visible) { // NAME_OF_PASIEN ?>
    <div id="r_NAME_OF_PASIEN" class="form-group row">
        <label id="elh_CV_PASIEN_NAME_OF_PASIEN" for="x_NAME_OF_PASIEN" class="<?= $Page->LeftColumnClass ?>"><?= $Page->NAME_OF_PASIEN->caption() ?><?= $Page->NAME_OF_PASIEN->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->NAME_OF_PASIEN->cellAttributes() ?>>
<span id="el_CV_PASIEN_NAME_OF_PASIEN">
<input type="<?= $Page->NAME_OF_PASIEN->getInputTextType() ?>" data-table="CV_PASIEN" data-field="x_NAME_OF_PASIEN" name="x_NAME_OF_PASIEN" id="x_NAME_OF_PASIEN" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->NAME_OF_PASIEN->getPlaceHolder()) ?>" value="<?= $Page->NAME_OF_PASIEN->EditValue ?>"<?= $Page->NAME_OF_PASIEN->editAttributes() ?> aria-describedby="x_NAME_OF_PASIEN_help">
<?= $Page->NAME_OF_PASIEN->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->NAME_OF_PASIEN->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->PASIEN_ID->Visible) { // PASIEN_ID ?>
    <div id="r_PASIEN_ID" class="form-group row">
        <label id="elh_CV_PASIEN_PASIEN_ID" for="x_PASIEN_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->PASIEN_ID->caption() ?><?= $Page->PASIEN_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PASIEN_ID->cellAttributes() ?>>
<span id="el_CV_PASIEN_PASIEN_ID">
<input type="<?= $Page->PASIEN_ID->getInputTextType() ?>" data-table="CV_PASIEN" data-field="x_PASIEN_ID" name="x_PASIEN_ID" id="x_PASIEN_ID" size="30" maxlength="30" placeholder="<?= HtmlEncode($Page->PASIEN_ID->getPlaceHolder()) ?>" value="<?= $Page->PASIEN_ID->EditValue ?>"<?= $Page->PASIEN_ID->editAttributes() ?> aria-describedby="x_PASIEN_ID_help">
<?= $Page->PASIEN_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->PASIEN_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->KK_NO->Visible) { // KK_NO ?>
    <div id="r_KK_NO" class="form-group row">
        <label id="elh_CV_PASIEN_KK_NO" for="x_KK_NO" class="<?= $Page->LeftColumnClass ?>"><?= $Page->KK_NO->caption() ?><?= $Page->KK_NO->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->KK_NO->cellAttributes() ?>>
<span id="el_CV_PASIEN_KK_NO">
<input type="<?= $Page->KK_NO->getInputTextType() ?>" data-table="CV_PASIEN" data-field="x_KK_NO" name="x_KK_NO" id="x_KK_NO" size="30" maxlength="30" placeholder="<?= HtmlEncode($Page->KK_NO->getPlaceHolder()) ?>" value="<?= $Page->KK_NO->EditValue ?>"<?= $Page->KK_NO->editAttributes() ?> aria-describedby="x_KK_NO_help">
<?= $Page->KK_NO->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->KK_NO->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->PLACE_OF_BIRTH->Visible) { // PLACE_OF_BIRTH ?>
    <div id="r_PLACE_OF_BIRTH" class="form-group row">
        <label id="elh_CV_PASIEN_PLACE_OF_BIRTH" for="x_PLACE_OF_BIRTH" class="<?= $Page->LeftColumnClass ?>"><?= $Page->PLACE_OF_BIRTH->caption() ?><?= $Page->PLACE_OF_BIRTH->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PLACE_OF_BIRTH->cellAttributes() ?>>
<span id="el_CV_PASIEN_PLACE_OF_BIRTH">
<input type="<?= $Page->PLACE_OF_BIRTH->getInputTextType() ?>" data-table="CV_PASIEN" data-field="x_PLACE_OF_BIRTH" name="x_PLACE_OF_BIRTH" id="x_PLACE_OF_BIRTH" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->PLACE_OF_BIRTH->getPlaceHolder()) ?>" value="<?= $Page->PLACE_OF_BIRTH->EditValue ?>"<?= $Page->PLACE_OF_BIRTH->editAttributes() ?> aria-describedby="x_PLACE_OF_BIRTH_help">
<?= $Page->PLACE_OF_BIRTH->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->PLACE_OF_BIRTH->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->DATE_OF_BIRTH->Visible) { // DATE_OF_BIRTH ?>
    <div id="r_DATE_OF_BIRTH" class="form-group row">
        <label id="elh_CV_PASIEN_DATE_OF_BIRTH" for="x_DATE_OF_BIRTH" class="<?= $Page->LeftColumnClass ?>"><?= $Page->DATE_OF_BIRTH->caption() ?><?= $Page->DATE_OF_BIRTH->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->DATE_OF_BIRTH->cellAttributes() ?>>
<span id="el_CV_PASIEN_DATE_OF_BIRTH">
<input type="<?= $Page->DATE_OF_BIRTH->getInputTextType() ?>" data-table="CV_PASIEN" data-field="x_DATE_OF_BIRTH" data-format="7" name="x_DATE_OF_BIRTH" id="x_DATE_OF_BIRTH" placeholder="<?= HtmlEncode($Page->DATE_OF_BIRTH->getPlaceHolder()) ?>" value="<?= $Page->DATE_OF_BIRTH->EditValue ?>"<?= $Page->DATE_OF_BIRTH->editAttributes() ?> aria-describedby="x_DATE_OF_BIRTH_help">
<?= $Page->DATE_OF_BIRTH->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->DATE_OF_BIRTH->getErrorMessage() ?></div>
<?php if (!$Page->DATE_OF_BIRTH->ReadOnly && !$Page->DATE_OF_BIRTH->Disabled && !isset($Page->DATE_OF_BIRTH->EditAttrs["readonly"]) && !isset($Page->DATE_OF_BIRTH->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fCV_PASIENedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fCV_PASIENedit", "x_DATE_OF_BIRTH", {"ignoreReadonly":true,"useCurrent":false,"format":7});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->GENDER->Visible) { // GENDER ?>
    <div id="r_GENDER" class="form-group row">
        <label id="elh_CV_PASIEN_GENDER" class="<?= $Page->LeftColumnClass ?>"><?= $Page->GENDER->caption() ?><?= $Page->GENDER->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->GENDER->cellAttributes() ?>>
<span id="el_CV_PASIEN_GENDER">
<?php
$onchange = $Page->GENDER->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Page->GENDER->EditAttrs["onchange"] = "";
?>
<span id="as_x_GENDER" class="ew-auto-suggest">
    <input type="<?= $Page->GENDER->getInputTextType() ?>" class="form-control" name="sv_x_GENDER" id="sv_x_GENDER" value="<?= RemoveHtml($Page->GENDER->EditValue) ?>" size="30" maxlength="1" placeholder="<?= HtmlEncode($Page->GENDER->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Page->GENDER->getPlaceHolder()) ?>"<?= $Page->GENDER->editAttributes() ?> aria-describedby="x_GENDER_help">
</span>
<input type="hidden" is="selection-list" class="form-control" data-table="CV_PASIEN" data-field="x_GENDER" data-input="sv_x_GENDER" data-value-separator="<?= $Page->GENDER->displayValueSeparatorAttribute() ?>" name="x_GENDER" id="x_GENDER" value="<?= HtmlEncode($Page->GENDER->CurrentValue) ?>"<?= $onchange ?>>
<?= $Page->GENDER->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->GENDER->getErrorMessage() ?></div>
<script>
loadjs.ready(["fCV_PASIENedit"], function() {
    fCV_PASIENedit.createAutoSuggest(Object.assign({"id":"x_GENDER","forceSelect":false}, ew.vars.tables.CV_PASIEN.fields.GENDER.autoSuggestOptions));
});
</script>
<?= $Page->GENDER->Lookup->getParamTag($Page, "p_x_GENDER") ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->MARITALSTATUSID->Visible) { // MARITALSTATUSID ?>
    <div id="r_MARITALSTATUSID" class="form-group row">
        <label id="elh_CV_PASIEN_MARITALSTATUSID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->MARITALSTATUSID->caption() ?><?= $Page->MARITALSTATUSID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->MARITALSTATUSID->cellAttributes() ?>>
<span id="el_CV_PASIEN_MARITALSTATUSID">
<template id="tp_x_MARITALSTATUSID">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="CV_PASIEN" data-field="x_MARITALSTATUSID" name="x_MARITALSTATUSID" id="x_MARITALSTATUSID"<?= $Page->MARITALSTATUSID->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x_MARITALSTATUSID" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x_MARITALSTATUSID"
    name="x_MARITALSTATUSID"
    value="<?= HtmlEncode($Page->MARITALSTATUSID->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_MARITALSTATUSID"
    data-target="dsl_x_MARITALSTATUSID"
    data-repeatcolumn="5"
    class="form-control<?= $Page->MARITALSTATUSID->isInvalidClass() ?>"
    data-table="CV_PASIEN"
    data-field="x_MARITALSTATUSID"
    data-value-separator="<?= $Page->MARITALSTATUSID->displayValueSeparatorAttribute() ?>"
    <?= $Page->MARITALSTATUSID->editAttributes() ?>>
<?= $Page->MARITALSTATUSID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->MARITALSTATUSID->getErrorMessage() ?></div>
<?= $Page->MARITALSTATUSID->Lookup->getParamTag($Page, "p_x_MARITALSTATUSID") ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->KODE_AGAMA->Visible) { // KODE_AGAMA ?>
    <div id="r_KODE_AGAMA" class="form-group row">
        <label id="elh_CV_PASIEN_KODE_AGAMA" class="<?= $Page->LeftColumnClass ?>"><?= $Page->KODE_AGAMA->caption() ?><?= $Page->KODE_AGAMA->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->KODE_AGAMA->cellAttributes() ?>>
<span id="el_CV_PASIEN_KODE_AGAMA">
<template id="tp_x_KODE_AGAMA">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="CV_PASIEN" data-field="x_KODE_AGAMA" name="x_KODE_AGAMA" id="x_KODE_AGAMA"<?= $Page->KODE_AGAMA->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x_KODE_AGAMA" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x_KODE_AGAMA"
    name="x_KODE_AGAMA"
    value="<?= HtmlEncode($Page->KODE_AGAMA->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_KODE_AGAMA"
    data-target="dsl_x_KODE_AGAMA"
    data-repeatcolumn="5"
    class="form-control<?= $Page->KODE_AGAMA->isInvalidClass() ?>"
    data-table="CV_PASIEN"
    data-field="x_KODE_AGAMA"
    data-value-separator="<?= $Page->KODE_AGAMA->displayValueSeparatorAttribute() ?>"
    <?= $Page->KODE_AGAMA->editAttributes() ?>>
<?= $Page->KODE_AGAMA->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->KODE_AGAMA->getErrorMessage() ?></div>
<?= $Page->KODE_AGAMA->Lookup->getParamTag($Page, "p_x_KODE_AGAMA") ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->JOB_ID->Visible) { // JOB_ID ?>
    <div id="r_JOB_ID" class="form-group row">
        <label id="elh_CV_PASIEN_JOB_ID" for="x_JOB_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->JOB_ID->caption() ?><?= $Page->JOB_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->JOB_ID->cellAttributes() ?>>
<span id="el_CV_PASIEN_JOB_ID">
<input type="<?= $Page->JOB_ID->getInputTextType() ?>" data-table="CV_PASIEN" data-field="x_JOB_ID" name="x_JOB_ID" id="x_JOB_ID" size="30" placeholder="<?= HtmlEncode($Page->JOB_ID->getPlaceHolder()) ?>" value="<?= $Page->JOB_ID->EditValue ?>"<?= $Page->JOB_ID->editAttributes() ?> aria-describedby="x_JOB_ID_help">
<?= $Page->JOB_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->JOB_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->REGISTRATION_DATE->Visible) { // REGISTRATION_DATE ?>
    <div id="r_REGISTRATION_DATE" class="form-group row">
        <label id="elh_CV_PASIEN_REGISTRATION_DATE" for="x_REGISTRATION_DATE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->REGISTRATION_DATE->caption() ?><?= $Page->REGISTRATION_DATE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->REGISTRATION_DATE->cellAttributes() ?>>
<span id="el_CV_PASIEN_REGISTRATION_DATE">
<input type="<?= $Page->REGISTRATION_DATE->getInputTextType() ?>" data-table="CV_PASIEN" data-field="x_REGISTRATION_DATE" data-format="11" name="x_REGISTRATION_DATE" id="x_REGISTRATION_DATE" placeholder="<?= HtmlEncode($Page->REGISTRATION_DATE->getPlaceHolder()) ?>" value="<?= $Page->REGISTRATION_DATE->EditValue ?>"<?= $Page->REGISTRATION_DATE->editAttributes() ?> aria-describedby="x_REGISTRATION_DATE_help">
<?= $Page->REGISTRATION_DATE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->REGISTRATION_DATE->getErrorMessage() ?></div>
<?php if (!$Page->REGISTRATION_DATE->ReadOnly && !$Page->REGISTRATION_DATE->Disabled && !isset($Page->REGISTRATION_DATE->EditAttrs["readonly"]) && !isset($Page->REGISTRATION_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fCV_PASIENedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fCV_PASIENedit", "x_REGISTRATION_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":11});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
    <input type="hidden" data-table="CV_PASIEN" data-field="x_ID" data-hidden="1" name="x_ID" id="x_ID" value="<?= HtmlEncode($Page->ID->CurrentValue) ?>">
<?php
    if (in_array("PASIEN_VISITATION", explode(",", $Page->getCurrentDetailTable())) && $PASIEN_VISITATION->DetailEdit) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("PASIEN_VISITATION", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "PasienVisitationGrid.php" ?>
<?php } ?>
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
    ew.addEventHandlers("CV_PASIEN");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
