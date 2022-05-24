<?php
class Timeslot
{
    private $startTime;
    private $endTime;
    private $timeslotName;
    private $speaker = array();

    public function __construct($startTime, $endTime, $timeslotName)
    {
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->timeslotName = $timeslotName;
    }

    public function setSpeakerArray($speaker)
    {
        $this->speaker = $speaker;
    }

    public function getSpeaker()
    {
        return $this->speaker;
    }
    public function addSpeaker($speaker)
    {
        array_push($this->speaker, $speaker);
    }

    public function buildSpeakerFromArray($speakerArray)
    {
        foreach ($speakerArray as $speaker) {
            $createdSpeaker = new Speaker($speaker['title'], $speaker['firstname'], $speaker['surname']);
            array_push($this->speaker, $createdSpeaker);
        }
    }

    public function toString()
    {
        $text = "";
        $text .= sprintf("%s - %s %s, ", $this->startTime, $this->endTime, $this->timeslotName);

        for ($i = 0; $i < count($this->speaker); $i++) {
            $text .= sprintf("%s", $this->speaker[$i]->toString());

            if ($i != count($this->speaker) - 1) {
                $text .= " und ";
            }
        }
        $text .= "<br>";
        return $text;
    }

    public function toArray()
    {

        $speakerArray = array();
        foreach ($this->speaker as $speaker) {

            array_push($speakerArray, $speaker->toArray());
        }

        $array = array(
            "startTime" => $this->startTime,
            "endTime" => $this->endTime,
            "eventName" => $this->timeslotName,
            "speaker" => $speakerArray

        );

        return $array;
    }
}
