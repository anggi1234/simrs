<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

// Page object
$ObstetriView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fOBSTETRIview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fOBSTETRIview = currentForm = new ew.Form("fOBSTETRIview", "view");
    loadjs.done("fOBSTETRIview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.OBSTETRI) ew.vars.tables.OBSTETRI = <?= JsonEncode(GetClientVar("tables", "OBSTETRI")) ?>;
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
<form name="fOBSTETRIview" id="fOBSTETRIview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="OBSTETRI">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (!$Page->isExport()) { ?>
<div class="ew-multi-page">
<div class="ew-nav-tabs" id="Page"><!-- multi-page tabs -->
    <ul class="<?= $Page->MultiPages->navStyle() ?>">
        <li class="nav-item"><a class="nav-link<?= $Page->MultiPages->pageStyle(1) ?>" href="#tab_OBSTETRI1" data-toggle="tab"><?= $Page->pageCaption(1) ?></a></li>
        <li class="nav-item"><a class="nav-link<?= $Page->MultiPages->pageStyle(2) ?>" href="#tab_OBSTETRI2" data-toggle="tab"><?= $Page->pageCaption(2) ?></a></li>
        <li class="nav-item"><a class="nav-link<?= $Page->MultiPages->pageStyle(3) ?>" href="#tab_OBSTETRI3" data-toggle="tab"><?= $Page->pageCaption(3) ?></a></li>
    </ul>
    <div class="tab-content">
<?php } ?>
<?php if (!$Page->isExport()) { ?>
        <div class="tab-pane<?= $Page->MultiPages->pageStyle(1) ?>" id="tab_OBSTETRI1"><!-- multi-page .tab-pane -->
<?php } ?>
<table class="table table-bordered table-hover ew-view-table">
<?php if ($Page->NO_REGISTRATION->Visible) { // NO_REGISTRATION ?>
    <tr id="r_NO_REGISTRATION">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_NO_REGISTRATION"><?= $Page->NO_REGISTRATION->caption() ?></span></td>
        <td data-name="NO_REGISTRATION" <?= $Page->NO_REGISTRATION->cellAttributes() ?>>
<span id="el_OBSTETRI_NO_REGISTRATION" data-page="1">
<span<?= $Page->NO_REGISTRATION->viewAttributes() ?>>
<?= $Page->NO_REGISTRATION->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->THENAME->Visible) { // THENAME ?>
    <tr id="r_THENAME">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_THENAME"><?= $Page->THENAME->caption() ?></span></td>
        <td data-name="THENAME" <?= $Page->THENAME->cellAttributes() ?>>
<span id="el_OBSTETRI_THENAME" data-page="1">
<span<?= $Page->THENAME->viewAttributes() ?>>
<?= $Page->THENAME->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->THEADDRESS->Visible) { // THEADDRESS ?>
    <tr id="r_THEADDRESS">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_THEADDRESS"><?= $Page->THEADDRESS->caption() ?></span></td>
        <td data-name="THEADDRESS" <?= $Page->THEADDRESS->cellAttributes() ?>>
<span id="el_OBSTETRI_THEADDRESS" data-page="1">
<span<?= $Page->THEADDRESS->viewAttributes() ?>>
<?= $Page->THEADDRESS->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->GENDER->Visible) { // GENDER ?>
    <tr id="r_GENDER">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_GENDER"><?= $Page->GENDER->caption() ?></span></td>
        <td data-name="GENDER" <?= $Page->GENDER->cellAttributes() ?>>
<span id="el_OBSTETRI_GENDER" data-page="1">
<span<?= $Page->GENDER->viewAttributes() ?>>
<?= $Page->GENDER->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->CLINIC_ID->Visible) { // CLINIC_ID ?>
    <tr id="r_CLINIC_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_CLINIC_ID"><?= $Page->CLINIC_ID->caption() ?></span></td>
        <td data-name="CLINIC_ID" <?= $Page->CLINIC_ID->cellAttributes() ?>>
<span id="el_OBSTETRI_CLINIC_ID" data-page="1">
<span<?= $Page->CLINIC_ID->viewAttributes() ?>>
<?= $Page->CLINIC_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->EMPLOYEE_ID->Visible) { // EMPLOYEE_ID ?>
    <tr id="r_EMPLOYEE_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_EMPLOYEE_ID"><?= $Page->EMPLOYEE_ID->caption() ?></span></td>
        <td data-name="EMPLOYEE_ID" <?= $Page->EMPLOYEE_ID->cellAttributes() ?>>
<span id="el_OBSTETRI_EMPLOYEE_ID" data-page="1">
<span<?= $Page->EMPLOYEE_ID->viewAttributes() ?>>
<?= $Page->EMPLOYEE_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->BIRTH_NB->Visible) { // BIRTH_NB ?>
    <tr id="r_BIRTH_NB">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_BIRTH_NB"><?= $Page->BIRTH_NB->caption() ?></span></td>
        <td data-name="BIRTH_NB" <?= $Page->BIRTH_NB->cellAttributes() ?>>
<span id="el_OBSTETRI_BIRTH_NB" data-page="1">
<span<?= $Page->BIRTH_NB->viewAttributes() ?>>
<?= $Page->BIRTH_NB->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->BIRTH_DURATION->Visible) { // BIRTH_DURATION ?>
    <tr id="r_BIRTH_DURATION">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_BIRTH_DURATION"><?= $Page->BIRTH_DURATION->caption() ?></span></td>
        <td data-name="BIRTH_DURATION" <?= $Page->BIRTH_DURATION->cellAttributes() ?>>
<span id="el_OBSTETRI_BIRTH_DURATION" data-page="1">
<span<?= $Page->BIRTH_DURATION->viewAttributes() ?>>
<?= $Page->BIRTH_DURATION->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->BIRTH_PLACE->Visible) { // BIRTH_PLACE ?>
    <tr id="r_BIRTH_PLACE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_BIRTH_PLACE"><?= $Page->BIRTH_PLACE->caption() ?></span></td>
        <td data-name="BIRTH_PLACE" <?= $Page->BIRTH_PLACE->cellAttributes() ?>>
<span id="el_OBSTETRI_BIRTH_PLACE" data-page="1">
<span<?= $Page->BIRTH_PLACE->viewAttributes() ?>>
<?= $Page->BIRTH_PLACE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ANTE_NATAL->Visible) { // ANTE_NATAL ?>
    <tr id="r_ANTE_NATAL">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_ANTE_NATAL"><?= $Page->ANTE_NATAL->caption() ?></span></td>
        <td data-name="ANTE_NATAL" <?= $Page->ANTE_NATAL->cellAttributes() ?>>
<span id="el_OBSTETRI_ANTE_NATAL" data-page="1">
<span<?= $Page->ANTE_NATAL->viewAttributes() ?>>
<?= $Page->ANTE_NATAL->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->BIRTH_WAY->Visible) { // BIRTH_WAY ?>
    <tr id="r_BIRTH_WAY">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_BIRTH_WAY"><?= $Page->BIRTH_WAY->caption() ?></span></td>
        <td data-name="BIRTH_WAY" <?= $Page->BIRTH_WAY->cellAttributes() ?>>
<span id="el_OBSTETRI_BIRTH_WAY" data-page="1">
<span<?= $Page->BIRTH_WAY->viewAttributes() ?>>
<?= $Page->BIRTH_WAY->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->BIRTH_BY->Visible) { // BIRTH_BY ?>
    <tr id="r_BIRTH_BY">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_BIRTH_BY"><?= $Page->BIRTH_BY->caption() ?></span></td>
        <td data-name="BIRTH_BY" <?= $Page->BIRTH_BY->cellAttributes() ?>>
<span id="el_OBSTETRI_BIRTH_BY" data-page="1">
<span<?= $Page->BIRTH_BY->viewAttributes() ?>>
<?= $Page->BIRTH_BY->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->BIRTH_DATE->Visible) { // BIRTH_DATE ?>
    <tr id="r_BIRTH_DATE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_BIRTH_DATE"><?= $Page->BIRTH_DATE->caption() ?></span></td>
        <td data-name="BIRTH_DATE" <?= $Page->BIRTH_DATE->cellAttributes() ?>>
<span id="el_OBSTETRI_BIRTH_DATE" data-page="1">
<span<?= $Page->BIRTH_DATE->viewAttributes() ?>>
<?= $Page->BIRTH_DATE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->GESTASI->Visible) { // GESTASI ?>
    <tr id="r_GESTASI">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_GESTASI"><?= $Page->GESTASI->caption() ?></span></td>
        <td data-name="GESTASI" <?= $Page->GESTASI->cellAttributes() ?>>
<span id="el_OBSTETRI_GESTASI" data-page="1">
<span<?= $Page->GESTASI->viewAttributes() ?>>
<?= $Page->GESTASI->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->PARITY->Visible) { // PARITY ?>
    <tr id="r_PARITY">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_PARITY"><?= $Page->PARITY->caption() ?></span></td>
        <td data-name="PARITY" <?= $Page->PARITY->cellAttributes() ?>>
<span id="el_OBSTETRI_PARITY" data-page="1">
<span<?= $Page->PARITY->viewAttributes() ?>>
<?= $Page->PARITY->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->NB_BABY->Visible) { // NB_BABY ?>
    <tr id="r_NB_BABY">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_NB_BABY"><?= $Page->NB_BABY->caption() ?></span></td>
        <td data-name="NB_BABY" <?= $Page->NB_BABY->cellAttributes() ?>>
<span id="el_OBSTETRI_NB_BABY" data-page="1">
<span<?= $Page->NB_BABY->viewAttributes() ?>>
<?= $Page->NB_BABY->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->BABY_DIE->Visible) { // BABY_DIE ?>
    <tr id="r_BABY_DIE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_BABY_DIE"><?= $Page->BABY_DIE->caption() ?></span></td>
        <td data-name="BABY_DIE" <?= $Page->BABY_DIE->cellAttributes() ?>>
<span id="el_OBSTETRI_BABY_DIE" data-page="1">
<span<?= $Page->BABY_DIE->viewAttributes() ?>>
<?= $Page->BABY_DIE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->BLOODING->Visible) { // BLOODING ?>
    <tr id="r_BLOODING">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_BLOODING"><?= $Page->BLOODING->caption() ?></span></td>
        <td data-name="BLOODING" <?= $Page->BLOODING->cellAttributes() ?>>
<span id="el_OBSTETRI_BLOODING" data-page="1">
<span<?= $Page->BLOODING->viewAttributes() ?>>
<?= $Page->BLOODING->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->DESCRIPTION->Visible) { // DESCRIPTION ?>
    <tr id="r_DESCRIPTION">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_DESCRIPTION"><?= $Page->DESCRIPTION->caption() ?></span></td>
        <td data-name="DESCRIPTION" <?= $Page->DESCRIPTION->cellAttributes() ?>>
<span id="el_OBSTETRI_DESCRIPTION" data-page="1">
<span<?= $Page->DESCRIPTION->viewAttributes() ?>>
<?= $Page->DESCRIPTION->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ID->Visible) { // ID ?>
    <tr id="r_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_ID"><?= $Page->ID->caption() ?></span></td>
        <td data-name="ID" <?= $Page->ID->cellAttributes() ?>>
<span id="el_OBSTETRI_ID" data-page="1">
<span<?= $Page->ID->viewAttributes() ?>>
<?= $Page->ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php if (!$Page->isExport()) { ?>
        </div>
<?php } ?>
<?php if (!$Page->isExport()) { ?>
        <div class="tab-pane<?= $Page->MultiPages->pageStyle(2) ?>" id="tab_OBSTETRI2"><!-- multi-page .tab-pane -->
<?php } ?>
<table class="table table-bordered table-hover ew-view-table">
<?php if ($Page->ABORTUS_KE->Visible) { // ABORTUS_KE ?>
    <tr id="r_ABORTUS_KE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_ABORTUS_KE"><?= $Page->ABORTUS_KE->caption() ?></span></td>
        <td data-name="ABORTUS_KE" <?= $Page->ABORTUS_KE->cellAttributes() ?>>
<span id="el_OBSTETRI_ABORTUS_KE" data-page="2">
<span<?= $Page->ABORTUS_KE->viewAttributes() ?>>
<?= $Page->ABORTUS_KE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ABORTUS_ID->Visible) { // ABORTUS_ID ?>
    <tr id="r_ABORTUS_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_ABORTUS_ID"><?= $Page->ABORTUS_ID->caption() ?></span></td>
        <td data-name="ABORTUS_ID" <?= $Page->ABORTUS_ID->cellAttributes() ?>>
<span id="el_OBSTETRI_ABORTUS_ID" data-page="2">
<span<?= $Page->ABORTUS_ID->viewAttributes() ?>>
<?= $Page->ABORTUS_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ABORTION_DATE->Visible) { // ABORTION_DATE ?>
    <tr id="r_ABORTION_DATE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_ABORTION_DATE"><?= $Page->ABORTION_DATE->caption() ?></span></td>
        <td data-name="ABORTION_DATE" <?= $Page->ABORTION_DATE->cellAttributes() ?>>
<span id="el_OBSTETRI_ABORTION_DATE" data-page="2">
<span<?= $Page->ABORTION_DATE->viewAttributes() ?>>
<?= $Page->ABORTION_DATE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->BIRTH_CAT->Visible) { // BIRTH_CAT ?>
    <tr id="r_BIRTH_CAT">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_BIRTH_CAT"><?= $Page->BIRTH_CAT->caption() ?></span></td>
        <td data-name="BIRTH_CAT" <?= $Page->BIRTH_CAT->cellAttributes() ?>>
<span id="el_OBSTETRI_BIRTH_CAT" data-page="2">
<span<?= $Page->BIRTH_CAT->viewAttributes() ?>>
<?= $Page->BIRTH_CAT->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->BIRTH_CON->Visible) { // BIRTH_CON ?>
    <tr id="r_BIRTH_CON">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_BIRTH_CON"><?= $Page->BIRTH_CON->caption() ?></span></td>
        <td data-name="BIRTH_CON" <?= $Page->BIRTH_CON->cellAttributes() ?>>
<span id="el_OBSTETRI_BIRTH_CON" data-page="2">
<span<?= $Page->BIRTH_CON->viewAttributes() ?>>
<?= $Page->BIRTH_CON->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->BIRTH_RISK->Visible) { // BIRTH_RISK ?>
    <tr id="r_BIRTH_RISK">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_BIRTH_RISK"><?= $Page->BIRTH_RISK->caption() ?></span></td>
        <td data-name="BIRTH_RISK" <?= $Page->BIRTH_RISK->cellAttributes() ?>>
<span id="el_OBSTETRI_BIRTH_RISK" data-page="2">
<span<?= $Page->BIRTH_RISK->viewAttributes() ?>>
<?= $Page->BIRTH_RISK->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->RISK_TYPE->Visible) { // RISK_TYPE ?>
    <tr id="r_RISK_TYPE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_RISK_TYPE"><?= $Page->RISK_TYPE->caption() ?></span></td>
        <td data-name="RISK_TYPE" <?= $Page->RISK_TYPE->cellAttributes() ?>>
<span id="el_OBSTETRI_RISK_TYPE" data-page="2">
<span<?= $Page->RISK_TYPE->viewAttributes() ?>>
<?= $Page->RISK_TYPE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->FOLLOW_UP->Visible) { // FOLLOW_UP ?>
    <tr id="r_FOLLOW_UP">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_FOLLOW_UP"><?= $Page->FOLLOW_UP->caption() ?></span></td>
        <td data-name="FOLLOW_UP" <?= $Page->FOLLOW_UP->cellAttributes() ?>>
<span id="el_OBSTETRI_FOLLOW_UP" data-page="2">
<span<?= $Page->FOLLOW_UP->viewAttributes() ?>>
<?= $Page->FOLLOW_UP->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->DIRUJUK_OLEH->Visible) { // DIRUJUK_OLEH ?>
    <tr id="r_DIRUJUK_OLEH">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_DIRUJUK_OLEH"><?= $Page->DIRUJUK_OLEH->caption() ?></span></td>
        <td data-name="DIRUJUK_OLEH" <?= $Page->DIRUJUK_OLEH->cellAttributes() ?>>
<span id="el_OBSTETRI_DIRUJUK_OLEH" data-page="2">
<span<?= $Page->DIRUJUK_OLEH->viewAttributes() ?>>
<?= $Page->DIRUJUK_OLEH->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php if (!$Page->isExport()) { ?>
        </div>
<?php } ?>
<?php if (!$Page->isExport()) { ?>
        <div class="tab-pane<?= $Page->MultiPages->pageStyle(3) ?>" id="tab_OBSTETRI3"><!-- multi-page .tab-pane -->
<?php } ?>
<table class="table table-bordered table-hover ew-view-table">
<?php if ($Page->INSPECTION_DATE->Visible) { // INSPECTION_DATE ?>
    <tr id="r_INSPECTION_DATE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_INSPECTION_DATE"><?= $Page->INSPECTION_DATE->caption() ?></span></td>
        <td data-name="INSPECTION_DATE" <?= $Page->INSPECTION_DATE->cellAttributes() ?>>
<span id="el_OBSTETRI_INSPECTION_DATE" data-page="3">
<span<?= $Page->INSPECTION_DATE->viewAttributes() ?>>
<?= $Page->INSPECTION_DATE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->PORSIO->Visible) { // PORSIO ?>
    <tr id="r_PORSIO">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_PORSIO"><?= $Page->PORSIO->caption() ?></span></td>
        <td data-name="PORSIO" <?= $Page->PORSIO->cellAttributes() ?>>
<span id="el_OBSTETRI_PORSIO" data-page="3">
<span<?= $Page->PORSIO->viewAttributes() ?>>
<?= $Page->PORSIO->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->PEMBUKAAN->Visible) { // PEMBUKAAN ?>
    <tr id="r_PEMBUKAAN">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_PEMBUKAAN"><?= $Page->PEMBUKAAN->caption() ?></span></td>
        <td data-name="PEMBUKAAN" <?= $Page->PEMBUKAAN->cellAttributes() ?>>
<span id="el_OBSTETRI_PEMBUKAAN" data-page="3">
<span<?= $Page->PEMBUKAAN->viewAttributes() ?>>
<?= $Page->PEMBUKAAN->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->KETUBAN->Visible) { // KETUBAN ?>
    <tr id="r_KETUBAN">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_KETUBAN"><?= $Page->KETUBAN->caption() ?></span></td>
        <td data-name="KETUBAN" <?= $Page->KETUBAN->cellAttributes() ?>>
<span id="el_OBSTETRI_KETUBAN" data-page="3">
<span<?= $Page->KETUBAN->viewAttributes() ?>>
<?= $Page->KETUBAN->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->PRESENTASI->Visible) { // PRESENTASI ?>
    <tr id="r_PRESENTASI">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_PRESENTASI"><?= $Page->PRESENTASI->caption() ?></span></td>
        <td data-name="PRESENTASI" <?= $Page->PRESENTASI->cellAttributes() ?>>
<span id="el_OBSTETRI_PRESENTASI" data-page="3">
<span<?= $Page->PRESENTASI->viewAttributes() ?>>
<?= $Page->PRESENTASI->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->POSISI->Visible) { // POSISI ?>
    <tr id="r_POSISI">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_POSISI"><?= $Page->POSISI->caption() ?></span></td>
        <td data-name="POSISI" <?= $Page->POSISI->cellAttributes() ?>>
<span id="el_OBSTETRI_POSISI" data-page="3">
<span<?= $Page->POSISI->viewAttributes() ?>>
<?= $Page->POSISI->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->PENURUNAN->Visible) { // PENURUNAN ?>
    <tr id="r_PENURUNAN">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_PENURUNAN"><?= $Page->PENURUNAN->caption() ?></span></td>
        <td data-name="PENURUNAN" <?= $Page->PENURUNAN->cellAttributes() ?>>
<span id="el_OBSTETRI_PENURUNAN" data-page="3">
<span<?= $Page->PENURUNAN->viewAttributes() ?>>
<?= $Page->PENURUNAN->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->PLACENTA->Visible) { // PLACENTA ?>
    <tr id="r_PLACENTA">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_PLACENTA"><?= $Page->PLACENTA->caption() ?></span></td>
        <td data-name="PLACENTA" <?= $Page->PLACENTA->cellAttributes() ?>>
<span id="el_OBSTETRI_PLACENTA" data-page="3">
<span<?= $Page->PLACENTA->viewAttributes() ?>>
<?= $Page->PLACENTA->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->RAHIM_ID->Visible) { // RAHIM_ID ?>
    <tr id="r_RAHIM_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_RAHIM_ID"><?= $Page->RAHIM_ID->caption() ?></span></td>
        <td data-name="RAHIM_ID" <?= $Page->RAHIM_ID->cellAttributes() ?>>
<span id="el_OBSTETRI_RAHIM_ID" data-page="3">
<span<?= $Page->RAHIM_ID->viewAttributes() ?>>
<?= $Page->RAHIM_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php if (!$Page->isExport()) { ?>
        </div>
<?php } ?>
<?php if (!$Page->isExport()) { ?>
    </div>
</div>
</div>
<?php } ?>
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
