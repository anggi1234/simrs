<?php

namespace PHPMaker2021\SIMRSSQLSERVERGUDANGFARMASI;

/**
 * Chart renderer interface
 */
interface ChartRendererInterface
{

    public function getContainer($width, $height);

    public function getScript($width, $height);
}
