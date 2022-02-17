<?php

namespace PHPMaker2021\SIMRSSQLSERVERGUDANGFARMASI;

// Page object
$InvoiceList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fINVOICElist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fINVOICElist = currentForm = new ew.Form("fINVOICElist", "list");
    fINVOICElist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("fINVOICElist");
});
var fINVOICElistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    fINVOICElistsrch = currentSearchForm = new ew.Form("fINVOICElistsrch");

    // Dynamic selection lists

    // Filters
    fINVOICElistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fINVOICElistsrch");
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
<form name="fINVOICElistsrch" id="fINVOICElistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fINVOICElistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="INVOICE">
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> INVOICE">
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
<form name="fINVOICElist" id="fINVOICElist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="INVOICE">
<div id="gmp_INVOICE" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_INVOICElist" class="table ew-table"><!-- .ew-table -->
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
        <th data-name="ORG_UNIT_CODE" class="<?= $Page->ORG_UNIT_CODE->headerCellClass() ?>"><div id="elh_INVOICE_ORG_UNIT_CODE" class="INVOICE_ORG_UNIT_CODE"><?= $Page->renderSort($Page->ORG_UNIT_CODE) ?></div></th>
<?php } ?>
<?php if ($Page->INVOICE_ID->Visible) { // INVOICE_ID ?>
        <th data-name="INVOICE_ID" class="<?= $Page->INVOICE_ID->headerCellClass() ?>"><div id="elh_INVOICE_INVOICE_ID" class="INVOICE_INVOICE_ID"><?= $Page->renderSort($Page->INVOICE_ID) ?></div></th>
<?php } ?>
<?php if ($Page->INVOICE_TYPE->Visible) { // INVOICE_TYPE ?>
        <th data-name="INVOICE_TYPE" class="<?= $Page->INVOICE_TYPE->headerCellClass() ?>"><div id="elh_INVOICE_INVOICE_TYPE" class="INVOICE_INVOICE_TYPE"><?= $Page->renderSort($Page->INVOICE_TYPE) ?></div></th>
<?php } ?>
<?php if ($Page->INVOICE_NO->Visible) { // INVOICE_NO ?>
        <th data-name="INVOICE_NO" class="<?= $Page->INVOICE_NO->headerCellClass() ?>"><div id="elh_INVOICE_INVOICE_NO" class="INVOICE_INVOICE_NO"><?= $Page->renderSort($Page->INVOICE_NO) ?></div></th>
<?php } ?>
<?php if ($Page->INV_COUNTER->Visible) { // INV_COUNTER ?>
        <th data-name="INV_COUNTER" class="<?= $Page->INV_COUNTER->headerCellClass() ?>"><div id="elh_INVOICE_INV_COUNTER" class="INVOICE_INV_COUNTER"><?= $Page->renderSort($Page->INV_COUNTER) ?></div></th>
<?php } ?>
<?php if ($Page->INV_DATE->Visible) { // INV_DATE ?>
        <th data-name="INV_DATE" class="<?= $Page->INV_DATE->headerCellClass() ?>"><div id="elh_INVOICE_INV_DATE" class="INVOICE_INV_DATE"><?= $Page->renderSort($Page->INV_DATE) ?></div></th>
<?php } ?>
<?php if ($Page->INVOICE_TRANS->Visible) { // INVOICE_TRANS ?>
        <th data-name="INVOICE_TRANS" class="<?= $Page->INVOICE_TRANS->headerCellClass() ?>"><div id="elh_INVOICE_INVOICE_TRANS" class="INVOICE_INVOICE_TRANS"><?= $Page->renderSort($Page->INVOICE_TRANS) ?></div></th>
<?php } ?>
<?php if ($Page->INVOICE_DUE->Visible) { // INVOICE_DUE ?>
        <th data-name="INVOICE_DUE" class="<?= $Page->INVOICE_DUE->headerCellClass() ?>"><div id="elh_INVOICE_INVOICE_DUE" class="INVOICE_INVOICE_DUE"><?= $Page->renderSort($Page->INVOICE_DUE) ?></div></th>
<?php } ?>
<?php if ($Page->REF_TYPE->Visible) { // REF_TYPE ?>
        <th data-name="REF_TYPE" class="<?= $Page->REF_TYPE->headerCellClass() ?>"><div id="elh_INVOICE_REF_TYPE" class="INVOICE_REF_TYPE"><?= $Page->renderSort($Page->REF_TYPE) ?></div></th>
<?php } ?>
<?php if ($Page->REF_NO->Visible) { // REF_NO ?>
        <th data-name="REF_NO" class="<?= $Page->REF_NO->headerCellClass() ?>"><div id="elh_INVOICE_REF_NO" class="INVOICE_REF_NO"><?= $Page->renderSort($Page->REF_NO) ?></div></th>
<?php } ?>
<?php if ($Page->REF_NO2->Visible) { // REF_NO2 ?>
        <th data-name="REF_NO2" class="<?= $Page->REF_NO2->headerCellClass() ?>"><div id="elh_INVOICE_REF_NO2" class="INVOICE_REF_NO2"><?= $Page->renderSort($Page->REF_NO2) ?></div></th>
<?php } ?>
<?php if ($Page->REF_DATE->Visible) { // REF_DATE ?>
        <th data-name="REF_DATE" class="<?= $Page->REF_DATE->headerCellClass() ?>"><div id="elh_INVOICE_REF_DATE" class="INVOICE_REF_DATE"><?= $Page->renderSort($Page->REF_DATE) ?></div></th>
<?php } ?>
<?php if ($Page->ACCOUNT_ID->Visible) { // ACCOUNT_ID ?>
        <th data-name="ACCOUNT_ID" class="<?= $Page->ACCOUNT_ID->headerCellClass() ?>"><div id="elh_INVOICE_ACCOUNT_ID" class="INVOICE_ACCOUNT_ID"><?= $Page->renderSort($Page->ACCOUNT_ID) ?></div></th>
<?php } ?>
<?php if ($Page->YEAR_ID->Visible) { // YEAR_ID ?>
        <th data-name="YEAR_ID" class="<?= $Page->YEAR_ID->headerCellClass() ?>"><div id="elh_INVOICE_YEAR_ID" class="INVOICE_YEAR_ID"><?= $Page->renderSort($Page->YEAR_ID) ?></div></th>
<?php } ?>
<?php if ($Page->ORG_ID->Visible) { // ORG_ID ?>
        <th data-name="ORG_ID" class="<?= $Page->ORG_ID->headerCellClass() ?>"><div id="elh_INVOICE_ORG_ID" class="INVOICE_ORG_ID"><?= $Page->renderSort($Page->ORG_ID) ?></div></th>
<?php } ?>
<?php if ($Page->PROGRAM_ID->Visible) { // PROGRAM_ID ?>
        <th data-name="PROGRAM_ID" class="<?= $Page->PROGRAM_ID->headerCellClass() ?>"><div id="elh_INVOICE_PROGRAM_ID" class="INVOICE_PROGRAM_ID"><?= $Page->renderSort($Page->PROGRAM_ID) ?></div></th>
<?php } ?>
<?php if ($Page->PROGRAMS->Visible) { // PROGRAMS ?>
        <th data-name="PROGRAMS" class="<?= $Page->PROGRAMS->headerCellClass() ?>"><div id="elh_INVOICE_PROGRAMS" class="INVOICE_PROGRAMS"><?= $Page->renderSort($Page->PROGRAMS) ?></div></th>
<?php } ?>
<?php if ($Page->PACTIVITY_ID->Visible) { // PACTIVITY_ID ?>
        <th data-name="PACTIVITY_ID" class="<?= $Page->PACTIVITY_ID->headerCellClass() ?>"><div id="elh_INVOICE_PACTIVITY_ID" class="INVOICE_PACTIVITY_ID"><?= $Page->renderSort($Page->PACTIVITY_ID) ?></div></th>
<?php } ?>
<?php if ($Page->ACTIVITY_ID->Visible) { // ACTIVITY_ID ?>
        <th data-name="ACTIVITY_ID" class="<?= $Page->ACTIVITY_ID->headerCellClass() ?>"><div id="elh_INVOICE_ACTIVITY_ID" class="INVOICE_ACTIVITY_ID"><?= $Page->renderSort($Page->ACTIVITY_ID) ?></div></th>
<?php } ?>
<?php if ($Page->ACTIVITY_NAME->Visible) { // ACTIVITY_NAME ?>
        <th data-name="ACTIVITY_NAME" class="<?= $Page->ACTIVITY_NAME->headerCellClass() ?>"><div id="elh_INVOICE_ACTIVITY_NAME" class="INVOICE_ACTIVITY_NAME"><?= $Page->renderSort($Page->ACTIVITY_NAME) ?></div></th>
<?php } ?>
<?php if ($Page->KEPERLUAN->Visible) { // KEPERLUAN ?>
        <th data-name="KEPERLUAN" class="<?= $Page->KEPERLUAN->headerCellClass() ?>"><div id="elh_INVOICE_KEPERLUAN" class="INVOICE_KEPERLUAN"><?= $Page->renderSort($Page->KEPERLUAN) ?></div></th>
<?php } ?>
<?php if ($Page->PPTK->Visible) { // PPTK ?>
        <th data-name="PPTK" class="<?= $Page->PPTK->headerCellClass() ?>"><div id="elh_INVOICE_PPTK" class="INVOICE_PPTK"><?= $Page->renderSort($Page->PPTK) ?></div></th>
<?php } ?>
<?php if ($Page->PPTK_NAME->Visible) { // PPTK_NAME ?>
        <th data-name="PPTK_NAME" class="<?= $Page->PPTK_NAME->headerCellClass() ?>"><div id="elh_INVOICE_PPTK_NAME" class="INVOICE_PPTK_NAME"><?= $Page->renderSort($Page->PPTK_NAME) ?></div></th>
<?php } ?>
<?php if ($Page->COMPANY_ID->Visible) { // COMPANY_ID ?>
        <th data-name="COMPANY_ID" class="<?= $Page->COMPANY_ID->headerCellClass() ?>"><div id="elh_INVOICE_COMPANY_ID" class="INVOICE_COMPANY_ID"><?= $Page->renderSort($Page->COMPANY_ID) ?></div></th>
<?php } ?>
<?php if ($Page->COMPANY_TO->Visible) { // COMPANY_TO ?>
        <th data-name="COMPANY_TO" class="<?= $Page->COMPANY_TO->headerCellClass() ?>"><div id="elh_INVOICE_COMPANY_TO" class="INVOICE_COMPANY_TO"><?= $Page->renderSort($Page->COMPANY_TO) ?></div></th>
<?php } ?>
<?php if ($Page->COMPANY_TYPE->Visible) { // COMPANY_TYPE ?>
        <th data-name="COMPANY_TYPE" class="<?= $Page->COMPANY_TYPE->headerCellClass() ?>"><div id="elh_INVOICE_COMPANY_TYPE" class="INVOICE_COMPANY_TYPE"><?= $Page->renderSort($Page->COMPANY_TYPE) ?></div></th>
<?php } ?>
<?php if ($Page->COMPANY->Visible) { // COMPANY ?>
        <th data-name="COMPANY" class="<?= $Page->COMPANY->headerCellClass() ?>"><div id="elh_INVOICE_COMPANY" class="INVOICE_COMPANY"><?= $Page->renderSort($Page->COMPANY) ?></div></th>
<?php } ?>
<?php if ($Page->COMPANY_CHIEF->Visible) { // COMPANY_CHIEF ?>
        <th data-name="COMPANY_CHIEF" class="<?= $Page->COMPANY_CHIEF->headerCellClass() ?>"><div id="elh_INVOICE_COMPANY_CHIEF" class="INVOICE_COMPANY_CHIEF"><?= $Page->renderSort($Page->COMPANY_CHIEF) ?></div></th>
<?php } ?>
<?php if ($Page->COMPANY_INFO->Visible) { // COMPANY_INFO ?>
        <th data-name="COMPANY_INFO" class="<?= $Page->COMPANY_INFO->headerCellClass() ?>"><div id="elh_INVOICE_COMPANY_INFO" class="INVOICE_COMPANY_INFO"><?= $Page->renderSort($Page->COMPANY_INFO) ?></div></th>
<?php } ?>
<?php if ($Page->CONTRACT_NO->Visible) { // CONTRACT_NO ?>
        <th data-name="CONTRACT_NO" class="<?= $Page->CONTRACT_NO->headerCellClass() ?>"><div id="elh_INVOICE_CONTRACT_NO" class="INVOICE_CONTRACT_NO"><?= $Page->renderSort($Page->CONTRACT_NO) ?></div></th>
<?php } ?>
<?php if ($Page->NPWP->Visible) { // NPWP ?>
        <th data-name="NPWP" class="<?= $Page->NPWP->headerCellClass() ?>"><div id="elh_INVOICE_NPWP" class="INVOICE_NPWP"><?= $Page->renderSort($Page->NPWP) ?></div></th>
<?php } ?>
<?php if ($Page->COMPANY_BANK->Visible) { // COMPANY_BANK ?>
        <th data-name="COMPANY_BANK" class="<?= $Page->COMPANY_BANK->headerCellClass() ?>"><div id="elh_INVOICE_COMPANY_BANK" class="INVOICE_COMPANY_BANK"><?= $Page->renderSort($Page->COMPANY_BANK) ?></div></th>
<?php } ?>
<?php if ($Page->COMPANY_ACCOUNT->Visible) { // COMPANY_ACCOUNT ?>
        <th data-name="COMPANY_ACCOUNT" class="<?= $Page->COMPANY_ACCOUNT->headerCellClass() ?>"><div id="elh_INVOICE_COMPANY_ACCOUNT" class="INVOICE_COMPANY_ACCOUNT"><?= $Page->renderSort($Page->COMPANY_ACCOUNT) ?></div></th>
<?php } ?>
<?php if ($Page->PAGU->Visible) { // PAGU ?>
        <th data-name="PAGU" class="<?= $Page->PAGU->headerCellClass() ?>"><div id="elh_INVOICE_PAGU" class="INVOICE_PAGU"><?= $Page->renderSort($Page->PAGU) ?></div></th>
<?php } ?>
<?php if ($Page->PAGU_REALISASI->Visible) { // PAGU_REALISASI ?>
        <th data-name="PAGU_REALISASI" class="<?= $Page->PAGU_REALISASI->headerCellClass() ?>"><div id="elh_INVOICE_PAGU_REALISASI" class="INVOICE_PAGU_REALISASI"><?= $Page->renderSort($Page->PAGU_REALISASI) ?></div></th>
<?php } ?>
<?php if ($Page->AMOUNT->Visible) { // AMOUNT ?>
        <th data-name="AMOUNT" class="<?= $Page->AMOUNT->headerCellClass() ?>"><div id="elh_INVOICE_AMOUNT" class="INVOICE_AMOUNT"><?= $Page->renderSort($Page->AMOUNT) ?></div></th>
<?php } ?>
<?php if ($Page->AMOUNT_PAID->Visible) { // AMOUNT_PAID ?>
        <th data-name="AMOUNT_PAID" class="<?= $Page->AMOUNT_PAID->headerCellClass() ?>"><div id="elh_INVOICE_AMOUNT_PAID" class="INVOICE_AMOUNT_PAID"><?= $Page->renderSort($Page->AMOUNT_PAID) ?></div></th>
<?php } ?>
<?php if ($Page->PAYMENT_INSTRUCTIONS->Visible) { // PAYMENT_INSTRUCTIONS ?>
        <th data-name="PAYMENT_INSTRUCTIONS" class="<?= $Page->PAYMENT_INSTRUCTIONS->headerCellClass() ?>"><div id="elh_INVOICE_PAYMENT_INSTRUCTIONS" class="INVOICE_PAYMENT_INSTRUCTIONS"><?= $Page->renderSort($Page->PAYMENT_INSTRUCTIONS) ?></div></th>
<?php } ?>
<?php if ($Page->ISAPPROVED->Visible) { // ISAPPROVED ?>
        <th data-name="ISAPPROVED" class="<?= $Page->ISAPPROVED->headerCellClass() ?>"><div id="elh_INVOICE_ISAPPROVED" class="INVOICE_ISAPPROVED"><?= $Page->renderSort($Page->ISAPPROVED) ?></div></th>
<?php } ?>
<?php if ($Page->APPROVED_BY->Visible) { // APPROVED_BY ?>
        <th data-name="APPROVED_BY" class="<?= $Page->APPROVED_BY->headerCellClass() ?>"><div id="elh_INVOICE_APPROVED_BY" class="INVOICE_APPROVED_BY"><?= $Page->renderSort($Page->APPROVED_BY) ?></div></th>
<?php } ?>
<?php if ($Page->APPROVED_DATE->Visible) { // APPROVED_DATE ?>
        <th data-name="APPROVED_DATE" class="<?= $Page->APPROVED_DATE->headerCellClass() ?>"><div id="elh_INVOICE_APPROVED_DATE" class="INVOICE_APPROVED_DATE"><?= $Page->renderSort($Page->APPROVED_DATE) ?></div></th>
<?php } ?>
<?php if ($Page->ISCETAK->Visible) { // ISCETAK ?>
        <th data-name="ISCETAK" class="<?= $Page->ISCETAK->headerCellClass() ?>"><div id="elh_INVOICE_ISCETAK" class="INVOICE_ISCETAK"><?= $Page->renderSort($Page->ISCETAK) ?></div></th>
<?php } ?>
<?php if ($Page->PRINTQ->Visible) { // PRINTQ ?>
        <th data-name="PRINTQ" class="<?= $Page->PRINTQ->headerCellClass() ?>"><div id="elh_INVOICE_PRINTQ" class="INVOICE_PRINTQ"><?= $Page->renderSort($Page->PRINTQ) ?></div></th>
<?php } ?>
<?php if ($Page->PRINT_DATE->Visible) { // PRINT_DATE ?>
        <th data-name="PRINT_DATE" class="<?= $Page->PRINT_DATE->headerCellClass() ?>"><div id="elh_INVOICE_PRINT_DATE" class="INVOICE_PRINT_DATE"><?= $Page->renderSort($Page->PRINT_DATE) ?></div></th>
<?php } ?>
<?php if ($Page->PRINTED_BY->Visible) { // PRINTED_BY ?>
        <th data-name="PRINTED_BY" class="<?= $Page->PRINTED_BY->headerCellClass() ?>"><div id="elh_INVOICE_PRINTED_BY" class="INVOICE_PRINTED_BY"><?= $Page->renderSort($Page->PRINTED_BY) ?></div></th>
<?php } ?>
<?php if ($Page->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
        <th data-name="MODIFIED_DATE" class="<?= $Page->MODIFIED_DATE->headerCellClass() ?>"><div id="elh_INVOICE_MODIFIED_DATE" class="INVOICE_MODIFIED_DATE"><?= $Page->renderSort($Page->MODIFIED_DATE) ?></div></th>
<?php } ?>
<?php if ($Page->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
        <th data-name="MODIFIED_BY" class="<?= $Page->MODIFIED_BY->headerCellClass() ?>"><div id="elh_INVOICE_MODIFIED_BY" class="INVOICE_MODIFIED_BY"><?= $Page->renderSort($Page->MODIFIED_BY) ?></div></th>
<?php } ?>
<?php if ($Page->PPTK_TITLE->Visible) { // PPTK_TITLE ?>
        <th data-name="PPTK_TITLE" class="<?= $Page->PPTK_TITLE->headerCellClass() ?>"><div id="elh_INVOICE_PPTK_TITLE" class="INVOICE_PPTK_TITLE"><?= $Page->renderSort($Page->PPTK_TITLE) ?></div></th>
<?php } ?>
<?php if ($Page->APPROVED_ID->Visible) { // APPROVED_ID ?>
        <th data-name="APPROVED_ID" class="<?= $Page->APPROVED_ID->headerCellClass() ?>"><div id="elh_INVOICE_APPROVED_ID" class="INVOICE_APPROVED_ID"><?= $Page->renderSort($Page->APPROVED_ID) ?></div></th>
<?php } ?>
<?php if ($Page->APPROVED_TITLE->Visible) { // APPROVED_TITLE ?>
        <th data-name="APPROVED_TITLE" class="<?= $Page->APPROVED_TITLE->headerCellClass() ?>"><div id="elh_INVOICE_APPROVED_TITLE" class="INVOICE_APPROVED_TITLE"><?= $Page->renderSort($Page->APPROVED_TITLE) ?></div></th>
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_INVOICE", "data-rowtype" => $Page->RowType]);

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
<span id="el<?= $Page->RowCount ?>_INVOICE_ORG_UNIT_CODE">
<span<?= $Page->ORG_UNIT_CODE->viewAttributes() ?>>
<?= $Page->ORG_UNIT_CODE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->INVOICE_ID->Visible) { // INVOICE_ID ?>
        <td data-name="INVOICE_ID" <?= $Page->INVOICE_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_INVOICE_ID">
<span<?= $Page->INVOICE_ID->viewAttributes() ?>>
<?= $Page->INVOICE_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->INVOICE_TYPE->Visible) { // INVOICE_TYPE ?>
        <td data-name="INVOICE_TYPE" <?= $Page->INVOICE_TYPE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_INVOICE_TYPE">
<span<?= $Page->INVOICE_TYPE->viewAttributes() ?>>
<?= $Page->INVOICE_TYPE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->INVOICE_NO->Visible) { // INVOICE_NO ?>
        <td data-name="INVOICE_NO" <?= $Page->INVOICE_NO->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_INVOICE_NO">
<span<?= $Page->INVOICE_NO->viewAttributes() ?>>
<?= $Page->INVOICE_NO->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->INV_COUNTER->Visible) { // INV_COUNTER ?>
        <td data-name="INV_COUNTER" <?= $Page->INV_COUNTER->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_INV_COUNTER">
<span<?= $Page->INV_COUNTER->viewAttributes() ?>>
<?= $Page->INV_COUNTER->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->INV_DATE->Visible) { // INV_DATE ?>
        <td data-name="INV_DATE" <?= $Page->INV_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_INV_DATE">
<span<?= $Page->INV_DATE->viewAttributes() ?>>
<?= $Page->INV_DATE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->INVOICE_TRANS->Visible) { // INVOICE_TRANS ?>
        <td data-name="INVOICE_TRANS" <?= $Page->INVOICE_TRANS->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_INVOICE_TRANS">
<span<?= $Page->INVOICE_TRANS->viewAttributes() ?>>
<?= $Page->INVOICE_TRANS->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->INVOICE_DUE->Visible) { // INVOICE_DUE ?>
        <td data-name="INVOICE_DUE" <?= $Page->INVOICE_DUE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_INVOICE_DUE">
<span<?= $Page->INVOICE_DUE->viewAttributes() ?>>
<?= $Page->INVOICE_DUE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->REF_TYPE->Visible) { // REF_TYPE ?>
        <td data-name="REF_TYPE" <?= $Page->REF_TYPE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_REF_TYPE">
<span<?= $Page->REF_TYPE->viewAttributes() ?>>
<?= $Page->REF_TYPE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->REF_NO->Visible) { // REF_NO ?>
        <td data-name="REF_NO" <?= $Page->REF_NO->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_REF_NO">
<span<?= $Page->REF_NO->viewAttributes() ?>>
<?= $Page->REF_NO->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->REF_NO2->Visible) { // REF_NO2 ?>
        <td data-name="REF_NO2" <?= $Page->REF_NO2->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_REF_NO2">
<span<?= $Page->REF_NO2->viewAttributes() ?>>
<?= $Page->REF_NO2->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->REF_DATE->Visible) { // REF_DATE ?>
        <td data-name="REF_DATE" <?= $Page->REF_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_REF_DATE">
<span<?= $Page->REF_DATE->viewAttributes() ?>>
<?= $Page->REF_DATE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ACCOUNT_ID->Visible) { // ACCOUNT_ID ?>
        <td data-name="ACCOUNT_ID" <?= $Page->ACCOUNT_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_ACCOUNT_ID">
<span<?= $Page->ACCOUNT_ID->viewAttributes() ?>>
<?= $Page->ACCOUNT_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->YEAR_ID->Visible) { // YEAR_ID ?>
        <td data-name="YEAR_ID" <?= $Page->YEAR_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_YEAR_ID">
<span<?= $Page->YEAR_ID->viewAttributes() ?>>
<?= $Page->YEAR_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ORG_ID->Visible) { // ORG_ID ?>
        <td data-name="ORG_ID" <?= $Page->ORG_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_ORG_ID">
<span<?= $Page->ORG_ID->viewAttributes() ?>>
<?= $Page->ORG_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PROGRAM_ID->Visible) { // PROGRAM_ID ?>
        <td data-name="PROGRAM_ID" <?= $Page->PROGRAM_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_PROGRAM_ID">
<span<?= $Page->PROGRAM_ID->viewAttributes() ?>>
<?= $Page->PROGRAM_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PROGRAMS->Visible) { // PROGRAMS ?>
        <td data-name="PROGRAMS" <?= $Page->PROGRAMS->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_PROGRAMS">
<span<?= $Page->PROGRAMS->viewAttributes() ?>>
<?= $Page->PROGRAMS->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PACTIVITY_ID->Visible) { // PACTIVITY_ID ?>
        <td data-name="PACTIVITY_ID" <?= $Page->PACTIVITY_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_PACTIVITY_ID">
<span<?= $Page->PACTIVITY_ID->viewAttributes() ?>>
<?= $Page->PACTIVITY_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ACTIVITY_ID->Visible) { // ACTIVITY_ID ?>
        <td data-name="ACTIVITY_ID" <?= $Page->ACTIVITY_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_ACTIVITY_ID">
<span<?= $Page->ACTIVITY_ID->viewAttributes() ?>>
<?= $Page->ACTIVITY_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ACTIVITY_NAME->Visible) { // ACTIVITY_NAME ?>
        <td data-name="ACTIVITY_NAME" <?= $Page->ACTIVITY_NAME->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_ACTIVITY_NAME">
<span<?= $Page->ACTIVITY_NAME->viewAttributes() ?>>
<?= $Page->ACTIVITY_NAME->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->KEPERLUAN->Visible) { // KEPERLUAN ?>
        <td data-name="KEPERLUAN" <?= $Page->KEPERLUAN->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_KEPERLUAN">
<span<?= $Page->KEPERLUAN->viewAttributes() ?>>
<?= $Page->KEPERLUAN->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PPTK->Visible) { // PPTK ?>
        <td data-name="PPTK" <?= $Page->PPTK->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_PPTK">
<span<?= $Page->PPTK->viewAttributes() ?>>
<?= $Page->PPTK->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PPTK_NAME->Visible) { // PPTK_NAME ?>
        <td data-name="PPTK_NAME" <?= $Page->PPTK_NAME->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_PPTK_NAME">
<span<?= $Page->PPTK_NAME->viewAttributes() ?>>
<?= $Page->PPTK_NAME->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->COMPANY_ID->Visible) { // COMPANY_ID ?>
        <td data-name="COMPANY_ID" <?= $Page->COMPANY_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_COMPANY_ID">
<span<?= $Page->COMPANY_ID->viewAttributes() ?>>
<?= $Page->COMPANY_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->COMPANY_TO->Visible) { // COMPANY_TO ?>
        <td data-name="COMPANY_TO" <?= $Page->COMPANY_TO->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_COMPANY_TO">
<span<?= $Page->COMPANY_TO->viewAttributes() ?>>
<?= $Page->COMPANY_TO->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->COMPANY_TYPE->Visible) { // COMPANY_TYPE ?>
        <td data-name="COMPANY_TYPE" <?= $Page->COMPANY_TYPE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_COMPANY_TYPE">
<span<?= $Page->COMPANY_TYPE->viewAttributes() ?>>
<?= $Page->COMPANY_TYPE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->COMPANY->Visible) { // COMPANY ?>
        <td data-name="COMPANY" <?= $Page->COMPANY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_COMPANY">
<span<?= $Page->COMPANY->viewAttributes() ?>>
<?= $Page->COMPANY->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->COMPANY_CHIEF->Visible) { // COMPANY_CHIEF ?>
        <td data-name="COMPANY_CHIEF" <?= $Page->COMPANY_CHIEF->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_COMPANY_CHIEF">
<span<?= $Page->COMPANY_CHIEF->viewAttributes() ?>>
<?= $Page->COMPANY_CHIEF->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->COMPANY_INFO->Visible) { // COMPANY_INFO ?>
        <td data-name="COMPANY_INFO" <?= $Page->COMPANY_INFO->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_COMPANY_INFO">
<span<?= $Page->COMPANY_INFO->viewAttributes() ?>>
<?= $Page->COMPANY_INFO->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->CONTRACT_NO->Visible) { // CONTRACT_NO ?>
        <td data-name="CONTRACT_NO" <?= $Page->CONTRACT_NO->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_CONTRACT_NO">
<span<?= $Page->CONTRACT_NO->viewAttributes() ?>>
<?= $Page->CONTRACT_NO->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->NPWP->Visible) { // NPWP ?>
        <td data-name="NPWP" <?= $Page->NPWP->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_NPWP">
<span<?= $Page->NPWP->viewAttributes() ?>>
<?= $Page->NPWP->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->COMPANY_BANK->Visible) { // COMPANY_BANK ?>
        <td data-name="COMPANY_BANK" <?= $Page->COMPANY_BANK->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_COMPANY_BANK">
<span<?= $Page->COMPANY_BANK->viewAttributes() ?>>
<?= $Page->COMPANY_BANK->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->COMPANY_ACCOUNT->Visible) { // COMPANY_ACCOUNT ?>
        <td data-name="COMPANY_ACCOUNT" <?= $Page->COMPANY_ACCOUNT->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_COMPANY_ACCOUNT">
<span<?= $Page->COMPANY_ACCOUNT->viewAttributes() ?>>
<?= $Page->COMPANY_ACCOUNT->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PAGU->Visible) { // PAGU ?>
        <td data-name="PAGU" <?= $Page->PAGU->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_PAGU">
<span<?= $Page->PAGU->viewAttributes() ?>>
<?= $Page->PAGU->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PAGU_REALISASI->Visible) { // PAGU_REALISASI ?>
        <td data-name="PAGU_REALISASI" <?= $Page->PAGU_REALISASI->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_PAGU_REALISASI">
<span<?= $Page->PAGU_REALISASI->viewAttributes() ?>>
<?= $Page->PAGU_REALISASI->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->AMOUNT->Visible) { // AMOUNT ?>
        <td data-name="AMOUNT" <?= $Page->AMOUNT->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_AMOUNT">
<span<?= $Page->AMOUNT->viewAttributes() ?>>
<?= $Page->AMOUNT->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->AMOUNT_PAID->Visible) { // AMOUNT_PAID ?>
        <td data-name="AMOUNT_PAID" <?= $Page->AMOUNT_PAID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_AMOUNT_PAID">
<span<?= $Page->AMOUNT_PAID->viewAttributes() ?>>
<?= $Page->AMOUNT_PAID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PAYMENT_INSTRUCTIONS->Visible) { // PAYMENT_INSTRUCTIONS ?>
        <td data-name="PAYMENT_INSTRUCTIONS" <?= $Page->PAYMENT_INSTRUCTIONS->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_PAYMENT_INSTRUCTIONS">
<span<?= $Page->PAYMENT_INSTRUCTIONS->viewAttributes() ?>>
<?= $Page->PAYMENT_INSTRUCTIONS->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ISAPPROVED->Visible) { // ISAPPROVED ?>
        <td data-name="ISAPPROVED" <?= $Page->ISAPPROVED->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_ISAPPROVED">
<span<?= $Page->ISAPPROVED->viewAttributes() ?>>
<?= $Page->ISAPPROVED->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->APPROVED_BY->Visible) { // APPROVED_BY ?>
        <td data-name="APPROVED_BY" <?= $Page->APPROVED_BY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_APPROVED_BY">
<span<?= $Page->APPROVED_BY->viewAttributes() ?>>
<?= $Page->APPROVED_BY->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->APPROVED_DATE->Visible) { // APPROVED_DATE ?>
        <td data-name="APPROVED_DATE" <?= $Page->APPROVED_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_APPROVED_DATE">
<span<?= $Page->APPROVED_DATE->viewAttributes() ?>>
<?= $Page->APPROVED_DATE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ISCETAK->Visible) { // ISCETAK ?>
        <td data-name="ISCETAK" <?= $Page->ISCETAK->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_ISCETAK">
<span<?= $Page->ISCETAK->viewAttributes() ?>>
<?= $Page->ISCETAK->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PRINTQ->Visible) { // PRINTQ ?>
        <td data-name="PRINTQ" <?= $Page->PRINTQ->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_PRINTQ">
<span<?= $Page->PRINTQ->viewAttributes() ?>>
<?= $Page->PRINTQ->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PRINT_DATE->Visible) { // PRINT_DATE ?>
        <td data-name="PRINT_DATE" <?= $Page->PRINT_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_PRINT_DATE">
<span<?= $Page->PRINT_DATE->viewAttributes() ?>>
<?= $Page->PRINT_DATE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PRINTED_BY->Visible) { // PRINTED_BY ?>
        <td data-name="PRINTED_BY" <?= $Page->PRINTED_BY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_PRINTED_BY">
<span<?= $Page->PRINTED_BY->viewAttributes() ?>>
<?= $Page->PRINTED_BY->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
        <td data-name="MODIFIED_DATE" <?= $Page->MODIFIED_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_MODIFIED_DATE">
<span<?= $Page->MODIFIED_DATE->viewAttributes() ?>>
<?= $Page->MODIFIED_DATE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
        <td data-name="MODIFIED_BY" <?= $Page->MODIFIED_BY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_MODIFIED_BY">
<span<?= $Page->MODIFIED_BY->viewAttributes() ?>>
<?= $Page->MODIFIED_BY->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PPTK_TITLE->Visible) { // PPTK_TITLE ?>
        <td data-name="PPTK_TITLE" <?= $Page->PPTK_TITLE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_PPTK_TITLE">
<span<?= $Page->PPTK_TITLE->viewAttributes() ?>>
<?= $Page->PPTK_TITLE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->APPROVED_ID->Visible) { // APPROVED_ID ?>
        <td data-name="APPROVED_ID" <?= $Page->APPROVED_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_APPROVED_ID">
<span<?= $Page->APPROVED_ID->viewAttributes() ?>>
<?= $Page->APPROVED_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->APPROVED_TITLE->Visible) { // APPROVED_TITLE ?>
        <td data-name="APPROVED_TITLE" <?= $Page->APPROVED_TITLE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_APPROVED_TITLE">
<span<?= $Page->APPROVED_TITLE->viewAttributes() ?>>
<?= $Page->APPROVED_TITLE->getViewValue() ?></span>
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
    ew.addEventHandlers("INVOICE");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
