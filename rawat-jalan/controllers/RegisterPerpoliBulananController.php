<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAJALALTER;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * register_perpoli_bulanan controller
 */
class RegisterPerpoliBulananController extends ControllerBase
{

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "RegisterPerpoliBulananSummary");
    }
}
