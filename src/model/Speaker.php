<?php

class Speaker
{
    public $title = "";
    public $firstname = "";
    public $surname = "";

    public function __construct($title, $firstname, $surname)
    {
        $this->title = $title;
        $this->firstname = $firstname;
        $this->surname = $surname;
    }

    public function toString(): string
    {
        $text = "";
        if ($this->title != "") {
            $text .= $this->title . " ";
        }
        return $text .= $this->firstname . " " . $this->surname;
    }
    public function toArray()
    {
        $array = array(
            "title" => $this->title,
            "firstname" => $this->firstname,
            "surname" => $this->surname
        );
        return $array;
    }
}
