<?php
include_once('BaseModel.php');
/**
 * Events handles the whole single events
 * 
 * @author ReneRuprecht
 */
class Events extends BaseModel
{
    /**
     * events containts an array of the single event objects
     *
     * @var array
     */
    private $events = array();

    /**
     * addEvent, adds an event to the array
     *
     * @param [Event] $event
     * @return void
     */
    public function addEvent($event): void
    {
        array_push($this->events, $event);
    }

    /**
     * getEvents returns the array of the single events
     *
     * @return array array of single event
     */
    public function getEvents(): array
    {
        return $this->events;
    }

    /**
     * eventsFromJson builds all of the single events and the necessary parts
     * from the json content.. returns the finished events object
     *
     * @param [type] $eventJson
     * @return Events
     */
    public static function eventsFromJson($eventJson): Events
    {
        $events = new Events();

        foreach ($eventJson as $event) {

            $createdEvent = Event::EventFromJson($event);
            $events->addEvent($createdEvent);
        }
        return $events;
    }

    /**
     * toString
     *
     * @return string formatted events data
     */
    public function toString(): string
    {
        $text = "";

        foreach ($this->events as $event) {
            $text .= $event->toString();
        }
        $text .= "<br>";

        return $text;
    }

    /**
     * toArray builds an array from the event instance
     *
     * @return array events as array
     */
    public function toArray(): array
    {

        /* 
        *a new array needs to be created because the fiels are private of the
        * event.
        */
        $eventsArray = array();

        foreach ($this->events as $event) {

            array_push($eventsArray, $event->toArray());
        }

        return $eventsArray;
    }
}
