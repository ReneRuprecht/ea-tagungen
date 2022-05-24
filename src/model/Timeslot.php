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

    public function getAllSpeaker(): array
    {
        return $this->speaker;
    }
    public function addSpeaker($speaker): void
    {
        array_push($this->speaker, $speaker);
    }

    public static function TimeslotFromJson($timeslotJson): Timeslot
    {
        $timeslot =  new Timeslot($timeslotJson['startTime'], $timeslotJson['endTime'], $timeslotJson['eventName']);

        $speakerJson = $timeslotJson['speaker'];

        foreach ($speakerJson as $speaker) {
            $createdSpeaker = Speaker::SpeakerFromJson($speaker);
            $timeslot->addSpeaker($createdSpeaker);
        }

        return $timeslot;
    }

    public function toString(): string
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

    public function toArray(): array
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
