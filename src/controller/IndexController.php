<?php
include_once('BaseController.php');
/**
 * IndexController handles the displaying part of the index page
 * 
 * @author ReneRuprecht
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
    public function createView(): void
    {
        $this->printAddRedirectLink();

        $this->showPage();
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
        $fileJson = $this->repository->readFromRepository();

        $greetingText = $fileJson['greetingText'];

        echo "<h1>" . $greetingText . "</h1>";

        $eventsJson = $fileJson['events'];
       
        // if there are no events, it can stop here
        if (!count($eventsJson) > 0) return;

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
