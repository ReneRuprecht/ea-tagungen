<?php
include_once('./partials/header.html');
include_once("./model/Speaker.php");
include_once("./model/Event.php");
include_once('./model/Events.php');
include_once('./repository/JsonRepository.php');
include_once('./model/Timeslot.php');
include_once('./constants/Constants.php');
include_once('./controller/IndexController.php');

// creates the repository
$repository = new JsonRepository();

// creates the controller with repository 
$controller = new IndexController($repository);
// calls the create view
$controller->createView();
