<?php
include_once('Controller.php');

class AddController extends Controller
{

    private $repository;

    public function __construct($repository)
    {
        session_start();
        $this->repository = $repository;
    }

    public function createView(): void
    {
        $this->printHeading();

        if (!$this->isFormValid()) {
            $this->pringForm();
            return;
        }

        $this->saveEvent();
    }

    private function saveEvent(): void
    {
        echo "saved";
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
        if (
            isset($_POST['eventDate']) && preg_match('/^(?!\s*$).+/', $_POST['eventDate'])  &&
            isset($_POST['eventName']) && preg_match('/^(?!\s*$).+/', $_POST['eventName']) &&
            isset($_POST['startTime']) && preg_match('/^\d{2}[:]\d{2}$/', $_POST['startTime']) &&
            isset($_POST['endTime']) && preg_match('/^\d{2}[:]\d{2}$/', $_POST['endTime']) &&
            isset($_POST['speaker']) && preg_match('/^(?!\s*$).+/', $_POST['speaker'])
        ) {
            return true;
        }

        return false;
    }

    private function pringForm(): void
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
