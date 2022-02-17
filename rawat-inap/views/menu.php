<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAWATINAP;

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
$sideMenu->addMenuItem(6290, "mi_V_REG_AKOMODASI", $MenuLanguage->MenuPhrase("6290", "MenuText"), $MenuRelativePath . "VRegAkomodasiList?cmd=resetall", -1, "", AllowListMenu('{A8247593-7AB1-4063-96EC-65D23DBC1338}V_REG_AKOMODASI'), false, false, "", "", false);
$sideMenu->addMenuItem(6281, "mi_Dashboard2", $MenuLanguage->MenuPhrase("6281", "MenuText"), $MenuRelativePath . "Dashboard2", -1, "", AllowListMenu('{A8247593-7AB1-4063-96EC-65D23DBC1338}Dashboard'), false, false, "", "", false);
$sideMenu->addMenuItem(1413, "mci_Rawat_Inap", $MenuLanguage->MenuPhrase("1413", "MenuText"), "", -1, "", IsLoggedIn(), false, true, "", "", false);
$sideMenu->addMenuItem(321, "mi_PASIEN_VISITATION", $MenuLanguage->MenuPhrase("321", "MenuText"), $MenuRelativePath . "PasienVisitationList", 1413, "", AllowListMenu('{A8247593-7AB1-4063-96EC-65D23DBC1338}PASIEN_VISITATION'), false, false, "", "", false);
$sideMenu->addMenuItem(6287, "mi_V_RAWAT_INAP", $MenuLanguage->MenuPhrase("6287", "MenuText"), $MenuRelativePath . "VRawatInapList", 1413, "", AllowListMenu('{A8247593-7AB1-4063-96EC-65D23DBC1338}V_RAWAT_INAP'), false, false, "", "", false);
$sideMenu->addMenuItem(76, "mi_CLASS_ROOM", $MenuLanguage->MenuPhrase("76", "MenuText"), $MenuRelativePath . "ClassRoomList", 1413, "", AllowListMenu('{A8247593-7AB1-4063-96EC-65D23DBC1338}CLASS_ROOM'), false, false, "", "", false);
$sideMenu->addMenuItem(5273, "mci_Laporan", $MenuLanguage->MenuPhrase("5273", "MenuText"), "", 1413, "", IsLoggedIn(), false, true, "", "", false);
$sideMenu->addMenuItem(6285, "mi_register_ranap", $MenuLanguage->MenuPhrase("6285", "MenuText"), $MenuRelativePath . "RegisterRanap", 5273, "", AllowListMenu('{A8247593-7AB1-4063-96EC-65D23DBC1338}register_ranap'), false, false, "", "", false);
$sideMenu->addMenuItem(466, "mi_V_TREATMENTBILL", $MenuLanguage->MenuPhrase("466", "MenuText"), $MenuRelativePath . "VTreatmentbillList", 1880, "", AllowListMenu('{A8247593-7AB1-4063-96EC-65D23DBC1338}V_TREATMENTBILL'), false, false, "", "", false);
$sideMenu->addMenuItem(6276, "mi_V_REKAM_MEDIS", $MenuLanguage->MenuPhrase("6276", "MenuText"), $MenuRelativePath . "VRekamMedisList", 2363, "", AllowListMenu('{A8247593-7AB1-4063-96EC-65D23DBC1338}V_REKAM_MEDIS'), false, false, "", "", false);
$sideMenu->addMenuItem(6268, "mi_V_RIWAYAT_RM", $MenuLanguage->MenuPhrase("6268", "MenuText"), $MenuRelativePath . "VRiwayatRmList", 2363, "", AllowListMenu('{A8247593-7AB1-4063-96EC-65D23DBC1338}V_RIWAYAT_RM'), false, false, "", "", false);
$sideMenu->addMenuItem(6261, "mci_Laporan", $MenuLanguage->MenuPhrase("6261", "MenuText"), "", 2363, "", IsLoggedIn(), false, true, "", "", false);
$sideMenu->addMenuItem(5762, "mi_penyakit_menular", $MenuLanguage->MenuPhrase("5762", "MenuText"), $MenuRelativePath . "PenyakitMenular", 6261, "", AllowListMenu('{A8247593-7AB1-4063-96EC-65D23DBC1338}penyakit_menular'), false, false, "", "", false);
$sideMenu->addMenuItem(6265, "mi_mata_dan_syaraf", $MenuLanguage->MenuPhrase("6265", "MenuText"), $MenuRelativePath . "MataDanSyaraf", 6261, "", AllowListMenu('{A8247593-7AB1-4063-96EC-65D23DBC1338}mata_dan_syaraf'), false, false, "", "", false);
$sideMenu->addMenuItem(6263, "mci_Master", $MenuLanguage->MenuPhrase("6263", "MenuText"), "", 2363, "", IsLoggedIn(), false, true, "", "", false);
$sideMenu->addMenuItem(123, "mi_DIAGNOSA", $MenuLanguage->MenuPhrase("123", "MenuText"), $MenuRelativePath . "DiagnosaList", 6263, "", AllowListMenu('{A8247593-7AB1-4063-96EC-65D23DBC1338}DIAGNOSA'), false, false, "", "", false);
$sideMenu->addMenuItem(1883, "mci_Mutasi_Barang", $MenuLanguage->MenuPhrase("1883", "MenuText"), "", -1, "", IsLoggedIn(), false, true, "", "", false);
$sideMenu->addMenuItem(1887, "mci_Permintaan_Barang_Alkes", $MenuLanguage->MenuPhrase("1887", "MenuText"), $MenuRelativePath . "MutationDocsAdd", 1883, "", IsLoggedIn(), false, true, "", "", false);
$sideMenu->addMenuItem(284, "mi_MUTATION_DOCS", $MenuLanguage->MenuPhrase("284", "MenuText"), $MenuRelativePath . "MutationDocsList", 1883, "", AllowListMenu('{A8247593-7AB1-4063-96EC-65D23DBC1338}MUTATION_DOCS'), false, false, "", "", false);
echo $sideMenu->toScript();
