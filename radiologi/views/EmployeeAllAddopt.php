<?php

namespace PHPMaker2021\SIMRSSQLSERVERRADIOLOGI;

// Page object
$EmployeeAllAddopt = &$Page;
?>
<script>
var currentForm, currentPageID;
var fEMPLOYEE_ALLaddopt;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "addopt";
    fEMPLOYEE_ALLaddopt = currentForm = new ew.Form("fEMPLOYEE_ALLaddopt", "addopt");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "EMPLOYEE_ALL")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.EMPLOYEE_ALL)
        ew.vars.tables.EMPLOYEE_ALL = currentTable;
    fEMPLOYEE_ALLaddopt.addFields([
        ["FULLNAME", [fields.FULLNAME.visible && fields.FULLNAME.required ? ew.Validators.required(fields.FULLNAME.caption) : null], fields.FULLNAME.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fEMPLOYEE_ALLaddopt,
            fobj = f.getForm(),
            $fobj = $(fobj),
            $k = $fobj.find("#" + f.formKeyCountName), // Get key_count
            rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1,
            startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
        for (var i = startcnt; i <= rowcnt; i++) {
            var rowIndex = ($k[0]) ? String(i) : "";
            f.setInvalid(rowIndex);
        }
    });

    // Validate form
    fEMPLOYEE_ALLaddopt.validate = function () {
        if (!this.validateRequired)
            return true; // Ignore validation
        var fobj = this.getForm(),
            $fobj = $(fobj);
        if ($fobj.find("#confirm").val() == "confirm")
            return true;
        var addcnt = 0,
            $k = $fobj.find("#" + this.formKeyCountName), // Get key_count
            rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1,
            startcnt = (rowcnt == 0) ? 0 : 1, // Check rowcnt == 0 => Inline-Add
            gridinsert = ["insert", "gridinsert"].includes($fobj.find("#action").val()) && $k[0];
        for (var i = startcnt; i <= rowcnt; i++) {
            var rowIndex = ($k[0]) ? String(i) : "";
            $fobj.data("rowindex", rowIndex);

            // Validate fields
            if (!this.validateFields(rowIndex))
                return false;

            // Call Form_CustomValidate event
            if (!this.customValidate(fobj)) {
                this.focus();
                return false;
            }
        }
        return true;
    }

    // Form_CustomValidate
    fEMPLOYEE_ALLaddopt.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fEMPLOYEE_ALLaddopt.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fEMPLOYEE_ALLaddopt");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php $Page->showPageHeader(); ?>
<form name="fEMPLOYEE_ALLaddopt" id="fEMPLOYEE_ALLaddopt" class="ew-form ew-horizontal" action="<?= HtmlEncode(GetUrl(Config("API_URL"))) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="<?= Config("API_ACTION_NAME") ?>" id="<?= Config("API_ACTION_NAME") ?>" value="<?= Config("API_ADD_ACTION") ?>">
<input type="hidden" name="<?= Config("API_OBJECT_NAME") ?>" id="<?= Config("API_OBJECT_NAME") ?>" value="EMPLOYEE_ALL">
<input type="hidden" name="addopt" id="addopt" value="1">
<?php if ($Page->FULLNAME->Visible) { // FULLNAME ?>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label ew-label" for="x_FULLNAME"><?= $Page->FULLNAME->caption() ?><?= $Page->FULLNAME->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="col-sm-10">
<input type="<?= $Page->FULLNAME->getInputTextType() ?>" data-table="EMPLOYEE_ALL" data-field="x_FULLNAME" name="x_FULLNAME" id="x_FULLNAME" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->FULLNAME->getPlaceHolder()) ?>" value="<?= $Page->FULLNAME->EditValue ?>"<?= $Page->FULLNAME->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->FULLNAME->getErrorMessage() ?></div>
</div>
    </div>
<?php } ?>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("EMPLOYEE_ALL");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
