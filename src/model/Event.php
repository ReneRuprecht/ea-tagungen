<?php

class Event
{
    private $eventDate;
    private $timeslots = array();

    public function __construct($eventDate)
    {
        $this->eventDate = $eventDate;
    }

    public function geteventDate()
    {
        return $this->eventDate;
    }

    public function addTimeSlotEntry($timeslot)
    {
        array_push($this->timeslots, $timeslot);
    }

    public function toArray()
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
