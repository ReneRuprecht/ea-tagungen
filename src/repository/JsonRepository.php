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

        $this->logger->log("conntected");
    }

    public function readFromRepository()
    {

        if (!file_exists($this->file)) {
            $this->logger->log("file not found");
            file_put_contents($this->file, "[]");
            return json_decode("[]", true);
        }

        $fileContent = file_get_contents($this->file);

        if ($fileContent == null || $fileContent == "") {
            file_put_contents($this->file, "[]");
            return json_decode("[]", true);
        }

        $this->logger->log("readFromRepository");
        return json_decode($fileContent, true);
    }

    public function saveSingleEvent($singleEventArray)
    {

        $fileJson = $this->readFromRepository();

        $timeslotExists = false;
        foreach ($fileJson as $key => $value) {
            if ($value['eventDate'] == $singleEventArray['eventDate']) {
                foreach ($singleEventArray['timeslots'] as $singleTimeSlot) {
                    array_push($fileJson[$key]['timeslots'], $singleTimeSlot);
                }
                $timeslotExists = true;
                break;
            }
        }

        if (!$timeslotExists) {
            array_push($fileJson, $singleEventArray);
        }

        file_put_contents($this->file, json_encode($fileJson, JSON_PRETTY_PRINT));

        $this->logger->log("event saved");
    }
}
