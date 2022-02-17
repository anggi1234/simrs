<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

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
<?php if ($V_REKAM_MEDIS->EMPLOYEE_ID->Visible) { // EMPLOYEE_ID ?>
        <tr id="r_EMPLOYEE_ID">
            <td class="<?= $V_REKAM_MEDIS->TableLeftColumnClass ?>"><?= $V_REKAM_MEDIS->EMPLOYEE_ID->caption() ?></td>
            <td <?= $V_REKAM_MEDIS->EMPLOYEE_ID->cellAttributes() ?>>
<span id="el_V_REKAM_MEDIS_EMPLOYEE_ID">
<span<?= $V_REKAM_MEDIS->EMPLOYEE_ID->viewAttributes() ?>>
<?= $V_REKAM_MEDIS->EMPLOYEE_ID->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_REKAM_MEDIS->PAYOR_ID->Visible) { // PAYOR_ID ?>
        <tr id="r_PAYOR_ID">
            <td class="<?= $V_REKAM_MEDIS->TableLeftColumnClass ?>"><?= $V_REKAM_MEDIS->PAYOR_ID->caption() ?></td>
            <td <?= $V_REKAM_MEDIS->PAYOR_ID->cellAttributes() ?>>
<span id="el_V_REKAM_MEDIS_PAYOR_ID">
<span<?= $V_REKAM_MEDIS->PAYOR_ID->viewAttributes() ?>>
<?= $V_REKAM_MEDIS->PAYOR_ID->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_REKAM_MEDIS->CLASS_ID->Visible) { // CLASS_ID ?>
        <tr id="r_CLASS_ID">
            <td class="<?= $V_REKAM_MEDIS->TableLeftColumnClass ?>"><?= $V_REKAM_MEDIS->CLASS_ID->caption() ?></td>
            <td <?= $V_REKAM_MEDIS->CLASS_ID->cellAttributes() ?>>
<span id="el_V_REKAM_MEDIS_CLASS_ID">
<span<?= $V_REKAM_MEDIS->CLASS_ID->viewAttributes() ?>>
<?= $V_REKAM_MEDIS->CLASS_ID->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_REKAM_MEDIS->PASIEN_ID->Visible) { // PASIEN_ID ?>
        <tr id="r_PASIEN_ID">
            <td class="<?= $V_REKAM_MEDIS->TableLeftColumnClass ?>"><?= $V_REKAM_MEDIS->PASIEN_ID->caption() ?></td>
            <td <?= $V_REKAM_MEDIS->PASIEN_ID->cellAttributes() ?>>
<span id="el_V_REKAM_MEDIS_PASIEN_ID">
<span<?= $V_REKAM_MEDIS->PASIEN_ID->viewAttributes() ?>>
<?= $V_REKAM_MEDIS->PASIEN_ID->getViewValue() ?></span>
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
<?php if ($V_REKAM_MEDIS->ISRJ->Visible) { // ISRJ ?>
        <tr id="r_ISRJ">
            <td class="<?= $V_REKAM_MEDIS->TableLeftColumnClass ?>"><?= $V_REKAM_MEDIS->ISRJ->caption() ?></td>
            <td <?= $V_REKAM_MEDIS->ISRJ->cellAttributes() ?>>
<span id="el_V_REKAM_MEDIS_ISRJ">
<span<?= $V_REKAM_MEDIS->ISRJ->viewAttributes() ?>>
<?= $V_REKAM_MEDIS->ISRJ->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_REKAM_MEDIS->tgl_kontrol->Visible) { // tgl_kontrol ?>
        <tr id="r_tgl_kontrol">
            <td class="<?= $V_REKAM_MEDIS->TableLeftColumnClass ?>"><?= $V_REKAM_MEDIS->tgl_kontrol->caption() ?></td>
            <td <?= $V_REKAM_MEDIS->tgl_kontrol->cellAttributes() ?>>
<span id="el_V_REKAM_MEDIS_tgl_kontrol">
<span<?= $V_REKAM_MEDIS->tgl_kontrol->viewAttributes() ?>>
<?= $V_REKAM_MEDIS->tgl_kontrol->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
