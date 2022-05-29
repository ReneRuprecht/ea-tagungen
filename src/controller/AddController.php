<?php
include_once('BaseController.php');
include_once('./model/Speaker.php');
include_once('./model/Timeslot.php');
include_once('./model/Event.php');

/**
 * Class AddController handles the controlling part of the add page
 */
class AddController extends BaseController
{

    /**
     * repository is used to save and read event data from json and gets
     * injected from the constructor
     *
     * @var [RepositoryInterface]
     */
    private $repository;

    /**
     * formValidator is used to validate the form and gets injected from the
     * constructor
     *
     * @var [ValidatorInterface]
     */
    private $formValidator;

    /**
     * Contstructor starts a session for the input form
     *
     * @param [RepositoryInterface] $repository
     * @param [ValidatorInterface] $formValidator
     */
    public function __construct($repository, $formValidator)
    {
        session_start();

        $this->repository = $repository;
        // connects the application to the repository
        $this->repository->connect(connectionString);

        $this->formValidator = $formValidator;
    }

    /**
     * printIndexRedirectLink prints the link to the index page
     *
     * @return void
     */
    public function printIndexRedirectLink(): void
    {
        echo '<a href="'.indexPage.'">Index Page</a>';
    }

    /**
     * createView is the start function to display the page ,check if the form
     * is valid and save the form 
     *
     * @return void
     */
    public function createView(): void
    {
        $this->printIndexRedirectLink();

        $this->printHeading();

        $this->printForm();

        // if there is no form submitted, the function can stop here
        if (!isset($_POST['formCreateEvent']))  return;

        // validate form an get the return value
        $errorMessage = $this->formValidator->validate();

        // display the error message if there is one
        if ($errorMessage != "") {
            echo $errorMessage;
            return;
        }

        // the form was valid, prepare the event data for saving
        $preparedEvent = $this->prepareEventForSaving();

        // saves the event
        $this->repository->saveSingleEvent($preparedEvent);

        echo "<h1>Event wurde angelegt</h1>";
    }

    /**
     * prepareEventForSaving is used to prepare the event for saving and saves
     * it
     *
     * @return array prepared event array to save in the repository
     */
    private function prepareEventForSaving(): array
    {
        $eventDate = $_POST['eventDate'];

        $event = new Event($eventDate);

        $eventName = $_POST['eventName'];
        $startTime = $_POST['startTime'];
        $endTime = $_POST['endTime'];

        $timeslot = new Timeslot($startTime, $endTime, $eventName);

        $speaker = $_POST['speaker'];

        // check if there are multiple speaker in the textfield
        if (strpos($speaker, ',')) {
            $explodedSpeakerArray = explode(',', $speaker);
            foreach ($explodedSpeakerArray as $speakerString) {

                $timeslot->addSpeaker($this->createSpeakerFromString($speakerString));
            }
        } else {
            $timeslot->addSpeaker($this->createSpeakerFromString($speaker));
        }

        $event->addTimeSlotEntry($timeslot);

        return $event->toArray();
    }

    /**
     * createSpeakerFromString builds the speaker object
     *
     * @param [string] $speakerString
     * @return Speaker
     */
    private function createSpeakerFromString($speakerString): Speaker
    {

        // is always true. the regex gets checked in the validation
        if (preg_match(speakerRegex, $speakerString, $matches)) {
            $speakerTitle = "";

            // adds the prof. part to the speakerTitle
            $matches[1] != "" ? $speakerTitle .= $matches[1] : "";

            // adds the dr. part to the speakerTitle
            ($speakerTitle && $matches[1]) != "" ? $speakerTitle .= " " . $matches[2] : $speakerTitle .= $matches[2];

            // setts the speaker surname
            $speakerSurname = $matches[3];

            return new Speaker($speakerTitle, $speakerSurname);
        }
    }

    /**
     * printHeading shows the heading of the page
     *
     * @return void
     */
    private function printHeading(): void
    {
        echo "
        <h1>
        Event anlegen
        </h1>
        ";
    }


    /**
     * printForm shows the form that is used to get the input from the user
     *
     * @return void
     */
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
                <label for=\"speaker\">Sprecher (mehrere Sprecher sind mit einem Komma ',' zu separieren):</label>
                <input type=\"text\" name=\"speaker\" value=\"$speaker\"/>
                <br>
                <input type=\"submit\" name=\"formCreateEvent\" value=\"abschicken\"/>
                
            </form>";
    }
}
