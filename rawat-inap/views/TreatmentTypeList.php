<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

// Page object
$TreatmentTypeList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fTREATMENT_TYPElist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fTREATMENT_TYPElist = currentForm = new ew.Form("fTREATMENT_TYPElist", "list");
    fTREATMENT_TYPElist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("fTREATMENT_TYPElist");
});
var fTREATMENT_TYPElistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    fTREATMENT_TYPElistsrch = currentSearchForm = new ew.Form("fTREATMENT_TYPElistsrch");

    // Dynamic selection lists

    // Filters
    fTREATMENT_TYPElistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fTREATMENT_TYPElistsrch");
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
<form name="fTREATMENT_TYPElistsrch" id="fTREATMENT_TYPElistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fTREATMENT_TYPElistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="TREATMENT_TYPE">
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> TREATMENT_TYPE">
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
<form name="fTREATMENT_TYPElist" id="fTREATMENT_TYPElist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="TREATMENT_TYPE">
<div id="gmp_TREATMENT_TYPE" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_TREATMENT_TYPElist" class="table ew-table"><!-- .ew-table -->
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
<?php if ($Page->TREAT_TYPE->Visible) { // TREAT_TYPE ?>
        <th data-name="TREAT_TYPE" class="<?= $Page->TREAT_TYPE->headerCellClass() ?>"><div id="elh_TREATMENT_TYPE_TREAT_TYPE" class="TREATMENT_TYPE_TREAT_TYPE"><?= $Page->renderSort($Page->TREAT_TYPE) ?></div></th>
<?php } ?>
<?php if ($Page->OBJECT_CATEGORY_ID->Visible) { // OBJECT_CATEGORY_ID ?>
        <th data-name="OBJECT_CATEGORY_ID" class="<?= $Page->OBJECT_CATEGORY_ID->headerCellClass() ?>"><div id="elh_TREATMENT_TYPE_OBJECT_CATEGORY_ID" class="TREATMENT_TYPE_OBJECT_CATEGORY_ID"><?= $Page->renderSort($Page->OBJECT_CATEGORY_ID) ?></div></th>
<?php } ?>
<?php if ($Page->TYPE_OF_TREATMENT->Visible) { // TYPE_OF_TREATMENT ?>
        <th data-name="TYPE_OF_TREATMENT" class="<?= $Page->TYPE_OF_TREATMENT->headerCellClass() ?>"><div id="elh_TREATMENT_TYPE_TYPE_OF_TREATMENT" class="TREATMENT_TYPE_TYPE_OF_TREATMENT"><?= $Page->renderSort($Page->TYPE_OF_TREATMENT) ?></div></th>
<?php } ?>
<?php if ($Page->ISSERVICE->Visible) { // ISSERVICE ?>
        <th data-name="ISSERVICE" class="<?= $Page->ISSERVICE->headerCellClass() ?>"><div id="elh_TREATMENT_TYPE_ISSERVICE" class="TREATMENT_TYPE_ISSERVICE"><?= $Page->renderSort($Page->ISSERVICE) ?></div></th>
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_TREATMENT_TYPE", "data-rowtype" => $Page->RowType]);

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
    <?php if ($Page->TREAT_TYPE->Visible) { // TREAT_TYPE ?>
        <td data-name="TREAT_TYPE" <?= $Page->TREAT_TYPE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_TYPE_TREAT_TYPE">
<span<?= $Page->TREAT_TYPE->viewAttributes() ?>>
<?= $Page->TREAT_TYPE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->OBJECT_CATEGORY_ID->Visible) { // OBJECT_CATEGORY_ID ?>
        <td data-name="OBJECT_CATEGORY_ID" <?= $Page->OBJECT_CATEGORY_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_TYPE_OBJECT_CATEGORY_ID">
<span<?= $Page->OBJECT_CATEGORY_ID->viewAttributes() ?>>
<?= $Page->OBJECT_CATEGORY_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->TYPE_OF_TREATMENT->Visible) { // TYPE_OF_TREATMENT ?>
        <td data-name="TYPE_OF_TREATMENT" <?= $Page->TYPE_OF_TREATMENT->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_TYPE_TYPE_OF_TREATMENT">
<span<?= $Page->TYPE_OF_TREATMENT->viewAttributes() ?>>
<?= $Page->TYPE_OF_TREATMENT->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ISSERVICE->Visible) { // ISSERVICE ?>
        <td data-name="ISSERVICE" <?= $Page->ISSERVICE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_TYPE_ISSERVICE">
<span<?= $Page->ISSERVICE->viewAttributes() ?>>
<?= $Page->ISSERVICE->getViewValue() ?></span>
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
    ew.addEventHandlers("TREATMENT_TYPE");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
