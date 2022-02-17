<?php

namespace PHPMaker2021\Online;

// Page object
$JobCategoryAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fJOB_CATEGORYadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fJOB_CATEGORYadd = currentForm = new ew.Form("fJOB_CATEGORYadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "JOB_CATEGORY")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.JOB_CATEGORY)
        ew.vars.tables.JOB_CATEGORY = currentTable;
    fJOB_CATEGORYadd.addFields([
        ["JOB_ID", [fields.JOB_ID.visible && fields.JOB_ID.required ? ew.Validators.required(fields.JOB_ID.caption) : null, ew.Validators.integer], fields.JOB_ID.isInvalid],
        ["NAME_OF_JOB", [fields.NAME_OF_JOB.visible && fields.NAME_OF_JOB.required ? ew.Validators.required(fields.NAME_OF_JOB.caption) : null], fields.NAME_OF_JOB.isInvalid],
        ["DESCRIPTION", [fields.DESCRIPTION.visible && fields.DESCRIPTION.required ? ew.Validators.required(fields.DESCRIPTION.caption) : null], fields.DESCRIPTION.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fJOB_CATEGORYadd,
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
    fJOB_CATEGORYadd.validate = function () {
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

        // Process detail forms
        var dfs = $fobj.find("input[name='detailpage']").get();
        for (var i = 0; i < dfs.length; i++) {
            var df = dfs[i],
                val = df.value,
                frm = ew.forms.get(val);
            if (val && frm && !frm.validate())
                return false;
        }
        return true;
    }

    // Form_CustomValidate
    fJOB_CATEGORYadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fJOB_CATEGORYadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fJOB_CATEGORYadd");
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
<form name="fJOB_CATEGORYadd" id="fJOB_CATEGORYadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="JOB_CATEGORY">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->JOB_ID->Visible) { // JOB_ID ?>
    <div id="r_JOB_ID" class="form-group row">
        <label id="elh_JOB_CATEGORY_JOB_ID" for="x_JOB_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->JOB_ID->caption() ?><?= $Page->JOB_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->JOB_ID->cellAttributes() ?>>
<span id="el_JOB_CATEGORY_JOB_ID">
<input type="<?= $Page->JOB_ID->getInputTextType() ?>" data-table="JOB_CATEGORY" data-field="x_JOB_ID" name="x_JOB_ID" id="x_JOB_ID" size="30" placeholder="<?= HtmlEncode($Page->JOB_ID->getPlaceHolder()) ?>" value="<?= $Page->JOB_ID->EditValue ?>"<?= $Page->JOB_ID->editAttributes() ?> aria-describedby="x_JOB_ID_help">
<?= $Page->JOB_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->JOB_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->NAME_OF_JOB->Visible) { // NAME_OF_JOB ?>
    <div id="r_NAME_OF_JOB" class="form-group row">
        <label id="elh_JOB_CATEGORY_NAME_OF_JOB" for="x_NAME_OF_JOB" class="<?= $Page->LeftColumnClass ?>"><?= $Page->NAME_OF_JOB->caption() ?><?= $Page->NAME_OF_JOB->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->NAME_OF_JOB->cellAttributes() ?>>
<span id="el_JOB_CATEGORY_NAME_OF_JOB">
<input type="<?= $Page->NAME_OF_JOB->getInputTextType() ?>" data-table="JOB_CATEGORY" data-field="x_NAME_OF_JOB" name="x_NAME_OF_JOB" id="x_NAME_OF_JOB" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->NAME_OF_JOB->getPlaceHolder()) ?>" value="<?= $Page->NAME_OF_JOB->EditValue ?>"<?= $Page->NAME_OF_JOB->editAttributes() ?> aria-describedby="x_NAME_OF_JOB_help">
<?= $Page->NAME_OF_JOB->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->NAME_OF_JOB->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->DESCRIPTION->Visible) { // DESCRIPTION ?>
    <div id="r_DESCRIPTION" class="form-group row">
        <label id="elh_JOB_CATEGORY_DESCRIPTION" for="x_DESCRIPTION" class="<?= $Page->LeftColumnClass ?>"><?= $Page->DESCRIPTION->caption() ?><?= $Page->DESCRIPTION->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->DESCRIPTION->cellAttributes() ?>>
<span id="el_JOB_CATEGORY_DESCRIPTION">
<input type="<?= $Page->DESCRIPTION->getInputTextType() ?>" data-table="JOB_CATEGORY" data-field="x_DESCRIPTION" name="x_DESCRIPTION" id="x_DESCRIPTION" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->DESCRIPTION->getPlaceHolder()) ?>" value="<?= $Page->DESCRIPTION->EditValue ?>"<?= $Page->DESCRIPTION->editAttributes() ?> aria-describedby="x_DESCRIPTION_help">
<?= $Page->DESCRIPTION->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->DESCRIPTION->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$Page->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("AddBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("JOB_CATEGORY");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
