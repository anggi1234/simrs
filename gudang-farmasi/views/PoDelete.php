<?php

namespace PHPMaker2021\SIMRSSQLSERVERGUDANGFARMASI;

// Page object
$PoDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fPOdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fPOdelete = currentForm = new ew.Form("fPOdelete", "delete");
    loadjs.done("fPOdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.PO) ew.vars.tables.PO = <?= JsonEncode(GetClientVar("tables", "PO")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fPOdelete" id="fPOdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="PO">
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
        <th class="<?= $Page->ORG_UNIT_CODE->headerCellClass() ?>"><span id="elh_PO_ORG_UNIT_CODE" class="PO_ORG_UNIT_CODE"><?= $Page->ORG_UNIT_CODE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->PO->Visible) { // PO ?>
        <th class="<?= $Page->PO->headerCellClass() ?>"><span id="elh_PO_PO" class="PO_PO"><?= $Page->PO->caption() ?></span></th>
<?php } ?>
<?php if ($Page->PO_DATE->Visible) { // PO_DATE ?>
        <th class="<?= $Page->PO_DATE->headerCellClass() ?>"><span id="elh_PO_PO_DATE" class="PO_PO_DATE"><?= $Page->PO_DATE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ORDER_VALUE->Visible) { // ORDER_VALUE ?>
        <th class="<?= $Page->ORDER_VALUE->headerCellClass() ?>"><span id="elh_PO_ORDER_VALUE" class="PO_ORDER_VALUE"><?= $Page->ORDER_VALUE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->RECEIVED_VALUE->Visible) { // RECEIVED_VALUE ?>
        <th class="<?= $Page->RECEIVED_VALUE->headerCellClass() ?>"><span id="elh_PO_RECEIVED_VALUE" class="PO_RECEIVED_VALUE"><?= $Page->RECEIVED_VALUE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->PROCURE_METHOD->Visible) { // PROCURE_METHOD ?>
        <th class="<?= $Page->PROCURE_METHOD->headerCellClass() ?>"><span id="elh_PO_PROCURE_METHOD" class="PO_PROCURE_METHOD"><?= $Page->PROCURE_METHOD->caption() ?></span></th>
<?php } ?>
<?php if ($Page->COMPANY_ID->Visible) { // COMPANY_ID ?>
        <th class="<?= $Page->COMPANY_ID->headerCellClass() ?>"><span id="elh_PO_COMPANY_ID" class="PO_COMPANY_ID"><?= $Page->COMPANY_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->FUND_ID->Visible) { // FUND_ID ?>
        <th class="<?= $Page->FUND_ID->headerCellClass() ?>"><span id="elh_PO_FUND_ID" class="PO_FUND_ID"><?= $Page->FUND_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->FUND_NO->Visible) { // FUND_NO ?>
        <th class="<?= $Page->FUND_NO->headerCellClass() ?>"><span id="elh_PO_FUND_NO" class="PO_FUND_NO"><?= $Page->FUND_NO->caption() ?></span></th>
<?php } ?>
<?php if ($Page->DESCRIPTION->Visible) { // DESCRIPTION ?>
        <th class="<?= $Page->DESCRIPTION->headerCellClass() ?>"><span id="elh_PO_DESCRIPTION" class="PO_DESCRIPTION"><?= $Page->DESCRIPTION->caption() ?></span></th>
<?php } ?>
<?php if ($Page->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
        <th class="<?= $Page->MODIFIED_DATE->headerCellClass() ?>"><span id="elh_PO_MODIFIED_DATE" class="PO_MODIFIED_DATE"><?= $Page->MODIFIED_DATE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
        <th class="<?= $Page->MODIFIED_BY->headerCellClass() ?>"><span id="elh_PO_MODIFIED_BY" class="PO_MODIFIED_BY"><?= $Page->MODIFIED_BY->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ORDER_BY->Visible) { // ORDER_BY ?>
        <th class="<?= $Page->ORDER_BY->headerCellClass() ?>"><span id="elh_PO_ORDER_BY" class="PO_ORDER_BY"><?= $Page->ORDER_BY->caption() ?></span></th>
<?php } ?>
<?php if ($Page->SENT_TO->Visible) { // SENT_TO ?>
        <th class="<?= $Page->SENT_TO->headerCellClass() ?>"><span id="elh_PO_SENT_TO" class="PO_SENT_TO"><?= $Page->SENT_TO->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ISVALID->Visible) { // ISVALID ?>
        <th class="<?= $Page->ISVALID->headerCellClass() ?>"><span id="elh_PO_ISVALID" class="PO_ISVALID"><?= $Page->ISVALID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->START_VALID->Visible) { // START_VALID ?>
        <th class="<?= $Page->START_VALID->headerCellClass() ?>"><span id="elh_PO_START_VALID" class="PO_START_VALID"><?= $Page->START_VALID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->END_VALID->Visible) { // END_VALID ?>
        <th class="<?= $Page->END_VALID->headerCellClass() ?>"><span id="elh_PO_END_VALID" class="PO_END_VALID"><?= $Page->END_VALID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->CONTRACT_NO->Visible) { // CONTRACT_NO ?>
        <th class="<?= $Page->CONTRACT_NO->headerCellClass() ?>"><span id="elh_PO_CONTRACT_NO" class="PO_CONTRACT_NO"><?= $Page->CONTRACT_NO->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ORG_ID->Visible) { // ORG_ID ?>
        <th class="<?= $Page->ORG_ID->headerCellClass() ?>"><span id="elh_PO_ORG_ID" class="PO_ORG_ID"><?= $Page->ORG_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->CLINIC_ID->Visible) { // CLINIC_ID ?>
        <th class="<?= $Page->CLINIC_ID->headerCellClass() ?>"><span id="elh_PO_CLINIC_ID" class="PO_CLINIC_ID"><?= $Page->CLINIC_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ACCOUNT_ID->Visible) { // ACCOUNT_ID ?>
        <th class="<?= $Page->ACCOUNT_ID->headerCellClass() ?>"><span id="elh_PO_ACCOUNT_ID" class="PO_ACCOUNT_ID"><?= $Page->ACCOUNT_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->PAID_VALUE->Visible) { // PAID_VALUE ?>
        <th class="<?= $Page->PAID_VALUE->headerCellClass() ?>"><span id="elh_PO_PAID_VALUE" class="PO_PAID_VALUE"><?= $Page->PAID_VALUE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->PPN->Visible) { // PPN ?>
        <th class="<?= $Page->PPN->headerCellClass() ?>"><span id="elh_PO_PPN" class="PO_PPN"><?= $Page->PPN->caption() ?></span></th>
<?php } ?>
<?php if ($Page->MATERAI->Visible) { // MATERAI ?>
        <th class="<?= $Page->MATERAI->headerCellClass() ?>"><span id="elh_PO_MATERAI" class="PO_MATERAI"><?= $Page->MATERAI->caption() ?></span></th>
<?php } ?>
<?php if ($Page->PPN_VALUE->Visible) { // PPN_VALUE ?>
        <th class="<?= $Page->PPN_VALUE->headerCellClass() ?>"><span id="elh_PO_PPN_VALUE" class="PO_PPN_VALUE"><?= $Page->PPN_VALUE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->DISCOUNT_VALUE->Visible) { // DISCOUNT_VALUE ?>
        <th class="<?= $Page->DISCOUNT_VALUE->headerCellClass() ?>"><span id="elh_PO_DISCOUNT_VALUE" class="PO_DISCOUNT_VALUE"><?= $Page->DISCOUNT_VALUE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ISCETAK->Visible) { // ISCETAK ?>
        <th class="<?= $Page->ISCETAK->headerCellClass() ?>"><span id="elh_PO_ISCETAK" class="PO_ISCETAK"><?= $Page->ISCETAK->caption() ?></span></th>
<?php } ?>
<?php if ($Page->PRINT_DATE->Visible) { // PRINT_DATE ?>
        <th class="<?= $Page->PRINT_DATE->headerCellClass() ?>"><span id="elh_PO_PRINT_DATE" class="PO_PRINT_DATE"><?= $Page->PRINT_DATE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->PRINTED_BY->Visible) { // PRINTED_BY ?>
        <th class="<?= $Page->PRINTED_BY->headerCellClass() ?>"><span id="elh_PO_PRINTED_BY" class="PO_PRINTED_BY"><?= $Page->PRINTED_BY->caption() ?></span></th>
<?php } ?>
<?php if ($Page->PRINTQ->Visible) { // PRINTQ ?>
        <th class="<?= $Page->PRINTQ->headerCellClass() ?>"><span id="elh_PO_PRINTQ" class="PO_PRINTQ"><?= $Page->PRINTQ->caption() ?></span></th>
<?php } ?>
<?php if ($Page->TAGIHAN_VALUE->Visible) { // TAGIHAN_VALUE ?>
        <th class="<?= $Page->TAGIHAN_VALUE->headerCellClass() ?>"><span id="elh_PO_TAGIHAN_VALUE" class="PO_TAGIHAN_VALUE"><?= $Page->TAGIHAN_VALUE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ACKNOWLEDGEBY->Visible) { // ACKNOWLEDGEBY ?>
        <th class="<?= $Page->ACKNOWLEDGEBY->headerCellClass() ?>"><span id="elh_PO_ACKNOWLEDGEBY" class="PO_ACKNOWLEDGEBY"><?= $Page->ACKNOWLEDGEBY->caption() ?></span></th>
<?php } ?>
<?php if ($Page->NUM->Visible) { // NUM ?>
        <th class="<?= $Page->NUM->headerCellClass() ?>"><span id="elh_PO_NUM" class="PO_NUM"><?= $Page->NUM->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ID->Visible) { // ID ?>
        <th class="<?= $Page->ID->headerCellClass() ?>"><span id="elh_PO_ID" class="PO_ID"><?= $Page->ID->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_PO_ORG_UNIT_CODE" class="PO_ORG_UNIT_CODE">
<span<?= $Page->ORG_UNIT_CODE->viewAttributes() ?>>
<?= $Page->ORG_UNIT_CODE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->PO->Visible) { // PO ?>
        <td <?= $Page->PO->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_PO" class="PO_PO">
<span<?= $Page->PO->viewAttributes() ?>>
<?= $Page->PO->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->PO_DATE->Visible) { // PO_DATE ?>
        <td <?= $Page->PO_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_PO_DATE" class="PO_PO_DATE">
<span<?= $Page->PO_DATE->viewAttributes() ?>>
<?= $Page->PO_DATE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ORDER_VALUE->Visible) { // ORDER_VALUE ?>
        <td <?= $Page->ORDER_VALUE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_ORDER_VALUE" class="PO_ORDER_VALUE">
<span<?= $Page->ORDER_VALUE->viewAttributes() ?>>
<?= $Page->ORDER_VALUE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->RECEIVED_VALUE->Visible) { // RECEIVED_VALUE ?>
        <td <?= $Page->RECEIVED_VALUE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_RECEIVED_VALUE" class="PO_RECEIVED_VALUE">
<span<?= $Page->RECEIVED_VALUE->viewAttributes() ?>>
<?= $Page->RECEIVED_VALUE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->PROCURE_METHOD->Visible) { // PROCURE_METHOD ?>
        <td <?= $Page->PROCURE_METHOD->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_PROCURE_METHOD" class="PO_PROCURE_METHOD">
<span<?= $Page->PROCURE_METHOD->viewAttributes() ?>>
<?= $Page->PROCURE_METHOD->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->COMPANY_ID->Visible) { // COMPANY_ID ?>
        <td <?= $Page->COMPANY_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_COMPANY_ID" class="PO_COMPANY_ID">
<span<?= $Page->COMPANY_ID->viewAttributes() ?>>
<?= $Page->COMPANY_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->FUND_ID->Visible) { // FUND_ID ?>
        <td <?= $Page->FUND_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_FUND_ID" class="PO_FUND_ID">
<span<?= $Page->FUND_ID->viewAttributes() ?>>
<?= $Page->FUND_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->FUND_NO->Visible) { // FUND_NO ?>
        <td <?= $Page->FUND_NO->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_FUND_NO" class="PO_FUND_NO">
<span<?= $Page->FUND_NO->viewAttributes() ?>>
<?= $Page->FUND_NO->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->DESCRIPTION->Visible) { // DESCRIPTION ?>
        <td <?= $Page->DESCRIPTION->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_DESCRIPTION" class="PO_DESCRIPTION">
<span<?= $Page->DESCRIPTION->viewAttributes() ?>>
<?= $Page->DESCRIPTION->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
        <td <?= $Page->MODIFIED_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_MODIFIED_DATE" class="PO_MODIFIED_DATE">
<span<?= $Page->MODIFIED_DATE->viewAttributes() ?>>
<?= $Page->MODIFIED_DATE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
        <td <?= $Page->MODIFIED_BY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_MODIFIED_BY" class="PO_MODIFIED_BY">
<span<?= $Page->MODIFIED_BY->viewAttributes() ?>>
<?= $Page->MODIFIED_BY->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ORDER_BY->Visible) { // ORDER_BY ?>
        <td <?= $Page->ORDER_BY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_ORDER_BY" class="PO_ORDER_BY">
<span<?= $Page->ORDER_BY->viewAttributes() ?>>
<?= $Page->ORDER_BY->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->SENT_TO->Visible) { // SENT_TO ?>
        <td <?= $Page->SENT_TO->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_SENT_TO" class="PO_SENT_TO">
<span<?= $Page->SENT_TO->viewAttributes() ?>>
<?= $Page->SENT_TO->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ISVALID->Visible) { // ISVALID ?>
        <td <?= $Page->ISVALID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_ISVALID" class="PO_ISVALID">
<span<?= $Page->ISVALID->viewAttributes() ?>>
<?= $Page->ISVALID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->START_VALID->Visible) { // START_VALID ?>
        <td <?= $Page->START_VALID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_START_VALID" class="PO_START_VALID">
<span<?= $Page->START_VALID->viewAttributes() ?>>
<?= $Page->START_VALID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->END_VALID->Visible) { // END_VALID ?>
        <td <?= $Page->END_VALID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_END_VALID" class="PO_END_VALID">
<span<?= $Page->END_VALID->viewAttributes() ?>>
<?= $Page->END_VALID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->CONTRACT_NO->Visible) { // CONTRACT_NO ?>
        <td <?= $Page->CONTRACT_NO->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_CONTRACT_NO" class="PO_CONTRACT_NO">
<span<?= $Page->CONTRACT_NO->viewAttributes() ?>>
<?= $Page->CONTRACT_NO->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ORG_ID->Visible) { // ORG_ID ?>
        <td <?= $Page->ORG_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_ORG_ID" class="PO_ORG_ID">
<span<?= $Page->ORG_ID->viewAttributes() ?>>
<?= $Page->ORG_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->CLINIC_ID->Visible) { // CLINIC_ID ?>
        <td <?= $Page->CLINIC_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_CLINIC_ID" class="PO_CLINIC_ID">
<span<?= $Page->CLINIC_ID->viewAttributes() ?>>
<?= $Page->CLINIC_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ACCOUNT_ID->Visible) { // ACCOUNT_ID ?>
        <td <?= $Page->ACCOUNT_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_ACCOUNT_ID" class="PO_ACCOUNT_ID">
<span<?= $Page->ACCOUNT_ID->viewAttributes() ?>>
<?= $Page->ACCOUNT_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->PAID_VALUE->Visible) { // PAID_VALUE ?>
        <td <?= $Page->PAID_VALUE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_PAID_VALUE" class="PO_PAID_VALUE">
<span<?= $Page->PAID_VALUE->viewAttributes() ?>>
<?= $Page->PAID_VALUE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->PPN->Visible) { // PPN ?>
        <td <?= $Page->PPN->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_PPN" class="PO_PPN">
<span<?= $Page->PPN->viewAttributes() ?>>
<?= $Page->PPN->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->MATERAI->Visible) { // MATERAI ?>
        <td <?= $Page->MATERAI->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_MATERAI" class="PO_MATERAI">
<span<?= $Page->MATERAI->viewAttributes() ?>>
<?= $Page->MATERAI->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->PPN_VALUE->Visible) { // PPN_VALUE ?>
        <td <?= $Page->PPN_VALUE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_PPN_VALUE" class="PO_PPN_VALUE">
<span<?= $Page->PPN_VALUE->viewAttributes() ?>>
<?= $Page->PPN_VALUE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->DISCOUNT_VALUE->Visible) { // DISCOUNT_VALUE ?>
        <td <?= $Page->DISCOUNT_VALUE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_DISCOUNT_VALUE" class="PO_DISCOUNT_VALUE">
<span<?= $Page->DISCOUNT_VALUE->viewAttributes() ?>>
<?= $Page->DISCOUNT_VALUE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ISCETAK->Visible) { // ISCETAK ?>
        <td <?= $Page->ISCETAK->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_ISCETAK" class="PO_ISCETAK">
<span<?= $Page->ISCETAK->viewAttributes() ?>>
<?= $Page->ISCETAK->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->PRINT_DATE->Visible) { // PRINT_DATE ?>
        <td <?= $Page->PRINT_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_PRINT_DATE" class="PO_PRINT_DATE">
<span<?= $Page->PRINT_DATE->viewAttributes() ?>>
<?= $Page->PRINT_DATE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->PRINTED_BY->Visible) { // PRINTED_BY ?>
        <td <?= $Page->PRINTED_BY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_PRINTED_BY" class="PO_PRINTED_BY">
<span<?= $Page->PRINTED_BY->viewAttributes() ?>>
<?= $Page->PRINTED_BY->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->PRINTQ->Visible) { // PRINTQ ?>
        <td <?= $Page->PRINTQ->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_PRINTQ" class="PO_PRINTQ">
<span<?= $Page->PRINTQ->viewAttributes() ?>>
<?= $Page->PRINTQ->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->TAGIHAN_VALUE->Visible) { // TAGIHAN_VALUE ?>
        <td <?= $Page->TAGIHAN_VALUE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_TAGIHAN_VALUE" class="PO_TAGIHAN_VALUE">
<span<?= $Page->TAGIHAN_VALUE->viewAttributes() ?>>
<?= $Page->TAGIHAN_VALUE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ACKNOWLEDGEBY->Visible) { // ACKNOWLEDGEBY ?>
        <td <?= $Page->ACKNOWLEDGEBY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_ACKNOWLEDGEBY" class="PO_ACKNOWLEDGEBY">
<span<?= $Page->ACKNOWLEDGEBY->viewAttributes() ?>>
<?= $Page->ACKNOWLEDGEBY->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->NUM->Visible) { // NUM ?>
        <td <?= $Page->NUM->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_NUM" class="PO_NUM">
<span<?= $Page->NUM->viewAttributes() ?>>
<?= $Page->NUM->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ID->Visible) { // ID ?>
        <td <?= $Page->ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_ID" class="PO_ID">
<span<?= $Page->ID->viewAttributes() ?>>
<?= $Page->ID->getViewValue() ?></span>
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
