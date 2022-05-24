<?php

class Events
{
    private $events = array();

    public function build($events)
    {
        array_push($this->events = $events);
    }

    public function addEvent($event)
    {
        array_push($this->events, $event);
    }

    public function getEvents()
    {
        return $this->events;
    }

    public function buildEventFromArray($eventArray)
    {
        foreach ($eventArray as $event) {

            $createdEvent = new Event($event['eventDate']);
            $createdEvent->buildTimeslotFromArray($event['timeslots']);
            array_push($this->events, $createdEvent);
        }
    }

    public function toString()
    {
        $text = "";
        foreach ($this->events as $event) {
            $text .= $event->toString();
        }
        $text .= "<br>";

        return $text;
    }

    public function toJson()
    {

        $eventsArray = array();
        foreach ($this->events as $event) {

            array_push($eventsArray, $event->toArray());
        }


        return $eventsArray[0];
    }
}
