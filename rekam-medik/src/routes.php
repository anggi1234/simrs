<?php

namespace PHPMaker2021\SIMRSSQLSERVERREKAMMEDIK;

use Slim\App;
use Slim\Routing\RouteCollectorProxy;

// Handle Routes
return function (App $app) {
    // CLASS_ROOM
    $app->any('/ClassRoomList[/{ORG_UNIT_CODE}/{CLASS_ROOM_ID}]', ClassRoomController::class . ':list')->add(PermissionMiddleware::class)->setName('ClassRoomList-CLASS_ROOM-list'); // list
    $app->group(
        '/CLASS_ROOM',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{ORG_UNIT_CODE}/{CLASS_ROOM_ID}]', ClassRoomController::class . ':list')->add(PermissionMiddleware::class)->setName('CLASS_ROOM/list-CLASS_ROOM-list-2'); // list
        }
    );

    // DIAGNOSA
    $app->any('/DiagnosaList[/{DIAGNOSA_ID}]', DiagnosaController::class . ':list')->add(PermissionMiddleware::class)->setName('DiagnosaList-DIAGNOSA-list'); // list
    $app->any('/DiagnosaAdd[/{DIAGNOSA_ID}]', DiagnosaController::class . ':add')->add(PermissionMiddleware::class)->setName('DiagnosaAdd-DIAGNOSA-add'); // add
    $app->any('/DiagnosaEdit[/{DIAGNOSA_ID}]', DiagnosaController::class . ':edit')->add(PermissionMiddleware::class)->setName('DiagnosaEdit-DIAGNOSA-edit'); // edit
    $app->any('/DiagnosaDelete[/{DIAGNOSA_ID}]', DiagnosaController::class . ':delete')->add(PermissionMiddleware::class)->setName('DiagnosaDelete-DIAGNOSA-delete'); // delete
    $app->group(
        '/DIAGNOSA',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{DIAGNOSA_ID}]', DiagnosaController::class . ':list')->add(PermissionMiddleware::class)->setName('DIAGNOSA/list-DIAGNOSA-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{DIAGNOSA_ID}]', DiagnosaController::class . ':add')->add(PermissionMiddleware::class)->setName('DIAGNOSA/add-DIAGNOSA-add-2'); // add
            $group->any('/' . Config("EDIT_ACTION") . '[/{DIAGNOSA_ID}]', DiagnosaController::class . ':edit')->add(PermissionMiddleware::class)->setName('DIAGNOSA/edit-DIAGNOSA-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{DIAGNOSA_ID}]', DiagnosaController::class . ':delete')->add(PermissionMiddleware::class)->setName('DIAGNOSA/delete-DIAGNOSA-delete-2'); // delete
        }
    );

    // EMPLOYEE_ALL
    $app->any('/EmployeeAllList[/{ORG_UNIT_CODE}/{EMPLOYEE_ID}]', EmployeeAllController::class . ':list')->add(PermissionMiddleware::class)->setName('EmployeeAllList-EMPLOYEE_ALL-list'); // list
    $app->group(
        '/EMPLOYEE_ALL',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{ORG_UNIT_CODE}/{EMPLOYEE_ID}]', EmployeeAllController::class . ':list')->add(PermissionMiddleware::class)->setName('EMPLOYEE_ALL/list-EMPLOYEE_ALL-list-2'); // list
        }
    );

    // MUTATION_DOCS
    $app->any('/MutationDocsList[/{ID}]', MutationDocsController::class . ':list')->add(PermissionMiddleware::class)->setName('MutationDocsList-MUTATION_DOCS-list'); // list
    $app->any('/MutationDocsAdd[/{ID}]', MutationDocsController::class . ':add')->add(PermissionMiddleware::class)->setName('MutationDocsAdd-MUTATION_DOCS-add'); // add
    $app->any('/MutationDocsView[/{ID}]', MutationDocsController::class . ':view')->add(PermissionMiddleware::class)->setName('MutationDocsView-MUTATION_DOCS-view'); // view
    $app->any('/MutationDocsEdit[/{ID}]', MutationDocsController::class . ':edit')->add(PermissionMiddleware::class)->setName('MutationDocsEdit-MUTATION_DOCS-edit'); // edit
    $app->any('/MutationDocsDelete[/{ID}]', MutationDocsController::class . ':delete')->add(PermissionMiddleware::class)->setName('MutationDocsDelete-MUTATION_DOCS-delete'); // delete
    $app->group(
        '/MUTATION_DOCS',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{ID}]', MutationDocsController::class . ':list')->add(PermissionMiddleware::class)->setName('MUTATION_DOCS/list-MUTATION_DOCS-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{ID}]', MutationDocsController::class . ':add')->add(PermissionMiddleware::class)->setName('MUTATION_DOCS/add-MUTATION_DOCS-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{ID}]', MutationDocsController::class . ':view')->add(PermissionMiddleware::class)->setName('MUTATION_DOCS/view-MUTATION_DOCS-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{ID}]', MutationDocsController::class . ':edit')->add(PermissionMiddleware::class)->setName('MUTATION_DOCS/edit-MUTATION_DOCS-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{ID}]', MutationDocsController::class . ':delete')->add(PermissionMiddleware::class)->setName('MUTATION_DOCS/delete-MUTATION_DOCS-delete-2'); // delete
        }
    );

    // PASIEN
    $app->any('/PasienList[/{ID}]', PasienController::class . ':list')->add(PermissionMiddleware::class)->setName('PasienList-PASIEN-list'); // list
    $app->any('/PasienAdd[/{ID}]', PasienController::class . ':add')->add(PermissionMiddleware::class)->setName('PasienAdd-PASIEN-add'); // add
    $app->any('/PasienView[/{ID}]', PasienController::class . ':view')->add(PermissionMiddleware::class)->setName('PasienView-PASIEN-view'); // view
    $app->any('/PasienEdit[/{ID}]', PasienController::class . ':edit')->add(PermissionMiddleware::class)->setName('PasienEdit-PASIEN-edit'); // edit
    $app->group(
        '/PASIEN',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{ID}]', PasienController::class . ':list')->add(PermissionMiddleware::class)->setName('PASIEN/list-PASIEN-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{ID}]', PasienController::class . ':add')->add(PermissionMiddleware::class)->setName('PASIEN/add-PASIEN-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{ID}]', PasienController::class . ':view')->add(PermissionMiddleware::class)->setName('PASIEN/view-PASIEN-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{ID}]', PasienController::class . ':edit')->add(PermissionMiddleware::class)->setName('PASIEN/edit-PASIEN-edit-2'); // edit
        }
    );

    // PASIEN_DIAGNOSA
    $app->any('/PasienDiagnosaList[/{ID}]', PasienDiagnosaController::class . ':list')->add(PermissionMiddleware::class)->setName('PasienDiagnosaList-PASIEN_DIAGNOSA-list'); // list
    $app->any('/PasienDiagnosaAdd[/{ID}]', PasienDiagnosaController::class . ':add')->add(PermissionMiddleware::class)->setName('PasienDiagnosaAdd-PASIEN_DIAGNOSA-add'); // add
    $app->any('/PasienDiagnosaView[/{ID}]', PasienDiagnosaController::class . ':view')->add(PermissionMiddleware::class)->setName('PasienDiagnosaView-PASIEN_DIAGNOSA-view'); // view
    $app->any('/PasienDiagnosaEdit[/{ID}]', PasienDiagnosaController::class . ':edit')->add(PermissionMiddleware::class)->setName('PasienDiagnosaEdit-PASIEN_DIAGNOSA-edit'); // edit
    $app->any('/PasienDiagnosaDelete[/{ID}]', PasienDiagnosaController::class . ':delete')->add(PermissionMiddleware::class)->setName('PasienDiagnosaDelete-PASIEN_DIAGNOSA-delete'); // delete
    $app->group(
        '/PASIEN_DIAGNOSA',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{ID}]', PasienDiagnosaController::class . ':list')->add(PermissionMiddleware::class)->setName('PASIEN_DIAGNOSA/list-PASIEN_DIAGNOSA-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{ID}]', PasienDiagnosaController::class . ':add')->add(PermissionMiddleware::class)->setName('PASIEN_DIAGNOSA/add-PASIEN_DIAGNOSA-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{ID}]', PasienDiagnosaController::class . ':view')->add(PermissionMiddleware::class)->setName('PASIEN_DIAGNOSA/view-PASIEN_DIAGNOSA-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{ID}]', PasienDiagnosaController::class . ':edit')->add(PermissionMiddleware::class)->setName('PASIEN_DIAGNOSA/edit-PASIEN_DIAGNOSA-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{ID}]', PasienDiagnosaController::class . ':delete')->add(PermissionMiddleware::class)->setName('PASIEN_DIAGNOSA/delete-PASIEN_DIAGNOSA-delete-2'); // delete
        }
    );

    // PASIEN_VISITATION
    $app->any('/PasienVisitationList[/{IDXDAFTAR}]', PasienVisitationController::class . ':list')->add(PermissionMiddleware::class)->setName('PasienVisitationList-PASIEN_VISITATION-list'); // list
    $app->any('/PasienVisitationAdd[/{IDXDAFTAR}]', PasienVisitationController::class . ':add')->add(PermissionMiddleware::class)->setName('PasienVisitationAdd-PASIEN_VISITATION-add'); // add
    $app->any('/PasienVisitationView[/{IDXDAFTAR}]', PasienVisitationController::class . ':view')->add(PermissionMiddleware::class)->setName('PasienVisitationView-PASIEN_VISITATION-view'); // view
    $app->any('/PasienVisitationEdit[/{IDXDAFTAR}]', PasienVisitationController::class . ':edit')->add(PermissionMiddleware::class)->setName('PasienVisitationEdit-PASIEN_VISITATION-edit'); // edit
    $app->any('/PasienVisitationSearch', PasienVisitationController::class . ':search')->add(PermissionMiddleware::class)->setName('PasienVisitationSearch-PASIEN_VISITATION-search'); // search
    $app->group(
        '/PASIEN_VISITATION',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{IDXDAFTAR}]', PasienVisitationController::class . ':list')->add(PermissionMiddleware::class)->setName('PASIEN_VISITATION/list-PASIEN_VISITATION-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{IDXDAFTAR}]', PasienVisitationController::class . ':add')->add(PermissionMiddleware::class)->setName('PASIEN_VISITATION/add-PASIEN_VISITATION-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{IDXDAFTAR}]', PasienVisitationController::class . ':view')->add(PermissionMiddleware::class)->setName('PASIEN_VISITATION/view-PASIEN_VISITATION-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{IDXDAFTAR}]', PasienVisitationController::class . ':edit')->add(PermissionMiddleware::class)->setName('PASIEN_VISITATION/edit-PASIEN_VISITATION-edit-2'); // edit
            $group->any('/' . Config("SEARCH_ACTION") . '', PasienVisitationController::class . ':search')->add(PermissionMiddleware::class)->setName('PASIEN_VISITATION/search-PASIEN_VISITATION-search-2'); // search
        }
    );

    // TREAT_TARIF
    $app->any('/TreatTarifList[/{ORG_UNIT_CODE}/{TARIF_ID}]', TreatTarifController::class . ':list')->add(PermissionMiddleware::class)->setName('TreatTarifList-TREAT_TARIF-list'); // list
    $app->any('/TreatTarifAdd[/{ORG_UNIT_CODE}/{TARIF_ID}]', TreatTarifController::class . ':add')->add(PermissionMiddleware::class)->setName('TreatTarifAdd-TREAT_TARIF-add'); // add
    $app->group(
        '/TREAT_TARIF',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{ORG_UNIT_CODE}/{TARIF_ID}]', TreatTarifController::class . ':list')->add(PermissionMiddleware::class)->setName('TREAT_TARIF/list-TREAT_TARIF-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{ORG_UNIT_CODE}/{TARIF_ID}]', TreatTarifController::class . ':add')->add(PermissionMiddleware::class)->setName('TREAT_TARIF/add-TREAT_TARIF-add-2'); // add
        }
    );

    // TREATMENT_AKOMODASI
    $app->any('/TreatmentAkomodasiList[/{ID}]', TreatmentAkomodasiController::class . ':list')->add(PermissionMiddleware::class)->setName('TreatmentAkomodasiList-TREATMENT_AKOMODASI-list'); // list
    $app->any('/TreatmentAkomodasiAdd[/{ID}]', TreatmentAkomodasiController::class . ':add')->add(PermissionMiddleware::class)->setName('TreatmentAkomodasiAdd-TREATMENT_AKOMODASI-add'); // add
    $app->any('/TreatmentAkomodasiView[/{ID}]', TreatmentAkomodasiController::class . ':view')->add(PermissionMiddleware::class)->setName('TreatmentAkomodasiView-TREATMENT_AKOMODASI-view'); // view
    $app->any('/TreatmentAkomodasiEdit[/{ID}]', TreatmentAkomodasiController::class . ':edit')->add(PermissionMiddleware::class)->setName('TreatmentAkomodasiEdit-TREATMENT_AKOMODASI-edit'); // edit
    $app->any('/TreatmentAkomodasiDelete[/{ID}]', TreatmentAkomodasiController::class . ':delete')->add(PermissionMiddleware::class)->setName('TreatmentAkomodasiDelete-TREATMENT_AKOMODASI-delete'); // delete
    $app->group(
        '/TREATMENT_AKOMODASI',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{ID}]', TreatmentAkomodasiController::class . ':list')->add(PermissionMiddleware::class)->setName('TREATMENT_AKOMODASI/list-TREATMENT_AKOMODASI-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{ID}]', TreatmentAkomodasiController::class . ':add')->add(PermissionMiddleware::class)->setName('TREATMENT_AKOMODASI/add-TREATMENT_AKOMODASI-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{ID}]', TreatmentAkomodasiController::class . ':view')->add(PermissionMiddleware::class)->setName('TREATMENT_AKOMODASI/view-TREATMENT_AKOMODASI-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{ID}]', TreatmentAkomodasiController::class . ':edit')->add(PermissionMiddleware::class)->setName('TREATMENT_AKOMODASI/edit-TREATMENT_AKOMODASI-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{ID}]', TreatmentAkomodasiController::class . ':delete')->add(PermissionMiddleware::class)->setName('TREATMENT_AKOMODASI/delete-TREATMENT_AKOMODASI-delete-2'); // delete
        }
    );

    // TREATMENT_BAYAR
    $app->any('/TreatmentBayarList[/{ID}]', TreatmentBayarController::class . ':list')->add(PermissionMiddleware::class)->setName('TreatmentBayarList-TREATMENT_BAYAR-list'); // list
    $app->any('/TreatmentBayarAdd[/{ID}]', TreatmentBayarController::class . ':add')->add(PermissionMiddleware::class)->setName('TreatmentBayarAdd-TREATMENT_BAYAR-add'); // add
    $app->any('/TreatmentBayarView[/{ID}]', TreatmentBayarController::class . ':view')->add(PermissionMiddleware::class)->setName('TreatmentBayarView-TREATMENT_BAYAR-view'); // view
    $app->any('/TreatmentBayarEdit[/{ID}]', TreatmentBayarController::class . ':edit')->add(PermissionMiddleware::class)->setName('TreatmentBayarEdit-TREATMENT_BAYAR-edit'); // edit
    $app->any('/TreatmentBayarDelete[/{ID}]', TreatmentBayarController::class . ':delete')->add(PermissionMiddleware::class)->setName('TreatmentBayarDelete-TREATMENT_BAYAR-delete'); // delete
    $app->group(
        '/TREATMENT_BAYAR',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{ID}]', TreatmentBayarController::class . ':list')->add(PermissionMiddleware::class)->setName('TREATMENT_BAYAR/list-TREATMENT_BAYAR-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{ID}]', TreatmentBayarController::class . ':add')->add(PermissionMiddleware::class)->setName('TREATMENT_BAYAR/add-TREATMENT_BAYAR-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{ID}]', TreatmentBayarController::class . ':view')->add(PermissionMiddleware::class)->setName('TREATMENT_BAYAR/view-TREATMENT_BAYAR-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{ID}]', TreatmentBayarController::class . ':edit')->add(PermissionMiddleware::class)->setName('TREATMENT_BAYAR/edit-TREATMENT_BAYAR-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{ID}]', TreatmentBayarController::class . ':delete')->add(PermissionMiddleware::class)->setName('TREATMENT_BAYAR/delete-TREATMENT_BAYAR-delete-2'); // delete
        }
    );

    // TREATMENT_BILL
    $app->any('/TreatmentBillList[/{ID}]', TreatmentBillController::class . ':list')->add(PermissionMiddleware::class)->setName('TreatmentBillList-TREATMENT_BILL-list'); // list
    $app->any('/TreatmentBillAdd[/{ID}]', TreatmentBillController::class . ':add')->add(PermissionMiddleware::class)->setName('TreatmentBillAdd-TREATMENT_BILL-add'); // add
    $app->any('/TreatmentBillView[/{ID}]', TreatmentBillController::class . ':view')->add(PermissionMiddleware::class)->setName('TreatmentBillView-TREATMENT_BILL-view'); // view
    $app->any('/TreatmentBillEdit[/{ID}]', TreatmentBillController::class . ':edit')->add(PermissionMiddleware::class)->setName('TreatmentBillEdit-TREATMENT_BILL-edit'); // edit
    $app->any('/TreatmentBillDelete[/{ID}]', TreatmentBillController::class . ':delete')->add(PermissionMiddleware::class)->setName('TreatmentBillDelete-TREATMENT_BILL-delete'); // delete
    $app->any('/TreatmentBillSearch', TreatmentBillController::class . ':search')->add(PermissionMiddleware::class)->setName('TreatmentBillSearch-TREATMENT_BILL-search'); // search
    $app->group(
        '/TREATMENT_BILL',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{ID}]', TreatmentBillController::class . ':list')->add(PermissionMiddleware::class)->setName('TREATMENT_BILL/list-TREATMENT_BILL-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{ID}]', TreatmentBillController::class . ':add')->add(PermissionMiddleware::class)->setName('TREATMENT_BILL/add-TREATMENT_BILL-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{ID}]', TreatmentBillController::class . ':view')->add(PermissionMiddleware::class)->setName('TREATMENT_BILL/view-TREATMENT_BILL-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{ID}]', TreatmentBillController::class . ':edit')->add(PermissionMiddleware::class)->setName('TREATMENT_BILL/edit-TREATMENT_BILL-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{ID}]', TreatmentBillController::class . ':delete')->add(PermissionMiddleware::class)->setName('TREATMENT_BILL/delete-TREATMENT_BILL-delete-2'); // delete
            $group->any('/' . Config("SEARCH_ACTION") . '', TreatmentBillController::class . ':search')->add(PermissionMiddleware::class)->setName('TREATMENT_BILL/search-TREATMENT_BILL-search-2'); // search
        }
    );

    // TREATMENT_OBAT
    $app->any('/TreatmentObatList[/{ID}]', TreatmentObatController::class . ':list')->add(PermissionMiddleware::class)->setName('TreatmentObatList-TREATMENT_OBAT-list'); // list
    $app->any('/TreatmentObatAdd[/{ID}]', TreatmentObatController::class . ':add')->add(PermissionMiddleware::class)->setName('TreatmentObatAdd-TREATMENT_OBAT-add'); // add
    $app->any('/TreatmentObatView[/{ID}]', TreatmentObatController::class . ':view')->add(PermissionMiddleware::class)->setName('TreatmentObatView-TREATMENT_OBAT-view'); // view
    $app->any('/TreatmentObatEdit[/{ID}]', TreatmentObatController::class . ':edit')->add(PermissionMiddleware::class)->setName('TreatmentObatEdit-TREATMENT_OBAT-edit'); // edit
    $app->any('/TreatmentObatDelete[/{ID}]', TreatmentObatController::class . ':delete')->add(PermissionMiddleware::class)->setName('TreatmentObatDelete-TREATMENT_OBAT-delete'); // delete
    $app->group(
        '/TREATMENT_OBAT',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{ID}]', TreatmentObatController::class . ':list')->add(PermissionMiddleware::class)->setName('TREATMENT_OBAT/list-TREATMENT_OBAT-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{ID}]', TreatmentObatController::class . ':add')->add(PermissionMiddleware::class)->setName('TREATMENT_OBAT/add-TREATMENT_OBAT-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{ID}]', TreatmentObatController::class . ':view')->add(PermissionMiddleware::class)->setName('TREATMENT_OBAT/view-TREATMENT_OBAT-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{ID}]', TreatmentObatController::class . ':edit')->add(PermissionMiddleware::class)->setName('TREATMENT_OBAT/edit-TREATMENT_OBAT-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{ID}]', TreatmentObatController::class . ':delete')->add(PermissionMiddleware::class)->setName('TREATMENT_OBAT/delete-TREATMENT_OBAT-delete-2'); // delete
        }
    );

    // USER_LOGIN
    $app->any('/UserLoginList[/{ORG_UNIT_CODE}/{_USERNAME}]', UserLoginController::class . ':list')->add(PermissionMiddleware::class)->setName('UserLoginList-USER_LOGIN-list'); // list
    $app->any('/UserLoginAdd[/{ORG_UNIT_CODE}/{_USERNAME}]', UserLoginController::class . ':add')->add(PermissionMiddleware::class)->setName('UserLoginAdd-USER_LOGIN-add'); // add
    $app->any('/UserLoginView[/{ORG_UNIT_CODE}/{_USERNAME}]', UserLoginController::class . ':view')->add(PermissionMiddleware::class)->setName('UserLoginView-USER_LOGIN-view'); // view
    $app->any('/UserLoginEdit[/{ORG_UNIT_CODE}/{_USERNAME}]', UserLoginController::class . ':edit')->add(PermissionMiddleware::class)->setName('UserLoginEdit-USER_LOGIN-edit'); // edit
    $app->group(
        '/USER_LOGIN',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{ORG_UNIT_CODE}/{_USERNAME}]', UserLoginController::class . ':list')->add(PermissionMiddleware::class)->setName('USER_LOGIN/list-USER_LOGIN-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{ORG_UNIT_CODE}/{_USERNAME}]', UserLoginController::class . ':add')->add(PermissionMiddleware::class)->setName('USER_LOGIN/add-USER_LOGIN-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{ORG_UNIT_CODE}/{_USERNAME}]', UserLoginController::class . ':view')->add(PermissionMiddleware::class)->setName('USER_LOGIN/view-USER_LOGIN-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{ORG_UNIT_CODE}/{_USERNAME}]', UserLoginController::class . ':edit')->add(PermissionMiddleware::class)->setName('USER_LOGIN/edit-USER_LOGIN-edit-2'); // edit
        }
    );

    // V_PASIENVISITATIONRJ
    $app->any('/VPasienvisitationrjList[/{NO_REGISTRATION}/{ORG_UNIT_CODE}/{visit_id}]', VPasienvisitationrjController::class . ':list')->add(PermissionMiddleware::class)->setName('VPasienvisitationrjList-V_PASIENVISITATIONRJ-list'); // list
    $app->any('/VPasienvisitationrjAdd[/{NO_REGISTRATION}/{ORG_UNIT_CODE}/{visit_id}]', VPasienvisitationrjController::class . ':add')->add(PermissionMiddleware::class)->setName('VPasienvisitationrjAdd-V_PASIENVISITATIONRJ-add'); // add
    $app->any('/VPasienvisitationrjView[/{NO_REGISTRATION}/{ORG_UNIT_CODE}/{visit_id}]', VPasienvisitationrjController::class . ':view')->add(PermissionMiddleware::class)->setName('VPasienvisitationrjView-V_PASIENVISITATIONRJ-view'); // view
    $app->any('/VPasienvisitationrjEdit[/{NO_REGISTRATION}/{ORG_UNIT_CODE}/{visit_id}]', VPasienvisitationrjController::class . ':edit')->add(PermissionMiddleware::class)->setName('VPasienvisitationrjEdit-V_PASIENVISITATIONRJ-edit'); // edit
    $app->group(
        '/V_PASIENVISITATIONRJ',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{NO_REGISTRATION}/{ORG_UNIT_CODE}/{visit_id}]', VPasienvisitationrjController::class . ':list')->add(PermissionMiddleware::class)->setName('V_PASIENVISITATIONRJ/list-V_PASIENVISITATIONRJ-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{NO_REGISTRATION}/{ORG_UNIT_CODE}/{visit_id}]', VPasienvisitationrjController::class . ':add')->add(PermissionMiddleware::class)->setName('V_PASIENVISITATIONRJ/add-V_PASIENVISITATIONRJ-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{NO_REGISTRATION}/{ORG_UNIT_CODE}/{visit_id}]', VPasienvisitationrjController::class . ':view')->add(PermissionMiddleware::class)->setName('V_PASIENVISITATIONRJ/view-V_PASIENVISITATIONRJ-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{NO_REGISTRATION}/{ORG_UNIT_CODE}/{visit_id}]', VPasienvisitationrjController::class . ':edit')->add(PermissionMiddleware::class)->setName('V_PASIENVISITATIONRJ/edit-V_PASIENVISITATIONRJ-edit-2'); // edit
        }
    );

    // V_DAFTAR_PASIEN
    $app->any('/VDaftarPasienList[/{ORG_UNIT_CODE}/{NO_REGISTRATION}]', VDaftarPasienController::class . ':list')->add(PermissionMiddleware::class)->setName('VDaftarPasienList-V_DAFTAR_PASIEN-list'); // list
    $app->any('/VDaftarPasienAdd[/{ORG_UNIT_CODE}/{NO_REGISTRATION}]', VDaftarPasienController::class . ':add')->add(PermissionMiddleware::class)->setName('VDaftarPasienAdd-V_DAFTAR_PASIEN-add'); // add
    $app->any('/VDaftarPasienView[/{ORG_UNIT_CODE}/{NO_REGISTRATION}]', VDaftarPasienController::class . ':view')->add(PermissionMiddleware::class)->setName('VDaftarPasienView-V_DAFTAR_PASIEN-view'); // view
    $app->group(
        '/V_DAFTAR_PASIEN',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{ORG_UNIT_CODE}/{NO_REGISTRATION}]', VDaftarPasienController::class . ':list')->add(PermissionMiddleware::class)->setName('V_DAFTAR_PASIEN/list-V_DAFTAR_PASIEN-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{ORG_UNIT_CODE}/{NO_REGISTRATION}]', VDaftarPasienController::class . ':add')->add(PermissionMiddleware::class)->setName('V_DAFTAR_PASIEN/add-V_DAFTAR_PASIEN-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{ORG_UNIT_CODE}/{NO_REGISTRATION}]', VDaftarPasienController::class . ':view')->add(PermissionMiddleware::class)->setName('V_DAFTAR_PASIEN/view-V_DAFTAR_PASIEN-view-2'); // view
        }
    );

    // V_FARMASI
    $app->any('/VFarmasiList[/{IDXDAFTAR}]', VFarmasiController::class . ':list')->add(PermissionMiddleware::class)->setName('VFarmasiList-V_FARMASI-list'); // list
    $app->any('/VFarmasiAdd[/{IDXDAFTAR}]', VFarmasiController::class . ':add')->add(PermissionMiddleware::class)->setName('VFarmasiAdd-V_FARMASI-add'); // add
    $app->any('/VFarmasiView[/{IDXDAFTAR}]', VFarmasiController::class . ':view')->add(PermissionMiddleware::class)->setName('VFarmasiView-V_FARMASI-view'); // view
    $app->any('/VFarmasiEdit[/{IDXDAFTAR}]', VFarmasiController::class . ':edit')->add(PermissionMiddleware::class)->setName('VFarmasiEdit-V_FARMASI-edit'); // edit
    $app->any('/VFarmasiSearch', VFarmasiController::class . ':search')->add(PermissionMiddleware::class)->setName('VFarmasiSearch-V_FARMASI-search'); // search
    $app->group(
        '/V_FARMASI',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{IDXDAFTAR}]', VFarmasiController::class . ':list')->add(PermissionMiddleware::class)->setName('V_FARMASI/list-V_FARMASI-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{IDXDAFTAR}]', VFarmasiController::class . ':add')->add(PermissionMiddleware::class)->setName('V_FARMASI/add-V_FARMASI-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{IDXDAFTAR}]', VFarmasiController::class . ':view')->add(PermissionMiddleware::class)->setName('V_FARMASI/view-V_FARMASI-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{IDXDAFTAR}]', VFarmasiController::class . ':edit')->add(PermissionMiddleware::class)->setName('V_FARMASI/edit-V_FARMASI-edit-2'); // edit
            $group->any('/' . Config("SEARCH_ACTION") . '', VFarmasiController::class . ':search')->add(PermissionMiddleware::class)->setName('V_FARMASI/search-V_FARMASI-search-2'); // search
        }
    );

    // V_KASIR
    $app->any('/VKasirList[/{IDXDAFTAR}]', VKasirController::class . ':list')->add(PermissionMiddleware::class)->setName('VKasirList-V_KASIR-list'); // list
    $app->any('/VKasirView[/{IDXDAFTAR}]', VKasirController::class . ':view')->add(PermissionMiddleware::class)->setName('VKasirView-V_KASIR-view'); // view
    $app->any('/VKasirEdit[/{IDXDAFTAR}]', VKasirController::class . ':edit')->add(PermissionMiddleware::class)->setName('VKasirEdit-V_KASIR-edit'); // edit
    $app->any('/VKasirSearch', VKasirController::class . ':search')->add(PermissionMiddleware::class)->setName('VKasirSearch-V_KASIR-search'); // search
    $app->group(
        '/V_KASIR',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{IDXDAFTAR}]', VKasirController::class . ':list')->add(PermissionMiddleware::class)->setName('V_KASIR/list-V_KASIR-list-2'); // list
            $group->any('/' . Config("VIEW_ACTION") . '[/{IDXDAFTAR}]', VKasirController::class . ':view')->add(PermissionMiddleware::class)->setName('V_KASIR/view-V_KASIR-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{IDXDAFTAR}]', VKasirController::class . ':edit')->add(PermissionMiddleware::class)->setName('V_KASIR/edit-V_KASIR-edit-2'); // edit
            $group->any('/' . Config("SEARCH_ACTION") . '', VKasirController::class . ':search')->add(PermissionMiddleware::class)->setName('V_KASIR/search-V_KASIR-search-2'); // search
        }
    );

    // V_REKAM_MEDIS
    $app->any('/VRekamMedisList[/{IDXDAFTAR}]', VRekamMedisController::class . ':list')->add(PermissionMiddleware::class)->setName('VRekamMedisList-V_REKAM_MEDIS-list'); // list
    $app->any('/VRekamMedisView[/{IDXDAFTAR}]', VRekamMedisController::class . ':view')->add(PermissionMiddleware::class)->setName('VRekamMedisView-V_REKAM_MEDIS-view'); // view
    $app->any('/VRekamMedisEdit[/{IDXDAFTAR}]', VRekamMedisController::class . ':edit')->add(PermissionMiddleware::class)->setName('VRekamMedisEdit-V_REKAM_MEDIS-edit'); // edit
    $app->any('/VRekamMedisSearch', VRekamMedisController::class . ':search')->add(PermissionMiddleware::class)->setName('VRekamMedisSearch-V_REKAM_MEDIS-search'); // search
    $app->group(
        '/V_REKAM_MEDIS',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{IDXDAFTAR}]', VRekamMedisController::class . ':list')->add(PermissionMiddleware::class)->setName('V_REKAM_MEDIS/list-V_REKAM_MEDIS-list-2'); // list
            $group->any('/' . Config("VIEW_ACTION") . '[/{IDXDAFTAR}]', VRekamMedisController::class . ':view')->add(PermissionMiddleware::class)->setName('V_REKAM_MEDIS/view-V_REKAM_MEDIS-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{IDXDAFTAR}]', VRekamMedisController::class . ':edit')->add(PermissionMiddleware::class)->setName('V_REKAM_MEDIS/edit-V_REKAM_MEDIS-edit-2'); // edit
            $group->any('/' . Config("SEARCH_ACTION") . '', VRekamMedisController::class . ':search')->add(PermissionMiddleware::class)->setName('V_REKAM_MEDIS/search-V_REKAM_MEDIS-search-2'); // search
        }
    );

    // V_SENSUS
    $app->any('/VSensusList[/{NO_REGISTRATION}]', VSensusController::class . ':list')->add(PermissionMiddleware::class)->setName('VSensusList-V_SENSUS-list'); // list
    $app->group(
        '/V_SENSUS',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{NO_REGISTRATION}]', VSensusController::class . ':list')->add(PermissionMiddleware::class)->setName('V_SENSUS/list-V_SENSUS-list-2'); // list
        }
    );

    // V_KUNJUNGAN
    $app->any('/VKunjunganList[/{NO_REGISTRATION}/{VISIT_ID}]', VKunjunganController::class . ':list')->add(PermissionMiddleware::class)->setName('VKunjunganList-V_KUNJUNGAN-list'); // list
    $app->group(
        '/V_KUNJUNGAN',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{NO_REGISTRATION}/{VISIT_ID}]', VKunjunganController::class . ':list')->add(PermissionMiddleware::class)->setName('V_KUNJUNGAN/list-V_KUNJUNGAN-list-2'); // list
        }
    );

    // V_LABORATORIUM
    $app->any('/VLaboratoriumList[/{IDXDAFTAR}]', VLaboratoriumController::class . ':list')->add(PermissionMiddleware::class)->setName('VLaboratoriumList-V_LABORATORIUM-list'); // list
    $app->any('/VLaboratoriumView[/{IDXDAFTAR}]', VLaboratoriumController::class . ':view')->add(PermissionMiddleware::class)->setName('VLaboratoriumView-V_LABORATORIUM-view'); // view
    $app->any('/VLaboratoriumEdit[/{IDXDAFTAR}]', VLaboratoriumController::class . ':edit')->add(PermissionMiddleware::class)->setName('VLaboratoriumEdit-V_LABORATORIUM-edit'); // edit
    $app->group(
        '/V_LABORATORIUM',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{IDXDAFTAR}]', VLaboratoriumController::class . ':list')->add(PermissionMiddleware::class)->setName('V_LABORATORIUM/list-V_LABORATORIUM-list-2'); // list
            $group->any('/' . Config("VIEW_ACTION") . '[/{IDXDAFTAR}]', VLaboratoriumController::class . ':view')->add(PermissionMiddleware::class)->setName('V_LABORATORIUM/view-V_LABORATORIUM-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{IDXDAFTAR}]', VLaboratoriumController::class . ':edit')->add(PermissionMiddleware::class)->setName('V_LABORATORIUM/edit-V_LABORATORIUM-edit-2'); // edit
        }
    );

    // V_RADIOLOGI
    $app->any('/VRadiologiList[/{IDXDAFTAR}]', VRadiologiController::class . ':list')->add(PermissionMiddleware::class)->setName('VRadiologiList-V_RADIOLOGI-list'); // list
    $app->any('/VRadiologiView[/{IDXDAFTAR}]', VRadiologiController::class . ':view')->add(PermissionMiddleware::class)->setName('VRadiologiView-V_RADIOLOGI-view'); // view
    $app->any('/VRadiologiEdit[/{IDXDAFTAR}]', VRadiologiController::class . ':edit')->add(PermissionMiddleware::class)->setName('VRadiologiEdit-V_RADIOLOGI-edit'); // edit
    $app->any('/VRadiologiSearch', VRadiologiController::class . ':search')->add(PermissionMiddleware::class)->setName('VRadiologiSearch-V_RADIOLOGI-search'); // search
    $app->group(
        '/V_RADIOLOGI',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{IDXDAFTAR}]', VRadiologiController::class . ':list')->add(PermissionMiddleware::class)->setName('V_RADIOLOGI/list-V_RADIOLOGI-list-2'); // list
            $group->any('/' . Config("VIEW_ACTION") . '[/{IDXDAFTAR}]', VRadiologiController::class . ':view')->add(PermissionMiddleware::class)->setName('V_RADIOLOGI/view-V_RADIOLOGI-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{IDXDAFTAR}]', VRadiologiController::class . ':edit')->add(PermissionMiddleware::class)->setName('V_RADIOLOGI/edit-V_RADIOLOGI-edit-2'); // edit
            $group->any('/' . Config("SEARCH_ACTION") . '', VRadiologiController::class . ':search')->add(PermissionMiddleware::class)->setName('V_RADIOLOGI/search-V_RADIOLOGI-search-2'); // search
        }
    );

    // ANTRIAN_LOGIN
    $app->any('/AntrianLoginList[/{ID}]', AntrianLoginController::class . ':list')->add(PermissionMiddleware::class)->setName('AntrianLoginList-ANTRIAN_LOGIN-list'); // list
    $app->any('/AntrianLoginAdd[/{ID}]', AntrianLoginController::class . ':add')->add(PermissionMiddleware::class)->setName('AntrianLoginAdd-ANTRIAN_LOGIN-add'); // add
    $app->any('/AntrianLoginView[/{ID}]', AntrianLoginController::class . ':view')->add(PermissionMiddleware::class)->setName('AntrianLoginView-ANTRIAN_LOGIN-view'); // view
    $app->any('/AntrianLoginEdit[/{ID}]', AntrianLoginController::class . ':edit')->add(PermissionMiddleware::class)->setName('AntrianLoginEdit-ANTRIAN_LOGIN-edit'); // edit
    $app->any('/AntrianLoginDelete[/{ID}]', AntrianLoginController::class . ':delete')->add(PermissionMiddleware::class)->setName('AntrianLoginDelete-ANTRIAN_LOGIN-delete'); // delete
    $app->group(
        '/ANTRIAN_LOGIN',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{ID}]', AntrianLoginController::class . ':list')->add(PermissionMiddleware::class)->setName('ANTRIAN_LOGIN/list-ANTRIAN_LOGIN-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{ID}]', AntrianLoginController::class . ':add')->add(PermissionMiddleware::class)->setName('ANTRIAN_LOGIN/add-ANTRIAN_LOGIN-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{ID}]', AntrianLoginController::class . ':view')->add(PermissionMiddleware::class)->setName('ANTRIAN_LOGIN/view-ANTRIAN_LOGIN-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{ID}]', AntrianLoginController::class . ':edit')->add(PermissionMiddleware::class)->setName('ANTRIAN_LOGIN/edit-ANTRIAN_LOGIN-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{ID}]', AntrianLoginController::class . ':delete')->add(PermissionMiddleware::class)->setName('ANTRIAN_LOGIN/delete-ANTRIAN_LOGIN-delete-2'); // delete
        }
    );

    // l_set_cssd
    $app->any('/LSetCssdList[/{id_set}]', LSetCssdController::class . ':list')->add(PermissionMiddleware::class)->setName('LSetCssdList-l_set_cssd-list'); // list
    $app->any('/LSetCssdAdd[/{id_set}]', LSetCssdController::class . ':add')->add(PermissionMiddleware::class)->setName('LSetCssdAdd-l_set_cssd-add'); // add
    $app->any('/LSetCssdView[/{id_set}]', LSetCssdController::class . ':view')->add(PermissionMiddleware::class)->setName('LSetCssdView-l_set_cssd-view'); // view
    $app->any('/LSetCssdEdit[/{id_set}]', LSetCssdController::class . ':edit')->add(PermissionMiddleware::class)->setName('LSetCssdEdit-l_set_cssd-edit'); // edit
    $app->any('/LSetCssdDelete[/{id_set}]', LSetCssdController::class . ':delete')->add(PermissionMiddleware::class)->setName('LSetCssdDelete-l_set_cssd-delete'); // delete
    $app->group(
        '/l_set_cssd',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id_set}]', LSetCssdController::class . ':list')->add(PermissionMiddleware::class)->setName('l_set_cssd/list-l_set_cssd-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id_set}]', LSetCssdController::class . ':add')->add(PermissionMiddleware::class)->setName('l_set_cssd/add-l_set_cssd-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id_set}]', LSetCssdController::class . ':view')->add(PermissionMiddleware::class)->setName('l_set_cssd/view-l_set_cssd-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id_set}]', LSetCssdController::class . ':edit')->add(PermissionMiddleware::class)->setName('l_set_cssd/edit-l_set_cssd-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id_set}]', LSetCssdController::class . ':delete')->add(PermissionMiddleware::class)->setName('l_set_cssd/delete-l_set_cssd-delete-2'); // delete
        }
    );

    // m_alat_cssd
    $app->any('/MAlatCssdList[/{alat_id}]', MAlatCssdController::class . ':list')->add(PermissionMiddleware::class)->setName('MAlatCssdList-m_alat_cssd-list'); // list
    $app->any('/MAlatCssdAdd[/{alat_id}]', MAlatCssdController::class . ':add')->add(PermissionMiddleware::class)->setName('MAlatCssdAdd-m_alat_cssd-add'); // add
    $app->any('/MAlatCssdView[/{alat_id}]', MAlatCssdController::class . ':view')->add(PermissionMiddleware::class)->setName('MAlatCssdView-m_alat_cssd-view'); // view
    $app->any('/MAlatCssdEdit[/{alat_id}]', MAlatCssdController::class . ':edit')->add(PermissionMiddleware::class)->setName('MAlatCssdEdit-m_alat_cssd-edit'); // edit
    $app->any('/MAlatCssdDelete[/{alat_id}]', MAlatCssdController::class . ':delete')->add(PermissionMiddleware::class)->setName('MAlatCssdDelete-m_alat_cssd-delete'); // delete
    $app->group(
        '/m_alat_cssd',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{alat_id}]', MAlatCssdController::class . ':list')->add(PermissionMiddleware::class)->setName('m_alat_cssd/list-m_alat_cssd-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{alat_id}]', MAlatCssdController::class . ':add')->add(PermissionMiddleware::class)->setName('m_alat_cssd/add-m_alat_cssd-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{alat_id}]', MAlatCssdController::class . ':view')->add(PermissionMiddleware::class)->setName('m_alat_cssd/view-m_alat_cssd-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{alat_id}]', MAlatCssdController::class . ':edit')->add(PermissionMiddleware::class)->setName('m_alat_cssd/edit-m_alat_cssd-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{alat_id}]', MAlatCssdController::class . ':delete')->add(PermissionMiddleware::class)->setName('m_alat_cssd/delete-m_alat_cssd-delete-2'); // delete
        }
    );

    // kedatangan_pasien
    $app->any('/KedatanganPasien', KedatanganPasienController::class)->add(PermissionMiddleware::class)->setName('KedatanganPasien-kedatangan_pasien-summary'); // summary

    // register_pasien
    $app->any('/RegisterPasien', RegisterPasienController::class)->add(PermissionMiddleware::class)->setName('RegisterPasien-register_pasien-summary'); // summary

    // V_KUNJUNGAN_PASIEN
    $app->any('/VKunjunganPasienList[/{VISIT_ID}]', VKunjunganPasienController::class . ':list')->add(PermissionMiddleware::class)->setName('VKunjunganPasienList-V_KUNJUNGAN_PASIEN-list'); // list
    $app->any('/VKunjunganPasienView[/{VISIT_ID}]', VKunjunganPasienController::class . ':view')->add(PermissionMiddleware::class)->setName('VKunjunganPasienView-V_KUNJUNGAN_PASIEN-view'); // view
    $app->any('/VKunjunganPasienEdit[/{VISIT_ID}]', VKunjunganPasienController::class . ':edit')->add(PermissionMiddleware::class)->setName('VKunjunganPasienEdit-V_KUNJUNGAN_PASIEN-edit'); // edit
    $app->group(
        '/V_KUNJUNGAN_PASIEN',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{VISIT_ID}]', VKunjunganPasienController::class . ':list')->add(PermissionMiddleware::class)->setName('V_KUNJUNGAN_PASIEN/list-V_KUNJUNGAN_PASIEN-list-2'); // list
            $group->any('/' . Config("VIEW_ACTION") . '[/{VISIT_ID}]', VKunjunganPasienController::class . ':view')->add(PermissionMiddleware::class)->setName('V_KUNJUNGAN_PASIEN/view-V_KUNJUNGAN_PASIEN-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{VISIT_ID}]', VKunjunganPasienController::class . ':edit')->add(PermissionMiddleware::class)->setName('V_KUNJUNGAN_PASIEN/edit-V_KUNJUNGAN_PASIEN-edit-2'); // edit
        }
    );

    // TARIF_TEMP
    $app->any('/TarifTempList', TarifTempController::class . ':list')->add(PermissionMiddleware::class)->setName('TarifTempList-TARIF_TEMP-list'); // list
    $app->group(
        '/TARIF_TEMP',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '', TarifTempController::class . ':list')->add(PermissionMiddleware::class)->setName('TARIF_TEMP/list-TARIF_TEMP-list-2'); // list
        }
    );

    // register_cara_bayar
    $app->any('/RegisterCaraBayar', RegisterCaraBayarController::class)->add(PermissionMiddleware::class)->setName('RegisterCaraBayar-register_cara_bayar-summary'); // summary

    // penyakit_menular
    $app->any('/PenyakitMenular', PenyakitMenularController::class)->add(PermissionMiddleware::class)->setName('PenyakitMenular-penyakit_menular-summary'); // summary

    // V_SENSUS_MATA_SYARAF
    $app->any('/VSensusMataSyarafList', VSensusMataSyarafController::class . ':list')->add(PermissionMiddleware::class)->setName('VSensusMataSyarafList-V_SENSUS_MATA_SYARAF-list'); // list
    $app->group(
        '/V_SENSUS_MATA_SYARAF',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '', VSensusMataSyarafController::class . ':list')->add(PermissionMiddleware::class)->setName('V_SENSUS_MATA_SYARAF/list-V_SENSUS_MATA_SYARAF-list-2'); // list
        }
    );

    // mata_dan_syaraf
    $app->any('/MataDanSyaraf', MataDanSyarafController::class)->add(PermissionMiddleware::class)->setName('MataDanSyaraf-mata_dan_syaraf-summary'); // summary

    // V_RIWAYAT_RM
    $app->any('/VRiwayatRmList[/{IDXDAFTAR}]', VRiwayatRmController::class . ':list')->add(PermissionMiddleware::class)->setName('VRiwayatRmList-V_RIWAYAT_RM-list'); // list
    $app->group(
        '/V_RIWAYAT_RM',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{IDXDAFTAR}]', VRiwayatRmController::class . ':list')->add(PermissionMiddleware::class)->setName('V_RIWAYAT_RM/list-V_RIWAYAT_RM-list-2'); // list
        }
    );

    // v_riwayat_sep
    $app->any('/VRiwayatSepList[/{IDXDAFTAR}]', VRiwayatSepController::class . ':list')->add(PermissionMiddleware::class)->setName('VRiwayatSepList-v_riwayat_sep-list'); // list
    $app->group(
        '/v_riwayat_sep',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{IDXDAFTAR}]', VRiwayatSepController::class . ':list')->add(PermissionMiddleware::class)->setName('v_riwayat_sep/list-v_riwayat_sep-list-2'); // list
        }
    );

    // sensus_hari_ini
    $app->any('/SensusHariIniList', SensusHariIniController::class . ':list')->add(PermissionMiddleware::class)->setName('SensusHariIniList-sensus_hari_ini-list'); // list
    $app->group(
        '/sensus_hari_ini',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '', SensusHariIniController::class . ':list')->add(PermissionMiddleware::class)->setName('sensus_hari_ini/list-sensus_hari_ini-list-2'); // list
        }
    );

    // harian
    $app->any('/Harian', HarianController::class)->add(PermissionMiddleware::class)->setName('Harian-harian-summary'); // summary

    // Dashboard2
    $app->any('/Dashboard2', Dashboard2Controller::class)->add(PermissionMiddleware::class)->setName('Dashboard2-Dashboard2-dashboard'); // dashboard

    // register_perpoli_harian
    $app->any('/RegisterPerpoliHarian', RegisterPerpoliHarianController::class)->add(PermissionMiddleware::class)->setName('RegisterPerpoliHarian-register_perpoli_harian-summary'); // summary

    // register_perpoli_bulanan
    $app->any('/RegisterPerpoliBulanan', RegisterPerpoliBulananController::class)->add(PermissionMiddleware::class)->setName('RegisterPerpoliBulanan-register_perpoli_bulanan-summary'); // summary

    // register_perpoli_tahunan
    $app->any('/RegisterPerpoliTahunan', RegisterPerpoliTahunanController::class)->add(PermissionMiddleware::class)->setName('RegisterPerpoliTahunan-register_perpoli_tahunan-summary'); // summary

    // register_ranap
    $app->any('/RegisterRanap', RegisterRanapController::class)->add(PermissionMiddleware::class)->setName('RegisterRanap-register_ranap-summary'); // summary

    // V_EMPLOYE
    $app->any('/VEmployeList[/{ORG_UNIT_CODE}/{EMPLOYEE_ID}]', VEmployeController::class . ':list')->add(PermissionMiddleware::class)->setName('VEmployeList-V_EMPLOYE-list'); // list
    $app->group(
        '/V_EMPLOYE',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{ORG_UNIT_CODE}/{EMPLOYEE_ID}]', VEmployeController::class . ':list')->add(PermissionMiddleware::class)->setName('V_EMPLOYE/list-V_EMPLOYE-list-2'); // list
        }
    );

    // V_RAWAT_INAP
    $app->any('/VRawatInapList[/{ID}]', VRawatInapController::class . ':list')->add(PermissionMiddleware::class)->setName('VRawatInapList-V_RAWAT_INAP-list'); // list
    $app->any('/VRawatInapView[/{ID}]', VRawatInapController::class . ':view')->add(PermissionMiddleware::class)->setName('VRawatInapView-V_RAWAT_INAP-view'); // view
    $app->any('/VRawatInapEdit[/{ID}]', VRawatInapController::class . ':edit')->add(PermissionMiddleware::class)->setName('VRawatInapEdit-V_RAWAT_INAP-edit'); // edit
    $app->group(
        '/V_RAWAT_INAP',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{ID}]', VRawatInapController::class . ':list')->add(PermissionMiddleware::class)->setName('V_RAWAT_INAP/list-V_RAWAT_INAP-list-2'); // list
            $group->any('/' . Config("VIEW_ACTION") . '[/{ID}]', VRawatInapController::class . ':view')->add(PermissionMiddleware::class)->setName('V_RAWAT_INAP/view-V_RAWAT_INAP-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{ID}]', VRawatInapController::class . ':edit')->add(PermissionMiddleware::class)->setName('V_RAWAT_INAP/edit-V_RAWAT_INAP-edit-2'); // edit
        }
    );

    // error
    $app->any('/error', OthersController::class . ':error')->add(PermissionMiddleware::class)->setName('error');

    // personal_data
    $app->any('/personaldata', OthersController::class . ':personaldata')->add(PermissionMiddleware::class)->setName('personaldata');

    // login
    $app->any('/login', OthersController::class . ':login')->add(PermissionMiddleware::class)->setName('login');

    // logout
    $app->any('/logout', OthersController::class . ':logout')->add(PermissionMiddleware::class)->setName('logout');

    // Swagger
    $app->get('/' . Config("SWAGGER_ACTION"), OthersController::class . ':swagger')->setName(Config("SWAGGER_ACTION")); // Swagger

    // Index
    $app->any('/[index]', OthersController::class . ':index')->add(PermissionMiddleware::class)->setName('index');

    // Route Action event
    if (function_exists(PROJECT_NAMESPACE . "Route_Action")) {
        Route_Action($app);
    }

    /**
     * Catch-all route to serve a 404 Not Found page if none of the routes match
     * NOTE: Make sure this route is defined last.
     */
    $app->map(
        ['GET', 'POST', 'PUT', 'DELETE', 'PATCH'],
        '/{routes:.+}',
        function ($request, $response, $params) {
            $error = [
                "statusCode" => "404",
                "error" => [
                    "class" => "text-warning",
                    "type" => Container("language")->phrase("Error"),
                    "description" => str_replace("%p", $params["routes"], Container("language")->phrase("PageNotFound")),
                ],
            ];
            Container("flash")->addMessage("error", $error);
            return $response->withStatus(302)->withHeader("Location", GetUrl("error")); // Redirect to error page
        }
    );
};
