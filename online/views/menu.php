<?php

namespace PHPMaker2021\Online;

// Menu Language
if ($Language && function_exists(PROJECT_NAMESPACE . "Config") && $Language->LanguageFolder == Config("LANGUAGE_FOLDER")) {
    $MenuRelativePath = "";
    $MenuLanguage = &$Language;
} else { // Compat reports
    $LANGUAGE_FOLDER = "../lang/";
    $MenuRelativePath = "../";
    $MenuLanguage = Container("language");
}

// Navbar menu
$topMenu = new Menu("navbar", true, true);
echo $topMenu->toScript();

// Sidebar menu
$sideMenu = new Menu("menu", true, false);
$sideMenu->addMenuItem(467, "mci_Pendaftaran", $MenuLanguage->MenuPhrase("467", "MenuText"), "", -1, "", IsLoggedIn(), false, true, "", "", false);
$sideMenu->addMenuItem(4783, "mi_V_daftarantri", $MenuLanguage->MenuPhrase("4783", "MenuText"), $MenuRelativePath . "VDaftarantriList", 467, "", IsLoggedIn() || AllowListMenu('{59E199C8-0BE6-40EC-8BD8-7401FBEA08A1}V_daftarantri'), false, false, "", "", false);
$sideMenu->addMenuItem(4784, "mi_V_daftardis", $MenuLanguage->MenuPhrase("4784", "MenuText"), $MenuRelativePath . "VDaftardisList", 467, "", IsLoggedIn() || AllowListMenu('{59E199C8-0BE6-40EC-8BD8-7401FBEA08A1}V_daftardis'), false, false, "", "", false);
echo $sideMenu->toScript();
