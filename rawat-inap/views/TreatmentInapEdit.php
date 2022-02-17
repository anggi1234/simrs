<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

// Page object
$TreatmentInapEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fTREATMENT_INAPedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fTREATMENT_INAPedit = currentForm = new ew.Form("fTREATMENT_INAPedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "TREATMENT_INAP")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.TREATMENT_INAP)
        ew.vars.tables.TREATMENT_INAP = currentTable;
    fTREATMENT_INAPedit.addFields([
        ["VISIT_ID", [fields.VISIT_ID.visible && fields.VISIT_ID.required ? ew.Validators.required(fields.VISIT_ID.caption) : null], fields.VISIT_ID.isInvalid],
        ["TARIF_ID", [fields.TARIF_ID.visible && fields.TARIF_ID.required ? ew.Validators.required(fields.TARIF_ID.caption) : null], fields.TARIF_ID.isInvalid],
        ["CLINIC_ID", [fields.CLINIC_ID.visible && fields.CLINIC_ID.required ? ew.Validators.required(fields.CLINIC_ID.caption) : null], fields.CLINIC_ID.isInvalid],
        ["TREATMENT", [fields.TREATMENT.visible && fields.TREATMENT.required ? ew.Validators.required(fields.TREATMENT.caption) : null], fields.TREATMENT.isInvalid],
        ["QUANTITY", [fields.QUANTITY.visible && fields.QUANTITY.required ? ew.Validators.required(fields.QUANTITY.caption) : null, ew.Validators.float], fields.QUANTITY.isInvalid],
        ["TRANS_ID", [fields.TRANS_ID.visible && fields.TRANS_ID.required ? ew.Validators.required(fields.TRANS_ID.caption) : null], fields.TRANS_ID.isInvalid],
        ["ID", [fields.ID.visible && fields.ID.required ? ew.Validators.required(fields.ID.caption) : null], fields.ID.isInvalid],
        ["AMOUNT", [fields.AMOUNT.visible && fields.AMOUNT.required ? ew.Validators.required(fields.AMOUNT.caption) : null, ew.Validators.float], fields.AMOUNT.isInvalid],
        ["POKOK_JUAL", [fields.POKOK_JUAL.visible && fields.POKOK_JUAL.required ? ew.Validators.required(fields.POKOK_JUAL.caption) : null, ew.Validators.float], fields.POKOK_JUAL.isInvalid],
        ["PPN", [fields.PPN.visible && fields.PPN.required ? ew.Validators.required(fields.PPN.caption) : null, ew.Validators.float], fields.PPN.isInvalid],
        ["SUBSIDI", [fields.SUBSIDI.visible && fields.SUBSIDI.required ? ew.Validators.required(fields.SUBSIDI.caption) : null, ew.Validators.float], fields.SUBSIDI.isInvalid],
        ["PRINT_DATE", [fields.PRINT_DATE.visible && fields.PRINT_DATE.required ? ew.Validators.required(fields.PRINT_DATE.caption) : null, ew.Validators.datetime(0)], fields.PRINT_DATE.isInvalid],
        ["ISCETAK", [fields.ISCETAK.visible && fields.ISCETAK.required ? ew.Validators.required(fields.ISCETAK.caption) : null], fields.ISCETAK.isInvalid],
        ["NOTA_NO", [fields.NOTA_NO.visible && fields.NOTA_NO.required ? ew.Validators.required(fields.NOTA_NO.caption) : null], fields.NOTA_NO.isInvalid],
        ["KUITANSI_ID", [fields.KUITANSI_ID.visible && fields.KUITANSI_ID.required ? ew.Validators.required(fields.KUITANSI_ID.caption) : null], fields.KUITANSI_ID.isInvalid],
        ["amount_paid", [fields.amount_paid.visible && fields.amount_paid.required ? ew.Validators.required(fields.amount_paid.caption) : null, ew.Validators.float], fields.amount_paid.isInvalid],
        ["sell_price", [fields.sell_price.visible && fields.sell_price.required ? ew.Validators.required(fields.sell_price.caption) : null, ew.Validators.float], fields.sell_price.isInvalid],
        ["diskon", [fields.diskon.visible && fields.diskon.required ? ew.Validators.required(fields.diskon.caption) : null, ew.Validators.float], fields.diskon.isInvalid],
        ["TAGIHAN", [fields.TAGIHAN.visible && fields.TAGIHAN.required ? ew.Validators.required(fields.TAGIHAN.caption) : null, ew.Validators.float], fields.TAGIHAN.isInvalid],
        ["ID_1", [fields.ID_1.visible && fields.ID_1.required ? ew.Validators.required(fields.ID_1.caption) : null], fields.ID_1.isInvalid],
        ["MEASURE_ID", [fields.MEASURE_ID.visible && fields.MEASURE_ID.required ? ew.Validators.required(fields.MEASURE_ID.caption) : null, ew.Validators.integer], fields.MEASURE_ID.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fTREATMENT_INAPedit,
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
    fTREATMENT_INAPedit.validate = function () {
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
    fTREATMENT_INAPedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fTREATMENT_INAPedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fTREATMENT_INAPedit.lists.TARIF_ID = <?= $Page->TARIF_ID->toClientList($Page) ?>;
    loadjs.done("fTREATMENT_INAPedit");
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
<form name="fTREATMENT_INAPedit" id="fTREATMENT_INAPedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="TREATMENT_INAP">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "PASIEN_VISITATION") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="PASIEN_VISITATION">
<input type="hidden" name="fk_VISIT_ID" value="<?= HtmlEncode($Page->VISIT_ID->getSessionValue()) ?>">
<input type="hidden" name="fk_NO_REGISTRATION" value="<?= HtmlEncode($Page->NO_REGISTRATION->getSessionValue()) ?>">
<input type="hidden" name="fk_TRANS_ID" value="<?= HtmlEncode($Page->TRANS_ID->getSessionValue()) ?>">
<input type="hidden" name="fk_DIANTAR_OLEH" value="<?= HtmlEncode($Page->THENAME->getSessionValue()) ?>">
<input type="hidden" name="fk_VISITOR_ADDRESS" value="<?= HtmlEncode($Page->THEADDRESS->getSessionValue()) ?>">
<?php } ?>
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->TARIF_ID->Visible) { // TARIF_ID ?>
    <div id="r_TARIF_ID" class="form-group row">
        <label id="elh_TREATMENT_INAP_TARIF_ID" for="x_TARIF_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->TARIF_ID->caption() ?><?= $Page->TARIF_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->TARIF_ID->cellAttributes() ?>>
<span id="el_TREATMENT_INAP_TARIF_ID">
<?php $Page->TARIF_ID->EditAttrs->prepend("onchange", "ew.autoFill(this);"); ?>
<div class="input-group ew-lookup-list" aria-describedby="x_TARIF_ID_help">
    <div class="form-control ew-lookup-text" tabindex="-1" id="lu_x_TARIF_ID"><?= EmptyValue(strval($Page->TARIF_ID->ViewValue)) ? $Language->phrase("PleaseSelect") : $Page->TARIF_ID->ViewValue ?></div>
    <div class="input-group-append">
        <button type="button" title="<?= HtmlEncode(str_replace("%s", RemoveHtml($Page->TARIF_ID->caption()), $Language->phrase("LookupLink", true))) ?>" class="ew-lookup-btn btn btn-default"<?= ($Page->TARIF_ID->ReadOnly || $Page->TARIF_ID->Disabled) ? " disabled" : "" ?> onclick="ew.modalLookupShow({lnk:this,el:'x_TARIF_ID',m:0,n:10});"><i class="fas fa-search ew-icon"></i></button>
    </div>
</div>
<div class="invalid-feedback"><?= $Page->TARIF_ID->getErrorMessage() ?></div>
<?= $Page->TARIF_ID->getCustomMessage() ?>
<?= $Page->TARIF_ID->Lookup->getParamTag($Page, "p_x_TARIF_ID") ?>
<input type="hidden" is="selection-list" data-table="TREATMENT_INAP" data-field="x_TARIF_ID" data-type="text" data-multiple="0" data-lookup="1" data-value-separator="<?= $Page->TARIF_ID->displayValueSeparatorAttribute() ?>" name="x_TARIF_ID" id="x_TARIF_ID" value="<?= $Page->TARIF_ID->CurrentValue ?>"<?= $Page->TARIF_ID->editAttributes() ?>>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->CLINIC_ID->Visible) { // CLINIC_ID ?>
    <div id="r_CLINIC_ID" class="form-group row">
        <label id="elh_TREATMENT_INAP_CLINIC_ID" for="x_CLINIC_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->CLINIC_ID->caption() ?><?= $Page->CLINIC_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->CLINIC_ID->cellAttributes() ?>>
<span id="el_TREATMENT_INAP_CLINIC_ID">
<span<?= $Page->CLINIC_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->CLINIC_ID->getDisplayValue($Page->CLINIC_ID->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_CLINIC_ID" data-hidden="1" name="x_CLINIC_ID" id="x_CLINIC_ID" value="<?= HtmlEncode($Page->CLINIC_ID->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->TREATMENT->Visible) { // TREATMENT ?>
    <div id="r_TREATMENT" class="form-group row">
        <label id="elh_TREATMENT_INAP_TREATMENT" for="x_TREATMENT" class="<?= $Page->LeftColumnClass ?>"><?= $Page->TREATMENT->caption() ?><?= $Page->TREATMENT->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->TREATMENT->cellAttributes() ?>>
<span id="el_TREATMENT_INAP_TREATMENT">
<input type="<?= $Page->TREATMENT->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_TREATMENT" name="x_TREATMENT" id="x_TREATMENT" size="30" maxlength="200" placeholder="<?= HtmlEncode($Page->TREATMENT->getPlaceHolder()) ?>" value="<?= $Page->TREATMENT->EditValue ?>"<?= $Page->TREATMENT->editAttributes() ?> aria-describedby="x_TREATMENT_help">
<?= $Page->TREATMENT->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->TREATMENT->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->QUANTITY->Visible) { // QUANTITY ?>
    <div id="r_QUANTITY" class="form-group row">
        <label id="elh_TREATMENT_INAP_QUANTITY" for="x_QUANTITY" class="<?= $Page->LeftColumnClass ?>"><?= $Page->QUANTITY->caption() ?><?= $Page->QUANTITY->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->QUANTITY->cellAttributes() ?>>
<span id="el_TREATMENT_INAP_QUANTITY">
<input type="<?= $Page->QUANTITY->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_QUANTITY" name="x_QUANTITY" id="x_QUANTITY" size="30" placeholder="<?= HtmlEncode($Page->QUANTITY->getPlaceHolder()) ?>" value="<?= $Page->QUANTITY->EditValue ?>"<?= $Page->QUANTITY->editAttributes() ?> aria-describedby="x_QUANTITY_help">
<?= $Page->QUANTITY->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->QUANTITY->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->TRANS_ID->Visible) { // TRANS_ID ?>
    <div id="r_TRANS_ID" class="form-group row">
        <label id="elh_TREATMENT_INAP_TRANS_ID" for="x_TRANS_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->TRANS_ID->caption() ?><?= $Page->TRANS_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->TRANS_ID->cellAttributes() ?>>
<?php if ($Page->TRANS_ID->getSessionValue() != "") { ?>
<span id="el_TREATMENT_INAP_TRANS_ID">
<span<?= $Page->TRANS_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->TRANS_ID->getDisplayValue($Page->TRANS_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x_TRANS_ID" name="x_TRANS_ID" value="<?= HtmlEncode($Page->TRANS_ID->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_TREATMENT_INAP_TRANS_ID">
<input type="<?= $Page->TRANS_ID->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_TRANS_ID" name="x_TRANS_ID" id="x_TRANS_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->TRANS_ID->getPlaceHolder()) ?>" value="<?= $Page->TRANS_ID->EditValue ?>"<?= $Page->TRANS_ID->editAttributes() ?> aria-describedby="x_TRANS_ID_help">
<?= $Page->TRANS_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->TRANS_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ID->Visible) { // ID ?>
    <div id="r_ID" class="form-group row">
        <label id="elh_TREATMENT_INAP_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ID->caption() ?><?= $Page->ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ID->cellAttributes() ?>>
<span id="el_TREATMENT_INAP_ID">
<span<?= $Page->ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->ID->getDisplayValue($Page->ID->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_ID" data-hidden="1" name="x_ID" id="x_ID" value="<?= HtmlEncode($Page->ID->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->AMOUNT->Visible) { // AMOUNT ?>
    <div id="r_AMOUNT" class="form-group row">
        <label id="elh_TREATMENT_INAP_AMOUNT" for="x_AMOUNT" class="<?= $Page->LeftColumnClass ?>"><?= $Page->AMOUNT->caption() ?><?= $Page->AMOUNT->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->AMOUNT->cellAttributes() ?>>
<span id="el_TREATMENT_INAP_AMOUNT">
<input type="<?= $Page->AMOUNT->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_AMOUNT" name="x_AMOUNT" id="x_AMOUNT" size="30" placeholder="<?= HtmlEncode($Page->AMOUNT->getPlaceHolder()) ?>" value="<?= $Page->AMOUNT->EditValue ?>"<?= $Page->AMOUNT->editAttributes() ?> aria-describedby="x_AMOUNT_help">
<?= $Page->AMOUNT->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->AMOUNT->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->POKOK_JUAL->Visible) { // POKOK_JUAL ?>
    <div id="r_POKOK_JUAL" class="form-group row">
        <label id="elh_TREATMENT_INAP_POKOK_JUAL" for="x_POKOK_JUAL" class="<?= $Page->LeftColumnClass ?>"><?= $Page->POKOK_JUAL->caption() ?><?= $Page->POKOK_JUAL->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->POKOK_JUAL->cellAttributes() ?>>
<span id="el_TREATMENT_INAP_POKOK_JUAL">
<input type="<?= $Page->POKOK_JUAL->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_POKOK_JUAL" name="x_POKOK_JUAL" id="x_POKOK_JUAL" size="30" placeholder="<?= HtmlEncode($Page->POKOK_JUAL->getPlaceHolder()) ?>" value="<?= $Page->POKOK_JUAL->EditValue ?>"<?= $Page->POKOK_JUAL->editAttributes() ?> aria-describedby="x_POKOK_JUAL_help">
<?= $Page->POKOK_JUAL->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->POKOK_JUAL->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->PPN->Visible) { // PPN ?>
    <div id="r_PPN" class="form-group row">
        <label id="elh_TREATMENT_INAP_PPN" for="x_PPN" class="<?= $Page->LeftColumnClass ?>"><?= $Page->PPN->caption() ?><?= $Page->PPN->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PPN->cellAttributes() ?>>
<span id="el_TREATMENT_INAP_PPN">
<input type="<?= $Page->PPN->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_PPN" name="x_PPN" id="x_PPN" size="30" placeholder="<?= HtmlEncode($Page->PPN->getPlaceHolder()) ?>" value="<?= $Page->PPN->EditValue ?>"<?= $Page->PPN->editAttributes() ?> aria-describedby="x_PPN_help">
<?= $Page->PPN->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->PPN->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->SUBSIDI->Visible) { // SUBSIDI ?>
    <div id="r_SUBSIDI" class="form-group row">
        <label id="elh_TREATMENT_INAP_SUBSIDI" for="x_SUBSIDI" class="<?= $Page->LeftColumnClass ?>"><?= $Page->SUBSIDI->caption() ?><?= $Page->SUBSIDI->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->SUBSIDI->cellAttributes() ?>>
<span id="el_TREATMENT_INAP_SUBSIDI">
<input type="<?= $Page->SUBSIDI->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_SUBSIDI" name="x_SUBSIDI" id="x_SUBSIDI" size="30" placeholder="<?= HtmlEncode($Page->SUBSIDI->getPlaceHolder()) ?>" value="<?= $Page->SUBSIDI->EditValue ?>"<?= $Page->SUBSIDI->editAttributes() ?> aria-describedby="x_SUBSIDI_help">
<?= $Page->SUBSIDI->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->SUBSIDI->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->PRINT_DATE->Visible) { // PRINT_DATE ?>
    <div id="r_PRINT_DATE" class="form-group row">
        <label id="elh_TREATMENT_INAP_PRINT_DATE" for="x_PRINT_DATE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->PRINT_DATE->caption() ?><?= $Page->PRINT_DATE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PRINT_DATE->cellAttributes() ?>>
<span id="el_TREATMENT_INAP_PRINT_DATE">
<input type="<?= $Page->PRINT_DATE->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_PRINT_DATE" name="x_PRINT_DATE" id="x_PRINT_DATE" placeholder="<?= HtmlEncode($Page->PRINT_DATE->getPlaceHolder()) ?>" value="<?= $Page->PRINT_DATE->EditValue ?>"<?= $Page->PRINT_DATE->editAttributes() ?> aria-describedby="x_PRINT_DATE_help">
<?= $Page->PRINT_DATE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->PRINT_DATE->getErrorMessage() ?></div>
<?php if (!$Page->PRINT_DATE->ReadOnly && !$Page->PRINT_DATE->Disabled && !isset($Page->PRINT_DATE->EditAttrs["readonly"]) && !isset($Page->PRINT_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fTREATMENT_INAPedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fTREATMENT_INAPedit", "x_PRINT_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ISCETAK->Visible) { // ISCETAK ?>
    <div id="r_ISCETAK" class="form-group row">
        <label id="elh_TREATMENT_INAP_ISCETAK" for="x_ISCETAK" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ISCETAK->caption() ?><?= $Page->ISCETAK->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ISCETAK->cellAttributes() ?>>
<span id="el_TREATMENT_INAP_ISCETAK">
<input type="<?= $Page->ISCETAK->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_ISCETAK" name="x_ISCETAK" id="x_ISCETAK" size="30" maxlength="1" placeholder="<?= HtmlEncode($Page->ISCETAK->getPlaceHolder()) ?>" value="<?= $Page->ISCETAK->EditValue ?>"<?= $Page->ISCETAK->editAttributes() ?> aria-describedby="x_ISCETAK_help">
<?= $Page->ISCETAK->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ISCETAK->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->NOTA_NO->Visible) { // NOTA_NO ?>
    <div id="r_NOTA_NO" class="form-group row">
        <label id="elh_TREATMENT_INAP_NOTA_NO" for="x_NOTA_NO" class="<?= $Page->LeftColumnClass ?>"><?= $Page->NOTA_NO->caption() ?><?= $Page->NOTA_NO->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->NOTA_NO->cellAttributes() ?>>
<span id="el_TREATMENT_INAP_NOTA_NO">
<input type="<?= $Page->NOTA_NO->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_NOTA_NO" name="x_NOTA_NO" id="x_NOTA_NO" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->NOTA_NO->getPlaceHolder()) ?>" value="<?= $Page->NOTA_NO->EditValue ?>"<?= $Page->NOTA_NO->editAttributes() ?> aria-describedby="x_NOTA_NO_help">
<?= $Page->NOTA_NO->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->NOTA_NO->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->KUITANSI_ID->Visible) { // KUITANSI_ID ?>
    <div id="r_KUITANSI_ID" class="form-group row">
        <label id="elh_TREATMENT_INAP_KUITANSI_ID" for="x_KUITANSI_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->KUITANSI_ID->caption() ?><?= $Page->KUITANSI_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->KUITANSI_ID->cellAttributes() ?>>
<span id="el_TREATMENT_INAP_KUITANSI_ID">
<input type="<?= $Page->KUITANSI_ID->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_KUITANSI_ID" name="x_KUITANSI_ID" id="x_KUITANSI_ID" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->KUITANSI_ID->getPlaceHolder()) ?>" value="<?= $Page->KUITANSI_ID->EditValue ?>"<?= $Page->KUITANSI_ID->editAttributes() ?> aria-describedby="x_KUITANSI_ID_help">
<?= $Page->KUITANSI_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->KUITANSI_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->amount_paid->Visible) { // amount_paid ?>
    <div id="r_amount_paid" class="form-group row">
        <label id="elh_TREATMENT_INAP_amount_paid" for="x_amount_paid" class="<?= $Page->LeftColumnClass ?>"><?= $Page->amount_paid->caption() ?><?= $Page->amount_paid->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->amount_paid->cellAttributes() ?>>
<span id="el_TREATMENT_INAP_amount_paid">
<input type="<?= $Page->amount_paid->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_amount_paid" name="x_amount_paid" id="x_amount_paid" size="30" placeholder="<?= HtmlEncode($Page->amount_paid->getPlaceHolder()) ?>" value="<?= $Page->amount_paid->EditValue ?>"<?= $Page->amount_paid->editAttributes() ?> aria-describedby="x_amount_paid_help">
<?= $Page->amount_paid->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->amount_paid->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->sell_price->Visible) { // sell_price ?>
    <div id="r_sell_price" class="form-group row">
        <label id="elh_TREATMENT_INAP_sell_price" for="x_sell_price" class="<?= $Page->LeftColumnClass ?>"><?= $Page->sell_price->caption() ?><?= $Page->sell_price->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->sell_price->cellAttributes() ?>>
<span id="el_TREATMENT_INAP_sell_price">
<input type="<?= $Page->sell_price->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_sell_price" name="x_sell_price" id="x_sell_price" size="30" placeholder="<?= HtmlEncode($Page->sell_price->getPlaceHolder()) ?>" value="<?= $Page->sell_price->EditValue ?>"<?= $Page->sell_price->editAttributes() ?> aria-describedby="x_sell_price_help">
<?= $Page->sell_price->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->sell_price->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->diskon->Visible) { // diskon ?>
    <div id="r_diskon" class="form-group row">
        <label id="elh_TREATMENT_INAP_diskon" for="x_diskon" class="<?= $Page->LeftColumnClass ?>"><?= $Page->diskon->caption() ?><?= $Page->diskon->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->diskon->cellAttributes() ?>>
<span id="el_TREATMENT_INAP_diskon">
<input type="<?= $Page->diskon->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_diskon" name="x_diskon" id="x_diskon" size="30" placeholder="<?= HtmlEncode($Page->diskon->getPlaceHolder()) ?>" value="<?= $Page->diskon->EditValue ?>"<?= $Page->diskon->editAttributes() ?> aria-describedby="x_diskon_help">
<?= $Page->diskon->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->diskon->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->TAGIHAN->Visible) { // TAGIHAN ?>
    <div id="r_TAGIHAN" class="form-group row">
        <label id="elh_TREATMENT_INAP_TAGIHAN" for="x_TAGIHAN" class="<?= $Page->LeftColumnClass ?>"><?= $Page->TAGIHAN->caption() ?><?= $Page->TAGIHAN->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->TAGIHAN->cellAttributes() ?>>
<span id="el_TREATMENT_INAP_TAGIHAN">
<input type="<?= $Page->TAGIHAN->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_TAGIHAN" name="x_TAGIHAN" id="x_TAGIHAN" size="30" placeholder="<?= HtmlEncode($Page->TAGIHAN->getPlaceHolder()) ?>" value="<?= $Page->TAGIHAN->EditValue ?>"<?= $Page->TAGIHAN->editAttributes() ?> aria-describedby="x_TAGIHAN_help">
<?= $Page->TAGIHAN->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->TAGIHAN->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ID_1->Visible) { // ID_1 ?>
    <div id="r_ID_1" class="form-group row">
        <label id="elh_TREATMENT_INAP_ID_1" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ID_1->caption() ?><?= $Page->ID_1->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ID_1->cellAttributes() ?>>
<span id="el_TREATMENT_INAP_ID_1">
<input type="<?= $Page->ID_1->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_ID_1" name="x_ID_1" id="x_ID_1" placeholder="<?= HtmlEncode($Page->ID_1->getPlaceHolder()) ?>" value="<?= $Page->ID_1->EditValue ?>"<?= $Page->ID_1->editAttributes() ?> aria-describedby="x_ID_1_help">
<?= $Page->ID_1->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ID_1->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->MEASURE_ID->Visible) { // MEASURE_ID ?>
    <div id="r_MEASURE_ID" class="form-group row">
        <label id="elh_TREATMENT_INAP_MEASURE_ID" for="x_MEASURE_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->MEASURE_ID->caption() ?><?= $Page->MEASURE_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->MEASURE_ID->cellAttributes() ?>>
<span id="el_TREATMENT_INAP_MEASURE_ID">
<input type="<?= $Page->MEASURE_ID->getInputTextType() ?>" data-table="TREATMENT_INAP" data-field="x_MEASURE_ID" name="x_MEASURE_ID" id="x_MEASURE_ID" size="30" placeholder="<?= HtmlEncode($Page->MEASURE_ID->getPlaceHolder()) ?>" value="<?= $Page->MEASURE_ID->EditValue ?>"<?= $Page->MEASURE_ID->editAttributes() ?> aria-describedby="x_MEASURE_ID_help">
<?= $Page->MEASURE_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->MEASURE_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php if ($Page->VISIT_ID->getSessionValue() != "") { ?>
<input type="hidden" id="x_VISIT_ID" name="x_VISIT_ID" value="<?= HtmlEncode($Page->VISIT_ID->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_TREATMENT_INAP_VISIT_ID">
<input type="hidden" data-table="TREATMENT_INAP" data-field="x_VISIT_ID" data-hidden="1" name="x_VISIT_ID" id="x_VISIT_ID" value="<?= HtmlEncode($Page->VISIT_ID->CurrentValue) ?>">
</span>
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
    ew.addEventHandlers("TREATMENT_INAP");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
