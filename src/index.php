<?php
include_once("./model/Speaker.php");
include_once("./model/Event.php");
include_once('./model/Events.php');
include_once('./repository/JsonRepository.php');
include_once('./utils/Logger.php');
include_once('./model/Timeslot.php');
include_once('./constants/Constants.php');
include_once('./controller/IndexController.php');

$logger = new Logger();
$repository = new JsonRepository($logger);
$repository->connect(connectionString);

$controller = new IndexController($repository);
$controller->createView();




$events = new Events();

$event = new Event('new1 1event name');
$timeslot = new Timeslot('09:00', '09:10', 'slotname1');
$speaker = new Speaker('', 'firstname', 'surname');
$speaker2 = new Speaker('dr.2', 'firstname2', 'surname2');
$timeslot->addSpeaker($speaker);
$timeslot->addSpeaker($speaker2);
$event->addTimeSlotEntry($timeslot);
$events->addEvent($event);




//$repository->save($events->toJson());
//var_dump($repository->findAllDates());