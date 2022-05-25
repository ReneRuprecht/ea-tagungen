<?php
include_once('Controller.php');

class IndexController extends Controller
{

    private $repository;

    public function __construct($repository)
    {
        $this->repository = $repository;
    }

    public function createView()
    {
        $this->printAddRedirectLink();
        $this->printHeading();

        $this->printIndex();
    }

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
    public function printAddRedirectLink()
    {
        $link = sprintf(
            "%s://%s:%s%s",
            isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
            $_SERVER['SERVER_NAME'],
            $_SERVER['SERVER_PORT'],
            "/add.php"
        );
        echo "<a href='" . $link . "'>Wechsel zum hinzufügen von Events</a>";
    }

    private function printIndex()
    {

        $eventsJson = $this->repository->readFromRepository();
        $events = Events::EventsFromJson($eventsJson);

        $eventCount = count($events->getEvents());

        if ($eventCount > 0) {

            $text = "Die Tagung findet am ";
            for ($i = 0; $i < $eventCount; $i++) {
                $text .= sprintf("%s", $events->getEvents()[$i]->getEventDate());

                if ($i == $eventCount - 2) {
                    $text .= " und ";
                }
                else{
                    $text .= ", ";
                }
            }

            $text .= " im T-Foyer statt.";

            echo $text;
        }


        echo $events->toString();
    }
}
