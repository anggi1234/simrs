<?php

namespace PHPMaker2021\SIMRSSQLSERVER;

// Table
$PASIEN = Container("PASIEN");
?>
<?php if ($PASIEN->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_PASIENmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($PASIEN->ORG_UNIT_CODE->Visible) { // ORG_UNIT_CODE ?>
        <tr id="r_ORG_UNIT_CODE">
            <td class="<?= $PASIEN->TableLeftColumnClass ?>"><?= $PASIEN->ORG_UNIT_CODE->caption() ?></td>
            <td <?= $PASIEN->ORG_UNIT_CODE->cellAttributes() ?>>
<span id="el_PASIEN_ORG_UNIT_CODE">
<span<?= $PASIEN->ORG_UNIT_CODE->viewAttributes() ?>>
<?= $PASIEN->ORG_UNIT_CODE->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($PASIEN->NO_REGISTRATION->Visible) { // NO_REGISTRATION ?>
        <tr id="r_NO_REGISTRATION">
            <td class="<?= $PASIEN->TableLeftColumnClass ?>"><?= $PASIEN->NO_REGISTRATION->caption() ?></td>
            <td <?= $PASIEN->NO_REGISTRATION->cellAttributes() ?>>
<span id="el_PASIEN_NO_REGISTRATION">
<span<?= $PASIEN->NO_REGISTRATION->viewAttributes() ?>>
<?= $PASIEN->NO_REGISTRATION->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($PASIEN->NAME_OF_PASIEN->Visible) { // NAME_OF_PASIEN ?>
        <tr id="r_NAME_OF_PASIEN">
            <td class="<?= $PASIEN->TableLeftColumnClass ?>"><?= $PASIEN->NAME_OF_PASIEN->caption() ?></td>
            <td <?= $PASIEN->NAME_OF_PASIEN->cellAttributes() ?>>
<span id="el_PASIEN_NAME_OF_PASIEN">
<span<?= $PASIEN->NAME_OF_PASIEN->viewAttributes() ?>>
<?= $PASIEN->NAME_OF_PASIEN->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($PASIEN->KK_NO->Visible) { // KK_NO ?>
        <tr id="r_KK_NO">
            <td class="<?= $PASIEN->TableLeftColumnClass ?>"><?= $PASIEN->KK_NO->caption() ?></td>
            <td <?= $PASIEN->KK_NO->cellAttributes() ?>>
<span id="el_PASIEN_KK_NO">
<span<?= $PASIEN->KK_NO->viewAttributes() ?>>
<?= $PASIEN->KK_NO->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($PASIEN->GENDER->Visible) { // GENDER ?>
        <tr id="r_GENDER">
            <td class="<?= $PASIEN->TableLeftColumnClass ?>"><?= $PASIEN->GENDER->caption() ?></td>
            <td <?= $PASIEN->GENDER->cellAttributes() ?>>
<span id="el_PASIEN_GENDER">
<span<?= $PASIEN->GENDER->viewAttributes() ?>>
<?= $PASIEN->GENDER->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($PASIEN->STATUS_PASIEN_ID->Visible) { // STATUS_PASIEN_ID ?>
        <tr id="r_STATUS_PASIEN_ID">
            <td class="<?= $PASIEN->TableLeftColumnClass ?>"><?= $PASIEN->STATUS_PASIEN_ID->caption() ?></td>
            <td <?= $PASIEN->STATUS_PASIEN_ID->cellAttributes() ?>>
<span id="el_PASIEN_STATUS_PASIEN_ID">
<span<?= $PASIEN->STATUS_PASIEN_ID->viewAttributes() ?>>
<?= $PASIEN->STATUS_PASIEN_ID->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($PASIEN->REGISTRATION_DATE->Visible) { // REGISTRATION_DATE ?>
        <tr id="r_REGISTRATION_DATE">
            <td class="<?= $PASIEN->TableLeftColumnClass ?>"><?= $PASIEN->REGISTRATION_DATE->caption() ?></td>
            <td <?= $PASIEN->REGISTRATION_DATE->cellAttributes() ?>>
<span id="el_PASIEN_REGISTRATION_DATE">
<span<?= $PASIEN->REGISTRATION_DATE->viewAttributes() ?>>
<?= $PASIEN->REGISTRATION_DATE->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($PASIEN->_PASSWORD->Visible) { // PASSWORD ?>
        <tr id="r__PASSWORD">
            <td class="<?= $PASIEN->TableLeftColumnClass ?>"><?= $PASIEN->_PASSWORD->caption() ?></td>
            <td <?= $PASIEN->_PASSWORD->cellAttributes() ?>>
<span id="el_PASIEN__PASSWORD">
<span<?= $PASIEN->_PASSWORD->viewAttributes() ?>>
<?= $PASIEN->_PASSWORD->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
