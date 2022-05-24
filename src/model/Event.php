<?php

class Event
{
    private $eventDate;
    private $timeslots = array();

    public function __construct($eventDate)
    {
        $this->eventDate = $eventDate;
    }

    public function getEventDate(): string
    {
        return $this->eventDate;
    }

    public function addTimeSlotEntry($timeslot): void
    {
        array_push($this->timeslots, $timeslot);
    }

    public static function EventFromJson($eventJson): Event
    {

        $event = new Event($eventJson['eventDate']);

        $timeslots = $eventJson['timeslots'];

        foreach ($timeslots as $timeslot) {
            $createdTimeslot = Timeslot::TimeslotFromJson($timeslot);
            $event->addTimeSlotEntry($createdTimeslot);
        }
        return $event;
    }

    public function toString(): string
    {
        $text = "<h1>" . $this->eventDate . "</h1>";

        foreach ($this->timeslots as $timeslot) {
            $text .= $timeslot->toString();
        }


        return $text;
    }

    public function toArray(): array
    {

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
