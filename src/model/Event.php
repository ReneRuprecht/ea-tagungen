<?php
include_once('BaseModel.php');

/**
 * Event model class to hold the data for a single event
 */
class Event extends BaseModel
{
    /**
     * eventDate contains the date of the event
     *
     * @var [string]
     */
    private $eventDate;

    /**
     * timeslots contains all timeslots of the event
     *
     * @var array of single timeslots
     */
    private $timeslots = array();

    /**
     * constructor that creates an instance of an event
     *
     * @param [string] $eventDate
     */
    public function __construct($eventDate)
    {
        $this->eventDate = $eventDate;
    }

    /**
     * getEventDate returns the event date
     *
     * @return string event date text
     */
    public function getEventDate(): string
    {
        return $this->eventDate;
    }

    /**
     * addTimeSlotEntry adds a timeslot to the array
     *
     * @param [Timeslot] $timeslot
     * @return void
     */
    public function addTimeSlotEntry($timeslot): void
    {
        array_push($this->timeslots, $timeslot);
    }

    /**
     * eventFromJson maps an event from json to an event object
     *
     * @param [json] $eventJson
     * @return Event
     */
    public static function eventFromJson($eventJson): Event
    {

        $event = new Event($eventJson['eventDate']);

        $timeslots = $eventJson['timeslots'];

        foreach ($timeslots as $timeslot) {
            $createdTimeslot = Timeslot::TimeslotFromJson($timeslot);
            $event->addTimeSlotEntry($createdTimeslot);
        }
        return $event;
    }

    /**
     * toString
     *
     * @return string formatted event data
     */
    public function toString(): string
    {
        $text = "<h4>Veranstaltungen am " . $this->eventDate . "</h4>";

        foreach ($this->timeslots as $timeslot) {
            $text .= $timeslot->toString();
        }


        return $text;
    }

    /**
     * toArray builds an array from the event instance
     *
     * @return array single event as string
     */
    public function toArray(): array
    {

        /* 
        *a new array needs to be created because the fiels are private of the
        * timeslots.
        */

        $timeslotArray = array();

        foreach ($this->timeslots as $timeslot) {
            array_push($timeslotArray, $timeslot->toArray());
        }

        $array = array(
            "eventDate" => $this->eventDate,
            "timeslots" => $timeslotArray

        );

        return $array;
    }
}
