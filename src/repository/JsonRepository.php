<?php
include_once('RepositoryInterface.php');

class JsonRepository implements RepositoryInterface
{
    private $logger;
    private $file;

    public function __construct($logger)
    {
        $this->logger = $logger;
    }

    public function connect($connectionString)
    {
        $this->file = $connectionString;

        $fileContent = $this->read();
        if ($fileContent == null || $fileContent == "") {
            file_put_contents($this->file, "[]");
        }

        $this->logger->log("conntected");
    }

    public function read()
    {

        if (!file_exists($this->file)) {
            $this->logger->log("file not found");
            return "";
        }

        $fileContent = file_get_contents($this->file);

        if ($fileContent == null) {
            return "";
        }

        $this->logger->log("read from repo");
        return $fileContent;
    }

    public function save($event)
    {

        $fileContent = $this->read();

        $fileJson = json_decode($fileContent, true);

        $found = false;
        foreach ($fileJson as $key => $value) {
            if ($value['eventDate'] == $event['eventDate']) {
                array_push($fileJson[$key]['timeslots'], $event['timeslots'][0]);
                $found = true;
                break;
            }
        }

        if (!$found) {
            array_push($fileJson, $event);
        }


        file_put_contents($this->file, json_encode($fileJson, JSON_PRETTY_PRINT));
        $this->logger->log("event saved");
    }

    public function findAllDates()
    {
        $dates = array();
        $fileContent = $this->read();
        $fileJson = json_decode($fileContent, true);

        foreach ($fileJson as $event) {
            array_push($dates, $event['eventDate']);
        }
        $this->logger->log("dates loaded");
        return $dates;
    }
}
