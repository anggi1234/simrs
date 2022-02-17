<?php

namespace PHPMaker2021\SIMRSSQLSERVERREKAMMEDIK;

// Table
$V_REKAM_MEDIS = Container("V_REKAM_MEDIS");
?>
<?php if ($V_REKAM_MEDIS->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_V_REKAM_MEDISmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($V_REKAM_MEDIS->NO_REGISTRATION->Visible) { // NO_REGISTRATION ?>
        <tr id="r_NO_REGISTRATION">
            <td class="<?= $V_REKAM_MEDIS->TableLeftColumnClass ?>"><?= $V_REKAM_MEDIS->NO_REGISTRATION->caption() ?></td>
            <td <?= $V_REKAM_MEDIS->NO_REGISTRATION->cellAttributes() ?>>
<span id="el_V_REKAM_MEDIS_NO_REGISTRATION">
<span<?= $V_REKAM_MEDIS->NO_REGISTRATION->viewAttributes() ?>>
<?= $V_REKAM_MEDIS->NO_REGISTRATION->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_REKAM_MEDIS->DIANTAR_OLEH->Visible) { // DIANTAR_OLEH ?>
        <tr id="r_DIANTAR_OLEH">
            <td class="<?= $V_REKAM_MEDIS->TableLeftColumnClass ?>"><?= $V_REKAM_MEDIS->DIANTAR_OLEH->caption() ?></td>
            <td <?= $V_REKAM_MEDIS->DIANTAR_OLEH->cellAttributes() ?>>
<span id="el_V_REKAM_MEDIS_DIANTAR_OLEH">
<span<?= $V_REKAM_MEDIS->DIANTAR_OLEH->viewAttributes() ?>>
<?= $V_REKAM_MEDIS->DIANTAR_OLEH->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_REKAM_MEDIS->GENDER->Visible) { // GENDER ?>
        <tr id="r_GENDER">
            <td class="<?= $V_REKAM_MEDIS->TableLeftColumnClass ?>"><?= $V_REKAM_MEDIS->GENDER->caption() ?></td>
            <td <?= $V_REKAM_MEDIS->GENDER->cellAttributes() ?>>
<span id="el_V_REKAM_MEDIS_GENDER">
<span<?= $V_REKAM_MEDIS->GENDER->viewAttributes() ?>>
<?= $V_REKAM_MEDIS->GENDER->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_REKAM_MEDIS->VISITOR_ADDRESS->Visible) { // VISITOR_ADDRESS ?>
        <tr id="r_VISITOR_ADDRESS">
            <td class="<?= $V_REKAM_MEDIS->TableLeftColumnClass ?>"><?= $V_REKAM_MEDIS->VISITOR_ADDRESS->caption() ?></td>
            <td <?= $V_REKAM_MEDIS->VISITOR_ADDRESS->cellAttributes() ?>>
<span id="el_V_REKAM_MEDIS_VISITOR_ADDRESS">
<span<?= $V_REKAM_MEDIS->VISITOR_ADDRESS->viewAttributes() ?>>
<?= $V_REKAM_MEDIS->VISITOR_ADDRESS->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_REKAM_MEDIS->AGEYEAR->Visible) { // AGEYEAR ?>
        <tr id="r_AGEYEAR">
            <td class="<?= $V_REKAM_MEDIS->TableLeftColumnClass ?>"><?= $V_REKAM_MEDIS->AGEYEAR->caption() ?></td>
            <td <?= $V_REKAM_MEDIS->AGEYEAR->cellAttributes() ?>>
<span id="el_V_REKAM_MEDIS_AGEYEAR">
<span<?= $V_REKAM_MEDIS->AGEYEAR->viewAttributes() ?>>
<?= $V_REKAM_MEDIS->AGEYEAR->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_REKAM_MEDIS->STATUS_PASIEN_ID->Visible) { // STATUS_PASIEN_ID ?>
        <tr id="r_STATUS_PASIEN_ID">
            <td class="<?= $V_REKAM_MEDIS->TableLeftColumnClass ?>"><?= $V_REKAM_MEDIS->STATUS_PASIEN_ID->caption() ?></td>
            <td <?= $V_REKAM_MEDIS->STATUS_PASIEN_ID->cellAttributes() ?>>
<span id="el_V_REKAM_MEDIS_STATUS_PASIEN_ID">
<span<?= $V_REKAM_MEDIS->STATUS_PASIEN_ID->viewAttributes() ?>>
<?= $V_REKAM_MEDIS->STATUS_PASIEN_ID->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_REKAM_MEDIS->VISIT_DATE->Visible) { // VISIT_DATE ?>
        <tr id="r_VISIT_DATE">
            <td class="<?= $V_REKAM_MEDIS->TableLeftColumnClass ?>"><?= $V_REKAM_MEDIS->VISIT_DATE->caption() ?></td>
            <td <?= $V_REKAM_MEDIS->VISIT_DATE->cellAttributes() ?>>
<span id="el_V_REKAM_MEDIS_VISIT_DATE">
<span<?= $V_REKAM_MEDIS->VISIT_DATE->viewAttributes() ?>>
<?= $V_REKAM_MEDIS->VISIT_DATE->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_REKAM_MEDIS->CLINIC_ID->Visible) { // CLINIC_ID ?>
        <tr id="r_CLINIC_ID">
            <td class="<?= $V_REKAM_MEDIS->TableLeftColumnClass ?>"><?= $V_REKAM_MEDIS->CLINIC_ID->caption() ?></td>
            <td <?= $V_REKAM_MEDIS->CLINIC_ID->cellAttributes() ?>>
<span id="el_V_REKAM_MEDIS_CLINIC_ID">
<span<?= $V_REKAM_MEDIS->CLINIC_ID->viewAttributes() ?>>
<?= $V_REKAM_MEDIS->CLINIC_ID->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_REKAM_MEDIS->KELUAR_ID->Visible) { // KELUAR_ID ?>
        <tr id="r_KELUAR_ID">
            <td class="<?= $V_REKAM_MEDIS->TableLeftColumnClass ?>"><?= $V_REKAM_MEDIS->KELUAR_ID->caption() ?></td>
            <td <?= $V_REKAM_MEDIS->KELUAR_ID->cellAttributes() ?>>
<span id="el_V_REKAM_MEDIS_KELUAR_ID">
<span<?= $V_REKAM_MEDIS->KELUAR_ID->viewAttributes() ?>>
<?= $V_REKAM_MEDIS->KELUAR_ID->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_REKAM_MEDIS->EXIT_DATE->Visible) { // EXIT_DATE ?>
        <tr id="r_EXIT_DATE">
            <td class="<?= $V_REKAM_MEDIS->TableLeftColumnClass ?>"><?= $V_REKAM_MEDIS->EXIT_DATE->caption() ?></td>
            <td <?= $V_REKAM_MEDIS->EXIT_DATE->cellAttributes() ?>>
<span id="el_V_REKAM_MEDIS_EXIT_DATE">
<span<?= $V_REKAM_MEDIS->EXIT_DATE->viewAttributes() ?>>
<?= $V_REKAM_MEDIS->EXIT_DATE->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
