<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

// Table
$V_KUNJUNGAN_PASIEN = Container("V_KUNJUNGAN_PASIEN");
?>
<?php if ($V_KUNJUNGAN_PASIEN->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_V_KUNJUNGAN_PASIENmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($V_KUNJUNGAN_PASIEN->NO_REGISTRATION->Visible) { // NO_REGISTRATION ?>
        <tr id="r_NO_REGISTRATION">
            <td class="<?= $V_KUNJUNGAN_PASIEN->TableLeftColumnClass ?>"><?= $V_KUNJUNGAN_PASIEN->NO_REGISTRATION->caption() ?></td>
            <td <?= $V_KUNJUNGAN_PASIEN->NO_REGISTRATION->cellAttributes() ?>>
<span id="el_V_KUNJUNGAN_PASIEN_NO_REGISTRATION">
<span<?= $V_KUNJUNGAN_PASIEN->NO_REGISTRATION->viewAttributes() ?>>
<?= $V_KUNJUNGAN_PASIEN->NO_REGISTRATION->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_KUNJUNGAN_PASIEN->DIANTAR_OLEH->Visible) { // DIANTAR_OLEH ?>
        <tr id="r_DIANTAR_OLEH">
            <td class="<?= $V_KUNJUNGAN_PASIEN->TableLeftColumnClass ?>"><?= $V_KUNJUNGAN_PASIEN->DIANTAR_OLEH->caption() ?></td>
            <td <?= $V_KUNJUNGAN_PASIEN->DIANTAR_OLEH->cellAttributes() ?>>
<span id="el_V_KUNJUNGAN_PASIEN_DIANTAR_OLEH">
<span<?= $V_KUNJUNGAN_PASIEN->DIANTAR_OLEH->viewAttributes() ?>>
<?= $V_KUNJUNGAN_PASIEN->DIANTAR_OLEH->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_KUNJUNGAN_PASIEN->GENDER->Visible) { // GENDER ?>
        <tr id="r_GENDER">
            <td class="<?= $V_KUNJUNGAN_PASIEN->TableLeftColumnClass ?>"><?= $V_KUNJUNGAN_PASIEN->GENDER->caption() ?></td>
            <td <?= $V_KUNJUNGAN_PASIEN->GENDER->cellAttributes() ?>>
<span id="el_V_KUNJUNGAN_PASIEN_GENDER">
<span<?= $V_KUNJUNGAN_PASIEN->GENDER->viewAttributes() ?>>
<?= $V_KUNJUNGAN_PASIEN->GENDER->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_KUNJUNGAN_PASIEN->STATUS_PASIEN_ID->Visible) { // STATUS_PASIEN_ID ?>
        <tr id="r_STATUS_PASIEN_ID">
            <td class="<?= $V_KUNJUNGAN_PASIEN->TableLeftColumnClass ?>"><?= $V_KUNJUNGAN_PASIEN->STATUS_PASIEN_ID->caption() ?></td>
            <td <?= $V_KUNJUNGAN_PASIEN->STATUS_PASIEN_ID->cellAttributes() ?>>
<span id="el_V_KUNJUNGAN_PASIEN_STATUS_PASIEN_ID">
<span<?= $V_KUNJUNGAN_PASIEN->STATUS_PASIEN_ID->viewAttributes() ?>>
<?= $V_KUNJUNGAN_PASIEN->STATUS_PASIEN_ID->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_KUNJUNGAN_PASIEN->CLINIC_ID->Visible) { // CLINIC_ID ?>
        <tr id="r_CLINIC_ID">
            <td class="<?= $V_KUNJUNGAN_PASIEN->TableLeftColumnClass ?>"><?= $V_KUNJUNGAN_PASIEN->CLINIC_ID->caption() ?></td>
            <td <?= $V_KUNJUNGAN_PASIEN->CLINIC_ID->cellAttributes() ?>>
<span id="el_V_KUNJUNGAN_PASIEN_CLINIC_ID">
<span<?= $V_KUNJUNGAN_PASIEN->CLINIC_ID->viewAttributes() ?>>
<?= $V_KUNJUNGAN_PASIEN->CLINIC_ID->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_KUNJUNGAN_PASIEN->CLINIC_ID_FROM->Visible) { // CLINIC_ID_FROM ?>
        <tr id="r_CLINIC_ID_FROM">
            <td class="<?= $V_KUNJUNGAN_PASIEN->TableLeftColumnClass ?>"><?= $V_KUNJUNGAN_PASIEN->CLINIC_ID_FROM->caption() ?></td>
            <td <?= $V_KUNJUNGAN_PASIEN->CLINIC_ID_FROM->cellAttributes() ?>>
<span id="el_V_KUNJUNGAN_PASIEN_CLINIC_ID_FROM">
<span<?= $V_KUNJUNGAN_PASIEN->CLINIC_ID_FROM->viewAttributes() ?>>
<?= $V_KUNJUNGAN_PASIEN->CLINIC_ID_FROM->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_KUNJUNGAN_PASIEN->VISIT_DATE->Visible) { // VISIT_DATE ?>
        <tr id="r_VISIT_DATE">
            <td class="<?= $V_KUNJUNGAN_PASIEN->TableLeftColumnClass ?>"><?= $V_KUNJUNGAN_PASIEN->VISIT_DATE->caption() ?></td>
            <td <?= $V_KUNJUNGAN_PASIEN->VISIT_DATE->cellAttributes() ?>>
<span id="el_V_KUNJUNGAN_PASIEN_VISIT_DATE">
<span<?= $V_KUNJUNGAN_PASIEN->VISIT_DATE->viewAttributes() ?>>
<?= $V_KUNJUNGAN_PASIEN->VISIT_DATE->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_KUNJUNGAN_PASIEN->tgl_kontrol->Visible) { // tgl_kontrol ?>
        <tr id="r_tgl_kontrol">
            <td class="<?= $V_KUNJUNGAN_PASIEN->TableLeftColumnClass ?>"><?= $V_KUNJUNGAN_PASIEN->tgl_kontrol->caption() ?></td>
            <td <?= $V_KUNJUNGAN_PASIEN->tgl_kontrol->cellAttributes() ?>>
<span id="el_V_KUNJUNGAN_PASIEN_tgl_kontrol">
<span<?= $V_KUNJUNGAN_PASIEN->tgl_kontrol->viewAttributes() ?>>
<?= $V_KUNJUNGAN_PASIEN->tgl_kontrol->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
