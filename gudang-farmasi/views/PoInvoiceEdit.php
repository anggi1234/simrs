<?php

namespace PHPMaker2021\SIMRSSQLSERVERGUDANGFARMASI;

// Page object
$PoInvoiceEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fPO_INVOICEedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fPO_INVOICEedit = currentForm = new ew.Form("fPO_INVOICEedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "PO_INVOICE")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.PO_INVOICE)
        ew.vars.tables.PO_INVOICE = currentTable;
    fPO_INVOICEedit.addFields([
        ["ORG_UNIT_CODE", [fields.ORG_UNIT_CODE.visible && fields.ORG_UNIT_CODE.required ? ew.Validators.required(fields.ORG_UNIT_CODE.caption) : null], fields.ORG_UNIT_CODE.isInvalid],
        ["INVOICE_ID", [fields.INVOICE_ID.visible && fields.INVOICE_ID.required ? ew.Validators.required(fields.INVOICE_ID.caption) : null], fields.INVOICE_ID.isInvalid],
        ["INVOICE_ID2", [fields.INVOICE_ID2.visible && fields.INVOICE_ID2.required ? ew.Validators.required(fields.INVOICE_ID2.caption) : null], fields.INVOICE_ID2.isInvalid],
        ["INVOICE_DATE", [fields.INVOICE_DATE.visible && fields.INVOICE_DATE.required ? ew.Validators.required(fields.INVOICE_DATE.caption) : null, ew.Validators.datetime(0)], fields.INVOICE_DATE.isInvalid],
        ["PO", [fields.PO.visible && fields.PO.required ? ew.Validators.required(fields.PO.caption) : null], fields.PO.isInvalid],
        ["COMPANY_ID", [fields.COMPANY_ID.visible && fields.COMPANY_ID.required ? ew.Validators.required(fields.COMPANY_ID.caption) : null], fields.COMPANY_ID.isInvalid],
        ["RECEIVED_DATE", [fields.RECEIVED_DATE.visible && fields.RECEIVED_DATE.required ? ew.Validators.required(fields.RECEIVED_DATE.caption) : null, ew.Validators.datetime(0)], fields.RECEIVED_DATE.isInvalid],
        ["AMOUNT", [fields.AMOUNT.visible && fields.AMOUNT.required ? ew.Validators.required(fields.AMOUNT.caption) : null, ew.Validators.float], fields.AMOUNT.isInvalid],
        ["PAYMENT_DUE", [fields.PAYMENT_DUE.visible && fields.PAYMENT_DUE.required ? ew.Validators.required(fields.PAYMENT_DUE.caption) : null, ew.Validators.datetime(0)], fields.PAYMENT_DUE.isInvalid],
        ["DESCRIPTION", [fields.DESCRIPTION.visible && fields.DESCRIPTION.required ? ew.Validators.required(fields.DESCRIPTION.caption) : null], fields.DESCRIPTION.isInvalid],
        ["MODIFIED_DATE", [fields.MODIFIED_DATE.visible && fields.MODIFIED_DATE.required ? ew.Validators.required(fields.MODIFIED_DATE.caption) : null, ew.Validators.datetime(0)], fields.MODIFIED_DATE.isInvalid],
        ["MODIFIED_BY", [fields.MODIFIED_BY.visible && fields.MODIFIED_BY.required ? ew.Validators.required(fields.MODIFIED_BY.caption) : null], fields.MODIFIED_BY.isInvalid],
        ["RECEIVED_BY", [fields.RECEIVED_BY.visible && fields.RECEIVED_BY.required ? ew.Validators.required(fields.RECEIVED_BY.caption) : null], fields.RECEIVED_BY.isInvalid],
        ["PRIORITY", [fields.PRIORITY.visible && fields.PRIORITY.required ? ew.Validators.required(fields.PRIORITY.caption) : null, ew.Validators.integer], fields.PRIORITY.isInvalid],
        ["CREDIT_NOTE", [fields.CREDIT_NOTE.visible && fields.CREDIT_NOTE.required ? ew.Validators.required(fields.CREDIT_NOTE.caption) : null], fields.CREDIT_NOTE.isInvalid],
        ["CREDIT_AMOUNT", [fields.CREDIT_AMOUNT.visible && fields.CREDIT_AMOUNT.required ? ew.Validators.required(fields.CREDIT_AMOUNT.caption) : null, ew.Validators.float], fields.CREDIT_AMOUNT.isInvalid],
        ["PPN", [fields.PPN.visible && fields.PPN.required ? ew.Validators.required(fields.PPN.caption) : null, ew.Validators.float], fields.PPN.isInvalid],
        ["MATERAI", [fields.MATERAI.visible && fields.MATERAI.required ? ew.Validators.required(fields.MATERAI.caption) : null, ew.Validators.float], fields.MATERAI.isInvalid],
        ["SENT_BY", [fields.SENT_BY.visible && fields.SENT_BY.required ? ew.Validators.required(fields.SENT_BY.caption) : null], fields.SENT_BY.isInvalid],
        ["ACCOUNT_ID", [fields.ACCOUNT_ID.visible && fields.ACCOUNT_ID.required ? ew.Validators.required(fields.ACCOUNT_ID.caption) : null, ew.Validators.integer], fields.ACCOUNT_ID.isInvalid],
        ["FINANCE_ID", [fields.FINANCE_ID.visible && fields.FINANCE_ID.required ? ew.Validators.required(fields.FINANCE_ID.caption) : null, ew.Validators.integer], fields.FINANCE_ID.isInvalid],
        ["potongan", [fields.potongan.visible && fields.potongan.required ? ew.Validators.required(fields.potongan.caption) : null, ew.Validators.float], fields.potongan.isInvalid],
        ["RECEIVED_VALUE", [fields.RECEIVED_VALUE.visible && fields.RECEIVED_VALUE.required ? ew.Validators.required(fields.RECEIVED_VALUE.caption) : null, ew.Validators.float], fields.RECEIVED_VALUE.isInvalid],
        ["NO_ORDER", [fields.NO_ORDER.visible && fields.NO_ORDER.required ? ew.Validators.required(fields.NO_ORDER.caption) : null], fields.NO_ORDER.isInvalid],
        ["CONTRACT_NO", [fields.CONTRACT_NO.visible && fields.CONTRACT_NO.required ? ew.Validators.required(fields.CONTRACT_NO.caption) : null], fields.CONTRACT_NO.isInvalid],
        ["ORG_ID", [fields.ORG_ID.visible && fields.ORG_ID.required ? ew.Validators.required(fields.ORG_ID.caption) : null], fields.ORG_ID.isInvalid],
        ["CLINIC_ID", [fields.CLINIC_ID.visible && fields.CLINIC_ID.required ? ew.Validators.required(fields.CLINIC_ID.caption) : null], fields.CLINIC_ID.isInvalid],
        ["PPN_VALUE", [fields.PPN_VALUE.visible && fields.PPN_VALUE.required ? ew.Validators.required(fields.PPN_VALUE.caption) : null, ew.Validators.float], fields.PPN_VALUE.isInvalid],
        ["DISCOUNT_VALUE", [fields.DISCOUNT_VALUE.visible && fields.DISCOUNT_VALUE.required ? ew.Validators.required(fields.DISCOUNT_VALUE.caption) : null, ew.Validators.float], fields.DISCOUNT_VALUE.isInvalid],
        ["PAID_VALUE", [fields.PAID_VALUE.visible && fields.PAID_VALUE.required ? ew.Validators.required(fields.PAID_VALUE.caption) : null, ew.Validators.float], fields.PAID_VALUE.isInvalid],
        ["ISCETAK", [fields.ISCETAK.visible && fields.ISCETAK.required ? ew.Validators.required(fields.ISCETAK.caption) : null], fields.ISCETAK.isInvalid],
        ["PRINT_DATE", [fields.PRINT_DATE.visible && fields.PRINT_DATE.required ? ew.Validators.required(fields.PRINT_DATE.caption) : null, ew.Validators.datetime(0)], fields.PRINT_DATE.isInvalid],
        ["PRINTED_BY", [fields.PRINTED_BY.visible && fields.PRINTED_BY.required ? ew.Validators.required(fields.PRINTED_BY.caption) : null], fields.PRINTED_BY.isInvalid],
        ["PRINTQ", [fields.PRINTQ.visible && fields.PRINTQ.required ? ew.Validators.required(fields.PRINTQ.caption) : null, ew.Validators.integer], fields.PRINTQ.isInvalid],
        ["FAKTUR_DATE", [fields.FAKTUR_DATE.visible && fields.FAKTUR_DATE.required ? ew.Validators.required(fields.FAKTUR_DATE.caption) : null, ew.Validators.datetime(0)], fields.FAKTUR_DATE.isInvalid],
        ["DISTRIBUTION_TYPE", [fields.DISTRIBUTION_TYPE.visible && fields.DISTRIBUTION_TYPE.required ? ew.Validators.required(fields.DISTRIBUTION_TYPE.caption) : null, ew.Validators.integer], fields.DISTRIBUTION_TYPE.isInvalid],
        ["DISCOUNTOFF_VALUE", [fields.DISCOUNTOFF_VALUE.visible && fields.DISCOUNTOFF_VALUE.required ? ew.Validators.required(fields.DISCOUNTOFF_VALUE.caption) : null, ew.Validators.float], fields.DISCOUNTOFF_VALUE.isInvalid],
        ["THECOUNTER", [fields.THECOUNTER.visible && fields.THECOUNTER.required ? ew.Validators.required(fields.THECOUNTER.caption) : null, ew.Validators.integer], fields.THECOUNTER.isInvalid],
        ["FUND_ID", [fields.FUND_ID.visible && fields.FUND_ID.required ? ew.Validators.required(fields.FUND_ID.caption) : null, ew.Validators.integer], fields.FUND_ID.isInvalid],
        ["ORDER_BY", [fields.ORDER_BY.visible && fields.ORDER_BY.required ? ew.Validators.required(fields.ORDER_BY.caption) : null], fields.ORDER_BY.isInvalid],
        ["ACKNOWLEDGEBY", [fields.ACKNOWLEDGEBY.visible && fields.ACKNOWLEDGEBY.required ? ew.Validators.required(fields.ACKNOWLEDGEBY.caption) : null], fields.ACKNOWLEDGEBY.isInvalid],
        ["NUM", [fields.NUM.visible && fields.NUM.required ? ew.Validators.required(fields.NUM.caption) : null, ew.Validators.integer], fields.NUM.isInvalid],
        ["ISPO", [fields.ISPO.visible && fields.ISPO.required ? ew.Validators.required(fields.ISPO.caption) : null], fields.ISPO.isInvalid],
        ["DOCS_TYPE", [fields.DOCS_TYPE.visible && fields.DOCS_TYPE.required ? ew.Validators.required(fields.DOCS_TYPE.caption) : null, ew.Validators.integer], fields.DOCS_TYPE.isInvalid],
        ["PO_DATE", [fields.PO_DATE.visible && fields.PO_DATE.required ? ew.Validators.required(fields.PO_DATE.caption) : null, ew.Validators.datetime(0)], fields.PO_DATE.isInvalid],
        ["PO_VALUE", [fields.PO_VALUE.visible && fields.PO_VALUE.required ? ew.Validators.required(fields.PO_VALUE.caption) : null, ew.Validators.float], fields.PO_VALUE.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fPO_INVOICEedit,
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
    fPO_INVOICEedit.validate = function () {
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
    fPO_INVOICEedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fPO_INVOICEedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fPO_INVOICEedit");
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
<form name="fPO_INVOICEedit" id="fPO_INVOICEedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="PO_INVOICE">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->ORG_UNIT_CODE->Visible) { // ORG_UNIT_CODE ?>
    <div id="r_ORG_UNIT_CODE" class="form-group row">
        <label id="elh_PO_INVOICE_ORG_UNIT_CODE" for="x_ORG_UNIT_CODE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ORG_UNIT_CODE->caption() ?><?= $Page->ORG_UNIT_CODE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ORG_UNIT_CODE->cellAttributes() ?>>
<span id="el_PO_INVOICE_ORG_UNIT_CODE">
<input type="<?= $Page->ORG_UNIT_CODE->getInputTextType() ?>" data-table="PO_INVOICE" data-field="x_ORG_UNIT_CODE" name="x_ORG_UNIT_CODE" id="x_ORG_UNIT_CODE" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->ORG_UNIT_CODE->getPlaceHolder()) ?>" value="<?= $Page->ORG_UNIT_CODE->EditValue ?>"<?= $Page->ORG_UNIT_CODE->editAttributes() ?> aria-describedby="x_ORG_UNIT_CODE_help">
<?= $Page->ORG_UNIT_CODE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ORG_UNIT_CODE->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->INVOICE_ID->Visible) { // INVOICE_ID ?>
    <div id="r_INVOICE_ID" class="form-group row">
        <label id="elh_PO_INVOICE_INVOICE_ID" for="x_INVOICE_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->INVOICE_ID->caption() ?><?= $Page->INVOICE_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->INVOICE_ID->cellAttributes() ?>>
<input type="<?= $Page->INVOICE_ID->getInputTextType() ?>" data-table="PO_INVOICE" data-field="x_INVOICE_ID" name="x_INVOICE_ID" id="x_INVOICE_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->INVOICE_ID->getPlaceHolder()) ?>" value="<?= $Page->INVOICE_ID->EditValue ?>"<?= $Page->INVOICE_ID->editAttributes() ?> aria-describedby="x_INVOICE_ID_help">
<?= $Page->INVOICE_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->INVOICE_ID->getErrorMessage() ?></div>
<input type="hidden" data-table="PO_INVOICE" data-field="x_INVOICE_ID" data-hidden="1" name="o_INVOICE_ID" id="o_INVOICE_ID" value="<?= HtmlEncode($Page->INVOICE_ID->OldValue ?? $Page->INVOICE_ID->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->INVOICE_ID2->Visible) { // INVOICE_ID2 ?>
    <div id="r_INVOICE_ID2" class="form-group row">
        <label id="elh_PO_INVOICE_INVOICE_ID2" for="x_INVOICE_ID2" class="<?= $Page->LeftColumnClass ?>"><?= $Page->INVOICE_ID2->caption() ?><?= $Page->INVOICE_ID2->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->INVOICE_ID2->cellAttributes() ?>>
<span id="el_PO_INVOICE_INVOICE_ID2">
<input type="<?= $Page->INVOICE_ID2->getInputTextType() ?>" data-table="PO_INVOICE" data-field="x_INVOICE_ID2" name="x_INVOICE_ID2" id="x_INVOICE_ID2" size="30" maxlength="25" placeholder="<?= HtmlEncode($Page->INVOICE_ID2->getPlaceHolder()) ?>" value="<?= $Page->INVOICE_ID2->EditValue ?>"<?= $Page->INVOICE_ID2->editAttributes() ?> aria-describedby="x_INVOICE_ID2_help">
<?= $Page->INVOICE_ID2->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->INVOICE_ID2->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->INVOICE_DATE->Visible) { // INVOICE_DATE ?>
    <div id="r_INVOICE_DATE" class="form-group row">
        <label id="elh_PO_INVOICE_INVOICE_DATE" for="x_INVOICE_DATE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->INVOICE_DATE->caption() ?><?= $Page->INVOICE_DATE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->INVOICE_DATE->cellAttributes() ?>>
<span id="el_PO_INVOICE_INVOICE_DATE">
<input type="<?= $Page->INVOICE_DATE->getInputTextType() ?>" data-table="PO_INVOICE" data-field="x_INVOICE_DATE" name="x_INVOICE_DATE" id="x_INVOICE_DATE" placeholder="<?= HtmlEncode($Page->INVOICE_DATE->getPlaceHolder()) ?>" value="<?= $Page->INVOICE_DATE->EditValue ?>"<?= $Page->INVOICE_DATE->editAttributes() ?> aria-describedby="x_INVOICE_DATE_help">
<?= $Page->INVOICE_DATE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->INVOICE_DATE->getErrorMessage() ?></div>
<?php if (!$Page->INVOICE_DATE->ReadOnly && !$Page->INVOICE_DATE->Disabled && !isset($Page->INVOICE_DATE->EditAttrs["readonly"]) && !isset($Page->INVOICE_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fPO_INVOICEedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fPO_INVOICEedit", "x_INVOICE_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->PO->Visible) { // PO ?>
    <div id="r_PO" class="form-group row">
        <label id="elh_PO_INVOICE_PO" for="x_PO" class="<?= $Page->LeftColumnClass ?>"><?= $Page->PO->caption() ?><?= $Page->PO->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PO->cellAttributes() ?>>
<span id="el_PO_INVOICE_PO">
<input type="<?= $Page->PO->getInputTextType() ?>" data-table="PO_INVOICE" data-field="x_PO" name="x_PO" id="x_PO" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->PO->getPlaceHolder()) ?>" value="<?= $Page->PO->EditValue ?>"<?= $Page->PO->editAttributes() ?> aria-describedby="x_PO_help">
<?= $Page->PO->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->PO->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->COMPANY_ID->Visible) { // COMPANY_ID ?>
    <div id="r_COMPANY_ID" class="form-group row">
        <label id="elh_PO_INVOICE_COMPANY_ID" for="x_COMPANY_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->COMPANY_ID->caption() ?><?= $Page->COMPANY_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->COMPANY_ID->cellAttributes() ?>>
<span id="el_PO_INVOICE_COMPANY_ID">
<input type="<?= $Page->COMPANY_ID->getInputTextType() ?>" data-table="PO_INVOICE" data-field="x_COMPANY_ID" name="x_COMPANY_ID" id="x_COMPANY_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->COMPANY_ID->getPlaceHolder()) ?>" value="<?= $Page->COMPANY_ID->EditValue ?>"<?= $Page->COMPANY_ID->editAttributes() ?> aria-describedby="x_COMPANY_ID_help">
<?= $Page->COMPANY_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->COMPANY_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->RECEIVED_DATE->Visible) { // RECEIVED_DATE ?>
    <div id="r_RECEIVED_DATE" class="form-group row">
        <label id="elh_PO_INVOICE_RECEIVED_DATE" for="x_RECEIVED_DATE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->RECEIVED_DATE->caption() ?><?= $Page->RECEIVED_DATE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->RECEIVED_DATE->cellAttributes() ?>>
<span id="el_PO_INVOICE_RECEIVED_DATE">
<input type="<?= $Page->RECEIVED_DATE->getInputTextType() ?>" data-table="PO_INVOICE" data-field="x_RECEIVED_DATE" name="x_RECEIVED_DATE" id="x_RECEIVED_DATE" placeholder="<?= HtmlEncode($Page->RECEIVED_DATE->getPlaceHolder()) ?>" value="<?= $Page->RECEIVED_DATE->EditValue ?>"<?= $Page->RECEIVED_DATE->editAttributes() ?> aria-describedby="x_RECEIVED_DATE_help">
<?= $Page->RECEIVED_DATE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->RECEIVED_DATE->getErrorMessage() ?></div>
<?php if (!$Page->RECEIVED_DATE->ReadOnly && !$Page->RECEIVED_DATE->Disabled && !isset($Page->RECEIVED_DATE->EditAttrs["readonly"]) && !isset($Page->RECEIVED_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fPO_INVOICEedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fPO_INVOICEedit", "x_RECEIVED_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->AMOUNT->Visible) { // AMOUNT ?>
    <div id="r_AMOUNT" class="form-group row">
        <label id="elh_PO_INVOICE_AMOUNT" for="x_AMOUNT" class="<?= $Page->LeftColumnClass ?>"><?= $Page->AMOUNT->caption() ?><?= $Page->AMOUNT->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->AMOUNT->cellAttributes() ?>>
<span id="el_PO_INVOICE_AMOUNT">
<input type="<?= $Page->AMOUNT->getInputTextType() ?>" data-table="PO_INVOICE" data-field="x_AMOUNT" name="x_AMOUNT" id="x_AMOUNT" size="30" placeholder="<?= HtmlEncode($Page->AMOUNT->getPlaceHolder()) ?>" value="<?= $Page->AMOUNT->EditValue ?>"<?= $Page->AMOUNT->editAttributes() ?> aria-describedby="x_AMOUNT_help">
<?= $Page->AMOUNT->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->AMOUNT->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->PAYMENT_DUE->Visible) { // PAYMENT_DUE ?>
    <div id="r_PAYMENT_DUE" class="form-group row">
        <label id="elh_PO_INVOICE_PAYMENT_DUE" for="x_PAYMENT_DUE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->PAYMENT_DUE->caption() ?><?= $Page->PAYMENT_DUE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PAYMENT_DUE->cellAttributes() ?>>
<span id="el_PO_INVOICE_PAYMENT_DUE">
<input type="<?= $Page->PAYMENT_DUE->getInputTextType() ?>" data-table="PO_INVOICE" data-field="x_PAYMENT_DUE" name="x_PAYMENT_DUE" id="x_PAYMENT_DUE" placeholder="<?= HtmlEncode($Page->PAYMENT_DUE->getPlaceHolder()) ?>" value="<?= $Page->PAYMENT_DUE->EditValue ?>"<?= $Page->PAYMENT_DUE->editAttributes() ?> aria-describedby="x_PAYMENT_DUE_help">
<?= $Page->PAYMENT_DUE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->PAYMENT_DUE->getErrorMessage() ?></div>
<?php if (!$Page->PAYMENT_DUE->ReadOnly && !$Page->PAYMENT_DUE->Disabled && !isset($Page->PAYMENT_DUE->EditAttrs["readonly"]) && !isset($Page->PAYMENT_DUE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fPO_INVOICEedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fPO_INVOICEedit", "x_PAYMENT_DUE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->DESCRIPTION->Visible) { // DESCRIPTION ?>
    <div id="r_DESCRIPTION" class="form-group row">
        <label id="elh_PO_INVOICE_DESCRIPTION" for="x_DESCRIPTION" class="<?= $Page->LeftColumnClass ?>"><?= $Page->DESCRIPTION->caption() ?><?= $Page->DESCRIPTION->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->DESCRIPTION->cellAttributes() ?>>
<span id="el_PO_INVOICE_DESCRIPTION">
<input type="<?= $Page->DESCRIPTION->getInputTextType() ?>" data-table="PO_INVOICE" data-field="x_DESCRIPTION" name="x_DESCRIPTION" id="x_DESCRIPTION" size="30" maxlength="200" placeholder="<?= HtmlEncode($Page->DESCRIPTION->getPlaceHolder()) ?>" value="<?= $Page->DESCRIPTION->EditValue ?>"<?= $Page->DESCRIPTION->editAttributes() ?> aria-describedby="x_DESCRIPTION_help">
<?= $Page->DESCRIPTION->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->DESCRIPTION->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
    <div id="r_MODIFIED_DATE" class="form-group row">
        <label id="elh_PO_INVOICE_MODIFIED_DATE" for="x_MODIFIED_DATE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->MODIFIED_DATE->caption() ?><?= $Page->MODIFIED_DATE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->MODIFIED_DATE->cellAttributes() ?>>
<span id="el_PO_INVOICE_MODIFIED_DATE">
<input type="<?= $Page->MODIFIED_DATE->getInputTextType() ?>" data-table="PO_INVOICE" data-field="x_MODIFIED_DATE" name="x_MODIFIED_DATE" id="x_MODIFIED_DATE" placeholder="<?= HtmlEncode($Page->MODIFIED_DATE->getPlaceHolder()) ?>" value="<?= $Page->MODIFIED_DATE->EditValue ?>"<?= $Page->MODIFIED_DATE->editAttributes() ?> aria-describedby="x_MODIFIED_DATE_help">
<?= $Page->MODIFIED_DATE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->MODIFIED_DATE->getErrorMessage() ?></div>
<?php if (!$Page->MODIFIED_DATE->ReadOnly && !$Page->MODIFIED_DATE->Disabled && !isset($Page->MODIFIED_DATE->EditAttrs["readonly"]) && !isset($Page->MODIFIED_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fPO_INVOICEedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fPO_INVOICEedit", "x_MODIFIED_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
    <div id="r_MODIFIED_BY" class="form-group row">
        <label id="elh_PO_INVOICE_MODIFIED_BY" for="x_MODIFIED_BY" class="<?= $Page->LeftColumnClass ?>"><?= $Page->MODIFIED_BY->caption() ?><?= $Page->MODIFIED_BY->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->MODIFIED_BY->cellAttributes() ?>>
<span id="el_PO_INVOICE_MODIFIED_BY">
<input type="<?= $Page->MODIFIED_BY->getInputTextType() ?>" data-table="PO_INVOICE" data-field="x_MODIFIED_BY" name="x_MODIFIED_BY" id="x_MODIFIED_BY" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->MODIFIED_BY->getPlaceHolder()) ?>" value="<?= $Page->MODIFIED_BY->EditValue ?>"<?= $Page->MODIFIED_BY->editAttributes() ?> aria-describedby="x_MODIFIED_BY_help">
<?= $Page->MODIFIED_BY->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->MODIFIED_BY->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->RECEIVED_BY->Visible) { // RECEIVED_BY ?>
    <div id="r_RECEIVED_BY" class="form-group row">
        <label id="elh_PO_INVOICE_RECEIVED_BY" for="x_RECEIVED_BY" class="<?= $Page->LeftColumnClass ?>"><?= $Page->RECEIVED_BY->caption() ?><?= $Page->RECEIVED_BY->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->RECEIVED_BY->cellAttributes() ?>>
<span id="el_PO_INVOICE_RECEIVED_BY">
<input type="<?= $Page->RECEIVED_BY->getInputTextType() ?>" data-table="PO_INVOICE" data-field="x_RECEIVED_BY" name="x_RECEIVED_BY" id="x_RECEIVED_BY" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->RECEIVED_BY->getPlaceHolder()) ?>" value="<?= $Page->RECEIVED_BY->EditValue ?>"<?= $Page->RECEIVED_BY->editAttributes() ?> aria-describedby="x_RECEIVED_BY_help">
<?= $Page->RECEIVED_BY->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->RECEIVED_BY->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->PRIORITY->Visible) { // PRIORITY ?>
    <div id="r_PRIORITY" class="form-group row">
        <label id="elh_PO_INVOICE_PRIORITY" for="x_PRIORITY" class="<?= $Page->LeftColumnClass ?>"><?= $Page->PRIORITY->caption() ?><?= $Page->PRIORITY->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PRIORITY->cellAttributes() ?>>
<span id="el_PO_INVOICE_PRIORITY">
<input type="<?= $Page->PRIORITY->getInputTextType() ?>" data-table="PO_INVOICE" data-field="x_PRIORITY" name="x_PRIORITY" id="x_PRIORITY" size="30" placeholder="<?= HtmlEncode($Page->PRIORITY->getPlaceHolder()) ?>" value="<?= $Page->PRIORITY->EditValue ?>"<?= $Page->PRIORITY->editAttributes() ?> aria-describedby="x_PRIORITY_help">
<?= $Page->PRIORITY->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->PRIORITY->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->CREDIT_NOTE->Visible) { // CREDIT_NOTE ?>
    <div id="r_CREDIT_NOTE" class="form-group row">
        <label id="elh_PO_INVOICE_CREDIT_NOTE" for="x_CREDIT_NOTE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->CREDIT_NOTE->caption() ?><?= $Page->CREDIT_NOTE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->CREDIT_NOTE->cellAttributes() ?>>
<span id="el_PO_INVOICE_CREDIT_NOTE">
<input type="<?= $Page->CREDIT_NOTE->getInputTextType() ?>" data-table="PO_INVOICE" data-field="x_CREDIT_NOTE" name="x_CREDIT_NOTE" id="x_CREDIT_NOTE" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->CREDIT_NOTE->getPlaceHolder()) ?>" value="<?= $Page->CREDIT_NOTE->EditValue ?>"<?= $Page->CREDIT_NOTE->editAttributes() ?> aria-describedby="x_CREDIT_NOTE_help">
<?= $Page->CREDIT_NOTE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->CREDIT_NOTE->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->CREDIT_AMOUNT->Visible) { // CREDIT_AMOUNT ?>
    <div id="r_CREDIT_AMOUNT" class="form-group row">
        <label id="elh_PO_INVOICE_CREDIT_AMOUNT" for="x_CREDIT_AMOUNT" class="<?= $Page->LeftColumnClass ?>"><?= $Page->CREDIT_AMOUNT->caption() ?><?= $Page->CREDIT_AMOUNT->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->CREDIT_AMOUNT->cellAttributes() ?>>
<span id="el_PO_INVOICE_CREDIT_AMOUNT">
<input type="<?= $Page->CREDIT_AMOUNT->getInputTextType() ?>" data-table="PO_INVOICE" data-field="x_CREDIT_AMOUNT" name="x_CREDIT_AMOUNT" id="x_CREDIT_AMOUNT" size="30" placeholder="<?= HtmlEncode($Page->CREDIT_AMOUNT->getPlaceHolder()) ?>" value="<?= $Page->CREDIT_AMOUNT->EditValue ?>"<?= $Page->CREDIT_AMOUNT->editAttributes() ?> aria-describedby="x_CREDIT_AMOUNT_help">
<?= $Page->CREDIT_AMOUNT->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->CREDIT_AMOUNT->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->PPN->Visible) { // PPN ?>
    <div id="r_PPN" class="form-group row">
        <label id="elh_PO_INVOICE_PPN" for="x_PPN" class="<?= $Page->LeftColumnClass ?>"><?= $Page->PPN->caption() ?><?= $Page->PPN->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PPN->cellAttributes() ?>>
<span id="el_PO_INVOICE_PPN">
<input type="<?= $Page->PPN->getInputTextType() ?>" data-table="PO_INVOICE" data-field="x_PPN" name="x_PPN" id="x_PPN" size="30" placeholder="<?= HtmlEncode($Page->PPN->getPlaceHolder()) ?>" value="<?= $Page->PPN->EditValue ?>"<?= $Page->PPN->editAttributes() ?> aria-describedby="x_PPN_help">
<?= $Page->PPN->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->PPN->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->MATERAI->Visible) { // MATERAI ?>
    <div id="r_MATERAI" class="form-group row">
        <label id="elh_PO_INVOICE_MATERAI" for="x_MATERAI" class="<?= $Page->LeftColumnClass ?>"><?= $Page->MATERAI->caption() ?><?= $Page->MATERAI->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->MATERAI->cellAttributes() ?>>
<span id="el_PO_INVOICE_MATERAI">
<input type="<?= $Page->MATERAI->getInputTextType() ?>" data-table="PO_INVOICE" data-field="x_MATERAI" name="x_MATERAI" id="x_MATERAI" size="30" placeholder="<?= HtmlEncode($Page->MATERAI->getPlaceHolder()) ?>" value="<?= $Page->MATERAI->EditValue ?>"<?= $Page->MATERAI->editAttributes() ?> aria-describedby="x_MATERAI_help">
<?= $Page->MATERAI->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->MATERAI->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->SENT_BY->Visible) { // SENT_BY ?>
    <div id="r_SENT_BY" class="form-group row">
        <label id="elh_PO_INVOICE_SENT_BY" for="x_SENT_BY" class="<?= $Page->LeftColumnClass ?>"><?= $Page->SENT_BY->caption() ?><?= $Page->SENT_BY->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->SENT_BY->cellAttributes() ?>>
<span id="el_PO_INVOICE_SENT_BY">
<input type="<?= $Page->SENT_BY->getInputTextType() ?>" data-table="PO_INVOICE" data-field="x_SENT_BY" name="x_SENT_BY" id="x_SENT_BY" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->SENT_BY->getPlaceHolder()) ?>" value="<?= $Page->SENT_BY->EditValue ?>"<?= $Page->SENT_BY->editAttributes() ?> aria-describedby="x_SENT_BY_help">
<?= $Page->SENT_BY->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->SENT_BY->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ACCOUNT_ID->Visible) { // ACCOUNT_ID ?>
    <div id="r_ACCOUNT_ID" class="form-group row">
        <label id="elh_PO_INVOICE_ACCOUNT_ID" for="x_ACCOUNT_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ACCOUNT_ID->caption() ?><?= $Page->ACCOUNT_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ACCOUNT_ID->cellAttributes() ?>>
<span id="el_PO_INVOICE_ACCOUNT_ID">
<input type="<?= $Page->ACCOUNT_ID->getInputTextType() ?>" data-table="PO_INVOICE" data-field="x_ACCOUNT_ID" name="x_ACCOUNT_ID" id="x_ACCOUNT_ID" size="30" placeholder="<?= HtmlEncode($Page->ACCOUNT_ID->getPlaceHolder()) ?>" value="<?= $Page->ACCOUNT_ID->EditValue ?>"<?= $Page->ACCOUNT_ID->editAttributes() ?> aria-describedby="x_ACCOUNT_ID_help">
<?= $Page->ACCOUNT_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ACCOUNT_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->FINANCE_ID->Visible) { // FINANCE_ID ?>
    <div id="r_FINANCE_ID" class="form-group row">
        <label id="elh_PO_INVOICE_FINANCE_ID" for="x_FINANCE_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->FINANCE_ID->caption() ?><?= $Page->FINANCE_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->FINANCE_ID->cellAttributes() ?>>
<span id="el_PO_INVOICE_FINANCE_ID">
<input type="<?= $Page->FINANCE_ID->getInputTextType() ?>" data-table="PO_INVOICE" data-field="x_FINANCE_ID" name="x_FINANCE_ID" id="x_FINANCE_ID" size="30" placeholder="<?= HtmlEncode($Page->FINANCE_ID->getPlaceHolder()) ?>" value="<?= $Page->FINANCE_ID->EditValue ?>"<?= $Page->FINANCE_ID->editAttributes() ?> aria-describedby="x_FINANCE_ID_help">
<?= $Page->FINANCE_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->FINANCE_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->potongan->Visible) { // potongan ?>
    <div id="r_potongan" class="form-group row">
        <label id="elh_PO_INVOICE_potongan" for="x_potongan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->potongan->caption() ?><?= $Page->potongan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->potongan->cellAttributes() ?>>
<span id="el_PO_INVOICE_potongan">
<input type="<?= $Page->potongan->getInputTextType() ?>" data-table="PO_INVOICE" data-field="x_potongan" name="x_potongan" id="x_potongan" size="30" placeholder="<?= HtmlEncode($Page->potongan->getPlaceHolder()) ?>" value="<?= $Page->potongan->EditValue ?>"<?= $Page->potongan->editAttributes() ?> aria-describedby="x_potongan_help">
<?= $Page->potongan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->potongan->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->RECEIVED_VALUE->Visible) { // RECEIVED_VALUE ?>
    <div id="r_RECEIVED_VALUE" class="form-group row">
        <label id="elh_PO_INVOICE_RECEIVED_VALUE" for="x_RECEIVED_VALUE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->RECEIVED_VALUE->caption() ?><?= $Page->RECEIVED_VALUE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->RECEIVED_VALUE->cellAttributes() ?>>
<span id="el_PO_INVOICE_RECEIVED_VALUE">
<input type="<?= $Page->RECEIVED_VALUE->getInputTextType() ?>" data-table="PO_INVOICE" data-field="x_RECEIVED_VALUE" name="x_RECEIVED_VALUE" id="x_RECEIVED_VALUE" size="30" placeholder="<?= HtmlEncode($Page->RECEIVED_VALUE->getPlaceHolder()) ?>" value="<?= $Page->RECEIVED_VALUE->EditValue ?>"<?= $Page->RECEIVED_VALUE->editAttributes() ?> aria-describedby="x_RECEIVED_VALUE_help">
<?= $Page->RECEIVED_VALUE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->RECEIVED_VALUE->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->NO_ORDER->Visible) { // NO_ORDER ?>
    <div id="r_NO_ORDER" class="form-group row">
        <label id="elh_PO_INVOICE_NO_ORDER" for="x_NO_ORDER" class="<?= $Page->LeftColumnClass ?>"><?= $Page->NO_ORDER->caption() ?><?= $Page->NO_ORDER->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->NO_ORDER->cellAttributes() ?>>
<span id="el_PO_INVOICE_NO_ORDER">
<input type="<?= $Page->NO_ORDER->getInputTextType() ?>" data-table="PO_INVOICE" data-field="x_NO_ORDER" name="x_NO_ORDER" id="x_NO_ORDER" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->NO_ORDER->getPlaceHolder()) ?>" value="<?= $Page->NO_ORDER->EditValue ?>"<?= $Page->NO_ORDER->editAttributes() ?> aria-describedby="x_NO_ORDER_help">
<?= $Page->NO_ORDER->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->NO_ORDER->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->CONTRACT_NO->Visible) { // CONTRACT_NO ?>
    <div id="r_CONTRACT_NO" class="form-group row">
        <label id="elh_PO_INVOICE_CONTRACT_NO" for="x_CONTRACT_NO" class="<?= $Page->LeftColumnClass ?>"><?= $Page->CONTRACT_NO->caption() ?><?= $Page->CONTRACT_NO->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->CONTRACT_NO->cellAttributes() ?>>
<span id="el_PO_INVOICE_CONTRACT_NO">
<input type="<?= $Page->CONTRACT_NO->getInputTextType() ?>" data-table="PO_INVOICE" data-field="x_CONTRACT_NO" name="x_CONTRACT_NO" id="x_CONTRACT_NO" size="30" maxlength="25" placeholder="<?= HtmlEncode($Page->CONTRACT_NO->getPlaceHolder()) ?>" value="<?= $Page->CONTRACT_NO->EditValue ?>"<?= $Page->CONTRACT_NO->editAttributes() ?> aria-describedby="x_CONTRACT_NO_help">
<?= $Page->CONTRACT_NO->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->CONTRACT_NO->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ORG_ID->Visible) { // ORG_ID ?>
    <div id="r_ORG_ID" class="form-group row">
        <label id="elh_PO_INVOICE_ORG_ID" for="x_ORG_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ORG_ID->caption() ?><?= $Page->ORG_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ORG_ID->cellAttributes() ?>>
<span id="el_PO_INVOICE_ORG_ID">
<input type="<?= $Page->ORG_ID->getInputTextType() ?>" data-table="PO_INVOICE" data-field="x_ORG_ID" name="x_ORG_ID" id="x_ORG_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->ORG_ID->getPlaceHolder()) ?>" value="<?= $Page->ORG_ID->EditValue ?>"<?= $Page->ORG_ID->editAttributes() ?> aria-describedby="x_ORG_ID_help">
<?= $Page->ORG_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ORG_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->CLINIC_ID->Visible) { // CLINIC_ID ?>
    <div id="r_CLINIC_ID" class="form-group row">
        <label id="elh_PO_INVOICE_CLINIC_ID" for="x_CLINIC_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->CLINIC_ID->caption() ?><?= $Page->CLINIC_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->CLINIC_ID->cellAttributes() ?>>
<span id="el_PO_INVOICE_CLINIC_ID">
<input type="<?= $Page->CLINIC_ID->getInputTextType() ?>" data-table="PO_INVOICE" data-field="x_CLINIC_ID" name="x_CLINIC_ID" id="x_CLINIC_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->CLINIC_ID->getPlaceHolder()) ?>" value="<?= $Page->CLINIC_ID->EditValue ?>"<?= $Page->CLINIC_ID->editAttributes() ?> aria-describedby="x_CLINIC_ID_help">
<?= $Page->CLINIC_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->CLINIC_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->PPN_VALUE->Visible) { // PPN_VALUE ?>
    <div id="r_PPN_VALUE" class="form-group row">
        <label id="elh_PO_INVOICE_PPN_VALUE" for="x_PPN_VALUE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->PPN_VALUE->caption() ?><?= $Page->PPN_VALUE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PPN_VALUE->cellAttributes() ?>>
<span id="el_PO_INVOICE_PPN_VALUE">
<input type="<?= $Page->PPN_VALUE->getInputTextType() ?>" data-table="PO_INVOICE" data-field="x_PPN_VALUE" name="x_PPN_VALUE" id="x_PPN_VALUE" size="30" placeholder="<?= HtmlEncode($Page->PPN_VALUE->getPlaceHolder()) ?>" value="<?= $Page->PPN_VALUE->EditValue ?>"<?= $Page->PPN_VALUE->editAttributes() ?> aria-describedby="x_PPN_VALUE_help">
<?= $Page->PPN_VALUE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->PPN_VALUE->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->DISCOUNT_VALUE->Visible) { // DISCOUNT_VALUE ?>
    <div id="r_DISCOUNT_VALUE" class="form-group row">
        <label id="elh_PO_INVOICE_DISCOUNT_VALUE" for="x_DISCOUNT_VALUE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->DISCOUNT_VALUE->caption() ?><?= $Page->DISCOUNT_VALUE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->DISCOUNT_VALUE->cellAttributes() ?>>
<span id="el_PO_INVOICE_DISCOUNT_VALUE">
<input type="<?= $Page->DISCOUNT_VALUE->getInputTextType() ?>" data-table="PO_INVOICE" data-field="x_DISCOUNT_VALUE" name="x_DISCOUNT_VALUE" id="x_DISCOUNT_VALUE" size="30" placeholder="<?= HtmlEncode($Page->DISCOUNT_VALUE->getPlaceHolder()) ?>" value="<?= $Page->DISCOUNT_VALUE->EditValue ?>"<?= $Page->DISCOUNT_VALUE->editAttributes() ?> aria-describedby="x_DISCOUNT_VALUE_help">
<?= $Page->DISCOUNT_VALUE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->DISCOUNT_VALUE->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->PAID_VALUE->Visible) { // PAID_VALUE ?>
    <div id="r_PAID_VALUE" class="form-group row">
        <label id="elh_PO_INVOICE_PAID_VALUE" for="x_PAID_VALUE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->PAID_VALUE->caption() ?><?= $Page->PAID_VALUE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PAID_VALUE->cellAttributes() ?>>
<span id="el_PO_INVOICE_PAID_VALUE">
<input type="<?= $Page->PAID_VALUE->getInputTextType() ?>" data-table="PO_INVOICE" data-field="x_PAID_VALUE" name="x_PAID_VALUE" id="x_PAID_VALUE" size="30" placeholder="<?= HtmlEncode($Page->PAID_VALUE->getPlaceHolder()) ?>" value="<?= $Page->PAID_VALUE->EditValue ?>"<?= $Page->PAID_VALUE->editAttributes() ?> aria-describedby="x_PAID_VALUE_help">
<?= $Page->PAID_VALUE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->PAID_VALUE->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ISCETAK->Visible) { // ISCETAK ?>
    <div id="r_ISCETAK" class="form-group row">
        <label id="elh_PO_INVOICE_ISCETAK" for="x_ISCETAK" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ISCETAK->caption() ?><?= $Page->ISCETAK->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ISCETAK->cellAttributes() ?>>
<span id="el_PO_INVOICE_ISCETAK">
<input type="<?= $Page->ISCETAK->getInputTextType() ?>" data-table="PO_INVOICE" data-field="x_ISCETAK" name="x_ISCETAK" id="x_ISCETAK" size="30" maxlength="1" placeholder="<?= HtmlEncode($Page->ISCETAK->getPlaceHolder()) ?>" value="<?= $Page->ISCETAK->EditValue ?>"<?= $Page->ISCETAK->editAttributes() ?> aria-describedby="x_ISCETAK_help">
<?= $Page->ISCETAK->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ISCETAK->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->PRINT_DATE->Visible) { // PRINT_DATE ?>
    <div id="r_PRINT_DATE" class="form-group row">
        <label id="elh_PO_INVOICE_PRINT_DATE" for="x_PRINT_DATE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->PRINT_DATE->caption() ?><?= $Page->PRINT_DATE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PRINT_DATE->cellAttributes() ?>>
<span id="el_PO_INVOICE_PRINT_DATE">
<input type="<?= $Page->PRINT_DATE->getInputTextType() ?>" data-table="PO_INVOICE" data-field="x_PRINT_DATE" name="x_PRINT_DATE" id="x_PRINT_DATE" placeholder="<?= HtmlEncode($Page->PRINT_DATE->getPlaceHolder()) ?>" value="<?= $Page->PRINT_DATE->EditValue ?>"<?= $Page->PRINT_DATE->editAttributes() ?> aria-describedby="x_PRINT_DATE_help">
<?= $Page->PRINT_DATE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->PRINT_DATE->getErrorMessage() ?></div>
<?php if (!$Page->PRINT_DATE->ReadOnly && !$Page->PRINT_DATE->Disabled && !isset($Page->PRINT_DATE->EditAttrs["readonly"]) && !isset($Page->PRINT_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fPO_INVOICEedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fPO_INVOICEedit", "x_PRINT_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->PRINTED_BY->Visible) { // PRINTED_BY ?>
    <div id="r_PRINTED_BY" class="form-group row">
        <label id="elh_PO_INVOICE_PRINTED_BY" for="x_PRINTED_BY" class="<?= $Page->LeftColumnClass ?>"><?= $Page->PRINTED_BY->caption() ?><?= $Page->PRINTED_BY->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PRINTED_BY->cellAttributes() ?>>
<span id="el_PO_INVOICE_PRINTED_BY">
<input type="<?= $Page->PRINTED_BY->getInputTextType() ?>" data-table="PO_INVOICE" data-field="x_PRINTED_BY" name="x_PRINTED_BY" id="x_PRINTED_BY" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->PRINTED_BY->getPlaceHolder()) ?>" value="<?= $Page->PRINTED_BY->EditValue ?>"<?= $Page->PRINTED_BY->editAttributes() ?> aria-describedby="x_PRINTED_BY_help">
<?= $Page->PRINTED_BY->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->PRINTED_BY->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->PRINTQ->Visible) { // PRINTQ ?>
    <div id="r_PRINTQ" class="form-group row">
        <label id="elh_PO_INVOICE_PRINTQ" for="x_PRINTQ" class="<?= $Page->LeftColumnClass ?>"><?= $Page->PRINTQ->caption() ?><?= $Page->PRINTQ->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PRINTQ->cellAttributes() ?>>
<span id="el_PO_INVOICE_PRINTQ">
<input type="<?= $Page->PRINTQ->getInputTextType() ?>" data-table="PO_INVOICE" data-field="x_PRINTQ" name="x_PRINTQ" id="x_PRINTQ" size="30" placeholder="<?= HtmlEncode($Page->PRINTQ->getPlaceHolder()) ?>" value="<?= $Page->PRINTQ->EditValue ?>"<?= $Page->PRINTQ->editAttributes() ?> aria-describedby="x_PRINTQ_help">
<?= $Page->PRINTQ->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->PRINTQ->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->FAKTUR_DATE->Visible) { // FAKTUR_DATE ?>
    <div id="r_FAKTUR_DATE" class="form-group row">
        <label id="elh_PO_INVOICE_FAKTUR_DATE" for="x_FAKTUR_DATE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->FAKTUR_DATE->caption() ?><?= $Page->FAKTUR_DATE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->FAKTUR_DATE->cellAttributes() ?>>
<span id="el_PO_INVOICE_FAKTUR_DATE">
<input type="<?= $Page->FAKTUR_DATE->getInputTextType() ?>" data-table="PO_INVOICE" data-field="x_FAKTUR_DATE" name="x_FAKTUR_DATE" id="x_FAKTUR_DATE" placeholder="<?= HtmlEncode($Page->FAKTUR_DATE->getPlaceHolder()) ?>" value="<?= $Page->FAKTUR_DATE->EditValue ?>"<?= $Page->FAKTUR_DATE->editAttributes() ?> aria-describedby="x_FAKTUR_DATE_help">
<?= $Page->FAKTUR_DATE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->FAKTUR_DATE->getErrorMessage() ?></div>
<?php if (!$Page->FAKTUR_DATE->ReadOnly && !$Page->FAKTUR_DATE->Disabled && !isset($Page->FAKTUR_DATE->EditAttrs["readonly"]) && !isset($Page->FAKTUR_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fPO_INVOICEedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fPO_INVOICEedit", "x_FAKTUR_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->DISTRIBUTION_TYPE->Visible) { // DISTRIBUTION_TYPE ?>
    <div id="r_DISTRIBUTION_TYPE" class="form-group row">
        <label id="elh_PO_INVOICE_DISTRIBUTION_TYPE" for="x_DISTRIBUTION_TYPE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->DISTRIBUTION_TYPE->caption() ?><?= $Page->DISTRIBUTION_TYPE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->DISTRIBUTION_TYPE->cellAttributes() ?>>
<span id="el_PO_INVOICE_DISTRIBUTION_TYPE">
<input type="<?= $Page->DISTRIBUTION_TYPE->getInputTextType() ?>" data-table="PO_INVOICE" data-field="x_DISTRIBUTION_TYPE" name="x_DISTRIBUTION_TYPE" id="x_DISTRIBUTION_TYPE" size="30" placeholder="<?= HtmlEncode($Page->DISTRIBUTION_TYPE->getPlaceHolder()) ?>" value="<?= $Page->DISTRIBUTION_TYPE->EditValue ?>"<?= $Page->DISTRIBUTION_TYPE->editAttributes() ?> aria-describedby="x_DISTRIBUTION_TYPE_help">
<?= $Page->DISTRIBUTION_TYPE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->DISTRIBUTION_TYPE->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->DISCOUNTOFF_VALUE->Visible) { // DISCOUNTOFF_VALUE ?>
    <div id="r_DISCOUNTOFF_VALUE" class="form-group row">
        <label id="elh_PO_INVOICE_DISCOUNTOFF_VALUE" for="x_DISCOUNTOFF_VALUE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->DISCOUNTOFF_VALUE->caption() ?><?= $Page->DISCOUNTOFF_VALUE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->DISCOUNTOFF_VALUE->cellAttributes() ?>>
<span id="el_PO_INVOICE_DISCOUNTOFF_VALUE">
<input type="<?= $Page->DISCOUNTOFF_VALUE->getInputTextType() ?>" data-table="PO_INVOICE" data-field="x_DISCOUNTOFF_VALUE" name="x_DISCOUNTOFF_VALUE" id="x_DISCOUNTOFF_VALUE" size="30" placeholder="<?= HtmlEncode($Page->DISCOUNTOFF_VALUE->getPlaceHolder()) ?>" value="<?= $Page->DISCOUNTOFF_VALUE->EditValue ?>"<?= $Page->DISCOUNTOFF_VALUE->editAttributes() ?> aria-describedby="x_DISCOUNTOFF_VALUE_help">
<?= $Page->DISCOUNTOFF_VALUE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->DISCOUNTOFF_VALUE->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->THECOUNTER->Visible) { // THECOUNTER ?>
    <div id="r_THECOUNTER" class="form-group row">
        <label id="elh_PO_INVOICE_THECOUNTER" for="x_THECOUNTER" class="<?= $Page->LeftColumnClass ?>"><?= $Page->THECOUNTER->caption() ?><?= $Page->THECOUNTER->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->THECOUNTER->cellAttributes() ?>>
<span id="el_PO_INVOICE_THECOUNTER">
<input type="<?= $Page->THECOUNTER->getInputTextType() ?>" data-table="PO_INVOICE" data-field="x_THECOUNTER" name="x_THECOUNTER" id="x_THECOUNTER" size="30" placeholder="<?= HtmlEncode($Page->THECOUNTER->getPlaceHolder()) ?>" value="<?= $Page->THECOUNTER->EditValue ?>"<?= $Page->THECOUNTER->editAttributes() ?> aria-describedby="x_THECOUNTER_help">
<?= $Page->THECOUNTER->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->THECOUNTER->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->FUND_ID->Visible) { // FUND_ID ?>
    <div id="r_FUND_ID" class="form-group row">
        <label id="elh_PO_INVOICE_FUND_ID" for="x_FUND_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->FUND_ID->caption() ?><?= $Page->FUND_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->FUND_ID->cellAttributes() ?>>
<span id="el_PO_INVOICE_FUND_ID">
<input type="<?= $Page->FUND_ID->getInputTextType() ?>" data-table="PO_INVOICE" data-field="x_FUND_ID" name="x_FUND_ID" id="x_FUND_ID" size="30" placeholder="<?= HtmlEncode($Page->FUND_ID->getPlaceHolder()) ?>" value="<?= $Page->FUND_ID->EditValue ?>"<?= $Page->FUND_ID->editAttributes() ?> aria-describedby="x_FUND_ID_help">
<?= $Page->FUND_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->FUND_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ORDER_BY->Visible) { // ORDER_BY ?>
    <div id="r_ORDER_BY" class="form-group row">
        <label id="elh_PO_INVOICE_ORDER_BY" for="x_ORDER_BY" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ORDER_BY->caption() ?><?= $Page->ORDER_BY->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ORDER_BY->cellAttributes() ?>>
<span id="el_PO_INVOICE_ORDER_BY">
<input type="<?= $Page->ORDER_BY->getInputTextType() ?>" data-table="PO_INVOICE" data-field="x_ORDER_BY" name="x_ORDER_BY" id="x_ORDER_BY" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->ORDER_BY->getPlaceHolder()) ?>" value="<?= $Page->ORDER_BY->EditValue ?>"<?= $Page->ORDER_BY->editAttributes() ?> aria-describedby="x_ORDER_BY_help">
<?= $Page->ORDER_BY->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ORDER_BY->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ACKNOWLEDGEBY->Visible) { // ACKNOWLEDGEBY ?>
    <div id="r_ACKNOWLEDGEBY" class="form-group row">
        <label id="elh_PO_INVOICE_ACKNOWLEDGEBY" for="x_ACKNOWLEDGEBY" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ACKNOWLEDGEBY->caption() ?><?= $Page->ACKNOWLEDGEBY->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ACKNOWLEDGEBY->cellAttributes() ?>>
<span id="el_PO_INVOICE_ACKNOWLEDGEBY">
<input type="<?= $Page->ACKNOWLEDGEBY->getInputTextType() ?>" data-table="PO_INVOICE" data-field="x_ACKNOWLEDGEBY" name="x_ACKNOWLEDGEBY" id="x_ACKNOWLEDGEBY" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->ACKNOWLEDGEBY->getPlaceHolder()) ?>" value="<?= $Page->ACKNOWLEDGEBY->EditValue ?>"<?= $Page->ACKNOWLEDGEBY->editAttributes() ?> aria-describedby="x_ACKNOWLEDGEBY_help">
<?= $Page->ACKNOWLEDGEBY->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ACKNOWLEDGEBY->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->NUM->Visible) { // NUM ?>
    <div id="r_NUM" class="form-group row">
        <label id="elh_PO_INVOICE_NUM" for="x_NUM" class="<?= $Page->LeftColumnClass ?>"><?= $Page->NUM->caption() ?><?= $Page->NUM->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->NUM->cellAttributes() ?>>
<span id="el_PO_INVOICE_NUM">
<input type="<?= $Page->NUM->getInputTextType() ?>" data-table="PO_INVOICE" data-field="x_NUM" name="x_NUM" id="x_NUM" size="30" placeholder="<?= HtmlEncode($Page->NUM->getPlaceHolder()) ?>" value="<?= $Page->NUM->EditValue ?>"<?= $Page->NUM->editAttributes() ?> aria-describedby="x_NUM_help">
<?= $Page->NUM->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->NUM->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ISPO->Visible) { // ISPO ?>
    <div id="r_ISPO" class="form-group row">
        <label id="elh_PO_INVOICE_ISPO" for="x_ISPO" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ISPO->caption() ?><?= $Page->ISPO->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ISPO->cellAttributes() ?>>
<span id="el_PO_INVOICE_ISPO">
<input type="<?= $Page->ISPO->getInputTextType() ?>" data-table="PO_INVOICE" data-field="x_ISPO" name="x_ISPO" id="x_ISPO" size="30" maxlength="1" placeholder="<?= HtmlEncode($Page->ISPO->getPlaceHolder()) ?>" value="<?= $Page->ISPO->EditValue ?>"<?= $Page->ISPO->editAttributes() ?> aria-describedby="x_ISPO_help">
<?= $Page->ISPO->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ISPO->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->DOCS_TYPE->Visible) { // DOCS_TYPE ?>
    <div id="r_DOCS_TYPE" class="form-group row">
        <label id="elh_PO_INVOICE_DOCS_TYPE" for="x_DOCS_TYPE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->DOCS_TYPE->caption() ?><?= $Page->DOCS_TYPE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->DOCS_TYPE->cellAttributes() ?>>
<span id="el_PO_INVOICE_DOCS_TYPE">
<input type="<?= $Page->DOCS_TYPE->getInputTextType() ?>" data-table="PO_INVOICE" data-field="x_DOCS_TYPE" name="x_DOCS_TYPE" id="x_DOCS_TYPE" size="30" placeholder="<?= HtmlEncode($Page->DOCS_TYPE->getPlaceHolder()) ?>" value="<?= $Page->DOCS_TYPE->EditValue ?>"<?= $Page->DOCS_TYPE->editAttributes() ?> aria-describedby="x_DOCS_TYPE_help">
<?= $Page->DOCS_TYPE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->DOCS_TYPE->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->PO_DATE->Visible) { // PO_DATE ?>
    <div id="r_PO_DATE" class="form-group row">
        <label id="elh_PO_INVOICE_PO_DATE" for="x_PO_DATE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->PO_DATE->caption() ?><?= $Page->PO_DATE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PO_DATE->cellAttributes() ?>>
<span id="el_PO_INVOICE_PO_DATE">
<input type="<?= $Page->PO_DATE->getInputTextType() ?>" data-table="PO_INVOICE" data-field="x_PO_DATE" name="x_PO_DATE" id="x_PO_DATE" placeholder="<?= HtmlEncode($Page->PO_DATE->getPlaceHolder()) ?>" value="<?= $Page->PO_DATE->EditValue ?>"<?= $Page->PO_DATE->editAttributes() ?> aria-describedby="x_PO_DATE_help">
<?= $Page->PO_DATE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->PO_DATE->getErrorMessage() ?></div>
<?php if (!$Page->PO_DATE->ReadOnly && !$Page->PO_DATE->Disabled && !isset($Page->PO_DATE->EditAttrs["readonly"]) && !isset($Page->PO_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fPO_INVOICEedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fPO_INVOICEedit", "x_PO_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->PO_VALUE->Visible) { // PO_VALUE ?>
    <div id="r_PO_VALUE" class="form-group row">
        <label id="elh_PO_INVOICE_PO_VALUE" for="x_PO_VALUE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->PO_VALUE->caption() ?><?= $Page->PO_VALUE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PO_VALUE->cellAttributes() ?>>
<span id="el_PO_INVOICE_PO_VALUE">
<input type="<?= $Page->PO_VALUE->getInputTextType() ?>" data-table="PO_INVOICE" data-field="x_PO_VALUE" name="x_PO_VALUE" id="x_PO_VALUE" size="30" placeholder="<?= HtmlEncode($Page->PO_VALUE->getPlaceHolder()) ?>" value="<?= $Page->PO_VALUE->EditValue ?>"<?= $Page->PO_VALUE->editAttributes() ?> aria-describedby="x_PO_VALUE_help">
<?= $Page->PO_VALUE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->PO_VALUE->getErrorMessage() ?></div>
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
    ew.addEventHandlers("PO_INVOICE");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
