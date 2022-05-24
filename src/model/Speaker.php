<?php

class Speaker
{
    public $title = "";
    public $surname = "";

    public function __construct($title, $surname)
    {
        $this->title = $title;
        $this->surname = $surname;
    }

    public function toString(): string
    {
        $text = "";
        if ($this->title != "") {
            $text .= $this->title . " ";
        }
        return $text .= $this->surname;
    }

    public static function SpeakerFromJson($speakerJson): Speaker
    {
        return new Speaker($speakerJson['title'], $speakerJson['surname']);;
    }

    public function toArray(): array
    {
        $array = array(
            "title" => $this->title,
            "surname" => $this->surname
        );
        return $array;
    }
}
