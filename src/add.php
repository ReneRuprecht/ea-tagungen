<?php

include_once('./controller/AddController.php');
include_once('./utils/Logger.php');
include_once('./repository/JsonRepository.php');
include_once('./constants/Constants.php');


$logger = new Logger();
$repository = new JsonRepository($logger);
$repository->connect(connectionString);

$controller = new AddController($repository);
$controller->createView();
