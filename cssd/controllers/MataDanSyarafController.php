<?php

namespace PHPMaker2021\SIMRSSQLSERVERCSSD;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * mata_dan_syaraf controller
 */
class MataDanSyarafController extends ControllerBase
{

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "MataDanSyarafSummary");
    }
}
