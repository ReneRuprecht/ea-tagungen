<?php

class Event
{
    private $eventDate;
    private $timeslots = array();

    public function __construct($eventDate)
    {
        $this->eventDate = $eventDate;
    }

    public function getEventDate()
    {
        return $this->eventDate;
    }

    public function addTimeSlotEntry($timeslot)
    {
        array_push($this->timeslots, $timeslot);
    }

    public function buildTimeslotFromArray($timeslotArray)
    {
        foreach ($timeslotArray as $timeslot) {
            $createdTimeslot = new Timeslot($timeslot['startTime'], $timeslot['endTime'], $timeslot['eventName']);
            $createdTimeslot->buildSpeakerFromArray($timeslot['speaker']);
            $this->addTimeSlotEntry($createdTimeslot);
        }
    }

    public function toString()
    {
        $text = "<h1>" . $this->eventDate . "</h1>";

        foreach ($this->timeslots as $timeslot) {
            $text .= $timeslot->toString();
        }


        return $text;
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
