<?php

ini_set("memory_limit", "2G");

$autoloadFile = dirname(__FILE__) . '/vendor/autoload.php';

/** @noinspection PhpIncludeInspection */
require_once($autoloadFile);

/** @noinspection PhpUnhandledExceptionInspection */
(new Kernel)->run();
