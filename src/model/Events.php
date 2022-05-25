<?php

class Events
{
    private $events = array();

    public function addEvent($event): void
    {
        array_push($this->events, $event);
    }

    public function getEvents(): array
    {
        return $this->events;
    }

    public static function EventsFromJson($eventJson): Events
    {
        $events = new Events();
        foreach ($eventJson as $event) {

            $createdEvent = Event::EventFromJson($event);
            $events->addEvent($createdEvent);
        }
        return $events;
    }

    public function toString(): string
    {
        $text = "";
        foreach ($this->events as $event) {
            $text .= $event->toString();
        }
        $text .= "<br>";

        return $text;
    }

    public function toArray()
    {

        $eventsArray = array();
        foreach ($this->events as $event) {

            array_push($eventsArray, $event->toArray());
        }

        return $eventsArray;
    }
}
