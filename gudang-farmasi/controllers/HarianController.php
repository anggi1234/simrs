<?php

namespace PHPMaker2021\SIMRSSQLSERVERGUDANGFARMASI;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * harian controller
 */
class HarianController extends ControllerBase
{

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "HarianSummary");
    }
}
