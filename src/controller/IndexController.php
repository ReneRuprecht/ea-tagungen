<?php
include_once('BaseController.php');
/**
 * Class IndexController handles the displaying part of the index page
 */
class IndexController extends BaseController
{

    /**
     * repository is used to save and read event data from json and gets
     * injected from the constructor
     *
     * @var [RepositoryInterface]
     */
    private $repository;

    /**
     * Contstructor 
     *
     * @param [RepositoryInterface] $repository
     */
    public function __construct($repository)
    {
        $this->repository = $repository;

        // connects the application to the repository
        $this->repository->connect(connectionString);
    }

    /**
     * createView is the start function to displaying the page
     *
     * @return void
     */
    public function createView()
    {
        $this->printAddRedirectLink();

        $this->printHeading();

        $this->showPage();
    }

    /**
     * printHeading shows the heading of the page
     *
     * @return void
     */
    private function printHeading()
    {
        echo "
        <h1>
        Willkommen zum Tagungsprogramm
        <br>
        Agile Software Days in Emden
        </h1>
        ";
    }

    /**
     * printAddRedirectLink prints the link to the add page
     *
     * @return void
     */
    public function printAddRedirectLink()
    {
        echo '<a href="add.php">Add Page</a>';
    }

    /**
     * showPage builds and shows the page to the user
     *
     * @return void
     */
    private function showPage()
    {

        // loads the json from the repository
        $eventsJson = $this->repository->readFromRepository();
        // builds the events from the json content
        $events = Events::EventsFromJson($eventsJson);
        // counts the events that got created
        $eventCount = count($events->getEvents());

        // if there are no events the function can stop here
        if ($eventCount == 0) return;


        // builds the text that displays when the events are
        $text = "Die Tagung findet am ";

        for ($i = 0; $i < $eventCount; $i++) {
            $text .= sprintf("%s", $events->getEvents()[$i]->getEventDate());

            if ($i == $eventCount - 2) {
                $text .= " und ";
            } else {
                $text .= ", ";
            }
        }

        $text .= " im T-Foyer statt.";
        echo $text;

        //displays the events
        echo $events->toString();
    }
}
