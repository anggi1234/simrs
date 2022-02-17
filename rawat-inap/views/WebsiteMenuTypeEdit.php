<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

// Page object
$WebsiteMenuTypeEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fWEBSITE_MENU_TYPEedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fWEBSITE_MENU_TYPEedit = currentForm = new ew.Form("fWEBSITE_MENU_TYPEedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "WEBSITE_MENU_TYPE")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.WEBSITE_MENU_TYPE)
        ew.vars.tables.WEBSITE_MENU_TYPE = currentTable;
    fWEBSITE_MENU_TYPEedit.addFields([
        ["menu_type", [fields.menu_type.visible && fields.menu_type.required ? ew.Validators.required(fields.menu_type.caption) : null, ew.Validators.integer], fields.menu_type.isInvalid],
        ["menutype", [fields.menutype.visible && fields.menutype.required ? ew.Validators.required(fields.menutype.caption) : null], fields.menutype.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fWEBSITE_MENU_TYPEedit,
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
    fWEBSITE_MENU_TYPEedit.validate = function () {
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
    fWEBSITE_MENU_TYPEedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fWEBSITE_MENU_TYPEedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fWEBSITE_MENU_TYPEedit");
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
<form name="fWEBSITE_MENU_TYPEedit" id="fWEBSITE_MENU_TYPEedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="WEBSITE_MENU_TYPE">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->menu_type->Visible) { // menu_type ?>
    <div id="r_menu_type" class="form-group row">
        <label id="elh_WEBSITE_MENU_TYPE_menu_type" for="x_menu_type" class="<?= $Page->LeftColumnClass ?>"><?= $Page->menu_type->caption() ?><?= $Page->menu_type->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->menu_type->cellAttributes() ?>>
<input type="<?= $Page->menu_type->getInputTextType() ?>" data-table="WEBSITE_MENU_TYPE" data-field="x_menu_type" name="x_menu_type" id="x_menu_type" size="30" placeholder="<?= HtmlEncode($Page->menu_type->getPlaceHolder()) ?>" value="<?= $Page->menu_type->EditValue ?>"<?= $Page->menu_type->editAttributes() ?> aria-describedby="x_menu_type_help">
<?= $Page->menu_type->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->menu_type->getErrorMessage() ?></div>
<input type="hidden" data-table="WEBSITE_MENU_TYPE" data-field="x_menu_type" data-hidden="1" name="o_menu_type" id="o_menu_type" value="<?= HtmlEncode($Page->menu_type->OldValue ?? $Page->menu_type->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->menutype->Visible) { // menutype ?>
    <div id="r_menutype" class="form-group row">
        <label id="elh_WEBSITE_MENU_TYPE_menutype" for="x_menutype" class="<?= $Page->LeftColumnClass ?>"><?= $Page->menutype->caption() ?><?= $Page->menutype->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->menutype->cellAttributes() ?>>
<span id="el_WEBSITE_MENU_TYPE_menutype">
<input type="<?= $Page->menutype->getInputTextType() ?>" data-table="WEBSITE_MENU_TYPE" data-field="x_menutype" name="x_menutype" id="x_menutype" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->menutype->getPlaceHolder()) ?>" value="<?= $Page->menutype->EditValue ?>"<?= $Page->menutype->editAttributes() ?> aria-describedby="x_menutype_help">
<?= $Page->menutype->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->menutype->getErrorMessage() ?></div>
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
    ew.addEventHandlers("WEBSITE_MENU_TYPE");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
