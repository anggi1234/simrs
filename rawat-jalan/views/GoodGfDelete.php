<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAJALALTER;

// Page object
$GoodGfDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fGOOD_GFdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fGOOD_GFdelete = currentForm = new ew.Form("fGOOD_GFdelete", "delete");
    loadjs.done("fGOOD_GFdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.GOOD_GF) ew.vars.tables.GOOD_GF = <?= JsonEncode(GetClientVar("tables", "GOOD_GF")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fGOOD_GFdelete" id="fGOOD_GFdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="GOOD_GF">
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
<?php if ($Page->ORG_ID->Visible) { // ORG_ID ?>
        <th class="<?= $Page->ORG_ID->headerCellClass() ?>"><span id="elh_GOOD_GF_ORG_ID" class="GOOD_GF_ORG_ID"><?= $Page->ORG_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->BRAND_ID->Visible) { // BRAND_ID ?>
        <th class="<?= $Page->BRAND_ID->headerCellClass() ?>"><span id="elh_GOOD_GF_BRAND_ID" class="GOOD_GF_BRAND_ID"><?= $Page->BRAND_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->BRAND_NAME->Visible) { // BRAND_NAME ?>
        <th class="<?= $Page->BRAND_NAME->headerCellClass() ?>"><span id="elh_GOOD_GF_BRAND_NAME" class="GOOD_GF_BRAND_NAME"><?= $Page->BRAND_NAME->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ROOMS_ID->Visible) { // ROOMS_ID ?>
        <th class="<?= $Page->ROOMS_ID->headerCellClass() ?>"><span id="elh_GOOD_GF_ROOMS_ID" class="GOOD_GF_ROOMS_ID"><?= $Page->ROOMS_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->QUANTITY->Visible) { // QUANTITY ?>
        <th class="<?= $Page->QUANTITY->headerCellClass() ?>"><span id="elh_GOOD_GF_QUANTITY" class="GOOD_GF_QUANTITY"><?= $Page->QUANTITY->caption() ?></span></th>
<?php } ?>
<?php if ($Page->MEASURE_ID->Visible) { // MEASURE_ID ?>
        <th class="<?= $Page->MEASURE_ID->headerCellClass() ?>"><span id="elh_GOOD_GF_MEASURE_ID" class="GOOD_GF_MEASURE_ID"><?= $Page->MEASURE_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ALLOCATED_DATE->Visible) { // ALLOCATED_DATE ?>
        <th class="<?= $Page->ALLOCATED_DATE->headerCellClass() ?>"><span id="elh_GOOD_GF_ALLOCATED_DATE" class="GOOD_GF_ALLOCATED_DATE"><?= $Page->ALLOCATED_DATE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->INVOICE_ID->Visible) { // INVOICE_ID ?>
        <th class="<?= $Page->INVOICE_ID->headerCellClass() ?>"><span id="elh_GOOD_GF_INVOICE_ID" class="GOOD_GF_INVOICE_ID"><?= $Page->INVOICE_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ALLOCATED_FROM->Visible) { // ALLOCATED_FROM ?>
        <th class="<?= $Page->ALLOCATED_FROM->headerCellClass() ?>"><span id="elh_GOOD_GF_ALLOCATED_FROM" class="GOOD_GF_ALLOCATED_FROM"><?= $Page->ALLOCATED_FROM->caption() ?></span></th>
<?php } ?>
<?php if ($Page->PRICE->Visible) { // PRICE ?>
        <th class="<?= $Page->PRICE->headerCellClass() ?>"><span id="elh_GOOD_GF_PRICE" class="GOOD_GF_PRICE"><?= $Page->PRICE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->DIJUAL->Visible) { // DIJUAL ?>
        <th class="<?= $Page->DIJUAL->headerCellClass() ?>"><span id="elh_GOOD_GF_DIJUAL" class="GOOD_GF_DIJUAL"><?= $Page->DIJUAL->caption() ?></span></th>
<?php } ?>
<?php if ($Page->DOC_NO->Visible) { // DOC_NO ?>
        <th class="<?= $Page->DOC_NO->headerCellClass() ?>"><span id="elh_GOOD_GF_DOC_NO" class="GOOD_GF_DOC_NO"><?= $Page->DOC_NO->caption() ?></span></th>
<?php } ?>
<?php if ($Page->PRINT_DATE->Visible) { // PRINT_DATE ?>
        <th class="<?= $Page->PRINT_DATE->headerCellClass() ?>"><span id="elh_GOOD_GF_PRINT_DATE" class="GOOD_GF_PRINT_DATE"><?= $Page->PRINT_DATE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->PRINTED_BY->Visible) { // PRINTED_BY ?>
        <th class="<?= $Page->PRINTED_BY->headerCellClass() ?>"><span id="elh_GOOD_GF_PRINTED_BY" class="GOOD_GF_PRINTED_BY"><?= $Page->PRINTED_BY->caption() ?></span></th>
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
<?php if ($Page->ORG_ID->Visible) { // ORG_ID ?>
        <td <?= $Page->ORG_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_ORG_ID" class="GOOD_GF_ORG_ID">
<span<?= $Page->ORG_ID->viewAttributes() ?>>
<?= $Page->ORG_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->BRAND_ID->Visible) { // BRAND_ID ?>
        <td <?= $Page->BRAND_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_BRAND_ID" class="GOOD_GF_BRAND_ID">
<span<?= $Page->BRAND_ID->viewAttributes() ?>>
<?= $Page->BRAND_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->BRAND_NAME->Visible) { // BRAND_NAME ?>
        <td <?= $Page->BRAND_NAME->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_BRAND_NAME" class="GOOD_GF_BRAND_NAME">
<span<?= $Page->BRAND_NAME->viewAttributes() ?>>
<?= $Page->BRAND_NAME->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ROOMS_ID->Visible) { // ROOMS_ID ?>
        <td <?= $Page->ROOMS_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_ROOMS_ID" class="GOOD_GF_ROOMS_ID">
<span<?= $Page->ROOMS_ID->viewAttributes() ?>>
<?= $Page->ROOMS_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->QUANTITY->Visible) { // QUANTITY ?>
        <td <?= $Page->QUANTITY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_QUANTITY" class="GOOD_GF_QUANTITY">
<span<?= $Page->QUANTITY->viewAttributes() ?>>
<?= $Page->QUANTITY->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->MEASURE_ID->Visible) { // MEASURE_ID ?>
        <td <?= $Page->MEASURE_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_MEASURE_ID" class="GOOD_GF_MEASURE_ID">
<span<?= $Page->MEASURE_ID->viewAttributes() ?>>
<?= $Page->MEASURE_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ALLOCATED_DATE->Visible) { // ALLOCATED_DATE ?>
        <td <?= $Page->ALLOCATED_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_ALLOCATED_DATE" class="GOOD_GF_ALLOCATED_DATE">
<span<?= $Page->ALLOCATED_DATE->viewAttributes() ?>>
<?= $Page->ALLOCATED_DATE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->INVOICE_ID->Visible) { // INVOICE_ID ?>
        <td <?= $Page->INVOICE_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_INVOICE_ID" class="GOOD_GF_INVOICE_ID">
<span<?= $Page->INVOICE_ID->viewAttributes() ?>>
<?= $Page->INVOICE_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ALLOCATED_FROM->Visible) { // ALLOCATED_FROM ?>
        <td <?= $Page->ALLOCATED_FROM->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_ALLOCATED_FROM" class="GOOD_GF_ALLOCATED_FROM">
<span<?= $Page->ALLOCATED_FROM->viewAttributes() ?>>
<?= $Page->ALLOCATED_FROM->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->PRICE->Visible) { // PRICE ?>
        <td <?= $Page->PRICE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_PRICE" class="GOOD_GF_PRICE">
<span<?= $Page->PRICE->viewAttributes() ?>>
<?= $Page->PRICE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->DIJUAL->Visible) { // DIJUAL ?>
        <td <?= $Page->DIJUAL->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_DIJUAL" class="GOOD_GF_DIJUAL">
<span<?= $Page->DIJUAL->viewAttributes() ?>>
<?= $Page->DIJUAL->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->DOC_NO->Visible) { // DOC_NO ?>
        <td <?= $Page->DOC_NO->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_DOC_NO" class="GOOD_GF_DOC_NO">
<span<?= $Page->DOC_NO->viewAttributes() ?>>
<?= $Page->DOC_NO->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->PRINT_DATE->Visible) { // PRINT_DATE ?>
        <td <?= $Page->PRINT_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_PRINT_DATE" class="GOOD_GF_PRINT_DATE">
<span<?= $Page->PRINT_DATE->viewAttributes() ?>>
<?= $Page->PRINT_DATE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->PRINTED_BY->Visible) { // PRINTED_BY ?>
        <td <?= $Page->PRINTED_BY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_PRINTED_BY" class="GOOD_GF_PRINTED_BY">
<span<?= $Page->PRINTED_BY->viewAttributes() ?>>
<?= $Page->PRINTED_BY->getViewValue() ?></span>
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
