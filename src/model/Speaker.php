<?php
include_once('BaseModel.php');

/**
 * Speaker model class to hold the data for a single speaker
 */
class Speaker extends BaseModel
{

    /**
     * title contains the title of the speaker if there is one
     *
     * @var string
     */
    private $title = "";

    /**
     * surname contains the surname of the speaker
     *
     * @var string
     */

    private $surname = "";

    /**
     * constructor that creates the speaker with its informations
     *
     * @param [stirng] $title
     * @param [string] $surname
     */
    public function __construct($title, $surname)
    {
        $this->title = $title;
        $this->surname = $surname;
    }

    /**
     * speakerFromJson maps a speaker from json to a speaker object
     *
     * @param [json] $speakerJson
     * @return Speaker
     */
    public static function speakerFromJson($speakerJson): Speaker
    {
        return new Speaker($speakerJson['title'], $speakerJson['surname']);;
    }

    /**
     * toString 
     *
     * @return string formatted speaker data
     */
    public function toString(): string
    {
        $text = "";
        if ($this->title != "") {
            $text .= $this->title . " ";
        }
        return $text .= $this->surname;
    }

    /**
     * toArray builds an array from the speaker instance
     *
     * @return array speaker as array
     */
    public function toArray(): array
    {
        $array = array(
            "title" => $this->title,
            "surname" => $this->surname
        );
        return $array;
    }
}
