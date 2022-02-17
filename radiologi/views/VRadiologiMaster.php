<?php

namespace PHPMaker2021\SIMRSSQLSERVERRADIOLOGI;

// Table
$V_RADIOLOGI = Container("V_RADIOLOGI");
?>
<?php if ($V_RADIOLOGI->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_V_RADIOLOGImaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($V_RADIOLOGI->NO_REGISTRATION->Visible) { // NO_REGISTRATION ?>
        <tr id="r_NO_REGISTRATION">
            <td class="<?= $V_RADIOLOGI->TableLeftColumnClass ?>"><?= $V_RADIOLOGI->NO_REGISTRATION->caption() ?></td>
            <td <?= $V_RADIOLOGI->NO_REGISTRATION->cellAttributes() ?>>
<span id="el_V_RADIOLOGI_NO_REGISTRATION">
<span<?= $V_RADIOLOGI->NO_REGISTRATION->viewAttributes() ?>>
<?= $V_RADIOLOGI->NO_REGISTRATION->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_RADIOLOGI->DIANTAR_OLEH->Visible) { // DIANTAR_OLEH ?>
        <tr id="r_DIANTAR_OLEH">
            <td class="<?= $V_RADIOLOGI->TableLeftColumnClass ?>"><?= $V_RADIOLOGI->DIANTAR_OLEH->caption() ?></td>
            <td <?= $V_RADIOLOGI->DIANTAR_OLEH->cellAttributes() ?>>
<span id="el_V_RADIOLOGI_DIANTAR_OLEH">
<span<?= $V_RADIOLOGI->DIANTAR_OLEH->viewAttributes() ?>>
<?= $V_RADIOLOGI->DIANTAR_OLEH->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_RADIOLOGI->VISIT_DATE->Visible) { // VISIT_DATE ?>
        <tr id="r_VISIT_DATE">
            <td class="<?= $V_RADIOLOGI->TableLeftColumnClass ?>"><?= $V_RADIOLOGI->VISIT_DATE->caption() ?></td>
            <td <?= $V_RADIOLOGI->VISIT_DATE->cellAttributes() ?>>
<span id="el_V_RADIOLOGI_VISIT_DATE">
<span<?= $V_RADIOLOGI->VISIT_DATE->viewAttributes() ?>>
<?= $V_RADIOLOGI->VISIT_DATE->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_RADIOLOGI->CLINIC_ID->Visible) { // CLINIC_ID ?>
        <tr id="r_CLINIC_ID">
            <td class="<?= $V_RADIOLOGI->TableLeftColumnClass ?>"><?= $V_RADIOLOGI->CLINIC_ID->caption() ?></td>
            <td <?= $V_RADIOLOGI->CLINIC_ID->cellAttributes() ?>>
<span id="el_V_RADIOLOGI_CLINIC_ID">
<span<?= $V_RADIOLOGI->CLINIC_ID->viewAttributes() ?>>
<?= $V_RADIOLOGI->CLINIC_ID->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_RADIOLOGI->GENDER->Visible) { // GENDER ?>
        <tr id="r_GENDER">
            <td class="<?= $V_RADIOLOGI->TableLeftColumnClass ?>"><?= $V_RADIOLOGI->GENDER->caption() ?></td>
            <td <?= $V_RADIOLOGI->GENDER->cellAttributes() ?>>
<span id="el_V_RADIOLOGI_GENDER">
<span<?= $V_RADIOLOGI->GENDER->viewAttributes() ?>>
<?= $V_RADIOLOGI->GENDER->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_RADIOLOGI->VISITOR_ADDRESS->Visible) { // VISITOR_ADDRESS ?>
        <tr id="r_VISITOR_ADDRESS">
            <td class="<?= $V_RADIOLOGI->TableLeftColumnClass ?>"><?= $V_RADIOLOGI->VISITOR_ADDRESS->caption() ?></td>
            <td <?= $V_RADIOLOGI->VISITOR_ADDRESS->cellAttributes() ?>>
<span id="el_V_RADIOLOGI_VISITOR_ADDRESS">
<span<?= $V_RADIOLOGI->VISITOR_ADDRESS->viewAttributes() ?>>
<?= $V_RADIOLOGI->VISITOR_ADDRESS->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_RADIOLOGI->EMPLOYEE_ID->Visible) { // EMPLOYEE_ID ?>
        <tr id="r_EMPLOYEE_ID">
            <td class="<?= $V_RADIOLOGI->TableLeftColumnClass ?>"><?= $V_RADIOLOGI->EMPLOYEE_ID->caption() ?></td>
            <td <?= $V_RADIOLOGI->EMPLOYEE_ID->cellAttributes() ?>>
<span id="el_V_RADIOLOGI_EMPLOYEE_ID">
<span<?= $V_RADIOLOGI->EMPLOYEE_ID->viewAttributes() ?>>
<?= $V_RADIOLOGI->EMPLOYEE_ID->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_RADIOLOGI->PAYOR_ID->Visible) { // PAYOR_ID ?>
        <tr id="r_PAYOR_ID">
            <td class="<?= $V_RADIOLOGI->TableLeftColumnClass ?>"><?= $V_RADIOLOGI->PAYOR_ID->caption() ?></td>
            <td <?= $V_RADIOLOGI->PAYOR_ID->cellAttributes() ?>>
<span id="el_V_RADIOLOGI_PAYOR_ID">
<span<?= $V_RADIOLOGI->PAYOR_ID->viewAttributes() ?>>
<?= $V_RADIOLOGI->PAYOR_ID->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_RADIOLOGI->CLASS_ID->Visible) { // CLASS_ID ?>
        <tr id="r_CLASS_ID">
            <td class="<?= $V_RADIOLOGI->TableLeftColumnClass ?>"><?= $V_RADIOLOGI->CLASS_ID->caption() ?></td>
            <td <?= $V_RADIOLOGI->CLASS_ID->cellAttributes() ?>>
<span id="el_V_RADIOLOGI_CLASS_ID">
<span<?= $V_RADIOLOGI->CLASS_ID->viewAttributes() ?>>
<?= $V_RADIOLOGI->CLASS_ID->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_RADIOLOGI->PASIEN_ID->Visible) { // PASIEN_ID ?>
        <tr id="r_PASIEN_ID">
            <td class="<?= $V_RADIOLOGI->TableLeftColumnClass ?>"><?= $V_RADIOLOGI->PASIEN_ID->caption() ?></td>
            <td <?= $V_RADIOLOGI->PASIEN_ID->cellAttributes() ?>>
<span id="el_V_RADIOLOGI_PASIEN_ID">
<span<?= $V_RADIOLOGI->PASIEN_ID->viewAttributes() ?>>
<?= $V_RADIOLOGI->PASIEN_ID->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_RADIOLOGI->AGEYEAR->Visible) { // AGEYEAR ?>
        <tr id="r_AGEYEAR">
            <td class="<?= $V_RADIOLOGI->TableLeftColumnClass ?>"><?= $V_RADIOLOGI->AGEYEAR->caption() ?></td>
            <td <?= $V_RADIOLOGI->AGEYEAR->cellAttributes() ?>>
<span id="el_V_RADIOLOGI_AGEYEAR">
<span<?= $V_RADIOLOGI->AGEYEAR->viewAttributes() ?>>
<?= $V_RADIOLOGI->AGEYEAR->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
