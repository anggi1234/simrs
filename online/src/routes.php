<?php

namespace PHPMaker2021\Online;

use Slim\App;
use Slim\Routing\RouteCollectorProxy;

// Handle Routes
return function (App $app) {
    // AGAMA
    $app->any('/AgamaList[/{KODE_AGAMA}]', AgamaController::class . ':list')->add(PermissionMiddleware::class)->setName('AgamaList-AGAMA-list'); // list
    $app->any('/AgamaAdd[/{KODE_AGAMA}]', AgamaController::class . ':add')->add(PermissionMiddleware::class)->setName('AgamaAdd-AGAMA-add'); // add
    $app->any('/AgamaView[/{KODE_AGAMA}]', AgamaController::class . ':view')->add(PermissionMiddleware::class)->setName('AgamaView-AGAMA-view'); // view
    $app->any('/AgamaEdit[/{KODE_AGAMA}]', AgamaController::class . ':edit')->add(PermissionMiddleware::class)->setName('AgamaEdit-AGAMA-edit'); // edit
    $app->any('/AgamaDelete[/{KODE_AGAMA}]', AgamaController::class . ':delete')->add(PermissionMiddleware::class)->setName('AgamaDelete-AGAMA-delete'); // delete
    $app->group(
        '/AGAMA',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{KODE_AGAMA}]', AgamaController::class . ':list')->add(PermissionMiddleware::class)->setName('AGAMA/list-AGAMA-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{KODE_AGAMA}]', AgamaController::class . ':add')->add(PermissionMiddleware::class)->setName('AGAMA/add-AGAMA-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{KODE_AGAMA}]', AgamaController::class . ':view')->add(PermissionMiddleware::class)->setName('AGAMA/view-AGAMA-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{KODE_AGAMA}]', AgamaController::class . ':edit')->add(PermissionMiddleware::class)->setName('AGAMA/edit-AGAMA-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{KODE_AGAMA}]', AgamaController::class . ':delete')->add(PermissionMiddleware::class)->setName('AGAMA/delete-AGAMA-delete-2'); // delete
        }
    );

    // ANTRIAN_PENDAFTARAN
    $app->any('/AntrianPendaftaranList[/{Id}]', AntrianPendaftaranController::class . ':list')->add(PermissionMiddleware::class)->setName('AntrianPendaftaranList-ANTRIAN_PENDAFTARAN-list'); // list
    $app->any('/AntrianPendaftaranAdd[/{Id}]', AntrianPendaftaranController::class . ':add')->add(PermissionMiddleware::class)->setName('AntrianPendaftaranAdd-ANTRIAN_PENDAFTARAN-add'); // add
    $app->any('/AntrianPendaftaranView[/{Id}]', AntrianPendaftaranController::class . ':view')->add(PermissionMiddleware::class)->setName('AntrianPendaftaranView-ANTRIAN_PENDAFTARAN-view'); // view
    $app->any('/AntrianPendaftaranDelete[/{Id}]', AntrianPendaftaranController::class . ':delete')->add(PermissionMiddleware::class)->setName('AntrianPendaftaranDelete-ANTRIAN_PENDAFTARAN-delete'); // delete
    $app->group(
        '/ANTRIAN_PENDAFTARAN',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{Id}]', AntrianPendaftaranController::class . ':list')->add(PermissionMiddleware::class)->setName('ANTRIAN_PENDAFTARAN/list-ANTRIAN_PENDAFTARAN-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{Id}]', AntrianPendaftaranController::class . ':add')->add(PermissionMiddleware::class)->setName('ANTRIAN_PENDAFTARAN/add-ANTRIAN_PENDAFTARAN-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{Id}]', AntrianPendaftaranController::class . ':view')->add(PermissionMiddleware::class)->setName('ANTRIAN_PENDAFTARAN/view-ANTRIAN_PENDAFTARAN-view-2'); // view
            $group->any('/' . Config("DELETE_ACTION") . '[/{Id}]', AntrianPendaftaranController::class . ':delete')->add(PermissionMiddleware::class)->setName('ANTRIAN_PENDAFTARAN/delete-ANTRIAN_PENDAFTARAN-delete-2'); // delete
        }
    );

    // CLINIC
    $app->any('/ClinicList[/{ORG_UNIT_CODE}/{CLINIC_ID}]', ClinicController::class . ':list')->add(PermissionMiddleware::class)->setName('ClinicList-CLINIC-list'); // list
    $app->any('/ClinicAdd[/{ORG_UNIT_CODE}/{CLINIC_ID}]', ClinicController::class . ':add')->add(PermissionMiddleware::class)->setName('ClinicAdd-CLINIC-add'); // add
    $app->any('/ClinicView[/{ORG_UNIT_CODE}/{CLINIC_ID}]', ClinicController::class . ':view')->add(PermissionMiddleware::class)->setName('ClinicView-CLINIC-view'); // view
    $app->any('/ClinicEdit[/{ORG_UNIT_CODE}/{CLINIC_ID}]', ClinicController::class . ':edit')->add(PermissionMiddleware::class)->setName('ClinicEdit-CLINIC-edit'); // edit
    $app->any('/ClinicDelete[/{ORG_UNIT_CODE}/{CLINIC_ID}]', ClinicController::class . ':delete')->add(PermissionMiddleware::class)->setName('ClinicDelete-CLINIC-delete'); // delete
    $app->group(
        '/CLINIC',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{ORG_UNIT_CODE}/{CLINIC_ID}]', ClinicController::class . ':list')->add(PermissionMiddleware::class)->setName('CLINIC/list-CLINIC-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{ORG_UNIT_CODE}/{CLINIC_ID}]', ClinicController::class . ':add')->add(PermissionMiddleware::class)->setName('CLINIC/add-CLINIC-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{ORG_UNIT_CODE}/{CLINIC_ID}]', ClinicController::class . ':view')->add(PermissionMiddleware::class)->setName('CLINIC/view-CLINIC-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{ORG_UNIT_CODE}/{CLINIC_ID}]', ClinicController::class . ':edit')->add(PermissionMiddleware::class)->setName('CLINIC/edit-CLINIC-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{ORG_UNIT_CODE}/{CLINIC_ID}]', ClinicController::class . ':delete')->add(PermissionMiddleware::class)->setName('CLINIC/delete-CLINIC-delete-2'); // delete
        }
    );

    // JOB_CATEGORY
    $app->any('/JobCategoryList[/{JOB_ID}]', JobCategoryController::class . ':list')->add(PermissionMiddleware::class)->setName('JobCategoryList-JOB_CATEGORY-list'); // list
    $app->any('/JobCategoryAdd[/{JOB_ID}]', JobCategoryController::class . ':add')->add(PermissionMiddleware::class)->setName('JobCategoryAdd-JOB_CATEGORY-add'); // add
    $app->any('/JobCategoryView[/{JOB_ID}]', JobCategoryController::class . ':view')->add(PermissionMiddleware::class)->setName('JobCategoryView-JOB_CATEGORY-view'); // view
    $app->any('/JobCategoryEdit[/{JOB_ID}]', JobCategoryController::class . ':edit')->add(PermissionMiddleware::class)->setName('JobCategoryEdit-JOB_CATEGORY-edit'); // edit
    $app->any('/JobCategoryDelete[/{JOB_ID}]', JobCategoryController::class . ':delete')->add(PermissionMiddleware::class)->setName('JobCategoryDelete-JOB_CATEGORY-delete'); // delete
    $app->group(
        '/JOB_CATEGORY',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{JOB_ID}]', JobCategoryController::class . ':list')->add(PermissionMiddleware::class)->setName('JOB_CATEGORY/list-JOB_CATEGORY-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{JOB_ID}]', JobCategoryController::class . ':add')->add(PermissionMiddleware::class)->setName('JOB_CATEGORY/add-JOB_CATEGORY-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{JOB_ID}]', JobCategoryController::class . ':view')->add(PermissionMiddleware::class)->setName('JOB_CATEGORY/view-JOB_CATEGORY-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{JOB_ID}]', JobCategoryController::class . ':edit')->add(PermissionMiddleware::class)->setName('JOB_CATEGORY/edit-JOB_CATEGORY-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{JOB_ID}]', JobCategoryController::class . ':delete')->add(PermissionMiddleware::class)->setName('JOB_CATEGORY/delete-JOB_CATEGORY-delete-2'); // delete
        }
    );

    // SEX
    $app->any('/SexList[/{GENDER}]', SexController::class . ':list')->add(PermissionMiddleware::class)->setName('SexList-SEX-list'); // list
    $app->any('/SexAdd[/{GENDER}]', SexController::class . ':add')->add(PermissionMiddleware::class)->setName('SexAdd-SEX-add'); // add
    $app->any('/SexView[/{GENDER}]', SexController::class . ':view')->add(PermissionMiddleware::class)->setName('SexView-SEX-view'); // view
    $app->any('/SexEdit[/{GENDER}]', SexController::class . ':edit')->add(PermissionMiddleware::class)->setName('SexEdit-SEX-edit'); // edit
    $app->any('/SexDelete[/{GENDER}]', SexController::class . ':delete')->add(PermissionMiddleware::class)->setName('SexDelete-SEX-delete'); // delete
    $app->group(
        '/SEX',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{GENDER}]', SexController::class . ':list')->add(PermissionMiddleware::class)->setName('SEX/list-SEX-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{GENDER}]', SexController::class . ':add')->add(PermissionMiddleware::class)->setName('SEX/add-SEX-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{GENDER}]', SexController::class . ':view')->add(PermissionMiddleware::class)->setName('SEX/view-SEX-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{GENDER}]', SexController::class . ':edit')->add(PermissionMiddleware::class)->setName('SEX/edit-SEX-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{GENDER}]', SexController::class . ':delete')->add(PermissionMiddleware::class)->setName('SEX/delete-SEX-delete-2'); // delete
        }
    );

    // ANTRIAN_LOGIN
    $app->any('/AntrianLoginList[/{ID}]', AntrianLoginController::class . ':list')->add(PermissionMiddleware::class)->setName('AntrianLoginList-ANTRIAN_LOGIN-list'); // list
    $app->any('/AntrianLoginView[/{ID}]', AntrianLoginController::class . ':view')->add(PermissionMiddleware::class)->setName('AntrianLoginView-ANTRIAN_LOGIN-view'); // view
    $app->any('/AntrianLoginEdit[/{ID}]', AntrianLoginController::class . ':edit')->add(PermissionMiddleware::class)->setName('AntrianLoginEdit-ANTRIAN_LOGIN-edit'); // edit
    $app->group(
        '/ANTRIAN_LOGIN',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{ID}]', AntrianLoginController::class . ':list')->add(PermissionMiddleware::class)->setName('ANTRIAN_LOGIN/list-ANTRIAN_LOGIN-list-2'); // list
            $group->any('/' . Config("VIEW_ACTION") . '[/{ID}]', AntrianLoginController::class . ':view')->add(PermissionMiddleware::class)->setName('ANTRIAN_LOGIN/view-ANTRIAN_LOGIN-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{ID}]', AntrianLoginController::class . ':edit')->add(PermissionMiddleware::class)->setName('ANTRIAN_LOGIN/edit-ANTRIAN_LOGIN-edit-2'); // edit
        }
    );

    // V_daftarantri
    $app->any('/VDaftarantriList[/{Id}]', VDaftarantriController::class . ':list')->add(PermissionMiddleware::class)->setName('VDaftarantriList-V_daftarantri-list'); // list
    $app->any('/VDaftarantriAdd[/{Id}]', VDaftarantriController::class . ':add')->add(PermissionMiddleware::class)->setName('VDaftarantriAdd-V_daftarantri-add'); // add
    $app->any('/VDaftarantriView[/{Id}]', VDaftarantriController::class . ':view')->add(PermissionMiddleware::class)->setName('VDaftarantriView-V_daftarantri-view'); // view
    $app->any('/VDaftarantriDelete[/{Id}]', VDaftarantriController::class . ':delete')->add(PermissionMiddleware::class)->setName('VDaftarantriDelete-V_daftarantri-delete'); // delete
    $app->group(
        '/V_daftarantri',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{Id}]', VDaftarantriController::class . ':list')->add(PermissionMiddleware::class)->setName('V_daftarantri/list-V_daftarantri-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{Id}]', VDaftarantriController::class . ':add')->add(PermissionMiddleware::class)->setName('V_daftarantri/add-V_daftarantri-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{Id}]', VDaftarantriController::class . ':view')->add(PermissionMiddleware::class)->setName('V_daftarantri/view-V_daftarantri-view-2'); // view
            $group->any('/' . Config("DELETE_ACTION") . '[/{Id}]', VDaftarantriController::class . ':delete')->add(PermissionMiddleware::class)->setName('V_daftarantri/delete-V_daftarantri-delete-2'); // delete
        }
    );

    // V_daftardis
    $app->any('/VDaftardisList[/{Id}]', VDaftardisController::class . ':list')->add(PermissionMiddleware::class)->setName('VDaftardisList-V_daftardis-list'); // list
    $app->any('/VDaftardisAdd[/{Id}]', VDaftardisController::class . ':add')->add(PermissionMiddleware::class)->setName('VDaftardisAdd-V_daftardis-add'); // add
    $app->any('/VDaftardisView[/{Id}]', VDaftardisController::class . ':view')->add(PermissionMiddleware::class)->setName('VDaftardisView-V_daftardis-view'); // view
    $app->any('/VDaftardisDelete[/{Id}]', VDaftardisController::class . ':delete')->add(PermissionMiddleware::class)->setName('VDaftardisDelete-V_daftardis-delete'); // delete
    $app->group(
        '/V_daftardis',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{Id}]', VDaftardisController::class . ':list')->add(PermissionMiddleware::class)->setName('V_daftardis/list-V_daftardis-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{Id}]', VDaftardisController::class . ':add')->add(PermissionMiddleware::class)->setName('V_daftardis/add-V_daftardis-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{Id}]', VDaftardisController::class . ':view')->add(PermissionMiddleware::class)->setName('V_daftardis/view-V_daftardis-view-2'); // view
            $group->any('/' . Config("DELETE_ACTION") . '[/{Id}]', VDaftardisController::class . ':delete')->add(PermissionMiddleware::class)->setName('V_daftardis/delete-V_daftardis-delete-2'); // delete
        }
    );

    // error
    $app->any('/error', OthersController::class . ':error')->add(PermissionMiddleware::class)->setName('error');

    // personal_data
    $app->any('/personaldata', OthersController::class . ':personaldata')->add(PermissionMiddleware::class)->setName('personaldata');

    // login
    $app->any('/login', OthersController::class . ':login')->add(PermissionMiddleware::class)->setName('login');

    // change_password
    $app->any('/changepassword', OthersController::class . ':changepassword')->add(PermissionMiddleware::class)->setName('changepassword');

    // register
    $app->any('/register', OthersController::class . ':register')->add(PermissionMiddleware::class)->setName('register');

    // logout
    $app->any('/logout', OthersController::class . ':logout')->add(PermissionMiddleware::class)->setName('logout');

    // captcha
    $app->any('/captcha[/{page}]', OthersController::class . ':captcha')->add(PermissionMiddleware::class)->setName('captcha');

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
