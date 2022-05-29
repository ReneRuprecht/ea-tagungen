<?php
// connectionString is used for the repository.
define("connectionString", "./events.txt");

// pages
define('indexPage', 'index.php');
define('addPage', 'add.php');

// regex part
define('eventDateRegex', '/^[0-9]{4,4}[-][0-9]{1,2}[-][0-9]{1,2}$/');
define('timeRegex', '/^\d{2}[:]\d{2}$/');
define('speakerRegex', '/^\s*((?:[p|P]rof\.))?\s*((?:[d|D]r\.))?\s*([a-zA-ZÄäÖöÜüẞß\-]+)$/');


$defaultEvents = array();

array_push($defaultEvents,array(
    "eventDate"=> "2022-06-29",
    "timeslots"=> array(),
));
array_push($defaultEvents,array(
    "eventDate"=> "2022-06-30",
    "timeslots"=> array(),
));


define("defaultJson", json_encode(
    array(
        "greetingText" => "Willkommen zum Tagungsprogramm<br>Agile Software Days in Emden", 
        "events" => $defaultEvents),
         JSON_PRETTY_PRINT));

