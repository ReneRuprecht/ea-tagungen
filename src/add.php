<?php
include_once('./controller/AddController.php');
include_once('./repository/JsonRepository.php');
include_once('./constants/Constants.php');
include_once('./utils/FormValidator.php');

// creates the repository
$repository = new JsonRepository();

// creates the form validator
$formValidator = new FormValidator();

// creates the controller with repository and form validator
$controller = new AddController($repository, $formValidator);
// calls the create view
$controller->createView();
