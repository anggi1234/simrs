<?php

namespace PHPMaker2021\SIMRSFARMASI;

// Page object
$ObstetriEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fOBSTETRIedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fOBSTETRIedit = currentForm = new ew.Form("fOBSTETRIedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "OBSTETRI")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.OBSTETRI)
        ew.vars.tables.OBSTETRI = currentTable;
    fOBSTETRIedit.addFields([
        ["NO_REGISTRATION", [fields.NO_REGISTRATION.visible && fields.NO_REGISTRATION.required ? ew.Validators.required(fields.NO_REGISTRATION.caption) : null], fields.NO_REGISTRATION.isInvalid],
        ["THENAME", [fields.THENAME.visible && fields.THENAME.required ? ew.Validators.required(fields.THENAME.caption) : null], fields.THENAME.isInvalid],
        ["THEADDRESS", [fields.THEADDRESS.visible && fields.THEADDRESS.required ? ew.Validators.required(fields.THEADDRESS.caption) : null], fields.THEADDRESS.isInvalid],
        ["GENDER", [fields.GENDER.visible && fields.GENDER.required ? ew.Validators.required(fields.GENDER.caption) : null], fields.GENDER.isInvalid],
        ["CLINIC_ID", [fields.CLINIC_ID.visible && fields.CLINIC_ID.required ? ew.Validators.required(fields.CLINIC_ID.caption) : null], fields.CLINIC_ID.isInvalid],
        ["EMPLOYEE_ID", [fields.EMPLOYEE_ID.visible && fields.EMPLOYEE_ID.required ? ew.Validators.required(fields.EMPLOYEE_ID.caption) : null], fields.EMPLOYEE_ID.isInvalid],
        ["BIRTH_NB", [fields.BIRTH_NB.visible && fields.BIRTH_NB.required ? ew.Validators.required(fields.BIRTH_NB.caption) : null], fields.BIRTH_NB.isInvalid],
        ["BIRTH_DURATION", [fields.BIRTH_DURATION.visible && fields.BIRTH_DURATION.required ? ew.Validators.required(fields.BIRTH_DURATION.caption) : null, ew.Validators.integer], fields.BIRTH_DURATION.isInvalid],
        ["BIRTH_PLACE", [fields.BIRTH_PLACE.visible && fields.BIRTH_PLACE.required ? ew.Validators.required(fields.BIRTH_PLACE.caption) : null], fields.BIRTH_PLACE.isInvalid],
        ["ANTE_NATAL", [fields.ANTE_NATAL.visible && fields.ANTE_NATAL.required ? ew.Validators.required(fields.ANTE_NATAL.caption) : null], fields.ANTE_NATAL.isInvalid],
        ["BIRTH_WAY", [fields.BIRTH_WAY.visible && fields.BIRTH_WAY.required ? ew.Validators.required(fields.BIRTH_WAY.caption) : null], fields.BIRTH_WAY.isInvalid],
        ["BIRTH_BY", [fields.BIRTH_BY.visible && fields.BIRTH_BY.required ? ew.Validators.required(fields.BIRTH_BY.caption) : null], fields.BIRTH_BY.isInvalid],
        ["BIRTH_DATE", [fields.BIRTH_DATE.visible && fields.BIRTH_DATE.required ? ew.Validators.required(fields.BIRTH_DATE.caption) : null, ew.Validators.datetime(7)], fields.BIRTH_DATE.isInvalid],
        ["GESTASI", [fields.GESTASI.visible && fields.GESTASI.required ? ew.Validators.required(fields.GESTASI.caption) : null, ew.Validators.integer], fields.GESTASI.isInvalid],
        ["PARITY", [fields.PARITY.visible && fields.PARITY.required ? ew.Validators.required(fields.PARITY.caption) : null, ew.Validators.integer], fields.PARITY.isInvalid],
        ["NB_BABY", [fields.NB_BABY.visible && fields.NB_BABY.required ? ew.Validators.required(fields.NB_BABY.caption) : null, ew.Validators.integer], fields.NB_BABY.isInvalid],
        ["BABY_DIE", [fields.BABY_DIE.visible && fields.BABY_DIE.required ? ew.Validators.required(fields.BABY_DIE.caption) : null, ew.Validators.integer], fields.BABY_DIE.isInvalid],
        ["ABORTUS_KE", [fields.ABORTUS_KE.visible && fields.ABORTUS_KE.required ? ew.Validators.required(fields.ABORTUS_KE.caption) : null, ew.Validators.integer], fields.ABORTUS_KE.isInvalid],
        ["ABORTUS_ID", [fields.ABORTUS_ID.visible && fields.ABORTUS_ID.required ? ew.Validators.required(fields.ABORTUS_ID.caption) : null], fields.ABORTUS_ID.isInvalid],
        ["ABORTION_DATE", [fields.ABORTION_DATE.visible && fields.ABORTION_DATE.required ? ew.Validators.required(fields.ABORTION_DATE.caption) : null, ew.Validators.datetime(0)], fields.ABORTION_DATE.isInvalid],
        ["BIRTH_CAT", [fields.BIRTH_CAT.visible && fields.BIRTH_CAT.required ? ew.Validators.required(fields.BIRTH_CAT.caption) : null], fields.BIRTH_CAT.isInvalid],
        ["BIRTH_CON", [fields.BIRTH_CON.visible && fields.BIRTH_CON.required ? ew.Validators.required(fields.BIRTH_CON.caption) : null], fields.BIRTH_CON.isInvalid],
        ["BIRTH_RISK", [fields.BIRTH_RISK.visible && fields.BIRTH_RISK.required ? ew.Validators.required(fields.BIRTH_RISK.caption) : null, ew.Validators.integer], fields.BIRTH_RISK.isInvalid],
        ["RISK_TYPE", [fields.RISK_TYPE.visible && fields.RISK_TYPE.required ? ew.Validators.required(fields.RISK_TYPE.caption) : null, ew.Validators.integer], fields.RISK_TYPE.isInvalid],
        ["FOLLOW_UP", [fields.FOLLOW_UP.visible && fields.FOLLOW_UP.required ? ew.Validators.required(fields.FOLLOW_UP.caption) : null], fields.FOLLOW_UP.isInvalid],
        ["DIRUJUK_OLEH", [fields.DIRUJUK_OLEH.visible && fields.DIRUJUK_OLEH.required ? ew.Validators.required(fields.DIRUJUK_OLEH.caption) : null], fields.DIRUJUK_OLEH.isInvalid],
        ["INSPECTION_DATE", [fields.INSPECTION_DATE.visible && fields.INSPECTION_DATE.required ? ew.Validators.required(fields.INSPECTION_DATE.caption) : null, ew.Validators.datetime(11)], fields.INSPECTION_DATE.isInvalid],
        ["PORSIO", [fields.PORSIO.visible && fields.PORSIO.required ? ew.Validators.required(fields.PORSIO.caption) : null], fields.PORSIO.isInvalid],
        ["PEMBUKAAN", [fields.PEMBUKAAN.visible && fields.PEMBUKAAN.required ? ew.Validators.required(fields.PEMBUKAAN.caption) : null], fields.PEMBUKAAN.isInvalid],
        ["KETUBAN", [fields.KETUBAN.visible && fields.KETUBAN.required ? ew.Validators.required(fields.KETUBAN.caption) : null], fields.KETUBAN.isInvalid],
        ["PRESENTASI", [fields.PRESENTASI.visible && fields.PRESENTASI.required ? ew.Validators.required(fields.PRESENTASI.caption) : null], fields.PRESENTASI.isInvalid],
        ["POSISI", [fields.POSISI.visible && fields.POSISI.required ? ew.Validators.required(fields.POSISI.caption) : null], fields.POSISI.isInvalid],
        ["PENURUNAN", [fields.PENURUNAN.visible && fields.PENURUNAN.required ? ew.Validators.required(fields.PENURUNAN.caption) : null], fields.PENURUNAN.isInvalid],
        ["PLACENTA", [fields.PLACENTA.visible && fields.PLACENTA.required ? ew.Validators.required(fields.PLACENTA.caption) : null], fields.PLACENTA.isInvalid],
        ["RAHIM_ID", [fields.RAHIM_ID.visible && fields.RAHIM_ID.required ? ew.Validators.required(fields.RAHIM_ID.caption) : null], fields.RAHIM_ID.isInvalid],
        ["BLOODING", [fields.BLOODING.visible && fields.BLOODING.required ? ew.Validators.required(fields.BLOODING.caption) : null], fields.BLOODING.isInvalid],
        ["DESCRIPTION", [fields.DESCRIPTION.visible && fields.DESCRIPTION.required ? ew.Validators.required(fields.DESCRIPTION.caption) : null], fields.DESCRIPTION.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fOBSTETRIedit,
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
    fOBSTETRIedit.validate = function () {
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
    fOBSTETRIedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fOBSTETRIedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Multi-Page
    fOBSTETRIedit.multiPage = new ew.MultiPage("fOBSTETRIedit");

    // Dynamic selection lists
    fOBSTETRIedit.lists.BIRTH_NB = <?= $Page->BIRTH_NB->toClientList($Page) ?>;
    fOBSTETRIedit.lists.BIRTH_PLACE = <?= $Page->BIRTH_PLACE->toClientList($Page) ?>;
    fOBSTETRIedit.lists.ANTE_NATAL = <?= $Page->ANTE_NATAL->toClientList($Page) ?>;
    fOBSTETRIedit.lists.BIRTH_WAY = <?= $Page->BIRTH_WAY->toClientList($Page) ?>;
    fOBSTETRIedit.lists.BIRTH_BY = <?= $Page->BIRTH_BY->toClientList($Page) ?>;
    fOBSTETRIedit.lists.ABORTUS_ID = <?= $Page->ABORTUS_ID->toClientList($Page) ?>;
    fOBSTETRIedit.lists.BIRTH_CON = <?= $Page->BIRTH_CON->toClientList($Page) ?>;
    fOBSTETRIedit.lists.FOLLOW_UP = <?= $Page->FOLLOW_UP->toClientList($Page) ?>;
    fOBSTETRIedit.lists.DIRUJUK_OLEH = <?= $Page->DIRUJUK_OLEH->toClientList($Page) ?>;
    fOBSTETRIedit.lists.RAHIM_ID = <?= $Page->RAHIM_ID->toClientList($Page) ?>;
    fOBSTETRIedit.lists.BLOODING = <?= $Page->BLOODING->toClientList($Page) ?>;
    loadjs.done("fOBSTETRIedit");
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
<form name="fOBSTETRIedit" id="fOBSTETRIedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="OBSTETRI">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "V_RAWAT_INAP") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="V_RAWAT_INAP">
<input type="hidden" name="fk_VISIT_ID" value="<?= HtmlEncode($Page->VISIT_ID->getSessionValue()) ?>">
<?php } ?>
<div class="ew-multi-page"><!-- multi-page -->
<div class="ew-nav-tabs" id="Page"><!-- multi-page tabs -->
    <ul class="<?= $Page->MultiPages->navStyle() ?>">
        <li class="nav-item"><a class="nav-link<?= $Page->MultiPages->pageStyle(1) ?>" href="#tab_OBSTETRI1" data-toggle="tab"><?= $Page->pageCaption(1) ?></a></li>
        <li class="nav-item"><a class="nav-link<?= $Page->MultiPages->pageStyle(2) ?>" href="#tab_OBSTETRI2" data-toggle="tab"><?= $Page->pageCaption(2) ?></a></li>
        <li class="nav-item"><a class="nav-link<?= $Page->MultiPages->pageStyle(3) ?>" href="#tab_OBSTETRI3" data-toggle="tab"><?= $Page->pageCaption(3) ?></a></li>
    </ul>
    <div class="tab-content"><!-- multi-page tabs .tab-content -->
        <div class="tab-pane<?= $Page->MultiPages->pageStyle(1) ?>" id="tab_OBSTETRI1"><!-- multi-page .tab-pane -->
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->NO_REGISTRATION->Visible) { // NO_REGISTRATION ?>
    <div id="r_NO_REGISTRATION" class="form-group row">
        <label id="elh_OBSTETRI_NO_REGISTRATION" for="x_NO_REGISTRATION" class="<?= $Page->LeftColumnClass ?>"><?= $Page->NO_REGISTRATION->caption() ?><?= $Page->NO_REGISTRATION->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->NO_REGISTRATION->cellAttributes() ?>>
<span id="el_OBSTETRI_NO_REGISTRATION">
<span<?= $Page->NO_REGISTRATION->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->NO_REGISTRATION->getDisplayValue($Page->NO_REGISTRATION->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_NO_REGISTRATION" data-hidden="1" data-page="1" name="x_NO_REGISTRATION" id="x_NO_REGISTRATION" value="<?= HtmlEncode($Page->NO_REGISTRATION->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->THENAME->Visible) { // THENAME ?>
    <div id="r_THENAME" class="form-group row">
        <label id="elh_OBSTETRI_THENAME" for="x_THENAME" class="<?= $Page->LeftColumnClass ?>"><?= $Page->THENAME->caption() ?><?= $Page->THENAME->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->THENAME->cellAttributes() ?>>
<span id="el_OBSTETRI_THENAME">
<span<?= $Page->THENAME->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->THENAME->getDisplayValue($Page->THENAME->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_THENAME" data-hidden="1" data-page="1" name="x_THENAME" id="x_THENAME" value="<?= HtmlEncode($Page->THENAME->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->THEADDRESS->Visible) { // THEADDRESS ?>
    <div id="r_THEADDRESS" class="form-group row">
        <label id="elh_OBSTETRI_THEADDRESS" for="x_THEADDRESS" class="<?= $Page->LeftColumnClass ?>"><?= $Page->THEADDRESS->caption() ?><?= $Page->THEADDRESS->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->THEADDRESS->cellAttributes() ?>>
<span id="el_OBSTETRI_THEADDRESS">
<span<?= $Page->THEADDRESS->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->THEADDRESS->getDisplayValue($Page->THEADDRESS->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_THEADDRESS" data-hidden="1" data-page="1" name="x_THEADDRESS" id="x_THEADDRESS" value="<?= HtmlEncode($Page->THEADDRESS->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->GENDER->Visible) { // GENDER ?>
    <div id="r_GENDER" class="form-group row">
        <label id="elh_OBSTETRI_GENDER" for="x_GENDER" class="<?= $Page->LeftColumnClass ?>"><?= $Page->GENDER->caption() ?><?= $Page->GENDER->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->GENDER->cellAttributes() ?>>
<span id="el_OBSTETRI_GENDER">
<span<?= $Page->GENDER->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->GENDER->getDisplayValue($Page->GENDER->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_GENDER" data-hidden="1" data-page="1" name="x_GENDER" id="x_GENDER" value="<?= HtmlEncode($Page->GENDER->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->CLINIC_ID->Visible) { // CLINIC_ID ?>
    <div id="r_CLINIC_ID" class="form-group row">
        <label id="elh_OBSTETRI_CLINIC_ID" for="x_CLINIC_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->CLINIC_ID->caption() ?><?= $Page->CLINIC_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->CLINIC_ID->cellAttributes() ?>>
<span id="el_OBSTETRI_CLINIC_ID">
<span<?= $Page->CLINIC_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->CLINIC_ID->getDisplayValue($Page->CLINIC_ID->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_CLINIC_ID" data-hidden="1" data-page="1" name="x_CLINIC_ID" id="x_CLINIC_ID" value="<?= HtmlEncode($Page->CLINIC_ID->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->EMPLOYEE_ID->Visible) { // EMPLOYEE_ID ?>
    <div id="r_EMPLOYEE_ID" class="form-group row">
        <label id="elh_OBSTETRI_EMPLOYEE_ID" for="x_EMPLOYEE_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->EMPLOYEE_ID->caption() ?><?= $Page->EMPLOYEE_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->EMPLOYEE_ID->cellAttributes() ?>>
<span id="el_OBSTETRI_EMPLOYEE_ID">
<span<?= $Page->EMPLOYEE_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->EMPLOYEE_ID->getDisplayValue($Page->EMPLOYEE_ID->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_EMPLOYEE_ID" data-hidden="1" data-page="1" name="x_EMPLOYEE_ID" id="x_EMPLOYEE_ID" value="<?= HtmlEncode($Page->EMPLOYEE_ID->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->BIRTH_NB->Visible) { // BIRTH_NB ?>
    <div id="r_BIRTH_NB" class="form-group row">
        <label id="elh_OBSTETRI_BIRTH_NB" for="x_BIRTH_NB" class="<?= $Page->LeftColumnClass ?>"><?= $Page->BIRTH_NB->caption() ?><?= $Page->BIRTH_NB->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->BIRTH_NB->cellAttributes() ?>>
<span id="el_OBSTETRI_BIRTH_NB">
    <select
        id="x_BIRTH_NB"
        name="x_BIRTH_NB"
        class="form-control ew-select<?= $Page->BIRTH_NB->isInvalidClass() ?>"
        data-select2-id="OBSTETRI_x_BIRTH_NB"
        data-table="OBSTETRI"
        data-field="x_BIRTH_NB"
        data-page="1"
        data-value-separator="<?= $Page->BIRTH_NB->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->BIRTH_NB->getPlaceHolder()) ?>"
        <?= $Page->BIRTH_NB->editAttributes() ?>>
        <?= $Page->BIRTH_NB->selectOptionListHtml("x_BIRTH_NB") ?>
    </select>
    <?= $Page->BIRTH_NB->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->BIRTH_NB->getErrorMessage() ?></div>
<?= $Page->BIRTH_NB->Lookup->getParamTag($Page, "p_x_BIRTH_NB") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='OBSTETRI_x_BIRTH_NB']"),
        options = { name: "x_BIRTH_NB", selectId: "OBSTETRI_x_BIRTH_NB", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.OBSTETRI.fields.BIRTH_NB.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->BIRTH_DURATION->Visible) { // BIRTH_DURATION ?>
    <div id="r_BIRTH_DURATION" class="form-group row">
        <label id="elh_OBSTETRI_BIRTH_DURATION" for="x_BIRTH_DURATION" class="<?= $Page->LeftColumnClass ?>"><?= $Page->BIRTH_DURATION->caption() ?><?= $Page->BIRTH_DURATION->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->BIRTH_DURATION->cellAttributes() ?>>
<span id="el_OBSTETRI_BIRTH_DURATION">
<input type="<?= $Page->BIRTH_DURATION->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_BIRTH_DURATION" data-page="1" name="x_BIRTH_DURATION" id="x_BIRTH_DURATION" size="30" placeholder="<?= HtmlEncode($Page->BIRTH_DURATION->getPlaceHolder()) ?>" value="<?= $Page->BIRTH_DURATION->EditValue ?>"<?= $Page->BIRTH_DURATION->editAttributes() ?> aria-describedby="x_BIRTH_DURATION_help">
<?= $Page->BIRTH_DURATION->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->BIRTH_DURATION->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->BIRTH_PLACE->Visible) { // BIRTH_PLACE ?>
    <div id="r_BIRTH_PLACE" class="form-group row">
        <label id="elh_OBSTETRI_BIRTH_PLACE" for="x_BIRTH_PLACE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->BIRTH_PLACE->caption() ?><?= $Page->BIRTH_PLACE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->BIRTH_PLACE->cellAttributes() ?>>
<span id="el_OBSTETRI_BIRTH_PLACE">
    <select
        id="x_BIRTH_PLACE"
        name="x_BIRTH_PLACE"
        class="form-control ew-select<?= $Page->BIRTH_PLACE->isInvalidClass() ?>"
        data-select2-id="OBSTETRI_x_BIRTH_PLACE"
        data-table="OBSTETRI"
        data-field="x_BIRTH_PLACE"
        data-page="1"
        data-value-separator="<?= $Page->BIRTH_PLACE->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->BIRTH_PLACE->getPlaceHolder()) ?>"
        <?= $Page->BIRTH_PLACE->editAttributes() ?>>
        <?= $Page->BIRTH_PLACE->selectOptionListHtml("x_BIRTH_PLACE") ?>
    </select>
    <?= $Page->BIRTH_PLACE->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->BIRTH_PLACE->getErrorMessage() ?></div>
<?= $Page->BIRTH_PLACE->Lookup->getParamTag($Page, "p_x_BIRTH_PLACE") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='OBSTETRI_x_BIRTH_PLACE']"),
        options = { name: "x_BIRTH_PLACE", selectId: "OBSTETRI_x_BIRTH_PLACE", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.OBSTETRI.fields.BIRTH_PLACE.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ANTE_NATAL->Visible) { // ANTE_NATAL ?>
    <div id="r_ANTE_NATAL" class="form-group row">
        <label id="elh_OBSTETRI_ANTE_NATAL" for="x_ANTE_NATAL" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ANTE_NATAL->caption() ?><?= $Page->ANTE_NATAL->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ANTE_NATAL->cellAttributes() ?>>
<span id="el_OBSTETRI_ANTE_NATAL">
    <select
        id="x_ANTE_NATAL"
        name="x_ANTE_NATAL"
        class="form-control ew-select<?= $Page->ANTE_NATAL->isInvalidClass() ?>"
        data-select2-id="OBSTETRI_x_ANTE_NATAL"
        data-table="OBSTETRI"
        data-field="x_ANTE_NATAL"
        data-page="1"
        data-value-separator="<?= $Page->ANTE_NATAL->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->ANTE_NATAL->getPlaceHolder()) ?>"
        <?= $Page->ANTE_NATAL->editAttributes() ?>>
        <?= $Page->ANTE_NATAL->selectOptionListHtml("x_ANTE_NATAL") ?>
    </select>
    <?= $Page->ANTE_NATAL->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->ANTE_NATAL->getErrorMessage() ?></div>
<?= $Page->ANTE_NATAL->Lookup->getParamTag($Page, "p_x_ANTE_NATAL") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='OBSTETRI_x_ANTE_NATAL']"),
        options = { name: "x_ANTE_NATAL", selectId: "OBSTETRI_x_ANTE_NATAL", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.OBSTETRI.fields.ANTE_NATAL.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->BIRTH_WAY->Visible) { // BIRTH_WAY ?>
    <div id="r_BIRTH_WAY" class="form-group row">
        <label id="elh_OBSTETRI_BIRTH_WAY" for="x_BIRTH_WAY" class="<?= $Page->LeftColumnClass ?>"><?= $Page->BIRTH_WAY->caption() ?><?= $Page->BIRTH_WAY->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->BIRTH_WAY->cellAttributes() ?>>
<span id="el_OBSTETRI_BIRTH_WAY">
    <select
        id="x_BIRTH_WAY"
        name="x_BIRTH_WAY"
        class="form-control ew-select<?= $Page->BIRTH_WAY->isInvalidClass() ?>"
        data-select2-id="OBSTETRI_x_BIRTH_WAY"
        data-table="OBSTETRI"
        data-field="x_BIRTH_WAY"
        data-page="1"
        data-value-separator="<?= $Page->BIRTH_WAY->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->BIRTH_WAY->getPlaceHolder()) ?>"
        <?= $Page->BIRTH_WAY->editAttributes() ?>>
        <?= $Page->BIRTH_WAY->selectOptionListHtml("x_BIRTH_WAY") ?>
    </select>
    <?= $Page->BIRTH_WAY->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->BIRTH_WAY->getErrorMessage() ?></div>
<?= $Page->BIRTH_WAY->Lookup->getParamTag($Page, "p_x_BIRTH_WAY") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='OBSTETRI_x_BIRTH_WAY']"),
        options = { name: "x_BIRTH_WAY", selectId: "OBSTETRI_x_BIRTH_WAY", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.OBSTETRI.fields.BIRTH_WAY.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->BIRTH_BY->Visible) { // BIRTH_BY ?>
    <div id="r_BIRTH_BY" class="form-group row">
        <label id="elh_OBSTETRI_BIRTH_BY" for="x_BIRTH_BY" class="<?= $Page->LeftColumnClass ?>"><?= $Page->BIRTH_BY->caption() ?><?= $Page->BIRTH_BY->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->BIRTH_BY->cellAttributes() ?>>
<span id="el_OBSTETRI_BIRTH_BY">
    <select
        id="x_BIRTH_BY"
        name="x_BIRTH_BY"
        class="form-control ew-select<?= $Page->BIRTH_BY->isInvalidClass() ?>"
        data-select2-id="OBSTETRI_x_BIRTH_BY"
        data-table="OBSTETRI"
        data-field="x_BIRTH_BY"
        data-page="1"
        data-value-separator="<?= $Page->BIRTH_BY->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->BIRTH_BY->getPlaceHolder()) ?>"
        <?= $Page->BIRTH_BY->editAttributes() ?>>
        <?= $Page->BIRTH_BY->selectOptionListHtml("x_BIRTH_BY") ?>
    </select>
    <?= $Page->BIRTH_BY->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->BIRTH_BY->getErrorMessage() ?></div>
<?= $Page->BIRTH_BY->Lookup->getParamTag($Page, "p_x_BIRTH_BY") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='OBSTETRI_x_BIRTH_BY']"),
        options = { name: "x_BIRTH_BY", selectId: "OBSTETRI_x_BIRTH_BY", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.OBSTETRI.fields.BIRTH_BY.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->BIRTH_DATE->Visible) { // BIRTH_DATE ?>
    <div id="r_BIRTH_DATE" class="form-group row">
        <label id="elh_OBSTETRI_BIRTH_DATE" for="x_BIRTH_DATE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->BIRTH_DATE->caption() ?><?= $Page->BIRTH_DATE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->BIRTH_DATE->cellAttributes() ?>>
<span id="el_OBSTETRI_BIRTH_DATE">
<input type="<?= $Page->BIRTH_DATE->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_BIRTH_DATE" data-page="1" data-format="7" name="x_BIRTH_DATE" id="x_BIRTH_DATE" placeholder="<?= HtmlEncode($Page->BIRTH_DATE->getPlaceHolder()) ?>" value="<?= $Page->BIRTH_DATE->EditValue ?>"<?= $Page->BIRTH_DATE->editAttributes() ?> aria-describedby="x_BIRTH_DATE_help">
<?= $Page->BIRTH_DATE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->BIRTH_DATE->getErrorMessage() ?></div>
<?php if (!$Page->BIRTH_DATE->ReadOnly && !$Page->BIRTH_DATE->Disabled && !isset($Page->BIRTH_DATE->EditAttrs["readonly"]) && !isset($Page->BIRTH_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fOBSTETRIedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fOBSTETRIedit", "x_BIRTH_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":7});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->GESTASI->Visible) { // GESTASI ?>
    <div id="r_GESTASI" class="form-group row">
        <label id="elh_OBSTETRI_GESTASI" for="x_GESTASI" class="<?= $Page->LeftColumnClass ?>"><?= $Page->GESTASI->caption() ?><?= $Page->GESTASI->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->GESTASI->cellAttributes() ?>>
<span id="el_OBSTETRI_GESTASI">
<input type="<?= $Page->GESTASI->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_GESTASI" data-page="1" name="x_GESTASI" id="x_GESTASI" size="30" placeholder="<?= HtmlEncode($Page->GESTASI->getPlaceHolder()) ?>" value="<?= $Page->GESTASI->EditValue ?>"<?= $Page->GESTASI->editAttributes() ?> aria-describedby="x_GESTASI_help">
<?= $Page->GESTASI->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->GESTASI->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->PARITY->Visible) { // PARITY ?>
    <div id="r_PARITY" class="form-group row">
        <label id="elh_OBSTETRI_PARITY" for="x_PARITY" class="<?= $Page->LeftColumnClass ?>"><?= $Page->PARITY->caption() ?><?= $Page->PARITY->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PARITY->cellAttributes() ?>>
<span id="el_OBSTETRI_PARITY">
<input type="<?= $Page->PARITY->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_PARITY" data-page="1" name="x_PARITY" id="x_PARITY" size="30" placeholder="<?= HtmlEncode($Page->PARITY->getPlaceHolder()) ?>" value="<?= $Page->PARITY->EditValue ?>"<?= $Page->PARITY->editAttributes() ?> aria-describedby="x_PARITY_help">
<?= $Page->PARITY->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->PARITY->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->NB_BABY->Visible) { // NB_BABY ?>
    <div id="r_NB_BABY" class="form-group row">
        <label id="elh_OBSTETRI_NB_BABY" for="x_NB_BABY" class="<?= $Page->LeftColumnClass ?>"><?= $Page->NB_BABY->caption() ?><?= $Page->NB_BABY->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->NB_BABY->cellAttributes() ?>>
<span id="el_OBSTETRI_NB_BABY">
<input type="<?= $Page->NB_BABY->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_NB_BABY" data-page="1" name="x_NB_BABY" id="x_NB_BABY" size="30" placeholder="<?= HtmlEncode($Page->NB_BABY->getPlaceHolder()) ?>" value="<?= $Page->NB_BABY->EditValue ?>"<?= $Page->NB_BABY->editAttributes() ?> aria-describedby="x_NB_BABY_help">
<?= $Page->NB_BABY->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->NB_BABY->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->BABY_DIE->Visible) { // BABY_DIE ?>
    <div id="r_BABY_DIE" class="form-group row">
        <label id="elh_OBSTETRI_BABY_DIE" for="x_BABY_DIE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->BABY_DIE->caption() ?><?= $Page->BABY_DIE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->BABY_DIE->cellAttributes() ?>>
<span id="el_OBSTETRI_BABY_DIE">
<input type="<?= $Page->BABY_DIE->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_BABY_DIE" data-page="1" name="x_BABY_DIE" id="x_BABY_DIE" size="30" placeholder="<?= HtmlEncode($Page->BABY_DIE->getPlaceHolder()) ?>" value="<?= $Page->BABY_DIE->EditValue ?>"<?= $Page->BABY_DIE->editAttributes() ?> aria-describedby="x_BABY_DIE_help">
<?= $Page->BABY_DIE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->BABY_DIE->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->BLOODING->Visible) { // BLOODING ?>
    <div id="r_BLOODING" class="form-group row">
        <label id="elh_OBSTETRI_BLOODING" class="<?= $Page->LeftColumnClass ?>"><?= $Page->BLOODING->caption() ?><?= $Page->BLOODING->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->BLOODING->cellAttributes() ?>>
<span id="el_OBSTETRI_BLOODING">
<template id="tp_x_BLOODING">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="OBSTETRI" data-field="x_BLOODING" name="x_BLOODING" id="x_BLOODING"<?= $Page->BLOODING->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x_BLOODING" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x_BLOODING"
    name="x_BLOODING"
    value="<?= HtmlEncode($Page->BLOODING->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_BLOODING"
    data-target="dsl_x_BLOODING"
    data-repeatcolumn="5"
    class="form-control<?= $Page->BLOODING->isInvalidClass() ?>"
    data-table="OBSTETRI"
    data-field="x_BLOODING"
    data-page="1"
    data-value-separator="<?= $Page->BLOODING->displayValueSeparatorAttribute() ?>"
    <?= $Page->BLOODING->editAttributes() ?>>
<?= $Page->BLOODING->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->BLOODING->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->DESCRIPTION->Visible) { // DESCRIPTION ?>
    <div id="r_DESCRIPTION" class="form-group row">
        <label id="elh_OBSTETRI_DESCRIPTION" for="x_DESCRIPTION" class="<?= $Page->LeftColumnClass ?>"><?= $Page->DESCRIPTION->caption() ?><?= $Page->DESCRIPTION->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->DESCRIPTION->cellAttributes() ?>>
<span id="el_OBSTETRI_DESCRIPTION">
<input type="<?= $Page->DESCRIPTION->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_DESCRIPTION" data-page="1" name="x_DESCRIPTION" id="x_DESCRIPTION" size="30" maxlength="200" placeholder="<?= HtmlEncode($Page->DESCRIPTION->getPlaceHolder()) ?>" value="<?= $Page->DESCRIPTION->EditValue ?>"<?= $Page->DESCRIPTION->editAttributes() ?> aria-describedby="x_DESCRIPTION_help">
<?= $Page->DESCRIPTION->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->DESCRIPTION->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
        </div><!-- /multi-page .tab-pane -->
        <div class="tab-pane<?= $Page->MultiPages->pageStyle(2) ?>" id="tab_OBSTETRI2"><!-- multi-page .tab-pane -->
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->ABORTUS_KE->Visible) { // ABORTUS_KE ?>
    <div id="r_ABORTUS_KE" class="form-group row">
        <label id="elh_OBSTETRI_ABORTUS_KE" for="x_ABORTUS_KE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ABORTUS_KE->caption() ?><?= $Page->ABORTUS_KE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ABORTUS_KE->cellAttributes() ?>>
<span id="el_OBSTETRI_ABORTUS_KE">
<input type="<?= $Page->ABORTUS_KE->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_ABORTUS_KE" data-page="2" name="x_ABORTUS_KE" id="x_ABORTUS_KE" size="30" placeholder="<?= HtmlEncode($Page->ABORTUS_KE->getPlaceHolder()) ?>" value="<?= $Page->ABORTUS_KE->EditValue ?>"<?= $Page->ABORTUS_KE->editAttributes() ?> aria-describedby="x_ABORTUS_KE_help">
<?= $Page->ABORTUS_KE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ABORTUS_KE->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ABORTUS_ID->Visible) { // ABORTUS_ID ?>
    <div id="r_ABORTUS_ID" class="form-group row">
        <label id="elh_OBSTETRI_ABORTUS_ID" for="x_ABORTUS_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ABORTUS_ID->caption() ?><?= $Page->ABORTUS_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ABORTUS_ID->cellAttributes() ?>>
<span id="el_OBSTETRI_ABORTUS_ID">
    <select
        id="x_ABORTUS_ID"
        name="x_ABORTUS_ID"
        class="form-control ew-select<?= $Page->ABORTUS_ID->isInvalidClass() ?>"
        data-select2-id="OBSTETRI_x_ABORTUS_ID"
        data-table="OBSTETRI"
        data-field="x_ABORTUS_ID"
        data-page="2"
        data-value-separator="<?= $Page->ABORTUS_ID->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->ABORTUS_ID->getPlaceHolder()) ?>"
        <?= $Page->ABORTUS_ID->editAttributes() ?>>
        <?= $Page->ABORTUS_ID->selectOptionListHtml("x_ABORTUS_ID") ?>
    </select>
    <?= $Page->ABORTUS_ID->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->ABORTUS_ID->getErrorMessage() ?></div>
<?= $Page->ABORTUS_ID->Lookup->getParamTag($Page, "p_x_ABORTUS_ID") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='OBSTETRI_x_ABORTUS_ID']"),
        options = { name: "x_ABORTUS_ID", selectId: "OBSTETRI_x_ABORTUS_ID", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.OBSTETRI.fields.ABORTUS_ID.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ABORTION_DATE->Visible) { // ABORTION_DATE ?>
    <div id="r_ABORTION_DATE" class="form-group row">
        <label id="elh_OBSTETRI_ABORTION_DATE" for="x_ABORTION_DATE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ABORTION_DATE->caption() ?><?= $Page->ABORTION_DATE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ABORTION_DATE->cellAttributes() ?>>
<span id="el_OBSTETRI_ABORTION_DATE">
<input type="<?= $Page->ABORTION_DATE->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_ABORTION_DATE" data-page="2" name="x_ABORTION_DATE" id="x_ABORTION_DATE" placeholder="<?= HtmlEncode($Page->ABORTION_DATE->getPlaceHolder()) ?>" value="<?= $Page->ABORTION_DATE->EditValue ?>"<?= $Page->ABORTION_DATE->editAttributes() ?> aria-describedby="x_ABORTION_DATE_help">
<?= $Page->ABORTION_DATE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ABORTION_DATE->getErrorMessage() ?></div>
<?php if (!$Page->ABORTION_DATE->ReadOnly && !$Page->ABORTION_DATE->Disabled && !isset($Page->ABORTION_DATE->EditAttrs["readonly"]) && !isset($Page->ABORTION_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fOBSTETRIedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fOBSTETRIedit", "x_ABORTION_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->BIRTH_CAT->Visible) { // BIRTH_CAT ?>
    <div id="r_BIRTH_CAT" class="form-group row">
        <label id="elh_OBSTETRI_BIRTH_CAT" for="x_BIRTH_CAT" class="<?= $Page->LeftColumnClass ?>"><?= $Page->BIRTH_CAT->caption() ?><?= $Page->BIRTH_CAT->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->BIRTH_CAT->cellAttributes() ?>>
<span id="el_OBSTETRI_BIRTH_CAT">
<input type="<?= $Page->BIRTH_CAT->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_BIRTH_CAT" data-page="2" name="x_BIRTH_CAT" id="x_BIRTH_CAT" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->BIRTH_CAT->getPlaceHolder()) ?>" value="<?= $Page->BIRTH_CAT->EditValue ?>"<?= $Page->BIRTH_CAT->editAttributes() ?> aria-describedby="x_BIRTH_CAT_help">
<?= $Page->BIRTH_CAT->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->BIRTH_CAT->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->BIRTH_CON->Visible) { // BIRTH_CON ?>
    <div id="r_BIRTH_CON" class="form-group row">
        <label id="elh_OBSTETRI_BIRTH_CON" for="x_BIRTH_CON" class="<?= $Page->LeftColumnClass ?>"><?= $Page->BIRTH_CON->caption() ?><?= $Page->BIRTH_CON->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->BIRTH_CON->cellAttributes() ?>>
<span id="el_OBSTETRI_BIRTH_CON">
    <select
        id="x_BIRTH_CON"
        name="x_BIRTH_CON"
        class="form-control ew-select<?= $Page->BIRTH_CON->isInvalidClass() ?>"
        data-select2-id="OBSTETRI_x_BIRTH_CON"
        data-table="OBSTETRI"
        data-field="x_BIRTH_CON"
        data-page="2"
        data-value-separator="<?= $Page->BIRTH_CON->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->BIRTH_CON->getPlaceHolder()) ?>"
        <?= $Page->BIRTH_CON->editAttributes() ?>>
        <?= $Page->BIRTH_CON->selectOptionListHtml("x_BIRTH_CON") ?>
    </select>
    <?= $Page->BIRTH_CON->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->BIRTH_CON->getErrorMessage() ?></div>
<?= $Page->BIRTH_CON->Lookup->getParamTag($Page, "p_x_BIRTH_CON") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='OBSTETRI_x_BIRTH_CON']"),
        options = { name: "x_BIRTH_CON", selectId: "OBSTETRI_x_BIRTH_CON", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.OBSTETRI.fields.BIRTH_CON.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->BIRTH_RISK->Visible) { // BIRTH_RISK ?>
    <div id="r_BIRTH_RISK" class="form-group row">
        <label id="elh_OBSTETRI_BIRTH_RISK" for="x_BIRTH_RISK" class="<?= $Page->LeftColumnClass ?>"><?= $Page->BIRTH_RISK->caption() ?><?= $Page->BIRTH_RISK->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->BIRTH_RISK->cellAttributes() ?>>
<span id="el_OBSTETRI_BIRTH_RISK">
<input type="<?= $Page->BIRTH_RISK->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_BIRTH_RISK" data-page="2" name="x_BIRTH_RISK" id="x_BIRTH_RISK" size="30" placeholder="<?= HtmlEncode($Page->BIRTH_RISK->getPlaceHolder()) ?>" value="<?= $Page->BIRTH_RISK->EditValue ?>"<?= $Page->BIRTH_RISK->editAttributes() ?> aria-describedby="x_BIRTH_RISK_help">
<?= $Page->BIRTH_RISK->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->BIRTH_RISK->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->RISK_TYPE->Visible) { // RISK_TYPE ?>
    <div id="r_RISK_TYPE" class="form-group row">
        <label id="elh_OBSTETRI_RISK_TYPE" for="x_RISK_TYPE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->RISK_TYPE->caption() ?><?= $Page->RISK_TYPE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->RISK_TYPE->cellAttributes() ?>>
<span id="el_OBSTETRI_RISK_TYPE">
<input type="<?= $Page->RISK_TYPE->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_RISK_TYPE" data-page="2" name="x_RISK_TYPE" id="x_RISK_TYPE" size="30" placeholder="<?= HtmlEncode($Page->RISK_TYPE->getPlaceHolder()) ?>" value="<?= $Page->RISK_TYPE->EditValue ?>"<?= $Page->RISK_TYPE->editAttributes() ?> aria-describedby="x_RISK_TYPE_help">
<?= $Page->RISK_TYPE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->RISK_TYPE->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->FOLLOW_UP->Visible) { // FOLLOW_UP ?>
    <div id="r_FOLLOW_UP" class="form-group row">
        <label id="elh_OBSTETRI_FOLLOW_UP" for="x_FOLLOW_UP" class="<?= $Page->LeftColumnClass ?>"><?= $Page->FOLLOW_UP->caption() ?><?= $Page->FOLLOW_UP->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->FOLLOW_UP->cellAttributes() ?>>
<span id="el_OBSTETRI_FOLLOW_UP">
    <select
        id="x_FOLLOW_UP"
        name="x_FOLLOW_UP"
        class="form-control ew-select<?= $Page->FOLLOW_UP->isInvalidClass() ?>"
        data-select2-id="OBSTETRI_x_FOLLOW_UP"
        data-table="OBSTETRI"
        data-field="x_FOLLOW_UP"
        data-page="2"
        data-value-separator="<?= $Page->FOLLOW_UP->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->FOLLOW_UP->getPlaceHolder()) ?>"
        <?= $Page->FOLLOW_UP->editAttributes() ?>>
        <?= $Page->FOLLOW_UP->selectOptionListHtml("x_FOLLOW_UP") ?>
    </select>
    <?= $Page->FOLLOW_UP->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->FOLLOW_UP->getErrorMessage() ?></div>
<?= $Page->FOLLOW_UP->Lookup->getParamTag($Page, "p_x_FOLLOW_UP") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='OBSTETRI_x_FOLLOW_UP']"),
        options = { name: "x_FOLLOW_UP", selectId: "OBSTETRI_x_FOLLOW_UP", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.OBSTETRI.fields.FOLLOW_UP.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->DIRUJUK_OLEH->Visible) { // DIRUJUK_OLEH ?>
    <div id="r_DIRUJUK_OLEH" class="form-group row">
        <label id="elh_OBSTETRI_DIRUJUK_OLEH" for="x_DIRUJUK_OLEH" class="<?= $Page->LeftColumnClass ?>"><?= $Page->DIRUJUK_OLEH->caption() ?><?= $Page->DIRUJUK_OLEH->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->DIRUJUK_OLEH->cellAttributes() ?>>
<span id="el_OBSTETRI_DIRUJUK_OLEH">
    <select
        id="x_DIRUJUK_OLEH"
        name="x_DIRUJUK_OLEH"
        class="form-control ew-select<?= $Page->DIRUJUK_OLEH->isInvalidClass() ?>"
        data-select2-id="OBSTETRI_x_DIRUJUK_OLEH"
        data-table="OBSTETRI"
        data-field="x_DIRUJUK_OLEH"
        data-page="2"
        data-value-separator="<?= $Page->DIRUJUK_OLEH->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->DIRUJUK_OLEH->getPlaceHolder()) ?>"
        <?= $Page->DIRUJUK_OLEH->editAttributes() ?>>
        <?= $Page->DIRUJUK_OLEH->selectOptionListHtml("x_DIRUJUK_OLEH") ?>
    </select>
    <?= $Page->DIRUJUK_OLEH->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->DIRUJUK_OLEH->getErrorMessage() ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='OBSTETRI_x_DIRUJUK_OLEH']"),
        options = { name: "x_DIRUJUK_OLEH", selectId: "OBSTETRI_x_DIRUJUK_OLEH", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.data = ew.vars.tables.OBSTETRI.fields.DIRUJUK_OLEH.lookupOptions;
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.OBSTETRI.fields.DIRUJUK_OLEH.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
        </div><!-- /multi-page .tab-pane -->
        <div class="tab-pane<?= $Page->MultiPages->pageStyle(3) ?>" id="tab_OBSTETRI3"><!-- multi-page .tab-pane -->
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->INSPECTION_DATE->Visible) { // INSPECTION_DATE ?>
    <div id="r_INSPECTION_DATE" class="form-group row">
        <label id="elh_OBSTETRI_INSPECTION_DATE" for="x_INSPECTION_DATE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->INSPECTION_DATE->caption() ?><?= $Page->INSPECTION_DATE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->INSPECTION_DATE->cellAttributes() ?>>
<span id="el_OBSTETRI_INSPECTION_DATE">
<input type="<?= $Page->INSPECTION_DATE->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_INSPECTION_DATE" data-page="3" data-format="11" name="x_INSPECTION_DATE" id="x_INSPECTION_DATE" placeholder="<?= HtmlEncode($Page->INSPECTION_DATE->getPlaceHolder()) ?>" value="<?= $Page->INSPECTION_DATE->EditValue ?>"<?= $Page->INSPECTION_DATE->editAttributes() ?> aria-describedby="x_INSPECTION_DATE_help">
<?= $Page->INSPECTION_DATE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->INSPECTION_DATE->getErrorMessage() ?></div>
<?php if (!$Page->INSPECTION_DATE->ReadOnly && !$Page->INSPECTION_DATE->Disabled && !isset($Page->INSPECTION_DATE->EditAttrs["readonly"]) && !isset($Page->INSPECTION_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fOBSTETRIedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fOBSTETRIedit", "x_INSPECTION_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":11});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->PORSIO->Visible) { // PORSIO ?>
    <div id="r_PORSIO" class="form-group row">
        <label id="elh_OBSTETRI_PORSIO" for="x_PORSIO" class="<?= $Page->LeftColumnClass ?>"><?= $Page->PORSIO->caption() ?><?= $Page->PORSIO->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PORSIO->cellAttributes() ?>>
<span id="el_OBSTETRI_PORSIO">
<input type="<?= $Page->PORSIO->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_PORSIO" data-page="3" name="x_PORSIO" id="x_PORSIO" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->PORSIO->getPlaceHolder()) ?>" value="<?= $Page->PORSIO->EditValue ?>"<?= $Page->PORSIO->editAttributes() ?> aria-describedby="x_PORSIO_help">
<?= $Page->PORSIO->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->PORSIO->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->PEMBUKAAN->Visible) { // PEMBUKAAN ?>
    <div id="r_PEMBUKAAN" class="form-group row">
        <label id="elh_OBSTETRI_PEMBUKAAN" for="x_PEMBUKAAN" class="<?= $Page->LeftColumnClass ?>"><?= $Page->PEMBUKAAN->caption() ?><?= $Page->PEMBUKAAN->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PEMBUKAAN->cellAttributes() ?>>
<span id="el_OBSTETRI_PEMBUKAAN">
<input type="<?= $Page->PEMBUKAAN->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_PEMBUKAAN" data-page="3" name="x_PEMBUKAAN" id="x_PEMBUKAAN" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->PEMBUKAAN->getPlaceHolder()) ?>" value="<?= $Page->PEMBUKAAN->EditValue ?>"<?= $Page->PEMBUKAAN->editAttributes() ?> aria-describedby="x_PEMBUKAAN_help">
<?= $Page->PEMBUKAAN->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->PEMBUKAAN->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->KETUBAN->Visible) { // KETUBAN ?>
    <div id="r_KETUBAN" class="form-group row">
        <label id="elh_OBSTETRI_KETUBAN" for="x_KETUBAN" class="<?= $Page->LeftColumnClass ?>"><?= $Page->KETUBAN->caption() ?><?= $Page->KETUBAN->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->KETUBAN->cellAttributes() ?>>
<span id="el_OBSTETRI_KETUBAN">
<input type="<?= $Page->KETUBAN->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_KETUBAN" data-page="3" name="x_KETUBAN" id="x_KETUBAN" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->KETUBAN->getPlaceHolder()) ?>" value="<?= $Page->KETUBAN->EditValue ?>"<?= $Page->KETUBAN->editAttributes() ?> aria-describedby="x_KETUBAN_help">
<?= $Page->KETUBAN->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->KETUBAN->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->PRESENTASI->Visible) { // PRESENTASI ?>
    <div id="r_PRESENTASI" class="form-group row">
        <label id="elh_OBSTETRI_PRESENTASI" for="x_PRESENTASI" class="<?= $Page->LeftColumnClass ?>"><?= $Page->PRESENTASI->caption() ?><?= $Page->PRESENTASI->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PRESENTASI->cellAttributes() ?>>
<span id="el_OBSTETRI_PRESENTASI">
<input type="<?= $Page->PRESENTASI->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_PRESENTASI" data-page="3" name="x_PRESENTASI" id="x_PRESENTASI" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->PRESENTASI->getPlaceHolder()) ?>" value="<?= $Page->PRESENTASI->EditValue ?>"<?= $Page->PRESENTASI->editAttributes() ?> aria-describedby="x_PRESENTASI_help">
<?= $Page->PRESENTASI->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->PRESENTASI->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->POSISI->Visible) { // POSISI ?>
    <div id="r_POSISI" class="form-group row">
        <label id="elh_OBSTETRI_POSISI" for="x_POSISI" class="<?= $Page->LeftColumnClass ?>"><?= $Page->POSISI->caption() ?><?= $Page->POSISI->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->POSISI->cellAttributes() ?>>
<span id="el_OBSTETRI_POSISI">
<input type="<?= $Page->POSISI->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_POSISI" data-page="3" name="x_POSISI" id="x_POSISI" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->POSISI->getPlaceHolder()) ?>" value="<?= $Page->POSISI->EditValue ?>"<?= $Page->POSISI->editAttributes() ?> aria-describedby="x_POSISI_help">
<?= $Page->POSISI->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->POSISI->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->PENURUNAN->Visible) { // PENURUNAN ?>
    <div id="r_PENURUNAN" class="form-group row">
        <label id="elh_OBSTETRI_PENURUNAN" for="x_PENURUNAN" class="<?= $Page->LeftColumnClass ?>"><?= $Page->PENURUNAN->caption() ?><?= $Page->PENURUNAN->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PENURUNAN->cellAttributes() ?>>
<span id="el_OBSTETRI_PENURUNAN">
<input type="<?= $Page->PENURUNAN->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_PENURUNAN" data-page="3" name="x_PENURUNAN" id="x_PENURUNAN" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->PENURUNAN->getPlaceHolder()) ?>" value="<?= $Page->PENURUNAN->EditValue ?>"<?= $Page->PENURUNAN->editAttributes() ?> aria-describedby="x_PENURUNAN_help">
<?= $Page->PENURUNAN->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->PENURUNAN->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->PLACENTA->Visible) { // PLACENTA ?>
    <div id="r_PLACENTA" class="form-group row">
        <label id="elh_OBSTETRI_PLACENTA" for="x_PLACENTA" class="<?= $Page->LeftColumnClass ?>"><?= $Page->PLACENTA->caption() ?><?= $Page->PLACENTA->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PLACENTA->cellAttributes() ?>>
<span id="el_OBSTETRI_PLACENTA">
<input type="<?= $Page->PLACENTA->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_PLACENTA" data-page="3" name="x_PLACENTA" id="x_PLACENTA" size="30" maxlength="1" placeholder="<?= HtmlEncode($Page->PLACENTA->getPlaceHolder()) ?>" value="<?= $Page->PLACENTA->EditValue ?>"<?= $Page->PLACENTA->editAttributes() ?> aria-describedby="x_PLACENTA_help">
<?= $Page->PLACENTA->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->PLACENTA->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->RAHIM_ID->Visible) { // RAHIM_ID ?>
    <div id="r_RAHIM_ID" class="form-group row">
        <label id="elh_OBSTETRI_RAHIM_ID" for="x_RAHIM_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->RAHIM_ID->caption() ?><?= $Page->RAHIM_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->RAHIM_ID->cellAttributes() ?>>
<span id="el_OBSTETRI_RAHIM_ID">
    <select
        id="x_RAHIM_ID"
        name="x_RAHIM_ID"
        class="form-control ew-select<?= $Page->RAHIM_ID->isInvalidClass() ?>"
        data-select2-id="OBSTETRI_x_RAHIM_ID"
        data-table="OBSTETRI"
        data-field="x_RAHIM_ID"
        data-page="3"
        data-value-separator="<?= $Page->RAHIM_ID->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->RAHIM_ID->getPlaceHolder()) ?>"
        <?= $Page->RAHIM_ID->editAttributes() ?>>
        <?= $Page->RAHIM_ID->selectOptionListHtml("x_RAHIM_ID") ?>
    </select>
    <?= $Page->RAHIM_ID->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->RAHIM_ID->getErrorMessage() ?></div>
<?= $Page->RAHIM_ID->Lookup->getParamTag($Page, "p_x_RAHIM_ID") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='OBSTETRI_x_RAHIM_ID']"),
        options = { name: "x_RAHIM_ID", selectId: "OBSTETRI_x_RAHIM_ID", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.OBSTETRI.fields.RAHIM_ID.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
        </div><!-- /multi-page .tab-pane -->
    </div><!-- /multi-page tabs .tab-content -->
</div><!-- /multi-page tabs -->
</div><!-- /multi-page -->
    <input type="hidden" data-table="OBSTETRI" data-field="x_OBSTETRI_ID" data-hidden="1" name="x_OBSTETRI_ID" id="x_OBSTETRI_ID" value="<?= HtmlEncode($Page->OBSTETRI_ID->CurrentValue) ?>">
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
    ew.addEventHandlers("OBSTETRI");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
