<?php

namespace PHPMaker2021\SIMRSSQLSERVERRADIOLOGI;

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
$sideMenu->addMenuItem(6281, "mi_Dashboard2", $MenuLanguage->MenuPhrase("6281", "MenuText"), $MenuRelativePath . "Dashboard2", -1, "", AllowListMenu('{F2EB688D-9DF4-4C42-A00E-6FA68361A137}Dashboard'), false, false, "", "", false);
$sideMenu->addMenuItem(470, "mci_Daftar_Rajal/IGD", $MenuLanguage->MenuPhrase("470", "MenuText"), $MenuRelativePath . "PasienVisitationAdd", 467, "", IsLoggedIn(), false, true, "", "", false);
$sideMenu->addMenuItem(5761, "mci_Daftar_Pasien_Baru", $MenuLanguage->MenuPhrase("5761", "MenuText"), $MenuRelativePath . "PasienAdd", 467, "", IsLoggedIn(), false, true, "", "", false);
$sideMenu->addMenuItem(6269, "mi_v_riwayat_sep", $MenuLanguage->MenuPhrase("6269", "MenuText"), $MenuRelativePath . "VRiwayatSepList", 467, "", AllowListMenu('{F2EB688D-9DF4-4C42-A00E-6FA68361A137}v_riwayat_sep'), false, false, "", "", false);
$sideMenu->addMenuItem(471, "mi_V_DAFTAR_PASIEN", $MenuLanguage->MenuPhrase("471", "MenuText"), $MenuRelativePath . "VDaftarPasienList", 467, "", AllowListMenu('{F2EB688D-9DF4-4C42-A00E-6FA68361A137}V_DAFTAR_PASIEN'), false, false, "", "", false);
$sideMenu->addMenuItem(2837, "mci_Laporan", $MenuLanguage->MenuPhrase("2837", "MenuText"), "", 467, "", IsLoggedIn(), false, true, "", "", false);
$sideMenu->addMenuItem(2840, "mi_V_SENSUS", $MenuLanguage->MenuPhrase("2840", "MenuText"), $MenuRelativePath . "VSensusList", 2837, "", AllowListMenu('{F2EB688D-9DF4-4C42-A00E-6FA68361A137}V_SENSUS'), false, false, "", "", false);
$sideMenu->addMenuItem(6267, "mi_V_KUNJUNGAN", $MenuLanguage->MenuPhrase("6267", "MenuText"), $MenuRelativePath . "VKunjunganList", 2837, "", AllowListMenu('{F2EB688D-9DF4-4C42-A00E-6FA68361A137}V_KUNJUNGAN'), false, false, "", "", false);
$sideMenu->addMenuItem(321, "mi_PASIEN_VISITATION", $MenuLanguage->MenuPhrase("321", "MenuText"), $MenuRelativePath . "PasienVisitationList", 468, "", AllowListMenu('{F2EB688D-9DF4-4C42-A00E-6FA68361A137}PASIEN_VISITATION'), false, false, "", "", false);
$sideMenu->addMenuItem(4786, "mci_Laporan", $MenuLanguage->MenuPhrase("4786", "MenuText"), "", 468, "", IsLoggedIn(), false, true, "", "", false);
$sideMenu->addMenuItem(4287, "mi_register_pasien", $MenuLanguage->MenuPhrase("4287", "MenuText"), $MenuRelativePath . "RegisterPasien", 4786, "", AllowListMenu('{F2EB688D-9DF4-4C42-A00E-6FA68361A137}register_pasien'), false, false, "", "", false);
$sideMenu->addMenuItem(5274, "mi_register_cara_bayar", $MenuLanguage->MenuPhrase("5274", "MenuText"), $MenuRelativePath . "RegisterCaraBayar", 4786, "", AllowListMenu('{F2EB688D-9DF4-4C42-A00E-6FA68361A137}register_cara_bayar'), false, false, "", "", false);
$sideMenu->addMenuItem(6282, "mi_register_perpoli_harian", $MenuLanguage->MenuPhrase("6282", "MenuText"), $MenuRelativePath . "RegisterPerpoliHarian", 4786, "", AllowListMenu('{F2EB688D-9DF4-4C42-A00E-6FA68361A137}register_perpoli_harian'), false, false, "", "", false);
$sideMenu->addMenuItem(6283, "mi_register_perpoli_bulanan", $MenuLanguage->MenuPhrase("6283", "MenuText"), $MenuRelativePath . "RegisterPerpoliBulanan", 4786, "", AllowListMenu('{F2EB688D-9DF4-4C42-A00E-6FA68361A137}register_perpoli_bulanan'), false, false, "", "", false);
$sideMenu->addMenuItem(6284, "mi_register_perpoli_tahunan", $MenuLanguage->MenuPhrase("6284", "MenuText"), $MenuRelativePath . "RegisterPerpoliTahunan", 4786, "", AllowListMenu('{F2EB688D-9DF4-4C42-A00E-6FA68361A137}register_perpoli_tahunan'), false, false, "", "", false);
$sideMenu->addMenuItem(3323, "mci_Master", $MenuLanguage->MenuPhrase("3323", "MenuText"), "", 468, "", IsLoggedIn(), false, true, "", "", false);
$sideMenu->addMenuItem(148, "mi_EMPLOYEE_ALL", $MenuLanguage->MenuPhrase("148", "MenuText"), $MenuRelativePath . "EmployeeAllList", 3323, "", AllowListMenu('{F2EB688D-9DF4-4C42-A00E-6FA68361A137}EMPLOYEE_ALL'), false, false, "", "", false);
$sideMenu->addMenuItem(4288, "mi_V_KUNJUNGAN_PASIEN", $MenuLanguage->MenuPhrase("4288", "MenuText"), $MenuRelativePath . "VKunjunganPasienList", 1413, "", AllowListMenu('{F2EB688D-9DF4-4C42-A00E-6FA68361A137}V_KUNJUNGAN_PASIEN'), false, false, "", "", false);
$sideMenu->addMenuItem(76, "mi_CLASS_ROOM", $MenuLanguage->MenuPhrase("76", "MenuText"), $MenuRelativePath . "ClassRoomList", 1413, "", AllowListMenu('{F2EB688D-9DF4-4C42-A00E-6FA68361A137}CLASS_ROOM'), false, false, "", "", false);
$sideMenu->addMenuItem(5273, "mci_Laporan", $MenuLanguage->MenuPhrase("5273", "MenuText"), "", 1413, "", IsLoggedIn(), false, true, "", "", false);
$sideMenu->addMenuItem(6285, "mi_register_ranap", $MenuLanguage->MenuPhrase("6285", "MenuText"), $MenuRelativePath . "RegisterRanap", 5273, "", AllowListMenu('{F2EB688D-9DF4-4C42-A00E-6FA68361A137}register_ranap'), false, false, "", "", false);
$sideMenu->addMenuItem(6277, "mi_V_LABORATORIUM", $MenuLanguage->MenuPhrase("6277", "MenuText"), $MenuRelativePath . "VLaboratoriumList", 3804, "", AllowListMenu('{F2EB688D-9DF4-4C42-A00E-6FA68361A137}V_LABORATORIUM'), false, false, "", "", false);
$sideMenu->addMenuItem(4281, "mci_Radiologi", $MenuLanguage->MenuPhrase("4281", "MenuText"), "", -1, "", IsLoggedIn(), false, true, "", "", false);
$sideMenu->addMenuItem(6278, "mi_V_RADIOLOGI", $MenuLanguage->MenuPhrase("6278", "MenuText"), $MenuRelativePath . "VRadiologiList", 4281, "", AllowListMenu('{F2EB688D-9DF4-4C42-A00E-6FA68361A137}V_RADIOLOGI'), false, false, "", "", false);
$sideMenu->addMenuItem(6287, "mi_V_RAWAT_INAP", $MenuLanguage->MenuPhrase("6287", "MenuText"), $MenuRelativePath . "VRawatInapList", 4281, "", AllowListMenu('{F2EB688D-9DF4-4C42-A00E-6FA68361A137}V_RAWAT_INAP'), false, false, "", "", false);
$sideMenu->addMenuItem(6274, "mi_V_FARMASI", $MenuLanguage->MenuPhrase("6274", "MenuText"), $MenuRelativePath . "VFarmasiList", 1881, "", AllowListMenu('{F2EB688D-9DF4-4C42-A00E-6FA68361A137}V_FARMASI'), false, false, "", "", false);
$sideMenu->addMenuItem(6275, "mi_V_KASIR", $MenuLanguage->MenuPhrase("6275", "MenuText"), $MenuRelativePath . "VKasirList", 1880, "", AllowListMenu('{F2EB688D-9DF4-4C42-A00E-6FA68361A137}V_KASIR'), false, false, "", "", false);
$sideMenu->addMenuItem(6276, "mi_V_REKAM_MEDIS", $MenuLanguage->MenuPhrase("6276", "MenuText"), $MenuRelativePath . "VRekamMedisList", 2363, "", AllowListMenu('{F2EB688D-9DF4-4C42-A00E-6FA68361A137}V_REKAM_MEDIS'), false, false, "", "", false);
$sideMenu->addMenuItem(6268, "mi_V_RIWAYAT_RM", $MenuLanguage->MenuPhrase("6268", "MenuText"), $MenuRelativePath . "VRiwayatRmList", 2363, "", AllowListMenu('{F2EB688D-9DF4-4C42-A00E-6FA68361A137}V_RIWAYAT_RM'), false, false, "", "", false);
$sideMenu->addMenuItem(6261, "mci_Laporan", $MenuLanguage->MenuPhrase("6261", "MenuText"), "", 2363, "", IsLoggedIn(), false, true, "", "", false);
$sideMenu->addMenuItem(5762, "mi_penyakit_menular", $MenuLanguage->MenuPhrase("5762", "MenuText"), $MenuRelativePath . "PenyakitMenular", 6261, "", AllowListMenu('{F2EB688D-9DF4-4C42-A00E-6FA68361A137}penyakit_menular'), false, false, "", "", false);
$sideMenu->addMenuItem(6265, "mi_mata_dan_syaraf", $MenuLanguage->MenuPhrase("6265", "MenuText"), $MenuRelativePath . "MataDanSyaraf", 6261, "", AllowListMenu('{F2EB688D-9DF4-4C42-A00E-6FA68361A137}mata_dan_syaraf'), false, false, "", "", false);
$sideMenu->addMenuItem(6263, "mci_Master", $MenuLanguage->MenuPhrase("6263", "MenuText"), "", 2363, "", IsLoggedIn(), false, true, "", "", false);
$sideMenu->addMenuItem(123, "mi_DIAGNOSA", $MenuLanguage->MenuPhrase("123", "MenuText"), $MenuRelativePath . "DiagnosaList", 6263, "", AllowListMenu('{F2EB688D-9DF4-4C42-A00E-6FA68361A137}DIAGNOSA'), false, false, "", "", false);
$sideMenu->addMenuItem(4787, "mci_Master", $MenuLanguage->MenuPhrase("4787", "MenuText"), "", 1882, "", IsLoggedIn(), false, true, "", "", false);
$sideMenu->addMenuItem(4284, "mi_l_set_cssd", $MenuLanguage->MenuPhrase("4284", "MenuText"), $MenuRelativePath . "LSetCssdList", 4787, "", AllowListMenu('{F2EB688D-9DF4-4C42-A00E-6FA68361A137}l_set_cssd'), false, false, "", "", false);
$sideMenu->addMenuItem(4285, "mi_m_alat_cssd", $MenuLanguage->MenuPhrase("4285", "MenuText"), $MenuRelativePath . "MAlatCssdList", 4787, "", AllowListMenu('{F2EB688D-9DF4-4C42-A00E-6FA68361A137}m_alat_cssd'), false, false, "", "", false);
$sideMenu->addMenuItem(1883, "mci_Mutasi_Barang", $MenuLanguage->MenuPhrase("1883", "MenuText"), "", -1, "", IsLoggedIn(), false, true, "", "", false);
$sideMenu->addMenuItem(1887, "mci_Permintaan_Barang_Alkes", $MenuLanguage->MenuPhrase("1887", "MenuText"), $MenuRelativePath . "MutationDocsAdd", 1883, "", IsLoggedIn(), false, true, "", "", false);
$sideMenu->addMenuItem(284, "mi_MUTATION_DOCS", $MenuLanguage->MenuPhrase("284", "MenuText"), $MenuRelativePath . "MutationDocsList", 1883, "", AllowListMenu('{F2EB688D-9DF4-4C42-A00E-6FA68361A137}MUTATION_DOCS'), false, false, "", "", false);
$sideMenu->addMenuItem(448, "mi_USER_LOGIN", $MenuLanguage->MenuPhrase("448", "MenuText"), $MenuRelativePath . "UserLoginList", 940, "", AllowListMenu('{F2EB688D-9DF4-4C42-A00E-6FA68361A137}USER_LOGIN'), false, false, "", "", false);
$sideMenu->addMenuItem(6286, "mi_V_EMPLOYE", $MenuLanguage->MenuPhrase("6286", "MenuText"), $MenuRelativePath . "VEmployeList", 940, "", AllowListMenu('{F2EB688D-9DF4-4C42-A00E-6FA68361A137}V_EMPLOYE'), false, false, "", "", false);
$sideMenu->addMenuItem(430, "mi_TREAT_TARIF", $MenuLanguage->MenuPhrase("430", "MenuText"), $MenuRelativePath . "TreatTarifList", 940, "", AllowListMenu('{F2EB688D-9DF4-4C42-A00E-6FA68361A137}TREAT_TARIF'), false, false, "", "", false);
echo $sideMenu->toScript();
