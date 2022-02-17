<?php

namespace PHPMaker2021\SIMRSSQLSERVERREKAMMEDIK;

// Page object
$TreatmentBillSearch = &$Page;
?>
<script>
var currentForm, currentPageID;
var fTREATMENT_BILLsearch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    <?php if ($Page->IsModal) { ?>
    fTREATMENT_BILLsearch = currentAdvancedSearchForm = new ew.Form("fTREATMENT_BILLsearch", "search");
    <?php } else { ?>
    fTREATMENT_BILLsearch = currentForm = new ew.Form("fTREATMENT_BILLsearch", "search");
    <?php } ?>
    currentPageID = ew.PAGE_ID = "search";

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "TREATMENT_BILL")) ?>,
        fields = currentTable.fields;
    fTREATMENT_BILLsearch.addFields([
        ["ORG_UNIT_CODE", [], fields.ORG_UNIT_CODE.isInvalid],
        ["BILL_ID", [], fields.BILL_ID.isInvalid],
        ["NO_REGISTRATION", [], fields.NO_REGISTRATION.isInvalid],
        ["VISIT_ID", [], fields.VISIT_ID.isInvalid],
        ["TARIF_ID", [], fields.TARIF_ID.isInvalid],
        ["CLASS_ID", [ew.Validators.integer], fields.CLASS_ID.isInvalid],
        ["CLINIC_ID", [], fields.CLINIC_ID.isInvalid],
        ["CLINIC_ID_FROM", [], fields.CLINIC_ID_FROM.isInvalid],
        ["TREATMENT", [], fields.TREATMENT.isInvalid],
        ["TREAT_DATE", [ew.Validators.datetime(11)], fields.TREAT_DATE.isInvalid],
        ["AMOUNT", [ew.Validators.float], fields.AMOUNT.isInvalid],
        ["QUANTITY", [ew.Validators.float], fields.QUANTITY.isInvalid],
        ["MEASURE_ID", [ew.Validators.integer], fields.MEASURE_ID.isInvalid],
        ["POKOK_JUAL", [ew.Validators.float], fields.POKOK_JUAL.isInvalid],
        ["PPN", [ew.Validators.float], fields.PPN.isInvalid],
        ["MARGIN", [ew.Validators.float], fields.MARGIN.isInvalid],
        ["SUBSIDI", [ew.Validators.float], fields.SUBSIDI.isInvalid],
        ["EMBALACE", [ew.Validators.float], fields.EMBALACE.isInvalid],
        ["PROFESI", [ew.Validators.float], fields.PROFESI.isInvalid],
        ["DISCOUNT", [ew.Validators.float], fields.DISCOUNT.isInvalid],
        ["PAY_METHOD_ID", [ew.Validators.integer], fields.PAY_METHOD_ID.isInvalid],
        ["PAYMENT_DATE", [ew.Validators.datetime(11)], fields.PAYMENT_DATE.isInvalid],
        ["ISLUNAS", [], fields.ISLUNAS.isInvalid],
        ["DUEDATE_ANGSURAN", [ew.Validators.datetime(0)], fields.DUEDATE_ANGSURAN.isInvalid],
        ["DESCRIPTION", [], fields.DESCRIPTION.isInvalid],
        ["KUITANSI_ID", [], fields.KUITANSI_ID.isInvalid],
        ["NOTA_NO", [], fields.NOTA_NO.isInvalid],
        ["ISCETAK", [], fields.ISCETAK.isInvalid],
        ["PRINT_DATE", [ew.Validators.datetime(0)], fields.PRINT_DATE.isInvalid],
        ["RESEP_NO", [], fields.RESEP_NO.isInvalid],
        ["RESEP_KE", [ew.Validators.integer], fields.RESEP_KE.isInvalid],
        ["DOSE", [ew.Validators.float], fields.DOSE.isInvalid],
        ["ORIG_DOSE", [ew.Validators.float], fields.ORIG_DOSE.isInvalid],
        ["DOSE_PRESC", [ew.Validators.float], fields.DOSE_PRESC.isInvalid],
        ["ITER", [ew.Validators.integer], fields.ITER.isInvalid],
        ["ITER_KE", [ew.Validators.integer], fields.ITER_KE.isInvalid],
        ["SOLD_STATUS", [ew.Validators.integer], fields.SOLD_STATUS.isInvalid],
        ["RACIKAN", [ew.Validators.integer], fields.RACIKAN.isInvalid],
        ["CLASS_ROOM_ID", [], fields.CLASS_ROOM_ID.isInvalid],
        ["KELUAR_ID", [ew.Validators.integer], fields.KELUAR_ID.isInvalid],
        ["BED_ID", [ew.Validators.integer], fields.BED_ID.isInvalid],
        ["PERDA_ID", [ew.Validators.integer], fields.PERDA_ID.isInvalid],
        ["EMPLOYEE_ID", [], fields.EMPLOYEE_ID.isInvalid],
        ["DESCRIPTION2", [], fields.DESCRIPTION2.isInvalid],
        ["MODIFIED_BY", [], fields.MODIFIED_BY.isInvalid],
        ["MODIFIED_DATE", [ew.Validators.datetime(0)], fields.MODIFIED_DATE.isInvalid],
        ["MODIFIED_FROM", [], fields.MODIFIED_FROM.isInvalid],
        ["BRAND_ID", [], fields.BRAND_ID.isInvalid],
        ["DOCTOR", [], fields.DOCTOR.isInvalid],
        ["JML_BKS", [ew.Validators.integer], fields.JML_BKS.isInvalid],
        ["EXIT_DATE", [ew.Validators.datetime(0)], fields.EXIT_DATE.isInvalid],
        ["FA_V", [ew.Validators.integer], fields.FA_V.isInvalid],
        ["TASK_ID", [ew.Validators.integer], fields.TASK_ID.isInvalid],
        ["EMPLOYEE_ID_FROM", [], fields.EMPLOYEE_ID_FROM.isInvalid],
        ["DOCTOR_FROM", [], fields.DOCTOR_FROM.isInvalid],
        ["status_pasien_id", [ew.Validators.integer], fields.status_pasien_id.isInvalid],
        ["amount_paid", [ew.Validators.float], fields.amount_paid.isInvalid],
        ["THENAME", [], fields.THENAME.isInvalid],
        ["THEADDRESS", [], fields.THEADDRESS.isInvalid],
        ["THEID", [], fields.THEID.isInvalid],
        ["serial_nb", [], fields.serial_nb.isInvalid],
        ["TREATMENT_PLAFOND", [], fields.TREATMENT_PLAFOND.isInvalid],
        ["AMOUNT_PLAFOND", [ew.Validators.float], fields.AMOUNT_PLAFOND.isInvalid],
        ["AMOUNT_PAID_PLAFOND", [ew.Validators.float], fields.AMOUNT_PAID_PLAFOND.isInvalid],
        ["CLASS_ID_PLAFOND", [ew.Validators.integer], fields.CLASS_ID_PLAFOND.isInvalid],
        ["PAYOR_ID", [], fields.PAYOR_ID.isInvalid],
        ["PEMBULATAN", [ew.Validators.float], fields.PEMBULATAN.isInvalid],
        ["ISRJ", [], fields.ISRJ.isInvalid],
        ["AGEYEAR", [ew.Validators.integer], fields.AGEYEAR.isInvalid],
        ["AGEMONTH", [ew.Validators.integer], fields.AGEMONTH.isInvalid],
        ["AGEDAY", [ew.Validators.integer], fields.AGEDAY.isInvalid],
        ["GENDER", [], fields.GENDER.isInvalid],
        ["KAL_ID", [], fields.KAL_ID.isInvalid],
        ["CORRECTION_ID", [], fields.CORRECTION_ID.isInvalid],
        ["CORRECTION_BY", [], fields.CORRECTION_BY.isInvalid],
        ["KARYAWAN", [], fields.KARYAWAN.isInvalid],
        ["ACCOUNT_ID", [], fields.ACCOUNT_ID.isInvalid],
        ["sell_price", [ew.Validators.float], fields.sell_price.isInvalid],
        ["diskon", [ew.Validators.float], fields.diskon.isInvalid],
        ["INVOICE_ID", [], fields.INVOICE_ID.isInvalid],
        ["NUMER", [], fields.NUMER.isInvalid],
        ["MEASURE_ID2", [ew.Validators.integer], fields.MEASURE_ID2.isInvalid],
        ["POTONGAN", [ew.Validators.float], fields.POTONGAN.isInvalid],
        ["BAYAR", [ew.Validators.float], fields.BAYAR.isInvalid],
        ["RETUR", [ew.Validators.float], fields.RETUR.isInvalid],
        ["TARIF_TYPE", [], fields.TARIF_TYPE.isInvalid],
        ["PPNVALUE", [ew.Validators.float], fields.PPNVALUE.isInvalid],
        ["TAGIHAN", [ew.Validators.float], fields.TAGIHAN.isInvalid],
        ["KOREKSI", [ew.Validators.float], fields.KOREKSI.isInvalid],
        ["STATUS_OBAT", [ew.Validators.integer], fields.STATUS_OBAT.isInvalid],
        ["SUBSIDISAT", [ew.Validators.float], fields.SUBSIDISAT.isInvalid],
        ["PRINTQ", [ew.Validators.integer], fields.PRINTQ.isInvalid],
        ["PRINTED_BY", [], fields.PRINTED_BY.isInvalid],
        ["STOCK_AVAILABLE", [ew.Validators.float], fields.STOCK_AVAILABLE.isInvalid],
        ["STATUS_TARIF", [ew.Validators.integer], fields.STATUS_TARIF.isInvalid],
        ["CLINIC_TYPE", [ew.Validators.integer], fields.CLINIC_TYPE.isInvalid],
        ["PACKAGE_ID", [], fields.PACKAGE_ID.isInvalid],
        ["MODULE_ID", [], fields.MODULE_ID.isInvalid],
        ["profession", [ew.Validators.float], fields.profession.isInvalid],
        ["THEORDER", [ew.Validators.integer], fields.THEORDER.isInvalid],
        ["CASHIER", [], fields.CASHIER.isInvalid],
        ["SPPFEE", [], fields.SPPFEE.isInvalid],
        ["SPPBILL", [], fields.SPPBILL.isInvalid],
        ["SPPRJK", [], fields.SPPRJK.isInvalid],
        ["SPPJMN", [], fields.SPPJMN.isInvalid],
        ["SPPKASIR", [], fields.SPPKASIR.isInvalid],
        ["PERUJUK", [], fields.PERUJUK.isInvalid],
        ["PERUJUKFEE", [ew.Validators.float], fields.PERUJUKFEE.isInvalid],
        ["modified_datesys", [ew.Validators.datetime(0)], fields.modified_datesys.isInvalid],
        ["TRANS_ID", [], fields.TRANS_ID.isInvalid],
        ["SPPBILLDATE", [ew.Validators.datetime(0)], fields.SPPBILLDATE.isInvalid],
        ["SPPBILLUSER", [], fields.SPPBILLUSER.isInvalid],
        ["SPPKASIRDATE", [ew.Validators.datetime(0)], fields.SPPKASIRDATE.isInvalid],
        ["SPPKASIRUSER", [], fields.SPPKASIRUSER.isInvalid],
        ["SPPPOLI", [], fields.SPPPOLI.isInvalid],
        ["SPPPOLIUSER", [], fields.SPPPOLIUSER.isInvalid],
        ["SPPPOLIDATE", [ew.Validators.datetime(0)], fields.SPPPOLIDATE.isInvalid],
        ["nota_temp", [], fields.nota_temp.isInvalid],
        ["CLINIC_ID_TEMP", [], fields.CLINIC_ID_TEMP.isInvalid],
        ["NOSEP", [], fields.NOSEP.isInvalid],
        ["ID", [ew.Validators.integer], fields.ID.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        fTREATMENT_BILLsearch.setInvalid();
    });

    // Validate form
    fTREATMENT_BILLsearch.validate = function () {
        if (!this.validateRequired)
            return true; // Ignore validation
        var fobj = this.getForm(),
            $fobj = $(fobj),
            rowIndex = "";
        $fobj.data("rowindex", rowIndex);

        // Validate fields
        if (!this.validateFields(rowIndex))
            return false;

        // Call Form_CustomValidate event
        if (!this.customValidate(fobj)) {
            this.focus();
            return false;
        }
        return true;
    }

    // Form_CustomValidate
    fTREATMENT_BILLsearch.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fTREATMENT_BILLsearch.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fTREATMENT_BILLsearch.lists.NO_REGISTRATION = <?= $Page->NO_REGISTRATION->toClientList($Page) ?>;
    fTREATMENT_BILLsearch.lists.TARIF_ID = <?= $Page->TARIF_ID->toClientList($Page) ?>;
    fTREATMENT_BILLsearch.lists.CLINIC_ID = <?= $Page->CLINIC_ID->toClientList($Page) ?>;
    fTREATMENT_BILLsearch.lists.EMPLOYEE_ID = <?= $Page->EMPLOYEE_ID->toClientList($Page) ?>;
    loadjs.done("fTREATMENT_BILLsearch");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fTREATMENT_BILLsearch" id="fTREATMENT_BILLsearch" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="TREATMENT_BILL">
<input type="hidden" name="action" id="action" value="search">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<div class="ew-search-div"><!-- page* -->
<?php if ($Page->ORG_UNIT_CODE->Visible) { // ORG_UNIT_CODE ?>
    <div id="r_ORG_UNIT_CODE" class="form-group row">
        <label for="x_ORG_UNIT_CODE" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_ORG_UNIT_CODE"><?= $Page->ORG_UNIT_CODE->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_ORG_UNIT_CODE" id="z_ORG_UNIT_CODE" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ORG_UNIT_CODE->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_ORG_UNIT_CODE" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->ORG_UNIT_CODE->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_ORG_UNIT_CODE" name="x_ORG_UNIT_CODE" id="x_ORG_UNIT_CODE" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->ORG_UNIT_CODE->getPlaceHolder()) ?>" value="<?= $Page->ORG_UNIT_CODE->EditValue ?>"<?= $Page->ORG_UNIT_CODE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->ORG_UNIT_CODE->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->BILL_ID->Visible) { // BILL_ID ?>
    <div id="r_BILL_ID" class="form-group row">
        <label for="x_BILL_ID" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_BILL_ID"><?= $Page->BILL_ID->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_BILL_ID" id="z_BILL_ID" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->BILL_ID->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_BILL_ID" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->BILL_ID->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_BILL_ID" name="x_BILL_ID" id="x_BILL_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->BILL_ID->getPlaceHolder()) ?>" value="<?= $Page->BILL_ID->EditValue ?>"<?= $Page->BILL_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->BILL_ID->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->NO_REGISTRATION->Visible) { // NO_REGISTRATION ?>
    <div id="r_NO_REGISTRATION" class="form-group row">
        <label for="x_NO_REGISTRATION" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_NO_REGISTRATION"><?= $Page->NO_REGISTRATION->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_NO_REGISTRATION" id="z_NO_REGISTRATION" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->NO_REGISTRATION->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_NO_REGISTRATION" class="ew-search-field ew-search-field-single">
<div class="input-group ew-lookup-list">
    <div class="form-control ew-lookup-text" tabindex="-1" id="lu_x_NO_REGISTRATION"><?= EmptyValue(strval($Page->NO_REGISTRATION->AdvancedSearch->ViewValue)) ? $Language->phrase("PleaseSelect") : $Page->NO_REGISTRATION->AdvancedSearch->ViewValue ?></div>
    <div class="input-group-append">
        <button type="button" title="<?= HtmlEncode(str_replace("%s", RemoveHtml($Page->NO_REGISTRATION->caption()), $Language->phrase("LookupLink", true))) ?>" class="ew-lookup-btn btn btn-default"<?= ($Page->NO_REGISTRATION->ReadOnly || $Page->NO_REGISTRATION->Disabled) ? " disabled" : "" ?> onclick="ew.modalLookupShow({lnk:this,el:'x_NO_REGISTRATION',m:0,n:10});"><i class="fas fa-search ew-icon"></i></button>
    </div>
</div>
<div class="invalid-feedback"><?= $Page->NO_REGISTRATION->getErrorMessage(false) ?></div>
<?= $Page->NO_REGISTRATION->Lookup->getParamTag($Page, "p_x_NO_REGISTRATION") ?>
<input type="hidden" is="selection-list" data-table="TREATMENT_BILL" data-field="x_NO_REGISTRATION" data-type="text" data-multiple="0" data-lookup="1" data-value-separator="<?= $Page->NO_REGISTRATION->displayValueSeparatorAttribute() ?>" name="x_NO_REGISTRATION" id="x_NO_REGISTRATION" value="<?= $Page->NO_REGISTRATION->AdvancedSearch->SearchValue ?>"<?= $Page->NO_REGISTRATION->editAttributes() ?>>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->VISIT_ID->Visible) { // VISIT_ID ?>
    <div id="r_VISIT_ID" class="form-group row">
        <label class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_VISIT_ID"><?= $Page->VISIT_ID->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_VISIT_ID" id="z_VISIT_ID" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->VISIT_ID->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_VISIT_ID" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->VISIT_ID->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_VISIT_ID" name="x_VISIT_ID" id="x_VISIT_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->VISIT_ID->getPlaceHolder()) ?>" value="<?= $Page->VISIT_ID->EditValue ?>"<?= $Page->VISIT_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->VISIT_ID->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->TARIF_ID->Visible) { // TARIF_ID ?>
    <div id="r_TARIF_ID" class="form-group row">
        <label for="x_TARIF_ID" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_TARIF_ID"><?= $Page->TARIF_ID->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_TARIF_ID" id="z_TARIF_ID" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->TARIF_ID->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_TARIF_ID" class="ew-search-field ew-search-field-single">
<div class="input-group ew-lookup-list">
    <div class="form-control ew-lookup-text" tabindex="-1" id="lu_x_TARIF_ID"><?= EmptyValue(strval($Page->TARIF_ID->AdvancedSearch->ViewValue)) ? $Language->phrase("PleaseSelect") : $Page->TARIF_ID->AdvancedSearch->ViewValue ?></div>
    <div class="input-group-append">
        <button type="button" title="<?= HtmlEncode(str_replace("%s", RemoveHtml($Page->TARIF_ID->caption()), $Language->phrase("LookupLink", true))) ?>" class="ew-lookup-btn btn btn-default"<?= ($Page->TARIF_ID->ReadOnly || $Page->TARIF_ID->Disabled) ? " disabled" : "" ?> onclick="ew.modalLookupShow({lnk:this,el:'x_TARIF_ID',m:0,n:10});"><i class="fas fa-search ew-icon"></i></button>
    </div>
</div>
<div class="invalid-feedback"><?= $Page->TARIF_ID->getErrorMessage(false) ?></div>
<?= $Page->TARIF_ID->Lookup->getParamTag($Page, "p_x_TARIF_ID") ?>
<input type="hidden" is="selection-list" data-table="TREATMENT_BILL" data-field="x_TARIF_ID" data-type="text" data-multiple="0" data-lookup="1" data-value-separator="<?= $Page->TARIF_ID->displayValueSeparatorAttribute() ?>" name="x_TARIF_ID" id="x_TARIF_ID" value="<?= $Page->TARIF_ID->AdvancedSearch->SearchValue ?>"<?= $Page->TARIF_ID->editAttributes() ?>>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->CLASS_ID->Visible) { // CLASS_ID ?>
    <div id="r_CLASS_ID" class="form-group row">
        <label for="x_CLASS_ID" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_CLASS_ID"><?= $Page->CLASS_ID->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_CLASS_ID" id="z_CLASS_ID" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->CLASS_ID->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_CLASS_ID" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->CLASS_ID->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_CLASS_ID" name="x_CLASS_ID" id="x_CLASS_ID" size="30" placeholder="<?= HtmlEncode($Page->CLASS_ID->getPlaceHolder()) ?>" value="<?= $Page->CLASS_ID->EditValue ?>"<?= $Page->CLASS_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->CLASS_ID->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->CLINIC_ID->Visible) { // CLINIC_ID ?>
    <div id="r_CLINIC_ID" class="form-group row">
        <label for="x_CLINIC_ID" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_CLINIC_ID"><?= $Page->CLINIC_ID->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_CLINIC_ID" id="z_CLINIC_ID" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->CLINIC_ID->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_CLINIC_ID" class="ew-search-field ew-search-field-single">
    <select
        id="x_CLINIC_ID"
        name="x_CLINIC_ID"
        class="form-control ew-select<?= $Page->CLINIC_ID->isInvalidClass() ?>"
        data-select2-id="TREATMENT_BILL_x_CLINIC_ID"
        data-table="TREATMENT_BILL"
        data-field="x_CLINIC_ID"
        data-value-separator="<?= $Page->CLINIC_ID->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->CLINIC_ID->getPlaceHolder()) ?>"
        <?= $Page->CLINIC_ID->editAttributes() ?>>
        <?= $Page->CLINIC_ID->selectOptionListHtml("x_CLINIC_ID") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->CLINIC_ID->getErrorMessage(false) ?></div>
<?= $Page->CLINIC_ID->Lookup->getParamTag($Page, "p_x_CLINIC_ID") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='TREATMENT_BILL_x_CLINIC_ID']"),
        options = { name: "x_CLINIC_ID", selectId: "TREATMENT_BILL_x_CLINIC_ID", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.TREATMENT_BILL.fields.CLINIC_ID.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->CLINIC_ID_FROM->Visible) { // CLINIC_ID_FROM ?>
    <div id="r_CLINIC_ID_FROM" class="form-group row">
        <label for="x_CLINIC_ID_FROM" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_CLINIC_ID_FROM"><?= $Page->CLINIC_ID_FROM->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_CLINIC_ID_FROM" id="z_CLINIC_ID_FROM" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->CLINIC_ID_FROM->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_CLINIC_ID_FROM" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->CLINIC_ID_FROM->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_CLINIC_ID_FROM" name="x_CLINIC_ID_FROM" id="x_CLINIC_ID_FROM" size="30" maxlength="15" placeholder="<?= HtmlEncode($Page->CLINIC_ID_FROM->getPlaceHolder()) ?>" value="<?= $Page->CLINIC_ID_FROM->EditValue ?>"<?= $Page->CLINIC_ID_FROM->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->CLINIC_ID_FROM->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->TREATMENT->Visible) { // TREATMENT ?>
    <div id="r_TREATMENT" class="form-group row">
        <label for="x_TREATMENT" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_TREATMENT"><?= $Page->TREATMENT->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_TREATMENT" id="z_TREATMENT" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->TREATMENT->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_TREATMENT" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->TREATMENT->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_TREATMENT" name="x_TREATMENT" id="x_TREATMENT" size="30" maxlength="200" placeholder="<?= HtmlEncode($Page->TREATMENT->getPlaceHolder()) ?>" value="<?= $Page->TREATMENT->EditValue ?>"<?= $Page->TREATMENT->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->TREATMENT->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->TREAT_DATE->Visible) { // TREAT_DATE ?>
    <div id="r_TREAT_DATE" class="form-group row">
        <label for="x_TREAT_DATE" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_TREAT_DATE"><?= $Page->TREAT_DATE->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_TREAT_DATE" id="z_TREAT_DATE" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->TREAT_DATE->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_TREAT_DATE" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->TREAT_DATE->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_TREAT_DATE" data-format="11" name="x_TREAT_DATE" id="x_TREAT_DATE" placeholder="<?= HtmlEncode($Page->TREAT_DATE->getPlaceHolder()) ?>" value="<?= $Page->TREAT_DATE->EditValue ?>"<?= $Page->TREAT_DATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->TREAT_DATE->getErrorMessage(false) ?></div>
<?php if (!$Page->TREAT_DATE->ReadOnly && !$Page->TREAT_DATE->Disabled && !isset($Page->TREAT_DATE->EditAttrs["readonly"]) && !isset($Page->TREAT_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fTREATMENT_BILLsearch", "datetimepicker"], function() {
    ew.createDateTimePicker("fTREATMENT_BILLsearch", "x_TREAT_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":11});
});
</script>
<?php } ?>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->AMOUNT->Visible) { // AMOUNT ?>
    <div id="r_AMOUNT" class="form-group row">
        <label for="x_AMOUNT" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_AMOUNT"><?= $Page->AMOUNT->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_AMOUNT" id="z_AMOUNT" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->AMOUNT->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_AMOUNT" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->AMOUNT->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_AMOUNT" name="x_AMOUNT" id="x_AMOUNT" size="30" placeholder="<?= HtmlEncode($Page->AMOUNT->getPlaceHolder()) ?>" value="<?= $Page->AMOUNT->EditValue ?>"<?= $Page->AMOUNT->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->AMOUNT->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->QUANTITY->Visible) { // QUANTITY ?>
    <div id="r_QUANTITY" class="form-group row">
        <label for="x_QUANTITY" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_QUANTITY"><?= $Page->QUANTITY->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_QUANTITY" id="z_QUANTITY" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->QUANTITY->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_QUANTITY" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->QUANTITY->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_QUANTITY" name="x_QUANTITY" id="x_QUANTITY" size="30" placeholder="<?= HtmlEncode($Page->QUANTITY->getPlaceHolder()) ?>" value="<?= $Page->QUANTITY->EditValue ?>"<?= $Page->QUANTITY->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->QUANTITY->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->MEASURE_ID->Visible) { // MEASURE_ID ?>
    <div id="r_MEASURE_ID" class="form-group row">
        <label for="x_MEASURE_ID" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_MEASURE_ID"><?= $Page->MEASURE_ID->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_MEASURE_ID" id="z_MEASURE_ID" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->MEASURE_ID->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_MEASURE_ID" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->MEASURE_ID->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_MEASURE_ID" name="x_MEASURE_ID" id="x_MEASURE_ID" size="30" placeholder="<?= HtmlEncode($Page->MEASURE_ID->getPlaceHolder()) ?>" value="<?= $Page->MEASURE_ID->EditValue ?>"<?= $Page->MEASURE_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->MEASURE_ID->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->POKOK_JUAL->Visible) { // POKOK_JUAL ?>
    <div id="r_POKOK_JUAL" class="form-group row">
        <label for="x_POKOK_JUAL" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_POKOK_JUAL"><?= $Page->POKOK_JUAL->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_POKOK_JUAL" id="z_POKOK_JUAL" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->POKOK_JUAL->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_POKOK_JUAL" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->POKOK_JUAL->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_POKOK_JUAL" name="x_POKOK_JUAL" id="x_POKOK_JUAL" size="30" placeholder="<?= HtmlEncode($Page->POKOK_JUAL->getPlaceHolder()) ?>" value="<?= $Page->POKOK_JUAL->EditValue ?>"<?= $Page->POKOK_JUAL->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->POKOK_JUAL->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->PPN->Visible) { // PPN ?>
    <div id="r_PPN" class="form-group row">
        <label for="x_PPN" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_PPN"><?= $Page->PPN->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_PPN" id="z_PPN" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PPN->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_PPN" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->PPN->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_PPN" name="x_PPN" id="x_PPN" size="30" placeholder="<?= HtmlEncode($Page->PPN->getPlaceHolder()) ?>" value="<?= $Page->PPN->EditValue ?>"<?= $Page->PPN->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->PPN->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->MARGIN->Visible) { // MARGIN ?>
    <div id="r_MARGIN" class="form-group row">
        <label for="x_MARGIN" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_MARGIN"><?= $Page->MARGIN->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_MARGIN" id="z_MARGIN" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->MARGIN->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_MARGIN" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->MARGIN->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_MARGIN" name="x_MARGIN" id="x_MARGIN" size="30" placeholder="<?= HtmlEncode($Page->MARGIN->getPlaceHolder()) ?>" value="<?= $Page->MARGIN->EditValue ?>"<?= $Page->MARGIN->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->MARGIN->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->SUBSIDI->Visible) { // SUBSIDI ?>
    <div id="r_SUBSIDI" class="form-group row">
        <label for="x_SUBSIDI" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_SUBSIDI"><?= $Page->SUBSIDI->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_SUBSIDI" id="z_SUBSIDI" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->SUBSIDI->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_SUBSIDI" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->SUBSIDI->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_SUBSIDI" name="x_SUBSIDI" id="x_SUBSIDI" size="30" placeholder="<?= HtmlEncode($Page->SUBSIDI->getPlaceHolder()) ?>" value="<?= $Page->SUBSIDI->EditValue ?>"<?= $Page->SUBSIDI->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->SUBSIDI->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->EMBALACE->Visible) { // EMBALACE ?>
    <div id="r_EMBALACE" class="form-group row">
        <label for="x_EMBALACE" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_EMBALACE"><?= $Page->EMBALACE->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_EMBALACE" id="z_EMBALACE" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->EMBALACE->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_EMBALACE" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->EMBALACE->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_EMBALACE" name="x_EMBALACE" id="x_EMBALACE" size="30" placeholder="<?= HtmlEncode($Page->EMBALACE->getPlaceHolder()) ?>" value="<?= $Page->EMBALACE->EditValue ?>"<?= $Page->EMBALACE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->EMBALACE->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->PROFESI->Visible) { // PROFESI ?>
    <div id="r_PROFESI" class="form-group row">
        <label for="x_PROFESI" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_PROFESI"><?= $Page->PROFESI->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_PROFESI" id="z_PROFESI" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PROFESI->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_PROFESI" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->PROFESI->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_PROFESI" name="x_PROFESI" id="x_PROFESI" size="30" placeholder="<?= HtmlEncode($Page->PROFESI->getPlaceHolder()) ?>" value="<?= $Page->PROFESI->EditValue ?>"<?= $Page->PROFESI->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->PROFESI->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->DISCOUNT->Visible) { // DISCOUNT ?>
    <div id="r_DISCOUNT" class="form-group row">
        <label for="x_DISCOUNT" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_DISCOUNT"><?= $Page->DISCOUNT->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_DISCOUNT" id="z_DISCOUNT" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->DISCOUNT->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_DISCOUNT" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->DISCOUNT->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_DISCOUNT" name="x_DISCOUNT" id="x_DISCOUNT" size="30" placeholder="<?= HtmlEncode($Page->DISCOUNT->getPlaceHolder()) ?>" value="<?= $Page->DISCOUNT->EditValue ?>"<?= $Page->DISCOUNT->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->DISCOUNT->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->PAY_METHOD_ID->Visible) { // PAY_METHOD_ID ?>
    <div id="r_PAY_METHOD_ID" class="form-group row">
        <label for="x_PAY_METHOD_ID" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_PAY_METHOD_ID"><?= $Page->PAY_METHOD_ID->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_PAY_METHOD_ID" id="z_PAY_METHOD_ID" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PAY_METHOD_ID->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_PAY_METHOD_ID" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->PAY_METHOD_ID->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_PAY_METHOD_ID" name="x_PAY_METHOD_ID" id="x_PAY_METHOD_ID" size="30" placeholder="<?= HtmlEncode($Page->PAY_METHOD_ID->getPlaceHolder()) ?>" value="<?= $Page->PAY_METHOD_ID->EditValue ?>"<?= $Page->PAY_METHOD_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->PAY_METHOD_ID->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->PAYMENT_DATE->Visible) { // PAYMENT_DATE ?>
    <div id="r_PAYMENT_DATE" class="form-group row">
        <label for="x_PAYMENT_DATE" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_PAYMENT_DATE"><?= $Page->PAYMENT_DATE->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_PAYMENT_DATE" id="z_PAYMENT_DATE" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PAYMENT_DATE->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_PAYMENT_DATE" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->PAYMENT_DATE->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_PAYMENT_DATE" data-format="11" name="x_PAYMENT_DATE" id="x_PAYMENT_DATE" placeholder="<?= HtmlEncode($Page->PAYMENT_DATE->getPlaceHolder()) ?>" value="<?= $Page->PAYMENT_DATE->EditValue ?>"<?= $Page->PAYMENT_DATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->PAYMENT_DATE->getErrorMessage(false) ?></div>
<?php if (!$Page->PAYMENT_DATE->ReadOnly && !$Page->PAYMENT_DATE->Disabled && !isset($Page->PAYMENT_DATE->EditAttrs["readonly"]) && !isset($Page->PAYMENT_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fTREATMENT_BILLsearch", "datetimepicker"], function() {
    ew.createDateTimePicker("fTREATMENT_BILLsearch", "x_PAYMENT_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":11});
});
</script>
<?php } ?>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->ISLUNAS->Visible) { // ISLUNAS ?>
    <div id="r_ISLUNAS" class="form-group row">
        <label for="x_ISLUNAS" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_ISLUNAS"><?= $Page->ISLUNAS->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_ISLUNAS" id="z_ISLUNAS" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ISLUNAS->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_ISLUNAS" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->ISLUNAS->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_ISLUNAS" name="x_ISLUNAS" id="x_ISLUNAS" size="30" maxlength="1" placeholder="<?= HtmlEncode($Page->ISLUNAS->getPlaceHolder()) ?>" value="<?= $Page->ISLUNAS->EditValue ?>"<?= $Page->ISLUNAS->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->ISLUNAS->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->DUEDATE_ANGSURAN->Visible) { // DUEDATE_ANGSURAN ?>
    <div id="r_DUEDATE_ANGSURAN" class="form-group row">
        <label for="x_DUEDATE_ANGSURAN" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_DUEDATE_ANGSURAN"><?= $Page->DUEDATE_ANGSURAN->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_DUEDATE_ANGSURAN" id="z_DUEDATE_ANGSURAN" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->DUEDATE_ANGSURAN->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_DUEDATE_ANGSURAN" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->DUEDATE_ANGSURAN->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_DUEDATE_ANGSURAN" name="x_DUEDATE_ANGSURAN" id="x_DUEDATE_ANGSURAN" placeholder="<?= HtmlEncode($Page->DUEDATE_ANGSURAN->getPlaceHolder()) ?>" value="<?= $Page->DUEDATE_ANGSURAN->EditValue ?>"<?= $Page->DUEDATE_ANGSURAN->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->DUEDATE_ANGSURAN->getErrorMessage(false) ?></div>
<?php if (!$Page->DUEDATE_ANGSURAN->ReadOnly && !$Page->DUEDATE_ANGSURAN->Disabled && !isset($Page->DUEDATE_ANGSURAN->EditAttrs["readonly"]) && !isset($Page->DUEDATE_ANGSURAN->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fTREATMENT_BILLsearch", "datetimepicker"], function() {
    ew.createDateTimePicker("fTREATMENT_BILLsearch", "x_DUEDATE_ANGSURAN", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->DESCRIPTION->Visible) { // DESCRIPTION ?>
    <div id="r_DESCRIPTION" class="form-group row">
        <label for="x_DESCRIPTION" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_DESCRIPTION"><?= $Page->DESCRIPTION->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_DESCRIPTION" id="z_DESCRIPTION" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->DESCRIPTION->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_DESCRIPTION" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->DESCRIPTION->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_DESCRIPTION" name="x_DESCRIPTION" id="x_DESCRIPTION" size="30" maxlength="200" placeholder="<?= HtmlEncode($Page->DESCRIPTION->getPlaceHolder()) ?>" value="<?= $Page->DESCRIPTION->EditValue ?>"<?= $Page->DESCRIPTION->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->DESCRIPTION->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->KUITANSI_ID->Visible) { // KUITANSI_ID ?>
    <div id="r_KUITANSI_ID" class="form-group row">
        <label for="x_KUITANSI_ID" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_KUITANSI_ID"><?= $Page->KUITANSI_ID->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_KUITANSI_ID" id="z_KUITANSI_ID" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->KUITANSI_ID->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_KUITANSI_ID" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->KUITANSI_ID->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_KUITANSI_ID" name="x_KUITANSI_ID" id="x_KUITANSI_ID" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->KUITANSI_ID->getPlaceHolder()) ?>" value="<?= $Page->KUITANSI_ID->EditValue ?>"<?= $Page->KUITANSI_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->KUITANSI_ID->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->NOTA_NO->Visible) { // NOTA_NO ?>
    <div id="r_NOTA_NO" class="form-group row">
        <label for="x_NOTA_NO" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_NOTA_NO"><?= $Page->NOTA_NO->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_NOTA_NO" id="z_NOTA_NO" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->NOTA_NO->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_NOTA_NO" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->NOTA_NO->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_NOTA_NO" name="x_NOTA_NO" id="x_NOTA_NO" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->NOTA_NO->getPlaceHolder()) ?>" value="<?= $Page->NOTA_NO->EditValue ?>"<?= $Page->NOTA_NO->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->NOTA_NO->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->ISCETAK->Visible) { // ISCETAK ?>
    <div id="r_ISCETAK" class="form-group row">
        <label for="x_ISCETAK" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_ISCETAK"><?= $Page->ISCETAK->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_ISCETAK" id="z_ISCETAK" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ISCETAK->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_ISCETAK" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->ISCETAK->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_ISCETAK" name="x_ISCETAK" id="x_ISCETAK" size="30" maxlength="1" placeholder="<?= HtmlEncode($Page->ISCETAK->getPlaceHolder()) ?>" value="<?= $Page->ISCETAK->EditValue ?>"<?= $Page->ISCETAK->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->ISCETAK->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->PRINT_DATE->Visible) { // PRINT_DATE ?>
    <div id="r_PRINT_DATE" class="form-group row">
        <label for="x_PRINT_DATE" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_PRINT_DATE"><?= $Page->PRINT_DATE->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_PRINT_DATE" id="z_PRINT_DATE" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PRINT_DATE->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_PRINT_DATE" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->PRINT_DATE->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_PRINT_DATE" name="x_PRINT_DATE" id="x_PRINT_DATE" placeholder="<?= HtmlEncode($Page->PRINT_DATE->getPlaceHolder()) ?>" value="<?= $Page->PRINT_DATE->EditValue ?>"<?= $Page->PRINT_DATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->PRINT_DATE->getErrorMessage(false) ?></div>
<?php if (!$Page->PRINT_DATE->ReadOnly && !$Page->PRINT_DATE->Disabled && !isset($Page->PRINT_DATE->EditAttrs["readonly"]) && !isset($Page->PRINT_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fTREATMENT_BILLsearch", "datetimepicker"], function() {
    ew.createDateTimePicker("fTREATMENT_BILLsearch", "x_PRINT_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->RESEP_NO->Visible) { // RESEP_NO ?>
    <div id="r_RESEP_NO" class="form-group row">
        <label for="x_RESEP_NO" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_RESEP_NO"><?= $Page->RESEP_NO->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_RESEP_NO" id="z_RESEP_NO" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->RESEP_NO->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_RESEP_NO" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->RESEP_NO->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_RESEP_NO" name="x_RESEP_NO" id="x_RESEP_NO" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->RESEP_NO->getPlaceHolder()) ?>" value="<?= $Page->RESEP_NO->EditValue ?>"<?= $Page->RESEP_NO->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->RESEP_NO->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->RESEP_KE->Visible) { // RESEP_KE ?>
    <div id="r_RESEP_KE" class="form-group row">
        <label for="x_RESEP_KE" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_RESEP_KE"><?= $Page->RESEP_KE->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_RESEP_KE" id="z_RESEP_KE" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->RESEP_KE->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_RESEP_KE" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->RESEP_KE->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_RESEP_KE" name="x_RESEP_KE" id="x_RESEP_KE" size="30" placeholder="<?= HtmlEncode($Page->RESEP_KE->getPlaceHolder()) ?>" value="<?= $Page->RESEP_KE->EditValue ?>"<?= $Page->RESEP_KE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->RESEP_KE->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->DOSE->Visible) { // DOSE ?>
    <div id="r_DOSE" class="form-group row">
        <label for="x_DOSE" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_DOSE"><?= $Page->DOSE->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_DOSE" id="z_DOSE" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->DOSE->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_DOSE" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->DOSE->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_DOSE" name="x_DOSE" id="x_DOSE" size="30" placeholder="<?= HtmlEncode($Page->DOSE->getPlaceHolder()) ?>" value="<?= $Page->DOSE->EditValue ?>"<?= $Page->DOSE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->DOSE->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->ORIG_DOSE->Visible) { // ORIG_DOSE ?>
    <div id="r_ORIG_DOSE" class="form-group row">
        <label for="x_ORIG_DOSE" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_ORIG_DOSE"><?= $Page->ORIG_DOSE->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_ORIG_DOSE" id="z_ORIG_DOSE" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ORIG_DOSE->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_ORIG_DOSE" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->ORIG_DOSE->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_ORIG_DOSE" name="x_ORIG_DOSE" id="x_ORIG_DOSE" size="30" placeholder="<?= HtmlEncode($Page->ORIG_DOSE->getPlaceHolder()) ?>" value="<?= $Page->ORIG_DOSE->EditValue ?>"<?= $Page->ORIG_DOSE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->ORIG_DOSE->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->DOSE_PRESC->Visible) { // DOSE_PRESC ?>
    <div id="r_DOSE_PRESC" class="form-group row">
        <label for="x_DOSE_PRESC" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_DOSE_PRESC"><?= $Page->DOSE_PRESC->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_DOSE_PRESC" id="z_DOSE_PRESC" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->DOSE_PRESC->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_DOSE_PRESC" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->DOSE_PRESC->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_DOSE_PRESC" name="x_DOSE_PRESC" id="x_DOSE_PRESC" size="30" placeholder="<?= HtmlEncode($Page->DOSE_PRESC->getPlaceHolder()) ?>" value="<?= $Page->DOSE_PRESC->EditValue ?>"<?= $Page->DOSE_PRESC->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->DOSE_PRESC->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->ITER->Visible) { // ITER ?>
    <div id="r_ITER" class="form-group row">
        <label for="x_ITER" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_ITER"><?= $Page->ITER->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_ITER" id="z_ITER" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ITER->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_ITER" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->ITER->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_ITER" name="x_ITER" id="x_ITER" size="30" placeholder="<?= HtmlEncode($Page->ITER->getPlaceHolder()) ?>" value="<?= $Page->ITER->EditValue ?>"<?= $Page->ITER->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->ITER->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->ITER_KE->Visible) { // ITER_KE ?>
    <div id="r_ITER_KE" class="form-group row">
        <label for="x_ITER_KE" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_ITER_KE"><?= $Page->ITER_KE->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_ITER_KE" id="z_ITER_KE" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ITER_KE->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_ITER_KE" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->ITER_KE->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_ITER_KE" name="x_ITER_KE" id="x_ITER_KE" size="30" placeholder="<?= HtmlEncode($Page->ITER_KE->getPlaceHolder()) ?>" value="<?= $Page->ITER_KE->EditValue ?>"<?= $Page->ITER_KE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->ITER_KE->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->SOLD_STATUS->Visible) { // SOLD_STATUS ?>
    <div id="r_SOLD_STATUS" class="form-group row">
        <label for="x_SOLD_STATUS" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_SOLD_STATUS"><?= $Page->SOLD_STATUS->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_SOLD_STATUS" id="z_SOLD_STATUS" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->SOLD_STATUS->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_SOLD_STATUS" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->SOLD_STATUS->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_SOLD_STATUS" name="x_SOLD_STATUS" id="x_SOLD_STATUS" size="30" placeholder="<?= HtmlEncode($Page->SOLD_STATUS->getPlaceHolder()) ?>" value="<?= $Page->SOLD_STATUS->EditValue ?>"<?= $Page->SOLD_STATUS->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->SOLD_STATUS->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->RACIKAN->Visible) { // RACIKAN ?>
    <div id="r_RACIKAN" class="form-group row">
        <label for="x_RACIKAN" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_RACIKAN"><?= $Page->RACIKAN->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_RACIKAN" id="z_RACIKAN" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->RACIKAN->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_RACIKAN" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->RACIKAN->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_RACIKAN" name="x_RACIKAN" id="x_RACIKAN" size="30" placeholder="<?= HtmlEncode($Page->RACIKAN->getPlaceHolder()) ?>" value="<?= $Page->RACIKAN->EditValue ?>"<?= $Page->RACIKAN->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->RACIKAN->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->CLASS_ROOM_ID->Visible) { // CLASS_ROOM_ID ?>
    <div id="r_CLASS_ROOM_ID" class="form-group row">
        <label for="x_CLASS_ROOM_ID" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_CLASS_ROOM_ID"><?= $Page->CLASS_ROOM_ID->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_CLASS_ROOM_ID" id="z_CLASS_ROOM_ID" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->CLASS_ROOM_ID->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_CLASS_ROOM_ID" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->CLASS_ROOM_ID->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_CLASS_ROOM_ID" name="x_CLASS_ROOM_ID" id="x_CLASS_ROOM_ID" size="30" maxlength="16" placeholder="<?= HtmlEncode($Page->CLASS_ROOM_ID->getPlaceHolder()) ?>" value="<?= $Page->CLASS_ROOM_ID->EditValue ?>"<?= $Page->CLASS_ROOM_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->CLASS_ROOM_ID->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->KELUAR_ID->Visible) { // KELUAR_ID ?>
    <div id="r_KELUAR_ID" class="form-group row">
        <label for="x_KELUAR_ID" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_KELUAR_ID"><?= $Page->KELUAR_ID->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_KELUAR_ID" id="z_KELUAR_ID" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->KELUAR_ID->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_KELUAR_ID" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->KELUAR_ID->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_KELUAR_ID" name="x_KELUAR_ID" id="x_KELUAR_ID" size="30" placeholder="<?= HtmlEncode($Page->KELUAR_ID->getPlaceHolder()) ?>" value="<?= $Page->KELUAR_ID->EditValue ?>"<?= $Page->KELUAR_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->KELUAR_ID->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->BED_ID->Visible) { // BED_ID ?>
    <div id="r_BED_ID" class="form-group row">
        <label for="x_BED_ID" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_BED_ID"><?= $Page->BED_ID->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_BED_ID" id="z_BED_ID" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->BED_ID->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_BED_ID" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->BED_ID->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_BED_ID" name="x_BED_ID" id="x_BED_ID" size="30" placeholder="<?= HtmlEncode($Page->BED_ID->getPlaceHolder()) ?>" value="<?= $Page->BED_ID->EditValue ?>"<?= $Page->BED_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->BED_ID->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->PERDA_ID->Visible) { // PERDA_ID ?>
    <div id="r_PERDA_ID" class="form-group row">
        <label for="x_PERDA_ID" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_PERDA_ID"><?= $Page->PERDA_ID->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_PERDA_ID" id="z_PERDA_ID" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PERDA_ID->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_PERDA_ID" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->PERDA_ID->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_PERDA_ID" name="x_PERDA_ID" id="x_PERDA_ID" size="30" placeholder="<?= HtmlEncode($Page->PERDA_ID->getPlaceHolder()) ?>" value="<?= $Page->PERDA_ID->EditValue ?>"<?= $Page->PERDA_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->PERDA_ID->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->EMPLOYEE_ID->Visible) { // EMPLOYEE_ID ?>
    <div id="r_EMPLOYEE_ID" class="form-group row">
        <label for="x_EMPLOYEE_ID" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_EMPLOYEE_ID"><?= $Page->EMPLOYEE_ID->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_EMPLOYEE_ID" id="z_EMPLOYEE_ID" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->EMPLOYEE_ID->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_EMPLOYEE_ID" class="ew-search-field ew-search-field-single">
    <select
        id="x_EMPLOYEE_ID"
        name="x_EMPLOYEE_ID"
        class="form-control ew-select<?= $Page->EMPLOYEE_ID->isInvalidClass() ?>"
        data-select2-id="TREATMENT_BILL_x_EMPLOYEE_ID"
        data-table="TREATMENT_BILL"
        data-field="x_EMPLOYEE_ID"
        data-value-separator="<?= $Page->EMPLOYEE_ID->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->EMPLOYEE_ID->getPlaceHolder()) ?>"
        <?= $Page->EMPLOYEE_ID->editAttributes() ?>>
        <?= $Page->EMPLOYEE_ID->selectOptionListHtml("x_EMPLOYEE_ID") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->EMPLOYEE_ID->getErrorMessage(false) ?></div>
<?= $Page->EMPLOYEE_ID->Lookup->getParamTag($Page, "p_x_EMPLOYEE_ID") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='TREATMENT_BILL_x_EMPLOYEE_ID']"),
        options = { name: "x_EMPLOYEE_ID", selectId: "TREATMENT_BILL_x_EMPLOYEE_ID", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.TREATMENT_BILL.fields.EMPLOYEE_ID.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->DESCRIPTION2->Visible) { // DESCRIPTION2 ?>
    <div id="r_DESCRIPTION2" class="form-group row">
        <label for="x_DESCRIPTION2" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_DESCRIPTION2"><?= $Page->DESCRIPTION2->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_DESCRIPTION2" id="z_DESCRIPTION2" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->DESCRIPTION2->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_DESCRIPTION2" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->DESCRIPTION2->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_DESCRIPTION2" name="x_DESCRIPTION2" id="x_DESCRIPTION2" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->DESCRIPTION2->getPlaceHolder()) ?>" value="<?= $Page->DESCRIPTION2->EditValue ?>"<?= $Page->DESCRIPTION2->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->DESCRIPTION2->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
    <div id="r_MODIFIED_BY" class="form-group row">
        <label for="x_MODIFIED_BY" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_MODIFIED_BY"><?= $Page->MODIFIED_BY->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_MODIFIED_BY" id="z_MODIFIED_BY" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->MODIFIED_BY->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_MODIFIED_BY" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->MODIFIED_BY->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_MODIFIED_BY" name="x_MODIFIED_BY" id="x_MODIFIED_BY" size="30" maxlength="200" placeholder="<?= HtmlEncode($Page->MODIFIED_BY->getPlaceHolder()) ?>" value="<?= $Page->MODIFIED_BY->EditValue ?>"<?= $Page->MODIFIED_BY->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->MODIFIED_BY->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
    <div id="r_MODIFIED_DATE" class="form-group row">
        <label for="x_MODIFIED_DATE" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_MODIFIED_DATE"><?= $Page->MODIFIED_DATE->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_MODIFIED_DATE" id="z_MODIFIED_DATE" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->MODIFIED_DATE->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_MODIFIED_DATE" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->MODIFIED_DATE->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_MODIFIED_DATE" name="x_MODIFIED_DATE" id="x_MODIFIED_DATE" placeholder="<?= HtmlEncode($Page->MODIFIED_DATE->getPlaceHolder()) ?>" value="<?= $Page->MODIFIED_DATE->EditValue ?>"<?= $Page->MODIFIED_DATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->MODIFIED_DATE->getErrorMessage(false) ?></div>
<?php if (!$Page->MODIFIED_DATE->ReadOnly && !$Page->MODIFIED_DATE->Disabled && !isset($Page->MODIFIED_DATE->EditAttrs["readonly"]) && !isset($Page->MODIFIED_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fTREATMENT_BILLsearch", "datetimepicker"], function() {
    ew.createDateTimePicker("fTREATMENT_BILLsearch", "x_MODIFIED_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->MODIFIED_FROM->Visible) { // MODIFIED_FROM ?>
    <div id="r_MODIFIED_FROM" class="form-group row">
        <label for="x_MODIFIED_FROM" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_MODIFIED_FROM"><?= $Page->MODIFIED_FROM->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_MODIFIED_FROM" id="z_MODIFIED_FROM" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->MODIFIED_FROM->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_MODIFIED_FROM" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->MODIFIED_FROM->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_MODIFIED_FROM" name="x_MODIFIED_FROM" id="x_MODIFIED_FROM" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->MODIFIED_FROM->getPlaceHolder()) ?>" value="<?= $Page->MODIFIED_FROM->EditValue ?>"<?= $Page->MODIFIED_FROM->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->MODIFIED_FROM->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->BRAND_ID->Visible) { // BRAND_ID ?>
    <div id="r_BRAND_ID" class="form-group row">
        <label for="x_BRAND_ID" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_BRAND_ID"><?= $Page->BRAND_ID->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_BRAND_ID" id="z_BRAND_ID" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->BRAND_ID->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_BRAND_ID" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->BRAND_ID->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_BRAND_ID" name="x_BRAND_ID" id="x_BRAND_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->BRAND_ID->getPlaceHolder()) ?>" value="<?= $Page->BRAND_ID->EditValue ?>"<?= $Page->BRAND_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->BRAND_ID->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->DOCTOR->Visible) { // DOCTOR ?>
    <div id="r_DOCTOR" class="form-group row">
        <label for="x_DOCTOR" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_DOCTOR"><?= $Page->DOCTOR->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_DOCTOR" id="z_DOCTOR" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->DOCTOR->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_DOCTOR" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->DOCTOR->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_DOCTOR" name="x_DOCTOR" id="x_DOCTOR" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->DOCTOR->getPlaceHolder()) ?>" value="<?= $Page->DOCTOR->EditValue ?>"<?= $Page->DOCTOR->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->DOCTOR->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->JML_BKS->Visible) { // JML_BKS ?>
    <div id="r_JML_BKS" class="form-group row">
        <label for="x_JML_BKS" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_JML_BKS"><?= $Page->JML_BKS->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_JML_BKS" id="z_JML_BKS" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->JML_BKS->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_JML_BKS" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->JML_BKS->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_JML_BKS" name="x_JML_BKS" id="x_JML_BKS" size="30" placeholder="<?= HtmlEncode($Page->JML_BKS->getPlaceHolder()) ?>" value="<?= $Page->JML_BKS->EditValue ?>"<?= $Page->JML_BKS->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->JML_BKS->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->EXIT_DATE->Visible) { // EXIT_DATE ?>
    <div id="r_EXIT_DATE" class="form-group row">
        <label for="x_EXIT_DATE" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_EXIT_DATE"><?= $Page->EXIT_DATE->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_EXIT_DATE" id="z_EXIT_DATE" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->EXIT_DATE->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_EXIT_DATE" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->EXIT_DATE->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_EXIT_DATE" name="x_EXIT_DATE" id="x_EXIT_DATE" placeholder="<?= HtmlEncode($Page->EXIT_DATE->getPlaceHolder()) ?>" value="<?= $Page->EXIT_DATE->EditValue ?>"<?= $Page->EXIT_DATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->EXIT_DATE->getErrorMessage(false) ?></div>
<?php if (!$Page->EXIT_DATE->ReadOnly && !$Page->EXIT_DATE->Disabled && !isset($Page->EXIT_DATE->EditAttrs["readonly"]) && !isset($Page->EXIT_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fTREATMENT_BILLsearch", "datetimepicker"], function() {
    ew.createDateTimePicker("fTREATMENT_BILLsearch", "x_EXIT_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->FA_V->Visible) { // FA_V ?>
    <div id="r_FA_V" class="form-group row">
        <label for="x_FA_V" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_FA_V"><?= $Page->FA_V->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_FA_V" id="z_FA_V" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->FA_V->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_FA_V" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->FA_V->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_FA_V" name="x_FA_V" id="x_FA_V" size="30" placeholder="<?= HtmlEncode($Page->FA_V->getPlaceHolder()) ?>" value="<?= $Page->FA_V->EditValue ?>"<?= $Page->FA_V->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->FA_V->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->TASK_ID->Visible) { // TASK_ID ?>
    <div id="r_TASK_ID" class="form-group row">
        <label for="x_TASK_ID" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_TASK_ID"><?= $Page->TASK_ID->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_TASK_ID" id="z_TASK_ID" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->TASK_ID->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_TASK_ID" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->TASK_ID->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_TASK_ID" name="x_TASK_ID" id="x_TASK_ID" size="30" placeholder="<?= HtmlEncode($Page->TASK_ID->getPlaceHolder()) ?>" value="<?= $Page->TASK_ID->EditValue ?>"<?= $Page->TASK_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->TASK_ID->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->EMPLOYEE_ID_FROM->Visible) { // EMPLOYEE_ID_FROM ?>
    <div id="r_EMPLOYEE_ID_FROM" class="form-group row">
        <label for="x_EMPLOYEE_ID_FROM" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_EMPLOYEE_ID_FROM"><?= $Page->EMPLOYEE_ID_FROM->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_EMPLOYEE_ID_FROM" id="z_EMPLOYEE_ID_FROM" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->EMPLOYEE_ID_FROM->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_EMPLOYEE_ID_FROM" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->EMPLOYEE_ID_FROM->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_EMPLOYEE_ID_FROM" name="x_EMPLOYEE_ID_FROM" id="x_EMPLOYEE_ID_FROM" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->EMPLOYEE_ID_FROM->getPlaceHolder()) ?>" value="<?= $Page->EMPLOYEE_ID_FROM->EditValue ?>"<?= $Page->EMPLOYEE_ID_FROM->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->EMPLOYEE_ID_FROM->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->DOCTOR_FROM->Visible) { // DOCTOR_FROM ?>
    <div id="r_DOCTOR_FROM" class="form-group row">
        <label for="x_DOCTOR_FROM" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_DOCTOR_FROM"><?= $Page->DOCTOR_FROM->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_DOCTOR_FROM" id="z_DOCTOR_FROM" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->DOCTOR_FROM->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_DOCTOR_FROM" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->DOCTOR_FROM->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_DOCTOR_FROM" name="x_DOCTOR_FROM" id="x_DOCTOR_FROM" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->DOCTOR_FROM->getPlaceHolder()) ?>" value="<?= $Page->DOCTOR_FROM->EditValue ?>"<?= $Page->DOCTOR_FROM->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->DOCTOR_FROM->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->status_pasien_id->Visible) { // status_pasien_id ?>
    <div id="r_status_pasien_id" class="form-group row">
        <label for="x_status_pasien_id" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_status_pasien_id"><?= $Page->status_pasien_id->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_status_pasien_id" id="z_status_pasien_id" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->status_pasien_id->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_status_pasien_id" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->status_pasien_id->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_status_pasien_id" name="x_status_pasien_id" id="x_status_pasien_id" size="30" placeholder="<?= HtmlEncode($Page->status_pasien_id->getPlaceHolder()) ?>" value="<?= $Page->status_pasien_id->EditValue ?>"<?= $Page->status_pasien_id->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->status_pasien_id->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->amount_paid->Visible) { // amount_paid ?>
    <div id="r_amount_paid" class="form-group row">
        <label for="x_amount_paid" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_amount_paid"><?= $Page->amount_paid->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_amount_paid" id="z_amount_paid" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->amount_paid->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_amount_paid" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->amount_paid->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_amount_paid" name="x_amount_paid" id="x_amount_paid" size="30" placeholder="<?= HtmlEncode($Page->amount_paid->getPlaceHolder()) ?>" value="<?= $Page->amount_paid->EditValue ?>"<?= $Page->amount_paid->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->amount_paid->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->THENAME->Visible) { // THENAME ?>
    <div id="r_THENAME" class="form-group row">
        <label for="x_THENAME" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_THENAME"><?= $Page->THENAME->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_THENAME" id="z_THENAME" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->THENAME->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_THENAME" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->THENAME->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_THENAME" name="x_THENAME" id="x_THENAME" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->THENAME->getPlaceHolder()) ?>" value="<?= $Page->THENAME->EditValue ?>"<?= $Page->THENAME->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->THENAME->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->THEADDRESS->Visible) { // THEADDRESS ?>
    <div id="r_THEADDRESS" class="form-group row">
        <label for="x_THEADDRESS" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_THEADDRESS"><?= $Page->THEADDRESS->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_THEADDRESS" id="z_THEADDRESS" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->THEADDRESS->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_THEADDRESS" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->THEADDRESS->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_THEADDRESS" name="x_THEADDRESS" id="x_THEADDRESS" size="30" maxlength="150" placeholder="<?= HtmlEncode($Page->THEADDRESS->getPlaceHolder()) ?>" value="<?= $Page->THEADDRESS->EditValue ?>"<?= $Page->THEADDRESS->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->THEADDRESS->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->THEID->Visible) { // THEID ?>
    <div id="r_THEID" class="form-group row">
        <label for="x_THEID" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_THEID"><?= $Page->THEID->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_THEID" id="z_THEID" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->THEID->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_THEID" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->THEID->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_THEID" name="x_THEID" id="x_THEID" size="30" maxlength="25" placeholder="<?= HtmlEncode($Page->THEID->getPlaceHolder()) ?>" value="<?= $Page->THEID->EditValue ?>"<?= $Page->THEID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->THEID->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->serial_nb->Visible) { // serial_nb ?>
    <div id="r_serial_nb" class="form-group row">
        <label for="x_serial_nb" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_serial_nb"><?= $Page->serial_nb->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_serial_nb" id="z_serial_nb" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->serial_nb->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_serial_nb" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->serial_nb->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_serial_nb" name="x_serial_nb" id="x_serial_nb" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->serial_nb->getPlaceHolder()) ?>" value="<?= $Page->serial_nb->EditValue ?>"<?= $Page->serial_nb->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->serial_nb->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->TREATMENT_PLAFOND->Visible) { // TREATMENT_PLAFOND ?>
    <div id="r_TREATMENT_PLAFOND" class="form-group row">
        <label for="x_TREATMENT_PLAFOND" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_TREATMENT_PLAFOND"><?= $Page->TREATMENT_PLAFOND->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_TREATMENT_PLAFOND" id="z_TREATMENT_PLAFOND" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->TREATMENT_PLAFOND->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_TREATMENT_PLAFOND" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->TREATMENT_PLAFOND->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_TREATMENT_PLAFOND" name="x_TREATMENT_PLAFOND" id="x_TREATMENT_PLAFOND" size="30" maxlength="150" placeholder="<?= HtmlEncode($Page->TREATMENT_PLAFOND->getPlaceHolder()) ?>" value="<?= $Page->TREATMENT_PLAFOND->EditValue ?>"<?= $Page->TREATMENT_PLAFOND->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->TREATMENT_PLAFOND->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->AMOUNT_PLAFOND->Visible) { // AMOUNT_PLAFOND ?>
    <div id="r_AMOUNT_PLAFOND" class="form-group row">
        <label for="x_AMOUNT_PLAFOND" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_AMOUNT_PLAFOND"><?= $Page->AMOUNT_PLAFOND->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_AMOUNT_PLAFOND" id="z_AMOUNT_PLAFOND" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->AMOUNT_PLAFOND->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_AMOUNT_PLAFOND" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->AMOUNT_PLAFOND->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_AMOUNT_PLAFOND" name="x_AMOUNT_PLAFOND" id="x_AMOUNT_PLAFOND" size="30" placeholder="<?= HtmlEncode($Page->AMOUNT_PLAFOND->getPlaceHolder()) ?>" value="<?= $Page->AMOUNT_PLAFOND->EditValue ?>"<?= $Page->AMOUNT_PLAFOND->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->AMOUNT_PLAFOND->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->AMOUNT_PAID_PLAFOND->Visible) { // AMOUNT_PAID_PLAFOND ?>
    <div id="r_AMOUNT_PAID_PLAFOND" class="form-group row">
        <label for="x_AMOUNT_PAID_PLAFOND" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_AMOUNT_PAID_PLAFOND"><?= $Page->AMOUNT_PAID_PLAFOND->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_AMOUNT_PAID_PLAFOND" id="z_AMOUNT_PAID_PLAFOND" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->AMOUNT_PAID_PLAFOND->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_AMOUNT_PAID_PLAFOND" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->AMOUNT_PAID_PLAFOND->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_AMOUNT_PAID_PLAFOND" name="x_AMOUNT_PAID_PLAFOND" id="x_AMOUNT_PAID_PLAFOND" size="30" placeholder="<?= HtmlEncode($Page->AMOUNT_PAID_PLAFOND->getPlaceHolder()) ?>" value="<?= $Page->AMOUNT_PAID_PLAFOND->EditValue ?>"<?= $Page->AMOUNT_PAID_PLAFOND->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->AMOUNT_PAID_PLAFOND->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->CLASS_ID_PLAFOND->Visible) { // CLASS_ID_PLAFOND ?>
    <div id="r_CLASS_ID_PLAFOND" class="form-group row">
        <label for="x_CLASS_ID_PLAFOND" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_CLASS_ID_PLAFOND"><?= $Page->CLASS_ID_PLAFOND->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_CLASS_ID_PLAFOND" id="z_CLASS_ID_PLAFOND" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->CLASS_ID_PLAFOND->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_CLASS_ID_PLAFOND" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->CLASS_ID_PLAFOND->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_CLASS_ID_PLAFOND" name="x_CLASS_ID_PLAFOND" id="x_CLASS_ID_PLAFOND" size="30" placeholder="<?= HtmlEncode($Page->CLASS_ID_PLAFOND->getPlaceHolder()) ?>" value="<?= $Page->CLASS_ID_PLAFOND->EditValue ?>"<?= $Page->CLASS_ID_PLAFOND->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->CLASS_ID_PLAFOND->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->PAYOR_ID->Visible) { // PAYOR_ID ?>
    <div id="r_PAYOR_ID" class="form-group row">
        <label for="x_PAYOR_ID" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_PAYOR_ID"><?= $Page->PAYOR_ID->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_PAYOR_ID" id="z_PAYOR_ID" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PAYOR_ID->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_PAYOR_ID" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->PAYOR_ID->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_PAYOR_ID" name="x_PAYOR_ID" id="x_PAYOR_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->PAYOR_ID->getPlaceHolder()) ?>" value="<?= $Page->PAYOR_ID->EditValue ?>"<?= $Page->PAYOR_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->PAYOR_ID->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->PEMBULATAN->Visible) { // PEMBULATAN ?>
    <div id="r_PEMBULATAN" class="form-group row">
        <label for="x_PEMBULATAN" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_PEMBULATAN"><?= $Page->PEMBULATAN->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_PEMBULATAN" id="z_PEMBULATAN" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PEMBULATAN->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_PEMBULATAN" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->PEMBULATAN->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_PEMBULATAN" name="x_PEMBULATAN" id="x_PEMBULATAN" size="30" placeholder="<?= HtmlEncode($Page->PEMBULATAN->getPlaceHolder()) ?>" value="<?= $Page->PEMBULATAN->EditValue ?>"<?= $Page->PEMBULATAN->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->PEMBULATAN->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->ISRJ->Visible) { // ISRJ ?>
    <div id="r_ISRJ" class="form-group row">
        <label for="x_ISRJ" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_ISRJ"><?= $Page->ISRJ->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_ISRJ" id="z_ISRJ" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ISRJ->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_ISRJ" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->ISRJ->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_ISRJ" name="x_ISRJ" id="x_ISRJ" size="30" maxlength="1" placeholder="<?= HtmlEncode($Page->ISRJ->getPlaceHolder()) ?>" value="<?= $Page->ISRJ->EditValue ?>"<?= $Page->ISRJ->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->ISRJ->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->AGEYEAR->Visible) { // AGEYEAR ?>
    <div id="r_AGEYEAR" class="form-group row">
        <label for="x_AGEYEAR" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_AGEYEAR"><?= $Page->AGEYEAR->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_AGEYEAR" id="z_AGEYEAR" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->AGEYEAR->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_AGEYEAR" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->AGEYEAR->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_AGEYEAR" name="x_AGEYEAR" id="x_AGEYEAR" size="30" placeholder="<?= HtmlEncode($Page->AGEYEAR->getPlaceHolder()) ?>" value="<?= $Page->AGEYEAR->EditValue ?>"<?= $Page->AGEYEAR->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->AGEYEAR->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->AGEMONTH->Visible) { // AGEMONTH ?>
    <div id="r_AGEMONTH" class="form-group row">
        <label for="x_AGEMONTH" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_AGEMONTH"><?= $Page->AGEMONTH->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_AGEMONTH" id="z_AGEMONTH" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->AGEMONTH->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_AGEMONTH" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->AGEMONTH->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_AGEMONTH" name="x_AGEMONTH" id="x_AGEMONTH" size="30" placeholder="<?= HtmlEncode($Page->AGEMONTH->getPlaceHolder()) ?>" value="<?= $Page->AGEMONTH->EditValue ?>"<?= $Page->AGEMONTH->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->AGEMONTH->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->AGEDAY->Visible) { // AGEDAY ?>
    <div id="r_AGEDAY" class="form-group row">
        <label for="x_AGEDAY" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_AGEDAY"><?= $Page->AGEDAY->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_AGEDAY" id="z_AGEDAY" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->AGEDAY->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_AGEDAY" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->AGEDAY->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_AGEDAY" name="x_AGEDAY" id="x_AGEDAY" size="30" placeholder="<?= HtmlEncode($Page->AGEDAY->getPlaceHolder()) ?>" value="<?= $Page->AGEDAY->EditValue ?>"<?= $Page->AGEDAY->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->AGEDAY->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->GENDER->Visible) { // GENDER ?>
    <div id="r_GENDER" class="form-group row">
        <label for="x_GENDER" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_GENDER"><?= $Page->GENDER->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_GENDER" id="z_GENDER" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->GENDER->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_GENDER" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->GENDER->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_GENDER" name="x_GENDER" id="x_GENDER" size="30" maxlength="1" placeholder="<?= HtmlEncode($Page->GENDER->getPlaceHolder()) ?>" value="<?= $Page->GENDER->EditValue ?>"<?= $Page->GENDER->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->GENDER->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->KAL_ID->Visible) { // KAL_ID ?>
    <div id="r_KAL_ID" class="form-group row">
        <label for="x_KAL_ID" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_KAL_ID"><?= $Page->KAL_ID->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_KAL_ID" id="z_KAL_ID" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->KAL_ID->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_KAL_ID" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->KAL_ID->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_KAL_ID" name="x_KAL_ID" id="x_KAL_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->KAL_ID->getPlaceHolder()) ?>" value="<?= $Page->KAL_ID->EditValue ?>"<?= $Page->KAL_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->KAL_ID->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->CORRECTION_ID->Visible) { // CORRECTION_ID ?>
    <div id="r_CORRECTION_ID" class="form-group row">
        <label for="x_CORRECTION_ID" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_CORRECTION_ID"><?= $Page->CORRECTION_ID->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_CORRECTION_ID" id="z_CORRECTION_ID" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->CORRECTION_ID->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_CORRECTION_ID" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->CORRECTION_ID->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_CORRECTION_ID" name="x_CORRECTION_ID" id="x_CORRECTION_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->CORRECTION_ID->getPlaceHolder()) ?>" value="<?= $Page->CORRECTION_ID->EditValue ?>"<?= $Page->CORRECTION_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->CORRECTION_ID->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->CORRECTION_BY->Visible) { // CORRECTION_BY ?>
    <div id="r_CORRECTION_BY" class="form-group row">
        <label for="x_CORRECTION_BY" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_CORRECTION_BY"><?= $Page->CORRECTION_BY->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_CORRECTION_BY" id="z_CORRECTION_BY" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->CORRECTION_BY->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_CORRECTION_BY" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->CORRECTION_BY->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_CORRECTION_BY" name="x_CORRECTION_BY" id="x_CORRECTION_BY" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->CORRECTION_BY->getPlaceHolder()) ?>" value="<?= $Page->CORRECTION_BY->EditValue ?>"<?= $Page->CORRECTION_BY->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->CORRECTION_BY->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->KARYAWAN->Visible) { // KARYAWAN ?>
    <div id="r_KARYAWAN" class="form-group row">
        <label for="x_KARYAWAN" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_KARYAWAN"><?= $Page->KARYAWAN->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_KARYAWAN" id="z_KARYAWAN" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->KARYAWAN->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_KARYAWAN" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->KARYAWAN->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_KARYAWAN" name="x_KARYAWAN" id="x_KARYAWAN" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->KARYAWAN->getPlaceHolder()) ?>" value="<?= $Page->KARYAWAN->EditValue ?>"<?= $Page->KARYAWAN->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->KARYAWAN->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->ACCOUNT_ID->Visible) { // ACCOUNT_ID ?>
    <div id="r_ACCOUNT_ID" class="form-group row">
        <label for="x_ACCOUNT_ID" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_ACCOUNT_ID"><?= $Page->ACCOUNT_ID->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_ACCOUNT_ID" id="z_ACCOUNT_ID" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ACCOUNT_ID->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_ACCOUNT_ID" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->ACCOUNT_ID->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_ACCOUNT_ID" name="x_ACCOUNT_ID" id="x_ACCOUNT_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->ACCOUNT_ID->getPlaceHolder()) ?>" value="<?= $Page->ACCOUNT_ID->EditValue ?>"<?= $Page->ACCOUNT_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->ACCOUNT_ID->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->sell_price->Visible) { // sell_price ?>
    <div id="r_sell_price" class="form-group row">
        <label for="x_sell_price" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_sell_price"><?= $Page->sell_price->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_sell_price" id="z_sell_price" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->sell_price->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_sell_price" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->sell_price->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_sell_price" name="x_sell_price" id="x_sell_price" size="30" placeholder="<?= HtmlEncode($Page->sell_price->getPlaceHolder()) ?>" value="<?= $Page->sell_price->EditValue ?>"<?= $Page->sell_price->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->sell_price->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->diskon->Visible) { // diskon ?>
    <div id="r_diskon" class="form-group row">
        <label for="x_diskon" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_diskon"><?= $Page->diskon->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_diskon" id="z_diskon" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->diskon->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_diskon" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->diskon->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_diskon" name="x_diskon" id="x_diskon" size="30" placeholder="<?= HtmlEncode($Page->diskon->getPlaceHolder()) ?>" value="<?= $Page->diskon->EditValue ?>"<?= $Page->diskon->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->diskon->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->INVOICE_ID->Visible) { // INVOICE_ID ?>
    <div id="r_INVOICE_ID" class="form-group row">
        <label for="x_INVOICE_ID" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_INVOICE_ID"><?= $Page->INVOICE_ID->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_INVOICE_ID" id="z_INVOICE_ID" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->INVOICE_ID->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_INVOICE_ID" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->INVOICE_ID->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_INVOICE_ID" name="x_INVOICE_ID" id="x_INVOICE_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->INVOICE_ID->getPlaceHolder()) ?>" value="<?= $Page->INVOICE_ID->EditValue ?>"<?= $Page->INVOICE_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->INVOICE_ID->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->NUMER->Visible) { // NUMER ?>
    <div id="r_NUMER" class="form-group row">
        <label for="x_NUMER" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_NUMER"><?= $Page->NUMER->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_NUMER" id="z_NUMER" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->NUMER->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_NUMER" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->NUMER->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_NUMER" name="x_NUMER" id="x_NUMER" size="30" maxlength="15" placeholder="<?= HtmlEncode($Page->NUMER->getPlaceHolder()) ?>" value="<?= $Page->NUMER->EditValue ?>"<?= $Page->NUMER->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->NUMER->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->MEASURE_ID2->Visible) { // MEASURE_ID2 ?>
    <div id="r_MEASURE_ID2" class="form-group row">
        <label for="x_MEASURE_ID2" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_MEASURE_ID2"><?= $Page->MEASURE_ID2->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_MEASURE_ID2" id="z_MEASURE_ID2" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->MEASURE_ID2->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_MEASURE_ID2" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->MEASURE_ID2->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_MEASURE_ID2" name="x_MEASURE_ID2" id="x_MEASURE_ID2" size="30" placeholder="<?= HtmlEncode($Page->MEASURE_ID2->getPlaceHolder()) ?>" value="<?= $Page->MEASURE_ID2->EditValue ?>"<?= $Page->MEASURE_ID2->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->MEASURE_ID2->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->POTONGAN->Visible) { // POTONGAN ?>
    <div id="r_POTONGAN" class="form-group row">
        <label for="x_POTONGAN" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_POTONGAN"><?= $Page->POTONGAN->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_POTONGAN" id="z_POTONGAN" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->POTONGAN->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_POTONGAN" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->POTONGAN->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_POTONGAN" name="x_POTONGAN" id="x_POTONGAN" size="30" placeholder="<?= HtmlEncode($Page->POTONGAN->getPlaceHolder()) ?>" value="<?= $Page->POTONGAN->EditValue ?>"<?= $Page->POTONGAN->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->POTONGAN->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->BAYAR->Visible) { // BAYAR ?>
    <div id="r_BAYAR" class="form-group row">
        <label for="x_BAYAR" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_BAYAR"><?= $Page->BAYAR->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_BAYAR" id="z_BAYAR" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->BAYAR->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_BAYAR" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->BAYAR->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_BAYAR" name="x_BAYAR" id="x_BAYAR" size="30" placeholder="<?= HtmlEncode($Page->BAYAR->getPlaceHolder()) ?>" value="<?= $Page->BAYAR->EditValue ?>"<?= $Page->BAYAR->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->BAYAR->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->RETUR->Visible) { // RETUR ?>
    <div id="r_RETUR" class="form-group row">
        <label for="x_RETUR" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_RETUR"><?= $Page->RETUR->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_RETUR" id="z_RETUR" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->RETUR->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_RETUR" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->RETUR->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_RETUR" name="x_RETUR" id="x_RETUR" size="30" placeholder="<?= HtmlEncode($Page->RETUR->getPlaceHolder()) ?>" value="<?= $Page->RETUR->EditValue ?>"<?= $Page->RETUR->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->RETUR->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->TARIF_TYPE->Visible) { // TARIF_TYPE ?>
    <div id="r_TARIF_TYPE" class="form-group row">
        <label for="x_TARIF_TYPE" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_TARIF_TYPE"><?= $Page->TARIF_TYPE->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_TARIF_TYPE" id="z_TARIF_TYPE" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->TARIF_TYPE->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_TARIF_TYPE" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->TARIF_TYPE->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_TARIF_TYPE" name="x_TARIF_TYPE" id="x_TARIF_TYPE" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->TARIF_TYPE->getPlaceHolder()) ?>" value="<?= $Page->TARIF_TYPE->EditValue ?>"<?= $Page->TARIF_TYPE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->TARIF_TYPE->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->PPNVALUE->Visible) { // PPNVALUE ?>
    <div id="r_PPNVALUE" class="form-group row">
        <label for="x_PPNVALUE" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_PPNVALUE"><?= $Page->PPNVALUE->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_PPNVALUE" id="z_PPNVALUE" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PPNVALUE->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_PPNVALUE" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->PPNVALUE->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_PPNVALUE" name="x_PPNVALUE" id="x_PPNVALUE" size="30" placeholder="<?= HtmlEncode($Page->PPNVALUE->getPlaceHolder()) ?>" value="<?= $Page->PPNVALUE->EditValue ?>"<?= $Page->PPNVALUE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->PPNVALUE->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->TAGIHAN->Visible) { // TAGIHAN ?>
    <div id="r_TAGIHAN" class="form-group row">
        <label for="x_TAGIHAN" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_TAGIHAN"><?= $Page->TAGIHAN->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_TAGIHAN" id="z_TAGIHAN" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->TAGIHAN->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_TAGIHAN" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->TAGIHAN->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_TAGIHAN" name="x_TAGIHAN" id="x_TAGIHAN" size="30" placeholder="<?= HtmlEncode($Page->TAGIHAN->getPlaceHolder()) ?>" value="<?= $Page->TAGIHAN->EditValue ?>"<?= $Page->TAGIHAN->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->TAGIHAN->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->KOREKSI->Visible) { // KOREKSI ?>
    <div id="r_KOREKSI" class="form-group row">
        <label for="x_KOREKSI" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_KOREKSI"><?= $Page->KOREKSI->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_KOREKSI" id="z_KOREKSI" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->KOREKSI->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_KOREKSI" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->KOREKSI->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_KOREKSI" name="x_KOREKSI" id="x_KOREKSI" size="30" placeholder="<?= HtmlEncode($Page->KOREKSI->getPlaceHolder()) ?>" value="<?= $Page->KOREKSI->EditValue ?>"<?= $Page->KOREKSI->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->KOREKSI->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->STATUS_OBAT->Visible) { // STATUS_OBAT ?>
    <div id="r_STATUS_OBAT" class="form-group row">
        <label for="x_STATUS_OBAT" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_STATUS_OBAT"><?= $Page->STATUS_OBAT->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_STATUS_OBAT" id="z_STATUS_OBAT" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->STATUS_OBAT->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_STATUS_OBAT" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->STATUS_OBAT->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_STATUS_OBAT" name="x_STATUS_OBAT" id="x_STATUS_OBAT" size="30" placeholder="<?= HtmlEncode($Page->STATUS_OBAT->getPlaceHolder()) ?>" value="<?= $Page->STATUS_OBAT->EditValue ?>"<?= $Page->STATUS_OBAT->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->STATUS_OBAT->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->SUBSIDISAT->Visible) { // SUBSIDISAT ?>
    <div id="r_SUBSIDISAT" class="form-group row">
        <label for="x_SUBSIDISAT" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_SUBSIDISAT"><?= $Page->SUBSIDISAT->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_SUBSIDISAT" id="z_SUBSIDISAT" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->SUBSIDISAT->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_SUBSIDISAT" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->SUBSIDISAT->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_SUBSIDISAT" name="x_SUBSIDISAT" id="x_SUBSIDISAT" size="30" placeholder="<?= HtmlEncode($Page->SUBSIDISAT->getPlaceHolder()) ?>" value="<?= $Page->SUBSIDISAT->EditValue ?>"<?= $Page->SUBSIDISAT->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->SUBSIDISAT->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->PRINTQ->Visible) { // PRINTQ ?>
    <div id="r_PRINTQ" class="form-group row">
        <label for="x_PRINTQ" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_PRINTQ"><?= $Page->PRINTQ->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_PRINTQ" id="z_PRINTQ" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PRINTQ->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_PRINTQ" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->PRINTQ->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_PRINTQ" name="x_PRINTQ" id="x_PRINTQ" size="30" placeholder="<?= HtmlEncode($Page->PRINTQ->getPlaceHolder()) ?>" value="<?= $Page->PRINTQ->EditValue ?>"<?= $Page->PRINTQ->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->PRINTQ->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->PRINTED_BY->Visible) { // PRINTED_BY ?>
    <div id="r_PRINTED_BY" class="form-group row">
        <label for="x_PRINTED_BY" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_PRINTED_BY"><?= $Page->PRINTED_BY->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_PRINTED_BY" id="z_PRINTED_BY" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PRINTED_BY->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_PRINTED_BY" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->PRINTED_BY->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_PRINTED_BY" name="x_PRINTED_BY" id="x_PRINTED_BY" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->PRINTED_BY->getPlaceHolder()) ?>" value="<?= $Page->PRINTED_BY->EditValue ?>"<?= $Page->PRINTED_BY->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->PRINTED_BY->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->STOCK_AVAILABLE->Visible) { // STOCK_AVAILABLE ?>
    <div id="r_STOCK_AVAILABLE" class="form-group row">
        <label for="x_STOCK_AVAILABLE" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_STOCK_AVAILABLE"><?= $Page->STOCK_AVAILABLE->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_STOCK_AVAILABLE" id="z_STOCK_AVAILABLE" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->STOCK_AVAILABLE->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_STOCK_AVAILABLE" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->STOCK_AVAILABLE->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_STOCK_AVAILABLE" name="x_STOCK_AVAILABLE" id="x_STOCK_AVAILABLE" size="30" placeholder="<?= HtmlEncode($Page->STOCK_AVAILABLE->getPlaceHolder()) ?>" value="<?= $Page->STOCK_AVAILABLE->EditValue ?>"<?= $Page->STOCK_AVAILABLE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->STOCK_AVAILABLE->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->STATUS_TARIF->Visible) { // STATUS_TARIF ?>
    <div id="r_STATUS_TARIF" class="form-group row">
        <label for="x_STATUS_TARIF" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_STATUS_TARIF"><?= $Page->STATUS_TARIF->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_STATUS_TARIF" id="z_STATUS_TARIF" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->STATUS_TARIF->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_STATUS_TARIF" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->STATUS_TARIF->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_STATUS_TARIF" name="x_STATUS_TARIF" id="x_STATUS_TARIF" size="30" placeholder="<?= HtmlEncode($Page->STATUS_TARIF->getPlaceHolder()) ?>" value="<?= $Page->STATUS_TARIF->EditValue ?>"<?= $Page->STATUS_TARIF->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->STATUS_TARIF->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->CLINIC_TYPE->Visible) { // CLINIC_TYPE ?>
    <div id="r_CLINIC_TYPE" class="form-group row">
        <label for="x_CLINIC_TYPE" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_CLINIC_TYPE"><?= $Page->CLINIC_TYPE->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_CLINIC_TYPE" id="z_CLINIC_TYPE" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->CLINIC_TYPE->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_CLINIC_TYPE" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->CLINIC_TYPE->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_CLINIC_TYPE" name="x_CLINIC_TYPE" id="x_CLINIC_TYPE" size="30" placeholder="<?= HtmlEncode($Page->CLINIC_TYPE->getPlaceHolder()) ?>" value="<?= $Page->CLINIC_TYPE->EditValue ?>"<?= $Page->CLINIC_TYPE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->CLINIC_TYPE->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->PACKAGE_ID->Visible) { // PACKAGE_ID ?>
    <div id="r_PACKAGE_ID" class="form-group row">
        <label for="x_PACKAGE_ID" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_PACKAGE_ID"><?= $Page->PACKAGE_ID->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_PACKAGE_ID" id="z_PACKAGE_ID" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PACKAGE_ID->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_PACKAGE_ID" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->PACKAGE_ID->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_PACKAGE_ID" name="x_PACKAGE_ID" id="x_PACKAGE_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->PACKAGE_ID->getPlaceHolder()) ?>" value="<?= $Page->PACKAGE_ID->EditValue ?>"<?= $Page->PACKAGE_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->PACKAGE_ID->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->MODULE_ID->Visible) { // MODULE_ID ?>
    <div id="r_MODULE_ID" class="form-group row">
        <label for="x_MODULE_ID" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_MODULE_ID"><?= $Page->MODULE_ID->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_MODULE_ID" id="z_MODULE_ID" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->MODULE_ID->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_MODULE_ID" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->MODULE_ID->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_MODULE_ID" name="x_MODULE_ID" id="x_MODULE_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->MODULE_ID->getPlaceHolder()) ?>" value="<?= $Page->MODULE_ID->EditValue ?>"<?= $Page->MODULE_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->MODULE_ID->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->profession->Visible) { // profession ?>
    <div id="r_profession" class="form-group row">
        <label for="x_profession" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_profession"><?= $Page->profession->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_profession" id="z_profession" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->profession->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_profession" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->profession->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_profession" name="x_profession" id="x_profession" size="30" placeholder="<?= HtmlEncode($Page->profession->getPlaceHolder()) ?>" value="<?= $Page->profession->EditValue ?>"<?= $Page->profession->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->profession->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->THEORDER->Visible) { // THEORDER ?>
    <div id="r_THEORDER" class="form-group row">
        <label for="x_THEORDER" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_THEORDER"><?= $Page->THEORDER->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_THEORDER" id="z_THEORDER" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->THEORDER->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_THEORDER" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->THEORDER->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_THEORDER" name="x_THEORDER" id="x_THEORDER" size="30" placeholder="<?= HtmlEncode($Page->THEORDER->getPlaceHolder()) ?>" value="<?= $Page->THEORDER->EditValue ?>"<?= $Page->THEORDER->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->THEORDER->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->CASHIER->Visible) { // CASHIER ?>
    <div id="r_CASHIER" class="form-group row">
        <label for="x_CASHIER" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_CASHIER"><?= $Page->CASHIER->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_CASHIER" id="z_CASHIER" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->CASHIER->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_CASHIER" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->CASHIER->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_CASHIER" name="x_CASHIER" id="x_CASHIER" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->CASHIER->getPlaceHolder()) ?>" value="<?= $Page->CASHIER->EditValue ?>"<?= $Page->CASHIER->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->CASHIER->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->SPPFEE->Visible) { // SPPFEE ?>
    <div id="r_SPPFEE" class="form-group row">
        <label for="x_SPPFEE" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_SPPFEE"><?= $Page->SPPFEE->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_SPPFEE" id="z_SPPFEE" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->SPPFEE->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_SPPFEE" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->SPPFEE->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_SPPFEE" name="x_SPPFEE" id="x_SPPFEE" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->SPPFEE->getPlaceHolder()) ?>" value="<?= $Page->SPPFEE->EditValue ?>"<?= $Page->SPPFEE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->SPPFEE->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->SPPBILL->Visible) { // SPPBILL ?>
    <div id="r_SPPBILL" class="form-group row">
        <label for="x_SPPBILL" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_SPPBILL"><?= $Page->SPPBILL->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_SPPBILL" id="z_SPPBILL" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->SPPBILL->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_SPPBILL" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->SPPBILL->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_SPPBILL" name="x_SPPBILL" id="x_SPPBILL" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->SPPBILL->getPlaceHolder()) ?>" value="<?= $Page->SPPBILL->EditValue ?>"<?= $Page->SPPBILL->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->SPPBILL->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->SPPRJK->Visible) { // SPPRJK ?>
    <div id="r_SPPRJK" class="form-group row">
        <label for="x_SPPRJK" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_SPPRJK"><?= $Page->SPPRJK->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_SPPRJK" id="z_SPPRJK" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->SPPRJK->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_SPPRJK" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->SPPRJK->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_SPPRJK" name="x_SPPRJK" id="x_SPPRJK" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->SPPRJK->getPlaceHolder()) ?>" value="<?= $Page->SPPRJK->EditValue ?>"<?= $Page->SPPRJK->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->SPPRJK->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->SPPJMN->Visible) { // SPPJMN ?>
    <div id="r_SPPJMN" class="form-group row">
        <label for="x_SPPJMN" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_SPPJMN"><?= $Page->SPPJMN->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_SPPJMN" id="z_SPPJMN" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->SPPJMN->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_SPPJMN" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->SPPJMN->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_SPPJMN" name="x_SPPJMN" id="x_SPPJMN" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->SPPJMN->getPlaceHolder()) ?>" value="<?= $Page->SPPJMN->EditValue ?>"<?= $Page->SPPJMN->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->SPPJMN->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->SPPKASIR->Visible) { // SPPKASIR ?>
    <div id="r_SPPKASIR" class="form-group row">
        <label for="x_SPPKASIR" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_SPPKASIR"><?= $Page->SPPKASIR->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_SPPKASIR" id="z_SPPKASIR" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->SPPKASIR->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_SPPKASIR" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->SPPKASIR->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_SPPKASIR" name="x_SPPKASIR" id="x_SPPKASIR" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->SPPKASIR->getPlaceHolder()) ?>" value="<?= $Page->SPPKASIR->EditValue ?>"<?= $Page->SPPKASIR->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->SPPKASIR->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->PERUJUK->Visible) { // PERUJUK ?>
    <div id="r_PERUJUK" class="form-group row">
        <label for="x_PERUJUK" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_PERUJUK"><?= $Page->PERUJUK->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_PERUJUK" id="z_PERUJUK" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PERUJUK->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_PERUJUK" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->PERUJUK->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_PERUJUK" name="x_PERUJUK" id="x_PERUJUK" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->PERUJUK->getPlaceHolder()) ?>" value="<?= $Page->PERUJUK->EditValue ?>"<?= $Page->PERUJUK->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->PERUJUK->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->PERUJUKFEE->Visible) { // PERUJUKFEE ?>
    <div id="r_PERUJUKFEE" class="form-group row">
        <label for="x_PERUJUKFEE" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_PERUJUKFEE"><?= $Page->PERUJUKFEE->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_PERUJUKFEE" id="z_PERUJUKFEE" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PERUJUKFEE->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_PERUJUKFEE" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->PERUJUKFEE->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_PERUJUKFEE" name="x_PERUJUKFEE" id="x_PERUJUKFEE" size="30" placeholder="<?= HtmlEncode($Page->PERUJUKFEE->getPlaceHolder()) ?>" value="<?= $Page->PERUJUKFEE->EditValue ?>"<?= $Page->PERUJUKFEE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->PERUJUKFEE->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->modified_datesys->Visible) { // modified_datesys ?>
    <div id="r_modified_datesys" class="form-group row">
        <label for="x_modified_datesys" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_modified_datesys"><?= $Page->modified_datesys->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_modified_datesys" id="z_modified_datesys" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->modified_datesys->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_modified_datesys" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->modified_datesys->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_modified_datesys" name="x_modified_datesys" id="x_modified_datesys" placeholder="<?= HtmlEncode($Page->modified_datesys->getPlaceHolder()) ?>" value="<?= $Page->modified_datesys->EditValue ?>"<?= $Page->modified_datesys->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->modified_datesys->getErrorMessage(false) ?></div>
<?php if (!$Page->modified_datesys->ReadOnly && !$Page->modified_datesys->Disabled && !isset($Page->modified_datesys->EditAttrs["readonly"]) && !isset($Page->modified_datesys->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fTREATMENT_BILLsearch", "datetimepicker"], function() {
    ew.createDateTimePicker("fTREATMENT_BILLsearch", "x_modified_datesys", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->TRANS_ID->Visible) { // TRANS_ID ?>
    <div id="r_TRANS_ID" class="form-group row">
        <label for="x_TRANS_ID" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_TRANS_ID"><?= $Page->TRANS_ID->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_TRANS_ID" id="z_TRANS_ID" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->TRANS_ID->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_TRANS_ID" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->TRANS_ID->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_TRANS_ID" name="x_TRANS_ID" id="x_TRANS_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->TRANS_ID->getPlaceHolder()) ?>" value="<?= $Page->TRANS_ID->EditValue ?>"<?= $Page->TRANS_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->TRANS_ID->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->SPPBILLDATE->Visible) { // SPPBILLDATE ?>
    <div id="r_SPPBILLDATE" class="form-group row">
        <label for="x_SPPBILLDATE" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_SPPBILLDATE"><?= $Page->SPPBILLDATE->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_SPPBILLDATE" id="z_SPPBILLDATE" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->SPPBILLDATE->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_SPPBILLDATE" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->SPPBILLDATE->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_SPPBILLDATE" name="x_SPPBILLDATE" id="x_SPPBILLDATE" placeholder="<?= HtmlEncode($Page->SPPBILLDATE->getPlaceHolder()) ?>" value="<?= $Page->SPPBILLDATE->EditValue ?>"<?= $Page->SPPBILLDATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->SPPBILLDATE->getErrorMessage(false) ?></div>
<?php if (!$Page->SPPBILLDATE->ReadOnly && !$Page->SPPBILLDATE->Disabled && !isset($Page->SPPBILLDATE->EditAttrs["readonly"]) && !isset($Page->SPPBILLDATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fTREATMENT_BILLsearch", "datetimepicker"], function() {
    ew.createDateTimePicker("fTREATMENT_BILLsearch", "x_SPPBILLDATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->SPPBILLUSER->Visible) { // SPPBILLUSER ?>
    <div id="r_SPPBILLUSER" class="form-group row">
        <label for="x_SPPBILLUSER" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_SPPBILLUSER"><?= $Page->SPPBILLUSER->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_SPPBILLUSER" id="z_SPPBILLUSER" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->SPPBILLUSER->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_SPPBILLUSER" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->SPPBILLUSER->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_SPPBILLUSER" name="x_SPPBILLUSER" id="x_SPPBILLUSER" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->SPPBILLUSER->getPlaceHolder()) ?>" value="<?= $Page->SPPBILLUSER->EditValue ?>"<?= $Page->SPPBILLUSER->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->SPPBILLUSER->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->SPPKASIRDATE->Visible) { // SPPKASIRDATE ?>
    <div id="r_SPPKASIRDATE" class="form-group row">
        <label for="x_SPPKASIRDATE" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_SPPKASIRDATE"><?= $Page->SPPKASIRDATE->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_SPPKASIRDATE" id="z_SPPKASIRDATE" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->SPPKASIRDATE->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_SPPKASIRDATE" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->SPPKASIRDATE->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_SPPKASIRDATE" name="x_SPPKASIRDATE" id="x_SPPKASIRDATE" placeholder="<?= HtmlEncode($Page->SPPKASIRDATE->getPlaceHolder()) ?>" value="<?= $Page->SPPKASIRDATE->EditValue ?>"<?= $Page->SPPKASIRDATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->SPPKASIRDATE->getErrorMessage(false) ?></div>
<?php if (!$Page->SPPKASIRDATE->ReadOnly && !$Page->SPPKASIRDATE->Disabled && !isset($Page->SPPKASIRDATE->EditAttrs["readonly"]) && !isset($Page->SPPKASIRDATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fTREATMENT_BILLsearch", "datetimepicker"], function() {
    ew.createDateTimePicker("fTREATMENT_BILLsearch", "x_SPPKASIRDATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->SPPKASIRUSER->Visible) { // SPPKASIRUSER ?>
    <div id="r_SPPKASIRUSER" class="form-group row">
        <label for="x_SPPKASIRUSER" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_SPPKASIRUSER"><?= $Page->SPPKASIRUSER->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_SPPKASIRUSER" id="z_SPPKASIRUSER" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->SPPKASIRUSER->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_SPPKASIRUSER" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->SPPKASIRUSER->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_SPPKASIRUSER" name="x_SPPKASIRUSER" id="x_SPPKASIRUSER" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->SPPKASIRUSER->getPlaceHolder()) ?>" value="<?= $Page->SPPKASIRUSER->EditValue ?>"<?= $Page->SPPKASIRUSER->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->SPPKASIRUSER->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->SPPPOLI->Visible) { // SPPPOLI ?>
    <div id="r_SPPPOLI" class="form-group row">
        <label for="x_SPPPOLI" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_SPPPOLI"><?= $Page->SPPPOLI->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_SPPPOLI" id="z_SPPPOLI" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->SPPPOLI->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_SPPPOLI" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->SPPPOLI->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_SPPPOLI" name="x_SPPPOLI" id="x_SPPPOLI" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->SPPPOLI->getPlaceHolder()) ?>" value="<?= $Page->SPPPOLI->EditValue ?>"<?= $Page->SPPPOLI->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->SPPPOLI->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->SPPPOLIUSER->Visible) { // SPPPOLIUSER ?>
    <div id="r_SPPPOLIUSER" class="form-group row">
        <label for="x_SPPPOLIUSER" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_SPPPOLIUSER"><?= $Page->SPPPOLIUSER->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_SPPPOLIUSER" id="z_SPPPOLIUSER" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->SPPPOLIUSER->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_SPPPOLIUSER" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->SPPPOLIUSER->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_SPPPOLIUSER" name="x_SPPPOLIUSER" id="x_SPPPOLIUSER" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->SPPPOLIUSER->getPlaceHolder()) ?>" value="<?= $Page->SPPPOLIUSER->EditValue ?>"<?= $Page->SPPPOLIUSER->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->SPPPOLIUSER->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->SPPPOLIDATE->Visible) { // SPPPOLIDATE ?>
    <div id="r_SPPPOLIDATE" class="form-group row">
        <label for="x_SPPPOLIDATE" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_SPPPOLIDATE"><?= $Page->SPPPOLIDATE->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_SPPPOLIDATE" id="z_SPPPOLIDATE" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->SPPPOLIDATE->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_SPPPOLIDATE" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->SPPPOLIDATE->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_SPPPOLIDATE" name="x_SPPPOLIDATE" id="x_SPPPOLIDATE" placeholder="<?= HtmlEncode($Page->SPPPOLIDATE->getPlaceHolder()) ?>" value="<?= $Page->SPPPOLIDATE->EditValue ?>"<?= $Page->SPPPOLIDATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->SPPPOLIDATE->getErrorMessage(false) ?></div>
<?php if (!$Page->SPPPOLIDATE->ReadOnly && !$Page->SPPPOLIDATE->Disabled && !isset($Page->SPPPOLIDATE->EditAttrs["readonly"]) && !isset($Page->SPPPOLIDATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fTREATMENT_BILLsearch", "datetimepicker"], function() {
    ew.createDateTimePicker("fTREATMENT_BILLsearch", "x_SPPPOLIDATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->nota_temp->Visible) { // nota_temp ?>
    <div id="r_nota_temp" class="form-group row">
        <label for="x_nota_temp" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_nota_temp"><?= $Page->nota_temp->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_nota_temp" id="z_nota_temp" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->nota_temp->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_nota_temp" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->nota_temp->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_nota_temp" name="x_nota_temp" id="x_nota_temp" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->nota_temp->getPlaceHolder()) ?>" value="<?= $Page->nota_temp->EditValue ?>"<?= $Page->nota_temp->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->nota_temp->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->CLINIC_ID_TEMP->Visible) { // CLINIC_ID_TEMP ?>
    <div id="r_CLINIC_ID_TEMP" class="form-group row">
        <label for="x_CLINIC_ID_TEMP" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_CLINIC_ID_TEMP"><?= $Page->CLINIC_ID_TEMP->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_CLINIC_ID_TEMP" id="z_CLINIC_ID_TEMP" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->CLINIC_ID_TEMP->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_CLINIC_ID_TEMP" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->CLINIC_ID_TEMP->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_CLINIC_ID_TEMP" name="x_CLINIC_ID_TEMP" id="x_CLINIC_ID_TEMP" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->CLINIC_ID_TEMP->getPlaceHolder()) ?>" value="<?= $Page->CLINIC_ID_TEMP->EditValue ?>"<?= $Page->CLINIC_ID_TEMP->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->CLINIC_ID_TEMP->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->NOSEP->Visible) { // NOSEP ?>
    <div id="r_NOSEP" class="form-group row">
        <label for="x_NOSEP" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_NOSEP"><?= $Page->NOSEP->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_NOSEP" id="z_NOSEP" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->NOSEP->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_NOSEP" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->NOSEP->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_NOSEP" name="x_NOSEP" id="x_NOSEP" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->NOSEP->getPlaceHolder()) ?>" value="<?= $Page->NOSEP->EditValue ?>"<?= $Page->NOSEP->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->NOSEP->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->ID->Visible) { // ID ?>
    <div id="r_ID" class="form-group row">
        <label for="x_ID" class="<?= $Page->LeftColumnClass ?>"><span id="elh_TREATMENT_BILL_ID"><?= $Page->ID->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_ID" id="z_ID" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ID->cellAttributes() ?>>
            <span id="el_TREATMENT_BILL_ID" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->ID->getInputTextType() ?>" data-table="TREATMENT_BILL" data-field="x_ID" name="x_ID" id="x_ID" maxlength="50" placeholder="<?= HtmlEncode($Page->ID->getPlaceHolder()) ?>" value="<?= $Page->ID->EditValue ?>"<?= $Page->ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->ID->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$Page->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
        <button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("Search") ?></button>
        <button class="btn btn-default ew-btn" name="btn-reset" id="btn-reset" type="button" onclick="location.reload();"><?= $Language->phrase("Reset") ?></button>
    </div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("TREATMENT_BILL");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
