<?php
include_once('BaseModel.php');
/**
 * Timeslot model class to hold the data for a single timeslot
 * 
 * @author ReneRuprecht
 */
class Timeslot extends BaseModel
{
    /**
     * startTime contains the startTime of the timeslot
     *
     * @var [string]
     */
    private $startTime;

    /**
     * endTime contains the endTime of the timeslot
     *
     * @var [string]
     */
    private $endTime;

    /**
     * timeslotName containts the name of the timeslot
     *
     * @var [string]
     */
    private $timeslotName;

    /**
     * speaker contains the speaker of the timeslot as an array
     *
     * @var array
     */
    private $speaker = array();

    /**
     * constructor that creates the timeslot with its informations
     *
     * @param [string] $startTime
     * @param [string] $endTime
     * @param [string] $timeslotName
     */
    public function __construct($startTime, $endTime, $timeslotName)
    {
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->timeslotName = $timeslotName;
    }

    /**
     * TimeslotFromJson maps a timeslot from json to a timeslot object
     *
     * @param [json] $timeslotJson
     * @return Timeslot
     */
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

    /**
     * addSpeaker adds a speaker to the speaker array
     *
     * @param [Speaker] $speaker
     * @return void
     */
    public function addSpeaker($speaker): void
    {
        array_push($this->speaker, $speaker);
    }

    /**
     * toString 
     *
     * @return string formatted timeslot data
     */
    public function toString(): string
    {
        $text = "<p>";
        $text .= sprintf("%s - %s %s, ", $this->startTime, $this->endTime, $this->timeslotName);

        $text .= sprintf("%s", $this->speaker[0]->toString());

        if (count($this->speaker) > 0) {
            for ($i = 1; $i < count($this->speaker); $i++) {
                $text .= sprintf(", %s", $this->speaker[$i]->toString());

                // appends the speaker to the string
                if ($i == count($this->speaker) - 2) {
                    $text .= sprintf(" und %s", $this->speaker[$i]->toString());
                    break;
                }
            }
        }

        $text .= "</p>";
        return $text;
    }

    /**
     * toArray builds an array from the timeslot instance
     *
     * @return array timeslot as array
     */
    public function toArray(): array
    {

        /* 
        *a new array needs to be created because the fiels are private of the
        * speaker.
        */
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
