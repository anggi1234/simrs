<?php

namespace PHPMaker2021\SIMRSSQLSERVERGUDANGFARMASI;

// Page object
$PoVerificationList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fPO_VERIFICATIONlist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fPO_VERIFICATIONlist = currentForm = new ew.Form("fPO_VERIFICATIONlist", "list");
    fPO_VERIFICATIONlist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("fPO_VERIFICATIONlist");
});
var fPO_VERIFICATIONlistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    fPO_VERIFICATIONlistsrch = currentSearchForm = new ew.Form("fPO_VERIFICATIONlistsrch");

    // Dynamic selection lists

    // Filters
    fPO_VERIFICATIONlistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fPO_VERIFICATIONlistsrch");
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
<form name="fPO_VERIFICATIONlistsrch" id="fPO_VERIFICATIONlistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fPO_VERIFICATIONlistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="PO_VERIFICATION">
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> PO_VERIFICATION">
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
<form name="fPO_VERIFICATIONlist" id="fPO_VERIFICATIONlist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="PO_VERIFICATION">
<div id="gmp_PO_VERIFICATION" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_PO_VERIFICATIONlist" class="table ew-table"><!-- .ew-table -->
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
<?php if ($Page->PO->Visible) { // PO ?>
        <th data-name="PO" class="<?= $Page->PO->headerCellClass() ?>"><div id="elh_PO_VERIFICATION_PO" class="PO_VERIFICATION_PO"><?= $Page->renderSort($Page->PO) ?></div></th>
<?php } ?>
<?php if ($Page->ISVALID->Visible) { // ISVALID ?>
        <th data-name="ISVALID" class="<?= $Page->ISVALID->headerCellClass() ?>"><div id="elh_PO_VERIFICATION_ISVALID" class="PO_VERIFICATION_ISVALID"><?= $Page->renderSort($Page->ISVALID) ?></div></th>
<?php } ?>
<?php if ($Page->VERIFIED_DATE->Visible) { // VERIFIED_DATE ?>
        <th data-name="VERIFIED_DATE" class="<?= $Page->VERIFIED_DATE->headerCellClass() ?>"><div id="elh_PO_VERIFICATION_VERIFIED_DATE" class="PO_VERIFICATION_VERIFIED_DATE"><?= $Page->renderSort($Page->VERIFIED_DATE) ?></div></th>
<?php } ?>
<?php if ($Page->VERIFIED_BY->Visible) { // VERIFIED_BY ?>
        <th data-name="VERIFIED_BY" class="<?= $Page->VERIFIED_BY->headerCellClass() ?>"><div id="elh_PO_VERIFICATION_VERIFIED_BY" class="PO_VERIFICATION_VERIFIED_BY"><?= $Page->renderSort($Page->VERIFIED_BY) ?></div></th>
<?php } ?>
<?php if ($Page->VERIFICATION_DESC->Visible) { // VERIFICATION_DESC ?>
        <th data-name="VERIFICATION_DESC" class="<?= $Page->VERIFICATION_DESC->headerCellClass() ?>"><div id="elh_PO_VERIFICATION_VERIFICATION_DESC" class="PO_VERIFICATION_VERIFICATION_DESC"><?= $Page->renderSort($Page->VERIFICATION_DESC) ?></div></th>
<?php } ?>
<?php if ($Page->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
        <th data-name="MODIFIED_DATE" class="<?= $Page->MODIFIED_DATE->headerCellClass() ?>"><div id="elh_PO_VERIFICATION_MODIFIED_DATE" class="PO_VERIFICATION_MODIFIED_DATE"><?= $Page->renderSort($Page->MODIFIED_DATE) ?></div></th>
<?php } ?>
<?php if ($Page->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
        <th data-name="MODIFIED_BY" class="<?= $Page->MODIFIED_BY->headerCellClass() ?>"><div id="elh_PO_VERIFICATION_MODIFIED_BY" class="PO_VERIFICATION_MODIFIED_BY"><?= $Page->renderSort($Page->MODIFIED_BY) ?></div></th>
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_PO_VERIFICATION", "data-rowtype" => $Page->RowType]);

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
    <?php if ($Page->PO->Visible) { // PO ?>
        <td data-name="PO" <?= $Page->PO->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_VERIFICATION_PO">
<span<?= $Page->PO->viewAttributes() ?>>
<?= $Page->PO->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ISVALID->Visible) { // ISVALID ?>
        <td data-name="ISVALID" <?= $Page->ISVALID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_VERIFICATION_ISVALID">
<span<?= $Page->ISVALID->viewAttributes() ?>>
<?= $Page->ISVALID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->VERIFIED_DATE->Visible) { // VERIFIED_DATE ?>
        <td data-name="VERIFIED_DATE" <?= $Page->VERIFIED_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_VERIFICATION_VERIFIED_DATE">
<span<?= $Page->VERIFIED_DATE->viewAttributes() ?>>
<?= $Page->VERIFIED_DATE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->VERIFIED_BY->Visible) { // VERIFIED_BY ?>
        <td data-name="VERIFIED_BY" <?= $Page->VERIFIED_BY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_VERIFICATION_VERIFIED_BY">
<span<?= $Page->VERIFIED_BY->viewAttributes() ?>>
<?= $Page->VERIFIED_BY->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->VERIFICATION_DESC->Visible) { // VERIFICATION_DESC ?>
        <td data-name="VERIFICATION_DESC" <?= $Page->VERIFICATION_DESC->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_VERIFICATION_VERIFICATION_DESC">
<span<?= $Page->VERIFICATION_DESC->viewAttributes() ?>>
<?= $Page->VERIFICATION_DESC->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
        <td data-name="MODIFIED_DATE" <?= $Page->MODIFIED_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_VERIFICATION_MODIFIED_DATE">
<span<?= $Page->MODIFIED_DATE->viewAttributes() ?>>
<?= $Page->MODIFIED_DATE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
        <td data-name="MODIFIED_BY" <?= $Page->MODIFIED_BY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_VERIFICATION_MODIFIED_BY">
<span<?= $Page->MODIFIED_BY->viewAttributes() ?>>
<?= $Page->MODIFIED_BY->getViewValue() ?></span>
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
    ew.addEventHandlers("PO_VERIFICATION");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
