<?php
include_once('Controller.php');
include_once('./model/Speaker.php');
include_once('./model/Timeslot.php');
include_once('./model/Event.php');
include_once('./model/Events.php');
class AddController extends Controller
{

    private $repository;

    public function __construct($repository)
    {
        session_start();
        $this->repository = $repository;
    }

    public function printIndexRedirectLink()
    {
        $link = sprintf(
            "%s://%s:%s%s",
            isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
            $_SERVER['SERVER_NAME'],
            $_SERVER['SERVER_PORT'],
            "/index.php"
        );
        echo "<a href='" . $link . "'>Zurück zur Übersicht</a>";
    }

    public function createView(): void
    {
        $this->printIndexRedirectLink();


        $this->printHeading();

        $this->printForm();


        if (isset($_POST['formCreateEvent']) && $this->isFormValid()) {
            $this->saveEvent();
            echo "<h1>Event wurde angelegt</h1>";
        }
    }

    private function saveEvent(): void
    {
        $eventDate = filter_var(
            $_POST['eventDate'],
            FILTER_SANITIZE_FULL_SPECIAL_CHARS
        );

        $event = new Event($eventDate);


        $eventName = $_POST['eventName'];
        $startTime = $_POST['startTime'];
        $endTime = $_POST['endTime'];

        $timeslot = new Timeslot($startTime, $endTime, $eventName);


        $speaker = $_POST['speaker'];



        if (strpos($speaker, ',')) {
            $explodedSpeakerArray = explode(',', $speaker);
            foreach ($explodedSpeakerArray as $speakerElement) {
                $timeslot->addSpeaker($this->createSpeakerFromString($speakerElement));
            }
        } else {
            $timeslot->addSpeaker($this->createSpeakerFromString($speaker));
        }

        $event->addTimeSlotEntry($timeslot);
        $events = new Events();
        $events->addEvent($event);

        $this->repository->saveSingleEvent($event->toArray());
    }


    private function createSpeakerFromString($speakerElement): Speaker
    {

        if (preg_match(speakerRegex, $speakerElement, $matches)) {
            $speakerTitle = "";

            $matches[1] != "" ? $speakerTitle .= $matches[1] : "";

            ($speakerTitle && $matches[1]) != "" ? $speakerTitle .= " " . $matches[2] : $speakerTitle .= $matches[2];


            $speakerSurname = $matches[3];
            return new Speaker($speakerTitle, $speakerSurname);
        }
    }

    private function printHeading(): void
    {
        echo "
        <h1>
        Event anlegen
        </h1>
        ";
    }

    private function isFormValid(): bool
    {
        if (!isset($_POST['eventDate']) || !preg_match(eventDateRegex, $_POST['eventDate'])) {
            echo "<h1>Das Datum ist ungültig</h1>";
            return false;
        }

        if (!isset($_POST['eventName']) || !preg_match('/^(?!\s*$).+/', $_POST['eventName'])) {
            echo "<h1>Der Eventname ist ungültig</h1>";
            return false;
        }

        if (!isset($_POST['startTime']) || !preg_match(timeRegex, $_POST['startTime'])) {
            echo "<h1>Die Startzeit ist ungültig</h1>";
            return false;
        }
        if (!isset($_POST['endTime']) || !preg_match(timeRegex, $_POST['endTime'])) {
            echo "<h1>Die Endzeit ist ungültig</h1>";
            return false;
        }

        if (!isset($_POST['speaker'])) {
            echo "<h1>Die Redner ist ungültig</h1>";
            return false;
        } else {
            if (strpos($_POST['speaker'], ',')) {
                $explodedSpeakerArray = explode(',', $_POST['speaker']);
                foreach ($explodedSpeakerArray as $speakerElement) {

                    if (!preg_match(speakerRegex, $speakerElement)) {
                        echo "<h1>Die Redner ist ungültig</h1>";
                        return false;
                    }
                }
            } else {
                if (!preg_match(speakerRegex, $_POST['speaker'])) {
                    echo "<h1>Die Redner ist ungültig</h1>";
                    return false;
                }
            }
        }

        return true;
    }

    private function printForm(): void
    {

        //sets current date
        $currentDate = date("Y-m-d");
        /* 
         * sets the current date +1, so the user can't set the date before the
         * current date 
         */
        $minDate =  date("Y-m-d", strtotime($currentDate . ' +1 day'));
        // sets the date
        $eventDate = isset($_POST['eventDate']) ? $_POST['eventDate'] : $minDate;

        $eventName = isset($_POST['eventName']) ? $_POST['eventName'] : "";

        $startTime = isset($_POST['startTime']) ? $_POST['startTime'] : "00:00";

        $endTime = isset($_POST['endTime']) ? $_POST['endTime'] : "00:00";

        $speaker = isset($_POST['speaker']) ? $_POST['speaker'] : "";

        echo "<form method=\"POST\" form action=\"add.php\">
                
                <label for=\"eventDate\">Datum:</label>
                <input type=\"date\" name=\"eventDate\" value=\"$eventDate\" min=\"$minDate\"/>
                <br>
                <label for=\"eventName\">Event Name:</label>
                <input type=\"text\" name=\"eventName\" value=\"$eventName\"/>
                <br>
                <label for=\"startTime\">Start Zeit:</label>
                <input type=\"time\" name=\"startTime\" value=\"$startTime\"/>
                <br>
                <label for=\"endTime\">End Zeit:</label>
                <input type=\"time\" name=\"endTime\" value=\"$endTime\"/>
                <br>
                <label for=\"speaker\">Sprecher:</label>
                <input type=\"text\" name=\"speaker\" value=\"$speaker\"/>
                <br>
                <input type=\"submit\" name=\"formCreateEvent\" value=\"abschicken\"/>
                
            </form>";
    }
}
