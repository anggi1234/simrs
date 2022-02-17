<?php

namespace PHPMaker2021\SIMRSSQLSERVERGUDANGFARMASI;

// Page object
$PoAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fPOadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fPOadd = currentForm = new ew.Form("fPOadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "PO")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.PO)
        ew.vars.tables.PO = currentTable;
    fPOadd.addFields([
        ["ORG_UNIT_CODE", [fields.ORG_UNIT_CODE.visible && fields.ORG_UNIT_CODE.required ? ew.Validators.required(fields.ORG_UNIT_CODE.caption) : null], fields.ORG_UNIT_CODE.isInvalid],
        ["PO", [fields.PO.visible && fields.PO.required ? ew.Validators.required(fields.PO.caption) : null], fields.PO.isInvalid],
        ["PO_DATE", [fields.PO_DATE.visible && fields.PO_DATE.required ? ew.Validators.required(fields.PO_DATE.caption) : null, ew.Validators.datetime(0)], fields.PO_DATE.isInvalid],
        ["ORDER_VALUE", [fields.ORDER_VALUE.visible && fields.ORDER_VALUE.required ? ew.Validators.required(fields.ORDER_VALUE.caption) : null, ew.Validators.float], fields.ORDER_VALUE.isInvalid],
        ["RECEIVED_VALUE", [fields.RECEIVED_VALUE.visible && fields.RECEIVED_VALUE.required ? ew.Validators.required(fields.RECEIVED_VALUE.caption) : null, ew.Validators.float], fields.RECEIVED_VALUE.isInvalid],
        ["PROCURE_METHOD", [fields.PROCURE_METHOD.visible && fields.PROCURE_METHOD.required ? ew.Validators.required(fields.PROCURE_METHOD.caption) : null, ew.Validators.integer], fields.PROCURE_METHOD.isInvalid],
        ["COMPANY_ID", [fields.COMPANY_ID.visible && fields.COMPANY_ID.required ? ew.Validators.required(fields.COMPANY_ID.caption) : null], fields.COMPANY_ID.isInvalid],
        ["FUND_ID", [fields.FUND_ID.visible && fields.FUND_ID.required ? ew.Validators.required(fields.FUND_ID.caption) : null, ew.Validators.integer], fields.FUND_ID.isInvalid],
        ["FUND_NO", [fields.FUND_NO.visible && fields.FUND_NO.required ? ew.Validators.required(fields.FUND_NO.caption) : null], fields.FUND_NO.isInvalid],
        ["DESCRIPTION", [fields.DESCRIPTION.visible && fields.DESCRIPTION.required ? ew.Validators.required(fields.DESCRIPTION.caption) : null], fields.DESCRIPTION.isInvalid],
        ["MODIFIED_DATE", [fields.MODIFIED_DATE.visible && fields.MODIFIED_DATE.required ? ew.Validators.required(fields.MODIFIED_DATE.caption) : null, ew.Validators.datetime(0)], fields.MODIFIED_DATE.isInvalid],
        ["MODIFIED_BY", [fields.MODIFIED_BY.visible && fields.MODIFIED_BY.required ? ew.Validators.required(fields.MODIFIED_BY.caption) : null], fields.MODIFIED_BY.isInvalid],
        ["ORDER_BY", [fields.ORDER_BY.visible && fields.ORDER_BY.required ? ew.Validators.required(fields.ORDER_BY.caption) : null], fields.ORDER_BY.isInvalid],
        ["SENT_TO", [fields.SENT_TO.visible && fields.SENT_TO.required ? ew.Validators.required(fields.SENT_TO.caption) : null], fields.SENT_TO.isInvalid],
        ["ISVALID", [fields.ISVALID.visible && fields.ISVALID.required ? ew.Validators.required(fields.ISVALID.caption) : null], fields.ISVALID.isInvalid],
        ["START_VALID", [fields.START_VALID.visible && fields.START_VALID.required ? ew.Validators.required(fields.START_VALID.caption) : null, ew.Validators.datetime(0)], fields.START_VALID.isInvalid],
        ["END_VALID", [fields.END_VALID.visible && fields.END_VALID.required ? ew.Validators.required(fields.END_VALID.caption) : null, ew.Validators.datetime(0)], fields.END_VALID.isInvalid],
        ["CONTRACT_NO", [fields.CONTRACT_NO.visible && fields.CONTRACT_NO.required ? ew.Validators.required(fields.CONTRACT_NO.caption) : null], fields.CONTRACT_NO.isInvalid],
        ["ORG_ID", [fields.ORG_ID.visible && fields.ORG_ID.required ? ew.Validators.required(fields.ORG_ID.caption) : null], fields.ORG_ID.isInvalid],
        ["CLINIC_ID", [fields.CLINIC_ID.visible && fields.CLINIC_ID.required ? ew.Validators.required(fields.CLINIC_ID.caption) : null], fields.CLINIC_ID.isInvalid],
        ["ACCOUNT_ID", [fields.ACCOUNT_ID.visible && fields.ACCOUNT_ID.required ? ew.Validators.required(fields.ACCOUNT_ID.caption) : null], fields.ACCOUNT_ID.isInvalid],
        ["PAID_VALUE", [fields.PAID_VALUE.visible && fields.PAID_VALUE.required ? ew.Validators.required(fields.PAID_VALUE.caption) : null, ew.Validators.float], fields.PAID_VALUE.isInvalid],
        ["PPN", [fields.PPN.visible && fields.PPN.required ? ew.Validators.required(fields.PPN.caption) : null, ew.Validators.float], fields.PPN.isInvalid],
        ["MATERAI", [fields.MATERAI.visible && fields.MATERAI.required ? ew.Validators.required(fields.MATERAI.caption) : null, ew.Validators.float], fields.MATERAI.isInvalid],
        ["PPN_VALUE", [fields.PPN_VALUE.visible && fields.PPN_VALUE.required ? ew.Validators.required(fields.PPN_VALUE.caption) : null, ew.Validators.float], fields.PPN_VALUE.isInvalid],
        ["DISCOUNT_VALUE", [fields.DISCOUNT_VALUE.visible && fields.DISCOUNT_VALUE.required ? ew.Validators.required(fields.DISCOUNT_VALUE.caption) : null, ew.Validators.float], fields.DISCOUNT_VALUE.isInvalid],
        ["ISCETAK", [fields.ISCETAK.visible && fields.ISCETAK.required ? ew.Validators.required(fields.ISCETAK.caption) : null], fields.ISCETAK.isInvalid],
        ["PRINT_DATE", [fields.PRINT_DATE.visible && fields.PRINT_DATE.required ? ew.Validators.required(fields.PRINT_DATE.caption) : null, ew.Validators.datetime(0)], fields.PRINT_DATE.isInvalid],
        ["PRINTED_BY", [fields.PRINTED_BY.visible && fields.PRINTED_BY.required ? ew.Validators.required(fields.PRINTED_BY.caption) : null], fields.PRINTED_BY.isInvalid],
        ["PRINTQ", [fields.PRINTQ.visible && fields.PRINTQ.required ? ew.Validators.required(fields.PRINTQ.caption) : null, ew.Validators.integer], fields.PRINTQ.isInvalid],
        ["TAGIHAN_VALUE", [fields.TAGIHAN_VALUE.visible && fields.TAGIHAN_VALUE.required ? ew.Validators.required(fields.TAGIHAN_VALUE.caption) : null, ew.Validators.float], fields.TAGIHAN_VALUE.isInvalid],
        ["ACKNOWLEDGEBY", [fields.ACKNOWLEDGEBY.visible && fields.ACKNOWLEDGEBY.required ? ew.Validators.required(fields.ACKNOWLEDGEBY.caption) : null], fields.ACKNOWLEDGEBY.isInvalid],
        ["NUM", [fields.NUM.visible && fields.NUM.required ? ew.Validators.required(fields.NUM.caption) : null, ew.Validators.integer], fields.NUM.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fPOadd,
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
    fPOadd.validate = function () {
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
    fPOadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fPOadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fPOadd");
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
<form name="fPOadd" id="fPOadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="PO">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->ORG_UNIT_CODE->Visible) { // ORG_UNIT_CODE ?>
    <div id="r_ORG_UNIT_CODE" class="form-group row">
        <label id="elh_PO_ORG_UNIT_CODE" for="x_ORG_UNIT_CODE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ORG_UNIT_CODE->caption() ?><?= $Page->ORG_UNIT_CODE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ORG_UNIT_CODE->cellAttributes() ?>>
<span id="el_PO_ORG_UNIT_CODE">
<input type="<?= $Page->ORG_UNIT_CODE->getInputTextType() ?>" data-table="PO" data-field="x_ORG_UNIT_CODE" name="x_ORG_UNIT_CODE" id="x_ORG_UNIT_CODE" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->ORG_UNIT_CODE->getPlaceHolder()) ?>" value="<?= $Page->ORG_UNIT_CODE->EditValue ?>"<?= $Page->ORG_UNIT_CODE->editAttributes() ?> aria-describedby="x_ORG_UNIT_CODE_help">
<?= $Page->ORG_UNIT_CODE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ORG_UNIT_CODE->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->PO->Visible) { // PO ?>
    <div id="r_PO" class="form-group row">
        <label id="elh_PO_PO" for="x_PO" class="<?= $Page->LeftColumnClass ?>"><?= $Page->PO->caption() ?><?= $Page->PO->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PO->cellAttributes() ?>>
<span id="el_PO_PO">
<input type="<?= $Page->PO->getInputTextType() ?>" data-table="PO" data-field="x_PO" name="x_PO" id="x_PO" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->PO->getPlaceHolder()) ?>" value="<?= $Page->PO->EditValue ?>"<?= $Page->PO->editAttributes() ?> aria-describedby="x_PO_help">
<?= $Page->PO->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->PO->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->PO_DATE->Visible) { // PO_DATE ?>
    <div id="r_PO_DATE" class="form-group row">
        <label id="elh_PO_PO_DATE" for="x_PO_DATE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->PO_DATE->caption() ?><?= $Page->PO_DATE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PO_DATE->cellAttributes() ?>>
<span id="el_PO_PO_DATE">
<input type="<?= $Page->PO_DATE->getInputTextType() ?>" data-table="PO" data-field="x_PO_DATE" name="x_PO_DATE" id="x_PO_DATE" placeholder="<?= HtmlEncode($Page->PO_DATE->getPlaceHolder()) ?>" value="<?= $Page->PO_DATE->EditValue ?>"<?= $Page->PO_DATE->editAttributes() ?> aria-describedby="x_PO_DATE_help">
<?= $Page->PO_DATE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->PO_DATE->getErrorMessage() ?></div>
<?php if (!$Page->PO_DATE->ReadOnly && !$Page->PO_DATE->Disabled && !isset($Page->PO_DATE->EditAttrs["readonly"]) && !isset($Page->PO_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fPOadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fPOadd", "x_PO_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ORDER_VALUE->Visible) { // ORDER_VALUE ?>
    <div id="r_ORDER_VALUE" class="form-group row">
        <label id="elh_PO_ORDER_VALUE" for="x_ORDER_VALUE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ORDER_VALUE->caption() ?><?= $Page->ORDER_VALUE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ORDER_VALUE->cellAttributes() ?>>
<span id="el_PO_ORDER_VALUE">
<input type="<?= $Page->ORDER_VALUE->getInputTextType() ?>" data-table="PO" data-field="x_ORDER_VALUE" name="x_ORDER_VALUE" id="x_ORDER_VALUE" size="30" placeholder="<?= HtmlEncode($Page->ORDER_VALUE->getPlaceHolder()) ?>" value="<?= $Page->ORDER_VALUE->EditValue ?>"<?= $Page->ORDER_VALUE->editAttributes() ?> aria-describedby="x_ORDER_VALUE_help">
<?= $Page->ORDER_VALUE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ORDER_VALUE->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->RECEIVED_VALUE->Visible) { // RECEIVED_VALUE ?>
    <div id="r_RECEIVED_VALUE" class="form-group row">
        <label id="elh_PO_RECEIVED_VALUE" for="x_RECEIVED_VALUE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->RECEIVED_VALUE->caption() ?><?= $Page->RECEIVED_VALUE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->RECEIVED_VALUE->cellAttributes() ?>>
<span id="el_PO_RECEIVED_VALUE">
<input type="<?= $Page->RECEIVED_VALUE->getInputTextType() ?>" data-table="PO" data-field="x_RECEIVED_VALUE" name="x_RECEIVED_VALUE" id="x_RECEIVED_VALUE" size="30" placeholder="<?= HtmlEncode($Page->RECEIVED_VALUE->getPlaceHolder()) ?>" value="<?= $Page->RECEIVED_VALUE->EditValue ?>"<?= $Page->RECEIVED_VALUE->editAttributes() ?> aria-describedby="x_RECEIVED_VALUE_help">
<?= $Page->RECEIVED_VALUE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->RECEIVED_VALUE->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->PROCURE_METHOD->Visible) { // PROCURE_METHOD ?>
    <div id="r_PROCURE_METHOD" class="form-group row">
        <label id="elh_PO_PROCURE_METHOD" for="x_PROCURE_METHOD" class="<?= $Page->LeftColumnClass ?>"><?= $Page->PROCURE_METHOD->caption() ?><?= $Page->PROCURE_METHOD->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PROCURE_METHOD->cellAttributes() ?>>
<span id="el_PO_PROCURE_METHOD">
<input type="<?= $Page->PROCURE_METHOD->getInputTextType() ?>" data-table="PO" data-field="x_PROCURE_METHOD" name="x_PROCURE_METHOD" id="x_PROCURE_METHOD" size="30" placeholder="<?= HtmlEncode($Page->PROCURE_METHOD->getPlaceHolder()) ?>" value="<?= $Page->PROCURE_METHOD->EditValue ?>"<?= $Page->PROCURE_METHOD->editAttributes() ?> aria-describedby="x_PROCURE_METHOD_help">
<?= $Page->PROCURE_METHOD->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->PROCURE_METHOD->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->COMPANY_ID->Visible) { // COMPANY_ID ?>
    <div id="r_COMPANY_ID" class="form-group row">
        <label id="elh_PO_COMPANY_ID" for="x_COMPANY_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->COMPANY_ID->caption() ?><?= $Page->COMPANY_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->COMPANY_ID->cellAttributes() ?>>
<span id="el_PO_COMPANY_ID">
<input type="<?= $Page->COMPANY_ID->getInputTextType() ?>" data-table="PO" data-field="x_COMPANY_ID" name="x_COMPANY_ID" id="x_COMPANY_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->COMPANY_ID->getPlaceHolder()) ?>" value="<?= $Page->COMPANY_ID->EditValue ?>"<?= $Page->COMPANY_ID->editAttributes() ?> aria-describedby="x_COMPANY_ID_help">
<?= $Page->COMPANY_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->COMPANY_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->FUND_ID->Visible) { // FUND_ID ?>
    <div id="r_FUND_ID" class="form-group row">
        <label id="elh_PO_FUND_ID" for="x_FUND_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->FUND_ID->caption() ?><?= $Page->FUND_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->FUND_ID->cellAttributes() ?>>
<span id="el_PO_FUND_ID">
<input type="<?= $Page->FUND_ID->getInputTextType() ?>" data-table="PO" data-field="x_FUND_ID" name="x_FUND_ID" id="x_FUND_ID" size="30" placeholder="<?= HtmlEncode($Page->FUND_ID->getPlaceHolder()) ?>" value="<?= $Page->FUND_ID->EditValue ?>"<?= $Page->FUND_ID->editAttributes() ?> aria-describedby="x_FUND_ID_help">
<?= $Page->FUND_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->FUND_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->FUND_NO->Visible) { // FUND_NO ?>
    <div id="r_FUND_NO" class="form-group row">
        <label id="elh_PO_FUND_NO" for="x_FUND_NO" class="<?= $Page->LeftColumnClass ?>"><?= $Page->FUND_NO->caption() ?><?= $Page->FUND_NO->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->FUND_NO->cellAttributes() ?>>
<span id="el_PO_FUND_NO">
<input type="<?= $Page->FUND_NO->getInputTextType() ?>" data-table="PO" data-field="x_FUND_NO" name="x_FUND_NO" id="x_FUND_NO" size="30" maxlength="30" placeholder="<?= HtmlEncode($Page->FUND_NO->getPlaceHolder()) ?>" value="<?= $Page->FUND_NO->EditValue ?>"<?= $Page->FUND_NO->editAttributes() ?> aria-describedby="x_FUND_NO_help">
<?= $Page->FUND_NO->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->FUND_NO->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->DESCRIPTION->Visible) { // DESCRIPTION ?>
    <div id="r_DESCRIPTION" class="form-group row">
        <label id="elh_PO_DESCRIPTION" for="x_DESCRIPTION" class="<?= $Page->LeftColumnClass ?>"><?= $Page->DESCRIPTION->caption() ?><?= $Page->DESCRIPTION->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->DESCRIPTION->cellAttributes() ?>>
<span id="el_PO_DESCRIPTION">
<input type="<?= $Page->DESCRIPTION->getInputTextType() ?>" data-table="PO" data-field="x_DESCRIPTION" name="x_DESCRIPTION" id="x_DESCRIPTION" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->DESCRIPTION->getPlaceHolder()) ?>" value="<?= $Page->DESCRIPTION->EditValue ?>"<?= $Page->DESCRIPTION->editAttributes() ?> aria-describedby="x_DESCRIPTION_help">
<?= $Page->DESCRIPTION->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->DESCRIPTION->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
    <div id="r_MODIFIED_DATE" class="form-group row">
        <label id="elh_PO_MODIFIED_DATE" for="x_MODIFIED_DATE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->MODIFIED_DATE->caption() ?><?= $Page->MODIFIED_DATE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->MODIFIED_DATE->cellAttributes() ?>>
<span id="el_PO_MODIFIED_DATE">
<input type="<?= $Page->MODIFIED_DATE->getInputTextType() ?>" data-table="PO" data-field="x_MODIFIED_DATE" name="x_MODIFIED_DATE" id="x_MODIFIED_DATE" placeholder="<?= HtmlEncode($Page->MODIFIED_DATE->getPlaceHolder()) ?>" value="<?= $Page->MODIFIED_DATE->EditValue ?>"<?= $Page->MODIFIED_DATE->editAttributes() ?> aria-describedby="x_MODIFIED_DATE_help">
<?= $Page->MODIFIED_DATE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->MODIFIED_DATE->getErrorMessage() ?></div>
<?php if (!$Page->MODIFIED_DATE->ReadOnly && !$Page->MODIFIED_DATE->Disabled && !isset($Page->MODIFIED_DATE->EditAttrs["readonly"]) && !isset($Page->MODIFIED_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fPOadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fPOadd", "x_MODIFIED_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
    <div id="r_MODIFIED_BY" class="form-group row">
        <label id="elh_PO_MODIFIED_BY" for="x_MODIFIED_BY" class="<?= $Page->LeftColumnClass ?>"><?= $Page->MODIFIED_BY->caption() ?><?= $Page->MODIFIED_BY->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->MODIFIED_BY->cellAttributes() ?>>
<span id="el_PO_MODIFIED_BY">
<input type="<?= $Page->MODIFIED_BY->getInputTextType() ?>" data-table="PO" data-field="x_MODIFIED_BY" name="x_MODIFIED_BY" id="x_MODIFIED_BY" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->MODIFIED_BY->getPlaceHolder()) ?>" value="<?= $Page->MODIFIED_BY->EditValue ?>"<?= $Page->MODIFIED_BY->editAttributes() ?> aria-describedby="x_MODIFIED_BY_help">
<?= $Page->MODIFIED_BY->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->MODIFIED_BY->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ORDER_BY->Visible) { // ORDER_BY ?>
    <div id="r_ORDER_BY" class="form-group row">
        <label id="elh_PO_ORDER_BY" for="x_ORDER_BY" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ORDER_BY->caption() ?><?= $Page->ORDER_BY->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ORDER_BY->cellAttributes() ?>>
<span id="el_PO_ORDER_BY">
<input type="<?= $Page->ORDER_BY->getInputTextType() ?>" data-table="PO" data-field="x_ORDER_BY" name="x_ORDER_BY" id="x_ORDER_BY" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->ORDER_BY->getPlaceHolder()) ?>" value="<?= $Page->ORDER_BY->EditValue ?>"<?= $Page->ORDER_BY->editAttributes() ?> aria-describedby="x_ORDER_BY_help">
<?= $Page->ORDER_BY->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ORDER_BY->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->SENT_TO->Visible) { // SENT_TO ?>
    <div id="r_SENT_TO" class="form-group row">
        <label id="elh_PO_SENT_TO" for="x_SENT_TO" class="<?= $Page->LeftColumnClass ?>"><?= $Page->SENT_TO->caption() ?><?= $Page->SENT_TO->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->SENT_TO->cellAttributes() ?>>
<span id="el_PO_SENT_TO">
<input type="<?= $Page->SENT_TO->getInputTextType() ?>" data-table="PO" data-field="x_SENT_TO" name="x_SENT_TO" id="x_SENT_TO" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->SENT_TO->getPlaceHolder()) ?>" value="<?= $Page->SENT_TO->EditValue ?>"<?= $Page->SENT_TO->editAttributes() ?> aria-describedby="x_SENT_TO_help">
<?= $Page->SENT_TO->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->SENT_TO->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ISVALID->Visible) { // ISVALID ?>
    <div id="r_ISVALID" class="form-group row">
        <label id="elh_PO_ISVALID" for="x_ISVALID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ISVALID->caption() ?><?= $Page->ISVALID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ISVALID->cellAttributes() ?>>
<span id="el_PO_ISVALID">
<input type="<?= $Page->ISVALID->getInputTextType() ?>" data-table="PO" data-field="x_ISVALID" name="x_ISVALID" id="x_ISVALID" size="30" maxlength="1" placeholder="<?= HtmlEncode($Page->ISVALID->getPlaceHolder()) ?>" value="<?= $Page->ISVALID->EditValue ?>"<?= $Page->ISVALID->editAttributes() ?> aria-describedby="x_ISVALID_help">
<?= $Page->ISVALID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ISVALID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->START_VALID->Visible) { // START_VALID ?>
    <div id="r_START_VALID" class="form-group row">
        <label id="elh_PO_START_VALID" for="x_START_VALID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->START_VALID->caption() ?><?= $Page->START_VALID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->START_VALID->cellAttributes() ?>>
<span id="el_PO_START_VALID">
<input type="<?= $Page->START_VALID->getInputTextType() ?>" data-table="PO" data-field="x_START_VALID" name="x_START_VALID" id="x_START_VALID" placeholder="<?= HtmlEncode($Page->START_VALID->getPlaceHolder()) ?>" value="<?= $Page->START_VALID->EditValue ?>"<?= $Page->START_VALID->editAttributes() ?> aria-describedby="x_START_VALID_help">
<?= $Page->START_VALID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->START_VALID->getErrorMessage() ?></div>
<?php if (!$Page->START_VALID->ReadOnly && !$Page->START_VALID->Disabled && !isset($Page->START_VALID->EditAttrs["readonly"]) && !isset($Page->START_VALID->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fPOadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fPOadd", "x_START_VALID", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->END_VALID->Visible) { // END_VALID ?>
    <div id="r_END_VALID" class="form-group row">
        <label id="elh_PO_END_VALID" for="x_END_VALID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->END_VALID->caption() ?><?= $Page->END_VALID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->END_VALID->cellAttributes() ?>>
<span id="el_PO_END_VALID">
<input type="<?= $Page->END_VALID->getInputTextType() ?>" data-table="PO" data-field="x_END_VALID" name="x_END_VALID" id="x_END_VALID" placeholder="<?= HtmlEncode($Page->END_VALID->getPlaceHolder()) ?>" value="<?= $Page->END_VALID->EditValue ?>"<?= $Page->END_VALID->editAttributes() ?> aria-describedby="x_END_VALID_help">
<?= $Page->END_VALID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->END_VALID->getErrorMessage() ?></div>
<?php if (!$Page->END_VALID->ReadOnly && !$Page->END_VALID->Disabled && !isset($Page->END_VALID->EditAttrs["readonly"]) && !isset($Page->END_VALID->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fPOadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fPOadd", "x_END_VALID", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->CONTRACT_NO->Visible) { // CONTRACT_NO ?>
    <div id="r_CONTRACT_NO" class="form-group row">
        <label id="elh_PO_CONTRACT_NO" for="x_CONTRACT_NO" class="<?= $Page->LeftColumnClass ?>"><?= $Page->CONTRACT_NO->caption() ?><?= $Page->CONTRACT_NO->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->CONTRACT_NO->cellAttributes() ?>>
<span id="el_PO_CONTRACT_NO">
<input type="<?= $Page->CONTRACT_NO->getInputTextType() ?>" data-table="PO" data-field="x_CONTRACT_NO" name="x_CONTRACT_NO" id="x_CONTRACT_NO" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->CONTRACT_NO->getPlaceHolder()) ?>" value="<?= $Page->CONTRACT_NO->EditValue ?>"<?= $Page->CONTRACT_NO->editAttributes() ?> aria-describedby="x_CONTRACT_NO_help">
<?= $Page->CONTRACT_NO->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->CONTRACT_NO->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ORG_ID->Visible) { // ORG_ID ?>
    <div id="r_ORG_ID" class="form-group row">
        <label id="elh_PO_ORG_ID" for="x_ORG_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ORG_ID->caption() ?><?= $Page->ORG_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ORG_ID->cellAttributes() ?>>
<span id="el_PO_ORG_ID">
<input type="<?= $Page->ORG_ID->getInputTextType() ?>" data-table="PO" data-field="x_ORG_ID" name="x_ORG_ID" id="x_ORG_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->ORG_ID->getPlaceHolder()) ?>" value="<?= $Page->ORG_ID->EditValue ?>"<?= $Page->ORG_ID->editAttributes() ?> aria-describedby="x_ORG_ID_help">
<?= $Page->ORG_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ORG_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->CLINIC_ID->Visible) { // CLINIC_ID ?>
    <div id="r_CLINIC_ID" class="form-group row">
        <label id="elh_PO_CLINIC_ID" for="x_CLINIC_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->CLINIC_ID->caption() ?><?= $Page->CLINIC_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->CLINIC_ID->cellAttributes() ?>>
<span id="el_PO_CLINIC_ID">
<input type="<?= $Page->CLINIC_ID->getInputTextType() ?>" data-table="PO" data-field="x_CLINIC_ID" name="x_CLINIC_ID" id="x_CLINIC_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->CLINIC_ID->getPlaceHolder()) ?>" value="<?= $Page->CLINIC_ID->EditValue ?>"<?= $Page->CLINIC_ID->editAttributes() ?> aria-describedby="x_CLINIC_ID_help">
<?= $Page->CLINIC_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->CLINIC_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ACCOUNT_ID->Visible) { // ACCOUNT_ID ?>
    <div id="r_ACCOUNT_ID" class="form-group row">
        <label id="elh_PO_ACCOUNT_ID" for="x_ACCOUNT_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ACCOUNT_ID->caption() ?><?= $Page->ACCOUNT_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ACCOUNT_ID->cellAttributes() ?>>
<span id="el_PO_ACCOUNT_ID">
<input type="<?= $Page->ACCOUNT_ID->getInputTextType() ?>" data-table="PO" data-field="x_ACCOUNT_ID" name="x_ACCOUNT_ID" id="x_ACCOUNT_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->ACCOUNT_ID->getPlaceHolder()) ?>" value="<?= $Page->ACCOUNT_ID->EditValue ?>"<?= $Page->ACCOUNT_ID->editAttributes() ?> aria-describedby="x_ACCOUNT_ID_help">
<?= $Page->ACCOUNT_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ACCOUNT_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->PAID_VALUE->Visible) { // PAID_VALUE ?>
    <div id="r_PAID_VALUE" class="form-group row">
        <label id="elh_PO_PAID_VALUE" for="x_PAID_VALUE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->PAID_VALUE->caption() ?><?= $Page->PAID_VALUE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PAID_VALUE->cellAttributes() ?>>
<span id="el_PO_PAID_VALUE">
<input type="<?= $Page->PAID_VALUE->getInputTextType() ?>" data-table="PO" data-field="x_PAID_VALUE" name="x_PAID_VALUE" id="x_PAID_VALUE" size="30" placeholder="<?= HtmlEncode($Page->PAID_VALUE->getPlaceHolder()) ?>" value="<?= $Page->PAID_VALUE->EditValue ?>"<?= $Page->PAID_VALUE->editAttributes() ?> aria-describedby="x_PAID_VALUE_help">
<?= $Page->PAID_VALUE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->PAID_VALUE->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->PPN->Visible) { // PPN ?>
    <div id="r_PPN" class="form-group row">
        <label id="elh_PO_PPN" for="x_PPN" class="<?= $Page->LeftColumnClass ?>"><?= $Page->PPN->caption() ?><?= $Page->PPN->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PPN->cellAttributes() ?>>
<span id="el_PO_PPN">
<input type="<?= $Page->PPN->getInputTextType() ?>" data-table="PO" data-field="x_PPN" name="x_PPN" id="x_PPN" size="30" placeholder="<?= HtmlEncode($Page->PPN->getPlaceHolder()) ?>" value="<?= $Page->PPN->EditValue ?>"<?= $Page->PPN->editAttributes() ?> aria-describedby="x_PPN_help">
<?= $Page->PPN->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->PPN->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->MATERAI->Visible) { // MATERAI ?>
    <div id="r_MATERAI" class="form-group row">
        <label id="elh_PO_MATERAI" for="x_MATERAI" class="<?= $Page->LeftColumnClass ?>"><?= $Page->MATERAI->caption() ?><?= $Page->MATERAI->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->MATERAI->cellAttributes() ?>>
<span id="el_PO_MATERAI">
<input type="<?= $Page->MATERAI->getInputTextType() ?>" data-table="PO" data-field="x_MATERAI" name="x_MATERAI" id="x_MATERAI" size="30" placeholder="<?= HtmlEncode($Page->MATERAI->getPlaceHolder()) ?>" value="<?= $Page->MATERAI->EditValue ?>"<?= $Page->MATERAI->editAttributes() ?> aria-describedby="x_MATERAI_help">
<?= $Page->MATERAI->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->MATERAI->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->PPN_VALUE->Visible) { // PPN_VALUE ?>
    <div id="r_PPN_VALUE" class="form-group row">
        <label id="elh_PO_PPN_VALUE" for="x_PPN_VALUE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->PPN_VALUE->caption() ?><?= $Page->PPN_VALUE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PPN_VALUE->cellAttributes() ?>>
<span id="el_PO_PPN_VALUE">
<input type="<?= $Page->PPN_VALUE->getInputTextType() ?>" data-table="PO" data-field="x_PPN_VALUE" name="x_PPN_VALUE" id="x_PPN_VALUE" size="30" placeholder="<?= HtmlEncode($Page->PPN_VALUE->getPlaceHolder()) ?>" value="<?= $Page->PPN_VALUE->EditValue ?>"<?= $Page->PPN_VALUE->editAttributes() ?> aria-describedby="x_PPN_VALUE_help">
<?= $Page->PPN_VALUE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->PPN_VALUE->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->DISCOUNT_VALUE->Visible) { // DISCOUNT_VALUE ?>
    <div id="r_DISCOUNT_VALUE" class="form-group row">
        <label id="elh_PO_DISCOUNT_VALUE" for="x_DISCOUNT_VALUE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->DISCOUNT_VALUE->caption() ?><?= $Page->DISCOUNT_VALUE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->DISCOUNT_VALUE->cellAttributes() ?>>
<span id="el_PO_DISCOUNT_VALUE">
<input type="<?= $Page->DISCOUNT_VALUE->getInputTextType() ?>" data-table="PO" data-field="x_DISCOUNT_VALUE" name="x_DISCOUNT_VALUE" id="x_DISCOUNT_VALUE" size="30" placeholder="<?= HtmlEncode($Page->DISCOUNT_VALUE->getPlaceHolder()) ?>" value="<?= $Page->DISCOUNT_VALUE->EditValue ?>"<?= $Page->DISCOUNT_VALUE->editAttributes() ?> aria-describedby="x_DISCOUNT_VALUE_help">
<?= $Page->DISCOUNT_VALUE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->DISCOUNT_VALUE->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ISCETAK->Visible) { // ISCETAK ?>
    <div id="r_ISCETAK" class="form-group row">
        <label id="elh_PO_ISCETAK" for="x_ISCETAK" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ISCETAK->caption() ?><?= $Page->ISCETAK->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ISCETAK->cellAttributes() ?>>
<span id="el_PO_ISCETAK">
<input type="<?= $Page->ISCETAK->getInputTextType() ?>" data-table="PO" data-field="x_ISCETAK" name="x_ISCETAK" id="x_ISCETAK" size="30" maxlength="1" placeholder="<?= HtmlEncode($Page->ISCETAK->getPlaceHolder()) ?>" value="<?= $Page->ISCETAK->EditValue ?>"<?= $Page->ISCETAK->editAttributes() ?> aria-describedby="x_ISCETAK_help">
<?= $Page->ISCETAK->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ISCETAK->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->PRINT_DATE->Visible) { // PRINT_DATE ?>
    <div id="r_PRINT_DATE" class="form-group row">
        <label id="elh_PO_PRINT_DATE" for="x_PRINT_DATE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->PRINT_DATE->caption() ?><?= $Page->PRINT_DATE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PRINT_DATE->cellAttributes() ?>>
<span id="el_PO_PRINT_DATE">
<input type="<?= $Page->PRINT_DATE->getInputTextType() ?>" data-table="PO" data-field="x_PRINT_DATE" name="x_PRINT_DATE" id="x_PRINT_DATE" placeholder="<?= HtmlEncode($Page->PRINT_DATE->getPlaceHolder()) ?>" value="<?= $Page->PRINT_DATE->EditValue ?>"<?= $Page->PRINT_DATE->editAttributes() ?> aria-describedby="x_PRINT_DATE_help">
<?= $Page->PRINT_DATE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->PRINT_DATE->getErrorMessage() ?></div>
<?php if (!$Page->PRINT_DATE->ReadOnly && !$Page->PRINT_DATE->Disabled && !isset($Page->PRINT_DATE->EditAttrs["readonly"]) && !isset($Page->PRINT_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fPOadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fPOadd", "x_PRINT_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->PRINTED_BY->Visible) { // PRINTED_BY ?>
    <div id="r_PRINTED_BY" class="form-group row">
        <label id="elh_PO_PRINTED_BY" for="x_PRINTED_BY" class="<?= $Page->LeftColumnClass ?>"><?= $Page->PRINTED_BY->caption() ?><?= $Page->PRINTED_BY->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PRINTED_BY->cellAttributes() ?>>
<span id="el_PO_PRINTED_BY">
<input type="<?= $Page->PRINTED_BY->getInputTextType() ?>" data-table="PO" data-field="x_PRINTED_BY" name="x_PRINTED_BY" id="x_PRINTED_BY" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->PRINTED_BY->getPlaceHolder()) ?>" value="<?= $Page->PRINTED_BY->EditValue ?>"<?= $Page->PRINTED_BY->editAttributes() ?> aria-describedby="x_PRINTED_BY_help">
<?= $Page->PRINTED_BY->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->PRINTED_BY->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->PRINTQ->Visible) { // PRINTQ ?>
    <div id="r_PRINTQ" class="form-group row">
        <label id="elh_PO_PRINTQ" for="x_PRINTQ" class="<?= $Page->LeftColumnClass ?>"><?= $Page->PRINTQ->caption() ?><?= $Page->PRINTQ->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PRINTQ->cellAttributes() ?>>
<span id="el_PO_PRINTQ">
<input type="<?= $Page->PRINTQ->getInputTextType() ?>" data-table="PO" data-field="x_PRINTQ" name="x_PRINTQ" id="x_PRINTQ" size="30" placeholder="<?= HtmlEncode($Page->PRINTQ->getPlaceHolder()) ?>" value="<?= $Page->PRINTQ->EditValue ?>"<?= $Page->PRINTQ->editAttributes() ?> aria-describedby="x_PRINTQ_help">
<?= $Page->PRINTQ->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->PRINTQ->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->TAGIHAN_VALUE->Visible) { // TAGIHAN_VALUE ?>
    <div id="r_TAGIHAN_VALUE" class="form-group row">
        <label id="elh_PO_TAGIHAN_VALUE" for="x_TAGIHAN_VALUE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->TAGIHAN_VALUE->caption() ?><?= $Page->TAGIHAN_VALUE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->TAGIHAN_VALUE->cellAttributes() ?>>
<span id="el_PO_TAGIHAN_VALUE">
<input type="<?= $Page->TAGIHAN_VALUE->getInputTextType() ?>" data-table="PO" data-field="x_TAGIHAN_VALUE" name="x_TAGIHAN_VALUE" id="x_TAGIHAN_VALUE" size="30" placeholder="<?= HtmlEncode($Page->TAGIHAN_VALUE->getPlaceHolder()) ?>" value="<?= $Page->TAGIHAN_VALUE->EditValue ?>"<?= $Page->TAGIHAN_VALUE->editAttributes() ?> aria-describedby="x_TAGIHAN_VALUE_help">
<?= $Page->TAGIHAN_VALUE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->TAGIHAN_VALUE->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ACKNOWLEDGEBY->Visible) { // ACKNOWLEDGEBY ?>
    <div id="r_ACKNOWLEDGEBY" class="form-group row">
        <label id="elh_PO_ACKNOWLEDGEBY" for="x_ACKNOWLEDGEBY" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ACKNOWLEDGEBY->caption() ?><?= $Page->ACKNOWLEDGEBY->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ACKNOWLEDGEBY->cellAttributes() ?>>
<span id="el_PO_ACKNOWLEDGEBY">
<input type="<?= $Page->ACKNOWLEDGEBY->getInputTextType() ?>" data-table="PO" data-field="x_ACKNOWLEDGEBY" name="x_ACKNOWLEDGEBY" id="x_ACKNOWLEDGEBY" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->ACKNOWLEDGEBY->getPlaceHolder()) ?>" value="<?= $Page->ACKNOWLEDGEBY->EditValue ?>"<?= $Page->ACKNOWLEDGEBY->editAttributes() ?> aria-describedby="x_ACKNOWLEDGEBY_help">
<?= $Page->ACKNOWLEDGEBY->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ACKNOWLEDGEBY->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->NUM->Visible) { // NUM ?>
    <div id="r_NUM" class="form-group row">
        <label id="elh_PO_NUM" for="x_NUM" class="<?= $Page->LeftColumnClass ?>"><?= $Page->NUM->caption() ?><?= $Page->NUM->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->NUM->cellAttributes() ?>>
<span id="el_PO_NUM">
<input type="<?= $Page->NUM->getInputTextType() ?>" data-table="PO" data-field="x_NUM" name="x_NUM" id="x_NUM" size="30" placeholder="<?= HtmlEncode($Page->NUM->getPlaceHolder()) ?>" value="<?= $Page->NUM->EditValue ?>"<?= $Page->NUM->editAttributes() ?> aria-describedby="x_NUM_help">
<?= $Page->NUM->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->NUM->getErrorMessage() ?></div>
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
    ew.addEventHandlers("PO");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
