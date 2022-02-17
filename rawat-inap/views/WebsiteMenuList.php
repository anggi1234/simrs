<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

// Page object
$WebsiteMenuList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fWEBSITE_MENUlist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fWEBSITE_MENUlist = currentForm = new ew.Form("fWEBSITE_MENUlist", "list");
    fWEBSITE_MENUlist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("fWEBSITE_MENUlist");
});
var fWEBSITE_MENUlistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    fWEBSITE_MENUlistsrch = currentSearchForm = new ew.Form("fWEBSITE_MENUlistsrch");

    // Dynamic selection lists

    // Filters
    fWEBSITE_MENUlistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fWEBSITE_MENUlistsrch");
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
<?php if (!$Page->isExport() && !$Page->CurrentAction) { ?>
<form name="fWEBSITE_MENUlistsrch" id="fWEBSITE_MENUlistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fWEBSITE_MENUlistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="WEBSITE_MENU">
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
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<?php if ($Page->TotalRecords > 0 || $Page->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> WEBSITE_MENU">
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
<form name="fWEBSITE_MENUlist" id="fWEBSITE_MENUlist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="WEBSITE_MENU">
<div id="gmp_WEBSITE_MENU" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_WEBSITE_MENUlist" class="table ew-table"><!-- .ew-table -->
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
<?php if ($Page->MENU_ID->Visible) { // MENU_ID ?>
        <th data-name="MENU_ID" class="<?= $Page->MENU_ID->headerCellClass() ?>"><div id="elh_WEBSITE_MENU_MENU_ID" class="WEBSITE_MENU_MENU_ID"><?= $Page->renderSort($Page->MENU_ID) ?></div></th>
<?php } ?>
<?php if ($Page->javascript_id->Visible) { // javascript_id ?>
        <th data-name="javascript_id" class="<?= $Page->javascript_id->headerCellClass() ?>"><div id="elh_WEBSITE_MENU_javascript_id" class="WEBSITE_MENU_javascript_id"><?= $Page->renderSort($Page->javascript_id) ?></div></th>
<?php } ?>
<?php if ($Page->file_name->Visible) { // file_name ?>
        <th data-name="file_name" class="<?= $Page->file_name->headerCellClass() ?>"><div id="elh_WEBSITE_MENU_file_name" class="WEBSITE_MENU_file_name"><?= $Page->renderSort($Page->file_name) ?></div></th>
<?php } ?>
<?php if ($Page->menu_name->Visible) { // menu_name ?>
        <th data-name="menu_name" class="<?= $Page->menu_name->headerCellClass() ?>"><div id="elh_WEBSITE_MENU_menu_name" class="WEBSITE_MENU_menu_name"><?= $Page->renderSort($Page->menu_name) ?></div></th>
<?php } ?>
<?php if ($Page->isactive->Visible) { // isactive ?>
        <th data-name="isactive" class="<?= $Page->isactive->headerCellClass() ?>"><div id="elh_WEBSITE_MENU_isactive" class="WEBSITE_MENU_isactive"><?= $Page->renderSort($Page->isactive) ?></div></th>
<?php } ?>
<?php if ($Page->menu_type->Visible) { // menu_type ?>
        <th data-name="menu_type" class="<?= $Page->menu_type->headerCellClass() ?>"><div id="elh_WEBSITE_MENU_menu_type" class="WEBSITE_MENU_menu_type"><?= $Page->renderSort($Page->menu_type) ?></div></th>
<?php } ?>
<?php if ($Page->header_name->Visible) { // header_name ?>
        <th data-name="header_name" class="<?= $Page->header_name->headerCellClass() ?>"><div id="elh_WEBSITE_MENU_header_name" class="WEBSITE_MENU_header_name"><?= $Page->renderSort($Page->header_name) ?></div></th>
<?php } ?>
<?php if ($Page->isslide->Visible) { // isslide ?>
        <th data-name="isslide" class="<?= $Page->isslide->headerCellClass() ?>"><div id="elh_WEBSITE_MENU_isslide" class="WEBSITE_MENU_isslide"><?= $Page->renderSort($Page->isslide) ?></div></th>
<?php } ?>
<?php if ($Page->timeslide->Visible) { // timeslide ?>
        <th data-name="timeslide" class="<?= $Page->timeslide->headerCellClass() ?>"><div id="elh_WEBSITE_MENU_timeslide" class="WEBSITE_MENU_timeslide"><?= $Page->renderSort($Page->timeslide) ?></div></th>
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_WEBSITE_MENU", "data-rowtype" => $Page->RowType]);

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
    <?php if ($Page->MENU_ID->Visible) { // MENU_ID ?>
        <td data-name="MENU_ID" <?= $Page->MENU_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_WEBSITE_MENU_MENU_ID">
<span<?= $Page->MENU_ID->viewAttributes() ?>>
<?= $Page->MENU_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->javascript_id->Visible) { // javascript_id ?>
        <td data-name="javascript_id" <?= $Page->javascript_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_WEBSITE_MENU_javascript_id">
<span<?= $Page->javascript_id->viewAttributes() ?>>
<?= $Page->javascript_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->file_name->Visible) { // file_name ?>
        <td data-name="file_name" <?= $Page->file_name->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_WEBSITE_MENU_file_name">
<span<?= $Page->file_name->viewAttributes() ?>>
<?= $Page->file_name->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->menu_name->Visible) { // menu_name ?>
        <td data-name="menu_name" <?= $Page->menu_name->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_WEBSITE_MENU_menu_name">
<span<?= $Page->menu_name->viewAttributes() ?>>
<?= $Page->menu_name->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->isactive->Visible) { // isactive ?>
        <td data-name="isactive" <?= $Page->isactive->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_WEBSITE_MENU_isactive">
<span<?= $Page->isactive->viewAttributes() ?>>
<?= $Page->isactive->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->menu_type->Visible) { // menu_type ?>
        <td data-name="menu_type" <?= $Page->menu_type->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_WEBSITE_MENU_menu_type">
<span<?= $Page->menu_type->viewAttributes() ?>>
<?= $Page->menu_type->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->header_name->Visible) { // header_name ?>
        <td data-name="header_name" <?= $Page->header_name->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_WEBSITE_MENU_header_name">
<span<?= $Page->header_name->viewAttributes() ?>>
<?= $Page->header_name->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->isslide->Visible) { // isslide ?>
        <td data-name="isslide" <?= $Page->isslide->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_WEBSITE_MENU_isslide">
<span<?= $Page->isslide->viewAttributes() ?>>
<?= $Page->isslide->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->timeslide->Visible) { // timeslide ?>
        <td data-name="timeslide" <?= $Page->timeslide->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_WEBSITE_MENU_timeslide">
<span<?= $Page->timeslide->viewAttributes() ?>>
<?= $Page->timeslide->getViewValue() ?></span>
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
    ew.addEventHandlers("WEBSITE_MENU");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
