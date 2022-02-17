<?php

namespace PHPMaker2021\ONLINEBARU;

// Table
$V_RAWAT_INAP = Container("V_RAWAT_INAP");
?>
<?php if ($V_RAWAT_INAP->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_V_RAWAT_INAPmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($V_RAWAT_INAP->NO_REGISTRATION->Visible) { // NO_REGISTRATION ?>
        <tr id="r_NO_REGISTRATION">
            <td class="<?= $V_RAWAT_INAP->TableLeftColumnClass ?>"><?= $V_RAWAT_INAP->NO_REGISTRATION->caption() ?></td>
            <td <?= $V_RAWAT_INAP->NO_REGISTRATION->cellAttributes() ?>>
<span id="el_V_RAWAT_INAP_NO_REGISTRATION">
<span<?= $V_RAWAT_INAP->NO_REGISTRATION->viewAttributes() ?>>
<?= $V_RAWAT_INAP->NO_REGISTRATION->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_RAWAT_INAP->VISIT_DATE->Visible) { // VISIT_DATE ?>
        <tr id="r_VISIT_DATE">
            <td class="<?= $V_RAWAT_INAP->TableLeftColumnClass ?>"><?= $V_RAWAT_INAP->VISIT_DATE->caption() ?></td>
            <td <?= $V_RAWAT_INAP->VISIT_DATE->cellAttributes() ?>>
<span id="el_V_RAWAT_INAP_VISIT_DATE">
<span<?= $V_RAWAT_INAP->VISIT_DATE->viewAttributes() ?>>
<?= $V_RAWAT_INAP->VISIT_DATE->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_RAWAT_INAP->CLINIC_ID->Visible) { // CLINIC_ID ?>
        <tr id="r_CLINIC_ID">
            <td class="<?= $V_RAWAT_INAP->TableLeftColumnClass ?>"><?= $V_RAWAT_INAP->CLINIC_ID->caption() ?></td>
            <td <?= $V_RAWAT_INAP->CLINIC_ID->cellAttributes() ?>>
<span id="el_V_RAWAT_INAP_CLINIC_ID">
<span<?= $V_RAWAT_INAP->CLINIC_ID->viewAttributes() ?>>
<?= $V_RAWAT_INAP->CLINIC_ID->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_RAWAT_INAP->GENDER->Visible) { // GENDER ?>
        <tr id="r_GENDER">
            <td class="<?= $V_RAWAT_INAP->TableLeftColumnClass ?>"><?= $V_RAWAT_INAP->GENDER->caption() ?></td>
            <td <?= $V_RAWAT_INAP->GENDER->cellAttributes() ?>>
<span id="el_V_RAWAT_INAP_GENDER">
<span<?= $V_RAWAT_INAP->GENDER->viewAttributes() ?>>
<?= $V_RAWAT_INAP->GENDER->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_RAWAT_INAP->EMPLOYEE_ID->Visible) { // EMPLOYEE_ID ?>
        <tr id="r_EMPLOYEE_ID">
            <td class="<?= $V_RAWAT_INAP->TableLeftColumnClass ?>"><?= $V_RAWAT_INAP->EMPLOYEE_ID->caption() ?></td>
            <td <?= $V_RAWAT_INAP->EMPLOYEE_ID->cellAttributes() ?>>
<span id="el_V_RAWAT_INAP_EMPLOYEE_ID">
<span<?= $V_RAWAT_INAP->EMPLOYEE_ID->viewAttributes() ?>>
<?= $V_RAWAT_INAP->EMPLOYEE_ID->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_RAWAT_INAP->PAYOR_ID->Visible) { // PAYOR_ID ?>
        <tr id="r_PAYOR_ID">
            <td class="<?= $V_RAWAT_INAP->TableLeftColumnClass ?>"><?= $V_RAWAT_INAP->PAYOR_ID->caption() ?></td>
            <td <?= $V_RAWAT_INAP->PAYOR_ID->cellAttributes() ?>>
<span id="el_V_RAWAT_INAP_PAYOR_ID">
<span<?= $V_RAWAT_INAP->PAYOR_ID->viewAttributes() ?>>
<?= $V_RAWAT_INAP->PAYOR_ID->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_RAWAT_INAP->CLASS_ID->Visible) { // CLASS_ID ?>
        <tr id="r_CLASS_ID">
            <td class="<?= $V_RAWAT_INAP->TableLeftColumnClass ?>"><?= $V_RAWAT_INAP->CLASS_ID->caption() ?></td>
            <td <?= $V_RAWAT_INAP->CLASS_ID->cellAttributes() ?>>
<span id="el_V_RAWAT_INAP_CLASS_ID">
<span<?= $V_RAWAT_INAP->CLASS_ID->viewAttributes() ?>>
<?= $V_RAWAT_INAP->CLASS_ID->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_RAWAT_INAP->PASIEN_ID->Visible) { // PASIEN_ID ?>
        <tr id="r_PASIEN_ID">
            <td class="<?= $V_RAWAT_INAP->TableLeftColumnClass ?>"><?= $V_RAWAT_INAP->PASIEN_ID->caption() ?></td>
            <td <?= $V_RAWAT_INAP->PASIEN_ID->cellAttributes() ?>>
<span id="el_V_RAWAT_INAP_PASIEN_ID">
<span<?= $V_RAWAT_INAP->PASIEN_ID->viewAttributes() ?>>
<?= $V_RAWAT_INAP->PASIEN_ID->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
