<?php

namespace PHPMaker2021\SIMRSSQLSERVERRADIOLOGI;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * kedatangan_pasien controller
 */
class KedatanganPasienController extends ControllerBase
{

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "KedatanganPasienSummary");
    }
}
