<?php

namespace PHPMaker2021\SIMRSSQLSERVER;

// Table
$TREATMENT_BILL = Container("TREATMENT_BILL");
?>
<?php if ($TREATMENT_BILL->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_TREATMENT_BILLmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($TREATMENT_BILL->NOTA_NO->Visible) { // NOTA_NO ?>
        <tr id="r_NOTA_NO">
            <td class="<?= $TREATMENT_BILL->TableLeftColumnClass ?>"><?= $TREATMENT_BILL->NOTA_NO->caption() ?></td>
            <td <?= $TREATMENT_BILL->NOTA_NO->cellAttributes() ?>>
<span id="el_TREATMENT_BILL_NOTA_NO">
<span<?= $TREATMENT_BILL->NOTA_NO->viewAttributes() ?>>
<?= $TREATMENT_BILL->NOTA_NO->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($TREATMENT_BILL->TARIF_ID->Visible) { // TARIF_ID ?>
        <tr id="r_TARIF_ID">
            <td class="<?= $TREATMENT_BILL->TableLeftColumnClass ?>"><?= $TREATMENT_BILL->TARIF_ID->caption() ?></td>
            <td <?= $TREATMENT_BILL->TARIF_ID->cellAttributes() ?>>
<span id="el_TREATMENT_BILL_TARIF_ID">
<span<?= $TREATMENT_BILL->TARIF_ID->viewAttributes() ?>>
<?= $TREATMENT_BILL->TARIF_ID->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($TREATMENT_BILL->CLINIC_ID->Visible) { // CLINIC_ID ?>
        <tr id="r_CLINIC_ID">
            <td class="<?= $TREATMENT_BILL->TableLeftColumnClass ?>"><?= $TREATMENT_BILL->CLINIC_ID->caption() ?></td>
            <td <?= $TREATMENT_BILL->CLINIC_ID->cellAttributes() ?>>
<span id="el_TREATMENT_BILL_CLINIC_ID">
<span<?= $TREATMENT_BILL->CLINIC_ID->viewAttributes() ?>>
<?= $TREATMENT_BILL->CLINIC_ID->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($TREATMENT_BILL->TREATMENT->Visible) { // TREATMENT ?>
        <tr id="r_TREATMENT">
            <td class="<?= $TREATMENT_BILL->TableLeftColumnClass ?>"><?= $TREATMENT_BILL->TREATMENT->caption() ?></td>
            <td <?= $TREATMENT_BILL->TREATMENT->cellAttributes() ?>>
<span id="el_TREATMENT_BILL_TREATMENT">
<span<?= $TREATMENT_BILL->TREATMENT->viewAttributes() ?>>
<?= $TREATMENT_BILL->TREATMENT->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($TREATMENT_BILL->TREAT_DATE->Visible) { // TREAT_DATE ?>
        <tr id="r_TREAT_DATE">
            <td class="<?= $TREATMENT_BILL->TableLeftColumnClass ?>"><?= $TREATMENT_BILL->TREAT_DATE->caption() ?></td>
            <td <?= $TREATMENT_BILL->TREAT_DATE->cellAttributes() ?>>
<span id="el_TREATMENT_BILL_TREAT_DATE">
<span<?= $TREATMENT_BILL->TREAT_DATE->viewAttributes() ?>>
<?= $TREATMENT_BILL->TREAT_DATE->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($TREATMENT_BILL->AMOUNT->Visible) { // AMOUNT ?>
        <tr id="r_AMOUNT">
            <td class="<?= $TREATMENT_BILL->TableLeftColumnClass ?>"><?= $TREATMENT_BILL->AMOUNT->caption() ?></td>
            <td <?= $TREATMENT_BILL->AMOUNT->cellAttributes() ?>>
<span id="el_TREATMENT_BILL_AMOUNT">
<span<?= $TREATMENT_BILL->AMOUNT->viewAttributes() ?>>
<?= $TREATMENT_BILL->AMOUNT->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($TREATMENT_BILL->QUANTITY->Visible) { // QUANTITY ?>
        <tr id="r_QUANTITY">
            <td class="<?= $TREATMENT_BILL->TableLeftColumnClass ?>"><?= $TREATMENT_BILL->QUANTITY->caption() ?></td>
            <td <?= $TREATMENT_BILL->QUANTITY->cellAttributes() ?>>
<span id="el_TREATMENT_BILL_QUANTITY">
<span<?= $TREATMENT_BILL->QUANTITY->viewAttributes() ?>>
<?= $TREATMENT_BILL->QUANTITY->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($TREATMENT_BILL->PAYMENT_DATE->Visible) { // PAYMENT_DATE ?>
        <tr id="r_PAYMENT_DATE">
            <td class="<?= $TREATMENT_BILL->TableLeftColumnClass ?>"><?= $TREATMENT_BILL->PAYMENT_DATE->caption() ?></td>
            <td <?= $TREATMENT_BILL->PAYMENT_DATE->cellAttributes() ?>>
<span id="el_TREATMENT_BILL_PAYMENT_DATE">
<span<?= $TREATMENT_BILL->PAYMENT_DATE->viewAttributes() ?>>
<?= $TREATMENT_BILL->PAYMENT_DATE->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($TREATMENT_BILL->ISLUNAS->Visible) { // ISLUNAS ?>
        <tr id="r_ISLUNAS">
            <td class="<?= $TREATMENT_BILL->TableLeftColumnClass ?>"><?= $TREATMENT_BILL->ISLUNAS->caption() ?></td>
            <td <?= $TREATMENT_BILL->ISLUNAS->cellAttributes() ?>>
<span id="el_TREATMENT_BILL_ISLUNAS">
<span<?= $TREATMENT_BILL->ISLUNAS->viewAttributes() ?>>
<?= $TREATMENT_BILL->ISLUNAS->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($TREATMENT_BILL->EMPLOYEE_ID->Visible) { // EMPLOYEE_ID ?>
        <tr id="r_EMPLOYEE_ID">
            <td class="<?= $TREATMENT_BILL->TableLeftColumnClass ?>"><?= $TREATMENT_BILL->EMPLOYEE_ID->caption() ?></td>
            <td <?= $TREATMENT_BILL->EMPLOYEE_ID->cellAttributes() ?>>
<span id="el_TREATMENT_BILL_EMPLOYEE_ID">
<span<?= $TREATMENT_BILL->EMPLOYEE_ID->viewAttributes() ?>>
<?= $TREATMENT_BILL->EMPLOYEE_ID->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($TREATMENT_BILL->amount_paid->Visible) { // amount_paid ?>
        <tr id="r_amount_paid">
            <td class="<?= $TREATMENT_BILL->TableLeftColumnClass ?>"><?= $TREATMENT_BILL->amount_paid->caption() ?></td>
            <td <?= $TREATMENT_BILL->amount_paid->cellAttributes() ?>>
<span id="el_TREATMENT_BILL_amount_paid">
<span<?= $TREATMENT_BILL->amount_paid->viewAttributes() ?>>
<?= $TREATMENT_BILL->amount_paid->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($TREATMENT_BILL->TRANS_ID->Visible) { // TRANS_ID ?>
        <tr id="r_TRANS_ID">
            <td class="<?= $TREATMENT_BILL->TableLeftColumnClass ?>"><?= $TREATMENT_BILL->TRANS_ID->caption() ?></td>
            <td <?= $TREATMENT_BILL->TRANS_ID->cellAttributes() ?>>
<span id="el_TREATMENT_BILL_TRANS_ID">
<span<?= $TREATMENT_BILL->TRANS_ID->viewAttributes() ?>>
<?= $TREATMENT_BILL->TRANS_ID->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
