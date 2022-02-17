<?php

namespace PHPMaker2021\SIMRSSQLSERVERGUDANGFARMASI;

// Page object
$PoInvoiceView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fPO_INVOICEview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fPO_INVOICEview = currentForm = new ew.Form("fPO_INVOICEview", "view");
    loadjs.done("fPO_INVOICEview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.PO_INVOICE) ew.vars.tables.PO_INVOICE = <?= JsonEncode(GetClientVar("tables", "PO_INVOICE")) ?>;
</script>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $Page->ExportOptions->render("body") ?>
<?php $Page->OtherOptions->render("body") ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fPO_INVOICEview" id="fPO_INVOICEview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="PO_INVOICE">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-bordered table-hover ew-view-table">
<?php if ($Page->ORG_UNIT_CODE->Visible) { // ORG_UNIT_CODE ?>
    <tr id="r_ORG_UNIT_CODE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_INVOICE_ORG_UNIT_CODE"><?= $Page->ORG_UNIT_CODE->caption() ?></span></td>
        <td data-name="ORG_UNIT_CODE" <?= $Page->ORG_UNIT_CODE->cellAttributes() ?>>
<span id="el_PO_INVOICE_ORG_UNIT_CODE">
<span<?= $Page->ORG_UNIT_CODE->viewAttributes() ?>>
<?= $Page->ORG_UNIT_CODE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->INVOICE_ID->Visible) { // INVOICE_ID ?>
    <tr id="r_INVOICE_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_INVOICE_INVOICE_ID"><?= $Page->INVOICE_ID->caption() ?></span></td>
        <td data-name="INVOICE_ID" <?= $Page->INVOICE_ID->cellAttributes() ?>>
<span id="el_PO_INVOICE_INVOICE_ID">
<span<?= $Page->INVOICE_ID->viewAttributes() ?>>
<?= $Page->INVOICE_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->INVOICE_ID2->Visible) { // INVOICE_ID2 ?>
    <tr id="r_INVOICE_ID2">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_INVOICE_INVOICE_ID2"><?= $Page->INVOICE_ID2->caption() ?></span></td>
        <td data-name="INVOICE_ID2" <?= $Page->INVOICE_ID2->cellAttributes() ?>>
<span id="el_PO_INVOICE_INVOICE_ID2">
<span<?= $Page->INVOICE_ID2->viewAttributes() ?>>
<?= $Page->INVOICE_ID2->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->INVOICE_DATE->Visible) { // INVOICE_DATE ?>
    <tr id="r_INVOICE_DATE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_INVOICE_INVOICE_DATE"><?= $Page->INVOICE_DATE->caption() ?></span></td>
        <td data-name="INVOICE_DATE" <?= $Page->INVOICE_DATE->cellAttributes() ?>>
<span id="el_PO_INVOICE_INVOICE_DATE">
<span<?= $Page->INVOICE_DATE->viewAttributes() ?>>
<?= $Page->INVOICE_DATE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->PO->Visible) { // PO ?>
    <tr id="r_PO">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_INVOICE_PO"><?= $Page->PO->caption() ?></span></td>
        <td data-name="PO" <?= $Page->PO->cellAttributes() ?>>
<span id="el_PO_INVOICE_PO">
<span<?= $Page->PO->viewAttributes() ?>>
<?= $Page->PO->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->COMPANY_ID->Visible) { // COMPANY_ID ?>
    <tr id="r_COMPANY_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_INVOICE_COMPANY_ID"><?= $Page->COMPANY_ID->caption() ?></span></td>
        <td data-name="COMPANY_ID" <?= $Page->COMPANY_ID->cellAttributes() ?>>
<span id="el_PO_INVOICE_COMPANY_ID">
<span<?= $Page->COMPANY_ID->viewAttributes() ?>>
<?= $Page->COMPANY_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->RECEIVED_DATE->Visible) { // RECEIVED_DATE ?>
    <tr id="r_RECEIVED_DATE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_INVOICE_RECEIVED_DATE"><?= $Page->RECEIVED_DATE->caption() ?></span></td>
        <td data-name="RECEIVED_DATE" <?= $Page->RECEIVED_DATE->cellAttributes() ?>>
<span id="el_PO_INVOICE_RECEIVED_DATE">
<span<?= $Page->RECEIVED_DATE->viewAttributes() ?>>
<?= $Page->RECEIVED_DATE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->AMOUNT->Visible) { // AMOUNT ?>
    <tr id="r_AMOUNT">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_INVOICE_AMOUNT"><?= $Page->AMOUNT->caption() ?></span></td>
        <td data-name="AMOUNT" <?= $Page->AMOUNT->cellAttributes() ?>>
<span id="el_PO_INVOICE_AMOUNT">
<span<?= $Page->AMOUNT->viewAttributes() ?>>
<?= $Page->AMOUNT->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->PAYMENT_DUE->Visible) { // PAYMENT_DUE ?>
    <tr id="r_PAYMENT_DUE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_INVOICE_PAYMENT_DUE"><?= $Page->PAYMENT_DUE->caption() ?></span></td>
        <td data-name="PAYMENT_DUE" <?= $Page->PAYMENT_DUE->cellAttributes() ?>>
<span id="el_PO_INVOICE_PAYMENT_DUE">
<span<?= $Page->PAYMENT_DUE->viewAttributes() ?>>
<?= $Page->PAYMENT_DUE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->DESCRIPTION->Visible) { // DESCRIPTION ?>
    <tr id="r_DESCRIPTION">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_INVOICE_DESCRIPTION"><?= $Page->DESCRIPTION->caption() ?></span></td>
        <td data-name="DESCRIPTION" <?= $Page->DESCRIPTION->cellAttributes() ?>>
<span id="el_PO_INVOICE_DESCRIPTION">
<span<?= $Page->DESCRIPTION->viewAttributes() ?>>
<?= $Page->DESCRIPTION->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
    <tr id="r_MODIFIED_DATE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_INVOICE_MODIFIED_DATE"><?= $Page->MODIFIED_DATE->caption() ?></span></td>
        <td data-name="MODIFIED_DATE" <?= $Page->MODIFIED_DATE->cellAttributes() ?>>
<span id="el_PO_INVOICE_MODIFIED_DATE">
<span<?= $Page->MODIFIED_DATE->viewAttributes() ?>>
<?= $Page->MODIFIED_DATE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
    <tr id="r_MODIFIED_BY">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_INVOICE_MODIFIED_BY"><?= $Page->MODIFIED_BY->caption() ?></span></td>
        <td data-name="MODIFIED_BY" <?= $Page->MODIFIED_BY->cellAttributes() ?>>
<span id="el_PO_INVOICE_MODIFIED_BY">
<span<?= $Page->MODIFIED_BY->viewAttributes() ?>>
<?= $Page->MODIFIED_BY->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->RECEIVED_BY->Visible) { // RECEIVED_BY ?>
    <tr id="r_RECEIVED_BY">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_INVOICE_RECEIVED_BY"><?= $Page->RECEIVED_BY->caption() ?></span></td>
        <td data-name="RECEIVED_BY" <?= $Page->RECEIVED_BY->cellAttributes() ?>>
<span id="el_PO_INVOICE_RECEIVED_BY">
<span<?= $Page->RECEIVED_BY->viewAttributes() ?>>
<?= $Page->RECEIVED_BY->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->PRIORITY->Visible) { // PRIORITY ?>
    <tr id="r_PRIORITY">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_INVOICE_PRIORITY"><?= $Page->PRIORITY->caption() ?></span></td>
        <td data-name="PRIORITY" <?= $Page->PRIORITY->cellAttributes() ?>>
<span id="el_PO_INVOICE_PRIORITY">
<span<?= $Page->PRIORITY->viewAttributes() ?>>
<?= $Page->PRIORITY->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->CREDIT_NOTE->Visible) { // CREDIT_NOTE ?>
    <tr id="r_CREDIT_NOTE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_INVOICE_CREDIT_NOTE"><?= $Page->CREDIT_NOTE->caption() ?></span></td>
        <td data-name="CREDIT_NOTE" <?= $Page->CREDIT_NOTE->cellAttributes() ?>>
<span id="el_PO_INVOICE_CREDIT_NOTE">
<span<?= $Page->CREDIT_NOTE->viewAttributes() ?>>
<?= $Page->CREDIT_NOTE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->CREDIT_AMOUNT->Visible) { // CREDIT_AMOUNT ?>
    <tr id="r_CREDIT_AMOUNT">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_INVOICE_CREDIT_AMOUNT"><?= $Page->CREDIT_AMOUNT->caption() ?></span></td>
        <td data-name="CREDIT_AMOUNT" <?= $Page->CREDIT_AMOUNT->cellAttributes() ?>>
<span id="el_PO_INVOICE_CREDIT_AMOUNT">
<span<?= $Page->CREDIT_AMOUNT->viewAttributes() ?>>
<?= $Page->CREDIT_AMOUNT->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->PPN->Visible) { // PPN ?>
    <tr id="r_PPN">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_INVOICE_PPN"><?= $Page->PPN->caption() ?></span></td>
        <td data-name="PPN" <?= $Page->PPN->cellAttributes() ?>>
<span id="el_PO_INVOICE_PPN">
<span<?= $Page->PPN->viewAttributes() ?>>
<?= $Page->PPN->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->MATERAI->Visible) { // MATERAI ?>
    <tr id="r_MATERAI">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_INVOICE_MATERAI"><?= $Page->MATERAI->caption() ?></span></td>
        <td data-name="MATERAI" <?= $Page->MATERAI->cellAttributes() ?>>
<span id="el_PO_INVOICE_MATERAI">
<span<?= $Page->MATERAI->viewAttributes() ?>>
<?= $Page->MATERAI->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->SENT_BY->Visible) { // SENT_BY ?>
    <tr id="r_SENT_BY">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_INVOICE_SENT_BY"><?= $Page->SENT_BY->caption() ?></span></td>
        <td data-name="SENT_BY" <?= $Page->SENT_BY->cellAttributes() ?>>
<span id="el_PO_INVOICE_SENT_BY">
<span<?= $Page->SENT_BY->viewAttributes() ?>>
<?= $Page->SENT_BY->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ACCOUNT_ID->Visible) { // ACCOUNT_ID ?>
    <tr id="r_ACCOUNT_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_INVOICE_ACCOUNT_ID"><?= $Page->ACCOUNT_ID->caption() ?></span></td>
        <td data-name="ACCOUNT_ID" <?= $Page->ACCOUNT_ID->cellAttributes() ?>>
<span id="el_PO_INVOICE_ACCOUNT_ID">
<span<?= $Page->ACCOUNT_ID->viewAttributes() ?>>
<?= $Page->ACCOUNT_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->FINANCE_ID->Visible) { // FINANCE_ID ?>
    <tr id="r_FINANCE_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_INVOICE_FINANCE_ID"><?= $Page->FINANCE_ID->caption() ?></span></td>
        <td data-name="FINANCE_ID" <?= $Page->FINANCE_ID->cellAttributes() ?>>
<span id="el_PO_INVOICE_FINANCE_ID">
<span<?= $Page->FINANCE_ID->viewAttributes() ?>>
<?= $Page->FINANCE_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->potongan->Visible) { // potongan ?>
    <tr id="r_potongan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_INVOICE_potongan"><?= $Page->potongan->caption() ?></span></td>
        <td data-name="potongan" <?= $Page->potongan->cellAttributes() ?>>
<span id="el_PO_INVOICE_potongan">
<span<?= $Page->potongan->viewAttributes() ?>>
<?= $Page->potongan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->RECEIVED_VALUE->Visible) { // RECEIVED_VALUE ?>
    <tr id="r_RECEIVED_VALUE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_INVOICE_RECEIVED_VALUE"><?= $Page->RECEIVED_VALUE->caption() ?></span></td>
        <td data-name="RECEIVED_VALUE" <?= $Page->RECEIVED_VALUE->cellAttributes() ?>>
<span id="el_PO_INVOICE_RECEIVED_VALUE">
<span<?= $Page->RECEIVED_VALUE->viewAttributes() ?>>
<?= $Page->RECEIVED_VALUE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->NO_ORDER->Visible) { // NO_ORDER ?>
    <tr id="r_NO_ORDER">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_INVOICE_NO_ORDER"><?= $Page->NO_ORDER->caption() ?></span></td>
        <td data-name="NO_ORDER" <?= $Page->NO_ORDER->cellAttributes() ?>>
<span id="el_PO_INVOICE_NO_ORDER">
<span<?= $Page->NO_ORDER->viewAttributes() ?>>
<?= $Page->NO_ORDER->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->CONTRACT_NO->Visible) { // CONTRACT_NO ?>
    <tr id="r_CONTRACT_NO">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_INVOICE_CONTRACT_NO"><?= $Page->CONTRACT_NO->caption() ?></span></td>
        <td data-name="CONTRACT_NO" <?= $Page->CONTRACT_NO->cellAttributes() ?>>
<span id="el_PO_INVOICE_CONTRACT_NO">
<span<?= $Page->CONTRACT_NO->viewAttributes() ?>>
<?= $Page->CONTRACT_NO->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ORG_ID->Visible) { // ORG_ID ?>
    <tr id="r_ORG_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_INVOICE_ORG_ID"><?= $Page->ORG_ID->caption() ?></span></td>
        <td data-name="ORG_ID" <?= $Page->ORG_ID->cellAttributes() ?>>
<span id="el_PO_INVOICE_ORG_ID">
<span<?= $Page->ORG_ID->viewAttributes() ?>>
<?= $Page->ORG_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->CLINIC_ID->Visible) { // CLINIC_ID ?>
    <tr id="r_CLINIC_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_INVOICE_CLINIC_ID"><?= $Page->CLINIC_ID->caption() ?></span></td>
        <td data-name="CLINIC_ID" <?= $Page->CLINIC_ID->cellAttributes() ?>>
<span id="el_PO_INVOICE_CLINIC_ID">
<span<?= $Page->CLINIC_ID->viewAttributes() ?>>
<?= $Page->CLINIC_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->PPN_VALUE->Visible) { // PPN_VALUE ?>
    <tr id="r_PPN_VALUE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_INVOICE_PPN_VALUE"><?= $Page->PPN_VALUE->caption() ?></span></td>
        <td data-name="PPN_VALUE" <?= $Page->PPN_VALUE->cellAttributes() ?>>
<span id="el_PO_INVOICE_PPN_VALUE">
<span<?= $Page->PPN_VALUE->viewAttributes() ?>>
<?= $Page->PPN_VALUE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->DISCOUNT_VALUE->Visible) { // DISCOUNT_VALUE ?>
    <tr id="r_DISCOUNT_VALUE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_INVOICE_DISCOUNT_VALUE"><?= $Page->DISCOUNT_VALUE->caption() ?></span></td>
        <td data-name="DISCOUNT_VALUE" <?= $Page->DISCOUNT_VALUE->cellAttributes() ?>>
<span id="el_PO_INVOICE_DISCOUNT_VALUE">
<span<?= $Page->DISCOUNT_VALUE->viewAttributes() ?>>
<?= $Page->DISCOUNT_VALUE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->PAID_VALUE->Visible) { // PAID_VALUE ?>
    <tr id="r_PAID_VALUE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_INVOICE_PAID_VALUE"><?= $Page->PAID_VALUE->caption() ?></span></td>
        <td data-name="PAID_VALUE" <?= $Page->PAID_VALUE->cellAttributes() ?>>
<span id="el_PO_INVOICE_PAID_VALUE">
<span<?= $Page->PAID_VALUE->viewAttributes() ?>>
<?= $Page->PAID_VALUE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ISCETAK->Visible) { // ISCETAK ?>
    <tr id="r_ISCETAK">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_INVOICE_ISCETAK"><?= $Page->ISCETAK->caption() ?></span></td>
        <td data-name="ISCETAK" <?= $Page->ISCETAK->cellAttributes() ?>>
<span id="el_PO_INVOICE_ISCETAK">
<span<?= $Page->ISCETAK->viewAttributes() ?>>
<?= $Page->ISCETAK->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->PRINT_DATE->Visible) { // PRINT_DATE ?>
    <tr id="r_PRINT_DATE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_INVOICE_PRINT_DATE"><?= $Page->PRINT_DATE->caption() ?></span></td>
        <td data-name="PRINT_DATE" <?= $Page->PRINT_DATE->cellAttributes() ?>>
<span id="el_PO_INVOICE_PRINT_DATE">
<span<?= $Page->PRINT_DATE->viewAttributes() ?>>
<?= $Page->PRINT_DATE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->PRINTED_BY->Visible) { // PRINTED_BY ?>
    <tr id="r_PRINTED_BY">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_INVOICE_PRINTED_BY"><?= $Page->PRINTED_BY->caption() ?></span></td>
        <td data-name="PRINTED_BY" <?= $Page->PRINTED_BY->cellAttributes() ?>>
<span id="el_PO_INVOICE_PRINTED_BY">
<span<?= $Page->PRINTED_BY->viewAttributes() ?>>
<?= $Page->PRINTED_BY->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->PRINTQ->Visible) { // PRINTQ ?>
    <tr id="r_PRINTQ">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_INVOICE_PRINTQ"><?= $Page->PRINTQ->caption() ?></span></td>
        <td data-name="PRINTQ" <?= $Page->PRINTQ->cellAttributes() ?>>
<span id="el_PO_INVOICE_PRINTQ">
<span<?= $Page->PRINTQ->viewAttributes() ?>>
<?= $Page->PRINTQ->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->FAKTUR_DATE->Visible) { // FAKTUR_DATE ?>
    <tr id="r_FAKTUR_DATE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_INVOICE_FAKTUR_DATE"><?= $Page->FAKTUR_DATE->caption() ?></span></td>
        <td data-name="FAKTUR_DATE" <?= $Page->FAKTUR_DATE->cellAttributes() ?>>
<span id="el_PO_INVOICE_FAKTUR_DATE">
<span<?= $Page->FAKTUR_DATE->viewAttributes() ?>>
<?= $Page->FAKTUR_DATE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->DISTRIBUTION_TYPE->Visible) { // DISTRIBUTION_TYPE ?>
    <tr id="r_DISTRIBUTION_TYPE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_INVOICE_DISTRIBUTION_TYPE"><?= $Page->DISTRIBUTION_TYPE->caption() ?></span></td>
        <td data-name="DISTRIBUTION_TYPE" <?= $Page->DISTRIBUTION_TYPE->cellAttributes() ?>>
<span id="el_PO_INVOICE_DISTRIBUTION_TYPE">
<span<?= $Page->DISTRIBUTION_TYPE->viewAttributes() ?>>
<?= $Page->DISTRIBUTION_TYPE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->DISCOUNTOFF_VALUE->Visible) { // DISCOUNTOFF_VALUE ?>
    <tr id="r_DISCOUNTOFF_VALUE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_INVOICE_DISCOUNTOFF_VALUE"><?= $Page->DISCOUNTOFF_VALUE->caption() ?></span></td>
        <td data-name="DISCOUNTOFF_VALUE" <?= $Page->DISCOUNTOFF_VALUE->cellAttributes() ?>>
<span id="el_PO_INVOICE_DISCOUNTOFF_VALUE">
<span<?= $Page->DISCOUNTOFF_VALUE->viewAttributes() ?>>
<?= $Page->DISCOUNTOFF_VALUE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->THECOUNTER->Visible) { // THECOUNTER ?>
    <tr id="r_THECOUNTER">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_INVOICE_THECOUNTER"><?= $Page->THECOUNTER->caption() ?></span></td>
        <td data-name="THECOUNTER" <?= $Page->THECOUNTER->cellAttributes() ?>>
<span id="el_PO_INVOICE_THECOUNTER">
<span<?= $Page->THECOUNTER->viewAttributes() ?>>
<?= $Page->THECOUNTER->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->FUND_ID->Visible) { // FUND_ID ?>
    <tr id="r_FUND_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_INVOICE_FUND_ID"><?= $Page->FUND_ID->caption() ?></span></td>
        <td data-name="FUND_ID" <?= $Page->FUND_ID->cellAttributes() ?>>
<span id="el_PO_INVOICE_FUND_ID">
<span<?= $Page->FUND_ID->viewAttributes() ?>>
<?= $Page->FUND_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ORDER_BY->Visible) { // ORDER_BY ?>
    <tr id="r_ORDER_BY">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_INVOICE_ORDER_BY"><?= $Page->ORDER_BY->caption() ?></span></td>
        <td data-name="ORDER_BY" <?= $Page->ORDER_BY->cellAttributes() ?>>
<span id="el_PO_INVOICE_ORDER_BY">
<span<?= $Page->ORDER_BY->viewAttributes() ?>>
<?= $Page->ORDER_BY->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ACKNOWLEDGEBY->Visible) { // ACKNOWLEDGEBY ?>
    <tr id="r_ACKNOWLEDGEBY">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_INVOICE_ACKNOWLEDGEBY"><?= $Page->ACKNOWLEDGEBY->caption() ?></span></td>
        <td data-name="ACKNOWLEDGEBY" <?= $Page->ACKNOWLEDGEBY->cellAttributes() ?>>
<span id="el_PO_INVOICE_ACKNOWLEDGEBY">
<span<?= $Page->ACKNOWLEDGEBY->viewAttributes() ?>>
<?= $Page->ACKNOWLEDGEBY->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->NUM->Visible) { // NUM ?>
    <tr id="r_NUM">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_INVOICE_NUM"><?= $Page->NUM->caption() ?></span></td>
        <td data-name="NUM" <?= $Page->NUM->cellAttributes() ?>>
<span id="el_PO_INVOICE_NUM">
<span<?= $Page->NUM->viewAttributes() ?>>
<?= $Page->NUM->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ISPO->Visible) { // ISPO ?>
    <tr id="r_ISPO">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_INVOICE_ISPO"><?= $Page->ISPO->caption() ?></span></td>
        <td data-name="ISPO" <?= $Page->ISPO->cellAttributes() ?>>
<span id="el_PO_INVOICE_ISPO">
<span<?= $Page->ISPO->viewAttributes() ?>>
<?= $Page->ISPO->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->DOCS_TYPE->Visible) { // DOCS_TYPE ?>
    <tr id="r_DOCS_TYPE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_INVOICE_DOCS_TYPE"><?= $Page->DOCS_TYPE->caption() ?></span></td>
        <td data-name="DOCS_TYPE" <?= $Page->DOCS_TYPE->cellAttributes() ?>>
<span id="el_PO_INVOICE_DOCS_TYPE">
<span<?= $Page->DOCS_TYPE->viewAttributes() ?>>
<?= $Page->DOCS_TYPE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->PO_DATE->Visible) { // PO_DATE ?>
    <tr id="r_PO_DATE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_INVOICE_PO_DATE"><?= $Page->PO_DATE->caption() ?></span></td>
        <td data-name="PO_DATE" <?= $Page->PO_DATE->cellAttributes() ?>>
<span id="el_PO_INVOICE_PO_DATE">
<span<?= $Page->PO_DATE->viewAttributes() ?>>
<?= $Page->PO_DATE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->PO_VALUE->Visible) { // PO_VALUE ?>
    <tr id="r_PO_VALUE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_INVOICE_PO_VALUE"><?= $Page->PO_VALUE->caption() ?></span></td>
        <td data-name="PO_VALUE" <?= $Page->PO_VALUE->cellAttributes() ?>>
<span id="el_PO_INVOICE_PO_VALUE">
<span<?= $Page->PO_VALUE->viewAttributes() ?>>
<?= $Page->PO_VALUE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
