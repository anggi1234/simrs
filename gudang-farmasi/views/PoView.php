<?php

namespace PHPMaker2021\SIMRSSQLSERVERGUDANGFARMASI;

// Page object
$PoView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fPOview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fPOview = currentForm = new ew.Form("fPOview", "view");
    loadjs.done("fPOview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.PO) ew.vars.tables.PO = <?= JsonEncode(GetClientVar("tables", "PO")) ?>;
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
<form name="fPOview" id="fPOview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="PO">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-bordered table-hover ew-view-table">
<?php if ($Page->ORG_UNIT_CODE->Visible) { // ORG_UNIT_CODE ?>
    <tr id="r_ORG_UNIT_CODE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_ORG_UNIT_CODE"><?= $Page->ORG_UNIT_CODE->caption() ?></span></td>
        <td data-name="ORG_UNIT_CODE" <?= $Page->ORG_UNIT_CODE->cellAttributes() ?>>
<span id="el_PO_ORG_UNIT_CODE">
<span<?= $Page->ORG_UNIT_CODE->viewAttributes() ?>>
<?= $Page->ORG_UNIT_CODE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->PO->Visible) { // PO ?>
    <tr id="r_PO">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_PO"><?= $Page->PO->caption() ?></span></td>
        <td data-name="PO" <?= $Page->PO->cellAttributes() ?>>
<span id="el_PO_PO">
<span<?= $Page->PO->viewAttributes() ?>>
<?= $Page->PO->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->PO_DATE->Visible) { // PO_DATE ?>
    <tr id="r_PO_DATE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_PO_DATE"><?= $Page->PO_DATE->caption() ?></span></td>
        <td data-name="PO_DATE" <?= $Page->PO_DATE->cellAttributes() ?>>
<span id="el_PO_PO_DATE">
<span<?= $Page->PO_DATE->viewAttributes() ?>>
<?= $Page->PO_DATE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ORDER_VALUE->Visible) { // ORDER_VALUE ?>
    <tr id="r_ORDER_VALUE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_ORDER_VALUE"><?= $Page->ORDER_VALUE->caption() ?></span></td>
        <td data-name="ORDER_VALUE" <?= $Page->ORDER_VALUE->cellAttributes() ?>>
<span id="el_PO_ORDER_VALUE">
<span<?= $Page->ORDER_VALUE->viewAttributes() ?>>
<?= $Page->ORDER_VALUE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->RECEIVED_VALUE->Visible) { // RECEIVED_VALUE ?>
    <tr id="r_RECEIVED_VALUE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_RECEIVED_VALUE"><?= $Page->RECEIVED_VALUE->caption() ?></span></td>
        <td data-name="RECEIVED_VALUE" <?= $Page->RECEIVED_VALUE->cellAttributes() ?>>
<span id="el_PO_RECEIVED_VALUE">
<span<?= $Page->RECEIVED_VALUE->viewAttributes() ?>>
<?= $Page->RECEIVED_VALUE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->PROCURE_METHOD->Visible) { // PROCURE_METHOD ?>
    <tr id="r_PROCURE_METHOD">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_PROCURE_METHOD"><?= $Page->PROCURE_METHOD->caption() ?></span></td>
        <td data-name="PROCURE_METHOD" <?= $Page->PROCURE_METHOD->cellAttributes() ?>>
<span id="el_PO_PROCURE_METHOD">
<span<?= $Page->PROCURE_METHOD->viewAttributes() ?>>
<?= $Page->PROCURE_METHOD->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->COMPANY_ID->Visible) { // COMPANY_ID ?>
    <tr id="r_COMPANY_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_COMPANY_ID"><?= $Page->COMPANY_ID->caption() ?></span></td>
        <td data-name="COMPANY_ID" <?= $Page->COMPANY_ID->cellAttributes() ?>>
<span id="el_PO_COMPANY_ID">
<span<?= $Page->COMPANY_ID->viewAttributes() ?>>
<?= $Page->COMPANY_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->FUND_ID->Visible) { // FUND_ID ?>
    <tr id="r_FUND_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_FUND_ID"><?= $Page->FUND_ID->caption() ?></span></td>
        <td data-name="FUND_ID" <?= $Page->FUND_ID->cellAttributes() ?>>
<span id="el_PO_FUND_ID">
<span<?= $Page->FUND_ID->viewAttributes() ?>>
<?= $Page->FUND_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->FUND_NO->Visible) { // FUND_NO ?>
    <tr id="r_FUND_NO">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_FUND_NO"><?= $Page->FUND_NO->caption() ?></span></td>
        <td data-name="FUND_NO" <?= $Page->FUND_NO->cellAttributes() ?>>
<span id="el_PO_FUND_NO">
<span<?= $Page->FUND_NO->viewAttributes() ?>>
<?= $Page->FUND_NO->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->DESCRIPTION->Visible) { // DESCRIPTION ?>
    <tr id="r_DESCRIPTION">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_DESCRIPTION"><?= $Page->DESCRIPTION->caption() ?></span></td>
        <td data-name="DESCRIPTION" <?= $Page->DESCRIPTION->cellAttributes() ?>>
<span id="el_PO_DESCRIPTION">
<span<?= $Page->DESCRIPTION->viewAttributes() ?>>
<?= $Page->DESCRIPTION->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
    <tr id="r_MODIFIED_DATE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_MODIFIED_DATE"><?= $Page->MODIFIED_DATE->caption() ?></span></td>
        <td data-name="MODIFIED_DATE" <?= $Page->MODIFIED_DATE->cellAttributes() ?>>
<span id="el_PO_MODIFIED_DATE">
<span<?= $Page->MODIFIED_DATE->viewAttributes() ?>>
<?= $Page->MODIFIED_DATE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
    <tr id="r_MODIFIED_BY">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_MODIFIED_BY"><?= $Page->MODIFIED_BY->caption() ?></span></td>
        <td data-name="MODIFIED_BY" <?= $Page->MODIFIED_BY->cellAttributes() ?>>
<span id="el_PO_MODIFIED_BY">
<span<?= $Page->MODIFIED_BY->viewAttributes() ?>>
<?= $Page->MODIFIED_BY->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ORDER_BY->Visible) { // ORDER_BY ?>
    <tr id="r_ORDER_BY">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_ORDER_BY"><?= $Page->ORDER_BY->caption() ?></span></td>
        <td data-name="ORDER_BY" <?= $Page->ORDER_BY->cellAttributes() ?>>
<span id="el_PO_ORDER_BY">
<span<?= $Page->ORDER_BY->viewAttributes() ?>>
<?= $Page->ORDER_BY->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->SENT_TO->Visible) { // SENT_TO ?>
    <tr id="r_SENT_TO">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_SENT_TO"><?= $Page->SENT_TO->caption() ?></span></td>
        <td data-name="SENT_TO" <?= $Page->SENT_TO->cellAttributes() ?>>
<span id="el_PO_SENT_TO">
<span<?= $Page->SENT_TO->viewAttributes() ?>>
<?= $Page->SENT_TO->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ISVALID->Visible) { // ISVALID ?>
    <tr id="r_ISVALID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_ISVALID"><?= $Page->ISVALID->caption() ?></span></td>
        <td data-name="ISVALID" <?= $Page->ISVALID->cellAttributes() ?>>
<span id="el_PO_ISVALID">
<span<?= $Page->ISVALID->viewAttributes() ?>>
<?= $Page->ISVALID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->START_VALID->Visible) { // START_VALID ?>
    <tr id="r_START_VALID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_START_VALID"><?= $Page->START_VALID->caption() ?></span></td>
        <td data-name="START_VALID" <?= $Page->START_VALID->cellAttributes() ?>>
<span id="el_PO_START_VALID">
<span<?= $Page->START_VALID->viewAttributes() ?>>
<?= $Page->START_VALID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->END_VALID->Visible) { // END_VALID ?>
    <tr id="r_END_VALID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_END_VALID"><?= $Page->END_VALID->caption() ?></span></td>
        <td data-name="END_VALID" <?= $Page->END_VALID->cellAttributes() ?>>
<span id="el_PO_END_VALID">
<span<?= $Page->END_VALID->viewAttributes() ?>>
<?= $Page->END_VALID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->CONTRACT_NO->Visible) { // CONTRACT_NO ?>
    <tr id="r_CONTRACT_NO">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_CONTRACT_NO"><?= $Page->CONTRACT_NO->caption() ?></span></td>
        <td data-name="CONTRACT_NO" <?= $Page->CONTRACT_NO->cellAttributes() ?>>
<span id="el_PO_CONTRACT_NO">
<span<?= $Page->CONTRACT_NO->viewAttributes() ?>>
<?= $Page->CONTRACT_NO->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ORG_ID->Visible) { // ORG_ID ?>
    <tr id="r_ORG_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_ORG_ID"><?= $Page->ORG_ID->caption() ?></span></td>
        <td data-name="ORG_ID" <?= $Page->ORG_ID->cellAttributes() ?>>
<span id="el_PO_ORG_ID">
<span<?= $Page->ORG_ID->viewAttributes() ?>>
<?= $Page->ORG_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->CLINIC_ID->Visible) { // CLINIC_ID ?>
    <tr id="r_CLINIC_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_CLINIC_ID"><?= $Page->CLINIC_ID->caption() ?></span></td>
        <td data-name="CLINIC_ID" <?= $Page->CLINIC_ID->cellAttributes() ?>>
<span id="el_PO_CLINIC_ID">
<span<?= $Page->CLINIC_ID->viewAttributes() ?>>
<?= $Page->CLINIC_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ACCOUNT_ID->Visible) { // ACCOUNT_ID ?>
    <tr id="r_ACCOUNT_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_ACCOUNT_ID"><?= $Page->ACCOUNT_ID->caption() ?></span></td>
        <td data-name="ACCOUNT_ID" <?= $Page->ACCOUNT_ID->cellAttributes() ?>>
<span id="el_PO_ACCOUNT_ID">
<span<?= $Page->ACCOUNT_ID->viewAttributes() ?>>
<?= $Page->ACCOUNT_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->PAID_VALUE->Visible) { // PAID_VALUE ?>
    <tr id="r_PAID_VALUE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_PAID_VALUE"><?= $Page->PAID_VALUE->caption() ?></span></td>
        <td data-name="PAID_VALUE" <?= $Page->PAID_VALUE->cellAttributes() ?>>
<span id="el_PO_PAID_VALUE">
<span<?= $Page->PAID_VALUE->viewAttributes() ?>>
<?= $Page->PAID_VALUE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->PPN->Visible) { // PPN ?>
    <tr id="r_PPN">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_PPN"><?= $Page->PPN->caption() ?></span></td>
        <td data-name="PPN" <?= $Page->PPN->cellAttributes() ?>>
<span id="el_PO_PPN">
<span<?= $Page->PPN->viewAttributes() ?>>
<?= $Page->PPN->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->MATERAI->Visible) { // MATERAI ?>
    <tr id="r_MATERAI">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_MATERAI"><?= $Page->MATERAI->caption() ?></span></td>
        <td data-name="MATERAI" <?= $Page->MATERAI->cellAttributes() ?>>
<span id="el_PO_MATERAI">
<span<?= $Page->MATERAI->viewAttributes() ?>>
<?= $Page->MATERAI->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->PPN_VALUE->Visible) { // PPN_VALUE ?>
    <tr id="r_PPN_VALUE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_PPN_VALUE"><?= $Page->PPN_VALUE->caption() ?></span></td>
        <td data-name="PPN_VALUE" <?= $Page->PPN_VALUE->cellAttributes() ?>>
<span id="el_PO_PPN_VALUE">
<span<?= $Page->PPN_VALUE->viewAttributes() ?>>
<?= $Page->PPN_VALUE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->DISCOUNT_VALUE->Visible) { // DISCOUNT_VALUE ?>
    <tr id="r_DISCOUNT_VALUE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_DISCOUNT_VALUE"><?= $Page->DISCOUNT_VALUE->caption() ?></span></td>
        <td data-name="DISCOUNT_VALUE" <?= $Page->DISCOUNT_VALUE->cellAttributes() ?>>
<span id="el_PO_DISCOUNT_VALUE">
<span<?= $Page->DISCOUNT_VALUE->viewAttributes() ?>>
<?= $Page->DISCOUNT_VALUE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ISCETAK->Visible) { // ISCETAK ?>
    <tr id="r_ISCETAK">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_ISCETAK"><?= $Page->ISCETAK->caption() ?></span></td>
        <td data-name="ISCETAK" <?= $Page->ISCETAK->cellAttributes() ?>>
<span id="el_PO_ISCETAK">
<span<?= $Page->ISCETAK->viewAttributes() ?>>
<?= $Page->ISCETAK->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->PRINT_DATE->Visible) { // PRINT_DATE ?>
    <tr id="r_PRINT_DATE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_PRINT_DATE"><?= $Page->PRINT_DATE->caption() ?></span></td>
        <td data-name="PRINT_DATE" <?= $Page->PRINT_DATE->cellAttributes() ?>>
<span id="el_PO_PRINT_DATE">
<span<?= $Page->PRINT_DATE->viewAttributes() ?>>
<?= $Page->PRINT_DATE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->PRINTED_BY->Visible) { // PRINTED_BY ?>
    <tr id="r_PRINTED_BY">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_PRINTED_BY"><?= $Page->PRINTED_BY->caption() ?></span></td>
        <td data-name="PRINTED_BY" <?= $Page->PRINTED_BY->cellAttributes() ?>>
<span id="el_PO_PRINTED_BY">
<span<?= $Page->PRINTED_BY->viewAttributes() ?>>
<?= $Page->PRINTED_BY->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->PRINTQ->Visible) { // PRINTQ ?>
    <tr id="r_PRINTQ">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_PRINTQ"><?= $Page->PRINTQ->caption() ?></span></td>
        <td data-name="PRINTQ" <?= $Page->PRINTQ->cellAttributes() ?>>
<span id="el_PO_PRINTQ">
<span<?= $Page->PRINTQ->viewAttributes() ?>>
<?= $Page->PRINTQ->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->TAGIHAN_VALUE->Visible) { // TAGIHAN_VALUE ?>
    <tr id="r_TAGIHAN_VALUE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_TAGIHAN_VALUE"><?= $Page->TAGIHAN_VALUE->caption() ?></span></td>
        <td data-name="TAGIHAN_VALUE" <?= $Page->TAGIHAN_VALUE->cellAttributes() ?>>
<span id="el_PO_TAGIHAN_VALUE">
<span<?= $Page->TAGIHAN_VALUE->viewAttributes() ?>>
<?= $Page->TAGIHAN_VALUE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ACKNOWLEDGEBY->Visible) { // ACKNOWLEDGEBY ?>
    <tr id="r_ACKNOWLEDGEBY">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_ACKNOWLEDGEBY"><?= $Page->ACKNOWLEDGEBY->caption() ?></span></td>
        <td data-name="ACKNOWLEDGEBY" <?= $Page->ACKNOWLEDGEBY->cellAttributes() ?>>
<span id="el_PO_ACKNOWLEDGEBY">
<span<?= $Page->ACKNOWLEDGEBY->viewAttributes() ?>>
<?= $Page->ACKNOWLEDGEBY->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->NUM->Visible) { // NUM ?>
    <tr id="r_NUM">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_NUM"><?= $Page->NUM->caption() ?></span></td>
        <td data-name="NUM" <?= $Page->NUM->cellAttributes() ?>>
<span id="el_PO_NUM">
<span<?= $Page->NUM->viewAttributes() ?>>
<?= $Page->NUM->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ID->Visible) { // ID ?>
    <tr id="r_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_PO_ID"><?= $Page->ID->caption() ?></span></td>
        <td data-name="ID" <?= $Page->ID->cellAttributes() ?>>
<span id="el_PO_ID">
<span<?= $Page->ID->viewAttributes() ?>>
<?= $Page->ID->getViewValue() ?></span>
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
