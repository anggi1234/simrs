<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

// Page object
$WebsiteMenuEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fWEBSITE_MENUedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fWEBSITE_MENUedit = currentForm = new ew.Form("fWEBSITE_MENUedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "WEBSITE_MENU")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.WEBSITE_MENU)
        ew.vars.tables.WEBSITE_MENU = currentTable;
    fWEBSITE_MENUedit.addFields([
        ["MENU_ID", [fields.MENU_ID.visible && fields.MENU_ID.required ? ew.Validators.required(fields.MENU_ID.caption) : null, ew.Validators.integer], fields.MENU_ID.isInvalid],
        ["javascript_id", [fields.javascript_id.visible && fields.javascript_id.required ? ew.Validators.required(fields.javascript_id.caption) : null], fields.javascript_id.isInvalid],
        ["file_name", [fields.file_name.visible && fields.file_name.required ? ew.Validators.required(fields.file_name.caption) : null], fields.file_name.isInvalid],
        ["menu_name", [fields.menu_name.visible && fields.menu_name.required ? ew.Validators.required(fields.menu_name.caption) : null], fields.menu_name.isInvalid],
        ["isactive", [fields.isactive.visible && fields.isactive.required ? ew.Validators.required(fields.isactive.caption) : null], fields.isactive.isInvalid],
        ["menu_type", [fields.menu_type.visible && fields.menu_type.required ? ew.Validators.required(fields.menu_type.caption) : null, ew.Validators.integer], fields.menu_type.isInvalid],
        ["header_name", [fields.header_name.visible && fields.header_name.required ? ew.Validators.required(fields.header_name.caption) : null], fields.header_name.isInvalid],
        ["isslide", [fields.isslide.visible && fields.isslide.required ? ew.Validators.required(fields.isslide.caption) : null], fields.isslide.isInvalid],
        ["timeslide", [fields.timeslide.visible && fields.timeslide.required ? ew.Validators.required(fields.timeslide.caption) : null, ew.Validators.integer], fields.timeslide.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fWEBSITE_MENUedit,
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
    fWEBSITE_MENUedit.validate = function () {
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
    fWEBSITE_MENUedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fWEBSITE_MENUedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fWEBSITE_MENUedit");
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
<form name="fWEBSITE_MENUedit" id="fWEBSITE_MENUedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="WEBSITE_MENU">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->MENU_ID->Visible) { // MENU_ID ?>
    <div id="r_MENU_ID" class="form-group row">
        <label id="elh_WEBSITE_MENU_MENU_ID" for="x_MENU_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->MENU_ID->caption() ?><?= $Page->MENU_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->MENU_ID->cellAttributes() ?>>
<input type="<?= $Page->MENU_ID->getInputTextType() ?>" data-table="WEBSITE_MENU" data-field="x_MENU_ID" name="x_MENU_ID" id="x_MENU_ID" size="30" placeholder="<?= HtmlEncode($Page->MENU_ID->getPlaceHolder()) ?>" value="<?= $Page->MENU_ID->EditValue ?>"<?= $Page->MENU_ID->editAttributes() ?> aria-describedby="x_MENU_ID_help">
<?= $Page->MENU_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->MENU_ID->getErrorMessage() ?></div>
<input type="hidden" data-table="WEBSITE_MENU" data-field="x_MENU_ID" data-hidden="1" name="o_MENU_ID" id="o_MENU_ID" value="<?= HtmlEncode($Page->MENU_ID->OldValue ?? $Page->MENU_ID->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->javascript_id->Visible) { // javascript_id ?>
    <div id="r_javascript_id" class="form-group row">
        <label id="elh_WEBSITE_MENU_javascript_id" for="x_javascript_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->javascript_id->caption() ?><?= $Page->javascript_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->javascript_id->cellAttributes() ?>>
<span id="el_WEBSITE_MENU_javascript_id">
<input type="<?= $Page->javascript_id->getInputTextType() ?>" data-table="WEBSITE_MENU" data-field="x_javascript_id" name="x_javascript_id" id="x_javascript_id" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->javascript_id->getPlaceHolder()) ?>" value="<?= $Page->javascript_id->EditValue ?>"<?= $Page->javascript_id->editAttributes() ?> aria-describedby="x_javascript_id_help">
<?= $Page->javascript_id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->javascript_id->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->file_name->Visible) { // file_name ?>
    <div id="r_file_name" class="form-group row">
        <label id="elh_WEBSITE_MENU_file_name" for="x_file_name" class="<?= $Page->LeftColumnClass ?>"><?= $Page->file_name->caption() ?><?= $Page->file_name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->file_name->cellAttributes() ?>>
<span id="el_WEBSITE_MENU_file_name">
<input type="<?= $Page->file_name->getInputTextType() ?>" data-table="WEBSITE_MENU" data-field="x_file_name" name="x_file_name" id="x_file_name" size="30" maxlength="200" placeholder="<?= HtmlEncode($Page->file_name->getPlaceHolder()) ?>" value="<?= $Page->file_name->EditValue ?>"<?= $Page->file_name->editAttributes() ?> aria-describedby="x_file_name_help">
<?= $Page->file_name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->file_name->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->menu_name->Visible) { // menu_name ?>
    <div id="r_menu_name" class="form-group row">
        <label id="elh_WEBSITE_MENU_menu_name" for="x_menu_name" class="<?= $Page->LeftColumnClass ?>"><?= $Page->menu_name->caption() ?><?= $Page->menu_name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->menu_name->cellAttributes() ?>>
<span id="el_WEBSITE_MENU_menu_name">
<input type="<?= $Page->menu_name->getInputTextType() ?>" data-table="WEBSITE_MENU" data-field="x_menu_name" name="x_menu_name" id="x_menu_name" size="30" maxlength="200" placeholder="<?= HtmlEncode($Page->menu_name->getPlaceHolder()) ?>" value="<?= $Page->menu_name->EditValue ?>"<?= $Page->menu_name->editAttributes() ?> aria-describedby="x_menu_name_help">
<?= $Page->menu_name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->menu_name->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->isactive->Visible) { // isactive ?>
    <div id="r_isactive" class="form-group row">
        <label id="elh_WEBSITE_MENU_isactive" for="x_isactive" class="<?= $Page->LeftColumnClass ?>"><?= $Page->isactive->caption() ?><?= $Page->isactive->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->isactive->cellAttributes() ?>>
<span id="el_WEBSITE_MENU_isactive">
<input type="<?= $Page->isactive->getInputTextType() ?>" data-table="WEBSITE_MENU" data-field="x_isactive" name="x_isactive" id="x_isactive" size="30" maxlength="1" placeholder="<?= HtmlEncode($Page->isactive->getPlaceHolder()) ?>" value="<?= $Page->isactive->EditValue ?>"<?= $Page->isactive->editAttributes() ?> aria-describedby="x_isactive_help">
<?= $Page->isactive->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->isactive->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->menu_type->Visible) { // menu_type ?>
    <div id="r_menu_type" class="form-group row">
        <label id="elh_WEBSITE_MENU_menu_type" for="x_menu_type" class="<?= $Page->LeftColumnClass ?>"><?= $Page->menu_type->caption() ?><?= $Page->menu_type->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->menu_type->cellAttributes() ?>>
<span id="el_WEBSITE_MENU_menu_type">
<input type="<?= $Page->menu_type->getInputTextType() ?>" data-table="WEBSITE_MENU" data-field="x_menu_type" name="x_menu_type" id="x_menu_type" size="30" placeholder="<?= HtmlEncode($Page->menu_type->getPlaceHolder()) ?>" value="<?= $Page->menu_type->EditValue ?>"<?= $Page->menu_type->editAttributes() ?> aria-describedby="x_menu_type_help">
<?= $Page->menu_type->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->menu_type->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->header_name->Visible) { // header_name ?>
    <div id="r_header_name" class="form-group row">
        <label id="elh_WEBSITE_MENU_header_name" for="x_header_name" class="<?= $Page->LeftColumnClass ?>"><?= $Page->header_name->caption() ?><?= $Page->header_name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->header_name->cellAttributes() ?>>
<span id="el_WEBSITE_MENU_header_name">
<input type="<?= $Page->header_name->getInputTextType() ?>" data-table="WEBSITE_MENU" data-field="x_header_name" name="x_header_name" id="x_header_name" size="30" maxlength="200" placeholder="<?= HtmlEncode($Page->header_name->getPlaceHolder()) ?>" value="<?= $Page->header_name->EditValue ?>"<?= $Page->header_name->editAttributes() ?> aria-describedby="x_header_name_help">
<?= $Page->header_name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->header_name->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->isslide->Visible) { // isslide ?>
    <div id="r_isslide" class="form-group row">
        <label id="elh_WEBSITE_MENU_isslide" for="x_isslide" class="<?= $Page->LeftColumnClass ?>"><?= $Page->isslide->caption() ?><?= $Page->isslide->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->isslide->cellAttributes() ?>>
<span id="el_WEBSITE_MENU_isslide">
<input type="<?= $Page->isslide->getInputTextType() ?>" data-table="WEBSITE_MENU" data-field="x_isslide" name="x_isslide" id="x_isslide" size="30" maxlength="1" placeholder="<?= HtmlEncode($Page->isslide->getPlaceHolder()) ?>" value="<?= $Page->isslide->EditValue ?>"<?= $Page->isslide->editAttributes() ?> aria-describedby="x_isslide_help">
<?= $Page->isslide->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->isslide->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->timeslide->Visible) { // timeslide ?>
    <div id="r_timeslide" class="form-group row">
        <label id="elh_WEBSITE_MENU_timeslide" for="x_timeslide" class="<?= $Page->LeftColumnClass ?>"><?= $Page->timeslide->caption() ?><?= $Page->timeslide->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->timeslide->cellAttributes() ?>>
<span id="el_WEBSITE_MENU_timeslide">
<input type="<?= $Page->timeslide->getInputTextType() ?>" data-table="WEBSITE_MENU" data-field="x_timeslide" name="x_timeslide" id="x_timeslide" size="30" placeholder="<?= HtmlEncode($Page->timeslide->getPlaceHolder()) ?>" value="<?= $Page->timeslide->EditValue ?>"<?= $Page->timeslide->editAttributes() ?> aria-describedby="x_timeslide_help">
<?= $Page->timeslide->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->timeslide->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$Page->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("SaveBtn") ?></button>
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
    ew.addEventHandlers("WEBSITE_MENU");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
