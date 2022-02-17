<?php

namespace PHPMaker2021\SIMRSSQLSERVERGUDANGFARMASI;

// Page object
$PoInvoiceDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fPO_INVOICEdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fPO_INVOICEdelete = currentForm = new ew.Form("fPO_INVOICEdelete", "delete");
    loadjs.done("fPO_INVOICEdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.PO_INVOICE) ew.vars.tables.PO_INVOICE = <?= JsonEncode(GetClientVar("tables", "PO_INVOICE")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fPO_INVOICEdelete" id="fPO_INVOICEdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="PO_INVOICE">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($Page->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?= HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table class="table ew-table">
    <thead>
    <tr class="ew-table-header">
<?php if ($Page->ORG_UNIT_CODE->Visible) { // ORG_UNIT_CODE ?>
        <th class="<?= $Page->ORG_UNIT_CODE->headerCellClass() ?>"><span id="elh_PO_INVOICE_ORG_UNIT_CODE" class="PO_INVOICE_ORG_UNIT_CODE"><?= $Page->ORG_UNIT_CODE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->INVOICE_ID->Visible) { // INVOICE_ID ?>
        <th class="<?= $Page->INVOICE_ID->headerCellClass() ?>"><span id="elh_PO_INVOICE_INVOICE_ID" class="PO_INVOICE_INVOICE_ID"><?= $Page->INVOICE_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->INVOICE_ID2->Visible) { // INVOICE_ID2 ?>
        <th class="<?= $Page->INVOICE_ID2->headerCellClass() ?>"><span id="elh_PO_INVOICE_INVOICE_ID2" class="PO_INVOICE_INVOICE_ID2"><?= $Page->INVOICE_ID2->caption() ?></span></th>
<?php } ?>
<?php if ($Page->INVOICE_DATE->Visible) { // INVOICE_DATE ?>
        <th class="<?= $Page->INVOICE_DATE->headerCellClass() ?>"><span id="elh_PO_INVOICE_INVOICE_DATE" class="PO_INVOICE_INVOICE_DATE"><?= $Page->INVOICE_DATE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->PO->Visible) { // PO ?>
        <th class="<?= $Page->PO->headerCellClass() ?>"><span id="elh_PO_INVOICE_PO" class="PO_INVOICE_PO"><?= $Page->PO->caption() ?></span></th>
<?php } ?>
<?php if ($Page->COMPANY_ID->Visible) { // COMPANY_ID ?>
        <th class="<?= $Page->COMPANY_ID->headerCellClass() ?>"><span id="elh_PO_INVOICE_COMPANY_ID" class="PO_INVOICE_COMPANY_ID"><?= $Page->COMPANY_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->RECEIVED_DATE->Visible) { // RECEIVED_DATE ?>
        <th class="<?= $Page->RECEIVED_DATE->headerCellClass() ?>"><span id="elh_PO_INVOICE_RECEIVED_DATE" class="PO_INVOICE_RECEIVED_DATE"><?= $Page->RECEIVED_DATE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->AMOUNT->Visible) { // AMOUNT ?>
        <th class="<?= $Page->AMOUNT->headerCellClass() ?>"><span id="elh_PO_INVOICE_AMOUNT" class="PO_INVOICE_AMOUNT"><?= $Page->AMOUNT->caption() ?></span></th>
<?php } ?>
<?php if ($Page->PAYMENT_DUE->Visible) { // PAYMENT_DUE ?>
        <th class="<?= $Page->PAYMENT_DUE->headerCellClass() ?>"><span id="elh_PO_INVOICE_PAYMENT_DUE" class="PO_INVOICE_PAYMENT_DUE"><?= $Page->PAYMENT_DUE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->DESCRIPTION->Visible) { // DESCRIPTION ?>
        <th class="<?= $Page->DESCRIPTION->headerCellClass() ?>"><span id="elh_PO_INVOICE_DESCRIPTION" class="PO_INVOICE_DESCRIPTION"><?= $Page->DESCRIPTION->caption() ?></span></th>
<?php } ?>
<?php if ($Page->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
        <th class="<?= $Page->MODIFIED_DATE->headerCellClass() ?>"><span id="elh_PO_INVOICE_MODIFIED_DATE" class="PO_INVOICE_MODIFIED_DATE"><?= $Page->MODIFIED_DATE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
        <th class="<?= $Page->MODIFIED_BY->headerCellClass() ?>"><span id="elh_PO_INVOICE_MODIFIED_BY" class="PO_INVOICE_MODIFIED_BY"><?= $Page->MODIFIED_BY->caption() ?></span></th>
<?php } ?>
<?php if ($Page->RECEIVED_BY->Visible) { // RECEIVED_BY ?>
        <th class="<?= $Page->RECEIVED_BY->headerCellClass() ?>"><span id="elh_PO_INVOICE_RECEIVED_BY" class="PO_INVOICE_RECEIVED_BY"><?= $Page->RECEIVED_BY->caption() ?></span></th>
<?php } ?>
<?php if ($Page->PRIORITY->Visible) { // PRIORITY ?>
        <th class="<?= $Page->PRIORITY->headerCellClass() ?>"><span id="elh_PO_INVOICE_PRIORITY" class="PO_INVOICE_PRIORITY"><?= $Page->PRIORITY->caption() ?></span></th>
<?php } ?>
<?php if ($Page->CREDIT_NOTE->Visible) { // CREDIT_NOTE ?>
        <th class="<?= $Page->CREDIT_NOTE->headerCellClass() ?>"><span id="elh_PO_INVOICE_CREDIT_NOTE" class="PO_INVOICE_CREDIT_NOTE"><?= $Page->CREDIT_NOTE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->CREDIT_AMOUNT->Visible) { // CREDIT_AMOUNT ?>
        <th class="<?= $Page->CREDIT_AMOUNT->headerCellClass() ?>"><span id="elh_PO_INVOICE_CREDIT_AMOUNT" class="PO_INVOICE_CREDIT_AMOUNT"><?= $Page->CREDIT_AMOUNT->caption() ?></span></th>
<?php } ?>
<?php if ($Page->PPN->Visible) { // PPN ?>
        <th class="<?= $Page->PPN->headerCellClass() ?>"><span id="elh_PO_INVOICE_PPN" class="PO_INVOICE_PPN"><?= $Page->PPN->caption() ?></span></th>
<?php } ?>
<?php if ($Page->MATERAI->Visible) { // MATERAI ?>
        <th class="<?= $Page->MATERAI->headerCellClass() ?>"><span id="elh_PO_INVOICE_MATERAI" class="PO_INVOICE_MATERAI"><?= $Page->MATERAI->caption() ?></span></th>
<?php } ?>
<?php if ($Page->SENT_BY->Visible) { // SENT_BY ?>
        <th class="<?= $Page->SENT_BY->headerCellClass() ?>"><span id="elh_PO_INVOICE_SENT_BY" class="PO_INVOICE_SENT_BY"><?= $Page->SENT_BY->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ACCOUNT_ID->Visible) { // ACCOUNT_ID ?>
        <th class="<?= $Page->ACCOUNT_ID->headerCellClass() ?>"><span id="elh_PO_INVOICE_ACCOUNT_ID" class="PO_INVOICE_ACCOUNT_ID"><?= $Page->ACCOUNT_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->FINANCE_ID->Visible) { // FINANCE_ID ?>
        <th class="<?= $Page->FINANCE_ID->headerCellClass() ?>"><span id="elh_PO_INVOICE_FINANCE_ID" class="PO_INVOICE_FINANCE_ID"><?= $Page->FINANCE_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->potongan->Visible) { // potongan ?>
        <th class="<?= $Page->potongan->headerCellClass() ?>"><span id="elh_PO_INVOICE_potongan" class="PO_INVOICE_potongan"><?= $Page->potongan->caption() ?></span></th>
<?php } ?>
<?php if ($Page->RECEIVED_VALUE->Visible) { // RECEIVED_VALUE ?>
        <th class="<?= $Page->RECEIVED_VALUE->headerCellClass() ?>"><span id="elh_PO_INVOICE_RECEIVED_VALUE" class="PO_INVOICE_RECEIVED_VALUE"><?= $Page->RECEIVED_VALUE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->NO_ORDER->Visible) { // NO_ORDER ?>
        <th class="<?= $Page->NO_ORDER->headerCellClass() ?>"><span id="elh_PO_INVOICE_NO_ORDER" class="PO_INVOICE_NO_ORDER"><?= $Page->NO_ORDER->caption() ?></span></th>
<?php } ?>
<?php if ($Page->CONTRACT_NO->Visible) { // CONTRACT_NO ?>
        <th class="<?= $Page->CONTRACT_NO->headerCellClass() ?>"><span id="elh_PO_INVOICE_CONTRACT_NO" class="PO_INVOICE_CONTRACT_NO"><?= $Page->CONTRACT_NO->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ORG_ID->Visible) { // ORG_ID ?>
        <th class="<?= $Page->ORG_ID->headerCellClass() ?>"><span id="elh_PO_INVOICE_ORG_ID" class="PO_INVOICE_ORG_ID"><?= $Page->ORG_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->CLINIC_ID->Visible) { // CLINIC_ID ?>
        <th class="<?= $Page->CLINIC_ID->headerCellClass() ?>"><span id="elh_PO_INVOICE_CLINIC_ID" class="PO_INVOICE_CLINIC_ID"><?= $Page->CLINIC_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->PPN_VALUE->Visible) { // PPN_VALUE ?>
        <th class="<?= $Page->PPN_VALUE->headerCellClass() ?>"><span id="elh_PO_INVOICE_PPN_VALUE" class="PO_INVOICE_PPN_VALUE"><?= $Page->PPN_VALUE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->DISCOUNT_VALUE->Visible) { // DISCOUNT_VALUE ?>
        <th class="<?= $Page->DISCOUNT_VALUE->headerCellClass() ?>"><span id="elh_PO_INVOICE_DISCOUNT_VALUE" class="PO_INVOICE_DISCOUNT_VALUE"><?= $Page->DISCOUNT_VALUE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->PAID_VALUE->Visible) { // PAID_VALUE ?>
        <th class="<?= $Page->PAID_VALUE->headerCellClass() ?>"><span id="elh_PO_INVOICE_PAID_VALUE" class="PO_INVOICE_PAID_VALUE"><?= $Page->PAID_VALUE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ISCETAK->Visible) { // ISCETAK ?>
        <th class="<?= $Page->ISCETAK->headerCellClass() ?>"><span id="elh_PO_INVOICE_ISCETAK" class="PO_INVOICE_ISCETAK"><?= $Page->ISCETAK->caption() ?></span></th>
<?php } ?>
<?php if ($Page->PRINT_DATE->Visible) { // PRINT_DATE ?>
        <th class="<?= $Page->PRINT_DATE->headerCellClass() ?>"><span id="elh_PO_INVOICE_PRINT_DATE" class="PO_INVOICE_PRINT_DATE"><?= $Page->PRINT_DATE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->PRINTED_BY->Visible) { // PRINTED_BY ?>
        <th class="<?= $Page->PRINTED_BY->headerCellClass() ?>"><span id="elh_PO_INVOICE_PRINTED_BY" class="PO_INVOICE_PRINTED_BY"><?= $Page->PRINTED_BY->caption() ?></span></th>
<?php } ?>
<?php if ($Page->PRINTQ->Visible) { // PRINTQ ?>
        <th class="<?= $Page->PRINTQ->headerCellClass() ?>"><span id="elh_PO_INVOICE_PRINTQ" class="PO_INVOICE_PRINTQ"><?= $Page->PRINTQ->caption() ?></span></th>
<?php } ?>
<?php if ($Page->FAKTUR_DATE->Visible) { // FAKTUR_DATE ?>
        <th class="<?= $Page->FAKTUR_DATE->headerCellClass() ?>"><span id="elh_PO_INVOICE_FAKTUR_DATE" class="PO_INVOICE_FAKTUR_DATE"><?= $Page->FAKTUR_DATE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->DISTRIBUTION_TYPE->Visible) { // DISTRIBUTION_TYPE ?>
        <th class="<?= $Page->DISTRIBUTION_TYPE->headerCellClass() ?>"><span id="elh_PO_INVOICE_DISTRIBUTION_TYPE" class="PO_INVOICE_DISTRIBUTION_TYPE"><?= $Page->DISTRIBUTION_TYPE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->DISCOUNTOFF_VALUE->Visible) { // DISCOUNTOFF_VALUE ?>
        <th class="<?= $Page->DISCOUNTOFF_VALUE->headerCellClass() ?>"><span id="elh_PO_INVOICE_DISCOUNTOFF_VALUE" class="PO_INVOICE_DISCOUNTOFF_VALUE"><?= $Page->DISCOUNTOFF_VALUE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->THECOUNTER->Visible) { // THECOUNTER ?>
        <th class="<?= $Page->THECOUNTER->headerCellClass() ?>"><span id="elh_PO_INVOICE_THECOUNTER" class="PO_INVOICE_THECOUNTER"><?= $Page->THECOUNTER->caption() ?></span></th>
<?php } ?>
<?php if ($Page->FUND_ID->Visible) { // FUND_ID ?>
        <th class="<?= $Page->FUND_ID->headerCellClass() ?>"><span id="elh_PO_INVOICE_FUND_ID" class="PO_INVOICE_FUND_ID"><?= $Page->FUND_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ORDER_BY->Visible) { // ORDER_BY ?>
        <th class="<?= $Page->ORDER_BY->headerCellClass() ?>"><span id="elh_PO_INVOICE_ORDER_BY" class="PO_INVOICE_ORDER_BY"><?= $Page->ORDER_BY->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ACKNOWLEDGEBY->Visible) { // ACKNOWLEDGEBY ?>
        <th class="<?= $Page->ACKNOWLEDGEBY->headerCellClass() ?>"><span id="elh_PO_INVOICE_ACKNOWLEDGEBY" class="PO_INVOICE_ACKNOWLEDGEBY"><?= $Page->ACKNOWLEDGEBY->caption() ?></span></th>
<?php } ?>
<?php if ($Page->NUM->Visible) { // NUM ?>
        <th class="<?= $Page->NUM->headerCellClass() ?>"><span id="elh_PO_INVOICE_NUM" class="PO_INVOICE_NUM"><?= $Page->NUM->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ISPO->Visible) { // ISPO ?>
        <th class="<?= $Page->ISPO->headerCellClass() ?>"><span id="elh_PO_INVOICE_ISPO" class="PO_INVOICE_ISPO"><?= $Page->ISPO->caption() ?></span></th>
<?php } ?>
<?php if ($Page->DOCS_TYPE->Visible) { // DOCS_TYPE ?>
        <th class="<?= $Page->DOCS_TYPE->headerCellClass() ?>"><span id="elh_PO_INVOICE_DOCS_TYPE" class="PO_INVOICE_DOCS_TYPE"><?= $Page->DOCS_TYPE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->PO_DATE->Visible) { // PO_DATE ?>
        <th class="<?= $Page->PO_DATE->headerCellClass() ?>"><span id="elh_PO_INVOICE_PO_DATE" class="PO_INVOICE_PO_DATE"><?= $Page->PO_DATE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->PO_VALUE->Visible) { // PO_VALUE ?>
        <th class="<?= $Page->PO_VALUE->headerCellClass() ?>"><span id="elh_PO_INVOICE_PO_VALUE" class="PO_INVOICE_PO_VALUE"><?= $Page->PO_VALUE->caption() ?></span></th>
<?php } ?>
    </tr>
    </thead>
    <tbody>
<?php
$Page->RecordCount = 0;
$i = 0;
while (!$Page->Recordset->EOF) {
    $Page->RecordCount++;
    $Page->RowCount++;

    // Set row properties
    $Page->resetAttributes();
    $Page->RowType = ROWTYPE_VIEW; // View

    // Get the field contents
    $Page->loadRowValues($Page->Recordset);

    // Render row
    $Page->renderRow();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php if ($Page->ORG_UNIT_CODE->Visible) { // ORG_UNIT_CODE ?>
        <td <?= $Page->ORG_UNIT_CODE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICE_ORG_UNIT_CODE" class="PO_INVOICE_ORG_UNIT_CODE">
<span<?= $Page->ORG_UNIT_CODE->viewAttributes() ?>>
<?= $Page->ORG_UNIT_CODE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->INVOICE_ID->Visible) { // INVOICE_ID ?>
        <td <?= $Page->INVOICE_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICE_INVOICE_ID" class="PO_INVOICE_INVOICE_ID">
<span<?= $Page->INVOICE_ID->viewAttributes() ?>>
<?= $Page->INVOICE_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->INVOICE_ID2->Visible) { // INVOICE_ID2 ?>
        <td <?= $Page->INVOICE_ID2->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICE_INVOICE_ID2" class="PO_INVOICE_INVOICE_ID2">
<span<?= $Page->INVOICE_ID2->viewAttributes() ?>>
<?= $Page->INVOICE_ID2->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->INVOICE_DATE->Visible) { // INVOICE_DATE ?>
        <td <?= $Page->INVOICE_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICE_INVOICE_DATE" class="PO_INVOICE_INVOICE_DATE">
<span<?= $Page->INVOICE_DATE->viewAttributes() ?>>
<?= $Page->INVOICE_DATE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->PO->Visible) { // PO ?>
        <td <?= $Page->PO->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICE_PO" class="PO_INVOICE_PO">
<span<?= $Page->PO->viewAttributes() ?>>
<?= $Page->PO->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->COMPANY_ID->Visible) { // COMPANY_ID ?>
        <td <?= $Page->COMPANY_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICE_COMPANY_ID" class="PO_INVOICE_COMPANY_ID">
<span<?= $Page->COMPANY_ID->viewAttributes() ?>>
<?= $Page->COMPANY_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->RECEIVED_DATE->Visible) { // RECEIVED_DATE ?>
        <td <?= $Page->RECEIVED_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICE_RECEIVED_DATE" class="PO_INVOICE_RECEIVED_DATE">
<span<?= $Page->RECEIVED_DATE->viewAttributes() ?>>
<?= $Page->RECEIVED_DATE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->AMOUNT->Visible) { // AMOUNT ?>
        <td <?= $Page->AMOUNT->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICE_AMOUNT" class="PO_INVOICE_AMOUNT">
<span<?= $Page->AMOUNT->viewAttributes() ?>>
<?= $Page->AMOUNT->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->PAYMENT_DUE->Visible) { // PAYMENT_DUE ?>
        <td <?= $Page->PAYMENT_DUE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICE_PAYMENT_DUE" class="PO_INVOICE_PAYMENT_DUE">
<span<?= $Page->PAYMENT_DUE->viewAttributes() ?>>
<?= $Page->PAYMENT_DUE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->DESCRIPTION->Visible) { // DESCRIPTION ?>
        <td <?= $Page->DESCRIPTION->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICE_DESCRIPTION" class="PO_INVOICE_DESCRIPTION">
<span<?= $Page->DESCRIPTION->viewAttributes() ?>>
<?= $Page->DESCRIPTION->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
        <td <?= $Page->MODIFIED_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICE_MODIFIED_DATE" class="PO_INVOICE_MODIFIED_DATE">
<span<?= $Page->MODIFIED_DATE->viewAttributes() ?>>
<?= $Page->MODIFIED_DATE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
        <td <?= $Page->MODIFIED_BY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICE_MODIFIED_BY" class="PO_INVOICE_MODIFIED_BY">
<span<?= $Page->MODIFIED_BY->viewAttributes() ?>>
<?= $Page->MODIFIED_BY->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->RECEIVED_BY->Visible) { // RECEIVED_BY ?>
        <td <?= $Page->RECEIVED_BY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICE_RECEIVED_BY" class="PO_INVOICE_RECEIVED_BY">
<span<?= $Page->RECEIVED_BY->viewAttributes() ?>>
<?= $Page->RECEIVED_BY->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->PRIORITY->Visible) { // PRIORITY ?>
        <td <?= $Page->PRIORITY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICE_PRIORITY" class="PO_INVOICE_PRIORITY">
<span<?= $Page->PRIORITY->viewAttributes() ?>>
<?= $Page->PRIORITY->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->CREDIT_NOTE->Visible) { // CREDIT_NOTE ?>
        <td <?= $Page->CREDIT_NOTE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICE_CREDIT_NOTE" class="PO_INVOICE_CREDIT_NOTE">
<span<?= $Page->CREDIT_NOTE->viewAttributes() ?>>
<?= $Page->CREDIT_NOTE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->CREDIT_AMOUNT->Visible) { // CREDIT_AMOUNT ?>
        <td <?= $Page->CREDIT_AMOUNT->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICE_CREDIT_AMOUNT" class="PO_INVOICE_CREDIT_AMOUNT">
<span<?= $Page->CREDIT_AMOUNT->viewAttributes() ?>>
<?= $Page->CREDIT_AMOUNT->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->PPN->Visible) { // PPN ?>
        <td <?= $Page->PPN->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICE_PPN" class="PO_INVOICE_PPN">
<span<?= $Page->PPN->viewAttributes() ?>>
<?= $Page->PPN->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->MATERAI->Visible) { // MATERAI ?>
        <td <?= $Page->MATERAI->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICE_MATERAI" class="PO_INVOICE_MATERAI">
<span<?= $Page->MATERAI->viewAttributes() ?>>
<?= $Page->MATERAI->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->SENT_BY->Visible) { // SENT_BY ?>
        <td <?= $Page->SENT_BY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICE_SENT_BY" class="PO_INVOICE_SENT_BY">
<span<?= $Page->SENT_BY->viewAttributes() ?>>
<?= $Page->SENT_BY->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ACCOUNT_ID->Visible) { // ACCOUNT_ID ?>
        <td <?= $Page->ACCOUNT_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICE_ACCOUNT_ID" class="PO_INVOICE_ACCOUNT_ID">
<span<?= $Page->ACCOUNT_ID->viewAttributes() ?>>
<?= $Page->ACCOUNT_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->FINANCE_ID->Visible) { // FINANCE_ID ?>
        <td <?= $Page->FINANCE_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICE_FINANCE_ID" class="PO_INVOICE_FINANCE_ID">
<span<?= $Page->FINANCE_ID->viewAttributes() ?>>
<?= $Page->FINANCE_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->potongan->Visible) { // potongan ?>
        <td <?= $Page->potongan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICE_potongan" class="PO_INVOICE_potongan">
<span<?= $Page->potongan->viewAttributes() ?>>
<?= $Page->potongan->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->RECEIVED_VALUE->Visible) { // RECEIVED_VALUE ?>
        <td <?= $Page->RECEIVED_VALUE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICE_RECEIVED_VALUE" class="PO_INVOICE_RECEIVED_VALUE">
<span<?= $Page->RECEIVED_VALUE->viewAttributes() ?>>
<?= $Page->RECEIVED_VALUE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->NO_ORDER->Visible) { // NO_ORDER ?>
        <td <?= $Page->NO_ORDER->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICE_NO_ORDER" class="PO_INVOICE_NO_ORDER">
<span<?= $Page->NO_ORDER->viewAttributes() ?>>
<?= $Page->NO_ORDER->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->CONTRACT_NO->Visible) { // CONTRACT_NO ?>
        <td <?= $Page->CONTRACT_NO->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICE_CONTRACT_NO" class="PO_INVOICE_CONTRACT_NO">
<span<?= $Page->CONTRACT_NO->viewAttributes() ?>>
<?= $Page->CONTRACT_NO->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ORG_ID->Visible) { // ORG_ID ?>
        <td <?= $Page->ORG_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICE_ORG_ID" class="PO_INVOICE_ORG_ID">
<span<?= $Page->ORG_ID->viewAttributes() ?>>
<?= $Page->ORG_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->CLINIC_ID->Visible) { // CLINIC_ID ?>
        <td <?= $Page->CLINIC_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICE_CLINIC_ID" class="PO_INVOICE_CLINIC_ID">
<span<?= $Page->CLINIC_ID->viewAttributes() ?>>
<?= $Page->CLINIC_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->PPN_VALUE->Visible) { // PPN_VALUE ?>
        <td <?= $Page->PPN_VALUE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICE_PPN_VALUE" class="PO_INVOICE_PPN_VALUE">
<span<?= $Page->PPN_VALUE->viewAttributes() ?>>
<?= $Page->PPN_VALUE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->DISCOUNT_VALUE->Visible) { // DISCOUNT_VALUE ?>
        <td <?= $Page->DISCOUNT_VALUE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICE_DISCOUNT_VALUE" class="PO_INVOICE_DISCOUNT_VALUE">
<span<?= $Page->DISCOUNT_VALUE->viewAttributes() ?>>
<?= $Page->DISCOUNT_VALUE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->PAID_VALUE->Visible) { // PAID_VALUE ?>
        <td <?= $Page->PAID_VALUE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICE_PAID_VALUE" class="PO_INVOICE_PAID_VALUE">
<span<?= $Page->PAID_VALUE->viewAttributes() ?>>
<?= $Page->PAID_VALUE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ISCETAK->Visible) { // ISCETAK ?>
        <td <?= $Page->ISCETAK->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICE_ISCETAK" class="PO_INVOICE_ISCETAK">
<span<?= $Page->ISCETAK->viewAttributes() ?>>
<?= $Page->ISCETAK->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->PRINT_DATE->Visible) { // PRINT_DATE ?>
        <td <?= $Page->PRINT_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICE_PRINT_DATE" class="PO_INVOICE_PRINT_DATE">
<span<?= $Page->PRINT_DATE->viewAttributes() ?>>
<?= $Page->PRINT_DATE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->PRINTED_BY->Visible) { // PRINTED_BY ?>
        <td <?= $Page->PRINTED_BY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICE_PRINTED_BY" class="PO_INVOICE_PRINTED_BY">
<span<?= $Page->PRINTED_BY->viewAttributes() ?>>
<?= $Page->PRINTED_BY->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->PRINTQ->Visible) { // PRINTQ ?>
        <td <?= $Page->PRINTQ->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICE_PRINTQ" class="PO_INVOICE_PRINTQ">
<span<?= $Page->PRINTQ->viewAttributes() ?>>
<?= $Page->PRINTQ->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->FAKTUR_DATE->Visible) { // FAKTUR_DATE ?>
        <td <?= $Page->FAKTUR_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICE_FAKTUR_DATE" class="PO_INVOICE_FAKTUR_DATE">
<span<?= $Page->FAKTUR_DATE->viewAttributes() ?>>
<?= $Page->FAKTUR_DATE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->DISTRIBUTION_TYPE->Visible) { // DISTRIBUTION_TYPE ?>
        <td <?= $Page->DISTRIBUTION_TYPE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICE_DISTRIBUTION_TYPE" class="PO_INVOICE_DISTRIBUTION_TYPE">
<span<?= $Page->DISTRIBUTION_TYPE->viewAttributes() ?>>
<?= $Page->DISTRIBUTION_TYPE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->DISCOUNTOFF_VALUE->Visible) { // DISCOUNTOFF_VALUE ?>
        <td <?= $Page->DISCOUNTOFF_VALUE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICE_DISCOUNTOFF_VALUE" class="PO_INVOICE_DISCOUNTOFF_VALUE">
<span<?= $Page->DISCOUNTOFF_VALUE->viewAttributes() ?>>
<?= $Page->DISCOUNTOFF_VALUE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->THECOUNTER->Visible) { // THECOUNTER ?>
        <td <?= $Page->THECOUNTER->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICE_THECOUNTER" class="PO_INVOICE_THECOUNTER">
<span<?= $Page->THECOUNTER->viewAttributes() ?>>
<?= $Page->THECOUNTER->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->FUND_ID->Visible) { // FUND_ID ?>
        <td <?= $Page->FUND_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICE_FUND_ID" class="PO_INVOICE_FUND_ID">
<span<?= $Page->FUND_ID->viewAttributes() ?>>
<?= $Page->FUND_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ORDER_BY->Visible) { // ORDER_BY ?>
        <td <?= $Page->ORDER_BY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICE_ORDER_BY" class="PO_INVOICE_ORDER_BY">
<span<?= $Page->ORDER_BY->viewAttributes() ?>>
<?= $Page->ORDER_BY->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ACKNOWLEDGEBY->Visible) { // ACKNOWLEDGEBY ?>
        <td <?= $Page->ACKNOWLEDGEBY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICE_ACKNOWLEDGEBY" class="PO_INVOICE_ACKNOWLEDGEBY">
<span<?= $Page->ACKNOWLEDGEBY->viewAttributes() ?>>
<?= $Page->ACKNOWLEDGEBY->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->NUM->Visible) { // NUM ?>
        <td <?= $Page->NUM->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICE_NUM" class="PO_INVOICE_NUM">
<span<?= $Page->NUM->viewAttributes() ?>>
<?= $Page->NUM->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ISPO->Visible) { // ISPO ?>
        <td <?= $Page->ISPO->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICE_ISPO" class="PO_INVOICE_ISPO">
<span<?= $Page->ISPO->viewAttributes() ?>>
<?= $Page->ISPO->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->DOCS_TYPE->Visible) { // DOCS_TYPE ?>
        <td <?= $Page->DOCS_TYPE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICE_DOCS_TYPE" class="PO_INVOICE_DOCS_TYPE">
<span<?= $Page->DOCS_TYPE->viewAttributes() ?>>
<?= $Page->DOCS_TYPE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->PO_DATE->Visible) { // PO_DATE ?>
        <td <?= $Page->PO_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICE_PO_DATE" class="PO_INVOICE_PO_DATE">
<span<?= $Page->PO_DATE->viewAttributes() ?>>
<?= $Page->PO_DATE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->PO_VALUE->Visible) { // PO_VALUE ?>
        <td <?= $Page->PO_VALUE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICE_PO_VALUE" class="PO_INVOICE_PO_VALUE">
<span<?= $Page->PO_VALUE->viewAttributes() ?>>
<?= $Page->PO_VALUE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
    </tr>
<?php
    $Page->Recordset->moveNext();
}
$Page->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
