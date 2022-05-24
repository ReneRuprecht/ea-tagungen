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

    private function printIndex()
    {
        $eventsFromRepository = $this->repository->read();

        $events = new Events();
        $events->buildEventFromArray($eventsFromRepository);

        $eventCount = count($events->getEvents());
        if ($eventCount > 0) {

            $text = "Die Tagung findet am ";
            for ($i = 0; $i < $eventCount; $i++) {
                $text .= sprintf("%s", $events->getEvents()[$i]->getEventDate());

                if ($i != $eventCount - 1) {
                    $text .= " und ";
                }
            }
            $text .= " im T-Foyer statt.";

            echo $text;
        }


        echo $events->toString();
    }
}
