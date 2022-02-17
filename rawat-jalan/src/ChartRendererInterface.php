<?php

namespace PHPMaker2021\SIMRSSQLSERVERRAJALALTER;

/**
 * Chart renderer interface
 */
interface ChartRendererInterface
{

    public function getContainer($width, $height);

    public function getScript($width, $height);
}
