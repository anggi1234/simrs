<?php

namespace PHPMaker2021\SIMRSSQLSERVERREKAMMEDIK;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class ClassRoomController extends ControllerBase
{
    // list
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ClassRoomList");
    }
}
