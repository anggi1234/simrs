<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

// Page object
$GoodGfList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fGOOD_GFlist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fGOOD_GFlist = currentForm = new ew.Form("fGOOD_GFlist", "list");
    fGOOD_GFlist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("fGOOD_GFlist");
});
var fGOOD_GFlistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    fGOOD_GFlistsrch = currentSearchForm = new ew.Form("fGOOD_GFlistsrch");

    // Dynamic selection lists

    // Filters
    fGOOD_GFlistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fGOOD_GFlistsrch");
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
<?php if (!$Page->isExport() || Config("EXPORT_MASTER_RECORD") && $Page->isExport("print")) { ?>
<?php
if ($Page->DbMasterFilter != "" && $Page->getCurrentMasterTable() == "MUTATION_DOCS") {
    if ($Page->MasterRecordExists) {
        include_once "views/MutationDocsMaster.php";
    }
}
?>
<?php } ?>
<?php
$Page->renderOtherOptions();
?>
<?php if ($Security->canSearch()) { ?>
<?php if (!$Page->isExport() && !$Page->CurrentAction) { ?>
<form name="fGOOD_GFlistsrch" id="fGOOD_GFlistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fGOOD_GFlistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="GOOD_GF">
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> GOOD_GF">
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
<form name="fGOOD_GFlist" id="fGOOD_GFlist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="GOOD_GF">
<?php if ($Page->getCurrentMasterTable() == "MUTATION_DOCS" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="MUTATION_DOCS">
<input type="hidden" name="fk_DOC_NO" value="<?= HtmlEncode($Page->DOC_NO->getSessionValue()) ?>">
<input type="hidden" name="fk_CLINIC_ID_TO" value="<?= HtmlEncode($Page->ROOMS_ID->getSessionValue()) ?>">
<input type="hidden" name="fk_CLINIC_ID" value="<?= HtmlEncode($Page->FROM_ROOMS_ID->getSessionValue()) ?>">
<?php } ?>
<div id="gmp_GOOD_GF" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_GOOD_GFlist" class="table ew-table"><!-- .ew-table -->
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
<?php if ($Page->BRAND_ID->Visible) { // BRAND_ID ?>
        <th data-name="BRAND_ID" class="<?= $Page->BRAND_ID->headerCellClass() ?>"><div id="elh_GOOD_GF_BRAND_ID" class="GOOD_GF_BRAND_ID"><?= $Page->renderSort($Page->BRAND_ID) ?></div></th>
<?php } ?>
<?php if ($Page->ROOMS_ID->Visible) { // ROOMS_ID ?>
        <th data-name="ROOMS_ID" class="<?= $Page->ROOMS_ID->headerCellClass() ?>"><div id="elh_GOOD_GF_ROOMS_ID" class="GOOD_GF_ROOMS_ID"><?= $Page->renderSort($Page->ROOMS_ID) ?></div></th>
<?php } ?>
<?php if ($Page->EXPIRY_DATE->Visible) { // EXPIRY_DATE ?>
        <th data-name="EXPIRY_DATE" class="<?= $Page->EXPIRY_DATE->headerCellClass() ?>"><div id="elh_GOOD_GF_EXPIRY_DATE" class="GOOD_GF_EXPIRY_DATE"><?= $Page->renderSort($Page->EXPIRY_DATE) ?></div></th>
<?php } ?>
<?php if ($Page->ISOUTLET->Visible) { // ISOUTLET ?>
        <th data-name="ISOUTLET" class="<?= $Page->ISOUTLET->headerCellClass() ?>"><div id="elh_GOOD_GF_ISOUTLET" class="GOOD_GF_ISOUTLET"><?= $Page->renderSort($Page->ISOUTLET) ?></div></th>
<?php } ?>
<?php if ($Page->QUANTITY->Visible) { // QUANTITY ?>
        <th data-name="QUANTITY" class="<?= $Page->QUANTITY->headerCellClass() ?>"><div id="elh_GOOD_GF_QUANTITY" class="GOOD_GF_QUANTITY"><?= $Page->renderSort($Page->QUANTITY) ?></div></th>
<?php } ?>
<?php if ($Page->ALLOCATED_FROM->Visible) { // ALLOCATED_FROM ?>
        <th data-name="ALLOCATED_FROM" class="<?= $Page->ALLOCATED_FROM->headerCellClass() ?>"><div id="elh_GOOD_GF_ALLOCATED_FROM" class="GOOD_GF_ALLOCATED_FROM"><?= $Page->renderSort($Page->ALLOCATED_FROM) ?></div></th>
<?php } ?>
<?php if ($Page->DIJUAL->Visible) { // DIJUAL ?>
        <th data-name="DIJUAL" class="<?= $Page->DIJUAL->headerCellClass() ?>"><div id="elh_GOOD_GF_DIJUAL" class="GOOD_GF_DIJUAL"><?= $Page->renderSort($Page->DIJUAL) ?></div></th>
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_GOOD_GF", "data-rowtype" => $Page->RowType]);

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
    <?php if ($Page->BRAND_ID->Visible) { // BRAND_ID ?>
        <td data-name="BRAND_ID" <?= $Page->BRAND_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_BRAND_ID">
<span<?= $Page->BRAND_ID->viewAttributes() ?>>
<?= $Page->BRAND_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ROOMS_ID->Visible) { // ROOMS_ID ?>
        <td data-name="ROOMS_ID" <?= $Page->ROOMS_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_ROOMS_ID">
<span<?= $Page->ROOMS_ID->viewAttributes() ?>>
<?= $Page->ROOMS_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->EXPIRY_DATE->Visible) { // EXPIRY_DATE ?>
        <td data-name="EXPIRY_DATE" <?= $Page->EXPIRY_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_EXPIRY_DATE">
<span<?= $Page->EXPIRY_DATE->viewAttributes() ?>>
<?= $Page->EXPIRY_DATE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ISOUTLET->Visible) { // ISOUTLET ?>
        <td data-name="ISOUTLET" <?= $Page->ISOUTLET->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_ISOUTLET">
<span<?= $Page->ISOUTLET->viewAttributes() ?>>
<?= $Page->ISOUTLET->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->QUANTITY->Visible) { // QUANTITY ?>
        <td data-name="QUANTITY" <?= $Page->QUANTITY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_QUANTITY">
<span<?= $Page->QUANTITY->viewAttributes() ?>>
<?= $Page->QUANTITY->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ALLOCATED_FROM->Visible) { // ALLOCATED_FROM ?>
        <td data-name="ALLOCATED_FROM" <?= $Page->ALLOCATED_FROM->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_ALLOCATED_FROM">
<span<?= $Page->ALLOCATED_FROM->viewAttributes() ?>>
<?= $Page->ALLOCATED_FROM->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->DIJUAL->Visible) { // DIJUAL ?>
        <td data-name="DIJUAL" <?= $Page->DIJUAL->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_DIJUAL">
<span<?= $Page->DIJUAL->viewAttributes() ?>>
<?= $Page->DIJUAL->getViewValue() ?></span>
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
    ew.addEventHandlers("GOOD_GF");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
