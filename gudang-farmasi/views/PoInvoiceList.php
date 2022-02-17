<?php

namespace PHPMaker2021\SIMRSSQLSERVERGUDANGFARMASI;

// Page object
$PoInvoiceList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fPO_INVOICElist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fPO_INVOICElist = currentForm = new ew.Form("fPO_INVOICElist", "list");
    fPO_INVOICElist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("fPO_INVOICElist");
});
var fPO_INVOICElistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    fPO_INVOICElistsrch = currentSearchForm = new ew.Form("fPO_INVOICElistsrch");

    // Dynamic selection lists

    // Filters
    fPO_INVOICElistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fPO_INVOICElistsrch");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($Page->TotalRecords > 0 && $Page->ExportOptions->visible()) { ?>
<?php $Page->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($Page->ImportOptions->visible()) { ?>
<?php $Page->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($Page->SearchOptions->visible()) { ?>
<?php $Page->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($Page->FilterOptions->visible()) { ?>
<?php $Page->FilterOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
$Page->renderOtherOptions();
?>
<?php if ($Security->canSearch()) { ?>
<?php if (!$Page->isExport() && !$Page->CurrentAction) { ?>
<form name="fPO_INVOICElistsrch" id="fPO_INVOICElistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fPO_INVOICElistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="PO_INVOICE">
    <div class="ew-extended-search">
<div id="xsr_<?= $Page->SearchRowCount + 1 ?>" class="ew-row d-sm-flex">
    <div class="ew-quick-search input-group">
        <input type="text" name="<?= Config("TABLE_BASIC_SEARCH") ?>" id="<?= Config("TABLE_BASIC_SEARCH") ?>" class="form-control" value="<?= HtmlEncode($Page->BasicSearch->getKeyword()) ?>" placeholder="<?= HtmlEncode($Language->phrase("Search")) ?>">
        <input type="hidden" name="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" id="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" value="<?= HtmlEncode($Page->BasicSearch->getType()) ?>">
        <div class="input-group-append">
            <button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?= $Language->phrase("SearchBtn") ?></button>
            <button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false"><span id="searchtype"><?= $Page->BasicSearch->getTypeNameShort() ?></span></button>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item<?php if ($Page->BasicSearch->getType() == "") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this);"><?= $Language->phrase("QuickSearchAuto") ?></a>
                <a class="dropdown-item<?php if ($Page->BasicSearch->getType() == "=") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, '=');"><?= $Language->phrase("QuickSearchExact") ?></a>
                <a class="dropdown-item<?php if ($Page->BasicSearch->getType() == "AND") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'AND');"><?= $Language->phrase("QuickSearchAll") ?></a>
                <a class="dropdown-item<?php if ($Page->BasicSearch->getType() == "OR") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'OR');"><?= $Language->phrase("QuickSearchAny") ?></a>
            </div>
        </div>
    </div>
</div>
    </div><!-- /.ew-extended-search -->
</div><!-- /.ew-search-panel -->
</form>
<?php } ?>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<?php if ($Page->TotalRecords > 0 || $Page->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> PO_INVOICE">
<?php if (!$Page->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if (!$Page->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?= CurrentPageUrl(false) ?>">
<?= $Page->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="fPO_INVOICElist" id="fPO_INVOICElist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="PO_INVOICE">
<div id="gmp_PO_INVOICE" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_PO_INVOICElist" class="table ew-table"><!-- .ew-table -->
<thead>
    <tr class="ew-table-header">
<?php
// Header row
$Page->RowType = ROWTYPE_HEADER;

// Render list options
$Page->renderListOptions();

// Render list options (header, left)
$Page->ListOptions->render("header", "left");
?>
<?php if ($Page->ORG_UNIT_CODE->Visible) { // ORG_UNIT_CODE ?>
        <th data-name="ORG_UNIT_CODE" class="<?= $Page->ORG_UNIT_CODE->headerCellClass() ?>"><div id="elh_PO_INVOICE_ORG_UNIT_CODE" class="PO_INVOICE_ORG_UNIT_CODE"><?= $Page->renderSort($Page->ORG_UNIT_CODE) ?></div></th>
<?php } ?>
<?php if ($Page->INVOICE_ID->Visible) { // INVOICE_ID ?>
        <th data-name="INVOICE_ID" class="<?= $Page->INVOICE_ID->headerCellClass() ?>"><div id="elh_PO_INVOICE_INVOICE_ID" class="PO_INVOICE_INVOICE_ID"><?= $Page->renderSort($Page->INVOICE_ID) ?></div></th>
<?php } ?>
<?php if ($Page->INVOICE_ID2->Visible) { // INVOICE_ID2 ?>
        <th data-name="INVOICE_ID2" class="<?= $Page->INVOICE_ID2->headerCellClass() ?>"><div id="elh_PO_INVOICE_INVOICE_ID2" class="PO_INVOICE_INVOICE_ID2"><?= $Page->renderSort($Page->INVOICE_ID2) ?></div></th>
<?php } ?>
<?php if ($Page->INVOICE_DATE->Visible) { // INVOICE_DATE ?>
        <th data-name="INVOICE_DATE" class="<?= $Page->INVOICE_DATE->headerCellClass() ?>"><div id="elh_PO_INVOICE_INVOICE_DATE" class="PO_INVOICE_INVOICE_DATE"><?= $Page->renderSort($Page->INVOICE_DATE) ?></div></th>
<?php } ?>
<?php if ($Page->PO->Visible) { // PO ?>
        <th data-name="PO" class="<?= $Page->PO->headerCellClass() ?>"><div id="elh_PO_INVOICE_PO" class="PO_INVOICE_PO"><?= $Page->renderSort($Page->PO) ?></div></th>
<?php } ?>
<?php if ($Page->COMPANY_ID->Visible) { // COMPANY_ID ?>
        <th data-name="COMPANY_ID" class="<?= $Page->COMPANY_ID->headerCellClass() ?>"><div id="elh_PO_INVOICE_COMPANY_ID" class="PO_INVOICE_COMPANY_ID"><?= $Page->renderSort($Page->COMPANY_ID) ?></div></th>
<?php } ?>
<?php if ($Page->RECEIVED_DATE->Visible) { // RECEIVED_DATE ?>
        <th data-name="RECEIVED_DATE" class="<?= $Page->RECEIVED_DATE->headerCellClass() ?>"><div id="elh_PO_INVOICE_RECEIVED_DATE" class="PO_INVOICE_RECEIVED_DATE"><?= $Page->renderSort($Page->RECEIVED_DATE) ?></div></th>
<?php } ?>
<?php if ($Page->AMOUNT->Visible) { // AMOUNT ?>
        <th data-name="AMOUNT" class="<?= $Page->AMOUNT->headerCellClass() ?>"><div id="elh_PO_INVOICE_AMOUNT" class="PO_INVOICE_AMOUNT"><?= $Page->renderSort($Page->AMOUNT) ?></div></th>
<?php } ?>
<?php if ($Page->PAYMENT_DUE->Visible) { // PAYMENT_DUE ?>
        <th data-name="PAYMENT_DUE" class="<?= $Page->PAYMENT_DUE->headerCellClass() ?>"><div id="elh_PO_INVOICE_PAYMENT_DUE" class="PO_INVOICE_PAYMENT_DUE"><?= $Page->renderSort($Page->PAYMENT_DUE) ?></div></th>
<?php } ?>
<?php if ($Page->DESCRIPTION->Visible) { // DESCRIPTION ?>
        <th data-name="DESCRIPTION" class="<?= $Page->DESCRIPTION->headerCellClass() ?>"><div id="elh_PO_INVOICE_DESCRIPTION" class="PO_INVOICE_DESCRIPTION"><?= $Page->renderSort($Page->DESCRIPTION) ?></div></th>
<?php } ?>
<?php if ($Page->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
        <th data-name="MODIFIED_DATE" class="<?= $Page->MODIFIED_DATE->headerCellClass() ?>"><div id="elh_PO_INVOICE_MODIFIED_DATE" class="PO_INVOICE_MODIFIED_DATE"><?= $Page->renderSort($Page->MODIFIED_DATE) ?></div></th>
<?php } ?>
<?php if ($Page->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
        <th data-name="MODIFIED_BY" class="<?= $Page->MODIFIED_BY->headerCellClass() ?>"><div id="elh_PO_INVOICE_MODIFIED_BY" class="PO_INVOICE_MODIFIED_BY"><?= $Page->renderSort($Page->MODIFIED_BY) ?></div></th>
<?php } ?>
<?php if ($Page->RECEIVED_BY->Visible) { // RECEIVED_BY ?>
        <th data-name="RECEIVED_BY" class="<?= $Page->RECEIVED_BY->headerCellClass() ?>"><div id="elh_PO_INVOICE_RECEIVED_BY" class="PO_INVOICE_RECEIVED_BY"><?= $Page->renderSort($Page->RECEIVED_BY) ?></div></th>
<?php } ?>
<?php if ($Page->PRIORITY->Visible) { // PRIORITY ?>
        <th data-name="PRIORITY" class="<?= $Page->PRIORITY->headerCellClass() ?>"><div id="elh_PO_INVOICE_PRIORITY" class="PO_INVOICE_PRIORITY"><?= $Page->renderSort($Page->PRIORITY) ?></div></th>
<?php } ?>
<?php if ($Page->CREDIT_NOTE->Visible) { // CREDIT_NOTE ?>
        <th data-name="CREDIT_NOTE" class="<?= $Page->CREDIT_NOTE->headerCellClass() ?>"><div id="elh_PO_INVOICE_CREDIT_NOTE" class="PO_INVOICE_CREDIT_NOTE"><?= $Page->renderSort($Page->CREDIT_NOTE) ?></div></th>
<?php } ?>
<?php if ($Page->CREDIT_AMOUNT->Visible) { // CREDIT_AMOUNT ?>
        <th data-name="CREDIT_AMOUNT" class="<?= $Page->CREDIT_AMOUNT->headerCellClass() ?>"><div id="elh_PO_INVOICE_CREDIT_AMOUNT" class="PO_INVOICE_CREDIT_AMOUNT"><?= $Page->renderSort($Page->CREDIT_AMOUNT) ?></div></th>
<?php } ?>
<?php if ($Page->PPN->Visible) { // PPN ?>
        <th data-name="PPN" class="<?= $Page->PPN->headerCellClass() ?>"><div id="elh_PO_INVOICE_PPN" class="PO_INVOICE_PPN"><?= $Page->renderSort($Page->PPN) ?></div></th>
<?php } ?>
<?php if ($Page->MATERAI->Visible) { // MATERAI ?>
        <th data-name="MATERAI" class="<?= $Page->MATERAI->headerCellClass() ?>"><div id="elh_PO_INVOICE_MATERAI" class="PO_INVOICE_MATERAI"><?= $Page->renderSort($Page->MATERAI) ?></div></th>
<?php } ?>
<?php if ($Page->SENT_BY->Visible) { // SENT_BY ?>
        <th data-name="SENT_BY" class="<?= $Page->SENT_BY->headerCellClass() ?>"><div id="elh_PO_INVOICE_SENT_BY" class="PO_INVOICE_SENT_BY"><?= $Page->renderSort($Page->SENT_BY) ?></div></th>
<?php } ?>
<?php if ($Page->ACCOUNT_ID->Visible) { // ACCOUNT_ID ?>
        <th data-name="ACCOUNT_ID" class="<?= $Page->ACCOUNT_ID->headerCellClass() ?>"><div id="elh_PO_INVOICE_ACCOUNT_ID" class="PO_INVOICE_ACCOUNT_ID"><?= $Page->renderSort($Page->ACCOUNT_ID) ?></div></th>
<?php } ?>
<?php if ($Page->FINANCE_ID->Visible) { // FINANCE_ID ?>
        <th data-name="FINANCE_ID" class="<?= $Page->FINANCE_ID->headerCellClass() ?>"><div id="elh_PO_INVOICE_FINANCE_ID" class="PO_INVOICE_FINANCE_ID"><?= $Page->renderSort($Page->FINANCE_ID) ?></div></th>
<?php } ?>
<?php if ($Page->potongan->Visible) { // potongan ?>
        <th data-name="potongan" class="<?= $Page->potongan->headerCellClass() ?>"><div id="elh_PO_INVOICE_potongan" class="PO_INVOICE_potongan"><?= $Page->renderSort($Page->potongan) ?></div></th>
<?php } ?>
<?php if ($Page->RECEIVED_VALUE->Visible) { // RECEIVED_VALUE ?>
        <th data-name="RECEIVED_VALUE" class="<?= $Page->RECEIVED_VALUE->headerCellClass() ?>"><div id="elh_PO_INVOICE_RECEIVED_VALUE" class="PO_INVOICE_RECEIVED_VALUE"><?= $Page->renderSort($Page->RECEIVED_VALUE) ?></div></th>
<?php } ?>
<?php if ($Page->NO_ORDER->Visible) { // NO_ORDER ?>
        <th data-name="NO_ORDER" class="<?= $Page->NO_ORDER->headerCellClass() ?>"><div id="elh_PO_INVOICE_NO_ORDER" class="PO_INVOICE_NO_ORDER"><?= $Page->renderSort($Page->NO_ORDER) ?></div></th>
<?php } ?>
<?php if ($Page->CONTRACT_NO->Visible) { // CONTRACT_NO ?>
        <th data-name="CONTRACT_NO" class="<?= $Page->CONTRACT_NO->headerCellClass() ?>"><div id="elh_PO_INVOICE_CONTRACT_NO" class="PO_INVOICE_CONTRACT_NO"><?= $Page->renderSort($Page->CONTRACT_NO) ?></div></th>
<?php } ?>
<?php if ($Page->ORG_ID->Visible) { // ORG_ID ?>
        <th data-name="ORG_ID" class="<?= $Page->ORG_ID->headerCellClass() ?>"><div id="elh_PO_INVOICE_ORG_ID" class="PO_INVOICE_ORG_ID"><?= $Page->renderSort($Page->ORG_ID) ?></div></th>
<?php } ?>
<?php if ($Page->CLINIC_ID->Visible) { // CLINIC_ID ?>
        <th data-name="CLINIC_ID" class="<?= $Page->CLINIC_ID->headerCellClass() ?>"><div id="elh_PO_INVOICE_CLINIC_ID" class="PO_INVOICE_CLINIC_ID"><?= $Page->renderSort($Page->CLINIC_ID) ?></div></th>
<?php } ?>
<?php if ($Page->PPN_VALUE->Visible) { // PPN_VALUE ?>
        <th data-name="PPN_VALUE" class="<?= $Page->PPN_VALUE->headerCellClass() ?>"><div id="elh_PO_INVOICE_PPN_VALUE" class="PO_INVOICE_PPN_VALUE"><?= $Page->renderSort($Page->PPN_VALUE) ?></div></th>
<?php } ?>
<?php if ($Page->DISCOUNT_VALUE->Visible) { // DISCOUNT_VALUE ?>
        <th data-name="DISCOUNT_VALUE" class="<?= $Page->DISCOUNT_VALUE->headerCellClass() ?>"><div id="elh_PO_INVOICE_DISCOUNT_VALUE" class="PO_INVOICE_DISCOUNT_VALUE"><?= $Page->renderSort($Page->DISCOUNT_VALUE) ?></div></th>
<?php } ?>
<?php if ($Page->PAID_VALUE->Visible) { // PAID_VALUE ?>
        <th data-name="PAID_VALUE" class="<?= $Page->PAID_VALUE->headerCellClass() ?>"><div id="elh_PO_INVOICE_PAID_VALUE" class="PO_INVOICE_PAID_VALUE"><?= $Page->renderSort($Page->PAID_VALUE) ?></div></th>
<?php } ?>
<?php if ($Page->ISCETAK->Visible) { // ISCETAK ?>
        <th data-name="ISCETAK" class="<?= $Page->ISCETAK->headerCellClass() ?>"><div id="elh_PO_INVOICE_ISCETAK" class="PO_INVOICE_ISCETAK"><?= $Page->renderSort($Page->ISCETAK) ?></div></th>
<?php } ?>
<?php if ($Page->PRINT_DATE->Visible) { // PRINT_DATE ?>
        <th data-name="PRINT_DATE" class="<?= $Page->PRINT_DATE->headerCellClass() ?>"><div id="elh_PO_INVOICE_PRINT_DATE" class="PO_INVOICE_PRINT_DATE"><?= $Page->renderSort($Page->PRINT_DATE) ?></div></th>
<?php } ?>
<?php if ($Page->PRINTED_BY->Visible) { // PRINTED_BY ?>
        <th data-name="PRINTED_BY" class="<?= $Page->PRINTED_BY->headerCellClass() ?>"><div id="elh_PO_INVOICE_PRINTED_BY" class="PO_INVOICE_PRINTED_BY"><?= $Page->renderSort($Page->PRINTED_BY) ?></div></th>
<?php } ?>
<?php if ($Page->PRINTQ->Visible) { // PRINTQ ?>
        <th data-name="PRINTQ" class="<?= $Page->PRINTQ->headerCellClass() ?>"><div id="elh_PO_INVOICE_PRINTQ" class="PO_INVOICE_PRINTQ"><?= $Page->renderSort($Page->PRINTQ) ?></div></th>
<?php } ?>
<?php if ($Page->FAKTUR_DATE->Visible) { // FAKTUR_DATE ?>
        <th data-name="FAKTUR_DATE" class="<?= $Page->FAKTUR_DATE->headerCellClass() ?>"><div id="elh_PO_INVOICE_FAKTUR_DATE" class="PO_INVOICE_FAKTUR_DATE"><?= $Page->renderSort($Page->FAKTUR_DATE) ?></div></th>
<?php } ?>
<?php if ($Page->DISTRIBUTION_TYPE->Visible) { // DISTRIBUTION_TYPE ?>
        <th data-name="DISTRIBUTION_TYPE" class="<?= $Page->DISTRIBUTION_TYPE->headerCellClass() ?>"><div id="elh_PO_INVOICE_DISTRIBUTION_TYPE" class="PO_INVOICE_DISTRIBUTION_TYPE"><?= $Page->renderSort($Page->DISTRIBUTION_TYPE) ?></div></th>
<?php } ?>
<?php if ($Page->DISCOUNTOFF_VALUE->Visible) { // DISCOUNTOFF_VALUE ?>
        <th data-name="DISCOUNTOFF_VALUE" class="<?= $Page->DISCOUNTOFF_VALUE->headerCellClass() ?>"><div id="elh_PO_INVOICE_DISCOUNTOFF_VALUE" class="PO_INVOICE_DISCOUNTOFF_VALUE"><?= $Page->renderSort($Page->DISCOUNTOFF_VALUE) ?></div></th>
<?php } ?>
<?php if ($Page->THECOUNTER->Visible) { // THECOUNTER ?>
        <th data-name="THECOUNTER" class="<?= $Page->THECOUNTER->headerCellClass() ?>"><div id="elh_PO_INVOICE_THECOUNTER" class="PO_INVOICE_THECOUNTER"><?= $Page->renderSort($Page->THECOUNTER) ?></div></th>
<?php } ?>
<?php if ($Page->FUND_ID->Visible) { // FUND_ID ?>
        <th data-name="FUND_ID" class="<?= $Page->FUND_ID->headerCellClass() ?>"><div id="elh_PO_INVOICE_FUND_ID" class="PO_INVOICE_FUND_ID"><?= $Page->renderSort($Page->FUND_ID) ?></div></th>
<?php } ?>
<?php if ($Page->ORDER_BY->Visible) { // ORDER_BY ?>
        <th data-name="ORDER_BY" class="<?= $Page->ORDER_BY->headerCellClass() ?>"><div id="elh_PO_INVOICE_ORDER_BY" class="PO_INVOICE_ORDER_BY"><?= $Page->renderSort($Page->ORDER_BY) ?></div></th>
<?php } ?>
<?php if ($Page->ACKNOWLEDGEBY->Visible) { // ACKNOWLEDGEBY ?>
        <th data-name="ACKNOWLEDGEBY" class="<?= $Page->ACKNOWLEDGEBY->headerCellClass() ?>"><div id="elh_PO_INVOICE_ACKNOWLEDGEBY" class="PO_INVOICE_ACKNOWLEDGEBY"><?= $Page->renderSort($Page->ACKNOWLEDGEBY) ?></div></th>
<?php } ?>
<?php if ($Page->NUM->Visible) { // NUM ?>
        <th data-name="NUM" class="<?= $Page->NUM->headerCellClass() ?>"><div id="elh_PO_INVOICE_NUM" class="PO_INVOICE_NUM"><?= $Page->renderSort($Page->NUM) ?></div></th>
<?php } ?>
<?php if ($Page->ISPO->Visible) { // ISPO ?>
        <th data-name="ISPO" class="<?= $Page->ISPO->headerCellClass() ?>"><div id="elh_PO_INVOICE_ISPO" class="PO_INVOICE_ISPO"><?= $Page->renderSort($Page->ISPO) ?></div></th>
<?php } ?>
<?php if ($Page->DOCS_TYPE->Visible) { // DOCS_TYPE ?>
        <th data-name="DOCS_TYPE" class="<?= $Page->DOCS_TYPE->headerCellClass() ?>"><div id="elh_PO_INVOICE_DOCS_TYPE" class="PO_INVOICE_DOCS_TYPE"><?= $Page->renderSort($Page->DOCS_TYPE) ?></div></th>
<?php } ?>
<?php if ($Page->PO_DATE->Visible) { // PO_DATE ?>
        <th data-name="PO_DATE" class="<?= $Page->PO_DATE->headerCellClass() ?>"><div id="elh_PO_INVOICE_PO_DATE" class="PO_INVOICE_PO_DATE"><?= $Page->renderSort($Page->PO_DATE) ?></div></th>
<?php } ?>
<?php if ($Page->PO_VALUE->Visible) { // PO_VALUE ?>
        <th data-name="PO_VALUE" class="<?= $Page->PO_VALUE->headerCellClass() ?>"><div id="elh_PO_INVOICE_PO_VALUE" class="PO_INVOICE_PO_VALUE"><?= $Page->renderSort($Page->PO_VALUE) ?></div></th>
<?php } ?>
<?php
// Render list options (header, right)
$Page->ListOptions->render("header", "right");
?>
    </tr>
</thead>
<tbody>
<?php
if ($Page->ExportAll && $Page->isExport()) {
    $Page->StopRecord = $Page->TotalRecords;
} else {
    // Set the last record to display
    if ($Page->TotalRecords > $Page->StartRecord + $Page->DisplayRecords - 1) {
        $Page->StopRecord = $Page->StartRecord + $Page->DisplayRecords - 1;
    } else {
        $Page->StopRecord = $Page->TotalRecords;
    }
}
$Page->RecordCount = $Page->StartRecord - 1;
if ($Page->Recordset && !$Page->Recordset->EOF) {
    // Nothing to do
} elseif (!$Page->AllowAddDeleteRow && $Page->StopRecord == 0) {
    $Page->StopRecord = $Page->GridAddRowCount;
}

// Initialize aggregate
$Page->RowType = ROWTYPE_AGGREGATEINIT;
$Page->resetAttributes();
$Page->renderRow();
while ($Page->RecordCount < $Page->StopRecord) {
    $Page->RecordCount++;
    if ($Page->RecordCount >= $Page->StartRecord) {
        $Page->RowCount++;

        // Set up key count
        $Page->KeyCount = $Page->RowIndex;

        // Init row class and style
        $Page->resetAttributes();
        $Page->CssClass = "";
        if ($Page->isGridAdd()) {
            $Page->loadRowValues(); // Load default values
            $Page->OldKey = "";
            $Page->setKey($Page->OldKey);
        } else {
            $Page->loadRowValues($Page->Recordset); // Load row values
            if ($Page->isGridEdit()) {
                $Page->OldKey = $Page->getKey(true); // Get from CurrentValue
                $Page->setKey($Page->OldKey);
            }
        }
        $Page->RowType = ROWTYPE_VIEW; // Render view

        // Set up row id / data-rowindex
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_PO_INVOICE", "data-rowtype" => $Page->RowType]);

        // Render row
        $Page->renderRow();

        // Render list options
        $Page->renderListOptions();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount);
?>
    <?php if ($Page->ORG_UNIT_CODE->Visible) { // ORG_UNIT_CODE ?>
        <td data-name="ORG_UNIT_CODE" <?= $Page->ORG_UNIT_CODE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICE_ORG_UNIT_CODE">
<span<?= $Page->ORG_UNIT_CODE->viewAttributes() ?>>
<?= $Page->ORG_UNIT_CODE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->INVOICE_ID->Visible) { // INVOICE_ID ?>
        <td data-name="INVOICE_ID" <?= $Page->INVOICE_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICE_INVOICE_ID">
<span<?= $Page->INVOICE_ID->viewAttributes() ?>>
<?= $Page->INVOICE_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->INVOICE_ID2->Visible) { // INVOICE_ID2 ?>
        <td data-name="INVOICE_ID2" <?= $Page->INVOICE_ID2->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICE_INVOICE_ID2">
<span<?= $Page->INVOICE_ID2->viewAttributes() ?>>
<?= $Page->INVOICE_ID2->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->INVOICE_DATE->Visible) { // INVOICE_DATE ?>
        <td data-name="INVOICE_DATE" <?= $Page->INVOICE_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICE_INVOICE_DATE">
<span<?= $Page->INVOICE_DATE->viewAttributes() ?>>
<?= $Page->INVOICE_DATE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PO->Visible) { // PO ?>
        <td data-name="PO" <?= $Page->PO->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICE_PO">
<span<?= $Page->PO->viewAttributes() ?>>
<?= $Page->PO->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->COMPANY_ID->Visible) { // COMPANY_ID ?>
        <td data-name="COMPANY_ID" <?= $Page->COMPANY_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICE_COMPANY_ID">
<span<?= $Page->COMPANY_ID->viewAttributes() ?>>
<?= $Page->COMPANY_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->RECEIVED_DATE->Visible) { // RECEIVED_DATE ?>
        <td data-name="RECEIVED_DATE" <?= $Page->RECEIVED_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICE_RECEIVED_DATE">
<span<?= $Page->RECEIVED_DATE->viewAttributes() ?>>
<?= $Page->RECEIVED_DATE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->AMOUNT->Visible) { // AMOUNT ?>
        <td data-name="AMOUNT" <?= $Page->AMOUNT->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICE_AMOUNT">
<span<?= $Page->AMOUNT->viewAttributes() ?>>
<?= $Page->AMOUNT->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PAYMENT_DUE->Visible) { // PAYMENT_DUE ?>
        <td data-name="PAYMENT_DUE" <?= $Page->PAYMENT_DUE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICE_PAYMENT_DUE">
<span<?= $Page->PAYMENT_DUE->viewAttributes() ?>>
<?= $Page->PAYMENT_DUE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->DESCRIPTION->Visible) { // DESCRIPTION ?>
        <td data-name="DESCRIPTION" <?= $Page->DESCRIPTION->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICE_DESCRIPTION">
<span<?= $Page->DESCRIPTION->viewAttributes() ?>>
<?= $Page->DESCRIPTION->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
        <td data-name="MODIFIED_DATE" <?= $Page->MODIFIED_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICE_MODIFIED_DATE">
<span<?= $Page->MODIFIED_DATE->viewAttributes() ?>>
<?= $Page->MODIFIED_DATE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
        <td data-name="MODIFIED_BY" <?= $Page->MODIFIED_BY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICE_MODIFIED_BY">
<span<?= $Page->MODIFIED_BY->viewAttributes() ?>>
<?= $Page->MODIFIED_BY->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->RECEIVED_BY->Visible) { // RECEIVED_BY ?>
        <td data-name="RECEIVED_BY" <?= $Page->RECEIVED_BY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICE_RECEIVED_BY">
<span<?= $Page->RECEIVED_BY->viewAttributes() ?>>
<?= $Page->RECEIVED_BY->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PRIORITY->Visible) { // PRIORITY ?>
        <td data-name="PRIORITY" <?= $Page->PRIORITY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICE_PRIORITY">
<span<?= $Page->PRIORITY->viewAttributes() ?>>
<?= $Page->PRIORITY->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->CREDIT_NOTE->Visible) { // CREDIT_NOTE ?>
        <td data-name="CREDIT_NOTE" <?= $Page->CREDIT_NOTE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICE_CREDIT_NOTE">
<span<?= $Page->CREDIT_NOTE->viewAttributes() ?>>
<?= $Page->CREDIT_NOTE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->CREDIT_AMOUNT->Visible) { // CREDIT_AMOUNT ?>
        <td data-name="CREDIT_AMOUNT" <?= $Page->CREDIT_AMOUNT->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICE_CREDIT_AMOUNT">
<span<?= $Page->CREDIT_AMOUNT->viewAttributes() ?>>
<?= $Page->CREDIT_AMOUNT->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PPN->Visible) { // PPN ?>
        <td data-name="PPN" <?= $Page->PPN->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICE_PPN">
<span<?= $Page->PPN->viewAttributes() ?>>
<?= $Page->PPN->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->MATERAI->Visible) { // MATERAI ?>
        <td data-name="MATERAI" <?= $Page->MATERAI->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICE_MATERAI">
<span<?= $Page->MATERAI->viewAttributes() ?>>
<?= $Page->MATERAI->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->SENT_BY->Visible) { // SENT_BY ?>
        <td data-name="SENT_BY" <?= $Page->SENT_BY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICE_SENT_BY">
<span<?= $Page->SENT_BY->viewAttributes() ?>>
<?= $Page->SENT_BY->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ACCOUNT_ID->Visible) { // ACCOUNT_ID ?>
        <td data-name="ACCOUNT_ID" <?= $Page->ACCOUNT_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICE_ACCOUNT_ID">
<span<?= $Page->ACCOUNT_ID->viewAttributes() ?>>
<?= $Page->ACCOUNT_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->FINANCE_ID->Visible) { // FINANCE_ID ?>
        <td data-name="FINANCE_ID" <?= $Page->FINANCE_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICE_FINANCE_ID">
<span<?= $Page->FINANCE_ID->viewAttributes() ?>>
<?= $Page->FINANCE_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->potongan->Visible) { // potongan ?>
        <td data-name="potongan" <?= $Page->potongan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICE_potongan">
<span<?= $Page->potongan->viewAttributes() ?>>
<?= $Page->potongan->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->RECEIVED_VALUE->Visible) { // RECEIVED_VALUE ?>
        <td data-name="RECEIVED_VALUE" <?= $Page->RECEIVED_VALUE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICE_RECEIVED_VALUE">
<span<?= $Page->RECEIVED_VALUE->viewAttributes() ?>>
<?= $Page->RECEIVED_VALUE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->NO_ORDER->Visible) { // NO_ORDER ?>
        <td data-name="NO_ORDER" <?= $Page->NO_ORDER->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICE_NO_ORDER">
<span<?= $Page->NO_ORDER->viewAttributes() ?>>
<?= $Page->NO_ORDER->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->CONTRACT_NO->Visible) { // CONTRACT_NO ?>
        <td data-name="CONTRACT_NO" <?= $Page->CONTRACT_NO->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICE_CONTRACT_NO">
<span<?= $Page->CONTRACT_NO->viewAttributes() ?>>
<?= $Page->CONTRACT_NO->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ORG_ID->Visible) { // ORG_ID ?>
        <td data-name="ORG_ID" <?= $Page->ORG_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICE_ORG_ID">
<span<?= $Page->ORG_ID->viewAttributes() ?>>
<?= $Page->ORG_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->CLINIC_ID->Visible) { // CLINIC_ID ?>
        <td data-name="CLINIC_ID" <?= $Page->CLINIC_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICE_CLINIC_ID">
<span<?= $Page->CLINIC_ID->viewAttributes() ?>>
<?= $Page->CLINIC_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PPN_VALUE->Visible) { // PPN_VALUE ?>
        <td data-name="PPN_VALUE" <?= $Page->PPN_VALUE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICE_PPN_VALUE">
<span<?= $Page->PPN_VALUE->viewAttributes() ?>>
<?= $Page->PPN_VALUE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->DISCOUNT_VALUE->Visible) { // DISCOUNT_VALUE ?>
        <td data-name="DISCOUNT_VALUE" <?= $Page->DISCOUNT_VALUE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICE_DISCOUNT_VALUE">
<span<?= $Page->DISCOUNT_VALUE->viewAttributes() ?>>
<?= $Page->DISCOUNT_VALUE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PAID_VALUE->Visible) { // PAID_VALUE ?>
        <td data-name="PAID_VALUE" <?= $Page->PAID_VALUE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICE_PAID_VALUE">
<span<?= $Page->PAID_VALUE->viewAttributes() ?>>
<?= $Page->PAID_VALUE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ISCETAK->Visible) { // ISCETAK ?>
        <td data-name="ISCETAK" <?= $Page->ISCETAK->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICE_ISCETAK">
<span<?= $Page->ISCETAK->viewAttributes() ?>>
<?= $Page->ISCETAK->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PRINT_DATE->Visible) { // PRINT_DATE ?>
        <td data-name="PRINT_DATE" <?= $Page->PRINT_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICE_PRINT_DATE">
<span<?= $Page->PRINT_DATE->viewAttributes() ?>>
<?= $Page->PRINT_DATE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PRINTED_BY->Visible) { // PRINTED_BY ?>
        <td data-name="PRINTED_BY" <?= $Page->PRINTED_BY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICE_PRINTED_BY">
<span<?= $Page->PRINTED_BY->viewAttributes() ?>>
<?= $Page->PRINTED_BY->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PRINTQ->Visible) { // PRINTQ ?>
        <td data-name="PRINTQ" <?= $Page->PRINTQ->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICE_PRINTQ">
<span<?= $Page->PRINTQ->viewAttributes() ?>>
<?= $Page->PRINTQ->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->FAKTUR_DATE->Visible) { // FAKTUR_DATE ?>
        <td data-name="FAKTUR_DATE" <?= $Page->FAKTUR_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICE_FAKTUR_DATE">
<span<?= $Page->FAKTUR_DATE->viewAttributes() ?>>
<?= $Page->FAKTUR_DATE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->DISTRIBUTION_TYPE->Visible) { // DISTRIBUTION_TYPE ?>
        <td data-name="DISTRIBUTION_TYPE" <?= $Page->DISTRIBUTION_TYPE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICE_DISTRIBUTION_TYPE">
<span<?= $Page->DISTRIBUTION_TYPE->viewAttributes() ?>>
<?= $Page->DISTRIBUTION_TYPE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->DISCOUNTOFF_VALUE->Visible) { // DISCOUNTOFF_VALUE ?>
        <td data-name="DISCOUNTOFF_VALUE" <?= $Page->DISCOUNTOFF_VALUE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICE_DISCOUNTOFF_VALUE">
<span<?= $Page->DISCOUNTOFF_VALUE->viewAttributes() ?>>
<?= $Page->DISCOUNTOFF_VALUE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->THECOUNTER->Visible) { // THECOUNTER ?>
        <td data-name="THECOUNTER" <?= $Page->THECOUNTER->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICE_THECOUNTER">
<span<?= $Page->THECOUNTER->viewAttributes() ?>>
<?= $Page->THECOUNTER->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->FUND_ID->Visible) { // FUND_ID ?>
        <td data-name="FUND_ID" <?= $Page->FUND_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICE_FUND_ID">
<span<?= $Page->FUND_ID->viewAttributes() ?>>
<?= $Page->FUND_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ORDER_BY->Visible) { // ORDER_BY ?>
        <td data-name="ORDER_BY" <?= $Page->ORDER_BY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICE_ORDER_BY">
<span<?= $Page->ORDER_BY->viewAttributes() ?>>
<?= $Page->ORDER_BY->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ACKNOWLEDGEBY->Visible) { // ACKNOWLEDGEBY ?>
        <td data-name="ACKNOWLEDGEBY" <?= $Page->ACKNOWLEDGEBY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICE_ACKNOWLEDGEBY">
<span<?= $Page->ACKNOWLEDGEBY->viewAttributes() ?>>
<?= $Page->ACKNOWLEDGEBY->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->NUM->Visible) { // NUM ?>
        <td data-name="NUM" <?= $Page->NUM->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICE_NUM">
<span<?= $Page->NUM->viewAttributes() ?>>
<?= $Page->NUM->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ISPO->Visible) { // ISPO ?>
        <td data-name="ISPO" <?= $Page->ISPO->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICE_ISPO">
<span<?= $Page->ISPO->viewAttributes() ?>>
<?= $Page->ISPO->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->DOCS_TYPE->Visible) { // DOCS_TYPE ?>
        <td data-name="DOCS_TYPE" <?= $Page->DOCS_TYPE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICE_DOCS_TYPE">
<span<?= $Page->DOCS_TYPE->viewAttributes() ?>>
<?= $Page->DOCS_TYPE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PO_DATE->Visible) { // PO_DATE ?>
        <td data-name="PO_DATE" <?= $Page->PO_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICE_PO_DATE">
<span<?= $Page->PO_DATE->viewAttributes() ?>>
<?= $Page->PO_DATE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PO_VALUE->Visible) { // PO_VALUE ?>
        <td data-name="PO_VALUE" <?= $Page->PO_VALUE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICE_PO_VALUE">
<span<?= $Page->PO_VALUE->viewAttributes() ?>>
<?= $Page->PO_VALUE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
    </tr>
<?php
    }
    if (!$Page->isGridAdd()) {
        $Page->Recordset->moveNext();
    }
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
<?php if (!$Page->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</form><!-- /.ew-list-form -->
<?php
// Close recordset
if ($Page->Recordset) {
    $Page->Recordset->close();
}
?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($Page->TotalRecords == 0 && !$Page->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
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
<?php } ?>
