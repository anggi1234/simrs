<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

// Page object
$UsersMenuList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fUSERS_MENUlist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fUSERS_MENUlist = currentForm = new ew.Form("fUSERS_MENUlist", "list");
    fUSERS_MENUlist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("fUSERS_MENUlist");
});
var fUSERS_MENUlistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    fUSERS_MENUlistsrch = currentSearchForm = new ew.Form("fUSERS_MENUlistsrch");

    // Dynamic selection lists

    // Filters
    fUSERS_MENUlistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fUSERS_MENUlistsrch");
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
<form name="fUSERS_MENUlistsrch" id="fUSERS_MENUlistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fUSERS_MENUlistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="USERS_MENU">
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> USERS_MENU">
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
<form name="fUSERS_MENUlist" id="fUSERS_MENUlist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="USERS_MENU">
<div id="gmp_USERS_MENU" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_USERS_MENUlist" class="table ew-table"><!-- .ew-table -->
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
        <th data-name="ORG_UNIT_CODE" class="<?= $Page->ORG_UNIT_CODE->headerCellClass() ?>"><div id="elh_USERS_MENU_ORG_UNIT_CODE" class="USERS_MENU_ORG_UNIT_CODE"><?= $Page->renderSort($Page->ORG_UNIT_CODE) ?></div></th>
<?php } ?>
<?php if ($Page->_USERNAME->Visible) { // USERNAME ?>
        <th data-name="_USERNAME" class="<?= $Page->_USERNAME->headerCellClass() ?>"><div id="elh_USERS_MENU__USERNAME" class="USERS_MENU__USERNAME"><?= $Page->renderSort($Page->_USERNAME) ?></div></th>
<?php } ?>
<?php if ($Page->MENU_ID->Visible) { // MENU_ID ?>
        <th data-name="MENU_ID" class="<?= $Page->MENU_ID->headerCellClass() ?>"><div id="elh_USERS_MENU_MENU_ID" class="USERS_MENU_MENU_ID"><?= $Page->renderSort($Page->MENU_ID) ?></div></th>
<?php } ?>
<?php if ($Page->STYPE_ID->Visible) { // STYPE_ID ?>
        <th data-name="STYPE_ID" class="<?= $Page->STYPE_ID->headerCellClass() ?>"><div id="elh_USERS_MENU_STYPE_ID" class="USERS_MENU_STYPE_ID"><?= $Page->renderSort($Page->STYPE_ID) ?></div></th>
<?php } ?>
<?php if ($Page->GROUP_ID->Visible) { // GROUP_ID ?>
        <th data-name="GROUP_ID" class="<?= $Page->GROUP_ID->headerCellClass() ?>"><div id="elh_USERS_MENU_GROUP_ID" class="USERS_MENU_GROUP_ID"><?= $Page->renderSort($Page->GROUP_ID) ?></div></th>
<?php } ?>
<?php if ($Page->C->Visible) { // C ?>
        <th data-name="C" class="<?= $Page->C->headerCellClass() ?>"><div id="elh_USERS_MENU_C" class="USERS_MENU_C"><?= $Page->renderSort($Page->C) ?></div></th>
<?php } ?>
<?php if ($Page->R->Visible) { // R ?>
        <th data-name="R" class="<?= $Page->R->headerCellClass() ?>"><div id="elh_USERS_MENU_R" class="USERS_MENU_R"><?= $Page->renderSort($Page->R) ?></div></th>
<?php } ?>
<?php if ($Page->U->Visible) { // U ?>
        <th data-name="U" class="<?= $Page->U->headerCellClass() ?>"><div id="elh_USERS_MENU_U" class="USERS_MENU_U"><?= $Page->renderSort($Page->U) ?></div></th>
<?php } ?>
<?php if ($Page->D->Visible) { // D ?>
        <th data-name="D" class="<?= $Page->D->headerCellClass() ?>"><div id="elh_USERS_MENU_D" class="USERS_MENU_D"><?= $Page->renderSort($Page->D) ?></div></th>
<?php } ?>
<?php if ($Page->P->Visible) { // P ?>
        <th data-name="P" class="<?= $Page->P->headerCellClass() ?>"><div id="elh_USERS_MENU_P" class="USERS_MENU_P"><?= $Page->renderSort($Page->P) ?></div></th>
<?php } ?>
<?php if ($Page->E->Visible) { // E ?>
        <th data-name="E" class="<?= $Page->E->headerCellClass() ?>"><div id="elh_USERS_MENU_E" class="USERS_MENU_E"><?= $Page->renderSort($Page->E) ?></div></th>
<?php } ?>
<?php if ($Page->C_TIME->Visible) { // C_TIME ?>
        <th data-name="C_TIME" class="<?= $Page->C_TIME->headerCellClass() ?>"><div id="elh_USERS_MENU_C_TIME" class="USERS_MENU_C_TIME"><?= $Page->renderSort($Page->C_TIME) ?></div></th>
<?php } ?>
<?php if ($Page->U_TIME->Visible) { // U_TIME ?>
        <th data-name="U_TIME" class="<?= $Page->U_TIME->headerCellClass() ?>"><div id="elh_USERS_MENU_U_TIME" class="USERS_MENU_U_TIME"><?= $Page->renderSort($Page->U_TIME) ?></div></th>
<?php } ?>
<?php if ($Page->D_TIME->Visible) { // D_TIME ?>
        <th data-name="D_TIME" class="<?= $Page->D_TIME->headerCellClass() ?>"><div id="elh_USERS_MENU_D_TIME" class="USERS_MENU_D_TIME"><?= $Page->renderSort($Page->D_TIME) ?></div></th>
<?php } ?>
<?php if ($Page->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
        <th data-name="MODIFIED_DATE" class="<?= $Page->MODIFIED_DATE->headerCellClass() ?>"><div id="elh_USERS_MENU_MODIFIED_DATE" class="USERS_MENU_MODIFIED_DATE"><?= $Page->renderSort($Page->MODIFIED_DATE) ?></div></th>
<?php } ?>
<?php if ($Page->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
        <th data-name="MODIFIED_BY" class="<?= $Page->MODIFIED_BY->headerCellClass() ?>"><div id="elh_USERS_MENU_MODIFIED_BY" class="USERS_MENU_MODIFIED_BY"><?= $Page->renderSort($Page->MODIFIED_BY) ?></div></th>
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_USERS_MENU", "data-rowtype" => $Page->RowType]);

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
<span id="el<?= $Page->RowCount ?>_USERS_MENU_ORG_UNIT_CODE">
<span<?= $Page->ORG_UNIT_CODE->viewAttributes() ?>>
<?= $Page->ORG_UNIT_CODE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->_USERNAME->Visible) { // USERNAME ?>
        <td data-name="_USERNAME" <?= $Page->_USERNAME->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_USERS_MENU__USERNAME">
<span<?= $Page->_USERNAME->viewAttributes() ?>>
<?= $Page->_USERNAME->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->MENU_ID->Visible) { // MENU_ID ?>
        <td data-name="MENU_ID" <?= $Page->MENU_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_USERS_MENU_MENU_ID">
<span<?= $Page->MENU_ID->viewAttributes() ?>>
<?= $Page->MENU_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->STYPE_ID->Visible) { // STYPE_ID ?>
        <td data-name="STYPE_ID" <?= $Page->STYPE_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_USERS_MENU_STYPE_ID">
<span<?= $Page->STYPE_ID->viewAttributes() ?>>
<?= $Page->STYPE_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->GROUP_ID->Visible) { // GROUP_ID ?>
        <td data-name="GROUP_ID" <?= $Page->GROUP_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_USERS_MENU_GROUP_ID">
<span<?= $Page->GROUP_ID->viewAttributes() ?>>
<?= $Page->GROUP_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->C->Visible) { // C ?>
        <td data-name="C" <?= $Page->C->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_USERS_MENU_C">
<span<?= $Page->C->viewAttributes() ?>>
<?= $Page->C->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->R->Visible) { // R ?>
        <td data-name="R" <?= $Page->R->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_USERS_MENU_R">
<span<?= $Page->R->viewAttributes() ?>>
<?= $Page->R->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->U->Visible) { // U ?>
        <td data-name="U" <?= $Page->U->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_USERS_MENU_U">
<span<?= $Page->U->viewAttributes() ?>>
<?= $Page->U->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->D->Visible) { // D ?>
        <td data-name="D" <?= $Page->D->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_USERS_MENU_D">
<span<?= $Page->D->viewAttributes() ?>>
<?= $Page->D->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->P->Visible) { // P ?>
        <td data-name="P" <?= $Page->P->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_USERS_MENU_P">
<span<?= $Page->P->viewAttributes() ?>>
<?= $Page->P->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->E->Visible) { // E ?>
        <td data-name="E" <?= $Page->E->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_USERS_MENU_E">
<span<?= $Page->E->viewAttributes() ?>>
<?= $Page->E->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->C_TIME->Visible) { // C_TIME ?>
        <td data-name="C_TIME" <?= $Page->C_TIME->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_USERS_MENU_C_TIME">
<span<?= $Page->C_TIME->viewAttributes() ?>>
<?= $Page->C_TIME->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->U_TIME->Visible) { // U_TIME ?>
        <td data-name="U_TIME" <?= $Page->U_TIME->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_USERS_MENU_U_TIME">
<span<?= $Page->U_TIME->viewAttributes() ?>>
<?= $Page->U_TIME->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->D_TIME->Visible) { // D_TIME ?>
        <td data-name="D_TIME" <?= $Page->D_TIME->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_USERS_MENU_D_TIME">
<span<?= $Page->D_TIME->viewAttributes() ?>>
<?= $Page->D_TIME->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
        <td data-name="MODIFIED_DATE" <?= $Page->MODIFIED_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_USERS_MENU_MODIFIED_DATE">
<span<?= $Page->MODIFIED_DATE->viewAttributes() ?>>
<?= $Page->MODIFIED_DATE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
        <td data-name="MODIFIED_BY" <?= $Page->MODIFIED_BY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_USERS_MENU_MODIFIED_BY">
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
    ew.addEventHandlers("USERS_MENU");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
