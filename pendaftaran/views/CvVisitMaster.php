<?php

namespace PHPMaker2021\SIMRSSQLSERVER;

// Table
$cv_visit = Container("cv_visit");
?>
<?php if ($cv_visit->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_cv_visitmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($cv_visit->NO_REGISTRATION->Visible) { // NO_REGISTRATION ?>
        <tr id="r_NO_REGISTRATION">
            <td class="<?= $cv_visit->TableLeftColumnClass ?>"><?= $cv_visit->NO_REGISTRATION->caption() ?></td>
            <td <?= $cv_visit->NO_REGISTRATION->cellAttributes() ?>>
<span id="el_cv_visit_NO_REGISTRATION">
<span<?= $cv_visit->NO_REGISTRATION->viewAttributes() ?>>
<?= $cv_visit->NO_REGISTRATION->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($cv_visit->VISIT_DATE->Visible) { // VISIT_DATE ?>
        <tr id="r_VISIT_DATE">
            <td class="<?= $cv_visit->TableLeftColumnClass ?>"><?= $cv_visit->VISIT_DATE->caption() ?></td>
            <td <?= $cv_visit->VISIT_DATE->cellAttributes() ?>>
<span id="el_cv_visit_VISIT_DATE">
<span<?= $cv_visit->VISIT_DATE->viewAttributes() ?>>
<?= $cv_visit->VISIT_DATE->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($cv_visit->CLINIC_ID->Visible) { // CLINIC_ID ?>
        <tr id="r_CLINIC_ID">
            <td class="<?= $cv_visit->TableLeftColumnClass ?>"><?= $cv_visit->CLINIC_ID->caption() ?></td>
            <td <?= $cv_visit->CLINIC_ID->cellAttributes() ?>>
<span id="el_cv_visit_CLINIC_ID">
<span<?= $cv_visit->CLINIC_ID->viewAttributes() ?>>
<?= $cv_visit->CLINIC_ID->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($cv_visit->GENDER->Visible) { // GENDER ?>
        <tr id="r_GENDER">
            <td class="<?= $cv_visit->TableLeftColumnClass ?>"><?= $cv_visit->GENDER->caption() ?></td>
            <td <?= $cv_visit->GENDER->cellAttributes() ?>>
<span id="el_cv_visit_GENDER">
<span<?= $cv_visit->GENDER->viewAttributes() ?>>
<?= $cv_visit->GENDER->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($cv_visit->EMPLOYEE_ID->Visible) { // EMPLOYEE_ID ?>
        <tr id="r_EMPLOYEE_ID">
            <td class="<?= $cv_visit->TableLeftColumnClass ?>"><?= $cv_visit->EMPLOYEE_ID->caption() ?></td>
            <td <?= $cv_visit->EMPLOYEE_ID->cellAttributes() ?>>
<span id="el_cv_visit_EMPLOYEE_ID">
<span<?= $cv_visit->EMPLOYEE_ID->viewAttributes() ?>>
<?= $cv_visit->EMPLOYEE_ID->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($cv_visit->PAYOR_ID->Visible) { // PAYOR_ID ?>
        <tr id="r_PAYOR_ID">
            <td class="<?= $cv_visit->TableLeftColumnClass ?>"><?= $cv_visit->PAYOR_ID->caption() ?></td>
            <td <?= $cv_visit->PAYOR_ID->cellAttributes() ?>>
<span id="el_cv_visit_PAYOR_ID">
<span<?= $cv_visit->PAYOR_ID->viewAttributes() ?>>
<?= $cv_visit->PAYOR_ID->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($cv_visit->CLASS_ID->Visible) { // CLASS_ID ?>
        <tr id="r_CLASS_ID">
            <td class="<?= $cv_visit->TableLeftColumnClass ?>"><?= $cv_visit->CLASS_ID->caption() ?></td>
            <td <?= $cv_visit->CLASS_ID->cellAttributes() ?>>
<span id="el_cv_visit_CLASS_ID">
<span<?= $cv_visit->CLASS_ID->viewAttributes() ?>>
<?= $cv_visit->CLASS_ID->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($cv_visit->PASIEN_ID->Visible) { // PASIEN_ID ?>
        <tr id="r_PASIEN_ID">
            <td class="<?= $cv_visit->TableLeftColumnClass ?>"><?= $cv_visit->PASIEN_ID->caption() ?></td>
            <td <?= $cv_visit->PASIEN_ID->cellAttributes() ?>>
<span id="el_cv_visit_PASIEN_ID">
<span<?= $cv_visit->PASIEN_ID->viewAttributes() ?>>
<?= $cv_visit->PASIEN_ID->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($cv_visit->AGEYEAR->Visible) { // AGEYEAR ?>
        <tr id="r_AGEYEAR">
            <td class="<?= $cv_visit->TableLeftColumnClass ?>"><?= $cv_visit->AGEYEAR->caption() ?></td>
            <td <?= $cv_visit->AGEYEAR->cellAttributes() ?>>
<span id="el_cv_visit_AGEYEAR">
<span<?= $cv_visit->AGEYEAR->viewAttributes() ?>>
<?= $cv_visit->AGEYEAR->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
