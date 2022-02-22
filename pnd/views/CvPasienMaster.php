<?php

namespace PHPMaker2021\SIMRSSQLSERVERPENDAFTARAN;

// Table
$CV_PASIEN = Container("CV_PASIEN");
?>
<?php if ($CV_PASIEN->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_CV_PASIENmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($CV_PASIEN->NO_REGISTRATION->Visible) { // NO_REGISTRATION ?>
        <tr id="r_NO_REGISTRATION">
            <td class="<?= $CV_PASIEN->TableLeftColumnClass ?>"><?= $CV_PASIEN->NO_REGISTRATION->caption() ?></td>
            <td <?= $CV_PASIEN->NO_REGISTRATION->cellAttributes() ?>>
<span id="el_CV_PASIEN_NO_REGISTRATION">
<span<?= $CV_PASIEN->NO_REGISTRATION->viewAttributes() ?>>
<?= $CV_PASIEN->NO_REGISTRATION->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($CV_PASIEN->NAME_OF_PASIEN->Visible) { // NAME_OF_PASIEN ?>
        <tr id="r_NAME_OF_PASIEN">
            <td class="<?= $CV_PASIEN->TableLeftColumnClass ?>"><?= $CV_PASIEN->NAME_OF_PASIEN->caption() ?></td>
            <td <?= $CV_PASIEN->NAME_OF_PASIEN->cellAttributes() ?>>
<span id="el_CV_PASIEN_NAME_OF_PASIEN">
<span<?= $CV_PASIEN->NAME_OF_PASIEN->viewAttributes() ?>>
<?= $CV_PASIEN->NAME_OF_PASIEN->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($CV_PASIEN->PASIEN_ID->Visible) { // PASIEN_ID ?>
        <tr id="r_PASIEN_ID">
            <td class="<?= $CV_PASIEN->TableLeftColumnClass ?>"><?= $CV_PASIEN->PASIEN_ID->caption() ?></td>
            <td <?= $CV_PASIEN->PASIEN_ID->cellAttributes() ?>>
<span id="el_CV_PASIEN_PASIEN_ID">
<span<?= $CV_PASIEN->PASIEN_ID->viewAttributes() ?>>
<?= $CV_PASIEN->PASIEN_ID->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($CV_PASIEN->KK_NO->Visible) { // KK_NO ?>
        <tr id="r_KK_NO">
            <td class="<?= $CV_PASIEN->TableLeftColumnClass ?>"><?= $CV_PASIEN->KK_NO->caption() ?></td>
            <td <?= $CV_PASIEN->KK_NO->cellAttributes() ?>>
<span id="el_CV_PASIEN_KK_NO">
<span<?= $CV_PASIEN->KK_NO->viewAttributes() ?>>
<?= $CV_PASIEN->KK_NO->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($CV_PASIEN->GENDER->Visible) { // GENDER ?>
        <tr id="r_GENDER">
            <td class="<?= $CV_PASIEN->TableLeftColumnClass ?>"><?= $CV_PASIEN->GENDER->caption() ?></td>
            <td <?= $CV_PASIEN->GENDER->cellAttributes() ?>>
<span id="el_CV_PASIEN_GENDER">
<span<?= $CV_PASIEN->GENDER->viewAttributes() ?>>
<?= $CV_PASIEN->GENDER->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($CV_PASIEN->STATUS_PASIEN_ID->Visible) { // STATUS_PASIEN_ID ?>
        <tr id="r_STATUS_PASIEN_ID">
            <td class="<?= $CV_PASIEN->TableLeftColumnClass ?>"><?= $CV_PASIEN->STATUS_PASIEN_ID->caption() ?></td>
            <td <?= $CV_PASIEN->STATUS_PASIEN_ID->cellAttributes() ?>>
<span id="el_CV_PASIEN_STATUS_PASIEN_ID">
<span<?= $CV_PASIEN->STATUS_PASIEN_ID->viewAttributes() ?>>
<?= $CV_PASIEN->STATUS_PASIEN_ID->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($CV_PASIEN->CONTACT_ADDRESS->Visible) { // CONTACT_ADDRESS ?>
        <tr id="r_CONTACT_ADDRESS">
            <td class="<?= $CV_PASIEN->TableLeftColumnClass ?>"><?= $CV_PASIEN->CONTACT_ADDRESS->caption() ?></td>
            <td <?= $CV_PASIEN->CONTACT_ADDRESS->cellAttributes() ?>>
<span id="el_CV_PASIEN_CONTACT_ADDRESS">
<span<?= $CV_PASIEN->CONTACT_ADDRESS->viewAttributes() ?>>
<?= $CV_PASIEN->CONTACT_ADDRESS->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($CV_PASIEN->REGISTRATION_DATE->Visible) { // REGISTRATION_DATE ?>
        <tr id="r_REGISTRATION_DATE">
            <td class="<?= $CV_PASIEN->TableLeftColumnClass ?>"><?= $CV_PASIEN->REGISTRATION_DATE->caption() ?></td>
            <td <?= $CV_PASIEN->REGISTRATION_DATE->cellAttributes() ?>>
<span id="el_CV_PASIEN_REGISTRATION_DATE">
<span<?= $CV_PASIEN->REGISTRATION_DATE->viewAttributes() ?>>
<?= $CV_PASIEN->REGISTRATION_DATE->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($CV_PASIEN->MOTHER->Visible) { // MOTHER ?>
        <tr id="r_MOTHER">
            <td class="<?= $CV_PASIEN->TableLeftColumnClass ?>"><?= $CV_PASIEN->MOTHER->caption() ?></td>
            <td <?= $CV_PASIEN->MOTHER->cellAttributes() ?>>
<span id="el_CV_PASIEN_MOTHER">
<span<?= $CV_PASIEN->MOTHER->viewAttributes() ?>>
<?= $CV_PASIEN->MOTHER->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($CV_PASIEN->FATHER->Visible) { // FATHER ?>
        <tr id="r_FATHER">
            <td class="<?= $CV_PASIEN->TableLeftColumnClass ?>"><?= $CV_PASIEN->FATHER->caption() ?></td>
            <td <?= $CV_PASIEN->FATHER->cellAttributes() ?>>
<span id="el_CV_PASIEN_FATHER">
<span<?= $CV_PASIEN->FATHER->viewAttributes() ?>>
<?= $CV_PASIEN->FATHER->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($CV_PASIEN->SPOUSE->Visible) { // SPOUSE ?>
        <tr id="r_SPOUSE">
            <td class="<?= $CV_PASIEN->TableLeftColumnClass ?>"><?= $CV_PASIEN->SPOUSE->caption() ?></td>
            <td <?= $CV_PASIEN->SPOUSE->cellAttributes() ?>>
<span id="el_CV_PASIEN_SPOUSE">
<span<?= $CV_PASIEN->SPOUSE->viewAttributes() ?>>
<?= $CV_PASIEN->SPOUSE->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
