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

    public function getEvents(){
        return $this->events;
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
