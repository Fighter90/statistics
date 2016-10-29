<?php

include_once('lib/config.php');
include_once('lib/models/MSQL.php');
include_once('lib/models/Main.php');
include_once('lib/models/Client.php');
include_once('lib/controllers/Base.php');
include_once('lib/controllers/Index.php');

$mode = ((isset($_GET['mode'])) && ($_GET['mode'] != '')) ? $_GET['mode'] : DEFAULT_CONTROLLER;
$params = explode('.', $mode);
$action = (isset($params[1])) ? $params[1] : '';
$className = (isset($params[0])) ? $params[0] : '';
$mode = new $className($action);
$mode->createPage();